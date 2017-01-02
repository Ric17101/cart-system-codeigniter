-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Oct 24, 2016 at 07:31 AM
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
-- Table structure for table `activity_calendar_date_color`
--

CREATE TABLE `activity_calendar_date_color` (
  `id` int(11) NOT NULL,
  `color` varchar(255) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `activity_calendar_date_color`
--

INSERT INTO `activity_calendar_date_color` (`id`, `color`, `date`) VALUES
(1, '#B7B7B7', '2016-09-27'),
(2, '#B7B7B7', '2016-10-28'),
(3, '#B7B7B7', '2016-10-17'),
(4, '#B7B7B7', '2016-10-07'),
(5, '#B7B7B7', '2016-09-07'),
(6, '#B7B7B7', '2016-09-14'),
(7, '#B7B7B7', '2016-10-04'),
(8, '#B7B7B7', '2016-10-05'),
(9, '#B7B7B7', '2016-09-20'),
(10, '#B7B7B7', '2016-10-18'),
(11, '#B7B7B7', '2016-10-06');

-- --------------------------------------------------------

--
-- Table structure for table `activity_types`
--

CREATE TABLE `activity_types` (
  `id` int(11) NOT NULL,
  `activity_type` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `severity` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `activity_types`
--

INSERT INTO `activity_types` (`id`, `activity_type`, `type`, `severity`) VALUES
(1, 'Acceptance(SAT, HAT, iSAT, UAT)', '', 'minor'),
(2, 'Board acceptance', '', 'minor'),
(3, 'Card insertion', '', 'critical'),
(4, 'Card pullout', '', 'minor'),
(5, 'Delivery and Installation', '', 'minor'),
(6, 'Hardware changeout', '', 'critical'),
(7, 'Installation and commissioning ( For New NE)', '', 'minor'),
(8, 'Integration', '', 'major'),
(9, 'ISDN activation ( ISDN PRI, BERT, Sniffing)', '', 'minor'),
(10, 'Knockdown test', '', 'major'),
(11, 'Link migration', '', 'major'),
(12, 'Link provisioning', '', 'major'),
(13, 'NE Migration', '', 'critical'),
(14, 'Number definition', '', 'major'),
(15, 'Parameter modification', '', 'critical'),
(16, 'Patching', '', 'major'),
(17, 'Power down (shutdown)', '', 'critical'),
(18, 'Power tapping', '', 'critical'),
(19, 'Preventive maintenance', '', 'critical'),
(20, 'Ring acceptance', '', 'minor'),
(21, 'Site Survey', '', 'minor'),
(22, 'Software patch', '', 'critical'),
(23, 'Software upgrade', '', 'critical'),
(24, 'Subrack Expansion', '', 'critical'),
(25, 'System upgrade', '', 'critical');

-- --------------------------------------------------------

--
-- Table structure for table `activity_type_prerequisites`
--

CREATE TABLE `activity_type_prerequisites` (
  `id` int(11) NOT NULL,
  `activity_type_prerequisite` varchar(255) NOT NULL,
  `activity_type_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `activity_type_prerequisites`
--

INSERT INTO `activity_type_prerequisites` (`id`, `activity_type_prerequisite`, `activity_type_id`) VALUES
(1, 'Approved RAAWA', 1),
(2, 'No major punchlist in equipment installation checklist', 1),
(3, 'Approved RAAWA', 2),
(4, 'Approved RAAWA', 3),
(5, 'Approved MOP', 3),
(6, 'Secured CFEI approval', 3),
(7, 'HEO concurrence and validation on Rectifier System/Inverter Sytem loadings', 3),
(8, 'Approved SACT/Service Order', 3),
(9, 'Approved RAAWA', 4),
(10, 'Approved MOP', 4),
(11, 'Approved Service Order', 4),
(12, 'Approved CFATA', 4),
(13, 'Approved TSSR', 5),
(14, 'GT Representative', 5),
(15, 'Vendor', 5),
(16, 'Approved RAAWA', 5),
(17, 'Approved RAAWA', 6),
(18, 'Approved MOP', 6),
(19, 'Approved Service Order', 6),
(20, 'Approved RAAWA', 7),
(21, 'Completed HEO UAT', 8),
(22, 'Completed Acceptance ( HAT,SAT)', 8),
(23, 'Approved RAAWA ( if on-site activity)', 8),
(24, 'Zero punchlist on Equipment installation and power tapping checklist', 8),
(25, 'Approved RAAWA ( If on-site activity)', 9),
(26, 'Approved MOP', 9),
(27, 'Approved Service Order', 9),
(28, 'Approved RAAWA ( If on-site activity)', 10),
(29, 'Approved MOP', 10),
(30, 'Approved Service Order', 10),
(31, 'Approved RAAWA ( If on-site activity)', 11),
(32, 'Approved MOP', 11),
(33, 'Approved Service Order', 11),
(34, 'Approved RAAWA ( If on-site activity)', 12),
(35, 'Approved MOP', 12),
(36, 'Approved Service Order', 12),
(37, 'Approved RAAWA ( if on-site activity)', 13),
(38, 'Approved MOP', 13),
(39, 'Approved Service Order', 13),
(40, 'Approved RAAWA ( If on-site activity)', 14),
(41, 'Approved MOP', 14),
(42, 'Approved Service Order', 14),
(43, 'Approved RAAWA ( If on-site activity)', 15),
(44, 'Approved MOP', 15),
(45, 'Approved Service Order', 15),
(46, 'Approved RAAWA', 16),
(47, 'Approved MOP', 16),
(48, 'Approved Service Order', 16),
(49, 'Approved RAAWA', 17),
(50, 'Approved MOP', 17),
(51, 'Approved Service Order', 17),
(52, 'Zero punchlist on equipment installation checklist', 18),
(53, 'Passed megger testing', 18),
(54, 'Approved MOP', 18),
(55, 'Approved Service Order', 18),
(56, 'Approved RAAWA', 19),
(57, 'Approved MOP', 19),
(58, 'Fault Ticket/Work Order', 19),
(59, 'Approved RAAWA', 20),
(60, 'Network Diagram', 20),
(61, 'Approved Pre-TSSR from CFEI', 21),
(62, 'Approved RAAWA', 21),
(63, 'Approved RAAWA ( if on-site activity)', 22),
(64, 'Approved MOP', 22),
(65, 'Approved Service Order', 22),
(66, 'Spare card', 22),
(67, 'Approved RAAWA ( if on-site activity)', 23),
(68, 'Approved MOP', 23),
(69, 'Approved Service Order', 23),
(70, 'Spare card', 23),
(71, 'Approved RAAWA', 24),
(72, 'Approved MOP', 24),
(73, 'Secured CFEI approval', 24),
(74, 'HEO concurrence and validation on Rectifier System/Inverter Sytem loadings', 24),
(75, 'Approved Service Order.', 24),
(76, 'Approved RAAWA ( if on-site activity)', 25),
(77, 'Approved MOP', 25),
(78, 'Approved Service Order', 25),
(79, 'Spare card', 25);

-- --------------------------------------------------------

--
-- Table structure for table `calendar`
--

CREATE TABLE `calendar` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `color` varchar(7) NOT NULL DEFAULT '#3a87ad',
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `calendar`
--

INSERT INTO `calendar` (`id`, `title`, `description`, `color`, `date`) VALUES
(11, 'Christmas Holiday ! ', 'I have a holiday in this day :)', '#e00e2b', '2016-07-06 09:24:00'),
(12, 'Meeting', 'Have a meeitng', '#4c55f2', '2016-07-14 09:25:00'),
(13, 'Urgent work', 'Have to Call Boominathan', '#6bce45', '2016-07-25 10:26:00'),
(14, 'Rest', 'Take rest ', '#c529d5', '2015-12-24 11:28:00'),
(15, 'Christmas Holiday ! ', 'I have a holiday in this day :)', '#e00e2b', '2016-07-06 09:24:00'),
(16, 'Meeting', 'Have a meeitng', '#4c55f2', '2016-07-14 09:25:00'),
(17, 'Urgent work', 'Have to Call Boominathan', '#6bce45', '2016-07-25 10:26:00'),
(18, 'Rest', 'Take rest ', '#c529d5', '2015-12-24 11:28:00'),
(19, 'Sunday', 'Testing event', '#3a87ad', '2016-07-30 00:00:00'),
(20, 'Sunday 2', 'Testing 2', '#3a87ad', '2016-08-02 00:00:00'),
(21, 'Sunday', 'Testing event3', '#3a87ad', '2016-07-30 00:00:00'),
(22, 'Sunday 2', 'Testing4', '#3a87ad', '2016-08-02 00:00:00'),
(23, 'Sunday', 'Testing event5', '#3a87ad', '2016-07-30 00:00:00'),
(24, 'Sunday 2', 'Testing6', '#3a87ad', '2016-08-02 00:00:00'),
(25, 'Sunday', 'Testing event7', '#3a87ad', '2016-07-30 00:00:00'),
(26, 'Sunday 2', 'Testing8', '#3a87ad', '2016-08-02 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `ci_sessions`
--

CREATE TABLE `ci_sessions` (
  `id` varchar(40) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `timestamp` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `data` blob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ci_sessions`
--

INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES
('0250e90a59e401483435690c9d30ca8918be48d3', '::1', 1469994728, 0x5f5f63695f6c6173745f726567656e65726174657c693a313436393939343530313b),
('3e9323fefd59b1a8b25f69d7ed595a5be40e1c41', '::1', 1469996743, 0x5f5f63695f6c6173745f726567656e65726174657c693a313436393939363539393b),
('48799a7e91b5f656c0f8b8b97f4a6576f681c905', '::1', 1470002219, 0x5f5f63695f6c6173745f726567656e65726174657c693a313437303030323231393b),
('58ba1db27b12426a834e4af8a3704f53ee2db4db', '::1', 1469998098, 0x5f5f63695f6c6173745f726567656e65726174657c693a313436393939373833343b),
('595f4fb50fc5dcd423b9c23c7e6d5148d8fd4ce7', '::1', 1469994906, 0x5f5f63695f6c6173745f726567656e65726174657c693a313436393939343833343b),
('6339849570634f3b4ae189a89273fe2bbb963889', '::1', 1468779265, 0x5f5f63695f6c6173745f726567656e65726174657c693a313436383737393034303b),
('65b75132db988cc2f04be2312948f5c598cf9b75', '::1', 1470006667, 0x5f5f63695f6c6173745f726567656e65726174657c693a313437303030363636373b),
('8dbc98a34fe4858c37f15b24aca153d52c4c18a9', '::1', 1470001753, 0x5f5f63695f6c6173745f726567656e65726174657c693a313437303030313735333b),
('949cf6c523bc9211b56180375e849c8db8c67b84', '::1', 1469999946, 0x5f5f63695f6c6173745f726567656e65726174657c693a313436393939393739313b),
('a6ee204bc0487b36bd8b2d60c787fbafddd1b94c', '::1', 1470009022, 0x5f5f63695f6c6173745f726567656e65726174657c693a313437303030393032323b),
('af60f0cd8d964e749ad3583c237f5bddd00827f1', '::1', 1470000210, 0x5f5f63695f6c6173745f726567656e65726174657c693a313437303030303132313b),
('b2218320fc4fe286d3086faf629137cec8bdc243', '::1', 1470000726, 0x5f5f63695f6c6173745f726567656e65726174657c693a313437303030303436343b),
('b512d59dfc8aa831f7ff6280c9149a07cdbdd66b', '::1', 1469998768, 0x5f5f63695f6c6173745f726567656e65726174657c693a313436393939383632343b),
('bcb3d09c729e0b36b231877ca6d2369693ecba9a', '::1', 1468783454, 0x5f5f63695f6c6173745f726567656e65726174657c693a313436383738333435333b),
('d73b8eb8deb313b3d64ff4bfe802dcdbe567575f', '::1', 1469997574, 0x5f5f63695f6c6173745f726567656e65726174657c693a313436393939373331383b757365725f69647c693a313b757365726e616d657c733a343a2272696331223b6c6f676765645f696e7c623a313b69735f636f6e6669726d65647c623a313b69735f61646d696e7c623a303b),
('df26e0a019d200e6a361d0fbf810ec3d6062b958', '::1', 1469995716, 0x5f5f63695f6c6173745f726567656e65726174657c693a313436393939353534373b),
('e16cc3db5003bd6136ab83a401fb7ded1eb5d13c', '::1', 1470000847, 0x5f5f63695f6c6173745f726567656e65726174657c693a313437303030303834373b),
('e226d1abc2dde7d1085cac2316f2465463e32d28', '::1', 1468205799, 0x5f5f63695f6c6173745f726567656e65726174657c693a313436383230353739393b),
('ee5aa82e8bfc696be632f14e77eae2cc5a0fddb9', '::1', 1470004687, 0x5f5f63695f6c6173745f726567656e65726174657c693a313437303030343434343b),
('f86bdd72b3e85f32c3b0e378c7b2ce022087f6db', '::1', 1470001271, 0x5f5f63695f6c6173745f726567656e65726174657c693a313437303030313237313b);

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

-- --------------------------------------------------------

--
-- Table structure for table `requests`
--

CREATE TABLE `requests` (
  `request_id` int(11) NOT NULL,
  `activity_type` varchar(255) DEFAULT NULL,
  `activity_type_requirement_checklist` varchar(255) NOT NULL,
  `site_name` varchar(255) DEFAULT NULL,
  `criticality` varchar(255) DEFAULT NULL,
  `activity_desc` varchar(255) DEFAULT NULL,
  `project_name` varchar(255) DEFAULT NULL,
  `employee_id` varchar(255) NOT NULL,
  `employee_name` varchar(255) NOT NULL,
  `department` varchar(255) NOT NULL,
  `discipline` varchar(255) DEFAULT NULL,
  `ne_involved` varchar(255) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `start_time` time DEFAULT NULL,
  `end_time` time DEFAULT NULL,
  `activity_date` date DEFAULT NULL,
  `gt_project_prop` varchar(255) DEFAULT NULL,
  `contact_num_prop` varchar(255) DEFAULT NULL,
  `gt_rep` varchar(255) DEFAULT NULL,
  `contact_num_rep` varchar(255) DEFAULT NULL,
  `vendor_rep` varchar(255) DEFAULT NULL,
  `contact_num_vendor` varchar(255) DEFAULT NULL,
  `reference_docs` varchar(255) DEFAULT NULL,
  `so_ref_number` varchar(255) DEFAULT NULL,
  `trs_config_number` varchar(255) DEFAULT NULL,
  `_status` int(4) DEFAULT NULL,
  `request_status` varchar(255) NOT NULL DEFAULT 'For Approval',
  `activity_status` varchar(255) NOT NULL,
  `remarks` text,
  `reason_for_short_notice` text,
  `approve_by` int(11) NOT NULL,
  `reject_by` int(11) NOT NULL,
  `approval_notes` text NOT NULL,
  `is_email_sent` int(1) NOT NULL DEFAULT '0',
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
  `deleted_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `requests`
--

INSERT INTO `requests` (`request_id`, `activity_type`, `activity_type_requirement_checklist`, `site_name`, `criticality`, `activity_desc`, `project_name`, `employee_id`, `employee_name`, `department`, `discipline`, `ne_involved`, `date`, `start_time`, `end_time`, `activity_date`, `gt_project_prop`, `contact_num_prop`, `gt_rep`, `contact_num_rep`, `vendor_rep`, `contact_num_vendor`, `reference_docs`, `so_ref_number`, `trs_config_number`, `_status`, `request_status`, `activity_status`, `remarks`, `reason_for_short_notice`, `approve_by`, `reject_by`, `approval_notes`, `is_email_sent`, `is_deleted`, `deleted_by`) VALUES
(2, 'Site Survey', '', 'BACOOR', 'Critical', 'Test description2', 'test project', '2', '', '', 'Wireless Core', 'test ne involved', '2016-07-06', '02:24:15', '05:24:15', '0000-11-30', 'test gt proj proponent', '09999999999', 'test gt representative', '09999999999', 'vendor representative', '09999999929', 'FIO', 'SOREFNUME002', 'test trs num', 0, 'For Approval', 'For Approval', 'for testing', NULL, 3, 0, '', 1, 0, 3),
(3, 'Site Survey', '', 'SANJUAN', 'Critical', 'Test description3', 'test project', '23', '', '', 'Wireless Core', 'test ne involved', '2016-07-06', '03:24:15', '04:24:15', '0000-08-30', 'test gt proj proponent', '09999999999', 'test gt representative', '09999999999', 'vendor representative', '09999999939', 'FIO', 'SOREFNUME003', 'test trs num', 3, 'Cancelled', 'Completed', 'for testing', NULL, 0, 0, '', 0, 0, NULL),
(4, 'Site Survey', '', 'VALERO', 'Critical', 'Test description4', 'test project', '23', '', '', 'Wireless Core', 'test ne involved', '2016-07-06', '04:24:15', '05:24:15', '0000-08-30', 'test gt proj proponent', '09999999999', 'test gt representative', '09999999999', 'vendor representative', '09999999949', 'FIO', 'SOREFNUME004', 'test trs num', 3, 'For Approval', '', 'for testing', NULL, 0, 0, '', 0, 0, NULL),
(5, 'Site Survey', '', 'SANJUAN', 'Critical', 'Test description5', 'test project', '23', '', '', 'Wireless Core', 'test ne involved', '2016-07-06', '05:24:15', '04:24:16', '2016-10-18', 'test gt proj proponent', '09999999999', 'test gt representative', '09999999999', 'vendor representative', '09999999959', 'FIO', 'SOREFNUME005', 'test trs num', 3, 'For Approval', '', 'for testing', NULL, 0, 0, '', 0, 0, NULL),
(6, 'Site Survey', '61,62', 'CARMONA', 'Critical', 'Test description6', 'test project', '23', '', '', 'Wireless Core', 'test ne involved', '2016-07-06', '06:24:00', '17:24:00', '2016-10-18', 'test gt proj proponent', '09999999999', 'test gt representative', '09999999999', 'vendor representative', '09999999969', 'FIO', 'SOREFNUME006', 'test trs num', 3, 'For Approval', '', 'for testing', '', 0, 0, '', 0, 0, NULL),
(7, 'Site Survey', '', 'SANJUAN', 'Critical', 'Test description7', 'test project', '23', '', '', 'Wireless Core', 'test ne involved', '2016-07-06', '07:24:15', '17:24:15', '2016-10-18', 'test gt proj proponent', '09999999999', 'test gt representative', '09999999999', 'vendor representative', '09999999979', 'FIO', 'SOREFNUME007', 'test trs num', 3, 'For Approval', '', 'for testing', NULL, 0, 0, '', 0, 0, NULL),
(8, 'Site Survey', '', 'VALERO', 'Critical', 'Test description8', 'test project', '23', '', '', 'Wireless Core', 'test ne involved', '2016-07-06', '08:24:15', '17:24:15', '2016-10-18', 'test gt proj proponent', '09999999999', 'test gt representative', '09999999999', 'vendor representative', '09999999989', 'FIO', 'SOREFNUME008', 'test trs num', 3, 'For Approval', '', 'for testing', NULL, 0, 0, '', 0, 0, NULL),
(9, 'Site Survey', '', 'BACOOR', 'Critical', 'Test description9', 'test project', '23', '', '', 'Wireless Core', 'test ne involved', '2016-07-06', '09:24:15', '17:24:15', '2016-10-18', 'test gt proj proponent', '09999999999', 'test gt representative', '09999999999', 'vendor representative', '09999999909', 'FIO', 'SOREFNUME009', 'test trs num', 3, 'For Approval', 'For Approval', 'for testing', NULL, 0, 0, '', 0, 0, 3),
(10, 'Site Survey', '', 'CARMONA', 'Critical', 'Test description10', 'test project', '23', '', '', 'Wireless Core', 'test ne involved', '2016-07-06', '10:24:15', '17:24:15', '2016-10-18', 'test gt proj proponent', '09999999999', 'test gt representative', '09999999999', 'vendor representative', '09999999199', 'FIO', 'SOREFNUME010', 'test trs num', 3, 'For Approval', '', 'for testing', NULL, 0, 0, '', 0, 0, NULL),
(11, 'Site Survey', '', 'SANJUAN', 'Critical', 'Test description11', 'test project', '23', '', '', 'Wireless Core', 'test ne involved', '2016-07-06', '11:24:15', '17:24:15', '2016-10-18', 'test gt proj proponent', '09999999999', 'test gt representative', '09999999999', 'vendor representative', '09999999299', 'FIO', 'SOREFNUME011', 'test trs num', 3, 'For Approval', '', 'for testing', NULL, 0, 0, '', 0, 0, NULL),
(12, 'Site Survey', '61', 'VALERO', 'Critical', 'Test description12', 'test project', '23', '', '', 'Wireless Core', 'test ne involved', '2016-07-06', '12:24:00', '17:24:00', '2016-10-18', 'test gt proj proponent', '09999999999', 'test gt representative', '09999999999', 'vendor representative', '09999999399', 'FIO', 'SOREFNUME012', 'test trs num', 0, 'For Approval', '', 'for testing', '', 23, 0, '', 1, 0, NULL),
(13, 'Site Survey', '', 'BACOOR', 'Critical', 'Test description13', 'test project', '12', '', '', 'Wireless Core', 'test ne involved', '2016-07-06', '13:24:15', '17:24:15', '2016-10-18', 'test gt proj proponent', '09999999999', 'test gt representative', '09999999999', 'vendor representative', '09999999499', 'FIO', 'SOREFNUME013', 'test trs num', 1, 'Accepted', 'For Approval', 'for testing', NULL, 3, 0, 'TESTING ACCEPT\r\n', 1, 0, 3),
(14, 'Site Survey', '', 'CARMONA', 'Critical', 'Test description14', 'test project', '13', '', '', 'Wireless Core', 'test ne involved', '2016-07-06', '14:24:15', '17:24:15', '2016-10-18', 'test gt proj proponent', '09999999999', 'test gt representative', '09999999999', 'vendor representative', '09999999599', 'FIO', 'SOREFNUME014', 'test trs num', NULL, 'For Approval', '', 'for testing', NULL, 0, 0, '', 0, 0, NULL),
(15, 'Site Survey', '', 'SANJUAN', 'Critical', 'Test description15', 'test project', '14', '', '', 'Wireless Core', 'test ne involved', '2016-07-06', '15:24:15', '17:24:15', '2016-10-18', 'test gt proj proponent', '09999999999', 'test gt representative', '09999999999', 'vendor representative', '09999999699', 'FIO', 'SOREFNUME015', 'test trs num', NULL, 'For Approval', '', 'for testing', NULL, 0, 0, '', 0, 0, NULL),
(16, 'Site Survey', '', 'VALERO', 'Critical', 'Test description16', 'test project', '15', '', '', 'Wireless Core', 'test ne involved', '2016-07-06', '17:24:15', '17:24:15', '2016-10-18', 'test gt proj proponent', '09999999999', 'test gt representative', '09999999999', 'vendor representative', '09999999799', 'FIO', 'SOREFNUME016', 'test trs num', NULL, 'For Approval', '', 'for testing', NULL, 0, 0, '', 0, 0, NULL),
(17, 'Site Survey', '', 'BACOOR', 'Critical', 'Test description17', 'test project', '16', '', '', 'Wireless Core', 'test ne involved', '2016-07-06', '18:24:15', '17:24:15', '2016-10-18', 'test gt proj proponent', '09999999999', 'test gt representative', '09999999999', 'vendor representative', '09999999299', 'FIO', 'SOREFNUME017', 'test trs num', 3, 'Cancelled', 'For Approval', 'for testing', NULL, 3, 0, '', 1, 0, 3),
(18, 'Site Survey', '', 'CARMONA', 'Critical', 'Test description18', 'test project', '17', '', '', 'Wireless Core', 'test ne involved', '2016-07-06', '19:24:15', '17:24:15', '2016-10-18', 'test gt proj proponent', '09999999999', 'test gt representative', '09999999999', 'vendor representative', '09999999399', 'FIO', 'SOREFNUME018', 'test trs num', NULL, 'For Approval', '', 'for testing', NULL, 0, 0, '', 0, 0, NULL),
(19, 'Site Survey', '', 'SANJUAN', 'Critical', 'Test description19', 'test project', '23', '', '', 'Wireless Core', 'test ne involved', '2016-07-06', '20:24:15', '17:24:15', '2016-10-18', 'test gt proj proponent', '09999999999', 'test gt representative', '09999999999', 'vendor representative', '09999999499', 'FIO', 'SOREFNUME019', 'test trs num', NULL, 'For Approval', '', 'for testing', NULL, 0, 0, '', 0, 0, NULL),
(20, 'Site Survey', '', 'VALERO', 'Critical', 'Test description20', 'test project', '19', '', '', 'Wireless Core', 'test ne involved', '2016-07-06', '21:24:15', '17:24:15', '2016-10-18', 'test gt proj proponent', '09999999999', 'test gt representative', '09999999999', 'vendor representative', '09999999599', 'FIO', 'SOREFNUME020', 'test trs num', NULL, 'For Approval', '', 'for testing', NULL, 0, 0, '', 0, 0, NULL),
(21, 'Site Survey', '', 'BACOOR', 'Critical', 'Test description21', 'test project', '20', '', '', 'Wireless Core', 'test ne involved', '2016-07-06', '22:24:15', '17:24:15', '2016-10-18', 'test gt proj proponent', '09999999999', 'test gt representative', '09999999999', 'vendor representative', '09999999699', 'FIO', 'SOREFNUME021', 'test trs num', 3, 'Cancelled', 'For Approval', 'for testing', NULL, 3, 0, '', 1, 0, 3),
(22, 'Site Survey', '', 'CARMONA', 'Critical', 'Test description22', 'test project', '21', 'wer', 'werw', 'Wireless Core', 'test ne involved', '2016-07-30', '06:14:00', '07:14:00', '2016-07-31', 'wer', 'wer', 'wer', 'ewr', 'wer', 'wer', 'FIO', 'wer', 'wer', 3, 'Cancelled', 'Completed', 'update\r\n\r\n', NULL, 0, 0, '', 0, 0, NULL),
(23, '', '', 'SANJUAN', '', '', '', '23', '', '', '', '', '0000-11-30', '00:00:00', '00:00:00', '0000-11-30', '', '', '', '', '', '', '', '', '', 3, 'Cancelled', 'Completed', 'update', NULL, 0, 0, '', 0, 0, NULL),
(24, 'Site Survey', '', 'VALERO', 'Critical', 'test', 'test', '5', 'test', 'test', 'Wireless Core', 'test', '2016-07-05', '03:34:00', '04:56:00', '2016-07-13', 'test', '234234', 'test', '12312312', 'test', '123123', 'Network Diagram', '123123f3q2', 'weq23123123', 3, 'Cancelled', '', 'TEESTING1', NULL, 0, 0, '', 0, 0, NULL),
(27, NULL, '', 'CARMONA', 'Major', 'testset', '', '22', '', '', '', '', '0000-00-00', '00:00:00', '00:00:00', '2016-10-18', '', '', '', '', '', '', 'Network Diagram', '', '', 3, 'Cancelled', 'Partially Completed', 'asdad tresteiub', NULL, 0, 0, '', 0, 0, NULL),
(28, 'Patching', '', 'SANJUAN', 'Critical', '', '', '21', '', '', 'Wireless Access', '', '0000-08-23', '00:00:00', '00:00:00', '0000-08-23', '', '', '', '', '', '', 'FIO', '', '', 3, 'Cancelled', 'Completed', 'asdasd', NULL, 0, 0, '', 0, 0, NULL),
(29, 'Integration', '', 'VALERO', '', 'asd', '', '20', '', '', '', '', '0000-00-00', '00:00:00', '00:00:00', '2016-10-18', '', '', '', '', '', '', '', '', 'asd', 3, 'Cancelled', 'Partially Completed', 'as', NULL, 0, 0, '', 0, 0, NULL),
(32, 'Integration', '', 'CARMONA', 'Critical', '', '', '18', '', 'asd', 'Etc.', '', '0000-00-00', '00:00:00', '00:00:00', '2016-10-18', '', '', '', '', '', '', 'Network Diagram', '', '', 3, 'Cancelled', 'Deferred', '', NULL, 0, 0, '', 0, 0, NULL),
(33, 'Site Survey', '', 'SANJUAN', 'Major', 'asd', 'asd', '17', '', '', 'Wireless Core', '', '0000-11-30', '00:00:00', '00:00:00', '2016-08-24', '', '', '', '', '', '', 'FIO', '', '', 3, 'Cancelled', 'Completed', 'del', NULL, 0, 0, '', 0, 0, NULL),
(34, 'Integration', '', 'VALERO', 'Critical', 'asd', 'asd', '16', 'asd', 'asd', 'Etc.', 'asd', '1900-12-30', '04:31:00', '04:31:00', '2016-08-26', 'asd', 'asd', 'asd', 'asd', 'asd', 'asd', 'Etc.', 'asd', 'asd', 3, 'Cancelled', 'Deferred', 'asdas', NULL, 0, 0, '', 0, 0, NULL),
(38, '', '', 'SANJUAN', '', '', '', '4', '', '', '', '', '0000-11-30', '00:00:00', '00:00:00', '0000-11-30', '', '', '', '', '', '', '', '', '', 3, 'Cancelled', 'Completed', 'asd', NULL, 0, 0, '', 0, 0, NULL),
(39, 'Site Survey', '', 'VALERO', 'Major', '', '', '51', 'TEST', '', '', '', '2016-08-19', '07:55:00', '07:55:00', '2016-08-26', '', '', '', '', '', '', 'FIO', '', '', 3, 'Cancelled', 'Completed', 'lkjlkjlk', NULL, 0, 0, '', 0, 0, NULL),
(40, '', '', 'BACOOR', '', '', '', '23', 'user19', '', '', '', '2016-08-12', '11:31:00', '11:31:00', '2016-08-25', '', '', '', '', '', '', '', '', '', 0, 'For Approval', 'For Approval', 'TEST reject 40....[]...', NULL, 23, 0, 'TEST EMAIL REJECT 40--- Accepted', 1, 1, 23),
(41, 'Integration', '', 'VALERO', 'Major', '', '', '4', '', '', 'Wireline Core', '', '2016-08-24', '00:00:00', '00:00:00', '0000-08-24', '', '', '', '', '', '', 'Network Diagram', '', '', 3, 'Cancelled', 'Partially Completed', '', NULL, 0, 0, '', 0, 0, NULL),
(42, '', '', 'VALERO', '', '', '', '49', 'user19', '', '', '', '0000-00-00', '00:00:00', '00:00:00', '2016-10-18', '', '', '', '', '', '', '', '', '', 3, 'Cancelled', '', '', NULL, 0, 0, '', 0, 0, NULL),
(44, '', '', 'SANJUAN', '', '', '', '23', '', '', '', '', '2016-08-24', '00:00:00', '12:00:00', '2016-10-18', '', '', '', '', '', '', '', '', '', 3, 'Cancelled', '', '', NULL, 0, 0, '', 0, 0, NULL),
(45, '', '', 'VALERO', '', '', '', '23', 'user19', '', '', '', '2016-08-24', '00:00:00', '00:00:00', '2016-10-18', '', '', '', '', '', '', '', '', '', 3, 'Cancelled', '', '"asdasdaskjdhaskdjhakjsd"', NULL, 0, 0, '', 0, 0, NULL),
(47, '', '', 'CARMONA', '', '', '', '4', '', '', '', '', '2016-08-30', '00:00:00', '00:00:00', '0000-09-05', '', '', '', '', '', '', '', '', '', 3, 'Cancelled', '', '', NULL, 0, 0, '', 0, 0, NULL),
(48, 'Site Survey', '', 'CARMONA', 'Critical', 'TEST', 'TEST Project', '46', 'Test Name', 'TEst Dept', 'Wireline Core', 'Test NE', '2016-08-31', '10:06:00', '10:06:00', '2016-08-18', 'Test GT', '0912031923', 'Test GT', '09123019244', 'Test Vendor', '091231238', 'FIO', '2109381', 'TEST TRS', 0, 'For Approval', 'Deferred', 'TESTING 08/31/2016', NULL, 0, 0, '', 0, 0, NULL),
(49, 'Site Survey', '', 'CARMONA', 'Major', 'sa -', 'sd-', '4', 'user', 'sd-', 'Wireless Core', 'ad-', '2016-08-31', '01:48:00', '01:48:00', '2016-08-25', 'ad-', 'lkl-', 'asdlkj-', 'lkj-', 'lkj-', 'saple -', 'MOP', 'lkj -', 'lkj -', 0, 'For Approval', 'Partially Completed', 'asd', NULL, 0, 0, '', 0, 0, NULL),
(50, '', '', '', '', '', '', '23', 'user19', '', '', '', '2016-08-31', '00:00:00', '00:00:00', '2016-10-18', '', '', '', '', '', '', '', '', '', 0, 'For Approval', '', '', NULL, 23, 0, '', 1, 1, 23),
(52, '', '', '', '', '', '', '23', 'user19', '', '', '', '2016-08-31', '00:00:00', '00:00:00', '2016-10-18', '', '', '', '', '', '', '', '', '', NULL, 'For Approval', '', '', NULL, 23, 0, '', 1, 1, 23),
(80, NULL, '', 'CARMONA', 'Minor', 'asd', 'sd', '23', 'user19', 'qwe', 'Wireline Core', 'asdlkj', '2016-09-01', '00:00:00', '12:00:00', '2016-09-07', 'asd', 'lj', 'lk', 'l', 'po19293', 'lkj', 'Network Diagram', 'adakj', 'lkj', 3, 'Cancelled', 'Completed', 'aklsdjalksd\r\n----to reject', NULL, 23, 0, '', 1, 0, NULL),
(81, 'Patching', '46', 'BACOOR', 'Major', 'TESTING DESCRIPTION', 'TESTING PROJECT', '23', 'user19', 'TESTING DEPT', 'Wireless Access', 'TESTING', '2016-09-02', '12:00:00', '12:00:00', '2016-09-09', 'TESTING GT', '09812093810923', 'test', '091823091823', 'Testing Vendor', '09823091283', 'FIO', 'TEST SO#', 'TESTING TRS', 0, 'For Approval', '', 'BACOOR TEST ACCEPT TEST REJECT 2\\n alksdjalksjdlkas', '', 23, 0, '', 1, 0, 3),
(84, 'Integration', '', 'CARMONA', 'Minor', 'ALSKJDLKAS', 'alksdjalksd', '4', 'user', 'lksjdla', 'Wireless Core', 'asd', '2016-09-05', '04:02:00', '04:02:00', '2016-09-08', 'asd', 'ad', 'sd', 'sda', 'df', 'dsf', 'MOP', 'sdf', 'dfs', NULL, 'For Approval', 'Partially Completed', 'Create Testin EMail', NULL, 0, 0, '', 0, 0, NULL),
(85, 'Integration', '', 'CARMONA', 'Minor', 'ALSKJDLKAS', 'alksdjalksd', '4', 'user', 'lksjdla', 'Wireless Core', 'asd', '2016-09-05', '04:02:00', '04:02:00', '2016-09-08', 'asd', 'ad', 'sd', 'sda', 'df', 'dsf', 'MOP', 'sdf', 'dfs', NULL, 'For Approval', 'Partially Completed', 'Create Testin EMail', NULL, 0, 0, '', 0, 0, NULL),
(86, 'Integration', '', 'CARMONA', '', '', '', '4', 'user', '', '', '', '2016-09-05', '00:00:00', '00:00:00', '2016-10-18', '', '', '', '', '', '', '', '', '', NULL, 'For Approval', '', '', NULL, 0, 0, '', 0, 0, NULL),
(88, NULL, '', 'VALERO', 'Major', '', '', '4', 'user', '', '', '', '2016-09-05', '00:00:00', '00:00:00', '2016-09-21', '', '', '', '', '', '', 'SLD', '', '', NULL, 'For Approval', 'Deferred', 'ASLKdjalksd', NULL, 0, 0, '', 0, 0, NULL),
(89, '', '', 'VALERO', '', '', '', '4', 'user', '', '', '', '2016-09-05', '00:00:00', '00:00:00', '2016-10-18', '', '', '', '', '', '', '', '', '', NULL, 'For Approval', '', '', NULL, 0, 0, '', 0, 0, NULL),
(90, 'Delivery and Installation', '', 'VALERO', '', '', '', '4', 'user', '', '', '', '2016-09-05', '00:00:00', '00:00:00', '2016-10-18', '', '', '', '', '', '', '', '', '', NULL, 'For Approval', '', '', NULL, 0, 0, '', 0, 0, NULL),
(91, '', '', 'CARMONA', '', '', '', '4', 'user', '', '', '', '2016-09-05', '00:00:00', '00:00:00', '2016-10-18', '', '', '', '', '', '', '', '', '', NULL, 'For Approval', '', '', NULL, 0, 0, '', 0, 0, NULL),
(99, '', '', 'VALERO', '', '', '', '4', 'user', '', '', '', '2016-09-05', '00:00:00', '00:00:00', '2016-10-18', '', '', '', '', '', '', '', '', '', NULL, 'For Approval', '', '', NULL, 0, 0, '', 0, 0, NULL),
(100, '', '', 'BACOOR', '', '', '', '4', 'user', '', '', 'sdf', '2016-09-05', '04:43:00', '04:43:00', '2016-10-18', '', '', '', 'lkq', 'jlkj', 'lkj', '', 'lkj', '', 0, 'For Approval', 'For Approval', '''''''', NULL, 3, 0, '', 1, 0, 3),
(102, '', '', 'VALERO', '', '', '', '4', 'user', '', '', '', '2016-09-05', '04:45:00', '04:45:00', '2016-10-18', '', '', '', '', '', '', '', '', '', NULL, 'For Approval', '', '', NULL, 0, 0, '', 0, 0, NULL),
(105, '', '', 'CARMONA', 'Minor', '', '', '4', 'user', '', '', '', '2016-09-05', '04:54:00', '00:00:00', '2016-10-18', '', '', '', '', '', '', '', '', '', NULL, 'For Approval', '', '', NULL, 0, 0, '', 0, 0, NULL),
(106, '', '', '', '', '', '', '4', 'user', '', '', '', '2016-09-05', '00:00:00', '00:00:00', '2016-10-18', '', '', '', '', '', '', '', '', '', NULL, 'For Approval', '', '', NULL, 0, 0, '', 0, 0, NULL),
(107, 'Integration', '', 'CARMONA', '', '', '', '4', 'user', '', '', '', '2016-09-05', '00:00:00', '00:00:00', '0000-09-05', '', '', '', '', '', '', '', '', '', NULL, 'For Approval', '', '', NULL, 0, 0, '', 0, 0, NULL),
(109, '', '', 'CARMONA', '', '', '', '4', 'user', '', '', '', '2016-09-05', '00:00:00', '00:00:00', '2016-10-18', '', '', '', '', '', '', '', '', '', NULL, 'For Approval', '', '', NULL, 0, 0, '', 0, 0, NULL),
(111, '', '', 'CARMONA', '', '', '', '4', 'user', '', '', '', '2016-09-05', '00:00:00', '00:00:00', '2016-10-18', '', '', '', '', '', '', '', '', '', NULL, 'For Approval', '', '', NULL, 0, 0, '', 0, 0, NULL),
(112, '', '', 'VALERO', '', '', '', '4', 'user', '', '', '', '2016-09-05', '00:00:00', '00:00:00', '2016-10-18', '', '', '', '', '', '', '', '', '', 3, 'Cancelled', '', '', NULL, 0, 0, 'TEST ACCPET 7\r\n', 0, 0, NULL),
(113, '', '', 'BACOOR', '', '', '', '4', 'user', '', '', '', '2016-09-05', '00:00:00', '00:00:00', '2016-10-18', '', '', '', '', '', '', '', '', '', 3, 'Cancelled', 'For Approval', 'TEST REJECT 113', NULL, 3, 0, 'test ACCEPT', 1, 0, 3),
(114, '', '', 'SANJUAN', '', '', '', '4', 'user', '', '', '', '2016-09-05', '00:00:00', '00:00:00', '2016-10-18', '', '', '', '', '', '', '', '', '', NULL, 'For Approval', '', '', NULL, 0, 0, '', 0, 0, NULL),
(122, 'Integration', '', 'BACOOR', 'Major', '', '', '23', 'user19', '', 'Wireline Access', '', '2016-09-06', '10:32:00', '10:32:00', '2016-10-18', '', '', '', '', '', '', '', '', '', 0, 'For Approval', 'For Approval', 'Accept 122', NULL, 3, 0, '', 1, 0, 3),
(124, '', '', 'VALERO', 'Major', 'TEST Description', 'Project Test', '23', 'user19', 'Dept Test', 'Wireline Core', 'TEST NE', '2016-09-06', '11:23:00', '11:23:00', '2016-09-06', '', '', '', '', '', '', '', '', '', 3, 'Cancelled', '', '', '', 23, 0, '', 1, 0, NULL),
(128, 'Patching', '', 'VALERO', 'Critical', 'TESTING Description', 'Testing Project Name', '23', 'user19', 'Testing Departmnet', 'Wireless Core', 'Test NE', '2016-09-06', '11:50:00', '11:48:00', '2016-09-15', 'TEST GT PROJECT', '091823123123', 'TEst GT', '0982309182', 'TEST Vendor', '09812309182', 'Network Diagram', '879812', '9871', 3, 'Cancelled', 'Deferred', 'TEST TABLE ACCEPT 3', '', 23, 0, '', 1, 0, NULL),
(133, 'Integration', '', 'CARMONA', 'Major', 'TEST with Transmission on Discipline', 'TEST', '23', 'user19', 'DEPT', 'Transmission', 'NE', '2016-09-06', '05:34:00', '05:34:00', '0000-09-06', '', '', '', '', '', '', 'Network Diagram', '', '', NULL, 'For Approval', 'Deferred', 'TEST Remarks', NULL, 0, 0, '', 0, 1, 23),
(144, '', '', 'SANJUAN', '', 'TEST subject', '', '23', 'user19', '', '', '', '2016-09-08', '10:58:00', '10:58:00', '0000-09-08', '', '', '', '', '', '', '', '', '', 3, 'Cancelled', '', 'TEST REJECT 144', NULL, 0, 0, 'TEST APPROVAL REMARKS--', 0, 1, 23),
(158, 'Acceptanve(SAT, HAT, iSAT, UAT)', '', '', 'Critical', '', '', '23', 'user19', '', '', '', '2016-09-12', '09:16:00', '21:16:00', '2016-09-15', 'test GT', '', '', '', '', '', '', '', '', NULL, 'For Approval', '', '', 'TESTING\r\n\r\n--', 23, 0, '', 1, 1, 23),
(159, 'Facilities audit', '', 'BACOOR', '', '', '', '23', 'user19', '', '', '', '2016-09-12', '01:00:00', '01:00:00', '0000-09-19', '', '', '', '', '', '', '', '', '', 0, 'For Approval', 'For Approval', '', '', 3, 0, '', 1, 0, 3),
(160, '', '', 'CARMONA', '', '', '', '23', 'user19', '', '', '', '2016-09-13', '01:00:00', '01:00:00', '0000-09-19', '', '', '', '', '', '', '', '', '', NULL, 'For Approval', '', '', '', 23, 0, '', 0, 0, NULL),
(161, 'Delivery', '', 'VALERO', 'Critical', 'TEsting', '', '23', 'user19', '', '', '', '2016-09-16', '10:07:00', '10:07:00', '0000-09-16', '', '', '', '', '', '', '', '', '', NULL, 'For Approval', '', '', '', 23, 0, '', 1, 1, 23),
(162, '', '', 'BACOOR', '', '', '', '23', 'user19', '', '', '', '2016-09-19', '01:00:00', '01:00:00', '2016-10-18', '', '', '', '', '', '', '', '', '', 0, 'For Approval', 'For Approval', '', '', 3, 0, '', 1, 0, 3),
(163, 'Board acceptance', '', 'BACOOR', 'Major', 'TEST BACOOR', '', '23', 'user19', '', 'Wireline Core', '', '2016-09-19', '09:52:00', '21:50:00', '2016-09-02', '', '', '', '', '', '', '', '', '', 0, 'For Approval', 'For Approval', 'TEST BACOOR', '', 3, 0, '', 1, 0, 3),
(164, 'Board acceptance', '', 'BACOOR', 'Major', '', '', '23', 'user19', '', '', '', '2016-09-19', '10:09:00', '22:09:00', '2016-10-18', '', '', '', '', '', '', '', '', '', 1, 'Accepted', 'For Approval', '', '', 3, 0, '', 1, 0, 3),
(165, 'Facilities audit', '', 'VALERO', 'Major', 'TEST to BACOOR', '', '23', 'user19', '', '', '', '2016-09-19', '10:10:00', '22:10:00', '2016-09-24', '', '', '', '', '', '', '', '', '', NULL, 'For Approval', '', 'TEST BACOOR', '', 23, 0, '', 1, 1, 23),
(166, 'Board acceptance', '', 'BACOOR', 'Minor', 'TEST', 'sd', '23', 'user19', '', 'Wireless Core', '', '2016-09-19', '10:31:00', '22:31:00', '2016-10-18', '', '', '', '', '', '', '', '', '', 0, 'For Approval', 'For Approval', '', '', 23, 0, '', 1, 1, 23),
(167, 'Board acceptance', '', 'BACOOR', 'Major', 'asda', 'TEST', '23', 'user19', '', 'Wireless Core', '', '2016-09-21', '10:27:00', '10:27:00', '2016-09-08', '', '', '', '', '', '', '', '', '', 0, 'For Approval', 'For Approval', '', '', 23, 0, '', 1, 1, 23),
(168, 'Board acceptance', '', 'VALERO', 'Major', 'asda', '', '23', 'user19', '', '', '', '2016-09-21', '01:00:00', '01:00:00', '0000-09-21', '', '', '', '', '', '', '', '', '', NULL, 'For Approval', '', '', '', 23, 0, '', 1, 1, 23),
(169, 'Acceptance(SAT, HAT, iSAT, UAT)', '', 'BACOOR', 'Critical', 'TESTING11:21 am', 'TESTING', '23', 'user19', '', 'Wireline Core', '', '2016-09-21', '01:00:00', '01:00:00', '2016-10-18', '', '', '', '', '', '', '', '', '', 0, 'For Approval', 'For Approval', '', '', 23, 0, '', 1, 1, 23),
(170, 'Board acceptance', '', 'CARMONA', 'Major', '', '', '23', 'user19', '', '', '', '2016-09-21', '01:00:00', '01:00:00', '2016-10-18', '', '', '', '', '', '', '', '', '', NULL, 'For Approval', '', '', '', 23, 0, '', 1, 1, 23),
(171, '', '', 'CARMONA', '', 'Test', '', '23', 'user19', '', 'Wireless Access', '', '2016-09-21', '01:00:00', '01:00:00', '0000-09-21', '', '', '', '', '', '', '', '', '', NULL, 'New', '', 'TEST', '', 23, 0, '', 1, 1, 23),
(172, '', '', '', '', '', '', '23', 'user19', '', '', '', '2016-09-21', '01:00:00', '01:00:00', '2016-10-18', '', '', '', '', '', '', '', '', '', NULL, 'New', '', '', '', 23, 0, '', 1, 1, 23),
(173, 'Hardware changeout', '', 'VALERO', '', 'TEST approval', '', '23', 'user19', '', '', '', '2016-09-21', '14:10:00', '14:10:00', '2016-09-26', '', '', '', '', '', '', '', '', '', 1, 'Accepted', '', '', 'TESTING', 23, 0, '', 1, 1, 23),
(174, 'Acceptance(SAT, HAT, iSAT, UAT)', '', 'CARMONA', 'Minor', 'adasdad', 'aSiardasd', '26', 'ENT2016', 'adasda', 'Transmission', 'adada', '2016-09-21', '17:07:00', '07:07:00', '2016-09-21', 'adasdadada', 'adasdad', 'adadada', 'adadad', 'adadasd', 'adadada', 'MOP', 'adsadada', '', NULL, 'For Approval', '', '', '', 26, 0, '', 0, 0, 26),
(175, 'Acceptance(SAT, HAT, iSAT, UAT)', '', 'CARMONA', 'Minor', 'adasdad', 'aSiardasd', '26', 'ENT2016', 'adasda', 'Transmission', 'adada', '2016-09-21', '17:07:00', '07:07:00', '2016-09-21', 'adasdadada', 'adasdad', 'adadada', 'adadad', 'adadasd', 'adadada', 'MOP', 'adsadada', '', NULL, 'For Approval', '', '', '', 26, 0, '', 1, 0, 26),
(176, 'Acceptance(SAT, HAT, iSAT, UAT)', '', 'CARMONA', 'Minor', 'adasdad', 'aSiardasd', '26', 'ENT2016', 'adasda', 'Transmission', 'adada', '2016-09-21', '17:07:00', '07:07:00', '2016-09-21', 'adasdadada', 'adasdad', 'adadada', 'adadad', 'adadasd', 'adadada', 'MOP', 'adsadada', '', NULL, 'For Approval', '', 'Ito po yung error?', '', 26, 0, '', 1, 0, 26),
(177, 'Acceptance(SAT, HAT, iSAT, UAT)', '', 'CARMONA', 'Minor', 'adasdad', 'aSiardasd', '26', 'ENT2016', 'adasda', 'Transmission', 'adada', '2016-09-21', '17:07:00', '07:07:00', '2016-09-21', 'adasdadada', 'adasdad', 'adadada', 'adadad', 'adadasd', 'adadada', 'MOP', 'adsadada', '', NULL, 'For Approval', '', 'Ito po yung error?', '', 26, 0, '', 1, 0, 26),
(178, '', '', '', '', '', '', '26', 'ENT2016', '', '', '', '2016-09-21', '01:00:00', '01:00:00', '2016-10-18', '', '', '', '', '', '', '', '', '', NULL, 'For Approval', '', '', '', 26, 0, '', 1, 0, 26),
(179, '', '', 'VALERO', '', 'TET EDIT', '', '26', 'ENT2016', '', '', '', '2016-09-21', '01:00:00', '01:00:00', '2016-10-13', '', '', '', '', '', '', '', '', '', NULL, 'For Approval', '', 'Test', '', 26, 0, '', 0, 0, 26),
(180, 'Board acceptance', '', 'CARMONA', 'Major', 'sd', 'fs', '26', 'ENT2016', '', '', '', '2016-09-21', '17:22:00', '17:22:00', '2016-09-21', '', '', '', '', '', '', '', '', '', NULL, 'For Approval', '', '', '', 26, 0, '', 0, 0, 26),
(181, 'Board acceptance', '', 'VALERO', 'Major', 'TEST', '', '26', 'ENT2016', '', '', '', '2016-09-21', '01:00:00', '01:00:00', '2016-10-18', '', '', '', '', '', '', '', '', '', NULL, 'For Approval', '', 'TEST 2', '', 26, 0, '', 0, 0, 26),
(182, NULL, '', 'VALERO', 'Major', 'TEST 3', '', '26', 'ENT2016', '', 'Wireline Core', '', '2016-09-21', '17:25:00', '17:25:00', '2016-10-18', '', '', '', '', '', '', '', '', '', NULL, 'For Approval', '', '', '', 26, 0, '', 0, 0, 26),
(183, '', '', 'VALERO', '', '', '', '26', 'ENT2016', '', '', '', '2016-09-21', '01:00:00', '01:00:00', '2016-10-18', '', '', '', '', '', '', '', '', '', NULL, 'For Approval', '', '', '', 26, 0, '', 0, 0, 26),
(184, 'Board acceptance', '', 'CARMONA', 'Minor', 'TEST4', '', '26', 'ENT2016', '', '', '', '2016-09-21', '17:27:00', '17:27:00', '2016-10-18', '', '', '', '', '', '', '', '', '', NULL, 'For Approval', '', '', '', 26, 0, '', 1, 0, 26),
(185, '', '', 'VALERO', '', '', '', '26', 'ENT2016', '', '', '', '2016-09-21', '01:00:00', '01:00:00', '2016-10-18', '', '', '', '', '', '', '', '', '', NULL, 'For Approval', '', '', '', 26, 0, '', 1, 0, 26),
(186, '', '', 'CARMONA', '', '', '', '26', 'ENT2016', '', 'Wireline Core', '', '2016-09-21', '01:00:00', '01:00:00', '2016-10-18', '', '', '', '', '', '', '', '', '', NULL, 'For Approval', '', '', '', 26, 0, '', 1, 0, 26),
(187, '', '', 'CARMONA', 'Major', 'TEST 5', '', '26', 'ENT2016', '', '', '', '2016-09-21', '01:00:00', '01:00:00', '2016-10-18', '', '', '', '', '', '', '', '', '', NULL, 'For Approval', '', '', '', 26, 0, '', 0, 1, 26),
(188, '', '', 'CARMONA', '', '', '', '26', 'ENT2016', '', '', '', '2016-09-21', '01:00:00', '01:00:00', '2016-10-18', '', '', '', '', '', '', '', '', '', NULL, 'For Approval', '', '', '', 26, 0, '', 0, 1, 26),
(189, '', '', 'CARMONA', '', '', '', '26', 'ENT2016', '', 'Wireline Core', '', '2016-09-21', '01:00:00', '01:00:00', '2016-10-18', '', '', '', '', '', '', '', '', '', NULL, 'For Approval', '', '', '', 26, 0, '', 0, 1, 26),
(190, '', '', 'CARMONA', '', '', '', '26', 'ENT2016', '', 'Wireline Access', '', '2016-09-21', '17:45:00', '17:45:00', '2016-09-02', '', '', '', '', '', '', '', '', '', NULL, 'For Approval', '', '', '', 26, 0, '', 0, 1, 26),
(191, 'Board acceptance', '', 'CARMONA', 'Critical', 'TEST app Create', '', '26', 'ENT2016', '', 'Wireless Core', '', '2016-09-22', '10:04:00', '10:05:00', '2016-10-18', '', '', '', '', '', '', '', '', '', NULL, 'For Approval', '', '', '', 26, 0, '', 0, 1, 26),
(192, 'Board acceptance', '', 'BACOOR', 'Major', 'TEST BACOOR', '', '26', 'ENT2016', '', 'Wireless Core', '', '2016-09-22', '01:00:00', '01:00:00', '2016-10-18', '', '', '', '', '', '', '', '', '', 0, 'For Approval', 'For Approval', '', '', 3, 0, '', 1, 0, 3),
(193, 'Board acceptance', '', 'SANJUAN', '', 'TEST if has data.is_sent', '', '26', 'ENT2016', '', 'Wireline Core', '', '2016-09-22', '01:00:00', '01:00:00', '2016-10-13', '', '', '', '', '', '', '', '', '', NULL, 'For Approval', '', 'TEST gg--==00--00', '', 26, 0, '', 0, 1, 26),
(194, NULL, '', 'BACOOR', 'Critical', 'TEST Create', '', '26', 'ENT2016', '', '', '', '2016-09-22', '15:33:00', '15:33:00', '2016-10-13', '', '', '', '', '', '', '', '', '', 3, 'Cancelled', 'For Approval', '', '', 3, 0, '', 1, 0, 3),
(195, 'Delivery and Installation', '13,14', 'BACOOR', '', 'TESTING', '', '23', 'user19', '', '', '', '2016-09-23', '16:33:00', '16:34:00', '2016-09-24', '', '', '', '', '', '', '', '', '', 0, 'For Approval', '', 'TEST if cancelled to For Approval 7.0', '', 23, 0, 'TEST CANCEL', 1, 0, 3),
(196, NULL, '', 'BACOOR', 'Critical', 'Testing ENT2016 recieve email...', '', '26', 'ENT2016', '', 'Wireless Core', 'TEST', '2016-09-26', '01:00:00', '01:00:00', '2016-10-13', '', '', '', '', '', '', '', '', '', 0, 'For Approval', 'For Approval', 'TESTING modified1:43 pm', '', 3, 0, '', 1, 1, 3),
(197, NULL, '', 'VALERO', 'Critical', 'TEsting', '', '26', 'ENT2016', '', 'Wireline Core', '', '2016-09-26', '13:44:00', '13:44:00', '2016-09-29', '', '', '', '', '', '', 'Network Diagram', '', '', NULL, 'For Approval', 'Partially Completed', 'TEST', '', 26, 0, '', 1, 0, NULL),
(198, NULL, '', 'CARMONA', 'Major', 'TEST user20 create', '', '27', 'user20', '', 'Wireless Core', 'TEST', '2016-09-26', '17:34:00', '17:34:00', '2016-09-30', '', '', '', '', '', '', '', '', '', NULL, 'For Approval', '', 'TESTING', '', 27, 0, '', 0, 0, NULL),
(199, NULL, '', 'VALERO', 'Major', 'TESTING create on new user20', '', '27', 'user20', '', 'Wireless Core', '', '2016-09-26', '01:00:00', '01:00:00', '2016-10-13', '', '', '', '', '', '', '', '', '', NULL, 'For Approval', '', 'TESTING', '', 27, 0, '', 1, 0, NULL),
(200, NULL, '', 'BACOOR', 'Major', 'TEST Requetsor', '', '27', 'user20', '', 'Wireline Core', '', '2016-09-26', '17:49:00', '17:49:00', '2016-10-13', '', '', '', '', '', '', '', '', '', 0, 'For Approval', 'For Approval', '', '', 3, 0, '', 1, 1, 3),
(201, NULL, '', 'VALERO', 'Minor', 'TEST requestor', '', '27', 'user20', '', 'Wireless Core', '', '2016-09-26', '17:54:00', '17:54:00', '2016-10-13', '', '', '', '', '', '', '', '', '', NULL, 'For Approval', '', '', '', 27, 0, '', 1, 0, NULL),
(202, NULL, '', 'CARMONA', 'Major', 'TES', '', '23', 'user19', '', 'Wireless Access', '', '2016-09-29', '14:59:00', '14:59:00', '2016-10-13', '', '', '', '', '', '', '', '', '', NULL, 'For Approval', '', '', '', 23, 0, '', 1, 0, NULL),
(203, NULL, '1', 'VALERO', 'Major', '', '', '23', 'user19', '', 'Wireline Core', '', '2016-09-29', '01:00:00', '01:00:00', '2016-10-13', '', '', '', '', '', '', '', '', '', NULL, 'For Approval', '', '', '', 23, 0, '', 1, 0, NULL),
(204, NULL, '', 'BACOOR', 'Major', 'TEST Create', '', '23', 'user19', '', 'IN', '', '2016-09-29', '01:00:00', '01:00:00', '2016-10-13', '', '', '', '', '', '', '', '', '', 3, 'Cancelled', '', '', '', 3, 0, '', 1, 0, 3),
(205, 'Card insertion', '5,6', 'VALERO', 'Major', 'TEST', '', '23', 'user19', '', 'Wireline Core', '', '2016-10-14', '14:04:00', '14:04:00', '2016-10-14', '', '', '', '', '', '', '', '', '', NULL, 'For Approval', '', 'TESTING for CHECKList', '', 23, 0, '', 1, 0, NULL),
(206, 'Card pullout', '10,11,12', 'VALERO', 'Critical', '', '', '23', 'user19', '', 'Wireline Core', '', '2016-10-14', '01:00:00', '01:00:00', '2016-10-13', '', '', '', '', '', '', '', '', '', NULL, 'For Approval', '', 'TEST checklist 2', '', 0, 0, '', 0, 0, NULL),
(207, 'Board acceptance', '3', '', '', '', '', '23', 'user19', '', '', '', '2016-10-14', '01:00:00', '01:00:00', '2016-10-13', '', '', '', '', '', '', '', '', '', NULL, 'For Approval', '', '', '', 23, 0, '', 1, 0, NULL),
(208, 'Card insertion', '5', '', '', '', '', '23', 'user19', '', '', '', '2016-10-14', '01:00:00', '01:00:00', '2016-10-13', '', '', '', '', '', '', '', '', '', NULL, 'For Approval', '', '', '', 23, 0, '', 1, 0, NULL),
(209, 'Board acceptance', '3', '', '', '', '', '23', 'user19', '', '', '', '2016-10-17', '01:00:00', '01:00:00', '2016-10-13', '', '', '', '', '', '', '', '', '', NULL, 'For Approval', '', '', '', 23, 0, '', 1, 0, NULL),
(210, 'Acceptance(SAT, HAT, iSAT, UAT)', '1,2', 'VALERO', '', '', '', '23', 'user19', '', '', '', '2016-10-24', '10:10:00', '10:10:00', '2016-10-13', '', '', '', '', '', '', '', '', '', NULL, 'For Approval', '', '', '', 0, 0, '', 0, 0, NULL),
(211, 'Acceptance(SAT, HAT, iSAT, UAT)', '1,2', 'VALERO', '', '', '', '23', 'user19', '', '', '', '2016-10-24', '10:10:00', '10:10:00', '2016-10-13', '', '', '', '', '', '', '', '', '', NULL, 'For Approval', '', '', '', 23, 0, '', 1, 0, NULL),
(212, 'System upgrade', '76,77,78,79', 'CARMONA', '', '', '', '23', 'user19', '', '', '', '2016-10-24', '22:10:00', '11:10:00', '2016-10-14', '', '', '', '', '', '', '', '', '', NULL, 'For Approval', '', '', '', 23, 0, '', 1, 0, NULL),
(213, 'Patching', '46,47,48', 'SANJUAN', '', '', '', '23', 'user19', '', '', '', '2016-10-24', '16:10:00', '11:55:00', '2016-10-20', '', '', '', '', '', '', '', '', '', NULL, 'For Approval', '', '', '', 23, 0, '', 1, 1, 23),
(214, 'Card insertion', '4,5,6,7,8', 'BACOOR', 'Critical', '', '', '23', 'user19', '', '', '', '2016-10-24', '04:10:00', '11:35:00', '2016-10-21', '', '', '', '', '', '', '', '', '', NULL, 'For Approval', '', '', '', 23, 0, '', 1, 0, NULL),
(215, 'Acceptance(SAT, HAT, iSAT, UAT)', '1,2', 'VALERO', '', '', '', '23', 'user19', '', '', '', '2016-10-24', '16:10:00', '23:35:00', '2016-10-21', '', '', '', '', '', '', '', '', '', NULL, 'For Approval', '', '', '', 23, 0, '', 1, 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `requests_v1`
--

CREATE TABLE `requests_v1` (
  `request_id` int(11) NOT NULL,
  `date_requested` date DEFAULT NULL,
  `employee_id` varchar(23) DEFAULT NULL,
  `employee_name` varchar(23) DEFAULT NULL,
  `department` varchar(23) DEFAULT NULL,
  `so_ref_number` varchar(23) DEFAULT NULL,
  `time` time DEFAULT NULL,
  `gt_rep` varchar(23) DEFAULT NULL,
  `vendor` varchar(23) DEFAULT NULL,
  `description` varchar(23) DEFAULT NULL,
  `ne_involved` varchar(23) DEFAULT NULL,
  `activity_date` date DEFAULT NULL,
  `remarks` text,
  `_status` enum('0','1') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `requests_v1`
--

INSERT INTO `requests_v1` (`request_id`, `date_requested`, `employee_id`, `employee_name`, `department`, `so_ref_number`, `time`, `gt_rep`, `vendor`, `description`, `ne_involved`, `activity_date`, `remarks`, `_status`) VALUES
(2, '2010-07-10', '2016-10-10', 'asd', '242', '09991', '08:10:30', '', '', '', '', '2010-07-10', '', '1'),
(3, '2010-07-10', '2016-10-10', 'test2', '242', '', '08:10:30', '', '', '', '', '2010-07-10', 'sd', '1'),
(4, '2010-07-10', '2016-10-10', 'go', '', '243', '08:10:30', '', '', '', '', '2010-07-10', '', '1'),
(6, '2010-07-10', '2016-10-10', 'ro', '', '244', '08:10:30', '', '', '', '', '2010-07-10', '', NULL),
(8, '2010-07-10', '2016-10-10', 're', '', '246', '08:10:30', '', '', '', '', '2010-07-10', '', '0'),
(9, '2010-07-10', '2016-10-10', 'CPE223', 'Name1', '1', '08:10:30', '', '', '', '', '2010-07-10', '', '0'),
(10, '2010-07-10', '2016-10-10', 'CPE223', 'Name2', '2', '08:10:30', '', '', '', '', '2010-07-10', '', '0'),
(11, '2010-07-10', '2016-10-10', 'CPE223', 'Name3', '3', '08:10:30', '', '', '', '', '2010-07-10', '', '0'),
(12, '2010-07-10', '2016-10-10', 'CPE223', 'Name4', '4', '08:10:30', '', '', '', '', '2010-07-10', '', '0'),
(13, '2010-07-10', '2016-10-10', 'CPE223', 'Name5', '5', '08:10:30', '', '', '', '', '2010-07-10', '', '0'),
(14, '2010-07-10', '2016-10-10', 'CPE223', 'Name6', '6', '08:10:30', '', '', '', '', '2010-07-10', '', '0'),
(15, '2010-07-10', '2016-10-10', 'CPE223', 'Name7', '7', '08:10:30', '', '', '', '', '2010-07-10', '', '0'),
(16, '2010-07-10', '2016-10-10', 'ric', 'Name8', '8', '08:10:30', '', '', '', '', '2010-07-10', '', '1'),
(17, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sites`
--

CREATE TABLE `sites` (
  `id` int(11) NOT NULL,
  `site_name` varchar(255) NOT NULL,
  `area` varchar(255) NOT NULL,
  `google_calendar_frame` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sites`
--

INSERT INTO `sites` (`id`, `site_name`, `area`, `google_calendar_frame`) VALUES
(1, 'VALERO', '', 'https://calendar.google.com/calendar/embed?src=globe.com.ph_k7n8jrdklc1elggi74gp4kuki4%40group.calendar.google.com&ctz=Asia/Manila'),
(2, 'CARMONA', '', 'https://calendar.google.com/calendar/embed?src=globe.com.ph_eagtl1fu4ioperiop1s4ecmduc%40group.calendar.google.com&ctz=Asia/Manila'),
(3, 'BACOOR', '', 'https://calendar.google.com/calendar/embed?src=globe.com.ph_k394f4ktr2qrj317bsdakkqkks%40group.calendar.google.com&ctz=Asia/Manila'),
(4, 'SANJUAN', '', 'https://calendar.google.com/calendar/embed?src=globe.com.ph_hoikrrpalnosk9uai0afv3qd0c%40group.calendar.google.com&ctz=Asia/Manila');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) UNSIGNED NOT NULL,
  `username` varchar(255) DEFAULT '',
  `firstname` varchar(255) DEFAULT '',
  `middlename` varchar(255) DEFAULT '',
  `lastname` varchar(255) DEFAULT '',
  `id_num` varchar(255) DEFAULT '',
  `email` varchar(255) DEFAULT '',
  `password` varchar(255) DEFAULT '',
  `immediate_supervisor` varchar(255) DEFAULT '',
  `company` varchar(255) DEFAULT '',
  `department` varchar(255) DEFAULT '',
  `area` varchar(255) DEFAULT NULL,
  `avatar` varchar(255) DEFAULT 'default.jpg',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `is_admin` tinyint(1) UNSIGNED DEFAULT '0',
  `is_approver` tinyint(1) NOT NULL DEFAULT '0',
  `is_confirmed` tinyint(1) UNSIGNED DEFAULT '0',
  `is_deleted` tinyint(1) UNSIGNED DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `firstname`, `middlename`, `lastname`, `id_num`, `email`, `password`, `immediate_supervisor`, `company`, `department`, `area`, `avatar`, `created_at`, `updated_at`, `is_admin`, `is_approver`, `is_confirmed`, `is_deleted`) VALUES
(1, 'ric1', '', '', '', '1', 'ricguiness@gmail.com', 'password', '', '', '', '', 'default.jpg', '2016-07-31 21:51:47', NULL, 0, 0, 1, 0),
(2, 'ric2', '', '', '', '2', 'ricguiness@gmail.com.pn', 'password', '', '', '', '', 'default.jpg', '2016-07-31 21:54:50', NULL, 0, 0, 1, 0),
(3, 'admin', 'admin', '', 'user a', '3', 'admin@example.com', 'admins', 'lkjlk', 'sms', 'asd', 'BACOOR', 'default.jpg', '2016-07-31 22:06:55', '2016-09-05 00:00:00', 1, 1, 1, 0),
(4, 'user', 'user', '', 'usera', '4', 'user@gmail.com', 'password', 'lk', 'lkajsd', 'lk', '', 'default.jpg', '2016-07-31 22:25:27', '2016-09-05 00:00:00', 0, 0, 1, 0),
(5, 'user2', '', '', '', '5', 'user2@gmail.com', 'password', '', '', '', '', 'default.jpg', '2016-07-31 22:47:34', NULL, 0, 0, 1, 0),
(6, 'user3', '', '', '', '6', 'user3@gmail.com', 'password', '', '', '', '', 'default.jpg', '2016-07-31 23:23:24', NULL, 0, 0, 0, 0),
(7, 'ric3', '', '', '', '7', 'ric3@gmail.com', 'password', '', '', '', '', 'default.jpg', '2016-07-31 23:33:15', NULL, 0, 0, 0, 0),
(8, 'user4', '4', '', '4', '8', 'user4@gmail.com', 'password', '4', '4', '4', '', 'default.jpg', '2016-07-31 23:48:58', '2016-08-01 00:00:00', 0, 0, 0, 0),
(9, 'user5', 'Richard', '', 'Raguine', '9', 'user5@gmail.com', 'password', 'Maam A', 'Smart', 'BLALSLASDLALSD', '', 'default.jpg', '2016-08-01 01:00:57', NULL, 0, 0, 0, 0),
(10, 'user6', 'user6', '', 'asd', '10', 'user6@gmail.com', 'password', 'asd', 'sad', 'asd', '', 'default.jpg', '2016-08-01 05:58:04', NULL, 0, 0, 0, 0),
(11, 'user7', 'asd', '', 'as', '11', 'user7@gmail.com', 'password', 'asd', 'asd', 'BLALSLASDLALSD', '', 'default.jpg', '2016-08-01 06:17:31', '2016-08-01 00:00:00', 0, 0, 0, 0),
(12, 'user10', 'user10', '', 'asdlkasjd', '12', 'user10@gmail.com', 'password', 'Madam', 'smart', 'tpe', '', 'default.jpg', '2016-08-09 05:40:21', NULL, 0, 0, 0, 0),
(13, 'user11', 'user11', '', 'asdas', '13', 'user11@gmail.com', 'password', 'Maam', 'user', 'user', '', 'default.jpg', '2016-08-09 07:43:25', NULL, 0, 0, 0, 0),
(14, 'user12', 'user12', '', 'uasdasd', '14', 'user12@email.com', 'password', 'feamfmd', 'usdasd', 'sdusdu', '', 'default.jpg', '2016-08-09 08:00:16', NULL, 0, 0, 0, 0),
(15, 'user13', 'user13', '', 'laksjd', '15', 'user13@gmail.com', 'password', 'jlkj', 'lkj', 'lk', '', 'default.jpg', '2016-08-09 08:03:54', NULL, 0, 0, 0, 0),
(16, 'user14', 'user14', '', 'alksdjl', '16', 'user14@email.com', 'password', 'kjl', 'kjlk', 'jl', '', 'default.jpg', '2016-08-09 08:06:25', NULL, 0, 0, 0, 0),
(17, 'obkatigbak1', 'Oliver', '', 'Katigbak', '17', 'obkatigbak@globe.com.ph', 'password', 'Any', 'GLOBE', 'ANY', 'CARMONA', 'default.jpg', '2016-08-30 09:08:04', NULL, 1, 1, 0, 0),
(18, 'obkatigbak', 'Oliver', '', 'Katigbak', '18', 'obkatigbak@globe.com.ph', 'password', 'ANY', 'GLOBE', 'ANY', 'VALERO', 'default.jpg', '2016-08-30 09:10:34', NULL, 1, 1, 0, 0),
(21, 'obkatigbak2', 'Oliver', '', 'Katigbak', '21', 'obkatigbak@globe.com.ph', 'password', 'ANY', 'Globe', 'ANY', 'SANJUAN', 'default.jpg', '2016-08-30 09:30:02', NULL, 1, 1, 0, 0),
(22, 'obkatigbak3', 'Oliver', '', 'Katigbak', '22', 'obkatigbak@globe.com.ph', 'password', 'ANY', 'GLOBE', 'ANY', 'BACOOR', 'default.jpg', '2016-08-30 09:34:27', NULL, 1, 1, 0, 0),
(23, 'user19', 'USER', '', 'Nineteen', '23', 'user19@gmail.com', 'password', 'opsfd', 'pasd', 'asopdiasd', '', 'default.jpg', '2016-08-31 08:34:21', '2016-09-08 00:00:00', 0, 0, 0, 0),
(24, 'test', 'Test user', '', 'TESTING', '24', 'test@gmail.com', 'password', 'lkj', 'asdklj', 'lkj', NULL, 'default.jpg', '2016-09-02 10:10:25', NULL, 0, 0, 0, 0),
(25, 'test2', 'TEST user 2', '', 'two', '', 'test2@gmail.com', 'password', 'lkj', 'alksdj', 'lkj', NULL, 'default.jpg', '2016-09-02 10:29:28', NULL, 0, 0, 0, 0),
(26, 'ENT2016', 'edwin', '', 'talenjale', '', 'entalenjale@globe.com.ph', 'password', 'Rex Reyes', 'HHHHHHH', 'IPNE', NULL, 'default.jpg', '2016-09-21 11:05:46', NULL, 0, 0, 0, 0),
(27, 'user20', 'Ric', '', 'rag', '', 'user20@globe.com.ph', 'password', 'test', 'test', 'test', NULL, 'default.jpg', '2016-09-26 11:34:24', NULL, 0, 0, 0, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity_calendar_date_color`
--
ALTER TABLE `activity_calendar_date_color`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `date` (`date`);

--
-- Indexes for table `activity_types`
--
ALTER TABLE `activity_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `activity_type_prerequisites`
--
ALTER TABLE `activity_type_prerequisites`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `calendar`
--
ALTER TABLE `calendar`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ci_sessions`
--
ALTER TABLE `ci_sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ci_sessions_timestamp` (`timestamp`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `requests`
--
ALTER TABLE `requests`
  ADD PRIMARY KEY (`request_id`);

--
-- Indexes for table `requests_v1`
--
ALTER TABLE `requests_v1`
  ADD PRIMARY KEY (`request_id`);

--
-- Indexes for table `sites`
--
ALTER TABLE `sites`
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
-- AUTO_INCREMENT for table `activity_calendar_date_color`
--
ALTER TABLE `activity_calendar_date_color`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `activity_types`
--
ALTER TABLE `activity_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
--
-- AUTO_INCREMENT for table `activity_type_prerequisites`
--
ALTER TABLE `activity_type_prerequisites`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=80;
--
-- AUTO_INCREMENT for table `calendar`
--
ALTER TABLE `calendar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT for table `requests`
--
ALTER TABLE `requests`
  MODIFY `request_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=216;
--
-- AUTO_INCREMENT for table `requests_v1`
--
ALTER TABLE `requests_v1`
  MODIFY `request_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT for table `sites`
--
ALTER TABLE `sites`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
