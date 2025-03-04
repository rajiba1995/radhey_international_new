-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 14, 2025 at 10:13 AM
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
-- Database: `radhey_international_crm`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `about` text DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `branches`
--

CREATE TABLE `branches` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `mobile` varchar(255) DEFAULT NULL,
  `whatsapp` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `branches`
--

INSERT INTO `branches` (`id`, `name`, `address`, `mobile`, `whatsapp`, `email`, `city`, `created_at`, `updated_at`) VALUES
(1, 'Branch 2', 'Kolkata', '9064956744', '345678345', 'branch@gmail.com', 'Kolkata', '2025-01-30 04:35:01', '2025-01-30 04:49:35');

-- --------------------------------------------------------

--
-- Table structure for table `business_types`
--

CREATE TABLE `business_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `catalogues`
--

CREATE TABLE `catalogues` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `catalogue_title_id` int(20) NOT NULL,
  `page_number` int(11) NOT NULL,
  `image` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `catalogues`
--

INSERT INTO `catalogues` (`id`, `catalogue_title_id`, `page_number`, `image`, `created_at`, `updated_at`) VALUES
(1, 1, 20, 'catalogue_pdfs/1738679630.pdf', '2025-02-04 09:03:50', '2025-02-04 09:03:50'),
(2, 2, 11, 'catalogue_pdfs/1739522851.pdf', '2025-02-14 03:17:31', '2025-02-14 03:17:31'),
(3, 3, 12, 'catalogue_pdfs/1739522869.pdf', '2025-02-14 03:17:49', '2025-02-14 03:17:49');

-- --------------------------------------------------------

--
-- Table structure for table `catalogue_titles`
--

CREATE TABLE `catalogue_titles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `catalogue_titles`
--

INSERT INTO `catalogue_titles` (`id`, `title`, `created_at`, `updated_at`) VALUES
(1, 'C1', '2025-01-29 02:03:06', '2025-01-29 02:03:06'),
(2, 'C2', '2025-01-29 02:03:06', '2025-01-29 02:03:06'),
(3, 'C3', '2025-01-29 02:03:06', '2025-01-29 02:03:06');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `collection_id` bigint(20) UNSIGNED DEFAULT NULL,
  `short_code` varchar(255) DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1: Active, 0: Inactive',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `collection_id`, `short_code`, `title`, `image`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, '1234', 'suiting', 'storage/category_image/7V1WVEzx8WJ89y5cUfetvAyzy7qWH7anlFmsHhpy.png', 1, '2025-01-29 07:34:22', '2025-02-07 04:20:34', NULL),
