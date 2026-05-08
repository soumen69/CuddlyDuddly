-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 18, 2026 at 01:54 PM
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admin_users`
--

INSERT INTO `admin_users` (`id`, `role_id`, `name`, `email`, `phone`, `password`, `session_id`, `is_active`, `created_at`, `updated_at`) VALUES
(2, 5, 'Soumen Maity', 'admin@cuddlyduddly.com', '9382319968', '$2y$12$5jJ083VjsmkvzWR7.kUJOeo0jZxiYGumL2Kjo5jztlYxtPsJkyY3e', 'ROwl5VNjnKWSfaVUEV4h1WBxrLjKXohkmih1inxS', 1, '2025-09-10 04:34:41', '2026-03-18 04:28:13'),
(3, 11, 'Amar Maity', 'amar.maity@delostylestudio.com', NULL, '$2y$12$C2qW5iP6UA4CsAaZBIlKCuNAIVM8hzEH3IcbmxUZ.JJf6fnyEU31q', 'A1XBkk4gKpVPmJ3TTKkB5Uh8pOBU6khIOnxgy2qv', 1, '2025-10-31 07:24:01', '2025-12-09 09:55:38'),
(4, 7, 'Rajesh Kumar', 'rajesh.kumar@delostylestudio.com', NULL, '$2y$12$SSsKeVbeovXdYvgMCjSSmOaXHM822857gxEonEZXxL.E7bTcJBQ/m', NULL, 1, '2025-10-31 09:21:45', '2025-11-05 07:30:15'),
(5, 5, 'Rajib Banerjee', 'rajib@delostylestudio.com', NULL, '$2y$12$B6p4TAy0qBuwLFIilDAQ4uGWN0J7YyFulEznAwcHoaCfmJbjWbB0u', NULL, 1, '2025-10-31 09:24:03', '2025-11-04 04:37:19'),
(6, NULL, 'Debleena Chakraborty', 'debleena.chakraborty@delostylestudio.com', NULL, '$2y$12$xf21UoesWKmLZpSgOidLg.FTn05.bCSrANK3g9J4kqDGXklkKYMVK', NULL, 1, '2025-10-31 09:26:42', '2025-11-04 06:15:14');

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
(5, 'Material', 'material', 'select', 1, 1, 1, 1),
(11, 'Capacity (ml)', 'capacity-ml', 'select', 1, 1, 0, 1),
(12, 'Diaper Size', 'diaper-size', 'select', 1, 1, 0, 1),
(16, 'Language', 'language', 'select', 1, 0, 0, 1),
(17, 'Binding Type', 'binding-type', 'select', 1, 0, 0, 1),
(18, 'Skin Type', 'skin-type', 'select', 1, 0, 0, 1),
(41, 'Age', 'age-69a8279c82f66', 'select', 1, 0, 0, 1),
(90, 'Toy Type', 'toy-type-69aec46003d63', 'select', 1, 0, 0, 1),
(91, 'Skill Type', 'skill-type-69aec46006c30', 'select', 1, 0, 0, 1),
(108, 'Color', 'color-69b3bc341a9d8', 'select', 1, 1, 1, 1),
(109, 'Delivery', 'delivery-69b3bc341d88c', 'boolean', 1, 0, 0, 1),
(110, 'Size', 'size-69b3bc341ead4', 'select', 1, 1, 0, 1),
(111, 'Age Group', 'age-group-69b3bc34213e4', 'multi-select', 1, 0, 0, 1),
(112, 'Occasion', 'occasion-69b3bc3424720', 'select', 1, 0, 0, 1),
(113, 'Brand', 'brand-69b3bc342624d', 'select', 1, 0, 0, 1),
(114, 'Gender', 'gender-69b3bc3427370', 'select', 1, 0, 0, 1);

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
(422, 108, 'Red', 'red-69b3bc341ad8f', 0),
(423, 108, 'Blue', 'blue-69b3bc341b0a3', 0),
(424, 108, 'Green', 'green-69b3bc341b332', 0),
(425, 108, 'Yellow', 'yellow-69b3bc341b542', 0),
(426, 108, 'Black', 'black-69b3bc341b75e', 0),
(427, 108, 'White', 'white-69b3bc341bb51', 0),
(428, 108, 'Pink', 'pink-69b3bc341c40e', 0),
(429, 108, 'Grey', 'grey-69b3bc341c863', 0),
(430, 108, 'Orange', 'orange-69b3bc341cc84', 0),
(431, 108, 'Purple', 'purple-69b3bc341d0b2', 0),
(432, 109, 'Free shipping', 'free-shipping-69b3bc341dcb8', 0),
(433, 109, 'Paid shipping', 'paid-shipping-69b3bc341e07f', 0),
(434, 109, 'COD', 'cod-69b3bc341e40b', 0),
(435, 110, '0-3 Months', '0-3-months-69b3bc341eeaa', 0),
(436, 110, '3-6 Months', '3-6-months-69b3bc341f241', 0),
(437, 110, '6-12 Months', '6-12-months-69b3bc341f570', 0),
(438, 110, '1-2 Years', '1-2-years-69b3bc341f8ba', 0),
(439, 110, '2-3 Years', '2-3-years-69b3bc341fe94', 0),
(440, 110, 'S', 's-69b3bc34201fd', 0),
(441, 110, 'M', 'm-69b3bc342052f', 0),
(442, 110, 'L', 'l-69b3bc342089f', 0),
(443, 110, 'XL', 'xl-69b3bc3420c2a', 0),
(444, 111, '0-6 Months', '0-6-months-69b3bc3422b66', 0),
(445, 111, '6-12 Months', '6-12-months-69b3bc3423084', 0),
(446, 111, '1-3 Years', '1-3-years-69b3bc342351c', 0),
(447, 111, '3-5 Years', '3-5-years-69b3bc3423abb', 0),
(448, 111, '5-8 Years', '5-8-years-69b3bc3423fc6', 0),
(449, 112, 'Party', 'party-69b3bc3424be9', 0),
(450, 112, 'Formal', 'formal-69b3bc3424ff8', 0),
(451, 112, 'Business Casual', 'business-casual-69b3bc34253e0', 0),
(452, 112, 'Semi Casual', 'semi-casual-69b3bc3425794', 0),
(453, 112, 'Ethinic', 'ethinic-69b3bc3425b35', 0),
(454, 113, 'Gucci', 'gucci-69b3bc3426643', 0),
(455, 113, 'Prada', 'prada-69b3bc34269cf', 0),
(456, 113, 'Louis Vuitton', 'louis-vuitton-69b3bc3426d24', 0),
(457, 114, 'Boys', 'boys-69b3bc342775f', 0),
(458, 114, 'Girls', 'girls-69b3bc3427af5', 0),
(459, 114, 'Unisex', 'unisex-69b3bc3427e1e', 0);

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `brands`
--

INSERT INTO `brands` (`id`, `name`, `slug`, `logo`, `description`, `is_active`, `created_at`, `updated_at`) VALUES
(8, 'Soumen', 'soumen', 'brands/8YV3iXKGsuKzu41VUpAx8FrlOGQYIaNNHGU4OXAL.png', 'wfiwrfkjwenfknwekfnierfniornfjkfnkjfnknk', 1, '2025-10-23 07:32:21', '2025-11-21 10:05:25');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('cuddlyduddly-cache-site_settings', 'a:28:{s:25:\"allow_seller_registration\";s:1:\"0\";s:18:\"require_seller_kyc\";s:1:\"0\";s:27:\"allow_customer_registration\";s:1:\"0\";s:20:\"allow_guest_checkout\";s:1:\"0\";s:22:\"notify_admin_new_order\";s:1:\"0\";s:23:\"notify_seller_new_order\";s:1:\"0\";s:29:\"notify_customer_status_update\";s:1:\"0\";s:26:\"enable_email_notifications\";s:1:\"0\";s:27:\"allow_multiple_admin_logins\";s:1:\"0\";s:13:\"platform_name\";s:12:\"CuddlyDuddly\";s:13:\"support_email\";s:24:\"support@cuddlyduddly.com\";s:13:\"support_phone\";s:11:\"98657412305\";s:16:\"business_address\";s:37:\"Webel More , Salt Lake , Bidhan Nagar\";s:26:\"default_commission_percent\";s:2:\"10\";s:23:\"session_timeout_minutes\";s:3:\"120\";s:12:\"store_status\";s:6:\"active\";s:19:\"maintenance_message\";s:19:\"We\'ll be back soon.\";s:20:\"frontend_maintenance\";s:6:\"active\";s:18:\"seller_maintenance\";s:6:\"active\";s:19:\"auto_payout_enabled\";s:1:\"0\";s:22:\"auto_payout_delay_days\";s:1:\"0\";s:24:\"minimum_payout_threshold\";s:5:\"10000\";s:30:\"auto_refund_on_order_rejection\";s:1:\"1\";s:27:\"refund_needs_admin_approval\";s:1:\"0\";s:22:\"hold_payout_on_dispute\";s:1:\"0\";s:26:\"dispute_hold_duration_days\";s:1:\"0\";s:24:\"deduct_gst_on_commission\";s:1:\"0\";s:20:\"platform_gst_percent\";s:1:\"0\";}', 1773839990);

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cancellations`
--

