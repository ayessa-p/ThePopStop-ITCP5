-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 19, 2026 at 01:10 PM
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
-- Database: `thepopstop`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(10) UNSIGNED NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `discounts`
--

CREATE TABLE `discounts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `discount_type` enum('percentage','fixed') NOT NULL,
  `discount_value` decimal(10,2) NOT NULL,
  `min_purchase` decimal(10,2) NOT NULL DEFAULT 0.00,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `discounts`
--

INSERT INTO `discounts` (`id`, `code`, `description`, `discount_type`, `discount_value`, `min_purchase`, `start_date`, `end_date`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'WELCOME10', '10% off for new customers!', 'percentage', 10.00, 500.00, '2026-03-19', '2027-03-19', 1, '2026-03-18 23:23:16', '2026-03-18 23:23:16');

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
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_02_27_000001_add_popstop_fields_to_users_table', 1),
(5, '2025_02_27_000002_create_products_table', 1),
(6, '2025_02_27_000003_create_product_photos_table', 1),
(7, '2025_02_27_000004_create_discounts_table', 1),
(8, '2025_02_27_000005_create_suppliers_table', 1),
(9, '2025_02_27_000006_create_cart_table', 1),
(10, '2025_02_27_000007_create_orders_table', 1),
(11, '2025_02_27_000008_create_order_items_table', 1),
(12, '2025_02_27_000009_create_purchase_orders_table', 1),
(13, '2025_02_27_000010_create_purchase_order_items_table', 1),
(14, '2025_02_27_000011_create_reviews_table', 1),
(15, '2026_02_27_000447_add_popstop_fields_to_users_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `discount_amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `status` enum('Pending','Processing','Shipped','Delivered','Cancelled') NOT NULL DEFAULT 'Pending',
  `shipping_address` text NOT NULL,
  `payment_method` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `discount_amount`, `status`, `shipping_address`, `payment_method`, `created_at`, `updated_at`) VALUES
(1, 1, 0.00, 'Delivered', '4857 Wolff Drive Suite 905\r\nConnellyborough, TX 52932', 'Cash on Delivery', '2026-03-11 16:31:21', '2026-03-11 18:50:28'),
(2, 1, 1269.50, 'Pending', '4857 Wolff Drive Suite 905\r\nConnellyborough, TX 52932', 'Cash on Delivery', '2026-03-19 00:17:30', '2026-03-19 00:17:30');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(10) UNSIGNED NOT NULL,
  `unit_price` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `quantity`, `unit_price`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, 2550.00, '2026-03-11 16:31:21', '2026-03-11 16:31:21'),
(2, 2, 20, 2, 6000.00, '2026-03-19 00:17:30', '2026-03-19 00:17:30'),
(3, 2, 25, 1, 695.00, '2026-03-19 00:17:31', '2026-03-19 00:17:31');

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
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `series` varchar(255) NOT NULL,
  `brand` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `cost_price` decimal(10,2) DEFAULT NULL,
  `sku` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `character` varchar(255) DEFAULT NULL,
  `stock_quantity` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `category` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `status` enum('In Stock','Low Stock','Out of Stock') NOT NULL DEFAULT 'Out of Stock',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `series`, `brand`, `price`, `cost_price`, `sku`, `description`, `character`, `stock_quantity`, `category`, `type`, `image_url`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Hirono × Stefanie Sun AUT NIHILO Figure', 'Hirono', 'Pop Mart', 2550.00, 2450.00, 'PM-HIR-001', 'Hirono × Stefanie Sun AUT NIHILO Figure', NULL, 15, 'Figurines', 'Limited Edition', 'products/hirono1.jpg', 'In Stock', '2026-03-17 09:07:03', '2026-03-17 09:07:03', NULL),
