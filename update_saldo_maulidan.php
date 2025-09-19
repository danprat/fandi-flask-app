<?php
include 'koneksi.php';
$response = array();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['penyesuaian_donasi_maulid'])) {
        $donasi = $_POST['penyesuaian_donasi_maulid'];

        $stmt = $koneksi->prepare("UPDATE saldo_rt SET penyesuaian_donasi_maulid = ? WHERE id = 1");
        $stmt->bind_param("i", $donasi);
        
        if ($stmt->execute()) {
            $stmt->close();
            include 'recalculate_saldo.php'; // Panggil penghitung ulang
            $response['status'] = 'success';
            $response['message'] = 'Saldo penyesuaian donasi berhasil diupdate';
        } else {
            $response['status'] = 'error';
            $response['message'] = 'Gagal mengupdate saldo';
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