CREATE TABLE `cancellations` (
  `id` bigint(20) NOT NULL,
  `order_id` bigint(20) NOT NULL,
  `user_id` bigint(20) DEFAULT NULL,
  `reason` text DEFAULT NULL,
  `status` enum('pending','approved','rejected') DEFAULT 'pending',
  `approved_by` bigint(20) DEFAULT NULL,
  `approved_at` datetime DEFAULT NULL,
  `refund_amount` decimal(10,2) DEFAULT NULL,
  `refund_status` enum('pending','processing','paid','failed') DEFAULT 'pending',
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cancellations`
--

INSERT INTO `cancellations` (`id`, `order_id`, `user_id`, `reason`, `status`, `approved_by`, `approved_at`, `refund_amount`, `refund_status`, `created_at`, `updated_at`) VALUES
(1, 6, 19, 'Product no longer needed', 'pending', NULL, NULL, NULL, 'pending', '2025-10-21 16:34:56', '2025-10-21 16:36:47'),
(2, 13, 20, 'Ordered by mistake', 'pending', NULL, NULL, NULL, 'pending', '2025-10-21 16:36:19', '2025-10-21 16:37:00'),
(3, 15, 20, 'Ordered by mistake', 'approved', 2, '2025-10-21 17:13:07', NULL, 'pending', '2025-10-21 16:42:58', '2025-10-21 17:13:07');

-- --------------------------------------------------------

--
-- Table structure for table `carts`
--

CREATE TABLE `carts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `is_ordered` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `carts`
--

INSERT INTO `carts` (`id`, `user_id`, `product_id`, `quantity`, `is_ordered`, `created_at`, `updated_at`) VALUES
(1, 19, 19, 1, 0, '2025-11-17 07:49:22', '2025-11-17 07:49:22'),
(2, 19, 22, 2, 1, '2025-11-17 07:49:28', '2025-11-17 07:49:28');

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
(144, 'Board Games', 'board-games', 5, NULL, NULL),
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
(366, 'Lotions, Oils & Powders', 'lotions-oils-powders', 5, NULL, NULL),
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
(875, '4+ Years', '4-years', 5, NULL, NULL);

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
(1, 'hero', '{\"heading\": {\"iconone\": \"Discovering\", \"icontwo\": \"parenthood\", \"rest\": \"made easier\"}, \"subheading\": \"Shop 10,000+ Curated, Safe & Reliable Baby and Mother Products.\", \"cta_text\": \"100+ trusted customers\", \"cta_url\": \"#\", \"avatars\": [\"storage/WebsiteImages/home/reviewicon1.png\", \"storage/WebsiteImages/home/reviewicon2.png\", \"storage/WebsiteImages/home/reviewicon3.png\"], \"hero_image\": \"storage/WebsiteImages/home/motherchild.webp\", \"throne_image\": \"storage/WebsiteImages/home/throne.png\", \"pattern_image\": \"storage/WebsiteImages/home/hero-pattern.png\"}', 1, 1, NULL, '2026-02-09 11:55:18'),
(2, 'story', '{\"image\":\"storage\\/WebsiteImages\\/home\\/ourstory.webp\",\"text\":\"We are your trusted online source for <strong>10,000+<\\/strong> 100% safety-compliant and innovative baby and mother essentials. Our mission is to support every stage of your family\'s journey with unwavering quality, expertise, and seamless care.\"}', 2, 1, NULL, '2026-02-09 11:55:18'),
(3, 'trust_icons', '[{\"icon\":\"storage\\/WebsiteImages\\/home\\/icon1.png\",\"text\":\"100% Safety Guaranteed\"},{\"icon\":\"storage\\/WebsiteImages\\/home\\/icon2.png\",\"text\":\"Nationwide Fast Shipping\"},{\"icon\":\"storage\\/WebsiteImages\\/home\\/icon3.png\",\"text\":\"Exceptional Customer Care\"}]', 3, 1, NULL, '2026-02-09 11:55:18'),
(4, 'category_grid', '[{\"image\":\"storage\\/WebsiteImages\\/home\\/pregnant-woman.webp\",\"title\":\"Pregnancy & Mom\",\"url\":\"\\/category\\/pregnancy-mom\"},{\"image\":\"storage\\/WebsiteImages\\/home\\/categoryimg6.webp\",\"title\":\"Infant & New Born Essentials\",\"url\":\"\\/category\\/infant-newborn\"},{\"image\":\"storage\\/WebsiteImages\\/home\\/categoryimg5.webp\",\"title\":\"Baby Gear & Travels\",\"url\":\"\\/category\\/baby-gear\"},{\"image\":\"storage\\/WebsiteImages\\/home\\/categoryimg4.webp\",\"title\":\"Fashion (0\\u201310+ Years)\",\"url\":\"\\/category\\/kids-fashion\"},{\"image\":\"storage\\/WebsiteImages\\/home\\/categoryimg3.webp\",\"title\":\"Nursery & Room Decor\",\"url\":\"\\/category\\/nursery\"},{\"image\":\"storage\\/WebsiteImages\\/home\\/categoryimg2.webp\",\"title\":\"Toys, Books & Learning\",\"url\":\"\\/category\\/toys-learning\"}]', 4, 1, NULL, '2026-02-09 11:55:18'),
(5, 'customer_favourites', '[{\"price\": 399, \"title\": \"Infant & New Born Essentials\", \"image\": \"storage/WebsiteImages/home/button1.png\", \"url\": \"/products?price_upto=399\"}, {\"price\": 799, \"title\": \"Infant & New Born Essentials\", \"image\": \"storage/WebsiteImages/home/button3.png\", \"url\": \"/products?price_upto=799\"}, {\"price\": 1299, \"title\": \"Pregnancy & Mom Care\", \"image\": \"storage/WebsiteImages/home/button4.png\", \"url\": \"/products?price_upto=1299\"},{\"price\": 399, \"title\": \"Infant & New Born Essentials\", \"image\": \"storage/WebsiteImages/home/button2.png\", \"url\": \"/products?price_upto=399\"}]', 5, 1, NULL, '2026-02-09 11:55:18'),
(6, 'product_list', '{\"title\": \"Featured bestsellers\", \"products\": [{\"name\": \"Maxi Cosi Zelia Luxe 5-in-1 Modular Travel System\", \"subtitle\": \"No Recline, Blue\", \"image\": \"storage/WebsiteImages/home/travelsystem.png\", \"rating\": 4.5, \"mrp\": 2395, \"price\": 995, \"url\": \"/product/maxi-cosi-zelia\"}, {\"name\": \"Friends Baby Cotton Snap Sleep and Play 2pk\", \"subtitle\": \"Brand: Luvable Friends\", \"image\": \"storage/WebsiteImages/home/babycloth.png\", \"rating\": 4.5, \"mrp\": 2395, \"price\": 1995, \"url\": \"/product/baby-cotton-sleep-play\"}, {\"name\": \"Baby Trend Cover Me 4-In-1 Convertible Car Seat\", \"subtitle\": \"Brand: Baby Trend\", \"image\": \"storage/WebsiteImages/home/carseat.png\", \"rating\": 4.5, \"mrp\": 2395, \"price\": 995, \"url\": \"/product/baby-trend-carseat\"}]}', 6, 1, NULL, '2026-02-09 11:55:18'),
(7, 'brand_logos', '[\"storage/WebsiteImages/home/brandicon1.png\", \"storage/WebsiteImages/home/brandicon2.png\", \"storage/WebsiteImages/home/brandicon3.png\", \"storage/WebsiteImages/home/brandicon4.png\", \"storage/WebsiteImages/home/brandicon5.png\", \"storage/WebsiteImages/home/brandicon6.png\"]', 7, 1, NULL, '2026-02-09 11:55:18'),
(8, 'promo', '{\"image\":\"storage/WebsiteImages/home/babyroom.png\", \"title\": \"The Baby Shop\", \"subtitle\": \"Curated and seasoned finds for your little ones\", \"cta_text\": \"Shop now\", \"cta_url\": \"/shop\"}', 8, 1, NULL, '2026-02-09 11:55:18'),
(9, 'brands_we_love', '[{\"image\":\"storage/WebsiteImages/home/brandimage1.png\", \"url\": \"#!\"}, {\"image\": \"storage/WebsiteImages/home/brandimage2.png\", \"url\": \"#!\"}]', 10, 1, '2026-01-20 10:34:27', '2026-02-09 11:55:18'),
(10, 'new_arrivals', '{\"view_all_url\": \"/products/new-arrivals\", \"products\": [{\"name\": \"Maxi Cosi Zelia Luxe 5-in-1 Modular Travel System\", \"subtitle\": \"No Recline, blue\", \"image\": \"storage/WebsiteImages/home/travelsystem.png\", \"rating\": 4.5, \"mrp\": 2395, \"price\": 995, \"url\": \"/product/maxi-cosi-zelia\"}, {\"name\": \"Friends Baby Cotton Snap Sleep and Play 2pk\", \"subtitle\": \"Brand: Luvable Friends\", \"image\": \"storage/WebsiteImages/home/babycloth.png\", \"rating\": 4.5, \"mrp\": 2395, \"price\": 1995, \"url\": \"/product/baby-cotton-sleep-play\"}, {\"name\": \"Baby Trend Cover Me 4-In-1 Convertible Car Seat\", \"subtitle\": \"Brand: Baby Trend\", \"image\": \"storage/WebsiteImages/home/carseat.png\", \"rating\": 4.5, \"mrp\": 2395, \"price\": 995, \"url\": \"/product/baby-trend-carseat\"}]}', 11, 1, '2026-01-20 10:34:49', '2026-02-09 11:55:18'),
(11, 'newsletter', '{\"title\": \"Enjoy 10% Off Your First Order\", \"subtitle\": \"Free shipping on orders above ₹49\", \"cta_text\": \"Join today\", \"cta_url\": \"/register\", \"background\": \"storage/WebsiteImages/home/background-bottom.png\"}', 9, 1, NULL, '2026-02-09 11:55:18');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `jobs`
--

INSERT INTO `jobs` (`id`, `queue`, `payload`, `attempts`, `reserved_at`, `available_at`, `created_at`) VALUES
(1, 'default', '{\"uuid\":\"8d50320a-b12e-448f-9eff-8673c989bec4\",\"displayName\":\"App\\\\Events\\\\TicketMessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":15:{s:5:\\\"event\\\";O:28:\\\"App\\\\Events\\\\TicketMessageSent\\\":4:{s:8:\\\"ticketId\\\";s:1:\\\"5\\\";s:7:\\\"message\\\";s:2:\\\"hi\\\";s:8:\\\"is_admin\\\";b:1;s:4:\\\"time\\\";s:13:\\\"0 seconds ago\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1762837670,\"delay\":null}', 0, NULL, 1762837670, 1762837670),
(2, 'default', '{\"uuid\":\"164a0458-6089-45cf-a7c0-1e125aadc7c6\",\"displayName\":\"App\\\\Events\\\\TicketMessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":15:{s:5:\\\"event\\\";O:28:\\\"App\\\\Events\\\\TicketMessageSent\\\":4:{s:8:\\\"ticketId\\\";s:1:\\\"5\\\";s:7:\\\"message\\\";s:7:\\\"testing\\\";s:8:\\\"is_admin\\\";b:1;s:4:\\\"time\\\";s:13:\\\"0 seconds ago\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1762837729,\"delay\":null}', 0, NULL, 1762837729, 1762837729),
(3, 'default', '{\"uuid\":\"5683cf2c-6980-4ec9-81e8-6888c54d577c\",\"displayName\":\"App\\\\Events\\\\TicketMessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":15:{s:5:\\\"event\\\";O:28:\\\"App\\\\Events\\\\TicketMessageSent\\\":4:{s:8:\\\"ticketId\\\";s:1:\\\"5\\\";s:7:\\\"message\\\";s:7:\\\"really?\\\";s:8:\\\"is_admin\\\";b:1;s:4:\\\"time\\\";s:13:\\\"0 seconds ago\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1762838334,\"delay\":null}', 0, NULL, 1762838334, 1762838334);

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
(1086, 18, 3, 875, 1082);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
(25, '2026_02_13_104818_create_user_otps_table', 12);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`id`, `role_id`, `model_id`, `model_type`) VALUES
(1, 5, 2, 'App\\Models\\AdminUser'),
(4, 6, 3, 'App\\Models\\AdminUser');

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
  `order_status` enum('pending','processing','shipped','delivered','cancelled') NOT NULL DEFAULT 'pending',
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `shipping_address_id`, `order_number`, `razorpay_order_id`, `razorpay_payment_id`, `total_amount`, `payment_method`, `payment_status`, `order_status`, `notes`, `created_at`, `updated_at`) VALUES
(2, 20, 7, 'ORD-1002', NULL, NULL, 980.00, 'online', 'paid', 'processing', NULL, '2025-11-28 05:51:21', '2025-11-28 07:51:21'),
(3, 21, 9, 'ORD-1003', NULL, NULL, 1200.00, 'cod', 'paid', 'delivered', NULL, '2025-11-28 02:51:21', '2025-11-28 07:51:21'),
(7, 21, 9, 'ORD-1007', NULL, NULL, 320.00, 'online', 'paid', 'processing', NULL, '2025-11-25 07:51:21', '2025-11-28 07:51:21'),
(8, 21, 20, 'ORD-1008', NULL, NULL, 870.00, 'online', 'paid', 'delivered', NULL, '2025-11-24 07:51:21', '2025-11-28 07:51:21'),
(10, 20, 7, 'ORD-1010', NULL, NULL, 1990.00, 'online', 'paid', 'delivered', NULL, '2025-11-22 07:51:21', '2025-11-28 07:51:21'),
(11, 20, 9, 'ORD-1011', NULL, NULL, 540.00, 'cod', 'paid', 'delivered', NULL, '2025-11-18 07:51:21', '2025-11-28 07:51:21'),
(12, 21, 20, 'ORD-1012', NULL, NULL, 760.00, 'online', 'paid', 'processing', NULL, '2025-11-16 07:51:21', '2025-11-28 07:51:21'),
(15, 20, 9, 'ORD-1015', NULL, NULL, 650.00, 'online', 'paid', 'processing', NULL, '2025-11-08 07:51:21', '2025-11-28 07:51:21'),
(18, 21, 7, 'ORD-1018', NULL, NULL, 1250.00, 'online', 'paid', 'shipped', NULL, '2025-10-31 07:51:21', '2025-11-28 07:51:21'),
(20, 20, 20, 'ORD-1020', NULL, NULL, 1540.00, 'online', 'paid', 'delivered', NULL, '2025-10-29 07:51:21', '2025-11-28 07:51:21');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(10) UNSIGNED NOT NULL DEFAULT 1,
  `price` decimal(10,2) NOT NULL DEFAULT 0.00,
  `commission_percent` decimal(5,2) DEFAULT NULL,
  `commission_amount` decimal(10,2) DEFAULT NULL,
  `seller_amount` decimal(10,2) DEFAULT NULL,
  `settlement_status` enum('pending','settled','refunded') DEFAULT 'pending',
  `subtotal` decimal(10,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
(16, 'mock.order.created', '{\"razorpay_order_id\":\"order_691c5bb6da3d0\"}', 'razorpay', '2025-11-18 11:42:46', '2025-11-18 11:42:46'),
(17, 'mock.order.created', '{\"razorpay_order_id\":\"order_691d9cb18b2bc\"}', 'razorpay', '2025-11-19 10:32:17', '2025-11-19 10:32:17');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payouts`
--

INSERT INTO `payouts` (`id`, `seller_id`, `order_id`, `order_item_id`, `initiated_by`, `amount`, `commission_amount`, `seller_amount`, `settlement_type`, `currency`, `status`, `provider_payout_id`, `razorpay_settlement_id`, `provider_response`, `requested_at`, `processed_at`, `created_at`, `updated_at`) VALUES
(1, 1, NULL, NULL, 2, 2000.00, NULL, NULL, 'auto', 'INR', 'failed', NULL, NULL, '{\"error\":\"Client error: `POST https:\\/\\/api.razorpay.com\\/v1\\/payouts` resulted in a `400 Bad Request` response:\\n{\\\"error\\\":{\\\"code\\\":\\\"BAD_REQUEST_ERROR\\\",\\\"description\\\":\\\"The RazorpayX Account number is invalid.\\\",\\\"source\\\":null,\\\"step\\\":null, (truncated...)\\n\"}', '2025-09-26 10:03:26', NULL, '2025-09-26 10:03:26', '2025-09-26 10:03:28'),
(2, 1, NULL, NULL, 2, 2000.00, NULL, NULL, 'auto', 'INR', 'failed', NULL, NULL, '{\"error\":\"Client error: `POST https:\\/\\/api.razorpay.com\\/v1\\/payouts` resulted in a `400 Bad Request` response:\\n{\\\"error\\\":{\\\"code\\\":\\\"BAD_REQUEST_ERROR\\\",\\\"description\\\":\\\"The RazorpayX Account number is invalid.\\\",\\\"source\\\":null,\\\"step\\\":null, (truncated...)\\n\"}', '2025-09-26 12:17:47', NULL, '2025-09-26 12:17:47', '2025-09-26 12:17:50'),
(3, 1, NULL, NULL, 2, 2000.00, NULL, NULL, 'auto', 'INR', 'failed', NULL, NULL, '{\"error\":\"Client error: `POST https:\\/\\/api.razorpay.com\\/v1\\/payouts` resulted in a `400 Bad Request` response:\\n{\\\"error\\\":{\\\"code\\\":\\\"BAD_REQUEST_ERROR\\\",\\\"description\\\":\\\"The RazorpayX Account number is invalid.\\\",\\\"source\\\":null,\\\"step\\\":null, (truncated...)\\n\"}', '2025-10-07 05:44:27', NULL, '2025-10-07 05:44:27', '2025-10-07 05:44:29'),
(4, 1, NULL, NULL, 2, 4000.00, NULL, NULL, 'auto', 'INR', 'failed', NULL, NULL, '{\"error\":\"Client error: `POST https:\\/\\/api.razorpay.com\\/v1\\/payouts` resulted in a `400 Bad Request` response:\\n{\\\"error\\\":{\\\"code\\\":\\\"BAD_REQUEST_ERROR\\\",\\\"description\\\":\\\"The RazorpayX Account number is invalid.\\\",\\\"source\\\":null,\\\"step\\\":null, (truncated...)\\n\"}', '2025-10-21 05:02:08', NULL, '2025-10-21 05:02:08', '2025-10-21 05:02:12');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `type`, `slug`, `group_name`, `description`, `created_at`, `updated_at`) VALUES
(2, 'All Sellers', 'option', 'admin.sellers.index', 'Sellers', 'View and manage all sellers', '2025-11-04 01:07:40', '2025-11-04 01:07:40'),
(4, 'KYC / Compliance', 'option', 'admin.sellers.compliance', 'Sellers', 'Access KYC compliance section', '2025-11-04 01:07:40', '2025-11-06 07:28:20'),
(5, 'Payouts', 'option', 'admin.payouts.index', 'Sellers', 'View and manage payouts', '2025-11-04 01:07:40', '2025-11-06 07:28:20'),
(6, 'All Products', 'option', 'admin.products.index', 'Products', 'View and manage products', '2025-11-04 01:07:40', '2025-11-04 01:07:40'),
(7, 'Categories', 'option', 'admin.categories.index', 'Products', 'Manage product categories', '2025-11-04 01:07:40', '2025-11-04 01:07:40'),
(8, 'Brands', 'option', 'admin.brands.index', 'Products', 'Manage product brands', '2025-11-04 01:07:40', '2025-11-04 01:07:40'),
(9, 'Inventory', 'option', 'admin.inventory.index', 'Products', 'Manage product inventory', '2025-11-04 01:07:40', '2025-11-04 01:07:40'),
(10, 'All Orders', 'option', 'admin.orders.index', 'Orders', 'View and manage orders', '2025-11-04 01:07:40', '2025-11-04 01:07:40'),
(11, 'Returns', 'option', 'admin.returns.index', 'Orders', 'Handle product returns', '2025-11-04 01:07:40', '2025-11-04 01:07:40'),
(12, 'Cancellations', 'option', 'admin.cancellations.index', 'Orders', 'Handle order cancellations', '2025-11-04 01:07:40', '2025-11-04 01:07:40'),
(13, 'All Customers', 'option', 'admin.customers.index', 'Customers', 'Manage customer accounts', '2025-11-04 01:07:40', '2025-11-04 01:07:40'),
(14, 'Reviews', 'option', 'admin.reviews.index', 'Customers', 'View and moderate reviews', '2025-11-04 01:07:40', '2025-11-04 01:07:40'),
(15, 'Wishlists', 'option', 'admin.wishlists.index', 'Customers', 'View customer wishlists', '2025-11-04 01:07:40', '2025-11-04 01:07:40'),
(16, 'Banners', 'option', 'admin.website.banners', 'Website Content', 'Manage website banners', '2025-11-04 01:07:40', '2025-11-04 01:07:40'),
(17, 'Landing Pages', 'option', 'admin.website.pages', 'Website Content', 'Manage landing pages', '2025-11-04 01:07:40', '2025-11-04 01:07:40'),
(18, 'Blog Posts', 'option', 'admin.website.blogs.index', 'Website Content', 'Manage blog posts', '2025-11-04 01:07:40', '2025-11-04 07:05:44'),
(19, 'SEO Settings', 'option', 'admin.website.seo', 'Website Content', 'Manage SEO settings', '2025-11-04 01:07:40', '2025-11-04 01:07:40'),
(20, 'Seller Support', 'option', 'admin.support.seller', 'Support', 'Handle seller support', '2025-11-04 01:07:40', '2025-11-04 01:07:40'),
(21, 'Customer Support', 'option', 'admin.support.customer', 'Support', 'Handle customer support', '2025-11-04 01:07:40', '2025-11-04 01:07:40'),
(22, 'Tickets', 'option', 'admin.support.tickets.index', 'Support', 'Manage support tickets', '2025-11-04 01:07:40', '2025-11-04 07:05:44'),
(23, 'Sales Report', 'option', 'admin.reports.sales', 'Reports', 'View sales report', '2025-11-04 01:07:40', '2025-11-04 01:07:40'),
(24, 'Revenue Report', 'option', 'admin.reports.revenue', 'Reports', 'View revenue report', '2025-11-04 01:07:40', '2025-11-04 01:07:40'),
(25, 'Seller Performance', 'option', 'admin.reports.seller-performance', 'Reports', 'View seller performance', '2025-11-04 01:07:40', '2025-11-04 01:07:40'),
(26, 'Customer Insights', 'option', 'admin.reports.customer-insights', 'Reports', 'View customer insights', '2025-11-04 01:07:40', '2025-11-04 01:07:40'),
(27, 'General Settings', 'option', 'admin.settings.general', 'Settings', 'Manage general settings', '2025-11-04 01:07:40', '2025-11-04 01:07:40'),
(28, 'Payment Gateways', 'option', 'admin.settings.payments', 'Settings', 'Manage payment gateways', '2025-11-04 01:07:40', '2025-11-04 01:07:40'),
(29, 'Shipping', 'option', 'admin.settings.shipping', 'Settings', 'Manage shipping options', '2025-11-04 01:07:40', '2025-11-04 01:07:40'),
(30, 'Roles & Permissions', 'option', 'admin.roles.index', 'Settings', 'Manage roles and permissions', '2025-11-04 01:07:40', '2025-11-04 01:07:40'),
(35, 'Add Seller', 'action', 'admin.sellers.create', 'Sellers', 'Create new seller', '2025-11-06 02:02:38', '2025-11-06 02:02:38'),
(36, 'View Seller', 'action', 'admin.sellers.show', 'Sellers', 'View seller details', '2025-11-06 02:02:38', '2025-11-06 07:18:07'),
(37, 'Edit Seller', 'action', 'admin.sellers.edit', 'Sellers', 'Edit seller info', '2025-11-06 02:02:38', '2025-11-06 02:02:38'),
(38, 'Delete Seller', 'action', 'admin.sellers.delete', 'Sellers', 'Delete seller', '2025-11-06 02:02:38', '2025-11-06 02:02:38'),
(39, 'View KYC Docs', 'action', 'admin.sellers.kyc.view', 'Sellers', 'View seller KYC documents', '2025-11-06 02:02:38', '2025-11-06 07:28:20'),
(40, 'Verify KYC', 'action', 'admin.sellers.kyc.verify', 'Sellers', 'Verify seller KYC details', '2025-11-06 02:02:38', '2025-11-06 07:28:20'),
(41, 'Reject KYC', 'action', 'admin.sellers.kyc.reject', 'Sellers', 'Reject seller KYC application', '2025-11-06 02:02:38', '2025-11-06 07:28:20'),
(42, 'Initiate Payout', 'action', 'admin.payouts.create', 'Sellers', 'Create a new payout', '2025-11-06 02:02:38', '2025-11-06 07:28:20'),
(43, 'Edit Payout', 'action', 'admin.payouts.edit', 'Sellers', 'Edit payout details', '2025-11-06 02:02:38', '2025-11-06 07:28:20'),
(44, 'Delete Payout', 'action', 'admin.payouts.delete', 'Sellers', 'Delete payout record', '2025-11-06 02:02:38', '2025-11-06 07:28:20'),
(45, 'Add Product', 'action', 'admin.products.create', 'Products', 'Create new product', '2025-11-06 02:02:38', '2025-11-06 02:02:38'),
(46, 'Delete Selected Products', 'action', 'admin.products.bulk_delete', 'Products', 'Bulk delete products', '2025-11-06 02:02:38', '2025-11-06 02:02:38'),
(47, 'Feature Selected Products', 'action', 'admin.products.bulk_feature', 'Products', 'Bulk feature products', '2025-11-06 02:02:38', '2025-11-06 02:02:38'),
(48, 'Approve Selected Products', 'action', 'admin.products.bulk_approve', 'Products', 'Bulk approve products', '2025-11-06 02:02:38', '2025-11-06 02:02:38'),
(49, 'Edit Product', 'action', 'admin.products.edit', 'Products', 'Edit a product', '2025-11-06 02:02:38', '2025-11-06 02:02:38'),
(50, 'View Product', 'action', 'admin.products.view', 'Products', 'View product details', '2025-11-06 02:02:38', '2025-11-06 02:02:38'),
(51, 'Approve Product', 'action', 'admin.products.approve', 'Products', 'Approve individual product', '2025-11-06 02:02:38', '2025-11-06 02:02:38'),
(52, 'Feature Product', 'action', 'admin.products.feature', 'Products', 'Feature individual product', '2025-11-06 02:02:38', '2025-11-06 02:02:38'),
(53, 'Delete Product', 'action', 'admin.products.delete', 'Products', 'Delete individual product', '2025-11-06 02:02:38', '2025-11-06 02:02:38'),
(54, 'Add Customer', 'action', 'admin.customers.create', 'Customers', 'Create new customer', '2025-11-06 23:45:28', '2025-11-06 23:45:28'),
(55, 'Bulk Delete', 'action', 'admin.customers.deleteselected', 'Customers', 'bulk delete customers', '2025-11-06 23:48:33', '2025-11-06 23:48:33'),
(56, 'Edit Customer', 'action', 'admin.customers.edit', 'Customers', 'edit customer', '2025-11-06 23:53:15', '2025-11-06 23:53:15'),
(57, 'View Customer', 'action', 'admin.customers.show', 'Customers', 'see customer', '2025-11-07 00:13:24', '2025-11-07 00:13:24'),
(58, 'Toggle Customer', 'action', 'admin.customers.toggle', 'Customers', 'active or inactive customer', '2025-11-07 00:24:01', '2025-11-07 00:24:01'),
(59, 'Bulk Delete', 'action', 'admin.reviews.deleteselected', 'Customers', 'bulk delete reviews', '2025-11-08 23:27:05', '2025-11-08 23:29:44'),
(60, 'Add Reviews', 'action', 'admin.reviews..create', 'Customers', 'custom create reviews', '2025-11-09 00:08:54', '2025-11-09 00:08:54'),
(61, 'Filter Reviews', 'action', 'admin.reviews.filter', 'Customers', 'filter customer\'s reviews', '2025-11-09 00:49:27', '2025-11-09 00:49:27'),
(62, 'Show Review', 'action', 'admin.reviews.show', 'Customers', 'show customer\'s review', '2025-11-09 00:51:15', '2025-11-09 00:51:15'),
(63, 'Filter Wishlists', 'action', 'admin.wishlists.filter', 'Customers', 'filter customers wishlists', '2025-11-09 02:56:47', '2025-11-09 02:56:47'),
(64, 'Show Wishlists', 'action', 'admin.wishlists.show', 'Customers', 'show customers wishlists', '2025-11-09 03:01:35', '2025-11-09 03:01:35'),
(65, 'Delete Wishlists', 'action', 'admin.wishlists.delete', 'Customers', 'delete customers wishlists', '2025-11-09 03:01:35', '2025-11-09 03:01:35'),
(66, 'Edit Order', 'action', 'admin.orders.edit', 'Orders', 'edit customers orders', '2025-11-09 06:00:37', '2025-11-09 06:00:37'),
(67, 'Delete Order', 'action', 'admin.orders.delete', 'Orders', 'delete customers orders', '2025-11-09 06:00:37', '2025-11-09 06:00:37'),
(68, 'Refund Process', 'action', 'admin.orders.refund', 'Orders', 'customers refund process', '2025-11-09 06:09:23', '2025-11-09 06:09:23'),
(69, 'Print Invoice', 'action', 'admin.orders.printInvoice', 'Orders', 'print orders invoice', '2025-11-09 06:09:23', '2025-11-09 06:18:34'),
(70, 'Send Mail', 'action', 'admin.orders.sendmail', 'Orders', 'send mail to customer', '2025-11-09 06:16:44', '2025-11-09 06:18:22'),
(71, 'Cancel Order', 'action', 'admin.orders.cancel', 'Orders', 'cancel order', '2025-11-09 06:16:44', '2025-11-09 06:16:44'),
(72, 'Cancellation Approval', 'action', 'admin.cancellations.approval', 'Orders', 'cancellation approval', '2025-11-09 06:30:59', '2025-11-09 06:30:59'),
(73, 'Return Process', 'action', 'admin.returns.process', 'Orders', 'return process', '2025-11-09 06:41:30', '2025-11-09 06:41:30'),
(74, 'Delete Return', 'action', 'admin.returns.delete', 'Orders', 'delete return request', '2025-11-09 06:41:30', '2025-11-09 06:41:30'),
(75, 'Create Return', 'action', 'admin.returns.create', 'Orders', 'create new return', '2025-11-09 06:43:39', '2025-11-09 06:43:39'),
(76, 'Create Order', 'action', 'admin.orders.create', 'Orders', 'create order', '2025-11-14 09:04:09', '2025-11-14 09:04:09');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_code` varchar(100) NOT NULL,
  `product_categories_id` bigint(20) UNSIGNED NOT NULL,
  `product_sub_categories_id` bigint(20) UNSIGNED NOT NULL,
  `brand_id` bigint(20) UNSIGNED DEFAULT NULL,
  `seller_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `auto_sku` tinyint(1) NOT NULL DEFAULT 0,
  `sku` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `brand_info` longtext DEFAULT NULL,
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
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `product_code`, `product_categories_id`, `product_sub_categories_id`, `brand_id`, `seller_id`, `name`, `slug`, `auto_sku`, `sku`, `description`, `brand_info`, `youtube_url`, `cancellation_policy`, `short_description`, `price`, `discount_price`, `commission_percent`, `stock`, `is_approved`, `approved_by`, `approved_at`, `featured`, `status`, `created_at`, `updated_at`) VALUES
(40, 'TEMP-40', 5, 173, NULL, 1, 'Hulk Kangaroo Pocket Cotton T-shirt', 'hulk-kangaroo-pocket-cotton-t-shirt-bjnHUD', 0, NULL, 'Get it in 2-3 daysUsually ships within a day\r\nEnter pincode to get accurate delivery date', NULL, NULL, NULL, NULL, 299.00, NULL, NULL, 0, 1, NULL, NULL, 0, 1, '2026-03-10 06:00:49', '2026-03-18 05:53:30'),
(41, 'TEMP-41', 5, 173, NULL, 2, 'Black Kids Cotton T Shirt ( Boys & Girls ) - Black Plain Unisex T-Shirts - 15 - 16Y', 'black-kids-cotton-t-shirt-boys-girls-black-plain-unisex-t-shirts-15-16y-fDaiVO', 0, NULL, 'Black Kids Cotton T Shirt ( Boys & Girls ) - Black Plain Unisex T-Shirts - 15 - 16Y', NULL, NULL, NULL, NULL, 500.00, NULL, NULL, 0, 0, NULL, NULL, 0, 1, '2026-03-10 10:29:50', '2026-03-18 05:53:30'),
(42, 'TEMP-42', 5, 173, NULL, 3, 'Buy Trending T-shirt for Boys | Stylish Tshirt for Kids, Boys', 'buy-trending-t-shirt-for-boys-stylish-tshirt-for-kids-boys-mR2RRS', 0, NULL, 'Buy Trending T-shirt for Boys | Stylish Tshirt for Kids, Boys', NULL, NULL, NULL, NULL, 900.00, NULL, NULL, 0, 0, NULL, NULL, 0, 1, '2026-03-10 11:23:48', '2026-03-18 05:53:30'),
(45, 'TEMP-45', 5, 173, NULL, 5, 'Boys White Glossy Branding T-shirt', 'boys-white-glossy-branding-t-shirt-pN3OmO', 0, NULL, 'Boys White Glossy Branding T-shirt', NULL, NULL, NULL, NULL, 1200.00, NULL, NULL, 0, 0, NULL, NULL, 0, 1, '2026-03-10 12:17:36', '2026-03-18 05:53:30'),
(46, 'TEMP-46', 5, 173, NULL, 6, 'FastColors-Full Sleeve-printed-t shirt for kids 10-11 YEARS', 'fastcolors-full-sleeve-printed-t-shirt-for-kids-10-11-years-tvVWX5', 0, NULL, 'FastColors-Full Sleeve-printed-t shirt for kids 10-11 YEARS.', NULL, NULL, NULL, NULL, 249.00, NULL, NULL, 0, 0, NULL, NULL, 0, 1, '2026-03-10 12:41:40', '2026-03-18 05:53:30'),
(47, 'TEMP-47', 5, 173, NULL, 3, 'Testing Variant Image Flow', 'testing-variant-image-flow-AfWJOL', 0, NULL, 'If you are going to use a passage of Lorem Ipsum, you need to be sure there isn\'t anything embarrassing hidden in the middle of text.', NULL, NULL, NULL, NULL, 300.00, NULL, NULL, 0, 0, NULL, NULL, 0, 1, '2026-03-11 09:26:30', '2026-03-18 05:53:30'),
(49, 'TEMP-49', 5, 173, NULL, 2, 'Testing Variant Image Flow 2', 'testing-variant-image-flow-2-AuKTY8', 0, NULL, 'If you are going to use a passage of Lorem Ipsum, you need to be sure there isn\'t anything embarrassing hidden in the middle of text.', NULL, NULL, NULL, NULL, 400.00, NULL, NULL, 0, 0, NULL, NULL, 0, 1, '2026-03-11 09:34:19', '2026-03-18 05:53:30'),
(50, 'TEMP-50', 5, 173, NULL, 6, 'Testing Variant Image Flow 3', 'testing-variant-image-flow-3-5oFxnu', 0, NULL, 'If you are going to use a passage of Lorem Ipsum, you need to be sure there isn\'t anything embarrassing hidden in the middle of text.', NULL, NULL, NULL, NULL, 400.00, NULL, NULL, 0, 0, NULL, NULL, 0, 1, '2026-03-11 09:46:13', '2026-03-18 05:53:30'),
(51, 'TEMP-51', 5, 211, NULL, 3, 'Hardcore Testing going on', 'hardcore-testing-going-on-1qtPCL', 0, NULL, 'this is a testing phase only , don\'t get offended or exited , we will let you know when it\'s ready.', NULL, NULL, NULL, NULL, 600.00, NULL, NULL, 0, 0, NULL, NULL, 0, 1, '2026-03-13 07:38:22', '2026-03-18 05:53:30'),
(52, 'TEMP-52', 5, 211, NULL, 3, 'Hardcore Testing going on', 'hardcore-testing-going-on-MK6uIc', 0, NULL, 'fverg', NULL, NULL, NULL, NULL, 600.00, NULL, NULL, 0, 0, NULL, NULL, 0, 1, '2026-03-13 07:41:25', '2026-03-18 05:53:30'),
(53, 'TEMP-53', 5, 211, NULL, 1, 'Gaming Chair', 'gaming-chair-g6HMBX', 0, NULL, 'uil,uikyiuk', NULL, NULL, NULL, NULL, 12000.00, NULL, NULL, 0, 0, NULL, NULL, 0, 1, '2026-03-13 12:46:59', '2026-03-18 05:53:30'),
(54, 'TEMP-54', 5, 211, NULL, 3, 'Delostyle Studio', 'delostyle-studio-rT0SWs', 0, NULL, '67jtyjhtyrj', NULL, NULL, NULL, NULL, 5725.00, NULL, NULL, 0, 0, NULL, NULL, 0, 1, '2026-03-13 12:54:29', '2026-03-18 05:53:30'),
(55, 'TEMP-55', 5, 213, NULL, 1, 'testing variant flow', 'testing-variant-flow-EHdZqR', 0, NULL, 'sssss', NULL, NULL, NULL, NULL, 1400.00, NULL, NULL, 0, 0, NULL, NULL, 0, 1, '2026-03-17 07:13:40', '2026-03-18 05:53:30'),
(56, 'TEMP-56', 5, 211, NULL, 3, 'Testing Create Flow', 'testing-create-flow-76DWw4', 0, NULL, 'testing Testing Create Flow', NULL, NULL, NULL, NULL, 500.00, NULL, NULL, 0, 0, NULL, NULL, 0, 1, '2026-03-17 11:14:29', '2026-03-18 05:53:30'),
(57, 'TEMP-57', 5, 211, NULL, 5, 'Last testing going', 'last-testing-going-SYdut1', 0, NULL, 'last', NULL, NULL, NULL, NULL, 1100.00, NULL, NULL, 0, 0, NULL, NULL, 0, 1, '2026-03-17 11:25:02', '2026-03-18 05:53:30'),
(58, 'TEMP-58', 11, 183, NULL, 1, 'Fast Colors-Full Sleeve-printed-t shirt for kids 10-11 YEARS', 'fast-colors-full-sleeve-printed-t-shirt-for-kids-10-11-years-Gh9yE5', 0, NULL, 'hiijinjuii', NULL, NULL, NULL, NULL, 1200.00, NULL, NULL, 400, 0, NULL, NULL, 0, 1, '2026-03-17 11:29:59', '2026-03-18 05:53:30');

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
(869, 51, 426),
(870, 51, 430),
(872, 51, 432),
(871, 51, 438),
(873, 51, 446),
(874, 51, 449),
(875, 51, 452),
(876, 51, 454),
(877, 51, 455),
(878, 51, 457),
(837, 52, 423),
(838, 52, 426),
(839, 52, 430),
(841, 52, 432),
(840, 52, 439),
(842, 52, 446),
(843, 52, 449),
(844, 52, 452),
(845, 52, 454),
(846, 52, 455),
(847, 52, 457),
(848, 52, 458),
(888, 53, 427),
(889, 53, 428),
(891, 53, 432),
(890, 53, 439),
(892, 53, 447),
(893, 53, 449),
(894, 53, 454),
(895, 53, 457),
(896, 53, 458),
(903, 54, 427),
(904, 54, 432),
(905, 54, 445),
(906, 54, 450),
(907, 54, 455),
(908, 54, 458),
(942, 55, 422),
(943, 55, 424),
(944, 55, 427),
(947, 55, 432),
(945, 55, 440),
(946, 55, 441),
(948, 55, 449),
(949, 55, 450),
(950, 55, 454),
(951, 55, 457),
(952, 55, 458),
(953, 56, 425),
(954, 56, 428),
(960, 56, 432),
(955, 56, 435),
(956, 56, 436),
(957, 56, 437),
(958, 56, 438),
(959, 56, 439),
(961, 56, 449),
(962, 56, 450),
(963, 56, 454),
(964, 56, 455),
(965, 56, 457),
(966, 56, 458),
(967, 57, 422),
(969, 57, 434),
(968, 57, 435),
(970, 57, 448),
(971, 57, 453),
(972, 57, 456),
(973, 57, 459),
(976, 58, 330),
(977, 58, 336);

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
(15, 51, 426, 'products/variants/2026/03/WcNpSSyNpV1HnwXoshpCn0cnaBRGD1W9mStlBPN2.jpg', 1, 0, '2026-03-13 07:38:22', '2026-03-13 07:38:22'),
(16, 51, 426, 'products/variants/2026/03/gcnQlu3eDjiOuRDorKDwK2CTGUGcgn63Nchd6mOB.jpg', 0, 1, '2026-03-13 07:38:22', '2026-03-13 07:38:22'),
(18, 51, 430, 'products/variants/2026/03/t7daLwCTP6KYnRCAadfSocOa32JVehIeEWPEPYGE.jpg', 1, 0, '2026-03-13 07:38:22', '2026-03-13 07:38:22'),
(19, 51, 430, 'products/variants/2026/03/bvBek9otICp5T5Ud5WHvF1sdeYaSFKBYPIZKDLma.jpg', 0, 1, '2026-03-13 07:38:22', '2026-03-13 07:38:22'),
(20, 51, 430, 'products/variants/2026/03/lbEGTT1qNpbmSfEPMPHWo2VbUa6DTENAublJGm4U.jpg', 0, 2, '2026-03-13 07:38:22', '2026-03-13 07:38:22'),
(21, 52, 423, 'products/variants/2026/03/uxNUn8BEebUwoOQty72xQ6FdGo67IzNN2RxBBkcD.jpg', 1, 0, '2026-03-13 07:41:25', '2026-03-13 07:41:25'),
(22, 52, 423, 'products/variants/2026/03/jFnnCXnFTTBZi7fa9QMmoXm6f7I1e9SzW2hCHw8m.jpg', 0, 1, '2026-03-13 07:41:25', '2026-03-13 07:41:25'),
(23, 52, 423, 'products/variants/2026/03/2qsQsQlr8UVCflhjdzAfklsxfwHR7Srqi3RXzvfj.jpg', 0, 2, '2026-03-13 07:41:25', '2026-03-13 07:41:25'),
(24, 52, 430, 'products/variants/2026/03/Ld76TTf2Y02aJrj8eopRrzzRDx9AQSa6xxFw7ETb.jpg', 1, 0, '2026-03-13 07:41:25', '2026-03-13 07:41:25'),
(25, 52, 430, 'products/variants/2026/03/xj9hB5pnQ0FJ0so7gzu0lofAPyv6qE8UHBHz6COi.jpg', 0, 1, '2026-03-13 07:41:25', '2026-03-13 07:41:25'),
(26, 52, 430, 'products/variants/2026/03/Z3lqKoQ9QRREzq7kfNL1avRJsb3nsOU92ADmjRsS.jpg', 0, 2, '2026-03-13 07:41:25', '2026-03-13 07:41:25'),
(27, 52, 426, 'products/variants/2026/03/tXFE5k8EgaR1t9Vh9sljrYej9VPDpJhnMWLI7hGA.jpg', 1, 1, '2026-03-13 07:43:07', '2026-03-13 07:43:07'),
(28, 52, 426, 'products/variants/2026/03/x3QrRE24jGQb9PvWSo1HLaXC1OZ3Ar6HyIKMqFei.jpg', 0, 2, '2026-03-13 07:43:07', '2026-03-13 07:43:07'),
(29, 52, 426, 'products/variants/2026/03/ktb0HFHEBbyp0WzRA6HCUFErZ0VAE5dDyUhkBFbs.jpg', 0, 3, '2026-03-13 07:43:07', '2026-03-13 07:43:07'),
(31, 51, 426, 'products/variants/2026/03/NjAV3qtIIhfeSMbDTtjy2BwSUAS3o4bM3x7BQpFn.jpg', 0, 3, '2026-03-13 08:01:44', '2026-03-13 08:01:44'),
(32, 53, 427, 'products/variants/2026/03/et3MV9u8CdPz1OtWVGX0qVA7BlqFqjs99Kt9tgDQ.jpg', 1, 0, '2026-03-13 12:46:59', '2026-03-13 12:46:59'),
(33, 53, 427, 'products/variants/2026/03/YCHTJGmgx56eruKkV0Ld8T6QBxSvfttEMxB9Tzmy.jpg', 0, 1, '2026-03-13 12:46:59', '2026-03-13 12:46:59'),
(34, 53, 428, 'products/variants/2026/03/BVhlUZdnRedQ2UcU8EdvYwPn6bbn3blFPomSCF77.jpg', 1, 0, '2026-03-13 12:46:59', '2026-03-13 12:46:59'),
(35, 53, 428, 'products/variants/2026/03/dkkJxncmutnMqftDQGoUANwh1tgtGEtJrC3TbmWz.jpg', 0, 1, '2026-03-13 12:46:59', '2026-03-13 12:46:59'),
(36, 53, 427, 'products/variants/2026/03/5aEnCXWivRmrHsXthcR3TVnaWEgKzN6JZpGUL2LF.jpg', 0, 2, '2026-03-13 12:49:25', '2026-03-13 12:49:25'),
(37, 53, 428, 'products/variants/2026/03/8OgaDqmJyQM4Y3ChsGR08xfkD0eI0ikE0lkbZFSC.jpg', 0, 2, '2026-03-13 12:49:25', '2026-03-13 12:49:25'),
(38, 54, 427, 'products/variants/2026/03/KFfSjlLyfhpTY9xzAMRHbUFLmM2WLa2oWZA6Nu4x.jpg', 1, 0, '2026-03-13 12:54:29', '2026-03-13 12:54:29'),
(39, 54, 427, 'products/variants/2026/03/XEP0fjpqSaokk36HCQ3tFdCzTwRL1eSuUMxCpAxa.jpg', 0, 1, '2026-03-16 06:42:34', '2026-03-16 06:42:34'),
(40, 55, 422, 'products/variants/2026/03/TXbaFLZ4xx6SAZM9X2MrWI5wDRrVTAkrHgysz5Nd.jpg', 1, 0, '2026-03-17 07:13:40', '2026-03-17 07:13:40'),
(41, 55, 424, 'products/variants/2026/03/ql5mVnxDMIr0tb6cyz0ftaCpAMPnZHQJW3DzHjlg.jpg', 1, 0, '2026-03-17 07:13:40', '2026-03-17 07:13:40'),
(42, 55, 427, 'products/variants/2026/03/zEt0UkB7DBv7iL89dESkKYPU5GcpqA7pX6x82osM.jpg', 1, 0, '2026-03-17 07:13:40', '2026-03-17 07:13:40'),
(43, 55, 422, 'products/variants/2026/03/9lobTyamuaM2QphXtZTtTH4sI6mWOFrlUdO6R7LZ.jpg', 0, 1, '2026-03-17 07:31:15', '2026-03-17 07:31:15'),
(44, 56, 425, 'products/variants/2026/03/kIrWAklunC8uuIBjsqZXO1jBCL0lVljJc0ucbP6H.png', 1, 0, '2026-03-17 11:14:29', '2026-03-17 11:14:29'),
(45, 56, 425, 'products/variants/2026/03/qthPh4YUi9Rqyg7ZNCtwKXvznnkhz2IHsLkeemTs.png', 0, 1, '2026-03-17 11:14:29', '2026-03-17 11:14:29'),
(46, 56, 428, 'products/variants/2026/03/N9Pr609m1E8bINpCDOcLanj7x3ER3rBiA00kyQTI.jpg', 1, 0, '2026-03-17 11:14:29', '2026-03-17 11:14:29'),
(47, 56, 428, 'products/variants/2026/03/rB0GDSfNbqvWIUVzl1ySbJ2ePPZ6ZUvhu3ReXS67.jpg', 0, 1, '2026-03-17 11:14:29', '2026-03-17 11:14:29'),
(48, 57, 422, 'products/variants/2026/03/NzGF8rt2QB5m4G7etLc4MSduDWwYF3xcpHFixAjc.png', 1, 0, '2026-03-17 11:25:02', '2026-03-17 11:25:02');

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
(2, 'Bath & Skin Care', 'bath-skin-care', 1),
(3, 'Birthday Products & Gifts', 'birthday-products-gifts', 1),
(4, 'Books & CDs / Learning Materials', 'books-learning-materials', 1),
(5, 'Clothes & Shoes', 'clothes-shoes', 1),
(6, 'Diapering', 'diapering', 1),
(7, 'Fashion Accessories', 'fashion-accessories', 1),
(8, 'Feeding & Nursing', 'feeding-nursing', 1),
(9, 'Health & Safety', 'health-safety', 1),
(10, 'Moms & Maternity', 'moms-maternity', 1),
(11, 'Toys & Gaming', 'toys-gaming', 1),
(16, 'Baby Food', 'baby-food', 1),
(17, 'fashion', 'fashion', 1);

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
(5, 1, 5, 0, 0),
(8, 2, 18, 0, 0),
(12, 3, 5, 0, 0),
(15, 4, 16, 0, 0),
(16, 4, 17, 0, 0),
(27, 6, 12, 0, 0),
(34, 7, 5, 0, 0),
(36, 8, 11, 0, 0),
(37, 8, 5, 0, 0),
(44, 10, 5, 0, 0),
(72, 16, 41, 0, 0),
(121, 11, 90, 0, 0),
(122, 11, 91, 0, 0),
(139, 5, 108, 0, 0),
(140, 5, 109, 0, 0),
(141, 5, 110, 0, 0),
(142, 5, 111, 0, 0),
(143, 5, 112, 0, 0),
(144, 5, 113, 0, 0),
(145, 5, 114, 0, 0);

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_category_section`
--

INSERT INTO `product_category_section` (`id`, `product_id`, `master_category_section_id`, `created_at`, `updated_at`) VALUES
(9, 40, 2, NULL, NULL),
(10, 40, 4, NULL, NULL),
(22, 41, 3, NULL, NULL),
(23, 41, 4, NULL, NULL),
(24, 42, 2, NULL, NULL),
(46, 45, 2, NULL, NULL),
(75, 46, 2, NULL, NULL),
(76, 46, 105, NULL, NULL),
(77, 47, 3, NULL, NULL),
(78, 49, 2, NULL, NULL),
(93, 50, 2, NULL, NULL),
(94, 50, 105, NULL, NULL),
(98, 52, 2, NULL, NULL),
(99, 52, 105, NULL, NULL),
(102, 51, 2, NULL, NULL),
(104, 53, 2, NULL, NULL),
(106, 54, 5, NULL, NULL),
(110, 55, 3, NULL, NULL),
(111, 56, 3, NULL, NULL),
(112, 56, 4, NULL, NULL),
(113, 56, 5, NULL, NULL),
(114, 56, 6, NULL, NULL),
(115, 56, 7, NULL, NULL),
(116, 57, 15, NULL, NULL),
(117, 57, 19, NULL, NULL),
(119, 58, 247, NULL, NULL);

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_images`
--

INSERT INTO `product_images` (`id`, `product_id`, `image_path`, `is_primary`, `created_at`, `updated_at`) VALUES
(1, 40, 'products/2026/03/9O8Y5oL1fCrsHdyRH3DdbOWN435B4WCpCizP6hBr.jpg', 1, '2026-03-10 06:00:49', '2026-03-10 10:23:00'),
(2, 40, 'products/2026/03/erEvnnPar6TE0K7c4kG0QQTu9XOg9GFk00LxgcIp.jpg', 0, '2026-03-10 06:00:49', '2026-03-10 10:23:00'),
(5, 40, 'products/2026/03/1BgHm8woexC2epwYP5jwG3vYZQtVUzcZj1YC3qIH.jpg', 0, '2026-03-10 09:54:58', '2026-03-10 10:23:00'),
(6, 40, 'products/2026/03/Slr6jHIbGRkJ3pJdH7WzcLA6dSDFMvsbnsdPhURK.jpg', 0, '2026-03-10 10:23:00', '2026-03-10 10:23:00'),
(7, 41, 'products/2026/03/Lv8Mq2cW7aPEsJSddaQCG2L0tLedfd4badz1LNwi.jpg', 1, '2026-03-10 10:29:50', '2026-03-10 11:20:34'),
(8, 41, 'products/2026/03/CcXRtC1Z30v8SBl86PyIymbCHU9FCjV5a4AzGHuK.jpg', 0, '2026-03-10 10:29:50', '2026-03-10 11:20:34'),
(9, 41, 'products/2026/03/RWWqTomAqc1fpZm5EJmsenwWCSRuBGcc9jn1xG5b.jpg', 0, '2026-03-10 10:29:50', '2026-03-10 11:20:34'),
(10, 41, 'products/2026/03/NWaTsWzf0rD7E7HIFbcyHUQPT452oOslpweklg4O.jpg', 0, '2026-03-10 10:50:31', '2026-03-10 11:20:34'),
(11, 42, 'products/2026/03/Dq4IZxiXpso0U2JWGNFFP8ERYFTfRpuMCsWfswML.jpg', 1, '2026-03-10 11:23:48', '2026-03-10 11:23:48'),
(12, 42, 'products/2026/03/SaFdqbQmdunz31VbWPxm0TXVBjmjXNJsJvELGt1X.jpg', 0, '2026-03-10 11:23:48', '2026-03-10 11:23:48'),
(13, 42, 'products/2026/03/4pZIxnNaMmCiFnzwenP9TuZuEQqBTCOjU2s22Pwa.jpg', 0, '2026-03-10 11:23:48', '2026-03-10 11:23:48'),
(14, 45, 'products/2026/03/RCqtbQ8JJXKsjir8ZC1hXJQ4Fi4KswVQFGEZXfEg.jpg', 1, '2026-03-10 12:17:36', '2026-03-11 05:22:44'),
(15, 45, 'products/2026/03/jKkifZ06VujBuqY3955RHvKrbjxRe53lbplbHNMf.jpg', 0, '2026-03-10 12:17:36', '2026-03-11 05:22:44'),
(16, 45, 'products/2026/03/GpyLnCUsRMcMmJIH60N3D4VFWqFu5Yf8yQnPeDXr.jpg', 0, '2026-03-10 12:17:36', '2026-03-11 05:22:44'),
(17, 46, 'products/2026/03/hUbu7KLUWyVJ9pExmg3f3mdg28ThYfYRqAVcRo9C.jpg', 1, '2026-03-10 12:41:40', '2026-03-11 06:59:31'),
(18, 46, 'products/2026/03/hBRAfjmI19RPWyPsiFHagAlriJuKIB4vhrDHng5m.jpg', 0, '2026-03-10 12:41:40', '2026-03-11 06:59:31'),
(19, 46, 'products/2026/03/4amnHHOb2Pv7ySLBDL5PUS2T94Ip4JHXj20zpraC.jpg', 0, '2026-03-10 12:41:40', '2026-03-11 06:59:31'),
(20, 47, 'products/2026/03/EqEeDnxRInhmQ69YbUKPWNBO73eD7ZiV8fiYXSJQ.jpg', 1, '2026-03-11 09:26:30', '2026-03-11 09:26:30'),
(21, 47, 'products/2026/03/FnEs7ZefMyANbp4504MxGGRTViOISNtnCw9qd9Hf.jpg', 0, '2026-03-11 09:26:30', '2026-03-11 09:26:30'),
(22, 47, 'products/2026/03/LYOaGTX6M3wrWopUZa9HEid2nOcmP5ejGjafl5yt.jpg', 0, '2026-03-11 09:26:30', '2026-03-11 09:26:30'),
(23, 49, 'products/2026/03/DLb9RroHrptNQonyckfnBYtmBGcZnogMrfxIuDLZ.jpg', 1, '2026-03-11 09:34:19', '2026-03-11 09:34:19'),
(24, 49, 'products/2026/03/5RPgU3cHqaJsQZy34a57Xy2HYfeUHA8tCrcsHd6B.jpg', 0, '2026-03-11 09:34:19', '2026-03-11 09:34:19'),
(25, 49, 'products/2026/03/5tu7nNoB5vzogxMRTFGcyuOGGjtl5hNLFxRDPyEB.jpg', 0, '2026-03-11 09:34:19', '2026-03-11 09:34:19'),
(29, 50, 'products/2026/03/kUhPFc9zxONmqg7o3mvmF2lwgJU7KtDVYe2fKGY5.jpg', 1, '2026-03-12 06:02:31', '2026-03-13 06:58:34'),
(30, 50, 'products/2026/03/AirZ6aonmVT07awd7rtfKtTnloin32LM7rByvs1r.jpg', 0, '2026-03-12 06:02:31', '2026-03-13 06:58:34'),
(31, 50, 'products/2026/03/lpDhS9t5Av5TChM0kuzOHT1clCF2FFQy2z2CswLr.jpg', 0, '2026-03-12 06:02:31', '2026-03-13 06:58:34'),
(32, 50, 'products/2026/03/Rp2VwUCBnBWagwh12N1sBPpRhIUXInFCbDE84ibT.jpg', 0, '2026-03-12 06:02:31', '2026-03-13 06:58:34'),
(33, 50, 'products/2026/03/PEMF5Vggkcq0N1oIRdFvXVZsGkwZUi3t8SJhZzi2.jpg', 0, '2026-03-12 06:02:31', '2026-03-13 06:58:34'),
(34, 51, 'products/2026/03/zfG2yYbeDJTg1knOtz5nddZ4dWYkbQk6LB1c9cyg.jpg', 1, '2026-03-13 07:38:22', '2026-03-13 10:20:47'),
(35, 51, 'products/2026/03/F6h01OIf5awEX0YJYKJPViyaEJcyJIdc0wgBSvjv.jpg', 0, '2026-03-13 07:38:22', '2026-03-13 10:20:47'),
(36, 51, 'products/2026/03/5FU7eyNJwvdJi2TdP5Tz2AnrksxtdLC4xXkOjUdf.jpg', 0, '2026-03-13 07:38:22', '2026-03-13 10:20:47'),
(37, 52, 'products/2026/03/95XQiVVJxDvYobj8WfyV1mSyrQLnFsuUkk9S8H9m.jpg', 1, '2026-03-13 07:41:25', '2026-03-13 07:43:07'),
(38, 52, 'products/2026/03/6eTsBhf83a0TaxgKZnwTjNDs7DXfXEmKWVwoaIyu.jpg', 0, '2026-03-13 07:41:25', '2026-03-13 07:43:07'),
(39, 52, 'products/2026/03/UapEWx4HJDXOxcrMA16AoT9c6GVTPrhOyslFGFve.jpg', 0, '2026-03-13 07:41:25', '2026-03-13 07:43:07'),
(40, 53, 'products/2026/03/Jjs0h83dpPk10xknpervbwgrh3kNHEJpsk0iRbG3.jpg', 1, '2026-03-13 12:46:59', '2026-03-13 12:49:25'),
(41, 53, 'products/2026/03/DSc2YzFdISZg3JXYdKs2QNFXnoBZrrzhrsllzQ3m.jpg', 0, '2026-03-13 12:46:59', '2026-03-13 12:49:25'),
(42, 53, 'products/2026/03/cO3UbyXbZ67X7R5ZFL6dciwcUwDsVLOw5NyB1VoO.jpg', 0, '2026-03-13 12:46:59', '2026-03-13 12:49:25'),
(43, 54, 'products/2026/03/7IrIpIK4XVTAN0zGmJ6Zfv9gqygrRSl8KhnTL2rZ.jpg', 1, '2026-03-13 12:54:29', '2026-03-16 06:42:34'),
(44, 54, 'products/2026/03/6ab2wdpyy0eQ67CkQ4RF2u44YHMifZenusJBNkQ6.jpg', 0, '2026-03-13 12:54:29', '2026-03-16 06:42:34'),
(45, 54, 'products/2026/03/PCPE65qEKvUaev0Hy16XZyo8EVTtExHL7xEEiixN.jpg', 0, '2026-03-13 12:54:29', '2026-03-16 06:42:34'),
(46, 55, 'products/2026/03/6o2BYQ6jgZ10MPsHg7PtwBxWMBhEDv6x6iannheG.jpg', 1, '2026-03-17 07:13:40', '2026-03-17 09:19:28'),
(47, 55, 'products/2026/03/y3uAJD8FvMyNm7vNuRJBozZam2HHanPGUpEmRGD6.png', 0, '2026-03-17 07:13:40', '2026-03-17 09:19:28'),
(48, 55, 'products/2026/03/rPrCLd8ashqhTucHBFNdzpdRNv0DuUV0b8NwS6n9.jpg', 0, '2026-03-17 07:13:40', '2026-03-17 09:19:28'),
(49, 56, 'products/2026/03/c8EhpX23qyhZ8hKQsKT4a9tEKWmquXP7NSxdxfM8.jpg', 1, '2026-03-17 11:14:29', '2026-03-17 11:14:29'),
(50, 56, 'products/2026/03/SOYYukqeY0q0brvj2gM7HcxhP65IFHWlONR7zPTR.jpg', 0, '2026-03-17 11:14:29', '2026-03-17 11:14:29'),
(51, 56, 'products/2026/03/elZF93dExeuuj7J9reBqLqGPI0g4q4xortgtiYab.jpg', 0, '2026-03-17 11:14:29', '2026-03-17 11:14:29'),
(52, 57, 'products/2026/03/cqUX9FLkyGetJJKLsLf7wsjk6TKxc4qC74xjswd0.png', 1, '2026-03-17 11:25:02', '2026-03-17 11:25:02'),
(53, 57, 'products/2026/03/ngVxbVuWAVIAqSGsRka3MBD2sxpm4pKEUpd0ySal.jpg', 0, '2026-03-17 11:25:02', '2026-03-17 11:25:02'),
(54, 57, 'products/2026/03/pmyAdk4zLLJQLeIkPpmBG9JFo7MxzvYKImwHGaN7.png', 0, '2026-03-17 11:25:02', '2026-03-17 11:25:02'),
(55, 58, 'products/2026/03/45kTD8M1geW725lxBWXm3UBCcVZGUAaLsOPaRsoA.jpg', 1, '2026-03-17 11:29:59', '2026-03-17 11:30:31'),
(56, 58, 'products/2026/03/WMNwgW3HaBXYZ2mG9dUUmXQdF5lXzMY7Gi2cq8Na.jpg', 0, '2026-03-17 11:29:59', '2026-03-17 11:30:31'),
(57, 58, 'products/2026/03/5G3CfDAgiUZHT0fXZTeXDjLuPXXVnseOMQ9vfl1f.jpg', 0, '2026-03-17 11:29:59', '2026-03-17 11:30:31');

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
(10, 2, 'Baby Soaps', 'baby-soaps', 1),
(11, 2, 'Baby Shampoos', 'baby-shampoos', 1),
(12, 2, 'Baby Lotions & Creams', 'baby-lotions-creams', 1),
(13, 2, 'Baby Oils', 'baby-oils', 1),
(14, 2, 'Baby Powders', 'baby-powders', 1),
(15, 2, 'Bath Tubs & Accessories', 'bath-tubs-accessories', 1),
(16, 2, 'Towels & Bath Robes', 'towels-bath-robes', 1),
(17, 2, 'Baby Grooming Kits', 'baby-grooming-kits', 1),
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
(54, 8, 'Feeding Bottles', 'feeding-bottles', 1),
(55, 8, 'Sippy Cups', 'sippy-cups', 1),
(56, 8, 'Bibs', 'bibs', 1),
(57, 8, 'Bottle Sterilizers', 'bottle-sterilizers', 1),
(58, 8, 'Breast Pumps', 'breast-pumps', 1),
(59, 8, 'Nursing Pads', 'nursing-pads', 1),
(60, 8, 'High Chairs', 'feeding-high-chairs', 1),
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
(211, 5, 'T-Shirts & Shirts', 't-shirts-shirts-69b3bc341980b', 1),
(212, 5, 'Dresses & Frocks', 'dresses-frocks-69b3bc3419f3f', 1),
(213, 5, 'Top & Bottom Sets', 'top-bottom-sets-69b3bc341a0ca', 1),
(214, 5, 'Ethnic Wear', 'ethnic-wear-69b3bc341a203', 1),
(215, 5, 'Nightwear & Sleepsuits', 'nightwear-sleepsuits-69b3bc341a307', 1),
(216, 5, 'Winter Wear', 'winter-wear-69b3bc341a3f5', 1),
(217, 5, 'Innerwear & Thermals', 'innerwear-thermals-69b3bc341a4dd', 1),
(218, 5, 'Shoes & Sneakers', 'shoes-sneakers-69b3bc341a5c2', 1),
(219, 5, 'Sandals & Slippers', 'sandals-slippers-69b3bc341a6a7', 1),
(220, 5, 'Boots', 'boots-69b3bc341a7c1', 1);

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
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_variants`
--

INSERT INTO `product_variants` (`id`, `product_id`, `sku`, `price`, `compare_price`, `stock`, `weight`, `status`, `created_at`, `updated_at`) VALUES
(18, 46, 'FSSFK1Y-BLA-S', 249.00, NULL, 25, NULL, 1, '2026-03-11 06:36:47', '2026-03-11 06:36:47'),
(19, 46, 'FSSFK1Y-BLA-L', 249.00, NULL, 26, NULL, 1, '2026-03-11 06:36:47', '2026-03-11 06:36:47'),
(20, 46, 'FSSFK1Y-WHI-S', 249.00, NULL, 27, NULL, 1, '2026-03-11 06:36:47', '2026-03-11 06:36:47'),
(22, 47, 'TVIF-BLA-23Y', 300.00, NULL, 250, NULL, 1, '2026-03-11 09:26:30', '2026-03-11 09:26:30'),
(23, 47, 'TVIF-WHI-23Y', 300.00, NULL, 220, NULL, 1, '2026-03-11 09:26:30', '2026-03-11 09:26:30'),
(26, 49, 'TVIF2-RED', 400.00, NULL, 12, NULL, 1, '2026-03-11 09:34:19', '2026-03-11 09:34:19'),
(27, 49, 'TVIF2-PUR', 400.00, NULL, 10, NULL, 1, '2026-03-11 09:34:19', '2026-03-11 09:34:19'),
(28, 50, 'TVIF3-YEL', 401.00, NULL, 18, NULL, 1, '2026-03-11 09:46:13', '2026-03-12 06:02:31'),
(29, 50, 'TVIF3-PIN', 402.00, NULL, 19, NULL, 1, '2026-03-11 09:46:13', '2026-03-12 06:02:31'),
(30, 50, 'TVIF3-RED', 403.00, NULL, 20, NULL, 1, '2026-03-13 06:58:34', '2026-03-13 06:58:34'),
(31, 50, 'TVIF3-RED-S', 404.00, NULL, 21, NULL, 1, '2026-03-13 06:58:34', '2026-03-13 06:58:34'),
(32, 51, 'HTGO-BLA-12Y', 600.00, NULL, 99, NULL, 1, '2026-03-13 07:38:22', '2026-03-13 07:38:22'),
(33, 51, 'HTGO-ORA-12Y', 600.00, NULL, 199, NULL, 1, '2026-03-13 07:38:22', '2026-03-13 07:38:22'),
(34, 52, 'HTGO-BLU-23Y', 610.00, NULL, 99, NULL, 1, '2026-03-13 07:41:25', '2026-03-13 07:41:25'),
(35, 52, 'HTGO-ORA-23Y', 620.00, NULL, 199, NULL, 1, '2026-03-13 07:41:25', '2026-03-13 07:41:25'),
(36, 52, 'HTGO-BLA-23Y', 630.00, NULL, 200, NULL, 1, '2026-03-13 07:43:07', '2026-03-13 07:43:07'),
(37, 53, 'GC-WHI-23Y', 12000.00, NULL, 0, NULL, 1, '2026-03-13 12:46:59', '2026-03-13 12:46:59'),
(38, 53, 'GC-PIN-23Y', 12000.00, NULL, 0, NULL, 1, '2026-03-13 12:46:59', '2026-03-13 12:46:59'),
(39, 54, 'DS-WHI', 5725.00, NULL, 10, NULL, 1, '2026-03-13 12:54:29', '2026-03-13 12:54:29'),
(40, 55, 'TVF-RED-S', 1400.00, NULL, 12, NULL, 1, '2026-03-17 07:13:40', '2026-03-17 07:13:40'),
(41, 55, 'TVF-GRE-S', 1401.00, NULL, 14, NULL, 1, '2026-03-17 07:13:40', '2026-03-17 10:32:07'),
(42, 55, 'TVF-GRE-M', 1402.00, NULL, 15, NULL, 1, '2026-03-17 07:13:40', '2026-03-17 10:32:14'),
(43, 55, 'TVF-WHI-M', 1403.00, NULL, 17, NULL, 1, '2026-03-17 07:13:40', '2026-03-17 10:32:19'),
(46, 56, 'TCF-YEL-12Y', 500.00, NULL, 4, NULL, 1, '2026-03-17 11:14:29', '2026-03-17 11:14:29'),
(47, 56, 'TCF-YEL-23Y', 500.00, NULL, 5, NULL, 1, '2026-03-17 11:14:29', '2026-03-17 11:14:29'),
(48, 56, 'TCF-PIN-03M', 500.00, NULL, 6, NULL, 1, '2026-03-17 11:14:29', '2026-03-17 11:14:29'),
(49, 56, 'TCF-PIN-36M', 500.00, NULL, 7, NULL, 1, '2026-03-17 11:14:29', '2026-03-17 11:14:29'),
(50, 56, 'TCF-PIN-612', 500.00, NULL, 8, NULL, 1, '2026-03-17 11:14:29', '2026-03-17 11:14:29'),
(51, 56, 'TCF-PIN-12Y', 500.00, NULL, 9, NULL, 1, '2026-03-17 11:14:29', '2026-03-17 11:14:29'),
(52, 56, 'TCF-PIN-23Y', 500.00, NULL, 10, NULL, 1, '2026-03-17 11:14:29', '2026-03-17 11:14:29'),
(53, 57, 'LTG-RED-03M', 1100.00, NULL, 110, NULL, 1, '2026-03-17 11:25:02', '2026-03-17 11:25:02');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `returns`
--

CREATE TABLE `returns` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `return_number` varchar(50) NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `order_item_id` bigint(20) UNSIGNED DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `reason` text DEFAULT NULL,
  `status` enum('requested','approved','rejected','received','refunded') DEFAULT 'requested',
  `refund_amount` decimal(10,2) DEFAULT NULL,
  `razorpay_refund_id` varchar(100) DEFAULT NULL,
  `refund_status` enum('pending','processing','paid','failed') DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `product_id`, `user_id`, `rating`, `comment`, `created_at`, `updated_at`) VALUES
