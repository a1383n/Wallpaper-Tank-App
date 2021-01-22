-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 22, 2021 at 07:03 PM
-- Server version: 10.4.13-MariaDB
-- PHP Version: 7.4.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `laravel`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `color` varchar(7) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '#333333',
  `items_count` bigint(20) NOT NULL DEFAULT 0,
  `user_id` bigint(20) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `title`, `color`, `items_count`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 'Dark', NULL, '#333333', 9, 1, '2021-01-22 15:31:14', '2021-01-22 16:14:18');

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
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
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
(19, '2014_10_12_000000_create_users_table', 1),
(20, '2014_10_12_100000_create_password_resets_table', 1),
(21, '2019_08_19_000000_create_failed_jobs_table', 1),
(22, '2021_01_08_124359_create_categories_table', 1),
(23, '2021_01_08_124646_create_wallpapers_table', 1),
(24, '2021_01_14_131810_create_wallpaper_views_table', 1),
(25, '2021_01_14_161854_create_wallpaper_likes_table', 1),
(26, '2021_01_15_192621_create_wallpapers_downloads_table', 1),
(27, '2021_01_15_213353_create_tokens_table', 1);

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
-- Table structure for table `tokens`
--

CREATE TABLE `tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `value` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  `push_token` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Demo', 'demo@email.com', NULL, '$2y$10$dVaYcTI5RZIEZTWCkaJicuhSJHDElWy/nmATP/JWNdTWfqUdXcQ5K', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `wallpapers`
--

CREATE TABLE `wallpapers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category_id` int(11) NOT NULL,
  `tags` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `likes` int(11) NOT NULL DEFAULT 0,
  `views` int(11) NOT NULL DEFAULT 0,
  `downloads` int(11) NOT NULL DEFAULT 0,
  `user_id` int(11) NOT NULL,
  `path` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  `temp_url` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `wallpaper_url` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `wallpapers`
--

INSERT INTO `wallpapers` (`id`, `title`, `category_id`, `tags`, `likes`, `views`, `downloads`, `user_id`, `path`, `temp_url`, `wallpaper_url`, `created_at`, `updated_at`) VALUES
(1, 'Moon light', 1, 'sds', 0, 0, 0, 1, 'e13d2a442d88b45f13d9acf72afd3293', 'http://localhost/storage/wallpapers/e13d2a442d88b45f13d9acf72afd3293/temp.jpg', 'http://localhost/storage/wallpapers/e13d2a442d88b45f13d9acf72afd3293/wallpaper.jpg', '2021-01-22 15:32:13', '2021-01-22 15:32:13'),
(2, 'Red Flower', 1, 'a', 0, 0, 0, 1, '3716ae98fed73aec4d2af38f496c9c90', 'http://localhost/storage/wallpapers/3716ae98fed73aec4d2af38f496c9c90/temp.jpg', 'http://localhost/storage/wallpapers/3716ae98fed73aec4d2af38f496c9c90/wallpaper.jpg', '2021-01-22 16:07:15', '2021-01-22 16:07:15'),
(3, 'Rainy road', 1, 'log', 0, 0, 0, 1, '36a48dc4154bf4cdbf819eb63f07dfd9', 'http://localhost/storage/wallpapers/36a48dc4154bf4cdbf819eb63f07dfd9/temp.jpg', 'http://localhost/storage/wallpapers/36a48dc4154bf4cdbf819eb63f07dfd9/wallpaper.jpg', '2021-01-22 16:08:02', '2021-01-22 16:08:02'),
(4, 'Snowy Mountain', 1, 'log', 0, 0, 0, 1, 'a470d21d81e94851dba985c217adf439', 'http://localhost/storage/wallpapers/a470d21d81e94851dba985c217adf439/temp.jpg', 'http://localhost/storage/wallpapers/a470d21d81e94851dba985c217adf439/wallpaper.jpg', '2021-01-22 16:08:16', '2021-01-22 16:08:16'),
(5, 'Yellow Flower', 1, 'yelow', 0, 0, 0, 1, 'fcdd7ade8d0a222c86c1e5b3c529a481', 'http://localhost/storage/wallpapers/fcdd7ade8d0a222c86c1e5b3c529a481/temp.jpg', 'http://localhost/storage/wallpapers/fcdd7ade8d0a222c86c1e5b3c529a481/wallpaper.jpg', '2021-01-22 16:08:44', '2021-01-22 16:08:44'),
(6, 'Moon', 1, 'log', 0, 0, 0, 1, 'ae2651fe4a1ecdcbdaa3a7aebdd87756', 'http://localhost/storage/wallpapers/ae2651fe4a1ecdcbdaa3a7aebdd87756/temp.jpg', 'http://localhost/storage/wallpapers/ae2651fe4a1ecdcbdaa3a7aebdd87756/wallpaper.jpg', '2021-01-22 16:10:23', '2021-01-22 16:10:23'),
(7, 'White flower', 1, 'log', 0, 0, 0, 1, '6bd460ea1c0a1371b8c782ba2e13da17', 'http://localhost/storage/wallpapers/6bd460ea1c0a1371b8c782ba2e13da17/temp.jpg', 'http://localhost/storage/wallpapers/6bd460ea1c0a1371b8c782ba2e13da17/wallpaper.jpg', '2021-01-22 16:10:34', '2021-01-22 16:10:34'),
(8, 'Starry Night', 1, 'as', 0, 0, 0, 1, 'c039e4001f0c109a92f5391af3047916', 'http://localhost/storage/wallpapers/c039e4001f0c109a92f5391af3047916/temp.jpg', 'http://localhost/storage/wallpapers/c039e4001f0c109a92f5391af3047916/wallpaper.jpg', '2021-01-22 16:11:16', '2021-01-22 16:11:16'),
(9, 'Moon light', 1, 'log', 0, 1, 0, 1, 'e234c1ac7581ddf3ba4a3567d796d9a0', 'http://localhost/storage/wallpapers/e234c1ac7581ddf3ba4a3567d796d9a0/temp.png', 'http://localhost/storage/wallpapers/e234c1ac7581ddf3ba4a3567d796d9a0/wallpaper.png', '2021-01-22 16:14:18', '2021-01-22 17:02:52');

-- --------------------------------------------------------

--
-- Table structure for table `wallpapers_downloads`
--

CREATE TABLE `wallpapers_downloads` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `session_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `wallpaper_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `wallpaper_likes`
--

CREATE TABLE `wallpaper_likes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `session_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `wallpaper_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `wallpaper_views`
--

