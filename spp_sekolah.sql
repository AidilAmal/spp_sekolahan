-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 01, 2026 at 04:04 AM
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
-- Database: `spp_sekolah`
--

-- --------------------------------------------------------

--
-- Table structure for table `tb_cek_pembayaran`
--

CREATE TABLE `tb_cek_pembayaran` (
  `nisn` varchar(10) NOT NULL,
  `tgl_terakhir_bayar` date DEFAULT NULL,
  `tgl_sekarang` date DEFAULT NULL,
  `status_pembayaran` enum('Belum Lunas','Sudah Lunas') DEFAULT NULL,
  `jumlah_bulan` varchar(5) DEFAULT NULL,
  `nama` varchar(50) DEFAULT NULL,
  `no_telp` varchar(13) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_kelas`
--

CREATE TABLE `tb_kelas` (
  `id_kelas` varchar(11) NOT NULL,
  `nama_kelas` varchar(10) DEFAULT NULL,
  `komp_keahlian` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_kelas`
--

INSERT INTO `tb_kelas` (`id_kelas`, `nama_kelas`, `komp_keahlian`) VALUES
('KLS-0001', 'X TB 1', 'Tata Boga'),
('KLS-0002', 'X SM 1', 'Seni Masak'),
('KLS-0003', 'XI TB 1', 'Tata Boga'),
('KLS-0004', 'XI SM 1', 'Seni Masak'),
('KLS-0005', 'XII TB 1', 'Tata Boga');

-- --------------------------------------------------------

--
-- Table structure for table `tb_pembayaran`
--

CREATE TABLE `tb_pembayaran` (
  `id_pembayaran` varchar(11) NOT NULL,
  `status` enum('Belum Lunas','Sudah Lunas') DEFAULT NULL,
  `nisn` varchar(10) DEFAULT NULL,
  `tgl_bayar` date DEFAULT NULL,
  `tgl_terakhir_bayar` date DEFAULT NULL,
  `batas_pembayaran` date DEFAULT NULL,
  `jumlah_bulan` varchar(10) DEFAULT NULL,
  `id_spp` varchar(40) DEFAULT NULL,
  `nominal_bayar` varchar(100) DEFAULT NULL,
  `jumlah_bayar` varchar(40) DEFAULT NULL,
  `kembalian` varchar(100) DEFAULT NULL,
  `id_petugas` varchar(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_pembayaran`
--

INSERT INTO `tb_pembayaran` (`id_pembayaran`, `status`, `nisn`, `tgl_bayar`, `tgl_terakhir_bayar`, `batas_pembayaran`, `jumlah_bulan`, `id_spp`, `nominal_bayar`, `jumlah_bayar`, `kembalian`, `id_petugas`) VALUES
('PAY-0001', 'Sudah Lunas', 'NIS-0001', '2026-09-01', '2026-09-01', '2026-09-10', '3', 'SPP-0001', '900000', '1000000', '100000', 'P001'),
('PAY-0002', 'Belum Lunas', 'NIS-0002', '2026-09-05', '2026-09-05', '2026-09-10', '2', 'SPP-0002', '700000', '500000', '0', 'P002');

-- --------------------------------------------------------

--
-- Table structure for table `tb_petugas`
--

CREATE TABLE `tb_petugas` (
  `id_petugas` varchar(11) NOT NULL,
  `username` varchar(25) DEFAULT NULL,
  `password` varchar(32) DEFAULT NULL,
  `nama_petugas` varchar(35) DEFAULT NULL,
  `level` enum('admin','petugas','siswa') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_petugas`
--

INSERT INTO `tb_petugas` (`id_petugas`, `username`, `password`, `nama_petugas`, `level`) VALUES
('P001', 'admin', 'admin123', 'Administrator', 'admin'),
('P002', 'petugas', '12345', 'Petugas SPP', 'petugas');

-- --------------------------------------------------------

--
-- Table structure for table `tb_siswa`
--

CREATE TABLE `tb_siswa` (
  `nisn` varchar(10) NOT NULL,
  `nis` varchar(8) DEFAULT NULL,
  `nama` varchar(50) DEFAULT NULL,
  `id_kelas` varchar(11) DEFAULT NULL,
  `nama_kelas` varchar(10) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `no_telp` varchar(13) DEFAULT NULL,
  `id_spp` varchar(40) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_siswa`
--

INSERT INTO `tb_siswa` (`nisn`, `nis`, `nama`, `id_kelas`, `nama_kelas`, `alamat`, `no_telp`, `id_spp`) VALUES
('NIS-0001', '000001', 'Yanto', 'KLS-0005', 'XII TB 1', 'Jl. Selebew', '081234567890', 'SPP-0001'),
('NIS-0002', '000002', 'Budi Santoso', 'KLS-0001', 'X TB 1', 'Jl. Merdeka No.2', '082233445566', 'SPP-0002'),
('NIS-0003', '000003', 'Citra Lestari', 'KLS-0002', 'X SM 1', 'Jl. Mawar No.3', '083344556677', 'SPP-0003'),
('NIS-0004', '000004', 'Dina Putri', 'KLS-0003', 'XI TB 1', 'Jl. Melati No.4', '084455667788', 'SPP-0004'),
('NIS-0005', '000005', 'Eko Prasetyo', 'KLS-0004', 'XI SM 1', 'Jl. Kenanga No.5', '085566778899', 'SPP-0005');

-- --------------------------------------------------------

--
-- Table structure for table `tb_spp`
--

CREATE TABLE `tb_spp` (
  `id_spp` varchar(11) NOT NULL,
  `tahun` int(11) DEFAULT NULL,
  `nominal` varchar(40) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_spp`
--

INSERT INTO `tb_spp` (`id_spp`, `tahun`, `nominal`) VALUES
('SPP-0001', 2025, '300000'),
('SPP-0002', 2026, '350000'),
('SPP-0003', 2027, '400000'),
('SPP-0004', 2028, '450000'),
('SPP-0005', 2029, '500000');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_cek_pembayaran`
--
ALTER TABLE `tb_cek_pembayaran`
  ADD PRIMARY KEY (`nisn`);

--
-- Indexes for table `tb_kelas`
--
ALTER TABLE `tb_kelas`
  ADD PRIMARY KEY (`id_kelas`);

--
-- Indexes for table `tb_pembayaran`
--
ALTER TABLE `tb_pembayaran`
  ADD PRIMARY KEY (`id_pembayaran`),
  ADD KEY `nisn` (`nisn`),
  ADD KEY `id_spp` (`id_spp`(11)),
  ADD KEY `id_petugas` (`id_petugas`);

--
-- Indexes for table `tb_petugas`
--
ALTER TABLE `tb_petugas`
  ADD PRIMARY KEY (`id_petugas`);

--
-- Indexes for table `tb_siswa`
--
ALTER TABLE `tb_siswa`
  ADD PRIMARY KEY (`nisn`),
  ADD KEY `id_kelas` (`id_kelas`),
  ADD KEY `id_spp` (`id_spp`(11));

--
-- Indexes for table `tb_spp`
--
ALTER TABLE `tb_spp`
  ADD PRIMARY KEY (`id_spp`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tb_cek_pembayaran`
--
ALTER TABLE `tb_cek_pembayaran`
  ADD CONSTRAINT `tb_cek_pembayaran_ibfk_1` FOREIGN KEY (`nisn`) REFERENCES `tb_siswa` (`nisn`);

--
-- Constraints for table `tb_pembayaran`
--
ALTER TABLE `tb_pembayaran`
  ADD CONSTRAINT `tb_pembayaran_ibfk_1` FOREIGN KEY (`nisn`) REFERENCES `tb_siswa` (`nisn`),
  ADD CONSTRAINT `tb_pembayaran_ibfk_3` FOREIGN KEY (`id_petugas`) REFERENCES `tb_petugas` (`id_petugas`);

--
-- Constraints for table `tb_siswa`
--
ALTER TABLE `tb_siswa`
  ADD CONSTRAINT `tb_siswa_ibfk_1` FOREIGN KEY (`id_kelas`) REFERENCES `tb_kelas` (`id_kelas`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
