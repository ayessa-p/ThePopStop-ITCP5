-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 06, 2026 at 01:37 AM
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

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `user_id`, `product_id`, `quantity`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, '2026-03-04 17:31:03', '2026-03-04 17:31:03');

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
(1, 'Hirono × Stefanie Sun AUT NIHILO Figure', 'Hirono', 'Pop Mart', 2550.00, 2450.00, 'PM-HIR-001', 'Hirono × Stefanie Sun AUT NIHILO Figure', NULL, 15, 'Figurines', 'Limited Edition', 'products/hirono1.jpg', 'In Stock', '2026-03-04 17:29:54', '2026-03-04 17:29:54', NULL),
(2, 'Hirono × Stefanie Sun Weather With You Figurine', 'Hirono', 'Pop Mart', 6000.00, 5900.00, 'PM-HIR-002', 'Hirono × Stefanie Sun Weather With You Figurine', NULL, 8, 'Figurines', 'Limited Edition', 'products/hirono2.jpg', 'Low Stock', '2026-03-04 17:29:54', '2026-03-04 17:29:54', NULL),
(3, 'Hirono Birdy Figurine', 'Hirono', 'Pop Mart', 6000.00, 5900.00, 'PM-HIR-003', 'Hirono Birdy Figurine', NULL, 10, 'Figurines', 'Regular', 'products/hirono3.jpg', 'Low Stock', '2026-03-04 17:29:54', '2026-03-04 17:29:54', NULL),
(4, 'Hirono Reshape Figurine', 'Hirono', 'Pop Mart', 6000.00, 5900.00, 'PM-HIR-004', 'Hirono Reshape Figurine', NULL, 12, 'Figurines', 'Regular', 'products/hirono4.jpg', 'In Stock', '2026-03-04 17:29:54', '2026-03-04 17:29:54', NULL),
(5, 'Hirono x Keith Haring Figurine', 'Hirono', 'Pop Mart', 6000.00, 5900.00, 'PM-HIR-005', 'Hirono x Keith Haring Figurine', NULL, 7, 'Figurines', 'Limited Edition', 'products/hirono5.jpg', 'Low Stock', '2026-03-04 17:29:54', '2026-03-04 17:29:54', NULL),
(6, 'Hirono × Gary Baseman Figure', 'Hirono', 'Pop Mart', 1700.00, 1600.00, 'PM-HIR-006', 'Hirono × Gary Baseman Figure', NULL, 20, 'Figurines', 'Blind Box', 'products/hirono6.jpg', 'In Stock', '2026-03-04 17:29:54', '2026-03-04 17:29:54', NULL),
(7, 'Hirono The Pianist Figure', 'Hirono', 'Pop Mart', 2550.00, 2450.00, 'PM-HIR-007', 'Hirono The Pianist Figure', NULL, 18, 'Figurines', 'Regular', 'products/hirono7.jpg', 'In Stock', '2026-03-04 17:29:54', '2026-03-04 17:29:54', NULL),
(8, 'Hirono Living Wild-Fight for Joy Plush Doll', 'Hirono', 'Pop Mart', 1470.00, 1370.00, 'PM-HIR-008', 'Hirono Living Wild-Fight for Joy Plush Doll', NULL, 25, 'Plush', 'Regular', 'products/hirono8.jpg', 'In Stock', '2026-03-04 17:29:54', '2026-03-04 17:29:54', NULL),
(9, 'Hirono × Snoopy Figure', 'Hirono', 'Pop Mart', 1700.00, 1600.00, 'PM-HIR-009', 'Hirono × Snoopy Figure', NULL, 22, 'Figurines', 'Blind Box', 'products/hirono9.jpg', 'In Stock', '2026-03-04 17:29:54', '2026-03-04 17:29:54', NULL),
(10, 'Hirono Doll Panda Figure', 'Hirono', 'Pop Mart', 1700.00, 1600.00, 'PM-HIR-010', 'Hirono Doll Panda Figure', NULL, 16, 'Figurines', 'Blind Box', 'products/hirono10.jpg', 'In Stock', '2026-03-04 17:29:54', '2026-03-04 17:29:54', NULL),
(11, 'SKULLPANDA Covenant of the White Moon Figure', 'Skullpanda', 'Pop Mart', 1700.00, 1600.00, 'PM-SKP-001', 'SKULLPANDA Covenant of the White Moon Figure', NULL, 20, 'Figurines', 'Blind Box', 'products/skullpanda1.jpg', 'In Stock', '2026-03-04 17:29:54', '2026-03-04 17:29:54', NULL),
(12, 'SKULLPANDA The Glimpse Figure', 'Skullpanda', 'Pop Mart', 1700.00, 1600.00, 'PM-SKP-002', 'SKULLPANDA The Glimpse Figure', NULL, 18, 'Figurines', 'Blind Box', 'products/skullpanda2.jpg', 'In Stock', '2026-03-04 17:29:54', '2026-03-04 17:29:54', NULL),
(13, 'SKULLPANDA Club Man Figurine', 'Skullpanda', 'Pop Mart', 1700.00, 1600.00, 'PM-SKP-003', 'SKULLPANDA Club Man Figurine', NULL, 15, 'Figurines', 'Blind Box', 'products/skullpanda3.jpg', 'In Stock', '2026-03-04 17:29:54', '2026-03-04 17:29:54', NULL),
(14, 'CRYBABY BE MINE FIGURINE', 'Crybaby', 'Pop Mart', 7280.00, 7180.00, 'PM-CRY-001', 'CRYBABY BE MINE FIGURINE', NULL, 5, 'Figurines', 'Limited Edition', 'products/crybaby1.jpg', 'Low Stock', '2026-03-04 17:29:54', '2026-03-04 17:29:54', NULL),
(15, 'CRYBABY MAKE ME FLOAT FIGURE', 'Crybaby', 'Pop Mart', 1700.00, 1600.00, 'PM-CRY-002', 'CRYBABY MAKE ME FLOAT FIGURE', NULL, 14, 'Figurines', 'Blind Box', 'products/crybaby2.jpg', 'In Stock', '2026-03-04 17:29:54', '2026-03-04 17:29:54', NULL),
(16, 'Crybaby Coconut Figure-Brown', 'Crybaby', 'Pop Mart', 1700.00, 1600.00, 'PM-CRY-003', 'Crybaby Coconut Figure-Brown', NULL, 12, 'Figurines', 'Blind Box', 'products/crybaby3.jpg', 'In Stock', '2026-03-04 17:29:54', '2026-03-04 17:29:54', NULL),
(17, 'Crybaby Coconut Figure-Green', 'Crybaby', 'Pop Mart', 1700.00, 1600.00, 'PM-CRY-004', 'Crybaby Coconut Figure-Green', NULL, 11, 'Figurines', 'Blind Box', 'products/crybaby4.jpg', 'In Stock', '2026-03-04 17:29:54', '2026-03-04 17:29:54', NULL),
(18, 'LABUBU Hip-hop Girl Figure', 'The Monster', 'Pop Mart', 1700.00, 1600.00, 'PM-LAB-001', 'LABUBU Hip-hop Girl Figure', NULL, 25, 'Figurines', 'Blind Box', 'products/labubu1.jpg', 'In Stock', '2026-03-04 17:29:54', '2026-03-04 17:29:54', NULL),
(19, 'LABUBU Superstar Dance Moves Figure', 'The Monster', 'Pop Mart', 1700.00, 1600.00, 'PM-LAB-002', 'LABUBU Superstar Dance Moves Figure', NULL, 22, 'Figurines', 'Blind Box', 'products/labubu2.jpg', 'In Stock', '2026-03-04 17:29:54', '2026-03-04 17:29:54', NULL),
(20, 'THE MONSTERS_How to Train Your Dragon Figurine', 'The Monster', 'Pop Mart', 6000.00, 5900.00, 'PM-MON-001', 'THE MONSTERS_How to Train Your Dragon Figurine', NULL, 8, 'Figurines', 'Limited Edition', 'products/labubu3.jpg', 'Low Stock', '2026-03-04 17:29:54', '2026-03-04 17:29:54', NULL),
(21, 'PINO JELLY Chocolate Cookie Figurine', 'Pino Jelly', 'Pop Mart', 5000.00, 4900.00, 'PM-PIN-001', 'PINO JELLY Chocolate Cookie Figurine', NULL, 10, 'Figurines', 'Regular', 'products/pino1.jpg', 'Low Stock', '2026-03-04 17:29:54', '2026-03-04 17:29:54', NULL),
(22, 'PINO JELLY Birthday Bash Figurine', 'Pino Jelly', 'Pop Mart', 5000.00, 4900.00, 'PM-PIN-002', 'PINO JELLY Birthday Bash Figurine', NULL, 12, 'Figurines', 'Regular', 'products/pino2.jpg', 'In Stock', '2026-03-04 17:29:54', '2026-03-04 17:29:54', NULL),
(23, 'PINO JELLY Guess Who I am Figure', 'Pino Jelly', 'Pop Mart', 1700.00, 1600.00, 'PM-PIN-003', 'PINO JELLY Guess Who I am Figure', NULL, 18, 'Figurines', 'Blind Box', 'products/pino3.jpg', 'In Stock', '2026-03-04 17:29:54', '2026-03-04 17:29:54', NULL),
(24, 'PINO JELLY Fairyland Figurine', 'Pino Jelly', 'Pop Mart', 5000.00, 4900.00, 'PM-PIN-004', 'PINO JELLY Fairyland Figurine', NULL, 9, 'Figurines', 'Regular', 'products/pino4.jpg', 'Low Stock', '2026-03-04 17:29:54', '2026-03-04 17:29:54', NULL),
(25, 'Funko Marvel: Deadpool & Wolverine - Wolverine Pop! Vinyl Figure', 'Marvel', 'Funko', 695.00, 595.00, 'FK-MAR-001', 'Funko Marvel: Deadpool & Wolverine - Wolverine Pop! Vinyl Figure', NULL, 30, 'Figurines', 'Regular', 'products/funko1.jpg', 'In Stock', '2026-03-04 17:29:54', '2026-03-04 17:29:54', NULL),
(26, 'Funko Marvel: Deadpool & Wolverine - Deadpool Pop! Vinyl Figure', 'Marvel', 'Funko', 695.00, 595.00, 'FK-MAR-002', 'Funko Marvel: Deadpool & Wolverine - Deadpool Pop! Vinyl Figure', NULL, 28, 'Figurines', 'Regular', 'products/funko2.jpg', 'In Stock', '2026-03-04 17:29:54', '2026-03-04 17:29:54', NULL),
(27, 'Funko DC Comics Batman War Zone - The Joker War Joker Pop! Vinyl Figure', 'DC Comics', 'Funko', 695.00, 595.00, 'FK-DC-001', 'Funko DC Comics Batman War Zone - The Joker War Joker Pop! Vinyl Figure', NULL, 25, 'Figurines', 'Regular', 'products/funko3.jpg', 'In Stock', '2026-03-04 17:29:54', '2026-03-04 17:29:54', NULL),
(28, 'Funko Bleach Ichigo Kurosaki (FB Shikai) Funko Pop! Vinyl Figure', 'Anime', 'Funko', 695.00, 595.00, 'FK-ANI-001', 'Funko Bleach Ichigo Kurosaki (FB Shikai) Funko Pop! Vinyl Figure', NULL, 20, 'Figurines', 'Regular', 'products/funko4.jpg', 'In Stock', '2026-03-04 17:29:54', '2026-03-04 17:29:54', NULL),
(29, 'Funko Boruto: Naruto Next Generations Mirai Sarutobi Funko Pop! Vinyl Figure', 'Anime', 'Funko', 695.00, 595.00, 'FK-ANI-002', 'Funko Boruto: Naruto Next Generations Mirai Sarutobi Funko Pop! Vinyl Figure', NULL, 22, 'Figurines', 'Regular', 'products/funko5.jpg', 'In Stock', '2026-03-04 17:29:54', '2026-03-04 17:29:54', NULL),
(30, 'Funko Spider-Man 2 Game Miles Morales Upgraded Suit Funko Pop! Vinyl Figure', 'Games', 'Funko', 695.00, 595.00, 'FK-GAM-001', 'Funko Spider-Man 2 Game Miles Morales Upgraded Suit Funko Pop! Vinyl Figure', NULL, 18, 'Figurines', 'Regular', 'products/funko6.jpg', 'In Stock', '2026-03-04 17:29:54', '2026-03-04 17:29:54', NULL),
(31, 'Funko Demon Slayer Tengen Uzui Funko Pop! Vinyl Figure', 'Anime', 'Funko', 695.00, 595.00, 'FK-ANI-003', 'Funko Demon Slayer Tengen Uzui Funko Pop! Vinyl Figure', NULL, 24, 'Figurines', 'Regular', 'products/funko7.jpg', 'In Stock', '2026-03-04 17:29:54', '2026-03-04 17:29:54', NULL),
(32, 'Funko My Hero Academia Katsuki Bakugo Funko Pop! Vinyl Figure - Previews Exclusive', 'Anime', 'Funko', 1195.00, 1095.00, 'FK-ANI-004', 'Funko My Hero Academia Katsuki Bakugo Funko Pop! Vinyl Figure - Previews Exclusive', NULL, 12, 'Figurines', 'Limited Edition', 'products/funko8.jpg', 'In Stock', '2026-03-04 17:29:54', '2026-03-04 17:29:54', NULL),
(33, 'Funko Black Clover Asta with Nero Funko Pop! Vinyl Figure', 'Anime', 'Funko', 695.00, 595.00, 'FK-ANI-005', 'Funko Black Clover Asta with Nero Funko Pop! Vinyl Figure', NULL, 19, 'Figurines', 'Regular', 'products/funko9.jpg', 'In Stock', '2026-03-04 17:29:54', '2026-03-04 17:29:54', NULL),
(34, 'Funko One Piece Onami (Wano) Funko Pop! Vinyl Figure', 'Anime', 'Funko', 695.00, 595.00, 'FK-ANI-006', 'Funko One Piece Onami (Wano) Funko Pop! Vinyl Figure', NULL, 21, 'Figurines', 'Regular', 'products/funko10.jpg', 'In Stock', '2026-03-04 17:29:54', '2026-03-04 17:29:54', NULL);

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
('3ULCdNO14X4EKCeZCKC7oGxHPHrrMaAOXOWz9ISL', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoicFBydnRvN3dHMGhZZUJlaUp5UGczMVFIQWg0MjBaYVNDalpMU0d0VSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7czo1OiJyb3V0ZSI7czo0OiJob21lIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1772670467),
('8fVph5jbnzErzLnJ9PeFmvv5PVk5vFOwktRbyrVc', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoicnhzUVNadVJZQVkyT3RqdExmR0RVSWdxeTJTd1FvdHZHazVubXFZVCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9pbmRleC5waHAiO3M6NToicm91dGUiO3M6NDoiaG9tZSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==', 1772674426);

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
(1, 'admin', 'Admin', 'Administrator', 'admin@thepopstop.com', '1-878-393-8055', '4857 Wolff Drive Suite 905\nConnellyborough, TX 52932', NULL, 'admin', 1, '2026-02-26 16:30:26', '$2y$12$l9VIUHtx8LZPK5/wYOuiTO2EvO2bHU9CVAvWSx9WVUFy7CHKko7eK', '0SO8x6WZOVNwgZXjeyOg6nVbwhtXymB6wsJS5eUV4CHboyUdA1jicEfdii2v', '2026-02-26 16:30:26', '2026-02-26 16:30:26'),
(2, 'jiji', 'jihoon', 'Lee Jihoon', 'ji@gmail.com', '09123456789', 'Taguig', 'profiles/YSn0MeTAraqAVhXZnIQKl6LKEGQMLP13Y7W7Xivt.jpg', 'customer', 1, '2026-02-26 18:24:58', '$2y$12$a2XawdkmRHq1kKaSz7RgbON4WIp5y16QG/QvrrJJ6Su.7rAyFIC3G', NULL, '2026-02-26 18:07:42', '2026-02-26 18:24:58');

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `discounts`
--
ALTER TABLE `discounts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `product_photos`
--
ALTER TABLE `product_photos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `purchase_orders`
--
ALTER TABLE `purchase_orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `purchase_order_items`
--
ALTER TABLE `purchase_order_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

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
