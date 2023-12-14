-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 07 Nov 2023 pada 02.38
-- Versi server: 10.4.27-MariaDB
-- Versi PHP: 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kampoeng_radjoet`
--

DELIMITER $$
--
-- Prosedur
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `tambahDataMasuk` (IN `supplier_name` VARCHAR(50), IN `product_code` VARCHAR(11), IN `product_name` VARCHAR(50), IN `quantity` INT, IN `date_value` DATE, IN `barcode_image` VARCHAR(300))   BEGIN
    INSERT INTO inventory (Supplier, Product_Code, Product_Name, Quantity, Date, barcode)
    VALUES (supplier_name, product_code, product_name, quantity, date_value, barcode_image);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `tambahInvenReports` (IN `supplier_name` VARCHAR(50), IN `product_code` VARCHAR(11), IN `product_name` VARCHAR(50), IN `quantity` INT, IN `date_value` DATE, IN `barcode_image` VARCHAR(300))   BEGIN
    INSERT INTO inven_reports (Supplier, Product_Code, Product_Name, Quantity, Date, barcode)
    VALUES (supplier_name, product_code, product_name, quantity, date_value, barcode_image);
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `barang_keluar`
--

CREATE TABLE `barang_keluar` (
  `id` int(11) NOT NULL,
  `nama_produk` varchar(255) NOT NULL,
  `tanggal` date NOT NULL,
  `stok` int(11) NOT NULL,
  `sku` varchar(50) NOT NULL,
  `harga` int(11) NOT NULL,
  `foto` varchar(255) NOT NULL,
  `barcode` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `barang_keluar`
--

INSERT INTO `barang_keluar` (`id`, `nama_produk`, `tanggal`, `stok`, `sku`, `harga`, `foto`, `barcode`) VALUES
(18, 'Cardigan Laviola', '2023-11-06', 100, 'KR001', 100000, '6548a462aa2dc.jpg', 'KR001166651'),
(19, 'Cardigan Diamond', '2023-11-06', 100, 'KR002', 250000, '6548a49e8bc84.jpg', 'KR002259866'),
(20, 'Cardigan Diamond', '2023-11-06', 150, 'KR002', 25000, '6548f667081a7.jpg', 'KR002609039');

-- --------------------------------------------------------

--
-- Struktur dari tabel `barang_masuk`
--

CREATE TABLE `barang_masuk` (
  `id` int(11) NOT NULL,
  `pengrajin` varchar(255) NOT NULL,
  `tanggal` date NOT NULL,
  `nama_produk` varchar(50) NOT NULL,
  `kategori` varchar(50) NOT NULL,
  `kondisi` varchar(50) NOT NULL,
  `deskripsi` varchar(255) NOT NULL,
  `harga` int(11) NOT NULL,
  `foto` varchar(255) NOT NULL,
  `stok` int(11) NOT NULL,
  `sku` varchar(50) NOT NULL,
  `barcode` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `barang_masuk`
--

INSERT INTO `barang_masuk` (`id`, `pengrajin`, `tanggal`, `nama_produk`, `kategori`, `kondisi`, `deskripsi`, `harga`, `foto`, `stok`, `sku`, `barcode`) VALUES
(49, 'Fairus', '0000-00-00', 'Cardigan Laviola', 'Cardigan', 'baru', 'Nyaman digunakan', 200000, '6548a3ea41e61.jpg', 50, 'KR001', 'KR001851544'),
(50, 'Salimi', '2023-11-06', 'Cardigan Diamond', 'Cardigan', 'baru', 'Premium pisan', 250000, '6548a4899c6ec.jpg', 200, 'KR002', 'KR002262311'),
(51, 'lala', '2023-11-06', 'Cardigan Diamond', 'Cardigan', 'baru', 'Ukura yang tersedia:\r\nS. M dan XL', 250000, '6548f55036464.jpg', 100, 'KR002', 'KR002841624'),
(52, 'test1', '2023-11-01', 'Cardigan Laviola', 'Cardigan', 'baru', 'Model nyaman digunakan', 200000, '6548f769010de.jpg', 100, 'KR001', 'KR001388851');

--
-- Trigger `barang_masuk`
--
DELIMITER $$
CREATE TRIGGER `insert_supplier_trigger` AFTER INSERT ON `barang_masuk` FOR EACH ROW BEGIN
    DECLARE supplier_count INT;
    SET supplier_count = (SELECT COUNT(*) FROM suppliers WHERE name = NEW.pengrajin);
    IF supplier_count = 0 THEN
        INSERT INTO suppliers (name, started, status)
        VALUES (NEW.pengrajin, NEW.tanggal, 'inactive');
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `kategori_list`
--

CREATE TABLE `kategori_list` (
  `id` int(11) NOT NULL,
  `kategori` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `kategori_list`
--

INSERT INTO `kategori_list` (`id`, `kategori`) VALUES
(1, 'Sweater'),
(2, 'Hoodie'),
(3, 'Cardigan'),
(4, 'Tas'),
(8, 'Turtleneck'),
(9, 'Topi'),
(10, 'Vest'),
(11, 'Bandana'),
(12, 'Tanktop'),
(13, 'Totebag'),
(14, 'Polo'),
(47, 'Knit');

--
-- Trigger `kategori_list`
--
DELIMITER $$
CREATE TRIGGER `delete_kategori` BEFORE INSERT ON `kategori_list` FOR EACH ROW BEGIN
  IF NEW.kategori = '' THEN
    DELETE FROM kategori_list WHERE id = NEW.id;
  END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `quantity`
--

CREATE TABLE `quantity` (
  `id` int(11) NOT NULL,
  `id_product` varchar(50) NOT NULL,
  `product_name` varchar(50) NOT NULL,
  `stock` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `quantity`
--

INSERT INTO `quantity` (`id`, `id_product`, `product_name`, `stock`) VALUES
(96, 'KR001', 'Cardigan Laviola', 150),
(97, 'KR002', 'Cardigan Diamond', 50);

-- --------------------------------------------------------

--
-- Struktur dari tabel `reports_keluar`
--

CREATE TABLE `reports_keluar` (
  `id` int(11) NOT NULL,
  `nama_produk` varchar(255) NOT NULL,
  `tanggal` datetime NOT NULL,
  `stok` int(11) NOT NULL,
  `sku` varchar(50) NOT NULL,
  `harga` int(11) NOT NULL,
  `foto` varchar(255) NOT NULL,
  `barcode` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `reports_keluar`
--

INSERT INTO `reports_keluar` (`id`, `nama_produk`, `tanggal`, `stok`, `sku`, `harga`, `foto`, `barcode`) VALUES
(18, 'Cardigan Laviola', '2023-11-06 15:31:00', 100, 'KR001', 100000, '6548a462aa2dc.jpg', 'KR001166651'),
(19, 'Cardigan Diamond', '2023-11-06 15:32:00', 100, 'KR002', 250000, '6548a49e8bc84.jpg', 'KR002259866'),
(20, 'Cardigan Diamond', '2023-11-06 21:21:00', 150, 'KR002', 25000, '6548f667081a7.jpg', 'KR002609039');

-- --------------------------------------------------------

--
-- Struktur dari tabel `reports_masuk`
--

CREATE TABLE `reports_masuk` (
  `id` int(11) NOT NULL,
  `pengrajin` varchar(255) NOT NULL,
  `nama_produk` varchar(255) NOT NULL,
  `tanggal` datetime NOT NULL,
  `stok` int(11) NOT NULL,
  `sku` varchar(50) NOT NULL,
  `harga` varchar(255) NOT NULL,
  `foto` varchar(255) NOT NULL,
  `barcode` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `reports_masuk`
--

INSERT INTO `reports_masuk` (`id`, `pengrajin`, `nama_produk`, `tanggal`, `stok`, `sku`, `harga`, `foto`, `barcode`) VALUES
(42, 'Fairus', 'Cardigan Laviola', '0000-00-00 00:00:00', 50, 'KR001', '200000', '6548a3ea41e61.jpg', 'KR001851544'),
(43, 'Salimi', 'Cardigan Diamond', '2023-11-06 15:31:00', 200, 'KR002', '250000', '6548a4899c6ec.jpg', 'KR002262311'),
(44, 'lala', 'Cardigan Diamond', '2023-11-06 21:14:00', 100, 'KR002', '250000', '6548f55036464.jpg', 'KR002841624'),
(45, 'test1', 'Cardigan Laviola', '2023-11-01 21:25:00', 100, 'KR001', '200000', '6548f769010de.jpg', 'KR001388851');

-- --------------------------------------------------------

--
-- Struktur dari tabel `suppliers`
--

CREATE TABLE `suppliers` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(50) NOT NULL,
  `started` date NOT NULL,
  `status` varchar(50) NOT NULL,
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `suppliers`
--

INSERT INTO `suppliers` (`id`, `name`, `email`, `phone`, `started`, `status`, `image`) VALUES
(20, 'Jarjit', 'jarjit@gmail.com', '0812345678', '2023-06-06', 'Active', '647ccd76495c4.jpg'),
(21, 'Ehsan', 'ehsan@gmail.com', '0812304129', '2023-06-05', 'Active', '647ccd9c27f05.jpg'),
(22, 'Mail', 'mail@gmail.com', '0812345678', '2022-12-30', 'Active', '647ccdb308a74.jpg'),
(25, 'Upin', 'upin@gmail.com', '0812345678', '2023-03-01', 'Active', '647ccde1608ba.jpg'),
(27, 'Ijul', 'ijul@gmail.com', '08532861611', '2023-05-29', 'Active', '647cce1ccbd93.jpg'),
(28, 'meimei', 'meimei@gmail.com', '0812304129', '2023-01-18', 'Active', '647cce344501c.jpg'),
(29, 'susanti', 'susanti@gmail.com', '08532861611', '2022-12-12', 'Active', '647cce498342c.jpg'),
(30, 'Kak ros', 'kakros@gmail.com', '0812304129', '2022-10-02', 'Active', '647cce6a996d2.jpg'),
(31, 'opah', 'opah@gmail.com', '0123618369', '2022-12-08', 'Active', '647cce98996e0.jpg'),
(32, 'ipin', 'ipin@gmail.com', '01235178912', '2023-03-14', 'Active', '647ccecca6f42.jpg'),
(33, 'Yanto', 'yanto@gmail.com', '012312301', '2023-06-07', 'Active', '6480b696f2001.jpg'),
(34, 'Iwan', 'iwan@gmail.com', '1231923', '2023-06-07', 'Active', '6480b7a6dea86.jpg'),
(35, 'Budi', '', '', '2023-06-08', 'inactive', ''),
(36, 'Entong', '', '', '2023-06-08', 'inactive', ''),
(37, 'Dadang', '', '', '2023-06-08', 'inactive', ''),
(38, 'Ujang', '', '', '2023-06-08', 'inactive', ''),
(39, 'mamang', '', '', '2023-06-08', 'inactive', ''),
(40, 'Uang', '', '', '2023-07-08', 'inactive', ''),
(41, 'opet', '', '', '2023-06-02', 'inactive', ''),
(42, 'idul', '', '', '2023-06-09', 'inactive', ''),
(76, 'Fairus', '', '', '2023-11-04', 'inactive', ''),
(77, 'test1', '', '', '2023-11-04', 'inactive', ''),
(78, 'test2', '', '', '2023-11-04', 'inactive', ''),
(79, 'test3', '', '', '2023-11-04', 'inactive', ''),
(80, 'test4', '', '', '2023-11-04', 'inactive', ''),
(81, 'test5', '', '', '2023-11-04', 'inactive', ''),
(82, 'test6', '', '', '2023-11-04', 'inactive', ''),
(83, 'test7', '', '', '2023-11-05', 'inactive', ''),
(84, 'test8', '', '', '2023-11-05', 'inactive', ''),
(85, 'test9', '', '', '2023-11-05', 'inactive', ''),
(86, 'Salimi', '', '', '2023-11-06', 'inactive', ''),
(87, 'uus asli', '', '', '2023-11-06', 'inactive', ''),
(88, 'lala', '', '', '2023-11-06', 'inactive', '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `verifikasi_code` varchar(255) NOT NULL,
  `status` int(11) NOT NULL,
  `reset_token` varchar(64) DEFAULT NULL,
  `reset_token_expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`id`, `username`, `email`, `password`, `verifikasi_code`, `status`, `reset_token`, `reset_token_expires_at`) VALUES
