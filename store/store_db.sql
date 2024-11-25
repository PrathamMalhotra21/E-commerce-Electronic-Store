-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 18, 2024 at 06:58 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `store_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `first_name`, `last_name`, `username`, `password`) VALUES
(2, 'Administrator', 'admin', 'admin', '$2y$10$VsLTsIRsAAc7rAe/H.bvM.9oCZU.6kDrHQG6i/US/.PwEex2XC0d.');

-- --------------------------------------------------------

--
-- Table structure for table `banner`
--

CREATE TABLE `banner` (
  `id` int NOT NULL,
  `heading` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `badge_text` varchar(100) DEFAULT NULL,
  `btn_text` varchar(50) DEFAULT NULL,
  `image` varchar(255) NOT NULL,
  `date_created` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `banner`
--

INSERT INTO `banner` (`id`, `heading`, `title`, `badge_text`, `btn_text`, `image`, `date_created`) VALUES
(1, 'Incredible Prices on All Your Favorite Items', 'Get more for less on selected brands', 'Best Prices', 'Shop Now', 'upload/banner/673326315d55c.webp', '2024-11-12 09:56:01'),
(3, 'Incredible Prices on All Your Favorite Items', 'Get more for less on selected brands', 'Best Prices  ', 'Shop Now', 'upload/banner/673716f92571a.webp', '2024-11-15 09:40:09');

-- --------------------------------------------------------

--
-- Table structure for table `brands`
--

CREATE TABLE `brands` (
  `id` int NOT NULL,
  `brand_name` varchar(255) DEFAULT NULL,
  `description` text,
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `brands`
--

INSERT INTO `brands` (`id`, `brand_name`, `description`, `status`, `created_at`) VALUES
(1, 'Apple', 'Apple Company', 'active', '2024-11-10 09:53:27'),
(2, 'Samsung', 'Samsung Company', 'active', '2024-11-10 10:11:00'),
(3, 'Nokia', 'Nokia Compnay', 'active', '2024-11-10 10:38:25'),
(5, 'Boat', 'Boat ', 'active', '2024-11-17 07:52:31');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int NOT NULL,
  `category_name` varchar(100) NOT NULL,
  `description` text,
  `image` varchar(255) DEFAULT NULL,
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `category_name`, `description`, `image`, `status`, `created_at`) VALUES
(2, 'Mobile', 'Mobile', 'upload/category/672f0dd021370.webp', 'active', '2024-11-09 07:22:56'),
(4, 'Laptop', 'Laptop', 'upload/category/672f4930ddc3a.jpg', 'active', '2024-11-09 11:36:16'),
(5, 'Mobile Accessories', 'Mobile Accessories such as mobile cover', 'upload/category/672f59b770f57.jpg', 'active', '2024-11-09 12:24:03'),
(8, 'Computer Accessories', 'Computer Accessories such as keyword, mouse, cables etc', 'upload/category/672f609fefa82.jpg', 'active', '2024-11-09 13:16:15');

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

CREATE TABLE `clients` (
  `id` int NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone_number` varchar(15) NOT NULL,
  `address` text,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `clients`
--

INSERT INTO `clients` (`id`, `first_name`, `last_name`, `email`, `phone_number`, `address`, `password`, `created_at`) VALUES
(1, 'John', 'Doe', 'john@gmail.com', '9811679296', 'Mars', '$2y$10$afdnrU3XMVyfmd02eVu42Ol4VPjQwLTLqHgYZbvAjDLuCWFUNFsMa', '2024-11-14 10:35:31'),
(3, 'Rohit', 'Doe', 'rohit@gmail.com', '123', 'international space station', '$2y$10$sCciju2jouQ366KtCKBW3.2zgf2h9UBLNTftAizB83Z/EvtUkoRje', '2024-11-17 13:41:11');

-- --------------------------------------------------------

--
-- Table structure for table `inventory`
--

CREATE TABLE `inventory` (
  `id` int NOT NULL,
  `product_id` int DEFAULT NULL,
  `quantity` int NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `date_created` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `inventory`
--

INSERT INTO `inventory` (`id`, `product_id`, `quantity`, `price`, `date_created`) VALUES
(2, 5, 31, '19.00', '2024-11-12 07:05:56'),
(5, 4, 22, '450.00', '2024-11-12 07:42:44'),
(6, 7, 98, '79.00', '2024-11-17 08:15:32');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `payment_method` enum('paypal','cash') NOT NULL,
  `status` enum('pending','processing','completed','cancelled') NOT NULL DEFAULT 'pending',
  `payment_status` varchar(100) NOT NULL,
  `address` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `total_amount`, `payment_method`, `status`, `payment_status`, `address`, `created_at`, `updated_at`) VALUES
