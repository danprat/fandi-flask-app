<?php
echo "Mencoba memanggil Python dari PHP...<br>";

// Sesuaikan 'python' dengan path ke python.exe Anda jika perlu
$command = 'python python_scripts/tes.py';
$output = shell_exec($command);

if ($output) {
    echo "<strong>Hasil dari Python:</strong> " . htmlspecialchars($output);
} else {
    echo "<strong>GAGAL:</strong> PHP tidak bisa menjalankan script Python. Periksa konfigurasi server Anda.";
}
?>