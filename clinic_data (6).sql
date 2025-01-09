-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 09, 2025 at 04:53 AM
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
-- Database: `clinic_data`
--

-- --------------------------------------------------------

--
-- Table structure for table `account`
--

CREATE TABLE `account` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `email` text NOT NULL,
  `verification_code` text NOT NULL,
  `email_verified_at` datetime DEFAULT NULL,
  `new_password` varchar(50) NOT NULL,
  `confirm_password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `account`
--

INSERT INTO `account` (`id`, `name`, `password`, `email`, `verification_code`, `email_verified_at`, `new_password`, `confirm_password`) VALUES
(16, 'admin', '159263', 'abesamiskheni@gmail.com', '', '2024-12-28 20:52:41', '', ''),
(18, 'minad', '159263', '', '', NULL, '', '');

-- --------------------------------------------------------

--
-- Table structure for table `consultations`
--

CREATE TABLE `consultations` (
  `ConsultationID` int(11) NOT NULL,
  `PatientID` int(11) NOT NULL,
  `TimeIn` time NOT NULL DEFAULT current_timestamp(),
  `TimeOut` time DEFAULT current_timestamp(),
  `SOAP` text DEFAULT NULL,
  `CreatedAt` datetime DEFAULT current_timestamp(),
  `UpdatedAt` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `LastEditedBy` int(11) DEFAULT NULL,
  `Date` date NOT NULL DEFAULT current_timestamp(),
  `Subjective` text NOT NULL,
  `Objective` text NOT NULL,
  `Assessment` text NOT NULL,
  `Plan` text NOT NULL,
  `PlanDate` date NOT NULL DEFAULT current_timestamp(),
  `SavedBy` varchar(20) NOT NULL,
  `Name` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `consultations`
--

INSERT INTO `consultations` (`ConsultationID`, `PatientID`, `TimeIn`, `TimeOut`, `SOAP`, `CreatedAt`, `UpdatedAt`, `LastEditedBy`, `Date`, `Subjective`, `Objective`, `Assessment`, `Plan`, `PlanDate`, `SavedBy`, `Name`) VALUES
(3, 7, '00:00:00', '00:00:00', NULL, '2024-12-14 23:21:36', '2024-12-14 23:21:36', NULL, '2024-12-14', 'dsadsa', 'dsadsadsa', 'dsadsad', 'dsadsadsad', '2024-12-22', 'Doc', ''),
(12, 6, '11:30:00', '11:30:00', NULL, '2024-12-15 11:30:36', '2024-12-15 11:30:36', NULL, '2024-12-15', 'sadsadsa', 'dasdsadasd', 'dasdsadasda', 'dasdadsadsa', '2024-12-19', 'Doc', ''),
(15, 1, '11:38:00', '12:38:00', NULL, '2024-12-15 11:39:00', '2024-12-15 11:39:00', NULL, '2024-12-15', 'cancer', 'cancer', 'cancer', '', '2024-12-19', 'Doc', ''),
(16, 1, '11:39:00', '12:39:00', NULL, '2024-12-15 11:39:38', '2024-12-15 11:39:38', NULL, '2024-12-15', 'cancer', 'cancer', 'cancer', 'cancer', '2024-12-20', 'Doc', ''),
(20, 20, '00:12:00', '00:12:00', NULL, '2025-01-09 00:12:48', '2025-01-09 00:12:48', NULL, '2025-01-09', 'klnfasnksafnkfas', 'fsalkgasklasgjksf', 'fsaklfasfsa;kj', 'fsahgsajsagjlk;sag', '2025-01-11', 'Doc', ''),
(21, 20, '00:21:00', '00:21:00', NULL, '2025-01-09 00:21:59', '2025-01-09 00:21:59', NULL, '2025-01-09', 'sadsadsa', 'dsadsadsadas', 'dsadasdasds', 'dsadasdasdas', '2025-01-10', 'doc', ''),
(22, 19, '11:47:00', '11:47:00', NULL, '2025-01-09 11:47:26', '2025-01-09 11:47:26', NULL, '2025-01-10', 'dasdsadas', 'dsadsadasdsa', 'animal_bite', 'dsadasdasdas', '2025-01-14', 'Doc', ''),
(23, 17, '11:48:00', '11:48:00', NULL, '2025-01-09 11:48:14', '2025-01-09 11:48:14', NULL, '2025-01-09', 'dasdsadsa', 'sadasdasd', 'respiratory', 'dasdasdsa', '2025-01-17', 'Doc', '');

-- --------------------------------------------------------

--
-- Table structure for table `email_logs`
--

CREATE TABLE `email_logs` (
  `id` int(11) NOT NULL,
  `recipient_email` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `status` enum('success','failed') NOT NULL,
  `sent_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `email_logs`
--

INSERT INTO `email_logs` (`id`, `recipient_email`, `subject`, `message`, `status`, `sent_at`) VALUES
(1, 'beboybuenafe59@gmail.com', 'TEST EMAIL', '123 HELLLO 123444', 'success', '2025-01-08 06:09:21'),
(2, 'boybe443@gmail.com', 'TEST EMAIL', 'KISSS', 'success', '2025-01-08 06:18:35'),
(3, 'abesamiskheni@gmail.com', 'Job Application', 'Can i apply for a job.', 'failed', '2025-01-08 14:20:50'),
(4, 'abesamiskheni@gmail.com', 'Job Application', 'dsadsadsa', 'failed', '2025-01-08 14:24:23'),
(5, 'abesamiskheni@gmail.com', 'Job Application', 'dsadsadsa', 'failed', '2025-01-08 14:24:29');

