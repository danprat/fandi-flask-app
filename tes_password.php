<?php

echo '<h2>Tes Fungsi password_verify()</h2>';
echo '<strong>Versi PHP Server Anda:</strong> ' . phpversion() . '<br><br>';

// --- DATA YANG AKAN KITA UJI ---

// Ini adalah password yang kita ketik di form
$password_dari_form = '12345';

// Ini adalah hash yang tersimpan di database Anda
$hash_dari_database = '$2y$10$sPQkkg0Ml55smKRW0Mab7.HtiTNzK0rQ6fZAXLONjQQHsuTdg9HOy';

echo '<strong>Password Input:</strong> ' . $password_dari_form . '<br>';
echo '<strong>Hash di Database:</strong> ' . $hash_dari_database . '<br><br>';
echo '<hr>';

// --- PROSES VERIFIKASI ---
if (password_verify($password_dari_form, $hash_dari_database)) {
    echo '<h1 style="color:green;">HASIL: BERHASIL!</h1>';
    echo 'Fungsi password_verify() bekerja dengan benar di server Anda. Hash cocok dengan password.';
} else {
    echo '<h1 style="color:red;">HASIL: GAGAL!</h1>';
    echo 'Fungsi password_verify() TIDAK COCOK. Ini berarti ada masalah kompatibilitas di server hosting Anda.';
}

?>