(2, 'Hirono × Stefanie Sun Weather With You Figurine', 'Hirono', 'Pop Mart', 6000.00, 5900.00, 'PM-HIR-002', 'Hirono × Stefanie Sun Weather With You Figurine', NULL, 18, 'Figurines', 'Limited Edition', 'products/hirono2.jpg', 'In Stock', '2026-03-17 09:07:03', '2026-03-19 01:17:11', NULL),
(3, 'Hirono Birdy Figurine', 'Hirono', 'Pop Mart', 6000.00, 5900.00, 'PM-HIR-003', 'Hirono Birdy Figurine', NULL, 10, 'Figurines', 'Regular', 'products/hirono3.jpg', 'Low Stock', '2026-03-17 09:07:03', '2026-03-17 09:07:03', NULL),
(4, 'Hirono Reshape Figurine', 'Hirono', 'Pop Mart', 6000.00, 5900.00, 'PM-HIR-004', 'Hirono Reshape Figurine', NULL, 12, 'Figurines', 'Regular', 'products/hirono4.jpg', 'In Stock', '2026-03-17 09:07:03', '2026-03-17 09:07:03', NULL),
(5, 'Hirono x Keith Haring Figurine', 'Hirono', 'Pop Mart', 6000.00, 5900.00, 'PM-HIR-005', 'Hirono x Keith Haring Figurine', NULL, 7, 'Figurines', 'Limited Edition', 'products/hirono5.jpg', 'Low Stock', '2026-03-17 09:07:03', '2026-03-17 09:07:03', NULL),
(6, 'Hirono × Gary Baseman Figure', 'Hirono', 'Pop Mart', 1700.00, 1600.00, 'PM-HIR-006', 'Hirono × Gary Baseman Figure', NULL, 20, 'Figurines', 'Blind Box', 'products/hirono6.jpg', 'In Stock', '2026-03-17 09:07:03', '2026-03-17 09:07:03', NULL),
(7, 'Hirono The Pianist Figure', 'Hirono', 'Pop Mart', 2550.00, 2450.00, 'PM-HIR-007', 'Hirono The Pianist Figure', NULL, 18, 'Figurines', 'Regular', 'products/hirono7.jpg', 'In Stock', '2026-03-17 09:07:03', '2026-03-17 09:07:03', NULL),
(8, 'Hirono Living Wild-Fight for Joy Plush Doll', 'Hirono', 'Pop Mart', 1470.00, 1370.00, 'PM-HIR-008', 'Hirono Living Wild-Fight for Joy Plush Doll', NULL, 25, 'Plush', 'Regular', 'products/hirono8.jpg', 'In Stock', '2026-03-17 09:07:03', '2026-03-17 09:07:03', NULL),
(9, 'Hirono × Snoopy Figure', 'Hirono', 'Pop Mart', 1700.00, 1600.00, 'PM-HIR-009', 'Hirono × Snoopy Figure', NULL, 22, 'Figurines', 'Blind Box', 'products/hirono9.jpg', 'In Stock', '2026-03-17 09:07:03', '2026-03-17 09:07:03', NULL),
(10, 'Hirono Doll Panda Figure', 'Hirono', 'Pop Mart', 1700.00, 1600.00, 'PM-HIR-010', 'Hirono Doll Panda Figure', NULL, 16, 'Figurines', 'Blind Box', 'products/hirono10.jpg', 'In Stock', '2026-03-17 09:07:03', '2026-03-17 09:07:03', NULL),
(11, 'SKULLPANDA Covenant of the White Moon Figure', 'Skullpanda', 'Pop Mart', 1700.00, 1600.00, 'PM-SKP-001', 'SKULLPANDA Covenant of the White Moon Figure', NULL, 20, 'Figurines', 'Blind Box', 'products/skullpanda1.jpg', 'In Stock', '2026-03-17 09:07:03', '2026-03-17 09:07:03', NULL),
(12, 'SKULLPANDA The Glimpse Figure', 'Skullpanda', 'Pop Mart', 1700.00, 1600.00, 'PM-SKP-002', 'SKULLPANDA The Glimpse Figure', NULL, 18, 'Figurines', 'Blind Box', 'products/skullpanda2.jpg', 'In Stock', '2026-03-17 09:07:03', '2026-03-17 09:07:03', NULL),
(13, 'SKULLPANDA Club Man Figurine', 'Skullpanda', 'Pop Mart', 1700.00, 1600.00, 'PM-SKP-003', 'SKULLPANDA Club Man Figurine', NULL, 15, 'Figurines', 'Blind Box', 'products/skullpanda3.jpg', 'In Stock', '2026-03-17 09:07:03', '2026-03-17 09:07:03', NULL),
(14, 'CRYBABY BE MINE FIGURINE', 'Crybaby', 'Pop Mart', 7280.00, 7180.00, 'PM-CRY-001', 'CRYBABY BE MINE FIGURINE', NULL, 5, 'Figurines', 'Limited Edition', 'products/crybaby1.jpg', 'Low Stock', '2026-03-17 09:07:03', '2026-03-17 09:07:03', NULL),
(15, 'CRYBABY MAKE ME FLOAT FIGURE', 'Crybaby', 'Pop Mart', 1700.00, 1600.00, 'PM-CRY-002', 'CRYBABY MAKE ME FLOAT FIGURE', NULL, 14, 'Figurines', 'Blind Box', 'products/crybaby2.jpg', 'In Stock', '2026-03-17 09:07:03', '2026-03-17 09:07:03', NULL),
(16, 'Crybaby Coconut Figure-Brown', 'Crybaby', 'Pop Mart', 1700.00, 1600.00, 'PM-CRY-003', 'Crybaby Coconut Figure-Brown', NULL, 12, 'Figurines', 'Blind Box', 'products/crybaby3.jpg', 'In Stock', '2026-03-17 09:07:03', '2026-03-17 09:07:03', NULL),
(17, 'Crybaby Coconut Figure-Green', 'Crybaby', 'Pop Mart', 1700.00, 1600.00, 'PM-CRY-004', 'Crybaby Coconut Figure-Green', NULL, 11, 'Figurines', 'Blind Box', 'products/crybaby4.jpg', 'In Stock', '2026-03-17 09:07:03', '2026-03-17 09:07:03', NULL),
(18, 'LABUBU Hip-hop Girl Figure', 'The Monster', 'Pop Mart', 1700.00, 1600.00, 'PM-LAB-001', 'LABUBU Hip-hop Girl Figure', NULL, 25, 'Figurines', 'Blind Box', 'products/labubu1.jpg', 'In Stock', '2026-03-17 09:07:03', '2026-03-17 09:07:03', NULL),
(19, 'LABUBU Superstar Dance Moves Figure', 'The Monster', 'Pop Mart', 1700.00, 1600.00, 'PM-LAB-002', 'LABUBU Superstar Dance Moves Figure', NULL, 22, 'Figurines', 'Blind Box', 'products/labubu2.jpg', 'In Stock', '2026-03-17 09:07:03', '2026-03-17 09:07:03', NULL),
(20, 'THE MONSTERS_How to Train Your Dragon Figurine', 'The Monster', 'Pop Mart', 6000.00, 5900.00, 'PM-MON-001', 'THE MONSTERS_How to Train Your Dragon Figurine', NULL, 6, 'Figurines', 'Limited Edition', 'products/labubu3.jpg', 'Low Stock', '2026-03-17 09:07:03', '2026-03-19 00:17:30', NULL),
(21, 'PINO JELLY Chocolate Cookie Figurine', 'Pino Jelly', 'Pop Mart', 5000.00, 4900.00, 'PM-PIN-001', 'PINO JELLY Chocolate Cookie Figurine', NULL, 10, 'Figurines', 'Regular', 'products/pino1.jpg', 'Low Stock', '2026-03-17 09:07:03', '2026-03-17 09:07:03', NULL),
(22, 'PINO JELLY Birthday Bash Figurine', 'Pino Jelly', 'Pop Mart', 5000.00, 4900.00, 'PM-PIN-002', 'PINO JELLY Birthday Bash Figurine', NULL, 12, 'Figurines', 'Regular', 'products/pino2.jpg', 'In Stock', '2026-03-17 09:07:03', '2026-03-17 09:07:03', NULL),
(23, 'PINO JELLY Guess Who I am Figure', 'Pino Jelly', 'Pop Mart', 1700.00, 1600.00, 'PM-PIN-003', 'PINO JELLY Guess Who I am Figure', NULL, 18, 'Figurines', 'Blind Box', 'products/pino3.jpg', 'In Stock', '2026-03-17 09:07:04', '2026-03-17 09:07:04', NULL),
(24, 'PINO JELLY Fairyland Figurine', 'Pino Jelly', 'Pop Mart', 5000.00, 4900.00, 'PM-PIN-004', 'PINO JELLY Fairyland Figurine', NULL, 9, 'Figurines', 'Regular', 'products/pino4.jpg', 'Low Stock', '2026-03-17 09:07:04', '2026-03-17 09:07:04', NULL),
(25, 'Funko Marvel: Deadpool & Wolverine - Wolverine Pop! Vinyl Figure', 'Marvel', 'Funko', 695.00, 595.00, 'FK-MAR-001', 'Funko Marvel: Deadpool & Wolverine - Wolverine Pop! Vinyl Figure', NULL, 29, 'Figurines', 'Regular', 'products/funko1.jpg', 'In Stock', '2026-03-17 09:07:04', '2026-03-19 00:17:31', NULL),
(26, 'Funko Marvel: Deadpool & Wolverine - Deadpool Pop! Vinyl Figure', 'Marvel', 'Funko', 695.00, 595.00, 'FK-MAR-002', 'Funko Marvel: Deadpool & Wolverine - Deadpool Pop! Vinyl Figure', NULL, 28, 'Figurines', 'Regular', 'products/funko2.jpg', 'In Stock', '2026-03-17 09:07:04', '2026-03-17 09:07:04', NULL),
(27, 'Funko DC Comics Batman War Zone - The Joker War Joker Pop! Vinyl Figure', 'DC Comics', 'Funko', 695.00, 595.00, 'FK-DC-001', 'Funko DC Comics Batman War Zone - The Joker War Joker Pop! Vinyl Figure', NULL, 25, 'Figurines', 'Regular', 'products/funko3.jpg', 'In Stock', '2026-03-17 09:07:04', '2026-03-17 09:07:04', NULL),
(28, 'Funko Bleach Ichigo Kurosaki (FB Shikai) Funko Pop! Vinyl Figure', 'Anime', 'Funko', 695.00, 595.00, 'FK-ANI-001', 'Funko Bleach Ichigo Kurosaki (FB Shikai) Funko Pop! Vinyl Figure', NULL, 20, 'Figurines', 'Regular', 'products/funko4.jpg', 'In Stock', '2026-03-17 09:07:04', '2026-03-17 09:07:04', NULL),
(29, 'Funko Boruto: Naruto Next Generations Mirai Sarutobi Funko Pop! Vinyl Figure', 'Anime', 'Funko', 695.00, 595.00, 'FK-ANI-002', 'Funko Boruto: Naruto Next Generations Mirai Sarutobi Funko Pop! Vinyl Figure', NULL, 22, 'Figurines', 'Regular', 'products/funko5.jpg', 'In Stock', '2026-03-17 09:07:04', '2026-03-17 09:07:04', NULL),
(30, 'Funko Spider-Man 2 Game Miles Morales Upgraded Suit Funko Pop! Vinyl Figure', 'Games', 'Funko', 695.00, 595.00, 'FK-GAM-001', 'Funko Spider-Man 2 Game Miles Morales Upgraded Suit Funko Pop! Vinyl Figure', NULL, 18, 'Figurines', 'Regular', 'products/funko6.jpg', 'In Stock', '2026-03-17 09:07:04', '2026-03-17 09:07:04', NULL),
(31, 'Funko Demon Slayer Tengen Uzui Funko Pop! Vinyl Figure', 'Anime', 'Funko', 695.00, 595.00, 'FK-ANI-003', 'Funko Demon Slayer Tengen Uzui Funko Pop! Vinyl Figure', NULL, 24, 'Figurines', 'Regular', 'products/funko7.jpg', 'In Stock', '2026-03-17 09:07:04', '2026-03-17 09:07:04', NULL),
(32, 'Funko My Hero Academia Katsuki Bakugo Funko Pop! Vinyl Figure - Previews Exclusive', 'Anime', 'Funko', 1195.00, 1095.00, 'FK-ANI-004', 'Funko My Hero Academia Katsuki Bakugo Funko Pop! Vinyl Figure - Previews Exclusive', NULL, 12, 'Figurines', 'Limited Edition', 'products/funko8.jpg', 'In Stock', '2026-03-17 09:07:04', '2026-03-17 09:07:04', NULL),
(33, 'Funko Black Clover Asta with Nero Funko Pop! Vinyl Figure', 'Anime', 'Funko', 695.00, 595.00, 'FK-ANI-005', 'Funko Black Clover Asta with Nero Funko Pop! Vinyl Figure', NULL, 19, 'Figurines', 'Regular', 'products/funko9.jpg', 'In Stock', '2026-03-17 09:07:04', '2026-03-17 09:07:04', NULL),
(34, 'Funko One Piece Onami (Wano) Funko Pop! Vinyl Figure', 'Anime', 'Funko', 695.00, 595.00, 'FK-ANI-006', 'Funko One Piece Onami (Wano) Funko Pop! Vinyl Figure', NULL, 21, 'Figurines', 'Regular', 'products/funko10.jpg', 'In Stock', '2026-03-17 09:07:04', '2026-03-17 09:07:04', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `product_photos`
--

CREATE TABLE `product_photos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `photo_url` varchar(255) NOT NULL,
  `is_primary` tinyint(1) NOT NULL DEFAULT 0,
  `display_order` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_photos`
--

INSERT INTO `product_photos` (`id`, `product_id`, `photo_url`, `is_primary`, `display_order`, `created_at`, `updated_at`) VALUES
(2, 1, 'products/hirono1.2.jpg', 0, 1, '2026-03-17 06:54:11', '2026-03-17 08:47:04'),
(3, 2, 'products/hirono2.1.jpg', 0, 1, '2026-03-17 06:54:11', '2026-03-17 06:54:11'),
(4, 2, 'products/hirono 2.2.jpg', 0, 2, '2026-03-17 06:54:11', '2026-03-17 06:54:11'),
(5, 1, 'products/hirono1.3.jpg', 0, 2, '2026-03-17 07:22:59', '2026-03-17 08:47:04'),
(6, 2, 'products/hirono2.2.jpg', 0, 1, '2026-03-17 07:22:59', '2026-03-17 07:22:59'),
(7, 2, 'products/hirono 2.3.jpg', 0, 2, '2026-03-17 07:22:59', '2026-03-17 07:22:59'),
(8, 2, 'products/hirono2.3.jpg', 0, 2, '2026-03-17 09:07:03', '2026-03-17 09:07:03'),
(9, 3, 'products/hirono3.2.jpg', 0, 1, '2026-03-17 09:07:03', '2026-03-17 09:07:03'),
(10, 3, 'products/hirono3.3.jpg', 0, 2, '2026-03-17 09:07:03', '2026-03-17 09:07:03'),
(11, 4, 'products/hirono4.2.jpg', 0, 1, '2026-03-17 09:07:03', '2026-03-17 09:07:03'),
(12, 4, 'products/hirono4.3.jpg', 0, 2, '2026-03-17 09:07:03', '2026-03-17 09:07:03'),
(13, 5, 'products/hirono5.2.jpg', 0, 1, '2026-03-17 09:07:03', '2026-03-17 09:07:03'),
(14, 5, 'products/hirono5.3.jpg', 0, 2, '2026-03-17 09:07:03', '2026-03-17 09:07:03'),
(15, 6, 'products/hirono6.2.jpg', 0, 1, '2026-03-17 09:07:03', '2026-03-17 09:07:03'),
(16, 6, 'products/hirono6.3.jpg', 0, 2, '2026-03-17 09:07:03', '2026-03-17 09:07:03'),
(17, 7, 'products/hirono7.2.jpg', 0, 1, '2026-03-17 09:07:03', '2026-03-17 09:07:03'),
(18, 7, 'products/hirono7.3.jpg', 0, 2, '2026-03-17 09:07:03', '2026-03-17 09:07:03'),
(19, 8, 'products/hirono8.2.jpg', 0, 1, '2026-03-17 09:07:03', '2026-03-17 09:07:03'),
(20, 8, 'products/hirono8.3.jpg', 0, 2, '2026-03-17 09:07:03', '2026-03-17 09:07:03'),
(21, 9, 'products/hirono9.2.jpg', 0, 1, '2026-03-17 09:07:03', '2026-03-17 09:07:03'),
(22, 9, 'products/hirono9.3.jpg', 0, 2, '2026-03-17 09:07:03', '2026-03-17 09:07:03'),
(23, 10, 'products/hirono10.2.jpg', 0, 1, '2026-03-17 09:07:03', '2026-03-17 09:07:03'),
(24, 10, 'products/hirono10.3.jpg', 0, 2, '2026-03-17 09:07:03', '2026-03-17 09:07:03'),
(25, 11, 'products/skullpanda1.2.jpg', 0, 1, '2026-03-17 09:07:03', '2026-03-17 09:07:03'),
(26, 11, 'products/skullpanda1.3.jpg', 0, 2, '2026-03-17 09:07:03', '2026-03-17 09:07:03'),
(27, 12, 'products/skullpanda2.2.jpg', 0, 1, '2026-03-17 09:07:03', '2026-03-17 09:07:03'),
(28, 12, 'products/skullpanda2.3.jpg', 0, 2, '2026-03-17 09:07:03', '2026-03-17 09:07:03'),
(29, 13, 'products/skullpanda3.2.jpg', 0, 1, '2026-03-17 09:07:03', '2026-03-17 09:07:03'),
(30, 13, 'products/skullpanda3.3.jpg', 0, 2, '2026-03-17 09:07:03', '2026-03-17 09:07:03'),
(31, 14, 'products/crybaby1.2.jpg', 0, 1, '2026-03-17 09:07:03', '2026-03-17 09:07:03'),
(32, 14, 'products/crybaby1.3.jpg', 0, 2, '2026-03-17 09:07:03', '2026-03-17 09:07:03'),
(33, 15, 'products/crybaby2.2.jpg', 0, 1, '2026-03-17 09:07:03', '2026-03-17 09:07:03'),
(34, 15, 'products/crybaby2.3.jpg', 0, 2, '2026-03-17 09:07:03', '2026-03-17 09:07:03'),
(35, 16, 'products/crybaby3.2.jpg', 0, 1, '2026-03-17 09:07:03', '2026-03-17 09:07:03'),
(36, 16, 'products/crybaby3.3.jpg', 0, 2, '2026-03-17 09:07:03', '2026-03-17 09:07:03'),
(37, 17, 'products/crybaby4.2.jpg', 0, 1, '2026-03-17 09:07:03', '2026-03-17 09:07:03'),
(38, 17, 'products/crybaby4.3.jpg', 0, 2, '2026-03-17 09:07:03', '2026-03-17 09:07:03'),
(39, 18, 'products/labubu1.2.jpg', 0, 1, '2026-03-17 09:07:03', '2026-03-17 09:07:03'),
(40, 18, 'products/labubu1.3.jpg', 0, 2, '2026-03-17 09:07:03', '2026-03-17 09:07:03'),
(41, 19, 'products/labubu2.2.jpg', 0, 1, '2026-03-17 09:07:03', '2026-03-17 09:07:03'),
(42, 19, 'products/labubu2.3.jpg', 0, 2, '2026-03-17 09:07:03', '2026-03-17 09:07:03'),
(43, 20, 'products/labubu3.2.jpg', 0, 1, '2026-03-17 09:07:03', '2026-03-17 09:07:03'),
(44, 20, 'products/labubuy3.3.jpg', 0, 2, '2026-03-17 09:07:03', '2026-03-17 09:07:03'),
(45, 21, 'products/pino1.2.jpg', 0, 1, '2026-03-17 09:07:03', '2026-03-17 09:07:03'),
(46, 21, 'products/pino1.3.jpg', 0, 2, '2026-03-17 09:07:03', '2026-03-17 09:07:03'),
(47, 22, 'products/pino2.2.jpg', 0, 1, '2026-03-17 09:07:04', '2026-03-17 09:07:04'),
(48, 22, 'products/pino2.3.jpg', 0, 2, '2026-03-17 09:07:04', '2026-03-17 09:07:04'),
(49, 23, 'products/pino3.2.jpg', 0, 1, '2026-03-17 09:07:04', '2026-03-17 09:07:04'),
(50, 23, 'products/pino3.3.jpg', 0, 2, '2026-03-17 09:07:04', '2026-03-17 09:07:04'),
(51, 24, 'products/pino4.2.jpg', 0, 1, '2026-03-17 09:07:04', '2026-03-17 09:07:04'),
(52, 24, 'products/pino4.3.jpg', 0, 2, '2026-03-17 09:07:04', '2026-03-17 09:07:04'),
(53, 25, 'products/funko1.2.jpg', 0, 1, '2026-03-17 09:07:04', '2026-03-17 09:07:04'),
(54, 25, 'products/funko1.3.jpg', 0, 2, '2026-03-17 09:07:04', '2026-03-17 09:07:04'),
(55, 26, 'products/funko2.2.jpg', 0, 1, '2026-03-17 09:07:04', '2026-03-17 09:07:04'),
(56, 26, 'products/funko2.3.jpg', 0, 2, '2026-03-17 09:07:04', '2026-03-17 09:07:04'),
(57, 27, 'products/funko3.2.jpg', 0, 1, '2026-03-17 09:07:04', '2026-03-17 09:07:04'),
(58, 27, 'products/funko3.3.jpg', 0, 2, '2026-03-17 09:07:04', '2026-03-17 09:07:04'),
(59, 28, 'products/funko4.2.jpg', 0, 1, '2026-03-17 09:07:04', '2026-03-17 09:07:04'),
(60, 28, 'products/funko4.3.jpg', 0, 2, '2026-03-17 09:07:04', '2026-03-17 09:07:04'),
(61, 29, 'products/funko5.2.jpg', 0, 1, '2026-03-17 09:07:04', '2026-03-17 09:07:04'),
(62, 29, 'products/funko5.3.jpg', 0, 2, '2026-03-17 09:07:04', '2026-03-17 09:07:04'),
(63, 30, 'products/funko6.2.jpg', 0, 1, '2026-03-17 09:07:04', '2026-03-17 09:07:04'),
(64, 30, 'products/funko6.3.jpg', 0, 2, '2026-03-17 09:07:04', '2026-03-17 09:07:04'),
(65, 31, 'products/funko7.2.jpg', 0, 1, '2026-03-17 09:07:04', '2026-03-17 09:07:04'),
(66, 31, 'products/funko7.3.jpg', 0, 2, '2026-03-17 09:07:04', '2026-03-17 09:07:04'),
(67, 32, 'products/funko8.2.jpg', 0, 1, '2026-03-17 09:07:04', '2026-03-17 09:07:04'),
(68, 32, 'products/funko8.3.jpg', 0, 2, '2026-03-17 09:07:04', '2026-03-17 09:07:04'),
(69, 33, 'products/funko9.2.jpg', 0, 1, '2026-03-17 09:07:04', '2026-03-17 09:07:04'),
(70, 33, 'products/funko9.3.jpg', 0, 2, '2026-03-17 09:07:04', '2026-03-17 09:07:04'),
(71, 34, 'products/funko10.2.jpg', 0, 1, '2026-03-17 09:07:04', '2026-03-17 09:07:04'),
(72, 34, 'products/funko10.3.jpg', 0, 2, '2026-03-17 09:07:04', '2026-03-17 09:07:04');

-- --------------------------------------------------------

--
-- Table structure for table `purchase_orders`
--

CREATE TABLE `purchase_orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `supplier_id` bigint(20) UNSIGNED NOT NULL,
  `order_date` date NOT NULL,
  `notes` text DEFAULT NULL,
  `status` enum('Ordered','Shipped','Received') NOT NULL DEFAULT 'Ordered',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `purchase_orders`
--

INSERT INTO `purchase_orders` (`id`, `supplier_id`, `order_date`, `notes`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, '2026-03-19', NULL, 'Received', '2026-03-19 00:31:46', '2026-03-19 01:17:11');

-- --------------------------------------------------------

--
-- Table structure for table `purchase_order_items`
--

CREATE TABLE `purchase_order_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `purchase_order_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(10) UNSIGNED NOT NULL,
  `unit_cost` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `purchase_order_items`
--

INSERT INTO `purchase_order_items` (`id`, `purchase_order_id`, `product_id`, `quantity`, `unit_cost`, `created_at`, `updated_at`) VALUES
(1, 1, 2, 5, 5900.00, '2026-03-19 00:31:46', '2026-03-19 00:31:46');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `rating` tinyint(3) UNSIGNED NOT NULL,
  `review_text` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `product_id`, `user_id`, `order_id`, `rating`, `review_text`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, 3, 'amazing', '2026-03-19 02:13:01', '2026-03-19 02:13:01');

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
('WJdSdDGbF3g3rp2S0RhawwkOqZVUT3QrU4n13UWg', 4, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoic1Foc2tSeHVBRW9ObVR6SFFmSmVCUnFiUmtzanNhZlhkNlNaWkVYVSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NjA6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9pbmRleC5waHAvaW1nLWRhdGEvcHJvZHVjdHMvZnVua282LmpwZyI7czo1OiJyb3V0ZSI7czoxMToiaW1hZ2Uuc2VydmUiO31zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aTo0O3M6MzoidXJsIjthOjE6e3M6ODoiaW50ZW5kZWQiO3M6Mzg6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9pbmRleC5waHAvb3JkZXJzIjt9fQ==', 1773922190);

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

CREATE TABLE `suppliers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `brand` varchar(255) NOT NULL,
  `contact_person` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `suppliers`
--

INSERT INTO `suppliers` (`id`, `brand`, `contact_person`, `email`, `phone`, `address`, `created_at`, `updated_at`) VALUES
(1, 'Pop Mart', 'Feonna Calupas', 'popmart.supplier@gmail.com', '0912-573-5463', 'Makati City, Philippines', '2026-03-19 00:29:16', '2026-03-19 00:29:16'),
(2, 'Funko', 'Nhaj Bravo', 'funko.supplier@gmail.com', '0912-573-5462', 'Manila City, Philippines', '2026-03-19 00:30:06', '2026-03-19 00:30:06');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `full_name` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `profile_photo` varchar(255) DEFAULT NULL,
  `role` enum('customer','admin') NOT NULL DEFAULT 'customer',
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `name`, `full_name`, `email`, `phone`, `address`, `profile_photo`, `role`, `is_active`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'Admin', 'Administrator', 'admin@thepopstop.com', '1-878-393-8055', '4857 Wolff Drive Suite 905\nConnellyborough, TX 52932', NULL, 'admin', 1, '2026-02-26 16:30:26', '$2y$12$l9VIUHtx8LZPK5/wYOuiTO2EvO2bHU9CVAvWSx9WVUFy7CHKko7eK', 'gavzyiRA4kOevKRSWdHBkigzjrfvukGWUEoMxams3Trd8b0bmeG34gO7oBGe', '2026-02-26 16:30:26', '2026-02-26 16:30:26'),
(2, 'jiji', 'jihoon', 'Lee Jihoon', 'ji@gmail.com', '09123456789', 'Taguig', 'profiles/YSn0MeTAraqAVhXZnIQKl6LKEGQMLP13Y7W7Xivt.jpg', 'customer', 1, '2026-02-26 18:24:58', '$2y$12$a2XawdkmRHq1kKaSz7RgbON4WIp5y16QG/QvrrJJ6Su.7rAyFIC3G', NULL, '2026-02-26 18:07:42', '2026-02-26 18:24:58'),
(3, 'aye', 'aye', 'ayessa', 'fuyu.chiiii@gmail.com', '09123456789', 'TAGUIG', 'profiles/gY17ig0PlP9LWJyiFsC0Sta2Pha5j0WKT9YKNLLu.jpg', 'customer', 1, '2026-03-11 16:38:31', '$2y$12$SwlUESf4DjOIEWPQFrR43.DdayvJD8MYvUZdpyRS0oeyh00yvWfCC', NULL, '2026-03-11 16:37:31', '2026-03-11 16:38:31'),
(4, 'yeye', 'ayessa', 'Ayessa Pili', 'aye@gmail.com', '09123456789', 'taguig', 'profiles/V1rXlKx3BaQOax16MKbv94nPcCZLzodAkVtaNX3D.jpg', 'customer', 1, '2026-03-19 03:02:49', '$2y$12$AKWIhD5IS9gPemJrHEgrceKF6/nL4sj1lJ/vAQzVdI.w7PZuDLp4y', NULL, '2026-03-19 02:58:16', '2026-03-19 03:03:15');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `cart_user_id_product_id_unique` (`user_id`,`product_id`),
  ADD KEY `cart_product_id_foreign` (`product_id`);

