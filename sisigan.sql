-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 11, 2025 at 02:11 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sisigan`
--

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `name` varchar(25) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `date_added` datetime NOT NULL DEFAULT current_timestamp(),
  `description` varchar(100) NOT NULL,
  `is_deleted` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `image`, `name`, `price`, `date_added`, `description`, `is_deleted`) VALUES
(1, '1760182338_835a82dca537bf4d7c75.png', 'Pork Sisig', 159.00, '2025-10-11 19:32:18', 'Classic sizzling pork sisig with egg and chili', 0),
(2, '1760182361_9cf125c22ec0504ff053.png', 'Chicken Sisig', 149.00, '2025-10-11 19:32:41', 'Tender chicken sisig with mayo and calamansi', 0),
(3, '1760182381_fd2f74296160cde7813e.jpg', 'Bangus Sisig', 169.00, '2025-10-11 19:33:01', 'Milkfish flakes seasoned and served sizzling', 0),
(4, '1760182404_d537c204f418b094d105.jpg', 'Tofu Sisig', 139.00, '2025-10-11 19:33:24', 'Crispy tofu bits in a spicy sisig sauce', 0),
(5, '1760182443_8b5580fb4b635d429c68.jpg', 'Sizzling Platter', 299.00, '2025-10-11 19:34:03', 'Ultimate Sisig of all time.', 0),
(6, '1760184520_bed2470ddc8bb3c9ee25.png', 'Test Edited', 0.00, '2025-10-11 20:08:13', 'a\'s Plant Edited', 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `role` varchar(25) NOT NULL,
  `username` varchar(25) NOT NULL,
  `password` varchar(25) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `is_deleted` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `role`, `username`, `password`, `fullname`, `email`, `date_created`, `is_deleted`) VALUES
(1, 'Admin', 'RuRosarito', 'Password', 'Ronn Saimund U. Rosarito', 'rosaritoronnsaimund@gmail.com', '2025-10-11 19:41:50', 0),
(2, 'user', 'Q.Dingle', 'Password', 'Quandale Dingle', 'qdingle@gmail.com', '2025-10-11 19:45:25', 0),
(3, 'user', 'SDDM_Huss', '123456', 'Saddam Hussein', 'saddH@gmail.com', '2025-10-11 19:46:41', 0),
(4, 'user', 'D-reamyB', '1111111', 'Dreamy Bull', 'dreamy@yahoo.com', '2025-10-11 19:47:44', 0),
(5, 'user', 'Edited', 'Edited', 'Edited', 'Edited@test.com', '2025-10-11 20:03:11', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
