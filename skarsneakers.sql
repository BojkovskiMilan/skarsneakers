-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 20, 2026 at 11:51 PM
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
-- Database: `skarsneakers`
--

-- --------------------------------------------------------

--
-- Table structure for table `brands`
--

CREATE TABLE `brands` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `brands`
--

INSERT INTO `brands` (`id`, `name`) VALUES
(1, 'Nike'),
(2, 'Adidas'),
(3, 'Puma'),
(4, 'New Balance'),
(5, 'Reebok'),
(6, 'Jordan');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`) VALUES
(1, 'Running'),
(2, 'Basketball'),
(3, 'Lifestyle'),
(4, 'Training'),
(5, 'Streetwear');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `status_id` int(11) NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `order_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `status_id`, `total_price`, `order_date`) VALUES
(2, 5, 2, 799.96, '2026-06-19 23:35:53'),
(3, 6, 3, 399.98, '2026-06-20 16:25:24'),
(4, 5, 3, 179.99, '2026-06-20 18:08:00'),
(5, 5, 2, 359.98, '2026-06-20 18:08:08'),
(6, 5, 3, 319.98, '2026-06-20 18:29:22'),
(7, 6, 2, 129.99, '2026-06-20 18:34:17'),
(8, 6, 3, 399.98, '2026-06-20 20:05:18'),
(9, 5, 1, 479.97, '2026-06-20 22:22:04');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `quantity`, `price`) VALUES
(1, 2, 11, 4, 199.99),
(2, 3, 11, 2, 199.99),
(3, 4, 8, 1, 179.99),
(4, 5, 8, 2, 179.99),
(5, 6, 3, 2, 159.99),
(6, 7, 13, 1, 129.99),
(7, 8, 11, 2, 199.99),
(8, 9, 3, 3, 159.99);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `description` text NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `stock` int(11) NOT NULL,
  `image` varchar(255) NOT NULL,
  `thumbnail` varchar(255) NOT NULL,
  `featured` int(11) NOT NULL DEFAULT 0,
  `brand_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `price`, `stock`, `image`, `thumbnail`, `featured`, `brand_id`, `category_id`, `created_at`) VALUES
(1, 'Nike Air Max 270', 'Komforne lifestyle patike sa modernim dizajnom i velikim Air jedinicama.', 129.99, 12, 'airmax270.jpg', 'airmax270_thumb.jpg', 1, 1, 3, '2026-06-19 19:39:52'),
(2, 'Nike Air Force 1', 'Ikoničan streetwear model koji nikada ne izlazi iz mode.', 109.99, 20, 'af1.jpg', 'af1_thumb.jpg', 1, 1, 5, '2026-06-19 19:39:52'),
(3, 'Adidas Ultraboost 22', 'Premium running patike sa Boost amortizacijom.', 159.99, 15, 'ultraboost.jpg', 'ultraboost_thumb.jpg', 1, 2, 1, '2026-06-19 19:39:52'),
(4, 'Adidas Samba', 'Retro fudbalski model koji je postao streetwear klasik.', 99.99, 18, 'samba.jpg', 'samba_thumb.jpg', 1, 2, 5, '2026-06-19 19:39:52'),
(5, 'Puma RS-X', 'Chunky dizajn inspirisan retro futurizmom.', 89.99, 25, 'rsx.jpg', 'rsx_thumb.jpg', 0, 3, 5, '2026-06-19 19:39:52'),
(6, 'Puma Suede Classic', 'Jednostavan i čist lifestyle model.', 79.99, 30, 'suede.jpg', 'suede_thumb.jpg', 0, 3, 3, '2026-06-19 19:39:52'),
(7, 'New Balance 574', 'Retro silueta za svakodnevno nošenje.', 94.99, 22, 'nb574.jpg', 'nb574_thumb.jpg', 0, 4, 3, '2026-06-19 19:39:52'),
(8, 'New Balance 990', 'Premium model poznat po udobnosti i izradi.', 179.99, 10, 'nb990.jpg', 'nb990_thumb.jpg', 1, 4, 1, '2026-06-19 19:39:52'),
(9, 'Reebok Nano X3', 'Trening patike za teretanu i funkcionalni trening.', 119.99, 14, 'nano.jpg', 'nano_thumb.jpg', 0, 5, 4, '2026-06-19 19:39:52'),
(10, 'Reebok Classic Leather', 'Minimalistički retro lifestyle model.', 89.99, 18, 'classic.jpg', 'classic_thumb.jpg', 0, 5, 3, '2026-06-19 19:39:52'),
(11, 'Jordan 1 Retro High', 'Legendarni košarkaški model sa streetwear statusom.', 199.99, 8, 'jordan1.jpg', 'jordan1_thumb.jpg', 1, 6, 2, '2026-06-19 19:39:52'),
(12, 'Jordan 4 Black Cat', 'All-black premium sneaker dizajn.', 219.99, 6, 'jordan4.jpg', 'jordan4_thumb.jpg', 1, 6, 2, '2026-06-19 19:39:52'),
(13, 'Nike Pegasus 40', 'Running patike za svakodnevni trening.', 129.99, 16, 'pegasus.jpg', 'pegasus_thumb.jpg', 0, 1, 1, '2026-06-19 19:39:52'),
(14, 'Adidas NMD R1', 'Moderni lifestyle model sa Boost đonom.', 139.99, 19, 'nmd.jpg', 'nmd_thumb.jpg', 0, 2, 5, '2026-06-19 19:39:52'),
(15, 'Puma Future Rider', 'Retro trkački stil sa modernim twistom.', 84.99, 21, 'futurerider.jpg', 'futurerider_thumb.jpg', 0, 3, 5, '2026-06-19 19:39:52'),
(16, 'New Balance 2002R', 'Trendy lifestyle model popularan u streetwear sceni.', 149.99, 11, '2002r.jpg', '2002r_thumb.jpg', 1, 4, 5, '2026-06-19 19:39:52');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`) VALUES
(1, 'admin'),
(2, 'user');