(2, 2, '4567', 'items product', 'storage/category_image/EBy5FfhlVFuzl1kl5lIdjH2sqjgVqYPceDMJglkU.png', 1, '2025-01-29 07:34:50', '2025-02-06 01:35:18', NULL),
(3, 4, '2345', 'siezer', 'storage/category_image/2SA1EjALcrq6g3S4bKRsIEHzsyv0n5z7iKzOQcfs.png', 1, '2025-02-03 02:21:07', '2025-02-06 01:35:31', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `cities`
--

CREATE TABLE `cities` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cities`
--

INSERT INTO `cities` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Kolkata', '2024-12-23 04:35:42', '2024-12-23 04:35:42'),
(2, 'New York', '2024-12-23 05:57:51', '2024-12-23 05:57:51'),
(3, 'Bhola', '2024-12-23 06:20:10', '2024-12-23 06:20:10'),
(4, 'sfsdff', '2024-12-23 06:25:26', '2024-12-23 06:25:26'),
(5, 'Kolkata2', '2024-12-23 06:39:52', '2024-12-23 06:39:52');

-- --------------------------------------------------------

--
-- Table structure for table `city_user`
--

CREATE TABLE `city_user` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `city_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `collections`
--

CREATE TABLE `collections` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `collections`
--

INSERT INTO `collections` (`id`, `title`, `created_at`, `updated_at`) VALUES
(1, 'GARMENT', '2024-12-24 01:40:05', '2024-12-24 09:07:19'),
(2, 'GARMENT ITEMS', '2024-12-24 03:50:03', '2024-12-24 09:07:26'),
(4, 'RAW MATERIALS', '2024-12-24 03:50:03', '2024-12-24 09:07:26');

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE `countries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`id`, `title`, `created_at`, `updated_at`) VALUES
(1, 'India', '2025-01-28 03:09:11', '2025-01-28 03:09:11'),
(2, 'South Africa', '2025-01-28 03:09:11', '2025-01-28 03:09:11');

-- --------------------------------------------------------

--
-- Table structure for table `designation`
--

CREATE TABLE `designation` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `designation`
--

INSERT INTO `designation` (`id`, `name`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Super Admin', 1, '2024-12-16 07:23:00', '2024-12-16 07:23:24'),
(2, 'Salesman', 1, '2024-12-17 03:18:56', '2024-12-19 09:31:40');

-- --------------------------------------------------------

--
-- Table structure for table `expences`
--

CREATE TABLE `expences` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `parent_id` bigint(20) UNSIGNED DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `for_debit` tinyint(1) NOT NULL DEFAULT 0,
  `for_credit` tinyint(1) NOT NULL DEFAULT 0,
  `for_staff` tinyint(1) NOT NULL DEFAULT 0,
  `for_store` tinyint(1) NOT NULL DEFAULT 0,
  `for_partner` tinyint(1) NOT NULL DEFAULT 0,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fabrics`
--

CREATE TABLE `fabrics` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `collection_id` bigint(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `threshold_price` decimal(10,2) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `fabrics`
--

INSERT INTO `fabrics` (`id`, `collection_id`, `title`, `threshold_price`, `image`, `status`, `created_at`, `updated_at`) VALUES
(2, 1, 'Wonder 1', 1000.00, NULL, 1, '2025-01-22 04:28:57', '2025-01-22 04:28:57'),
(3, 1, 'Wonder 2', 2000.00, NULL, 1, '2025-01-22 04:29:12', '2025-01-22 04:29:12'),
(4, 1, 'Wonder 3', 3000.00, NULL, 1, '2025-01-22 04:29:59', '2025-01-22 04:29:59');

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
-- Table structure for table `galleries`
--

CREATE TABLE `galleries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `image` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `invoices`
--

CREATE TABLE `invoices` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED DEFAULT NULL,
  `customer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL COMMENT 'order placed by whom or staff_id',
  `packingslip_id` bigint(20) UNSIGNED DEFAULT NULL,
  `invoice_no` varchar(255) DEFAULT NULL,
  `net_price` double NOT NULL COMMENT 'total amount',
  `required_payment_amount` double NOT NULL,
  `payment_status` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0:pending;1:half_paid;2:full_paid',
  `is_paid` tinyint(1) NOT NULL DEFAULT 0,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `invoice_payments`
--

CREATE TABLE `invoice_payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `invoice_id` bigint(20) UNSIGNED DEFAULT NULL,
  `payment_collection_id` bigint(20) UNSIGNED DEFAULT NULL,
  `invoice_amount` double NOT NULL COMMENT 'invoice''s net amount',
  `vouchar_amount` double NOT NULL,
  `paid_amount` double NOT NULL COMMENT 'payment amount',
  `rest_amount` double NOT NULL,
  `is_commisionable` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'for staff',
  `invoice_no` varchar(255) DEFAULT NULL,
  `voucher_no` varchar(255) DEFAULT NULL COMMENT 'payment_receipt',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `journals`
--

CREATE TABLE `journals` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `payment_id` bigint(20) UNSIGNED DEFAULT NULL,
  `transaction_amount` double NOT NULL,
  `is_credit` tinyint(1) NOT NULL DEFAULT 0,
  `is_debit` tinyint(1) NOT NULL DEFAULT 0,
  `bank_cash` varchar(255) NOT NULL DEFAULT 'bank',
  `purpose` varchar(255) DEFAULT NULL,
  `purpose_description` text DEFAULT NULL,
  `purpose_id` varchar(255) DEFAULT NULL COMMENT 'invoice_no / voucher_no',
  `entry_date` date DEFAULT NULL,
  `is_gst` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ledgers`
--

CREATE TABLE `ledgers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_type` enum('staff','customer','partner','supplier') NOT NULL DEFAULT 'staff',
  `staff_id` bigint(20) UNSIGNED DEFAULT NULL,
  `customer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `supplier_id` bigint(20) UNSIGNED DEFAULT NULL,
  `admin_id` bigint(20) UNSIGNED DEFAULT NULL,
  `payment_id` bigint(20) UNSIGNED DEFAULT NULL,
  `staff_commision_id` bigint(20) UNSIGNED DEFAULT NULL,
  `collection_staff_commission_id` bigint(20) UNSIGNED DEFAULT NULL,
  `store_bad_debt_id` bigint(20) UNSIGNED DEFAULT NULL,
  `transaction_id` varchar(244) DEFAULT NULL COMMENT 'invoice_no / voucher_no',
  `transaction_amount` double NOT NULL,
  `is_credit` tinyint(1) NOT NULL DEFAULT 0,
  `is_debit` tinyint(1) NOT NULL DEFAULT 0,
  `bank_cash` enum('bank','cash') NOT NULL DEFAULT 'bank',
  `entry_date` date DEFAULT NULL,
  `purpose` varchar(255) DEFAULT NULL,
  `purpose_description` text DEFAULT NULL,
  `start_date` datetime DEFAULT NULL,
  `whatsapp_status` int(11) NOT NULL DEFAULT 0 COMMENT '0:Pending, 1:Sent, 2: Cancel',
  `last_whatsapp` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ledgers`
--

INSERT INTO `ledgers` (`id`, `user_type`, `staff_id`, `customer_id`, `supplier_id`, `admin_id`, `payment_id`, `staff_commision_id`, `collection_staff_commission_id`, `store_bad_debt_id`, `transaction_id`, `transaction_amount`, `is_credit`, `is_debit`, `bank_cash`, `entry_date`, `purpose`, `purpose_description`, `start_date`, `whatsapp_status`, `last_whatsapp`, `created_at`, `updated_at`) VALUES
(1, 'supplier', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 'GRN-20250213092004000', 999, 1, 0, 'bank', '2025-02-13', 'goods_received_note', 'Goods Received Note', NULL, 0, NULL, '2025-02-13 03:50:04', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `measurements`
--

CREATE TABLE `measurements` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `short_code` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `position` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `measurements`
--

INSERT INTO `measurements` (`id`, `product_id`, `title`, `short_code`, `status`, `position`, `created_at`, `updated_at`) VALUES
(1, 1, 'FRONT', 'FRT', 1, 16, '2024-12-17 05:25:28', '2024-12-20 07:55:22'),
(2, 1, 'CHEST', 'CST', 1, 17, '2024-12-17 05:25:41', '2024-12-20 07:55:22'),
(3, 1, 'AFTER CHEST', 'AF CST', 1, 19, '2024-12-17 05:25:54', '2024-12-20 07:55:22'),
(4, 1, 'STOMACH', 'STM', 1, 21, '2024-12-17 05:26:06', '2024-12-20 07:55:22'),
(5, 1, 'WAIST', 'WST ', 1, 20, '2024-12-17 05:26:16', '2024-12-20 07:55:22'),
(11, 1, 'JACKET LENGTH', 'J/L', 1, 6, '2024-12-17 05:27:44', '2024-12-20 07:55:22'),
(12, 1, 'MUSCLE', 'MSL', 1, 7, '2024-12-17 05:27:52', '2024-12-20 07:55:22'),
(13, 1, 'WRIST', 'WRT', 1, 8, '2024-12-17 05:28:25', '2024-12-20 07:55:22'),
(14, 1, 'TROUSER LENGTH', 'T/L', 1, 9, '2024-12-17 05:28:36', '2024-12-20 07:55:22'),
(15, 1, 'BIG INSEAM', 'INS (B)', 1, 10, '2024-12-17 05:28:48', '2024-12-20 07:55:22'),
(16, 1, 'SHORT INSEAM', 'INS (S)', 1, 11, '2024-12-17 05:30:06', '2024-12-20 07:55:22'),
(17, 1, 'CROTCH', 'CRT', 1, 12, '2024-12-17 05:30:14', '2024-12-20 07:55:22'),
(18, 1, 'THIGH', 'THG', 1, 13, '2024-12-17 05:30:25', '2024-12-20 07:55:22'),
(19, 1, 'KNEE', 'KNE', 1, 15, '2024-12-17 05:30:32', '2024-12-20 07:55:22'),
(20, 1, 'BOTTOM', 'BTM', 1, 14, '2024-12-17 05:30:44', '2024-12-20 07:55:22'),
(21, 1, 'COLLAR', 'COL', 1, 18, '2024-12-17 05:31:00', '2024-12-20 07:55:22'),
(24, 4, 'test', '1234', 1, 0, '2024-12-20 09:04:31', '2024-12-20 09:04:31');

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
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2024_12_02_131444_create_admins_table', 1),
(6, '2024_12_03_092854_add_columns_to_users_table', 1),
(7, '2024_12_03_093500_create_user_address_table', 1),
(8, '2024_12_03_105253_create_categories_table', 1),
(9, '2024_12_04_060453_create_table_sub_categories', 1),
(10, '2024_12_04_105816_create_products_table', 1),
(11, '2024_12_06_111251_create_suppliers_table', 1),
(12, '2024_12_06_142443_add_status_to_products_table', 1),
(13, '2024_12_09_101636_create_designation_table', 1),
(14, '2024_12_09_102526_create_roles_table', 1),
(15, '2024_12_09_105754_create_user_roles_table', 1),
(16, '2024_12_09_131331_add_designation_name_to_users_table', 1),
(17, '2024_12_10_093804_add_aadhar_number_to_users_table', 1),
(18, '2024_12_10_094627_create_user_banks_table', 1),
(19, '2024_12_10_100052_add_user_id_font_to_users_table', 1),
(20, '2024_12_10_130733_add_status_to_table_name', 1),
(21, '2024_12_11_114529_update_users_table', 1),
(22, '2024_12_12_104709_add_company_name_users', 1),
(23, '2024_12_12_114249_update_landmark_in_user_address', 1),
(24, '2024_12_12_115559_add_image_and_video_to_users_table', 1),
(25, '2024_12_12_132930_update_profile_image_in_users', 1),
(26, '2024_12_13_091915_update_hsn_code_in_products_table', 1),
(27, '2024_12_13_102134_drop_column_from_suppliers_table', 1),
(28, '2024_12_16_131344_modify_profile_image_in_users_table', 2),
(29, '2024_12_16_082818_create_measurments_table', 3),
(30, '2024_12_16_114526_create_expences_table', 3),
(31, '2024_12_17_094645_add_user_type_to_users_table', 4),
(32, '2024_12_17_144303_add_dob_to_users_table', 5),
(33, '2024_12_17_124141_create_fabrics_table', 6),
(34, '2024_12_17_133651_update_password_addhar_name_nullable_in_users_table', 6),
(35, '2024_12_18_143107_create_galleries_table', 7),
(36, '2024_12_18_143944_add_image_to_categories_table', 7),
(37, '2024_12_19_103432_change_deleted_at_in_products_table', 8),
(38, '2024_12_20_103022_create_collection_types_table', 9),
(40, '2024_12_20_121259_add_collection_id_to_products_table', 11),
(41, '2024_12_20_123154_modify_sub_category_id_in_products_table', 12),
(42, '2024_12_20_131031_rename_subcategory_id_to_product_id_in_measurements_table', 13),
(43, '2024_12_20_065209_update_fabrics_table', 14),
(44, '2024_12_19_102933_create_collections_table', 15),
(45, '2024_12_19_103022_create_collection_types_table', 16),
(46, '2024_12_22_060555_create_cities_table', 17),
(47, '2024_12_22_132636_create_orders_table', 17),
(48, '2024_12_22_132805_create_order_items_table', 17),
(49, '2024_12_22_132839_create_order_measurements_table', 17),
(50, '2024_12_23_103225_create_city_user_table', 18),
(51, '2024_12_23_150414_add_employee_rank_column_to_users_table', 19),
(53, '2024_12_23_125126_add_columns_to_orders_table', 20),
(54, '2024_12_24_071336_add_collection_id_and_short_code_to_categories_table', 20),
(59, '2024_12_24_065427_remove_column_from_collections_table', 21),
(60, '2024_12_26_070749_add_customer_id_to_orders_table', 22),
(61, '2024_12_26_075437_update_columns_in_order_items_table', 23),
(63, '2025_01_07_080829_create_ledgers_table', 24),
(65, '2025_01_08_105303_add_created_by_to_orders_table', 25),
(66, '2025_01_09_065300_update_payment_method_column_in_ledger_table', 26),
(67, '2025_01_15_140025_update_fabrics_table', 26),
(68, '2025_01_15_144149_create_product_fabrics_table', 26),
(69, '2025_01_20_092357_create_product_images_table', 27),
(74, '2025_01_21_081330_create_purchase_orders_table', 28),
(75, '2025_01_21_082539_create_purchase_order_products_table', 28),
(76, '2025_01_22_083454_create_otps_table', 28),
(78, '2025_01_23_095707_create_stocks_table', 29),
(79, '2025_01_23_100913_create_stock_products_table', 30),
(80, '2025_01_23_101941_create_stock_fabrics_table', 31),
(81, '2025_01_28_083042_create_countries_table', 32),
(82, '2025_01_28_091844_add_country_id_to_users_table', 33),
(83, '2025_01_28_102948_update_users_table_for_passport_columns', 34),
(84, '2025_01_28_123512_create_catalogues_table', 35),
(86, '2025_01_28_123512_create_catalogs_table', 36),
(90, '2025_01_28_130059_create_catalog_titles_table', 37),
(91, '2025_01_28_142647_rename_title_to_catalogue_title_id_in_catalogues_table', 38),
(92, '2025_01_29_094213_create_business_types_table', 38),
(93, '2025_01_29_110148_add_emergency_contact_to_users_table', 39),
(95, '2025_01_30_084237_create_branches_table', 40),
(96, '2025_01_30_102716_add_branch_id_to_users_table', 41),
(98, '2025_02_05_105404_add_columns_to_ledgers_table', 42),
(99, '2025_02_06_110657_remove_column_from_ledgers_table', 43),
(100, '2025_01_22_112054_add_expires_at_to_personal_access_tokens_table', 44),
(101, '2025_01_23_111905_add_otp_verification_mpin_ip_address_to_users_table', 44),
(102, '2025_01_27_074352_create_business_type_table', 45),
(103, '2025_01_27_075002_add_business_type_to_orders_table', 46),
(104, '2025_01_29_072617_add_business_type_to_users_table', 46),
(106, '2025_01_29_105949_add_employee_id_to_otps_table', 47),
(110, '2025_02_05_115601_create_payments_table', 48),
(111, '2025_02_07_070524_update_state_nullable_in_user_address_table', 49),
(112, '2025_02_06_123001_add_stuff_id_and_image_to_payments_table', 50),
(113, '2025_02_11_1334056_create_invoices_table', 50),
(114, '2025_02_11_134005_create_packing_slips_table', 50),
(115, '2025_02_11_135122_create_payment_collections_table', 50),
(116, '2025_02_11_135929_create_ledgers_table', 51),
(117, '2025_02_11_143841_create_journals_table', 51),
(120, '2025_02_12_070236_add_column_qty_while_grn_to_stock_fabrics_table', 52),
(121, '2025_02_12_070434_add_column_qty_while_grn_to_stock_products_table', 52),
(122, '2025_02_12_075421_add_column_qty_while_grn_to_purchase_order_products_table', 53),
(123, '2025_02_11_114056_update_status_enum_in_orders_table', 54),
(124, '2025_02_11_114153_update_status_enum_in_orders_table', 54),
(125, '2025_02_12_072417_update_payments_table', 55),
(126, '2025_02_12_093445_create_invoice_payments_table', 55),
(127, '2025_02_13_094245_create_payment_revokes_table', 56);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `business_type` bigint(20) UNSIGNED DEFAULT NULL,
  `customer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `order_number` varchar(255) NOT NULL,
  `customer_name` varchar(255) DEFAULT NULL,
  `customer_email` varchar(255) DEFAULT NULL,
  `billing_address` varchar(255) DEFAULT NULL,
  `shipping_address` varchar(255) DEFAULT NULL,
  `total_amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` enum('Pending','Confirmed','In Production','Ready for Delivery','Shipped','Delivered','Cancelled','Returned') NOT NULL DEFAULT 'Pending',
  `paid_amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `remaining_amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `last_payment_date` timestamp NULL DEFAULT NULL,
  `payment_mode` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `business_type`, `customer_id`, `created_by`, `order_number`, `customer_name`, `customer_email`, `billing_address`, `shipping_address`, `total_amount`, `created_at`, `updated_at`, `status`, `paid_amount`, `remaining_amount`, `last_payment_date`, `payment_mode`) VALUES
(1, NULL, 16, 1, '15', 'Souvik Mandal', '', 'Kolkata user11, Newtown bus stand, Kolkata11, , India - 700159', 'Kolkata user11, Newtown bus stand, Kolkata11, , India - 700159', 1234.00, '2025-02-06 07:36:31', '2025-02-07 07:23:13', 'Pending', 1234.00, 0.00, '2025-02-07 04:47:37', 'Cash'),
(4, NULL, 16, 17, '16', 'Souvik Mandal', '', 'Kolkata user11, Newtown bus stand, Kolkata11, , India - 700159', 'Kolkata user11, Newtown bus stand, Kolkata11, , India - 700159', 3000.00, '2025-02-07 08:24:36', '2025-02-07 08:31:02', 'Pending', 3000.00, 0.00, '2025-02-06 18:30:00', 'Cash'),
(5, NULL, 16, 17, '17', 'Souvik Mandal', '', 'Kolkata user11, Newtown bus stand, Kolkata11, , India - 700159', 'Kolkata user11, Newtown bus stand, Kolkata11, , India - 700159', 3000.00, '2025-02-07 09:42:14', '2025-02-07 09:42:14', 'Pending', 2222.00, 778.00, '2025-02-07 09:42:14', 'Online'),
(6, NULL, 16, 17, '18', 'Souvik Mandal', '', 'Kolkata user11, Newtown bus stand, Kolkata11, , India - 700159', 'Kolkata user11, Newtown bus stand, Kolkata11, , India - 700159', 222.00, '2025-02-10 09:00:18', '2025-02-10 09:00:18', 'Pending', 222.00, 0.00, '2025-02-10 09:00:18', 'Cash');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `catalogue_id` bigint(20) DEFAULT NULL,
  `cat_page_number` varchar(255) DEFAULT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `collection` varchar(255) NOT NULL,
  `fabrics` varchar(255) DEFAULT NULL,
  `category` int(11) DEFAULT NULL,
  `sub_category` varchar(255) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `product_name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `catalogue_id`, `cat_page_number`, `order_id`, `product_id`, `collection`, `fabrics`, `category`, `sub_category`, `quantity`, `product_name`, `price`, `created_at`, `updated_at`) VALUES
(1, 1, '11\n', 1, 1, '1', '2', 1, '', NULL, 'MEN\'S SUIT (JKT+TRS)', 1234.00, '2025-02-06 07:36:31', '2025-02-06 07:36:31'),
(2, NULL, NULL, 4, 1, '1', '3', 1, '', NULL, 'MEN\'S SUIT (JKT+TRS)', 3000.00, '2025-02-07 08:24:36', '2025-02-07 08:24:36'),
(3, 1, '20', 5, 1, '1', '3', 1, '', NULL, 'MEN\'S SUIT (JKT+TRS)', 3000.00, '2025-02-07 09:42:14', '2025-02-07 09:42:14'),
(4, 1, '12', 6, 1, '1', '', 1, '', NULL, 'MEN\'S SUIT (JKT+TRS)', 222.00, '2025-02-10 09:00:18', '2025-02-10 09:00:18');

-- --------------------------------------------------------

--
-- Table structure for table `order_measurements`
--

CREATE TABLE `order_measurements` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_item_id` bigint(20) UNSIGNED DEFAULT NULL,
  `measurement_name` varchar(255) DEFAULT NULL,
  `measurement_value` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_measurements`
--

INSERT INTO `order_measurements` (`id`, `order_item_id`, `measurement_name`, `measurement_value`, `created_at`, `updated_at`) VALUES
(115, 23, 'FRONT', '3', '2025-01-02 07:13:48', '2025-01-02 07:13:48'),
(116, 23, 'STOMACH', '4', '2025-01-02 07:13:48', '2025-01-02 07:13:48'),
(117, 23, 'JACKET LENGTH', '1', '2025-01-02 07:13:48', '2025-01-02 07:13:48'),
(118, 23, 'SHORT INSEAM', '2', '2025-01-02 07:13:48', '2025-01-02 07:13:48'),
(119, 24, 'FRONT', '3', '2025-01-02 09:34:18', '2025-01-02 09:34:18'),
(120, 24, 'STOMACH', '4', '2025-01-02 09:34:18', '2025-01-02 09:34:18'),
(121, 24, 'JACKET LENGTH', '1', '2025-01-02 09:34:18', '2025-01-02 09:34:18'),
(122, 24, 'SHORT INSEAM', '2', '2025-01-02 09:34:18', '2025-01-02 09:34:18'),
(123, 24, 'MUSCLE', '12', '2025-01-02 09:34:18', '2025-01-02 09:34:18'),
(124, 25, 'FRONT', '3', '2025-01-02 09:35:00', '2025-01-02 09:35:00'),
(125, 25, 'STOMACH', '4', '2025-01-02 09:35:00', '2025-01-02 09:35:00'),
(126, 25, 'JACKET LENGTH', '1', '2025-01-02 09:35:00', '2025-01-02 09:35:00'),
(127, 25, 'SHORT INSEAM', '2', '2025-01-02 09:35:00', '2025-01-02 09:35:00'),
(128, 25, 'MUSCLE', '12', '2025-01-02 09:35:00', '2025-01-02 09:35:00'),
(129, 25, 'WRIST', '13', '2025-01-03 06:34:29', '2025-01-03 06:35:07'),
(130, 25, 'TROUSER LENGTH', '', '2025-01-03 06:34:29', '2025-01-03 06:34:29'),
(131, 25, 'BIG INSEAM', '', '2025-01-03 06:34:29', '2025-01-03 06:34:29'),
(132, 25, 'CROTCH', '', '2025-01-03 06:34:29', '2025-01-03 06:34:29'),
(133, 25, 'THIGH', '', '2025-01-03 06:34:29', '2025-01-03 06:34:29'),
(134, 25, 'BOTTOM', '', '2025-01-03 06:34:29', '2025-01-03 06:34:29'),
(135, 25, 'KNEE', '', '2025-01-03 06:34:29', '2025-01-03 06:34:29'),
(136, 25, 'CHEST', '', '2025-01-03 06:34:29', '2025-01-03 06:34:29'),
(137, 25, 'COLLAR', '', '2025-01-03 06:34:29', '2025-01-03 06:34:29'),
(138, 25, 'AFTER CHEST', '', '2025-01-03 06:34:29', '2025-01-03 06:34:29'),
(139, 25, 'WAIST', '', '2025-01-03 06:34:29', '2025-01-03 06:34:29'),
(140, 22, 'JACKET LENGTH', '', '2025-01-03 06:54:20', '2025-01-03 06:54:20'),
(141, 22, 'MUSCLE', '', '2025-01-03 06:54:20', '2025-01-03 06:54:20'),
(142, 22, 'WRIST', '', '2025-01-03 06:54:20', '2025-01-03 06:54:20'),
(143, 22, 'TROUSER LENGTH', '', '2025-01-03 06:54:20', '2025-01-03 06:54:20'),
(144, 22, 'BIG INSEAM', '', '2025-01-03 06:54:20', '2025-01-03 06:54:20'),
(145, 22, 'SHORT INSEAM', '', '2025-01-03 06:54:20', '2025-01-03 06:54:20'),
(146, 22, 'CROTCH', '', '2025-01-03 06:54:20', '2025-01-03 06:54:20'),
(147, 22, 'THIGH', '', '2025-01-03 06:54:20', '2025-01-03 06:54:20'),
(148, 22, 'BOTTOM', '', '2025-01-03 06:54:20', '2025-01-03 06:54:20'),
(149, 22, 'KNEE', '', '2025-01-03 06:54:20', '2025-01-03 06:54:20'),
(150, 22, 'FRONT', '', '2025-01-03 06:54:20', '2025-01-03 06:54:20'),
(151, 22, 'CHEST', '', '2025-01-03 06:54:20', '2025-01-03 06:54:20'),
(152, 22, 'COLLAR', '', '2025-01-03 06:54:20', '2025-01-03 06:54:20'),
(153, 22, 'AFTER CHEST', '', '2025-01-03 06:54:20', '2025-01-03 06:54:20'),
(154, 22, 'WAIST', '', '2025-01-03 06:54:20', '2025-01-03 06:54:20'),
(155, 22, 'STOMACH', '', '2025-01-03 06:54:20', '2025-01-03 06:54:20'),
(156, 26, 'FRONT', '3', '2025-01-06 06:32:35', '2025-01-06 06:32:35'),
(157, 26, 'STOMACH', '4', '2025-01-06 06:32:35', '2025-01-06 06:32:35'),
(158, 26, 'JACKET LENGTH', '1', '2025-01-06 06:32:35', '2025-01-06 06:32:35'),
(159, 26, 'SHORT INSEAM', '2', '2025-01-06 06:32:35', '2025-01-06 06:32:35'),
(160, 26, 'MUSCLE', '12', '2025-01-06 06:32:35', '2025-01-06 06:32:35'),
(161, 26, 'WRIST', '13', '2025-01-06 06:32:35', '2025-01-06 06:32:35'),
(162, 26, 'TROUSER LENGTH', '', '2025-01-06 06:32:35', '2025-01-06 06:32:35'),
(163, 26, 'BIG INSEAM', '', '2025-01-06 06:32:35', '2025-01-06 06:32:35'),
(164, 26, 'CROTCH', '', '2025-01-06 06:32:35', '2025-01-06 06:32:35'),
(165, 26, 'THIGH', '', '2025-01-06 06:32:35', '2025-01-06 06:32:35'),
(166, 26, 'BOTTOM', '', '2025-01-06 06:32:35', '2025-01-06 06:32:35'),
(167, 26, 'KNEE', '', '2025-01-06 06:32:35', '2025-01-06 06:32:35'),
(168, 26, 'CHEST', '', '2025-01-06 06:32:35', '2025-01-06 06:32:35'),
(169, 26, 'COLLAR', '', '2025-01-06 06:32:35', '2025-01-06 06:32:35'),
(170, 26, 'AFTER CHEST', '', '2025-01-06 06:32:35', '2025-01-06 06:32:35'),
(171, 26, 'WAIST', '', '2025-01-06 06:32:35', '2025-01-06 06:32:35'),
(172, 28, 'JACKET LENGTH', '', '2025-01-06 07:07:23', '2025-01-06 07:07:23'),
(173, 28, 'MUSCLE', '', '2025-01-06 07:07:23', '2025-01-06 07:07:23'),
(174, 28, 'WRIST', '', '2025-01-06 07:07:23', '2025-01-06 07:07:23'),
(175, 28, 'TROUSER LENGTH', '', '2025-01-06 07:07:23', '2025-01-06 07:07:23'),
(176, 28, 'BIG INSEAM', '', '2025-01-06 07:07:23', '2025-01-06 07:07:23'),
(177, 28, 'SHORT INSEAM', '', '2025-01-06 07:07:23', '2025-01-06 07:07:23'),
(178, 28, 'CROTCH', '', '2025-01-06 07:07:23', '2025-01-06 07:07:23'),
(179, 28, 'THIGH', '', '2025-01-06 07:07:23', '2025-01-06 07:07:23'),
(180, 28, 'BOTTOM', '', '2025-01-06 07:07:23', '2025-01-06 07:07:23'),
(181, 28, 'KNEE', '', '2025-01-06 07:07:23', '2025-01-06 07:07:23'),
(182, 28, 'FRONT', '', '2025-01-06 07:07:23', '2025-01-06 07:07:23'),
(183, 28, 'CHEST', '', '2025-01-06 07:07:23', '2025-01-06 07:07:23'),
(184, 28, 'COLLAR', '', '2025-01-06 07:07:23', '2025-01-06 07:07:23'),
(185, 28, 'AFTER CHEST', '', '2025-01-06 07:07:24', '2025-01-06 07:07:24'),
(186, 28, 'WAIST', '', '2025-01-06 07:07:24', '2025-01-06 07:07:24'),
(187, 28, 'STOMACH', '', '2025-01-06 07:07:24', '2025-01-06 07:07:24'),
(188, 29, 'JACKET LENGTH', '', '2025-01-06 09:48:35', '2025-01-06 09:48:35'),
(189, 29, 'MUSCLE', '', '2025-01-06 09:48:35', '2025-01-06 09:48:35'),
(190, 29, 'WRIST', '', '2025-01-06 09:48:35', '2025-01-06 09:48:35'),
(191, 29, 'TROUSER LENGTH', '', '2025-01-06 09:48:35', '2025-01-06 09:48:35'),
(192, 29, 'BIG INSEAM', '', '2025-01-06 09:48:35', '2025-01-06 09:48:35'),
(193, 29, 'SHORT INSEAM', '', '2025-01-06 09:48:35', '2025-01-06 09:48:35'),
(194, 29, 'CROTCH', '', '2025-01-06 09:48:35', '2025-01-06 09:48:35'),
(195, 29, 'THIGH', '', '2025-01-06 09:48:35', '2025-01-06 09:48:35'),
(196, 29, 'BOTTOM', '', '2025-01-06 09:48:35', '2025-01-06 09:48:35'),
(197, 29, 'KNEE', '', '2025-01-06 09:48:35', '2025-01-06 09:48:35'),
(198, 29, 'FRONT', '', '2025-01-06 09:48:35', '2025-01-06 09:48:35'),
(199, 29, 'CHEST', '', '2025-01-06 09:48:35', '2025-01-06 09:48:35'),
(200, 29, 'COLLAR', '', '2025-01-06 09:48:35', '2025-01-06 09:48:35'),
(201, 29, 'AFTER CHEST', '', '2025-01-06 09:48:35', '2025-01-06 09:48:35'),
(202, 29, 'WAIST', '', '2025-01-06 09:48:35', '2025-01-06 09:48:35'),
(203, 29, 'STOMACH', '', '2025-01-06 09:48:35', '2025-01-06 09:48:35'),
(204, 31, 'FRONT', '3', '2025-01-07 01:38:07', '2025-01-07 01:38:07'),
(205, 31, 'STOMACH', '4', '2025-01-07 01:38:07', '2025-01-07 01:38:07'),
(206, 31, 'JACKET LENGTH', '1', '2025-01-07 01:38:07', '2025-01-07 01:38:07'),
(207, 31, 'SHORT INSEAM', '2', '2025-01-07 01:38:07', '2025-01-07 01:38:07'),
(208, 31, 'MUSCLE', '12', '2025-01-07 01:38:07', '2025-01-07 01:38:07'),
(209, 31, 'WRIST', '13', '2025-01-07 01:38:07', '2025-01-07 01:38:07'),
(210, 31, 'TROUSER LENGTH', '', '2025-01-07 01:38:07', '2025-01-07 01:38:07'),
(211, 31, 'BIG INSEAM', '', '2025-01-07 01:38:07', '2025-01-07 01:38:07'),
(212, 31, 'CROTCH', '', '2025-01-07 01:38:07', '2025-01-07 01:38:07'),
(213, 31, 'THIGH', '', '2025-01-07 01:38:07', '2025-01-07 01:38:07'),
(214, 31, 'BOTTOM', '', '2025-01-07 01:38:07', '2025-01-07 01:38:07'),
(215, 31, 'KNEE', '', '2025-01-07 01:38:07', '2025-01-07 01:38:07'),
(216, 31, 'CHEST', '', '2025-01-07 01:38:07', '2025-01-07 01:38:07'),
(217, 31, 'COLLAR', '', '2025-01-07 01:38:07', '2025-01-07 01:38:07'),
(218, 31, 'AFTER CHEST', '', '2025-01-07 01:38:07', '2025-01-07 01:38:07'),
(219, 31, 'WAIST', '', '2025-01-07 01:38:07', '2025-01-07 01:38:07'),
(220, 30, 'JACKET LENGTH', '', '2025-01-07 01:40:47', '2025-01-07 01:40:47'),
(221, 30, 'MUSCLE', '', '2025-01-07 01:40:47', '2025-01-07 01:40:47'),
(222, 30, 'WRIST', '', '2025-01-07 01:40:47', '2025-01-07 01:40:47'),
(223, 30, 'TROUSER LENGTH', '', '2025-01-07 01:40:47', '2025-01-07 01:40:47'),
(224, 30, 'BIG INSEAM', '', '2025-01-07 01:40:47', '2025-01-07 01:40:47'),
(225, 30, 'SHORT INSEAM', '', '2025-01-07 01:40:47', '2025-01-07 01:40:47'),
(226, 30, 'CROTCH', '', '2025-01-07 01:40:47', '2025-01-07 01:40:47'),
(227, 30, 'THIGH', '', '2025-01-07 01:40:47', '2025-01-07 01:40:47'),
(228, 30, 'BOTTOM', '', '2025-01-07 01:40:47', '2025-01-07 01:40:47'),
(229, 30, 'KNEE', '', '2025-01-07 01:40:47', '2025-01-07 01:40:47'),
(230, 30, 'FRONT', '', '2025-01-07 01:40:47', '2025-01-07 01:40:47'),
(231, 30, 'CHEST', '', '2025-01-07 01:40:47', '2025-01-07 01:40:47'),
(232, 30, 'COLLAR', '', '2025-01-07 01:40:47', '2025-01-07 01:40:47'),
(233, 30, 'AFTER CHEST', '', '2025-01-07 01:40:47', '2025-01-07 01:40:47'),
(234, 30, 'WAIST', '', '2025-01-07 01:40:47', '2025-01-07 01:40:47'),
(235, 30, 'STOMACH', '', '2025-01-07 01:40:47', '2025-01-07 01:40:47'),
(236, 32, 'JACKET LENGTH', '', '2025-01-07 01:46:09', '2025-01-07 01:46:09'),
(237, 32, 'MUSCLE', '', '2025-01-07 01:46:09', '2025-01-07 01:46:09'),
(238, 32, 'WRIST', '', '2025-01-07 01:46:09', '2025-01-07 01:46:09'),
(239, 32, 'TROUSER LENGTH', '', '2025-01-07 01:46:09', '2025-01-07 01:46:09'),
(240, 32, 'BIG INSEAM', '', '2025-01-07 01:46:09', '2025-01-07 01:46:09'),
(241, 32, 'SHORT INSEAM', '', '2025-01-07 01:46:09', '2025-01-07 01:46:09'),
(242, 32, 'CROTCH', '', '2025-01-07 01:46:09', '2025-01-07 01:46:09'),
(243, 32, 'THIGH', '', '2025-01-07 01:46:09', '2025-01-07 01:46:09'),
(244, 32, 'BOTTOM', '', '2025-01-07 01:46:09', '2025-01-07 01:46:09'),
(245, 32, 'KNEE', '', '2025-01-07 01:46:09', '2025-01-07 01:46:09'),
(246, 32, 'FRONT', '', '2025-01-07 01:46:09', '2025-01-07 01:46:09'),
(247, 32, 'CHEST', '', '2025-01-07 01:46:09', '2025-01-07 01:46:09'),
(248, 32, 'COLLAR', '', '2025-01-07 01:46:09', '2025-01-07 01:46:09'),
(249, 32, 'AFTER CHEST', '', '2025-01-07 01:46:09', '2025-01-07 01:46:09'),
(250, 32, 'WAIST', '', '2025-01-07 01:46:09', '2025-01-07 01:46:09'),
(251, 32, 'STOMACH', '', '2025-01-07 01:46:09', '2025-01-07 01:46:09'),
(252, 27, 'JACKET LENGTH', '', '2025-01-07 06:01:58', '2025-01-07 06:01:58'),
(253, 27, 'MUSCLE', '', '2025-01-07 06:01:58', '2025-01-07 06:01:58'),
(254, 27, 'WRIST', '', '2025-01-07 06:01:58', '2025-01-07 06:01:58'),
(255, 27, 'TROUSER LENGTH', '', '2025-01-07 06:01:58', '2025-01-07 06:01:58'),
(256, 27, 'BIG INSEAM', '', '2025-01-07 06:01:58', '2025-01-07 06:01:58'),
(257, 27, 'SHORT INSEAM', '', '2025-01-07 06:01:58', '2025-01-07 06:01:58'),
(258, 27, 'CROTCH', '', '2025-01-07 06:01:58', '2025-01-07 06:01:58'),
(259, 27, 'THIGH', '', '2025-01-07 06:01:58', '2025-01-07 06:01:58'),
(260, 27, 'BOTTOM', '', '2025-01-07 06:01:58', '2025-01-07 06:01:58'),
(261, 27, 'KNEE', '', '2025-01-07 06:01:58', '2025-01-07 06:01:58'),
(262, 27, 'FRONT', '', '2025-01-07 06:01:58', '2025-01-07 06:01:58'),
(263, 27, 'CHEST', '', '2025-01-07 06:01:58', '2025-01-07 06:01:58'),
(264, 27, 'COLLAR', '', '2025-01-07 06:01:58', '2025-01-07 06:01:58'),
(265, 27, 'AFTER CHEST', '', '2025-01-07 06:01:58', '2025-01-07 06:01:58'),
(266, 27, 'WAIST', '', '2025-01-07 06:01:58', '2025-01-07 06:01:58'),
(267, 27, 'STOMACH', '', '2025-01-07 06:01:58', '2025-01-07 06:01:58'),
(268, 33, 'JACKET LENGTH', '11', '2025-01-08 01:54:20', '2025-01-08 01:54:20'),
(269, 33, 'MUSCLE', '', '2025-01-08 01:54:20', '2025-01-08 01:54:20'),
(270, 33, 'WRIST', '', '2025-01-08 01:54:20', '2025-01-08 01:54:20'),
(271, 33, 'TROUSER LENGTH', '', '2025-01-08 01:54:20', '2025-01-08 01:54:20'),
(272, 33, 'BIG INSEAM', '', '2025-01-08 01:54:20', '2025-01-08 01:54:20'),
(273, 33, 'SHORT INSEAM', '22', '2025-01-08 01:54:20', '2025-01-08 01:54:20'),
(274, 33, 'CROTCH', '', '2025-01-08 01:54:20', '2025-01-08 01:54:20'),
(275, 33, 'THIGH', '', '2025-01-08 01:54:20', '2025-01-08 01:54:20'),
(276, 33, 'BOTTOM', '', '2025-01-08 01:54:20', '2025-01-08 01:54:20'),
(277, 33, 'KNEE', '', '2025-01-08 01:54:20', '2025-01-08 01:54:20'),
(278, 33, 'FRONT', '23', '2025-01-08 01:54:20', '2025-01-08 01:54:20'),
(279, 33, 'CHEST', '', '2025-01-08 01:54:20', '2025-01-08 01:54:20'),
(280, 33, 'COLLAR', '', '2025-01-08 01:54:20', '2025-01-08 01:54:20'),
(281, 33, 'AFTER CHEST', '', '2025-01-08 01:54:20', '2025-01-08 01:54:20'),
(282, 33, 'WAIST', '', '2025-01-08 01:54:20', '2025-01-08 01:54:20'),
(283, 33, 'STOMACH', '24', '2025-01-08 01:54:20', '2025-01-08 01:54:20'),
(284, 34, 'JACKET LENGTH', '', '2025-01-08 02:11:17', '2025-01-08 02:11:17'),
(285, 34, 'MUSCLE', '', '2025-01-08 02:11:17', '2025-01-08 02:11:17'),
(286, 34, 'WRIST', '', '2025-01-08 02:11:17', '2025-01-08 02:11:17'),
(287, 34, 'TROUSER LENGTH', '14', '2025-01-08 02:11:17', '2025-01-08 02:11:17'),
(288, 34, 'BIG INSEAM', '', '2025-01-08 02:11:17', '2025-01-08 02:11:17'),
(289, 34, 'SHORT INSEAM', '', '2025-01-08 02:11:17', '2025-01-08 02:11:17'),
(290, 34, 'CROTCH', '', '2025-01-08 02:11:17', '2025-01-08 02:11:17'),
(291, 34, 'THIGH', '', '2025-01-08 02:11:17', '2025-01-08 02:11:17'),
(292, 34, 'BOTTOM', '', '2025-01-08 02:11:17', '2025-01-08 02:11:17'),
(293, 34, 'KNEE', '', '2025-01-08 02:11:17', '2025-01-08 02:11:17'),
(294, 34, 'FRONT', '', '2025-01-08 02:11:17', '2025-01-08 02:11:17'),
(295, 34, 'CHEST', '', '2025-01-08 02:11:17', '2025-01-08 02:11:17'),
(296, 34, 'COLLAR', '', '2025-01-08 02:11:17', '2025-01-08 02:11:17'),
(297, 34, 'AFTER CHEST', '', '2025-01-08 02:11:17', '2025-01-08 02:11:17'),
(298, 34, 'WAIST', '', '2025-01-08 02:11:17', '2025-01-08 02:11:17'),
(299, 34, 'STOMACH', '', '2025-01-08 02:11:17', '2025-01-08 02:11:17'),
(300, 35, 'JACKET LENGTH', '', '2025-01-08 02:16:51', '2025-01-08 02:16:51'),
(301, 35, 'MUSCLE', '', '2025-01-08 02:16:51', '2025-01-08 02:16:51'),
(302, 35, 'WRIST', '', '2025-01-08 02:16:51', '2025-01-08 02:16:51'),
(303, 35, 'TROUSER LENGTH', '14', '2025-01-08 02:16:51', '2025-01-08 02:16:51'),
(304, 35, 'BIG INSEAM', '21', '2025-01-08 02:16:51', '2025-01-08 02:16:51'),
(305, 35, 'SHORT INSEAM', '', '2025-01-08 02:16:51', '2025-01-08 02:16:51'),
(306, 35, 'CROTCH', '', '2025-01-08 02:16:51', '2025-01-08 02:16:51'),
(307, 35, 'THIGH', '', '2025-01-08 02:16:51', '2025-01-08 02:16:51'),
(308, 35, 'BOTTOM', '', '2025-01-08 02:16:51', '2025-01-08 02:16:51'),
(309, 35, 'KNEE', '', '2025-01-08 02:16:51', '2025-01-08 02:16:51'),
(310, 35, 'FRONT', '', '2025-01-08 02:16:51', '2025-01-08 02:16:51'),
(311, 35, 'CHEST', '', '2025-01-08 02:16:51', '2025-01-08 02:16:51'),
(312, 35, 'COLLAR', '', '2025-01-08 02:16:51', '2025-01-08 02:16:51'),
(313, 35, 'AFTER CHEST', '', '2025-01-08 02:16:51', '2025-01-08 02:16:51'),
(314, 35, 'WAIST', '', '2025-01-08 02:16:51', '2025-01-08 02:16:51'),
(315, 35, 'STOMACH', '', '2025-01-08 02:16:51', '2025-01-08 02:16:51'),
(316, 36, 'JACKET LENGTH', '11', '2025-01-08 02:54:28', '2025-01-08 02:54:28'),
(317, 36, 'MUSCLE', '', '2025-01-08 02:54:28', '2025-01-08 02:54:28'),
(318, 36, 'WRIST', '', '2025-01-08 02:54:28', '2025-01-08 02:54:28'),
(319, 36, 'TROUSER LENGTH', '', '2025-01-08 02:54:28', '2025-01-08 02:54:28'),
(320, 36, 'BIG INSEAM', '', '2025-01-08 02:54:28', '2025-01-08 02:54:28'),
(321, 36, 'SHORT INSEAM', '22', '2025-01-08 02:54:28', '2025-01-08 02:54:28'),
(322, 36, 'CROTCH', '', '2025-01-08 02:54:28', '2025-01-08 02:54:28'),
(323, 36, 'THIGH', '', '2025-01-08 02:54:28', '2025-01-08 02:54:28'),
(324, 36, 'BOTTOM', '', '2025-01-08 02:54:28', '2025-01-08 02:54:28'),
(325, 36, 'KNEE', '', '2025-01-08 02:54:28', '2025-01-08 02:54:28'),
(326, 36, 'FRONT', '23', '2025-01-08 02:54:28', '2025-01-08 02:54:28'),
(327, 36, 'CHEST', '', '2025-01-08 02:54:28', '2025-01-08 02:54:28'),
(328, 36, 'COLLAR', '', '2025-01-08 02:54:28', '2025-01-08 02:54:28'),
(329, 36, 'AFTER CHEST', '', '2025-01-08 02:54:28', '2025-01-08 02:54:28'),
(330, 36, 'WAIST', '', '2025-01-08 02:54:28', '2025-01-08 02:54:28'),
(331, 36, 'STOMACH', '24', '2025-01-08 02:54:28', '2025-01-08 02:54:28'),
(332, 2, 'JACKET LENGTH', '', '2025-02-06 01:27:43', '2025-02-06 01:27:43'),
(333, 2, 'MUSCLE', '', '2025-02-06 01:27:43', '2025-02-06 01:27:43'),
(334, 2, 'WRIST', '', '2025-02-06 01:27:43', '2025-02-06 01:27:43'),
(335, 2, 'TROUSER LENGTH', '', '2025-02-06 01:27:43', '2025-02-06 01:27:43'),
(336, 2, 'BIG INSEAM', '', '2025-02-06 01:27:43', '2025-02-06 01:27:43'),
(337, 2, 'SHORT INSEAM', '', '2025-02-06 01:27:43', '2025-02-06 01:27:43'),
(338, 2, 'CROTCH', '', '2025-02-06 01:27:43', '2025-02-06 01:27:43'),
(339, 2, 'THIGH', '', '2025-02-06 01:27:43', '2025-02-06 01:27:43'),
(340, 2, 'BOTTOM', '', '2025-02-06 01:27:43', '2025-02-06 01:27:43'),
(341, 2, 'KNEE', '', '2025-02-06 01:27:43', '2025-02-06 01:27:43'),
(342, 2, 'FRONT', '', '2025-02-06 01:27:43', '2025-02-06 01:27:43'),
(343, 2, 'CHEST', '', '2025-02-06 01:27:43', '2025-02-06 01:27:43'),
(344, 2, 'COLLAR', '', '2025-02-06 01:27:43', '2025-02-06 01:27:43'),
(345, 2, 'AFTER CHEST', '', '2025-02-06 01:27:43', '2025-02-06 01:27:43'),
(346, 2, 'WAIST', '', '2025-02-06 01:27:43', '2025-02-06 01:27:43'),
(347, 2, 'STOMACH', '', '2025-02-06 01:27:43', '2025-02-06 01:27:43'),
(348, 1, 'JACKET LENGTH', '', '2025-02-06 02:33:48', '2025-02-06 02:33:48'),
(349, 1, 'MUSCLE', '', '2025-02-06 02:33:48', '2025-02-06 02:33:48'),
(350, 1, 'WRIST', '', '2025-02-06 02:33:48', '2025-02-06 02:33:48'),
(351, 1, 'TROUSER LENGTH', '', '2025-02-06 02:33:48', '2025-02-06 02:33:48'),
(352, 1, 'BIG INSEAM', '', '2025-02-06 02:33:48', '2025-02-06 02:33:48'),
(353, 1, 'SHORT INSEAM', '', '2025-02-06 02:33:48', '2025-02-06 02:33:48'),
(354, 1, 'CROTCH', '', '2025-02-06 02:33:48', '2025-02-06 02:33:48'),
(355, 1, 'THIGH', '', '2025-02-06 02:33:48', '2025-02-06 02:33:48'),
(356, 1, 'BOTTOM', '', '2025-02-06 02:33:48', '2025-02-06 02:33:48'),
(357, 1, 'KNEE', '', '2025-02-06 02:33:48', '2025-02-06 02:33:48'),
(358, 1, 'FRONT', '', '2025-02-06 02:33:48', '2025-02-06 02:33:48'),
(359, 1, 'CHEST', '', '2025-02-06 02:33:48', '2025-02-06 02:33:48'),
(360, 1, 'COLLAR', '', '2025-02-06 02:33:48', '2025-02-06 02:33:48'),
(361, 1, 'AFTER CHEST', '', '2025-02-06 02:33:48', '2025-02-06 02:33:48'),
(362, 1, 'WAIST', '', '2025-02-06 02:33:48', '2025-02-06 02:33:48'),
(363, 1, 'STOMACH', '', '2025-02-06 02:33:48', '2025-02-06 02:33:48');

-- --------------------------------------------------------

--
-- Table structure for table `otps`
--

CREATE TABLE `otps` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `phone` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `employee_id` varchar(255) DEFAULT NULL,
  `otp` varchar(255) NOT NULL,
  `expires_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `packingslips`
--

CREATE TABLE `packingslips` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED DEFAULT NULL,
  `customer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `invoice_id` bigint(20) UNSIGNED DEFAULT NULL,
  `slipno` varchar(100) DEFAULT NULL,
  `is_disbursed` tinyint(1) NOT NULL DEFAULT 0,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `disbursed_by` bigint(20) UNSIGNED DEFAULT NULL,
  `disbursed_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED DEFAULT NULL,
  `paid_amount` decimal(10,2) DEFAULT NULL,
  `admin_id` bigint(20) UNSIGNED DEFAULT NULL,
  `stuff_id` bigint(20) UNSIGNED DEFAULT NULL,
  `supplier_id` bigint(20) UNSIGNED DEFAULT NULL,
  `customer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `expense_id` bigint(20) UNSIGNED DEFAULT NULL,
  `service_slip_id` bigint(20) UNSIGNED DEFAULT NULL,
  `discount_id` bigint(20) UNSIGNED DEFAULT NULL,
  `payment_for` varchar(255) DEFAULT NULL,
  `payment_in` varchar(255) DEFAULT NULL,
  `bank_cash` enum('Bank','Cash') DEFAULT NULL,
  `voucher_no` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `payment_date` date DEFAULT NULL,
  `payment_mode` enum('Cash','Cheque','UPI','Bank Transfer','neft') DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `chq_utr_no` varchar(255) DEFAULT NULL,
  `bank_name` varchar(255) DEFAULT NULL,
  `narration` text DEFAULT NULL,
  `created_from` varchar(255) DEFAULT NULL,
  `is_gst` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `order_id`, `paid_amount`, `admin_id`, `stuff_id`, `supplier_id`, `customer_id`, `expense_id`, `service_slip_id`, `discount_id`, `payment_for`, `payment_in`, `bank_cash`, `voucher_no`, `image`, `payment_date`, `payment_mode`, `amount`, `chq_utr_no`, `bank_name`, `narration`, `created_from`, `is_gst`, `created_at`, `updated_at`, `created_by`, `updated_by`) VALUES
(1, 1, 1234.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '2025-02-06 07:36:31', '2025-02-06 08:51:44', NULL, NULL),
(4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '2025-02-07 08:24:36', '2025-02-07 08:24:36', NULL, NULL),
(5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '2025-02-07 09:42:14', '2025-02-07 09:42:14', NULL, NULL),
(6, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '2025-02-10 09:00:18', '2025-02-10 09:00:18', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `payment_collections`
--

CREATE TABLE `payment_collections` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `admin_id` bigint(20) UNSIGNED DEFAULT NULL,
  `payment_id` bigint(20) UNSIGNED DEFAULT NULL,
  `collection_amount` double DEFAULT NULL,
  `cheque_date` date DEFAULT NULL,
  `voucher_no` varchar(255) DEFAULT NULL COMMENT 'payment receipt voucher no',
  `payment_type` varchar(255) NOT NULL DEFAULT 'cheque' COMMENT 'cheque,neft,cash',
  `bank_name` varchar(255) DEFAULT NULL,
  `cheque_number` varchar(255) DEFAULT NULL,
  `is_ledger_added` tinyint(1) NOT NULL DEFAULT 0,
  `image` varchar(255) DEFAULT NULL,
  `is_approve` int(11) NOT NULL COMMENT '1=approved',
  `created_from` enum('web','app') NOT NULL DEFAULT 'app',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payment_revokes`
--

CREATE TABLE `payment_revokes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `done_by` bigint(20) UNSIGNED NOT NULL,
  `voucher_no` varchar(255) NOT NULL,
  `collection_amount` double DEFAULT NULL,
  `paymentcollection_data_json` longtext DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payment_revokes`
--

INSERT INTO `payment_revokes` (`id`, `customer_id`, `done_by`, `voucher_no`, `collection_amount`, `paymentcollection_data_json`, `created_at`, `updated_at`) VALUES
(1, 16, 1, 'PAYRECEIPT1739437956', 100, '{\"id\":1,\"customer_id\":16,\"user_id\":32,\"admin_id\":1,\"payment_id\":7,\"collection_amount\":100,\"cheque_date\":\"2025-02-13\",\"voucher_no\":\"PAYRECEIPT1739437956\",\"payment_type\":\"cash\",\"bank_name\":\"\",\"cheque_number\":\"\",\"is_ledger_added\":1,\"image\":null,\"is_approve\":1,\"created_from\":\"web\",\"created_at\":\"2025-02-13T09:12:57.000000Z\",\"updated_at\":\"2025-02-13T09:12:57.000000Z\"}', '2025-02-13 05:35:30', NULL),
(2, 16, 1, 'PAYRECEIPT1739437956', 100, '{\"id\":1,\"customer_id\":16,\"user_id\":32,\"admin_id\":1,\"payment_id\":7,\"collection_amount\":100,\"cheque_date\":\"2025-02-13\",\"voucher_no\":\"PAYRECEIPT1739437956\",\"payment_type\":\"cash\",\"bank_name\":\"\",\"cheque_number\":\"\",\"is_ledger_added\":1,\"image\":null,\"is_approve\":1,\"created_from\":\"web\",\"created_at\":\"2025-02-13T09:12:57.000000Z\",\"updated_at\":\"2025-02-13T09:12:57.000000Z\"}', '2025-02-13 05:38:10', NULL),
(3, 14, 1, 'PAYRECEIPT1739445295', 2500, '{\"id\":2,\"customer_id\":14,\"user_id\":24,\"admin_id\":1,\"payment_id\":8,\"collection_amount\":2500,\"cheque_date\":\"2025-02-13\",\"voucher_no\":\"PAYRECEIPT1739445295\",\"payment_type\":\"cash\",\"bank_name\":\"\",\"cheque_number\":\"\",\"is_ledger_added\":1,\"image\":null,\"is_approve\":1,\"created_from\":\"web\",\"created_at\":\"2025-02-13T11:15:22.000000Z\",\"updated_at\":\"2025-02-13T11:15:22.000000Z\"}', '2025-02-13 06:34:02', NULL),
(4, 16, 1, 'PAYRECEIPT1739437956', 100, '{\"id\":1,\"customer_id\":16,\"user_id\":32,\"admin_id\":1,\"payment_id\":7,\"collection_amount\":100,\"cheque_date\":\"2025-02-13\",\"voucher_no\":\"PAYRECEIPT1739437956\",\"payment_type\":\"cash\",\"bank_name\":\"\",\"cheque_number\":\"\",\"is_ledger_added\":1,\"image\":null,\"is_approve\":1,\"created_from\":\"web\",\"created_at\":\"2025-02-13T09:12:57.000000Z\",\"updated_at\":\"2025-02-13T09:12:57.000000Z\"}', '2025-02-13 06:34:40', NULL),
(5, 16, 1, 'PAYRECEIPT1739445382', 1500, '{\"id\":3,\"customer_id\":16,\"user_id\":32,\"admin_id\":1,\"payment_id\":9,\"collection_amount\":1500,\"cheque_date\":\"2025-02-13\",\"voucher_no\":\"PAYRECEIPT1739445382\",\"payment_type\":\"cash\",\"bank_name\":\"\",\"cheque_number\":\"\",\"is_ledger_added\":1,\"image\":null,\"is_approve\":1,\"created_from\":\"web\",\"created_at\":\"2025-02-13T11:16:38.000000Z\",\"updated_at\":\"2025-02-13T11:16:38.000000Z\"}', '2025-02-13 06:34:42', NULL),
(6, 16, 1, 'PAYRECEIPT1739448345', 2500, '{\"id\":4,\"customer_id\":16,\"user_id\":32,\"admin_id\":1,\"payment_id\":10,\"collection_amount\":2500,\"cheque_date\":\"2025-02-13\",\"voucher_no\":\"PAYRECEIPT1739448345\",\"payment_type\":\"cash\",\"bank_name\":\"\",\"cheque_number\":\"\",\"is_ledger_added\":1,\"image\":null,\"is_approve\":1,\"created_from\":\"web\",\"created_at\":\"2025-02-13T12:06:05.000000Z\",\"updated_at\":\"2025-02-13T12:06:05.000000Z\"}', '2025-02-13 06:36:11', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `collection_id` bigint(20) UNSIGNED DEFAULT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `sub_category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `short_description` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `product_code` varchar(255) DEFAULT NULL,
  `gst_details` decimal(5,2) DEFAULT 0.00,
  `product_image` varchar(255) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1: Active, 0: Inactive',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `collection_id`, `category_id`, `sub_category_id`, `name`, `short_description`, `description`, `product_code`, `gst_details`, `product_image`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 1, NULL, 'MEN\'S SUIT (JKT+TRS)', NULL, NULL, '1234', NULL, NULL, 1, '2025-01-29 07:38:19', '2025-01-29 07:38:19', NULL),
(2, 2, 2, NULL, 'Items Product', NULL, NULL, '1234', NULL, NULL, 1, '2025-02-03 02:16:39', '2025-02-03 02:16:39', NULL),
(3, 4, 3, NULL, 'Siezer', NULL, NULL, '7890', NULL, NULL, 1, '2025-02-03 02:23:12', '2025-02-03 02:23:12', NULL),
(4, 2, 2, NULL, 'Items Product', NULL, NULL, '1234', NULL, NULL, 1, '2025-02-11 06:39:00', '2025-02-11 06:41:56', '2025-02-11 06:41:56'),
(5, 2, 2, NULL, 'Formal Suit', NULL, NULL, '123123', NULL, NULL, 1, '2025-02-11 06:56:06', '2025-02-11 06:56:06', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `product_fabrics`
--

CREATE TABLE `product_fabrics` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `fabric_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_fabrics`
--

INSERT INTO `product_fabrics` (`id`, `product_id`, `fabric_id`, `created_at`, `updated_at`) VALUES
(1, 5, 5, NULL, NULL),
(2, 6, 4, NULL, NULL),
(3, 7, 3, NULL, NULL),
(4, 8, 5, NULL, NULL),
(6, 10, 2, NULL, NULL),
(7, 10, 3, NULL, NULL),
(8, 11, 2, NULL, NULL),
(9, 11, 3, NULL, NULL),
(10, 1, 2, NULL, NULL),
(11, 1, 3, NULL, NULL),
(12, 2, 3, NULL, NULL),
(13, 2, 4, NULL, NULL),
(14, 3, 2, NULL, NULL),
(15, 3, 3, NULL, NULL),
(16, 4, 2, NULL, NULL),
(17, 4, 3, NULL, NULL),
(18, 4, 4, NULL, NULL),
(19, 1, 2, NULL, NULL),
(20, 1, 3, NULL, NULL),
(21, 2, 2, NULL, NULL),
(22, 2, 3, NULL, NULL),
(23, 3, 2, NULL, NULL),
(24, 3, 4, NULL, NULL),
(25, 4, 2, NULL, NULL),
(26, 4, 3, NULL, NULL),
(27, 5, 2, NULL, NULL),
(28, 5, 3, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `product_images`
--

CREATE TABLE `product_images` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `image` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_images`
--

INSERT INTO `product_images` (`id`, `product_id`, `image`, `created_at`, `updated_at`) VALUES
(2, 8, 'uploads/product_images/IHTROQD61lvWCqmb6p5hgXtlUwBXrk4GKuHZKw3L.png', '2025-01-20 05:14:53', '2025-01-20 05:14:53'),
(4, 9, 'uploads/product_images/cVRCfi58BYh6xZyM6S4twbmFWmHaXGQPNPP3x32D.png', '2025-01-21 03:20:31', '2025-01-21 03:20:31'),
(5, 9, 'uploads/product_images/Ykoh5RU3NolkbAqnXJSKqw2ELwNkOStJ7nDjUJuY.png', '2025-01-21 03:20:31', '2025-01-21 03:20:31');

-- --------------------------------------------------------

--
-- Table structure for table `purchase_orders`
--

CREATE TABLE `purchase_orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `supplier_id` bigint(20) UNSIGNED NOT NULL,
  `unique_id` varchar(255) NOT NULL,
  `product_ids` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `fabric_ids` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `address` text DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `pin` varchar(255) DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `landmark` varchar(255) DEFAULT NULL,
  `total_price` decimal(15,2) NOT NULL,
  `is_good_in` tinyint(1) NOT NULL DEFAULT 0,
  `goods_in_type` enum('scan','bulk') DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `purchase_orders`
--

INSERT INTO `purchase_orders` (`id`, `supplier_id`, `unique_id`, `product_ids`, `fabric_ids`, `address`, `city`, `pin`, `state`, `country`, `landmark`, `total_price`, `is_good_in`, `goods_in_type`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 'PO1739438386', '', '2', 'Kolkata', 'Kolkata', '7000015', 'West Bengal', 'India', NULL, 999.00, 0, 'bulk', 1, '2025-02-13 03:49:46', '2025-02-13 03:50:04');

-- --------------------------------------------------------

--
-- Table structure for table `purchase_order_products`
--

CREATE TABLE `purchase_order_products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `purchase_order_id` bigint(20) UNSIGNED NOT NULL,
  `collection_id` bigint(20) UNSIGNED DEFAULT NULL,
  `stock_type` enum('fabric','product') NOT NULL,
  `piece_price` decimal(15,2) NOT NULL,
  `total_price` decimal(15,2) NOT NULL,
  `fabric_id` bigint(20) UNSIGNED DEFAULT NULL,
  `fabric_name` varchar(255) DEFAULT NULL,
  `qty_in_meter` decimal(15,2) DEFAULT NULL,
  `qty_while_grn_fabric` decimal(10,2) DEFAULT NULL,
  `product_id` bigint(20) UNSIGNED DEFAULT NULL,
  `product_name` varchar(255) DEFAULT NULL,
  `qty_in_pieces` int(11) DEFAULT NULL,
  `qty_while_grn_product` decimal(10,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `purchase_order_products`
--

INSERT INTO `purchase_order_products` (`id`, `purchase_order_id`, `collection_id`, `stock_type`, `piece_price`, `total_price`, `fabric_id`, `fabric_name`, `qty_in_meter`, `qty_while_grn_fabric`, `product_id`, `product_name`, `qty_in_pieces`, `qty_while_grn_product`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'fabric', 111.00, 999.00, 2, 'Wonder 1', 10.00, 9.00, NULL, NULL, NULL, NULL, '2025-02-13 03:49:46', '2025-02-13 03:50:04');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `value` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `slug`, `value`, `created_at`, `updated_at`) VALUES
(1, 'Customer', 'customer', 'customer', '2024-12-09 05:20:24', '2024-12-09 05:20:24'),
(2, 'Category', 'category', 'category', '2024-12-09 05:20:24', '2024-12-09 05:20:24'),
(3, 'Subcategory', 'subcategory', 'subcategory', '2024-12-09 05:20:24', '2024-12-09 05:20:24'),
(4, 'Product', 'product', 'product', '2024-12-09 05:20:24', '2024-12-09 05:20:24'),
(5, 'Expense', 'expense', 'expense', '2024-12-09 05:20:24', '2024-12-09 05:20:24'),
(6, 'Supplier', 'supplier', 'supplier', '2024-12-09 05:20:24', '2024-12-09 05:20:24'),
(7, 'Staff', 'staff', 'staff', '2024-12-09 05:20:24', '2024-12-09 05:20:24'),
(8, 'PO', 'po', 'po', '2024-12-09 05:20:24', '2024-12-09 05:20:24'),
(9, 'Sales', 'sales', 'sales', '2024-12-09 05:20:24', '2024-12-09 05:20:24'),
(10, 'Accounting', 'accounting', 'accounting', '2024-12-09 05:20:24', '2024-12-09 05:20:24'),
(11, 'Report', 'report', 'report', '2024-12-09 05:20:24', '2024-12-09 05:20:24');

-- --------------------------------------------------------

--
-- Table structure for table `salesman_billing_number`
--

CREATE TABLE `salesman_billing_number` (
  `id` int(11) NOT NULL,
  `salesman_id` int(11) NOT NULL,
  `start_no` varchar(255) NOT NULL,
  `end_no` varchar(255) NOT NULL,
  `no_of_used` int(11) DEFAULT NULL,
  `total_count` int(11) DEFAULT NULL COMMENT 'total no of bill count',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `salesman_billing_number`
--

INSERT INTO `salesman_billing_number` (`id`, `salesman_id`, `start_no`, `end_no`, `no_of_used`, `total_count`, `created_at`, `updated_at`) VALUES
(1, 1, '10', '14', 5, 5, '2025-02-06 07:34:43', '2025-02-06 07:35:38'),
(2, 17, '15', '20', 3, 6, '2025-02-06 07:35:38', '2025-02-10 09:00:18');

-- --------------------------------------------------------

--
-- Table structure for table `stocks`
--

CREATE TABLE `stocks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `grn_no` varchar(255) DEFAULT NULL,
  `purchase_order_id` bigint(20) UNSIGNED NOT NULL,
  `po_unique_id` varchar(255) DEFAULT NULL,
  `return_id` bigint(20) UNSIGNED DEFAULT NULL,
  `return_order_no` varchar(255) DEFAULT NULL,
  `goods_in_type` varchar(255) DEFAULT NULL,
  `product_ids` varchar(255) DEFAULT NULL,
  `fabric_ids` varchar(255) DEFAULT NULL,
  `total_price` decimal(15,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `stocks`
--

INSERT INTO `stocks` (`id`, `grn_no`, `purchase_order_id`, `po_unique_id`, `return_id`, `return_order_no`, `goods_in_type`, `product_ids`, `fabric_ids`, `total_price`, `created_at`, `updated_at`) VALUES
(1, 'GRN-20250213092004000', 1, 'PO1739438386', NULL, NULL, 'goods_in', '', '2', 999.00, '2025-02-13 03:50:04', '2025-02-13 03:50:04');

-- --------------------------------------------------------

--
-- Table structure for table `stock_fabrics`
--

CREATE TABLE `stock_fabrics` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `stock_id` bigint(20) UNSIGNED NOT NULL,
  `fabric_id` bigint(20) UNSIGNED NOT NULL,
  `qty_in_meter` decimal(10,2) NOT NULL,
  `qty_while_grn` decimal(10,2) DEFAULT NULL,
  `piece_price` decimal(10,2) NOT NULL,
  `total_price` decimal(15,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `stock_fabrics`
--

INSERT INTO `stock_fabrics` (`id`, `stock_id`, `fabric_id`, `qty_in_meter`, `qty_while_grn`, `piece_price`, `total_price`, `created_at`, `updated_at`) VALUES
(1, 1, 2, 10.00, 9.00, 111.00, 999.00, '2025-02-13 03:50:04', '2025-02-13 03:50:04');

-- --------------------------------------------------------

--
-- Table structure for table `stock_products`
--

CREATE TABLE `stock_products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `stock_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `qty_in_pieces` int(11) NOT NULL,
  `qty_while_grn` decimal(10,2) DEFAULT NULL,
  `piece_price` decimal(10,2) NOT NULL,
  `total_price` decimal(15,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sub_categories`
--

CREATE TABLE `sub_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1: Active, 0: Inactive',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sub_categories`
--

INSERT INTO `sub_categories` (`id`, `category_id`, `title`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 14, 'MEN\'S SUIT (JKT+TRS)	', 1, '2024-12-17 05:20:58', '2024-12-17 05:20:58', NULL),
(2, 15, 'MEN\'S JACKET (JKT)', 1, '2024-12-17 05:21:26', '2024-12-17 05:21:26', NULL),
(3, 16, 'MEN\'S TROUSER (TRS)', 1, '2024-12-17 05:21:55', '2024-12-17 05:21:55', NULL),
(4, 17, 'MEN\'S SHIRT (SH)', 1, '2024-12-17 05:22:23', '2024-12-17 05:22:23', NULL),
(5, 14, 'LADIES SUIT (JKT+TRS/SKIRT)', 1, '2024-12-17 05:22:36', '2024-12-17 05:22:36', NULL),
(6, 15, 'LADIES JACKET (JKT)', 1, '2024-12-17 05:22:46', '2024-12-17 05:22:46', NULL),
(7, 16, 'LADIES TROUSER (TRS)', 1, '2024-12-17 05:22:55', '2024-12-17 05:22:55', NULL),
(8, 18, 'LADIES SKIRT (SKT)', 1, '2024-12-17 05:23:35', '2024-12-17 05:23:35', NULL),
(9, 17, 'LADIES SHIRT(SH)', 1, '2024-12-17 05:23:50', '2024-12-17 05:23:50', NULL),
(10, 11, 'MEN\'S SUIT (JKT+TRS)', 1, '2024-12-20 02:41:45', '2024-12-20 02:41:45', NULL),
(11, 14, 'MEN\'S SUIT (JKT+TRS)', 1, '2024-12-20 02:41:57', '2024-12-20 02:41:57', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

CREATE TABLE `suppliers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `mobile` varchar(255) DEFAULT NULL,
  `whatsapp_no` varchar(255) DEFAULT NULL,
  `billing_address` text DEFAULT NULL,
  `billing_landmark` varchar(255) DEFAULT NULL,
  `billing_state` varchar(255) DEFAULT NULL,
  `billing_city` varchar(255) DEFAULT NULL,
  `billing_pin` varchar(255) DEFAULT NULL,
  `billing_country` varchar(255) DEFAULT NULL,
  `gst_number` varchar(255) DEFAULT NULL,
  `gst_file` varchar(255) DEFAULT NULL,
  `credit_limit` decimal(10,2) DEFAULT NULL,
  `credit_days` int(11) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `suppliers`
--

INSERT INTO `suppliers` (`id`, `name`, `email`, `mobile`, `whatsapp_no`, `billing_address`, `billing_landmark`, `billing_state`, `billing_city`, `billing_pin`, `billing_country`, `gst_number`, `gst_file`, `credit_limit`, `credit_days`, `status`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'Souvik Mandal', 'souvik@gmail.com', '+2345623456', '+2345623456', 'Kolkata', NULL, 'West Bengal', 'Kolkata', '7000015', 'India', '7898ty76', 'storage/gst_files/iGsCI3WrExa8ZDr2Gbltr3dPDTdk39g8kW8hbEL9.png', 1210000.00, 60, 1, NULL, '2024-12-23 09:37:21', '2025-02-12 07:32:40'),
(2, 'Vozen Electronics Pvt. Ltd', 'vozen@gmail.com', '+7894568512345', '+7894568512345', 'kolkata', NULL, 'West Bengal', 'kolkata', '70002', 'India', NULL, NULL, NULL, NULL, 1, NULL, '2024-12-23 09:39:53', '2025-02-07 03:08:06');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `is_super_admin` int(11) DEFAULT NULL,
  `admin_id` int(11) DEFAULT NULL,
  `business_type` bigint(20) UNSIGNED DEFAULT NULL,
  `branch_id` bigint(20) UNSIGNED DEFAULT NULL,
  `country_id` bigint(20) UNSIGNED DEFAULT NULL,
  `user_type` tinyint(4) NOT NULL DEFAULT 1 COMMENT '0:staff, 1:customer',
  `employee_id` varchar(255) DEFAULT NULL,
  `designation` varchar(255) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `company_name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `otp_verification` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0:otp not sent, 1:otp not veridied,2:otp verified',
  `mpin` varchar(255) DEFAULT NULL,
  `ip_address` varchar(255) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `profile_image` varchar(255) DEFAULT NULL,
  `verified_video` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `about` text DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `whatsapp_no` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `passport_id_back` varchar(255) DEFAULT NULL,
  `passport_expiry_date` date DEFAULT NULL,
  `passport_id_front` varchar(255) DEFAULT NULL,
  `emergency_contact_person` varchar(255) DEFAULT NULL,
  `emergency_mobile` varchar(255) DEFAULT NULL,
  `emergency_whatsapp` varchar(255) DEFAULT NULL,
  `emergency_address` text DEFAULT NULL,
  `aadhar_name` varchar(255) DEFAULT NULL,
  `gst_number` varchar(255) DEFAULT NULL,
  `gst_certificate_image` varchar(255) DEFAULT NULL,
  `credit_limit` decimal(15,2) DEFAULT NULL,
  `credit_days` int(11) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1: Active, 0: Inactive',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `employee_rank` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `is_super_admin`, `admin_id`, `business_type`, `branch_id`, `country_id`, `user_type`, `employee_id`, `designation`, `name`, `company_name`, `email`, `otp_verification`, `mpin`, `ip_address`, `dob`, `email_verified_at`, `profile_image`, `verified_video`, `phone`, `location`, `about`, `password`, `whatsapp_no`, `image`, `passport_id_back`, `passport_expiry_date`, `passport_id_front`, `emergency_contact_person`, `emergency_mobile`, `emergency_whatsapp`, `emergency_address`, `aadhar_name`, `gst_number`, `gst_certificate_image`, `credit_limit`, `credit_days`, `remember_token`, `deleted_at`, `status`, `created_at`, `updated_at`, `employee_rank`) VALUES
(1, NULL, NULL, NULL, NULL, NULL, 0, NULL, '1', 'Admin', NULL, 'admin@gmail.com', 0, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, '$2y$10$lVQJeUPQK1vjwgSmQEsj9eOU8/V7LMbmbsOI5x1kPT3GuQwWpf1p6', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, 1, '2024-12-16 01:14:38', '2024-12-16 08:00:56', '0'),
(14, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, 'Koushik Adhikary', 'Techmantra', 'koushik@gmail.com', 0, NULL, NULL, '2025-06-12', NULL, 'storage/profile_image/1738828300.png', NULL, '+123456789876', NULL, NULL, NULL, '+123456789876', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '7898ty76', 'storage/gst_certificate_image/1739365401.jpg', 1237.00, 12, NULL, NULL, 1, '2024-12-23 09:36:17', '2025-02-12 07:33:21', 'PM'),
(15, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, 'Papiya Halder uuu', 'Souvik group of company', 'papiyahalde77@gmail.com', 0, NULL, NULL, '2024-12-23', NULL, 'storage/profile_image/1738828288.png', NULL, '74185296', NULL, NULL, NULL, '74185296', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, 0.00, 0, NULL, NULL, 1, '2024-12-23 09:42:05', '2025-02-06 02:21:28', '1'),
(16, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, 'Souvik Mandal', 'Souvik group of company user', '', 0, NULL, NULL, '2024-12-24', NULL, 'storage/profile_image/1738828260.png', NULL, '+9064956744', NULL, NULL, NULL, '+9064956744', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, 0.00, 0, NULL, NULL, 1, '2024-12-24 08:28:22', '2025-02-07 04:17:07', '1'),
(17, NULL, NULL, NULL, NULL, NULL, 0, NULL, '2', 'Subha ', NULL, 'subha@gmail.com', 0, NULL, NULL, NULL, NULL, NULL, NULL, '78945612', NULL, NULL, '$2y$10$lVQJeUPQK1vjwgSmQEsj9eOU8/V7LMbmbsOI5x1kPT3GuQwWpf1p6', '78945612', 'images/OrHZjmAX1YI5678VXnuVwx59KJaTp1AUpU8AzSWZ.png', 'user_ids/bQqHrm7xa8SrYwReu31EBaPDtIP0dzcGTuBN5dhh.png', NULL, 'user_ids/xkumK0BZCrQrDBrXiM0Vs89KUKwi0YIaSvatFhqC.png', NULL, NULL, NULL, NULL, '07894561235', NULL, NULL, NULL, NULL, NULL, NULL, 1, '2024-12-26 07:42:11', '2025-01-09 08:50:31', NULL),
(18, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, 'Papiya Halder1', 'Blackburn Burton Associates', 'papiyahalder77@gmail.com', 0, NULL, NULL, '1993-12-01', NULL, NULL, NULL, '87987983', NULL, NULL, NULL, '87987983', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2024-12-27 08:14:56', '2024-12-27 08:14:56', '1'),
(19, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, 'Jaquelyn Mcpherson', 'Whitney Graham Associates', 'wodypytatu@mailinator.com', 0, NULL, NULL, '2004-10-19', NULL, NULL, NULL, '76232123', NULL, NULL, NULL, '76232123', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2024-12-30 01:37:32', '2024-12-30 01:37:32', '1'),
(20, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, 'Thaddeus Stephenson', 'Lara Burks Inc', 'qipyr@mailinator.com', 0, NULL, NULL, '1987-01-31', NULL, NULL, NULL, '76847894', NULL, NULL, NULL, '76847894', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2024-12-30 03:35:40', '2024-12-30 03:35:40', 'Optio cillum dolore'),
(21, NULL, NULL, NULL, NULL, NULL, 0, NULL, '2', 'Papiya Halder', NULL, 'papiyahaldersads@gmail.com', 0, NULL, NULL, NULL, NULL, NULL, NULL, '87987984', NULL, NULL, '$2y$10$hFiS5LxWPqAmZJu0vdAC7.ctYjUC2zUg1pD0FicnjtHQHLJ/FeB9O', '87987984', 'uploads/staff2/c5e28e5e-76af-43d5-9fc7-9eebee32c66c.png', 'uploads/staff/76cf0b3a-96bf-46c9-960e-cf57650d796e.png', NULL, 'uploads/staff/770abbab-b6ff-47f7-bb34-6f2741e35cc5.png', NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, 1, '2025-01-09 08:55:20', '2025-01-09 08:55:20', NULL),
(24, NULL, NULL, NULL, NULL, NULL, 0, NULL, '2', 'Rajib Ali Khan', NULL, 'rajibalikhan@gmail.com', 0, NULL, NULL, NULL, NULL, NULL, NULL, '12345678', NULL, NULL, '$2y$10$hFiS5LxWPqAmZJu0vdAC7.ctYjUC2zUg1pD0FicnjtHQHLJ/FeB9O$2y$10$lVQJeUPQK1vjwgSmQEsj9eOU8/V7LMbmbsOI5x1kPT3GuQwWpf1p6', '12345678', '', '', NULL, '', NULL, NULL, NULL, NULL, '23456788456', NULL, NULL, NULL, NULL, NULL, NULL, 1, '2025-01-28 01:16:20', '2025-01-28 01:16:20', NULL),
(32, NULL, NULL, NULL, 1, 1, 0, NULL, '2', 'Koushik Sen', NULL, 'koushika@gmail.com', 0, NULL, NULL, NULL, NULL, NULL, NULL, '+1234563456', NULL, NULL, '$2y$10$lVQJeUPQK1vjwgSmQEsj9eOU8/V7LMbmbsOI5x1kPT3GuQwWpf1p6', '+1234563456', '', '', NULL, '', '', '', '', '', '23456745678', NULL, NULL, NULL, NULL, NULL, NULL, 1, '2025-01-30 05:15:41', '2025-02-12 07:57:47', NULL),
(34, NULL, NULL, NULL, 1, NULL, 0, NULL, '2', 'Stanny Shop', NULL, 'stanny@gmail.com', 0, NULL, NULL, NULL, NULL, NULL, NULL, '23453456', NULL, NULL, '$2y$10$cFdnDFjg34q/f.4yFfjqduJKW5pqfyG5SgMckEHlWxvucHX7guoY2', '23453456', '', '', NULL, '', '', '', '', '', '', NULL, NULL, NULL, NULL, NULL, NULL, 1, '2025-02-05 02:13:56', '2025-02-05 02:13:56', NULL),
(35, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, 'Sandipa Das', 'Souvik group of company', 'sandipa@gmail.com', 0, NULL, NULL, '2025-02-07', NULL, NULL, NULL, '+123456345', NULL, NULL, NULL, '+123456345', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, 0.00, 0, NULL, NULL, 1, '2025-02-07 01:51:08', '2025-02-07 03:04:54', '');

-- --------------------------------------------------------

--
-- Table structure for table `user_address`
--

CREATE TABLE `user_address` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `address_type` varchar(255) NOT NULL COMMENT '1: billing; 2: shipping',
  `address` varchar(255) NOT NULL,
  `landmark` varchar(255) DEFAULT NULL,
  `city` varchar(255) NOT NULL,
  `state` varchar(255) DEFAULT NULL,
  `country` varchar(255) NOT NULL,
  `zip_code` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_address`
--

INSERT INTO `user_address` (`id`, `user_id`, `address_type`, `address`, `landmark`, `city`, `state`, `country`, `zip_code`, `created_at`, `updated_at`) VALUES
(11, 14, '1', 'New Adarshapally', 'Newtown bus stand', 'mum', 'guj', 'India', '700159', '2024-12-23 09:36:17', '2024-12-31 04:53:37'),
(12, 14, '2', 'New Adarshapally', 'Newtown bus stand', 'mum', 'guj', 'India', '700159', '2024-12-23 09:36:17', '2024-12-31 04:53:37'),
(13, 15, '1', 'New Adarshapally hhhhhhh', 'Newtown bus stand', 'mum', 'guj', 'India', '700159', '2024-12-23 09:42:05', '2025-01-02 01:05:52'),
(14, 15, '2', 'New Adarshapally', 'Newtown bus stand1111', 'mum', 'guj', 'India', '700159', '2024-12-23 09:42:05', '2025-01-02 01:05:52'),
(15, 16, '1', 'Kolkata user11', 'Newtown bus stand', 'Kolkata11', '', 'India', '700159', '2024-12-24 08:28:22', '2025-02-07 04:10:45'),
(16, 16, '2', 'Kolkata user11', 'Newtown bus stand', 'Kolkata11', '', 'India', '700159', '2024-12-24 08:28:22', '2025-02-07 04:10:45'),
(17, 17, '1', 'kolkata', '', 'kolkata', 'West Bengal', 'India', '70002', '2024-12-26 07:42:11', '2024-12-26 07:42:11'),
(18, 18, '1', 'New Adarshapally', 'Newtown bus stand', 'mum', 'West Bengal', 'India', '700159', '2024-12-27 08:14:56', '2024-12-27 08:14:56'),
(19, 18, '2', 'New Adarshapally', 'Newtown bus stand', 'mum', 'West Bengal', 'India', '700159', '2024-12-27 08:14:56', '2024-12-27 08:14:56'),
(20, 19, '1', 'Dolore ratione aut q', 'In a molestias offic', 'Accusantium assumend', 'Molestiae omnis eum', 'Quasi enim dolor exe', '939923', '2024-12-30 01:37:32', '2025-01-06 07:07:23'),
(21, 19, '2', 'Dolore ratione aut q', 'In a molestias offic', 'Accusantium assumend', 'Molestiae omnis eum', 'Quasi enim dolor exe', '939923', '2024-12-30 01:37:32', '2025-01-06 07:07:23'),
(22, 20, '1', 'Quam aut sit provide', 'Incidunt non amet ', 'Elit et ea et conse', 'Voluptate voluptate ', 'Deleniti minima duis', '123456', '2024-12-30 03:35:40', '2024-12-30 03:35:40'),
(23, 20, '2', 'Quam aut sit provide', 'Incidunt non amet ', 'Elit et ea et conse', 'Voluptate voluptate ', 'Deleniti minima duis', '123456', '2024-12-30 03:35:40', '2024-12-30 03:35:40'),
(24, 21, '1', 'New Adarshapally', '', 'mum', 'guj', 'India', '700159', '2025-01-09 08:55:20', '2025-01-09 08:55:20'),
(25, 22, '1', '', '', '', '', '', '', '2025-01-28 00:56:41', '2025-01-28 00:56:41'),
(26, 23, '1', '', '', '', '', '', '', '2025-01-28 01:02:25', '2025-01-28 01:02:25'),
(27, 24, '1', '', '', '', '', '', '', '2025-01-28 01:16:20', '2025-01-28 01:16:20'),
(28, 25, '1', '', '', '', '', '', '', '2025-01-28 04:30:47', '2025-01-28 04:30:47'),
(29, 26, '1', '', '', '', '', '', '', '2025-01-28 04:41:51', '2025-01-28 04:41:51'),
(30, 27, '1', '', '', '', '', '', '', '2025-01-28 04:46:08', '2025-01-28 04:46:08'),
(31, 28, '1', '', '', '', '', '', '', '2025-01-28 04:47:38', '2025-01-28 04:47:38'),
(32, 29, '1', '', '', '', '', '', '', '2025-01-28 05:36:03', '2025-01-28 05:36:03'),
(33, 30, '1', '', '', '', '', '', '', '2025-01-29 07:19:37', '2025-01-29 07:19:37'),
(34, 31, '1', '', '', '', '', '', '', '2025-01-29 07:31:03', '2025-01-29 07:31:03'),
(35, 32, '1', '', '', '', '', '', '', '2025-01-30 05:15:41', '2025-01-30 05:15:41'),
(36, 33, '1', '', '', '', '', '', '', '2025-02-05 01:52:37', '2025-02-05 01:52:37'),
(37, 34, '1', '', '', '', '', '', '', '2025-02-05 02:13:56', '2025-02-05 02:13:56'),
(38, 35, '1', 'Kolkata', NULL, 'Kolkata', '', 'India', '7000015', '2025-02-07 01:51:08', '2025-02-07 01:51:08'),
(39, 35, '2', 'Kolkata', NULL, 'Kolkata', '', 'India', '7000015', '2025-02-07 01:51:08', '2025-02-07 01:51:08');

-- --------------------------------------------------------

--
-- Table structure for table `user_banks`
--

CREATE TABLE `user_banks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `account_holder_name` varchar(255) NOT NULL COMMENT 'Banking credentials',
  `bank_name` varchar(255) DEFAULT NULL COMMENT 'Banking credentials',
  `branch_name` varchar(255) DEFAULT NULL COMMENT 'Banking credentials',
  `bank_account_no` varchar(255) DEFAULT NULL COMMENT 'Banking credentials',
  `ifsc` varchar(255) DEFAULT NULL COMMENT 'Banking credentials',
  `monthly_salary` double DEFAULT NULL COMMENT 'Salary & allowance',
  `daily_salary` double DEFAULT NULL COMMENT 'Salary & allowance',
  `travelling_allowance` double DEFAULT NULL COMMENT 'Salary & allowance',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_banks`
--

INSERT INTO `user_banks` (`id`, `user_id`, `account_holder_name`, `bank_name`, `branch_name`, `bank_account_no`, `ifsc`, `monthly_salary`, `daily_salary`, `travelling_allowance`, `created_at`, `updated_at`) VALUES
(5, 17, 'Subha ', 'SBI', 'Jhargram', '7894561236', 'dbvvdvsc78', 78555, 1222, 22, '2024-12-26 07:42:11', '2024-12-26 07:42:11'),
(6, 21, '', '', '', '', '', 12000, NULL, NULL, '2025-01-09 08:55:20', '2025-01-09 08:55:20'),
(7, 22, '', '', '', '', '', 900000, NULL, NULL, '2025-01-28 00:56:41', '2025-01-28 00:56:41'),
(8, 23, '', '', '', '', '', 89999, NULL, NULL, '2025-01-28 01:02:25', '2025-01-28 01:02:25'),
(9, 24, '', '', '', '', '', 23445, NULL, NULL, '2025-01-28 01:16:20', '2025-01-28 01:16:20'),
(10, 25, '', '', '', '', '', 12345, NULL, NULL, '2025-01-28 04:30:47', '2025-01-28 04:30:47'),
(11, 26, '', '', '', '', '', 2345678, NULL, NULL, '2025-01-28 04:41:51', '2025-01-28 04:41:51'),
(12, 27, '', '', '', '', '', 23456, NULL, NULL, '2025-01-28 04:46:08', '2025-01-28 04:46:08'),
(13, 28, '', '', '', '', '', 3234567, NULL, NULL, '2025-01-28 04:47:38', '2025-01-28 04:47:38'),
(14, 29, '', '', '', '', '', 234567, NULL, NULL, '2025-01-28 05:36:03', '2025-01-28 05:36:03'),
(15, 30, '', '', '', '', '', 2345234523, NULL, NULL, '2025-01-29 07:19:37', '2025-01-29 07:19:37'),
(16, 31, '', '', '', '', '', 23434534, NULL, NULL, '2025-01-29 07:31:03', '2025-01-29 07:31:03'),
(17, 32, '', '', '', '', '', 234567845, NULL, NULL, '2025-01-30 05:15:41', '2025-01-30 05:15:41'),
(18, 33, '', '', '', '', '', 23453454, NULL, NULL, '2025-02-05 01:52:37', '2025-02-05 01:52:37'),
(19, 34, '', '', '', '', '', 234234534, NULL, NULL, '2025-02-05 02:13:56', '2025-02-05 02:13:56');

-- --------------------------------------------------------

--
-- Table structure for table `user_roles`
--

CREATE TABLE `user_roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `designation_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_roles`
--

INSERT INTO `user_roles` (`id`, `designation_id`, `role_id`, `created_at`, `updated_at`) VALUES
(1, 1, 1, NULL, NULL),
(2, 2, 1, NULL, NULL),
(6, 2, 7, NULL, NULL),
(7, 2, 2, NULL, NULL),
(8, 1, 5, NULL, NULL),
(9, 1, 9, NULL, NULL),
(10, 1, 2, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `admins_email_unique` (`email`);

--
-- Indexes for table `branches`
--
ALTER TABLE `branches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `business_types`
--
ALTER TABLE `business_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `catalogues`
--
ALTER TABLE `catalogues`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `catalogue_titles`
--
ALTER TABLE `catalogue_titles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `categories_collection_id_foreign` (`collection_id`);

--
-- Indexes for table `cities`
--
ALTER TABLE `cities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `city_user`
--
ALTER TABLE `city_user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `city_user_user_id_foreign` (`user_id`),
  ADD KEY `city_user_city_id_foreign` (`city_id`);

--
-- Indexes for table `collections`
--
ALTER TABLE `collections`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `designation`
--
ALTER TABLE `designation`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `expences`
--
ALTER TABLE `expences`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fabrics`
--
ALTER TABLE `fabrics`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `galleries`
--
ALTER TABLE `galleries`
  ADD PRIMARY KEY (`id`),
  ADD KEY `galleries_product_id_foreign` (`product_id`);

--
-- Indexes for table `invoices`
--
ALTER TABLE `invoices`
  ADD PRIMARY KEY (`id`),
  ADD KEY `invoices_order_id_foreign` (`order_id`),
  ADD KEY `invoices_customer_id_foreign` (`customer_id`),
  ADD KEY `invoices_user_id_foreign` (`user_id`);

--
-- Indexes for table `invoice_payments`
--
ALTER TABLE `invoice_payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `invoice_payments_invoice_id_foreign` (`invoice_id`),
  ADD KEY `invoice_payments_payment_collection_id_foreign` (`payment_collection_id`);

--
-- Indexes for table `journals`
--
ALTER TABLE `journals`
  ADD PRIMARY KEY (`id`),
  ADD KEY `journals_payment_id_foreign` (`payment_id`);

--
-- Indexes for table `ledgers`
--
ALTER TABLE `ledgers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ledgers_staff_id_foreign` (`staff_id`),
  ADD KEY `ledgers_customer_id_foreign` (`customer_id`),
  ADD KEY `ledgers_supplier_id_foreign` (`supplier_id`),
  ADD KEY `ledgers_admin_id_foreign` (`admin_id`),
  ADD KEY `ledgers_payment_id_foreign` (`payment_id`);

--
-- Indexes for table `measurements`
--
ALTER TABLE `measurements`
  ADD PRIMARY KEY (`id`),
  ADD KEY `measurements_product_id_foreign` (`product_id`);

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
  ADD UNIQUE KEY `orders_order_number_unique` (`order_number`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_items_order_id_foreign` (`order_id`),
  ADD KEY `order_items_product_id_foreign` (`product_id`),
  ADD KEY `order_items_collection_type_foreign` (`collection`);

--
-- Indexes for table `order_measurements`
--
ALTER TABLE `order_measurements`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_measurements_order_item_id_foreign` (`order_item_id`);

--
-- Indexes for table `otps`
--
ALTER TABLE `otps`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `otps_phone_unique` (`phone`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `packingslips`
--
ALTER TABLE `packingslips`
  ADD PRIMARY KEY (`id`),
  ADD KEY `packingslips_order_id_foreign` (`order_id`),
  ADD KEY `packingslips_customer_id_foreign` (`customer_id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `payments_order_id_foreign` (`order_id`),
  ADD KEY `payments_admin_id_foreign` (`admin_id`),
  ADD KEY `payments_supplier_id_foreign` (`supplier_id`),
  ADD KEY `payments_expense_id_foreign` (`expense_id`),
  ADD KEY `payments_stuff_id_foreign` (`stuff_id`),
  ADD KEY `payments_customer_id_foreign` (`customer_id`);

--
-- Indexes for table `payment_collections`
--
ALTER TABLE `payment_collections`
  ADD PRIMARY KEY (`id`),
  ADD KEY `payment_collections_customer_id_foreign` (`customer_id`),
  ADD KEY `payment_collections_user_id_foreign` (`user_id`),
  ADD KEY `payment_collections_admin_id_foreign` (`admin_id`),
  ADD KEY `payment_collections_payment_id_foreign` (`payment_id`);

--
-- Indexes for table `payment_revokes`
--
ALTER TABLE `payment_revokes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `payment_revokes_customer_id_foreign` (`customer_id`),
  ADD KEY `payment_revokes_done_by_foreign` (`done_by`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `products_category_id_foreign` (`category_id`),
  ADD KEY `products_sub_category_id_foreign` (`sub_category_id`),
  ADD KEY `products_collection_id_foreign` (`collection_id`);

--
-- Indexes for table `product_fabrics`
--
ALTER TABLE `product_fabrics`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_fabrics_product_id_foreign` (`product_id`),
  ADD KEY `product_fabrics_fabric_id_foreign` (`fabric_id`);

--
-- Indexes for table `product_images`
--
ALTER TABLE `product_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_images_product_id_foreign` (`product_id`);

--
-- Indexes for table `purchase_orders`
--
ALTER TABLE `purchase_orders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `purchase_orders_unique_id_unique` (`unique_id`),
  ADD KEY `purchase_orders_supplier_id_foreign` (`supplier_id`);

--
-- Indexes for table `purchase_order_products`
--
ALTER TABLE `purchase_order_products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `purchase_order_products_purchase_order_id_foreign` (`purchase_order_id`),
  ADD KEY `purchase_order_products_collection_id_foreign` (`collection_id`),
  ADD KEY `purchase_order_products_fabric_id_foreign` (`fabric_id`),
  ADD KEY `purchase_order_products_product_id_foreign` (`product_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_slug_unique` (`slug`);

--
-- Indexes for table `salesman_billing_number`
--
ALTER TABLE `salesman_billing_number`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stocks`
--
ALTER TABLE `stocks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `stocks_purchase_order_id_foreign` (`purchase_order_id`);

--
-- Indexes for table `stock_fabrics`
--
ALTER TABLE `stock_fabrics`
  ADD PRIMARY KEY (`id`),
  ADD KEY `stock_fabrics_stock_id_foreign` (`stock_id`),
  ADD KEY `stock_fabrics_fabric_id_foreign` (`fabric_id`);

--
-- Indexes for table `stock_products`
--
ALTER TABLE `stock_products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `stock_products_stock_id_foreign` (`stock_id`),
  ADD KEY `stock_products_product_id_foreign` (`product_id`);

--
-- Indexes for table `sub_categories`
--
ALTER TABLE `sub_categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sub_categories_category_id_foreign` (`category_id`);

--
-- Indexes for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `suppliers_email_unique` (`email`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `users_business_type_foreign` (`business_type`);

--
-- Indexes for table `user_address`
--
ALTER TABLE `user_address`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_address_user_id_foreign` (`user_id`);

--
-- Indexes for table `user_banks`
--
ALTER TABLE `user_banks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_banks_user_id_foreign` (`user_id`);

--
-- Indexes for table `user_roles`
--
ALTER TABLE `user_roles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_roles_designation_id_foreign` (`designation_id`),
  ADD KEY `user_roles_role_id_foreign` (`role_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `branches`
--
ALTER TABLE `branches`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `business_types`
--
ALTER TABLE `business_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `catalogues`
--
ALTER TABLE `catalogues`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `catalogue_titles`
--
ALTER TABLE `catalogue_titles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `cities`
--
ALTER TABLE `cities`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `city_user`
--
ALTER TABLE `city_user`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `collections`
--
ALTER TABLE `collections`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `countries`
--
ALTER TABLE `countries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `designation`
--
ALTER TABLE `designation`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `expences`
--
ALTER TABLE `expences`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `fabrics`
--
ALTER TABLE `fabrics`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `galleries`
--
ALTER TABLE `galleries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `invoices`
--
ALTER TABLE `invoices`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `invoice_payments`
--
ALTER TABLE `invoice_payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `journals`
--
ALTER TABLE `journals`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `ledgers`
--
ALTER TABLE `ledgers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `measurements`
--
ALTER TABLE `measurements`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=128;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `order_measurements`
--
ALTER TABLE `order_measurements`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=364;

--
-- AUTO_INCREMENT for table `otps`
--
ALTER TABLE `otps`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `packingslips`
--
ALTER TABLE `packingslips`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `payment_collections`
--
ALTER TABLE `payment_collections`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `payment_revokes`
--
ALTER TABLE `payment_revokes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `product_fabrics`
--
ALTER TABLE `product_fabrics`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `product_images`
--
ALTER TABLE `product_images`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `purchase_orders`
--
ALTER TABLE `purchase_orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `purchase_order_products`
--
ALTER TABLE `purchase_order_products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `salesman_billing_number`
--
ALTER TABLE `salesman_billing_number`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `stocks`
--
ALTER TABLE `stocks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `stock_fabrics`
--
ALTER TABLE `stock_fabrics`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `stock_products`
--
ALTER TABLE `stock_products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sub_categories`
--
ALTER TABLE `sub_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `user_address`
--
ALTER TABLE `user_address`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `user_banks`
--
ALTER TABLE `user_banks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `user_roles`
--
ALTER TABLE `user_roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `categories`
--
ALTER TABLE `categories`
  ADD CONSTRAINT `categories_collection_id_foreign` FOREIGN KEY (`collection_id`) REFERENCES `collections` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `city_user`
--
ALTER TABLE `city_user`
  ADD CONSTRAINT `city_user_city_id_foreign` FOREIGN KEY (`city_id`) REFERENCES `cities` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `city_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `galleries`
--
ALTER TABLE `galleries`
  ADD CONSTRAINT `galleries_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `invoices`
--
ALTER TABLE `invoices`
  ADD CONSTRAINT `invoices_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `invoices_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `invoices_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `invoice_payments`
--
ALTER TABLE `invoice_payments`
  ADD CONSTRAINT `invoice_payments_invoice_id_foreign` FOREIGN KEY (`invoice_id`) REFERENCES `invoices` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `invoice_payments_payment_collection_id_foreign` FOREIGN KEY (`payment_collection_id`) REFERENCES `payment_collections` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `journals`
--
ALTER TABLE `journals`
  ADD CONSTRAINT `journals_payment_id_foreign` FOREIGN KEY (`payment_id`) REFERENCES `payments` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `ledgers`
--
ALTER TABLE `ledgers`
  ADD CONSTRAINT `ledgers_admin_id_foreign` FOREIGN KEY (`admin_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `ledgers_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `ledgers_payment_id_foreign` FOREIGN KEY (`payment_id`) REFERENCES `payments` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `ledgers_staff_id_foreign` FOREIGN KEY (`staff_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `ledgers_supplier_id_foreign` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `measurements`
--
ALTER TABLE `measurements`
  ADD CONSTRAINT `measurements_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `order_measurements`
--
ALTER TABLE `order_measurements`
  ADD CONSTRAINT `order_measurements_order_item_id_foreign` FOREIGN KEY (`order_item_id`) REFERENCES `order_items` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `packingslips`
--
ALTER TABLE `packingslips`
  ADD CONSTRAINT `packingslips_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `packingslips_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_admin_id_foreign` FOREIGN KEY (`admin_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `payments_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `payments_expense_id_foreign` FOREIGN KEY (`expense_id`) REFERENCES `expences` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `payments_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `payments_stuff_id_foreign` FOREIGN KEY (`stuff_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `payments_supplier_id_foreign` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `payment_collections`
--
ALTER TABLE `payment_collections`
  ADD CONSTRAINT `payment_collections_admin_id_foreign` FOREIGN KEY (`admin_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `payment_collections_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `payment_collections_payment_id_foreign` FOREIGN KEY (`payment_id`) REFERENCES `payments` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `payment_collections_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `payment_revokes`
--
ALTER TABLE `payment_revokes`
  ADD CONSTRAINT `payment_revokes_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `payment_revokes_done_by_foreign` FOREIGN KEY (`done_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `product_images`
--
ALTER TABLE `product_images`
  ADD CONSTRAINT `product_images_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `stocks`
--
ALTER TABLE `stocks`
  ADD CONSTRAINT `stocks_purchase_order_id_foreign` FOREIGN KEY (`purchase_order_id`) REFERENCES `purchase_orders` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `stock_fabrics`
--
ALTER TABLE `stock_fabrics`
  ADD CONSTRAINT `stock_fabrics_fabric_id_foreign` FOREIGN KEY (`fabric_id`) REFERENCES `fabrics` (`id`),
  ADD CONSTRAINT `stock_fabrics_stock_id_foreign` FOREIGN KEY (`stock_id`) REFERENCES `stocks` (`id`);

--
-- Constraints for table `stock_products`
--
ALTER TABLE `stock_products`
  ADD CONSTRAINT `stock_products_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `stock_products_stock_id_foreign` FOREIGN KEY (`stock_id`) REFERENCES `stocks` (`id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_business_type_foreign` FOREIGN KEY (`business_type`) REFERENCES `business_types` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