(4, 20, 19, 4.0, 'Lorem Ipsum is simply dummy text of the printing and typesetting industry.', '2025-09-24 09:54:38', '2025-09-24 09:54:38');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `slug`, `description`, `created_at`, `updated_at`) VALUES
(5, 'Super Admin', 'super-admin', 'Full system access, can manage all modules and settings.', '2025-10-30 09:08:30', '2025-10-30 09:08:30'),
(6, 'Admin', 'admin', 'General administrative privileges except system-level settings.', '2025-10-30 09:08:30', '2025-10-30 09:08:30'),
(7, 'Support Staff', 'support', 'Handles customer support, orders, and returns.', '2025-10-30 09:08:30', '2025-10-30 09:08:30'),
(8, 'Inventory Manager', 'inventory-manager', 'Manages stock, warehouses, and inventory adjustments.', '2025-10-30 09:08:30', '2025-10-30 09:08:30'),
(10, 'Accountant', 'accountant', 'Manages transactions, settlements, and refunds.', '2025-10-30 09:08:30', '2025-10-30 09:08:30'),
(11, 'Marketing Manager', 'marketing-manager', 'Handles promotions, banners, and marketing campaigns.', '2025-10-30 09:08:30', '2025-10-30 09:08:30'),
(12, 'Viewer', 'viewer', 'Read-only access to reports and dashboards.', '2025-10-30 09:08:30', '2025-10-30 09:08:30');

