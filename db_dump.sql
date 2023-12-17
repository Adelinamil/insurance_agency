-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 17, 2023 at 10:24 PM
-- Server version: 10.11.4-MariaDB-1:10.11.4+maria~ubu2004
-- PHP Version: 8.1.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `miluhina_insurance_agency`
--
CREATE DATABASE IF NOT EXISTS `miluhina_insurance_agency` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `miluhina_insurance_agency`;

-- --------------------------------------------------------

--
-- Table structure for table `auth_tokens`
--

CREATE TABLE `auth_tokens` (
  `token` varchar(256) NOT NULL,
  `user_id` int(11) NOT NULL,
  `expiry_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `auth_tokens`
--

INSERT INTO `auth_tokens` (`token`, `user_id`, `expiry_date`) VALUES
('fyveMTYRxXy62uyhYXlHpFoGTRs9484BZOne1EZkiqHLXVpH3fT5-dSJbWEYXIGRcXBnuYQiavSdukN_SKwN98cK9_RyIY0n17etg-TC42RlJu5ylzy4twv3cZ5g604i', 4, '2024-01-16'),
('jnv8jOm_nYUWxQL_FueRrhDeWl1wTsKbhE7Qsy5vfi4l49IyyxHtT7PmVnUoWtZB1EJozqISLMGpmqxKChIHss6Rf9l1dV64lZvSg76bx6tACWFtpCXpnOUuEUN3zNP8', 4, '2024-01-16');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `customer_id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `birth_date` date NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `email` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`customer_id`, `first_name`, `last_name`, `birth_date`, `address`, `phone`, `email`) VALUES
(1, 'Иван', 'Иванов', '1990-01-15', 'ул. Главная, д. 123', '555-1234', 'ivan.ivanov@email.com'),
(2, 'Мария', 'Петрова', '1985-05-20', 'ул. Дубовая, д. 456', '555-5678', 'maria.petrova@email.com');

-- --------------------------------------------------------

--
-- Table structure for table `insurance_events`
--

CREATE TABLE `insurance_events` (
  `event_id` int(11) NOT NULL,
  `event_date` date NOT NULL,
  `description` text DEFAULT NULL,
  `policy_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `insurance_events`
--

INSERT INTO `insurance_events` (`event_id`, `event_date`, `description`, `policy_id`) VALUES
(1, '2023-11-19', 'Автомобильная авария', 1),
(2, '2023-12-12', 'Проникновение в дом', 2),
(3, '2024-01-16', 'Оформление полиса', 3);

-- --------------------------------------------------------

--
-- Table structure for table `insurance_products`
--

CREATE TABLE `insurance_products` (
  `product_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `type` varchar(50) NOT NULL,
  `coverage` decimal(10,2) NOT NULL,
  `default_sum_insured` decimal(10,2) NOT NULL,
  `default_premium` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `insurance_products`
--

INSERT INTO `insurance_products` (`product_id`, `name`, `description`, `type`, `coverage`, `default_sum_insured`, `default_premium`) VALUES
(1, 'Страхование автомобиля', 'Покрытие для вашего транспортного средства', 'Авто', 10000.00, 5000.00, 500.00),
(2, 'Страхование недвижимости', 'Покрытие для вашего жилья', 'Имущество', 200000.00, 150000.00, 1000.00);

-- --------------------------------------------------------

--
-- Table structure for table `policies`
--

CREATE TABLE `policies` (
  `policy_id` int(11) NOT NULL,
  `policy_number` varchar(20) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `insurance_type` varchar(50) NOT NULL,
  `coverage` decimal(10,2) NOT NULL,
  `premium` decimal(10,2) NOT NULL,
  `customer_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `policies`
--

INSERT INTO `policies` (`policy_id`, `policy_number`, `start_date`, `end_date`, `insurance_type`, `coverage`, `premium`, `customer_id`) VALUES
(1, 'П001', '2023-01-01', '2023-12-31', 'Авто', 10000.00, 500.00, 1),
(2, 'П002', '2023-02-15', '2023-08-15', 'Имущество', 200000.00, 1000.00, 2),
(3, 'П003', '2023-01-01', '2024-01-01', 'Имущество', 15000.00, 1000.00, 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `role` varchar(20) NOT NULL CHECK (`role` in ('admin','agent','support'))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`, `first_name`, `last_name`, `email`, `role`) VALUES
(4, 'admin', '$2y$13$1GUfygz5.urh4M5JnZ5UCe6M9I34cx.namrj3cewyzTQVbf4nzEcq', 'Админ', 'Админович', 'admin@admin.com', 'admin'),
(5, 'agent', '$2y$13$DSBbnznTJ6pTM.BNI10.ROa2lYlkc/0rtMBYc7GQshM1wvOFuo8dm', 'Агент', 'Агентович', 'agent@agent.com', 'agent');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `auth_tokens`
--
ALTER TABLE `auth_tokens`
  ADD PRIMARY KEY (`token`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`customer_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `insurance_events`
--
ALTER TABLE `insurance_events`
  ADD PRIMARY KEY (`event_id`),
  ADD KEY `policy_id` (`policy_id`);

--
-- Indexes for table `insurance_products`
--
ALTER TABLE `insurance_products`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `policies`
--
ALTER TABLE `policies`
  ADD PRIMARY KEY (`policy_id`),
  ADD UNIQUE KEY `policy_number` (`policy_number`),
  ADD KEY `customer_id` (`customer_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `insurance_events`
--
ALTER TABLE `insurance_events`
  MODIFY `event_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `insurance_products`
--
ALTER TABLE `insurance_products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `policies`
--
ALTER TABLE `policies`
  MODIFY `policy_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `auth_tokens`
--
ALTER TABLE `auth_tokens`
  ADD CONSTRAINT `auth_tokens_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `insurance_events`
--
ALTER TABLE `insurance_events`
  ADD CONSTRAINT `insurance_events_ibfk_1` FOREIGN KEY (`policy_id`) REFERENCES `policies` (`policy_id`);

--
-- Constraints for table `policies`
--
ALTER TABLE `policies`
  ADD CONSTRAINT `policies_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`customer_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
