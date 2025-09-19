<?php
include 'koneksi.php';

$response = array();

// 1. Ambil Ringkasan Saldo Total (data ini sudah selalu up-to-date)
$result_saldo = $koneksi->query("SELECT total_kas, total_sosial, total_donasi_maulid FROM saldo_rt WHERE id = 1");
$response['saldo'] = $result_saldo->fetch_assoc();


// 2. Ambil Status Iuran Pertemuan Terkini
// Ambil dulu ID pertemuan terakhir
$result_pertemuan_terakhir = $koneksi->query("SELECT id FROM pertemuan ORDER BY tanggal_pertemuan DESC LIMIT 1");
if ($result_pertemuan_terakhir->num_rows > 0) {
    $id_pertemuan_terakhir = $result_pertemuan_terakhir->fetch_assoc()['id'];

    // Hitung status iuran untuk pertemuan tersebut
    $stmt_iuran = $koneksi->prepare("SELECT 
                                        COUNT(*) as total_warga,
                                        COUNT(CASE WHEN bayar_kas = 1 AND bayar_arisan = 1 THEN 1 END) as warga_lunas
                                    FROM iuran_warga 
                                    WHERE id_pertemuan = ?");
    $stmt_iuran->bind_param("i", $id_pertemuan_terakhir);
    $stmt_iuran->execute();
    $result_iuran = $stmt_iuran->get_result();
    $response['iuran_terkini'] = $result_iuran->fetch_assoc();
} else {
    $response['iuran_terkini'] = null; // Jika belum ada pertemuan sama sekali
}


// 3. Ambil Jadwal Penting Mendatang
// Ambil pertemuan berikutnya (yang tanggalnya >= hari ini)
$result_jadwal_pertemuan = $koneksi->query("SELECT p.tanggal_pertemuan, w.nama_warga as ketempatan FROM pertemuan p JOIN warga w ON p.id_warga_ketempatan = w.id WHERE p.tanggal_pertemuan >= CURDATE() ORDER BY p.tanggal_pertemuan ASC LIMIT 1");
$response['jadwal_pertemuan'] = $result_jadwal_pertemuan->fetch_assoc();

// Ambil jadwal maulid berikutnya
$result_jadwal_maulid = $koneksi->query("SELECT tanggal, keterangan FROM jadwal_maulidan WHERE tanggal >= CURDATE() ORDER BY tanggal ASC LIMIT 1");
$response['jadwal_maulid'] = $result_jadwal_maulid->fetch_assoc();


echo json_encode($response);
$koneksi->close();

?>