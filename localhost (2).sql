-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jul 24, 2024 at 02:20 PM
-- Server version: 10.5.20-MariaDB
-- PHP Version: 7.3.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `id21937078_attendance`
--
CREATE DATABASE IF NOT EXISTS `id21937078_attendance` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
USE `id21937078_attendance`;

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `module` varchar(50) NOT NULL,
  `attendance_time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `module_teaching` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`id`, `student_id`, `module`, `attendance_time`, `module_teaching`) VALUES
(1, 1, 'ICG', '2024-04-22 21:12:29', NULL),
(2, 2, 'MCI', '2024-04-23 06:37:00', NULL),
(3, 1, 'DBF', '2024-04-23 06:37:00', NULL),
(4, 3, 'DST', '2024-04-23 06:38:28', NULL),
(5, 4, 'BMC', '2024-04-23 06:38:28', NULL),
(6, 1, 'MCI', '2024-04-27 09:01:36', NULL),
(7, 1, 'MCI', '2024-04-27 09:01:48', NULL),
(8, 1, 'DBF', '2024-04-27 11:23:51', NULL),
(9, 1, 'DBF', '2024-04-27 11:24:00', NULL),
(10, 1, 'DST', '2024-04-27 17:31:38', NULL),
(11, 1, 'DST', '2024-04-27 19:41:58', NULL),
(12, 1, 'DST', '2024-04-27 19:41:59', NULL),
(13, 1, 'DST', '2024-04-27 19:42:25', NULL),
(14, 1, 'DST', '2024-04-27 19:42:26', NULL),
(15, 1, 'DST', '2024-04-27 19:43:32', NULL),
(16, 1, 'DST', '2024-04-27 21:16:53', NULL),
(17, 1, 'ICG', '2024-05-10 12:42:07', NULL),
(18, 1, 'ICG', '2024-05-10 12:42:09', NULL),
(19, 1, 'ICG', '2024-05-10 12:42:47', NULL),
(20, 1, 'ICG', '2024-05-10 12:44:04', NULL),
(21, 1, 'ICG', '2024-05-10 12:44:06', NULL),
(22, 1, 'ICG', '2024-05-10 12:44:09', NULL),
(23, 1, 'ICG', '2024-05-10 12:44:31', NULL),
(24, 1, 'ICG', '2024-05-10 12:48:07', NULL),
(25, 1, 'DST Practical', '2024-05-14 06:45:37', NULL),
(26, 1, 'DST Practical', '2024-05-14 06:57:09', NULL),
(27, 1, 'DBF Practical', '2024-05-16 10:36:44', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `modules`
--

CREATE TABLE `modules` (
  `module_id` int(11) NOT NULL,
  `module_name` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `modules`
--

INSERT INTO `modules` (`module_id`, `module_name`) VALUES
(1, 'MCI'),
(2, 'DBF');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` int(11) NOT NULL,
  `student_number` varchar(20) NOT NULL,
  `pin` varchar(10) NOT NULL,
  `username` varchar(50) NOT NULL,
  `is_student` tinyint(1) NOT NULL,
  `is_teacher` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `student_number`, `pin`, `username`, `is_student`, `is_teacher`) VALUES
(1, '240001', '1234', 'Adolf', 1, 0),
(2, '1234', '', 'Jimmy', 1, 0),
(3, '1234', '', 'Sally', 1, 0),
(4, '12345', '', 'John', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `teachers`
--

CREATE TABLE `teachers` (
  `id` int(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `is_student` tinyint(1) DEFAULT 0,
  `is_teacher` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `teachers`
--

INSERT INTO `teachers` (`id`, `email`, `password`, `is_student`, `is_teacher`) VALUES
(1, 'test@gmail.com', '123', 0, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `modules`
--
ALTER TABLE `modules`
  ADD PRIMARY KEY (`module_id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `teachers`
--
ALTER TABLE `teachers`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `modules`
--
ALTER TABLE `modules`
  MODIFY `module_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `teachers`
--
ALTER TABLE `teachers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `attendance`
--
ALTER TABLE `attendance`
  ADD CONSTRAINT `attendance_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
