-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jul 24, 2016 at 06:20 PM
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
-- Table structure for table `requests`
--

CREATE TABLE `requests` (
  `request_id` int(11) NOT NULL,
  `activity_type` varchar(255) DEFAULT NULL,
  `criticality` varchar(255) DEFAULT NULL,
  `activity_desc` varchar(255) DEFAULT NULL,
  `project_name` varchar(255) DEFAULT NULL,
  `discipline` varchar(255) DEFAULT NULL,
  `ne_involved` varchar(255) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `start_time` time DEFAULT NULL,
  `end_time` time DEFAULT NULL,
  `gt_project_prop` varchar(255) DEFAULT NULL,
  `contact_num_prop` varchar(255) DEFAULT NULL,
  `gt_rep` varchar(255) DEFAULT NULL,
  `contact_num_rep` varchar(255) DEFAULT NULL,
  `vendor_rep` varchar(255) DEFAULT NULL,
  `contact_num_vendor` varchar(255) DEFAULT NULL,
  `reference_docs` varchar(255) DEFAULT NULL,
  `so_ref_number` varchar(255) DEFAULT NULL,
  `trs_config_number` varchar(255) DEFAULT NULL,
  `_status` enum('0','1','2') DEFAULT NULL,
  `remarks` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `requests`
--

INSERT INTO `requests` (`request_id`, `activity_type`, `criticality`, `activity_desc`, `project_name`, `discipline`, `ne_involved`, `date`, `start_time`, `end_time`, `gt_project_prop`, `contact_num_prop`, `gt_rep`, `contact_num_rep`, `vendor_rep`, `contact_num_vendor`, `reference_docs`, `so_ref_number`, `trs_config_number`, `_status`, `remarks`) VALUES
(1, 'Site Survey', 'Critical', 'Test description1', 'test project', 'Wireless Core', 'test ne involved', '2016-07-06', '01:24:15', '17:24:15', 'test gt proj proponent', '09999999999', 'test gt representative', '09999999999', 'vendor representative', '09999999919', 'FIO', 'SOREFNUME001', 'test trs num', NULL, 'for testing'),
(2, 'Site Survey', 'Critical', 'Test description2', 'test project', 'Wireless Core', 'test ne involved', '2016-07-06', '02:24:15', '17:24:15', 'test gt proj proponent', '09999999999', 'test gt representative', '09999999999', 'vendor representative', '09999999929', 'FIO', 'SOREFNUME002', 'test trs num', NULL, 'for testing'),
(3, 'Site Survey', 'Critical', 'Test description3', 'test project', 'Wireless Core', 'test ne involved', '2016-07-06', '03:24:15', '17:24:15', 'test gt proj proponent', '09999999999', 'test gt representative', '09999999999', 'vendor representative', '09999999939', 'FIO', 'SOREFNUME003', 'test trs num', NULL, 'for testing'),
(4, 'Site Survey', 'Critical', 'Test description4', 'test project', 'Wireless Core', 'test ne involved', '2016-07-06', '04:24:15', '17:24:15', 'test gt proj proponent', '09999999999', 'test gt representative', '09999999999', 'vendor representative', '09999999949', 'FIO', 'SOREFNUME004', 'test trs num', NULL, 'for testing'),
(5, 'Site Survey', 'Critical', 'Test description5', 'test project', 'Wireless Core', 'test ne involved', '2016-07-06', '05:24:15', '17:24:15', 'test gt proj proponent', '09999999999', 'test gt representative', '09999999999', 'vendor representative', '09999999959', 'FIO', 'SOREFNUME005', 'test trs num', NULL, 'for testing'),
(6, 'Site Survey', 'Critical', 'Test description6', 'test project', 'Wireless Core', 'test ne involved', '2016-07-06', '06:24:15', '17:24:15', 'test gt proj proponent', '09999999999', 'test gt representative', '09999999999', 'vendor representative', '09999999969', 'FIO', 'SOREFNUME006', 'test trs num', NULL, 'for testing'),
(7, 'Site Survey', 'Critical', 'Test description7', 'test project', 'Wireless Core', 'test ne involved', '2016-07-06', '07:24:15', '17:24:15', 'test gt proj proponent', '09999999999', 'test gt representative', '09999999999', 'vendor representative', '09999999979', 'FIO', 'SOREFNUME007', 'test trs num', NULL, 'for testing'),
(8, 'Site Survey', 'Critical', 'Test description8', 'test project', 'Wireless Core', 'test ne involved', '2016-07-06', '08:24:15', '17:24:15', 'test gt proj proponent', '09999999999', 'test gt representative', '09999999999', 'vendor representative', '09999999989', 'FIO', 'SOREFNUME008', 'test trs num', NULL, 'for testing'),
(9, 'Site Survey', 'Critical', 'Test description9', 'test project', 'Wireless Core', 'test ne involved', '2016-07-06', '09:24:15', '17:24:15', 'test gt proj proponent', '09999999999', 'test gt representative', '09999999999', 'vendor representative', '09999999909', 'FIO', 'SOREFNUME009', 'test trs num', NULL, 'for testing'),
(10, 'Site Survey', 'Critical', 'Test description10', 'test project', 'Wireless Core', 'test ne involved', '2016-07-06', '10:24:15', '17:24:15', 'test gt proj proponent', '09999999999', 'test gt representative', '09999999999', 'vendor representative', '09999999199', 'FIO', 'SOREFNUME010', 'test trs num', NULL, 'for testing'),
(11, 'Site Survey', 'Critical', 'Test description11', 'test project', 'Wireless Core', 'test ne involved', '2016-07-06', '11:24:15', '17:24:15', 'test gt proj proponent', '09999999999', 'test gt representative', '09999999999', 'vendor representative', '09999999299', 'FIO', 'SOREFNUME011', 'test trs num', NULL, 'for testing'),
(12, 'Site Survey', 'Critical', 'Test description12', 'test project', 'Wireless Core', 'test ne involved', '2016-07-06', '12:24:15', '17:24:15', 'test gt proj proponent', '09999999999', 'test gt representative', '09999999999', 'vendor representative', '09999999399', 'FIO', 'SOREFNUME012', 'test trs num', NULL, 'for testing'),
(13, 'Site Survey', 'Critical', 'Test description13', 'test project', 'Wireless Core', 'test ne involved', '2016-07-06', '13:24:15', '17:24:15', 'test gt proj proponent', '09999999999', 'test gt representative', '09999999999', 'vendor representative', '09999999499', 'FIO', 'SOREFNUME013', 'test trs num', NULL, 'for testing'),
(14, 'Site Survey', 'Critical', 'Test description14', 'test project', 'Wireless Core', 'test ne involved', '2016-07-06', '14:24:15', '17:24:15', 'test gt proj proponent', '09999999999', 'test gt representative', '09999999999', 'vendor representative', '09999999599', 'FIO', 'SOREFNUME014', 'test trs num', NULL, 'for testing'),
(15, 'Site Survey', 'Critical', 'Test description15', 'test project', 'Wireless Core', 'test ne involved', '2016-07-06', '15:24:15', '17:24:15', 'test gt proj proponent', '09999999999', 'test gt representative', '09999999999', 'vendor representative', '09999999699', 'FIO', 'SOREFNUME015', 'test trs num', NULL, 'for testing'),
(16, 'Site Survey', 'Critical', 'Test description16', 'test project', 'Wireless Core', 'test ne involved', '2016-07-06', '17:24:15', '17:24:15', 'test gt proj proponent', '09999999999', 'test gt representative', '09999999999', 'vendor representative', '09999999799', 'FIO', 'SOREFNUME016', 'test trs num', NULL, 'for testing'),
(17, 'Site Survey', 'Critical', 'Test description17', 'test project', 'Wireless Core', 'test ne involved', '2016-07-06', '18:24:15', '17:24:15', 'test gt proj proponent', '09999999999', 'test gt representative', '09999999999', 'vendor representative', '09999999299', 'FIO', 'SOREFNUME017', 'test trs num', NULL, 'for testing'),
(18, 'Site Survey', 'Critical', 'Test description18', 'test project', 'Wireless Core', 'test ne involved', '2016-07-06', '19:24:15', '17:24:15', 'test gt proj proponent', '09999999999', 'test gt representative', '09999999999', 'vendor representative', '09999999399', 'FIO', 'SOREFNUME018', 'test trs num', NULL, 'for testing'),
(19, 'Site Survey', 'Critical', 'Test description19', 'test project', 'Wireless Core', 'test ne involved', '2016-07-06', '20:24:15', '17:24:15', 'test gt proj proponent', '09999999999', 'test gt representative', '09999999999', 'vendor representative', '09999999499', 'FIO', 'SOREFNUME019', 'test trs num', NULL, 'for testing'),
(20, 'Site Survey', 'Critical', 'Test description20', 'test project', 'Wireless Core', 'test ne involved', '2016-07-06', '21:24:15', '17:24:15', 'test gt proj proponent', '09999999999', 'test gt representative', '09999999999', 'vendor representative', '09999999599', 'FIO', 'SOREFNUME020', 'test trs num', NULL, 'for testing'),
(21, 'Site Survey', 'Critical', 'Test description21', 'test project', 'Wireless Core', 'test ne involved', '2016-07-06', '22:24:15', '17:24:15', 'test gt proj proponent', '09999999999', 'test gt representative', '09999999999', 'vendor representative', '09999999699', 'FIO', 'SOREFNUME021', 'test trs num', NULL, 'for testing'),
(22, 'Site Survey', 'Critical', 'Test description22', 'test project', 'Wireless Core', 'test ne involved', '2016-07-06', '23:24:15', '17:24:15', 'test gt proj proponent', '09999999999', 'test gt representative', '09999999999', 'vendor representative', '09999999799', 'FIO', 'SOREFNUME022', 'test trs num', NULL, 'for testing');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `requests`
--
ALTER TABLE `requests`
  ADD PRIMARY KEY (`request_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `requests`
--
ALTER TABLE `requests`
  MODIFY `request_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
