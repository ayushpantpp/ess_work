-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jan 27, 2016 at 07:39 AM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `hrportal`
--

-- --------------------------------------------------------

--
-- Table structure for table `app_ratings`
--

CREATE TABLE IF NOT EXISTS `app_ratings` (
  `id` int(6) unsigned NOT NULL AUTO_INCREMENT,
  `appraiser_id` varchar(30) NOT NULL,
  `factor_id` varchar(30) NOT NULL,
  `rating_id` varchar(50) DEFAULT NULL,
  `remarks` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=21 ;

--
-- Dumping data for table `app_ratings`
--

INSERT INTO `app_ratings` (`id`, `appraiser_id`, `factor_id`, `rating_id`, `remarks`) VALUES
(17, '1', '2', '3', ''),
(18, '1', '3', '4', ''),
(19, '2', '2', '3', ''),
(20, '2', '3', '4', '');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
