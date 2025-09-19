<?php
include 'koneksi.php';

$sql = "SELECT total_kas, penyesuaian_kas, total_sosial, penyesuaian_sosial, total_donasi_maulid, penyesuaian_donasi_maulid, last_updated FROM saldo_rt WHERE id = 1";
$result = $koneksi->query($sql);

if ($result->num_rows > 0) {
    $response = $result->fetch_assoc();
} else {
    $response['status'] = 'error';
    $response['message'] = 'Data saldo tidak ditemukan.';
}

echo json_encode($response);
$koneksi->close();
?>