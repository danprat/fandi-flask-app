<?php
include 'koneksi.php';

// Tentukan bulan yang akan difilter. Jika tidak ada, gunakan bulan saat ini.
// Formatnya YYYY-MM, contoh: 2025-09
$filter_bulan = isset($_GET['bulan']) ? $_GET['bulan'] : date('Y-m');

$response = array();

// 1. Ambil daftar transaksi HANYA untuk bulan yang dipilih
$stmt_list = $koneksi->prepare("SELECT id, tanggal, jenis, jumlah, keterangan FROM transaksi_umum WHERE DATE_FORMAT(tanggal, '%Y-%m') = ? ORDER BY tanggal DESC, id DESC");
$stmt_list->bind_param("s", $filter_bulan);
$stmt_list->execute();
$result_list = $stmt_list->get_result();

$transaksi_list = array();
while($row = $result_list->fetch_assoc()){
    $transaksi_list[] = $row;
}
$response['transaksi'] = $transaksi_list;


// 2. Hitung ringkasan (summary) HANYA untuk bulan yang dipilih
$stmt_summary = $koneksi->prepare("SELECT 
                                    SUM(CASE WHEN jenis = 'pemasukan' THEN jumlah ELSE 0 END) as total_pemasukan,
                                    SUM(CASE WHEN jenis = 'pengeluaran' THEN jumlah ELSE 0 END) as total_pengeluaran
                                  FROM transaksi_umum WHERE DATE_FORMAT(tanggal, '%Y-%m') = ?");
$stmt_summary->bind_param("s", $filter_bulan);
$stmt_summary->execute();
$result_summary = $stmt_summary->get_result();
$summary = $result_summary->fetch_assoc();
$response['summary'] = $summary;


// 3. Ambil total saldo kas KESELURUHAN saat ini untuk ditampilkan sebagai sisa saldo
$stmt_saldo = $koneksi->prepare("SELECT total_kas FROM saldo_rt WHERE id = 1");
$stmt_saldo->execute();
$result_saldo = $stmt_saldo->get_result();
$saldo = $result_saldo->fetch_assoc();
$response['sisa_saldo'] = $saldo['total_kas'];


echo json_encode($response);
$koneksi->close();

?>