-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 24, 2024 at 04:40 PM
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
-- Database: `db_rpl`
--

-- --------------------------------------------------------

--
-- Table structure for table `barang`
--

CREATE TABLE `barang` (
  `id` int NOT NULL,
  `nama` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `harga` decimal(10,2) NOT NULL,
  `stok` int NOT NULL,
  `gambar_barang` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `barang`
--

INSERT INTO `barang` (`id`, `nama`, `harga`, `stok`, `gambar_barang`) VALUES
(1, 'Bola Basket', '10000.00', 8, 'bolabasket.jpg'),
(4, 'Bola Voli', '12000.00', 9, 'bolavoli.jpg'),
(6, 'Bola Sepak', '10000.00', 9, 'c9874111818b934536db3dc5a8aade28.jpeg'),
(8, 'Bola Baseball', '15000.00', 9, '16723409_7036c349-3463-4c93-8adf-996358a4998b_1990_2000.jpeg'),
(9, 'Raket', '15000.00', 20, 'yonex_arc_saber_73_light_-_dark_blue_1.jpg'),
(10, 'Shuttlecock', '6000.00', 9, 'images (1).jpeg');

-- --------------------------------------------------------

--
-- Table structure for table `pembelian`
--

CREATE TABLE `pembelian` (
  `id` int NOT NULL,
  `username` varchar(50) NOT NULL,
  `id_produk` int NOT NULL,
  `jumlah` int NOT NULL,
  `tanggal_pembelian` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `metode_pembayaran` varchar(50) NOT NULL,
  `status` enum('belum terkirim','terkirim') DEFAULT 'belum terkirim',
  `nama_barang` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `pembelian`
--

INSERT INTO `pembelian` (`id`, `username`, `id_produk`, `jumlah`, `tanggal_pembelian`, `metode_pembayaran`, `status`, `nama_barang`) VALUES
(4, 'hilmy', 4, 1, '2024-06-16 17:35:18', 'OVO', 'terkirim', 'Bola Voli'),
(5, 'hilmy', 1, 1, '2024-06-22 20:53:20', 'Transfer Bank', 'terkirim', 'Bola Basket'),
(6, 'hilmy', 6, 1, '2024-06-24 00:23:17', 'Gopay', 'terkirim', 'Bola Sepak'),
(7, 'hilmy', 8, 1, '2024-06-24 01:19:17', 'OVO', 'terkirim', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `username` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `password` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `level` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `email` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `saldo` int DEFAULT '0',
  `alamat` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`username`, `password`, `level`, `email`, `saldo`, `alamat`) VALUES
('admin', '123', 'Admin', 'admin123@gmail.com', 100000, ''),
('hilmy', '123', 'Pengguna', 'hilmyarema218@gmail.com', 100000, 'Jalan Mangga No 7 Malang'),
('rawp', '123', 'Admin', 'hilmyarema218@gmail.com', 0, ''),
('root', '123', 'Admin', 'admin123@gmail.com', 0, '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `nama` (`nama`);

--
-- Indexes for table `pembelian`
--
ALTER TABLE `pembelian`
  ADD PRIMARY KEY (`id`),
  ADD KEY `username` (`username`),
  ADD KEY `FK_pembelian_barang` (`id_produk`),
  ADD KEY `nama_barang` (`nama_barang`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `barang`
--
ALTER TABLE `barang`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `pembelian`
--
ALTER TABLE `pembelian`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `pembelian`
--
ALTER TABLE `pembelian`
  ADD CONSTRAINT `FK_pembelian_barang` FOREIGN KEY (`id_produk`) REFERENCES `barang` (`id`),
  ADD CONSTRAINT `FK_pembelian_barang_2` FOREIGN KEY (`nama_barang`) REFERENCES `barang` (`nama`),
  ADD CONSTRAINT `FK_pembelian_user` FOREIGN KEY (`username`) REFERENCES `user` (`username`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
