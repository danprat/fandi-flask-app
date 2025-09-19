<?php
include 'koneksi.php';
$response = array();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['id'], $_POST['tanggal'], $_POST['waktu'], $_POST['keterangan'])) {
        $id = $_POST['id'];
        $tanggal = $_POST['tanggal'];
        $waktu = $_POST['waktu'];
        $keterangan = $_POST['keterangan'];

        $stmt = $koneksi->prepare("UPDATE jadwal_maulidan SET tanggal = ?, waktu = ?, keterangan = ? WHERE id = ?");
        $stmt->bind_param("sssi", $tanggal, $waktu, $keterangan, $id);

        if ($stmt->execute()) {
            $stmt->close();
            include 'recalculate_saldo.php'; // Panggil penghitung ulang jika diperlukan
            $response['status'] = 'success';
            $response['message'] = 'Jadwal berhasil diupdate';
        } else {
            $response['status'] = 'error';
            $response['message'] = 'Gagal mengupdate jadwal';
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