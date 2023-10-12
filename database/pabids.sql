-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Oct 12, 2023 at 04:08 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pabids`
--

-- --------------------------------------------------------

--
-- Table structure for table `address`
--

CREATE TABLE `address` (
  `id` int(11) NOT NULL,
  `country` varchar(145) DEFAULT NULL,
  `province` varchar(145) DEFAULT NULL,
  `city` varchar(145) DEFAULT NULL,
  `barangay` varchar(145) DEFAULT NULL,
  `street` varchar(145) DEFAULT NULL,
  `zip_code` varchar(145) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bidding`
--

CREATE TABLE `bidding` (
  `id` int(11) NOT NULL,
  `user_id` int(14) DEFAULT NULL,
  `product_id` int(14) DEFAULT NULL,
  `bid_price` int(14) DEFAULT NULL,
  `bid_status` enum('winner','lost','pending') NOT NULL DEFAULT 'pending',
  `status` enum('active','disabled') NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `email_config`
--

CREATE TABLE `email_config` (
  `Id` int(145) NOT NULL,
  `email` varchar(145) DEFAULT NULL,
  `password` varchar(145) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `email_config`
--

INSERT INTO `email_config` (`Id`, `email`, `password`, `created_at`, `updated_at`) VALUES
(1, 'pabids2023@gmail.com', 'nixudxwdfvnsonze', '2023-02-20 11:25:24', '2023-10-08 08:44:44');

-- --------------------------------------------------------

--
-- Table structure for table `favorite`
--

CREATE TABLE `favorite` (
  `id` int(11) NOT NULL,
  `user_id` int(14) DEFAULT NULL,
  `product_id` int(14) DEFAULT NULL,
  `status` enum('active','disabled') NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `google_recaptcha_api`
--

CREATE TABLE `google_recaptcha_api` (
  `Id` int(11) NOT NULL,
  `site_key` varchar(145) DEFAULT NULL,
  `site_secret_key` varchar(145) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `google_recaptcha_api`
--

INSERT INTO `google_recaptcha_api` (`Id`, `site_key`, `site_secret_key`, `created_at`, `updated_at`) VALUES
(1, '6LdiQZQhAAAAABpaNFtJpgzGpmQv2FwhaqNj2azh', '6LdiQZQhAAAAAByS6pnNjOs9xdYXMrrW2OeTFlrm', '2023-02-20 00:57:18', '2023-10-07 01:20:32');

-- --------------------------------------------------------

--
-- Table structure for table `likes`
--

CREATE TABLE `likes` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `status` enum('active','disabled') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

CREATE TABLE `logs` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `activity` varchar(145) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `product_name` varchar(145) DEFAULT NULL,
  `product_price` varchar(145) DEFAULT NULL,
  `product_description` varchar(500) DEFAULT NULL,
  `bidding_start_date` datetime DEFAULT NULL,
  `bidding_end_date` datetime DEFAULT NULL,
  `product_image` varchar(145) DEFAULT NULL,
  `product_number` varchar(145) DEFAULT NULL,
  `product_status` enum('sold','not_sold') NOT NULL DEFAULT 'not_sold',
  `bidding_status` enum('open','closed') NOT NULL DEFAULT 'closed',
  `status` enum('active','disabled') NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `religion`
--

CREATE TABLE `religion` (
  `id` int(11) NOT NULL,
  `religion` varchar(145) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `religion`
--

INSERT INTO `religion` (`id`, `religion`, `created_at`, `updated_at`) VALUES
(1, 'Roman Catholic', '2023-02-19 08:36:44', NULL),
(2, 'Iglesia ni Cristo', '2023-02-19 08:36:44', '2023-02-19 08:38:16'),
(3, 'Cristian', '2023-02-19 08:36:44', '2023-02-19 08:38:29'),
(4, 'Islam', '2023-02-19 08:36:44', '2023-02-19 08:38:37'),
(5, 'Buddhism', '2023-02-19 08:36:44', '2023-02-19 08:38:43'),
(6, 'Protestant', '2023-02-19 08:36:44', '2023-02-19 08:38:50'),
(7, 'Methodist', '2023-02-19 08:36:44', '2023-02-19 08:38:56'),
(8, 'Adventist', '2023-02-19 08:36:44', '2023-02-19 08:39:03'),
(9, 'Independent', '2023-02-19 08:36:44', '2023-02-19 08:39:12'),
(10, 'Evangelical', '2023-02-19 08:36:44', '2023-02-19 08:39:18'),
(11, 'Jehovah\'s-Witnesses', '2023-02-19 08:36:44', '2023-02-19 08:39:27'),
(12, 'JIL', '2023-02-19 08:36:44', '2023-02-19 08:39:33'),
(13, 'Lutheran', '2023-02-19 08:36:44', '2023-02-19 08:39:39'),
(14, 'Orthodox', '2023-02-19 08:36:44', '2023-02-19 08:39:44'),
(15, 'Pentecostal', '2023-02-19 08:36:44', '2023-02-19 08:39:59'),
(16, 'Presbyterianism', '2023-02-19 08:36:44', '2023-02-19 08:40:02'),
(17, 'Latter-Day', '2023-02-19 08:36:44', '2023-02-19 08:40:13'),
(18, 'UCCP', '2023-02-19 08:36:44', '2023-02-19 08:40:18'),
(19, 'KJC', '2023-02-19 08:36:44', '2023-02-19 08:40:24'),
(20, 'Baptist', '2023-02-19 08:36:44', '2023-02-19 08:40:34'),
(21, 'Angelican-Episcopalian', '2023-02-19 08:36:44', '2023-02-19 08:40:50');

-- --------------------------------------------------------

--
-- Table structure for table `seller`
--

CREATE TABLE `seller` (
  `id` int(11) NOT NULL,
  `user_id` int(14) DEFAULT NULL,
  `shop_name` varchar(145) DEFAULT NULL,
  `email` varchar(145) DEFAULT NULL,
  `phone_number` varchar(145) DEFAULT NULL,
  `region` varchar(145) DEFAULT NULL,
  `province` varchar(145) DEFAULT NULL,
  `municipality` varchar(145) DEFAULT NULL,
  `barangay` varchar(145) DEFAULT NULL,
  `street` varchar(145) DEFAULT NULL,
  `postal_code` varchar(145) DEFAULT NULL,
  `valid_id_front` varchar(145) DEFAULT NULL,
  `valid_id_back` varchar(145) DEFAULT NULL,
  `status` enum('not_verify','verify','disabled') NOT NULL DEFAULT 'not_verify',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `system_config`
--

CREATE TABLE `system_config` (
  `Id` int(14) NOT NULL,
  `system_name` varchar(145) DEFAULT NULL,
  `system_phone_number` varchar(145) DEFAULT NULL,
  `system_email` varchar(145) DEFAULT NULL,
  `system_logo` varchar(145) DEFAULT NULL,
  `system_favicon` varchar(145) DEFAULT NULL,
  `system_color` varchar(145) DEFAULT NULL,
  `system_copy_right` varchar(145) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `system_config`
--

INSERT INTO `system_config` (`Id`, `system_name`, `system_phone_number`, `system_email`, `system_logo`, `system_favicon`, `system_color`, `system_copy_right`, `created_at`, `updated_at`) VALUES
(1, 'PABids', '0977662192', 'pabids2023@gmail.com', 'pabids-logo.png', 'pabids-favicon.png', NULL, 'COPYRIGHT © 2023 - PABids. ALL RIGHTS RESERVED.', '2023-02-20 00:16:44', '2023-10-08 08:41:03');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `first_name` varchar(145) DEFAULT NULL,
  `middle_name` varchar(145) DEFAULT NULL,
  `last_name` varchar(145) DEFAULT NULL,
  `sex` varchar(145) DEFAULT NULL COMMENT 'male=1, female=2',
  `date_of_birth` varchar(145) DEFAULT NULL,
  `age` varchar(145) DEFAULT NULL,
  `civil_status` varchar(145) DEFAULT NULL,
  `phone_number` varchar(145) DEFAULT NULL,
  `email` varchar(145) DEFAULT NULL,
  `password` varchar(145) DEFAULT NULL,
  `profile` varchar(1145) NOT NULL DEFAULT 'profile.png',
  `status` enum('Y','N') DEFAULT 'N',
  `tokencode` varchar(145) DEFAULT NULL,
  `account_status` enum('active','disabled') NOT NULL DEFAULT 'active',
  `user_type` varchar(14) DEFAULT NULL COMMENT 'superadmin=0,\r\nadmin=1,\r\nusers=2',
  `seller` enum('Yes','No') NOT NULL DEFAULT 'No',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `middle_name`, `last_name`, `sex`, `date_of_birth`, `age`, `civil_status`, `phone_number`, `email`, `password`, `profile`, `status`, `tokencode`, `account_status`, `user_type`, `seller`, `created_at`, `updated_at`) VALUES
(1, 'ADMIN', 'ADMIN', 'ADMIN', 'MALE', NULL, NULL, 'MARRIED', '9893278279', 'pabids2023@gmail.com', '42f749ade7f9e195bf475f37a44cafcb', 'profile.png', 'Y', '4b1df3ad169dc30bfa742526659acd4e', 'active', '1', 'No', '2023-09-17 23:33:38', '2023-10-08 10:52:55'),
(5, 'JUAN', 'CRUZ', 'SANTOS', NULL, NULL, NULL, NULL, '9776621929', 'sample@gmail.com', '42f749ade7f9e195bf475f37a44cafcb', 'profile.png', 'Y', 'd05c1dc72075bc797399d2686003f0dc', 'active', '2', 'No', '2023-10-08 10:45:51', '2023-10-12 14:08:34'),
(6, 'JUAN', 'CRUZ', 'SANTOS', NULL, NULL, NULL, NULL, '9776621929', 'sample1@gmail.com', '42f749ade7f9e195bf475f37a44cafcb', 'profile.png', 'Y', 'd05c1dc72075bc797399d2686003f0dc', 'active', '2', 'No', '2023-10-08 10:45:51', '2023-10-09 10:02:02'),
(7, 'JUAN', 'CRUZ', 'SANTOS', NULL, NULL, NULL, NULL, '9776621929', 'sample2@gmail.com', '42f749ade7f9e195bf475f37a44cafcb', 'profile.png', 'Y', 'd05c1dc72075bc797399d2686003f0dc', 'active', '2', 'No', '2023-10-08 10:45:51', '2023-10-09 10:02:11'),
(8, 'JUAN', 'CRUZ', 'SANTOS', NULL, NULL, NULL, NULL, '9776621929', 'sample3@gmail.com', '42f749ade7f9e195bf475f37a44cafcb', 'profile.png', 'Y', 'd05c1dc72075bc797399d2686003f0dc', 'active', '2', 'No', '2023-10-08 10:45:51', '2023-10-09 10:02:24'),
(9, 'JUAN', 'CRUZ', 'SANTOS', NULL, NULL, NULL, NULL, '9776621929', 'sample4@gmail.com', '42f749ade7f9e195bf475f37a44cafcb', 'profile.png', 'Y', 'd05c1dc72075bc797399d2686003f0dc', 'active', '2', 'No', '2023-10-08 10:45:51', '2023-10-09 10:02:35');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `address`
--
ALTER TABLE `address`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bidding`
--
ALTER TABLE `bidding`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `email_config`
--
ALTER TABLE `email_config`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `favorite`
--
ALTER TABLE `favorite`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `google_recaptcha_api`
--
ALTER TABLE `google_recaptcha_api`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `religion`
--
ALTER TABLE `religion`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `seller`
--
ALTER TABLE `seller`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `system_config`
--
ALTER TABLE `system_config`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `address`
--
ALTER TABLE `address`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bidding`
--
ALTER TABLE `bidding`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `email_config`
--
ALTER TABLE `email_config`
  MODIFY `Id` int(145) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `favorite`
--
ALTER TABLE `favorite`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `google_recaptcha_api`
--
ALTER TABLE `google_recaptcha_api`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `likes`
--
ALTER TABLE `likes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `logs`
--
ALTER TABLE `logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `religion`
--
ALTER TABLE `religion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `seller`
--
ALTER TABLE `seller`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `system_config`
--
ALTER TABLE `system_config`
  MODIFY `Id` int(14) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bidding`
--
ALTER TABLE `bidding`
  ADD CONSTRAINT `bidding_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `bidding_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`);

--
-- Constraints for table `favorite`
--
ALTER TABLE `favorite`
  ADD CONSTRAINT `favorite_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `favorite_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`);

--
-- Constraints for table `likes`
--
ALTER TABLE `likes`
  ADD CONSTRAINT `likes_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `likes_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`);

--
-- Constraints for table `logs`
--
ALTER TABLE `logs`
  ADD CONSTRAINT `logs_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `product_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `seller`
--
ALTER TABLE `seller`
  ADD CONSTRAINT `seller_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
