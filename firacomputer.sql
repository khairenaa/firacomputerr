-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 19, 2025 at 09:59 AM
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
-- Database: `firacomputer`
--

-- --------------------------------------------------------

--
-- Table structure for table `custom_pc_requests`
--

CREATE TABLE `custom_pc_requests` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `budget` decimal(10,2) NOT NULL,
  `email` varchar(255) NOT NULL,
  `submitted_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `custom_pc_requests`
--

INSERT INTO `custom_pc_requests` (`id`, `name`, `phone`, `budget`, `email`, `submitted_at`) VALUES
(22, 'Khairena', '0175979139', 5500.00, 'abbkhairena@gmail.com', '2025-07-19 07:58:55');

-- --------------------------------------------------------

--
-- Table structure for table `laptop_requests`
--

CREATE TABLE `laptop_requests` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `budget` decimal(10,2) NOT NULL,
  `condition` enum('new','refurbished') NOT NULL,
  `type` enum('normal','gaming') NOT NULL,
  `spec` text DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `submitted_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `laptop_requests`
--

INSERT INTO `laptop_requests` (`id`, `name`, `phone`, `budget`, `condition`, `type`, `spec`, `email`, `submitted_at`) VALUES
(12, 'Khairena', '0175979139', 3050.00, 'new', 'normal', 'Intel i5-13th GEN\r\n16GB RAM\r\n1TB STORAGE', 'abbkhairena@gmail.com', '2025-07-18 18:16:51');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `custom_pc_requests`
--
ALTER TABLE `custom_pc_requests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `laptop_requests`
--
ALTER TABLE `laptop_requests`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `custom_pc_requests`
--
ALTER TABLE `custom_pc_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `laptop_requests`
--
ALTER TABLE `laptop_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
