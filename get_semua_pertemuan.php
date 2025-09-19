<?php

include 'koneksi.php';

$response = array();

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
            p.tanggal_pertemuan DESC"; // Diurutkan dari yang paling baru

$result = $koneksi->query($sql);

$pertemuan_list = array();
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()){
        $pertemuan_list[] = $row;
    }
}

echo json_encode($pertemuan_list);

$koneksi->close();

?>