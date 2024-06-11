-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jun 11, 2024 at 06:50 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `book_store_web`
--

-- --------------------------------------------------------

--
-- Table structure for table `files`
--

CREATE TABLE `files` (
  `id` int(10) UNSIGNED NOT NULL,
  `filename` varchar(255) NOT NULL,
  `storage_path` varchar(255) NOT NULL,
  `mime_type` varchar(255) NOT NULL,
  `author` varchar(255) DEFAULT NULL,
  `size` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `files`
--

INSERT INTO `files` (`id`, `filename`, `storage_path`, `mime_type`, `author`, `size`) VALUES
(30, 'DUPR_project.pdf', '/storage/uploads/4e04c2e9c21bb063ae9da01bcf41edf0', 'application/pdf', 'vasi', 1915081),
(31, 'PCHMI.pdf', '/storage/uploads/c8980aac6ff9d8f50327362e802d9776', 'application/pdf', 'vasi', 187518),
(32, 'СнежинкатаНаКох.pdf', '/storage/uploads/8bdd287dc4c02d98709871f793d6ead0', 'application/pdf', 'desi', 211851),
(33, 'Килимът на Сиерпински.pdf', '/storage/uploads/d5074be1947f8963c29620f41e1d0479', 'application/pdf', 'desi', 133321),
(34, 'PCHMI_template.pdf', '/storage/uploads/5c4b2fc673272d129a4c45895661e1e6', 'application/pdf', 'vasi', 237677),
(35, 'ASI-Presentatione.pdf', '/storage/uploads/3408210956b5c49c6ad60437ff3abe3b', 'application/pdf', 'edi', 174350);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `email` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(512) NOT NULL,
  `roles` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `username`, `password`, `roles`) VALUES
(1, 'vasi@gmail.com', 'vasi', '$2y$10$D1m3JpfitjCXrdb6rDkxQ.ofwHuMq5WhUwt92IFXUL.ckzclrT6PS', '[\"user\"]'),
(2, 'desi@gmail.com', 'desi', '$2y$10$zxg31bQzrtdyg4nKhMWcGuZlGKitzRtjijvbusWjXQl1uKICJsoOS', '[\"user\"]'),
(3, 'edi@gmail.com', 'edi', '$2y$10$WtuBndJW5nCoHOtU/t8k4em.Ke63Tv.2Fpk/MKU6FoNCS7kgLdLFC', '[\"user\"]');

-- --------------------------------------------------------

--
-- Table structure for table `user_files`
--

CREATE TABLE `user_files` (
  `user_id` int(10) UNSIGNED NOT NULL,
  `book_id` int(10) UNSIGNED NOT NULL,
  `return_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_files`
--

INSERT INTO `user_files` (`user_id`, `book_id`, `return_date`) VALUES
(1, 33, '2024-07-01'),
(1, 35, '2024-07-01'),
(2, 31, '2024-07-01'),
(2, 35, '2024-07-01'),
(3, 31, '2024-07-01'),
(3, 32, '2024-07-01'),
(3, 35, '2024-07-01');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `files`
--
ALTER TABLE `files`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `user_files`
--
ALTER TABLE `user_files`
  ADD UNIQUE KEY `user_id_book_id` (`user_id`,`book_id`),
  ADD KEY `user_id` (`user_id`,`book_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `files`
--
ALTER TABLE `files`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
