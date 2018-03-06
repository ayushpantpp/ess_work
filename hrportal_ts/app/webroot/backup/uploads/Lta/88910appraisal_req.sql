-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Oct 06, 2015 at 05:35 PM
-- Server version: 5.5.43-0ubuntu0.14.04.1
-- PHP Version: 5.5.9-1ubuntu4.11

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
-- Table structure for table `appraisal_req`
--

CREATE TABLE IF NOT EXISTS `appraisal_req` (
  `id` int(6) unsigned NOT NULL AUTO_INCREMENT,
  `dt_fromDate` date DEFAULT NULL,
  `dt_toDate` date DEFAULT NULL,
  `dt_request` date DEFAULT NULL,
  `ch_status` varchar(20) DEFAULT NULL,
  `emp_code` varchar(8) DEFAULT NULL,
  `dt_appraisal` date DEFAULT NULL,
  `app_type` char(1) DEFAULT NULL,
  `desc_code` varchar(20) DEFAULT NULL,
  `edu_code` varchar(10) DEFAULT NULL,
  `ess_exp` varchar(10) DEFAULT NULL,
  `hra_amt` varchar(10) DEFAULT NULL,
  `yr_inct` varchar(10) DEFAULT NULL,
  `dept_code` varchar(20) DEFAULT NULL,
  `locat_code` varchar(8) DEFAULT NULL,
  `dt_join` date DEFAULT NULL,
  `tot_exp` varchar(5) DEFAULT NULL,
  `last_prmt` date DEFAULT NULL,
  `amt_lst_inc` varchar(10) DEFAULT NULL,
  `gross_sal` varchar(8) DEFAULT NULL,
  `emp_type` varchar(8) DEFAULT NULL,
  `rating` varchar(5) DEFAULT NULL,
  `amt_inc` varchar(10) DEFAULT NULL,
  `remark` varchar(8) DEFAULT NULL,
  `rating_avg` varchar(8) DEFAULT NULL,
  `rating_min` char(1) DEFAULT NULL,
  `rating_max` char(1) DEFAULT NULL,
  `sal_avg` varchar(10) DEFAULT NULL,
  `sal_min` varchar(10) DEFAULT NULL,
  `sal_max` varchar(10) DEFAULT NULL,
  `app_Code` varchar(10) DEFAULT NULL,
  `review_reason` varchar(500) DEFAULT NULL,
  `slab_category_id` varchar(15) DEFAULT NULL,
  `myprofile_id` varchar(20) DEFAULT NULL,
  `departments_id` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `appraisal_req`
--

INSERT INTO `appraisal_req` (`id`, `dt_fromDate`, `dt_toDate`, `dt_request`, `ch_status`, `emp_code`, `dt_appraisal`, `app_type`, `desc_code`, `edu_code`, `ess_exp`, `hra_amt`, `yr_inct`, `dept_code`, `locat_code`, `dt_join`, `tot_exp`, `last_prmt`, `amt_lst_inc`, `gross_sal`, `emp_type`, `rating`, `amt_inc`, `remark`, `rating_avg`, `rating_min`, `rating_max`, `sal_avg`, `sal_min`, `sal_max`, `app_Code`, `review_reason`, `slab_category_id`, `myprofile_id`, `departments_id`) VALUES
(1, '2015-07-01', '2015-09-28', '2015-09-28', 'ON HOLD', '1111', '2015-09-29', '0', NULL, '', NULL, NULL, NULL, 'DEPT00006', NULL, '2015-07-01', NULL, NULL, '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1', '1', '1');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
