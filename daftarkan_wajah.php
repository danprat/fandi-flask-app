<?php
include 'koneksi.php';
$response = array();

// Tampilkan semua error untuk debugging
ini_set('display_errors', 1);
error_reporting(E_ALL);

if (isset($_POST['id_warga']) && isset($_FILES['image'])) {
    $id_warga = $_POST['id_warga'];
    $file = $_FILES['image'];

    $uploadDir = 'uploads/';
    $tempImagePath = $uploadDir . 'reg_' . time() . '_' . basename($file['name']);
    
    if (move_uploaded_file($file['tmp_name'], $tempImagePath)) {
        
        $pythonScript = 'python_scripts/generate_embedding.py';
        // Coba gunakan 'python3'. Tambahkan '2>&1' untuk menangkap pesan error.
        $command = 'python3 ' . escapeshellarg($pythonScript) . ' ' . escapeshellarg($tempImagePath) . ' 2>&1';

        $output = shell_exec($command);
        unlink($tempImagePath);

        $result = json_decode($output, true);

        // Cek apakah outputnya valid JSON dan punya status
        if ($result && isset($result['status'])) {
             if ($result['status'] === 'success') {
                $embeddingJson = json_encode($result['embedding']);
                $stmt = $koneksi->prepare("UPDATE warga SET face_embedding = ? WHERE id = ?");
                $stmt->bind_param("si", $embeddingJson, $id_warga);

                if ($stmt->execute()) {
                    $response['status'] = 'success';
                    $response['message'] = 'Wajah berhasil didaftarkan.';
                } else {
                    $response['status'] = 'error';
                    $response['message'] = 'Gagal menyimpan embedding ke DB.';
                }
                $stmt->close();
            } else {
                $response = $result; // Kirim pesan error dari Python ke Flutter
            }
        } else {
            // Jika output dari Python bukan JSON / kosong, tampilkan output mentahnya
            $response['status'] = 'error';
            $response['message'] = 'Terjadi error di script Python. Output: ' . htmlspecialchars($output);
        }

    } else {
        $response['status'] = 'error';
        $response['message'] = 'Gagal meng-upload gambar.';
    }
} else {
    $response['status'] = 'error';
    $response['message'] = 'Data tidak lengkap. ID Warga dan gambar dibutuhkan.';
}

echo json_encode($response);
$koneksi->close();
?>