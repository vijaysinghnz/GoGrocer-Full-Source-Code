-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jul 27, 2020 at 01:20 PM
-- Server version: 10.2.31-MariaDB-cll-lve
-- PHP Version: 7.2.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `u602795421_testgrocer`
--

-- --------------------------------------------------------

--
-- Table structure for table `aboutuspage`
--

CREATE TABLE `aboutuspage` (
  `about_id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `aboutuspage`
--

INSERT INTO `aboutuspage` (`about_id`, `title`, `description`) VALUES
(1, 'About Us', '<p><strong>About Us</strong><br />\r\n&nbsp;MaaS - Mobile App as a Service. We provide mobile app solutions to Supermarkets, fashion stores and other related establishments.</p>');

-- --------------------------------------------------------

--
-- Table structure for table `address`
--

CREATE TABLE `address` (
  `address_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `receiver_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `receiver_phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `society` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `house_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `landmark` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `state` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pincode` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lat` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lng` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `select_status` int(11) NOT NULL,
  `added_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `admin_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `admin_email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `admin_pass` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `admin_image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `admin_name`, `admin_email`, `admin_pass`, `admin_image`) VALUES
(1, 'GoGrocer Admin', 'support@tecmanic.com', '$2y$10$.H44.WZ.yRCg60piB1bLP.Z9ezo42sAM3hP8P09vbTY5jmc79I5yC', 'images/admin/profile/07-04-20/070420120712pm-604a0cadf94914c7ee6c6e552e9b4487-curved-check-mark-circle-icon-by-vexels.png');

-- --------------------------------------------------------

--
-- Table structure for table `admin_payouts`
--

