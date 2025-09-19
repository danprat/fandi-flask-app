<?php
include 'koneksi.php';

$response = array();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['id']) && 
        isset($_POST['bayar_kas']) &&
        isset($_POST['bayar_arisan']) &&
        isset($_POST['jumlah_sosial'])) {

        $id_iuran = $_POST['id'];
        $bayar_kas = $_POST['bayar_kas'];
        $bayar_arisan = $_POST['bayar_arisan'];
        $jumlah_sosial = $_POST['jumlah_sosial'];

        // Langkah 1: Update iuran spesifik seperti biasa
        $stmt_update_iuran = $koneksi->prepare("UPDATE iuran_warga SET bayar_kas = ?, bayar_arisan = ?, jumlah_sosial = ? WHERE id = ?");
        $stmt_update_iuran->bind_param("iiii", $bayar_kas, $bayar_arisan, $jumlah_sosial, $id_iuran);

        if ($stmt_update_iuran->execute()) {
            $stmt_update_iuran->close();
            
            // Langkah 2: Panggil script penghitung ulang saldo
            include 'recalculate_saldo.php';
            
            $response['status'] = 'success';
            $response['message'] = 'Data iuran berhasil diupdate dan saldo telah disinkronkan';

        } else {
            $response['status'] = 'error';
            $response['message'] = 'Gagal mengupdate data iuran: ' . $stmt_update_iuran->error;
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