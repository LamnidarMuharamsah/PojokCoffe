-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jan 18, 2017 at 09:10 AM
-- Server version: 10.1.16-MariaDB
-- PHP Version: 7.0.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `restoran`
--

-- --------------------------------------------------------

--
-- Table structure for table `bahan_baku`
--

CREATE TABLE `bahan_baku` (
  `id_bahan` int(11) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `tgl_masuk` date NOT NULL,
  `stok` int(11) NOT NULL,
  `tgl_kadaluarsa` date NOT NULL,
  `harga` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bahan_baku`
--

INSERT INTO `bahan_baku` (`id_bahan`, `nama`, `tgl_masuk`, `stok`, `tgl_kadaluarsa`, `harga`) VALUES
(1, 'Madu', '2017-01-01', 168, '2017-07-26', 2000000),
(3, 'Daging Ayam Dada', '2017-01-01', 18, '2017-01-03', 500000),
(4, 'Kecap', '2017-01-01', 47, '2017-07-21', 550000),
(5, 'Mie ramen', '2017-01-10', 15, '2017-02-03', 250000),
(6, 'sawi hijau', '2017-01-04', 485, '2017-01-31', 200000),
(7, 'Daging sukiyaki', '2017-01-10', 35, '2017-01-26', 500000),
(8, 'Bawang Putih', '2017-01-13', 140, '2018-02-03', 400000),
(9, 'Saus Sambal', '2017-01-05', 247, '2020-01-19', 2000000),
(10, 'Minyak ikan', '2017-01-11', 56, '2017-01-27', 650000),
(11, 'minyak wijen', '2017-01-04', 621, '2017-01-20', 500000),
(12, 'Minyak Goreng', '2017-01-11', 1990, '2017-01-26', 5000000),
(13, 'Minyak Goreng', '2017-01-11', 2000, '2017-01-26', 5000000),
(14, 'merica', '2017-01-04', 200, '2017-01-26', 1540000),
(15, 'cabai rawit', '2017-01-04', 20, '2017-01-27', 200000000),
(16, 'jahe', '2017-01-04', 15, '2017-01-26', 400000),
(17, 'Tepung', '2017-01-05', 50, '2017-01-27', 5000000),
(18, 'Telur rebus', '2017-01-05', 20, '2017-01-20', 2500000),
(19, 'jamur', '2017-01-05', 30, '2017-01-28', 4000000),
(20, 'Bawang Merah', '2017-01-05', 54, '2017-01-25', 260000),
(21, 'Sprit', '2017-01-04', 200, '2017-01-18', 2500000),
(22, 'Susu', '2017-01-05', 300, '2017-01-24', 4000000),
(23, 'Es batu', '2017-01-11', 100000, '2017-01-25', 200000),
(24, 'Nasi', '2017-01-04', 2147483647, '2017-01-12', 2000000),
(25, 'Telur', '2017-01-04', 2000, '2017-01-25', 4000000),
(26, 'Udang', '2017-01-05', 244, '2017-01-20', 2000000),
(27, 'Udang', '2017-01-05', 224, '2017-01-20', 2000000),
(28, 'Bakso', '2017-01-18', 4990, '2017-01-19', 5000000);

-- --------------------------------------------------------

--
-- Table structure for table `detail_bahan_baku`
--

CREATE TABLE `detail_bahan_baku` (
  `id_detail_bahan` int(11) NOT NULL,
  `id_menu` int(11) NOT NULL,
  `id_bahan` int(11) NOT NULL,
  `jumlah_bahan` int(11) NOT NULL DEFAULT '1',
  `ket` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `detail_bahan_baku`
--

INSERT INTO `detail_bahan_baku` (`id_detail_bahan`, `id_menu`, `id_bahan`, `jumlah_bahan`, `ket`) VALUES
(11, 8, 1, 2, 'sendok'),
(12, 8, 3, 1, 'ekor'),
(13, 9, 4, 1, 'sachet'),
(14, 9, 1, 1, 'sendok'),
(15, 10, 4, 1, ''),
(16, 10, 1, 2, ''),
(17, 11, 5, 1, 'bungkus'),
(18, 11, 6, 3, 'biji'),
(19, 11, 8, 2, 'siung'),
(20, 11, 10, 2, 'sendok'),
(21, 11, 12, 2, 'sendok'),
(22, 11, 16, 1, 'biji'),
(23, 11, 18, 2, 'butir'),
(24, 11, 7, 3, 'buah'),
(25, 11, 27, 4, 'ekor'),
(26, 11, 28, 2, 'biji'),
(27, 11, 9, 1, 'sashet'),
(28, 11, 19, 1, 'buah'),
(29, 12, 4, 2, 'Sedok');

-- --------------------------------------------------------

--
-- Table structure for table `detail_pemesanan`
--

CREATE TABLE `detail_pemesanan` (
  `id_detail_pemesanan` int(11) NOT NULL,
  `id_pemesanan` int(11) UNSIGNED ZEROFILL NOT NULL,
  `id_menu` int(11) NOT NULL,
  `jumlah` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `detail_pemesanan`
--

INSERT INTO `detail_pemesanan` (`id_detail_pemesanan`, `id_pemesanan`, `id_menu`, `jumlah`) VALUES
(1, 00000000001, 8, 3),
(4, 00000000002, 8, 2),
(5, 00000000003, 8, 2),
(6, 00000000004, 8, 1),
(7, 00000000005, 8, 2),
(8, 00000000005, 9, 3),
(9, 00000000006, 8, 1),
(10, 00000000006, 9, 2),
(11, 00000000006, 8, 2),
(12, 00000000007, 8, 2),
(13, 00000000007, 9, 2),
(14, 00000000007, 8, 3),
(15, 00000000008, 8, 2),
(16, 00000000008, 9, 3),
(17, 00000000005, 9, 1),
(18, 00000000005, 10, 1),
(19, 00000000008, 10, 2),
(20, 00000000009, 11, 3),
(21, 00000000009, 8, 1),
(22, 00000000010, 11, 2),
(23, 00000000010, 9, 2),
(24, 00000000011, 11, 2),
(25, 00000000011, 8, 3),
(26, 00000000012, 11, 20),
(27, 00000000013, 8, 6666);

-- --------------------------------------------------------

--
-- Table structure for table `jabatan`
--

CREATE TABLE `jabatan` (
  `id_jabatan` int(11) NOT NULL,
  `jabatan` varchar(50) NOT NULL,
  `deskripsi` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `jabatan`
--

INSERT INTO `jabatan` (`id_jabatan`, `jabatan`, `deskripsi`) VALUES
(1, 'admin', 'admin sistem'),
(2, 'Kasir', 'Mengelola pembayaran'),
(3, 'Manager', 'Mengambil keputusan'),
(4, 'Pelayan', 'Mengelola Pemesanan'),
(6, 'Koki', 'Mengelola masakan'),
(7, 'Pantry', 'Mengelola bahan baku'),
(8, 'CS', 'customer service');

-- --------------------------------------------------------

--
-- Table structure for table `jawaban`
--

CREATE TABLE `jawaban` (
  `id_jawaban` int(11) NOT NULL,
  `jawaban` varchar(200) NOT NULL,
  `pertanyaan` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `jawaban`
--

INSERT INTO `jawaban` (`id_jawaban`, `jawaban`, `pertanyaan`) VALUES
(9, '2', 6),
(10, '3', 7),
(11, '5', 6),
(12, '4', 7),
(13, '2', 9);

-- --------------------------------------------------------

--
-- Table structure for table `kuisioner`
--

CREATE TABLE `kuisioner` (
  `id_kuisioner` int(11) NOT NULL,
  `id_pegawai` int(10) UNSIGNED ZEROFILL NOT NULL,
  `tgl_kuisioner` date NOT NULL,
  `tgl_selesai` date NOT NULL,
  `judul_kuisioner` varchar(150) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `kuisioner`
--

INSERT INTO `kuisioner` (`id_kuisioner`, `id_pegawai`, `tgl_kuisioner`, `tgl_selesai`, `judul_kuisioner`, `status`) VALUES
(5, 0000000003, '2017-01-18', '2017-01-13', 'Kuisioner Baru', 1),
(6, 0000000014, '2017-01-18', '2017-01-19', 'baru', 1);

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE `menu` (
  `id_menu` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `jenis` varchar(20) NOT NULL,
  `harga` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`id_menu`, `nama`, `jenis`, `harga`) VALUES
(8, 'Ayam Madu', 'Main Course', 30000),
(9, 'testing', 'Minuman', 20000),
(10, 'Ramen', 'Main Course', 25000),
(11, 'Ramen Jomblo', 'Main Course', 1000),
(12, 'Cikopi', 'Minuman', 25000);

-- --------------------------------------------------------

--
-- Table structure for table `pegawai`
--

CREATE TABLE `pegawai` (
  `id_pegawai` int(10) UNSIGNED ZEROFILL NOT NULL,
  `nama` varchar(50) NOT NULL,
  `alamat` varchar(150) NOT NULL,
  `tempat_lahir` varchar(100) NOT NULL,
  `tgl_lahir` date NOT NULL,
  `jk` varchar(1) NOT NULL DEFAULT 'L',
  `id_jabatan` int(11) NOT NULL,
  `password` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pegawai`
--

INSERT INTO `pegawai` (`id_pegawai`, `nama`, `alamat`, `tempat_lahir`, `tgl_lahir`, `jk`, `id_jabatan`, `password`, `username`) VALUES
(0000000003, 'admin', 'admin', 'admin', '2017-01-12', 'L', 1, '21232f297a57a5a743894a0e4a801fc3', 'admin'),
(0000000009, 'krisna', 'testingasdads', 'krisna', '2017-01-10', 'L', 1, '948f5cc9f8c6c3b86a070beaca7d20bf', 'krisna'),
(0000000010, 'kasir', 'kasir', 'kasir', '2017-01-11', 'L', 2, 'c7911af3adbd12a035b289556d96470a', 'kasir'),
(0000000011, 'koki', 'koki', 'koki', '2017-01-11', 'L', 6, 'c38be0f1f87d0e77a0cd2fe6941253eb', 'koki'),
(0000000012, 'manager', 'manager', 'manager', '2017-01-11', 'L', 3, '1d0258c2440a8d19e716292b231e3190', 'manager'),
(0000000013, 'pantry', 'pantry', 'pantry', '2017-01-19', 'L', 7, 'dfc1c8bed5de7350be927562047dd29f', 'pantry'),
(0000000014, 'cusvis', 'cusvis', 'cusvis', '2017-01-11', 'L', 8, 'c031912845c14ed58ea11111dcd5ec71', 'cusvis'),
(0000000015, 'pelayan', 'pelayan', 'pelayan', '2017-01-12', 'L', 4, '511cc40443f2a1ab03ab373b77d28091', 'pelayan'),
(0000000016, 'Dendry', 'KEPO', 'KEPO', '1945-08-17', 'L', 3, 'a040891f4886a4fbe43b6c62f20fe63c', 'dendry'),
(0000000017, 'Doni', 'Cimohai', 'Ciyanjur', '2017-01-04', 'L', 6, '2da9cd653f63c010b6d6c5a5ad73fe32', 'doni');

-- --------------------------------------------------------

--
-- Table structure for table `pembayaran`
--

CREATE TABLE `pembayaran` (
  `id_pembayaran` int(11) NOT NULL,
  `id_pemesanan` int(11) UNSIGNED ZEROFILL NOT NULL,
  `diskon` int(11) NOT NULL,
  `total_bayar` double NOT NULL,
  `id_pegawai` int(10) UNSIGNED ZEROFILL NOT NULL,
  `bayar` double NOT NULL,
  `kembalian` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pembayaran`
--

INSERT INTO `pembayaran` (`id_pembayaran`, `id_pemesanan`, `diskon`, `total_bayar`, `id_pegawai`, `bayar`, `kembalian`) VALUES
(1, 00000000001, 10, 115000, 0000000003, 120000, 5000),
(2, 00000000002, 10, 54000, 0000000003, 100000, 46000),
(3, 00000000003, 10, 54000, 0000000003, 100000, 46000),
(4, 00000000004, 10, 27000, 0000000003, 30000, 3000),
(5, 00000000005, 0, 120000, 0000000015, 130000, 10000),
(6, 00000000006, 0, 130000, 0000000003, 200000, 70000),
(7, 00000000007, 0, 190000, 0000000003, 1000000, 810000),
(8, 00000000011, 0, 92000, 0000000015, 100000, 8000);

-- --------------------------------------------------------

--
-- Table structure for table `pemesanan`
--

CREATE TABLE `pemesanan` (
  `id_pemesanan` int(11) UNSIGNED ZEROFILL NOT NULL,
  `id_pegawai` int(10) UNSIGNED ZEROFILL NOT NULL,
  `tgl_pesan` date NOT NULL,
  `no_meja` varchar(3) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pemesanan`
--

INSERT INTO `pemesanan` (`id_pemesanan`, `id_pegawai`, `tgl_pesan`, `no_meja`, `status`) VALUES
(00000000001, 0000000003, '2017-01-14', '8', 3),
(00000000002, 0000000003, '2017-01-14', '9', 3),
(00000000003, 0000000003, '2017-01-14', '1', 3),
(00000000004, 0000000003, '2017-01-15', '66', 3),
(00000000005, 0000000015, '2017-01-17', 'asd', 3),
(00000000006, 0000000003, '2017-01-16', '22', 3),
(00000000007, 0000000003, '2017-01-16', '21', 3),
(00000000008, 0000000003, '2017-01-17', '100', 2),
(00000000009, 0000000003, '2017-01-18', '28', 2),
(00000000010, 0000000015, '2017-01-18', '13', 1),
(00000000011, 0000000015, '2017-01-18', '88', 3),
(00000000012, 0000000015, '2017-01-18', '300', 1),
(00000000013, 0000000015, '2017-01-18', '666', 1);

-- --------------------------------------------------------

--
-- Table structure for table `pertanyaan`
--

CREATE TABLE `pertanyaan` (
  `id_pertanyaan` int(11) NOT NULL,
  `pertanyaan` varchar(200) NOT NULL,
  `id_kuisioner` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pertanyaan`
--

INSERT INTO `pertanyaan` (`id_pertanyaan`, `pertanyaan`, `id_kuisioner`) VALUES
(6, 'Apakah anda senang dengan pelayanan kami kepada anda ??', 5),
(7, 'Apakah harga yang di tawarkan sesuai dengan rasa ??', 5),
(8, 'Bagaimana rasa dari menu baru kami ?', 5),
(9, 'coba coba', 6);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bahan_baku`
--
ALTER TABLE `bahan_baku`
  ADD PRIMARY KEY (`id_bahan`);

--
-- Indexes for table `detail_bahan_baku`
--
ALTER TABLE `detail_bahan_baku`
  ADD PRIMARY KEY (`id_detail_bahan`),
  ADD KEY `id_menu` (`id_menu`),
  ADD KEY `id_bahan` (`id_bahan`);

--
-- Indexes for table `detail_pemesanan`
--
ALTER TABLE `detail_pemesanan`
  ADD PRIMARY KEY (`id_detail_pemesanan`),
  ADD KEY `id_pemesanan` (`id_pemesanan`),
  ADD KEY `id_menu` (`id_menu`);

--
-- Indexes for table `jabatan`
--
ALTER TABLE `jabatan`
  ADD PRIMARY KEY (`id_jabatan`);

--
-- Indexes for table `jawaban`
--
ALTER TABLE `jawaban`
  ADD PRIMARY KEY (`id_jawaban`),
  ADD KEY `pertanyaan` (`pertanyaan`),
  ADD KEY `pertanyaan_2` (`pertanyaan`);

--
-- Indexes for table `kuisioner`
--
ALTER TABLE `kuisioner`
  ADD PRIMARY KEY (`id_kuisioner`),
  ADD KEY `id_pegawai` (`id_pegawai`);

--
-- Indexes for table `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id_menu`);

--
-- Indexes for table `pegawai`
--
ALTER TABLE `pegawai`
  ADD PRIMARY KEY (`id_pegawai`),
  ADD KEY `id_jabatan` (`id_jabatan`);

--
-- Indexes for table `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD PRIMARY KEY (`id_pembayaran`),
  ADD KEY `id_pemesanan` (`id_pemesanan`),
  ADD KEY `id_pegawai` (`id_pegawai`);

--
-- Indexes for table `pemesanan`
--
ALTER TABLE `pemesanan`
  ADD PRIMARY KEY (`id_pemesanan`),
  ADD KEY `id_pegawai` (`id_pegawai`);

--
-- Indexes for table `pertanyaan`
--
ALTER TABLE `pertanyaan`
  ADD PRIMARY KEY (`id_pertanyaan`),
  ADD KEY `id_kuisioner` (`id_kuisioner`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bahan_baku`
--
ALTER TABLE `bahan_baku`
  MODIFY `id_bahan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;
--
-- AUTO_INCREMENT for table `detail_bahan_baku`
--
ALTER TABLE `detail_bahan_baku`
  MODIFY `id_detail_bahan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;
--
-- AUTO_INCREMENT for table `detail_pemesanan`
--
ALTER TABLE `detail_pemesanan`
  MODIFY `id_detail_pemesanan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;
--
-- AUTO_INCREMENT for table `jabatan`
--
ALTER TABLE `jabatan`
  MODIFY `id_jabatan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `jawaban`
--
ALTER TABLE `jawaban`
  MODIFY `id_jawaban` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `kuisioner`
--
ALTER TABLE `kuisioner`
  MODIFY `id_kuisioner` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `menu`
--
ALTER TABLE `menu`
  MODIFY `id_menu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `pegawai`
--
ALTER TABLE `pegawai`
  MODIFY `id_pegawai` int(10) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT for table `pembayaran`
--
ALTER TABLE `pembayaran`
  MODIFY `id_pembayaran` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `pemesanan`
--
ALTER TABLE `pemesanan`
  MODIFY `id_pemesanan` int(11) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `pertanyaan`
--
ALTER TABLE `pertanyaan`
  MODIFY `id_pertanyaan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `detail_bahan_baku`
--
ALTER TABLE `detail_bahan_baku`
  ADD CONSTRAINT `bahan_bahan` FOREIGN KEY (`id_bahan`) REFERENCES `bahan_baku` (`id_bahan`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `bahan_menu` FOREIGN KEY (`id_menu`) REFERENCES `menu` (`id_menu`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `detail_pemesanan`
--
ALTER TABLE `detail_pemesanan`
  ADD CONSTRAINT `detail_menu` FOREIGN KEY (`id_menu`) REFERENCES `menu` (`id_menu`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `detail_pemesanan` FOREIGN KEY (`id_pemesanan`) REFERENCES `pemesanan` (`id_pemesanan`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `jawaban`
--
ALTER TABLE `jawaban`
  ADD CONSTRAINT `jawaban_pertanyaan` FOREIGN KEY (`pertanyaan`) REFERENCES `pertanyaan` (`id_pertanyaan`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `kuisioner`
--
ALTER TABLE `kuisioner`
  ADD CONSTRAINT `pegawai_kuisioner` FOREIGN KEY (`id_pegawai`) REFERENCES `pegawai` (`id_pegawai`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `pegawai`
--
ALTER TABLE `pegawai`
  ADD CONSTRAINT `jabatan_pegawai` FOREIGN KEY (`id_jabatan`) REFERENCES `jabatan` (`id_jabatan`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD CONSTRAINT `pembayaran_pegawai` FOREIGN KEY (`id_pegawai`) REFERENCES `pegawai` (`id_pegawai`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pembayaran_pemesanan` FOREIGN KEY (`id_pemesanan`) REFERENCES `pemesanan` (`id_pemesanan`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `pemesanan`
--
ALTER TABLE `pemesanan`
  ADD CONSTRAINT `pemesanan_pegawai` FOREIGN KEY (`id_pegawai`) REFERENCES `pegawai` (`id_pegawai`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `pertanyaan`
--
ALTER TABLE `pertanyaan`
  ADD CONSTRAINT `kuisioner_pertanyaan` FOREIGN KEY (`id_kuisioner`) REFERENCES `kuisioner` (`id_kuisioner`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
