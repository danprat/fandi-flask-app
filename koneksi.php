<?php

// Set header untuk memberitahu client bahwa responsnya adalah JSON
header('Content-Type: application/json');

// Detail koneksi database
$servername = "mysql"; // Server database, biasanya localhost
$username = "kampuspu_rt";        // Username default XAMPP/Laragon
$password = "dhM3YMtk%ADD]Za-";            // Password default XAMPP/Laragon adalah kosong
$dbname = "kampuspu_rt";         // Nama database yang kita buat tadi

// Membuat koneksi ke database
$koneksi = new mysqli($servername, $username, $password, $dbname);

// Cek koneksi
// Jika koneksi gagal, hentikan skrip dan tampilkan pesan error
if ($koneksi->connect_error) {
    // Buat array untuk respons error
    $error_response = [
        'status' => 'error',
        'message' => 'Koneksi ke database gagal: ' . $koneksi->connect_error
    ];
    // Encode array ke JSON dan kirim sebagai respons
    die(json_encode($error_response));
}

// Jika koneksi berhasil, file ini bisa di-include di file API lain
// Tidak perlu ada output 'sukses' di sini agar tidak mengganggu output JSON dari file lain

?>