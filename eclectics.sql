-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 16, 2024 at 07:59 PM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.4.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `eclectics`
--

-- --------------------------------------------------------

--
-- Table structure for table `loan_application`
--

CREATE TABLE `loan_application` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `loan_type_id` int(11) DEFAULT NULL,
  `amount` double(8,2) DEFAULT NULL,
  `repayment_period` int(10) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `cdate` timestamp NOT NULL DEFAULT current_timestamp(),
  `udate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `loan_application`
--

INSERT INTO `loan_application` (`id`, `user_id`, `loan_type_id`, `amount`, `repayment_period`, `status`, `cdate`, `udate`) VALUES
(1, 1, 1, 10000.00, 12, 1, '2024-04-16 09:23:38', '2024-04-16 09:35:34'),
(2, NULL, 2, NULL, NULL, 1, '2024-04-16 10:03:58', '2024-04-16 10:03:58'),
(3, NULL, 1, NULL, NULL, 1, '2024-04-16 10:04:53', '2024-04-16 10:04:53'),
(4, 1, 1, NULL, NULL, 1, '2024-04-16 10:05:54', '2024-04-16 10:05:54'),
(5, 1, 2, 100000.00, NULL, 1, '2024-04-16 10:11:07', '2024-04-16 10:11:07'),
(6, 1, 1, 10000.00, NULL, 1, '2024-04-16 14:02:43', '2024-04-16 14:02:43'),
(7, 6, 1, 100000.00, NULL, 1, '2024-04-16 15:40:45', '2024-04-16 15:40:45');

-- --------------------------------------------------------

--
-- Table structure for table `loan_payment`
--

CREATE TABLE `loan_payment` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `amount_paid` double(8,2) DEFAULT NULL,
  `status` tinyint(3) NOT NULL DEFAULT 1,
  `cdate` timestamp NOT NULL DEFAULT current_timestamp(),
  `udate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `loan_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `loan_payment`
--

INSERT INTO `loan_payment` (`id`, `user_id`, `amount_paid`, `status`, `cdate`, `udate`, `loan_id`) VALUES
(1, 1, 100.00, 1, '2024-04-16 11:07:10', '2024-04-16 11:07:10', NULL),
(2, 1, 100.00, 1, '2024-04-16 11:07:26', '2024-04-16 11:08:10', 5);

-- --------------------------------------------------------

--
-- Table structure for table `loan_types`
--

CREATE TABLE `loan_types` (
  `id` int(11) NOT NULL,
  `name` varchar(200) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `interest_rate` double(8,2) DEFAULT NULL,
  `status` tinyint(3) NOT NULL DEFAULT 1,
  `cdate` timestamp NOT NULL DEFAULT current_timestamp(),
  `udate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `loan_types`
--

INSERT INTO `loan_types` (`id`, `name`, `description`, `interest_rate`, `status`, `cdate`, `udate`) VALUES
(1, 'short-term loan', 'This is a short term loan', 10.00, 1, '2024-04-16 09:30:57', '2024-04-16 10:12:34'),
(2, 'long-term loan', 'This is a long term loan', 10.00, 1, '2024-04-16 09:30:57', '2024-04-16 10:12:42');

-- --------------------------------------------------------

--
-- Table structure for table `log`
--

