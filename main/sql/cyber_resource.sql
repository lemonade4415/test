-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Nov 14, 2024 at 05:12 AM
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
-- Database: `cyber_resource`
--

-- --------------------------------------------------------

--
-- Table structure for table `approved_job_listings`
--

CREATE TABLE `approved_job_listings` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `job_title` varchar(255) NOT NULL,
  `location` varchar(255) NOT NULL,
  `job_description` text NOT NULL,
  `job_type` varchar(50) NOT NULL,
  `salary` varchar(100) NOT NULL,
  `benefits` text NOT NULL,
  `approved_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `approved_job_listings`
--

INSERT INTO `approved_job_listings` (`id`, `username`, `job_title`, `location`, `job_description`, `job_type`, `salary`, `benefits`, `approved_at`) VALUES
(18, 'company1', 'driver', 'jl kbn jruk', 'drive lalamove', 'full-time', '20000000', 'bonus', '2024-11-12 13:13:47'),
(19, 'company1', 'net eng', 'jl uri', 'net eng', 'contract', '3290434', 'bonus', '2024-11-12 13:10:34');

-- --------------------------------------------------------

--
-- Table structure for table `job_listings`
--

CREATE TABLE `job_listings` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `job_title` varchar(255) NOT NULL,
  `location` varchar(255) DEFAULT NULL,
  `job_description` text NOT NULL,
  `job_type` varchar(50) DEFAULT NULL,
  `salary` varchar(100) DEFAULT NULL,
  `benefits` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `job_listings`
--

INSERT INTO `job_listings` (`id`, `username`, `job_title`, `location`, `job_description`, `job_type`, `salary`, `benefits`) VALUES
(7, 'wen1', 'alert(&quot;xss&quot;)', 'alert(&quot;xss&quot;)', 'alert(&quot;xss&quot;)', 'part-time', 'alert(&quot;xss&quot;)', 'alert(&quot;xss&quot;)'),
(8, 'wen1', 'alert(&quot;xss&quot;)', 'alert(&quot;xss&quot;)', 'alert(&quot;xss&quot;)', 'part-time', 'alert(&quot;xss&quot;)', 'alert(&quot;xss&quot;)'),
(9, 'wen1', 'alert(&quot;e&quot;)', 'alert(&quot;e&quot;)', 'alert(&quot;e&quot;)', 'full-time', 'alert(&quot;e&quot;)', 'alert(&quot;e&quot;)'),
(10, 'wen1', '&lt;script&gt;alert(&quot;s&quot;)&lt;/script&gt;', '&lt;script&gt;alert(&quot;s&quot;)&lt;/script&gt;', '&lt;script&gt;alert(&quot;s&quot;)&lt;/script&gt;', 'contract', '&lt;script&gt;alert(&quot;s&quot;)&lt;/script&gt;', '&lt;script&gt;alert(&quot;s&quot;)&lt;/script&gt;'),
(15, 'wen1', 'SELECT * FROM users', 'SELECT * FROM users', 'SELECT * FROM users', 'part-time', 'SELECT * FROM users', 'SELECT * FROM users'),
(16, 'wen1', 'SELECT * FROM users', 'SELECT * FROM users', 'SELECT * FROM users', 'full-time', 'SELECT * FROM users', 'SELECT * FROM users'),
(28, 'company1', 'fewf', 'ewef', 'efwfw', 'full-time', '', 'few'),
(29, 'company1', 'rwer', 'rewr', 'wefwef', 'part-time', '', 'ew'),
(30, 'company1', 'rfef', 'rfef', 'fref', 'full-time', '', 'ref'),
(31, 'company1', 'ref', 'ref', 'rfef', 'full-time', '23443080934', ''),
(32, 'company1', 'fwef', 'efwf', 'wefw', 'full-time', '33', 'fsfd'),
(33, 'company1', 'fwef', 'ewfwe', 'efwef', 'part-time', '222313', '');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(50) NOT NULL,
  `profile_image` varchar(255) DEFAULT NULL,
  `age` int(3) DEFAULT NULL,
  `gender` varchar(10) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `profession` varchar(50) DEFAULT NULL,
  `CompanySpecialization` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `profile_image`, `age`, `gender`, `address`, `profession`, `CompanySpecialization`) VALUES
(3, 'shane2', 'shane@example.com', '$2y$10$vG.srdd0jKecOl3RbBjrH.xFTtFywx.Iph80jRPPTVfQ26RhQy4H6', 'Company', NULL, NULL, NULL, NULL, NULL, NULL),
(5, 'user123', 'user123@example.com', '$2y$10$7V.veZazrfsBOUckbLFlfeIjrGmum.IWP1G0pmsnN2LC5XPxwouxm', 'Company', NULL, NULL, NULL, NULL, NULL, NULL),
(6, 'shane14', 'shane14@gmail.com', '$2y$10$4hMzfi7pch9.ruI6YTICgOu4FQfJ3ShdjOtjpEbJNhWZ4LwmcWkD6', 'Company', NULL, NULL, NULL, NULL, NULL, NULL),
(9, 'test', 'test2@test.com', '$2y$10$uYDQGwa7CWXsxpTSh5j3tuQ2.azmw4A101phJYhO6gISP6Sjqg8TO', 'Company', NULL, NULL, NULL, NULL, NULL, NULL),
(11, 'hello', 'hello@gmail.com', '$2y$10$OZQmtIOy452Oze4gRwcl2.ljc7BmNSioFIOmDia.D8UFGbIglrwE.', 'Customer', NULL, NULL, NULL, NULL, NULL, NULL),
(16, 'wen2', 'wen2@gmail.com', '$2y$10$i8TbxUiFsWCDvk.H6HrE4uLE27BC/lD9bvn6STkRTfHPJ2hIFl57u', 'Customer', NULL, NULL, NULL, NULL, NULL, NULL),
(25, 'wen1', 'wen1@email.com', '$2y$10$9UZIF11KVl0pZ8dq0SLMGOjTn7/7IP3B/OSBqZIlP/wXAdTP8IvAi', 'Company', NULL, NULL, NULL, NULL, NULL, NULL),
(30, 'wen3', 'wen3@email.com', '$2y$10$.RNDQtAFIfBzT66JtYCsmuOrMn9n/OewLX7JiS1Gqn9jzdmbg2uh6', 'Customer', NULL, NULL, NULL, NULL, NULL, NULL),
(31, 'wen4', 'wen4@email.com', '$2y$10$Tic1kGBjbatXBz0J/s72pOl/51IubBjakzvYYrYYyVt7lfv9TYjW6', 'Company', NULL, NULL, NULL, NULL, NULL, NULL),
(37, 'wen7', 'wen7@email.com', '$2y$10$debuI/dwrx1EDbZb/MVTQOSHEuVq9rqZiybyONRwt4LmeNdxvHZqi', 'Company', NULL, NULL, NULL, NULL, NULL, NULL),
(38, 'customer1', 'customer1@email.com', '$2y$10$DgHTRO5bMNstMz32oz0ljOf.yPHuHBS39e7DBCx12h7yzd3iMqlqS', 'Customer', NULL, NULL, NULL, NULL, NULL, NULL),
(39, 'company1', 'company1@email.com', '$2y$10$AkXfw7CDqARgBdkPmUxUF.Vs33jT3.gOk2vElY6eQV8R.GhqydK5W', 'Company', NULL, NULL, NULL, NULL, NULL, NULL),
(45, 'Admin Magang', 'admin@admin.com', '$2y$10$Kwracj6eG8MkIk6NnVB2KeQZR/t6eeCeEOXAefgtPAf07x2RBZbdG', 'admin', NULL, NULL, NULL, NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `approved_job_listings`
--
ALTER TABLE `approved_job_listings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `job_listings`
--
ALTER TABLE `job_listings`
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT for table `approved_job_listings`
--
ALTER TABLE `approved_job_listings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `job_listings`
--
ALTER TABLE `job_listings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
