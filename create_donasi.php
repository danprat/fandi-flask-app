<?php
include 'koneksi.php';

$response = array();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['id_warga']) && isset($_POST['jumlah']) && isset($_POST['tanggal_donasi'])) {

        $id_warga = $_POST['id_warga'];
        $jumlah = $_POST['jumlah'];
        $tanggal_donasi = $_POST['tanggal_donasi'];

        if (empty($id_warga) || empty($jumlah) || empty($tanggal_donasi)) {
            $response['status'] = 'error';
            $response['message'] = 'Semua field wajib diisi.';
        } else {
            $stmt = $koneksi->prepare("INSERT INTO donasi_maulidan (id_warga, jumlah, tanggal_donasi) VALUES (?, ?, ?)");
            $stmt->bind_param("iis", $id_warga, $jumlah, $tanggal_donasi);

            if ($stmt->execute()) {
                $stmt->close();
                
                // PANGGIL SCRIPT PENGHITUNG ULANG SETELAH SUKSES
                include 'recalculate_saldo.php';
                
                $response['status'] = 'success';
                $response['message'] = 'Data donasi berhasil ditambahkan';
            } else {
                $response['status'] = 'error';
                $response['message'] = 'Gagal menyimpan donasi: ' . $stmt->error;
            }
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