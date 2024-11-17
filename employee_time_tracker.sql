-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 17, 2024 at 03:58 PM
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
-- Database: `employee_time_tracker`
--

-- --------------------------------------------------------

--
-- Table structure for table `daily_session`
--

CREATE TABLE `daily_session` (
  `id` int(11) NOT NULL,
  `employee_id` int(11) DEFAULT NULL,
  `time_consumed` int(11) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `regular_hour` int(11) NOT NULL DEFAULT 8,
  `over_time` int(11) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `daily_session`
--

INSERT INTO `daily_session` (`id`, `employee_id`, `time_consumed`, `date`, `regular_hour`, `over_time`, `created_at`) VALUES
(35, 30, 46, '2024-11-10', 8, 0, '2024-11-10 03:14:06'),
(36, 34, 3, '2024-11-10', 8, 0, '2024-11-10 03:14:27'),
(37, 30, 28800, '2024-11-11', 8, 31, '2024-11-11 02:05:42'),
(38, 30, 73, '2024-11-12', 8, 0, '2024-11-12 00:50:35'),
(39, 30, 2, '2024-11-14', 8, 0, '2024-11-14 01:23:10');

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

CREATE TABLE `employee` (
  `id` int(11) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `age` int(11) NOT NULL,
  `password` varchar(255) NOT NULL,
  `street_address` varchar(255) NOT NULL,
  `suburb` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `state` varchar(255) NOT NULL,
  `postcode` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL,
  `verify_token` varchar(255) NOT NULL,
  `expiration_token` datetime NOT NULL,
  `verified` varchar(255) NOT NULL,
  `reset_code` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`id`, `fullname`, `email`, `age`, `password`, `street_address`, `suburb`, `city`, `state`, `postcode`, `country`, `verify_token`, `expiration_token`, `verified`, `reset_code`, `role`, `created_at`) VALUES
(30, 'CARLO GARCIA', 'carlodatugarcia@gmail.com', 20, 'dec18b1c76eb181beb92071ccc0e727b', 'San Francisco', 'Tarlac city', 'Tarlac city', 'Tarlac', '2316', 'Philippines', 'c29460b8d65d5b86d82b3e3e5d959f04', '2024-11-04 10:11:59', 'yes', 'e6952741c018ecda7f36044dc292b577', 'employee', '2024-11-04 10:01:59'),
(34, 'CARLO GARCIA', 'lifehack825@gmail.com', 20, '39fca9daf377b2ac37acdca8e4abc83b', 'San Francisco', 'Tarlac city', 'Tarlac city', 'Tarlac', '2316', 'Philippines', '7c2424fa5d0b110770cf75ad717ade34', '2024-11-09 00:30:38', 'yes', '5af4f5fbe3d489507bc497348c03b2fd', 'employee', '2024-11-09 00:20:02'),
(54, 'CARLO GARCIA datu', 'kaloygarcia8@gmail.com', 20, '0192023a7bbd73250516f069df18b500', 'San Francisco', 'Tarlac city', 'Tarlac city', 'Tarlac', '2316', 'Philippines', '09b7c5af4830adf55937135a0775fb7b', '2024-11-17 22:44:36', 'yes', '', 'employee', '2024-11-17 22:34:36');

-- --------------------------------------------------------

--
-- Table structure for table `time_entries`
--

CREATE TABLE `time_entries` (
  `id` int(11) NOT NULL,
  `employee_id` int(11) DEFAULT NULL,
  `date` date NOT NULL,
  `time_started` datetime NOT NULL,
  `time_ended` datetime NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `time_entries`
--

INSERT INTO `time_entries` (`id`, `employee_id`, `date`, `time_started`, `time_ended`, `created_at`) VALUES
(288, 30, '2024-11-10', '2024-11-10 03:14:00', '2024-11-10 03:14:06', '2024-11-10 03:14:06'),
(289, 34, '2024-11-10', '2024-11-10 03:14:24', '2024-11-10 03:14:27', '2024-11-10 03:14:27'),
(290, 30, '2024-11-10', '2024-11-10 15:10:41', '2024-11-10 15:10:44', '2024-11-10 15:10:44'),
(291, 30, '2024-11-10', '2024-11-10 15:11:26', '2024-11-10 15:11:29', '2024-11-10 15:11:29'),
(292, 30, '2024-11-10', '2024-11-10 15:12:29', '2024-11-10 15:12:33', '2024-11-10 15:12:33'),
(293, 30, '2024-11-10', '2024-11-10 15:12:47', '2024-11-10 15:12:49', '2024-11-10 15:12:49'),
(294, 30, '2024-11-10', '2024-11-10 15:13:05', '2024-11-10 15:13:11', '2024-11-10 15:13:11'),
(295, 30, '2024-11-10', '2024-11-10 15:18:20', '2024-11-10 15:18:22', '2024-11-10 15:18:22'),
(296, 30, '2024-11-10', '2024-11-10 15:32:34', '2024-11-10 15:32:37', '2024-11-10 15:32:37'),
(297, 30, '2024-11-10', '2024-11-10 15:32:34', '2024-11-10 15:32:37', '2024-11-10 15:32:37'),
(298, 30, '2024-11-10', '2024-11-10 15:32:42', '2024-11-10 15:32:44', '2024-11-10 15:32:44'),
(299, 30, '2024-11-10', '2024-11-10 15:32:42', '2024-11-10 15:32:44', '2024-11-10 15:32:44'),
(300, 30, '2024-11-10', '2024-11-10 15:33:05', '2024-11-10 15:33:09', '2024-11-10 15:33:09'),
(301, 30, '2024-11-10', '2024-11-10 15:33:05', '2024-11-10 15:33:09', '2024-11-10 15:33:09'),
(302, 30, '2024-11-10', '2024-11-10 15:33:42', '2024-11-10 15:33:44', '2024-11-10 15:33:44'),
(309, 30, '2024-11-11', '2024-11-11 02:48:44', '2024-11-11 02:48:48', '2024-11-11 02:48:48'),
(310, 30, '2024-11-11', '2024-11-11 02:49:06', '2024-11-11 10:49:11', '2024-11-11 02:49:11'),
(311, 30, '2024-11-11', '2024-11-11 02:49:37', '2024-11-11 02:49:42', '2024-11-11 02:49:42'),
(312, 30, '2024-11-11', '2024-11-11 02:57:57', '2024-11-11 02:58:03', '2024-11-11 02:58:03'),
(313, 30, '2024-11-11', '2024-11-11 03:00:35', '2024-11-11 03:00:38', '2024-11-11 03:00:38'),
(314, 30, '2024-11-11', '2024-11-11 03:02:14', '2024-11-11 03:02:16', '2024-11-11 03:02:16'),
(315, 30, '2024-11-11', '2024-11-11 03:03:08', '2024-11-11 03:03:12', '2024-11-11 03:03:12'),
(316, 30, '2024-11-11', '2024-11-11 03:03:15', '2024-11-11 03:03:17', '2024-11-11 03:03:17'),
(319, 30, '2024-11-11', '2024-11-11 18:04:40', '2024-11-11 18:04:45', '2024-11-12 01:04:45'),
(321, 30, '2024-11-11', '2024-11-11 18:15:10', '2024-11-11 18:15:14', '2024-11-12 01:15:14'),
(322, 30, '2024-11-11', '2024-11-11 18:16:20', '2024-11-11 18:16:22', '2024-11-12 01:16:22'),
(323, 30, '2024-11-11', '2024-11-11 18:16:44', '2024-11-11 18:16:46', '2024-11-12 01:16:46'),
(324, 30, '2024-11-11', '2024-11-11 18:17:31', '2024-11-11 18:17:35', '2024-11-12 01:17:35'),
(325, 30, '2024-11-11', '2024-11-11 18:17:52', '2024-11-11 18:17:56', '2024-11-12 01:17:56'),
(326, 30, '2024-11-11', '2024-11-11 18:18:00', '2024-11-11 18:18:03', '2024-11-12 01:18:03'),
(327, 30, '2024-11-11', '2024-11-11 18:21:48', '2024-11-11 18:21:50', '2024-11-12 01:21:50'),
(328, 30, '2024-11-11', '2024-11-11 18:22:16', '2024-11-11 18:22:19', '2024-11-12 01:22:19'),
(329, 30, '2024-11-11', '2024-11-11 18:23:16', '2024-11-11 18:23:17', '2024-11-12 01:23:17'),
(330, 30, '2024-11-11', '2024-11-11 18:24:22', '2024-11-11 18:24:26', '2024-11-12 01:24:26'),
(333, 30, '2024-11-11', '2024-11-11 18:33:40', '2024-11-11 18:33:42', '2024-11-12 01:33:42'),
(334, 30, '2024-11-11', '2024-11-11 18:36:12', '2024-11-11 18:36:15', '2024-11-12 01:36:15'),
(335, 30, '2024-11-11', '2024-11-11 18:36:33', '2024-11-11 18:36:35', '2024-11-12 01:36:35'),
(336, 30, '2024-11-11', '2024-11-11 18:36:45', '2024-11-11 18:36:49', '2024-11-12 01:36:49'),
(337, 30, '2024-11-11', '2024-11-11 18:38:02', '2024-11-11 18:38:05', '2024-11-12 01:38:05'),
(351, 30, '2024-11-12', '2024-11-12 01:48:59', '2024-11-12 01:49:02', '2024-11-12 01:49:02'),
(352, 30, '2024-11-12', '2024-11-12 01:49:06', '2024-11-12 01:49:11', '2024-11-12 01:49:11'),
(353, 30, '2024-11-12', '2024-11-12 01:49:16', '2024-11-12 01:49:18', '2024-11-12 01:49:18'),
(354, 30, '2024-11-12', '2024-11-12 01:49:20', '2024-11-12 01:49:26', '2024-11-12 01:49:26'),
(355, 30, '2024-11-12', '2024-11-12 01:49:37', '2024-11-12 01:49:41', '2024-11-12 01:49:41'),
(356, 30, '2024-11-12', '2024-11-12 01:49:43', '2024-11-12 01:49:52', '2024-11-12 01:49:52'),
(357, 30, '2024-11-12', '2024-11-12 01:50:02', '2024-11-12 01:50:05', '2024-11-12 01:50:05'),
(358, 30, '2024-11-12', '2024-11-12 01:50:12', '2024-11-12 01:50:29', '2024-11-12 01:50:29'),
(359, 30, '2024-11-12', '2024-11-12 01:50:50', '2024-11-12 01:50:52', '2024-11-12 01:50:52'),
(360, 30, '2024-11-12', '2024-11-12 01:50:54', '2024-11-12 01:50:55', '2024-11-12 01:50:55'),
(361, 30, '2024-11-12', '2024-11-12 01:50:56', '2024-11-12 01:50:58', '2024-11-12 01:50:58'),
(362, 30, '2024-11-12', '2024-11-12 01:52:01', '2024-11-12 01:52:04', '2024-11-12 01:52:04'),
(363, 30, '2024-11-12', '2024-11-12 01:52:06', '2024-11-12 01:52:08', '2024-11-12 01:52:08'),
(364, 30, '2024-11-12', '2024-11-12 01:52:08', '2024-11-12 01:52:14', '2024-11-12 01:52:14'),
(365, 30, '2024-11-12', '2024-11-12 01:52:25', '2024-11-12 01:52:27', '2024-11-12 01:52:27'),
(366, 30, '2024-11-12', '2024-11-12 01:52:28', '2024-11-12 01:52:30', '2024-11-12 01:52:30'),
(367, 30, '2024-11-12', '2024-11-12 01:52:31', '2024-11-12 01:52:32', '2024-11-12 01:52:32'),
(368, 30, '2024-11-11', '2024-11-11 18:53:26', '2024-11-11 18:53:30', '2024-11-12 01:53:30'),
(369, 30, '2024-11-11', '2024-11-11 18:53:31', '2024-11-11 18:53:36', '2024-11-12 01:53:36'),
(370, 30, '2024-11-11', '2024-11-11 18:55:16', '2024-11-11 18:55:20', '2024-11-12 01:55:20'),
(371, 30, '2024-11-11', '2024-11-11 18:57:55', '2024-11-11 18:57:58', '2024-11-12 01:57:58'),
(372, 30, '2024-11-11', '2024-11-11 18:58:30', '2024-11-11 18:58:32', '2024-11-12 01:58:32'),
(373, 30, '2024-11-12', '2024-11-12 02:12:29', '2024-11-12 02:12:32', '2024-11-12 02:12:32'),
(374, 30, '2024-11-14', '2024-11-14 01:23:08', '2024-11-14 01:23:10', '2024-11-14 01:23:10');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `daily_session`
--
ALTER TABLE `daily_session`
  ADD PRIMARY KEY (`id`),
  ADD KEY `daily_session_ibfk_1` (`employee_id`);

--
-- Indexes for table `employee`
--
ALTER TABLE `employee`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`email`);

--
-- Indexes for table `time_entries`
--
ALTER TABLE `time_entries`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_customer_id` (`employee_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `daily_session`
--
ALTER TABLE `daily_session`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `employee`
--
ALTER TABLE `employee`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT for table `time_entries`
--
ALTER TABLE `time_entries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=391;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `daily_session`
--
ALTER TABLE `daily_session`
  ADD CONSTRAINT `daily_session_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `employee` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `time_entries`
--
ALTER TABLE `time_entries`
  ADD CONSTRAINT `fk_customer_id` FOREIGN KEY (`employee_id`) REFERENCES `employee` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
