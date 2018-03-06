-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jun 24, 2016 at 01:20 PM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `hrportal_local`
--

-- --------------------------------------------------------

--
-- Table structure for table `oracle_hcm_emp_exp`
--

CREATE TABLE IF NOT EXISTS `oracle_hcm_emp_exp` (
  `cld_id` varchar(4) DEFAULT NULL,
  `sloc_id` int(2) DEFAULT NULL,
  `ho_org_id` varchar(2) DEFAULT NULL,
  `org_id` varchar(4) DEFAULT NULL,
  `doc_id` varchar(40) DEFAULT NULL,
  `emp_code` int(20) DEFAULT NULL,
  `emp_org_nm` varchar(250) DEFAULT NULL,
  `emp_org_loc` varchar(20) DEFAULT NULL,
  `emp_org_doj` date DEFAULT NULL,
  `emp_org_dol` date DEFAULT NULL,
  `emp_org_desig` varchar(250) DEFAULT NULL,
  `emp_org_sal` int(26) DEFAULT NULL,
  `usr_id_create` int(10) DEFAULT NULL,
  `usr_id_create_dt` date DEFAULT NULL,
  `usr_id_mod` int(10) DEFAULT NULL,
  `usr_id_mod_dt` date DEFAULT NULL,
  `org_per_nm` varchar(200) DEFAULT NULL,
  `org_per_desg` varchar(200) DEFAULT NULL,
  `org_per_email` varchar(200) DEFAULT NULL,
  `org_per_phone` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
