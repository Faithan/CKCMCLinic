-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 17, 2025 at 01:14 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ckcmclinic_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_tbl`
--

CREATE TABLE `admin_tbl` (
  `admin_id` int(11) NOT NULL,
  `admin_username` text NOT NULL,
  `admin_password` text NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `middle_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `admin_position` varchar(255) NOT NULL,
  `admin_pic` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_tbl`
--

INSERT INTO `admin_tbl` (`admin_id`, `admin_username`, `admin_password`, `first_name`, `middle_name`, `last_name`, `admin_position`, `admin_pic`) VALUES
(1, 'admin_nurse', 'admin', 'Scarlet', 'middle name', 'Marinduque', 'School Nurse', 'nurse.png');

-- --------------------------------------------------------

--
-- Table structure for table `course_tbl`
--

CREATE TABLE `course_tbl` (
  `course_id` int(11) NOT NULL,
  `course_name` varchar(255) NOT NULL,
  `course_info` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `course_tbl`
--

INSERT INTO `course_tbl` (`course_id`, `course_name`, `course_info`) VALUES
(1, 'Bachelor of Science in Computer Science', ' Bachelor of Science Major in Computer Science is an undergraduate degree program that focuses on the mathematical and theoretical foundations of computing. It is a four-year program that combines general education with computer science, mathematics, and '),
(2, 'Bachelor of Science in Criminology', 'none'),
(3, 'Bachelor of Arts in English Languages', 'none'),
(4, 'Bachelor of Science in Social Science', 'none'),
(5, 'Bachelor of Science in Education Major in English', 'none'),
(6, 'Bachelor of Science in Secondary  Education Major in Mathematics', 'none'),
(7, 'Bachelor of Science in Eduction Major in Basic Education', 'none'),
(8, 'Bachelor of Science in Business Administration Major in Accounting', 'none'),
(9, 'Bachelor of Science in Business Administration Major in Financing Management', '');

-- --------------------------------------------------------

--
-- Table structure for table `medicines_tbl`
--

CREATE TABLE `medicines_tbl` (
  `medicine_id` int(11) NOT NULL,
  `medicine_name` varchar(255) NOT NULL,
  `medicine_description` text NOT NULL,
  `medicine_pic` text NOT NULL,
  `stocks` int(255) NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `medicines_tbl`
--

INSERT INTO `medicines_tbl` (`medicine_id`, `medicine_name`, `medicine_description`, `medicine_pic`, `stocks`, `created_at`) VALUES
(1, 'Paracetamol', '', '', 2, '2025-03-17 11:47:28'),
(2, 'Ibuprofen', '', '', 4, '2025-03-17 11:47:52'),
(3, 'Sumatriptan', '', '', 4, '2025-03-17 11:48:07'),
(4, 'Naproxen', '', '', 4, '2025-03-17 11:48:26'),
(5, 'Dextromethorphan', '', '', 0, '2025-03-17 11:48:44');

-- --------------------------------------------------------

--
-- Table structure for table `record_tbl`
--

CREATE TABLE `record_tbl` (
  `record_id` int(11) NOT NULL,
  `student_id` bigint(255) NOT NULL,
  `record_date` date NOT NULL,
  `record_time` time NOT NULL,
  `student_name` text NOT NULL,
  `student_department` text NOT NULL,
  `chief_complaint` text NOT NULL,
  `treatment` text NOT NULL,
  `medicine_taken` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `record_tbl`
--

INSERT INTO `record_tbl` (`record_id`, `student_id`, `record_date`, `record_time`, `student_name`, `student_department`, `chief_complaint`, `treatment`, `medicine_taken`) VALUES
(11, 228224, '2025-01-21', '00:00:00', 'Dan Cedric Morales Cablayan  ', 'Bachelor of Science in Computer Science', 'HeadAche', 'Paracetamol', ''),
(12, 228375, '2025-01-21', '00:00:00', 'KC  V. Marcel ', 'Bachelor of Science in Computer Science', 'dgfdfgd', 'asdasd', ''),
(13, 228719, '2025-01-21', '00:00:00', 'John Rafael T Flores ', 'Bachelor of Science in Computer Science', 'headache', 'aspirin', ''),
(14, 228719, '2025-03-17', '00:00:00', 'John Rafael T Flores ', 'Bachelor of Science in Computer Science', 'Headache', 'Drink water, rest in a dark room, use pain relievers.', ''),
(15, 228719, '2025-03-17', '00:00:00', 'John Rafael T Flores ', 'Bachelor of Science in Computer Science', 'Headache', 'Drink water, rest in a dark room, use pain relievers.', ''),
(16, 228224, '2025-03-17', '19:43:03', 'Dan Cedric Morales Cablayan  ', 'Bachelor of Science in Computer Science', 'Headache', 'Drink water, rest in a dark room, use pain relievers.', 'Array'),
(17, 228224, '2025-03-17', '19:46:25', 'Dan Cedric Morales Cablayan  ', 'Bachelor of Science in Computer Science', 'Headache', 'Drink water, rest in a dark room, use pain relievers.', '1'),
(18, 228224, '2025-03-17', '19:48:03', 'Dan Cedric Morales Cablayan  ', 'Bachelor of Science in Computer Science', 'Headache', 'Drink water, rest in a dark room, use pain relievers.', 'Paracetamol, Ibuprofen'),
(19, 228224, '2025-03-17', '19:51:05', 'Dan Cedric Morales Cablayan  ', 'Bachelor of Science in Computer Science', 'Headache', 'Drink water, rest in a dark room, use pain relievers.', 'Paracetamol, Ibuprofen'),
(20, 228224, '2025-03-17', '19:52:34', 'Dan Cedric Morales Cablayan  ', 'Bachelor of Science in Computer Science', 'Headache', 'Drink water, rest in a dark room, use pain relievers.', 'Paracetamol, Ibuprofen'),
(21, 228224, '2025-03-17', '19:53:49', 'Dan Cedric Morales Cablayan  ', 'Bachelor of Science in Computer Science', 'Headache', 'Drink water, rest in a dark room, use pain relievers.', 'Paracetamol'),
(22, 228224, '2025-03-17', '19:55:59', 'Dan Cedric Morales Cablayan  ', 'Bachelor of Science in Computer Science', 'Headache', 'Drink water, rest in a dark room, use pain relievers.', 'Paracetamol'),
(23, 228224, '2025-03-17', '20:04:07', 'Dan Cedric Morales Cablayan  ', 'Bachelor of Science in Computer Science', 'Headache', 'Drink water, rest in a dark room, use pain relievers.', 'Paracetamol');

-- --------------------------------------------------------

--
-- Table structure for table `student_tbl`
--

CREATE TABLE `student_tbl` (
  `user_id` int(11) NOT NULL,
  `student_id` bigint(255) NOT NULL,
  `password` text NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `middle_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `extension` text NOT NULL,
  `email` text NOT NULL,
  `gender` varchar(50) NOT NULL,
  `birthdate` date NOT NULL,
  `age` int(255) NOT NULL,
  `birth_place` text NOT NULL,
  `marital_status` text NOT NULL,
  `address` text NOT NULL,
  `religion` text NOT NULL,
  `additional_info` text NOT NULL,
  `department` text NOT NULL,
  `year_level` text NOT NULL,
  `profile_picture` text NOT NULL,
  `blood_pressure` text NOT NULL,
  `temperature` text NOT NULL,
  `pulse_rate` text NOT NULL,
  `respiratory_rate` text NOT NULL,
  `height` text NOT NULL,
  `weight` text NOT NULL,
  `eperson1_name` text NOT NULL,
  `eperson1_phone` bigint(20) NOT NULL,
  `eperson1_relationship` text NOT NULL,
  `eperson2_name` text NOT NULL,
  `eperson2_phone` bigint(20) NOT NULL,
  `eperson2_relationship` text NOT NULL,
  `health_record` text NOT NULL,
  `datetime_recorded` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student_tbl`
--

INSERT INTO `student_tbl` (`user_id`, `student_id`, `password`, `first_name`, `middle_name`, `last_name`, `extension`, `email`, `gender`, `birthdate`, `age`, `birth_place`, `marital_status`, `address`, `religion`, `additional_info`, `department`, `year_level`, `profile_picture`, `blood_pressure`, `temperature`, `pulse_rate`, `respiratory_rate`, `height`, `weight`, `eperson1_name`, `eperson1_phone`, `eperson1_relationship`, `eperson2_name`, `eperson2_phone`, `eperson2_relationship`, `health_record`, `datetime_recorded`) VALUES
(31, 228719, 'SohxPQo2bK', 'John Rafael', 'T', 'Flores', '', 'rafael@gmail.com', 'male', '2004-06-14', 20, 'Simpak, Lala, Lanao del Norte', 'single', 'Simpak, Lala, Lanao del Norte', 'roman catholic', '', 'Bachelor of Science in Computer Science', '3rd', '1736042625_472276427_1261371525169409_7688329182028481839_n.jpg', '', '', '', '', '', '', 'John Rafael T. Flores', 9123456789, 'himself', '', 0, '', '', '2025-01-05 10:03:45'),
(32, 228224, 'YURM7bnfM4', 'Dan Cedric', 'Morales', 'Cablayan ', '', 'cablayan@gmail.com', 'male', '2001-07-01', 23, 'Maranding lala Lanao, LDN', 'single', 'Maranding lala Lanao, LDN', 'roman catholic', '', 'Bachelor of Science in Computer Science', '3rd', '1736043069_472357174_472739102233227_4650933974427041552_n.jpg', '', '37', '60', '30', '1.60', '50', 'Marivic Morales Cablayan', 9287742180, 'Mother', '', 0, '', '', '2025-01-05 10:11:09'),
(33, 228375, 'huSrMfPUG2', 'KC ', 'V.', 'Marcel', '', 'marcel@gmail.com', 'female', '2004-05-04', 20, 'Simpak Lala Lanao del Norte', 'single', 'P-2 Darumawang Ilaya, Lala, Lanao del Norte ', 'Seventh Day Adventist ', '', 'Bachelor of Science in Computer Science', '3rd', '1736043373_467478326_1267170528004242_1852056616610060103_n.jpg', '120/80', '37', '60', '20', '1.50', '40', 'Donagen V. Marcel ', 9709180471, 'Mother', '', 0, '', '', '2025-01-05 10:16:13');

-- --------------------------------------------------------

--
-- Table structure for table `year_lvl_tbl`
--

CREATE TABLE `year_lvl_tbl` (
  `year_lvl_id` int(11) NOT NULL,
  `year_lvl_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `year_lvl_tbl`
