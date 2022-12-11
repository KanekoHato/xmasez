-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 11, 2022 at 06:23 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ezxmas`
--
CREATE DATABASE IF NOT EXISTS `ezxmas` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `ezxmas`;

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

DROP TABLE IF EXISTS `category`;
CREATE TABLE `category` (
  `id` int(255) NOT NULL,
  `category` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `category`) VALUES
(1, 'Paint Ball'),
(2, 'Rally - Time Attack'),
(3, 'Rally - Laps'),
(4, 'Fishing');

-- --------------------------------------------------------

--
-- Table structure for table `ezexpress`
--

DROP TABLE IF EXISTS `ezexpress`;
CREATE TABLE `ezexpress` (
  `p_name` varchar(35) NOT NULL,
  `team_state` int(11) NOT NULL,
  `team_name` varchar(35) NOT NULL,
  `id` int(11) NOT NULL,
  `id_img_path` varchar(255) NOT NULL,
  `ship_img_path` varchar(255) NOT NULL,
  `navi_idcard_path` varchar(255) NOT NULL,
  `veh_img_path` varchar(255) NOT NULL,
  `drive_lic_path` varchar(255) NOT NULL,
  `p_member_1` varchar(255) NOT NULL,
  `p_member_2` varchar(255) NOT NULL,
  `p_member_3` varchar(255) NOT NULL,
  `p_member_4` varchar(255) NOT NULL,
  `category_id` int(35) NOT NULL,
  `ispaid` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ezexpress`
--
ALTER TABLE `ezexpress`
  ADD PRIMARY KEY (`id`),
  ADD KEY `CAT_FKEY` (`category_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `ezexpress`
--
ALTER TABLE `ezexpress`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `ezexpress`
--
ALTER TABLE `ezexpress`
  ADD CONSTRAINT `CAT_FKEY` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
