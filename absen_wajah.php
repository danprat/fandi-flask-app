<?php
include 'koneksi.php';
$response = array();

if (isset($_POST['id_pertemuan']) && isset($_FILES['image'])) {
    $id_pertemuan = $_POST['id_pertemuan'];
    $file = $_FILES['image'];

    // --- Langkah 1: Siapkan data wajah yang sudah terdaftar ---
    $result_warga = $koneksi->query("SELECT id, face_embedding FROM warga WHERE face_embedding IS NOT NULL");
    $known_faces = array();
    while($row = $result_warga->fetch_assoc()) {
        $embedding = json_decode($row['face_embedding'], true);
        if ($embedding) { // Hanya proses jika embedding valid
            $known_faces[] = [
                'id' => $row['id'],
                'face_embedding' => $embedding
            ];
        }
    }

    // Tulis data wajah ke file JSON sementara
    $knownFacesJsonPath = 'uploads/known_faces.json';
    file_put_contents($knownFacesJsonPath, json_encode($known_faces));

    // --- Langkah 2: Proses gambar absensi yang baru masuk ---
    $uploadDir = 'uploads/';
    $tempImagePath = $uploadDir . 'absen_' . time() . '_' . basename($file['name']);

    if (move_uploaded_file($file['tmp_name'], $tempImagePath)) {

        // --- Langkah 3: Panggil script Python untuk mengenali wajah ---
        $pythonScript = 'python_scripts/recognize_face.py';
        $command = 'python ' . escapeshellarg($pythonScript) . ' ' . escapeshellarg($tempImagePath) . ' ' . escapeshellarg($knownFacesJsonPath);

        $output = shell_exec($command);
        $result = json_decode($output, true);

        // Hapus file-file sementara
        unlink($tempImagePath);
        unlink($knownFacesJsonPath);

        // --- Langkah 4: Proses hasil dari Python ---
        if ($result && $result['status'] === 'success') {
            $warga_id = $result['warga_id'];

            // Cek dulu apakah warga ini sudah absen di pertemuan ini
            $stmt_check = $koneksi->prepare("SELECT id FROM absensi WHERE id_pertemuan = ? AND id_warga = ?");
            $stmt_check->bind_param("ii", $id_pertemuan, $warga_id);
            $stmt_check->execute();
            $result_check = $stmt_check->get_result();

            if ($result_check->num_rows > 0) {
                 $response['status'] = 'error';
                 $response['message'] = 'Warga ini sudah melakukan absensi.';
            } else {
                // Simpan data absensi ke database
                $stmt_insert = $koneksi->prepare("INSERT INTO absensi (id_pertemuan, id_warga) VALUES (?, ?)");
                $stmt_insert->bind_param("ii", $id_pertemuan, $warga_id);
                $stmt_insert->execute();

                // Ambil nama warga untuk ditampilkan di Flutter
                $stmt_get_name = $koneksi->prepare("SELECT nama_warga FROM warga WHERE id = ?");
                $stmt_get_name->bind_param("i", $warga_id);
                $stmt_get_name->execute();
                $result_name = $stmt_get_name->get_result()->fetch_assoc();

                $response['status'] = 'success';
                $response['message'] = 'Absensi berhasil!';
                $response['nama_warga'] = $result_name['nama_warga'];
            }

        } else {
            // Jika Python gagal mengenali wajah
            $response = $result;
        }

    } else {
         $response['status'] = 'error';
         $response['message'] = 'Gagal meng-upload gambar absensi.';
    }
} else {
    $response['status'] = 'error';
    $response['message'] = 'Data tidak lengkap. ID Pertemuan dan gambar dibutuhkan.';
}

echo json_encode($response);
$koneksi->close();
?>