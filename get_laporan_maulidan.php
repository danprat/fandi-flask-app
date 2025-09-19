<?php
include 'koneksi.php';

// Ambil parameter filter, defaultnya 'harian'
$filter = isset($_GET['filter']) ? $_GET['filter'] : 'harian';

$sql_group_by = "";

// Tentukan cara pengelompokan berdasarkan filter
if ($filter === 'harian') {
    $sql_group_by = "DATE(d.tanggal_donasi)";
} elseif ($filter === 'bulanan') {
    // Format YYYY-MM
    $sql_group_by = "DATE_FORMAT(d.tanggal_donasi, '%Y-%m')";
} else {
    // Default ke harian jika filter tidak valid
    $sql_group_by = "DATE(d.tanggal_donasi)";
}

// Query utama untuk mengagregasi data
$sql = "SELECT 
            $sql_group_by as periode,
            SUM(d.jumlah) as total_donasi,
            COUNT(DISTINCT d.id_warga) as jumlah_warga,
            GROUP_CONCAT(DISTINCT w.nama_warga SEPARATOR ', ') as nama_warga_list
        FROM 
            donasi_maulidan d
        JOIN 
            warga w ON d.id_warga = w.id
        GROUP BY 
            periode
        ORDER BY 
            periode DESC";

$result = $koneksi->query($sql);

$laporan_list = array();
if ($result && $result->num_rows > 0) {
    while($row = $result->fetch_assoc()){
        $laporan_list[] = $row;
    }
}

echo json_encode($laporan_list);

$koneksi->close();

?>