<?php
include 'koneksi.php';

$response = array();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['id']) &&
        isset($_POST['tanggal_pertemuan']) && 
        isset($_POST['id_warga_ketempatan']) && 
        isset($_POST['id_warga_pemenang']) &&
        isset($_POST['notulen'])) {

        $id = $_POST['id'];
        $tanggal = $_POST['tanggal_pertemuan'];
        $id_ketempatan = $_POST['id_warga_ketempatan'];
        $id_pemenang = $_POST['id_warga_pemenang'];
        $notulen = $_POST['notulen'];

        $stmt = $koneksi->prepare("UPDATE pertemuan SET tanggal_pertemuan = ?, id_warga_ketempatan = ?, id_warga_pemenang = ?, notulen = ? WHERE id = ?");
        // s = string, i = integer, i = integer, s = string, i = integer
        $stmt->bind_param("siisi", $tanggal, $id_ketempatan, $id_pemenang, $notulen, $id);

        if ($stmt->execute()) {
            $response['status'] = 'success';
            $response['message'] = 'Data pertemuan berhasil diupdate';
        } else {
            $response['status'] = 'error';
            $response['message'] = 'Gagal mengupdate data: ' . $stmt->error;
        }
        $stmt->close();
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