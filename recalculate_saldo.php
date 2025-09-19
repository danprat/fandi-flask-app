<?php
// File ini tidak butuh koneksi sendiri, karena di-include oleh file lain
// yang sudah punya koneksi ($koneksi).

// --- KALKULASI TOTAL KAS ---
// Ambil total iuran kas
$sql_iuran_kas = "SELECT SUM(CASE WHEN bayar_kas = 1 THEN 2000 ELSE 0 END) as total_iuran_kas FROM iuran_warga";
$result_iuran_kas = $koneksi->query($sql_iuran_kas);
$total_iuran_kas = $result_iuran_kas->fetch_assoc()['total_iuran_kas'] ?? 0;

// Ambil total pemasukan dan pengeluaran dari transaksi umum
$sql_transaksi = "SELECT 
                    SUM(CASE WHEN jenis = 'pemasukan' THEN jumlah ELSE 0 END) as total_pemasukan,
                    SUM(CASE WHEN jenis = 'pengeluaran' THEN jumlah ELSE 0 END) as total_pengeluaran
                  FROM transaksi_umum";
$result_transaksi = $koneksi->query($sql_transaksi);
$transaksi = $result_transaksi->fetch_assoc();
$total_pemasukan = $transaksi['total_pemasukan'] ?? 0;
$total_pengeluaran = $transaksi['total_pengeluaran'] ?? 0;

// Ambil saldo penyesuaian kas
$sql_penyesuaian_kas = "SELECT penyesuaian_kas FROM saldo_rt WHERE id = 1";
$result_penyesuaian_kas = $koneksi->query($sql_penyesuaian_kas);
$penyesuaian_kas = $result_penyesuaian_kas->fetch_assoc()['penyesuaian_kas'] ?? 0;

// Hitung total kas akhir
$total_kas_baru = $penyesuaian_kas + $total_iuran_kas + $total_pemasukan - $total_pengeluaran;


// --- KALKULASI TOTAL SOSIAL ---
// Ambil total iuran sosial
$sql_iuran_sosial = "SELECT SUM(jumlah_sosial) as total_iuran_sosial FROM iuran_warga";
$result_iuran_sosial = $koneksi->query($sql_iuran_sosial);
$total_iuran_sosial = $result_iuran_sosial->fetch_assoc()['total_iuran_sosial'] ?? 0;

// Ambil saldo penyesuaian sosial
$sql_penyesuaian_sosial = "SELECT penyesuaian_sosial FROM saldo_rt WHERE id = 1";
$result_penyesuaian_sosial = $koneksi->query($sql_penyesuaian_sosial);
$penyesuaian_sosial = $result_penyesuaian_sosial->fetch_assoc()['penyesuaian_sosial'] ?? 0;

// Hitung total sosial akhir
$total_sosial_baru = $penyesuaian_sosial + $total_iuran_sosial;


// --- KALKULASI TOTAL DONASI MAULID ---
// Ambil total donasi dari tabel donasi_maulidan
$sql_donasi = "SELECT SUM(jumlah) as total_donasi FROM donasi_maulidan";
$result_donasi = $koneksi->query($sql_donasi);
$total_donasi = $result_donasi->fetch_assoc()['total_donasi'] ?? 0;

// Ambil saldo penyesuaian donasi
$sql_penyesuaian_donasi = "SELECT penyesuaian_donasi_maulid FROM saldo_rt WHERE id = 1";
$result_penyesuaian_donasi = $koneksi->query($sql_penyesuaian_donasi);
$penyesuaian_donasi = $result_penyesuaian_donasi->fetch_assoc()['penyesuaian_donasi_maulid'] ?? 0;

// Hitung total donasi akhir
$total_donasi_baru = $penyesuaian_donasi + $total_donasi;


// --- UPDATE DATABASE DENGAN SEMUA NILAI BARU ---
$stmt_update_saldo = $koneksi->prepare("UPDATE saldo_rt SET total_kas = ?, total_sosial = ?, total_donasi_maulid = ? WHERE id = 1");
$stmt_update_saldo->bind_param("iii", $total_kas_baru, $total_sosial_baru, $total_donasi_baru);
$stmt_update_saldo->execute();
$stmt_update_saldo->close();

?>