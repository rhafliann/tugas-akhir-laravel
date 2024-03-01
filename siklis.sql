-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Feb 29, 2024 at 06:15 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `siklis`
--

-- --------------------------------------------------------

--
-- Table structure for table `arsip`
--

CREATE TABLE `arsip` (
  `id_arsip` int UNSIGNED NOT NULL,
  `jenis` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `keterangan` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_users` int UNSIGNED NOT NULL,
  `is_deleted` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `barang_ppr`
--

CREATE TABLE `barang_ppr` (
  `id_barang_ppr` int UNSIGNED NOT NULL,
  `id_ruangan` int UNSIGNED NOT NULL,
  `nama_barang` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tahun_pembuatan` varchar(4) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jumlah` int NOT NULL,
  `keterangan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_deleted` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `barang_ppr`
--

INSERT INTO `barang_ppr` (`id_barang_ppr`, `id_ruangan`, `nama_barang`, `tahun_pembuatan`, `jumlah`, `keterangan`, `image`, `is_deleted`, `created_at`, `updated_at`) VALUES
(1, 3, 'ipsa', '2016', 82, 'quia', NULL, '1', '2023-12-20 23:15:49', '2023-12-20 23:15:49'),
(2, 3, 'facilis', '1977', 7, 'numquam', NULL, '0', '2023-12-20 23:15:49', '2023-12-20 23:15:49'),
(3, 2, 'voluptate', '1997', 43, 'distinctio', NULL, '1', '2023-12-20 23:15:49', '2023-12-20 23:15:49'),
(4, 2, 'aut', '1977', 44, 'sunt', NULL, '1', '2023-12-20 23:15:49', '2023-12-20 23:15:49'),
(5, 3, 'beatae', '1992', 71, 'corporis', NULL, '0', '2023-12-20 23:15:49', '2023-12-20 23:15:49'),
(6, 2, 'animi', '1997', 64, 'voluptatem', NULL, '1', '2023-12-20 23:15:49', '2023-12-20 23:15:49'),
(7, 3, 'dolorem', '2004', 94, 'quia', NULL, '0', '2023-12-20 23:15:49', '2023-12-20 23:15:49'),
(8, 1, 'nihil', '1979', 31, 'et', NULL, '1', '2023-12-20 23:15:49', '2023-12-20 23:15:49'),
(9, 2, 'magni', '2004', 64, 'fugit', NULL, '0', '2023-12-20 23:15:49', '2023-12-20 23:15:49'),
(10, 2, 'impedit', '2007', 21, 'minima', NULL, '1', '2023-12-20 23:15:49', '2023-12-20 23:15:49'),
(11, 3, 'omnis', '2001', 66, 'ab', NULL, '0', '2023-12-20 23:15:49', '2023-12-20 23:15:49'),
(12, 1, 'rem', '1987', 98, 'iusto', NULL, '0', '2023-12-20 23:15:49', '2023-12-20 23:15:49'),
(13, 2, 'aut', '1995', 92, 'qui', NULL, '0', '2023-12-20 23:15:49', '2023-12-20 23:15:49'),
(14, 2, 'suscipit', '1999', 97, 'nihil', NULL, '1', '2023-12-20 23:15:49', '2023-12-20 23:15:49'),
(15, 1, 'saepe', '2018', 15, 'officiis', NULL, '0', '2023-12-20 23:15:49', '2023-12-20 23:15:49'),
(16, 1, 'ut', '1996', 43, 'eos', NULL, '1', '2023-12-20 23:15:49', '2023-12-20 23:15:49'),
(17, 1, 'assumenda', '1993', 18, 'distinctio', NULL, '0', '2023-12-20 23:15:49', '2023-12-20 23:15:49'),
(18, 3, 'soluta', '1991', 97, 'quam', NULL, '0', '2023-12-20 23:15:49', '2023-12-20 23:15:49'),
(19, 3, 'quidem', '1970', 61, 'officia', NULL, '1', '2023-12-20 23:15:49', '2023-12-20 23:15:49'),
(20, 1, 'iste', '1983', 68, 'sint', NULL, '1', '2023-12-20 23:15:49', '2023-12-20 23:15:49'),
(21, 3, 'fuga', '2015', 38, 'numquam', NULL, '1', '2023-12-20 23:15:49', '2023-12-20 23:15:49'),
(22, 1, 'doloremque', '1984', 67, 'sit', NULL, '1', '2023-12-20 23:15:49', '2023-12-20 23:15:49'),
(23, 2, 'aut', '1991', 83, 'qui', NULL, '0', '2023-12-20 23:15:49', '2023-12-20 23:15:49'),
(24, 3, 'blanditiis', '2015', 44, 'voluptatem', NULL, '1', '2023-12-20 23:15:49', '2023-12-20 23:15:49'),
(25, 2, 'molestiae', '1990', 1, 'et', NULL, '0', '2023-12-20 23:15:49', '2023-12-20 23:15:49'),
(26, 3, 'placeat', '1972', 89, 'et', NULL, '0', '2023-12-20 23:15:49', '2023-12-20 23:15:49'),
(27, 2, 'enim', '2017', 32, 'qui', NULL, '0', '2023-12-20 23:15:49', '2023-12-20 23:15:49'),
(28, 1, 'aperiam', '1970', 98, 'id', NULL, '1', '2023-12-20 23:15:49', '2023-12-20 23:15:49'),
(29, 1, 'rerum', '2020', 71, 'sed', NULL, '0', '2023-12-20 23:15:49', '2023-12-20 23:15:49'),
(30, 1, 'asperiores', '2022', 6, 'consequatur', NULL, '0', '2023-12-20 23:15:49', '2023-12-20 23:15:49'),
(31, 3, 'voluptas', '1977', 62, 'veritatis', NULL, '1', '2023-12-20 23:15:49', '2023-12-20 23:15:49'),
(32, 1, 'sed', '1974', 18, 'praesentium', NULL, '1', '2023-12-20 23:15:49', '2023-12-20 23:15:49'),
(33, 2, 'provident', '2002', 81, 'ullam', NULL, '1', '2023-12-20 23:15:49', '2023-12-20 23:15:49'),
(34, 1, 'corporis', '1981', 50, 'pariatur', NULL, '1', '2023-12-20 23:15:49', '2023-12-20 23:15:49'),
(35, 2, 'repellat', '2017', 13, 'minus', NULL, '0', '2023-12-20 23:15:49', '2023-12-20 23:15:49'),
(36, 3, 'veritatis', '2008', 69, 'et', NULL, '0', '2023-12-20 23:15:49', '2023-12-20 23:15:49'),
(37, 3, 'aut', '1980', 92, 'delectus', NULL, '1', '2023-12-20 23:15:49', '2023-12-20 23:15:49'),
(38, 1, 'nobis', '2005', 94, 'sunt', NULL, '1', '2023-12-20 23:15:49', '2023-12-20 23:15:49'),
(39, 2, 'necessitatibus', '1993', 7, 'id', NULL, '0', '2023-12-20 23:15:49', '2023-12-20 23:15:49'),
(40, 2, 'sint', '1983', 3, 'enim', NULL, '0', '2023-12-20 23:15:49', '2023-12-20 23:15:49');

-- --------------------------------------------------------

--
-- Table structure for table `barang_tik`
--

CREATE TABLE `barang_tik` (
  `id_barang_tik` int UNSIGNED NOT NULL,
  `id_ruangan` int UNSIGNED NOT NULL,
  `jenis_aset` enum('BMN','Non-BMN') COLLATE utf8mb4_unicode_ci NOT NULL,
  `kode_barang` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_barang` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `merek` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kelengkapan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tahun_pembelian` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kondisi` enum('Baik','Perlu Perbaikan','Rusak Total') COLLATE utf8mb4_unicode_ci NOT NULL,
  `status_pinjam` enum('Ya','Tidak') COLLATE utf8mb4_unicode_ci NOT NULL,
  `keterangan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_deleted` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `barang_tik`
--

INSERT INTO `barang_tik` (`id_barang_tik`, `id_ruangan`, `jenis_aset`, `kode_barang`, `nama_barang`, `merek`, `kelengkapan`, `tahun_pembelian`, `kondisi`, `status_pinjam`, `keterangan`, `image`, `is_deleted`, `created_at`, `updated_at`) VALUES
(1, 3, 'Non-BMN', '188598', 'quas', 'fuga', 'Ab est numquam dolorem libero porro ut.', '1992-09-03', 'Perlu Perbaikan', 'Ya', 'dolores', NULL, '1', '2023-12-20 23:15:49', '2023-12-20 23:15:49'),
(2, 2, 'Non-BMN', '315890', 'impedit', 'suscipit', 'Quisquam maiores laboriosam error est in occaecati.', '2002-03-05', 'Rusak Total', 'Ya', 'dolorem', NULL, '0', '2023-12-20 23:15:49', '2023-12-20 23:15:49'),
(3, 2, 'BMN', '44424', 'ut', 'at', 'Earum saepe tenetur placeat praesentium ut aut et.', '2009-10-21', 'Baik', 'Tidak', 'excepturi', NULL, '1', '2023-12-20 23:15:49', '2023-12-20 23:15:49'),
(4, 3, 'BMN', '672271', 'sint', 'reiciendis', 'Assumenda explicabo autem voluptates eum.', '2014-11-12', 'Perlu Perbaikan', 'Ya', 'facere', NULL, '0', '2023-12-20 23:15:49', '2023-12-20 23:15:49'),
(5, 2, 'BMN', '874294', 'qui', 'magni', 'Vero quisquam sed pariatur sed beatae natus iusto dolorum.', '2022-12-23', 'Rusak Total', 'Ya', 'veniam', NULL, '1', '2023-12-20 23:15:49', '2023-12-20 23:15:49'),
(6, 1, 'BMN', '582932', 'vel', 'esse', 'Culpa quae aliquam vitae et sint.', '1976-05-15', 'Perlu Perbaikan', 'Tidak', 'officia', NULL, '0', '2023-12-20 23:15:49', '2023-12-20 23:15:49'),
(7, 2, 'BMN', '778470', 'dolor', 'et', 'Nam perspiciatis atque ea commodi et.', '1997-05-09', 'Perlu Perbaikan', 'Tidak', 'porro', NULL, '0', '2023-12-20 23:15:49', '2023-12-20 23:15:49'),
(8, 2, 'Non-BMN', '215254', 'sit', 'non', 'Vero fuga sed officiis et quis.', '1981-03-03', 'Perlu Perbaikan', 'Ya', 'officia', NULL, '0', '2023-12-20 23:15:49', '2023-12-20 23:15:49'),
(9, 2, 'Non-BMN', '497847', 'cupiditate', 'accusantium', 'Delectus id consequatur reprehenderit mollitia accusamus.', '2021-07-29', 'Perlu Perbaikan', 'Tidak', 'enim', NULL, '0', '2023-12-20 23:15:49', '2023-12-20 23:15:49'),
(10, 2, 'BMN', '431023', 'qui', 'est', 'Et est reiciendis omnis.', '2004-05-15', 'Perlu Perbaikan', 'Ya', 'delectus', NULL, '1', '2023-12-20 23:15:49', '2023-12-20 23:15:49'),
(11, 2, 'BMN', '614015', 'id', 'doloremque', 'Perferendis et veniam veniam vel facilis fugiat.', '1990-05-23', 'Perlu Perbaikan', 'Tidak', 'sed', NULL, '0', '2023-12-20 23:15:49', '2023-12-20 23:15:49'),
(12, 3, 'Non-BMN', '796194', 'omnis', 'velit', 'Consequatur tempore aliquid id molestiae.', '2008-02-25', 'Baik', 'Ya', 'quae', NULL, '1', '2023-12-20 23:15:49', '2023-12-20 23:15:49'),
(13, 2, 'BMN', '690701', 'ipsa', 'possimus', 'In dolore nulla eos assumenda incidunt.', '1984-04-27', 'Baik', 'Tidak', 'ad', NULL, '0', '2023-12-20 23:15:49', '2023-12-20 23:15:49'),
(14, 2, 'Non-BMN', '531348', 'sint', 'accusantium', 'Commodi necessitatibus quasi sapiente esse autem et.', '1999-05-25', 'Perlu Perbaikan', 'Ya', 'eligendi', NULL, '0', '2023-12-20 23:15:49', '2023-12-20 23:15:49'),
(15, 1, 'BMN', '122774', 'dolor', 'natus', 'Animi tempora modi iusto ipsum minima.', '2006-02-28', 'Baik', 'Tidak', 'sint', NULL, '1', '2023-12-20 23:15:49', '2023-12-20 23:15:49'),
(16, 3, 'BMN', '555866', 'suscipit', 'error', 'Tenetur dignissimos architecto recusandae consequatur voluptatem quam qui.', '1987-08-19', 'Rusak Total', 'Tidak', 'maxime', NULL, '1', '2023-12-20 23:15:49', '2023-12-20 23:15:49'),
(17, 3, 'Non-BMN', '191499', 'voluptas', 'rerum', 'Est iste aut ipsam quis omnis vitae.', '1972-09-13', 'Baik', 'Tidak', 'sunt', NULL, '1', '2023-12-20 23:15:49', '2023-12-20 23:15:49'),
(18, 3, 'Non-BMN', '167215', 'distinctio', 'eveniet', 'Non impedit excepturi molestiae nesciunt id.', '1988-03-22', 'Perlu Perbaikan', 'Ya', 'iure', NULL, '1', '2023-12-20 23:15:49', '2023-12-20 23:15:49'),
(19, 1, 'BMN', '909987', 'hic', 'quod', 'Ut fugiat doloribus accusamus maiores ipsum vero.', '1972-03-08', 'Rusak Total', 'Tidak', 'optio', NULL, '0', '2023-12-20 23:15:49', '2023-12-20 23:15:49'),
(20, 1, 'BMN', '212249', 'ex', 'soluta', 'Nostrum est beatae odit.', '2007-02-18', 'Baik', 'Tidak', 'voluptate', NULL, '1', '2023-12-20 23:15:49', '2023-12-20 23:15:49'),
(21, 1, 'Non-BMN', '983877', 'exercitationem', 'ut', 'Eum voluptatem consectetur eum quia sunt.', '1977-01-27', 'Baik', 'Tidak', 'quis', NULL, '1', '2023-12-20 23:15:49', '2023-12-20 23:15:49'),
(22, 1, 'Non-BMN', '684180', 'at', 'dolore', 'Et et iusto reprehenderit repellendus autem.', '1994-01-16', 'Perlu Perbaikan', 'Ya', 'omnis', NULL, '0', '2023-12-20 23:15:49', '2023-12-20 23:15:49'),
(23, 3, 'BMN', '868559', 'dolores', 'porro', 'Et magni quibusdam amet quis.', '2020-10-16', 'Perlu Perbaikan', 'Ya', 'officiis', NULL, '1', '2023-12-20 23:15:49', '2023-12-20 23:15:49'),
(24, 2, 'Non-BMN', '121578', 'amet', 'eius', 'Recusandae et consequatur omnis voluptas deleniti exercitationem aliquid qui.', '1993-01-18', 'Baik', 'Ya', 'alias', NULL, '1', '2023-12-20 23:15:49', '2023-12-20 23:15:49'),
(25, 2, 'Non-BMN', '604785', 'nesciunt', 'sit', 'Necessitatibus cum quia voluptatibus iusto et quia magni sed.', '2020-03-10', 'Baik', 'Tidak', 'delectus', NULL, '0', '2023-12-20 23:15:49', '2023-12-20 23:15:49'),
(26, 2, 'BMN', '290648', 'repudiandae', 'voluptates', 'Nihil deserunt repudiandae ut aut nemo illo blanditiis.', '2003-09-30', 'Perlu Perbaikan', 'Tidak', 'accusamus', NULL, '1', '2023-12-20 23:15:49', '2023-12-20 23:15:49'),
(27, 2, 'BMN', '46463', 'modi', 'odit', 'Natus necessitatibus qui consequuntur adipisci ut voluptas pariatur.', '2003-11-02', 'Rusak Total', 'Ya', 'nobis', NULL, '1', '2023-12-20 23:15:49', '2023-12-20 23:15:49'),
(28, 3, 'Non-BMN', '422545', 'voluptas', 'quis', 'Sint alias atque perspiciatis voluptatum.', '1999-03-20', 'Baik', 'Tidak', 'a', NULL, '0', '2023-12-20 23:15:49', '2023-12-20 23:15:49'),
(29, 3, 'BMN', '446944', 'quas', 'nisi', 'Amet et omnis et voluptatem eum maxime.', '2013-08-05', 'Baik', 'Tidak', 'quaerat', NULL, '0', '2023-12-20 23:15:49', '2023-12-20 23:15:49'),
(30, 3, 'Non-BMN', '970506', 'vel', 'impedit', 'Sed ea aliquam asperiores dicta accusantium.', '2005-01-19', 'Perlu Perbaikan', 'Ya', 'consequuntur', NULL, '0', '2023-12-20 23:15:49', '2023-12-20 23:15:49'),
(31, 1, 'BMN', '805641', 'sint', 'corporis', 'Vero aspernatur ullam nisi quia eius velit.', '1987-07-27', 'Rusak Total', 'Ya', 'facere', NULL, '1', '2023-12-20 23:15:49', '2023-12-20 23:15:49'),
(32, 3, 'Non-BMN', '449642', 'numquam', 'nisi', 'Quo doloremque ex labore asperiores et.', '2017-10-21', 'Baik', 'Ya', 'vel', NULL, '0', '2023-12-20 23:15:49', '2023-12-20 23:15:49'),
(33, 2, 'Non-BMN', '172220', 'autem', 'maxime', 'Est voluptas architecto minima voluptatem tenetur quibusdam consequatur.', '2018-08-04', 'Rusak Total', 'Ya', 'at', NULL, '0', '2023-12-20 23:15:49', '2023-12-20 23:15:49'),
(34, 3, 'Non-BMN', '105712', 'ex', 'nobis', 'Qui consequuntur ratione repudiandae aut ab molestiae distinctio.', '2002-02-10', 'Perlu Perbaikan', 'Ya', 'deleniti', NULL, '0', '2023-12-20 23:15:49', '2023-12-20 23:15:49'),
(35, 3, 'BMN', '325313', 'nemo', 'sunt', 'Eum necessitatibus minus molestiae est.', '1979-02-13', 'Baik', 'Tidak', 'dolorem', NULL, '0', '2023-12-20 23:15:49', '2023-12-20 23:15:49'),
(36, 1, 'BMN', '97669', 'mollitia', 'velit', 'Odio aut fugit vero vel minus dolor quod.', '1995-04-05', 'Rusak Total', 'Tidak', 'aliquid', NULL, '1', '2023-12-20 23:15:49', '2023-12-20 23:15:49'),
(37, 3, 'Non-BMN', '88985', 'reiciendis', 'iure', 'Ut fuga omnis iure voluptatibus nisi et perspiciatis.', '2019-04-05', 'Rusak Total', 'Tidak', 'distinctio', NULL, '1', '2023-12-20 23:15:49', '2023-12-20 23:15:49'),
(38, 2, 'BMN', '356174', 'incidunt', 'et', 'Hic quos unde et voluptatibus at dolore.', '2015-02-19', 'Baik', 'Ya', 'eos', NULL, '1', '2023-12-20 23:15:49', '2023-12-20 23:15:49'),
(39, 1, 'Non-BMN', '442121', 'fugit', 'libero', 'Velit eos laboriosam nisi.', '1973-10-13', 'Baik', 'Tidak', 'alias', NULL, '0', '2023-12-20 23:15:49', '2023-12-20 23:15:49'),
(40, 2, 'BMN', '325993', 'aperiam', 'et', 'Sit fugit tenetur dignissimos aspernatur iste consequuntur.', '1992-01-18', 'Perlu Perbaikan', 'Ya', 'perferendis', NULL, '0', '2023-12-20 23:15:49', '2023-12-20 23:15:49');

-- --------------------------------------------------------

--
-- Table structure for table `cuti`
--

CREATE TABLE `cuti` (
  `id_cuti` int UNSIGNED NOT NULL,
  `id_users` int UNSIGNED NOT NULL,
  `jatah_cuti` int NOT NULL,
  `is_deleted` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cuti`
--

INSERT INTO `cuti` (`id_cuti`, `id_users`, `jatah_cuti`, `is_deleted`, `created_at`, `updated_at`) VALUES
(1, 1, 30, '0', '2023-12-20 23:15:49', '2023-12-20 23:15:49'),
(2, 2, 22, '0', '2023-12-20 23:15:49', '2023-12-20 23:15:49'),
(3, 3, 12, '0', '2023-12-20 23:15:49', '2023-12-20 23:15:49'),
(4, 4, 29, '0', '2023-12-20 23:15:49', '2023-12-20 23:15:49'),
(5, 5, 18, '0', '2023-12-20 23:15:49', '2023-12-20 23:15:49'),
(6, 6, 23, '0', '2023-12-20 23:15:49', '2023-12-20 23:15:49'),
(7, 7, 22, '0', '2023-12-20 23:15:49', '2023-12-20 23:15:49'),
(8, 8, 10, '0', '2023-12-20 23:15:49', '2023-12-20 23:15:49'),
(9, 9, 15, '0', '2023-12-20 23:15:49', '2023-12-20 23:15:49'),
(10, 10, 11, '0', '2023-12-20 23:15:49', '2023-12-20 23:15:49'),
(11, 11, 30, '0', '2023-12-20 23:15:49', '2023-12-20 23:15:49'),
(12, 12, 28, '0', '2023-12-20 23:15:49', '2023-12-20 23:15:49'),
(13, 13, 15, '0', '2023-12-20 23:15:49', '2023-12-20 23:15:49'),
(14, 14, 16, '0', '2023-12-20 23:15:50', '2023-12-20 23:15:50'),
(15, 15, 17, '0', '2023-12-20 23:15:50', '2023-12-20 23:15:50'),
(16, 16, 15, '0', '2023-12-20 23:15:50', '2023-12-20 23:15:50'),
(17, 17, 19, '0', '2023-12-20 23:15:50', '2023-12-20 23:15:50'),
(18, 18, 16, '0', '2023-12-20 23:15:50', '2023-12-20 23:15:50'),
(19, 19, 15, '0', '2023-12-20 23:15:50', '2023-12-20 23:15:50');

-- --------------------------------------------------------

--
-- Table structure for table `detail_peminjaman_barang`
--

CREATE TABLE `detail_peminjaman_barang` (
  `id_detail_peminjaman` int UNSIGNED NOT NULL,
  `id_peminjaman` int UNSIGNED NOT NULL,
  `id_barang_tik` int UNSIGNED NOT NULL,
  `keterangan_awal` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `keterangan_akhir` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tgl_kembali` date DEFAULT NULL,
  `status` enum('dipinjam','dikembalikan') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `diklat`
--

CREATE TABLE `diklat` (
  `id_diklat` int UNSIGNED NOT NULL,
  `id_users` int UNSIGNED NOT NULL,
  `id_jenis_diklat` int UNSIGNED NOT NULL,
  `nama_diklat` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `penyelenggara` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tgl_mulai` date NOT NULL,
  `tgl_selesai` date NOT NULL,
  `jp` int NOT NULL,
  `file_sertifikat` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_deleted` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `email_configuration`
--

CREATE TABLE `email_configuration` (
  `id_email_configuration` int UNSIGNED NOT NULL,
  `protocol` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `host` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `port` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `timeout` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `email_configuration`
--

INSERT INTO `email_configuration` (`id_email_configuration`, `protocol`, `host`, `port`, `timeout`, `username`, `email`, `password`, `created_at`, `updated_at`) VALUES
(1, 'smtp', 'smtp.gmail.com', '465', '30', 'kevinalmer.bisnis@gmail.com', 'kevinalmer.bisnis@gmail.com', 'szjnbcpcbkpvggte', '2023-12-20 23:15:50', '2023-12-20 23:15:50');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs_table`
--

CREATE TABLE `failed_jobs_table` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hubungan_keluarga`
--

CREATE TABLE `hubungan_keluarga` (
  `id_hubungan` int UNSIGNED NOT NULL,
  `urutan` int NOT NULL,
  `nama` varchar(256) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_deleted` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `hubungan_keluarga`
--

INSERT INTO `hubungan_keluarga` (`id_hubungan`, `urutan`, `nama`, `is_deleted`, `created_at`, `updated_at`) VALUES
(1, 1, 'Ibu', '0', '2023-12-20 23:15:47', '2023-12-20 23:15:47'),
(2, 2, 'Ayah', '0', '2023-12-20 23:15:47', '2023-12-20 23:15:47'),
(3, 3, 'Anak Kandung', '0', '2023-12-20 23:15:47', '2023-12-20 23:15:47');

-- --------------------------------------------------------

--
-- Table structure for table `jabatan`
--

CREATE TABLE `jabatan` (
  `id_jabatan` int UNSIGNED NOT NULL,
  `nama_jabatan` varchar(256) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_deleted` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `jabatan`
--

INSERT INTO `jabatan` (`id_jabatan`, `nama_jabatan`, `is_deleted`, `created_at`, `updated_at`) VALUES
(1, 'Admin', '0', '2023-12-20 23:15:47', '2023-12-20 23:15:47'),
(2, 'kadiv', '0', '2023-12-20 23:15:47', '2023-12-20 23:15:47'),
(3, 'dda', '0', '2023-12-20 23:15:47', '2023-12-20 23:15:47'),
(4, 'staf', '0', '2023-12-20 23:15:47', '2023-12-20 23:15:47'),
(5, 'ppk', '0', '2023-12-20 23:15:47', '2023-12-20 23:15:47'),
(6, 'bod', '0', '2023-12-20 23:15:47', '2023-12-20 23:15:47'),
(7, 'direktur', '0', '2023-12-20 23:15:47', '2023-12-20 23:15:47'),
(8, 'Kadiv TIK', '0', '2023-12-20 23:15:47', '2023-12-20 23:15:47'),
(9, 'Kadiv KSHM', '0', '2023-12-20 23:15:47', '2023-12-20 23:15:47');

-- --------------------------------------------------------

--
-- Table structure for table `jenis_diklat`
--

CREATE TABLE `jenis_diklat` (
  `id_jenis_diklat` int UNSIGNED NOT NULL,
  `nama_jenis_diklat` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_deleted` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `jenis_diklat`
--

INSERT INTO `jenis_diklat` (`id_jenis_diklat`, `nama_jenis_diklat`, `is_deleted`, `created_at`, `updated_at`) VALUES
(1, 'Diklat kepemimpinan', '0', '2023-12-20 23:15:47', '2023-12-20 23:15:47'),
(2, 'Diklat Fungsional', '0', '2023-12-20 23:15:47', '2023-12-20 23:15:47'),
(3, 'Diklat Teknis', '0', '2023-12-20 23:15:47', '2023-12-20 23:15:47');

-- --------------------------------------------------------

--
-- Table structure for table `kegiatan`
--

CREATE TABLE `kegiatan` (
  `id_kegiatan` int UNSIGNED NOT NULL,
  `nama_kegiatan` varchar(256) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tgl_mulai` date NOT NULL,
  `tgl_selesai` date NOT NULL,
  `lokasi` varchar(256) COLLATE utf8mb4_unicode_ci NOT NULL,
  `peserta` varchar(256) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_deleted` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `kegiatan`
--

INSERT INTO `kegiatan` (`id_kegiatan`, `nama_kegiatan`, `tgl_mulai`, `tgl_selesai`, `lokasi`, `peserta`, `is_deleted`, `created_at`, `updated_at`) VALUES
(1, 'Pariatur beatae temporibus.', '2023-06-13', '2023-06-20', 'Expedita est suscipit odio accusantium atque.', 'Voluptatem fuga.', '0', '2023-12-20 23:15:49', '2023-12-20 23:15:49'),
(2, 'Possimus libero aut.', '2024-01-05', '2024-01-12', 'Repellat in est necessitatibus.', 'Exercitationem consequatur voluptatibus.', '0', '2023-12-20 23:15:49', '2023-12-20 23:15:49'),
(3, 'Reprehenderit quas.', '2023-03-29', '2023-04-05', 'Odit eligendi est sunt ut quod autem.', 'Repudiandae sint provident.', '0', '2023-12-20 23:15:49', '2023-12-20 23:15:49'),
(4, 'Doloremque perspiciatis.', '2023-04-28', '2023-05-05', 'Nobis officia deleniti dignissimos vel minus deleniti.', 'Et earum beatae.', '0', '2023-12-20 23:15:49', '2023-12-20 23:15:49'),
(5, 'Ea dolores nulla.', '2023-04-10', '2023-04-17', 'Accusamus molestiae quas maxime exercitationem consectetur illo.', 'Harum repellendus.', '0', '2023-12-20 23:15:49', '2023-12-20 23:15:49'),
(6, 'Vero et.', '2023-11-30', '2023-12-07', 'Enim perferendis et illum sit.', 'Et quasi.', '0', '2023-12-20 23:15:49', '2023-12-20 23:15:49'),
(7, 'Laboriosam est officia.', '2024-01-05', '2024-01-12', 'Tempora qui sunt consequuntur.', 'Quia adipisci.', '0', '2023-12-20 23:15:49', '2023-12-20 23:15:49'),
(8, 'Et voluptatibus qui.', '2023-06-08', '2023-06-15', 'Officiis occaecati tempore impedit quia consequatur dolorem.', 'Quia facilis.', '0', '2023-12-20 23:15:49', '2023-12-20 23:15:49'),
(9, 'Tempore quis.', '2023-03-18', '2023-03-25', 'Quasi quis consequatur maiores quidem.', 'Non quas.', '0', '2023-12-20 23:15:49', '2023-12-20 23:15:49'),
(10, 'Nemo facilis.', '2023-12-17', '2023-12-24', 'Quod fugit fugiat est rerum.', 'Delectus odio.', '0', '2023-12-20 23:15:49', '2023-12-20 23:15:49'),
(11, 'Veniam odio.', '2023-03-31', '2023-04-07', 'Est quia harum explicabo consectetur enim.', 'Repellat ut blanditiis.', '0', '2023-12-20 23:15:49', '2023-12-20 23:15:49'),
(12, 'Cumque deleniti.', '2023-04-23', '2023-04-30', 'Reprehenderit commodi perferendis architecto officiis nihil dolorem.', 'Ex officia et.', '0', '2023-12-20 23:15:49', '2023-12-20 23:15:49'),
(13, 'Maxime voluptatum sit.', '2023-10-25', '2023-11-01', 'Sed debitis voluptatibus ab rerum incidunt.', 'Ut voluptas quos.', '0', '2023-12-20 23:15:49', '2023-12-20 23:15:49'),
(14, 'Labore odit.', '2024-01-17', '2024-01-24', 'Dolorem harum distinctio voluptas harum.', 'Quia deserunt molestiae.', '0', '2023-12-20 23:15:49', '2023-12-20 23:15:49'),
(15, 'Est qui.', '2023-07-06', '2023-07-13', 'Magni et quia alias eius est exercitationem.', 'Quos numquam nulla.', '0', '2023-12-20 23:15:49', '2023-12-20 23:15:49'),
(16, 'Consequatur et.', '2024-01-13', '2024-01-20', 'Qui sed eos modi nesciunt eligendi quaerat.', 'Aliquid aut non.', '0', '2023-12-20 23:15:49', '2023-12-20 23:15:49'),
(17, 'Aut voluptatibus.', '2023-09-22', '2023-09-29', 'Tenetur consequuntur cum hic deleniti ut ex.', 'Error ad.', '0', '2023-12-20 23:15:49', '2023-12-20 23:15:49'),
(18, 'Eaque sed dolorem.', '2023-02-22', '2023-03-01', 'Magni aut pariatur totam fugit perspiciatis.', 'Velit molestias.', '0', '2023-12-20 23:15:49', '2023-12-20 23:15:49'),
(19, 'Culpa sequi.', '2023-09-17', '2023-09-24', 'Adipisci voluptatem ratione molestiae ipsa necessitatibus.', 'Nostrum consequatur.', '0', '2023-12-20 23:15:49', '2023-12-20 23:15:49'),
(20, 'Doloremque amet.', '2023-11-21', '2023-11-28', 'Voluptates velit expedita omnis autem necessitatibus porro.', 'Ea doloribus placeat.', '0', '2023-12-20 23:15:49', '2023-12-20 23:15:49'),
(21, 'Provident tenetur.', '2023-02-25', '2023-03-04', 'Voluptatem sint ea eaque.', 'Non at culpa.', '0', '2023-12-20 23:15:49', '2023-12-20 23:15:49'),
(22, 'Quisquam quo earum.', '2023-04-23', '2023-04-30', 'Aut facere quas consequatur ut alias totam.', 'Sit consequatur.', '0', '2023-12-20 23:15:49', '2023-12-20 23:15:49'),
(23, 'Optio molestiae est.', '2023-10-20', '2023-10-27', 'Animi perferendis voluptas recusandae.', 'Et quia voluptatem.', '0', '2023-12-20 23:15:49', '2023-12-20 23:15:49'),
(24, 'Aut voluptatibus est.', '2023-07-13', '2023-07-20', 'Provident corrupti quas sit qui et ullam.', 'Eligendi rerum.', '0', '2023-12-20 23:15:49', '2023-12-20 23:15:49'),
(25, 'Ut quia.', '2024-01-06', '2024-01-13', 'Dolor corrupti voluptatem quia.', 'Ducimus et ipsum.', '0', '2023-12-20 23:15:49', '2023-12-20 23:15:49'),
(26, 'Sunt odit odio.', '2024-02-08', '2024-02-15', 'Numquam cupiditate omnis id optio omnis sunt.', 'Voluptatibus optio sunt.', '0', '2023-12-20 23:15:49', '2023-12-20 23:15:49'),
(27, 'Dolores reiciendis iure.', '2023-09-06', '2023-09-13', 'Ut eum sint sint eaque consequatur.', 'Ea aspernatur in.', '0', '2023-12-20 23:15:49', '2023-12-20 23:15:49'),
(28, 'Asperiores qui.', '2023-09-17', '2023-09-24', 'Minima rerum omnis quam amet.', 'Rerum eius delectus.', '0', '2023-12-20 23:15:49', '2023-12-20 23:15:49'),
(29, 'Dicta est.', '2023-11-01', '2023-11-08', 'Aperiam eos voluptatem optio.', 'Ipsam ad ea.', '0', '2023-12-20 23:15:49', '2023-12-20 23:15:49'),
(30, 'Similique soluta.', '2023-09-26', '2023-10-03', 'Excepturi officiis ut nobis aut qui.', 'Quasi et.', '0', '2023-12-20 23:15:49', '2023-12-20 23:15:49'),
(31, 'Nulla maxime.', '2023-04-13', '2023-04-20', 'Delectus dicta nostrum et tenetur hic quibusdam.', 'Tenetur cumque.', '0', '2023-12-20 23:15:49', '2023-12-20 23:15:49'),
(32, 'Animi aperiam non.', '2023-09-26', '2023-10-03', 'Tempore sed illo deserunt est maxime.', 'Nam voluptatum.', '0', '2023-12-20 23:15:49', '2023-12-20 23:15:49'),
(33, 'Voluptatem dolores.', '2023-11-17', '2023-11-24', 'Qui debitis in minus qui in.', 'Dolore nobis voluptatem.', '0', '2023-12-20 23:15:49', '2023-12-20 23:15:49'),
(34, 'Rerum corporis nostrum.', '2023-11-09', '2023-11-16', 'Aliquid sunt fugit assumenda quod temporibus.', 'Ut id.', '0', '2023-12-20 23:15:49', '2023-12-20 23:15:49'),
(35, 'Sit magni est.', '2024-01-04', '2024-01-11', 'Sequi dolor aut ipsam beatae voluptate illum et.', 'Doloribus sit.', '0', '2023-12-20 23:15:49', '2023-12-20 23:15:49'),
(36, 'Iste non.', '2023-02-16', '2023-02-23', 'Error et beatae libero excepturi.', 'Ut omnis.', '0', '2023-12-20 23:15:49', '2023-12-20 23:15:49'),
(37, 'Nam aut.', '2023-04-16', '2023-04-23', 'Totam itaque enim hic nesciunt.', 'Eum consequatur.', '0', '2023-12-20 23:15:49', '2023-12-20 23:15:49'),
(38, 'Quam similique eum.', '2023-07-26', '2023-08-02', 'Et quasi facilis tempore autem autem quo.', 'Dolore voluptatem doloremque.', '0', '2023-12-20 23:15:49', '2023-12-20 23:15:49'),
(39, 'Voluptatibus distinctio.', '2023-08-08', '2023-08-15', 'Perferendis eum aperiam voluptatem.', 'Sit explicabo.', '0', '2023-12-20 23:15:49', '2023-12-20 23:15:49'),
(40, 'Esse voluptatem.', '2023-12-11', '2023-12-18', 'Provident est consequatur explicabo.', 'Accusantium dignissimos animi.', '0', '2023-12-20 23:15:49', '2023-12-20 23:15:49');

-- --------------------------------------------------------

--
-- Table structure for table `keluarga`
--

CREATE TABLE `keluarga` (
  `id_keluarga` int UNSIGNED NOT NULL,
  `nama` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `gender` enum('laki-laki','perempuan') COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('hidup','meninggal') COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_users` int UNSIGNED NOT NULL,
  `id_hubungan` int UNSIGNED NOT NULL,
  `is_deleted` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kode_surat`
--

CREATE TABLE `kode_surat` (
  `id_kode_surat` int UNSIGNED NOT NULL,
  `divisi` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kode_surat` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_deleted` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `kode_surat`
--

INSERT INTO `kode_surat` (`id_kode_surat`, `divisi`, `kode_surat`, `is_deleted`, `created_at`, `updated_at`) VALUES
(1, 'Direktur', 'I', '0', '2023-12-20 23:15:49', '2023-12-20 23:15:49'),
(2, 'DDA', 'I.B', '0', '2023-12-20 23:15:49', '2023-12-20 23:15:49'),
(3, 'DDP', 'I.A', '0', '2023-12-20 23:15:49', '2023-12-20 23:15:49'),
(4, 'HRGA', 'II.E', '0', '2023-12-20 23:15:49', '2023-12-20 23:15:49'),
(5, 'PPR', 'II.D', '0', '2023-12-20 23:15:49', '2023-12-20 23:15:49'),
(6, 'ICT', 'II.C', '0', '2023-12-20 23:15:49', '2023-12-20 23:15:49'),
(7, 'RDP', 'II.B', '0', '2023-12-20 23:15:49', '2023-12-20 23:15:49'),
(8, 'Training', 'II.A', '0', '2023-12-20 23:15:49', '2023-12-20 23:15:49'),
(9, 'Keuangan', 'II.F', '0', '2023-12-20 23:15:49', '2023-12-20 23:15:49'),
(10, 'Keuangan', 'II.F', '0', '2023-12-20 23:15:49', '2023-12-20 23:15:49');

-- --------------------------------------------------------

--
-- Table structure for table `lembur`
--

CREATE TABLE `lembur` (
  `id_lembur` int UNSIGNED NOT NULL,
  `kode_finger` int UNSIGNED NOT NULL,
  `id_atasan` int UNSIGNED NOT NULL,
  `tanggal` date NOT NULL,
  `jam_mulai` time NOT NULL,
  `jam_selesai` time NOT NULL,
  `jam_lembur` time NOT NULL,
  `tugas` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status_izin_atasan` enum('0','1') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alasan_ditolak_atasan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_deleted` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(2, '2023_07_17_134323_create_kegiatan_table', 1),
(3, '2023_07_17_140432_create_jabatan_table', 1),
(4, '2023_07_19_022028_create_users_table', 1),
(5, '2023_07_19_022329_create_password_reset_tokens_table', 1),
(6, '2023_07_19_022519_create_failed_jobs_table', 1),
(7, '2023_07_19_023231_create_personal_access_tokens_table', 1),
(8, '2023_07_19_023244_create_password_resets_table', 1),
(9, '2023_07_24_125616_create_tingkat_pendidikan_table', 1),
(10, '2023_07_24_130002_create_profile_user_table', 1),
(11, '2023_07_24_130016_create_pendidikan_table', 1),
(12, '2023_07_24_130028_create_pengalaman_kerja_table', 1),
(13, '2023_07_24_130030_create_jenis_diklat_table', 1),
(14, '2023_07_24_130038_create_diklat_table', 1),
(15, '2023_07_24_130047_create_arsip_table', 1),
(16, '2023_07_24_130131_create_hubungan_keluarga_table', 1),
(17, '2023_07_24_130137_create_keluarga_table', 1),
(18, '2023_07_27_200816_create_peran_table', 1),
(19, '2023_07_27_203650_create_tim_kegiatan_table', 1),
(20, '2023_08_02_061422_create_presensi_table', 1),
(21, '2023_08_02_061435_create_perizinan_table', 1),
(22, '2023_08_02_061447_create_cuti_table', 1),
(23, '2023_08_02_061508_create_lembur_table', 1),
(24, '2023_08_03_041241_create_settings_table', 1),
(25, '2023_09_14_032731_create_notifikasi_table', 1),
(26, '2023_09_15_013810_create_url_table', 1),
(27, '2023_09_15_014125_create_kode_surat_table', 1),
(28, '2023_09_15_014210_create_surat_table', 1),
(29, '2023_09_17_061109_create_email_configuration_table', 1),
(30, '2023_11_02_063038_create_ruangan_table', 1),
(31, '2023_11_02_064220_create_barang_tik_table', 1),
(32, '2023_11_02_064819_create_peminjaman_barang_table', 1),
(33, '2023_11_02_064829_create_detail_peminjaman_barang_table', 1),
(34, '2023_11_02_065822_create_barang_ppr_table', 1),
(35, '2023_11_03_080856_create_sirkulasi_barang_table', 1),
(36, '2023_11_13_030601_create_pengajuan_zoom_table', 1),
(37, '2023_11_13_031004_create_pengajuan_singlelink_table', 1),
(38, '2023_11_13_042250_create_pengajuan_blastemail_table', 1),
(39, '2023_11_24_042950_create_pengajuan_form_table', 1),
(40, '2023_11_24_044928_create_pengajuan_perbaikan_table', 1),
(41, '2023_11_24_063228_create_pengajuan_desain_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `notifikasi`
--

CREATE TABLE `notifikasi` (
  `id_notifikasi` int UNSIGNED NOT NULL,
  `judul` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pesan` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `label` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `link` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_dibaca` enum('dibaca','tidak_dibaca') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'tidak_dibaca',
  `send_email` enum('yes','no') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'yes',
  `id_users` int UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `peminjaman_barang`
--

CREATE TABLE `peminjaman_barang` (
  `id_peminjaman` int UNSIGNED NOT NULL,
  `id_users` int UNSIGNED NOT NULL,
  `tgl_ajuan` date NOT NULL,
  `tgl_peminjaman` date NOT NULL,
  `tgl_pengembalian` date NOT NULL,
  `kegiatan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('belum_diajukan','diajukan','dipinjam','dikembalikan','dikembalikan_sebagian') COLLATE utf8mb4_unicode_ci NOT NULL,
  `keterangan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_deleted` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pendidikan`
--

CREATE TABLE `pendidikan` (
  `id_pendidikan` int UNSIGNED NOT NULL,
  `nama_sekolah` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jurusan` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tahun_lulus` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ijazah` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_users` int UNSIGNED NOT NULL,
  `id_tingkat_pendidikan` int UNSIGNED NOT NULL,
  `is_deleted` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pengajuan_blastemail`
--

CREATE TABLE `pengajuan_blastemail` (
  `id_pengajuan_blastemail` int UNSIGNED NOT NULL,
  `id_users` int UNSIGNED NOT NULL,
  `tgl_pengajuan` date NOT NULL,
  `jenis_blast` enum('Sertifikat Kegiatan','Surat Undangan','Informasi Lainnya') COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_kegiatan` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `keterangan_pemohon` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `lampiran` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_operator` enum('Hana','Bayu','Wendy','Siswa Magang','Lainnya') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tgl_kirim` date DEFAULT NULL,
  `keterangan_operator` text COLLATE utf8mb4_unicode_ci,
  `status` enum('diajukan','selesai') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'diajukan',
  `is_deleted` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pengajuan_desain`
--

CREATE TABLE `pengajuan_desain` (
  `id_pengajuan_desain` int UNSIGNED NOT NULL,
  `id_users` int UNSIGNED NOT NULL,
  `tgl_pengajuan` date NOT NULL,
  `nama_kegiatan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tempat_kegiatan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tgl_kegiatan` date NOT NULL,
  `tgl_digunakan` date NOT NULL,
  `jenis_desain` enum('Cover Petunjuk Teknis','Cover Laporan','Cover Dokumen Pedukung','Cover Materi','Nametag','Spanduk Indoor','Spanduk Outdoor','Sertifikat','Social Media Feeds','Web-banner','Lainnya') COLLATE utf8mb4_unicode_ci NOT NULL,
  `ukuran` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lampiran_pendukung` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lampiran_qrcode` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `no_sertifikat` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `keterangan_pemohon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `keterangan` text COLLATE utf8mb4_unicode_ci,
  `lampiran_desain` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('diajukan','diproses','dicek_kadiv','disetujui_kadiv','revisi','selesai') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'diajukan',
  `is_deleted` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pengajuan_form`
--

CREATE TABLE `pengajuan_form` (
  `id_pengajuan_form` int UNSIGNED NOT NULL,
  `id_users` int UNSIGNED NOT NULL,
  `tgl_pengajuan` date NOT NULL,
  `jenis_form` enum('Biodata','Daftar Hadir','Evaluasi','Konfirmasi Keikutsertaan','Pendaftaran','Pengumpulan Tugas','Validasi') COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_kegiatan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tgl_digunakan` date NOT NULL,
  `bahasa` enum('Indonesia','Inggris') COLLATE utf8mb4_unicode_ci NOT NULL,
  `template` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contoh` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shortlink` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kolaborator` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `keterangan_pemohon` text COLLATE utf8mb4_unicode_ci,
  `nama_operator` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tautan_form` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('diajukan','diproses','ready') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'diajukan',
  `is_deleted` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pengajuan_perbaikan`
--

CREATE TABLE `pengajuan_perbaikan` (
  `id_pengajuan_perbaikan` int UNSIGNED NOT NULL,
  `id_users` int UNSIGNED NOT NULL,
  `tgl_pengajuan` date NOT NULL,
  `id_barang_tik` int UNSIGNED NOT NULL,
  `keterangan_pemohon` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_operator` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `keterangan_operator` text COLLATE utf8mb4_unicode_ci,
  `tgl_pengecekan` date DEFAULT NULL,
  `tgl_selesai` date DEFAULT NULL,
  `status` enum('diajukan','diproses','selesai') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'diajukan',
  `is_deleted` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pengajuan_singlelink`
--

CREATE TABLE `pengajuan_singlelink` (
  `id_pengajuan_singlelink` int UNSIGNED NOT NULL,
  `id_users` int UNSIGNED NOT NULL,
  `tgl_pengajuan` date NOT NULL,
  `nama_kegiatan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_shortlink` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `keterangan_pemohon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `keterangan_operator` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('diajukan','ready') COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_deleted` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pengajuan_zoom`
--

CREATE TABLE `pengajuan_zoom` (
  `id_pengajuan_zoom` int UNSIGNED NOT NULL,
  `id_users` int UNSIGNED NOT NULL,
  `tgl_pengajuan` date NOT NULL,
  `jenis_zoom` enum('meeting','webinar') COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_kegiatan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jumlah_peserta` int NOT NULL,
  `tgl_pelaksanaan` date NOT NULL,
  `jam_mulai` time NOT NULL,
  `jam_selesai` time NOT NULL,
  `keterangan_pemohon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `keterangan_operator` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nama_operator` enum('Hana','Bayu','Wendy','Siswa Magang','Lainnya') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `akun_zoom` enum('ict.seaqil@gmail.com','training.qiteplanguage.org','seameoqil@gmail.com') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tautan_zoom` text COLLATE utf8mb4_unicode_ci,
  `status` enum('diajukan','ready') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_deleted` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pengalaman_kerja`
--

CREATE TABLE `pengalaman_kerja` (
  `id_pengalaman_kerja` int UNSIGNED NOT NULL,
  `nama_perusahaan` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `masa_kerja` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_kerja` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `posisi` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_users` int UNSIGNED NOT NULL,
  `is_deleted` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `peran`
--

CREATE TABLE `peran` (
  `id_peran` int UNSIGNED NOT NULL,
  `nama_peran` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_deleted` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `peran`
--

INSERT INTO `peran` (`id_peran`, `nama_peran`, `is_deleted`, `created_at`, `updated_at`) VALUES
(1, 'Pembawa Acara', '0', '2023-12-20 23:15:47', '2023-12-20 23:15:47'),
(2, 'Panitia', '0', '2023-12-20 23:15:47', '2023-12-20 23:15:47');

-- --------------------------------------------------------

--
-- Table structure for table `perizinan`
--

CREATE TABLE `perizinan` (
  `id_perizinan` int UNSIGNED NOT NULL,
  `id_atasan` int UNSIGNED DEFAULT NULL,
  `kode_finger` varchar(8) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jenis_perizinan` enum('I','DL','S','CS','Prajab','CT','CM','CAP','CH','CB','A','TB') COLLATE utf8mb4_unicode_ci NOT NULL,
  `tgl_ajuan` date NOT NULL,
  `tgl_absen_awal` date NOT NULL,
  `tgl_absen_akhir` date NOT NULL,
  `keterangan` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_perizinan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status_izin_atasan` enum('0','1') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alasan_ditolak_atasan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status_izin_ppk` enum('0','1') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alasan_ditolak_ppk` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jumlah_hari_pengajuan` int DEFAULT NULL,
  `is_deleted` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens_table`
--

CREATE TABLE `personal_access_tokens_table` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `presensi`
--

CREATE TABLE `presensi` (
  `id_presensi` int UNSIGNED NOT NULL,
  `kode_finger` int UNSIGNED NOT NULL,
  `tanggal` date NOT NULL,
  `jam_masuk` time DEFAULT NULL,
  `jam_pulang` time DEFAULT NULL,
  `terlambat` time DEFAULT NULL,
  `pulang_cepat` time DEFAULT NULL,
  `kehadiran` time DEFAULT NULL,
  `jenis_perizinan` enum('I','DL','S','CS','Prajab','CT','CM','CAP','CH','CB','A','TB') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_deleted` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `profile_user`
--

CREATE TABLE `profile_user` (
  `id_profile_user` int UNSIGNED NOT NULL,
  `nip` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nik` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kk` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gelar_depan` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gelar_belakang` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tempat_lahir` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `alamat` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `no_hp` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `agama` enum('islam','kristen','katolik','hindu','budha','konghucu') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gender` enum('laki-laki','perempuan') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pendidikan` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tmt` date DEFAULT NULL,
  `status_kawin` enum('menikah','belum_menikah') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bpjs` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'no_pp.png',
  `id_users` int UNSIGNED NOT NULL,
  `id_jabatan` int UNSIGNED DEFAULT NULL,
  `id_tingkat_pendidikan` int UNSIGNED DEFAULT NULL,
  `is_deleted` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `profile_user`
--

INSERT INTO `profile_user` (`id_profile_user`, `nip`, `nik`, `kk`, `gelar_depan`, `gelar_belakang`, `tempat_lahir`, `tanggal_lahir`, `alamat`, `no_hp`, `agama`, `gender`, `pendidikan`, `tmt`, `status_kawin`, `bpjs`, `photo`, `id_users`, `id_jabatan`, `id_tingkat_pendidikan`, `is_deleted`, `created_at`, `updated_at`) VALUES
(1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'no_pp.png', 1, NULL, NULL, '0', '2023-12-20 23:15:47', '2023-12-20 23:15:47'),
(2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'no_pp.png', 2, NULL, NULL, '0', '2023-12-20 23:15:47', '2023-12-20 23:15:47'),
(3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'no_pp.png', 3, NULL, NULL, '0', '2023-12-20 23:15:48', '2023-12-20 23:15:48'),
(4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'no_pp.png', 4, NULL, NULL, '0', '2023-12-20 23:15:48', '2023-12-20 23:15:48'),
(5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'no_pp.png', 5, NULL, NULL, '0', '2023-12-20 23:15:48', '2023-12-20 23:15:48'),
(6, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'no_pp.png', 6, NULL, NULL, '0', '2023-12-20 23:15:48', '2023-12-20 23:15:48'),
(7, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'no_pp.png', 7, NULL, NULL, '0', '2023-12-20 23:15:48', '2023-12-20 23:15:48'),
(8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'no_pp.png', 8, NULL, NULL, '0', '2023-12-20 23:15:48', '2023-12-20 23:15:48'),
(9, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'no_pp.png', 9, NULL, NULL, '0', '2023-12-20 23:15:49', '2023-12-20 23:15:49'),
(10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'no_pp.png', 10, NULL, NULL, '0', '2023-12-20 23:15:49', '2023-12-20 23:15:49'),
(11, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'no_pp.png', 11, NULL, NULL, '0', '2023-12-20 23:15:49', '2023-12-20 23:15:49'),
(12, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'no_pp.png', 12, NULL, NULL, '0', '2023-12-20 23:15:49', '2023-12-20 23:15:49'),
(13, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'no_pp.png', 13, NULL, NULL, '0', '2023-12-20 23:15:49', '2023-12-20 23:15:49'),
(14, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'no_pp.png', 14, NULL, NULL, '0', '2023-12-20 23:15:49', '2023-12-20 23:15:49'),
(15, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'no_pp.png', 15, NULL, NULL, '0', '2023-12-20 23:15:49', '2023-12-20 23:15:49'),
(16, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'no_pp.png', 16, NULL, NULL, '0', '2023-12-20 23:15:49', '2023-12-20 23:15:49'),
(17, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'no_pp.png', 17, NULL, NULL, '0', '2023-12-20 23:15:49', '2023-12-20 23:15:49'),
(18, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'no_pp.png', 18, NULL, NULL, '0', '2023-12-20 23:15:49', '2023-12-20 23:15:49'),
(19, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'no_pp.png', 19, NULL, NULL, '0', '2023-12-20 23:15:49', '2023-12-20 23:15:49');

-- --------------------------------------------------------

--
-- Table structure for table `ruangan`
--

CREATE TABLE `ruangan` (
  `id_ruangan` int UNSIGNED NOT NULL,
  `nama_ruangan` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_deleted` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ruangan`
--

INSERT INTO `ruangan` (`id_ruangan`, `nama_ruangan`, `is_deleted`, `created_at`, `updated_at`) VALUES
(1, 'Master Control', '0', '2023-12-20 23:15:49', '2023-12-20 23:15:49'),
(2, 'Studio', '0', '2023-12-20 23:15:49', '2023-12-20 23:15:49'),
(3, 'Ruang Rapat', '0', '2023-12-20 23:15:49', '2023-12-20 23:15:49');

-- --------------------------------------------------------

--
-- Table structure for table `setting`
--

CREATE TABLE `setting` (
  `id_setting` int UNSIGNED NOT NULL,
  `tahun_aktif` varchar(4) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_users` int UNSIGNED NOT NULL,
  `status` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_deleted` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `setting`
--

INSERT INTO `setting` (`id_setting`, `tahun_aktif`, `id_users`, `status`, `is_deleted`, `created_at`, `updated_at`) VALUES
(1, '2023', 4, '1', '0', '2023-12-20 23:15:49', '2023-12-20 23:15:49');

-- --------------------------------------------------------

--
-- Table structure for table `sirkulasi_barang`
--

CREATE TABLE `sirkulasi_barang` (
  `id_sirkulasi_barang` int UNSIGNED NOT NULL,
  `id_barang_ppr` int UNSIGNED NOT NULL,
  `id_users` int UNSIGNED NOT NULL,
  `tgl_sirkulasi` date NOT NULL,
  `jumlah` int NOT NULL,
  `jenis_sirkulasi` enum('Penambahan','Pengurangan') COLLATE utf8mb4_unicode_ci NOT NULL,
  `keterangan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_deleted` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `surat`
--

CREATE TABLE `surat` (
  `id_surat` int UNSIGNED NOT NULL,
  `no_surat` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jenis_surat` enum('nota_dinas','notula_rapat','sertifikat_kegiatan','sertifikat_magang','surat_keluar') COLLATE utf8mb4_unicode_ci NOT NULL,
  `urutan` int NOT NULL,
  `tgl_surat` date NOT NULL,
  `keterangan` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bulan_kegiatan` enum('I','II','III','IV','V','VI','VII','VIII','IX','X','XI','XII') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `id_users` int UNSIGNED NOT NULL,
  `id_kode_surat` int UNSIGNED NOT NULL,
  `is_deleted` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tim_kegiatan`
--

CREATE TABLE `tim_kegiatan` (
  `id_tim` int UNSIGNED NOT NULL,
  `id_kegiatan` int UNSIGNED NOT NULL,
  `id_users` int UNSIGNED NOT NULL,
  `id_peran` int UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tim_kegiatan`
--

INSERT INTO `tim_kegiatan` (`id_tim`, `id_kegiatan`, `id_users`, `id_peran`, `created_at`, `updated_at`) VALUES
(1, 25, 9, 2, '2023-12-20 23:15:49', '2023-12-20 23:15:49'),
(2, 25, 1, 2, '2023-12-20 23:15:49', '2023-12-20 23:15:49'),
(3, 6, 2, 1, '2023-12-20 23:15:49', '2023-12-20 23:15:49'),
(4, 39, 4, 1, '2023-12-20 23:15:49', '2023-12-20 23:15:49'),
(5, 18, 4, 2, '2023-12-20 23:15:49', '2023-12-20 23:15:49'),
(6, 17, 11, 2, '2023-12-20 23:15:49', '2023-12-20 23:15:49'),
(7, 12, 4, 1, '2023-12-20 23:15:49', '2023-12-20 23:15:49'),
(8, 36, 10, 2, '2023-12-20 23:15:49', '2023-12-20 23:15:49'),
(9, 34, 6, 2, '2023-12-20 23:15:49', '2023-12-20 23:15:49'),
(10, 16, 2, 2, '2023-12-20 23:15:49', '2023-12-20 23:15:49'),
(11, 22, 7, 2, '2023-12-20 23:15:49', '2023-12-20 23:15:49'),
(12, 6, 2, 1, '2023-12-20 23:15:49', '2023-12-20 23:15:49'),
(13, 15, 10, 2, '2023-12-20 23:15:49', '2023-12-20 23:15:49'),
(14, 8, 3, 1, '2023-12-20 23:15:49', '2023-12-20 23:15:49'),
(15, 31, 3, 2, '2023-12-20 23:15:49', '2023-12-20 23:15:49'),
(16, 10, 3, 1, '2023-12-20 23:15:49', '2023-12-20 23:15:49'),
(17, 30, 10, 1, '2023-12-20 23:15:49', '2023-12-20 23:15:49'),
(18, 18, 2, 2, '2023-12-20 23:15:49', '2023-12-20 23:15:49'),
(19, 6, 7, 1, '2023-12-20 23:15:49', '2023-12-20 23:15:49'),
(20, 37, 2, 1, '2023-12-20 23:15:49', '2023-12-20 23:15:49'),
(21, 12, 9, 2, '2023-12-20 23:15:49', '2023-12-20 23:15:49'),
(22, 26, 10, 2, '2023-12-20 23:15:49', '2023-12-20 23:15:49'),
(23, 7, 5, 2, '2023-12-20 23:15:49', '2023-12-20 23:15:49'),
(24, 4, 1, 1, '2023-12-20 23:15:49', '2023-12-20 23:15:49'),
(25, 12, 7, 2, '2023-12-20 23:15:49', '2023-12-20 23:15:49'),
(26, 27, 8, 1, '2023-12-20 23:15:49', '2023-12-20 23:15:49'),
(27, 39, 8, 1, '2023-12-20 23:15:49', '2023-12-20 23:15:49'),
(28, 24, 5, 1, '2023-12-20 23:15:49', '2023-12-20 23:15:49'),
(29, 9, 1, 1, '2023-12-20 23:15:49', '2023-12-20 23:15:49'),
(30, 5, 3, 2, '2023-12-20 23:15:49', '2023-12-20 23:15:49'),
(31, 33, 1, 2, '2023-12-20 23:15:49', '2023-12-20 23:15:49'),
(32, 16, 7, 2, '2023-12-20 23:15:49', '2023-12-20 23:15:49'),
(33, 25, 12, 2, '2023-12-20 23:15:49', '2023-12-20 23:15:49'),
(34, 3, 4, 1, '2023-12-20 23:15:49', '2023-12-20 23:15:49'),
(35, 21, 5, 1, '2023-12-20 23:15:49', '2023-12-20 23:15:49'),
(36, 9, 7, 2, '2023-12-20 23:15:49', '2023-12-20 23:15:49'),
(37, 15, 8, 2, '2023-12-20 23:15:49', '2023-12-20 23:15:49'),
(38, 31, 2, 2, '2023-12-20 23:15:49', '2023-12-20 23:15:49'),
(39, 24, 6, 2, '2023-12-20 23:15:49', '2023-12-20 23:15:49'),
(40, 1, 12, 2, '2023-12-20 23:15:49', '2023-12-20 23:15:49');

-- --------------------------------------------------------

--
-- Table structure for table `tingkat_pendidikan`
--

CREATE TABLE `tingkat_pendidikan` (
  `id_tingkat_pendidikan` int UNSIGNED NOT NULL,
  `nama_tingkat_pendidikan` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_deleted` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tingkat_pendidikan`
--

INSERT INTO `tingkat_pendidikan` (`id_tingkat_pendidikan`, `nama_tingkat_pendidikan`, `is_deleted`, `created_at`, `updated_at`) VALUES
(1, 'Sarjana', '0', '2023-12-20 23:15:47', '2023-12-20 23:15:47'),
(2, 'Magister', '0', '2023-12-20 23:15:47', '2023-12-20 23:15:47'),
(3, 'Doktor', '0', '2023-12-20 23:15:47', '2023-12-20 23:15:47');

-- --------------------------------------------------------

--
-- Table structure for table `url`
--

CREATE TABLE `url` (
  `id_url` int UNSIGNED NOT NULL,
  `url_short` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `url_address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `qrcode_image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jenis` enum('Form','Sertifikat','Laporan','Single-link','Zoom','Leaflet') COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_users` int UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id_users` int UNSIGNED NOT NULL,
  `nama_pegawai` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `_password_` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_jabatan` int UNSIGNED DEFAULT NULL,
  `level` enum('admin','bod','ppk','kadiv','staf') COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_deleted` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `kode_finger` int UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id_users`, `nama_pegawai`, `email`, `password`, `_password_`, `id_jabatan`, `level`, `is_deleted`, `kode_finger`, `created_at`, `updated_at`) VALUES
(1, 'almer', 'kevinalmer4@gmail.com', '$2y$10$LsyBRTrcc.kKlDp/i3Gab.0pLfua6fSbQbF.zcayrYT2ymPmvnD.6', '12345678', 4, 'staf', '0', 82121, '2023-12-20 23:15:47', '2023-12-20 23:15:47'),
(2, 'Admin', 'admin@admin.com', '$2y$10$zCmKriYQH1EYZTDWpx.xueLSrx4H45/ggl2w2oo2gtMmNpPT2nLzu', '12345678', 1, 'admin', '0', 88121, '2023-12-20 23:15:47', '2023-12-20 23:15:47'),
(3, 'kadiv', 'kadiv@kadiv.com', '$2y$10$CNqgxTlxMH7bq7XGvw8PV.0k/M8nUVFp.sRWHbIXCixhoN9du98Vm', '12345678', 2, 'kadiv', '0', 989898, '2023-12-20 23:15:48', '2023-12-20 23:15:48'),
(4, 'Kadiv Tik', 'ghina.athaya05@gmail.com', '$2y$10$phr.LEUEgNBJzNE78GSTOu1/GoRSSNVAcAIeScf9eFNj5DEpa38Vm', '12345678', 8, 'kadiv', '0', 989898, '2023-12-20 23:15:48', '2023-12-20 23:15:48'),
(5, 'Kadiv KSHM', 'fadiahnurafidah@gmail.com', '$2y$10$.avmvaIa4UUENGDpxv1rq.P2wIWUdaAXAAZhNJiJl6/ySL9/EvHTa', '12345678', 9, 'kadiv', '0', 989390, '2023-12-20 23:15:48', '2023-12-20 23:15:48'),
(6, 'bod', 'bod@bod.com', '$2y$10$cYeU0T7BIX/5mEdhinRb0O003y1m4Oa76hx4bxJwqOuambKvzHmsC', '12345678', 6, 'bod', '0', 919898, '2023-12-20 23:15:48', '2023-12-20 23:15:48'),
(7, 'ppk', 'ppk@ppk.com', '$2y$10$.XrjSOVqT/KLvl4Oo1sU.OTf5ia6B36G63dz.lMkcWWmlWHA3Nx/W', '12345678', 6, 'ppk', '0', 983898, '2023-12-20 23:15:48', '2023-12-20 23:15:48'),
(8, 'staf', 'staf@staf.com', '$2y$10$dV2rCJ6TUfb4vzFPn5dDzuopecxuAAeEH6JwJBlD.HUThibOQZ/56', '12345678', 4, 'staf', '0', 545621, '2023-12-20 23:15:48', '2023-12-20 23:15:48'),
(9, 'direktur', 'direktur@direktur.com', '$2y$10$5twv2r..xE9xd71woBaCd.aU4.ALI9NhzKS3./lBES6KMH.zWL.5K', '12345678', 7, 'bod', '0', 784028, '2023-12-20 23:15:48', '2023-12-20 23:15:48'),
(10, 'Giles D\'Amore', 'elfrieda42@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'password', 1, 'staf', '0', 84534, '2023-12-20 23:15:49', '2023-12-20 23:15:49'),
(11, 'Birdie Reilly I', 'sbruen@example.org', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'password', 3, 'staf', '0', 60646, '2023-12-20 23:15:49', '2023-12-20 23:15:49'),
(12, 'Taryn Reynolds', 'ferry.bryon@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'password', 2, 'staf', '0', 43465, '2023-12-20 23:15:49', '2023-12-20 23:15:49'),
(13, 'Issac Batz', 'jratke@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'password', 1, 'staf', '0', 88678, '2023-12-20 23:15:49', '2023-12-20 23:15:49'),
(14, 'Dr. Alanna Ratke', 'angelita50@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'password', 3, 'staf', '0', 41264, '2023-12-20 23:15:49', '2023-12-20 23:15:49'),
(15, 'Prof. Reva Bradtke', 'rhiannon.gulgowski@example.org', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'password', 1, 'staf', '0', 657, '2023-12-20 23:15:49', '2023-12-20 23:15:49'),
(16, 'Mercedes Schmitt', 'roma.runte@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'password', 2, 'staf', '0', 68852, '2023-12-20 23:15:49', '2023-12-20 23:15:49'),
(17, 'Jacky Upton DVM', 'alf69@example.org', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'password', 1, 'staf', '0', 14320, '2023-12-20 23:15:49', '2023-12-20 23:15:49'),
(18, 'Letitia Littel', 'cara.stokes@example.net', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'password', 3, 'staf', '0', 49225, '2023-12-20 23:15:49', '2023-12-20 23:15:49'),
(19, 'Braden Hirthe', 'alice13@example.net', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'password', 2, 'staf', '0', 18255, '2023-12-20 23:15:49', '2023-12-20 23:15:49');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `arsip`
--
ALTER TABLE `arsip`
  ADD PRIMARY KEY (`id_arsip`),
  ADD KEY `arsip_id_users_foreign` (`id_users`);

--
-- Indexes for table `barang_ppr`
--
ALTER TABLE `barang_ppr`
  ADD PRIMARY KEY (`id_barang_ppr`),
  ADD KEY `barang_ppr_id_ruangan_foreign` (`id_ruangan`);

--
-- Indexes for table `barang_tik`
--
ALTER TABLE `barang_tik`
  ADD PRIMARY KEY (`id_barang_tik`),
  ADD KEY `barang_tik_id_ruangan_foreign` (`id_ruangan`);

--
-- Indexes for table `cuti`
--
ALTER TABLE `cuti`
  ADD PRIMARY KEY (`id_cuti`),
  ADD KEY `cuti_id_users_foreign` (`id_users`);

--
-- Indexes for table `detail_peminjaman_barang`
--
ALTER TABLE `detail_peminjaman_barang`
  ADD PRIMARY KEY (`id_detail_peminjaman`);

--
-- Indexes for table `diklat`
--
ALTER TABLE `diklat`
  ADD PRIMARY KEY (`id_diklat`),
  ADD KEY `diklat_id_users_foreign` (`id_users`),
  ADD KEY `diklat_id_jenis_diklat_foreign` (`id_jenis_diklat`);

--
-- Indexes for table `email_configuration`
--
ALTER TABLE `email_configuration`
  ADD PRIMARY KEY (`id_email_configuration`);

--
-- Indexes for table `failed_jobs_table`
--
ALTER TABLE `failed_jobs_table`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_table_uuid_unique` (`uuid`);

--
-- Indexes for table `hubungan_keluarga`
--
ALTER TABLE `hubungan_keluarga`
  ADD PRIMARY KEY (`id_hubungan`);

--
-- Indexes for table `jabatan`
--
ALTER TABLE `jabatan`
  ADD PRIMARY KEY (`id_jabatan`);

--
-- Indexes for table `jenis_diklat`
--
ALTER TABLE `jenis_diklat`
  ADD PRIMARY KEY (`id_jenis_diklat`);

--
-- Indexes for table `kegiatan`
--
ALTER TABLE `kegiatan`
  ADD PRIMARY KEY (`id_kegiatan`);

--
-- Indexes for table `keluarga`
--
ALTER TABLE `keluarga`
  ADD PRIMARY KEY (`id_keluarga`),
  ADD KEY `keluarga_id_users_foreign` (`id_users`),
  ADD KEY `keluarga_id_hubungan_foreign` (`id_hubungan`);

--
-- Indexes for table `kode_surat`
--
ALTER TABLE `kode_surat`
  ADD PRIMARY KEY (`id_kode_surat`);

--
-- Indexes for table `lembur`
--
ALTER TABLE `lembur`
  ADD PRIMARY KEY (`id_lembur`),
  ADD KEY `lembur_kode_finger_foreign` (`kode_finger`),
  ADD KEY `lembur_id_atasan_foreign` (`id_atasan`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifikasi`
--
ALTER TABLE `notifikasi`
  ADD PRIMARY KEY (`id_notifikasi`),
  ADD KEY `notifikasi_id_users_foreign` (`id_users`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `peminjaman_barang`
--
ALTER TABLE `peminjaman_barang`
  ADD PRIMARY KEY (`id_peminjaman`),
  ADD KEY `peminjaman_barang_id_users_foreign` (`id_users`);

--
-- Indexes for table `pendidikan`
--
ALTER TABLE `pendidikan`
  ADD PRIMARY KEY (`id_pendidikan`),
  ADD KEY `pendidikan_id_users_foreign` (`id_users`),
  ADD KEY `pendidikan_id_tingkat_pendidikan_foreign` (`id_tingkat_pendidikan`);

--
-- Indexes for table `pengajuan_blastemail`
--
ALTER TABLE `pengajuan_blastemail`
  ADD PRIMARY KEY (`id_pengajuan_blastemail`),
  ADD KEY `pengajuan_blastemail_id_users_foreign` (`id_users`);

--
-- Indexes for table `pengajuan_desain`
--
ALTER TABLE `pengajuan_desain`
  ADD PRIMARY KEY (`id_pengajuan_desain`),
  ADD KEY `pengajuan_desain_id_users_foreign` (`id_users`);

--
-- Indexes for table `pengajuan_form`
--
ALTER TABLE `pengajuan_form`
  ADD PRIMARY KEY (`id_pengajuan_form`),
  ADD KEY `pengajuan_form_id_users_foreign` (`id_users`);

--
-- Indexes for table `pengajuan_perbaikan`
--
ALTER TABLE `pengajuan_perbaikan`
  ADD PRIMARY KEY (`id_pengajuan_perbaikan`),
  ADD KEY `pengajuan_perbaikan_id_users_foreign` (`id_users`),
  ADD KEY `pengajuan_perbaikan_id_barang_tik_foreign` (`id_barang_tik`);

--
-- Indexes for table `pengajuan_singlelink`
--
ALTER TABLE `pengajuan_singlelink`
  ADD PRIMARY KEY (`id_pengajuan_singlelink`),
  ADD KEY `pengajuan_singlelink_id_users_foreign` (`id_users`);

--
-- Indexes for table `pengajuan_zoom`
--
ALTER TABLE `pengajuan_zoom`
  ADD PRIMARY KEY (`id_pengajuan_zoom`),
  ADD KEY `pengajuan_zoom_id_users_foreign` (`id_users`);

--
-- Indexes for table `pengalaman_kerja`
--
ALTER TABLE `pengalaman_kerja`
  ADD PRIMARY KEY (`id_pengalaman_kerja`),
  ADD KEY `pengalaman_kerja_id_users_foreign` (`id_users`);

--
-- Indexes for table `peran`
--
ALTER TABLE `peran`
  ADD PRIMARY KEY (`id_peran`);

--
-- Indexes for table `perizinan`
--
ALTER TABLE `perizinan`
  ADD PRIMARY KEY (`id_perizinan`),
  ADD KEY `perizinan_id_atasan_foreign` (`id_atasan`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `personal_access_tokens_table`
--
ALTER TABLE `personal_access_tokens_table`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_table_token_unique` (`token`),
  ADD KEY `personal_access_tokens_table_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `presensi`
--
ALTER TABLE `presensi`
  ADD PRIMARY KEY (`id_presensi`),
  ADD KEY `presensi_kode_finger_foreign` (`kode_finger`);

--
-- Indexes for table `profile_user`
--
ALTER TABLE `profile_user`
  ADD PRIMARY KEY (`id_profile_user`),
  ADD KEY `profile_user_id_users_foreign` (`id_users`),
  ADD KEY `profile_user_id_jabatan_foreign` (`id_jabatan`),
  ADD KEY `profile_user_id_tingkat_pendidikan_foreign` (`id_tingkat_pendidikan`);

--
-- Indexes for table `ruangan`
--
ALTER TABLE `ruangan`
  ADD PRIMARY KEY (`id_ruangan`);

--
-- Indexes for table `setting`
--
ALTER TABLE `setting`
  ADD PRIMARY KEY (`id_setting`),
  ADD KEY `setting_id_users_foreign` (`id_users`);

--
-- Indexes for table `sirkulasi_barang`
--
ALTER TABLE `sirkulasi_barang`
  ADD PRIMARY KEY (`id_sirkulasi_barang`),
  ADD KEY `sirkulasi_barang_id_users_foreign` (`id_users`),
  ADD KEY `sirkulasi_barang_id_barang_ppr_foreign` (`id_barang_ppr`);

--
-- Indexes for table `surat`
--
ALTER TABLE `surat`
  ADD PRIMARY KEY (`id_surat`),
  ADD KEY `surat_id_users_foreign` (`id_users`),
  ADD KEY `surat_id_kode_surat_foreign` (`id_kode_surat`);

--
-- Indexes for table `tim_kegiatan`
--
ALTER TABLE `tim_kegiatan`
  ADD PRIMARY KEY (`id_tim`),
  ADD KEY `tim_kegiatan_id_kegiatan_foreign` (`id_kegiatan`),
  ADD KEY `tim_kegiatan_id_users_foreign` (`id_users`),
  ADD KEY `tim_kegiatan_id_peran_foreign` (`id_peran`);

--
-- Indexes for table `tingkat_pendidikan`
--
ALTER TABLE `tingkat_pendidikan`
  ADD PRIMARY KEY (`id_tingkat_pendidikan`);

--
-- Indexes for table `url`
--
ALTER TABLE `url`
  ADD PRIMARY KEY (`id_url`),
  ADD KEY `url_id_users_foreign` (`id_users`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_users`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_id_jabatan_foreign` (`id_jabatan`),
  ADD KEY `users_kode_finger_index` (`kode_finger`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `arsip`
--
ALTER TABLE `arsip`
  MODIFY `id_arsip` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `barang_ppr`
--
ALTER TABLE `barang_ppr`
  MODIFY `id_barang_ppr` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `barang_tik`
--
ALTER TABLE `barang_tik`
  MODIFY `id_barang_tik` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `cuti`
--
ALTER TABLE `cuti`
  MODIFY `id_cuti` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `detail_peminjaman_barang`
--
ALTER TABLE `detail_peminjaman_barang`
  MODIFY `id_detail_peminjaman` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `diklat`
--
ALTER TABLE `diklat`
  MODIFY `id_diklat` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `email_configuration`
--
ALTER TABLE `email_configuration`
  MODIFY `id_email_configuration` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `failed_jobs_table`
--
ALTER TABLE `failed_jobs_table`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hubungan_keluarga`
--
ALTER TABLE `hubungan_keluarga`
  MODIFY `id_hubungan` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `jabatan`
--
ALTER TABLE `jabatan`
  MODIFY `id_jabatan` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `jenis_diklat`
--
ALTER TABLE `jenis_diklat`
  MODIFY `id_jenis_diklat` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `kegiatan`
--
ALTER TABLE `kegiatan`
  MODIFY `id_kegiatan` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `keluarga`
--
ALTER TABLE `keluarga`
  MODIFY `id_keluarga` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kode_surat`
--
ALTER TABLE `kode_surat`
  MODIFY `id_kode_surat` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `lembur`
--
ALTER TABLE `lembur`
  MODIFY `id_lembur` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `notifikasi`
--
ALTER TABLE `notifikasi`
  MODIFY `id_notifikasi` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `peminjaman_barang`
--
ALTER TABLE `peminjaman_barang`
  MODIFY `id_peminjaman` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pendidikan`
--
ALTER TABLE `pendidikan`
  MODIFY `id_pendidikan` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pengajuan_blastemail`
--
ALTER TABLE `pengajuan_blastemail`
  MODIFY `id_pengajuan_blastemail` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pengajuan_desain`
--
ALTER TABLE `pengajuan_desain`
  MODIFY `id_pengajuan_desain` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pengajuan_form`
--
ALTER TABLE `pengajuan_form`
  MODIFY `id_pengajuan_form` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pengajuan_perbaikan`
--
ALTER TABLE `pengajuan_perbaikan`
  MODIFY `id_pengajuan_perbaikan` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pengajuan_singlelink`
--
ALTER TABLE `pengajuan_singlelink`
  MODIFY `id_pengajuan_singlelink` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pengajuan_zoom`
--
ALTER TABLE `pengajuan_zoom`
  MODIFY `id_pengajuan_zoom` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pengalaman_kerja`
--
ALTER TABLE `pengalaman_kerja`
  MODIFY `id_pengalaman_kerja` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `peran`
--
ALTER TABLE `peran`
  MODIFY `id_peran` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `perizinan`
--
ALTER TABLE `perizinan`
  MODIFY `id_perizinan` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `personal_access_tokens_table`
--
ALTER TABLE `personal_access_tokens_table`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `presensi`
--
ALTER TABLE `presensi`
  MODIFY `id_presensi` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `profile_user`
--
ALTER TABLE `profile_user`
  MODIFY `id_profile_user` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `ruangan`
--
ALTER TABLE `ruangan`
  MODIFY `id_ruangan` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `setting`
--
ALTER TABLE `setting`
  MODIFY `id_setting` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `sirkulasi_barang`
--
ALTER TABLE `sirkulasi_barang`
  MODIFY `id_sirkulasi_barang` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `surat`
--
ALTER TABLE `surat`
  MODIFY `id_surat` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tim_kegiatan`
--
ALTER TABLE `tim_kegiatan`
  MODIFY `id_tim` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `tingkat_pendidikan`
--
ALTER TABLE `tingkat_pendidikan`
  MODIFY `id_tingkat_pendidikan` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `url`
--
ALTER TABLE `url`
  MODIFY `id_url` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id_users` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `arsip`
--
ALTER TABLE `arsip`
  ADD CONSTRAINT `arsip_id_users_foreign` FOREIGN KEY (`id_users`) REFERENCES `users` (`id_users`) ON DELETE CASCADE;

--
-- Constraints for table `barang_ppr`
--
ALTER TABLE `barang_ppr`
  ADD CONSTRAINT `barang_ppr_id_ruangan_foreign` FOREIGN KEY (`id_ruangan`) REFERENCES `ruangan` (`id_ruangan`) ON DELETE CASCADE;

--
-- Constraints for table `barang_tik`
--
ALTER TABLE `barang_tik`
  ADD CONSTRAINT `barang_tik_id_ruangan_foreign` FOREIGN KEY (`id_ruangan`) REFERENCES `ruangan` (`id_ruangan`) ON DELETE CASCADE;

--
-- Constraints for table `cuti`
--
ALTER TABLE `cuti`
  ADD CONSTRAINT `cuti_id_users_foreign` FOREIGN KEY (`id_users`) REFERENCES `users` (`id_users`) ON DELETE CASCADE;

--
-- Constraints for table `diklat`
--
ALTER TABLE `diklat`
  ADD CONSTRAINT `diklat_id_jenis_diklat_foreign` FOREIGN KEY (`id_jenis_diklat`) REFERENCES `jenis_diklat` (`id_jenis_diklat`) ON DELETE CASCADE,
  ADD CONSTRAINT `diklat_id_users_foreign` FOREIGN KEY (`id_users`) REFERENCES `users` (`id_users`) ON DELETE CASCADE;

--
-- Constraints for table `keluarga`
--
ALTER TABLE `keluarga`
  ADD CONSTRAINT `keluarga_id_hubungan_foreign` FOREIGN KEY (`id_hubungan`) REFERENCES `hubungan_keluarga` (`id_hubungan`) ON DELETE CASCADE,
  ADD CONSTRAINT `keluarga_id_users_foreign` FOREIGN KEY (`id_users`) REFERENCES `users` (`id_users`) ON DELETE CASCADE;

--
-- Constraints for table `lembur`
--
ALTER TABLE `lembur`
  ADD CONSTRAINT `lembur_id_atasan_foreign` FOREIGN KEY (`id_atasan`) REFERENCES `users` (`id_users`) ON DELETE CASCADE,
  ADD CONSTRAINT `lembur_kode_finger_foreign` FOREIGN KEY (`kode_finger`) REFERENCES `users` (`kode_finger`) ON DELETE CASCADE;

--
-- Constraints for table `notifikasi`
--
ALTER TABLE `notifikasi`
  ADD CONSTRAINT `notifikasi_id_users_foreign` FOREIGN KEY (`id_users`) REFERENCES `users` (`id_users`) ON DELETE CASCADE;

--
-- Constraints for table `peminjaman_barang`
--
ALTER TABLE `peminjaman_barang`
  ADD CONSTRAINT `peminjaman_barang_id_users_foreign` FOREIGN KEY (`id_users`) REFERENCES `users` (`id_users`) ON DELETE CASCADE;

--
-- Constraints for table `pendidikan`
--
ALTER TABLE `pendidikan`
  ADD CONSTRAINT `pendidikan_id_tingkat_pendidikan_foreign` FOREIGN KEY (`id_tingkat_pendidikan`) REFERENCES `tingkat_pendidikan` (`id_tingkat_pendidikan`) ON DELETE CASCADE,
  ADD CONSTRAINT `pendidikan_id_users_foreign` FOREIGN KEY (`id_users`) REFERENCES `users` (`id_users`) ON DELETE CASCADE;

--
-- Constraints for table `pengajuan_blastemail`
--
ALTER TABLE `pengajuan_blastemail`
  ADD CONSTRAINT `pengajuan_blastemail_id_users_foreign` FOREIGN KEY (`id_users`) REFERENCES `users` (`id_users`);

--
-- Constraints for table `pengajuan_desain`
--
ALTER TABLE `pengajuan_desain`
  ADD CONSTRAINT `pengajuan_desain_id_users_foreign` FOREIGN KEY (`id_users`) REFERENCES `users` (`id_users`) ON DELETE CASCADE;

--
-- Constraints for table `pengajuan_form`
--
ALTER TABLE `pengajuan_form`
  ADD CONSTRAINT `pengajuan_form_id_users_foreign` FOREIGN KEY (`id_users`) REFERENCES `users` (`id_users`) ON DELETE CASCADE;

--
-- Constraints for table `pengajuan_perbaikan`
--
ALTER TABLE `pengajuan_perbaikan`
  ADD CONSTRAINT `pengajuan_perbaikan_id_barang_tik_foreign` FOREIGN KEY (`id_barang_tik`) REFERENCES `barang_tik` (`id_barang_tik`) ON DELETE CASCADE,
  ADD CONSTRAINT `pengajuan_perbaikan_id_users_foreign` FOREIGN KEY (`id_users`) REFERENCES `users` (`id_users`) ON DELETE CASCADE;

--
-- Constraints for table `pengajuan_singlelink`
--
ALTER TABLE `pengajuan_singlelink`
  ADD CONSTRAINT `pengajuan_singlelink_id_users_foreign` FOREIGN KEY (`id_users`) REFERENCES `users` (`id_users`) ON DELETE CASCADE;

--
-- Constraints for table `pengajuan_zoom`
--
ALTER TABLE `pengajuan_zoom`
  ADD CONSTRAINT `pengajuan_zoom_id_users_foreign` FOREIGN KEY (`id_users`) REFERENCES `users` (`id_users`) ON DELETE CASCADE;

--
-- Constraints for table `pengalaman_kerja`
--
ALTER TABLE `pengalaman_kerja`
  ADD CONSTRAINT `pengalaman_kerja_id_users_foreign` FOREIGN KEY (`id_users`) REFERENCES `users` (`id_users`) ON DELETE CASCADE;

--
-- Constraints for table `perizinan`
--
ALTER TABLE `perizinan`
  ADD CONSTRAINT `perizinan_id_atasan_foreign` FOREIGN KEY (`id_atasan`) REFERENCES `users` (`id_users`) ON DELETE CASCADE;

--
-- Constraints for table `presensi`
--
ALTER TABLE `presensi`
  ADD CONSTRAINT `presensi_kode_finger_foreign` FOREIGN KEY (`kode_finger`) REFERENCES `users` (`kode_finger`) ON DELETE CASCADE;

--
-- Constraints for table `profile_user`
--
ALTER TABLE `profile_user`
  ADD CONSTRAINT `profile_user_id_jabatan_foreign` FOREIGN KEY (`id_jabatan`) REFERENCES `jabatan` (`id_jabatan`) ON DELETE CASCADE,
  ADD CONSTRAINT `profile_user_id_tingkat_pendidikan_foreign` FOREIGN KEY (`id_tingkat_pendidikan`) REFERENCES `tingkat_pendidikan` (`id_tingkat_pendidikan`) ON DELETE CASCADE,
  ADD CONSTRAINT `profile_user_id_users_foreign` FOREIGN KEY (`id_users`) REFERENCES `users` (`id_users`) ON DELETE CASCADE;

--
-- Constraints for table `setting`
--
ALTER TABLE `setting`
  ADD CONSTRAINT `setting_id_users_foreign` FOREIGN KEY (`id_users`) REFERENCES `users` (`id_users`) ON DELETE CASCADE;

--
-- Constraints for table `sirkulasi_barang`
--
ALTER TABLE `sirkulasi_barang`
  ADD CONSTRAINT `sirkulasi_barang_id_barang_ppr_foreign` FOREIGN KEY (`id_barang_ppr`) REFERENCES `barang_ppr` (`id_barang_ppr`),
  ADD CONSTRAINT `sirkulasi_barang_id_users_foreign` FOREIGN KEY (`id_users`) REFERENCES `users` (`id_users`);

--
-- Constraints for table `surat`
--
ALTER TABLE `surat`
  ADD CONSTRAINT `surat_id_kode_surat_foreign` FOREIGN KEY (`id_kode_surat`) REFERENCES `kode_surat` (`id_kode_surat`) ON DELETE CASCADE,
  ADD CONSTRAINT `surat_id_users_foreign` FOREIGN KEY (`id_users`) REFERENCES `users` (`id_users`) ON DELETE CASCADE;

--
-- Constraints for table `tim_kegiatan`
--
ALTER TABLE `tim_kegiatan`
  ADD CONSTRAINT `tim_kegiatan_id_kegiatan_foreign` FOREIGN KEY (`id_kegiatan`) REFERENCES `kegiatan` (`id_kegiatan`) ON DELETE CASCADE,
  ADD CONSTRAINT `tim_kegiatan_id_peran_foreign` FOREIGN KEY (`id_peran`) REFERENCES `peran` (`id_peran`) ON DELETE CASCADE,
  ADD CONSTRAINT `tim_kegiatan_id_users_foreign` FOREIGN KEY (`id_users`) REFERENCES `users` (`id_users`) ON DELETE CASCADE;

--
-- Constraints for table `url`
--
ALTER TABLE `url`
  ADD CONSTRAINT `url_id_users_foreign` FOREIGN KEY (`id_users`) REFERENCES `users` (`id_users`) ON DELETE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_id_jabatan_foreign` FOREIGN KEY (`id_jabatan`) REFERENCES `jabatan` (`id_jabatan`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
