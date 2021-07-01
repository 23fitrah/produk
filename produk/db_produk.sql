-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 01 Jul 2021 pada 15.19
-- Versi Server: 10.1.10-MariaDB
-- PHP Version: 5.5.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_produk`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_produk`
--

CREATE TABLE `tbl_produk` (
  `Id` int(10) NOT NULL,
  `Nama_barang` varchar(200) NOT NULL,
  `Kode_barang` varchar(50) NOT NULL,
  `Jumlah_barang` int(10) NOT NULL,
  `Tanggal` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tbl_produk`
--

INSERT INTO `tbl_produk` (`Id`, `Nama_barang`, `Kode_barang`, `Jumlah_barang`, `Tanggal`) VALUES
(25, 'Buku Tulis', 'BT001', 20, '2021-07-01'),
(26, 'Pulpen', 'PL001', 22, '2021-07-03');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_produk`
--
ALTER TABLE `tbl_produk`
  ADD PRIMARY KEY (`Id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_produk`
--
ALTER TABLE `tbl_produk`
  MODIFY `Id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
