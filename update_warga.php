<?php

include 'koneksi.php';

$response = array();

// Cek jika metodenya adalah POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Cek apakah 'id' dan 'nama_warga' dikirimkan
    if (isset($_POST['id']) && isset($_POST['nama_warga'])) {
        
        $id = $_POST['id'];
        $nama_warga = $_POST['nama_warga'];

        // Validasi dasar agar tidak kosong
        if (!empty($id) && !empty($nama_warga)) {
            // Gunakan prepared statement untuk keamanan
            $stmt = $koneksi->prepare("UPDATE warga SET nama_warga = ? WHERE id = ?");
            // "si" -> s untuk string (nama_warga), i untuk integer (id)
            $stmt->bind_param("si", $nama_warga, $id);

            if ($stmt->execute()) {
                // Cek apakah ada baris yang terpengaruh (berhasil di-update)
                if ($stmt->affected_rows > 0) {
                    $response['status'] = 'success';
                    $response['message'] = 'Data warga berhasil diupdate';
                } else {
                    $response['status'] = 'error';
                    $response['message'] = 'Tidak ada data yang diupdate atau ID tidak ditemukan';
                }
            } else {
                $response['status'] = 'error';
                $response['message'] = 'Gagal mengeksekusi query: ' . $stmt->error;
            }
            $stmt->close();
        } else {
            $response['status'] = 'error';
            $response['message'] = 'ID dan Nama Warga tidak boleh kosong';
        }
    } else {
        $response['status'] = 'error';
        $response['message'] = 'Data yang diperlukan tidak lengkap';
    }
} else {
    $response['status'] = 'error';
    $response['message'] = 'Metode request tidak valid';
}

echo json_encode($response);
$koneksi->close();

?>