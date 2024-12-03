-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 03, 2024 at 10:46 PM
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
-- Database: `bizmatchhub`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `category_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_by` int(11) NOT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `name`, `created_by`, `image`) VALUES
(1, 'Build your website', 1, 'https://www.tekshapers.com/uploads/blog_image/15362384091533896513blog-sco2.jpg'),
(3, 'Boost your business efficiency', 1, 'https://geekologist.co/wp-content/uploads/2015/07/What-is-a-Business-Analyst-smartgenie.co_-300x230.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `chats`
--

CREATE TABLE `chats` (
  `chat_id` int(11) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `receiver_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `sent_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `been_read` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `chats`
--

INSERT INTO `chats` (`chat_id`, `sender_id`, `receiver_id`, `message`, `sent_at`, `been_read`) VALUES
(1, 1, 2, 'Hi, how\'re you? Inquiring about your service.', '2024-12-03 10:55:00', 0),
(2, 2, 1, 'Yes please, go on', '2024-12-03 11:19:02', 0),
(3, 2, 1, 'Yes please, go on', '2024-12-03 11:19:17', 0),
(4, 2, 1, 'Apologies, the app glitched', '2024-12-03 11:20:40', 0),
(5, 2, 1, 'that\'s alright', '2024-12-03 12:40:13', 0),
(6, 1, 2, 'wassup', '2024-12-03 20:22:02', 0),
(7, 1, 2, 'finalisement', '2024-12-03 20:41:05', 0);

-- --------------------------------------------------------

--
-- Table structure for table `freelancercategories`
--

CREATE TABLE `freelancercategories` (
  `freelancer_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `experience_level` enum('beginner','intermediate','expert') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `freelancercategories`
--

INSERT INTO `freelancercategories` (`freelancer_id`, `category_id`, `experience_level`) VALUES
(2, 1, 'expert'),
(2, 3, 'intermediate');

-- --------------------------------------------------------

--
-- Table structure for table `freelancerdetails`
--

CREATE TABLE `freelancerdetails` (
  `freelancer_id` int(11) NOT NULL,
  `work_experience` int(11) NOT NULL CHECK (`work_experience` >= 0),
  `job_title` varchar(255) DEFAULT NULL,
  `introduction` text DEFAULT NULL,
  `total_rating` decimal(3,2) DEFAULT 0.00 CHECK (`total_rating` between 0 and 5),
  `num_ratings` int(11) DEFAULT 0 CHECK (`num_ratings` >= 0),
  `hourly_rate` decimal(10,2) DEFAULT 0.00,
  `work_hours` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `freelancerdetails`
--

INSERT INTO `freelancerdetails` (`freelancer_id`, `work_experience`, `job_title`, `introduction`, `total_rating`, `num_ratings`, `hourly_rate`, `work_hours`) VALUES
(2, 4, 'Software Engineer', 'I am a passionate software engineer with a deep love for coding. My expertise lies in PHP, and I take pride in crafting clean, efficient, and scalable code. I am always eager to learn and stay ahead of industry trends, ensuring that my work is not only cutting-edge but also reliable. Whether it\'s developing robust web applications or optimizing existing systems, I am dedicated to delivering high-quality solutions. My enthusiasm for technology and commitment to excellence make me a valuable asset to any team.', 0.00, 0, 19.00, '9 AM - 5 PM');

-- --------------------------------------------------------

--
-- Table structure for table `owner`
--

CREATE TABLE `owner` (
  `owner_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `payment_id` int(11) NOT NULL,
  `invoice_number` varchar(50) NOT NULL,
  `contractor_id` int(11) NOT NULL,
  `freelancer_id` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL CHECK (`amount` >= 0),
  `paid_at` timestamp NULL DEFAULT current_timestamp(),
  `status` enum('pending','completed','failed') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`payment_id`, `invoice_number`, `contractor_id`, `freelancer_id`, `amount`, `paid_at`, `status`) VALUES
(1, 'INV1191831733234018', 1, 2, 450666.00, '2024-12-03 13:53:38', ''),
(2, 'INV9269011733235094', 3, 2, 500.00, '2024-12-03 14:11:34', 'pending');

-- --------------------------------------------------------

--
-- Table structure for table `portfolios`
--

CREATE TABLE `portfolios` (
  `portfolio_id` int(11) NOT NULL,
  `freelancer_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `portfolios`
--

INSERT INTO `portfolios` (`portfolio_id`, `freelancer_id`, `title`, `description`, `url`) VALUES
(1, 2, 'Requirements Engineering Practicum Certificate', 'I\'m super duper fly like that', 'https://drive.google.com/file/d/1HIdBfG7C1sKAD9VHQEue5x7Rn3Ax7ydW/view?usp=drive_link'),
(2, 2, 'Requirements Engineering Practicum Certificate', 'tttt', 'https://drive.google.com/file/d/1HIdBfG7C1sKAD9VHQEue5x7Rn3Ax7ydW/view?usp=drive_link');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `review_id` int(11) NOT NULL,
  `contractor_id` int(11) NOT NULL,
  `freelancer_id` int(11) NOT NULL,
  `rating` int(11) NOT NULL CHECK (`rating` between 1 and 5),
  `review` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone_number` varchar(15) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `user_type` enum('freelancer','contractor') NOT NULL,
  `name` varchar(255) NOT NULL,
  `profile_picture` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `email`, `phone_number`, `password`, `user_type`, `name`, `profile_picture`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'elikem.gale-zoyiku@ashesi.edu.gh', '0507586382', '$2y$10$owVHulaAwsloKNqKZIK9rO2OvbNL.yvfoa6B/0pPj4G6hqgbvbX36', 'contractor', 'Elikem Asudo Tsatsu Gale-Zoyiku', NULL, 1, '2024-11-30 13:11:27', '2024-11-30 13:11:27'),
(2, 'gideon.boakye@ashesi.edu.gh', '0507586382', '$2y$10$nOuM1AlkBcTAs9lGdZvCSOdUu/H.wppIAWqgpMkzvTofgZ/.skSpO', 'freelancer', 'Gideon Boakye', NULL, 1, '2024-11-30 13:28:24', '2024-11-30 13:28:24'),
(3, 'vn@gmail.com', '0507586382', 'EATprof@2002', 'contractor', 'My name', NULL, 0, '2024-12-01 09:14:47', '2024-12-01 09:18:04');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`),
  ADD UNIQUE KEY `name` (`name`),
  ADD KEY `created_by` (`created_by`);

--
-- Indexes for table `chats`
--
ALTER TABLE `chats`
  ADD PRIMARY KEY (`chat_id`),
  ADD KEY `receiver_id` (`receiver_id`),
  ADD KEY `idx_chats` (`sender_id`,`receiver_id`);

--
-- Indexes for table `freelancercategories`
--
ALTER TABLE `freelancercategories`
  ADD PRIMARY KEY (`freelancer_id`,`category_id`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `idx_freelancer_categories` (`freelancer_id`,`category_id`);

--
-- Indexes for table `freelancerdetails`
--
ALTER TABLE `freelancerdetails`
  ADD PRIMARY KEY (`freelancer_id`);

--
-- Indexes for table `owner`
--
ALTER TABLE `owner`
  ADD PRIMARY KEY (`owner_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`payment_id`),
  ADD UNIQUE KEY `invoice_number` (`invoice_number`),
  ADD KEY `contractor_id` (`contractor_id`),
  ADD KEY `freelancer_id` (`freelancer_id`);

--
-- Indexes for table `portfolios`
--
ALTER TABLE `portfolios`
  ADD PRIMARY KEY (`portfolio_id`),
  ADD KEY `freelancer_id` (`freelancer_id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`review_id`),
  ADD KEY `freelancer_id` (`freelancer_id`),
  ADD KEY `idx_reviews` (`contractor_id`,`freelancer_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `chats`
--
ALTER TABLE `chats`
  MODIFY `chat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `portfolios`
--
ALTER TABLE `portfolios`
  MODIFY `portfolio_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `review_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `categories`
--
ALTER TABLE `categories`
  ADD CONSTRAINT `categories_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `users` (`user_id`) ON UPDATE CASCADE;

--
-- Constraints for table `chats`
--
ALTER TABLE `chats`
  ADD CONSTRAINT `chats_ibfk_1` FOREIGN KEY (`sender_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `chats_ibfk_2` FOREIGN KEY (`receiver_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `freelancercategories`
--
ALTER TABLE `freelancercategories`
  ADD CONSTRAINT `freelancercategories_ibfk_1` FOREIGN KEY (`freelancer_id`) REFERENCES `freelancerdetails` (`freelancer_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `freelancercategories_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `freelancerdetails`
--
ALTER TABLE `freelancerdetails`
  ADD CONSTRAINT `freelancerdetails_ibfk_1` FOREIGN KEY (`freelancer_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `owner`
--
ALTER TABLE `owner`
  ADD CONSTRAINT `owner_ibfk_1` FOREIGN KEY (`owner_id`) REFERENCES `users` (`user_id`) ON UPDATE CASCADE;

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`contractor_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `payments_ibfk_2` FOREIGN KEY (`freelancer_id`) REFERENCES `freelancerdetails` (`freelancer_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `portfolios`
--
ALTER TABLE `portfolios`
  ADD CONSTRAINT `portfolios_ibfk_1` FOREIGN KEY (`freelancer_id`) REFERENCES `freelancerdetails` (`freelancer_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`contractor_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`freelancer_id`) REFERENCES `freelancerdetails` (`freelancer_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