-- --------------------------------------------------------

--
-- Table structure for table `role_permission`
--

CREATE TABLE `role_permission` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `permission_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
  `slug` varchar(255) NOT NULL,
  `badge_id` int(11) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `contact_person` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `phone` varchar(20) NOT NULL,
  `address` text DEFAULT NULL,
  `city` varchar(150) DEFAULT NULL,
  `state` varchar(150) DEFAULT NULL,
  `country` varchar(150) DEFAULT NULL,
  `postal_code` varchar(20) DEFAULT NULL,
  `gst_number` varchar(50) DEFAULT NULL,
  `pan_number` varchar(20) DEFAULT NULL,
  `bank_account_number` varchar(50) DEFAULT NULL,
  `bank_name` varchar(150) DEFAULT NULL,
  `ifsc_code` varchar(20) DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `documents` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`documents`)),
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sellers`
--

INSERT INTO `sellers` (`id`, `slug`, `badge_id`, `name`, `contact_person`, `email`, `password`, `phone`, `address`, `city`, `state`, `country`, `postal_code`, `gst_number`, `pan_number`, `bank_account_number`, `bank_name`, `ifsc_code`, `logo`, `documents`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'garments-manufacture', NULL, 'Garments Manufacture', 'Soumen Maiti', 'soumen.maiti@delostylestudio.com', '$2y$12$5jJ083VjsmkvzWR7.kUJOeo0jZxiYGumL2Kjo5jztlYxtPsJkyY3e', '+1 (724) 367-8291', 'Nisi aut magna nisi', 'Aut vel labore non c', 'Sint consectetur omn', 'Cupidatat vel in rep', 'Voluptatibus anim re', '110', '548', '36471257415215', 'Alden Shelton', 'FDRL0002162', 'seller_docs/fWQEouD25BNLJyyTfxYohVACAnTdwovhBjVmDwbU.jpg', '\"[\\\"seller_docs\\\\\\/Zkkqg5tDoinGN8ZErkSatDcKjDZlJbcFQ6f5SoOb.pdf\\\"]\"', 1, '2025-09-24 03:53:15', '2026-02-19 06:23:07'),
(2, 'enfield-350', NULL, 'Enfield 350', 'Amar Maity', 'amar.maity@delostylestudio.com', '$2y$12$5jJ083VjsmkvzWR7.kUJOeo0jZxiYGumL2Kjo5jztlYxtPsJkyY3e', '+1 (149) 858-3565', 'Voluptatem Qui non', 'Magna ut quod pariat', 'Excepturi et nesciun', 'Esse non dolores eos', 'Et impedit tempor r', '507', '562', '601', 'Hilary Patterson', 'Autem a eius fuga E', 'seller_docs/Q7O7MxldO6L9dMMfgg01oJW8ZHoVx6XwJ73oy9Sg.png', '\"[\\\"seller_docs\\\\\\/qvG1gXpfKl0IsB2A0kKu9I6HEnc2H76lQAXVC09D.pdf\\\"]\"', 1, '2025-09-24 04:02:49', '2026-02-19 06:23:07'),
(3, 'pantaloons', NULL, 'Pantaloons', 'Rajesh Kumar', 'rajesh.kumar@delostylestudio.com', '$2y$12$5jJ083VjsmkvzWR7.kUJOeo0jZxiYGumL2Kjo5jztlYxtPsJkyY3e', '+1 (548) 264-9254', 'Modi enim est sequi', 'Dignissimos sed temp', 'Pariatur Exercitati', 'Et delectus volupta', 'Eum voluptatem Veri', '712', '139', '429', 'Yoshio Pollard', 'Nulla adipisicing am', 'seller_docs/BGbLY8akz5DUKRpzfqikD7RmrPb1VuRVWEXcTUMS.png', '\"[\\\"seller_docs\\\\\\/jxoOvL9gdkuf1jYBvKw7UzOYQt9KjI74eiLEm5iB.pdf\\\"]\"', 1, '2025-09-24 04:46:27', '2026-02-19 06:23:07'),
(5, 'dst-seller', NULL, 'DST Seller', 'Rajib B', 'amarmaity243@gmail.com', '$2y$12$5jJ083VjsmkvzWR7.kUJOeo0jZxiYGumL2Kjo5jztlYxtPsJkyY3e', '+91 9903823389', 'Howrah, Andul', 'Andul', 'West Bengal', 'India', '711302', '19AAACH7409R1ZY', 'FNFPM8165R', '46237482348902', 'Uco Bank', 'UBCA000004', 'seller_docs/BdVif7JX0wNUNjffB5xqbxC06EpDdxI2tDTR4QoV.png', '\"[\\\"seller_docs\\\\\\/9Ma5I1Zt9DYnyNBVdGFnJgm9oDkr0KrDzO1UaXAy.jpg\\\"]\"', 1, '2025-10-16 12:06:32', '2026-02-19 06:23:07'),
(6, 'testing-new-flow', NULL, 'Testing New FLow', 'Exercitationem aut e', 'pagobyhi@mailinator.com', NULL, '+1 (966) 645-7727', 'Commodi duis accusam', 'Aliquam sit adipisc', 'Dolores adipisci id', 'Cumque inventore eli', 'Quis sed nesciunt e', '355', '893', '389', 'Darius Berry', 'Obcaecati consequat', NULL, '\"[\\\"seller_docs\\\\\\/Zkkqg5tDoinGN8ZErkSatDcKjDZlJbcFQ6f5SoOb.pdf\\\"]\"', 0, '2025-11-06 06:55:21', '2026-02-19 06:23:07');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('ROwl5VNjnKWSfaVUEV4h1WBxrLjKXohkmih1inxS', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiN1hVRG5sV3pBTDVBT2VVMFdtdU1TTEk3UXZBTVFHQ1Ywa3dadld1ZCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9idWxrL3RlbXBsYXRlIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MjoibG9naW5fYWRtaW5fNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToyO3M6MTg6Imxhc3RfYWN0aXZpdHlfdGltZSI7aToxNzczODM4Mzc3O30=', 1773838379);

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `key`, `value`, `created_at`, `updated_at`) VALUES
(1, 'allow_seller_registration', '0', '2025-11-24 09:06:51', '2025-11-27 05:16:28'),
(2, 'require_seller_kyc', '0', '2025-11-24 09:06:51', '2025-11-27 05:16:30'),
(3, 'allow_customer_registration', '0', '2025-11-24 09:06:51', '2025-11-27 05:16:31'),
(4, 'allow_guest_checkout', '0', '2025-11-24 09:06:51', '2025-11-27 05:16:29'),
(5, 'notify_admin_new_order', '0', '2025-11-24 09:06:51', '2025-11-27 06:57:51'),
(6, 'notify_seller_new_order', '0', '2025-11-24 09:06:51', '2025-11-27 06:57:52'),
(7, 'notify_customer_status_update', '0', '2025-11-24 09:06:51', '2025-11-27 06:57:53'),
(8, 'enable_email_notifications', '0', '2025-11-24 09:06:51', '2025-11-27 06:57:54'),
(9, 'allow_multiple_admin_logins', '0', '2025-11-24 09:06:51', '2025-11-27 06:58:45'),
(11, 'platform_name', 'CuddlyDuddly', '2025-11-24 09:06:51', '2025-11-27 06:54:27'),
(12, 'support_email', 'support@cuddlyduddly.com', '2025-11-24 09:06:51', '2025-11-27 06:54:27'),
(13, 'support_phone', '98657412305', '2025-11-24 09:06:51', '2025-11-27 06:54:27'),
(14, 'business_address', 'Webel More , Salt Lake , Bidhan Nagar', '2025-11-24 09:06:51', '2025-11-27 06:54:07'),
(15, 'default_commission_percent', '10', '2025-11-24 09:06:51', '2025-12-01 06:35:27'),
(17, 'session_timeout_minutes', '120', '2025-11-24 09:06:51', '2025-11-27 06:58:27'),
(18, 'store_status', 'active', '2025-11-24 09:06:51', '2025-11-27 08:34:58'),
(19, 'maintenance_message', 'We\'ll be back soon.', '2025-11-24 09:06:51', '2025-11-25 11:08:09'),
(20, 'frontend_maintenance', 'active', '2025-11-24 10:37:13', '2025-11-27 08:35:17'),
(21, 'seller_maintenance', 'active', '2025-11-24 10:37:13', '2025-11-27 08:34:58'),
(22, 'auto_payout_enabled', '0', '2025-11-26 07:34:23', '2025-11-26 12:33:03'),
(23, 'auto_payout_delay_days', '0', '2025-11-26 07:34:23', '2025-11-27 07:32:13'),
(24, 'minimum_payout_threshold', '10000', '2025-11-26 07:34:57', '2025-11-26 12:33:21'),
(25, 'auto_refund_on_order_rejection', '1', '2025-11-26 07:46:38', '2025-11-27 08:43:39'),
(26, 'refund_needs_admin_approval', '0', '2025-11-26 07:46:38', '2025-11-27 08:43:39'),
(27, 'hold_payout_on_dispute', '0', '2025-11-26 07:46:59', '2025-11-27 07:32:24'),
(28, 'dispute_hold_duration_days', '0', '2025-11-26 07:46:59', '2025-11-27 07:32:29'),
(29, 'deduct_gst_on_commission', '0', '2025-11-26 07:48:49', '2025-11-26 11:07:35'),
(30, 'platform_gst_percent', '0', '2025-11-26 07:48:49', '2025-11-26 10:28:56');

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
  `seller_id` int(11) NOT NULL,
  `provider` varchar(50) DEFAULT 'shiprocket',
  `awb_number` varchar(255) DEFAULT NULL,
  `shipment_id` varchar(255) DEFAULT NULL,
  `status` enum('pending','awb_assigned','pickup_scheduled','in_transit','out_for_delivery','delivered','rto_initiated','rto_delivered','cancelled') DEFAULT 'pending',
  `delivered_at` datetime DEFAULT NULL,
  `rto_initiated_at` datetime DEFAULT NULL,
  `rto_delivered_at` datetime DEFAULT NULL,
  `settlement_status` enum('none','on_hold','released','cancelled') DEFAULT 'none',
  `hold_until` datetime DEFAULT NULL,
  `payload_last` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`payload_last`)),
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `shipments`
--

