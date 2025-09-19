<?php
include 'koneksi.php';
$response = array();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['id'], $_POST['id_warga'], $_POST['jumlah'], $_POST['tanggal_donasi'])) {
        $id = $_POST['id'];
        $id_warga = $_POST['id_warga'];
        $jumlah = $_POST['jumlah'];
        $tanggal_donasi = $_POST['tanggal_donasi'];

        $stmt = $koneksi->prepare("UPDATE donasi_maulidan SET id_warga = ?, jumlah = ?, tanggal_donasi = ? WHERE id = ?");
        $stmt->bind_param("iisi", $id_warga, $jumlah, $tanggal_donasi, $id);

        if ($stmt->execute()) {
            $stmt->close();
            include 'recalculate_saldo.php'; // Panggil penghitung ulang saldo
            $response['status'] = 'success';
            $response['message'] = 'Donasi berhasil diupdate';
        } else {
            $response['status'] = 'error';
            $response['message'] = 'Gagal mengupdate donasi';
        }
    } else {
        $response['status'] = 'error';
        $response['message'] = 'Data tidak lengkap';
    }
} else {
    $response['status'] = 'error';
    $response['message'] = 'Metode request tidak valid';
}

echo json_encode($response);
$koneksi->close();
?>