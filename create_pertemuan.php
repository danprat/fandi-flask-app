<?php

include 'koneksi.php';

$response = array();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Cek kelengkapan data yang dikirim
    if (isset($_POST['tanggal_pertemuan']) && 
        isset($_POST['id_warga_ketempatan']) && 
        isset($_POST['id_warga_pemenang']) &&
        isset($_POST['notulen'])) {

        $tanggal = $_POST['tanggal_pertemuan'];
        $id_ketempatan = $_POST['id_warga_ketempatan'];
        $id_pemenang = $_POST['id_warga_pemenang'];
        $notulen = $_POST['notulen'];

        // Validasi dasar
        if (empty($tanggal) || empty($id_ketempatan) || empty($id_pemenang)) {
            $response['status'] = 'error';
            $response['message'] = 'Tanggal, ketempatan, dan pemenang tidak boleh kosong.';
        } else {
            $stmt = $koneksi->prepare("INSERT INTO pertemuan (tanggal_pertemuan, id_warga_ketempatan, id_warga_pemenang, notulen) VALUES (?, ?, ?, ?)");
            // s = string, i = integer, i = integer, s = string
            $stmt->bind_param("siis", $tanggal, $id_ketempatan, $id_pemenang, $notulen);

            if ($stmt->execute()) {
                $response['status'] = 'success';
                $response['message'] = 'Data pertemuan berhasil ditambahkan';
            } else {
                $response['status'] = 'error';
                $response['message'] = 'Gagal menyimpan data pertemuan: ' . $stmt->error;
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