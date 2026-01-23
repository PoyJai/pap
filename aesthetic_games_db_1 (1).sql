-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 23, 2026 at 03:05 PM
-- Server version: 12.1.2-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `aesthetic_games_db_1`
--

-- --------------------------------------------------------

--
-- Table structure for table `games`
--

CREATE TABLE `games` (
  `id` int(11) UNSIGNED NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `genre` varchar(50) NOT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `long_description` text DEFAULT NULL,
  `price` decimal(10,2) DEFAULT 0.00,
  `release_date` date DEFAULT NULL,
  `developer` varchar(255) DEFAULT NULL,
  `rating` decimal(2,1) DEFAULT 0.0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `games`
--

INSERT INTO `games` (`id`, `title`, `description`, `genre`, `image_url`, `created_at`, `long_description`, `price`, `release_date`, `developer`, `rating`) VALUES
(168, 'ปืนซุ่มยิง (Sniper Rifle)', 'เป็นปืนไรเฟิลที่ออกแบบมาเพื่อความแม่นยำสูงในระยะไกล\r\nมักติดตั้งกล้องเล็ง ใช้ในงานทางทหาร การแข่งขันยิงปืน และการฝึกยิงระยะไกล', 'Strategy', 'https://blogger.googleusercontent.com/img/b/R29vZ2xl/AVvXsEgL4PPyb8g1IxJfZbKLpls3ioOVRg1oWIwUMviDE-6p4X55XBjio3XNTJCZWLEVilJNVgRJCIv4Th1adPN-zHMKUqpZ25nANBnQMztk_WwMM5rIRRbFLIWeR1KAFKkODxxbfJwZTbEwpnE/s1600/SVCh+7_62x54R-3.jpg', '2025-12-14 18:46:20', NULL, 700000.00, NULL, NULL, 0.0),
(169, 'ปืนจู่โจม (Assault Rifle)', 'เป็นปืนที่ใช้ในทางทหาร ยิงได้ทั้งกึ่งอัตโนมัติและอัตโนมัติ\r\nมีประสิทธิภาพสูงและใช้ในสถานการณ์การรบ', 'JRPG', 'https://upload.wikimedia.org/wikipedia/commons/thumb/2/28/Stag2wi_.jpg/500px-Stag2wi_.jpg', '2025-12-14 18:46:20', NULL, 400000.00, NULL, NULL, 0.0),
(170, 'ปืนกลมือ (Submachine Gun)', 'เป็นปืนอัตโนมัติหรือกึ่งอัตโนมัติ ใช้กระสุนขนาดเดียวกับปืนพก\r\nมักใช้ในหน่วยทหารและตำรวจ', 'Platformer', 'https://upload.wikimedia.org/wikipedia/commons/3/3a/Hkmp5count-terr-wiki.jpg\r\n', '2025-12-14 18:46:20', NULL, 300000.00, NULL, NULL, 0.0),
(171, 'ปืนไรเฟิล (Rifle)', 'ปืนยาวที่มีเกลียวในลำกล้อง ช่วยเพิ่มความแม่นยำ\r\nเหมาะสำหรับการยิงระยะไกลและการแข่งขันยิงปืน', 'Action RPG', 'https://upload.wikimedia.org/wikipedia/commons/b/b5/M-40A3.jpg', '2025-12-14 18:46:20', NULL, 120000.00, NULL, NULL, 0.0),
(172, 'ปืนลูกซอง (Shotgun)', 'ใช้กระสุนลูกปรายหรือกระสุนเดี่ยว เหมาะสำหรับการล่าสัตว์และการรักษาความปลอดภัย\r\nมีอำนาจหยุดยั้งสูงในระยะใกล้', 'Management Sim', 'https://www.shutterstock.com/image-photo/tactical-pumpaction-shotgun-shell-holder-260nw-2651904063.jpg', '2025-12-14 18:46:20', NULL, 80000.00, NULL, NULL, 0.0),
(173, 'ปืนลูกโม่ (Revolver)', 'มีโม่บรรจุกระสุน ยิงได้ทีละนัด โครงสร้างแข็งแรง ดูแลรักษาง่าย\r\nมีความแม่นยำและทนทานสูง', 'FPS/Exploration', 'https://rookiehobby.com//upload/pd/pictures/pic-1-20241403-1710404519-621.png', '2025-12-14 18:46:20', NULL, 100000.00, NULL, NULL, 0.0),
(174, 'ปืนพก (Handgun / Pistol)', 'เป็นอาวุธปืนขนาดเล็ก ใช้งานด้วยมือเดียวหรือสองมือ เหมาะสำหรับการพกพา มีทั้งแบบกึ่งอัตโนมัติและลูกโม่\r\nนิยมใช้ในงานรักษาความปลอดภัย และการป้องกันตัว', 'Puzzle/Exploration', 'https://media.istockphoto.com/id/535481859/th/%E0%B8%A3%E0%B8%B9%E0%B8%9B%E0%B8%96%E0%B9%88%E0%B8%B2%E0%B8%A2/%E0%B8%9B%E0%B8%B7%E0%B8%99%E0%B8%9E%E0%B8%81.jpg?s=612x612&w=0&k=20&c=A-efMYu-DS3ra44Va9bT10EYQgmslAnzpD7UL3hWS9E=', '2025-12-14 18:46:20', NULL, 120000.00, NULL, NULL, 0.0);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `customer_name` varchar(100) NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `order_details` text NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `customer_name`, `total_amount`, `order_details`, `created_at`) VALUES
(1, 'sddasd', 1700.00, 'Minecraft, Minecraft', '2026-01-23 12:51:24'),
(2, 'assasdsa', 0.00, 'Silent Cartographer II III IV', '2026-01-23 12:51:39'),
(3, 'sasdas', 850.00, 'Minecraft', '2026-01-23 12:51:49');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `games`
--
ALTER TABLE `games`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `games`
--
ALTER TABLE `games`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=238;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
