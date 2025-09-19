<?php
include 'koneksi.php';

$sql = "SELECT id, tanggal, waktu, keterangan FROM jadwal_maulidan ORDER BY tanggal ASC";
$result = $koneksi->query($sql);

$jadwal = array();
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $jadwal[] = $row;
    }
}

echo json_encode($jadwal);
$koneksi->close();
?>