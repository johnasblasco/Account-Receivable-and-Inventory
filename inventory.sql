-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Dec 12, 2024 at 06:41 PM
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
-- Database: `inventory`
--

-- --------------------------------------------------------

--
-- Table structure for table `brands`
--

CREATE TABLE `brands` (
  `bid` int(2) NOT NULL,
  `brandname` varchar(50) NOT NULL,
  `status` tinyint(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `brands`
--

INSERT INTO `brands` (`bid`, `brandname`, `status`) VALUES
(1, 'HP', 1),
(2, 'asus', 1),
(4, 'acer', 1),
(5, 'dell', 1),
(12, 'Apple', 1),
(15, 'Nike', 1);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `cid` int(2) NOT NULL,
  `catname` varchar(50) NOT NULL,
  `parent_cat` tinyint(2) NOT NULL,
  `status` tinyint(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`cid`, `catname`, `parent_cat`, `status`) VALUES
(3, 'Electronics', 0, 1),
(15, 'Hardware', 0, 1),
(17, 'Gadgets', 0, 1),
(18, 'Mobile', 18, 1),
(19, 'Laptop', 18, 1);

-- --------------------------------------------------------

--
-- Table structure for table `financial_reports`
--

CREATE TABLE `financial_reports` (
  `id` int(11) NOT NULL,
  `report_date` date NOT NULL,
  `total_receivables` decimal(10,2) NOT NULL,
  `total_payments` decimal(10,2) NOT NULL,
  `net_outstanding` decimal(10,2) NOT NULL,
  `period` enum('Monthly','Quarterly','Annually') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `financial_reports`
--

INSERT INTO `financial_reports` (`id`, `report_date`, `total_receivables`, `total_payments`, `net_outstanding`, `period`, `created_at`) VALUES
(1, '2024-11-01', 10000.00, 5000.00, 5000.00, 'Monthly', '2024-11-30 08:50:33'),
(2, '2024-10-01', 12000.00, 4500.00, 7500.00, 'Monthly', '2024-11-30 08:50:33'),
(3, '2024-09-01', 15000.00, 7000.00, 8000.00, 'Monthly', '2024-11-30 08:50:33'),
(4, '2024-08-01', 13000.00, 6000.00, 7000.00, 'Monthly', '2024-11-30 08:50:33'),
(5, '2024-07-01', 11000.00, 4500.00, 6500.00, 'Monthly', '2024-11-30 08:50:33');

-- --------------------------------------------------------

--
-- Table structure for table `invoice`
--

CREATE TABLE `invoice` (
  `invoice_no` int(11) NOT NULL,
  `customer_name` varchar(100) NOT NULL,
  `order_date` date NOT NULL,
  `sub_total` double NOT NULL,
  `gst` double NOT NULL,
  `discount` double NOT NULL,
  `net_total` double NOT NULL,
  `paid` double NOT NULL,
  `due` double NOT NULL,
  `payment_type` tinytext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `invoice`
--

INSERT INTO `invoice` (`invoice_no`, `customer_name`, `order_date`, `sub_total`, `gst`, `discount`, `net_total`, `paid`, `due`, `payment_type`) VALUES
(18, 'Kenneth', '2020-11-09', 128, 23.04, 0, 151.04, 151.04, 0, 'Cash'),
(19, 'Kasha', '2020-11-09', 28, 5.04, 0, 33.04, 135.04, 0, 'Card'),
(20, 'James Reid', '2020-12-09', 323, 58.14, 0, 381.14, 382.13, 23, 'Cash'),
(21, 'Katheryn', '0000-00-00', 3778.7200000000003, 680.1696000000001, 0, 4458.8896, 4458.88, 0.023, 'Card'),
(10, 'Jhomar Barra ', '2020-11-09', 600.86, 108.1548, 0, 709.0148, 709.0148, 0, 'Card');

-- --------------------------------------------------------

--
-- Table structure for table `invoices`
--

CREATE TABLE `invoices` (
  `id` int(11) NOT NULL,
  `member_id` int(11) NOT NULL,
  `invoice_number` varchar(255) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `status` enum('paid','unpaid') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `invoices`
--

INSERT INTO `invoices` (`id`, `member_id`, `invoice_number`, `amount`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 'INV001', 500.00, 'unpaid', '2024-01-15 02:00:00', '2024-11-30 08:38:23'),
(2, 1, 'INV002', 300.00, 'paid', '2024-02-20 04:00:00', '2024-11-30 08:38:23'),
(3, 2, 'INV003', 250.00, 'unpaid', '2024-03-05 01:30:00', '2024-11-30 08:38:23'),
(4, 2, 'INV004', 700.00, 'paid', '2024-04-01 06:00:00', '2024-11-30 08:38:23'),
(5, 3, 'INV005', 150.00, 'unpaid', '2024-05-10 03:45:00', '2024-11-30 08:38:23');

-- --------------------------------------------------------

--
-- Table structure for table `invoice_details`
--

CREATE TABLE `invoice_details` (
  `id` int(11) NOT NULL,
  `invoice_no` int(11) NOT NULL,
  `product_name` varchar(100) NOT NULL,
  `price` double NOT NULL,
  `qty` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `invoice_details`
--

INSERT INTO `invoice_details` (`id`, `invoice_no`, `product_name`, `price`, `qty`) VALUES
(7, 17, 'Asus E203MAH Celeron Dual Core 11.6\" HD Laptop', 28, 1),
(8, 17, 'Asus E203MAH Celeron Dual Core 11.6\" HD Laptop', 28, 1),
(9, 18, 'Asus E203MAH Celeron Dual Core 11.6\" HD Laptop', 28, 1),
(10, 18, 'keyboard', 100, 1),
(11, 19, 'Asus E203MAH Celeron Dual Core 11.6\" HD Laptop', 28, 1),
(12, 20, 'Asus E203MAH Celeron Dual Core 11.6\" HD Laptop', 28, 4),
(13, 20, 'keyboard', 100, 1),
(14, 20, 'Nikon', 111, 1),
(15, 21, 'demo product 1', 500, 5),
(16, 21, 'Asus E203MAH Celeron Dual Core 11.6\" HD Laptop', 28, 2),
(17, 22, 'test 11', 50005, 2);

-- --------------------------------------------------------

--
-- Table structure for table `members`
--

CREATE TABLE `members` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `members`
--

INSERT INTO `members` (`id`, `name`, `email`, `phone`, `address`, `created_at`) VALUES
(1, 'James Reid\r\n', 'johndoe@example.com', NULL, NULL, '2024-11-30 08:38:22'),
(2, 'Kenneth', 'janesmith@example.com', NULL, NULL, '2024-11-30 08:38:22'),
(3, 'Jhomar Barra', 'alicejohnson@example.com', NULL, NULL, '2024-11-30 08:38:22');

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` int(11) NOT NULL,
  `invoice_id` int(11) NOT NULL,
  `payment_date` date NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `payment_method` varchar(50) DEFAULT NULL,
  `note` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payment_methods`
--

CREATE TABLE `payment_methods` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `pid` int(2) NOT NULL,
  `cid` int(2) NOT NULL,
  `bid` int(2) NOT NULL,
  `productname` varchar(150) NOT NULL,
  `price` double(10,2) NOT NULL,
  `quantity` int(2) NOT NULL,
  `added_date` date NOT NULL,
  `status` tinyint(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`pid`, `cid`, `bid`, `productname`, `price`, `quantity`, `added_date`, `status`) VALUES
(3, 19, 2, 'Asus VivoBook N580', 500.86, 100, '2020-09-10', 1),
(4, 20, 2, 'Speker', 111.00, 98, '2020-09-10', 1),
(5, 19, 5, 'Black Laptop', 500.86, 100, '2020-09-10', 1),
(6, 18, 5, 'Telephone', 110.00, 100, '2020-09-10', 1),
(7, 19, 12, 'Nikon', 111.00, 0, '2020-09-10', 1),
(8, 20, 4, 'keyboard', 100.00, 39, '2020-09-11', 1),
(9, 19, 2, 'Asus X441MA Celeron Dual Core 14.0\" HD Laptop', 26.00, 48, '2020-09-11', 1),
(10, 19, 2, 'Asus E203MAH Celeron Dual Core 11.6\" HD Laptop', 28.00, 36, '2020-09-11', 1),
(11, 19, 12, 'demo product 20', 500.00, 5, '2024-12-01', 1);

-- --------------------------------------------------------

--
-- Table structure for table `receivables`
--

CREATE TABLE `receivables` (
  `id` int(11) NOT NULL,
  `member_id` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `due_date` date NOT NULL,
  `status` enum('Pending','Paid','Overdue') DEFAULT 'Pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(2) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(150) NOT NULL,
  `usertype` varchar(28) NOT NULL,
  `reg-date` date NOT NULL,
  `last-login` datetime NOT NULL,
  `notes` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `email`, `password`, `usertype`, `reg-date`, `last-login`, `notes`) VALUES
(1, 'Anisur Rahman', 'shahin@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'Admin', '2020-09-06', '2020-09-13 12:14:24', ''),
(2, 'akkar', 'aa@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'Admin', '2020-09-06', '2020-09-06 00:00:00', ''),
(3, 'wwwwww', 'a@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'Admin', '2020-09-06', '2020-09-06 00:00:00', ''),
(4, 'ddddddd', 'w@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'Admin', '2020-09-06', '2020-09-06 00:00:00', ''),
(5, 'test', 'rizwan@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'Other', '2020-09-06', '2020-09-09 07:19:39', ''),
(6, 'ddddddddddddd', 'd@gmail.com', '631577fc0428c1dbc6176a3ca5935f77', 'Admin', '2020-09-06', '2020-09-06 00:00:00', ''),
(7, 'd@gmail.com', 'dc@gmail.com', '631577fc0428c1dbc6176a3ca5935f77', 'Admin', '2020-09-06', '2020-09-06 00:00:00', ''),
(8, 'Asik Newaz', 'asik@gmail.com', 'fcea920f7412b5da7be0cf42b8c93759', 'Other', '2020-09-06', '2020-09-06 01:55:55', ''),
(9, 'Asik Newaz', 'asik3#@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'Other', '2020-09-13', '2020-09-13 01:25:36', ''),
(10, 'Asik Newaz', 'asik1@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'Other', '2020-09-13', '2020-09-13 01:28:17', ''),
(11, 'Asik newaz', 'asik111@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'Other', '2020-09-13', '2020-09-13 01:53:44', ''),
(12, 'jhomar love alex', 'qwe@qwe.com', '76d80224611fc919a5d54f0ff9fba446', 'Admin', '2024-11-26', '2024-11-26 08:58:49', ''),
(13, 'jhomar barra', 'qwe@qwe', '76d80224611fc919a5d54f0ff9fba446', 'Admin', '2024-11-26', '2024-12-04 11:47:02', ''),
(14, 'James Reid', 'asd@asd', '7815696ecbf1c96e6894b779456d330e', 'Other', '2024-11-27', '2024-11-27 10:59:27', ''),
(15, 'Jhomar Barra', 'asd@asd.com', 'a8f5f167f44f4964e6c998dee827110c', 'Admin', '2024-12-01', '2024-12-01 02:41:36', ''),
(16, 'Jhomar Barra', 'jhomarbarra@pogi.com', '7f13cee6873ad1d748aacfd5a6b453d4', 'Admin', '2024-12-01', '2024-12-01 02:43:14', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`bid`),
  ADD UNIQUE KEY `brandname` (`brandname`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`cid`),
  ADD UNIQUE KEY `cat_name` (`catname`);

--
-- Indexes for table `financial_reports`
--
ALTER TABLE `financial_reports`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `invoices`
--
ALTER TABLE `invoices`
  ADD PRIMARY KEY (`id`),
  ADD KEY `member_id` (`member_id`);

--
-- Indexes for table `members`
--
ALTER TABLE `members`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payment_methods`
--
ALTER TABLE `payment_methods`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`pid`),
  ADD UNIQUE KEY `productname` (`productname`);

--
-- Indexes for table `receivables`
--
ALTER TABLE `receivables`
  ADD PRIMARY KEY (`id`),
  ADD KEY `member_id` (`member_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `brands`
--
ALTER TABLE `brands`
  MODIFY `bid` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `cid` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `financial_reports`
--
ALTER TABLE `financial_reports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `invoices`
--
ALTER TABLE `invoices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `members`
--
ALTER TABLE `members`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payment_methods`
--
ALTER TABLE `payment_methods`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `pid` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `receivables`
--
ALTER TABLE `receivables`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `invoices`
--
ALTER TABLE `invoices`
  ADD CONSTRAINT `invoices_ibfk_1` FOREIGN KEY (`member_id`) REFERENCES `members` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `receivables`
--
ALTER TABLE `receivables`
  ADD CONSTRAINT `receivables_ibfk_1` FOREIGN KEY (`member_id`) REFERENCES `members` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
