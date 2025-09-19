<?php
include 'koneksi.php';
$response = array();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['id'])) {
        $id = $_POST['id'];

        $stmt = $koneksi->prepare("DELETE FROM jadwal_maulidan WHERE id = ?");
        $stmt->bind_param("i", $id);

        if ($stmt->execute() && $stmt->affected_rows > 0) {
            $stmt->close();
            include 'recalculate_saldo.php'; // Panggil penghitung ulang jika diperlukan
            $response['status'] = 'success';
            $response['message'] = 'Jadwal berhasil dihapus';
        } else {
            $response['status'] = 'error';
            $response['message'] = 'Gagal menghapus jadwal atau ID tidak ditemukan';
        }
    } else {
        $response['status'] = 'error';
        $response['message'] = 'ID tidak boleh kosong';
    }
} else {
    $response['status'] = 'error';
    $response['message'] = 'Metode request tidak valid';
}

echo json_encode($response);
$koneksi->close();
?>