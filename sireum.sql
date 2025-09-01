-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 14, 2025 at 12:08 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sireum`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id_admin` int(3) UNSIGNED ZEROFILL NOT NULL,
  `username_admin` varchar(50) DEFAULT NULL,
  `nama_admin` varchar(255) NOT NULL,
  `password_admin` varchar(60) DEFAULT NULL,
  `email_admin` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id_admin`, `username_admin`, `nama_admin`, `password_admin`, `email_admin`) VALUES
(001, 'admin1', 'Ahmad Fauzi', '$2y$10$8c/Fbzj4wCVMi2ahGvzTBuIh/lb1TiETrtMv1tdKmOCllL3OCMryC', 'admin1@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `galeri`
--

CREATE TABLE `galeri` (
  `id_foto` int(15) NOT NULL,
  `foto` varchar(255) NOT NULL,
  `path_foto` varchar(255) NOT NULL,
  `id_operator` int(15) DEFAULT NULL,
  `id_kategori` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `galeri`
--

INSERT INTO `galeri` (`id_foto`, `foto`, `path_foto`, `id_operator`, `id_kategori`) VALUES
(1, '1737017033_keris1.jpg', './upload/galeri/1737017033_keris1.jpg', 1, 2),
(2, '1737017188_keris2.jpg', './upload/galeri/1737017188_keris2.jpg', 2, 2),
(3, '1737017326_gambarkeris1.jpg', './upload/galeri/1737017326_gambarkeris1.jpg', 1, 2),
(4, '1737017348_gambarkeris2.jpg', './upload/galeri/1737017348_gambarkeris2.jpg', 1, 2),
(5, '1737017367_gambarkeris3.jpg', './upload/galeri/1737017367_gambarkeris3.jpg', 1, 2),
(6, '1737017566_batik1.jpg', './upload/galeri/1737017566_batik1.jpg', 1, 4),
(7, '1737017736_batik2.jpg', './upload/galeri/1737017736_batik2.jpg', 2, 4),
(8, '1737017749_batik3.jpg', './upload/galeri/1737017749_batik3.jpg', 2, 4),
(9, '1737017765_batik4.jpg', './upload/galeri/1737017765_batik4.jpg', 2, 4),
(10, '1737017804_musik1.jpg', './upload/galeri/1737017804_musik1.jpg', 2, 5),
(11, '1737017819_musik2.jpg', './upload/galeri/1737017819_musik2.jpg', 2, 5),
(12, '1737017841_musik3.jpg', './upload/galeri/1737017841_musik3.jpg', 2, 5),
(13, '1737017867_musik4.jpg', './upload/galeri/1737017867_musik4.jpg', 2, 5),
(14, '1737017893_mus1.jpg', './upload/galeri/1737017893_mus1.jpg', 2, 3),
(15, '1737017910_mus2.jpg', './upload/galeri/1737017910_mus2.jpg', 2, 3),
(16, '1737017925_mus3.jpg', './upload/galeri/1737017925_mus3.jpg', 2, 3),
(17, '1737017942_mus4.jpg', './upload/galeri/1737017942_mus4.jpg', 2, 3),
(18, '1737018166_wayang1.jpg', './upload/galeri/1737018166_wayang1.jpg', 3, 1),
(19, '1737018180_wayang2.jpg', './upload/galeri/1737018180_wayang2.jpg', 3, 1),
(20, '1737018196_wayang3.jpg', './upload/galeri/1737018196_wayang3.jpg', 3, 1),
(21, '1737018210_wayang4.jpg', './upload/galeri/1737018210_wayang4.jpg', 3, 1),
(22, '1737018252_kendi1.jpg', './upload/galeri/1737018252_kendi1.jpg', 3, 6),
(23, '1737018267_kendi2.jpg', './upload/galeri/1737018267_kendi2.jpg', 3, 6),
(24, '1737018281_kendi3.jpg', './upload/galeri/1737018281_kendi3.jpg', 3, 6),
(26, '1737081379_patung1.jpg', './upload/galeri/1737081379_patung1.jpg', 1, 7);

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `id_kategori` int(11) NOT NULL,
  `nama_kategori` varchar(255) NOT NULL,
  `id_operator` int(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`id_kategori`, `nama_kategori`, `id_operator`) VALUES
(1, 'Wayang', 1),
(2, 'Keris Pusaka\r\n', 1),
(3, 'Lukisan', 1),
(4, 'Batik', 1),
(5, 'Alat Musik', 1),
(6, 'Kendi', 3),
(7, 'Patung', 1);

-- --------------------------------------------------------

--
-- Table structure for table `kontak`
--

CREATE TABLE `kontak` (
  `id_kontak` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `subjek` varchar(100) NOT NULL,
  `isi_pesan` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kontak`
