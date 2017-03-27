-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Mar 27, 2017 at 07:35 AM
-- Server version: 10.1.16-MariaDB
-- PHP Version: 7.0.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `timereservationdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `participants`
--

CREATE TABLE `participants` (
  `id` int(2) NOT NULL,
  `lastname` varchar(150) DEFAULT NULL,
  `firstname` varchar(150) DEFAULT NULL,
  `emailaddress` text,
  `phone` varchar(15) DEFAULT NULL,
  `schedule` varchar(150) DEFAULT NULL,
  `ipaddress` varchar(19) DEFAULT NULL,
  `datemodified` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `participants`
--

INSERT INTO `participants` (`id`, `lastname`, `firstname`, `emailaddress`, `phone`, `schedule`, `ipaddress`, `datemodified`) VALUES
(259, 'Cortez ', 'S', 'e@hotmail.com', '1234566', NULL, NULL, '2017-03-27 13:34:51'),
(260, 'Sanchez', 'N', 'a@gmail.com', '70011234', NULL, NULL, '2017-03-27 13:34:55'),
(261, 'Tokuyama', 'S', 'b@yahoo.com', '4545', NULL, NULL, '2017-03-27 13:34:57'),
(262, 'Sanders', 'S', 'c@gmail.com', '43453434', NULL, NULL, '2017-03-27 13:35:01'),
(263, 'Trzepacz', 'T', 'd@softegg.com', '77342333', NULL, NULL, '2017-03-27 13:35:05');

-- --------------------------------------------------------

--
-- Table structure for table `schedules`
--

CREATE TABLE `schedules` (
  `id` int(10) NOT NULL,
  `slots` varchar(150) DEFAULT NULL,
  `status` varchar(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `schedules`
--

INSERT INTO `schedules` (`id`, `slots`, `status`) VALUES
(1, '11:00 - 11:15', '2'),
(2, '11:15 - 11:30', '6'),
(3, '11:30 - 11:45', '8'),
(4, '11:45 - 12:00', '10'),
(5, '12:00 - 12:15', '8'),
(6, '12:15 - 12:30', '0'),
(7, '12:30 - 12:45', '7'),
(8, '12:45 - 13:00', '9'),
(9, '13:00 - 13:15', '7'),
(10, '13:15 - 13:30', '9'),
(11, '13:30 - 13:45', '6'),
(12, '13:45 - 14:00', '9'),
(13, '14:00 - 14:15', '9'),
(14, '14:15 - 14:30', '8'),
(15, '14:30 - 14:45', '9'),
(16, '14:45 - 15:00', '8'),
(17, '15:00 - 15:15', '8'),
(18, '15:15 - 15:30', '9'),
(19, '15:30 - 15:45', '9'),
(20, '15:45 - 16:00', '6');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `participants`
--
ALTER TABLE `participants`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `schedules`
--
ALTER TABLE `schedules`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `participants`
--
ALTER TABLE `participants`
  MODIFY `id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=289;
--
-- AUTO_INCREMENT for table `schedules`
--
ALTER TABLE `schedules`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