INSERT INTO `shipments` (`id`, `order_id`, `seller_id`, `provider`, `awb_number`, `shipment_id`, `status`, `delivered_at`, `rto_initiated_at`, `rto_delivered_at`, `settlement_status`, `hold_until`, `payload_last`, `created_at`, `updated_at`) VALUES
(1, 2, 0, 'shiprocket', 'AWB740877', 'SHIP696dcbc0860af', 'awb_assigned', NULL, NULL, NULL, 'none', NULL, NULL, '2026-01-19 06:14:24', '2026-01-19 06:14:24');

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
(7, 20, 'Rajesh Kumar', '+91 9215423562', 'rajesh.maity@delostylestudio.com', 'Bihar', 'Near Chutiya Para', 'Sitamandi', 'Patna', 'Patna', '875421', 'India', 1, '2025-10-16 12:27:29', '2025-10-16 12:27:29'),
(9, 20, 'Rajesh Yadav', '9903823389', 'rajesh.maity@delostylestudio.com', 'maity bhawan', 'near andul airport', 'Near Shiv Mandir', 'West Midnapore', 'West Bengal', '721140', 'India', 0, '2025-11-05 10:05:51', '2025-11-05 10:05:51'),
(20, 21, 'Priyanka Debnath', '9382319968', 'soumen.maiti@delostylestudio.com', 'maity bhawan', 'near andul airport', 'Near Shiv Mandir', 'West Midnapore', 'West Bengal', '721140', 'India', 1, '2025-11-18 11:42:46', '2025-11-18 11:42:46');

