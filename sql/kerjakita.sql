-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 05 Feb 2026 pada 06.59
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kerjakita`
--

DELIMITER $$
--
-- Prosedur
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_cari_lowongan` (IN `p_keyword` VARCHAR(255), IN `p_lokasi` VARCHAR(255), IN `p_kategori` INT, IN `p_limit` INT, IN `p_offset` INT)   BEGIN
    SELECT DISTINCT l.* FROM v_lowongan_detail l
    LEFT JOIN Lowongan_Kategori lk ON l.idLowongan = lk.idLowongan
    WHERE l.status = 'aktif'
    AND (p_keyword IS NULL OR l.judul LIKE CONCAT('%', p_keyword, '%') OR l.deskripsi LIKE CONCAT('%', p_keyword, '%'))
    AND (p_lokasi IS NULL OR l.lokasi LIKE CONCAT('%', p_lokasi, '%'))
    AND (p_kategori IS NULL OR lk.id_kategori = p_kategori)
    ORDER BY l.created_at DESC
    LIMIT p_limit OFFSET p_offset;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_dashboard_pekerja` (IN `p_idPekerja` INT)   BEGIN
    SELECT 
        (SELECT COUNT(*) FROM Lamaran WHERE idPekerja = p_idPekerja) as total_lamaran,
        (SELECT COUNT(*) FROM Lamaran WHERE idPekerja = p_idPekerja AND status_lamaran = 'pending') as lamaran_pending,
        (SELECT COUNT(*) FROM Lamaran WHERE idPekerja = p_idPekerja AND status_lamaran = 'diterima') as lamaran_diterima,
        (SELECT COUNT(*) FROM Favorit WHERE idPekerja = p_idPekerja) as total_favorit,
        (SELECT COUNT(*) FROM Notifikasi n
         INNER JOIN Pekerja p ON p.idUser = n.idUser
         WHERE p.idPekerja = p_idPekerja AND n.is_read = FALSE) as notifikasi_belum_dibaca;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_dashboard_pemberi_kerja` (IN `p_idPemberiKerja` INT)   BEGIN
    SELECT 
        (SELECT COUNT(*) FROM Lowongan WHERE idPemberiKerja = p_idPemberiKerja) as total_lowongan,
        (SELECT COUNT(*) FROM Lowongan WHERE idPemberiKerja = p_idPemberiKerja AND status = 'aktif') as lowongan_aktif,
        (SELECT COUNT(*) FROM Lamaran lmr 
         INNER JOIN Lowongan l ON lmr.idLowongan = l.idLowongan 
         WHERE l.idPemberiKerja = p_idPemberiKerja) as total_lamaran,
        (SELECT COUNT(*) FROM Lamaran lmr 
         INNER JOIN Lowongan l ON lmr.idLowongan = l.idLowongan 
         WHERE l.idPemberiKerja = p_idPemberiKerja AND lmr.status_lamaran = 'pending') as lamaran_pending,
        (SELECT COUNT(*) FROM Notifikasi n
         INNER JOIN PemberiKerja pk ON pk.idUser = n.idUser
         WHERE pk.idPemberiKerja = p_idPemberiKerja AND n.is_read = FALSE) as notifikasi_belum_dibaca;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `activity_log`
--

