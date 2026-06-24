-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.0.30 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for sisteminventaris
CREATE DATABASE IF NOT EXISTS `sisteminventaris` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `sisteminventaris`;

-- Dumping structure for table sisteminventaris.cache
CREATE TABLE IF NOT EXISTS `cache` (
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table sisteminventaris.cache: ~0 rows (approximately)
DELETE FROM `cache`;

-- Dumping structure for table sisteminventaris.cache_locks
CREATE TABLE IF NOT EXISTS `cache_locks` (
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_locks_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table sisteminventaris.cache_locks: ~0 rows (approximately)
DELETE FROM `cache_locks`;

-- Dumping structure for table sisteminventaris.failed_jobs
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table sisteminventaris.failed_jobs: ~0 rows (approximately)
DELETE FROM `failed_jobs`;

-- Dumping structure for table sisteminventaris.jobs
CREATE TABLE IF NOT EXISTS `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table sisteminventaris.jobs: ~0 rows (approximately)
DELETE FROM `jobs`;

-- Dumping structure for table sisteminventaris.job_batches
CREATE TABLE IF NOT EXISTS `job_batches` (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table sisteminventaris.job_batches: ~0 rows (approximately)
DELETE FROM `job_batches`;

-- Dumping structure for table sisteminventaris.kategori_perangkat
CREATE TABLE IF NOT EXISTS `kategori_perangkat` (
  `id_kategori` int NOT NULL AUTO_INCREMENT,
  `nama_kategori` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id_kategori`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table sisteminventaris.kategori_perangkat: ~15 rows (approximately)
DELETE FROM `kategori_perangkat`;
INSERT INTO `kategori_perangkat` (`id_kategori`, `nama_kategori`) VALUES
	(2, 'PC'),
	(3, 'Laptop'),
	(11, 'Printer / Scanner'),
	(12, 'Handphone'),
	(13, 'Mouse'),
	(14, 'Keyboard'),
	(15, 'Monitor'),
	(16, 'USB LAN'),
	(17, 'Switch Port Hub'),
	(18, 'USB Port'),
	(19, 'Finger Print'),
	(20, 'Web Cam'),
	(21, 'CD Room Ex'),
	(22, 'HDD External'),
	(23, 'Rabspery TV');

-- Dumping structure for table sisteminventaris.maintenance
CREATE TABLE IF NOT EXISTS `maintenance` (
  `id_maintenance` int NOT NULL AUTO_INCREMENT,
  `id_pengaduan_masuk` int DEFAULT NULL,
  `id_kategori` int DEFAULT NULL,
  `id_ruangan` int DEFAULT NULL,
  `nama_teknisi` varchar(50) DEFAULT NULL,
  `tanggal` datetime DEFAULT NULL,
  `deskripsi` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_maintenance`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table sisteminventaris.maintenance: ~3 rows (approximately)
DELETE FROM `maintenance`;
INSERT INTO `maintenance` (`id_maintenance`, `id_pengaduan_masuk`, `id_kategori`, `id_ruangan`, `nama_teknisi`, `tanggal`, `deskripsi`, `created_at`, `updated_at`) VALUES
	(1, 1, 2, 15, 'RIZAL', '2026-06-18 11:46:23', 'Ganti PSU baru', '2026-06-18 04:46:23', '2026-06-18 04:46:23'),
	(2, 2, 14, 16, 'RIZAL', '2026-06-18 11:56:41', 'Ganti keyboard baru', '2026-06-18 04:56:41', '2026-06-18 04:56:41'),
	(3, 3, 2, 16, 'RIZAL', '2026-06-18 20:14:15', NULL, '2026-06-18 13:14:15', '2026-06-18 13:14:15');

-- Dumping structure for table sisteminventaris.migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table sisteminventaris.migrations: ~0 rows (approximately)
DELETE FROM `migrations`;

-- Dumping structure for table sisteminventaris.notifikasi
CREATE TABLE IF NOT EXISTS `notifikasi` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_pengaduan` int DEFAULT NULL,
  `judul` varchar(50) DEFAULT NULL,
  `pesan` varchar(200) DEFAULT NULL,
  `is_read` int DEFAULT NULL,
  `type` varchar(50) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table sisteminventaris.notifikasi: ~0 rows (approximately)
DELETE FROM `notifikasi`;

-- Dumping structure for table sisteminventaris.password_reset_tokens
CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table sisteminventaris.password_reset_tokens: ~0 rows (approximately)
DELETE FROM `password_reset_tokens`;

-- Dumping structure for table sisteminventaris.pengaduan_masuk
CREATE TABLE IF NOT EXISTS `pengaduan_masuk` (
  `id_pengaduan_masuk` int NOT NULL AUTO_INCREMENT,
  `id_pengaduan` int DEFAULT NULL,
  `id_ruangan` int DEFAULT '0',
  `id_perangkat` int DEFAULT NULL,
  `id_kategori` int DEFAULT NULL,
  `nama_ruangan` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `kode_inventaris` varchar(50) DEFAULT NULL,
  `kategori_perangkat` varchar(50) DEFAULT NULL,
  `merek_perangkat` varchar(50) DEFAULT NULL,
  `deskripsi_masalah` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT '',
  `status` enum('Menunggu','Diterima','Pending','Diproses','Selesai') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `tanggal` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_pengaduan_masuk`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table sisteminventaris.pengaduan_masuk: ~3 rows (approximately)
DELETE FROM `pengaduan_masuk`;
INSERT INTO `pengaduan_masuk` (`id_pengaduan_masuk`, `id_pengaduan`, `id_ruangan`, `id_perangkat`, `id_kategori`, `nama_ruangan`, `kode_inventaris`, `kategori_perangkat`, `merek_perangkat`, `deskripsi_masalah`, `status`, `tanggal`, `created_at`, `updated_at`) VALUES
	(1, 1, 15, 114, 2, 'POLI PARU', 'MDN/MG/01.01/26/0015', 'PC', 'ASUS', 'pc matot', 'Selesai', '2026-06-18 11:46:23', '2026-06-18 04:46:23', '2026-06-18 04:46:23'),
	(2, 2, 16, 385, 14, 'POLI UROLOGI', 'MDN/MG/01.07/26/0016', 'Keyboard', 'LOGITECH', 'keyboard matot', 'Selesai', '2026-06-18 11:56:41', '2026-06-18 04:56:41', '2026-06-18 04:56:41'),
	(3, 3, 16, 383, 2, 'POLI UROLOGI', 'MDN/MG/01.01/26/0016', 'PC', 'ASUS', 'PC matot', 'Pending', '2026-06-18 20:14:15', '2026-06-18 13:14:15', '2026-06-18 13:14:15');

-- Dumping structure for table sisteminventaris.perangkat
CREATE TABLE IF NOT EXISTS `perangkat` (
  `id_perangkat` int NOT NULL AUTO_INCREMENT,
  `id_ruangan` int DEFAULT NULL,
  `id_kategori` int DEFAULT NULL,
  `kode_inventaris` varchar(50) DEFAULT NULL,
  `alamat_ip` varchar(50) DEFAULT NULL,
  `merek` varchar(50) DEFAULT NULL,
  `spesifikasi` varchar(500) DEFAULT NULL,
  `kondisi` enum('Baik','Rusak','Maintenance') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `tipe` varchar(500) DEFAULT NULL,
  `dipindahkan_oleh` varchar(50) DEFAULT NULL,
  `role_pemindah` varchar(50) DEFAULT NULL,
  `tanggal_pindah` datetime DEFAULT NULL,
  PRIMARY KEY (`id_perangkat`)
) ENGINE=InnoDB AUTO_INCREMENT=387 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table sisteminventaris.perangkat: ~374 rows (approximately)
DELETE FROM `perangkat`;
INSERT INTO `perangkat` (`id_perangkat`, `id_ruangan`, `id_kategori`, `kode_inventaris`, `alamat_ip`, `merek`, `spesifikasi`, `kondisi`, `tipe`, `dipindahkan_oleh`, `role_pemindah`, `tanggal_pindah`) VALUES
	(2, 5, 2, 'MDN/MG/01.01/26/0001', '192.168.1.11', 'SIMBADDA', 'WINDOWS 10 PRO\r\nADIMIIGD_INTEL CORE i3-4170\r\nRAM 8\r\n256', 'Baik', '-', NULL, NULL, NULL),
	(3, 5, 11, 'MDN/MG/01.02/26/0001', '-', 'EPSON', '-', 'Baik', 'L3210', NULL, NULL, NULL),
	(4, 5, 11, 'MDN/MG/01.02/26/0002', '-', 'FARGO', '-', 'Baik', 'C50', NULL, NULL, NULL),
	(7, 5, 11, 'MDN/MG/01.02/26/0003', '-', 'GPRINTER', '-', 'Baik', 'GP-1924D', NULL, NULL, NULL),
	(8, 5, 3, 'MDN/MG/01.03/26/0001', '-', 'ASUSVIVOBOOK', 'INTEL CORE i3-A140AZ', 'Baik', '-', NULL, NULL, NULL),
	(9, 5, 23, 'MDN/MG/01.05/26/0002', '-', 'LG', '43 INCH', 'Baik', '-', NULL, NULL, NULL),
	(10, 5, 13, 'MDN/MG/01.06/26/0001', '-', 'LOGITECH', '-', 'Baik', '-', NULL, NULL, NULL),
	(11, 5, 14, 'MDN/MG/01.07/26/0001', '-', 'LOGITECH', '-', 'Baik', '-', NULL, NULL, NULL),
	(12, 5, 15, 'MDN/MG/01.08/26/0001', '-', 'LOGITECH', '-', 'Baik', '-', NULL, NULL, NULL),
	(13, 5, 18, 'MDN/MG/01.11/26/0001', '-', 'LOGITECH', '-', 'Baik', '-', NULL, NULL, NULL),
	(14, 34, 2, 'MDN/MG/01.01/26/0036', '192.168.1.22/24', 'SIMBADDA', 'WINDOWS 10 PRO\r\nKASIR 2_INTEL CORE I3-4170\r\nRAM 8\r\n512', 'Baik', '-', NULL, NULL, NULL),
	(15, 5, 19, 'MDN/MG/01.12/26/0001', '-', 'HID 4500', '-', 'Baik', '-', NULL, NULL, NULL),
	(16, 34, 2, 'MDN/MG/01.01/26/0037', '192.168.1.21/24', 'ASUS', 'WINDOWS 10 PRO\r\nKASIR_INTEL CORE I3-1115G4\r\nRAM 8\r\n256', 'Baik', '-', NULL, NULL, NULL),
	(17, 34, 11, 'MDN/MG/01.02/26/0019', '-', 'EPSON', '-', 'Baik', 'L121', NULL, NULL, NULL),
	(18, 33, 2, 'MDN/MG/01.01/26/0033', '192.168.1.15', 'ASUS', 'WINDOWS 10\r\nADMISIRJ1_INTEL CORE i3-1215U\r\nRAM 8\r\n256', 'Baik', '-', NULL, NULL, NULL),
	(19, 33, 2, 'MDN/MG/01.01/26/0034', '192.168.1.13', 'ASUS', 'WINDOWS 10\r\nDESKTOP-G701FN0_INTEL CORE i3-1215U\r\nRAM 8\r\n256', 'Baik', '-', NULL, NULL, NULL),
	(20, 33, 2, 'MDN/MG/01.01/26/0035', '192.168.1.14', 'ASUS', 'WINDOWS 10\r\nDESKTOP-6E90CBL_INTEL CORE i3-1215U\r\nRAM 8\r\n256', 'Baik', '-', NULL, NULL, NULL),
	(21, 34, 13, 'MDN/MG/01.06/26/0037', '-', 'LOGITECH', '-', 'Baik', '-', NULL, NULL, NULL),
	(22, 34, 13, 'MDN/MG/01.06/26/0038', '-', 'LOGITECH', '-', 'Baik', '-', NULL, NULL, NULL),
	(23, 33, 11, 'MDN/MG/01.02/26/0017', '-', 'EPSON', '-', 'Baik', 'L3210', NULL, NULL, NULL),
	(24, 33, 11, 'MDN/MG/01.02/26/0018', '-', 'EPSON', '-', 'Baik', 'L121', NULL, NULL, NULL),
	(25, 34, 14, 'MDN/MG/01.07/26/0036', '-', 'LOGITECH', '-', 'Baik', '-', NULL, NULL, NULL),
	(26, 34, 14, 'MDN/MG/01.07/26/0037', '-', 'LOGITECH', '-', 'Baik', '-', NULL, NULL, NULL),
	(27, 33, 23, 'MDN/MG/01.05/26/0008', '-', 'LG', '43 INCH', 'Baik', '-', NULL, NULL, NULL),
	(28, 33, 13, 'MDN/MG/01.06/26/0034', '-', 'ASUS', NULL, 'Baik', '-', NULL, NULL, NULL),
	(29, 34, 15, 'MDN/MG/01.08/26/0037', '-', 'LG', '-', 'Baik', '-', NULL, NULL, NULL),
	(30, 34, 15, 'MDN/MG/01.08/26/0038', '-', 'LG', '-', 'Baik', '-', NULL, NULL, NULL),
	(31, 33, 13, 'MDN/MG/01.06/26/0035', '-', 'ASUS', '-', 'Baik', '-', NULL, NULL, NULL),
	(32, 33, 13, 'MDN/MG/01.06/26/0036', '-', 'ASUS', '-', 'Baik', '-', NULL, NULL, NULL),
	(33, 33, 14, 'MDN/MG/01.07/26/0033', '-', 'ASUS', '-', 'Baik', '-', NULL, NULL, NULL),
	(34, 33, 14, 'MDN/MG/01.07/26/0034', '-', 'ASUS', '-', 'Baik', '-', NULL, NULL, NULL),
	(39, 33, 14, 'MDN/MG/01.07/26/0035', '-', 'ASUS', '-', 'Baik', '-', NULL, NULL, NULL),
	(40, 6, 2, 'MDN/MG/01.01/26/0002', '192.168.1.19/24', 'SIMBADDA', 'WIINDOWS 10 PRO\r\nDESKTOP-RJP67IM-INTEL CORE i5-4590\r\nRAM 8\r\n256', 'Baik', '-', NULL, NULL, NULL),
	(41, 33, 15, 'MDN/MG/01.08/26/0034', '-', 'ASUS', NULL, 'Baik', '-', NULL, NULL, NULL),
	(42, 33, 15, 'MDN/MG/01.08/26/0035', '-', 'ASUS', NULL, 'Baik', '-', NULL, NULL, NULL),
	(43, 33, 15, 'MDN/MG/01.08/26/0036', '-', 'ASUS', NULL, 'Baik', '-', NULL, NULL, NULL),
	(44, 6, 11, 'MDN/MG/01.02/26/0004', '-', 'EPSON', '-', 'Baik', 'LX310', NULL, NULL, NULL),
	(45, 6, 13, 'MDN/MG/01.06/26/0002', '-', 'LOGITECH', '-', 'Baik', '-', NULL, NULL, NULL),
	(46, 10, 2, 'MDN/MG/01.01/26/0008', '192.168.1.25', 'SIMBADDA', 'WINDOWS 10 PRO\r\nFARMASI1_INTEL CORE i34170\r\nRAM 8\r\n256', 'Baik', '-', NULL, NULL, NULL),
	(47, 10, 2, 'MDN/MG/01.01/26/0009', '192.168.1.26', 'SIMBADDA', 'WINDOWS 10 PRO\r\nFARMASI2_INTEL CORE i3-4170\r\nRAM 8\r\n256', 'Baik', '-', NULL, NULL, NULL),
	(48, 10, 2, 'MDN/MG/01.01/26/0010', '192.168.1.27', 'SIMBADDA', 'WINDOWS 10 PRO\r\nDESKTOP-EVO71AH_INTEL CORE i3-4170\r\nRAM 8\r\n128', 'Baik', '-', NULL, NULL, NULL),
	(49, 10, 11, 'MDN/MG/01.02/26/0010', '-', 'EPSON', '-', 'Baik', 'L3210', NULL, NULL, NULL),
	(50, 10, 23, 'MDN/MG/01.05/26/0007', '-', 'LG', '43 INCH', 'Baik', '-', NULL, NULL, NULL),
	(51, 10, 13, 'MDN/MG/01.06/26/0008', '-', 'LOGITECH', '-', 'Baik', '-', NULL, NULL, NULL),
	(52, 10, 13, 'MDN/MG/01.06/26/0009', '-', 'LOGITECH', '-', 'Baik', '-', NULL, NULL, NULL),
	(53, 10, 13, 'MDN/MG/01.06/26/0010', '-', 'LOGITECH', '-', 'Baik', '-', NULL, NULL, NULL),
	(54, 10, 14, 'MDN/MG/01.07/26/0008', '-', 'LOGITECH', '-', 'Baik', '-', NULL, NULL, NULL),
	(55, 10, 14, 'MDN/MG/01.07/26/0009', '-', 'LOGITECH', '-', 'Baik', '-', NULL, NULL, NULL),
	(56, 10, 14, 'MDN/MG/01.07/26/0010', '-', 'LOGITECH', '-', 'Baik', '-', NULL, NULL, NULL),
	(57, 10, 15, 'MDN/MG/01.08/26/0008', '-', 'LG', NULL, 'Baik', '-', NULL, NULL, NULL),
	(58, 10, 15, 'MDN/MG/01.08/26/0009', '-', 'LG', NULL, 'Baik', '-', NULL, NULL, NULL),
	(59, 10, 15, 'MDN/MG/01.08/26/0010', '-', 'LG', NULL, 'Baik', '-', NULL, NULL, NULL),
	(60, 10, 17, 'MDN/MG/01.10/26/0001', '-', 'TP-LINK', NULL, 'Baik', '-', NULL, NULL, NULL),
	(61, 17, 2, 'MDN/MG/01.01/26/0017', '192.168.1.75', 'SIMBADDA', 'WINDOWS 10 PRO \r\nPOLIJIWA_INTEL CORE i3-4170 \r\nRAM 8\r\n512', 'Baik', '-', NULL, NULL, NULL),
	(62, 17, 13, 'MDN/MG/01.06/26/0017', '-', 'LOGITECH', NULL, 'Baik', '-', NULL, NULL, NULL),
	(63, 17, 14, 'MDN/MG/01.07/26/0017', '-', 'LOGITECH', NULL, 'Baik', '-', NULL, NULL, NULL),
	(64, 17, 15, 'MDN/MG/01.08/26/0017', '-', 'LG', NULL, 'Baik', '-', NULL, NULL, NULL),
	(65, 8, 2, 'MDN/MG/01.01/26/0004', '192.168.1.176', 'SIMBADDA', 'WINDOWS 10 PRO\r\nLAB1_INTEL CORE I3 4170\r\nRAM 8\r\n512', 'Baik', '-', NULL, NULL, NULL),
	(66, 8, 2, 'MDN/MG/01.01/26/0005', '192.168.1.175/24', 'SIMBADDA', 'WINDOWS 10 PRO\r\nLAB2_INTEL CORE i3-4170\r\nRAM 8\r\n512', 'Baik', '-', NULL, NULL, NULL),
	(67, 8, 11, 'MDN/MG/01.02/26/0006', '-', 'EPSON', NULL, 'Baik', 'L3210', NULL, NULL, NULL),
	(68, 8, 11, 'MDN/MG/01.02/26/0007', '-', 'EPSON', NULL, 'Baik', 'L121', NULL, NULL, NULL),
	(69, 10, 12, 'MDN/MG/01.04/26/0010', '-', 'REALME', 'ANDROID 15\r\nRMX3933\r\nRAM 4+2\r\n64', 'Baik', 'NOTE 60', NULL, NULL, NULL),
	(70, 8, 12, 'MDN/MG/01.04/26/0007', '-', 'VIVO', 'ANDROID 15\r\nV2310\r\nRAM 4+4\r\n128', 'Baik', 'Y17S', NULL, NULL, NULL),
	(71, 8, 13, 'MDN/MG/01.06/26/0004', '-', 'LOGITECH', NULL, 'Baik', '-', NULL, NULL, NULL),
	(72, 8, 13, 'MDN/MG/01.06/26/0005', '-', 'LOGITECH', NULL, 'Baik', '-', NULL, NULL, NULL),
	(73, 8, 14, 'MDN/MG/01.07/26/0004', '-', 'LOGITECH', NULL, 'Baik', '-', NULL, NULL, NULL),
	(74, 8, 14, 'MDN/MG/01.07/26/0005', '-', 'LOGITECH', NULL, 'Baik', '-', NULL, NULL, NULL),
	(75, 8, 15, 'MDN/MG/01.08/26/0004', '-', 'LG', NULL, 'Baik', '-', NULL, NULL, NULL),
	(76, 8, 15, 'MDN/MG/01.08/26/0005', '-', 'LG', NULL, 'Baik', '-', NULL, NULL, NULL),
	(77, 11, 2, 'MDN/MG/01.01/26/0011', '192.168.1.61', 'SIMBADDA', 'WINDOWS 10 PRO\r\nDESKTOP-I7QJK26_INTEL CORE i3-4170\r\nRAM 8\r\n128', 'Baik', '-', NULL, NULL, NULL),
	(78, 11, 11, 'MDN/MG/01.02/26/0011', '-', 'EPSON', NULL, 'Baik', 'L121', NULL, NULL, NULL),
	(79, 11, 23, 'MDN/MG/01.05/26/0002', '-', 'LG', '43 INCH', 'Baik', '-', NULL, NULL, NULL),
	(80, 11, 23, 'MDN/MG/01.05/26/0003', '-', 'LG', '43 INCH', 'Baik', '-', NULL, NULL, NULL),
	(81, 11, 23, 'MDN/MG/01.05/26/0004', '-', 'LG', '43 INCH', 'Baik', '-', NULL, NULL, NULL),
	(82, 11, 23, 'MDN/MG/01.05/26/0005', '-', 'LG', '43 INCH', 'Baik', '-', NULL, NULL, NULL),
	(83, 11, 13, 'MDN/MG/01.06/26/0011', '-', 'LOGITECH', NULL, 'Baik', '-', NULL, NULL, NULL),
	(84, 11, 14, 'MDN/MG/01.07/26/0011', '-', 'LOGITECH', NULL, 'Baik', '-', NULL, NULL, NULL),
	(85, 11, 15, 'MDN/MG/01.08/26/0011', '-', 'LG', NULL, 'Baik', '-', NULL, NULL, NULL),
	(86, 33, 20, 'MDN/MG/01.13/26/0001', '-', 'LOGITECH', NULL, 'Baik', '-', NULL, NULL, NULL),
	(87, 6, 14, 'MDN/MG/01.07/26/0002', '-', 'LOGITECH', '-', 'Baik', '-', NULL, NULL, NULL),
	(88, 18, 2, 'MDN/MG/01.01/26/0024', '192.168.1.79', 'SIMBADDA', 'WINDOWS 10 PRO\r\nPOLIBEDAHSYARAF_INTEL CORE i3-4170\r\nRAM 8\r\n512', 'Baik', '-', NULL, NULL, NULL),
	(90, 6, 15, 'MDN/MG/01.08/26/0002', '-', 'LG', '-', 'Baik', '-', NULL, NULL, NULL),
	(91, 7, 2, 'MDN/MG/01.01/26/0003', '192.168.1.23', 'SIMBADDA', 'WINDOWS 10 PRO\r\nIGD1_INTEL CORE i3-4170\r\nRAM 8\r\n512', 'Baik', '-', NULL, NULL, NULL),
	(92, 7, 11, 'MDN/MG/01.02/26/0005', '-', 'EPSON', '-', 'Baik', 'L3210', NULL, NULL, NULL),
	(94, 14, 2, 'MDN/MG/01.01/26/0014', '192.168.1.63', 'SIMBADDA', 'WINDOWS 10 PRO\r\nDESKTOP-TUD1R9E_INTEL CORE i3-4170\r\nRAM 8\r\n512', 'Baik', '-', NULL, NULL, NULL),
	(95, 20, 2, 'MDN/MG/01.01/26/0020', '192.168.1.81', 'ASUS', 'WINDOWS 11 PRO\r\nPOLIJANTUNG1_INTEL CORE i3-1115G4\r\nRAM 8\r\n256', 'Baik', '-', NULL, NULL, NULL),
	(96, 20, 13, 'MDN/MG/01.06/26/0020', '-', 'LOGITECH', NULL, 'Baik', '-', NULL, NULL, NULL),
	(97, 20, 14, 'MDN/MG/01.07/26/0020', '-', 'LOGITECH', NULL, 'Baik', '-', NULL, NULL, NULL),
	(98, 20, 15, 'MDN/MG/01.08/26/0020', '-', 'LG', NULL, 'Baik', '-', NULL, NULL, NULL),
	(99, 14, 13, 'MDN/MG/01.06/26/0014', '-', 'LOGITECH', NULL, 'Baik', '-', NULL, NULL, NULL),
	(100, 14, 14, 'MDN/MG/01.07/26/0014', '-', 'LOGITECH', NULL, 'Baik', '-', NULL, NULL, NULL),
	(101, 14, 15, 'MDN/MG/01.08/26/0014', '-', 'LG', NULL, 'Baik', '-', NULL, NULL, NULL),
	(102, 18, 13, 'MDN/MG/01.06/26/0024', '-', 'LOGITECH', NULL, 'Baik', '-', NULL, NULL, NULL),
	(103, 18, 14, 'MDN/MG/01.07/26/0024', '-', 'LOGITECH', NULL, 'Baik', '-', NULL, NULL, NULL),
	(104, 18, 15, 'MDN/MG/01.08/26/0024', '-', 'LG', NULL, 'Baik', '-', NULL, NULL, NULL),
	(105, 27, 2, 'MDN/MG/01.01/26/0027', '192.168.1.95/24', 'ASUS', 'WINDOWS 10 PRO\r\nPOLIOBGYN1_INTEL CORE i3-1115G4\r\nRAM 8\r\n256', 'Baik', '-', NULL, NULL, NULL),
	(106, 27, 13, 'MDN/MG/01.06/26/0027', '-', 'LOGITECH', NULL, 'Baik', '-', NULL, NULL, NULL),
	(107, 27, 14, 'MDN/MG/01.07/26/0027', '-', 'LOGITECH', NULL, 'Baik', '-', NULL, NULL, NULL),
	(108, 27, 15, 'MDN/MG/01.08/26/0027', '-', 'LG', NULL, 'Baik', '-', NULL, NULL, NULL),
	(109, 27, 16, 'MDN/MG/01.09/26/0003', '-', 'LOGITECH', NULL, 'Baik', '-', NULL, NULL, NULL),
	(110, 19, 2, 'MDN/MG/01.01/26/0019', '192.168.1.77', 'SIMBADDA', 'WINDOWS 10 PRO\r\nPOLIORTHOPEDI_INTEL CORE i3-4170\r\nRAM 4\r\n256', 'Baik', '-', NULL, NULL, NULL),
	(111, 19, 13, 'MDN/MG/01.06/26/0019', '-', 'LOGITECH', NULL, 'Baik', '-', NULL, NULL, NULL),
	(112, 19, 14, 'MDN/MG/01.07/26/0019', '-', 'LOGITECH', NULL, 'Baik', '-', NULL, NULL, NULL),
	(113, 19, 15, 'MDN/MG/01.08/26/0019', '-', 'LG', NULL, 'Baik', '-', NULL, NULL, NULL),
	(114, 15, 2, 'MDN/MG/01.01/26/0015', '192.168.1.69', 'ASUS', 'WINDOWS 11\r\nPOLIPARU1_INTEL CORE i3-1115G4\r\nRAM 8\r\n256', 'Baik', '-', NULL, NULL, NULL),
	(115, 15, 13, 'MDN/MG/01.06/26/0015', '-', 'LOGITECH', NULL, 'Baik', '-', NULL, NULL, NULL),
	(116, 7, 3, 'MDN/MG/01.03/26/0002', '-', 'HP', 'WINDOWS 11\r\nINTEL CORE 3 100U\r\nRAM 8\r\n512', 'Baik', '-', NULL, NULL, NULL),
	(117, 15, 14, 'MDN/MG/01.07/26/0015', '-', 'LOGITECH', NULL, 'Baik', '-', NULL, NULL, NULL),
	(118, 7, 3, 'MDN/MG/01.03/26/0003', '-', 'ASUS VIVOBOOK', 'WINDOWS 11\r\nINTEL CORE i3-1215U\r\nRAM 8\r\n256', 'Baik', '-', NULL, NULL, NULL),
	(119, 15, 15, 'MDN/MG/01.08/26/0015', '-', 'LG', NULL, 'Baik', '-', NULL, NULL, NULL),
	(120, 15, 11, 'MDN/MG/01.02/26/0012', '-', 'EPSON', NULL, 'Baik', 'L121', NULL, NULL, NULL),
	(121, 7, 13, 'MDN/MG/01.06/26/0003', '-', 'LOGITECH', '-', 'Baik', '-', NULL, NULL, NULL),
	(122, 7, 14, 'MDN/MG/01.07/26/0003', '-', 'LOGITECH', '-', 'Baik', '-', NULL, NULL, NULL),
	(123, 7, 15, 'MDN/MG/01.08/26/0003', '-', 'LG', NULL, 'Baik', '-', NULL, NULL, NULL),
	(124, 7, 16, 'MDN/MG/01.09/26/0001', '-', 'LOGITECH', NULL, 'Baik', '-', NULL, NULL, NULL),
	(125, 12, 2, 'MDN/MG/01.01/26/0013', '192.168.1.65', 'ASUS', 'WINDOWS 11\r\nPOLITHT1_INTEL CORE i3-1115G4\r\nRAM 8\r\n256', 'Baik', '-', NULL, NULL, NULL),
	(126, 12, 13, 'MDN/MG/01.06/26/0013', '-', 'LOGITECH', NULL, 'Baik', '-', NULL, NULL, NULL),
	(127, 12, 14, 'MDN/MG/01.07/26/0013', '-', 'LOGITECH', NULL, 'Baik', '-', NULL, NULL, NULL),
	(128, 12, 15, 'MDN/MG/01.08/26/0013', '-', 'LG', NULL, 'Baik', '-', NULL, NULL, NULL),
	(129, 9, 2, 'MDN/MG/01.01/26/0007', '192.168.1.180', 'SIMBADDA', 'WINDOWS 10 PRO\r\nRADIOLOGI 1_INTEL CORE I3-4170\r\nRAM 16\r\nSSD 512', 'Baik', '-', NULL, NULL, NULL),
	(130, 9, 2, 'MDN/MG/01.01/26/0006', '192.168.1.179', 'DAZUMBA', 'WINDOWS 10PRO\r\nDEKSTOP-3926TKU_INTEL CORE I3-4150\r\nRAM 8\r\n512', 'Baik', '-', NULL, NULL, NULL),
	(131, 9, 11, 'MDN/MG/01.02/26/0008', '-', 'HP', NULL, 'Baik', 'COLOR LASER JET PRO M454DW', NULL, NULL, NULL),
	(132, 9, 11, 'MDN/MG/01.02/26/0009', '-', 'EPSON', NULL, 'Baik', 'L3210', NULL, NULL, NULL),
	(133, 9, 13, 'MDN/MG/01.06/26/0007', '-', 'LOGITECH', NULL, 'Baik', '-', NULL, NULL, NULL),
	(134, 9, 13, 'MDN/MG/01.06/26/0006', '-', 'LOGITECH', NULL, 'Baik', '-', NULL, NULL, NULL),
	(135, 9, 14, 'MDN/MG/01.07/26/0007', '-', 'LOGITECH', NULL, 'Baik', '-', NULL, NULL, NULL),
	(136, 9, 14, 'MDN/MG/01.07/26/0006', '-', 'SILENT KB1000', NULL, 'Baik', '-', NULL, NULL, NULL),
	(137, 9, 15, 'MDN/MG/01.08/26/0007', '-', 'LG', NULL, 'Baik', '-', NULL, NULL, NULL),
	(138, 9, 15, 'MDN/MG/01.08/26/0006', '-', 'LG', NULL, 'Baik', '-', NULL, NULL, NULL),
	(139, 9, 12, 'MDN/MG/01.04/26/0011', '-', 'REALME', 'ANDROID 14\r\nRMX3933\r\nRAM 4\r\n64', 'Baik', 'NOTE 60', NULL, NULL, NULL),
	(140, 9, 21, 'MDN/MG/01.14/26/0001', '-', 'DELL', NULL, 'Baik', '-', NULL, NULL, NULL),
	(141, 9, 22, 'MDN/MG/01.15/26/0001', '-', 'SEAGETA EXPANSION', '2TB', 'Baik', '-', NULL, NULL, NULL),
	(142, 36, 3, 'MDN/MG/01.03/26/0012', '-', 'HP', 'WINDOWS 10\r\nINTEL CORE 100U\r\nRAM 8\r\n512', 'Baik', '-', NULL, NULL, NULL),
	(143, 36, 13, 'MDN/MG/01.06/26/0032', '-', 'LOGITECH', NULL, 'Baik', '-', NULL, NULL, NULL),
	(144, 36, 15, 'MDN/MG/01.08/26/0032', '-', 'VIEWSONIC', NULL, 'Baik', '-', NULL, NULL, NULL),
	(145, 36, 16, 'MDN/MG/01.09/26/0005', '-', 'LOGITECH', NULL, 'Baik', '-', NULL, NULL, NULL),
	(146, 36, 18, 'MDN/MG/01.11/26/0002', '-', 'ROBOT', NULL, 'Baik', '-', NULL, NULL, NULL),
	(147, 36, 19, 'MDN/MG/01.11/26/0002', '-', 'HID 4500', NULL, 'Baik', '-', NULL, NULL, NULL),
	(148, 32, 2, 'MDN/MG/01.01/26/0038', '192.168.1.36', 'SIMBADDA', 'WINDOWS 10 PRO\r\nREKAMEDIS1 INTEL CORE I3-4170\r\nRAM 8\r\n512', 'Baik', '-', NULL, NULL, NULL),
	(149, 32, 2, 'MDN/MG/01.01/26/0039', '192.168.1.37', 'SIMBADDA', 'WINDOWS 10 PRO \r\nREKAMEDIS2 INTEL CORE I3-4170\r\nRAM 8\r\n512', 'Baik', '-', NULL, NULL, NULL),
	(150, 32, 2, 'MDN/MG/01.01/26/0040', '192.168.1.38', 'SIMBADDA', 'WINDOWS 10 PRO\r\nRM3 INTELCORE I3-4160\r\nRAM 8\r\n512', 'Baik', '-', NULL, NULL, NULL),
	(151, 32, 2, 'MDN/MG/01.01/26/0041', '192.168.1.45', 'SIMBADDA', 'WINDOWS 10 PRO \r\nKLAIM4 INTEL CORE I3-4170\r\nRAM 8\r\n512', 'Baik', '-', NULL, NULL, NULL),
	(152, 32, 2, 'MDN/MG/01.01/26/0042', '192.168.1.46', '3POWER UP', 'WINDOWS 10\r\nDEKSTOP-MOUD3CV\r\nRAM 8\r\n128', 'Baik', '-', NULL, NULL, NULL),
	(153, 32, 2, 'MDN/MG/01.01/26/0043', '192.168.1.40', 'SIMBADDA', 'WINDOWS 10 PRO\r\nKLAIM 1 INTEL CORE 13-4170\r\nRAM 8\r\n512', 'Baik', '-', NULL, NULL, NULL),
	(154, 32, 2, 'MDN/MG/01.01/26/0044', '192.168.1.41', 'SIMBADDA', 'WINDOWS 10 PRO\r\nKLAIM2 INTEL CORE 13-4170\r\nRAM 8\r\n512', 'Baik', '-', NULL, NULL, NULL),
	(155, 32, 2, 'MDN/MG/01.01/26/0045', '192.168.1.42', '3POWER UP', 'WINDOWS 10 \r\nDEKSTOP-JCVVIM INTEL CORE 15-4590\r\nRAM 8\r\n128', 'Baik', '-', NULL, NULL, NULL),
	(156, 32, 2, 'MDN/MG/01.01/26/0046', '192.168.1.43', 'SIMBADDA', 'WINDOWS 10 PR\r\nKLAIM6 INTEL CORE I3-4170\r\nRAM 8\r\n512', 'Baik', '-', NULL, NULL, NULL),
	(157, 32, 2, 'MDN/MG/01.01/26/0047', '192.168.1.44', 'SIMBADDA', 'WINDOWS 10 PRO\r\nKLAIM3\r\nRAM 8\r\n128', 'Baik', '-', NULL, NULL, NULL),
	(158, 32, 11, 'MDN/MG/01.02/26/0020', '-', 'EPSON', NULL, 'Baik', 'L3210', NULL, NULL, NULL),
	(159, 32, 11, 'MDN/MG/01.02/26/0021', '-', 'BROTHER', NULL, 'Baik', 'ADS-1200', NULL, NULL, NULL),
	(160, 32, 11, 'MDN/MG/01.02/26/0022', '-', 'BROTHER', NULL, 'Baik', 'ADS 1300', NULL, NULL, NULL),
	(161, 32, 11, 'MDN/MG/01.02/26/0023', '-', 'BROTHER', NULL, 'Baik', 'ADS-1200', NULL, NULL, NULL),
	(162, 32, 13, 'MDN/MG/01.06/26/0039', '-', 'LOGITECH', NULL, 'Baik', '-', NULL, NULL, NULL),
	(163, 32, 13, 'MDN/MG/01.06/26/0040', '-', 'LOGITECH', NULL, 'Baik', '-', NULL, NULL, NULL),
	(164, 32, 13, 'MDN/MG/01.06/26/0041', '-', 'LOGITECH', NULL, 'Baik', '-', NULL, NULL, NULL),
	(165, 32, 13, 'MDN/MG/01.06/26/0042', '-', 'LOGITECH', NULL, 'Baik', '-', NULL, NULL, NULL),
	(166, 32, 13, 'MDN/MG/01.06/26/0043', '-', 'LOGITECH', NULL, 'Baik', '-', NULL, NULL, NULL),
	(167, 32, 13, 'MDN/MG/01.06/26/0044', '-', 'LOGITECH', NULL, 'Baik', '-', NULL, NULL, NULL),
	(168, 32, 13, 'MDN/MG/01.06/26/0045', '-', 'LOGITECH', NULL, 'Baik', '-', NULL, NULL, NULL),
	(169, 32, 13, 'MDN/MG/01.06/26/0046', '-', 'LOGITECH', NULL, 'Baik', '-', NULL, NULL, NULL),
	(170, 32, 13, 'MDN/MG/01.06/26/0047', '-', 'LOGITECH', NULL, 'Baik', '-', NULL, NULL, NULL),
	(171, 41, 2, 'MDN/MG/01.01/26/0068', '192.168.1.137/24', 'SIMBADDA', 'WINDOWS 10 PRO\r\nICU1 INTEL CORE I3-4170\r\nRAM 4\r\n256', 'Baik', '-', NULL, NULL, NULL),
	(172, 32, 13, 'MDN/MG/01.06/26/0048', '-', 'LOGITECH', NULL, 'Baik', '-', NULL, NULL, NULL),
	(173, 41, 2, 'MDN/MG/01.01/26/0069', '192.168.1.138/24', 'SIMBADDA', 'WINDOWS 10 PRO\r\nICU2 INTEL CORE I3-12100 \r\nRAM 8\r\n256', 'Baik', '-', NULL, NULL, NULL),
	(174, 41, 11, 'MDN/MG/01.02/26/0029', '-', 'EPSON', '-', 'Baik', 'L121', NULL, NULL, NULL),
	(175, 32, 14, 'MDN/MG/01.07/26/0038', '-', 'LOGITECH', NULL, 'Baik', '-', NULL, NULL, NULL),
	(176, 32, 14, 'MDN/MG/01.07/26/0039', '-', 'LOGITECH', NULL, 'Baik', '-', NULL, NULL, NULL),
	(177, 32, 14, 'MDN/MG/01.07/26/0040', '-', 'LOGITECH', NULL, 'Baik', '-', NULL, NULL, NULL),
	(178, 32, 14, 'MDN/MG/01.07/26/0041', '-', 'LOGITECH', NULL, 'Baik', '-', NULL, NULL, NULL),
	(179, 32, 14, 'MDN/MG/01.07/26/0042', '-', 'LOGITECH', NULL, 'Baik', '-', NULL, NULL, NULL),
	(180, 41, 3, 'MDN/MG/01.03/26/0013', '-', 'HP', 'WINDOWS 11\r\nDESKTOP-PO5LMH2_INTEL CORE 3 100U\r\nRAM 8 \r\n512', 'Baik', '14-ep/14s', NULL, NULL, NULL),
	(181, 41, 12, 'MDN/MG/01.04/26/0012', '-', 'VIVO', 'ANDROID 15\r\nY2310\r\nRAM 4\r\n128', 'Baik', 'Y17', NULL, NULL, NULL),
	(182, 41, 13, 'MDN/MG/01.06/26/0069', '-', 'LOGITECH', '-', 'Baik', '-', NULL, NULL, NULL),
	(183, 41, 13, 'MDN/MG/01.06/26/0070', '-', 'LOGITECH', '-', 'Baik', '-', NULL, NULL, NULL),
	(184, 41, 14, 'MDN/MG/01.07/26/0068', '-', 'LOGITECH', '-', 'Baik', '-', NULL, NULL, NULL),
	(185, 41, 14, 'MDN/MG/01.07/26/0069', '-', 'LOGITECH', '-', 'Baik', '-', NULL, NULL, NULL),
	(186, 41, 15, 'MDN/MG/01.08/26/0069', '-', 'LG', '-', 'Baik', '-', NULL, NULL, NULL),
	(187, 41, 15, 'MDN/MG/01.08/26/0070', '-', 'LG', '-', 'Baik', '-', NULL, NULL, NULL),
	(188, 41, 17, 'MDN/MG/01.10/26/0009', '-', 'TP LINK', '-', 'Baik', '-', NULL, NULL, NULL),
	(189, 47, 2, 'MDN/MG/01.01/26/0075', '192.168.1.172/24', 'SIMBADDA', 'WINDOWS 10 PRO\r\nMS1_INTEL CORE i3-4170\r\nRAM 4\r\n256', 'Baik', '-', NULL, NULL, NULL),
	(190, 47, 11, 'MDN/MG/01.02/26/0034', '-', 'EPSON', '-', 'Baik', 'L121', NULL, NULL, NULL),
	(191, 47, 3, 'MDN/MG/01.03/26/0011', '-', 'ASUS VIVOBOOK', 'WINDOWS 11\r\nINTEL CORE i3-1215U\r\nRAM 8\r\n256', 'Baik', '(A1404ZA-IPS321)', NULL, NULL, NULL),
	(192, 47, 12, 'MDN/MG/01.04/26/0009', '-', 'VIVO', 'ANDROID 15\r\nV2310\r\nRAM 4+4\r\n128', 'Baik', 'Y17', NULL, NULL, NULL),
	(193, 47, 13, 'MDN/MG/01.06/26/0076', '-', 'LOGITECH', NULL, 'Baik', '-', NULL, NULL, NULL),
	(194, 47, 14, 'MDN/MG/01.07/26/0075', '-', 'LOGITECH', NULL, 'Baik', '-', NULL, NULL, NULL),
	(195, 47, 15, 'MDN/MG/01.08/26/0076', '-', 'LG', NULL, 'Baik', '-', NULL, NULL, NULL),
	(196, 13, 2, 'MDN/MG/01.01/26/0012', '192.168.1.67', 'ASUS', 'WINDOWS 11 PRO\r\nPOLIMATA1_INTEL CORE i3-1115G4\r\nRAM 8\r\n256', 'Baik', '-', NULL, NULL, NULL),
	(197, 13, 11, 'MDN/MG/01.02/26/0013', '-', 'EPSON', '-', 'Baik', 'L3210', NULL, NULL, NULL),
	(198, 13, 13, 'MDN/MG/01.06/26/0012', '-', 'LOGITECH', '-', 'Baik', '-', NULL, NULL, NULL),
	(199, 13, 14, 'MDN/MG/01.07/26/0012', '-', 'LOGITECH', '-', 'Baik', '-', NULL, NULL, NULL),
	(200, 13, 15, 'MDN/MG/01.08/26/0012', '-', 'LG', '-', 'Baik', '-', NULL, NULL, NULL),
	(201, 39, 2, 'MDN/MG/01.01/26/0054', '192.168.1.154', 'SIMBADDA', 'WINDOWS 10 PRO\r\nTU1_INTEL CORE i3-4170\r\nRAM 8\r\n512', 'Baik', '-', NULL, NULL, NULL),
	(202, 39, 2, 'MDN/MG/01.01/26/0055', '192.168.1.149/24', 'SIMBADDA', 'WINDOWS 10 PRO\r\nTU-NINDYA_INTEL CORE i3-4170\r\nRAM 8\r\n512', 'Baik', '-', NULL, NULL, NULL),
	(203, 39, 2, 'MDN/MG/01.01/26/0056', '192.168.1.151/24', 'SIMBADDA', 'WINDOWS 10 PRO\r\nKABAGKABID1_INTEL CORE i3-4170\r\nRAM 8\r\n512', 'Baik', '-', NULL, NULL, NULL),
	(204, 39, 2, 'MDN/MG/01.01/26/0057', '192.168.1.156/24', 'SIMBADDA', 'WINDOWS 10 PRO \r\nHUMASAMEL_INTEL CORE i3-4170\r\nRAM 8\r\n512', 'Baik', '-', NULL, NULL, NULL),
	(205, 39, 2, 'MDN/MG/01.01/26/0058', '192.168.1.159/24', 'SIMBADDA', 'WINDOWS 10 PRO\r\nKABAGKABID2_INTEL CORE i3-4170\r\nRAM 4\r\n256', 'Baik', '-', NULL, NULL, NULL),
	(206, 39, 2, 'MDN/MG/01.01/26/0059', '192.168.1.157/24', 'SIMBADDA', 'WINDOWS 10 PRO\r\nKABAGKABID3_INTEL CORE i3-4170\r\nRAM 8\r\n512', 'Baik', '-', NULL, NULL, NULL),
	(207, 39, 2, 'MDN/MG/01.01/26/0060', '192.168.1.155', 'CUBEGAMING', 'WINDOWS 11 PRO\r\nDESKTOP-TTQQ3NB_INTEL CORE i5-12400F\r\nRAM 16\r\n512\r\n1 TB', 'Baik', '-', NULL, NULL, NULL),
	(208, 39, 2, 'MDN/MG/01.01/26/0061', '192.168.1.148/24', 'SIMBADDA', 'WINDOWS 10 PRO \r\nSEVASDM_INTEL CORE i3-4170\r\nRAM 8\r\n512', 'Baik', '-', NULL, NULL, NULL),
	(209, 39, 2, 'MDN/MG/01.01/26/0062', '169.254.167.87/16', 'SIMBADDA', 'WINDOWS 10 PRO\r\nSDM1_INTEL CORE i3-4170\r\nRAM 8\r\n256', 'Baik', '-', NULL, NULL, NULL),
	(210, 39, 2, 'MDN/MG/01.01/26/0063', '192.168.56.1/24', 'SIMBADDA', 'WINDOWS 10 PRO\r\nIT4_INTEL CORE i3-4170\r\nRAM 8\r\n512', 'Baik', '-', NULL, NULL, NULL),
	(211, 39, 2, 'MDN/MG/01.01/26/0064', '192.168.1.143/24', 'SIMBADDA', 'WINDOWS 10 PRO\r\nIT1_INTEL CORE i3-10105\r\nRAM 8\r\n256', 'Baik', '-', NULL, NULL, NULL),
	(212, 39, 2, 'MDN/MG/01.01/26/0065', '192.168.1.145/24', 'SIMBADDA', 'WINDOWS 10 PRO\r\nDESKTOP-4M075VH_INTEL CORE i3-10105\r\nRAM 8\r\n256', 'Baik', '-', NULL, NULL, NULL),
	(213, 39, 2, 'MDN/MG/01.01/26/0066', '192.168.1.146/24', 'SIMBADDA', 'WINDOWS 10 PRO\r\nKABAGKABID4-HAFIS_INTEL CORE i3-4170\r\nRAM 8\r\n256', 'Baik', '-', NULL, NULL, NULL),
	(214, 39, 2, 'MDN/MG/01.01/26/0067', '192.168.1.144/24', 'SIMBADDA', 'WINDOWS 10 PRO\r\nIT3_INTEL CORE i3-4160\r\nRAM 8\r\n256', 'Baik', '-', NULL, NULL, NULL),
	(215, 39, 11, 'MDN/MG/01.02/26/0027', '-', 'EPSON', '-', 'Baik', 'L3210', NULL, NULL, NULL),
	(216, 39, 11, 'MDN/MG/01.02/26/0028', '-', 'EPSON', '-', 'Baik', 'L121', NULL, NULL, NULL),
	(217, 39, 3, 'MDN/MG/01.03/26/0015', '-', 'HP', 'WINDOWS 11\r\nINTEL CORE 3 100U\r\nRAM 8', 'Baik', '-', NULL, NULL, NULL),
	(218, 39, 3, 'MDN/MG/01.03/26/0016', '-', 'LENOVO', 'WINDOWS 11\r\nINTEL CORE i5-13420H\r\nRAM 16\r\n512', 'Baik', '-', NULL, NULL, NULL),
	(219, 39, 3, 'MDN/MG/01.03/26/0017', '-', 'HP', 'WINDOWS 11\r\nINTEL CORE i3-1115G4\r\nRAM 8\r\n512', 'Baik', '-', NULL, NULL, NULL),
	(220, 39, 13, 'MDN/MG/01.06/26/0055', '-', 'LOGITECH', '-', 'Baik', '-', NULL, NULL, NULL),
	(221, 39, 13, 'MDN/MG/01.06/26/0056', '-', 'ROBOT', '-', 'Baik', '-', NULL, NULL, NULL),
	(222, 39, 13, 'MDN/MG/01.06/26/0057', '-', 'LOGITECH', '-', 'Baik', '-', NULL, NULL, NULL),
	(223, 39, 13, 'MDN/MG/01.06/26/0058', '-', 'LOGITECH', '-', 'Baik', '-', NULL, NULL, NULL),
	(224, 39, 13, 'MDN/MG/01.06/26/0059', '-', 'LOGITECH', '-', 'Baik', '-', NULL, NULL, NULL),
	(225, 39, 13, 'MDN/MG/01.06/26/0060', '-', 'LOGITECH', '-', 'Baik', '-', NULL, NULL, NULL),
	(226, 39, 13, 'MDN/MG/01.06/26/0061', '-', 'LOGITECH', '-', 'Baik', '-', NULL, NULL, NULL),
	(227, 39, 13, 'MDN/MG/01.06/26/0062', '-', 'LOGITECH', '-', 'Baik', '-', NULL, NULL, NULL),
	(228, 39, 13, 'MDN/MG/01.06/26/0063', '-', 'LOGITECH', '-', 'Baik', '-', NULL, NULL, NULL),
	(229, 39, 13, 'MDN/MG/01.06/26/0064', '-', 'LOGITECH', '-', 'Baik', '-', NULL, NULL, NULL),
	(230, 39, 13, 'MDN/MG/01.06/26/0065', '-', 'LOGITECH', '-', 'Baik', '-', NULL, NULL, NULL),
	(231, 39, 13, 'MDN/MG/01.06/26/0066', '-', 'LOGITECH', '-', 'Baik', '-', NULL, NULL, NULL),
	(232, 39, 13, 'MDN/MG/01.06/26/0067', '-', 'LOGITECH', '-', 'Baik', '-', NULL, NULL, NULL),
	(233, 39, 13, 'MDN/MG/01.06/26/0068', '-', 'LOGITECH', '-', 'Baik', '-', NULL, NULL, NULL),
	(234, 39, 14, 'MDN/MG/01.07/26/0054', '-', 'LOGITECH', '-', 'Baik', '-', NULL, NULL, NULL),
	(235, 39, 14, 'MDN/MG/01.07/26/0055', '-', 'LOGITECH', '-', 'Baik', '-', NULL, NULL, NULL),
	(236, 39, 14, 'MDN/MG/01.07/26/0057', '-', 'LOGITECH', '-', 'Baik', '-', NULL, NULL, NULL),
	(237, 39, 14, 'MDN/MG/01.07/26/0058', '-', 'LOGITECH', '-', 'Baik', '-', NULL, NULL, NULL),
	(238, 39, 14, 'MDN/MG/01.07/26/0059', '-', 'LOGITECH', '-', 'Baik', '-', NULL, NULL, NULL),
	(239, 39, 14, 'MDN/MG/01.07/26/0060', '-', 'LOGITECH', '-', 'Baik', '-', NULL, NULL, NULL),
	(240, 39, 14, 'MDN/MG/01.07/26/0061', '-', 'LOGITECH', '-', 'Baik', '-', NULL, NULL, NULL),
	(241, 39, 14, 'MDN/MG/01.07/26/0062', '-', 'LOGITECH', '-', 'Baik', '-', NULL, NULL, NULL),
	(242, 39, 14, 'MDN/MG/01.07/26/0063', '-', 'LOGITECH', '-', 'Baik', '-', NULL, NULL, NULL),
	(243, 39, 14, 'MDN/MG/01.07/26/0064', '-', 'LOGITECH', '-', 'Baik', '-', NULL, NULL, NULL),
	(244, 39, 14, 'MDN/MG/01.07/26/0065', '-', 'LOGITECH', '-', 'Baik', '-', NULL, NULL, NULL),
	(245, 39, 14, 'MDN/MG/01.07/26/0066', '-', 'LOGITECH', '-', 'Baik', '-', NULL, NULL, NULL),
	(246, 39, 14, 'MDN/MG/01.07/26/0067', '-', 'LOGITECH', '-', 'Baik', '-', NULL, NULL, NULL),
	(247, 39, 15, 'MDN/MG/01.08/26/0055', '-', 'LG', '-', 'Baik', '-', NULL, NULL, NULL),
	(248, 39, 15, 'MDN/MG/01.08/26/0056', '-', 'LG', '-', 'Baik', '-', NULL, NULL, NULL),
	(249, 39, 15, 'MDN/MG/01.08/26/0057', '-', 'LG', '-', 'Baik', '-', NULL, NULL, NULL),
	(250, 39, 15, 'MDN/MG/01.08/26/0058', '-', 'LG', '-', 'Baik', '-', NULL, NULL, NULL),
	(251, 39, 15, 'MDN/MG/01.08/26/0059', '-', 'LG', '-', 'Baik', '-', NULL, NULL, NULL),
	(252, 39, 15, 'MDN/MG/01.08/26/0060', '-', 'LG', '-', 'Baik', '-', NULL, NULL, NULL),
	(253, 39, 15, 'MDN/MG/01.08/26/0061', '-', 'LG', '-', 'Baik', '-', NULL, NULL, NULL),
	(254, 39, 15, 'MDN/MG/01.08/26/0062', '-', 'LG', '-', 'Baik', '-', NULL, NULL, NULL),
	(255, 39, 15, 'MDN/MG/01.08/26/0063', '-', 'LG', '-', 'Baik', '-', NULL, NULL, NULL),
	(256, 39, 15, 'MDN/MG/01.08/26/0064', '-', 'LG', '-', 'Baik', '-', NULL, NULL, NULL),
	(257, 39, 15, 'MDN/MG/01.08/26/0065', '-', 'LG', '-', 'Baik', '-', NULL, NULL, NULL),
	(258, 39, 15, 'MDN/MG/01.08/26/0066', '-', 'LG', '-', 'Baik', '-', NULL, NULL, NULL),
	(259, 39, 15, 'MDN/MG/01.08/26/0067', '-', 'LG', '-', 'Baik', '-', NULL, NULL, NULL),
	(260, 39, 15, 'MDN/MG/01.08/26/0068', '-', 'LG', '-', 'Baik', '-', NULL, NULL, NULL),
	(261, 39, 17, 'MDN/MG/01.10/26/0008', '-', 'TP LINK', '-', 'Baik', '-', NULL, NULL, NULL),
	(262, 39, 20, 'MDN/MG/01.13/26/0003', '-', 'LOGITECH', '-', 'Baik', '-', NULL, NULL, NULL),
	(263, 21, 2, 'MDN/MG/01.01/26/0018', '192.168.1.83', 'SIMBADDA', 'WINDOWS 11 PRO\r\nPOLITULIP1_INTEL CORE i3-1115G4\r\nRAM 8\r\n256', 'Baik', '-', NULL, NULL, NULL),
	(264, 21, 13, 'MDN/MG/01.06/26/0018', '-', 'LOGITECH', '-', 'Baik', '-', NULL, NULL, NULL),
	(265, 21, 14, 'MDN/MG/01.07/26/0018', '-', 'LOGITECH', '-', 'Baik', '-', NULL, NULL, NULL),
	(266, 21, 15, 'MDN/MG/01.08/26/0018', '-', 'LG', '-', 'Baik', '-', NULL, NULL, NULL),
	(267, 40, 2, 'MDN/MG/01.01/26/0051', '192.168.1.164/24', 'SIMBADDA', 'WINDOWS 10 PRO\r\nKEUANGAN1_INTEL CORE i3-4170\r\nRAM 8\r\n512', 'Baik', '-', NULL, NULL, NULL),
	(268, 40, 2, 'MDN/MG/01.01/26/0052', '192.168.1.165/24', 'SIMBADDA', 'WINDOWS 10 PRO \r\nKEUANGAN2_INTEL CORE i3-4170\r\nRAM 8\r\n512', 'Baik', '-', NULL, NULL, NULL),
	(269, 40, 2, 'MDN/MG/01.01/26/0053', '192.168.1.166/24', 'SIMBADDA', 'WINDOWS 10 PRO\r\nKEUANGAN4_INTEL CORE i3-4170\r\nRAM 8\r\n512', 'Baik', '-', NULL, NULL, NULL),
	(270, 40, 11, 'MDN/MG/01.02/26/0026', '-', 'EPSON', '-', 'Baik', 'L310', NULL, NULL, NULL),
	(271, 40, 3, 'MDN/MG/01.03/26/0014', '-', 'LENOVO', 'WINDOWS 11\r\nINTEL CORE i5-1342OH\r\nRAM 16\r\n512', 'Baik', '-', NULL, NULL, NULL),
	(272, 40, 13, 'MDN/MG/01.06/26/0052', '-', 'LOGITECH', '-', 'Baik', '-', NULL, NULL, NULL),
	(273, 40, 13, 'MDN/MG/01.06/26/0053', '-', 'LOGITECH', '-', 'Baik', '-', NULL, NULL, NULL),
	(274, 40, 13, 'MDN/MG/01.06/26/0054', '-', 'LOGITECH', '-', 'Baik', '-', NULL, NULL, NULL),
	(275, 40, 14, 'MDN/MG/01.07/26/0051', '-', 'LOGITECH', '-', 'Baik', '-', NULL, NULL, NULL),
	(276, 40, 14, 'MDN/MG/01.07/26/0052', '-', 'LOGITECH', '-', 'Baik', '-', NULL, NULL, NULL),
	(277, 40, 14, 'MDN/MG/01.07/26/0053', '-', 'LOGITECH', '-', 'Baik', '-', NULL, NULL, NULL),
	(278, 40, 15, 'MDN/MG/01.08/26/0052', '-', 'LG', '-', 'Baik', '-', NULL, NULL, NULL),
	(279, 40, 15, 'MDN/MG/01.08/26/0053', '-', 'LG', '-', 'Baik', '-', NULL, NULL, NULL),
	(280, 40, 15, 'MDN/MG/01.08/26/0054', '-', 'LG', '-', 'Baik', '-', NULL, NULL, NULL),
	(281, 40, 17, 'MDN/MG/01.10/26/0007', '-', 'TP LINK', '-', 'Baik', '-', NULL, NULL, NULL),
	(282, 38, 2, 'MDN/MG/01.01/26/0050', '192.168.1.59/24', 'SIMBADDA', 'WINDOWS 10 PRO_\r\nGIZI1_INTEL CORE I3-4170\r\nRAM 4\r\n256', 'Baik', '-', NULL, NULL, NULL),
	(283, 32, 14, 'MDN/MG/01.07/26/0043', '-', 'LOGITECH', NULL, 'Baik', '-', NULL, NULL, NULL),
	(284, 32, 14, 'MDN/MG/01.07/26/0044', '-', 'LOGITECH', NULL, 'Baik', '-', NULL, NULL, NULL),
	(285, 38, 11, 'MDN/MG/01.02/26/0025', '-', 'EPSON', '-', 'Baik', 'L3210', NULL, NULL, NULL),
	(286, 32, 14, 'MDN/MG/01.07/26/0045', '-', 'LOGITECH', NULL, 'Baik', '-', NULL, NULL, NULL),
	(287, 32, 14, 'MDN/MG/01.07/26/0046', '-', 'LOGITECH', NULL, 'Baik', '-', NULL, NULL, NULL),
	(288, 32, 14, 'MDN/MG/01.07/26/0047', '-', 'LOGITECH', NULL, 'Baik', '-', NULL, NULL, NULL),
	(289, 38, 13, 'MDN/MG/01.06/26/0051', '-', 'LOGITECH', '-', 'Baik', '-', NULL, NULL, NULL),
	(290, 32, 15, 'MDN/MG/01.08/26/0039', '-', 'LG', NULL, 'Baik', '-', NULL, NULL, NULL),
	(291, 38, 14, 'MDN/MG/01.07/26/0050', '-', 'LOGITECH', '-', 'Baik', '-', NULL, NULL, NULL),
	(292, 38, 15, 'MDN/MG/01.08/26/0051', '-', 'LG', '-', 'Baik', '-', NULL, NULL, NULL),
	(293, 32, 15, 'MDN/MG/01.08/26/0040', '-', 'LG', NULL, 'Baik', '-', NULL, NULL, NULL),
	(294, 32, 15, 'MDN/MG/01.08/26/0041', '-', 'LG', NULL, 'Baik', '-', NULL, NULL, NULL),
	(295, 32, 15, 'MDN/MG/01.08/26/0043', '-', 'LG', NULL, 'Baik', '-', NULL, NULL, NULL),
	(296, 38, 17, 'MDN/MG/01.10/26/0011', '-', 'TP LINK', '-', 'Baik', '-', NULL, NULL, NULL),
	(297, 32, 15, 'MDN/MG/01.08/26/0044', '-', 'LG', NULL, 'Baik', '-', NULL, NULL, NULL),
	(298, 32, 15, 'MDN/MG/01.08/26/0045', '-', 'LG', NULL, 'Baik', '-', NULL, NULL, NULL),
	(299, 32, 15, 'MDN/MG/01.08/26/0046', '-', 'LG', NULL, 'Baik', '-', NULL, NULL, NULL),
	(300, 32, 15, 'MDN/MG/01.08/26/0047', '-', 'LG', NULL, 'Baik', '-', NULL, NULL, NULL),
	(301, 32, 15, 'MDN/MG/01.08/26/0048', '-', 'LG', NULL, 'Baik', '-', NULL, NULL, NULL),
	(302, 32, 17, 'MDN/MG/01.10/26/0004', '-', 'TP-LINK', NULL, 'Baik', '-', NULL, NULL, NULL),
	(303, 32, 17, 'MDN/MG/01.10/26/0005', '-', 'TP-LINK', NULL, 'Baik', '-', NULL, NULL, NULL),
	(304, 37, 2, 'MDN/MG/01.01/26/0048', '192.168.1.55/24', '-', 'WINDOWS 10 PRO\r\nLOGISTIK2_INTEL CORE i3-4170\r\nRAM 4\r\n256', 'Baik', '-', NULL, NULL, NULL),
	(305, 37, 2, 'MDN/MG/01.01/26/0049', '192.168.1.54/24', 'SIMBADA', 'WINDOWS 10 PRO\r\nLOGISTIK1_INTEL CORE i3-4170\r\nRAM 8\r\n512', 'Baik', '-', NULL, NULL, NULL),
	(306, 37, 11, 'MDN/MG/01.02/26/0024', '-', 'EPSON', '-', 'Baik', 'L3210', NULL, NULL, NULL),
	(307, 37, 13, 'MDN/MG/01.06/26/0049', '-', 'LOGITECH', '-', 'Baik', '-', NULL, NULL, NULL),
	(308, 37, 13, 'MDN/MG/01.06/26/0050', '-', 'LOGITECH', '-', 'Baik', '-', NULL, NULL, NULL),
	(309, 37, 14, 'MDN/MG/01.07/26/0048', '-', 'LOGITECH', '-', 'Baik', '-', NULL, NULL, NULL),
	(310, 37, 14, 'MDN/MG/01.07/26/0049', '-', 'LOGITECH', '-', 'Baik', '-', NULL, NULL, NULL),
	(311, 37, 15, 'MDN/MG/01.08/26/0049', '-', 'LG', '-', 'Baik', '-', NULL, NULL, NULL),
	(312, 37, 15, 'MDN/MG/01.08/26/0050', '-', 'LG', '-', 'Baik', '-', NULL, NULL, NULL),
	(313, 28, 2, 'MDN/MG/01.01/26/0028', '192.168.1.75/24', 'SIMBADA', 'WINDOWS 10 PRO\r\nPOLIUMUM_INTEL CORE i3-4170\r\nRAM 4\r\n256', 'Baik', '-', NULL, NULL, NULL),
	(314, 28, 13, 'MDN/MG/01.06/26/0028', '-', '-', '-', 'Baik', '-', NULL, NULL, NULL),
	(315, 42, 2, 'MDN/MG/01.01/26/0070', '192.168.1.125/24', 'SIMBADDA', 'WINDOWS 10 PRO\r\nKIRANA1_INTEL CORE i3-4170\r\nRAM 4\r\n256', 'Baik', '-', NULL, NULL, NULL),
	(316, 42, 11, 'MDN/MG/01.02/26/0030', '-', 'EPSON', NULL, 'Baik', 'L121', NULL, NULL, NULL),
	(317, 28, 14, 'MDN/MG/01.07/26/0028', '-', 'LOGITECH', '-', 'Baik', '-', NULL, NULL, NULL),
	(318, 42, 3, 'MDN/MG/01.03/26/0008', '-', 'HP', 'WINDOWS 11\r\nINTEL CORE 3 100U\r\nRAM 8\r\n512', 'Baik', '-', NULL, NULL, NULL),
	(319, 28, 15, 'MDN/MG/01.08/26/0028', '-', 'LG', '-', 'Baik', '-', NULL, NULL, NULL),
	(320, 42, 13, 'MDN/MG/01.06/26/0071', '-', 'LOGITECH', NULL, 'Baik', '-', NULL, NULL, NULL),
	(321, 28, 16, 'MDN/MG/01.09/26/0004', '-', 'LOGITECH', '-', 'Baik', '-', NULL, NULL, NULL),
	(322, 42, 15, 'MDN/MG/01.08/26/0071', '-', 'LG', NULL, 'Baik', '-', NULL, NULL, NULL),
	(323, 28, 17, 'MDN/MG/01.10/26/0002', '-', 'TP LINK', '-', 'Baik', '-', NULL, NULL, NULL),
	(324, 43, 2, 'MDN/MG/01.01/26/0071', '192.168.1.128/24', 'SIMBADDA', 'WINDOWS 10 PRO\r\nLEMBAHMANAH1_INTEL CORE i3-4170\r\nRAM 8\r\n256', 'Baik', '-', NULL, NULL, NULL),
	(326, 43, 2, 'MDN/MG/01.01/26/0072', '169.254.179.198/16', 'SIMBADDA', 'WINDOWS 10 PRO\r\nDESKTOP-I7QJK26_INTEL CORE i3-12100\r\nRAM 8\r\n256', 'Baik', '-', NULL, NULL, NULL),
	(327, 43, 11, 'MDN/MG/01.02/26/0031', '-', 'EPSON', NULL, 'Baik', 'L121', NULL, NULL, NULL),
	(328, 43, 3, 'MDN/MG/01.03/26/0009', '-', 'HP', 'WINDOWS 11\r\nINTEL CORE 3 100U\r\nRAM 8\r\n512', 'Baik', '-', NULL, NULL, NULL),
	(329, 43, 12, 'MDN/MG/01.04/26/0006', '-', 'VIVO Y17S', 'ANDROID 15\r\nRAM 4+4\r\n128', 'Baik', 'V2310', NULL, NULL, NULL),
	(330, 43, 13, 'MDN/MG/01.06/26/0072', '-', 'LOGITECH', NULL, 'Baik', '-', NULL, NULL, NULL),
	(331, 43, 13, 'MDN/MG/01.06/26/0073', '-', 'LOGITECH', NULL, 'Baik', '-', NULL, NULL, NULL),
	(332, 43, 14, 'MDN/MG/01.07/26/0071', '-', 'LOGITECH', NULL, 'Baik', '-', NULL, NULL, NULL),
	(333, 43, 14, 'MDN/MG/01.07/26/0072', '-', 'LOGITECH', NULL, 'Baik', '-', NULL, NULL, NULL),
	(334, 43, 15, 'MDN/MG/01.08/26/0072', '-', 'LG', NULL, 'Baik', '-', NULL, NULL, NULL),
	(335, 43, 15, 'MDN/MG/01.08/26/0073', '-', 'LG', NULL, 'Baik', '-', NULL, NULL, NULL),
	(336, 43, 17, 'MDN/MG/01.10/26/0010', '-', 'TP-LINK', NULL, 'Baik', '-', NULL, NULL, NULL),
	(337, 30, 2, 'MDN/MG/01.01/26/0030', '192.168.1.30/24', 'SIMBADA', 'WINDOWS 10 PRO\r\nPERINA1_INTEL CORE i3-4170\r\nRAM 8\r\n256', 'Baik', '-', NULL, NULL, NULL),
	(338, 30, 3, 'MDN/MG/01.03/26/0005', '-', 'HP', 'WINDOWS 11\r\nINTEL CORE 3 100U\r\nRAM 8\r\n512', 'Baik', '-', NULL, NULL, NULL),
	(339, 30, 12, 'MDN/MG/01.04/26/0002', '-', 'OPPO', 'ANDROID 15\r\nCPH2591\r\nRAM 4\r\n128', 'Baik', 'A18', NULL, NULL, NULL),
	(340, 30, 13, 'MDN/MG/01.06/26/0030', '-', 'LOGITECH', '-', 'Baik', '-', NULL, NULL, NULL),
	(341, 30, 14, 'MDN/MG/01.07/26/0030', '-', 'LOGITECH', '-', 'Baik', '-', NULL, NULL, NULL),
	(342, 30, 15, 'MDN/MG/01.08/26/0030', '-', 'LG', '-', 'Baik', '-', NULL, NULL, NULL),
	(343, 35, 2, 'MDN/MG/01.01/26/0032', '192.168.1.51/24', 'SIMBADA', 'WINDOWS 10 PRO\r\nHEMODIALISA1_INTEL CORE i3-4170\r\nRAM 8\r\n512', 'Baik', '-', NULL, NULL, NULL),
	(344, 35, 11, 'MDN/MG/01.02/26/0016', '-', 'EPSON', '-', 'Baik', 'L121', NULL, NULL, NULL),
	(345, 35, 3, 'MDN/MG/01.03/26/0007', '-', 'HP', 'WINDOWS 11\r\nINTEL CORE 3 100U\r\nRAM 8\r\n512', 'Baik', '-', NULL, NULL, NULL),
	(346, 35, 12, 'MDN/MG/01.04/26/0004', '-', 'REALME', 'ANDROID 15\r\nRMX3933\r\nRAM 4+2\r\n64', 'Baik', 'NOTE 60', NULL, NULL, NULL),
	(347, 35, 23, 'MDN/MG/01.05/26/0006', '-', 'SAMSUNG 55"', '-', 'Baik', '-', NULL, NULL, NULL),
	(348, 35, 13, 'MDN/MG/01.06/26/0033', '-', 'LOGITECH', '-', 'Baik', '-', NULL, NULL, NULL),
	(349, 35, 14, 'MDN/MG/01.07/26/0032', '-', 'LOGITECH', '-', 'Baik', '-', NULL, NULL, NULL),
	(350, 35, 15, 'MDN/MG/01.08/26/0033', '-', 'LG', '-', 'Baik', '-', NULL, NULL, NULL),
	(351, 31, 2, 'MDN/MG/01.01/26/0031', '192.168.1.34/24', 'SIMBADA', 'WINDOWS 10 PRO\r\nNIFAS1_INTEL HD GRAPHICS 4400\r\nRAM 8\r\n256', 'Baik', '-', NULL, NULL, NULL),
	(352, 31, 3, 'MDN/MG/01.03/26/0006', '-', 'HP', 'WINDOWS 11\r\nINTEL CORE 3 100U\r\nRAM 8\r\n512', 'Baik', '-', NULL, NULL, NULL),
	(353, 31, 12, 'MDN/MG/01.04/26/0003', '-', 'VIVO', 'ANDROID 15\r\nV2310\r\nRAM 4+4\r\n128', 'Baik', 'Y17S', NULL, NULL, NULL),
	(354, 31, 13, 'MDN/MG/01.06/26/0031', '-', 'LOGITECH', '-', 'Baik', '-', NULL, NULL, NULL),
	(355, 31, 14, 'MDN/MG/01.07/26/0031', '-', 'LOGITECH', '-', 'Baik', '-', NULL, NULL, NULL),
	(356, 31, 15, 'MDN/MG/01.08/26/0031', '-', 'LG', '-', 'Baik', '-', NULL, NULL, NULL),
	(357, 29, 2, 'MDN/MG/01.01/26/0029', '192.168.1.32/24', 'SIMBADA', 'WINDOWS 10 PRO\r\nVK1_INTEL CORE i3-4170\r\nRAM 4\r\n256', 'Baik', '-', NULL, NULL, NULL),
	(358, 29, 11, 'MDN/MG/01.02/26/0015', '-', 'EPSON', '-', 'Baik', 'L3210', NULL, NULL, NULL),
	(359, 29, 13, 'MDN/MG/01.06/26/0029', '-', 'LOGITECH', '-', 'Baik', '-', NULL, NULL, NULL),
	(360, 29, 14, 'MDN/MG/01.07/26/0029', '-', 'LOGITECH', '-', 'Baik', '-', NULL, NULL, NULL),
	(361, 29, 15, 'MDN/MG/01.08/26/0029', '-', 'LG', '-', 'Baik', '-', NULL, NULL, NULL),
	(362, 26, 2, 'MDN/MG/01.01/26/0026', '192.168.1.93/24', 'ASUS', 'WINDOWS 10 PRO\r\nPOLIANAK1_INTEL CORE i3-1115G4\r\nRAM 8\r\n256', 'Baik', '-', NULL, NULL, NULL),
	(363, 26, 13, 'MDN/MG/01.06/26/0026', '-', 'LOGITECH', '-', 'Baik', '-', NULL, NULL, NULL),
	(364, 26, 14, 'MDN/MG/01.07/26/0026', '-', 'LOGITECH', '-', 'Baik', '-', NULL, NULL, NULL),
	(365, 26, 15, 'MDN/MG/01.08/26/0026', '-', 'LG', '-', 'Baik', '-', NULL, NULL, NULL),
	(366, 26, 16, 'MDN/MG/01.09/26/0002', '-', 'LOGITECH', '-', 'Baik', '-', NULL, NULL, NULL),
	(367, 25, 2, 'MDN/MG/01.01/26/0025', '192.168.1.91/24', 'SIMBADA', 'WINDOWS 10 PRO\r\nFISIO1_INTEL CORE i3-4170\r\nRAM 4\r\n512', 'Baik', '-', NULL, NULL, NULL),
	(368, 25, 11, 'MDN/MG/01.02/26/0014', '-', 'EPSON', '-', 'Baik', 'L3210', NULL, NULL, NULL),
	(369, 25, 13, 'MDN/MG/01.06/26/0025', '-', 'LOGITECH', '-', 'Baik', '-', NULL, NULL, NULL),
	(370, 25, 14, 'MDN/MG/01.07/26/0025', '-', 'LOGITECH', '-', 'Baik', '-', NULL, NULL, NULL),
	(371, 25, 15, 'MDN/MG/01.08/26/0025', '-', 'LG', '-', 'Baik', '-', NULL, NULL, NULL),
	(372, 25, 3, 'MDN/MG/01.03/26/0004', '-', 'ASUSVIVOBOOK', 'WINDOWS 11\r\nINTEL CORE i3-N305\r\nRAM 8\r\nHDD 512', 'Baik', '-', NULL, NULL, NULL),
	(373, 46, 2, 'MDN/MG/01.01/26/0074', '192.168.1.169/24', 'SIMBADA', 'WINDOWS 10 PRO\r\nGR1_INTEL CORE i3-4170\r\nRAM 4\r\n256', 'Baik', '-', NULL, NULL, NULL),
	(374, 46, 11, 'MDN/MG/01.02/26/0033', '-', 'EPSON', '-', 'Baik', 'L121', NULL, NULL, NULL),
	(375, 46, 3, 'MDN/MG/01.03/26/0010', '-', 'HP', 'WINDOWS 11\r\nINTEL CORE 3 100U\r\nRAM 8\r\n512', 'Baik', '-', NULL, NULL, NULL),
	(376, 46, 12, 'MDN/MG/01.04/26/0008', '-', 'VIVO', 'ANDROID 15\r\nV2310\r\nRAM  4+4\r\n128', 'Baik', 'Y17S', NULL, NULL, NULL),
	(377, 46, 13, 'MDN/MG/01.06/26/0075', '-', 'LOGITECH', '-', 'Baik', '-', NULL, NULL, NULL),
	(378, 46, 14, 'MDN/MG/01.07/26/0074', '-', 'LOGITECH', '-', 'Baik', '-', NULL, NULL, NULL),
	(379, 46, 15, 'MDN/MG/01.08/26/0075', '-', 'LG', '-', 'Baik', '-', NULL, NULL, NULL),
	(382, 10, 17, '123456111111111111111111', '09809809890', 'toyotaaaa', 'okeee polllllllllllllllll', 'Baik', '0987', NULL, NULL, NULL),
	(383, 16, 2, 'MDN/MG/01.01/26/0016', '192.168.1.71', 'ASUS', 'WINDOWS 11\r\nUROLOGI_INTEL CORE i3-1115G4\r\nRAM 8\r\n256', 'Baik', 'A1400EA', NULL, NULL, NULL),
	(384, 16, 13, 'MDN/MG/01.06/26/0016', '-', 'LOGITECH', '-', 'Baik', '-', NULL, NULL, NULL),
	(385, 16, 14, 'MDN/MG/01.07/26/0016', '-', 'LOGITECH', '-', 'Baik', '-', NULL, NULL, NULL),
	(386, 16, 15, 'MDN/MG/01.08/26/0016', '-', 'LG', '-', 'Baik', '-', NULL, NULL, NULL);

-- Dumping structure for table sisteminventaris.riwayat_cetak
CREATE TABLE IF NOT EXISTS `riwayat_cetak` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `id_ruangan` int DEFAULT NULL,
  `jenis` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pdf',
  `dicetak_pada` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table sisteminventaris.riwayat_cetak: ~0 rows (approximately)
DELETE FROM `riwayat_cetak`;

-- Dumping structure for table sisteminventaris.ruangan
CREATE TABLE IF NOT EXISTS `ruangan` (
  `id_ruangan` int NOT NULL AUTO_INCREMENT,
  `nama_ruangan` varchar(100) DEFAULT NULL,
  `lokasi` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_ruangan`)
) ENGINE=InnoDB AUTO_INCREMENT=51 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table sisteminventaris.ruangan: ~43 rows (approximately)
DELETE FROM `ruangan`;
INSERT INTO `ruangan` (`id_ruangan`, `nama_ruangan`, `lokasi`) VALUES
	(5, 'ADMINISTRASI  IGD', 'Lt. 1'),
	(6, 'KASIR IGD', 'Lt. 1'),
	(7, 'IGD', 'Lt. 1'),
	(8, 'LABORATORIUM', 'Lt. 1'),
	(9, 'RADIOLOGI', 'Lt. 1'),
	(10, 'FARMASI', 'Lt. 1'),
	(11, 'NURSE STATION POLI', 'Lt. 1'),
	(12, 'POLI THT', 'Lt. 1'),
	(13, 'POLI MATA', 'Lt. 1'),
	(14, 'POLI GIGI', 'Lt. 1'),
	(15, 'POLI PARU', 'Lt. 1'),
	(16, 'POLI UROLOGI', 'Lt. 1'),
	(17, 'KLINIK KIA/UMUM', 'Lt. 1'),
	(18, 'POLI BEDAH SYARAF', 'Lt. 1'),
	(19, 'POLI ORTOPEDI', 'Lt. 1'),
	(20, 'POLI JANTUNG', 'Lt. 1'),
	(21, 'POLI SYARAF', 'Lt. 1'),
	(22, 'POLI  PENYAKIT DALAM', 'Lt. 1'),
	(23, 'POLI PENYAKIT DALAM 2', 'Lt. 1'),
	(24, 'POLI BEDAH', 'Lt. 1'),
	(25, 'POLI REHAB MEDIK', 'Lt. 1'),
	(26, 'POLI ANAK', 'Lt. 1'),
	(27, 'POLI OBGYN', 'Lt. 1'),
	(28, 'POLI JIWA', 'Lt. 1'),
	(29, 'UNIT BERSALIN', 'Lt. 1'),
	(30, 'UNIT PERINATAL', 'Lt. 1'),
	(31, 'UNIT MIJIL', 'Lt. 1'),
	(32, 'UNIT KLAIM', 'Lt. 1'),
	(33, 'ADMINISTRASI RS', 'Lt. 1'),
	(34, 'KASIR RS', 'Lt. 1'),
	(35, 'UNIT DIALISIS', 'Lt. 1'),
	(36, 'UNIT APM', 'Lt. 1'),
	(37, 'UNIT LOGISTIK', 'Lt. 1'),
	(38, 'UNIT GIZI', 'Lt. 1'),
	(39, 'UNIT TATA USAHA', 'Lt. 2'),
	(40, 'UNIT KEUANGAN', 'Lt. 2'),
	(41, 'UNIT ICU', 'Lt. 2'),
	(42, 'UNIT KIRANA', 'Lt. 2'),
	(43, 'UNIT LEMBAH MANAH', 'Lt. 2'),
	(44, 'UNIT OK', 'Lt. 2'),
	(45, 'UNIT OPS', 'Lt. 2'),
	(46, 'UNIT GEMAH RIPAH', 'Lt. 3'),
	(47, 'UNIT MAHESWARA', 'Lt. 3');

-- Dumping structure for table sisteminventaris.sessions
CREATE TABLE IF NOT EXISTS `sessions` (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table sisteminventaris.sessions: ~3 rows (approximately)
DELETE FROM `sessions`;
INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
	('amqQAUEBJDRvUb0fE6aEmZD2pA9lii65UBGQ2CBR', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiQWFUY1dnd1owazZyZGRicWgyTmhHTlhNWG5VbTNodnZSOFdOcVVUbSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzI6Imh0dHA6Ly9zaXN0ZW1pbnZlbnRhcmlzLmNvbTo4MDcwIjtzOjU6InJvdXRlIjtzOjU6ImxvZ2luIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1782045749);

-- Dumping structure for table sisteminventaris.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table sisteminventaris.users: ~4 rows (approximately)
DELETE FROM `users`;
INSERT INTO `users` (`id`, `name`, `password`, `role`, `remember_token`, `created_at`, `updated_at`) VALUES
	(2, 'DELTA', '2305101001', 'admin', NULL, NULL, '2026-03-02 00:25:43'),
	(18, 'RIZAL', 'rizal123', 'teknisi', NULL, '2026-04-30 20:28:56', '2026-04-30 20:28:56'),
	(21, 'aZHIs', '2305101010', 'admin', NULL, '2026-05-01 19:17:44', '2026-05-13 22:58:30'),
	(22, 'ARUL', '1234567891', 'teknisi', NULL, '2026-05-01 19:21:26', '2026-05-01 19:24:52');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