-- --------------------------------------------------------

--
-- Table structure for table `shipping_logs`
--

CREATE TABLE `shipping_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) DEFAULT NULL,
  `event_name` varchar(100) DEFAULT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`payload`)),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `shipping_logs`
--

INSERT INTO `shipping_logs` (`id`, `order_id`, `event_name`, `payload`, `created_at`, `updated_at`) VALUES
(1, 30, 'MOCK_AWB_CREATED', '{\"awb\":\"AWB356017\",\"shipment_id\":\"SHIP691c5c75358a0\"}', '2025-11-18 11:45:57', '2025-11-18 17:15:57'),
(2, 31, 'MOCK_AWB_CREATED', '{\"awb\":\"AWB849352\",\"shipment_id\":\"SHIP691d9cf3510d6\"}', '2025-11-19 10:33:23', '2025-11-19 16:03:23'),
(3, 2, 'MOCK_AWB_CREATED', '{\"awb\":\"AWB740877\",\"shipment_id\":\"SHIP696dcbc0860af\"}', '2026-01-19 06:14:24', '2026-01-19 11:44:24'),
(4, 4, 'MOCK_AWB_CREATED', '{\"awb\":\"AWB761270\",\"shipment_id\":\"SHIP69896949263af\"}', '2026-02-09 04:57:45', '2026-02-09 10:27:45');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `support_tickets`
--

INSERT INTO `support_tickets` (`id`, `user_id`, `assigned_to`, `subject`, `message`, `type`, `priority`, `status`, `last_reply_by`, `last_replied_at`, `created_at`, `updated_at`) VALUES
(2, 19, 6, 'Order not delivered yet', 'I placed an order 10 days ago but still haven\'t received it.', 'customer', 'medium', 'in_progress', 3, '2025-11-10 12:41:13', '2025-11-10 07:11:13', '2025-11-10 09:41:26'),
(4, 2, 5, 'Seller payout delay issue', 'I have not received my payout for last week\'s sales. Please check.', 'seller', 'high', 'in_progress', 3, '2025-11-10 12:43:36', '2025-11-10 07:13:36', '2025-11-10 09:27:55'),
(5, 3, 6, 'testing', 'testing the support flow', 'seller', 'urgent', 'in_progress', 2, '2025-11-10 14:27:39', '2025-11-10 08:57:39', '2025-11-19 10:24:19'),
(6, 2, 2, 'Est pariatur Offici', 'Doloremque maiores n', 'seller', 'medium', 'open', 2, '2025-12-03 11:22:46', '2025-12-03 05:52:46', '2025-12-03 05:52:46'),
(7, 2, 2, 'Sunt nulla id a veni', 'Amet in reprehender', 'seller', 'medium', 'open', 2, '2025-12-03 11:32:56', '2025-12-03 06:02:56', '2025-12-03 06:02:56');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ticket_replies`
--

