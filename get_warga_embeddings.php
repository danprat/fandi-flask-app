<?php
// Catatan: File ini sengaja tidak menggunakan keamanan API Key agar bisa diakses oleh
// script Python di server yang sama. Jika Python Anda di server berbeda, perlu strategi keamanan lain.
include 'koneksi.php';
header('Content-Type: application/json');

$result_warga = $koneksi->query("SELECT id, face_embedding FROM warga WHERE face_embedding IS NOT NULL");
$known_faces = array();
while($row = $result_warga->fetch_assoc()) {
    $embedding = json_decode($row['face_embedding'], true);
    if ($embedding) {
        $known_faces[] = [
            'id' => $row['id'],
            'face_embedding' => $embedding
        ];
    }
}

echo json_encode($known_faces);
$koneksi->close();
?>