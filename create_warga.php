<?php

// Panggil file koneksi untuk terhubung ke database
include 'koneksi.php';

// Siapkan array untuk respons JSON
$response = array();

// Cek apakah request yang datang adalah POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // Cek apakah 'nama_warga' dikirimkan
    if (isset($_POST['nama_warga']) && !empty($_POST['nama_warga'])) {
        
        $nama_warga = $_POST['nama_warga'];

        // Mencegah SQL Injection dengan Prepared Statements
        // Ini adalah langkah keamanan yang SANGAT PENTING
        $stmt = $koneksi->prepare("INSERT INTO warga (nama_warga) VALUES (?)");
        $stmt->bind_param("s", $nama_warga); // "s" berarti tipe datanya adalah string

        // Eksekusi statement
        if ($stmt->execute()) {
            $response['status'] = 'success';
            $response['message'] = 'Data warga berhasil ditambahkan';
        } else {
            $response['status'] = 'error';
            $response['message'] = 'Gagal menambahkan data warga: ' . $stmt->error;
        }
        $stmt->close();

    } else {
        // Jika nama_warga tidak dikirimkan
        $response['status'] = 'error';
        $response['message'] = 'Nama warga tidak boleh kosong';
    }
} else {
    // Jika request bukan POST
    $response['status'] = 'error';
    $response['message'] = 'Metode request tidak valid';
}

// Mengembalikan respons dalam format JSON
echo json_encode($response);

// Tutup koneksi
$koneksi->close();

?>