CREATE TABLE `admin_payouts` (
  `payout_id` int(11) NOT NULL,
  `payout_date` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `respond_payout_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bill` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `store_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payout_amt` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `banner`
--

CREATE TABLE `banner` (
  `banner_id` int(100) NOT NULL,
  `banner_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `banner_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `banner`
--

INSERT INTO `banner` (`banner_id`, `banner_name`, `banner_image`) VALUES
(6, 'banner2', 'images/banner/060520114457am-download-(6).jpg'),
(7, 'banner3', 'images/banner/060520100355am-download-(4).jpg'),
(8, 'banner4', 'images/banner/060520100432am-download-(3).jpg'),
(23, '01', 'images/banner/290620113736am-060520100432am-download-(3).jpg');

-- --------------------------------------------------------

--
-- Table structure for table `cancel_for`
--

CREATE TABLE `cancel_for` (
  `res_id` int(11) NOT NULL,
  `reason` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cancel_for`
--

INSERT INTO `cancel_for` (`res_id`, `reason`) VALUES
(1, 'i bought from somewhere else'),
(2, 'changed my mind.');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `cart_id` int(255) NOT NULL,
  `qty` int(255) NOT NULL,
  `user_id` int(200) NOT NULL,
  `store_id` int(200) NOT NULL,
  `store_name` varchar(200) CHARACTER SET utf8 NOT NULL,
  `product_id` int(200) NOT NULL,
  `variant_id` int(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cart_rewards`
--

CREATE TABLE `cart_rewards` (
  `cart_rewards_id` int(11) NOT NULL,
  `cart_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rewards` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `cat_id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `parent` int(11) NOT NULL DEFAULT 0,
  `level` int(11) NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `city`
--

CREATE TABLE `city` (
  `city_id` int(100) NOT NULL,
  `city_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `closing_hours`
--

CREATE TABLE `closing_hours` (
  `closing_hrs_id` int(100) NOT NULL,
  `date` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `start_hrs` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `end_hrs` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `coupon`
--

CREATE TABLE `coupon` (
  `coupon_id` int(100) NOT NULL,
  `coupon_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `coupon_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `coupon_description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `cart_value` int(100) NOT NULL,
  `amount` int(100) NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `uses_restriction` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `currency`
--

CREATE TABLE `currency` (
  `id` int(11) NOT NULL,
  `currency_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `currency_sign` char(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `currency`
--

INSERT INTO `currency` (`id`, `currency_name`, `currency_sign`) VALUES
(1, 'INR', 'Rs.');

-- --------------------------------------------------------

--
-- Table structure for table `deal_product`
--

CREATE TABLE `deal_product` (
  `deal_id` int(11) NOT NULL,
  `varient_id` int(11) NOT NULL,
  `deal_price` float NOT NULL,
  `valid_from` datetime NOT NULL,
  `valid_to` datetime NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `delivery_boy`
--

CREATE TABLE `delivery_boy` (
  `dboy_id` int(11) NOT NULL,
  `boy_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `boy_phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `boy_city` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `device_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `boy_loc` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lat` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lng` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `delivery_rating`
--

CREATE TABLE `delivery_rating` (
  `rating_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `dboy_id` int(11) NOT NULL,
  `rating` float NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fcm`
--

CREATE TABLE `fcm` (
  `id` int(11) NOT NULL,
  `sender_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `server_key` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `store_server_key` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `driver_server_key` longtext COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `fcm`
--

INSERT INTO `fcm` (`id`, `sender_id`, `server_key`, `store_server_key`, `driver_server_key`) VALUES
(1, '352076647507', 'AAAflnTFM:APA91bENvJ_m7EYr0iyqcolGcB3DdSV_K5tKBDOJherPDN0TlQsYNeUzS92HSz0Ou1c_d0ty2Mvp_XAcxYMhqdh0XQG57cMC_8P2N_lFZmZQT55EZ2sfAx_d84ztVMYHGWaUfYwD-vQN', 'AAAAlnTFM:APA91bENvJ_m7EYr0iyGcB3DdSV_K5tKBDOJherPDN0TlQsYNeUzS92HSz0Ou1c_d0ty2Mvp_XAcxYMhqdh0XQG57cMC_8P2N_lFZmZQT55EZ2sfAx_d84ztVMYHGWaUfYwD-vQN', 'bjhkszhgjkxhgjkzbgjhgvxfcghzfCGJfzJHCFjhxfgjhxfjhf');

-- --------------------------------------------------------

--
-- Table structure for table `freedeliverycart`
--

CREATE TABLE `freedeliverycart` (
  `id` int(11) NOT NULL,
  `min_cart_value` float NOT NULL DEFAULT 0,
  `del_charge` float NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `freedeliverycart`
--

INSERT INTO `freedeliverycart` (`id`, `min_cart_value`, `del_charge`) VALUES
(1, 1000, 20);

-- --------------------------------------------------------

--
-- Table structure for table `map_API`
--

CREATE TABLE `map_API` (
  `id` int(11) NOT NULL,
  `map_api_key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `map_API`
--

INSERT INTO `map_API` (`id`, `map_api_key`) VALUES
(1, 'AIzaSyDq6a7_3mqLmO1mcnxJMkehXRdvvgsjw1E');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `minimum_maximum_order_value`
--

CREATE TABLE `minimum_maximum_order_value` (
  `min_max_id` int(100) NOT NULL,
  `min_value` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `max_value` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `minimum_maximum_order_value`
--

INSERT INTO `minimum_maximum_order_value` (`min_max_id`, `min_value`, `max_value`) VALUES
(1, '300', '10000');

-- --------------------------------------------------------

--
-- Table structure for table `msg91`
--

CREATE TABLE `msg91` (
  `id` int(11) NOT NULL,
  `sender_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `api_key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `msg91`
--

INSERT INTO `msg91` (`id`, `sender_id`, `api_key`, `active`) VALUES
(1, 'GOGRCK', '197064AVzt8vx5456d55f3', 1);

-- --------------------------------------------------------

--
-- Table structure for table `notificationby`
--

CREATE TABLE `notificationby` (
  `noti_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `sms` int(11) NOT NULL,
  `app` int(11) NOT NULL,
  `email` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `store_id` int(11) NOT NULL,
  `address_id` int(11) NOT NULL,
  `cart_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_price` float NOT NULL,
  `price_without_delivery` float NOT NULL,
  `total_products_mrp` float NOT NULL,
  `payment_method` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `paid_by_wallet` float NOT NULL DEFAULT 0,
  `rem_price` float NOT NULL DEFAULT 0,
  `order_date` date NOT NULL,
  `delivery_date` date NOT NULL,
  `delivery_charge` float NOT NULL DEFAULT 0,
  `time_slot` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dboy_id` int(11) NOT NULL DEFAULT 0,
  `order_status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Pending',
  `user_signature` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cancelling_reason` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `coupon_id` int(11) NOT NULL DEFAULT 0,
  `coupon_discount` float NOT NULL DEFAULT 0,
  `payment_status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cancel_by_store` int(11) NOT NULL DEFAULT 0,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payment_via`
--

CREATE TABLE `payment_via` (
  `p_id` int(11) NOT NULL,
  `paypal` int(11) NOT NULL,
  `razorpay` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payment_via`
--

INSERT INTO `payment_via` (`p_id`, `paypal`, `razorpay`) VALUES
(1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `payout_requests`
--

CREATE TABLE `payout_requests` (
  `req_id` int(11) NOT NULL,
  `store_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payout_amt` float NOT NULL,
  `req_date` date NOT NULL,
  `complete` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payout_req_valid`
--

CREATE TABLE `payout_req_valid` (
  `val_id` int(11) NOT NULL,
  `min_amt` int(11) NOT NULL,
  `min_days` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payout_req_valid`
--

INSERT INTO `payout_req_valid` (`val_id`, `min_amt`, `min_days`) VALUES
(1, 10, 10);

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `product_id` int(11) NOT NULL,
  `cat_id` int(11) NOT NULL,
  `product_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_varient`
--

CREATE TABLE `product_varient` (
  `varient_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `unit` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mrp` float DEFAULT NULL,
  `price` float NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `varient_image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reedem_values`
--

CREATE TABLE `reedem_values` (
  `reedem_id` int(100) NOT NULL,
  `reward_point` int(100) NOT NULL,
  `value` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `reedem_values`
--

INSERT INTO `reedem_values` (`reedem_id`, `reward_point`, `value`) VALUES
(1, 1, '0.50');

-- --------------------------------------------------------

--
-- Table structure for table `reward_points`
--

CREATE TABLE `reward_points` (
  `reward_id` int(100) NOT NULL,
  `min_cart_value` int(100) NOT NULL,
  `reward_point` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `reward_points`
--

INSERT INTO `reward_points` (`reward_id`, `min_cart_value`, `reward_point`) VALUES
(1, 10, 10),
(2, 20, 20),
(3, 1000, 200),
(4, 30, 30),
(5, 2000, 450);

-- --------------------------------------------------------

--
-- Table structure for table `secondary_banner`
--

CREATE TABLE `secondary_banner` (
  `sec_banner_id` int(100) NOT NULL,
  `banner_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `banner_image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `secondary_banner`
--

INSERT INTO `secondary_banner` (`sec_banner_id`, `banner_name`, `banner_image`) VALUES
(3, 'sample', 'images/banner/260520024315am-coffee-shop-products-mockup-scene-generator_146162-4.jpg'),
(4, 'banner 2', 'images/banner/030620064558pm-banner_136.png'),
(5, 'banner 3', 'images/banner/030620064637pm-Grocery-Banner-New-1200x400.jpg'),
(6, 'banner4', 'images/banner/030620064704pm-Home_banner-two_1350x600.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `smsby`
--

CREATE TABLE `smsby` (
  `by_id` int(11) NOT NULL,
  `msg91` int(11) NOT NULL DEFAULT 1,
  `twilio` int(11) NOT NULL DEFAULT 0,
  `status` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `smsby`
--

INSERT INTO `smsby` (`by_id`, `msg91`, `twilio`, `status`) VALUES
(1, 1, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `society`
--

CREATE TABLE `society` (
  `society_id` int(100) NOT NULL,
  `society_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `city_id` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `store`
--

CREATE TABLE `store` (
  `store_id` int(100) NOT NULL,
  `store_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `employee_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `admin_share` float NOT NULL DEFAULT 0,
  `device_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `del_range` float NOT NULL,
  `lat` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lng` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `store_bank`
--

CREATE TABLE `store_bank` (
  `ac_id` int(11) NOT NULL,
  `store_id` int(11) NOT NULL,
  `ac_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ifsc` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `holder_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bank_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `upi` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `store_earning`
--

CREATE TABLE `store_earning` (
  `id` int(11) NOT NULL,
  `store_id` int(11) NOT NULL,
  `paid` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `store_notification`
--

CREATE TABLE `store_notification` (
  `not_id` int(11) NOT NULL,
  `not_title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `not_message` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `store_id` int(11) NOT NULL,
  `read_by_store` int(11) NOT NULL DEFAULT 0,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `store_orders`
--

CREATE TABLE `store_orders` (
  `store_order_id` int(11) NOT NULL,
  `product_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `varient_image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantity` float NOT NULL,
  `unit` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `varient_id` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `price` float NOT NULL,
  `total_mrp` float NOT NULL,
  `order_cart_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `order_date` datetime NOT NULL,
  `store_approval` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `store_products`
--

CREATE TABLE `store_products` (
  `p_id` int(11) NOT NULL,
  `varient_id` int(11) NOT NULL,
  `stock` int(11) NOT NULL,
  `store_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `store_society`
--

CREATE TABLE `store_society` (
  `store_society_id` int(100) NOT NULL,
  `society_id` int(100) NOT NULL,
  `store_id` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_web_setting`
--

CREATE TABLE `tbl_web_setting` (
  `set_id` int(11) NOT NULL,
  `icon` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `favicon` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_web_setting`
--

INSERT INTO `tbl_web_setting` (`set_id`, `icon`, `name`, `favicon`) VALUES
(1, 'images/app_logo/favicon/11-05-2020/gogrocer-icon.png', 'GoGrocer', 'images/app_logo/favicon/11-05-2020/gogrocer-icon.png');

-- --------------------------------------------------------

--
-- Table structure for table `termspage`
--

CREATE TABLE `termspage` (
  `terms_id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `termspage`
--

INSERT INTO `termspage` (`terms_id`, `title`, `description`) VALUES
(1, 'Terms & Condition', '<table cellspacing=\"0\" id=\"datatables\" style=\"width:100%\">\r\n	<tbody>\r\n		<tr>\r\n			<td>&nbsp;</td>\r\n			<td>\r\n			<p><strong>Terms and Conditions</strong></p>\r\n\r\n			<p>Last Updated: 05&nbsp;May 2020</p>\r\n\r\n			<p>Bisht Technologies Private Limited, a company incorporated under the Companies Act, 1956 having its registered office at #3, 2nd floor, Kapil Complex Mukhani, Haldwani-263139 and operating office at A-130, Sector 63, Noida, who is the owner of the mobile application GoGrocer (the &quot;Application Provider&quot;) reserves all rights not expressly granted to you under these Terms and Conditions. GoGrocer mobile application, the product that is subject to these Terms and Conditions is hereafter referred to as the &quot;Licensed Application&quot;</p>\r\n\r\n			<p><strong>Scope of License</strong></p>\r\n\r\n			<p>This license granted to you for the Licensed Application by the Application Provider, is limited to a non-exclusive, non-transferable, license to use the Licensed Application on any Android&trade; and iOS device that you own or control. This license does not allow you to use the Licensed Application on any Android&trade; device that you do not own or control, and you may not distribute or make the Licensed Application available over a network where it could be used by multiple devices at the same time. Nothing contained in the Licensed Application should be considered as granting you, by implication or otherwise, any license or right to use any trade-marks, logos, or other names contained in the Licensed Application. You may not rent, lease, lend, sell, redistribute or sublicense the Licensed Application. You may not copy, decompile, reverse engineer, disassemble, attempt to derive the source code of, modify, or create derivative works of the Licensed Application, any updates, or any part thereof (except as and only to the extent any foregoing restriction is prohibited by applicable law or to the extent as may be permitted by the licensing terms governing use of any open sourced components included within the Licensed Application). Any attempt to do so is a violation of the rights of the Application Provider and its licensors. If you breach this restriction, you may be subject to prosecution and damages. The terms of the license will govern any upgrades provided by the Application Provider that replace and/or supplement the original Licensed Application, unless such upgrade is accompanied by a separate license in which case the terms of that license will govern its use.</p>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>');

-- --------------------------------------------------------

--
-- Table structure for table `time_slot`
--

CREATE TABLE `time_slot` (
  `time_slot_id` int(100) NOT NULL,
  `open_hour` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `close_hour` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `time_slot` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `time_slot`
--

INSERT INTO `time_slot` (`time_slot_id`, `open_hour`, `close_hour`, `time_slot`) VALUES
(1, '07:00', '22:00', 60);

-- --------------------------------------------------------

--
-- Table structure for table `twilio`
--

CREATE TABLE `twilio` (
  `twilio_id` int(11) NOT NULL,
  `twilio_sid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `twilio_token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `twilio_phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `twilio`
--

INSERT INTO `twilio` (`twilio_id`, `twilio_sid`, `twilio_token`, `twilio_phone`, `active`) VALUES
(1, 'AC301fdc7bb65f1d359ba9217e2hjhjk', 'd6f8aa81a27981136a38c3562f885ad1', '+19169995023', 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `user_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `device_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'N/A',
  `user_password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `otp_value` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `wallet` float NOT NULL DEFAULT 0,
  `rewards` int(11) NOT NULL DEFAULT 0,
  `is_verified` int(11) NOT NULL DEFAULT 0,
  `block` int(11) NOT NULL DEFAULT 2,
  `reg_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_notification`
--

CREATE TABLE `user_notification` (
  `noti_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `noti_title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `noti_message` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `read_by_user` int(11) NOT NULL DEFAULT 0,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `wallet_recharge_history`
--

CREATE TABLE `wallet_recharge_history` (
  `wallet_recharge_history` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `recharge_status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` float NOT NULL,
  `date_of_recharge` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `aboutuspage`
--
ALTER TABLE `aboutuspage`
  ADD PRIMARY KEY (`about_id`);

--
-- Indexes for table `address`
--
ALTER TABLE `address`
  ADD PRIMARY KEY (`address_id`);

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin_payouts`
--
ALTER TABLE `admin_payouts`
  ADD PRIMARY KEY (`payout_id`);

--
-- Indexes for table `banner`
--
ALTER TABLE `banner`
  ADD PRIMARY KEY (`banner_id`);

--
-- Indexes for table `cancel_for`
--
ALTER TABLE `cancel_for`
  ADD PRIMARY KEY (`res_id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`cart_id`);

--
-- Indexes for table `cart_rewards`
--
ALTER TABLE `cart_rewards`
  ADD PRIMARY KEY (`cart_rewards_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`cat_id`);

--
-- Indexes for table `city`
--
ALTER TABLE `city`
  ADD PRIMARY KEY (`city_id`);

--
-- Indexes for table `closing_hours`
--
ALTER TABLE `closing_hours`
  ADD PRIMARY KEY (`closing_hrs_id`);

--
-- Indexes for table `coupon`
--
ALTER TABLE `coupon`
  ADD PRIMARY KEY (`coupon_id`);

--
-- Indexes for table `currency`
--
ALTER TABLE `currency`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `deal_product`
--
ALTER TABLE `deal_product`
  ADD PRIMARY KEY (`deal_id`);

--
-- Indexes for table `delivery_boy`
--
ALTER TABLE `delivery_boy`
  ADD PRIMARY KEY (`dboy_id`);

--
-- Indexes for table `delivery_rating`
--
ALTER TABLE `delivery_rating`
  ADD PRIMARY KEY (`rating_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fcm`
--
ALTER TABLE `fcm`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `freedeliverycart`
--
ALTER TABLE `freedeliverycart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `map_API`
--
ALTER TABLE `map_API`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `minimum_maximum_order_value`
--
ALTER TABLE `minimum_maximum_order_value`
  ADD PRIMARY KEY (`min_max_id`);

--
-- Indexes for table `msg91`
--
ALTER TABLE `msg91`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notificationby`
--
ALTER TABLE `notificationby`
  ADD PRIMARY KEY (`noti_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `payment_via`
--
ALTER TABLE `payment_via`
  ADD PRIMARY KEY (`p_id`);

--
-- Indexes for table `payout_requests`
--
ALTER TABLE `payout_requests`
  ADD PRIMARY KEY (`req_id`);

--
-- Indexes for table `payout_req_valid`
--
ALTER TABLE `payout_req_valid`
  ADD PRIMARY KEY (`val_id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `product_varient`
--
ALTER TABLE `product_varient`
  ADD PRIMARY KEY (`varient_id`);

--
-- Indexes for table `reedem_values`
--
ALTER TABLE `reedem_values`
  ADD PRIMARY KEY (`reedem_id`);

--
-- Indexes for table `reward_points`
--
ALTER TABLE `reward_points`
  ADD PRIMARY KEY (`reward_id`);

--
-- Indexes for table `secondary_banner`
--
ALTER TABLE `secondary_banner`
  ADD PRIMARY KEY (`sec_banner_id`);

--
-- Indexes for table `smsby`
--
ALTER TABLE `smsby`
  ADD PRIMARY KEY (`by_id`);

--
-- Indexes for table `society`
--
ALTER TABLE `society`
  ADD PRIMARY KEY (`society_id`);

--
-- Indexes for table `store`
--
ALTER TABLE `store`
  ADD PRIMARY KEY (`store_id`);

--
-- Indexes for table `store_bank`
--
ALTER TABLE `store_bank`
  ADD PRIMARY KEY (`ac_id`);

--
-- Indexes for table `store_earning`
--
ALTER TABLE `store_earning`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `store_notification`
--
ALTER TABLE `store_notification`
  ADD PRIMARY KEY (`not_id`);

--
-- Indexes for table `store_orders`
--
ALTER TABLE `store_orders`
  ADD PRIMARY KEY (`store_order_id`);

--
-- Indexes for table `store_products`
--
ALTER TABLE `store_products`
  ADD PRIMARY KEY (`p_id`);

--
-- Indexes for table `store_society`
--
ALTER TABLE `store_society`
  ADD PRIMARY KEY (`store_society_id`);

--
-- Indexes for table `tbl_web_setting`
--
ALTER TABLE `tbl_web_setting`
  ADD PRIMARY KEY (`set_id`);

--
-- Indexes for table `termspage`
--
ALTER TABLE `termspage`
  ADD PRIMARY KEY (`terms_id`);

--
-- Indexes for table `time_slot`
--
ALTER TABLE `time_slot`
  ADD PRIMARY KEY (`time_slot_id`);

--
-- Indexes for table `twilio`
--
ALTER TABLE `twilio`
  ADD PRIMARY KEY (`twilio_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `user_notification`
--
ALTER TABLE `user_notification`
  ADD PRIMARY KEY (`noti_id`);

--
-- Indexes for table `wallet_recharge_history`
--
ALTER TABLE `wallet_recharge_history`
  ADD PRIMARY KEY (`wallet_recharge_history`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `aboutuspage`
--
ALTER TABLE `aboutuspage`
  MODIFY `about_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `address`
--
ALTER TABLE `address`
  MODIFY `address_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=344;

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `admin_payouts`
--
ALTER TABLE `admin_payouts`
  MODIFY `payout_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `banner`
--
ALTER TABLE `banner`
  MODIFY `banner_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `cancel_for`
--
ALTER TABLE `cancel_for`
  MODIFY `res_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `cart_id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cart_rewards`
--
ALTER TABLE `cart_rewards`
  MODIFY `cart_rewards_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=463;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `cat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `city`
--
ALTER TABLE `city`
  MODIFY `city_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `closing_hours`
--
ALTER TABLE `closing_hours`
  MODIFY `closing_hrs_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `coupon`
--
ALTER TABLE `coupon`
  MODIFY `coupon_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `currency`
--
ALTER TABLE `currency`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `deal_product`
--
ALTER TABLE `deal_product`
  MODIFY `deal_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `delivery_boy`
--
ALTER TABLE `delivery_boy`
  MODIFY `dboy_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `delivery_rating`
--
ALTER TABLE `delivery_rating`
  MODIFY `rating_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `fcm`
--
ALTER TABLE `fcm`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `freedeliverycart`
--
ALTER TABLE `freedeliverycart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `map_API`
--
ALTER TABLE `map_API`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `minimum_maximum_order_value`
--
ALTER TABLE `minimum_maximum_order_value`
  MODIFY `min_max_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `msg91`
--
ALTER TABLE `msg91`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `notificationby`
--
ALTER TABLE `notificationby`
  MODIFY `noti_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2015;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1022;

--
-- AUTO_INCREMENT for table `payment_via`
--
ALTER TABLE `payment_via`
  MODIFY `p_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `payout_requests`
--
ALTER TABLE `payout_requests`
  MODIFY `req_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `payout_req_valid`
--
ALTER TABLE `payout_req_valid`
  MODIFY `val_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `product_varient`
--
ALTER TABLE `product_varient`
  MODIFY `varient_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=88;

--
-- AUTO_INCREMENT for table `reedem_values`
--
ALTER TABLE `reedem_values`
  MODIFY `reedem_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `reward_points`
--
ALTER TABLE `reward_points`
  MODIFY `reward_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `secondary_banner`
--
ALTER TABLE `secondary_banner`
  MODIFY `sec_banner_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `smsby`
--
ALTER TABLE `smsby`
  MODIFY `by_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `society`
--
ALTER TABLE `society`
  MODIFY `society_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `store`
--
ALTER TABLE `store`
  MODIFY `store_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `store_bank`
--
ALTER TABLE `store_bank`
  MODIFY `ac_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `store_earning`
--
ALTER TABLE `store_earning`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `store_notification`
--
ALTER TABLE `store_notification`
  MODIFY `not_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=552;

--
-- AUTO_INCREMENT for table `store_orders`
--
ALTER TABLE `store_orders`
  MODIFY `store_order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2755;

--
-- AUTO_INCREMENT for table `store_products`
--
ALTER TABLE `store_products`
  MODIFY `p_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=342;

--
-- AUTO_INCREMENT for table `store_society`
--
ALTER TABLE `store_society`
  MODIFY `store_society_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tbl_web_setting`
--
ALTER TABLE `tbl_web_setting`
  MODIFY `set_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `termspage`
--
ALTER TABLE `termspage`
  MODIFY `terms_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `time_slot`
--
ALTER TABLE `time_slot`
  MODIFY `time_slot_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `twilio`
--
ALTER TABLE `twilio`
  MODIFY `twilio_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2016;

--
-- AUTO_INCREMENT for table `user_notification`
--
ALTER TABLE `user_notification`
  MODIFY `noti_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1933;

--
-- AUTO_INCREMENT for table `wallet_recharge_history`
--
ALTER TABLE `wallet_recharge_history`
  MODIFY `wallet_recharge_history` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=284;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