(32, 'fairussalimi', 'fairussalimi24@gmail.com', '$2y$10$aorJFFALIAdHu4TG7frSKuE1wYPHQdVIaHCWRYpnKEzy8Y3BK/Qv6', 'fa80a44f7ecb25c0fcbc76000a6bc34c', 1, NULL, NULL),
(35, 'test3', 'arning2711@gmail.com', '$2y$10$igvajalcBeCYmOTSAvR3JuwvNxc0i16f8sHmwBg85l3e7gujHsRsG', '06c8c3ba37282681df06f39f7aa17178', 1, NULL, NULL),
(36, 'fairussalimi2', 'fairussalimi123@gmail.com', '$2y$10$cdHA2Dknr4J9earSEO1Y3e6prONxNLCaaots2OxMpPYSn6HGDdzcG', '8c5394876d74f20027e6c0c249f159fc', 1, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `barang_keluar`
--
ALTER TABLE `barang_keluar`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `barang_masuk`
--
ALTER TABLE `barang_masuk`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `kategori_list`
--
ALTER TABLE `kategori_list`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `quantity`
--
ALTER TABLE `quantity`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `reports_keluar`
--
ALTER TABLE `reports_keluar`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `reports_masuk`
--
ALTER TABLE `reports_masuk`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `reset_token` (`reset_token`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `barang_keluar`
--
ALTER TABLE `barang_keluar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT untuk tabel `barang_masuk`
--
ALTER TABLE `barang_masuk`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT untuk tabel `kategori_list`
--
ALTER TABLE `kategori_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT untuk tabel `quantity`
--
ALTER TABLE `quantity`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=98;

--
-- AUTO_INCREMENT untuk tabel `reports_keluar`
--
ALTER TABLE `reports_keluar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT untuk tabel `reports_masuk`
--
ALTER TABLE `reports_masuk`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT untuk tabel `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=89;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
