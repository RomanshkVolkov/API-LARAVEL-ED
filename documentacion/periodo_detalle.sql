-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jul 18, 2022 at 03:46 AM
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
-- Database: `evasys_upqroo`
--

-- --------------------------------------------------------

--
-- Table structure for table `periodo_detalle`
--

CREATE TABLE `periodo_detalle` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `periodo_id` bigint(20) UNSIGNED NOT NULL,
  `carrera_id` bigint(20) UNSIGNED NOT NULL,
  `personal_id` bigint(20) UNSIGNED NOT NULL,
  `materia_id` bigint(20) UNSIGNED NOT NULL,
  `grupo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `plan_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `periodo_detalle`
--

INSERT INTO `periodo_detalle` (`id`, `periodo_id`, `carrera_id`, `personal_id`, `materia_id`, `grupo`, `plan_id`, `created_at`, `updated_at`) VALUES
(1304, 9, 1, 41, 236, '', 1, NULL, NULL),
(3290, 19, 3, 232, 58, '', 3, NULL, NULL),
(3305, 19, 1, 247, 31, '', 1, NULL, NULL),
(3306, 19, 1, 112, 37, '', 1, NULL, NULL),
(3307, 19, 1, 272, 35, '', 1, NULL, NULL),
(3308, 19, 1, 147, 36, '', 1, NULL, NULL),
(3309, 19, 1, 308, 34, '', 1, NULL, NULL),
(3310, 19, 1, 5, 32, '', 1, NULL, NULL),
(3311, 19, 1, 232, 33, '', 1, NULL, NULL),
(3312, 19, 1, 53, 31, '', 1, NULL, NULL),
(3313, 19, 1, 189, 37, '', 1, NULL, NULL),
(3314, 19, 1, 247, 35, '', 1, NULL, NULL),
(3315, 19, 1, 262, 36, '', 1, NULL, NULL),
(3316, 19, 1, 119, 34, '', 1, NULL, NULL),
(3317, 19, 1, 146, 33, '', 1, NULL, NULL),
(3318, 19, 1, 308, 82, '', 1, NULL, NULL),
(3319, 19, 1, 306, 86, '', 1, NULL, NULL),
(3320, 19, 1, 222, 87, '', 1, NULL, NULL),
(3321, 19, 1, 262, 85, '', 1, NULL, NULL),
(3322, 19, 1, 232, 55, '', 1, NULL, NULL),
(3323, 19, 1, 112, 83, '', 1, NULL, NULL),
(3324, 19, 1, 84, 84, '', 1, NULL, NULL),
(3325, 19, 1, 247, 96, '', 1, NULL, NULL),
(3326, 19, 1, 307, 98, '', 1, NULL, NULL),
(3327, 19, 1, 5, 100, '', 1, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `periodo_detalle`
--
ALTER TABLE `periodo_detalle`
  ADD PRIMARY KEY (`id`),
  ADD KEY `periodo_detalle_periodo_id_foreign` (`periodo_id`),
  ADD KEY `periodo_detalle_carrera_id_foreign` (`carrera_id`),
  ADD KEY `periodo_detalle_materia_id_foreign` (`materia_id`),
  ADD KEY `periodo_detalle_personal_id_foreign` (`personal_id`),
  ADD KEY `periodo_detalle_plan_id_foreign` (`plan_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `periodo_detalle`
--
ALTER TABLE `periodo_detalle`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3341;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `periodo_detalle`
--
ALTER TABLE `periodo_detalle`
  ADD CONSTRAINT `periodo_detalle_carrera_id_foreign` FOREIGN KEY (`carrera_id`) REFERENCES `carrera` (`id`),
  ADD CONSTRAINT `periodo_detalle_materia_id_foreign` FOREIGN KEY (`materia_id`) REFERENCES `materia` (`id`),
  ADD CONSTRAINT `periodo_detalle_periodo_id_foreign` FOREIGN KEY (`periodo_id`) REFERENCES `periodo` (`id`),
  ADD CONSTRAINT `periodo_detalle_personal_id_foreign` FOREIGN KEY (`personal_id`) REFERENCES `personal` (`id`),
  ADD CONSTRAINT `periodo_detalle_plan_id_foreign` FOREIGN KEY (`plan_id`) REFERENCES `plan` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
