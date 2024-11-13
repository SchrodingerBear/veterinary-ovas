-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 13, 2024 at 12:56 PM
-- Server version: 10.4.33-MariaDB-log
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ovas_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `appointment_list`
--

CREATE TABLE `appointment_list` (
  `id` int(30) NOT NULL,
  `code` varchar(100) NOT NULL,
  `schedule` date NOT NULL,
  `owner_name` text NOT NULL,
  `contact` text NOT NULL,
  `email` text NOT NULL,
  `address` text NOT NULL,
  `category_id` int(30) NOT NULL,
  `breed` text NOT NULL,
  `age` varchar(50) NOT NULL,
  `service_ids` text DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `appointment_list`
--

INSERT INTO `appointment_list` (`id`, `code`, `schedule`, `owner_name`, `contact`, `email`, `address`, `category_id`, `breed`, `age`, `service_ids`, `status`, `date_created`, `date_updated`) VALUES
(1, 'OVAS-2022010001', '2022-01-04', 'John D Smith', '0912345789', 'jsmith@sample.com', 'Here City', 1, 'German Shepherd', '5 mos. old', '3,1', 0, '2022-01-04 15:55:21', NULL),
(2, 'OVAS-2022010002', '2022-01-05', 'Claire Blake', '09123456897', 'cblake@sample.com', 'There City', 1, 'Pug', '6 mos. old', '3,1', 0, '2022-01-04 15:56:55', NULL),
(3, 'OVAS-2022010003', '2022-01-05', 'Mark Cooper', '094567894152', 'mcooper@gmail.com', 'Here', 2, 'Persian Cat', '1 yr. old', '5,3', 0, '2022-01-04 15:58:23', NULL),
(4, 'OVAS-2022010004', '2022-01-05', 'Samantha Miller', '0995564887', 'smiller@sample.com', 'Sample Address', 2, 'Maine Coon', '7 mos.', '5,1', 0, '2022-01-04 15:59:51', NULL),
(6, 'OVAS-2022010006', '2022-01-06', 'Jane Park', '09888754466', 'jpark@gmail.com', 'Sample address', 2, 'Ragdoll', '8 mos', '5,1', 1, '2022-01-04 16:27:54', '2022-01-04 17:17:55');

-- --------------------------------------------------------

--
-- Table structure for table `category_list`
--

CREATE TABLE `category_list` (
  `id` int(30) NOT NULL,
  `name` text NOT NULL,
  `delete_flag` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0 = Active, 1 = Delete',
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `category_list`
--

INSERT INTO `category_list` (`id`, `name`, `delete_flag`, `date_created`, `date_updated`) VALUES
(1, 'Dogs', 0, '2022-01-04 10:31:11', NULL),
(2, 'Cats', 0, '2022-01-04 10:31:38', NULL),
(3, 'Hamsters', 0, '2022-01-04 10:32:02', NULL),
(4, 'Rabbits', 0, '2022-01-04 10:32:13', NULL),
(5, 'Birds', 0, '2022-01-04 10:32:47', NULL),
(6, 'test', 1, '2022-01-04 10:33:02', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `medicalrecords`
--

CREATE TABLE `medicalrecords` (
  `record_id` int(11) NOT NULL,
  `pet_name` varchar(100) NOT NULL,
  `client_name` varchar(100) NOT NULL,
  `medical_condition` text NOT NULL,
  `proposed_solution` text DEFAULT NULL,
  `date_of_record` timestamp NOT NULL DEFAULT current_timestamp(),
  `delete_flag` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `medicalrecords`
--

INSERT INTO `medicalrecords` (`record_id`, `pet_name`, `client_name`, `medical_condition`, `proposed_solution`, `date_of_record`, `delete_flag`) VALUES
(1, 'Buddy', 'John Doe', 'Skin irritation and hair loss', 'Prescribed antibiotics and topical cream. Follow-up in 2 weeks.', '2024-11-13 12:44:37', 0),
(2, 'Milo', 'Jane Smith', 'Stomach upset and vomiting', 'Recommended a bland diet for 3 days, monitor hydration, and follow up if symptoms persist.', '2024-11-13 12:44:37', 0),
(3, 'Bella', 'Mark Johnson', 'Limping on right hind leg', 'X-ray suggested possible ligament strain. Recommended rest and anti-inflammatory medication for 10 days.', '2024-11-13 12:44:37', 0),
(4, 'Luna', 'Sara Lee', 'Ear infection', 'Ear drops prescribed, clean ears twice a day, and follow up in a week for re-evaluation.', '2024-11-13 12:44:37', 0),
(5, 'Charlie', 'Robert Brown', 'Allergic reaction to flea bites', 'Administered anti-histamine and recommended flea prevention. Follow-up in a month.', '2024-11-13 12:44:37', 0),
(6, 'Buddy', 'John Doe', 'Skin irritation and hair loss', 'Prescribed antibiotics and topical cream. Follow-up in 2 weeks.', '2024-11-13 12:51:10', 0),
(7, 'Buddy', 'John Doess', 'Skin irritation and hair loss', 'Prescribed antibiotics and topical cream. Follow-up in 2 weeks.', '2024-11-13 12:51:17', 1),
(8, 'Buddy', 'John Doesss', 'Skin irritation and hair loss', 'Prescribed antibiotics and topical cream. Follow-up in 2 weeks.', '2024-11-13 12:52:21', 1);

-- --------------------------------------------------------

--
-- Table structure for table `message_list`
--

CREATE TABLE `message_list` (
  `id` int(30) NOT NULL,
  `fullname` text NOT NULL,
  `contact` text NOT NULL,
  `email` text NOT NULL,
  `message` text NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `message_list`
--

INSERT INTO `message_list` (`id`, `fullname`, `contact`, `email`, `message`, `status`, `date_created`) VALUES
(1, 'test', '09123456897', 'jsmith@sample.com', 'test', 1, '2022-01-04 17:26:19');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `stocks` int(11) NOT NULL,
  `description` text DEFAULT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp(),
  `delete_flag` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `price`, `stocks`, `description`, `date_created`, `delete_flag`) VALUES
(1, 'Antibiotic Tablets', 25.50, 120, 'Antibiotic tablets for treating bacterial infections in pets.', '2024-08-12 12:02:27', 1),
(2, 'Flea and Tick Collar', 15.75, 80, 'Collar to protect pets from fleas and ticks.', '2024-08-12 12:02:27', 0),
(3, 'Vitamin Supplement', 30.00, 60, 'Vitamin supplement to support overall pet health.', '2024-08-12 12:02:27', 0),
(4, 'Dental Chews', 18.40, 1550, 'Dental chews to help maintain oral hygiene in petss.2', '2024-08-12 12:02:27', 0),
(5, 'Ear Cleaner Solution', 12.90, 100, 'Solution for cleaning and treating pet ear infections.', '2024-08-12 12:02:27', 0),
(6, 'Wound Care Kit', 35.00, 45, 'Kit for treating and dressing minor wounds and injuries.', '2024-08-12 12:02:27', 0),
(7, 'Anti-Anxiety Drops', 27.20, 70, 'Drops to help manage anxiety and stress in pets.', '2024-08-12 12:02:27', 1),
(8, 'Probiotic Powder', 22.50, 90, 'Probiotic powder to aid in digestion and gut health.', '2024-08-12 12:02:27', 0),
(9, 'Grooming Brush', 14.60, 110, 'Brush for grooming and de-shedding pets.s', '2024-08-12 12:02:27', 0),
(10, 'Joint Support Supplement', 40.00, 50, 'Supplement to support joint health and mobility in pets.', '2024-08-12 12:02:27', 0),
(11, 'testt', 123.00, 123, '12312321', '2024-08-12 12:07:06', 1),
(12, 'asda', 0.00, 0, 'das', '2024-08-12 12:54:37', 1);

-- --------------------------------------------------------

--
-- Table structure for table `service_list`
--

CREATE TABLE `service_list` (
  `id` int(30) NOT NULL,
  `category_ids` text NOT NULL,
  `name` text NOT NULL,
  `description` text NOT NULL,
  `fee` float NOT NULL DEFAULT 0,
  `delete_flag` tinyint(4) NOT NULL DEFAULT 0,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `service_list`
--

INSERT INTO `service_list` (`id`, `category_ids`, `name`, `description`, `fee`, `delete_flag`, `date_created`, `date_updated`) VALUES
(1, '2,1', 'Immunization', '<p style=\"margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px;\">This service provides essential immunizations for cats and dogs to protect them against various infectious diseases. Immunizations help boost the pets\' immune systems and safeguard them from potentially serious illnesses.</p>', 1500, 0, '2022-01-04 10:59:49', '2024-08-12 19:46:58'),
(2, '2,1', 'Vaccination', '<p><font color=\"#000000\">This service involves administering vaccinations to cats and dogs to protect them from common and potentially severe diseases. Vaccinations are a vital part of routine pet care and help in preventing the spread of infections among animals.</font></p>', 1700, 0, '2022-01-04 11:14:24', '2024-08-12 19:47:07'),
(3, '5,2,1,3,4', 'Check-up', '<p><font color=\"#000000\">A general health check-up service is offered for a wide range of pets including birds, cats, dogs, hamsters, and rabbits. This check-up is aimed at assessing the overall health and well-being of pets, detecting any potential issues early, and ensuring they receive appropriate care.</font></p>', 500, 0, '2022-01-04 11:15:09', '2024-08-12 19:46:47'),
(4, '1', 'Anti-Rabies', '<p><font color=\"#000000\">This service provides a crucial vaccination to protect dogs from rabies, a severe and potentially deadly viral infection that affects the nervous system. The anti-rabies vaccine helps prevent the transmission of the virus and ensures the safety and health of dogs.</font></p>', 500, 0, '2022-01-04 11:16:24', '2024-08-12 19:46:31'),
(5, '2', 'Anti-Rabies', '<p>This vaccination is designed to protect cats from rabies, a fatal disease that can be transmitted through bites and scratches. The anti-rabies vaccine is essential for preventing this serious illness and maintaining public health safety.</p>', 250, 0, '2022-01-04 11:16:38', '2024-08-12 19:46:38'),
(6, '4', 'deleted', '<p>test</p>', 123, 1, '2022-01-04 11:17:34', '2022-01-04 11:17:46');

-- --------------------------------------------------------

--
-- Table structure for table `system_info`
--

CREATE TABLE `system_info` (
  `id` int(30) NOT NULL,
  `meta_field` text NOT NULL,
  `meta_value` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `system_info`
--

INSERT INTO `system_info` (`id`, `meta_field`, `meta_value`) VALUES
(1, 'name', 'Online Veterinary Management System'),
(6, 'short_name', 'OVMS'),
(11, 'logo', 'uploads/logo-1723463660.png'),
(13, 'user_avatar', 'uploads/user_avatar.jpg'),
(14, 'cover', 'uploads/cover-1723462925.png'),
(15, 'content', 'Array'),
(16, 'email', 'info@vetclinic.com'),
(17, 'contact', '09854698789 / 78945632'),
(18, 'from_time', '11:00'),
(19, 'to_time', '21:30'),
(20, 'address', 'XYZ Street, There City, Here, 2306'),
(23, 'max_appointment', '30'),
(24, 'clinic_schedule', '9:00 AM - 5:00 PM');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(50) NOT NULL,
  `firstname` varchar(250) NOT NULL,
  `middlename` text DEFAULT NULL,
  `lastname` varchar(250) NOT NULL,
  `username` text NOT NULL,
  `password` text NOT NULL,
  `avatar` text DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  `type` tinyint(1) NOT NULL DEFAULT 0,
  `status` int(1) NOT NULL DEFAULT 1 COMMENT '0=not verified, 1 = verified',
  `date_added` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `firstname`, `middlename`, `lastname`, `username`, `password`, `avatar`, `last_login`, `type`, `status`, `date_added`, `date_updated`) VALUES
(1, 'Adminstrator', NULL, 'Admin', 'admin', '21232f297a57a5a743894a0e4a801fc3', 'uploads/avatar-1.png?v=1723463319', NULL, 1, 1, '2021-01-20 14:02:37', '2024-08-12 19:48:39'),
(3, 'Claire', NULL, 'Blake', 'cblake', '4744ddea876b11dcb1d169fadf494418', 'uploads/avatar-3.png?v=1639467985', NULL, 2, 1, '2021-12-14 15:46:25', '2021-12-14 15:46:25');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appointment_list`
--
ALTER TABLE `appointment_list`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `category_list`
--
ALTER TABLE `category_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `medicalrecords`
--
ALTER TABLE `medicalrecords`
  ADD PRIMARY KEY (`record_id`);

--
-- Indexes for table `message_list`
--
ALTER TABLE `message_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `service_list`
--
ALTER TABLE `service_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `system_info`
--
ALTER TABLE `system_info`
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
-- AUTO_INCREMENT for table `appointment_list`
--
ALTER TABLE `appointment_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `category_list`
--
ALTER TABLE `category_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `medicalrecords`
--
ALTER TABLE `medicalrecords`
  MODIFY `record_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `message_list`
--
ALTER TABLE `message_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `service_list`
--
ALTER TABLE `service_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `system_info`
--
ALTER TABLE `system_info`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `appointment_list`
--
ALTER TABLE `appointment_list`
  ADD CONSTRAINT `appointment_list_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `category_list` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
