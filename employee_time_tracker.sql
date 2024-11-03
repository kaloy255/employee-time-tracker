-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 02, 2024 at 09:26 PM
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
  `regular_hour` int(11) NOT NULL,
  `over_time` int(11) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `daily_session`
--

INSERT INTO `daily_session` (`id`, `employee_id`, `time_consumed`, `date`, `regular_hour`, `over_time`, `created_at`) VALUES
(18, 27, 0, '2024-11-03', 0, 2, '2024-11-03 04:22:48');

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
(27, 'CARLO GARCIA', 'carlodatugarcia@gmail.com', 20, '0192023a7bbd73250516f069df18b500', 'San Francisco', 'Tarlac city', 'Tarlac city', 'Tarlac', '2316', 'Philippines', '91c35c68aa55aa10aca54b1fe634f429', '2024-11-03 04:15:16', 'yes', '14a82a7932b35c7275d5855ceaddb059', 'employee', '2024-11-03 04:05:03');

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
(184, 27, '2024-11-03', '2024-11-03 04:22:48', '2024-11-03 04:22:50', '2024-11-03 04:22:48');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `employee`
--
ALTER TABLE `employee`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `time_entries`
--
ALTER TABLE `time_entries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=185;

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
