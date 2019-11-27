-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Nov 27, 2019 at 07:00 PM
-- Server version: 10.4.8-MariaDB
-- PHP Version: 7.3.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `GOAT_CMS`
--

-- --------------------------------------------------------

--
-- Table structure for table `Hardware`
--

CREATE TABLE `Hardware` (
  `hardwareID` int(5) NOT NULL COMMENT 'Primary key',
  `serialNum` varchar(30) DEFAULT NULL COMMENT 'Serial Number',
  `make` varchar(50) NOT NULL COMMENT 'Manufacturer',
  `description` varchar(100) NOT NULL COMMENT 'Description of hardware',
  `cost` double(9,2) DEFAULT NULL COMMENT 'Cost of unit',
  `notes` varchar(1000) DEFAULT NULL COMMENT 'Notes about the unit',
  `assignedTo` int(5) DEFAULT NULL COMMENT 'The userID the piece is signed out to'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `Hardware`
--

INSERT INTO `Hardware` (`hardwareID`, `serialNum`, `make`, `description`, `cost`, `notes`, `assignedTo`) VALUES
(10, NULL, 'Apple', 'USB-C Adapter HDMI', 50.99, 'USB-C to HDMI Adapter for MacBook ', 1),
(11, 'HN5PJMXW6', 'Apple', 'Ipad 7th Gen, Wifi Model', 349.99, 'Space Grey Wifi Model', NULL),
(12, 'IO2RN2OMMN', 'LG', '5K Monitor', 999.99, 'At repair facility until further notice', NULL),
(13, 'NO45NONROIN2R', 'Apple', 'IMAC PRO', 6999.99, '32gb RAM, 2TB SSD', 18),
(14, '', 'Wacom', 'Professional Designer Tablet', 7999.99, '', 22),
(15, '', 'Apple', 'Pencil', 99.99, '', NULL),
(16, '', 'Ducky', 'Mechanical Keyboard', 99.99, 'White mechanical keyboard', 19);

-- --------------------------------------------------------

--
-- Table structure for table `HardwareCategories`
--

CREATE TABLE `HardwareCategories` (
  `categoryID` int(5) NOT NULL,
  `hardwareCategory` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `HardwareCategories`
--

INSERT INTO `HardwareCategories` (`categoryID`, `hardwareCategory`) VALUES
(1, 'make'),
(2, 'description'),
(3, 'assignedTo');

-- --------------------------------------------------------

--
-- Table structure for table `software`
--

CREATE TABLE `software` (
  `softwareID` int(11) NOT NULL COMMENT 'Primary Key',
  `licenseKey` varchar(50) NOT NULL COMMENT 'License key for software products',
  `version` varchar(10) DEFAULT NULL COMMENT 'software version',
  `publisher` varchar(50) NOT NULL COMMENT 'software publisher',
  `description` varchar(100) NOT NULL,
  `subscription` char(1) NOT NULL COMMENT 'Software is part of a subscription true or false',
  `cost` double(9,2) DEFAULT NULL COMMENT 'cost of software product',
  `subscriptionCycle` varchar(50) DEFAULT NULL COMMENT 'The subscription cycle for a subscription-based software product',
  `location` char(5) NOT NULL COMMENT 'Location of the software, either local or cloud',
  `expiry` datetime DEFAULT NULL COMMENT 'When the license expires',
  `assignedTo` int(5) DEFAULT NULL COMMENT 'The userID the software is assigned to'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Software attributes';

--
-- Dumping data for table `software`
--

INSERT INTO `software` (`softwareID`, `licenseKey`, `version`, `publisher`, `description`, `subscription`, `cost`, `subscriptionCycle`, `location`, `expiry`, `assignedTo`) VALUES
(1, 'HN5PJMXWLSDF', '', 'Adobe', 'Creative Cloud', 'y', 99.99, 'Yearly', 'cloud', '2020-02-25 00:00:00', 1),
(2, 'AXWF-YHXC-IKGH', '1.1.1', 'Apple', 'Final Cut Pro X', 'n', 279.99, '', 'local', '2020-12-31 00:00:00', 1),
(3, 'JSDIOFOIHSDV', '5.1.2', 'Autodesk', 'Autocad', 'n', 5999.99, '', 'local', '2021-12-31 00:00:00', NULL),
(4, 'AXEW-9SDF-K234', '', 'Microsoft', 'Office 365', 'y', 99.99, 'Yearly', 'cloud', '2020-06-10 00:00:00', 22),
(6, 'AVEM-0DK3-L23K-K32M', '10.2', 'VMware Inc', 'VMware Workstation Pro', 'y', 49.99, 'Yearly', 'local', '2021-12-31 00:00:00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `SoftwareCategories`
--

CREATE TABLE `SoftwareCategories` (
  `categoryID` int(5) NOT NULL,
  `softwareCategory` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `SoftwareCategories`
--

INSERT INTO `SoftwareCategories` (`categoryID`, `softwareCategory`) VALUES
(1, 'publisher'),
(2, 'description'),
(3, 'subscription'),
(4, 'assignedTo'),
(7, 'softwareid'),
(8, 'location');

-- --------------------------------------------------------

--
-- Table structure for table `UserCategories`
--

CREATE TABLE `UserCategories` (
  `categoryID` int(5) NOT NULL,
  `userCategory` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `UserCategories`
--

INSERT INTO `UserCategories` (`categoryID`, `userCategory`) VALUES
(1, 'username'),
(2, 'firstName'),
(3, 'lastName'),
(4, 'active'),
(5, 'department'),
(6, 'level'),
(9, 'lastlogin');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `userID` int(5) NOT NULL COMMENT 'Primary key',
  `level` int(1) NOT NULL COMMENT 'Account level, can only be values 1 to 3',
  `department` varchar(100) DEFAULT NULL COMMENT 'department name',
  `active` char(1) NOT NULL COMMENT 'Account status, must be ''y'' or ''n''',
  `firstName` varchar(50) NOT NULL,
  `lastName` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL DEFAULT 'Password01',
  `lastLogin` datetime NOT NULL DEFAULT current_timestamp(),
  `notes` varchar(1000) DEFAULT NULL,
  `username` varchar(20) NOT NULL,
  `image` varchar(500) DEFAULT NULL,
  `bio` varchar(1000) DEFAULT NULL COMMENT 'user bio'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Users table for CMS system';

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userID`, `level`, `department`, `active`, `firstName`, `lastName`, `password`, `lastLogin`, `notes`, `username`, `image`, `bio`) VALUES
(1, 1, 'DB Admin', 'y', 'Arthur', 'Pendleton', '$2y$10$fGsGCbWyFk69HVtaLPgGfOh239sboz9cSRMzJk2veGo9crcm44FHm', '2019-11-09 08:40:54', 'Test Admin', 'apendle', 'imacG3_thumb_2019-11-26 10:51:43.jpg', 'This is a test of the bio system without file upload alan '),
(18, 1, 'Admin', 'y', 'Alan', 'Simpson', '$2y$10$V.v3l/DF0M3L7OsFjxtt/.fkCiDY6KFoYDDoSILuZ9M2kXUZl9W5m', '2019-11-09 10:16:46', 'CEO of Design by the GOAT', 'asimpson', NULL, NULL),
(19, 2, 'Development', 'y', 'Shawn', 'Robson', '$2y$10$cjF.5p79uuAFMVWbE/PciufM.c4/xOmbeemGLWSA7Qvk1J4XJLEVS', '2019-11-11 07:34:30', 'Promoted to manager', 'srobson', '', NULL),
(21, 3, 'Finance', 'n', 'Amy', 'Thorinson', '$2y$10$ZFZGJnQsZwjEL9j.ZnQmTO8Jt0HMiF6Jq5NQ/AGgjtma5tLZFKUSa', '2019-11-11 07:34:08', 'Away on maternity leave', 'athorinson', NULL, NULL),
(22, 3, 'Marketing', 'y', 'Stephen', 'McKinnon', '$2y$10$pC6OyMMcuGIitg7YUXvHVea7wCbvy/x5WA8djVyRH9hvoi4Hn.2V6', '2019-11-11 02:20:45', 'test account', 'smckinnon', 'index_thumb_2019-11-27 05:24:13.png', ''),
(23, 3, 'Development', 'n', 'Alan', 'SimpsonJr', '$2y$10$Pbpl2yx7n7MwOxFbXLuqmOeKqO7LlwMwA/4jR53ItQiAJXHSxs2DK', '2019-11-12 03:05:49', '', 'asimpjr', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Hardware`
--
ALTER TABLE `Hardware`
  ADD PRIMARY KEY (`hardwareID`),
  ADD KEY `usesHardwareFK` (`assignedTo`);

--
-- Indexes for table `HardwareCategories`
--
ALTER TABLE `HardwareCategories`
  ADD PRIMARY KEY (`categoryID`);

--
-- Indexes for table `software`
--
ALTER TABLE `software`
  ADD PRIMARY KEY (`softwareID`),
  ADD UNIQUE KEY `licenseKey` (`licenseKey`),
  ADD KEY `usesSoftwareFK` (`assignedTo`);

--
-- Indexes for table `SoftwareCategories`
--
ALTER TABLE `SoftwareCategories`
  ADD PRIMARY KEY (`categoryID`);

--
-- Indexes for table `UserCategories`
--
ALTER TABLE `UserCategories`
  ADD PRIMARY KEY (`categoryID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userID`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Hardware`
--
ALTER TABLE `Hardware`
  MODIFY `hardwareID` int(5) NOT NULL AUTO_INCREMENT COMMENT 'Primary key', AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `HardwareCategories`
--
ALTER TABLE `HardwareCategories`
  MODIFY `categoryID` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `software`
--
ALTER TABLE `software`
  MODIFY `softwareID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Primary Key', AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `SoftwareCategories`
--
ALTER TABLE `SoftwareCategories`
  MODIFY `categoryID` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `UserCategories`
--
ALTER TABLE `UserCategories`
  MODIFY `categoryID` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `userID` int(5) NOT NULL AUTO_INCREMENT COMMENT 'Primary key', AUTO_INCREMENT=24;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `Hardware`
--
ALTER TABLE `Hardware`
  ADD CONSTRAINT `usesHardwareFK` FOREIGN KEY (`assignedTo`) REFERENCES `users` (`userID`);

--
-- Constraints for table `software`
--
ALTER TABLE `software`
  ADD CONSTRAINT `usesSoftwareFK` FOREIGN KEY (`assignedTo`) REFERENCES `users` (`userID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