--
-- Indexes for table `discounts`
--
ALTER TABLE `discounts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `discounts_code_unique` (`code`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

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
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `orders_user_id_foreign` (`user_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_items_order_id_foreign` (`order_id`),
  ADD KEY `order_items_product_id_foreign` (`product_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `products_sku_unique` (`sku`);

--
-- Indexes for table `product_photos`
--
ALTER TABLE `product_photos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_photos_product_id_foreign` (`product_id`);

--
-- Indexes for table `purchase_orders`
--
ALTER TABLE `purchase_orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `purchase_orders_supplier_id_foreign` (`supplier_id`);

--
-- Indexes for table `purchase_order_items`
--
ALTER TABLE `purchase_order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `purchase_order_items_purchase_order_id_foreign` (`purchase_order_id`),
  ADD KEY `purchase_order_items_product_id_foreign` (`product_id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reviews_product_id_foreign` (`product_id`),
  ADD KEY `reviews_user_id_foreign` (`user_id`),
  ADD KEY `reviews_order_id_foreign` (`order_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_username_unique` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `discounts`
--
ALTER TABLE `discounts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `product_photos`
--
ALTER TABLE `product_photos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT for table `purchase_orders`
--
ALTER TABLE `purchase_orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `purchase_order_items`
--
ALTER TABLE `purchase_order_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cart_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `product_photos`
--
ALTER TABLE `product_photos`
  ADD CONSTRAINT `product_photos_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `purchase_orders`
--
ALTER TABLE `purchase_orders`
  ADD CONSTRAINT `purchase_orders_supplier_id_foreign` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `purchase_order_items`
--
ALTER TABLE `purchase_order_items`
  ADD CONSTRAINT `purchase_order_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `purchase_order_items_purchase_order_id_foreign` FOREIGN KEY (`purchase_order_id`) REFERENCES `purchase_orders` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reviews_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reviews_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
