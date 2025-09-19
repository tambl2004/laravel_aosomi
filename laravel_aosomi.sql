-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Sep 19, 2025 at 06:33 PM
-- Server version: 5.7.24
-- PHP Version: 8.3.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `laravel_aosomi`
--

-- --------------------------------------------------------

--
-- Table structure for table `addresses`
--

CREATE TABLE `addresses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `district` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ward` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_default` tinyint(1) NOT NULL DEFAULT '0',
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'home',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `addresses`
--

INSERT INTO `addresses` (`id`, `user_id`, `name`, `phone`, `address`, `city`, `district`, `ward`, `is_default`, `type`, `created_at`, `updated_at`) VALUES
(1, 2, 'Admin', '0123456789', '25a', 'ha noi', 'ha noi', 'ha noi', 1, 'home', '2025-09-19 11:18:53', '2025-09-19 11:18:53');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `carts`
--

CREATE TABLE `carts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `sort_order` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `slug`, `description`, `image`, `is_active`, `sort_order`, `created_at`, `updated_at`) VALUES
(1, 'Áo sơ mi nam', 'ao-so-mi-nam', 'Áo sơ mi nam cao cấp, phong cách công sở', 'https://product.hstatic.net/1000133495/product/10_60fa8eb3999741179b20d27bcce2317c_master.png', 1, 1, '2025-09-19 10:15:43', '2025-09-19 10:52:28'),
(2, 'Áo sơ mi nữ', 'ao-so-mi-nu', 'Áo sơ mi nữ thanh lịch, phù hợp mọi dịp', 'https://airui.store/wp-content/uploads/2024/06/Ao-so-mi-nu-coc-tay-dang-rong-khau-tum-sau-1.jpg', 1, 2, '2025-09-19 10:15:43', '2025-09-19 10:52:11'),
(3, 'Áo sơ mi trẻ em', 'ao-so-mi-tre-em', 'Áo sơ mi trẻ em chất lượng cao, thoải mái', 'https://product.hstatic.net/1000290074/product/rabity9651_copy_86b05413b38443cca8f1151300649adb_grande.jpg', 1, 3, '2025-09-19 10:15:43', '2025-09-19 10:53:11'),
(4, 'Áo sơ mi thể thao', 'ao-so-mi-the-thao', 'Áo sơ mi thể thao co giãn, thấm hút mồ hôi', 'https://cdn.storims.com/api/v2/image/resize?path=https://storage.googleapis.com/storims_cdn/storims/uploads/69ffeef30de7d04cb921923ea98c3fd9.jpeg&format=jpeg', 1, 4, '2025-09-19 10:15:43', '2025-09-19 10:53:29'),
(5, 'Áo sơ mi cao cấp', 'ao-so-mi-cao-cap', 'Áo sơ mi cao cấp, chất liệu premium', 'https://cdn.storims.com/api/v2/image/resize?path=https://storage.googleapis.com/storims_cdn/storims/uploads/69ffeef30de7d04cb921923ea98c3fd9.jpeg&format=jpeg', 1, 5, '2025-09-19 10:15:43', '2025-09-19 10:53:34');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
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
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
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
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_09_19_154536_add_role_and_email_verification_to_users_table', 1),
(5, '2025_09_19_161141_create_categories_table', 1),
(6, '2025_09_19_171258_create_products_table', 1),
(7, '2025_09_19_173030_update_products_table_remove_unnecessary_fields', 2),
(8, '2025_09_19_175551_create_wishlists_table', 3),
(9, '2025_09_19_175555_create_carts_table', 3),
(10, '2025_09_19_180438_create_orders_table', 4),
(11, '2025_09_19_180442_create_order_items_table', 4),
(12, '2025_09_19_181553_create_addresses_table', 5);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `customer_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_address` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_city` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_district` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_ward` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  `shipping_fee` decimal(10,2) NOT NULL DEFAULT '0.00',
  `total_amount` decimal(10,2) NOT NULL,
  `payment_method` enum('cod','bank_transfer','momo','zalopay') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'cod',
  `status` enum('pending','confirmed','processing','shipped','delivered','cancelled') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `notes` text COLLATE utf8mb4_unicode_ci,
  `admin_notes` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `order_number`, `user_id`, `customer_name`, `customer_email`, `customer_phone`, `customer_address`, `customer_city`, `customer_district`, `customer_ward`, `subtotal`, `shipping_fee`, `total_amount`, `payment_method`, `status`, `notes`, `admin_notes`, `created_at`, `updated_at`) VALUES
(1, 'ORD202509190001', 2, 'Admin', 'admin@gmail.com', '0123456789', '25a', 'ha noi', 'ha noi', 'ha noi', 750000.00, 0.00, 750000.00, 'cod', 'delivered', NULL, NULL, '2025-09-19 11:21:22', '2025-09-19 11:21:40');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `product_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `product_price` decimal(10,2) NOT NULL,
  `quantity` int(11) NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `product_name`, `product_image`, `product_price`, `quantity`, `total_price`, `created_at`, `updated_at`) VALUES