--

INSERT INTO `year_lvl_tbl` (`year_lvl_id`, `year_lvl_name`) VALUES
(1, '1st'),
(2, '2nd'),
(3, '3rd'),
(4, '4th');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_tbl`
--
ALTER TABLE `admin_tbl`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `course_tbl`
--
ALTER TABLE `course_tbl`
  ADD PRIMARY KEY (`course_id`);

--
-- Indexes for table `medicines_tbl`
--
ALTER TABLE `medicines_tbl`
  ADD PRIMARY KEY (`medicine_id`);

--
-- Indexes for table `record_tbl`
--
ALTER TABLE `record_tbl`
  ADD PRIMARY KEY (`record_id`);

--
-- Indexes for table `student_tbl`
--
ALTER TABLE `student_tbl`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `year_lvl_tbl`
--
ALTER TABLE `year_lvl_tbl`
  ADD PRIMARY KEY (`year_lvl_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_tbl`
--
ALTER TABLE `admin_tbl`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `course_tbl`
--
ALTER TABLE `course_tbl`
  MODIFY `course_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `medicines_tbl`
--
ALTER TABLE `medicines_tbl`
  MODIFY `medicine_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `record_tbl`
--
ALTER TABLE `record_tbl`
  MODIFY `record_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `student_tbl`
--
ALTER TABLE `student_tbl`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `year_lvl_tbl`
--
ALTER TABLE `year_lvl_tbl`
  MODIFY `year_lvl_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
