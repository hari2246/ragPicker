-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 14, 2024 at 03:49 PM
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
-- Database: `ragpicker_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `ragpicker_id` int(11) NOT NULL,
  `booking_date` datetime DEFAULT current_timestamp(),
  `status` enum('pending','confirmed','cancelled') DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`id`, `user_id`, `ragpicker_id`, `booking_date`, `status`) VALUES
(1, 1, 2, '2024-07-14 13:20:28', 'pending'),
(2, 3, 2, '2024-07-14 13:32:34', 'pending'),
(3, 4, 2, '2024-07-14 13:50:36', 'pending'),
(4, 1, 2, '2024-07-14 13:56:14', 'pending'),
(5, 1, 2, '2024-07-14 13:57:51', 'pending'),
(6, 1, 2, '2024-07-14 14:11:50', 'pending'),
(7, 1, 2, '2024-07-14 14:12:46', 'pending');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('user','ragpicker') NOT NULL DEFAULT 'user',
  `location` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `location`, `created_at`) VALUES
(1, 'S.Hari Krishna', 'harisuddamalla24@gmail.com', '$2y$10$ILaRv6Drbal69Jr7eGu0yuWqhmVRFlIIZEt2khdJ3b6dUXjeq8NB.', 'user', NULL, '2024-07-14 04:20:03'),
(2, 'john', 'john@gmail.com', '$2y$10$LTJ7nnFgACAl3K92HKZ2geLfzK/urrxUNqcfxL0t/WVLTt3X6xUTO', 'ragpicker', 'piler', '2024-07-14 04:20:51'),
(3, 'alice', 'alice@gmail.com', '$2y$10$HMMkLjvaSyfxJPYhHtzMTODShsub7mQBCvWJf//2LrQKSk2hl9ugu', 'user', NULL, '2024-07-14 08:01:59'),
(4, 'bob', 'bob@gmail.com', '$2y$10$lQnYO7GMkHiX7JIszkACiOOd2kZPgP.nEj7RAHwMqyXxxhb/Ing6y', 'user', NULL, '2024-07-14 08:20:09'),
(5, 'charles', 'charles@gmail.com', '$2y$10$BTetq2ZUU49QDUMMXHI2T.rYr3uq3UsVbusI2XqIYTs0YCMoDJ1OG', 'ragpicker', 'tirupati', '2024-07-14 09:04:50');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `ragpicker_id` (`ragpicker_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `bookings_ibfk_2` FOREIGN KEY (`ragpicker_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