(1, 1, '19.00', 'cash', 'processing', 'COD', 'Mars', '2024-11-14 15:02:39', '2024-11-14 17:13:57'),
(3, 1, '450.00', 'paypal', 'pending', 'COD', 'Mars', '2024-11-14 15:29:22', '2024-11-14 15:29:22'),
(4, 1, '38.00', 'cash', 'pending', 'COD', 'Mars', '2024-11-14 18:01:47', '2024-11-14 18:01:47'),
(5, 1, '919.00', 'paypal', 'pending', 'completed', 'Sun', '2024-11-16 17:01:29', '2024-11-17 10:11:26'),
(6, 3, '79.00', 'cash', 'pending', 'pending', 'international space station', '2024-11-17 13:49:31', '2024-11-17 13:49:31'),
(7, 1, '79.00', 'cash', 'pending', 'pending', 'Mars', '2024-11-18 06:42:02', '2024-11-18 06:42:02');

-- --------------------------------------------------------

--
-- Table structure for table `orders_list`
--

CREATE TABLE `orders_list` (
  `id` int NOT NULL,
  `order_id` int NOT NULL,
  `product_id` int NOT NULL,
  `quantity` int NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders_list`
--

INSERT INTO `orders_list` (`id`, `order_id`, `product_id`, `quantity`, `price`) VALUES
(1, 1, 5, 1, '19.00'),
(3, 3, 4, 1, '450.00'),
(4, 4, 5, 2, '19.00'),
(5, 5, 4, 2, '450.00'),
(6, 5, 5, 1, '19.00'),
(7, 6, 7, 1, '79.00'),
(8, 7, 7, 1, '79.00');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `specs` text NOT NULL,
  `brand_id` int DEFAULT NULL,
  `category_id` int DEFAULT NULL,
  `sub_category_id` int DEFAULT NULL,
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `specs`, `brand_id`, `category_id`, `sub_category_id`, `status`, `created_at`) VALUES
(4, 'iPhone Pro Max 12', '<ul class=\"techspecs-list\" role=\"list\" style=\"padding: 0px; margin-right: 0px; margin-bottom: 0px; margin-left: 0px; color: rgb(52, 58, 64); font-family: \"Source Sans Pro\", -apple-system, BlinkMacSystemFont, \"Segoe UI\", Roboto, \"Helvetica Neue\", Arial, sans-serif, \"Apple Color Emoji\", \"Segoe UI Emoji\", \"Segoe UI Symbol\"; font-size: 14px; list-style: none;\"><li role=\"listitem\" style=\"margin: 0px; padding: 0px;\">Super Retina XDR display</li><li role=\"listitem\" style=\"margin: 0.4em 0px 0px; padding: 0px;\">6.7‑inch (diagonal) all‑screen OLED display</li><li role=\"listitem\" style=\"margin: 0.4em 0px 0px; padding: 0px;\">2778‑by‑1284-pixel resolution at 458 ppi</li></ul><p class=\"typography-caption model-caption\" style=\"margin: 0.8em 0px 0px; color: rgb(52, 58, 64); font-family: \"Source Sans Pro\", -apple-system, BlinkMacSystemFont, \"Segoe UI\", Roboto, \"Helvetica Neue\", Arial, sans-serif, \"Apple Color Emoji\", \"Segoe UI Emoji\", \"Segoe UI Symbol\"; font-size: 14px; padding: 0px; line-height: 1.33337;\">The iPhone 12 Pro Max display has rounded corners that follow a beautiful curved design, and these corners are within a standard rectangle. When measured as a standard rectangular shape, the screen is 6.68 inches diagonally (actual viewable area is less).</p><p style=\"margin: 0.8em 0px 0px; color: rgb(52, 58, 64); font-family: \"Source Sans Pro\", -apple-system, BlinkMacSystemFont, \"Segoe UI\", Roboto, \"Helvetica Neue\", Arial, sans-serif, \"Apple Color Emoji\", \"Segoe UI Emoji\", \"Segoe UI Symbol\"; font-size: 14px; padding: 0px; line-height: 1.33337;\"><br></p><ul class=\"techspecs-list\" role=\"list\" style=\"padding: 0px; margin-right: 0px; margin-bottom: 0px; margin-left: 0px; color: rgb(52, 58, 64); font-family: \"Source Sans Pro\", -apple-system, BlinkMacSystemFont, \"Segoe UI\", Roboto, \"Helvetica Neue\", Arial, sans-serif, \"Apple Color Emoji\", \"Segoe UI Emoji\", \"Segoe UI Symbol\"; font-size: 14px; list-style: none;\"><li role=\"listitem\" style=\"margin: 0px; padding: 0px;\">HDR display</li><li role=\"listitem\" style=\"margin: 0.4em 0px 0px; padding: 0px;\">True Tone</li><li role=\"listitem\" style=\"margin: 0.4em 0px 0px; padding: 0px;\">Wide color (P3)</li><li role=\"listitem\" style=\"margin: 0.4em 0px 0px; padding: 0px;\">Haptic Touch</li><li role=\"listitem\" style=\"margin: 0.4em 0px 0px; padding: 0px;\">2,000,000:1 contrast ratio (typical)</li><li role=\"listitem\" style=\"margin: 0.4em 0px 0px; padding: 0px;\">800 nits max brightness (typical); 1,200 nits max brightness (HDR)</li><li role=\"listitem\" style=\"margin: 0.4em 0px 0px; padding: 0px;\">Fingerprint-resistant oleophobic coating</li><li role=\"listitem\" style=\"margin: 0.4em 0px 0px; padding: 0px;\">Support for display of multiple languages and characters simultaneously</li></ul>', 1, 2, NULL, 'active', '2024-11-10 21:10:50'),
(5, 'iPhone Pro Max 12 Case Cover', '<p open=\"\" sans\",=\"\" arial,=\"\" sans-serif;\"=\"\" style=\"margin-right: 0px; margin-bottom: 15px; margin-left: 0px; font-family: \"Source Sans Pro\", -apple-system, BlinkMacSystemFont, \"Segoe UI\", Roboto, \"Helvetica Neue\", Arial, sans-serif, \"Apple Color Emoji\", \"Segoe UI Emoji\", \"Segoe UI Symbol\"; font-size: 14px; padding: 0px; text-align: justify;\">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur rhoncus posuere accumsan. Maecenas eget aliquam odio, ac vehicula leo. Praesent magna erat, consectetur elementum leo nec, ornare congue dolor. Sed tristique magna non lorem tristique, vitae dictum velit posuere. Aliquam in tempor dui, nec scelerisque mi. Interdum et malesuada fames ac ante ipsum primis in faucibus. Curabitur venenatis urna justo, eu dapibus diam venenatis vel. Proin tincidunt leo a elit mollis, in sollicitudin est iaculis. In metus urna, cursus non ullamcorper sed, cursus id velit. Nullam dui justo, gravida sit amet sollicitudin vel, tempor ac diam. Phasellus egestas quis metus in condimentum. Pellentesque non dapibus eros, eu facilisis ipsum. Cras suscipit metus iaculis, varius est eu, blandit metus. Mauris sed diam eros. Curabitur gravida pulvinar metus a euismod. Cras consequat metus eros, id tincidunt massa aliquam ut.</p><p open=\"\" sans\",=\"\" arial,=\"\" sans-serif;\"=\"\" style=\"margin-right: 0px; margin-bottom: 15px; margin-left: 0px; font-family: \"Source Sans Pro\", -apple-system, BlinkMacSystemFont, \"Segoe UI\", Roboto, \"Helvetica Neue\", Arial, sans-serif, \"Apple Color Emoji\", \"Segoe UI Emoji\", \"Segoe UI Symbol\"; font-size: 14px; padding: 0px; text-align: justify;\">Sed sit amet eleifend nisl. Aliquam ullamcorper nisl sed eros commodo cursus. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin leo metus, malesuada ac viverra quis, placerat in magna. Morbi suscipit justo vitae tincidunt venenatis. Aliquam ex odio, sagittis quis tincidunt id, semper ut orci. Cras consequat dui vel vestibulum volutpat. Maecenas dapibus purus quis magna consectetur placerat. Donec porttitor massa eu lacus aliquet bibendum.</p><p open=\"\" sans\",=\"\" arial,=\"\" sans-serif;\"=\"\" style=\"margin-right: 0px; margin-bottom: 15px; margin-left: 0px; font-family: \"Source Sans Pro\", -apple-system, BlinkMacSystemFont, \"Segoe UI\", Roboto, \"Helvetica Neue\", Arial, sans-serif, \"Apple Color Emoji\", \"Segoe UI Emoji\", \"Segoe UI Symbol\"; font-size: 14px; padding: 0px; text-align: justify;\">Sed ut ex sed elit blandit ultrices. Curabitur non suscipit purus, eu facilisis felis. Proin ac nisl commodo, efficitur tortor mattis, elementum velit. Duis vel mattis justo. Pellentesque sodales, enim vel blandit vulputate, nunc nunc pretium dolor, vitae cursus massa erat consectetur ex. Donec varius tristique dui vitae semper. Quisque dictum volutpat vulputate. Morbi dui enim, auctor vel velit vel, sollicitudin scelerisque metus. Duis in turpis a elit luctus vestibulum.</p>', 1, 5, 5, 'active', '2024-11-10 21:14:07'),
(7, 'Headphone CDX', '<ul><li style=\"margin: 0px; padding: 0px 0px 8px 16px; list-style: none; position: relative;\">With Mic:Yes</li><li style=\"margin: 0px; padding: 0px 0px 8px 16px; list-style: none; position: relative;\">Connector type: 3.5 mm</li><li style=\"margin: 0px; padding: 0px 0px 8px 16px; list-style: none; position: relative;\">Battery life: 15 hr | Charging time: 3 Hours</li><li style=\"margin: 0px; padding: 0px 0px 8px 16px; list-style: none; position: relative;\">Drivers- Its 40mm dynamic drivers help pump out immersive HD audio all day long</li><li style=\"margin: 0px; padding: 0px 0px 8px 16px; list-style: none; position: relative;\">Playback- It provides a massive battery backup of upto 15 hours for a superior playback time.</li><li style=\"margin: 0px; padding: 0px 0px 8px 16px; list-style: none; position: relative;\">Ear Cushions- It has been ergonomically designed and structured as an on-ear headphone to provide the best user experience with its comfortable padded earcushions and lightweight design</li><li style=\"margin: 0px; padding: 0px 0px 0px 16px; list-style: none; position: relative;\">Controls- You can control your music without hiccups using the easy access controls, communicate seamlessly using the built-in mic, access voice assistant and always stay in the zone</li></ul>', 5, 5, 4, 'active', '2024-11-17 07:53:55');

-- --------------------------------------------------------

--
-- Table structure for table `sub_categories`
--

CREATE TABLE `sub_categories` (
  `id` int NOT NULL,
  `category_id` int NOT NULL,
  `sub_category_name` varchar(100) NOT NULL,
  `description` text,
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sub_categories`
--

INSERT INTO `sub_categories` (`id`, `category_id`, `sub_category_name`, `description`, `status`, `created_at`) VALUES
(1, 8, 'Mouse', 'Computer Mouse', 'active', '2024-11-09 17:00:48'),
(2, 2, 'Keyboard', 'Keyboard for computers, laptop etc', 'inactive', '2024-11-09 17:17:53'),
(4, 5, 'Headphone', 'Headphones', 'active', '2024-11-17 07:50:48'),
(5, 5, 'Mobile Cover', 'Mobile Cover', 'active', '2024-11-17 08:36:54');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `banner`
--
ALTER TABLE `banner`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `inventory`
--
ALTER TABLE `inventory`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `product_id` (`product_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `orders_list`
--
ALTER TABLE `orders_list`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `brand_id` (`brand_id`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `sub_category_id` (`sub_category_id`);

--
-- Indexes for table `sub_categories`
--
ALTER TABLE `sub_categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `banner`
--
ALTER TABLE `banner`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `brands`
--
ALTER TABLE `brands`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `clients`
--
ALTER TABLE `clients`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `inventory`
--
ALTER TABLE `inventory`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `orders_list`
--
ALTER TABLE `orders_list`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `sub_categories`
--
ALTER TABLE `sub_categories`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `inventory`
--
ALTER TABLE `inventory`
  ADD CONSTRAINT `inventory_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `orders_list`
--
ALTER TABLE `orders_list`
  ADD CONSTRAINT `orders_list_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  ADD CONSTRAINT `orders_list_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`id`),
  ADD CONSTRAINT `products_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`),
  ADD CONSTRAINT `products_ibfk_3` FOREIGN KEY (`sub_category_id`) REFERENCES `sub_categories` (`id`);

--
-- Constraints for table `sub_categories`
--
ALTER TABLE `sub_categories`
  ADD CONSTRAINT `sub_categories_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
