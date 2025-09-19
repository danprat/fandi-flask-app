<?php
include 'koneksi.php';
$response = array();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['id'], $_POST['tanggal'], $_POST['jenis'], $_POST['jumlah'], $_POST['keterangan'])) {
        $id = $_POST['id'];
        $tanggal = $_POST['tanggal'];
        $jenis = $_POST['jenis'];
        $jumlah = $_POST['jumlah'];
        $keterangan = $_POST['keterangan'];

        $stmt = $koneksi->prepare("UPDATE transaksi_umum SET tanggal = ?, jenis = ?, jumlah = ?, keterangan = ? WHERE id = ?");
        $stmt->bind_param("ssisi", $tanggal, $jenis, $jumlah, $keterangan, $id);

        if ($stmt->execute()) {
            $stmt->close();
            include 'recalculate_saldo.php'; // Panggil penghitung ulang saldo
            $response['status'] = 'success';
            $response['message'] = 'Transaksi berhasil diupdate';
        } else {
            $response['status'] = 'error';
            $response['message'] = 'Gagal mengupdate transaksi';
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