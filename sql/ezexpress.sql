-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 14, 2022 at 06:27 AM
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
-- Database: `express`
--

-- --------------------------------------------------------

--
-- Table structure for table `ezexpress`
--

DROP TABLE IF EXISTS `ezexpress`;
CREATE TABLE `ezexpress` (
  `p_name` varchar(35) NOT NULL,
  `team_state` int(11) NOT NULL,
  `team_name` varchar(35) DEFAULT NULL,
  `id` int(11) NOT NULL,
  `id_img_path` varchar(255) DEFAULT NULL,
  `ship_img_path` varchar(255) DEFAULT NULL,
  `navi_idcard_path` varchar(255) DEFAULT NULL,
  `veh_img_path` varchar(255) DEFAULT NULL,
  `drive_lic_path` varchar(255) DEFAULT NULL,
  `p_member_1` varchar(255) DEFAULT NULL,
  `p_member_2` varchar(255) DEFAULT NULL,
  `p_member_3` varchar(255) DEFAULT NULL,
  `p_member_4` varchar(255) DEFAULT NULL,
  `category_id` int(35) NOT NULL,
  `ispaid` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

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
-- AUTO_INCREMENT for table `ezexpress`
--
ALTER TABLE `ezexpress`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

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
