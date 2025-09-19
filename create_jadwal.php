<?php
include 'koneksi.php';

$response = array();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['tanggal']) && isset($_POST['waktu']) && isset($_POST['keterangan'])) {

        $tanggal = $_POST['tanggal'];
        $waktu = $_POST['waktu']; // Harus 'maghrib' atau 'isya'
        $keterangan = $_POST['keterangan'];

        // Validasi sederhana
        if ($waktu !== 'maghrib' && $waktu !== 'isya') {
             $response['status'] = 'error';
             $response['message'] = 'Waktu harus maghrib atau isya.';
        } else {
            $stmt = $koneksi->prepare("INSERT INTO jadwal_maulidan (tanggal, waktu, keterangan) VALUES (?, ?, ?)");
            // s = string, s = string, s = string
            $stmt->bind_param("sss", $tanggal, $waktu, $keterangan);

            if ($stmt->execute()) {
                $response['status'] = 'success';
                $response['message'] = 'Jadwal berhasil ditambahkan';
            } else {
                $response['status'] = 'error';
                $response['message'] = 'Gagal menyimpan jadwal: ' . $stmt->error;
            }
            $stmt->close();
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