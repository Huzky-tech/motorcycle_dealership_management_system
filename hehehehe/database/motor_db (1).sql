-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 21, 2025 at 04:35 AM
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
-- Database: `motor_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `account_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('A','U') NOT NULL DEFAULT 'U'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`account_id`, `username`, `password`, `role`) VALUES
(4, 'mj', '$2y$10$e6f4GfKHoecFQdIydGAt8uOpDkGWBW1TbDrZG0WL1XlZJh2wRLVLK', 'U'),
(5, 'ds', '$2y$10$X2Klk/YlbrG3SPCoJAKSn.xi00x944w3kqVygW1MR.5xpaDQ8My0i', 'U'),
(6, 'shesh', '$2y$10$yR8zrJ.x5dd8n/Lirma.huLvLDgLRzCdB0U/cVWewGmr7XzaS1g22', 'U'),
(7, 'damn', '$2y$10$k0EFtOwarsnvDEDbnI408u3g/ISBjPbJPN/YWyBgp0J54Ln4yRUoa', 'U'),
(9, 'ouch', '$2y$10$7CRDxkA5NF/ow9HXGrh3d.0ghe6bi1XgmiqUpKZPt6o06h0EbR2C6', 'U'),
(10, 'owo', '$2y$10$Q1oViQNqJEnSVtJSkZJnDutX.eXqD05ImdSTrqAQaaZ3A6qvtHEhu', 'U'),
(11, 'admin', '$2y$10$Kd.unPexnLC.KYMOEDtIf.1wSDxwQHdAgIVoO1xNV4/AtK7JBHPUC', 'A'),
(12, 'user', '$2y$10$1Gi/mmCrdOaJmNaeN6lOD.o8xg1aFFO2I2aAC2Pi1gcoGrY4oUS5e', 'U'),
(13, 'beboy', '$2y$10$FtlPs2kuM8HVGhdg4G5uPertRestmTXWe.b3HK4lrX7u/k.Jp0utu', 'U');

-- --------------------------------------------------------

--
-- Table structure for table `inquiries`
--

