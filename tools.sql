-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: localhost
-- Thời gian đã tạo: Th5 17, 2025 lúc 10:43 AM
-- Phiên bản máy phục vụ: 10.4.28-MariaDB
-- Phiên bản PHP: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `tools`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `keys`
--

CREATE TABLE `keys` (
  `id` int(11) NOT NULL,
  `tool_id` int(11) NOT NULL,
  `key_value` varchar(255) NOT NULL,
  `status` varchar(50) DEFAULT 'active',
  `usage_count` int(11) DEFAULT 0,
  `last_used_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `expiry_date` date DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `keys`
--

INSERT INTO `keys` (`id`, `tool_id`, `key_value`, `status`, `usage_count`, `last_used_at`, `expiry_date`, `notes`, `created_at`, `updated_at`) VALUES
(4, 1, '123', 'active', 0, '2025-05-16 15:45:50', NULL, NULL, '2025-05-16 15:45:50', '2025-05-16 15:45:50');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tools`
--

CREATE TABLE `tools` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `tools`
--

INSERT INTO `tools` (`id`, `name`, `description`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'tool_map', 'Map nro', 1, '2025-05-16 14:46:08', '2025-05-16 14:46:08'),
(3, 'NS1', NULL, 1, '2025-05-16 16:23:21', '2025-05-16 16:23:21'),
(4, 'NS1', NULL, 1, '2025-05-16 16:23:25', '2025-05-16 16:23:25'),
(5, 'NS2', NULL, 1, '2025-05-16 16:23:28', '2025-05-16 16:23:28'),
(6, 'NS1', NULL, 1, '2025-05-16 16:23:29', '2025-05-16 16:23:29'),
(7, 'NS1', NULL, 1, '2025-05-16 16:23:31', '2025-05-16 16:23:31');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `full_name` varchar(255) DEFAULT NULL,
  `is_admin` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `full_name`, `is_admin`, `created_at`, `updated_at`) VALUES
(1, 'admin', '1', NULL, 'Nguyễn Đức Long', 1, '2025-05-16 14:53:25', '2025-05-16 14:54:11'),
(2, '1', '1', NULL, NULL, 1, '2025-05-16 14:59:31', '2025-05-16 15:11:39'),
(3, '', '', NULL, NULL, 1, '2025-05-16 14:59:31', '2025-05-16 14:59:31');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `keys`
--
ALTER TABLE `keys`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `key_value` (`key_value`),
  ADD KEY `tool_id` (`tool_id`);

--
-- Chỉ mục cho bảng `tools`
--
ALTER TABLE `tools`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `keys`
--
ALTER TABLE `keys`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT cho bảng `tools`
--
ALTER TABLE `tools`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `keys`
--
ALTER TABLE `keys`
  ADD CONSTRAINT `keys_ibfk_1` FOREIGN KEY (`tool_id`) REFERENCES `tools` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
