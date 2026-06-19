-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 19, 2026 at 03:49 AM
-- Server version: 8.4.3
-- PHP Version: 8.3.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_uas_pbo_ti1d_indyayuramadhani`
--

-- --------------------------------------------------------

--
-- Table structure for table `tabel_mahasiswa`
--

CREATE TABLE `tabel_mahasiswa` (
  `id_mahasiswa` int NOT NULL,
  `nim` varchar(15) NOT NULL,
  `semester` int NOT NULL,
  `tarif_ukt_nominal` decimal(12,2) NOT NULL,
  `jenis_pembiayaan` enum('Mandiri','Bidikmisi','Prestasi') NOT NULL,
  `golongan_ukt` varchar(5) DEFAULT NULL,
  `nama_wali` varchar(100) DEFAULT NULL,
  `nomor_kip_kuliah` varchar(30) DEFAULT NULL,
  `dana_saku_subsidi` decimal(12,2) DEFAULT NULL,
  `nama_instansi_beasiswa` varchar(100) DEFAULT NULL,
  `minimal_ipk_syarat` decimal(3,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tabel_mahasiswa`
--

INSERT INTO `tabel_mahasiswa` (`id_mahasiswa`, `nim`, `semester`, `tarif_ukt_nominal`, `jenis_pembiayaan`, `golongan_ukt`, `nama_wali`, `nomor_kip_kuliah`, `dana_saku_subsidi`, `nama_instansi_beasiswa`, `minimal_ipk_syarat`) VALUES
(1, '202601001', 3, 5000000.00, 'Mandiri', 'Gol 4', 'Budi Santoso', NULL, NULL, NULL, NULL),
(2, '202601002', 5, 7500000.00, 'Mandiri', 'Gol 5', 'Siti Aminah', NULL, NULL, NULL, NULL),
(3, '202601003', 1, 3000000.00, 'Mandiri', 'Gol 2', 'Ahmad Subagjo', NULL, NULL, NULL, NULL),
(4, '202601004', 7, 5000000.00, 'Mandiri', 'Gol 4', 'Hendro Wijoyo', NULL, NULL, NULL, NULL),
(5, '202601005', 3, 10000000.00, 'Mandiri', 'Gol 7', 'Diana Putri', NULL, NULL, NULL, NULL),
(6, '202601006', 5, 7500000.00, 'Mandiri', 'Gol 5', 'Rudi Hermawan', NULL, NULL, NULL, NULL),
(7, '202601007', 1, 5000000.00, 'Mandiri', 'Gol 4', 'Slamet Riyadi', NULL, NULL, NULL, NULL),
(8, '202602001', 3, 0.00, 'Bidikmisi', NULL, NULL, 'KIP-2026-001', 950000.00, NULL, NULL),
(9, '202602002', 3, 0.00, 'Bidikmisi', NULL, NULL, 'KIP-2026-002', 950000.00, NULL, NULL),
(10, '202602003', 5, 0.00, 'Bidikmisi', NULL, NULL, 'KIP-2024-089', 1000000.00, NULL, NULL),
(11, '202602004', 5, 0.00, 'Bidikmisi', NULL, NULL, 'KIP-2024-112', 1000000.00, NULL, NULL),
(12, '202602005', 7, 0.00, 'Bidikmisi', NULL, NULL, 'KIP-2023-045', 1100000.00, NULL, NULL),
(13, '202602006', 1, 0.00, 'Bidikmisi', NULL, NULL, 'KIP-2026-105', 950000.00, NULL, NULL),
(14, '202602007', 1, 0.00, 'Bidikmisi', NULL, NULL, 'KIP-2026-204', 950000.00, NULL, NULL),
(15, '202603001', 3, 2500000.00, 'Prestasi', NULL, NULL, NULL, NULL, 'Djarum Foundation', 3.50),
(16, '202603002', 5, 0.00, 'Prestasi', NULL, NULL, NULL, NULL, 'Beasiswa Bank Indonesia', 3.25),
(17, '202603003', 5, 1500000.00, 'Prestasi', NULL, NULL, NULL, NULL, 'Tanoto Foundation', 3.40),
(18, '202603004', 7, 0.00, 'Prestasi', NULL, NULL, NULL, NULL, 'Beasiswa Unggulan Kemendikbud', 3.50),
(19, '202603005', 1, 2000000.00, 'Prestasi', NULL, NULL, NULL, NULL, 'PT Freeport Indonesia', 3.30),
(20, '202603006', 3, 0.00, 'Prestasi', NULL, NULL, NULL, NULL, 'Beasiswa Pemprov', 3.00);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tabel_mahasiswa`
--
ALTER TABLE `tabel_mahasiswa`
  ADD PRIMARY KEY (`id_mahasiswa`),
  ADD UNIQUE KEY `nim` (`nim`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tabel_mahasiswa`
--
ALTER TABLE `tabel_mahasiswa`
  MODIFY `id_mahasiswa` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
