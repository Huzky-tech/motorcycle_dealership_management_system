-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 17, 2025 at 12:48 AM
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
  `motorcycle_id` int(11) DEFAULT NULL,
  `status` enum('pending','approved','rejected','cancelled') DEFAULT 'pending',
  `purchase_report_id` int(11) DEFAULT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `inquiries`
--

INSERT INTO `inquiries` (`id`, `customer_name`, `model`, `color`, `inquiry_details`, `purchase_date`, `address`, `email`, `mobile`, `created_at`, `motorcycle_id`, `status`, `purchase_report_id`, `quantity`) VALUES
(10, 'mj g calunsag', 'Ducati Sprint', 'Black', 'assa', '2025-03-16', 'wao lanao del sur ', 'GFF@gmail.com', '56345345435534', '2025-03-16 05:16:34', NULL, 'approved', NULL, 1),
(11, 'mj g poiuytrew', 'Ducati hahah', 'White', 'hehehehe', '2025-03-16', ';lkjhgfdsa', 'GFF@gmail.com', '-098765432', '2025-03-16 07:49:53', NULL, 'cancelled', NULL, 2);

-- --------------------------------------------------------

--
-- Table structure for table `motorcycles`
--

CREATE TABLE `motorcycles` (
  `id` int(11) NOT NULL,
  `model` varchar(255) NOT NULL,
  `srp` decimal(10,2) NOT NULL,
  `downpayment` decimal(10,2) NOT NULL,
  `monthly` decimal(10,2) NOT NULL,
  `stock` int(11) NOT NULL CHECK (`stock` >= 0),
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `motorcycles`
--

INSERT INTO `motorcycles` (`id`, `model`, `srp`, `downpayment`, `monthly`, `stock`, `image`) VALUES
(6, 'Ducati Sprint', 750000.00, 20000.00, 10000.00, 4, 'lll.jpg'),
(7, 'Ducati hahah', 1000000.00, 10000.00, 1000.00, 3, 'ww.jpg');

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

--
-- Indexes for dumped tables
--

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
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `inquiries`
--
ALTER TABLE `inquiries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `motorcycles`
--
ALTER TABLE `motorcycles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

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
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
