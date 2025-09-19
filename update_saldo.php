<?php
include 'koneksi.php';

$response = array();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Diubah agar sesuai dengan nama controller di Flutter
    if (isset($_POST['penyesuaian_kas']) && isset($_POST['penyesuaian_sosial'])) {
        $kas = $_POST['penyesuaian_kas'];
        $sosial = $_POST['penyesuaian_sosial'];

        $stmt = $koneksi->prepare("UPDATE saldo_rt SET penyesuaian_kas = ?, penyesuaian_sosial = ? WHERE id = 1");
        $stmt->bind_param("ii", $kas, $sosial);

        if ($stmt->execute()) {
            $response['status'] = 'success';
            $response['message'] = 'Saldo penyesuaian berhasil diupdate';
        } else {
            $response['status'] = 'error';
            $response['message'] = 'Gagal mengupdate saldo: ' . $stmt->error;
        }
        $stmt->close();
    } else {
        $response['status'] = 'error';
        $response['message'] = 'Data saldo tidak lengkap';
    }
} else {
    $response['status'] = 'error';
    $response['message'] = 'Metode request tidak valid';
}

echo json_encode($response);
$koneksi->close();
?>