CREATE TABLE `log` (
  `id` int(11) NOT NULL,
  `admin_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `external_id` int(11) NOT NULL,
  `app` varchar(50) NOT NULL,
  `controller` varchar(50) NOT NULL,
  `action` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `ip` varchar(50) NOT NULL,
  `cdate` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `log`
--

INSERT INTO `log` (`id`, `admin_id`, `user_id`, `external_id`, `app`, `controller`, `action`, `description`, `ip`, `cdate`) VALUES
(1, 0, 0, 0, 'v1', 'register', 'user', 'Validation Errors encountered during registration : {\"email\":\"Please provide Your Email\",\"role_id\":\"Please select a user type\"}', '::1', '2024-04-16 13:37:27'),
(2, 0, 0, 0, 'v1', 'register', 'user', 'Validation Errors encountered during registration : {\"email\":\"Please provide Your Email\"}', '::1', '2024-04-16 13:38:57'),
(3, 0, 0, 0, 'v1', 'register', 'user', 'Validation Errors encountered during registration : {\"full_name\":\"Please provide full name name.\",\"email\":\"Please provide Your Email\",\"role_id\":\"Please select a user type\",\"password\":\"Please Enter Your Password\"}', '::1', '2024-04-16 13:40:42'),
(4, 0, 0, 0, 'v1', 'register', 'user', 'Registration was successfull ID : 2', '::1', '2024-04-16 13:42:49'),
(5, 0, 0, 0, 'v1', 'register', 'user', 'Validation Errors encountered during registration : {\"email\":\"This email address has already been taken. Please enter another email.\"}', '::1', '2024-04-16 13:43:19'),
(6, 0, 0, 0, 'v1', 'register', 'user', 'Registration was successfull ID : 3', '::1', '2024-04-16 13:43:29'),
(7, 0, 0, 0, 'v1', 'register', 'user', 'Validation Errors encountered during registration : {\"email\":\"This email address has already been taken. Please enter another email.\"}', '::1', '2024-04-16 13:44:15'),
(8, 0, 0, 0, 'v1', 'register', 'user', 'Registration was successfull ID : 4', '::1', '2024-04-16 13:44:26'),
(9, 0, 0, 0, 'v1', 'register', 'user', 'Validation Errors encountered during registration : {\"email\":\"This email address has already been taken. Please enter another email.\"}', '::1', '2024-04-16 13:45:16'),
(10, 0, 0, 0, 'v1', 'register', 'user', 'Registration was successfull ID : 5', '::1', '2024-04-16 13:45:27'),
(11, 0, 0, 0, 'v1', 'register', 'user', 'Validation Errors encountered during registration : {\"email\":\"This email address has already been taken. Please enter another email.\"}', '::1', '2024-04-16 14:37:51'),
(12, 0, 0, 0, 'v1', 'login', 'user', 'Validation Errors encountered during login : []', '::1', '2024-04-16 14:42:56'),
(13, 0, 0, 0, 'v1', 'login', 'user', 'Validation Errors encountered during login : {\"uuid\":\"Please provide a device id.\"}', '::1', '2024-04-16 14:44:09'),
(14, 0, 1, 0, 'v1', 'login', 'user', 'Login was successfull ID : 1', '::1', '2024-04-16 14:47:55'),
(15, 0, 1, 0, 'v1', 'login', 'user', 'Login was successfull ID : 1', '::1', '2024-04-16 14:49:07'),
(16, 0, 1, 0, 'v1', 'login', 'user', 'Login was successfull ID : 1', '::1', '2024-04-16 14:49:59'),
(17, 0, 1, 0, 'v1', 'login', 'user', 'Login was successfull ID : 1', '::1', '2024-04-16 14:53:49'),
(18, 0, 0, 0, 'v1', 'register', 'user', 'Validation Errors encountered during registration : {\"email\":\"This email address has already been taken. Please enter another email.\"}', '::1', '2024-04-16 15:42:48');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `description` varchar(200) DEFAULT NULL,
  `status` tinyint(1) NOT NULL,
  `cdate` timestamp NOT NULL DEFAULT current_timestamp(),
  `udate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `description`, `status`, `cdate`, `udate`) VALUES
(1, 'admin', 'This is admin', 1, '2024-04-16 12:07:05', '2024-04-16 12:07:15'),
(2, 'customer', 'this is customer', 1, '2024-04-16 12:07:05', '2024-04-16 12:07:19');

-- --------------------------------------------------------

--
-- Table structure for table `tokens`
--