--

INSERT INTO `kontak` (`id_kontak`, `username`, `email`, `subjek`, `isi_pesan`) VALUES
(1, 'Ahmad Fauzi', 'zee@gmail.com', 'Lokasi Museum', 'Strategis'),
(2, 'Ulum', 'ulum123@gmail.com', 'Ok', 'Y'),
(3, 'Tomiyoka Giyuu', 'giyuu123@gmail.com', 'Room', 'Very Comfortable');

-- --------------------------------------------------------

--
-- Table structure for table `konten`
--

CREATE TABLE `konten` (
  `id_konten` int(10) NOT NULL,
  `nama_konten` varchar(255) DEFAULT NULL,
  `isi_konten` text DEFAULT NULL,
  `id_operator` int(15) DEFAULT NULL,
  `tanggal_update` date NOT NULL,
  `jam_mulai` time NOT NULL,
  `jam_selesai` time NOT NULL,
  `foto` varchar(255) NOT NULL,
  `path_foto` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `konten`
--

INSERT INTO `konten` (`id_konten`, `nama_konten`, `isi_konten`, `id_operator`, `tanggal_update`, `jam_mulai`, `jam_selesai`, `foto`, `path_foto`) VALUES
(1, 'Festival Tari Nusantara', 'Festival Tari Nusantara merupakan ajang seni dan budaya yang menampilkan kekayaan tari tradisional.', 1, '2025-01-18', '03:58:00', '05:01:00', '1737080550_tarinusantara.jpg', '/home/sireummy/domains/sireum.my.id/public_html/operator/upload/konten/1737080550_tarinusantara.jpg'),
(2, 'Pertunjukkan Wayang', 'Pertunjukan wayang adalah seni tradisional Indonesia yang menggabungkan unsur drama, musik, sastra, dan visual.', 1, '2025-01-25', '06:58:00', '08:01:00', '1737081161_acarawayang.jpg', '/home/sireummy/domains/sireum.my.id/public_html/operator/upload/konten/1737081161_acarawayang.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `money`
--

CREATE TABLE `money` (
  `id_money` int(11) NOT NULL,
  `harga_awal` int(11) NOT NULL,
  `harga_update` int(11) NOT NULL,
  `id_operator` int(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `money`
--

INSERT INTO `money` (`id_money`, `harga_awal`, `harga_update`, `id_operator`) VALUES
(1, 9000, 15000, 1);

-- --------------------------------------------------------

--
-- Table structure for table `negara`
--

CREATE TABLE `negara` (
  `id_negara` int(10) NOT NULL,
  `nama_negara` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `negara`
--

INSERT INTO `negara` (`id_negara`, `nama_negara`) VALUES
(1, 'Indonesia'),
(2, 'Malaysia'),
(3, 'Singapura'),
(4, 'Thailand'),
(5, 'Brunei Darussalam'),
(6, 'Jepang');

-- --------------------------------------------------------

--
-- Table structure for table `operator`
--

CREATE TABLE `operator` (
  `id_operator` int(15) NOT NULL,
  `nama_operator` varchar(50) DEFAULT NULL,
  `alamat_operator` text DEFAULT NULL,
  `jenis_kelamin_operator` varchar(10) DEFAULT NULL,
  `nomor_telepon_operator` bigint(12) DEFAULT NULL,
  `email_operator` varchar(30) DEFAULT NULL,
  `username_operator` varchar(50) DEFAULT NULL,
  `password_operator` varchar(60) DEFAULT NULL,
  `id_admin` int(3) UNSIGNED ZEROFILL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `operator`
--

INSERT INTO `operator` (`id_operator`, `nama_operator`, `alamat_operator`, `jenis_kelamin_operator`, `nomor_telepon_operator`, `email_operator`, `username_operator`, `password_operator`, `id_admin`) VALUES
(1, 'Ahmad Fauzi', 'Majalengka', 'Laki-laki', 6283812344321, 'fauzi@gmail.com', 'Fauzi', '$2y$10$GEQSOgpzeGqoqA1T./uzhet9.aY2pcCy5PkW2ySWKz4UHN6ebAshC', 001),
(2, 'Febri Nabilah', 'Tangerang', 'Perempuan', 623454356562, 'febri123@gmail.com', 'nabilah', '$2y$10$mNRPf8N24oBwZKsxyRzFtOQKCOYrKP3VJjGrfje1bx6iyUA4aUAcq', 001),
(3, 'Pauzul Ulum', 'Tangerang', 'Laki-laki', 62898997676767, 'kimlum@gmail.com', 'Ulum', '$2y$10$UShD0YsR2X/XC4.vXXhysOqY9ShWX8Y37prZ9tGqoym3wz/DzBGHa', 001),
(4, 'Operator ', 'Majalengka', 'Laki-laki', 83834566543, 'operator@gmail.com', 'operator', '$2y$10$rclam/HmHQn6pWnZEW5OJutA.uhX9fQaOpigOrhmV.LESkzCgMvt.', 001);

-- --------------------------------------------------------

--
-- Table structure for table `pengunjung`
--

CREATE TABLE `pengunjung` (
  `id_pengunjung` int(15) NOT NULL,
  `nomor_identitas_pengunjung` varchar(16) DEFAULT NULL,
  `nama_pengunjung` varchar(50) DEFAULT NULL,
  `tanggal_lahir_pengunjung` date DEFAULT NULL,
  `jenis_kelamin_pengunjung` varchar(25) DEFAULT NULL,
  `alamat_pengunjung` text DEFAULT NULL,
  `kewarganegaraan` int(10) DEFAULT NULL,
  `nomor_telepon_pengunjung` varchar(12) DEFAULT NULL,
  `email_pengunjung` varchar(50) DEFAULT NULL,
  `password_pengunjung` varchar(60) DEFAULT NULL,
  `id_negara` int(10) DEFAULT NULL,
  `id_operator` int(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pengunjung`
--

INSERT INTO `pengunjung` (`id_pengunjung`, `nomor_identitas_pengunjung`, `nama_pengunjung`, `tanggal_lahir_pengunjung`, `jenis_kelamin_pengunjung`, `alamat_pengunjung`, `kewarganegaraan`, `nomor_telepon_pengunjung`, `email_pengunjung`, `password_pengunjung`, `id_negara`, `id_operator`) VALUES
(1, '2404001', 'Ahmad Fauzi', '2006-01-24', 'Laki-laki', 'Majalengka', 1, '083824757542', 'ahmadfauzi@gmail.com', '$2y$10$aJlEfFDLIVpGMS/YEd5aw.vdGM0lgGSd833Nn4iysNnMhUaPpl.8C', NULL, NULL),
(2, '2404002', 'Diva Lathipah', '2005-05-04', 'Perempuan', 'Jatitengah', 2, '083845678342', 'diva@gmail.com', '$2y$10$xrKeXxsh1TAG.S5hRepHte1cM9oi2d4UZATTjqopYhuullavRhvQ.', NULL, NULL),
(3, '2404004', 'Silvia Agnes', '1999-02-01', 'Perempuan', 'Jakarta', 2, '09993787683', 'agnes@gmail.com', '$2y$10$FIhScISYq11cyOCBiapR3OLhBvf5R/dlQ8OWpXz38Dq/43HuD9wz2', NULL, NULL),
(4, '2404005', 'Dzaky Mirza', '2006-09-15', 'Laki-laki', 'Tangerang', 3, '089989332232', 'dzaky@gmail.com', '$2y$10$kRrMWxHn84.KFqgDlBc1gu9ZIJuY5tPnwNdoUGHcGav8vJGfBZMmK', NULL, NULL),
(5, '2404008', 'Lucinta Maya', '1999-05-05', 'Privasi gender', 'Jakarta', 4, '0898890724', 'maya@gmail.com', '$2y$10$D0nma0MlNU8ilEp4Sni8nOOGATW/WOAlHYDJqP4tnYbEJsJTYpveW', NULL, NULL),
(6, '2404058', 'Febri Nabilah', '2006-02-07', 'Perempuan', 'Rajeg', 1, '08123123123', 'febri123@gmail.com', '$2y$10$gHL2yPPGnXyQO5temgRebuv/ZACcHo6VRss4UgRCsp1tNF7.efdsO', NULL, NULL),
(7, '2404000', 'Adam Ramdani', '2023-10-09', 'Privasi gender', 'Gandasari ', 1, '085524751218', 'nimuduit1994@gmail.com', '$2y$10$UCiT0GzYNKvWMtCcecIBK.dNtN0NuxM576kXOV1XVqRBc/KB57MUm', NULL, NULL),
(8, '2404100', 'Alvin Makmum', '2000-02-01', 'Laki-laki', 'Tangerang', 5, '089023456782', 'alvin@gmail.com', '$2y$10$sHssIWF4YbncW1Wg9VQoR.del1BEO4hc2x4NkokpXWURq1dRPjuoG', NULL, NULL),
(10, '2404019', 'Mahalini Iskandar', '2000-07-03', 'Privasi gender', 'Bali', 3, '089778977656', 'mahalini@gmail.com', '$2y$10$mE4w8ZZP/72sKxk8TOXP8ukRjHnFsENucg1pZ8/Y8yyn/lnrLNSf.', NULL, NULL),
(12, '2404077', 'Tomiyoka Giyuu', '2025-01-07', 'Laki-laki', 'Tokyo', 6, '089977665544', 'giyuu123@gmail.com', '$2y$10$N7/n5QRyV8VUtVBOa/QU.OA5LHIkQYzV6Nij.ucLImncZXJG8ABYa', NULL, NULL),
(13, '2406890', 'Muhammad Jamil', '2025-01-23', 'Laki-laki', 'Lampung', 4, '0899899033', 'jamil@gmail.com', '$2y$10$jtWSYi5jVayr3fqms/tzoOfGPDcFyRVNq6gHSSDOIp94UNV1fHwLK', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `reservasi`
--

CREATE TABLE `reservasi` (
  `id_reservasi` int(10) NOT NULL,
  `id_pengunjung` int(15) DEFAULT NULL,
  `nomor_reservasi` varchar(255) DEFAULT NULL,
  `tanggal_reservasi` date DEFAULT NULL,
  `jam_kunjungan` time NOT NULL,
  `tanggal_pemesanan` date NOT NULL,
  `jumlah_pengunjung` int(15) DEFAULT NULL,
  `status_reservasi` varchar(255) DEFAULT NULL,
  `id_operator` int(15) DEFAULT NULL,
  `id_money` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reservasi`
--

INSERT INTO `reservasi` (`id_reservasi`, `id_pengunjung`, `nomor_reservasi`, `tanggal_reservasi`, `jam_kunjungan`, `tanggal_pemesanan`, `jumlah_pengunjung`, `status_reservasi`, `id_operator`, `id_money`) VALUES
(1, 1, 'RSV6788a5081760', '2025-01-16', '19:00:00', '2025-01-16', 1, 'Dikonfirmasi', 3, 1),
(2, 2, 'RSV6788a58e3146', '2025-01-17', '13:00:00', '2025-01-16', 1, 'Dikonfirmasi', 1, 1),
(3, 1, 'RSV6788e711ea008', '2025-01-16', '12:15:00', '2025-01-16', 4, 'Dikonfirmasi', 1, 1),
(4, 5, 'RSV6788e83683cd0', '2025-01-17', '15:00:00', '2025-01-16', 2, 'Dikonfirmasi', 1, 1),
(5, 8, 'RSV6789cef836426', '2025-01-18', '09:10:00', '2025-01-17', 1, 'Dikonfirmasi', 3, 1),
(8, 10, 'RSV678b89bc34548', '2025-01-19', '09:00:00', '2025-01-18', 1, 'Dikonfirmasi', 2, 1),
(10, 12, 'RSV678cf553d70d3', '2025-01-25', '11:30:00', '2025-01-19', 4, 'Dikonfirmasi', 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `id_transaksi` int(15) NOT NULL,
  `id_reservasi` int(10) DEFAULT NULL,
  `id_pengunjung` int(15) NOT NULL,
  `id_money` int(11) NOT NULL,
  `nomor_transaksi` varchar(255) DEFAULT NULL,
  `tanggal_transaksi` date NOT NULL,
  `status_transaksi` varchar(255) DEFAULT NULL,
  `metode_transaksi` varchar(255) NOT NULL,
  `uang_transaksi` int(11) NOT NULL,
  `nomor_payment` varchar(50) DEFAULT NULL,
  `status_tiket` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0 = Belum dikonfirmasi, 1 = Sudah dikonfirmasi'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transaksi`
--

INSERT INTO `transaksi` (`id_transaksi`, `id_reservasi`, `id_pengunjung`, `id_money`, `nomor_transaksi`, `tanggal_transaksi`, `status_transaksi`, `metode_transaksi`, `uang_transaksi`, `nomor_payment`, `status_tiket`) VALUES
(1, 1, 1, 1, 'TRX6788a51cf08b', '2025-01-16', 'Sukses', 'Online', 15000, '2147483647', 0),
(2, 2, 2, 1, 'TRX6788a599251f', '2025-01-16', 'Sukses', 'Online', 15000, '2147483647', 1),
(3, 3, 1, 1, 'TRX6788e78396478', '2025-01-16', 'Sukses', 'Online', 60000, '212232343545', 0),
(4, 4, 5, 1, 'TRX6788e83f18a94', '2025-01-16', 'Sukses', 'Online', 30000, '212212', 1),
(5, 5, 8, 1, 'TRX6789cf05e1b81', '2025-01-17', 'Sukses', 'Online', 15000, '123342432432', 1),
(7, 8, 10, 1, 'TRX678b89e0a5665', '2025-01-18', 'Sukses', 'Online', 15000, '2345787656', 0),
(9, 10, 12, 1, 'TRX678cf5a0582fa', '2025-01-19', 'Sukses', 'Online', 60000, '089977665544', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id_admin`);

--
-- Indexes for table `galeri`
--
ALTER TABLE `galeri`
  ADD PRIMARY KEY (`id_foto`),
  ADD KEY `id_operator` (`id_operator`),
  ADD KEY `id_kategori` (`id_kategori`);

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id_kategori`),
  ADD KEY `id_operator` (`id_operator`);

--
-- Indexes for table `kontak`
--
ALTER TABLE `kontak`
  ADD PRIMARY KEY (`id_kontak`);

--
-- Indexes for table `konten`
--
ALTER TABLE `konten`
  ADD PRIMARY KEY (`id_konten`),
  ADD KEY `id_operator` (`id_operator`);

--
-- Indexes for table `money`
--
ALTER TABLE `money`
  ADD PRIMARY KEY (`id_money`),
  ADD KEY `id_operator` (`id_operator`);

--
-- Indexes for table `negara`
--
ALTER TABLE `negara`
  ADD PRIMARY KEY (`id_negara`);

--
-- Indexes for table `operator`
--
ALTER TABLE `operator`
  ADD PRIMARY KEY (`id_operator`),
  ADD KEY `id_admin` (`id_admin`);

--
-- Indexes for table `pengunjung`
--
ALTER TABLE `pengunjung`
  ADD PRIMARY KEY (`id_pengunjung`),
  ADD KEY `kewarganegaraan` (`kewarganegaraan`),
  ADD KEY `fk_pengunjung_operator` (`id_operator`);

--
-- Indexes for table `reservasi`
--
ALTER TABLE `reservasi`
  ADD PRIMARY KEY (`id_reservasi`),
  ADD KEY `id_pengunjung` (`id_pengunjung`),
  ADD KEY `id_money` (`id_money`),
  ADD KEY `reservasi_ibfk_2` (`id_operator`);

--
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id_transaksi`),
  ADD KEY `id_reservasi` (`id_reservasi`),
  ADD KEY `id_pengunjung` (`id_pengunjung`),
  ADD KEY `id_money` (`id_money`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id_admin` int(3) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `galeri`
--
ALTER TABLE `galeri`
  MODIFY `id_foto` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id_kategori` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `kontak`
--
ALTER TABLE `kontak`
  MODIFY `id_kontak` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `konten`
--
ALTER TABLE `konten`
  MODIFY `id_konten` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `money`
--
ALTER TABLE `money`
  MODIFY `id_money` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `negara`
--
ALTER TABLE `negara`
  MODIFY `id_negara` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `operator`
--
ALTER TABLE `operator`
  MODIFY `id_operator` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `pengunjung`
--
ALTER TABLE `pengunjung`
  MODIFY `id_pengunjung` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `reservasi`
--
ALTER TABLE `reservasi`
  MODIFY `id_reservasi` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id_transaksi` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `galeri`
--
ALTER TABLE `galeri`
  ADD CONSTRAINT `galeri_ibfk_1` FOREIGN KEY (`id_operator`) REFERENCES `operator` (`id_operator`),
  ADD CONSTRAINT `galeri_ibfk_2` FOREIGN KEY (`id_kategori`) REFERENCES `kategori` (`id_kategori`);

--
-- Constraints for table `kategori`
--
ALTER TABLE `kategori`
  ADD CONSTRAINT `kategori_ibfk_1` FOREIGN KEY (`id_operator`) REFERENCES `operator` (`id_operator`);

--
-- Constraints for table `konten`
--
ALTER TABLE `konten`
  ADD CONSTRAINT `konten_ibfk_1` FOREIGN KEY (`id_operator`) REFERENCES `operator` (`id_operator`);

--
-- Constraints for table `money`
--
ALTER TABLE `money`
  ADD CONSTRAINT `money_ibfk_1` FOREIGN KEY (`id_operator`) REFERENCES `operator` (`id_operator`);

--
-- Constraints for table `operator`
--
ALTER TABLE `operator`
  ADD CONSTRAINT `operator_ibfk_1` FOREIGN KEY (`id_admin`) REFERENCES `admin` (`id_admin`);

--
-- Constraints for table `pengunjung`
--
ALTER TABLE `pengunjung`
  ADD CONSTRAINT `fk_pengunjung_operator` FOREIGN KEY (`id_operator`) REFERENCES `operator` (`id_operator`),
  ADD CONSTRAINT `pengunjung_ibfk_1` FOREIGN KEY (`kewarganegaraan`) REFERENCES `negara` (`id_negara`);

--
-- Constraints for table `reservasi`
--
ALTER TABLE `reservasi`
  ADD CONSTRAINT `reservasi_ibfk_1` FOREIGN KEY (`id_pengunjung`) REFERENCES `pengunjung` (`id_pengunjung`) ON DELETE CASCADE,
  ADD CONSTRAINT `reservasi_ibfk_2` FOREIGN KEY (`id_operator`) REFERENCES `operator` (`id_operator`),
  ADD CONSTRAINT `reservasi_ibfk_3` FOREIGN KEY (`id_money`) REFERENCES `money` (`id_money`);

--
-- Constraints for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD CONSTRAINT `transaksi_ibfk_1` FOREIGN KEY (`id_reservasi`) REFERENCES `reservasi` (`id_reservasi`) ON DELETE CASCADE,
  ADD CONSTRAINT `transaksi_ibfk_2` FOREIGN KEY (`id_pengunjung`) REFERENCES `pengunjung` (`id_pengunjung`),
  ADD CONSTRAINT `transaksi_ibfk_3` FOREIGN KEY (`id_money`) REFERENCES `money` (`id_money`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
