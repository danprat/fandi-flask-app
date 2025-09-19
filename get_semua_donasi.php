<?php

include 'koneksi.php';

$sql = "SELECT 
            d.id,
            d.tanggal_donasi,
            d.jumlah,
            w.nama_warga
        FROM 
            donasi_maulidan d
        JOIN 
            warga w ON d.id_warga = w.id
        ORDER BY 
            d.tanggal_donasi DESC, d.id DESC";

$result = $koneksi->query($sql);

$donasi_list = array();
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()){
        $donasi_list[] = $row;
    }
}

echo json_encode($donasi_list);

$koneksi->close();

?>