CREATE TABLE `inquiries` (
  `id` int(11) NOT NULL,
  `customer_name` varchar(255) NOT NULL,
  `model` varchar(50) NOT NULL,
  `color` varchar(50) NOT NULL,
  `inquiry_details` text NOT NULL,
  `purchase_date` date NOT NULL,
  `address` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `mobile` varchar(20) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `motorcycle_id` int(11) NOT NULL,
  `status` enum('pending','approved','rejected','cancelled') DEFAULT 'pending',
  `purchase_report_id` int(11) DEFAULT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `inquiries`
--

INSERT INTO `inquiries` (`id`, `customer_name`, `model`, `color`, `inquiry_details`, `purchase_date`, `address`, `email`, `mobile`, `created_at`, `motorcycle_id`, `status`, `purchase_report_id`, `quantity`) VALUES
(10, 'mj g calunsag', 'Ducati Sprint', 'Black', 'assa', '2025-03-16', 'wao lanao del sur ', 'GFF@gmail.com', '56345345435534', '2025-03-16 05:16:34', 6, 'approved', NULL, 1),
(12, 'rex G Henobla', 'Ducati hahah', 'Red', 'lkjhgfdsa', '2025-03-20', 'wao lanao del sur ', 'rex@gmail', '09876543265', '2025-03-20 03:39:26', 7, 'approved', NULL, 1),
(13, 'Rex g henobla', 'Ducati wow', 'Black', 'gfdgffgs', '2025-03-20', 'cdo', 'fahs@gmail.com', '0987654321', '2025-03-20 03:41:32', 7, 'approved', NULL, 1),
(15, 'iuyt oiuy oiuytr', 'Ducati Sprint', 'Black', '09876543', '2025-03-20', 'oiuytr', 'fahs@gmail.com', '098765432', '2025-03-20 04:56:32', 6, 'approved', NULL, 1),
(16, 'mj g calunsag', 'Ducati Sprint', 'Black', 'poiuytr', '2025-03-20', 'iuytre', 'GFF@gmail.com', '09876543', '2025-03-20 05:30:52', 6, 'approved', NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `motorcycles`
--

CREATE TABLE `motorcycles` (
  `id` int(11) NOT NULL,
  `model` varchar(255) DEFAULT NULL,
  `srp` decimal(10,2) NOT NULL DEFAULT 0.00,
  `downpayment` decimal(10,2) NOT NULL DEFAULT 0.00,
  `monthly` decimal(10,2) NOT NULL DEFAULT 0.00,
  `stock` int(11) NOT NULL CHECK (`stock` >= 0),
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `motorcycles`
--

INSERT INTO `motorcycles` (`id`, `model`, `srp`, `downpayment`, `monthly`, `stock`, `image`) VALUES
(6, 'Ducati Sprint', 750000.00, 20000.00, 10000.00, 2, 'lll.jpg'),
(7, 'Ducati hahah', 1000000.00, 10000.00, 1000.00, 2, 'ww.jpg'),
(8, 'Ducati shhessh', 300000.00, 20000.00, 10000.00, 6, 'u.jpg'),
(9, 'Ducati chhaaarrrotttt', 50000.00, 5000.00, 5000.00, 6, 'oo.jpg'),
(10, 'Ducati wow', 500000.00, 20000.00, 10000.00, 4, 'y.jpg'),
(11, 'Ducati hehehe', 1000000.00, 10000.00, 1000.00, 5, 'ww.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `payment_id` int(11) NOT NULL,
  `customer_name` varchar(255) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `payment_date` date NOT NULL,
  `status` enum('Pending','Completed','Failed') NOT NULL,
  `purchase_report_id` int(11) NOT NULL,
  `inquiry_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`payment_id`, `customer_name`, `amount`, `payment_date`, `status`, `purchase_report_id`, `inquiry_id`) VALUES
(12, 'mj g poiuytrew', 10000.00, '2025-03-16', 'Completed', 8, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `purchased_report`
--

CREATE TABLE `purchased_report` (
  `id` int(11) NOT NULL,
  `customer_name` varchar(255) NOT NULL,
  `model` varchar(255) NOT NULL,
  `inquiry_details` text NOT NULL,
  `purchase_date` date NOT NULL,
  `status` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `purchased_report`
--

INSERT INTO `purchased_report` (`id`, `customer_name`, `model`, `inquiry_details`, `purchase_date`, `status`) VALUES
(6, 'mj g calunsag', 'Ducati Sprint', 'assa', '2025-03-16', 'approved'),
(7, 'mj g calunsag', 'Ducati Sprint', 'assa', '2025-03-16', 'approved'),
(8, 'mj g poiuytrew', 'Ducati hahah', 'hehehehe', '2025-03-16', 'approved'),
(9, 'mj g calunsag', 'Ducati Sprint', 'assa', '2025-03-16', 'approved'),
(10, 'Rex g henobla', 'Ducati wow', 'gfdgffgs', '2025-03-20', 'approved'),
(11, 'mj g calunsag', 'Ducati Sprint', 'assa', '2025-03-16', 'approved'),
(12, 'rex G Henobla', 'Ducati hahah', 'lkjhgfdsa', '2025-03-20', 'approved'),
(13, 'mj g poiuytrew', 'Ducati hahah', 'hehehehe', '2025-03-16', 'approved'),
(14, 'Rex g henobla', 'Ducati wow', 'gfdgffgs', '2025-03-20', 'approved'),
(15, 'Rex g henobla', 'Ducati wow', 'gfdgffgs', '2025-03-20', 'approved'),
(16, 'mj g calunsag', 'Ducati Sprint', 'assa', '2025-03-16', 'approved'),
(17, 'mj g poiuytrew', 'Ducati hahah', 'hehehehe', '2025-03-16', 'approved'),
(18, 'mj g poiuytrew', 'Ducati hahah', 'hehehehe', '2025-03-16', 'approved'),
(19, 'Rex g henobla', 'Ducati wow', 'gfdgffgs', '2025-03-20', 'approved'),
(20, 'Rex g henobla', 'Ducati wow', 'gfdgffgs', '2025-03-20', 'approved'),
(21, 'mj g poiuytrew', 'Ducati hahah', 'hehehehe', '2025-03-16', 'approved'),
(22, 'mj g poiuytrew', 'Ducati hahah', 'hehehehe', '2025-03-16', 'approved'),
(23, 'Rex g henobla', 'Ducati wow', 'gfdgffgs', '2025-03-20', 'approved'),
(24, 'iuyt oiuy oiuytr', 'Ducati Sprint', '09876543', '2025-03-20', 'approved'),
(25, 'mj g calunsag', 'Ducati Sprint', 'poiuytr', '2025-03-20', 'approved');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `account_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `email`, `account_id`) VALUES
(2, 'mj', 'GFF@gmail.com', 4),
(5, 'damn', 'fahs@gmail.com', 7),
(6, 'ouch', 'ouch@gmail', 9),
(7, 'owo', 'fahs@gmail.com', 10),
(8, 'user', 'user@gmail.com', 12),
(9, 'beboy', 'GFF@gmail.com', 13);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`account_id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `inquiries`
--
ALTER TABLE `inquiries`
  ADD PRIMARY KEY (`id`),
  ADD KEY `motorcycle_id` (`motorcycle_id`),
  ADD KEY `fk_inquiries_purchased_report` (`purchase_report_id`);

--
-- Indexes for table `motorcycles`
--
ALTER TABLE `motorcycles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`payment_id`),
  ADD KEY `fk_payments_purchased_report` (`purchase_report_id`),
  ADD KEY `fk_payments_inquiries` (`inquiry_id`);

--
-- Indexes for table `purchased_report`
--
ALTER TABLE `purchased_report`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `account_id` (`account_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `account_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `inquiries`
--
ALTER TABLE `inquiries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `motorcycles`
--
ALTER TABLE `motorcycles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `purchased_report`
--
ALTER TABLE `purchased_report`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `inquiries`
--
ALTER TABLE `inquiries`
  ADD CONSTRAINT `fk_inquiries_purchased_report` FOREIGN KEY (`purchase_report_id`) REFERENCES `purchased_report` (`id`),
  ADD CONSTRAINT `inquiries_ibfk_1` FOREIGN KEY (`motorcycle_id`) REFERENCES `motorcycles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `fk_payments_inquiries` FOREIGN KEY (`inquiry_id`) REFERENCES `inquiries` (`id`),
  ADD CONSTRAINT `fk_payments_purchased_report` FOREIGN KEY (`purchase_report_id`) REFERENCES `purchased_report` (`id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`account_id`) REFERENCES `accounts` (`account_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
