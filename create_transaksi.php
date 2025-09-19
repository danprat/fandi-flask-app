<?php
include 'koneksi.php';
$response = array();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['tanggal'], $_POST['jenis'], $_POST['jumlah'], $_POST['keterangan'])) {
        $tanggal = $_POST['tanggal'];
        $jenis = $_POST['jenis'];
        $jumlah = $_POST['jumlah'];
        $keterangan = $_POST['keterangan'];

        $stmt = $koneksi->prepare("INSERT INTO transaksi_umum (tanggal, jenis, jumlah, keterangan) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssis", $tanggal, $jenis, $jumlah, $keterangan);

        if ($stmt->execute()) {
            $response['status'] = 'success';
            $response['message'] = 'Transaksi berhasil disimpan';

            // Setelah berhasil, panggil logika update saldo
            include 'recalculate_saldo.php';

        } else {
            $response['status'] = 'error';
            $response['message'] = 'Gagal menyimpan transaksi';
        }
        $stmt->close();
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