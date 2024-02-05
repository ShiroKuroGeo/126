-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 05, 2024 at 10:01 AM
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
-- Database: `126motorparts`
--

-- --------------------------------------------------------

--
-- Table structure for table `rpos_admin`
--

CREATE TABLE `rpos_admin` (
  `admin_id` varchar(200) NOT NULL,
  `admin_name` varchar(200) NOT NULL,
  `admin_email` varchar(200) NOT NULL,
  `admin_password` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `rpos_admin`
--

INSERT INTO `rpos_admin` (`admin_id`, `admin_name`, `admin_email`, `admin_password`) VALUES
('10e0b6dc958adfb5b094d8935a13aeadbe783c25', 'System Admin', 'admin@gmail.com', '10470c3b4b1fed12c3baac014be15fac67c6e815');

-- --------------------------------------------------------

--
-- Table structure for table `rpos_cart`
--

CREATE TABLE `rpos_cart` (
  `cart_id` varchar(200) NOT NULL,
  `cart_code` varchar(200) NOT NULL,
  `customer_id` varchar(200) NOT NULL,
  `customer_name` varchar(200) NOT NULL,
  `prod_id` varchar(200) NOT NULL,
  `prod_name` varchar(200) NOT NULL,
  `prod_img` varchar(200) NOT NULL,
  `prod_price` varchar(200) NOT NULL,
  `prod_qty` varchar(200) NOT NULL,
  `cart_status` varchar(200) NOT NULL,
  `created_at` timestamp(6) NOT NULL DEFAULT current_timestamp(6) ON UPDATE current_timestamp(6)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `rpos_cart`
--

INSERT INTO `rpos_cart` (`cart_id`, `cart_code`, `customer_id`, `customer_name`, `prod_id`, `prod_name`, `prod_img`, `prod_price`, `prod_qty`, `cart_status`, `created_at`) VALUES
('6c43806050', 'TNZP-7915', 'bef90fc73a5d', 'shiro', '35e6b9e396', 'Mags', '', '350', '2', '', '2024-01-30 09:35:01.901122'),
('e3c18e63b6', 'TLQN-9803', 'bef90fc73a5d', 'shiro', '35e6b9e396', 'Mags', '', '350', '1', '', '2024-01-30 09:30:44.698591');

-- --------------------------------------------------------

--
-- Table structure for table `rpos_customers`
--

CREATE TABLE `rpos_customers` (
  `customer_id` varchar(200) NOT NULL,
  `customer_name` varchar(200) NOT NULL,
  `customer_phoneno` varchar(200) NOT NULL,
  `customer_email` varchar(200) NOT NULL,
  `customer_password` varchar(200) NOT NULL,
  `created_at` timestamp(6) NOT NULL DEFAULT current_timestamp(6) ON UPDATE current_timestamp(6)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `rpos_customers`
--

INSERT INTO `rpos_customers` (`customer_id`, `customer_name`, `customer_phoneno`, `customer_email`, `customer_password`, `created_at`) VALUES
('35135b319ce3', 'Kurisuti Yap', '09556041283', 'customer@gmail.com', '10470c3b4b1fed12c3baac014be15fac67c6e815', '2023-04-14 04:47:21.815552'),
('99a17f4644a9', 'keth elden', '09556041283', 'keth@gmail.com', '10470c3b4b1fed12c3baac014be15fac67c6e815', '2023-12-22 18:20:47.166817'),
('bef90fc73a5d', 'shiro', '09484750060', 'shiro@gmail.com', '10470c3b4b1fed12c3baac014be15fac67c6e815', '2024-02-01 03:53:51.001046');

-- --------------------------------------------------------

--
-- Table structure for table `rpos_orders`
--

CREATE TABLE `rpos_orders` (
  `order_id` varchar(200) NOT NULL,
  `order_code` varchar(200) NOT NULL,
  `customer_id` varchar(200) NOT NULL,
  `customer_name` varchar(200) NOT NULL,
  `prod_id` varchar(200) NOT NULL,
  `prod_name` varchar(200) NOT NULL,
  `prod_price` varchar(200) NOT NULL,
  `prod_qty` varchar(200) NOT NULL,
  `order_status` varchar(200) NOT NULL,
  `created_at` timestamp(6) NOT NULL DEFAULT current_timestamp(6) ON UPDATE current_timestamp(6)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `rpos_orders`
--

INSERT INTO `rpos_orders` (`order_id`, `order_code`, `customer_id`, `customer_name`, `prod_id`, `prod_name`, `prod_price`, `prod_qty`, `order_status`, `created_at`) VALUES
('0cda20b738', 'REFK-5416', '35135b319ce3', 'Kurisuti Yap', '35e6b9e396', 'Mags', '350', '1', 'Paid', '2024-02-05 03:23:37.080840'),
('12f79d8382', 'QPCF-5083', '35135b319ce3', 'Kurisuti Yap', '9c927223b7', 'Shock', '200', '1', 'Paid', '2023-04-26 05:48:20.814688'),
('9b4bd8791e', 'WQMZ-3148', '35135b319ce3', 'Kurisuti Yap', '35e6b9e396', 'Mags', '350', '10', 'Paid', '2024-02-05 03:18:22.526176'),
('a1e8a6ea5b', 'NRBI-9341', '35135b319ce3', 'Kurisuti Yap', '9c927223b7', 'Shock', '200', '2', 'Paid', '2023-04-27 15:42:41.557202'),
('a21e2a43c5', 'YBVK-7584', '99a17f4644a9', 'keth elden', 'fe111b20e2', 'tire hugger', '250', '1', 'Paid', '2023-12-22 18:22:32.726188'),
('a42d12cbb8', 'FPQX-4812', '35135b319ce3', 'Kurisuti Yap', '9c927223b7', 'Shock', '200', '1', 'Paid', '2023-04-26 07:26:07.686251'),
('c971c42851', 'UDAP-0981', 'bef90fc73a5d', 'shiro', '3e6d46832b', 'mini driving light', '700', '1', 'Paid', '2024-01-31 07:29:26.579230'),
('e30a8a6a50', 'BHXP-8649', '35135b319ce3', 'Kurisuti Yap', '3e6d46832b', 'mini driving light', '700', '12', 'Paid', '2024-01-31 07:33:08.879108'),
('e3d30838a9', 'PYJZ-1065', '35135b319ce3', 'Kurisuti Yap', '9c927223b7', 'Shock', '200', '1', 'Paid', '2023-04-26 06:03:51.029947');

-- --------------------------------------------------------

--
-- Table structure for table `rpos_pass_resets`
--

CREATE TABLE `rpos_pass_resets` (
  `reset_id` int(20) NOT NULL,
  `reset_code` varchar(200) NOT NULL,
  `reset_token` varchar(200) NOT NULL,
  `reset_email` varchar(200) NOT NULL,
  `reset_status` varchar(200) NOT NULL,
  `created_at` timestamp(6) NOT NULL DEFAULT current_timestamp(6) ON UPDATE current_timestamp(6)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `rpos_pass_resets`
--

INSERT INTO `rpos_pass_resets` (`reset_id`, `reset_code`, `reset_token`, `reset_email`, `reset_status`, `created_at`) VALUES
(1, '63KU9QDGSO', '4ac4cee0a94e82a2aedc311617aa437e218bdf68', 'sytmadmin@gmail.com', 'Pending', '2023-04-27 07:08:11.018304');

-- --------------------------------------------------------

--
-- Table structure for table `rpos_payments`
--

CREATE TABLE `rpos_payments` (
  `pay_id` varchar(200) NOT NULL,
  `pay_code` varchar(200) NOT NULL,
  `order_code` varchar(200) NOT NULL,
  `customer_id` varchar(200) NOT NULL,
  `staff_id` int(20) NOT NULL,
  `staff_name` varchar(200) NOT NULL,
  `pay_amt` varchar(200) NOT NULL,
  `pay_method` varchar(200) NOT NULL,
  `created_at` timestamp(6) NOT NULL DEFAULT current_timestamp(6) ON UPDATE current_timestamp(6)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `rpos_payments`
--

INSERT INTO `rpos_payments` (`pay_id`, `pay_code`, `order_code`, `customer_id`, `staff_id`, `staff_name`, `pay_amt`, `pay_method`, `created_at`) VALUES
('1d49d1', 'KXUPGALBOW', 'GBJR-8052', '35135b319ce3', 0, '', '350', 'Cash', '2023-12-22 17:35:44.628398'),
('247fe2', 'H19GBEFUZC', 'YBVK-7584', '99a17f4644a9', 0, '', '250', 'Cash', '2023-12-22 18:22:32.724761'),
('26978c', 'WNMU9HIJT6', 'PYJZ-1065', '35135b319ce3', 0, '', '200', 'Gcash', '2023-12-21 14:05:26.335142'),
('2a5c05', 'FDRIPSUL6Y', 'WQMZ-3148', '35135b319ce3', 0, '', '3500', 'Gcash', '2024-02-05 03:18:22.437016'),
('47f11a', 'AWAIYAWUND', 'FSGE-8269', '35135b319ce3', 0, '', '350', 'Cash', '2023-04-28 06:02:08.658562'),
('4e71b6', 'TWZDU5VL1A', 'XSUB-3481', '35135b319ce3', 0, '', '1400', 'Cash', '2023-12-21 14:48:26.203758'),
('5169d0', 'BCA2GHXKLJ', 'QPCF-5083', '35135b319ce3', 0, '', '200', 'Cash', '2023-04-26 05:48:20.687174'),
('5290d7', 'AWERGDTHGF', 'FPQX-4812', '35135b319ce3', 0, '', '200', 'Cash', '2023-04-26 07:26:07.647092'),
('b34fd4', '1ZV8SJ9WOP', 'XZGJ-8914', '35135b319ce3', 0, '', '700', 'Cash', '2023-12-21 16:23:41.840682'),
('ba419b', 'NDTK5R2YUL', 'NRBI-9341', '35135b319ce3', 0, '', '400', 'Cash', '2023-04-27 15:42:41.482201'),
('c00644', 'D1B457UJY2', 'REFK-5416', '35135b319ce3', 2, '', '350', 'Gcash', '2024-02-05 03:23:37.047734'),
('c71b7f', 'L7JGOKQVCX', 'UDAP-0981', 'bef90fc73a5d', 0, '', '700', 'Cash', '2024-01-31 07:29:26.534644'),
('eff7c4', 'IZTQBK3Y1N', 'BHXP-8649', '35135b319ce3', 0, '', '8400', 'Cash', '2024-01-31 07:33:08.862103');

-- --------------------------------------------------------

--
-- Table structure for table `rpos_products`
--

CREATE TABLE `rpos_products` (
  `prod_id` varchar(200) NOT NULL,
  `prod_code` varchar(200) NOT NULL,
  `prod_name` varchar(200) NOT NULL,
  `prod_quantity` varchar(200) NOT NULL DEFAULT '1',
  `prod_img` varchar(200) NOT NULL,
  `prod_desc` longtext NOT NULL,
  `prod_origpr` varchar(200) NOT NULL,
  `prod_revenue` varchar(200) NOT NULL,
  `prod_price` varchar(200) NOT NULL,
  `created_at` timestamp(6) NOT NULL DEFAULT current_timestamp(6) ON UPDATE current_timestamp(6)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `rpos_products`
--

INSERT INTO `rpos_products` (`prod_id`, `prod_code`, `prod_name`, `prod_quantity`, `prod_img`, `prod_desc`, `prod_origpr`, `prod_revenue`, `prod_price`, `created_at`) VALUES
('2af246f1f4', 'FYIG-6724', 'tire', '', 'tire.jpg', 'tire', '', '', '1150', '2023-12-22 18:14:38.838407'),
('35e6b9e396', 'HRDW-3862', 'Mags', '5', 'mags.png', 'Motor mags', '', '', '350', '2024-02-05 03:15:15.515582'),
('3e6d46832b', 'DSJH-3478', 'mini driving light', '', 'mdl.jpg', 'mini driving light heavy duty', '', '', '700', '2023-12-22 18:54:49.500839'),
('7ef2ba95a5', 'IAYN-9421', 'handle grip', '', 'handle.jpg', 'handle grip', '', '', '90', '2023-12-22 18:14:16.481900'),
('9c927223b7', 'GMHV-2593', 'Shock', '8', 'shock.jpg', 'Shock absorber', '', '', '200', '2023-04-26 05:44:34.727506'),
('ea95e4df3c', 'RSFK-6584', 'brake', '', 'brake.jpg', 'brake', '', '', '120', '2023-12-22 18:13:43.852275'),
('fe111b20e2', 'IYGN-4692', 'tire hugger', '', 'tirehugger.jpg', 'tire hugger for click', '', '', '250', '2023-12-22 18:15:06.973249');

-- --------------------------------------------------------

--
-- Table structure for table `rpos_staff`
--

CREATE TABLE `rpos_staff` (
  `staff_id` int(20) NOT NULL,
  `staff_name` varchar(200) NOT NULL,
  `staff_number` varchar(200) NOT NULL,
  `staff_email` varchar(200) NOT NULL,
  `staff_password` varchar(200) NOT NULL,
  `created_at` timestamp(6) NOT NULL DEFAULT current_timestamp(6) ON UPDATE current_timestamp(6)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `rpos_staff`
--

INSERT INTO `rpos_staff` (`staff_id`, `staff_name`, `staff_number`, `staff_email`, `staff_password`, `created_at`) VALUES
(2, 'Cashier Roll', 'QEUY-9042', 'cashier@gmail.com', '10470c3b4b1fed12c3baac014be15fac67c6e815', '2023-04-13 14:46:17.791857');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `rpos_admin`
--
ALTER TABLE `rpos_admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `rpos_cart`
--
ALTER TABLE `rpos_cart`
  ADD PRIMARY KEY (`cart_id`),
  ADD KEY `CustomerName` (`customer_id`) USING BTREE;

--
-- Indexes for table `rpos_customers`
--
ALTER TABLE `rpos_customers`
  ADD PRIMARY KEY (`customer_id`);

--
-- Indexes for table `rpos_orders`
--
ALTER TABLE `rpos_orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `CustomerOrder` (`customer_id`),
  ADD KEY `ProductOrder` (`prod_id`);

--
-- Indexes for table `rpos_pass_resets`
--
ALTER TABLE `rpos_pass_resets`
  ADD PRIMARY KEY (`reset_id`);

--
-- Indexes for table `rpos_payments`
--
ALTER TABLE `rpos_payments`
  ADD PRIMARY KEY (`pay_id`),
  ADD KEY `order` (`order_code`),
  ADD KEY `Staff` (`staff_id`) USING BTREE;

--
-- Indexes for table `rpos_products`
--
ALTER TABLE `rpos_products`
  ADD PRIMARY KEY (`prod_id`);

--
-- Indexes for table `rpos_staff`
--
ALTER TABLE `rpos_staff`
  ADD PRIMARY KEY (`staff_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `rpos_pass_resets`
--
ALTER TABLE `rpos_pass_resets`
  MODIFY `reset_id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `rpos_staff`
--
ALTER TABLE `rpos_staff`
  MODIFY `staff_id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `rpos_orders`
--
ALTER TABLE `rpos_orders`
  ADD CONSTRAINT `CustomerOrder` FOREIGN KEY (`customer_id`) REFERENCES `rpos_customers` (`customer_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ProductOrder` FOREIGN KEY (`prod_id`) REFERENCES `rpos_products` (`prod_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
