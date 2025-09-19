<?php

include 'koneksi.php';

$response = array();

// Query untuk mengambil pertemuan terbaru dengan menggabungkan tabel warga
// p = pertemuan, wk = warga ketempatan, wp = warga pemenang
$sql = "SELECT 
            p.id,
            p.tanggal_pertemuan,
            p.notulen,
            p.id_warga_ketempatan,
            wk.nama_warga AS nama_ketempatan,
            p.id_warga_pemenang,
            wp.nama_warga AS nama_pemenang
        FROM 
            pertemuan p
        LEFT JOIN 
            warga wk ON p.id_warga_ketempatan = wk.id
        LEFT JOIN 
            warga wp ON p.id_warga_pemenang = wp.id
        ORDER BY 
            p.tanggal_pertemuan DESC 
        LIMIT 1";

$result = $koneksi->query($sql);

if ($result->num_rows > 0) {
    $response = $result->fetch_assoc();
} else {
    $response['status'] = 'error';
    $response['message'] = 'Belum ada data pertemuan';
}

echo json_encode($response);
$koneksi->close();

?>