INSERT INTO `ticket_replies` (`id`, `ticket_id`, `user_id`, `admin_id`, `seller_id`, `message`, `is_internal`, `attachments`, `created_at`, `updated_at`) VALUES
(1, 5, NULL, NULL, 3, 'hi admin', 0, NULL, '2025-11-13 12:45:23', '2025-11-13 12:45:23'),
(2, 5, NULL, 2, NULL, 'double?', 0, NULL, '2025-11-13 12:45:51', '2025-11-13 12:45:51'),
(3, 5, NULL, NULL, 3, 'huh', 0, NULL, '2025-11-13 12:46:00', '2025-11-13 12:46:00'),
(4, 5, NULL, 2, NULL, 'now fixed.', 0, NULL, '2025-11-13 12:46:13', '2025-11-13 12:46:13'),
(5, 5, NULL, NULL, 3, 'tyhthnth', 0, NULL, '2025-11-13 12:46:21', '2025-11-13 12:46:21'),
(6, 5, NULL, 2, NULL, 'ghrgbg', 0, NULL, '2025-11-13 12:46:24', '2025-11-13 12:46:24'),
(7, 5, NULL, NULL, 3, 'rthrtgbrt', 0, NULL, '2025-11-13 12:46:27', '2025-11-13 12:46:27'),
(8, 5, NULL, 2, NULL, 'gbgb', 0, NULL, '2025-11-13 12:46:30', '2025-11-13 12:46:30'),
(9, 5, NULL, NULL, 3, 'gbgb', 0, NULL, '2025-11-13 12:46:35', '2025-11-13 12:46:35'),
(10, 5, NULL, 2, NULL, 'SOHAM', 0, NULL, '2025-11-13 12:47:27', '2025-11-13 12:47:27'),
(11, 5, NULL, NULL, 3, 'KIBE', 0, NULL, '2025-11-13 12:47:32', '2025-11-13 12:47:32'),
(15, 7, NULL, 2, NULL, 'hi', 0, NULL, '2025-12-03 06:18:16', '2025-12-03 06:18:16'),
(16, 7, NULL, NULL, 2, 'hello', 0, NULL, '2025-12-03 06:18:53', '2025-12-03 06:18:53'),
(17, 6, NULL, 2, NULL, 'hi', 0, NULL, '2026-01-19 06:17:36', '2026-01-19 06:17:36'),
(18, 5, NULL, 2, NULL, 'hello testing', 0, NULL, '2026-02-19 12:35:55', '2026-02-19 12:35:55'),
(19, 5, NULL, 2, NULL, 'ssss', 0, NULL, '2026-02-19 12:36:20', '2026-02-19 12:36:20'),
(20, 5, NULL, 2, NULL, 'ssss', 0, NULL, '2026-02-19 12:36:24', '2026-02-19 12:36:24'),
(21, 5, NULL, 2, NULL, 'wwwww', 0, NULL, '2026-02-19 12:36:30', '2026-02-19 12:36:30');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ticket_tags`
--

INSERT INTO `ticket_tags` (`id`, `name`, `color`, `created_at`, `updated_at`) VALUES
(1, 'Urgent', '#dc3545', '2025-11-10 07:16:15', '2025-11-10 07:16:15'),
(2, 'Payment', '#0d6efd', '2025-11-10 07:16:15', '2025-11-10 07:16:15'),
(3, 'Delivery', '#198754', '2025-11-10 07:16:15', '2025-11-10 07:16:15');

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
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
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
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `phone`, `profile_image`, `dob`, `gender`, `is_verified`, `status`, `last_login_at`, `email_verified_at`, `remember_token`, `created_at`, `updated_at`) VALUES
(20, 'Rajesh', 'Kumar', 'rajesh.kumar@delostylestudio.com', '+91 8956238956', NULL, '2021-01-04', 'male', 0, 'active', NULL, NULL, NULL, '2025-10-16 12:17:26', '2025-10-16 12:17:26'),
(21, 'Priyanka', 'Debnath', 'adminpriyanka@cuddlyduddly.com', '9382319968', NULL, '2001-04-17', 'female', 0, 'active', NULL, NULL, NULL, '2025-11-18 11:19:53', '2025-11-18 11:19:53'),
(23, 'Soumen', 'Maity', 'soumen.maiti@delostylestudio.com', '698956256', NULL, NULL, NULL, 0, 'active', NULL, NULL, 'sBqMb1RDqC8HRZlEKXXoTvx7igVUr1u2f96dLpGxFimb483gueqHmGCFwFih', '2026-02-16 07:33:47', '2026-02-16 07:33:47'),
(24, 'Amar', 'Maity', 'amar.maity@delostylestudio.com', '8927451285', NULL, NULL, NULL, 0, 'active', NULL, NULL, 'Xt8Cm1eJX5FYYo2IVP1nzvL1UFP7YJqkUcNjVRe2QQvbLX3BkyKzUKd9Enjt', '2026-02-17 11:29:24', '2026-02-17 11:29:24');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_otps`
--