CREATE TABLE `wallpaper_views` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `wallpaper_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `session_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ip` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `agent` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `wallpaper_views`
--

INSERT INTO `wallpaper_views` (`id`, `wallpaper_id`, `url`, `user_id`, `session_id`, `ip`, `agent`, `created_at`, `updated_at`) VALUES
(1, '9', 'http://127.0.0.1:8000/wallpapers/9', 1, '5BtZX9uQgJUqJWhO3IGz6MoDnWnwI8WVJSvsi5FG', '127.0.0.1', 'Mozilla/5.0 (iPhone; CPU iPhone OS 13_2_3 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.0.3 Mobile/15E148 Safari/604.1', '2021-01-22 17:02:52', '2021-01-22 17:02:52');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `tokens`
--
ALTER TABLE `tokens`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `wallpapers`
--
ALTER TABLE `wallpapers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wallpapers_downloads`
--
ALTER TABLE `wallpapers_downloads`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wallpaper_likes`
--
ALTER TABLE `wallpaper_likes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wallpaper_views`
--
ALTER TABLE `wallpaper_views`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `tokens`
--
ALTER TABLE `tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `wallpapers`
--
ALTER TABLE `wallpapers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `wallpapers_downloads`
--
ALTER TABLE `wallpapers_downloads`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `wallpaper_likes`
--
ALTER TABLE `wallpaper_likes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `wallpaper_views`
--
ALTER TABLE `wallpaper_views`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
