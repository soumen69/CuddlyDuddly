-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 08, 2026 at 02:44 PM
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
-- Database: `cuddly_duddly`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_users`
--

CREATE TABLE `admin_users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `role_id` int(11) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `session_id` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1=active,0=inactive',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_users`
--

INSERT INTO `admin_users` (`id`, `role_id`, `name`, `email`, `phone`, `password`, `session_id`, `is_active`, `created_at`, `updated_at`) VALUES
(2, 5, 'Soumen Maity', 'admin@cuddlyduddly.com', '9382319968', '$2y$12$5jJ083VjsmkvzWR7.kUJOeo0jZxiYGumL2Kjo5jztlYxtPsJkyY3e', 'r4M3En6qLrnJm7En5E5QkxERoJ3XqsNouwskQlLZ', 1, '2025-09-09 23:04:41', '2026-07-01 10:32:20'),
(3, 11, 'Amar Maity', 'amar.maity@delostylestudio.com', NULL, '$2y$12$C2qW5iP6UA4CsAaZBIlKCuNAIVM8hzEH3IcbmxUZ.JJf6fnyEU31q', 'A1XBkk4gKpVPmJ3TTKkB5Uh8pOBU6khIOnxgy2qv', 1, '2025-10-31 01:54:01', '2025-12-09 04:25:38'),
(4, 7, 'Rajesh Kumar', 'rajesh.kumar@delostylestudio.com', NULL, '$2y$12$SSsKeVbeovXdYvgMCjSSmOaXHM822857gxEonEZXxL.E7bTcJBQ/m', 'egGogOV8IPUwWOSx9fQA1Yy0MgWYiyioJtfweii1', 1, '2025-10-31 03:51:45', '2026-04-15 10:00:43'),
(5, 5, 'Rajib Banerjee', 'rajib@delostylestudio.com', NULL, '$2y$12$B6p4TAy0qBuwLFIilDAQ4uGWN0J7YyFulEznAwcHoaCfmJbjWbB0u', '0eyPPfFSrUUR9J8UCdsHCD3AMpLjmEwVH5OJ9WKS', 1, '2025-10-31 03:54:03', '2026-04-15 09:55:22'),
(6, 10, 'Debleena Chakraborty', 'debleena.chakraborty@delostylestudio.com', NULL, '$2y$12$xf21UoesWKmLZpSgOidLg.FTn05.bCSrANK3g9J4kqDGXklkKYMVK', NULL, 1, '2025-10-31 03:56:42', '2026-04-15 09:57:49');

-- --------------------------------------------------------

--
-- Table structure for table `attributes`
--

CREATE TABLE `attributes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `input_type` enum('select','multi-select','boolean') DEFAULT 'select',
  `is_filterable` tinyint(1) DEFAULT 1,
  `is_variant` tinyint(1) DEFAULT 0,
  `is_visual` tinyint(1) DEFAULT 0,
  `status` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `attributes`
--

INSERT INTO `attributes` (`id`, `name`, `slug`, `input_type`, `is_filterable`, `is_variant`, `is_visual`, `status`) VALUES
(12, 'Diaper Size', 'diaper-size', 'select', 1, 1, 0, 1),
(16, 'Language', 'language', 'select', 1, 0, 0, 1),
(17, 'Binding Type', 'binding-type', 'select', 1, 0, 0, 1),
(41, 'Age', 'age-69a8279c82f66', 'select', 1, 0, 0, 1),
(90, 'Toy Type', 'toy-type-69aec46003d63', 'select', 1, 0, 0, 1),
(91, 'Skill Type', 'skill-type-69aec46006c30', 'select', 1, 0, 0, 1),
(188, 'Quantity(MG)', 'quantitymg-69de2ba71245c', 'multi-select', 1, 1, 0, 1),
(189, 'Quantity (ML)', 'quantity-ml-69de2ba712d3e', 'multi-select', 1, 1, 0, 1),
(190, 'Pack of', 'pack-of-69de2ba713583', 'multi-select', 1, 1, 0, 1),
(215, 'Occasion', 'occasion-6a01b0e48b23b', 'select', 1, 0, 0, 1),
(216, 'Gender', 'gender-6a01b0e48c086', 'select', 1, 0, 0, 1),
(217, 'Color', 'color-6a01b0e48c892', 'multi-select', 1, 1, 1, 1),
(218, 'Size', 'size-6a01b0e48d9a0', 'multi-select', 1, 1, 0, 1),
(219, 'Delivery', 'delivery-6a01b0e48f057', 'boolean', 1, 0, 0, 1),
(220, 'Quantity', 'quantity-6a0201db8f155', 'multi-select', 1, 1, 0, 1),
(224, 'Storage', 'storage-6a2ff26bd4952', 'select', 1, 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `attribute_values`
--

CREATE TABLE `attribute_values` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `attribute_id` bigint(20) UNSIGNED NOT NULL,
  `value` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `sort_order` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `attribute_values`
--

INSERT INTO `attribute_values` (`id`, `attribute_id`, `value`, `slug`, `sort_order`) VALUES
(100, 41, '0-3 M', '0-3-m-69a8279c836f5', 0),
(101, 41, '3 - 6 M', '3-6-m-69a8279c83d4c', 0),
(102, 41, '6 - 9 M', '6-9-m-69a8279c84301', 0),
(330, 90, 'Educational Toys', 'educational-toys-69aec460043b8', 0),
(331, 90, 'Action Figures', 'action-figures-69aec46004a61', 0),
(332, 90, 'Board Games', 'board-games-69aec460050a2', 0),
(333, 90, 'Building Blocks', 'building-blocks-69aec4600566d', 0),
(334, 90, 'Soft Toys', 'soft-toys-69aec46005c1a', 0),
(335, 90, 'Remote Control Toys', 'remote-control-toys-69aec4600619f', 0),
(336, 91, 'Motor Skills', 'motor-skills-69aec460071bf', 0),
(337, 91, 'Cognitive Skills', 'cognitive-skills-69aec46007757', 0),
(338, 91, 'STEM Learning', 'stem-learning-69aec460094c2', 0),
(339, 91, 'Creative Play', 'creative-play-69aec46009b70', 0),
(820, 188, '500mg', '500mg-69de2ba71267b', 0),
(821, 188, '200mg', '200mg-69de2ba71285d', 0),
(822, 188, '400mg', '400mg-69de2ba7129f5', 0),
(823, 189, '200ml', '200ml-69de2ba712f38', 0),
(824, 189, '400ml', '400ml-69de2ba7130cf', 0),
(825, 189, '500ml', '500ml-69de2ba71326d', 0),
(826, 190, 'Pack of 4', 'pack-of-4-69de2ba71378f', 0),
(827, 190, 'Pack of 3', 'pack-of-3-69de2ba71397c', 0),
(828, 190, 'Pack of 2', 'pack-of-2-69de2ba713b30', 0),
(966, 215, 'Party', 'party-6a01b0e48b45a', 0),
(967, 215, 'Formal', 'formal-6a01b0e48b67b', 0),
(968, 215, 'Business Casual', 'business-casual-6a01b0e48b94c', 0),
(969, 215, 'Semi Casual', 'semi-casual-6a01b0e48bb62', 0),
(970, 215, 'Ethinic', 'ethinic-6a01b0e48bcfc', 0),
(971, 216, 'Boys', 'boys-6a01b0e48c24b', 0),
(972, 216, 'Girls', 'girls-6a01b0e48c3ea', 0),
(973, 216, 'Unisex', 'unisex-6a01b0e48c55f', 0),
(974, 217, 'Red', 'red-6a01b0e48cadd', 0),
(975, 217, 'White', 'white-6a01b0e48ccea', 0),
(976, 217, 'Blue', 'blue-6a01b0e48ce83', 0),
(977, 217, 'Black', 'black-6a01b0e48d01a', 0),
(978, 217, 'Green', 'green-6a01b0e48d17b', 0),
(979, 217, 'Pink', 'pink-6a01b0e48d2ed', 0),
(980, 217, 'Yellow', 'yellow-6a01b0e48d461', 0),
(981, 217, 'Orange', 'orange-6a01b0e48d641', 0),
(982, 218, '0-3M', '0-3m-6a01b0e48db8d', 0),
(983, 218, '4-6M', '4-6m-6a01b0e48dd4c', 0),
(984, 218, '7-12M', '7-12m-6a01b0e48defe', 0),
(985, 218, '1-2Y', '1-2y-6a01b0e48e077', 0),
(986, 218, '3-5Y', '3-5y-6a01b0e48e221', 0),
(987, 218, '6-12Y', '6-12y-6a01b0e48e3b5', 0),
(988, 218, 'XS', 'xs-6a01b0e48e521', 0),
(989, 218, 'S', 's-6a01b0e48e6e3', 0),
(990, 218, 'M', 'm-6a01b0e48e86e', 0),
(991, 218, 'L', 'l-6a01b0e48e9f3', 0),
(992, 218, 'XL', 'xl-6a01b0e48eba4', 0),
(993, 218, 'XXL', 'xxl-6a01b0e48ed17', 0),
(994, 219, 'Free shipping', 'free-shipping-6a01b0e48f1fe', 0),
(995, 219, 'Paid shipping', 'paid-shipping-6a01b0e48f37a', 0),
(996, 219, 'COD', 'cod-6a01b0e48f4de', 0),
(997, 220, '350g', '350g-6a0201db8f410', 0),
(998, 220, '250g', '250g-6a0201db8f6f1', 0),
(999, 220, '500g', '500g-6a0201db8f937', 0),
(1000, 220, 'Stage1', 'stage1-6a0201db8fb8c', 0),
(1001, 220, 'Stage2', 'stage2-6a0201db8fded', 0),
(1002, 220, 'Stage3', 'stage3-6a0201db90000', 0),
(1003, 220, 'Stage4', 'stage4-6a0201db9025e', 0),
(1019, 224, '6 - 128 GB', '6-128-gb-6a2ff26bd4e9f', 0),
(1020, 224, '8 - 128 GB', '8-128-gb-6a2ff26bd59aa', 0),
(1021, 224, '8 - 256 GB', '8-256-gb-6a2ff26bd5d10', 0),
(1022, 224, '12 - 256 GB', '12-256-gb-6a2ff26bd6050', 0),
(1023, 224, '12 - 512 GB', '12-512-gb-6a2ff26bd638f', 0);

-- --------------------------------------------------------

--
-- Table structure for table `brands`
--

CREATE TABLE `brands` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `brands`
--

INSERT INTO `brands` (`id`, `name`, `slug`, `logo`, `description`, `is_active`, `created_at`, `updated_at`) VALUES
(8, 'Lawda', 'lawda', 'brands/8YV3iXKGsuKzu41VUpAx8FrlOGQYIaNNHGU4OXAL.png', 'wfiwrfkjwenfknwekfnierfniornfjkfnkjfnknk', 1, '2025-10-23 02:02:21', '2026-06-18 12:36:13'),
(9, 'LG', 'lg', NULL, 'Lg Logo', 1, '2026-06-15 12:28:00', '2026-06-15 12:28:00'),
(10, 'Blue Start', 'blue-start', NULL, NULL, 1, '2026-06-15 12:28:14', '2026-06-15 12:28:14'),
(11, 'Panasonic', 'panasonic', NULL, NULL, 1, '2026-06-15 12:28:34', '2026-06-15 12:28:34'),
(12, 'Samsung', 'samsung', NULL, NULL, 1, '2026-06-15 12:28:52', '2026-06-15 12:28:52'),
(13, 'Sony', 'sony', NULL, NULL, 1, '2026-06-15 12:29:01', '2026-06-15 12:29:01');

-- --------------------------------------------------------

--
-- Table structure for table `brand_master_category_mappings`
--

CREATE TABLE `brand_master_category_mappings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `brand_id` bigint(20) UNSIGNED NOT NULL,
  `master_category_id` bigint(20) UNSIGNED NOT NULL,
  `priority` int(10) UNSIGNED NOT NULL DEFAULT 100,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `brand_master_category_mappings`
--

INSERT INTO `brand_master_category_mappings` (`id`, `brand_id`, `master_category_id`, `priority`, `created_at`, `updated_at`) VALUES
(1, 8, 1, 100, '2026-06-18 12:05:39', '2026-06-18 12:05:39'),
(2, 8, 2, 100, '2026-06-18 12:05:39', '2026-06-18 12:05:39');

-- --------------------------------------------------------

--
-- Table structure for table `brand_navigation_categories`
--

CREATE TABLE `brand_navigation_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `brand_id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `brand_navigation_categories`
--

INSERT INTO `brand_navigation_categories` (`id`, `brand_id`, `category_id`, `created_at`, `updated_at`) VALUES
(1, 8, 876, '2026-06-18 12:41:50', '2026-06-18 12:41:50');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('cuddlyduddly-cache-navigation.index', 'a:1088:{i:0;a:10:{s:26:\"master_category_section_id\";i:1;s:18:\"master_category_id\";i:1;s:20:\"master_category_name\";s:11:\"BOY FASHION\";s:20:\"master_category_slug\";s:11:\"boy-fashion\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:1;s:13:\"category_name\";s:12:\"Sets & Suits\";s:13:\"category_slug\";s:10:\"sets-suits\";}i:1;a:10:{s:26:\"master_category_section_id\";i:2;s:18:\"master_category_id\";i:1;s:20:\"master_category_name\";s:11:\"BOY FASHION\";s:20:\"master_category_slug\";s:11:\"boy-fashion\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:2;s:13:\"category_name\";s:8:\"T-shirts\";s:13:\"category_slug\";s:8:\"t-shirts\";}i:2;a:10:{s:26:\"master_category_section_id\";i:3;s:18:\"master_category_id\";i:1;s:20:\"master_category_name\";s:11:\"BOY FASHION\";s:20:\"master_category_slug\";s:11:\"boy-fashion\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:3;s:13:\"category_name\";s:6:\"Shirts\";s:13:\"category_slug\";s:6:\"shirts\";}i:3;a:10:{s:26:\"master_category_section_id\";i:4;s:18:\"master_category_id\";i:1;s:20:\"master_category_name\";s:11:\"BOY FASHION\";s:20:\"master_category_slug\";s:11:\"boy-fashion\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:4;s:13:\"category_name\";s:6:\"Shorts\";s:13:\"category_slug\";s:6:\"shorts\";}i:4;a:10:{s:26:\"master_category_section_id\";i:5;s:18:\"master_category_id\";i:1;s:20:\"master_category_name\";s:11:\"BOY FASHION\";s:20:\"master_category_slug\";s:11:\"boy-fashion\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:5;s:13:\"category_name\";s:16:\"Jeans & Trousers\";s:13:\"category_slug\";s:14:\"jeans-trousers\";}i:5;a:10:{s:26:\"master_category_section_id\";i:6;s:18:\"master_category_id\";i:1;s:20:\"master_category_name\";s:11:\"BOY FASHION\";s:20:\"master_category_slug\";s:11:\"boy-fashion\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:6;s:13:\"category_name\";s:17:\"Night Shorts Sets\";s:13:\"category_slug\";s:17:\"night-shorts-sets\";}i:6;a:10:{s:26:\"master_category_section_id\";i:7;s:18:\"master_category_id\";i:1;s:20:\"master_category_name\";s:11:\"BOY FASHION\";s:20:\"master_category_slug\";s:11:\"boy-fashion\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:7;s:13:\"category_name\";s:9:\"Nightwear\";s:13:\"category_slug\";s:9:\"nightwear\";}i:7;a:10:{s:26:\"master_category_section_id\";i:8;s:18:\"master_category_id\";i:1;s:20:\"master_category_name\";s:11:\"BOY FASHION\";s:20:\"master_category_slug\";s:11:\"boy-fashion\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:8;s:13:\"category_name\";s:19:\"Lounge & Trackpants\";s:13:\"category_slug\";s:17:\"lounge-trackpants\";}i:8;a:10:{s:26:\"master_category_section_id\";i:9;s:18:\"master_category_id\";i:1;s:20:\"master_category_name\";s:11:\"BOY FASHION\";s:20:\"master_category_slug\";s:11:\"boy-fashion\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:9;s:13:\"category_name\";s:17:\"Onesies & Rompers\";s:13:\"category_slug\";s:15:\"onesies-rompers\";}i:9;a:10:{s:26:\"master_category_section_id\";i:10;s:18:\"master_category_id\";i:1;s:20:\"master_category_name\";s:11:\"BOY FASHION\";s:20:\"master_category_slug\";s:11:\"boy-fashion\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:10;s:13:\"category_name\";s:24:\"Diaper & Bootie Leggings\";s:13:\"category_slug\";s:22:\"diaper-bootie-leggings\";}i:10;a:10:{s:26:\"master_category_section_id\";i:11;s:18:\"master_category_id\";i:1;s:20:\"master_category_name\";s:11:\"BOY FASHION\";s:20:\"master_category_slug\";s:11:\"boy-fashion\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:11;s:13:\"category_name\";s:8:\"Rainwear\";s:13:\"category_slug\";s:8:\"rainwear\";}i:11;a:10:{s:26:\"master_category_section_id\";i:12;s:18:\"master_category_id\";i:1;s:20:\"master_category_name\";s:11:\"BOY FASHION\";s:20:\"master_category_slug\";s:11:\"boy-fashion\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:12;s:13:\"category_name\";s:10:\"Party Wear\";s:13:\"category_slug\";s:10:\"party-wear\";}i:12;a:10:{s:26:\"master_category_section_id\";i:13;s:18:\"master_category_id\";i:1;s:20:\"master_category_name\";s:11:\"BOY FASHION\";s:20:\"master_category_slug\";s:11:\"boy-fashion\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:13;s:13:\"category_name\";s:11:\"Ethnic Wear\";s:13:\"category_slug\";s:11:\"ethnic-wear\";}i:13;a:10:{s:26:\"master_category_section_id\";i:14;s:18:\"master_category_id\";i:1;s:20:\"master_category_name\";s:11:\"BOY FASHION\";s:20:\"master_category_slug\";s:11:\"boy-fashion\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:14;s:13:\"category_name\";s:9:\"Swim Wear\";s:13:\"category_slug\";s:9:\"swim-wear\";}i:14;a:10:{s:26:\"master_category_section_id\";i:15;s:18:\"master_category_id\";i:1;s:20:\"master_category_name\";s:11:\"BOY FASHION\";s:20:\"master_category_slug\";s:11:\"boy-fashion\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:15;s:13:\"category_name\";s:23:\"Athleisure & Sportswear\";s:13:\"category_slug\";s:21:\"athleisure-sportswear\";}i:15;a:10:{s:26:\"master_category_section_id\";i:16;s:18:\"master_category_id\";i:1;s:20:\"master_category_name\";s:11:\"BOY FASHION\";s:20:\"master_category_slug\";s:11:\"boy-fashion\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:16;s:13:\"category_name\";s:5:\"Vests\";s:13:\"category_slug\";s:5:\"vests\";}i:16;a:10:{s:26:\"master_category_section_id\";i:17;s:18:\"master_category_id\";i:1;s:20:\"master_category_name\";s:11:\"BOY FASHION\";s:20:\"master_category_slug\";s:11:\"boy-fashion\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:17;s:13:\"category_name\";s:15:\"Briefs & Boxers\";s:13:\"category_slug\";s:13:\"briefs-boxers\";}i:17;a:10:{s:26:\"master_category_section_id\";i:18;s:18:\"master_category_id\";i:1;s:20:\"master_category_name\";s:11:\"BOY FASHION\";s:20:\"master_category_slug\";s:11:\"boy-fashion\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:18;s:13:\"category_name\";s:10:\"Inner Wear\";s:13:\"category_slug\";s:10:\"inner-wear\";}i:18;a:10:{s:26:\"master_category_section_id\";i:19;s:18:\"master_category_id\";i:1;s:20:\"master_category_name\";s:11:\"BOY FASHION\";s:20:\"master_category_slug\";s:11:\"boy-fashion\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:19;s:13:\"category_name\";s:11:\"Summer Caps\";s:13:\"category_slug\";s:11:\"summer-caps\";}i:19;a:10:{s:26:\"master_category_section_id\";i:20;s:18:\"master_category_id\";i:1;s:20:\"master_category_name\";s:11:\"BOY FASHION\";s:20:\"master_category_slug\";s:11:\"boy-fashion\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:20;s:13:\"category_name\";s:9:\"Bath Time\";s:13:\"category_slug\";s:9:\"bath-time\";}i:20;a:10:{s:26:\"master_category_section_id\";i:21;s:18:\"master_category_id\";i:1;s:20:\"master_category_name\";s:11:\"BOY FASHION\";s:20:\"master_category_slug\";s:11:\"boy-fashion\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:21;s:13:\"category_name\";s:5:\"Socks\";s:13:\"category_slug\";s:5:\"socks\";}i:21;a:10:{s:26:\"master_category_section_id\";i:22;s:18:\"master_category_id\";i:1;s:20:\"master_category_name\";s:11:\"BOY FASHION\";s:20:\"master_category_slug\";s:11:\"boy-fashion\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:22;s:13:\"category_name\";s:23:\"Caps, Mittens & Booties\";s:13:\"category_slug\";s:20:\"caps-mittens-booties\";}i:22;a:10:{s:26:\"master_category_section_id\";i:23;s:18:\"master_category_id\";i:1;s:20:\"master_category_name\";s:11:\"BOY FASHION\";s:20:\"master_category_slug\";s:11:\"boy-fashion\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:23;s:13:\"category_name\";s:8:\"Thermals\";s:13:\"category_slug\";s:8:\"thermals\";}i:23;a:10:{s:26:\"master_category_section_id\";i:24;s:18:\"master_category_id\";i:1;s:20:\"master_category_name\";s:11:\"BOY FASHION\";s:20:\"master_category_slug\";s:11:\"boy-fashion\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:24;s:13:\"category_name\";s:11:\"Sweatshirts\";s:13:\"category_slug\";s:11:\"sweatshirts\";}i:24;a:10:{s:26:\"master_category_section_id\";i:25;s:18:\"master_category_id\";i:1;s:20:\"master_category_name\";s:11:\"BOY FASHION\";s:20:\"master_category_slug\";s:11:\"boy-fashion\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:25;s:13:\"category_name\";s:7:\"Jackets\";s:13:\"category_slug\";s:7:\"jackets\";}i:25;a:10:{s:26:\"master_category_section_id\";i:26;s:18:\"master_category_id\";i:1;s:20:\"master_category_name\";s:11:\"BOY FASHION\";s:20:\"master_category_slug\";s:11:\"boy-fashion\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:26;s:13:\"category_name\";s:8:\"Sweaters\";s:13:\"category_slug\";s:8:\"sweaters\";}i:26;a:10:{s:26:\"master_category_section_id\";i:27;s:18:\"master_category_id\";i:1;s:20:\"master_category_name\";s:11:\"BOY FASHION\";s:20:\"master_category_slug\";s:11:\"boy-fashion\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:27;s:13:\"category_name\";s:11:\"Winter Sets\";s:13:\"category_slug\";s:11:\"winter-sets\";}i:27;a:10:{s:26:\"master_category_section_id\";i:28;s:18:\"master_category_id\";i:1;s:20:\"master_category_name\";s:11:\"BOY FASHION\";s:20:\"master_category_slug\";s:11:\"boy-fashion\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:28;s:13:\"category_name\";s:14:\"Fleece Bottoms\";s:13:\"category_slug\";s:14:\"fleece-bottoms\";}i:28;a:10:{s:26:\"master_category_section_id\";i:29;s:18:\"master_category_id\";i:1;s:20:\"master_category_name\";s:11:\"BOY FASHION\";s:20:\"master_category_slug\";s:11:\"boy-fashion\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:29;s:13:\"category_name\";s:23:\"Woolen Caps & Ear Muffs\";s:13:\"category_slug\";s:21:\"woolen-caps-ear-muffs\";}i:29;a:10:{s:26:\"master_category_section_id\";i:30;s:18:\"master_category_id\";i:1;s:20:\"master_category_name\";s:11:\"BOY FASHION\";s:20:\"master_category_slug\";s:11:\"boy-fashion\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:30;s:13:\"category_name\";s:16:\"Winter Nightwear\";s:13:\"category_slug\";s:16:\"winter-nightwear\";}i:30;a:10:{s:26:\"master_category_section_id\";i:31;s:18:\"master_category_id\";i:1;s:20:\"master_category_name\";s:11:\"BOY FASHION\";s:20:\"master_category_slug\";s:11:\"boy-fashion\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:31;s:13:\"category_name\";s:6:\"Gloves\";s:13:\"category_slug\";s:6:\"gloves\";}i:31;a:10:{s:26:\"master_category_section_id\";i:32;s:18:\"master_category_id\";i:1;s:20:\"master_category_name\";s:11:\"BOY FASHION\";s:20:\"master_category_slug\";s:11:\"boy-fashion\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:32;s:13:\"category_name\";s:14:\"Theme Costumes\";s:13:\"category_slug\";s:14:\"theme-costumes\";}i:32;a:10:{s:26:\"master_category_section_id\";i:33;s:18:\"master_category_id\";i:1;s:20:\"master_category_name\";s:11:\"BOY FASHION\";s:20:\"master_category_slug\";s:11:\"boy-fashion\";s:15:\"section_type_id\";i:2;s:17:\"section_type_name\";s:18:\"SHOP BY COLLECTION\";s:17:\"section_type_slug\";s:18:\"shop-by-collection\";s:11:\"category_id\";i:33;s:13:\"category_name\";s:16:\"Splash in Summer\";s:13:\"category_slug\";s:16:\"splash-in-summer\";}i:33;a:10:{s:26:\"master_category_section_id\";i:34;s:18:\"master_category_id\";i:1;s:20:\"master_category_name\";s:11:\"BOY FASHION\";s:20:\"master_category_slug\";s:11:\"boy-fashion\";s:15:\"section_type_id\";i:2;s:17:\"section_type_name\";s:18:\"SHOP BY COLLECTION\";s:17:\"section_type_slug\";s:18:\"shop-by-collection\";s:11:\"category_id\";i:34;s:13:\"category_name\";s:11:\"Bestsellers\";s:13:\"category_slug\";s:11:\"bestsellers\";}i:34;a:10:{s:26:\"master_category_section_id\";i:35;s:18:\"master_category_id\";i:1;s:20:\"master_category_name\";s:11:\"BOY FASHION\";s:20:\"master_category_slug\";s:11:\"boy-fashion\";s:15:\"section_type_id\";i:2;s:17:\"section_type_name\";s:18:\"SHOP BY COLLECTION\";s:17:\"section_type_slug\";s:18:\"shop-by-collection\";s:11:\"category_id\";i:35;s:13:\"category_name\";s:11:\"Multi-packs\";s:13:\"category_slug\";s:11:\"multi-packs\";}i:35;a:10:{s:26:\"master_category_section_id\";i:36;s:18:\"master_category_id\";i:1;s:20:\"master_category_name\";s:11:\"BOY FASHION\";s:20:\"master_category_slug\";s:11:\"boy-fashion\";s:15:\"section_type_id\";i:2;s:17:\"section_type_name\";s:18:\"SHOP BY COLLECTION\";s:17:\"section_type_slug\";s:18:\"shop-by-collection\";s:11:\"category_id\";i:36;s:13:\"category_name\";s:15:\"Baby Essentials\";s:13:\"category_slug\";s:15:\"baby-essentials\";}i:36;a:10:{s:26:\"master_category_section_id\";i:37;s:18:\"master_category_id\";i:1;s:20:\"master_category_name\";s:11:\"BOY FASHION\";s:20:\"master_category_slug\";s:11:\"boy-fashion\";s:15:\"section_type_id\";i:3;s:17:\"section_type_name\";s:11:\"SHOP BY AGE\";s:17:\"section_type_slug\";s:11:\"shop-by-age\";s:11:\"category_id\";i:37;s:13:\"category_name\";s:20:\"Preemie/Tine Preemie\";s:13:\"category_slug\";s:19:\"preemietine-preemie\";}i:37;a:10:{s:26:\"master_category_section_id\";i:38;s:18:\"master_category_id\";i:1;s:20:\"master_category_name\";s:11:\"BOY FASHION\";s:20:\"master_category_slug\";s:11:\"boy-fashion\";s:15:\"section_type_id\";i:3;s:17:\"section_type_name\";s:11:\"SHOP BY AGE\";s:17:\"section_type_slug\";s:11:\"shop-by-age\";s:11:\"category_id\";i:38;s:13:\"category_name\";s:16:\"New Born (0-3 M)\";s:13:\"category_slug\";s:14:\"new-born-0-3-m\";}i:38;a:10:{s:26:\"master_category_section_id\";i:39;s:18:\"master_category_id\";i:1;s:20:\"master_category_name\";s:11:\"BOY FASHION\";s:20:\"master_category_slug\";s:11:\"boy-fashion\";s:15:\"section_type_id\";i:3;s:17:\"section_type_name\";s:11:\"SHOP BY AGE\";s:17:\"section_type_slug\";s:11:\"shop-by-age\";s:11:\"category_id\";i:39;s:13:\"category_name\";s:10:\"3-6 Months\";s:13:\"category_slug\";s:10:\"3-6-months\";}i:39;a:10:{s:26:\"master_category_section_id\";i:40;s:18:\"master_category_id\";i:1;s:20:\"master_category_name\";s:11:\"BOY FASHION\";s:20:\"master_category_slug\";s:11:\"boy-fashion\";s:15:\"section_type_id\";i:3;s:17:\"section_type_name\";s:11:\"SHOP BY AGE\";s:17:\"section_type_slug\";s:11:\"shop-by-age\";s:11:\"category_id\";i:40;s:13:\"category_name\";s:10:\"6-9 Months\";s:13:\"category_slug\";s:10:\"6-9-months\";}i:40;a:10:{s:26:\"master_category_section_id\";i:41;s:18:\"master_category_id\";i:1;s:20:\"master_category_name\";s:11:\"BOY FASHION\";s:20:\"master_category_slug\";s:11:\"boy-fashion\";s:15:\"section_type_id\";i:3;s:17:\"section_type_name\";s:11:\"SHOP BY AGE\";s:17:\"section_type_slug\";s:11:\"shop-by-age\";s:11:\"category_id\";i:41;s:13:\"category_name\";s:11:\"9-12 Months\";s:13:\"category_slug\";s:11:\"9-12-months\";}i:41;a:10:{s:26:\"master_category_section_id\";i:42;s:18:\"master_category_id\";i:1;s:20:\"master_category_name\";s:11:\"BOY FASHION\";s:20:\"master_category_slug\";s:11:\"boy-fashion\";s:15:\"section_type_id\";i:3;s:17:\"section_type_name\";s:11:\"SHOP BY AGE\";s:17:\"section_type_slug\";s:11:\"shop-by-age\";s:11:\"category_id\";i:42;s:13:\"category_name\";s:12:\"12-18 Months\";s:13:\"category_slug\";s:12:\"12-18-months\";}i:42;a:10:{s:26:\"master_category_section_id\";i:43;s:18:\"master_category_id\";i:1;s:20:\"master_category_name\";s:11:\"BOY FASHION\";s:20:\"master_category_slug\";s:11:\"boy-fashion\";s:15:\"section_type_id\";i:3;s:17:\"section_type_name\";s:11:\"SHOP BY AGE\";s:17:\"section_type_slug\";s:11:\"shop-by-age\";s:11:\"category_id\";i:43;s:13:\"category_name\";s:12:\"18-24 Months\";s:13:\"category_slug\";s:12:\"18-24-months\";}i:43;a:10:{s:26:\"master_category_section_id\";i:44;s:18:\"master_category_id\";i:1;s:20:\"master_category_name\";s:11:\"BOY FASHION\";s:20:\"master_category_slug\";s:11:\"boy-fashion\";s:15:\"section_type_id\";i:3;s:17:\"section_type_name\";s:11:\"SHOP BY AGE\";s:17:\"section_type_slug\";s:11:\"shop-by-age\";s:11:\"category_id\";i:44;s:13:\"category_name\";s:12:\"2 to 4 Years\";s:13:\"category_slug\";s:12:\"2-to-4-years\";}i:44;a:10:{s:26:\"master_category_section_id\";i:45;s:18:\"master_category_id\";i:1;s:20:\"master_category_name\";s:11:\"BOY FASHION\";s:20:\"master_category_slug\";s:11:\"boy-fashion\";s:15:\"section_type_id\";i:3;s:17:\"section_type_name\";s:11:\"SHOP BY AGE\";s:17:\"section_type_slug\";s:11:\"shop-by-age\";s:11:\"category_id\";i:45;s:13:\"category_name\";s:12:\"4 to 6 Years\";s:13:\"category_slug\";s:12:\"4-to-6-years\";}i:45;a:10:{s:26:\"master_category_section_id\";i:46;s:18:\"master_category_id\";i:1;s:20:\"master_category_name\";s:11:\"BOY FASHION\";s:20:\"master_category_slug\";s:11:\"boy-fashion\";s:15:\"section_type_id\";i:3;s:17:\"section_type_name\";s:11:\"SHOP BY AGE\";s:17:\"section_type_slug\";s:11:\"shop-by-age\";s:11:\"category_id\";i:46;s:13:\"category_name\";s:12:\"6 to 8 Years\";s:13:\"category_slug\";s:12:\"6-to-8-years\";}i:46;a:10:{s:26:\"master_category_section_id\";i:47;s:18:\"master_category_id\";i:1;s:20:\"master_category_name\";s:11:\"BOY FASHION\";s:20:\"master_category_slug\";s:11:\"boy-fashion\";s:15:\"section_type_id\";i:3;s:17:\"section_type_name\";s:11:\"SHOP BY AGE\";s:17:\"section_type_slug\";s:11:\"shop-by-age\";s:11:\"category_id\";i:47;s:13:\"category_name\";s:8:\"8+ Years\";s:13:\"category_slug\";s:7:\"8-years\";}i:47;a:10:{s:26:\"master_category_section_id\";i:48;s:18:\"master_category_id\";i:1;s:20:\"master_category_name\";s:11:\"BOY FASHION\";s:20:\"master_category_slug\";s:11:\"boy-fashion\";s:15:\"section_type_id\";i:4;s:17:\"section_type_name\";s:19:\"FASHION ACCESSORIES\";s:17:\"section_type_slug\";s:19:\"fashion-accessories\";s:11:\"category_id\";i:48;s:13:\"category_name\";s:10:\"Sunglasses\";s:13:\"category_slug\";s:10:\"sunglasses\";}i:48;a:10:{s:26:\"master_category_section_id\";i:49;s:18:\"master_category_id\";i:1;s:20:\"master_category_name\";s:11:\"BOY FASHION\";s:20:\"master_category_slug\";s:11:\"boy-fashion\";s:15:\"section_type_id\";i:4;s:17:\"section_type_name\";s:19:\"FASHION ACCESSORIES\";s:17:\"section_type_slug\";s:19:\"fashion-accessories\";s:11:\"category_id\";i:19;s:13:\"category_name\";s:11:\"Summer Caps\";s:13:\"category_slug\";s:11:\"summer-caps\";}i:49;a:10:{s:26:\"master_category_section_id\";i:50;s:18:\"master_category_id\";i:1;s:20:\"master_category_name\";s:11:\"BOY FASHION\";s:20:\"master_category_slug\";s:11:\"boy-fashion\";s:15:\"section_type_id\";i:4;s:17:\"section_type_name\";s:19:\"FASHION ACCESSORIES\";s:17:\"section_type_slug\";s:19:\"fashion-accessories\";s:11:\"category_id\";i:49;s:13:\"category_name\";s:14:\"Kids Umbrellas\";s:13:\"category_slug\";s:14:\"kids-umbrellas\";}i:50;a:10:{s:26:\"master_category_section_id\";i:51;s:18:\"master_category_id\";i:1;s:20:\"master_category_name\";s:11:\"BOY FASHION\";s:20:\"master_category_slug\";s:11:\"boy-fashion\";s:15:\"section_type_id\";i:4;s:17:\"section_type_name\";s:19:\"FASHION ACCESSORIES\";s:17:\"section_type_slug\";s:19:\"fashion-accessories\";s:11:\"category_id\";i:50;s:13:\"category_name\";s:7:\"Watches\";s:13:\"category_slug\";s:7:\"watches\";}i:51;a:10:{s:26:\"master_category_section_id\";i:52;s:18:\"master_category_id\";i:1;s:20:\"master_category_name\";s:11:\"BOY FASHION\";s:20:\"master_category_slug\";s:11:\"boy-fashion\";s:15:\"section_type_id\";i:4;s:17:\"section_type_name\";s:19:\"FASHION ACCESSORIES\";s:17:\"section_type_slug\";s:19:\"fashion-accessories\";s:11:\"category_id\";i:51;s:13:\"category_name\";s:24:\"Ties, Belts & Suspenders\";s:13:\"category_slug\";s:21:\"ties-belts-suspenders\";}i:52;a:10:{s:26:\"master_category_section_id\";i:53;s:18:\"master_category_id\";i:1;s:20:\"master_category_name\";s:11:\"BOY FASHION\";s:20:\"master_category_slug\";s:11:\"boy-fashion\";s:15:\"section_type_id\";i:4;s:17:\"section_type_name\";s:19:\"FASHION ACCESSORIES\";s:17:\"section_type_slug\";s:19:\"fashion-accessories\";s:11:\"category_id\";i:52;s:13:\"category_name\";s:4:\"Bags\";s:13:\"category_slug\";s:4:\"bags\";}i:53;a:10:{s:26:\"master_category_section_id\";i:54;s:18:\"master_category_id\";i:1;s:20:\"master_category_name\";s:11:\"BOY FASHION\";s:20:\"master_category_slug\";s:11:\"boy-fashion\";s:15:\"section_type_id\";i:4;s:17:\"section_type_name\";s:19:\"FASHION ACCESSORIES\";s:17:\"section_type_slug\";s:19:\"fashion-accessories\";s:11:\"category_id\";i:53;s:13:\"category_name\";s:13:\"Smart Watches\";s:13:\"category_slug\";s:13:\"smart-watches\";}i:54;a:10:{s:26:\"master_category_section_id\";i:55;s:18:\"master_category_id\";i:1;s:20:\"master_category_name\";s:11:\"BOY FASHION\";s:20:\"master_category_slug\";s:11:\"boy-fashion\";s:15:\"section_type_id\";i:4;s:17:\"section_type_name\";s:19:\"FASHION ACCESSORIES\";s:17:\"section_type_slug\";s:19:\"fashion-accessories\";s:11:\"category_id\";i:29;s:13:\"category_name\";s:23:\"Woolen Caps & Ear Muffs\";s:13:\"category_slug\";s:21:\"woolen-caps-ear-muffs\";}i:55;a:10:{s:26:\"master_category_section_id\";i:56;s:18:\"master_category_id\";i:1;s:20:\"master_category_name\";s:11:\"BOY FASHION\";s:20:\"master_category_slug\";s:11:\"boy-fashion\";s:15:\"section_type_id\";i:4;s:17:\"section_type_name\";s:19:\"FASHION ACCESSORIES\";s:17:\"section_type_slug\";s:19:\"fashion-accessories\";s:11:\"category_id\";i:22;s:13:\"category_name\";s:23:\"Caps, Mittens & Booties\";s:13:\"category_slug\";s:20:\"caps-mittens-booties\";}i:56;a:10:{s:26:\"master_category_section_id\";i:57;s:18:\"master_category_id\";i:1;s:20:\"master_category_name\";s:11:\"BOY FASHION\";s:20:\"master_category_slug\";s:11:\"boy-fashion\";s:15:\"section_type_id\";i:4;s:17:\"section_type_name\";s:19:\"FASHION ACCESSORIES\";s:17:\"section_type_slug\";s:19:\"fashion-accessories\";s:11:\"category_id\";i:31;s:13:\"category_name\";s:6:\"Gloves\";s:13:\"category_slug\";s:6:\"gloves\";}i:57;a:10:{s:26:\"master_category_section_id\";i:58;s:18:\"master_category_id\";i:1;s:20:\"master_category_name\";s:11:\"BOY FASHION\";s:20:\"master_category_slug\";s:11:\"boy-fashion\";s:15:\"section_type_id\";i:5;s:17:\"section_type_name\";s:8:\"FOOTWEAR\";s:17:\"section_type_slug\";s:8:\"footwear\";s:11:\"category_id\";i:54;s:13:\"category_name\";s:10:\"Flip Flops\";s:13:\"category_slug\";s:10:\"flip-flops\";}i:58;a:10:{s:26:\"master_category_section_id\";i:59;s:18:\"master_category_id\";i:1;s:20:\"master_category_name\";s:11:\"BOY FASHION\";s:20:\"master_category_slug\";s:11:\"boy-fashion\";s:15:\"section_type_id\";i:5;s:17:\"section_type_name\";s:8:\"FOOTWEAR\";s:17:\"section_type_slug\";s:8:\"footwear\";s:11:\"category_id\";i:55;s:13:\"category_name\";s:5:\"Clogs\";s:13:\"category_slug\";s:5:\"clogs\";}i:59;a:10:{s:26:\"master_category_section_id\";i:60;s:18:\"master_category_id\";i:1;s:20:\"master_category_name\";s:11:\"BOY FASHION\";s:20:\"master_category_slug\";s:11:\"boy-fashion\";s:15:\"section_type_id\";i:5;s:17:\"section_type_name\";s:8:\"FOOTWEAR\";s:17:\"section_type_slug\";s:8:\"footwear\";s:11:\"category_id\";i:56;s:13:\"category_name\";s:7:\"Sandals\";s:13:\"category_slug\";s:7:\"sandals\";}i:60;a:10:{s:26:\"master_category_section_id\";i:61;s:18:\"master_category_id\";i:1;s:20:\"master_category_name\";s:11:\"BOY FASHION\";s:20:\"master_category_slug\";s:11:\"boy-fashion\";s:15:\"section_type_id\";i:5;s:17:\"section_type_name\";s:8:\"FOOTWEAR\";s:17:\"section_type_slug\";s:8:\"footwear\";s:11:\"category_id\";i:57;s:13:\"category_name\";s:10:\"Pool Shoes\";s:13:\"category_slug\";s:10:\"pool-shoes\";}i:61;a:10:{s:26:\"master_category_section_id\";i:62;s:18:\"master_category_id\";i:1;s:20:\"master_category_name\";s:11:\"BOY FASHION\";s:20:\"master_category_slug\";s:11:\"boy-fashion\";s:15:\"section_type_id\";i:5;s:17:\"section_type_name\";s:8:\"FOOTWEAR\";s:17:\"section_type_slug\";s:8:\"footwear\";s:11:\"category_id\";i:58;s:13:\"category_name\";s:12:\"Casual Shoes\";s:13:\"category_slug\";s:12:\"casual-shoes\";}i:62;a:10:{s:26:\"master_category_section_id\";i:63;s:18:\"master_category_id\";i:1;s:20:\"master_category_name\";s:11:\"BOY FASHION\";s:20:\"master_category_slug\";s:11:\"boy-fashion\";s:15:\"section_type_id\";i:5;s:17:\"section_type_name\";s:8:\"FOOTWEAR\";s:17:\"section_type_slug\";s:8:\"footwear\";s:11:\"category_id\";i:59;s:13:\"category_name\";s:12:\"Sports Shoes\";s:13:\"category_slug\";s:12:\"sports-shoes\";}i:63;a:10:{s:26:\"master_category_section_id\";i:64;s:18:\"master_category_id\";i:1;s:20:\"master_category_name\";s:11:\"BOY FASHION\";s:20:\"master_category_slug\";s:11:\"boy-fashion\";s:15:\"section_type_id\";i:5;s:17:\"section_type_name\";s:8:\"FOOTWEAR\";s:17:\"section_type_slug\";s:8:\"footwear\";s:11:\"category_id\";i:60;s:13:\"category_name\";s:8:\"Sneakers\";s:13:\"category_slug\";s:8:\"sneakers\";}i:64;a:10:{s:26:\"master_category_section_id\";i:65;s:18:\"master_category_id\";i:1;s:20:\"master_category_name\";s:11:\"BOY FASHION\";s:20:\"master_category_slug\";s:11:\"boy-fashion\";s:15:\"section_type_id\";i:5;s:17:\"section_type_name\";s:8:\"FOOTWEAR\";s:17:\"section_type_slug\";s:8:\"footwear\";s:11:\"category_id\";i:61;s:13:\"category_name\";s:18:\"Formal & Partywear\";s:13:\"category_slug\";s:16:\"formal-partywear\";}i:65;a:10:{s:26:\"master_category_section_id\";i:66;s:18:\"master_category_id\";i:1;s:20:\"master_category_name\";s:11:\"BOY FASHION\";s:20:\"master_category_slug\";s:11:\"boy-fashion\";s:15:\"section_type_id\";i:5;s:17:\"section_type_name\";s:8:\"FOOTWEAR\";s:17:\"section_type_slug\";s:8:\"footwear\";s:11:\"category_id\";i:62;s:13:\"category_name\";s:12:\"Winter Boots\";s:13:\"category_slug\";s:12:\"winter-boots\";}i:66;a:10:{s:26:\"master_category_section_id\";i:67;s:18:\"master_category_id\";i:1;s:20:\"master_category_name\";s:11:\"BOY FASHION\";s:20:\"master_category_slug\";s:11:\"boy-fashion\";s:15:\"section_type_id\";i:5;s:17:\"section_type_name\";s:8:\"FOOTWEAR\";s:17:\"section_type_slug\";s:8:\"footwear\";s:11:\"category_id\";i:63;s:13:\"category_name\";s:7:\"Booties\";s:13:\"category_slug\";s:7:\"booties\";}i:67;a:10:{s:26:\"master_category_section_id\";i:68;s:18:\"master_category_id\";i:1;s:20:\"master_category_name\";s:11:\"BOY FASHION\";s:20:\"master_category_slug\";s:11:\"boy-fashion\";s:15:\"section_type_id\";i:5;s:17:\"section_type_name\";s:8:\"FOOTWEAR\";s:17:\"section_type_slug\";s:8:\"footwear\";s:11:\"category_id\";i:64;s:13:\"category_name\";s:12:\"School Shoes\";s:13:\"category_slug\";s:12:\"school-shoes\";}i:68;a:10:{s:26:\"master_category_section_id\";i:69;s:18:\"master_category_id\";i:1;s:20:\"master_category_name\";s:11:\"BOY FASHION\";s:20:\"master_category_slug\";s:11:\"boy-fashion\";s:15:\"section_type_id\";i:5;s:17:\"section_type_name\";s:8:\"FOOTWEAR\";s:17:\"section_type_slug\";s:8:\"footwear\";s:11:\"category_id\";i:65;s:13:\"category_name\";s:9:\"LED Shoes\";s:13:\"category_slug\";s:9:\"led-shoes\";}i:69;a:10:{s:26:\"master_category_section_id\";i:70;s:18:\"master_category_id\";i:1;s:20:\"master_category_name\";s:11:\"BOY FASHION\";s:20:\"master_category_slug\";s:11:\"boy-fashion\";s:15:\"section_type_id\";i:5;s:17:\"section_type_name\";s:8:\"FOOTWEAR\";s:17:\"section_type_slug\";s:8:\"footwear\";s:11:\"category_id\";i:66;s:13:\"category_name\";s:23:\"Mojaris/Ethnic Footwear\";s:13:\"category_slug\";s:22:\"mojarisethnic-footwear\";}i:70;a:10:{s:26:\"master_category_section_id\";i:71;s:18:\"master_category_id\";i:1;s:20:\"master_category_name\";s:11:\"BOY FASHION\";s:20:\"master_category_slug\";s:11:\"boy-fashion\";s:15:\"section_type_id\";i:6;s:17:\"section_type_name\";s:13:\"SHOP BY PRICE\";s:17:\"section_type_slug\";s:13:\"shop-by-price\";s:11:\"category_id\";i:67;s:13:\"category_name\";s:13:\"All Under 199\";s:13:\"category_slug\";s:13:\"all-under-199\";}i:71;a:10:{s:26:\"master_category_section_id\";i:72;s:18:\"master_category_id\";i:1;s:20:\"master_category_name\";s:11:\"BOY FASHION\";s:20:\"master_category_slug\";s:11:\"boy-fashion\";s:15:\"section_type_id\";i:6;s:17:\"section_type_name\";s:13:\"SHOP BY PRICE\";s:17:\"section_type_slug\";s:13:\"shop-by-price\";s:11:\"category_id\";i:68;s:13:\"category_name\";s:13:\"All Under 299\";s:13:\"category_slug\";s:13:\"all-under-299\";}i:72;a:10:{s:26:\"master_category_section_id\";i:73;s:18:\"master_category_id\";i:1;s:20:\"master_category_name\";s:11:\"BOY FASHION\";s:20:\"master_category_slug\";s:11:\"boy-fashion\";s:15:\"section_type_id\";i:6;s:17:\"section_type_name\";s:13:\"SHOP BY PRICE\";s:17:\"section_type_slug\";s:13:\"shop-by-price\";s:11:\"category_id\";i:69;s:13:\"category_name\";s:13:\"All Under 399\";s:13:\"category_slug\";s:13:\"all-under-399\";}i:73;a:10:{s:26:\"master_category_section_id\";i:74;s:18:\"master_category_id\";i:1;s:20:\"master_category_name\";s:11:\"BOY FASHION\";s:20:\"master_category_slug\";s:11:\"boy-fashion\";s:15:\"section_type_id\";i:6;s:17:\"section_type_name\";s:13:\"SHOP BY PRICE\";s:17:\"section_type_slug\";s:13:\"shop-by-price\";s:11:\"category_id\";i:70;s:13:\"category_name\";s:13:\"All Under 499\";s:13:\"category_slug\";s:13:\"all-under-499\";}i:74;a:10:{s:26:\"master_category_section_id\";i:75;s:18:\"master_category_id\";i:1;s:20:\"master_category_name\";s:11:\"BOY FASHION\";s:20:\"master_category_slug\";s:11:\"boy-fashion\";s:15:\"section_type_id\";i:7;s:17:\"section_type_name\";s:14:\"SHOP BY BRANDS\";s:17:\"section_type_slug\";s:14:\"shop-by-brands\";s:11:\"category_id\";i:71;s:13:\"category_name\";s:7:\"Babyhug\";s:13:\"category_slug\";s:7:\"babyhug\";}i:75;a:10:{s:26:\"master_category_section_id\";i:76;s:18:\"master_category_id\";i:1;s:20:\"master_category_name\";s:11:\"BOY FASHION\";s:20:\"master_category_slug\";s:11:\"boy-fashion\";s:15:\"section_type_id\";i:7;s:17:\"section_type_name\";s:14:\"SHOP BY BRANDS\";s:17:\"section_type_slug\";s:14:\"shop-by-brands\";s:11:\"category_id\";i:72;s:13:\"category_name\";s:7:\"Babyoye\";s:13:\"category_slug\";s:7:\"babyoye\";}i:76;a:10:{s:26:\"master_category_section_id\";i:77;s:18:\"master_category_id\";i:1;s:20:\"master_category_name\";s:11:\"BOY FASHION\";s:20:\"master_category_slug\";s:11:\"boy-fashion\";s:15:\"section_type_id\";i:7;s:17:\"section_type_name\";s:14:\"SHOP BY BRANDS\";s:17:\"section_type_slug\";s:14:\"shop-by-brands\";s:11:\"category_id\";i:73;s:13:\"category_name\";s:11:\"Kookie Kids\";s:13:\"category_slug\";s:11:\"kookie-kids\";}i:77;a:10:{s:26:\"master_category_section_id\";i:78;s:18:\"master_category_id\";i:1;s:20:\"master_category_name\";s:11:\"BOY FASHION\";s:20:\"master_category_slug\";s:11:\"boy-fashion\";s:15:\"section_type_id\";i:7;s:17:\"section_type_name\";s:14:\"SHOP BY BRANDS\";s:17:\"section_type_slug\";s:14:\"shop-by-brands\";s:11:\"category_id\";i:74;s:13:\"category_name\";s:8:\"Carter\'s\";s:13:\"category_slug\";s:7:\"carters\";}i:78;a:10:{s:26:\"master_category_section_id\";i:79;s:18:\"master_category_id\";i:1;s:20:\"master_category_name\";s:11:\"BOY FASHION\";s:20:\"master_category_slug\";s:11:\"boy-fashion\";s:15:\"section_type_id\";i:7;s:17:\"section_type_name\";s:14:\"SHOP BY BRANDS\";s:17:\"section_type_slug\";s:14:\"shop-by-brands\";s:11:\"category_id\";i:75;s:13:\"category_name\";s:9:\"Pine Kids\";s:13:\"category_slug\";s:9:\"pine-kids\";}i:79;a:10:{s:26:\"master_category_section_id\";i:80;s:18:\"master_category_id\";i:1;s:20:\"master_category_name\";s:11:\"BOY FASHION\";s:20:\"master_category_slug\";s:11:\"boy-fashion\";s:15:\"section_type_id\";i:7;s:17:\"section_type_name\";s:14:\"SHOP BY BRANDS\";s:17:\"section_type_slug\";s:14:\"shop-by-brands\";s:11:\"category_id\";i:76;s:13:\"category_name\";s:9:\"Cute Walk\";s:13:\"category_slug\";s:9:\"cute-walk\";}i:80;a:10:{s:26:\"master_category_section_id\";i:81;s:18:\"master_category_id\";i:1;s:20:\"master_category_name\";s:11:\"BOY FASHION\";s:20:\"master_category_slug\";s:11:\"boy-fashion\";s:15:\"section_type_id\";i:7;s:17:\"section_type_name\";s:14:\"SHOP BY BRANDS\";s:17:\"section_type_slug\";s:14:\"shop-by-brands\";s:11:\"category_id\";i:77;s:13:\"category_name\";s:8:\"Honeyhap\";s:13:\"category_slug\";s:8:\"honeyhap\";}i:81;a:10:{s:26:\"master_category_section_id\";i:82;s:18:\"master_category_id\";i:1;s:20:\"master_category_name\";s:11:\"BOY FASHION\";s:20:\"master_category_slug\";s:11:\"boy-fashion\";s:15:\"section_type_id\";i:7;s:17:\"section_type_name\";s:14:\"SHOP BY BRANDS\";s:17:\"section_type_slug\";s:14:\"shop-by-brands\";s:11:\"category_id\";i:78;s:13:\"category_name\";s:13:\"OLLINGTON ST.\";s:13:\"category_slug\";s:12:\"ollington-st\";}i:82;a:10:{s:26:\"master_category_section_id\";i:83;s:18:\"master_category_id\";i:1;s:20:\"master_category_name\";s:11:\"BOY FASHION\";s:20:\"master_category_slug\";s:11:\"boy-fashion\";s:15:\"section_type_id\";i:7;s:17:\"section_type_name\";s:14:\"SHOP BY BRANDS\";s:17:\"section_type_slug\";s:14:\"shop-by-brands\";s:11:\"category_id\";i:79;s:13:\"category_name\";s:13:\"Doodle Poodle\";s:13:\"category_slug\";s:13:\"doodle-poodle\";}i:83;a:10:{s:26:\"master_category_section_id\";i:84;s:18:\"master_category_id\";i:1;s:20:\"master_category_name\";s:11:\"BOY FASHION\";s:20:\"master_category_slug\";s:11:\"boy-fashion\";s:15:\"section_type_id\";i:7;s:17:\"section_type_name\";s:14:\"SHOP BY BRANDS\";s:17:\"section_type_slug\";s:14:\"shop-by-brands\";s:11:\"category_id\";i:80;s:13:\"category_name\";s:10:\"Primo Gino\";s:13:\"category_slug\";s:10:\"primo-gino\";}i:84;a:10:{s:26:\"master_category_section_id\";i:85;s:18:\"master_category_id\";i:1;s:20:\"master_category_name\";s:11:\"BOY FASHION\";s:20:\"master_category_slug\";s:11:\"boy-fashion\";s:15:\"section_type_id\";i:7;s:17:\"section_type_name\";s:14:\"SHOP BY BRANDS\";s:17:\"section_type_slug\";s:14:\"shop-by-brands\";s:11:\"category_id\";i:81;s:13:\"category_name\";s:10:\"Mark & Mia\";s:13:\"category_slug\";s:8:\"mark-mia\";}i:85;a:10:{s:26:\"master_category_section_id\";i:86;s:18:\"master_category_id\";i:1;s:20:\"master_category_name\";s:11:\"BOY FASHION\";s:20:\"master_category_slug\";s:11:\"boy-fashion\";s:15:\"section_type_id\";i:7;s:17:\"section_type_name\";s:14:\"SHOP BY BRANDS\";s:17:\"section_type_slug\";s:14:\"shop-by-brands\";s:11:\"category_id\";i:82;s:13:\"category_name\";s:7:\"Bonfino\";s:13:\"category_slug\";s:7:\"bonfino\";}i:86;a:10:{s:26:\"master_category_section_id\";i:87;s:18:\"master_category_id\";i:1;s:20:\"master_category_name\";s:11:\"BOY FASHION\";s:20:\"master_category_slug\";s:11:\"boy-fashion\";s:15:\"section_type_id\";i:7;s:17:\"section_type_name\";s:14:\"SHOP BY BRANDS\";s:17:\"section_type_slug\";s:14:\"shop-by-brands\";s:11:\"category_id\";i:83;s:13:\"category_name\";s:12:\"Earthy Touch\";s:13:\"category_slug\";s:12:\"earthy-touch\";}i:87;a:10:{s:26:\"master_category_section_id\";i:88;s:18:\"master_category_id\";i:1;s:20:\"master_category_name\";s:11:\"BOY FASHION\";s:20:\"master_category_slug\";s:11:\"boy-fashion\";s:15:\"section_type_id\";i:7;s:17:\"section_type_name\";s:14:\"SHOP BY BRANDS\";s:17:\"section_type_slug\";s:14:\"shop-by-brands\";s:11:\"category_id\";i:84;s:13:\"category_name\";s:19:\"Arias by Lara Dutta\";s:13:\"category_slug\";s:19:\"arias-by-lara-dutta\";}i:88;a:10:{s:26:\"master_category_section_id\";i:89;s:18:\"master_category_id\";i:1;s:20:\"master_category_name\";s:11:\"BOY FASHION\";s:20:\"master_category_slug\";s:11:\"boy-fashion\";s:15:\"section_type_id\";i:7;s:17:\"section_type_name\";s:14:\"SHOP BY BRANDS\";s:17:\"section_type_slug\";s:14:\"shop-by-brands\";s:11:\"category_id\";i:85;s:13:\"category_name\";s:11:\"Pine Active\";s:13:\"category_slug\";s:11:\"pine-active\";}i:89;a:10:{s:26:\"master_category_section_id\";i:90;s:18:\"master_category_id\";i:1;s:20:\"master_category_name\";s:11:\"BOY FASHION\";s:20:\"master_category_slug\";s:11:\"boy-fashion\";s:15:\"section_type_id\";i:7;s:17:\"section_type_name\";s:14:\"SHOP BY BRANDS\";s:17:\"section_type_slug\";s:14:\"shop-by-brands\";s:11:\"category_id\";i:86;s:13:\"category_name\";s:10:\"ToffyHouse\";s:13:\"category_slug\";s:10:\"toffyhouse\";}i:90;a:10:{s:26:\"master_category_section_id\";i:91;s:18:\"master_category_id\";i:1;s:20:\"master_category_name\";s:11:\"BOY FASHION\";s:20:\"master_category_slug\";s:11:\"boy-fashion\";s:15:\"section_type_id\";i:7;s:17:\"section_type_name\";s:14:\"SHOP BY BRANDS\";s:17:\"section_type_slug\";s:14:\"shop-by-brands\";s:11:\"category_id\";i:87;s:13:\"category_name\";s:9:\"Taffykids\";s:13:\"category_slug\";s:9:\"taffykids\";}i:91;a:10:{s:26:\"master_category_section_id\";i:92;s:18:\"master_category_id\";i:1;s:20:\"master_category_name\";s:11:\"BOY FASHION\";s:20:\"master_category_slug\";s:11:\"boy-fashion\";s:15:\"section_type_id\";i:7;s:17:\"section_type_name\";s:14:\"SHOP BY BRANDS\";s:17:\"section_type_slug\";s:14:\"shop-by-brands\";s:11:\"category_id\";i:88;s:13:\"category_name\";s:10:\"Ed-a-mamma\";s:13:\"category_slug\";s:10:\"ed-a-mamma\";}i:92;a:10:{s:26:\"master_category_section_id\";i:93;s:18:\"master_category_id\";i:1;s:20:\"master_category_name\";s:11:\"BOY FASHION\";s:20:\"master_category_slug\";s:11:\"boy-fashion\";s:15:\"section_type_id\";i:7;s:17:\"section_type_name\";s:14:\"SHOP BY BRANDS\";s:17:\"section_type_slug\";s:14:\"shop-by-brands\";s:11:\"category_id\";i:89;s:13:\"category_name\";s:3:\"UCB\";s:13:\"category_slug\";s:3:\"ucb\";}i:93;a:10:{s:26:\"master_category_section_id\";i:94;s:18:\"master_category_id\";i:1;s:20:\"master_category_name\";s:11:\"BOY FASHION\";s:20:\"master_category_slug\";s:11:\"boy-fashion\";s:15:\"section_type_id\";i:7;s:17:\"section_type_name\";s:14:\"SHOP BY BRANDS\";s:17:\"section_type_slug\";s:14:\"shop-by-brands\";s:11:\"category_id\";i:90;s:13:\"category_name\";s:20:\"U.S. Polo Assn. Kids\";s:13:\"category_slug\";s:17:\"us-polo-assn-kids\";}i:94;a:10:{s:26:\"master_category_section_id\";i:95;s:18:\"master_category_id\";i:1;s:20:\"master_category_name\";s:11:\"BOY FASHION\";s:20:\"master_category_slug\";s:11:\"boy-fashion\";s:15:\"section_type_id\";i:7;s:17:\"section_type_name\";s:14:\"SHOP BY BRANDS\";s:17:\"section_type_slug\";s:14:\"shop-by-brands\";s:11:\"category_id\";i:91;s:13:\"category_name\";s:11:\"Monte Carlo\";s:13:\"category_slug\";s:11:\"monte-carlo\";}i:95;a:10:{s:26:\"master_category_section_id\";i:96;s:18:\"master_category_id\";i:1;s:20:\"master_category_name\";s:11:\"BOY FASHION\";s:20:\"master_category_slug\";s:11:\"boy-fashion\";s:15:\"section_type_id\";i:7;s:17:\"section_type_name\";s:14:\"SHOP BY BRANDS\";s:17:\"section_type_slug\";s:14:\"shop-by-brands\";s:11:\"category_id\";i:92;s:13:\"category_name\";s:11:\"Gini & Jony\";s:13:\"category_slug\";s:9:\"gini-jony\";}i:96;a:10:{s:26:\"master_category_section_id\";i:97;s:18:\"master_category_id\";i:1;s:20:\"master_category_name\";s:11:\"BOY FASHION\";s:20:\"master_category_slug\";s:11:\"boy-fashion\";s:15:\"section_type_id\";i:7;s:17:\"section_type_name\";s:14:\"SHOP BY BRANDS\";s:17:\"section_type_slug\";s:14:\"shop-by-brands\";s:11:\"category_id\";i:93;s:13:\"category_name\";s:4:\"Puma\";s:13:\"category_slug\";s:4:\"puma\";}i:97;a:10:{s:26:\"master_category_section_id\";i:98;s:18:\"master_category_id\";i:1;s:20:\"master_category_name\";s:11:\"BOY FASHION\";s:20:\"master_category_slug\";s:11:\"boy-fashion\";s:15:\"section_type_id\";i:7;s:17:\"section_type_name\";s:14:\"SHOP BY BRANDS\";s:17:\"section_type_slug\";s:14:\"shop-by-brands\";s:11:\"category_id\";i:94;s:13:\"category_name\";s:14:\"Tommy Hilfiger\";s:13:\"category_slug\";s:14:\"tommy-hilfiger\";}i:98;a:10:{s:26:\"master_category_section_id\";i:99;s:18:\"master_category_id\";i:1;s:20:\"master_category_name\";s:11:\"BOY FASHION\";s:20:\"master_category_slug\";s:11:\"boy-fashion\";s:15:\"section_type_id\";i:7;s:17:\"section_type_name\";s:14:\"SHOP BY BRANDS\";s:17:\"section_type_slug\";s:14:\"shop-by-brands\";s:11:\"category_id\";i:95;s:13:\"category_name\";s:11:\"ADIDAS KIDS\";s:13:\"category_slug\";s:11:\"adidas-kids\";}i:99;a:10:{s:26:\"master_category_section_id\";i:100;s:18:\"master_category_id\";i:1;s:20:\"master_category_name\";s:11:\"BOY FASHION\";s:20:\"master_category_slug\";s:11:\"boy-fashion\";s:15:\"section_type_id\";i:7;s:17:\"section_type_name\";s:14:\"SHOP BY BRANDS\";s:17:\"section_type_slug\";s:14:\"shop-by-brands\";s:11:\"category_id\";i:96;s:13:\"category_name\";s:4:\"RUFF\";s:13:\"category_slug\";s:4:\"ruff\";}i:100;a:10:{s:26:\"master_category_section_id\";i:101;s:18:\"master_category_id\";i:1;s:20:\"master_category_name\";s:11:\"BOY FASHION\";s:20:\"master_category_slug\";s:11:\"boy-fashion\";s:15:\"section_type_id\";i:7;s:17:\"section_type_name\";s:14:\"SHOP BY BRANDS\";s:17:\"section_type_slug\";s:14:\"shop-by-brands\";s:11:\"category_id\";i:97;s:13:\"category_name\";s:10:\"ASICS Kids\";s:13:\"category_slug\";s:10:\"asics-kids\";}i:101;a:10:{s:26:\"master_category_section_id\";i:102;s:18:\"master_category_id\";i:2;s:20:\"master_category_name\";s:12:\"GIRL FASHION\";s:20:\"master_category_slug\";s:12:\"girl-fashion\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:98;s:13:\"category_name\";s:16:\"Frocks & Dresses\";s:13:\"category_slug\";s:14:\"frocks-dresses\";}i:102;a:10:{s:26:\"master_category_section_id\";i:103;s:18:\"master_category_id\";i:2;s:20:\"master_category_name\";s:12:\"GIRL FASHION\";s:20:\"master_category_slug\";s:12:\"girl-fashion\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:1;s:13:\"category_name\";s:12:\"Sets & Suits\";s:13:\"category_slug\";s:10:\"sets-suits\";}i:103;a:10:{s:26:\"master_category_section_id\";i:104;s:18:\"master_category_id\";i:2;s:20:\"master_category_name\";s:12:\"GIRL FASHION\";s:20:\"master_category_slug\";s:12:\"girl-fashion\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:99;s:13:\"category_name\";s:4:\"Tops\";s:13:\"category_slug\";s:4:\"tops\";}i:104;a:10:{s:26:\"master_category_section_id\";i:105;s:18:\"master_category_id\";i:2;s:20:\"master_category_name\";s:12:\"GIRL FASHION\";s:20:\"master_category_slug\";s:12:\"girl-fashion\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:100;s:13:\"category_name\";s:7:\"Tshirts\";s:13:\"category_slug\";s:7:\"tshirts\";}i:105;a:10:{s:26:\"master_category_section_id\";i:106;s:18:\"master_category_id\";i:2;s:20:\"master_category_name\";s:12:\"GIRL FASHION\";s:20:\"master_category_slug\";s:12:\"girl-fashion\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:101;s:13:\"category_name\";s:15:\"Shorts & Skirts\";s:13:\"category_slug\";s:13:\"shorts-skirts\";}i:106;a:10:{s:26:\"master_category_section_id\";i:107;s:18:\"master_category_id\";i:2;s:20:\"master_category_name\";s:12:\"GIRL FASHION\";s:20:\"master_category_slug\";s:12:\"girl-fashion\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:5;s:13:\"category_name\";s:16:\"Jeans & Trousers\";s:13:\"category_slug\";s:14:\"jeans-trousers\";}i:107;a:10:{s:26:\"master_category_section_id\";i:108;s:18:\"master_category_id\";i:2;s:20:\"master_category_name\";s:12:\"GIRL FASHION\";s:20:\"master_category_slug\";s:12:\"girl-fashion\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:6;s:13:\"category_name\";s:17:\"Night Shorts Sets\";s:13:\"category_slug\";s:17:\"night-shorts-sets\";}i:108;a:10:{s:26:\"master_category_section_id\";i:109;s:18:\"master_category_id\";i:2;s:20:\"master_category_name\";s:12:\"GIRL FASHION\";s:20:\"master_category_slug\";s:12:\"girl-fashion\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:7;s:13:\"category_name\";s:9:\"Nightwear\";s:13:\"category_slug\";s:9:\"nightwear\";}i:109;a:10:{s:26:\"master_category_section_id\";i:110;s:18:\"master_category_id\";i:2;s:20:\"master_category_name\";s:12:\"GIRL FASHION\";s:20:\"master_category_slug\";s:12:\"girl-fashion\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:102;s:13:\"category_name\";s:21:\"Pajamas & Track Pants\";s:13:\"category_slug\";s:19:\"pajamas-track-pants\";}i:110;a:10:{s:26:\"master_category_section_id\";i:111;s:18:\"master_category_id\";i:2;s:20:\"master_category_name\";s:12:\"GIRL FASHION\";s:20:\"master_category_slug\";s:12:\"girl-fashion\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:103;s:13:\"category_name\";s:8:\"Leggings\";s:13:\"category_slug\";s:8:\"leggings\";}i:111;a:10:{s:26:\"master_category_section_id\";i:112;s:18:\"master_category_id\";i:2;s:20:\"master_category_name\";s:12:\"GIRL FASHION\";s:20:\"master_category_slug\";s:12:\"girl-fashion\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:104;s:13:\"category_name\";s:24:\"Bootie & Diaper Leggings\";s:13:\"category_slug\";s:22:\"bootie-diaper-leggings\";}i:112;a:10:{s:26:\"master_category_section_id\";i:113;s:18:\"master_category_id\";i:2;s:20:\"master_category_name\";s:12:\"GIRL FASHION\";s:20:\"master_category_slug\";s:12:\"girl-fashion\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:11;s:13:\"category_name\";s:8:\"Rainwear\";s:13:\"category_slug\";s:8:\"rainwear\";}i:113;a:10:{s:26:\"master_category_section_id\";i:114;s:18:\"master_category_id\";i:2;s:20:\"master_category_name\";s:12:\"GIRL FASHION\";s:20:\"master_category_slug\";s:12:\"girl-fashion\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:14;s:13:\"category_name\";s:9:\"Swim Wear\";s:13:\"category_slug\";s:9:\"swim-wear\";}i:114;a:10:{s:26:\"master_category_section_id\";i:115;s:18:\"master_category_id\";i:2;s:20:\"master_category_name\";s:12:\"GIRL FASHION\";s:20:\"master_category_slug\";s:12:\"girl-fashion\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:105;s:13:\"category_name\";s:17:\"Slips & Bralettes\";s:13:\"category_slug\";s:15:\"slips-bralettes\";}i:115;a:10:{s:26:\"master_category_section_id\";i:116;s:18:\"master_category_id\";i:2;s:20:\"master_category_name\";s:12:\"GIRL FASHION\";s:20:\"master_category_slug\";s:12:\"girl-fashion\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:106;s:13:\"category_name\";s:18:\"Panties & Bloomers\";s:13:\"category_slug\";s:16:\"panties-bloomers\";}i:116;a:10:{s:26:\"master_category_section_id\";i:117;s:18:\"master_category_id\";i:2;s:20:\"master_category_name\";s:12:\"GIRL FASHION\";s:20:\"master_category_slug\";s:12:\"girl-fashion\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:18;s:13:\"category_name\";s:10:\"Inner Wear\";s:13:\"category_slug\";s:10:\"inner-wear\";}i:117;a:10:{s:26:\"master_category_section_id\";i:118;s:18:\"master_category_id\";i:2;s:20:\"master_category_name\";s:12:\"GIRL FASHION\";s:20:\"master_category_slug\";s:12:\"girl-fashion\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:9;s:13:\"category_name\";s:17:\"Onesies & Rompers\";s:13:\"category_slug\";s:15:\"onesies-rompers\";}i:118;a:10:{s:26:\"master_category_section_id\";i:119;s:18:\"master_category_id\";i:2;s:20:\"master_category_name\";s:12:\"GIRL FASHION\";s:20:\"master_category_slug\";s:12:\"girl-fashion\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:12;s:13:\"category_name\";s:10:\"Party Wear\";s:13:\"category_slug\";s:10:\"party-wear\";}i:119;a:10:{s:26:\"master_category_section_id\";i:120;s:18:\"master_category_id\";i:2;s:20:\"master_category_name\";s:12:\"GIRL FASHION\";s:20:\"master_category_slug\";s:12:\"girl-fashion\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:13;s:13:\"category_name\";s:11:\"Ethnic Wear\";s:13:\"category_slug\";s:11:\"ethnic-wear\";}i:120;a:10:{s:26:\"master_category_section_id\";i:121;s:18:\"master_category_id\";i:2;s:20:\"master_category_name\";s:12:\"GIRL FASHION\";s:20:\"master_category_slug\";s:12:\"girl-fashion\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:20;s:13:\"category_name\";s:9:\"Bath Time\";s:13:\"category_slug\";s:9:\"bath-time\";}i:121;a:10:{s:26:\"master_category_section_id\";i:122;s:18:\"master_category_id\";i:2;s:20:\"master_category_name\";s:12:\"GIRL FASHION\";s:20:\"master_category_slug\";s:12:\"girl-fashion\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:15;s:13:\"category_name\";s:23:\"Athleisure & Sportswear\";s:13:\"category_slug\";s:21:\"athleisure-sportswear\";}i:122;a:10:{s:26:\"master_category_section_id\";i:123;s:18:\"master_category_id\";i:2;s:20:\"master_category_name\";s:12:\"GIRL FASHION\";s:20:\"master_category_slug\";s:12:\"girl-fashion\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:19;s:13:\"category_name\";s:11:\"Summer Caps\";s:13:\"category_slug\";s:11:\"summer-caps\";}i:123;a:10:{s:26:\"master_category_section_id\";i:124;s:18:\"master_category_id\";i:2;s:20:\"master_category_name\";s:12:\"GIRL FASHION\";s:20:\"master_category_slug\";s:12:\"girl-fashion\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:107;s:13:\"category_name\";s:14:\"Socks & Tights\";s:13:\"category_slug\";s:12:\"socks-tights\";}i:124;a:10:{s:26:\"master_category_section_id\";i:125;s:18:\"master_category_id\";i:2;s:20:\"master_category_name\";s:12:\"GIRL FASHION\";s:20:\"master_category_slug\";s:12:\"girl-fashion\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:22;s:13:\"category_name\";s:23:\"Caps, Mittens & Booties\";s:13:\"category_slug\";s:20:\"caps-mittens-booties\";}i:125;a:10:{s:26:\"master_category_section_id\";i:126;s:18:\"master_category_id\";i:2;s:20:\"master_category_name\";s:12:\"GIRL FASHION\";s:20:\"master_category_slug\";s:12:\"girl-fashion\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:25;s:13:\"category_name\";s:7:\"Jackets\";s:13:\"category_slug\";s:7:\"jackets\";}i:126;a:10:{s:26:\"master_category_section_id\";i:127;s:18:\"master_category_id\";i:2;s:20:\"master_category_name\";s:12:\"GIRL FASHION\";s:20:\"master_category_slug\";s:12:\"girl-fashion\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:24;s:13:\"category_name\";s:11:\"Sweatshirts\";s:13:\"category_slug\";s:11:\"sweatshirts\";}i:127;a:10:{s:26:\"master_category_section_id\";i:128;s:18:\"master_category_id\";i:2;s:20:\"master_category_name\";s:12:\"GIRL FASHION\";s:20:\"master_category_slug\";s:12:\"girl-fashion\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:27;s:13:\"category_name\";s:11:\"Winter Sets\";s:13:\"category_slug\";s:11:\"winter-sets\";}i:128;a:10:{s:26:\"master_category_section_id\";i:129;s:18:\"master_category_id\";i:2;s:20:\"master_category_name\";s:12:\"GIRL FASHION\";s:20:\"master_category_slug\";s:12:\"girl-fashion\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:30;s:13:\"category_name\";s:16:\"Winter Nightwear\";s:13:\"category_slug\";s:16:\"winter-nightwear\";}i:129;a:10:{s:26:\"master_category_section_id\";i:130;s:18:\"master_category_id\";i:2;s:20:\"master_category_name\";s:12:\"GIRL FASHION\";s:20:\"master_category_slug\";s:12:\"girl-fashion\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:108;s:13:\"category_name\";s:8:\"Sweaters\";s:13:\"category_slug\";s:8:\"sweaters\";}i:130;a:10:{s:26:\"master_category_section_id\";i:131;s:18:\"master_category_id\";i:2;s:20:\"master_category_name\";s:12:\"GIRL FASHION\";s:20:\"master_category_slug\";s:12:\"girl-fashion\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:29;s:13:\"category_name\";s:23:\"Woolen Caps & Ear Muffs\";s:13:\"category_slug\";s:21:\"woolen-caps-ear-muffs\";}i:131;a:10:{s:26:\"master_category_section_id\";i:132;s:18:\"master_category_id\";i:2;s:20:\"master_category_name\";s:12:\"GIRL FASHION\";s:20:\"master_category_slug\";s:12:\"girl-fashion\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:23;s:13:\"category_name\";s:8:\"Thermals\";s:13:\"category_slug\";s:8:\"thermals\";}i:132;a:10:{s:26:\"master_category_section_id\";i:133;s:18:\"master_category_id\";i:2;s:20:\"master_category_name\";s:12:\"GIRL FASHION\";s:20:\"master_category_slug\";s:12:\"girl-fashion\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:28;s:13:\"category_name\";s:14:\"Fleece Bottoms\";s:13:\"category_slug\";s:14:\"fleece-bottoms\";}i:133;a:10:{s:26:\"master_category_section_id\";i:134;s:18:\"master_category_id\";i:2;s:20:\"master_category_name\";s:12:\"GIRL FASHION\";s:20:\"master_category_slug\";s:12:\"girl-fashion\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:31;s:13:\"category_name\";s:6:\"Gloves\";s:13:\"category_slug\";s:6:\"gloves\";}i:134;a:10:{s:26:\"master_category_section_id\";i:135;s:18:\"master_category_id\";i:2;s:20:\"master_category_name\";s:12:\"GIRL FASHION\";s:20:\"master_category_slug\";s:12:\"girl-fashion\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:32;s:13:\"category_name\";s:14:\"Theme Costumes\";s:13:\"category_slug\";s:14:\"theme-costumes\";}i:135;a:10:{s:26:\"master_category_section_id\";i:136;s:18:\"master_category_id\";i:2;s:20:\"master_category_name\";s:12:\"GIRL FASHION\";s:20:\"master_category_slug\";s:12:\"girl-fashion\";s:15:\"section_type_id\";i:2;s:17:\"section_type_name\";s:18:\"SHOP BY COLLECTION\";s:17:\"section_type_slug\";s:18:\"shop-by-collection\";s:11:\"category_id\";i:33;s:13:\"category_name\";s:16:\"Splash in Summer\";s:13:\"category_slug\";s:16:\"splash-in-summer\";}i:136;a:10:{s:26:\"master_category_section_id\";i:137;s:18:\"master_category_id\";i:2;s:20:\"master_category_name\";s:12:\"GIRL FASHION\";s:20:\"master_category_slug\";s:12:\"girl-fashion\";s:15:\"section_type_id\";i:2;s:17:\"section_type_name\";s:18:\"SHOP BY COLLECTION\";s:17:\"section_type_slug\";s:18:\"shop-by-collection\";s:11:\"category_id\";i:34;s:13:\"category_name\";s:11:\"Bestsellers\";s:13:\"category_slug\";s:11:\"bestsellers\";}i:137;a:10:{s:26:\"master_category_section_id\";i:138;s:18:\"master_category_id\";i:2;s:20:\"master_category_name\";s:12:\"GIRL FASHION\";s:20:\"master_category_slug\";s:12:\"girl-fashion\";s:15:\"section_type_id\";i:2;s:17:\"section_type_name\";s:18:\"SHOP BY COLLECTION\";s:17:\"section_type_slug\";s:18:\"shop-by-collection\";s:11:\"category_id\";i:35;s:13:\"category_name\";s:11:\"Multi-packs\";s:13:\"category_slug\";s:11:\"multi-packs\";}i:138;a:10:{s:26:\"master_category_section_id\";i:139;s:18:\"master_category_id\";i:2;s:20:\"master_category_name\";s:12:\"GIRL FASHION\";s:20:\"master_category_slug\";s:12:\"girl-fashion\";s:15:\"section_type_id\";i:2;s:17:\"section_type_name\";s:18:\"SHOP BY COLLECTION\";s:17:\"section_type_slug\";s:18:\"shop-by-collection\";s:11:\"category_id\";i:36;s:13:\"category_name\";s:15:\"Baby Essentials\";s:13:\"category_slug\";s:15:\"baby-essentials\";}i:139;a:10:{s:26:\"master_category_section_id\";i:140;s:18:\"master_category_id\";i:2;s:20:\"master_category_name\";s:12:\"GIRL FASHION\";s:20:\"master_category_slug\";s:12:\"girl-fashion\";s:15:\"section_type_id\";i:3;s:17:\"section_type_name\";s:11:\"SHOP BY AGE\";s:17:\"section_type_slug\";s:11:\"shop-by-age\";s:11:\"category_id\";i:37;s:13:\"category_name\";s:20:\"Preemie/Tine Preemie\";s:13:\"category_slug\";s:19:\"preemietine-preemie\";}i:140;a:10:{s:26:\"master_category_section_id\";i:141;s:18:\"master_category_id\";i:2;s:20:\"master_category_name\";s:12:\"GIRL FASHION\";s:20:\"master_category_slug\";s:12:\"girl-fashion\";s:15:\"section_type_id\";i:3;s:17:\"section_type_name\";s:11:\"SHOP BY AGE\";s:17:\"section_type_slug\";s:11:\"shop-by-age\";s:11:\"category_id\";i:38;s:13:\"category_name\";s:16:\"New Born (0-3 M)\";s:13:\"category_slug\";s:14:\"new-born-0-3-m\";}i:141;a:10:{s:26:\"master_category_section_id\";i:142;s:18:\"master_category_id\";i:2;s:20:\"master_category_name\";s:12:\"GIRL FASHION\";s:20:\"master_category_slug\";s:12:\"girl-fashion\";s:15:\"section_type_id\";i:3;s:17:\"section_type_name\";s:11:\"SHOP BY AGE\";s:17:\"section_type_slug\";s:11:\"shop-by-age\";s:11:\"category_id\";i:39;s:13:\"category_name\";s:10:\"3-6 Months\";s:13:\"category_slug\";s:10:\"3-6-months\";}i:142;a:10:{s:26:\"master_category_section_id\";i:143;s:18:\"master_category_id\";i:2;s:20:\"master_category_name\";s:12:\"GIRL FASHION\";s:20:\"master_category_slug\";s:12:\"girl-fashion\";s:15:\"section_type_id\";i:3;s:17:\"section_type_name\";s:11:\"SHOP BY AGE\";s:17:\"section_type_slug\";s:11:\"shop-by-age\";s:11:\"category_id\";i:40;s:13:\"category_name\";s:10:\"6-9 Months\";s:13:\"category_slug\";s:10:\"6-9-months\";}i:143;a:10:{s:26:\"master_category_section_id\";i:144;s:18:\"master_category_id\";i:2;s:20:\"master_category_name\";s:12:\"GIRL FASHION\";s:20:\"master_category_slug\";s:12:\"girl-fashion\";s:15:\"section_type_id\";i:3;s:17:\"section_type_name\";s:11:\"SHOP BY AGE\";s:17:\"section_type_slug\";s:11:\"shop-by-age\";s:11:\"category_id\";i:41;s:13:\"category_name\";s:11:\"9-12 Months\";s:13:\"category_slug\";s:11:\"9-12-months\";}i:144;a:10:{s:26:\"master_category_section_id\";i:145;s:18:\"master_category_id\";i:2;s:20:\"master_category_name\";s:12:\"GIRL FASHION\";s:20:\"master_category_slug\";s:12:\"girl-fashion\";s:15:\"section_type_id\";i:3;s:17:\"section_type_name\";s:11:\"SHOP BY AGE\";s:17:\"section_type_slug\";s:11:\"shop-by-age\";s:11:\"category_id\";i:42;s:13:\"category_name\";s:12:\"12-18 Months\";s:13:\"category_slug\";s:12:\"12-18-months\";}i:145;a:10:{s:26:\"master_category_section_id\";i:146;s:18:\"master_category_id\";i:2;s:20:\"master_category_name\";s:12:\"GIRL FASHION\";s:20:\"master_category_slug\";s:12:\"girl-fashion\";s:15:\"section_type_id\";i:3;s:17:\"section_type_name\";s:11:\"SHOP BY AGE\";s:17:\"section_type_slug\";s:11:\"shop-by-age\";s:11:\"category_id\";i:43;s:13:\"category_name\";s:12:\"18-24 Months\";s:13:\"category_slug\";s:12:\"18-24-months\";}i:146;a:10:{s:26:\"master_category_section_id\";i:147;s:18:\"master_category_id\";i:2;s:20:\"master_category_name\";s:12:\"GIRL FASHION\";s:20:\"master_category_slug\";s:12:\"girl-fashion\";s:15:\"section_type_id\";i:3;s:17:\"section_type_name\";s:11:\"SHOP BY AGE\";s:17:\"section_type_slug\";s:11:\"shop-by-age\";s:11:\"category_id\";i:44;s:13:\"category_name\";s:12:\"2 to 4 Years\";s:13:\"category_slug\";s:12:\"2-to-4-years\";}i:147;a:10:{s:26:\"master_category_section_id\";i:148;s:18:\"master_category_id\";i:2;s:20:\"master_category_name\";s:12:\"GIRL FASHION\";s:20:\"master_category_slug\";s:12:\"girl-fashion\";s:15:\"section_type_id\";i:3;s:17:\"section_type_name\";s:11:\"SHOP BY AGE\";s:17:\"section_type_slug\";s:11:\"shop-by-age\";s:11:\"category_id\";i:45;s:13:\"category_name\";s:12:\"4 to 6 Years\";s:13:\"category_slug\";s:12:\"4-to-6-years\";}i:148;a:10:{s:26:\"master_category_section_id\";i:149;s:18:\"master_category_id\";i:2;s:20:\"master_category_name\";s:12:\"GIRL FASHION\";s:20:\"master_category_slug\";s:12:\"girl-fashion\";s:15:\"section_type_id\";i:3;s:17:\"section_type_name\";s:11:\"SHOP BY AGE\";s:17:\"section_type_slug\";s:11:\"shop-by-age\";s:11:\"category_id\";i:46;s:13:\"category_name\";s:12:\"6 to 8 Years\";s:13:\"category_slug\";s:12:\"6-to-8-years\";}i:149;a:10:{s:26:\"master_category_section_id\";i:150;s:18:\"master_category_id\";i:2;s:20:\"master_category_name\";s:12:\"GIRL FASHION\";s:20:\"master_category_slug\";s:12:\"girl-fashion\";s:15:\"section_type_id\";i:3;s:17:\"section_type_name\";s:11:\"SHOP BY AGE\";s:17:\"section_type_slug\";s:11:\"shop-by-age\";s:11:\"category_id\";i:47;s:13:\"category_name\";s:8:\"8+ Years\";s:13:\"category_slug\";s:7:\"8-years\";}i:150;a:10:{s:26:\"master_category_section_id\";i:151;s:18:\"master_category_id\";i:2;s:20:\"master_category_name\";s:12:\"GIRL FASHION\";s:20:\"master_category_slug\";s:12:\"girl-fashion\";s:15:\"section_type_id\";i:4;s:17:\"section_type_name\";s:19:\"FASHION ACCESSORIES\";s:17:\"section_type_slug\";s:19:\"fashion-accessories\";s:11:\"category_id\";i:48;s:13:\"category_name\";s:10:\"Sunglasses\";s:13:\"category_slug\";s:10:\"sunglasses\";}i:151;a:10:{s:26:\"master_category_section_id\";i:152;s:18:\"master_category_id\";i:2;s:20:\"master_category_name\";s:12:\"GIRL FASHION\";s:20:\"master_category_slug\";s:12:\"girl-fashion\";s:15:\"section_type_id\";i:4;s:17:\"section_type_name\";s:19:\"FASHION ACCESSORIES\";s:17:\"section_type_slug\";s:19:\"fashion-accessories\";s:11:\"category_id\";i:109;s:13:\"category_name\";s:10:\"Hair Bands\";s:13:\"category_slug\";s:10:\"hair-bands\";}i:152;a:10:{s:26:\"master_category_section_id\";i:153;s:18:\"master_category_id\";i:2;s:20:\"master_category_name\";s:12:\"GIRL FASHION\";s:20:\"master_category_slug\";s:12:\"girl-fashion\";s:15:\"section_type_id\";i:4;s:17:\"section_type_name\";s:19:\"FASHION ACCESSORIES\";s:17:\"section_type_slug\";s:19:\"fashion-accessories\";s:11:\"category_id\";i:110;s:13:\"category_name\";s:25:\"Hair Clips & Rubber Bands\";s:13:\"category_slug\";s:23:\"hair-clips-rubber-bands\";}i:153;a:10:{s:26:\"master_category_section_id\";i:154;s:18:\"master_category_id\";i:2;s:20:\"master_category_name\";s:12:\"GIRL FASHION\";s:20:\"master_category_slug\";s:12:\"girl-fashion\";s:15:\"section_type_id\";i:4;s:17:\"section_type_name\";s:19:\"FASHION ACCESSORIES\";s:17:\"section_type_slug\";s:19:\"fashion-accessories\";s:11:\"category_id\";i:19;s:13:\"category_name\";s:11:\"Summer Caps\";s:13:\"category_slug\";s:11:\"summer-caps\";}i:154;a:10:{s:26:\"master_category_section_id\";i:155;s:18:\"master_category_id\";i:2;s:20:\"master_category_name\";s:12:\"GIRL FASHION\";s:20:\"master_category_slug\";s:12:\"girl-fashion\";s:15:\"section_type_id\";i:4;s:17:\"section_type_name\";s:19:\"FASHION ACCESSORIES\";s:17:\"section_type_slug\";s:19:\"fashion-accessories\";s:11:\"category_id\";i:49;s:13:\"category_name\";s:14:\"Kids Umbrellas\";s:13:\"category_slug\";s:14:\"kids-umbrellas\";}i:155;a:10:{s:26:\"master_category_section_id\";i:156;s:18:\"master_category_id\";i:2;s:20:\"master_category_name\";s:12:\"GIRL FASHION\";s:20:\"master_category_slug\";s:12:\"girl-fashion\";s:15:\"section_type_id\";i:4;s:17:\"section_type_name\";s:19:\"FASHION ACCESSORIES\";s:17:\"section_type_slug\";s:19:\"fashion-accessories\";s:11:\"category_id\";i:111;s:13:\"category_name\";s:9:\"Jewellery\";s:13:\"category_slug\";s:9:\"jewellery\";}i:156;a:10:{s:26:\"master_category_section_id\";i:157;s:18:\"master_category_id\";i:2;s:20:\"master_category_name\";s:12:\"GIRL FASHION\";s:20:\"master_category_slug\";s:12:\"girl-fashion\";s:15:\"section_type_id\";i:4;s:17:\"section_type_name\";s:19:\"FASHION ACCESSORIES\";s:17:\"section_type_slug\";s:19:\"fashion-accessories\";s:11:\"category_id\";i:52;s:13:\"category_name\";s:4:\"Bags\";s:13:\"category_slug\";s:4:\"bags\";}i:157;a:10:{s:26:\"master_category_section_id\";i:158;s:18:\"master_category_id\";i:2;s:20:\"master_category_name\";s:12:\"GIRL FASHION\";s:20:\"master_category_slug\";s:12:\"girl-fashion\";s:15:\"section_type_id\";i:4;s:17:\"section_type_name\";s:19:\"FASHION ACCESSORIES\";s:17:\"section_type_slug\";s:19:\"fashion-accessories\";s:11:\"category_id\";i:50;s:13:\"category_name\";s:7:\"Watches\";s:13:\"category_slug\";s:7:\"watches\";}i:158;a:10:{s:26:\"master_category_section_id\";i:159;s:18:\"master_category_id\";i:2;s:20:\"master_category_name\";s:12:\"GIRL FASHION\";s:20:\"master_category_slug\";s:12:\"girl-fashion\";s:15:\"section_type_id\";i:4;s:17:\"section_type_name\";s:19:\"FASHION ACCESSORIES\";s:17:\"section_type_slug\";s:19:\"fashion-accessories\";s:11:\"category_id\";i:112;s:13:\"category_name\";s:5:\"Belts\";s:13:\"category_slug\";s:5:\"belts\";}i:159;a:10:{s:26:\"master_category_section_id\";i:160;s:18:\"master_category_id\";i:2;s:20:\"master_category_name\";s:12:\"GIRL FASHION\";s:20:\"master_category_slug\";s:12:\"girl-fashion\";s:15:\"section_type_id\";i:4;s:17:\"section_type_name\";s:19:\"FASHION ACCESSORIES\";s:17:\"section_type_slug\";s:19:\"fashion-accessories\";s:11:\"category_id\";i:53;s:13:\"category_name\";s:13:\"Smart Watches\";s:13:\"category_slug\";s:13:\"smart-watches\";}i:160;a:10:{s:26:\"master_category_section_id\";i:161;s:18:\"master_category_id\";i:2;s:20:\"master_category_name\";s:12:\"GIRL FASHION\";s:20:\"master_category_slug\";s:12:\"girl-fashion\";s:15:\"section_type_id\";i:4;s:17:\"section_type_name\";s:19:\"FASHION ACCESSORIES\";s:17:\"section_type_slug\";s:19:\"fashion-accessories\";s:11:\"category_id\";i:113;s:13:\"category_name\";s:23:\"Woolen Caps & Ear Muffs\";s:13:\"category_slug\";s:21:\"woolen-caps-ear-muffs\";}i:161;a:10:{s:26:\"master_category_section_id\";i:162;s:18:\"master_category_id\";i:2;s:20:\"master_category_name\";s:12:\"GIRL FASHION\";s:20:\"master_category_slug\";s:12:\"girl-fashion\";s:15:\"section_type_id\";i:4;s:17:\"section_type_name\";s:19:\"FASHION ACCESSORIES\";s:17:\"section_type_slug\";s:19:\"fashion-accessories\";s:11:\"category_id\";i:22;s:13:\"category_name\";s:23:\"Caps, Mittens & Booties\";s:13:\"category_slug\";s:20:\"caps-mittens-booties\";}i:162;a:10:{s:26:\"master_category_section_id\";i:163;s:18:\"master_category_id\";i:2;s:20:\"master_category_name\";s:12:\"GIRL FASHION\";s:20:\"master_category_slug\";s:12:\"girl-fashion\";s:15:\"section_type_id\";i:4;s:17:\"section_type_name\";s:19:\"FASHION ACCESSORIES\";s:17:\"section_type_slug\";s:19:\"fashion-accessories\";s:11:\"category_id\";i:114;s:13:\"category_name\";s:6:\"Gloves\";s:13:\"category_slug\";s:6:\"gloves\";}i:163;a:10:{s:26:\"master_category_section_id\";i:164;s:18:\"master_category_id\";i:2;s:20:\"master_category_name\";s:12:\"GIRL FASHION\";s:20:\"master_category_slug\";s:12:\"girl-fashion\";s:15:\"section_type_id\";i:5;s:17:\"section_type_name\";s:8:\"FOOTWEAR\";s:17:\"section_type_slug\";s:8:\"footwear\";s:11:\"category_id\";i:54;s:13:\"category_name\";s:10:\"Flip Flops\";s:13:\"category_slug\";s:10:\"flip-flops\";}i:164;a:10:{s:26:\"master_category_section_id\";i:165;s:18:\"master_category_id\";i:2;s:20:\"master_category_name\";s:12:\"GIRL FASHION\";s:20:\"master_category_slug\";s:12:\"girl-fashion\";s:15:\"section_type_id\";i:5;s:17:\"section_type_name\";s:8:\"FOOTWEAR\";s:17:\"section_type_slug\";s:8:\"footwear\";s:11:\"category_id\";i:55;s:13:\"category_name\";s:5:\"Clogs\";s:13:\"category_slug\";s:5:\"clogs\";}i:165;a:10:{s:26:\"master_category_section_id\";i:166;s:18:\"master_category_id\";i:2;s:20:\"master_category_name\";s:12:\"GIRL FASHION\";s:20:\"master_category_slug\";s:12:\"girl-fashion\";s:15:\"section_type_id\";i:5;s:17:\"section_type_name\";s:8:\"FOOTWEAR\";s:17:\"section_type_slug\";s:8:\"footwear\";s:11:\"category_id\";i:56;s:13:\"category_name\";s:7:\"Sandals\";s:13:\"category_slug\";s:7:\"sandals\";}i:166;a:10:{s:26:\"master_category_section_id\";i:167;s:18:\"master_category_id\";i:2;s:20:\"master_category_name\";s:12:\"GIRL FASHION\";s:20:\"master_category_slug\";s:12:\"girl-fashion\";s:15:\"section_type_id\";i:5;s:17:\"section_type_name\";s:8:\"FOOTWEAR\";s:17:\"section_type_slug\";s:8:\"footwear\";s:11:\"category_id\";i:57;s:13:\"category_name\";s:10:\"Pool Shoes\";s:13:\"category_slug\";s:10:\"pool-shoes\";}i:167;a:10:{s:26:\"master_category_section_id\";i:168;s:18:\"master_category_id\";i:2;s:20:\"master_category_name\";s:12:\"GIRL FASHION\";s:20:\"master_category_slug\";s:12:\"girl-fashion\";s:15:\"section_type_id\";i:5;s:17:\"section_type_name\";s:8:\"FOOTWEAR\";s:17:\"section_type_slug\";s:8:\"footwear\";s:11:\"category_id\";i:58;s:13:\"category_name\";s:12:\"Casual Shoes\";s:13:\"category_slug\";s:12:\"casual-shoes\";}i:168;a:10:{s:26:\"master_category_section_id\";i:169;s:18:\"master_category_id\";i:2;s:20:\"master_category_name\";s:12:\"GIRL FASHION\";s:20:\"master_category_slug\";s:12:\"girl-fashion\";s:15:\"section_type_id\";i:5;s:17:\"section_type_name\";s:8:\"FOOTWEAR\";s:17:\"section_type_slug\";s:8:\"footwear\";s:11:\"category_id\";i:115;s:13:\"category_name\";s:10:\"Ballerinas\";s:13:\"category_slug\";s:10:\"ballerinas\";}i:169;a:10:{s:26:\"master_category_section_id\";i:170;s:18:\"master_category_id\";i:2;s:20:\"master_category_name\";s:12:\"GIRL FASHION\";s:20:\"master_category_slug\";s:12:\"girl-fashion\";s:15:\"section_type_id\";i:5;s:17:\"section_type_name\";s:8:\"FOOTWEAR\";s:17:\"section_type_slug\";s:8:\"footwear\";s:11:\"category_id\";i:59;s:13:\"category_name\";s:12:\"Sports Shoes\";s:13:\"category_slug\";s:12:\"sports-shoes\";}i:170;a:10:{s:26:\"master_category_section_id\";i:171;s:18:\"master_category_id\";i:2;s:20:\"master_category_name\";s:12:\"GIRL FASHION\";s:20:\"master_category_slug\";s:12:\"girl-fashion\";s:15:\"section_type_id\";i:5;s:17:\"section_type_name\";s:8:\"FOOTWEAR\";s:17:\"section_type_slug\";s:8:\"footwear\";s:11:\"category_id\";i:60;s:13:\"category_name\";s:8:\"Sneakers\";s:13:\"category_slug\";s:8:\"sneakers\";}i:171;a:10:{s:26:\"master_category_section_id\";i:172;s:18:\"master_category_id\";i:2;s:20:\"master_category_name\";s:12:\"GIRL FASHION\";s:20:\"master_category_slug\";s:12:\"girl-fashion\";s:15:\"section_type_id\";i:5;s:17:\"section_type_name\";s:8:\"FOOTWEAR\";s:17:\"section_type_slug\";s:8:\"footwear\";s:11:\"category_id\";i:63;s:13:\"category_name\";s:7:\"Booties\";s:13:\"category_slug\";s:7:\"booties\";}i:172;a:10:{s:26:\"master_category_section_id\";i:173;s:18:\"master_category_id\";i:2;s:20:\"master_category_name\";s:12:\"GIRL FASHION\";s:20:\"master_category_slug\";s:12:\"girl-fashion\";s:15:\"section_type_id\";i:5;s:17:\"section_type_name\";s:8:\"FOOTWEAR\";s:17:\"section_type_slug\";s:8:\"footwear\";s:11:\"category_id\";i:62;s:13:\"category_name\";s:12:\"Winter Boots\";s:13:\"category_slug\";s:12:\"winter-boots\";}i:173;a:10:{s:26:\"master_category_section_id\";i:174;s:18:\"master_category_id\";i:2;s:20:\"master_category_name\";s:12:\"GIRL FASHION\";s:20:\"master_category_slug\";s:12:\"girl-fashion\";s:15:\"section_type_id\";i:5;s:17:\"section_type_name\";s:8:\"FOOTWEAR\";s:17:\"section_type_slug\";s:8:\"footwear\";s:11:\"category_id\";i:12;s:13:\"category_name\";s:10:\"Party Wear\";s:13:\"category_slug\";s:10:\"party-wear\";}i:174;a:10:{s:26:\"master_category_section_id\";i:175;s:18:\"master_category_id\";i:2;s:20:\"master_category_name\";s:12:\"GIRL FASHION\";s:20:\"master_category_slug\";s:12:\"girl-fashion\";s:15:\"section_type_id\";i:5;s:17:\"section_type_name\";s:8:\"FOOTWEAR\";s:17:\"section_type_slug\";s:8:\"footwear\";s:11:\"category_id\";i:64;s:13:\"category_name\";s:12:\"School Shoes\";s:13:\"category_slug\";s:12:\"school-shoes\";}i:175;a:10:{s:26:\"master_category_section_id\";i:176;s:18:\"master_category_id\";i:2;s:20:\"master_category_name\";s:12:\"GIRL FASHION\";s:20:\"master_category_slug\";s:12:\"girl-fashion\";s:15:\"section_type_id\";i:5;s:17:\"section_type_name\";s:8:\"FOOTWEAR\";s:17:\"section_type_slug\";s:8:\"footwear\";s:11:\"category_id\";i:65;s:13:\"category_name\";s:9:\"LED Shoes\";s:13:\"category_slug\";s:9:\"led-shoes\";}i:176;a:10:{s:26:\"master_category_section_id\";i:177;s:18:\"master_category_id\";i:2;s:20:\"master_category_name\";s:12:\"GIRL FASHION\";s:20:\"master_category_slug\";s:12:\"girl-fashion\";s:15:\"section_type_id\";i:5;s:17:\"section_type_name\";s:8:\"FOOTWEAR\";s:17:\"section_type_slug\";s:8:\"footwear\";s:11:\"category_id\";i:66;s:13:\"category_name\";s:23:\"Mojaris/Ethnic Footwear\";s:13:\"category_slug\";s:22:\"mojarisethnic-footwear\";}i:177;a:10:{s:26:\"master_category_section_id\";i:178;s:18:\"master_category_id\";i:2;s:20:\"master_category_name\";s:12:\"GIRL FASHION\";s:20:\"master_category_slug\";s:12:\"girl-fashion\";s:15:\"section_type_id\";i:6;s:17:\"section_type_name\";s:13:\"SHOP BY PRICE\";s:17:\"section_type_slug\";s:13:\"shop-by-price\";s:11:\"category_id\";i:67;s:13:\"category_name\";s:13:\"All Under 199\";s:13:\"category_slug\";s:13:\"all-under-199\";}i:178;a:10:{s:26:\"master_category_section_id\";i:179;s:18:\"master_category_id\";i:2;s:20:\"master_category_name\";s:12:\"GIRL FASHION\";s:20:\"master_category_slug\";s:12:\"girl-fashion\";s:15:\"section_type_id\";i:6;s:17:\"section_type_name\";s:13:\"SHOP BY PRICE\";s:17:\"section_type_slug\";s:13:\"shop-by-price\";s:11:\"category_id\";i:68;s:13:\"category_name\";s:13:\"All Under 299\";s:13:\"category_slug\";s:13:\"all-under-299\";}i:179;a:10:{s:26:\"master_category_section_id\";i:180;s:18:\"master_category_id\";i:2;s:20:\"master_category_name\";s:12:\"GIRL FASHION\";s:20:\"master_category_slug\";s:12:\"girl-fashion\";s:15:\"section_type_id\";i:6;s:17:\"section_type_name\";s:13:\"SHOP BY PRICE\";s:17:\"section_type_slug\";s:13:\"shop-by-price\";s:11:\"category_id\";i:69;s:13:\"category_name\";s:13:\"All Under 399\";s:13:\"category_slug\";s:13:\"all-under-399\";}i:180;a:10:{s:26:\"master_category_section_id\";i:181;s:18:\"master_category_id\";i:2;s:20:\"master_category_name\";s:12:\"GIRL FASHION\";s:20:\"master_category_slug\";s:12:\"girl-fashion\";s:15:\"section_type_id\";i:6;s:17:\"section_type_name\";s:13:\"SHOP BY PRICE\";s:17:\"section_type_slug\";s:13:\"shop-by-price\";s:11:\"category_id\";i:70;s:13:\"category_name\";s:13:\"All Under 499\";s:13:\"category_slug\";s:13:\"all-under-499\";}i:181;a:10:{s:26:\"master_category_section_id\";i:182;s:18:\"master_category_id\";i:2;s:20:\"master_category_name\";s:12:\"GIRL FASHION\";s:20:\"master_category_slug\";s:12:\"girl-fashion\";s:15:\"section_type_id\";i:7;s:17:\"section_type_name\";s:14:\"SHOP BY BRANDS\";s:17:\"section_type_slug\";s:14:\"shop-by-brands\";s:11:\"category_id\";i:71;s:13:\"category_name\";s:7:\"Babyhug\";s:13:\"category_slug\";s:7:\"babyhug\";}i:182;a:10:{s:26:\"master_category_section_id\";i:183;s:18:\"master_category_id\";i:2;s:20:\"master_category_name\";s:12:\"GIRL FASHION\";s:20:\"master_category_slug\";s:12:\"girl-fashion\";s:15:\"section_type_id\";i:7;s:17:\"section_type_name\";s:14:\"SHOP BY BRANDS\";s:17:\"section_type_slug\";s:14:\"shop-by-brands\";s:11:\"category_id\";i:73;s:13:\"category_name\";s:11:\"Kookie Kids\";s:13:\"category_slug\";s:11:\"kookie-kids\";}i:183;a:10:{s:26:\"master_category_section_id\";i:184;s:18:\"master_category_id\";i:2;s:20:\"master_category_name\";s:12:\"GIRL FASHION\";s:20:\"master_category_slug\";s:12:\"girl-fashion\";s:15:\"section_type_id\";i:7;s:17:\"section_type_name\";s:14:\"SHOP BY BRANDS\";s:17:\"section_type_slug\";s:14:\"shop-by-brands\";s:11:\"category_id\";i:72;s:13:\"category_name\";s:7:\"Babyoye\";s:13:\"category_slug\";s:7:\"babyoye\";}i:184;a:10:{s:26:\"master_category_section_id\";i:185;s:18:\"master_category_id\";i:2;s:20:\"master_category_name\";s:12:\"GIRL FASHION\";s:20:\"master_category_slug\";s:12:\"girl-fashion\";s:15:\"section_type_id\";i:7;s:17:\"section_type_name\";s:14:\"SHOP BY BRANDS\";s:17:\"section_type_slug\";s:14:\"shop-by-brands\";s:11:\"category_id\";i:75;s:13:\"category_name\";s:9:\"Pine Kids\";s:13:\"category_slug\";s:9:\"pine-kids\";}i:185;a:10:{s:26:\"master_category_section_id\";i:186;s:18:\"master_category_id\";i:2;s:20:\"master_category_name\";s:12:\"GIRL FASHION\";s:20:\"master_category_slug\";s:12:\"girl-fashion\";s:15:\"section_type_id\";i:7;s:17:\"section_type_name\";s:14:\"SHOP BY BRANDS\";s:17:\"section_type_slug\";s:14:\"shop-by-brands\";s:11:\"category_id\";i:74;s:13:\"category_name\";s:8:\"Carter\'s\";s:13:\"category_slug\";s:7:\"carters\";}i:186;a:10:{s:26:\"master_category_section_id\";i:187;s:18:\"master_category_id\";i:2;s:20:\"master_category_name\";s:12:\"GIRL FASHION\";s:20:\"master_category_slug\";s:12:\"girl-fashion\";s:15:\"section_type_id\";i:7;s:17:\"section_type_name\";s:14:\"SHOP BY BRANDS\";s:17:\"section_type_slug\";s:14:\"shop-by-brands\";s:11:\"category_id\";i:116;s:13:\"category_name\";s:8:\"Cutewalk\";s:13:\"category_slug\";s:8:\"cutewalk\";}i:187;a:10:{s:26:\"master_category_section_id\";i:188;s:18:\"master_category_id\";i:2;s:20:\"master_category_name\";s:12:\"GIRL FASHION\";s:20:\"master_category_slug\";s:12:\"girl-fashion\";s:15:\"section_type_id\";i:7;s:17:\"section_type_name\";s:14:\"SHOP BY BRANDS\";s:17:\"section_type_slug\";s:14:\"shop-by-brands\";s:11:\"category_id\";i:81;s:13:\"category_name\";s:10:\"Mark & Mia\";s:13:\"category_slug\";s:8:\"mark-mia\";}i:188;a:10:{s:26:\"master_category_section_id\";i:189;s:18:\"master_category_id\";i:2;s:20:\"master_category_name\";s:12:\"GIRL FASHION\";s:20:\"master_category_slug\";s:12:\"girl-fashion\";s:15:\"section_type_id\";i:7;s:17:\"section_type_name\";s:14:\"SHOP BY BRANDS\";s:17:\"section_type_slug\";s:14:\"shop-by-brands\";s:11:\"category_id\";i:77;s:13:\"category_name\";s:8:\"Honeyhap\";s:13:\"category_slug\";s:8:\"honeyhap\";}i:189;a:10:{s:26:\"master_category_section_id\";i:190;s:18:\"master_category_id\";i:2;s:20:\"master_category_name\";s:12:\"GIRL FASHION\";s:20:\"master_category_slug\";s:12:\"girl-fashion\";s:15:\"section_type_id\";i:7;s:17:\"section_type_name\";s:14:\"SHOP BY BRANDS\";s:17:\"section_type_slug\";s:14:\"shop-by-brands\";s:11:\"category_id\";i:117;s:13:\"category_name\";s:11:\"Hola Bonita\";s:13:\"category_slug\";s:11:\"hola-bonita\";}i:190;a:10:{s:26:\"master_category_section_id\";i:191;s:18:\"master_category_id\";i:2;s:20:\"master_category_name\";s:12:\"GIRL FASHION\";s:20:\"master_category_slug\";s:12:\"girl-fashion\";s:15:\"section_type_id\";i:7;s:17:\"section_type_name\";s:14:\"SHOP BY BRANDS\";s:17:\"section_type_slug\";s:14:\"shop-by-brands\";s:11:\"category_id\";i:78;s:13:\"category_name\";s:13:\"OLLINGTON ST.\";s:13:\"category_slug\";s:12:\"ollington-st\";}i:191;a:10:{s:26:\"master_category_section_id\";i:192;s:18:\"master_category_id\";i:2;s:20:\"master_category_name\";s:12:\"GIRL FASHION\";s:20:\"master_category_slug\";s:12:\"girl-fashion\";s:15:\"section_type_id\";i:7;s:17:\"section_type_name\";s:14:\"SHOP BY BRANDS\";s:17:\"section_type_slug\";s:14:\"shop-by-brands\";s:11:\"category_id\";i:79;s:13:\"category_name\";s:13:\"Doodle Poodle\";s:13:\"category_slug\";s:13:\"doodle-poodle\";}i:192;a:10:{s:26:\"master_category_section_id\";i:193;s:18:\"master_category_id\";i:2;s:20:\"master_category_name\";s:12:\"GIRL FASHION\";s:20:\"master_category_slug\";s:12:\"girl-fashion\";s:15:\"section_type_id\";i:7;s:17:\"section_type_name\";s:14:\"SHOP BY BRANDS\";s:17:\"section_type_slug\";s:14:\"shop-by-brands\";s:11:\"category_id\";i:83;s:13:\"category_name\";s:12:\"Earthy Touch\";s:13:\"category_slug\";s:12:\"earthy-touch\";}i:193;a:10:{s:26:\"master_category_section_id\";i:194;s:18:\"master_category_id\";i:2;s:20:\"master_category_name\";s:12:\"GIRL FASHION\";s:20:\"master_category_slug\";s:12:\"girl-fashion\";s:15:\"section_type_id\";i:7;s:17:\"section_type_name\";s:14:\"SHOP BY BRANDS\";s:17:\"section_type_slug\";s:14:\"shop-by-brands\";s:11:\"category_id\";i:80;s:13:\"category_name\";s:10:\"Primo Gino\";s:13:\"category_slug\";s:10:\"primo-gino\";}i:194;a:10:{s:26:\"master_category_section_id\";i:195;s:18:\"master_category_id\";i:2;s:20:\"master_category_name\";s:12:\"GIRL FASHION\";s:20:\"master_category_slug\";s:12:\"girl-fashion\";s:15:\"section_type_id\";i:7;s:17:\"section_type_name\";s:14:\"SHOP BY BRANDS\";s:17:\"section_type_slug\";s:14:\"shop-by-brands\";s:11:\"category_id\";i:82;s:13:\"category_name\";s:7:\"Bonfino\";s:13:\"category_slug\";s:7:\"bonfino\";}i:195;a:10:{s:26:\"master_category_section_id\";i:196;s:18:\"master_category_id\";i:2;s:20:\"master_category_name\";s:12:\"GIRL FASHION\";s:20:\"master_category_slug\";s:12:\"girl-fashion\";s:15:\"section_type_id\";i:7;s:17:\"section_type_name\";s:14:\"SHOP BY BRANDS\";s:17:\"section_type_slug\";s:14:\"shop-by-brands\";s:11:\"category_id\";i:84;s:13:\"category_name\";s:19:\"Arias by Lara Dutta\";s:13:\"category_slug\";s:19:\"arias-by-lara-dutta\";}i:196;a:10:{s:26:\"master_category_section_id\";i:197;s:18:\"master_category_id\";i:2;s:20:\"master_category_name\";s:12:\"GIRL FASHION\";s:20:\"master_category_slug\";s:12:\"girl-fashion\";s:15:\"section_type_id\";i:7;s:17:\"section_type_name\";s:14:\"SHOP BY BRANDS\";s:17:\"section_type_slug\";s:14:\"shop-by-brands\";s:11:\"category_id\";i:85;s:13:\"category_name\";s:11:\"Pine Active\";s:13:\"category_slug\";s:11:\"pine-active\";}i:197;a:10:{s:26:\"master_category_section_id\";i:198;s:18:\"master_category_id\";i:2;s:20:\"master_category_name\";s:12:\"GIRL FASHION\";s:20:\"master_category_slug\";s:12:\"girl-fashion\";s:15:\"section_type_id\";i:7;s:17:\"section_type_name\";s:14:\"SHOP BY BRANDS\";s:17:\"section_type_slug\";s:14:\"shop-by-brands\";s:11:\"category_id\";i:86;s:13:\"category_name\";s:10:\"ToffyHouse\";s:13:\"category_slug\";s:10:\"toffyhouse\";}i:198;a:10:{s:26:\"master_category_section_id\";i:199;s:18:\"master_category_id\";i:2;s:20:\"master_category_name\";s:12:\"GIRL FASHION\";s:20:\"master_category_slug\";s:12:\"girl-fashion\";s:15:\"section_type_id\";i:7;s:17:\"section_type_name\";s:14:\"SHOP BY BRANDS\";s:17:\"section_type_slug\";s:14:\"shop-by-brands\";s:11:\"category_id\";i:87;s:13:\"category_name\";s:9:\"Taffykids\";s:13:\"category_slug\";s:9:\"taffykids\";}i:199;a:10:{s:26:\"master_category_section_id\";i:200;s:18:\"master_category_id\";i:2;s:20:\"master_category_name\";s:12:\"GIRL FASHION\";s:20:\"master_category_slug\";s:12:\"girl-fashion\";s:15:\"section_type_id\";i:7;s:17:\"section_type_name\";s:14:\"SHOP BY BRANDS\";s:17:\"section_type_slug\";s:14:\"shop-by-brands\";s:11:\"category_id\";i:88;s:13:\"category_name\";s:10:\"Ed-a-mamma\";s:13:\"category_slug\";s:10:\"ed-a-mamma\";}i:200;a:10:{s:26:\"master_category_section_id\";i:201;s:18:\"master_category_id\";i:2;s:20:\"master_category_name\";s:12:\"GIRL FASHION\";s:20:\"master_category_slug\";s:12:\"girl-fashion\";s:15:\"section_type_id\";i:7;s:17:\"section_type_name\";s:14:\"SHOP BY BRANDS\";s:17:\"section_type_slug\";s:14:\"shop-by-brands\";s:11:\"category_id\";i:93;s:13:\"category_name\";s:4:\"Puma\";s:13:\"category_slug\";s:4:\"puma\";}i:201;a:10:{s:26:\"master_category_section_id\";i:202;s:18:\"master_category_id\";i:2;s:20:\"master_category_name\";s:12:\"GIRL FASHION\";s:20:\"master_category_slug\";s:12:\"girl-fashion\";s:15:\"section_type_id\";i:7;s:17:\"section_type_name\";s:14:\"SHOP BY BRANDS\";s:17:\"section_type_slug\";s:14:\"shop-by-brands\";s:11:\"category_id\";i:97;s:13:\"category_name\";s:10:\"ASICS Kids\";s:13:\"category_slug\";s:10:\"asics-kids\";}i:202;a:10:{s:26:\"master_category_section_id\";i:203;s:18:\"master_category_id\";i:2;s:20:\"master_category_name\";s:12:\"GIRL FASHION\";s:20:\"master_category_slug\";s:12:\"girl-fashion\";s:15:\"section_type_id\";i:7;s:17:\"section_type_name\";s:14:\"SHOP BY BRANDS\";s:17:\"section_type_slug\";s:14:\"shop-by-brands\";s:11:\"category_id\";i:95;s:13:\"category_name\";s:11:\"ADIDAS KIDS\";s:13:\"category_slug\";s:11:\"adidas-kids\";}i:203;a:10:{s:26:\"master_category_section_id\";i:204;s:18:\"master_category_id\";i:2;s:20:\"master_category_name\";s:12:\"GIRL FASHION\";s:20:\"master_category_slug\";s:12:\"girl-fashion\";s:15:\"section_type_id\";i:7;s:17:\"section_type_name\";s:14:\"SHOP BY BRANDS\";s:17:\"section_type_slug\";s:14:\"shop-by-brands\";s:11:\"category_id\";i:89;s:13:\"category_name\";s:3:\"UCB\";s:13:\"category_slug\";s:3:\"ucb\";}i:204;a:10:{s:26:\"master_category_section_id\";i:205;s:18:\"master_category_id\";i:2;s:20:\"master_category_name\";s:12:\"GIRL FASHION\";s:20:\"master_category_slug\";s:12:\"girl-fashion\";s:15:\"section_type_id\";i:7;s:17:\"section_type_name\";s:14:\"SHOP BY BRANDS\";s:17:\"section_type_slug\";s:14:\"shop-by-brands\";s:11:\"category_id\";i:92;s:13:\"category_name\";s:11:\"Gini & Jony\";s:13:\"category_slug\";s:9:\"gini-jony\";}i:205;a:10:{s:26:\"master_category_section_id\";i:206;s:18:\"master_category_id\";i:2;s:20:\"master_category_name\";s:12:\"GIRL FASHION\";s:20:\"master_category_slug\";s:12:\"girl-fashion\";s:15:\"section_type_id\";i:7;s:17:\"section_type_name\";s:14:\"SHOP BY BRANDS\";s:17:\"section_type_slug\";s:14:\"shop-by-brands\";s:11:\"category_id\";i:118;s:13:\"category_name\";s:11:\"Global Desi\";s:13:\"category_slug\";s:11:\"global-desi\";}i:206;a:10:{s:26:\"master_category_section_id\";i:207;s:18:\"master_category_id\";i:2;s:20:\"master_category_name\";s:12:\"GIRL FASHION\";s:20:\"master_category_slug\";s:12:\"girl-fashion\";s:15:\"section_type_id\";i:7;s:17:\"section_type_name\";s:14:\"SHOP BY BRANDS\";s:17:\"section_type_slug\";s:14:\"shop-by-brands\";s:11:\"category_id\";i:119;s:13:\"category_name\";s:8:\"And Girl\";s:13:\"category_slug\";s:8:\"and-girl\";}i:207;a:10:{s:26:\"master_category_section_id\";i:208;s:18:\"master_category_id\";i:2;s:20:\"master_category_name\";s:12:\"GIRL FASHION\";s:20:\"master_category_slug\";s:12:\"girl-fashion\";s:15:\"section_type_id\";i:7;s:17:\"section_type_name\";s:14:\"SHOP BY BRANDS\";s:17:\"section_type_slug\";s:14:\"shop-by-brands\";s:11:\"category_id\";i:94;s:13:\"category_name\";s:14:\"Tommy Hilfiger\";s:13:\"category_slug\";s:14:\"tommy-hilfiger\";}i:208;a:10:{s:26:\"master_category_section_id\";i:209;s:18:\"master_category_id\";i:2;s:20:\"master_category_name\";s:12:\"GIRL FASHION\";s:20:\"master_category_slug\";s:12:\"girl-fashion\";s:15:\"section_type_id\";i:7;s:17:\"section_type_name\";s:14:\"SHOP BY BRANDS\";s:17:\"section_type_slug\";s:14:\"shop-by-brands\";s:11:\"category_id\";i:120;s:13:\"category_name\";s:4:\"NIKE\";s:13:\"category_slug\";s:4:\"nike\";}i:209;a:10:{s:26:\"master_category_section_id\";i:210;s:18:\"master_category_id\";i:3;s:20:\"master_category_name\";s:8:\"FOOTWEAR\";s:20:\"master_category_slug\";s:8:\"footwear\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:54;s:13:\"category_name\";s:10:\"Flip Flops\";s:13:\"category_slug\";s:10:\"flip-flops\";}i:210;a:10:{s:26:\"master_category_section_id\";i:211;s:18:\"master_category_id\";i:3;s:20:\"master_category_name\";s:8:\"FOOTWEAR\";s:20:\"master_category_slug\";s:8:\"footwear\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:55;s:13:\"category_name\";s:5:\"Clogs\";s:13:\"category_slug\";s:5:\"clogs\";}i:211;a:10:{s:26:\"master_category_section_id\";i:212;s:18:\"master_category_id\";i:3;s:20:\"master_category_name\";s:8:\"FOOTWEAR\";s:20:\"master_category_slug\";s:8:\"footwear\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:56;s:13:\"category_name\";s:7:\"Sandals\";s:13:\"category_slug\";s:7:\"sandals\";}i:212;a:10:{s:26:\"master_category_section_id\";i:213;s:18:\"master_category_id\";i:3;s:20:\"master_category_name\";s:8:\"FOOTWEAR\";s:20:\"master_category_slug\";s:8:\"footwear\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:57;s:13:\"category_name\";s:10:\"Pool Shoes\";s:13:\"category_slug\";s:10:\"pool-shoes\";}i:213;a:10:{s:26:\"master_category_section_id\";i:214;s:18:\"master_category_id\";i:3;s:20:\"master_category_name\";s:8:\"FOOTWEAR\";s:20:\"master_category_slug\";s:8:\"footwear\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:115;s:13:\"category_name\";s:10:\"Ballerinas\";s:13:\"category_slug\";s:10:\"ballerinas\";}i:214;a:10:{s:26:\"master_category_section_id\";i:215;s:18:\"master_category_id\";i:3;s:20:\"master_category_name\";s:8:\"FOOTWEAR\";s:20:\"master_category_slug\";s:8:\"footwear\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:58;s:13:\"category_name\";s:12:\"Casual Shoes\";s:13:\"category_slug\";s:12:\"casual-shoes\";}i:215;a:10:{s:26:\"master_category_section_id\";i:216;s:18:\"master_category_id\";i:3;s:20:\"master_category_name\";s:8:\"FOOTWEAR\";s:20:\"master_category_slug\";s:8:\"footwear\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:59;s:13:\"category_name\";s:12:\"Sports Shoes\";s:13:\"category_slug\";s:12:\"sports-shoes\";}i:216;a:10:{s:26:\"master_category_section_id\";i:217;s:18:\"master_category_id\";i:3;s:20:\"master_category_name\";s:8:\"FOOTWEAR\";s:20:\"master_category_slug\";s:8:\"footwear\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:60;s:13:\"category_name\";s:8:\"Sneakers\";s:13:\"category_slug\";s:8:\"sneakers\";}i:217;a:10:{s:26:\"master_category_section_id\";i:218;s:18:\"master_category_id\";i:3;s:20:\"master_category_name\";s:8:\"FOOTWEAR\";s:20:\"master_category_slug\";s:8:\"footwear\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:62;s:13:\"category_name\";s:12:\"Winter Boots\";s:13:\"category_slug\";s:12:\"winter-boots\";}i:218;a:10:{s:26:\"master_category_section_id\";i:219;s:18:\"master_category_id\";i:3;s:20:\"master_category_name\";s:8:\"FOOTWEAR\";s:20:\"master_category_slug\";s:8:\"footwear\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:121;s:13:\"category_name\";s:19:\"Formal & Party Wear\";s:13:\"category_slug\";s:17:\"formal-party-wear\";}i:219;a:10:{s:26:\"master_category_section_id\";i:220;s:18:\"master_category_id\";i:3;s:20:\"master_category_name\";s:8:\"FOOTWEAR\";s:20:\"master_category_slug\";s:8:\"footwear\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:63;s:13:\"category_name\";s:7:\"Booties\";s:13:\"category_slug\";s:7:\"booties\";}i:220;a:10:{s:26:\"master_category_section_id\";i:221;s:18:\"master_category_id\";i:3;s:20:\"master_category_name\";s:8:\"FOOTWEAR\";s:20:\"master_category_slug\";s:8:\"footwear\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:64;s:13:\"category_name\";s:12:\"School Shoes\";s:13:\"category_slug\";s:12:\"school-shoes\";}i:221;a:10:{s:26:\"master_category_section_id\";i:222;s:18:\"master_category_id\";i:3;s:20:\"master_category_name\";s:8:\"FOOTWEAR\";s:20:\"master_category_slug\";s:8:\"footwear\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:66;s:13:\"category_name\";s:23:\"Mojaris/Ethnic Footwear\";s:13:\"category_slug\";s:22:\"mojarisethnic-footwear\";}i:222;a:10:{s:26:\"master_category_section_id\";i:223;s:18:\"master_category_id\";i:3;s:20:\"master_category_name\";s:8:\"FOOTWEAR\";s:20:\"master_category_slug\";s:8:\"footwear\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:65;s:13:\"category_name\";s:9:\"LED Shoes\";s:13:\"category_slug\";s:9:\"led-shoes\";}i:223;a:10:{s:26:\"master_category_section_id\";i:224;s:18:\"master_category_id\";i:3;s:20:\"master_category_name\";s:8:\"FOOTWEAR\";s:20:\"master_category_slug\";s:8:\"footwear\";s:15:\"section_type_id\";i:8;s:17:\"section_type_name\";s:10:\"DON\'T MISS\";s:17:\"section_type_slug\";s:9:\"dont-miss\";s:11:\"category_id\";i:122;s:13:\"category_name\";s:10:\"Sock Shoes\";s:13:\"category_slug\";s:10:\"sock-shoes\";}i:224;a:10:{s:26:\"master_category_section_id\";i:225;s:18:\"master_category_id\";i:3;s:20:\"master_category_name\";s:8:\"FOOTWEAR\";s:20:\"master_category_slug\";s:8:\"footwear\";s:15:\"section_type_id\";i:8;s:17:\"section_type_name\";s:10:\"DON\'T MISS\";s:17:\"section_type_slug\";s:9:\"dont-miss\";s:11:\"category_id\";i:21;s:13:\"category_name\";s:5:\"Socks\";s:13:\"category_slug\";s:5:\"socks\";}i:225;a:10:{s:26:\"master_category_section_id\";i:226;s:18:\"master_category_id\";i:3;s:20:\"master_category_name\";s:8:\"FOOTWEAR\";s:20:\"master_category_slug\";s:8:\"footwear\";s:15:\"section_type_id\";i:8;s:17:\"section_type_name\";s:10:\"DON\'T MISS\";s:17:\"section_type_slug\";s:9:\"dont-miss\";s:11:\"category_id\";i:123;s:13:\"category_name\";s:18:\"Stockings & Tights\";s:13:\"category_slug\";s:16:\"stockings-tights\";}i:226;a:10:{s:26:\"master_category_section_id\";i:227;s:18:\"master_category_id\";i:3;s:20:\"master_category_name\";s:8:\"FOOTWEAR\";s:20:\"master_category_slug\";s:8:\"footwear\";s:15:\"section_type_id\";i:3;s:17:\"section_type_name\";s:11:\"SHOP BY AGE\";s:17:\"section_type_slug\";s:11:\"shop-by-age\";s:11:\"category_id\";i:38;s:13:\"category_name\";s:16:\"New Born (0-3 M)\";s:13:\"category_slug\";s:14:\"new-born-0-3-m\";}i:227;a:10:{s:26:\"master_category_section_id\";i:228;s:18:\"master_category_id\";i:3;s:20:\"master_category_name\";s:8:\"FOOTWEAR\";s:20:\"master_category_slug\";s:8:\"footwear\";s:15:\"section_type_id\";i:3;s:17:\"section_type_name\";s:11:\"SHOP BY AGE\";s:17:\"section_type_slug\";s:11:\"shop-by-age\";s:11:\"category_id\";i:39;s:13:\"category_name\";s:10:\"3-6 Months\";s:13:\"category_slug\";s:10:\"3-6-months\";}i:228;a:10:{s:26:\"master_category_section_id\";i:229;s:18:\"master_category_id\";i:3;s:20:\"master_category_name\";s:8:\"FOOTWEAR\";s:20:\"master_category_slug\";s:8:\"footwear\";s:15:\"section_type_id\";i:3;s:17:\"section_type_name\";s:11:\"SHOP BY AGE\";s:17:\"section_type_slug\";s:11:\"shop-by-age\";s:11:\"category_id\";i:40;s:13:\"category_name\";s:10:\"6-9 Months\";s:13:\"category_slug\";s:10:\"6-9-months\";}i:229;a:10:{s:26:\"master_category_section_id\";i:230;s:18:\"master_category_id\";i:3;s:20:\"master_category_name\";s:8:\"FOOTWEAR\";s:20:\"master_category_slug\";s:8:\"footwear\";s:15:\"section_type_id\";i:3;s:17:\"section_type_name\";s:11:\"SHOP BY AGE\";s:17:\"section_type_slug\";s:11:\"shop-by-age\";s:11:\"category_id\";i:41;s:13:\"category_name\";s:11:\"9-12 Months\";s:13:\"category_slug\";s:11:\"9-12-months\";}i:230;a:10:{s:26:\"master_category_section_id\";i:231;s:18:\"master_category_id\";i:3;s:20:\"master_category_name\";s:8:\"FOOTWEAR\";s:20:\"master_category_slug\";s:8:\"footwear\";s:15:\"section_type_id\";i:3;s:17:\"section_type_name\";s:11:\"SHOP BY AGE\";s:17:\"section_type_slug\";s:11:\"shop-by-age\";s:11:\"category_id\";i:42;s:13:\"category_name\";s:12:\"12-18 Months\";s:13:\"category_slug\";s:12:\"12-18-months\";}i:231;a:10:{s:26:\"master_category_section_id\";i:232;s:18:\"master_category_id\";i:3;s:20:\"master_category_name\";s:8:\"FOOTWEAR\";s:20:\"master_category_slug\";s:8:\"footwear\";s:15:\"section_type_id\";i:3;s:17:\"section_type_name\";s:11:\"SHOP BY AGE\";s:17:\"section_type_slug\";s:11:\"shop-by-age\";s:11:\"category_id\";i:43;s:13:\"category_name\";s:12:\"18-24 Months\";s:13:\"category_slug\";s:12:\"18-24-months\";}i:232;a:10:{s:26:\"master_category_section_id\";i:233;s:18:\"master_category_id\";i:3;s:20:\"master_category_name\";s:8:\"FOOTWEAR\";s:20:\"master_category_slug\";s:8:\"footwear\";s:15:\"section_type_id\";i:3;s:17:\"section_type_name\";s:11:\"SHOP BY AGE\";s:17:\"section_type_slug\";s:11:\"shop-by-age\";s:11:\"category_id\";i:44;s:13:\"category_name\";s:12:\"2 to 4 Years\";s:13:\"category_slug\";s:12:\"2-to-4-years\";}i:233;a:10:{s:26:\"master_category_section_id\";i:234;s:18:\"master_category_id\";i:3;s:20:\"master_category_name\";s:8:\"FOOTWEAR\";s:20:\"master_category_slug\";s:8:\"footwear\";s:15:\"section_type_id\";i:3;s:17:\"section_type_name\";s:11:\"SHOP BY AGE\";s:17:\"section_type_slug\";s:11:\"shop-by-age\";s:11:\"category_id\";i:45;s:13:\"category_name\";s:12:\"4 to 6 Years\";s:13:\"category_slug\";s:12:\"4-to-6-years\";}i:234;a:10:{s:26:\"master_category_section_id\";i:235;s:18:\"master_category_id\";i:3;s:20:\"master_category_name\";s:8:\"FOOTWEAR\";s:20:\"master_category_slug\";s:8:\"footwear\";s:15:\"section_type_id\";i:3;s:17:\"section_type_name\";s:11:\"SHOP BY AGE\";s:17:\"section_type_slug\";s:11:\"shop-by-age\";s:11:\"category_id\";i:46;s:13:\"category_name\";s:12:\"6 to 8 Years\";s:13:\"category_slug\";s:12:\"6-to-8-years\";}i:235;a:10:{s:26:\"master_category_section_id\";i:236;s:18:\"master_category_id\";i:3;s:20:\"master_category_name\";s:8:\"FOOTWEAR\";s:20:\"master_category_slug\";s:8:\"footwear\";s:15:\"section_type_id\";i:3;s:17:\"section_type_name\";s:11:\"SHOP BY AGE\";s:17:\"section_type_slug\";s:11:\"shop-by-age\";s:11:\"category_id\";i:47;s:13:\"category_name\";s:8:\"8+ Years\";s:13:\"category_slug\";s:7:\"8-years\";}i:236;a:10:{s:26:\"master_category_section_id\";i:237;s:18:\"master_category_id\";i:3;s:20:\"master_category_name\";s:8:\"FOOTWEAR\";s:20:\"master_category_slug\";s:8:\"footwear\";s:15:\"section_type_id\";i:9;s:17:\"section_type_name\";s:13:\"SHOP BY BRAND\";s:17:\"section_type_slug\";s:13:\"shop-by-brand\";s:11:\"category_id\";i:116;s:13:\"category_name\";s:8:\"Cutewalk\";s:13:\"category_slug\";s:8:\"cutewalk\";}i:237;a:10:{s:26:\"master_category_section_id\";i:238;s:18:\"master_category_id\";i:3;s:20:\"master_category_name\";s:8:\"FOOTWEAR\";s:20:\"master_category_slug\";s:8:\"footwear\";s:15:\"section_type_id\";i:9;s:17:\"section_type_name\";s:13:\"SHOP BY BRAND\";s:17:\"section_type_slug\";s:13:\"shop-by-brand\";s:11:\"category_id\";i:124;s:13:\"category_name\";s:8:\"Pinekids\";s:13:\"category_slug\";s:8:\"pinekids\";}i:238;a:10:{s:26:\"master_category_section_id\";i:239;s:18:\"master_category_id\";i:3;s:20:\"master_category_name\";s:8:\"FOOTWEAR\";s:20:\"master_category_slug\";s:8:\"footwear\";s:15:\"section_type_id\";i:9;s:17:\"section_type_name\";s:13:\"SHOP BY BRAND\";s:17:\"section_type_slug\";s:13:\"shop-by-brand\";s:11:\"category_id\";i:72;s:13:\"category_name\";s:7:\"Babyoye\";s:13:\"category_slug\";s:7:\"babyoye\";}i:239;a:10:{s:26:\"master_category_section_id\";i:240;s:18:\"master_category_id\";i:3;s:20:\"master_category_name\";s:8:\"FOOTWEAR\";s:20:\"master_category_slug\";s:8:\"footwear\";s:15:\"section_type_id\";i:9;s:17:\"section_type_name\";s:13:\"SHOP BY BRAND\";s:17:\"section_type_slug\";s:13:\"shop-by-brand\";s:11:\"category_id\";i:93;s:13:\"category_name\";s:4:\"Puma\";s:13:\"category_slug\";s:4:\"puma\";}i:240;a:10:{s:26:\"master_category_section_id\";i:241;s:18:\"master_category_id\";i:3;s:20:\"master_category_name\";s:8:\"FOOTWEAR\";s:20:\"master_category_slug\";s:8:\"footwear\";s:15:\"section_type_id\";i:9;s:17:\"section_type_name\";s:13:\"SHOP BY BRAND\";s:17:\"section_type_slug\";s:13:\"shop-by-brand\";s:11:\"category_id\";i:95;s:13:\"category_name\";s:11:\"ADIDAS KIDS\";s:13:\"category_slug\";s:11:\"adidas-kids\";}i:241;a:10:{s:26:\"master_category_section_id\";i:242;s:18:\"master_category_id\";i:3;s:20:\"master_category_name\";s:8:\"FOOTWEAR\";s:20:\"master_category_slug\";s:8:\"footwear\";s:15:\"section_type_id\";i:9;s:17:\"section_type_name\";s:13:\"SHOP BY BRAND\";s:17:\"section_type_slug\";s:13:\"shop-by-brand\";s:11:\"category_id\";i:125;s:13:\"category_name\";s:8:\"Skechers\";s:13:\"category_slug\";s:8:\"skechers\";}i:242;a:10:{s:26:\"master_category_section_id\";i:243;s:18:\"master_category_id\";i:3;s:20:\"master_category_name\";s:8:\"FOOTWEAR\";s:20:\"master_category_slug\";s:8:\"footwear\";s:15:\"section_type_id\";i:9;s:17:\"section_type_name\";s:13:\"SHOP BY BRAND\";s:17:\"section_type_slug\";s:13:\"shop-by-brand\";s:11:\"category_id\";i:126;s:13:\"category_name\";s:6:\"Campus\";s:13:\"category_slug\";s:6:\"campus\";}i:243;a:10:{s:26:\"master_category_section_id\";i:244;s:18:\"master_category_id\";i:3;s:20:\"master_category_name\";s:8:\"FOOTWEAR\";s:20:\"master_category_slug\";s:8:\"footwear\";s:15:\"section_type_id\";i:9;s:17:\"section_type_name\";s:13:\"SHOP BY BRAND\";s:17:\"section_type_slug\";s:13:\"shop-by-brand\";s:11:\"category_id\";i:127;s:13:\"category_name\";s:8:\"Kazarmax\";s:13:\"category_slug\";s:8:\"kazarmax\";}i:244;a:10:{s:26:\"master_category_section_id\";i:245;s:18:\"master_category_id\";i:3;s:20:\"master_category_name\";s:8:\"FOOTWEAR\";s:20:\"master_category_slug\";s:8:\"footwear\";s:15:\"section_type_id\";i:9;s:17:\"section_type_name\";s:13:\"SHOP BY BRAND\";s:17:\"section_type_slug\";s:13:\"shop-by-brand\";s:11:\"category_id\";i:97;s:13:\"category_name\";s:10:\"ASICS Kids\";s:13:\"category_slug\";s:10:\"asics-kids\";}i:245;a:10:{s:26:\"master_category_section_id\";i:246;s:18:\"master_category_id\";i:4;s:20:\"master_category_name\";s:4:\"TOYS\";s:20:\"master_category_slug\";s:4:\"toys\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:128;s:13:\"category_name\";s:12:\"Musical Toys\";s:13:\"category_slug\";s:12:\"musical-toys\";}i:246;a:10:{s:26:\"master_category_section_id\";i:247;s:18:\"master_category_id\";i:4;s:20:\"master_category_name\";s:4:\"TOYS\";s:20:\"master_category_slug\";s:4:\"toys\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:129;s:13:\"category_name\";s:27:\"Learning & Educational Toys\";s:13:\"category_slug\";s:25:\"learning-educational-toys\";}i:247;a:10:{s:26:\"master_category_section_id\";i:248;s:18:\"master_category_id\";i:4;s:20:\"master_category_name\";s:4:\"TOYS\";s:20:\"master_category_slug\";s:4:\"toys\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:130;s:13:\"category_name\";s:9:\"Soft Toys\";s:13:\"category_slug\";s:9:\"soft-toys\";}i:248;a:10:{s:26:\"master_category_section_id\";i:249;s:18:\"master_category_id\";i:4;s:20:\"master_category_name\";s:4:\"TOYS\";s:20:\"master_category_slug\";s:4:\"toys\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:131;s:13:\"category_name\";s:21:\"Indoor & Outdoor Play\";s:13:\"category_slug\";s:19:\"indoor-outdoor-play\";}i:249;a:10:{s:26:\"master_category_section_id\";i:250;s:18:\"master_category_id\";i:4;s:20:\"master_category_name\";s:4:\"TOYS\";s:20:\"master_category_slug\";s:4:\"toys\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:132;s:13:\"category_name\";s:20:\"Play Gyms & Playmats\";s:13:\"category_slug\";s:18:\"play-gyms-playmats\";}i:250;a:10:{s:26:\"master_category_section_id\";i:251;s:18:\"master_category_id\";i:4;s:20:\"master_category_name\";s:4:\"TOYS\";s:20:\"master_category_slug\";s:4:\"toys\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:133;s:13:\"category_name\";s:14:\"Sports & Games\";s:13:\"category_slug\";s:12:\"sports-games\";}i:251;a:10:{s:26:\"master_category_section_id\";i:252;s:18:\"master_category_id\";i:4;s:20:\"master_category_name\";s:4:\"TOYS\";s:20:\"master_category_slug\";s:4:\"toys\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:134;s:13:\"category_name\";s:24:\"Role & Pretend Play Toys\";s:13:\"category_slug\";s:22:\"role-pretend-play-toys\";}i:252;a:10:{s:26:\"master_category_section_id\";i:253;s:18:\"master_category_id\";i:4;s:20:\"master_category_name\";s:4:\"TOYS\";s:20:\"master_category_slug\";s:4:\"toys\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:135;s:13:\"category_name\";s:26:\"Blocks & Construction Sets\";s:13:\"category_slug\";s:24:\"blocks-construction-sets\";}i:253;a:10:{s:26:\"master_category_section_id\";i:254;s:18:\"master_category_id\";i:4;s:20:\"master_category_name\";s:4:\"TOYS\";s:20:\"master_category_slug\";s:4:\"toys\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:136;s:13:\"category_name\";s:13:\"Stacking Toys\";s:13:\"category_slug\";s:13:\"stacking-toys\";}i:254;a:10:{s:26:\"master_category_section_id\";i:255;s:18:\"master_category_id\";i:4;s:20:\"master_category_name\";s:4:\"TOYS\";s:20:\"master_category_slug\";s:4:\"toys\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:137;s:13:\"category_name\";s:12:\"Kids Puzzles\";s:13:\"category_slug\";s:12:\"kids-puzzles\";}i:255;a:10:{s:26:\"master_category_section_id\";i:256;s:18:\"master_category_id\";i:4;s:20:\"master_category_name\";s:4:\"TOYS\";s:20:\"master_category_slug\";s:4:\"toys\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:138;s:13:\"category_name\";s:12:\"Baby Rattles\";s:13:\"category_slug\";s:12:\"baby-rattles\";}i:256;a:10:{s:26:\"master_category_section_id\";i:257;s:18:\"master_category_id\";i:4;s:20:\"master_category_name\";s:4:\"TOYS\";s:20:\"master_category_slug\";s:4:\"toys\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:139;s:13:\"category_name\";s:27:\"Toys Cars Trains & Vehicles\";s:13:\"category_slug\";s:25:\"toys-cars-trains-vehicles\";}i:257;a:10:{s:26:\"master_category_section_id\";i:258;s:18:\"master_category_id\";i:4;s:20:\"master_category_name\";s:4:\"TOYS\";s:20:\"master_category_slug\";s:4:\"toys\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:140;s:13:\"category_name\";s:24:\"Kids Musical Instruments\";s:13:\"category_slug\";s:24:\"kids-musical-instruments\";}i:258;a:10:{s:26:\"master_category_section_id\";i:259;s:18:\"master_category_id\";i:4;s:20:\"master_category_name\";s:4:\"TOYS\";s:20:\"master_category_slug\";s:4:\"toys\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:141;s:13:\"category_name\";s:18:\"Dolls & Dollhouses\";s:13:\"category_slug\";s:16:\"dolls-dollhouses\";}i:259;a:10:{s:26:\"master_category_section_id\";i:260;s:18:\"master_category_id\";i:4;s:20:\"master_category_name\";s:4:\"TOYS\";s:20:\"master_category_slug\";s:4:\"toys\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:142;s:13:\"category_name\";s:22:\"Push & Pull Along Toys\";s:13:\"category_slug\";s:20:\"push-pull-along-toys\";}i:260;a:10:{s:26:\"master_category_section_id\";i:261;s:18:\"master_category_id\";i:4;s:20:\"master_category_name\";s:4:\"TOYS\";s:20:\"master_category_slug\";s:4:\"toys\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:143;s:13:\"category_name\";s:23:\"Art Crafts & Hobby Kits\";s:13:\"category_slug\";s:21:\"art-crafts-hobby-kits\";}i:261;a:10:{s:26:\"master_category_section_id\";i:262;s:18:\"master_category_id\";i:4;s:20:\"master_category_name\";s:4:\"TOYS\";s:20:\"master_category_slug\";s:4:\"toys\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:144;s:13:\"category_name\";s:11:\"Board Games\";s:13:\"category_slug\";s:11:\"board-games\";}i:262;a:10:{s:26:\"master_category_section_id\";i:263;s:18:\"master_category_id\";i:4;s:20:\"master_category_name\";s:4:\"TOYS\";s:20:\"master_category_slug\";s:4:\"toys\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:145;s:13:\"category_name\";s:29:\"Action Figures & Collectibles\";s:13:\"category_slug\";s:27:\"action-figures-collectibles\";}i:263;a:10:{s:26:\"master_category_section_id\";i:264;s:18:\"master_category_id\";i:4;s:20:\"master_category_name\";s:4:\"TOYS\";s:20:\"master_category_slug\";s:4:\"toys\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:146;s:13:\"category_name\";s:27:\"Radio & Remote Control Toys\";s:13:\"category_slug\";s:25:\"radio-remote-control-toys\";}i:264;a:10:{s:26:\"master_category_section_id\";i:265;s:18:\"master_category_id\";i:4;s:20:\"master_category_name\";s:4:\"TOYS\";s:20:\"master_category_slug\";s:4:\"toys\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:147;s:13:\"category_name\";s:9:\"Bath Toys\";s:13:\"category_slug\";s:9:\"bath-toys\";}i:265;a:10:{s:26:\"master_category_section_id\";i:266;s:18:\"master_category_id\";i:4;s:20:\"master_category_name\";s:4:\"TOYS\";s:20:\"master_category_slug\";s:4:\"toys\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:148;s:13:\"category_name\";s:19:\"Toys Guns & Weapons\";s:13:\"category_slug\";s:17:\"toys-guns-weapons\";}i:266;a:10:{s:26:\"master_category_section_id\";i:267;s:18:\"master_category_id\";i:4;s:20:\"master_category_name\";s:4:\"TOYS\";s:20:\"master_category_slug\";s:4:\"toys\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:149;s:13:\"category_name\";s:26:\"PC Games & Gaming Consoles\";s:13:\"category_slug\";s:24:\"pc-games-gaming-consoles\";}i:267;a:10:{s:26:\"master_category_section_id\";i:268;s:18:\"master_category_id\";i:4;s:20:\"master_category_name\";s:4:\"TOYS\";s:20:\"master_category_slug\";s:4:\"toys\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:150;s:13:\"category_name\";s:12:\"Kids Gadgets\";s:13:\"category_slug\";s:12:\"kids-gadgets\";}i:268;a:10:{s:26:\"master_category_section_id\";i:269;s:18:\"master_category_id\";i:4;s:20:\"master_category_name\";s:4:\"TOYS\";s:20:\"master_category_slug\";s:4:\"toys\";s:15:\"section_type_id\";i:10;s:17:\"section_type_name\";s:19:\"RIDE-ONS & SCOOTERS\";s:17:\"section_type_slug\";s:17:\"ride-ons-scooters\";s:11:\"category_id\";i:151;s:13:\"category_name\";s:25:\"Battery Operated Ride-ons\";s:13:\"category_slug\";s:25:\"battery-operated-ride-ons\";}i:269;a:10:{s:26:\"master_category_section_id\";i:270;s:18:\"master_category_id\";i:4;s:20:\"master_category_name\";s:4:\"TOYS\";s:20:\"master_category_slug\";s:4:\"toys\";s:15:\"section_type_id\";i:10;s:17:\"section_type_name\";s:19:\"RIDE-ONS & SCOOTERS\";s:17:\"section_type_slug\";s:17:\"ride-ons-scooters\";s:11:\"category_id\";i:152;s:13:\"category_name\";s:20:\"Manual Push Ride-ons\";s:13:\"category_slug\";s:20:\"manual-push-ride-ons\";}i:270;a:10:{s:26:\"master_category_section_id\";i:271;s:18:\"master_category_id\";i:4;s:20:\"master_category_name\";s:4:\"TOYS\";s:20:\"master_category_slug\";s:4:\"toys\";s:15:\"section_type_id\";i:10;s:17:\"section_type_name\";s:19:\"RIDE-ONS & SCOOTERS\";s:17:\"section_type_slug\";s:17:\"ride-ons-scooters\";s:11:\"category_id\";i:153;s:13:\"category_name\";s:19:\"Swing cars/twisters\";s:13:\"category_slug\";s:18:\"swing-carstwisters\";}i:271;a:10:{s:26:\"master_category_section_id\";i:272;s:18:\"master_category_id\";i:4;s:20:\"master_category_name\";s:4:\"TOYS\";s:20:\"master_category_slug\";s:4:\"toys\";s:15:\"section_type_id\";i:10;s:17:\"section_type_name\";s:19:\"RIDE-ONS & SCOOTERS\";s:17:\"section_type_slug\";s:17:\"ride-ons-scooters\";s:11:\"category_id\";i:154;s:13:\"category_name\";s:8:\"Scooters\";s:13:\"category_slug\";s:8:\"scooters\";}i:272;a:10:{s:26:\"master_category_section_id\";i:273;s:18:\"master_category_id\";i:4;s:20:\"master_category_name\";s:4:\"TOYS\";s:20:\"master_category_slug\";s:4:\"toys\";s:15:\"section_type_id\";i:10;s:17:\"section_type_name\";s:19:\"RIDE-ONS & SCOOTERS\";s:17:\"section_type_slug\";s:17:\"ride-ons-scooters\";s:11:\"category_id\";i:155;s:13:\"category_name\";s:16:\"Rocking Ride Ons\";s:13:\"category_slug\";s:16:\"rocking-ride-ons\";}i:273;a:10:{s:26:\"master_category_section_id\";i:274;s:18:\"master_category_id\";i:4;s:20:\"master_category_name\";s:4:\"TOYS\";s:20:\"master_category_slug\";s:4:\"toys\";s:15:\"section_type_id\";i:10;s:17:\"section_type_name\";s:19:\"RIDE-ONS & SCOOTERS\";s:17:\"section_type_slug\";s:17:\"ride-ons-scooters\";s:11:\"category_id\";i:156;s:13:\"category_name\";s:9:\"Tricycles\";s:13:\"category_slug\";s:9:\"tricycles\";}i:274;a:10:{s:26:\"master_category_section_id\";i:275;s:18:\"master_category_id\";i:4;s:20:\"master_category_name\";s:4:\"TOYS\";s:20:\"master_category_slug\";s:4:\"toys\";s:15:\"section_type_id\";i:10;s:17:\"section_type_name\";s:19:\"RIDE-ONS & SCOOTERS\";s:17:\"section_type_slug\";s:17:\"ride-ons-scooters\";s:11:\"category_id\";i:157;s:13:\"category_name\";s:8:\"Bicycles\";s:13:\"category_slug\";s:8:\"bicycles\";}i:275;a:10:{s:26:\"master_category_section_id\";i:276;s:18:\"master_category_id\";i:4;s:20:\"master_category_name\";s:4:\"TOYS\";s:20:\"master_category_slug\";s:4:\"toys\";s:15:\"section_type_id\";i:10;s:17:\"section_type_name\";s:19:\"RIDE-ONS & SCOOTERS\";s:17:\"section_type_slug\";s:17:\"ride-ons-scooters\";s:11:\"category_id\";i:158;s:13:\"category_name\";s:12:\"Balance Bike\";s:13:\"category_slug\";s:12:\"balance-bike\";}i:276;a:10:{s:26:\"master_category_section_id\";i:277;s:18:\"master_category_id\";i:4;s:20:\"master_category_name\";s:4:\"TOYS\";s:20:\"master_category_slug\";s:4:\"toys\";s:15:\"section_type_id\";i:11;s:17:\"section_type_name\";s:20:\"HOME PLAY ACTIVITIES\";s:17:\"section_type_slug\";s:20:\"home-play-activities\";s:11:\"category_id\";i:159;s:13:\"category_name\";s:25:\"Play Dough, Sand & Moulds\";s:13:\"category_slug\";s:22:\"play-dough-sand-moulds\";}i:277;a:10:{s:26:\"master_category_section_id\";i:278;s:18:\"master_category_id\";i:4;s:20:\"master_category_name\";s:4:\"TOYS\";s:20:\"master_category_slug\";s:4:\"toys\";s:15:\"section_type_id\";i:11;s:17:\"section_type_name\";s:20:\"HOME PLAY ACTIVITIES\";s:17:\"section_type_slug\";s:20:\"home-play-activities\";s:11:\"category_id\";i:160;s:13:\"category_name\";s:36:\"Coloring, Sequencing & Engraving Art\";s:13:\"category_slug\";s:33:\"coloring-sequencing-engraving-art\";}i:278;a:10:{s:26:\"master_category_section_id\";i:279;s:18:\"master_category_id\";i:4;s:20:\"master_category_name\";s:4:\"TOYS\";s:20:\"master_category_slug\";s:4:\"toys\";s:15:\"section_type_id\";i:11;s:17:\"section_type_name\";s:20:\"HOME PLAY ACTIVITIES\";s:17:\"section_type_slug\";s:20:\"home-play-activities\";s:11:\"category_id\";i:161;s:13:\"category_name\";s:12:\"Activity Kit\";s:13:\"category_slug\";s:12:\"activity-kit\";}i:279;a:10:{s:26:\"master_category_section_id\";i:280;s:18:\"master_category_id\";i:4;s:20:\"master_category_name\";s:4:\"TOYS\";s:20:\"master_category_slug\";s:4:\"toys\";s:15:\"section_type_id\";i:11;s:17:\"section_type_name\";s:20:\"HOME PLAY ACTIVITIES\";s:17:\"section_type_slug\";s:20:\"home-play-activities\";s:11:\"category_id\";i:162;s:13:\"category_name\";s:26:\"Building Construction Sets\";s:13:\"category_slug\";s:26:\"building-construction-sets\";}i:280;a:10:{s:26:\"master_category_section_id\";i:281;s:18:\"master_category_id\";i:4;s:20:\"master_category_name\";s:4:\"TOYS\";s:20:\"master_category_slug\";s:4:\"toys\";s:15:\"section_type_id\";i:11;s:17:\"section_type_name\";s:20:\"HOME PLAY ACTIVITIES\";s:17:\"section_type_slug\";s:20:\"home-play-activities\";s:11:\"category_id\";i:163;s:13:\"category_name\";s:23:\"Multi Model Making Sets\";s:13:\"category_slug\";s:23:\"multi-model-making-sets\";}i:281;a:10:{s:26:\"master_category_section_id\";i:282;s:18:\"master_category_id\";i:4;s:20:\"master_category_name\";s:4:\"TOYS\";s:20:\"master_category_slug\";s:4:\"toys\";s:15:\"section_type_id\";i:11;s:17:\"section_type_name\";s:20:\"HOME PLAY ACTIVITIES\";s:17:\"section_type_slug\";s:20:\"home-play-activities\";s:11:\"category_id\";i:164;s:13:\"category_name\";s:12:\"Kitchen Sets\";s:13:\"category_slug\";s:12:\"kitchen-sets\";}i:282;a:10:{s:26:\"master_category_section_id\";i:283;s:18:\"master_category_id\";i:4;s:20:\"master_category_name\";s:4:\"TOYS\";s:20:\"master_category_slug\";s:4:\"toys\";s:15:\"section_type_id\";i:11;s:17:\"section_type_name\";s:20:\"HOME PLAY ACTIVITIES\";s:17:\"section_type_slug\";s:20:\"home-play-activities\";s:11:\"category_id\";i:165;s:13:\"category_name\";s:10:\"Play Foods\";s:13:\"category_slug\";s:10:\"play-foods\";}i:283;a:10:{s:26:\"master_category_section_id\";i:284;s:18:\"master_category_id\";i:4;s:20:\"master_category_name\";s:4:\"TOYS\";s:20:\"master_category_slug\";s:4:\"toys\";s:15:\"section_type_id\";i:11;s:17:\"section_type_name\";s:20:\"HOME PLAY ACTIVITIES\";s:17:\"section_type_slug\";s:20:\"home-play-activities\";s:11:\"category_id\";i:166;s:13:\"category_name\";s:17:\"Kids\' Doctor Sets\";s:13:\"category_slug\";s:16:\"kids-doctor-sets\";}i:284;a:10:{s:26:\"master_category_section_id\";i:285;s:18:\"master_category_id\";i:4;s:20:\"master_category_name\";s:4:\"TOYS\";s:20:\"master_category_slug\";s:4:\"toys\";s:15:\"section_type_id\";i:11;s:17:\"section_type_name\";s:20:\"HOME PLAY ACTIVITIES\";s:17:\"section_type_slug\";s:20:\"home-play-activities\";s:11:\"category_id\";i:167;s:13:\"category_name\";s:17:\"Piano & Keyboards\";s:13:\"category_slug\";s:15:\"piano-keyboards\";}i:285;a:10:{s:26:\"master_category_section_id\";i:286;s:18:\"master_category_id\";i:4;s:20:\"master_category_name\";s:4:\"TOYS\";s:20:\"master_category_slug\";s:4:\"toys\";s:15:\"section_type_id\";i:11;s:17:\"section_type_name\";s:20:\"HOME PLAY ACTIVITIES\";s:17:\"section_type_slug\";s:20:\"home-play-activities\";s:11:\"category_id\";i:168;s:13:\"category_name\";s:22:\"Drum Sets & Percussion\";s:13:\"category_slug\";s:20:\"drum-sets-percussion\";}i:286;a:10:{s:26:\"master_category_section_id\";i:287;s:18:\"master_category_id\";i:4;s:20:\"master_category_name\";s:4:\"TOYS\";s:20:\"master_category_slug\";s:4:\"toys\";s:15:\"section_type_id\";i:6;s:17:\"section_type_name\";s:13:\"SHOP BY PRICE\";s:17:\"section_type_slug\";s:13:\"shop-by-price\";s:11:\"category_id\";i:169;s:13:\"category_name\";s:9:\"Under 299\";s:13:\"category_slug\";s:9:\"under-299\";}i:287;a:10:{s:26:\"master_category_section_id\";i:288;s:18:\"master_category_id\";i:4;s:20:\"master_category_name\";s:4:\"TOYS\";s:20:\"master_category_slug\";s:4:\"toys\";s:15:\"section_type_id\";i:6;s:17:\"section_type_name\";s:13:\"SHOP BY PRICE\";s:17:\"section_type_slug\";s:13:\"shop-by-price\";s:11:\"category_id\";i:170;s:13:\"category_name\";s:9:\"Under 499\";s:13:\"category_slug\";s:9:\"under-499\";}i:288;a:10:{s:26:\"master_category_section_id\";i:289;s:18:\"master_category_id\";i:4;s:20:\"master_category_name\";s:4:\"TOYS\";s:20:\"master_category_slug\";s:4:\"toys\";s:15:\"section_type_id\";i:6;s:17:\"section_type_name\";s:13:\"SHOP BY PRICE\";s:17:\"section_type_slug\";s:13:\"shop-by-price\";s:11:\"category_id\";i:171;s:13:\"category_name\";s:9:\"Under 699\";s:13:\"category_slug\";s:9:\"under-699\";}i:289;a:10:{s:26:\"master_category_section_id\";i:290;s:18:\"master_category_id\";i:4;s:20:\"master_category_name\";s:4:\"TOYS\";s:20:\"master_category_slug\";s:4:\"toys\";s:15:\"section_type_id\";i:6;s:17:\"section_type_name\";s:13:\"SHOP BY PRICE\";s:17:\"section_type_slug\";s:13:\"shop-by-price\";s:11:\"category_id\";i:172;s:13:\"category_name\";s:9:\"Under 999\";s:13:\"category_slug\";s:9:\"under-999\";}i:290;a:10:{s:26:\"master_category_section_id\";i:291;s:18:\"master_category_id\";i:4;s:20:\"master_category_name\";s:4:\"TOYS\";s:20:\"master_category_slug\";s:4:\"toys\";s:15:\"section_type_id\";i:12;s:17:\"section_type_name\";s:11:\"BOARD GAMES\";s:17:\"section_type_slug\";s:11:\"board-games\";s:11:\"category_id\";i:173;s:13:\"category_name\";s:8:\"IQ Games\";s:13:\"category_slug\";s:8:\"iq-games\";}i:291;a:10:{s:26:\"master_category_section_id\";i:292;s:18:\"master_category_id\";i:4;s:20:\"master_category_name\";s:4:\"TOYS\";s:20:\"master_category_slug\";s:4:\"toys\";s:15:\"section_type_id\";i:12;s:17:\"section_type_name\";s:11:\"BOARD GAMES\";s:17:\"section_type_slug\";s:11:\"board-games\";s:11:\"category_id\";i:174;s:13:\"category_name\";s:22:\"Ludo, Snakes & Ladders\";s:13:\"category_slug\";s:19:\"ludo-snakes-ladders\";}i:292;a:10:{s:26:\"master_category_section_id\";i:293;s:18:\"master_category_id\";i:4;s:20:\"master_category_name\";s:4:\"TOYS\";s:20:\"master_category_slug\";s:4:\"toys\";s:15:\"section_type_id\";i:12;s:17:\"section_type_name\";s:11:\"BOARD GAMES\";s:17:\"section_type_slug\";s:11:\"board-games\";s:11:\"category_id\";i:175;s:13:\"category_name\";s:32:\"Words, Pictures & Scrabble Games\";s:13:\"category_slug\";s:29:\"words-pictures-scrabble-games\";}i:293;a:10:{s:26:\"master_category_section_id\";i:294;s:18:\"master_category_id\";i:4;s:20:\"master_category_name\";s:4:\"TOYS\";s:20:\"master_category_slug\";s:4:\"toys\";s:15:\"section_type_id\";i:12;s:17:\"section_type_name\";s:11:\"BOARD GAMES\";s:17:\"section_type_slug\";s:11:\"board-games\";s:11:\"category_id\";i:176;s:13:\"category_name\";s:13:\"Playing Cards\";s:13:\"category_slug\";s:13:\"playing-cards\";}i:294;a:10:{s:26:\"master_category_section_id\";i:295;s:18:\"master_category_id\";i:4;s:20:\"master_category_name\";s:4:\"TOYS\";s:20:\"master_category_slug\";s:4:\"toys\";s:15:\"section_type_id\";i:12;s:17:\"section_type_name\";s:11:\"BOARD GAMES\";s:17:\"section_type_slug\";s:11:\"board-games\";s:11:\"category_id\";i:177;s:13:\"category_name\";s:25:\"Life & Travel Board Games\";s:13:\"category_slug\";s:23:\"life-travel-board-games\";}i:295;a:10:{s:26:\"master_category_section_id\";i:296;s:18:\"master_category_id\";i:4;s:20:\"master_category_name\";s:4:\"TOYS\";s:20:\"master_category_slug\";s:4:\"toys\";s:15:\"section_type_id\";i:12;s:17:\"section_type_name\";s:11:\"BOARD GAMES\";s:17:\"section_type_slug\";s:11:\"board-games\";s:11:\"category_id\";i:178;s:13:\"category_name\";s:33:\"Animal, Birds & Marine Life Games\";s:13:\"category_slug\";s:30:\"animal-birds-marine-life-games\";}i:296;a:10:{s:26:\"master_category_section_id\";i:297;s:18:\"master_category_id\";i:4;s:20:\"master_category_name\";s:4:\"TOYS\";s:20:\"master_category_slug\";s:4:\"toys\";s:15:\"section_type_id\";i:12;s:17:\"section_type_name\";s:11:\"BOARD GAMES\";s:17:\"section_type_slug\";s:11:\"board-games\";s:11:\"category_id\";i:179;s:13:\"category_name\";s:17:\"Business/Monopoly\";s:13:\"category_slug\";s:16:\"businessmonopoly\";}i:297;a:10:{s:26:\"master_category_section_id\";i:298;s:18:\"master_category_id\";i:4;s:20:\"master_category_name\";s:4:\"TOYS\";s:20:\"master_category_slug\";s:4:\"toys\";s:15:\"section_type_id\";i:7;s:17:\"section_type_name\";s:14:\"SHOP BY BRANDS\";s:17:\"section_type_slug\";s:14:\"shop-by-brands\";s:11:\"category_id\";i:180;s:13:\"category_name\";s:12:\"Fisher Price\";s:13:\"category_slug\";s:12:\"fisher-price\";}i:298;a:10:{s:26:\"master_category_section_id\";i:299;s:18:\"master_category_id\";i:4;s:20:\"master_category_name\";s:4:\"TOYS\";s:20:\"master_category_slug\";s:4:\"toys\";s:15:\"section_type_id\";i:7;s:17:\"section_type_name\";s:14:\"SHOP BY BRANDS\";s:17:\"section_type_slug\";s:14:\"shop-by-brands\";s:11:\"category_id\";i:181;s:13:\"category_name\";s:10:\"Intellikit\";s:13:\"category_slug\";s:10:\"intellikit\";}i:299;a:10:{s:26:\"master_category_section_id\";i:300;s:18:\"master_category_id\";i:4;s:20:\"master_category_name\";s:4:\"TOYS\";s:20:\"master_category_slug\";s:4:\"toys\";s:15:\"section_type_id\";i:7;s:17:\"section_type_name\";s:14:\"SHOP BY BRANDS\";s:17:\"section_type_slug\";s:14:\"shop-by-brands\";s:11:\"category_id\";i:71;s:13:\"category_name\";s:7:\"Babyhug\";s:13:\"category_slug\";s:7:\"babyhug\";}i:300;a:10:{s:26:\"master_category_section_id\";i:301;s:18:\"master_category_id\";i:4;s:20:\"master_category_name\";s:4:\"TOYS\";s:20:\"master_category_slug\";s:4:\"toys\";s:15:\"section_type_id\";i:7;s:17:\"section_type_name\";s:14:\"SHOP BY BRANDS\";s:17:\"section_type_slug\";s:14:\"shop-by-brands\";s:11:\"category_id\";i:182;s:13:\"category_name\";s:13:\"Intelliskills\";s:13:\"category_slug\";s:13:\"intelliskills\";}i:301;a:10:{s:26:\"master_category_section_id\";i:302;s:18:\"master_category_id\";i:4;s:20:\"master_category_name\";s:4:\"TOYS\";s:20:\"master_category_slug\";s:4:\"toys\";s:15:\"section_type_id\";i:7;s:17:\"section_type_name\";s:14:\"SHOP BY BRANDS\";s:17:\"section_type_slug\";s:14:\"shop-by-brands\";s:11:\"category_id\";i:183;s:13:\"category_name\";s:11:\"Intellibaby\";s:13:\"category_slug\";s:11:\"intellibaby\";}i:302;a:10:{s:26:\"master_category_section_id\";i:303;s:18:\"master_category_id\";i:4;s:20:\"master_category_name\";s:4:\"TOYS\";s:20:\"master_category_slug\";s:4:\"toys\";s:15:\"section_type_id\";i:7;s:17:\"section_type_name\";s:14:\"SHOP BY BRANDS\";s:17:\"section_type_slug\";s:14:\"shop-by-brands\";s:11:\"category_id\";i:184;s:13:\"category_name\";s:11:\"Fab n Funky\";s:13:\"category_slug\";s:11:\"fab-n-funky\";}i:303;a:10:{s:26:\"master_category_section_id\";i:304;s:18:\"master_category_id\";i:4;s:20:\"master_category_name\";s:4:\"TOYS\";s:20:\"master_category_slug\";s:4:\"toys\";s:15:\"section_type_id\";i:7;s:17:\"section_type_name\";s:14:\"SHOP BY BRANDS\";s:17:\"section_type_slug\";s:14:\"shop-by-brands\";s:11:\"category_id\";i:185;s:13:\"category_name\";s:9:\"Hotwheels\";s:13:\"category_slug\";s:9:\"hotwheels\";}i:304;a:10:{s:26:\"master_category_section_id\";i:305;s:18:\"master_category_id\";i:4;s:20:\"master_category_name\";s:4:\"TOYS\";s:20:\"master_category_slug\";s:4:\"toys\";s:15:\"section_type_id\";i:7;s:17:\"section_type_name\";s:14:\"SHOP BY BRANDS\";s:17:\"section_type_slug\";s:14:\"shop-by-brands\";s:11:\"category_id\";i:186;s:13:\"category_name\";s:6:\"Disney\";s:13:\"category_slug\";s:6:\"disney\";}i:305;a:10:{s:26:\"master_category_section_id\";i:306;s:18:\"master_category_id\";i:4;s:20:\"master_category_name\";s:4:\"TOYS\";s:20:\"master_category_slug\";s:4:\"toys\";s:15:\"section_type_id\";i:7;s:17:\"section_type_name\";s:14:\"SHOP BY BRANDS\";s:17:\"section_type_slug\";s:14:\"shop-by-brands\";s:11:\"category_id\";i:187;s:13:\"category_name\";s:6:\"Barbie\";s:13:\"category_slug\";s:6:\"barbie\";}i:306;a:10:{s:26:\"master_category_section_id\";i:307;s:18:\"master_category_id\";i:4;s:20:\"master_category_name\";s:4:\"TOYS\";s:20:\"master_category_slug\";s:4:\"toys\";s:15:\"section_type_id\";i:7;s:17:\"section_type_name\";s:14:\"SHOP BY BRANDS\";s:17:\"section_type_slug\";s:14:\"shop-by-brands\";s:11:\"category_id\";i:188;s:13:\"category_name\";s:7:\"Giggles\";s:13:\"category_slug\";s:7:\"giggles\";}i:307;a:10:{s:26:\"master_category_section_id\";i:308;s:18:\"master_category_id\";i:4;s:20:\"master_category_name\";s:4:\"TOYS\";s:20:\"master_category_slug\";s:4:\"toys\";s:15:\"section_type_id\";i:7;s:17:\"section_type_name\";s:14:\"SHOP BY BRANDS\";s:17:\"section_type_slug\";s:14:\"shop-by-brands\";s:11:\"category_id\";i:189;s:13:\"category_name\";s:4:\"Lego\";s:13:\"category_slug\";s:4:\"lego\";}i:308;a:10:{s:26:\"master_category_section_id\";i:309;s:18:\"master_category_id\";i:4;s:20:\"master_category_name\";s:4:\"TOYS\";s:20:\"master_category_slug\";s:4:\"toys\";s:15:\"section_type_id\";i:7;s:17:\"section_type_name\";s:14:\"SHOP BY BRANDS\";s:17:\"section_type_slug\";s:14:\"shop-by-brands\";s:11:\"category_id\";i:82;s:13:\"category_name\";s:7:\"Bonfino\";s:13:\"category_slug\";s:7:\"bonfino\";}i:309;a:10:{s:26:\"master_category_section_id\";i:310;s:18:\"master_category_id\";i:4;s:20:\"master_category_name\";s:4:\"TOYS\";s:20:\"master_category_slug\";s:4:\"toys\";s:15:\"section_type_id\";i:7;s:17:\"section_type_name\";s:14:\"SHOP BY BRANDS\";s:17:\"section_type_slug\";s:14:\"shop-by-brands\";s:11:\"category_id\";i:75;s:13:\"category_name\";s:9:\"Pine Kids\";s:13:\"category_slug\";s:9:\"pine-kids\";}i:310;a:10:{s:26:\"master_category_section_id\";i:311;s:18:\"master_category_id\";i:4;s:20:\"master_category_name\";s:4:\"TOYS\";s:20:\"master_category_slug\";s:4:\"toys\";s:15:\"section_type_id\";i:7;s:17:\"section_type_name\";s:14:\"SHOP BY BRANDS\";s:17:\"section_type_slug\";s:14:\"shop-by-brands\";s:11:\"category_id\";i:190;s:13:\"category_name\";s:10:\"Playnation\";s:13:\"category_slug\";s:10:\"playnation\";}i:311;a:10:{s:26:\"master_category_section_id\";i:312;s:18:\"master_category_id\";i:5;s:20:\"master_category_name\";s:9:\"DIAPERING\";s:20:\"master_category_slug\";s:9:\"diapering\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:191;s:13:\"category_name\";s:12:\"Diaper Pants\";s:13:\"category_slug\";s:12:\"diaper-pants\";}i:312;a:10:{s:26:\"master_category_section_id\";i:313;s:18:\"master_category_id\";i:5;s:20:\"master_category_name\";s:9:\"DIAPERING\";s:20:\"master_category_slug\";s:9:\"diapering\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:192;s:13:\"category_name\";s:13:\"Taped Diapers\";s:13:\"category_slug\";s:13:\"taped-diapers\";}i:313;a:10:{s:26:\"master_category_section_id\";i:314;s:18:\"master_category_id\";i:5;s:20:\"master_category_name\";s:9:\"DIAPERING\";s:20:\"master_category_slug\";s:9:\"diapering\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:193;s:13:\"category_name\";s:10:\"Baby Wipes\";s:13:\"category_slug\";s:10:\"baby-wipes\";}i:314;a:10:{s:26:\"master_category_section_id\";i:315;s:18:\"master_category_id\";i:5;s:20:\"master_category_name\";s:9:\"DIAPERING\";s:20:\"master_category_slug\";s:9:\"diapering\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:194;s:13:\"category_name\";s:27:\"Cloth Nappies & Accessories\";s:13:\"category_slug\";s:25:\"cloth-nappies-accessories\";}i:315;a:10:{s:26:\"master_category_section_id\";i:316;s:18:\"master_category_id\";i:5;s:20:\"master_category_name\";s:9:\"DIAPERING\";s:20:\"master_category_slug\";s:9:\"diapering\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:195;s:13:\"category_name\";s:37:\"Cloth Diaper Training Pants & Inserts\";s:13:\"category_slug\";s:35:\"cloth-diaper-training-pants-inserts\";}i:316;a:10:{s:26:\"master_category_section_id\";i:317;s:18:\"master_category_id\";i:5;s:20:\"master_category_name\";s:9:\"DIAPERING\";s:20:\"master_category_slug\";s:9:\"diapering\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:196;s:13:\"category_name\";s:14:\"Bed Protectors\";s:13:\"category_slug\";s:14:\"bed-protectors\";}i:317;a:10:{s:26:\"master_category_section_id\";i:318;s:18:\"master_category_id\";i:5;s:20:\"master_category_name\";s:9:\"DIAPERING\";s:20:\"master_category_slug\";s:9:\"diapering\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:197;s:13:\"category_name\";s:17:\"Diaper Rash Cream\";s:13:\"category_slug\";s:17:\"diaper-rash-cream\";}i:318;a:10:{s:26:\"master_category_section_id\";i:319;s:18:\"master_category_id\";i:5;s:20:\"master_category_name\";s:9:\"DIAPERING\";s:20:\"master_category_slug\";s:9:\"diapering\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:198;s:13:\"category_name\";s:20:\"Diaper Changing Mats\";s:13:\"category_slug\";s:20:\"diaper-changing-mats\";}i:319;a:10:{s:26:\"master_category_section_id\";i:320;s:18:\"master_category_id\";i:5;s:20:\"master_category_name\";s:9:\"DIAPERING\";s:20:\"master_category_slug\";s:9:\"diapering\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:199;s:13:\"category_name\";s:23:\"Diaper Bags & Backpacks\";s:13:\"category_slug\";s:21:\"diaper-bags-backpacks\";}i:320;a:10:{s:26:\"master_category_section_id\";i:321;s:18:\"master_category_id\";i:5;s:20:\"master_category_name\";s:9:\"DIAPERING\";s:20:\"master_category_slug\";s:9:\"diapering\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:200;s:13:\"category_name\";s:29:\"Diaper Bins & Disposable Bags\";s:13:\"category_slug\";s:27:\"diaper-bins-disposable-bags\";}i:321;a:10:{s:26:\"master_category_section_id\";i:322;s:18:\"master_category_id\";i:5;s:20:\"master_category_name\";s:9:\"DIAPERING\";s:20:\"master_category_slug\";s:9:\"diapering\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:201;s:13:\"category_name\";s:20:\"Potty Chairs & Seats\";s:13:\"category_slug\";s:18:\"potty-chairs-seats\";}i:322;a:10:{s:26:\"master_category_section_id\";i:323;s:18:\"master_category_id\";i:5;s:20:\"master_category_name\";s:9:\"DIAPERING\";s:20:\"master_category_slug\";s:9:\"diapering\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:202;s:13:\"category_name\";s:18:\"Waterproof Nappies\";s:13:\"category_slug\";s:18:\"waterproof-nappies\";}i:323;a:10:{s:26:\"master_category_section_id\";i:324;s:18:\"master_category_id\";i:5;s:20:\"master_category_name\";s:9:\"DIAPERING\";s:20:\"master_category_slug\";s:9:\"diapering\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:203;s:13:\"category_name\";s:12:\"Swim Diapers\";s:13:\"category_slug\";s:12:\"swim-diapers\";}i:324;a:10:{s:26:\"master_category_section_id\";i:325;s:18:\"master_category_id\";i:5;s:20:\"master_category_name\";s:9:\"DIAPERING\";s:20:\"master_category_slug\";s:9:\"diapering\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:204;s:13:\"category_name\";s:20:\"Diaper Monthly Packs\";s:13:\"category_slug\";s:20:\"diaper-monthly-packs\";}i:325;a:10:{s:26:\"master_category_section_id\";i:326;s:18:\"master_category_id\";i:5;s:20:\"master_category_name\";s:9:\"DIAPERING\";s:20:\"master_category_slug\";s:9:\"diapering\";s:15:\"section_type_id\";i:13;s:17:\"section_type_name\";s:23:\"DISPOSABLE BABY DIAPERS\";s:17:\"section_type_slug\";s:23:\"disposable-baby-diapers\";s:11:\"category_id\";i:191;s:13:\"category_name\";s:12:\"Diaper Pants\";s:13:\"category_slug\";s:12:\"diaper-pants\";}i:326;a:10:{s:26:\"master_category_section_id\";i:327;s:18:\"master_category_id\";i:5;s:20:\"master_category_name\";s:9:\"DIAPERING\";s:20:\"master_category_slug\";s:9:\"diapering\";s:15:\"section_type_id\";i:13;s:17:\"section_type_name\";s:23:\"DISPOSABLE BABY DIAPERS\";s:17:\"section_type_slug\";s:23:\"disposable-baby-diapers\";s:11:\"category_id\";i:192;s:13:\"category_name\";s:13:\"Taped Diapers\";s:13:\"category_slug\";s:13:\"taped-diapers\";}i:327;a:10:{s:26:\"master_category_section_id\";i:328;s:18:\"master_category_id\";i:5;s:20:\"master_category_name\";s:9:\"DIAPERING\";s:20:\"master_category_slug\";s:9:\"diapering\";s:15:\"section_type_id\";i:13;s:17:\"section_type_name\";s:23:\"DISPOSABLE BABY DIAPERS\";s:17:\"section_type_slug\";s:23:\"disposable-baby-diapers\";s:11:\"category_id\";i:205;s:13:\"category_name\";s:13:\"Monthly Packs\";s:13:\"category_slug\";s:13:\"monthly-packs\";}i:328;a:10:{s:26:\"master_category_section_id\";i:329;s:18:\"master_category_id\";i:5;s:20:\"master_category_name\";s:9:\"DIAPERING\";s:20:\"master_category_slug\";s:9:\"diapering\";s:15:\"section_type_id\";i:14;s:17:\"section_type_name\";s:10:\"TOP BRANDS\";s:17:\"section_type_slug\";s:10:\"top-brands\";s:11:\"category_id\";i:206;s:13:\"category_name\";s:7:\"Pampers\";s:13:\"category_slug\";s:7:\"pampers\";}i:329;a:10:{s:26:\"master_category_section_id\";i:330;s:18:\"master_category_id\";i:5;s:20:\"master_category_name\";s:9:\"DIAPERING\";s:20:\"master_category_slug\";s:9:\"diapering\";s:15:\"section_type_id\";i:14;s:17:\"section_type_name\";s:10:\"TOP BRANDS\";s:17:\"section_type_slug\";s:10:\"top-brands\";s:11:\"category_id\";i:71;s:13:\"category_name\";s:7:\"Babyhug\";s:13:\"category_slug\";s:7:\"babyhug\";}i:330;a:10:{s:26:\"master_category_section_id\";i:331;s:18:\"master_category_id\";i:5;s:20:\"master_category_name\";s:9:\"DIAPERING\";s:20:\"master_category_slug\";s:9:\"diapering\";s:15:\"section_type_id\";i:14;s:17:\"section_type_name\";s:10:\"TOP BRANDS\";s:17:\"section_type_slug\";s:10:\"top-brands\";s:11:\"category_id\";i:207;s:13:\"category_name\";s:8:\"MamyPoko\";s:13:\"category_slug\";s:8:\"mamypoko\";}i:331;a:10:{s:26:\"master_category_section_id\";i:332;s:18:\"master_category_id\";i:5;s:20:\"master_category_name\";s:9:\"DIAPERING\";s:20:\"master_category_slug\";s:9:\"diapering\";s:15:\"section_type_id\";i:14;s:17:\"section_type_name\";s:10:\"TOP BRANDS\";s:17:\"section_type_slug\";s:10:\"top-brands\";s:11:\"category_id\";i:208;s:13:\"category_name\";s:7:\"Huggies\";s:13:\"category_slug\";s:7:\"huggies\";}i:332;a:10:{s:26:\"master_category_section_id\";i:333;s:18:\"master_category_id\";i:5;s:20:\"master_category_name\";s:9:\"DIAPERING\";s:20:\"master_category_slug\";s:9:\"diapering\";s:15:\"section_type_id\";i:14;s:17:\"section_type_name\";s:10:\"TOP BRANDS\";s:17:\"section_type_slug\";s:10:\"top-brands\";s:11:\"category_id\";i:209;s:13:\"category_name\";s:17:\"Himalaya Babycare\";s:13:\"category_slug\";s:17:\"himalaya-babycare\";}i:333;a:10:{s:26:\"master_category_section_id\";i:334;s:18:\"master_category_id\";i:5;s:20:\"master_category_name\";s:9:\"DIAPERING\";s:20:\"master_category_slug\";s:9:\"diapering\";s:15:\"section_type_id\";i:14;s:17:\"section_type_name\";s:10:\"TOP BRANDS\";s:17:\"section_type_slug\";s:10:\"top-brands\";s:11:\"category_id\";i:210;s:13:\"category_name\";s:12:\"SuperBottoms\";s:13:\"category_slug\";s:12:\"superbottoms\";}i:334;a:10:{s:26:\"master_category_section_id\";i:335;s:18:\"master_category_id\";i:5;s:20:\"master_category_name\";s:9:\"DIAPERING\";s:20:\"master_category_slug\";s:9:\"diapering\";s:15:\"section_type_id\";i:14;s:17:\"section_type_name\";s:10:\"TOP BRANDS\";s:17:\"section_type_slug\";s:10:\"top-brands\";s:11:\"category_id\";i:211;s:13:\"category_name\";s:7:\"Littles\";s:13:\"category_slug\";s:7:\"littles\";}i:335;a:10:{s:26:\"master_category_section_id\";i:336;s:18:\"master_category_id\";i:5;s:20:\"master_category_name\";s:9:\"DIAPERING\";s:20:\"master_category_slug\";s:9:\"diapering\";s:15:\"section_type_id\";i:14;s:17:\"section_type_name\";s:10:\"TOP BRANDS\";s:17:\"section_type_slug\";s:10:\"top-brands\";s:11:\"category_id\";i:212;s:13:\"category_name\";s:7:\"Sebamed\";s:13:\"category_slug\";s:7:\"sebamed\";}i:336;a:10:{s:26:\"master_category_section_id\";i:337;s:18:\"master_category_id\";i:5;s:20:\"master_category_name\";s:9:\"DIAPERING\";s:20:\"master_category_slug\";s:9:\"diapering\";s:15:\"section_type_id\";i:14;s:17:\"section_type_name\";s:10:\"TOP BRANDS\";s:17:\"section_type_slug\";s:10:\"top-brands\";s:11:\"category_id\";i:213;s:13:\"category_name\";s:6:\"Teddyy\";s:13:\"category_slug\";s:6:\"teddyy\";}i:337;a:10:{s:26:\"master_category_section_id\";i:338;s:18:\"master_category_id\";i:5;s:20:\"master_category_name\";s:9:\"DIAPERING\";s:20:\"master_category_slug\";s:9:\"diapering\";s:15:\"section_type_id\";i:14;s:17:\"section_type_name\";s:10:\"TOP BRANDS\";s:17:\"section_type_slug\";s:10:\"top-brands\";s:11:\"category_id\";i:214;s:13:\"category_name\";s:7:\"Mee Mee\";s:13:\"category_slug\";s:7:\"mee-mee\";}i:338;a:10:{s:26:\"master_category_section_id\";i:339;s:18:\"master_category_id\";i:5;s:20:\"master_category_name\";s:9:\"DIAPERING\";s:20:\"master_category_slug\";s:9:\"diapering\";s:15:\"section_type_id\";i:15;s:17:\"section_type_name\";s:19:\"BABY DIAPER BY SIZE\";s:17:\"section_type_slug\";s:19:\"baby-diaper-by-size\";s:11:\"category_id\";i:215;s:13:\"category_name\";s:20:\"New Born/Extra Small\";s:13:\"category_slug\";s:19:\"new-bornextra-small\";}i:339;a:10:{s:26:\"master_category_section_id\";i:340;s:18:\"master_category_id\";i:5;s:20:\"master_category_name\";s:9:\"DIAPERING\";s:20:\"master_category_slug\";s:9:\"diapering\";s:15:\"section_type_id\";i:15;s:17:\"section_type_name\";s:19:\"BABY DIAPER BY SIZE\";s:17:\"section_type_slug\";s:19:\"baby-diaper-by-size\";s:11:\"category_id\";i:216;s:13:\"category_name\";s:5:\"Small\";s:13:\"category_slug\";s:5:\"small\";}i:340;a:10:{s:26:\"master_category_section_id\";i:341;s:18:\"master_category_id\";i:5;s:20:\"master_category_name\";s:9:\"DIAPERING\";s:20:\"master_category_slug\";s:9:\"diapering\";s:15:\"section_type_id\";i:15;s:17:\"section_type_name\";s:19:\"BABY DIAPER BY SIZE\";s:17:\"section_type_slug\";s:19:\"baby-diaper-by-size\";s:11:\"category_id\";i:217;s:13:\"category_name\";s:6:\"Medium\";s:13:\"category_slug\";s:6:\"medium\";}i:341;a:10:{s:26:\"master_category_section_id\";i:342;s:18:\"master_category_id\";i:5;s:20:\"master_category_name\";s:9:\"DIAPERING\";s:20:\"master_category_slug\";s:9:\"diapering\";s:15:\"section_type_id\";i:15;s:17:\"section_type_name\";s:19:\"BABY DIAPER BY SIZE\";s:17:\"section_type_slug\";s:19:\"baby-diaper-by-size\";s:11:\"category_id\";i:218;s:13:\"category_name\";s:5:\"Large\";s:13:\"category_slug\";s:5:\"large\";}i:342;a:10:{s:26:\"master_category_section_id\";i:343;s:18:\"master_category_id\";i:5;s:20:\"master_category_name\";s:9:\"DIAPERING\";s:20:\"master_category_slug\";s:9:\"diapering\";s:15:\"section_type_id\";i:15;s:17:\"section_type_name\";s:19:\"BABY DIAPER BY SIZE\";s:17:\"section_type_slug\";s:19:\"baby-diaper-by-size\";s:11:\"category_id\";i:219;s:13:\"category_name\";s:11:\"Extra Large\";s:13:\"category_slug\";s:11:\"extra-large\";}i:343;a:10:{s:26:\"master_category_section_id\";i:344;s:18:\"master_category_id\";i:5;s:20:\"master_category_name\";s:9:\"DIAPERING\";s:20:\"master_category_slug\";s:9:\"diapering\";s:15:\"section_type_id\";i:15;s:17:\"section_type_name\";s:19:\"BABY DIAPER BY SIZE\";s:17:\"section_type_slug\";s:19:\"baby-diaper-by-size\";s:11:\"category_id\";i:220;s:13:\"category_name\";s:8:\"XXL/XXXL\";s:13:\"category_slug\";s:7:\"xxlxxxl\";}i:344;a:10:{s:26:\"master_category_section_id\";i:345;s:18:\"master_category_id\";i:5;s:20:\"master_category_name\";s:9:\"DIAPERING\";s:20:\"master_category_slug\";s:9:\"diapering\";s:15:\"section_type_id\";i:16;s:17:\"section_type_name\";s:21:\"BABY DIAPER BY WEIGHT\";s:17:\"section_type_slug\";s:21:\"baby-diaper-by-weight\";s:11:\"category_id\";i:221;s:13:\"category_name\";s:9:\"0 to 7 Kg\";s:13:\"category_slug\";s:9:\"0-to-7-kg\";}i:345;a:10:{s:26:\"master_category_section_id\";i:346;s:18:\"master_category_id\";i:5;s:20:\"master_category_name\";s:9:\"DIAPERING\";s:20:\"master_category_slug\";s:9:\"diapering\";s:15:\"section_type_id\";i:16;s:17:\"section_type_name\";s:21:\"BABY DIAPER BY WEIGHT\";s:17:\"section_type_slug\";s:21:\"baby-diaper-by-weight\";s:11:\"category_id\";i:222;s:13:\"category_name\";s:10:\"7 to 14 Kg\";s:13:\"category_slug\";s:10:\"7-to-14-kg\";}i:346;a:10:{s:26:\"master_category_section_id\";i:347;s:18:\"master_category_id\";i:5;s:20:\"master_category_name\";s:9:\"DIAPERING\";s:20:\"master_category_slug\";s:9:\"diapering\";s:15:\"section_type_id\";i:16;s:17:\"section_type_name\";s:21:\"BABY DIAPER BY WEIGHT\";s:17:\"section_type_slug\";s:21:\"baby-diaper-by-weight\";s:11:\"category_id\";i:223;s:13:\"category_name\";s:11:\"14 to 18 Kg\";s:13:\"category_slug\";s:11:\"14-to-18-kg\";}i:347;a:10:{s:26:\"master_category_section_id\";i:348;s:18:\"master_category_id\";i:5;s:20:\"master_category_name\";s:9:\"DIAPERING\";s:20:\"master_category_slug\";s:9:\"diapering\";s:15:\"section_type_id\";i:16;s:17:\"section_type_name\";s:21:\"BABY DIAPER BY WEIGHT\";s:17:\"section_type_slug\";s:21:\"baby-diaper-by-weight\";s:11:\"category_id\";i:224;s:13:\"category_name\";s:11:\"18 to 25 Kg\";s:13:\"category_slug\";s:11:\"18-to-25-kg\";}i:348;a:10:{s:26:\"master_category_section_id\";i:349;s:18:\"master_category_id\";i:5;s:20:\"master_category_name\";s:9:\"DIAPERING\";s:20:\"master_category_slug\";s:9:\"diapering\";s:15:\"section_type_id\";i:17;s:17:\"section_type_name\";s:20:\"DIAPER CHANGING MATS\";s:17:\"section_type_slug\";s:20:\"diaper-changing-mats\";s:11:\"category_id\";i:225;s:13:\"category_name\";s:24:\"Bed Protectors with Foam\";s:13:\"category_slug\";s:24:\"bed-protectors-with-foam\";}i:349;a:10:{s:26:\"master_category_section_id\";i:350;s:18:\"master_category_id\";i:5;s:20:\"master_category_name\";s:9:\"DIAPERING\";s:20:\"master_category_slug\";s:9:\"diapering\";s:15:\"section_type_id\";i:17;s:17:\"section_type_name\";s:20:\"DIAPER CHANGING MATS\";s:17:\"section_type_slug\";s:20:\"diaper-changing-mats\";s:11:\"category_id\";i:226;s:13:\"category_name\";s:15:\"Disposable Mats\";s:13:\"category_slug\";s:15:\"disposable-mats\";}i:350;a:10:{s:26:\"master_category_section_id\";i:351;s:18:\"master_category_id\";i:5;s:20:\"master_category_name\";s:9:\"DIAPERING\";s:20:\"master_category_slug\";s:9:\"diapering\";s:15:\"section_type_id\";i:18;s:17:\"section_type_name\";s:27:\"CLOTH NAPPIES & ACCESSORIES\";s:17:\"section_type_slug\";s:25:\"cloth-nappies-accessories\";s:11:\"category_id\";i:227;s:13:\"category_name\";s:14:\"String Nappies\";s:13:\"category_slug\";s:14:\"string-nappies\";}i:351;a:10:{s:26:\"master_category_section_id\";i:352;s:18:\"master_category_id\";i:5;s:20:\"master_category_name\";s:9:\"DIAPERING\";s:20:\"master_category_slug\";s:9:\"diapering\";s:15:\"section_type_id\";i:18;s:17:\"section_type_name\";s:27:\"CLOTH NAPPIES & ACCESSORIES\";s:17:\"section_type_slug\";s:25:\"cloth-nappies-accessories\";s:11:\"category_id\";i:228;s:13:\"category_name\";s:14:\"Velcro Nappies\";s:13:\"category_slug\";s:14:\"velcro-nappies\";}i:352;a:10:{s:26:\"master_category_section_id\";i:353;s:18:\"master_category_id\";i:5;s:20:\"master_category_name\";s:9:\"DIAPERING\";s:20:\"master_category_slug\";s:9:\"diapering\";s:15:\"section_type_id\";i:18;s:17:\"section_type_name\";s:27:\"CLOTH NAPPIES & ACCESSORIES\";s:17:\"section_type_slug\";s:25:\"cloth-nappies-accessories\";s:11:\"category_id\";i:229;s:13:\"category_name\";s:14:\"Square Nappies\";s:13:\"category_slug\";s:14:\"square-nappies\";}i:353;a:10:{s:26:\"master_category_section_id\";i:354;s:18:\"master_category_id\";i:5;s:20:\"master_category_name\";s:9:\"DIAPERING\";s:20:\"master_category_slug\";s:9:\"diapering\";s:15:\"section_type_id\";i:18;s:17:\"section_type_name\";s:27:\"CLOTH NAPPIES & ACCESSORIES\";s:17:\"section_type_slug\";s:25:\"cloth-nappies-accessories\";s:11:\"category_id\";i:202;s:13:\"category_name\";s:18:\"Waterproof Nappies\";s:13:\"category_slug\";s:18:\"waterproof-nappies\";}i:354;a:10:{s:26:\"master_category_section_id\";i:355;s:18:\"master_category_id\";i:5;s:20:\"master_category_name\";s:9:\"DIAPERING\";s:20:\"master_category_slug\";s:9:\"diapering\";s:15:\"section_type_id\";i:18;s:17:\"section_type_name\";s:27:\"CLOTH NAPPIES & ACCESSORIES\";s:17:\"section_type_slug\";s:25:\"cloth-nappies-accessories\";s:11:\"category_id\";i:203;s:13:\"category_name\";s:12:\"Swim Diapers\";s:13:\"category_slug\";s:12:\"swim-diapers\";}i:355;a:10:{s:26:\"master_category_section_id\";i:356;s:18:\"master_category_id\";i:5;s:20:\"master_category_name\";s:9:\"DIAPERING\";s:20:\"master_category_slug\";s:9:\"diapering\";s:15:\"section_type_id\";i:18;s:17:\"section_type_name\";s:27:\"CLOTH NAPPIES & ACCESSORIES\";s:17:\"section_type_slug\";s:25:\"cloth-nappies-accessories\";s:11:\"category_id\";i:230;s:13:\"category_name\";s:27:\"Nappy Inserts & Accessories\";s:13:\"category_slug\";s:25:\"nappy-inserts-accessories\";}i:356;a:10:{s:26:\"master_category_section_id\";i:357;s:18:\"master_category_id\";i:5;s:20:\"master_category_name\";s:9:\"DIAPERING\";s:20:\"master_category_slug\";s:9:\"diapering\";s:15:\"section_type_id\";i:19;s:17:\"section_type_name\";s:23:\"DIAPER BAGS & BACKPACKS\";s:17:\"section_type_slug\";s:21:\"diaper-bags-backpacks\";s:11:\"category_id\";i:231;s:13:\"category_name\";s:11:\"Diaper Bags\";s:13:\"category_slug\";s:11:\"diaper-bags\";}i:357;a:10:{s:26:\"master_category_section_id\";i:358;s:18:\"master_category_id\";i:5;s:20:\"master_category_name\";s:9:\"DIAPERING\";s:20:\"master_category_slug\";s:9:\"diapering\";s:15:\"section_type_id\";i:19;s:17:\"section_type_name\";s:23:\"DIAPER BAGS & BACKPACKS\";s:17:\"section_type_slug\";s:21:\"diaper-bags-backpacks\";s:11:\"category_id\";i:232;s:13:\"category_name\";s:16:\"Diaper Backpacks\";s:13:\"category_slug\";s:16:\"diaper-backpacks\";}i:358;a:10:{s:26:\"master_category_section_id\";i:359;s:18:\"master_category_id\";i:5;s:20:\"master_category_name\";s:9:\"DIAPERING\";s:20:\"master_category_slug\";s:9:\"diapering\";s:15:\"section_type_id\";i:19;s:17:\"section_type_name\";s:23:\"DIAPER BAGS & BACKPACKS\";s:17:\"section_type_slug\";s:21:\"diaper-bags-backpacks\";s:11:\"category_id\";i:200;s:13:\"category_name\";s:29:\"Diaper Bins & Disposable Bags\";s:13:\"category_slug\";s:27:\"diaper-bins-disposable-bags\";}i:359;a:10:{s:26:\"master_category_section_id\";i:360;s:18:\"master_category_id\";i:5;s:20:\"master_category_name\";s:9:\"DIAPERING\";s:20:\"master_category_slug\";s:9:\"diapering\";s:15:\"section_type_id\";i:20;s:17:\"section_type_name\";s:14:\"POTTY TRAINING\";s:17:\"section_type_slug\";s:14:\"potty-training\";s:11:\"category_id\";i:233;s:13:\"category_name\";s:12:\"Potty Chairs\";s:13:\"category_slug\";s:12:\"potty-chairs\";}i:360;a:10:{s:26:\"master_category_section_id\";i:361;s:18:\"master_category_id\";i:5;s:20:\"master_category_name\";s:9:\"DIAPERING\";s:20:\"master_category_slug\";s:9:\"diapering\";s:15:\"section_type_id\";i:20;s:17:\"section_type_name\";s:14:\"POTTY TRAINING\";s:17:\"section_type_slug\";s:14:\"potty-training\";s:11:\"category_id\";i:234;s:13:\"category_name\";s:11:\"Potty Seats\";s:13:\"category_slug\";s:11:\"potty-seats\";}i:361;a:10:{s:26:\"master_category_section_id\";i:362;s:18:\"master_category_id\";i:6;s:20:\"master_category_name\";s:4:\"GEAR\";s:20:\"master_category_slug\";s:4:\"gear\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:235;s:13:\"category_name\";s:22:\"Baby Strollers & Prams\";s:13:\"category_slug\";s:20:\"baby-strollers-prams\";}i:362;a:10:{s:26:\"master_category_section_id\";i:363;s:18:\"master_category_id\";i:6;s:20:\"master_category_name\";s:4:\"GEAR\";s:20:\"master_category_slug\";s:4:\"gear\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:236;s:13:\"category_name\";s:19:\"Ride-ons & Scooters\";s:13:\"category_slug\";s:17:\"ride-ons-scooters\";}i:363;a:10:{s:26:\"master_category_section_id\";i:364;s:18:\"master_category_id\";i:6;s:20:\"master_category_name\";s:4:\"GEAR\";s:20:\"master_category_slug\";s:4:\"gear\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:151;s:13:\"category_name\";s:25:\"Battery Operated Ride-ons\";s:13:\"category_slug\";s:25:\"battery-operated-ride-ons\";}i:364;a:10:{s:26:\"master_category_section_id\";i:365;s:18:\"master_category_id\";i:6;s:20:\"master_category_name\";s:4:\"GEAR\";s:20:\"master_category_slug\";s:4:\"gear\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:237;s:13:\"category_name\";s:17:\"Tricycles & Bikes\";s:13:\"category_slug\";s:15:\"tricycles-bikes\";}i:365;a:10:{s:26:\"master_category_section_id\";i:366;s:18:\"master_category_id\";i:6;s:20:\"master_category_name\";s:4:\"GEAR\";s:20:\"master_category_slug\";s:4:\"gear\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:238;s:13:\"category_name\";s:12:\"Baby Walkers\";s:13:\"category_slug\";s:12:\"baby-walkers\";}i:366;a:10:{s:26:\"master_category_section_id\";i:367;s:18:\"master_category_id\";i:6;s:20:\"master_category_name\";s:4:\"GEAR\";s:20:\"master_category_slug\";s:4:\"gear\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:239;s:13:\"category_name\";s:26:\"Bouncers, Rockers & Swings\";s:13:\"category_slug\";s:23:\"bouncers-rockers-swings\";}i:367;a:10:{s:26:\"master_category_section_id\";i:368;s:18:\"master_category_id\";i:6;s:20:\"master_category_name\";s:4:\"GEAR\";s:20:\"master_category_slug\";s:4:\"gear\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:240;s:13:\"category_name\";s:27:\"High Chairs & Booster Seats\";s:13:\"category_slug\";s:25:\"high-chairs-booster-seats\";}i:368;a:10:{s:26:\"master_category_section_id\";i:369;s:18:\"master_category_id\";i:6;s:20:\"master_category_name\";s:4:\"GEAR\";s:20:\"master_category_slug\";s:4:\"gear\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:241;s:13:\"category_name\";s:9:\"Car Seats\";s:13:\"category_slug\";s:9:\"car-seats\";}i:369;a:10:{s:26:\"master_category_section_id\";i:370;s:18:\"master_category_id\";i:6;s:20:\"master_category_name\";s:4:\"GEAR\";s:20:\"master_category_slug\";s:4:\"gear\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:242;s:13:\"category_name\";s:22:\"Baby On Board Stickers\";s:13:\"category_slug\";s:22:\"baby-on-board-stickers\";}i:370;a:10:{s:26:\"master_category_section_id\";i:371;s:18:\"master_category_id\";i:6;s:20:\"master_category_name\";s:4:\"GEAR\";s:20:\"master_category_slug\";s:4:\"gear\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:243;s:13:\"category_name\";s:13:\"Baby Carriers\";s:13:\"category_slug\";s:13:\"baby-carriers\";}i:371;a:10:{s:26:\"master_category_section_id\";i:372;s:18:\"master_category_id\";i:6;s:20:\"master_category_name\";s:4:\"GEAR\";s:20:\"master_category_slug\";s:4:\"gear\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:244;s:13:\"category_name\";s:14:\"Baby Carrycots\";s:13:\"category_slug\";s:14:\"baby-carrycots\";}i:372;a:10:{s:26:\"master_category_section_id\";i:373;s:18:\"master_category_id\";i:6;s:20:\"master_category_name\";s:4:\"GEAR\";s:20:\"master_category_slug\";s:4:\"gear\";s:15:\"section_type_id\";i:21;s:17:\"section_type_name\";s:22:\"BABY STROLLERS & PRAMS\";s:17:\"section_type_slug\";s:20:\"baby-strollers-prams\";s:11:\"category_id\";i:245;s:13:\"category_name\";s:5:\"Prams\";s:13:\"category_slug\";s:5:\"prams\";}i:373;a:10:{s:26:\"master_category_section_id\";i:374;s:18:\"master_category_id\";i:6;s:20:\"master_category_name\";s:4:\"GEAR\";s:20:\"master_category_slug\";s:4:\"gear\";s:15:\"section_type_id\";i:21;s:17:\"section_type_name\";s:22:\"BABY STROLLERS & PRAMS\";s:17:\"section_type_slug\";s:20:\"baby-strollers-prams\";s:11:\"category_id\";i:246;s:13:\"category_name\";s:21:\"Lightweight Strollers\";s:13:\"category_slug\";s:21:\"lightweight-strollers\";}i:374;a:10:{s:26:\"master_category_section_id\";i:375;s:18:\"master_category_id\";i:6;s:20:\"master_category_name\";s:4:\"GEAR\";s:20:\"master_category_slug\";s:4:\"gear\";s:15:\"section_type_id\";i:21;s:17:\"section_type_name\";s:22:\"BABY STROLLERS & PRAMS\";s:17:\"section_type_slug\";s:20:\"baby-strollers-prams\";s:11:\"category_id\";i:247;s:13:\"category_name\";s:22:\"Twin Strollers & Prams\";s:13:\"category_slug\";s:20:\"twin-strollers-prams\";}i:375;a:10:{s:26:\"master_category_section_id\";i:376;s:18:\"master_category_id\";i:6;s:20:\"master_category_name\";s:4:\"GEAR\";s:20:\"master_category_slug\";s:4:\"gear\";s:15:\"section_type_id\";i:21;s:17:\"section_type_name\";s:22:\"BABY STROLLERS & PRAMS\";s:17:\"section_type_slug\";s:20:\"baby-strollers-prams\";s:11:\"category_id\";i:248;s:13:\"category_name\";s:18:\"Standard Strollers\";s:13:\"category_slug\";s:18:\"standard-strollers\";}i:376;a:10:{s:26:\"master_category_section_id\";i:377;s:18:\"master_category_id\";i:6;s:20:\"master_category_name\";s:4:\"GEAR\";s:20:\"master_category_slug\";s:4:\"gear\";s:15:\"section_type_id\";i:21;s:17:\"section_type_name\";s:22:\"BABY STROLLERS & PRAMS\";s:17:\"section_type_slug\";s:20:\"baby-strollers-prams\";s:11:\"category_id\";i:249;s:13:\"category_name\";s:14:\"Travel Systems\";s:13:\"category_slug\";s:14:\"travel-systems\";}i:377;a:10:{s:26:\"master_category_section_id\";i:378;s:18:\"master_category_id\";i:6;s:20:\"master_category_name\";s:4:\"GEAR\";s:20:\"master_category_slug\";s:4:\"gear\";s:15:\"section_type_id\";i:10;s:17:\"section_type_name\";s:19:\"RIDE-ONS & SCOOTERS\";s:17:\"section_type_slug\";s:17:\"ride-ons-scooters\";s:11:\"category_id\";i:151;s:13:\"category_name\";s:25:\"Battery Operated Ride-ons\";s:13:\"category_slug\";s:25:\"battery-operated-ride-ons\";}i:378;a:10:{s:26:\"master_category_section_id\";i:379;s:18:\"master_category_id\";i:6;s:20:\"master_category_name\";s:4:\"GEAR\";s:20:\"master_category_slug\";s:4:\"gear\";s:15:\"section_type_id\";i:10;s:17:\"section_type_name\";s:19:\"RIDE-ONS & SCOOTERS\";s:17:\"section_type_slug\";s:17:\"ride-ons-scooters\";s:11:\"category_id\";i:152;s:13:\"category_name\";s:20:\"Manual Push Ride-ons\";s:13:\"category_slug\";s:20:\"manual-push-ride-ons\";}i:379;a:10:{s:26:\"master_category_section_id\";i:380;s:18:\"master_category_id\";i:6;s:20:\"master_category_name\";s:4:\"GEAR\";s:20:\"master_category_slug\";s:4:\"gear\";s:15:\"section_type_id\";i:10;s:17:\"section_type_name\";s:19:\"RIDE-ONS & SCOOTERS\";s:17:\"section_type_slug\";s:17:\"ride-ons-scooters\";s:11:\"category_id\";i:250;s:13:\"category_name\";s:18:\"Twister/Swing Cars\";s:13:\"category_slug\";s:17:\"twisterswing-cars\";}i:380;a:10:{s:26:\"master_category_section_id\";i:381;s:18:\"master_category_id\";i:6;s:20:\"master_category_name\";s:4:\"GEAR\";s:20:\"master_category_slug\";s:4:\"gear\";s:15:\"section_type_id\";i:10;s:17:\"section_type_name\";s:19:\"RIDE-ONS & SCOOTERS\";s:17:\"section_type_slug\";s:17:\"ride-ons-scooters\";s:11:\"category_id\";i:251;s:13:\"category_name\";s:13:\"Kids Scooters\";s:13:\"category_slug\";s:13:\"kids-scooters\";}i:381;a:10:{s:26:\"master_category_section_id\";i:382;s:18:\"master_category_id\";i:6;s:20:\"master_category_name\";s:4:\"GEAR\";s:20:\"master_category_slug\";s:4:\"gear\";s:15:\"section_type_id\";i:10;s:17:\"section_type_name\";s:19:\"RIDE-ONS & SCOOTERS\";s:17:\"section_type_slug\";s:17:\"ride-ons-scooters\";s:11:\"category_id\";i:252;s:13:\"category_name\";s:16:\"Rocking Ride-ons\";s:13:\"category_slug\";s:16:\"rocking-ride-ons\";}i:382;a:10:{s:26:\"master_category_section_id\";i:383;s:18:\"master_category_id\";i:6;s:20:\"master_category_name\";s:4:\"GEAR\";s:20:\"master_category_slug\";s:4:\"gear\";s:15:\"section_type_id\";i:10;s:17:\"section_type_name\";s:19:\"RIDE-ONS & SCOOTERS\";s:17:\"section_type_slug\";s:17:\"ride-ons-scooters\";s:11:\"category_id\";i:253;s:13:\"category_name\";s:15:\"Protective Gear\";s:13:\"category_slug\";s:15:\"protective-gear\";}i:383;a:10:{s:26:\"master_category_section_id\";i:384;s:18:\"master_category_id\";i:6;s:20:\"master_category_name\";s:4:\"GEAR\";s:20:\"master_category_slug\";s:4:\"gear\";s:15:\"section_type_id\";i:10;s:17:\"section_type_name\";s:19:\"RIDE-ONS & SCOOTERS\";s:17:\"section_type_slug\";s:17:\"ride-ons-scooters\";s:11:\"category_id\";i:254;s:13:\"category_name\";s:20:\"Skates & Skateboards\";s:13:\"category_slug\";s:18:\"skates-skateboards\";}i:384;a:10:{s:26:\"master_category_section_id\";i:385;s:18:\"master_category_id\";i:6;s:20:\"master_category_name\";s:4:\"GEAR\";s:20:\"master_category_slug\";s:4:\"gear\";s:15:\"section_type_id\";i:22;s:17:\"section_type_name\";s:12:\"BABY WALKERS\";s:17:\"section_type_slug\";s:12:\"baby-walkers\";s:11:\"category_id\";i:255;s:13:\"category_name\";s:25:\"Musical & Regular Walkers\";s:13:\"category_slug\";s:23:\"musical-regular-walkers\";}i:385;a:10:{s:26:\"master_category_section_id\";i:386;s:18:\"master_category_id\";i:6;s:20:\"master_category_name\";s:4:\"GEAR\";s:20:\"master_category_slug\";s:4:\"gear\";s:15:\"section_type_id\";i:22;s:17:\"section_type_name\";s:12:\"BABY WALKERS\";s:17:\"section_type_slug\";s:12:\"baby-walkers\";s:11:\"category_id\";i:256;s:13:\"category_name\";s:23:\"Activity / Push Walkers\";s:13:\"category_slug\";s:21:\"activity-push-walkers\";}i:386;a:10:{s:26:\"master_category_section_id\";i:387;s:18:\"master_category_id\";i:6;s:20:\"master_category_name\";s:4:\"GEAR\";s:20:\"master_category_slug\";s:4:\"gear\";s:15:\"section_type_id\";i:22;s:17:\"section_type_name\";s:12:\"BABY WALKERS\";s:17:\"section_type_slug\";s:12:\"baby-walkers\";s:11:\"category_id\";i:257;s:13:\"category_name\";s:18:\"Walker Cum Rockers\";s:13:\"category_slug\";s:18:\"walker-cum-rockers\";}i:387;a:10:{s:26:\"master_category_section_id\";i:388;s:18:\"master_category_id\";i:6;s:20:\"master_category_name\";s:4:\"GEAR\";s:20:\"master_category_slug\";s:4:\"gear\";s:15:\"section_type_id\";i:23;s:17:\"section_type_name\";s:17:\"CAR SEATS BY TYPE\";s:17:\"section_type_slug\";s:17:\"car-seats-by-type\";s:11:\"category_id\";i:258;s:13:\"category_name\";s:47:\"Convertible Car Seats (Rear and Forward-facing)\";s:13:\"category_slug\";s:45:\"convertible-car-seats-rear-and-forward-facing\";}i:388;a:10:{s:26:\"master_category_section_id\";i:389;s:18:\"master_category_id\";i:6;s:20:\"master_category_name\";s:4:\"GEAR\";s:20:\"master_category_slug\";s:4:\"gear\";s:15:\"section_type_id\";i:23;s:17:\"section_type_name\";s:17:\"CAR SEATS BY TYPE\";s:17:\"section_type_slug\";s:17:\"car-seats-by-type\";s:11:\"category_id\";i:259;s:13:\"category_name\";s:26:\"Rear-facing Baby Car Seats\";s:13:\"category_slug\";s:26:\"rear-facing-baby-car-seats\";}i:389;a:10:{s:26:\"master_category_section_id\";i:390;s:18:\"master_category_id\";i:6;s:20:\"master_category_name\";s:4:\"GEAR\";s:20:\"master_category_slug\";s:4:\"gear\";s:15:\"section_type_id\";i:23;s:17:\"section_type_name\";s:17:\"CAR SEATS BY TYPE\";s:17:\"section_type_slug\";s:17:\"car-seats-by-type\";s:11:\"category_id\";i:260;s:13:\"category_name\";s:30:\"Forward-facing Child Car Seats\";s:13:\"category_slug\";s:30:\"forward-facing-child-car-seats\";}i:390;a:10:{s:26:\"master_category_section_id\";i:391;s:18:\"master_category_id\";i:6;s:20:\"master_category_name\";s:4:\"GEAR\";s:20:\"master_category_slug\";s:4:\"gear\";s:15:\"section_type_id\";i:23;s:17:\"section_type_name\";s:17:\"CAR SEATS BY TYPE\";s:17:\"section_type_slug\";s:17:\"car-seats-by-type\";s:11:\"category_id\";i:261;s:13:\"category_name\";s:26:\"Backless Booster Car Seats\";s:13:\"category_slug\";s:26:\"backless-booster-car-seats\";}i:391;a:10:{s:26:\"master_category_section_id\";i:392;s:18:\"master_category_id\";i:6;s:20:\"master_category_name\";s:4:\"GEAR\";s:20:\"master_category_slug\";s:4:\"gear\";s:15:\"section_type_id\";i:24;s:17:\"section_type_name\";s:25:\"CAR SEATS BY CHILD WEIGHT\";s:17:\"section_type_slug\";s:25:\"car-seats-by-child-weight\";s:11:\"category_id\";i:262;s:13:\"category_name\";s:10:\"Upto 9 Kgs\";s:13:\"category_slug\";s:10:\"upto-9-kgs\";}i:392;a:10:{s:26:\"master_category_section_id\";i:393;s:18:\"master_category_id\";i:6;s:20:\"master_category_name\";s:4:\"GEAR\";s:20:\"master_category_slug\";s:4:\"gear\";s:15:\"section_type_id\";i:24;s:17:\"section_type_name\";s:25:\"CAR SEATS BY CHILD WEIGHT\";s:17:\"section_type_slug\";s:25:\"car-seats-by-child-weight\";s:11:\"category_id\";i:263;s:13:\"category_name\";s:11:\"Upto 15 Kgs\";s:13:\"category_slug\";s:11:\"upto-15-kgs\";}i:393;a:10:{s:26:\"master_category_section_id\";i:394;s:18:\"master_category_id\";i:6;s:20:\"master_category_name\";s:4:\"GEAR\";s:20:\"master_category_slug\";s:4:\"gear\";s:15:\"section_type_id\";i:24;s:17:\"section_type_name\";s:25:\"CAR SEATS BY CHILD WEIGHT\";s:17:\"section_type_slug\";s:25:\"car-seats-by-child-weight\";s:11:\"category_id\";i:264;s:13:\"category_name\";s:11:\"Upto 22 Kgs\";s:13:\"category_slug\";s:11:\"upto-22-kgs\";}i:394;a:10:{s:26:\"master_category_section_id\";i:395;s:18:\"master_category_id\";i:6;s:20:\"master_category_name\";s:4:\"GEAR\";s:20:\"master_category_slug\";s:4:\"gear\";s:15:\"section_type_id\";i:24;s:17:\"section_type_name\";s:25:\"CAR SEATS BY CHILD WEIGHT\";s:17:\"section_type_slug\";s:25:\"car-seats-by-child-weight\";s:11:\"category_id\";i:265;s:13:\"category_name\";s:11:\"Upto 36 Kgs\";s:13:\"category_slug\";s:11:\"upto-36-kgs\";}i:395;a:10:{s:26:\"master_category_section_id\";i:396;s:18:\"master_category_id\";i:6;s:20:\"master_category_name\";s:4:\"GEAR\";s:20:\"master_category_slug\";s:4:\"gear\";s:15:\"section_type_id\";i:25;s:17:\"section_type_name\";s:25:\"BATTERY OPERATED RIDE-ONS\";s:17:\"section_type_slug\";s:25:\"battery-operated-ride-ons\";s:11:\"category_id\";i:266;s:13:\"category_name\";s:4:\"Cars\";s:13:\"category_slug\";s:4:\"cars\";}i:396;a:10:{s:26:\"master_category_section_id\";i:397;s:18:\"master_category_id\";i:6;s:20:\"master_category_name\";s:4:\"GEAR\";s:20:\"master_category_slug\";s:4:\"gear\";s:15:\"section_type_id\";i:25;s:17:\"section_type_name\";s:25:\"BATTERY OPERATED RIDE-ONS\";s:17:\"section_type_slug\";s:25:\"battery-operated-ride-ons\";s:11:\"category_id\";i:267;s:13:\"category_name\";s:18:\"Bikes and Scooters\";s:13:\"category_slug\";s:18:\"bikes-and-scooters\";}i:397;a:10:{s:26:\"master_category_section_id\";i:398;s:18:\"master_category_id\";i:6;s:20:\"master_category_name\";s:4:\"GEAR\";s:20:\"master_category_slug\";s:4:\"gear\";s:15:\"section_type_id\";i:25;s:17:\"section_type_name\";s:25:\"BATTERY OPERATED RIDE-ONS\";s:17:\"section_type_slug\";s:25:\"battery-operated-ride-ons\";s:11:\"category_id\";i:268;s:13:\"category_name\";s:4:\"ATVs\";s:13:\"category_slug\";s:4:\"atvs\";}i:398;a:10:{s:26:\"master_category_section_id\";i:399;s:18:\"master_category_id\";i:6;s:20:\"master_category_name\";s:4:\"GEAR\";s:20:\"master_category_slug\";s:4:\"gear\";s:15:\"section_type_id\";i:25;s:17:\"section_type_name\";s:25:\"BATTERY OPERATED RIDE-ONS\";s:17:\"section_type_slug\";s:25:\"battery-operated-ride-ons\";s:11:\"category_id\";i:269;s:13:\"category_name\";s:5:\"Jeeps\";s:13:\"category_slug\";s:5:\"jeeps\";}i:399;a:10:{s:26:\"master_category_section_id\";i:400;s:18:\"master_category_id\";i:6;s:20:\"master_category_name\";s:4:\"GEAR\";s:20:\"master_category_slug\";s:4:\"gear\";s:15:\"section_type_id\";i:26;s:17:\"section_type_name\";s:17:\"TRICYCLES & BIKES\";s:17:\"section_type_slug\";s:15:\"tricycles-bikes\";s:11:\"category_id\";i:156;s:13:\"category_name\";s:9:\"Tricycles\";s:13:\"category_slug\";s:9:\"tricycles\";}i:400;a:10:{s:26:\"master_category_section_id\";i:401;s:18:\"master_category_id\";i:6;s:20:\"master_category_name\";s:4:\"GEAR\";s:20:\"master_category_slug\";s:4:\"gear\";s:15:\"section_type_id\";i:26;s:17:\"section_type_name\";s:17:\"TRICYCLES & BIKES\";s:17:\"section_type_slug\";s:15:\"tricycles-bikes\";s:11:\"category_id\";i:157;s:13:\"category_name\";s:8:\"Bicycles\";s:13:\"category_slug\";s:8:\"bicycles\";}i:401;a:10:{s:26:\"master_category_section_id\";i:402;s:18:\"master_category_id\";i:6;s:20:\"master_category_name\";s:4:\"GEAR\";s:20:\"master_category_slug\";s:4:\"gear\";s:15:\"section_type_id\";i:26;s:17:\"section_type_name\";s:17:\"TRICYCLES & BIKES\";s:17:\"section_type_slug\";s:15:\"tricycles-bikes\";s:11:\"category_id\";i:270;s:13:\"category_name\";s:24:\"Training / Balance Bikes\";s:13:\"category_slug\";s:22:\"training-balance-bikes\";}i:402;a:10:{s:26:\"master_category_section_id\";i:403;s:18:\"master_category_id\";i:6;s:20:\"master_category_name\";s:4:\"GEAR\";s:20:\"master_category_slug\";s:4:\"gear\";s:15:\"section_type_id\";i:27;s:17:\"section_type_name\";s:27:\"HIGH CHAIRS & BOOSTER SEATS\";s:17:\"section_type_slug\";s:25:\"high-chairs-booster-seats\";s:11:\"category_id\";i:271;s:13:\"category_name\";s:11:\"High Chairs\";s:13:\"category_slug\";s:11:\"high-chairs\";}i:403;a:10:{s:26:\"master_category_section_id\";i:404;s:18:\"master_category_id\";i:6;s:20:\"master_category_name\";s:4:\"GEAR\";s:20:\"master_category_slug\";s:4:\"gear\";s:15:\"section_type_id\";i:27;s:17:\"section_type_name\";s:27:\"HIGH CHAIRS & BOOSTER SEATS\";s:17:\"section_type_slug\";s:25:\"high-chairs-booster-seats\";s:11:\"category_id\";i:272;s:13:\"category_name\";s:18:\"Wooden High Chairs\";s:13:\"category_slug\";s:18:\"wooden-high-chairs\";}i:404;a:10:{s:26:\"master_category_section_id\";i:405;s:18:\"master_category_id\";i:6;s:20:\"master_category_name\";s:4:\"GEAR\";s:20:\"master_category_slug\";s:4:\"gear\";s:15:\"section_type_id\";i:27;s:17:\"section_type_name\";s:27:\"HIGH CHAIRS & BOOSTER SEATS\";s:17:\"section_type_slug\";s:25:\"high-chairs-booster-seats\";s:11:\"category_id\";i:273;s:13:\"category_name\";s:13:\"Booster Seats\";s:13:\"category_slug\";s:13:\"booster-seats\";}i:405;a:10:{s:26:\"master_category_section_id\";i:406;s:18:\"master_category_id\";i:6;s:20:\"master_category_name\";s:4:\"GEAR\";s:20:\"master_category_slug\";s:4:\"gear\";s:15:\"section_type_id\";i:28;s:17:\"section_type_name\";s:20:\"INFANT ACTIVITY TIME\";s:17:\"section_type_slug\";s:20:\"infant-activity-time\";s:11:\"category_id\";i:274;s:13:\"category_name\";s:7:\"Rockers\";s:13:\"category_slug\";s:7:\"rockers\";}i:406;a:10:{s:26:\"master_category_section_id\";i:407;s:18:\"master_category_id\";i:6;s:20:\"master_category_name\";s:4:\"GEAR\";s:20:\"master_category_slug\";s:4:\"gear\";s:15:\"section_type_id\";i:28;s:17:\"section_type_name\";s:20:\"INFANT ACTIVITY TIME\";s:17:\"section_type_slug\";s:20:\"infant-activity-time\";s:11:\"category_id\";i:275;s:13:\"category_name\";s:8:\"Bouncers\";s:13:\"category_slug\";s:8:\"bouncers\";}i:407;a:10:{s:26:\"master_category_section_id\";i:408;s:18:\"master_category_id\";i:6;s:20:\"master_category_name\";s:4:\"GEAR\";s:20:\"master_category_slug\";s:4:\"gear\";s:15:\"section_type_id\";i:28;s:17:\"section_type_name\";s:20:\"INFANT ACTIVITY TIME\";s:17:\"section_type_slug\";s:20:\"infant-activity-time\";s:11:\"category_id\";i:276;s:13:\"category_name\";s:6:\"Swings\";s:13:\"category_slug\";s:6:\"swings\";}i:408;a:10:{s:26:\"master_category_section_id\";i:409;s:18:\"master_category_id\";i:6;s:20:\"master_category_name\";s:4:\"GEAR\";s:20:\"master_category_slug\";s:4:\"gear\";s:15:\"section_type_id\";i:14;s:17:\"section_type_name\";s:10:\"TOP BRANDS\";s:17:\"section_type_slug\";s:10:\"top-brands\";s:11:\"category_id\";i:71;s:13:\"category_name\";s:7:\"Babyhug\";s:13:\"category_slug\";s:7:\"babyhug\";}i:409;a:10:{s:26:\"master_category_section_id\";i:410;s:18:\"master_category_id\";i:6;s:20:\"master_category_name\";s:4:\"GEAR\";s:20:\"master_category_slug\";s:4:\"gear\";s:15:\"section_type_id\";i:14;s:17:\"section_type_name\";s:10:\"TOP BRANDS\";s:17:\"section_type_slug\";s:10:\"top-brands\";s:11:\"category_id\";i:184;s:13:\"category_name\";s:11:\"Fab n Funky\";s:13:\"category_slug\";s:11:\"fab-n-funky\";}i:410;a:10:{s:26:\"master_category_section_id\";i:411;s:18:\"master_category_id\";i:6;s:20:\"master_category_name\";s:4:\"GEAR\";s:20:\"master_category_slug\";s:4:\"gear\";s:15:\"section_type_id\";i:14;s:17:\"section_type_name\";s:10:\"TOP BRANDS\";s:17:\"section_type_slug\";s:10:\"top-brands\";s:11:\"category_id\";i:277;s:13:\"category_name\";s:12:\"R for Rabbit\";s:13:\"category_slug\";s:12:\"r-for-rabbit\";}i:411;a:10:{s:26:\"master_category_section_id\";i:412;s:18:\"master_category_id\";i:6;s:20:\"master_category_name\";s:4:\"GEAR\";s:20:\"master_category_slug\";s:4:\"gear\";s:15:\"section_type_id\";i:14;s:17:\"section_type_name\";s:10:\"TOP BRANDS\";s:17:\"section_type_slug\";s:10:\"top-brands\";s:11:\"category_id\";i:278;s:13:\"category_name\";s:6:\"Baybee\";s:13:\"category_slug\";s:6:\"baybee\";}i:412;a:10:{s:26:\"master_category_section_id\";i:413;s:18:\"master_category_id\";i:6;s:20:\"master_category_name\";s:4:\"GEAR\";s:20:\"master_category_slug\";s:4:\"gear\";s:15:\"section_type_id\";i:14;s:17:\"section_type_name\";s:10:\"TOP BRANDS\";s:17:\"section_type_slug\";s:10:\"top-brands\";s:11:\"category_id\";i:279;s:13:\"category_name\";s:7:\"Luv Lap\";s:13:\"category_slug\";s:7:\"luv-lap\";}i:413;a:10:{s:26:\"master_category_section_id\";i:414;s:18:\"master_category_id\";i:6;s:20:\"master_category_name\";s:4:\"GEAR\";s:20:\"master_category_slug\";s:4:\"gear\";s:15:\"section_type_id\";i:14;s:17:\"section_type_name\";s:10:\"TOP BRANDS\";s:17:\"section_type_slug\";s:10:\"top-brands\";s:11:\"category_id\";i:280;s:13:\"category_name\";s:4:\"Dash\";s:13:\"category_slug\";s:4:\"dash\";}i:414;a:10:{s:26:\"master_category_section_id\";i:415;s:18:\"master_category_id\";i:6;s:20:\"master_category_name\";s:4:\"GEAR\";s:20:\"master_category_slug\";s:4:\"gear\";s:15:\"section_type_id\";i:14;s:17:\"section_type_name\";s:10:\"TOP BRANDS\";s:17:\"section_type_slug\";s:10:\"top-brands\";s:11:\"category_id\";i:281;s:13:\"category_name\";s:12:\"StarAndDaisy\";s:13:\"category_slug\";s:12:\"staranddaisy\";}i:415;a:10:{s:26:\"master_category_section_id\";i:416;s:18:\"master_category_id\";i:6;s:20:\"master_category_name\";s:4:\"GEAR\";s:20:\"master_category_slug\";s:4:\"gear\";s:15:\"section_type_id\";i:14;s:17:\"section_type_name\";s:10:\"TOP BRANDS\";s:17:\"section_type_slug\";s:10:\"top-brands\";s:11:\"category_id\";i:282;s:13:\"category_name\";s:7:\"Mastela\";s:13:\"category_slug\";s:7:\"mastela\";}i:416;a:10:{s:26:\"master_category_section_id\";i:417;s:18:\"master_category_id\";i:6;s:20:\"master_category_name\";s:4:\"GEAR\";s:20:\"master_category_slug\";s:4:\"gear\";s:15:\"section_type_id\";i:14;s:17:\"section_type_name\";s:10:\"TOP BRANDS\";s:17:\"section_type_slug\";s:10:\"top-brands\";s:11:\"category_id\";i:283;s:13:\"category_name\";s:11:\"Play Nation\";s:13:\"category_slug\";s:11:\"play-nation\";}i:417;a:10:{s:26:\"master_category_section_id\";i:418;s:18:\"master_category_id\";i:6;s:20:\"master_category_name\";s:4:\"GEAR\";s:20:\"master_category_slug\";s:4:\"gear\";s:15:\"section_type_id\";i:14;s:17:\"section_type_name\";s:10:\"TOP BRANDS\";s:17:\"section_type_slug\";s:10:\"top-brands\";s:11:\"category_id\";i:284;s:13:\"category_name\";s:4:\"Joie\";s:13:\"category_slug\";s:4:\"joie\";}i:418;a:10:{s:26:\"master_category_section_id\";i:419;s:18:\"master_category_id\";i:7;s:20:\"master_category_name\";s:7:\"FEEDING\";s:20:\"master_category_slug\";s:7:\"feeding\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:285;s:13:\"category_name\";s:26:\"Baby Food & Infant Formula\";s:13:\"category_slug\";s:24:\"baby-food-infant-formula\";}i:419;a:10:{s:26:\"master_category_section_id\";i:420;s:18:\"master_category_id\";i:7;s:20:\"master_category_name\";s:7:\"FEEDING\";s:20:\"master_category_slug\";s:7:\"feeding\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:286;s:13:\"category_name\";s:23:\"Feeding Bottles & Teats\";s:13:\"category_slug\";s:21:\"feeding-bottles-teats\";}i:420;a:10:{s:26:\"master_category_section_id\";i:421;s:18:\"master_category_id\";i:7;s:20:\"master_category_name\";s:7:\"FEEDING\";s:20:\"master_category_slug\";s:7:\"feeding\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:287;s:13:\"category_name\";s:14:\"Breast Feeding\";s:13:\"category_slug\";s:14:\"breast-feeding\";}i:421;a:10:{s:26:\"master_category_section_id\";i:422;s:18:\"master_category_id\";i:7;s:20:\"master_category_name\";s:7:\"FEEDING\";s:20:\"master_category_slug\";s:7:\"feeding\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:288;s:13:\"category_name\";s:14:\"Sippers & Cups\";s:13:\"category_slug\";s:12:\"sippers-cups\";}i:422;a:10:{s:26:\"master_category_section_id\";i:423;s:18:\"master_category_id\";i:7;s:20:\"master_category_name\";s:7:\"FEEDING\";s:20:\"master_category_slug\";s:7:\"feeding\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:289;s:13:\"category_name\";s:14:\"Bibs & Hankies\";s:13:\"category_slug\";s:12:\"bibs-hankies\";}i:423;a:10:{s:26:\"master_category_section_id\";i:424;s:18:\"master_category_id\";i:7;s:20:\"master_category_name\";s:7:\"FEEDING\";s:20:\"master_category_slug\";s:7:\"feeding\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:290;s:13:\"category_name\";s:24:\"Kids Foods & Supplements\";s:13:\"category_slug\";s:22:\"kids-foods-supplements\";}i:424;a:10:{s:26:\"master_category_section_id\";i:425;s:18:\"master_category_id\";i:7;s:20:\"master_category_name\";s:7:\"FEEDING\";s:20:\"master_category_slug\";s:7:\"feeding\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:291;s:13:\"category_name\";s:17:\"Dishes & Utensils\";s:13:\"category_slug\";s:15:\"dishes-utensils\";}i:425;a:10:{s:26:\"master_category_section_id\";i:426;s:18:\"master_category_id\";i:7;s:20:\"master_category_name\";s:7:\"FEEDING\";s:20:\"master_category_slug\";s:7:\"feeding\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:292;s:13:\"category_name\";s:20:\"Teethers & Pacifiers\";s:13:\"category_slug\";s:18:\"teethers-pacifiers\";}i:426;a:10:{s:26:\"master_category_section_id\";i:427;s:18:\"master_category_id\";i:7;s:20:\"master_category_name\";s:7:\"FEEDING\";s:20:\"master_category_slug\";s:7:\"feeding\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:293;s:13:\"category_name\";s:21:\"Sterilizers & Warmers\";s:13:\"category_slug\";s:19:\"sterilizers-warmers\";}i:427;a:10:{s:26:\"master_category_section_id\";i:428;s:18:\"master_category_id\";i:7;s:20:\"master_category_name\";s:7:\"FEEDING\";s:20:\"master_category_slug\";s:7:\"feeding\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:294;s:13:\"category_name\";s:19:\"Feeding Accessories\";s:13:\"category_slug\";s:19:\"feeding-accessories\";}i:428;a:10:{s:26:\"master_category_section_id\";i:429;s:18:\"master_category_id\";i:7;s:20:\"master_category_name\";s:7:\"FEEDING\";s:20:\"master_category_slug\";s:7:\"feeding\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:295;s:13:\"category_name\";s:23:\"Feeding Bottle Cleaning\";s:13:\"category_slug\";s:23:\"feeding-bottle-cleaning\";}i:429;a:10:{s:26:\"master_category_section_id\";i:430;s:18:\"master_category_id\";i:7;s:20:\"master_category_name\";s:7:\"FEEDING\";s:20:\"master_category_slug\";s:7:\"feeding\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:296;s:13:\"category_name\";s:18:\"Kitchen Appliances\";s:13:\"category_slug\";s:18:\"kitchen-appliances\";}i:430;a:10:{s:26:\"master_category_section_id\";i:431;s:18:\"master_category_id\";i:7;s:20:\"master_category_name\";s:7:\"FEEDING\";s:20:\"master_category_slug\";s:7:\"feeding\";s:15:\"section_type_id\";i:29;s:17:\"section_type_name\";s:26:\"BABY FOOD & INFANT FORMULA\";s:17:\"section_type_slug\";s:24:\"baby-food-infant-formula\";s:11:\"category_id\";i:297;s:13:\"category_name\";s:25:\"Dry Milk Powder / Formula\";s:13:\"category_slug\";s:23:\"dry-milk-powder-formula\";}i:431;a:10:{s:26:\"master_category_section_id\";i:432;s:18:\"master_category_id\";i:7;s:20:\"master_category_name\";s:7:\"FEEDING\";s:20:\"master_category_slug\";s:7:\"feeding\";s:15:\"section_type_id\";i:29;s:17:\"section_type_name\";s:26:\"BABY FOOD & INFANT FORMULA\";s:17:\"section_type_slug\";s:24:\"baby-food-infant-formula\";s:11:\"category_id\";i:298;s:13:\"category_name\";s:23:\"Porridge/Cereals/Grains\";s:13:\"category_slug\";s:21:\"porridgecerealsgrains\";}i:432;a:10:{s:26:\"master_category_section_id\";i:433;s:18:\"master_category_id\";i:7;s:20:\"master_category_name\";s:7:\"FEEDING\";s:20:\"master_category_slug\";s:7:\"feeding\";s:15:\"section_type_id\";i:29;s:17:\"section_type_name\";s:26:\"BABY FOOD & INFANT FORMULA\";s:17:\"section_type_slug\";s:24:\"baby-food-infant-formula\";s:11:\"category_id\";i:299;s:13:\"category_name\";s:27:\"Puree - Fruits & Vegetables\";s:13:\"category_slug\";s:23:\"puree-fruits-vegetables\";}i:433;a:10:{s:26:\"master_category_section_id\";i:434;s:18:\"master_category_id\";i:7;s:20:\"master_category_name\";s:7:\"FEEDING\";s:20:\"master_category_slug\";s:7:\"feeding\";s:15:\"section_type_id\";i:29;s:17:\"section_type_name\";s:26:\"BABY FOOD & INFANT FORMULA\";s:17:\"section_type_slug\";s:24:\"baby-food-infant-formula\";s:11:\"category_id\";i:300;s:13:\"category_name\";s:20:\"Finger Food / Snacks\";s:13:\"category_slug\";s:18:\"finger-food-snacks\";}i:434;a:10:{s:26:\"master_category_section_id\";i:435;s:18:\"master_category_id\";i:7;s:20:\"master_category_name\";s:7:\"FEEDING\";s:20:\"master_category_slug\";s:7:\"feeding\";s:15:\"section_type_id\";i:29;s:17:\"section_type_name\";s:26:\"BABY FOOD & INFANT FORMULA\";s:17:\"section_type_slug\";s:24:\"baby-food-infant-formula\";s:11:\"category_id\";i:301;s:13:\"category_name\";s:22:\"Add on Nutritional Mix\";s:13:\"category_slug\";s:22:\"add-on-nutritional-mix\";}i:435;a:10:{s:26:\"master_category_section_id\";i:436;s:18:\"master_category_id\";i:7;s:20:\"master_category_name\";s:7:\"FEEDING\";s:20:\"master_category_slug\";s:7:\"feeding\";s:15:\"section_type_id\";i:30;s:17:\"section_type_name\";s:14:\"BREAST FEEDING\";s:17:\"section_type_slug\";s:14:\"breast-feeding\";s:11:\"category_id\";i:302;s:13:\"category_name\";s:12:\"Breast Pumps\";s:13:\"category_slug\";s:12:\"breast-pumps\";}i:436;a:10:{s:26:\"master_category_section_id\";i:437;s:18:\"master_category_id\";i:7;s:20:\"master_category_name\";s:7:\"FEEDING\";s:20:\"master_category_slug\";s:7:\"feeding\";s:15:\"section_type_id\";i:30;s:17:\"section_type_name\";s:14:\"BREAST FEEDING\";s:17:\"section_type_slug\";s:14:\"breast-feeding\";s:11:\"category_id\";i:303;s:13:\"category_name\";s:20:\"Electric Breast Pump\";s:13:\"category_slug\";s:20:\"electric-breast-pump\";}i:437;a:10:{s:26:\"master_category_section_id\";i:438;s:18:\"master_category_id\";i:7;s:20:\"master_category_name\";s:7:\"FEEDING\";s:20:\"master_category_slug\";s:7:\"feeding\";s:15:\"section_type_id\";i:30;s:17:\"section_type_name\";s:14:\"BREAST FEEDING\";s:17:\"section_type_slug\";s:14:\"breast-feeding\";s:11:\"category_id\";i:304;s:13:\"category_name\";s:18:\"Manual Breast Pump\";s:13:\"category_slug\";s:18:\"manual-breast-pump\";}i:438;a:10:{s:26:\"master_category_section_id\";i:439;s:18:\"master_category_id\";i:7;s:20:\"master_category_name\";s:7:\"FEEDING\";s:20:\"master_category_slug\";s:7:\"feeding\";s:15:\"section_type_id\";i:30;s:17:\"section_type_name\";s:14:\"BREAST FEEDING\";s:17:\"section_type_slug\";s:14:\"breast-feeding\";s:11:\"category_id\";i:305;s:13:\"category_name\";s:11:\"Breast Pads\";s:13:\"category_slug\";s:11:\"breast-pads\";}i:439;a:10:{s:26:\"master_category_section_id\";i:440;s:18:\"master_category_id\";i:7;s:20:\"master_category_name\";s:7:\"FEEDING\";s:20:\"master_category_slug\";s:7:\"feeding\";s:15:\"section_type_id\";i:30;s:17:\"section_type_name\";s:14:\"BREAST FEEDING\";s:17:\"section_type_slug\";s:14:\"breast-feeding\";s:11:\"category_id\";i:306;s:13:\"category_name\";s:14:\"Nipple Shields\";s:13:\"category_slug\";s:14:\"nipple-shields\";}i:440;a:10:{s:26:\"master_category_section_id\";i:441;s:18:\"master_category_id\";i:7;s:20:\"master_category_name\";s:7:\"FEEDING\";s:20:\"master_category_slug\";s:7:\"feeding\";s:15:\"section_type_id\";i:30;s:17:\"section_type_name\";s:14:\"BREAST FEEDING\";s:17:\"section_type_slug\";s:14:\"breast-feeding\";s:11:\"category_id\";i:307;s:13:\"category_name\";s:14:\"Nipple Pullers\";s:13:\"category_slug\";s:14:\"nipple-pullers\";}i:441;a:10:{s:26:\"master_category_section_id\";i:442;s:18:\"master_category_id\";i:7;s:20:\"master_category_name\";s:7:\"FEEDING\";s:20:\"master_category_slug\";s:7:\"feeding\";s:15:\"section_type_id\";i:30;s:17:\"section_type_name\";s:14:\"BREAST FEEDING\";s:17:\"section_type_slug\";s:14:\"breast-feeding\";s:11:\"category_id\";i:308;s:13:\"category_name\";s:19:\"Breast Milk Storage\";s:13:\"category_slug\";s:19:\"breast-milk-storage\";}i:442;a:10:{s:26:\"master_category_section_id\";i:443;s:18:\"master_category_id\";i:7;s:20:\"master_category_name\";s:7:\"FEEDING\";s:20:\"master_category_slug\";s:7:\"feeding\";s:15:\"section_type_id\";i:30;s:17:\"section_type_name\";s:14:\"BREAST FEEDING\";s:17:\"section_type_slug\";s:14:\"breast-feeding\";s:11:\"category_id\";i:309;s:13:\"category_name\";s:24:\"Feeding Pillows & Covers\";s:13:\"category_slug\";s:22:\"feeding-pillows-covers\";}i:443;a:10:{s:26:\"master_category_section_id\";i:444;s:18:\"master_category_id\";i:7;s:20:\"master_category_name\";s:7:\"FEEDING\";s:20:\"master_category_slug\";s:7:\"feeding\";s:15:\"section_type_id\";i:30;s:17:\"section_type_name\";s:14:\"BREAST FEEDING\";s:17:\"section_type_slug\";s:14:\"breast-feeding\";s:11:\"category_id\";i:310;s:13:\"category_name\";s:21:\"Nursing Covers & Bibs\";s:13:\"category_slug\";s:19:\"nursing-covers-bibs\";}i:444;a:10:{s:26:\"master_category_section_id\";i:445;s:18:\"master_category_id\";i:7;s:20:\"master_category_name\";s:7:\"FEEDING\";s:20:\"master_category_slug\";s:7:\"feeding\";s:15:\"section_type_id\";i:30;s:17:\"section_type_name\";s:14:\"BREAST FEEDING\";s:17:\"section_type_slug\";s:14:\"breast-feeding\";s:11:\"category_id\";i:311;s:13:\"category_name\";s:12:\"Nursing Bras\";s:13:\"category_slug\";s:12:\"nursing-bras\";}i:445;a:10:{s:26:\"master_category_section_id\";i:446;s:18:\"master_category_id\";i:7;s:20:\"master_category_name\";s:7:\"FEEDING\";s:20:\"master_category_slug\";s:7:\"feeding\";s:15:\"section_type_id\";i:31;s:17:\"section_type_name\";s:22:\"FEEDING BOTTLES & ACC.\";s:17:\"section_type_slug\";s:19:\"feeding-bottles-acc\";s:11:\"category_id\";i:312;s:13:\"category_name\";s:15:\"Feeding Bottles\";s:13:\"category_slug\";s:15:\"feeding-bottles\";}i:446;a:10:{s:26:\"master_category_section_id\";i:447;s:18:\"master_category_id\";i:7;s:20:\"master_category_name\";s:7:\"FEEDING\";s:20:\"master_category_slug\";s:7:\"feeding\";s:15:\"section_type_id\";i:31;s:17:\"section_type_name\";s:22:\"FEEDING BOTTLES & ACC.\";s:17:\"section_type_slug\";s:19:\"feeding-bottles-acc\";s:11:\"category_id\";i:313;s:13:\"category_name\";s:15:\"Nipples & Teats\";s:13:\"category_slug\";s:13:\"nipples-teats\";}i:447;a:10:{s:26:\"master_category_section_id\";i:448;s:18:\"master_category_id\";i:7;s:20:\"master_category_name\";s:7:\"FEEDING\";s:20:\"master_category_slug\";s:7:\"feeding\";s:15:\"section_type_id\";i:31;s:17:\"section_type_name\";s:22:\"FEEDING BOTTLES & ACC.\";s:17:\"section_type_slug\";s:19:\"feeding-bottles-acc\";s:11:\"category_id\";i:314;s:13:\"category_name\";s:11:\"Food Feeder\";s:13:\"category_slug\";s:11:\"food-feeder\";}i:448;a:10:{s:26:\"master_category_section_id\";i:449;s:18:\"master_category_id\";i:7;s:20:\"master_category_name\";s:7:\"FEEDING\";s:20:\"master_category_slug\";s:7:\"feeding\";s:15:\"section_type_id\";i:31;s:17:\"section_type_name\";s:22:\"FEEDING BOTTLES & ACC.\";s:17:\"section_type_slug\";s:19:\"feeding-bottles-acc\";s:11:\"category_id\";i:315;s:13:\"category_name\";s:20:\"Fruit & Food Nibbler\";s:13:\"category_slug\";s:18:\"fruit-food-nibbler\";}i:449;a:10:{s:26:\"master_category_section_id\";i:450;s:18:\"master_category_id\";i:7;s:20:\"master_category_name\";s:7:\"FEEDING\";s:20:\"master_category_slug\";s:7:\"feeding\";s:15:\"section_type_id\";i:31;s:17:\"section_type_name\";s:22:\"FEEDING BOTTLES & ACC.\";s:17:\"section_type_slug\";s:19:\"feeding-bottles-acc\";s:11:\"category_id\";i:316;s:13:\"category_name\";s:30:\"Bottle Covers & Insulated Bags\";s:13:\"category_slug\";s:28:\"bottle-covers-insulated-bags\";}i:450;a:10:{s:26:\"master_category_section_id\";i:451;s:18:\"master_category_id\";i:7;s:20:\"master_category_name\";s:7:\"FEEDING\";s:20:\"master_category_slug\";s:7:\"feeding\";s:15:\"section_type_id\";i:32;s:17:\"section_type_name\";s:20:\"TEETHERS & PACIFIERS\";s:17:\"section_type_slug\";s:18:\"teethers-pacifiers\";s:11:\"category_id\";i:317;s:13:\"category_name\";s:30:\"Water Filled Silicone Teethers\";s:13:\"category_slug\";s:30:\"water-filled-silicone-teethers\";}i:451;a:10:{s:26:\"master_category_section_id\";i:452;s:18:\"master_category_id\";i:7;s:20:\"master_category_name\";s:7:\"FEEDING\";s:20:\"master_category_slug\";s:7:\"feeding\";s:15:\"section_type_id\";i:32;s:17:\"section_type_name\";s:20:\"TEETHERS & PACIFIERS\";s:17:\"section_type_slug\";s:18:\"teethers-pacifiers\";s:11:\"category_id\";i:318;s:13:\"category_name\";s:17:\"Silicone Teethers\";s:13:\"category_slug\";s:17:\"silicone-teethers\";}i:452;a:10:{s:26:\"master_category_section_id\";i:453;s:18:\"master_category_id\";i:7;s:20:\"master_category_name\";s:7:\"FEEDING\";s:20:\"master_category_slug\";s:7:\"feeding\";s:15:\"section_type_id\";i:32;s:17:\"section_type_name\";s:20:\"TEETHERS & PACIFIERS\";s:17:\"section_type_slug\";s:18:\"teethers-pacifiers\";s:11:\"category_id\";i:319;s:13:\"category_name\";s:9:\"Pacifiers\";s:13:\"category_slug\";s:9:\"pacifiers\";}i:453;a:10:{s:26:\"master_category_section_id\";i:454;s:18:\"master_category_id\";i:7;s:20:\"master_category_name\";s:7:\"FEEDING\";s:20:\"master_category_slug\";s:7:\"feeding\";s:15:\"section_type_id\";i:32;s:17:\"section_type_name\";s:20:\"TEETHERS & PACIFIERS\";s:17:\"section_type_slug\";s:18:\"teethers-pacifiers\";s:11:\"category_id\";i:320;s:13:\"category_name\";s:15:\"Rattle Teethers\";s:13:\"category_slug\";s:15:\"rattle-teethers\";}i:454;a:10:{s:26:\"master_category_section_id\";i:455;s:18:\"master_category_id\";i:7;s:20:\"master_category_name\";s:7:\"FEEDING\";s:20:\"master_category_slug\";s:7:\"feeding\";s:15:\"section_type_id\";i:32;s:17:\"section_type_name\";s:20:\"TEETHERS & PACIFIERS\";s:17:\"section_type_slug\";s:18:\"teethers-pacifiers\";s:11:\"category_id\";i:321;s:13:\"category_name\";s:21:\"Orthodontic Pacifiers\";s:13:\"category_slug\";s:21:\"orthodontic-pacifiers\";}i:455;a:10:{s:26:\"master_category_section_id\";i:456;s:18:\"master_category_id\";i:7;s:20:\"master_category_name\";s:7:\"FEEDING\";s:20:\"master_category_slug\";s:7:\"feeding\";s:15:\"section_type_id\";i:32;s:17:\"section_type_name\";s:20:\"TEETHERS & PACIFIERS\";s:17:\"section_type_slug\";s:18:\"teethers-pacifiers\";s:11:\"category_id\";i:322;s:13:\"category_name\";s:15:\"Wooden Teethers\";s:13:\"category_slug\";s:15:\"wooden-teethers\";}i:456;a:10:{s:26:\"master_category_section_id\";i:457;s:18:\"master_category_id\";i:7;s:20:\"master_category_name\";s:7:\"FEEDING\";s:20:\"master_category_slug\";s:7:\"feeding\";s:15:\"section_type_id\";i:33;s:17:\"section_type_name\";s:20:\"STERLIZERS & WARMERS\";s:17:\"section_type_slug\";s:18:\"sterlizers-warmers\";s:11:\"category_id\";i:323;s:13:\"category_name\";s:18:\"Bottle Sterilizers\";s:13:\"category_slug\";s:18:\"bottle-sterilizers\";}i:457;a:10:{s:26:\"master_category_section_id\";i:458;s:18:\"master_category_id\";i:7;s:20:\"master_category_name\";s:7:\"FEEDING\";s:20:\"master_category_slug\";s:7:\"feeding\";s:15:\"section_type_id\";i:33;s:17:\"section_type_name\";s:20:\"STERLIZERS & WARMERS\";s:17:\"section_type_slug\";s:18:\"sterlizers-warmers\";s:11:\"category_id\";i:324;s:13:\"category_name\";s:21:\"Bottle & Food Warmers\";s:13:\"category_slug\";s:19:\"bottle-food-warmers\";}i:458;a:10:{s:26:\"master_category_section_id\";i:459;s:18:\"master_category_id\";i:7;s:20:\"master_category_name\";s:7:\"FEEDING\";s:20:\"master_category_slug\";s:7:\"feeding\";s:15:\"section_type_id\";i:33;s:17:\"section_type_name\";s:20:\"STERLIZERS & WARMERS\";s:17:\"section_type_slug\";s:18:\"sterlizers-warmers\";s:11:\"category_id\";i:325;s:13:\"category_name\";s:24:\"Multipurpose Sterilizers\";s:13:\"category_slug\";s:24:\"multipurpose-sterilizers\";}i:459;a:10:{s:26:\"master_category_section_id\";i:460;s:18:\"master_category_id\";i:7;s:20:\"master_category_name\";s:7:\"FEEDING\";s:20:\"master_category_slug\";s:7:\"feeding\";s:15:\"section_type_id\";i:34;s:17:\"section_type_name\";s:23:\"FEEDING BOTTLE CLEANING\";s:17:\"section_type_slug\";s:23:\"feeding-bottle-cleaning\";s:11:\"category_id\";i:326;s:13:\"category_name\";s:32:\"Bottle & Nipple Cleaning Brushes\";s:13:\"category_slug\";s:30:\"bottle-nipple-cleaning-brushes\";}i:460;a:10:{s:26:\"master_category_section_id\";i:461;s:18:\"master_category_id\";i:7;s:20:\"master_category_name\";s:7:\"FEEDING\";s:20:\"master_category_slug\";s:7:\"feeding\";s:15:\"section_type_id\";i:34;s:17:\"section_type_name\";s:23:\"FEEDING BOTTLE CLEANING\";s:17:\"section_type_slug\";s:23:\"feeding-bottle-cleaning\";s:11:\"category_id\";i:327;s:13:\"category_name\";s:12:\"Drying Racks\";s:13:\"category_slug\";s:12:\"drying-racks\";}i:461;a:10:{s:26:\"master_category_section_id\";i:462;s:18:\"master_category_id\";i:7;s:20:\"master_category_name\";s:7:\"FEEDING\";s:20:\"master_category_slug\";s:7:\"feeding\";s:15:\"section_type_id\";i:34;s:17:\"section_type_name\";s:23:\"FEEDING BOTTLE CLEANING\";s:17:\"section_type_slug\";s:23:\"feeding-bottle-cleaning\";s:11:\"category_id\";i:328;s:13:\"category_name\";s:19:\"Cleaning Combo Sets\";s:13:\"category_slug\";s:19:\"cleaning-combo-sets\";}i:462;a:10:{s:26:\"master_category_section_id\";i:463;s:18:\"master_category_id\";i:7;s:20:\"master_category_name\";s:7:\"FEEDING\";s:20:\"master_category_slug\";s:7:\"feeding\";s:15:\"section_type_id\";i:34;s:17:\"section_type_name\";s:23:\"FEEDING BOTTLE CLEANING\";s:17:\"section_type_slug\";s:23:\"feeding-bottle-cleaning\";s:11:\"category_id\";i:329;s:13:\"category_name\";s:12:\"Bottle Tongs\";s:13:\"category_slug\";s:12:\"bottle-tongs\";}i:463;a:10:{s:26:\"master_category_section_id\";i:464;s:18:\"master_category_id\";i:7;s:20:\"master_category_name\";s:7:\"FEEDING\";s:20:\"master_category_slug\";s:7:\"feeding\";s:15:\"section_type_id\";i:34;s:17:\"section_type_name\";s:23:\"FEEDING BOTTLE CLEANING\";s:17:\"section_type_slug\";s:23:\"feeding-bottle-cleaning\";s:11:\"category_id\";i:330;s:13:\"category_name\";s:23:\"Multi Purpose Cleansers\";s:13:\"category_slug\";s:23:\"multi-purpose-cleansers\";}i:464;a:10:{s:26:\"master_category_section_id\";i:465;s:18:\"master_category_id\";i:7;s:20:\"master_category_name\";s:7:\"FEEDING\";s:20:\"master_category_slug\";s:7:\"feeding\";s:15:\"section_type_id\";i:35;s:17:\"section_type_name\";s:14:\"SIPPERS & CUPS\";s:17:\"section_type_slug\";s:12:\"sippers-cups\";s:11:\"category_id\";i:331;s:13:\"category_name\";s:13:\"Spout Sippers\";s:13:\"category_slug\";s:13:\"spout-sippers\";}i:465;a:10:{s:26:\"master_category_section_id\";i:466;s:18:\"master_category_id\";i:7;s:20:\"master_category_name\";s:7:\"FEEDING\";s:20:\"master_category_slug\";s:7:\"feeding\";s:15:\"section_type_id\";i:35;s:17:\"section_type_name\";s:14:\"SIPPERS & CUPS\";s:17:\"section_type_slug\";s:12:\"sippers-cups\";s:11:\"category_id\";i:332;s:13:\"category_name\";s:13:\"Straw Sippers\";s:13:\"category_slug\";s:13:\"straw-sippers\";}i:466;a:10:{s:26:\"master_category_section_id\";i:467;s:18:\"master_category_id\";i:7;s:20:\"master_category_name\";s:7:\"FEEDING\";s:20:\"master_category_slug\";s:7:\"feeding\";s:15:\"section_type_id\";i:35;s:17:\"section_type_name\";s:14:\"SIPPERS & CUPS\";s:17:\"section_type_slug\";s:12:\"sippers-cups\";s:11:\"category_id\";i:333;s:13:\"category_name\";s:4:\"Mugs\";s:13:\"category_slug\";s:4:\"mugs\";}i:467;a:10:{s:26:\"master_category_section_id\";i:468;s:18:\"master_category_id\";i:7;s:20:\"master_category_name\";s:7:\"FEEDING\";s:20:\"master_category_slug\";s:7:\"feeding\";s:15:\"section_type_id\";i:35;s:17:\"section_type_name\";s:14:\"SIPPERS & CUPS\";s:17:\"section_type_slug\";s:12:\"sippers-cups\";s:11:\"category_id\";i:334;s:13:\"category_name\";s:8:\"Tumblers\";s:13:\"category_slug\";s:8:\"tumblers\";}i:468;a:10:{s:26:\"master_category_section_id\";i:469;s:18:\"master_category_id\";i:7;s:20:\"master_category_name\";s:7:\"FEEDING\";s:20:\"master_category_slug\";s:7:\"feeding\";s:15:\"section_type_id\";i:36;s:17:\"section_type_name\";s:12:\"BIBS & HANKY\";s:17:\"section_type_slug\";s:10:\"bibs-hanky\";s:11:\"category_id\";i:335;s:13:\"category_name\";s:4:\"Bibs\";s:13:\"category_slug\";s:4:\"bibs\";}i:469;a:10:{s:26:\"master_category_section_id\";i:470;s:18:\"master_category_id\";i:7;s:20:\"master_category_name\";s:7:\"FEEDING\";s:20:\"master_category_slug\";s:7:\"feeding\";s:15:\"section_type_id\";i:36;s:17:\"section_type_name\";s:12:\"BIBS & HANKY\";s:17:\"section_type_slug\";s:10:\"bibs-hanky\";s:11:\"category_id\";i:336;s:13:\"category_name\";s:17:\"Burp/Wash Clothes\";s:13:\"category_slug\";s:16:\"burpwash-clothes\";}i:470;a:10:{s:26:\"master_category_section_id\";i:471;s:18:\"master_category_id\";i:7;s:20:\"master_category_name\";s:7:\"FEEDING\";s:20:\"master_category_slug\";s:7:\"feeding\";s:15:\"section_type_id\";i:36;s:17:\"section_type_name\";s:12:\"BIBS & HANKY\";s:17:\"section_type_slug\";s:10:\"bibs-hanky\";s:11:\"category_id\";i:337;s:13:\"category_name\";s:15:\"Hanky / Napkins\";s:13:\"category_slug\";s:13:\"hanky-napkins\";}i:471;a:10:{s:26:\"master_category_section_id\";i:472;s:18:\"master_category_id\";i:7;s:20:\"master_category_name\";s:7:\"FEEDING\";s:20:\"master_category_slug\";s:7:\"feeding\";s:15:\"section_type_id\";i:36;s:17:\"section_type_name\";s:12:\"BIBS & HANKY\";s:17:\"section_type_slug\";s:10:\"bibs-hanky\";s:11:\"category_id\";i:338;s:13:\"category_name\";s:6:\"Aprons\";s:13:\"category_slug\";s:6:\"aprons\";}i:472;a:10:{s:26:\"master_category_section_id\";i:473;s:18:\"master_category_id\";i:7;s:20:\"master_category_name\";s:7:\"FEEDING\";s:20:\"master_category_slug\";s:7:\"feeding\";s:15:\"section_type_id\";i:37;s:17:\"section_type_name\";s:17:\"DISHES & UTENSILS\";s:17:\"section_type_slug\";s:15:\"dishes-utensils\";s:11:\"category_id\";i:339;s:13:\"category_name\";s:30:\"Bowls, Containers & Dispensers\";s:13:\"category_slug\";s:27:\"bowls-containers-dispensers\";}i:473;a:10:{s:26:\"master_category_section_id\";i:474;s:18:\"master_category_id\";i:7;s:20:\"master_category_name\";s:7:\"FEEDING\";s:20:\"master_category_slug\";s:7:\"feeding\";s:15:\"section_type_id\";i:37;s:17:\"section_type_name\";s:17:\"DISHES & UTENSILS\";s:17:\"section_type_slug\";s:15:\"dishes-utensils\";s:11:\"category_id\";i:340;s:13:\"category_name\";s:7:\"Cutlery\";s:13:\"category_slug\";s:7:\"cutlery\";}i:474;a:10:{s:26:\"master_category_section_id\";i:475;s:18:\"master_category_id\";i:7;s:20:\"master_category_name\";s:7:\"FEEDING\";s:20:\"master_category_slug\";s:7:\"feeding\";s:15:\"section_type_id\";i:37;s:17:\"section_type_name\";s:17:\"DISHES & UTENSILS\";s:17:\"section_type_slug\";s:15:\"dishes-utensils\";s:11:\"category_id\";i:341;s:13:\"category_name\";s:22:\"Milk Powder Containers\";s:13:\"category_slug\";s:22:\"milk-powder-containers\";}i:475;a:10:{s:26:\"master_category_section_id\";i:476;s:18:\"master_category_id\";i:7;s:20:\"master_category_name\";s:7:\"FEEDING\";s:20:\"master_category_slug\";s:7:\"feeding\";s:15:\"section_type_id\";i:37;s:17:\"section_type_name\";s:17:\"DISHES & UTENSILS\";s:17:\"section_type_slug\";s:15:\"dishes-utensils\";s:11:\"category_id\";i:342;s:13:\"category_name\";s:6:\"Dishes\";s:13:\"category_slug\";s:6:\"dishes\";}i:476;a:10:{s:26:\"master_category_section_id\";i:477;s:18:\"master_category_id\";i:7;s:20:\"master_category_name\";s:7:\"FEEDING\";s:20:\"master_category_slug\";s:7:\"feeding\";s:15:\"section_type_id\";i:37;s:17:\"section_type_name\";s:17:\"DISHES & UTENSILS\";s:17:\"section_type_slug\";s:15:\"dishes-utensils\";s:11:\"category_id\";i:343;s:13:\"category_name\";s:12:\"Feeding Sets\";s:13:\"category_slug\";s:12:\"feeding-sets\";}i:477;a:10:{s:26:\"master_category_section_id\";i:478;s:18:\"master_category_id\";i:7;s:20:\"master_category_name\";s:7:\"FEEDING\";s:20:\"master_category_slug\";s:7:\"feeding\";s:15:\"section_type_id\";i:37;s:17:\"section_type_name\";s:17:\"DISHES & UTENSILS\";s:17:\"section_type_slug\";s:15:\"dishes-utensils\";s:11:\"category_id\";i:344;s:13:\"category_name\";s:9:\"Tableware\";s:13:\"category_slug\";s:9:\"tableware\";}i:478;a:10:{s:26:\"master_category_section_id\";i:479;s:18:\"master_category_id\";i:7;s:20:\"master_category_name\";s:7:\"FEEDING\";s:20:\"master_category_slug\";s:7:\"feeding\";s:15:\"section_type_id\";i:37;s:17:\"section_type_name\";s:17:\"DISHES & UTENSILS\";s:17:\"section_type_slug\";s:15:\"dishes-utensils\";s:11:\"category_id\";i:345;s:13:\"category_name\";s:9:\"Drinkware\";s:13:\"category_slug\";s:9:\"drinkware\";}i:479;a:10:{s:26:\"master_category_section_id\";i:480;s:18:\"master_category_id\";i:7;s:20:\"master_category_name\";s:7:\"FEEDING\";s:20:\"master_category_slug\";s:7:\"feeding\";s:15:\"section_type_id\";i:38;s:17:\"section_type_name\";s:24:\"KIDS FOODS & SUPPLEMENTS\";s:17:\"section_type_slug\";s:22:\"kids-foods-supplements\";s:11:\"category_id\";i:346;s:13:\"category_name\";s:23:\"Health Drinks & Powders\";s:13:\"category_slug\";s:21:\"health-drinks-powders\";}i:480;a:10:{s:26:\"master_category_section_id\";i:481;s:18:\"master_category_id\";i:7;s:20:\"master_category_name\";s:7:\"FEEDING\";s:20:\"master_category_slug\";s:7:\"feeding\";s:15:\"section_type_id\";i:38;s:17:\"section_type_name\";s:24:\"KIDS FOODS & SUPPLEMENTS\";s:17:\"section_type_slug\";s:22:\"kids-foods-supplements\";s:11:\"category_id\";i:347;s:13:\"category_name\";s:19:\"Breakfast & Cereals\";s:13:\"category_slug\";s:17:\"breakfast-cereals\";}i:481;a:10:{s:26:\"master_category_section_id\";i:482;s:18:\"master_category_id\";i:7;s:20:\"master_category_name\";s:7:\"FEEDING\";s:20:\"master_category_slug\";s:7:\"feeding\";s:15:\"section_type_id\";i:38;s:17:\"section_type_name\";s:24:\"KIDS FOODS & SUPPLEMENTS\";s:17:\"section_type_slug\";s:22:\"kids-foods-supplements\";s:11:\"category_id\";i:348;s:13:\"category_name\";s:13:\"Ready to Cook\";s:13:\"category_slug\";s:13:\"ready-to-cook\";}i:482;a:10:{s:26:\"master_category_section_id\";i:483;s:18:\"master_category_id\";i:7;s:20:\"master_category_name\";s:7:\"FEEDING\";s:20:\"master_category_slug\";s:7:\"feeding\";s:15:\"section_type_id\";i:38;s:17:\"section_type_name\";s:24:\"KIDS FOODS & SUPPLEMENTS\";s:17:\"section_type_slug\";s:22:\"kids-foods-supplements\";s:11:\"category_id\";i:349;s:13:\"category_name\";s:24:\"Dry Fruits, Nuts & Seeds\";s:13:\"category_slug\";s:21:\"dry-fruits-nuts-seeds\";}i:483;a:10:{s:26:\"master_category_section_id\";i:484;s:18:\"master_category_id\";i:7;s:20:\"master_category_name\";s:7:\"FEEDING\";s:20:\"master_category_slug\";s:7:\"feeding\";s:15:\"section_type_id\";i:38;s:17:\"section_type_name\";s:24:\"KIDS FOODS & SUPPLEMENTS\";s:17:\"section_type_slug\";s:22:\"kids-foods-supplements\";s:11:\"category_id\";i:350;s:13:\"category_name\";s:20:\"Snacks & Finger Food\";s:13:\"category_slug\";s:18:\"snacks-finger-food\";}i:484;a:10:{s:26:\"master_category_section_id\";i:485;s:18:\"master_category_id\";i:7;s:20:\"master_category_name\";s:7:\"FEEDING\";s:20:\"master_category_slug\";s:7:\"feeding\";s:15:\"section_type_id\";i:38;s:17:\"section_type_name\";s:24:\"KIDS FOODS & SUPPLEMENTS\";s:17:\"section_type_slug\";s:22:\"kids-foods-supplements\";s:11:\"category_id\";i:351;s:13:\"category_name\";s:18:\"Biscuits & Cookies\";s:13:\"category_slug\";s:16:\"biscuits-cookies\";}i:485;a:10:{s:26:\"master_category_section_id\";i:486;s:18:\"master_category_id\";i:7;s:20:\"master_category_name\";s:7:\"FEEDING\";s:20:\"master_category_slug\";s:7:\"feeding\";s:15:\"section_type_id\";i:38;s:17:\"section_type_name\";s:24:\"KIDS FOODS & SUPPLEMENTS\";s:17:\"section_type_slug\";s:22:\"kids-foods-supplements\";s:11:\"category_id\";i:352;s:13:\"category_name\";s:28:\"Chocolates, Candies & Sweets\";s:13:\"category_slug\";s:25:\"chocolates-candies-sweets\";}i:486;a:10:{s:26:\"master_category_section_id\";i:487;s:18:\"master_category_id\";i:7;s:20:\"master_category_name\";s:7:\"FEEDING\";s:20:\"master_category_slug\";s:7:\"feeding\";s:15:\"section_type_id\";i:38;s:17:\"section_type_name\";s:24:\"KIDS FOODS & SUPPLEMENTS\";s:17:\"section_type_slug\";s:22:\"kids-foods-supplements\";s:11:\"category_id\";i:353;s:13:\"category_name\";s:15:\"Vitamin Gummies\";s:13:\"category_slug\";s:15:\"vitamin-gummies\";}i:487;a:10:{s:26:\"master_category_section_id\";i:488;s:18:\"master_category_id\";i:7;s:20:\"master_category_name\";s:7:\"FEEDING\";s:20:\"master_category_slug\";s:7:\"feeding\";s:15:\"section_type_id\";i:38;s:17:\"section_type_name\";s:24:\"KIDS FOODS & SUPPLEMENTS\";s:17:\"section_type_slug\";s:22:\"kids-foods-supplements\";s:11:\"category_id\";i:354;s:13:\"category_name\";s:23:\"Spreads, Jams & Ketchup\";s:13:\"category_slug\";s:20:\"spreads-jams-ketchup\";}i:488;a:10:{s:26:\"master_category_section_id\";i:489;s:18:\"master_category_id\";i:7;s:20:\"master_category_name\";s:7:\"FEEDING\";s:20:\"master_category_slug\";s:7:\"feeding\";s:15:\"section_type_id\";i:38;s:17:\"section_type_name\";s:24:\"KIDS FOODS & SUPPLEMENTS\";s:17:\"section_type_slug\";s:22:\"kids-foods-supplements\";s:11:\"category_id\";i:355;s:13:\"category_name\";s:19:\"Ghee & Cooking Oils\";s:13:\"category_slug\";s:17:\"ghee-cooking-oils\";}i:489;a:10:{s:26:\"master_category_section_id\";i:490;s:18:\"master_category_id\";i:7;s:20:\"master_category_name\";s:7:\"FEEDING\";s:20:\"master_category_slug\";s:7:\"feeding\";s:15:\"section_type_id\";i:14;s:17:\"section_type_name\";s:10:\"TOP BRANDS\";s:17:\"section_type_slug\";s:10:\"top-brands\";s:11:\"category_id\";i:71;s:13:\"category_name\";s:7:\"Babyhug\";s:13:\"category_slug\";s:7:\"babyhug\";}i:490;a:10:{s:26:\"master_category_section_id\";i:491;s:18:\"master_category_id\";i:7;s:20:\"master_category_name\";s:7:\"FEEDING\";s:20:\"master_category_slug\";s:7:\"feeding\";s:15:\"section_type_id\";i:14;s:17:\"section_type_name\";s:10:\"TOP BRANDS\";s:17:\"section_type_slug\";s:10:\"top-brands\";s:11:\"category_id\";i:356;s:13:\"category_name\";s:6:\"Nestle\";s:13:\"category_slug\";s:6:\"nestle\";}i:491;a:10:{s:26:\"master_category_section_id\";i:492;s:18:\"master_category_id\";i:7;s:20:\"master_category_name\";s:7:\"FEEDING\";s:20:\"master_category_slug\";s:7:\"feeding\";s:15:\"section_type_id\";i:14;s:17:\"section_type_name\";s:10:\"TOP BRANDS\";s:17:\"section_type_slug\";s:10:\"top-brands\";s:11:\"category_id\";i:357;s:13:\"category_name\";s:6:\"Medela\";s:13:\"category_slug\";s:6:\"medela\";}i:492;a:10:{s:26:\"master_category_section_id\";i:493;s:18:\"master_category_id\";i:7;s:20:\"master_category_name\";s:7:\"FEEDING\";s:20:\"master_category_slug\";s:7:\"feeding\";s:15:\"section_type_id\";i:14;s:17:\"section_type_name\";s:10:\"TOP BRANDS\";s:17:\"section_type_slug\";s:10:\"top-brands\";s:11:\"category_id\";i:358;s:13:\"category_name\";s:5:\"Avent\";s:13:\"category_slug\";s:5:\"avent\";}i:493;a:10:{s:26:\"master_category_section_id\";i:494;s:18:\"master_category_id\";i:7;s:20:\"master_category_name\";s:7:\"FEEDING\";s:20:\"master_category_slug\";s:7:\"feeding\";s:15:\"section_type_id\";i:14;s:17:\"section_type_name\";s:10:\"TOP BRANDS\";s:17:\"section_type_slug\";s:10:\"top-brands\";s:11:\"category_id\";i:359;s:13:\"category_name\";s:6:\"Chicco\";s:13:\"category_slug\";s:6:\"chicco\";}i:494;a:10:{s:26:\"master_category_section_id\";i:495;s:18:\"master_category_id\";i:7;s:20:\"master_category_name\";s:7:\"FEEDING\";s:20:\"master_category_slug\";s:7:\"feeding\";s:15:\"section_type_id\";i:14;s:17:\"section_type_name\";s:10:\"TOP BRANDS\";s:17:\"section_type_slug\";s:10:\"top-brands\";s:11:\"category_id\";i:360;s:13:\"category_name\";s:6:\"Pigeon\";s:13:\"category_slug\";s:6:\"pigeon\";}i:495;a:10:{s:26:\"master_category_section_id\";i:496;s:18:\"master_category_id\";i:7;s:20:\"master_category_name\";s:7:\"FEEDING\";s:20:\"master_category_slug\";s:7:\"feeding\";s:15:\"section_type_id\";i:14;s:17:\"section_type_name\";s:10:\"TOP BRANDS\";s:17:\"section_type_slug\";s:10:\"top-brands\";s:11:\"category_id\";i:361;s:13:\"category_name\";s:7:\"Aptamil\";s:13:\"category_slug\";s:7:\"aptamil\";}i:496;a:10:{s:26:\"master_category_section_id\";i:497;s:18:\"master_category_id\";i:7;s:20:\"master_category_name\";s:7:\"FEEDING\";s:20:\"master_category_slug\";s:7:\"feeding\";s:15:\"section_type_id\";i:14;s:17:\"section_type_name\";s:10:\"TOP BRANDS\";s:17:\"section_type_slug\";s:10:\"top-brands\";s:11:\"category_id\";i:362;s:13:\"category_name\";s:9:\"PediaSure\";s:13:\"category_slug\";s:9:\"pediasure\";}i:497;a:10:{s:26:\"master_category_section_id\";i:498;s:18:\"master_category_id\";i:7;s:20:\"master_category_name\";s:7:\"FEEDING\";s:20:\"master_category_slug\";s:7:\"feeding\";s:15:\"section_type_id\";i:14;s:17:\"section_type_name\";s:10:\"TOP BRANDS\";s:17:\"section_type_slug\";s:10:\"top-brands\";s:11:\"category_id\";i:363;s:13:\"category_name\";s:7:\"Similac\";s:13:\"category_slug\";s:7:\"similac\";}i:498;a:10:{s:26:\"master_category_section_id\";i:499;s:18:\"master_category_id\";i:7;s:20:\"master_category_name\";s:7:\"FEEDING\";s:20:\"master_category_slug\";s:7:\"feeding\";s:15:\"section_type_id\";i:14;s:17:\"section_type_name\";s:10:\"TOP BRANDS\";s:17:\"section_type_slug\";s:10:\"top-brands\";s:11:\"category_id\";i:214;s:13:\"category_name\";s:7:\"Mee Mee\";s:13:\"category_slug\";s:7:\"mee-mee\";}i:499;a:10:{s:26:\"master_category_section_id\";i:500;s:18:\"master_category_id\";i:7;s:20:\"master_category_name\";s:7:\"FEEDING\";s:20:\"master_category_slug\";s:7:\"feeding\";s:15:\"section_type_id\";i:14;s:17:\"section_type_name\";s:10:\"TOP BRANDS\";s:17:\"section_type_slug\";s:10:\"top-brands\";s:11:\"category_id\";i:279;s:13:\"category_name\";s:7:\"Luv Lap\";s:13:\"category_slug\";s:7:\"luv-lap\";}i:500;a:10:{s:26:\"master_category_section_id\";i:501;s:18:\"master_category_id\";i:7;s:20:\"master_category_name\";s:7:\"FEEDING\";s:20:\"master_category_slug\";s:7:\"feeding\";s:15:\"section_type_id\";i:14;s:17:\"section_type_name\";s:10:\"TOP BRANDS\";s:17:\"section_type_slug\";s:10:\"top-brands\";s:11:\"category_id\";i:364;s:13:\"category_name\";s:11:\"Early Foods\";s:13:\"category_slug\";s:11:\"early-foods\";}i:501;a:10:{s:26:\"master_category_section_id\";i:502;s:18:\"master_category_id\";i:7;s:20:\"master_category_name\";s:7:\"FEEDING\";s:20:\"master_category_slug\";s:7:\"feeding\";s:15:\"section_type_id\";i:14;s:17:\"section_type_name\";s:10:\"TOP BRANDS\";s:17:\"section_type_slug\";s:10:\"top-brands\";s:11:\"category_id\";i:365;s:13:\"category_name\";s:6:\"timios\";s:13:\"category_slug\";s:6:\"timios\";}i:502;a:10:{s:26:\"master_category_section_id\";i:503;s:18:\"master_category_id\";i:8;s:20:\"master_category_name\";s:4:\"BATH\";s:20:\"master_category_slug\";s:4:\"bath\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:366;s:13:\"category_name\";s:23:\"Lotions, Oils & Powders\";s:13:\"category_slug\";s:20:\"lotions-oils-powders\";}i:503;a:10:{s:26:\"master_category_section_id\";i:504;s:18:\"master_category_id\";i:8;s:20:\"master_category_name\";s:4:\"BATH\";s:20:\"master_category_slug\";s:4:\"bath\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:367;s:13:\"category_name\";s:17:\"Soaps & Body Wash\";s:13:\"category_slug\";s:15:\"soaps-body-wash\";}i:504;a:10:{s:26:\"master_category_section_id\";i:505;s:18:\"master_category_id\";i:8;s:20:\"master_category_name\";s:4:\"BATH\";s:20:\"master_category_slug\";s:4:\"bath\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:368;s:13:\"category_name\";s:23:\"Shampoos & Conditioners\";s:13:\"category_slug\";s:21:\"shampoos-conditioners\";}i:505;a:10:{s:26:\"master_category_section_id\";i:506;s:18:\"master_category_id\";i:8;s:20:\"master_category_name\";s:4:\"BATH\";s:20:\"master_category_slug\";s:4:\"bath\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:369;s:13:\"category_name\";s:23:\"Baby Creams & Ointments\";s:13:\"category_slug\";s:21:\"baby-creams-ointments\";}i:506;a:10:{s:26:\"master_category_section_id\";i:507;s:18:\"master_category_id\";i:8;s:20:\"master_category_name\";s:4:\"BATH\";s:20:\"master_category_slug\";s:4:\"bath\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:370;s:13:\"category_name\";s:19:\"Bath Tubs & Bathers\";s:13:\"category_slug\";s:17:\"bath-tubs-bathers\";}i:507;a:10:{s:26:\"master_category_section_id\";i:508;s:18:\"master_category_id\";i:8;s:20:\"master_category_name\";s:4:\"BATH\";s:20:\"master_category_slug\";s:4:\"bath\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:371;s:13:\"category_name\";s:19:\"Bathing Accessories\";s:13:\"category_slug\";s:19:\"bathing-accessories\";}i:508;a:10:{s:26:\"master_category_section_id\";i:509;s:18:\"master_category_id\";i:8;s:20:\"master_category_name\";s:4:\"BATH\";s:20:\"master_category_slug\";s:4:\"bath\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:372;s:13:\"category_name\";s:19:\"Grooming Essentials\";s:13:\"category_slug\";s:19:\"grooming-essentials\";}i:509;a:10:{s:26:\"master_category_section_id\";i:510;s:18:\"master_category_id\";i:8;s:20:\"master_category_name\";s:4:\"BATH\";s:20:\"master_category_slug\";s:4:\"bath\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:147;s:13:\"category_name\";s:9:\"Bath Toys\";s:13:\"category_slug\";s:9:\"bath-toys\";}i:510;a:10:{s:26:\"master_category_section_id\";i:511;s:18:\"master_category_id\";i:8;s:20:\"master_category_name\";s:4:\"BATH\";s:20:\"master_category_slug\";s:4:\"bath\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:373;s:13:\"category_name\";s:19:\"Bath Towels & Robes\";s:13:\"category_slug\";s:17:\"bath-towels-robes\";}i:511;a:10:{s:26:\"master_category_section_id\";i:512;s:18:\"master_category_id\";i:8;s:20:\"master_category_name\";s:4:\"BATH\";s:20:\"master_category_slug\";s:4:\"bath\";s:15:\"section_type_id\";i:39;s:17:\"section_type_name\";s:19:\"BATHING ACCESSORIES\";s:17:\"section_type_slug\";s:19:\"bathing-accessories\";s:11:\"category_id\";i:374;s:13:\"category_name\";s:20:\"Bath Sponge & Loofah\";s:13:\"category_slug\";s:18:\"bath-sponge-loofah\";}i:512;a:10:{s:26:\"master_category_section_id\";i:513;s:18:\"master_category_id\";i:8;s:20:\"master_category_name\";s:4:\"BATH\";s:20:\"master_category_slug\";s:4:\"bath\";s:15:\"section_type_id\";i:39;s:17:\"section_type_name\";s:19:\"BATHING ACCESSORIES\";s:17:\"section_type_slug\";s:19:\"bathing-accessories\";s:11:\"category_id\";i:375;s:13:\"category_name\";s:11:\"Shower Caps\";s:13:\"category_slug\";s:11:\"shower-caps\";}i:513;a:10:{s:26:\"master_category_section_id\";i:514;s:18:\"master_category_id\";i:8;s:20:\"master_category_name\";s:4:\"BATH\";s:20:\"master_category_slug\";s:4:\"bath\";s:15:\"section_type_id\";i:39;s:17:\"section_type_name\";s:19:\"BATHING ACCESSORIES\";s:17:\"section_type_slug\";s:19:\"bathing-accessories\";s:11:\"category_id\";i:376;s:13:\"category_name\";s:10:\"Soap Cases\";s:13:\"category_slug\";s:10:\"soap-cases\";}i:514;a:10:{s:26:\"master_category_section_id\";i:515;s:18:\"master_category_id\";i:8;s:20:\"master_category_name\";s:4:\"BATH\";s:20:\"master_category_slug\";s:4:\"bath\";s:15:\"section_type_id\";i:39;s:17:\"section_type_name\";s:19:\"BATHING ACCESSORIES\";s:17:\"section_type_slug\";s:19:\"bathing-accessories\";s:11:\"category_id\";i:377;s:13:\"category_name\";s:11:\"Bath Gloves\";s:13:\"category_slug\";s:11:\"bath-gloves\";}i:515;a:10:{s:26:\"master_category_section_id\";i:516;s:18:\"master_category_id\";i:8;s:20:\"master_category_name\";s:4:\"BATH\";s:20:\"master_category_slug\";s:4:\"bath\";s:15:\"section_type_id\";i:39;s:17:\"section_type_name\";s:19:\"BATHING ACCESSORIES\";s:17:\"section_type_slug\";s:19:\"bathing-accessories\";s:11:\"category_id\";i:378;s:13:\"category_name\";s:14:\"Baby Bath Nets\";s:13:\"category_slug\";s:14:\"baby-bath-nets\";}i:516;a:10:{s:26:\"master_category_section_id\";i:517;s:18:\"master_category_id\";i:8;s:20:\"master_category_name\";s:4:\"BATH\";s:20:\"master_category_slug\";s:4:\"bath\";s:15:\"section_type_id\";i:39;s:17:\"section_type_name\";s:19:\"BATHING ACCESSORIES\";s:17:\"section_type_slug\";s:19:\"bathing-accessories\";s:11:\"category_id\";i:379;s:13:\"category_name\";s:31:\"Bathroom Stools & Towel Holders\";s:13:\"category_slug\";s:29:\"bathroom-stools-towel-holders\";}i:517;a:10:{s:26:\"master_category_section_id\";i:518;s:18:\"master_category_id\";i:8;s:20:\"master_category_name\";s:4:\"BATH\";s:20:\"master_category_slug\";s:4:\"bath\";s:15:\"section_type_id\";i:39;s:17:\"section_type_name\";s:19:\"BATHING ACCESSORIES\";s:17:\"section_type_slug\";s:19:\"bathing-accessories\";s:11:\"category_id\";i:380;s:13:\"category_name\";s:29:\"Rinse Cups & Faucet Extenders\";s:13:\"category_slug\";s:27:\"rinse-cups-faucet-extenders\";}i:518;a:10:{s:26:\"master_category_section_id\";i:519;s:18:\"master_category_id\";i:8;s:20:\"master_category_name\";s:4:\"BATH\";s:20:\"master_category_slug\";s:4:\"bath\";s:15:\"section_type_id\";i:40;s:17:\"section_type_name\";s:9:\"BATH TOYS\";s:17:\"section_type_slug\";s:9:\"bath-toys\";s:11:\"category_id\";i:381;s:13:\"category_name\";s:12:\"Squeeze Toys\";s:13:\"category_slug\";s:12:\"squeeze-toys\";}i:519;a:10:{s:26:\"master_category_section_id\";i:520;s:18:\"master_category_id\";i:8;s:20:\"master_category_name\";s:4:\"BATH\";s:20:\"master_category_slug\";s:4:\"bath\";s:15:\"section_type_id\";i:40;s:17:\"section_type_name\";s:9:\"BATH TOYS\";s:17:\"section_type_slug\";s:9:\"bath-toys\";s:11:\"category_id\";i:382;s:13:\"category_name\";s:10:\"Bath Books\";s:13:\"category_slug\";s:10:\"bath-books\";}i:520;a:10:{s:26:\"master_category_section_id\";i:521;s:18:\"master_category_id\";i:8;s:20:\"master_category_name\";s:4:\"BATH\";s:20:\"master_category_slug\";s:4:\"bath\";s:15:\"section_type_id\";i:40;s:17:\"section_type_name\";s:9:\"BATH TOYS\";s:17:\"section_type_slug\";s:9:\"bath-toys\";s:11:\"category_id\";i:383;s:13:\"category_name\";s:29:\"Learning & Activity Bath Toys\";s:13:\"category_slug\";s:27:\"learning-activity-bath-toys\";}i:521;a:10:{s:26:\"master_category_section_id\";i:522;s:18:\"master_category_id\";i:8;s:20:\"master_category_name\";s:4:\"BATH\";s:20:\"master_category_slug\";s:4:\"bath\";s:15:\"section_type_id\";i:41;s:17:\"section_type_name\";s:21:\"SOAP BARS & BODY WASH\";s:17:\"section_type_slug\";s:19:\"soap-bars-body-wash\";s:11:\"category_id\";i:384;s:13:\"category_name\";s:9:\"Body Wash\";s:13:\"category_slug\";s:9:\"body-wash\";}i:522;a:10:{s:26:\"master_category_section_id\";i:523;s:18:\"master_category_id\";i:8;s:20:\"master_category_name\";s:4:\"BATH\";s:20:\"master_category_slug\";s:4:\"bath\";s:15:\"section_type_id\";i:41;s:17:\"section_type_name\";s:21:\"SOAP BARS & BODY WASH\";s:17:\"section_type_slug\";s:19:\"soap-bars-body-wash\";s:11:\"category_id\";i:385;s:13:\"category_name\";s:9:\"Soap Bars\";s:13:\"category_slug\";s:9:\"soap-bars\";}i:523;a:10:{s:26:\"master_category_section_id\";i:524;s:18:\"master_category_id\";i:8;s:20:\"master_category_name\";s:4:\"BATH\";s:20:\"master_category_slug\";s:4:\"bath\";s:15:\"section_type_id\";i:41;s:17:\"section_type_name\";s:21:\"SOAP BARS & BODY WASH\";s:17:\"section_type_slug\";s:19:\"soap-bars-body-wash\";s:11:\"category_id\";i:386;s:13:\"category_name\";s:15:\"Top to Toe Wash\";s:13:\"category_slug\";s:15:\"top-to-toe-wash\";}i:524;a:10:{s:26:\"master_category_section_id\";i:525;s:18:\"master_category_id\";i:8;s:20:\"master_category_name\";s:4:\"BATH\";s:20:\"master_category_slug\";s:4:\"bath\";s:15:\"section_type_id\";i:41;s:17:\"section_type_name\";s:21:\"SOAP BARS & BODY WASH\";s:17:\"section_type_slug\";s:19:\"soap-bars-body-wash\";s:11:\"category_id\";i:387;s:13:\"category_name\";s:9:\"Face Wash\";s:13:\"category_slug\";s:9:\"face-wash\";}i:525;a:10:{s:26:\"master_category_section_id\";i:526;s:18:\"master_category_id\";i:8;s:20:\"master_category_name\";s:4:\"BATH\";s:20:\"master_category_slug\";s:4:\"bath\";s:15:\"section_type_id\";i:41;s:17:\"section_type_name\";s:21:\"SOAP BARS & BODY WASH\";s:17:\"section_type_slug\";s:19:\"soap-bars-body-wash\";s:11:\"category_id\";i:388;s:13:\"category_name\";s:16:\"Ubtan for Babies\";s:13:\"category_slug\";s:16:\"ubtan-for-babies\";}i:526;a:10:{s:26:\"master_category_section_id\";i:527;s:18:\"master_category_id\";i:8;s:20:\"master_category_name\";s:4:\"BATH\";s:20:\"master_category_slug\";s:4:\"bath\";s:15:\"section_type_id\";i:42;s:17:\"section_type_name\";s:8:\"GROOMING\";s:17:\"section_type_slug\";s:8:\"grooming\";s:11:\"category_id\";i:389;s:13:\"category_name\";s:12:\"Brush & Comb\";s:13:\"category_slug\";s:10:\"brush-comb\";}i:527;a:10:{s:26:\"master_category_section_id\";i:528;s:18:\"master_category_id\";i:8;s:20:\"master_category_name\";s:4:\"BATH\";s:20:\"master_category_slug\";s:4:\"bath\";s:15:\"section_type_id\";i:42;s:17:\"section_type_name\";s:8:\"GROOMING\";s:17:\"section_type_slug\";s:8:\"grooming\";s:11:\"category_id\";i:390;s:13:\"category_name\";s:13:\"Nail Clippers\";s:13:\"category_slug\";s:13:\"nail-clippers\";}i:528;a:10:{s:26:\"master_category_section_id\";i:529;s:18:\"master_category_id\";i:8;s:20:\"master_category_name\";s:4:\"BATH\";s:20:\"master_category_slug\";s:4:\"bath\";s:15:\"section_type_id\";i:42;s:17:\"section_type_name\";s:8:\"GROOMING\";s:17:\"section_type_slug\";s:8:\"grooming\";s:11:\"category_id\";i:391;s:13:\"category_name\";s:11:\"Powder Puff\";s:13:\"category_slug\";s:11:\"powder-puff\";}i:529;a:10:{s:26:\"master_category_section_id\";i:530;s:18:\"master_category_id\";i:8;s:20:\"master_category_name\";s:4:\"BATH\";s:20:\"master_category_slug\";s:4:\"bath\";s:15:\"section_type_id\";i:42;s:17:\"section_type_name\";s:8:\"GROOMING\";s:17:\"section_type_slug\";s:8:\"grooming\";s:11:\"category_id\";i:392;s:13:\"category_name\";s:13:\"Grooming Kits\";s:13:\"category_slug\";s:13:\"grooming-kits\";}i:530;a:10:{s:26:\"master_category_section_id\";i:531;s:18:\"master_category_id\";i:8;s:20:\"master_category_name\";s:4:\"BATH\";s:20:\"master_category_slug\";s:4:\"bath\";s:15:\"section_type_id\";i:42;s:17:\"section_type_name\";s:8:\"GROOMING\";s:17:\"section_type_slug\";s:8:\"grooming\";s:11:\"category_id\";i:393;s:13:\"category_name\";s:23:\"Baby Perfumes & Cologne\";s:13:\"category_slug\";s:21:\"baby-perfumes-cologne\";}i:531;a:10:{s:26:\"master_category_section_id\";i:532;s:18:\"master_category_id\";i:8;s:20:\"master_category_name\";s:4:\"BATH\";s:20:\"master_category_slug\";s:4:\"bath\";s:15:\"section_type_id\";i:42;s:17:\"section_type_name\";s:8:\"GROOMING\";s:17:\"section_type_slug\";s:8:\"grooming\";s:11:\"category_id\";i:394;s:13:\"category_name\";s:13:\"Baby Scissors\";s:13:\"category_slug\";s:13:\"baby-scissors\";}i:532;a:10:{s:26:\"master_category_section_id\";i:533;s:18:\"master_category_id\";i:8;s:20:\"master_category_name\";s:4:\"BATH\";s:20:\"master_category_slug\";s:4:\"bath\";s:15:\"section_type_id\";i:14;s:17:\"section_type_name\";s:10:\"TOP BRANDS\";s:17:\"section_type_slug\";s:10:\"top-brands\";s:11:\"category_id\";i:71;s:13:\"category_name\";s:7:\"Babyhug\";s:13:\"category_slug\";s:7:\"babyhug\";}i:533;a:10:{s:26:\"master_category_section_id\";i:534;s:18:\"master_category_id\";i:8;s:20:\"master_category_name\";s:4:\"BATH\";s:20:\"master_category_slug\";s:4:\"bath\";s:15:\"section_type_id\";i:14;s:17:\"section_type_name\";s:10:\"TOP BRANDS\";s:17:\"section_type_slug\";s:10:\"top-brands\";s:11:\"category_id\";i:212;s:13:\"category_name\";s:7:\"Sebamed\";s:13:\"category_slug\";s:7:\"sebamed\";}i:534;a:10:{s:26:\"master_category_section_id\";i:535;s:18:\"master_category_id\";i:8;s:20:\"master_category_name\";s:4:\"BATH\";s:20:\"master_category_slug\";s:4:\"bath\";s:15:\"section_type_id\";i:14;s:17:\"section_type_name\";s:10:\"TOP BRANDS\";s:17:\"section_type_slug\";s:10:\"top-brands\";s:11:\"category_id\";i:209;s:13:\"category_name\";s:17:\"Himalaya Babycare\";s:13:\"category_slug\";s:17:\"himalaya-babycare\";}i:535;a:10:{s:26:\"master_category_section_id\";i:536;s:18:\"master_category_id\";i:8;s:20:\"master_category_name\";s:4:\"BATH\";s:20:\"master_category_slug\";s:4:\"bath\";s:15:\"section_type_id\";i:14;s:17:\"section_type_name\";s:10:\"TOP BRANDS\";s:17:\"section_type_slug\";s:10:\"top-brands\";s:11:\"category_id\";i:395;s:13:\"category_name\";s:10:\"Mama Earth\";s:13:\"category_slug\";s:10:\"mama-earth\";}i:536;a:10:{s:26:\"master_category_section_id\";i:537;s:18:\"master_category_id\";i:8;s:20:\"master_category_name\";s:4:\"BATH\";s:20:\"master_category_slug\";s:4:\"bath\";s:15:\"section_type_id\";i:14;s:17:\"section_type_name\";s:10:\"TOP BRANDS\";s:17:\"section_type_slug\";s:10:\"top-brands\";s:11:\"category_id\";i:396;s:13:\"category_name\";s:13:\"Cetaphil Baby\";s:13:\"category_slug\";s:13:\"cetaphil-baby\";}i:537;a:10:{s:26:\"master_category_section_id\";i:538;s:18:\"master_category_id\";i:8;s:20:\"master_category_name\";s:4:\"BATH\";s:20:\"master_category_slug\";s:4:\"bath\";s:15:\"section_type_id\";i:14;s:17:\"section_type_name\";s:10:\"TOP BRANDS\";s:17:\"section_type_slug\";s:10:\"top-brands\";s:11:\"category_id\";i:359;s:13:\"category_name\";s:6:\"Chicco\";s:13:\"category_slug\";s:6:\"chicco\";}i:538;a:10:{s:26:\"master_category_section_id\";i:539;s:18:\"master_category_id\";i:8;s:20:\"master_category_name\";s:4:\"BATH\";s:20:\"master_category_slug\";s:4:\"bath\";s:15:\"section_type_id\";i:14;s:17:\"section_type_name\";s:10:\"TOP BRANDS\";s:17:\"section_type_slug\";s:10:\"top-brands\";s:11:\"category_id\";i:397;s:13:\"category_name\";s:7:\"CURATIO\";s:13:\"category_slug\";s:7:\"curatio\";}i:539;a:10:{s:26:\"master_category_section_id\";i:540;s:18:\"master_category_id\";i:8;s:20:\"master_category_name\";s:4:\"BATH\";s:20:\"master_category_slug\";s:4:\"bath\";s:15:\"section_type_id\";i:14;s:17:\"section_type_name\";s:10:\"TOP BRANDS\";s:17:\"section_type_slug\";s:10:\"top-brands\";s:11:\"category_id\";i:398;s:13:\"category_name\";s:11:\"Aveeno Baby\";s:13:\"category_slug\";s:11:\"aveeno-baby\";}i:540;a:10:{s:26:\"master_category_section_id\";i:541;s:18:\"master_category_id\";i:8;s:20:\"master_category_name\";s:4:\"BATH\";s:20:\"master_category_slug\";s:4:\"bath\";s:15:\"section_type_id\";i:14;s:17:\"section_type_name\";s:10:\"TOP BRANDS\";s:17:\"section_type_slug\";s:10:\"top-brands\";s:11:\"category_id\";i:399;s:13:\"category_name\";s:12:\"the moms co.\";s:13:\"category_slug\";s:11:\"the-moms-co\";}i:541;a:10:{s:26:\"master_category_section_id\";i:542;s:18:\"master_category_id\";i:8;s:20:\"master_category_name\";s:4:\"BATH\";s:20:\"master_category_slug\";s:4:\"bath\";s:15:\"section_type_id\";i:14;s:17:\"section_type_name\";s:10:\"TOP BRANDS\";s:17:\"section_type_slug\";s:10:\"top-brands\";s:11:\"category_id\";i:214;s:13:\"category_name\";s:7:\"Mee Mee\";s:13:\"category_slug\";s:7:\"mee-mee\";}i:542;a:10:{s:26:\"master_category_section_id\";i:543;s:18:\"master_category_id\";i:8;s:20:\"master_category_name\";s:4:\"BATH\";s:20:\"master_category_slug\";s:4:\"bath\";s:15:\"section_type_id\";i:43;s:17:\"section_type_name\";s:23:\"SHAMPOOS & CONDITIONERS\";s:17:\"section_type_slug\";s:21:\"shampoos-conditioners\";s:11:\"category_id\";i:400;s:13:\"category_name\";s:13:\"Baby Shampoos\";s:13:\"category_slug\";s:13:\"baby-shampoos\";}i:543;a:10:{s:26:\"master_category_section_id\";i:544;s:18:\"master_category_id\";i:8;s:20:\"master_category_name\";s:4:\"BATH\";s:20:\"master_category_slug\";s:4:\"bath\";s:15:\"section_type_id\";i:43;s:17:\"section_type_name\";s:23:\"SHAMPOOS & CONDITIONERS\";s:17:\"section_type_slug\";s:21:\"shampoos-conditioners\";s:11:\"category_id\";i:401;s:13:\"category_name\";s:12:\"Conditioners\";s:13:\"category_slug\";s:12:\"conditioners\";}i:544;a:10:{s:26:\"master_category_section_id\";i:545;s:18:\"master_category_id\";i:8;s:20:\"master_category_name\";s:4:\"BATH\";s:20:\"master_category_slug\";s:4:\"bath\";s:15:\"section_type_id\";i:43;s:17:\"section_type_name\";s:23:\"SHAMPOOS & CONDITIONERS\";s:17:\"section_type_slug\";s:21:\"shampoos-conditioners\";s:11:\"category_id\";i:386;s:13:\"category_name\";s:15:\"Top to Toe Wash\";s:13:\"category_slug\";s:15:\"top-to-toe-wash\";}i:545;a:10:{s:26:\"master_category_section_id\";i:546;s:18:\"master_category_id\";i:8;s:20:\"master_category_name\";s:4:\"BATH\";s:20:\"master_category_slug\";s:4:\"bath\";s:15:\"section_type_id\";i:44;s:17:\"section_type_name\";s:19:\"BATH TOWELS & ROBES\";s:17:\"section_type_slug\";s:17:\"bath-towels-robes\";s:11:\"category_id\";i:402;s:13:\"category_name\";s:16:\"Towel & Wrappers\";s:13:\"category_slug\";s:14:\"towel-wrappers\";}i:546;a:10:{s:26:\"master_category_section_id\";i:547;s:18:\"master_category_id\";i:8;s:20:\"master_category_name\";s:4:\"BATH\";s:20:\"master_category_slug\";s:4:\"bath\";s:15:\"section_type_id\";i:44;s:17:\"section_type_name\";s:19:\"BATH TOWELS & ROBES\";s:17:\"section_type_slug\";s:17:\"bath-towels-robes\";s:11:\"category_id\";i:403;s:13:\"category_name\";s:10:\"Bath Robes\";s:13:\"category_slug\";s:10:\"bath-robes\";}i:547;a:10:{s:26:\"master_category_section_id\";i:548;s:18:\"master_category_id\";i:8;s:20:\"master_category_name\";s:4:\"BATH\";s:20:\"master_category_slug\";s:4:\"bath\";s:15:\"section_type_id\";i:44;s:17:\"section_type_name\";s:19:\"BATH TOWELS & ROBES\";s:17:\"section_type_slug\";s:17:\"bath-towels-robes\";s:11:\"category_id\";i:404;s:13:\"category_name\";s:18:\"Hand & Face Towels\";s:13:\"category_slug\";s:16:\"hand-face-towels\";}i:548;a:10:{s:26:\"master_category_section_id\";i:549;s:18:\"master_category_id\";i:8;s:20:\"master_category_name\";s:4:\"BATH\";s:20:\"master_category_slug\";s:4:\"bath\";s:15:\"section_type_id\";i:45;s:17:\"section_type_name\";s:23:\"LOTIONS, OILS & POWDERS\";s:17:\"section_type_slug\";s:20:\"lotions-oils-powders\";s:11:\"category_id\";i:405;s:13:\"category_name\";s:12:\"Baby Lotions\";s:13:\"category_slug\";s:12:\"baby-lotions\";}i:549;a:10:{s:26:\"master_category_section_id\";i:550;s:18:\"master_category_id\";i:8;s:20:\"master_category_name\";s:4:\"BATH\";s:20:\"master_category_slug\";s:4:\"bath\";s:15:\"section_type_id\";i:45;s:17:\"section_type_name\";s:23:\"LOTIONS, OILS & POWDERS\";s:17:\"section_type_slug\";s:20:\"lotions-oils-powders\";s:11:\"category_id\";i:406;s:13:\"category_name\";s:12:\"Massage Oils\";s:13:\"category_slug\";s:12:\"massage-oils\";}i:550;a:10:{s:26:\"master_category_section_id\";i:551;s:18:\"master_category_id\";i:8;s:20:\"master_category_name\";s:4:\"BATH\";s:20:\"master_category_slug\";s:4:\"bath\";s:15:\"section_type_id\";i:45;s:17:\"section_type_name\";s:23:\"LOTIONS, OILS & POWDERS\";s:17:\"section_type_slug\";s:20:\"lotions-oils-powders\";s:11:\"category_id\";i:407;s:13:\"category_name\";s:9:\"Hair Oils\";s:13:\"category_slug\";s:9:\"hair-oils\";}i:551;a:10:{s:26:\"master_category_section_id\";i:552;s:18:\"master_category_id\";i:8;s:20:\"master_category_name\";s:4:\"BATH\";s:20:\"master_category_slug\";s:4:\"bath\";s:15:\"section_type_id\";i:45;s:17:\"section_type_name\";s:23:\"LOTIONS, OILS & POWDERS\";s:17:\"section_type_slug\";s:20:\"lotions-oils-powders\";s:11:\"category_id\";i:408;s:13:\"category_name\";s:12:\"Baby Powders\";s:13:\"category_slug\";s:12:\"baby-powders\";}i:552;a:10:{s:26:\"master_category_section_id\";i:553;s:18:\"master_category_id\";i:8;s:20:\"master_category_name\";s:4:\"BATH\";s:20:\"master_category_slug\";s:4:\"bath\";s:15:\"section_type_id\";i:45;s:17:\"section_type_name\";s:23:\"LOTIONS, OILS & POWDERS\";s:17:\"section_type_slug\";s:20:\"lotions-oils-powders\";s:11:\"category_id\";i:409;s:13:\"category_name\";s:11:\"Sun Screens\";s:13:\"category_slug\";s:11:\"sun-screens\";}i:553;a:10:{s:26:\"master_category_section_id\";i:554;s:18:\"master_category_id\";i:8;s:20:\"master_category_name\";s:4:\"BATH\";s:20:\"master_category_slug\";s:4:\"bath\";s:15:\"section_type_id\";i:46;s:17:\"section_type_name\";s:23:\"BABY CREAMS & OINTMENTS\";s:17:\"section_type_slug\";s:21:\"baby-creams-ointments\";s:11:\"category_id\";i:410;s:13:\"category_name\";s:11:\"Baby Creams\";s:13:\"category_slug\";s:11:\"baby-creams\";}i:554;a:10:{s:26:\"master_category_section_id\";i:555;s:18:\"master_category_id\";i:8;s:20:\"master_category_name\";s:4:\"BATH\";s:20:\"master_category_slug\";s:4:\"bath\";s:15:\"section_type_id\";i:46;s:17:\"section_type_name\";s:23:\"BABY CREAMS & OINTMENTS\";s:17:\"section_type_slug\";s:21:\"baby-creams-ointments\";s:11:\"category_id\";i:411;s:13:\"category_name\";s:11:\"Face Creams\";s:13:\"category_slug\";s:11:\"face-creams\";}i:555;a:10:{s:26:\"master_category_section_id\";i:556;s:18:\"master_category_id\";i:8;s:20:\"master_category_name\";s:4:\"BATH\";s:20:\"master_category_slug\";s:4:\"bath\";s:15:\"section_type_id\";i:46;s:17:\"section_type_name\";s:23:\"BABY CREAMS & OINTMENTS\";s:17:\"section_type_slug\";s:21:\"baby-creams-ointments\";s:11:\"category_id\";i:412;s:13:\"category_name\";s:13:\"Baby Lip Gels\";s:13:\"category_slug\";s:13:\"baby-lip-gels\";}i:556;a:10:{s:26:\"master_category_section_id\";i:557;s:18:\"master_category_id\";i:8;s:20:\"master_category_name\";s:4:\"BATH\";s:20:\"master_category_slug\";s:4:\"bath\";s:15:\"section_type_id\";i:47;s:17:\"section_type_name\";s:18:\"BATHING ESSENTIALS\";s:17:\"section_type_slug\";s:18:\"bathing-essentials\";s:11:\"category_id\";i:413;s:13:\"category_name\";s:14:\"Baby Bath Tubs\";s:13:\"category_slug\";s:14:\"baby-bath-tubs\";}i:557;a:10:{s:26:\"master_category_section_id\";i:558;s:18:\"master_category_id\";i:8;s:20:\"master_category_name\";s:4:\"BATH\";s:20:\"master_category_slug\";s:4:\"bath\";s:15:\"section_type_id\";i:47;s:17:\"section_type_name\";s:18:\"BATHING ESSENTIALS\";s:17:\"section_type_slug\";s:18:\"bathing-essentials\";s:11:\"category_id\";i:414;s:13:\"category_name\";s:12:\"Baby Bathers\";s:13:\"category_slug\";s:12:\"baby-bathers\";}i:558;a:10:{s:26:\"master_category_section_id\";i:559;s:18:\"master_category_id\";i:8;s:20:\"master_category_name\";s:4:\"BATH\";s:20:\"master_category_slug\";s:4:\"bath\";s:15:\"section_type_id\";i:47;s:17:\"section_type_name\";s:18:\"BATHING ESSENTIALS\";s:17:\"section_type_slug\";s:18:\"bathing-essentials\";s:11:\"category_id\";i:415;s:13:\"category_name\";s:11:\"Bath Slings\";s:13:\"category_slug\";s:11:\"bath-slings\";}i:559;a:10:{s:26:\"master_category_section_id\";i:560;s:18:\"master_category_id\";i:8;s:20:\"master_category_name\";s:4:\"BATH\";s:20:\"master_category_slug\";s:4:\"bath\";s:15:\"section_type_id\";i:47;s:17:\"section_type_name\";s:18:\"BATHING ESSENTIALS\";s:17:\"section_type_slug\";s:18:\"bathing-essentials\";s:11:\"category_id\";i:416;s:13:\"category_name\";s:23:\"Kids Pool & Accessories\";s:13:\"category_slug\";s:21:\"kids-pool-accessories\";}i:560;a:10:{s:26:\"master_category_section_id\";i:561;s:18:\"master_category_id\";i:9;s:20:\"master_category_name\";s:7:\"NURSERY\";s:20:\"master_category_slug\";s:7:\"nursery\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:417;s:13:\"category_name\";s:24:\"Cots, Cradles & Playpens\";s:13:\"category_slug\";s:21:\"cots-cradles-playpens\";}i:561;a:10:{s:26:\"master_category_section_id\";i:562;s:18:\"master_category_id\";i:9;s:20:\"master_category_name\";s:7:\"NURSERY\";s:20:\"master_category_slug\";s:7:\"nursery\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:418;s:13:\"category_name\";s:27:\"Blankets, Quilts & Wrappers\";s:13:\"category_slug\";s:24:\"blankets-quilts-wrappers\";}i:562;a:10:{s:26:\"master_category_section_id\";i:563;s:18:\"master_category_id\";i:9;s:20:\"master_category_name\";s:7:\"NURSERY\";s:20:\"master_category_slug\";s:7:\"nursery\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:419;s:13:\"category_name\";s:18:\"Baby Sleeping Bags\";s:13:\"category_slug\";s:18:\"baby-sleeping-bags\";}i:563;a:10:{s:26:\"master_category_section_id\";i:564;s:18:\"master_category_id\";i:9;s:20:\"master_category_name\";s:7:\"NURSERY\";s:20:\"master_category_slug\";s:7:\"nursery\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:420;s:13:\"category_name\";s:27:\"Baby Bedding Sets & Pillows\";s:13:\"category_slug\";s:25:\"baby-bedding-sets-pillows\";}i:564;a:10:{s:26:\"master_category_section_id\";i:565;s:18:\"master_category_id\";i:9;s:20:\"master_category_name\";s:7:\"NURSERY\";s:20:\"master_category_slug\";s:7:\"nursery\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:421;s:13:\"category_name\";s:13:\"Mosquito Nets\";s:13:\"category_slug\";s:13:\"mosquito-nets\";}i:565;a:10:{s:26:\"master_category_section_id\";i:566;s:18:\"master_category_id\";i:9;s:20:\"master_category_name\";s:7:\"NURSERY\";s:20:\"master_category_slug\";s:7:\"nursery\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:422;s:13:\"category_name\";s:19:\"Wardrobes & Storage\";s:13:\"category_slug\";s:17:\"wardrobes-storage\";}i:566;a:10:{s:26:\"master_category_section_id\";i:567;s:18:\"master_category_id\";i:9;s:20:\"master_category_name\";s:7:\"NURSERY\";s:20:\"master_category_slug\";s:7:\"nursery\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:423;s:13:\"category_name\";s:29:\"Kids Room and Study Furniture\";s:13:\"category_slug\";s:29:\"kids-room-and-study-furniture\";}i:567;a:10:{s:26:\"master_category_section_id\";i:568;s:18:\"master_category_id\";i:9;s:20:\"master_category_name\";s:7:\"NURSERY\";s:20:\"master_category_slug\";s:7:\"nursery\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:424;s:13:\"category_name\";s:23:\"Room Decor & Furnishing\";s:13:\"category_slug\";s:21:\"room-decor-furnishing\";}i:568;a:10:{s:26:\"master_category_section_id\";i:569;s:18:\"master_category_id\";i:9;s:20:\"master_category_name\";s:7:\"NURSERY\";s:20:\"master_category_slug\";s:7:\"nursery\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:425;s:13:\"category_name\";s:22:\"Travel Trolleys & Bags\";s:13:\"category_slug\";s:20:\"travel-trolleys-bags\";}i:569;a:10:{s:26:\"master_category_section_id\";i:570;s:18:\"master_category_id\";i:9;s:20:\"master_category_name\";s:7:\"NURSERY\";s:20:\"master_category_slug\";s:7:\"nursery\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:426;s:13:\"category_name\";s:22:\"Wall Papers & Stickers\";s:13:\"category_slug\";s:20:\"wall-papers-stickers\";}i:570;a:10:{s:26:\"master_category_section_id\";i:571;s:18:\"master_category_id\";i:9;s:20:\"master_category_name\";s:7:\"NURSERY\";s:20:\"master_category_slug\";s:7:\"nursery\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:427;s:13:\"category_name\";s:6:\"Clocks\";s:13:\"category_slug\";s:6:\"clocks\";}i:571;a:10:{s:26:\"master_category_section_id\";i:572;s:18:\"master_category_id\";i:9;s:20:\"master_category_name\";s:7:\"NURSERY\";s:20:\"master_category_slug\";s:7:\"nursery\";s:15:\"section_type_id\";i:48;s:17:\"section_type_name\";s:27:\"BLANKETS, QUILTS & WRAPPERS\";s:17:\"section_type_slug\";s:24:\"blankets-quilts-wrappers\";s:11:\"category_id\";i:428;s:13:\"category_name\";s:17:\"Blankets & Quilts\";s:13:\"category_slug\";s:15:\"blankets-quilts\";}i:572;a:10:{s:26:\"master_category_section_id\";i:573;s:18:\"master_category_id\";i:9;s:20:\"master_category_name\";s:7:\"NURSERY\";s:20:\"master_category_slug\";s:7:\"nursery\";s:15:\"section_type_id\";i:48;s:17:\"section_type_name\";s:27:\"BLANKETS, QUILTS & WRAPPERS\";s:17:\"section_type_slug\";s:24:\"blankets-quilts-wrappers\";s:11:\"category_id\";i:429;s:13:\"category_name\";s:19:\"Wrappers & Swaddles\";s:13:\"category_slug\";s:17:\"wrappers-swaddles\";}i:573;a:10:{s:26:\"master_category_section_id\";i:574;s:18:\"master_category_id\";i:9;s:20:\"master_category_name\";s:7:\"NURSERY\";s:20:\"master_category_slug\";s:7:\"nursery\";s:15:\"section_type_id\";i:48;s:17:\"section_type_name\";s:27:\"BLANKETS, QUILTS & WRAPPERS\";s:17:\"section_type_slug\";s:24:\"blankets-quilts-wrappers\";s:11:\"category_id\";i:419;s:13:\"category_name\";s:18:\"Baby Sleeping Bags\";s:13:\"category_slug\";s:18:\"baby-sleeping-bags\";}i:574;a:10:{s:26:\"master_category_section_id\";i:575;s:18:\"master_category_id\";i:9;s:20:\"master_category_name\";s:7:\"NURSERY\";s:20:\"master_category_slug\";s:7:\"nursery\";s:15:\"section_type_id\";i:48;s:17:\"section_type_name\";s:27:\"BLANKETS, QUILTS & WRAPPERS\";s:17:\"section_type_slug\";s:24:\"blankets-quilts-wrappers\";s:11:\"category_id\";i:430;s:13:\"category_name\";s:24:\"Hooded Towels & Wrappers\";s:13:\"category_slug\";s:22:\"hooded-towels-wrappers\";}i:575;a:10:{s:26:\"master_category_section_id\";i:576;s:18:\"master_category_id\";i:9;s:20:\"master_category_name\";s:7:\"NURSERY\";s:20:\"master_category_slug\";s:7:\"nursery\";s:15:\"section_type_id\";i:49;s:17:\"section_type_name\";s:14:\"BABY FURNITURE\";s:17:\"section_type_slug\";s:14:\"baby-furniture\";s:11:\"category_id\";i:431;s:13:\"category_name\";s:12:\"Cots & Cribs\";s:13:\"category_slug\";s:10:\"cots-cribs\";}i:576;a:10:{s:26:\"master_category_section_id\";i:577;s:18:\"master_category_id\";i:9;s:20:\"master_category_name\";s:7:\"NURSERY\";s:20:\"master_category_slug\";s:7:\"nursery\";s:15:\"section_type_id\";i:49;s:17:\"section_type_name\";s:14:\"BABY FURNITURE\";s:17:\"section_type_slug\";s:14:\"baby-furniture\";s:11:\"category_id\";i:432;s:13:\"category_name\";s:19:\"Cradles & Bassinets\";s:13:\"category_slug\";s:17:\"cradles-bassinets\";}i:577;a:10:{s:26:\"master_category_section_id\";i:578;s:18:\"master_category_id\";i:9;s:20:\"master_category_name\";s:7:\"NURSERY\";s:20:\"master_category_slug\";s:7:\"nursery\";s:15:\"section_type_id\";i:49;s:17:\"section_type_name\";s:14:\"BABY FURNITURE\";s:17:\"section_type_slug\";s:14:\"baby-furniture\";s:11:\"category_id\";i:433;s:13:\"category_name\";s:21:\"Playpens / Play yards\";s:13:\"category_slug\";s:19:\"playpens-play-yards\";}i:578;a:10:{s:26:\"master_category_section_id\";i:579;s:18:\"master_category_id\";i:9;s:20:\"master_category_name\";s:7:\"NURSERY\";s:20:\"master_category_slug\";s:7:\"nursery\";s:15:\"section_type_id\";i:49;s:17:\"section_type_name\";s:14:\"BABY FURNITURE\";s:17:\"section_type_slug\";s:14:\"baby-furniture\";s:11:\"category_id\";i:434;s:13:\"category_name\";s:16:\"Wooden Furniture\";s:13:\"category_slug\";s:16:\"wooden-furniture\";}i:579;a:10:{s:26:\"master_category_section_id\";i:580;s:18:\"master_category_id\";i:9;s:20:\"master_category_name\";s:7:\"NURSERY\";s:20:\"master_category_slug\";s:7:\"nursery\";s:15:\"section_type_id\";i:49;s:17:\"section_type_name\";s:14:\"BABY FURNITURE\";s:17:\"section_type_slug\";s:14:\"baby-furniture\";s:11:\"category_id\";i:435;s:13:\"category_name\";s:11:\"Cot Mobiles\";s:13:\"category_slug\";s:11:\"cot-mobiles\";}i:580;a:10:{s:26:\"master_category_section_id\";i:581;s:18:\"master_category_id\";i:9;s:20:\"master_category_name\";s:7:\"NURSERY\";s:20:\"master_category_slug\";s:7:\"nursery\";s:15:\"section_type_id\";i:49;s:17:\"section_type_name\";s:14:\"BABY FURNITURE\";s:17:\"section_type_slug\";s:14:\"baby-furniture\";s:11:\"category_id\";i:436;s:13:\"category_name\";s:13:\"Baby Monitors\";s:13:\"category_slug\";s:13:\"baby-monitors\";}i:581;a:10:{s:26:\"master_category_section_id\";i:582;s:18:\"master_category_id\";i:9;s:20:\"master_category_name\";s:7:\"NURSERY\";s:20:\"master_category_slug\";s:7:\"nursery\";s:15:\"section_type_id\";i:50;s:17:\"section_type_name\";s:27:\"BABY BEDDING SETS & PILLOWS\";s:17:\"section_type_slug\";s:25:\"baby-bedding-sets-pillows\";s:11:\"category_id\";i:437;s:13:\"category_name\";s:15:\"Baby Gadda Sets\";s:13:\"category_slug\";s:15:\"baby-gadda-sets\";}i:582;a:10:{s:26:\"master_category_section_id\";i:583;s:18:\"master_category_id\";i:9;s:20:\"master_category_name\";s:7:\"NURSERY\";s:20:\"master_category_slug\";s:7:\"nursery\";s:15:\"section_type_id\";i:50;s:17:\"section_type_name\";s:27:\"BABY BEDDING SETS & PILLOWS\";s:17:\"section_type_slug\";s:25:\"baby-bedding-sets-pillows\";s:11:\"category_id\";i:438;s:13:\"category_name\";s:27:\"Baby Pillows & Bolster Sets\";s:13:\"category_slug\";s:25:\"baby-pillows-bolster-sets\";}i:583;a:10:{s:26:\"master_category_section_id\";i:584;s:18:\"master_category_id\";i:9;s:20:\"master_category_name\";s:7:\"NURSERY\";s:20:\"master_category_slug\";s:7:\"nursery\";s:15:\"section_type_id\";i:50;s:17:\"section_type_name\";s:27:\"BABY BEDDING SETS & PILLOWS\";s:17:\"section_type_slug\";s:25:\"baby-bedding-sets-pillows\";s:11:\"category_id\";i:439;s:13:\"category_name\";s:27:\"Mustard Seed Infant Pillows\";s:13:\"category_slug\";s:27:\"mustard-seed-infant-pillows\";}i:584;a:10:{s:26:\"master_category_section_id\";i:585;s:18:\"master_category_id\";i:9;s:20:\"master_category_name\";s:7:\"NURSERY\";s:20:\"master_category_slug\";s:7:\"nursery\";s:15:\"section_type_id\";i:50;s:17:\"section_type_name\";s:27:\"BABY BEDDING SETS & PILLOWS\";s:17:\"section_type_slug\";s:25:\"baby-bedding-sets-pillows\";s:11:\"category_id\";i:440;s:13:\"category_name\";s:22:\"Neck & Head Supporters\";s:13:\"category_slug\";s:20:\"neck-head-supporters\";}i:585;a:10:{s:26:\"master_category_section_id\";i:586;s:18:\"master_category_id\";i:9;s:20:\"master_category_name\";s:7:\"NURSERY\";s:20:\"master_category_slug\";s:7:\"nursery\";s:15:\"section_type_id\";i:50;s:17:\"section_type_name\";s:27:\"BABY BEDDING SETS & PILLOWS\";s:17:\"section_type_slug\";s:25:\"baby-bedding-sets-pillows\";s:11:\"category_id\";i:196;s:13:\"category_name\";s:14:\"Bed Protectors\";s:13:\"category_slug\";s:14:\"bed-protectors\";}i:586;a:10:{s:26:\"master_category_section_id\";i:587;s:18:\"master_category_id\";i:9;s:20:\"master_category_name\";s:7:\"NURSERY\";s:20:\"master_category_slug\";s:7:\"nursery\";s:15:\"section_type_id\";i:51;s:17:\"section_type_name\";s:22:\"STORAGE & ORGANIZATION\";s:17:\"section_type_slug\";s:20:\"storage-organization\";s:11:\"category_id\";i:441;s:13:\"category_name\";s:25:\"Wardrobes & Storage Units\";s:13:\"category_slug\";s:23:\"wardrobes-storage-units\";}i:587;a:10:{s:26:\"master_category_section_id\";i:588;s:18:\"master_category_id\";i:9;s:20:\"master_category_name\";s:7:\"NURSERY\";s:20:\"master_category_slug\";s:7:\"nursery\";s:15:\"section_type_id\";i:51;s:17:\"section_type_name\";s:22:\"STORAGE & ORGANIZATION\";s:17:\"section_type_slug\";s:20:\"storage-organization\";s:11:\"category_id\";i:442;s:13:\"category_name\";s:16:\"Chest of Drawers\";s:13:\"category_slug\";s:16:\"chest-of-drawers\";}i:588;a:10:{s:26:\"master_category_section_id\";i:589;s:18:\"master_category_id\";i:9;s:20:\"master_category_name\";s:7:\"NURSERY\";s:20:\"master_category_slug\";s:7:\"nursery\";s:15:\"section_type_id\";i:51;s:17:\"section_type_name\";s:22:\"STORAGE & ORGANIZATION\";s:17:\"section_type_slug\";s:20:\"storage-organization\";s:11:\"category_id\";i:443;s:13:\"category_name\";s:13:\"Storage Boxes\";s:13:\"category_slug\";s:13:\"storage-boxes\";}i:589;a:10:{s:26:\"master_category_section_id\";i:590;s:18:\"master_category_id\";i:9;s:20:\"master_category_name\";s:7:\"NURSERY\";s:20:\"master_category_slug\";s:7:\"nursery\";s:15:\"section_type_id\";i:51;s:17:\"section_type_name\";s:22:\"STORAGE & ORGANIZATION\";s:17:\"section_type_slug\";s:20:\"storage-organization\";s:11:\"category_id\";i:444;s:13:\"category_name\";s:5:\"Racks\";s:13:\"category_slug\";s:5:\"racks\";}i:590;a:10:{s:26:\"master_category_section_id\";i:591;s:18:\"master_category_id\";i:9;s:20:\"master_category_name\";s:7:\"NURSERY\";s:20:\"master_category_slug\";s:7:\"nursery\";s:15:\"section_type_id\";i:51;s:17:\"section_type_name\";s:22:\"STORAGE & ORGANIZATION\";s:17:\"section_type_slug\";s:20:\"storage-organization\";s:11:\"category_id\";i:445;s:13:\"category_name\";s:13:\"Hangers/Hooks\";s:13:\"category_slug\";s:12:\"hangershooks\";}i:591;a:10:{s:26:\"master_category_section_id\";i:592;s:18:\"master_category_id\";i:9;s:20:\"master_category_name\";s:7:\"NURSERY\";s:20:\"master_category_slug\";s:7:\"nursery\";s:15:\"section_type_id\";i:51;s:17:\"section_type_name\";s:22:\"STORAGE & ORGANIZATION\";s:17:\"section_type_slug\";s:20:\"storage-organization\";s:11:\"category_id\";i:446;s:13:\"category_name\";s:19:\"Storage Bags & Bins\";s:13:\"category_slug\";s:17:\"storage-bags-bins\";}i:592;a:10:{s:26:\"master_category_section_id\";i:593;s:18:\"master_category_id\";i:9;s:20:\"master_category_name\";s:7:\"NURSERY\";s:20:\"master_category_slug\";s:7:\"nursery\";s:15:\"section_type_id\";i:51;s:17:\"section_type_name\";s:22:\"STORAGE & ORGANIZATION\";s:17:\"section_type_slug\";s:20:\"storage-organization\";s:11:\"category_id\";i:447;s:13:\"category_name\";s:25:\"Hanging Organiser Pockets\";s:13:\"category_slug\";s:25:\"hanging-organiser-pockets\";}i:593;a:10:{s:26:\"master_category_section_id\";i:594;s:18:\"master_category_id\";i:9;s:20:\"master_category_name\";s:7:\"NURSERY\";s:20:\"master_category_slug\";s:7:\"nursery\";s:15:\"section_type_id\";i:51;s:17:\"section_type_name\";s:22:\"STORAGE & ORGANIZATION\";s:17:\"section_type_slug\";s:20:\"storage-organization\";s:11:\"category_id\";i:448;s:13:\"category_name\";s:12:\"Laundry Bags\";s:13:\"category_slug\";s:12:\"laundry-bags\";}i:594;a:10:{s:26:\"master_category_section_id\";i:595;s:18:\"master_category_id\";i:9;s:20:\"master_category_name\";s:7:\"NURSERY\";s:20:\"master_category_slug\";s:7:\"nursery\";s:15:\"section_type_id\";i:51;s:17:\"section_type_name\";s:22:\"STORAGE & ORGANIZATION\";s:17:\"section_type_slug\";s:20:\"storage-organization\";s:11:\"category_id\";i:449;s:13:\"category_name\";s:11:\"Bookshelves\";s:13:\"category_slug\";s:11:\"bookshelves\";}i:595;a:10:{s:26:\"master_category_section_id\";i:596;s:18:\"master_category_id\";i:9;s:20:\"master_category_name\";s:7:\"NURSERY\";s:20:\"master_category_slug\";s:7:\"nursery\";s:15:\"section_type_id\";i:52;s:17:\"section_type_name\";s:23:\"KIDS BEDDING ESSENTIALS\";s:17:\"section_type_slug\";s:23:\"kids-bedding-essentials\";s:11:\"category_id\";i:450;s:13:\"category_name\";s:12:\"Bedding Sets\";s:13:\"category_slug\";s:12:\"bedding-sets\";}i:596;a:10:{s:26:\"master_category_section_id\";i:597;s:18:\"master_category_id\";i:9;s:20:\"master_category_name\";s:7:\"NURSERY\";s:20:\"master_category_slug\";s:7:\"nursery\";s:15:\"section_type_id\";i:52;s:17:\"section_type_name\";s:23:\"KIDS BEDDING ESSENTIALS\";s:17:\"section_type_slug\";s:23:\"kids-bedding-essentials\";s:11:\"category_id\";i:428;s:13:\"category_name\";s:17:\"Blankets & Quilts\";s:13:\"category_slug\";s:15:\"blankets-quilts\";}i:597;a:10:{s:26:\"master_category_section_id\";i:598;s:18:\"master_category_id\";i:9;s:20:\"master_category_name\";s:7:\"NURSERY\";s:20:\"master_category_slug\";s:7:\"nursery\";s:15:\"section_type_id\";i:52;s:17:\"section_type_name\";s:23:\"KIDS BEDDING ESSENTIALS\";s:17:\"section_type_slug\";s:23:\"kids-bedding-essentials\";s:11:\"category_id\";i:451;s:13:\"category_name\";s:14:\"Bed Comforters\";s:13:\"category_slug\";s:14:\"bed-comforters\";}i:598;a:10:{s:26:\"master_category_section_id\";i:599;s:18:\"master_category_id\";i:9;s:20:\"master_category_name\";s:7:\"NURSERY\";s:20:\"master_category_slug\";s:7:\"nursery\";s:15:\"section_type_id\";i:52;s:17:\"section_type_name\";s:23:\"KIDS BEDDING ESSENTIALS\";s:17:\"section_type_slug\";s:23:\"kids-bedding-essentials\";s:11:\"category_id\";i:452;s:13:\"category_name\";s:9:\"Bedsheets\";s:13:\"category_slug\";s:9:\"bedsheets\";}i:599;a:10:{s:26:\"master_category_section_id\";i:600;s:18:\"master_category_id\";i:9;s:20:\"master_category_name\";s:7:\"NURSERY\";s:20:\"master_category_slug\";s:7:\"nursery\";s:15:\"section_type_id\";i:52;s:17:\"section_type_name\";s:23:\"KIDS BEDDING ESSENTIALS\";s:17:\"section_type_slug\";s:23:\"kids-bedding-essentials\";s:11:\"category_id\";i:453;s:13:\"category_name\";s:26:\"Cushion, Pillow & Bolsters\";s:13:\"category_slug\";s:23:\"cushion-pillow-bolsters\";}i:600;a:10:{s:26:\"master_category_section_id\";i:601;s:18:\"master_category_id\";i:9;s:20:\"master_category_name\";s:7:\"NURSERY\";s:20:\"master_category_slug\";s:7:\"nursery\";s:15:\"section_type_id\";i:52;s:17:\"section_type_name\";s:23:\"KIDS BEDDING ESSENTIALS\";s:17:\"section_type_slug\";s:23:\"kids-bedding-essentials\";s:11:\"category_id\";i:454;s:13:\"category_name\";s:23:\"Cushion & Pillow Covers\";s:13:\"category_slug\";s:21:\"cushion-pillow-covers\";}i:601;a:10:{s:26:\"master_category_section_id\";i:602;s:18:\"master_category_id\";i:9;s:20:\"master_category_name\";s:7:\"NURSERY\";s:20:\"master_category_slug\";s:7:\"nursery\";s:15:\"section_type_id\";i:14;s:17:\"section_type_name\";s:10:\"TOP BRANDS\";s:17:\"section_type_slug\";s:10:\"top-brands\";s:11:\"category_id\";i:71;s:13:\"category_name\";s:7:\"Babyhug\";s:13:\"category_slug\";s:7:\"babyhug\";}i:602;a:10:{s:26:\"master_category_section_id\";i:603;s:18:\"master_category_id\";i:9;s:20:\"master_category_name\";s:7:\"NURSERY\";s:20:\"master_category_slug\";s:7:\"nursery\";s:15:\"section_type_id\";i:14;s:17:\"section_type_name\";s:10:\"TOP BRANDS\";s:17:\"section_type_slug\";s:10:\"top-brands\";s:11:\"category_id\";i:184;s:13:\"category_name\";s:11:\"Fab n Funky\";s:13:\"category_slug\";s:11:\"fab-n-funky\";}i:603;a:10:{s:26:\"master_category_section_id\";i:604;s:18:\"master_category_id\";i:9;s:20:\"master_category_name\";s:7:\"NURSERY\";s:20:\"master_category_slug\";s:7:\"nursery\";s:15:\"section_type_id\";i:14;s:17:\"section_type_name\";s:10:\"TOP BRANDS\";s:17:\"section_type_slug\";s:10:\"top-brands\";s:11:\"category_id\";i:455;s:13:\"category_name\";s:13:\"Haus & kinder\";s:13:\"category_slug\";s:11:\"haus-kinder\";}i:604;a:10:{s:26:\"master_category_section_id\";i:605;s:18:\"master_category_id\";i:9;s:20:\"master_category_name\";s:7:\"NURSERY\";s:20:\"master_category_slug\";s:7:\"nursery\";s:15:\"section_type_id\";i:14;s:17:\"section_type_name\";s:10:\"TOP BRANDS\";s:17:\"section_type_slug\";s:10:\"top-brands\";s:11:\"category_id\";i:456;s:13:\"category_name\";s:8:\"Brandonn\";s:13:\"category_slug\";s:8:\"brandonn\";}i:605;a:10:{s:26:\"master_category_section_id\";i:606;s:18:\"master_category_id\";i:9;s:20:\"master_category_name\";s:7:\"NURSERY\";s:20:\"master_category_slug\";s:7:\"nursery\";s:15:\"section_type_id\";i:14;s:17:\"section_type_name\";s:10:\"TOP BRANDS\";s:17:\"section_type_slug\";s:10:\"top-brands\";s:11:\"category_id\";i:457;s:13:\"category_name\";s:10:\"Mom\'s Home\";s:13:\"category_slug\";s:9:\"moms-home\";}i:606;a:10:{s:26:\"master_category_section_id\";i:607;s:18:\"master_category_id\";i:9;s:20:\"master_category_name\";s:7:\"NURSERY\";s:20:\"master_category_slug\";s:7:\"nursery\";s:15:\"section_type_id\";i:14;s:17:\"section_type_name\";s:10:\"TOP BRANDS\";s:17:\"section_type_slug\";s:10:\"top-brands\";s:11:\"category_id\";i:458;s:13:\"category_name\";s:4:\"SYGA\";s:13:\"category_slug\";s:4:\"syga\";}i:607;a:10:{s:26:\"master_category_section_id\";i:608;s:18:\"master_category_id\";i:9;s:20:\"master_category_name\";s:7:\"NURSERY\";s:20:\"master_category_slug\";s:7:\"nursery\";s:15:\"section_type_id\";i:14;s:17:\"section_type_name\";s:10:\"TOP BRANDS\";s:17:\"section_type_slug\";s:10:\"top-brands\";s:11:\"category_id\";i:278;s:13:\"category_name\";s:6:\"Baybee\";s:13:\"category_slug\";s:6:\"baybee\";}i:608;a:10:{s:26:\"master_category_section_id\";i:609;s:18:\"master_category_id\";i:9;s:20:\"master_category_name\";s:7:\"NURSERY\";s:20:\"master_category_slug\";s:7:\"nursery\";s:15:\"section_type_id\";i:14;s:17:\"section_type_name\";s:10:\"TOP BRANDS\";s:17:\"section_type_slug\";s:10:\"top-brands\";s:11:\"category_id\";i:459;s:13:\"category_name\";s:11:\"Abracadabra\";s:13:\"category_slug\";s:11:\"abracadabra\";}i:609;a:10:{s:26:\"master_category_section_id\";i:610;s:18:\"master_category_id\";i:9;s:20:\"master_category_name\";s:7:\"NURSERY\";s:20:\"master_category_slug\";s:7:\"nursery\";s:15:\"section_type_id\";i:14;s:17:\"section_type_name\";s:10:\"TOP BRANDS\";s:17:\"section_type_slug\";s:10:\"top-brands\";s:11:\"category_id\";i:277;s:13:\"category_name\";s:12:\"R for Rabbit\";s:13:\"category_slug\";s:12:\"r-for-rabbit\";}i:610;a:10:{s:26:\"master_category_section_id\";i:611;s:18:\"master_category_id\";i:9;s:20:\"master_category_name\";s:7:\"NURSERY\";s:20:\"master_category_slug\";s:7:\"nursery\";s:15:\"section_type_id\";i:14;s:17:\"section_type_name\";s:10:\"TOP BRANDS\";s:17:\"section_type_slug\";s:10:\"top-brands\";s:11:\"category_id\";i:279;s:13:\"category_name\";s:7:\"Luv Lap\";s:13:\"category_slug\";s:7:\"luv-lap\";}i:611;a:10:{s:26:\"master_category_section_id\";i:612;s:18:\"master_category_id\";i:9;s:20:\"master_category_name\";s:7:\"NURSERY\";s:20:\"master_category_slug\";s:7:\"nursery\";s:15:\"section_type_id\";i:14;s:17:\"section_type_name\";s:10:\"TOP BRANDS\";s:17:\"section_type_slug\";s:10:\"top-brands\";s:11:\"category_id\";i:460;s:13:\"category_name\";s:10:\"Elementary\";s:13:\"category_slug\";s:10:\"elementary\";}i:612;a:10:{s:26:\"master_category_section_id\";i:613;s:18:\"master_category_id\";i:9;s:20:\"master_category_name\";s:7:\"NURSERY\";s:20:\"master_category_slug\";s:7:\"nursery\";s:15:\"section_type_id\";i:14;s:17:\"section_type_name\";s:10:\"TOP BRANDS\";s:17:\"section_type_slug\";s:10:\"top-brands\";s:11:\"category_id\";i:461;s:13:\"category_name\";s:8:\"Mi Arcus\";s:13:\"category_slug\";s:8:\"mi-arcus\";}i:613;a:10:{s:26:\"master_category_section_id\";i:614;s:18:\"master_category_id\";i:9;s:20:\"master_category_name\";s:7:\"NURSERY\";s:20:\"master_category_slug\";s:7:\"nursery\";s:15:\"section_type_id\";i:14;s:17:\"section_type_name\";s:10:\"TOP BRANDS\";s:17:\"section_type_slug\";s:10:\"top-brands\";s:11:\"category_id\";i:462;s:13:\"category_name\";s:8:\"Nilkamal\";s:13:\"category_slug\";s:8:\"nilkamal\";}i:614;a:10:{s:26:\"master_category_section_id\";i:615;s:18:\"master_category_id\";i:9;s:20:\"master_category_name\";s:7:\"NURSERY\";s:20:\"master_category_slug\";s:7:\"nursery\";s:15:\"section_type_id\";i:14;s:17:\"section_type_name\";s:10:\"TOP BRANDS\";s:17:\"section_type_slug\";s:10:\"top-brands\";s:11:\"category_id\";i:463;s:13:\"category_name\";s:7:\"Kiddery\";s:13:\"category_slug\";s:7:\"kiddery\";}i:615;a:10:{s:26:\"master_category_section_id\";i:616;s:18:\"master_category_id\";i:9;s:20:\"master_category_name\";s:7:\"NURSERY\";s:20:\"master_category_slug\";s:7:\"nursery\";s:15:\"section_type_id\";i:53;s:17:\"section_type_name\";s:13:\"MOSQUITO NETS\";s:17:\"section_type_slug\";s:13:\"mosquito-nets\";s:11:\"category_id\";i:464;s:13:\"category_name\";s:22:\"Mattress Set With Nets\";s:13:\"category_slug\";s:22:\"mattress-set-with-nets\";}i:616;a:10:{s:26:\"master_category_section_id\";i:617;s:18:\"master_category_id\";i:9;s:20:\"master_category_name\";s:7:\"NURSERY\";s:20:\"master_category_slug\";s:7:\"nursery\";s:15:\"section_type_id\";i:53;s:17:\"section_type_name\";s:13:\"MOSQUITO NETS\";s:17:\"section_type_slug\";s:13:\"mosquito-nets\";s:11:\"category_id\";i:421;s:13:\"category_name\";s:13:\"Mosquito Nets\";s:13:\"category_slug\";s:13:\"mosquito-nets\";}i:617;a:10:{s:26:\"master_category_section_id\";i:618;s:18:\"master_category_id\";i:9;s:20:\"master_category_name\";s:7:\"NURSERY\";s:20:\"master_category_slug\";s:7:\"nursery\";s:15:\"section_type_id\";i:54;s:17:\"section_type_name\";s:18:\"TRAVEL ACCESSORIES\";s:17:\"section_type_slug\";s:18:\"travel-accessories\";s:11:\"category_id\";i:465;s:13:\"category_name\";s:20:\"Trolley Luggage Bags\";s:13:\"category_slug\";s:20:\"trolley-luggage-bags\";}i:618;a:10:{s:26:\"master_category_section_id\";i:619;s:18:\"master_category_id\";i:9;s:20:\"master_category_name\";s:7:\"NURSERY\";s:20:\"master_category_slug\";s:7:\"nursery\";s:15:\"section_type_id\";i:54;s:17:\"section_type_name\";s:18:\"TRAVEL ACCESSORIES\";s:17:\"section_type_slug\";s:18:\"travel-accessories\";s:11:\"category_id\";i:466;s:13:\"category_name\";s:11:\"Duffle Bags\";s:13:\"category_slug\";s:11:\"duffle-bags\";}i:619;a:10:{s:26:\"master_category_section_id\";i:620;s:18:\"master_category_id\";i:9;s:20:\"master_category_name\";s:7:\"NURSERY\";s:20:\"master_category_slug\";s:7:\"nursery\";s:15:\"section_type_id\";i:54;s:17:\"section_type_name\";s:18:\"TRAVEL ACCESSORIES\";s:17:\"section_type_slug\";s:18:\"travel-accessories\";s:11:\"category_id\";i:467;s:13:\"category_name\";s:14:\"Accessory Bags\";s:13:\"category_slug\";s:14:\"accessory-bags\";}i:620;a:10:{s:26:\"master_category_section_id\";i:621;s:18:\"master_category_id\";i:9;s:20:\"master_category_name\";s:7:\"NURSERY\";s:20:\"master_category_slug\";s:7:\"nursery\";s:15:\"section_type_id\";i:54;s:17:\"section_type_name\";s:18:\"TRAVEL ACCESSORIES\";s:17:\"section_type_slug\";s:18:\"travel-accessories\";s:11:\"category_id\";i:468;s:13:\"category_name\";s:12:\"Luggage Tags\";s:13:\"category_slug\";s:12:\"luggage-tags\";}i:621;a:10:{s:26:\"master_category_section_id\";i:622;s:18:\"master_category_id\";i:9;s:20:\"master_category_name\";s:7:\"NURSERY\";s:20:\"master_category_slug\";s:7:\"nursery\";s:15:\"section_type_id\";i:55;s:17:\"section_type_name\";s:22:\"WALL PAPERS & STICKERS\";s:17:\"section_type_slug\";s:20:\"wall-papers-stickers\";s:11:\"category_id\";i:469;s:13:\"category_name\";s:22:\"Growth & Reward Charts\";s:13:\"category_slug\";s:20:\"growth-reward-charts\";}i:622;a:10:{s:26:\"master_category_section_id\";i:623;s:18:\"master_category_id\";i:9;s:20:\"master_category_name\";s:7:\"NURSERY\";s:20:\"master_category_slug\";s:7:\"nursery\";s:15:\"section_type_id\";i:55;s:17:\"section_type_name\";s:22:\"WALL PAPERS & STICKERS\";s:17:\"section_type_slug\";s:20:\"wall-papers-stickers\";s:11:\"category_id\";i:470;s:13:\"category_name\";s:22:\"Wall Stickers & Decals\";s:13:\"category_slug\";s:20:\"wall-stickers-decals\";}i:623;a:10:{s:26:\"master_category_section_id\";i:624;s:18:\"master_category_id\";i:9;s:20:\"master_category_name\";s:7:\"NURSERY\";s:20:\"master_category_slug\";s:7:\"nursery\";s:15:\"section_type_id\";i:55;s:17:\"section_type_name\";s:22:\"WALL PAPERS & STICKERS\";s:17:\"section_type_slug\";s:20:\"wall-papers-stickers\";s:11:\"category_id\";i:471;s:13:\"category_name\";s:21:\"Glow In Dark Stickers\";s:13:\"category_slug\";s:21:\"glow-in-dark-stickers\";}i:624;a:10:{s:26:\"master_category_section_id\";i:625;s:18:\"master_category_id\";i:9;s:20:\"master_category_name\";s:7:\"NURSERY\";s:20:\"master_category_slug\";s:7:\"nursery\";s:15:\"section_type_id\";i:56;s:17:\"section_type_name\";s:22:\"KIDS ROOM & STUDY ESS.\";s:17:\"section_type_slug\";s:19:\"kids-room-study-ess\";s:11:\"category_id\";i:472;s:13:\"category_name\";s:9:\"Kids Beds\";s:13:\"category_slug\";s:9:\"kids-beds\";}i:625;a:10:{s:26:\"master_category_section_id\";i:626;s:18:\"master_category_id\";i:9;s:20:\"master_category_name\";s:7:\"NURSERY\";s:20:\"master_category_slug\";s:7:\"nursery\";s:15:\"section_type_id\";i:56;s:17:\"section_type_name\";s:22:\"KIDS ROOM & STUDY ESS.\";s:17:\"section_type_slug\";s:19:\"kids-room-study-ess\";s:11:\"category_id\";i:473;s:13:\"category_name\";s:12:\"Study Tables\";s:13:\"category_slug\";s:12:\"study-tables\";}i:626;a:10:{s:26:\"master_category_section_id\";i:627;s:18:\"master_category_id\";i:9;s:20:\"master_category_name\";s:7:\"NURSERY\";s:20:\"master_category_slug\";s:7:\"nursery\";s:15:\"section_type_id\";i:56;s:17:\"section_type_name\";s:22:\"KIDS ROOM & STUDY ESS.\";s:17:\"section_type_slug\";s:19:\"kids-room-study-ess\";s:11:\"category_id\";i:474;s:13:\"category_name\";s:5:\"Chair\";s:13:\"category_slug\";s:5:\"chair\";}i:627;a:10:{s:26:\"master_category_section_id\";i:628;s:18:\"master_category_id\";i:9;s:20:\"master_category_name\";s:7:\"NURSERY\";s:20:\"master_category_slug\";s:7:\"nursery\";s:15:\"section_type_id\";i:56;s:17:\"section_type_name\";s:22:\"KIDS ROOM & STUDY ESS.\";s:17:\"section_type_slug\";s:19:\"kids-room-study-ess\";s:11:\"category_id\";i:475;s:13:\"category_name\";s:18:\"Table & Chair Sets\";s:13:\"category_slug\";s:16:\"table-chair-sets\";}i:628;a:10:{s:26:\"master_category_section_id\";i:629;s:18:\"master_category_id\";i:9;s:20:\"master_category_name\";s:7:\"NURSERY\";s:20:\"master_category_slug\";s:7:\"nursery\";s:15:\"section_type_id\";i:56;s:17:\"section_type_name\";s:22:\"KIDS ROOM & STUDY ESS.\";s:17:\"section_type_slug\";s:19:\"kids-room-study-ess\";s:11:\"category_id\";i:476;s:13:\"category_name\";s:25:\"Activity Tables/Lap Desks\";s:13:\"category_slug\";s:24:\"activity-tableslap-desks\";}i:629;a:10:{s:26:\"master_category_section_id\";i:630;s:18:\"master_category_id\";i:9;s:20:\"master_category_name\";s:7:\"NURSERY\";s:20:\"master_category_slug\";s:7:\"nursery\";s:15:\"section_type_id\";i:56;s:17:\"section_type_name\";s:22:\"KIDS ROOM & STUDY ESS.\";s:17:\"section_type_slug\";s:19:\"kids-room-study-ess\";s:11:\"category_id\";i:477;s:13:\"category_name\";s:6:\"Stools\";s:13:\"category_slug\";s:6:\"stools\";}i:630;a:10:{s:26:\"master_category_section_id\";i:631;s:18:\"master_category_id\";i:9;s:20:\"master_category_name\";s:7:\"NURSERY\";s:20:\"master_category_slug\";s:7:\"nursery\";s:15:\"section_type_id\";i:56;s:17:\"section_type_name\";s:22:\"KIDS ROOM & STUDY ESS.\";s:17:\"section_type_slug\";s:19:\"kids-room-study-ess\";s:11:\"category_id\";i:449;s:13:\"category_name\";s:11:\"Bookshelves\";s:13:\"category_slug\";s:11:\"bookshelves\";}i:631;a:10:{s:26:\"master_category_section_id\";i:632;s:18:\"master_category_id\";i:9;s:20:\"master_category_name\";s:7:\"NURSERY\";s:20:\"master_category_slug\";s:7:\"nursery\";s:15:\"section_type_id\";i:56;s:17:\"section_type_name\";s:22:\"KIDS ROOM & STUDY ESS.\";s:17:\"section_type_slug\";s:19:\"kids-room-study-ess\";s:11:\"category_id\";i:478;s:13:\"category_name\";s:27:\"Wired & Wireless Headphones\";s:13:\"category_slug\";s:25:\"wired-wireless-headphones\";}i:632;a:10:{s:26:\"master_category_section_id\";i:633;s:18:\"master_category_id\";i:9;s:20:\"master_category_name\";s:7:\"NURSERY\";s:20:\"master_category_slug\";s:7:\"nursery\";s:15:\"section_type_id\";i:56;s:17:\"section_type_name\";s:22:\"KIDS ROOM & STUDY ESS.\";s:17:\"section_type_slug\";s:19:\"kids-room-study-ess\";s:11:\"category_id\";i:479;s:13:\"category_name\";s:18:\"Bluetooth Speakers\";s:13:\"category_slug\";s:18:\"bluetooth-speakers\";}i:633;a:10:{s:26:\"master_category_section_id\";i:634;s:18:\"master_category_id\";i:9;s:20:\"master_category_name\";s:7:\"NURSERY\";s:20:\"master_category_slug\";s:7:\"nursery\";s:15:\"section_type_id\";i:57;s:17:\"section_type_name\";s:23:\"CRIB BEDDING ESSENTIALS\";s:17:\"section_type_slug\";s:23:\"crib-bedding-essentials\";s:11:\"category_id\";i:480;s:13:\"category_name\";s:13:\"Crib Mattress\";s:13:\"category_slug\";s:13:\"crib-mattress\";}i:634;a:10:{s:26:\"master_category_section_id\";i:635;s:18:\"master_category_id\";i:9;s:20:\"master_category_name\";s:7:\"NURSERY\";s:20:\"master_category_slug\";s:7:\"nursery\";s:15:\"section_type_id\";i:57;s:17:\"section_type_name\";s:23:\"CRIB BEDDING ESSENTIALS\";s:17:\"section_type_slug\";s:23:\"crib-bedding-essentials\";s:11:\"category_id\";i:481;s:13:\"category_name\";s:17:\"Crib Bedding Sets\";s:13:\"category_slug\";s:17:\"crib-bedding-sets\";}i:635;a:10:{s:26:\"master_category_section_id\";i:636;s:18:\"master_category_id\";i:9;s:20:\"master_category_name\";s:7:\"NURSERY\";s:20:\"master_category_slug\";s:7:\"nursery\";s:15:\"section_type_id\";i:57;s:17:\"section_type_name\";s:23:\"CRIB BEDDING ESSENTIALS\";s:17:\"section_type_slug\";s:23:\"crib-bedding-essentials\";s:11:\"category_id\";i:482;s:13:\"category_name\";s:11:\"Bed Bumpers\";s:13:\"category_slug\";s:11:\"bed-bumpers\";}i:636;a:10:{s:26:\"master_category_section_id\";i:637;s:18:\"master_category_id\";i:9;s:20:\"master_category_name\";s:7:\"NURSERY\";s:20:\"master_category_slug\";s:7:\"nursery\";s:15:\"section_type_id\";i:57;s:17:\"section_type_name\";s:23:\"CRIB BEDDING ESSENTIALS\";s:17:\"section_type_slug\";s:23:\"crib-bedding-essentials\";s:11:\"category_id\";i:483;s:13:\"category_name\";s:11:\"Crib Sheets\";s:13:\"category_slug\";s:11:\"crib-sheets\";}i:637;a:10:{s:26:\"master_category_section_id\";i:638;s:18:\"master_category_id\";i:9;s:20:\"master_category_name\";s:7:\"NURSERY\";s:20:\"master_category_slug\";s:7:\"nursery\";s:15:\"section_type_id\";i:57;s:17:\"section_type_name\";s:23:\"CRIB BEDDING ESSENTIALS\";s:17:\"section_type_slug\";s:23:\"crib-bedding-essentials\";s:11:\"category_id\";i:484;s:13:\"category_name\";s:25:\"Mattress Protector Covers\";s:13:\"category_slug\";s:25:\"mattress-protector-covers\";}i:638;a:10:{s:26:\"master_category_section_id\";i:639;s:18:\"master_category_id\";i:9;s:20:\"master_category_name\";s:7:\"NURSERY\";s:20:\"master_category_slug\";s:7:\"nursery\";s:15:\"section_type_id\";i:58;s:17:\"section_type_name\";s:32:\"MATTRESSES & MATTRESS PROTECTORS\";s:17:\"section_type_slug\";s:30:\"mattresses-mattress-protectors\";s:11:\"category_id\";i:485;s:13:\"category_name\";s:19:\"Mattress Protectors\";s:13:\"category_slug\";s:19:\"mattress-protectors\";}i:639;a:10:{s:26:\"master_category_section_id\";i:640;s:18:\"master_category_id\";i:9;s:20:\"master_category_name\";s:7:\"NURSERY\";s:20:\"master_category_slug\";s:7:\"nursery\";s:15:\"section_type_id\";i:58;s:17:\"section_type_name\";s:32:\"MATTRESSES & MATTRESS PROTECTORS\";s:17:\"section_type_slug\";s:30:\"mattresses-mattress-protectors\";s:11:\"category_id\";i:486;s:13:\"category_name\";s:17:\"Crib/Cot Mattress\";s:13:\"category_slug\";s:16:\"cribcot-mattress\";}i:640;a:10:{s:26:\"master_category_section_id\";i:641;s:18:\"master_category_id\";i:9;s:20:\"master_category_name\";s:7:\"NURSERY\";s:20:\"master_category_slug\";s:7:\"nursery\";s:15:\"section_type_id\";i:58;s:17:\"section_type_name\";s:32:\"MATTRESSES & MATTRESS PROTECTORS\";s:17:\"section_type_slug\";s:30:\"mattresses-mattress-protectors\";s:11:\"category_id\";i:487;s:13:\"category_name\";s:18:\"Kid\'s Bed Mattress\";s:13:\"category_slug\";s:17:\"kids-bed-mattress\";}i:641;a:10:{s:26:\"master_category_section_id\";i:642;s:18:\"master_category_id\";i:9;s:20:\"master_category_name\";s:7:\"NURSERY\";s:20:\"master_category_slug\";s:7:\"nursery\";s:15:\"section_type_id\";i:59;s:17:\"section_type_name\";s:16:\"KIDS ROOMS DECOR\";s:17:\"section_type_slug\";s:16:\"kids-rooms-decor\";s:11:\"category_id\";i:488;s:13:\"category_name\";s:14:\"Lamps & Lights\";s:13:\"category_slug\";s:12:\"lamps-lights\";}i:642;a:10:{s:26:\"master_category_section_id\";i:643;s:18:\"master_category_id\";i:9;s:20:\"master_category_name\";s:7:\"NURSERY\";s:20:\"master_category_slug\";s:7:\"nursery\";s:15:\"section_type_id\";i:59;s:17:\"section_type_name\";s:16:\"KIDS ROOMS DECOR\";s:17:\"section_type_slug\";s:16:\"kids-rooms-decor\";s:11:\"category_id\";i:489;s:13:\"category_name\";s:26:\"Rugs, Mattresses & Carpets\";s:13:\"category_slug\";s:23:\"rugs-mattresses-carpets\";}i:643;a:10:{s:26:\"master_category_section_id\";i:644;s:18:\"master_category_id\";i:9;s:20:\"master_category_name\";s:7:\"NURSERY\";s:20:\"master_category_slug\";s:7:\"nursery\";s:15:\"section_type_id\";i:59;s:17:\"section_type_name\";s:16:\"KIDS ROOMS DECOR\";s:17:\"section_type_slug\";s:16:\"kids-rooms-decor\";s:11:\"category_id\";i:490;s:13:\"category_name\";s:15:\"Kids Floor Mats\";s:13:\"category_slug\";s:15:\"kids-floor-mats\";}i:644;a:10:{s:26:\"master_category_section_id\";i:645;s:18:\"master_category_id\";i:9;s:20:\"master_category_name\";s:7:\"NURSERY\";s:20:\"master_category_slug\";s:7:\"nursery\";s:15:\"section_type_id\";i:59;s:17:\"section_type_name\";s:16:\"KIDS ROOMS DECOR\";s:17:\"section_type_slug\";s:16:\"kids-rooms-decor\";s:11:\"category_id\";i:491;s:13:\"category_name\";s:10:\"Room Decor\";s:13:\"category_slug\";s:10:\"room-decor\";}i:645;a:10:{s:26:\"master_category_section_id\";i:646;s:18:\"master_category_id\";i:9;s:20:\"master_category_name\";s:7:\"NURSERY\";s:20:\"master_category_slug\";s:7:\"nursery\";s:15:\"section_type_id\";i:59;s:17:\"section_type_name\";s:16:\"KIDS ROOMS DECOR\";s:17:\"section_type_slug\";s:16:\"kids-rooms-decor\";s:11:\"category_id\";i:492;s:13:\"category_name\";s:22:\"Door & Window Curtains\";s:13:\"category_slug\";s:20:\"door-window-curtains\";}i:646;a:10:{s:26:\"master_category_section_id\";i:647;s:18:\"master_category_id\";i:10;s:20:\"master_category_name\";s:4:\"MOMS\";s:20:\"master_category_slug\";s:4:\"moms\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:493;s:13:\"category_name\";s:18:\"Nursing/Sleep Wear\";s:13:\"category_slug\";s:17:\"nursingsleep-wear\";}i:647;a:10:{s:26:\"master_category_section_id\";i:648;s:18:\"master_category_id\";i:10;s:20:\"master_category_name\";s:4:\"MOMS\";s:20:\"master_category_slug\";s:4:\"moms\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:494;s:13:\"category_name\";s:26:\"Maternity Dresses & Skirts\";s:13:\"category_slug\";s:24:\"maternity-dresses-skirts\";}i:648;a:10:{s:26:\"master_category_section_id\";i:649;s:18:\"master_category_id\";i:10;s:20:\"master_category_name\";s:4:\"MOMS\";s:20:\"master_category_slug\";s:4:\"moms\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:495;s:13:\"category_name\";s:18:\"Maternity Lingerie\";s:13:\"category_slug\";s:18:\"maternity-lingerie\";}i:649;a:10:{s:26:\"master_category_section_id\";i:650;s:18:\"master_category_id\";i:10;s:20:\"master_category_name\";s:4:\"MOMS\";s:20:\"master_category_slug\";s:4:\"moms\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:496;s:13:\"category_name\";s:21:\"Maternity Bottom wear\";s:13:\"category_slug\";s:21:\"maternity-bottom-wear\";}i:650;a:10:{s:26:\"master_category_section_id\";i:651;s:18:\"master_category_id\";i:10;s:20:\"master_category_name\";s:4:\"MOMS\";s:20:\"master_category_slug\";s:4:\"moms\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:497;s:13:\"category_name\";s:21:\"Maternity Ethnic Wear\";s:13:\"category_slug\";s:21:\"maternity-ethnic-wear\";}i:651;a:10:{s:26:\"master_category_section_id\";i:652;s:18:\"master_category_id\";i:10;s:20:\"master_category_name\";s:4:\"MOMS\";s:20:\"master_category_slug\";s:4:\"moms\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:498;s:13:\"category_name\";s:14:\"Maternity Tops\";s:13:\"category_slug\";s:14:\"maternity-tops\";}i:652;a:10:{s:26:\"master_category_section_id\";i:653;s:18:\"master_category_id\";i:10;s:20:\"master_category_name\";s:4:\"MOMS\";s:20:\"master_category_slug\";s:4:\"moms\";s:15:\"section_type_id\";i:60;s:17:\"section_type_name\";s:29:\"MATERNITY SUPPORT ACCESSORIES\";s:17:\"section_type_slug\";s:29:\"maternity-support-accessories\";s:11:\"category_id\";i:499;s:13:\"category_name\";s:17:\"Pregnancy Pillows\";s:13:\"category_slug\";s:17:\"pregnancy-pillows\";}i:653;a:10:{s:26:\"master_category_section_id\";i:654;s:18:\"master_category_id\";i:10;s:20:\"master_category_name\";s:4:\"MOMS\";s:20:\"master_category_slug\";s:4:\"moms\";s:15:\"section_type_id\";i:60;s:17:\"section_type_name\";s:29:\"MATERNITY SUPPORT ACCESSORIES\";s:17:\"section_type_slug\";s:29:\"maternity-support-accessories\";s:11:\"category_id\";i:500;s:13:\"category_name\";s:32:\"Corset Belts/Belly Support Belts\";s:13:\"category_slug\";s:31:\"corset-beltsbelly-support-belts\";}i:654;a:10:{s:26:\"master_category_section_id\";i:655;s:18:\"master_category_id\";i:10;s:20:\"master_category_name\";s:4:\"MOMS\";s:20:\"master_category_slug\";s:4:\"moms\";s:15:\"section_type_id\";i:60;s:17:\"section_type_name\";s:29:\"MATERNITY SUPPORT ACCESSORIES\";s:17:\"section_type_slug\";s:29:\"maternity-support-accessories\";s:11:\"category_id\";i:501;s:13:\"category_name\";s:17:\"Socks & Stockings\";s:13:\"category_slug\";s:15:\"socks-stockings\";}i:655;a:10:{s:26:\"master_category_section_id\";i:656;s:18:\"master_category_id\";i:10;s:20:\"master_category_name\";s:4:\"MOMS\";s:20:\"master_category_slug\";s:4:\"moms\";s:15:\"section_type_id\";i:61;s:17:\"section_type_name\";s:25:\"WOMEN\'S BEAUTY & CARE NEW\";s:17:\"section_type_slug\";s:22:\"womens-beauty-care-new\";s:11:\"category_id\";i:502;s:13:\"category_name\";s:18:\"Skin & Facial Care\";s:13:\"category_slug\";s:16:\"skin-facial-care\";}i:656;a:10:{s:26:\"master_category_section_id\";i:657;s:18:\"master_category_id\";i:10;s:20:\"master_category_name\";s:4:\"MOMS\";s:20:\"master_category_slug\";s:4:\"moms\";s:15:\"section_type_id\";i:61;s:17:\"section_type_name\";s:25:\"WOMEN\'S BEAUTY & CARE NEW\";s:17:\"section_type_slug\";s:22:\"womens-beauty-care-new\";s:11:\"category_id\";i:503;s:13:\"category_name\";s:9:\"Body Care\";s:13:\"category_slug\";s:9:\"body-care\";}i:657;a:10:{s:26:\"master_category_section_id\";i:658;s:18:\"master_category_id\";i:10;s:20:\"master_category_name\";s:4:\"MOMS\";s:20:\"master_category_slug\";s:4:\"moms\";s:15:\"section_type_id\";i:61;s:17:\"section_type_name\";s:25:\"WOMEN\'S BEAUTY & CARE NEW\";s:17:\"section_type_slug\";s:22:\"womens-beauty-care-new\";s:11:\"category_id\";i:504;s:13:\"category_name\";s:19:\"Hair Care & Styling\";s:13:\"category_slug\";s:17:\"hair-care-styling\";}i:658;a:10:{s:26:\"master_category_section_id\";i:659;s:18:\"master_category_id\";i:10;s:20:\"master_category_name\";s:4:\"MOMS\";s:20:\"master_category_slug\";s:4:\"moms\";s:15:\"section_type_id\";i:61;s:17:\"section_type_name\";s:25:\"WOMEN\'S BEAUTY & CARE NEW\";s:17:\"section_type_slug\";s:22:\"womens-beauty-care-new\";s:11:\"category_id\";i:505;s:13:\"category_name\";s:18:\"Hair Styling Tools\";s:13:\"category_slug\";s:18:\"hair-styling-tools\";}i:659;a:10:{s:26:\"master_category_section_id\";i:660;s:18:\"master_category_id\";i:10;s:20:\"master_category_name\";s:4:\"MOMS\";s:20:\"master_category_slug\";s:4:\"moms\";s:15:\"section_type_id\";i:61;s:17:\"section_type_name\";s:25:\"WOMEN\'S BEAUTY & CARE NEW\";s:17:\"section_type_slug\";s:22:\"womens-beauty-care-new\";s:11:\"category_id\";i:506;s:13:\"category_name\";s:18:\"Bathing Essentials\";s:13:\"category_slug\";s:18:\"bathing-essentials\";}i:660;a:10:{s:26:\"master_category_section_id\";i:661;s:18:\"master_category_id\";i:10;s:20:\"master_category_name\";s:4:\"MOMS\";s:20:\"master_category_slug\";s:4:\"moms\";s:15:\"section_type_id\";i:61;s:17:\"section_type_name\";s:25:\"WOMEN\'S BEAUTY & CARE NEW\";s:17:\"section_type_slug\";s:22:\"womens-beauty-care-new\";s:11:\"category_id\";i:507;s:13:\"category_name\";s:8:\"Eye Care\";s:13:\"category_slug\";s:8:\"eye-care\";}i:661;a:10:{s:26:\"master_category_section_id\";i:662;s:18:\"master_category_id\";i:10;s:20:\"master_category_name\";s:4:\"MOMS\";s:20:\"master_category_slug\";s:4:\"moms\";s:15:\"section_type_id\";i:61;s:17:\"section_type_name\";s:25:\"WOMEN\'S BEAUTY & CARE NEW\";s:17:\"section_type_slug\";s:22:\"womens-beauty-care-new\";s:11:\"category_id\";i:508;s:13:\"category_name\";s:8:\"Lip Care\";s:13:\"category_slug\";s:8:\"lip-care\";}i:662;a:10:{s:26:\"master_category_section_id\";i:663;s:18:\"master_category_id\";i:10;s:20:\"master_category_name\";s:4:\"MOMS\";s:20:\"master_category_slug\";s:4:\"moms\";s:15:\"section_type_id\";i:61;s:17:\"section_type_name\";s:25:\"WOMEN\'S BEAUTY & CARE NEW\";s:17:\"section_type_slug\";s:22:\"womens-beauty-care-new\";s:11:\"category_id\";i:509;s:13:\"category_name\";s:14:\"Sun Protection\";s:13:\"category_slug\";s:14:\"sun-protection\";}i:663;a:10:{s:26:\"master_category_section_id\";i:664;s:18:\"master_category_id\";i:10;s:20:\"master_category_name\";s:4:\"MOMS\";s:20:\"master_category_slug\";s:4:\"moms\";s:15:\"section_type_id\";i:61;s:17:\"section_type_name\";s:25:\"WOMEN\'S BEAUTY & CARE NEW\";s:17:\"section_type_slug\";s:22:\"womens-beauty-care-new\";s:11:\"category_id\";i:510;s:13:\"category_name\";s:17:\"Hands & Feet Care\";s:13:\"category_slug\";s:15:\"hands-feet-care\";}i:664;a:10:{s:26:\"master_category_section_id\";i:665;s:18:\"master_category_id\";i:10;s:20:\"master_category_name\";s:4:\"MOMS\";s:20:\"master_category_slug\";s:4:\"moms\";s:15:\"section_type_id\";i:61;s:17:\"section_type_name\";s:25:\"WOMEN\'S BEAUTY & CARE NEW\";s:17:\"section_type_slug\";s:22:\"womens-beauty-care-new\";s:11:\"category_id\";i:511;s:13:\"category_name\";s:23:\"Feminine Hygiene & Care\";s:13:\"category_slug\";s:21:\"feminine-hygiene-care\";}i:665;a:10:{s:26:\"master_category_section_id\";i:666;s:18:\"master_category_id\";i:10;s:20:\"master_category_name\";s:4:\"MOMS\";s:20:\"master_category_slug\";s:4:\"moms\";s:15:\"section_type_id\";i:61;s:17:\"section_type_name\";s:25:\"WOMEN\'S BEAUTY & CARE NEW\";s:17:\"section_type_slug\";s:22:\"womens-beauty-care-new\";s:11:\"category_id\";i:512;s:13:\"category_name\";s:13:\"Kits & Combos\";s:13:\"category_slug\";s:11:\"kits-combos\";}i:666;a:10:{s:26:\"master_category_section_id\";i:667;s:18:\"master_category_id\";i:10;s:20:\"master_category_name\";s:4:\"MOMS\";s:20:\"master_category_slug\";s:4:\"moms\";s:15:\"section_type_id\";i:61;s:17:\"section_type_name\";s:25:\"WOMEN\'S BEAUTY & CARE NEW\";s:17:\"section_type_slug\";s:22:\"womens-beauty-care-new\";s:11:\"category_id\";i:513;s:13:\"category_name\";s:19:\"Make up & Cosmetics\";s:13:\"category_slug\";s:17:\"make-up-cosmetics\";}i:667;a:10:{s:26:\"master_category_section_id\";i:668;s:18:\"master_category_id\";i:10;s:20:\"master_category_name\";s:4:\"MOMS\";s:20:\"master_category_slug\";s:4:\"moms\";s:15:\"section_type_id\";i:61;s:17:\"section_type_name\";s:25:\"WOMEN\'S BEAUTY & CARE NEW\";s:17:\"section_type_slug\";s:22:\"womens-beauty-care-new\";s:11:\"category_id\";i:514;s:13:\"category_name\";s:19:\"Health & Well-being\";s:13:\"category_slug\";s:17:\"health-well-being\";}i:668;a:10:{s:26:\"master_category_section_id\";i:669;s:18:\"master_category_id\";i:10;s:20:\"master_category_name\";s:4:\"MOMS\";s:20:\"master_category_slug\";s:4:\"moms\";s:15:\"section_type_id\";i:61;s:17:\"section_type_name\";s:25:\"WOMEN\'S BEAUTY & CARE NEW\";s:17:\"section_type_slug\";s:22:\"womens-beauty-care-new\";s:11:\"category_id\";i:515;s:13:\"category_name\";s:12:\"Super Savers\";s:13:\"category_slug\";s:12:\"super-savers\";}i:669;a:10:{s:26:\"master_category_section_id\";i:670;s:18:\"master_category_id\";i:10;s:20:\"master_category_name\";s:4:\"MOMS\";s:20:\"master_category_slug\";s:4:\"moms\";s:15:\"section_type_id\";i:62;s:17:\"section_type_name\";s:18:\"SHOP BY BRANDS NEW\";s:17:\"section_type_slug\";s:18:\"shop-by-brands-new\";s:11:\"category_id\";i:516;s:13:\"category_name\";s:10:\"Bella Mama\";s:13:\"category_slug\";s:10:\"bella-mama\";}i:670;a:10:{s:26:\"master_category_section_id\";i:671;s:18:\"master_category_id\";i:10;s:20:\"master_category_name\";s:4:\"MOMS\";s:20:\"master_category_slug\";s:4:\"moms\";s:15:\"section_type_id\";i:62;s:17:\"section_type_name\";s:18:\"SHOP BY BRANDS NEW\";s:17:\"section_type_slug\";s:18:\"shop-by-brands-new\";s:11:\"category_id\";i:517;s:13:\"category_name\";s:7:\"MomToBe\";s:13:\"category_slug\";s:7:\"momtobe\";}i:671;a:10:{s:26:\"master_category_section_id\";i:672;s:18:\"master_category_id\";i:10;s:20:\"master_category_name\";s:4:\"MOMS\";s:20:\"master_category_slug\";s:4:\"moms\";s:15:\"section_type_id\";i:62;s:17:\"section_type_name\";s:18:\"SHOP BY BRANDS NEW\";s:17:\"section_type_slug\";s:18:\"shop-by-brands-new\";s:11:\"category_id\";i:518;s:13:\"category_name\";s:7:\"ECOMAMA\";s:13:\"category_slug\";s:7:\"ecomama\";}i:672;a:10:{s:26:\"master_category_section_id\";i:673;s:18:\"master_category_id\";i:10;s:20:\"master_category_name\";s:4:\"MOMS\";s:20:\"master_category_slug\";s:4:\"moms\";s:15:\"section_type_id\";i:62;s:17:\"section_type_name\";s:18:\"SHOP BY BRANDS NEW\";s:17:\"section_type_slug\";s:18:\"shop-by-brands-new\";s:11:\"category_id\";i:519;s:13:\"category_name\";s:5:\"Fabme\";s:13:\"category_slug\";s:5:\"fabme\";}i:673;a:10:{s:26:\"master_category_section_id\";i:674;s:18:\"master_category_id\";i:10;s:20:\"master_category_name\";s:4:\"MOMS\";s:20:\"master_category_slug\";s:4:\"moms\";s:15:\"section_type_id\";i:62;s:17:\"section_type_name\";s:18:\"SHOP BY BRANDS NEW\";s:17:\"section_type_slug\";s:18:\"shop-by-brands-new\";s:11:\"category_id\";i:520;s:13:\"category_name\";s:8:\"Aujjessa\";s:13:\"category_slug\";s:8:\"aujjessa\";}i:674;a:10:{s:26:\"master_category_section_id\";i:675;s:18:\"master_category_id\";i:10;s:20:\"master_category_name\";s:4:\"MOMS\";s:20:\"master_category_slug\";s:4:\"moms\";s:15:\"section_type_id\";i:62;s:17:\"section_type_name\";s:18:\"SHOP BY BRANDS NEW\";s:17:\"section_type_slug\";s:18:\"shop-by-brands-new\";s:11:\"category_id\";i:521;s:13:\"category_name\";s:5:\"Kriti\";s:13:\"category_slug\";s:5:\"kriti\";}i:675;a:10:{s:26:\"master_category_section_id\";i:676;s:18:\"master_category_id\";i:10;s:20:\"master_category_name\";s:4:\"MOMS\";s:20:\"master_category_slug\";s:4:\"moms\";s:15:\"section_type_id\";i:62;s:17:\"section_type_name\";s:18:\"SHOP BY BRANDS NEW\";s:17:\"section_type_slug\";s:18:\"shop-by-brands-new\";s:11:\"category_id\";i:522;s:13:\"category_name\";s:5:\"Morph\";s:13:\"category_slug\";s:5:\"morph\";}i:676;a:10:{s:26:\"master_category_section_id\";i:677;s:18:\"master_category_id\";i:10;s:20:\"master_category_name\";s:4:\"MOMS\";s:20:\"master_category_slug\";s:4:\"moms\";s:15:\"section_type_id\";i:62;s:17:\"section_type_name\";s:18:\"SHOP BY BRANDS NEW\";s:17:\"section_type_slug\";s:18:\"shop-by-brands-new\";s:11:\"category_id\";i:523;s:13:\"category_name\";s:13:\"The Mom Store\";s:13:\"category_slug\";s:13:\"the-mom-store\";}i:677;a:10:{s:26:\"master_category_section_id\";i:678;s:18:\"master_category_id\";i:10;s:20:\"master_category_name\";s:4:\"MOMS\";s:20:\"master_category_slug\";s:4:\"moms\";s:15:\"section_type_id\";i:62;s:17:\"section_type_name\";s:18:\"SHOP BY BRANDS NEW\";s:17:\"section_type_slug\";s:18:\"shop-by-brands-new\";s:11:\"category_id\";i:524;s:13:\"category_name\";s:6:\"Zelena\";s:13:\"category_slug\";s:6:\"zelena\";}i:678;a:10:{s:26:\"master_category_section_id\";i:679;s:18:\"master_category_id\";i:10;s:20:\"master_category_name\";s:4:\"MOMS\";s:20:\"master_category_slug\";s:4:\"moms\";s:15:\"section_type_id\";i:62;s:17:\"section_type_name\";s:18:\"SHOP BY BRANDS NEW\";s:17:\"section_type_slug\";s:18:\"shop-by-brands-new\";s:11:\"category_id\";i:525;s:13:\"category_name\";s:9:\"Mine4Nine\";s:13:\"category_slug\";s:9:\"mine4nine\";}i:679;a:10:{s:26:\"master_category_section_id\";i:680;s:18:\"master_category_id\";i:10;s:20:\"master_category_name\";s:4:\"MOMS\";s:20:\"master_category_slug\";s:4:\"moms\";s:15:\"section_type_id\";i:62;s:17:\"section_type_name\";s:18:\"SHOP BY BRANDS NEW\";s:17:\"section_type_slug\";s:18:\"shop-by-brands-new\";s:11:\"category_id\";i:526;s:13:\"category_name\";s:11:\"Mometernity\";s:13:\"category_slug\";s:11:\"mometernity\";}i:680;a:10:{s:26:\"master_category_section_id\";i:681;s:18:\"master_category_id\";i:10;s:20:\"master_category_name\";s:4:\"MOMS\";s:20:\"master_category_slug\";s:4:\"moms\";s:15:\"section_type_id\";i:62;s:17:\"section_type_name\";s:18:\"SHOP BY BRANDS NEW\";s:17:\"section_type_slug\";s:18:\"shop-by-brands-new\";s:11:\"category_id\";i:527;s:13:\"category_name\";s:4:\"Nejo\";s:13:\"category_slug\";s:4:\"nejo\";}i:681;a:10:{s:26:\"master_category_section_id\";i:682;s:18:\"master_category_id\";i:10;s:20:\"master_category_name\";s:4:\"MOMS\";s:20:\"master_category_slug\";s:4:\"moms\";s:15:\"section_type_id\";i:62;s:17:\"section_type_name\";s:18:\"SHOP BY BRANDS NEW\";s:17:\"section_type_slug\";s:18:\"shop-by-brands-new\";s:11:\"category_id\";i:528;s:13:\"category_name\";s:3:\"Piu\";s:13:\"category_slug\";s:3:\"piu\";}i:682;a:10:{s:26:\"master_category_section_id\";i:683;s:18:\"master_category_id\";i:10;s:20:\"master_category_name\";s:4:\"MOMS\";s:20:\"master_category_slug\";s:4:\"moms\";s:15:\"section_type_id\";i:63;s:17:\"section_type_name\";s:23:\"MATERNITY PERSONAL CARE\";s:17:\"section_type_slug\";s:23:\"maternity-personal-care\";s:11:\"category_id\";i:529;s:13:\"category_name\";s:29:\"Anti Stretch Creams & Lotions\";s:13:\"category_slug\";s:27:\"anti-stretch-creams-lotions\";}i:683;a:10:{s:26:\"master_category_section_id\";i:684;s:18:\"master_category_id\";i:10;s:20:\"master_category_name\";s:4:\"MOMS\";s:20:\"master_category_slug\";s:4:\"moms\";s:15:\"section_type_id\";i:63;s:17:\"section_type_name\";s:23:\"MATERNITY PERSONAL CARE\";s:17:\"section_type_slug\";s:23:\"maternity-personal-care\";s:11:\"category_id\";i:530;s:13:\"category_name\";s:24:\"Breast Care Oil & Serums\";s:13:\"category_slug\";s:22:\"breast-care-oil-serums\";}i:684;a:10:{s:26:\"master_category_section_id\";i:685;s:18:\"master_category_id\";i:10;s:20:\"master_category_name\";s:4:\"MOMS\";s:20:\"master_category_slug\";s:4:\"moms\";s:15:\"section_type_id\";i:63;s:17:\"section_type_name\";s:23:\"MATERNITY PERSONAL CARE\";s:17:\"section_type_slug\";s:23:\"maternity-personal-care\";s:11:\"category_id\";i:531;s:13:\"category_name\";s:22:\"Maternity Pads & Pants\";s:13:\"category_slug\";s:20:\"maternity-pads-pants\";}i:685;a:10:{s:26:\"master_category_section_id\";i:686;s:18:\"master_category_id\";i:10;s:20:\"master_category_name\";s:4:\"MOMS\";s:20:\"master_category_slug\";s:4:\"moms\";s:15:\"section_type_id\";i:63;s:17:\"section_type_name\";s:23:\"MATERNITY PERSONAL CARE\";s:17:\"section_type_slug\";s:23:\"maternity-personal-care\";s:11:\"category_id\";i:532;s:13:\"category_name\";s:13:\"Intimate Wash\";s:13:\"category_slug\";s:13:\"intimate-wash\";}i:686;a:10:{s:26:\"master_category_section_id\";i:687;s:18:\"master_category_id\";i:10;s:20:\"master_category_name\";s:4:\"MOMS\";s:20:\"master_category_slug\";s:4:\"moms\";s:15:\"section_type_id\";i:63;s:17:\"section_type_name\";s:23:\"MATERNITY PERSONAL CARE\";s:17:\"section_type_slug\";s:23:\"maternity-personal-care\";s:11:\"category_id\";i:533;s:13:\"category_name\";s:14:\"Intimate Wipes\";s:13:\"category_slug\";s:14:\"intimate-wipes\";}i:687;a:10:{s:26:\"master_category_section_id\";i:688;s:18:\"master_category_id\";i:10;s:20:\"master_category_name\";s:4:\"MOMS\";s:20:\"master_category_slug\";s:4:\"moms\";s:15:\"section_type_id\";i:64;s:17:\"section_type_name\";s:20:\"NEW MOM\'S ESSENTIALS\";s:17:\"section_type_slug\";s:19:\"new-moms-essentials\";s:11:\"category_id\";i:287;s:13:\"category_name\";s:14:\"Breast Feeding\";s:13:\"category_slug\";s:14:\"breast-feeding\";}i:688;a:10:{s:26:\"master_category_section_id\";i:689;s:18:\"master_category_id\";i:10;s:20:\"master_category_name\";s:4:\"MOMS\";s:20:\"master_category_slug\";s:4:\"moms\";s:15:\"section_type_id\";i:64;s:17:\"section_type_name\";s:20:\"NEW MOM\'S ESSENTIALS\";s:17:\"section_type_slug\";s:19:\"new-moms-essentials\";s:11:\"category_id\";i:534;s:13:\"category_name\";s:30:\"Nutrition & Lactation Boosters\";s:13:\"category_slug\";s:28:\"nutrition-lactation-boosters\";}i:689;a:10:{s:26:\"master_category_section_id\";i:690;s:18:\"master_category_id\";i:10;s:20:\"master_category_name\";s:4:\"MOMS\";s:20:\"master_category_slug\";s:4:\"moms\";s:15:\"section_type_id\";i:64;s:17:\"section_type_name\";s:20:\"NEW MOM\'S ESSENTIALS\";s:17:\"section_type_slug\";s:19:\"new-moms-essentials\";s:11:\"category_id\";i:535;s:13:\"category_name\";s:29:\"Vitamins & Health Supplements\";s:13:\"category_slug\";s:27:\"vitamins-health-supplements\";}i:690;a:10:{s:26:\"master_category_section_id\";i:691;s:18:\"master_category_id\";i:10;s:20:\"master_category_name\";s:4:\"MOMS\";s:20:\"master_category_slug\";s:4:\"moms\";s:15:\"section_type_id\";i:64;s:17:\"section_type_name\";s:20:\"NEW MOM\'S ESSENTIALS\";s:17:\"section_type_slug\";s:19:\"new-moms-essentials\";s:11:\"category_id\";i:536;s:13:\"category_name\";s:12:\"Nursing Wear\";s:13:\"category_slug\";s:12:\"nursing-wear\";}i:691;a:10:{s:26:\"master_category_section_id\";i:692;s:18:\"master_category_id\";i:10;s:20:\"master_category_name\";s:4:\"MOMS\";s:20:\"master_category_slug\";s:4:\"moms\";s:15:\"section_type_id\";i:64;s:17:\"section_type_name\";s:20:\"NEW MOM\'S ESSENTIALS\";s:17:\"section_type_slug\";s:19:\"new-moms-essentials\";s:11:\"category_id\";i:311;s:13:\"category_name\";s:12:\"Nursing Bras\";s:13:\"category_slug\";s:12:\"nursing-bras\";}i:692;a:10:{s:26:\"master_category_section_id\";i:693;s:18:\"master_category_id\";i:10;s:20:\"master_category_name\";s:4:\"MOMS\";s:20:\"master_category_slug\";s:4:\"moms\";s:15:\"section_type_id\";i:65;s:17:\"section_type_name\";s:19:\"NEW BABY ESSENTIALS\";s:17:\"section_type_slug\";s:19:\"new-baby-essentials\";s:11:\"category_id\";i:537;s:13:\"category_name\";s:7:\"Diapers\";s:13:\"category_slug\";s:7:\"diapers\";}i:693;a:10:{s:26:\"master_category_section_id\";i:694;s:18:\"master_category_id\";i:10;s:20:\"master_category_name\";s:4:\"MOMS\";s:20:\"master_category_slug\";s:4:\"moms\";s:15:\"section_type_id\";i:65;s:17:\"section_type_name\";s:19:\"NEW BABY ESSENTIALS\";s:17:\"section_type_slug\";s:19:\"new-baby-essentials\";s:11:\"category_id\";i:538;s:13:\"category_name\";s:13:\"Cloth Nappies\";s:13:\"category_slug\";s:13:\"cloth-nappies\";}i:694;a:10:{s:26:\"master_category_section_id\";i:695;s:18:\"master_category_id\";i:10;s:20:\"master_category_name\";s:4:\"MOMS\";s:20:\"master_category_slug\";s:4:\"moms\";s:15:\"section_type_id\";i:65;s:17:\"section_type_name\";s:19:\"NEW BABY ESSENTIALS\";s:17:\"section_type_slug\";s:19:\"new-baby-essentials\";s:11:\"category_id\";i:539;s:13:\"category_name\";s:5:\"Wipes\";s:13:\"category_slug\";s:5:\"wipes\";}i:695;a:10:{s:26:\"master_category_section_id\";i:696;s:18:\"master_category_id\";i:10;s:20:\"master_category_name\";s:4:\"MOMS\";s:20:\"master_category_slug\";s:4:\"moms\";s:15:\"section_type_id\";i:65;s:17:\"section_type_name\";s:19:\"NEW BABY ESSENTIALS\";s:17:\"section_type_slug\";s:19:\"new-baby-essentials\";s:11:\"category_id\";i:540;s:13:\"category_name\";s:18:\"Diaper Rash Creams\";s:13:\"category_slug\";s:18:\"diaper-rash-creams\";}i:696;a:10:{s:26:\"master_category_section_id\";i:697;s:18:\"master_category_id\";i:10;s:20:\"master_category_name\";s:4:\"MOMS\";s:20:\"master_category_slug\";s:4:\"moms\";s:15:\"section_type_id\";i:65;s:17:\"section_type_name\";s:19:\"NEW BABY ESSENTIALS\";s:17:\"section_type_slug\";s:19:\"new-baby-essentials\";s:11:\"category_id\";i:196;s:13:\"category_name\";s:14:\"Bed Protectors\";s:13:\"category_slug\";s:14:\"bed-protectors\";}i:697;a:10:{s:26:\"master_category_section_id\";i:698;s:18:\"master_category_id\";i:10;s:20:\"master_category_name\";s:4:\"MOMS\";s:20:\"master_category_slug\";s:4:\"moms\";s:15:\"section_type_id\";i:65;s:17:\"section_type_name\";s:19:\"NEW BABY ESSENTIALS\";s:17:\"section_type_slug\";s:19:\"new-baby-essentials\";s:11:\"category_id\";i:541;s:13:\"category_name\";s:13:\"Baby Skincare\";s:13:\"category_slug\";s:13:\"baby-skincare\";}i:698;a:10:{s:26:\"master_category_section_id\";i:699;s:18:\"master_category_id\";i:10;s:20:\"master_category_name\";s:4:\"MOMS\";s:20:\"master_category_slug\";s:4:\"moms\";s:15:\"section_type_id\";i:65;s:17:\"section_type_name\";s:19:\"NEW BABY ESSENTIALS\";s:17:\"section_type_slug\";s:19:\"new-baby-essentials\";s:11:\"category_id\";i:542;s:13:\"category_name\";s:34:\"Blankets, Wrappers & Sleeping Bags\";s:13:\"category_slug\";s:31:\"blankets-wrappers-sleeping-bags\";}i:699;a:10:{s:26:\"master_category_section_id\";i:700;s:18:\"master_category_id\";i:10;s:20:\"master_category_name\";s:4:\"MOMS\";s:20:\"master_category_slug\";s:4:\"moms\";s:15:\"section_type_id\";i:65;s:17:\"section_type_name\";s:19:\"NEW BABY ESSENTIALS\";s:17:\"section_type_slug\";s:19:\"new-baby-essentials\";s:11:\"category_id\";i:231;s:13:\"category_name\";s:11:\"Diaper Bags\";s:13:\"category_slug\";s:11:\"diaper-bags\";}i:700;a:10:{s:26:\"master_category_section_id\";i:701;s:18:\"master_category_id\";i:11;s:20:\"master_category_name\";s:15:\"HEALTH & SAFETY\";s:20:\"master_category_slug\";s:13:\"health-safety\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:543;s:13:\"category_name\";s:22:\"Cleansers & Detergents\";s:13:\"category_slug\";s:20:\"cleansers-detergents\";}i:701;a:10:{s:26:\"master_category_section_id\";i:702;s:18:\"master_category_id\";i:11;s:20:\"master_category_name\";s:15:\"HEALTH & SAFETY\";s:20:\"master_category_slug\";s:13:\"health-safety\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:544;s:13:\"category_name\";s:9:\"Oral Care\";s:13:\"category_slug\";s:9:\"oral-care\";}i:702;a:10:{s:26:\"master_category_section_id\";i:703;s:18:\"master_category_id\";i:11;s:20:\"master_category_name\";s:15:\"HEALTH & SAFETY\";s:20:\"master_category_slug\";s:13:\"health-safety\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:545;s:13:\"category_name\";s:22:\"Childproofing & Safety\";s:13:\"category_slug\";s:20:\"childproofing-safety\";}i:703;a:10:{s:26:\"master_category_section_id\";i:704;s:18:\"master_category_id\";i:11;s:20:\"master_category_name\";s:15:\"HEALTH & SAFETY\";s:20:\"master_category_slug\";s:13:\"health-safety\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:546;s:13:\"category_name\";s:12:\"Medical Care\";s:13:\"category_slug\";s:12:\"medical-care\";}i:704;a:10:{s:26:\"master_category_section_id\";i:705;s:18:\"master_category_id\";i:11;s:20:\"master_category_name\";s:15:\"HEALTH & SAFETY\";s:20:\"master_category_slug\";s:13:\"health-safety\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:547;s:13:\"category_name\";s:26:\"Mosquito Repellents & Care\";s:13:\"category_slug\";s:24:\"mosquito-repellents-care\";}i:705;a:10:{s:26:\"master_category_section_id\";i:706;s:18:\"master_category_id\";i:11;s:20:\"master_category_name\";s:15:\"HEALTH & SAFETY\";s:20:\"master_category_slug\";s:13:\"health-safety\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:548;s:13:\"category_name\";s:28:\"Protection Face Masks & Gear\";s:13:\"category_slug\";s:26:\"protection-face-masks-gear\";}i:706;a:10:{s:26:\"master_category_section_id\";i:707;s:18:\"master_category_id\";i:11;s:20:\"master_category_name\";s:15:\"HEALTH & SAFETY\";s:20:\"master_category_slug\";s:13:\"health-safety\";s:15:\"section_type_id\";i:66;s:17:\"section_type_name\";s:26:\"HEALTH & SAFETY ESSENTIALS\";s:17:\"section_type_slug\";s:24:\"health-safety-essentials\";s:11:\"category_id\";i:549;s:13:\"category_name\";s:8:\"Handwash\";s:13:\"category_slug\";s:8:\"handwash\";}i:707;a:10:{s:26:\"master_category_section_id\";i:708;s:18:\"master_category_id\";i:11;s:20:\"master_category_name\";s:15:\"HEALTH & SAFETY\";s:20:\"master_category_slug\";s:13:\"health-safety\";s:15:\"section_type_id\";i:66;s:17:\"section_type_name\";s:26:\"HEALTH & SAFETY ESSENTIALS\";s:17:\"section_type_slug\";s:24:\"health-safety-essentials\";s:11:\"category_id\";i:550;s:13:\"category_name\";s:15:\"Hand Sanitizers\";s:13:\"category_slug\";s:15:\"hand-sanitizers\";}i:708;a:10:{s:26:\"master_category_section_id\";i:709;s:18:\"master_category_id\";i:11;s:20:\"master_category_name\";s:15:\"HEALTH & SAFETY\";s:20:\"master_category_slug\";s:13:\"health-safety\";s:15:\"section_type_id\";i:66;s:17:\"section_type_name\";s:26:\"HEALTH & SAFETY ESSENTIALS\";s:17:\"section_type_slug\";s:24:\"health-safety-essentials\";s:11:\"category_id\";i:551;s:13:\"category_name\";s:13:\"Disinfectants\";s:13:\"category_slug\";s:13:\"disinfectants\";}i:709;a:10:{s:26:\"master_category_section_id\";i:710;s:18:\"master_category_id\";i:11;s:20:\"master_category_name\";s:15:\"HEALTH & SAFETY\";s:20:\"master_category_slug\";s:13:\"health-safety\";s:15:\"section_type_id\";i:66;s:17:\"section_type_name\";s:26:\"HEALTH & SAFETY ESSENTIALS\";s:17:\"section_type_slug\";s:24:\"health-safety-essentials\";s:11:\"category_id\";i:552;s:13:\"category_name\";s:27:\"Air Purifiers (House & Car)\";s:13:\"category_slug\";s:23:\"air-purifiers-house-car\";}i:710;a:10:{s:26:\"master_category_section_id\";i:711;s:18:\"master_category_id\";i:11;s:20:\"master_category_name\";s:15:\"HEALTH & SAFETY\";s:20:\"master_category_slug\";s:13:\"health-safety\";s:15:\"section_type_id\";i:14;s:17:\"section_type_name\";s:10:\"TOP BRANDS\";s:17:\"section_type_slug\";s:10:\"top-brands\";s:11:\"category_id\";i:71;s:13:\"category_name\";s:7:\"Babyhug\";s:13:\"category_slug\";s:7:\"babyhug\";}i:711;a:10:{s:26:\"master_category_section_id\";i:712;s:18:\"master_category_id\";i:11;s:20:\"master_category_name\";s:15:\"HEALTH & SAFETY\";s:20:\"master_category_slug\";s:13:\"health-safety\";s:15:\"section_type_id\";i:14;s:17:\"section_type_name\";s:10:\"TOP BRANDS\";s:17:\"section_type_slug\";s:10:\"top-brands\";s:11:\"category_id\";i:359;s:13:\"category_name\";s:6:\"Chicco\";s:13:\"category_slug\";s:6:\"chicco\";}i:712;a:10:{s:26:\"master_category_section_id\";i:713;s:18:\"master_category_id\";i:11;s:20:\"master_category_name\";s:15:\"HEALTH & SAFETY\";s:20:\"master_category_slug\";s:13:\"health-safety\";s:15:\"section_type_id\";i:14;s:17:\"section_type_name\";s:10:\"TOP BRANDS\";s:17:\"section_type_slug\";s:10:\"top-brands\";s:11:\"category_id\";i:395;s:13:\"category_name\";s:10:\"Mama Earth\";s:13:\"category_slug\";s:10:\"mama-earth\";}i:713;a:10:{s:26:\"master_category_section_id\";i:714;s:18:\"master_category_id\";i:11;s:20:\"master_category_name\";s:15:\"HEALTH & SAFETY\";s:20:\"master_category_slug\";s:13:\"health-safety\";s:15:\"section_type_id\";i:14;s:17:\"section_type_name\";s:10:\"TOP BRANDS\";s:17:\"section_type_slug\";s:10:\"top-brands\";s:11:\"category_id\";i:553;s:13:\"category_name\";s:7:\"Colgate\";s:13:\"category_slug\";s:7:\"colgate\";}i:714;a:10:{s:26:\"master_category_section_id\";i:715;s:18:\"master_category_id\";i:11;s:20:\"master_category_name\";s:15:\"HEALTH & SAFETY\";s:20:\"master_category_slug\";s:13:\"health-safety\";s:15:\"section_type_id\";i:14;s:17:\"section_type_name\";s:10:\"TOP BRANDS\";s:17:\"section_type_slug\";s:10:\"top-brands\";s:11:\"category_id\";i:360;s:13:\"category_name\";s:6:\"Pigeon\";s:13:\"category_slug\";s:6:\"pigeon\";}i:715;a:10:{s:26:\"master_category_section_id\";i:716;s:18:\"master_category_id\";i:11;s:20:\"master_category_name\";s:15:\"HEALTH & SAFETY\";s:20:\"master_category_slug\";s:13:\"health-safety\";s:15:\"section_type_id\";i:14;s:17:\"section_type_name\";s:10:\"TOP BRANDS\";s:17:\"section_type_slug\";s:10:\"top-brands\";s:11:\"category_id\";i:554;s:13:\"category_name\";s:18:\"Himalayan Babycare\";s:13:\"category_slug\";s:18:\"himalayan-babycare\";}i:716;a:10:{s:26:\"master_category_section_id\";i:717;s:18:\"master_category_id\";i:11;s:20:\"master_category_name\";s:15:\"HEALTH & SAFETY\";s:20:\"master_category_slug\";s:13:\"health-safety\";s:15:\"section_type_id\";i:14;s:17:\"section_type_name\";s:10:\"TOP BRANDS\";s:17:\"section_type_slug\";s:10:\"top-brands\";s:11:\"category_id\";i:555;s:13:\"category_name\";s:6:\"Oral-B\";s:13:\"category_slug\";s:6:\"oral-b\";}i:717;a:10:{s:26:\"master_category_section_id\";i:718;s:18:\"master_category_id\";i:11;s:20:\"master_category_name\";s:15:\"HEALTH & SAFETY\";s:20:\"master_category_slug\";s:13:\"health-safety\";s:15:\"section_type_id\";i:14;s:17:\"section_type_name\";s:10:\"TOP BRANDS\";s:17:\"section_type_slug\";s:10:\"top-brands\";s:11:\"category_id\";i:556;s:13:\"category_name\";s:3:\"ZOE\";s:13:\"category_slug\";s:3:\"zoe\";}i:718;a:10:{s:26:\"master_category_section_id\";i:719;s:18:\"master_category_id\";i:11;s:20:\"master_category_name\";s:15:\"HEALTH & SAFETY\";s:20:\"master_category_slug\";s:13:\"health-safety\";s:15:\"section_type_id\";i:67;s:17:\"section_type_name\";s:12:\"MEDICAL CARE\";s:17:\"section_type_slug\";s:12:\"medical-care\";s:11:\"category_id\";i:557;s:13:\"category_name\";s:25:\"Cotton Buds, Pads & Balls\";s:13:\"category_slug\";s:22:\"cotton-buds-pads-balls\";}i:719;a:10:{s:26:\"master_category_section_id\";i:720;s:18:\"master_category_id\";i:11;s:20:\"master_category_name\";s:15:\"HEALTH & SAFETY\";s:20:\"master_category_slug\";s:13:\"health-safety\";s:15:\"section_type_id\";i:67;s:17:\"section_type_name\";s:12:\"MEDICAL CARE\";s:17:\"section_type_slug\";s:12:\"medical-care\";s:11:\"category_id\";i:558;s:13:\"category_name\";s:12:\"Thermometers\";s:13:\"category_slug\";s:12:\"thermometers\";}i:720;a:10:{s:26:\"master_category_section_id\";i:721;s:18:\"master_category_id\";i:11;s:20:\"master_category_name\";s:15:\"HEALTH & SAFETY\";s:20:\"master_category_slug\";s:13:\"health-safety\";s:15:\"section_type_id\";i:67;s:17:\"section_type_name\";s:12:\"MEDICAL CARE\";s:17:\"section_type_slug\";s:12:\"medical-care\";s:11:\"category_id\";i:559;s:13:\"category_name\";s:27:\"Nasal Aspirators & Cleaners\";s:13:\"category_slug\";s:25:\"nasal-aspirators-cleaners\";}i:721;a:10:{s:26:\"master_category_section_id\";i:722;s:18:\"master_category_id\";i:11;s:20:\"master_category_name\";s:15:\"HEALTH & SAFETY\";s:20:\"master_category_slug\";s:13:\"health-safety\";s:15:\"section_type_id\";i:67;s:17:\"section_type_name\";s:12:\"MEDICAL CARE\";s:17:\"section_type_slug\";s:12:\"medical-care\";s:11:\"category_id\";i:560;s:13:\"category_name\";s:23:\"Anti Colic Tummy RollOn\";s:13:\"category_slug\";s:23:\"anti-colic-tummy-rollon\";}i:722;a:10:{s:26:\"master_category_section_id\";i:723;s:18:\"master_category_id\";i:11;s:20:\"master_category_name\";s:15:\"HEALTH & SAFETY\";s:20:\"master_category_slug\";s:13:\"health-safety\";s:15:\"section_type_id\";i:67;s:17:\"section_type_name\";s:12:\"MEDICAL CARE\";s:17:\"section_type_slug\";s:12:\"medical-care\";s:11:\"category_id\";i:561;s:13:\"category_name\";s:34:\"Cold Relief/Nasal Balms & Inhalers\";s:13:\"category_slug\";s:31:\"cold-reliefnasal-balms-inhalers\";}i:723;a:10:{s:26:\"master_category_section_id\";i:724;s:18:\"master_category_id\";i:11;s:20:\"master_category_name\";s:15:\"HEALTH & SAFETY\";s:20:\"master_category_slug\";s:13:\"health-safety\";s:15:\"section_type_id\";i:67;s:17:\"section_type_name\";s:12:\"MEDICAL CARE\";s:17:\"section_type_slug\";s:12:\"medical-care\";s:11:\"category_id\";i:562;s:13:\"category_name\";s:17:\"Medicine Droppers\";s:13:\"category_slug\";s:17:\"medicine-droppers\";}i:724;a:10:{s:26:\"master_category_section_id\";i:725;s:18:\"master_category_id\";i:11;s:20:\"master_category_name\";s:15:\"HEALTH & SAFETY\";s:20:\"master_category_slug\";s:13:\"health-safety\";s:15:\"section_type_id\";i:67;s:17:\"section_type_name\";s:12:\"MEDICAL CARE\";s:17:\"section_type_slug\";s:12:\"medical-care\";s:11:\"category_id\";i:563;s:13:\"category_name\";s:11:\"Gripe Water\";s:13:\"category_slug\";s:11:\"gripe-water\";}i:725;a:10:{s:26:\"master_category_section_id\";i:726;s:18:\"master_category_id\";i:11;s:20:\"master_category_name\";s:15:\"HEALTH & SAFETY\";s:20:\"master_category_slug\";s:13:\"health-safety\";s:15:\"section_type_id\";i:67;s:17:\"section_type_name\";s:12:\"MEDICAL CARE\";s:17:\"section_type_slug\";s:12:\"medical-care\";s:11:\"category_id\";i:564;s:13:\"category_name\";s:26:\"Humidifiers/De-humidifiers\";s:13:\"category_slug\";s:25:\"humidifiersde-humidifiers\";}i:726;a:10:{s:26:\"master_category_section_id\";i:727;s:18:\"master_category_id\";i:11;s:20:\"master_category_name\";s:15:\"HEALTH & SAFETY\";s:20:\"master_category_slug\";s:13:\"health-safety\";s:15:\"section_type_id\";i:67;s:17:\"section_type_name\";s:12:\"MEDICAL CARE\";s:17:\"section_type_slug\";s:12:\"medical-care\";s:11:\"category_id\";i:565;s:13:\"category_name\";s:23:\"Vaporizers & Nebulizers\";s:13:\"category_slug\";s:21:\"vaporizers-nebulizers\";}i:727;a:10:{s:26:\"master_category_section_id\";i:728;s:18:\"master_category_id\";i:11;s:20:\"master_category_name\";s:15:\"HEALTH & SAFETY\";s:20:\"master_category_slug\";s:13:\"health-safety\";s:15:\"section_type_id\";i:68;s:17:\"section_type_name\";s:26:\"MOSQUITO REPELLENTS & CARE\";s:17:\"section_type_slug\";s:24:\"mosquito-repellents-care\";s:11:\"category_id\";i:566;s:13:\"category_name\";s:26:\"Mosquito After Bite Creams\";s:13:\"category_slug\";s:26:\"mosquito-after-bite-creams\";}i:728;a:10:{s:26:\"master_category_section_id\";i:729;s:18:\"master_category_id\";i:11;s:20:\"master_category_name\";s:15:\"HEALTH & SAFETY\";s:20:\"master_category_slug\";s:13:\"health-safety\";s:15:\"section_type_id\";i:68;s:17:\"section_type_name\";s:26:\"MOSQUITO REPELLENTS & CARE\";s:17:\"section_type_slug\";s:24:\"mosquito-repellents-care\";s:11:\"category_id\";i:567;s:13:\"category_name\";s:22:\"Anti Mosquito Roll-ons\";s:13:\"category_slug\";s:22:\"anti-mosquito-roll-ons\";}i:729;a:10:{s:26:\"master_category_section_id\";i:730;s:18:\"master_category_id\";i:11;s:20:\"master_category_name\";s:15:\"HEALTH & SAFETY\";s:20:\"master_category_slug\";s:13:\"health-safety\";s:15:\"section_type_id\";i:68;s:17:\"section_type_name\";s:26:\"MOSQUITO REPELLENTS & CARE\";s:17:\"section_type_slug\";s:24:\"mosquito-repellents-care\";s:11:\"category_id\";i:568;s:13:\"category_name\";s:21:\"Anti Mosquito Patches\";s:13:\"category_slug\";s:21:\"anti-mosquito-patches\";}i:730;a:10:{s:26:\"master_category_section_id\";i:731;s:18:\"master_category_id\";i:11;s:20:\"master_category_name\";s:15:\"HEALTH & SAFETY\";s:20:\"master_category_slug\";s:13:\"health-safety\";s:15:\"section_type_id\";i:68;s:17:\"section_type_name\";s:26:\"MOSQUITO REPELLENTS & CARE\";s:17:\"section_type_slug\";s:24:\"mosquito-repellents-care\";s:11:\"category_id\";i:569;s:13:\"category_name\";s:15:\"Mosquito Sprays\";s:13:\"category_slug\";s:15:\"mosquito-sprays\";}i:731;a:10:{s:26:\"master_category_section_id\";i:732;s:18:\"master_category_id\";i:11;s:20:\"master_category_name\";s:15:\"HEALTH & SAFETY\";s:20:\"master_category_slug\";s:13:\"health-safety\";s:15:\"section_type_id\";i:68;s:17:\"section_type_name\";s:26:\"MOSQUITO REPELLENTS & CARE\";s:17:\"section_type_slug\";s:24:\"mosquito-repellents-care\";s:11:\"category_id\";i:570;s:13:\"category_name\";s:32:\"Mosquito Repellant Creams & Gels\";s:13:\"category_slug\";s:30:\"mosquito-repellant-creams-gels\";}i:732;a:10:{s:26:\"master_category_section_id\";i:733;s:18:\"master_category_id\";i:11;s:20:\"master_category_name\";s:15:\"HEALTH & SAFETY\";s:20:\"master_category_slug\";s:13:\"health-safety\";s:15:\"section_type_id\";i:68;s:17:\"section_type_name\";s:26:\"MOSQUITO REPELLENTS & CARE\";s:17:\"section_type_slug\";s:24:\"mosquito-repellents-care\";s:11:\"category_id\";i:571;s:13:\"category_name\";s:26:\"Mosquito Repellant Devices\";s:13:\"category_slug\";s:26:\"mosquito-repellant-devices\";}i:733;a:10:{s:26:\"master_category_section_id\";i:734;s:18:\"master_category_id\";i:11;s:20:\"master_category_name\";s:15:\"HEALTH & SAFETY\";s:20:\"master_category_slug\";s:13:\"health-safety\";s:15:\"section_type_id\";i:68;s:17:\"section_type_name\";s:26:\"MOSQUITO REPELLENTS & CARE\";s:17:\"section_type_slug\";s:24:\"mosquito-repellents-care\";s:11:\"category_id\";i:572;s:13:\"category_name\";s:24:\"Mosquito Repellant Bands\";s:13:\"category_slug\";s:24:\"mosquito-repellant-bands\";}i:734;a:10:{s:26:\"master_category_section_id\";i:735;s:18:\"master_category_id\";i:11;s:20:\"master_category_name\";s:15:\"HEALTH & SAFETY\";s:20:\"master_category_slug\";s:13:\"health-safety\";s:15:\"section_type_id\";i:68;s:17:\"section_type_name\";s:26:\"MOSQUITO REPELLENTS & CARE\";s:17:\"section_type_slug\";s:24:\"mosquito-repellents-care\";s:11:\"category_id\";i:573;s:13:\"category_name\";s:23:\"Mosquito Repellent Oils\";s:13:\"category_slug\";s:23:\"mosquito-repellent-oils\";}i:735;a:10:{s:26:\"master_category_section_id\";i:736;s:18:\"master_category_id\";i:11;s:20:\"master_category_name\";s:15:\"HEALTH & SAFETY\";s:20:\"master_category_slug\";s:13:\"health-safety\";s:15:\"section_type_id\";i:69;s:17:\"section_type_name\";s:22:\"CLEANSERS & DETERGENTS\";s:17:\"section_type_slug\";s:20:\"cleansers-detergents\";s:11:\"category_id\";i:574;s:13:\"category_name\";s:28:\"Baby Safe Laundry Detergents\";s:13:\"category_slug\";s:28:\"baby-safe-laundry-detergents\";}i:736;a:10:{s:26:\"master_category_section_id\";i:737;s:18:\"master_category_id\";i:11;s:20:\"master_category_name\";s:15:\"HEALTH & SAFETY\";s:20:\"master_category_slug\";s:13:\"health-safety\";s:15:\"section_type_id\";i:69;s:17:\"section_type_name\";s:22:\"CLEANSERS & DETERGENTS\";s:17:\"section_type_slug\";s:20:\"cleansers-detergents\";s:11:\"category_id\";i:575;s:13:\"category_name\";s:21:\"All Purpose Cleansers\";s:13:\"category_slug\";s:21:\"all-purpose-cleansers\";}i:737;a:10:{s:26:\"master_category_section_id\";i:738;s:18:\"master_category_id\";i:11;s:20:\"master_category_name\";s:15:\"HEALTH & SAFETY\";s:20:\"master_category_slug\";s:13:\"health-safety\";s:15:\"section_type_id\";i:69;s:17:\"section_type_name\";s:22:\"CLEANSERS & DETERGENTS\";s:17:\"section_type_slug\";s:20:\"cleansers-detergents\";s:11:\"category_id\";i:576;s:13:\"category_name\";s:12:\"Toy Cleaners\";s:13:\"category_slug\";s:12:\"toy-cleaners\";}i:738;a:10:{s:26:\"master_category_section_id\";i:739;s:18:\"master_category_id\";i:11;s:20:\"master_category_name\";s:15:\"HEALTH & SAFETY\";s:20:\"master_category_slug\";s:13:\"health-safety\";s:15:\"section_type_id\";i:69;s:17:\"section_type_name\";s:22:\"CLEANSERS & DETERGENTS\";s:17:\"section_type_slug\";s:20:\"cleansers-detergents\";s:11:\"category_id\";i:577;s:13:\"category_name\";s:20:\"Vegetable/Fruit Wash\";s:13:\"category_slug\";s:19:\"vegetablefruit-wash\";}i:739;a:10:{s:26:\"master_category_section_id\";i:740;s:18:\"master_category_id\";i:11;s:20:\"master_category_name\";s:15:\"HEALTH & SAFETY\";s:20:\"master_category_slug\";s:13:\"health-safety\";s:15:\"section_type_id\";i:69;s:17:\"section_type_name\";s:22:\"CLEANSERS & DETERGENTS\";s:17:\"section_type_slug\";s:20:\"cleansers-detergents\";s:11:\"category_id\";i:578;s:13:\"category_name\";s:22:\"Bottle Cleaning Liquid\";s:13:\"category_slug\";s:22:\"bottle-cleaning-liquid\";}i:740;a:10:{s:26:\"master_category_section_id\";i:741;s:18:\"master_category_id\";i:11;s:20:\"master_category_name\";s:15:\"HEALTH & SAFETY\";s:20:\"master_category_slug\";s:13:\"health-safety\";s:15:\"section_type_id\";i:69;s:17:\"section_type_name\";s:22:\"CLEANSERS & DETERGENTS\";s:17:\"section_type_slug\";s:20:\"cleansers-detergents\";s:11:\"category_id\";i:579;s:13:\"category_name\";s:18:\"Dishwashing Liquid\";s:13:\"category_slug\";s:18:\"dishwashing-liquid\";}i:741;a:10:{s:26:\"master_category_section_id\";i:742;s:18:\"master_category_id\";i:11;s:20:\"master_category_name\";s:15:\"HEALTH & SAFETY\";s:20:\"master_category_slug\";s:13:\"health-safety\";s:15:\"section_type_id\";i:69;s:17:\"section_type_name\";s:22:\"CLEANSERS & DETERGENTS\";s:17:\"section_type_slug\";s:20:\"cleansers-detergents\";s:11:\"category_id\";i:580;s:13:\"category_name\";s:14:\"Floor Cleaners\";s:13:\"category_slug\";s:14:\"floor-cleaners\";}i:742;a:10:{s:26:\"master_category_section_id\";i:743;s:18:\"master_category_id\";i:11;s:20:\"master_category_name\";s:15:\"HEALTH & SAFETY\";s:20:\"master_category_slug\";s:13:\"health-safety\";s:15:\"section_type_id\";i:70;s:17:\"section_type_name\";s:10:\"TOOTHBRUSH\";s:17:\"section_type_slug\";s:10:\"toothbrush\";s:11:\"category_id\";i:581;s:13:\"category_name\";s:17:\"Finger Toothbrush\";s:13:\"category_slug\";s:17:\"finger-toothbrush\";}i:743;a:10:{s:26:\"master_category_section_id\";i:744;s:18:\"master_category_id\";i:11;s:20:\"master_category_name\";s:15:\"HEALTH & SAFETY\";s:20:\"master_category_slug\";s:13:\"health-safety\";s:15:\"section_type_id\";i:70;s:17:\"section_type_name\";s:10:\"TOOTHBRUSH\";s:17:\"section_type_slug\";s:10:\"toothbrush\";s:11:\"category_id\";i:582;s:13:\"category_name\";s:17:\"Manual Toothbrush\";s:13:\"category_slug\";s:17:\"manual-toothbrush\";}i:744;a:10:{s:26:\"master_category_section_id\";i:745;s:18:\"master_category_id\";i:11;s:20:\"master_category_name\";s:15:\"HEALTH & SAFETY\";s:20:\"master_category_slug\";s:13:\"health-safety\";s:15:\"section_type_id\";i:70;s:17:\"section_type_name\";s:10:\"TOOTHBRUSH\";s:17:\"section_type_slug\";s:10:\"toothbrush\";s:11:\"category_id\";i:583;s:13:\"category_name\";s:27:\"Electric/Powered Toothbrush\";s:13:\"category_slug\";s:26:\"electricpowered-toothbrush\";}i:745;a:10:{s:26:\"master_category_section_id\";i:746;s:18:\"master_category_id\";i:11;s:20:\"master_category_name\";s:15:\"HEALTH & SAFETY\";s:20:\"master_category_slug\";s:13:\"health-safety\";s:15:\"section_type_id\";i:70;s:17:\"section_type_name\";s:10:\"TOOTHBRUSH\";s:17:\"section_type_slug\";s:10:\"toothbrush\";s:11:\"category_id\";i:584;s:13:\"category_name\";s:25:\"Training & Gum Toothbrush\";s:13:\"category_slug\";s:23:\"training-gum-toothbrush\";}i:746;a:10:{s:26:\"master_category_section_id\";i:747;s:18:\"master_category_id\";i:11;s:20:\"master_category_name\";s:15:\"HEALTH & SAFETY\";s:20:\"master_category_slug\";s:13:\"health-safety\";s:15:\"section_type_id\";i:71;s:17:\"section_type_name\";s:18:\"CHILDPROOFING ESS.\";s:17:\"section_type_slug\";s:17:\"childproofing-ess\";s:11:\"category_id\";i:436;s:13:\"category_name\";s:13:\"Baby Monitors\";s:13:\"category_slug\";s:13:\"baby-monitors\";}i:747;a:10:{s:26:\"master_category_section_id\";i:748;s:18:\"master_category_id\";i:11;s:20:\"master_category_name\";s:15:\"HEALTH & SAFETY\";s:20:\"master_category_slug\";s:13:\"health-safety\";s:15:\"section_type_id\";i:71;s:17:\"section_type_name\";s:18:\"CHILDPROOFING ESS.\";s:17:\"section_type_slug\";s:17:\"childproofing-ess\";s:11:\"category_id\";i:585;s:13:\"category_name\";s:18:\"Bed Guards & Rails\";s:13:\"category_slug\";s:16:\"bed-guards-rails\";}i:748;a:10:{s:26:\"master_category_section_id\";i:749;s:18:\"master_category_id\";i:11;s:20:\"master_category_name\";s:15:\"HEALTH & SAFETY\";s:20:\"master_category_slug\";s:13:\"health-safety\";s:15:\"section_type_id\";i:71;s:17:\"section_type_name\";s:18:\"CHILDPROOFING ESS.\";s:17:\"section_type_slug\";s:17:\"childproofing-ess\";s:11:\"category_id\";i:586;s:13:\"category_name\";s:12:\"Safety Gates\";s:13:\"category_slug\";s:12:\"safety-gates\";}i:749;a:10:{s:26:\"master_category_section_id\";i:750;s:18:\"master_category_id\";i:11;s:20:\"master_category_name\";s:15:\"HEALTH & SAFETY\";s:20:\"master_category_slug\";s:13:\"health-safety\";s:15:\"section_type_id\";i:71;s:17:\"section_type_name\";s:18:\"CHILDPROOFING ESS.\";s:17:\"section_type_slug\";s:17:\"childproofing-ess\";s:11:\"category_id\";i:587;s:13:\"category_name\";s:20:\"Corner & Edge Guards\";s:13:\"category_slug\";s:18:\"corner-edge-guards\";}i:750;a:10:{s:26:\"master_category_section_id\";i:751;s:18:\"master_category_id\";i:11;s:20:\"master_category_name\";s:15:\"HEALTH & SAFETY\";s:20:\"master_category_slug\";s:13:\"health-safety\";s:15:\"section_type_id\";i:71;s:17:\"section_type_name\";s:18:\"CHILDPROOFING ESS.\";s:17:\"section_type_slug\";s:17:\"childproofing-ess\";s:11:\"category_id\";i:588;s:13:\"category_name\";s:19:\"Elbow and Knee-Pads\";s:13:\"category_slug\";s:19:\"elbow-and-knee-pads\";}i:751;a:10:{s:26:\"master_category_section_id\";i:752;s:18:\"master_category_id\";i:11;s:20:\"master_category_name\";s:15:\"HEALTH & SAFETY\";s:20:\"master_category_slug\";s:13:\"health-safety\";s:15:\"section_type_id\";i:71;s:17:\"section_type_name\";s:18:\"CHILDPROOFING ESS.\";s:17:\"section_type_slug\";s:17:\"childproofing-ess\";s:11:\"category_id\";i:589;s:13:\"category_name\";s:18:\"Child Safety Locks\";s:13:\"category_slug\";s:18:\"child-safety-locks\";}i:752;a:10:{s:26:\"master_category_section_id\";i:753;s:18:\"master_category_id\";i:11;s:20:\"master_category_name\";s:15:\"HEALTH & SAFETY\";s:20:\"master_category_slug\";s:13:\"health-safety\";s:15:\"section_type_id\";i:71;s:17:\"section_type_name\";s:18:\"CHILDPROOFING ESS.\";s:17:\"section_type_slug\";s:17:\"childproofing-ess\";s:11:\"category_id\";i:590;s:13:\"category_name\";s:22:\"Electric Socket Covers\";s:13:\"category_slug\";s:22:\"electric-socket-covers\";}i:753;a:10:{s:26:\"master_category_section_id\";i:754;s:18:\"master_category_id\";i:11;s:20:\"master_category_name\";s:15:\"HEALTH & SAFETY\";s:20:\"master_category_slug\";s:13:\"health-safety\";s:15:\"section_type_id\";i:71;s:17:\"section_type_name\";s:18:\"CHILDPROOFING ESS.\";s:17:\"section_type_slug\";s:17:\"childproofing-ess\";s:11:\"category_id\";i:591;s:13:\"category_name\";s:22:\"Door Stoppers & Guards\";s:13:\"category_slug\";s:20:\"door-stoppers-guards\";}i:754;a:10:{s:26:\"master_category_section_id\";i:755;s:18:\"master_category_id\";i:11;s:20:\"master_category_name\";s:15:\"HEALTH & SAFETY\";s:20:\"master_category_slug\";s:13:\"health-safety\";s:15:\"section_type_id\";i:71;s:17:\"section_type_name\";s:18:\"CHILDPROOFING ESS.\";s:17:\"section_type_slug\";s:17:\"childproofing-ess\";s:11:\"category_id\";i:592;s:13:\"category_name\";s:12:\"Baby Helmets\";s:13:\"category_slug\";s:12:\"baby-helmets\";}i:755;a:10:{s:26:\"master_category_section_id\";i:756;s:18:\"master_category_id\";i:11;s:20:\"master_category_name\";s:15:\"HEALTH & SAFETY\";s:20:\"master_category_slug\";s:13:\"health-safety\";s:15:\"section_type_id\";i:71;s:17:\"section_type_name\";s:18:\"CHILDPROOFING ESS.\";s:17:\"section_type_slug\";s:17:\"childproofing-ess\";s:11:\"category_id\";i:593;s:13:\"category_name\";s:20:\"Baby Head Supporters\";s:13:\"category_slug\";s:20:\"baby-head-supporters\";}i:756;a:10:{s:26:\"master_category_section_id\";i:757;s:18:\"master_category_id\";i:11;s:20:\"master_category_name\";s:15:\"HEALTH & SAFETY\";s:20:\"master_category_slug\";s:13:\"health-safety\";s:15:\"section_type_id\";i:71;s:17:\"section_type_name\";s:18:\"CHILDPROOFING ESS.\";s:17:\"section_type_slug\";s:17:\"childproofing-ess\";s:11:\"category_id\";i:594;s:13:\"category_name\";s:17:\"Kids Safety Belts\";s:13:\"category_slug\";s:17:\"kids-safety-belts\";}i:757;a:10:{s:26:\"master_category_section_id\";i:758;s:18:\"master_category_id\";i:11;s:20:\"master_category_name\";s:15:\"HEALTH & SAFETY\";s:20:\"master_category_slug\";s:13:\"health-safety\";s:15:\"section_type_id\";i:71;s:17:\"section_type_name\";s:18:\"CHILDPROOFING ESS.\";s:17:\"section_type_slug\";s:17:\"childproofing-ess\";s:11:\"category_id\";i:595;s:13:\"category_name\";s:22:\"Anti Radiation Devices\";s:13:\"category_slug\";s:22:\"anti-radiation-devices\";}i:758;a:10:{s:26:\"master_category_section_id\";i:759;s:18:\"master_category_id\";i:11;s:20:\"master_category_name\";s:15:\"HEALTH & SAFETY\";s:20:\"master_category_slug\";s:13:\"health-safety\";s:15:\"section_type_id\";i:71;s:17:\"section_type_name\";s:18:\"CHILDPROOFING ESS.\";s:17:\"section_type_slug\";s:17:\"childproofing-ess\";s:11:\"category_id\";i:596;s:13:\"category_name\";s:18:\"Anti Glare Glasses\";s:13:\"category_slug\";s:18:\"anti-glare-glasses\";}i:759;a:10:{s:26:\"master_category_section_id\";i:760;s:18:\"master_category_id\";i:11;s:20:\"master_category_name\";s:15:\"HEALTH & SAFETY\";s:20:\"master_category_slug\";s:13:\"health-safety\";s:15:\"section_type_id\";i:71;s:17:\"section_type_name\";s:18:\"CHILDPROOFING ESS.\";s:17:\"section_type_slug\";s:17:\"childproofing-ess\";s:11:\"category_id\";i:597;s:13:\"category_name\";s:22:\"Child Tracking Devices\";s:13:\"category_slug\";s:22:\"child-tracking-devices\";}i:760;a:10:{s:26:\"master_category_section_id\";i:761;s:18:\"master_category_id\";i:11;s:20:\"master_category_name\";s:15:\"HEALTH & SAFETY\";s:20:\"master_category_slug\";s:13:\"health-safety\";s:15:\"section_type_id\";i:71;s:17:\"section_type_name\";s:18:\"CHILDPROOFING ESS.\";s:17:\"section_type_slug\";s:17:\"childproofing-ess\";s:11:\"category_id\";i:552;s:13:\"category_name\";s:27:\"Air Purifiers (House & Car)\";s:13:\"category_slug\";s:23:\"air-purifiers-house-car\";}i:761;a:10:{s:26:\"master_category_section_id\";i:762;s:18:\"master_category_id\";i:11;s:20:\"master_category_name\";s:15:\"HEALTH & SAFETY\";s:20:\"master_category_slug\";s:13:\"health-safety\";s:15:\"section_type_id\";i:72;s:17:\"section_type_name\";s:9:\"ORAL CARE\";s:17:\"section_type_slug\";s:9:\"oral-care\";s:11:\"category_id\";i:598;s:13:\"category_name\";s:10:\"Toothpaste\";s:13:\"category_slug\";s:10:\"toothpaste\";}i:762;a:10:{s:26:\"master_category_section_id\";i:763;s:18:\"master_category_id\";i:11;s:20:\"master_category_name\";s:15:\"HEALTH & SAFETY\";s:20:\"master_category_slug\";s:13:\"health-safety\";s:15:\"section_type_id\";i:72;s:17:\"section_type_name\";s:9:\"ORAL CARE\";s:17:\"section_type_slug\";s:9:\"oral-care\";s:11:\"category_id\";i:599;s:13:\"category_name\";s:12:\"Toothbrushes\";s:13:\"category_slug\";s:12:\"toothbrushes\";}i:763;a:10:{s:26:\"master_category_section_id\";i:764;s:18:\"master_category_id\";i:11;s:20:\"master_category_name\";s:15:\"HEALTH & SAFETY\";s:20:\"master_category_slug\";s:13:\"health-safety\";s:15:\"section_type_id\";i:72;s:17:\"section_type_name\";s:9:\"ORAL CARE\";s:17:\"section_type_slug\";s:9:\"oral-care\";s:11:\"category_id\";i:600;s:13:\"category_name\";s:15:\"Tongue Cleaners\";s:13:\"category_slug\";s:15:\"tongue-cleaners\";}i:764;a:10:{s:26:\"master_category_section_id\";i:765;s:18:\"master_category_id\";i:11;s:20:\"master_category_name\";s:15:\"HEALTH & SAFETY\";s:20:\"master_category_slug\";s:13:\"health-safety\";s:15:\"section_type_id\";i:72;s:17:\"section_type_name\";s:9:\"ORAL CARE\";s:17:\"section_type_slug\";s:9:\"oral-care\";s:11:\"category_id\";i:601;s:13:\"category_name\";s:13:\"Oral Care Set\";s:13:\"category_slug\";s:13:\"oral-care-set\";}i:765;a:10:{s:26:\"master_category_section_id\";i:766;s:18:\"master_category_id\";i:11;s:20:\"master_category_name\";s:15:\"HEALTH & SAFETY\";s:20:\"master_category_slug\";s:13:\"health-safety\";s:15:\"section_type_id\";i:72;s:17:\"section_type_name\";s:9:\"ORAL CARE\";s:17:\"section_type_slug\";s:9:\"oral-care\";s:11:\"category_id\";i:602;s:13:\"category_name\";s:18:\"Toothbrush Holders\";s:13:\"category_slug\";s:18:\"toothbrush-holders\";}i:766;a:10:{s:26:\"master_category_section_id\";i:767;s:18:\"master_category_id\";i:12;s:20:\"master_category_name\";s:9:\"BOUTIQUES\";s:20:\"master_category_slug\";s:9:\"boutiques\";s:15:\"section_type_id\";i:73;s:17:\"section_type_name\";s:9:\"BOUTIQUES\";s:17:\"section_type_slug\";s:9:\"boutiques\";s:11:\"category_id\";i:603;s:13:\"category_name\";s:9:\"New Today\";s:13:\"category_slug\";s:9:\"new-today\";}i:767;a:10:{s:26:\"master_category_section_id\";i:768;s:18:\"master_category_id\";i:12;s:20:\"master_category_name\";s:9:\"BOUTIQUES\";s:20:\"master_category_slug\";s:9:\"boutiques\";s:15:\"section_type_id\";i:73;s:17:\"section_type_name\";s:9:\"BOUTIQUES\";s:17:\"section_type_slug\";s:9:\"boutiques\";s:11:\"category_id\";i:34;s:13:\"category_name\";s:11:\"Bestsellers\";s:13:\"category_slug\";s:11:\"bestsellers\";}i:768;a:10:{s:26:\"master_category_section_id\";i:769;s:18:\"master_category_id\";i:12;s:20:\"master_category_name\";s:9:\"BOUTIQUES\";s:20:\"master_category_slug\";s:9:\"boutiques\";s:15:\"section_type_id\";i:73;s:17:\"section_type_name\";s:9:\"BOUTIQUES\";s:17:\"section_type_slug\";s:9:\"boutiques\";s:11:\"category_id\";i:604;s:13:\"category_name\";s:8:\"Last Day\";s:13:\"category_slug\";s:8:\"last-day\";}i:769;a:10:{s:26:\"master_category_section_id\";i:770;s:18:\"master_category_id\";i:12;s:20:\"master_category_name\";s:9:\"BOUTIQUES\";s:20:\"master_category_slug\";s:9:\"boutiques\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:605;s:13:\"category_name\";s:12:\"Kids Clothes\";s:13:\"category_slug\";s:12:\"kids-clothes\";}i:770;a:10:{s:26:\"master_category_section_id\";i:771;s:18:\"master_category_id\";i:12;s:20:\"master_category_name\";s:9:\"BOUTIQUES\";s:20:\"master_category_slug\";s:9:\"boutiques\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:606;s:13:\"category_name\";s:12:\"Baby Clothes\";s:13:\"category_slug\";s:12:\"baby-clothes\";}i:771;a:10:{s:26:\"master_category_section_id\";i:772;s:18:\"master_category_id\";i:12;s:20:\"master_category_name\";s:9:\"BOUTIQUES\";s:20:\"master_category_slug\";s:9:\"boutiques\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:607;s:13:\"category_name\";s:8:\"Footwear\";s:13:\"category_slug\";s:8:\"footwear\";}i:772;a:10:{s:26:\"master_category_section_id\";i:773;s:18:\"master_category_id\";i:12;s:20:\"master_category_name\";s:9:\"BOUTIQUES\";s:20:\"master_category_slug\";s:9:\"boutiques\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:608;s:13:\"category_name\";s:11:\"Accessories\";s:13:\"category_slug\";s:11:\"accessories\";}i:773;a:10:{s:26:\"master_category_section_id\";i:774;s:18:\"master_category_id\";i:12;s:20:\"master_category_name\";s:9:\"BOUTIQUES\";s:20:\"master_category_slug\";s:9:\"boutiques\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:609;s:13:\"category_name\";s:14:\"Fine Jewellery\";s:13:\"category_slug\";s:14:\"fine-jewellery\";}i:774;a:10:{s:26:\"master_category_section_id\";i:775;s:18:\"master_category_id\";i:12;s:20:\"master_category_name\";s:9:\"BOUTIQUES\";s:20:\"master_category_slug\";s:9:\"boutiques\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:610;s:13:\"category_name\";s:4:\"Toys\";s:13:\"category_slug\";s:4:\"toys\";}i:775;a:10:{s:26:\"master_category_section_id\";i:776;s:18:\"master_category_id\";i:12;s:20:\"master_category_name\";s:9:\"BOUTIQUES\";s:20:\"master_category_slug\";s:9:\"boutiques\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:611;s:13:\"category_name\";s:9:\"Baby Gear\";s:13:\"category_slug\";s:9:\"baby-gear\";}i:776;a:10:{s:26:\"master_category_section_id\";i:777;s:18:\"master_category_id\";i:12;s:20:\"master_category_name\";s:9:\"BOUTIQUES\";s:20:\"master_category_slug\";s:9:\"boutiques\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:612;s:13:\"category_name\";s:7:\"Nursery\";s:13:\"category_slug\";s:7:\"nursery\";}i:777;a:10:{s:26:\"master_category_section_id\";i:778;s:18:\"master_category_id\";i:12;s:20:\"master_category_name\";s:9:\"BOUTIQUES\";s:20:\"master_category_slug\";s:9:\"boutiques\";s:15:\"section_type_id\";i:74;s:17:\"section_type_name\";s:25:\"INT\'L BRANDS IN BABY GEAR\";s:17:\"section_type_slug\";s:24:\"intl-brands-in-baby-gear\";s:11:\"category_id\";i:359;s:13:\"category_name\";s:6:\"Chicco\";s:13:\"category_slug\";s:6:\"chicco\";}i:778;a:10:{s:26:\"master_category_section_id\";i:779;s:18:\"master_category_id\";i:12;s:20:\"master_category_name\";s:9:\"BOUTIQUES\";s:20:\"master_category_slug\";s:9:\"boutiques\";s:15:\"section_type_id\";i:74;s:17:\"section_type_name\";s:25:\"INT\'L BRANDS IN BABY GEAR\";s:17:\"section_type_slug\";s:24:\"intl-brands-in-baby-gear\";s:11:\"category_id\";i:613;s:13:\"category_name\";s:5:\"Graco\";s:13:\"category_slug\";s:5:\"graco\";}i:779;a:10:{s:26:\"master_category_section_id\";i:780;s:18:\"master_category_id\";i:12;s:20:\"master_category_name\";s:9:\"BOUTIQUES\";s:20:\"master_category_slug\";s:9:\"boutiques\";s:15:\"section_type_id\";i:75;s:17:\"section_type_name\";s:24:\"TOP INTERNATIONAL BRANDS\";s:17:\"section_type_slug\";s:24:\"top-international-brands\";s:11:\"category_id\";i:73;s:13:\"category_name\";s:11:\"Kookie Kids\";s:13:\"category_slug\";s:11:\"kookie-kids\";}i:780;a:10:{s:26:\"master_category_section_id\";i:781;s:18:\"master_category_id\";i:12;s:20:\"master_category_name\";s:9:\"BOUTIQUES\";s:20:\"master_category_slug\";s:9:\"boutiques\";s:15:\"section_type_id\";i:75;s:17:\"section_type_name\";s:24:\"TOP INTERNATIONAL BRANDS\";s:17:\"section_type_slug\";s:24:\"top-international-brands\";s:11:\"category_id\";i:74;s:13:\"category_name\";s:8:\"Carter\'s\";s:13:\"category_slug\";s:7:\"carters\";}i:781;a:10:{s:26:\"master_category_section_id\";i:782;s:18:\"master_category_id\";i:12;s:20:\"master_category_name\";s:9:\"BOUTIQUES\";s:20:\"master_category_slug\";s:9:\"boutiques\";s:15:\"section_type_id\";i:75;s:17:\"section_type_name\";s:24:\"TOP INTERNATIONAL BRANDS\";s:17:\"section_type_slug\";s:24:\"top-international-brands\";s:11:\"category_id\";i:81;s:13:\"category_name\";s:10:\"Mark & Mia\";s:13:\"category_slug\";s:8:\"mark-mia\";}i:782;a:10:{s:26:\"master_category_section_id\";i:783;s:18:\"master_category_id\";i:12;s:20:\"master_category_name\";s:9:\"BOUTIQUES\";s:20:\"master_category_slug\";s:9:\"boutiques\";s:15:\"section_type_id\";i:75;s:17:\"section_type_name\";s:24:\"TOP INTERNATIONAL BRANDS\";s:17:\"section_type_slug\";s:24:\"top-international-brands\";s:11:\"category_id\";i:614;s:13:\"category_name\";s:5:\"GUESS\";s:13:\"category_slug\";s:5:\"guess\";}i:783;a:10:{s:26:\"master_category_section_id\";i:784;s:18:\"master_category_id\";i:12;s:20:\"master_category_name\";s:9:\"BOUTIQUES\";s:20:\"master_category_slug\";s:9:\"boutiques\";s:15:\"section_type_id\";i:75;s:17:\"section_type_name\";s:24:\"TOP INTERNATIONAL BRANDS\";s:17:\"section_type_slug\";s:24:\"top-international-brands\";s:11:\"category_id\";i:89;s:13:\"category_name\";s:3:\"UCB\";s:13:\"category_slug\";s:3:\"ucb\";}i:784;a:10:{s:26:\"master_category_section_id\";i:785;s:18:\"master_category_id\";i:12;s:20:\"master_category_name\";s:9:\"BOUTIQUES\";s:20:\"master_category_slug\";s:9:\"boutiques\";s:15:\"section_type_id\";i:75;s:17:\"section_type_name\";s:24:\"TOP INTERNATIONAL BRANDS\";s:17:\"section_type_slug\";s:24:\"top-international-brands\";s:11:\"category_id\";i:615;s:13:\"category_name\";s:12:\"US Polo Assn\";s:13:\"category_slug\";s:12:\"us-polo-assn\";}i:785;a:10:{s:26:\"master_category_section_id\";i:786;s:18:\"master_category_id\";i:12;s:20:\"master_category_name\";s:9:\"BOUTIQUES\";s:20:\"master_category_slug\";s:9:\"boutiques\";s:15:\"section_type_id\";i:75;s:17:\"section_type_name\";s:24:\"TOP INTERNATIONAL BRANDS\";s:17:\"section_type_slug\";s:24:\"top-international-brands\";s:11:\"category_id\";i:93;s:13:\"category_name\";s:4:\"Puma\";s:13:\"category_slug\";s:4:\"puma\";}i:786;a:10:{s:26:\"master_category_section_id\";i:787;s:18:\"master_category_id\";i:12;s:20:\"master_category_name\";s:9:\"BOUTIQUES\";s:20:\"master_category_slug\";s:9:\"boutiques\";s:15:\"section_type_id\";i:75;s:17:\"section_type_name\";s:24:\"TOP INTERNATIONAL BRANDS\";s:17:\"section_type_slug\";s:24:\"top-international-brands\";s:11:\"category_id\";i:97;s:13:\"category_name\";s:10:\"ASICS Kids\";s:13:\"category_slug\";s:10:\"asics-kids\";}i:787;a:10:{s:26:\"master_category_section_id\";i:788;s:18:\"master_category_id\";i:12;s:20:\"master_category_name\";s:9:\"BOUTIQUES\";s:20:\"master_category_slug\";s:9:\"boutiques\";s:15:\"section_type_id\";i:75;s:17:\"section_type_name\";s:24:\"TOP INTERNATIONAL BRANDS\";s:17:\"section_type_slug\";s:24:\"top-international-brands\";s:11:\"category_id\";i:616;s:13:\"category_name\";s:17:\"Turtledove London\";s:13:\"category_slug\";s:17:\"turtledove-london\";}i:788;a:10:{s:26:\"master_category_section_id\";i:789;s:18:\"master_category_id\";i:12;s:20:\"master_category_name\";s:9:\"BOUTIQUES\";s:20:\"master_category_slug\";s:9:\"boutiques\";s:15:\"section_type_id\";i:75;s:17:\"section_type_name\";s:24:\"TOP INTERNATIONAL BRANDS\";s:17:\"section_type_slug\";s:24:\"top-international-brands\";s:11:\"category_id\";i:95;s:13:\"category_name\";s:11:\"ADIDAS KIDS\";s:13:\"category_slug\";s:11:\"adidas-kids\";}i:789;a:10:{s:26:\"master_category_section_id\";i:790;s:18:\"master_category_id\";i:12;s:20:\"master_category_name\";s:9:\"BOUTIQUES\";s:20:\"master_category_slug\";s:9:\"boutiques\";s:15:\"section_type_id\";i:75;s:17:\"section_type_name\";s:24:\"TOP INTERNATIONAL BRANDS\";s:17:\"section_type_slug\";s:24:\"top-international-brands\";s:11:\"category_id\";i:617;s:13:\"category_name\";s:19:\"JACK & JONES JUNIOR\";s:13:\"category_slug\";s:17:\"jack-jones-junior\";}i:790;a:10:{s:26:\"master_category_section_id\";i:791;s:18:\"master_category_id\";i:12;s:20:\"master_category_name\";s:9:\"BOUTIQUES\";s:20:\"master_category_slug\";s:9:\"boutiques\";s:15:\"section_type_id\";i:75;s:17:\"section_type_name\";s:24:\"TOP INTERNATIONAL BRANDS\";s:17:\"section_type_slug\";s:24:\"top-international-brands\";s:11:\"category_id\";i:618;s:13:\"category_name\";s:9:\"iDO Italy\";s:13:\"category_slug\";s:9:\"ido-italy\";}i:791;a:10:{s:26:\"master_category_section_id\";i:792;s:18:\"master_category_id\";i:12;s:20:\"master_category_name\";s:9:\"BOUTIQUES\";s:20:\"master_category_slug\";s:9:\"boutiques\";s:15:\"section_type_id\";i:75;s:17:\"section_type_name\";s:24:\"TOP INTERNATIONAL BRANDS\";s:17:\"section_type_slug\";s:24:\"top-international-brands\";s:11:\"category_id\";i:619;s:13:\"category_name\";s:10:\"LC WAIKIKI\";s:13:\"category_slug\";s:10:\"lc-waikiki\";}i:792;a:10:{s:26:\"master_category_section_id\";i:793;s:18:\"master_category_id\";i:12;s:20:\"master_category_name\";s:9:\"BOUTIQUES\";s:20:\"master_category_slug\";s:9:\"boutiques\";s:15:\"section_type_id\";i:76;s:17:\"section_type_name\";s:22:\"TOP MOMPRENEURS BRANDS\";s:17:\"section_type_slug\";s:22:\"top-mompreneurs-brands\";s:11:\"category_id\";i:620;s:13:\"category_name\";s:11:\"Toy Balloon\";s:13:\"category_slug\";s:11:\"toy-balloon\";}i:793;a:10:{s:26:\"master_category_section_id\";i:794;s:18:\"master_category_id\";i:12;s:20:\"master_category_name\";s:9:\"BOUTIQUES\";s:20:\"master_category_slug\";s:9:\"boutiques\";s:15:\"section_type_id\";i:76;s:17:\"section_type_name\";s:22:\"TOP MOMPRENEURS BRANDS\";s:17:\"section_type_slug\";s:22:\"top-mompreneurs-brands\";s:11:\"category_id\";i:621;s:13:\"category_name\";s:11:\"Tiber Taber\";s:13:\"category_slug\";s:11:\"tiber-taber\";}i:794;a:10:{s:26:\"master_category_section_id\";i:795;s:18:\"master_category_id\";i:12;s:20:\"master_category_name\";s:9:\"BOUTIQUES\";s:20:\"master_category_slug\";s:9:\"boutiques\";s:15:\"section_type_id\";i:76;s:17:\"section_type_name\";s:22:\"TOP MOMPRENEURS BRANDS\";s:17:\"section_type_slug\";s:22:\"top-mompreneurs-brands\";s:11:\"category_id\";i:622;s:13:\"category_name\";s:9:\"Pspeaches\";s:13:\"category_slug\";s:9:\"pspeaches\";}i:795;a:10:{s:26:\"master_category_section_id\";i:796;s:18:\"master_category_id\";i:12;s:20:\"master_category_name\";s:9:\"BOUTIQUES\";s:20:\"master_category_slug\";s:9:\"boutiques\";s:15:\"section_type_id\";i:76;s:17:\"section_type_name\";s:22:\"TOP MOMPRENEURS BRANDS\";s:17:\"section_type_slug\";s:22:\"top-mompreneurs-brands\";s:11:\"category_id\";i:623;s:13:\"category_name\";s:6:\"M\'andy\";s:13:\"category_slug\";s:5:\"mandy\";}i:796;a:10:{s:26:\"master_category_section_id\";i:797;s:18:\"master_category_id\";i:12;s:20:\"master_category_name\";s:9:\"BOUTIQUES\";s:20:\"master_category_slug\";s:9:\"boutiques\";s:15:\"section_type_id\";i:76;s:17:\"section_type_name\";s:22:\"TOP MOMPRENEURS BRANDS\";s:17:\"section_type_slug\";s:22:\"top-mompreneurs-brands\";s:11:\"category_id\";i:624;s:13:\"category_name\";s:10:\"Indiurbane\";s:13:\"category_slug\";s:10:\"indiurbane\";}i:797;a:10:{s:26:\"master_category_section_id\";i:798;s:18:\"master_category_id\";i:12;s:20:\"master_category_name\";s:9:\"BOUTIQUES\";s:20:\"master_category_slug\";s:9:\"boutiques\";s:15:\"section_type_id\";i:76;s:17:\"section_type_name\";s:22:\"TOP MOMPRENEURS BRANDS\";s:17:\"section_type_slug\";s:22:\"top-mompreneurs-brands\";s:11:\"category_id\";i:625;s:13:\"category_name\";s:7:\"BownBee\";s:13:\"category_slug\";s:7:\"bownbee\";}i:798;a:10:{s:26:\"master_category_section_id\";i:799;s:18:\"master_category_id\";i:12;s:20:\"master_category_name\";s:9:\"BOUTIQUES\";s:20:\"master_category_slug\";s:9:\"boutiques\";s:15:\"section_type_id\";i:76;s:17:\"section_type_name\";s:22:\"TOP MOMPRENEURS BRANDS\";s:17:\"section_type_slug\";s:22:\"top-mompreneurs-brands\";s:11:\"category_id\";i:626;s:13:\"category_name\";s:10:\"Bella Moda\";s:13:\"category_slug\";s:10:\"bella-moda\";}i:799;a:10:{s:26:\"master_category_section_id\";i:800;s:18:\"master_category_id\";i:12;s:20:\"master_category_name\";s:9:\"BOUTIQUES\";s:20:\"master_category_slug\";s:9:\"boutiques\";s:15:\"section_type_id\";i:76;s:17:\"section_type_name\";s:22:\"TOP MOMPRENEURS BRANDS\";s:17:\"section_type_slug\";s:22:\"top-mompreneurs-brands\";s:11:\"category_id\";i:627;s:13:\"category_name\";s:16:\"Lilpicks Couture\";s:13:\"category_slug\";s:16:\"lilpicks-couture\";}i:800;a:10:{s:26:\"master_category_section_id\";i:801;s:18:\"master_category_id\";i:12;s:20:\"master_category_name\";s:9:\"BOUTIQUES\";s:20:\"master_category_slug\";s:9:\"boutiques\";s:15:\"section_type_id\";i:76;s:17:\"section_type_name\";s:22:\"TOP MOMPRENEURS BRANDS\";s:17:\"section_type_slug\";s:22:\"top-mompreneurs-brands\";s:11:\"category_id\";i:628;s:13:\"category_name\";s:8:\"Anthrilo\";s:13:\"category_slug\";s:8:\"anthrilo\";}i:801;a:10:{s:26:\"master_category_section_id\";i:802;s:18:\"master_category_id\";i:12;s:20:\"master_category_name\";s:9:\"BOUTIQUES\";s:20:\"master_category_slug\";s:9:\"boutiques\";s:15:\"section_type_id\";i:76;s:17:\"section_type_name\";s:22:\"TOP MOMPRENEURS BRANDS\";s:17:\"section_type_slug\";s:22:\"top-mompreneurs-brands\";s:11:\"category_id\";i:629;s:13:\"category_name\";s:7:\"D\'chica\";s:13:\"category_slug\";s:6:\"dchica\";}i:802;a:10:{s:26:\"master_category_section_id\";i:803;s:18:\"master_category_id\";i:12;s:20:\"master_category_name\";s:9:\"BOUTIQUES\";s:20:\"master_category_slug\";s:9:\"boutiques\";s:15:\"section_type_id\";i:77;s:17:\"section_type_name\";s:17:\"TOP INDIAN BRANDS\";s:17:\"section_type_slug\";s:17:\"top-indian-brands\";s:11:\"category_id\";i:86;s:13:\"category_name\";s:10:\"ToffyHouse\";s:13:\"category_slug\";s:10:\"toffyhouse\";}i:803;a:10:{s:26:\"master_category_section_id\";i:804;s:18:\"master_category_id\";i:12;s:20:\"master_category_name\";s:9:\"BOUTIQUES\";s:20:\"master_category_slug\";s:9:\"boutiques\";s:15:\"section_type_id\";i:77;s:17:\"section_type_name\";s:17:\"TOP INDIAN BRANDS\";s:17:\"section_type_slug\";s:17:\"top-indian-brands\";s:11:\"category_id\";i:630;s:13:\"category_name\";s:13:\"KALKI Fashion\";s:13:\"category_slug\";s:13:\"kalki-fashion\";}i:804;a:10:{s:26:\"master_category_section_id\";i:805;s:18:\"master_category_id\";i:12;s:20:\"master_category_name\";s:9:\"BOUTIQUES\";s:20:\"master_category_slug\";s:9:\"boutiques\";s:15:\"section_type_id\";i:77;s:17:\"section_type_name\";s:17:\"TOP INDIAN BRANDS\";s:17:\"section_type_slug\";s:17:\"top-indian-brands\";s:11:\"category_id\";i:631;s:13:\"category_name\";s:12:\"Dapper Dudes\";s:13:\"category_slug\";s:12:\"dapper-dudes\";}i:805;a:10:{s:26:\"master_category_section_id\";i:806;s:18:\"master_category_id\";i:12;s:20:\"master_category_name\";s:9:\"BOUTIQUES\";s:20:\"master_category_slug\";s:9:\"boutiques\";s:15:\"section_type_id\";i:77;s:17:\"section_type_name\";s:17:\"TOP INDIAN BRANDS\";s:17:\"section_type_slug\";s:17:\"top-indian-brands\";s:11:\"category_id\";i:632;s:13:\"category_name\";s:7:\"Enfance\";s:13:\"category_slug\";s:7:\"enfance\";}i:806;a:10:{s:26:\"master_category_section_id\";i:807;s:18:\"master_category_id\";i:12;s:20:\"master_category_name\";s:9:\"BOUTIQUES\";s:20:\"master_category_slug\";s:9:\"boutiques\";s:15:\"section_type_id\";i:77;s:17:\"section_type_name\";s:17:\"TOP INDIAN BRANDS\";s:17:\"section_type_slug\";s:17:\"top-indian-brands\";s:11:\"category_id\";i:633;s:13:\"category_name\";s:8:\"Rikidoos\";s:13:\"category_slug\";s:8:\"rikidoos\";}i:807;a:10:{s:26:\"master_category_section_id\";i:808;s:18:\"master_category_id\";i:12;s:20:\"master_category_name\";s:9:\"BOUTIQUES\";s:20:\"master_category_slug\";s:9:\"boutiques\";s:15:\"section_type_id\";i:77;s:17:\"section_type_name\";s:17:\"TOP INDIAN BRANDS\";s:17:\"section_type_slug\";s:17:\"top-indian-brands\";s:11:\"category_id\";i:634;s:13:\"category_name\";s:12:\"CrayonFlakes\";s:13:\"category_slug\";s:12:\"crayonflakes\";}i:808;a:10:{s:26:\"master_category_section_id\";i:809;s:18:\"master_category_id\";i:12;s:20:\"master_category_name\";s:9:\"BOUTIQUES\";s:20:\"master_category_slug\";s:9:\"boutiques\";s:15:\"section_type_id\";i:77;s:17:\"section_type_name\";s:17:\"TOP INDIAN BRANDS\";s:17:\"section_type_slug\";s:17:\"top-indian-brands\";s:11:\"category_id\";i:635;s:13:\"category_name\";s:10:\"Cutecumber\";s:13:\"category_slug\";s:10:\"cutecumber\";}i:809;a:10:{s:26:\"master_category_section_id\";i:810;s:18:\"master_category_id\";i:12;s:20:\"master_category_name\";s:9:\"BOUTIQUES\";s:20:\"master_category_slug\";s:9:\"boutiques\";s:15:\"section_type_id\";i:77;s:17:\"section_type_name\";s:17:\"TOP INDIAN BRANDS\";s:17:\"section_type_slug\";s:17:\"top-indian-brands\";s:11:\"category_id\";i:636;s:13:\"category_name\";s:9:\"Vastramay\";s:13:\"category_slug\";s:9:\"vastramay\";}i:810;a:10:{s:26:\"master_category_section_id\";i:811;s:18:\"master_category_id\";i:12;s:20:\"master_category_name\";s:9:\"BOUTIQUES\";s:20:\"master_category_slug\";s:9:\"boutiques\";s:15:\"section_type_id\";i:77;s:17:\"section_type_name\";s:17:\"TOP INDIAN BRANDS\";s:17:\"section_type_slug\";s:17:\"top-indian-brands\";s:11:\"category_id\";i:637;s:13:\"category_name\";s:9:\"Partikles\";s:13:\"category_slug\";s:9:\"partikles\";}i:811;a:10:{s:26:\"master_category_section_id\";i:812;s:18:\"master_category_id\";i:12;s:20:\"master_category_name\";s:9:\"BOUTIQUES\";s:20:\"master_category_slug\";s:9:\"boutiques\";s:15:\"section_type_id\";i:77;s:17:\"section_type_name\";s:17:\"TOP INDIAN BRANDS\";s:17:\"section_type_slug\";s:17:\"top-indian-brands\";s:11:\"category_id\";i:638;s:13:\"category_name\";s:9:\"Taffykids\";s:13:\"category_slug\";s:9:\"taffykids\";}i:812;a:10:{s:26:\"master_category_section_id\";i:813;s:18:\"master_category_id\";i:12;s:20:\"master_category_name\";s:9:\"BOUTIQUES\";s:20:\"master_category_slug\";s:9:\"boutiques\";s:15:\"section_type_id\";i:77;s:17:\"section_type_name\";s:17:\"TOP INDIAN BRANDS\";s:17:\"section_type_slug\";s:17:\"top-indian-brands\";s:11:\"category_id\";i:639;s:13:\"category_name\";s:7:\"Piccolo\";s:13:\"category_slug\";s:7:\"piccolo\";}i:813;a:10:{s:26:\"master_category_section_id\";i:814;s:18:\"master_category_id\";i:12;s:20:\"master_category_name\";s:9:\"BOUTIQUES\";s:20:\"master_category_slug\";s:9:\"boutiques\";s:15:\"section_type_id\";i:77;s:17:\"section_type_name\";s:17:\"TOP INDIAN BRANDS\";s:17:\"section_type_slug\";s:17:\"top-indian-brands\";s:11:\"category_id\";i:640;s:13:\"category_name\";s:10:\"AJ Dezines\";s:13:\"category_slug\";s:10:\"aj-dezines\";}i:814;a:10:{s:26:\"master_category_section_id\";i:815;s:18:\"master_category_id\";i:12;s:20:\"master_category_name\";s:9:\"BOUTIQUES\";s:20:\"master_category_slug\";s:9:\"boutiques\";s:15:\"section_type_id\";i:78;s:17:\"section_type_name\";s:25:\"FINE JEWELLERY BRANDS NEW\";s:17:\"section_type_slug\";s:25:\"fine-jewellery-brands-new\";s:11:\"category_id\";i:641;s:13:\"category_name\";s:14:\"Vidushi Aastha\";s:13:\"category_slug\";s:14:\"vidushi-aastha\";}i:815;a:10:{s:26:\"master_category_section_id\";i:816;s:18:\"master_category_id\";i:12;s:20:\"master_category_name\";s:9:\"BOUTIQUES\";s:20:\"master_category_slug\";s:9:\"boutiques\";s:15:\"section_type_id\";i:79;s:17:\"section_type_name\";s:24:\"DESIGNER WEAR BRANDS NEW\";s:17:\"section_type_slug\";s:24:\"designer-wear-brands-new\";s:11:\"category_id\";i:642;s:13:\"category_name\";s:11:\"BYB PREMIUM\";s:13:\"category_slug\";s:11:\"byb-premium\";}i:816;a:10:{s:26:\"master_category_section_id\";i:817;s:18:\"master_category_id\";i:12;s:20:\"master_category_name\";s:9:\"BOUTIQUES\";s:20:\"master_category_slug\";s:9:\"boutiques\";s:15:\"section_type_id\";i:79;s:17:\"section_type_name\";s:24:\"DESIGNER WEAR BRANDS NEW\";s:17:\"section_type_slug\";s:24:\"designer-wear-brands-new\";s:11:\"category_id\";i:643;s:13:\"category_name\";s:9:\"LIZ JACOB\";s:13:\"category_slug\";s:9:\"liz-jacob\";}i:817;a:10:{s:26:\"master_category_section_id\";i:818;s:18:\"master_category_id\";i:12;s:20:\"master_category_name\";s:9:\"BOUTIQUES\";s:20:\"master_category_slug\";s:9:\"boutiques\";s:15:\"section_type_id\";i:79;s:17:\"section_type_name\";s:24:\"DESIGNER WEAR BRANDS NEW\";s:17:\"section_type_slug\";s:24:\"designer-wear-brands-new\";s:11:\"category_id\";i:644;s:13:\"category_name\";s:7:\"Lagorii\";s:13:\"category_slug\";s:7:\"lagorii\";}i:818;a:10:{s:26:\"master_category_section_id\";i:819;s:18:\"master_category_id\";i:12;s:20:\"master_category_name\";s:9:\"BOUTIQUES\";s:20:\"master_category_slug\";s:9:\"boutiques\";s:15:\"section_type_id\";i:79;s:17:\"section_type_name\";s:24:\"DESIGNER WEAR BRANDS NEW\";s:17:\"section_type_slug\";s:24:\"designer-wear-brands-new\";s:11:\"category_id\";i:645;s:13:\"category_name\";s:14:\"The Tribe Kids\";s:13:\"category_slug\";s:14:\"the-tribe-kids\";}i:819;a:10:{s:26:\"master_category_section_id\";i:820;s:18:\"master_category_id\";i:12;s:20:\"master_category_name\";s:9:\"BOUTIQUES\";s:20:\"master_category_slug\";s:9:\"boutiques\";s:15:\"section_type_id\";i:79;s:17:\"section_type_name\";s:24:\"DESIGNER WEAR BRANDS NEW\";s:17:\"section_type_slug\";s:24:\"designer-wear-brands-new\";s:11:\"category_id\";i:646;s:13:\"category_name\";s:6:\"Minime\";s:13:\"category_slug\";s:6:\"minime\";}i:820;a:10:{s:26:\"master_category_section_id\";i:821;s:18:\"master_category_id\";i:12;s:20:\"master_category_name\";s:9:\"BOUTIQUES\";s:20:\"master_category_slug\";s:9:\"boutiques\";s:15:\"section_type_id\";i:79;s:17:\"section_type_name\";s:24:\"DESIGNER WEAR BRANDS NEW\";s:17:\"section_type_slug\";s:24:\"designer-wear-brands-new\";s:11:\"category_id\";i:647;s:13:\"category_name\";s:6:\"Jilmil\";s:13:\"category_slug\";s:6:\"jilmil\";}i:821;a:10:{s:26:\"master_category_section_id\";i:822;s:18:\"master_category_id\";i:12;s:20:\"master_category_name\";s:9:\"BOUTIQUES\";s:20:\"master_category_slug\";s:9:\"boutiques\";s:15:\"section_type_id\";i:79;s:17:\"section_type_name\";s:24:\"DESIGNER WEAR BRANDS NEW\";s:17:\"section_type_slug\";s:24:\"designer-wear-brands-new\";s:11:\"category_id\";i:648;s:13:\"category_name\";s:11:\"Plum Cheeks\";s:13:\"category_slug\";s:11:\"plum-cheeks\";}i:822;a:10:{s:26:\"master_category_section_id\";i:823;s:18:\"master_category_id\";i:12;s:20:\"master_category_name\";s:9:\"BOUTIQUES\";s:20:\"master_category_slug\";s:9:\"boutiques\";s:15:\"section_type_id\";i:79;s:17:\"section_type_name\";s:24:\"DESIGNER WEAR BRANDS NEW\";s:17:\"section_type_slug\";s:24:\"designer-wear-brands-new\";s:11:\"category_id\";i:649;s:13:\"category_name\";s:13:\"THE RIGHT CUT\";s:13:\"category_slug\";s:13:\"the-right-cut\";}i:823;a:10:{s:26:\"master_category_section_id\";i:824;s:18:\"master_category_id\";i:12;s:20:\"master_category_name\";s:9:\"BOUTIQUES\";s:20:\"master_category_slug\";s:9:\"boutiques\";s:15:\"section_type_id\";i:79;s:17:\"section_type_name\";s:24:\"DESIGNER WEAR BRANDS NEW\";s:17:\"section_type_slug\";s:24:\"designer-wear-brands-new\";s:11:\"category_id\";i:650;s:13:\"category_name\";s:13:\"KIRTI AGARWAL\";s:13:\"category_slug\";s:13:\"kirti-agarwal\";}i:824;a:10:{s:26:\"master_category_section_id\";i:825;s:18:\"master_category_id\";i:12;s:20:\"master_category_name\";s:9:\"BOUTIQUES\";s:20:\"master_category_slug\";s:9:\"boutiques\";s:15:\"section_type_id\";i:79;s:17:\"section_type_name\";s:24:\"DESIGNER WEAR BRANDS NEW\";s:17:\"section_type_slug\";s:24:\"designer-wear-brands-new\";s:11:\"category_id\";i:651;s:13:\"category_name\";s:11:\"Pasha India\";s:13:\"category_slug\";s:11:\"pasha-india\";}i:825;a:10:{s:26:\"master_category_section_id\";i:826;s:18:\"master_category_id\";i:12;s:20:\"master_category_name\";s:9:\"BOUTIQUES\";s:20:\"master_category_slug\";s:9:\"boutiques\";s:15:\"section_type_id\";i:79;s:17:\"section_type_name\";s:24:\"DESIGNER WEAR BRANDS NEW\";s:17:\"section_type_slug\";s:24:\"designer-wear-brands-new\";s:11:\"category_id\";i:652;s:13:\"category_name\";s:10:\"CASA NINOS\";s:13:\"category_slug\";s:10:\"casa-ninos\";}i:826;a:10:{s:26:\"master_category_section_id\";i:827;s:18:\"master_category_id\";i:12;s:20:\"master_category_name\";s:9:\"BOUTIQUES\";s:20:\"master_category_slug\";s:9:\"boutiques\";s:15:\"section_type_id\";i:79;s:17:\"section_type_name\";s:24:\"DESIGNER WEAR BRANDS NEW\";s:17:\"section_type_slug\";s:24:\"designer-wear-brands-new\";s:11:\"category_id\";i:653;s:13:\"category_name\";s:11:\"Foreverkidz\";s:13:\"category_slug\";s:11:\"foreverkidz\";}i:827;a:10:{s:26:\"master_category_section_id\";i:828;s:18:\"master_category_id\";i:12;s:20:\"master_category_name\";s:9:\"BOUTIQUES\";s:20:\"master_category_slug\";s:9:\"boutiques\";s:15:\"section_type_id\";i:79;s:17:\"section_type_name\";s:24:\"DESIGNER WEAR BRANDS NEW\";s:17:\"section_type_slug\";s:24:\"designer-wear-brands-new\";s:11:\"category_id\";i:654;s:13:\"category_name\";s:7:\"Ka Kids\";s:13:\"category_slug\";s:7:\"ka-kids\";}i:828;a:10:{s:26:\"master_category_section_id\";i:829;s:18:\"master_category_id\";i:12;s:20:\"master_category_name\";s:9:\"BOUTIQUES\";s:20:\"master_category_slug\";s:9:\"boutiques\";s:15:\"section_type_id\";i:79;s:17:\"section_type_name\";s:24:\"DESIGNER WEAR BRANDS NEW\";s:17:\"section_type_slug\";s:24:\"designer-wear-brands-new\";s:11:\"category_id\";i:655;s:13:\"category_name\";s:15:\"Bibbity Bobbity\";s:13:\"category_slug\";s:15:\"bibbity-bobbity\";}i:829;a:10:{s:26:\"master_category_section_id\";i:830;s:18:\"master_category_id\";i:12;s:20:\"master_category_name\";s:9:\"BOUTIQUES\";s:20:\"master_category_slug\";s:9:\"boutiques\";s:15:\"section_type_id\";i:79;s:17:\"section_type_name\";s:24:\"DESIGNER WEAR BRANDS NEW\";s:17:\"section_type_slug\";s:24:\"designer-wear-brands-new\";s:11:\"category_id\";i:656;s:13:\"category_name\";s:10:\"Swoon Baby\";s:13:\"category_slug\";s:10:\"swoon-baby\";}i:830;a:10:{s:26:\"master_category_section_id\";i:831;s:18:\"master_category_id\";i:12;s:20:\"master_category_name\";s:9:\"BOUTIQUES\";s:20:\"master_category_slug\";s:9:\"boutiques\";s:15:\"section_type_id\";i:79;s:17:\"section_type_name\";s:24:\"DESIGNER WEAR BRANDS NEW\";s:17:\"section_type_slug\";s:24:\"designer-wear-brands-new\";s:11:\"category_id\";i:657;s:13:\"category_name\";s:10:\"Fayon Kids\";s:13:\"category_slug\";s:10:\"fayon-kids\";}i:831;a:10:{s:26:\"master_category_section_id\";i:832;s:18:\"master_category_id\";i:13;s:20:\"master_category_name\";s:21:\"WOMEN\'S BEAUTY & CARE\";s:20:\"master_category_slug\";s:18:\"womens-beauty-care\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:502;s:13:\"category_name\";s:18:\"Skin & Facial Care\";s:13:\"category_slug\";s:16:\"skin-facial-care\";}i:832;a:10:{s:26:\"master_category_section_id\";i:833;s:18:\"master_category_id\";i:13;s:20:\"master_category_name\";s:21:\"WOMEN\'S BEAUTY & CARE\";s:20:\"master_category_slug\";s:18:\"womens-beauty-care\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:503;s:13:\"category_name\";s:9:\"Body Care\";s:13:\"category_slug\";s:9:\"body-care\";}i:833;a:10:{s:26:\"master_category_section_id\";i:834;s:18:\"master_category_id\";i:13;s:20:\"master_category_name\";s:21:\"WOMEN\'S BEAUTY & CARE\";s:20:\"master_category_slug\";s:18:\"womens-beauty-care\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:504;s:13:\"category_name\";s:19:\"Hair Care & Styling\";s:13:\"category_slug\";s:17:\"hair-care-styling\";}i:834;a:10:{s:26:\"master_category_section_id\";i:835;s:18:\"master_category_id\";i:13;s:20:\"master_category_name\";s:21:\"WOMEN\'S BEAUTY & CARE\";s:20:\"master_category_slug\";s:18:\"womens-beauty-care\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:505;s:13:\"category_name\";s:18:\"Hair Styling Tools\";s:13:\"category_slug\";s:18:\"hair-styling-tools\";}i:835;a:10:{s:26:\"master_category_section_id\";i:836;s:18:\"master_category_id\";i:13;s:20:\"master_category_name\";s:21:\"WOMEN\'S BEAUTY & CARE\";s:20:\"master_category_slug\";s:18:\"womens-beauty-care\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:506;s:13:\"category_name\";s:18:\"Bathing Essentials\";s:13:\"category_slug\";s:18:\"bathing-essentials\";}i:836;a:10:{s:26:\"master_category_section_id\";i:837;s:18:\"master_category_id\";i:13;s:20:\"master_category_name\";s:21:\"WOMEN\'S BEAUTY & CARE\";s:20:\"master_category_slug\";s:18:\"womens-beauty-care\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:507;s:13:\"category_name\";s:8:\"Eye Care\";s:13:\"category_slug\";s:8:\"eye-care\";}i:837;a:10:{s:26:\"master_category_section_id\";i:838;s:18:\"master_category_id\";i:13;s:20:\"master_category_name\";s:21:\"WOMEN\'S BEAUTY & CARE\";s:20:\"master_category_slug\";s:18:\"womens-beauty-care\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:508;s:13:\"category_name\";s:8:\"Lip Care\";s:13:\"category_slug\";s:8:\"lip-care\";}i:838;a:10:{s:26:\"master_category_section_id\";i:839;s:18:\"master_category_id\";i:13;s:20:\"master_category_name\";s:21:\"WOMEN\'S BEAUTY & CARE\";s:20:\"master_category_slug\";s:18:\"womens-beauty-care\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:509;s:13:\"category_name\";s:14:\"Sun Protection\";s:13:\"category_slug\";s:14:\"sun-protection\";}i:839;a:10:{s:26:\"master_category_section_id\";i:840;s:18:\"master_category_id\";i:13;s:20:\"master_category_name\";s:21:\"WOMEN\'S BEAUTY & CARE\";s:20:\"master_category_slug\";s:18:\"womens-beauty-care\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:510;s:13:\"category_name\";s:17:\"Hands & Feet Care\";s:13:\"category_slug\";s:15:\"hands-feet-care\";}i:840;a:10:{s:26:\"master_category_section_id\";i:841;s:18:\"master_category_id\";i:13;s:20:\"master_category_name\";s:21:\"WOMEN\'S BEAUTY & CARE\";s:20:\"master_category_slug\";s:18:\"womens-beauty-care\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:511;s:13:\"category_name\";s:23:\"Feminine Hygiene & Care\";s:13:\"category_slug\";s:21:\"feminine-hygiene-care\";}i:841;a:10:{s:26:\"master_category_section_id\";i:842;s:18:\"master_category_id\";i:13;s:20:\"master_category_name\";s:21:\"WOMEN\'S BEAUTY & CARE\";s:20:\"master_category_slug\";s:18:\"womens-beauty-care\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:512;s:13:\"category_name\";s:13:\"Kits & Combos\";s:13:\"category_slug\";s:11:\"kits-combos\";}i:842;a:10:{s:26:\"master_category_section_id\";i:843;s:18:\"master_category_id\";i:13;s:20:\"master_category_name\";s:21:\"WOMEN\'S BEAUTY & CARE\";s:20:\"master_category_slug\";s:18:\"womens-beauty-care\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:513;s:13:\"category_name\";s:19:\"Make up & Cosmetics\";s:13:\"category_slug\";s:17:\"make-up-cosmetics\";}i:843;a:10:{s:26:\"master_category_section_id\";i:844;s:18:\"master_category_id\";i:13;s:20:\"master_category_name\";s:21:\"WOMEN\'S BEAUTY & CARE\";s:20:\"master_category_slug\";s:18:\"womens-beauty-care\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:514;s:13:\"category_name\";s:19:\"Health & Well-being\";s:13:\"category_slug\";s:17:\"health-well-being\";}i:844;a:10:{s:26:\"master_category_section_id\";i:845;s:18:\"master_category_id\";i:13;s:20:\"master_category_name\";s:21:\"WOMEN\'S BEAUTY & CARE\";s:20:\"master_category_slug\";s:18:\"womens-beauty-care\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:658;s:13:\"category_name\";s:15:\"Maternity Store\";s:13:\"category_slug\";s:15:\"maternity-store\";}i:845;a:10:{s:26:\"master_category_section_id\";i:846;s:18:\"master_category_id\";i:13;s:20:\"master_category_name\";s:21:\"WOMEN\'S BEAUTY & CARE\";s:20:\"master_category_slug\";s:18:\"womens-beauty-care\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:659;s:13:\"category_name\";s:10:\"Baby Store\";s:13:\"category_slug\";s:10:\"baby-store\";}i:846;a:10:{s:26:\"master_category_section_id\";i:847;s:18:\"master_category_id\";i:13;s:20:\"master_category_name\";s:21:\"WOMEN\'S BEAUTY & CARE\";s:20:\"master_category_slug\";s:18:\"womens-beauty-care\";s:15:\"section_type_id\";i:47;s:17:\"section_type_name\";s:18:\"BATHING ESSENTIALS\";s:17:\"section_type_slug\";s:18:\"bathing-essentials\";s:11:\"category_id\";i:660;s:13:\"category_name\";s:20:\"Body Wash/Shower Gel\";s:13:\"category_slug\";s:19:\"body-washshower-gel\";}i:847;a:10:{s:26:\"master_category_section_id\";i:848;s:18:\"master_category_id\";i:13;s:20:\"master_category_name\";s:21:\"WOMEN\'S BEAUTY & CARE\";s:20:\"master_category_slug\";s:18:\"womens-beauty-care\";s:15:\"section_type_id\";i:47;s:17:\"section_type_name\";s:18:\"BATHING ESSENTIALS\";s:17:\"section_type_slug\";s:18:\"bathing-essentials\";s:11:\"category_id\";i:661;s:13:\"category_name\";s:13:\"Bathing Soaps\";s:13:\"category_slug\";s:13:\"bathing-soaps\";}i:848;a:10:{s:26:\"master_category_section_id\";i:849;s:18:\"master_category_id\";i:13;s:20:\"master_category_name\";s:21:\"WOMEN\'S BEAUTY & CARE\";s:20:\"master_category_slug\";s:18:\"womens-beauty-care\";s:15:\"section_type_id\";i:47;s:17:\"section_type_name\";s:18:\"BATHING ESSENTIALS\";s:17:\"section_type_slug\";s:18:\"bathing-essentials\";s:11:\"category_id\";i:662;s:13:\"category_name\";s:19:\"Bath Salts & Scrubs\";s:13:\"category_slug\";s:17:\"bath-salts-scrubs\";}i:849;a:10:{s:26:\"master_category_section_id\";i:850;s:18:\"master_category_id\";i:13;s:20:\"master_category_name\";s:21:\"WOMEN\'S BEAUTY & CARE\";s:20:\"master_category_slug\";s:18:\"womens-beauty-care\";s:15:\"section_type_id\";i:80;s:17:\"section_type_name\";s:18:\"SKIN & FACIAL CARE\";s:17:\"section_type_slug\";s:16:\"skin-facial-care\";s:11:\"category_id\";i:387;s:13:\"category_name\";s:9:\"Face Wash\";s:13:\"category_slug\";s:9:\"face-wash\";}i:850;a:10:{s:26:\"master_category_section_id\";i:851;s:18:\"master_category_id\";i:13;s:20:\"master_category_name\";s:21:\"WOMEN\'S BEAUTY & CARE\";s:20:\"master_category_slug\";s:18:\"womens-beauty-care\";s:15:\"section_type_id\";i:80;s:17:\"section_type_name\";s:18:\"SKIN & FACIAL CARE\";s:17:\"section_type_slug\";s:16:\"skin-facial-care\";s:11:\"category_id\";i:663;s:13:\"category_name\";s:25:\"Moisturizers & Day Creams\";s:13:\"category_slug\";s:23:\"moisturizers-day-creams\";}i:851;a:10:{s:26:\"master_category_section_id\";i:852;s:18:\"master_category_id\";i:13;s:20:\"master_category_name\";s:21:\"WOMEN\'S BEAUTY & CARE\";s:20:\"master_category_slug\";s:18:\"womens-beauty-care\";s:15:\"section_type_id\";i:80;s:17:\"section_type_name\";s:18:\"SKIN & FACIAL CARE\";s:17:\"section_type_slug\";s:16:\"skin-facial-care\";s:11:\"category_id\";i:664;s:13:\"category_name\";s:11:\"Face Serums\";s:13:\"category_slug\";s:11:\"face-serums\";}i:852;a:10:{s:26:\"master_category_section_id\";i:853;s:18:\"master_category_id\";i:13;s:20:\"master_category_name\";s:21:\"WOMEN\'S BEAUTY & CARE\";s:20:\"master_category_slug\";s:18:\"womens-beauty-care\";s:15:\"section_type_id\";i:80;s:17:\"section_type_name\";s:18:\"SKIN & FACIAL CARE\";s:17:\"section_type_slug\";s:16:\"skin-facial-care\";s:11:\"category_id\";i:665;s:13:\"category_name\";s:17:\"Face masks/sheets\";s:13:\"category_slug\";s:16:\"face-maskssheets\";}i:853;a:10:{s:26:\"master_category_section_id\";i:854;s:18:\"master_category_id\";i:13;s:20:\"master_category_name\";s:21:\"WOMEN\'S BEAUTY & CARE\";s:20:\"master_category_slug\";s:18:\"womens-beauty-care\";s:15:\"section_type_id\";i:80;s:17:\"section_type_name\";s:18:\"SKIN & FACIAL CARE\";s:17:\"section_type_slug\";s:16:\"skin-facial-care\";s:11:\"category_id\";i:666;s:13:\"category_name\";s:9:\"Cleansers\";s:13:\"category_slug\";s:9:\"cleansers\";}i:854;a:10:{s:26:\"master_category_section_id\";i:855;s:18:\"master_category_id\";i:13;s:20:\"master_category_name\";s:21:\"WOMEN\'S BEAUTY & CARE\";s:20:\"master_category_slug\";s:18:\"womens-beauty-care\";s:15:\"section_type_id\";i:80;s:17:\"section_type_name\";s:18:\"SKIN & FACIAL CARE\";s:17:\"section_type_slug\";s:16:\"skin-facial-care\";s:11:\"category_id\";i:667;s:13:\"category_name\";s:6:\"Toners\";s:13:\"category_slug\";s:6:\"toners\";}i:855;a:10:{s:26:\"master_category_section_id\";i:856;s:18:\"master_category_id\";i:13;s:20:\"master_category_name\";s:21:\"WOMEN\'S BEAUTY & CARE\";s:20:\"master_category_slug\";s:18:\"womens-beauty-care\";s:15:\"section_type_id\";i:80;s:17:\"section_type_name\";s:18:\"SKIN & FACIAL CARE\";s:17:\"section_type_slug\";s:16:\"skin-facial-care\";s:11:\"category_id\";i:668;s:13:\"category_name\";s:11:\"Night Cream\";s:13:\"category_slug\";s:11:\"night-cream\";}i:856;a:10:{s:26:\"master_category_section_id\";i:857;s:18:\"master_category_id\";i:13;s:20:\"master_category_name\";s:21:\"WOMEN\'S BEAUTY & CARE\";s:20:\"master_category_slug\";s:18:\"womens-beauty-care\";s:15:\"section_type_id\";i:80;s:17:\"section_type_name\";s:18:\"SKIN & FACIAL CARE\";s:17:\"section_type_slug\";s:16:\"skin-facial-care\";s:11:\"category_id\";i:669;s:13:\"category_name\";s:25:\"Face Scrubs & Exfoliators\";s:13:\"category_slug\";s:23:\"face-scrubs-exfoliators\";}i:857;a:10:{s:26:\"master_category_section_id\";i:858;s:18:\"master_category_id\";i:13;s:20:\"master_category_name\";s:21:\"WOMEN\'S BEAUTY & CARE\";s:20:\"master_category_slug\";s:18:\"womens-beauty-care\";s:15:\"section_type_id\";i:80;s:17:\"section_type_name\";s:18:\"SKIN & FACIAL CARE\";s:17:\"section_type_slug\";s:16:\"skin-facial-care\";s:11:\"category_id\";i:670;s:13:\"category_name\";s:12:\"Facial Spray\";s:13:\"category_slug\";s:12:\"facial-spray\";}i:858;a:10:{s:26:\"master_category_section_id\";i:859;s:18:\"master_category_id\";i:13;s:20:\"master_category_name\";s:21:\"WOMEN\'S BEAUTY & CARE\";s:20:\"master_category_slug\";s:18:\"womens-beauty-care\";s:15:\"section_type_id\";i:80;s:17:\"section_type_name\";s:18:\"SKIN & FACIAL CARE\";s:17:\"section_type_slug\";s:16:\"skin-facial-care\";s:11:\"category_id\";i:671;s:13:\"category_name\";s:9:\"Face Oils\";s:13:\"category_slug\";s:9:\"face-oils\";}i:859;a:10:{s:26:\"master_category_section_id\";i:860;s:18:\"master_category_id\";i:13;s:20:\"master_category_name\";s:21:\"WOMEN\'S BEAUTY & CARE\";s:20:\"master_category_slug\";s:18:\"womens-beauty-care\";s:15:\"section_type_id\";i:80;s:17:\"section_type_name\";s:18:\"SKIN & FACIAL CARE\";s:17:\"section_type_slug\";s:16:\"skin-facial-care\";s:11:\"category_id\";i:672;s:13:\"category_name\";s:19:\"Rollers & Massagers\";s:13:\"category_slug\";s:17:\"rollers-massagers\";}i:860;a:10:{s:26:\"master_category_section_id\";i:861;s:18:\"master_category_id\";i:13;s:20:\"master_category_name\";s:21:\"WOMEN\'S BEAUTY & CARE\";s:20:\"master_category_slug\";s:18:\"womens-beauty-care\";s:15:\"section_type_id\";i:80;s:17:\"section_type_name\";s:18:\"SKIN & FACIAL CARE\";s:17:\"section_type_slug\";s:16:\"skin-facial-care\";s:11:\"category_id\";i:673;s:13:\"category_name\";s:14:\"Massage Creams\";s:13:\"category_slug\";s:14:\"massage-creams\";}i:861;a:10:{s:26:\"master_category_section_id\";i:862;s:18:\"master_category_id\";i:13;s:20:\"master_category_name\";s:21:\"WOMEN\'S BEAUTY & CARE\";s:20:\"master_category_slug\";s:18:\"womens-beauty-care\";s:15:\"section_type_id\";i:81;s:17:\"section_type_name\";s:9:\"BODY CARE\";s:17:\"section_type_slug\";s:9:\"body-care\";s:11:\"category_id\";i:674;s:13:\"category_name\";s:26:\"Stretch Mark Creams & Oils\";s:13:\"category_slug\";s:24:\"stretch-mark-creams-oils\";}i:862;a:10:{s:26:\"master_category_section_id\";i:863;s:18:\"master_category_id\";i:13;s:20:\"master_category_name\";s:21:\"WOMEN\'S BEAUTY & CARE\";s:20:\"master_category_slug\";s:18:\"womens-beauty-care\";s:15:\"section_type_id\";i:81;s:17:\"section_type_name\";s:9:\"BODY CARE\";s:17:\"section_type_slug\";s:9:\"body-care\";s:11:\"category_id\";i:675;s:13:\"category_name\";s:12:\"Body Lotions\";s:13:\"category_slug\";s:12:\"body-lotions\";}i:863;a:10:{s:26:\"master_category_section_id\";i:864;s:18:\"master_category_id\";i:13;s:20:\"master_category_name\";s:21:\"WOMEN\'S BEAUTY & CARE\";s:20:\"master_category_slug\";s:18:\"womens-beauty-care\";s:15:\"section_type_id\";i:81;s:17:\"section_type_name\";s:9:\"BODY CARE\";s:17:\"section_type_slug\";s:9:\"body-care\";s:11:\"category_id\";i:676;s:13:\"category_name\";s:25:\"Body Cream & Moisturisers\";s:13:\"category_slug\";s:23:\"body-cream-moisturisers\";}i:864;a:10:{s:26:\"master_category_section_id\";i:865;s:18:\"master_category_id\";i:13;s:20:\"master_category_name\";s:21:\"WOMEN\'S BEAUTY & CARE\";s:20:\"master_category_slug\";s:18:\"womens-beauty-care\";s:15:\"section_type_id\";i:81;s:17:\"section_type_name\";s:9:\"BODY CARE\";s:17:\"section_type_slug\";s:9:\"body-care\";s:11:\"category_id\";i:677;s:13:\"category_name\";s:24:\"Massage & Essential Oils\";s:13:\"category_slug\";s:22:\"massage-essential-oils\";}i:865;a:10:{s:26:\"master_category_section_id\";i:866;s:18:\"master_category_id\";i:13;s:20:\"master_category_name\";s:21:\"WOMEN\'S BEAUTY & CARE\";s:20:\"master_category_slug\";s:18:\"womens-beauty-care\";s:15:\"section_type_id\";i:81;s:17:\"section_type_name\";s:9:\"BODY CARE\";s:17:\"section_type_slug\";s:9:\"body-care\";s:11:\"category_id\";i:678;s:13:\"category_name\";s:11:\"Body Butter\";s:13:\"category_slug\";s:11:\"body-butter\";}i:866;a:10:{s:26:\"master_category_section_id\";i:867;s:18:\"master_category_id\";i:13;s:20:\"master_category_name\";s:21:\"WOMEN\'S BEAUTY & CARE\";s:20:\"master_category_slug\";s:18:\"womens-beauty-care\";s:15:\"section_type_id\";i:81;s:17:\"section_type_name\";s:9:\"BODY CARE\";s:17:\"section_type_slug\";s:9:\"body-care\";s:11:\"category_id\";i:679;s:13:\"category_name\";s:11:\"Body Scrubs\";s:13:\"category_slug\";s:11:\"body-scrubs\";}i:867;a:10:{s:26:\"master_category_section_id\";i:868;s:18:\"master_category_id\";i:13;s:20:\"master_category_name\";s:21:\"WOMEN\'S BEAUTY & CARE\";s:20:\"master_category_slug\";s:18:\"womens-beauty-care\";s:15:\"section_type_id\";i:81;s:17:\"section_type_name\";s:9:\"BODY CARE\";s:17:\"section_type_slug\";s:9:\"body-care\";s:11:\"category_id\";i:680;s:13:\"category_name\";s:18:\"Body Shaping Cream\";s:13:\"category_slug\";s:18:\"body-shaping-cream\";}i:868;a:10:{s:26:\"master_category_section_id\";i:869;s:18:\"master_category_id\";i:13;s:20:\"master_category_name\";s:21:\"WOMEN\'S BEAUTY & CARE\";s:20:\"master_category_slug\";s:18:\"womens-beauty-care\";s:15:\"section_type_id\";i:82;s:17:\"section_type_name\";s:15:\"MATERNITY STORE\";s:17:\"section_type_slug\";s:15:\"maternity-store\";s:11:\"category_id\";i:681;s:13:\"category_name\";s:23:\"Stretch Marks Solutions\";s:13:\"category_slug\";s:23:\"stretch-marks-solutions\";}i:869;a:10:{s:26:\"master_category_section_id\";i:870;s:18:\"master_category_id\";i:13;s:20:\"master_category_name\";s:21:\"WOMEN\'S BEAUTY & CARE\";s:20:\"master_category_slug\";s:18:\"womens-beauty-care\";s:15:\"section_type_id\";i:82;s:17:\"section_type_name\";s:15:\"MATERNITY STORE\";s:17:\"section_type_slug\";s:15:\"maternity-store\";s:11:\"category_id\";i:682;s:13:\"category_name\";s:22:\"Nipple Balms & Butters\";s:13:\"category_slug\";s:20:\"nipple-balms-butters\";}i:870;a:10:{s:26:\"master_category_section_id\";i:871;s:18:\"master_category_id\";i:13;s:20:\"master_category_name\";s:21:\"WOMEN\'S BEAUTY & CARE\";s:20:\"master_category_slug\";s:18:\"womens-beauty-care\";s:15:\"section_type_id\";i:82;s:17:\"section_type_name\";s:15:\"MATERNITY STORE\";s:17:\"section_type_slug\";s:15:\"maternity-store\";s:11:\"category_id\";i:683;s:13:\"category_name\";s:25:\"Breast Care Oils & Serums\";s:13:\"category_slug\";s:23:\"breast-care-oils-serums\";}i:871;a:10:{s:26:\"master_category_section_id\";i:872;s:18:\"master_category_id\";i:13;s:20:\"master_category_name\";s:21:\"WOMEN\'S BEAUTY & CARE\";s:20:\"master_category_slug\";s:18:\"womens-beauty-care\";s:15:\"section_type_id\";i:82;s:17:\"section_type_name\";s:15:\"MATERNITY STORE\";s:17:\"section_type_slug\";s:15:\"maternity-store\";s:11:\"category_id\";i:531;s:13:\"category_name\";s:22:\"Maternity Pads & Pants\";s:13:\"category_slug\";s:20:\"maternity-pads-pants\";}i:872;a:10:{s:26:\"master_category_section_id\";i:873;s:18:\"master_category_id\";i:13;s:20:\"master_category_name\";s:21:\"WOMEN\'S BEAUTY & CARE\";s:20:\"master_category_slug\";s:18:\"womens-beauty-care\";s:15:\"section_type_id\";i:82;s:17:\"section_type_name\";s:15:\"MATERNITY STORE\";s:17:\"section_type_slug\";s:15:\"maternity-store\";s:11:\"category_id\";i:684;s:13:\"category_name\";s:19:\"Belly Support Belts\";s:13:\"category_slug\";s:19:\"belly-support-belts\";}i:873;a:10:{s:26:\"master_category_section_id\";i:874;s:18:\"master_category_id\";i:13;s:20:\"master_category_name\";s:21:\"WOMEN\'S BEAUTY & CARE\";s:20:\"master_category_slug\";s:18:\"womens-beauty-care\";s:15:\"section_type_id\";i:82;s:17:\"section_type_name\";s:15:\"MATERNITY STORE\";s:17:\"section_type_slug\";s:15:\"maternity-store\";s:11:\"category_id\";i:499;s:13:\"category_name\";s:17:\"Pregnancy Pillows\";s:13:\"category_slug\";s:17:\"pregnancy-pillows\";}i:874;a:10:{s:26:\"master_category_section_id\";i:875;s:18:\"master_category_id\";i:13;s:20:\"master_category_name\";s:21:\"WOMEN\'S BEAUTY & CARE\";s:20:\"master_category_slug\";s:18:\"womens-beauty-care\";s:15:\"section_type_id\";i:82;s:17:\"section_type_name\";s:15:\"MATERNITY STORE\";s:17:\"section_type_slug\";s:15:\"maternity-store\";s:11:\"category_id\";i:685;s:13:\"category_name\";s:14:\"Maternity Wear\";s:13:\"category_slug\";s:14:\"maternity-wear\";}i:875;a:10:{s:26:\"master_category_section_id\";i:876;s:18:\"master_category_id\";i:13;s:20:\"master_category_name\";s:21:\"WOMEN\'S BEAUTY & CARE\";s:20:\"master_category_slug\";s:18:\"womens-beauty-care\";s:15:\"section_type_id\";i:82;s:17:\"section_type_name\";s:15:\"MATERNITY STORE\";s:17:\"section_type_slug\";s:15:\"maternity-store\";s:11:\"category_id\";i:686;s:13:\"category_name\";s:17:\"Matenity Lingerie\";s:13:\"category_slug\";s:17:\"matenity-lingerie\";}i:876;a:10:{s:26:\"master_category_section_id\";i:877;s:18:\"master_category_id\";i:13;s:20:\"master_category_name\";s:21:\"WOMEN\'S BEAUTY & CARE\";s:20:\"master_category_slug\";s:18:\"womens-beauty-care\";s:15:\"section_type_id\";i:82;s:17:\"section_type_name\";s:15:\"MATERNITY STORE\";s:17:\"section_type_slug\";s:15:\"maternity-store\";s:11:\"category_id\";i:501;s:13:\"category_name\";s:17:\"Socks & Stockings\";s:13:\"category_slug\";s:15:\"socks-stockings\";}i:877;a:10:{s:26:\"master_category_section_id\";i:878;s:18:\"master_category_id\";i:13;s:20:\"master_category_name\";s:21:\"WOMEN\'S BEAUTY & CARE\";s:20:\"master_category_slug\";s:18:\"womens-beauty-care\";s:15:\"section_type_id\";i:82;s:17:\"section_type_name\";s:15:\"MATERNITY STORE\";s:17:\"section_type_slug\";s:15:\"maternity-store\";s:11:\"category_id\";i:687;s:13:\"category_name\";s:22:\"Hospital Bag Checklist\";s:13:\"category_slug\";s:22:\"hospital-bag-checklist\";}i:878;a:10:{s:26:\"master_category_section_id\";i:879;s:18:\"master_category_id\";i:13;s:20:\"master_category_name\";s:21:\"WOMEN\'S BEAUTY & CARE\";s:20:\"master_category_slug\";s:18:\"womens-beauty-care\";s:15:\"section_type_id\";i:82;s:17:\"section_type_name\";s:15:\"MATERNITY STORE\";s:17:\"section_type_slug\";s:15:\"maternity-store\";s:11:\"category_id\";i:688;s:13:\"category_name\";s:27:\"Pregnancy & Parenting Books\";s:13:\"category_slug\";s:25:\"pregnancy-parenting-books\";}i:879;a:10:{s:26:\"master_category_section_id\";i:880;s:18:\"master_category_id\";i:13;s:20:\"master_category_name\";s:21:\"WOMEN\'S BEAUTY & CARE\";s:20:\"master_category_slug\";s:18:\"womens-beauty-care\";s:15:\"section_type_id\";i:83;s:17:\"section_type_name\";s:19:\"HAIR CARE & STYLING\";s:17:\"section_type_slug\";s:17:\"hair-care-styling\";s:11:\"category_id\";i:689;s:13:\"category_name\";s:7:\"Shampoo\";s:13:\"category_slug\";s:7:\"shampoo\";}i:880;a:10:{s:26:\"master_category_section_id\";i:881;s:18:\"master_category_id\";i:13;s:20:\"master_category_name\";s:21:\"WOMEN\'S BEAUTY & CARE\";s:20:\"master_category_slug\";s:18:\"womens-beauty-care\";s:15:\"section_type_id\";i:83;s:17:\"section_type_name\";s:19:\"HAIR CARE & STYLING\";s:17:\"section_type_slug\";s:17:\"hair-care-styling\";s:11:\"category_id\";i:690;s:13:\"category_name\";s:8:\"Hair Oil\";s:13:\"category_slug\";s:8:\"hair-oil\";}i:881;a:10:{s:26:\"master_category_section_id\";i:882;s:18:\"master_category_id\";i:13;s:20:\"master_category_name\";s:21:\"WOMEN\'S BEAUTY & CARE\";s:20:\"master_category_slug\";s:18:\"womens-beauty-care\";s:15:\"section_type_id\";i:83;s:17:\"section_type_name\";s:19:\"HAIR CARE & STYLING\";s:17:\"section_type_slug\";s:17:\"hair-care-styling\";s:11:\"category_id\";i:691;s:13:\"category_name\";s:9:\"Hair Mask\";s:13:\"category_slug\";s:9:\"hair-mask\";}i:882;a:10:{s:26:\"master_category_section_id\";i:883;s:18:\"master_category_id\";i:13;s:20:\"master_category_name\";s:21:\"WOMEN\'S BEAUTY & CARE\";s:20:\"master_category_slug\";s:18:\"womens-beauty-care\";s:15:\"section_type_id\";i:83;s:17:\"section_type_name\";s:19:\"HAIR CARE & STYLING\";s:17:\"section_type_slug\";s:17:\"hair-care-styling\";s:11:\"category_id\";i:692;s:13:\"category_name\";s:11:\"Conditioner\";s:13:\"category_slug\";s:11:\"conditioner\";}i:883;a:10:{s:26:\"master_category_section_id\";i:884;s:18:\"master_category_id\";i:13;s:20:\"master_category_name\";s:21:\"WOMEN\'S BEAUTY & CARE\";s:20:\"master_category_slug\";s:18:\"womens-beauty-care\";s:15:\"section_type_id\";i:83;s:17:\"section_type_name\";s:19:\"HAIR CARE & STYLING\";s:17:\"section_type_slug\";s:17:\"hair-care-styling\";s:11:\"category_id\";i:693;s:13:\"category_name\";s:10:\"Hair Serum\";s:13:\"category_slug\";s:10:\"hair-serum\";}i:884;a:10:{s:26:\"master_category_section_id\";i:885;s:18:\"master_category_id\";i:13;s:20:\"master_category_name\";s:21:\"WOMEN\'S BEAUTY & CARE\";s:20:\"master_category_slug\";s:18:\"womens-beauty-care\";s:15:\"section_type_id\";i:83;s:17:\"section_type_name\";s:19:\"HAIR CARE & STYLING\";s:17:\"section_type_slug\";s:17:\"hair-care-styling\";s:11:\"category_id\";i:505;s:13:\"category_name\";s:18:\"Hair Styling Tools\";s:13:\"category_slug\";s:18:\"hair-styling-tools\";}i:885;a:10:{s:26:\"master_category_section_id\";i:886;s:18:\"master_category_id\";i:13;s:20:\"master_category_name\";s:21:\"WOMEN\'S BEAUTY & CARE\";s:20:\"master_category_slug\";s:18:\"womens-beauty-care\";s:15:\"section_type_id\";i:84;s:17:\"section_type_name\";s:23:\"FEMININE HYGIENE & CARE\";s:17:\"section_type_slug\";s:21:\"feminine-hygiene-care\";s:11:\"category_id\";i:694;s:13:\"category_name\";s:16:\"Sanitary Napkins\";s:13:\"category_slug\";s:16:\"sanitary-napkins\";}i:886;a:10:{s:26:\"master_category_section_id\";i:887;s:18:\"master_category_id\";i:13;s:20:\"master_category_name\";s:21:\"WOMEN\'S BEAUTY & CARE\";s:20:\"master_category_slug\";s:18:\"womens-beauty-care\";s:15:\"section_type_id\";i:84;s:17:\"section_type_name\";s:23:\"FEMININE HYGIENE & CARE\";s:17:\"section_type_slug\";s:21:\"feminine-hygiene-care\";s:11:\"category_id\";i:695;s:13:\"category_name\";s:12:\"Panty Liners\";s:13:\"category_slug\";s:12:\"panty-liners\";}i:887;a:10:{s:26:\"master_category_section_id\";i:888;s:18:\"master_category_id\";i:13;s:20:\"master_category_name\";s:21:\"WOMEN\'S BEAUTY & CARE\";s:20:\"master_category_slug\";s:18:\"womens-beauty-care\";s:15:\"section_type_id\";i:84;s:17:\"section_type_name\";s:23:\"FEMININE HYGIENE & CARE\";s:17:\"section_type_slug\";s:21:\"feminine-hygiene-care\";s:11:\"category_id\";i:696;s:13:\"category_name\";s:14:\"Menstrual Cups\";s:13:\"category_slug\";s:14:\"menstrual-cups\";}i:888;a:10:{s:26:\"master_category_section_id\";i:889;s:18:\"master_category_id\";i:13;s:20:\"master_category_name\";s:21:\"WOMEN\'S BEAUTY & CARE\";s:20:\"master_category_slug\";s:18:\"womens-beauty-care\";s:15:\"section_type_id\";i:84;s:17:\"section_type_name\";s:23:\"FEMININE HYGIENE & CARE\";s:17:\"section_type_slug\";s:21:\"feminine-hygiene-care\";s:11:\"category_id\";i:697;s:13:\"category_name\";s:22:\"Hygienic Disposal Bags\";s:13:\"category_slug\";s:22:\"hygienic-disposal-bags\";}i:889;a:10:{s:26:\"master_category_section_id\";i:890;s:18:\"master_category_id\";i:13;s:20:\"master_category_name\";s:21:\"WOMEN\'S BEAUTY & CARE\";s:20:\"master_category_slug\";s:18:\"womens-beauty-care\";s:15:\"section_type_id\";i:84;s:17:\"section_type_name\";s:23:\"FEMININE HYGIENE & CARE\";s:17:\"section_type_slug\";s:21:\"feminine-hygiene-care\";s:11:\"category_id\";i:698;s:13:\"category_name\";s:28:\"Vaginal Tightening Gel/Cream\";s:13:\"category_slug\";s:27:\"vaginal-tightening-gelcream\";}i:890;a:10:{s:26:\"master_category_section_id\";i:891;s:18:\"master_category_id\";i:13;s:20:\"master_category_name\";s:21:\"WOMEN\'S BEAUTY & CARE\";s:20:\"master_category_slug\";s:18:\"womens-beauty-care\";s:15:\"section_type_id\";i:84;s:17:\"section_type_name\";s:23:\"FEMININE HYGIENE & CARE\";s:17:\"section_type_slug\";s:21:\"feminine-hygiene-care\";s:11:\"category_id\";i:532;s:13:\"category_name\";s:13:\"Intimate Wash\";s:13:\"category_slug\";s:13:\"intimate-wash\";}i:891;a:10:{s:26:\"master_category_section_id\";i:892;s:18:\"master_category_id\";i:13;s:20:\"master_category_name\";s:21:\"WOMEN\'S BEAUTY & CARE\";s:20:\"master_category_slug\";s:18:\"womens-beauty-care\";s:15:\"section_type_id\";i:84;s:17:\"section_type_name\";s:23:\"FEMININE HYGIENE & CARE\";s:17:\"section_type_slug\";s:21:\"feminine-hygiene-care\";s:11:\"category_id\";i:699;s:13:\"category_name\";s:22:\"Shaving & Hair Removal\";s:13:\"category_slug\";s:20:\"shaving-hair-removal\";}i:892;a:10:{s:26:\"master_category_section_id\";i:893;s:18:\"master_category_id\";i:13;s:20:\"master_category_name\";s:21:\"WOMEN\'S BEAUTY & CARE\";s:20:\"master_category_slug\";s:18:\"womens-beauty-care\";s:15:\"section_type_id\";i:85;s:17:\"section_type_name\";s:19:\"HEALTH & WELL-BEING\";s:17:\"section_type_slug\";s:17:\"health-well-being\";s:11:\"category_id\";i:700;s:13:\"category_name\";s:18:\"Health Supplements\";s:13:\"category_slug\";s:18:\"health-supplements\";}i:893;a:10:{s:26:\"master_category_section_id\";i:894;s:18:\"master_category_id\";i:13;s:20:\"master_category_name\";s:21:\"WOMEN\'S BEAUTY & CARE\";s:20:\"master_category_slug\";s:18:\"womens-beauty-care\";s:15:\"section_type_id\";i:85;s:17:\"section_type_name\";s:19:\"HEALTH & WELL-BEING\";s:17:\"section_type_slug\";s:17:\"health-well-being\";s:11:\"category_id\";i:701;s:13:\"category_name\";s:17:\"Weight Management\";s:13:\"category_slug\";s:17:\"weight-management\";}i:894;a:10:{s:26:\"master_category_section_id\";i:895;s:18:\"master_category_id\";i:13;s:20:\"master_category_name\";s:21:\"WOMEN\'S BEAUTY & CARE\";s:20:\"master_category_slug\";s:18:\"womens-beauty-care\";s:15:\"section_type_id\";i:86;s:17:\"section_type_name\";s:19:\"NEW MOMS MUST HAVES\";s:17:\"section_type_slug\";s:19:\"new-moms-must-haves\";s:11:\"category_id\";i:702;s:13:\"category_name\";s:25:\"Breast Feeding Essentials\";s:13:\"category_slug\";s:25:\"breast-feeding-essentials\";}i:895;a:10:{s:26:\"master_category_section_id\";i:896;s:18:\"master_category_id\";i:13;s:20:\"master_category_name\";s:21:\"WOMEN\'S BEAUTY & CARE\";s:20:\"master_category_slug\";s:18:\"womens-beauty-care\";s:15:\"section_type_id\";i:86;s:17:\"section_type_name\";s:19:\"NEW MOMS MUST HAVES\";s:17:\"section_type_slug\";s:19:\"new-moms-must-haves\";s:11:\"category_id\";i:534;s:13:\"category_name\";s:30:\"Nutrition & Lactation Boosters\";s:13:\"category_slug\";s:28:\"nutrition-lactation-boosters\";}i:896;a:10:{s:26:\"master_category_section_id\";i:897;s:18:\"master_category_id\";i:13;s:20:\"master_category_name\";s:21:\"WOMEN\'S BEAUTY & CARE\";s:20:\"master_category_slug\";s:18:\"womens-beauty-care\";s:15:\"section_type_id\";i:86;s:17:\"section_type_name\";s:19:\"NEW MOMS MUST HAVES\";s:17:\"section_type_slug\";s:19:\"new-moms-must-haves\";s:11:\"category_id\";i:703;s:13:\"category_name\";s:23:\"Maternity Shaping Belts\";s:13:\"category_slug\";s:23:\"maternity-shaping-belts\";}i:897;a:10:{s:26:\"master_category_section_id\";i:898;s:18:\"master_category_id\";i:13;s:20:\"master_category_name\";s:21:\"WOMEN\'S BEAUTY & CARE\";s:20:\"master_category_slug\";s:18:\"womens-beauty-care\";s:15:\"section_type_id\";i:86;s:17:\"section_type_name\";s:19:\"NEW MOMS MUST HAVES\";s:17:\"section_type_slug\";s:19:\"new-moms-must-haves\";s:11:\"category_id\";i:311;s:13:\"category_name\";s:12:\"Nursing Bras\";s:13:\"category_slug\";s:12:\"nursing-bras\";}i:898;a:10:{s:26:\"master_category_section_id\";i:899;s:18:\"master_category_id\";i:14;s:20:\"master_category_name\";s:15:\"BIRTHDAYS GIFTS\";s:20:\"master_category_slug\";s:15:\"birthdays-gifts\";s:15:\"section_type_id\";i:87;s:17:\"section_type_name\";s:19:\"BIRTHDAY ESSENTIALS\";s:17:\"section_type_slug\";s:19:\"birthday-essentials\";s:11:\"category_id\";i:704;s:13:\"category_name\";s:14:\"Party Balloons\";s:13:\"category_slug\";s:14:\"party-balloons\";}i:899;a:10:{s:26:\"master_category_section_id\";i:900;s:18:\"master_category_id\";i:14;s:20:\"master_category_name\";s:15:\"BIRTHDAYS GIFTS\";s:20:\"master_category_slug\";s:15:\"birthdays-gifts\";s:15:\"section_type_id\";i:87;s:17:\"section_type_name\";s:19:\"BIRTHDAY ESSENTIALS\";s:17:\"section_type_slug\";s:19:\"birthday-essentials\";s:11:\"category_id\";i:705;s:13:\"category_name\";s:11:\"Party Decor\";s:13:\"category_slug\";s:11:\"party-decor\";}i:900;a:10:{s:26:\"master_category_section_id\";i:901;s:18:\"master_category_id\";i:14;s:20:\"master_category_name\";s:15:\"BIRTHDAYS GIFTS\";s:20:\"master_category_slug\";s:15:\"birthdays-gifts\";s:15:\"section_type_id\";i:87;s:17:\"section_type_name\";s:19:\"BIRTHDAY ESSENTIALS\";s:17:\"section_type_slug\";s:19:\"birthday-essentials\";s:11:\"category_id\";i:706;s:13:\"category_name\";s:23:\"Birthday Decoration Kit\";s:13:\"category_slug\";s:23:\"birthday-decoration-kit\";}i:901;a:10:{s:26:\"master_category_section_id\";i:902;s:18:\"master_category_id\";i:14;s:20:\"master_category_name\";s:15:\"BIRTHDAYS GIFTS\";s:20:\"master_category_slug\";s:15:\"birthdays-gifts\";s:15:\"section_type_id\";i:87;s:17:\"section_type_name\";s:19:\"BIRTHDAY ESSENTIALS\";s:17:\"section_type_slug\";s:19:\"birthday-essentials\";s:11:\"category_id\";i:707;s:13:\"category_name\";s:18:\"Party Props & Caps\";s:13:\"category_slug\";s:16:\"party-props-caps\";}i:902;a:10:{s:26:\"master_category_section_id\";i:903;s:18:\"master_category_id\";i:14;s:20:\"master_category_name\";s:15:\"BIRTHDAYS GIFTS\";s:20:\"master_category_slug\";s:15:\"birthdays-gifts\";s:15:\"section_type_id\";i:87;s:17:\"section_type_name\";s:19:\"BIRTHDAY ESSENTIALS\";s:17:\"section_type_slug\";s:19:\"birthday-essentials\";s:11:\"category_id\";i:708;s:13:\"category_name\";s:22:\"Candles & Cake Toppers\";s:13:\"category_slug\";s:20:\"candles-cake-toppers\";}i:903;a:10:{s:26:\"master_category_section_id\";i:904;s:18:\"master_category_id\";i:14;s:20:\"master_category_name\";s:15:\"BIRTHDAYS GIFTS\";s:20:\"master_category_slug\";s:15:\"birthdays-gifts\";s:15:\"section_type_id\";i:87;s:17:\"section_type_name\";s:19:\"BIRTHDAY ESSENTIALS\";s:17:\"section_type_slug\";s:19:\"birthday-essentials\";s:11:\"category_id\";i:709;s:13:\"category_name\";s:26:\"Plates, Cups & Table decor\";s:13:\"category_slug\";s:23:\"plates-cups-table-decor\";}i:904;a:10:{s:26:\"master_category_section_id\";i:905;s:18:\"master_category_id\";i:14;s:20:\"master_category_name\";s:15:\"BIRTHDAYS GIFTS\";s:20:\"master_category_slug\";s:15:\"birthdays-gifts\";s:15:\"section_type_id\";i:87;s:17:\"section_type_name\";s:19:\"BIRTHDAY ESSENTIALS\";s:17:\"section_type_slug\";s:19:\"birthday-essentials\";s:11:\"category_id\";i:710;s:13:\"category_name\";s:14:\"Party Supplies\";s:13:\"category_slug\";s:14:\"party-supplies\";}i:905;a:10:{s:26:\"master_category_section_id\";i:906;s:18:\"master_category_id\";i:14;s:20:\"master_category_name\";s:15:\"BIRTHDAYS GIFTS\";s:20:\"master_category_slug\";s:15:\"birthdays-gifts\";s:15:\"section_type_id\";i:87;s:17:\"section_type_name\";s:19:\"BIRTHDAY ESSENTIALS\";s:17:\"section_type_slug\";s:19:\"birthday-essentials\";s:11:\"category_id\";i:711;s:13:\"category_name\";s:20:\"Gift Bags & Wrappers\";s:13:\"category_slug\";s:18:\"gift-bags-wrappers\";}i:906;a:10:{s:26:\"master_category_section_id\";i:907;s:18:\"master_category_id\";i:14;s:20:\"master_category_name\";s:15:\"BIRTHDAYS GIFTS\";s:20:\"master_category_slug\";s:15:\"birthdays-gifts\";s:15:\"section_type_id\";i:87;s:17:\"section_type_name\";s:19:\"BIRTHDAY ESSENTIALS\";s:17:\"section_type_slug\";s:19:\"birthday-essentials\";s:11:\"category_id\";i:712;s:13:\"category_name\";s:16:\"Invitation Cards\";s:13:\"category_slug\";s:16:\"invitation-cards\";}i:907;a:10:{s:26:\"master_category_section_id\";i:908;s:18:\"master_category_id\";i:14;s:20:\"master_category_name\";s:15:\"BIRTHDAYS GIFTS\";s:20:\"master_category_slug\";s:15:\"birthdays-gifts\";s:15:\"section_type_id\";i:88;s:17:\"section_type_name\";s:11:\"PARTY DECOR\";s:17:\"section_type_slug\";s:11:\"party-decor\";s:11:\"category_id\";i:713;s:13:\"category_name\";s:18:\"Cut-outs & Posters\";s:13:\"category_slug\";s:16:\"cut-outs-posters\";}i:908;a:10:{s:26:\"master_category_section_id\";i:909;s:18:\"master_category_id\";i:14;s:20:\"master_category_name\";s:15:\"BIRTHDAYS GIFTS\";s:20:\"master_category_slug\";s:15:\"birthdays-gifts\";s:15:\"section_type_id\";i:88;s:17:\"section_type_name\";s:11:\"PARTY DECOR\";s:17:\"section_type_slug\";s:11:\"party-decor\";s:11:\"category_id\";i:714;s:13:\"category_name\";s:10:\"Wall Decor\";s:13:\"category_slug\";s:10:\"wall-decor\";}i:909;a:10:{s:26:\"master_category_section_id\";i:910;s:18:\"master_category_id\";i:14;s:20:\"master_category_name\";s:15:\"BIRTHDAYS GIFTS\";s:20:\"master_category_slug\";s:15:\"birthdays-gifts\";s:15:\"section_type_id\";i:88;s:17:\"section_type_name\";s:11:\"PARTY DECOR\";s:17:\"section_type_slug\";s:11:\"party-decor\";s:11:\"category_id\";i:715;s:13:\"category_name\";s:18:\"Swirls Decorations\";s:13:\"category_slug\";s:18:\"swirls-decorations\";}i:910;a:10:{s:26:\"master_category_section_id\";i:911;s:18:\"master_category_id\";i:14;s:20:\"master_category_name\";s:15:\"BIRTHDAYS GIFTS\";s:20:\"master_category_slug\";s:15:\"birthdays-gifts\";s:15:\"section_type_id\";i:88;s:17:\"section_type_name\";s:11:\"PARTY DECOR\";s:17:\"section_type_slug\";s:11:\"party-decor\";s:11:\"category_id\";i:716;s:13:\"category_name\";s:13:\"Party Banners\";s:13:\"category_slug\";s:13:\"party-banners\";}i:911;a:10:{s:26:\"master_category_section_id\";i:912;s:18:\"master_category_id\";i:14;s:20:\"master_category_name\";s:15:\"BIRTHDAYS GIFTS\";s:20:\"master_category_slug\";s:15:\"birthdays-gifts\";s:15:\"section_type_id\";i:89;s:17:\"section_type_name\";s:12:\"RETURN GIFTS\";s:17:\"section_type_slug\";s:12:\"return-gifts\";s:11:\"category_id\";i:717;s:13:\"category_name\";s:9:\"0-3 Years\";s:13:\"category_slug\";s:9:\"0-3-years\";}i:912;a:10:{s:26:\"master_category_section_id\";i:913;s:18:\"master_category_id\";i:14;s:20:\"master_category_name\";s:15:\"BIRTHDAYS GIFTS\";s:20:\"master_category_slug\";s:15:\"birthdays-gifts\";s:15:\"section_type_id\";i:89;s:17:\"section_type_name\";s:12:\"RETURN GIFTS\";s:17:\"section_type_slug\";s:12:\"return-gifts\";s:11:\"category_id\";i:718;s:13:\"category_name\";s:9:\"3-6 Years\";s:13:\"category_slug\";s:9:\"3-6-years\";}i:913;a:10:{s:26:\"master_category_section_id\";i:914;s:18:\"master_category_id\";i:14;s:20:\"master_category_name\";s:15:\"BIRTHDAYS GIFTS\";s:20:\"master_category_slug\";s:15:\"birthdays-gifts\";s:15:\"section_type_id\";i:89;s:17:\"section_type_name\";s:12:\"RETURN GIFTS\";s:17:\"section_type_slug\";s:12:\"return-gifts\";s:11:\"category_id\";i:719;s:13:\"category_name\";s:8:\"6+ Years\";s:13:\"category_slug\";s:7:\"6-years\";}i:914;a:10:{s:26:\"master_category_section_id\";i:915;s:18:\"master_category_id\";i:14;s:20:\"master_category_name\";s:15:\"BIRTHDAYS GIFTS\";s:20:\"master_category_slug\";s:15:\"birthdays-gifts\";s:15:\"section_type_id\";i:90;s:17:\"section_type_name\";s:22:\"PARTY BALLOONS & PROPS\";s:17:\"section_type_slug\";s:20:\"party-balloons-props\";s:11:\"category_id\";i:720;s:13:\"category_name\";s:13:\"Balloon Packs\";s:13:\"category_slug\";s:13:\"balloon-packs\";}i:915;a:10:{s:26:\"master_category_section_id\";i:916;s:18:\"master_category_id\";i:14;s:20:\"master_category_name\";s:15:\"BIRTHDAYS GIFTS\";s:20:\"master_category_slug\";s:15:\"birthdays-gifts\";s:15:\"section_type_id\";i:90;s:17:\"section_type_name\";s:22:\"PARTY BALLOONS & PROPS\";s:17:\"section_type_slug\";s:20:\"party-balloons-props\";s:11:\"category_id\";i:721;s:13:\"category_name\";s:8:\"Metallic\";s:13:\"category_slug\";s:8:\"metallic\";}i:916;a:10:{s:26:\"master_category_section_id\";i:917;s:18:\"master_category_id\";i:14;s:20:\"master_category_name\";s:15:\"BIRTHDAYS GIFTS\";s:20:\"master_category_slug\";s:15:\"birthdays-gifts\";s:15:\"section_type_id\";i:90;s:17:\"section_type_name\";s:22:\"PARTY BALLOONS & PROPS\";s:17:\"section_type_slug\";s:20:\"party-balloons-props\";s:11:\"category_id\";i:722;s:13:\"category_name\";s:4:\"Foil\";s:13:\"category_slug\";s:4:\"foil\";}i:917;a:10:{s:26:\"master_category_section_id\";i:918;s:18:\"master_category_id\";i:14;s:20:\"master_category_name\";s:15:\"BIRTHDAYS GIFTS\";s:20:\"master_category_slug\";s:15:\"birthdays-gifts\";s:15:\"section_type_id\";i:90;s:17:\"section_type_name\";s:22:\"PARTY BALLOONS & PROPS\";s:17:\"section_type_slug\";s:20:\"party-balloons-props\";s:11:\"category_id\";i:723;s:13:\"category_name\";s:16:\"Photobooth Props\";s:13:\"category_slug\";s:16:\"photobooth-props\";}i:918;a:10:{s:26:\"master_category_section_id\";i:919;s:18:\"master_category_id\";i:14;s:20:\"master_category_name\";s:15:\"BIRTHDAYS GIFTS\";s:20:\"master_category_slug\";s:15:\"birthdays-gifts\";s:15:\"section_type_id\";i:90;s:17:\"section_type_name\";s:22:\"PARTY BALLOONS & PROPS\";s:17:\"section_type_slug\";s:20:\"party-balloons-props\";s:11:\"category_id\";i:724;s:13:\"category_name\";s:11:\"Badges/Sash\";s:13:\"category_slug\";s:10:\"badgessash\";}i:919;a:10:{s:26:\"master_category_section_id\";i:920;s:18:\"master_category_id\";i:14;s:20:\"master_category_name\";s:15:\"BIRTHDAYS GIFTS\";s:20:\"master_category_slug\";s:15:\"birthdays-gifts\";s:15:\"section_type_id\";i:90;s:17:\"section_type_name\";s:22:\"PARTY BALLOONS & PROPS\";s:17:\"section_type_slug\";s:20:\"party-balloons-props\";s:11:\"category_id\";i:725;s:13:\"category_name\";s:4:\"Hats\";s:13:\"category_slug\";s:4:\"hats\";}i:920;a:10:{s:26:\"master_category_section_id\";i:921;s:18:\"master_category_id\";i:14;s:20:\"master_category_name\";s:15:\"BIRTHDAYS GIFTS\";s:20:\"master_category_slug\";s:15:\"birthdays-gifts\";s:15:\"section_type_id\";i:90;s:17:\"section_type_name\";s:22:\"PARTY BALLOONS & PROPS\";s:17:\"section_type_slug\";s:20:\"party-balloons-props\";s:11:\"category_id\";i:726;s:13:\"category_name\";s:5:\"Masks\";s:13:\"category_slug\";s:5:\"masks\";}i:921;a:10:{s:26:\"master_category_section_id\";i:922;s:18:\"master_category_id\";i:14;s:20:\"master_category_name\";s:15:\"BIRTHDAYS GIFTS\";s:20:\"master_category_slug\";s:15:\"birthdays-gifts\";s:15:\"section_type_id\";i:91;s:17:\"section_type_name\";s:26:\"PLATES, CUPS & TABLE DECOR\";s:17:\"section_type_slug\";s:23:\"plates-cups-table-decor\";s:11:\"category_id\";i:727;s:13:\"category_name\";s:9:\"Menu Card\";s:13:\"category_slug\";s:9:\"menu-card\";}i:922;a:10:{s:26:\"master_category_section_id\";i:923;s:18:\"master_category_id\";i:14;s:20:\"master_category_name\";s:15:\"BIRTHDAYS GIFTS\";s:20:\"master_category_slug\";s:15:\"birthdays-gifts\";s:15:\"section_type_id\";i:91;s:17:\"section_type_name\";s:26:\"PLATES, CUPS & TABLE DECOR\";s:17:\"section_type_slug\";s:23:\"plates-cups-table-decor\";s:11:\"category_id\";i:728;s:13:\"category_name\";s:15:\"Napkins/Tissues\";s:13:\"category_slug\";s:14:\"napkinstissues\";}i:923;a:10:{s:26:\"master_category_section_id\";i:924;s:18:\"master_category_id\";i:14;s:20:\"master_category_name\";s:15:\"BIRTHDAYS GIFTS\";s:20:\"master_category_slug\";s:15:\"birthdays-gifts\";s:15:\"section_type_id\";i:91;s:17:\"section_type_name\";s:26:\"PLATES, CUPS & TABLE DECOR\";s:17:\"section_type_slug\";s:23:\"plates-cups-table-decor\";s:11:\"category_id\";i:729;s:13:\"category_name\";s:20:\"Straw & Cutlery Sets\";s:13:\"category_slug\";s:18:\"straw-cutlery-sets\";}i:924;a:10:{s:26:\"master_category_section_id\";i:925;s:18:\"master_category_id\";i:14;s:20:\"master_category_name\";s:15:\"BIRTHDAYS GIFTS\";s:20:\"master_category_slug\";s:15:\"birthdays-gifts\";s:15:\"section_type_id\";i:91;s:17:\"section_type_name\";s:26:\"PLATES, CUPS & TABLE DECOR\";s:17:\"section_type_slug\";s:23:\"plates-cups-table-decor\";s:11:\"category_id\";i:730;s:13:\"category_name\";s:18:\"Paper/Fibre Plates\";s:13:\"category_slug\";s:17:\"paperfibre-plates\";}i:925;a:10:{s:26:\"master_category_section_id\";i:926;s:18:\"master_category_id\";i:14;s:20:\"master_category_name\";s:15:\"BIRTHDAYS GIFTS\";s:20:\"master_category_slug\";s:15:\"birthdays-gifts\";s:15:\"section_type_id\";i:91;s:17:\"section_type_name\";s:26:\"PLATES, CUPS & TABLE DECOR\";s:17:\"section_type_slug\";s:23:\"plates-cups-table-decor\";s:11:\"category_id\";i:731;s:13:\"category_name\";s:14:\"Cups & Glasses\";s:13:\"category_slug\";s:12:\"cups-glasses\";}i:926;a:10:{s:26:\"master_category_section_id\";i:927;s:18:\"master_category_id\";i:14;s:20:\"master_category_name\";s:15:\"BIRTHDAYS GIFTS\";s:20:\"master_category_slug\";s:15:\"birthdays-gifts\";s:15:\"section_type_id\";i:91;s:17:\"section_type_name\";s:26:\"PLATES, CUPS & TABLE DECOR\";s:17:\"section_type_slug\";s:23:\"plates-cups-table-decor\";s:11:\"category_id\";i:732;s:13:\"category_name\";s:19:\"Table Covers & Mats\";s:13:\"category_slug\";s:17:\"table-covers-mats\";}i:927;a:10:{s:26:\"master_category_section_id\";i:928;s:18:\"master_category_id\";i:14;s:20:\"master_category_name\";s:15:\"BIRTHDAYS GIFTS\";s:20:\"master_category_slug\";s:15:\"birthdays-gifts\";s:15:\"section_type_id\";i:91;s:17:\"section_type_name\";s:26:\"PLATES, CUPS & TABLE DECOR\";s:17:\"section_type_slug\";s:23:\"plates-cups-table-decor\";s:11:\"category_id\";i:733;s:13:\"category_name\";s:14:\"Bottle Wrapper\";s:13:\"category_slug\";s:14:\"bottle-wrapper\";}i:928;a:10:{s:26:\"master_category_section_id\";i:929;s:18:\"master_category_id\";i:14;s:20:\"master_category_name\";s:15:\"BIRTHDAYS GIFTS\";s:20:\"master_category_slug\";s:15:\"birthdays-gifts\";s:15:\"section_type_id\";i:92;s:17:\"section_type_name\";s:9:\"GIFT SETS\";s:17:\"section_type_slug\";s:9:\"gift-sets\";s:11:\"category_id\";i:734;s:13:\"category_name\";s:15:\"Baby Gifts Sets\";s:13:\"category_slug\";s:15:\"baby-gifts-sets\";}i:929;a:10:{s:26:\"master_category_section_id\";i:930;s:18:\"master_category_id\";i:14;s:20:\"master_category_name\";s:15:\"BIRTHDAYS GIFTS\";s:20:\"master_category_slug\";s:15:\"birthdays-gifts\";s:15:\"section_type_id\";i:92;s:17:\"section_type_name\";s:9:\"GIFT SETS\";s:17:\"section_type_slug\";s:9:\"gift-sets\";s:11:\"category_id\";i:735;s:13:\"category_name\";s:14:\"Kids Gift Sets\";s:13:\"category_slug\";s:14:\"kids-gift-sets\";}i:930;a:10:{s:26:\"master_category_section_id\";i:931;s:18:\"master_category_id\";i:14;s:20:\"master_category_name\";s:15:\"BIRTHDAYS GIFTS\";s:20:\"master_category_slug\";s:15:\"birthdays-gifts\";s:15:\"section_type_id\";i:92;s:17:\"section_type_name\";s:9:\"GIFT SETS\";s:17:\"section_type_slug\";s:9:\"gift-sets\";s:11:\"category_id\";i:736;s:13:\"category_name\";s:16:\"Gift Certificate\";s:13:\"category_slug\";s:16:\"gift-certificate\";}i:931;a:10:{s:26:\"master_category_section_id\";i:932;s:18:\"master_category_id\";i:14;s:20:\"master_category_name\";s:15:\"BIRTHDAYS GIFTS\";s:20:\"master_category_slug\";s:15:\"birthdays-gifts\";s:15:\"section_type_id\";i:93;s:17:\"section_type_name\";s:10:\"GIFT STORE\";s:17:\"section_type_slug\";s:10:\"gift-store\";s:11:\"category_id\";i:737;s:13:\"category_name\";s:15:\"Fashion For him\";s:13:\"category_slug\";s:15:\"fashion-for-him\";}i:932;a:10:{s:26:\"master_category_section_id\";i:933;s:18:\"master_category_id\";i:14;s:20:\"master_category_name\";s:15:\"BIRTHDAYS GIFTS\";s:20:\"master_category_slug\";s:15:\"birthdays-gifts\";s:15:\"section_type_id\";i:93;s:17:\"section_type_name\";s:10:\"GIFT STORE\";s:17:\"section_type_slug\";s:10:\"gift-store\";s:11:\"category_id\";i:738;s:13:\"category_name\";s:15:\"Fashion For her\";s:13:\"category_slug\";s:15:\"fashion-for-her\";}i:933;a:10:{s:26:\"master_category_section_id\";i:934;s:18:\"master_category_id\";i:14;s:20:\"master_category_name\";s:15:\"BIRTHDAYS GIFTS\";s:20:\"master_category_slug\";s:15:\"birthdays-gifts\";s:15:\"section_type_id\";i:93;s:17:\"section_type_name\";s:10:\"GIFT STORE\";s:17:\"section_type_slug\";s:10:\"gift-store\";s:11:\"category_id\";i:739;s:13:\"category_name\";s:19:\"Fashion Accessories\";s:13:\"category_slug\";s:19:\"fashion-accessories\";}i:934;a:10:{s:26:\"master_category_section_id\";i:935;s:18:\"master_category_id\";i:14;s:20:\"master_category_name\";s:15:\"BIRTHDAYS GIFTS\";s:20:\"master_category_slug\";s:15:\"birthdays-gifts\";s:15:\"section_type_id\";i:93;s:17:\"section_type_name\";s:10:\"GIFT STORE\";s:17:\"section_type_slug\";s:10:\"gift-store\";s:11:\"category_id\";i:740;s:13:\"category_name\";s:13:\"Toys & Gaming\";s:13:\"category_slug\";s:11:\"toys-gaming\";}i:935;a:10:{s:26:\"master_category_section_id\";i:936;s:18:\"master_category_id\";i:14;s:20:\"master_category_name\";s:15:\"BIRTHDAYS GIFTS\";s:20:\"master_category_slug\";s:15:\"birthdays-gifts\";s:15:\"section_type_id\";i:93;s:17:\"section_type_name\";s:10:\"GIFT STORE\";s:17:\"section_type_slug\";s:10:\"gift-store\";s:11:\"category_id\";i:611;s:13:\"category_name\";s:9:\"Baby Gear\";s:13:\"category_slug\";s:9:\"baby-gear\";}i:936;a:10:{s:26:\"master_category_section_id\";i:937;s:18:\"master_category_id\";i:14;s:20:\"master_category_name\";s:15:\"BIRTHDAYS GIFTS\";s:20:\"master_category_slug\";s:15:\"birthdays-gifts\";s:15:\"section_type_id\";i:93;s:17:\"section_type_name\";s:10:\"GIFT STORE\";s:17:\"section_type_slug\";s:10:\"gift-store\";s:11:\"category_id\";i:612;s:13:\"category_name\";s:7:\"Nursery\";s:13:\"category_slug\";s:7:\"nursery\";}i:937;a:10:{s:26:\"master_category_section_id\";i:938;s:18:\"master_category_id\";i:14;s:20:\"master_category_name\";s:15:\"BIRTHDAYS GIFTS\";s:20:\"master_category_slug\";s:15:\"birthdays-gifts\";s:15:\"section_type_id\";i:93;s:17:\"section_type_name\";s:10:\"GIFT STORE\";s:17:\"section_type_slug\";s:10:\"gift-store\";s:11:\"category_id\";i:741;s:13:\"category_name\";s:12:\"Books & CD\'s\";s:13:\"category_slug\";s:9:\"books-cds\";}i:938;a:10:{s:26:\"master_category_section_id\";i:939;s:18:\"master_category_id\";i:15;s:20:\"master_category_name\";s:5:\"BOOKS\";s:20:\"master_category_slug\";s:5:\"books\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:742;s:13:\"category_name\";s:11:\"Board Books\";s:13:\"category_slug\";s:11:\"board-books\";}i:939;a:10:{s:26:\"master_category_section_id\";i:940;s:18:\"master_category_id\";i:15;s:20:\"master_category_name\";s:5:\"BOOKS\";s:20:\"master_category_slug\";s:5:\"books\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:743;s:13:\"category_name\";s:12:\"Read & Learn\";s:13:\"category_slug\";s:10:\"read-learn\";}i:940;a:10:{s:26:\"master_category_section_id\";i:941;s:18:\"master_category_id\";i:15;s:20:\"master_category_name\";s:5:\"BOOKS\";s:20:\"master_category_slug\";s:5:\"books\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:744;s:13:\"category_name\";s:32:\"Crafts, Hobbies & Activity books\";s:13:\"category_slug\";s:29:\"crafts-hobbies-activity-books\";}i:941;a:10:{s:26:\"master_category_section_id\";i:942;s:18:\"master_category_id\";i:15;s:20:\"master_category_name\";s:5:\"BOOKS\";s:20:\"master_category_slug\";s:5:\"books\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:745;s:13:\"category_name\";s:11:\"Story Books\";s:13:\"category_slug\";s:11:\"story-books\";}i:942;a:10:{s:26:\"master_category_section_id\";i:943;s:18:\"master_category_id\";i:15;s:20:\"master_category_name\";s:5:\"BOOKS\";s:20:\"master_category_slug\";s:5:\"books\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:746;s:13:\"category_name\";s:23:\"Drawing & Coloring Book\";s:13:\"category_slug\";s:21:\"drawing-coloring-book\";}i:943;a:10:{s:26:\"master_category_section_id\";i:944;s:18:\"master_category_id\";i:15;s:20:\"master_category_name\";s:5:\"BOOKS\";s:20:\"master_category_slug\";s:5:\"books\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:747;s:13:\"category_name\";s:14:\"Academic Books\";s:13:\"category_slug\";s:14:\"academic-books\";}i:944;a:10:{s:26:\"master_category_section_id\";i:945;s:18:\"master_category_id\";i:15;s:20:\"master_category_name\";s:5:\"BOOKS\";s:20:\"master_category_slug\";s:5:\"books\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:748;s:13:\"category_name\";s:13:\"Picture Books\";s:13:\"category_slug\";s:13:\"picture-books\";}i:945;a:10:{s:26:\"master_category_section_id\";i:946;s:18:\"master_category_id\";i:15;s:20:\"master_category_name\";s:5:\"BOOKS\";s:20:\"master_category_slug\";s:5:\"books\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:749;s:13:\"category_name\";s:21:\"Rhymes & Poetry Books\";s:13:\"category_slug\";s:19:\"rhymes-poetry-books\";}i:946;a:10:{s:26:\"master_category_section_id\";i:947;s:18:\"master_category_id\";i:15;s:20:\"master_category_name\";s:5:\"BOOKS\";s:20:\"master_category_slug\";s:5:\"books\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:750;s:13:\"category_name\";s:22:\"Comics & Graphic Books\";s:13:\"category_slug\";s:20:\"comics-graphic-books\";}i:947;a:10:{s:26:\"master_category_section_id\";i:948;s:18:\"master_category_id\";i:15;s:20:\"master_category_name\";s:5:\"BOOKS\";s:20:\"master_category_slug\";s:5:\"books\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:751;s:13:\"category_name\";s:13:\"Sticker Books\";s:13:\"category_slug\";s:13:\"sticker-books\";}i:948;a:10:{s:26:\"master_category_section_id\";i:949;s:18:\"master_category_id\";i:15;s:20:\"master_category_name\";s:5:\"BOOKS\";s:20:\"master_category_slug\";s:5:\"books\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:688;s:13:\"category_name\";s:27:\"Pregnancy & Parenting Books\";s:13:\"category_slug\";s:25:\"pregnancy-parenting-books\";}i:949;a:10:{s:26:\"master_category_section_id\";i:950;s:18:\"master_category_id\";i:15;s:20:\"master_category_name\";s:5:\"BOOKS\";s:20:\"master_category_slug\";s:5:\"books\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:752;s:13:\"category_name\";s:13:\"CD\'s & Movies\";s:13:\"category_slug\";s:10:\"cds-movies\";}i:950;a:10:{s:26:\"master_category_section_id\";i:951;s:18:\"master_category_id\";i:15;s:20:\"master_category_name\";s:5:\"BOOKS\";s:20:\"master_category_slug\";s:5:\"books\";s:15:\"section_type_id\";i:94;s:17:\"section_type_name\";s:32:\"CRAFTS, HOBBIES & ACTIVITY BOOKS\";s:17:\"section_type_slug\";s:29:\"crafts-hobbies-activity-books\";s:11:\"category_id\";i:753;s:13:\"category_name\";s:14:\"Activity Books\";s:13:\"category_slug\";s:14:\"activity-books\";}i:951;a:10:{s:26:\"master_category_section_id\";i:952;s:18:\"master_category_id\";i:15;s:20:\"master_category_name\";s:5:\"BOOKS\";s:20:\"master_category_slug\";s:5:\"books\";s:15:\"section_type_id\";i:94;s:17:\"section_type_name\";s:32:\"CRAFTS, HOBBIES & ACTIVITY BOOKS\";s:17:\"section_type_slug\";s:29:\"crafts-hobbies-activity-books\";s:11:\"category_id\";i:754;s:13:\"category_name\";s:13:\"Arts & Crafts\";s:13:\"category_slug\";s:11:\"arts-crafts\";}i:952;a:10:{s:26:\"master_category_section_id\";i:953;s:18:\"master_category_id\";i:15;s:20:\"master_category_name\";s:5:\"BOOKS\";s:20:\"master_category_slug\";s:5:\"books\";s:15:\"section_type_id\";i:94;s:17:\"section_type_name\";s:32:\"CRAFTS, HOBBIES & ACTIVITY BOOKS\";s:17:\"section_type_slug\";s:29:\"crafts-hobbies-activity-books\";s:11:\"category_id\";i:755;s:13:\"category_name\";s:17:\"Game & Quiz Books\";s:13:\"category_slug\";s:15:\"game-quiz-books\";}i:953;a:10:{s:26:\"master_category_section_id\";i:954;s:18:\"master_category_id\";i:15;s:20:\"master_category_name\";s:5:\"BOOKS\";s:20:\"master_category_slug\";s:5:\"books\";s:15:\"section_type_id\";i:94;s:17:\"section_type_name\";s:32:\"CRAFTS, HOBBIES & ACTIVITY BOOKS\";s:17:\"section_type_slug\";s:29:\"crafts-hobbies-activity-books\";s:11:\"category_id\";i:756;s:13:\"category_name\";s:8:\"Journals\";s:13:\"category_slug\";s:8:\"journals\";}i:954;a:10:{s:26:\"master_category_section_id\";i:955;s:18:\"master_category_id\";i:15;s:20:\"master_category_name\";s:5:\"BOOKS\";s:20:\"master_category_slug\";s:5:\"books\";s:15:\"section_type_id\";i:94;s:17:\"section_type_name\";s:32:\"CRAFTS, HOBBIES & ACTIVITY BOOKS\";s:17:\"section_type_slug\";s:29:\"crafts-hobbies-activity-books\";s:11:\"category_id\";i:757;s:13:\"category_name\";s:11:\"Scrap Books\";s:13:\"category_slug\";s:11:\"scrap-books\";}i:955;a:10:{s:26:\"master_category_section_id\";i:956;s:18:\"master_category_id\";i:15;s:20:\"master_category_name\";s:5:\"BOOKS\";s:20:\"master_category_slug\";s:5:\"books\";s:15:\"section_type_id\";i:95;s:17:\"section_type_name\";s:27:\"PREGNANCY & PARENTING BOOKS\";s:17:\"section_type_slug\";s:25:\"pregnancy-parenting-books\";s:11:\"category_id\";i:758;s:13:\"category_name\";s:10:\"Baby Names\";s:13:\"category_slug\";s:10:\"baby-names\";}i:956;a:10:{s:26:\"master_category_section_id\";i:957;s:18:\"master_category_id\";i:15;s:20:\"master_category_name\";s:5:\"BOOKS\";s:20:\"master_category_slug\";s:5:\"books\";s:15:\"section_type_id\";i:95;s:17:\"section_type_name\";s:27:\"PREGNANCY & PARENTING BOOKS\";s:17:\"section_type_slug\";s:25:\"pregnancy-parenting-books\";s:11:\"category_id\";i:759;s:13:\"category_name\";s:17:\"Baby Record Books\";s:13:\"category_slug\";s:17:\"baby-record-books\";}i:957;a:10:{s:26:\"master_category_section_id\";i:958;s:18:\"master_category_id\";i:15;s:20:\"master_category_name\";s:5:\"BOOKS\";s:20:\"master_category_slug\";s:5:\"books\";s:15:\"section_type_id\";i:95;s:17:\"section_type_name\";s:27:\"PREGNANCY & PARENTING BOOKS\";s:17:\"section_type_slug\";s:25:\"pregnancy-parenting-books\";s:11:\"category_id\";i:760;s:13:\"category_name\";s:17:\"Child Development\";s:13:\"category_slug\";s:17:\"child-development\";}i:958;a:10:{s:26:\"master_category_section_id\";i:959;s:18:\"master_category_id\";i:15;s:20:\"master_category_name\";s:5:\"BOOKS\";s:20:\"master_category_slug\";s:5:\"books\";s:15:\"section_type_id\";i:95;s:17:\"section_type_name\";s:27:\"PREGNANCY & PARENTING BOOKS\";s:17:\"section_type_slug\";s:25:\"pregnancy-parenting-books\";s:11:\"category_id\";i:761;s:13:\"category_name\";s:17:\"Expecting Mothers\";s:13:\"category_slug\";s:17:\"expecting-mothers\";}i:959;a:10:{s:26:\"master_category_section_id\";i:960;s:18:\"master_category_id\";i:15;s:20:\"master_category_name\";s:5:\"BOOKS\";s:20:\"master_category_slug\";s:5:\"books\";s:15:\"section_type_id\";i:95;s:17:\"section_type_name\";s:27:\"PREGNANCY & PARENTING BOOKS\";s:17:\"section_type_slug\";s:25:\"pregnancy-parenting-books\";s:11:\"category_id\";i:762;s:13:\"category_name\";s:22:\"Conception & Pregnancy\";s:13:\"category_slug\";s:20:\"conception-pregnancy\";}i:960;a:10:{s:26:\"master_category_section_id\";i:961;s:18:\"master_category_id\";i:15;s:20:\"master_category_name\";s:5:\"BOOKS\";s:20:\"master_category_slug\";s:5:\"books\";s:15:\"section_type_id\";i:96;s:17:\"section_type_name\";s:12:\"READ & LEARN\";s:17:\"section_type_slug\";s:10:\"read-learn\";s:11:\"category_id\";i:763;s:13:\"category_name\";s:18:\"Aphabets & Numbers\";s:13:\"category_slug\";s:16:\"aphabets-numbers\";}i:961;a:10:{s:26:\"master_category_section_id\";i:962;s:18:\"master_category_id\";i:15;s:20:\"master_category_name\";s:5:\"BOOKS\";s:20:\"master_category_slug\";s:5:\"books\";s:15:\"section_type_id\";i:96;s:17:\"section_type_name\";s:12:\"READ & LEARN\";s:17:\"section_type_slug\";s:10:\"read-learn\";s:11:\"category_id\";i:764;s:13:\"category_name\";s:15:\"Animals & Birds\";s:13:\"category_slug\";s:13:\"animals-birds\";}i:962;a:10:{s:26:\"master_category_section_id\";i:963;s:18:\"master_category_id\";i:15;s:20:\"master_category_name\";s:5:\"BOOKS\";s:20:\"master_category_slug\";s:5:\"books\";s:15:\"section_type_id\";i:96;s:17:\"section_type_name\";s:12:\"READ & LEARN\";s:17:\"section_type_slug\";s:10:\"read-learn\";s:11:\"category_id\";i:765;s:13:\"category_name\";s:19:\"Fruits & Vegetables\";s:13:\"category_slug\";s:17:\"fruits-vegetables\";}i:963;a:10:{s:26:\"master_category_section_id\";i:964;s:18:\"master_category_id\";i:15;s:20:\"master_category_name\";s:5:\"BOOKS\";s:20:\"master_category_slug\";s:5:\"books\";s:15:\"section_type_id\";i:96;s:17:\"section_type_name\";s:12:\"READ & LEARN\";s:17:\"section_type_slug\";s:10:\"read-learn\";s:11:\"category_id\";i:766;s:13:\"category_name\";s:19:\"Pre-School Learning\";s:13:\"category_slug\";s:19:\"pre-school-learning\";}i:964;a:10:{s:26:\"master_category_section_id\";i:965;s:18:\"master_category_id\";i:15;s:20:\"master_category_name\";s:5:\"BOOKS\";s:20:\"master_category_slug\";s:5:\"books\";s:15:\"section_type_id\";i:96;s:17:\"section_type_name\";s:12:\"READ & LEARN\";s:17:\"section_type_slug\";s:10:\"read-learn\";s:11:\"category_id\";i:767;s:13:\"category_name\";s:17:\"General Knowledge\";s:13:\"category_slug\";s:17:\"general-knowledge\";}i:965;a:10:{s:26:\"master_category_section_id\";i:966;s:18:\"master_category_id\";i:15;s:20:\"master_category_name\";s:5:\"BOOKS\";s:20:\"master_category_slug\";s:5:\"books\";s:15:\"section_type_id\";i:97;s:17:\"section_type_name\";s:11:\"STORY BOOKS\";s:17:\"section_type_slug\";s:11:\"story-books\";s:11:\"category_id\";i:768;s:13:\"category_name\";s:17:\"Adventure Stories\";s:13:\"category_slug\";s:17:\"adventure-stories\";}i:966;a:10:{s:26:\"master_category_section_id\";i:967;s:18:\"master_category_id\";i:15;s:20:\"master_category_name\";s:5:\"BOOKS\";s:20:\"master_category_slug\";s:5:\"books\";s:15:\"section_type_id\";i:97;s:17:\"section_type_name\";s:11:\"STORY BOOKS\";s:17:\"section_type_slug\";s:11:\"story-books\";s:11:\"category_id\";i:769;s:13:\"category_name\";s:19:\"Bedtime Story Books\";s:13:\"category_slug\";s:19:\"bedtime-story-books\";}i:967;a:10:{s:26:\"master_category_section_id\";i:968;s:18:\"master_category_id\";i:15;s:20:\"master_category_name\";s:5:\"BOOKS\";s:20:\"master_category_slug\";s:5:\"books\";s:15:\"section_type_id\";i:97;s:17:\"section_type_name\";s:11:\"STORY BOOKS\";s:17:\"section_type_slug\";s:11:\"story-books\";s:11:\"category_id\";i:770;s:13:\"category_name\";s:25:\"Classic Story Collections\";s:13:\"category_slug\";s:25:\"classic-story-collections\";}i:968;a:10:{s:26:\"master_category_section_id\";i:969;s:18:\"master_category_id\";i:15;s:20:\"master_category_name\";s:5:\"BOOKS\";s:20:\"master_category_slug\";s:5:\"books\";s:15:\"section_type_id\";i:97;s:17:\"section_type_name\";s:11:\"STORY BOOKS\";s:17:\"section_type_slug\";s:11:\"story-books\";s:11:\"category_id\";i:771;s:13:\"category_name\";s:17:\"Pop Up & 3D books\";s:13:\"category_slug\";s:15:\"pop-up-3d-books\";}i:969;a:10:{s:26:\"master_category_section_id\";i:970;s:18:\"master_category_id\";i:15;s:20:\"master_category_name\";s:5:\"BOOKS\";s:20:\"master_category_slug\";s:5:\"books\";s:15:\"section_type_id\";i:14;s:17:\"section_type_name\";s:10:\"TOP BRANDS\";s:17:\"section_type_slug\";s:10:\"top-brands\";s:11:\"category_id\";i:71;s:13:\"category_name\";s:7:\"Babyhug\";s:13:\"category_slug\";s:7:\"babyhug\";}i:970;a:10:{s:26:\"master_category_section_id\";i:971;s:18:\"master_category_id\";i:15;s:20:\"master_category_name\";s:5:\"BOOKS\";s:20:\"master_category_slug\";s:5:\"books\";s:15:\"section_type_id\";i:14;s:17:\"section_type_name\";s:10:\"TOP BRANDS\";s:17:\"section_type_slug\";s:10:\"top-brands\";s:11:\"category_id\";i:182;s:13:\"category_name\";s:13:\"Intelliskills\";s:13:\"category_slug\";s:13:\"intelliskills\";}i:971;a:10:{s:26:\"master_category_section_id\";i:972;s:18:\"master_category_id\";i:15;s:20:\"master_category_name\";s:5:\"BOOKS\";s:20:\"master_category_slug\";s:5:\"books\";s:15:\"section_type_id\";i:14;s:17:\"section_type_name\";s:10:\"TOP BRANDS\";s:17:\"section_type_slug\";s:10:\"top-brands\";s:11:\"category_id\";i:772;s:13:\"category_name\";s:11:\"Intellitots\";s:13:\"category_slug\";s:11:\"intellitots\";}i:972;a:10:{s:26:\"master_category_section_id\";i:973;s:18:\"master_category_id\";i:15;s:20:\"master_category_name\";s:5:\"BOOKS\";s:20:\"master_category_slug\";s:5:\"books\";s:15:\"section_type_id\";i:14;s:17:\"section_type_name\";s:10:\"TOP BRANDS\";s:17:\"section_type_slug\";s:10:\"top-brands\";s:11:\"category_id\";i:773;s:13:\"category_name\";s:9:\"Dreamland\";s:13:\"category_slug\";s:9:\"dreamland\";}i:973;a:10:{s:26:\"master_category_section_id\";i:974;s:18:\"master_category_id\";i:15;s:20:\"master_category_name\";s:5:\"BOOKS\";s:20:\"master_category_slug\";s:5:\"books\";s:15:\"section_type_id\";i:14;s:17:\"section_type_name\";s:10:\"TOP BRANDS\";s:17:\"section_type_slug\";s:10:\"top-brands\";s:11:\"category_id\";i:774;s:13:\"category_name\";s:5:\"Sawan\";s:13:\"category_slug\";s:5:\"sawan\";}i:974;a:10:{s:26:\"master_category_section_id\";i:975;s:18:\"master_category_id\";i:15;s:20:\"master_category_name\";s:5:\"BOOKS\";s:20:\"master_category_slug\";s:5:\"books\";s:15:\"section_type_id\";i:14;s:17:\"section_type_name\";s:10:\"TOP BRANDS\";s:17:\"section_type_slug\";s:10:\"top-brands\";s:11:\"category_id\";i:775;s:13:\"category_name\";s:7:\"Navneet\";s:13:\"category_slug\";s:7:\"navneet\";}i:975;a:10:{s:26:\"master_category_section_id\";i:976;s:18:\"master_category_id\";i:15;s:20:\"master_category_name\";s:5:\"BOOKS\";s:20:\"master_category_slug\";s:5:\"books\";s:15:\"section_type_id\";i:14;s:17:\"section_type_name\";s:10:\"TOP BRANDS\";s:17:\"section_type_slug\";s:10:\"top-brands\";s:11:\"category_id\";i:776;s:13:\"category_name\";s:7:\"Pegasus\";s:13:\"category_slug\";s:7:\"pegasus\";}i:976;a:10:{s:26:\"master_category_section_id\";i:977;s:18:\"master_category_id\";i:15;s:20:\"master_category_name\";s:5:\"BOOKS\";s:20:\"master_category_slug\";s:5:\"books\";s:15:\"section_type_id\";i:14;s:17:\"section_type_name\";s:10:\"TOP BRANDS\";s:17:\"section_type_slug\";s:10:\"top-brands\";s:11:\"category_id\";i:777;s:13:\"category_name\";s:17:\"Amar Chitra Katha\";s:13:\"category_slug\";s:17:\"amar-chitra-katha\";}i:977;a:10:{s:26:\"master_category_section_id\";i:978;s:18:\"master_category_id\";i:15;s:20:\"master_category_name\";s:5:\"BOOKS\";s:20:\"master_category_slug\";s:5:\"books\";s:15:\"section_type_id\";i:14;s:17:\"section_type_name\";s:10:\"TOP BRANDS\";s:17:\"section_type_slug\";s:10:\"top-brands\";s:11:\"category_id\";i:778;s:13:\"category_name\";s:6:\"Target\";s:13:\"category_slug\";s:6:\"target\";}i:978;a:10:{s:26:\"master_category_section_id\";i:979;s:18:\"master_category_id\";i:15;s:20:\"master_category_name\";s:5:\"BOOKS\";s:20:\"master_category_slug\";s:5:\"books\";s:15:\"section_type_id\";i:98;s:17:\"section_type_name\";s:23:\"DRAWING & COLORING BOOK\";s:17:\"section_type_slug\";s:21:\"drawing-coloring-book\";s:11:\"category_id\";i:779;s:13:\"category_name\";s:22:\"Coloring Activity Book\";s:13:\"category_slug\";s:22:\"coloring-activity-book\";}i:979;a:10:{s:26:\"master_category_section_id\";i:980;s:18:\"master_category_id\";i:15;s:20:\"master_category_name\";s:5:\"BOOKS\";s:20:\"master_category_slug\";s:5:\"books\";s:15:\"section_type_id\";i:98;s:17:\"section_type_name\";s:23:\"DRAWING & COLORING BOOK\";s:17:\"section_type_slug\";s:21:\"drawing-coloring-book\";s:11:\"category_id\";i:780;s:13:\"category_name\";s:18:\"Copy & Color Books\";s:13:\"category_slug\";s:16:\"copy-color-books\";}i:980;a:10:{s:26:\"master_category_section_id\";i:981;s:18:\"master_category_id\";i:15;s:20:\"master_category_name\";s:5:\"BOOKS\";s:20:\"master_category_slug\";s:5:\"books\";s:15:\"section_type_id\";i:98;s:17:\"section_type_name\";s:23:\"DRAWING & COLORING BOOK\";s:17:\"section_type_slug\";s:21:\"drawing-coloring-book\";s:11:\"category_id\";i:781;s:13:\"category_name\";s:13:\"Join the Dots\";s:13:\"category_slug\";s:13:\"join-the-dots\";}i:981;a:10:{s:26:\"master_category_section_id\";i:982;s:18:\"master_category_id\";i:15;s:20:\"master_category_name\";s:5:\"BOOKS\";s:20:\"master_category_slug\";s:5:\"books\";s:15:\"section_type_id\";i:98;s:17:\"section_type_name\";s:23:\"DRAWING & COLORING BOOK\";s:17:\"section_type_slug\";s:21:\"drawing-coloring-book\";s:11:\"category_id\";i:782;s:13:\"category_name\";s:13:\"Drawing Books\";s:13:\"category_slug\";s:13:\"drawing-books\";}i:982;a:10:{s:26:\"master_category_section_id\";i:983;s:18:\"master_category_id\";i:15;s:20:\"master_category_name\";s:5:\"BOOKS\";s:20:\"master_category_slug\";s:5:\"books\";s:15:\"section_type_id\";i:98;s:17:\"section_type_name\";s:23:\"DRAWING & COLORING BOOK\";s:17:\"section_type_slug\";s:21:\"drawing-coloring-book\";s:11:\"category_id\";i:783;s:13:\"category_name\";s:16:\"Magical Coloring\";s:13:\"category_slug\";s:16:\"magical-coloring\";}i:983;a:10:{s:26:\"master_category_section_id\";i:984;s:18:\"master_category_id\";i:16;s:20:\"master_category_name\";s:15:\"SCHOOL SUPPLIES\";s:20:\"master_category_slug\";s:15:\"school-supplies\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:784;s:13:\"category_name\";s:17:\"School Stationery\";s:13:\"category_slug\";s:17:\"school-stationery\";}i:984;a:10:{s:26:\"master_category_section_id\";i:985;s:18:\"master_category_id\";i:16;s:20:\"master_category_name\";s:15:\"SCHOOL SUPPLIES\";s:20:\"master_category_slug\";s:15:\"school-supplies\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:785;s:13:\"category_name\";s:24:\"School Bags & Back Packs\";s:13:\"category_slug\";s:22:\"school-bags-back-packs\";}i:985;a:10:{s:26:\"master_category_section_id\";i:986;s:18:\"master_category_id\";i:16;s:20:\"master_category_name\";s:15:\"SCHOOL SUPPLIES\";s:20:\"master_category_slug\";s:15:\"school-supplies\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:786;s:13:\"category_name\";s:13:\"Water Bottles\";s:13:\"category_slug\";s:13:\"water-bottles\";}i:986;a:10:{s:26:\"master_category_section_id\";i:987;s:18:\"master_category_id\";i:16;s:20:\"master_category_name\";s:15:\"SCHOOL SUPPLIES\";s:20:\"master_category_slug\";s:15:\"school-supplies\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:787;s:13:\"category_name\";s:11:\"Lunch Boxes\";s:13:\"category_slug\";s:11:\"lunch-boxes\";}i:987;a:10:{s:26:\"master_category_section_id\";i:988;s:18:\"master_category_id\";i:16;s:20:\"master_category_name\";s:15:\"SCHOOL SUPPLIES\";s:20:\"master_category_slug\";s:15:\"school-supplies\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:788;s:13:\"category_name\";s:11:\"School Kits\";s:13:\"category_slug\";s:11:\"school-kits\";}i:988;a:10:{s:26:\"master_category_section_id\";i:989;s:18:\"master_category_id\";i:16;s:20:\"master_category_name\";s:15:\"SCHOOL SUPPLIES\";s:20:\"master_category_slug\";s:15:\"school-supplies\";s:15:\"section_type_id\";i:99;s:17:\"section_type_name\";s:11:\"LUNCH BOXES\";s:17:\"section_type_slug\";s:11:\"lunch-boxes\";s:11:\"category_id\";i:789;s:13:\"category_name\";s:9:\"Lunch Box\";s:13:\"category_slug\";s:9:\"lunch-box\";}i:989;a:10:{s:26:\"master_category_section_id\";i:990;s:18:\"master_category_id\";i:16;s:20:\"master_category_name\";s:15:\"SCHOOL SUPPLIES\";s:20:\"master_category_slug\";s:15:\"school-supplies\";s:15:\"section_type_id\";i:99;s:17:\"section_type_name\";s:11:\"LUNCH BOXES\";s:17:\"section_type_slug\";s:11:\"lunch-boxes\";s:11:\"category_id\";i:790;s:13:\"category_name\";s:14:\"Lunch Box Sets\";s:13:\"category_slug\";s:14:\"lunch-box-sets\";}i:990;a:10:{s:26:\"master_category_section_id\";i:991;s:18:\"master_category_id\";i:16;s:20:\"master_category_name\";s:15:\"SCHOOL SUPPLIES\";s:20:\"master_category_slug\";s:15:\"school-supplies\";s:15:\"section_type_id\";i:99;s:17:\"section_type_name\";s:11:\"LUNCH BOXES\";s:17:\"section_type_slug\";s:11:\"lunch-boxes\";s:11:\"category_id\";i:791;s:13:\"category_name\";s:23:\"Lunch Box Set With Bags\";s:13:\"category_slug\";s:23:\"lunch-box-set-with-bags\";}i:991;a:10:{s:26:\"master_category_section_id\";i:992;s:18:\"master_category_id\";i:16;s:20:\"master_category_name\";s:15:\"SCHOOL SUPPLIES\";s:20:\"master_category_slug\";s:15:\"school-supplies\";s:15:\"section_type_id\";i:99;s:17:\"section_type_name\";s:11:\"LUNCH BOXES\";s:17:\"section_type_slug\";s:11:\"lunch-boxes\";s:11:\"category_id\";i:792;s:13:\"category_name\";s:19:\"Insulated Lunch Box\";s:13:\"category_slug\";s:19:\"insulated-lunch-box\";}i:992;a:10:{s:26:\"master_category_section_id\";i:993;s:18:\"master_category_id\";i:16;s:20:\"master_category_name\";s:15:\"SCHOOL SUPPLIES\";s:20:\"master_category_slug\";s:15:\"school-supplies\";s:15:\"section_type_id\";i:100;s:17:\"section_type_name\";s:17:\"SHOP BY CHARACTER\";s:17:\"section_type_slug\";s:17:\"shop-by-character\";s:11:\"category_id\";i:793;s:13:\"category_name\";s:15:\"Disney Princess\";s:13:\"category_slug\";s:15:\"disney-princess\";}i:993;a:10:{s:26:\"master_category_section_id\";i:994;s:18:\"master_category_id\";i:16;s:20:\"master_category_name\";s:15:\"SCHOOL SUPPLIES\";s:20:\"master_category_slug\";s:15:\"school-supplies\";s:15:\"section_type_id\";i:100;s:17:\"section_type_name\";s:17:\"SHOP BY CHARACTER\";s:17:\"section_type_slug\";s:17:\"shop-by-character\";s:11:\"category_id\";i:794;s:13:\"category_name\";s:13:\"Disney Frozen\";s:13:\"category_slug\";s:13:\"disney-frozen\";}i:994;a:10:{s:26:\"master_category_section_id\";i:995;s:18:\"master_category_id\";i:16;s:20:\"master_category_name\";s:15:\"SCHOOL SUPPLIES\";s:20:\"master_category_slug\";s:15:\"school-supplies\";s:15:\"section_type_id\";i:100;s:17:\"section_type_name\";s:17:\"SHOP BY CHARACTER\";s:17:\"section_type_slug\";s:17:\"shop-by-character\";s:11:\"category_id\";i:795;s:13:\"category_name\";s:12:\"Minnie Mouse\";s:13:\"category_slug\";s:12:\"minnie-mouse\";}i:995;a:10:{s:26:\"master_category_section_id\";i:996;s:18:\"master_category_id\";i:16;s:20:\"master_category_name\";s:15:\"SCHOOL SUPPLIES\";s:20:\"master_category_slug\";s:15:\"school-supplies\";s:15:\"section_type_id\";i:100;s:17:\"section_type_name\";s:17:\"SHOP BY CHARACTER\";s:17:\"section_type_slug\";s:17:\"shop-by-character\";s:11:\"category_id\";i:187;s:13:\"category_name\";s:6:\"Barbie\";s:13:\"category_slug\";s:6:\"barbie\";}i:996;a:10:{s:26:\"master_category_section_id\";i:997;s:18:\"master_category_id\";i:16;s:20:\"master_category_name\";s:15:\"SCHOOL SUPPLIES\";s:20:\"master_category_slug\";s:15:\"school-supplies\";s:15:\"section_type_id\";i:100;s:17:\"section_type_name\";s:17:\"SHOP BY CHARACTER\";s:17:\"section_type_slug\";s:17:\"shop-by-character\";s:11:\"category_id\";i:796;s:13:\"category_name\";s:9:\"Spiderman\";s:13:\"category_slug\";s:9:\"spiderman\";}i:997;a:10:{s:26:\"master_category_section_id\";i:998;s:18:\"master_category_id\";i:16;s:20:\"master_category_name\";s:15:\"SCHOOL SUPPLIES\";s:20:\"master_category_slug\";s:15:\"school-supplies\";s:15:\"section_type_id\";i:100;s:17:\"section_type_name\";s:17:\"SHOP BY CHARACTER\";s:17:\"section_type_slug\";s:17:\"shop-by-character\";s:11:\"category_id\";i:797;s:13:\"category_name\";s:8:\"Avengers\";s:13:\"category_slug\";s:8:\"avengers\";}i:998;a:10:{s:26:\"master_category_section_id\";i:999;s:18:\"master_category_id\";i:16;s:20:\"master_category_name\";s:15:\"SCHOOL SUPPLIES\";s:20:\"master_category_slug\";s:15:\"school-supplies\";s:15:\"section_type_id\";i:100;s:17:\"section_type_name\";s:17:\"SHOP BY CHARACTER\";s:17:\"section_type_slug\";s:17:\"shop-by-character\";s:11:\"category_id\";i:798;s:13:\"category_name\";s:16:\"Mickey & Friends\";s:13:\"category_slug\";s:14:\"mickey-friends\";}i:999;a:10:{s:26:\"master_category_section_id\";i:1000;s:18:\"master_category_id\";i:16;s:20:\"master_category_name\";s:15:\"SCHOOL SUPPLIES\";s:20:\"master_category_slug\";s:15:\"school-supplies\";s:15:\"section_type_id\";i:100;s:17:\"section_type_name\";s:17:\"SHOP BY CHARACTER\";s:17:\"section_type_slug\";s:17:\"shop-by-character\";s:11:\"category_id\";i:799;s:13:\"category_name\";s:9:\"Peppa Pig\";s:13:\"category_slug\";s:9:\"peppa-pig\";}i:1000;a:10:{s:26:\"master_category_section_id\";i:1001;s:18:\"master_category_id\";i:16;s:20:\"master_category_name\";s:15:\"SCHOOL SUPPLIES\";s:20:\"master_category_slug\";s:15:\"school-supplies\";s:15:\"section_type_id\";i:101;s:17:\"section_type_name\";s:10:\"STATIONERY\";s:17:\"section_type_slug\";s:10:\"stationery\";s:11:\"category_id\";i:800;s:13:\"category_name\";s:23:\"Writing & Doodle Boards\";s:13:\"category_slug\";s:21:\"writing-doodle-boards\";}i:1001;a:10:{s:26:\"master_category_section_id\";i:1002;s:18:\"master_category_id\";i:16;s:20:\"master_category_name\";s:15:\"SCHOOL SUPPLIES\";s:20:\"master_category_slug\";s:15:\"school-supplies\";s:15:\"section_type_id\";i:101;s:17:\"section_type_name\";s:10:\"STATIONERY\";s:17:\"section_type_slug\";s:10:\"stationery\";s:11:\"category_id\";i:801;s:13:\"category_name\";s:27:\"Pens,Pencils & Pencil Boxes\";s:13:\"category_slug\";s:24:\"penspencils-pencil-boxes\";}i:1002;a:10:{s:26:\"master_category_section_id\";i:1003;s:18:\"master_category_id\";i:16;s:20:\"master_category_name\";s:15:\"SCHOOL SUPPLIES\";s:20:\"master_category_slug\";s:15:\"school-supplies\";s:15:\"section_type_id\";i:101;s:17:\"section_type_name\";s:10:\"STATIONERY\";s:17:\"section_type_slug\";s:10:\"stationery\";s:11:\"category_id\";i:802;s:13:\"category_name\";s:24:\"Drawing & Colouring Sets\";s:13:\"category_slug\";s:22:\"drawing-colouring-sets\";}i:1003;a:10:{s:26:\"master_category_section_id\";i:1004;s:18:\"master_category_id\";i:16;s:20:\"master_category_name\";s:15:\"SCHOOL SUPPLIES\";s:20:\"master_category_slug\";s:15:\"school-supplies\";s:15:\"section_type_id\";i:101;s:17:\"section_type_name\";s:10:\"STATIONERY\";s:17:\"section_type_slug\";s:10:\"stationery\";s:11:\"category_id\";i:803;s:13:\"category_name\";s:15:\"Stationery Sets\";s:13:\"category_slug\";s:15:\"stationery-sets\";}i:1004;a:10:{s:26:\"master_category_section_id\";i:1005;s:18:\"master_category_id\";i:16;s:20:\"master_category_name\";s:15:\"SCHOOL SUPPLIES\";s:20:\"master_category_slug\";s:15:\"school-supplies\";s:15:\"section_type_id\";i:101;s:17:\"section_type_name\";s:10:\"STATIONERY\";s:17:\"section_type_slug\";s:10:\"stationery\";s:11:\"category_id\";i:804;s:13:\"category_name\";s:10:\"Note Books\";s:13:\"category_slug\";s:10:\"note-books\";}i:1005;a:10:{s:26:\"master_category_section_id\";i:1006;s:18:\"master_category_id\";i:16;s:20:\"master_category_name\";s:15:\"SCHOOL SUPPLIES\";s:20:\"master_category_slug\";s:15:\"school-supplies\";s:15:\"section_type_id\";i:102;s:17:\"section_type_name\";s:13:\"WATER BOTTLES\";s:17:\"section_type_slug\";s:13:\"water-bottles\";s:11:\"category_id\";i:805;s:13:\"category_name\";s:15:\"Regular Bottles\";s:13:\"category_slug\";s:15:\"regular-bottles\";}i:1006;a:10:{s:26:\"master_category_section_id\";i:1007;s:18:\"master_category_id\";i:16;s:20:\"master_category_name\";s:15:\"SCHOOL SUPPLIES\";s:20:\"master_category_slug\";s:15:\"school-supplies\";s:15:\"section_type_id\";i:102;s:17:\"section_type_name\";s:13:\"WATER BOTTLES\";s:17:\"section_type_slug\";s:13:\"water-bottles\";s:11:\"category_id\";i:806;s:13:\"category_name\";s:14:\"Sipper Bottles\";s:13:\"category_slug\";s:14:\"sipper-bottles\";}i:1007;a:10:{s:26:\"master_category_section_id\";i:1008;s:18:\"master_category_id\";i:16;s:20:\"master_category_name\";s:15:\"SCHOOL SUPPLIES\";s:20:\"master_category_slug\";s:15:\"school-supplies\";s:15:\"section_type_id\";i:102;s:17:\"section_type_name\";s:13:\"WATER BOTTLES\";s:17:\"section_type_slug\";s:13:\"water-bottles\";s:11:\"category_id\";i:807;s:13:\"category_name\";s:14:\"Sports Bottles\";s:13:\"category_slug\";s:14:\"sports-bottles\";}i:1008;a:10:{s:26:\"master_category_section_id\";i:1009;s:18:\"master_category_id\";i:16;s:20:\"master_category_name\";s:15:\"SCHOOL SUPPLIES\";s:20:\"master_category_slug\";s:15:\"school-supplies\";s:15:\"section_type_id\";i:103;s:17:\"section_type_name\";s:18:\"SHOP BY TOP BRANDS\";s:17:\"section_type_slug\";s:18:\"shop-by-top-brands\";s:11:\"category_id\";i:808;s:13:\"category_name\";s:4:\"Youp\";s:13:\"category_slug\";s:4:\"youp\";}i:1009;a:10:{s:26:\"master_category_section_id\";i:1010;s:18:\"master_category_id\";i:16;s:20:\"master_category_name\";s:15:\"SCHOOL SUPPLIES\";s:20:\"master_category_slug\";s:15:\"school-supplies\";s:15:\"section_type_id\";i:103;s:17:\"section_type_name\";s:18:\"SHOP BY TOP BRANDS\";s:17:\"section_type_slug\";s:18:\"shop-by-top-brands\";s:11:\"category_id\";i:809;s:13:\"category_name\";s:6:\"Milton\";s:13:\"category_slug\";s:6:\"milton\";}i:1010;a:10:{s:26:\"master_category_section_id\";i:1011;s:18:\"master_category_id\";i:16;s:20:\"master_category_name\";s:15:\"SCHOOL SUPPLIES\";s:20:\"master_category_slug\";s:15:\"school-supplies\";s:15:\"section_type_id\";i:103;s:17:\"section_type_name\";s:18:\"SHOP BY TOP BRANDS\";s:17:\"section_type_slug\";s:18:\"shop-by-top-brands\";s:11:\"category_id\";i:184;s:13:\"category_name\";s:11:\"Fab n Funky\";s:13:\"category_slug\";s:11:\"fab-n-funky\";}i:1011;a:10:{s:26:\"master_category_section_id\";i:1012;s:18:\"master_category_id\";i:16;s:20:\"master_category_name\";s:15:\"SCHOOL SUPPLIES\";s:20:\"master_category_slug\";s:15:\"school-supplies\";s:15:\"section_type_id\";i:103;s:17:\"section_type_name\";s:18:\"SHOP BY TOP BRANDS\";s:17:\"section_type_slug\";s:18:\"shop-by-top-brands\";s:11:\"category_id\";i:810;s:13:\"category_name\";s:6:\"Apsara\";s:13:\"category_slug\";s:6:\"apsara\";}i:1012;a:10:{s:26:\"master_category_section_id\";i:1013;s:18:\"master_category_id\";i:16;s:20:\"master_category_name\";s:15:\"SCHOOL SUPPLIES\";s:20:\"master_category_slug\";s:15:\"school-supplies\";s:15:\"section_type_id\";i:103;s:17:\"section_type_name\";s:18:\"SHOP BY TOP BRANDS\";s:17:\"section_type_slug\";s:18:\"shop-by-top-brands\";s:11:\"category_id\";i:811;s:13:\"category_name\";s:4:\"Doms\";s:13:\"category_slug\";s:4:\"doms\";}i:1013;a:10:{s:26:\"master_category_section_id\";i:1014;s:18:\"master_category_id\";i:16;s:20:\"master_category_name\";s:15:\"SCHOOL SUPPLIES\";s:20:\"master_category_slug\";s:15:\"school-supplies\";s:15:\"section_type_id\";i:103;s:17:\"section_type_name\";s:18:\"SHOP BY TOP BRANDS\";s:17:\"section_type_slug\";s:18:\"shop-by-top-brands\";s:11:\"category_id\";i:812;s:13:\"category_name\";s:9:\"Classmate\";s:13:\"category_slug\";s:9:\"classmate\";}i:1014;a:10:{s:26:\"master_category_section_id\";i:1015;s:18:\"master_category_id\";i:16;s:20:\"master_category_name\";s:15:\"SCHOOL SUPPLIES\";s:20:\"master_category_slug\";s:15:\"school-supplies\";s:15:\"section_type_id\";i:103;s:17:\"section_type_name\";s:18:\"SHOP BY TOP BRANDS\";s:17:\"section_type_slug\";s:18:\"shop-by-top-brands\";s:11:\"category_id\";i:813;s:13:\"category_name\";s:6:\"Camlin\";s:13:\"category_slug\";s:6:\"camlin\";}i:1015;a:10:{s:26:\"master_category_section_id\";i:1016;s:18:\"master_category_id\";i:16;s:20:\"master_category_name\";s:15:\"SCHOOL SUPPLIES\";s:20:\"master_category_slug\";s:15:\"school-supplies\";s:15:\"section_type_id\";i:103;s:17:\"section_type_name\";s:18:\"SHOP BY TOP BRANDS\";s:17:\"section_type_slug\";s:18:\"shop-by-top-brands\";s:11:\"category_id\";i:814;s:13:\"category_name\";s:13:\"Faber Castell\";s:13:\"category_slug\";s:13:\"faber-castell\";}i:1016;a:10:{s:26:\"master_category_section_id\";i:1017;s:18:\"master_category_id\";i:16;s:20:\"master_category_name\";s:15:\"SCHOOL SUPPLIES\";s:20:\"master_category_slug\";s:15:\"school-supplies\";s:15:\"section_type_id\";i:103;s:17:\"section_type_name\";s:18:\"SHOP BY TOP BRANDS\";s:17:\"section_type_slug\";s:18:\"shop-by-top-brands\";s:11:\"category_id\";i:815;s:13:\"category_name\";s:14:\"My Little Pony\";s:13:\"category_slug\";s:14:\"my-little-pony\";}i:1017;a:10:{s:26:\"master_category_section_id\";i:1018;s:18:\"master_category_id\";i:16;s:20:\"master_category_name\";s:15:\"SCHOOL SUPPLIES\";s:20:\"master_category_slug\";s:15:\"school-supplies\";s:15:\"section_type_id\";i:104;s:17:\"section_type_name\";s:24:\"SCHOOL BAGS & BACK PACKS\";s:17:\"section_type_slug\";s:22:\"school-bags-back-packs\";s:11:\"category_id\";i:816;s:13:\"category_name\";s:10:\"Back Packs\";s:13:\"category_slug\";s:10:\"back-packs\";}i:1018;a:10:{s:26:\"master_category_section_id\";i:1019;s:18:\"master_category_id\";i:16;s:20:\"master_category_name\";s:15:\"SCHOOL SUPPLIES\";s:20:\"master_category_slug\";s:15:\"school-supplies\";s:15:\"section_type_id\";i:104;s:17:\"section_type_name\";s:24:\"SCHOOL BAGS & BACK PACKS\";s:17:\"section_type_slug\";s:22:\"school-bags-back-packs\";s:11:\"category_id\";i:817;s:13:\"category_name\";s:14:\"Soft Toys Bags\";s:13:\"category_slug\";s:14:\"soft-toys-bags\";}i:1019;a:10:{s:26:\"master_category_section_id\";i:1020;s:18:\"master_category_id\";i:16;s:20:\"master_category_name\";s:15:\"SCHOOL SUPPLIES\";s:20:\"master_category_slug\";s:15:\"school-supplies\";s:15:\"section_type_id\";i:104;s:17:\"section_type_name\";s:24:\"SCHOOL BAGS & BACK PACKS\";s:17:\"section_type_slug\";s:22:\"school-bags-back-packs\";s:11:\"category_id\";i:818;s:13:\"category_name\";s:12:\"Trolley Bags\";s:13:\"category_slug\";s:12:\"trolley-bags\";}i:1020;a:10:{s:26:\"master_category_section_id\";i:1021;s:18:\"master_category_id\";i:17;s:20:\"master_category_name\";s:13:\"HOME & LIVING\";s:20:\"master_category_slug\";s:11:\"home-living\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:819;s:13:\"category_name\";s:15:\"Home Furnishing\";s:13:\"category_slug\";s:15:\"home-furnishing\";}i:1021;a:10:{s:26:\"master_category_section_id\";i:1022;s:18:\"master_category_id\";i:17;s:20:\"master_category_name\";s:13:\"HOME & LIVING\";s:20:\"master_category_slug\";s:11:\"home-living\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:820;s:13:\"category_name\";s:10:\"Home Decor\";s:13:\"category_slug\";s:10:\"home-decor\";}i:1022;a:10:{s:26:\"master_category_section_id\";i:1023;s:18:\"master_category_id\";i:17;s:20:\"master_category_name\";s:13:\"HOME & LIVING\";s:20:\"master_category_slug\";s:11:\"home-living\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:821;s:13:\"category_name\";s:29:\"Home Storage and Organization\";s:13:\"category_slug\";s:29:\"home-storage-and-organization\";}i:1023;a:10:{s:26:\"master_category_section_id\";i:1024;s:18:\"master_category_id\";i:17;s:20:\"master_category_name\";s:13:\"HOME & LIVING\";s:20:\"master_category_slug\";s:11:\"home-living\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:822;s:13:\"category_name\";s:27:\"Kitchen & Dining Essentials\";s:13:\"category_slug\";s:25:\"kitchen-dining-essentials\";}i:1024;a:10:{s:26:\"master_category_section_id\";i:1025;s:18:\"master_category_id\";i:17;s:20:\"master_category_name\";s:13:\"HOME & LIVING\";s:20:\"master_category_slug\";s:11:\"home-living\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:296;s:13:\"category_name\";s:18:\"Kitchen Appliances\";s:13:\"category_slug\";s:18:\"kitchen-appliances\";}i:1025;a:10:{s:26:\"master_category_section_id\";i:1026;s:18:\"master_category_id\";i:17;s:20:\"master_category_name\";s:13:\"HOME & LIVING\";s:20:\"master_category_slug\";s:11:\"home-living\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:823;s:13:\"category_name\";s:21:\"Electronics & Gadgets\";s:13:\"category_slug\";s:19:\"electronics-gadgets\";}i:1026;a:10:{s:26:\"master_category_section_id\";i:1027;s:18:\"master_category_id\";i:17;s:20:\"master_category_name\";s:13:\"HOME & LIVING\";s:20:\"master_category_slug\";s:11:\"home-living\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:824;s:13:\"category_name\";s:16:\"Luggage & Travel\";s:13:\"category_slug\";s:14:\"luggage-travel\";}i:1027;a:10:{s:26:\"master_category_section_id\";i:1028;s:18:\"master_category_id\";i:17;s:20:\"master_category_name\";s:13:\"HOME & LIVING\";s:20:\"master_category_slug\";s:11:\"home-living\";s:15:\"section_type_id\";i:105;s:17:\"section_type_name\";s:29:\"HOME STORAGE AND ORGANIZATION\";s:17:\"section_type_slug\";s:29:\"home-storage-and-organization\";s:11:\"category_id\";i:825;s:13:\"category_name\";s:35:\"Bathroom Accessories & Organisation\";s:13:\"category_slug\";s:33:\"bathroom-accessories-organisation\";}i:1028;a:10:{s:26:\"master_category_section_id\";i:1029;s:18:\"master_category_id\";i:17;s:20:\"master_category_name\";s:13:\"HOME & LIVING\";s:20:\"master_category_slug\";s:11:\"home-living\";s:15:\"section_type_id\";i:105;s:17:\"section_type_name\";s:29:\"HOME STORAGE AND ORGANIZATION\";s:17:\"section_type_slug\";s:29:\"home-storage-and-organization\";s:11:\"category_id\";i:826;s:13:\"category_name\";s:12:\"Home Storage\";s:13:\"category_slug\";s:12:\"home-storage\";}i:1029;a:10:{s:26:\"master_category_section_id\";i:1030;s:18:\"master_category_id\";i:17;s:20:\"master_category_name\";s:13:\"HOME & LIVING\";s:20:\"master_category_slug\";s:11:\"home-living\";s:15:\"section_type_id\";i:105;s:17:\"section_type_name\";s:29:\"HOME STORAGE AND ORGANIZATION\";s:17:\"section_type_slug\";s:29:\"home-storage-and-organization\";s:11:\"category_id\";i:827;s:13:\"category_name\";s:19:\"Closet Organisation\";s:13:\"category_slug\";s:19:\"closet-organisation\";}i:1030;a:10:{s:26:\"master_category_section_id\";i:1031;s:18:\"master_category_id\";i:17;s:20:\"master_category_name\";s:13:\"HOME & LIVING\";s:20:\"master_category_slug\";s:11:\"home-living\";s:15:\"section_type_id\";i:105;s:17:\"section_type_name\";s:29:\"HOME STORAGE AND ORGANIZATION\";s:17:\"section_type_slug\";s:29:\"home-storage-and-organization\";s:11:\"category_id\";i:828;s:13:\"category_name\";s:20:\"Laundry Organisation\";s:13:\"category_slug\";s:20:\"laundry-organisation\";}i:1031;a:10:{s:26:\"master_category_section_id\";i:1032;s:18:\"master_category_id\";i:17;s:20:\"master_category_name\";s:13:\"HOME & LIVING\";s:20:\"master_category_slug\";s:11:\"home-living\";s:15:\"section_type_id\";i:105;s:17:\"section_type_name\";s:29:\"HOME STORAGE AND ORGANIZATION\";s:17:\"section_type_slug\";s:29:\"home-storage-and-organization\";s:11:\"category_id\";i:829;s:13:\"category_name\";s:23:\"Racks Shelves & Drawers\";s:13:\"category_slug\";s:21:\"racks-shelves-drawers\";}i:1032;a:10:{s:26:\"master_category_section_id\";i:1033;s:18:\"master_category_id\";i:17;s:20:\"master_category_name\";s:13:\"HOME & LIVING\";s:20:\"master_category_slug\";s:11:\"home-living\";s:15:\"section_type_id\";i:106;s:17:\"section_type_name\";s:21:\"ELECTRONICS & GADGETS\";s:17:\"section_type_slug\";s:19:\"electronics-gadgets\";s:11:\"category_id\";i:830;s:13:\"category_name\";s:22:\"Headphones & Earphones\";s:13:\"category_slug\";s:20:\"headphones-earphones\";}i:1033;a:10:{s:26:\"master_category_section_id\";i:1034;s:18:\"master_category_id\";i:17;s:20:\"master_category_name\";s:13:\"HOME & LIVING\";s:20:\"master_category_slug\";s:11:\"home-living\";s:15:\"section_type_id\";i:106;s:17:\"section_type_name\";s:21:\"ELECTRONICS & GADGETS\";s:17:\"section_type_slug\";s:19:\"electronics-gadgets\";s:11:\"category_id\";i:479;s:13:\"category_name\";s:18:\"Bluetooth Speakers\";s:13:\"category_slug\";s:18:\"bluetooth-speakers\";}i:1034;a:10:{s:26:\"master_category_section_id\";i:1035;s:18:\"master_category_id\";i:17;s:20:\"master_category_name\";s:13:\"HOME & LIVING\";s:20:\"master_category_slug\";s:11:\"home-living\";s:15:\"section_type_id\";i:106;s:17:\"section_type_name\";s:21:\"ELECTRONICS & GADGETS\";s:17:\"section_type_slug\";s:19:\"electronics-gadgets\";s:11:\"category_id\";i:53;s:13:\"category_name\";s:13:\"Smart Watches\";s:13:\"category_slug\";s:13:\"smart-watches\";}i:1035;a:10:{s:26:\"master_category_section_id\";i:1036;s:18:\"master_category_id\";i:17;s:20:\"master_category_name\";s:13:\"HOME & LIVING\";s:20:\"master_category_slug\";s:11:\"home-living\";s:15:\"section_type_id\";i:106;s:17:\"section_type_name\";s:21:\"ELECTRONICS & GADGETS\";s:17:\"section_type_slug\";s:19:\"electronics-gadgets\";s:11:\"category_id\";i:831;s:13:\"category_name\";s:15:\"Digital Cameras\";s:13:\"category_slug\";s:15:\"digital-cameras\";}i:1036;a:10:{s:26:\"master_category_section_id\";i:1037;s:18:\"master_category_id\";i:17;s:20:\"master_category_name\";s:13:\"HOME & LIVING\";s:20:\"master_category_slug\";s:11:\"home-living\";s:15:\"section_type_id\";i:106;s:17:\"section_type_name\";s:21:\"ELECTRONICS & GADGETS\";s:17:\"section_type_slug\";s:19:\"electronics-gadgets\";s:11:\"category_id\";i:832;s:13:\"category_name\";s:20:\"Speakers & Soundbars\";s:13:\"category_slug\";s:18:\"speakers-soundbars\";}i:1037;a:10:{s:26:\"master_category_section_id\";i:1038;s:18:\"master_category_id\";i:17;s:20:\"master_category_name\";s:13:\"HOME & LIVING\";s:20:\"master_category_slug\";s:11:\"home-living\";s:15:\"section_type_id\";i:107;s:17:\"section_type_name\";s:15:\"HOME FURNISHING\";s:17:\"section_type_slug\";s:15:\"home-furnishing\";s:11:\"category_id\";i:833;s:13:\"category_name\";s:22:\"Curtains & Accessories\";s:13:\"category_slug\";s:20:\"curtains-accessories\";}i:1038;a:10:{s:26:\"master_category_section_id\";i:1039;s:18:\"master_category_id\";i:17;s:20:\"master_category_name\";s:13:\"HOME & LIVING\";s:20:\"master_category_slug\";s:11:\"home-living\";s:15:\"section_type_id\";i:107;s:17:\"section_type_name\";s:15:\"HOME FURNISHING\";s:17:\"section_type_slug\";s:15:\"home-furnishing\";s:11:\"category_id\";i:834;s:13:\"category_name\";s:14:\"Rugs & Carpets\";s:13:\"category_slug\";s:12:\"rugs-carpets\";}i:1039;a:10:{s:26:\"master_category_section_id\";i:1040;s:18:\"master_category_id\";i:17;s:20:\"master_category_name\";s:13:\"HOME & LIVING\";s:20:\"master_category_slug\";s:11:\"home-living\";s:15:\"section_type_id\";i:107;s:17:\"section_type_name\";s:15:\"HOME FURNISHING\";s:17:\"section_type_slug\";s:15:\"home-furnishing\";s:11:\"category_id\";i:835;s:13:\"category_name\";s:15:\"Bathroom Linens\";s:13:\"category_slug\";s:15:\"bathroom-linens\";}i:1040;a:10:{s:26:\"master_category_section_id\";i:1041;s:18:\"master_category_id\";i:17;s:20:\"master_category_name\";s:13:\"HOME & LIVING\";s:20:\"master_category_slug\";s:11:\"home-living\";s:15:\"section_type_id\";i:107;s:17:\"section_type_name\";s:15:\"HOME FURNISHING\";s:17:\"section_type_slug\";s:15:\"home-furnishing\";s:11:\"category_id\";i:836;s:13:\"category_name\";s:16:\"Bedding & Linens\";s:13:\"category_slug\";s:14:\"bedding-linens\";}i:1041;a:10:{s:26:\"master_category_section_id\";i:1042;s:18:\"master_category_id\";i:17;s:20:\"master_category_name\";s:13:\"HOME & LIVING\";s:20:\"master_category_slug\";s:11:\"home-living\";s:15:\"section_type_id\";i:108;s:17:\"section_type_name\";s:27:\"KITCHEN & DINING ESSENTIALS\";s:17:\"section_type_slug\";s:25:\"kitchen-dining-essentials\";s:11:\"category_id\";i:345;s:13:\"category_name\";s:9:\"Drinkware\";s:13:\"category_slug\";s:9:\"drinkware\";}i:1042;a:10:{s:26:\"master_category_section_id\";i:1043;s:18:\"master_category_id\";i:17;s:20:\"master_category_name\";s:13:\"HOME & LIVING\";s:20:\"master_category_slug\";s:11:\"home-living\";s:15:\"section_type_id\";i:108;s:17:\"section_type_name\";s:27:\"KITCHEN & DINING ESSENTIALS\";s:17:\"section_type_slug\";s:25:\"kitchen-dining-essentials\";s:11:\"category_id\";i:837;s:13:\"category_name\";s:10:\"Dinnerware\";s:13:\"category_slug\";s:10:\"dinnerware\";}i:1043;a:10:{s:26:\"master_category_section_id\";i:1044;s:18:\"master_category_id\";i:17;s:20:\"master_category_name\";s:13:\"HOME & LIVING\";s:20:\"master_category_slug\";s:11:\"home-living\";s:15:\"section_type_id\";i:108;s:17:\"section_type_name\";s:27:\"KITCHEN & DINING ESSENTIALS\";s:17:\"section_type_slug\";s:25:\"kitchen-dining-essentials\";s:11:\"category_id\";i:838;s:13:\"category_name\";s:19:\"Cookware & Bakeware\";s:13:\"category_slug\";s:17:\"cookware-bakeware\";}i:1044;a:10:{s:26:\"master_category_section_id\";i:1045;s:18:\"master_category_id\";i:17;s:20:\"master_category_name\";s:13:\"HOME & LIVING\";s:20:\"master_category_slug\";s:11:\"home-living\";s:15:\"section_type_id\";i:108;s:17:\"section_type_name\";s:27:\"KITCHEN & DINING ESSENTIALS\";s:17:\"section_type_slug\";s:25:\"kitchen-dining-essentials\";s:11:\"category_id\";i:839;s:13:\"category_name\";s:28:\"Kitchen Storage & Containers\";s:13:\"category_slug\";s:26:\"kitchen-storage-containers\";}i:1045;a:10:{s:26:\"master_category_section_id\";i:1046;s:18:\"master_category_id\";i:17;s:20:\"master_category_name\";s:13:\"HOME & LIVING\";s:20:\"master_category_slug\";s:11:\"home-living\";s:15:\"section_type_id\";i:108;s:17:\"section_type_name\";s:27:\"KITCHEN & DINING ESSENTIALS\";s:17:\"section_type_slug\";s:25:\"kitchen-dining-essentials\";s:11:\"category_id\";i:840;s:13:\"category_name\";s:16:\"Kitchen Textiles\";s:13:\"category_slug\";s:16:\"kitchen-textiles\";}i:1046;a:10:{s:26:\"master_category_section_id\";i:1047;s:18:\"master_category_id\";i:17;s:20:\"master_category_name\";s:13:\"HOME & LIVING\";s:20:\"master_category_slug\";s:11:\"home-living\";s:15:\"section_type_id\";i:108;s:17:\"section_type_name\";s:27:\"KITCHEN & DINING ESSENTIALS\";s:17:\"section_type_slug\";s:25:\"kitchen-dining-essentials\";s:11:\"category_id\";i:841;s:13:\"category_name\";s:13:\"Kitchen Tools\";s:13:\"category_slug\";s:13:\"kitchen-tools\";}i:1047;a:10:{s:26:\"master_category_section_id\";i:1048;s:18:\"master_category_id\";i:17;s:20:\"master_category_name\";s:13:\"HOME & LIVING\";s:20:\"master_category_slug\";s:11:\"home-living\";s:15:\"section_type_id\";i:109;s:17:\"section_type_name\";s:10:\"HOME DECOR\";s:17:\"section_type_slug\";s:10:\"home-decor\";s:11:\"category_id\";i:714;s:13:\"category_name\";s:10:\"Wall Decor\";s:13:\"category_slug\";s:10:\"wall-decor\";}i:1048;a:10:{s:26:\"master_category_section_id\";i:1049;s:18:\"master_category_id\";i:17;s:20:\"master_category_name\";s:13:\"HOME & LIVING\";s:20:\"master_category_slug\";s:11:\"home-living\";s:15:\"section_type_id\";i:109;s:17:\"section_type_name\";s:10:\"HOME DECOR\";s:17:\"section_type_slug\";s:10:\"home-decor\";s:11:\"category_id\";i:842;s:13:\"category_name\";s:8:\"Lighting\";s:13:\"category_slug\";s:8:\"lighting\";}i:1049;a:10:{s:26:\"master_category_section_id\";i:1050;s:18:\"master_category_id\";i:17;s:20:\"master_category_name\";s:13:\"HOME & LIVING\";s:20:\"master_category_slug\";s:11:\"home-living\";s:15:\"section_type_id\";i:109;s:17:\"section_type_name\";s:10:\"HOME DECOR\";s:17:\"section_type_slug\";s:10:\"home-decor\";s:11:\"category_id\";i:843;s:13:\"category_name\";s:5:\"Flora\";s:13:\"category_slug\";s:5:\"flora\";}i:1050;a:10:{s:26:\"master_category_section_id\";i:1051;s:18:\"master_category_id\";i:17;s:20:\"master_category_name\";s:13:\"HOME & LIVING\";s:20:\"master_category_slug\";s:11:\"home-living\";s:15:\"section_type_id\";i:109;s:17:\"section_type_name\";s:10:\"HOME DECOR\";s:17:\"section_type_slug\";s:10:\"home-decor\";s:11:\"category_id\";i:844;s:13:\"category_name\";s:14:\"Picture Frames\";s:13:\"category_slug\";s:14:\"picture-frames\";}i:1051;a:10:{s:26:\"master_category_section_id\";i:1052;s:18:\"master_category_id\";i:17;s:20:\"master_category_name\";s:13:\"HOME & LIVING\";s:20:\"master_category_slug\";s:11:\"home-living\";s:15:\"section_type_id\";i:109;s:17:\"section_type_name\";s:10:\"HOME DECOR\";s:17:\"section_type_slug\";s:10:\"home-decor\";s:11:\"category_id\";i:427;s:13:\"category_name\";s:6:\"Clocks\";s:13:\"category_slug\";s:6:\"clocks\";}i:1052;a:10:{s:26:\"master_category_section_id\";i:1053;s:18:\"master_category_id\";i:17;s:20:\"master_category_name\";s:13:\"HOME & LIVING\";s:20:\"master_category_slug\";s:11:\"home-living\";s:15:\"section_type_id\";i:109;s:17:\"section_type_name\";s:10:\"HOME DECOR\";s:17:\"section_type_slug\";s:10:\"home-decor\";s:11:\"category_id\";i:845;s:13:\"category_name\";s:7:\"Mirrors\";s:13:\"category_slug\";s:7:\"mirrors\";}i:1053;a:10:{s:26:\"master_category_section_id\";i:1054;s:18:\"master_category_id\";i:17;s:20:\"master_category_name\";s:13:\"HOME & LIVING\";s:20:\"master_category_slug\";s:11:\"home-living\";s:15:\"section_type_id\";i:109;s:17:\"section_type_name\";s:10:\"HOME DECOR\";s:17:\"section_type_slug\";s:10:\"home-decor\";s:11:\"category_id\";i:846;s:13:\"category_name\";s:24:\"Candles & Candle Holders\";s:13:\"category_slug\";s:22:\"candles-candle-holders\";}i:1054;a:10:{s:26:\"master_category_section_id\";i:1055;s:18:\"master_category_id\";i:17;s:20:\"master_category_name\";s:13:\"HOME & LIVING\";s:20:\"master_category_slug\";s:11:\"home-living\";s:15:\"section_type_id\";i:109;s:17:\"section_type_name\";s:10:\"HOME DECOR\";s:17:\"section_type_slug\";s:10:\"home-decor\";s:11:\"category_id\";i:847;s:13:\"category_name\";s:22:\"Decorative Accessories\";s:13:\"category_slug\";s:22:\"decorative-accessories\";}i:1055;a:10:{s:26:\"master_category_section_id\";i:1056;s:18:\"master_category_id\";i:17;s:20:\"master_category_name\";s:13:\"HOME & LIVING\";s:20:\"master_category_slug\";s:11:\"home-living\";s:15:\"section_type_id\";i:110;s:17:\"section_type_name\";s:27:\"KITCHEN AND HOME APPLIANCES\";s:17:\"section_type_slug\";s:27:\"kitchen-and-home-appliances\";s:11:\"category_id\";i:848;s:13:\"category_name\";s:14:\"Mixer Grinders\";s:13:\"category_slug\";s:14:\"mixer-grinders\";}i:1056;a:10:{s:26:\"master_category_section_id\";i:1057;s:18:\"master_category_id\";i:17;s:20:\"master_category_name\";s:13:\"HOME & LIVING\";s:20:\"master_category_slug\";s:11:\"home-living\";s:15:\"section_type_id\";i:110;s:17:\"section_type_name\";s:27:\"KITCHEN AND HOME APPLIANCES\";s:17:\"section_type_slug\";s:27:\"kitchen-and-home-appliances\";s:11:\"category_id\";i:849;s:13:\"category_name\";s:18:\"Juicers & Blenders\";s:13:\"category_slug\";s:16:\"juicers-blenders\";}i:1057;a:10:{s:26:\"master_category_section_id\";i:1058;s:18:\"master_category_id\";i:17;s:20:\"master_category_name\";s:13:\"HOME & LIVING\";s:20:\"master_category_slug\";s:11:\"home-living\";s:15:\"section_type_id\";i:110;s:17:\"section_type_name\";s:27:\"KITCHEN AND HOME APPLIANCES\";s:17:\"section_type_slug\";s:27:\"kitchen-and-home-appliances\";s:11:\"category_id\";i:850;s:13:\"category_name\";s:26:\"Toasters & Sandwich Makers\";s:13:\"category_slug\";s:24:\"toasters-sandwich-makers\";}i:1058;a:10:{s:26:\"master_category_section_id\";i:1059;s:18:\"master_category_id\";i:17;s:20:\"master_category_name\";s:13:\"HOME & LIVING\";s:20:\"master_category_slug\";s:11:\"home-living\";s:15:\"section_type_id\";i:110;s:17:\"section_type_name\";s:27:\"KITCHEN AND HOME APPLIANCES\";s:17:\"section_type_slug\";s:27:\"kitchen-and-home-appliances\";s:11:\"category_id\";i:851;s:13:\"category_name\";s:42:\"Coffee Maker, Air Fryer & Electric Kettles\";s:13:\"category_slug\";s:39:\"coffee-maker-air-fryer-electric-kettles\";}i:1059;a:10:{s:26:\"master_category_section_id\";i:1060;s:18:\"master_category_id\";i:17;s:20:\"master_category_name\";s:13:\"HOME & LIVING\";s:20:\"master_category_slug\";s:11:\"home-living\";s:15:\"section_type_id\";i:110;s:17:\"section_type_name\";s:27:\"KITCHEN AND HOME APPLIANCES\";s:17:\"section_type_slug\";s:27:\"kitchen-and-home-appliances\";s:11:\"category_id\";i:852;s:13:\"category_name\";s:13:\"Dehumidifiers\";s:13:\"category_slug\";s:13:\"dehumidifiers\";}i:1060;a:10:{s:26:\"master_category_section_id\";i:1061;s:18:\"master_category_id\";i:17;s:20:\"master_category_name\";s:13:\"HOME & LIVING\";s:20:\"master_category_slug\";s:11:\"home-living\";s:15:\"section_type_id\";i:111;s:17:\"section_type_name\";s:25:\"HANDBAGS PURSES & WALLETS\";s:17:\"section_type_slug\";s:23:\"handbags-purses-wallets\";s:11:\"category_id\";i:853;s:13:\"category_name\";s:16:\"Bags & Backpacks\";s:13:\"category_slug\";s:14:\"bags-backpacks\";}i:1061;a:10:{s:26:\"master_category_section_id\";i:1062;s:18:\"master_category_id\";i:17;s:20:\"master_category_name\";s:13:\"HOME & LIVING\";s:20:\"master_category_slug\";s:11:\"home-living\";s:15:\"section_type_id\";i:111;s:17:\"section_type_name\";s:25:\"HANDBAGS PURSES & WALLETS\";s:17:\"section_type_slug\";s:23:\"handbags-purses-wallets\";s:11:\"category_id\";i:854;s:13:\"category_name\";s:30:\"Travel Bags, Kits & Organisers\";s:13:\"category_slug\";s:27:\"travel-bags-kits-organisers\";}i:1062;a:10:{s:26:\"master_category_section_id\";i:1063;s:18:\"master_category_id\";i:17;s:20:\"master_category_name\";s:13:\"HOME & LIVING\";s:20:\"master_category_slug\";s:11:\"home-living\";s:15:\"section_type_id\";i:111;s:17:\"section_type_name\";s:25:\"HANDBAGS PURSES & WALLETS\";s:17:\"section_type_slug\";s:23:\"handbags-purses-wallets\";s:11:\"category_id\";i:855;s:13:\"category_name\";s:14:\"Travel Luggage\";s:13:\"category_slug\";s:14:\"travel-luggage\";}i:1063;a:10:{s:26:\"master_category_section_id\";i:1064;s:18:\"master_category_id\";i:18;s:20:\"master_category_name\";s:8:\"CARTER\'S\";s:20:\"master_category_slug\";s:7:\"carters\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:856;s:13:\"category_name\";s:19:\"Bodysuits & Rompers\";s:13:\"category_slug\";s:17:\"bodysuits-rompers\";}i:1064;a:10:{s:26:\"master_category_section_id\";i:1065;s:18:\"master_category_id\";i:18;s:20:\"master_category_name\";s:8:\"CARTER\'S\";s:20:\"master_category_slug\";s:7:\"carters\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:857;s:13:\"category_name\";s:12:\"Sets & Suits\";s:13:\"category_slug\";s:10:\"sets-suits\";}i:1065;a:10:{s:26:\"master_category_section_id\";i:1066;s:18:\"master_category_id\";i:18;s:20:\"master_category_name\";s:8:\"CARTER\'S\";s:20:\"master_category_slug\";s:7:\"carters\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:7;s:13:\"category_name\";s:9:\"Nightwear\";s:13:\"category_slug\";s:9:\"nightwear\";}i:1066;a:10:{s:26:\"master_category_section_id\";i:1067;s:18:\"master_category_id\";i:18;s:20:\"master_category_name\";s:8:\"CARTER\'S\";s:20:\"master_category_slug\";s:7:\"carters\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:858;s:13:\"category_name\";s:7:\"Topwear\";s:13:\"category_slug\";s:7:\"topwear\";}i:1067;a:10:{s:26:\"master_category_section_id\";i:1068;s:18:\"master_category_id\";i:18;s:20:\"master_category_name\";s:8:\"CARTER\'S\";s:20:\"master_category_slug\";s:7:\"carters\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:859;s:13:\"category_name\";s:6:\"Frocks\";s:13:\"category_slug\";s:6:\"frocks\";}i:1068;a:10:{s:26:\"master_category_section_id\";i:1069;s:18:\"master_category_id\";i:18;s:20:\"master_category_name\";s:8:\"CARTER\'S\";s:20:\"master_category_slug\";s:7:\"carters\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:860;s:13:\"category_name\";s:6:\"Shirts\";s:13:\"category_slug\";s:6:\"shirts\";}i:1069;a:10:{s:26:\"master_category_section_id\";i:1070;s:18:\"master_category_id\";i:18;s:20:\"master_category_name\";s:8:\"CARTER\'S\";s:20:\"master_category_slug\";s:7:\"carters\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:861;s:13:\"category_name\";s:18:\"Pajamas & Leggings\";s:13:\"category_slug\";s:16:\"pajamas-leggings\";}i:1070;a:10:{s:26:\"master_category_section_id\";i:1071;s:18:\"master_category_id\";i:18;s:20:\"master_category_name\";s:8:\"CARTER\'S\";s:20:\"master_category_slug\";s:7:\"carters\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:862;s:13:\"category_name\";s:22:\"Shorts, Skirts & Jeans\";s:13:\"category_slug\";s:19:\"shorts-skirts-jeans\";}i:1071;a:10:{s:26:\"master_category_section_id\";i:1072;s:18:\"master_category_id\";i:18;s:20:\"master_category_name\";s:8:\"CARTER\'S\";s:20:\"master_category_slug\";s:7:\"carters\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:863;s:13:\"category_name\";s:8:\"Swimwear\";s:13:\"category_slug\";s:8:\"swimwear\";}i:1072;a:10:{s:26:\"master_category_section_id\";i:1073;s:18:\"master_category_id\";i:18;s:20:\"master_category_name\";s:8:\"CARTER\'S\";s:20:\"master_category_slug\";s:7:\"carters\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:864;s:13:\"category_name\";s:21:\"Sweatshirts & Jackets\";s:13:\"category_slug\";s:19:\"sweatshirts-jackets\";}i:1073;a:10:{s:26:\"master_category_section_id\";i:1074;s:18:\"master_category_id\";i:18;s:20:\"master_category_name\";s:8:\"CARTER\'S\";s:20:\"master_category_slug\";s:7:\"carters\";s:15:\"section_type_id\";i:1;s:17:\"section_type_name\";s:16:\"SHOP BY CATEGORY\";s:17:\"section_type_slug\";s:16:\"shop-by-category\";s:11:\"category_id\";i:26;s:13:\"category_name\";s:8:\"Sweaters\";s:13:\"category_slug\";s:8:\"sweaters\";}i:1074;a:10:{s:26:\"master_category_section_id\";i:1075;s:18:\"master_category_id\";i:18;s:20:\"master_category_name\";s:8:\"CARTER\'S\";s:20:\"master_category_slug\";s:7:\"carters\";s:15:\"section_type_id\";i:112;s:17:\"section_type_name\";s:14:\"SHOP BY GENDER\";s:17:\"section_type_slug\";s:14:\"shop-by-gender\";s:11:\"category_id\";i:865;s:13:\"category_name\";s:21:\"Baby Girl (0-2 years)\";s:13:\"category_slug\";s:19:\"baby-girl-0-2-years\";}i:1075;a:10:{s:26:\"master_category_section_id\";i:1076;s:18:\"master_category_id\";i:18;s:20:\"master_category_name\";s:8:\"CARTER\'S\";s:20:\"master_category_slug\";s:7:\"carters\";s:15:\"section_type_id\";i:112;s:17:\"section_type_name\";s:14:\"SHOP BY GENDER\";s:17:\"section_type_slug\";s:14:\"shop-by-gender\";s:11:\"category_id\";i:866;s:13:\"category_name\";s:20:\"Baby Boy (0-2 years)\";s:13:\"category_slug\";s:18:\"baby-boy-0-2-years\";}i:1076;a:10:{s:26:\"master_category_section_id\";i:1077;s:18:\"master_category_id\";i:18;s:20:\"master_category_name\";s:8:\"CARTER\'S\";s:20:\"master_category_slug\";s:7:\"carters\";s:15:\"section_type_id\";i:112;s:17:\"section_type_name\";s:14:\"SHOP BY GENDER\";s:17:\"section_type_slug\";s:14:\"shop-by-gender\";s:11:\"category_id\";i:867;s:13:\"category_name\";s:15:\"Girl (2+ years)\";s:13:\"category_slug\";s:12:\"girl-2-years\";}i:1077;a:10:{s:26:\"master_category_section_id\";i:1078;s:18:\"master_category_id\";i:18;s:20:\"master_category_name\";s:8:\"CARTER\'S\";s:20:\"master_category_slug\";s:7:\"carters\";s:15:\"section_type_id\";i:112;s:17:\"section_type_name\";s:14:\"SHOP BY GENDER\";s:17:\"section_type_slug\";s:14:\"shop-by-gender\";s:11:\"category_id\";i:868;s:13:\"category_name\";s:14:\"Boy (2+ years)\";s:13:\"category_slug\";s:11:\"boy-2-years\";}i:1078;a:10:{s:26:\"master_category_section_id\";i:1079;s:18:\"master_category_id\";i:18;s:20:\"master_category_name\";s:8:\"CARTER\'S\";s:20:\"master_category_slug\";s:7:\"carters\";s:15:\"section_type_id\";i:3;s:17:\"section_type_name\";s:11:\"SHOP BY AGE\";s:17:\"section_type_slug\";s:11:\"shop-by-age\";s:11:\"category_id\";i:38;s:13:\"category_name\";s:16:\"New Born (0-3 M)\";s:13:\"category_slug\";s:14:\"new-born-0-3-m\";}i:1079;a:10:{s:26:\"master_category_section_id\";i:1080;s:18:\"master_category_id\";i:18;s:20:\"master_category_name\";s:8:\"CARTER\'S\";s:20:\"master_category_slug\";s:7:\"carters\";s:15:\"section_type_id\";i:3;s:17:\"section_type_name\";s:11:\"SHOP BY AGE\";s:17:\"section_type_slug\";s:11:\"shop-by-age\";s:11:\"category_id\";i:869;s:13:\"category_name\";s:12:\"3 - 6 Months\";s:13:\"category_slug\";s:10:\"3-6-months\";}i:1080;a:10:{s:26:\"master_category_section_id\";i:1081;s:18:\"master_category_id\";i:18;s:20:\"master_category_name\";s:8:\"CARTER\'S\";s:20:\"master_category_slug\";s:7:\"carters\";s:15:\"section_type_id\";i:3;s:17:\"section_type_name\";s:11:\"SHOP BY AGE\";s:17:\"section_type_slug\";s:11:\"shop-by-age\";s:11:\"category_id\";i:870;s:13:\"category_name\";s:12:\"6 - 9 Months\";s:13:\"category_slug\";s:10:\"6-9-months\";}i:1081;a:10:{s:26:\"master_category_section_id\";i:1082;s:18:\"master_category_id\";i:18;s:20:\"master_category_name\";s:8:\"CARTER\'S\";s:20:\"master_category_slug\";s:7:\"carters\";s:15:\"section_type_id\";i:3;s:17:\"section_type_name\";s:11:\"SHOP BY AGE\";s:17:\"section_type_slug\";s:11:\"shop-by-age\";s:11:\"category_id\";i:871;s:13:\"category_name\";s:13:\"9 - 12 Months\";s:13:\"category_slug\";s:11:\"9-12-months\";}i:1082;a:10:{s:26:\"master_category_section_id\";i:1083;s:18:\"master_category_id\";i:18;s:20:\"master_category_name\";s:8:\"CARTER\'S\";s:20:\"master_category_slug\";s:7:\"carters\";s:15:\"section_type_id\";i:3;s:17:\"section_type_name\";s:11:\"SHOP BY AGE\";s:17:\"section_type_slug\";s:11:\"shop-by-age\";s:11:\"category_id\";i:872;s:13:\"category_name\";s:14:\"12 - 18 Months\";s:13:\"category_slug\";s:12:\"12-18-months\";}i:1083;a:10:{s:26:\"master_category_section_id\";i:1084;s:18:\"master_category_id\";i:18;s:20:\"master_category_name\";s:8:\"CARTER\'S\";s:20:\"master_category_slug\";s:7:\"carters\";s:15:\"section_type_id\";i:3;s:17:\"section_type_name\";s:11:\"SHOP BY AGE\";s:17:\"section_type_slug\";s:11:\"shop-by-age\";s:11:\"category_id\";i:873;s:13:\"category_name\";s:14:\"18 - 24 Months\";s:13:\"category_slug\";s:12:\"18-24-months\";}i:1084;a:10:{s:26:\"master_category_section_id\";i:1085;s:18:\"master_category_id\";i:18;s:20:\"master_category_name\";s:8:\"CARTER\'S\";s:20:\"master_category_slug\";s:7:\"carters\";s:15:\"section_type_id\";i:3;s:17:\"section_type_name\";s:11:\"SHOP BY AGE\";s:17:\"section_type_slug\";s:11:\"shop-by-age\";s:11:\"category_id\";i:874;s:13:\"category_name\";s:11:\"2 - 4 Years\";s:13:\"category_slug\";s:9:\"2-4-years\";}i:1085;a:10:{s:26:\"master_category_section_id\";i:1086;s:18:\"master_category_id\";i:18;s:20:\"master_category_name\";s:8:\"CARTER\'S\";s:20:\"master_category_slug\";s:7:\"carters\";s:15:\"section_type_id\";i:3;s:17:\"section_type_name\";s:11:\"SHOP BY AGE\";s:17:\"section_type_slug\";s:11:\"shop-by-age\";s:11:\"category_id\";i:875;s:13:\"category_name\";s:8:\"4+ Years\";s:13:\"category_slug\";s:7:\"4-years\";}i:1086;a:10:{s:26:\"master_category_section_id\";i:1129;s:18:\"master_category_id\";i:1;s:20:\"master_category_name\";s:11:\"BOY FASHION\";s:20:\"master_category_slug\";s:11:\"boy-fashion\";s:15:\"section_type_id\";i:7;s:17:\"section_type_name\";s:14:\"SHOP BY BRANDS\";s:17:\"section_type_slug\";s:14:\"shop-by-brands\";s:11:\"category_id\";i:876;s:13:\"category_name\";s:5:\"Gucci\";s:13:\"category_slug\";s:5:\"gucci\";}i:1087;a:10:{s:26:\"master_category_section_id\";i:1130;s:18:\"master_category_id\";i:2;s:20:\"master_category_name\";s:12:\"GIRL FASHION\";s:20:\"master_category_slug\";s:12:\"girl-fashion\";s:15:\"section_type_id\";i:7;s:17:\"section_type_name\";s:14:\"SHOP BY BRANDS\";s:17:\"section_type_slug\";s:14:\"shop-by-brands\";s:11:\"category_id\";i:876;s:13:\"category_name\";s:5:\"Gucci\";s:13:\"category_slug\";s:5:\"gucci\";}}', 2097147789);
INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('cuddlyduddly-cache-site_settings', 'a:28:{s:25:\"allow_seller_registration\";s:1:\"0\";s:18:\"require_seller_kyc\";s:1:\"0\";s:27:\"allow_customer_registration\";s:1:\"0\";s:20:\"allow_guest_checkout\";s:1:\"0\";s:22:\"notify_admin_new_order\";s:1:\"0\";s:23:\"notify_seller_new_order\";s:1:\"0\";s:29:\"notify_customer_status_update\";s:1:\"0\";s:26:\"enable_email_notifications\";s:1:\"0\";s:27:\"allow_multiple_admin_logins\";s:1:\"1\";s:13:\"platform_name\";s:12:\"CuddlyDuddly\";s:13:\"support_email\";s:24:\"support@cuddlyduddly.com\";s:13:\"support_phone\";s:11:\"98657412305\";s:16:\"business_address\";s:37:\"Webel More , Salt Lake , Bidhan Nagar\";s:26:\"default_commission_percent\";s:2:\"10\";s:23:\"session_timeout_minutes\";s:3:\"120\";s:12:\"store_status\";s:6:\"active\";s:19:\"maintenance_message\";s:19:\"We\'ll be back soon.\";s:20:\"frontend_maintenance\";s:6:\"active\";s:18:\"seller_maintenance\";s:6:\"active\";s:19:\"auto_payout_enabled\";s:1:\"0\";s:22:\"auto_payout_delay_days\";s:1:\"0\";s:24:\"minimum_payout_threshold\";s:5:\"10000\";s:30:\"auto_refund_on_order_rejection\";s:1:\"1\";s:27:\"refund_needs_admin_approval\";s:1:\"0\";s:22:\"hold_payout_on_dispute\";s:1:\"0\";s:26:\"dispute_hold_duration_days\";s:1:\"0\";s:24:\"deduct_gst_on_commission\";s:1:\"0\";s:20:\"platform_gst_percent\";s:1:\"0\";}', 1783056251);

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `carts`
--

CREATE TABLE `carts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `variant_id` bigint(20) DEFAULT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `is_ordered` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `carts`
--

INSERT INTO `carts` (`id`, `user_id`, `product_id`, `variant_id`, `quantity`, `is_ordered`, `created_at`, `updated_at`) VALUES
(1, 19, 19, NULL, 1, 0, '2025-11-17 02:19:22', '2025-11-17 02:19:22'),
(2, 19, 22, NULL, 2, 1, '2025-11-17 02:19:28', '2025-11-17 02:19:28'),
(14, 27, 79, 101, 2, 0, '2026-04-13 10:59:40', '2026-04-13 10:59:48');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(15) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `product_categories_id` bigint(20) UNSIGNED DEFAULT NULL,
  `description` text DEFAULT NULL,
  `image_url` varchar(512) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `slug`, `product_categories_id`, `description`, `image_url`) VALUES
(1, 'Sets & Suits', 'sets-suits', 5, NULL, NULL),
(2, 'T-shirts', 't-shirts', 5, NULL, NULL),
(3, 'Shirts', 'shirts', 5, NULL, NULL),
(4, 'Shorts', 'shorts', 5, NULL, NULL),
(5, 'Jeans & Trousers', 'jeans-trousers', 5, NULL, NULL),
(6, 'Night Shorts Sets', 'night-shorts-sets', 5, NULL, NULL),
(7, 'Nightwear', 'nightwear', 5, NULL, NULL),
(8, 'Lounge & Trackpants', 'lounge-trackpants', 5, NULL, NULL),
(9, 'Onesies & Rompers', 'onesies-rompers', 5, NULL, NULL),
(10, 'Diaper & Bootie Leggings', 'diaper-bootie-leggings', 5, NULL, NULL),
(11, 'Rainwear', 'rainwear', 5, NULL, NULL),
(12, 'Party Wear', 'party-wear', 5, NULL, NULL),
(13, 'Ethnic Wear', 'ethnic-wear', 5, NULL, NULL),
(14, 'Swim Wear', 'swim-wear', 5, NULL, NULL),
(15, 'Athleisure & Sportswear', 'athleisure-sportswear', 5, NULL, NULL),
(16, 'Vests', 'vests', 5, NULL, NULL),
(17, 'Briefs & Boxers', 'briefs-boxers', 5, NULL, NULL),
(18, 'Inner Wear', 'inner-wear', 5, NULL, NULL),
(19, 'Summer Caps', 'summer-caps', 5, NULL, NULL),
(20, 'Bath Time', 'bath-time', 5, NULL, NULL),
(21, 'Socks', 'socks', 5, NULL, NULL),
(22, 'Caps, Mittens & Booties', 'caps-mittens-booties', 5, NULL, NULL),
(23, 'Thermals', 'thermals', 5, NULL, NULL),
(24, 'Sweatshirts', 'sweatshirts', 5, NULL, NULL),
(25, 'Jackets', 'jackets', 5, NULL, NULL),
(26, 'Sweaters', 'sweaters', 5, NULL, NULL),
(27, 'Winter Sets', 'winter-sets', 5, NULL, NULL),
(28, 'Fleece Bottoms', 'fleece-bottoms', 5, NULL, NULL),
(29, 'Woolen Caps & Ear Muffs', 'woolen-caps-ear-muffs', 5, NULL, NULL),
(30, 'Winter Nightwear', 'winter-nightwear', 5, NULL, NULL),
(31, 'Gloves', 'gloves', 5, NULL, NULL),
(32, 'Theme Costumes', 'theme-costumes', 5, NULL, NULL),
(33, 'Splash in Summer', 'splash-in-summer', 5, NULL, NULL),
(34, 'Bestsellers', 'bestsellers', 5, NULL, NULL),
(35, 'Multi-packs', 'multi-packs', 5, NULL, NULL),
(36, 'Baby Essentials', 'baby-essentials', 5, NULL, NULL),
(37, 'Preemie/Tine Preemie', 'preemietine-preemie', 5, NULL, NULL),
(38, 'New Born (0-3 M)', 'new-born-0-3-m', 5, NULL, NULL),
(39, '3-6 Months', '3-6-months', 5, NULL, NULL),
(40, '6-9 Months', '6-9-months', 5, NULL, NULL),
(41, '9-12 Months', '9-12-months', 5, NULL, NULL),
(42, '12-18 Months', '12-18-months', 5, NULL, NULL),
(43, '18-24 Months', '18-24-months', 5, NULL, NULL),
(44, '2 to 4 Years', '2-to-4-years', 5, NULL, NULL),
(45, '4 to 6 Years', '4-to-6-years', 5, NULL, NULL),
(46, '6 to 8 Years', '6-to-8-years', 5, NULL, NULL),
(47, '8+ Years', '8-years', 5, NULL, NULL),
(48, 'Sunglasses', 'sunglasses', 5, NULL, NULL),
(49, 'Kids Umbrellas', 'kids-umbrellas', 5, NULL, NULL),
(50, 'Watches', 'watches', 5, NULL, NULL),
(51, 'Ties, Belts & Suspenders', 'ties-belts-suspenders', 5, NULL, NULL),
(52, 'Bags', 'bags', 5, NULL, NULL),
(53, 'Smart Watches', 'smart-watches', 5, NULL, NULL),
(54, 'Flip Flops', 'flip-flops', 5, NULL, NULL),
(55, 'Clogs', 'clogs', 5, NULL, NULL),
(56, 'Sandals', 'sandals', 5, NULL, NULL),
(57, 'Pool Shoes', 'pool-shoes', 5, NULL, NULL),
(58, 'Casual Shoes', 'casual-shoes', 5, NULL, NULL),
(59, 'Sports Shoes', 'sports-shoes', 5, NULL, NULL),
(60, 'Sneakers', 'sneakers', 5, NULL, NULL),
(61, 'Formal & Partywear', 'formal-partywear', 5, NULL, NULL),
(62, 'Winter Boots', 'winter-boots', 5, NULL, NULL),
(63, 'Booties', 'booties', 5, NULL, NULL),
(64, 'School Shoes', 'school-shoes', 5, NULL, NULL),
(65, 'LED Shoes', 'led-shoes', 5, NULL, NULL),
(66, 'Mojaris/Ethnic Footwear', 'mojarisethnic-footwear', 5, NULL, NULL),
(67, 'All Under 199', 'all-under-199', 5, NULL, NULL),
(68, 'All Under 299', 'all-under-299', 5, NULL, NULL),
(69, 'All Under 399', 'all-under-399', 5, NULL, NULL),
(70, 'All Under 499', 'all-under-499', 5, NULL, NULL),
(71, 'Babyhug', 'babyhug', 5, NULL, NULL),
(72, 'Babyoye', 'babyoye', 5, NULL, NULL),
(73, 'Kookie Kids', 'kookie-kids', 5, NULL, NULL),
(74, 'Carter\'s', 'carters', 5, NULL, NULL),
(75, 'Pine Kids', 'pine-kids', 5, NULL, NULL),
(76, 'Cute Walk', 'cute-walk', 5, NULL, NULL),
(77, 'Honeyhap', 'honeyhap', 5, NULL, NULL),
(78, 'OLLINGTON ST.', 'ollington-st', 5, NULL, NULL),
(79, 'Doodle Poodle', 'doodle-poodle', 5, NULL, NULL),
(80, 'Primo Gino', 'primo-gino', 5, NULL, NULL),
(81, 'Mark & Mia', 'mark-mia', 5, NULL, NULL),
(82, 'Bonfino', 'bonfino', 5, NULL, NULL),
(83, 'Earthy Touch', 'earthy-touch', 5, NULL, NULL),
(84, 'Arias by Lara Dutta', 'arias-by-lara-dutta', 5, NULL, NULL),
(85, 'Pine Active', 'pine-active', 5, NULL, NULL),
(86, 'ToffyHouse', 'toffyhouse', 5, NULL, NULL),
(87, 'Taffykids', 'taffykids', 5, NULL, NULL),
(88, 'Ed-a-mamma', 'ed-a-mamma', 5, NULL, NULL),
(89, 'UCB', 'ucb', 5, NULL, NULL),
(90, 'U.S. Polo Assn. Kids', 'us-polo-assn-kids', 5, NULL, NULL),
(91, 'Monte Carlo', 'monte-carlo', 5, NULL, NULL),
(92, 'Gini & Jony', 'gini-jony', 5, NULL, NULL),
(93, 'Puma', 'puma', 5, NULL, NULL),
(94, 'Tommy Hilfiger', 'tommy-hilfiger', 5, NULL, NULL),
(95, 'ADIDAS KIDS', 'adidas-kids', 5, NULL, NULL),
(96, 'RUFF', 'ruff', 5, NULL, NULL),
(97, 'ASICS Kids', 'asics-kids', 5, NULL, NULL),
(98, 'Frocks & Dresses', 'frocks-dresses', 5, NULL, NULL),
(99, 'Tops', 'tops', 5, NULL, NULL),
(100, 'Tshirts', 'tshirts', 5, NULL, NULL),
(101, 'Shorts & Skirts', 'shorts-skirts', 5, NULL, NULL),
(102, 'Pajamas & Track Pants', 'pajamas-track-pants', 5, NULL, NULL),
(103, 'Leggings', 'leggings', 5, NULL, NULL),
(104, 'Bootie & Diaper Leggings', 'bootie-diaper-leggings', 5, NULL, NULL),
(105, 'Slips & Bralettes', 'slips-bralettes', 5, NULL, NULL),
(106, 'Panties & Bloomers', 'panties-bloomers', 5, NULL, NULL),
(107, 'Socks & Tights', 'socks-tights', 5, NULL, NULL),
(108, 'Sweaters', 'sweaters', 5, NULL, NULL),
(109, 'Hair Bands', 'hair-bands', 5, NULL, NULL),
(110, 'Hair Clips & Rubber Bands', 'hair-clips-rubber-bands', 5, NULL, NULL),
(111, 'Jewellery', 'jewellery', 5, NULL, NULL),
(112, 'Belts', 'belts', 5, NULL, NULL),
(113, 'Woolen Caps & Ear Muffs', 'woolen-caps-ear-muffs', 5, NULL, NULL),
(114, 'Gloves', 'gloves', 5, NULL, NULL),
(115, 'Ballerinas', 'ballerinas', 5, NULL, NULL),
(116, 'Cutewalk', 'cutewalk', 5, NULL, NULL),
(117, 'Hola Bonita', 'hola-bonita', 5, NULL, NULL),
(118, 'Global Desi', 'global-desi', 5, NULL, NULL),
(119, 'And Girl', 'and-girl', 5, NULL, NULL),
(120, 'NIKE', 'nike', 5, NULL, NULL),
(121, 'Formal & Party Wear', 'formal-party-wear', 5, NULL, NULL),
(122, 'Sock Shoes', 'sock-shoes', 5, NULL, NULL),
(123, 'Stockings & Tights', 'stockings-tights', 5, NULL, NULL),
(124, 'Pinekids', 'pinekids', 5, NULL, NULL),
(125, 'Skechers', 'skechers', 5, NULL, NULL),
(126, 'Campus', 'campus', 5, NULL, NULL),
(127, 'Kazarmax', 'kazarmax', 5, NULL, NULL),
(128, 'Musical Toys', 'musical-toys', 5, NULL, NULL),
(129, 'Learning & Educational Toys', 'learning-educational-toys', 5, NULL, NULL),
(130, 'Soft Toys', 'soft-toys', 5, NULL, NULL),
(131, 'Indoor & Outdoor Play', 'indoor-outdoor-play', 5, NULL, NULL),
(132, 'Play Gyms & Playmats', 'play-gyms-playmats', 5, NULL, NULL),
(133, 'Sports & Games', 'sports-games', 5, NULL, NULL),
(134, 'Role & Pretend Play Toys', 'role-pretend-play-toys', 5, NULL, NULL),
(135, 'Blocks & Construction Sets', 'blocks-construction-sets', 5, NULL, NULL),
(136, 'Stacking Toys', 'stacking-toys', 5, NULL, NULL),
(137, 'Kids Puzzles', 'kids-puzzles', 5, NULL, NULL),
(138, 'Baby Rattles', 'baby-rattles', 5, NULL, NULL),
(139, 'Toys Cars Trains & Vehicles', 'toys-cars-trains-vehicles', 5, NULL, NULL),
(140, 'Kids Musical Instruments', 'kids-musical-instruments', 5, NULL, NULL),
(141, 'Dolls & Dollhouses', 'dolls-dollhouses', 5, NULL, NULL),
(142, 'Push & Pull Along Toys', 'push-pull-along-toys', 5, NULL, NULL),
(143, 'Art Crafts & Hobby Kits', 'art-crafts-hobby-kits', 5, NULL, NULL),
(144, 'Board Games', 'board-games', 11, NULL, NULL),
(145, 'Action Figures & Collectibles', 'action-figures-collectibles', 5, NULL, NULL),
(146, 'Radio & Remote Control Toys', 'radio-remote-control-toys', 5, NULL, NULL),
(147, 'Bath Toys', 'bath-toys', 5, NULL, NULL),
(148, 'Toys Guns & Weapons', 'toys-guns-weapons', 5, NULL, NULL),
(149, 'PC Games & Gaming Consoles', 'pc-games-gaming-consoles', 5, NULL, NULL),
(150, 'Kids Gadgets', 'kids-gadgets', 5, NULL, NULL),
(151, 'Battery Operated Ride-ons', 'battery-operated-ride-ons', 1, NULL, NULL),
(152, 'Manual Push Ride-ons', 'manual-push-ride-ons', 1, NULL, NULL),
(153, 'Swing cars/twisters', 'swing-carstwisters', 1, NULL, NULL),
(154, 'Scooters', 'scooters', 1, NULL, NULL),
(155, 'Rocking Ride Ons', 'rocking-ride-ons', 1, NULL, NULL),
(156, 'Tricycles', 'tricycles', 1, NULL, NULL),
(157, 'Bicycles', 'bicycles', 1, NULL, NULL),
(158, 'Balance Bike', 'balance-bike', 1, NULL, NULL),
(159, 'Play Dough, Sand & Moulds', 'play-dough-sand-moulds', 1, NULL, NULL),
(160, 'Coloring, Sequencing & Engraving Art', 'coloring-sequencing-engraving-art', 1, NULL, NULL),
(161, 'Activity Kit', 'activity-kit', 1, NULL, NULL),
(162, 'Building Construction Sets', 'building-construction-sets', 1, NULL, NULL),
(163, 'Multi Model Making Sets', 'multi-model-making-sets', 1, NULL, NULL),
(164, 'Kitchen Sets', 'kitchen-sets', 1, NULL, NULL),
(165, 'Play Foods', 'play-foods', 1, NULL, NULL),
(166, 'Kids\' Doctor Sets', 'kids-doctor-sets', 1, NULL, NULL),
(167, 'Piano & Keyboards', 'piano-keyboards', 1, NULL, NULL),
(168, 'Drum Sets & Percussion', 'drum-sets-percussion', 1, NULL, NULL),
(169, 'Under 299', 'under-299', 5, NULL, NULL),
(170, 'Under 499', 'under-499', 5, NULL, NULL),
(171, 'Under 699', 'under-699', 5, NULL, NULL),
(172, 'Under 999', 'under-999', 5, NULL, NULL),
(173, 'IQ Games', 'iq-games', 11, NULL, NULL),
(174, 'Ludo, Snakes & Ladders', 'ludo-snakes-ladders', 11, NULL, NULL),
(175, 'Words, Pictures & Scrabble Games', 'words-pictures-scrabble-games', 11, NULL, NULL),
(176, 'Playing Cards', 'playing-cards', 11, NULL, NULL),
(177, 'Life & Travel Board Games', 'life-travel-board-games', 11, NULL, NULL),
(178, 'Animal, Birds & Marine Life Games', 'animal-birds-marine-life-games', 11, NULL, NULL),
(179, 'Business/Monopoly', 'businessmonopoly', 11, NULL, NULL),
(180, 'Fisher Price', 'fisher-price', 5, NULL, NULL),
(181, 'Intellikit', 'intellikit', 5, NULL, NULL),
(182, 'Intelliskills', 'intelliskills', 5, NULL, NULL),
(183, 'Intellibaby', 'intellibaby', 5, NULL, NULL),
(184, 'Fab n Funky', 'fab-n-funky', 5, NULL, NULL),
(185, 'Hotwheels', 'hotwheels', 5, NULL, NULL),
(186, 'Disney', 'disney', 5, NULL, NULL),
(187, 'Barbie', 'barbie', 11, NULL, NULL),
(188, 'Giggles', 'giggles', 5, NULL, NULL),
(189, 'Lego', 'lego', 5, NULL, NULL),
(190, 'Playnation', 'playnation', 5, NULL, NULL),
(191, 'Diaper Pants', 'diaper-pants', 5, NULL, NULL),
(192, 'Taped Diapers', 'taped-diapers', 5, NULL, NULL),
(193, 'Baby Wipes', 'baby-wipes', 5, NULL, NULL),
(194, 'Cloth Nappies & Accessories', 'cloth-nappies-accessories', 5, NULL, NULL),
(195, 'Cloth Diaper Training Pants & Inserts', 'cloth-diaper-training-pants-inserts', 5, NULL, NULL),
(196, 'Bed Protectors', 'bed-protectors', 1, NULL, NULL),
(197, 'Diaper Rash Cream', 'diaper-rash-cream', 5, NULL, NULL),
(198, 'Diaper Changing Mats', 'diaper-changing-mats', 5, NULL, NULL),
(199, 'Diaper Bags & Backpacks', 'diaper-bags-backpacks', 5, NULL, NULL),
(200, 'Diaper Bins & Disposable Bags', 'diaper-bins-disposable-bags', 5, NULL, NULL),
(201, 'Potty Chairs & Seats', 'potty-chairs-seats', 5, NULL, NULL),
(202, 'Waterproof Nappies', 'waterproof-nappies', 5, NULL, NULL),
(203, 'Swim Diapers', 'swim-diapers', 5, NULL, NULL),
(204, 'Diaper Monthly Packs', 'diaper-monthly-packs', 5, NULL, NULL),
(205, 'Monthly Packs', 'monthly-packs', 6, NULL, NULL),
(206, 'Pampers', 'pampers', 5, NULL, NULL),
(207, 'MamyPoko', 'mamypoko', 5, NULL, NULL),
(208, 'Huggies', 'huggies', 5, NULL, NULL),
(209, 'Himalaya Babycare', 'himalaya-babycare', 5, NULL, NULL),
(210, 'SuperBottoms', 'superbottoms', 5, NULL, NULL),
(211, 'Littles', 'littles', 5, NULL, NULL),
(212, 'Sebamed', 'sebamed', 5, NULL, NULL),
(213, 'Teddyy', 'teddyy', 5, NULL, NULL),
(214, 'Mee Mee', 'mee-mee', 5, NULL, NULL),
(215, 'New Born/Extra Small', 'new-bornextra-small', 6, NULL, NULL),
(216, 'Small', 'small', 6, NULL, NULL),
(217, 'Medium', 'medium', 6, NULL, NULL),
(218, 'Large', 'large', 6, NULL, NULL),
(219, 'Extra Large', 'extra-large', 6, NULL, NULL),
(220, 'XXL/XXXL', 'xxlxxxl', 6, NULL, NULL),
(221, '0 to 7 Kg', '0-to-7-kg', 6, NULL, NULL),
(222, '7 to 14 Kg', '7-to-14-kg', 6, NULL, NULL),
(223, '14 to 18 Kg', '14-to-18-kg', 6, NULL, NULL),
(224, '18 to 25 Kg', '18-to-25-kg', 6, NULL, NULL),
(225, 'Bed Protectors with Foam', 'bed-protectors-with-foam', 6, NULL, NULL),
(226, 'Disposable Mats', 'disposable-mats', 6, NULL, NULL),
(227, 'String Nappies', 'string-nappies', 6, NULL, NULL),
(228, 'Velcro Nappies', 'velcro-nappies', 6, NULL, NULL),
(229, 'Square Nappies', 'square-nappies', 6, NULL, NULL),
(230, 'Nappy Inserts & Accessories', 'nappy-inserts-accessories', 6, NULL, NULL),
(231, 'Diaper Bags', 'diaper-bags', 6, NULL, NULL),
(232, 'Diaper Backpacks', 'diaper-backpacks', 6, NULL, NULL),
(233, 'Potty Chairs', 'potty-chairs', 6, NULL, NULL),
(234, 'Potty Seats', 'potty-seats', 6, NULL, NULL),
(235, 'Baby Strollers & Prams', 'baby-strollers-prams', 5, NULL, NULL),
(236, 'Ride-ons & Scooters', 'ride-ons-scooters', 5, NULL, NULL),
(237, 'Tricycles & Bikes', 'tricycles-bikes', 5, NULL, NULL),
(238, 'Baby Walkers', 'baby-walkers', 5, NULL, NULL),
(239, 'Bouncers, Rockers & Swings', 'bouncers-rockers-swings', 5, NULL, NULL),
(240, 'High Chairs & Booster Seats', 'high-chairs-booster-seats', 5, NULL, NULL),
(241, 'Car Seats', 'car-seats', 5, NULL, NULL),
(242, 'Baby On Board Stickers', 'baby-on-board-stickers', 5, NULL, NULL),
(243, 'Baby Carriers', 'baby-carriers', 5, NULL, NULL),
(244, 'Baby Carrycots', 'baby-carrycots', 5, NULL, NULL),
(245, 'Prams', 'prams', 1, NULL, NULL),
(246, 'Lightweight Strollers', 'lightweight-strollers', 1, NULL, NULL),
(247, 'Twin Strollers & Prams', 'twin-strollers-prams', 1, NULL, NULL),
(248, 'Standard Strollers', 'standard-strollers', 1, NULL, NULL),
(249, 'Travel Systems', 'travel-systems', 1, NULL, NULL),
(250, 'Twister/Swing Cars', 'twisterswing-cars', 1, NULL, NULL),
(251, 'Kids Scooters', 'kids-scooters', 1, NULL, NULL),
(252, 'Rocking Ride-ons', 'rocking-ride-ons', 1, NULL, NULL),
(253, 'Protective Gear', 'protective-gear', 1, NULL, NULL),
(254, 'Skates & Skateboards', 'skates-skateboards', 1, NULL, NULL),
(255, 'Musical & Regular Walkers', 'musical-regular-walkers', 1, NULL, NULL),
(256, 'Activity / Push Walkers', 'activity-push-walkers', 1, NULL, NULL),
(257, 'Walker Cum Rockers', 'walker-cum-rockers', 1, NULL, NULL),
(258, 'Convertible Car Seats (Rear and Forward-facing)', 'convertible-car-seats-rear-and-forward-facing', 1, NULL, NULL),
(259, 'Rear-facing Baby Car Seats', 'rear-facing-baby-car-seats', 1, NULL, NULL),
(260, 'Forward-facing Child Car Seats', 'forward-facing-child-car-seats', 1, NULL, NULL),
(261, 'Backless Booster Car Seats', 'backless-booster-car-seats', 1, NULL, NULL),
(262, 'Upto 9 Kgs', 'upto-9-kgs', 1, NULL, NULL),
(263, 'Upto 15 Kgs', 'upto-15-kgs', 1, NULL, NULL),
(264, 'Upto 22 Kgs', 'upto-22-kgs', 1, NULL, NULL),
(265, 'Upto 36 Kgs', 'upto-36-kgs', 1, NULL, NULL),
(266, 'Cars', 'cars', 1, NULL, NULL),
(267, 'Bikes and Scooters', 'bikes-and-scooters', 1, NULL, NULL),
(268, 'ATVs', 'atvs', 1, NULL, NULL),
(269, 'Jeeps', 'jeeps', 1, NULL, NULL),
(270, 'Training / Balance Bikes', 'training-balance-bikes', 1, NULL, NULL),
(271, 'High Chairs', 'high-chairs', 1, NULL, NULL),
(272, 'Wooden High Chairs', 'wooden-high-chairs', 1, NULL, NULL),
(273, 'Booster Seats', 'booster-seats', 1, NULL, NULL),
(274, 'Rockers', 'rockers', 1, NULL, NULL),
(275, 'Bouncers', 'bouncers', 1, NULL, NULL),
(276, 'Swings', 'swings', 1, NULL, NULL),
(277, 'R for Rabbit', 'r-for-rabbit', 5, NULL, NULL),
(278, 'Baybee', 'baybee', 5, NULL, NULL),
(279, 'Luv Lap', 'luv-lap', 5, NULL, NULL),
(280, 'Dash', 'dash', 5, NULL, NULL),
(281, 'StarAndDaisy', 'staranddaisy', 5, NULL, NULL),
(282, 'Mastela', 'mastela', 5, NULL, NULL),
(283, 'Play Nation', 'play-nation', 5, NULL, NULL),
(284, 'Joie', 'joie', 5, NULL, NULL),
(285, 'Baby Food & Infant Formula', 'baby-food-infant-formula', 5, NULL, NULL),
(286, 'Feeding Bottles & Teats', 'feeding-bottles-teats', 5, NULL, NULL),
(287, 'Breast Feeding', 'breast-feeding', 5, NULL, NULL),
(288, 'Sippers & Cups', 'sippers-cups', 5, NULL, NULL),
(289, 'Bibs & Hankies', 'bibs-hankies', 5, NULL, NULL),
(290, 'Kids Foods & Supplements', 'kids-foods-supplements', 5, NULL, NULL),
(291, 'Dishes & Utensils', 'dishes-utensils', 5, NULL, NULL),
(292, 'Teethers & Pacifiers', 'teethers-pacifiers', 5, NULL, NULL),
(293, 'Sterilizers & Warmers', 'sterilizers-warmers', 5, NULL, NULL),
(294, 'Feeding Accessories', 'feeding-accessories', 5, NULL, NULL),
(295, 'Feeding Bottle Cleaning', 'feeding-bottle-cleaning', 5, NULL, NULL),
(296, 'Kitchen Appliances', 'kitchen-appliances', 5, NULL, NULL),
(297, 'Dry Milk Powder / Formula', 'dry-milk-powder-formula', 8, NULL, NULL),
(298, 'Porridge/Cereals/Grains', 'porridgecerealsgrains', 8, NULL, NULL),
(299, 'Puree - Fruits & Vegetables', 'puree-fruits-vegetables', 8, NULL, NULL),
(300, 'Finger Food / Snacks', 'finger-food-snacks', 8, NULL, NULL),
(301, 'Add on Nutritional Mix', 'add-on-nutritional-mix', 8, NULL, NULL),
(302, 'Breast Pumps', 'breast-pumps', 8, NULL, NULL),
(303, 'Electric Breast Pump', 'electric-breast-pump', 8, NULL, NULL),
(304, 'Manual Breast Pump', 'manual-breast-pump', 8, NULL, NULL),
(305, 'Breast Pads', 'breast-pads', 8, NULL, NULL),
(306, 'Nipple Shields', 'nipple-shields', 8, NULL, NULL),
(307, 'Nipple Pullers', 'nipple-pullers', 8, NULL, NULL),
(308, 'Breast Milk Storage', 'breast-milk-storage', 8, NULL, NULL),
(309, 'Feeding Pillows & Covers', 'feeding-pillows-covers', 8, NULL, NULL),
(310, 'Nursing Covers & Bibs', 'nursing-covers-bibs', 8, NULL, NULL),
(311, 'Nursing Bras', 'nursing-bras', 8, NULL, NULL),
(312, 'Feeding Bottles', 'feeding-bottles', 8, NULL, NULL),
(313, 'Nipples & Teats', 'nipples-teats', 8, NULL, NULL),
(314, 'Food Feeder', 'food-feeder', 8, NULL, NULL),
(315, 'Fruit & Food Nibbler', 'fruit-food-nibbler', 8, NULL, NULL),
(316, 'Bottle Covers & Insulated Bags', 'bottle-covers-insulated-bags', 8, NULL, NULL),
(317, 'Water Filled Silicone Teethers', 'water-filled-silicone-teethers', 8, NULL, NULL),
(318, 'Silicone Teethers', 'silicone-teethers', 8, NULL, NULL),
(319, 'Pacifiers', 'pacifiers', 8, NULL, NULL),
(320, 'Rattle Teethers', 'rattle-teethers', 8, NULL, NULL),
(321, 'Orthodontic Pacifiers', 'orthodontic-pacifiers', 8, NULL, NULL),
(322, 'Wooden Teethers', 'wooden-teethers', 8, NULL, NULL),
(323, 'Bottle Sterilizers', 'bottle-sterilizers', 8, NULL, NULL),
(324, 'Bottle & Food Warmers', 'bottle-food-warmers', 8, NULL, NULL),
(325, 'Multipurpose Sterilizers', 'multipurpose-sterilizers', 8, NULL, NULL),
(326, 'Bottle & Nipple Cleaning Brushes', 'bottle-nipple-cleaning-brushes', 8, NULL, NULL),
(327, 'Drying Racks', 'drying-racks', 8, NULL, NULL),
(328, 'Cleaning Combo Sets', 'cleaning-combo-sets', 8, NULL, NULL),
(329, 'Bottle Tongs', 'bottle-tongs', 8, NULL, NULL),
(330, 'Multi Purpose Cleansers', 'multi-purpose-cleansers', 8, NULL, NULL),
(331, 'Spout Sippers', 'spout-sippers', 8, NULL, NULL),
(332, 'Straw Sippers', 'straw-sippers', 8, NULL, NULL),
(333, 'Mugs', 'mugs', 8, NULL, NULL),
(334, 'Tumblers', 'tumblers', 8, NULL, NULL),
(335, 'Bibs', 'bibs', 8, NULL, NULL),
(336, 'Burp/Wash Clothes', 'burpwash-clothes', 8, NULL, NULL),
(337, 'Hanky / Napkins', 'hanky-napkins', 8, NULL, NULL),
(338, 'Aprons', 'aprons', 8, NULL, NULL),
(339, 'Bowls, Containers & Dispensers', 'bowls-containers-dispensers', 8, NULL, NULL),
(340, 'Cutlery', 'cutlery', 8, NULL, NULL),
(341, 'Milk Powder Containers', 'milk-powder-containers', 8, NULL, NULL),
(342, 'Dishes', 'dishes', 8, NULL, NULL),
(343, 'Feeding Sets', 'feeding-sets', 8, NULL, NULL),
(344, 'Tableware', 'tableware', 8, NULL, NULL),
(345, 'Drinkware', 'drinkware', 8, NULL, NULL),
(346, 'Health Drinks & Powders', 'health-drinks-powders', 8, NULL, NULL),
(347, 'Breakfast & Cereals', 'breakfast-cereals', 8, NULL, NULL),
(348, 'Ready to Cook', 'ready-to-cook', 8, NULL, NULL),
(349, 'Dry Fruits, Nuts & Seeds', 'dry-fruits-nuts-seeds', 8, NULL, NULL),
(350, 'Snacks & Finger Food', 'snacks-finger-food', 8, NULL, NULL),
(351, 'Biscuits & Cookies', 'biscuits-cookies', 8, NULL, NULL),
(352, 'Chocolates, Candies & Sweets', 'chocolates-candies-sweets', 8, NULL, NULL),
(353, 'Vitamin Gummies', 'vitamin-gummies', 8, NULL, NULL),
(354, 'Spreads, Jams & Ketchup', 'spreads-jams-ketchup', 8, NULL, NULL),
(355, 'Ghee & Cooking Oils', 'ghee-cooking-oils', 8, NULL, NULL),
(356, 'Nestle', 'nestle', 5, NULL, NULL),
(357, 'Medela', 'medela', 5, NULL, NULL),
(358, 'Avent', 'avent', 5, NULL, NULL),
(359, 'Chicco', 'chicco', 1, NULL, NULL),
(360, 'Pigeon', 'pigeon', 5, NULL, NULL),
(361, 'Aptamil', 'aptamil', 5, NULL, NULL),
(362, 'PediaSure', 'pediasure', 5, NULL, NULL),
(363, 'Similac', 'similac', 5, NULL, NULL),
(364, 'Early Foods', 'early-foods', 5, NULL, NULL),
(365, 'timios', 'timios', 5, NULL, NULL),
(366, 'Lotions, Oils & Powders', 'lotions-oils-powders', 2, NULL, NULL),
(367, 'Soaps & Body Wash', 'soaps-body-wash', 5, NULL, NULL),
(368, 'Shampoos & Conditioners', 'shampoos-conditioners', 5, NULL, NULL),
(369, 'Baby Creams & Ointments', 'baby-creams-ointments', 5, NULL, NULL),
(370, 'Bath Tubs & Bathers', 'bath-tubs-bathers', 5, NULL, NULL),
(371, 'Bathing Accessories', 'bathing-accessories', 5, NULL, NULL),
(372, 'Grooming Essentials', 'grooming-essentials', 5, NULL, NULL),
(373, 'Bath Towels & Robes', 'bath-towels-robes', 5, NULL, NULL),
(374, 'Bath Sponge & Loofah', 'bath-sponge-loofah', 2, NULL, NULL),
(375, 'Shower Caps', 'shower-caps', 2, NULL, NULL),
(376, 'Soap Cases', 'soap-cases', 2, NULL, NULL),
(377, 'Bath Gloves', 'bath-gloves', 2, NULL, NULL),
(378, 'Baby Bath Nets', 'baby-bath-nets', 2, NULL, NULL),
(379, 'Bathroom Stools & Towel Holders', 'bathroom-stools-towel-holders', 2, NULL, NULL),
(380, 'Rinse Cups & Faucet Extenders', 'rinse-cups-faucet-extenders', 2, NULL, NULL),
(381, 'Squeeze Toys', 'squeeze-toys', 2, NULL, NULL),
(382, 'Bath Books', 'bath-books', 2, NULL, NULL),
(383, 'Learning & Activity Bath Toys', 'learning-activity-bath-toys', 2, NULL, NULL),
(384, 'Body Wash', 'body-wash', 2, NULL, NULL),
(385, 'Soap Bars', 'soap-bars', 2, NULL, NULL),
(386, 'Top to Toe Wash', 'top-to-toe-wash', 2, NULL, NULL),
(387, 'Face Wash', 'face-wash', 2, NULL, NULL),
(388, 'Ubtan for Babies', 'ubtan-for-babies', 2, NULL, NULL),
(389, 'Brush & Comb', 'brush-comb', 2, NULL, NULL),
(390, 'Nail Clippers', 'nail-clippers', 2, NULL, NULL),
(391, 'Powder Puff', 'powder-puff', 2, NULL, NULL),
(392, 'Grooming Kits', 'grooming-kits', 2, NULL, NULL),
(393, 'Baby Perfumes & Cologne', 'baby-perfumes-cologne', 2, NULL, NULL),
(394, 'Baby Scissors', 'baby-scissors', 2, NULL, NULL),
(395, 'Mama Earth', 'mama-earth', 5, NULL, NULL),
(396, 'Cetaphil Baby', 'cetaphil-baby', 5, NULL, NULL),
(397, 'CURATIO', 'curatio', 5, NULL, NULL),
(398, 'Aveeno Baby', 'aveeno-baby', 5, NULL, NULL),
(399, 'the moms co.', 'the-moms-co', 5, NULL, NULL),
(400, 'Baby Shampoos', 'baby-shampoos', 2, NULL, NULL),
(401, 'Conditioners', 'conditioners', 2, NULL, NULL),
(402, 'Towel & Wrappers', 'towel-wrappers', 2, NULL, NULL),
(403, 'Bath Robes', 'bath-robes', 2, NULL, NULL),
(404, 'Hand & Face Towels', 'hand-face-towels', 2, NULL, NULL),
(405, 'Baby Lotions', 'baby-lotions', 2, NULL, NULL),
(406, 'Massage Oils', 'massage-oils', 2, NULL, NULL),
(407, 'Hair Oils', 'hair-oils', 2, NULL, NULL),
(408, 'Baby Powders', 'baby-powders', 2, NULL, NULL),
(409, 'Sun Screens', 'sun-screens', 2, NULL, NULL),
(410, 'Baby Creams', 'baby-creams', 2, NULL, NULL),
(411, 'Face Creams', 'face-creams', 2, NULL, NULL),
(412, 'Baby Lip Gels', 'baby-lip-gels', 2, NULL, NULL),
(413, 'Baby Bath Tubs', 'baby-bath-tubs', 2, NULL, NULL),
(414, 'Baby Bathers', 'baby-bathers', 2, NULL, NULL),
(415, 'Bath Slings', 'bath-slings', 2, NULL, NULL),
(416, 'Kids Pool & Accessories', 'kids-pool-accessories', 2, NULL, NULL),
(417, 'Cots, Cradles & Playpens', 'cots-cradles-playpens', 5, NULL, NULL),
(418, 'Blankets, Quilts & Wrappers', 'blankets-quilts-wrappers', 5, NULL, NULL),
(419, 'Baby Sleeping Bags', 'baby-sleeping-bags', 1, NULL, NULL),
(420, 'Baby Bedding Sets & Pillows', 'baby-bedding-sets-pillows', 5, NULL, NULL),
(421, 'Mosquito Nets', 'mosquito-nets', 1, NULL, NULL),
(422, 'Wardrobes & Storage', 'wardrobes-storage', 5, NULL, NULL),
(423, 'Kids Room and Study Furniture', 'kids-room-and-study-furniture', 5, NULL, NULL),
(424, 'Room Decor & Furnishing', 'room-decor-furnishing', 5, NULL, NULL),
(425, 'Travel Trolleys & Bags', 'travel-trolleys-bags', 5, NULL, NULL),
(426, 'Wall Papers & Stickers', 'wall-papers-stickers', 5, NULL, NULL),
(427, 'Clocks', 'clocks', 5, NULL, NULL),
(428, 'Blankets & Quilts', 'blankets-quilts', 1, NULL, NULL),
(429, 'Wrappers & Swaddles', 'wrappers-swaddles', 1, NULL, NULL),
(430, 'Hooded Towels & Wrappers', 'hooded-towels-wrappers', 1, NULL, NULL),
(431, 'Cots & Cribs', 'cots-cribs', 1, NULL, NULL),
(432, 'Cradles & Bassinets', 'cradles-bassinets', 1, NULL, NULL),
(433, 'Playpens / Play yards', 'playpens-play-yards', 1, NULL, NULL),
(434, 'Wooden Furniture', 'wooden-furniture', 1, NULL, NULL),
(435, 'Cot Mobiles', 'cot-mobiles', 1, NULL, NULL),
(436, 'Baby Monitors', 'baby-monitors', 1, NULL, NULL),
(437, 'Baby Gadda Sets', 'baby-gadda-sets', 1, NULL, NULL),
(438, 'Baby Pillows & Bolster Sets', 'baby-pillows-bolster-sets', 1, NULL, NULL),
(439, 'Mustard Seed Infant Pillows', 'mustard-seed-infant-pillows', 1, NULL, NULL),
(440, 'Neck & Head Supporters', 'neck-head-supporters', 1, NULL, NULL),
(441, 'Wardrobes & Storage Units', 'wardrobes-storage-units', 1, NULL, NULL),
(442, 'Chest of Drawers', 'chest-of-drawers', 1, NULL, NULL),
(443, 'Storage Boxes', 'storage-boxes', 1, NULL, NULL),
(444, 'Racks', 'racks', 1, NULL, NULL),
(445, 'Hangers/Hooks', 'hangershooks', 1, NULL, NULL),
(446, 'Storage Bags & Bins', 'storage-bags-bins', 1, NULL, NULL),
(447, 'Hanging Organiser Pockets', 'hanging-organiser-pockets', 1, NULL, NULL),
(448, 'Laundry Bags', 'laundry-bags', 1, NULL, NULL),
(449, 'Bookshelves', 'bookshelves', 1, NULL, NULL),
(450, 'Bedding Sets', 'bedding-sets', 1, NULL, NULL),
(451, 'Bed Comforters', 'bed-comforters', 1, NULL, NULL),
(452, 'Bedsheets', 'bedsheets', 1, NULL, NULL),
(453, 'Cushion, Pillow & Bolsters', 'cushion-pillow-bolsters', 1, NULL, NULL),
(454, 'Cushion & Pillow Covers', 'cushion-pillow-covers', 1, NULL, NULL),
(455, 'Haus & kinder', 'haus-kinder', 5, NULL, NULL),
(456, 'Brandonn', 'brandonn', 5, NULL, NULL),
(457, 'Mom\'s Home', 'moms-home', 5, NULL, NULL),
(458, 'SYGA', 'syga', 5, NULL, NULL),
(459, 'Abracadabra', 'abracadabra', 5, NULL, NULL),
(460, 'Elementary', 'elementary', 5, NULL, NULL),
(461, 'Mi Arcus', 'mi-arcus', 5, NULL, NULL),
(462, 'Nilkamal', 'nilkamal', 5, NULL, NULL),
(463, 'Kiddery', 'kiddery', 5, NULL, NULL),
(464, 'Mattress Set With Nets', 'mattress-set-with-nets', 1, NULL, NULL),
(465, 'Trolley Luggage Bags', 'trolley-luggage-bags', 1, NULL, NULL),
(466, 'Duffle Bags', 'duffle-bags', 1, NULL, NULL),
(467, 'Accessory Bags', 'accessory-bags', 1, NULL, NULL),
(468, 'Luggage Tags', 'luggage-tags', 1, NULL, NULL),
(469, 'Growth & Reward Charts', 'growth-reward-charts', 1, NULL, NULL),
(470, 'Wall Stickers & Decals', 'wall-stickers-decals', 1, NULL, NULL),
(471, 'Glow In Dark Stickers', 'glow-in-dark-stickers', 1, NULL, NULL),
(472, 'Kids Beds', 'kids-beds', 1, NULL, NULL),
(473, 'Study Tables', 'study-tables', 1, NULL, NULL),
(474, 'Chair', 'chair', 1, NULL, NULL),
(475, 'Table & Chair Sets', 'table-chair-sets', 1, NULL, NULL),
(476, 'Activity Tables/Lap Desks', 'activity-tableslap-desks', 1, NULL, NULL),
(477, 'Stools', 'stools', 1, NULL, NULL),
(478, 'Wired & Wireless Headphones', 'wired-wireless-headphones', 1, NULL, NULL),
(479, 'Bluetooth Speakers', 'bluetooth-speakers', 1, NULL, NULL),
(480, 'Crib Mattress', 'crib-mattress', 1, NULL, NULL),
(481, 'Crib Bedding Sets', 'crib-bedding-sets', 1, NULL, NULL),
(482, 'Bed Bumpers', 'bed-bumpers', 1, NULL, NULL),
(483, 'Crib Sheets', 'crib-sheets', 1, NULL, NULL),
(484, 'Mattress Protector Covers', 'mattress-protector-covers', 1, NULL, NULL),
(485, 'Mattress Protectors', 'mattress-protectors', 1, NULL, NULL),
(486, 'Crib/Cot Mattress', 'cribcot-mattress', 1, NULL, NULL),
(487, 'Kid\'s Bed Mattress', 'kids-bed-mattress', 1, NULL, NULL),
(488, 'Lamps & Lights', 'lamps-lights', 1, NULL, NULL),
(489, 'Rugs, Mattresses & Carpets', 'rugs-mattresses-carpets', 1, NULL, NULL),
(490, 'Kids Floor Mats', 'kids-floor-mats', 1, NULL, NULL),
(491, 'Room Decor', 'room-decor', 1, NULL, NULL),
(492, 'Door & Window Curtains', 'door-window-curtains', 1, NULL, NULL),
(493, 'Nursing/Sleep Wear', 'nursingsleep-wear', 5, NULL, NULL),
(494, 'Maternity Dresses & Skirts', 'maternity-dresses-skirts', 5, NULL, NULL),
(495, 'Maternity Lingerie', 'maternity-lingerie', 5, NULL, NULL),
(496, 'Maternity Bottom wear', 'maternity-bottom-wear', 5, NULL, NULL),
(497, 'Maternity Ethnic Wear', 'maternity-ethnic-wear', 5, NULL, NULL),
(498, 'Maternity Tops', 'maternity-tops', 5, NULL, NULL),
(499, 'Pregnancy Pillows', 'pregnancy-pillows', 10, NULL, NULL),
(500, 'Corset Belts/Belly Support Belts', 'corset-beltsbelly-support-belts', 10, NULL, NULL),
(501, 'Socks & Stockings', 'socks-stockings', 10, NULL, NULL),
(502, 'Skin & Facial Care', 'skin-facial-care', 5, NULL, NULL),
(503, 'Body Care', 'body-care', 5, NULL, NULL),
(504, 'Hair Care & Styling', 'hair-care-styling', 5, NULL, NULL),
(505, 'Hair Styling Tools', 'hair-styling-tools', 2, NULL, NULL),
(506, 'Bathing Essentials', 'bathing-essentials', 5, NULL, NULL),
(507, 'Eye Care', 'eye-care', 5, NULL, NULL),
(508, 'Lip Care', 'lip-care', 5, NULL, NULL),
(509, 'Sun Protection', 'sun-protection', 5, NULL, NULL),
(510, 'Hands & Feet Care', 'hands-feet-care', 5, NULL, NULL),
(511, 'Feminine Hygiene & Care', 'feminine-hygiene-care', 5, NULL, NULL),
(512, 'Kits & Combos', 'kits-combos', 5, NULL, NULL),
(513, 'Make up & Cosmetics', 'make-up-cosmetics', 5, NULL, NULL),
(514, 'Health & Well-being', 'health-well-being', 5, NULL, NULL),
(515, 'Super Savers', 'super-savers', 10, NULL, NULL),
(516, 'Bella Mama', 'bella-mama', 5, NULL, NULL),
(517, 'MomToBe', 'momtobe', 5, NULL, NULL),
(518, 'ECOMAMA', 'ecomama', 5, NULL, NULL),
(519, 'Fabme', 'fabme', 5, NULL, NULL),
(520, 'Aujjessa', 'aujjessa', 5, NULL, NULL),
(521, 'Kriti', 'kriti', 5, NULL, NULL),
(522, 'Morph', 'morph', 5, NULL, NULL),
(523, 'The Mom Store', 'the-mom-store', 5, NULL, NULL),
(524, 'Zelena', 'zelena', 5, NULL, NULL),
(525, 'Mine4Nine', 'mine4nine', 5, NULL, NULL),
(526, 'Mometernity', 'mometernity', 5, NULL, NULL),
(527, 'Nejo', 'nejo', 5, NULL, NULL),
(528, 'Piu', 'piu', 5, NULL, NULL),
(529, 'Anti Stretch Creams & Lotions', 'anti-stretch-creams-lotions', 10, NULL, NULL),
(530, 'Breast Care Oil & Serums', 'breast-care-oil-serums', 10, NULL, NULL),
(531, 'Maternity Pads & Pants', 'maternity-pads-pants', 10, NULL, NULL),
(532, 'Intimate Wash', 'intimate-wash', 10, NULL, NULL),
(533, 'Intimate Wipes', 'intimate-wipes', 10, NULL, NULL),
(534, 'Nutrition & Lactation Boosters', 'nutrition-lactation-boosters', 10, NULL, NULL),
(535, 'Vitamins & Health Supplements', 'vitamins-health-supplements', 10, NULL, NULL),
(536, 'Nursing Wear', 'nursing-wear', 10, NULL, NULL),
(537, 'Diapers', 'diapers', 1, NULL, NULL),
(538, 'Cloth Nappies', 'cloth-nappies', 1, NULL, NULL),
(539, 'Wipes', 'wipes', 1, NULL, NULL),
(540, 'Diaper Rash Creams', 'diaper-rash-creams', 1, NULL, NULL),
(541, 'Baby Skincare', 'baby-skincare', 1, NULL, NULL),
(542, 'Blankets, Wrappers & Sleeping Bags', 'blankets-wrappers-sleeping-bags', 1, NULL, NULL),
(543, 'Cleansers & Detergents', 'cleansers-detergents', 5, NULL, NULL),
(544, 'Oral Care', 'oral-care', 5, NULL, NULL),
(545, 'Childproofing & Safety', 'childproofing-safety', 5, NULL, NULL),
(546, 'Medical Care', 'medical-care', 5, NULL, NULL),
(547, 'Mosquito Repellents & Care', 'mosquito-repellents-care', 5, NULL, NULL),
(548, 'Protection Face Masks & Gear', 'protection-face-masks-gear', 5, NULL, NULL),
(549, 'Handwash', 'handwash', 9, NULL, NULL),
(550, 'Hand Sanitizers', 'hand-sanitizers', 9, NULL, NULL),
(551, 'Disinfectants', 'disinfectants', 9, NULL, NULL),
(552, 'Air Purifiers (House & Car)', 'air-purifiers-house-car', 9, NULL, NULL),
(553, 'Colgate', 'colgate', 5, NULL, NULL),
(554, 'Himalayan Babycare', 'himalayan-babycare', 5, NULL, NULL),
(555, 'Oral-B', 'oral-b', 5, NULL, NULL),
(556, 'ZOE', 'zoe', 5, NULL, NULL),
(557, 'Cotton Buds, Pads & Balls', 'cotton-buds-pads-balls', 9, NULL, NULL),
(558, 'Thermometers', 'thermometers', 9, NULL, NULL),
(559, 'Nasal Aspirators & Cleaners', 'nasal-aspirators-cleaners', 9, NULL, NULL),
(560, 'Anti Colic Tummy RollOn', 'anti-colic-tummy-rollon', 9, NULL, NULL),
(561, 'Cold Relief/Nasal Balms & Inhalers', 'cold-reliefnasal-balms-inhalers', 9, NULL, NULL),
(562, 'Medicine Droppers', 'medicine-droppers', 9, NULL, NULL),
(563, 'Gripe Water', 'gripe-water', 9, NULL, NULL),
(564, 'Humidifiers/De-humidifiers', 'humidifiersde-humidifiers', 9, NULL, NULL),
(565, 'Vaporizers & Nebulizers', 'vaporizers-nebulizers', 9, NULL, NULL),
(566, 'Mosquito After Bite Creams', 'mosquito-after-bite-creams', 9, NULL, NULL),
(567, 'Anti Mosquito Roll-ons', 'anti-mosquito-roll-ons', 9, NULL, NULL),
(568, 'Anti Mosquito Patches', 'anti-mosquito-patches', 9, NULL, NULL),
(569, 'Mosquito Sprays', 'mosquito-sprays', 9, NULL, NULL),
(570, 'Mosquito Repellant Creams & Gels', 'mosquito-repellant-creams-gels', 9, NULL, NULL),
(571, 'Mosquito Repellant Devices', 'mosquito-repellant-devices', 9, NULL, NULL),
(572, 'Mosquito Repellant Bands', 'mosquito-repellant-bands', 9, NULL, NULL),
(573, 'Mosquito Repellent Oils', 'mosquito-repellent-oils', 9, NULL, NULL),
(574, 'Baby Safe Laundry Detergents', 'baby-safe-laundry-detergents', 9, NULL, NULL),
(575, 'All Purpose Cleansers', 'all-purpose-cleansers', 9, NULL, NULL),
(576, 'Toy Cleaners', 'toy-cleaners', 9, NULL, NULL),
(577, 'Vegetable/Fruit Wash', 'vegetablefruit-wash', 9, NULL, NULL),
(578, 'Bottle Cleaning Liquid', 'bottle-cleaning-liquid', 9, NULL, NULL),
(579, 'Dishwashing Liquid', 'dishwashing-liquid', 9, NULL, NULL),
(580, 'Floor Cleaners', 'floor-cleaners', 9, NULL, NULL),
(581, 'Finger Toothbrush', 'finger-toothbrush', 9, NULL, NULL),
(582, 'Manual Toothbrush', 'manual-toothbrush', 9, NULL, NULL),
(583, 'Electric/Powered Toothbrush', 'electricpowered-toothbrush', 9, NULL, NULL),
(584, 'Training & Gum Toothbrush', 'training-gum-toothbrush', 9, NULL, NULL),
(585, 'Bed Guards & Rails', 'bed-guards-rails', 9, NULL, NULL),
(586, 'Safety Gates', 'safety-gates', 9, NULL, NULL),
(587, 'Corner & Edge Guards', 'corner-edge-guards', 9, NULL, NULL),
(588, 'Elbow and Knee-Pads', 'elbow-and-knee-pads', 9, NULL, NULL),
(589, 'Child Safety Locks', 'child-safety-locks', 9, NULL, NULL),
(590, 'Electric Socket Covers', 'electric-socket-covers', 9, NULL, NULL),
(591, 'Door Stoppers & Guards', 'door-stoppers-guards', 9, NULL, NULL),
(592, 'Baby Helmets', 'baby-helmets', 9, NULL, NULL),
(593, 'Baby Head Supporters', 'baby-head-supporters', 9, NULL, NULL),
(594, 'Kids Safety Belts', 'kids-safety-belts', 9, NULL, NULL),
(595, 'Anti Radiation Devices', 'anti-radiation-devices', 9, NULL, NULL),
(596, 'Anti Glare Glasses', 'anti-glare-glasses', 9, NULL, NULL),
(597, 'Child Tracking Devices', 'child-tracking-devices', 9, NULL, NULL),
(598, 'Toothpaste', 'toothpaste', 9, NULL, NULL),
(599, 'Toothbrushes', 'toothbrushes', 9, NULL, NULL),
(600, 'Tongue Cleaners', 'tongue-cleaners', 9, NULL, NULL),
(601, 'Oral Care Set', 'oral-care-set', 9, NULL, NULL),
(602, 'Toothbrush Holders', 'toothbrush-holders', 9, NULL, NULL),
(603, 'New Today', 'new-today', 5, NULL, NULL),
(604, 'Last Day', 'last-day', 5, NULL, NULL),
(605, 'Kids Clothes', 'kids-clothes', 5, NULL, NULL),
(606, 'Baby Clothes', 'baby-clothes', 5, NULL, NULL),
(607, 'Footwear', 'footwear', 5, NULL, NULL),
(608, 'Accessories', 'accessories', 5, NULL, NULL),
(609, 'Fine Jewellery', 'fine-jewellery', 5, NULL, NULL),
(610, 'Toys', 'toys', 5, NULL, NULL),
(611, 'Baby Gear', 'baby-gear', 3, NULL, NULL),
(612, 'Nursery', 'nursery', 3, NULL, NULL),
(613, 'Graco', 'graco', 1, NULL, NULL),
(614, 'GUESS', 'guess', 5, NULL, NULL),
(615, 'US Polo Assn', 'us-polo-assn', 5, NULL, NULL),
(616, 'Turtledove London', 'turtledove-london', 5, NULL, NULL),
(617, 'JACK & JONES JUNIOR', 'jack-jones-junior', 5, NULL, NULL),
(618, 'iDO Italy', 'ido-italy', 5, NULL, NULL),
(619, 'LC WAIKIKI', 'lc-waikiki', 5, NULL, NULL),
(620, 'Toy Balloon', 'toy-balloon', 5, NULL, NULL),
(621, 'Tiber Taber', 'tiber-taber', 5, NULL, NULL),
(622, 'Pspeaches', 'pspeaches', 5, NULL, NULL),
(623, 'M\'andy', 'mandy', 5, NULL, NULL),
(624, 'Indiurbane', 'indiurbane', 5, NULL, NULL),
(625, 'BownBee', 'bownbee', 5, NULL, NULL),
(626, 'Bella Moda', 'bella-moda', 5, NULL, NULL),
(627, 'Lilpicks Couture', 'lilpicks-couture', 5, NULL, NULL),
(628, 'Anthrilo', 'anthrilo', 5, NULL, NULL),
(629, 'D\'chica', 'dchica', 5, NULL, NULL),
(630, 'KALKI Fashion', 'kalki-fashion', 5, NULL, NULL),
(631, 'Dapper Dudes', 'dapper-dudes', 5, NULL, NULL),
(632, 'Enfance', 'enfance', 5, NULL, NULL),
(633, 'Rikidoos', 'rikidoos', 5, NULL, NULL),
(634, 'CrayonFlakes', 'crayonflakes', 5, NULL, NULL),
(635, 'Cutecumber', 'cutecumber', 5, NULL, NULL),
(636, 'Vastramay', 'vastramay', 5, NULL, NULL),
(637, 'Partikles', 'partikles', 5, NULL, NULL),
(638, 'Taffykids', 'taffykids', 5, NULL, NULL),
(639, 'Piccolo', 'piccolo', 5, NULL, NULL),
(640, 'AJ Dezines', 'aj-dezines', 5, NULL, NULL),
(641, 'Vidushi Aastha', 'vidushi-aastha', 7, NULL, NULL),
(642, 'BYB PREMIUM', 'byb-premium', 5, NULL, NULL),
(643, 'LIZ JACOB', 'liz-jacob', 5, NULL, NULL),
(644, 'Lagorii', 'lagorii', 5, NULL, NULL),
(645, 'The Tribe Kids', 'the-tribe-kids', 5, NULL, NULL),
(646, 'Minime', 'minime', 5, NULL, NULL),
(647, 'Jilmil', 'jilmil', 5, NULL, NULL),
(648, 'Plum Cheeks', 'plum-cheeks', 5, NULL, NULL),
(649, 'THE RIGHT CUT', 'the-right-cut', 5, NULL, NULL),
(650, 'KIRTI AGARWAL', 'kirti-agarwal', 5, NULL, NULL),
(651, 'Pasha India', 'pasha-india', 5, NULL, NULL),
(652, 'CASA NINOS', 'casa-ninos', 5, NULL, NULL),
(653, 'Foreverkidz', 'foreverkidz', 5, NULL, NULL),
(654, 'Ka Kids', 'ka-kids', 5, NULL, NULL),
(655, 'Bibbity Bobbity', 'bibbity-bobbity', 5, NULL, NULL),
(656, 'Swoon Baby', 'swoon-baby', 5, NULL, NULL),
(657, 'Fayon Kids', 'fayon-kids', 5, NULL, NULL),
(658, 'Maternity Store', 'maternity-store', 5, NULL, NULL),
(659, 'Baby Store', 'baby-store', 5, NULL, NULL),
(660, 'Body Wash/Shower Gel', 'body-washshower-gel', 2, NULL, NULL),
(661, 'Bathing Soaps', 'bathing-soaps', 2, NULL, NULL),
(662, 'Bath Salts & Scrubs', 'bath-salts-scrubs', 2, NULL, NULL),
(663, 'Moisturizers & Day Creams', 'moisturizers-day-creams', 2, NULL, NULL),
(664, 'Face Serums', 'face-serums', 2, NULL, NULL),
(665, 'Face masks/sheets', 'face-maskssheets', 2, NULL, NULL),
(666, 'Cleansers', 'cleansers', 2, NULL, NULL),
(667, 'Toners', 'toners', 2, NULL, NULL),
(668, 'Night Cream', 'night-cream', 2, NULL, NULL),
(669, 'Face Scrubs & Exfoliators', 'face-scrubs-exfoliators', 2, NULL, NULL),
(670, 'Facial Spray', 'facial-spray', 2, NULL, NULL),
(671, 'Face Oils', 'face-oils', 2, NULL, NULL),
(672, 'Rollers & Massagers', 'rollers-massagers', 2, NULL, NULL),
(673, 'Massage Creams', 'massage-creams', 2, NULL, NULL),
(674, 'Stretch Mark Creams & Oils', 'stretch-mark-creams-oils', 2, NULL, NULL),
(675, 'Body Lotions', 'body-lotions', 2, NULL, NULL),
(676, 'Body Cream & Moisturisers', 'body-cream-moisturisers', 2, NULL, NULL),
(677, 'Massage & Essential Oils', 'massage-essential-oils', 2, NULL, NULL),
(678, 'Body Butter', 'body-butter', 2, NULL, NULL),
(679, 'Body Scrubs', 'body-scrubs', 2, NULL, NULL),
(680, 'Body Shaping Cream', 'body-shaping-cream', 2, NULL, NULL),
(681, 'Stretch Marks Solutions', 'stretch-marks-solutions', 10, NULL, NULL),
(682, 'Nipple Balms & Butters', 'nipple-balms-butters', 10, NULL, NULL),
(683, 'Breast Care Oils & Serums', 'breast-care-oils-serums', 10, NULL, NULL),
(684, 'Belly Support Belts', 'belly-support-belts', 10, NULL, NULL),
(685, 'Maternity Wear', 'maternity-wear', 10, NULL, NULL),
(686, 'Matenity Lingerie', 'matenity-lingerie', 10, NULL, NULL),
(687, 'Hospital Bag Checklist', 'hospital-bag-checklist', 10, NULL, NULL),
(688, 'Pregnancy & Parenting Books', 'pregnancy-parenting-books', 5, NULL, NULL),
(689, 'Shampoo', 'shampoo', 2, NULL, NULL),
(690, 'Hair Oil', 'hair-oil', 2, NULL, NULL),
(691, 'Hair Mask', 'hair-mask', 2, NULL, NULL),
(692, 'Conditioner', 'conditioner', 2, NULL, NULL),
(693, 'Hair Serum', 'hair-serum', 2, NULL, NULL),
(694, 'Sanitary Napkins', 'sanitary-napkins', 10, NULL, NULL),
(695, 'Panty Liners', 'panty-liners', 10, NULL, NULL),
(696, 'Menstrual Cups', 'menstrual-cups', 10, NULL, NULL),
(697, 'Hygienic Disposal Bags', 'hygienic-disposal-bags', 10, NULL, NULL),
(698, 'Vaginal Tightening Gel/Cream', 'vaginal-tightening-gelcream', 10, NULL, NULL),
(699, 'Shaving & Hair Removal', 'shaving-hair-removal', 10, NULL, NULL),
(700, 'Health Supplements', 'health-supplements', 9, NULL, NULL),
(701, 'Weight Management', 'weight-management', 9, NULL, NULL),
(702, 'Breast Feeding Essentials', 'breast-feeding-essentials', 10, NULL, NULL),
(703, 'Maternity Shaping Belts', 'maternity-shaping-belts', 10, NULL, NULL),
(704, 'Party Balloons', 'party-balloons', 3, NULL, NULL),
(705, 'Party Decor', 'party-decor', 3, NULL, NULL),
(706, 'Birthday Decoration Kit', 'birthday-decoration-kit', 3, NULL, NULL),
(707, 'Party Props & Caps', 'party-props-caps', 3, NULL, NULL),
(708, 'Candles & Cake Toppers', 'candles-cake-toppers', 3, NULL, NULL),
(709, 'Plates, Cups & Table decor', 'plates-cups-table-decor', 3, NULL, NULL),
(710, 'Party Supplies', 'party-supplies', 3, NULL, NULL),
(711, 'Gift Bags & Wrappers', 'gift-bags-wrappers', 3, NULL, NULL),
(712, 'Invitation Cards', 'invitation-cards', 3, NULL, NULL),
(713, 'Cut-outs & Posters', 'cut-outs-posters', 3, NULL, NULL),
(714, 'Wall Decor', 'wall-decor', 3, NULL, NULL),
(715, 'Swirls Decorations', 'swirls-decorations', 3, NULL, NULL),
(716, 'Party Banners', 'party-banners', 3, NULL, NULL),
(717, '0-3 Years', '0-3-years', 3, NULL, NULL),
(718, '3-6 Years', '3-6-years', 3, NULL, NULL),
(719, '6+ Years', '6-years', 3, NULL, NULL),
(720, 'Balloon Packs', 'balloon-packs', 3, NULL, NULL),
(721, 'Metallic', 'metallic', 3, NULL, NULL),
(722, 'Foil', 'foil', 3, NULL, NULL),
(723, 'Photobooth Props', 'photobooth-props', 3, NULL, NULL),
(724, 'Badges/Sash', 'badgessash', 3, NULL, NULL),
(725, 'Hats', 'hats', 3, NULL, NULL),
(726, 'Masks', 'masks', 3, NULL, NULL),
(727, 'Menu Card', 'menu-card', 3, NULL, NULL),
(728, 'Napkins/Tissues', 'napkinstissues', 3, NULL, NULL),
(729, 'Straw & Cutlery Sets', 'straw-cutlery-sets', 3, NULL, NULL),
(730, 'Paper/Fibre Plates', 'paperfibre-plates', 3, NULL, NULL),
(731, 'Cups & Glasses', 'cups-glasses', 3, NULL, NULL),
(732, 'Table Covers & Mats', 'table-covers-mats', 3, NULL, NULL),
(733, 'Bottle Wrapper', 'bottle-wrapper', 3, NULL, NULL),
(734, 'Baby Gifts Sets', 'baby-gifts-sets', 3, NULL, NULL),
(735, 'Kids Gift Sets', 'kids-gift-sets', 3, NULL, NULL),
(736, 'Gift Certificate', 'gift-certificate', 3, NULL, NULL),
(737, 'Fashion For him', 'fashion-for-him', 3, NULL, NULL),
(738, 'Fashion For her', 'fashion-for-her', 3, NULL, NULL),
(739, 'Fashion Accessories', 'fashion-accessories', 3, NULL, NULL),
(740, 'Toys & Gaming', 'toys-gaming', 3, NULL, NULL),
(741, 'Books & CD\'s', 'books-cds', 3, NULL, NULL),
(742, 'Board Books', 'board-books', 5, NULL, NULL),
(743, 'Read & Learn', 'read-learn', 5, NULL, NULL),
(744, 'Crafts, Hobbies & Activity books', 'crafts-hobbies-activity-books', 5, NULL, NULL),
(745, 'Story Books', 'story-books', 5, NULL, NULL),
(746, 'Drawing & Coloring Book', 'drawing-coloring-book', 5, NULL, NULL),
(747, 'Academic Books', 'academic-books', 5, NULL, NULL),
(748, 'Picture Books', 'picture-books', 5, NULL, NULL),
(749, 'Rhymes & Poetry Books', 'rhymes-poetry-books', 5, NULL, NULL),
(750, 'Comics & Graphic Books', 'comics-graphic-books', 5, NULL, NULL),
(751, 'Sticker Books', 'sticker-books', 5, NULL, NULL),
(752, 'CD\'s & Movies', 'cds-movies', 5, NULL, NULL),
(753, 'Activity Books', 'activity-books', 4, NULL, NULL),
(754, 'Arts & Crafts', 'arts-crafts', 4, NULL, NULL),
(755, 'Game & Quiz Books', 'game-quiz-books', 4, NULL, NULL),
(756, 'Journals', 'journals', 4, NULL, NULL),
(757, 'Scrap Books', 'scrap-books', 4, NULL, NULL),
(758, 'Baby Names', 'baby-names', 4, NULL, NULL),
(759, 'Baby Record Books', 'baby-record-books', 4, NULL, NULL),
(760, 'Child Development', 'child-development', 4, NULL, NULL),
(761, 'Expecting Mothers', 'expecting-mothers', 4, NULL, NULL),
(762, 'Conception & Pregnancy', 'conception-pregnancy', 4, NULL, NULL),
(763, 'Aphabets & Numbers', 'aphabets-numbers', 4, NULL, NULL),
(764, 'Animals & Birds', 'animals-birds', 4, NULL, NULL),
(765, 'Fruits & Vegetables', 'fruits-vegetables', 4, NULL, NULL),
(766, 'Pre-School Learning', 'pre-school-learning', 4, NULL, NULL),
(767, 'General Knowledge', 'general-knowledge', 4, NULL, NULL),
(768, 'Adventure Stories', 'adventure-stories', 4, NULL, NULL),
(769, 'Bedtime Story Books', 'bedtime-story-books', 4, NULL, NULL),
(770, 'Classic Story Collections', 'classic-story-collections', 4, NULL, NULL),
(771, 'Pop Up & 3D books', 'pop-up-3d-books', 4, NULL, NULL),
(772, 'Intellitots', 'intellitots', 5, NULL, NULL),
(773, 'Dreamland', 'dreamland', 5, NULL, NULL),
(774, 'Sawan', 'sawan', 5, NULL, NULL),
(775, 'Navneet', 'navneet', 5, NULL, NULL),
(776, 'Pegasus', 'pegasus', 5, NULL, NULL),
(777, 'Amar Chitra Katha', 'amar-chitra-katha', 5, NULL, NULL),
(778, 'Target', 'target', 5, NULL, NULL),
(779, 'Coloring Activity Book', 'coloring-activity-book', 4, NULL, NULL),
(780, 'Copy & Color Books', 'copy-color-books', 4, NULL, NULL),
(781, 'Join the Dots', 'join-the-dots', 4, NULL, NULL),
(782, 'Drawing Books', 'drawing-books', 4, NULL, NULL),
(783, 'Magical Coloring', 'magical-coloring', 4, NULL, NULL),
(784, 'School Stationery', 'school-stationery', 5, NULL, NULL),
(785, 'School Bags & Back Packs', 'school-bags-back-packs', 5, NULL, NULL),
(786, 'Water Bottles', 'water-bottles', 5, NULL, NULL),
(787, 'Lunch Boxes', 'lunch-boxes', 5, NULL, NULL),
(788, 'School Kits', 'school-kits', 5, NULL, NULL),
(789, 'Lunch Box', 'lunch-box', 8, NULL, NULL),
(790, 'Lunch Box Sets', 'lunch-box-sets', 8, NULL, NULL),
(791, 'Lunch Box Set With Bags', 'lunch-box-set-with-bags', 8, NULL, NULL),
(792, 'Insulated Lunch Box', 'insulated-lunch-box', 8, NULL, NULL),
(793, 'Disney Princess', 'disney-princess', 11, NULL, NULL),
(794, 'Disney Frozen', 'disney-frozen', 11, NULL, NULL),
(795, 'Minnie Mouse', 'minnie-mouse', 11, NULL, NULL),
(796, 'Spiderman', 'spiderman', 11, NULL, NULL),
(797, 'Avengers', 'avengers', 11, NULL, NULL),
(798, 'Mickey & Friends', 'mickey-friends', 11, NULL, NULL),
(799, 'Peppa Pig', 'peppa-pig', 11, NULL, NULL),
(800, 'Writing & Doodle Boards', 'writing-doodle-boards', 4, NULL, NULL),
(801, 'Pens,Pencils & Pencil Boxes', 'penspencils-pencil-boxes', 4, NULL, NULL),
(802, 'Drawing & Colouring Sets', 'drawing-colouring-sets', 4, NULL, NULL),
(803, 'Stationery Sets', 'stationery-sets', 4, NULL, NULL),
(804, 'Note Books', 'note-books', 4, NULL, NULL),
(805, 'Regular Bottles', 'regular-bottles', 8, NULL, NULL),
(806, 'Sipper Bottles', 'sipper-bottles', 8, NULL, NULL),
(807, 'Sports Bottles', 'sports-bottles', 8, NULL, NULL),
(808, 'Youp', 'youp', 5, NULL, NULL),
(809, 'Milton', 'milton', 5, NULL, NULL),
(810, 'Apsara', 'apsara', 5, NULL, NULL),
(811, 'Doms', 'doms', 5, NULL, NULL),
(812, 'Classmate', 'classmate', 5, NULL, NULL),
(813, 'Camlin', 'camlin', 5, NULL, NULL),
(814, 'Faber Castell', 'faber-castell', 5, NULL, NULL),
(815, 'My Little Pony', 'my-little-pony', 5, NULL, NULL),
(816, 'Back Packs', 'back-packs', 7, NULL, NULL),
(817, 'Soft Toys Bags', 'soft-toys-bags', 7, NULL, NULL),
(818, 'Trolley Bags', 'trolley-bags', 7, NULL, NULL),
(819, 'Home Furnishing', 'home-furnishing', 5, NULL, NULL),
(820, 'Home Decor', 'home-decor', 5, NULL, NULL),
(821, 'Home Storage and Organization', 'home-storage-and-organization', 5, NULL, NULL),
(822, 'Kitchen & Dining Essentials', 'kitchen-dining-essentials', 5, NULL, NULL),
(823, 'Electronics & Gadgets', 'electronics-gadgets', 5, NULL, NULL),
(824, 'Luggage & Travel', 'luggage-travel', 5, NULL, NULL),
(825, 'Bathroom Accessories & Organisation', 'bathroom-accessories-organisation', 1, NULL, NULL),
(826, 'Home Storage', 'home-storage', 1, NULL, NULL),
(827, 'Closet Organisation', 'closet-organisation', 1, NULL, NULL),
(828, 'Laundry Organisation', 'laundry-organisation', 1, NULL, NULL),
(829, 'Racks Shelves & Drawers', 'racks-shelves-drawers', 1, NULL, NULL),
(830, 'Headphones & Earphones', 'headphones-earphones', 11, NULL, NULL),
(831, 'Digital Cameras', 'digital-cameras', 11, NULL, NULL),
(832, 'Speakers & Soundbars', 'speakers-soundbars', 11, NULL, NULL),
(833, 'Curtains & Accessories', 'curtains-accessories', 1, NULL, NULL),
(834, 'Rugs & Carpets', 'rugs-carpets', 1, NULL, NULL),
(835, 'Bathroom Linens', 'bathroom-linens', 1, NULL, NULL),
(836, 'Bedding & Linens', 'bedding-linens', 1, NULL, NULL),
(837, 'Dinnerware', 'dinnerware', 1, NULL, NULL),
(838, 'Cookware & Bakeware', 'cookware-bakeware', 1, NULL, NULL),
(839, 'Kitchen Storage & Containers', 'kitchen-storage-containers', 1, NULL, NULL),
(840, 'Kitchen Textiles', 'kitchen-textiles', 1, NULL, NULL),
(841, 'Kitchen Tools', 'kitchen-tools', 1, NULL, NULL),
(842, 'Lighting', 'lighting', 1, NULL, NULL),
(843, 'Flora', 'flora', 1, NULL, NULL),
(844, 'Picture Frames', 'picture-frames', 1, NULL, NULL),
(845, 'Mirrors', 'mirrors', 1, NULL, NULL),
(846, 'Candles & Candle Holders', 'candles-candle-holders', 1, NULL, NULL),
(847, 'Decorative Accessories', 'decorative-accessories', 1, NULL, NULL),
(848, 'Mixer Grinders', 'mixer-grinders', 1, NULL, NULL),
(849, 'Juicers & Blenders', 'juicers-blenders', 1, NULL, NULL),
(850, 'Toasters & Sandwich Makers', 'toasters-sandwich-makers', 1, NULL, NULL),
(851, 'Coffee Maker, Air Fryer & Electric Kettles', 'coffee-maker-air-fryer-electric-kettles', 1, NULL, NULL),
(852, 'Dehumidifiers', 'dehumidifiers', 1, NULL, NULL),
(853, 'Bags & Backpacks', 'bags-backpacks', 7, NULL, NULL),
(854, 'Travel Bags, Kits & Organisers', 'travel-bags-kits-organisers', 7, NULL, NULL),
(855, 'Travel Luggage', 'travel-luggage', 7, NULL, NULL),
(856, 'Bodysuits & Rompers', 'bodysuits-rompers', 5, NULL, NULL),
(857, 'Sets & Suits', 'sets-suits', 5, NULL, NULL),
(858, 'Topwear', 'topwear', 5, NULL, NULL),
(859, 'Frocks', 'frocks', 5, NULL, NULL),
(860, 'Shirts', 'shirts', 5, NULL, NULL),
(861, 'Pajamas & Leggings', 'pajamas-leggings', 5, NULL, NULL),
(862, 'Shorts, Skirts & Jeans', 'shorts-skirts-jeans', 5, NULL, NULL),
(863, 'Swimwear', 'swimwear', 5, NULL, NULL),
(864, 'Sweatshirts & Jackets', 'sweatshirts-jackets', 5, NULL, NULL),
(865, 'Baby Girl (0-2 years)', 'baby-girl-0-2-years', 5, NULL, NULL),
(866, 'Baby Boy (0-2 years)', 'baby-boy-0-2-years', 5, NULL, NULL),
(867, 'Girl (2+ years)', 'girl-2-years', 5, NULL, NULL),
(868, 'Boy (2+ years)', 'boy-2-years', 5, NULL, NULL),
(869, '3 - 6 Months', '3-6-months', 5, NULL, NULL),
(870, '6 - 9 Months', '6-9-months', 5, NULL, NULL),
(871, '9 - 12 Months', '9-12-months', 5, NULL, NULL),
(872, '12 - 18 Months', '12-18-months', 5, NULL, NULL);
INSERT INTO `categories` (`id`, `name`, `slug`, `product_categories_id`, `description`, `image_url`) VALUES
(873, '18 - 24 Months', '18-24-months', 5, NULL, NULL),
(874, '2 - 4 Years', '2-4-years', 5, NULL, NULL),
(875, '4+ Years', '4-years', 5, NULL, NULL),
(876, 'Gucci', 'gucci', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `home_sections`
--

CREATE TABLE `home_sections` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `key` varchar(100) NOT NULL,
  `data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`data`)),
  `position` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `home_sections`
--

INSERT INTO `home_sections` (`id`, `key`, `data`, `position`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'hero', '{\"heading\": {\"iconone\": \"Discovering\", \"icontwo\": \"parenthood\", \"rest\": \"made easier\"}, \"subheading\": \"Shop 10,000+ Curated, Safe & Reliable Baby and Mother Products.\", \"cta_text\": \"100+ trusted customers\", \"cta_url\": \"#\", \"avatars\": [\"storage/WebsiteImages/home/reviewicon1.png\", \"storage/WebsiteImages/home/reviewicon2.png\", \"storage/WebsiteImages/home/reviewicon3.png\"], \"hero_image\": \"storage/WebsiteImages/home/motherchild.webp\", \"throne_image\": \"storage/WebsiteImages/home/throne.png\", \"pattern_image\": \"storage/WebsiteImages/home/hero-pattern.png\"}', 1, 1, NULL, '2026-02-09 06:25:18'),
(2, 'story', '{\"image\":\"storage\\/WebsiteImages\\/home\\/ourstory.webp\",\"text\":\"We are your trusted online source for <strong>10,000+<\\/strong> 100% safety-compliant and innovative baby and mother essentials. Our mission is to support every stage of your family\'s journey with unwavering quality, expertise, and seamless care.\"}', 2, 0, NULL, '2026-04-21 05:44:02'),
(3, 'trust_icons', '[{\"icon\":\"storage\\/WebsiteImages\\/home\\/icon1.png\",\"text\":\"100% Safety Guaranteed\"},{\"icon\":\"storage\\/WebsiteImages\\/home\\/icon2.png\",\"text\":\"Nationwide Fast Shipping\"},{\"icon\":\"storage\\/WebsiteImages\\/home\\/icon3.png\",\"text\":\"Exceptional Customer Care\"}]', 3, 0, NULL, '2026-04-21 05:47:18'),
(4, 'category_grid', '[{\"image\":\"storage\\/WebsiteImages\\/home\\/pregnant-woman.webp\",\"title\":\"Pregnancy & Mom\",\"url\":\"\\/category\\/pregnancy-mom\"},{\"image\":\"storage\\/WebsiteImages\\/home\\/categoryimg6.webp\",\"title\":\"Infant & New Born Essentials\",\"url\":\"\\/category\\/infant-newborn\"},{\"image\":\"storage\\/WebsiteImages\\/home\\/categoryimg5.webp\",\"title\":\"Baby Gear & Travels\",\"url\":\"\\/category\\/baby-gear\"},{\"image\":\"storage\\/WebsiteImages\\/home\\/categoryimg4.webp\",\"title\":\"Fashion (0\\u201310+ Years)\",\"url\":\"\\/category\\/kids-fashion\"},{\"image\":\"storage\\/WebsiteImages\\/home\\/categoryimg3.webp\",\"title\":\"Nursery & Room Decor\",\"url\":\"\\/category\\/nursery\"},{\"image\":\"storage\\/WebsiteImages\\/home\\/categoryimg2.webp\",\"title\":\"Toys, Books & Learning\",\"url\":\"\\/category\\/toys-learning\"}]', 4, 1, NULL, '2026-02-09 06:25:18'),
(5, 'customer_favourites', '[{\"price\": 399, \"title\": \"Infant & New Born Essentials\", \"image\": \"storage/WebsiteImages/home/button1.png\", \"url\": \"/products?price_upto=399\"}, {\"price\": 799, \"title\": \"Infant & New Born Essentials\", \"image\": \"storage/WebsiteImages/home/button3.png\", \"url\": \"/products?price_upto=799\"}, {\"price\": 1299, \"title\": \"Pregnancy & Mom Care\", \"image\": \"storage/WebsiteImages/home/button4.png\", \"url\": \"/products?price_upto=1299\"},{\"price\": 399, \"title\": \"Infant & New Born Essentials\", \"image\": \"storage/WebsiteImages/home/button2.png\", \"url\": \"/products?price_upto=399\"}]', 5, 1, NULL, '2026-02-09 06:25:18'),
(6, 'product_list', '{\"title\": \"Featured bestsellers\", \"products\": [{\"name\": \"Maxi Cosi Zelia Luxe 5-in-1 Modular Travel System\", \"subtitle\": \"No Recline, Blue\", \"image\": \"storage/WebsiteImages/home/travelsystem.png\", \"rating\": 4.5, \"mrp\": 2395, \"price\": 995, \"url\": \"/product/maxi-cosi-zelia\"}, {\"name\": \"Friends Baby Cotton Snap Sleep and Play 2pk\", \"subtitle\": \"Brand: Luvable Friends\", \"image\": \"storage/WebsiteImages/home/babycloth.png\", \"rating\": 4.5, \"mrp\": 2395, \"price\": 1995, \"url\": \"/product/baby-cotton-sleep-play\"}, {\"name\": \"Baby Trend Cover Me 4-In-1 Convertible Car Seat\", \"subtitle\": \"Brand: Baby Trend\", \"image\": \"storage/WebsiteImages/home/carseat.png\", \"rating\": 4.5, \"mrp\": 2395, \"price\": 995, \"url\": \"/product/baby-trend-carseat\"}]}', 6, 1, NULL, '2026-02-09 06:25:18'),
(7, 'brand_logos', '[\"storage/WebsiteImages/home/brandicon1.png\", \"storage/WebsiteImages/home/brandicon2.png\", \"storage/WebsiteImages/home/brandicon3.png\", \"storage/WebsiteImages/home/brandicon4.png\", \"storage/WebsiteImages/home/brandicon5.png\", \"storage/WebsiteImages/home/brandicon6.png\"]', 7, 1, NULL, '2026-02-09 06:25:18'),
(8, 'promo', '{\"image\":\"storage/WebsiteImages/home/babyroom.png\", \"title\": \"The Baby Shop\", \"subtitle\": \"Curated and seasoned finds for your little ones\", \"cta_text\": \"Shop now\", \"cta_url\": \"/shop\"}', 8, 1, NULL, '2026-02-09 06:25:18'),
(9, 'brands_we_love', '[{\"image\":\"storage/WebsiteImages/home/brandimage1.png\", \"url\": \"#!\"}, {\"image\": \"storage/WebsiteImages/home/brandimage2.png\", \"url\": \"#!\"}]', 10, 1, '2026-01-20 05:04:27', '2026-02-09 06:25:18'),
(10, 'new_arrivals', '{\"view_all_url\": \"/products/new-arrivals\", \"products\": [{\"name\": \"Maxi Cosi Zelia Luxe 5-in-1 Modular Travel System\", \"subtitle\": \"No Recline, blue\", \"image\": \"storage/WebsiteImages/home/travelsystem.png\", \"rating\": 4.5, \"mrp\": 2395, \"price\": 995, \"url\": \"/product/maxi-cosi-zelia\"}, {\"name\": \"Friends Baby Cotton Snap Sleep and Play 2pk\", \"subtitle\": \"Brand: Luvable Friends\", \"image\": \"storage/WebsiteImages/home/babycloth.png\", \"rating\": 4.5, \"mrp\": 2395, \"price\": 1995, \"url\": \"/product/baby-cotton-sleep-play\"}, {\"name\": \"Baby Trend Cover Me 4-In-1 Convertible Car Seat\", \"subtitle\": \"Brand: Baby Trend\", \"image\": \"storage/WebsiteImages/home/carseat.png\", \"rating\": 4.5, \"mrp\": 2395, \"price\": 995, \"url\": \"/product/baby-trend-carseat\"}]}', 11, 1, '2026-01-20 05:04:49', '2026-02-09 06:25:18'),
(11, 'newsletter', '{\"title\": \"Enjoy 10% Off Your First Order\", \"subtitle\": \"Free shipping on orders above ₹49\", \"cta_text\": \"Join today\", \"cta_url\": \"/register\", \"background\": \"storage/WebsiteImages/home/background-bottom.png\"}', 9, 1, NULL, '2026-02-09 06:25:18');

-- --------------------------------------------------------

--
-- Table structure for table `ingestion_batches`
--

CREATE TABLE `ingestion_batches` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `seller_id` bigint(20) UNSIGNED NOT NULL,
  `status` enum('review_required','ready_for_publish','publishing','partially_committed','committed','publish_failed','image_upload_pending','image_review_required','image_upload_in_progress','completed') NOT NULL DEFAULT 'review_required',
  `total_products` int(11) NOT NULL DEFAULT 0,
  `total_errors` int(11) NOT NULL DEFAULT 0,
  `commit_summary` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`commit_summary`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ingestion_batches`
--

INSERT INTO `ingestion_batches` (`id`, `seller_id`, `status`, `total_products`, `total_errors`, `commit_summary`, `created_at`, `updated_at`) VALUES
(1, 15, 'image_upload_pending', 10, 0, NULL, '2026-06-18 04:49:26', '2026-06-30 09:27:27');

-- --------------------------------------------------------

--
-- Table structure for table `ingestion_errors`
--

CREATE TABLE `ingestion_errors` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `batch_id` bigint(20) UNSIGNED NOT NULL,
  `product_code` varchar(255) NOT NULL,
  `error_type` varchar(100) DEFAULT NULL,
  `severity` enum('info','warning','error','critical') NOT NULL DEFAULT 'error',
  `sheet_name` varchar(255) DEFAULT NULL,
  `row_number` int(11) DEFAULT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ingestion_products`
--

CREATE TABLE `ingestion_products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `batch_id` bigint(20) UNSIGNED NOT NULL,
  `product_code` varchar(255) NOT NULL,
  `category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `raw_payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`raw_payload`)),
  `compiled_payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`compiled_payload`)),
  `status` enum('compile_failed','validation_failed','pending_review','approved','rejected','queued','processing','committed','commit_failed') NOT NULL,
  `commit_error` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ingestion_products`
--

INSERT INTO `ingestion_products` (`id`, `batch_id`, `product_code`, `category_id`, `raw_payload`, `compiled_payload`, `status`, `commit_error`, `created_at`, `updated_at`) VALUES
(1, 1, 'GRP001', 5, '{\"is_variant_product\":true,\"group_code\":\"GRP001\",\"category_id\":5,\"subcategory_id\":476,\"name\":\"Boys Party Cotton Checked Shirt\",\"description\":\"Premium checked shirt for boys\",\"brand_id\":8,\"price\":1299,\"stock\":45,\"seller_id\":15}', '{\"product\":{\"is_variant_product\":true,\"group_code\":\"GRP001\",\"category_id\":5,\"subcategory_id\":476,\"name\":\"Boys Party Cotton Checked Shirt\",\"description\":\"Premium checked shirt for boys\",\"brand_id\":8,\"price\":1299,\"stock\":45,\"seller_id\":15},\"simple_attributes\":[966,971,996],\"variants\":[{\"variant_key\":\"85ffc9ed8d262edc99eb0ec5432cc2b52815c10b\",\"variant_attribute_value_ids\":[976,990],\"price\":1299,\"stock\":25,\"status\":1},{\"variant_key\":\"037837258359e0f553feca9e60d7e4451eb933b5\",\"variant_attribute_value_ids\":[974,991],\"price\":1399,\"stock\":20,\"status\":1}],\"compile_status\":\"success\"}', 'approved', NULL, '2026-06-18 04:49:26', '2026-06-18 04:49:31'),
(2, 1, 'GRP002', 5, '{\"is_variant_product\":true,\"group_code\":\"GRP002\",\"category_id\":5,\"subcategory_id\":477,\"name\":\"Girls Formal Denim Dress\",\"description\":\"Girls formal denim dress\",\"brand_id\":8,\"price\":1899,\"stock\":15,\"seller_id\":15}', '{\"product\":{\"is_variant_product\":true,\"group_code\":\"GRP002\",\"category_id\":5,\"subcategory_id\":477,\"name\":\"Girls Formal Denim Dress\",\"description\":\"Girls formal denim dress\",\"brand_id\":8,\"price\":1899,\"stock\":15,\"seller_id\":15},\"simple_attributes\":[967,972,994],\"variants\":[{\"variant_key\":\"afb72029e0fcd50aaf520b0151109ba0de36c821\",\"variant_attribute_value_ids\":[979,989],\"price\":1899,\"stock\":15,\"status\":1}],\"compile_status\":\"success\"}', 'approved', NULL, '2026-06-18 04:49:26', '2026-06-18 04:49:31'),
(3, 1, 'GRP003', 5, '{\"is_variant_product\":true,\"group_code\":\"GRP003\",\"category_id\":5,\"subcategory_id\":489,\"name\":\"Girls Casual Stretch Jeans\",\"description\":\"Comfort fit girls jeans\",\"brand_id\":10,\"price\":999,\"stock\":40,\"seller_id\":15}', '{\"product\":{\"is_variant_product\":true,\"group_code\":\"GRP003\",\"category_id\":5,\"subcategory_id\":489,\"name\":\"Girls Casual Stretch Jeans\",\"description\":\"Comfort fit girls jeans\",\"brand_id\":10,\"price\":999,\"stock\":40,\"seller_id\":15},\"simple_attributes\":[969,972,995],\"variants\":[{\"variant_key\":\"85ffc9ed8d262edc99eb0ec5432cc2b52815c10b\",\"variant_attribute_value_ids\":[976,990],\"price\":999,\"stock\":40,\"status\":1}],\"compile_status\":\"success\"}', 'approved', NULL, '2026-06-18 04:49:27', '2026-06-18 04:49:31'),
(4, 1, 'FD001', 8, '{\"is_variant_product\":true,\"group_code\":\"FD001\",\"category_id\":8,\"subcategory_id\":490,\"name\":\"Baby Feeding Bottle 250ml\",\"description\":\"Anti colic feeding bottle\",\"brand_id\":11,\"price\":399,\"stock\":100,\"seller_id\":15}', '{\"product\":{\"is_variant_product\":true,\"group_code\":\"FD001\",\"category_id\":8,\"subcategory_id\":490,\"name\":\"Baby Feeding Bottle 250ml\",\"description\":\"Anti colic feeding bottle\",\"brand_id\":11,\"price\":399,\"stock\":100,\"seller_id\":15},\"simple_attributes\":[],\"variants\":[{\"variant_key\":\"f66b7dcd21696a4242e1ff93608c405741802c92\",\"variant_attribute_value_ids\":[998],\"price\":399,\"stock\":100,\"status\":1}],\"compile_status\":\"success\"}', 'approved', NULL, '2026-06-18 04:49:27', '2026-06-18 04:49:31'),
(5, 1, 'FD002', 8, '{\"is_variant_product\":true,\"group_code\":\"FD002\",\"category_id\":8,\"subcategory_id\":490,\"name\":\"Baby Feeding Bottle Premium\",\"description\":\"Premium feeding bottle\",\"brand_id\":12,\"price\":499,\"stock\":60,\"seller_id\":15}', '{\"product\":{\"is_variant_product\":true,\"group_code\":\"FD002\",\"category_id\":8,\"subcategory_id\":490,\"name\":\"Baby Feeding Bottle Premium\",\"description\":\"Premium feeding bottle\",\"brand_id\":12,\"price\":499,\"stock\":60,\"seller_id\":15},\"simple_attributes\":[],\"variants\":[{\"variant_key\":\"4a839f86b122140fda5b48dc57e2f0fc170d0356\",\"variant_attribute_value_ids\":[997],\"price\":499,\"stock\":60,\"status\":1}],\"compile_status\":\"success\"}', 'approved', NULL, '2026-06-18 04:49:27', '2026-06-18 04:49:31'),
(6, 1, 'BP001', 8, '{\"is_variant_product\":true,\"group_code\":\"BP001\",\"category_id\":8,\"subcategory_id\":494,\"name\":\"Electric Breast Pump Stage1\",\"description\":\"Portable breast pump\",\"brand_id\":9,\"price\":2499,\"stock\":20,\"seller_id\":15}', '{\"product\":{\"is_variant_product\":true,\"group_code\":\"BP001\",\"category_id\":8,\"subcategory_id\":494,\"name\":\"Electric Breast Pump Stage1\",\"description\":\"Portable breast pump\",\"brand_id\":9,\"price\":2499,\"stock\":20,\"seller_id\":15},\"simple_attributes\":[],\"variants\":[{\"variant_key\":\"e3cbba8883fe746c6e35783c9404b4bc0c7ee9eb\",\"variant_attribute_value_ids\":[1000],\"price\":2499,\"stock\":20,\"status\":1}],\"compile_status\":\"success\"}', 'approved', NULL, '2026-06-18 04:49:27', '2026-06-18 04:49:31'),
(7, 1, 'TY001', 11, '{\"is_variant_product\":false,\"group_code\":\"TY001\",\"category_id\":11,\"subcategory_id\":183,\"name\":\"Educational Alphabet Learning Toy\",\"description\":\"Alphabet learning toy\",\"brand_id\":13,\"price\":799,\"stock\":50,\"seller_id\":15}', '{\"product\":{\"is_variant_product\":false,\"group_code\":\"TY001\",\"category_id\":11,\"subcategory_id\":183,\"name\":\"Educational Alphabet Learning Toy\",\"description\":\"Alphabet learning toy\",\"brand_id\":13,\"price\":799,\"stock\":50,\"seller_id\":15},\"simple_attributes\":[330,338],\"variants\":[{\"variant_key\":\"da39a3ee5e6b4b0d3255bfef95601890afd80709\",\"variant_attribute_value_ids\":[],\"price\":799,\"stock\":50,\"status\":1}],\"compile_status\":\"success\"}', 'approved', NULL, '2026-06-18 04:49:27', '2026-06-18 04:49:31'),
(8, 1, 'TY002', 11, '{\"is_variant_product\":false,\"group_code\":\"TY002\",\"category_id\":11,\"subcategory_id\":183,\"name\":\"Superhero Action Figure Set\",\"description\":\"Action figure collection\",\"brand_id\":12,\"price\":999,\"stock\":30,\"seller_id\":15}', '{\"product\":{\"is_variant_product\":false,\"group_code\":\"TY002\",\"category_id\":11,\"subcategory_id\":183,\"name\":\"Superhero Action Figure Set\",\"description\":\"Action figure collection\",\"brand_id\":12,\"price\":999,\"stock\":30,\"seller_id\":15},\"simple_attributes\":[331,339],\"variants\":[{\"variant_key\":\"da39a3ee5e6b4b0d3255bfef95601890afd80709\",\"variant_attribute_value_ids\":[],\"price\":999,\"stock\":30,\"status\":1}],\"compile_status\":\"success\"}', 'approved', NULL, '2026-06-18 04:49:27', '2026-06-18 04:49:31'),
(9, 1, 'TY003', 11, '{\"is_variant_product\":false,\"group_code\":\"TY003\",\"category_id\":11,\"subcategory_id\":183,\"name\":\"Family Strategy Board Game\",\"description\":\"Board game for family\",\"brand_id\":9,\"price\":899,\"stock\":25,\"seller_id\":15}', '{\"product\":{\"is_variant_product\":false,\"group_code\":\"TY003\",\"category_id\":11,\"subcategory_id\":183,\"name\":\"Family Strategy Board Game\",\"description\":\"Board game for family\",\"brand_id\":9,\"price\":899,\"stock\":25,\"seller_id\":15},\"simple_attributes\":[332,337],\"variants\":[{\"variant_key\":\"da39a3ee5e6b4b0d3255bfef95601890afd80709\",\"variant_attribute_value_ids\":[],\"price\":899,\"stock\":25,\"status\":1}],\"compile_status\":\"success\"}', 'approved', NULL, '2026-06-18 04:49:27', '2026-06-18 04:49:31'),
(10, 1, 'TY004', 11, '{\"is_variant_product\":false,\"group_code\":\"TY004\",\"category_id\":11,\"subcategory_id\":183,\"name\":\"Kids Building Blocks Mega Pack\",\"description\":\"Creative building block set\",\"brand_id\":13,\"price\":1499,\"stock\":15,\"seller_id\":15}', '{\"product\":{\"is_variant_product\":false,\"group_code\":\"TY004\",\"category_id\":11,\"subcategory_id\":183,\"name\":\"Kids Building Blocks Mega Pack\",\"description\":\"Creative building block set\",\"brand_id\":13,\"price\":1499,\"stock\":15,\"seller_id\":15},\"simple_attributes\":[333,336],\"variants\":[{\"variant_key\":\"da39a3ee5e6b4b0d3255bfef95601890afd80709\",\"variant_attribute_value_ids\":[],\"price\":1499,\"stock\":15,\"status\":1}],\"compile_status\":\"success\"}', 'approved', NULL, '2026-06-18 04:49:27', '2026-06-18 04:49:31');

-- --------------------------------------------------------

--
-- Table structure for table `ingestion_product_images`
--

CREATE TABLE `ingestion_product_images` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `batch_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `product_code` varchar(255) NOT NULL,
  `attribute_value_id` bigint(20) UNSIGNED DEFAULT NULL,
  `image_path` varchar(500) NOT NULL,
  `original_filename` varchar(255) NOT NULL,
  `image_type` enum('simple','visual_variant') NOT NULL,
  `is_primary` tinyint(1) NOT NULL DEFAULT 0,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `status` enum('pending_review','approved','rejected','committed','failed') NOT NULL DEFAULT 'pending_review',
  `error_message` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ingestion_product_images`
--

INSERT INTO `ingestion_product_images` (`id`, `batch_id`, `product_id`, `product_code`, `attribute_value_id`, `image_path`, `original_filename`, `image_type`, `is_primary`, `sort_order`, `status`, `error_message`, `created_at`, `updated_at`) VALUES
(1, 1, 305, 'BABYBOOTIE24', 976, 'bulk-temp/6a438b64ac590.png', '1.png', 'visual_variant', 1, 0, 'committed', NULL, '2026-06-30 09:24:52', '2026-06-30 09:26:46'),
(2, 1, 305, 'BABYBOOTIE24', 976, 'bulk-temp/6a438b64b80c0.png', 'Pasted image (17).png', 'visual_variant', 0, 1, 'committed', NULL, '2026-06-30 09:24:52', '2026-06-30 09:26:46'),
(3, 1, 305, 'BABYBOOTIE24', 976, 'bulk-temp/6a438b64ba4d7.png', 'Pasted image (81).png', 'visual_variant', 0, 2, 'committed', NULL, '2026-06-30 09:24:52', '2026-06-30 09:26:46'),
(4, 1, 305, 'BABYBOOTIE24', 976, 'bulk-temp/6a438b64bcfd5.png', 'RED-XL.png', 'visual_variant', 0, 3, 'committed', NULL, '2026-06-30 09:24:52', '2026-06-30 09:26:46'),
(5, 1, 305, 'BABYBOOTIE24', 979, 'bulk-temp/6a438b64c0c3f.png', '1.png', 'visual_variant', 1, 0, 'committed', NULL, '2026-06-30 09:24:52', '2026-06-30 09:26:46'),
(6, 1, 305, 'BABYBOOTIE24', 979, 'bulk-temp/6a438b64c2e85.png', 'Pasted image (186).png', 'visual_variant', 0, 1, 'committed', NULL, '2026-06-30 09:24:52', '2026-06-30 09:26:46'),
(7, 1, 305, 'BABYBOOTIE24', 979, 'bulk-temp/6a438b64c4db3.png', 'Pasted image (83).png', 'visual_variant', 0, 2, 'committed', NULL, '2026-06-30 09:24:52', '2026-06-30 09:26:46'),
(8, 1, 305, 'BABYBOOTIE24', 979, 'bulk-temp/6a438b64c6ec7.png', 'Pasted image (89).png', 'visual_variant', 0, 3, 'committed', NULL, '2026-06-30 09:24:52', '2026-06-30 09:26:46'),
(9, 1, 305, 'BABYBOOTIE24', 975, 'bulk-temp/6a438b64cabbc.png', '1.png', 'visual_variant', 1, 0, 'committed', NULL, '2026-06-30 09:24:52', '2026-06-30 09:26:46'),
(10, 1, 305, 'BABYBOOTIE24', 975, 'bulk-temp/6a438b64cd1c5.png', 'Pasted image (110).png', 'visual_variant', 0, 1, 'committed', NULL, '2026-06-30 09:24:52', '2026-06-30 09:26:46'),
(11, 1, 305, 'BABYBOOTIE24', 975, 'bulk-temp/6a438b64cf66c.png', 'Pasted image (173).png', 'visual_variant', 0, 2, 'committed', NULL, '2026-06-30 09:24:52', '2026-06-30 09:26:46'),
(12, 1, 305, 'BABYBOOTIE24', 975, 'bulk-temp/6a438b64d1848.png', 'Pasted image (44).png', 'visual_variant', 0, 3, 'committed', NULL, '2026-06-30 09:24:52', '2026-06-30 09:26:46'),
(13, 1, 296, 'BABYFOOTIE15', 979, 'bulk-temp/6a438b64d600e.png', '1.png', 'visual_variant', 1, 0, 'committed', NULL, '2026-06-30 09:24:52', '2026-06-30 09:26:45'),
(14, 1, 296, 'BABYFOOTIE15', 979, 'bulk-temp/6a438b64d8464.png', 'Pasted image (128).png', 'visual_variant', 0, 1, 'committed', NULL, '2026-06-30 09:24:52', '2026-06-30 09:26:45'),
(15, 1, 296, 'BABYFOOTIE15', 979, 'bulk-temp/6a438b64da37b.png', 'Pasted image (143).png', 'visual_variant', 0, 2, 'committed', NULL, '2026-06-30 09:24:52', '2026-06-30 09:26:45'),
(16, 1, 296, 'BABYFOOTIE15', 979, 'bulk-temp/6a438b64dc7a9.png', 'Pasted image (171).png', 'visual_variant', 0, 3, 'committed', NULL, '2026-06-30 09:24:52', '2026-06-30 09:26:45'),
(17, 1, 296, 'BABYFOOTIE15', 975, 'bulk-temp/6a438b64e07cf.png', '1.png', 'visual_variant', 1, 0, 'committed', NULL, '2026-06-30 09:24:52', '2026-06-30 09:26:45'),
(18, 1, 296, 'BABYFOOTIE15', 975, 'bulk-temp/6a438b64e2092.png', 'Pasted image (129).png', 'visual_variant', 0, 1, 'committed', NULL, '2026-06-30 09:24:52', '2026-06-30 09:26:45'),
(19, 1, 296, 'BABYFOOTIE15', 975, 'bulk-temp/6a438b64e39da.png', 'Pasted image (195).png', 'visual_variant', 0, 2, 'committed', NULL, '2026-06-30 09:24:52', '2026-06-30 09:26:45'),
(20, 1, 296, 'BABYFOOTIE15', 975, 'bulk-temp/6a438b64e4fe2.png', 'Pasted image (31).png', 'visual_variant', 0, 3, 'committed', NULL, '2026-06-30 09:24:52', '2026-06-30 09:26:45'),
(21, 1, 285, 'BABYNIGHTS04', 976, 'bulk-temp/6a438b64e8640.png', '1.png', 'visual_variant', 1, 0, 'committed', NULL, '2026-06-30 09:24:52', '2026-06-30 09:26:44'),
(22, 1, 285, 'BABYNIGHTS04', 976, 'bulk-temp/6a438b64e9ede.png', 'Pasted image (122).png', 'visual_variant', 0, 1, 'committed', NULL, '2026-06-30 09:24:52', '2026-06-30 09:26:44'),
(23, 1, 285, 'BABYNIGHTS04', 976, 'bulk-temp/6a438b64ebdd6.png', 'Pasted image (33).png', 'visual_variant', 0, 2, 'committed', NULL, '2026-06-30 09:24:52', '2026-06-30 09:26:44'),
(24, 1, 285, 'BABYNIGHTS04', 976, 'bulk-temp/6a438b64ed8f4.png', 'Pasted image (55).png', 'visual_variant', 0, 3, 'committed', NULL, '2026-06-30 09:24:52', '2026-06-30 09:26:44'),
(25, 1, 285, 'BABYNIGHTS04', 975, 'bulk-temp/6a438b64f010e.png', '1.png', 'visual_variant', 1, 0, 'committed', NULL, '2026-06-30 09:24:52', '2026-06-30 09:26:44'),
(26, 1, 285, 'BABYNIGHTS04', 975, 'bulk-temp/6a438b64f1868.png', 'Pasted image (65).png', 'visual_variant', 0, 1, 'committed', NULL, '2026-06-30 09:24:52', '2026-06-30 09:26:44'),
(27, 1, 285, 'BABYNIGHTS04', 975, 'bulk-temp/6a438b64f2ee1.png', 'Pasted image (92).png', 'visual_variant', 0, 2, 'committed', NULL, '2026-06-30 09:24:52', '2026-06-30 09:26:44'),
(28, 1, 285, 'BABYNIGHTS04', 975, 'bulk-temp/6a438b6500307.png', 'Screenshot from 2026-03-05 11-22-37.png', 'visual_variant', 0, 3, 'committed', NULL, '2026-06-30 09:24:53', '2026-06-30 09:26:44'),
(29, 1, 282, 'BABYROMPER01', 976, 'bulk-temp/6a438b65030ea.png', '1.png', 'visual_variant', 1, 0, 'committed', NULL, '2026-06-30 09:24:53', '2026-06-30 09:26:43'),
(30, 1, 282, 'BABYROMPER01', 976, 'bulk-temp/6a438b6504a2e.png', 'Pasted image (118).png', 'visual_variant', 0, 1, 'committed', NULL, '2026-06-30 09:24:53', '2026-06-30 09:26:43'),
(31, 1, 282, 'BABYROMPER01', 976, 'bulk-temp/6a438b6506296.png', 'Pasted image (12).png', 'visual_variant', 0, 2, 'committed', NULL, '2026-06-30 09:24:53', '2026-06-30 09:26:43'),
(32, 1, 282, 'BABYROMPER01', 976, 'bulk-temp/6a438b650781f.png', 'Pasted image (132).png', 'visual_variant', 0, 3, 'committed', NULL, '2026-06-30 09:24:53', '2026-06-30 09:26:43'),
(33, 1, 282, 'BABYROMPER01', 979, 'bulk-temp/6a438b650a785.png', '1.png', 'visual_variant', 1, 0, 'committed', NULL, '2026-06-30 09:24:53', '2026-06-30 09:26:43'),
(34, 1, 282, 'BABYROMPER01', 979, 'bulk-temp/6a438b650c147.png', 'Pasted image (118).png', 'visual_variant', 0, 1, 'committed', NULL, '2026-06-30 09:24:53', '2026-06-30 09:26:43'),
(35, 1, 282, 'BABYROMPER01', 979, 'bulk-temp/6a438b650dcb3.png', 'Pasted image (145).png', 'visual_variant', 0, 2, 'committed', NULL, '2026-06-30 09:24:53', '2026-06-30 09:26:43'),
(36, 1, 282, 'BABYROMPER01', 979, 'bulk-temp/6a438b650f81a.png', 'Pasted image (9).png', 'visual_variant', 0, 3, 'committed', NULL, '2026-06-30 09:24:53', '2026-06-30 09:26:43'),
(37, 1, 282, 'BABYROMPER01', 975, 'bulk-temp/6a438b6514631.png', '1.png', 'visual_variant', 1, 0, 'committed', NULL, '2026-06-30 09:24:53', '2026-06-30 09:26:43'),
(38, 1, 282, 'BABYROMPER01', 975, 'bulk-temp/6a438b6516b44.png', 'Pasted image (12).png', 'visual_variant', 0, 1, 'committed', NULL, '2026-06-30 09:24:53', '2026-06-30 09:26:43'),
(39, 1, 282, 'BABYROMPER01', 975, 'bulk-temp/6a438b6518b49.png', 'Pasted image (41).png', 'visual_variant', 0, 2, 'committed', NULL, '2026-06-30 09:24:53', '2026-06-30 09:26:43'),
(40, 1, 282, 'BABYROMPER01', 975, 'bulk-temp/6a438b651a637.png', 'Screenshot from 2026-03-05 11-22-55.png', 'visual_variant', 0, 3, 'committed', NULL, '2026-06-30 09:24:53', '2026-06-30 09:26:43'),
(41, 1, 292, 'BABYSLEEPS11', 976, 'bulk-temp/6a438b651f5c4.png', '1.png', 'visual_variant', 1, 0, 'committed', NULL, '2026-06-30 09:24:53', '2026-06-30 09:26:45'),
(42, 1, 292, 'BABYSLEEPS11', 976, 'bulk-temp/6a438b652101a.png', 'Pasted image (102).png', 'visual_variant', 0, 1, 'committed', NULL, '2026-06-30 09:24:53', '2026-06-30 09:26:45'),
(43, 1, 292, 'BABYSLEEPS11', 976, 'bulk-temp/6a438b65229af.png', 'Pasted image (188).png', 'visual_variant', 0, 2, 'committed', NULL, '2026-06-30 09:24:53', '2026-06-30 09:26:45'),
(44, 1, 292, 'BABYSLEEPS11', 976, 'bulk-temp/6a438b65240c7.png', 'Pasted image (193).png', 'visual_variant', 0, 3, 'committed', NULL, '2026-06-30 09:24:53', '2026-06-30 09:26:45'),
(45, 1, 292, 'BABYSLEEPS11', 979, 'bulk-temp/6a438b652682d.png', '1.png', 'visual_variant', 1, 0, 'committed', NULL, '2026-06-30 09:24:53', '2026-06-30 09:26:45'),
(46, 1, 292, 'BABYSLEEPS11', 979, 'bulk-temp/6a438b652818a.png', 'GREEN-XL-top.png', 'visual_variant', 0, 1, 'committed', NULL, '2026-06-30 09:24:53', '2026-06-30 09:26:45'),
(47, 1, 292, 'BABYSLEEPS11', 979, 'bulk-temp/6a438b652a657.png', 'Pasted image (118).png', 'visual_variant', 0, 2, 'committed', NULL, '2026-06-30 09:24:53', '2026-06-30 09:26:45'),
(48, 1, 292, 'BABYSLEEPS11', 979, 'bulk-temp/6a438b652c163.png', 'Pasted image (95).png', 'visual_variant', 0, 3, 'committed', NULL, '2026-06-30 09:24:53', '2026-06-30 09:26:45'),
(49, 1, 292, 'BABYSLEEPS11', 975, 'bulk-temp/6a438b652ecf1.png', '1.png', 'visual_variant', 1, 0, 'committed', NULL, '2026-06-30 09:24:53', '2026-06-30 09:26:45'),
(50, 1, 292, 'BABYSLEEPS11', 975, 'bulk-temp/6a438b653056a.png', 'Pasted image (113).png', 'visual_variant', 0, 1, 'committed', NULL, '2026-06-30 09:24:53', '2026-06-30 09:26:45'),
(51, 1, 292, 'BABYSLEEPS11', 975, 'bulk-temp/6a438b6531f17.png', 'Pasted image (136).png', 'visual_variant', 0, 2, 'committed', NULL, '2026-06-30 09:24:53', '2026-06-30 09:26:45'),
(52, 1, 292, 'BABYSLEEPS11', 975, 'bulk-temp/6a438b6533715.png', 'Pasted image (191).png', 'visual_variant', 0, 3, 'committed', NULL, '2026-06-30 09:24:53', '2026-06-30 09:26:45'),
(53, 1, 325, 'BOARDGAME01', NULL, 'bulk-temp/6a438b65359cb.png', '1.png', 'simple', 1, 0, 'committed', NULL, '2026-06-30 09:24:53', '2026-06-30 09:26:47'),
(54, 1, 325, 'BOARDGAME01', NULL, 'bulk-temp/6a438b6537188.png', 'Pasted image (127).png', 'simple', 0, 1, 'committed', NULL, '2026-06-30 09:24:53', '2026-06-30 09:26:47'),
(55, 1, 325, 'BOARDGAME01', NULL, 'bulk-temp/6a438b6538b7f.png', 'Pasted image (15).png', 'simple', 0, 2, 'committed', NULL, '2026-06-30 09:24:53', '2026-06-30 09:26:47'),
(56, 1, 325, 'BOARDGAME01', NULL, 'bulk-temp/6a438b653a534.png', 'Pasted image (39).png', 'simple', 0, 3, 'committed', NULL, '2026-06-30 09:24:53', '2026-06-30 09:26:47'),
(57, 1, 326, 'BOARDGAME02', NULL, 'bulk-temp/6a438b653cd49.png', '1.png', 'simple', 1, 0, 'committed', NULL, '2026-06-30 09:24:53', '2026-06-30 09:26:47'),
(58, 1, 326, 'BOARDGAME02', NULL, 'bulk-temp/6a438b653ded2.png', 'Pasted image (185).png', 'simple', 0, 1, 'committed', NULL, '2026-06-30 09:24:53', '2026-06-30 09:26:47'),
(59, 1, 326, 'BOARDGAME02', NULL, 'bulk-temp/6a438b653f28a.png', 'Pasted image (48).png', 'simple', 0, 2, 'committed', NULL, '2026-06-30 09:24:53', '2026-06-30 09:26:47'),
(60, 1, 326, 'BOARDGAME02', NULL, 'bulk-temp/6a438b65405c5.png', 'Pasted image (66).png', 'simple', 0, 3, 'committed', NULL, '2026-06-30 09:24:53', '2026-06-30 09:26:47'),
(61, 1, 327, 'BOARDGAME03', NULL, 'bulk-temp/6a438b65429b8.png', '1.png', 'simple', 1, 0, 'committed', NULL, '2026-06-30 09:24:53', '2026-06-30 09:26:47'),
(62, 1, 327, 'BOARDGAME03', NULL, 'bulk-temp/6a438b654452a.png', 'Pasted image (178).png', 'simple', 0, 1, 'committed', NULL, '2026-06-30 09:24:53', '2026-06-30 09:26:47'),
(63, 1, 327, 'BOARDGAME03', NULL, 'bulk-temp/6a438b6545ea9.png', 'Pasted image (91).png', 'simple', 0, 2, 'committed', NULL, '2026-06-30 09:24:53', '2026-06-30 09:26:47'),
(64, 1, 327, 'BOARDGAME03', NULL, 'bulk-temp/6a438b65474d8.png', 'RED-XL.png', 'simple', 0, 3, 'committed', NULL, '2026-06-30 09:24:53', '2026-06-30 09:26:47'),
(65, 1, 328, 'BOARDGAME04', NULL, 'bulk-temp/6a438b6549eab.png', '1.png', 'simple', 1, 0, 'committed', NULL, '2026-06-30 09:24:53', '2026-06-30 09:26:47'),
(66, 1, 328, 'BOARDGAME04', NULL, 'bulk-temp/6a438b654b64a.png', 'Pasted image (21).png', 'simple', 0, 1, 'committed', NULL, '2026-06-30 09:24:53', '2026-06-30 09:26:47'),
(67, 1, 328, 'BOARDGAME04', NULL, 'bulk-temp/6a438b654cef9.png', 'Pasted image (22).png', 'simple', 0, 2, 'committed', NULL, '2026-06-30 09:24:53', '2026-06-30 09:26:47'),
(68, 1, 328, 'BOARDGAME04', NULL, 'bulk-temp/6a438b654e389.png', 'Screenshot from 2026-03-05 11-22-31.png', 'simple', 0, 3, 'committed', NULL, '2026-06-30 09:24:53', '2026-06-30 09:26:47'),
(69, 1, 329, 'BOARDGAME05', NULL, 'bulk-temp/6a438b6550b6e.png', '1.png', 'simple', 1, 0, 'committed', NULL, '2026-06-30 09:24:53', '2026-06-30 09:26:47'),
(70, 1, 329, 'BOARDGAME05', NULL, 'bulk-temp/6a438b6552294.png', 'Pasted image (140).png', 'simple', 0, 1, 'committed', NULL, '2026-06-30 09:24:53', '2026-06-30 09:26:47'),
(71, 1, 329, 'BOARDGAME05', NULL, 'bulk-temp/6a438b65536a0.png', 'Pasted image (92).png', 'simple', 0, 2, 'committed', NULL, '2026-06-30 09:24:53', '2026-06-30 09:26:48'),
(72, 1, 329, 'BOARDGAME05', NULL, 'bulk-temp/6a438b65549b8.png', 'Pasted image (97).png', 'simple', 0, 3, 'committed', NULL, '2026-06-30 09:24:53', '2026-06-30 09:26:48'),
(73, 1, 330, 'BOARDGAME06', NULL, 'bulk-temp/6a438b6557673.png', '1.png', 'simple', 1, 0, 'committed', NULL, '2026-06-30 09:24:53', '2026-06-30 09:26:48'),
(74, 1, 330, 'BOARDGAME06', NULL, 'bulk-temp/6a438b65590ee.png', 'Pasted image (167).png', 'simple', 0, 1, 'committed', NULL, '2026-06-30 09:24:53', '2026-06-30 09:26:48'),
(75, 1, 330, 'BOARDGAME06', NULL, 'bulk-temp/6a438b655a72f.png', 'Pasted image (28).png', 'simple', 0, 2, 'committed', NULL, '2026-06-30 09:24:53', '2026-06-30 09:26:48'),
(76, 1, 330, 'BOARDGAME06', NULL, 'bulk-temp/6a438b655c193.png', 'Pasted image (83).png', 'simple', 0, 3, 'committed', NULL, '2026-06-30 09:24:53', '2026-06-30 09:26:48'),
(77, 1, 331, 'BOARDGAME07', NULL, 'bulk-temp/6a438b655f227.png', '1.png', 'simple', 1, 0, 'committed', NULL, '2026-06-30 09:24:53', '2026-06-30 09:26:48'),
(78, 1, 331, 'BOARDGAME07', NULL, 'bulk-temp/6a438b6560ae4.png', 'Pasted image (178).png', 'simple', 0, 1, 'committed', NULL, '2026-06-30 09:24:53', '2026-06-30 09:26:48'),
(79, 1, 331, 'BOARDGAME07', NULL, 'bulk-temp/6a438b6562803.png', 'Pasted image (33).png', 'simple', 0, 2, 'committed', NULL, '2026-06-30 09:24:53', '2026-06-30 09:26:48'),
(80, 1, 331, 'BOARDGAME07', NULL, 'bulk-temp/6a438b6564512.png', 'Pasted image (59).png', 'simple', 0, 3, 'committed', NULL, '2026-06-30 09:24:53', '2026-06-30 09:26:48'),
(81, 1, 332, 'BOARDGAME08', NULL, 'bulk-temp/6a438b6567bd5.png', '1.png', 'simple', 1, 0, 'committed', NULL, '2026-06-30 09:24:53', '2026-06-30 09:26:48'),
(82, 1, 332, 'BOARDGAME08', NULL, 'bulk-temp/6a438b656953c.png', 'GREEN-XL-top.png', 'simple', 0, 1, 'committed', NULL, '2026-06-30 09:24:53', '2026-06-30 09:26:48'),
(83, 1, 332, 'BOARDGAME08', NULL, 'bulk-temp/6a438b656b85e.png', 'Pasted image (109).png', 'simple', 0, 2, 'committed', NULL, '2026-06-30 09:24:53', '2026-06-30 09:26:48'),
(84, 1, 332, 'BOARDGAME08', NULL, 'bulk-temp/6a438b656d473.png', 'Pasted image (80).png', 'simple', 0, 3, 'committed', NULL, '2026-06-30 09:24:53', '2026-06-30 09:26:48'),
(85, 1, 333, 'BOARDGAME09', NULL, 'bulk-temp/6a438b657145f.png', '1.png', 'simple', 1, 0, 'committed', NULL, '2026-06-30 09:24:53', '2026-06-30 09:26:48'),
(86, 1, 333, 'BOARDGAME09', NULL, 'bulk-temp/6a438b65730b2.png', 'Pasted image (196).png', 'simple', 0, 1, 'committed', NULL, '2026-06-30 09:24:53', '2026-06-30 09:26:48'),
(87, 1, 333, 'BOARDGAME09', NULL, 'bulk-temp/6a438b6574a0f.png', 'Pasted image (35).png', 'simple', 0, 2, 'committed', NULL, '2026-06-30 09:24:53', '2026-06-30 09:26:48'),
(88, 1, 333, 'BOARDGAME09', NULL, 'bulk-temp/6a438b657671c.png', 'Pasted image (82).png', 'simple', 0, 3, 'committed', NULL, '2026-06-30 09:24:53', '2026-06-30 09:26:48'),
(89, 1, 334, 'BOARDGAME10', NULL, 'bulk-temp/6a438b6579553.png', '1.png', 'simple', 1, 0, 'committed', NULL, '2026-06-30 09:24:53', '2026-06-30 09:26:48'),
(90, 1, 334, 'BOARDGAME10', NULL, 'bulk-temp/6a438b657b5ed.png', 'Pasted image (58).png', 'simple', 0, 1, 'committed', NULL, '2026-06-30 09:24:53', '2026-06-30 09:26:48'),
(91, 1, 334, 'BOARDGAME10', NULL, 'bulk-temp/6a438b657d0fb.png', 'Pasted image (66).png', 'simple', 0, 2, 'committed', NULL, '2026-06-30 09:24:53', '2026-06-30 09:26:48'),
(92, 1, 334, 'BOARDGAME10', NULL, 'bulk-temp/6a438b657ecda.png', 'Screenshot from 2026-03-04 15-02-09.png', 'simple', 0, 3, 'committed', NULL, '2026-06-30 09:24:53', '2026-06-30 09:26:48'),
(93, 1, 304, 'BOYSCASUAL23', 977, 'bulk-temp/6a438b65829ad.png', '1.png', 'visual_variant', 1, 0, 'committed', NULL, '2026-06-30 09:24:53', '2026-06-30 09:26:46'),
(94, 1, 304, 'BOYSCASUAL23', 977, 'bulk-temp/6a438b658493c.png', 'Pasted image (167).png', 'visual_variant', 0, 1, 'committed', NULL, '2026-06-30 09:24:53', '2026-06-30 09:26:46'),
(95, 1, 304, 'BOYSCASUAL23', 977, 'bulk-temp/6a438b6586edc.png', 'Pasted image (21).png', 'visual_variant', 0, 2, 'committed', NULL, '2026-06-30 09:24:53', '2026-06-30 09:26:46'),
(96, 1, 304, 'BOYSCASUAL23', 977, 'bulk-temp/6a438b658903d.png', 'Pasted image (56).png', 'visual_variant', 0, 3, 'committed', NULL, '2026-06-30 09:24:53', '2026-06-30 09:26:46'),
(97, 1, 304, 'BOYSCASUAL23', 976, 'bulk-temp/6a438b658d1c4.png', '1.png', 'visual_variant', 1, 0, 'committed', NULL, '2026-06-30 09:24:53', '2026-06-30 09:26:46'),
(98, 1, 304, 'BOYSCASUAL23', 976, 'bulk-temp/6a438b658f9a8.png', 'Pasted image (107).png', 'visual_variant', 0, 1, 'committed', NULL, '2026-06-30 09:24:53', '2026-06-30 09:26:46'),
(99, 1, 304, 'BOYSCASUAL23', 976, 'bulk-temp/6a438b6593cf0.png', 'Pasted image (193).png', 'visual_variant', 0, 2, 'committed', NULL, '2026-06-30 09:24:53', '2026-06-30 09:26:46'),
(100, 1, 304, 'BOYSCASUAL23', 976, 'bulk-temp/6a438b659744a.png', 'Pasted image (64).png', 'visual_variant', 0, 3, 'committed', NULL, '2026-06-30 09:24:53', '2026-06-30 09:26:46'),
(101, 1, 298, 'BOYSNIGHTP17', 976, 'bulk-temp/6a438b659a23e.png', '1.png', 'visual_variant', 1, 0, 'committed', NULL, '2026-06-30 09:24:53', '2026-06-30 09:26:45'),
(102, 1, 298, 'BOYSNIGHTP17', 976, 'bulk-temp/6a438b659b91a.png', 'Pasted image (41).png', 'visual_variant', 0, 1, 'committed', NULL, '2026-06-30 09:24:53', '2026-06-30 09:26:45'),
(103, 1, 298, 'BOYSNIGHTP17', 976, 'bulk-temp/6a438b659cf51.png', 'Pasted image (8).png', 'visual_variant', 0, 2, 'committed', NULL, '2026-06-30 09:24:53', '2026-06-30 09:26:45'),
(104, 1, 298, 'BOYSNIGHTP17', 976, 'bulk-temp/6a438b659e724.png', 'Pasted image (9).png', 'visual_variant', 0, 3, 'committed', NULL, '2026-06-30 09:24:53', '2026-06-30 09:26:45'),
(105, 1, 298, 'BOYSNIGHTP17', 978, 'bulk-temp/6a438b65a0d9f.png', '1.png', 'visual_variant', 1, 0, 'committed', NULL, '2026-06-30 09:24:53', '2026-06-30 09:26:45'),
(106, 1, 298, 'BOYSNIGHTP17', 978, 'bulk-temp/6a438b65a27af.png', 'Pasted image (158).png', 'visual_variant', 0, 1, 'committed', NULL, '2026-06-30 09:24:53', '2026-06-30 09:26:45'),
(107, 1, 298, 'BOYSNIGHTP17', 978, 'bulk-temp/6a438b65a3fa0.png', 'Pasted image (19).png', 'visual_variant', 0, 2, 'committed', NULL, '2026-06-30 09:24:53', '2026-06-30 09:26:45'),
(108, 1, 298, 'BOYSNIGHTP17', 978, 'bulk-temp/6a438b65a588c.png', 'Pasted image (43).png', 'visual_variant', 0, 3, 'committed', NULL, '2026-06-30 09:24:53', '2026-06-30 09:26:46'),
(109, 1, 295, 'BOYSSPORTS14', 977, 'bulk-temp/6a438b65a85b7.png', '1.png', 'visual_variant', 1, 0, 'committed', NULL, '2026-06-30 09:24:53', '2026-06-30 09:26:45'),
(110, 1, 295, 'BOYSSPORTS14', 977, 'bulk-temp/6a438b65a9ce2.png', 'Pasted image (17).png', 'visual_variant', 0, 1, 'committed', NULL, '2026-06-30 09:24:53', '2026-06-30 09:26:45'),
(111, 1, 295, 'BOYSSPORTS14', 977, 'bulk-temp/6a438b65ab3d9.png', 'Pasted image (70).png', 'visual_variant', 0, 2, 'committed', NULL, '2026-06-30 09:24:53', '2026-06-30 09:26:45'),
(112, 1, 295, 'BOYSSPORTS14', 977, 'bulk-temp/6a438b65ac939.png', 'Screenshot from 2026-03-05 11-23-05.png', 'visual_variant', 0, 3, 'committed', NULL, '2026-06-30 09:24:53', '2026-06-30 09:26:45'),
(113, 1, 295, 'BOYSSPORTS14', 976, 'bulk-temp/6a438b65af2b4.png', '1.png', 'visual_variant', 1, 0, 'committed', NULL, '2026-06-30 09:24:53', '2026-06-30 09:26:45'),
(114, 1, 295, 'BOYSSPORTS14', 976, 'bulk-temp/6a438b65b06ba.png', 'Pasted image (148).png', 'visual_variant', 0, 1, 'committed', NULL, '2026-06-30 09:24:53', '2026-06-30 09:26:45'),
(115, 1, 295, 'BOYSSPORTS14', 976, 'bulk-temp/6a438b65b1bb5.png', 'Screenshot from 2026-03-04 15-02-42.png', 'visual_variant', 0, 2, 'committed', NULL, '2026-06-30 09:24:53', '2026-06-30 09:26:45'),
(116, 1, 295, 'BOYSSPORTS14', 976, 'bulk-temp/6a438b65b317a.png', 'WHITE-XXL-top.png', 'visual_variant', 0, 3, 'committed', NULL, '2026-06-30 09:24:53', '2026-06-30 09:26:45'),
(117, 1, 295, 'BOYSSPORTS14', 974, 'bulk-temp/6a438b65b5358.png', '1.png', 'visual_variant', 1, 0, 'committed', NULL, '2026-06-30 09:24:53', '2026-06-30 09:26:45'),
(118, 1, 295, 'BOYSSPORTS14', 974, 'bulk-temp/6a438b65b67d5.png', 'Pasted image (108).png', 'visual_variant', 0, 1, 'committed', NULL, '2026-06-30 09:24:53', '2026-06-30 09:26:45'),
(119, 1, 295, 'BOYSSPORTS14', 974, 'bulk-temp/6a438b65b7936.png', 'Pasted image (112).png', 'visual_variant', 0, 2, 'committed', NULL, '2026-06-30 09:24:53', '2026-06-30 09:26:45'),
(120, 1, 295, 'BOYSSPORTS14', 974, 'bulk-temp/6a438b65b911f.png', 'Screenshot from 2026-03-05 11-22-37.png', 'visual_variant', 0, 3, 'committed', NULL, '2026-06-30 09:24:53', '2026-06-30 09:26:45'),
(121, 1, 291, 'BOYSSUITSE10', 977, 'bulk-temp/6a438b65bc106.png', '1.png', 'visual_variant', 1, 0, 'committed', NULL, '2026-06-30 09:24:53', '2026-06-30 09:26:45'),
(122, 1, 291, 'BOYSSUITSE10', 977, 'bulk-temp/6a438b65bd420.png', 'Pasted image (11).png', 'visual_variant', 0, 1, 'committed', NULL, '2026-06-30 09:24:53', '2026-06-30 09:26:45'),
(123, 1, 291, 'BOYSSUITSE10', 977, 'bulk-temp/6a438b65beb71.png', 'Pasted image (90).png', 'visual_variant', 0, 2, 'committed', NULL, '2026-06-30 09:24:53', '2026-06-30 09:26:45'),
(124, 1, 291, 'BOYSSUITSE10', 977, 'bulk-temp/6a438b65c0304.png', 'RED-L.png', 'visual_variant', 0, 3, 'committed', NULL, '2026-06-30 09:24:53', '2026-06-30 09:26:45'),
(125, 1, 291, 'BOYSSUITSE10', 976, 'bulk-temp/6a438b65c3b10.png', '1.png', 'visual_variant', 1, 0, 'committed', NULL, '2026-06-30 09:24:53', '2026-06-30 09:26:45'),
(126, 1, 291, 'BOYSSUITSE10', 976, 'bulk-temp/6a438b65c508d.png', 'Pasted image (103).png', 'visual_variant', 0, 1, 'committed', NULL, '2026-06-30 09:24:53', '2026-06-30 09:26:45'),
(127, 1, 291, 'BOYSSUITSE10', 976, 'bulk-temp/6a438b65c675c.png', 'Pasted image (141).png', 'visual_variant', 0, 2, 'committed', NULL, '2026-06-30 09:24:53', '2026-06-30 09:26:45'),
(128, 1, 291, 'BOYSSUITSE10', 976, 'bulk-temp/6a438b65c7d71.png', 'Pasted image (143).png', 'visual_variant', 0, 3, 'committed', NULL, '2026-06-30 09:24:53', '2026-06-30 09:26:45'),
(129, 1, 308, 'EDUTOY02', NULL, 'bulk-temp/6a438b65cbe93.png', '1.png', 'simple', 1, 0, 'committed', NULL, '2026-06-30 09:24:53', '2026-06-30 09:26:47'),
(130, 1, 308, 'EDUTOY02', NULL, 'bulk-temp/6a438b65cd671.png', 'Pasted image (109).png', 'simple', 0, 1, 'committed', NULL, '2026-06-30 09:24:53', '2026-06-30 09:26:47'),
(131, 1, 308, 'EDUTOY02', NULL, 'bulk-temp/6a438b65cedeb.png', 'Pasted image (177).png', 'simple', 0, 2, 'committed', NULL, '2026-06-30 09:24:53', '2026-06-30 09:26:47'),
(132, 1, 308, 'EDUTOY02', NULL, 'bulk-temp/6a438b65d0332.png', 'Pasted image (19).png', 'simple', 0, 3, 'committed', NULL, '2026-06-30 09:24:53', '2026-06-30 09:26:47'),
(133, 1, 309, 'EDUTOY03', NULL, 'bulk-temp/6a438b65d2f63.png', '1.png', 'simple', 1, 0, 'committed', NULL, '2026-06-30 09:24:53', '2026-06-30 09:26:47'),
(134, 1, 309, 'EDUTOY03', NULL, 'bulk-temp/6a438b65d42ae.png', 'Pasted image (105).png', 'simple', 0, 1, 'committed', NULL, '2026-06-30 09:24:53', '2026-06-30 09:26:47'),
(135, 1, 309, 'EDUTOY03', NULL, 'bulk-temp/6a438b65d59b1.png', 'Pasted image (116).png', 'simple', 0, 2, 'committed', NULL, '2026-06-30 09:24:53', '2026-06-30 09:26:47'),
(136, 1, 309, 'EDUTOY03', NULL, 'bulk-temp/6a438b65d7a74.png', 'Pasted image (78).png', 'simple', 0, 3, 'committed', NULL, '2026-06-30 09:24:53', '2026-06-30 09:26:47'),
(137, 1, 310, 'EDUTOY04', NULL, 'bulk-temp/6a438b65e00b7.png', '1.png', 'simple', 1, 0, 'committed', NULL, '2026-06-30 09:24:53', '2026-06-30 09:26:47'),
(138, 1, 310, 'EDUTOY04', NULL, 'bulk-temp/6a438b65e12cb.png', 'Pasted image (69).png', 'simple', 0, 1, 'committed', NULL, '2026-06-30 09:24:53', '2026-06-30 09:26:47'),
(139, 1, 310, 'EDUTOY04', NULL, 'bulk-temp/6a438b65e3037.png', 'Pasted image (79).png', 'simple', 0, 2, 'committed', NULL, '2026-06-30 09:24:53', '2026-06-30 09:26:47'),
(140, 1, 310, 'EDUTOY04', NULL, 'bulk-temp/6a438b65e450a.png', 'Screenshot from 2026-03-05 11-22-41.png', 'simple', 0, 3, 'committed', NULL, '2026-06-30 09:24:53', '2026-06-30 09:26:47'),
(141, 1, 311, 'EDUTOY05', NULL, 'bulk-temp/6a438b65e6ba9.png', '1.png', 'simple', 1, 0, 'committed', NULL, '2026-06-30 09:24:53', '2026-06-30 09:26:47'),
(142, 1, 311, 'EDUTOY05', NULL, 'bulk-temp/6a438b65e8123.png', 'Pasted image (100).png', 'simple', 0, 1, 'committed', NULL, '2026-06-30 09:24:53', '2026-06-30 09:26:47'),
(143, 1, 311, 'EDUTOY05', NULL, 'bulk-temp/6a438b65e9990.png', 'Pasted image (161).png', 'simple', 0, 2, 'committed', NULL, '2026-06-30 09:24:53', '2026-06-30 09:26:47'),
(144, 1, 311, 'EDUTOY05', NULL, 'bulk-temp/6a438b65eb18d.png', 'Pasted image (21).png', 'simple', 0, 3, 'committed', NULL, '2026-06-30 09:24:53', '2026-06-30 09:26:47'),
(145, 1, 312, 'EDUTOY06', NULL, 'bulk-temp/6a438b65eda5c.png', '1.png', 'simple', 1, 0, 'committed', NULL, '2026-06-30 09:24:53', '2026-06-30 09:26:47'),
(146, 1, 312, 'EDUTOY06', NULL, 'bulk-temp/6a438b65ef219.png', 'Pasted image (10).png', 'simple', 0, 1, 'committed', NULL, '2026-06-30 09:24:53', '2026-06-30 09:26:47'),
(147, 1, 312, 'EDUTOY06', NULL, 'bulk-temp/6a438b65f0572.png', 'Pasted image (132).png', 'simple', 0, 2, 'committed', NULL, '2026-06-30 09:24:53', '2026-06-30 09:26:47'),
(148, 1, 312, 'EDUTOY06', NULL, 'bulk-temp/6a438b65f1ab0.png', 'Pasted image (169).png', 'simple', 0, 3, 'committed', NULL, '2026-06-30 09:24:53', '2026-06-30 09:26:47'),
(149, 1, 313, 'EDUTOY07', NULL, 'bulk-temp/6a438b66005fe.png', '1.png', 'simple', 1, 0, 'committed', NULL, '2026-06-30 09:24:54', '2026-06-30 09:26:47'),
(150, 1, 313, 'EDUTOY07', NULL, 'bulk-temp/6a438b66027bd.png', 'Pasted image (12).png', 'simple', 0, 1, 'committed', NULL, '2026-06-30 09:24:54', '2026-06-30 09:26:47'),
(151, 1, 313, 'EDUTOY07', NULL, 'bulk-temp/6a438b6603eaf.png', 'Pasted image (18).png', 'simple', 0, 2, 'committed', NULL, '2026-06-30 09:24:54', '2026-06-30 09:26:47'),
(152, 1, 313, 'EDUTOY07', NULL, 'bulk-temp/6a438b6605493.png', 'Pasted image (78).png', 'simple', 0, 3, 'committed', NULL, '2026-06-30 09:24:54', '2026-06-30 09:26:47'),
(153, 1, 314, 'EDUTOY08', NULL, 'bulk-temp/6a438b66074a6.png', '1.png', 'simple', 1, 0, 'committed', NULL, '2026-06-30 09:24:54', '2026-06-30 09:26:47'),
(154, 1, 314, 'EDUTOY08', NULL, 'bulk-temp/6a438b6608793.png', 'Pasted image (101).png', 'simple', 0, 1, 'committed', NULL, '2026-06-30 09:24:54', '2026-06-30 09:26:47'),
(155, 1, 314, 'EDUTOY08', NULL, 'bulk-temp/6a438b6609c00.png', 'Pasted image (149).png', 'simple', 0, 2, 'committed', NULL, '2026-06-30 09:24:54', '2026-06-30 09:26:47'),
(156, 1, 314, 'EDUTOY08', NULL, 'bulk-temp/6a438b660b01b.png', 'Pasted image (93).png', 'simple', 0, 3, 'committed', NULL, '2026-06-30 09:24:54', '2026-06-30 09:26:47'),
(157, 1, 315, 'EDUTOY09', NULL, 'bulk-temp/6a438b660deee.png', '1.png', 'simple', 1, 0, 'committed', NULL, '2026-06-30 09:24:54', '2026-06-30 09:26:47'),
(158, 1, 315, 'EDUTOY09', NULL, 'bulk-temp/6a438b660f4bb.png', 'Pasted image (132).png', 'simple', 0, 1, 'committed', NULL, '2026-06-30 09:24:54', '2026-06-30 09:26:47'),
(159, 1, 315, 'EDUTOY09', NULL, 'bulk-temp/6a438b66106fd.png', 'Pasted image (137).png', 'simple', 0, 2, 'committed', NULL, '2026-06-30 09:24:54', '2026-06-30 09:26:47'),
(160, 1, 315, 'EDUTOY09', NULL, 'bulk-temp/6a438b6611dac.png', 'Pasted image (86).png', 'simple', 0, 3, 'committed', NULL, '2026-06-30 09:24:54', '2026-06-30 09:26:47'),
(161, 1, 316, 'EDUTOY10', NULL, 'bulk-temp/6a438b6614423.png', '1.png', 'simple', 1, 0, 'committed', NULL, '2026-06-30 09:24:54', '2026-06-30 09:26:47'),
(162, 1, 316, 'EDUTOY10', NULL, 'bulk-temp/6a438b661561c.png', 'Pasted image (164).png', 'simple', 0, 1, 'committed', NULL, '2026-06-30 09:24:54', '2026-06-30 09:26:47'),
(163, 1, 316, 'EDUTOY10', NULL, 'bulk-temp/6a438b66164ac.png', 'Pasted image (64).png', 'simple', 0, 2, 'committed', NULL, '2026-06-30 09:24:54', '2026-06-30 09:26:47'),
(164, 1, 316, 'EDUTOY10', NULL, 'bulk-temp/6a438b6617138.png', 'Pasted image (8).png', 'simple', 0, 3, 'committed', NULL, '2026-06-30 09:24:54', '2026-06-30 09:26:47'),
(165, 1, 299, 'ETHNICKURT18', 981, 'bulk-temp/6a438b661905b.png', '1.png', 'visual_variant', 1, 0, 'committed', NULL, '2026-06-30 09:24:54', '2026-06-30 09:26:46'),
(166, 1, 299, 'ETHNICKURT18', 981, 'bulk-temp/6a438b661a42f.png', 'Pasted image (140).png', 'visual_variant', 0, 1, 'committed', NULL, '2026-06-30 09:24:54', '2026-06-30 09:26:46'),
(167, 1, 299, 'ETHNICKURT18', 981, 'bulk-temp/6a438b661b743.png', 'Pasted image (19).png', 'visual_variant', 0, 2, 'committed', NULL, '2026-06-30 09:24:54', '2026-06-30 09:26:46'),
(168, 1, 299, 'ETHNICKURT18', 981, 'bulk-temp/6a438b661c99b.png', 'Pasted image (36).png', 'visual_variant', 0, 3, 'committed', NULL, '2026-06-30 09:24:54', '2026-06-30 09:26:46'),
(169, 1, 299, 'ETHNICKURT18', 974, 'bulk-temp/6a438b661eaf1.png', '(6 - 12M).png', 'visual_variant', 0, 0, 'committed', NULL, '2026-06-30 09:24:54', '2026-06-30 09:26:46'),
(170, 1, 299, 'ETHNICKURT18', 974, 'bulk-temp/6a438b66201bd.png', '1.png', 'visual_variant', 1, 1, 'committed', NULL, '2026-06-30 09:24:54', '2026-06-30 09:26:46'),
(171, 1, 299, 'ETHNICKURT18', 974, 'bulk-temp/6a438b66215d1.png', 'Pasted image (196).png', 'visual_variant', 0, 2, 'committed', NULL, '2026-06-30 09:24:54', '2026-06-30 09:26:46'),
(172, 1, 299, 'ETHNICKURT18', 974, 'bulk-temp/6a438b6622d00.png', 'Pasted image (31).png', 'visual_variant', 0, 3, 'committed', NULL, '2026-06-30 09:24:54', '2026-06-30 09:26:46'),
(173, 1, 299, 'ETHNICKURT18', 975, 'bulk-temp/6a438b66251fa.png', '1.png', 'visual_variant', 1, 0, 'committed', NULL, '2026-06-30 09:24:54', '2026-06-30 09:26:46'),
(174, 1, 299, 'ETHNICKURT18', 975, 'bulk-temp/6a438b662677f.png', 'Pasted image (187).png', 'visual_variant', 0, 1, 'committed', NULL, '2026-06-30 09:24:54', '2026-06-30 09:26:46'),
(175, 1, 299, 'ETHNICKURT18', 975, 'bulk-temp/6a438b6627e46.png', 'Pasted image (24).png', 'visual_variant', 0, 2, 'committed', NULL, '2026-06-30 09:24:54', '2026-06-30 09:26:46'),
(176, 1, 299, 'ETHNICKURT18', 975, 'bulk-temp/6a438b6629eac.png', 'Pasted image (79).png', 'visual_variant', 0, 3, 'committed', NULL, '2026-06-30 09:24:54', '2026-06-30 09:26:46'),
(177, 1, 297, 'GIRLSBALLE16', 977, 'bulk-temp/6a438b662cf1c.png', '1.png', 'visual_variant', 1, 0, 'committed', NULL, '2026-06-30 09:24:54', '2026-06-30 09:26:45'),
(178, 1, 297, 'GIRLSBALLE16', 977, 'bulk-temp/6a438b662e5db.png', 'Pasted image (170).png', 'visual_variant', 0, 1, 'committed', NULL, '2026-06-30 09:24:54', '2026-06-30 09:26:45'),
(179, 1, 297, 'GIRLSBALLE16', 977, 'bulk-temp/6a438b662fc08.png', 'Pasted image (182).png', 'visual_variant', 0, 2, 'committed', NULL, '2026-06-30 09:24:54', '2026-06-30 09:26:45'),
(180, 1, 297, 'GIRLSBALLE16', 977, 'bulk-temp/6a438b6631387.png', 'WHITE-XXL-back.png', 'visual_variant', 0, 3, 'committed', NULL, '2026-06-30 09:24:54', '2026-06-30 09:26:45'),
(181, 1, 297, 'GIRLSBALLE16', 979, 'bulk-temp/6a438b6633807.png', '1.png', 'visual_variant', 1, 0, 'committed', NULL, '2026-06-30 09:24:54', '2026-06-30 09:26:45'),
(182, 1, 297, 'GIRLSBALLE16', 979, 'bulk-temp/6a438b6634d03.png', 'Pasted image (10).png', 'visual_variant', 0, 1, 'committed', NULL, '2026-06-30 09:24:54', '2026-06-30 09:26:45'),
(183, 1, 297, 'GIRLSBALLE16', 979, 'bulk-temp/6a438b6635fe6.png', 'Pasted image (122).png', 'visual_variant', 0, 2, 'committed', NULL, '2026-06-30 09:24:54', '2026-06-30 09:26:45'),
(184, 1, 297, 'GIRLSBALLE16', 979, 'bulk-temp/6a438b663785e.png', 'Pasted image (13).png', 'visual_variant', 0, 3, 'committed', NULL, '2026-06-30 09:24:54', '2026-06-30 09:26:45'),
(185, 1, 297, 'GIRLSBALLE16', 975, 'bulk-temp/6a438b663a324.png', '1.png', 'visual_variant', 1, 0, 'committed', NULL, '2026-06-30 09:24:54', '2026-06-30 09:26:45'),
(186, 1, 297, 'GIRLSBALLE16', 975, 'bulk-temp/6a438b663bcdd.png', 'Pasted image (145).png', 'visual_variant', 0, 1, 'committed', NULL, '2026-06-30 09:24:54', '2026-06-30 09:26:45'),
(187, 1, 297, 'GIRLSBALLE16', 975, 'bulk-temp/6a438b663d94d.png', 'Pasted image (35).png', 'visual_variant', 0, 2, 'committed', NULL, '2026-06-30 09:24:54', '2026-06-30 09:26:45'),
(188, 1, 297, 'GIRLSBALLE16', 975, 'bulk-temp/6a438b663f6d3.png', 'Pasted image (77).png', 'visual_variant', 0, 3, 'committed', NULL, '2026-06-30 09:24:54', '2026-06-30 09:26:45'),
(189, 1, 300, 'GIRLSCASUA19', 976, 'bulk-temp/6a438b6643455.png', '1.png', 'visual_variant', 1, 0, 'committed', NULL, '2026-06-30 09:24:54', '2026-06-30 09:26:46'),
(190, 1, 300, 'GIRLSCASUA19', 976, 'bulk-temp/6a438b6645291.png', 'Pasted image (156).png', 'visual_variant', 0, 1, 'committed', NULL, '2026-06-30 09:24:54', '2026-06-30 09:26:46'),
(191, 1, 300, 'GIRLSCASUA19', 976, 'bulk-temp/6a438b664746d.png', 'Pasted image (177).png', 'visual_variant', 0, 2, 'committed', NULL, '2026-06-30 09:24:54', '2026-06-30 09:26:46'),
(192, 1, 300, 'GIRLSCASUA19', 976, 'bulk-temp/6a438b6649828.png', 'Pasted image (22).png', 'visual_variant', 0, 3, 'committed', NULL, '2026-06-30 09:24:54', '2026-06-30 09:26:46'),
(193, 1, 300, 'GIRLSCASUA19', 978, 'bulk-temp/6a438b664c8f5.png', '1.png', 'visual_variant', 1, 0, 'committed', NULL, '2026-06-30 09:24:54', '2026-06-30 09:26:46'),
(194, 1, 300, 'GIRLSCASUA19', 978, 'bulk-temp/6a438b664e46e.png', 'Pasted image (123).png', 'visual_variant', 0, 1, 'committed', NULL, '2026-06-30 09:24:54', '2026-06-30 09:26:46'),
(195, 1, 300, 'GIRLSCASUA19', 978, 'bulk-temp/6a438b66500ef.png', 'Pasted image (183).png', 'visual_variant', 0, 2, 'committed', NULL, '2026-06-30 09:24:54', '2026-06-30 09:26:46'),
(196, 1, 300, 'GIRLSCASUA19', 978, 'bulk-temp/6a438b66520d1.png', 'Pasted image (90).png', 'visual_variant', 0, 3, 'committed', NULL, '2026-06-30 09:24:54', '2026-06-30 09:26:46'),
(197, 1, 300, 'GIRLSCASUA19', 975, 'bulk-temp/6a438b6655419.png', '(6 - 12M).png', 'visual_variant', 0, 0, 'committed', NULL, '2026-06-30 09:24:54', '2026-06-30 09:26:46'),
(198, 1, 300, 'GIRLSCASUA19', 975, 'bulk-temp/6a438b66571c1.png', '1.png', 'visual_variant', 1, 1, 'committed', NULL, '2026-06-30 09:24:54', '2026-06-30 09:26:46'),
(199, 1, 300, 'GIRLSCASUA19', 975, 'bulk-temp/6a438b6658ace.png', 'Pasted image (110).png', 'visual_variant', 0, 2, 'committed', NULL, '2026-06-30 09:24:54', '2026-06-30 09:26:46'),
(200, 1, 300, 'GIRLSCASUA19', 975, 'bulk-temp/6a438b665abd1.png', 'Pasted image (79).png', 'visual_variant', 0, 3, 'committed', NULL, '2026-06-30 09:24:54', '2026-06-30 09:26:46'),
(201, 1, 293, 'GIRLSETHNI12', 981, 'bulk-temp/6a438b665e8ef.png', '1.png', 'visual_variant', 1, 0, 'committed', NULL, '2026-06-30 09:24:54', '2026-06-30 09:26:45'),
(202, 1, 293, 'GIRLSETHNI12', 981, 'bulk-temp/6a438b66602f8.png', 'Pasted image (124).png', 'visual_variant', 0, 1, 'committed', NULL, '2026-06-30 09:24:54', '2026-06-30 09:26:45'),
(203, 1, 293, 'GIRLSETHNI12', 981, 'bulk-temp/6a438b6662280.png', 'Pasted image (2).png', 'visual_variant', 0, 2, 'committed', NULL, '2026-06-30 09:24:54', '2026-06-30 09:26:45'),
(204, 1, 293, 'GIRLSETHNI12', 981, 'bulk-temp/6a438b6663b56.png', 'Pasted image (89).png', 'visual_variant', 0, 3, 'committed', NULL, '2026-06-30 09:24:54', '2026-06-30 09:26:45'),
(205, 1, 293, 'GIRLSETHNI12', 979, 'bulk-temp/6a438b6666fbc.png', '1.png', 'visual_variant', 1, 0, 'committed', NULL, '2026-06-30 09:24:54', '2026-06-30 09:26:45'),
(206, 1, 293, 'GIRLSETHNI12', 979, 'bulk-temp/6a438b6668ea3.png', 'Pasted image (135).png', 'visual_variant', 0, 1, 'committed', NULL, '2026-06-30 09:24:54', '2026-06-30 09:26:45'),
(207, 1, 293, 'GIRLSETHNI12', 979, 'bulk-temp/6a438b666b567.png', 'Pasted image (163).png', 'visual_variant', 0, 2, 'committed', NULL, '2026-06-30 09:24:54', '2026-06-30 09:26:45'),
(208, 1, 293, 'GIRLSETHNI12', 979, 'bulk-temp/6a438b666cd2d.png', 'Pasted image (174).png', 'visual_variant', 0, 3, 'committed', NULL, '2026-06-30 09:24:54', '2026-06-30 09:26:45'),
(209, 1, 293, 'GIRLSETHNI12', 974, 'bulk-temp/6a438b666f991.png', '1.png', 'visual_variant', 1, 0, 'committed', NULL, '2026-06-30 09:24:54', '2026-06-30 09:26:45'),
(210, 1, 293, 'GIRLSETHNI12', 974, 'bulk-temp/6a438b6671284.png', 'Pasted image (107).png', 'visual_variant', 0, 1, 'committed', NULL, '2026-06-30 09:24:54', '2026-06-30 09:26:45'),
(211, 1, 293, 'GIRLSETHNI12', 974, 'bulk-temp/6a438b6673e80.png', 'Pasted image (134).png', 'visual_variant', 0, 2, 'committed', NULL, '2026-06-30 09:24:54', '2026-06-30 09:26:45'),
(212, 1, 293, 'GIRLSETHNI12', 974, 'bulk-temp/6a438b6674f17.png', 'Pasted image (148).png', 'visual_variant', 0, 3, 'committed', NULL, '2026-06-30 09:24:54', '2026-06-30 09:26:45'),
(213, 1, 284, 'GIRLSFROCK03', 979, 'bulk-temp/6a438b66774ca.png', '(6 - 12M).png', 'visual_variant', 0, 0, 'committed', NULL, '2026-06-30 09:24:54', '2026-06-30 09:26:44'),
(214, 1, 284, 'GIRLSFROCK03', 979, 'bulk-temp/6a438b6678a3a.png', '1.png', 'visual_variant', 1, 1, 'committed', NULL, '2026-06-30 09:24:54', '2026-06-30 09:26:44'),
(215, 1, 284, 'GIRLSFROCK03', 979, 'bulk-temp/6a438b6679c70.png', 'Pasted image (144).png', 'visual_variant', 0, 2, 'committed', NULL, '2026-06-30 09:24:54', '2026-06-30 09:26:44'),
(216, 1, 284, 'GIRLSFROCK03', 979, 'bulk-temp/6a438b667ae91.png', 'Pasted image (166).png', 'visual_variant', 0, 3, 'committed', NULL, '2026-06-30 09:24:54', '2026-06-30 09:26:44'),
(217, 1, 284, 'GIRLSFROCK03', 975, 'bulk-temp/6a438b667d376.png', '1.png', 'visual_variant', 1, 0, 'committed', NULL, '2026-06-30 09:24:54', '2026-06-30 09:26:44'),
(218, 1, 284, 'GIRLSFROCK03', 975, 'bulk-temp/6a438b667e949.png', 'Pasted image (39).png', 'visual_variant', 0, 1, 'committed', NULL, '2026-06-30 09:24:54', '2026-06-30 09:26:44'),
(219, 1, 284, 'GIRLSFROCK03', 975, 'bulk-temp/6a438b6680190.png', 'Pasted image (54).png', 'visual_variant', 0, 2, 'committed', NULL, '2026-06-30 09:24:54', '2026-06-30 09:26:44'),
(220, 1, 284, 'GIRLSFROCK03', 975, 'bulk-temp/6a438b66814d4.png', 'Pasted image (91).png', 'visual_variant', 0, 3, 'committed', NULL, '2026-06-30 09:24:54', '2026-06-30 09:26:44'),
(221, 1, 284, 'GIRLSFROCK03', 980, 'bulk-temp/6a438b66836d6.png', '1.png', 'visual_variant', 1, 0, 'committed', NULL, '2026-06-30 09:24:54', '2026-06-30 09:26:44'),
(222, 1, 284, 'GIRLSFROCK03', 980, 'bulk-temp/6a438b6684d32.png', 'Pasted image (111).png', 'visual_variant', 0, 1, 'committed', NULL, '2026-06-30 09:24:54', '2026-06-30 09:26:44'),
(223, 1, 284, 'GIRLSFROCK03', 980, 'bulk-temp/6a438b668652e.png', 'Pasted image (126).png', 'visual_variant', 0, 2, 'committed', NULL, '2026-06-30 09:24:54', '2026-06-30 09:26:44'),
(224, 1, 284, 'GIRLSFROCK03', 980, 'bulk-temp/6a438b6688482.png', 'Pasted image (62).png', 'visual_variant', 0, 3, 'committed', NULL, '2026-06-30 09:24:54', '2026-06-30 09:26:44'),
(225, 1, 287, 'GIRLSLEDSH06', 979, 'bulk-temp/6a438b668b421.png', '1.png', 'visual_variant', 1, 0, 'committed', NULL, '2026-06-30 09:24:54', '2026-06-30 09:26:44'),
(226, 1, 287, 'GIRLSLEDSH06', 979, 'bulk-temp/6a438b668cf4f.png', 'Pasted image (120).png', 'visual_variant', 0, 1, 'committed', NULL, '2026-06-30 09:24:54', '2026-06-30 09:26:44'),
(227, 1, 287, 'GIRLSLEDSH06', 979, 'bulk-temp/6a438b668e6ee.png', 'Pasted image (121).png', 'visual_variant', 0, 2, 'committed', NULL, '2026-06-30 09:24:54', '2026-06-30 09:26:44'),
(228, 1, 287, 'GIRLSLEDSH06', 979, 'bulk-temp/6a438b668fb26.png', 'RED-XL-back.png', 'visual_variant', 0, 3, 'committed', NULL, '2026-06-30 09:24:54', '2026-06-30 09:26:44'),
(229, 1, 287, 'GIRLSLEDSH06', 975, 'bulk-temp/6a438b669249d.png', '1.png', 'visual_variant', 1, 0, 'committed', NULL, '2026-06-30 09:24:54', '2026-06-30 09:26:44'),
(230, 1, 287, 'GIRLSLEDSH06', 975, 'bulk-temp/6a438b6693f6e.png', 'Pasted image (139).png', 'visual_variant', 0, 1, 'committed', NULL, '2026-06-30 09:24:54', '2026-06-30 09:26:44'),
(231, 1, 287, 'GIRLSLEDSH06', 975, 'bulk-temp/6a438b66978a3.png', 'Pasted image (28).png', 'visual_variant', 0, 2, 'committed', NULL, '2026-06-30 09:24:54', '2026-06-30 09:26:44'),
(232, 1, 287, 'GIRLSLEDSH06', 975, 'bulk-temp/6a438b6699ed9.png', 'Pasted image (89).png', 'visual_variant', 0, 3, 'committed', NULL, '2026-06-30 09:24:54', '2026-06-30 09:26:44'),
(233, 1, 303, 'GIRLSPARTY22', 979, 'bulk-temp/6a438b669c930.png', '(0 - 6M).png', 'visual_variant', 0, 0, 'committed', NULL, '2026-06-30 09:24:54', '2026-06-30 09:26:46'),
(234, 1, 303, 'GIRLSPARTY22', 979, 'bulk-temp/6a438b669dbf9.png', '1.png', 'visual_variant', 1, 1, 'committed', NULL, '2026-06-30 09:24:54', '2026-06-30 09:26:46'),
(235, 1, 303, 'GIRLSPARTY22', 979, 'bulk-temp/6a438b669ef4b.png', 'Pasted image (112).png', 'visual_variant', 0, 2, 'committed', NULL, '2026-06-30 09:24:54', '2026-06-30 09:26:46'),
(236, 1, 303, 'GIRLSPARTY22', 979, 'bulk-temp/6a438b66a04d7.png', 'Pasted image (194).png', 'visual_variant', 0, 3, 'committed', NULL, '2026-06-30 09:24:54', '2026-06-30 09:26:46'),
(237, 1, 303, 'GIRLSPARTY22', 974, 'bulk-temp/6a438b66a2596.png', '1.png', 'visual_variant', 1, 0, 'committed', NULL, '2026-06-30 09:24:54', '2026-06-30 09:26:46'),
(238, 1, 303, 'GIRLSPARTY22', 974, 'bulk-temp/6a438b66a36c3.png', 'Pasted image (12).png', 'visual_variant', 0, 1, 'committed', NULL, '2026-06-30 09:24:54', '2026-06-30 09:26:46'),
(239, 1, 303, 'GIRLSPARTY22', 974, 'bulk-temp/6a438b66a487d.png', 'Pasted image (193).png', 'visual_variant', 0, 2, 'committed', NULL, '2026-06-30 09:24:54', '2026-06-30 09:26:46'),
(240, 1, 303, 'GIRLSPARTY22', 974, 'bulk-temp/6a438b66a5a4d.png', 'Screenshot from 2026-03-05 11-23-00.png', 'visual_variant', 0, 3, 'committed', NULL, '2026-06-30 09:24:54', '2026-06-30 09:26:46'),
(241, 1, 303, 'GIRLSPARTY22', 975, 'bulk-temp/6a438b66a8675.png', '1.png', 'visual_variant', 1, 0, 'committed', NULL, '2026-06-30 09:24:54', '2026-06-30 09:26:46'),
(242, 1, 303, 'GIRLSPARTY22', 975, 'bulk-temp/6a438b66aa303.png', 'Pasted image (109).png', 'visual_variant', 0, 1, 'committed', NULL, '2026-06-30 09:24:54', '2026-06-30 09:26:46'),
(243, 1, 303, 'GIRLSPARTY22', 975, 'bulk-temp/6a438b66ab44d.png', 'Pasted image (11).png', 'visual_variant', 0, 2, 'committed', NULL, '2026-06-30 09:24:54', '2026-06-30 09:26:46'),
(244, 1, 303, 'GIRLSPARTY22', 975, 'bulk-temp/6a438b66acc6a.png', 'Screenshot from 2026-03-05 11-23-05.png', 'visual_variant', 0, 3, 'committed', NULL, '2026-06-30 09:24:54', '2026-06-30 09:26:46'),
(245, 1, 303, 'GIRLSPARTY22', 980, 'bulk-temp/6a438b66af912.png', '1.png', 'visual_variant', 1, 0, 'committed', NULL, '2026-06-30 09:24:54', '2026-06-30 09:26:46'),
(246, 1, 303, 'GIRLSPARTY22', 980, 'bulk-temp/6a438b66b0e7d.png', 'Pasted image (26).png', 'visual_variant', 0, 1, 'committed', NULL, '2026-06-30 09:24:54', '2026-06-30 09:26:46'),
(247, 1, 303, 'GIRLSPARTY22', 980, 'bulk-temp/6a438b66b233f.png', 'Pasted image (92).png', 'visual_variant', 0, 2, 'committed', NULL, '2026-06-30 09:24:54', '2026-06-30 09:26:46'),
(248, 1, 303, 'GIRLSPARTY22', 980, 'bulk-temp/6a438b66b3544.png', 'Screenshot from 2026-03-04 15-01-27.png', 'visual_variant', 0, 3, 'committed', NULL, '2026-06-30 09:24:54', '2026-06-30 09:26:46'),
(249, 1, 290, 'GIRLSTOPSE09', 978, 'bulk-temp/6a438b66b5f4a.png', '1.png', 'visual_variant', 1, 0, 'committed', NULL, '2026-06-30 09:24:54', '2026-06-30 09:26:44'),
(250, 1, 290, 'GIRLSTOPSE09', 978, 'bulk-temp/6a438b66b717b.png', 'Pasted image (178).png', 'visual_variant', 0, 1, 'committed', NULL, '2026-06-30 09:24:54', '2026-06-30 09:26:44'),
(251, 1, 290, 'GIRLSTOPSE09', 978, 'bulk-temp/6a438b66b80a9.png', 'Pasted image (189).png', 'visual_variant', 0, 2, 'committed', NULL, '2026-06-30 09:24:54', '2026-06-30 09:26:44'),
(252, 1, 290, 'GIRLSTOPSE09', 978, 'bulk-temp/6a438b66b94fe.png', 'Pasted image (77).png', 'visual_variant', 0, 3, 'committed', NULL, '2026-06-30 09:24:54', '2026-06-30 09:26:45'),
(253, 1, 290, 'GIRLSTOPSE09', 979, 'bulk-temp/6a438b66bbb8c.png', '1.png', 'visual_variant', 1, 0, 'committed', NULL, '2026-06-30 09:24:54', '2026-06-30 09:26:44'),
(254, 1, 290, 'GIRLSTOPSE09', 979, 'bulk-temp/6a438b66bd43a.png', 'Pasted image (145).png', 'visual_variant', 0, 1, 'committed', NULL, '2026-06-30 09:24:54', '2026-06-30 09:26:44'),
(255, 1, 290, 'GIRLSTOPSE09', 979, 'bulk-temp/6a438b66bea7e.png', 'Pasted image (78).png', 'visual_variant', 0, 2, 'committed', NULL, '2026-06-30 09:24:54', '2026-06-30 09:26:44'),
(256, 1, 290, 'GIRLSTOPSE09', 979, 'bulk-temp/6a438b66c0bc9.png', 'WHITE-XXL-top.png', 'visual_variant', 0, 3, 'committed', NULL, '2026-06-30 09:24:54', '2026-06-30 09:26:44'),
(257, 1, 290, 'GIRLSTOPSE09', 980, 'bulk-temp/6a438b66c3a78.png', '1.png', 'visual_variant', 1, 0, 'committed', NULL, '2026-06-30 09:24:54', '2026-06-30 09:26:44'),
(258, 1, 290, 'GIRLSTOPSE09', 980, 'bulk-temp/6a438b66c4ed3.png', 'Pasted image (161).png', 'visual_variant', 0, 1, 'committed', NULL, '2026-06-30 09:24:54', '2026-06-30 09:26:44'),
(259, 1, 290, 'GIRLSTOPSE09', 980, 'bulk-temp/6a438b66c634c.png', 'Pasted image (93).png', 'visual_variant', 0, 2, 'committed', NULL, '2026-06-30 09:24:54', '2026-06-30 09:26:44'),
(260, 1, 290, 'GIRLSTOPSE09', 980, 'bulk-temp/6a438b66c780a.png', 'Pasted image (98).png', 'visual_variant', 0, 3, 'committed', NULL, '2026-06-30 09:24:54', '2026-06-30 09:26:44'),
(261, 1, 294, 'KIDSCASUAL13', 978, 'bulk-temp/6a438b66ca511.png', '1.png', 'visual_variant', 1, 0, 'committed', NULL, '2026-06-30 09:24:54', '2026-06-30 09:26:45'),
(262, 1, 294, 'KIDSCASUAL13', 978, 'bulk-temp/6a438b66cb941.png', 'Pasted image (106).png', 'visual_variant', 0, 1, 'committed', NULL, '2026-06-30 09:24:54', '2026-06-30 09:26:45'),
(263, 1, 294, 'KIDSCASUAL13', 978, 'bulk-temp/6a438b66cccb0.png', 'Pasted image (181).png', 'visual_variant', 0, 2, 'committed', NULL, '2026-06-30 09:24:54', '2026-06-30 09:26:45'),
(264, 1, 294, 'KIDSCASUAL13', 978, 'bulk-temp/6a438b66cdf8c.png', 'Pasted image (196).png', 'visual_variant', 0, 3, 'committed', NULL, '2026-06-30 09:24:54', '2026-06-30 09:26:45'),
(265, 1, 294, 'KIDSCASUAL13', 981, 'bulk-temp/6a438b66d0376.png', '1.png', 'visual_variant', 1, 0, 'committed', NULL, '2026-06-30 09:24:54', '2026-06-30 09:26:45'),
(266, 1, 294, 'KIDSCASUAL13', 981, 'bulk-temp/6a438b66d1946.png', 'GREEN-XL-top.png', 'visual_variant', 0, 1, 'committed', NULL, '2026-06-30 09:24:54', '2026-06-30 09:26:45'),
(267, 1, 294, 'KIDSCASUAL13', 981, 'bulk-temp/6a438b66d2baf.png', 'Pasted image (135).png', 'visual_variant', 0, 2, 'committed', NULL, '2026-06-30 09:24:54', '2026-06-30 09:26:45'),
(268, 1, 294, 'KIDSCASUAL13', 981, 'bulk-temp/6a438b66d3f10.png', 'Pasted image (24).png', 'visual_variant', 0, 3, 'committed', NULL, '2026-06-30 09:24:54', '2026-06-30 09:26:45'),
(269, 1, 294, 'KIDSCASUAL13', 980, 'bulk-temp/6a438b66d6206.png', '(0 - 6M).png', 'visual_variant', 0, 0, 'committed', NULL, '2026-06-30 09:24:54', '2026-06-30 09:26:45'),
(270, 1, 294, 'KIDSCASUAL13', 980, 'bulk-temp/6a438b66d742d.png', '1.png', 'visual_variant', 1, 1, 'committed', NULL, '2026-06-30 09:24:54', '2026-06-30 09:26:45'),
(271, 1, 294, 'KIDSCASUAL13', 980, 'bulk-temp/6a438b66d8738.png', 'Pasted image (133).png', 'visual_variant', 0, 2, 'committed', NULL, '2026-06-30 09:24:54', '2026-06-30 09:26:45'),
(272, 1, 294, 'KIDSCASUAL13', 980, 'bulk-temp/6a438b66d9cc6.png', 'Screenshot from 2026-03-04 15-01-27.png', 'visual_variant', 0, 3, 'committed', NULL, '2026-06-30 09:24:54', '2026-06-30 09:26:45'),
(273, 1, 289, 'KIDSFORMAL08', 976, 'bulk-temp/6a438b66dc24e.png', '1.png', 'visual_variant', 1, 0, 'committed', NULL, '2026-06-30 09:24:54', '2026-06-30 09:26:44'),
(274, 1, 289, 'KIDSFORMAL08', 976, 'bulk-temp/6a438b66dd5fa.png', 'Pasted image (82).png', 'visual_variant', 0, 1, 'committed', NULL, '2026-06-30 09:24:54', '2026-06-30 09:26:44'),
(275, 1, 289, 'KIDSFORMAL08', 976, 'bulk-temp/6a438b66de824.png', 'Pasted image (98).png', 'visual_variant', 0, 2, 'committed', NULL, '2026-06-30 09:24:54', '2026-06-30 09:26:44'),
(276, 1, 289, 'KIDSFORMAL08', 976, 'bulk-temp/6a438b66e078f.png', 'Screenshot from 2026-03-05 11-22-31.png', 'visual_variant', 0, 3, 'committed', NULL, '2026-06-30 09:24:54', '2026-06-30 09:26:44'),
(277, 1, 289, 'KIDSFORMAL08', 975, 'bulk-temp/6a438b66e2746.png', '1.png', 'visual_variant', 1, 0, 'committed', NULL, '2026-06-30 09:24:54', '2026-06-30 09:26:44'),
(278, 1, 289, 'KIDSFORMAL08', 975, 'bulk-temp/6a438b66e3974.png', 'Pasted image (120).png', 'visual_variant', 0, 1, 'committed', NULL, '2026-06-30 09:24:54', '2026-06-30 09:26:44'),
(279, 1, 289, 'KIDSFORMAL08', 975, 'bulk-temp/6a438b66e4d62.png', 'Pasted image (134).png', 'visual_variant', 0, 2, 'committed', NULL, '2026-06-30 09:24:54', '2026-06-30 09:26:44'),
(280, 1, 289, 'KIDSFORMAL08', 975, 'bulk-temp/6a438b66e64a3.png', 'Pasted image (19).png', 'visual_variant', 0, 3, 'committed', NULL, '2026-06-30 09:24:54', '2026-06-30 09:26:44'),
(281, 1, 302, 'KIDSFORMAL21', 977, 'bulk-temp/6a438b66eaae7.png', '1.png', 'visual_variant', 1, 0, 'committed', NULL, '2026-06-30 09:24:54', '2026-06-30 09:26:46'),
(282, 1, 302, 'KIDSFORMAL21', 977, 'bulk-temp/6a438b66ebef3.png', 'Pasted image (10).png', 'visual_variant', 0, 1, 'committed', NULL, '2026-06-30 09:24:54', '2026-06-30 09:26:46'),
(283, 1, 302, 'KIDSFORMAL21', 977, 'bulk-temp/6a438b66ed295.png', 'Pasted image (194).png', 'visual_variant', 0, 2, 'committed', NULL, '2026-06-30 09:24:54', '2026-06-30 09:26:46'),
(284, 1, 302, 'KIDSFORMAL21', 977, 'bulk-temp/6a438b66ee5d8.png', 'Pasted image (98).png', 'visual_variant', 0, 3, 'committed', NULL, '2026-06-30 09:24:54', '2026-06-30 09:26:46'),
(285, 1, 302, 'KIDSFORMAL21', 975, 'bulk-temp/6a438b66f044e.png', '1.png', 'visual_variant', 1, 0, 'committed', NULL, '2026-06-30 09:24:54', '2026-06-30 09:26:46'),
(286, 1, 302, 'KIDSFORMAL21', 975, 'bulk-temp/6a438b66f192c.png', 'Pasted image (21).png', 'visual_variant', 0, 1, 'committed', NULL, '2026-06-30 09:24:54', '2026-06-30 09:26:46'),
(287, 1, 302, 'KIDSFORMAL21', 975, 'bulk-temp/6a438b66f2b5c.png', 'Pasted image (74).png', 'visual_variant', 0, 2, 'committed', NULL, '2026-06-30 09:24:54', '2026-06-30 09:26:46');
INSERT INTO `ingestion_product_images` (`id`, `batch_id`, `product_id`, `product_code`, `attribute_value_id`, `image_path`, `original_filename`, `image_type`, `is_primary`, `sort_order`, `status`, `error_message`, `created_at`, `updated_at`) VALUES
(288, 1, 302, 'KIDSFORMAL21', 975, 'bulk-temp/6a438b66f3f53.png', 'Screenshot from 2026-03-05 11-23-05.png', 'visual_variant', 0, 3, 'committed', NULL, '2026-06-30 09:24:55', '2026-06-30 09:26:46'),
(289, 1, 306, 'KIDSRAINCO25', 976, 'bulk-temp/6a438b6702bea.png', '1.png', 'visual_variant', 1, 0, 'committed', NULL, '2026-06-30 09:24:55', '2026-06-30 09:26:46'),
(290, 1, 306, 'KIDSRAINCO25', 976, 'bulk-temp/6a438b67041a8.png', 'Pasted image (122).png', 'visual_variant', 0, 1, 'committed', NULL, '2026-06-30 09:24:55', '2026-06-30 09:26:46'),
(291, 1, 306, 'KIDSRAINCO25', 976, 'bulk-temp/6a438b67056fd.png', 'Pasted image (30).png', 'visual_variant', 0, 2, 'committed', NULL, '2026-06-30 09:24:55', '2026-06-30 09:26:46'),
(292, 1, 306, 'KIDSRAINCO25', 976, 'bulk-temp/6a438b6706eab.png', 'WHITE-XXL-top.png', 'visual_variant', 0, 3, 'committed', NULL, '2026-06-30 09:24:55', '2026-06-30 09:26:46'),
(293, 1, 306, 'KIDSRAINCO25', 974, 'bulk-temp/6a438b67096af.png', '1.png', 'visual_variant', 1, 0, 'committed', NULL, '2026-06-30 09:24:55', '2026-06-30 09:26:46'),
(294, 1, 306, 'KIDSRAINCO25', 974, 'bulk-temp/6a438b670ae17.png', 'Pasted image (132).png', 'visual_variant', 0, 1, 'committed', NULL, '2026-06-30 09:24:55', '2026-06-30 09:26:46'),
(295, 1, 306, 'KIDSRAINCO25', 974, 'bulk-temp/6a438b670c617.png', 'Pasted image (31).png', 'visual_variant', 0, 2, 'committed', NULL, '2026-06-30 09:24:55', '2026-06-30 09:26:46'),
(296, 1, 306, 'KIDSRAINCO25', 974, 'bulk-temp/6a438b670e14d.png', 'Pasted image (63).png', 'visual_variant', 0, 3, 'committed', NULL, '2026-06-30 09:24:55', '2026-06-30 09:26:47'),
(297, 1, 306, 'KIDSRAINCO25', 980, 'bulk-temp/6a438b6710c93.png', '1.png', 'visual_variant', 1, 0, 'committed', NULL, '2026-06-30 09:24:55', '2026-06-30 09:26:46'),
(298, 1, 306, 'KIDSRAINCO25', 980, 'bulk-temp/6a438b671238e.png', 'Pasted image (104).png', 'visual_variant', 0, 1, 'committed', NULL, '2026-06-30 09:24:55', '2026-06-30 09:26:46'),
(299, 1, 306, 'KIDSRAINCO25', 980, 'bulk-temp/6a438b67138f8.png', 'Pasted image (163).png', 'visual_variant', 0, 2, 'committed', NULL, '2026-06-30 09:24:55', '2026-06-30 09:26:46'),
(300, 1, 306, 'KIDSRAINCO25', 980, 'bulk-temp/6a438b6714b91.png', 'Pasted image (65).png', 'visual_variant', 0, 3, 'committed', NULL, '2026-06-30 09:24:55', '2026-06-30 09:26:47'),
(301, 1, 286, 'KIDSSNEAKE05', 977, 'bulk-temp/6a438b67179b3.png', '1.png', 'visual_variant', 1, 0, 'committed', NULL, '2026-06-30 09:24:55', '2026-06-30 09:26:44'),
(302, 1, 286, 'KIDSSNEAKE05', 977, 'bulk-temp/6a438b6718c16.png', 'Pasted image (48).png', 'visual_variant', 0, 1, 'committed', NULL, '2026-06-30 09:24:55', '2026-06-30 09:26:44'),
(303, 1, 286, 'KIDSSNEAKE05', 977, 'bulk-temp/6a438b671a2b6.png', 'Pasted image (57).png', 'visual_variant', 0, 2, 'committed', NULL, '2026-06-30 09:24:55', '2026-06-30 09:26:44'),
(304, 1, 286, 'KIDSSNEAKE05', 977, 'bulk-temp/6a438b671b6a9.png', 'Pasted image (62).png', 'visual_variant', 0, 3, 'committed', NULL, '2026-06-30 09:24:55', '2026-06-30 09:26:44'),
(305, 1, 286, 'KIDSSNEAKE05', 976, 'bulk-temp/6a438b671d9fc.png', '1.png', 'visual_variant', 1, 0, 'committed', NULL, '2026-06-30 09:24:55', '2026-06-30 09:26:44'),
(306, 1, 286, 'KIDSSNEAKE05', 976, 'bulk-temp/6a438b671ece6.png', 'Pasted image (109).png', 'visual_variant', 0, 1, 'committed', NULL, '2026-06-30 09:24:55', '2026-06-30 09:26:44'),
(307, 1, 286, 'KIDSSNEAKE05', 976, 'bulk-temp/6a438b67201b9.png', 'Pasted image (17).png', 'visual_variant', 0, 2, 'committed', NULL, '2026-06-30 09:24:55', '2026-06-30 09:26:44'),
(308, 1, 286, 'KIDSSNEAKE05', 976, 'bulk-temp/6a438b6721c30.png', 'Pasted image (48).png', 'visual_variant', 0, 3, 'committed', NULL, '2026-06-30 09:24:55', '2026-06-30 09:26:44'),
(309, 1, 286, 'KIDSSNEAKE05', 975, 'bulk-temp/6a438b6724453.png', '1.png', 'visual_variant', 1, 0, 'committed', NULL, '2026-06-30 09:24:55', '2026-06-30 09:26:44'),
(310, 1, 286, 'KIDSSNEAKE05', 975, 'bulk-temp/6a438b6725a92.png', 'GREEN-XL-side.png', 'visual_variant', 0, 1, 'committed', NULL, '2026-06-30 09:24:55', '2026-06-30 09:26:44'),
(311, 1, 286, 'KIDSSNEAKE05', 975, 'bulk-temp/6a438b6727365.png', 'Pasted image (110).png', 'visual_variant', 0, 2, 'committed', NULL, '2026-06-30 09:24:55', '2026-06-30 09:26:44'),
(312, 1, 286, 'KIDSSNEAKE05', 975, 'bulk-temp/6a438b6728ffe.png', 'Pasted image (61).png', 'visual_variant', 0, 3, 'committed', NULL, '2026-06-30 09:24:55', '2026-06-30 09:26:44'),
(313, 1, 283, 'KIDST-SHIR02', 977, 'bulk-temp/6a438b672cf08.png', '1.png', 'visual_variant', 1, 0, 'committed', NULL, '2026-06-30 09:24:55', '2026-06-30 09:26:43'),
(314, 1, 283, 'KIDST-SHIR02', 977, 'bulk-temp/6a438b672ea7b.png', 'GREY-M.png', 'visual_variant', 0, 1, 'committed', NULL, '2026-06-30 09:24:55', '2026-06-30 09:26:43'),
(315, 1, 283, 'KIDST-SHIR02', 977, 'bulk-temp/6a438b6730ae7.png', 'Pasted image (56).png', 'visual_variant', 0, 2, 'committed', NULL, '2026-06-30 09:24:55', '2026-06-30 09:26:44'),
(316, 1, 283, 'KIDST-SHIR02', 977, 'bulk-temp/6a438b6732061.png', 'Pasted image (73).png', 'visual_variant', 0, 3, 'committed', NULL, '2026-06-30 09:24:55', '2026-06-30 09:26:44'),
(317, 1, 283, 'KIDST-SHIR02', 976, 'bulk-temp/6a438b67345fc.png', '1.png', 'visual_variant', 1, 0, 'committed', NULL, '2026-06-30 09:24:55', '2026-06-30 09:26:43'),
(318, 1, 283, 'KIDST-SHIR02', 976, 'bulk-temp/6a438b6735be9.png', 'Pasted image (114).png', 'visual_variant', 0, 1, 'committed', NULL, '2026-06-30 09:24:55', '2026-06-30 09:26:43'),
(319, 1, 283, 'KIDST-SHIR02', 976, 'bulk-temp/6a438b6737405.png', 'Pasted image (157).png', 'visual_variant', 0, 2, 'committed', NULL, '2026-06-30 09:24:55', '2026-06-30 09:26:44'),
(320, 1, 283, 'KIDST-SHIR02', 976, 'bulk-temp/6a438b6738e7a.png', 'Pasted image (65).png', 'visual_variant', 0, 3, 'committed', NULL, '2026-06-30 09:24:55', '2026-06-30 09:26:44'),
(321, 1, 283, 'KIDST-SHIR02', 974, 'bulk-temp/6a438b673b1d5.png', '1.png', 'visual_variant', 1, 0, 'committed', NULL, '2026-06-30 09:24:55', '2026-06-30 09:26:43'),
(322, 1, 283, 'KIDST-SHIR02', 974, 'bulk-temp/6a438b673ca2a.png', 'Pasted image (154).png', 'visual_variant', 0, 1, 'committed', NULL, '2026-06-30 09:24:55', '2026-06-30 09:26:43'),
(323, 1, 283, 'KIDST-SHIR02', 974, 'bulk-temp/6a438b673e032.png', 'RED-XL-top.png', 'visual_variant', 0, 2, 'committed', NULL, '2026-06-30 09:24:55', '2026-06-30 09:26:44'),
(324, 1, 283, 'KIDST-SHIR02', 974, 'bulk-temp/6a438b673f9c4.png', 'Screenshot from 2026-03-04 15-02-09.png', 'visual_variant', 0, 3, 'committed', NULL, '2026-06-30 09:24:55', '2026-06-30 09:26:44'),
(325, 1, 251, 'MATWEAR01', NULL, 'bulk-temp/6a438b674311c.png', '1.png', 'simple', 1, 0, 'committed', NULL, '2026-06-30 09:24:55', '2026-06-30 09:26:41'),
(326, 1, 251, 'MATWEAR01', NULL, 'bulk-temp/6a438b67450ee.png', 'Pasted image (107).png', 'simple', 0, 1, 'committed', NULL, '2026-06-30 09:24:55', '2026-06-30 09:26:41'),
(327, 1, 251, 'MATWEAR01', NULL, 'bulk-temp/6a438b67481e6.png', 'Pasted image (184).png', 'simple', 0, 2, 'committed', NULL, '2026-06-30 09:24:55', '2026-06-30 09:26:41'),
(328, 1, 251, 'MATWEAR01', NULL, 'bulk-temp/6a438b674c197.png', 'Pasted image (23).png', 'simple', 0, 3, 'committed', NULL, '2026-06-30 09:24:55', '2026-06-30 09:26:42'),
(329, 1, 252, 'MATWEAR02', NULL, 'bulk-temp/6a438b674f0e3.png', '1.png', 'simple', 1, 0, 'committed', NULL, '2026-06-30 09:24:55', '2026-06-30 09:26:42'),
(330, 1, 252, 'MATWEAR02', NULL, 'bulk-temp/6a438b6751400.png', 'Pasted image (174).png', 'simple', 0, 1, 'committed', NULL, '2026-06-30 09:24:55', '2026-06-30 09:26:42'),
(331, 1, 252, 'MATWEAR02', NULL, 'bulk-temp/6a438b675332c.png', 'Pasted image (94).png', 'simple', 0, 2, 'committed', NULL, '2026-06-30 09:24:55', '2026-06-30 09:26:42'),
(332, 1, 252, 'MATWEAR02', NULL, 'bulk-temp/6a438b6755554.png', 'RED-XL-back.png', 'simple', 0, 3, 'committed', NULL, '2026-06-30 09:24:55', '2026-06-30 09:26:42'),
(333, 1, 253, 'MATWEAR03', NULL, 'bulk-temp/6a438b6759eb5.png', '1.png', 'simple', 1, 0, 'committed', NULL, '2026-06-30 09:24:55', '2026-06-30 09:26:42'),
(334, 1, 253, 'MATWEAR03', NULL, 'bulk-temp/6a438b675c2eb.png', 'Pasted image (164).png', 'simple', 0, 1, 'committed', NULL, '2026-06-30 09:24:55', '2026-06-30 09:26:42'),
(335, 1, 253, 'MATWEAR03', NULL, 'bulk-temp/6a438b675e8a8.png', 'Pasted image (37).png', 'simple', 0, 2, 'committed', NULL, '2026-06-30 09:24:55', '2026-06-30 09:26:42'),
(336, 1, 253, 'MATWEAR03', NULL, 'bulk-temp/6a438b6760a86.png', 'Pasted image.png', 'simple', 0, 3, 'committed', NULL, '2026-06-30 09:24:55', '2026-06-30 09:26:42'),
(337, 1, 254, 'MATWEAR04', NULL, 'bulk-temp/6a438b67641b1.png', '1.png', 'simple', 1, 0, 'committed', NULL, '2026-06-30 09:24:55', '2026-06-30 09:26:42'),
(338, 1, 254, 'MATWEAR04', NULL, 'bulk-temp/6a438b676619e.png', 'Pasted image (113).png', 'simple', 0, 1, 'committed', NULL, '2026-06-30 09:24:55', '2026-06-30 09:26:42'),
(339, 1, 254, 'MATWEAR04', NULL, 'bulk-temp/6a438b676885a.png', 'Pasted image (14).png', 'simple', 0, 2, 'committed', NULL, '2026-06-30 09:24:55', '2026-06-30 09:26:42'),
(340, 1, 254, 'MATWEAR04', NULL, 'bulk-temp/6a438b676b047.png', 'WHITE-XXL-front.png', 'simple', 0, 3, 'committed', NULL, '2026-06-30 09:24:55', '2026-06-30 09:26:42'),
(341, 1, 255, 'MATWEAR05', NULL, 'bulk-temp/6a438b676ee70.png', '1.png', 'simple', 1, 0, 'committed', NULL, '2026-06-30 09:24:55', '2026-06-30 09:26:42'),
(342, 1, 255, 'MATWEAR05', NULL, 'bulk-temp/6a438b6770efd.png', 'Pasted image (125).png', 'simple', 0, 1, 'committed', NULL, '2026-06-30 09:24:55', '2026-06-30 09:26:42'),
(343, 1, 255, 'MATWEAR05', NULL, 'bulk-temp/6a438b6772ff9.png', 'Pasted image (179).png', 'simple', 0, 2, 'committed', NULL, '2026-06-30 09:24:55', '2026-06-30 09:26:42'),
(344, 1, 255, 'MATWEAR05', NULL, 'bulk-temp/6a438b67753fe.png', 'RED-XL-back.png', 'simple', 0, 3, 'committed', NULL, '2026-06-30 09:24:55', '2026-06-30 09:26:42'),
(345, 1, 256, 'MATWEAR06', NULL, 'bulk-temp/6a438b6778e12.png', '1.png', 'simple', 1, 0, 'committed', NULL, '2026-06-30 09:24:55', '2026-06-30 09:26:42'),
(346, 1, 256, 'MATWEAR06', NULL, 'bulk-temp/6a438b677b097.png', 'Pasted image (150).png', 'simple', 0, 1, 'committed', NULL, '2026-06-30 09:24:55', '2026-06-30 09:26:42'),
(347, 1, 256, 'MATWEAR06', NULL, 'bulk-temp/6a438b677d0b9.png', 'Pasted image (169).png', 'simple', 0, 2, 'committed', NULL, '2026-06-30 09:24:55', '2026-06-30 09:26:42'),
(348, 1, 256, 'MATWEAR06', NULL, 'bulk-temp/6a438b677f78c.png', 'Pasted image (32).png', 'simple', 0, 3, 'committed', NULL, '2026-06-30 09:24:55', '2026-06-30 09:26:42'),
(349, 1, 257, 'MATWEAR07', NULL, 'bulk-temp/6a438b6782ec3.png', '1.png', 'simple', 1, 0, 'committed', NULL, '2026-06-30 09:24:55', '2026-06-30 09:26:42'),
(350, 1, 257, 'MATWEAR07', NULL, 'bulk-temp/6a438b6784f4b.png', 'Pasted image (100).png', 'simple', 0, 1, 'committed', NULL, '2026-06-30 09:24:55', '2026-06-30 09:26:42'),
(351, 1, 257, 'MATWEAR07', NULL, 'bulk-temp/6a438b678758e.png', 'Pasted image (122).png', 'simple', 0, 2, 'committed', NULL, '2026-06-30 09:24:55', '2026-06-30 09:26:42'),
(352, 1, 257, 'MATWEAR07', NULL, 'bulk-temp/6a438b6789c5d.png', 'Pasted image (8).png', 'simple', 0, 3, 'committed', NULL, '2026-06-30 09:24:55', '2026-06-30 09:26:42'),
(353, 1, 258, 'MATWEAR08', NULL, 'bulk-temp/6a438b678ce14.png', '1.png', 'simple', 1, 0, 'committed', NULL, '2026-06-30 09:24:55', '2026-06-30 09:26:42'),
(354, 1, 258, 'MATWEAR08', NULL, 'bulk-temp/6a438b678eb91.png', 'Pasted image (144).png', 'simple', 0, 1, 'committed', NULL, '2026-06-30 09:24:55', '2026-06-30 09:26:42'),
(355, 1, 258, 'MATWEAR08', NULL, 'bulk-temp/6a438b67907d1.png', 'Pasted image (3).png', 'simple', 0, 2, 'committed', NULL, '2026-06-30 09:24:55', '2026-06-30 09:26:42'),
(356, 1, 258, 'MATWEAR08', NULL, 'bulk-temp/6a438b6792467.png', 'Screenshot from 2026-03-05 11-22-37.png', 'simple', 0, 3, 'committed', NULL, '2026-06-30 09:24:55', '2026-06-30 09:26:42'),
(357, 1, 259, 'MATWEAR09', NULL, 'bulk-temp/6a438b6799b24.png', '1.png', 'simple', 1, 0, 'committed', NULL, '2026-06-30 09:24:55', '2026-06-30 09:26:42'),
(358, 1, 259, 'MATWEAR09', NULL, 'bulk-temp/6a438b679b5b6.png', 'Pasted image (151).png', 'simple', 0, 1, 'committed', NULL, '2026-06-30 09:24:55', '2026-06-30 09:26:42'),
(359, 1, 259, 'MATWEAR09', NULL, 'bulk-temp/6a438b679d209.png', 'Pasted image (54).png', 'simple', 0, 2, 'committed', NULL, '2026-06-30 09:24:55', '2026-06-30 09:26:42'),
(360, 1, 259, 'MATWEAR09', NULL, 'bulk-temp/6a438b679eee4.png', 'Pasted image (97).png', 'simple', 0, 3, 'committed', NULL, '2026-06-30 09:24:55', '2026-06-30 09:26:42'),
(361, 1, 260, 'MATWEAR10', NULL, 'bulk-temp/6a438b67a1df9.png', '1.png', 'simple', 1, 0, 'committed', NULL, '2026-06-30 09:24:55', '2026-06-30 09:26:42'),
(362, 1, 260, 'MATWEAR10', NULL, 'bulk-temp/6a438b67a34ff.png', 'Pasted image (111).png', 'simple', 0, 1, 'committed', NULL, '2026-06-30 09:24:55', '2026-06-30 09:26:42'),
(363, 1, 260, 'MATWEAR10', NULL, 'bulk-temp/6a438b67a4ea1.png', 'Pasted image (182).png', 'simple', 0, 2, 'committed', NULL, '2026-06-30 09:24:55', '2026-06-30 09:26:42'),
(364, 1, 260, 'MATWEAR10', NULL, 'bulk-temp/6a438b67a6845.png', 'Pasted image (184).png', 'simple', 0, 3, 'committed', NULL, '2026-06-30 09:24:55', '2026-06-30 09:26:42'),
(365, 1, 261, 'NURSEBRA01', NULL, 'bulk-temp/6a438b67a94ee.png', '1.png', 'simple', 1, 0, 'committed', NULL, '2026-06-30 09:24:55', '2026-06-30 09:26:42'),
(366, 1, 261, 'NURSEBRA01', NULL, 'bulk-temp/6a438b67ab0d9.png', 'Pasted image (133).png', 'simple', 0, 1, 'committed', NULL, '2026-06-30 09:24:55', '2026-06-30 09:26:42'),
(367, 1, 261, 'NURSEBRA01', NULL, 'bulk-temp/6a438b67acfe2.png', 'Pasted image (55).png', 'simple', 0, 2, 'committed', NULL, '2026-06-30 09:24:55', '2026-06-30 09:26:42'),
(368, 1, 261, 'NURSEBRA01', NULL, 'bulk-temp/6a438b67ae930.png', 'Pasted image (56).png', 'simple', 0, 3, 'committed', NULL, '2026-06-30 09:24:55', '2026-06-30 09:26:42'),
(369, 1, 262, 'NURSEBRA02', NULL, 'bulk-temp/6a438b67b1578.png', '1.png', 'simple', 1, 0, 'committed', NULL, '2026-06-30 09:24:55', '2026-06-30 09:26:42'),
(370, 1, 262, 'NURSEBRA02', NULL, 'bulk-temp/6a438b67b2f23.png', 'Pasted image (150).png', 'simple', 0, 1, 'committed', NULL, '2026-06-30 09:24:55', '2026-06-30 09:26:42'),
(371, 1, 262, 'NURSEBRA02', NULL, 'bulk-temp/6a438b67b48fc.png', 'Pasted image (175).png', 'simple', 0, 2, 'committed', NULL, '2026-06-30 09:24:55', '2026-06-30 09:26:42'),
(372, 1, 262, 'NURSEBRA02', NULL, 'bulk-temp/6a438b67b6209.png', 'Pasted image (185).png', 'simple', 0, 3, 'committed', NULL, '2026-06-30 09:24:55', '2026-06-30 09:26:42'),
(373, 1, 263, 'NURSEBRA03', NULL, 'bulk-temp/6a438b67b86cb.png', '1.png', 'simple', 1, 0, 'committed', NULL, '2026-06-30 09:24:55', '2026-06-30 09:26:42'),
(374, 1, 263, 'NURSEBRA03', NULL, 'bulk-temp/6a438b67ba1ac.png', 'Pasted image (13).png', 'simple', 0, 1, 'committed', NULL, '2026-06-30 09:24:55', '2026-06-30 09:26:42'),
(375, 1, 263, 'NURSEBRA03', NULL, 'bulk-temp/6a438b67bb94e.png', 'Pasted image (177).png', 'simple', 0, 2, 'committed', NULL, '2026-06-30 09:24:55', '2026-06-30 09:26:42'),
(376, 1, 263, 'NURSEBRA03', NULL, 'bulk-temp/6a438b67bd4e8.png', 'Pasted image (73).png', 'simple', 0, 3, 'committed', NULL, '2026-06-30 09:24:55', '2026-06-30 09:26:42'),
(377, 1, 264, 'NURSEBRA04', NULL, 'bulk-temp/6a438b67c12e7.png', '1.png', 'simple', 1, 0, 'committed', NULL, '2026-06-30 09:24:55', '2026-06-30 09:26:42'),
(378, 1, 264, 'NURSEBRA04', NULL, 'bulk-temp/6a438b67c295c.png', 'Pasted image (171).png', 'simple', 0, 1, 'committed', NULL, '2026-06-30 09:24:55', '2026-06-30 09:26:42'),
(379, 1, 264, 'NURSEBRA04', NULL, 'bulk-temp/6a438b67c4895.png', 'Pasted image (4).png', 'simple', 0, 2, 'committed', NULL, '2026-06-30 09:24:55', '2026-06-30 09:26:42'),
(380, 1, 264, 'NURSEBRA04', NULL, 'bulk-temp/6a438b67c640e.png', 'Pasted image (65).png', 'simple', 0, 3, 'committed', NULL, '2026-06-30 09:24:55', '2026-06-30 09:26:42'),
(381, 1, 265, 'NURSEBRA05', NULL, 'bulk-temp/6a438b67c8c11.png', '1.png', 'simple', 1, 0, 'committed', NULL, '2026-06-30 09:24:55', '2026-06-30 09:26:42'),
(382, 1, 265, 'NURSEBRA05', NULL, 'bulk-temp/6a438b67ca90e.png', 'Pasted image (139).png', 'simple', 0, 1, 'committed', NULL, '2026-06-30 09:24:55', '2026-06-30 09:26:42'),
(383, 1, 265, 'NURSEBRA05', NULL, 'bulk-temp/6a438b67cd64e.png', 'Pasted image (32).png', 'simple', 0, 2, 'committed', NULL, '2026-06-30 09:24:55', '2026-06-30 09:26:42'),
(384, 1, 265, 'NURSEBRA05', NULL, 'bulk-temp/6a438b67cec98.png', 'Screenshot from 2026-03-05 11-22-41.png', 'simple', 0, 3, 'committed', NULL, '2026-06-30 09:24:55', '2026-06-30 09:26:42'),
(385, 1, 266, 'NURSEBRA06', NULL, 'bulk-temp/6a438b67d1304.png', '1.png', 'simple', 1, 0, 'committed', NULL, '2026-06-30 09:24:55', '2026-06-30 09:26:42'),
(386, 1, 266, 'NURSEBRA06', NULL, 'bulk-temp/6a438b67d2d51.png', 'Pasted image (13).png', 'simple', 0, 1, 'committed', NULL, '2026-06-30 09:24:55', '2026-06-30 09:26:42'),
(387, 1, 266, 'NURSEBRA06', NULL, 'bulk-temp/6a438b67d463a.png', 'Pasted image (15).png', 'simple', 0, 2, 'committed', NULL, '2026-06-30 09:24:55', '2026-06-30 09:26:42'),
(388, 1, 266, 'NURSEBRA06', NULL, 'bulk-temp/6a438b67d603b.png', 'Pasted image (167).png', 'simple', 0, 3, 'committed', NULL, '2026-06-30 09:24:55', '2026-06-30 09:26:42'),
(389, 1, 267, 'NURSEBRA07', NULL, 'bulk-temp/6a438b67d8bfb.png', '1.png', 'simple', 1, 0, 'committed', NULL, '2026-06-30 09:24:55', '2026-06-30 09:26:42'),
(390, 1, 267, 'NURSEBRA07', NULL, 'bulk-temp/6a438b67da869.png', 'Pasted image (61).png', 'simple', 0, 1, 'committed', NULL, '2026-06-30 09:24:55', '2026-06-30 09:26:42'),
(391, 1, 267, 'NURSEBRA07', NULL, 'bulk-temp/6a438b67dc179.png', 'Pasted image (72).png', 'simple', 0, 2, 'committed', NULL, '2026-06-30 09:24:55', '2026-06-30 09:26:42'),
(392, 1, 267, 'NURSEBRA07', NULL, 'bulk-temp/6a438b67ddb7e.png', 'Pasted image (98).png', 'simple', 0, 3, 'committed', NULL, '2026-06-30 09:24:55', '2026-06-30 09:26:42'),
(393, 1, 268, 'NURSEBRA08', NULL, 'bulk-temp/6a438b67e0c7a.png', '1.png', 'simple', 1, 0, 'committed', NULL, '2026-06-30 09:24:55', '2026-06-30 09:26:42'),
(394, 1, 268, 'NURSEBRA08', NULL, 'bulk-temp/6a438b67e212f.png', 'Pasted image (171).png', 'simple', 0, 1, 'committed', NULL, '2026-06-30 09:24:55', '2026-06-30 09:26:42'),
(395, 1, 268, 'NURSEBRA08', NULL, 'bulk-temp/6a438b67e4b13.png', 'Pasted image (39).png', 'simple', 0, 2, 'committed', NULL, '2026-06-30 09:24:55', '2026-06-30 09:26:42'),
(396, 1, 268, 'NURSEBRA08', NULL, 'bulk-temp/6a438b67e67b9.png', 'Pasted image (40).png', 'simple', 0, 3, 'committed', NULL, '2026-06-30 09:24:55', '2026-06-30 09:26:42'),
(397, 1, 269, 'PREGPILLOW01', NULL, 'bulk-temp/6a438b67e9b0f.png', '1.png', 'simple', 1, 0, 'committed', NULL, '2026-06-30 09:24:55', '2026-06-30 09:26:42'),
(398, 1, 269, 'PREGPILLOW01', NULL, 'bulk-temp/6a438b67eb10c.png', 'GREEN-XL-top.png', 'simple', 0, 1, 'committed', NULL, '2026-06-30 09:24:55', '2026-06-30 09:26:42'),
(399, 1, 269, 'PREGPILLOW01', NULL, 'bulk-temp/6a438b67ec63f.png', 'Pasted image (187).png', 'simple', 0, 2, 'committed', NULL, '2026-06-30 09:24:55', '2026-06-30 09:26:42'),
(400, 1, 269, 'PREGPILLOW01', NULL, 'bulk-temp/6a438b67edd89.png', 'Pasted image (190).png', 'simple', 0, 3, 'committed', NULL, '2026-06-30 09:24:55', '2026-06-30 09:26:43'),
(401, 1, 270, 'PREGPILLOW02', NULL, 'bulk-temp/6a438b67f05ac.png', '1.png', 'simple', 1, 0, 'committed', NULL, '2026-06-30 09:24:55', '2026-06-30 09:26:43'),
(402, 1, 270, 'PREGPILLOW02', NULL, 'bulk-temp/6a438b67f1b76.png', 'Pasted image (165).png', 'simple', 0, 1, 'committed', NULL, '2026-06-30 09:24:55', '2026-06-30 09:26:43'),
(403, 1, 270, 'PREGPILLOW02', NULL, 'bulk-temp/6a438b67f326b.png', 'Pasted image (190).png', 'simple', 0, 2, 'committed', NULL, '2026-06-30 09:24:55', '2026-06-30 09:26:43'),
(404, 1, 270, 'PREGPILLOW02', NULL, 'bulk-temp/6a438b68007f1.png', 'Pasted image (97).png', 'simple', 0, 3, 'committed', NULL, '2026-06-30 09:24:56', '2026-06-30 09:26:43'),
(405, 1, 271, 'PREGPILLOW03', NULL, 'bulk-temp/6a438b68036dd.png', '1.png', 'simple', 1, 0, 'committed', NULL, '2026-06-30 09:24:56', '2026-06-30 09:26:43'),
(406, 1, 271, 'PREGPILLOW03', NULL, 'bulk-temp/6a438b680492e.png', 'Pasted image (102).png', 'simple', 0, 1, 'committed', NULL, '2026-06-30 09:24:56', '2026-06-30 09:26:43'),
(407, 1, 271, 'PREGPILLOW03', NULL, 'bulk-temp/6a438b6805f80.png', 'Pasted image (127).png', 'simple', 0, 2, 'committed', NULL, '2026-06-30 09:24:56', '2026-06-30 09:26:43'),
(408, 1, 271, 'PREGPILLOW03', NULL, 'bulk-temp/6a438b680759a.png', 'Pasted image (25).png', 'simple', 0, 3, 'committed', NULL, '2026-06-30 09:24:56', '2026-06-30 09:26:43'),
(409, 1, 272, 'PREGPILLOW04', NULL, 'bulk-temp/6a438b68097d4.png', '1.png', 'simple', 1, 0, 'committed', NULL, '2026-06-30 09:24:56', '2026-06-30 09:26:43'),
(410, 1, 272, 'PREGPILLOW04', NULL, 'bulk-temp/6a438b680ad2b.png', 'Pasted image (128).png', 'simple', 0, 1, 'committed', NULL, '2026-06-30 09:24:56', '2026-06-30 09:26:43'),
(411, 1, 272, 'PREGPILLOW04', NULL, 'bulk-temp/6a438b680c7a4.png', 'Pasted image (167).png', 'simple', 0, 2, 'committed', NULL, '2026-06-30 09:24:56', '2026-06-30 09:26:43'),
(412, 1, 272, 'PREGPILLOW04', NULL, 'bulk-temp/6a438b680e1b0.png', 'Pasted image (169).png', 'simple', 0, 3, 'committed', NULL, '2026-06-30 09:24:56', '2026-06-30 09:26:43'),
(413, 1, 273, 'PREGPILLOW05', NULL, 'bulk-temp/6a438b6810e1d.png', '1.png', 'simple', 1, 0, 'committed', NULL, '2026-06-30 09:24:56', '2026-06-30 09:26:43'),
(414, 1, 273, 'PREGPILLOW05', NULL, 'bulk-temp/6a438b68125d9.png', 'Pasted image (71).png', 'simple', 0, 1, 'committed', NULL, '2026-06-30 09:24:56', '2026-06-30 09:26:43'),
(415, 1, 273, 'PREGPILLOW05', NULL, 'bulk-temp/6a438b6813b27.png', 'Pasted image (76).png', 'simple', 0, 2, 'committed', NULL, '2026-06-30 09:24:56', '2026-06-30 09:26:43'),
(416, 1, 273, 'PREGPILLOW05', NULL, 'bulk-temp/6a438b6814c79.png', 'RED-XL-back.png', 'simple', 0, 3, 'committed', NULL, '2026-06-30 09:24:56', '2026-06-30 09:26:43'),
(417, 1, 274, 'SKINCARE01', NULL, 'bulk-temp/6a438b68175bf.png', '1.png', 'simple', 1, 0, 'committed', NULL, '2026-06-30 09:24:56', '2026-06-30 09:26:43'),
(418, 1, 274, 'SKINCARE01', NULL, 'bulk-temp/6a438b6818898.png', 'Pasted image (125).png', 'simple', 0, 1, 'committed', NULL, '2026-06-30 09:24:56', '2026-06-30 09:26:43'),
(419, 1, 274, 'SKINCARE01', NULL, 'bulk-temp/6a438b6819d3c.png', 'Pasted image (153).png', 'simple', 0, 2, 'committed', NULL, '2026-06-30 09:24:56', '2026-06-30 09:26:43'),
(420, 1, 274, 'SKINCARE01', NULL, 'bulk-temp/6a438b681b162.png', 'Pasted image (22).png', 'simple', 0, 3, 'committed', NULL, '2026-06-30 09:24:56', '2026-06-30 09:26:43'),
(421, 1, 275, 'SKINCARE02', NULL, 'bulk-temp/6a438b681d811.png', '1.png', 'simple', 1, 0, 'committed', NULL, '2026-06-30 09:24:56', '2026-06-30 09:26:43'),
(422, 1, 275, 'SKINCARE02', NULL, 'bulk-temp/6a438b681ec46.png', 'Pasted image (142).png', 'simple', 0, 1, 'committed', NULL, '2026-06-30 09:24:56', '2026-06-30 09:26:43'),
(423, 1, 275, 'SKINCARE02', NULL, 'bulk-temp/6a438b681ffee.png', 'Pasted image (95).png', 'simple', 0, 2, 'committed', NULL, '2026-06-30 09:24:56', '2026-06-30 09:26:43'),
(424, 1, 275, 'SKINCARE02', NULL, 'bulk-temp/6a438b6821697.png', 'Pasted image (99).png', 'simple', 0, 3, 'committed', NULL, '2026-06-30 09:24:56', '2026-06-30 09:26:43'),
(425, 1, 276, 'SKINCARE03', NULL, 'bulk-temp/6a438b682480a.png', '1.png', 'simple', 1, 0, 'committed', NULL, '2026-06-30 09:24:56', '2026-06-30 09:26:43'),
(426, 1, 276, 'SKINCARE03', NULL, 'bulk-temp/6a438b68257cf.png', 'Pasted image (100).png', 'simple', 0, 1, 'committed', NULL, '2026-06-30 09:24:56', '2026-06-30 09:26:43'),
(427, 1, 276, 'SKINCARE03', NULL, 'bulk-temp/6a438b6826c0d.png', 'Pasted image (18).png', 'simple', 0, 2, 'committed', NULL, '2026-06-30 09:24:56', '2026-06-30 09:26:43'),
(428, 1, 276, 'SKINCARE03', NULL, 'bulk-temp/6a438b68280b8.png', 'Pasted image (19).png', 'simple', 0, 3, 'committed', NULL, '2026-06-30 09:24:56', '2026-06-30 09:26:43'),
(429, 1, 277, 'SKINCARE04', NULL, 'bulk-temp/6a438b682a757.png', '1.png', 'simple', 1, 0, 'committed', NULL, '2026-06-30 09:24:56', '2026-06-30 09:26:43'),
(430, 1, 277, 'SKINCARE04', NULL, 'bulk-temp/6a438b682bd78.png', 'Pasted image (138).png', 'simple', 0, 1, 'committed', NULL, '2026-06-30 09:24:56', '2026-06-30 09:26:43'),
(431, 1, 277, 'SKINCARE04', NULL, 'bulk-temp/6a438b682d2b8.png', 'Pasted image (6).png', 'simple', 0, 2, 'committed', NULL, '2026-06-30 09:24:56', '2026-06-30 09:26:43'),
(432, 1, 277, 'SKINCARE04', NULL, 'bulk-temp/6a438b682e593.png', 'Pasted image (69).png', 'simple', 0, 3, 'committed', NULL, '2026-06-30 09:24:56', '2026-06-30 09:26:43'),
(433, 1, 278, 'SKINCARE05', NULL, 'bulk-temp/6a438b6830b55.png', '1.png', 'simple', 1, 0, 'committed', NULL, '2026-06-30 09:24:56', '2026-06-30 09:26:43'),
(434, 1, 278, 'SKINCARE05', NULL, 'bulk-temp/6a438b6832235.png', 'Pasted image (115).png', 'simple', 0, 1, 'committed', NULL, '2026-06-30 09:24:56', '2026-06-30 09:26:43'),
(435, 1, 278, 'SKINCARE05', NULL, 'bulk-temp/6a438b68337aa.png', 'Pasted image (57).png', 'simple', 0, 2, 'committed', NULL, '2026-06-30 09:24:56', '2026-06-30 09:26:43'),
(436, 1, 278, 'SKINCARE05', NULL, 'bulk-temp/6a438b6834982.png', 'Screenshot from 2026-03-05 11-22-55.png', 'simple', 0, 3, 'committed', NULL, '2026-06-30 09:24:56', '2026-06-30 09:26:43'),
(437, 1, 279, 'SKINCARE06', NULL, 'bulk-temp/6a438b6837150.png', '1.png', 'simple', 1, 0, 'committed', NULL, '2026-06-30 09:24:56', '2026-06-30 09:26:43'),
(438, 1, 279, 'SKINCARE06', NULL, 'bulk-temp/6a438b6838d21.png', 'Pasted image (159).png', 'simple', 0, 1, 'committed', NULL, '2026-06-30 09:24:56', '2026-06-30 09:26:43'),
(439, 1, 279, 'SKINCARE06', NULL, 'bulk-temp/6a438b683a1cf.png', 'Pasted image (31).png', 'simple', 0, 2, 'committed', NULL, '2026-06-30 09:24:56', '2026-06-30 09:26:43'),
(440, 1, 279, 'SKINCARE06', NULL, 'bulk-temp/6a438b683b649.png', 'Pasted image (89).png', 'simple', 0, 3, 'committed', NULL, '2026-06-30 09:24:56', '2026-06-30 09:26:43'),
(441, 1, 280, 'SKINCARE07', NULL, 'bulk-temp/6a438b683d890.png', '1.png', 'simple', 1, 0, 'committed', NULL, '2026-06-30 09:24:56', '2026-06-30 09:26:43'),
(442, 1, 280, 'SKINCARE07', NULL, 'bulk-temp/6a438b683ec9d.png', 'Pasted image (110).png', 'simple', 0, 1, 'committed', NULL, '2026-06-30 09:24:56', '2026-06-30 09:26:43'),
(443, 1, 280, 'SKINCARE07', NULL, 'bulk-temp/6a438b68400c4.png', 'Pasted image (60).png', 'simple', 0, 2, 'committed', NULL, '2026-06-30 09:24:56', '2026-06-30 09:26:43'),
(444, 1, 280, 'SKINCARE07', NULL, 'bulk-temp/6a438b6841496.png', 'Pasted image (78).png', 'simple', 0, 3, 'committed', NULL, '2026-06-30 09:24:56', '2026-06-30 09:26:43'),
(445, 1, 281, 'SKINCARE08', NULL, 'bulk-temp/6a438b6843935.png', '1.png', 'simple', 1, 0, 'committed', NULL, '2026-06-30 09:24:56', '2026-06-30 09:26:43'),
(446, 1, 281, 'SKINCARE08', NULL, 'bulk-temp/6a438b6844d1e.png', 'Pasted image (122).png', 'simple', 0, 1, 'committed', NULL, '2026-06-30 09:24:56', '2026-06-30 09:26:43'),
(447, 1, 281, 'SKINCARE08', NULL, 'bulk-temp/6a438b684632a.png', 'Pasted image (139).png', 'simple', 0, 2, 'committed', NULL, '2026-06-30 09:24:56', '2026-06-30 09:26:43'),
(448, 1, 281, 'SKINCARE08', NULL, 'bulk-temp/6a438b6847639.png', 'Pasted image (32).png', 'simple', 0, 3, 'committed', NULL, '2026-06-30 09:24:56', '2026-06-30 09:26:43'),
(449, 1, 317, 'SOFTTOY01', NULL, 'bulk-temp/6a438b6849a5c.png', '1.png', 'simple', 1, 0, 'committed', NULL, '2026-06-30 09:24:56', '2026-06-30 09:26:47'),
(450, 1, 317, 'SOFTTOY01', NULL, 'bulk-temp/6a438b684b147.png', 'Pasted image (158).png', 'simple', 0, 1, 'committed', NULL, '2026-06-30 09:24:56', '2026-06-30 09:26:47'),
(451, 1, 317, 'SOFTTOY01', NULL, 'bulk-temp/6a438b684c79e.png', 'Pasted image (32).png', 'simple', 0, 2, 'committed', NULL, '2026-06-30 09:24:56', '2026-06-30 09:26:47'),
(452, 1, 317, 'SOFTTOY01', NULL, 'bulk-temp/6a438b684dada.png', 'Screenshot from 2026-03-04 15-02-42.png', 'simple', 0, 3, 'committed', NULL, '2026-06-30 09:24:56', '2026-06-30 09:26:47'),
(453, 1, 318, 'SOFTTOY02', NULL, 'bulk-temp/6a438b685000d.png', '1.png', 'simple', 1, 0, 'committed', NULL, '2026-06-30 09:24:56', '2026-06-30 09:26:47'),
(454, 1, 318, 'SOFTTOY02', NULL, 'bulk-temp/6a438b685114e.png', 'Pasted image (10).png', 'simple', 0, 1, 'committed', NULL, '2026-06-30 09:24:56', '2026-06-30 09:26:47'),
(455, 1, 318, 'SOFTTOY02', NULL, 'bulk-temp/6a438b6852553.png', 'Pasted image (46).png', 'simple', 0, 2, 'committed', NULL, '2026-06-30 09:24:56', '2026-06-30 09:26:47'),
(456, 1, 318, 'SOFTTOY02', NULL, 'bulk-temp/6a438b68537d6.png', 'Pasted image (92).png', 'simple', 0, 3, 'committed', NULL, '2026-06-30 09:24:56', '2026-06-30 09:26:47'),
(457, 1, 319, 'SOFTTOY03', NULL, 'bulk-temp/6a438b6855bc3.png', '1.png', 'simple', 1, 0, 'committed', NULL, '2026-06-30 09:24:56', '2026-06-30 09:26:47'),
(458, 1, 319, 'SOFTTOY03', NULL, 'bulk-temp/6a438b6857340.png', 'Pasted image (141).png', 'simple', 0, 1, 'committed', NULL, '2026-06-30 09:24:56', '2026-06-30 09:26:47'),
(459, 1, 319, 'SOFTTOY03', NULL, 'bulk-temp/6a438b6858c94.png', 'Pasted image (57).png', 'simple', 0, 2, 'committed', NULL, '2026-06-30 09:24:56', '2026-06-30 09:26:47'),
(460, 1, 319, 'SOFTTOY03', NULL, 'bulk-temp/6a438b6859d9e.png', 'Pasted image (71).png', 'simple', 0, 3, 'committed', NULL, '2026-06-30 09:24:56', '2026-06-30 09:26:47'),
(461, 1, 320, 'SOFTTOY04', NULL, 'bulk-temp/6a438b685cabc.png', '1.png', 'simple', 1, 0, 'committed', NULL, '2026-06-30 09:24:56', '2026-06-30 09:26:47'),
(462, 1, 320, 'SOFTTOY04', NULL, 'bulk-temp/6a438b685e0b3.png', 'Pasted image (123).png', 'simple', 0, 1, 'committed', NULL, '2026-06-30 09:24:56', '2026-06-30 09:26:47'),
(463, 1, 320, 'SOFTTOY04', NULL, 'bulk-temp/6a438b685f62f.png', 'Pasted image (152).png', 'simple', 0, 2, 'committed', NULL, '2026-06-30 09:24:56', '2026-06-30 09:26:47'),
(464, 1, 320, 'SOFTTOY04', NULL, 'bulk-temp/6a438b6860d57.png', 'Pasted image (66).png', 'simple', 0, 3, 'committed', NULL, '2026-06-30 09:24:56', '2026-06-30 09:26:47'),
(465, 1, 321, 'SOFTTOY05', NULL, 'bulk-temp/6a438b686358d.png', '1.png', 'simple', 1, 0, 'committed', NULL, '2026-06-30 09:24:56', '2026-06-30 09:26:47'),
(466, 1, 321, 'SOFTTOY05', NULL, 'bulk-temp/6a438b6864c1c.png', 'Pasted image (32).png', 'simple', 0, 1, 'committed', NULL, '2026-06-30 09:24:56', '2026-06-30 09:26:47'),
(467, 1, 321, 'SOFTTOY05', NULL, 'bulk-temp/6a438b6865f63.png', 'Pasted image (82).png', 'simple', 0, 2, 'committed', NULL, '2026-06-30 09:24:56', '2026-06-30 09:26:47'),
(468, 1, 321, 'SOFTTOY05', NULL, 'bulk-temp/6a438b686740f.png', 'WHITE-XXL-top.png', 'simple', 0, 3, 'committed', NULL, '2026-06-30 09:24:56', '2026-06-30 09:26:47'),
(469, 1, 322, 'SOFTTOY06', NULL, 'bulk-temp/6a438b6869ac3.png', '1.png', 'simple', 1, 0, 'committed', NULL, '2026-06-30 09:24:56', '2026-06-30 09:26:47'),
(470, 1, 322, 'SOFTTOY06', NULL, 'bulk-temp/6a438b686b0e7.png', 'Pasted image (183).png', 'simple', 0, 1, 'committed', NULL, '2026-06-30 09:24:56', '2026-06-30 09:26:47'),
(471, 1, 322, 'SOFTTOY06', NULL, 'bulk-temp/6a438b686c411.png', 'Pasted image (55).png', 'simple', 0, 2, 'committed', NULL, '2026-06-30 09:24:56', '2026-06-30 09:26:47'),
(472, 1, 322, 'SOFTTOY06', NULL, 'bulk-temp/6a438b686d886.png', 'Pasted image (99).png', 'simple', 0, 3, 'committed', NULL, '2026-06-30 09:24:56', '2026-06-30 09:26:47'),
(473, 1, 323, 'SOFTTOY07', NULL, 'bulk-temp/6a438b686fd57.png', '1.png', 'simple', 1, 0, 'committed', NULL, '2026-06-30 09:24:56', '2026-06-30 09:26:47'),
(474, 1, 323, 'SOFTTOY07', NULL, 'bulk-temp/6a438b68712d3.png', 'Pasted image (114).png', 'simple', 0, 1, 'committed', NULL, '2026-06-30 09:24:56', '2026-06-30 09:26:47'),
(475, 1, 323, 'SOFTTOY07', NULL, 'bulk-temp/6a438b687257d.png', 'Pasted image (164).png', 'simple', 0, 2, 'committed', NULL, '2026-06-30 09:24:56', '2026-06-30 09:26:47'),
(476, 1, 323, 'SOFTTOY07', NULL, 'bulk-temp/6a438b6873a74.png', 'Pasted image (29).png', 'simple', 0, 3, 'committed', NULL, '2026-06-30 09:24:56', '2026-06-30 09:26:47'),
(477, 1, 324, 'SOFTTOY08', NULL, 'bulk-temp/6a438b6875fe1.png', '1.png', 'simple', 1, 0, 'committed', NULL, '2026-06-30 09:24:56', '2026-06-30 09:26:47'),
(478, 1, 324, 'SOFTTOY08', NULL, 'bulk-temp/6a438b68774a8.png', 'Pasted image (131).png', 'simple', 0, 1, 'committed', NULL, '2026-06-30 09:24:56', '2026-06-30 09:26:47'),
(479, 1, 324, 'SOFTTOY08', NULL, 'bulk-temp/6a438b6878a73.png', 'RED-XL-top.png', 'simple', 0, 2, 'committed', NULL, '2026-06-30 09:24:56', '2026-06-30 09:26:47'),
(480, 1, 324, 'SOFTTOY08', NULL, 'bulk-temp/6a438b6879ce6.png', 'Screenshot from 2026-03-05 11-22-55.png', 'simple', 0, 3, 'committed', NULL, '2026-06-30 09:24:56', '2026-06-30 09:26:47'),
(481, 1, 288, 'TODDLERSAN07', 974, 'bulk-temp/6a438b687ea0f.png', '1.png', 'visual_variant', 1, 0, 'committed', NULL, '2026-06-30 09:24:56', '2026-06-30 09:26:44'),
(482, 1, 288, 'TODDLERSAN07', 974, 'bulk-temp/6a438b68803ef.png', 'Pasted image (19).png', 'visual_variant', 0, 1, 'committed', NULL, '2026-06-30 09:24:56', '2026-06-30 09:26:44'),
(483, 1, 288, 'TODDLERSAN07', 974, 'bulk-temp/6a438b6881dad.png', 'Screenshot from 2026-03-04 15-01-27.png', 'visual_variant', 0, 2, 'committed', NULL, '2026-06-30 09:24:56', '2026-06-30 09:26:44'),
(484, 1, 288, 'TODDLERSAN07', 974, 'bulk-temp/6a438b688356d.png', 'Screenshot from 2026-03-05 11-22-31.png', 'visual_variant', 0, 3, 'committed', NULL, '2026-06-30 09:24:56', '2026-06-30 09:26:44'),
(485, 1, 288, 'TODDLERSAN07', 980, 'bulk-temp/6a438b68859e2.png', '1.png', 'visual_variant', 1, 0, 'committed', NULL, '2026-06-30 09:24:56', '2026-06-30 09:26:44'),
(486, 1, 288, 'TODDLERSAN07', 980, 'bulk-temp/6a438b6887776.png', 'Pasted image (176).png', 'visual_variant', 0, 1, 'committed', NULL, '2026-06-30 09:24:56', '2026-06-30 09:26:44'),
(487, 1, 288, 'TODDLERSAN07', 980, 'bulk-temp/6a438b6889856.png', 'Pasted image (45).png', 'visual_variant', 0, 2, 'committed', NULL, '2026-06-30 09:24:56', '2026-06-30 09:26:44'),
(488, 1, 288, 'TODDLERSAN07', 980, 'bulk-temp/6a438b688aea4.png', 'WHITE-XXL-front.png', 'visual_variant', 0, 3, 'committed', NULL, '2026-06-30 09:24:56', '2026-06-30 09:26:44'),
(489, 1, 301, 'TODDLERTOP20', 976, 'bulk-temp/6a438b688de96.png', '1.png', 'visual_variant', 1, 0, 'committed', NULL, '2026-06-30 09:24:56', '2026-06-30 09:26:46'),
(490, 1, 301, 'TODDLERTOP20', 976, 'bulk-temp/6a438b688f570.png', 'Pasted image (102).png', 'visual_variant', 0, 1, 'committed', NULL, '2026-06-30 09:24:56', '2026-06-30 09:26:46'),
(491, 1, 301, 'TODDLERTOP20', 976, 'bulk-temp/6a438b6890cd4.png', 'Pasted image (156).png', 'visual_variant', 0, 2, 'committed', NULL, '2026-06-30 09:24:56', '2026-06-30 09:26:46'),
(492, 1, 301, 'TODDLERTOP20', 976, 'bulk-temp/6a438b6892087.png', 'Pasted image (183).png', 'visual_variant', 0, 3, 'committed', NULL, '2026-06-30 09:24:56', '2026-06-30 09:26:46'),
(493, 1, 301, 'TODDLERTOP20', 979, 'bulk-temp/6a438b68960dd.png', '1.png', 'visual_variant', 1, 0, 'committed', NULL, '2026-06-30 09:24:56', '2026-06-30 09:26:46'),
(494, 1, 301, 'TODDLERTOP20', 979, 'bulk-temp/6a438b689820f.png', 'Pasted image (195).png', 'visual_variant', 0, 1, 'committed', NULL, '2026-06-30 09:24:56', '2026-06-30 09:26:46'),
(495, 1, 301, 'TODDLERTOP20', 979, 'bulk-temp/6a438b68998a3.png', 'Pasted image (80).png', 'visual_variant', 0, 2, 'committed', NULL, '2026-06-30 09:24:56', '2026-06-30 09:26:46'),
(496, 1, 301, 'TODDLERTOP20', 979, 'bulk-temp/6a438b689ab46.png', 'Pasted image (9).png', 'visual_variant', 0, 3, 'committed', NULL, '2026-06-30 09:24:56', '2026-06-30 09:26:46'),
(497, 1, 301, 'TODDLERTOP20', 980, 'bulk-temp/6a438b689cfb1.png', '1.png', 'visual_variant', 1, 0, 'committed', NULL, '2026-06-30 09:24:56', '2026-06-30 09:26:46'),
(498, 1, 301, 'TODDLERTOP20', 980, 'bulk-temp/6a438b689e653.png', 'GREY-M.png', 'visual_variant', 0, 1, 'committed', NULL, '2026-06-30 09:24:56', '2026-06-30 09:26:46'),
(499, 1, 301, 'TODDLERTOP20', 980, 'bulk-temp/6a438b68a00cd.png', 'Pasted image (113).png', 'visual_variant', 0, 2, 'committed', NULL, '2026-06-30 09:24:56', '2026-06-30 09:26:46'),
(500, 1, 301, 'TODDLERTOP20', 980, 'bulk-temp/6a438b68a1e2e.png', 'Pasted image (156).png', 'visual_variant', 0, 3, 'committed', NULL, '2026-06-30 09:24:56', '2026-06-30 09:26:46');

-- --------------------------------------------------------

--
-- Table structure for table `ingestion_variants`
--

CREATE TABLE `ingestion_variants` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ingestion_product_id` bigint(20) UNSIGNED NOT NULL,
  `variant_key` varchar(255) NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`payload`)),
  `status` enum('pending','committed','failed') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ingestion_variants`
--

INSERT INTO `ingestion_variants` (`id`, `ingestion_product_id`, `variant_key`, `payload`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, '85ffc9ed8d262edc99eb0ec5432cc2b52815c10b', '{\"variant_key\":\"85ffc9ed8d262edc99eb0ec5432cc2b52815c10b\",\"variant_attribute_value_ids\":[976,990],\"price\":1299,\"stock\":25,\"status\":1}', 'pending', '2026-06-18 04:49:26', '2026-06-18 04:49:26'),
(2, 1, '037837258359e0f553feca9e60d7e4451eb933b5', '{\"variant_key\":\"037837258359e0f553feca9e60d7e4451eb933b5\",\"variant_attribute_value_ids\":[974,991],\"price\":1399,\"stock\":20,\"status\":1}', 'pending', '2026-06-18 04:49:26', '2026-06-18 04:49:26'),
(3, 2, 'afb72029e0fcd50aaf520b0151109ba0de36c821', '{\"variant_key\":\"afb72029e0fcd50aaf520b0151109ba0de36c821\",\"variant_attribute_value_ids\":[979,989],\"price\":1899,\"stock\":15,\"status\":1}', 'pending', '2026-06-18 04:49:27', '2026-06-18 04:49:27'),
(4, 3, '85ffc9ed8d262edc99eb0ec5432cc2b52815c10b', '{\"variant_key\":\"85ffc9ed8d262edc99eb0ec5432cc2b52815c10b\",\"variant_attribute_value_ids\":[976,990],\"price\":999,\"stock\":40,\"status\":1}', 'pending', '2026-06-18 04:49:27', '2026-06-18 04:49:27'),
(5, 4, 'f66b7dcd21696a4242e1ff93608c405741802c92', '{\"variant_key\":\"f66b7dcd21696a4242e1ff93608c405741802c92\",\"variant_attribute_value_ids\":[998],\"price\":399,\"stock\":100,\"status\":1}', 'pending', '2026-06-18 04:49:27', '2026-06-18 04:49:27'),
(6, 5, '4a839f86b122140fda5b48dc57e2f0fc170d0356', '{\"variant_key\":\"4a839f86b122140fda5b48dc57e2f0fc170d0356\",\"variant_attribute_value_ids\":[997],\"price\":499,\"stock\":60,\"status\":1}', 'pending', '2026-06-18 04:49:27', '2026-06-18 04:49:27'),
(7, 6, 'e3cbba8883fe746c6e35783c9404b4bc0c7ee9eb', '{\"variant_key\":\"e3cbba8883fe746c6e35783c9404b4bc0c7ee9eb\",\"variant_attribute_value_ids\":[1000],\"price\":2499,\"stock\":20,\"status\":1}', 'pending', '2026-06-18 04:49:27', '2026-06-18 04:49:27'),
(8, 7, 'da39a3ee5e6b4b0d3255bfef95601890afd80709', '{\"variant_key\":\"da39a3ee5e6b4b0d3255bfef95601890afd80709\",\"variant_attribute_value_ids\":[],\"price\":799,\"stock\":50,\"status\":1}', 'pending', '2026-06-18 04:49:27', '2026-06-18 04:49:27'),
(9, 8, 'da39a3ee5e6b4b0d3255bfef95601890afd80709', '{\"variant_key\":\"da39a3ee5e6b4b0d3255bfef95601890afd80709\",\"variant_attribute_value_ids\":[],\"price\":999,\"stock\":30,\"status\":1}', 'pending', '2026-06-18 04:49:27', '2026-06-18 04:49:27'),
(10, 9, 'da39a3ee5e6b4b0d3255bfef95601890afd80709', '{\"variant_key\":\"da39a3ee5e6b4b0d3255bfef95601890afd80709\",\"variant_attribute_value_ids\":[],\"price\":899,\"stock\":25,\"status\":1}', 'pending', '2026-06-18 04:49:27', '2026-06-18 04:49:27'),
(11, 10, 'da39a3ee5e6b4b0d3255bfef95601890afd80709', '{\"variant_key\":\"da39a3ee5e6b4b0d3255bfef95601890afd80709\",\"variant_attribute_value_ids\":[],\"price\":1499,\"stock\":15,\"status\":1}', 'pending', '2026-06-18 04:49:27', '2026-06-18 04:49:27');

-- --------------------------------------------------------

--
-- Table structure for table `inventories`
--

CREATE TABLE `inventories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `seller_id` bigint(20) UNSIGNED NOT NULL,
  `sku` varchar(50) NOT NULL COMMENT 'Stock Keeping Unit',
  `quantity` int(11) DEFAULT 0 COMMENT 'Available stock',
  `reserved_quantity` int(11) DEFAULT 0 COMMENT 'Stock reserved for pending orders',
  `warehouse_location` varchar(255) DEFAULT NULL COMMENT 'Optional storage location',
  `price` decimal(10,2) NOT NULL COMMENT 'Selling price (optional if centralized pricing)',
  `cost_price` decimal(10,2) DEFAULT NULL COMMENT 'Cost price for reports',
  `min_stock` int(11) DEFAULT 0 COMMENT 'Low stock threshold for alerts',
  `status` enum('in_stock','low_stock','out_of_stock') NOT NULL DEFAULT 'in_stock',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `inventory_logs`
--

CREATE TABLE `inventory_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `inventory_id` bigint(20) UNSIGNED NOT NULL,
  `action` enum('added','removed','reserved','unreserved','sold','returned') NOT NULL,
  `quantity` int(11) NOT NULL,
  `remarks` varchar(255) DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `master_categories`
--

CREATE TABLE `master_categories` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `image_url` varchar(512) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `master_categories`
--

INSERT INTO `master_categories` (`id`, `name`, `slug`, `image_url`, `status`) VALUES
(1, 'BOY FASHION', 'boy-fashion', 'images/master_category_banners/boy-fashion.jpg', 1),
(2, 'GIRL FASHION', 'girl-fashion', NULL, 1),
(3, 'FOOTWEAR', 'footwear', NULL, 1),
(4, 'TOYS', 'toys', NULL, 1),
(5, 'DIAPERING', 'diapering', NULL, 1),
(6, 'GEAR', 'gear', NULL, 1),
(7, 'FEEDING', 'feeding', NULL, 1),
(8, 'BATH', 'bath', NULL, 1),
(9, 'NURSERY', 'nursery', NULL, 1),
(10, 'MOMS', 'moms', NULL, 1),
(11, 'HEALTH & SAFETY', 'health-safety', NULL, 1),
(12, 'BOUTIQUES', 'boutiques', NULL, 1),
(13, 'WOMEN\'S BEAUTY & CARE', 'womens-beauty-care', NULL, 1),
(14, 'BIRTHDAYS GIFTS', 'birthdays-gifts', NULL, 1),
(15, 'BOOKS', 'books', NULL, 1),
(16, 'SCHOOL SUPPLIES', 'school-supplies', NULL, 1),
(17, 'HOME & LIVING', 'home-living', NULL, 1),
(18, 'CARTER\'S', 'carters', NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `master_category_sections`
--

CREATE TABLE `master_category_sections` (
  `id` bigint(15) UNSIGNED NOT NULL,
  `master_category_id` int(11) DEFAULT NULL,
  `section_type_id` int(11) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `position` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `master_category_sections`
--

INSERT INTO `master_category_sections` (`id`, `master_category_id`, `section_type_id`, `category_id`, `position`) VALUES
(1, 1, 1, 1, 1),
(2, 1, 1, 2, 2),
(3, 1, 1, 3, 3),
(4, 1, 1, 4, 4),
(5, 1, 1, 5, 5),
(6, 1, 1, 6, 6),
(7, 1, 1, 7, 7),
(8, 1, 1, 8, 8),
(9, 1, 1, 9, 9),
(10, 1, 1, 10, 10),
(11, 1, 1, 11, 11),
(12, 1, 1, 12, 12),
(13, 1, 1, 13, 13),
(14, 1, 1, 14, 14),
(15, 1, 1, 15, 15),
(16, 1, 1, 16, 16),
(17, 1, 1, 17, 17),
(18, 1, 1, 18, 18),
(19, 1, 1, 19, 19),
(20, 1, 1, 20, 20),
(21, 1, 1, 21, 21),
(22, 1, 1, 22, 22),
(23, 1, 1, 23, 23),
(24, 1, 1, 24, 24),
(25, 1, 1, 25, 25),
(26, 1, 1, 26, 26),
(27, 1, 1, 27, 27),
(28, 1, 1, 28, 28),
(29, 1, 1, 29, 29),
(30, 1, 1, 30, 30),
(31, 1, 1, 31, 31),
(32, 1, 1, 32, 32),
(33, 1, 2, 33, 33),
(34, 1, 2, 34, 34),
(35, 1, 2, 35, 35),
(36, 1, 2, 36, 36),
(37, 1, 3, 37, 37),
(38, 1, 3, 38, 38),
(39, 1, 3, 39, 39),
(40, 1, 3, 40, 40),
(41, 1, 3, 41, 41),
(42, 1, 3, 42, 42),
(43, 1, 3, 43, 43),
(44, 1, 3, 44, 44),
(45, 1, 3, 45, 45),
(46, 1, 3, 46, 46),
(47, 1, 3, 47, 47),
(48, 1, 4, 48, 48),
(49, 1, 4, 19, 49),
(50, 1, 4, 49, 50),
(51, 1, 4, 50, 51),
(52, 1, 4, 51, 52),
(53, 1, 4, 52, 53),
(54, 1, 4, 53, 54),
(55, 1, 4, 29, 55),
(56, 1, 4, 22, 56),
(57, 1, 4, 31, 57),
(58, 1, 5, 54, 58),
(59, 1, 5, 55, 59),
(60, 1, 5, 56, 60),
(61, 1, 5, 57, 61),
(62, 1, 5, 58, 62),
(63, 1, 5, 59, 63),
(64, 1, 5, 60, 64),
(65, 1, 5, 61, 65),
(66, 1, 5, 62, 66),
(67, 1, 5, 63, 67),
(68, 1, 5, 64, 68),
(69, 1, 5, 65, 69),
(70, 1, 5, 66, 70),
(71, 1, 6, 67, 71),
(72, 1, 6, 68, 72),
(73, 1, 6, 69, 73),
(74, 1, 6, 70, 74),
(75, 1, 7, 71, 75),
(76, 1, 7, 72, 76),
(77, 1, 7, 73, 77),
(78, 1, 7, 74, 78),
(79, 1, 7, 75, 79),
(80, 1, 7, 76, 80),
(81, 1, 7, 77, 81),
(82, 1, 7, 78, 82),
(83, 1, 7, 79, 83),
(84, 1, 7, 80, 84),
(85, 1, 7, 81, 85),
(86, 1, 7, 82, 86),
(87, 1, 7, 83, 87),
(88, 1, 7, 84, 88),
(89, 1, 7, 85, 89),
(90, 1, 7, 86, 90),
(91, 1, 7, 87, 91),
(92, 1, 7, 88, 92),
(93, 1, 7, 89, 93),
(94, 1, 7, 90, 94),
(95, 1, 7, 91, 95),
(96, 1, 7, 92, 96),
(97, 1, 7, 93, 97),
(98, 1, 7, 94, 98),
(99, 1, 7, 95, 99),
(100, 1, 7, 96, 100),
(101, 1, 7, 97, 101),
(102, 2, 1, 98, 102),
(103, 2, 1, 1, 103),
(104, 2, 1, 99, 104),
(105, 2, 1, 100, 105),
(106, 2, 1, 101, 106),
(107, 2, 1, 5, 107),
(108, 2, 1, 6, 108),
(109, 2, 1, 7, 109),
(110, 2, 1, 102, 110),
(111, 2, 1, 103, 111),
(112, 2, 1, 104, 112),
(113, 2, 1, 11, 113),
(114, 2, 1, 14, 114),
(115, 2, 1, 105, 115),
(116, 2, 1, 106, 116),
(117, 2, 1, 18, 117),
(118, 2, 1, 9, 118),
(119, 2, 1, 12, 119),
(120, 2, 1, 13, 120),
(121, 2, 1, 20, 121),
(122, 2, 1, 15, 122),
(123, 2, 1, 19, 123),
(124, 2, 1, 107, 124),
(125, 2, 1, 22, 125),
(126, 2, 1, 25, 126),
(127, 2, 1, 24, 127),
(128, 2, 1, 27, 128),
(129, 2, 1, 30, 129),
(130, 2, 1, 108, 130),
(131, 2, 1, 29, 131),
(132, 2, 1, 23, 132),
(133, 2, 1, 28, 133),
(134, 2, 1, 31, 134),
(135, 2, 1, 32, 135),
(136, 2, 2, 33, 136),
(137, 2, 2, 34, 137),
(138, 2, 2, 35, 138),
(139, 2, 2, 36, 139),
(140, 2, 3, 37, 140),
(141, 2, 3, 38, 141),
(142, 2, 3, 39, 142),
(143, 2, 3, 40, 143),
(144, 2, 3, 41, 144),
(145, 2, 3, 42, 145),
(146, 2, 3, 43, 146),
(147, 2, 3, 44, 147),
(148, 2, 3, 45, 148),
(149, 2, 3, 46, 149),
(150, 2, 3, 47, 150),
(151, 2, 4, 48, 151),
(152, 2, 4, 109, 152),
(153, 2, 4, 110, 153),
(154, 2, 4, 19, 154),
(155, 2, 4, 49, 155),
(156, 2, 4, 111, 156),
(157, 2, 4, 52, 157),
(158, 2, 4, 50, 158),
(159, 2, 4, 112, 159),
(160, 2, 4, 53, 160),
(161, 2, 4, 113, 161),
(162, 2, 4, 22, 162),
(163, 2, 4, 114, 163),
(164, 2, 5, 54, 164),
(165, 2, 5, 55, 165),
(166, 2, 5, 56, 166),
(167, 2, 5, 57, 167),
(168, 2, 5, 58, 168),
(169, 2, 5, 115, 169),
(170, 2, 5, 59, 170),
(171, 2, 5, 60, 171),
(172, 2, 5, 63, 172),
(173, 2, 5, 62, 173),
(174, 2, 5, 12, 174),
(175, 2, 5, 64, 175),
(176, 2, 5, 65, 176),
(177, 2, 5, 66, 177),
(178, 2, 6, 67, 178),
(179, 2, 6, 68, 179),
(180, 2, 6, 69, 180),
(181, 2, 6, 70, 181),
(182, 2, 7, 71, 182),
(183, 2, 7, 73, 183),
(184, 2, 7, 72, 184),
(185, 2, 7, 75, 185),
(186, 2, 7, 74, 186),
(187, 2, 7, 116, 187),
(188, 2, 7, 81, 188),
(189, 2, 7, 77, 189),
(190, 2, 7, 117, 190),
(191, 2, 7, 78, 191),
(192, 2, 7, 79, 192),
(193, 2, 7, 83, 193),
(194, 2, 7, 80, 194),
(195, 2, 7, 82, 195),
(196, 2, 7, 84, 196),
(197, 2, 7, 85, 197),
(198, 2, 7, 86, 198),
(199, 2, 7, 87, 199),
(200, 2, 7, 88, 200),
(201, 2, 7, 93, 201),
(202, 2, 7, 97, 202),
(203, 2, 7, 95, 203),
(204, 2, 7, 89, 204),
(205, 2, 7, 92, 205),
(206, 2, 7, 118, 206),
(207, 2, 7, 119, 207),
(208, 2, 7, 94, 208),
(209, 2, 7, 120, 209),
(210, 3, 1, 54, 210),
(211, 3, 1, 55, 211),
(212, 3, 1, 56, 212),
(213, 3, 1, 57, 213),
(214, 3, 1, 115, 214),
(215, 3, 1, 58, 215),
(216, 3, 1, 59, 216),
(217, 3, 1, 60, 217),
(218, 3, 1, 62, 218),
(219, 3, 1, 121, 219),
(220, 3, 1, 63, 220),
(221, 3, 1, 64, 221),
(222, 3, 1, 66, 222),
(223, 3, 1, 65, 223),
(224, 3, 8, 122, 234),
(225, 3, 8, 21, 235),
(226, 3, 8, 123, 236),
(227, 3, 3, 38, 224),
(228, 3, 3, 39, 225),
(229, 3, 3, 40, 226),
(230, 3, 3, 41, 227),
(231, 3, 3, 42, 228),
(232, 3, 3, 43, 229),
(233, 3, 3, 44, 230),
(234, 3, 3, 45, 231),
(235, 3, 3, 46, 232),
(236, 3, 3, 47, 233),
(237, 3, 9, 116, 237),
(238, 3, 9, 124, 238),
(239, 3, 9, 72, 239),
(240, 3, 9, 93, 240),
(241, 3, 9, 95, 241),
(242, 3, 9, 125, 242),
(243, 3, 9, 126, 243),
(244, 3, 9, 127, 244),
(245, 3, 9, 97, 245),
(246, 4, 1, 128, 246),
(247, 4, 1, 129, 247),
(248, 4, 1, 130, 248),
(249, 4, 1, 131, 249),
(250, 4, 1, 132, 250),
(251, 4, 1, 133, 251),
(252, 4, 1, 134, 252),
(253, 4, 1, 135, 253),
(254, 4, 1, 136, 254),
(255, 4, 1, 137, 255),
(256, 4, 1, 138, 256),
(257, 4, 1, 139, 257),
(258, 4, 1, 140, 258),
(259, 4, 1, 141, 259),
(260, 4, 1, 142, 260),
(261, 4, 1, 143, 261),
(262, 4, 1, 144, 262),
(263, 4, 1, 145, 263),
(264, 4, 1, 146, 264),
(265, 4, 1, 147, 265),
(266, 4, 1, 148, 266),
(267, 4, 1, 149, 267),
(268, 4, 1, 150, 268),
(269, 4, 10, 151, 287),
(270, 4, 10, 152, 288),
(271, 4, 10, 153, 289),
(272, 4, 10, 154, 290),
(273, 4, 10, 155, 291),
(274, 4, 10, 156, 292),
(275, 4, 10, 157, 293),
(276, 4, 10, 158, 294),
(277, 4, 11, 159, 295),
(278, 4, 11, 160, 296),
(279, 4, 11, 161, 297),
(280, 4, 11, 162, 298),
(281, 4, 11, 163, 299),
(282, 4, 11, 164, 300),
(283, 4, 11, 165, 301),
(284, 4, 11, 166, 302),
(285, 4, 11, 167, 303),
(286, 4, 11, 168, 304),
(287, 4, 6, 169, 269),
(288, 4, 6, 170, 270),
(289, 4, 6, 171, 271),
(290, 4, 6, 172, 272),
(291, 4, 12, 173, 305),
(292, 4, 12, 174, 306),
(293, 4, 12, 175, 307),
(294, 4, 12, 176, 308),
(295, 4, 12, 177, 309),
(296, 4, 12, 178, 310),
(297, 4, 12, 179, 311),
(298, 4, 7, 180, 273),
(299, 4, 7, 181, 274),
(300, 4, 7, 71, 275),
(301, 4, 7, 182, 276),
(302, 4, 7, 183, 277),
(303, 4, 7, 184, 278),
(304, 4, 7, 185, 279),
(305, 4, 7, 186, 280),
(306, 4, 7, 187, 281),
(307, 4, 7, 188, 282),
(308, 4, 7, 189, 283),
(309, 4, 7, 82, 284),
(310, 4, 7, 75, 285),
(311, 4, 7, 190, 286),
(312, 5, 1, 191, 312),
(313, 5, 1, 192, 313),
(314, 5, 1, 193, 314),
(315, 5, 1, 194, 315),
(316, 5, 1, 195, 316),
(317, 5, 1, 196, 317),
(318, 5, 1, 197, 318),
(319, 5, 1, 198, 319),
(320, 5, 1, 199, 320),
(321, 5, 1, 200, 321),
(322, 5, 1, 201, 322),
(323, 5, 1, 202, 323),
(324, 5, 1, 203, 324),
(325, 5, 1, 204, 325),
(326, 5, 13, 191, 326),
(327, 5, 13, 192, 327),
(328, 5, 13, 205, 328),
(329, 5, 14, 206, 329),
(330, 5, 14, 71, 330),
(331, 5, 14, 207, 331),
(332, 5, 14, 208, 332),
(333, 5, 14, 209, 333),
(334, 5, 14, 210, 334),
(335, 5, 14, 211, 335),
(336, 5, 14, 212, 336),
(337, 5, 14, 213, 337),
(338, 5, 14, 214, 338),
(339, 5, 15, 215, 339),
(340, 5, 15, 216, 340),
(341, 5, 15, 217, 341),
(342, 5, 15, 218, 342),
(343, 5, 15, 219, 343),
(344, 5, 15, 220, 344),
(345, 5, 16, 221, 345),
(346, 5, 16, 222, 346),
(347, 5, 16, 223, 347),
(348, 5, 16, 224, 348),
(349, 5, 17, 225, 349),
(350, 5, 17, 226, 350),
(351, 5, 18, 227, 351),
(352, 5, 18, 228, 352),
(353, 5, 18, 229, 353),
(354, 5, 18, 202, 354),
(355, 5, 18, 203, 355),
(356, 5, 18, 230, 356),
(357, 5, 19, 231, 357),
(358, 5, 19, 232, 358),
(359, 5, 19, 200, 359),
(360, 5, 20, 233, 360),
(361, 5, 20, 234, 361),
(362, 6, 1, 235, 362),
(363, 6, 1, 236, 363),
(364, 6, 1, 151, 364),
(365, 6, 1, 237, 365),
(366, 6, 1, 238, 366),
(367, 6, 1, 239, 367),
(368, 6, 1, 240, 368),
(369, 6, 1, 241, 369),
(370, 6, 1, 242, 370),
(371, 6, 1, 243, 371),
(372, 6, 1, 244, 372),
(373, 6, 21, 245, 390),
(374, 6, 21, 246, 391),
(375, 6, 21, 247, 392),
(376, 6, 21, 248, 393),
(377, 6, 21, 249, 394),
(378, 6, 10, 151, 373),
(379, 6, 10, 152, 374),
(380, 6, 10, 250, 375),
(381, 6, 10, 251, 376),
(382, 6, 10, 252, 377),
(383, 6, 10, 253, 378),
(384, 6, 10, 254, 379),
(385, 6, 22, 255, 395),
(386, 6, 22, 256, 396),
(387, 6, 22, 257, 397),
(388, 6, 23, 258, 398),
(389, 6, 23, 259, 399),
(390, 6, 23, 260, 400),
(391, 6, 23, 261, 401),
(392, 6, 24, 262, 402),
(393, 6, 24, 263, 403),
(394, 6, 24, 264, 404),
(395, 6, 24, 265, 405),
(396, 6, 25, 266, 406),
(397, 6, 25, 267, 407),
(398, 6, 25, 268, 408),
(399, 6, 25, 269, 409),
(400, 6, 26, 156, 410),
(401, 6, 26, 157, 411),
(402, 6, 26, 270, 412),
(403, 6, 27, 271, 413),
(404, 6, 27, 272, 414),
(405, 6, 27, 273, 415),
(406, 6, 28, 274, 416),
(407, 6, 28, 275, 417),
(408, 6, 28, 276, 418),
(409, 6, 14, 71, 380),
(410, 6, 14, 184, 381),
(411, 6, 14, 277, 382),
(412, 6, 14, 278, 383),
(413, 6, 14, 279, 384),
(414, 6, 14, 280, 385),
(415, 6, 14, 281, 386),
(416, 6, 14, 282, 387),
(417, 6, 14, 283, 388),
(418, 6, 14, 284, 389),
(419, 7, 1, 285, 419),
(420, 7, 1, 286, 420),
(421, 7, 1, 287, 421),
(422, 7, 1, 288, 422),
(423, 7, 1, 289, 423),
(424, 7, 1, 290, 424),
(425, 7, 1, 291, 425),
(426, 7, 1, 292, 426),
(427, 7, 1, 293, 427),
(428, 7, 1, 294, 428),
(429, 7, 1, 295, 429),
(430, 7, 1, 296, 430),
(431, 7, 29, 297, 444),
(432, 7, 29, 298, 445),
(433, 7, 29, 299, 446),
(434, 7, 29, 300, 447),
(435, 7, 29, 301, 448),
(436, 7, 30, 302, 449),
(437, 7, 30, 303, 450),
(438, 7, 30, 304, 451),
(439, 7, 30, 305, 452),
(440, 7, 30, 306, 453),
(441, 7, 30, 307, 454),
(442, 7, 30, 308, 455),
(443, 7, 30, 309, 456),
(444, 7, 30, 310, 457),
(445, 7, 30, 311, 458),
(446, 7, 31, 312, 459),
(447, 7, 31, 313, 460),
(448, 7, 31, 314, 461),
(449, 7, 31, 315, 462),
(450, 7, 31, 316, 463),
(451, 7, 32, 317, 464),
(452, 7, 32, 318, 465),
(453, 7, 32, 319, 466),
(454, 7, 32, 320, 467),
(455, 7, 32, 321, 468),
(456, 7, 32, 322, 469),
(457, 7, 33, 323, 470),
(458, 7, 33, 324, 471),
(459, 7, 33, 325, 472),
(460, 7, 34, 326, 473),
(461, 7, 34, 327, 474),
(462, 7, 34, 328, 475),
(463, 7, 34, 329, 476),
(464, 7, 34, 330, 477),
(465, 7, 35, 331, 478),
(466, 7, 35, 332, 479),
(467, 7, 35, 333, 480),
(468, 7, 35, 334, 481),
(469, 7, 36, 335, 482),
(470, 7, 36, 336, 483),
(471, 7, 36, 337, 484),
(472, 7, 36, 338, 485),
(473, 7, 37, 339, 486),
(474, 7, 37, 340, 487),
(475, 7, 37, 341, 488),
(476, 7, 37, 342, 489),
(477, 7, 37, 343, 490),
(478, 7, 37, 344, 491),
(479, 7, 37, 345, 492),
(480, 7, 38, 346, 493),
(481, 7, 38, 347, 494),
(482, 7, 38, 348, 495),
(483, 7, 38, 349, 496),
(484, 7, 38, 350, 497),
(485, 7, 38, 351, 498),
(486, 7, 38, 352, 499),
(487, 7, 38, 353, 500),
(488, 7, 38, 354, 501),
(489, 7, 38, 355, 502),
(490, 7, 14, 71, 431),
(491, 7, 14, 356, 432),
(492, 7, 14, 357, 433),
(493, 7, 14, 358, 434),
(494, 7, 14, 359, 435),
(495, 7, 14, 360, 436),
(496, 7, 14, 361, 437),
(497, 7, 14, 362, 438),
(498, 7, 14, 363, 439),
(499, 7, 14, 214, 440),
(500, 7, 14, 279, 441),
(501, 7, 14, 364, 442),
(502, 7, 14, 365, 443),
(503, 8, 1, 366, 503),
(504, 8, 1, 367, 504),
(505, 8, 1, 368, 505),
(506, 8, 1, 369, 506),
(507, 8, 1, 370, 507),
(508, 8, 1, 371, 508),
(509, 8, 1, 372, 509),
(510, 8, 1, 147, 510),
(511, 8, 1, 373, 511),
(512, 8, 39, 374, 522),
(513, 8, 39, 375, 523),
(514, 8, 39, 376, 524),
(515, 8, 39, 377, 525),
(516, 8, 39, 378, 526),
(517, 8, 39, 379, 527),
(518, 8, 39, 380, 528),
(519, 8, 40, 381, 529),
(520, 8, 40, 382, 530),
(521, 8, 40, 383, 531),
(522, 8, 41, 384, 532),
(523, 8, 41, 385, 533),
(524, 8, 41, 386, 534),
(525, 8, 41, 387, 535),
(526, 8, 41, 388, 536),
(527, 8, 42, 389, 537),
(528, 8, 42, 390, 538),
(529, 8, 42, 391, 539),
(530, 8, 42, 392, 540),
(531, 8, 42, 393, 541),
(532, 8, 42, 394, 542),
(533, 8, 14, 71, 512),
(534, 8, 14, 212, 513),
(535, 8, 14, 209, 514),
(536, 8, 14, 395, 515),
(537, 8, 14, 396, 516),
(538, 8, 14, 359, 517),
(539, 8, 14, 397, 518),
(540, 8, 14, 398, 519),
(541, 8, 14, 399, 520),
(542, 8, 14, 214, 521),
(543, 8, 43, 400, 543),
(544, 8, 43, 401, 544),
(545, 8, 43, 386, 545),
(546, 8, 44, 402, 546),
(547, 8, 44, 403, 547),
(548, 8, 44, 404, 548),
(549, 8, 45, 405, 549),
(550, 8, 45, 406, 550),
(551, 8, 45, 407, 551),
(552, 8, 45, 408, 552),
(553, 8, 45, 409, 553),
(554, 8, 46, 410, 554),
(555, 8, 46, 411, 555),
(556, 8, 46, 412, 556),
(557, 8, 47, 413, 557),
(558, 8, 47, 414, 558),
(559, 8, 47, 415, 559),
(560, 8, 47, 416, 560),
(561, 9, 1, 417, 561),
(562, 9, 1, 418, 562),
(563, 9, 1, 419, 563),
(564, 9, 1, 420, 564),
(565, 9, 1, 421, 565),
(566, 9, 1, 422, 566),
(567, 9, 1, 423, 567),
(568, 9, 1, 424, 568),
(569, 9, 1, 425, 569),
(570, 9, 1, 426, 570),
(571, 9, 1, 427, 571),
(572, 9, 48, 428, 586),
(573, 9, 48, 429, 587),
(574, 9, 48, 419, 588),
(575, 9, 48, 430, 589),
(576, 9, 49, 431, 590),
(577, 9, 49, 432, 591),
(578, 9, 49, 433, 592),
(579, 9, 49, 434, 593),
(580, 9, 49, 435, 594),
(581, 9, 49, 436, 595),
(582, 9, 50, 437, 596),
(583, 9, 50, 438, 597),
(584, 9, 50, 439, 598),
(585, 9, 50, 440, 599),
(586, 9, 50, 196, 600),
(587, 9, 51, 441, 601),
(588, 9, 51, 442, 602),
(589, 9, 51, 443, 603),
(590, 9, 51, 444, 604),
(591, 9, 51, 445, 605),
(592, 9, 51, 446, 606),
(593, 9, 51, 447, 607),
(594, 9, 51, 448, 608),
(595, 9, 51, 449, 609),
(596, 9, 52, 450, 610),
(597, 9, 52, 428, 611),
(598, 9, 52, 451, 612),
(599, 9, 52, 452, 613),
(600, 9, 52, 453, 614),
(601, 9, 52, 454, 615),
(602, 9, 14, 71, 572),
(603, 9, 14, 184, 573),
(604, 9, 14, 455, 574),
(605, 9, 14, 456, 575),
(606, 9, 14, 457, 576),
(607, 9, 14, 458, 577),
(608, 9, 14, 278, 578),
(609, 9, 14, 459, 579),
(610, 9, 14, 277, 580),
(611, 9, 14, 279, 581),
(612, 9, 14, 460, 582),
(613, 9, 14, 461, 583),
(614, 9, 14, 462, 584),
(615, 9, 14, 463, 585),
(616, 9, 53, 464, 616),
(617, 9, 53, 421, 617),
(618, 9, 54, 465, 618),
(619, 9, 54, 466, 619),
(620, 9, 54, 467, 620),
(621, 9, 54, 468, 621),
(622, 9, 55, 469, 622),
(623, 9, 55, 470, 623),
(624, 9, 55, 471, 624),
(625, 9, 56, 472, 625),
(626, 9, 56, 473, 626),
(627, 9, 56, 474, 627),
(628, 9, 56, 475, 628),
(629, 9, 56, 476, 629),
(630, 9, 56, 477, 630),
(631, 9, 56, 449, 631),
(632, 9, 56, 478, 632),
(633, 9, 56, 479, 633),
(634, 9, 57, 480, 634),
(635, 9, 57, 481, 635),
(636, 9, 57, 482, 636),
(637, 9, 57, 483, 637),
(638, 9, 57, 484, 638),
(639, 9, 58, 485, 639),
(640, 9, 58, 486, 640),
(641, 9, 58, 487, 641),
(642, 9, 59, 488, 642),
(643, 9, 59, 489, 643),
(644, 9, 59, 490, 644),
(645, 9, 59, 491, 645),
(646, 9, 59, 492, 646),
(647, 10, 1, 493, 647),
(648, 10, 1, 494, 648),
(649, 10, 1, 495, 649),
(650, 10, 1, 496, 650),
(651, 10, 1, 497, 651),
(652, 10, 1, 498, 652),
(653, 10, 60, 499, 653),
(654, 10, 60, 500, 654),
(655, 10, 60, 501, 655),
(656, 10, 61, 502, 656),
(657, 10, 61, 503, 657),
(658, 10, 61, 504, 658),
(659, 10, 61, 505, 659),
(660, 10, 61, 506, 660),
(661, 10, 61, 507, 661),
(662, 10, 61, 508, 662),
(663, 10, 61, 509, 663),
(664, 10, 61, 510, 664),
(665, 10, 61, 511, 665),
(666, 10, 61, 512, 666),
(667, 10, 61, 513, 667),
(668, 10, 61, 514, 668),
(669, 10, 61, 515, 669),
(670, 10, 62, 516, 670),
(671, 10, 62, 517, 671),
(672, 10, 62, 518, 672),
(673, 10, 62, 519, 673),
(674, 10, 62, 520, 674),
(675, 10, 62, 521, 675),
(676, 10, 62, 522, 676),
(677, 10, 62, 523, 677),
(678, 10, 62, 524, 678),
(679, 10, 62, 525, 679),
(680, 10, 62, 526, 680),
(681, 10, 62, 527, 681),
(682, 10, 62, 528, 682),
(683, 10, 63, 529, 683),
(684, 10, 63, 530, 684),
(685, 10, 63, 531, 685),
(686, 10, 63, 532, 686),
(687, 10, 63, 533, 687),
(688, 10, 64, 287, 688),
(689, 10, 64, 534, 689),
(690, 10, 64, 535, 690),
(691, 10, 64, 536, 691),
(692, 10, 64, 311, 692),
(693, 10, 65, 537, 693),
(694, 10, 65, 538, 694),
(695, 10, 65, 539, 695),
(696, 10, 65, 540, 696),
(697, 10, 65, 196, 697),
(698, 10, 65, 541, 698),
(699, 10, 65, 542, 699),
(700, 10, 65, 231, 700),
(701, 11, 1, 543, 701),
(702, 11, 1, 544, 702),
(703, 11, 1, 545, 703),
(704, 11, 1, 546, 704),
(705, 11, 1, 547, 705),
(706, 11, 1, 548, 706),
(707, 11, 66, 549, 715),
(708, 11, 66, 550, 716),
(709, 11, 66, 551, 717),
(710, 11, 66, 552, 718),
(711, 11, 14, 71, 707),
(712, 11, 14, 359, 708),
(713, 11, 14, 395, 709),
(714, 11, 14, 553, 710),
(715, 11, 14, 360, 711),
(716, 11, 14, 554, 712),
(717, 11, 14, 555, 713),
(718, 11, 14, 556, 714),
(719, 11, 67, 557, 719),
(720, 11, 67, 558, 720),
(721, 11, 67, 559, 721),
(722, 11, 67, 560, 722),
(723, 11, 67, 561, 723),
(724, 11, 67, 562, 724),
(725, 11, 67, 563, 725),
(726, 11, 67, 564, 726),
(727, 11, 67, 565, 727),
(728, 11, 68, 566, 728),
(729, 11, 68, 567, 729),
(730, 11, 68, 568, 730),
(731, 11, 68, 569, 731),
(732, 11, 68, 570, 732),
(733, 11, 68, 571, 733),
(734, 11, 68, 572, 734),
(735, 11, 68, 573, 735),
(736, 11, 69, 574, 736),
(737, 11, 69, 575, 737),
(738, 11, 69, 576, 738),
(739, 11, 69, 577, 739),
(740, 11, 69, 578, 740),
(741, 11, 69, 579, 741),
(742, 11, 69, 580, 742),
(743, 11, 70, 581, 743),
(744, 11, 70, 582, 744),
(745, 11, 70, 583, 745),
(746, 11, 70, 584, 746),
(747, 11, 71, 436, 747),
(748, 11, 71, 585, 748),
(749, 11, 71, 586, 749),
(750, 11, 71, 587, 750),
(751, 11, 71, 588, 751),
(752, 11, 71, 589, 752),
(753, 11, 71, 590, 753),
(754, 11, 71, 591, 754),
(755, 11, 71, 592, 755),
(756, 11, 71, 593, 756),
(757, 11, 71, 594, 757),
(758, 11, 71, 595, 758),
(759, 11, 71, 596, 759),
(760, 11, 71, 597, 760),
(761, 11, 71, 552, 761),
(762, 11, 72, 598, 762),
(763, 11, 72, 599, 763),
(764, 11, 72, 600, 764),
(765, 11, 72, 601, 765),
(766, 11, 72, 602, 766),
(767, 12, 73, 603, 775),
(768, 12, 73, 34, 776),
(769, 12, 73, 604, 777),
(770, 12, 1, 605, 767),
(771, 12, 1, 606, 768),
(772, 12, 1, 607, 769),
(773, 12, 1, 608, 770),
(774, 12, 1, 609, 771),
(775, 12, 1, 610, 772),
(776, 12, 1, 611, 773),
(777, 12, 1, 612, 774),
(778, 12, 74, 359, 778),
(779, 12, 74, 613, 779),
(780, 12, 75, 73, 780),
(781, 12, 75, 74, 781),
(782, 12, 75, 81, 782),
(783, 12, 75, 614, 783),
(784, 12, 75, 89, 784),
(785, 12, 75, 615, 785),
(786, 12, 75, 93, 786),
(787, 12, 75, 97, 787),
(788, 12, 75, 616, 788),
(789, 12, 75, 95, 789),
(790, 12, 75, 617, 790),
(791, 12, 75, 618, 791),
(792, 12, 75, 619, 792),
(793, 12, 76, 620, 793),
(794, 12, 76, 621, 794),
(795, 12, 76, 622, 795),
(796, 12, 76, 623, 796),
(797, 12, 76, 624, 797),
(798, 12, 76, 625, 798),
(799, 12, 76, 626, 799),
(800, 12, 76, 627, 800),
(801, 12, 76, 628, 801),
(802, 12, 76, 629, 802),
(803, 12, 77, 86, 803),
(804, 12, 77, 630, 804),
(805, 12, 77, 631, 805),
(806, 12, 77, 632, 806),
(807, 12, 77, 633, 807),
(808, 12, 77, 634, 808),
(809, 12, 77, 635, 809),
(810, 12, 77, 636, 810),
(811, 12, 77, 637, 811),
(812, 12, 77, 638, 812),
(813, 12, 77, 639, 813),
(814, 12, 77, 640, 814),
(815, 12, 78, 641, 815),
(816, 12, 79, 642, 816),
(817, 12, 79, 643, 817),
(818, 12, 79, 644, 818),
(819, 12, 79, 645, 819),
(820, 12, 79, 646, 820),
(821, 12, 79, 647, 821),
(822, 12, 79, 648, 822),
(823, 12, 79, 649, 823),
(824, 12, 79, 650, 824),
(825, 12, 79, 651, 825),
(826, 12, 79, 652, 826),
(827, 12, 79, 653, 827),
(828, 12, 79, 654, 828),
(829, 12, 79, 655, 829),
(830, 12, 79, 656, 830),
(831, 12, 79, 657, 831),
(832, 13, 1, 502, 832),
(833, 13, 1, 503, 833),
(834, 13, 1, 504, 834),
(835, 13, 1, 505, 835),
(836, 13, 1, 506, 836),
(837, 13, 1, 507, 837),
(838, 13, 1, 508, 838),
(839, 13, 1, 509, 839),
(840, 13, 1, 510, 840),
(841, 13, 1, 511, 841),
(842, 13, 1, 512, 842),
(843, 13, 1, 513, 843),
(844, 13, 1, 514, 844),
(845, 13, 1, 658, 845),
(846, 13, 1, 659, 846),
(847, 13, 47, 660, 847),
(848, 13, 47, 661, 848),
(849, 13, 47, 662, 849),
(850, 13, 80, 387, 850),
(851, 13, 80, 663, 851),
(852, 13, 80, 664, 852),
(853, 13, 80, 665, 853),
(854, 13, 80, 666, 854),
(855, 13, 80, 667, 855),
(856, 13, 80, 668, 856),
(857, 13, 80, 669, 857),
(858, 13, 80, 670, 858),
(859, 13, 80, 671, 859),
(860, 13, 80, 672, 860),
(861, 13, 80, 673, 861),
(862, 13, 81, 674, 862),
(863, 13, 81, 675, 863),
(864, 13, 81, 676, 864),
(865, 13, 81, 677, 865),
(866, 13, 81, 678, 866),
(867, 13, 81, 679, 867),
(868, 13, 81, 680, 868),
(869, 13, 82, 681, 869),
(870, 13, 82, 682, 870),
(871, 13, 82, 683, 871),
(872, 13, 82, 531, 872),
(873, 13, 82, 684, 873),
(874, 13, 82, 499, 874),
(875, 13, 82, 685, 875),
(876, 13, 82, 686, 876),
(877, 13, 82, 501, 877),
(878, 13, 82, 687, 878),
(879, 13, 82, 688, 879),
(880, 13, 83, 689, 880),
(881, 13, 83, 690, 881),
(882, 13, 83, 691, 882),
(883, 13, 83, 692, 883),
(884, 13, 83, 693, 884),
(885, 13, 83, 505, 885),
(886, 13, 84, 694, 886),
(887, 13, 84, 695, 887),
(888, 13, 84, 696, 888),
(889, 13, 84, 697, 889),
(890, 13, 84, 698, 890),
(891, 13, 84, 532, 891),
(892, 13, 84, 699, 892),
(893, 13, 85, 700, 893),
(894, 13, 85, 701, 894),
(895, 13, 86, 702, 895),
(896, 13, 86, 534, 896),
(897, 13, 86, 703, 897),
(898, 13, 86, 311, 898),
(899, 14, 87, 704, 899),
(900, 14, 87, 705, 900),
(901, 14, 87, 706, 901),
(902, 14, 87, 707, 902),
(903, 14, 87, 708, 903),
(904, 14, 87, 709, 904),
(905, 14, 87, 710, 905),
(906, 14, 87, 711, 906),
(907, 14, 87, 712, 907),
(908, 14, 88, 713, 908),
(909, 14, 88, 714, 909),
(910, 14, 88, 715, 910),
(911, 14, 88, 716, 911),
(912, 14, 89, 717, 912),
(913, 14, 89, 718, 913),
(914, 14, 89, 719, 914),
(915, 14, 90, 720, 915),
(916, 14, 90, 721, 916),
(917, 14, 90, 722, 917),
(918, 14, 90, 723, 918),
(919, 14, 90, 724, 919),
(920, 14, 90, 725, 920),
(921, 14, 90, 726, 921),
(922, 14, 91, 727, 922),
(923, 14, 91, 728, 923),
(924, 14, 91, 729, 924),
(925, 14, 91, 730, 925),
(926, 14, 91, 731, 926),
(927, 14, 91, 732, 927),
(928, 14, 91, 733, 928),
(929, 14, 92, 734, 929),
(930, 14, 92, 735, 930),
(931, 14, 92, 736, 931),
(932, 14, 93, 737, 932),
(933, 14, 93, 738, 933),
(934, 14, 93, 739, 934),
(935, 14, 93, 740, 935),
(936, 14, 93, 611, 936),
(937, 14, 93, 612, 937),
(938, 14, 93, 741, 938),
(939, 15, 1, 742, 939),
(940, 15, 1, 743, 940),
(941, 15, 1, 744, 941),
(942, 15, 1, 745, 942),
(943, 15, 1, 746, 943),
(944, 15, 1, 747, 944),
(945, 15, 1, 748, 945),
(946, 15, 1, 749, 946),
(947, 15, 1, 750, 947),
(948, 15, 1, 751, 948),
(949, 15, 1, 688, 949),
(950, 15, 1, 752, 950),
(951, 15, 94, 753, 960),
(952, 15, 94, 754, 961),
(953, 15, 94, 755, 962),
(954, 15, 94, 756, 963),
(955, 15, 94, 757, 964),
(956, 15, 95, 758, 965),
(957, 15, 95, 759, 966),
(958, 15, 95, 760, 967),
(959, 15, 95, 761, 968),
(960, 15, 95, 762, 969),
(961, 15, 96, 763, 970),
(962, 15, 96, 764, 971),
(963, 15, 96, 765, 972),
(964, 15, 96, 766, 973),
(965, 15, 96, 767, 974),
(966, 15, 97, 768, 975),
(967, 15, 97, 769, 976),
(968, 15, 97, 770, 977),
(969, 15, 97, 771, 978),
(970, 15, 14, 71, 951),
(971, 15, 14, 182, 952),
(972, 15, 14, 772, 953),
(973, 15, 14, 773, 954),
(974, 15, 14, 774, 955),
(975, 15, 14, 775, 956),
(976, 15, 14, 776, 957),
(977, 15, 14, 777, 958),
(978, 15, 14, 778, 959),
(979, 15, 98, 779, 979),
(980, 15, 98, 780, 980),
(981, 15, 98, 781, 981),
(982, 15, 98, 782, 982),
(983, 15, 98, 783, 983),
(984, 16, 1, 784, 984),
(985, 16, 1, 785, 985),
(986, 16, 1, 786, 986),
(987, 16, 1, 787, 987),
(988, 16, 1, 788, 988),
(989, 16, 99, 789, 989),
(990, 16, 99, 790, 990),
(991, 16, 99, 791, 991),
(992, 16, 99, 792, 992),
(993, 16, 100, 793, 993),
(994, 16, 100, 794, 994),
(995, 16, 100, 795, 995),
(996, 16, 100, 187, 996),
(997, 16, 100, 796, 997),
(998, 16, 100, 797, 998),
(999, 16, 100, 798, 999),
(1000, 16, 100, 799, 1000),
(1001, 16, 101, 800, 1001),
(1002, 16, 101, 801, 1002),
(1003, 16, 101, 802, 1003),
(1004, 16, 101, 803, 1004),
(1005, 16, 101, 804, 1005),
(1006, 16, 102, 805, 1006),
(1007, 16, 102, 806, 1007),
(1008, 16, 102, 807, 1008),
(1009, 16, 103, 808, 1009),
(1010, 16, 103, 809, 1010),
(1011, 16, 103, 184, 1011),
(1012, 16, 103, 810, 1012),
(1013, 16, 103, 811, 1013),
(1014, 16, 103, 812, 1014),
(1015, 16, 103, 813, 1015),
(1016, 16, 103, 814, 1016),
(1017, 16, 103, 815, 1017),
(1018, 16, 104, 816, 1018),
(1019, 16, 104, 817, 1019),
(1020, 16, 104, 818, 1020),
(1021, 17, 1, 819, 1021),
(1022, 17, 1, 820, 1022),
(1023, 17, 1, 821, 1023),
(1024, 17, 1, 822, 1024),
(1025, 17, 1, 296, 1025),
(1026, 17, 1, 823, 1026),
(1027, 17, 1, 824, 1027),
(1028, 17, 105, 825, 1028),
(1029, 17, 105, 826, 1029),
(1030, 17, 105, 827, 1030),
(1031, 17, 105, 828, 1031),
(1032, 17, 105, 829, 1032),
(1033, 17, 106, 830, 1033),
(1034, 17, 106, 479, 1034),
(1035, 17, 106, 53, 1035),
(1036, 17, 106, 831, 1036),
(1037, 17, 106, 832, 1037),
(1038, 17, 107, 833, 1038),
(1039, 17, 107, 834, 1039),
(1040, 17, 107, 835, 1040),
(1041, 17, 107, 836, 1041),
(1042, 17, 108, 345, 1042),
(1043, 17, 108, 837, 1043),
(1044, 17, 108, 838, 1044),
(1045, 17, 108, 839, 1045),
(1046, 17, 108, 840, 1046),
(1047, 17, 108, 841, 1047),
(1048, 17, 109, 714, 1048),
(1049, 17, 109, 842, 1049),
(1050, 17, 109, 843, 1050),
(1051, 17, 109, 844, 1051),
(1052, 17, 109, 427, 1052),
(1053, 17, 109, 845, 1053),
(1054, 17, 109, 846, 1054),
(1055, 17, 109, 847, 1055),
(1056, 17, 110, 848, 1056),
(1057, 17, 110, 849, 1057),
(1058, 17, 110, 850, 1058),
(1059, 17, 110, 851, 1059),
(1060, 17, 110, 852, 1060),
(1061, 17, 111, 853, 1061),
(1062, 17, 111, 854, 1062),
(1063, 17, 111, 855, 1063),
(1064, 18, 1, 856, 1064),
(1065, 18, 1, 857, 1065),
(1066, 18, 1, 7, 1066),
(1067, 18, 1, 858, 1067),
(1068, 18, 1, 859, 1068),
(1069, 18, 1, 860, 1069),
(1070, 18, 1, 861, 1070),
(1071, 18, 1, 862, 1071),
(1072, 18, 1, 863, 1072),
(1073, 18, 1, 864, 1073),
(1074, 18, 1, 26, 1074),
(1075, 18, 112, 865, 1083),
(1076, 18, 112, 866, 1084),
(1077, 18, 112, 867, 1085),
(1078, 18, 112, 868, 1086),
(1079, 18, 3, 38, 1075),
(1080, 18, 3, 869, 1076),
(1081, 18, 3, 870, 1077),
(1082, 18, 3, 871, 1078),
(1083, 18, 3, 872, 1079),
(1084, 18, 3, 873, 1080),
(1085, 18, 3, 874, 1081),
(1086, 18, 3, 875, 1082),
(1129, 1, 7, 876, 0),
(1130, 2, 7, 876, 0);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2025_09_09_124855_create_cache_locks_table', 1),
(2, '2025_09_09_124855_create_cache_table', 1),
(3, '2025_09_09_124855_create_categories_table', 1),
(4, '2025_09_09_124855_create_failed_jobs_table', 1),
(5, '2025_09_09_124855_create_job_batches_table', 1),
(6, '2025_09_09_124855_create_jobs_table', 1),
(7, '2025_09_09_124855_create_master_categories_table', 1),
(8, '2025_09_09_124855_create_master_category_sections_table', 1),
(9, '2025_09_09_124855_create_password_reset_tokens_table', 1),
(10, '2025_09_09_124855_create_section_types_table', 1),
(11, '2025_09_09_124855_create_sessions_table', 1),
(12, '2025_09_09_124855_create_users_table', 1),
(13, '2025_09_09_124858_add_foreign_keys_to_master_category_sections_table', 1),
(14, '2025_09_10_073129_add_parent_id_to_categories_table', 1),
(15, '2025_09_10_090940_drop_parent_id_from_categories_table', 2),
(16, '2025_09_10_093952_create_admin_users_table', 3),
(17, '2025_09_10_100032_update_admin_users_table_add_mobile_remove_remember_token', 4),
(18, '2025_09_25_075049_create_payouts_table', 5),
(19, '2025_10_08_174705_create_product_category_section_table', 6),
(20, '2025_10_08_175438_drop_master_category_sections_id_from_products_table', 7),
(21, '2025_10_21_182528_create_brands_table', 8),
(22, '2025_11_21_155416_create_settings_table', 9),
(23, '2025_11_21_170545_add_general_settings_keys_to_settings_table', 10),
(24, '2025_11_24_171750_add_session_id_to_admin_users_table', 11),
(25, '2026_02_13_104818_create_user_otps_table', 12),
(26, '2026_06_18_123520_create_navigation_master_category_mappings_table', 13);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`id`, `role_id`, `model_id`, `model_type`) VALUES
(1, 5, 2, 'App\\Models\\AdminUser'),
(4, 6, 3, 'App\\Models\\AdminUser');

-- --------------------------------------------------------

--
-- Table structure for table `navigation_category_mappings`
--

CREATE TABLE `navigation_category_mappings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_sub_category_id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `navigation_category_mappings`
--

INSERT INTO `navigation_category_mappings` (`id`, `product_sub_category_id`, `category_id`, `created_at`, `updated_at`) VALUES
(1, 476, 2, '2026-06-18 09:52:01', '2026-06-18 09:52:01'),
(2, 476, 3, '2026-06-18 09:52:01', '2026-06-18 09:52:01'),
(20, 479, 13, '2026-06-18 10:04:47', '2026-06-18 10:04:47'),
(21, 489, 4, '2026-06-18 10:04:47', '2026-06-18 10:04:47'),
(22, 489, 5, '2026-06-18 10:04:47', '2026-06-18 10:04:47'),
(23, 489, 862, '2026-06-18 10:04:47', '2026-06-18 10:04:47'),
(24, 482, 18, '2026-06-18 10:04:47', '2026-06-18 10:04:47'),
(25, 482, 23, '2026-06-18 10:04:47', '2026-06-18 10:04:47'),
(26, 478, 7, '2026-06-18 10:04:47', '2026-06-18 10:04:47'),
(27, 480, 14, '2026-06-18 10:04:47', '2026-06-18 10:04:47'),
(28, 480, 863, '2026-06-18 10:04:47', '2026-06-18 10:04:47'),
(29, 481, 24, '2026-06-18 10:04:47', '2026-06-18 10:04:47'),
(30, 481, 25, '2026-06-18 10:04:47', '2026-06-18 10:04:47'),
(31, 481, 864, '2026-06-18 10:04:47', '2026-06-18 10:04:47'),
(32, 483, 58, '2026-06-18 10:08:13', '2026-06-18 10:08:13'),
(33, 483, 60, '2026-06-18 10:08:13', '2026-06-18 10:08:13'),
(34, 485, 62, '2026-06-18 10:08:13', '2026-06-18 10:08:13');

-- --------------------------------------------------------

--
-- Table structure for table `navigation_master_category_mappings`
--

CREATE TABLE `navigation_master_category_mappings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `product_sub_category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `master_category_id` bigint(20) UNSIGNED NOT NULL,
  `priority` int(10) UNSIGNED NOT NULL DEFAULT 100,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `navigation_master_category_mappings`
--

INSERT INTO `navigation_master_category_mappings` (`id`, `product_category_id`, `product_sub_category_id`, `master_category_id`, `priority`, `created_at`, `updated_at`) VALUES
(1, 11, NULL, 4, 100, '2026-06-18 08:00:32', '2026-06-18 08:00:32'),
(2, 8, NULL, 7, 100, '2026-06-18 08:00:32', '2026-06-18 08:00:32'),
(3, 2, NULL, 8, 100, '2026-06-18 08:00:32', '2026-06-18 08:00:32'),
(4, 6, NULL, 5, 100, '2026-06-18 08:00:32', '2026-06-18 08:00:32'),
(5, 1, NULL, 6, 100, '2026-06-18 08:00:32', '2026-06-18 08:00:32'),
(6, 9, NULL, 11, 100, '2026-06-18 08:00:32', '2026-06-18 08:00:32'),
(7, 10, NULL, 10, 100, '2026-06-18 08:00:32', '2026-06-18 08:00:32'),
(8, 3, NULL, 14, 100, '2026-06-18 08:00:32', '2026-06-18 08:00:32'),
(9, 4, NULL, 15, 100, '2026-06-18 08:00:32', '2026-06-18 08:00:32');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `receiver_id` bigint(20) UNSIGNED NOT NULL,
  `receiver_type` enum('admin_user','seller','users') NOT NULL,
  `title` varchar(255) NOT NULL,
  `message` text DEFAULT NULL,
  `type` varchar(255) NOT NULL DEFAULT 'system',
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `receiver_id`, `receiver_type`, `title`, `message`, `type`, `is_read`, `created_at`, `updated_at`) VALUES
(1, 24, 'seller', 'Product Approved', 'Your product has been approved', 'product', 1, '2026-05-11 12:32:06', '2026-05-12 05:50:01'),
(2, 24, 'seller', 'Product Unapproved', 'Your product approval has been removed', 'product', 1, '2026-05-11 12:44:18', '2026-05-12 05:50:01'),
(3, 25, 'seller', 'Product Approved', 'Your product has been approved', 'product', 0, '2026-05-11 12:44:27', '2026-05-11 12:44:27'),
(4, 24, 'seller', 'Product Unapproved', 'Your product approval has been removed', 'product', 1, '2026-05-11 12:44:47', '2026-05-12 05:50:01'),
(5, 24, 'seller', 'Product Approved', 'Your product has been approved', 'product', 1, '2026-05-11 12:44:58', '2026-05-12 05:50:01'),
(6, 24, 'seller', 'Product Approved', 'Your product has been approved', 'product', 1, '2026-05-11 12:45:06', '2026-05-12 05:50:01'),
(7, 1, 'seller', 'Product Approved', 'Your product has been approved', 'product', 0, '2026-05-12 04:52:28', '2026-05-12 04:52:28'),
(8, 1, 'seller', 'Product Approved', 'Your product has been approved', 'product', 0, '2026-05-12 05:26:14', '2026-05-12 05:26:14'),
(9, 1, 'seller', 'Product Unapproved', 'Your product approval has been removed', 'product', 0, '2026-05-12 05:26:44', '2026-05-12 05:26:44'),
(10, 2, 'admin_user', 'New Product Pending', 'A seller submitted a product', 'product', 0, '2026-05-12 05:36:02', '2026-05-12 05:36:02'),
(11, 3, 'admin_user', 'New Product Pending', 'A seller submitted a product', 'product', 0, '2026-05-12 05:36:02', '2026-05-12 05:36:02'),
(12, 6, 'admin_user', 'New Product Pending', 'A seller submitted a product', 'product', 0, '2026-05-12 05:36:02', '2026-05-12 05:36:02'),
(13, 4, 'admin_user', 'New Product Pending', 'A seller submitted a product', 'product', 0, '2026-05-12 05:36:02', '2026-05-12 05:36:02'),
(14, 5, 'admin_user', 'New Product Pending', 'A seller submitted a product', 'product', 0, '2026-05-12 05:36:02', '2026-05-12 05:36:02'),
(15, 24, 'seller', 'Product Approved', 'Your product has been approved', 'product', 1, '2026-05-12 05:36:38', '2026-05-12 05:50:01'),
(16, 24, 'seller', 'Product Unapproved', 'Your product approval has been removed', 'product', 1, '2026-05-12 05:36:52', '2026-05-12 05:50:01');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `shipping_address_id` bigint(20) UNSIGNED DEFAULT NULL,
  `order_number` varchar(50) NOT NULL,
  `razorpay_order_id` varchar(100) DEFAULT NULL,
  `razorpay_payment_id` varchar(100) DEFAULT NULL,
  `total_amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `payment_method` enum('cod','online') NOT NULL DEFAULT 'cod',
  `payment_status` enum('pending','paid','failed') NOT NULL DEFAULT 'pending',
  `order_status` varchar(50) NOT NULL DEFAULT 'active',
  `completion_status` varchar(30) NOT NULL DEFAULT 'processing',
  `last_status_at` datetime DEFAULT NULL,
  `delivered_at` datetime DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `shipping_address_id`, `order_number`, `razorpay_order_id`, `razorpay_payment_id`, `total_amount`, `payment_method`, `payment_status`, `order_status`, `completion_status`, `last_status_at`, `delivered_at`, `notes`, `created_at`, `updated_at`) VALUES
(1, 29, 25, 'ORD-XNFC9XU8KUIH', NULL, NULL, 2199.00, 'online', 'paid', 'placed', 'processing', NULL, NULL, NULL, '2026-04-15 07:09:01', '2026-04-15 07:09:01'),
(2, 29, 25, 'ORD-1PAAYVAK54MQ', NULL, NULL, 891.00, 'online', 'paid', 'placed', 'processing', NULL, NULL, NULL, '2026-04-15 09:46:51', '2026-04-15 09:46:51'),
(3, 29, 25, 'ORD-U76UKUKEFNDC', NULL, NULL, 4491.00, 'online', 'paid', 'placed', 'processing', NULL, NULL, NULL, '2026-04-16 09:28:41', '2026-04-16 09:28:41'),
(6, 31, 26, 'ORD-VKZ5F2GY6P7H', NULL, NULL, 0.00, 'online', 'paid', 'placed', 'processing', NULL, NULL, NULL, '2026-06-30 09:38:07', '2026-06-30 09:38:07'),
(7, 31, 26, 'ORD-TBEDVLN9IMM3', NULL, NULL, 0.00, 'online', 'paid', 'placed', 'processing', NULL, NULL, NULL, '2026-07-01 09:36:52', '2026-07-01 09:36:52'),
(8, 31, 26, 'ORD-FMKSMKGPW5GO', NULL, NULL, 0.00, 'online', 'paid', 'placed', 'processing', NULL, NULL, NULL, '2026-07-01 10:47:03', '2026-07-01 10:47:03');

-- --------------------------------------------------------

--
-- Table structure for table `order_cancellations`
--

CREATE TABLE `order_cancellations` (
  `id` bigint(20) NOT NULL,
  `cancel_number` varchar(50) NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `order_item_id` bigint(20) UNSIGNED DEFAULT NULL,
  `shipment_id` bigint(20) UNSIGNED DEFAULT NULL,
  `seller_id` bigint(20) UNSIGNED DEFAULT NULL,
  `cancelled_by` enum('customer','seller','admin','system') DEFAULT 'customer',
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `reason` text DEFAULT NULL,
  `status` enum('requested','approved','rejected','completed') DEFAULT 'requested',
  `approved_by` bigint(20) UNSIGNED DEFAULT NULL,
  `reviewed_by` bigint(20) UNSIGNED DEFAULT NULL,
  `approved_at` datetime DEFAULT NULL,
  `reviewed_at` datetime DEFAULT NULL,
  `review_notes` text DEFAULT NULL,
  `cancelled_at` datetime DEFAULT NULL,
  `refund_amount` decimal(10,2) DEFAULT NULL,
  `razorpay_refund_id` varchar(100) DEFAULT NULL,
  `completed_at` datetime DEFAULT NULL,
  `refund_status` enum('pending','processing','paid','failed') DEFAULT 'pending',
  `metadata` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`metadata`)),
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `seller_id` bigint(20) UNSIGNED NOT NULL,
  `shipment_id` bigint(20) UNSIGNED DEFAULT NULL,
  `product_variant_id` bigint(20) UNSIGNED DEFAULT NULL,
  `quantity` int(10) UNSIGNED NOT NULL DEFAULT 1,
  `price` decimal(10,2) NOT NULL DEFAULT 0.00,
  `commission_percent` decimal(5,2) DEFAULT NULL,
  `commission_snapshot` decimal(5,2) DEFAULT NULL,
  `commission_amount` decimal(10,2) DEFAULT NULL,
  `seller_amount` decimal(10,2) DEFAULT NULL,
  `settlement_status` enum('pending','settled','refunded') DEFAULT 'pending',
  `item_status` varchar(50) NOT NULL DEFAULT 'pending',
  `return_status` varchar(50) DEFAULT NULL,
  `replacement_status` varchar(50) DEFAULT NULL,
  `cancellation_status` varchar(50) DEFAULT NULL,
  `delivered_at` datetime DEFAULT NULL,
  `cancelled_at` datetime DEFAULT NULL,
  `returned_at` datetime DEFAULT NULL,
  `metadata` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`metadata`)),
  `subtotal` decimal(10,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `seller_id`, `shipment_id`, `product_variant_id`, `quantity`, `price`, `commission_percent`, `commission_snapshot`, `commission_amount`, `seller_amount`, `settlement_status`, `item_status`, `return_status`, `replacement_status`, `cancellation_status`, `delivered_at`, `cancelled_at`, `returned_at`, `metadata`, `subtotal`, `created_at`, `updated_at`) VALUES
(8, 6, 283, 0, NULL, 718, 2, 412.32, NULL, NULL, NULL, NULL, 'pending', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 824.64, '2026-06-30 09:38:07', '2026-06-30 09:38:07'),
(9, 7, 283, 0, NULL, 726, 1, 2166.23, NULL, NULL, NULL, NULL, 'pending', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2166.23, '2026-07-01 09:36:52', '2026-07-01 09:36:52'),
(10, 8, 283, 0, NULL, 719, 1, 2148.24, NULL, NULL, NULL, NULL, 'pending', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2148.24, '2026-07-01 10:47:03', '2026-07-01 10:47:03'),
(11, 8, 306, 0, NULL, 938, 1, 1579.95, NULL, NULL, NULL, NULL, 'pending', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1579.95, '2026-07-01 10:47:03', '2026-07-01 10:47:03');

-- --------------------------------------------------------

--
-- Table structure for table `order_replacements`
--

CREATE TABLE `order_replacements` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `replacement_number` varchar(50) NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `order_item_id` bigint(20) UNSIGNED NOT NULL,
  `shipment_id` bigint(20) UNSIGNED DEFAULT NULL,
  `seller_id` bigint(20) UNSIGNED DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `reviewed_by` bigint(20) UNSIGNED DEFAULT NULL,
  `reason` text DEFAULT NULL,
  `review_notes` text DEFAULT NULL,
  `status` enum('requested','approved','rejected','replacement_created','replacement_shipped','replacement_delivered','completed') DEFAULT 'requested',
  `replacement_order_item_id` bigint(20) UNSIGNED DEFAULT NULL,
  `replacement_shipment_id` bigint(20) UNSIGNED DEFAULT NULL,
  `metadata` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`metadata`)),
  `approved_at` datetime DEFAULT NULL,
  `rejected_at` datetime DEFAULT NULL,
  `completed_at` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_returns`
--

CREATE TABLE `order_returns` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `return_number` varchar(50) NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `order_item_id` bigint(20) UNSIGNED DEFAULT NULL,
  `shipment_id` bigint(20) UNSIGNED DEFAULT NULL,
  `seller_id` bigint(20) UNSIGNED DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `reviewed_by` bigint(20) UNSIGNED DEFAULT NULL,
  `reviewed_at` datetime DEFAULT NULL,
  `review_notes` text DEFAULT NULL,
  `reason` text DEFAULT NULL,
  `status` enum('requested','approved','rejected','pickup_scheduled','picked_up','received','inspection_passed','inspection_failed','refund_initiated','refunded','closed') DEFAULT 'requested',
  `refund_amount` decimal(10,2) DEFAULT NULL,
  `razorpay_refund_id` varchar(100) DEFAULT NULL,
  `refunded_at` datetime DEFAULT NULL,
  `closed_at` datetime DEFAULT NULL,
  `refund_status` enum('pending','processing','paid','failed') DEFAULT 'pending',
  `pickup_awb` varchar(100) DEFAULT NULL,
  `pickup_status` varchar(50) DEFAULT NULL,
  `pickup_scheduled_at` datetime DEFAULT NULL,
  `picked_up_at` datetime DEFAULT NULL,
  `received_at` datetime DEFAULT NULL,
  `inspection_status` varchar(50) DEFAULT NULL,
  `inspected_at` datetime DEFAULT NULL,
  `metadata` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`metadata`)),
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payment_logs`
--

CREATE TABLE `payment_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `event` varchar(150) NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`payload`)),
  `source` varchar(50) DEFAULT 'razorpay',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payment_logs`
--

INSERT INTO `payment_logs` (`id`, `event`, `payload`, `source`, `created_at`, `updated_at`) VALUES
(16, 'mock.order.created', '{\"razorpay_order_id\":\"order_691c5bb6da3d0\"}', 'razorpay', '2025-11-18 06:12:46', '2025-11-18 06:12:46'),
(17, 'mock.order.created', '{\"razorpay_order_id\":\"order_691d9cb18b2bc\"}', 'razorpay', '2025-11-19 05:02:17', '2025-11-19 05:02:17');

-- --------------------------------------------------------

--
-- Table structure for table `payouts`
--

CREATE TABLE `payouts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `seller_id` bigint(20) UNSIGNED NOT NULL COMMENT 'sellers.id',
  `order_id` bigint(20) DEFAULT NULL,
  `order_item_id` bigint(20) DEFAULT NULL,
  `initiated_by` bigint(20) UNSIGNED DEFAULT NULL COMMENT 'admin_users.id',
  `amount` decimal(14,2) NOT NULL,
  `commission_amount` decimal(10,2) DEFAULT NULL,
  `seller_amount` decimal(10,2) DEFAULT NULL,
  `settlement_type` enum('auto','manual') DEFAULT 'auto',
  `currency` varchar(10) NOT NULL DEFAULT 'INR',
  `status` enum('initiated','pending','processing','completed','failed','cancelled') NOT NULL DEFAULT 'initiated',
  `provider_payout_id` varchar(255) DEFAULT NULL,
  `razorpay_settlement_id` varchar(100) DEFAULT NULL,
  `provider_response` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`provider_response`)),
  `requested_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `processed_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `type` enum('module','option','action') NOT NULL DEFAULT 'action',
  `slug` varchar(100) NOT NULL,
  `group_name` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `type`, `slug`, `group_name`, `description`, `created_at`, `updated_at`) VALUES
(2, 'All Sellers', 'option', 'admin.sellers.index', 'Sellers', 'View and manage all sellers', '2025-11-03 19:37:40', '2025-11-03 19:37:40'),
(4, 'KYC / Compliance', 'option', 'admin.sellers.compliance', 'Sellers', 'Access KYC compliance section', '2025-11-03 19:37:40', '2025-11-06 01:58:20'),
(5, 'Payouts', 'option', 'admin.payouts.index', 'Sellers', 'View and manage payouts', '2025-11-03 19:37:40', '2025-11-06 01:58:20'),
(6, 'All Products', 'option', 'admin.products.index', 'Products', 'View and manage products', '2025-11-03 19:37:40', '2025-11-03 19:37:40'),
(7, 'Categories', 'option', 'admin.categories.index', 'Products', 'Manage product categories', '2025-11-03 19:37:40', '2025-11-03 19:37:40'),
(8, 'Brands', 'option', 'admin.brands.index', 'Products', 'Manage product brands', '2025-11-03 19:37:40', '2025-11-03 19:37:40'),
(9, 'Inventory', 'option', 'admin.inventory.index', 'Products', 'Manage product inventory', '2025-11-03 19:37:40', '2025-11-03 19:37:40'),
(10, 'All Orders', 'option', 'admin.orders.index', 'Orders', 'View and manage orders', '2025-11-03 19:37:40', '2025-11-03 19:37:40'),
(11, 'Returns', 'option', 'admin.returns.index', 'Orders', 'Handle product returns', '2025-11-03 19:37:40', '2025-11-03 19:37:40'),
(12, 'Cancellations', 'option', 'admin.cancellations.index', 'Orders', 'Handle order cancellations', '2025-11-03 19:37:40', '2025-11-03 19:37:40'),
(13, 'All Customers', 'option', 'admin.customers.index', 'Customers', 'Manage customer accounts', '2025-11-03 19:37:40', '2025-11-03 19:37:40'),
(14, 'Reviews', 'option', 'admin.reviews.index', 'Customers', 'View and moderate reviews', '2025-11-03 19:37:40', '2025-11-03 19:37:40'),
(15, 'Wishlists', 'option', 'admin.wishlists.index', 'Customers', 'View customer wishlists', '2025-11-03 19:37:40', '2025-11-03 19:37:40'),
(16, 'Banners', 'option', 'admin.website.banners', 'Website Content', 'Manage website banners', '2025-11-03 19:37:40', '2025-11-03 19:37:40'),
(17, 'Landing Pages', 'option', 'admin.website.pages', 'Website Content', 'Manage landing pages', '2025-11-03 19:37:40', '2025-11-03 19:37:40'),
(18, 'Blog Posts', 'option', 'admin.website.blogs.index', 'Website Content', 'Manage blog posts', '2025-11-03 19:37:40', '2025-11-04 01:35:44'),
(19, 'SEO Settings', 'option', 'admin.website.seo', 'Website Content', 'Manage SEO settings', '2025-11-03 19:37:40', '2025-11-03 19:37:40'),
(20, 'Seller Support', 'option', 'admin.support.seller', 'Support', 'Handle seller support', '2025-11-03 19:37:40', '2025-11-03 19:37:40'),
(21, 'Customer Support', 'option', 'admin.support.customer', 'Support', 'Handle customer support', '2025-11-03 19:37:40', '2025-11-03 19:37:40'),
(22, 'Tickets', 'option', 'admin.support.tickets.index', 'Support', 'Manage support tickets', '2025-11-03 19:37:40', '2025-11-04 01:35:44'),
(23, 'Sales Report', 'option', 'admin.reports.sales', 'Reports', 'View sales report', '2025-11-03 19:37:40', '2025-11-03 19:37:40'),
(24, 'Revenue Report', 'option', 'admin.reports.revenue', 'Reports', 'View revenue report', '2025-11-03 19:37:40', '2025-11-03 19:37:40'),
(25, 'Seller Performance', 'option', 'admin.reports.seller-performance', 'Reports', 'View seller performance', '2025-11-03 19:37:40', '2025-11-03 19:37:40'),
(26, 'Customer Insights', 'option', 'admin.reports.customer-insights', 'Reports', 'View customer insights', '2025-11-03 19:37:40', '2025-11-03 19:37:40'),
(27, 'General Settings', 'option', 'admin.settings.general', 'Settings', 'Manage general settings', '2025-11-03 19:37:40', '2025-11-03 19:37:40'),
(28, 'Payment Gateways', 'option', 'admin.settings.payments', 'Settings', 'Manage payment gateways', '2025-11-03 19:37:40', '2025-11-03 19:37:40'),
(29, 'Shipping', 'option', 'admin.settings.shipping', 'Settings', 'Manage shipping options', '2025-11-03 19:37:40', '2025-11-03 19:37:40'),
(30, 'Roles & Permissions', 'option', 'admin.roles.index', 'Settings', 'Manage roles and permissions', '2025-11-03 19:37:40', '2025-11-03 19:37:40'),
(35, 'Add Seller', 'action', 'admin.sellers.create', 'Sellers', 'Create new seller', '2025-11-05 20:32:38', '2025-11-05 20:32:38'),
(36, 'View Seller', 'action', 'admin.sellers.show', 'Sellers', 'View seller details', '2025-11-05 20:32:38', '2025-11-06 01:48:07'),
(37, 'Edit Seller', 'action', 'admin.sellers.edit', 'Sellers', 'Edit seller info', '2025-11-05 20:32:38', '2025-11-05 20:32:38'),
(38, 'Delete Seller', 'action', 'admin.sellers.delete', 'Sellers', 'Delete seller', '2025-11-05 20:32:38', '2025-11-05 20:32:38'),
(39, 'View KYC Docs', 'action', 'admin.sellers.kyc.view', 'Sellers', 'View seller KYC documents', '2025-11-05 20:32:38', '2025-11-06 01:58:20'),
(40, 'Verify KYC', 'action', 'admin.sellers.kyc.verify', 'Sellers', 'Verify seller KYC details', '2025-11-05 20:32:38', '2025-11-06 01:58:20'),
(41, 'Reject KYC', 'action', 'admin.sellers.kyc.reject', 'Sellers', 'Reject seller KYC application', '2025-11-05 20:32:38', '2025-11-06 01:58:20'),
(42, 'Initiate Payout', 'action', 'admin.payouts.create', 'Sellers', 'Create a new payout', '2025-11-05 20:32:38', '2025-11-06 01:58:20'),
(43, 'Edit Payout', 'action', 'admin.payouts.edit', 'Sellers', 'Edit payout details', '2025-11-05 20:32:38', '2025-11-06 01:58:20'),
(44, 'Delete Payout', 'action', 'admin.payouts.delete', 'Sellers', 'Delete payout record', '2025-11-05 20:32:38', '2025-11-06 01:58:20'),
(45, 'Add Product', 'action', 'admin.products.create', 'Products', 'Create new product', '2025-11-05 20:32:38', '2025-11-05 20:32:38'),
(46, 'Delete Selected Products', 'action', 'admin.products.bulk_delete', 'Products', 'Bulk delete products', '2025-11-05 20:32:38', '2025-11-05 20:32:38'),
(47, 'Feature Selected Products', 'action', 'admin.products.bulk_feature', 'Products', 'Bulk feature products', '2025-11-05 20:32:38', '2025-11-05 20:32:38'),
(48, 'Approve Selected Products', 'action', 'admin.products.bulk_approve', 'Products', 'Bulk approve products', '2025-11-05 20:32:38', '2025-11-05 20:32:38'),
(49, 'Edit Product', 'action', 'admin.products.edit', 'Products', 'Edit a product', '2025-11-05 20:32:38', '2025-11-05 20:32:38'),
(50, 'View Product', 'action', 'admin.products.view', 'Products', 'View product details', '2025-11-05 20:32:38', '2025-11-05 20:32:38'),
(51, 'Approve Product', 'action', 'admin.products.approve', 'Products', 'Approve individual product', '2025-11-05 20:32:38', '2025-11-05 20:32:38'),
(52, 'Feature Product', 'action', 'admin.products.feature', 'Products', 'Feature individual product', '2025-11-05 20:32:38', '2025-11-05 20:32:38'),
(53, 'Delete Product', 'action', 'admin.products.delete', 'Products', 'Delete individual product', '2025-11-05 20:32:38', '2025-11-05 20:32:38'),
(54, 'Add Customer', 'action', 'admin.customers.create', 'Customers', 'Create new customer', '2025-11-06 18:15:28', '2025-11-06 18:15:28'),
(55, 'Bulk Delete', 'action', 'admin.customers.deleteselected', 'Customers', 'bulk delete customers', '2025-11-06 18:18:33', '2025-11-06 18:18:33'),
(56, 'Edit Customer', 'action', 'admin.customers.edit', 'Customers', 'edit customer', '2025-11-06 18:23:15', '2025-11-06 18:23:15'),
(57, 'View Customer', 'action', 'admin.customers.show', 'Customers', 'see customer', '2025-11-06 18:43:24', '2025-11-06 18:43:24'),
(58, 'Toggle Customer', 'action', 'admin.customers.toggle', 'Customers', 'active or inactive customer', '2025-11-06 18:54:01', '2025-11-06 18:54:01'),
(59, 'Bulk Delete', 'action', 'admin.reviews.deleteselected', 'Customers', 'bulk delete reviews', '2025-11-08 17:57:05', '2025-11-08 17:59:44'),
(60, 'Add Reviews', 'action', 'admin.reviews..create', 'Customers', 'custom create reviews', '2025-11-08 18:38:54', '2025-11-08 18:38:54'),
(61, 'Filter Reviews', 'action', 'admin.reviews.filter', 'Customers', 'filter customer\'s reviews', '2025-11-08 19:19:27', '2025-11-08 19:19:27'),
(62, 'Show Review', 'action', 'admin.reviews.show', 'Customers', 'show customer\'s review', '2025-11-08 19:21:15', '2025-11-08 19:21:15'),
(63, 'Filter Wishlists', 'action', 'admin.wishlists.filter', 'Customers', 'filter customers wishlists', '2025-11-08 21:26:47', '2025-11-08 21:26:47'),
(64, 'Show Wishlists', 'action', 'admin.wishlists.show', 'Customers', 'show customers wishlists', '2025-11-08 21:31:35', '2025-11-08 21:31:35'),
(65, 'Delete Wishlists', 'action', 'admin.wishlists.delete', 'Customers', 'delete customers wishlists', '2025-11-08 21:31:35', '2025-11-08 21:31:35'),
(66, 'Edit Order', 'action', 'admin.orders.edit', 'Orders', 'edit customers orders', '2025-11-09 00:30:37', '2025-11-09 00:30:37'),
(67, 'Delete Order', 'action', 'admin.orders.delete', 'Orders', 'delete customers orders', '2025-11-09 00:30:37', '2025-11-09 00:30:37'),
(68, 'Refund Process', 'action', 'admin.orders.refund', 'Orders', 'customers refund process', '2025-11-09 00:39:23', '2025-11-09 00:39:23'),
(69, 'Print Invoice', 'action', 'admin.orders.printInvoice', 'Orders', 'print orders invoice', '2025-11-09 00:39:23', '2025-11-09 00:48:34'),
(70, 'Send Mail', 'action', 'admin.orders.sendmail', 'Orders', 'send mail to customer', '2025-11-09 00:46:44', '2025-11-09 00:48:22'),
(71, 'Cancel Order', 'action', 'admin.orders.cancel', 'Orders', 'cancel order', '2025-11-09 00:46:44', '2025-11-09 00:46:44'),
(72, 'Cancellation Approval', 'action', 'admin.cancellations.approval', 'Orders', 'cancellation approval', '2025-11-09 01:00:59', '2025-11-09 01:00:59'),
(73, 'Return Process', 'action', 'admin.returns.process', 'Orders', 'return process', '2025-11-09 01:11:30', '2025-11-09 01:11:30'),
(74, 'Delete Return', 'action', 'admin.returns.delete', 'Orders', 'delete return request', '2025-11-09 01:11:30', '2025-11-09 01:11:30'),
(75, 'Create Return', 'action', 'admin.returns.create', 'Orders', 'create new return', '2025-11-09 01:13:39', '2025-11-09 01:13:39'),
(76, 'Create Order', 'action', 'admin.orders.create', 'Orders', 'create order', '2025-11-14 03:34:09', '2025-11-14 03:34:09');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_code` varchar(100) NOT NULL,
  `product_categories_id` bigint(20) UNSIGNED NOT NULL,
  `product_sub_categories_id` bigint(20) UNSIGNED NOT NULL,
  `seller_id` bigint(20) UNSIGNED NOT NULL,
  `bulk_batch_id` bigint(20) UNSIGNED DEFAULT NULL,
  `brand_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `auto_sku` tinyint(1) NOT NULL DEFAULT 0,
  `sku` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `youtube_url` varchar(255) DEFAULT NULL,
  `cancellation_policy` longtext DEFAULT NULL,
  `short_description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL DEFAULT 0.00,
  `discount_price` decimal(10,2) DEFAULT NULL,
  `commission_percent` decimal(5,2) DEFAULT NULL,
  `stock` int(11) NOT NULL DEFAULT 0,
  `is_approved` tinyint(1) NOT NULL DEFAULT 0 COMMENT '1=Approved, 0=Pending',
  `approved_by` bigint(20) UNSIGNED DEFAULT NULL,
  `approved_at` datetime DEFAULT NULL,
  `featured` tinyint(1) NOT NULL DEFAULT 0,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `image_upload_status` enum('pending','in_progress','completed','skipped') NOT NULL DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `product_code`, `product_categories_id`, `product_sub_categories_id`, `seller_id`, `bulk_batch_id`, `brand_id`, `name`, `slug`, `auto_sku`, `sku`, `description`, `youtube_url`, `cancellation_policy`, `short_description`, `price`, `discount_price`, `commission_percent`, `stock`, `is_approved`, `approved_by`, `approved_at`, `featured`, `status`, `created_at`, `updated_at`, `image_upload_status`) VALUES
(251, 'MATWEAR01', 10, 67, 15, 5, 8, 'Maternity Floral Dress', 'maternity-floral-dress-6a2fa18030b12', 0, 'PSKU-8MSZECOQ', 'Comfortable floral maternity dress with adjustable waist, ideal for all trimesters.', NULL, NULL, NULL, 599.00, NULL, NULL, 50, 0, NULL, NULL, 0, 1, '2026-06-15 06:53:52', '2026-06-15 07:02:48', 'completed'),
(252, 'MATWEAR02', 10, 67, 15, 5, 8, 'Maternity Denim Jeans', 'maternity-denim-jeans-6a2fa18033595', 0, 'PSKU-PMXREIM8', 'Stretchy denim jeans designed for comfort during pregnancy with elasticated waistband.', NULL, NULL, NULL, 899.00, NULL, NULL, 40, 0, NULL, NULL, 0, 1, '2026-06-15 06:53:52', '2026-06-15 07:02:48', 'completed'),
(253, 'MATWEAR03', 10, 67, 15, 5, 8, 'Maternity Nursing Kurti', 'maternity-nursing-kurti-6a2fa1803577c', 0, 'PSKU-BL2HH45B', 'Soft cotton kurti with hidden zip for easy nursing and stylish everyday wear.', NULL, NULL, NULL, 699.00, NULL, NULL, 60, 0, NULL, NULL, 0, 1, '2026-06-15 06:53:52', '2026-06-15 07:02:48', 'completed'),
(254, 'MATWEAR04', 10, 67, 15, 5, 8, 'Maternity Leggings', 'maternity-leggings-6a2fa180366bf', 0, 'PSKU-FC1D8VA8', 'Full-length maternity leggings with belly support panel for all-day comfort.', NULL, NULL, NULL, 449.00, NULL, NULL, 80, 0, NULL, NULL, 0, 1, '2026-06-15 06:53:52', '2026-06-15 07:02:48', 'completed'),
(255, 'MATWEAR05', 10, 67, 15, 5, 8, 'Maternity Maxi Dress', 'maternity-maxi-dress-6a2fa18037704', 0, 'PSKU-QEFHJYJL', 'Breathable maxi dress perfect for maternity photoshoots and daily wear.', NULL, NULL, NULL, 799.00, NULL, NULL, 35, 0, NULL, NULL, 0, 1, '2026-06-15 06:53:52', '2026-06-15 07:02:48', 'completed'),
(256, 'MATWEAR06', 10, 67, 15, 5, 8, 'Maternity Yoga Pants', 'maternity-yoga-pants-6a2fa180386f2', 0, 'PSKU-8PLXKRJE', 'Flexible yoga pants designed for prenatal yoga and light exercise.', NULL, NULL, NULL, 549.00, NULL, NULL, 45, 0, NULL, NULL, 0, 1, '2026-06-15 06:53:52', '2026-06-15 07:02:48', 'completed'),
(257, 'MATWEAR07', 10, 67, 15, 5, 8, 'Maternity Wrap Dress', 'maternity-wrap-dress-6a2fa180393a7', 0, 'PSKU-BCXTAPDR', 'Elegant wrap dress suitable for office and outings during pregnancy.', NULL, NULL, NULL, 999.00, NULL, NULL, 30, 0, NULL, NULL, 0, 1, '2026-06-15 06:53:52', '2026-06-15 07:02:49', 'completed'),
(258, 'MATWEAR08', 10, 67, 15, 5, 8, 'Maternity Night Dress', 'maternity-night-dress-6a2fa1803a338', 0, 'PSKU-MYUGMYUZ', 'Soft, breathable night dress for comfortable sleep during pregnancy.', NULL, NULL, NULL, 399.00, NULL, NULL, 70, 0, NULL, NULL, 0, 1, '2026-06-15 06:53:52', '2026-06-15 07:02:49', 'completed'),
(259, 'MATWEAR09', 10, 67, 15, 5, 8, 'Maternity Formal Blouse', 'maternity-formal-blouse-6a2fa1803afab', 0, 'PSKU-2ATLRWLT', 'Professional maternity blouse suitable for work throughout pregnancy.', NULL, NULL, NULL, 749.00, NULL, NULL, 25, 0, NULL, NULL, 0, 1, '2026-06-15 06:53:52', '2026-06-15 07:02:49', 'completed'),
(260, 'MATWEAR10', 10, 67, 15, 5, 8, 'Maternity Sweatshirt', 'maternity-sweatshirt-6a2fa1803bb80', 0, 'PSKU-JJWPMW25', 'Cozy maternity sweatshirt with front zip for easy nursing post-delivery.', NULL, NULL, NULL, 649.00, NULL, NULL, 55, 0, NULL, NULL, 0, 1, '2026-06-15 06:53:52', '2026-06-15 07:02:49', 'completed'),
(261, 'NURSEBRA01', 10, 68, 15, 5, 8, 'Wireless Nursing Bra', 'wireless-nursing-bra-6a2fa1803c614', 0, 'PSKU-1PASJVUC', 'Ultra-soft wireless nursing bra with easy-open clip for comfortable feeding.', NULL, NULL, NULL, 349.00, NULL, NULL, 90, 0, NULL, NULL, 0, 1, '2026-06-15 06:53:52', '2026-06-15 07:02:49', 'completed'),
(262, 'NURSEBRA02', 10, 68, 15, 5, 8, 'Padded Nursing Bra', 'padded-nursing-bra-6a2fa1803d0fc', 0, 'PSKU-IF9HLM4N', 'Lightly padded nursing bra with removable pads and adjustable straps.', NULL, NULL, NULL, 449.00, NULL, NULL, 75, 0, NULL, NULL, 0, 1, '2026-06-15 06:53:52', '2026-06-15 07:02:49', 'completed'),
(263, 'NURSEBRA03', 10, 68, 15, 5, 8, 'Sports Nursing Bra', 'sports-nursing-bra-6a2fa1803dec4', 0, 'PSKU-LT4HCSP2', 'High-support sports nursing bra ideal for active new moms.', NULL, NULL, NULL, 499.00, NULL, NULL, 60, 0, NULL, NULL, 0, 1, '2026-06-15 06:53:52', '2026-06-15 07:02:49', 'completed'),
(264, 'NURSEBRA04', 10, 68, 15, 5, 8, 'T-Shirt Nursing Bra', 't-shirt-nursing-bra-6a2fa1803ed11', 0, 'PSKU-EZXVUNUK', 'Seamless T-shirt nursing bra for everyday invisible comfort.', NULL, NULL, NULL, 399.00, NULL, NULL, 80, 0, NULL, NULL, 0, 1, '2026-06-15 06:53:52', '2026-06-15 07:02:49', 'completed'),
(265, 'NURSEBRA05', 10, 68, 15, 5, 8, 'Lace Nursing Bra', 'lace-nursing-bra-6a2fa1803f962', 0, 'PSKU-LEG6T9TP', 'Elegant lace nursing bra balancing style and functionality.', NULL, NULL, NULL, 549.00, NULL, NULL, 50, 0, NULL, NULL, 0, 1, '2026-06-15 06:53:52', '2026-06-15 07:02:49', 'completed'),
(266, 'NURSEBRA06', 10, 68, 15, 5, 8, 'Full Coverage Nursing Bra', 'full-coverage-nursing-bra-6a2fa180403da', 0, 'PSKU-39JNLIGV', 'Full-coverage nursing bra providing maximum support for larger sizes.', NULL, NULL, NULL, 599.00, NULL, NULL, 45, 0, NULL, NULL, 0, 1, '2026-06-15 06:53:52', '2026-06-15 07:02:49', 'completed'),
(267, 'NURSEBRA07', 10, 68, 15, 5, 8, 'Sleep Nursing Bra', 'sleep-nursing-bra-6a2fa18040deb', 0, 'PSKU-RANTMAVN', 'Lightweight sleep nursing bra for comfortable nighttime feeding.', NULL, NULL, NULL, 299.00, NULL, NULL, 100, 0, NULL, NULL, 0, 1, '2026-06-15 06:53:52', '2026-06-15 07:02:49', 'completed'),
(268, 'NURSEBRA08', 10, 68, 15, 5, 8, 'Front Closure Nursing Bra', 'front-closure-nursing-bra-6a2fa18041940', 0, 'PSKU-KFZBTNXE', 'Convenient front-closure nursing bra for quick, easy access.', NULL, NULL, NULL, 479.00, NULL, NULL, 65, 0, NULL, NULL, 0, 1, '2026-06-15 06:53:52', '2026-06-15 07:02:49', 'completed'),
(269, 'PREGPILLOW01', 10, 69, 15, 5, 8, 'U-Shape Pregnancy Pillow', 'u-shape-pregnancy-pillow-6a2fa18042c37', 0, 'PSKU-18V0YXNP', 'Full-body U-shape pregnancy pillow offering complete support for back, belly and hips.', NULL, NULL, NULL, 1499.00, NULL, NULL, 30, 0, NULL, NULL, 0, 1, '2026-06-15 06:53:52', '2026-06-15 07:02:49', 'completed'),
(270, 'PREGPILLOW02', 10, 69, 15, 5, 8, 'C-Shape Pregnancy Pillow', 'c-shape-pregnancy-pillow-6a2fa18043912', 0, 'PSKU-CYVLPGVA', 'Ergonomic C-shape pillow supporting bump and back for restful sleep.', NULL, NULL, NULL, 1299.00, NULL, NULL, 35, 0, NULL, NULL, 0, 1, '2026-06-15 06:53:52', '2026-06-15 07:02:49', 'completed'),
(271, 'PREGPILLOW03', 10, 69, 15, 5, 8, 'Wedge Pregnancy Pillow', 'wedge-pregnancy-pillow-6a2fa1804438b', 0, 'PSKU-O8JK6X1Y', 'Compact wedge pillow targeting belly and back support while sleeping.', NULL, NULL, NULL, 699.00, NULL, NULL, 50, 0, NULL, NULL, 0, 1, '2026-06-15 06:53:52', '2026-06-15 07:02:49', 'completed'),
(272, 'PREGPILLOW04', 10, 69, 15, 5, 8, 'Total Body Pregnancy Pillow', 'total-body-pregnancy-pillow-6a2fa18044eb5', 0, 'PSKU-WQ7M8GKD', 'Extra-long total body pillow for full-length support during pregnancy.', NULL, NULL, NULL, 1699.00, NULL, NULL, 20, 0, NULL, NULL, 0, 1, '2026-06-15 06:53:52', '2026-06-15 07:02:49', 'completed'),
(273, 'PREGPILLOW05', 10, 69, 15, 5, 8, 'Memory Foam Maternity Pillow', 'memory-foam-maternity-pillow-6a2fa18045c62', 0, 'PSKU-T4Y5ER8O', 'Memory foam pregnancy pillow that conforms to body shape for personalized support.', NULL, NULL, NULL, 1899.00, NULL, NULL, 25, 0, NULL, NULL, 0, 1, '2026-06-15 06:53:52', '2026-06-15 07:02:49', 'completed'),
(274, 'SKINCARE01', 10, 70, 15, 5, 8, 'Stretch Mark Cream', 'stretch-mark-cream-6a2fa18046cf3', 0, 'PSKU-VM91UZYM', 'Nourishing cream with shea butter and vitamin E to reduce stretch marks.', NULL, NULL, NULL, 599.00, NULL, NULL, 60, 0, NULL, NULL, 0, 1, '2026-06-15 06:53:52', '2026-06-15 07:02:49', 'completed'),
(275, 'SKINCARE02', 10, 70, 15, 5, 8, 'Belly Butter', 'belly-butter-6a2fa18047973', 0, 'PSKU-NQSGIHDF', 'Rich belly butter moisturizer keeping skin elastic and hydrated during pregnancy.', NULL, NULL, NULL, 499.00, NULL, NULL, 70, 0, NULL, NULL, 0, 1, '2026-06-15 06:53:52', '2026-06-15 07:02:49', 'completed'),
(276, 'SKINCARE03', 10, 70, 15, 5, 8, 'Pregnancy Safe Sunscreen', 'pregnancy-safe-sunscreen-6a2fa18048b10', 0, 'PSKU-YKNZ8X7X', 'Mineral-based SPF 50 sunscreen safe for use during pregnancy and breastfeeding.', NULL, NULL, NULL, 699.00, NULL, NULL, 55, 0, NULL, NULL, 0, 1, '2026-06-15 06:53:52', '2026-06-15 07:02:50', 'completed'),
(277, 'SKINCARE04', 10, 70, 15, 5, 8, 'Maternity Lip Balm', 'maternity-lip-balm-6a2fa1804a62c', 0, 'PSKU-TLREIL7I', 'Chemical-free, hydrating lip balm formulated safe for expectant mothers.', NULL, NULL, NULL, 199.00, NULL, NULL, 120, 0, NULL, NULL, 0, 1, '2026-06-15 06:53:52', '2026-06-15 07:02:50', 'completed'),
(278, 'SKINCARE05', 10, 70, 15, 5, 8, 'Pregnancy Glow Serum', 'pregnancy-glow-serum-6a2fa1804ba02', 0, 'PSKU-7XL0I58L', 'Hydrating serum with hyaluronic acid for radiant skin during pregnancy.', NULL, NULL, NULL, 899.00, NULL, NULL, 40, 0, NULL, NULL, 0, 1, '2026-06-15 06:53:52', '2026-06-15 07:02:50', 'completed'),
(279, 'SKINCARE06', 10, 70, 15, 5, 8, 'Nipple Cream', 'nipple-cream-6a2fa1804d0f5', 0, 'PSKU-PSUKKXAN', 'Lanolin-free nipple cream for soothing soreness during breastfeeding.', NULL, NULL, NULL, 349.00, NULL, NULL, 80, 0, NULL, NULL, 0, 1, '2026-06-15 06:53:52', '2026-06-15 07:02:50', 'completed'),
(280, 'SKINCARE07', 10, 70, 15, 5, 8, 'Maternity Body Oil', 'maternity-body-oil-6a2fa1804e754', 0, 'PSKU-MU8BIUXI', 'Lightweight body oil with rosehip and almond oil to maintain skin elasticity.', NULL, NULL, NULL, 799.00, NULL, NULL, 45, 0, NULL, NULL, 0, 1, '2026-06-15 06:53:52', '2026-06-15 07:02:50', 'completed'),
(281, 'SKINCARE08', 10, 70, 15, 5, 8, 'Pregnancy Safe Face Wash', 'pregnancy-safe-face-wash-6a2fa1804f6e4', 0, 'PSKU-3SS0XRLF', 'Gentle, fragrance-free face wash safe for sensitive skin during pregnancy.', NULL, NULL, NULL, 449.00, NULL, NULL, 65, 0, NULL, NULL, 0, 1, '2026-06-15 06:53:52', '2026-06-15 07:02:50', 'completed'),
(282, 'BABYROMPER01', 5, 476, 15, 5, 8, 'Baby Romper', 'baby-romper-6a2fa180503fe', 0, 'PSKU-ZTAZPXON', 'Blue Baby Romper in size 0-3M, perfect for semi casual wear.', NULL, NULL, NULL, 260.03, NULL, NULL, 823, 0, NULL, NULL, 0, 1, '2026-06-15 06:53:52', '2026-06-15 07:02:50', 'completed'),
(283, 'KIDST-SHIR02', 5, 476, 15, 5, 8, 'Kids T-Shirt', 'kids-t-shirt-6a2fa1805da07', 0, 'PSKU-WTUEFMZS', 'Red Kids T-Shirt in size 3-5Y, perfect for party wear.', NULL, NULL, NULL, 412.32, NULL, NULL, 1122, 1, NULL, NULL, 0, 1, '2026-06-15 06:53:52', '2026-06-30 09:31:36', 'completed'),
(284, 'GIRLSFROCK03', 5, 477, 15, 5, 8, 'Girls Frock', 'girls-frock-6a2fa1806a393', 0, 'PSKU-6AT8O8QR', 'Pink Girls Frock in size 1-2Y, perfect for party wear.', NULL, NULL, NULL, 573.10, NULL, NULL, 1311, 0, NULL, NULL, 0, 1, '2026-06-15 06:53:52', '2026-06-15 07:02:50', 'completed'),
(285, 'BABYNIGHTS04', 5, 480, 15, 5, 8, 'Baby Nightsuit', 'baby-nightsuit-6a2fa180723f7', 0, 'PSKU-TLRCKIMC', 'White Baby Nightsuit in size 0-3M, perfect for semi casual wear.', NULL, NULL, NULL, 766.24, NULL, NULL, 856, 0, NULL, NULL, 0, 1, '2026-06-15 06:53:52', '2026-06-15 07:02:50', 'completed'),
(286, 'KIDSSNEAKE05', 5, 483, 15, 5, 8, 'Kids Sneakers', 'kids-sneakers-6a2fa180774b1', 0, 'PSKU-YGB0RYZP', 'Blue Kids Sneakers in size 3-5Y, perfect for semi casual wear.', NULL, NULL, NULL, 550.54, NULL, NULL, 851, 0, NULL, NULL, 0, 1, '2026-06-15 06:53:52', '2026-06-15 07:02:50', 'completed'),
(287, 'GIRLSLEDSH06', 5, 488, 15, 5, 8, 'Girls Led Shoes', 'girls-led-shoes-6a2fa1807e63f', 0, 'PSKU-CSBBVWLT', 'Pink Girls Led Shoes in size 3-5Y, perfect for party wear.', NULL, NULL, NULL, 456.30, NULL, NULL, 579, 0, NULL, NULL, 0, 1, '2026-06-15 06:53:52', '2026-06-15 07:02:50', 'completed'),
(288, 'TODDLERSAN07', 5, 486, 15, 5, 8, 'Toddler Sandals', 'toddler-sandals-6a2fa18083d08', 0, 'PSKU-GVLAKQCE', 'Red Toddler Sandals in size 0-3M, perfect for semi casual wear.', NULL, NULL, NULL, 749.74, NULL, NULL, 486, 0, NULL, NULL, 0, 1, '2026-06-15 06:53:52', '2026-06-15 07:02:51', 'completed'),
(289, 'KIDSFORMAL08', 5, 476, 15, 5, 8, 'Kids Formal Shirt', 'kids-formal-shirt-6a2fa1808817b', 0, 'PSKU-QTVLV5RV', 'White Kids Formal Shirt in size 3-5Y, perfect for formal wear.', NULL, NULL, NULL, 362.28, NULL, NULL, 1127, 0, NULL, NULL, 0, 1, '2026-06-15 06:53:52', '2026-06-15 07:02:51', 'completed'),
(290, 'GIRLSTOPSE09', 5, 478, 15, 5, 8, 'Girls Top Set', 'girls-top-set-6a2fa1808d9fa', 0, 'PSKU-TMWSKP0B', 'Pink Girls Top Set in size 1-2Y, perfect for semi casual wear.', NULL, NULL, NULL, 338.41, NULL, NULL, 1342, 0, NULL, NULL, 0, 1, '2026-06-15 06:53:52', '2026-06-15 07:02:51', 'completed'),
(291, 'BOYSSUITSE10', 5, 487, 15, 5, 8, 'Boys Suit Set', 'boys-suit-set-6a2fa180956bb', 0, 'PSKU-C19TEVIF', 'Black Boys Suit Set in size 3-5Y, perfect for formal wear.', NULL, NULL, NULL, 315.35, NULL, NULL, 720, 0, NULL, NULL, 0, 1, '2026-06-15 06:53:52', '2026-06-15 07:02:51', 'completed'),
(292, 'BABYSLEEPS11', 5, 480, 15, 5, 8, 'Baby Sleepsuit', 'baby-sleepsuit-6a2fa1809a796', 0, 'PSKU-KRIV4ZEG', 'White Baby Sleepsuit in size 0-3M, perfect for semi casual wear.', NULL, NULL, NULL, 561.10, NULL, NULL, 999, 0, NULL, NULL, 0, 1, '2026-06-15 06:53:52', '2026-06-15 07:02:51', 'completed'),
(293, 'GIRLSETHNI12', 5, 477, 15, 5, 8, 'Girls Ethnic Dress', 'girls-ethnic-dress-6a2fa180a1845', 0, 'PSKU-U0NXHM8W', 'Red Girls Ethnic Dress in size 1-2Y, perfect for ethinic wear.', NULL, NULL, NULL, 355.31, NULL, NULL, 931, 0, NULL, NULL, 0, 1, '2026-06-15 06:53:52', '2026-06-15 07:02:51', 'completed'),
(294, 'KIDSCASUAL13', 5, 476, 15, 5, 8, 'Kids Casual Tee', 'kids-casual-tee-6a2fa180a8b45', 0, 'PSKU-XWIXVW2S', 'Green Kids Casual Tee in size 3-5Y, perfect for semi casual wear.', NULL, NULL, NULL, 216.99, NULL, NULL, 1415, 0, NULL, NULL, 0, 1, '2026-06-15 06:53:52', '2026-06-15 07:02:51', 'completed'),
(295, 'BOYSSPORTS14', 5, 483, 15, 5, 8, 'Boys Sports Shoes', 'boys-sports-shoes-6a2fa180b2aac', 0, 'PSKU-6ZTJLBMG', 'Black Boys Sports Shoes in size 3-5Y, perfect for semi casual wear.', NULL, NULL, NULL, 295.21, NULL, NULL, 1139, 0, NULL, NULL, 0, 1, '2026-06-15 06:53:52', '2026-06-15 07:02:51', 'completed'),
(296, 'BABYFOOTIE15', 5, 486, 15, 5, 8, 'Baby Footie', 'baby-footie-6a2fa180b9188', 0, 'PSKU-CPCNHPKL', 'White Baby Footie in size 0-3M, perfect for semi casual wear.', NULL, NULL, NULL, 256.01, NULL, NULL, 625, 0, NULL, NULL, 0, 1, '2026-06-15 06:53:52', '2026-06-15 07:02:52', 'completed'),
(297, 'GIRLSBALLE16', 5, 486, 15, 5, 8, 'Girls Ballet Flats', 'girls-ballet-flats-6a2fa180bc933', 0, 'PSKU-IX0FGZ0A', 'Pink Girls Ballet Flats in size 3-5Y, perfect for party wear.', NULL, NULL, NULL, 253.43, NULL, NULL, 1103, 0, NULL, NULL, 0, 1, '2026-06-15 06:53:52', '2026-06-15 07:02:52', 'completed'),
(298, 'BOYSNIGHTP17', 5, 480, 15, 5, 8, 'Boys Night Pyjama', 'boys-night-pyjama-6a2fa180c2b93', 0, 'PSKU-3OQU4D5A', 'Blue Boys Night Pyjama in size 3-5Y, perfect for semi casual wear.', NULL, NULL, NULL, 202.89, NULL, NULL, 1296, 0, NULL, NULL, 0, 1, '2026-06-15 06:53:52', '2026-06-15 07:02:52', 'completed'),
(299, 'ETHNICKURT18', 5, 487, 15, 5, 8, 'Ethnic Kurta Set', 'ethnic-kurta-set-6a2fa180c77a1', 0, 'PSKU-57U22JTC', 'Orange Ethnic Kurta Set in size 3-5Y, perfect for ethinic wear.', NULL, NULL, NULL, 491.76, NULL, NULL, 1591, 0, NULL, NULL, 0, 1, '2026-06-15 06:53:52', '2026-06-15 07:02:52', 'completed'),
(300, 'GIRLSCASUA19', 5, 477, 15, 5, 8, 'Girls Casual Frock', 'girls-casual-frock-6a2fa180cd9b5', 0, 'PSKU-G8RBFD6K', 'Blue Girls Casual Frock in size 1-2Y, perfect for semi casual wear.', NULL, NULL, NULL, 255.18, NULL, NULL, 911, 0, NULL, NULL, 0, 1, '2026-06-15 06:53:52', '2026-06-15 07:02:52', 'completed'),
(301, 'TODDLERTOP20', 5, 478, 15, 5, 8, 'Toddler Top Set', 'toddler-top-set-6a2fa180d20eb', 0, 'PSKU-F3JHDWHH', 'Yellow Toddler Top Set in size 0-3M, perfect for semi casual wear.', NULL, NULL, NULL, 505.68, NULL, NULL, 1424, 0, NULL, NULL, 0, 1, '2026-06-15 06:53:52', '2026-06-15 07:02:52', 'completed'),
(302, 'KIDSFORMAL21', 5, 483, 15, 5, 8, 'Kids Formal Shoes', 'kids-formal-shoes-6a2fa180d89ae', 0, 'PSKU-ICOOUEXC', 'Black Kids Formal Shoes in size 3-5Y, perfect for formal wear.', NULL, NULL, NULL, 377.21, NULL, NULL, 739, 0, NULL, NULL, 0, 1, '2026-06-15 06:53:52', '2026-06-15 07:02:52', 'completed'),
(303, 'GIRLSPARTY22', 5, 477, 15, 5, 8, 'Girls Party Dress', 'girls-party-dress-6a2fa180dcffc', 0, 'PSKU-SGAMDKXV', 'Red Girls Party Dress in size 1-2Y, perfect for party wear.', NULL, NULL, NULL, 243.92, NULL, NULL, 1857, 0, NULL, NULL, 0, 1, '2026-06-15 06:53:52', '2026-06-15 07:02:53', 'completed'),
(304, 'BOYSCASUAL23', 5, 487, 15, 5, 8, 'Boys Casual Jeans Set', 'boys-casual-jeans-set-6a2fa180e6fee', 0, 'PSKU-2M5IYUOR', 'Blue Boys Casual Jeans Set in size 3-5Y, perfect for semi casual wear.', NULL, NULL, NULL, 291.59, NULL, NULL, 478, 0, NULL, NULL, 0, 1, '2026-06-15 06:53:52', '2026-06-15 07:02:53', 'completed'),
(305, 'BABYBOOTIE24', 5, 486, 15, 5, 8, 'Baby Booties', 'baby-booties-6a2fa180ec339', 0, 'PSKU-FSGWC4HG', 'Pink Baby Booties in size 0-3M, perfect for semi casual wear.', NULL, NULL, NULL, 433.37, NULL, NULL, 884, 0, NULL, NULL, 0, 1, '2026-06-15 06:53:52', '2026-06-15 07:02:53', 'completed'),
(306, 'KIDSRAINCO25', 5, 478, 15, 5, 8, 'Kids Raincoat Jacket', 'kids-raincoat-jacket-6a2fa180f20fc', 0, 'PSKU-UOVHJGES', 'Yellow Kids Raincoat Jacket in size 1-2Y, perfect for semi casual wear.', NULL, NULL, NULL, 550.88, NULL, NULL, 1726, 1, NULL, NULL, 0, 1, '2026-06-15 06:53:52', '2026-07-01 10:33:03', 'completed'),
(308, 'EDUTOY02', 11, 183, 15, 5, 8, 'Number Learning Abacus', 'number-learning-abacus-6a2fa1810ab4f', 0, 'PSKU-4FI0MT2I', 'Colorful abacus teaching counting and basic math to kids aged 2-6.', NULL, NULL, NULL, 399.00, NULL, NULL, 75, 0, NULL, NULL, 0, 1, '2026-06-15 06:53:53', '2026-06-15 07:02:53', 'completed'),
(309, 'EDUTOY03', 11, 183, 15, 5, 8, 'Shape Sorter Cube', 'shape-sorter-cube-6a2fa1810b896', 0, 'PSKU-8XIIQ718', 'Chunky shape sorter cube for toddlers developing problem-solving skills.', NULL, NULL, NULL, 349.00, NULL, NULL, 80, 0, NULL, NULL, 0, 1, '2026-06-15 06:53:53', '2026-06-15 07:02:53', 'completed'),
(310, 'EDUTOY04', 11, 183, 15, 5, 8, 'Magnetic Drawing Board', 'magnetic-drawing-board-6a2fa1810c5ed', 0, 'PSKU-JEEJGTAZ', 'Mess-free magnetic drawing board for creative writing and drawing practice.', NULL, NULL, NULL, 599.00, NULL, NULL, 55, 0, NULL, NULL, 0, 1, '2026-06-15 06:53:53', '2026-06-15 07:02:53', 'completed'),
(311, 'EDUTOY05', 11, 183, 15, 5, 8, 'Science Experiment Kit', 'science-experiment-kit-6a2fa1810d717', 0, 'PSKU-1Z2GM0XT', 'Beginner science kit with safe experiments for curious kids aged 6-12.', NULL, NULL, NULL, 999.00, NULL, NULL, 30, 0, NULL, NULL, 0, 1, '2026-06-15 06:53:53', '2026-06-15 07:02:53', 'completed'),
(312, 'EDUTOY06', 11, 183, 15, 5, 8, 'Phonics Flash Cards', 'phonics-flash-cards-6a2fa1810e467', 0, 'PSKU-LPABQIJ5', 'Set of 100 phonics flash cards for early reading and language development.', NULL, NULL, NULL, 299.00, NULL, NULL, 100, 0, NULL, NULL, 0, 1, '2026-06-15 06:53:53', '2026-06-15 07:02:53', 'completed'),
(313, 'EDUTOY07', 11, 183, 15, 5, 8, 'Solar System Model Kit', 'solar-system-model-kit-6a2fa1810efda', 0, 'PSKU-HBIV6ISD', 'Build-and-learn solar system model kit for school-age kids.', NULL, NULL, NULL, 799.00, NULL, NULL, 40, 0, NULL, NULL, 0, 1, '2026-06-15 06:53:53', '2026-06-15 07:02:53', 'completed'),
(314, 'EDUTOY08', 11, 183, 15, 5, 8, 'Kids Coding Game', 'kids-coding-game-6a2fa1810fd1f', 0, 'PSKU-AL5XEL5U', 'Beginner coding board game teaching programming logic without screens.', NULL, NULL, NULL, 1199.00, NULL, NULL, 25, 0, NULL, NULL, 0, 1, '2026-06-15 06:53:53', '2026-06-15 07:02:53', 'completed'),
(315, 'EDUTOY09', 11, 183, 15, 5, 8, 'Stacking Rings Toy', 'stacking-rings-toy-6a2fa18110b42', 0, 'PSKU-VG6KVRRP', 'Classic color stacking rings for infants developing hand-eye coordination.', NULL, NULL, NULL, 249.00, NULL, NULL, 120, 0, NULL, NULL, 0, 1, '2026-06-15 06:53:53', '2026-06-15 07:02:53', 'completed'),
(316, 'EDUTOY10', 11, 183, 15, 5, 8, 'Counting Bears Set', 'counting-bears-set-6a2fa18111bbc', 0, 'PSKU-DVMD2RAM', 'Set of 60 counting bears in 6 colors for early math and sorting activities.', NULL, NULL, NULL, 449.00, NULL, NULL, 70, 0, NULL, NULL, 0, 1, '2026-06-15 06:53:53', '2026-06-15 07:02:53', 'completed'),
(317, 'SOFTTOY01', 11, 186, 15, 5, 8, 'Plush Teddy Bear', 'plush-teddy-bear-6a2fa18112b48', 0, 'PSKU-IEZ2QMPA', 'Extra soft and cuddly plush teddy bear suitable for newborns and above.', NULL, NULL, NULL, 599.00, NULL, NULL, 80, 0, NULL, NULL, 0, 1, '2026-06-15 06:53:53', '2026-06-15 07:02:53', 'completed'),
(318, 'SOFTTOY02', 11, 186, 15, 5, 8, 'Baby Elephant Plush', 'baby-elephant-plush-6a2fa181139f6', 0, 'PSKU-MU26XSWR', 'Adorable baby elephant soft toy with rattle inside for sensory play.', NULL, NULL, NULL, 499.00, NULL, NULL, 90, 0, NULL, NULL, 0, 1, '2026-06-15 06:53:53', '2026-06-15 07:02:53', 'completed'),
(319, 'SOFTTOY03', 11, 186, 15, 5, 8, 'Unicorn Stuffed Animal', 'unicorn-stuffed-animal-6a2fa181146d6', 0, 'PSKU-K3WOCPO4', 'Sparkly unicorn stuffed toy loved by little girls aged 2+.', NULL, NULL, NULL, 699.00, NULL, NULL, 65, 0, NULL, NULL, 0, 1, '2026-06-15 06:53:53', '2026-06-15 07:02:53', 'completed'),
(320, 'SOFTTOY04', 11, 186, 15, 5, 8, 'Soft Dinosaur Set', 'soft-dinosaur-set-6a2fa18115c5d', 0, 'PSKU-BY27WHNX', 'Set of 5 soft mini dinosaur plush toys for imaginative play.', NULL, NULL, NULL, 849.00, NULL, NULL, 50, 0, NULL, NULL, 0, 1, '2026-06-15 06:53:53', '2026-06-15 07:02:53', 'completed'),
(321, 'SOFTTOY05', 11, 186, 15, 5, 8, 'Huggable Bunny Plush', 'huggable-bunny-plush-6a2fa18116ca7', 0, 'PSKU-HXVYOY5Q', 'Soft white bunny plush with long floppy ears, perfect for gifting.', NULL, NULL, NULL, 549.00, NULL, NULL, 75, 0, NULL, NULL, 0, 1, '2026-06-15 06:53:53', '2026-06-15 07:02:53', 'completed'),
(322, 'SOFTTOY06', 11, 186, 15, 5, 8, 'Baby Lion Rattle Plush', 'baby-lion-rattle-plush-6a2fa18117b57', 0, 'PSKU-XJ2AHQQC', 'Cheerful lion soft toy with built-in rattle for babies aged 0-12M.', NULL, NULL, NULL, 399.00, NULL, NULL, 100, 0, NULL, NULL, 0, 1, '2026-06-15 06:53:53', '2026-06-15 07:02:54', 'completed'),
(323, 'SOFTTOY07', 11, 186, 15, 5, 8, 'Reversible Octopus Plush', 'reversible-octopus-plush-6a2fa18118833', 0, 'PSKU-SDOLVOAY', 'Mood-changing reversible octopus plush toy, happy and sad faces.', NULL, NULL, NULL, 449.00, NULL, NULL, 85, 0, NULL, NULL, 0, 1, '2026-06-15 06:53:53', '2026-06-15 07:02:54', 'completed'),
(324, 'SOFTTOY08', 11, 186, 15, 5, 8, 'Giant Panda Stuffed Bear', 'giant-panda-stuffed-bear-6a2fa1811996c', 0, 'PSKU-QVAHWGQW', 'Giant panda stuffed bear, perfect companion for kids aged 3+.', NULL, NULL, NULL, 999.00, NULL, NULL, 40, 0, NULL, NULL, 0, 1, '2026-06-15 06:53:53', '2026-06-15 07:02:54', 'completed'),
(325, 'BOARDGAME01', 11, 187, 15, 5, 8, 'Snakes and Ladders', 'snakes-and-ladders-6a2fa1811a93d', 0, 'PSKU-FEPQO0UY', 'Classic snakes and ladders board game for 2-6 players, ages 4+.', NULL, NULL, NULL, 299.00, NULL, NULL, 90, 0, NULL, NULL, 0, 1, '2026-06-15 06:53:53', '2026-06-15 07:02:54', 'completed'),
(326, 'BOARDGAME02', 11, 187, 15, 5, 8, 'Junior Scrabble', 'junior-scrabble-6a2fa1811b9cf', 0, 'PSKU-ZNHVVXPF', 'Junior edition Scrabble for young word learners aged 5+.', NULL, NULL, NULL, 699.00, NULL, NULL, 55, 0, NULL, NULL, 0, 1, '2026-06-15 06:53:53', '2026-06-15 07:02:54', 'completed'),
(327, 'BOARDGAME03', 11, 187, 15, 5, 8, 'Kids Memory Match Game', 'kids-memory-match-game-6a2fa1811c7c4', 0, 'PSKU-9CMTIGZM', 'Animal-themed memory match card game improving concentration in kids.', NULL, NULL, NULL, 349.00, NULL, NULL, 80, 0, NULL, NULL, 0, 1, '2026-06-15 06:53:53', '2026-06-15 07:02:54', 'completed'),
(328, 'BOARDGAME04', 11, 187, 15, 5, 8, 'Ludo Board Game', 'ludo-board-game-6a2fa1811e64e', 0, 'PSKU-2BUWGSZJ', 'Colorful ludo board game set for family fun, suitable for ages 5+.', NULL, NULL, NULL, 249.00, NULL, NULL, 100, 0, NULL, NULL, 0, 1, '2026-06-15 06:53:53', '2026-06-15 07:02:54', 'completed'),
(329, 'BOARDGAME05', 11, 187, 15, 5, 8, 'Kids Chess Set', 'kids-chess-set-6a2fa1811f819', 0, 'PSKU-ZRZBJ9QT', 'Beginner-friendly chess set with jumbo pieces and illustrated rules.', NULL, NULL, NULL, 799.00, NULL, NULL, 35, 0, NULL, NULL, 0, 1, '2026-06-15 06:53:53', '2026-06-15 07:02:54', 'completed'),
(330, 'BOARDGAME06', 11, 187, 15, 5, 8, 'Jenga Blocks Junior', 'jenga-blocks-junior-6a2fa18120b1a', 0, 'PSKU-JBOEJP1P', 'Junior Jenga wooden block tower game building focus and motor skills.', NULL, NULL, NULL, 599.00, NULL, NULL, 50, 0, NULL, NULL, 0, 1, '2026-06-15 06:53:53', '2026-06-15 07:02:54', 'completed'),
(331, 'BOARDGAME07', 11, 187, 15, 5, 8, 'Pictionary Kids Edition', 'pictionary-kids-edition-6a2fa18122600', 0, 'PSKU-T7CY0CUJ', 'Drawing and guessing board game for creative kids aged 6+.', NULL, NULL, NULL, 899.00, NULL, NULL, 30, 0, NULL, NULL, 0, 1, '2026-06-15 06:53:53', '2026-06-15 07:02:54', 'completed'),
(332, 'BOARDGAME08', 11, 187, 15, 5, 8, 'Animal Bingo', 'animal-bingo-6a2fa181237ce', 0, 'PSKU-RAGM8OTU', 'Animal-themed bingo card game for early learners, fun for the whole family.', NULL, NULL, NULL, 299.00, NULL, NULL, 85, 0, NULL, NULL, 0, 1, '2026-06-15 06:53:53', '2026-06-15 07:02:54', 'completed'),
(333, 'BOARDGAME09', 11, 187, 15, 5, 8, 'Treasure Hunt Board Game', 'treasure-hunt-board-game-6a2fa18124722', 0, 'PSKU-GTG705QW', 'Interactive treasure hunt adventure board game for kids aged 5-10.', NULL, NULL, NULL, 749.00, NULL, NULL, 40, 0, NULL, NULL, 0, 1, '2026-06-15 06:53:53', '2026-06-15 07:02:54', 'completed'),
(334, 'BOARDGAME10', 11, 187, 15, 5, 8, 'Math War Card Game', 'math-war-card-game-6a2fa18126450', 0, 'PSKU-VVYLBXXW', 'Fast-paced math card game making arithmetic fun for school-age kids.', NULL, NULL, NULL, 349.00, NULL, NULL, 70, 0, NULL, NULL, 0, 1, '2026-06-15 06:53:53', '2026-06-15 07:02:54', 'completed');

-- --------------------------------------------------------

--
-- Table structure for table `product_attribute_values`
--

CREATE TABLE `product_attribute_values` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `attribute_value_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_attribute_values`
--

INSERT INTO `product_attribute_values` (`id`, `product_id`, `attribute_value_id`) VALUES
(737, 282, 969),
(738, 282, 973),
(739, 282, 996),
(977, 283, 966),
(978, 283, 971),
(970, 283, 974),
(971, 283, 976),
(972, 283, 977),
(973, 283, 986),
(974, 283, 987),
(975, 283, 989),
(976, 283, 990),
(979, 283, 994),
(743, 284, 966),
(744, 284, 972),
(745, 284, 995),
(746, 285, 969),
(747, 285, 973),
(748, 285, 995),
(749, 286, 969),
(750, 286, 971),
(751, 286, 996),
(752, 287, 966),
(753, 287, 972),
(754, 287, 996),
(755, 288, 969),
(756, 288, 973),
(757, 288, 996),
(758, 289, 967),
(759, 289, 971),
(760, 289, 996),
(761, 290, 969),
(762, 290, 972),
(763, 290, 995),
(764, 291, 967),
(765, 291, 971),
(766, 291, 995),
(767, 292, 969),
(768, 292, 973),
(769, 292, 995),
(770, 293, 970),
(771, 293, 972),
(772, 293, 995),
(773, 294, 969),
(774, 294, 973),
(775, 294, 994),
(776, 295, 969),
(777, 295, 971),
(778, 295, 994),
(779, 296, 969),
(780, 296, 973),
(781, 296, 996),
(782, 297, 966),
(783, 297, 972),
(784, 297, 994),
(785, 298, 969),
(786, 298, 971),
(787, 298, 994),
(788, 299, 970),
(789, 299, 971),
(790, 299, 996),
(791, 300, 969),
(792, 300, 972),
(793, 300, 996),
(794, 301, 969),
(795, 301, 973),
(796, 301, 994),
(797, 302, 967),
(798, 302, 973),
(799, 302, 995),
(800, 303, 966),
(801, 303, 972),
(802, 303, 995),
(803, 304, 969),
(804, 304, 971),
(805, 304, 995),
(806, 305, 969),
(807, 305, 973),
(808, 305, 994),
(988, 306, 969),
(989, 306, 973),
(980, 306, 974),
(981, 306, 976),
(982, 306, 980),
(983, 306, 985),
(984, 306, 986),
(985, 306, 987),
(986, 306, 988),
(987, 306, 989),
(990, 306, 996),
(814, 308, 330),
(815, 308, 338),
(816, 309, 330),
(817, 309, 336),
(818, 310, 330),
(819, 310, 339),
(820, 311, 330),
(821, 311, 338),
(822, 312, 330),
(823, 312, 337),
(824, 313, 330),
(825, 313, 338),
(826, 314, 330),
(827, 314, 338),
(828, 315, 330),
(829, 315, 336),
(830, 316, 330),
(831, 316, 337),
(832, 317, 334),
(833, 317, 336),
(834, 318, 334),
(835, 318, 336),
(836, 319, 334),
(837, 319, 339),
(838, 320, 334),
(839, 320, 339),
(840, 321, 334),
(841, 321, 336),
(842, 322, 334),
(843, 322, 336),
(844, 323, 334),
(845, 323, 339),
(846, 324, 334),
(847, 324, 339),
(848, 325, 332),
(849, 325, 337),
(850, 326, 332),
(851, 326, 337),
(852, 327, 332),
(853, 327, 337),
(854, 328, 332),
(855, 328, 337),
(856, 329, 332),
(857, 329, 338),
(858, 330, 332),
(859, 330, 336),
(860, 331, 332),
(861, 331, 339),
(862, 332, 332),
(863, 332, 337),
(864, 333, 332),
(865, 333, 337),
(866, 334, 332),
(867, 334, 338);

-- --------------------------------------------------------

--
-- Table structure for table `product_attribute_value_images`
--

CREATE TABLE `product_attribute_value_images` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `attribute_value_id` bigint(20) UNSIGNED NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `is_primary` tinyint(1) DEFAULT 0,
  `sort_order` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_attribute_value_images`
--

INSERT INTO `product_attribute_value_images` (`id`, `product_id`, `attribute_value_id`, `image_path`, `is_primary`, `sort_order`, `created_at`, `updated_at`) VALUES
(547, 282, 976, 'products/variants/2026/06/6a2fa39a4d292.png', 1, 0, '2026-06-15 07:02:50', '2026-06-15 07:02:50'),
(548, 282, 979, 'products/variants/2026/06/6a2fa39a5110b.png', 1, 0, '2026-06-15 07:02:50', '2026-06-15 07:02:50'),
(549, 282, 975, 'products/variants/2026/06/6a2fa39a53b89.png', 1, 0, '2026-06-15 07:02:50', '2026-06-15 07:02:50'),
(550, 282, 976, 'products/variants/2026/06/6a2fa39a56134.png', 0, 1, '2026-06-15 07:02:50', '2026-06-15 07:02:50'),
(551, 282, 979, 'products/variants/2026/06/6a2fa39a588ac.png', 0, 1, '2026-06-15 07:02:50', '2026-06-15 07:02:50'),
(552, 282, 975, 'products/variants/2026/06/6a2fa39a5b874.png', 0, 1, '2026-06-15 07:02:50', '2026-06-15 07:02:50'),
(553, 282, 976, 'products/variants/2026/06/6a2fa39a5ebcc.png', 0, 2, '2026-06-15 07:02:50', '2026-06-15 07:02:50'),
(554, 282, 979, 'products/variants/2026/06/6a2fa39a6176a.png', 0, 2, '2026-06-15 07:02:50', '2026-06-15 07:02:50'),
(555, 282, 975, 'products/variants/2026/06/6a2fa39a643fd.png', 0, 2, '2026-06-15 07:02:50', '2026-06-15 07:02:50'),
(556, 282, 976, 'products/variants/2026/06/6a2fa39a66ad7.png', 0, 3, '2026-06-15 07:02:50', '2026-06-15 07:02:50'),
(557, 282, 979, 'products/variants/2026/06/6a2fa39a69473.png', 0, 3, '2026-06-15 07:02:50', '2026-06-15 07:02:50'),
(558, 282, 975, 'products/variants/2026/06/6a2fa39a6c21f.png', 0, 3, '2026-06-15 07:02:50', '2026-06-15 07:02:50'),
(559, 283, 977, 'products/variants/2026/06/6a2fa39a6ef9d.png', 1, 0, '2026-06-15 07:02:50', '2026-06-15 07:02:50'),
(560, 283, 976, 'products/variants/2026/06/6a2fa39a72208.png', 1, 0, '2026-06-15 07:02:50', '2026-06-15 07:02:50'),
(561, 283, 974, 'products/variants/2026/06/6a2fa39a75fa1.png', 1, 0, '2026-06-15 07:02:50', '2026-06-15 07:02:50'),
(562, 283, 977, 'products/variants/2026/06/6a2fa39a78eeb.png', 0, 1, '2026-06-15 07:02:50', '2026-06-15 07:02:50'),
(563, 283, 976, 'products/variants/2026/06/6a2fa39a7b93e.png', 0, 1, '2026-06-15 07:02:50', '2026-06-15 07:02:50'),
(564, 283, 974, 'products/variants/2026/06/6a2fa39a7fe6f.png', 0, 1, '2026-06-15 07:02:50', '2026-06-15 07:02:50'),
(565, 283, 977, 'products/variants/2026/06/6a2fa39a83127.png', 0, 2, '2026-06-15 07:02:50', '2026-06-15 07:02:50'),
(566, 283, 976, 'products/variants/2026/06/6a2fa39a85d1d.png', 0, 2, '2026-06-15 07:02:50', '2026-06-15 07:02:50'),
(567, 283, 974, 'products/variants/2026/06/6a2fa39a8835e.png', 0, 2, '2026-06-15 07:02:50', '2026-06-15 07:02:50'),
(568, 283, 977, 'products/variants/2026/06/6a2fa39a8ca89.png', 0, 3, '2026-06-15 07:02:50', '2026-06-15 07:02:50'),
(569, 283, 976, 'products/variants/2026/06/6a2fa39a91564.png', 0, 3, '2026-06-15 07:02:50', '2026-06-15 07:02:50'),
(570, 283, 974, 'products/variants/2026/06/6a2fa39a93b77.png', 0, 3, '2026-06-15 07:02:50', '2026-06-15 07:02:50'),
(571, 284, 979, 'products/variants/2026/06/6a2fa39a95f73.png', 0, 0, '2026-06-15 07:02:50', '2026-06-15 07:02:50'),
(572, 284, 975, 'products/variants/2026/06/6a2fa39a98c21.png', 1, 0, '2026-06-15 07:02:50', '2026-06-15 07:02:50'),
(573, 284, 980, 'products/variants/2026/06/6a2fa39a9b246.png', 1, 0, '2026-06-15 07:02:50', '2026-06-15 07:02:50'),
(574, 284, 979, 'products/variants/2026/06/6a2fa39a9d8af.png', 1, 1, '2026-06-15 07:02:50', '2026-06-15 07:02:50'),
(575, 284, 975, 'products/variants/2026/06/6a2fa39a9ff88.png', 0, 1, '2026-06-15 07:02:50', '2026-06-15 07:02:50'),
(576, 284, 980, 'products/variants/2026/06/6a2fa39aa2332.png', 0, 1, '2026-06-15 07:02:50', '2026-06-15 07:02:50'),
(577, 284, 979, 'products/variants/2026/06/6a2fa39aa46e7.png', 0, 2, '2026-06-15 07:02:50', '2026-06-15 07:02:50'),
(578, 284, 975, 'products/variants/2026/06/6a2fa39aa69a7.png', 0, 2, '2026-06-15 07:02:50', '2026-06-15 07:02:50'),
(579, 284, 980, 'products/variants/2026/06/6a2fa39aa963d.png', 0, 2, '2026-06-15 07:02:50', '2026-06-15 07:02:50'),
(580, 284, 979, 'products/variants/2026/06/6a2fa39aabf79.png', 0, 3, '2026-06-15 07:02:50', '2026-06-15 07:02:50'),
(581, 284, 975, 'products/variants/2026/06/6a2fa39aaed52.png', 0, 3, '2026-06-15 07:02:50', '2026-06-15 07:02:50'),
(582, 284, 980, 'products/variants/2026/06/6a2fa39ab12d8.png', 0, 3, '2026-06-15 07:02:50', '2026-06-15 07:02:50'),
(583, 285, 976, 'products/variants/2026/06/6a2fa39ab3777.png', 1, 0, '2026-06-15 07:02:50', '2026-06-15 07:02:50'),
(584, 285, 975, 'products/variants/2026/06/6a2fa39ab562b.png', 1, 0, '2026-06-15 07:02:50', '2026-06-15 07:02:50'),
(585, 285, 976, 'products/variants/2026/06/6a2fa39ab7602.png', 0, 1, '2026-06-15 07:02:50', '2026-06-15 07:02:50'),
(586, 285, 975, 'products/variants/2026/06/6a2fa39ab99e9.png', 0, 1, '2026-06-15 07:02:50', '2026-06-15 07:02:50'),
(587, 285, 976, 'products/variants/2026/06/6a2fa39abbbe7.png', 0, 2, '2026-06-15 07:02:50', '2026-06-15 07:02:50'),
(588, 285, 975, 'products/variants/2026/06/6a2fa39abe2e8.png', 0, 2, '2026-06-15 07:02:50', '2026-06-15 07:02:50'),
(589, 285, 976, 'products/variants/2026/06/6a2fa39ac072e.png', 0, 3, '2026-06-15 07:02:50', '2026-06-15 07:02:50'),
(590, 285, 975, 'products/variants/2026/06/6a2fa39ac3159.png', 0, 3, '2026-06-15 07:02:50', '2026-06-15 07:02:50'),
(591, 286, 977, 'products/variants/2026/06/6a2fa39ac55d0.png', 1, 0, '2026-06-15 07:02:50', '2026-06-15 07:02:50'),
(592, 286, 976, 'products/variants/2026/06/6a2fa39ac7ae7.png', 1, 0, '2026-06-15 07:02:50', '2026-06-15 07:02:50'),
(593, 286, 975, 'products/variants/2026/06/6a2fa39ac9d9f.png', 1, 0, '2026-06-15 07:02:50', '2026-06-15 07:02:50'),
(594, 286, 977, 'products/variants/2026/06/6a2fa39acc747.png', 0, 1, '2026-06-15 07:02:50', '2026-06-15 07:02:50'),
(595, 286, 976, 'products/variants/2026/06/6a2fa39aceff2.png', 0, 1, '2026-06-15 07:02:50', '2026-06-15 07:02:50'),
(596, 286, 975, 'products/variants/2026/06/6a2fa39ad32fc.png', 0, 1, '2026-06-15 07:02:50', '2026-06-15 07:02:50'),
(597, 286, 977, 'products/variants/2026/06/6a2fa39ad5d12.png', 0, 2, '2026-06-15 07:02:50', '2026-06-15 07:02:50'),
(598, 286, 976, 'products/variants/2026/06/6a2fa39ad8a41.png', 0, 2, '2026-06-15 07:02:50', '2026-06-15 07:02:50'),
(599, 286, 975, 'products/variants/2026/06/6a2fa39adbe6f.png', 0, 2, '2026-06-15 07:02:50', '2026-06-15 07:02:50'),
(600, 286, 977, 'products/variants/2026/06/6a2fa39adf8c5.png', 0, 3, '2026-06-15 07:02:50', '2026-06-15 07:02:50'),
(601, 286, 976, 'products/variants/2026/06/6a2fa39ae3173.png', 0, 3, '2026-06-15 07:02:50', '2026-06-15 07:02:50'),
(602, 286, 975, 'products/variants/2026/06/6a2fa39ae6ae9.png', 0, 3, '2026-06-15 07:02:50', '2026-06-15 07:02:50'),
(603, 287, 979, 'products/variants/2026/06/6a2fa39aea4ec.png', 1, 0, '2026-06-15 07:02:50', '2026-06-15 07:02:50'),
(604, 287, 975, 'products/variants/2026/06/6a2fa39aee01e.png', 1, 0, '2026-06-15 07:02:50', '2026-06-15 07:02:50'),
(605, 287, 979, 'products/variants/2026/06/6a2fa39af2092.png', 0, 1, '2026-06-15 07:02:51', '2026-06-15 07:02:51'),
(606, 287, 975, 'products/variants/2026/06/6a2fa39b0362d.png', 0, 1, '2026-06-15 07:02:51', '2026-06-15 07:02:51'),
(607, 287, 979, 'products/variants/2026/06/6a2fa39b06af8.png', 0, 2, '2026-06-15 07:02:51', '2026-06-15 07:02:51'),
(608, 287, 975, 'products/variants/2026/06/6a2fa39b09eea.png', 0, 2, '2026-06-15 07:02:51', '2026-06-15 07:02:51'),
(609, 287, 975, 'products/variants/2026/06/6a2fa39b0d90d.png', 0, 3, '2026-06-15 07:02:51', '2026-06-15 07:02:51'),
(610, 287, 979, 'products/variants/2026/06/6a2fa39b11451.png', 0, 3, '2026-06-15 07:02:51', '2026-06-15 07:02:51'),
(611, 288, 974, 'products/variants/2026/06/6a2fa39b1547b.png', 1, 0, '2026-06-15 07:02:51', '2026-06-15 07:02:51'),
(612, 288, 980, 'products/variants/2026/06/6a2fa39b19590.png', 1, 0, '2026-06-15 07:02:51', '2026-06-15 07:02:51'),
(613, 288, 974, 'products/variants/2026/06/6a2fa39b1e248.png', 0, 1, '2026-06-15 07:02:51', '2026-06-15 07:02:51'),
(614, 288, 980, 'products/variants/2026/06/6a2fa39b22690.png', 0, 1, '2026-06-15 07:02:51', '2026-06-15 07:02:51'),
(615, 288, 974, 'products/variants/2026/06/6a2fa39b27c4e.png', 0, 2, '2026-06-15 07:02:51', '2026-06-15 07:02:51'),
(616, 288, 980, 'products/variants/2026/06/6a2fa39b2adbe.png', 0, 2, '2026-06-15 07:02:51', '2026-06-15 07:02:51'),
(617, 288, 980, 'products/variants/2026/06/6a2fa39b2dd80.png', 0, 3, '2026-06-15 07:02:51', '2026-06-15 07:02:51'),
(618, 288, 974, 'products/variants/2026/06/6a2fa39b31a95.png', 0, 3, '2026-06-15 07:02:51', '2026-06-15 07:02:51'),
(619, 289, 976, 'products/variants/2026/06/6a2fa39b35fca.png', 1, 0, '2026-06-15 07:02:51', '2026-06-15 07:02:51'),
(620, 289, 975, 'products/variants/2026/06/6a2fa39b398b3.png', 1, 0, '2026-06-15 07:02:51', '2026-06-15 07:02:51'),
(621, 289, 976, 'products/variants/2026/06/6a2fa39b3d468.png', 0, 1, '2026-06-15 07:02:51', '2026-06-15 07:02:51'),
(622, 289, 975, 'products/variants/2026/06/6a2fa39b40948.png', 0, 1, '2026-06-15 07:02:51', '2026-06-15 07:02:51'),
(623, 289, 976, 'products/variants/2026/06/6a2fa39b441e7.png', 0, 2, '2026-06-15 07:02:51', '2026-06-15 07:02:51'),
(624, 289, 975, 'products/variants/2026/06/6a2fa39b47f50.png', 0, 2, '2026-06-15 07:02:51', '2026-06-15 07:02:51'),
(625, 289, 976, 'products/variants/2026/06/6a2fa39b4c1a9.png', 0, 3, '2026-06-15 07:02:51', '2026-06-15 07:02:51'),
(626, 289, 975, 'products/variants/2026/06/6a2fa39b4f1c1.png', 0, 3, '2026-06-15 07:02:51', '2026-06-15 07:02:51'),
(627, 290, 978, 'products/variants/2026/06/6a2fa39b51f7b.png', 1, 0, '2026-06-15 07:02:51', '2026-06-15 07:02:51'),
(628, 290, 979, 'products/variants/2026/06/6a2fa39b5548a.png', 1, 0, '2026-06-15 07:02:51', '2026-06-15 07:02:51'),
(629, 290, 980, 'products/variants/2026/06/6a2fa39b58402.png', 1, 0, '2026-06-15 07:02:51', '2026-06-15 07:02:51'),
(630, 290, 978, 'products/variants/2026/06/6a2fa39b5b718.png', 0, 1, '2026-06-15 07:02:51', '2026-06-15 07:02:51'),
(631, 290, 979, 'products/variants/2026/06/6a2fa39b5e897.png', 0, 1, '2026-06-15 07:02:51', '2026-06-15 07:02:51'),
(632, 290, 980, 'products/variants/2026/06/6a2fa39b61636.png', 0, 1, '2026-06-15 07:02:51', '2026-06-15 07:02:51'),
(633, 290, 978, 'products/variants/2026/06/6a2fa39b65018.png', 0, 2, '2026-06-15 07:02:51', '2026-06-15 07:02:51'),
(634, 290, 979, 'products/variants/2026/06/6a2fa39b681ea.png', 0, 2, '2026-06-15 07:02:51', '2026-06-15 07:02:51'),
(635, 290, 980, 'products/variants/2026/06/6a2fa39b6a604.png', 0, 2, '2026-06-15 07:02:51', '2026-06-15 07:02:51'),
(636, 290, 978, 'products/variants/2026/06/6a2fa39b6cbd4.png', 0, 3, '2026-06-15 07:02:51', '2026-06-15 07:02:51'),
(637, 290, 979, 'products/variants/2026/06/6a2fa39b6f822.png', 0, 3, '2026-06-15 07:02:51', '2026-06-15 07:02:51'),
(638, 290, 980, 'products/variants/2026/06/6a2fa39b71bd1.png', 0, 3, '2026-06-15 07:02:51', '2026-06-15 07:02:51'),
(639, 291, 977, 'products/variants/2026/06/6a2fa39b7409e.png', 1, 0, '2026-06-15 07:02:51', '2026-06-15 07:02:51'),
(640, 291, 976, 'products/variants/2026/06/6a2fa39b769e0.png', 1, 0, '2026-06-15 07:02:51', '2026-06-15 07:02:51'),
(641, 291, 977, 'products/variants/2026/06/6a2fa39b78fdc.png', 0, 1, '2026-06-15 07:02:51', '2026-06-15 07:02:51'),
(642, 291, 976, 'products/variants/2026/06/6a2fa39b7b45f.png', 0, 1, '2026-06-15 07:02:51', '2026-06-15 07:02:51'),
(643, 291, 977, 'products/variants/2026/06/6a2fa39b7d67a.png', 0, 2, '2026-06-15 07:02:51', '2026-06-15 07:02:51'),
(644, 291, 976, 'products/variants/2026/06/6a2fa39b801ab.png', 0, 2, '2026-06-15 07:02:51', '2026-06-15 07:02:51'),
(645, 291, 977, 'products/variants/2026/06/6a2fa39b82463.png', 0, 3, '2026-06-15 07:02:51', '2026-06-15 07:02:51'),
(646, 291, 976, 'products/variants/2026/06/6a2fa39b84c73.png', 0, 3, '2026-06-15 07:02:51', '2026-06-15 07:02:51'),
(647, 292, 976, 'products/variants/2026/06/6a2fa39b86e91.png', 1, 0, '2026-06-15 07:02:51', '2026-06-15 07:02:51'),
(648, 292, 979, 'products/variants/2026/06/6a2fa39b88ef2.png', 1, 0, '2026-06-15 07:02:51', '2026-06-15 07:02:51'),
(649, 292, 975, 'products/variants/2026/06/6a2fa39b8ad3f.png', 1, 0, '2026-06-15 07:02:51', '2026-06-15 07:02:51'),
(650, 292, 976, 'products/variants/2026/06/6a2fa39b8cc27.png', 0, 1, '2026-06-15 07:02:51', '2026-06-15 07:02:51'),
(651, 292, 979, 'products/variants/2026/06/6a2fa39b8e6ce.png', 0, 1, '2026-06-15 07:02:51', '2026-06-15 07:02:51'),
(652, 292, 975, 'products/variants/2026/06/6a2fa39b906e2.png', 0, 1, '2026-06-15 07:02:51', '2026-06-15 07:02:51'),
(653, 292, 976, 'products/variants/2026/06/6a2fa39b924b1.png', 0, 2, '2026-06-15 07:02:51', '2026-06-15 07:02:51'),
(654, 292, 979, 'products/variants/2026/06/6a2fa39b93f08.png', 0, 2, '2026-06-15 07:02:51', '2026-06-15 07:02:51'),
(655, 292, 975, 'products/variants/2026/06/6a2fa39b95e31.png', 0, 2, '2026-06-15 07:02:51', '2026-06-15 07:02:51'),
(656, 292, 976, 'products/variants/2026/06/6a2fa39b97b4a.png', 0, 3, '2026-06-15 07:02:51', '2026-06-15 07:02:51'),
(657, 292, 979, 'products/variants/2026/06/6a2fa39b99e2d.png', 0, 3, '2026-06-15 07:02:51', '2026-06-15 07:02:51'),
(658, 292, 975, 'products/variants/2026/06/6a2fa39b9ba2d.png', 0, 3, '2026-06-15 07:02:51', '2026-06-15 07:02:51'),
(659, 293, 981, 'products/variants/2026/06/6a2fa39b9d7ab.png', 1, 0, '2026-06-15 07:02:51', '2026-06-15 07:02:51'),
(660, 293, 979, 'products/variants/2026/06/6a2fa39b9f968.png', 1, 0, '2026-06-15 07:02:51', '2026-06-15 07:02:51'),
(661, 293, 974, 'products/variants/2026/06/6a2fa39ba1fe9.png', 1, 0, '2026-06-15 07:02:51', '2026-06-15 07:02:51'),
(662, 293, 981, 'products/variants/2026/06/6a2fa39ba4d35.png', 0, 1, '2026-06-15 07:02:51', '2026-06-15 07:02:51'),
(663, 293, 979, 'products/variants/2026/06/6a2fa39ba70f7.png', 0, 1, '2026-06-15 07:02:51', '2026-06-15 07:02:51'),
(664, 293, 974, 'products/variants/2026/06/6a2fa39ba92e1.png', 0, 1, '2026-06-15 07:02:51', '2026-06-15 07:02:51'),
(665, 293, 981, 'products/variants/2026/06/6a2fa39bab566.png', 0, 2, '2026-06-15 07:02:51', '2026-06-15 07:02:51'),
(666, 293, 979, 'products/variants/2026/06/6a2fa39bada91.png', 0, 2, '2026-06-15 07:02:51', '2026-06-15 07:02:51'),
(667, 293, 974, 'products/variants/2026/06/6a2fa39bb0153.png', 0, 2, '2026-06-15 07:02:51', '2026-06-15 07:02:51'),
(668, 293, 981, 'products/variants/2026/06/6a2fa39bb2754.png', 0, 3, '2026-06-15 07:02:51', '2026-06-15 07:02:51'),
(669, 293, 979, 'products/variants/2026/06/6a2fa39bb50e8.png', 0, 3, '2026-06-15 07:02:51', '2026-06-15 07:02:51'),
(670, 293, 974, 'products/variants/2026/06/6a2fa39bb7b28.png', 0, 3, '2026-06-15 07:02:51', '2026-06-15 07:02:51'),
(671, 294, 978, 'products/variants/2026/06/6a2fa39bba5e3.png', 1, 0, '2026-06-15 07:02:51', '2026-06-15 07:02:51'),
(672, 294, 981, 'products/variants/2026/06/6a2fa39bbd070.png', 1, 0, '2026-06-15 07:02:51', '2026-06-15 07:02:51'),
(673, 294, 980, 'products/variants/2026/06/6a2fa39bbee92.png', 0, 0, '2026-06-15 07:02:51', '2026-06-15 07:02:51'),
(674, 294, 978, 'products/variants/2026/06/6a2fa39bc1317.png', 0, 1, '2026-06-15 07:02:51', '2026-06-15 07:02:51'),
(675, 294, 981, 'products/variants/2026/06/6a2fa39bc3d03.png', 0, 1, '2026-06-15 07:02:51', '2026-06-15 07:02:51'),
(676, 294, 980, 'products/variants/2026/06/6a2fa39bc6193.png', 1, 1, '2026-06-15 07:02:51', '2026-06-15 07:02:51'),
(677, 294, 978, 'products/variants/2026/06/6a2fa39bc8d4e.png', 0, 2, '2026-06-15 07:02:51', '2026-06-15 07:02:51'),
(678, 294, 981, 'products/variants/2026/06/6a2fa39bcbcfd.png', 0, 2, '2026-06-15 07:02:51', '2026-06-15 07:02:51'),
(679, 294, 980, 'products/variants/2026/06/6a2fa39bcfb31.png', 0, 2, '2026-06-15 07:02:51', '2026-06-15 07:02:51'),
(680, 294, 978, 'products/variants/2026/06/6a2fa39bd3349.png', 0, 3, '2026-06-15 07:02:51', '2026-06-15 07:02:51'),
(681, 294, 981, 'products/variants/2026/06/6a2fa39bd69e4.png', 0, 3, '2026-06-15 07:02:51', '2026-06-15 07:02:51'),
(682, 294, 980, 'products/variants/2026/06/6a2fa39bda18c.png', 0, 3, '2026-06-15 07:02:51', '2026-06-15 07:02:51'),
(683, 295, 977, 'products/variants/2026/06/6a2fa39bdd2ab.png', 1, 0, '2026-06-15 07:02:51', '2026-06-15 07:02:51'),
(684, 295, 976, 'products/variants/2026/06/6a2fa39bdfe1c.png', 1, 0, '2026-06-15 07:02:51', '2026-06-15 07:02:51'),
(685, 295, 974, 'products/variants/2026/06/6a2fa39be3020.png', 1, 0, '2026-06-15 07:02:51', '2026-06-15 07:02:51'),
(686, 295, 977, 'products/variants/2026/06/6a2fa39be6ad2.png', 0, 1, '2026-06-15 07:02:51', '2026-06-15 07:02:51'),
(687, 295, 976, 'products/variants/2026/06/6a2fa39be9635.png', 0, 1, '2026-06-15 07:02:51', '2026-06-15 07:02:51'),
(688, 295, 974, 'products/variants/2026/06/6a2fa39bec196.png', 0, 1, '2026-06-15 07:02:51', '2026-06-15 07:02:51'),
(689, 295, 977, 'products/variants/2026/06/6a2fa39beec61.png', 0, 2, '2026-06-15 07:02:51', '2026-06-15 07:02:51'),
(690, 295, 976, 'products/variants/2026/06/6a2fa39bf1c56.png', 0, 2, '2026-06-15 07:02:51', '2026-06-15 07:02:51'),
(691, 295, 974, 'products/variants/2026/06/6a2fa39c004a5.png', 0, 2, '2026-06-15 07:02:52', '2026-06-15 07:02:52'),
(692, 295, 977, 'products/variants/2026/06/6a2fa39c03621.png', 0, 3, '2026-06-15 07:02:52', '2026-06-15 07:02:52'),
(693, 295, 976, 'products/variants/2026/06/6a2fa39c068f3.png', 0, 3, '2026-06-15 07:02:52', '2026-06-15 07:02:52'),
(694, 295, 974, 'products/variants/2026/06/6a2fa39c092da.png', 0, 3, '2026-06-15 07:02:52', '2026-06-15 07:02:52'),
(695, 296, 979, 'products/variants/2026/06/6a2fa39c0c5eb.png', 1, 0, '2026-06-15 07:02:52', '2026-06-15 07:02:52'),
(696, 296, 975, 'products/variants/2026/06/6a2fa39c0e74b.png', 1, 0, '2026-06-15 07:02:52', '2026-06-15 07:02:52'),
(697, 296, 979, 'products/variants/2026/06/6a2fa39c10958.png', 0, 1, '2026-06-15 07:02:52', '2026-06-15 07:02:52'),
(698, 296, 975, 'products/variants/2026/06/6a2fa39c133f5.png', 0, 1, '2026-06-15 07:02:52', '2026-06-15 07:02:52'),
(699, 296, 979, 'products/variants/2026/06/6a2fa39c16088.png', 0, 2, '2026-06-15 07:02:52', '2026-06-15 07:02:52'),
(700, 296, 975, 'products/variants/2026/06/6a2fa39c18481.png', 0, 2, '2026-06-15 07:02:52', '2026-06-15 07:02:52'),
(701, 296, 979, 'products/variants/2026/06/6a2fa39c1b1cb.png', 0, 3, '2026-06-15 07:02:52', '2026-06-15 07:02:52'),
(702, 296, 975, 'products/variants/2026/06/6a2fa39c1d80e.png', 0, 3, '2026-06-15 07:02:52', '2026-06-15 07:02:52'),
(703, 297, 977, 'products/variants/2026/06/6a2fa39c20810.png', 1, 0, '2026-06-15 07:02:52', '2026-06-15 07:02:52'),
(704, 297, 979, 'products/variants/2026/06/6a2fa39c24323.png', 1, 0, '2026-06-15 07:02:52', '2026-06-15 07:02:52'),
(705, 297, 975, 'products/variants/2026/06/6a2fa39c27cdc.png', 1, 0, '2026-06-15 07:02:52', '2026-06-15 07:02:52'),
(706, 297, 977, 'products/variants/2026/06/6a2fa39c2b111.png', 0, 1, '2026-06-15 07:02:52', '2026-06-15 07:02:52'),
(707, 297, 979, 'products/variants/2026/06/6a2fa39c2dc5f.png', 0, 1, '2026-06-15 07:02:52', '2026-06-15 07:02:52'),
(708, 297, 975, 'products/variants/2026/06/6a2fa39c304ee.png', 0, 1, '2026-06-15 07:02:52', '2026-06-15 07:02:52'),
(709, 297, 977, 'products/variants/2026/06/6a2fa39c331aa.png', 0, 2, '2026-06-15 07:02:52', '2026-06-15 07:02:52'),
(710, 297, 979, 'products/variants/2026/06/6a2fa39c359b5.png', 0, 2, '2026-06-15 07:02:52', '2026-06-15 07:02:52'),
(711, 297, 975, 'products/variants/2026/06/6a2fa39c3892b.png', 0, 2, '2026-06-15 07:02:52', '2026-06-15 07:02:52'),
(712, 297, 977, 'products/variants/2026/06/6a2fa39c3b6ee.png', 0, 3, '2026-06-15 07:02:52', '2026-06-15 07:02:52'),
(713, 297, 979, 'products/variants/2026/06/6a2fa39c3e10e.png', 0, 3, '2026-06-15 07:02:52', '2026-06-15 07:02:52'),
(714, 297, 975, 'products/variants/2026/06/6a2fa39c40c6e.png', 0, 3, '2026-06-15 07:02:52', '2026-06-15 07:02:52'),
(715, 298, 976, 'products/variants/2026/06/6a2fa39c43ab1.png', 1, 0, '2026-06-15 07:02:52', '2026-06-15 07:02:52'),
(716, 298, 978, 'products/variants/2026/06/6a2fa39c46811.png', 1, 0, '2026-06-15 07:02:52', '2026-06-15 07:02:52'),
(717, 298, 976, 'products/variants/2026/06/6a2fa39c49065.png', 0, 1, '2026-06-15 07:02:52', '2026-06-15 07:02:52'),
(718, 298, 978, 'products/variants/2026/06/6a2fa39c4bc69.png', 0, 1, '2026-06-15 07:02:52', '2026-06-15 07:02:52'),
(719, 298, 976, 'products/variants/2026/06/6a2fa39c4e97c.png', 0, 2, '2026-06-15 07:02:52', '2026-06-15 07:02:52'),
(720, 298, 978, 'products/variants/2026/06/6a2fa39c515b7.png', 0, 2, '2026-06-15 07:02:52', '2026-06-15 07:02:52'),
(721, 298, 976, 'products/variants/2026/06/6a2fa39c54542.png', 0, 3, '2026-06-15 07:02:52', '2026-06-15 07:02:52'),
(722, 298, 978, 'products/variants/2026/06/6a2fa39c57fb4.png', 0, 3, '2026-06-15 07:02:52', '2026-06-15 07:02:52'),
(723, 299, 981, 'products/variants/2026/06/6a2fa39c5eff5.png', 1, 0, '2026-06-15 07:02:52', '2026-06-15 07:02:52'),
(724, 299, 974, 'products/variants/2026/06/6a2fa39c62596.png', 0, 0, '2026-06-15 07:02:52', '2026-06-15 07:02:52'),
(725, 299, 975, 'products/variants/2026/06/6a2fa39c660ab.png', 1, 0, '2026-06-15 07:02:52', '2026-06-15 07:02:52'),
(726, 299, 981, 'products/variants/2026/06/6a2fa39c68e2e.png', 0, 1, '2026-06-15 07:02:52', '2026-06-15 07:02:52'),
(727, 299, 974, 'products/variants/2026/06/6a2fa39c6bdd3.png', 1, 1, '2026-06-15 07:02:52', '2026-06-15 07:02:52'),
(728, 299, 975, 'products/variants/2026/06/6a2fa39c6ef0c.png', 0, 1, '2026-06-15 07:02:52', '2026-06-15 07:02:52'),
(729, 299, 981, 'products/variants/2026/06/6a2fa39c71d07.png', 0, 2, '2026-06-15 07:02:52', '2026-06-15 07:02:52'),
(730, 299, 974, 'products/variants/2026/06/6a2fa39c7499b.png', 0, 2, '2026-06-15 07:02:52', '2026-06-15 07:02:52'),
(731, 299, 975, 'products/variants/2026/06/6a2fa39c78419.png', 0, 2, '2026-06-15 07:02:52', '2026-06-15 07:02:52'),
(732, 299, 981, 'products/variants/2026/06/6a2fa39c7b7f1.png', 0, 3, '2026-06-15 07:02:52', '2026-06-15 07:02:52'),
(733, 299, 974, 'products/variants/2026/06/6a2fa39c7f00c.png', 0, 3, '2026-06-15 07:02:52', '2026-06-15 07:02:52'),
(734, 299, 975, 'products/variants/2026/06/6a2fa39c81d14.png', 0, 3, '2026-06-15 07:02:52', '2026-06-15 07:02:52'),
(735, 300, 976, 'products/variants/2026/06/6a2fa39c851d3.png', 1, 0, '2026-06-15 07:02:52', '2026-06-15 07:02:52'),
(736, 300, 978, 'products/variants/2026/06/6a2fa39c88a1b.png', 1, 0, '2026-06-15 07:02:52', '2026-06-15 07:02:52'),
(737, 300, 975, 'products/variants/2026/06/6a2fa39c8be75.png', 0, 0, '2026-06-15 07:02:52', '2026-06-15 07:02:52'),
(738, 300, 976, 'products/variants/2026/06/6a2fa39c9016a.png', 0, 1, '2026-06-15 07:02:52', '2026-06-15 07:02:52'),
(739, 300, 978, 'products/variants/2026/06/6a2fa39c947c2.png', 0, 1, '2026-06-15 07:02:52', '2026-06-15 07:02:52'),
(740, 300, 975, 'products/variants/2026/06/6a2fa39c9859f.png', 1, 1, '2026-06-15 07:02:52', '2026-06-15 07:02:52'),
(741, 300, 976, 'products/variants/2026/06/6a2fa39c9e771.png', 0, 2, '2026-06-15 07:02:52', '2026-06-15 07:02:52'),
(742, 300, 978, 'products/variants/2026/06/6a2fa39ca263a.png', 0, 2, '2026-06-15 07:02:52', '2026-06-15 07:02:52'),
(743, 300, 975, 'products/variants/2026/06/6a2fa39ca5d89.png', 0, 2, '2026-06-15 07:02:52', '2026-06-15 07:02:52'),
(744, 300, 976, 'products/variants/2026/06/6a2fa39ca9256.png', 0, 3, '2026-06-15 07:02:52', '2026-06-15 07:02:52'),
(745, 300, 978, 'products/variants/2026/06/6a2fa39cad7ae.png', 0, 3, '2026-06-15 07:02:52', '2026-06-15 07:02:52'),
(746, 300, 975, 'products/variants/2026/06/6a2fa39cb15f6.png', 0, 3, '2026-06-15 07:02:52', '2026-06-15 07:02:52'),
(747, 301, 976, 'products/variants/2026/06/6a2fa39cb4d51.png', 1, 0, '2026-06-15 07:02:52', '2026-06-15 07:02:52'),
(748, 301, 979, 'products/variants/2026/06/6a2fa39cba284.png', 1, 0, '2026-06-15 07:02:52', '2026-06-15 07:02:52'),
(749, 301, 980, 'products/variants/2026/06/6a2fa39cbdea2.png', 1, 0, '2026-06-15 07:02:52', '2026-06-15 07:02:52'),
(750, 301, 976, 'products/variants/2026/06/6a2fa39cc1081.png', 0, 1, '2026-06-15 07:02:52', '2026-06-15 07:02:52'),
(751, 301, 979, 'products/variants/2026/06/6a2fa39cc43c4.png', 0, 1, '2026-06-15 07:02:52', '2026-06-15 07:02:52'),
(752, 301, 980, 'products/variants/2026/06/6a2fa39cc802b.png', 0, 1, '2026-06-15 07:02:52', '2026-06-15 07:02:52'),
(753, 301, 976, 'products/variants/2026/06/6a2fa39ccb6b4.png', 0, 2, '2026-06-15 07:02:52', '2026-06-15 07:02:52'),
(754, 301, 979, 'products/variants/2026/06/6a2fa39cce40b.png', 0, 2, '2026-06-15 07:02:52', '2026-06-15 07:02:52'),
(755, 301, 980, 'products/variants/2026/06/6a2fa39cd124a.png', 0, 2, '2026-06-15 07:02:52', '2026-06-15 07:02:52'),
(756, 301, 976, 'products/variants/2026/06/6a2fa39cd3fbf.png', 0, 3, '2026-06-15 07:02:52', '2026-06-15 07:02:52'),
(757, 301, 979, 'products/variants/2026/06/6a2fa39cd6bd7.png', 0, 3, '2026-06-15 07:02:52', '2026-06-15 07:02:52'),
(758, 301, 980, 'products/variants/2026/06/6a2fa39cd9540.png', 0, 3, '2026-06-15 07:02:52', '2026-06-15 07:02:52'),
(759, 302, 977, 'products/variants/2026/06/6a2fa39cdc0f8.png', 1, 0, '2026-06-15 07:02:52', '2026-06-15 07:02:52'),
(760, 302, 975, 'products/variants/2026/06/6a2fa39cdeb09.png', 1, 0, '2026-06-15 07:02:52', '2026-06-15 07:02:52'),
(761, 302, 977, 'products/variants/2026/06/6a2fa39ce1a47.png', 0, 1, '2026-06-15 07:02:52', '2026-06-15 07:02:52'),
(762, 302, 975, 'products/variants/2026/06/6a2fa39ce4ba5.png', 0, 1, '2026-06-15 07:02:52', '2026-06-15 07:02:52'),
(763, 302, 977, 'products/variants/2026/06/6a2fa39ce80b4.png', 0, 2, '2026-06-15 07:02:52', '2026-06-15 07:02:52'),
(764, 302, 975, 'products/variants/2026/06/6a2fa39ceb28b.png', 0, 2, '2026-06-15 07:02:52', '2026-06-15 07:02:52'),
(765, 302, 977, 'products/variants/2026/06/6a2fa39ceec8c.png', 0, 3, '2026-06-15 07:02:52', '2026-06-15 07:02:52'),
(766, 302, 975, 'products/variants/2026/06/6a2fa39cf1f31.png', 0, 3, '2026-06-15 07:02:52', '2026-06-15 07:02:52'),
(767, 303, 979, 'products/variants/2026/06/6a2fa39d005fe.png', 0, 0, '2026-06-15 07:02:53', '2026-06-15 07:02:53'),
(768, 303, 974, 'products/variants/2026/06/6a2fa39d02ec7.png', 1, 0, '2026-06-15 07:02:53', '2026-06-15 07:02:53'),
(769, 303, 975, 'products/variants/2026/06/6a2fa39d059a5.png', 1, 0, '2026-06-15 07:02:53', '2026-06-15 07:02:53'),
(770, 303, 980, 'products/variants/2026/06/6a2fa39d0865c.png', 1, 0, '2026-06-15 07:02:53', '2026-06-15 07:02:53'),
(771, 303, 979, 'products/variants/2026/06/6a2fa39d0c561.png', 1, 1, '2026-06-15 07:02:53', '2026-06-15 07:02:53'),
(772, 303, 974, 'products/variants/2026/06/6a2fa39d0f44e.png', 0, 1, '2026-06-15 07:02:53', '2026-06-15 07:02:53'),
(773, 303, 975, 'products/variants/2026/06/6a2fa39d12cdb.png', 0, 1, '2026-06-15 07:02:53', '2026-06-15 07:02:53'),
(774, 303, 980, 'products/variants/2026/06/6a2fa39d16d65.png', 0, 1, '2026-06-15 07:02:53', '2026-06-15 07:02:53'),
(775, 303, 979, 'products/variants/2026/06/6a2fa39d1ae37.png', 0, 2, '2026-06-15 07:02:53', '2026-06-15 07:02:53'),
(776, 303, 974, 'products/variants/2026/06/6a2fa39d1f175.png', 0, 2, '2026-06-15 07:02:53', '2026-06-15 07:02:53'),
(777, 303, 975, 'products/variants/2026/06/6a2fa39d24e7e.png', 0, 2, '2026-06-15 07:02:53', '2026-06-15 07:02:53'),
(778, 303, 980, 'products/variants/2026/06/6a2fa39d29870.png', 0, 2, '2026-06-15 07:02:53', '2026-06-15 07:02:53'),
(779, 303, 979, 'products/variants/2026/06/6a2fa39d2d9f0.png', 0, 3, '2026-06-15 07:02:53', '2026-06-15 07:02:53'),
(780, 303, 974, 'products/variants/2026/06/6a2fa39d315fd.png', 0, 3, '2026-06-15 07:02:53', '2026-06-15 07:02:53'),
(781, 303, 975, 'products/variants/2026/06/6a2fa39d3d045.png', 0, 3, '2026-06-15 07:02:53', '2026-06-15 07:02:53'),
(782, 303, 980, 'products/variants/2026/06/6a2fa39d3f723.png', 0, 3, '2026-06-15 07:02:53', '2026-06-15 07:02:53'),
(783, 304, 977, 'products/variants/2026/06/6a2fa39d418a7.png', 1, 0, '2026-06-15 07:02:53', '2026-06-15 07:02:53'),
(784, 304, 976, 'products/variants/2026/06/6a2fa39d43da2.png', 1, 0, '2026-06-15 07:02:53', '2026-06-15 07:02:53'),
(785, 304, 977, 'products/variants/2026/06/6a2fa39d45e36.png', 0, 1, '2026-06-15 07:02:53', '2026-06-15 07:02:53'),
(786, 304, 976, 'products/variants/2026/06/6a2fa39d48846.png', 0, 1, '2026-06-15 07:02:53', '2026-06-15 07:02:53'),
(787, 304, 977, 'products/variants/2026/06/6a2fa39d4a851.png', 0, 2, '2026-06-15 07:02:53', '2026-06-15 07:02:53'),
(788, 304, 976, 'products/variants/2026/06/6a2fa39d4c9e4.png', 0, 2, '2026-06-15 07:02:53', '2026-06-15 07:02:53'),
(789, 304, 977, 'products/variants/2026/06/6a2fa39d4e5bb.png', 0, 3, '2026-06-15 07:02:53', '2026-06-15 07:02:53'),
(790, 304, 976, 'products/variants/2026/06/6a2fa39d50b63.png', 0, 3, '2026-06-15 07:02:53', '2026-06-15 07:02:53'),
(791, 305, 976, 'products/variants/2026/06/6a2fa39d528b9.png', 1, 0, '2026-06-15 07:02:53', '2026-06-15 07:02:53'),
(792, 305, 979, 'products/variants/2026/06/6a2fa39d545c5.png', 1, 0, '2026-06-15 07:02:53', '2026-06-15 07:02:53'),
(793, 305, 975, 'products/variants/2026/06/6a2fa39d55bd8.png', 1, 0, '2026-06-15 07:02:53', '2026-06-15 07:02:53'),
(794, 305, 976, 'products/variants/2026/06/6a2fa39d57401.png', 0, 1, '2026-06-15 07:02:53', '2026-06-15 07:02:53'),
(795, 305, 979, 'products/variants/2026/06/6a2fa39d590fb.png', 0, 1, '2026-06-15 07:02:53', '2026-06-15 07:02:53'),
(796, 305, 975, 'products/variants/2026/06/6a2fa39d5a68f.png', 0, 1, '2026-06-15 07:02:53', '2026-06-15 07:02:53'),
(797, 305, 976, 'products/variants/2026/06/6a2fa39d5c1dd.png', 0, 2, '2026-06-15 07:02:53', '2026-06-15 07:02:53'),
(798, 305, 979, 'products/variants/2026/06/6a2fa39d5db3e.png', 0, 2, '2026-06-15 07:02:53', '2026-06-15 07:02:53'),
(799, 305, 975, 'products/variants/2026/06/6a2fa39d5f5ab.png', 0, 2, '2026-06-15 07:02:53', '2026-06-15 07:02:53'),
(800, 305, 976, 'products/variants/2026/06/6a2fa39d6119b.png', 0, 3, '2026-06-15 07:02:53', '2026-06-15 07:02:53'),
(801, 305, 979, 'products/variants/2026/06/6a2fa39d629b3.png', 0, 3, '2026-06-15 07:02:53', '2026-06-15 07:02:53'),
(802, 305, 975, 'products/variants/2026/06/6a2fa39d63dbc.png', 0, 3, '2026-06-15 07:02:53', '2026-06-15 07:02:53'),
(803, 306, 976, 'products/variants/2026/06/6a2fa39d65415.png', 1, 0, '2026-06-15 07:02:53', '2026-06-15 07:02:53'),
(804, 306, 974, 'products/variants/2026/06/6a2fa39d66f2f.png', 1, 0, '2026-06-15 07:02:53', '2026-06-15 07:02:53'),
(805, 306, 980, 'products/variants/2026/06/6a2fa39d69208.png', 1, 0, '2026-06-15 07:02:53', '2026-06-15 07:02:53'),
(806, 306, 976, 'products/variants/2026/06/6a2fa39d6b28f.png', 0, 1, '2026-06-15 07:02:53', '2026-06-15 07:02:53'),
(807, 306, 974, 'products/variants/2026/06/6a2fa39d6de1f.png', 0, 1, '2026-06-15 07:02:53', '2026-06-15 07:02:53'),
(808, 306, 980, 'products/variants/2026/06/6a2fa39d701be.png', 0, 1, '2026-06-15 07:02:53', '2026-06-15 07:02:53'),
(809, 306, 976, 'products/variants/2026/06/6a2fa39d720dd.png', 0, 2, '2026-06-15 07:02:53', '2026-06-15 07:02:53'),
(810, 306, 974, 'products/variants/2026/06/6a2fa39d7407c.png', 0, 2, '2026-06-15 07:02:53', '2026-06-15 07:02:53'),
(811, 306, 980, 'products/variants/2026/06/6a2fa39d76398.png', 0, 2, '2026-06-15 07:02:53', '2026-06-15 07:02:53'),
(812, 306, 976, 'products/variants/2026/06/6a2fa39d7833e.png', 0, 3, '2026-06-15 07:02:53', '2026-06-15 07:02:53'),
(813, 306, 974, 'products/variants/2026/06/6a2fa39d7a4dc.png', 0, 3, '2026-06-15 07:02:53', '2026-06-15 07:02:53'),
(814, 306, 980, 'products/variants/2026/06/6a2fa39d7c983.png', 0, 3, '2026-06-15 07:02:53', '2026-06-15 07:02:53'),
(815, 282, 976, 'products/variants/2026/06/6a438bd3b33c8.png', 1, 0, '2026-06-30 09:26:43', '2026-06-30 09:26:43'),
(816, 282, 979, 'products/variants/2026/06/6a438bd3b714b.png', 1, 0, '2026-06-30 09:26:43', '2026-06-30 09:26:43'),
(817, 282, 975, 'products/variants/2026/06/6a438bd3ba7eb.png', 1, 0, '2026-06-30 09:26:43', '2026-06-30 09:26:43'),
(818, 282, 976, 'products/variants/2026/06/6a438bd3bd09a.png', 0, 1, '2026-06-30 09:26:43', '2026-06-30 09:26:43'),
(819, 282, 979, 'products/variants/2026/06/6a438bd3c025e.png', 0, 1, '2026-06-30 09:26:43', '2026-06-30 09:26:43'),
(820, 282, 975, 'products/variants/2026/06/6a438bd3c34f4.png', 0, 1, '2026-06-30 09:26:43', '2026-06-30 09:26:43'),
(821, 282, 976, 'products/variants/2026/06/6a438bd3c62b3.png', 0, 2, '2026-06-30 09:26:43', '2026-06-30 09:26:43'),
(822, 282, 979, 'products/variants/2026/06/6a438bd3c8dc7.png', 0, 2, '2026-06-30 09:26:43', '2026-06-30 09:26:43'),
(823, 282, 975, 'products/variants/2026/06/6a438bd3cbaa6.png', 0, 2, '2026-06-30 09:26:43', '2026-06-30 09:26:43'),
(824, 282, 976, 'products/variants/2026/06/6a438bd3ce72f.png', 0, 3, '2026-06-30 09:26:43', '2026-06-30 09:26:43'),
(825, 282, 979, 'products/variants/2026/06/6a438bd3d1a1d.png', 0, 3, '2026-06-30 09:26:43', '2026-06-30 09:26:43'),
(826, 282, 975, 'products/variants/2026/06/6a438bd3d49c0.png', 0, 3, '2026-06-30 09:26:43', '2026-06-30 09:26:43'),
(827, 283, 977, 'products/variants/2026/06/6a438bd3d7d37.png', 1, 0, '2026-06-30 09:26:43', '2026-06-30 09:26:43'),
(828, 283, 976, 'products/variants/2026/06/6a438bd3daac1.png', 1, 0, '2026-06-30 09:26:43', '2026-06-30 09:26:43'),
(829, 283, 974, 'products/variants/2026/06/6a438bd3e4bb9.png', 1, 0, '2026-06-30 09:26:43', '2026-06-30 09:26:43'),
(830, 283, 977, 'products/variants/2026/06/6a438bd3e88d1.png', 0, 1, '2026-06-30 09:26:43', '2026-06-30 09:26:43'),
(831, 283, 976, 'products/variants/2026/06/6a438bd3eca17.png', 0, 1, '2026-06-30 09:26:43', '2026-06-30 09:26:43'),
(832, 283, 974, 'products/variants/2026/06/6a438bd3eff02.png', 0, 1, '2026-06-30 09:26:43', '2026-06-30 09:26:43'),
(833, 283, 977, 'products/variants/2026/06/6a438bd3f3376.png', 0, 2, '2026-06-30 09:26:44', '2026-06-30 09:26:44'),
(834, 283, 976, 'products/variants/2026/06/6a438bd402744.png', 0, 2, '2026-06-30 09:26:44', '2026-06-30 09:26:44'),
(835, 283, 974, 'products/variants/2026/06/6a438bd406814.png', 0, 2, '2026-06-30 09:26:44', '2026-06-30 09:26:44'),
(836, 283, 977, 'products/variants/2026/06/6a438bd40a1d3.png', 0, 3, '2026-06-30 09:26:44', '2026-06-30 09:26:44'),
(837, 283, 976, 'products/variants/2026/06/6a438bd40d952.png', 0, 3, '2026-06-30 09:26:44', '2026-06-30 09:26:44'),
(838, 283, 974, 'products/variants/2026/06/6a438bd410edb.png', 0, 3, '2026-06-30 09:26:44', '2026-06-30 09:26:44'),
(839, 284, 979, 'products/variants/2026/06/6a438bd4144a5.png', 0, 0, '2026-06-30 09:26:44', '2026-06-30 09:26:44'),
(840, 284, 975, 'products/variants/2026/06/6a438bd417d12.png', 1, 0, '2026-06-30 09:26:44', '2026-06-30 09:26:44'),
(841, 284, 980, 'products/variants/2026/06/6a438bd41ad2d.png', 1, 0, '2026-06-30 09:26:44', '2026-06-30 09:26:44'),
(842, 284, 979, 'products/variants/2026/06/6a438bd41e584.png', 1, 1, '2026-06-30 09:26:44', '2026-06-30 09:26:44'),
(843, 284, 975, 'products/variants/2026/06/6a438bd421dd3.png', 0, 1, '2026-06-30 09:26:44', '2026-06-30 09:26:44'),
(844, 284, 980, 'products/variants/2026/06/6a438bd425cda.png', 0, 1, '2026-06-30 09:26:44', '2026-06-30 09:26:44'),
(845, 284, 979, 'products/variants/2026/06/6a438bd429584.png', 0, 2, '2026-06-30 09:26:44', '2026-06-30 09:26:44'),
(846, 284, 975, 'products/variants/2026/06/6a438bd42cd18.png', 0, 2, '2026-06-30 09:26:44', '2026-06-30 09:26:44'),
(847, 284, 980, 'products/variants/2026/06/6a438bd4303e0.png', 0, 2, '2026-06-30 09:26:44', '2026-06-30 09:26:44'),
(848, 284, 979, 'products/variants/2026/06/6a438bd433f59.png', 0, 3, '2026-06-30 09:26:44', '2026-06-30 09:26:44'),
(849, 284, 975, 'products/variants/2026/06/6a438bd436f33.png', 0, 3, '2026-06-30 09:26:44', '2026-06-30 09:26:44'),
(850, 284, 980, 'products/variants/2026/06/6a438bd439b6a.png', 0, 3, '2026-06-30 09:26:44', '2026-06-30 09:26:44'),
(851, 285, 976, 'products/variants/2026/06/6a438bd43d028.png', 1, 0, '2026-06-30 09:26:44', '2026-06-30 09:26:44'),
(852, 285, 975, 'products/variants/2026/06/6a438bd440203.png', 1, 0, '2026-06-30 09:26:44', '2026-06-30 09:26:44'),
(853, 285, 976, 'products/variants/2026/06/6a438bd4434cc.png', 0, 1, '2026-06-30 09:26:44', '2026-06-30 09:26:44'),
(854, 285, 975, 'products/variants/2026/06/6a438bd446cf1.png', 0, 1, '2026-06-30 09:26:44', '2026-06-30 09:26:44'),
(855, 285, 976, 'products/variants/2026/06/6a438bd44a672.png', 0, 2, '2026-06-30 09:26:44', '2026-06-30 09:26:44'),
(856, 285, 975, 'products/variants/2026/06/6a438bd44ec74.png', 0, 2, '2026-06-30 09:26:44', '2026-06-30 09:26:44'),
(857, 285, 976, 'products/variants/2026/06/6a438bd45206a.png', 0, 3, '2026-06-30 09:26:44', '2026-06-30 09:26:44'),
(858, 285, 975, 'products/variants/2026/06/6a438bd454f42.png', 0, 3, '2026-06-30 09:26:44', '2026-06-30 09:26:44'),
(859, 286, 977, 'products/variants/2026/06/6a438bd457748.png', 1, 0, '2026-06-30 09:26:44', '2026-06-30 09:26:44'),
(860, 286, 976, 'products/variants/2026/06/6a438bd45aacb.png', 1, 0, '2026-06-30 09:26:44', '2026-06-30 09:26:44'),
(861, 286, 975, 'products/variants/2026/06/6a438bd45dfbb.png', 1, 0, '2026-06-30 09:26:44', '2026-06-30 09:26:44'),
(862, 286, 977, 'products/variants/2026/06/6a438bd461740.png', 0, 1, '2026-06-30 09:26:44', '2026-06-30 09:26:44'),
(863, 286, 976, 'products/variants/2026/06/6a438bd4654e4.png', 0, 1, '2026-06-30 09:26:44', '2026-06-30 09:26:44'),
(864, 286, 975, 'products/variants/2026/06/6a438bd468841.png', 0, 1, '2026-06-30 09:26:44', '2026-06-30 09:26:44'),
(865, 286, 977, 'products/variants/2026/06/6a438bd46b2f7.png', 0, 2, '2026-06-30 09:26:44', '2026-06-30 09:26:44'),
(866, 286, 976, 'products/variants/2026/06/6a438bd46e6bb.png', 0, 2, '2026-06-30 09:26:44', '2026-06-30 09:26:44'),
(867, 286, 975, 'products/variants/2026/06/6a438bd471b2f.png', 0, 2, '2026-06-30 09:26:44', '2026-06-30 09:26:44'),
(868, 286, 977, 'products/variants/2026/06/6a438bd474f3e.png', 0, 3, '2026-06-30 09:26:44', '2026-06-30 09:26:44'),
(869, 286, 976, 'products/variants/2026/06/6a438bd4775b4.png', 0, 3, '2026-06-30 09:26:44', '2026-06-30 09:26:44'),
(870, 286, 975, 'products/variants/2026/06/6a438bd47a9b9.png', 0, 3, '2026-06-30 09:26:44', '2026-06-30 09:26:44'),
(871, 287, 979, 'products/variants/2026/06/6a438bd47e153.png', 1, 0, '2026-06-30 09:26:44', '2026-06-30 09:26:44'),
(872, 287, 975, 'products/variants/2026/06/6a438bd4817b1.png', 1, 0, '2026-06-30 09:26:44', '2026-06-30 09:26:44'),
(873, 287, 979, 'products/variants/2026/06/6a438bd4851be.png', 0, 1, '2026-06-30 09:26:44', '2026-06-30 09:26:44'),
(874, 287, 975, 'products/variants/2026/06/6a438bd488cb2.png', 0, 1, '2026-06-30 09:26:44', '2026-06-30 09:26:44'),
(875, 287, 979, 'products/variants/2026/06/6a438bd48c1e6.png', 0, 2, '2026-06-30 09:26:44', '2026-06-30 09:26:44'),
(876, 287, 975, 'products/variants/2026/06/6a438bd48f948.png', 0, 2, '2026-06-30 09:26:44', '2026-06-30 09:26:44'),
(877, 287, 979, 'products/variants/2026/06/6a438bd49324b.png', 0, 3, '2026-06-30 09:26:44', '2026-06-30 09:26:44'),
(878, 287, 975, 'products/variants/2026/06/6a438bd4967ba.png', 0, 3, '2026-06-30 09:26:44', '2026-06-30 09:26:44'),
(879, 288, 974, 'products/variants/2026/06/6a438bd499a99.png', 1, 0, '2026-06-30 09:26:44', '2026-06-30 09:26:44'),
(880, 288, 980, 'products/variants/2026/06/6a438bd49d318.png', 1, 0, '2026-06-30 09:26:44', '2026-06-30 09:26:44'),
(881, 288, 974, 'products/variants/2026/06/6a438bd4a0474.png', 0, 1, '2026-06-30 09:26:44', '2026-06-30 09:26:44'),
(882, 288, 980, 'products/variants/2026/06/6a438bd4a3527.png', 0, 1, '2026-06-30 09:26:44', '2026-06-30 09:26:44'),
(883, 288, 974, 'products/variants/2026/06/6a438bd4a6421.png', 0, 2, '2026-06-30 09:26:44', '2026-06-30 09:26:44'),
(884, 288, 980, 'products/variants/2026/06/6a438bd4a935c.png', 0, 2, '2026-06-30 09:26:44', '2026-06-30 09:26:44'),
(885, 288, 974, 'products/variants/2026/06/6a438bd4ac1ba.png', 0, 3, '2026-06-30 09:26:44', '2026-06-30 09:26:44'),
(886, 288, 980, 'products/variants/2026/06/6a438bd4af55f.png', 0, 3, '2026-06-30 09:26:44', '2026-06-30 09:26:44'),
(887, 289, 976, 'products/variants/2026/06/6a438bd4b2672.png', 1, 0, '2026-06-30 09:26:44', '2026-06-30 09:26:44'),
(888, 289, 975, 'products/variants/2026/06/6a438bd4b53dc.png', 1, 0, '2026-06-30 09:26:44', '2026-06-30 09:26:44'),
(889, 289, 976, 'products/variants/2026/06/6a438bd4b7dd1.png', 0, 1, '2026-06-30 09:26:44', '2026-06-30 09:26:44'),
(890, 289, 975, 'products/variants/2026/06/6a438bd4bb675.png', 0, 1, '2026-06-30 09:26:44', '2026-06-30 09:26:44'),
(891, 289, 976, 'products/variants/2026/06/6a438bd4bea22.png', 0, 2, '2026-06-30 09:26:44', '2026-06-30 09:26:44'),
(892, 289, 975, 'products/variants/2026/06/6a438bd4c20a7.png', 0, 2, '2026-06-30 09:26:44', '2026-06-30 09:26:44'),
(893, 289, 976, 'products/variants/2026/06/6a438bd4c54d9.png', 0, 3, '2026-06-30 09:26:44', '2026-06-30 09:26:44'),
(894, 289, 975, 'products/variants/2026/06/6a438bd4c8785.png', 0, 3, '2026-06-30 09:26:44', '2026-06-30 09:26:44'),
(895, 290, 980, 'products/variants/2026/06/6a438bd4cb980.png', 1, 0, '2026-06-30 09:26:44', '2026-06-30 09:26:44'),
(896, 290, 978, 'products/variants/2026/06/6a438bd4cebb6.png', 1, 0, '2026-06-30 09:26:44', '2026-06-30 09:26:44'),
(897, 290, 979, 'products/variants/2026/06/6a438bd4d1bfd.png', 1, 0, '2026-06-30 09:26:44', '2026-06-30 09:26:44'),
(898, 290, 980, 'products/variants/2026/06/6a438bd4d4c25.png', 0, 1, '2026-06-30 09:26:44', '2026-06-30 09:26:44'),
(899, 290, 978, 'products/variants/2026/06/6a438bd4d860e.png', 0, 1, '2026-06-30 09:26:44', '2026-06-30 09:26:44'),
(900, 290, 979, 'products/variants/2026/06/6a438bd4db8a7.png', 0, 1, '2026-06-30 09:26:44', '2026-06-30 09:26:44'),
(901, 290, 980, 'products/variants/2026/06/6a438bd4e09a4.png', 0, 2, '2026-06-30 09:26:44', '2026-06-30 09:26:44'),
(902, 290, 978, 'products/variants/2026/06/6a438bd4e7615.png', 0, 2, '2026-06-30 09:26:44', '2026-06-30 09:26:44'),
(903, 290, 979, 'products/variants/2026/06/6a438bd4eaaba.png', 0, 2, '2026-06-30 09:26:44', '2026-06-30 09:26:44'),
(904, 290, 979, 'products/variants/2026/06/6a438bd4ee16b.png', 0, 3, '2026-06-30 09:26:44', '2026-06-30 09:26:44'),
(905, 290, 980, 'products/variants/2026/06/6a438bd4f111d.png', 0, 3, '2026-06-30 09:26:44', '2026-06-30 09:26:44'),
(906, 290, 978, 'products/variants/2026/06/6a438bd500471.png', 0, 3, '2026-06-30 09:26:45', '2026-06-30 09:26:45'),
(907, 291, 977, 'products/variants/2026/06/6a438bd5032e3.png', 1, 0, '2026-06-30 09:26:45', '2026-06-30 09:26:45'),
(908, 291, 976, 'products/variants/2026/06/6a438bd506500.png', 1, 0, '2026-06-30 09:26:45', '2026-06-30 09:26:45'),
(909, 291, 977, 'products/variants/2026/06/6a438bd509996.png', 0, 1, '2026-06-30 09:26:45', '2026-06-30 09:26:45'),
(910, 291, 976, 'products/variants/2026/06/6a438bd50cdcb.png', 0, 1, '2026-06-30 09:26:45', '2026-06-30 09:26:45'),
(911, 291, 977, 'products/variants/2026/06/6a438bd50ffaf.png', 0, 2, '2026-06-30 09:26:45', '2026-06-30 09:26:45'),
(912, 291, 976, 'products/variants/2026/06/6a438bd5130d7.png', 0, 2, '2026-06-30 09:26:45', '2026-06-30 09:26:45'),
(913, 291, 977, 'products/variants/2026/06/6a438bd516373.png', 0, 3, '2026-06-30 09:26:45', '2026-06-30 09:26:45'),
(914, 291, 976, 'products/variants/2026/06/6a438bd519be8.png', 0, 3, '2026-06-30 09:26:45', '2026-06-30 09:26:45'),
(915, 292, 976, 'products/variants/2026/06/6a438bd51d22a.png', 1, 0, '2026-06-30 09:26:45', '2026-06-30 09:26:45'),
(916, 292, 979, 'products/variants/2026/06/6a438bd52074b.png', 1, 0, '2026-06-30 09:26:45', '2026-06-30 09:26:45'),
(917, 292, 975, 'products/variants/2026/06/6a438bd52360a.png', 1, 0, '2026-06-30 09:26:45', '2026-06-30 09:26:45'),
(918, 292, 976, 'products/variants/2026/06/6a438bd526474.png', 0, 1, '2026-06-30 09:26:45', '2026-06-30 09:26:45'),
(919, 292, 979, 'products/variants/2026/06/6a438bd528ed5.png', 0, 1, '2026-06-30 09:26:45', '2026-06-30 09:26:45'),
(920, 292, 975, 'products/variants/2026/06/6a438bd52b940.png', 0, 1, '2026-06-30 09:26:45', '2026-06-30 09:26:45'),
(921, 292, 976, 'products/variants/2026/06/6a438bd52e6b0.png', 0, 2, '2026-06-30 09:26:45', '2026-06-30 09:26:45'),
(922, 292, 979, 'products/variants/2026/06/6a438bd530dc3.png', 0, 2, '2026-06-30 09:26:45', '2026-06-30 09:26:45'),
(923, 292, 975, 'products/variants/2026/06/6a438bd53377b.png', 0, 2, '2026-06-30 09:26:45', '2026-06-30 09:26:45'),
(924, 292, 976, 'products/variants/2026/06/6a438bd53619b.png', 0, 3, '2026-06-30 09:26:45', '2026-06-30 09:26:45'),
(925, 292, 979, 'products/variants/2026/06/6a438bd539007.png', 0, 3, '2026-06-30 09:26:45', '2026-06-30 09:26:45'),
(926, 292, 975, 'products/variants/2026/06/6a438bd53bdc5.png', 0, 3, '2026-06-30 09:26:45', '2026-06-30 09:26:45'),
(927, 293, 981, 'products/variants/2026/06/6a438bd53e7ff.png', 1, 0, '2026-06-30 09:26:45', '2026-06-30 09:26:45'),
(928, 293, 979, 'products/variants/2026/06/6a438bd541d6a.png', 1, 0, '2026-06-30 09:26:45', '2026-06-30 09:26:45'),
(929, 293, 974, 'products/variants/2026/06/6a438bd545035.png', 1, 0, '2026-06-30 09:26:45', '2026-06-30 09:26:45'),
(930, 293, 981, 'products/variants/2026/06/6a438bd548d4a.png', 0, 1, '2026-06-30 09:26:45', '2026-06-30 09:26:45'),
(931, 293, 979, 'products/variants/2026/06/6a438bd54ba6b.png', 0, 1, '2026-06-30 09:26:45', '2026-06-30 09:26:45'),
(932, 293, 974, 'products/variants/2026/06/6a438bd54f9f6.png', 0, 1, '2026-06-30 09:26:45', '2026-06-30 09:26:45'),
(933, 293, 981, 'products/variants/2026/06/6a438bd5528c9.png', 0, 2, '2026-06-30 09:26:45', '2026-06-30 09:26:45'),
(934, 293, 979, 'products/variants/2026/06/6a438bd5564a2.png', 0, 2, '2026-06-30 09:26:45', '2026-06-30 09:26:45'),
(935, 293, 974, 'products/variants/2026/06/6a438bd559ad4.png', 0, 2, '2026-06-30 09:26:45', '2026-06-30 09:26:45'),
(936, 293, 981, 'products/variants/2026/06/6a438bd55d0c3.png', 0, 3, '2026-06-30 09:26:45', '2026-06-30 09:26:45'),
(937, 293, 979, 'products/variants/2026/06/6a438bd56082f.png', 0, 3, '2026-06-30 09:26:45', '2026-06-30 09:26:45'),
(938, 293, 974, 'products/variants/2026/06/6a438bd563e9e.png', 0, 3, '2026-06-30 09:26:45', '2026-06-30 09:26:45'),
(939, 294, 978, 'products/variants/2026/06/6a438bd56763f.png', 1, 0, '2026-06-30 09:26:45', '2026-06-30 09:26:45'),
(940, 294, 981, 'products/variants/2026/06/6a438bd56abd2.png', 1, 0, '2026-06-30 09:26:45', '2026-06-30 09:26:45'),
(941, 294, 980, 'products/variants/2026/06/6a438bd56ddc7.png', 0, 0, '2026-06-30 09:26:45', '2026-06-30 09:26:45'),
(942, 294, 978, 'products/variants/2026/06/6a438bd5717b8.png', 0, 1, '2026-06-30 09:26:45', '2026-06-30 09:26:45'),
(943, 294, 981, 'products/variants/2026/06/6a438bd5750cf.png', 0, 1, '2026-06-30 09:26:45', '2026-06-30 09:26:45'),
(944, 294, 980, 'products/variants/2026/06/6a438bd5781ee.png', 1, 1, '2026-06-30 09:26:45', '2026-06-30 09:26:45'),
(945, 294, 978, 'products/variants/2026/06/6a438bd57adf5.png', 0, 2, '2026-06-30 09:26:45', '2026-06-30 09:26:45'),
(946, 294, 981, 'products/variants/2026/06/6a438bd57da80.png', 0, 2, '2026-06-30 09:26:45', '2026-06-30 09:26:45'),
(947, 294, 980, 'products/variants/2026/06/6a438bd5807bf.png', 0, 2, '2026-06-30 09:26:45', '2026-06-30 09:26:45'),
(948, 294, 978, 'products/variants/2026/06/6a438bd583092.png', 0, 3, '2026-06-30 09:26:45', '2026-06-30 09:26:45'),
(949, 294, 981, 'products/variants/2026/06/6a438bd58669d.png', 0, 3, '2026-06-30 09:26:45', '2026-06-30 09:26:45'),
(950, 294, 980, 'products/variants/2026/06/6a438bd589479.png', 0, 3, '2026-06-30 09:26:45', '2026-06-30 09:26:45'),
(951, 295, 977, 'products/variants/2026/06/6a438bd58bd4f.png', 1, 0, '2026-06-30 09:26:45', '2026-06-30 09:26:45'),
(952, 295, 976, 'products/variants/2026/06/6a438bd58ea8d.png', 1, 0, '2026-06-30 09:26:45', '2026-06-30 09:26:45'),
(953, 295, 974, 'products/variants/2026/06/6a438bd591684.png', 1, 0, '2026-06-30 09:26:45', '2026-06-30 09:26:45'),
(954, 295, 977, 'products/variants/2026/06/6a438bd5943d4.png', 0, 1, '2026-06-30 09:26:45', '2026-06-30 09:26:45'),
(955, 295, 976, 'products/variants/2026/06/6a438bd597470.png', 0, 1, '2026-06-30 09:26:45', '2026-06-30 09:26:45'),
(956, 295, 974, 'products/variants/2026/06/6a438bd59a678.png', 0, 1, '2026-06-30 09:26:45', '2026-06-30 09:26:45'),
(957, 295, 977, 'products/variants/2026/06/6a438bd59cd42.png', 0, 2, '2026-06-30 09:26:45', '2026-06-30 09:26:45'),
(958, 295, 976, 'products/variants/2026/06/6a438bd59fd3e.png', 0, 2, '2026-06-30 09:26:45', '2026-06-30 09:26:45'),
(959, 295, 974, 'products/variants/2026/06/6a438bd5a28d1.png', 0, 2, '2026-06-30 09:26:45', '2026-06-30 09:26:45'),
(960, 295, 977, 'products/variants/2026/06/6a438bd5a4faf.png', 0, 3, '2026-06-30 09:26:45', '2026-06-30 09:26:45'),
(961, 295, 976, 'products/variants/2026/06/6a438bd5a7c83.png', 0, 3, '2026-06-30 09:26:45', '2026-06-30 09:26:45'),
(962, 295, 974, 'products/variants/2026/06/6a438bd5aa1a0.png', 0, 3, '2026-06-30 09:26:45', '2026-06-30 09:26:45'),
(963, 296, 979, 'products/variants/2026/06/6a438bd5ac7b2.png', 1, 0, '2026-06-30 09:26:45', '2026-06-30 09:26:45'),
(964, 296, 975, 'products/variants/2026/06/6a438bd5ae911.png', 1, 0, '2026-06-30 09:26:45', '2026-06-30 09:26:45'),
(965, 296, 979, 'products/variants/2026/06/6a438bd5b098f.png', 0, 1, '2026-06-30 09:26:45', '2026-06-30 09:26:45'),
(966, 296, 975, 'products/variants/2026/06/6a438bd5b2f85.png', 0, 1, '2026-06-30 09:26:45', '2026-06-30 09:26:45'),
(967, 296, 979, 'products/variants/2026/06/6a438bd5b4e83.png', 0, 2, '2026-06-30 09:26:45', '2026-06-30 09:26:45'),
(968, 296, 975, 'products/variants/2026/06/6a438bd5b70ad.png', 0, 2, '2026-06-30 09:26:45', '2026-06-30 09:26:45'),
(969, 296, 979, 'products/variants/2026/06/6a438bd5b9381.png', 0, 3, '2026-06-30 09:26:45', '2026-06-30 09:26:45'),
(970, 296, 975, 'products/variants/2026/06/6a438bd5bb614.png', 0, 3, '2026-06-30 09:26:45', '2026-06-30 09:26:45'),
(971, 297, 977, 'products/variants/2026/06/6a438bd5bd93b.png', 1, 0, '2026-06-30 09:26:45', '2026-06-30 09:26:45'),
(972, 297, 979, 'products/variants/2026/06/6a438bd5bfb35.png', 1, 0, '2026-06-30 09:26:45', '2026-06-30 09:26:45'),
(973, 297, 975, 'products/variants/2026/06/6a438bd5c1f98.png', 1, 0, '2026-06-30 09:26:45', '2026-06-30 09:26:45'),
(974, 297, 977, 'products/variants/2026/06/6a438bd5c41d3.png', 0, 1, '2026-06-30 09:26:45', '2026-06-30 09:26:45'),
(975, 297, 979, 'products/variants/2026/06/6a438bd5c6dd8.png', 0, 1, '2026-06-30 09:26:45', '2026-06-30 09:26:45'),
(976, 297, 975, 'products/variants/2026/06/6a438bd5c9113.png', 0, 1, '2026-06-30 09:26:45', '2026-06-30 09:26:45'),
(977, 297, 977, 'products/variants/2026/06/6a438bd5cb746.png', 0, 2, '2026-06-30 09:26:45', '2026-06-30 09:26:45'),
(978, 297, 979, 'products/variants/2026/06/6a438bd5cd7c1.png', 0, 2, '2026-06-30 09:26:45', '2026-06-30 09:26:45'),
(979, 297, 975, 'products/variants/2026/06/6a438bd5cfd99.png', 0, 2, '2026-06-30 09:26:45', '2026-06-30 09:26:45'),
(980, 297, 977, 'products/variants/2026/06/6a438bd5d1e78.png', 0, 3, '2026-06-30 09:26:45', '2026-06-30 09:26:45'),
(981, 297, 979, 'products/variants/2026/06/6a438bd5d4292.png', 0, 3, '2026-06-30 09:26:45', '2026-06-30 09:26:45'),
(982, 297, 975, 'products/variants/2026/06/6a438bd5d71b5.png', 0, 3, '2026-06-30 09:26:45', '2026-06-30 09:26:45'),
(983, 298, 976, 'products/variants/2026/06/6a438bd5d9863.png', 1, 0, '2026-06-30 09:26:45', '2026-06-30 09:26:45');
INSERT INTO `product_attribute_value_images` (`id`, `product_id`, `attribute_value_id`, `image_path`, `is_primary`, `sort_order`, `created_at`, `updated_at`) VALUES
(984, 298, 978, 'products/variants/2026/06/6a438bd5dc66b.png', 1, 0, '2026-06-30 09:26:45', '2026-06-30 09:26:45'),
(985, 298, 976, 'products/variants/2026/06/6a438bd5dfa61.png', 0, 1, '2026-06-30 09:26:45', '2026-06-30 09:26:45'),
(986, 298, 978, 'products/variants/2026/06/6a438bd5e550d.png', 0, 1, '2026-06-30 09:26:45', '2026-06-30 09:26:45'),
(987, 298, 976, 'products/variants/2026/06/6a438bd5eab03.png', 0, 2, '2026-06-30 09:26:45', '2026-06-30 09:26:45'),
(988, 298, 978, 'products/variants/2026/06/6a438bd5ed7e7.png', 0, 2, '2026-06-30 09:26:45', '2026-06-30 09:26:45'),
(989, 298, 976, 'products/variants/2026/06/6a438bd5f03ef.png', 0, 3, '2026-06-30 09:26:45', '2026-06-30 09:26:45'),
(990, 298, 978, 'products/variants/2026/06/6a438bd5f30b8.png', 0, 3, '2026-06-30 09:26:46', '2026-06-30 09:26:46'),
(991, 299, 981, 'products/variants/2026/06/6a438bd601de4.png', 1, 0, '2026-06-30 09:26:46', '2026-06-30 09:26:46'),
(992, 299, 974, 'products/variants/2026/06/6a438bd604897.png', 0, 0, '2026-06-30 09:26:46', '2026-06-30 09:26:46'),
(993, 299, 975, 'products/variants/2026/06/6a438bd60763c.png', 1, 0, '2026-06-30 09:26:46', '2026-06-30 09:26:46'),
(994, 299, 981, 'products/variants/2026/06/6a438bd609994.png', 0, 1, '2026-06-30 09:26:46', '2026-06-30 09:26:46'),
(995, 299, 974, 'products/variants/2026/06/6a438bd60c27c.png', 1, 1, '2026-06-30 09:26:46', '2026-06-30 09:26:46'),
(996, 299, 975, 'products/variants/2026/06/6a438bd60edcd.png', 0, 1, '2026-06-30 09:26:46', '2026-06-30 09:26:46'),
(997, 299, 981, 'products/variants/2026/06/6a438bd610dd9.png', 0, 2, '2026-06-30 09:26:46', '2026-06-30 09:26:46'),
(998, 299, 974, 'products/variants/2026/06/6a438bd6131f8.png', 0, 2, '2026-06-30 09:26:46', '2026-06-30 09:26:46'),
(999, 299, 975, 'products/variants/2026/06/6a438bd61514b.png', 0, 2, '2026-06-30 09:26:46', '2026-06-30 09:26:46'),
(1000, 299, 981, 'products/variants/2026/06/6a438bd6175e2.png', 0, 3, '2026-06-30 09:26:46', '2026-06-30 09:26:46'),
(1001, 299, 974, 'products/variants/2026/06/6a438bd61995d.png', 0, 3, '2026-06-30 09:26:46', '2026-06-30 09:26:46'),
(1002, 299, 975, 'products/variants/2026/06/6a438bd61b992.png', 0, 3, '2026-06-30 09:26:46', '2026-06-30 09:26:46'),
(1003, 300, 976, 'products/variants/2026/06/6a438bd61e103.png', 1, 0, '2026-06-30 09:26:46', '2026-06-30 09:26:46'),
(1004, 300, 978, 'products/variants/2026/06/6a438bd62089a.png', 1, 0, '2026-06-30 09:26:46', '2026-06-30 09:26:46'),
(1005, 300, 975, 'products/variants/2026/06/6a438bd6235da.png', 0, 0, '2026-06-30 09:26:46', '2026-06-30 09:26:46'),
(1006, 300, 976, 'products/variants/2026/06/6a438bd6267c0.png', 0, 1, '2026-06-30 09:26:46', '2026-06-30 09:26:46'),
(1007, 300, 978, 'products/variants/2026/06/6a438bd62962f.png', 0, 1, '2026-06-30 09:26:46', '2026-06-30 09:26:46'),
(1008, 300, 975, 'products/variants/2026/06/6a438bd62ca06.png', 1, 1, '2026-06-30 09:26:46', '2026-06-30 09:26:46'),
(1009, 300, 976, 'products/variants/2026/06/6a438bd62fc05.png', 0, 2, '2026-06-30 09:26:46', '2026-06-30 09:26:46'),
(1010, 300, 978, 'products/variants/2026/06/6a438bd632909.png', 0, 2, '2026-06-30 09:26:46', '2026-06-30 09:26:46'),
(1011, 300, 975, 'products/variants/2026/06/6a438bd635789.png', 0, 2, '2026-06-30 09:26:46', '2026-06-30 09:26:46'),
(1012, 300, 976, 'products/variants/2026/06/6a438bd638908.png', 0, 3, '2026-06-30 09:26:46', '2026-06-30 09:26:46'),
(1013, 300, 978, 'products/variants/2026/06/6a438bd63b4c4.png', 0, 3, '2026-06-30 09:26:46', '2026-06-30 09:26:46'),
(1014, 300, 975, 'products/variants/2026/06/6a438bd63e0a0.png', 0, 3, '2026-06-30 09:26:46', '2026-06-30 09:26:46'),
(1015, 301, 976, 'products/variants/2026/06/6a438bd64100f.png', 1, 0, '2026-06-30 09:26:46', '2026-06-30 09:26:46'),
(1016, 301, 979, 'products/variants/2026/06/6a438bd643ab5.png', 1, 0, '2026-06-30 09:26:46', '2026-06-30 09:26:46'),
(1017, 301, 980, 'products/variants/2026/06/6a438bd646444.png', 1, 0, '2026-06-30 09:26:46', '2026-06-30 09:26:46'),
(1018, 301, 976, 'products/variants/2026/06/6a438bd649085.png', 0, 1, '2026-06-30 09:26:46', '2026-06-30 09:26:46'),
(1019, 301, 979, 'products/variants/2026/06/6a438bd64b8ee.png', 0, 1, '2026-06-30 09:26:46', '2026-06-30 09:26:46'),
(1020, 301, 980, 'products/variants/2026/06/6a438bd64eb1d.png', 0, 1, '2026-06-30 09:26:46', '2026-06-30 09:26:46'),
(1021, 301, 976, 'products/variants/2026/06/6a438bd651f78.png', 0, 2, '2026-06-30 09:26:46', '2026-06-30 09:26:46'),
(1022, 301, 979, 'products/variants/2026/06/6a438bd655d7a.png', 0, 2, '2026-06-30 09:26:46', '2026-06-30 09:26:46'),
(1023, 301, 980, 'products/variants/2026/06/6a438bd658ee4.png', 0, 2, '2026-06-30 09:26:46', '2026-06-30 09:26:46'),
(1024, 301, 976, 'products/variants/2026/06/6a438bd65b690.png', 0, 3, '2026-06-30 09:26:46', '2026-06-30 09:26:46'),
(1025, 301, 979, 'products/variants/2026/06/6a438bd65e228.png', 0, 3, '2026-06-30 09:26:46', '2026-06-30 09:26:46'),
(1026, 301, 980, 'products/variants/2026/06/6a438bd660cba.png', 0, 3, '2026-06-30 09:26:46', '2026-06-30 09:26:46'),
(1027, 302, 977, 'products/variants/2026/06/6a438bd6634e5.png', 1, 0, '2026-06-30 09:26:46', '2026-06-30 09:26:46'),
(1028, 302, 975, 'products/variants/2026/06/6a438bd666260.png', 1, 0, '2026-06-30 09:26:46', '2026-06-30 09:26:46'),
(1029, 302, 977, 'products/variants/2026/06/6a438bd669438.png', 0, 1, '2026-06-30 09:26:46', '2026-06-30 09:26:46'),
(1030, 302, 975, 'products/variants/2026/06/6a438bd66bf16.png', 0, 1, '2026-06-30 09:26:46', '2026-06-30 09:26:46'),
(1031, 302, 977, 'products/variants/2026/06/6a438bd66e815.png', 0, 2, '2026-06-30 09:26:46', '2026-06-30 09:26:46'),
(1032, 302, 975, 'products/variants/2026/06/6a438bd670faf.png', 0, 2, '2026-06-30 09:26:46', '2026-06-30 09:26:46'),
(1033, 302, 977, 'products/variants/2026/06/6a438bd6737bb.png', 0, 3, '2026-06-30 09:26:46', '2026-06-30 09:26:46'),
(1034, 302, 975, 'products/variants/2026/06/6a438bd676403.png', 0, 3, '2026-06-30 09:26:46', '2026-06-30 09:26:46'),
(1035, 303, 979, 'products/variants/2026/06/6a438bd6792d1.png', 0, 0, '2026-06-30 09:26:46', '2026-06-30 09:26:46'),
(1036, 303, 974, 'products/variants/2026/06/6a438bd67beba.png', 1, 0, '2026-06-30 09:26:46', '2026-06-30 09:26:46'),
(1037, 303, 975, 'products/variants/2026/06/6a438bd67eded.png', 1, 0, '2026-06-30 09:26:46', '2026-06-30 09:26:46'),
(1038, 303, 980, 'products/variants/2026/06/6a438bd681fa5.png', 1, 0, '2026-06-30 09:26:46', '2026-06-30 09:26:46'),
(1039, 303, 979, 'products/variants/2026/06/6a438bd684f2f.png', 1, 1, '2026-06-30 09:26:46', '2026-06-30 09:26:46'),
(1040, 303, 974, 'products/variants/2026/06/6a438bd6881c4.png', 0, 1, '2026-06-30 09:26:46', '2026-06-30 09:26:46'),
(1041, 303, 975, 'products/variants/2026/06/6a438bd68b010.png', 0, 1, '2026-06-30 09:26:46', '2026-06-30 09:26:46'),
(1042, 303, 980, 'products/variants/2026/06/6a438bd68dbd3.png', 0, 1, '2026-06-30 09:26:46', '2026-06-30 09:26:46'),
(1043, 303, 979, 'products/variants/2026/06/6a438bd690346.png', 0, 2, '2026-06-30 09:26:46', '2026-06-30 09:26:46'),
(1044, 303, 974, 'products/variants/2026/06/6a438bd692c5a.png', 0, 2, '2026-06-30 09:26:46', '2026-06-30 09:26:46'),
(1045, 303, 975, 'products/variants/2026/06/6a438bd6958b2.png', 0, 2, '2026-06-30 09:26:46', '2026-06-30 09:26:46'),
(1046, 303, 980, 'products/variants/2026/06/6a438bd698151.png', 0, 2, '2026-06-30 09:26:46', '2026-06-30 09:26:46'),
(1047, 303, 979, 'products/variants/2026/06/6a438bd69ac0e.png', 0, 3, '2026-06-30 09:26:46', '2026-06-30 09:26:46'),
(1048, 303, 974, 'products/variants/2026/06/6a438bd69d62c.png', 0, 3, '2026-06-30 09:26:46', '2026-06-30 09:26:46'),
(1049, 303, 975, 'products/variants/2026/06/6a438bd6a04d0.png', 0, 3, '2026-06-30 09:26:46', '2026-06-30 09:26:46'),
(1050, 303, 980, 'products/variants/2026/06/6a438bd6a398c.png', 0, 3, '2026-06-30 09:26:46', '2026-06-30 09:26:46'),
(1051, 304, 977, 'products/variants/2026/06/6a438bd6a6a79.png', 1, 0, '2026-06-30 09:26:46', '2026-06-30 09:26:46'),
(1052, 304, 976, 'products/variants/2026/06/6a438bd6a98a4.png', 1, 0, '2026-06-30 09:26:46', '2026-06-30 09:26:46'),
(1053, 304, 977, 'products/variants/2026/06/6a438bd6ac930.png', 0, 1, '2026-06-30 09:26:46', '2026-06-30 09:26:46'),
(1054, 304, 976, 'products/variants/2026/06/6a438bd6af372.png', 0, 1, '2026-06-30 09:26:46', '2026-06-30 09:26:46'),
(1055, 304, 977, 'products/variants/2026/06/6a438bd6b1ea2.png', 0, 2, '2026-06-30 09:26:46', '2026-06-30 09:26:46'),
(1056, 304, 976, 'products/variants/2026/06/6a438bd6b4590.png', 0, 2, '2026-06-30 09:26:46', '2026-06-30 09:26:46'),
(1057, 304, 977, 'products/variants/2026/06/6a438bd6b72cf.png', 0, 3, '2026-06-30 09:26:46', '2026-06-30 09:26:46'),
(1058, 304, 976, 'products/variants/2026/06/6a438bd6b9968.png', 0, 3, '2026-06-30 09:26:46', '2026-06-30 09:26:46'),
(1059, 305, 976, 'products/variants/2026/06/6a438bd6bc02f.png', 1, 0, '2026-06-30 09:26:46', '2026-06-30 09:26:46'),
(1060, 305, 979, 'products/variants/2026/06/6a438bd6be237.png', 1, 0, '2026-06-30 09:26:46', '2026-06-30 09:26:46'),
(1061, 305, 975, 'products/variants/2026/06/6a438bd6bfd04.png', 1, 0, '2026-06-30 09:26:46', '2026-06-30 09:26:46'),
(1062, 305, 976, 'products/variants/2026/06/6a438bd6c2146.png', 0, 1, '2026-06-30 09:26:46', '2026-06-30 09:26:46'),
(1063, 305, 979, 'products/variants/2026/06/6a438bd6c419b.png', 0, 1, '2026-06-30 09:26:46', '2026-06-30 09:26:46'),
(1064, 305, 975, 'products/variants/2026/06/6a438bd6c60f4.png', 0, 1, '2026-06-30 09:26:46', '2026-06-30 09:26:46'),
(1065, 305, 976, 'products/variants/2026/06/6a438bd6c87fa.png', 0, 2, '2026-06-30 09:26:46', '2026-06-30 09:26:46'),
(1066, 305, 979, 'products/variants/2026/06/6a438bd6caeaf.png', 0, 2, '2026-06-30 09:26:46', '2026-06-30 09:26:46'),
(1067, 305, 975, 'products/variants/2026/06/6a438bd6cce8f.png', 0, 2, '2026-06-30 09:26:46', '2026-06-30 09:26:46'),
(1068, 305, 976, 'products/variants/2026/06/6a438bd6cf7b9.png', 0, 3, '2026-06-30 09:26:46', '2026-06-30 09:26:46'),
(1069, 305, 979, 'products/variants/2026/06/6a438bd6d1ba7.png', 0, 3, '2026-06-30 09:26:46', '2026-06-30 09:26:46'),
(1070, 305, 975, 'products/variants/2026/06/6a438bd6d4048.png', 0, 3, '2026-06-30 09:26:46', '2026-06-30 09:26:46'),
(1071, 306, 976, 'products/variants/2026/06/6a438bd6d62e4.png', 1, 0, '2026-06-30 09:26:46', '2026-06-30 09:26:46'),
(1072, 306, 974, 'products/variants/2026/06/6a438bd6d8e89.png', 1, 0, '2026-06-30 09:26:46', '2026-06-30 09:26:46'),
(1073, 306, 980, 'products/variants/2026/06/6a438bd6dbb30.png', 1, 0, '2026-06-30 09:26:46', '2026-06-30 09:26:46'),
(1074, 306, 976, 'products/variants/2026/06/6a438bd6de294.png', 0, 1, '2026-06-30 09:26:46', '2026-06-30 09:26:46'),
(1075, 306, 974, 'products/variants/2026/06/6a438bd6e12b2.png', 0, 1, '2026-06-30 09:26:46', '2026-06-30 09:26:46'),
(1076, 306, 980, 'products/variants/2026/06/6a438bd6e4466.png', 0, 1, '2026-06-30 09:26:46', '2026-06-30 09:26:46'),
(1077, 306, 976, 'products/variants/2026/06/6a438bd6e8dde.png', 0, 2, '2026-06-30 09:26:46', '2026-06-30 09:26:46'),
(1078, 306, 974, 'products/variants/2026/06/6a438bd6eb5ea.png', 0, 2, '2026-06-30 09:26:46', '2026-06-30 09:26:46'),
(1079, 306, 980, 'products/variants/2026/06/6a438bd6edec2.png', 0, 2, '2026-06-30 09:26:46', '2026-06-30 09:26:46'),
(1080, 306, 976, 'products/variants/2026/06/6a438bd6f05dc.png', 0, 3, '2026-06-30 09:26:46', '2026-06-30 09:26:46'),
(1081, 306, 974, 'products/variants/2026/06/6a438bd6f2b95.png', 0, 3, '2026-06-30 09:26:46', '2026-06-30 09:26:46'),
(1082, 306, 980, 'products/variants/2026/06/6a438bd701168.png', 0, 3, '2026-06-30 09:26:47', '2026-06-30 09:26:47');

-- --------------------------------------------------------

--
-- Table structure for table `product_categories`
--

CREATE TABLE `product_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(150) NOT NULL,
  `slug` varchar(160) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_categories`
--

INSERT INTO `product_categories` (`id`, `name`, `slug`, `status`) VALUES
(1, 'Baby Gear & Nursery', 'baby-gear-nursery', 1),
(2, 'Bath & Skin Care', 'bath-skin-care-69de2ba70fa97', 1),
(3, 'Birthday Products & Gifts', 'birthday-products-gifts', 1),
(4, 'Books & CDs / Learning Materials', 'books-learning-materials', 1),
(5, 'Clothes & Shoes', 'clothes-shoes-6a01b0e4880a3', 1),
(6, 'Diapering', 'diapering', 1),
(7, 'Fashion Accessories', 'fashion-accessories', 1),
(8, 'Feeding & Nursing', 'feeding-nursing-6a0201db8c745', 1),
(9, 'Health & Safety', 'health-safety', 1),
(10, 'Moms & Maternity', 'moms-maternity', 1),
(11, 'Toys & Gaming', 'toys-gaming-69aec45fe9e74', 1),
(16, 'Baby Food', 'baby-food-69a8279c7c62d', 1),
(17, 'Electronics', 'electronics-6a2ff26bcbc13', 1);

-- --------------------------------------------------------

--
-- Table structure for table `product_category_attributes`
--

CREATE TABLE `product_category_attributes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_categories_id` bigint(20) UNSIGNED NOT NULL,
  `attribute_id` bigint(20) UNSIGNED NOT NULL,
  `is_required` tinyint(1) DEFAULT 0,
  `sort_order` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_category_attributes`
--

INSERT INTO `product_category_attributes` (`id`, `product_categories_id`, `attribute_id`, `is_required`, `sort_order`) VALUES
(15, 4, 16, 0, 0),
(16, 4, 17, 0, 0),
(27, 6, 12, 0, 0),
(72, 16, 41, 0, 0),
(121, 11, 90, 0, 0),
(122, 11, 91, 0, 0),
(219, 2, 188, 0, 0),
(220, 2, 189, 0, 0),
(221, 2, 190, 0, 0),
(246, 5, 215, 0, 0),
(247, 5, 216, 0, 0),
(248, 5, 217, 0, 0),
(249, 5, 218, 0, 0),
(250, 5, 219, 0, 0),
(251, 8, 220, 0, 0),
(255, 17, 224, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `product_category_section`
--

CREATE TABLE `product_category_section` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `master_category_section_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_category_section`
--

INSERT INTO `product_category_section` (`id`, `product_id`, `master_category_section_id`, `created_at`, `updated_at`) VALUES
(856, 283, 1, NULL, NULL),
(857, 306, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `product_images`
--

CREATE TABLE `product_images` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `is_primary` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_images`
--

INSERT INTO `product_images` (`id`, `product_id`, `image_path`, `is_primary`, `created_at`, `updated_at`) VALUES
(641, 251, 'products/2026/06/6a2fa3988db68.png', 1, '2026-06-15 07:02:48', '2026-06-15 07:02:48'),
(642, 251, 'products/2026/06/6a2fa3989f4d3.png', 0, '2026-06-15 07:02:48', '2026-06-15 07:02:48'),
(643, 251, 'products/2026/06/6a2fa398a3e17.png', 0, '2026-06-15 07:02:48', '2026-06-15 07:02:48'),
(644, 251, 'products/2026/06/6a2fa398a7e42.png', 0, '2026-06-15 07:02:48', '2026-06-15 07:02:48'),
(645, 252, 'products/2026/06/6a2fa398aad4b.png', 1, '2026-06-15 07:02:48', '2026-06-15 07:02:48'),
(646, 252, 'products/2026/06/6a2fa398adefe.png', 0, '2026-06-15 07:02:48', '2026-06-15 07:02:48'),
(647, 252, 'products/2026/06/6a2fa398b0fce.png', 0, '2026-06-15 07:02:48', '2026-06-15 07:02:48'),
(648, 252, 'products/2026/06/6a2fa398b3ec6.png', 0, '2026-06-15 07:02:48', '2026-06-15 07:02:48'),
(649, 253, 'products/2026/06/6a2fa398b68a6.png', 1, '2026-06-15 07:02:48', '2026-06-15 07:02:48'),
(650, 253, 'products/2026/06/6a2fa398b90d0.png', 0, '2026-06-15 07:02:48', '2026-06-15 07:02:48'),
(651, 253, 'products/2026/06/6a2fa398bbfaa.png', 0, '2026-06-15 07:02:48', '2026-06-15 07:02:48'),
(652, 253, 'products/2026/06/6a2fa398beeea.png', 0, '2026-06-15 07:02:48', '2026-06-15 07:02:48'),
(653, 254, 'products/2026/06/6a2fa398c1731.png', 1, '2026-06-15 07:02:48', '2026-06-15 07:02:48'),
(654, 254, 'products/2026/06/6a2fa398c452d.png', 0, '2026-06-15 07:02:48', '2026-06-15 07:02:48'),
(655, 254, 'products/2026/06/6a2fa398c7791.png', 0, '2026-06-15 07:02:48', '2026-06-15 07:02:48'),
(656, 254, 'products/2026/06/6a2fa398ca72a.png', 0, '2026-06-15 07:02:48', '2026-06-15 07:02:48'),
(657, 255, 'products/2026/06/6a2fa398cdd91.png', 1, '2026-06-15 07:02:48', '2026-06-15 07:02:48'),
(658, 255, 'products/2026/06/6a2fa398d126d.png', 0, '2026-06-15 07:02:48', '2026-06-15 07:02:48'),
(659, 255, 'products/2026/06/6a2fa398d921f.png', 0, '2026-06-15 07:02:48', '2026-06-15 07:02:48'),
(660, 255, 'products/2026/06/6a2fa398dcf04.png', 0, '2026-06-15 07:02:48', '2026-06-15 07:02:48'),
(661, 256, 'products/2026/06/6a2fa398e0aa4.png', 1, '2026-06-15 07:02:48', '2026-06-15 07:02:48'),
(662, 256, 'products/2026/06/6a2fa398e3f2f.png', 0, '2026-06-15 07:02:48', '2026-06-15 07:02:48'),
(663, 256, 'products/2026/06/6a2fa398e9eca.png', 0, '2026-06-15 07:02:48', '2026-06-15 07:02:48'),
(664, 256, 'products/2026/06/6a2fa398ef34b.png', 0, '2026-06-15 07:02:48', '2026-06-15 07:02:48'),
(665, 257, 'products/2026/06/6a2fa398f30f4.png', 1, '2026-06-15 07:02:49', '2026-06-15 07:02:49'),
(666, 257, 'products/2026/06/6a2fa3990267a.png', 0, '2026-06-15 07:02:49', '2026-06-15 07:02:49'),
(667, 257, 'products/2026/06/6a2fa39905795.png', 0, '2026-06-15 07:02:49', '2026-06-15 07:02:49'),
(668, 257, 'products/2026/06/6a2fa3990854a.png', 0, '2026-06-15 07:02:49', '2026-06-15 07:02:49'),
(669, 258, 'products/2026/06/6a2fa3990b655.png', 1, '2026-06-15 07:02:49', '2026-06-15 07:02:49'),
(670, 258, 'products/2026/06/6a2fa3990e9d7.png', 0, '2026-06-15 07:02:49', '2026-06-15 07:02:49'),
(671, 258, 'products/2026/06/6a2fa39912fe9.png', 0, '2026-06-15 07:02:49', '2026-06-15 07:02:49'),
(672, 258, 'products/2026/06/6a2fa399167bb.png', 0, '2026-06-15 07:02:49', '2026-06-15 07:02:49'),
(673, 259, 'products/2026/06/6a2fa3991989d.png', 1, '2026-06-15 07:02:49', '2026-06-15 07:02:49'),
(674, 259, 'products/2026/06/6a2fa3991c954.png', 0, '2026-06-15 07:02:49', '2026-06-15 07:02:49'),
(675, 259, 'products/2026/06/6a2fa3991ff49.png', 0, '2026-06-15 07:02:49', '2026-06-15 07:02:49'),
(676, 259, 'products/2026/06/6a2fa39922d67.png', 0, '2026-06-15 07:02:49', '2026-06-15 07:02:49'),
(677, 260, 'products/2026/06/6a2fa39926a71.png', 1, '2026-06-15 07:02:49', '2026-06-15 07:02:49'),
(678, 260, 'products/2026/06/6a2fa3992a496.png', 0, '2026-06-15 07:02:49', '2026-06-15 07:02:49'),
(679, 260, 'products/2026/06/6a2fa3992e8a3.png', 0, '2026-06-15 07:02:49', '2026-06-15 07:02:49'),
(680, 260, 'products/2026/06/6a2fa39932eb5.png', 0, '2026-06-15 07:02:49', '2026-06-15 07:02:49'),
(681, 261, 'products/2026/06/6a2fa399363ae.png', 1, '2026-06-15 07:02:49', '2026-06-15 07:02:49'),
(682, 261, 'products/2026/06/6a2fa399397d9.png', 0, '2026-06-15 07:02:49', '2026-06-15 07:02:49'),
(683, 261, 'products/2026/06/6a2fa3993cde3.png', 0, '2026-06-15 07:02:49', '2026-06-15 07:02:49'),
(684, 261, 'products/2026/06/6a2fa39940306.png', 0, '2026-06-15 07:02:49', '2026-06-15 07:02:49'),
(685, 262, 'products/2026/06/6a2fa399436be.png', 1, '2026-06-15 07:02:49', '2026-06-15 07:02:49'),
(686, 262, 'products/2026/06/6a2fa39946d13.png', 0, '2026-06-15 07:02:49', '2026-06-15 07:02:49'),
(687, 262, 'products/2026/06/6a2fa3994a414.png', 0, '2026-06-15 07:02:49', '2026-06-15 07:02:49'),
(688, 262, 'products/2026/06/6a2fa3994d879.png', 0, '2026-06-15 07:02:49', '2026-06-15 07:02:49'),
(689, 263, 'products/2026/06/6a2fa39950a35.png', 1, '2026-06-15 07:02:49', '2026-06-15 07:02:49'),
(690, 263, 'products/2026/06/6a2fa39953af7.png', 0, '2026-06-15 07:02:49', '2026-06-15 07:02:49'),
(691, 263, 'products/2026/06/6a2fa39956760.png', 0, '2026-06-15 07:02:49', '2026-06-15 07:02:49'),
(692, 263, 'products/2026/06/6a2fa3995924e.png', 0, '2026-06-15 07:02:49', '2026-06-15 07:02:49'),
(693, 264, 'products/2026/06/6a2fa3995c165.png', 1, '2026-06-15 07:02:49', '2026-06-15 07:02:49'),
(694, 264, 'products/2026/06/6a2fa3995f03b.png', 0, '2026-06-15 07:02:49', '2026-06-15 07:02:49'),
(695, 264, 'products/2026/06/6a2fa39962ad4.png', 0, '2026-06-15 07:02:49', '2026-06-15 07:02:49'),
(696, 264, 'products/2026/06/6a2fa39966011.png', 0, '2026-06-15 07:02:49', '2026-06-15 07:02:49'),
(697, 265, 'products/2026/06/6a2fa39969a69.png', 1, '2026-06-15 07:02:49', '2026-06-15 07:02:49'),
(698, 265, 'products/2026/06/6a2fa3996d25e.png', 0, '2026-06-15 07:02:49', '2026-06-15 07:02:49'),
(699, 265, 'products/2026/06/6a2fa399708ea.png', 0, '2026-06-15 07:02:49', '2026-06-15 07:02:49'),
(700, 265, 'products/2026/06/6a2fa39973c1c.png', 0, '2026-06-15 07:02:49', '2026-06-15 07:02:49'),
(701, 266, 'products/2026/06/6a2fa39976e5d.png', 1, '2026-06-15 07:02:49', '2026-06-15 07:02:49'),
(702, 266, 'products/2026/06/6a2fa3997ac37.png', 0, '2026-06-15 07:02:49', '2026-06-15 07:02:49'),
(703, 266, 'products/2026/06/6a2fa3997e0b3.png', 0, '2026-06-15 07:02:49', '2026-06-15 07:02:49'),
(704, 266, 'products/2026/06/6a2fa39981c32.png', 0, '2026-06-15 07:02:49', '2026-06-15 07:02:49'),
(705, 267, 'products/2026/06/6a2fa39985e30.png', 1, '2026-06-15 07:02:49', '2026-06-15 07:02:49'),
(706, 267, 'products/2026/06/6a2fa39989dbd.png', 0, '2026-06-15 07:02:49', '2026-06-15 07:02:49'),
(707, 267, 'products/2026/06/6a2fa3998e176.png', 0, '2026-06-15 07:02:49', '2026-06-15 07:02:49'),
(708, 267, 'products/2026/06/6a2fa399923f0.png', 0, '2026-06-15 07:02:49', '2026-06-15 07:02:49'),
(709, 268, 'products/2026/06/6a2fa399958ea.png', 1, '2026-06-15 07:02:49', '2026-06-15 07:02:49'),
(710, 268, 'products/2026/06/6a2fa39998498.png', 0, '2026-06-15 07:02:49', '2026-06-15 07:02:49'),
(711, 268, 'products/2026/06/6a2fa3999b057.png', 0, '2026-06-15 07:02:49', '2026-06-15 07:02:49'),
(712, 268, 'products/2026/06/6a2fa3999ddba.png', 0, '2026-06-15 07:02:49', '2026-06-15 07:02:49'),
(713, 269, 'products/2026/06/6a2fa399a0c2a.png', 1, '2026-06-15 07:02:49', '2026-06-15 07:02:49'),
(714, 269, 'products/2026/06/6a2fa399a3a8c.png', 0, '2026-06-15 07:02:49', '2026-06-15 07:02:49'),
(715, 269, 'products/2026/06/6a2fa399a63b8.png', 0, '2026-06-15 07:02:49', '2026-06-15 07:02:49'),
(716, 269, 'products/2026/06/6a2fa399a9067.png', 0, '2026-06-15 07:02:49', '2026-06-15 07:02:49'),
(717, 270, 'products/2026/06/6a2fa399acbe7.png', 1, '2026-06-15 07:02:49', '2026-06-15 07:02:49'),
(718, 270, 'products/2026/06/6a2fa399af52e.png', 0, '2026-06-15 07:02:49', '2026-06-15 07:02:49'),
(719, 270, 'products/2026/06/6a2fa399b1f22.png', 0, '2026-06-15 07:02:49', '2026-06-15 07:02:49'),
(720, 270, 'products/2026/06/6a2fa399b4b57.png', 0, '2026-06-15 07:02:49', '2026-06-15 07:02:49'),
(721, 271, 'products/2026/06/6a2fa399b7699.png', 1, '2026-06-15 07:02:49', '2026-06-15 07:02:49'),
(722, 271, 'products/2026/06/6a2fa399ba242.png', 0, '2026-06-15 07:02:49', '2026-06-15 07:02:49'),
(723, 271, 'products/2026/06/6a2fa399bd159.png', 0, '2026-06-15 07:02:49', '2026-06-15 07:02:49'),
(724, 271, 'products/2026/06/6a2fa399c013f.png', 0, '2026-06-15 07:02:49', '2026-06-15 07:02:49'),
(725, 272, 'products/2026/06/6a2fa399c2fba.png', 1, '2026-06-15 07:02:49', '2026-06-15 07:02:49'),
(726, 272, 'products/2026/06/6a2fa399c6938.png', 0, '2026-06-15 07:02:49', '2026-06-15 07:02:49'),
(727, 272, 'products/2026/06/6a2fa399ca110.png', 0, '2026-06-15 07:02:49', '2026-06-15 07:02:49'),
(728, 272, 'products/2026/06/6a2fa399cd489.png', 0, '2026-06-15 07:02:49', '2026-06-15 07:02:49'),
(729, 273, 'products/2026/06/6a2fa399d0231.png', 1, '2026-06-15 07:02:49', '2026-06-15 07:02:49'),
(730, 273, 'products/2026/06/6a2fa399d3464.png', 0, '2026-06-15 07:02:49', '2026-06-15 07:02:49'),
(731, 273, 'products/2026/06/6a2fa399d635f.png', 0, '2026-06-15 07:02:49', '2026-06-15 07:02:49'),
(732, 273, 'products/2026/06/6a2fa399d92e8.png', 0, '2026-06-15 07:02:49', '2026-06-15 07:02:49'),
(733, 274, 'products/2026/06/6a2fa399dc0f6.png', 1, '2026-06-15 07:02:49', '2026-06-15 07:02:49'),
(734, 274, 'products/2026/06/6a2fa399defc1.png', 0, '2026-06-15 07:02:49', '2026-06-15 07:02:49'),
(735, 274, 'products/2026/06/6a2fa399e1d7a.png', 0, '2026-06-15 07:02:49', '2026-06-15 07:02:49'),
(736, 274, 'products/2026/06/6a2fa399e4b2f.png', 0, '2026-06-15 07:02:49', '2026-06-15 07:02:49'),
(737, 275, 'products/2026/06/6a2fa399e73fb.png', 1, '2026-06-15 07:02:49', '2026-06-15 07:02:49'),
(738, 275, 'products/2026/06/6a2fa399ea255.png', 0, '2026-06-15 07:02:49', '2026-06-15 07:02:49'),
(739, 275, 'products/2026/06/6a2fa399ed4a3.png', 0, '2026-06-15 07:02:49', '2026-06-15 07:02:49'),
(740, 275, 'products/2026/06/6a2fa399f029f.png', 0, '2026-06-15 07:02:49', '2026-06-15 07:02:49'),
(741, 276, 'products/2026/06/6a2fa399f331b.png', 1, '2026-06-15 07:02:50', '2026-06-15 07:02:50'),
(742, 276, 'products/2026/06/6a2fa39a02232.png', 0, '2026-06-15 07:02:50', '2026-06-15 07:02:50'),
(743, 276, 'products/2026/06/6a2fa39a05e43.png', 0, '2026-06-15 07:02:50', '2026-06-15 07:02:50'),
(744, 276, 'products/2026/06/6a2fa39a095bb.png', 0, '2026-06-15 07:02:50', '2026-06-15 07:02:50'),
(745, 277, 'products/2026/06/6a2fa39a0d259.png', 1, '2026-06-15 07:02:50', '2026-06-15 07:02:50'),
(746, 277, 'products/2026/06/6a2fa39a10862.png', 0, '2026-06-15 07:02:50', '2026-06-15 07:02:50'),
(747, 277, 'products/2026/06/6a2fa39a13dd2.png', 0, '2026-06-15 07:02:50', '2026-06-15 07:02:50'),
(748, 277, 'products/2026/06/6a2fa39a170c8.png', 0, '2026-06-15 07:02:50', '2026-06-15 07:02:50'),
(749, 278, 'products/2026/06/6a2fa39a1a677.png', 1, '2026-06-15 07:02:50', '2026-06-15 07:02:50'),
(750, 278, 'products/2026/06/6a2fa39a1da7e.png', 0, '2026-06-15 07:02:50', '2026-06-15 07:02:50'),
(751, 278, 'products/2026/06/6a2fa39a2068b.png', 0, '2026-06-15 07:02:50', '2026-06-15 07:02:50'),
(752, 278, 'products/2026/06/6a2fa39a234fb.png', 0, '2026-06-15 07:02:50', '2026-06-15 07:02:50'),
(753, 279, 'products/2026/06/6a2fa39a26450.png', 1, '2026-06-15 07:02:50', '2026-06-15 07:02:50'),
(754, 279, 'products/2026/06/6a2fa39a295d1.png', 0, '2026-06-15 07:02:50', '2026-06-15 07:02:50'),
(755, 279, 'products/2026/06/6a2fa39a2ca87.png', 0, '2026-06-15 07:02:50', '2026-06-15 07:02:50'),
(756, 279, 'products/2026/06/6a2fa39a2fc1f.png', 0, '2026-06-15 07:02:50', '2026-06-15 07:02:50'),
(757, 280, 'products/2026/06/6a2fa39a33004.png', 1, '2026-06-15 07:02:50', '2026-06-15 07:02:50'),
(758, 280, 'products/2026/06/6a2fa39a36c5b.png', 0, '2026-06-15 07:02:50', '2026-06-15 07:02:50'),
(759, 280, 'products/2026/06/6a2fa39a39f2e.png', 0, '2026-06-15 07:02:50', '2026-06-15 07:02:50'),
(760, 280, 'products/2026/06/6a2fa39a3d404.png', 0, '2026-06-15 07:02:50', '2026-06-15 07:02:50'),
(761, 281, 'products/2026/06/6a2fa39a4077d.png', 1, '2026-06-15 07:02:50', '2026-06-15 07:02:50'),
(762, 281, 'products/2026/06/6a2fa39a43b06.png', 0, '2026-06-15 07:02:50', '2026-06-15 07:02:50'),
(763, 281, 'products/2026/06/6a2fa39a46fbb.png', 0, '2026-06-15 07:02:50', '2026-06-15 07:02:50'),
(764, 281, 'products/2026/06/6a2fa39a49eb3.png', 0, '2026-06-15 07:02:50', '2026-06-15 07:02:50'),
(769, 308, 'products/2026/06/6a2fa39d8b2fd.png', 1, '2026-06-15 07:02:53', '2026-06-15 07:02:53'),
(770, 308, 'products/2026/06/6a2fa39d8e68c.png', 0, '2026-06-15 07:02:53', '2026-06-15 07:02:53'),
(771, 308, 'products/2026/06/6a2fa39d91798.png', 0, '2026-06-15 07:02:53', '2026-06-15 07:02:53'),
(772, 308, 'products/2026/06/6a2fa39d94571.png', 0, '2026-06-15 07:02:53', '2026-06-15 07:02:53'),
(773, 309, 'products/2026/06/6a2fa39d968da.png', 1, '2026-06-15 07:02:53', '2026-06-15 07:02:53'),
(774, 309, 'products/2026/06/6a2fa39d9889c.png', 0, '2026-06-15 07:02:53', '2026-06-15 07:02:53'),
(775, 309, 'products/2026/06/6a2fa39d9c6b0.png', 0, '2026-06-15 07:02:53', '2026-06-15 07:02:53'),
(776, 309, 'products/2026/06/6a2fa39d9eef2.png', 0, '2026-06-15 07:02:53', '2026-06-15 07:02:53'),
(777, 310, 'products/2026/06/6a2fa39da1561.png', 1, '2026-06-15 07:02:53', '2026-06-15 07:02:53'),
(778, 310, 'products/2026/06/6a2fa39da361b.png', 0, '2026-06-15 07:02:53', '2026-06-15 07:02:53'),
(779, 310, 'products/2026/06/6a2fa39da5be8.png', 0, '2026-06-15 07:02:53', '2026-06-15 07:02:53'),
(780, 310, 'products/2026/06/6a2fa39da7efa.png', 0, '2026-06-15 07:02:53', '2026-06-15 07:02:53'),
(781, 311, 'products/2026/06/6a2fa39daa6fb.png', 1, '2026-06-15 07:02:53', '2026-06-15 07:02:53'),
(782, 311, 'products/2026/06/6a2fa39daccaa.png', 0, '2026-06-15 07:02:53', '2026-06-15 07:02:53'),
(783, 311, 'products/2026/06/6a2fa39daf261.png', 0, '2026-06-15 07:02:53', '2026-06-15 07:02:53'),
(784, 311, 'products/2026/06/6a2fa39db2a58.png', 0, '2026-06-15 07:02:53', '2026-06-15 07:02:53'),
(785, 312, 'products/2026/06/6a2fa39db6071.png', 1, '2026-06-15 07:02:53', '2026-06-15 07:02:53'),
(786, 312, 'products/2026/06/6a2fa39db8cfc.png', 0, '2026-06-15 07:02:53', '2026-06-15 07:02:53'),
(787, 312, 'products/2026/06/6a2fa39dbab2a.png', 0, '2026-06-15 07:02:53', '2026-06-15 07:02:53'),
(788, 312, 'products/2026/06/6a2fa39dbd9dc.png', 0, '2026-06-15 07:02:53', '2026-06-15 07:02:53'),
(789, 313, 'products/2026/06/6a2fa39dbf936.png', 1, '2026-06-15 07:02:53', '2026-06-15 07:02:53'),
(790, 313, 'products/2026/06/6a2fa39dc14e1.png', 0, '2026-06-15 07:02:53', '2026-06-15 07:02:53'),
(791, 313, 'products/2026/06/6a2fa39dc30a9.png', 0, '2026-06-15 07:02:53', '2026-06-15 07:02:53'),
(792, 313, 'products/2026/06/6a2fa39dc4e16.png', 0, '2026-06-15 07:02:53', '2026-06-15 07:02:53'),
(793, 314, 'products/2026/06/6a2fa39dc6cd6.png', 1, '2026-06-15 07:02:53', '2026-06-15 07:02:53'),
(794, 314, 'products/2026/06/6a2fa39dc8804.png', 0, '2026-06-15 07:02:53', '2026-06-15 07:02:53'),
(795, 314, 'products/2026/06/6a2fa39dca4b4.png', 0, '2026-06-15 07:02:53', '2026-06-15 07:02:53'),
(796, 314, 'products/2026/06/6a2fa39dcbddf.png', 0, '2026-06-15 07:02:53', '2026-06-15 07:02:53'),
(797, 315, 'products/2026/06/6a2fa39dcd947.png', 1, '2026-06-15 07:02:53', '2026-06-15 07:02:53'),
(798, 315, 'products/2026/06/6a2fa39dcfafa.png', 0, '2026-06-15 07:02:53', '2026-06-15 07:02:53'),
(799, 315, 'products/2026/06/6a2fa39dd1ac9.png', 0, '2026-06-15 07:02:53', '2026-06-15 07:02:53'),
(800, 315, 'products/2026/06/6a2fa39dd377d.png', 0, '2026-06-15 07:02:53', '2026-06-15 07:02:53'),
(801, 316, 'products/2026/06/6a2fa39dd540f.png', 1, '2026-06-15 07:02:53', '2026-06-15 07:02:53'),
(802, 316, 'products/2026/06/6a2fa39dd72bf.png', 0, '2026-06-15 07:02:53', '2026-06-15 07:02:53'),
(803, 316, 'products/2026/06/6a2fa39dd8efd.png', 0, '2026-06-15 07:02:53', '2026-06-15 07:02:53'),
(804, 316, 'products/2026/06/6a2fa39ddb022.png', 0, '2026-06-15 07:02:53', '2026-06-15 07:02:53'),
(805, 317, 'products/2026/06/6a2fa39ddcc6c.png', 1, '2026-06-15 07:02:53', '2026-06-15 07:02:53'),
(806, 317, 'products/2026/06/6a2fa39ddeb96.png', 0, '2026-06-15 07:02:53', '2026-06-15 07:02:53'),
(807, 317, 'products/2026/06/6a2fa39de0992.png', 0, '2026-06-15 07:02:53', '2026-06-15 07:02:53'),
(808, 317, 'products/2026/06/6a2fa39de25c4.png', 0, '2026-06-15 07:02:53', '2026-06-15 07:02:53'),
(809, 318, 'products/2026/06/6a2fa39de42a5.png', 1, '2026-06-15 07:02:53', '2026-06-15 07:02:53'),
(810, 318, 'products/2026/06/6a2fa39de5605.png', 0, '2026-06-15 07:02:53', '2026-06-15 07:02:53'),
(811, 318, 'products/2026/06/6a2fa39de6943.png', 0, '2026-06-15 07:02:53', '2026-06-15 07:02:53'),
(812, 318, 'products/2026/06/6a2fa39de7a45.png', 0, '2026-06-15 07:02:53', '2026-06-15 07:02:53'),
(813, 319, 'products/2026/06/6a2fa39de8d0f.png', 1, '2026-06-15 07:02:53', '2026-06-15 07:02:53'),
(814, 319, 'products/2026/06/6a2fa39de9eab.png', 0, '2026-06-15 07:02:53', '2026-06-15 07:02:53'),
(815, 319, 'products/2026/06/6a2fa39deb310.png', 0, '2026-06-15 07:02:53', '2026-06-15 07:02:53'),
(816, 319, 'products/2026/06/6a2fa39dec4cd.png', 0, '2026-06-15 07:02:53', '2026-06-15 07:02:53'),
(817, 320, 'products/2026/06/6a2fa39ded7cc.png', 1, '2026-06-15 07:02:53', '2026-06-15 07:02:53'),
(818, 320, 'products/2026/06/6a2fa39deed47.png', 0, '2026-06-15 07:02:53', '2026-06-15 07:02:53'),
(819, 320, 'products/2026/06/6a2fa39defe90.png', 0, '2026-06-15 07:02:53', '2026-06-15 07:02:53'),
(820, 320, 'products/2026/06/6a2fa39df1092.png', 0, '2026-06-15 07:02:53', '2026-06-15 07:02:53'),
(821, 321, 'products/2026/06/6a2fa39df23db.png', 1, '2026-06-15 07:02:53', '2026-06-15 07:02:53'),
(822, 321, 'products/2026/06/6a2fa39df3865.png', 0, '2026-06-15 07:02:53', '2026-06-15 07:02:53'),
(823, 321, 'products/2026/06/6a2fa39e007aa.png', 0, '2026-06-15 07:02:54', '2026-06-15 07:02:54'),
(824, 321, 'products/2026/06/6a2fa39e01951.png', 0, '2026-06-15 07:02:54', '2026-06-15 07:02:54'),
(825, 322, 'products/2026/06/6a2fa39e03195.png', 1, '2026-06-15 07:02:54', '2026-06-15 07:02:54'),
(826, 322, 'products/2026/06/6a2fa39e045fb.png', 0, '2026-06-15 07:02:54', '2026-06-15 07:02:54'),
(827, 322, 'products/2026/06/6a2fa39e0596c.png', 0, '2026-06-15 07:02:54', '2026-06-15 07:02:54'),
(828, 322, 'products/2026/06/6a2fa39e0736a.png', 0, '2026-06-15 07:02:54', '2026-06-15 07:02:54'),
(829, 323, 'products/2026/06/6a2fa39e087c2.png', 1, '2026-06-15 07:02:54', '2026-06-15 07:02:54'),
(830, 323, 'products/2026/06/6a2fa39e0a928.png', 0, '2026-06-15 07:02:54', '2026-06-15 07:02:54'),
(831, 323, 'products/2026/06/6a2fa39e0c8f8.png', 0, '2026-06-15 07:02:54', '2026-06-15 07:02:54'),
(832, 323, 'products/2026/06/6a2fa39e0e8bf.png', 0, '2026-06-15 07:02:54', '2026-06-15 07:02:54'),
(833, 324, 'products/2026/06/6a2fa39e10bee.png', 1, '2026-06-15 07:02:54', '2026-06-15 07:02:54'),
(834, 324, 'products/2026/06/6a2fa39e12913.png', 0, '2026-06-15 07:02:54', '2026-06-15 07:02:54'),
(835, 324, 'products/2026/06/6a2fa39e14723.png', 0, '2026-06-15 07:02:54', '2026-06-15 07:02:54'),
(836, 324, 'products/2026/06/6a2fa39e16464.png', 0, '2026-06-15 07:02:54', '2026-06-15 07:02:54'),
(837, 325, 'products/2026/06/6a2fa39e180eb.png', 1, '2026-06-15 07:02:54', '2026-06-15 07:02:54'),
(838, 325, 'products/2026/06/6a2fa39e19e17.png', 0, '2026-06-15 07:02:54', '2026-06-15 07:02:54'),
(839, 325, 'products/2026/06/6a2fa39e1c417.png', 0, '2026-06-15 07:02:54', '2026-06-15 07:02:54'),
(840, 325, 'products/2026/06/6a2fa39e1e36e.png', 0, '2026-06-15 07:02:54', '2026-06-15 07:02:54'),
(841, 326, 'products/2026/06/6a2fa39e202c7.png', 1, '2026-06-15 07:02:54', '2026-06-15 07:02:54'),
(842, 326, 'products/2026/06/6a2fa39e22108.png', 0, '2026-06-15 07:02:54', '2026-06-15 07:02:54'),
(843, 326, 'products/2026/06/6a2fa39e23fa3.png', 0, '2026-06-15 07:02:54', '2026-06-15 07:02:54'),
(844, 326, 'products/2026/06/6a2fa39e260dd.png', 0, '2026-06-15 07:02:54', '2026-06-15 07:02:54'),
(845, 327, 'products/2026/06/6a2fa39e27de7.png', 1, '2026-06-15 07:02:54', '2026-06-15 07:02:54'),
(846, 327, 'products/2026/06/6a2fa39e2999e.png', 0, '2026-06-15 07:02:54', '2026-06-15 07:02:54'),
(847, 327, 'products/2026/06/6a2fa39e2b4c4.png', 0, '2026-06-15 07:02:54', '2026-06-15 07:02:54'),
(848, 327, 'products/2026/06/6a2fa39e2d4b6.png', 0, '2026-06-15 07:02:54', '2026-06-15 07:02:54'),
(849, 328, 'products/2026/06/6a2fa39e2f111.png', 1, '2026-06-15 07:02:54', '2026-06-15 07:02:54'),
(850, 328, 'products/2026/06/6a2fa39e30f60.png', 0, '2026-06-15 07:02:54', '2026-06-15 07:02:54'),
(851, 328, 'products/2026/06/6a2fa39e329ba.png', 0, '2026-06-15 07:02:54', '2026-06-15 07:02:54'),
(852, 328, 'products/2026/06/6a2fa39e35325.png', 0, '2026-06-15 07:02:54', '2026-06-15 07:02:54'),
(853, 329, 'products/2026/06/6a2fa39e378c8.png', 1, '2026-06-15 07:02:54', '2026-06-15 07:02:54'),
(854, 329, 'products/2026/06/6a2fa39e39969.png', 0, '2026-06-15 07:02:54', '2026-06-15 07:02:54'),
(855, 329, 'products/2026/06/6a2fa39e3bf92.png', 0, '2026-06-15 07:02:54', '2026-06-15 07:02:54'),
(856, 329, 'products/2026/06/6a2fa39e3e3ac.png', 0, '2026-06-15 07:02:54', '2026-06-15 07:02:54'),
(857, 330, 'products/2026/06/6a2fa39e40e5b.png', 1, '2026-06-15 07:02:54', '2026-06-15 07:02:54'),
(858, 330, 'products/2026/06/6a2fa39e42c83.png', 0, '2026-06-15 07:02:54', '2026-06-15 07:02:54'),
(859, 330, 'products/2026/06/6a2fa39e45005.png', 0, '2026-06-15 07:02:54', '2026-06-15 07:02:54'),
(860, 330, 'products/2026/06/6a2fa39e46a42.png', 0, '2026-06-15 07:02:54', '2026-06-15 07:02:54'),
(861, 331, 'products/2026/06/6a2fa39e48315.png', 1, '2026-06-15 07:02:54', '2026-06-15 07:02:54'),
(862, 331, 'products/2026/06/6a2fa39e49d86.png', 0, '2026-06-15 07:02:54', '2026-06-15 07:02:54'),
(863, 331, 'products/2026/06/6a2fa39e4bd1c.png', 0, '2026-06-15 07:02:54', '2026-06-15 07:02:54'),
(864, 331, 'products/2026/06/6a2fa39e4dabe.png', 0, '2026-06-15 07:02:54', '2026-06-15 07:02:54'),
(865, 332, 'products/2026/06/6a2fa39e51eea.png', 1, '2026-06-15 07:02:54', '2026-06-15 07:02:54'),
(866, 332, 'products/2026/06/6a2fa39e5532b.png', 0, '2026-06-15 07:02:54', '2026-06-15 07:02:54'),
(867, 332, 'products/2026/06/6a2fa39e5794f.png', 0, '2026-06-15 07:02:54', '2026-06-15 07:02:54'),
(868, 332, 'products/2026/06/6a2fa39e59e3f.png', 0, '2026-06-15 07:02:54', '2026-06-15 07:02:54'),
(869, 333, 'products/2026/06/6a2fa39e5c443.png', 1, '2026-06-15 07:02:54', '2026-06-15 07:02:54'),
(870, 333, 'products/2026/06/6a2fa39e5de01.png', 0, '2026-06-15 07:02:54', '2026-06-15 07:02:54'),
(871, 333, 'products/2026/06/6a2fa39e60940.png', 0, '2026-06-15 07:02:54', '2026-06-15 07:02:54'),
(872, 333, 'products/2026/06/6a2fa39e62807.png', 0, '2026-06-15 07:02:54', '2026-06-15 07:02:54'),
(873, 334, 'products/2026/06/6a2fa39e65796.png', 1, '2026-06-15 07:02:54', '2026-06-15 07:02:54'),
(874, 334, 'products/2026/06/6a2fa39e672be.png', 0, '2026-06-15 07:02:54', '2026-06-15 07:02:54'),
(875, 334, 'products/2026/06/6a2fa39e68ca1.png', 0, '2026-06-15 07:02:54', '2026-06-15 07:02:54'),
(876, 334, 'products/2026/06/6a2fa39e6a93c.png', 0, '2026-06-15 07:02:54', '2026-06-15 07:02:54'),
(877, 251, 'products/2026/06/6a438bd1d70a9.png', 1, '2026-06-30 09:26:41', '2026-06-30 09:26:41'),
(878, 251, 'products/2026/06/6a438bd1eac90.png', 0, '2026-06-30 09:26:41', '2026-06-30 09:26:41'),
(879, 251, 'products/2026/06/6a438bd1ee356.png', 0, '2026-06-30 09:26:41', '2026-06-30 09:26:41'),
(880, 251, 'products/2026/06/6a438bd1f1f6a.png', 0, '2026-06-30 09:26:41', '2026-06-30 09:26:41'),
(881, 252, 'products/2026/06/6a438bd20150f.png', 1, '2026-06-30 09:26:42', '2026-06-30 09:26:42'),
(882, 252, 'products/2026/06/6a438bd2053be.png', 0, '2026-06-30 09:26:42', '2026-06-30 09:26:42'),
(883, 252, 'products/2026/06/6a438bd208fdf.png', 0, '2026-06-30 09:26:42', '2026-06-30 09:26:42'),
(884, 252, 'products/2026/06/6a438bd20cbc9.png', 0, '2026-06-30 09:26:42', '2026-06-30 09:26:42'),
(885, 253, 'products/2026/06/6a438bd21013b.png', 1, '2026-06-30 09:26:42', '2026-06-30 09:26:42'),
(886, 253, 'products/2026/06/6a438bd2139fa.png', 0, '2026-06-30 09:26:42', '2026-06-30 09:26:42'),
(887, 253, 'products/2026/06/6a438bd21739b.png', 0, '2026-06-30 09:26:42', '2026-06-30 09:26:42'),
(888, 253, 'products/2026/06/6a438bd21a883.png', 0, '2026-06-30 09:26:42', '2026-06-30 09:26:42'),
(889, 254, 'products/2026/06/6a438bd21e136.png', 1, '2026-06-30 09:26:42', '2026-06-30 09:26:42'),
(890, 254, 'products/2026/06/6a438bd221837.png', 0, '2026-06-30 09:26:42', '2026-06-30 09:26:42'),
(891, 254, 'products/2026/06/6a438bd2250be.png', 0, '2026-06-30 09:26:42', '2026-06-30 09:26:42'),
(892, 254, 'products/2026/06/6a438bd2294ed.png', 0, '2026-06-30 09:26:42', '2026-06-30 09:26:42'),
(893, 255, 'products/2026/06/6a438bd22c961.png', 1, '2026-06-30 09:26:42', '2026-06-30 09:26:42'),
(894, 255, 'products/2026/06/6a438bd230783.png', 0, '2026-06-30 09:26:42', '2026-06-30 09:26:42'),
(895, 255, 'products/2026/06/6a438bd234779.png', 0, '2026-06-30 09:26:42', '2026-06-30 09:26:42'),
(896, 255, 'products/2026/06/6a438bd23845c.png', 0, '2026-06-30 09:26:42', '2026-06-30 09:26:42'),
(897, 256, 'products/2026/06/6a438bd23c0f1.png', 1, '2026-06-30 09:26:42', '2026-06-30 09:26:42'),
(898, 256, 'products/2026/06/6a438bd2404e7.png', 0, '2026-06-30 09:26:42', '2026-06-30 09:26:42'),
(899, 256, 'products/2026/06/6a438bd24413c.png', 0, '2026-06-30 09:26:42', '2026-06-30 09:26:42'),
(900, 256, 'products/2026/06/6a438bd247e2e.png', 0, '2026-06-30 09:26:42', '2026-06-30 09:26:42'),
(901, 257, 'products/2026/06/6a438bd24b8af.png', 1, '2026-06-30 09:26:42', '2026-06-30 09:26:42'),
(902, 257, 'products/2026/06/6a438bd24ee6b.png', 0, '2026-06-30 09:26:42', '2026-06-30 09:26:42'),
(903, 257, 'products/2026/06/6a438bd2521f5.png', 0, '2026-06-30 09:26:42', '2026-06-30 09:26:42'),
(904, 257, 'products/2026/06/6a438bd25596c.png', 0, '2026-06-30 09:26:42', '2026-06-30 09:26:42'),
(905, 258, 'products/2026/06/6a438bd259900.png', 1, '2026-06-30 09:26:42', '2026-06-30 09:26:42'),
(906, 258, 'products/2026/06/6a438bd25cdbb.png', 0, '2026-06-30 09:26:42', '2026-06-30 09:26:42'),
(907, 258, 'products/2026/06/6a438bd25ff42.png', 0, '2026-06-30 09:26:42', '2026-06-30 09:26:42'),
(908, 258, 'products/2026/06/6a438bd26385a.png', 0, '2026-06-30 09:26:42', '2026-06-30 09:26:42'),
(909, 259, 'products/2026/06/6a438bd267146.png', 1, '2026-06-30 09:26:42', '2026-06-30 09:26:42'),
(910, 259, 'products/2026/06/6a438bd26a95c.png', 0, '2026-06-30 09:26:42', '2026-06-30 09:26:42'),
(911, 259, 'products/2026/06/6a438bd26eae7.png', 0, '2026-06-30 09:26:42', '2026-06-30 09:26:42'),
(912, 259, 'products/2026/06/6a438bd271e8a.png', 0, '2026-06-30 09:26:42', '2026-06-30 09:26:42'),
(913, 260, 'products/2026/06/6a438bd275a04.png', 1, '2026-06-30 09:26:42', '2026-06-30 09:26:42'),
(914, 260, 'products/2026/06/6a438bd279287.png', 0, '2026-06-30 09:26:42', '2026-06-30 09:26:42'),
(915, 260, 'products/2026/06/6a438bd27c894.png', 0, '2026-06-30 09:26:42', '2026-06-30 09:26:42'),
(916, 260, 'products/2026/06/6a438bd27fb5c.png', 0, '2026-06-30 09:26:42', '2026-06-30 09:26:42'),
(917, 261, 'products/2026/06/6a438bd282bdc.png', 1, '2026-06-30 09:26:42', '2026-06-30 09:26:42'),
(918, 261, 'products/2026/06/6a438bd285950.png', 0, '2026-06-30 09:26:42', '2026-06-30 09:26:42'),
(919, 261, 'products/2026/06/6a438bd288b06.png', 0, '2026-06-30 09:26:42', '2026-06-30 09:26:42'),
(920, 261, 'products/2026/06/6a438bd28b99a.png', 0, '2026-06-30 09:26:42', '2026-06-30 09:26:42'),
(921, 262, 'products/2026/06/6a438bd28ed5f.png', 1, '2026-06-30 09:26:42', '2026-06-30 09:26:42'),
(922, 262, 'products/2026/06/6a438bd291eb7.png', 0, '2026-06-30 09:26:42', '2026-06-30 09:26:42'),
(923, 262, 'products/2026/06/6a438bd294e02.png', 0, '2026-06-30 09:26:42', '2026-06-30 09:26:42'),
(924, 262, 'products/2026/06/6a438bd297f4f.png', 0, '2026-06-30 09:26:42', '2026-06-30 09:26:42'),
(925, 263, 'products/2026/06/6a438bd29b3ac.png', 1, '2026-06-30 09:26:42', '2026-06-30 09:26:42'),
(926, 263, 'products/2026/06/6a438bd29e7ef.png', 0, '2026-06-30 09:26:42', '2026-06-30 09:26:42'),
(927, 263, 'products/2026/06/6a438bd2a15ba.png', 0, '2026-06-30 09:26:42', '2026-06-30 09:26:42'),
(928, 263, 'products/2026/06/6a438bd2a43ff.png', 0, '2026-06-30 09:26:42', '2026-06-30 09:26:42'),
(929, 264, 'products/2026/06/6a438bd2a74fd.png', 1, '2026-06-30 09:26:42', '2026-06-30 09:26:42'),
(930, 264, 'products/2026/06/6a438bd2aa107.png', 0, '2026-06-30 09:26:42', '2026-06-30 09:26:42'),
(931, 264, 'products/2026/06/6a438bd2ad896.png', 0, '2026-06-30 09:26:42', '2026-06-30 09:26:42'),
(932, 264, 'products/2026/06/6a438bd2b0b5e.png', 0, '2026-06-30 09:26:42', '2026-06-30 09:26:42'),
(933, 265, 'products/2026/06/6a438bd2b3f66.png', 1, '2026-06-30 09:26:42', '2026-06-30 09:26:42'),
(934, 265, 'products/2026/06/6a438bd2b764d.png', 0, '2026-06-30 09:26:42', '2026-06-30 09:26:42'),
(935, 265, 'products/2026/06/6a438bd2bb0d9.png', 0, '2026-06-30 09:26:42', '2026-06-30 09:26:42'),
(936, 265, 'products/2026/06/6a438bd2be666.png', 0, '2026-06-30 09:26:42', '2026-06-30 09:26:42'),
(937, 266, 'products/2026/06/6a438bd2c1959.png', 1, '2026-06-30 09:26:42', '2026-06-30 09:26:42'),
(938, 266, 'products/2026/06/6a438bd2c488d.png', 0, '2026-06-30 09:26:42', '2026-06-30 09:26:42'),
(939, 266, 'products/2026/06/6a438bd2c7cad.png', 0, '2026-06-30 09:26:42', '2026-06-30 09:26:42'),
(940, 266, 'products/2026/06/6a438bd2caa17.png', 0, '2026-06-30 09:26:42', '2026-06-30 09:26:42'),
(941, 267, 'products/2026/06/6a438bd2cda5e.png', 1, '2026-06-30 09:26:42', '2026-06-30 09:26:42'),
(942, 267, 'products/2026/06/6a438bd2d0c0f.png', 0, '2026-06-30 09:26:42', '2026-06-30 09:26:42'),
(943, 267, 'products/2026/06/6a438bd2d3d06.png', 0, '2026-06-30 09:26:42', '2026-06-30 09:26:42'),
(944, 267, 'products/2026/06/6a438bd2d7b27.png', 0, '2026-06-30 09:26:42', '2026-06-30 09:26:42'),
(945, 268, 'products/2026/06/6a438bd2db184.png', 1, '2026-06-30 09:26:42', '2026-06-30 09:26:42'),
(946, 268, 'products/2026/06/6a438bd2de61f.png', 0, '2026-06-30 09:26:42', '2026-06-30 09:26:42'),
(947, 268, 'products/2026/06/6a438bd2e1e64.png', 0, '2026-06-30 09:26:42', '2026-06-30 09:26:42'),
(948, 268, 'products/2026/06/6a438bd2e5005.png', 0, '2026-06-30 09:26:42', '2026-06-30 09:26:42'),
(949, 269, 'products/2026/06/6a438bd2e8201.png', 1, '2026-06-30 09:26:42', '2026-06-30 09:26:42'),
(950, 269, 'products/2026/06/6a438bd2eb3f9.png', 0, '2026-06-30 09:26:42', '2026-06-30 09:26:42'),
(951, 269, 'products/2026/06/6a438bd2ee47e.png', 0, '2026-06-30 09:26:42', '2026-06-30 09:26:42'),
(952, 269, 'products/2026/06/6a438bd2f3a8b.png', 0, '2026-06-30 09:26:43', '2026-06-30 09:26:43'),
(953, 270, 'products/2026/06/6a438bd30415d.png', 1, '2026-06-30 09:26:43', '2026-06-30 09:26:43'),
(954, 270, 'products/2026/06/6a438bd307885.png', 0, '2026-06-30 09:26:43', '2026-06-30 09:26:43'),
(955, 270, 'products/2026/06/6a438bd30abf1.png', 0, '2026-06-30 09:26:43', '2026-06-30 09:26:43'),
(956, 270, 'products/2026/06/6a438bd30de5a.png', 0, '2026-06-30 09:26:43', '2026-06-30 09:26:43'),
(957, 271, 'products/2026/06/6a438bd311ad1.png', 1, '2026-06-30 09:26:43', '2026-06-30 09:26:43'),
(958, 271, 'products/2026/06/6a438bd315367.png', 0, '2026-06-30 09:26:43', '2026-06-30 09:26:43'),
(959, 271, 'products/2026/06/6a438bd31886a.png', 0, '2026-06-30 09:26:43', '2026-06-30 09:26:43'),
(960, 271, 'products/2026/06/6a438bd31c335.png', 0, '2026-06-30 09:26:43', '2026-06-30 09:26:43'),
(961, 272, 'products/2026/06/6a438bd31fd86.png', 1, '2026-06-30 09:26:43', '2026-06-30 09:26:43'),
(962, 272, 'products/2026/06/6a438bd32329d.png', 0, '2026-06-30 09:26:43', '2026-06-30 09:26:43'),
(963, 272, 'products/2026/06/6a438bd326a31.png', 0, '2026-06-30 09:26:43', '2026-06-30 09:26:43'),
(964, 272, 'products/2026/06/6a438bd329f4c.png', 0, '2026-06-30 09:26:43', '2026-06-30 09:26:43'),
(965, 273, 'products/2026/06/6a438bd32d678.png', 1, '2026-06-30 09:26:43', '2026-06-30 09:26:43'),
(966, 273, 'products/2026/06/6a438bd330e28.png', 0, '2026-06-30 09:26:43', '2026-06-30 09:26:43'),
(967, 273, 'products/2026/06/6a438bd3340be.png', 0, '2026-06-30 09:26:43', '2026-06-30 09:26:43'),
(968, 273, 'products/2026/06/6a438bd336f00.png', 0, '2026-06-30 09:26:43', '2026-06-30 09:26:43'),
(969, 274, 'products/2026/06/6a438bd339ef9.png', 1, '2026-06-30 09:26:43', '2026-06-30 09:26:43'),
(970, 274, 'products/2026/06/6a438bd33d458.png', 0, '2026-06-30 09:26:43', '2026-06-30 09:26:43'),
(971, 274, 'products/2026/06/6a438bd34125b.png', 0, '2026-06-30 09:26:43', '2026-06-30 09:26:43'),
(972, 274, 'products/2026/06/6a438bd345708.png', 0, '2026-06-30 09:26:43', '2026-06-30 09:26:43'),
(973, 275, 'products/2026/06/6a438bd349455.png', 1, '2026-06-30 09:26:43', '2026-06-30 09:26:43'),
(974, 275, 'products/2026/06/6a438bd350055.png', 0, '2026-06-30 09:26:43', '2026-06-30 09:26:43'),
(975, 275, 'products/2026/06/6a438bd356ece.png', 0, '2026-06-30 09:26:43', '2026-06-30 09:26:43'),
(976, 275, 'products/2026/06/6a438bd35c901.png', 0, '2026-06-30 09:26:43', '2026-06-30 09:26:43'),
(977, 276, 'products/2026/06/6a438bd36049d.png', 1, '2026-06-30 09:26:43', '2026-06-30 09:26:43'),
(978, 276, 'products/2026/06/6a438bd363a3a.png', 0, '2026-06-30 09:26:43', '2026-06-30 09:26:43'),
(979, 276, 'products/2026/06/6a438bd367691.png', 0, '2026-06-30 09:26:43', '2026-06-30 09:26:43'),
(980, 276, 'products/2026/06/6a438bd36b696.png', 0, '2026-06-30 09:26:43', '2026-06-30 09:26:43'),
(981, 277, 'products/2026/06/6a438bd36f136.png', 1, '2026-06-30 09:26:43', '2026-06-30 09:26:43'),
(982, 277, 'products/2026/06/6a438bd372b1d.png', 0, '2026-06-30 09:26:43', '2026-06-30 09:26:43'),
(983, 277, 'products/2026/06/6a438bd375fbe.png', 0, '2026-06-30 09:26:43', '2026-06-30 09:26:43'),
(984, 277, 'products/2026/06/6a438bd379426.png', 0, '2026-06-30 09:26:43', '2026-06-30 09:26:43'),
(985, 278, 'products/2026/06/6a438bd37c18d.png', 1, '2026-06-30 09:26:43', '2026-06-30 09:26:43'),
(986, 278, 'products/2026/06/6a438bd37fb21.png', 0, '2026-06-30 09:26:43', '2026-06-30 09:26:43'),
(987, 278, 'products/2026/06/6a438bd382f46.png', 0, '2026-06-30 09:26:43', '2026-06-30 09:26:43'),
(988, 278, 'products/2026/06/6a438bd3863bc.png', 0, '2026-06-30 09:26:43', '2026-06-30 09:26:43'),
(989, 279, 'products/2026/06/6a438bd3893ab.png', 1, '2026-06-30 09:26:43', '2026-06-30 09:26:43'),
(990, 279, 'products/2026/06/6a438bd38c92d.png', 0, '2026-06-30 09:26:43', '2026-06-30 09:26:43'),
(991, 279, 'products/2026/06/6a438bd390631.png', 0, '2026-06-30 09:26:43', '2026-06-30 09:26:43'),
(992, 279, 'products/2026/06/6a438bd393ee9.png', 0, '2026-06-30 09:26:43', '2026-06-30 09:26:43'),
(993, 280, 'products/2026/06/6a438bd397cc2.png', 1, '2026-06-30 09:26:43', '2026-06-30 09:26:43'),
(994, 280, 'products/2026/06/6a438bd39b71c.png', 0, '2026-06-30 09:26:43', '2026-06-30 09:26:43'),
(995, 280, 'products/2026/06/6a438bd39f0f2.png', 0, '2026-06-30 09:26:43', '2026-06-30 09:26:43'),
(996, 280, 'products/2026/06/6a438bd3a2a9e.png', 0, '2026-06-30 09:26:43', '2026-06-30 09:26:43'),
(997, 281, 'products/2026/06/6a438bd3a679d.png', 1, '2026-06-30 09:26:43', '2026-06-30 09:26:43'),
(998, 281, 'products/2026/06/6a438bd3a9bf7.png', 0, '2026-06-30 09:26:43', '2026-06-30 09:26:43'),
(999, 281, 'products/2026/06/6a438bd3ad03f.png', 0, '2026-06-30 09:26:43', '2026-06-30 09:26:43'),
(1000, 281, 'products/2026/06/6a438bd3b0022.png', 0, '2026-06-30 09:26:43', '2026-06-30 09:26:43'),
(1001, 308, 'products/2026/06/6a438bd703d26.png', 1, '2026-06-30 09:26:47', '2026-06-30 09:26:47'),
(1002, 308, 'products/2026/06/6a438bd706b81.png', 0, '2026-06-30 09:26:47', '2026-06-30 09:26:47'),
(1003, 308, 'products/2026/06/6a438bd709193.png', 0, '2026-06-30 09:26:47', '2026-06-30 09:26:47'),
(1004, 308, 'products/2026/06/6a438bd70bc7d.png', 0, '2026-06-30 09:26:47', '2026-06-30 09:26:47'),
(1005, 309, 'products/2026/06/6a438bd70e9cc.png', 1, '2026-06-30 09:26:47', '2026-06-30 09:26:47'),
(1006, 309, 'products/2026/06/6a438bd711461.png', 0, '2026-06-30 09:26:47', '2026-06-30 09:26:47'),
(1007, 309, 'products/2026/06/6a438bd71419d.png', 0, '2026-06-30 09:26:47', '2026-06-30 09:26:47'),
(1008, 309, 'products/2026/06/6a438bd716a6d.png', 0, '2026-06-30 09:26:47', '2026-06-30 09:26:47'),
(1009, 310, 'products/2026/06/6a438bd7197b6.png', 1, '2026-06-30 09:26:47', '2026-06-30 09:26:47'),
(1010, 310, 'products/2026/06/6a438bd71c0f1.png', 0, '2026-06-30 09:26:47', '2026-06-30 09:26:47'),
(1011, 310, 'products/2026/06/6a438bd71e5c9.png', 0, '2026-06-30 09:26:47', '2026-06-30 09:26:47'),
(1012, 310, 'products/2026/06/6a438bd7210f3.png', 0, '2026-06-30 09:26:47', '2026-06-30 09:26:47'),
(1013, 311, 'products/2026/06/6a438bd723c1e.png', 1, '2026-06-30 09:26:47', '2026-06-30 09:26:47'),
(1014, 311, 'products/2026/06/6a438bd726525.png', 0, '2026-06-30 09:26:47', '2026-06-30 09:26:47'),
(1015, 311, 'products/2026/06/6a438bd7292e3.png', 0, '2026-06-30 09:26:47', '2026-06-30 09:26:47'),
(1016, 311, 'products/2026/06/6a438bd72bb73.png', 0, '2026-06-30 09:26:47', '2026-06-30 09:26:47'),
(1017, 312, 'products/2026/06/6a438bd72e0d6.png', 1, '2026-06-30 09:26:47', '2026-06-30 09:26:47'),
(1018, 312, 'products/2026/06/6a438bd730cb6.png', 0, '2026-06-30 09:26:47', '2026-06-30 09:26:47'),
(1019, 312, 'products/2026/06/6a438bd7335ff.png', 0, '2026-06-30 09:26:47', '2026-06-30 09:26:47'),
(1020, 312, 'products/2026/06/6a438bd736166.png', 0, '2026-06-30 09:26:47', '2026-06-30 09:26:47'),
(1021, 313, 'products/2026/06/6a438bd738d48.png', 1, '2026-06-30 09:26:47', '2026-06-30 09:26:47'),
(1022, 313, 'products/2026/06/6a438bd73b673.png', 0, '2026-06-30 09:26:47', '2026-06-30 09:26:47'),
(1023, 313, 'products/2026/06/6a438bd73e086.png', 0, '2026-06-30 09:26:47', '2026-06-30 09:26:47'),
(1024, 313, 'products/2026/06/6a438bd741393.png', 0, '2026-06-30 09:26:47', '2026-06-30 09:26:47'),
(1025, 314, 'products/2026/06/6a438bd74400e.png', 1, '2026-06-30 09:26:47', '2026-06-30 09:26:47'),
(1026, 314, 'products/2026/06/6a438bd746779.png', 0, '2026-06-30 09:26:47', '2026-06-30 09:26:47'),
(1027, 314, 'products/2026/06/6a438bd7491db.png', 0, '2026-06-30 09:26:47', '2026-06-30 09:26:47'),
(1028, 314, 'products/2026/06/6a438bd74b729.png', 0, '2026-06-30 09:26:47', '2026-06-30 09:26:47'),
(1029, 315, 'products/2026/06/6a438bd74f2f4.png', 1, '2026-06-30 09:26:47', '2026-06-30 09:26:47'),
(1030, 315, 'products/2026/06/6a438bd7518b5.png', 0, '2026-06-30 09:26:47', '2026-06-30 09:26:47'),
(1031, 315, 'products/2026/06/6a438bd754063.png', 0, '2026-06-30 09:26:47', '2026-06-30 09:26:47'),
(1032, 315, 'products/2026/06/6a438bd756375.png', 0, '2026-06-30 09:26:47', '2026-06-30 09:26:47'),
(1033, 316, 'products/2026/06/6a438bd7587b5.png', 1, '2026-06-30 09:26:47', '2026-06-30 09:26:47'),
(1034, 316, 'products/2026/06/6a438bd75a9b7.png', 0, '2026-06-30 09:26:47', '2026-06-30 09:26:47'),
(1035, 316, 'products/2026/06/6a438bd75ce6d.png', 0, '2026-06-30 09:26:47', '2026-06-30 09:26:47'),
(1036, 316, 'products/2026/06/6a438bd75eebb.png', 0, '2026-06-30 09:26:47', '2026-06-30 09:26:47'),
(1037, 317, 'products/2026/06/6a438bd7611bc.png', 1, '2026-06-30 09:26:47', '2026-06-30 09:26:47'),
(1038, 317, 'products/2026/06/6a438bd763848.png', 0, '2026-06-30 09:26:47', '2026-06-30 09:26:47'),
(1039, 317, 'products/2026/06/6a438bd766351.png', 0, '2026-06-30 09:26:47', '2026-06-30 09:26:47'),
(1040, 317, 'products/2026/06/6a438bd769045.png', 0, '2026-06-30 09:26:47', '2026-06-30 09:26:47'),
(1041, 318, 'products/2026/06/6a438bd76bfe4.png', 1, '2026-06-30 09:26:47', '2026-06-30 09:26:47'),
(1042, 318, 'products/2026/06/6a438bd76fe09.png', 0, '2026-06-30 09:26:47', '2026-06-30 09:26:47'),
(1043, 318, 'products/2026/06/6a438bd772cbb.png', 0, '2026-06-30 09:26:47', '2026-06-30 09:26:47'),
(1044, 318, 'products/2026/06/6a438bd7757f9.png', 0, '2026-06-30 09:26:47', '2026-06-30 09:26:47'),
(1045, 319, 'products/2026/06/6a438bd778120.png', 1, '2026-06-30 09:26:47', '2026-06-30 09:26:47'),
(1046, 319, 'products/2026/06/6a438bd77ae96.png', 0, '2026-06-30 09:26:47', '2026-06-30 09:26:47'),
(1047, 319, 'products/2026/06/6a438bd77dd77.png', 0, '2026-06-30 09:26:47', '2026-06-30 09:26:47'),
(1048, 319, 'products/2026/06/6a438bd78041a.png', 0, '2026-06-30 09:26:47', '2026-06-30 09:26:47'),
(1049, 320, 'products/2026/06/6a438bd7831ae.png', 1, '2026-06-30 09:26:47', '2026-06-30 09:26:47'),
(1050, 320, 'products/2026/06/6a438bd786498.png', 0, '2026-06-30 09:26:47', '2026-06-30 09:26:47'),
(1051, 320, 'products/2026/06/6a438bd78940d.png', 0, '2026-06-30 09:26:47', '2026-06-30 09:26:47'),
(1052, 320, 'products/2026/06/6a438bd78c492.png', 0, '2026-06-30 09:26:47', '2026-06-30 09:26:47'),
(1053, 321, 'products/2026/06/6a438bd78f59d.png', 1, '2026-06-30 09:26:47', '2026-06-30 09:26:47'),
(1054, 321, 'products/2026/06/6a438bd792333.png', 0, '2026-06-30 09:26:47', '2026-06-30 09:26:47'),
(1055, 321, 'products/2026/06/6a438bd794880.png', 0, '2026-06-30 09:26:47', '2026-06-30 09:26:47'),
(1056, 321, 'products/2026/06/6a438bd7975c4.png', 0, '2026-06-30 09:26:47', '2026-06-30 09:26:47'),
(1057, 322, 'products/2026/06/6a438bd799f3d.png', 1, '2026-06-30 09:26:47', '2026-06-30 09:26:47'),
(1058, 322, 'products/2026/06/6a438bd79c8fc.png', 0, '2026-06-30 09:26:47', '2026-06-30 09:26:47'),
(1059, 322, 'products/2026/06/6a438bd79f7e6.png', 0, '2026-06-30 09:26:47', '2026-06-30 09:26:47'),
(1060, 322, 'products/2026/06/6a438bd7a22f8.png', 0, '2026-06-30 09:26:47', '2026-06-30 09:26:47'),
(1061, 323, 'products/2026/06/6a438bd7a53d7.png', 1, '2026-06-30 09:26:47', '2026-06-30 09:26:47'),
(1062, 323, 'products/2026/06/6a438bd7a7ef3.png', 0, '2026-06-30 09:26:47', '2026-06-30 09:26:47'),
(1063, 323, 'products/2026/06/6a438bd7aaefe.png', 0, '2026-06-30 09:26:47', '2026-06-30 09:26:47'),
(1064, 323, 'products/2026/06/6a438bd7adcb3.png', 0, '2026-06-30 09:26:47', '2026-06-30 09:26:47'),
(1065, 324, 'products/2026/06/6a438bd7b0705.png', 1, '2026-06-30 09:26:47', '2026-06-30 09:26:47'),
(1066, 324, 'products/2026/06/6a438bd7b3325.png', 0, '2026-06-30 09:26:47', '2026-06-30 09:26:47'),
(1067, 324, 'products/2026/06/6a438bd7b60ed.png', 0, '2026-06-30 09:26:47', '2026-06-30 09:26:47'),
(1068, 324, 'products/2026/06/6a438bd7b8c30.png', 0, '2026-06-30 09:26:47', '2026-06-30 09:26:47'),
(1069, 325, 'products/2026/06/6a438bd7bb66b.png', 1, '2026-06-30 09:26:47', '2026-06-30 09:26:47'),
(1070, 325, 'products/2026/06/6a438bd7be30c.png', 0, '2026-06-30 09:26:47', '2026-06-30 09:26:47'),
(1071, 325, 'products/2026/06/6a438bd7c1163.png', 0, '2026-06-30 09:26:47', '2026-06-30 09:26:47'),
(1072, 325, 'products/2026/06/6a438bd7c3c80.png', 0, '2026-06-30 09:26:47', '2026-06-30 09:26:47'),
(1073, 326, 'products/2026/06/6a438bd7c67cf.png', 1, '2026-06-30 09:26:47', '2026-06-30 09:26:47'),
(1074, 326, 'products/2026/06/6a438bd7c9baf.png', 0, '2026-06-30 09:26:47', '2026-06-30 09:26:47'),
(1075, 326, 'products/2026/06/6a438bd7ccd00.png', 0, '2026-06-30 09:26:47', '2026-06-30 09:26:47'),
(1076, 326, 'products/2026/06/6a438bd7cfd83.png', 0, '2026-06-30 09:26:47', '2026-06-30 09:26:47'),
(1077, 327, 'products/2026/06/6a438bd7d3a24.png', 1, '2026-06-30 09:26:47', '2026-06-30 09:26:47'),
(1078, 327, 'products/2026/06/6a438bd7d7730.png', 0, '2026-06-30 09:26:47', '2026-06-30 09:26:47'),
(1079, 327, 'products/2026/06/6a438bd7da7e6.png', 0, '2026-06-30 09:26:47', '2026-06-30 09:26:47'),
(1080, 327, 'products/2026/06/6a438bd7dd083.png', 0, '2026-06-30 09:26:47', '2026-06-30 09:26:47'),
(1081, 328, 'products/2026/06/6a438bd7dffed.png', 1, '2026-06-30 09:26:47', '2026-06-30 09:26:47'),
(1082, 328, 'products/2026/06/6a438bd7e2a2d.png', 0, '2026-06-30 09:26:47', '2026-06-30 09:26:47'),
(1083, 328, 'products/2026/06/6a438bd7e5b09.png', 0, '2026-06-30 09:26:47', '2026-06-30 09:26:47'),
(1084, 328, 'products/2026/06/6a438bd7eacaa.png', 0, '2026-06-30 09:26:47', '2026-06-30 09:26:47'),
(1085, 329, 'products/2026/06/6a438bd7ed49f.png', 1, '2026-06-30 09:26:47', '2026-06-30 09:26:47'),
(1086, 329, 'products/2026/06/6a438bd7f0287.png', 0, '2026-06-30 09:26:47', '2026-06-30 09:26:47'),
(1087, 329, 'products/2026/06/6a438bd7f2ebf.png', 0, '2026-06-30 09:26:48', '2026-06-30 09:26:48'),
(1088, 329, 'products/2026/06/6a438bd801b1e.png', 0, '2026-06-30 09:26:48', '2026-06-30 09:26:48'),
(1089, 330, 'products/2026/06/6a438bd804a4b.png', 1, '2026-06-30 09:26:48', '2026-06-30 09:26:48'),
(1090, 330, 'products/2026/06/6a438bd807d1f.png', 0, '2026-06-30 09:26:48', '2026-06-30 09:26:48'),
(1091, 330, 'products/2026/06/6a438bd80b145.png', 0, '2026-06-30 09:26:48', '2026-06-30 09:26:48'),
(1092, 330, 'products/2026/06/6a438bd80df37.png', 0, '2026-06-30 09:26:48', '2026-06-30 09:26:48'),
(1093, 331, 'products/2026/06/6a438bd811805.png', 1, '2026-06-30 09:26:48', '2026-06-30 09:26:48'),
(1094, 331, 'products/2026/06/6a438bd815359.png', 0, '2026-06-30 09:26:48', '2026-06-30 09:26:48'),
(1095, 331, 'products/2026/06/6a438bd818ac8.png', 0, '2026-06-30 09:26:48', '2026-06-30 09:26:48'),
(1096, 331, 'products/2026/06/6a438bd81bd18.png', 0, '2026-06-30 09:26:48', '2026-06-30 09:26:48'),
(1097, 332, 'products/2026/06/6a438bd81ec09.png', 1, '2026-06-30 09:26:48', '2026-06-30 09:26:48'),
(1098, 332, 'products/2026/06/6a438bd82194a.png', 0, '2026-06-30 09:26:48', '2026-06-30 09:26:48'),
(1099, 332, 'products/2026/06/6a438bd824f3f.png', 0, '2026-06-30 09:26:48', '2026-06-30 09:26:48'),
(1100, 332, 'products/2026/06/6a438bd827db0.png', 0, '2026-06-30 09:26:48', '2026-06-30 09:26:48'),
(1101, 333, 'products/2026/06/6a438bd82ae0f.png', 1, '2026-06-30 09:26:48', '2026-06-30 09:26:48'),
(1102, 333, 'products/2026/06/6a438bd82e0a9.png', 0, '2026-06-30 09:26:48', '2026-06-30 09:26:48'),
(1103, 333, 'products/2026/06/6a438bd833e9b.png', 0, '2026-06-30 09:26:48', '2026-06-30 09:26:48'),
(1104, 333, 'products/2026/06/6a438bd83a15b.png', 0, '2026-06-30 09:26:48', '2026-06-30 09:26:48'),
(1105, 334, 'products/2026/06/6a438bd83d4e6.png', 1, '2026-06-30 09:26:48', '2026-06-30 09:26:48'),
(1106, 334, 'products/2026/06/6a438bd840b5a.png', 0, '2026-06-30 09:26:48', '2026-06-30 09:26:48'),
(1107, 334, 'products/2026/06/6a438bd8438cc.png', 0, '2026-06-30 09:26:48', '2026-06-30 09:26:48'),
(1108, 334, 'products/2026/06/6a438bd846a23.png', 0, '2026-06-30 09:26:48', '2026-06-30 09:26:48');

-- --------------------------------------------------------

--
-- Table structure for table `product_sub_categories`
--

CREATE TABLE `product_sub_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_categories_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(150) NOT NULL,
  `slug` varchar(160) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_sub_categories`
--

INSERT INTO `product_sub_categories` (`id`, `product_categories_id`, `name`, `slug`, `status`) VALUES
(1, 1, 'Strollers & Prams', 'strollers-prams', 1),
(2, 1, 'Car Seats & Boosters', 'car-seats-boosters', 1),
(3, 1, 'Baby Carriers & Slings', 'baby-carriers-slings', 1),
(4, 1, 'Walkers & Activity Centers', 'walkers-activity-centers', 1),
(5, 1, 'High Chairs & Booster Seats', 'high-chairs-booster-seats', 1),
(6, 1, 'Cradles & Bassinets', 'cradles-bassinets', 1),
(7, 1, 'Baby Cribs & Furniture', 'baby-cribs-furniture', 1),
(8, 1, 'Ride-ons & Kids Cycles', 'ride-ons-kids-cycles', 1),
(9, 1, 'Baby Bedding & Blankets', 'baby-bedding-blankets', 1),
(18, 3, 'Birthday Decorations', 'birthday-decorations', 1),
(19, 3, 'Party Supplies', 'party-supplies', 1),
(20, 3, 'Theme Party Kits', 'theme-party-kits', 1),
(21, 3, 'Return Gifts', 'return-gifts', 1),
(22, 3, 'Gift Hampers', 'gift-hampers', 1),
(23, 3, 'Greeting Cards', 'greeting-cards', 1),
(24, 4, 'Story Books', 'story-books', 1),
(25, 4, 'Educational Books', 'educational-books', 1),
(26, 4, 'Activity Books', 'activity-books', 1),
(27, 4, 'Coloring Books', 'coloring-books', 1),
(28, 4, 'Learning CDs & DVDs', 'learning-cds-dvds', 1),
(29, 4, 'Board Books', 'board-books', 1),
(40, 6, 'Disposable Diapers', 'disposable-diapers', 1),
(41, 6, 'Cloth Diapers', 'cloth-diapers', 1),
(42, 6, 'Baby Wipes', 'baby-wipes', 1),
(43, 6, 'Diaper Rash Creams', 'diaper-rash-creams', 1),
(44, 6, 'Changing Mats', 'changing-mats', 1),
(45, 6, 'Diaper Bags', 'diaper-bags', 1),
(46, 7, 'Caps & Hats', 'caps-hats', 1),
(47, 7, 'Socks & Tights', 'socks-tights', 1),
(48, 7, 'Belts', 'belts', 1),
(49, 7, 'Hair Accessories', 'hair-accessories', 1),
(50, 7, 'Bags & Backpacks', 'bags-backpacks', 1),
(51, 7, 'Kids Umbrella', 'kids-umbrella', 1),
(52, 7, 'Watches', 'kids-watches', 1),
(53, 7, 'Sunglasses & Eyewear', 'sunglasses-eyewear', 1),
(61, 9, 'Thermometers', 'thermometers', 1),
(62, 9, 'First Aid Kits', 'first-aid-kits', 1),
(63, 9, 'Nasal Aspirators', 'nasal-aspirators', 1),
(64, 9, 'Baby Safety Locks', 'baby-safety-locks', 1),
(65, 9, 'Corner Guards', 'corner-guards', 1),
(66, 9, 'Humidifiers', 'humidifiers', 1),
(67, 10, 'Maternity Wear', 'maternity-wear', 1),
(68, 10, 'Nursing Bras', 'nursing-bras', 1),
(69, 10, 'Pregnancy Pillows', 'pregnancy-pillows', 1),
(70, 10, 'Maternity Skincare', 'maternity-skincare', 1),
(71, 10, 'Postpartum Care', 'postpartum-care', 1),
(120, 16, 'Chair', 'chair-69a8279c81932', 1),
(121, 16, 'Table', 'table-69a8279c8232f', 1),
(122, 16, 'Sofa', 'sofa-69a8279c8287a', 1),
(183, 11, 'Educational Toys', 'educational-toys-69aec45ff3be9', 1),
(184, 11, 'Building Blocks', 'building-blocks-69aec46000192', 1),
(185, 11, 'Action Figures', 'action-figures-69aec4600179e', 1),
(186, 11, 'Soft Toys', 'soft-toys-69aec46001e8f', 1),
(187, 11, 'Board Games', 'board-games-69aec46002527', 1),
(188, 11, 'Puzzles', 'puzzles-69aec46002b39', 1),
(189, 11, 'Remote Control Toys', 'remote-control-toys-69aec4600320b', 1),
(190, 11, 'Outdoor Play Equipment', 'outdoor-play-equipment-69aec46003768', 1),
(412, 2, 'Baby Soaps', 'baby-soaps-69de2ba7113ec', 1),
(413, 2, 'Baby Shampoos', 'baby-shampoos-69de2ba711667', 1),
(414, 2, 'Baby Lotions & Creams', 'baby-lotions-creams-69de2ba711832', 1),
(415, 2, 'Baby Oils', 'baby-oils-69de2ba711b5e', 1),
(416, 2, 'Baby Powders', 'baby-powders-69de2ba711d06', 1),
(417, 2, 'Bath Tubs & Accessories', 'bath-tubs-accessories-69de2ba711e7f', 1),
(418, 2, 'Towels & Bath Robes', 'towels-bath-robes-69de2ba711ffc', 1),
(419, 2, 'Baby Grooming Kits', 'baby-grooming-kits-69de2ba71216f', 1),
(420, 2, 'Testing Break', 'testing-break-69de2ba7122f6', 1),
(476, 5, 'T-Shirts & Shirts', 't-shirts-shirts-6a01b0e489c13', 1),
(477, 5, 'Dresses & Frocks', 'dresses-frocks-6a01b0e489f63', 1),
(478, 5, 'Top & Bottom Sets', 'top-bottom-sets-6a01b0e48a138', 1),
(479, 5, 'Ethnic Wear', 'ethnic-wear-6a01b0e48a2cc', 1),
(480, 5, 'Nightwear & Sleepsuits', 'nightwear-sleepsuits-6a01b0e48a449', 1),
(481, 5, 'Winter Wear', 'winter-wear-6a01b0e48a5a2', 1),
(482, 5, 'Innerwear & Thermals', 'innerwear-thermals-6a01b0e48a6f2', 1),
(483, 5, 'Shoes & Sneakers', 'shoes-sneakers-6a01b0e48a856', 1),
(484, 5, 'Sandals & Slippers', 'sandals-slippers-6a01b0e48a9a8', 1),
(485, 5, 'Boots', 'boots-6a01b0e48aaf3', 1),
(486, 5, 'Footware', 'footware-6a01b0e48ac58', 1),
(487, 5, 'Sets & Suits', 'sets-suits-6a01b0e48addb', 1),
(488, 5, 'Led Shoes', 'led-shoes-6a01b0e48af33', 1),
(489, 5, 'Shorts, Skirts & Jeans', 'shorts-skirts-jeans-6a01b0e48b0b0', 1),
(490, 8, 'Feeding Bottles', 'feeding-bottles-6a0201db8de0a', 1),
(491, 8, 'Sippy Cups', 'sippy-cups-6a0201db8e126', 1),
(492, 8, 'Bibs', 'bibs-6a0201db8e337', 1),
(493, 8, 'Bottle Sterilizers', 'bottle-sterilizers-6a0201db8e512', 1),
(494, 8, 'Breast Pumps', 'breast-pumps-6a0201db8e6da', 1),
(495, 8, 'Nursing Pads', 'nursing-pads-6a0201db8e87f', 1),
(496, 8, 'High Chairs', 'high-chairs-6a0201db8ea55', 1),
(497, 8, 'Breast Feeding', 'breast-feeding-6a0201db8ebff', 1),
(498, 8, 'Kids Food & Nutritional Supplements', 'kids-food-nutritional-supplements-6a0201db8ee07', 1),
(499, 8, 'Baby Food & Infant Formula', 'baby-food-infant-formula-6a0201db8efc0', 1),
(509, 17, 'TV', 'tv-6a2ff26bd3acf', 1),
(510, 17, 'Mobile', 'mobile-6a2ff26bd3f0d', 1),
(511, 17, 'Tab', 'tab-6a2ff26bd42a4', 1),
(512, 17, 'AC', 'ac-6a2ff26bd45fb', 1);

-- --------------------------------------------------------

--
-- Table structure for table `product_variants`
--

CREATE TABLE `product_variants` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `sku` varchar(100) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `compare_price` decimal(10,2) DEFAULT NULL,
  `stock` int(11) NOT NULL DEFAULT 0,
  `weight` decimal(8,2) DEFAULT NULL,
  `status` tinyint(1) DEFAULT 1,
  `is_featured` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_variants`
--

INSERT INTO `product_variants` (`id`, `product_id`, `sku`, `price`, `compare_price`, `stock`, `weight`, `status`, `is_featured`, `created_at`, `updated_at`) VALUES
(706, 282, 'BABYROMPER01-BLUE-03M-KIYS', 1669.68, NULL, 16, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(707, 282, 'BABYROMPER01-BLUE-46M-O8LL', 831.57, NULL, 67, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(708, 282, 'BABYROMPER01-BLUE-712M-WJD2', 1892.88, NULL, 183, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(709, 282, 'BABYROMPER01-PINK-03M-2NIG', 2251.01, NULL, 32, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(710, 282, 'BABYROMPER01-PINK-46M-IVIZ', 1169.42, NULL, 17, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(711, 282, 'BABYROMPER01-PINK-712M-KU1N', 701.87, NULL, 139, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(712, 282, 'BABYROMPER01-WHITE-03M-ZVSK', 260.03, NULL, 60, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(713, 282, 'BABYROMPER01-WHITE-46M-OETI', 1693.73, NULL, 149, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(714, 282, 'BABYROMPER01-WHITE-712M-Y28I', 706.01, NULL, 160, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(715, 283, 'KIDST-SHIR02-RED-35Y-FTBY', 2060.69, NULL, 11, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(716, 283, 'KIDST-SHIR02-RED-612Y-MZX2', 1804.72, NULL, 97, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(717, 283, 'KIDST-SHIR02-RED-S-SKIN', 556.60, NULL, 96, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(718, 283, 'KIDST-SHIR02-RED-M-ZTUY', 412.32, NULL, 32, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-30 09:38:07'),
(719, 283, 'KIDST-SHIR02-BLUE-35Y-JGTS', 2148.24, NULL, 163, NULL, 1, 0, '2026-06-15 06:53:52', '2026-07-01 10:47:03'),
(720, 283, 'KIDST-SHIR02-BLUE-612Y-WLVI', 2055.40, NULL, 196, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(721, 283, 'KIDST-SHIR02-BLUE-S-PNNJ', 1432.32, NULL, 106, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(722, 283, 'KIDST-SHIR02-BLUE-M-YPKY', 1468.69, NULL, 170, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(723, 283, 'KIDST-SHIR02-BLACK-35Y-ZAE0', 2235.54, NULL, 102, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(724, 283, 'KIDST-SHIR02-BLACK-612Y-CYZ1', 641.26, NULL, 27, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(725, 283, 'KIDST-SHIR02-BLACK-S-EIY2', 1719.91, NULL, 84, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(726, 283, 'KIDST-SHIR02-BLACK-M-XHDH', 2166.23, NULL, 34, NULL, 1, 0, '2026-06-15 06:53:52', '2026-07-01 09:36:52'),
(727, 284, 'GIRLSFROCK03-PINK-12Y-ZZZT', 838.34, NULL, 172, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(728, 284, 'GIRLSFROCK03-PINK-35Y-OD7G', 573.10, NULL, 100, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(729, 284, 'GIRLSFROCK03-PINK-612Y-3VIS', 1740.40, NULL, 189, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(730, 284, 'GIRLSFROCK03-WHITE-12Y-6KCU', 1689.48, NULL, 165, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(731, 284, 'GIRLSFROCK03-WHITE-35Y-UT7I', 592.62, NULL, 196, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(732, 284, 'GIRLSFROCK03-WHITE-612Y-6QID', 574.83, NULL, 107, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(733, 284, 'GIRLSFROCK03-YELLOW-12Y-PDXS', 2474.90, NULL, 173, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(734, 284, 'GIRLSFROCK03-YELLOW-35Y-PFW8', 1479.98, NULL, 185, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(735, 284, 'GIRLSFROCK03-YELLOW-612Y-AJIF', 2137.56, NULL, 24, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(736, 285, 'BABYNIGHTS04-WHITE-03M-BRXQ', 2089.15, NULL, 90, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(737, 285, 'BABYNIGHTS04-WHITE-46M-ZBYN', 814.80, NULL, 64, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(738, 285, 'BABYNIGHTS04-WHITE-712M-SRMM', 2214.65, NULL, 90, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(739, 285, 'BABYNIGHTS04-WHITE-12Y-JTTU', 1706.51, NULL, 111, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(740, 285, 'BABYNIGHTS04-BLUE-03M-1JED', 1254.36, NULL, 77, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(741, 285, 'BABYNIGHTS04-BLUE-46M-XUBN', 766.24, NULL, 153, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(742, 285, 'BABYNIGHTS04-BLUE-712M-MDTF', 803.31, NULL, 159, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(743, 285, 'BABYNIGHTS04-BLUE-12Y-PRXX', 2263.99, NULL, 112, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(744, 286, 'KIDSSNEAKE05-BLUE-35Y-0XZ3', 703.44, NULL, 45, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(745, 286, 'KIDSSNEAKE05-BLUE-612Y-MCRL', 1334.09, NULL, 22, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(746, 286, 'KIDSSNEAKE05-BLUE-XS-20L0', 550.54, NULL, 50, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(747, 286, 'KIDSSNEAKE05-BLUE-S-OFKX', 1169.97, NULL, 26, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(748, 286, 'KIDSSNEAKE05-BLACK-35Y-S1JT', 1076.72, NULL, 129, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(749, 286, 'KIDSSNEAKE05-BLACK-612Y-BRYJ', 777.25, NULL, 151, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(750, 286, 'KIDSSNEAKE05-BLACK-XS-EANA', 1763.65, NULL, 39, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(751, 286, 'KIDSSNEAKE05-BLACK-S-HQLG', 2234.01, NULL, 78, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(752, 286, 'KIDSSNEAKE05-WHITE-35Y-TPND', 981.40, NULL, 85, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(753, 286, 'KIDSSNEAKE05-WHITE-612Y-IRTI', 562.76, NULL, 10, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(754, 286, 'KIDSSNEAKE05-WHITE-XS-5GQX', 2213.46, NULL, 77, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(755, 286, 'KIDSSNEAKE05-WHITE-S-QJWE', 1951.51, NULL, 139, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(756, 287, 'GIRLSLEDSH06-PINK-35Y-F1MH', 2201.19, NULL, 86, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(757, 287, 'GIRLSLEDSH06-PINK-612Y-7O0F', 1366.62, NULL, 60, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(758, 287, 'GIRLSLEDSH06-PINK-XS-ZV2I', 1059.00, NULL, 51, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(759, 287, 'GIRLSLEDSH06-WHITE-35Y-ZXPS', 2392.05, NULL, 145, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(760, 287, 'GIRLSLEDSH06-WHITE-612Y-5AQ2', 1576.57, NULL, 135, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(761, 287, 'GIRLSLEDSH06-WHITE-XS-WE8U', 456.30, NULL, 102, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(762, 288, 'TODDLERSAN07-RED-03M-YGRH', 749.74, NULL, 71, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(763, 288, 'TODDLERSAN07-RED-46M-UGJM', 2376.98, NULL, 31, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(764, 288, 'TODDLERSAN07-RED-12Y-PPYZ', 1316.78, NULL, 27, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(765, 288, 'TODDLERSAN07-YELLOW-03M-RZ6P', 1960.42, NULL, 42, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(766, 288, 'TODDLERSAN07-YELLOW-46M-84DD', 1292.15, NULL, 150, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(767, 288, 'TODDLERSAN07-YELLOW-12Y-ZRHL', 808.63, NULL, 165, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(768, 289, 'KIDSFORMAL08-WHITE-35Y-AJQY', 2417.03, NULL, 148, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(769, 289, 'KIDSFORMAL08-WHITE-612Y-NOEX', 1785.70, NULL, 192, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(770, 289, 'KIDSFORMAL08-WHITE-S-WPYL', 1116.68, NULL, 181, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(771, 289, 'KIDSFORMAL08-WHITE-M-OWHM', 1057.87, NULL, 142, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(772, 289, 'KIDSFORMAL08-BLUE-35Y-FUFG', 477.31, NULL, 67, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(773, 289, 'KIDSFORMAL08-BLUE-612Y-H5QW', 976.60, NULL, 160, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(774, 289, 'KIDSFORMAL08-BLUE-S-XAYE', 728.26, NULL, 66, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(775, 289, 'KIDSFORMAL08-BLUE-M-STNK', 362.28, NULL, 171, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(776, 290, 'GIRLSTOPSE09-PINK-12Y-5AZI', 725.57, NULL, 18, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(777, 290, 'GIRLSTOPSE09-PINK-35Y-QXTA', 361.97, NULL, 70, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(778, 290, 'GIRLSTOPSE09-PINK-612Y-VNUC', 1737.65, NULL, 64, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(779, 290, 'GIRLSTOPSE09-PINK-XS-OZLU', 503.32, NULL, 156, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(780, 290, 'GIRLSTOPSE09-GREEN-12Y-64GJ', 1286.14, NULL, 131, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(781, 290, 'GIRLSTOPSE09-GREEN-35Y-YK4G', 636.94, NULL, 34, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(782, 290, 'GIRLSTOPSE09-GREEN-612Y-JESY', 1190.42, NULL, 118, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(783, 290, 'GIRLSTOPSE09-GREEN-XS-GK5K', 1273.16, NULL, 196, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(784, 290, 'GIRLSTOPSE09-YELLOW-12Y-OSTU', 1747.74, NULL, 175, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(785, 290, 'GIRLSTOPSE09-YELLOW-35Y-30DO', 338.41, NULL, 196, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(786, 290, 'GIRLSTOPSE09-YELLOW-612Y-BD1W', 2040.36, NULL, 37, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(787, 290, 'GIRLSTOPSE09-YELLOW-XS-K3GK', 639.66, NULL, 147, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(788, 291, 'BOYSSUITSE10-BLACK-35Y-35DB', 521.42, NULL, 56, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(789, 291, 'BOYSSUITSE10-BLACK-612Y-HGW0', 1263.04, NULL, 29, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(790, 291, 'BOYSSUITSE10-BLACK-S-ALRL', 2057.45, NULL, 150, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(791, 291, 'BOYSSUITSE10-BLACK-M-ZWOE', 315.35, NULL, 148, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(792, 291, 'BOYSSUITSE10-BLUE-35Y-MMLV', 2427.69, NULL, 70, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(793, 291, 'BOYSSUITSE10-BLUE-612Y-SXK4', 1133.75, NULL, 133, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(794, 291, 'BOYSSUITSE10-BLUE-S-YNXR', 2187.70, NULL, 25, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(795, 291, 'BOYSSUITSE10-BLUE-M-QLKN', 1070.64, NULL, 109, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(796, 292, 'BABYSLEEPS11-WHITE-03M-6ZRJ', 2329.99, NULL, 126, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(797, 292, 'BABYSLEEPS11-WHITE-46M-WTVZ', 1171.92, NULL, 197, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(798, 292, 'BABYSLEEPS11-WHITE-712M-S23W', 1721.30, NULL, 134, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(799, 292, 'BABYSLEEPS11-PINK-03M-QSVH', 635.77, NULL, 65, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(800, 292, 'BABYSLEEPS11-PINK-46M-3B5U', 1531.11, NULL, 148, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(801, 292, 'BABYSLEEPS11-PINK-712M-VEED', 1919.34, NULL, 24, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(802, 292, 'BABYSLEEPS11-BLUE-03M-GNL6', 1542.61, NULL, 138, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(803, 292, 'BABYSLEEPS11-BLUE-46M-UGZB', 561.10, NULL, 140, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(804, 292, 'BABYSLEEPS11-BLUE-712M-0BZ5', 2157.09, NULL, 27, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(805, 293, 'GIRLSETHNI12-RED-12Y-JZF3', 355.31, NULL, 70, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(806, 293, 'GIRLSETHNI12-RED-35Y-B5WA', 474.74, NULL, 155, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(807, 293, 'GIRLSETHNI12-RED-612Y-FSAX', 1530.51, NULL, 20, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(808, 293, 'GIRLSETHNI12-ORANGE-12Y-TFKZ', 387.56, NULL, 178, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(809, 293, 'GIRLSETHNI12-ORANGE-35Y-AEAX', 1499.02, NULL, 90, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(810, 293, 'GIRLSETHNI12-ORANGE-612Y-B0FA', 668.80, NULL, 193, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(811, 293, 'GIRLSETHNI12-PINK-12Y-OK7N', 747.98, NULL, 111, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(812, 293, 'GIRLSETHNI12-PINK-35Y-KSRY', 1743.89, NULL, 86, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(813, 293, 'GIRLSETHNI12-PINK-612Y-VORR', 926.21, NULL, 28, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(814, 294, 'KIDSCASUAL13-GREEN-35Y-ORLG', 1253.06, NULL, 154, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(815, 294, 'KIDSCASUAL13-GREEN-612Y-BUYH', 367.50, NULL, 64, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(816, 294, 'KIDSCASUAL13-GREEN-XS-5NJQ', 808.96, NULL, 99, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(817, 294, 'KIDSCASUAL13-GREEN-S-03VA', 2221.32, NULL, 104, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(818, 294, 'KIDSCASUAL13-ORANGE-35Y-DXIX', 561.82, NULL, 149, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(819, 294, 'KIDSCASUAL13-ORANGE-612Y-AXMX', 894.79, NULL, 177, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(820, 294, 'KIDSCASUAL13-ORANGE-XS-CMVB', 216.99, NULL, 151, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(821, 294, 'KIDSCASUAL13-ORANGE-S-XB6V', 2342.04, NULL, 36, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(822, 294, 'KIDSCASUAL13-YELLOW-35Y-SWMB', 807.27, NULL, 37, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(823, 294, 'KIDSCASUAL13-YELLOW-612Y-5JZE', 1471.41, NULL, 79, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(824, 294, 'KIDSCASUAL13-YELLOW-XS-NCMA', 1590.11, NULL, 193, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(825, 294, 'KIDSCASUAL13-YELLOW-S-PNZS', 667.27, NULL, 172, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(826, 295, 'BOYSSPORTS14-BLACK-35Y-THIF', 1361.44, NULL, 74, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(827, 295, 'BOYSSPORTS14-BLACK-612Y-TYMS', 411.29, NULL, 118, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(828, 295, 'BOYSSPORTS14-BLACK-S-IYQY', 300.40, NULL, 95, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(829, 295, 'BOYSSPORTS14-BLACK-M-RUFQ', 1664.36, NULL, 77, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(830, 295, 'BOYSSPORTS14-BLUE-35Y-YFOD', 1903.83, NULL, 151, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(831, 295, 'BOYSSPORTS14-BLUE-612Y-51MB', 1182.68, NULL, 12, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(832, 295, 'BOYSSPORTS14-BLUE-S-LB0P', 372.06, NULL, 186, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(833, 295, 'BOYSSPORTS14-BLUE-M-RJMZ', 1453.86, NULL, 104, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(834, 295, 'BOYSSPORTS14-RED-35Y-O32O', 1469.81, NULL, 120, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(835, 295, 'BOYSSPORTS14-RED-612Y-M5KA', 295.21, NULL, 103, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(836, 295, 'BOYSSPORTS14-RED-S-RGPH', 2266.53, NULL, 63, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(837, 295, 'BOYSSPORTS14-RED-M-AXGW', 772.92, NULL, 36, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(838, 296, 'BABYFOOTIE15-WHITE-03M-M7AW', 1993.27, NULL, 114, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(839, 296, 'BABYFOOTIE15-WHITE-46M-XHKL', 1922.80, NULL, 70, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(840, 296, 'BABYFOOTIE15-WHITE-712M-DRLZ', 2444.27, NULL, 55, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(841, 296, 'BABYFOOTIE15-PINK-03M-8UWA', 256.01, NULL, 198, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(842, 296, 'BABYFOOTIE15-PINK-46M-VGYD', 1998.49, NULL, 115, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(843, 296, 'BABYFOOTIE15-PINK-712M-CNNR', 2186.35, NULL, 73, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(844, 297, 'GIRLSBALLE16-PINK-35Y-83QO', 565.16, NULL, 189, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(845, 297, 'GIRLSBALLE16-PINK-612Y-VG86', 1078.85, NULL, 19, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(846, 297, 'GIRLSBALLE16-PINK-XS-K8PU', 710.60, NULL, 127, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(847, 297, 'GIRLSBALLE16-PINK-S-TGWU', 900.94, NULL, 68, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(848, 297, 'GIRLSBALLE16-WHITE-35Y-OSTE', 253.43, NULL, 59, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(849, 297, 'GIRLSBALLE16-WHITE-612Y-K6FQ', 954.00, NULL, 27, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(850, 297, 'GIRLSBALLE16-WHITE-XS-L1LX', 1006.64, NULL, 140, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(851, 297, 'GIRLSBALLE16-WHITE-S-UTPT', 1761.89, NULL, 147, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(852, 297, 'GIRLSBALLE16-BLACK-35Y-EPJJ', 2359.25, NULL, 39, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(853, 297, 'GIRLSBALLE16-BLACK-612Y-A3BB', 609.71, NULL, 77, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(854, 297, 'GIRLSBALLE16-BLACK-XS-DMYN', 448.33, NULL, 121, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(855, 297, 'GIRLSBALLE16-BLACK-S-RGAU', 1874.65, NULL, 90, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(856, 298, 'BOYSNIGHTP17-BLUE-35Y-1JBQ', 1593.28, NULL, 140, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(857, 298, 'BOYSNIGHTP17-BLUE-612Y-SNB4', 1084.95, NULL, 157, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(858, 298, 'BOYSNIGHTP17-BLUE-XS-FKVC', 784.86, NULL, 191, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(859, 298, 'BOYSNIGHTP17-BLUE-S-NJPT', 202.89, NULL, 147, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(860, 298, 'BOYSNIGHTP17-GREEN-35Y-20CR', 1853.69, NULL, 199, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(861, 298, 'BOYSNIGHTP17-GREEN-612Y-OPD2', 1741.45, NULL, 103, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(862, 298, 'BOYSNIGHTP17-GREEN-XS-VX9E', 359.94, NULL, 180, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(863, 298, 'BOYSNIGHTP17-GREEN-S-FLES', 1632.26, NULL, 179, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(864, 299, 'ETHNICKURT18-ORANGE-35Y-FXG2', 1854.43, NULL, 86, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(865, 299, 'ETHNICKURT18-ORANGE-612Y-9Z8M', 910.35, NULL, 114, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(866, 299, 'ETHNICKURT18-ORANGE-S-S0JK', 1124.52, NULL, 85, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(867, 299, 'ETHNICKURT18-ORANGE-M-NSWF', 491.76, NULL, 117, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(868, 299, 'ETHNICKURT18-WHITE-35Y-QEYZ', 2361.84, NULL, 183, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(869, 299, 'ETHNICKURT18-WHITE-612Y-TMYK', 2275.45, NULL, 167, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(870, 299, 'ETHNICKURT18-WHITE-S-3YFE', 891.18, NULL, 150, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(871, 299, 'ETHNICKURT18-WHITE-M-B8PB', 897.91, NULL, 63, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(872, 299, 'ETHNICKURT18-RED-35Y-OWUZ', 2006.25, NULL, 165, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(873, 299, 'ETHNICKURT18-RED-612Y-56NG', 940.17, NULL, 123, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(874, 299, 'ETHNICKURT18-RED-S-2YHO', 1752.94, NULL, 140, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(875, 299, 'ETHNICKURT18-RED-M-AXNJ', 2024.59, NULL, 198, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(876, 300, 'GIRLSCASUA19-BLUE-12Y-DVHQ', 1714.36, NULL, 82, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(877, 300, 'GIRLSCASUA19-BLUE-35Y-LGVM', 1725.86, NULL, 168, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(878, 300, 'GIRLSCASUA19-BLUE-612Y-YAOW', 413.79, NULL, 70, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(879, 300, 'GIRLSCASUA19-GREEN-12Y-BDWH', 912.96, NULL, 60, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(880, 300, 'GIRLSCASUA19-GREEN-35Y-UITT', 255.18, NULL, 72, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(881, 300, 'GIRLSCASUA19-GREEN-612Y-WWBO', 1604.93, NULL, 28, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(882, 300, 'GIRLSCASUA19-WHITE-12Y-OCDM', 1152.21, NULL, 171, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(883, 300, 'GIRLSCASUA19-WHITE-35Y-FVSG', 646.20, NULL, 188, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(884, 300, 'GIRLSCASUA19-WHITE-612Y-BQNG', 1336.07, NULL, 72, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(885, 301, 'TODDLERTOP20-YELLOW-03M-SQDT', 1707.93, NULL, 11, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(886, 301, 'TODDLERTOP20-YELLOW-46M-QSY0', 1989.37, NULL, 66, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(887, 301, 'TODDLERTOP20-YELLOW-712M-W1XK', 2048.45, NULL, 188, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(888, 301, 'TODDLERTOP20-YELLOW-12Y-CUMD', 1267.46, NULL, 152, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(889, 301, 'TODDLERTOP20-PINK-03M-W4AI', 2309.18, NULL, 41, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(890, 301, 'TODDLERTOP20-PINK-46M-VKV7', 505.68, NULL, 128, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(891, 301, 'TODDLERTOP20-PINK-712M-GUS5', 1420.60, NULL, 153, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(892, 301, 'TODDLERTOP20-PINK-12Y-N8RU', 928.79, NULL, 123, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(893, 301, 'TODDLERTOP20-BLUE-03M-HAI5', 2073.51, NULL, 139, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(894, 301, 'TODDLERTOP20-BLUE-46M-PHM2', 2109.31, NULL, 150, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(895, 301, 'TODDLERTOP20-BLUE-712M-EVB9', 2262.58, NULL, 200, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(896, 301, 'TODDLERTOP20-BLUE-12Y-QUBG', 1234.16, NULL, 73, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(897, 302, 'KIDSFORMAL21-BLACK-35Y-NBEY', 836.82, NULL, 143, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(898, 302, 'KIDSFORMAL21-BLACK-612Y-QJWK', 1640.52, NULL, 80, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(899, 302, 'KIDSFORMAL21-BLACK-S-OJRT', 377.21, NULL, 83, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(900, 302, 'KIDSFORMAL21-BLACK-M-FHCQ', 823.94, NULL, 91, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(901, 302, 'KIDSFORMAL21-WHITE-35Y-XTGF', 384.33, NULL, 48, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(902, 302, 'KIDSFORMAL21-WHITE-612Y-RD8O', 1079.98, NULL, 49, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(903, 302, 'KIDSFORMAL21-WHITE-S-SQ1T', 691.09, NULL, 116, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(904, 302, 'KIDSFORMAL21-WHITE-M-NR5F', 960.03, NULL, 129, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(905, 303, 'GIRLSPARTY22-RED-12Y-XFDR', 342.21, NULL, 117, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(906, 303, 'GIRLSPARTY22-RED-35Y-840O', 2280.13, NULL, 159, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(907, 303, 'GIRLSPARTY22-RED-612Y-87SC', 243.92, NULL, 157, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(908, 303, 'GIRLSPARTY22-RED-XS-DGCT', 1296.05, NULL, 100, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(909, 303, 'GIRLSPARTY22-PINK-12Y-LNMH', 1931.99, NULL, 117, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(910, 303, 'GIRLSPARTY22-PINK-35Y-EHO5', 1918.29, NULL, 149, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(911, 303, 'GIRLSPARTY22-PINK-612Y-HRRM', 2263.97, NULL, 134, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(912, 303, 'GIRLSPARTY22-PINK-XS-HZWT', 826.75, NULL, 134, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(913, 303, 'GIRLSPARTY22-WHITE-12Y-NPGC', 1093.37, NULL, 181, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(914, 303, 'GIRLSPARTY22-WHITE-35Y-14YH', 2034.73, NULL, 195, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(915, 303, 'GIRLSPARTY22-WHITE-612Y-3VTH', 2132.16, NULL, 42, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(916, 303, 'GIRLSPARTY22-WHITE-XS-QE5Q', 1427.48, NULL, 110, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(917, 303, 'GIRLSPARTY22-YELLOW-12Y-XKDV', 1497.10, NULL, 16, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(918, 303, 'GIRLSPARTY22-YELLOW-35Y-UF0J', 1677.32, NULL, 44, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(919, 303, 'GIRLSPARTY22-YELLOW-612Y-XFHE', 616.98, NULL, 76, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(920, 303, 'GIRLSPARTY22-YELLOW-XS-Y1HQ', 951.91, NULL, 126, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(921, 304, 'BOYSCASUAL23-BLUE-35Y-LKF0', 975.25, NULL, 107, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(922, 304, 'BOYSCASUAL23-BLUE-612Y-MNV2', 1928.62, NULL, 117, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(923, 304, 'BOYSCASUAL23-BLUE-S-FRN4', 2119.30, NULL, 130, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(924, 304, 'BOYSCASUAL23-BLUE-M-GN75', 1921.76, NULL, 23, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(925, 304, 'BOYSCASUAL23-BLACK-35Y-DZ2G', 714.71, NULL, 27, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(926, 304, 'BOYSCASUAL23-BLACK-612Y-SGCF', 291.59, NULL, 17, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(927, 304, 'BOYSCASUAL23-BLACK-S-WOCS', 657.53, NULL, 15, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(928, 304, 'BOYSCASUAL23-BLACK-M-S35O', 549.48, NULL, 42, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(929, 305, 'BABYBOOTIE24-PINK-03M-VQPP', 1738.76, NULL, 154, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(930, 305, 'BABYBOOTIE24-PINK-46M-KSSD', 1268.58, NULL, 75, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(931, 305, 'BABYBOOTIE24-PINK-712M-PH8M', 584.92, NULL, 165, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(932, 305, 'BABYBOOTIE24-BLUE-03M-400V', 1851.22, NULL, 51, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(933, 305, 'BABYBOOTIE24-BLUE-46M-ZACB', 447.63, NULL, 16, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(934, 305, 'BABYBOOTIE24-BLUE-712M-HXUI', 1523.33, NULL, 106, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(935, 305, 'BABYBOOTIE24-WHITE-03M-JZES', 2364.38, NULL, 60, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(936, 305, 'BABYBOOTIE24-WHITE-46M-FTX4', 1560.83, NULL, 170, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(937, 305, 'BABYBOOTIE24-WHITE-712M-LTUP', 433.37, NULL, 87, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(938, 306, 'KIDSRAINCO25-YELLOW-12Y-SMQV', 1579.95, NULL, 39, NULL, 1, 0, '2026-06-15 06:53:52', '2026-07-01 10:47:03'),
(939, 306, 'KIDSRAINCO25-YELLOW-35Y-CVJT', 1999.06, NULL, 98, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(940, 306, 'KIDSRAINCO25-YELLOW-612Y-3PAB', 1184.27, NULL, 104, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(941, 306, 'KIDSRAINCO25-YELLOW-XS-BCGN', 1362.71, NULL, 97, NULL, 1, 0, '2026-06-15 06:53:52', '2026-06-15 06:53:52'),
(942, 306, 'KIDSRAINCO25-YELLOW-S-XOA4', 2153.02, NULL, 135, NULL, 1, 0, '2026-06-15 06:53:53', '2026-06-15 06:53:53'),
(943, 306, 'KIDSRAINCO25-RED-12Y-NJ9I', 1196.10, NULL, 102, NULL, 1, 0, '2026-06-15 06:53:53', '2026-06-15 06:53:53'),
(944, 306, 'KIDSRAINCO25-RED-35Y-7L2S', 2249.62, NULL, 127, NULL, 1, 0, '2026-06-15 06:53:53', '2026-06-15 06:53:53'),
(945, 306, 'KIDSRAINCO25-RED-612Y-U7DP', 550.88, NULL, 55, NULL, 1, 0, '2026-06-15 06:53:53', '2026-06-15 06:53:53'),
(946, 306, 'KIDSRAINCO25-RED-XS-6LGK', 1399.02, NULL, 176, NULL, 1, 0, '2026-06-15 06:53:53', '2026-06-15 06:53:53'),
(947, 306, 'KIDSRAINCO25-RED-S-FQ7G', 1615.60, NULL, 147, NULL, 1, 0, '2026-06-15 06:53:53', '2026-06-15 06:53:53'),
(948, 306, 'KIDSRAINCO25-BLUE-12Y-4BH1', 1268.21, NULL, 197, NULL, 1, 0, '2026-06-15 06:53:53', '2026-06-15 06:53:53'),
(949, 306, 'KIDSRAINCO25-BLUE-35Y-MSEQ', 816.31, NULL, 72, NULL, 1, 0, '2026-06-15 06:53:53', '2026-06-15 06:53:53'),
(950, 306, 'KIDSRAINCO25-BLUE-612Y-CEWR', 840.53, NULL, 125, NULL, 1, 0, '2026-06-15 06:53:53', '2026-06-15 06:53:53'),
(951, 306, 'KIDSRAINCO25-BLUE-XS-BC3Z', 1925.10, NULL, 155, NULL, 1, 0, '2026-06-15 06:53:53', '2026-06-15 06:53:53'),
(952, 306, 'KIDSRAINCO25-BLUE-S-OQ12', 1735.83, NULL, 96, NULL, 1, 0, '2026-06-15 06:53:53', '2026-06-15 06:53:53');

-- --------------------------------------------------------

--
-- Table structure for table `product_views`
--

CREATE TABLE `product_views` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `views` int(11) NOT NULL DEFAULT 1,
  `viewed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `rating` decimal(2,1) UNSIGNED NOT NULL,
  `comment` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `slug` varchar(100) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `slug`, `description`, `created_at`, `updated_at`) VALUES
(5, 'Super Admin', 'super-admin', 'Full system access, can manage all modules and settings.', '2025-10-30 03:38:30', '2025-10-30 03:38:30'),
(6, 'Admin', 'admin', 'General administrative privileges except system-level settings.', '2025-10-30 03:38:30', '2025-10-30 03:38:30'),
(7, 'Support Staff', 'support', 'Handles customer support, orders, and returns.', '2025-10-30 03:38:30', '2025-10-30 03:38:30'),
(8, 'Inventory Manager', 'inventory-manager', 'Manages stock, warehouses, and inventory adjustments.', '2025-10-30 03:38:30', '2025-10-30 03:38:30'),
(10, 'Accountant', 'accountant', 'Manages transactions, settlements, and refunds.', '2025-10-30 03:38:30', '2025-10-30 03:38:30'),
(11, 'Marketing Manager', 'marketing-manager', 'Handles promotions, banners, and marketing campaigns.', '2025-10-30 03:38:30', '2025-10-30 03:38:30'),
(12, 'Viewer', 'viewer', 'Read-only access to reports and dashboards.', '2025-10-30 03:38:30', '2025-10-30 03:38:30');

-- --------------------------------------------------------

--
-- Table structure for table `role_permission`
--

CREATE TABLE `role_permission` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `permission_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `role_permission`
--

INSERT INTO `role_permission` (`id`, `role_id`, `permission_id`) VALUES
(1, 7, 13),
(2, 7, 54),
(3, 7, 55),
(4, 7, 56),
(5, 7, 58),
(6, 7, 57),
(7, 7, 14),
(8, 7, 60),
(9, 7, 59),
(10, 7, 61),
(11, 7, 62),
(12, 7, 15),
(13, 7, 65),
(14, 7, 63),
(15, 7, 64);

-- --------------------------------------------------------

--
-- Table structure for table `section_types`
--

CREATE TABLE `section_types` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `section_types`
--

INSERT INTO `section_types` (`id`, `name`, `slug`) VALUES
(1, 'SHOP BY CATEGORY', 'shop-by-category'),
(2, 'SHOP BY COLLECTION', 'shop-by-collection'),
(3, 'SHOP BY AGE', 'shop-by-age'),
(4, 'FASHION ACCESSORIES', 'fashion-accessories'),
(5, 'FOOTWEAR', 'footwear'),
(6, 'SHOP BY PRICE', 'shop-by-price'),
(7, 'SHOP BY BRANDS', 'shop-by-brands'),
(8, 'DON\'T MISS', 'dont-miss'),
(9, 'SHOP BY BRAND', 'shop-by-brand'),
(10, 'RIDE-ONS & SCOOTERS', 'ride-ons-scooters'),
(11, 'HOME PLAY ACTIVITIES', 'home-play-activities'),
(12, 'BOARD GAMES', 'board-games'),
(13, 'DISPOSABLE BABY DIAPERS', 'disposable-baby-diapers'),
(14, 'TOP BRANDS', 'top-brands'),
(15, 'BABY DIAPER BY SIZE', 'baby-diaper-by-size'),
(16, 'BABY DIAPER BY WEIGHT', 'baby-diaper-by-weight'),
(17, 'DIAPER CHANGING MATS', 'diaper-changing-mats'),
(18, 'CLOTH NAPPIES & ACCESSORIES', 'cloth-nappies-accessories'),
(19, 'DIAPER BAGS & BACKPACKS', 'diaper-bags-backpacks'),
(20, 'POTTY TRAINING', 'potty-training'),
(21, 'BABY STROLLERS & PRAMS', 'baby-strollers-prams'),
(22, 'BABY WALKERS', 'baby-walkers'),
(23, 'CAR SEATS BY TYPE', 'car-seats-by-type'),
(24, 'CAR SEATS BY CHILD WEIGHT', 'car-seats-by-child-weight'),
(25, 'BATTERY OPERATED RIDE-ONS', 'battery-operated-ride-ons'),
(26, 'TRICYCLES & BIKES', 'tricycles-bikes'),
(27, 'HIGH CHAIRS & BOOSTER SEATS', 'high-chairs-booster-seats'),
(28, 'INFANT ACTIVITY TIME', 'infant-activity-time'),
(29, 'BABY FOOD & INFANT FORMULA', 'baby-food-infant-formula'),
(30, 'BREAST FEEDING', 'breast-feeding'),
(31, 'FEEDING BOTTLES & ACC.', 'feeding-bottles-acc'),
(32, 'TEETHERS & PACIFIERS', 'teethers-pacifiers'),
(33, 'STERLIZERS & WARMERS', 'sterlizers-warmers'),
(34, 'FEEDING BOTTLE CLEANING', 'feeding-bottle-cleaning'),
(35, 'SIPPERS & CUPS', 'sippers-cups'),
(36, 'BIBS & HANKY', 'bibs-hanky'),
(37, 'DISHES & UTENSILS', 'dishes-utensils'),
(38, 'KIDS FOODS & SUPPLEMENTS', 'kids-foods-supplements'),
(39, 'BATHING ACCESSORIES', 'bathing-accessories'),
(40, 'BATH TOYS', 'bath-toys'),
(41, 'SOAP BARS & BODY WASH', 'soap-bars-body-wash'),
(42, 'GROOMING', 'grooming'),
(43, 'SHAMPOOS & CONDITIONERS', 'shampoos-conditioners'),
(44, 'BATH TOWELS & ROBES', 'bath-towels-robes'),
(45, 'LOTIONS, OILS & POWDERS', 'lotions-oils-powders'),
(46, 'BABY CREAMS & OINTMENTS', 'baby-creams-ointments'),
(47, 'BATHING ESSENTIALS', 'bathing-essentials'),
(48, 'BLANKETS, QUILTS & WRAPPERS', 'blankets-quilts-wrappers'),
(49, 'BABY FURNITURE', 'baby-furniture'),
(50, 'BABY BEDDING SETS & PILLOWS', 'baby-bedding-sets-pillows'),
(51, 'STORAGE & ORGANIZATION', 'storage-organization'),
(52, 'KIDS BEDDING ESSENTIALS', 'kids-bedding-essentials'),
(53, 'MOSQUITO NETS', 'mosquito-nets'),
(54, 'TRAVEL ACCESSORIES', 'travel-accessories'),
(55, 'WALL PAPERS & STICKERS', 'wall-papers-stickers'),
(56, 'KIDS ROOM & STUDY ESS.', 'kids-room-study-ess'),
(57, 'CRIB BEDDING ESSENTIALS', 'crib-bedding-essentials'),
(58, 'MATTRESSES & MATTRESS PROTECTORS', 'mattresses-mattress-protectors'),
(59, 'KIDS ROOMS DECOR', 'kids-rooms-decor'),
(60, 'MATERNITY SUPPORT ACCESSORIES', 'maternity-support-accessories'),
(61, 'WOMEN\'S BEAUTY & CARE NEW', 'womens-beauty-care-new'),
(62, 'SHOP BY BRANDS NEW', 'shop-by-brands-new'),
(63, 'MATERNITY PERSONAL CARE', 'maternity-personal-care'),
(64, 'NEW MOM\'S ESSENTIALS', 'new-moms-essentials'),
(65, 'NEW BABY ESSENTIALS', 'new-baby-essentials'),
(66, 'HEALTH & SAFETY ESSENTIALS', 'health-safety-essentials'),
(67, 'MEDICAL CARE', 'medical-care'),
(68, 'MOSQUITO REPELLENTS & CARE', 'mosquito-repellents-care'),
(69, 'CLEANSERS & DETERGENTS', 'cleansers-detergents'),
(70, 'TOOTHBRUSH', 'toothbrush'),
(71, 'CHILDPROOFING ESS.', 'childproofing-ess'),
(72, 'ORAL CARE', 'oral-care'),
(73, 'BOUTIQUES', 'boutiques'),
(74, 'INT\'L BRANDS IN BABY GEAR', 'intl-brands-in-baby-gear'),
(75, 'TOP INTERNATIONAL BRANDS', 'top-international-brands'),
(76, 'TOP MOMPRENEURS BRANDS', 'top-mompreneurs-brands'),
(77, 'TOP INDIAN BRANDS', 'top-indian-brands'),
(78, 'FINE JEWELLERY BRANDS NEW', 'fine-jewellery-brands-new'),
(79, 'DESIGNER WEAR BRANDS NEW', 'designer-wear-brands-new'),
(80, 'SKIN & FACIAL CARE', 'skin-facial-care'),
(81, 'BODY CARE', 'body-care'),
(82, 'MATERNITY STORE', 'maternity-store'),
(83, 'HAIR CARE & STYLING', 'hair-care-styling'),
(84, 'FEMININE HYGIENE & CARE', 'feminine-hygiene-care'),
(85, 'HEALTH & WELL-BEING', 'health-well-being'),
(86, 'NEW MOMS MUST HAVES', 'new-moms-must-haves'),
(87, 'BIRTHDAY ESSENTIALS', 'birthday-essentials'),
(88, 'PARTY DECOR', 'party-decor'),
(89, 'RETURN GIFTS', 'return-gifts'),
(90, 'PARTY BALLOONS & PROPS', 'party-balloons-props'),
(91, 'PLATES, CUPS & TABLE DECOR', 'plates-cups-table-decor'),
(92, 'GIFT SETS', 'gift-sets'),
(93, 'GIFT STORE', 'gift-store'),
(94, 'CRAFTS, HOBBIES & ACTIVITY BOOKS', 'crafts-hobbies-activity-books'),
(95, 'PREGNANCY & PARENTING BOOKS', 'pregnancy-parenting-books'),
(96, 'READ & LEARN', 'read-learn'),
(97, 'STORY BOOKS', 'story-books'),
(98, 'DRAWING & COLORING BOOK', 'drawing-coloring-book'),
(99, 'LUNCH BOXES', 'lunch-boxes'),
(100, 'SHOP BY CHARACTER', 'shop-by-character'),
(101, 'STATIONERY', 'stationery'),
(102, 'WATER BOTTLES', 'water-bottles'),
(103, 'SHOP BY TOP BRANDS', 'shop-by-top-brands'),
(104, 'SCHOOL BAGS & BACK PACKS', 'school-bags-back-packs'),
(105, 'HOME STORAGE AND ORGANIZATION', 'home-storage-and-organization'),
(106, 'ELECTRONICS & GADGETS', 'electronics-gadgets'),
(107, 'HOME FURNISHING', 'home-furnishing'),
(108, 'KITCHEN & DINING ESSENTIALS', 'kitchen-dining-essentials'),
(109, 'HOME DECOR', 'home-decor'),
(110, 'KITCHEN AND HOME APPLIANCES', 'kitchen-and-home-appliances'),
(111, 'HANDBAGS PURSES & WALLETS', 'handbags-purses-wallets'),
(112, 'SHOP BY GENDER', 'shop-by-gender');

-- --------------------------------------------------------

--
-- Table structure for table `sellers`
--

CREATE TABLE `sellers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `contact_person` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `mobile` varchar(20) NOT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `last_login_at` timestamp NULL DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  `is_onboard` tinyint(1) NOT NULL DEFAULT 1,
  `compliance_status` enum('pending','verified','rejected') DEFAULT 'pending',
  `commission_rate` decimal(5,2) DEFAULT 10.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sellers`
--

INSERT INTO `sellers` (`id`, `slug`, `name`, `contact_person`, `email`, `mobile`, `logo`, `last_login_at`, `is_active`, `created_at`, `updated_at`, `deleted_at`, `is_onboard`, `compliance_status`, `commission_rate`) VALUES
(15, 'baby-store-db', 'Baby store DB', 'Debleena Chakraborty', 'debleenachakraborty6@gmail.com', '7980948240', NULL, NULL, 1, '2026-05-08 09:12:05', '2026-05-19 05:58:35', NULL, 1, 'pending', 10.00),
(24, 'rd-private-ltd', 'RD Private Ltd', 'Amar Maity', 'amar.maity@delostylestudio.com', '9903823389', NULL, NULL, 1, '2026-04-15 06:30:14', '2026-04-15 06:39:02', NULL, 1, 'pending', 10.00),
(25, 'debleena-stors', 'Debleena Stors', 'Deboleena', 'debleena.chakraborty@delostylestudio.com', '8017988495', NULL, NULL, 1, '2026-04-15 08:55:51', '2026-04-15 08:56:22', NULL, 1, 'pending', 10.00),
(26, 'dst-test-business', 'DST Test Business', 'Rajib Banerjee', 'rajib@delostylestudio.com', '7003882793', NULL, NULL, 1, '2026-04-15 11:17:02', '2026-04-21 05:43:35', NULL, 1, 'pending', 10.00),
(27, 'caldwell-nguyen', 'Caldwell Nguyen', 'Mallory Hodge', 'maityamar825@gmail.com', '7044777972', NULL, NULL, 1, '2026-04-24 08:52:38', '2026-04-24 12:41:34', NULL, 1, 'pending', 10.00),
(28, 'xyz-business-services', 'XYZ Business Services', 'Phang Nga', 'shankhadeep.aich@delostylestudio.com', '0101010101', NULL, NULL, 1, '2026-04-24 12:40:14', '2026-04-24 12:41:30', NULL, 1, 'pending', 10.00),
(29, 'ananda-bazar-patrika', 'Ananda Bazar Patrika', 'Mallory Hodge', 'lenoxiqi@mailinator.com', '6957488459', NULL, NULL, 0, '2026-05-07 12:13:01', '2026-05-07 12:18:08', NULL, 1, 'pending', 10.00);

-- --------------------------------------------------------

--
-- Table structure for table `seller_addresses`
--

CREATE TABLE `seller_addresses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `seller_id` bigint(20) UNSIGNED NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `state` varchar(150) DEFAULT NULL,
  `district` varchar(150) DEFAULT NULL,
  `pincode` varchar(6) DEFAULT NULL,
  `building_number` varchar(255) DEFAULT NULL,
  `street` varchar(150) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `seller_addresses`
--

INSERT INTO `seller_addresses` (`id`, `seller_id`, `email`, `city`, `state`, `district`, `pincode`, `building_number`, `street`, `created_at`, `updated_at`) VALUES
(11, 24, 'amar.maity@delostylestudio.com', 'Howrah', 'West Bengal', 'Howrah', '711302', 'Salt Lake Electronics Complex, XI - 11 & 12, Street Number 17,', 'Near webl more', '2026-04-15 06:30:14', '2026-04-15 06:30:14'),
(12, 25, 'debleena.chakraborty@delostylestudio.com', 'Kolkata', 'West Bengal', 'Kolkata', '700037', 'Test', 'Test', '2026-04-15 08:55:51', '2026-04-15 08:55:51'),
(13, 26, 'rajib@delostylestudio.com', 'Kolkata', 'West Bengal', 'Kolkata', '700029', '0101', 'Rashbehari Avenue', '2026-04-15 11:17:02', '2026-04-15 11:17:02'),
(14, 27, 'maityamar825@gmail.com', 'Howrah', 'West Bengal', 'Howrah', '711302', 'Salt Lake Electronics Complex, XI - 11 & 12, Street Number 17,', 'Near webl more', '2026-04-24 08:53:09', '2026-04-24 08:53:09'),
(15, 28, 'shankhadeep.aich@delostylestudio.com', 'Kolkata', 'West Bengal', 'Kolkata', '700029', '22', 'Devharipur', '2026-04-24 12:40:41', '2026-04-24 12:40:41'),
(16, 29, 'lenoxiqi@mailinator.com', 'Howrah', 'West Bengal', 'Howrah', '711111', 'Salt Lake Electronics Complex, XI - 11 & 12, Street Number 17,', 'Near webl more', '2026-05-07 12:13:51', '2026-05-07 12:13:51'),
(17, 30, 'debleenachakraborty6@gmail.com', 'South 24 Parganas', 'West Bengal', 'South 24 Parganas', '700070', '67', 'Tollygunge', '2026-05-08 09:12:45', '2026-05-08 09:12:45');

-- --------------------------------------------------------

--
-- Table structure for table `seller_bank_details`
--

CREATE TABLE `seller_bank_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `seller_id` bigint(20) UNSIGNED NOT NULL,
  `account_holder_name` varchar(255) NOT NULL,
  `bank_name` varchar(255) NOT NULL,
  `account_number` varchar(255) NOT NULL,
  `ifsc_code` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `seller_bank_details`
--

INSERT INTO `seller_bank_details` (`id`, `seller_id`, `account_holder_name`, `bank_name`, `account_number`, `ifsc_code`, `created_at`, `updated_at`) VALUES
(1, 24, 'Amar Maity', 'HDFC', '123456789', 'UCBA0000403', '2026-05-12 05:28:15', '2026-05-12 05:28:15');

-- --------------------------------------------------------

--
-- Table structure for table `seller_business_details`
--

CREATE TABLE `seller_business_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `seller_id` bigint(20) UNSIGNED NOT NULL,
  `legal_business_name` varchar(255) DEFAULT NULL,
  `store_display_name` varchar(150) DEFAULT NULL,
  `business_type` varchar(50) DEFAULT NULL,
  `gst_available` tinyint(1) NOT NULL DEFAULT 0,
  `gst_number` varchar(15) DEFAULT NULL,
  `pan_number` varchar(11) DEFAULT NULL,
  `pan_name` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `seller_business_details`
--

INSERT INTO `seller_business_details` (`id`, `seller_id`, `legal_business_name`, `store_display_name`, `business_type`, `gst_available`, `gst_number`, `pan_number`, `pan_name`, `created_at`, `updated_at`) VALUES
(18, 24, 'Research and development', 'RD Private Ltd', 'other', 0, NULL, 'CJZPM2825B', 'Amar Kumar Maity', '2026-04-15 06:30:14', '2026-04-15 06:30:14'),
(19, 25, 'D Testing', 'Debleena Stors', 'other', 0, NULL, 'CJZPM3535B', 'Debleena Chakraborty', '2026-04-15 08:55:51', '2026-04-15 08:55:51'),
(20, 26, 'DST Test Business', 'DST Test Business', 'pvt', 0, NULL, 'GFUTY7687X', 'Rajib Banerjee', '2026-04-15 11:17:02', '2026-04-15 11:17:02'),
(21, 27, 'Research and development', 'Caldwell Nguyen', 'other', 0, NULL, 'CWZFD2825B', 'Amar Kumar Maity', '2026-04-24 08:53:09', '2026-04-24 08:53:09'),
(22, 28, 'XYZ Business Services', 'XYZ Business Services', 'sole', 0, NULL, 'BFUTY7687T', 'Shankhadeep Aich', '2026-04-24 12:40:41', '2026-04-24 12:40:41'),
(23, 29, 'ABP Pvd Ltd.', 'Ananda Bazar Patrika', 'other', 0, NULL, 'CWZFD2825B', 'Kay Ortega', '2026-05-07 12:13:51', '2026-05-07 12:13:51'),
(24, 30, 'Baby co', 'Baby store DB', 'llp', 0, NULL, 'BBLPC8826K', 'Debleena Chakraborty', '2026-05-08 09:12:45', '2026-05-08 09:12:45');

-- --------------------------------------------------------

--
-- Table structure for table `seller_pickup_addresses`
--

CREATE TABLE `seller_pickup_addresses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `seller_id` bigint(20) UNSIGNED NOT NULL,
  `pickup_address_line1` varchar(255) NOT NULL,
  `pickup_address_line2` varchar(255) NOT NULL,
  `pickup_city` varchar(255) NOT NULL,
  `pickup_state` varchar(255) NOT NULL,
  `pickup_pincode` varchar(255) NOT NULL,
  `pickup_landmark` varchar(255) DEFAULT NULL,
  `contact_person_name` varchar(255) NOT NULL,
  `contact_mobile` varchar(255) NOT NULL,
  `alternate_mobile` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `seller_pickup_addresses`
--

INSERT INTO `seller_pickup_addresses` (`id`, `seller_id`, `pickup_address_line1`, `pickup_address_line2`, `pickup_city`, `pickup_state`, `pickup_pincode`, `pickup_landmark`, `contact_person_name`, `contact_mobile`, `alternate_mobile`, `created_at`, `updated_at`) VALUES
(11, 24, '27 First Extension', 'Quibusdam adipisicin', 'Kolkata', 'West Bengal', '700009', 'Odio commodi magna n', 'Amar Maity', '9903823389', NULL, '2026-04-15 06:30:14', '2026-04-15 06:30:14'),
(12, 25, '45, test road', 'Webel More', 'North 24 Parganas', 'West Bengal', '700091', 'Near webel more', 'Deboleena', '8017988495', NULL, '2026-04-15 08:55:51', '2026-04-15 08:55:51'),
(13, 26, 'Rashbehari Avenue', 'Rashbehari', 'Kolkata', 'West Bengal', '700029', 'Near Rajdanga High School', 'Rajib Banerjee', '7003882793', NULL, '2026-04-15 11:17:02', '2026-04-15 11:17:02'),
(14, 27, '27 First Extension', 'Quibusdam adipisicin', 'Howrah', 'West Bengal', '711302', 'Odio commodi magna n', 'Mallory Hodge', '7044777972', NULL, '2026-04-24 08:53:09', '2026-04-24 08:53:09'),
(15, 28, '7-11', 'Patong, Phuket, Thailand', 'Patong', 'Phuket', '083150', 'Patong Beach', 'Phang Nga', '0101010101', NULL, '2026-04-24 12:40:41', '2026-04-24 12:40:41'),
(16, 29, '27 First Extension', 'Sint aut sit velit', 'Howrah', 'West Bengal', '711111', 'Odio commodi magna n', 'Mallory Hodge', '6957488459', NULL, '2026-05-07 12:13:51', '2026-05-07 12:13:51'),
(17, 30, 'Tollygunge', 'Bansdroni', 'South 24 Parganas', 'West Bengal', '700070', 'SBI Bank', 'Debleena Chakraborty', '7980948240', NULL, '2026-05-08 09:12:45', '2026-05-08 09:12:45');

-- --------------------------------------------------------

--
-- Table structure for table `seller_settlements`
--

CREATE TABLE `seller_settlements` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_item_id` bigint(20) UNSIGNED NOT NULL,
  `shipment_id` bigint(20) UNSIGNED NOT NULL,
  `seller_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `gross_amount` decimal(10,2) NOT NULL,
  `commission_percent` decimal(5,2) NOT NULL,
  `commission_amount` decimal(10,2) NOT NULL,
  `seller_amount` decimal(10,2) NOT NULL,
  `razorpay_transfer_id` varchar(150) DEFAULT NULL,
  `razorpay_settlement_id` varchar(150) DEFAULT NULL,
  `status` varchar(50) NOT NULL DEFAULT 'pending',
  `hold_until` datetime DEFAULT NULL,
  `settled_at` datetime DEFAULT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`payload`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `seller_supplier_details`
--

CREATE TABLE `seller_supplier_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `seller_id` bigint(20) UNSIGNED NOT NULL,
  `product_categories` varchar(255) NOT NULL,
  `monthly_order_capacity` varchar(255) NOT NULL,
  `average_dispatch_time` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `seller_supplier_details`
--

INSERT INTO `seller_supplier_details` (`id`, `seller_id`, `product_categories`, `monthly_order_capacity`, `average_dispatch_time`, `created_at`, `updated_at`) VALUES
(11, 24, '2', 'lt50', 'same', '2026-04-15 06:30:14', '2026-04-15 06:30:14'),
(12, 25, '5,6', 'lt50', 'same', '2026-04-15 08:55:51', '2026-04-15 08:55:51'),
(13, 26, '5,7,11,17', '50-200', '3-5', '2026-04-15 11:17:02', '2026-04-15 11:17:02'),
(14, 27, '2,4', 'lt50', 'same', '2026-04-24 08:53:09', '2026-04-24 08:53:09'),
(15, 28, '1,2,3,4,5', '50-200', '2-3', '2026-04-24 12:40:41', '2026-04-24 12:40:41'),
(16, 29, '11', 'lt50', 'same', '2026-05-07 12:13:51', '2026-05-07 12:13:51'),
(17, 30, '2', 'lt50', 'same', '2026-05-08 09:12:45', '2026-05-08 09:12:45');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('b2b65AtjaVsS8BvJnMe9YbUPfYDMVSDGGbfwclAU', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiODJNTlVOMkUyYkhjVFMxcFJMNTdITXBRQUFsd2pLSHZmaVdBQm82NiI7czo1NToibG9naW5fY3VzdG9tZXJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aTozMTtzOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czo3MDoiaHR0cDovLzEyNy4wLjAuMTo4MDAwLy53ZWxsLWtub3duL2FwcHNwZWNpZmljL2NvbS5jaHJvbWUuZGV2dG9vbHMuanNvbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1783053294),
('MlaTY4ZulSyTzAgJ87tMrj8BigVdkNIlejfDUoun', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoicHFWWUg0UDBPZjZBcmNYano4RnZuOUlJRW5jMnNwT2N0RDhpUHVMMyI7czo1NToibG9naW5fY3VzdG9tZXJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aTozMTtzOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czozNToiaHR0cDovLzEyNy4wLjAuMTo4MDAwL29yZGVyLWhpc3RvcnkiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1782968383),
('r4M3En6qLrnJm7En5E5QkxERoJ3XqsNouwskQlLZ', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'YTo2OntzOjY6Il90b2tlbiI7czo0MDoiQ3FkajdOcUpndWxNOVBjQ2tMY2oxR1FLNmhUVWRGWFRDSE92cjEyQyI7czo1NToibG9naW5fY3VzdG9tZXJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aTozMTtzOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czo1MToiaHR0cDovLzEyNy4wLjAuMTo4MDAwL29yZGVyLWhpc3Rvcnk/c2VhcmNoPSZzdGF0dXM9Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MjoibG9naW5fYWRtaW5fNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToyO3M6MTg6Imxhc3RfYWN0aXZpdHlfdGltZSI7aToxNzgyOTAzMjA3O30=', 1782903298);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `key` varchar(255) NOT NULL,
  `value` longtext DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `key`, `value`, `created_at`, `updated_at`) VALUES
(1, 'allow_seller_registration', '0', '2025-11-24 03:36:51', '2025-11-26 23:46:28'),
(2, 'require_seller_kyc', '0', '2025-11-24 03:36:51', '2025-11-26 23:46:30'),
(3, 'allow_customer_registration', '0', '2025-11-24 03:36:51', '2025-11-26 23:46:31'),
(4, 'allow_guest_checkout', '0', '2025-11-24 03:36:51', '2025-11-26 23:46:29'),
(5, 'notify_admin_new_order', '0', '2025-11-24 03:36:51', '2025-11-27 01:27:51'),
(6, 'notify_seller_new_order', '0', '2025-11-24 03:36:51', '2025-11-27 01:27:52'),
(7, 'notify_customer_status_update', '0', '2025-11-24 03:36:51', '2025-11-27 01:27:53'),
(8, 'enable_email_notifications', '0', '2025-11-24 03:36:51', '2025-11-27 01:27:54'),
(9, 'allow_multiple_admin_logins', '1', '2025-11-24 03:36:51', '2026-05-12 05:37:28'),
(11, 'platform_name', 'CuddlyDuddly', '2025-11-24 03:36:51', '2025-11-27 01:24:27'),
(12, 'support_email', 'support@cuddlyduddly.com', '2025-11-24 03:36:51', '2025-11-27 01:24:27'),
(13, 'support_phone', '98657412305', '2025-11-24 03:36:51', '2025-11-27 01:24:27'),
(14, 'business_address', 'Webel More , Salt Lake , Bidhan Nagar', '2025-11-24 03:36:51', '2025-11-27 01:24:07'),
(15, 'default_commission_percent', '10', '2025-11-24 03:36:51', '2025-12-01 01:05:27'),
(17, 'session_timeout_minutes', '120', '2025-11-24 03:36:51', '2025-11-27 01:28:27'),
(18, 'store_status', 'active', '2025-11-24 03:36:51', '2025-11-27 03:04:58'),
(19, 'maintenance_message', 'We\'ll be back soon.', '2025-11-24 03:36:51', '2025-11-25 05:38:09'),
(20, 'frontend_maintenance', 'active', '2025-11-24 05:07:13', '2026-04-15 06:27:42'),
(21, 'seller_maintenance', 'active', '2025-11-24 05:07:13', '2025-11-27 03:04:58'),
(22, 'auto_payout_enabled', '0', '2025-11-26 02:04:23', '2025-11-26 07:03:03'),
(23, 'auto_payout_delay_days', '0', '2025-11-26 02:04:23', '2025-11-27 02:02:13'),
(24, 'minimum_payout_threshold', '10000', '2025-11-26 02:04:57', '2025-11-26 07:03:21'),
(25, 'auto_refund_on_order_rejection', '1', '2025-11-26 02:16:38', '2025-11-27 03:13:39'),
(26, 'refund_needs_admin_approval', '0', '2025-11-26 02:16:38', '2025-11-27 03:13:39'),
(27, 'hold_payout_on_dispute', '0', '2025-11-26 02:16:59', '2025-11-27 02:02:24'),
(28, 'dispute_hold_duration_days', '0', '2025-11-26 02:16:59', '2025-11-27 02:02:29'),
(29, 'deduct_gst_on_commission', '0', '2025-11-26 02:18:49', '2025-11-26 05:37:35'),
(30, 'platform_gst_percent', '0', '2025-11-26 02:18:49', '2025-11-26 04:58:56');

-- --------------------------------------------------------

--
-- Table structure for table `settlements_log`
--

CREATE TABLE `settlements_log` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `settlement_batch_id` varchar(100) DEFAULT NULL,
  `total_settlement_amount` decimal(12,2) DEFAULT NULL,
  `total_commission` decimal(12,2) DEFAULT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`payload`)),
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `shipments`
--

CREATE TABLE `shipments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `seller_id` bigint(20) UNSIGNED NOT NULL,
  `provider` varchar(50) DEFAULT 'shiprocket',
  `awb_number` varchar(255) DEFAULT NULL,
  `tracking_number` varchar(100) DEFAULT NULL,
  `courier_name` varchar(100) DEFAULT NULL,
  `courier_code` varchar(50) DEFAULT NULL,
  `tracking_url` text DEFAULT NULL,
  `pickup_token` varchar(100) DEFAULT NULL,
  `expected_delivery` datetime DEFAULT NULL,
  `packed_at` datetime DEFAULT NULL,
  `picked_up_at` datetime DEFAULT NULL,
  `shipped_at` datetime DEFAULT NULL,
  `in_transit_at` datetime DEFAULT NULL,
  `out_for_delivery_at` datetime DEFAULT NULL,
  `cancelled_at` datetime DEFAULT NULL,
  `provider_reference` varchar(150) DEFAULT NULL,
  `shipment_id` varchar(255) DEFAULT NULL,
  `status` varchar(50) NOT NULL DEFAULT 'pending',
  `delivered_at` datetime DEFAULT NULL,
  `rto_initiated_at` datetime DEFAULT NULL,
  `rto_delivered_at` datetime DEFAULT NULL,
  `settlement_status` enum('none','on_hold','released','cancelled') DEFAULT 'none',
  `hold_until` datetime DEFAULT NULL,
  `payload_last` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`payload_last`)),
  `provider_metadata` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`provider_metadata`)),
  `mock_progress` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `shipment_events`
--

CREATE TABLE `shipment_events` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `shipment_id` bigint(20) UNSIGNED NOT NULL,
  `event_code` varchar(60) DEFAULT NULL,
  `event_title` varchar(150) DEFAULT NULL,
  `event_description` text DEFAULT NULL,
  `event_source` varchar(30) DEFAULT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`payload`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `shipment_items`
--

CREATE TABLE `shipment_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `shipment_id` bigint(20) UNSIGNED NOT NULL,
  `order_item_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `shipping_addresses`
--

CREATE TABLE `shipping_addresses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `shipping_name` varchar(150) NOT NULL,
  `shipping_phone` varchar(20) NOT NULL,
  `shipping_email` varchar(150) DEFAULT NULL,
  `address_line1` varchar(255) NOT NULL,
  `address_line2` varchar(255) DEFAULT NULL,
  `landmark` varchar(255) DEFAULT NULL,
  `city` varchar(100) NOT NULL,
  `state` varchar(100) NOT NULL,
  `postal_code` varchar(20) NOT NULL,
  `country` varchar(100) NOT NULL DEFAULT 'India',
  `is_default` tinyint(1) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `shipping_addresses`
--

INSERT INTO `shipping_addresses` (`id`, `user_id`, `shipping_name`, `shipping_phone`, `shipping_email`, `address_line1`, `address_line2`, `landmark`, `city`, `state`, `postal_code`, `country`, `is_default`, `created_at`, `updated_at`) VALUES
(25, 29, 'Shankhadeep Aich', '9875512408', 'shankhadeep.aich@delostylestudio.com', '41, Sodepur Road, Ramkrishnanagar,', 'P.O. Haridevpur', 'Dolly Villa Medical Hall', 'Kolkata', 'West Bengal', '700082', 'India', 1, '2026-04-15 07:08:53', '2026-04-15 07:08:53'),
(26, 31, 'Debleena', '9382319968', 'debleena@gmail.com', '45 , DB Block , Tollygaunge', 'South Kolkata', 'Next to Axis Mall', 'South 24 Parganas', 'West Bengal', '700147', 'India', 1, '2026-04-17 08:20:53', '2026-04-17 08:20:53');

-- --------------------------------------------------------

--
-- Table structure for table `shipping_logs`
--

CREATE TABLE `shipping_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) DEFAULT NULL,
  `shipment_id` bigint(20) UNSIGNED DEFAULT NULL,
  `provider` varchar(50) DEFAULT NULL,
  `event_name` varchar(100) DEFAULT NULL,
  `internal_status` varchar(50) DEFAULT NULL,
  `provider_status` varchar(100) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `remarks` text DEFAULT NULL,
  `event_time` datetime DEFAULT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`payload`)),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `shipping_logs`
--

INSERT INTO `shipping_logs` (`id`, `order_id`, `shipment_id`, `provider`, `event_name`, `internal_status`, `provider_status`, `location`, `remarks`, `event_time`, `payload`, `created_at`, `updated_at`) VALUES
(1, 30, NULL, NULL, 'MOCK_AWB_CREATED', NULL, NULL, NULL, NULL, NULL, '{\"awb\":\"AWB356017\",\"shipment_id\":\"SHIP691c5c75358a0\"}', '2025-11-18 06:15:57', '2025-11-18 17:15:57'),
(2, 31, NULL, NULL, 'MOCK_AWB_CREATED', NULL, NULL, NULL, NULL, NULL, '{\"awb\":\"AWB849352\",\"shipment_id\":\"SHIP691d9cf3510d6\"}', '2025-11-19 05:03:23', '2025-11-19 16:03:23'),
(3, 2, NULL, NULL, 'MOCK_AWB_CREATED', NULL, NULL, NULL, NULL, NULL, '{\"awb\":\"AWB740877\",\"shipment_id\":\"SHIP696dcbc0860af\"}', '2026-01-19 00:44:24', '2026-01-19 11:44:24'),
(4, 4, NULL, NULL, 'MOCK_AWB_CREATED', NULL, NULL, NULL, NULL, NULL, '{\"awb\":\"AWB761270\",\"shipment_id\":\"SHIP69896949263af\"}', '2026-02-08 23:27:45', '2026-02-09 10:27:45');

-- --------------------------------------------------------

--
-- Table structure for table `support_tickets`
--

CREATE TABLE `support_tickets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `assigned_to` bigint(20) UNSIGNED DEFAULT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `type` enum('customer','seller') NOT NULL DEFAULT 'customer',
  `priority` enum('low','medium','high','urgent') DEFAULT 'medium',
  `status` enum('open','in_progress','resolved','closed') DEFAULT 'open',
  `last_reply_by` bigint(20) UNSIGNED DEFAULT NULL,
  `last_replied_at` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `support_tickets`
--

INSERT INTO `support_tickets` (`id`, `user_id`, `assigned_to`, `subject`, `message`, `type`, `priority`, `status`, `last_reply_by`, `last_replied_at`, `created_at`, `updated_at`) VALUES
(2, 19, 6, 'Order not delivered yet', 'I placed an order 10 days ago but still haven\'t received it.', 'customer', 'medium', 'in_progress', 3, '2025-11-10 12:41:13', '2025-11-10 01:41:13', '2025-11-10 04:11:26'),
(4, 2, 5, 'Seller payout delay issue', 'I have not received my payout for last week\'s sales. Please check.', 'seller', 'high', 'in_progress', 3, '2025-11-10 12:43:36', '2025-11-10 01:43:36', '2025-11-10 03:57:55'),
(5, 3, 6, 'testing', 'testing the support flow', 'seller', 'urgent', 'in_progress', 2, '2025-11-10 14:27:39', '2025-11-10 03:27:39', '2025-11-19 04:54:19'),
(6, 2, 2, 'Est pariatur Offici', 'Doloremque maiores n', 'seller', 'medium', 'open', 2, '2025-12-03 11:22:46', '2025-12-03 00:22:46', '2025-12-03 00:22:46'),
(7, 2, 2, 'Sunt nulla id a veni', 'Amet in reprehender', 'seller', 'medium', 'open', 2, '2025-12-03 11:32:56', '2025-12-03 00:32:56', '2025-12-03 00:32:56');

-- --------------------------------------------------------

--
-- Table structure for table `ticket_replies`
--

CREATE TABLE `ticket_replies` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ticket_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `admin_id` bigint(20) UNSIGNED DEFAULT NULL,
  `seller_id` bigint(15) DEFAULT NULL,
  `message` text NOT NULL,
  `is_internal` tinyint(1) DEFAULT 0,
  `attachments` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`attachments`)),
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ticket_replies`
--

INSERT INTO `ticket_replies` (`id`, `ticket_id`, `user_id`, `admin_id`, `seller_id`, `message`, `is_internal`, `attachments`, `created_at`, `updated_at`) VALUES
(1, 5, NULL, NULL, 3, 'hi admin', 0, NULL, '2025-11-13 07:15:23', '2025-11-13 07:15:23'),
(2, 5, NULL, 2, NULL, 'double?', 0, NULL, '2025-11-13 07:15:51', '2025-11-13 07:15:51'),
(3, 5, NULL, NULL, 3, 'huh', 0, NULL, '2025-11-13 07:16:00', '2025-11-13 07:16:00'),
(4, 5, NULL, 2, NULL, 'now fixed.', 0, NULL, '2025-11-13 07:16:13', '2025-11-13 07:16:13'),
(5, 5, NULL, NULL, 3, 'tyhthnth', 0, NULL, '2025-11-13 07:16:21', '2025-11-13 07:16:21'),
(6, 5, NULL, 2, NULL, 'ghrgbg', 0, NULL, '2025-11-13 07:16:24', '2025-11-13 07:16:24'),
(7, 5, NULL, NULL, 3, 'rthrtgbrt', 0, NULL, '2025-11-13 07:16:27', '2025-11-13 07:16:27'),
(8, 5, NULL, 2, NULL, 'gbgb', 0, NULL, '2025-11-13 07:16:30', '2025-11-13 07:16:30'),
(9, 5, NULL, NULL, 3, 'gbgb', 0, NULL, '2025-11-13 07:16:35', '2025-11-13 07:16:35'),
(10, 5, NULL, 2, NULL, 'SOHAM', 0, NULL, '2025-11-13 07:17:27', '2025-11-13 07:17:27'),
(11, 5, NULL, NULL, 3, 'KIBE', 0, NULL, '2025-11-13 07:17:32', '2025-11-13 07:17:32'),
(15, 7, NULL, 2, NULL, 'hi', 0, NULL, '2025-12-03 00:48:16', '2025-12-03 00:48:16'),
(16, 7, NULL, NULL, 2, 'hello', 0, NULL, '2025-12-03 00:48:53', '2025-12-03 00:48:53'),
(17, 6, NULL, 2, NULL, 'hi', 0, NULL, '2026-01-19 00:47:36', '2026-01-19 00:47:36'),
(18, 5, NULL, 2, NULL, 'hello testing', 0, NULL, '2026-02-19 07:05:55', '2026-02-19 07:05:55'),
(19, 5, NULL, 2, NULL, 'ssss', 0, NULL, '2026-02-19 07:06:20', '2026-02-19 07:06:20'),
(20, 5, NULL, 2, NULL, 'ssss', 0, NULL, '2026-02-19 07:06:24', '2026-02-19 07:06:24'),
(21, 5, NULL, 2, NULL, 'wwwww', 0, NULL, '2026-02-19 07:06:30', '2026-02-19 07:06:30');

-- --------------------------------------------------------

--
-- Table structure for table `ticket_tags`
--

CREATE TABLE `ticket_tags` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `color` varchar(20) DEFAULT '#6c757d',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ticket_tags`
--

INSERT INTO `ticket_tags` (`id`, `name`, `color`, `created_at`, `updated_at`) VALUES
(1, 'Urgent', '#dc3545', '2025-11-10 01:46:15', '2025-11-10 01:46:15'),
(2, 'Payment', '#0d6efd', '2025-11-10 01:46:15', '2025-11-10 01:46:15'),
(3, 'Delivery', '#198754', '2025-11-10 01:46:15', '2025-11-10 01:46:15');

-- --------------------------------------------------------

--
-- Table structure for table `ticket_tag_pivot`
--

CREATE TABLE `ticket_tag_pivot` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `support_ticket_id` bigint(20) UNSIGNED NOT NULL,
  `ticket_tag_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(191) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `profile_image` varchar(255) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `gender` enum('male','female','other') DEFAULT NULL,
  `is_verified` tinyint(1) DEFAULT 0,
  `status` enum('active','inactive','banned') DEFAULT 'active',
  `last_login_at` timestamp NULL DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `phone`, `profile_image`, `dob`, `gender`, `is_verified`, `status`, `last_login_at`, `email_verified_at`, `remember_token`, `created_at`, `updated_at`, `deleted_at`) VALUES
(29, 'Shankhadeep Aich', 'shankhadeep.aich@delostylestudio.com', '9875512408', NULL, NULL, NULL, 0, 'active', NULL, NULL, 'bSX30FUq3ykFkoxwQHHag8hTGch7XUpXs070Ro8hUHs3sd1G1HydRwDSZqRp', '2026-04-15 06:49:13', '2026-04-15 06:49:13', NULL),
(30, 'Rajib Banerjee', 'rajib@delostylestudio.com', '917003882793', NULL, NULL, NULL, 0, 'active', NULL, NULL, 'wMEKSQTntjTMVqjaaXN6BuX8V7oynsTJBjX2tMp6dANlbLwLtJUM8li9L5RL', '2026-04-15 11:01:46', '2026-04-15 11:01:46', NULL),
(31, 'Debleena', 'debleena.chakraborty@delostylestudio.com', '8927451285', NULL, NULL, NULL, 0, 'active', NULL, NULL, 'ryhXpcrcQScNJEugeIbExYwavD2JeCMnszrM4IPeo9h3o6oHBl6zhrYV1h1b', '2026-04-16 09:06:45', '2026-04-16 09:06:45', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_otps`
--

CREATE TABLE `user_otps` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `identifier` varchar(255) NOT NULL,
  `otp` varchar(255) NOT NULL,
  `expires_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `attempts` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_otps`
--

INSERT INTO `user_otps` (`id`, `identifier`, `otp`, `expires_at`, `attempts`, `created_at`, `updated_at`) VALUES
(50, '7980948240', '$2y$12$CTNnU4v/PSzCFaGsFJq5kOn4ADmovsYc740fuQeNh.92pgCp06MDC', '2026-04-22 06:15:00', 0, '2026-04-22 06:09:27', '2026-04-22 06:10:00'),
(51, '8927451285', '$2y$12$f8fbTqo3Kxr0xW/7.oGXSesaY1t3H1a4gvhYHwdSFQvGfG.YEsKW6', '2026-04-22 06:17:14', 0, '2026-04-22 06:12:14', '2026-04-22 06:12:14');

-- --------------------------------------------------------

--
-- Table structure for table `variant_attribute_values`
--

CREATE TABLE `variant_attribute_values` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `variant_id` bigint(20) UNSIGNED NOT NULL,
  `attribute_value_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `variant_attribute_values`
--

INSERT INTO `variant_attribute_values` (`id`, `variant_id`, `attribute_value_id`) VALUES
(1330, 706, 976),
(1331, 706, 982),
(1332, 707, 976),
(1333, 707, 983),
(1334, 708, 976),
(1335, 708, 984),
(1336, 709, 979),
(1337, 709, 982),
(1338, 710, 979),
(1339, 710, 983),
(1340, 711, 979),
(1341, 711, 984),
(1342, 712, 975),
(1343, 712, 982),
(1344, 713, 975),
(1345, 713, 983),
(1346, 714, 975),
(1347, 714, 984),
(1348, 715, 974),
(1349, 715, 986),
(1350, 716, 974),
(1351, 716, 987),
(1352, 717, 974),
(1353, 717, 989),
(1354, 718, 974),
(1355, 718, 990),
(1356, 719, 976),
(1357, 719, 986),
(1358, 720, 976),
(1359, 720, 987),
(1360, 721, 976),
(1361, 721, 989),
(1362, 722, 976),
(1363, 722, 990),
(1364, 723, 977),
(1365, 723, 986),
(1366, 724, 977),
(1367, 724, 987),
(1368, 725, 977),
(1369, 725, 989),
(1370, 726, 977),
(1371, 726, 990),
(1372, 727, 979),
(1373, 727, 985),
(1374, 728, 979),
(1375, 728, 986),
(1376, 729, 979),
(1377, 729, 987),
(1378, 730, 975),
(1379, 730, 985),
(1380, 731, 975),
(1381, 731, 986),
(1382, 732, 975),
(1383, 732, 987),
(1384, 733, 980),
(1385, 733, 985),
(1386, 734, 980),
(1387, 734, 986),
(1388, 735, 980),
(1389, 735, 987),
(1390, 736, 975),
(1391, 736, 982),
(1392, 737, 975),
(1393, 737, 983),
(1394, 738, 975),
(1395, 738, 984),
(1396, 739, 975),
(1397, 739, 985),
(1398, 740, 976),
(1399, 740, 982),
(1400, 741, 976),
(1401, 741, 983),
(1402, 742, 976),
(1403, 742, 984),
(1404, 743, 976),
(1405, 743, 985),
(1406, 744, 976),
(1407, 744, 986),
(1408, 745, 976),
(1409, 745, 987),
(1410, 746, 976),
(1411, 746, 988),
(1412, 747, 976),
(1413, 747, 989),
(1414, 748, 977),
(1415, 748, 986),
(1416, 749, 977),
(1417, 749, 987),
(1418, 750, 977),
(1419, 750, 988),
(1420, 751, 977),
(1421, 751, 989),
(1422, 752, 975),
(1423, 752, 986),
(1424, 753, 975),
(1425, 753, 987),
(1426, 754, 975),
(1427, 754, 988),
(1428, 755, 975),
(1429, 755, 989),
(1430, 756, 979),
(1431, 756, 986),
(1432, 757, 979),
(1433, 757, 987),
(1434, 758, 979),
(1435, 758, 988),
(1436, 759, 975),
(1437, 759, 986),
(1438, 760, 975),
(1439, 760, 987),
(1440, 761, 975),
(1441, 761, 988),
(1442, 762, 974),
(1443, 762, 982),
(1444, 763, 974),
(1445, 763, 983),
(1446, 764, 974),
(1447, 764, 985),
(1448, 765, 980),
(1449, 765, 982),
(1450, 766, 980),
(1451, 766, 983),
(1452, 767, 980),
(1453, 767, 985),
(1454, 768, 975),
(1455, 768, 986),
(1456, 769, 975),
(1457, 769, 987),
(1458, 770, 975),
(1459, 770, 989),
(1460, 771, 975),
(1461, 771, 990),
(1462, 772, 976),
(1463, 772, 986),
(1464, 773, 976),
(1465, 773, 987),
(1466, 774, 976),
(1467, 774, 989),
(1468, 775, 976),
(1469, 775, 990),
(1470, 776, 979),
(1471, 776, 985),
(1472, 777, 979),
(1473, 777, 986),
(1474, 778, 979),
(1475, 778, 987),
(1476, 779, 979),
(1477, 779, 988),
(1478, 780, 978),
(1479, 780, 985),
(1480, 781, 978),
(1481, 781, 986),
(1482, 782, 978),
(1483, 782, 987),
(1484, 783, 978),
(1485, 783, 988),
(1486, 784, 980),
(1487, 784, 985),
(1488, 785, 980),
(1489, 785, 986),
(1490, 786, 980),
(1491, 786, 987),
(1492, 787, 980),
(1493, 787, 988),
(1494, 788, 977),
(1495, 788, 986),
(1496, 789, 977),
(1497, 789, 987),
(1498, 790, 977),
(1499, 790, 989),
(1500, 791, 977),
(1501, 791, 990),
(1502, 792, 976),
(1503, 792, 986),
(1504, 793, 976),
(1505, 793, 987),
(1506, 794, 976),
(1507, 794, 989),
(1508, 795, 976),
(1509, 795, 990),
(1510, 796, 975),
(1511, 796, 982),
(1512, 797, 975),
(1513, 797, 983),
(1514, 798, 975),
(1515, 798, 984),
(1516, 799, 979),
(1517, 799, 982),
(1518, 800, 979),
(1519, 800, 983),
(1520, 801, 979),
(1521, 801, 984),
(1522, 802, 976),
(1523, 802, 982),
(1524, 803, 976),
(1525, 803, 983),
(1526, 804, 976),
(1527, 804, 984),
(1528, 805, 974),
(1529, 805, 985),
(1530, 806, 974),
(1531, 806, 986),
(1532, 807, 974),
(1533, 807, 987),
(1534, 808, 981),
(1535, 808, 985),
(1536, 809, 981),
(1537, 809, 986),
(1538, 810, 981),
(1539, 810, 987),
(1540, 811, 979),
(1541, 811, 985),
(1542, 812, 979),
(1543, 812, 986),
(1544, 813, 979),
(1545, 813, 987),
(1546, 814, 978),
(1547, 814, 986),
(1548, 815, 978),
(1549, 815, 987),
(1550, 816, 978),
(1551, 816, 988),
(1552, 817, 978),
(1553, 817, 989),
(1554, 818, 981),
(1555, 818, 986),
(1556, 819, 981),
(1557, 819, 987),
(1558, 820, 981),
(1559, 820, 988),
(1560, 821, 981),
(1561, 821, 989),
(1562, 822, 980),
(1563, 822, 986),
(1564, 823, 980),
(1565, 823, 987),
(1566, 824, 980),
(1567, 824, 988),
(1568, 825, 980),
(1569, 825, 989),
(1570, 826, 977),
(1571, 826, 986),
(1572, 827, 977),
(1573, 827, 987),
(1574, 828, 977),
(1575, 828, 989),
(1576, 829, 977),
(1577, 829, 990),
(1578, 830, 976),
(1579, 830, 986),
(1580, 831, 976),
(1581, 831, 987),
(1582, 832, 976),
(1583, 832, 989),
(1584, 833, 976),
(1585, 833, 990),
(1586, 834, 974),
(1587, 834, 986),
(1588, 835, 974),
(1589, 835, 987),
(1590, 836, 974),
(1591, 836, 989),
(1592, 837, 974),
(1593, 837, 990),
(1594, 838, 975),
(1595, 838, 982),
(1596, 839, 975),
(1597, 839, 983),
(1598, 840, 975),
(1599, 840, 984),
(1600, 841, 979),
(1601, 841, 982),
(1602, 842, 979),
(1603, 842, 983),
(1604, 843, 979),
(1605, 843, 984),
(1606, 844, 979),
(1607, 844, 986),
(1608, 845, 979),
(1609, 845, 987),
(1610, 846, 979),
(1611, 846, 988),
(1612, 847, 979),
(1613, 847, 989),
(1614, 848, 975),
(1615, 848, 986),
(1616, 849, 975),
(1617, 849, 987),
(1618, 850, 975),
(1619, 850, 988),
(1620, 851, 975),
(1621, 851, 989),
(1622, 852, 977),
(1623, 852, 986),
(1624, 853, 977),
(1625, 853, 987),
(1626, 854, 977),
(1627, 854, 988),
(1628, 855, 977),
(1629, 855, 989),
(1630, 856, 976),
(1631, 856, 986),
(1632, 857, 976),
(1633, 857, 987),
(1634, 858, 976),
(1635, 858, 988),
(1636, 859, 976),
(1637, 859, 989),
(1638, 860, 978),
(1639, 860, 986),
(1640, 861, 978),
(1641, 861, 987),
(1642, 862, 978),
(1643, 862, 988),
(1644, 863, 978),
(1645, 863, 989),
(1646, 864, 981),
(1647, 864, 986),
(1648, 865, 981),
(1649, 865, 987),
(1650, 866, 981),
(1651, 866, 989),
(1652, 867, 981),
(1653, 867, 990),
(1654, 868, 975),
(1655, 868, 986),
(1656, 869, 975),
(1657, 869, 987),
(1658, 870, 975),
(1659, 870, 989),
(1660, 871, 975),
(1661, 871, 990),
(1662, 872, 974),
(1663, 872, 986),
(1664, 873, 974),
(1665, 873, 987),
(1666, 874, 974),
(1667, 874, 989),
(1668, 875, 974),
(1669, 875, 990),
(1670, 876, 976),
(1671, 876, 985),
(1672, 877, 976),
(1673, 877, 986),
(1674, 878, 976),
(1675, 878, 987),
(1676, 879, 978),
(1677, 879, 985),
(1678, 880, 978),
(1679, 880, 986),
(1680, 881, 978),
(1681, 881, 987),
(1682, 882, 975),
(1683, 882, 985),
(1684, 883, 975),
(1685, 883, 986),
(1686, 884, 975),
(1687, 884, 987),
(1688, 885, 980),
(1689, 885, 982),
(1690, 886, 980),
(1691, 886, 983),
(1692, 887, 980),
(1693, 887, 984),
(1694, 888, 980),
(1695, 888, 985),
(1696, 889, 979),
(1697, 889, 982),
(1698, 890, 979),
(1699, 890, 983),
(1700, 891, 979),
(1701, 891, 984),
(1702, 892, 979),
(1703, 892, 985),
(1704, 893, 976),
(1705, 893, 982),
(1706, 894, 976),
(1707, 894, 983),
(1708, 895, 976),
(1709, 895, 984),
(1710, 896, 976),
(1711, 896, 985),
(1712, 897, 977),
(1713, 897, 986),
(1714, 898, 977),
(1715, 898, 987),
(1716, 899, 977),
(1717, 899, 989),
(1718, 900, 977),
(1719, 900, 990),
(1720, 901, 975),
(1721, 901, 986),
(1722, 902, 975),
(1723, 902, 987),
(1724, 903, 975),
(1725, 903, 989),
(1726, 904, 975),
(1727, 904, 990),
(1728, 905, 974),
(1729, 905, 985),
(1730, 906, 974),
(1731, 906, 986),
(1732, 907, 974),
(1733, 907, 987),
(1734, 908, 974),
(1735, 908, 988),
(1736, 909, 979),
(1737, 909, 985),
(1738, 910, 979),
(1739, 910, 986),
(1740, 911, 979),
(1741, 911, 987),
(1742, 912, 979),
(1743, 912, 988),
(1744, 913, 975),
(1745, 913, 985),
(1746, 914, 975),
(1747, 914, 986),
(1748, 915, 975),
(1749, 915, 987),
(1750, 916, 975),
(1751, 916, 988),
(1752, 917, 980),
(1753, 917, 985),
(1754, 918, 980),
(1755, 918, 986),
(1756, 919, 980),
(1757, 919, 987),
(1758, 920, 980),
(1759, 920, 988),
(1760, 921, 976),
(1761, 921, 986),
(1762, 922, 976),
(1763, 922, 987),
(1764, 923, 976),
(1765, 923, 989),
(1766, 924, 976),
(1767, 924, 990),
(1768, 925, 977),
(1769, 925, 986),
(1770, 926, 977),
(1771, 926, 987),
(1772, 927, 977),
(1773, 927, 989),
(1774, 928, 977),
(1775, 928, 990),
(1776, 929, 979),
(1777, 929, 982),
(1778, 930, 979),
(1779, 930, 983),
(1780, 931, 979),
(1781, 931, 984),
(1782, 932, 976),
(1783, 932, 982),
(1784, 933, 976),
(1785, 933, 983),
(1786, 934, 976),
(1787, 934, 984),
(1788, 935, 975),
(1789, 935, 982),
(1790, 936, 975),
(1791, 936, 983),
(1792, 937, 975),
(1793, 937, 984),
(1794, 938, 980),
(1795, 938, 985),
(1796, 939, 980),
(1797, 939, 986),
(1798, 940, 980),
(1799, 940, 987),
(1800, 941, 980),
(1801, 941, 988),
(1802, 942, 980),
(1803, 942, 989),
(1804, 943, 974),
(1805, 943, 985),
(1806, 944, 974),
(1807, 944, 986),
(1808, 945, 974),
(1809, 945, 987),
(1810, 946, 974),
(1811, 946, 988),
(1812, 947, 974),
(1813, 947, 989),
(1814, 948, 976),
(1815, 948, 985),
(1816, 949, 976),
(1817, 949, 986),
(1818, 950, 976),
(1819, 950, 987),
(1820, 951, 976),
(1821, 951, 988),
(1822, 952, 976),
(1823, 952, 989);

-- --------------------------------------------------------

--
-- Table structure for table `wishlists`
--

CREATE TABLE `wishlists` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_users`
--
ALTER TABLE `admin_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `admin_users_email_unique` (`email`);

--
-- Indexes for table `attributes`
--
ALTER TABLE `attributes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indexes for table `attribute_values`
--
ALTER TABLE `attribute_values`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_attribute_value` (`attribute_id`,`slug`),
  ADD KEY `idx_attribute_values_attribute` (`attribute_id`);

--
-- Indexes for table `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `brands_slug_unique` (`slug`);

--
-- Indexes for table `brand_master_category_mappings`
--
ALTER TABLE `brand_master_category_mappings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_brand_master` (`brand_id`,`master_category_id`),
  ADD KEY `idx_brand` (`brand_id`),
  ADD KEY `idx_master` (`master_category_id`);

--
-- Indexes for table `brand_navigation_categories`
--
ALTER TABLE `brand_navigation_categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_brand_category` (`brand_id`,`category_id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_cart_item` (`user_id`,`product_id`,`variant_id`,`is_ordered`),
  ADD KEY `carts_user_id_index` (`user_id`),
  ADD KEY `carts_product_id_index` (`product_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_categories_product_category` (`product_categories_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `home_sections`
--
ALTER TABLE `home_sections`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ingestion_batches`
--
ALTER TABLE `ingestion_batches`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_seller_status` (`seller_id`,`status`);

--
-- Indexes for table `ingestion_errors`
--
ALTER TABLE `ingestion_errors`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_batch_product` (`batch_id`,`product_code`);

--
-- Indexes for table `ingestion_products`
--
ALTER TABLE `ingestion_products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_batch_status` (`batch_id`,`status`),
  ADD KEY `idx_product_code` (`product_code`);

--
-- Indexes for table `ingestion_product_images`
--
ALTER TABLE `ingestion_product_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_batch` (`batch_id`),
  ADD KEY `idx_product` (`product_id`),
  ADD KEY `idx_attr_value` (`attribute_value_id`);

--
-- Indexes for table `ingestion_variants`
--
ALTER TABLE `ingestion_variants`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_ingestion_product` (`ingestion_product_id`);

--
-- Indexes for table `inventories`
--
ALTER TABLE `inventories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `sku` (`sku`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `seller_id` (`seller_id`);

--
-- Indexes for table `inventory_logs`
--
ALTER TABLE `inventory_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `inventory_id` (`inventory_id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `master_categories`
--
ALTER TABLE `master_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `master_category_sections`
--
ALTER TABLE `master_category_sections`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_master_section_category` (`master_category_id`,`section_type_id`,`category_id`),
  ADD KEY `idx_master_position` (`master_category_id`,`position`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `role_id` (`role_id`),
  ADD KEY `model_index` (`model_id`,`model_type`);

--
-- Indexes for table `navigation_category_mappings`
--
ALTER TABLE `navigation_category_mappings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_mapping` (`product_sub_category_id`,`category_id`);

--
-- Indexes for table `navigation_master_category_mappings`
--
ALTER TABLE `navigation_master_category_mappings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_nmcm_mapping` (`product_category_id`,`product_sub_category_id`,`master_category_id`),
  ADD KEY `idx_nmcm_category` (`product_category_id`),
  ADD KEY `idx_nmcm_subcategory` (`product_sub_category_id`),
  ADD KEY `idx_nmcm_master` (`master_category_id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `order_number` (`order_number`),
  ADD KEY `fk_orders_user` (`user_id`),
  ADD KEY `fk_orders_shipping` (`shipping_address_id`);

--
-- Indexes for table `order_cancellations`
--
ALTER TABLE `order_cancellations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `cancel_number` (`cancel_number`),
  ADD KEY `idx_cancel_order` (`order_id`),
  ADD KEY `idx_cancel_item` (`order_item_id`),
  ADD KEY `idx_cancel_status` (`status`),
  ADD KEY `idx_cancel_seller` (`seller_id`),
  ADD KEY `fk_cancel_shipment` (`shipment_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_order_items_order` (`order_id`),
  ADD KEY `fk_order_items_product` (`product_id`),
  ADD KEY `idx_order_items_seller` (`seller_id`),
  ADD KEY `idx_order_items_status` (`item_status`),
  ADD KEY `idx_order_items_shipment` (`shipment_id`);

--
-- Indexes for table `order_replacements`
--
ALTER TABLE `order_replacements`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `replacement_number` (`replacement_number`),
  ADD KEY `idx_replace_order` (`order_id`),
  ADD KEY `idx_replace_item` (`order_item_id`),
  ADD KEY `idx_replace_status` (`status`),
  ADD KEY `idx_replace_seller` (`seller_id`),
  ADD KEY `fk_replace_shipment` (`shipment_id`);

--
-- Indexes for table `order_returns`
--
ALTER TABLE `order_returns`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `return_number` (`return_number`),
  ADD KEY `returns_order_id_foreign` (`order_id`),
  ADD KEY `returns_order_item_id_foreign` (`order_item_id`),
  ADD KEY `returns_user_id_foreign` (`user_id`),
  ADD KEY `idx_return_order` (`order_id`),
  ADD KEY `idx_return_item` (`order_item_id`),
  ADD KEY `idx_return_status` (`status`),
  ADD KEY `idx_return_seller` (`seller_id`),
  ADD KEY `fk_return_shipment` (`shipment_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `payment_logs`
--
ALTER TABLE `payment_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payouts`
--
ALTER TABLE `payouts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `payouts_seller_id_status_index` (`seller_id`,`status`),
  ADD KEY `payouts_initiated_by_foreign` (`initiated_by`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD UNIQUE KEY `products_sku_unique` (`sku`),
  ADD KEY `seller_id` (`seller_id`),
  ADD KEY `approved_by` (`approved_by`),
  ADD KEY `idx_products_category` (`product_categories_id`),
  ADD KEY `product_sub_categories_id` (`product_sub_categories_id`),
  ADD KEY `product_code` (`product_code`);

--
-- Indexes for table `product_attribute_values`
--
ALTER TABLE `product_attribute_values`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_product_attribute_value` (`product_id`,`attribute_value_id`),
  ADD KEY `attribute_value_id` (`attribute_value_id`),
  ADD KEY `idx_pav_product` (`product_id`);

--
-- Indexes for table `product_attribute_value_images`
--
ALTER TABLE `product_attribute_value_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_pavi_product` (`product_id`),
  ADD KEY `idx_pavi_attribute_value` (`attribute_value_id`),
  ADD KEY `idx_pavi_sort` (`sort_order`);

--
-- Indexes for table `product_categories`
--
ALTER TABLE `product_categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indexes for table `product_category_attributes`
--
ALTER TABLE `product_category_attributes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_category_attribute` (`product_categories_id`,`attribute_id`),
  ADD KEY `attribute_id` (`attribute_id`);

--
-- Indexes for table `product_category_section`
--
ALTER TABLE `product_category_section`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `product_category_unique` (`product_id`,`master_category_section_id`),
  ADD KEY `product_category_section_master_category_section_id_foreign` (`master_category_section_id`),
  ADD KEY `idx_pcs_section` (`master_category_section_id`);

--
-- Indexes for table `product_images`
--
ALTER TABLE `product_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `product_sub_categories`
--
ALTER TABLE `product_sub_categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_product_sub_category_parent` (`product_categories_id`);

--
-- Indexes for table `product_variants`
--
ALTER TABLE `product_variants`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `sku` (`sku`),
  ADD KEY `idx_variants_product` (`product_id`);

--
-- Indexes for table `product_views`
--
ALTER TABLE `product_views`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_views_user_id_index` (`user_id`),
  ADD KEY `product_views_product_id_index` (`product_id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reviews_product_id_foreign` (`product_id`),
  ADD KEY `reviews_customer_id_foreign` (`user_id`),
  ADD KEY `reviews_product_id_index` (`product_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indexes for table `role_permission`
--
ALTER TABLE `role_permission`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `section_types`
--
ALTER TABLE `section_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sellers`
--
ALTER TABLE `sellers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `phone` (`mobile`),
  ADD UNIQUE KEY `mobile` (`mobile`),
  ADD KEY `idx_slug` (`slug`),
  ADD KEY `idx_sellers_deleted_at` (`deleted_at`);

--
-- Indexes for table `seller_addresses`
--
ALTER TABLE `seller_addresses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_seller_id` (`seller_id`);

--
-- Indexes for table `seller_bank_details`
--
ALTER TABLE `seller_bank_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_seller_id` (`seller_id`);

--
-- Indexes for table `seller_business_details`
--
ALTER TABLE `seller_business_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_seller_id` (`seller_id`);

--
-- Indexes for table `seller_pickup_addresses`
--
ALTER TABLE `seller_pickup_addresses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_seller_id` (`seller_id`);

--
-- Indexes for table `seller_settlements`
--
ALTER TABLE `seller_settlements`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_item_id` (`order_item_id`),
  ADD KEY `shipment_id` (`shipment_id`),
  ADD KEY `seller_id` (`seller_id`),
  ADD KEY `status` (`status`);

--
-- Indexes for table `seller_supplier_details`
--
ALTER TABLE `seller_supplier_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_seller_id` (`seller_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `settings_key_unique` (`key`);

--
-- Indexes for table `settlements_log`
--
ALTER TABLE `settlements_log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `shipments`
--
ALTER TABLE `shipments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `shipments_order_id_foreign` (`order_id`),
  ADD KEY `idx_shipments_status` (`status`),
  ADD KEY `idx_shipments_seller` (`seller_id`),
  ADD KEY `idx_shipments_awb` (`awb_number`);

--
-- Indexes for table `shipment_events`
--
ALTER TABLE `shipment_events`
  ADD PRIMARY KEY (`id`),
  ADD KEY `shipment_id` (`shipment_id`);

--
-- Indexes for table `shipment_items`
--
ALTER TABLE `shipment_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `shipment_id` (`shipment_id`),
  ADD KEY `order_item_id` (`order_item_id`);

--
-- Indexes for table `shipping_addresses`
--
ALTER TABLE `shipping_addresses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_shipping_addresses_user` (`user_id`);

--
-- Indexes for table `shipping_logs`
--
ALTER TABLE `shipping_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_shipping_logs_shipment` (`shipment_id`);

--
-- Indexes for table `support_tickets`
--
ALTER TABLE `support_tickets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_ticket_status` (`status`),
  ADD KEY `idx_ticket_priority` (`priority`),
  ADD KEY `idx_ticket_last_replied_at` (`last_replied_at`);

--
-- Indexes for table `ticket_replies`
--
ALTER TABLE `ticket_replies`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_reply_user` (`user_id`),
  ADD KEY `idx_reply_ticket` (`ticket_id`);

--
-- Indexes for table `ticket_tags`
--
ALTER TABLE `ticket_tags`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ticket_tag_pivot`
--
ALTER TABLE `ticket_tag_pivot`
  ADD PRIMARY KEY (`id`),
  ADD KEY `support_ticket_id` (`support_ticket_id`),
  ADD KEY `ticket_tag_id` (`ticket_tag_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `idx_users_deleted_at` (`deleted_at`);

--
-- Indexes for table `user_otps`
--
ALTER TABLE `user_otps`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_otps_identifier_index` (`identifier`);

--
-- Indexes for table `variant_attribute_values`
--
ALTER TABLE `variant_attribute_values`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_variant_attribute_value` (`variant_id`,`attribute_value_id`),
  ADD KEY `idx_vav_variant` (`variant_id`),
  ADD KEY `idx_vav_attribute_value` (`attribute_value_id`);

--
-- Indexes for table `wishlists`
--
ALTER TABLE `wishlists`
  ADD PRIMARY KEY (`id`),
  ADD KEY `wishlists_user_id_foreign` (`user_id`),
  ADD KEY `wishlists_product_id_foreign` (`product_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_users`
--
ALTER TABLE `admin_users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `attributes`
--
ALTER TABLE `attributes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=225;

--
-- AUTO_INCREMENT for table `attribute_values`
--
ALTER TABLE `attribute_values`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1024;

--
-- AUTO_INCREMENT for table `brands`
--
ALTER TABLE `brands`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `brand_master_category_mappings`
--
ALTER TABLE `brand_master_category_mappings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `brand_navigation_categories`
--
ALTER TABLE `brand_navigation_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `carts`
--
ALTER TABLE `carts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=877;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `home_sections`
--
ALTER TABLE `home_sections`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `ingestion_batches`
--
ALTER TABLE `ingestion_batches`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `ingestion_errors`
--
ALTER TABLE `ingestion_errors`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ingestion_products`
--
ALTER TABLE `ingestion_products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `ingestion_product_images`
--
ALTER TABLE `ingestion_product_images`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=501;

--
-- AUTO_INCREMENT for table `ingestion_variants`
--
ALTER TABLE `ingestion_variants`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `inventories`
--
ALTER TABLE `inventories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `inventory_logs`
--
ALTER TABLE `inventory_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `master_categories`
--
ALTER TABLE `master_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `master_category_sections`
--
ALTER TABLE `master_category_sections`
  MODIFY `id` bigint(15) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1131;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `navigation_category_mappings`
--
ALTER TABLE `navigation_category_mappings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `navigation_master_category_mappings`
--
ALTER TABLE `navigation_master_category_mappings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `order_cancellations`
--
ALTER TABLE `order_cancellations`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `order_replacements`
--
ALTER TABLE `order_replacements`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order_returns`
--
ALTER TABLE `order_returns`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payment_logs`
--
ALTER TABLE `payment_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `payouts`
--
ALTER TABLE `payouts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=399;

--
-- AUTO_INCREMENT for table `product_attribute_values`
--
ALTER TABLE `product_attribute_values`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=991;

--
-- AUTO_INCREMENT for table `product_attribute_value_images`
--
ALTER TABLE `product_attribute_value_images`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1083;

--
-- AUTO_INCREMENT for table `product_categories`
--
ALTER TABLE `product_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `product_category_attributes`
--
ALTER TABLE `product_category_attributes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=256;

--
-- AUTO_INCREMENT for table `product_category_section`
--
ALTER TABLE `product_category_section`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=858;

--
-- AUTO_INCREMENT for table `product_images`
--
ALTER TABLE `product_images`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1109;

--
-- AUTO_INCREMENT for table `product_sub_categories`
--
ALTER TABLE `product_sub_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=513;

--
-- AUTO_INCREMENT for table `product_variants`
--
ALTER TABLE `product_variants`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1003;

--
-- AUTO_INCREMENT for table `product_views`
--
ALTER TABLE `product_views`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `role_permission`
--
ALTER TABLE `role_permission`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `section_types`
--
ALTER TABLE `section_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=113;

--
-- AUTO_INCREMENT for table `sellers`
--
ALTER TABLE `sellers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `seller_addresses`
--
ALTER TABLE `seller_addresses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `seller_bank_details`
--
ALTER TABLE `seller_bank_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `seller_business_details`
--
ALTER TABLE `seller_business_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `seller_pickup_addresses`
--
ALTER TABLE `seller_pickup_addresses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `seller_settlements`
--
ALTER TABLE `seller_settlements`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `seller_supplier_details`
--
ALTER TABLE `seller_supplier_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `settlements_log`
--
ALTER TABLE `settlements_log`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `shipments`
--
ALTER TABLE `shipments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `shipment_events`
--
ALTER TABLE `shipment_events`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `shipment_items`
--
ALTER TABLE `shipment_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `shipping_addresses`
--
ALTER TABLE `shipping_addresses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `shipping_logs`
--
ALTER TABLE `shipping_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `support_tickets`
--
ALTER TABLE `support_tickets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `ticket_replies`
--
ALTER TABLE `ticket_replies`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `ticket_tags`
--
ALTER TABLE `ticket_tags`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `ticket_tag_pivot`
--
ALTER TABLE `ticket_tag_pivot`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `user_otps`
--
ALTER TABLE `user_otps`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `variant_attribute_values`
--
ALTER TABLE `variant_attribute_values`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1898;

--
-- AUTO_INCREMENT for table `wishlists`
--
ALTER TABLE `wishlists`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `attribute_values`
--
ALTER TABLE `attribute_values`
  ADD CONSTRAINT `attribute_values_ibfk_1` FOREIGN KEY (`attribute_id`) REFERENCES `attributes` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `categories`
--
ALTER TABLE `categories`
  ADD CONSTRAINT `fk_categories_product_category` FOREIGN KEY (`product_categories_id`) REFERENCES `product_categories` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `inventories`
--
ALTER TABLE `inventories`
  ADD CONSTRAINT `inventories_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `inventories_ibfk_2` FOREIGN KEY (`seller_id`) REFERENCES `sellers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `inventory_logs`
--
ALTER TABLE `inventory_logs`
  ADD CONSTRAINT `inventory_logs_ibfk_1` FOREIGN KEY (`inventory_id`) REFERENCES `inventories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `fk_orders_shipping` FOREIGN KEY (`shipping_address_id`) REFERENCES `shipping_addresses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_orders_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `order_cancellations`
--
ALTER TABLE `order_cancellations`
  ADD CONSTRAINT `fk_cancel_item` FOREIGN KEY (`order_item_id`) REFERENCES `order_items` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_cancel_order` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_cancel_shipment` FOREIGN KEY (`shipment_id`) REFERENCES `shipments` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `fk_order_items_order` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_order_items_product` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_order_items_shipment` FOREIGN KEY (`shipment_id`) REFERENCES `shipments` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `order_replacements`
--
ALTER TABLE `order_replacements`
  ADD CONSTRAINT `fk_replace_item` FOREIGN KEY (`order_item_id`) REFERENCES `order_items` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_replace_order` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_replace_shipment` FOREIGN KEY (`shipment_id`) REFERENCES `shipments` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `order_returns`
--
ALTER TABLE `order_returns`
  ADD CONSTRAINT `fk_return_shipment` FOREIGN KEY (`shipment_id`) REFERENCES `shipments` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `returns_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `returns_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `payouts`
--
ALTER TABLE `payouts`
  ADD CONSTRAINT `payouts_initiated_by_foreign` FOREIGN KEY (`initiated_by`) REFERENCES `admin_users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `payouts_seller_id_foreign` FOREIGN KEY (`seller_id`) REFERENCES `sellers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `fk_products_approved_by` FOREIGN KEY (`approved_by`) REFERENCES `admin_users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_products_category` FOREIGN KEY (`product_categories_id`) REFERENCES `product_categories` (`id`),
  ADD CONSTRAINT `fk_products_seller` FOREIGN KEY (`seller_id`) REFERENCES `sellers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `product_attribute_values`
--
ALTER TABLE `product_attribute_values`
  ADD CONSTRAINT `product_attribute_values_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `product_attribute_values_ibfk_2` FOREIGN KEY (`attribute_value_id`) REFERENCES `attribute_values` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `product_attribute_value_images`
--
ALTER TABLE `product_attribute_value_images`
  ADD CONSTRAINT `fk_pavi_attribute_value` FOREIGN KEY (`attribute_value_id`) REFERENCES `attribute_values` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_pavi_product` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `product_category_attributes`
--
ALTER TABLE `product_category_attributes`
  ADD CONSTRAINT `product_category_attributes_ibfk_1` FOREIGN KEY (`product_categories_id`) REFERENCES `product_categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `product_category_attributes_ibfk_2` FOREIGN KEY (`attribute_id`) REFERENCES `attributes` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `product_sub_categories`
--
ALTER TABLE `product_sub_categories`
  ADD CONSTRAINT `fk_product_sub_category_parent` FOREIGN KEY (`product_categories_id`) REFERENCES `product_categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `product_variants`
--
ALTER TABLE `product_variants`
  ADD CONSTRAINT `product_variants_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `shipments`
--
ALTER TABLE `shipments`
  ADD CONSTRAINT `shipments_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `shipment_events`
--
ALTER TABLE `shipment_events`
  ADD CONSTRAINT `shipment_events_ibfk_1` FOREIGN KEY (`shipment_id`) REFERENCES `shipments` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `shipment_items`
--
ALTER TABLE `shipment_items`
  ADD CONSTRAINT `shipment_items_ibfk_1` FOREIGN KEY (`shipment_id`) REFERENCES `shipments` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `shipment_items_ibfk_2` FOREIGN KEY (`order_item_id`) REFERENCES `order_items` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `shipping_addresses`
--
ALTER TABLE `shipping_addresses`
  ADD CONSTRAINT `fk_shipping_addresses_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `shipping_logs`
--
ALTER TABLE `shipping_logs`
  ADD CONSTRAINT `fk_shipping_logs_shipment` FOREIGN KEY (`shipment_id`) REFERENCES `shipments` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `ticket_replies`
--
ALTER TABLE `ticket_replies`
  ADD CONSTRAINT `fk_reply_ticket` FOREIGN KEY (`ticket_id`) REFERENCES `support_tickets` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `ticket_tag_pivot`
--
ALTER TABLE `ticket_tag_pivot`
  ADD CONSTRAINT `ticket_tag_pivot_ibfk_1` FOREIGN KEY (`support_ticket_id`) REFERENCES `support_tickets` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `ticket_tag_pivot_ibfk_2` FOREIGN KEY (`ticket_tag_id`) REFERENCES `ticket_tags` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `variant_attribute_values`
--
ALTER TABLE `variant_attribute_values`
  ADD CONSTRAINT `variant_attribute_values_ibfk_1` FOREIGN KEY (`variant_id`) REFERENCES `product_variants` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `variant_attribute_values_ibfk_2` FOREIGN KEY (`attribute_value_id`) REFERENCES `attribute_values` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `wishlists`
--
ALTER TABLE `wishlists`
  ADD CONSTRAINT `wishlists_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `wishlists_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
