-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Sep 19, 2025 at 06:24 AM
-- Server version: 8.0.43-cll-lve
-- PHP Version: 8.4.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kampuspu_apirt06`
--

-- --------------------------------------------------------

--
-- Table structure for table `absensi`
--

CREATE TABLE `absensi` (
  `id` int NOT NULL,
  `id_pertemuan` int NOT NULL,
  `id_warga` int NOT NULL,
  `waktu_absen` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pembayaran`
--

CREATE TABLE `pembayaran` (
  `id` int NOT NULL,
  `pertemuan_id` int NOT NULL,
  `warga_id` int NOT NULL,
  `total_bayar` int NOT NULL,
  `jenis_transaksi` enum('iuran','manual') NOT NULL DEFAULT 'iuran',
  `rincian_arisan` int NOT NULL DEFAULT '0',
  `rincian_kas` int NOT NULL DEFAULT '0',
  `rincian_sosial` int NOT NULL DEFAULT '0',
  `rincian_infaq` int NOT NULL DEFAULT '0',
  `keterangan` varchar(255) DEFAULT NULL,
  `waktu_bayar` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `pembayaran`
--

INSERT INTO `pembayaran` (`id`, `pertemuan_id`, `warga_id`, `total_bayar`, `jenis_transaksi`, `rincian_arisan`, `rincian_kas`, `rincian_sosial`, `rincian_infaq`, `keterangan`, `waktu_bayar`) VALUES
(1, 1, 2, 15000, 'iuran', 8000, 2000, 2000, 3000, 'Iuran rutin Mega', '2025-08-16 07:27:14'),
(2, 1, 3, 20000, 'iuran', 8000, 7000, 2000, 3000, 'Iuran rutin Tarwo', '2025-08-16 07:27:14'),
(3, 1, 4, 15000, 'iuran', 8000, 2000, 2000, 3000, 'Iuran rutin Joko', '2025-08-16 07:27:14'),
(4, 1, 5, 15000, 'iuran', 8000, 2000, 2000, 3000, 'Iuran rutin Andi', '2025-08-16 07:27:14'),
(5, 1, 7, 10000, 'iuran', 0, 10000, 0, 0, 'Iuran rutin Untung', '2025-08-16 07:27:14'),
(6, 1, 8, 15000, 'iuran', 8000, 2000, 2000, 3000, 'Iuran rutin Mashruri', '2025-08-16 07:27:14'),
(7, 1, 10, 15000, 'iuran', 8000, 2000, 2000, 3000, 'Iuran rutin Dayat', '2025-08-16 07:27:14'),
(8, 1, 12, 15000, 'iuran', 8000, 2000, 2000, 3000, 'Iuran rutin Juned', '2025-08-16 07:27:14'),
(9, 1, 15, 15000, 'iuran', 8000, 2000, 2000, 3000, 'Iuran rutin Anto', '2025-08-16 07:27:14'),
(10, 1, 1, 50000, 'manual', 0, 50000, 0, 0, 'Sumbangan awal untuk kas', '2025-08-16 07:27:14'),
(11, 2, 2, 15000, 'iuran', 8000, 2000, 2000, 3000, 'Iuran rutin Mega', '2025-08-16 07:27:14'),
(12, 2, 4, 15000, 'iuran', 8000, 2000, 2000, 3000, 'Iuran rutin Joko', '2025-08-16 07:27:14'),
(13, 2, 6, 15000, 'iuran', 8000, 2000, 2000, 3000, 'Iuran rutin Fandi', '2025-08-16 07:27:14'),
(14, 2, 8, 15000, 'iuran', 8000, 2000, 2000, 3000, 'Iuran rutin Mashruri', '2025-08-16 07:27:14'),
(15, 2, 9, 25000, 'iuran', 8000, 12000, 2000, 3000, 'Iuran rutin Darso', '2025-08-16 07:27:14'),
(16, 2, 11, 15000, 'iuran', 8000, 2000, 2000, 3000, 'Iuran rutin Eri', '2025-08-16 07:27:14'),
(17, 2, 13, 15000, 'iuran', 8000, 2000, 2000, 3000, 'Iuran rutin Gabid', '2025-08-16 07:27:14'),
(18, 2, 14, 15000, 'iuran', 8000, 2000, 2000, 3000, 'Iuran rutin Ismangil', '2025-08-16 07:27:14'),
(19, 2, 16, 15000, 'iuran', 8000, 2000, 2000, 3000, 'Iuran rutin Lehan', '2025-08-16 07:27:14'),
(20, 2, 18, 15000, 'iuran', 8000, 2000, 2000, 3000, 'Iuran rutin Khotib', '2025-08-16 07:27:14'),
(21, 3, 3, 15000, 'iuran', 8000, 2000, 2000, 3000, 'Iuran rutin Tarwo', '2025-08-16 07:27:14'),
(22, 3, 5, 15000, 'iuran', 8000, 2000, 2000, 3000, 'Iuran rutin Andi', '2025-08-16 07:27:14'),
(23, 3, 7, 15000, 'iuran', 8000, 2000, 2000, 3000, 'Iuran rutin Untung', '2025-08-16 07:27:14'),
(24, 3, 9, 15000, 'iuran', 8000, 2000, 2000, 3000, 'Iuran rutin Darso', '2025-08-16 07:27:14'),
(25, 3, 11, 15000, 'iuran', 8000, 2000, 2000, 3000, 'Iuran rutin Eri', '2025-08-16 07:27:14'),
(26, 3, 17, 15000, 'iuran', 8000, 2000, 2000, 3000, 'Iuran rutin Sakir', '2025-08-16 07:27:14'),
(27, 3, 1, 75000, 'manual', 0, 0, 75000, 0, 'Donasi untuk dana sosial', '2025-08-16 07:27:14');

-- --------------------------------------------------------

--
-- Table structure for table `pengeluaran`
--

CREATE TABLE `pengeluaran` (
  `id` int NOT NULL,
  `tanggal` date NOT NULL,
  `jumlah` int NOT NULL,
  `diambil_dari` enum('kas','sosial','infaq') NOT NULL,
  `keterangan` varchar(255) NOT NULL,
  `dicatat_oleh` int NOT NULL COMMENT 'ID Admin yang mencatat',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `pengeluaran`
--

INSERT INTO `pengeluaran` (`id`, `tanggal`, `jumlah`, `diambil_dari`, `keterangan`, `dicatat_oleh`, `created_at`) VALUES
(1, '2025-07-28', 75000, 'kas', 'Beli spanduk dan bendera untuk 17an', 1, '2025-08-16 07:27:14'),
(2, '2025-08-05', 200000, 'sosial', 'Bantuan menjenguk Bpk. Sakir yang sakit', 1, '2025-08-16 07:27:14'),
(3, '2025-08-11', 150000, 'kas', 'Konsumsi rapat panitia 17 Agustus', 1, '2025-08-16 07:27:14');

-- --------------------------------------------------------

--
-- Table structure for table `pertemuan`
--

CREATE TABLE `pertemuan` (
  `id` int NOT NULL,
  `tanggal` date NOT NULL,
  `lokasi` varchar(255) NOT NULL,
  `notulen` text,
  `status` enum('selesai','akan_datang') NOT NULL DEFAULT 'akan_datang',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `pertemuan`
--

INSERT INTO `pertemuan` (`id`, `tanggal`, `lokasi`, `notulen`, `status`, `created_at`) VALUES
(1, '2025-07-26', 'Rumah Bpk. Joko', 'Membahas persiapan awal untuk acara 17 Agustus. Dibentuk panitia kecil.', 'selesai', '2025-08-16 07:27:14'),
(2, '2025-08-02', 'Rumah Bpk. Andi', 'Finalisasi konsep lomba 17 Agustus dan pembagian tugas panitia.', 'selesai', '2025-08-16 07:27:14'),
(3, '2025-08-09', 'Balai Warga', 'Evaluasi dana sosial dan rencana penyaluran bantuan.', 'selesai', '2025-08-16 07:27:14'),
(4, '2025-08-23', 'Rumah Bpk. Untung', 'Belum ada notulen.', 'akan_datang', '2025-08-16 07:27:14'),
(5, '2025-09-03', 'Bapak Untung', NULL, 'akan_datang', '2025-08-16 08:09:05'),
(6, '2025-09-03', 'Bapak Surip', NULL, 'akan_datang', '2025-08-16 23:45:50'),
(7, '2025-08-17', 'Bapak Salam', NULL, 'akan_datang', '2025-08-16 23:46:26');

-- --------------------------------------------------------

--
-- Table structure for table `warga`
--

CREATE TABLE `warga` (
  `id` int NOT NULL,
  `nama_lengkap` varchar(100) NOT NULL,
  `no_hp` varchar(15) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','warga') NOT NULL DEFAULT 'warga',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `face_embedding` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `warga`
--

INSERT INTO `warga` (`id`, `nama_lengkap`, `no_hp`, `password`, `role`, `created_at`, `face_embedding`) VALUES
(1, 'Admin Arisan', '081234567890', '$2y$10$tKxD3YZLWcZ/QhsqZ6srd.IWK0/uvdc9cITV5G8u8WfsFqsQpjH2m', 'admin', '2025-08-09 13:43:32', NULL),
(2, 'Mega', '081200000002', '$2y$10$i5f1PZ3C5E.E2L7m1xJp5e8XfR2.o6o.jI4zX.t8s.zG9q/s.K/2e', 'admin', '2025-08-16 07:27:14', NULL),
(3, 'Tarwo', '081200000003', '$2y$10$i5f1PZ3C5E.E2L7m1xJp5e8XfR2.o6o.jI4zX.t8s.zG9q/s.K/2e', 'admin', '2025-08-16 07:27:14', NULL),
(4, 'Joko', '081200000004', '$2y$10$i5f1PZ3C5E.E2L7m1xJp5e8XfR2.o6o.jI4zX.t8s.zG9q/s.K/2e', 'warga', '2025-08-16 07:27:14', NULL),
(5, 'Andi', '081200000005', '$2y$10$i5f1PZ3C5E.E2L7m1xJp5e8XfR2.o6o.jI4zX.t8s.zG9q/s.K/2e', 'admin', '2025-08-16 07:27:14', NULL),
(6, 'Fandi', '081200000006', '$2y$10$i5f1PZ3C5E.E2L7m1xJp5e8XfR2.o6o.jI4zX.t8s.zG9q/s.K/2e', 'admin', '2025-08-16 07:27:14', NULL),
(7, 'Untung', '081200000007', '$2y$10$i5f1PZ3C5E.E2L7m1xJp5e8XfR2.o6o.jI4zX.t8s.zG9q/s.K/2e', 'warga', '2025-08-16 07:27:14', NULL),
(8, 'Mashruri', '081200000008', '$2y$10$i5f1PZ3C5E.E2L7m1xJp5e8XfR2.o6o.jI4zX.t8s.zG9q/s.K/2e', 'warga', '2025-08-16 07:27:14', NULL),
(9, 'Darso', '081200000009', '$2y$10$i5f1PZ3C5E.E2L7m1xJp5e8XfR2.o6o.jI4zX.t8s.zG9q/s.K/2e', 'warga', '2025-08-16 07:27:14', NULL),
(10, 'Dayat', '081200000010', '$2y$10$i5f1PZ3C5E.E2L7m1xJp5e8XfR2.o6o.jI4zX.t8s.zG9q/s.K/2e', 'warga', '2025-08-16 07:27:14', NULL),
(11, 'Eri', '081200000011', '$2y$10$i5f1PZ3C5E.E2L7m1xJp5e8XfR2.o6o.jI4zX.t8s.zG9q/s.K/2e', 'warga', '2025-08-16 07:27:14', NULL),
(12, 'Juned', '081200000012', '$2y$10$i5f1PZ3C5E.E2L7m1xJp5e8XfR2.o6o.jI4zX.t8s.zG9q/s.K/2e', 'warga', '2025-08-16 07:27:14', NULL),
(13, 'Gabid', '081200000013', '$2y$10$i5f1PZ3C5E.E2L7m1xJp5e8XfR2.o6o.jI4zX.t8s.zG9q/s.K/2e', 'warga', '2025-08-16 07:27:14', NULL),
(14, 'Ismangil', '081200000014', '$2y$10$i5f1PZ3C5E.E2L7m1xJp5e8XfR2.o6o.jI4zX.t8s.zG9q/s.K/2e', 'warga', '2025-08-16 07:27:14', NULL),
(15, 'Anto', '081200000015', '$2y$10$i5f1PZ3C5E.E2L7m1xJp5e8XfR2.o6o.jI4zX.t8s.zG9q/s.K/2e', 'warga', '2025-08-16 07:27:14', NULL),
(16, 'Lehan', '081200000016', '$2y$10$i5f1PZ3C5E.E2L7m1xJp5e8XfR2.o6o.jI4zX.t8s.zG9q/s.K/2e', 'warga', '2025-08-16 07:27:14', NULL),
(17, 'Sakir', '081200000017', '$2y$10$i5f1PZ3C5E.E2L7m1xJp5e8XfR2.o6o.jI4zX.t8s.zG9q/s.K/2e', 'warga', '2025-08-16 07:27:14', NULL),
(18, 'Khotib', '081200000018', '$2y$10$i5f1PZ3C5E.E2L7m1xJp5e8XfR2.o6o.jI4zX.t8s.zG9q/s.K/2e', 'warga', '2025-08-16 07:27:14', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `absensi`
--
ALTER TABLE `absensi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_pertemuan` (`id_pertemuan`),
  ADD KEY `id_warga` (`id_warga`);

--
-- Indexes for table `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pertemuan_id` (`pertemuan_id`),
  ADD KEY `warga_id` (`warga_id`);

--
-- Indexes for table `pengeluaran`
--
ALTER TABLE `pengeluaran`
  ADD PRIMARY KEY (`id`),
  ADD KEY `dicatat_oleh` (`dicatat_oleh`);

--
-- Indexes for table `pertemuan`
--
ALTER TABLE `pertemuan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `warga`
--
ALTER TABLE `warga`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `no_hp` (`no_hp`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `absensi`
--
ALTER TABLE `absensi`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pembayaran`
--
ALTER TABLE `pembayaran`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `pengeluaran`
--
ALTER TABLE `pengeluaran`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `pertemuan`
--
ALTER TABLE `pertemuan`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `warga`
--
ALTER TABLE `warga`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `absensi`
--
ALTER TABLE `absensi`
  ADD CONSTRAINT `absensi_ibfk_1` FOREIGN KEY (`id_pertemuan`) REFERENCES `pertemuan` (`id`),
  ADD CONSTRAINT `absensi_ibfk_2` FOREIGN KEY (`id_warga`) REFERENCES `warga` (`id`);

--
-- Constraints for table `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD CONSTRAINT `pembayaran_ibfk_1` FOREIGN KEY (`pertemuan_id`) REFERENCES `pertemuan` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `pembayaran_ibfk_2` FOREIGN KEY (`warga_id`) REFERENCES `warga` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `pengeluaran`
--
ALTER TABLE `pengeluaran`
  ADD CONSTRAINT `pengeluaran_ibfk_1` FOREIGN KEY (`dicatat_oleh`) REFERENCES `warga` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
