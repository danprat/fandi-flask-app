<?php
// Script untuk membuat hash baru yang 100% kompatibel dengan server Anda
$password_untuk_dihash = '12345';
$hash_baru = password_hash($password_untuk_dihash, PASSWORD_DEFAULT);

echo '<h3>Hash Baru untuk Password "12345"</h3>';
echo 'Silakan copy teks di bawah ini dan paste ke kolom password di phpMyAdmin untuk semua user:<br><br>';
echo '<strong style="font-size:1.1em; color:blue; word-wrap:break-word;">' . $hash_baru . '</strong>';
?>