-- --------------------------------------------------------

--
-- Table structure for table `statuses`
--

CREATE TABLE `statuses` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `statuses`
--

INSERT INTO `statuses` (`id`, `name`) VALUES
(1, 'processing'),
(2, 'completed'),
(3, 'cancelled');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `activation_code` varchar(100) DEFAULT NULL,
  `active` int(11) NOT NULL DEFAULT 0,
  `failed_attempts` int(11) NOT NULL DEFAULT 0,
  `locked_until` datetime DEFAULT NULL,
  `role_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `username`, `email`, `password`, `activation_code`, `active`, `failed_attempts`, `locked_until`, `role_id`, `created_at`) VALUES
(5, 'Milan', 'Bojkovski', 'Milan', 'bojkovskimilans@gmail.com', '$2y$10$rrSXsTeOC6/2pnvE5KzNmeAAYsjs1X2P/sRmMK4hoCg6jCsXg/2du', 'c609409dcf4e5700eb7f57bcdff24898', 1, 0, NULL, 2, '2026-06-19 22:30:44'),
(6, 'Milan', 'Bojkovski', 'Milan2', 'bojkovskimilano@gmail.com', '$2y$10$.yJX.rRA9iZayfFh3CkatOCeZMDlcZsHJ1j09ljKPS1DRl7fFjygG', '0b146b43222ca7302c2e4ce94b201931', 1, 0, NULL, 1, '2026-06-20 15:41:54'),
(7, 'Pera', 'Peric', 'Pera', 'pera123@gmail.com', '$2y$10$hLTfK7fz6pyaYSiTS.4piuk7EneLYwYOD3N..Za2OyNKXIwOCHLDe', '9e31b1ad8e3792ec214eacbca6450fc1', 1, 0, '2026-06-20 20:30:56', 2, '2026-06-20 19:22:24'),
(15, 'Admin', 'Admin', 'Admin', 'admin@gmail.com', '$2y$10$7eZR29KhbKW5HlUTCGj3netAmbcmXZNk1G1p0aXwI7./.0QEHPFoC', 'a60309985975f2533a6fb3da8f602335', 1, 0, NULL, 1, '2026-06-20 20:29:34'),
(16, 'User', 'User', 'User', 'user123@gmail.com', '$2y$10$QWFRyMpMPp1v3IJjvn2eN.OvltCJ.yW67bTgHJvFCaBnxKwsDtsz6', '9be1453313ccd5bfee8992eba0671ae4', 1, 0, NULL, 2, '2026-06-20 20:33:04'),
(17, 'Pera', 'Peric', 'Perica', 'pera1234@gmail.com', '$2y$10$e8ft3z0gjFpUw8lYcKpes.7vUgsECsSh0epOwX76wsj/VFx.TQJ2e', 'd55abf27c14075404f9809a6236607ea', 0, 0, NULL, 2, '2026-06-20 22:24:38');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `status_id` (`status_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `brand_id` (`brand_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `statuses`
--
ALTER TABLE `statuses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `role_id` (`role_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `brands`
--
ALTER TABLE `brands`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `statuses`
--
ALTER TABLE `statuses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`status_id`) REFERENCES `statuses` (`id`);

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`id`),
  ADD CONSTRAINT `products_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