INSERT INTO `user_otps` (`id`, `identifier`, `otp`, `expires_at`, `attempts`, `created_at`, `updated_at`) VALUES
(1, '9382319968', '$2y$12$PSa9nOkQKZtDzkT.V6K80uk6uP9cgBIxg9kV8PidFLDa3NIKDmuWa', '2026-02-17 11:18:32', 0, '2026-02-13 06:21:33', '2026-02-17 11:13:32'),
(2, '698562686', '$2y$12$2bISG/ynkeTzseanMsH2O.bSJpC8shV5Tu78ySW9YMivudgVjVzjO', '2026-02-13 06:33:31', 0, '2026-02-13 06:28:31', '2026-02-13 06:28:31'),
(8, '6559898295', '$2y$12$WxNR2m69h2Vf/thbtRO.suxWegstKFR9tu1jRYqveAxm1nbMta4BS', '2026-02-16 09:33:27', 0, '2026-02-16 09:28:27', '2026-02-16 09:28:27'),
(9, 'sefbfdgbfdgbdf', '$2y$12$m8H5KorhpbozN8LlBgWkReyGqyGvqcKKqI889LH/lDAQVmE1/IZXe', '2026-02-16 12:37:58', 0, '2026-02-16 12:32:58', '2026-02-16 12:32:58'),
(10, 'ewudguwwjcb', '$2y$12$b0VEIsUF7oj9hXAq68M2su43foIjuyfN/AaFKoAPxMW/wgxp11ope', '2026-02-16 12:40:49', 0, '2026-02-16 12:35:49', '2026-02-16 12:35:49'),
(11, 'sdfghjkl', '$2y$12$VJ656pVf6oVb0zyCKSRrqOtD/Fgdx4UWk.b5UbdkapiUuYLxgXM1C', '2026-02-16 12:48:11', 0, '2026-02-16 12:36:56', '2026-02-16 12:43:11'),
(12, '9865231470', '$2y$12$sxBzv.jQc.3zRE//EeVmOe3g0Wb10na26z2OFimREurD3yUAECwIi', '2026-02-17 07:28:31', 0, '2026-02-17 07:23:31', '2026-02-17 07:23:31'),
(14, 'soumen.maiti@delostylestudio.co', '$2y$12$7oHtYgK4xbRPF5gh9mPaiuH6MQSJpeH40iEy1ncZlLBhMKoRYx5iG', '2026-02-17 11:10:01', 0, '2026-02-17 09:39:54', '2026-02-17 11:05:01'),
(15, 'abc@gmail.com', '$2y$12$rlY97U6yGJiN9vTK.5QS8uS5LeB3zRu.NPfjQmNKxUYcmxlRRUx4S', '2026-02-17 11:10:33', 0, '2026-02-17 11:05:33', '2026-02-17 11:05:33');

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
(61, 32, 426),
(62, 32, 438),
(63, 33, 430),
(64, 33, 438),
(65, 34, 423),
(66, 34, 439),
(67, 35, 430),
(68, 35, 439),
(69, 36, 426),
(70, 36, 439),
(71, 37, 427),
(72, 37, 439),
(73, 38, 428),
(74, 38, 439),
(75, 39, 427),
(76, 40, 422),
(77, 40, 440),
(78, 41, 424),
(79, 41, 440),
(80, 42, 424),
(81, 42, 441),
(82, 43, 427),
(83, 43, 441),
(88, 46, 425),
(89, 46, 438),
(90, 47, 425),
(91, 47, 439),
(92, 48, 428),
(93, 48, 435),
(94, 49, 428),
(95, 49, 436),
(96, 50, 428),
(97, 50, 437),
(98, 51, 428),
(99, 51, 438),
(100, 52, 428),
(101, 52, 439),
(102, 53, 422),
(103, 53, 435);

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
-- Indexes for table `cancellations`
--
ALTER TABLE `cancellations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`id`),
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
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `order_number` (`order_number`),
  ADD KEY `fk_orders_user` (`user_id`),
  ADD KEY `fk_orders_shipping` (`shipping_address_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_order_items_order` (`order_id`),
  ADD KEY `fk_order_items_product` (`product_id`);

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
  ADD UNIQUE KEY `products_product_code_unique` (`product_code`),
  ADD UNIQUE KEY `products_sku_unique` (`sku`),
  ADD KEY `seller_id` (`seller_id`),
  ADD KEY `approved_by` (`approved_by`),
  ADD KEY `idx_products_category` (`product_categories_id`),
  ADD KEY `product_sub_categories_id` (`product_sub_categories_id`),
  ADD KEY `fk_products_brand` (`brand_id`);

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
-- Indexes for table `returns`
--
ALTER TABLE `returns`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `return_number` (`return_number`),
  ADD KEY `returns_order_id_foreign` (`order_id`),
  ADD KEY `returns_order_item_id_foreign` (`order_item_id`),
  ADD KEY `returns_user_id_foreign` (`user_id`);

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
  ADD UNIQUE KEY `phone` (`phone`);

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
  ADD KEY `shipments_order_id_foreign` (`order_id`);

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
  ADD PRIMARY KEY (`id`);

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
  ADD UNIQUE KEY `email` (`email`);

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=115;

--
-- AUTO_INCREMENT for table `attribute_values`
--
ALTER TABLE `attribute_values`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=460;

--
-- AUTO_INCREMENT for table `brands`
--
ALTER TABLE `brands`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `cancellations`
--
ALTER TABLE `cancellations`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `carts`
--
ALTER TABLE `carts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=876;

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `master_categories`
--
ALTER TABLE `master_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `master_category_sections`
--
ALTER TABLE `master_category_sections`
  MODIFY `id` bigint(15) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1087;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT for table `product_attribute_values`
--
ALTER TABLE `product_attribute_values`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=978;

--
-- AUTO_INCREMENT for table `product_attribute_value_images`
--
ALTER TABLE `product_attribute_value_images`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `product_categories`
--
ALTER TABLE `product_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `product_category_attributes`
--
ALTER TABLE `product_category_attributes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=146;

--
-- AUTO_INCREMENT for table `product_category_section`
--
ALTER TABLE `product_category_section`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=120;

--
-- AUTO_INCREMENT for table `product_images`
--
ALTER TABLE `product_images`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT for table `product_sub_categories`
--
ALTER TABLE `product_sub_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=221;

--
-- AUTO_INCREMENT for table `product_variants`
--
ALTER TABLE `product_variants`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `product_views`
--
ALTER TABLE `product_views`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `returns`
--
ALTER TABLE `returns`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `role_permission`
--
ALTER TABLE `role_permission`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `section_types`
--
ALTER TABLE `section_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=113;

--
-- AUTO_INCREMENT for table `sellers`
--
ALTER TABLE `sellers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

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
-- AUTO_INCREMENT for table `shipping_addresses`
--
ALTER TABLE `shipping_addresses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `user_otps`
--
ALTER TABLE `user_otps`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `variant_attribute_values`
--
ALTER TABLE `variant_attribute_values`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=104;

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
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `fk_order_items_order` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_order_items_product` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

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
  ADD CONSTRAINT `fk_products_brand` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`id`) ON DELETE SET NULL,
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
-- Constraints for table `returns`
--
ALTER TABLE `returns`
  ADD CONSTRAINT `returns_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `returns_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `shipments`
--
ALTER TABLE `shipments`
  ADD CONSTRAINT `shipments_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `shipping_addresses`
--
ALTER TABLE `shipping_addresses`
  ADD CONSTRAINT `fk_shipping_addresses_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

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
