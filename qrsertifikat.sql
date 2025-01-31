-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jan 31, 2025 at 05:05 AM
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
-- Database: `qrsertifikat`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `idadmin` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `namalengkap` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`idadmin`, `username`, `password`, `namalengkap`) VALUES
(5, 'admin', '$2y$10$Q5II/fscvlYz4GbO9BjVJebrJT8olYWgb9P0POATRMEzSP7sO1KJu', 'Admin');

-- --------------------------------------------------------

--
-- Table structure for table `dsertifikat`
--

CREATE TABLE `dsertifikat` (
  `id` int(11) NOT NULL,
  `tanggal` datetime NOT NULL DEFAULT current_timestamp(),
  `nama` varchar(50) DEFAULT NULL,
  `id_donor` varchar(50) DEFAULT NULL,
  `no_hp` varchar(15) DEFAULT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `no_sertifikat` varchar(40) DEFAULT NULL,
  `kategori` enum('10','25','50','75') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `dsertifikat`
--

INSERT INTO `dsertifikat` (`id`, `tanggal`, `nama`, `id_donor`, `no_hp`, `tanggal_lahir`, `no_sertifikat`, `kategori`) VALUES
(3, '2025-01-23 13:49:45', 'EDY BAGOES', '1271DGEDY00023', '082367677179', '1979-07-10', '001/1.01.02/PK - SERT/DD/I/2025', '25'),
(4, '2025-01-25 10:01:57', 'DEVI PURWANTI', '1271DGDEV000017', '085277116491', '1977-12-14', '002/1.01.02/PK - SERT/DD/I/2025', '10');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`idadmin`);

--
-- Indexes for table `dsertifikat`
--
ALTER TABLE `dsertifikat`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `no_piagam` (`no_sertifikat`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `idadmin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `dsertifikat`
--
ALTER TABLE `dsertifikat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
