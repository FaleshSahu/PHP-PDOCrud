-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jan 12, 2018 at 01:13 PM
-- Server version: 5.7.19
-- PHP Version: 7.0.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cruid`
--
CREATE DATABASE IF NOT EXISTS `cruid` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `cruid`;

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

DROP TABLE IF EXISTS `employee`;
CREATE TABLE IF NOT EXISTS `employee` (
  `eid` int(11) NOT NULL AUTO_INCREMENT,
  `ename` varchar(500) DEFAULT NULL,
  `operation` varchar(500) DEFAULT NULL,
  `operation_date` varchar(500) DEFAULT NULL,
  `operation_userid` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`eid`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`eid`, `ename`, `operation`, `operation_date`, `operation_userid`) VALUES
(5, 'Falesh Kumar', NULL, NULL, NULL),
(4, 'Gaurav Chauhan', NULL, NULL, NULL),
(6, 'asdfgh', NULL, NULL, NULL),
(11, 'Rahul', 'Update', '2018-01-12 06:14:15', '202139'),
(12, 'Ram Prasas', 'Update', '2018-01-12 09:43:30', '202139');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
