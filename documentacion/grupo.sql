-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jul 16, 2022 at 08:13 PM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 7.3.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `upqroo`
--

-- --------------------------------------------------------

--
-- Table structure for table `grupo`
--

CREATE TABLE `grupo` (
  `id` bigint(20) NOT NULL,
  `PDOCVE` int(4) DEFAULT NULL,
  `CARCVE` varchar(1) DEFAULT NULL,
  `PLACVE` varchar(1) DEFAULT NULL,
  `ESPCVE` varchar(1) DEFAULT NULL,
  `PAQCVE` varchar(3) DEFAULT NULL,
  `MATCVE` varchar(7) DEFAULT NULL,
  `GPOCVE` varchar(2) DEFAULT NULL,
  `LIMNUM` varchar(2) DEFAULT NULL,
  `INSNUM` varchar(2) DEFAULT NULL,
  `PERCVE` varchar(3) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `grupo`
--

INSERT INTO `grupo` (`id`, `PDOCVE`, `CARCVE`, `PLACVE`, `ESPCVE`, `PAQCVE`, `MATCVE`, `GPOCVE`, `LIMNUM`, `INSNUM`, `PERCVE`) VALUES
(168, 3122, '3', 'A', '', '051', 'BDN', '01', '20', '12', '81'),
(308, 3122, '3', 'A', '', '052', 'BDN', '02', '20', '10', '81'),
(3589, 3122, '3', 'A', '', '051', 'BDN', '01', '20', '12', '81'),
(3729, 3122, '3', 'A', '', '052', 'BDN', '02', '20', '10', '81');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
