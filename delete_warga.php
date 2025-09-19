<?php

include 'koneksi.php';

$response = array();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // Cek apakah ID dikirimkan
    if (isset($_POST['id']) && !empty($_POST['id'])) {
        $id = $_POST['id'];

        // Prepared statement untuk DELETE
        $stmt = $koneksi->prepare("DELETE FROM warga WHERE id = ?");
        $stmt->bind_param("i", $id); // "i" untuk integer

        if ($stmt->execute()) {
            if ($stmt->affected_rows > 0) {
                $response['status'] = 'success';
                $response['message'] = 'Data warga berhasil dihapus';
            } else {
                $response['status'] = 'error';
                $response['message'] = 'ID tidak ditemukan';
            }
        } else {
            $response['status'] = 'error';
            $response['message'] = 'Gagal menghapus data: ' . $stmt->error;
        }
        $stmt->close();

    } else {
        $response['status'] = 'error';
        $response['message'] = 'ID warga tidak boleh kosong';
    }
} else {
    $response['status'] = 'error';
    $response['message'] = 'Metode request tidak valid';
}

echo json_encode($response);
$koneksi->close();
?>