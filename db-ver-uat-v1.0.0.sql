-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 09, 2024 at 12:07 PM
-- Server version: 5.7.23-23
-- PHP Version: 8.1.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ehostsx5_school_shiksha`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_blocks`
--

CREATE TABLE `tbl_blocks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `district_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `is_active` tinyint(4) DEFAULT '1',
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tbl_blocks`
--

INSERT INTO `tbl_blocks` (`id`, `district_id`, `name`, `is_active`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 2, 'Monteswar', 1, 1, NULL, '2024-04-25 17:26:46', NULL),
(2, 3, 'Dumraon', 1, 1, 1, '2024-04-30 12:17:05', '2024-04-30 12:17:23'),
(4, 6, 'Matigara', 1, 1, NULL, '2024-05-02 15:15:45', NULL),
(5, 9, 'Andheri', 0, 1, 1, '2024-05-06 19:55:32', '2024-05-06 19:56:09'),
(6, 9, 'Bandra', 1, 1, NULL, '2024-05-06 19:55:56', NULL),
(7, 14, 'Bangalore East', 1, 1, NULL, '2024-05-08 15:30:10', NULL),
(8, 14, 'Bangalore North', 1, 1, NULL, '2024-05-08 15:31:09', NULL),
(9, 14, 'Bangalore South', 1, 1, NULL, '2024-05-08 15:31:29', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_courses`
--

CREATE TABLE `tbl_courses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(300) COLLATE utf8_unicode_ci DEFAULT NULL,
  `course_details` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `course_type` enum('online_course','computer_course','others') COLLATE utf8_unicode_ci DEFAULT NULL,
  `is_active` tinyint(4) DEFAULT '1',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tbl_courses`
--

INSERT INTO `tbl_courses` (`id`, `name`, `course_details`, `course_type`, `is_active`, `created_at`, `updated_at`) VALUES
(5, 'Bachelor of Computer Applications (BCA)', '3 years (6 semester)', 'computer_course', 1, '2024-05-08 16:09:51', '2024-05-08 16:12:52'),
(6, 'Masters of Computer Applications (MCA)', '3 years (6 semester) ', 'computer_course', 1, '2024-05-08 16:10:04', '2024-05-08 16:12:30');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_course_services`
--

CREATE TABLE `tbl_course_services` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `service_id` bigint(20) UNSIGNED DEFAULT NULL,
  `org_course_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tbl_course_services`
--

INSERT INTO `tbl_course_services` (`id`, `service_id`, `org_course_id`) VALUES
(16, 12, 11),
(17, 13, 10),
(18, 13, 11),
(19, 14, 10),
(20, 14, 11),
(21, 15, 11),
(22, 16, 11),
(23, 17, 11),
(24, 18, 11),
(25, 19, 11),
(26, 20, 11),
(27, 21, 10),
(28, 21, 11),
(29, 22, 10),
(30, 22, 11),
(31, 23, 10),
(32, 23, 11),
(33, 24, 10),
(34, 24, 11),
(35, 25, 10),
(36, 25, 11),
(37, 26, 10),
(38, 26, 11),
(39, 27, 10),
(40, 27, 11);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_districts`
--

CREATE TABLE `tbl_districts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `state_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `is_active` tinyint(4) DEFAULT '1',
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tbl_districts`
--

INSERT INTO `tbl_districts` (`id`, `state_id`, `name`, `is_active`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(2, 1, 'Purba Bardhaman', 1, 1, NULL, '2024-04-25 17:26:02', NULL),
(3, NULL, 'Buxer', 1, 1, NULL, '2024-04-30 12:16:11', '2024-04-30 12:16:51'),
(6, 1, ' Darjeeling', 1, 1, NULL, '2024-05-02 15:13:26', NULL),
(7, 1, 'Hoogly', 1, 1, NULL, '2024-05-02 15:13:54', NULL),
(9, 4, 'Mumbai City', 1, 1, NULL, '2024-05-06 19:53:22', NULL),
(11, 4, 'Pune', 1, 1, NULL, '2024-05-06 19:54:17', NULL),
(12, 4, 'Nagpur', 1, 1, NULL, '2024-05-06 19:54:30', NULL),
(13, 7, 'Davanagere', 1, 1, NULL, '2024-05-08 15:26:39', NULL),
(14, 7, 'Bengaluru ', 1, 1, NULL, '2024-05-08 15:27:04', NULL),
(15, 7, 'Mysuru', 1, 1, NULL, '2024-05-08 15:27:20', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_enquires`
--

CREATE TABLE `tbl_enquires` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `enquiry_number` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `service_id` bigint(20) UNSIGNED DEFAULT NULL,
  `service_commission_amount` decimal(10,2) DEFAULT '0.00',
  `enquiry_details` longtext COLLATE utf8_unicode_ci,
  `documents` longtext COLLATE utf8_unicode_ci,
  `status` enum('pending','rejected','completed','onhold') COLLATE utf8_unicode_ci DEFAULT 'pending',
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_invoices`
--

CREATE TABLE `tbl_invoices` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `uniq_invoice_id` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `invoice_date` date DEFAULT NULL,
  `due_date` date DEFAULT NULL,
  `subtotal` decimal(10,2) DEFAULT NULL,
  `discount` decimal(10,2) DEFAULT '0.00',
  `total` decimal(10,2) DEFAULT '0.00',
  `status` enum('paid','unpaid') COLLATE utf8_unicode_ci DEFAULT NULL,
  `payment_url` longtext COLLATE utf8_unicode_ci,
  `extra_note` longtext COLLATE utf8_unicode_ci,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tbl_invoices`
--