-- --------------------------------------------------------

--
-- Table structure for table `patients`
--

CREATE TABLE `patients` (
  `PatientID` int(11) NOT NULL,
  `FirstName` varchar(50) NOT NULL,
  `LastName` varchar(50) NOT NULL,
  `MiddleInitial` varchar(10) NOT NULL,
  `Sex` char(1) DEFAULT NULL CHECK (`Sex` in ('M','F')),
  `DOB` date NOT NULL,
  `Address` varchar(255) DEFAULT NULL,
  `ContactNumber` varchar(15) DEFAULT NULL,
  `CreatedAt` datetime DEFAULT current_timestamp(),
  `UpdatedAt` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `age` int(11) NOT NULL,
  `civil_status` varchar(20) NOT NULL,
  `emergency_number` varchar(15) NOT NULL,
  `guardian` varchar(50) NOT NULL,
  `height` varchar(10) NOT NULL,
  `weight` varchar(10) NOT NULL,
  `yearLevel` varchar(20) NOT NULL,
  `specialCases` varchar(20) NOT NULL,
  `Program` varchar(20) NOT NULL,
  `Student_Num` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `patient_pic` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `patients`
--

INSERT INTO `patients` (`PatientID`, `FirstName`, `LastName`, `MiddleInitial`, `Sex`, `DOB`, `Address`, `ContactNumber`, `CreatedAt`, `UpdatedAt`, `age`, `civil_status`, `emergency_number`, `guardian`, `height`, `weight`, `yearLevel`, `specialCases`, `Program`, `Student_Num`, `email`, `patient_pic`) VALUES
(1, 'John', 'Doe', '', 'M', '1990-05-15', '123 Main St', '1234567890', '2024-12-04 15:04:54', '2025-01-09 00:21:21', 0, '', '', '', '', '', '', '', '', '21-14-212', '', ''),
(16, 'Khen', 'Abesamis', '', 'F', '0000-00-00', '', '9454595720', '2024-12-21 16:32:14', '2024-12-21 16:32:14', 21, 'Single', '', '', '200', '0', '4th Year', '', 'CBA', '21-14-001', 'abesamiskheni@gmail.com', ''),
(17, 'Linda ', 'Sugg', '', 'M', '0000-00-00', '', '9454595720', '2024-12-21 16:36:51', '2024-12-21 16:36:51', 21, 'Single', '', '', '122', '0', '2nd Year', 'PTB - Complied', 'CBA', '21-14-002', 'khenabesamis@gmail.com', ''),
(18, 'pusa', 'Lacy', '', 'F', '0000-00-00', '', '9454595720', '2024-12-23 20:39:04', '2024-12-23 20:39:04', 5, 'Single', '', '', '188', '0', '4th Year', 'For APL', 'CAS', '21-14-333', 'khenabesamis@gmail.com', ''),
(19, 'Lebron', 'James', '', 'M', '0000-00-00', '', '9454595720', '2025-01-06 05:33:01', '2025-01-06 05:33:01', 36, 'Single', '', '', '188', '0', '5th Year', 'Pregnant', 'CBA', '21-14-006', 'abesamiskheni@gmail.com', ''),
(20, 'Arl', 'Buenafe', 'Bago', 'M', '0000-00-00', 'Valenzuela city', '9312345672', '2025-01-08 14:18:15', '2025-01-08 14:18:15', 100, 'Single', '9826371827', 'Chris Buenafe', '150', '80', '5th Year', 'PWD', 'CED', '21-10-150', 'boybe443@gmail.com', '');

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `StaffID` int(11) NOT NULL,
  `FirstName` varchar(50) NOT NULL,
  `LastName` varchar(50) NOT NULL,
  `Role` varchar(30) NOT NULL,
  `CreatedAt` datetime DEFAULT current_timestamp(),
  `UpdatedAt` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`StaffID`, `FirstName`, `LastName`, `Role`, `CreatedAt`, `UpdatedAt`) VALUES
(1, 'Rei', 'Monik', 'Doctor', '2024-12-04 15:06:15', '2024-12-04 15:06:15'),
(2, 'Larry', 'Kristie', 'Nurse', '2024-12-04 15:06:15', '2024-12-04 15:06:15');

-- --------------------------------------------------------

--
-- Table structure for table `staffaccount`
--

CREATE TABLE `staffaccount` (
  `id` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `staffaccount`
--

INSERT INTO `staffaccount` (`id`, `username`, `password`) VALUES
(1, 'staff1', '159263');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `account`
--
ALTER TABLE `account`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `consultations`
--
ALTER TABLE `consultations`
  ADD PRIMARY KEY (`ConsultationID`),
  ADD KEY `PatientID` (`PatientID`),
  ADD KEY `LastEditedBy` (`LastEditedBy`);

--
-- Indexes for table `email_logs`
--
ALTER TABLE `email_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `patients`
--
ALTER TABLE `patients`
  ADD PRIMARY KEY (`PatientID`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`StaffID`);

--
-- Indexes for table `staffaccount`
--
ALTER TABLE `staffaccount`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `account`
--
ALTER TABLE `account`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `consultations`
--
ALTER TABLE `consultations`
  MODIFY `ConsultationID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `email_logs`
--
ALTER TABLE `email_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `patients`
--
ALTER TABLE `patients`
  MODIFY `PatientID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `StaffID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `staffaccount`
--
ALTER TABLE `staffaccount`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `consultations`
--
ALTER TABLE `consultations`
  ADD CONSTRAINT `consultations_ibfk_2` FOREIGN KEY (`LastEditedBy`) REFERENCES `staff` (`StaffID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
