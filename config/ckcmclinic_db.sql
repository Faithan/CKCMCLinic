-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 22, 2025 at 03:56 AM
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
(1, 'admin_nurse', 'admin', 'first name', 'middle name', 'last name', 'nurse', '');

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
-- Table structure for table `record_tbl`
--

CREATE TABLE `record_tbl` (
  `record_id` int(11) NOT NULL,
  `student_id` bigint(255) NOT NULL,
  `record_date` date NOT NULL,
  `student_name` text NOT NULL,
  `student_department` text NOT NULL,
  `chief_complaint` text NOT NULL,
  `treatment` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `record_tbl`
--

INSERT INTO `record_tbl` (`record_id`, `student_id`, `record_date`, `student_name`, `student_department`, `chief_complaint`, `treatment`) VALUES
(11, 228224, '2025-01-21', 'Dan Cedric Morales Cablayan  ', 'Bachelor of Science in Computer Science', 'Headache', 'Paracetamol'),
(12, 228375, '2025-01-21', 'KC  V. Marcel ', 'Bachelor of Science in Computer Science', 'Headache', 'Aspirin'),
(13, 228719, '2025-01-21', 'John Rafael T Flores ', 'Bachelor of Science in Computer Science', 'Headache', 'Aspirin');

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
  MODIFY `course_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `record_tbl`
--
ALTER TABLE `record_tbl`
  MODIFY `record_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

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