CREATE TABLE `tokens` (
  `id` int(11) UNSIGNED NOT NULL,
  `uid` int(11) UNSIGNED NOT NULL,
  `token` varchar(128) NOT NULL,
  `uuid` varchar(64) NOT NULL,
  `firebase_id` varchar(256) NOT NULL,
  `userAgent` varchar(64) NOT NULL,
  `osVersion` varchar(16) NOT NULL,
  `ip` varchar(45) NOT NULL,
  `country` varchar(2) NOT NULL,
  `expire` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `isAdmin` int(11) NOT NULL DEFAULT 0,
  `status` tinyint(3) NOT NULL DEFAULT 0,
  `lastLogin` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `cdate` timestamp NOT NULL DEFAULT current_timestamp(),
  `udate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tokens`
--

INSERT INTO `tokens` (`id`, `uid`, `token`, `uuid`, `firebase_id`, `userAgent`, `osVersion`, `ip`, `country`, `expire`, `isAdmin`, `status`, `lastLogin`, `cdate`, `udate`) VALUES
(1, 1, '9ef70b0fbb65d0b06d278bc8fd32b670990551947dc246bf5bb4107f52026aadd23a4948107c53cfc6a65115f709215bc44f085c87a91c2917036cd4ec61aa3a', '', '', '', '1.0', '::1', '', '2023-09-22 13:30:38', 0, 1, '2022-09-22 13:30:38', '2022-09-22 13:30:38', '2022-09-22 13:30:38'),
(2, 1, '535e5c1da77f2eb6bccd6b9ad4cfa43e4b5f1984bf51a21ccb1e6ba1c678ceb00a5c2327f2f54513ebd6a8a55e5e14428ef25725c69cc4dadce3cc618640a854', '', '', '', '1.0', '::1', '', '2023-09-22 16:48:39', 0, 1, '2022-09-22 16:48:39', '2022-09-22 16:48:39', '2022-09-22 16:48:39'),
(3, 2, '26d5cc639142609f76545a60fef98fa19c44847367030f1c365a56af537550d0f0fc2176bd942cfa5a414256abed55ec2b2b09027d7da0cff7b4fadf5da74582', '', '', '', '1.0', '::1', '', '2022-09-22 16:50:36', 0, 0, '2022-09-22 16:50:10', '2022-09-22 16:50:10', '2022-09-22 16:50:36'),
(4, 2, '0ffb0433a1c7e5b9ef403340489020ffadff54b573d7febab624d134ff40178472acaa30cc336250dc37b6ca9fc3a0ee2927fad078be0407c36b8b93d14bfca9', '', '', '', '1.0', '::1', '', '2025-04-16 13:42:49', 0, 1, '2024-04-16 13:42:49', '2024-04-16 13:42:49', '2024-04-16 13:42:49'),
(5, 3, 'cf9c5b965c28dc39a4ed42018fb06f82790bd09a181751c39b6acfb421cfeeeccadda35d7585cf38adc4ad0f31379e82b5e1f632a377f9017aea3362ebd26b0b', '', '', '', '1.0', '::1', '', '2025-04-16 13:43:29', 0, 1, '2024-04-16 13:43:29', '2024-04-16 13:43:29', '2024-04-16 13:43:29'),
(6, 4, 'ccfd6a5f8e6574bf8d67b0c843aaf4b8e366e70d5427301917898929166a798d7e62d329c18c8e10edcf48b336c68e654b7d4d796da0aca7d9567c0bd4884f1a', '', '', '', '1.0', '::1', '', '2025-04-16 13:44:26', 0, 1, '2024-04-16 13:44:26', '2024-04-16 13:44:26', '2024-04-16 13:44:26'),
(7, 5, 'd23aa75e8fdefabfdb3902ffbc90d837c96717113413fa13e1afb9fcfd0d4adf33af77f1ab10f78139c71d170e3eda349eb5f79d32621ac453ef48edf46b3270', '', '', '', '1.0', '::1', '', '2025-04-16 13:45:27', 0, 1, '2024-04-16 13:45:27', '2024-04-16 13:45:27', '2024-04-16 13:45:27');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `full_name` varchar(200) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `id_no` int(11) DEFAULT NULL,
  `password_hash` varchar(255) DEFAULT NULL,
  `access_token` text DEFAULT NULL,
  `auth_key` varchar(255) DEFAULT NULL,
  `role_id` int(11) DEFAULT NULL,
  `login` tinyint(3) NOT NULL DEFAULT 1,
  `status` bigint(5) NOT NULL DEFAULT 1,
  `cdate` timestamp NOT NULL DEFAULT current_timestamp(),
  `udate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `full_name`, `email`, `id_no`, `password_hash`, `access_token`, `auth_key`, `role_id`, `login`, `status`, `cdate`, `udate`) VALUES
(1, 'Victor Odhiambo', 'victorodhiambo706@gmail.com', 34679046, '$2y$13$1AKQXCQhLkk9sCLZampVRusIIbPjre9Vld0w90U/a6PpXxmaD0AVm', 'd23aa75e8fdefabfdb3902ffbc90d837c96717113413fa13e1afb9fcfd0d4adf33af77f1ab10f78139c71d170e3eda349eb5f79d32621ac453ef48edf46b3270', NULL, 1, 1, 1, '2024-04-16 08:47:08', '2024-04-16 14:53:45'),
(2, 'victor odhiambo', 'victor@test.com', NULL, '$2y$13$HwoaWlZGoUve96VGjepnY.RR2uL4YTWB6ETR3cqlkx9MCk./kPv26', '0ffb0433a1c7e5b9ef403340489020ffadff54b573d7febab624d134ff40178472acaa30cc336250dc37b6ca9fc3a0ee2927fad078be0407c36b8b93d14bfca9', 'EKRNkHcic7L0rAQvJXEAVL6E9jC4vFg7', 1, 1, 1, '2024-04-16 13:42:49', '2024-04-16 13:42:49'),
(3, 'victor odhiambo', 'test@test.com', NULL, '$2y$13$jw4C3xWGHLSZceKUFIx.x.rGM8weT7hl5vRbrJnE/eZzmYYf2ge22', 'cf9c5b965c28dc39a4ed42018fb06f82790bd09a181751c39b6acfb421cfeeeccadda35d7585cf38adc4ad0f31379e82b5e1f632a377f9017aea3362ebd26b0b', 'GSg7jfeCjMQ-y0HPN8Gntr4FZ6-Z5JyN', 1, 1, 1, '2024-04-16 13:43:28', '2024-04-16 13:43:28'),
(4, 'victor odhiambo', 'test1@test.com', NULL, '$2y$13$1l.p6kvr9MXcxZocjZZBheQkjJUvi2h3rJWvCym61fR4QPPPhd1QW', 'ccfd6a5f8e6574bf8d67b0c843aaf4b8e366e70d5427301917898929166a798d7e62d329c18c8e10edcf48b336c68e654b7d4d796da0aca7d9567c0bd4884f1a', 'xBavxVuV60kYI-P03mQh1fiI3WltmY5y', 1, 1, 1, '2024-04-16 13:44:26', '2024-04-16 13:44:26'),
(5, 'victor odhiambo', 'test2@test.com', NULL, '$2y$13$NXqxMJTgnA5Wvrjv/idLa.fxZE49rFF6o7opy0RXHTBBlPYtxvslq', 'd23aa75e8fdefabfdb3902ffbc90d837c96717113413fa13e1afb9fcfd0d4adf33af77f1ab10f78139c71d170e3eda349eb5f79d32621ac453ef48edf46b3270', 'rb2L_ZEXO0ZoB5UMV0DgS0Jsfiv5lbIw', 1, 1, 1, '2024-04-16 13:45:27', '2024-04-16 13:45:27'),
(6, 'Victor Odhiambo', 'victorodhiambo70@gmail.com', 34679047, '$2y$13$RfgyWjSsbMR1OWUOakrWfePVuUxtYWwIaDYWaljFte.Cc.PAGIBNm', NULL, NULL, NULL, 1, 1, '2024-04-16 15:39:14', '2024-04-16 15:39:14'),
(7, 'victor odhiambo', 'test3@test.com', NULL, '$2y$13$dE8Jur00HPS58f3MSerUYu4TOT7QPBixctM/huwybPTzBIKnmV2Ie', '936f1e01828f6846c70ed3617da89142320ff7aace85bc4ef4f732087952ffcbbb988d9f26f08d987cc5645234aff2efcf6c3fcd2af1204f8e52d29f7e9e6237', 'FyNgbrZvRa6Sp5cIOwthRD9ohmOmlTvb', 1, 1, 1, '2024-04-16 15:42:58', '2024-04-16 15:42:58');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `loan_application`
--
ALTER TABLE `loan_application`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `loan_payment`
--
ALTER TABLE `loan_payment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `loan_types`
--
ALTER TABLE `loan_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `log`
--
ALTER TABLE `log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tokens`
--
ALTER TABLE `tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `uid` (`uid`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `loan_application`
--
ALTER TABLE `loan_application`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `loan_payment`
--
ALTER TABLE `loan_payment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `loan_types`
--
ALTER TABLE `loan_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `log`
--
ALTER TABLE `log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tokens`
--
ALTER TABLE `tokens`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