CREATE TABLE `activity_log` (
  `id_log` int(11) NOT NULL,
  `idUser` int(11) DEFAULT NULL,
  `activity_type` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `activity_log`
--

INSERT INTO `activity_log` (`id_log`, `idUser`, `activity_type`, `description`, `ip_address`, `created_at`) VALUES
(1, NULL, 'login_failed', 'Gagal login dengan username: john.pemberi@email.com', '127.0.0.1', '2026-02-01 21:00:12'),
(2, NULL, 'login_failed', 'Gagal login dengan username: john.pemberi@email.com', '127.0.0.1', '2026-02-01 21:00:32'),
(3, 1, 'login', 'User login ke sistem', '127.0.0.1', '2026-02-01 21:01:17'),
(4, 4, 'login', 'User login ke sistem', '127.0.0.1', '2026-02-01 21:05:30'),
(5, 1, 'logout', 'User logout dari sistem', '127.0.0.1', '2026-02-01 21:38:14'),
(6, 2, 'login', 'User login ke sistem', '127.0.0.1', '2026-02-01 21:38:43'),
(7, 2, 'logout', 'User logout dari sistem', '127.0.0.1', '2026-02-01 21:43:25'),
(8, 2, 'login', 'User login ke sistem', '127.0.0.1', '2026-02-01 21:43:38'),
(9, 2, 'logout', 'User logout dari sistem', '127.0.0.1', '2026-02-01 21:43:48'),
(10, 1, 'login', 'User login ke sistem', '127.0.0.1', '2026-02-01 21:43:56'),
(11, 1, 'logout', 'User logout dari sistem', '127.0.0.1', '2026-02-01 22:03:38'),
(12, 1, 'login', 'User login ke sistem', '127.0.0.1', '2026-02-01 22:03:49'),
(13, 1, 'logout', 'User logout dari sistem', '127.0.0.1', '2026-02-01 22:16:37'),
(14, 1, 'login', 'User login ke sistem', '127.0.0.1', '2026-02-01 22:16:46'),
(15, 1, 'logout', 'User logout dari sistem', '127.0.0.1', '2026-02-01 22:34:43'),
(16, 4, 'login', 'User login ke sistem', '127.0.0.1', '2026-02-01 22:35:20'),
(17, 4, 'logout', 'User logout dari sistem', '127.0.0.1', '2026-02-01 22:39:56'),
(18, 1, 'login', 'User login ke sistem', '127.0.0.1', '2026-02-01 22:40:10'),
(19, 1, 'logout', 'User logout dari sistem', '127.0.0.1', '2026-02-01 22:43:15'),
(20, 1, 'login', 'User login ke sistem', '127.0.0.1', '2026-02-01 22:43:30'),
(21, 5, 'register', 'User baru mendaftar sebagai Pekerja', '127.0.0.1', '2026-02-02 22:17:24'),
(22, 5, 'login', 'User login ke sistem', '127.0.0.1', '2026-02-02 22:17:35'),
(23, 5, 'logout', 'User logout dari sistem', '127.0.0.1', '2026-02-02 22:18:12'),
(24, NULL, 'login_failed', 'Gagal login dengan username: Bhadriko', '127.0.0.1', '2026-02-02 22:24:12'),
(25, 5, 'login', 'User login ke sistem', '127.0.0.1', '2026-02-02 22:24:18'),
(26, NULL, 'login_failed', 'Gagal login dengan username: Bhadriko', '127.0.0.1', '2026-02-02 22:54:15'),
(27, 5, 'login', 'User login ke sistem', '127.0.0.1', '2026-02-02 22:54:24'),
(28, 6, 'register', 'User baru mendaftar sebagai PemberiKerja', '127.0.0.1', '2026-02-02 22:57:09'),
(29, 6, 'login', 'User login ke sistem', '127.0.0.1', '2026-02-02 22:57:18'),
(30, 6, 'logout', 'User logout dari sistem', '127.0.0.1', '2026-02-02 23:01:13'),
(31, 5, 'login', 'User login ke sistem', '127.0.0.1', '2026-02-02 23:01:30'),
(32, 5, 'login', 'User login ke sistem', '127.0.0.1', '2026-02-02 23:07:07'),
(33, 5, 'logout', 'User logout dari sistem', '127.0.0.1', '2026-02-03 00:27:11'),
(34, 6, 'login', 'User login ke sistem', '127.0.0.1', '2026-02-03 00:27:19'),
(35, 1, 'login', 'User login ke sistem', '127.0.0.1', '2026-02-04 19:57:20'),
(36, 1, 'logout', 'User logout dari sistem', '127.0.0.1', '2026-02-04 19:59:18'),
(37, 2, 'login', 'User login ke sistem', '127.0.0.1', '2026-02-04 19:59:38'),
(38, 2, 'logout', 'User logout dari sistem', '127.0.0.1', '2026-02-04 20:00:03'),
(39, 5, 'login', 'User login ke sistem', '127.0.0.1', '2026-02-04 20:00:48'),
(40, 5, 'logout', 'User logout dari sistem', '127.0.0.1', '2026-02-04 20:01:02'),
(41, 2, 'login', 'User login ke sistem', '127.0.0.1', '2026-02-04 20:01:19'),
(42, 2, 'logout', 'User logout dari sistem', '127.0.0.1', '2026-02-04 20:05:11'),
(43, 1, 'login', 'User login ke sistem', '127.0.0.1', '2026-02-04 20:05:29'),
(44, 5, 'login', 'User login ke sistem', '127.0.0.1', '2026-02-04 20:08:44'),
(45, 1, 'logout', 'User logout dari sistem', '127.0.0.1', '2026-02-04 20:33:48'),
(46, 1, 'login', 'User login ke sistem', '127.0.0.1', '2026-02-04 20:34:04'),
(47, 1, 'logout', 'User logout dari sistem', '127.0.0.1', '2026-02-04 20:40:50'),
(48, 1, 'login', 'User login ke sistem', '127.0.0.1', '2026-02-04 20:40:57'),
(49, 1, 'logout', 'User logout dari sistem', '127.0.0.1', '2026-02-04 20:43:15'),
(50, 3, 'login', 'User login ke sistem', '127.0.0.1', '2026-02-04 20:43:35'),
(51, 3, 'logout', 'User logout dari sistem', '127.0.0.1', '2026-02-04 21:07:33'),
(52, 1, 'login', 'User login ke sistem', '127.0.0.1', '2026-02-04 21:07:40'),
(53, 1, 'logout', 'User logout dari sistem', '127.0.0.1', '2026-02-04 21:10:45'),
(54, 1, 'login', 'User login ke sistem', '127.0.0.1', '2026-02-04 21:17:43'),
(55, 1, 'logout', 'User logout dari sistem', '127.0.0.1', '2026-02-04 21:17:57'),
(56, 6, 'login', 'User login ke sistem', '127.0.0.1', '2026-02-04 21:18:19'),
(57, 6, 'logout', 'User logout dari sistem', '127.0.0.1', '2026-02-04 21:23:11'),
(58, 3, 'login', 'User login ke sistem', '127.0.0.1', '2026-02-04 21:23:40'),
(59, 3, 'logout', 'User logout dari sistem', '127.0.0.1', '2026-02-04 21:23:55'),
(60, 1, 'login', 'User login ke sistem', '127.0.0.1', '2026-02-04 21:24:04'),
(61, 5, 'logout', 'User logout dari sistem', '127.0.0.1', '2026-02-04 21:41:30'),
(62, 4, 'login', 'User login ke sistem', '127.0.0.1', '2026-02-04 21:42:04'),
(63, 4, 'logout', 'User logout dari sistem', '127.0.0.1', '2026-02-04 21:57:43'),
(64, 4, 'login', 'User login ke sistem', '127.0.0.1', '2026-02-04 21:57:53'),
(65, 4, 'logout', 'User logout dari sistem', '127.0.0.1', '2026-02-04 22:01:35'),
(66, 2, 'login', 'User login ke sistem', '127.0.0.1', '2026-02-04 22:02:15'),
(67, 1, 'logout', 'User logout dari sistem', '127.0.0.1', '2026-02-04 22:07:05'),
(68, 6, 'login', 'User login ke sistem', '127.0.0.1', '2026-02-04 22:07:27'),
(69, 6, 'logout', 'User logout dari sistem', '127.0.0.1', '2026-02-04 22:33:59'),
(70, 5, 'login', 'User login ke sistem', '127.0.0.1', '2026-02-04 22:34:46');

-- --------------------------------------------------------

--
-- Struktur dari tabel `chat_conversation`
--

CREATE TABLE `chat_conversation` (
  `id_conversation` int(11) NOT NULL,
  `idPekerja` int(11) NOT NULL,
  `idPemberiKerja` int(11) NOT NULL,
  `idLowongan` int(11) DEFAULT NULL,
  `last_message_time` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `chat_message`
--

CREATE TABLE `chat_message` (
  `id_message` int(11) NOT NULL,
  `id_conversation` int(11) NOT NULL,
  `id_sender` int(11) NOT NULL,
  `message_text` text NOT NULL,
  `is_read` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Trigger `chat_message`
--
DELIMITER $$
CREATE TRIGGER `after_message_insert` AFTER INSERT ON `chat_message` FOR EACH ROW BEGIN
    UPDATE Chat_Conversation 
    SET last_message_time = NEW.created_at 
    WHERE id_conversation = NEW.id_conversation;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `favorit`
--

CREATE TABLE `favorit` (
  `id_favorit` int(11) NOT NULL,
  `idPekerja` int(11) NOT NULL,
  `idLowongan` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `kategori`
--

CREATE TABLE `kategori` (
  `id_kategori` int(11) NOT NULL,
  `nama_kategori` varchar(100) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `kategori`
--

INSERT INTO `kategori` (`id_kategori`, `nama_kategori`, `deskripsi`, `created_at`) VALUES
(1, 'Cleaning', 'Pekerjaan kebersihan rumah, kantor, dll', '2026-02-01 07:01:15'),
(2, 'Konstruksi', 'Pekerjaan tukang bangunan, renovasi', '2026-02-01 07:01:15'),
(3, 'Asisten Rumah Tangga', 'Pekerjaan memasak, mengurus rumah', '2026-02-01 07:01:15'),
(4, 'Tukang Kebun', 'Pekerjaan perawatan taman', '2026-02-01 07:01:15'),
(5, 'Angkut Barang', 'Pekerjaan pindahan dan angkut barang', '2026-02-01 07:01:15'),
(6, 'Perbaikan', 'Pekerjaan service AC, elektronik, dll', '2026-02-01 07:01:15'),
(7, 'Jaga Toko', 'Pekerjaan menjaga toko atau warung', '2026-02-01 07:01:15'),
(8, 'Cuci Kendaraan', 'Pekerjaan mencuci motor atau mobil', '2026-02-01 07:01:15'),
(9, 'Digital', 'Pekerjaan digital seperti desain, programming, dll', '2026-02-01 16:08:29');

-- --------------------------------------------------------

--
-- Struktur dari tabel `lamaran`
--

CREATE TABLE `lamaran` (
  `idLamaran` int(11) NOT NULL,
  `idLowongan` int(11) NOT NULL,
  `idPekerja` int(11) NOT NULL,
  `tanggal_lamaran` date NOT NULL,
  `status_lamaran` varchar(50) DEFAULT 'pending',
  `is_read` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `lamaran`
--

INSERT INTO `lamaran` (`idLamaran`, `idLowongan`, `idPekerja`, `tanggal_lamaran`, `status_lamaran`, `is_read`, `created_at`, `updated_at`) VALUES
(1, 1, 1, '0000-00-00', 'diterima', 1, '2026-02-05 05:21:19', '2026-02-05 05:21:19'),
(2, 2, 1, '0000-00-00', 'tertarik', 0, '2026-02-05 05:21:19', '2026-02-05 05:21:19'),
(3, 3, 1, '0000-00-00', 'ditolak', 1, '2026-02-05 05:21:19', '2026-02-05 05:21:19'),
(4, 4, 2, '0000-00-00', 'diterima', 1, '2026-02-05 05:21:19', '2026-02-05 05:21:19'),
(5, 5, 2, '0000-00-00', 'tertarik', 0, '2026-02-05 05:21:19', '2026-02-05 05:21:19'),
(6, 1, 3, '0000-00-00', 'diterima', 1, '2026-02-05 05:21:19', '2026-02-05 05:21:19'),
(7, 6, 3, '0000-00-00', 'tertarik', 0, '2026-02-05 05:21:19', '2026-02-05 05:21:19');

-- --------------------------------------------------------

--
-- Struktur dari tabel `lowongan`
--

CREATE TABLE `lowongan` (
  `idLowongan` int(11) NOT NULL,
  `idPemberiKerja` int(11) NOT NULL,
  `judul` varchar(255) NOT NULL,
  `deskripsi` text NOT NULL,
  `gambar` text DEFAULT NULL,
  `lokasi` varchar(255) NOT NULL,
  `upah` decimal(15,2) DEFAULT NULL,
  `status` varchar(50) DEFAULT 'aktif',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `lowongan`
--

INSERT INTO `lowongan` (`idLowongan`, `idPemberiKerja`, `judul`, `deskripsi`, `gambar`, `lokasi`, `upah`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 'Developer Backend PHP', 'Dibutuhkan developer PHP berpengalaman untuk project web application', NULL, 'Bandung', 1500000.00, 'aktif', '2026-02-05 05:21:19', '2026-02-05 05:21:19'),
(2, 1, 'UI/UX Designer', 'Desain interface untuk aplikasi mobile yang user-friendly', NULL, 'Bandung', 1200000.00, 'aktif', '2026-02-05 05:21:19', '2026-02-05 05:21:19'),
(3, 1, 'Frontend Developer React', 'Developer React untuk membuat dashboard interactive', NULL, 'Bandung', 1300000.00, 'aktif', '2026-02-05 05:21:19', '2026-02-05 05:21:19'),
(4, 2, 'Content Writer Profesional', 'Menulis artikel berkualitas untuk blog perusahaan kami', NULL, 'Jakarta', 800000.00, 'aktif', '2026-02-05 05:21:19', '2026-02-05 05:21:19'),
(5, 2, 'Social Media Manager', 'Kelola social media dan buat konten menarik', NULL, 'Jakarta', 900000.00, 'aktif', '2026-02-05 05:21:19', '2026-02-05 05:21:19'),
(6, 2, 'Graphic Designer Junior', 'Desain grafis untuk kebutuhan marketing dan branding', NULL, 'Jakarta', 700000.00, 'draft', '2026-02-05 05:21:19', '2026-02-05 05:21:19'),
(7, 3, 'Virtual Assistant', 'Bantu admin dan koordinasi meeting', NULL, 'Surabaya', 600000.00, 'aktif', '2026-02-05 05:21:19', '2026-02-05 05:21:19'),
(8, 3, 'Data Entry Specialist', 'Input dan verifikasi data dengan akurat', NULL, 'Surabaya', 500000.00, 'aktif', '2026-02-05 05:21:19', '2026-02-05 05:21:19'),
(9, 1, 'Developer Backend PHP', 'Dibutuhkan developer PHP berpengalaman untuk project web application', NULL, 'Bandung', 1500000.00, 'aktif', '2026-02-05 05:22:19', '2026-02-05 05:22:19'),
(10, 1, 'UI/UX Designer', 'Desain interface untuk aplikasi mobile yang user-friendly', NULL, 'Bandung', 1200000.00, 'aktif', '2026-02-05 05:22:19', '2026-02-05 05:22:19'),
(11, 1, 'Frontend Developer React', 'Developer React untuk membuat dashboard interactive', NULL, 'Bandung', 1300000.00, 'aktif', '2026-02-05 05:22:19', '2026-02-05 05:22:19'),
(12, 2, 'Content Writer Profesional', 'Menulis artikel berkualitas untuk blog perusahaan kami', NULL, 'Jakarta', 800000.00, 'aktif', '2026-02-05 05:22:19', '2026-02-05 05:22:19'),
(13, 2, 'Social Media Manager', 'Kelola social media dan buat konten menarik', NULL, 'Jakarta', 900000.00, 'aktif', '2026-02-05 05:22:19', '2026-02-05 05:22:19'),
(14, 2, 'Graphic Designer Junior', 'Desain grafis untuk kebutuhan marketing dan branding', NULL, 'Jakarta', 700000.00, 'draft', '2026-02-05 05:22:19', '2026-02-05 05:22:19'),
(15, 3, 'Virtual Assistant', 'Bantu admin dan koordinasi meeting', NULL, 'Surabaya', 600000.00, 'aktif', '2026-02-05 05:22:19', '2026-02-05 05:22:19'),
(16, 3, 'Data Entry Specialist', 'Input dan verifikasi data dengan akurat', NULL, 'Surabaya', 500000.00, 'aktif', '2026-02-05 05:22:19', '2026-02-05 05:22:19'),
(17, 1, 'Developer Backend PHP', 'Dibutuhkan developer PHP berpengalaman untuk project web application', NULL, 'Bandung', 1500000.00, 'aktif', '2026-02-05 05:22:45', '2026-02-05 05:22:45'),
(18, 1, 'UI/UX Designer', 'Desain interface untuk aplikasi mobile yang user-friendly', NULL, 'Bandung', 1200000.00, 'aktif', '2026-02-05 05:22:45', '2026-02-05 05:22:45'),
(19, 1, 'Frontend Developer React', 'Developer React untuk membuat dashboard interactive', NULL, 'Bandung', 1300000.00, 'aktif', '2026-02-05 05:22:45', '2026-02-05 05:22:45'),
(20, 2, 'Content Writer Profesional', 'Menulis artikel berkualitas untuk blog perusahaan kami', NULL, 'Jakarta', 800000.00, 'aktif', '2026-02-05 05:22:45', '2026-02-05 05:22:45'),
(21, 2, 'Social Media Manager', 'Kelola social media dan buat konten menarik', NULL, 'Jakarta', 900000.00, 'aktif', '2026-02-05 05:22:45', '2026-02-05 05:22:45'),
(22, 2, 'Graphic Designer Junior', 'Desain grafis untuk kebutuhan marketing dan branding', NULL, 'Jakarta', 700000.00, 'draft', '2026-02-05 05:22:45', '2026-02-05 05:22:45'),
(23, 3, 'Virtual Assistant', 'Bantu admin dan koordinasi meeting', NULL, 'Surabaya', 600000.00, 'aktif', '2026-02-05 05:22:45', '2026-02-05 05:22:45'),
(24, 3, 'Data Entry Specialist', 'Input dan verifikasi data dengan akurat', NULL, 'Surabaya', 500000.00, 'aktif', '2026-02-05 05:22:45', '2026-02-05 05:22:45');

-- --------------------------------------------------------

--
-- Struktur dari tabel `lowongan_kategori`
--

CREATE TABLE `lowongan_kategori` (
  `id` int(11) NOT NULL,
  `idLowongan` int(11) NOT NULL,
  `id_kategori` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `notifikasi`
--

CREATE TABLE `notifikasi` (
  `id_notifikasi` int(11) NOT NULL,
  `idUser` int(11) NOT NULL,
  `tipe_notifikasi` varchar(100) NOT NULL,
  `pesan` text NOT NULL,
  `is_read` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `notifikasi`
--

INSERT INTO `notifikasi` (`id_notifikasi`, `idUser`, `tipe_notifikasi`, `pesan`, `is_read`, `created_at`) VALUES
(1, 2, 'rating', 'Anda menerima rating <strong>5 bintang</strong> dari John Doe untuk pekerjaan <strong>Developer Backend PHP</strong>', 0, '2026-02-05 05:22:45'),
(2, 4, 'rating', 'Anda menerima rating <strong>4 bintang</strong> dari Ahmad Rizki untuk pekerjaan <strong>Content Writer Profesional</strong>', 0, '2026-02-05 05:22:45'),
(3, 5, 'rating', 'Anda menerima rating <strong>5 bintang</strong> dari John Doe untuk pekerjaan <strong>Developer Backend PHP</strong>', 0, '2026-02-05 05:22:45');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pekerja`
--

CREATE TABLE `pekerja` (
  `idPekerja` int(11) NOT NULL,
  `idUser` int(11) NOT NULL,
  `usia` int(11) DEFAULT NULL,
  `keahlian` text DEFAULT NULL,
  `pengalaman` text DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `no_telp` varchar(20) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `pekerja`
--

INSERT INTO `pekerja` (`idPekerja`, `idUser`, `usia`, `keahlian`, `pengalaman`, `alamat`, `no_telp`, `created_at`, `updated_at`) VALUES
(1, 2, 23, 'Cleaning, Tukang Bangunan', '3 tahun sebagai pekerja kebersihan', 'Jl. Cibaduyut No. 67, Bandung', '081234567890', '2026-02-01 07:01:14', '2026-02-04 22:02:32'),
(2, 4, NULL, 'Memasak, Mengasuh Anak', '5 tahun sebagai asisten rumah tangga', 'Jl. Buah Batu No. 89, Bandung', '081298765432', '2026-02-01 07:01:14', '2026-02-01 07:01:15'),
(3, 5, 17, 'Front-End Web Developer,Bongkar PC/Letop (no rakit ulang),Jalan 2 kaki', NULL, 'Jln Batukali no 33', '+62 85759412258', '2026-02-03 05:17:24', '2026-02-04 22:39:58');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pekerjaan`
--

CREATE TABLE `pekerjaan` (
  `idPekerjaan` int(11) NOT NULL,
  `idLamaran` int(11) NOT NULL,
  `status_pekerjaan` varchar(50) DEFAULT 'berjalan',
  `tanggal_mulai` date DEFAULT NULL,
  `tanggal_selesai` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `pekerjaan`
--

INSERT INTO `pekerjaan` (`idPekerjaan`, `idLamaran`, `status_pekerjaan`, `tanggal_mulai`, `tanggal_selesai`, `created_at`, `updated_at`) VALUES
(1, 1, 'selesai', '2026-01-01', '2026-01-15', '2026-02-05 05:22:45', '2026-02-05 05:22:45'),
(2, 4, 'selesai', '2026-01-05', '2026-01-20', '2026-02-05 05:22:45', '2026-02-05 05:22:45'),
(3, 6, 'selesai', '2026-01-10', '2026-01-25', '2026-02-05 05:22:45', '2026-02-05 05:22:45');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pemberikerja`
--

CREATE TABLE `pemberikerja` (
  `idPemberiKerja` int(11) NOT NULL,
  `idUser` int(11) NOT NULL,
  `nama_perusahaan` varchar(255) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `no_telp` varchar(20) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `pemberikerja`
--

INSERT INTO `pemberikerja` (`idPemberiKerja`, `idUser`, `nama_perusahaan`, `alamat`, `no_telp`, `created_at`, `updated_at`) VALUES
(1, 1, 'PT Maju Jaya', 'Jl. Dipati Ukur No. 123, Bandung', '022-12345678', '2026-02-01 07:01:14', '2026-02-01 07:01:15'),
(2, 3, 'CV Sejahtera', 'Jl. Dago No. 45, Bandung', '022-87654321', '2026-02-01 07:01:14', '2026-02-01 07:01:15'),
(3, 6, 'Pramudya', NULL, NULL, '2026-02-03 05:57:09', '2026-02-03 05:57:09');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pencarian_log`
--

CREATE TABLE `pencarian_log` (
  `id_pencarian` int(11) NOT NULL,
  `idUser` int(11) DEFAULT NULL,
  `keyword` varchar(255) NOT NULL,
  `lokasi` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `rating`
--

CREATE TABLE `rating` (
  `idRating` int(11) NOT NULL,
  `idPekerjaan` int(11) NOT NULL,
  `nilai_rating` int(11) NOT NULL CHECK (`nilai_rating` >= 1 and `nilai_rating` <= 5),
  `ulasan` text DEFAULT NULL,
  `pemberi_rating` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `rating`
--

INSERT INTO `rating` (`idRating`, `idPekerjaan`, `nilai_rating`, `ulasan`, `pemberi_rating`, `created_at`) VALUES
(1, 1, 5, 'Developer sangat profesional, hasil kode rapi dan tepat waktu. Sangat puas!', 'PemberiKerja', '2026-02-05 05:22:45'),
(2, 2, 4, 'Konten berkualitas, namun perlu waktu sedikit lebih lama. Overall bagus!', 'PemberiKerja', '2026-02-05 05:22:45'),
(3, 3, 5, 'Pekerja sangat responsif dan detail oriented. Hasil excellent!', 'PemberiKerja', '2026-02-05 05:22:45');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `idUser` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `username` varchar(100) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `jenis_kelamin` enum('Laki-laki','Perempuan') DEFAULT NULL,
  `tipe_user` enum('Pekerja','PemberiKerja') NOT NULL,
  `alamat` text DEFAULT NULL,
  `no_hp` varchar(20) DEFAULT NULL,
  `foto_profil` text DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `peran_old` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`idUser`, `nama`, `username`, `email`, `password`, `jenis_kelamin`, `tipe_user`, `alamat`, `no_hp`, `foto_profil`, `remember_token`, `peran_old`, `created_at`, `updated_at`) VALUES
(1, 'John Doe', 'john_doe', 'john.pemberi@email.com', '$2y$12$s.wK4Ut4TGXPfa5otQ37gOVqFNTLnGdyJ4jMIpH9xcnIvu3fEDTr.', 'Laki-laki', 'PemberiKerja', NULL, NULL, NULL, NULL, 'PemberiKerja', '2026-02-01 07:01:14', '2026-02-01 21:01:17'),
(2, 'Jane Smith', 'jane_smith', 'jane.pekerja@email.com', '$2y$12$UIi.uxHWSy2iVuLCYIW9vuVUo2zXfpVUKHWk13sf7q4Rd/z51Dhoa', 'Laki-laki', 'Pekerja', NULL, NULL, 'profil/profil_2_1770260626.png', NULL, 'Pekerja', '2026-02-01 07:01:14', '2026-02-04 22:02:32'),
(3, 'Ahmad Rizki', 'ahmad_rizki', 'ahmad@email.com', '$2y$12$BZ/SCledyeW7U1XVj9/QLO5f0jdK0Ntp/LYfjUhHmqicILOayWjyq', 'Laki-laki', 'PemberiKerja', NULL, NULL, NULL, NULL, 'PemberiKerja', '2026-02-01 07:01:14', '2026-02-04 20:43:35'),
(4, 'Siti Nurhaliza', 'siti_nurhaliza', 'siti@email.com', '$2y$12$YIUj9NxUQymROmU8xdhIy.i9CPPPcYHAob/LvcpvoQJlU26LZCVJ6', 'Laki-laki', 'Pekerja', NULL, NULL, NULL, NULL, 'Pekerja', '2026-02-01 07:01:14', '2026-02-01 21:05:30'),
(5, 'Bhadriko Theo Pramudya', 'Bhadriko', 'bhadriko7@gmail.com', '$2y$12$C21P3T97IEoV2Knl2G0UzekHjx7/H6w4nxMW6HV0B833UJUJh2cBK', 'Laki-laki', 'Pekerja', 'Jln Batukali no 33', '085759412258', 'profil/profil_5_1770269999.png', NULL, NULL, '2026-02-02 22:17:24', '2026-02-04 22:39:59'),
(6, 'Pramudya', 'bayangan_gwehhh', 'bhariko7@gmail.com', '$2y$12$UOVf1RJHsHxnaUYQIcces.1Z8Ckgm1RirK2hfLkbPLzcVaUeVjjHa', 'Laki-laki', 'PemberiKerja', 'Jalan jalan', '085759412258', NULL, NULL, NULL, '2026-02-02 22:57:09', '2026-02-02 22:57:09');

--
-- Trigger `user`
--
DELIMITER $$
CREATE TRIGGER `after_user_insert` AFTER INSERT ON `user` FOR EACH ROW BEGIN
    IF NEW.tipe_user = 'PemberiKerja' THEN
        INSERT INTO PemberiKerja (idUser, nama_perusahaan, created_at, updated_at) 
        VALUES (NEW.idUser, NEW.nama, NOW(), NOW());
    ELSEIF NEW.tipe_user = 'Pekerja' THEN
        INSERT INTO Pekerja (idUser, created_at, updated_at) 
        VALUES (NEW.idUser, NOW(), NOW());
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Stand-in struktur untuk tampilan `v_lamaran_detail`
-- (Lihat di bawah untuk tampilan aktual)
--
CREATE TABLE `v_lamaran_detail` (
`idLamaran` int(11)
,`idLowongan` int(11)
,`idPekerja` int(11)
,`tanggal_lamaran` date
,`status_lamaran` varchar(50)
,`created_at` timestamp
,`updated_at` timestamp
,`judul_lowongan` varchar(255)
,`lokasi` varchar(255)
,`upah` decimal(15,2)
,`keahlian` text
,`pengalaman` text
,`alamat_pekerja` text
,`telp_pekerja` varchar(20)
,`nama_pekerja` varchar(255)
,`email_pekerja` varchar(255)
);

-- --------------------------------------------------------

--
-- Stand-in struktur untuk tampilan `v_lowongan_detail`
-- (Lihat di bawah untuk tampilan aktual)
--
CREATE TABLE `v_lowongan_detail` (
`idLowongan` int(11)
,`idPemberiKerja` int(11)
,`judul` varchar(255)
,`deskripsi` text
,`lokasi` varchar(255)
,`upah` decimal(15,2)
,`status` varchar(50)
,`created_at` timestamp
,`updated_at` timestamp
,`nama_perusahaan` varchar(255)
,`alamat_perusahaan` text
,`telp_perusahaan` varchar(20)
,`nama_pemberi_kerja` varchar(255)
,`email_pemberi_kerja` varchar(255)
,`total_pelamar` bigint(21)
,`kategori` mediumtext
);

-- --------------------------------------------------------

--
-- Stand-in struktur untuk tampilan `v_rating_pekerja`
-- (Lihat di bawah untuk tampilan aktual)
--
CREATE TABLE `v_rating_pekerja` (
`idPekerja` int(11)
,`nama` varchar(255)
,`rating_average` decimal(14,4)
,`total_rating` bigint(21)
);

-- --------------------------------------------------------

--
-- Stand-in struktur untuk tampilan `v_rating_pemberi_kerja`
-- (Lihat di bawah untuk tampilan aktual)
--
CREATE TABLE `v_rating_pemberi_kerja` (
`idPemberiKerja` int(11)
,`nama` varchar(255)
,`rating_average` decimal(14,4)
,`total_rating` bigint(21)
);

-- --------------------------------------------------------

--
-- Struktur untuk view `v_lamaran_detail`
--
DROP TABLE IF EXISTS `v_lamaran_detail`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_lamaran_detail`  AS SELECT `lmr`.`idLamaran` AS `idLamaran`, `lmr`.`idLowongan` AS `idLowongan`, `lmr`.`idPekerja` AS `idPekerja`, `lmr`.`tanggal_lamaran` AS `tanggal_lamaran`, `lmr`.`status_lamaran` AS `status_lamaran`, `lmr`.`created_at` AS `created_at`, `lmr`.`updated_at` AS `updated_at`, `l`.`judul` AS `judul_lowongan`, `l`.`lokasi` AS `lokasi`, `l`.`upah` AS `upah`, `p`.`keahlian` AS `keahlian`, `p`.`pengalaman` AS `pengalaman`, `p`.`alamat` AS `alamat_pekerja`, `p`.`no_telp` AS `telp_pekerja`, `u`.`nama` AS `nama_pekerja`, `u`.`email` AS `email_pekerja` FROM (((`lamaran` `lmr` left join `lowongan` `l` on(`lmr`.`idLowongan` = `l`.`idLowongan`)) left join `pekerja` `p` on(`lmr`.`idPekerja` = `p`.`idPekerja`)) left join `user` `u` on(`p`.`idUser` = `u`.`idUser`)) ;

-- --------------------------------------------------------

--
-- Struktur untuk view `v_lowongan_detail`
--
DROP TABLE IF EXISTS `v_lowongan_detail`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_lowongan_detail`  AS SELECT `l`.`idLowongan` AS `idLowongan`, `l`.`idPemberiKerja` AS `idPemberiKerja`, `l`.`judul` AS `judul`, `l`.`deskripsi` AS `deskripsi`, `l`.`lokasi` AS `lokasi`, `l`.`upah` AS `upah`, `l`.`status` AS `status`, `l`.`created_at` AS `created_at`, `l`.`updated_at` AS `updated_at`, `pk`.`nama_perusahaan` AS `nama_perusahaan`, `pk`.`alamat` AS `alamat_perusahaan`, `pk`.`no_telp` AS `telp_perusahaan`, `u`.`nama` AS `nama_pemberi_kerja`, `u`.`email` AS `email_pemberi_kerja`, (select count(0) from `lamaran` where `lamaran`.`idLowongan` = `l`.`idLowongan`) AS `total_pelamar`, group_concat(`k`.`nama_kategori` separator ', ') AS `kategori` FROM ((((`lowongan` `l` left join `pemberikerja` `pk` on(`l`.`idPemberiKerja` = `pk`.`idPemberiKerja`)) left join `user` `u` on(`pk`.`idUser` = `u`.`idUser`)) left join `lowongan_kategori` `lk` on(`l`.`idLowongan` = `lk`.`idLowongan`)) left join `kategori` `k` on(`lk`.`id_kategori` = `k`.`id_kategori`)) GROUP BY `l`.`idLowongan` ;

-- --------------------------------------------------------

--
-- Struktur untuk view `v_rating_pekerja`
--
DROP TABLE IF EXISTS `v_rating_pekerja`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_rating_pekerja`  AS SELECT `p`.`idPekerja` AS `idPekerja`, `u`.`nama` AS `nama`, avg(`r`.`nilai_rating`) AS `rating_average`, count(`r`.`idRating`) AS `total_rating` FROM ((((`pekerja` `p` left join `user` `u` on(`p`.`idUser` = `u`.`idUser`)) left join `lamaran` `lmr` on(`p`.`idPekerja` = `lmr`.`idPekerja`)) left join `pekerjaan` `pj` on(`lmr`.`idLamaran` = `pj`.`idLamaran`)) left join `rating` `r` on(`pj`.`idPekerjaan` = `r`.`idPekerjaan` and `r`.`pemberi_rating` = 'PemberiKerja')) GROUP BY `p`.`idPekerja` ;

-- --------------------------------------------------------

--
-- Struktur untuk view `v_rating_pemberi_kerja`
--
DROP TABLE IF EXISTS `v_rating_pemberi_kerja`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_rating_pemberi_kerja`  AS SELECT `pk`.`idPemberiKerja` AS `idPemberiKerja`, `u`.`nama` AS `nama`, avg(`r`.`nilai_rating`) AS `rating_average`, count(`r`.`idRating`) AS `total_rating` FROM (((((`pemberikerja` `pk` left join `user` `u` on(`pk`.`idUser` = `u`.`idUser`)) left join `lowongan` `l` on(`pk`.`idPemberiKerja` = `l`.`idPemberiKerja`)) left join `lamaran` `lmr` on(`l`.`idLowongan` = `lmr`.`idLowongan`)) left join `pekerjaan` `pj` on(`lmr`.`idLamaran` = `pj`.`idLamaran`)) left join `rating` `r` on(`pj`.`idPekerjaan` = `r`.`idPekerjaan` and `r`.`pemberi_rating` = 'Pekerja')) GROUP BY `pk`.`idPemberiKerja` ;

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `activity_log`
--
ALTER TABLE `activity_log`
  ADD PRIMARY KEY (`id_log`),
  ADD KEY `idx_user` (`idUser`),
  ADD KEY `idx_created_at` (`created_at`);

--
-- Indeks untuk tabel `chat_conversation`
--
ALTER TABLE `chat_conversation`
  ADD PRIMARY KEY (`id_conversation`),
  ADD UNIQUE KEY `unique_conversation` (`idPekerja`,`idPemberiKerja`,`idLowongan`),
  ADD KEY `idPemberiKerja` (`idPemberiKerja`),
  ADD KEY `idLowongan` (`idLowongan`);

--
-- Indeks untuk tabel `chat_message`
--
ALTER TABLE `chat_message`
  ADD PRIMARY KEY (`id_message`),
  ADD KEY `id_sender` (`id_sender`),
  ADD KEY `idx_conversation` (`id_conversation`),
  ADD KEY `idx_created_at` (`created_at`);

--
-- Indeks untuk tabel `favorit`
--
ALTER TABLE `favorit`
  ADD PRIMARY KEY (`id_favorit`),
  ADD UNIQUE KEY `unique_favorit` (`idPekerja`,`idLowongan`),
  ADD KEY `idLowongan` (`idLowongan`);

--
-- Indeks untuk tabel `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indeks untuk tabel `lamaran`
--
ALTER TABLE `lamaran`
  ADD PRIMARY KEY (`idLamaran`),
  ADD UNIQUE KEY `unique_lamaran` (`idLowongan`,`idPekerja`),
  ADD KEY `idPekerja` (`idPekerja`),
  ADD KEY `idx_status` (`status_lamaran`),
  ADD KEY `idx_tanggal` (`tanggal_lamaran`);

--
-- Indeks untuk tabel `lowongan`
--
ALTER TABLE `lowongan`
  ADD PRIMARY KEY (`idLowongan`),
  ADD KEY `idPemberiKerja` (`idPemberiKerja`),
  ADD KEY `idx_status` (`status`),
  ADD KEY `idx_lokasi` (`lokasi`),
  ADD KEY `idx_created_at` (`created_at`);

--
-- Indeks untuk tabel `lowongan_kategori`
--
ALTER TABLE `lowongan_kategori`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_lowongan_kategori` (`idLowongan`,`id_kategori`),
  ADD KEY `id_kategori` (`id_kategori`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `notifikasi`
--
ALTER TABLE `notifikasi`
  ADD PRIMARY KEY (`id_notifikasi`),
  ADD KEY `idx_user_read` (`idUser`,`is_read`),
  ADD KEY `idx_created_at` (`created_at`);

--
-- Indeks untuk tabel `pekerja`
--
ALTER TABLE `pekerja`
  ADD PRIMARY KEY (`idPekerja`),
  ADD UNIQUE KEY `unique_user_pekerja` (`idUser`);

--
-- Indeks untuk tabel `pekerjaan`
--
ALTER TABLE `pekerjaan`
  ADD PRIMARY KEY (`idPekerjaan`),
  ADD KEY `idLamaran` (`idLamaran`),
  ADD KEY `idx_status` (`status_pekerjaan`);

--
-- Indeks untuk tabel `pemberikerja`
--
ALTER TABLE `pemberikerja`
  ADD PRIMARY KEY (`idPemberiKerja`),
  ADD UNIQUE KEY `unique_user_pemberi` (`idUser`);

--
-- Indeks untuk tabel `pencarian_log`
--
ALTER TABLE `pencarian_log`
  ADD PRIMARY KEY (`id_pencarian`),
  ADD KEY `idUser` (`idUser`),
  ADD KEY `idx_keyword` (`keyword`),
  ADD KEY `idx_created_at` (`created_at`);

--
-- Indeks untuk tabel `rating`
--
ALTER TABLE `rating`
  ADD PRIMARY KEY (`idRating`),
  ADD KEY `idPekerjaan` (`idPekerjaan`),
  ADD KEY `idx_rating` (`nilai_rating`),
  ADD KEY `idx_pemberi` (`pemberi_rating`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`idUser`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `idx_email` (`email`),
  ADD KEY `idx_peran` (`peran_old`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `activity_log`
--
ALTER TABLE `activity_log`
  MODIFY `id_log` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- AUTO_INCREMENT untuk tabel `chat_conversation`
--
ALTER TABLE `chat_conversation`
  MODIFY `id_conversation` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `chat_message`
--
ALTER TABLE `chat_message`
  MODIFY `id_message` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `favorit`
--
ALTER TABLE `favorit`
  MODIFY `id_favorit` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id_kategori` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `lamaran`
--
ALTER TABLE `lamaran`
  MODIFY `idLamaran` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `lowongan`
--
ALTER TABLE `lowongan`
  MODIFY `idLowongan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT untuk tabel `lowongan_kategori`
--
ALTER TABLE `lowongan_kategori`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `notifikasi`
--
ALTER TABLE `notifikasi`
  MODIFY `id_notifikasi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `pekerja`
--
ALTER TABLE `pekerja`
  MODIFY `idPekerja` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `pekerjaan`
--
ALTER TABLE `pekerjaan`
  MODIFY `idPekerjaan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `pemberikerja`
--
ALTER TABLE `pemberikerja`
  MODIFY `idPemberiKerja` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `pencarian_log`
--
ALTER TABLE `pencarian_log`
  MODIFY `id_pencarian` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `rating`
--
ALTER TABLE `rating`
  MODIFY `idRating` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `idUser` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `activity_log`
--
ALTER TABLE `activity_log`
  ADD CONSTRAINT `activity_log_ibfk_1` FOREIGN KEY (`idUser`) REFERENCES `user` (`idUser`) ON DELETE SET NULL;

--
-- Ketidakleluasaan untuk tabel `chat_conversation`
--
ALTER TABLE `chat_conversation`
  ADD CONSTRAINT `chat_conversation_ibfk_1` FOREIGN KEY (`idPekerja`) REFERENCES `pekerja` (`idPekerja`) ON DELETE CASCADE,
  ADD CONSTRAINT `chat_conversation_ibfk_2` FOREIGN KEY (`idPemberiKerja`) REFERENCES `pemberikerja` (`idPemberiKerja`) ON DELETE CASCADE,
  ADD CONSTRAINT `chat_conversation_ibfk_3` FOREIGN KEY (`idLowongan`) REFERENCES `lowongan` (`idLowongan`) ON DELETE SET NULL;

--
-- Ketidakleluasaan untuk tabel `chat_message`
--
ALTER TABLE `chat_message`
  ADD CONSTRAINT `chat_message_ibfk_1` FOREIGN KEY (`id_conversation`) REFERENCES `chat_conversation` (`id_conversation`) ON DELETE CASCADE,
  ADD CONSTRAINT `chat_message_ibfk_2` FOREIGN KEY (`id_sender`) REFERENCES `user` (`idUser`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `favorit`
--
ALTER TABLE `favorit`
  ADD CONSTRAINT `favorit_ibfk_1` FOREIGN KEY (`idPekerja`) REFERENCES `pekerja` (`idPekerja`) ON DELETE CASCADE,
  ADD CONSTRAINT `favorit_ibfk_2` FOREIGN KEY (`idLowongan`) REFERENCES `lowongan` (`idLowongan`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `lamaran`
--
ALTER TABLE `lamaran`
  ADD CONSTRAINT `lamaran_ibfk_1` FOREIGN KEY (`idLowongan`) REFERENCES `lowongan` (`idLowongan`) ON DELETE CASCADE,
  ADD CONSTRAINT `lamaran_ibfk_2` FOREIGN KEY (`idPekerja`) REFERENCES `pekerja` (`idPekerja`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `lowongan`
--
ALTER TABLE `lowongan`
  ADD CONSTRAINT `lowongan_ibfk_1` FOREIGN KEY (`idPemberiKerja`) REFERENCES `pemberikerja` (`idPemberiKerja`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `lowongan_kategori`
--
ALTER TABLE `lowongan_kategori`
  ADD CONSTRAINT `lowongan_kategori_ibfk_1` FOREIGN KEY (`idLowongan`) REFERENCES `lowongan` (`idLowongan`) ON DELETE CASCADE,
  ADD CONSTRAINT `lowongan_kategori_ibfk_2` FOREIGN KEY (`id_kategori`) REFERENCES `kategori` (`id_kategori`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `notifikasi`
--
ALTER TABLE `notifikasi`
  ADD CONSTRAINT `notifikasi_ibfk_1` FOREIGN KEY (`idUser`) REFERENCES `user` (`idUser`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `pekerja`
--
ALTER TABLE `pekerja`
  ADD CONSTRAINT `pekerja_ibfk_1` FOREIGN KEY (`idUser`) REFERENCES `user` (`idUser`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `pekerjaan`
--
ALTER TABLE `pekerjaan`
  ADD CONSTRAINT `pekerjaan_ibfk_1` FOREIGN KEY (`idLamaran`) REFERENCES `lamaran` (`idLamaran`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `pemberikerja`
--
ALTER TABLE `pemberikerja`
  ADD CONSTRAINT `pemberikerja_ibfk_1` FOREIGN KEY (`idUser`) REFERENCES `user` (`idUser`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `pencarian_log`
--
ALTER TABLE `pencarian_log`
  ADD CONSTRAINT `pencarian_log_ibfk_1` FOREIGN KEY (`idUser`) REFERENCES `user` (`idUser`) ON DELETE SET NULL;

--
-- Ketidakleluasaan untuk tabel `rating`
--
ALTER TABLE `rating`
  ADD CONSTRAINT `rating_ibfk_1` FOREIGN KEY (`idPekerjaan`) REFERENCES `pekerjaan` (`idPekerjaan`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
