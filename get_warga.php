<?php

// Panggil file koneksi.php untuk menghubungkan ke database
include 'koneksi.php';

// Siapkan query SQL untuk mengambil semua data dari tabel warga
// Diurutkan berdasarkan nama warga A-Z
$sql = "SELECT id, nama_warga, status_aktif FROM warga ORDER BY nama_warga ASC";

// Eksekusi query
$result = $koneksi->query($sql);

// Siapkan array kosong untuk menampung data warga
$warga = array();

// Cek jika query menghasilkan data
if ($result->num_rows > 0) {
    // Looping untuk mengambil setiap baris data
    while($row = $result->fetch_assoc()) {
        // Masukkan data baris ke dalam array $warga
        $warga[] = $row;
    }
}

// Tampilkan data dalam format JSON
echo json_encode($warga);

// Tutup koneksi ke database
$koneksi->close();

?>