INSERT INTO `tbl_invoices` (`id`, `user_id`, `uniq_invoice_id`, `invoice_date`, `due_date`, `subtotal`, `discount`, `total`, `status`, `payment_url`, `extra_note`, `created_at`, `updated_at`) VALUES
(2, 42, 'INV-0001', '2024-05-08', '2024-05-08', 4999.00, 0.00, 4999.00, 'paid', NULL, NULL, '2024-05-08 17:43:12', NULL),
(3, 43, 'INV-0002', '2024-05-08', '2024-05-08', 2499.00, 0.00, 2499.00, 'paid', NULL, NULL, '2024-05-08 18:13:21', NULL),
(4, 44, 'INV-0003', '2024-05-08', '2024-05-08', 1499.00, 0.00, 1499.00, 'paid', NULL, NULL, '2024-05-08 18:22:42', NULL),
(5, 45, 'INV-0004', '2024-05-08', '2024-05-08', 0.00, 0.00, 0.00, 'paid', NULL, NULL, '2024-05-08 19:04:21', NULL),
(6, 46, 'INV-0005', '2024-05-08', '2024-05-08', 0.00, 0.00, 0.00, 'paid', NULL, NULL, '2024-05-08 19:09:37', NULL),
(7, 47, 'INV-0006', '2024-05-08', '2024-05-08', 0.00, 0.00, 0.00, 'paid', NULL, NULL, '2024-05-08 19:11:17', NULL),
(8, 48, 'INV-0007', '2024-05-08', '2024-05-08', 0.00, 0.00, 0.00, 'paid', NULL, NULL, '2024-05-08 19:12:52', NULL),
(9, 49, 'INV-0008', '2024-05-08', '2024-05-08', 299.00, 0.00, 299.00, 'paid', NULL, NULL, '2024-05-08 19:18:32', NULL),
(10, 50, 'INV-0009', '2024-05-08', '2024-05-08', 0.00, 0.00, 0.00, 'paid', NULL, NULL, '2024-05-08 19:30:01', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_invoice_items`
--

CREATE TABLE `tbl_invoice_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `invoice_id` bigint(20) UNSIGNED NOT NULL,
  `item_description` longtext COLLATE utf8_unicode_ci,
  `quantity` int(11) DEFAULT NULL,
  `unit_amount` decimal(10,2) DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tbl_invoice_items`
--

INSERT INTO `tbl_invoice_items` (`id`, `invoice_id`, `item_description`, `quantity`, `unit_amount`, `amount`) VALUES
(2, 2, 'PAID MASTER DISTRIBUTOR ENTRY', 1, 4999.00, 4999.00),
(3, 3, 'Paid DISTRIBUTOR ENTRY', 1, 2499.00, 2499.00),
(4, 4, 'Paid Affiliate Agent', 1, 1499.00, 1499.00),
(5, 5, 'FREE STUDENT REGISTRATION ', 1, 0.00, 0.00),
(6, 6, 'FREE STUDENT REGISTRATION ', 1, 0.00, 0.00),
(7, 7, 'FREE STUDENT REGISTRATION ', 1, 0.00, 0.00),
(8, 8, 'FREE STUDENT REGISTRATION ', 1, 0.00, 0.00),
(9, 9, '299 PLUS MEMBER ', 1, 299.00, 299.00),
(10, 10, 'FREE STUDENT REGISTRATION ', 1, 0.00, 0.00);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_notifications`
--

CREATE TABLE `tbl_notifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `subject` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `message` text COLLATE utf8_unicode_ci,
  `is_read` tinyint(4) DEFAULT '0',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_organizations`
--

CREATE TABLE `tbl_organizations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(300) COLLATE utf8_unicode_ci DEFAULT NULL,
  `logo` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `state_id` bigint(20) UNSIGNED DEFAULT NULL,
  `district_id` bigint(20) UNSIGNED DEFAULT NULL,
  `block_id` bigint(20) UNSIGNED DEFAULT NULL,
  `is_active` tinyint(4) DEFAULT '1',
  `type` enum('college','others') COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tbl_organizations`
--

INSERT INTO `tbl_organizations` (`id`, `name`, `logo`, `state_id`, `district_id`, `block_id`, `is_active`, `type`, `created_at`, `updated_at`) VALUES
(1, 'Organizations One', '1714477327_97e6f5e67f675e2543a3.jpg', 1, NULL, NULL, 1, 'college', '2024-04-24 13:15:47', '2024-04-30 11:42:07'),
(3, 'Testing Organization ', '1714645577_593bb9c1e39423f3c606.jpg', 1, 6, 4, 1, 'college', '2024-05-02 10:26:17', NULL),
(4, 'Education Organization ', '1715005097_5f1b31c9ad3f2e3d1c09.png', 1, 2, 1, 1, 'others', '2024-05-06 19:48:17', '2024-05-06 19:48:42'),
(5, 'Final Testing Organization ', '1715162991_2a7e4504c635a7c3089a.png', 7, 14, 8, 1, 'college', '2024-05-08 15:39:51', '2024-05-08 16:01:44');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_organizations_course`
--

CREATE TABLE `tbl_organizations_course` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `organization_id` bigint(20) UNSIGNED DEFAULT NULL,
  `course_id` bigint(20) UNSIGNED DEFAULT NULL,
  `course_fees` decimal(10,2) DEFAULT '0.00',
  `course_duration` tinyint(4) DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tbl_organizations_course`
--

INSERT INTO `tbl_organizations_course` (`id`, `organization_id`, `course_id`, `course_fees`, `course_duration`, `created_at`, `updated_at`) VALUES
(10, 5, 6, 230000.00, 36, '2024-05-08 16:20:09', NULL),
(11, 5, 5, 180000.00, 36, '2024-05-08 16:20:22', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_plans`
--

CREATE TABLE `tbl_plans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED DEFAULT NULL,
  `plan_name` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `plan_amount` decimal(10,2) NOT NULL,
  `plan_duration` tinyint(4) DEFAULT NULL COMMENT 'respect to month',
  `plan_description` text COLLATE utf8_unicode_ci,
  `is_active` tinyint(4) DEFAULT '1',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tbl_plans`
--

INSERT INTO `tbl_plans` (`id`, `role_id`, `plan_name`, `plan_amount`, `plan_duration`, `plan_description`, `is_active`, `created_at`, `updated_at`) VALUES
(15, 5, 'FREE STUDENT REGISTRATION ', 0.00, 12, '[\"\"]', 1, '2024-05-08 16:48:16', NULL),
(16, 5, '299 PLUS MEMBER ', 299.00, 12, '[\"299+ MEMBER \"]', 1, '2024-05-08 16:49:25', NULL),
(17, 5, '499 PLUS MEMBER ', 499.00, 12, '[\"499 + Members\"]', 1, '2024-05-08 16:50:11', NULL),
(18, 4, 'Free Affiliate Agent', 0.00, 12, '[\"\"]', 1, '2024-05-08 17:34:00', NULL),
(19, 4, 'Paid Affiliate Agent', 1499.00, 12, '[\"\"]', 1, '2024-05-08 17:34:56', NULL),
(20, 3, 'FREE DISTRIBUTOR ENTRY', 0.00, 12, '[\"\"]', 1, '2024-05-08 17:35:56', NULL),
(21, 3, 'Paid DISTRIBUTOR ENTRY', 2499.00, 12, '[\"\"]', 1, '2024-05-08 17:36:26', NULL),
(23, 2, 'FREE MASTER DISTRIBUTOR ENTRY', 0.00, 12, '[\"\"]', 1, '2024-05-08 17:40:44', NULL),
(24, 2, 'PAID MASTER DISTRIBUTOR ENTRY', 4999.00, 12, '[\"\"]', 1, '2024-05-08 17:41:05', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_plan_commission`
--

CREATE TABLE `tbl_plan_commission` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED DEFAULT NULL,
  `plan_id` bigint(20) UNSIGNED DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tbl_plan_commission`
--

INSERT INTO `tbl_plan_commission` (`id`, `role_id`, `plan_id`, `amount`) VALUES
(13, 4, 15, 10.00),
(14, 4, 16, 40.00),
(15, 4, 17, 100.00),
(16, 3, 18, 0.00),
(17, 3, 19, 300.00),
(18, 2, 20, 0.00),
(19, 2, 21, 500.00);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_plan_services`
--

CREATE TABLE `tbl_plan_services` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `plan_id` bigint(20) UNSIGNED DEFAULT NULL,
  `service_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_roles`
--

CREATE TABLE `tbl_roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `role_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tbl_roles`
--

INSERT INTO `tbl_roles` (`id`, `role_name`, `created_at`, `updated_at`) VALUES
(1, 'super_admin', '2024-04-23 00:43:33', '2024-04-22 19:11:16'),
(2, 'master_distributor', '2024-04-23 00:43:33', '2024-04-22 19:11:16'),
(3, 'distributor', '2024-04-23 00:43:33', '2024-04-22 19:11:16'),
(4, 'affiliate_agent', '2024-04-23 00:43:33', '2024-05-08 12:39:08'),
(5, 'student', '2024-04-25 17:21:35', '2024-04-25 11:51:25');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_services`
--

CREATE TABLE `tbl_services` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `service_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `intended_for` enum('hs','mp','graduate','other') COLLATE utf8_unicode_ci DEFAULT NULL,
  `image` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `is_active` tinyint(4) DEFAULT '1',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tbl_services`
--

INSERT INTO `tbl_services` (`id`, `service_name`, `intended_for`, `image`, `is_active`, `created_at`, `updated_at`) VALUES
(12, 'FREE COLLEGE ADMISSION', 'graduate', '1715167491_f5c4fbdc3e4447d2fd3e.png', 1, '2024-05-08 16:54:51', NULL),
(13, 'PAID COLLEGE ADMISSION', 'graduate', '1715167781_5209de3325ef5a588c6a.png', 1, '2024-05-08 16:59:41', NULL),
(14, 'STUDENT LOAN', 'graduate', '1715167911_1db121054f1e64f46c74.png', 1, '2024-05-08 17:01:51', NULL),
(15, 'PAID SCHOLARSHIP THROUGH THE ENTRANCE EXAM ', 'graduate', '1715167942_6d494d4da112f1afca48.png', 1, '2024-05-08 17:02:22', NULL),
(16, 'NGO. SCHOLARSHIP', 'graduate', '1715167973_f9be623f9df4cc2287a4.png', 1, '2024-05-08 17:02:53', NULL),
(17, 'GOVT. SCHOLARSHIP & PRIVATE SCHOLARSHIP ', 'graduate', '1715168338_0d74974fa46c9529e7c0.png', 1, '2024-05-08 17:08:58', NULL),
(18, 'STUDENT FREE CERTIFICATE COURSE WITH JOB VACANCY', 'graduate', '1715168366_54b1c9755cf90def3736.png', 1, '2024-05-08 17:09:26', NULL),
(19, 'STUDENT PAID CERTIFICATE COURSE ', 'graduate', '1715168408_96336cd1151ae795f31f.png', 1, '2024-05-08 17:10:08', NULL),
(20, 'NAPS & NATS (GOVT. APPRENTSHIP TRAINING WITH STIPHEN)', 'graduate', '1715168433_aa058d3e0b85d885401b.png', 1, '2024-05-08 17:10:33', NULL),
(21, 'VOCATIONAL TRAINING & INTERNSHIP TRAINING OF COLLEGE CANDIDATES', 'graduate', '1715168468_0ce7ac82e435657846e4.png', 1, '2024-05-08 17:11:08', NULL),
(22, 'JOB CAMPASING & PRIVATE PLACEMENT THROUGH THE EXAM', 'graduate', '1715168489_00194a09518c6bccd453.png', 1, '2024-05-08 17:11:29', NULL),
(23, 'EDUCATION LOAN THROUGH THE N.G.O & MICROFINANCE', 'graduate', '1715168517_ca390257959d2a4b2550.png', 1, '2024-05-08 17:11:57', NULL),
(24, 'FREE AGENT ENTRY', 'graduate', '1715168739_4edf42c9273a3a18f37f.png', 1, '2024-05-08 17:15:39', NULL),
(25, 'PAID AFFILATE AGENT', 'graduate', '1715168761_e7995b732df366ebcdb5.png', 1, '2024-05-08 17:16:01', NULL),
(26, 'FREE DISTRIBUTOR ENTRY', 'graduate', '1715168859_669beaca7e189f66af69.png', 1, '2024-05-08 17:17:39', NULL),
(27, 'PAID DISTRIBUTOR ENTRY', 'graduate', '1715168880_99a7f17dfbbb9f3d3b17.png', 1, '2024-05-08 17:18:00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_service_comissions`
--

CREATE TABLE `tbl_service_comissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED DEFAULT NULL,
  `service_id` bigint(20) UNSIGNED DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT '0.00',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tbl_service_comissions`
--

INSERT INTO `tbl_service_comissions` (`id`, `role_id`, `service_id`, `amount`, `created_at`, `updated_at`) VALUES
(9, 4, 12, 1500.00, '2024-05-08 17:03:28', NULL),
(10, 4, 13, 10000.00, '2024-05-08 17:04:05', NULL),
(11, 4, 14, 100.00, '2024-05-08 17:06:18', NULL),
(12, 4, 15, 1000.00, '2024-05-08 17:07:02', NULL),
(13, 4, 16, 200.00, '2024-05-08 17:07:17', NULL),
(14, 4, 17, 0.00, '2024-05-08 17:12:42', NULL),
(15, 4, 18, 100.00, '2024-05-08 17:13:02', NULL),
(16, 4, 19, 500.00, '2024-05-08 17:13:33', NULL),
(17, 4, 20, 500.00, '2024-05-08 17:13:46', NULL),
(18, 4, 21, 500.00, '2024-05-08 17:14:05', NULL),
(19, 4, 22, 500.00, '2024-05-08 17:14:27', NULL),
(20, 4, 23, 200.00, '2024-05-08 17:14:43', NULL),
(21, 3, 24, 0.00, '2024-05-08 17:16:32', NULL),
(22, 3, 25, 300.00, '2024-05-08 17:16:48', NULL),
(23, 2, 26, 0.00, '2024-05-08 17:18:20', NULL),
(24, 2, 27, 500.00, '2024-05-08 17:18:31', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_settings`
--

CREATE TABLE `tbl_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `setting_name` varchar(255) NOT NULL,
  `setting_value` longtext,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_settings`
--

INSERT INTO `tbl_settings` (`id`, `setting_name`, `setting_value`, `created_at`) VALUES
(4, 'company_logo', '1714476790_c2a97f4d4f4d74161d4b.png', '2024-04-10 15:20:03'),
(5, 'bank_name', 'Bank Name', '2024-04-10 16:52:46'),
(6, 'bank_acc_number', '1236547896', '2024-04-10 16:52:46'),
(7, 'smtp_host', 'mail.ehostingguru.com', '2024-04-10 16:54:08'),
(8, 'smtp_username', 'noreply@ehostingguru.com', '2024-04-10 16:54:08'),
(9, 'smtp_pass', 'b&vBH^ynlZ!x', '2024-04-10 16:55:15'),
(10, 'smtp_port', '465', '2024-04-10 16:55:15'),
(11, 'support_email', 'admin@gmail.com', '2024-04-26 15:19:52'),
(12, 'support_phone', '9088765430', '2024-04-26 15:19:52'),
(13, 'support_whatsapp_no', '9088776655', '2024-04-26 15:20:51'),
(14, 'company_name', 'School Shiksharthi', '2024-05-08 19:47:22'),
(15, 'company_address', 'Baghajatin Place ', '2024-05-08 19:47:22');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_states`
--

CREATE TABLE `tbl_states` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tbl_states`
--

INSERT INTO `tbl_states` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'West Bengal', '2024-04-25 17:24:56', NULL),
(4, 'Maharashtra', '2024-05-06 19:51:04', NULL),
(5, 'New Delhi', '2024-05-06 19:51:37', NULL),
(7, 'Karnataka', '2024-05-08 15:25:30', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_students`
--

CREATE TABLE `tbl_students` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `affilate_agent_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(300) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `aadhar_number` varchar(12) COLLATE utf8_unicode_ci DEFAULT NULL,
  `gender` enum('male','female','other') COLLATE utf8_unicode_ci DEFAULT NULL,
  `nationality` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `religion` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `district_id` bigint(20) UNSIGNED DEFAULT NULL,
  `police_station` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `pincode` varchar(6) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8_unicode_ci,
  `whatsapp_number` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tbl_students`
--

INSERT INTO `tbl_students` (`id`, `user_id`, `affilate_agent_id`, `name`, `email`, `date_of_birth`, `aadhar_number`, `gender`, `nationality`, `religion`, `district_id`, `police_station`, `pincode`, `address`, `whatsapp_number`, `created_at`, `updated_at`) VALUES
(33, 45, 1, 'student', 'student@gmail.com', '2024-05-08', '435656546774', 'female', 'indian', 'hindu', 2, 'dfgsdgh', '645645', 'fdgsdgd', '6545543454', '2024-05-08 19:04:21', NULL),
(34, 46, 1, 'Aranya Chakravarti', 'aranya.desuntech@gmail.com', '2000-10-11', '602427405695', 'male', 'Indian', 'Hindu', 2, 'Bidhannagar South PS ', '700106', 'FD Block, Salt Lake City,Kolkata', '9876543215', '2024-05-08 19:09:37', NULL),
(35, 47, 1, 'Anupam Roy', 'anupam@gmail.com', '2000-10-05', '602427405600', 'male', 'Indian', 'Hindu', 6, 'Bidhannagar South PS ', '700091', 'Kakurgachi, Kolkata.', '9876543216', '2024-05-08 19:11:17', NULL),
(36, 48, 1, 'Joy Bera', 'joy@gmail.com', '2001-08-11', '543534553536', 'male', 'Indian', 'Hindu', 7, 'Bidhannagar South PS ', '700091', 'Ultadanga', '9876543217', '2024-05-08 19:12:52', NULL),
(37, 49, 44, 'Rahul Saha', 'rahul@gmail.com', '2002-06-04', '234567890343', 'male', 'Indian', 'Hindu', 7, 'Central PS', '700034', '23A Rashbihari Avenue, Kolkata. ', '9876543218', '2024-05-08 19:18:32', NULL),
(38, 50, 44, 'Yashir Arafath', 'yashir@gmail.com', '2004-07-06', '602427405757', 'male', 'Indian', 'Muslim', 7, 'Sonarpur PS', '700056', 'Sonapur, Rajpur, West Bengal', '9876543219', '2024-05-08 19:30:01', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_student_education_details`
--

CREATE TABLE `tbl_student_education_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `student_id` bigint(20) UNSIGNED DEFAULT NULL,
  `last_qualification` varchar(300) COLLATE utf8_unicode_ci DEFAULT NULL,
  `hs_passout_year` year(4) DEFAULT NULL,
  `hs_roll_no` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `percentage` varchar(5) COLLATE utf8_unicode_ci DEFAULT NULL,
  `total_number` int(10) UNSIGNED DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_student_family_details`
--

CREATE TABLE `tbl_student_family_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `student_id` bigint(20) UNSIGNED DEFAULT NULL,
  `father_name` varchar(300) COLLATE utf8_unicode_ci DEFAULT NULL,
  `mother_name` varchar(300) COLLATE utf8_unicode_ci DEFAULT NULL,
  `father_mobile_number` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL,
  `parents_occupation` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `family_income` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `number_of_member` tinyint(4) DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_users`
--

CREATE TABLE `tbl_users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `role_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `mobile` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `wallet` decimal(10,2) DEFAULT NULL,
  `reset_otp` varchar(6) COLLATE utf8_unicode_ci DEFAULT NULL,
  `otp_valid_till` datetime DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  `is_active` tinyint(4) DEFAULT '1',
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tbl_users`
--

INSERT INTO `tbl_users` (`id`, `username`, `role_id`, `name`, `email`, `mobile`, `password`, `wallet`, `reset_otp`, `otp_valid_till`, `last_login`, `is_active`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, NULL, 1, 'Super Admin', 'admin@gmail.com', '9875614351', '21232f297a57a5a743894a0e4a801fc3', NULL, '', NULL, '2024-04-22 19:13:47', 1, NULL, NULL, '2024-04-23 00:44:17', '2024-05-08 20:02:43'),
(42, 'MDB-001', 2, 'Aranya Master Distributor', 'aranya.md@gmail.com', '9876543210', '8d4cb7afdd93af67281377cb3f9b935c', 594.50, NULL, NULL, NULL, 1, 1, NULL, '2024-05-08 17:43:12', '2024-05-08 19:58:36'),
(43, 'DB-001', 3, 'Aranya Distributor', 'aranya.d@gmail.com', '9876543220', '73b8264d99e52830dbf11df4395a0c24', 315.00, NULL, NULL, NULL, 1, 42, NULL, '2024-05-08 18:13:21', '2024-05-08 19:32:32'),
(44, 'AGT-001', 4, 'Aranya Agent', 'aranya.a@gmail.com', '9876543223', '7f8199312f2c0cf56ef85ad625be6aaa', 50.00, NULL, NULL, NULL, 1, 43, NULL, '2024-05-08 18:22:42', '2024-05-08 19:38:52'),
(45, 'STD-001', 5, 'student', 'student@gmail.com', '7567545654', 'e10adc3949ba59abbe56e057f20f883e', NULL, NULL, NULL, NULL, 1, 1, NULL, '2024-05-08 19:04:21', NULL),
(46, 'STD-002', 5, 'Aranya Chakravarti', 'aranya.desuntech@gmail.com', '9876543215', 'c228b6b9243bc2327cad9e8f02eacf3c', NULL, NULL, NULL, NULL, 1, 1, NULL, '2024-05-08 19:09:37', NULL),
(47, 'STD-003', 5, 'Anupam Roy', 'anupam@gmail.com', '9876543216', 'c228b6b9243bc2327cad9e8f02eacf3c', NULL, NULL, NULL, NULL, 1, 1, NULL, '2024-05-08 19:11:17', NULL),
(48, 'STD-004', 5, 'Joy Bera', 'joy@gmail.com', '9876543217', '43dfed7f2d8411438878e5e0bc6c505e', NULL, NULL, NULL, NULL, 1, 1, NULL, '2024-05-08 19:12:52', NULL),
(49, 'STD-005', 5, 'Rahul Saha', 'rahul@gmail.com', '9876543218', '366b1d1b4a50fb8adf79f3e49db12a21', NULL, NULL, NULL, NULL, 1, 44, NULL, '2024-05-08 19:18:32', NULL),
(50, 'STD-006', 5, 'Yashir Arafath', 'yashir@gmail.com', '9876543219', '269cf0fe1e7805f3a81849953f7feca2', NULL, NULL, NULL, NULL, 1, 44, NULL, '2024-05-08 19:30:01', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user_subscriptions`
--

CREATE TABLE `tbl_user_subscriptions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `invoice_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `plan_id` bigint(20) UNSIGNED NOT NULL,
  `plan_services` text COLLATE utf8_unicode_ci NOT NULL,
  `subscription_status` enum('expired','pending','active','cancelled') COLLATE utf8_unicode_ci DEFAULT NULL,
  `plan_interval` enum('month') COLLATE utf8_unicode_ci DEFAULT NULL,
  `plan_interval_count` tinyint(4) DEFAULT NULL,
  `plan_period_start` datetime DEFAULT NULL,
  `plan_period_end` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tbl_user_subscriptions`
--

INSERT INTO `tbl_user_subscriptions` (`id`, `invoice_id`, `user_id`, `plan_id`, `plan_services`, `subscription_status`, `plan_interval`, `plan_interval_count`, `plan_period_start`, `plan_period_end`, `created_at`, `updated_at`) VALUES
(2, 2, 42, 24, 'PAID MASTER DISTRIBUTOR ENTRY', 'active', 'month', 12, '2024-05-08 17:43:12', '2025-05-08 17:43:12', '2024-05-08 17:43:12', NULL),
(3, 3, 43, 21, 'Paid DISTRIBUTOR ENTRY', 'active', 'month', 12, '2024-05-08 18:13:21', '2025-05-08 18:13:21', '2024-05-08 18:13:21', NULL),
(4, 4, 44, 19, 'Paid Affiliate Agent', 'active', 'month', 12, '2024-05-08 18:22:42', '2025-05-08 18:22:42', '2024-05-08 18:22:42', NULL),
(5, 5, 45, 15, 'FREE STUDENT REGISTRATION ', 'active', 'month', 12, '2024-05-08 19:04:21', '2025-05-08 19:04:21', '2024-05-08 19:04:21', NULL),
(6, 6, 46, 15, 'FREE STUDENT REGISTRATION ', 'active', 'month', 12, '2024-05-08 19:09:37', '2025-05-08 19:09:37', '2024-05-08 19:09:37', NULL),
(7, 7, 47, 15, 'FREE STUDENT REGISTRATION ', 'active', 'month', 12, '2024-05-08 19:11:17', '2025-05-08 19:11:17', '2024-05-08 19:11:17', NULL),
(8, 8, 48, 15, 'FREE STUDENT REGISTRATION ', 'active', 'month', 12, '2024-05-08 19:12:52', '2025-05-08 19:12:52', '2024-05-08 19:12:52', NULL),
(9, 9, 49, 16, '299 PLUS MEMBER ', 'active', 'month', 12, '2024-05-08 19:18:32', '2025-05-08 19:18:32', '2024-05-08 19:18:32', NULL),
(10, 10, 50, 15, 'FREE STUDENT REGISTRATION ', 'active', 'month', 12, '2024-05-08 19:30:01', '2025-05-08 19:30:01', '2024-05-08 19:30:01', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_wallet_txn_history`
--

CREATE TABLE `tbl_wallet_txn_history` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `amount` decimal(10,2) NOT NULL,
  `txn_type` enum('cr','dr') COLLATE utf8_unicode_ci DEFAULT NULL,
  `txn_comment` text COLLATE utf8_unicode_ci,
  `ref_number` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `txn_date` date NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tbl_wallet_txn_history`
--

INSERT INTO `tbl_wallet_txn_history` (`id`, `user_id`, `amount`, `txn_type`, `txn_comment`, `ref_number`, `txn_date`, `created_at`) VALUES
(1, 42, 500.00, 'cr', 'commission for user plan', '8234307711', '2024-05-08', '2024-05-08 18:13:21'),
(2, 43, 300.00, 'cr', 'commission for user plan', '8186443519', '2024-05-08', '2024-05-08 18:22:42'),
(3, 42, 90.00, 'cr', 'commission for user plan', '2868930831', '2024-05-08', '2024-05-08 18:22:42'),
(4, 44, 40.00, 'cr', 'commission for student plan', '3467096342', '2024-05-08', '2024-05-08 19:18:32'),
(5, 43, 12.00, 'cr', 'commission for student plan', '7892266701', '2024-05-08', '2024-05-08 19:18:32'),
(6, 42, 3.60, 'cr', 'commission for student plan', '8967599804', '2024-05-08', '2024-05-08 19:18:32'),
(7, 44, 10.00, 'cr', 'commission for student plan', '5896867950', '2024-05-08', '2024-05-08 19:30:01'),
(8, 43, 3.00, 'cr', 'commission for student plan', '8997504097', '2024-05-08', '2024-05-08 19:30:01'),
(9, 42, 0.90, 'cr', 'commission for student plan', '0483518533', '2024-05-08', '2024-05-08 19:30:01');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_blocks`
--
ALTER TABLE `tbl_blocks`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uniq_name_district_id_tbl_blocks` (`district_id`,`name`);

--
-- Indexes for table `tbl_courses`
--
ALTER TABLE `tbl_courses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_course_services`
--
ALTER TABLE `tbl_course_services`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_org_course_id_tbl_course_services` (`org_course_id`),
  ADD KEY `fk_service_id_tbl_course_services` (`service_id`);

--
-- Indexes for table `tbl_districts`
--
ALTER TABLE `tbl_districts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uniq_name_tbl_districts` (`name`),
  ADD KEY `fk_state_id_tbl_districts` (`state_id`);

--
-- Indexes for table `tbl_enquires`
--
ALTER TABLE `tbl_enquires`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uniq_enquiry_number_tbl_enquires` (`enquiry_number`),
  ADD KEY `fk_service_id_tbl_enquires` (`service_id`);

--
-- Indexes for table `tbl_invoices`
--
ALTER TABLE `tbl_invoices`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_id_tbl_invoices` (`user_id`);

--
-- Indexes for table `tbl_invoice_items`
--
ALTER TABLE `tbl_invoice_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_invoice_id_tbl_invoice_items` (`invoice_id`);

--
-- Indexes for table `tbl_notifications`
--
ALTER TABLE `tbl_notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_id_tbl_notifications` (`user_id`);

--
-- Indexes for table `tbl_organizations`
--
ALTER TABLE `tbl_organizations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_state_id_tbl_organizations` (`state_id`),
  ADD KEY `fk_district_id_tbl_organizations` (`district_id`),
  ADD KEY `fk_block_id_tbl_organizations` (`block_id`);

--
-- Indexes for table `tbl_organizations_course`
--
ALTER TABLE `tbl_organizations_course`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_organization_id_tbl_organizations_course` (`organization_id`),
  ADD KEY `fk_course_id_tbl_organizations_course` (`course_id`);

--
-- Indexes for table `tbl_plans`
--
ALTER TABLE `tbl_plans`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uniq_role_id_plan_name` (`role_id`,`plan_name`);

--
-- Indexes for table `tbl_plan_commission`
--
ALTER TABLE `tbl_plan_commission`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_role_id_tbl_plan_commission` (`role_id`),
  ADD KEY `fk_plan_id_tbl_plan_commission` (`plan_id`);

--
-- Indexes for table `tbl_plan_services`
--
ALTER TABLE `tbl_plan_services`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_plan_id_tbl_plan_services` (`plan_id`),
  ADD KEY `fk_service_id_tbl_plan_services` (`service_id`);

--
-- Indexes for table `tbl_roles`
--
ALTER TABLE `tbl_roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uniq_role_name_tbl_roles` (`role_name`);

--
-- Indexes for table `tbl_services`
--
ALTER TABLE `tbl_services`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uniq_service_name_tbl_services` (`service_name`);

--
-- Indexes for table `tbl_service_comissions`
--
ALTER TABLE `tbl_service_comissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uniq_role_id_service_id` (`role_id`,`service_id`),
  ADD KEY `fk_service_id_tbl_service_comissions` (`service_id`);

--
-- Indexes for table `tbl_settings`
--
ALTER TABLE `tbl_settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uniq_setting_name` (`setting_name`);

--
-- Indexes for table `tbl_states`
--
ALTER TABLE `tbl_states`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uniq_name_tbl_states` (`name`);

--
-- Indexes for table `tbl_students`
--
ALTER TABLE `tbl_students`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_affilate_agent_id_tbl_students` (`affilate_agent_id`),
  ADD KEY `fk_district_id_tbl_students` (`district_id`),
  ADD KEY `fk_user_id_tbl_students` (`user_id`);

--
-- Indexes for table `tbl_student_education_details`
--
ALTER TABLE `tbl_student_education_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_student_id_tbl_student_education_details` (`student_id`);

--
-- Indexes for table `tbl_student_family_details`
--
ALTER TABLE `tbl_student_family_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_student_id_tbl_student_family_details` (`student_id`);

--
-- Indexes for table `tbl_users`
--
ALTER TABLE `tbl_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uniq_email_tbl_users` (`email`),
  ADD UNIQUE KEY `uniq_mobile_tbl_users` (`mobile`),
  ADD KEY `fk_role_id_tbl_users` (`role_id`);

--
-- Indexes for table `tbl_user_subscriptions`
--
ALTER TABLE `tbl_user_subscriptions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_id_tbl_user_subscriptions` (`user_id`),
  ADD KEY `fk_plan_id_tbl_user_subscriptions` (`plan_id`);

--
-- Indexes for table `tbl_wallet_txn_history`
--
ALTER TABLE `tbl_wallet_txn_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_id_tbl_wallet_txn_history` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_blocks`
--
ALTER TABLE `tbl_blocks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tbl_courses`
--
ALTER TABLE `tbl_courses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tbl_course_services`
--
ALTER TABLE `tbl_course_services`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `tbl_districts`
--
ALTER TABLE `tbl_districts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `tbl_enquires`
--
ALTER TABLE `tbl_enquires`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_invoices`
--
ALTER TABLE `tbl_invoices`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tbl_invoice_items`
--
ALTER TABLE `tbl_invoice_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tbl_notifications`
--
ALTER TABLE `tbl_notifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_organizations`
--
ALTER TABLE `tbl_organizations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tbl_organizations_course`
--
ALTER TABLE `tbl_organizations_course`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `tbl_plans`
--
ALTER TABLE `tbl_plans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `tbl_plan_commission`
--
ALTER TABLE `tbl_plan_commission`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `tbl_plan_services`
--
ALTER TABLE `tbl_plan_services`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `tbl_roles`
--
ALTER TABLE `tbl_roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tbl_services`
--
ALTER TABLE `tbl_services`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `tbl_service_comissions`
--
ALTER TABLE `tbl_service_comissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `tbl_settings`
--
ALTER TABLE `tbl_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `tbl_states`
--
ALTER TABLE `tbl_states`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tbl_students`
--
ALTER TABLE `tbl_students`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `tbl_student_education_details`
--
ALTER TABLE `tbl_student_education_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_student_family_details`
--
ALTER TABLE `tbl_student_family_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_users`
--
ALTER TABLE `tbl_users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `tbl_user_subscriptions`
--
ALTER TABLE `tbl_user_subscriptions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tbl_wallet_txn_history`
--
ALTER TABLE `tbl_wallet_txn_history`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_blocks`
--
ALTER TABLE `tbl_blocks`
  ADD CONSTRAINT `fk_district_id_tbl_blocks` FOREIGN KEY (`district_id`) REFERENCES `tbl_districts` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `tbl_course_services`
--
ALTER TABLE `tbl_course_services`
  ADD CONSTRAINT `fk_org_course_id_tbl_course_services` FOREIGN KEY (`org_course_id`) REFERENCES `tbl_organizations_course` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_service_id_tbl_course_services` FOREIGN KEY (`service_id`) REFERENCES `tbl_services` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `tbl_districts`
--
ALTER TABLE `tbl_districts`
  ADD CONSTRAINT `fk_state_id_tbl_districts` FOREIGN KEY (`state_id`) REFERENCES `tbl_states` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION;

--
-- Constraints for table `tbl_enquires`
--
ALTER TABLE `tbl_enquires`
  ADD CONSTRAINT `fk_service_id_tbl_enquires` FOREIGN KEY (`service_id`) REFERENCES `tbl_services` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION;

--
-- Constraints for table `tbl_invoices`
--
ALTER TABLE `tbl_invoices`
  ADD CONSTRAINT `fk_user_id_tbl_invoices` FOREIGN KEY (`user_id`) REFERENCES `tbl_users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `tbl_invoice_items`
--
ALTER TABLE `tbl_invoice_items`
  ADD CONSTRAINT `fk_invoice_id_tbl_invoice_items` FOREIGN KEY (`invoice_id`) REFERENCES `tbl_invoices` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `tbl_notifications`
--
ALTER TABLE `tbl_notifications`
  ADD CONSTRAINT `fk_user_id_tbl_notifications` FOREIGN KEY (`user_id`) REFERENCES `tbl_users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `tbl_organizations`
--
ALTER TABLE `tbl_organizations`
  ADD CONSTRAINT `fk_block_id_tbl_organizations` FOREIGN KEY (`block_id`) REFERENCES `tbl_blocks` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_district_id_tbl_organizations` FOREIGN KEY (`district_id`) REFERENCES `tbl_districts` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_state_id_tbl_organizations` FOREIGN KEY (`state_id`) REFERENCES `tbl_states` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION;

--
-- Constraints for table `tbl_organizations_course`
--
ALTER TABLE `tbl_organizations_course`
  ADD CONSTRAINT `fk_course_id_tbl_organizations_course` FOREIGN KEY (`course_id`) REFERENCES `tbl_courses` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_organization_id_tbl_organizations_course` FOREIGN KEY (`organization_id`) REFERENCES `tbl_organizations` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `tbl_plans`
--
ALTER TABLE `tbl_plans`
  ADD CONSTRAINT `fk_role_id_tbl_plans` FOREIGN KEY (`role_id`) REFERENCES `tbl_roles` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION;

--
-- Constraints for table `tbl_plan_commission`
--
ALTER TABLE `tbl_plan_commission`
  ADD CONSTRAINT `fk_plan_id_tbl_plan_commission` FOREIGN KEY (`plan_id`) REFERENCES `tbl_plans` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_role_id_tbl_plan_commission` FOREIGN KEY (`role_id`) REFERENCES `tbl_roles` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `tbl_plan_services`
--
ALTER TABLE `tbl_plan_services`
  ADD CONSTRAINT `fk_plan_id_tbl_plan_services` FOREIGN KEY (`plan_id`) REFERENCES `tbl_plans` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_service_id_tbl_plan_services` FOREIGN KEY (`service_id`) REFERENCES `tbl_services` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `tbl_service_comissions`
--
ALTER TABLE `tbl_service_comissions`
  ADD CONSTRAINT `fk_role_id_tbl_service_comissions` FOREIGN KEY (`role_id`) REFERENCES `tbl_roles` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_service_id_tbl_service_comissions` FOREIGN KEY (`service_id`) REFERENCES `tbl_services` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `tbl_students`
--
ALTER TABLE `tbl_students`
  ADD CONSTRAINT `fk_affilate_agent_id_tbl_students` FOREIGN KEY (`affilate_agent_id`) REFERENCES `tbl_users` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_district_id_tbl_students` FOREIGN KEY (`district_id`) REFERENCES `tbl_districts` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_user_id_tbl_students` FOREIGN KEY (`user_id`) REFERENCES `tbl_users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `tbl_student_education_details`
--
ALTER TABLE `tbl_student_education_details`
  ADD CONSTRAINT `fk_student_id_tbl_student_education_details` FOREIGN KEY (`student_id`) REFERENCES `tbl_students` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `tbl_student_family_details`
--
ALTER TABLE `tbl_student_family_details`
  ADD CONSTRAINT `fk_student_id_tbl_student_family_details` FOREIGN KEY (`student_id`) REFERENCES `tbl_students` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `tbl_users`
--
ALTER TABLE `tbl_users`
  ADD CONSTRAINT `fk_role_id_tbl_users` FOREIGN KEY (`role_id`) REFERENCES `tbl_roles` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `tbl_user_subscriptions`
--
ALTER TABLE `tbl_user_subscriptions`
  ADD CONSTRAINT `fk_plan_id_tbl_user_subscriptions` FOREIGN KEY (`plan_id`) REFERENCES `tbl_plans` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_user_id_tbl_user_subscriptions` FOREIGN KEY (`user_id`) REFERENCES `tbl_users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `tbl_wallet_txn_history`
--
ALTER TABLE `tbl_wallet_txn_history`
  ADD CONSTRAINT `fk_user_id_tbl_wallet_txn_history` FOREIGN KEY (`user_id`) REFERENCES `tbl_users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