(1, 1, 4, 'Áo Sơ Mi Nam Kẻ Sọc', 'https://pos.nvncdn.com/492284-9176/ps/20241218_YTf7BwIvOW.jpeg?v=1734509951', 400000.00, 1, 400000.00, '2025-09-19 11:21:22', '2025-09-19 11:21:22'),
(2, 1, 5, 'Áo Sơ Mi Nam Họa Tiết', 'https://images.unsplash.com/photo-1617137984095-74e4e5e3613f?q=80&w=1974&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D', 350000.00, 1, 350000.00, '2025-09-19 11:21:22', '2025-09-19 11:21:22');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `content` longtext COLLATE utf8mb4_unicode_ci,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `stock` int(11) NOT NULL DEFAULT '0',
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `is_featured` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `slug`, `description`, `content`, `image`, `price`, `stock`, `category_id`, `is_active`, `is_featured`, `created_at`, `updated_at`) VALUES
(1, 'Áo Sơ Mi Nam Công Sở Cao Cấp', 'ao-so-mi-nam-cong-so-cao-cap', 'Áo sơ mi nam lịch lãm, chất liệu cotton cao cấp, thoáng mát, chống nhăn. Phù hợp cho môi trường công sở và các sự kiện quan trọng.', 'Thiết kế ôm vừa vặn, tôn dáng. Cổ áo cứng cáp, đường may tỉ mỉ. Dễ dàng phối hợp với quần tây, quần kaki.', 'https://product.hstatic.net/200000690725/product/tb920_a04cd3c42ae9458e9207fdccaf7bed48.png', 450000.00, 100, 1, 1, 0, '2025-09-19 10:32:36', '2025-09-19 10:38:35'),
(2, 'Áo Sơ Mi Nam Trắng Tinh Tế2', 'ao-so-mi-nam-trang-tinh-te2', 'Áo sơ mi nam màu trắng tinh tế, chất liệu cotton mềm mại, thiết kế đơn giản nhưng sang trọng.', 'Thiết kế cổ điển với cổ áo kiểu classic, phù hợp cho nhiều dịp khác nhau từ công sở đến các sự kiện quan trọng.', 'https://product.hstatic.net/1000360022/product/ao-so-mi-trang-nam_d173696d6c7a415c8401fd80d5d6fd90_grande.jpg', 380000.00, 80, 1, 1, 0, '2025-09-19 10:32:36', '2025-09-19 10:48:13'),
(3, 'Áo Sơ Mi Nam Xanh Navy', 'ao-so-mi-nam-xanh-navy', 'Áo sơ mi nam màu xanh navy thanh lịch, chất liệu cotton cao cấp, thiết kế hiện đại.', 'Màu xanh navy sang trọng, dễ dàng phối hợp với nhiều trang phục khác nhau. Chất liệu cotton thoáng mát.', 'https://images.unsplash.com/photo-1596755094514-f87e34085b2c?q=80&w=1974&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D', 420000.00, 60, 1, 1, 1, '2025-09-19 10:32:36', '2025-09-19 10:32:36'),
(4, 'Áo Sơ Mi Nam Kẻ Sọc', 'ao-so-mi-nam-ke-soc', 'Áo sơ mi nam kẻ sọc tinh tế, thiết kế độc đáo, chất liệu cotton cao cấp.', 'Thiết kế kẻ sọc tạo điểm nhấn, phù hợp cho những người yêu thích phong cách cá tính và hiện đại.', 'https://pos.nvncdn.com/492284-9176/ps/20241218_YTf7BwIvOW.jpeg?v=1734509951', 400000.00, 44, 1, 1, 0, '2025-09-19 10:32:36', '2025-09-19 11:21:22'),
(5, 'Áo Sơ Mi Nam Họa Tiết', 'ao-so-mi-nam-hoa-tiet', 'Áo sơ mi nam có họa tiết nhẹ nhàng, thiết kế trẻ trung, chất liệu cotton mềm mại.', 'Họa tiết tinh tế tạo sự khác biệt, phù hợp cho những dịp không quá trang trọng.', 'https://images.unsplash.com/photo-1617137984095-74e4e5e3613f?q=80&w=1974&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D', 350000.00, 69, 1, 1, 0, '2025-09-19 10:32:36', '2025-09-19 11:21:22'),
(6, 'Áo Sơ Mi Nữ Công Sở Thanh Lịch', 'ao-so-mi-nu-cong-so-thanh-lich', 'Áo sơ mi nữ công sở với thiết kế thanh lịch, chất liệu cotton cao cấp, phù hợp cho môi trường làm việc.', 'Thiết kế tôn dáng, cổ áo kiểu classic, tay dài. Chất liệu cotton thoáng mát, dễ chăm sóc.', 'https://airui.store/wp-content/uploads/2024/06/Ao-so-mi-nu-coc-tay-dang-rong-khau-tum-sau-1.jpg', 420000.00, 90, 2, 1, 0, '2025-09-19 10:32:36', '2025-09-19 10:48:49'),
(7, 'Áo Sơ Mi Nữ Trắng Tinh Khôi2', 'ao-so-mi-nu-trang-tinh-khoi2', 'Áo sơ mi nữ màu trắng tinh khôi, thiết kế đơn giản nhưng sang trọng, chất liệu cotton mềm mại.', 'Màu trắng tinh khôi tạo vẻ thanh lịch, phù hợp cho nhiều dịp khác nhau.', 'https://product.hstatic.net/200000690725/product/tb920_a04cd3c42ae9458e9207fdccaf7bed48.png', 380000.00, 75, 2, 1, 0, '2025-09-19 10:32:36', '2025-09-19 10:39:02'),
(8, 'Áo Sơ Mi Nữ Xanh Pastel', 'ao-so-mi-nu-xanh-pastel', 'Áo sơ mi nữ màu xanh pastel nhẹ nhàng, thiết kế nữ tính, chất liệu cotton cao cấp.', 'Màu xanh pastel tạo cảm giác dịu nhẹ, phù hợp cho những người yêu thích phong cách nhẹ nhàng.', 'https://airui.store/wp-content/uploads/2024/06/Ao-so-mi-nu-coc-tay-dang-rong-khau-tum-sau-1.jpg', 400000.00, 65, 2, 1, 1, '2025-09-19 10:32:36', '2025-09-19 10:48:57'),
(9, 'Áo Sơ Mi Nữ Hoa Nhí', 'ao-so-mi-nu-hoa-nhi', 'Áo sơ mi nữ có họa tiết hoa nhí tinh tế, thiết kế nữ tính, chất liệu cotton mềm mại.', 'Họa tiết hoa nhí tạo sự nữ tính và trẻ trung, phù hợp cho những dịp không quá trang trọng.', 'https://airui.store/wp-content/uploads/2024/06/Ao-so-mi-nu-coc-tay-dang-rong-khau-tum-sau-1.jpg', 360000.00, 55, 2, 1, 0, '2025-09-19 10:32:36', '2025-09-19 10:49:04'),
(10, 'Áo Sơ Mi Nữ Tay Ngắn', 'ao-so-mi-nu-tay-ngan', 'Áo sơ mi nữ tay ngắn thoải mái, thiết kế trẻ trung, chất liệu cotton thoáng mát.', 'Thiết kế tay ngắn phù hợp cho thời tiết nóng, tạo cảm giác thoải mái và năng động.', 'https://airui.store/wp-content/uploads/2024/06/Ao-so-mi-nu-coc-tay-dang-rong-khau-tum-sau-1.jpg', 320000.00, 85, 2, 1, 1, '2025-09-19 10:32:36', '2025-09-19 10:49:12');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('FAOUbhFJLfVF6DRVSRR8soVTW362taT7BaFWwlvo', 2, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoibmNlR2Zjajc5N1FvWkVsYTB2b3h2T1daWEJOVXNBUmlLVjJkeEtFTSI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czozNjoiaHR0cDovLzEyNy4wLjAuMTo4MDAwL2FkbWluL3Byb2R1Y3RzIjt9czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6ODc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9yZXBvcnRzP2VuZF9kYXRlPTIwMjUtMDktMjAmcGVyaW9kPTMwJnN0YXJ0X2RhdGU9MjAyNS0wOC0yMSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjI7fQ==', 1758306754);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('admin','user') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `role`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Test User', 'test@example.com', 'user', '2025-09-19 10:15:42', '$2y$12$c4Mnt9ZTReaJAMI0ggZJVuUw.PFAa.n0z7Fe/jkJ3ro6.hi/s5yrW', '0Flyw5bhX9', '2025-09-19 10:15:43', '2025-09-19 10:15:43'),
(2, 'Admin', 'admin@gmail.com', 'admin', '2025-09-19 10:15:43', '$2y$12$kRmj2jAr.Wd56qRNZsFnNuRLaNwtb5GlDqOpPGEPewI/pJqBfJDSS', NULL, '2025-09-19 10:15:43', '2025-09-19 10:15:43');

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
-- Indexes for table `addresses`
--
ALTER TABLE `addresses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `addresses_user_id_foreign` (`user_id`);

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
  ADD UNIQUE KEY `carts_user_id_product_id_unique` (`user_id`,`product_id`),
  ADD KEY `carts_user_id_index` (`user_id`),
  ADD KEY `carts_product_id_index` (`product_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `categories_slug_unique` (`slug`);

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
  ADD UNIQUE KEY `orders_order_number_unique` (`order_number`),
  ADD KEY `orders_user_id_index` (`user_id`),
  ADD KEY `orders_status_index` (`status`),
  ADD KEY `orders_created_at_index` (`created_at`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_items_order_id_index` (`order_id`),
  ADD KEY `order_items_product_id_index` (`product_id`);

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
  ADD UNIQUE KEY `products_slug_unique` (`slug`),
  ADD KEY `products_is_active_is_featured_index` (`is_active`,`is_featured`),
  ADD KEY `products_category_id_is_active_index` (`category_id`,`is_active`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `wishlists`
--
ALTER TABLE `wishlists`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `wishlists_user_id_product_id_unique` (`user_id`,`product_id`),
  ADD KEY `wishlists_user_id_index` (`user_id`),
  ADD KEY `wishlists_product_id_index` (`product_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `addresses`
--
ALTER TABLE `addresses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `carts`
--
ALTER TABLE `carts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `wishlists`
--
ALTER TABLE `wishlists`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `addresses`
--
ALTER TABLE `addresses`
  ADD CONSTRAINT `addresses_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `carts`
--
ALTER TABLE `carts`
  ADD CONSTRAINT `carts_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `carts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

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
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;

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
