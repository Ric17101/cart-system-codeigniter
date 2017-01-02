-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jul 25, 2016 at 05:54 AM
-- Server version: 10.1.9-MariaDB
-- PHP Version: 5.6.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ci_request`
--

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `color` varchar(7) NOT NULL DEFAULT '#3a87ad',
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `title`, `description`, `color`, `date`) VALUES
(11, 'Christmas Holiday ! ', 'I have a holiday in this day :)', '#e00e2b', '2016-07-06 09:24:00'),
(12, 'Meeting', 'Have a meeitng', '#4c55f2', '2016-07-14 09:25:00'),
(13, 'Urgent work', 'Have to Call Boominathan', '#6bce45', '2016-07-25 10:26:00'),
(14, 'Rest', 'Take rest ', '#c529d5', '2015-12-24 11:28:00'),
(15, 'Christmas Holiday ! ', 'I have a holiday in this day :)', '#e00e2b', '2016-07-06 09:24:00'),
(16, 'Meeting', 'Have a meeitng', '#4c55f2', '2016-07-14 09:25:00'),
(17, 'Urgent work', 'Have to Call Boominathan', '#6bce45', '2016-07-25 10:26:00'),
(18, 'Rest', 'Take rest ', '#c529d5', '2015-12-24 11:28:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
