-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 06, 2025 at 05:43 AM
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
(18, 'minad', '159263', '', '', NULL, '', ''),
(19, 'admin', '$2y$10$9Xqb9d9xqK4QX9UiOXS1tOjszl6nVXUOYC/yhALbNOb', 'abesamiskheni@gmail.com', '', '2024-12-28 21:04:54', '', ''),
(20, 'admin', '$2y$10$sJsK6Fn6HTshvCGBz6fqbO.V3DPrjln3RPCXarWvqpP', 'abesamiskheni@gmail.com', '', '2024-12-28 21:06:20', '', ''),
(21, 'admin', '$2y$10$Fxt6XvcVGI0kSiB2Jb.z4.p.fUBHFRtxkGN1IhAYhA0', 'abesamiskheni@gmail.com', '', '2024-12-28 21:07:16', '', ''),
(22, 'admin', '$2y$10$meOJhN7pWyB4YfG7H6sKY.FYW4GC0/Pl3WtSBDjHyyQ', 'abesamiskheni@gmail.com', '', '2025-01-03 23:21:35', '', '');

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
(16, 1, '11:39:00', '12:39:00', NULL, '2024-12-15 11:39:38', '2024-12-15 11:39:38', NULL, '2024-12-15', 'cancer', 'cancer', 'cancer', 'cancer', '2024-12-20', 'Doc', '');

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
  `email` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `patients`
--

INSERT INTO `patients` (`PatientID`, `FirstName`, `LastName`, `MiddleInitial`, `Sex`, `DOB`, `Address`, `ContactNumber`, `CreatedAt`, `UpdatedAt`, `age`, `civil_status`, `emergency_number`, `guardian`, `height`, `weight`, `yearLevel`, `specialCases`, `Program`, `Student_Num`, `email`) VALUES
(1, 'John', 'DoW', '', 'M', '1990-05-15', '123 Main St', '1234567890', '2024-12-04 15:04:54', '2025-01-06 12:42:21', 0, '', '', '', '', '', '', '', '', '21-14-212', ''),
(16, 'Khen', 'Abesamis', '', 'F', '0000-00-00', '', '9454595720', '2024-12-21 16:32:14', '2024-12-21 16:32:14', 21, 'Single', '', '', '200', '0', '4th Year', '', 'CBA', '21-14-001', 'abesamiskheni@gmail.com'),
(17, 'Linda ', 'Sugg', '', 'M', '0000-00-00', '', '9454595720', '2024-12-21 16:36:51', '2024-12-21 16:36:51', 21, 'Single', '', '', '122', '0', '2nd Year', 'PTB - Complied', 'CBA', '21-14-002', 'khenabesamis@gmail.com'),
(18, 'pusa', 'Lacy', '', 'F', '0000-00-00', '', '9454595720', '2024-12-23 20:39:04', '2024-12-23 20:39:04', 5, 'Single', '', '', '188', '0', '4th Year', 'For APL', 'CAS', '21-14-333', 'khenabesamis@gmail.com'),
(19, 'Lebron', 'James', '', 'M', '0000-00-00', '', '9454595720', '2025-01-06 05:33:01', '2025-01-06 05:33:01', 36, 'Single', '', '', '188', '0', '5th Year', 'Pregnant', 'CBA', '21-14-006', 'abesamiskheni@gmail.com');

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
  MODIFY `ConsultationID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `patients`
--
ALTER TABLE `patients`
  MODIFY `PatientID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

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
