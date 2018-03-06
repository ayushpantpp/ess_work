-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 16, 2017 at 05:31 PM
-- Server version: 5.7.20-0ubuntu0.16.04.1
-- PHP Version: 5.6.31-4+ubuntu16.04.1+deb.sury.org+4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `make_live`
--

-- --------------------------------------------------------

--
-- Table structure for table `acl_rights_types`
--

CREATE TABLE `acl_rights_types` (
  `id` int(25) NOT NULL,
  `name` varchar(255) NOT NULL,
  `status` int(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `acl_rights_types`
--

INSERT INTO `acl_rights_types` (`id`, `name`, `status`) VALUES
(1, 'approval', 1),
(2, 'masters', 1),
(3, 'reports', 1);

-- --------------------------------------------------------

--
-- Table structure for table `acos`
--

CREATE TABLE `acos` (
  `id` int(10) UNSIGNED NOT NULL,
  `parent_id` int(10) DEFAULT NULL,
  `model` varchar(255) DEFAULT '',
  `foreign_key` int(10) UNSIGNED DEFAULT NULL,
  `alias` varchar(255) DEFAULT '',
  `lft` int(10) DEFAULT NULL,
  `rght` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `acos`
--

INSERT INTO `acos` (`id`, `parent_id`, `model`, `foreign_key`, `alias`, `lft`, `rght`) VALUES
(1, NULL, NULL, NULL, 'Travels', 1, 6),
(2, 1, NULL, NULL, 'index', 2, 3),
(3, 1, NULL, NULL, 'deleteTravelDetails', 4, 5);

-- --------------------------------------------------------

--
-- Table structure for table `admin_options`
--

CREATE TABLE `admin_options` (
  `id` int(10) NOT NULL,
  `name` varchar(255) NOT NULL,
  `value` int(10) NOT NULL,
  `description` varchar(1000) NOT NULL,
  `sloc_id` varchar(22) DEFAULT NULL,
  `cloud_id` varchar(22) DEFAULT NULL,
  `ho_id` varchar(22) DEFAULT NULL,
  `ho_org_id` varchar(22) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin_options`
--

INSERT INTO `admin_options` (`id`, `name`, `value`, `description`, `sloc_id`, `cloud_id`, `ho_id`, `ho_org_id`) VALUES
(1, 'username_login', 0, 'Whether login using username ?', NULL, NULL, NULL, NULL),
(2, 'leave_module', 1, 'Leave module', NULL, NULL, NULL, NULL),
(3, 'separation_module', 1, 'Separation module', NULL, NULL, NULL, NULL),
(4, 'appraisal_module', 1, 'Performance Module', NULL, NULL, NULL, NULL),
(5, 'travel_module', 1, 'Travel Module', NULL, NULL, NULL, NULL),
(6, 'conveyance_module', 1, 'Conveyance Module', NULL, NULL, NULL, NULL),
(7, 'training_module', 1, 'Training Module', NULL, NULL, NULL, NULL),
(8, 'lta_module', 1, 'LTA module', NULL, NULL, NULL, NULL),
(9, 'medical_module', 0, 'Medical Module', NULL, NULL, NULL, NULL),
(11, 'tax_module', 1, 'Income tax module', NULL, NULL, NULL, NULL),
(12, 'task_module', 1, 'Task Module', NULL, NULL, NULL, NULL),
(13, 'bom_module', 1, 'Board of Management', NULL, NULL, NULL, NULL),
(14, 'doc_module', 1, 'Record Management', NULL, NULL, NULL, NULL),
(15, 'mom_module', 1, 'MOM Management', NULL, NULL, NULL, NULL),
(16, 'legal_module', 1, 'Legal Management', NULL, NULL, NULL, NULL),
(17, 'help_desk', 1, 'Help Desk', NULL, NULL, NULL, NULL),
(18, 'bday_notify', 1, 'Show Birthday', NULL, NULL, NULL, NULL),
(19, 'salary_slip', 1, 'Salary Slip', NULL, NULL, NULL, NULL),
(20, 'temporary_component', 1, 'Temporary Component', NULL, NULL, NULL, NULL),
(21, 'attendance_module', 1, 'Attendance Module', NULL, NULL, NULL, NULL),
(22, 'user_profile', 1, 'User Profile', NULL, NULL, NULL, NULL),
(23, 'other_module', 1, 'Other Document', NULL, NULL, NULL, NULL),
(25, 'ceo_dashboard', 1, 'CEO Dashboard', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `admin_option_org`
--

CREATE TABLE `admin_option_org` (
  `id` int(10) NOT NULL,
  `admin_options_id` int(10) NOT NULL,
  `org_id` varchar(10) NOT NULL,
  `status` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `applications`
--

CREATE TABLE `applications` (
  `id` int(11) NOT NULL,
  `vc_application_name` varchar(255) NOT NULL,
  `usr_id_create` varchar(45) DEFAULT NULL,
  `usr_id_create_dt` varchar(45) DEFAULT NULL,
  `usr_id_mod` varchar(45) DEFAULT NULL,
  `usd_id_mod_dt` varchar(45) DEFAULT NULL,
  `wf_status` varchar(45) DEFAULT NULL,
  `solc_id` varchar(25) DEFAULT NULL,
  `cld_id` varchar(22) DEFAULT NULL,
  `ho_org_id` varchar(22) DEFAULT NULL,
  `org_id` varchar(22) DEFAULT NULL,
  `emp_doc_id` varchar(52) DEFAULT NULL,
  `doc_id` varchar(52) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `applications`
--

INSERT INTO `applications` (`id`, `vc_application_name`, `usr_id_create`, `usr_id_create_dt`, `usr_id_mod`, `usd_id_mod_dt`, `wf_status`, `solc_id`, `cld_id`, `ho_org_id`, `org_id`, `emp_doc_id`, `doc_id`) VALUES
(1, 'Travel Voucher Module', NULL, NULL, '1', NULL, '1', NULL, NULL, '01', '01', NULL, NULL),
(2, 'Leave Module', NULL, NULL, NULL, NULL, '1', NULL, NULL, '01', '01', NULL, NULL),
(3, 'Expense Voucher Module', NULL, NULL, NULL, NULL, '1', NULL, NULL, '01', '01', NULL, NULL),
(4, 'Appraisal Module', NULL, NULL, NULL, NULL, '1', NULL, NULL, '01', '01', NULL, NULL),
(6, 'Training Module', '1', '2015-07-16 05:33:04', NULL, NULL, '1', NULL, NULL, '01', '01', NULL, NULL),
(7, 'Core', '1', '2015-07-31 10:15:40', NULL, NULL, '1', NULL, NULL, '01', '01', NULL, NULL),
(8, 'Separation module', '1', '2015-10-07 05:58:54', NULL, NULL, '1', NULL, NULL, '01', '01', NULL, NULL),
(9, 'User Module', NULL, NULL, NULL, NULL, '1', NULL, NULL, '01', '01', NULL, NULL),
(10, 'Recuitment', '1', '2015-11-26 06:10:41', NULL, NULL, '1', NULL, NULL, '01', '01', NULL, NULL),
(11, 'KRA', '1', NULL, NULL, NULL, '1', NULL, NULL, '01', '01', NULL, NULL),
(12, 'KPI', '1', NULL, NULL, NULL, '1', NULL, NULL, '01', '01', NULL, NULL),
(13, 'Event', '1', '2015-12-11 03:08:57', NULL, NULL, '1', NULL, NULL, '01', '01', NULL, NULL),
(14, 'LTA', NULL, NULL, NULL, NULL, '1', NULL, NULL, '01', '01', NULL, NULL),
(15, 'Medical', '0', NULL, NULL, NULL, '1', NULL, NULL, '01', '01', NULL, NULL),
(16, 'Task Management', '1', '2016-12-13 03:28:24', NULL, NULL, '1', NULL, '0000', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `application_constrains`
--

CREATE TABLE `application_constrains` (
  `id` int(10) NOT NULL,
  `app_name` varchar(10) DEFAULT NULL,
  `app_id` int(10) DEFAULT NULL,
  `apply_in_days` int(10) DEFAULT NULL,
  `org_id` varchar(10) DEFAULT NULL,
  `created_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `application_constrains`
--

INSERT INTO `application_constrains` (`id`, `app_name`, `app_id`, `apply_in_days`, `org_id`, `created_date`) VALUES
(2, 'leave', 2, 2, '02', '2017-09-22');

-- --------------------------------------------------------

--
-- Table structure for table `appraisal_development_plan`
--

CREATE TABLE `appraisal_development_plan` (
  `id` int(11) NOT NULL,
  `financial_year` varchar(50) NOT NULL,
  `emp_code` int(11) NOT NULL,
  `comp_code` varchar(40) NOT NULL,
  `self_areas_strength` text NOT NULL,
  `self_areas_development` text NOT NULL,
  `self_post_date` date NOT NULL,
  `appraiser_id` int(11) NOT NULL,
  `appraiser_comp_code` varchar(40) NOT NULL,
  `appraiser_areas_strength` text NOT NULL,
  `appraiser_areas_development` text NOT NULL,
  `appraiser_post_date` date NOT NULL,
  `higher_another_role` text NOT NULL,
  `reviewer_code` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `appraisal_process`
--

CREATE TABLE `appraisal_process` (
  `id` int(11) NOT NULL,
  `emp_code` varchar(40) NOT NULL,
  `appraiser_code` varchar(40) NOT NULL,
  `comp_code` varchar(40) NOT NULL,
  `financial_year` varchar(50) NOT NULL,
  `status` int(1) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `appraisal_req`
--

CREATE TABLE `appraisal_req` (
  `id` int(6) UNSIGNED NOT NULL,
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
  `review_degree` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `app_appraisers`
--

CREATE TABLE `app_appraisers` (
  `id` int(7) UNSIGNED NOT NULL,
  `request_id` varchar(30) DEFAULT NULL,
  `emp_code_appraiser` varchar(30) DEFAULT NULL,
  `dt_appraise` date DEFAULT NULL,
  `myprofile_id` varchar(20) DEFAULT NULL,
  `from_hr` int(10) DEFAULT NULL,
  `peer_appraiser` int(5) DEFAULT NULL,
  `skip_status` int(10) DEFAULT NULL,
  `sloc_id` varchar(22) DEFAULT NULL,
  `cloud_id` varchar(22) DEFAULT NULL,
  `ho_id` varchar(22) DEFAULT NULL,
  `ho_org_id` varchar(22) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `app_comments`
--

CREATE TABLE `app_comments` (
  `id` int(6) UNSIGNED NOT NULL,
  `appraiser_id` varchar(30) NOT NULL,
  `fac_comment` varchar(1000) DEFAULT NULL,
  `nu_performance` varchar(50) DEFAULT NULL,
  `commentt_conf` varchar(1000) DEFAULT NULL,
  `comment_training` varchar(1000) DEFAULT NULL,
  `amt_inc_recommended` varchar(15) DEFAULT NULL,
  `amt_inc_standard` varchar(15) DEFAULT NULL,
  `amt_inc_reason` varchar(200) DEFAULT NULL,
  `amt_reject_reason` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `app_eo_mst`
--

CREATE TABLE `app_eo_mst` (
  `eo_mst_sloc_id` int(2) DEFAULT NULL,
  `eo_mst_id` int(20) DEFAULT NULL,
  `eo_mst_nm` varchar(250) DEFAULT NULL,
  `eo_mst_alias` varchar(30) DEFAULT NULL,
  `eo_mst_leg_cd` varchar(30) DEFAULT NULL,
  `eo_mst_actv` varchar(1) DEFAULT NULL,
  `usr_id_create` int(4) DEFAULT NULL,
  `usr_id_create_dt` date DEFAULT NULL,
  `usr_id_mod` int(4) DEFAULT NULL,
  `usr_id_mod_dt` date DEFAULT NULL,
  `ss_id` int(10) DEFAULT NULL,
  `eo_org_id` varchar(2) DEFAULT NULL,
  `eo_ho_org_id` varchar(2) DEFAULT NULL,
  `eo_cld_id` varchar(4) DEFAULT NULL,
  `eo_mst_typ_mig` varchar(2) DEFAULT NULL,
  `eo_mst_src` varchar(3) DEFAULT NULL,
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `app_factors`
--

CREATE TABLE `app_factors` (
  `id` int(6) UNSIGNED NOT NULL,
  `factor_name` varchar(30) DEFAULT NULL,
  `factor_type` varchar(30) NOT NULL,
  `fac_order` varchar(50) NOT NULL,
  `fac_status` varchar(10) DEFAULT NULL,
  `department_id` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `app_factors_map`
--

CREATE TABLE `app_factors_map` (
  `id` int(11) NOT NULL,
  `app_factors_id` varchar(20) DEFAULT NULL,
  `myprofile_id` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `app_kras`
--

CREATE TABLE `app_kras` (
  `id` int(6) UNSIGNED NOT NULL,
  `target` varchar(500) DEFAULT NULL,
  `result_achieved` varchar(500) DEFAULT NULL,
  `remark` varchar(500) DEFAULT NULL,
  `request_id` varchar(50) DEFAULT NULL,
  `from_date` date DEFAULT NULL,
  `to_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `app_ratings`
--

CREATE TABLE `app_ratings` (
  `id` int(6) UNSIGNED NOT NULL,
  `appraiser_id` varchar(30) NOT NULL,
  `factor_id` varchar(30) NOT NULL,
  `rating_id` varchar(50) DEFAULT NULL,
  `remarks` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `app_slabs`
--

CREATE TABLE `app_slabs` (
  `id` int(6) UNSIGNED NOT NULL,
  `comp_code` varchar(30) DEFAULT NULL,
  `desg_code` varchar(30) DEFAULT NULL,
  `dept_code` varchar(50) DEFAULT NULL,
  `rating_id` varchar(50) DEFAULT NULL,
  `amt_inc` varchar(20) DEFAULT NULL,
  `slab_category_id` varchar(20) DEFAULT NULL,
  `department_id` int(11) DEFAULT NULL,
  `designation_id` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `app_slabs`
--

INSERT INTO `app_slabs` (`id`, `comp_code`, `desg_code`, `dept_code`, `rating_id`, `amt_inc`, `slab_category_id`, `department_id`, `designation_id`) VALUES
(1, '01', 'PAR0000017', 'DEPT00013', '1', '3000', '1', 13, 'PAR0000017'),
(2, '01', 'PAR0000017', 'DEPT00013', '2', '4000', '1', 13, 'PAR0000017'),
(3, '01', 'PAR0000017', 'DEPT00013', '3', '5000', '1', 13, 'PAR0000017'),
(4, '01', 'PAR0000017', 'DEPT00013', '4', '6000', '1', 13, 'PAR0000017'),
(5, '01', 'PAR0000017', 'DEPT00013', '5', '7000', '1', 13, 'PAR0000017');

-- --------------------------------------------------------

--
-- Table structure for table `app_slab_categories`
--

CREATE TABLE `app_slab_categories` (
  `id` int(6) UNSIGNED NOT NULL,
  `comp_code` varchar(30) DEFAULT NULL,
  `description` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `app_slab_categories`
--

INSERT INTO `app_slab_categories` (`id`, `comp_code`, `description`) VALUES
(1, '01', 'GENERAL'),
(2, '01', 'Developer'),
(3, '01', 'Technical Manager');

-- --------------------------------------------------------

--
-- Table structure for table `aros`
--

CREATE TABLE `aros` (
  `id` int(10) UNSIGNED NOT NULL,
  `parent_id` int(10) DEFAULT NULL,
  `model` varchar(255) DEFAULT '',
  `foreign_key` int(10) UNSIGNED DEFAULT NULL,
  `alias` varchar(255) DEFAULT '',
  `lft` int(10) DEFAULT NULL,
  `rght` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `aros`
--

INSERT INTO `aros` (`id`, `parent_id`, `model`, `foreign_key`, `alias`, `lft`, `rght`) VALUES
(1, NULL, 'Roles', 1, 'Employee', 1, 6),
(2, NULL, 'Roles', 2, 'Manager', 7, 10),
(3, NULL, 'Roles', 3, 'HR', 11, 14),
(4, 3, 'UserDetail', 209, 'UserDetail209', 12, 13),
(5, 1, 'UserDetail', 115, 'UserDetail115', 2, 3),
(6, 2, 'UserDetail', 427, 'UserDetail427', 8, 9),
(12, NULL, 'Roles', 7, 'Assigner', 15, 18),
(13, NULL, 'Roles', 8, 'Viewer', 19, 22),
(14, NULL, 'Roles', 9, 'Hawkeye', 23, 24),
(15, 12, 'UserDetail', 1, 'UserDetail1', 16, 17),
(16, 13, 'UserDetail', 2, 'UserDetail2', 20, 21),
(17, 1, 'UserDetail', 12740, 'UserDetail12740', 4, 5);

-- --------------------------------------------------------

--
-- Table structure for table `aros_acos`
--

CREATE TABLE `aros_acos` (
  `id` int(10) UNSIGNED NOT NULL,
  `aro_id` decimal(10,0) NOT NULL,
  `aco_id` decimal(10,0) NOT NULL,
  `_create` decimal(2,0) NOT NULL DEFAULT '0',
  `_read` decimal(2,0) NOT NULL DEFAULT '0',
  `_update` decimal(2,0) NOT NULL DEFAULT '0',
  `_delete` decimal(2,0) NOT NULL DEFAULT '0',
  `comp_code` varchar(40) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `aros_acos`
--

INSERT INTO `aros_acos` (`id`, `aro_id`, `aco_id`, `_create`, `_read`, `_update`, `_delete`, `comp_code`) VALUES
(1, '1', '1296', '1', '1', '1', '1', '01'),
(2, '1', '1299', '1', '1', '1', '1', '01'),
(3, '1', '1300', '1', '1', '1', '1', '01'),
(4, '1', '1301', '1', '1', '1', '1', '01'),
(5, '1', '1302', '1', '1', '1', '1', '01'),
(6, '1', '1303', '1', '1', '1', '1', '01'),
(7, '1', '1305', '1', '1', '1', '1', '01'),
(8, '1', '1318', '1', '1', '1', '1', '01'),
(9, '1', '1319', '1', '1', '1', '1', '01'),
(10, '1', '1298', '1', '1', '1', '1', '01'),
(11, '1', '209', '1', '1', '1', '1', '01'),
(12, '1', '1312', '1', '1', '1', '1', '01'),
(13, '1', '1317', '1', '1', '1', '1', '01'),
(14, '2', '1296', '1', '1', '1', '1', '01'),
(15, '2', '1299', '1', '1', '1', '1', '01'),
(16, '2', '1300', '1', '1', '1', '1', '01'),
(17, '2', '1301', '1', '1', '1', '1', '01'),
(18, '2', '1302', '1', '1', '1', '1', '01'),
(19, '2', '1303', '1', '1', '1', '1', '01'),
(20, '2', '1305', '1', '1', '1', '1', '01'),
(21, '2', '1318', '1', '1', '1', '1', '01'),
(22, '2', '1319', '1', '1', '1', '1', '01'),
(23, '2', '1298', '1', '1', '1', '1', '01'),
(24, '2', '209', '1', '1', '1', '1', '01'),
(25, '2', '1312', '1', '1', '1', '1', '01'),
(26, '2', '1317', '1', '1', '1', '1', '01'),
(27, '2', '1315', '1', '1', '1', '1', '01'),
(28, '2', '1316', '1', '1', '1', '1', '01'),
(29, '3', '1296', '1', '1', '1', '1', '01'),
(30, '3', '1299', '1', '1', '1', '1', '01'),
(31, '3', '1300', '1', '1', '1', '1', '01'),
(32, '3', '1301', '1', '1', '1', '1', '01'),
(33, '3', '1302', '1', '1', '1', '1', '01'),
(34, '3', '1303', '1', '1', '1', '1', '01'),
(35, '3', '1305', '1', '1', '1', '1', '01'),
(36, '3', '1318', '1', '1', '1', '1', '01'),
(37, '3', '1319', '1', '1', '1', '1', '01'),
(38, '3', '1298', '1', '1', '1', '1', '01'),
(39, '3', '209', '1', '1', '1', '1', '01'),
(40, '3', '1312', '1', '1', '1', '1', '01'),
(41, '3', '1317', '1', '1', '1', '1', '01'),
(42, '3', '1315', '1', '1', '1', '1', '01'),
(43, '3', '1316', '1', '1', '1', '1', '01'),
(44, '12', '2258', '1', '1', '1', '1', '1'),
(45, '12', '2259', '1', '1', '1', '1', '1'),
(46, '12', '2269', '1', '1', '1', '1', '1'),
(47, '12', '2274', '1', '1', '1', '1', '1'),
(48, '12', '2277', '1', '1', '1', '1', '1'),
(49, '12', '667', '-1', '-1', '-1', '-1', '-1'),
(50, '12', '2278', '1', '1', '1', '1', '1');

-- --------------------------------------------------------

--
-- Table structure for table `assign_competency_dept_desg`
--

CREATE TABLE `assign_competency_dept_desg` (
  `id` int(11) NOT NULL,
  `financial_year` varchar(50) NOT NULL,
  `emp_id` int(11) NOT NULL,
  `dept_id` varchar(25) NOT NULL,
  `desg_id` varchar(35) NOT NULL,
  `competency_id` int(11) NOT NULL,
  `ho_org_id` int(11) NOT NULL,
  `org_id` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_date` date NOT NULL,
  `updated_by` int(11) NOT NULL,
  `updated_date` date NOT NULL,
  `hcm_id` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `assign_competency_to_emp`
--

CREATE TABLE `assign_competency_to_emp` (
  `id` int(11) NOT NULL,
  `group_comp_id` int(11) DEFAULT NULL,
  `dept_id` varchar(40) NOT NULL,
  `desg_id` varchar(40) NOT NULL,
  `ho_org_id` int(11) NOT NULL,
  `org_id` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_date` date NOT NULL,
  `updated_by` int(11) NOT NULL,
  `updated_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `assign_comp_to_emp_details`
--

CREATE TABLE `assign_comp_to_emp_details` (
  `id` int(11) NOT NULL,
  `assign_comp_to_emp_id` int(11) NOT NULL,
  `emp_id` int(11) NOT NULL,
  `created_date` date NOT NULL,
  `updated_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `assign_desgination_kras`
--

CREATE TABLE `assign_desgination_kras` (
  `id` int(11) NOT NULL,
  `desg_name` varchar(250) DEFAULT NULL,
  `kra_id` int(11) DEFAULT NULL,
  `groups` varchar(100) DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `assign_group_to_desg`
--

CREATE TABLE `assign_group_to_desg` (
  `id` int(11) NOT NULL,
  `financial_year` varchar(50) NOT NULL,
  `group_comp_id` int(11) DEFAULT NULL,
  `dept_id` varchar(40) NOT NULL,
  `ho_org_id` int(11) NOT NULL,
  `org_id` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_date` date NOT NULL,
  `updated_by` int(11) NOT NULL,
  `updated_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `assign_group_to_desg_details`
--

CREATE TABLE `assign_group_to_desg_details` (
  `id` int(11) NOT NULL,
  `assign_group_to_desg_id` int(11) NOT NULL,
  `desg_id` varchar(40) NOT NULL,
  `created_date` date NOT NULL,
  `updated_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `attendance_details`
--

CREATE TABLE `attendance_details` (
  `id` int(10) NOT NULL,
  `cld_id` varchar(4) DEFAULT NULL,
  `sloc_id` int(10) DEFAULT NULL,
  `ho_org_id` varchar(2) DEFAULT NULL,
  `org_id` varchar(2) DEFAULT NULL,
  `description` varchar(1000) NOT NULL,
  `emp_doc_id` varchar(40) DEFAULT NULL,
  `atten_dt` date NOT NULL,
  `leave_id` varchar(20) DEFAULT NULL,
  `extra_time_hr` int(10) DEFAULT NULL,
  `usr_id_create` int(10) NOT NULL,
  `usr_id_create_dt` date NOT NULL,
  `usr_id_mod` int(10) DEFAULT NULL,
  `usr_id_mod_dt` date DEFAULT NULL,
  `in_time` timestamp NULL DEFAULT NULL,
  `out_time` timestamp NULL DEFAULT NULL,
  `ded_ch` varchar(1) DEFAULT NULL,
  `wk_off_chk` varchar(1) DEFAULT NULL,
  `hlfday_leave_chk` varchar(1) DEFAULT NULL,
  `emp_dept_id` varchar(20) DEFAULT NULL,
  `emp_grp_id` varchar(20) DEFAULT NULL,
  `emp_loc_id` varchar(20) DEFAULT NULL,
  `emp_id` varchar(20) DEFAULT NULL,
  `add_comp_leave_chk` varchar(1) DEFAULT NULL,
  `qtr_leave_chk` varchar(1) DEFAULT NULL,
  `leave_proof_submit_chk` varchar(1) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '5',
  `approver_id` varchar(255) NOT NULL,
  `reject_remark` varchar(255) DEFAULT NULL,
  `is_od` varchar(20) DEFAULT NULL,
  `latitude` varchar(50) DEFAULT NULL,
  `longitude` varchar(50) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Triggers `attendance_details`
--
DELIMITER $$
CREATE TRIGGER `atten_update` AFTER UPDATE ON `attendance_details` FOR EACH ROW if NEW.status = 5 then
IF @DISABLE_TRIGGERS IS NULL THEN
	INSERT INTO newdata VALUES (NEW.`id`,'attendance_details','U');
END IF;
end if
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `attendance` AFTER INSERT ON `attendance_details` FOR EACH ROW if NEW.status = 5 then
IF @DISABLE_TRIGGERS IS NULL THEN
	INSERT INTO newdata VALUES (NEW.`id`,'attendance_details','I');
END IF;
end if
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `attendance_detail_dtl`
--

CREATE TABLE `attendance_detail_dtl` (
  `id` int(11) NOT NULL,
  `cld_id` varchar(10) DEFAULT NULL,
  `sloc_id` int(10) DEFAULT NULL,
  `ho_org_id` varchar(10) DEFAULT NULL,
  `org_id` varchar(10) DEFAULT NULL,
  `emp_doc_id` varchar(40) DEFAULT NULL,
  `atten_dt` date DEFAULT NULL,
  `leave_id` varchar(20) DEFAULT NULL,
  `extra_time_hr` int(30) DEFAULT NULL,
  `usr_id_create` int(11) DEFAULT NULL,
  `usr_id_create_dt` date DEFAULT NULL,
  `usr_id_mod` int(11) DEFAULT NULL,
  `usr_id_mod_dt` date DEFAULT NULL,
  `in_time` varchar(20) DEFAULT NULL,
  `out_time` varchar(20) DEFAULT NULL,
  `ded_ch` varchar(20) DEFAULT NULL,
  `wk_off_chk` varchar(10) DEFAULT NULL,
  `hlfday_leave_chk` varchar(10) DEFAULT NULL,
  `emp_dept_id` varchar(20) DEFAULT NULL,
  `emp_grp_id` varchar(20) DEFAULT NULL,
  `emp_loc_id` varchar(20) DEFAULT NULL,
  `emp_id` varchar(20) DEFAULT NULL,
  `add_comp_leave_chk` varchar(10) DEFAULT NULL,
  `qtr_leave_chk` varchar(10) DEFAULT NULL,
  `leave_proof_submit_chk` varchar(10) DEFAULT NULL,
  `prj_doc_id` varchar(40) DEFAULT NULL,
  `rest_day_chk` varchar(20) NOT NULL DEFAULT 'N'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `attendance_with_location`
--

CREATE TABLE `attendance_with_location` (
  `id` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `latitude` varchar(50) DEFAULT NULL,
  `longitude` varchar(50) DEFAULT NULL,
  `in_radius` varchar(25) NOT NULL,
  `comp_code` varchar(11) NOT NULL,
  `org_id` varchar(11) NOT NULL,
  `location_code` varchar(50) NOT NULL,
  `created_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `attribute_type`
--

CREATE TABLE `attribute_type` (
  `id` int(20) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `at_status` int(5) DEFAULT NULL,
  `att_type_id` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `audit_trail`
--

CREATE TABLE `audit_trail` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `ip` varchar(4000) DEFAULT NULL,
  `browser` varchar(4000) DEFAULT NULL,
  `time` datetime DEFAULT NULL,
  `action` varchar(45) DEFAULT NULL,
  `other` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `block`
--

CREATE TABLE `block` (
  `id` int(11) DEFAULT NULL,
  `page_id` int(22) DEFAULT NULL,
  `name` int(10) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `solc_id` varchar(25) DEFAULT NULL,
  `cld_id` varchar(22) DEFAULT NULL,
  `ho_org_id` varchar(22) DEFAULT NULL,
  `org_id` varchar(22) DEFAULT NULL,
  `emp_doc_id` varchar(52) DEFAULT NULL,
  `doc_id` varchar(52) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `bm_data_type`
--

CREATE TABLE `bm_data_type` (
  `id` int(11) NOT NULL,
  `datatype` varchar(100) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0' COMMENT '0="Active", 1="Inactive"',
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `solc_id` varchar(25) DEFAULT NULL,
  `cld_id` varchar(22) DEFAULT NULL,
  `ho_org_id` varchar(22) DEFAULT NULL,
  `org_id` varchar(22) DEFAULT NULL,
  `emp_doc_id` varchar(52) DEFAULT NULL,
  `doc_id` varchar(52) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `bm_data_type_details`
--

CREATE TABLE `bm_data_type_details` (
  `id` int(11) NOT NULL,
  `data_type_id` int(11) NOT NULL,
  `serial_num` varchar(100) NOT NULL,
  `id_no` varchar(100) NOT NULL,
  `p_no` varchar(100) NOT NULL,
  `title` int(11) NOT NULL,
  `surname` varchar(100) NOT NULL,
  `firstname` varchar(100) NOT NULL,
  `other_name` varchar(100) NOT NULL,
  `dob` date NOT NULL,
  `gender` int(11) NOT NULL COMMENT '0=''Male'',1=''Female''',
  `qualification` varchar(255) NOT NULL,
  `promotion_type` int(11) DEFAULT NULL,
  `secondment_transfer_id` int(11) DEFAULT NULL,
  `retirement_ground_id` int(11) DEFAULT NULL,
  `academic` text,
  `professional` text,
  `experience` text,
  `physical_disability` int(11) DEFAULT NULL,
  `disable_details` text,
  `ministry_id` int(11) NOT NULL,
  `department_code` varchar(100) NOT NULL,
  `d_o_appointment` date NOT NULL,
  `d_o_c_appointment` date NOT NULL,
  `currenct_designation` varchar(100) NOT NULL,
  `recommended_designation` varchar(100) DEFAULT NULL,
  `recomm_term_services` varchar(200) NOT NULL,
  `justification` text NOT NULL,
  `notes` text NOT NULL,
  `status` int(11) NOT NULL COMMENT '0=''Active'',1=''Inactive''',
  `created_by` int(11) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `bm_meeting_request`
--

CREATE TABLE `bm_meeting_request` (
  `id` int(11) NOT NULL,
  `meeting_number` varchar(200) NOT NULL,
  `subject` text NOT NULL,
  `request_receive_id` varchar(200) NOT NULL,
  `meeting_date` date NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0' COMMENT '0=''Active'' , 1=''Inactive''',
  `created_by` varchar(200) NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `bm_meeting_request_refnum`
--

CREATE TABLE `bm_meeting_request_refnum` (
  `id` int(11) NOT NULL,
  `meeting_request_id` int(11) NOT NULL,
  `transfer_commitee` varchar(200) DEFAULT NULL COMMENT 'department code',
  `request_receive_id` varchar(200) NOT NULL,
  `finalize_status` int(11) NOT NULL DEFAULT '0' COMMENT '0=''Not final'', 1=''final''',
  `status` int(11) NOT NULL DEFAULT '0' COMMENT '0=''Active'' , 1=''Inactive''',
  `created_by` varchar(200) NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `bm_receive_request`
--

CREATE TABLE `bm_receive_request` (
  `id` int(11) NOT NULL,
  `request_type_id` int(11) NOT NULL,
  `dept_code` varchar(200) NOT NULL,
  `action_officer_id` int(11) NOT NULL,
  `signatory_id` int(11) NOT NULL,
  `reference_num` varchar(200) NOT NULL,
  `subject` text NOT NULL,
  `date_of_request` date NOT NULL,
  `date_of_receive` date NOT NULL,
  `final_status` int(11) NOT NULL DEFAULT '0' COMMENT '0="Not final" , 1="final"',
  `status` int(11) NOT NULL DEFAULT '1' COMMENT '1="Active", 0="Inactive"',
  `created_by` int(11) NOT NULL COMMENT 'use MyProfile ID',
  `forward_to` int(11) NOT NULL COMMENT 'use MyProfile ID',
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `bm_receive_request_forward`
--

CREATE TABLE `bm_receive_request_forward` (
  `id` int(11) NOT NULL,
  `request_receive_id` int(11) NOT NULL,
  `req_receive_by` varchar(200) NOT NULL,
  `req_forward_by` varchar(200) NOT NULL,
  `forward_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `frwd_status` int(11) NOT NULL DEFAULT '0' COMMENT '0=''current_request_holder'' , 1=''old_request_holder''',
  `stastus` int(11) NOT NULL DEFAULT '0' COMMENT '0="Active", 1="Inactive"'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `bm_recruitment_final`
--

CREATE TABLE `bm_recruitment_final` (
  `id` int(11) NOT NULL,
  `request_type_id` int(11) NOT NULL,
  `serial_num` varchar(200) NOT NULL,
  `subject` text NOT NULL,
  `date_of_received` date NOT NULL,
  `num_of_candidates` int(11) NOT NULL,
  `notes` text,
  `status` int(11) NOT NULL DEFAULT '1' COMMENT '1="Active", 0="Inactive"',
  `created_by` int(11) NOT NULL COMMENT 'use MyProfile ID',
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `bm_report_type_attachment`
--

CREATE TABLE `bm_report_type_attachment` (
  `id` int(11) NOT NULL,
  `data_type_id` int(11) NOT NULL,
  `upload_date` date NOT NULL,
  `remark` text NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0' COMMENT '0=''Active'' , 1=''Inactive''',
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `bm_report_type_attach_files`
--

CREATE TABLE `bm_report_type_attach_files` (
  `id` int(11) NOT NULL,
  `report_type_attach_id` int(11) NOT NULL,
  `attach_file` varchar(200) NOT NULL,
  `folder_name` varchar(200) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0' COMMENT '0=''Active'' , 1=''Inactive''',
  `created_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `bm_request_details`
--

CREATE TABLE `bm_request_details` (
  `id` int(11) NOT NULL,
  `serial_num` varchar(100) NOT NULL,
  `request_id` int(11) NOT NULL,
  `id_no` varchar(100) NOT NULL,
  `p_no` varchar(100) NOT NULL,
  `title` int(11) NOT NULL,
  `surname` varchar(100) NOT NULL,
  `firstname` varchar(100) NOT NULL,
  `other_name` varchar(100) NOT NULL,
  `dob` date NOT NULL,
  `gender` int(11) NOT NULL COMMENT '0=''Male'',1=''Female''',
  `data_entry_type` int(11) NOT NULL,
  `academic` text,
  `professional` text,
  `experience` text,
  `physical_disability` int(11) NOT NULL,
  `disable_details` text,
  `ministry_id` int(11) NOT NULL,
  `department_code` varchar(100) NOT NULL,
  `d_o_appointment` date NOT NULL,
  `d_o_c_appointment` date NOT NULL,
  `currenct_designation` varchar(100) NOT NULL,
  `recommended_designation` varchar(100) NOT NULL,
  `recomm_term_services` varchar(200) NOT NULL,
  `justification` text NOT NULL,
  `notes` text NOT NULL,
  `status` int(11) NOT NULL COMMENT '0=''Active'',1=''Inactive''',
  `created_by` int(11) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `bm_title`
--

CREATE TABLE `bm_title` (
  `id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0' COMMENT '0="Active", 1="Inactive"',
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `solc_id` varchar(25) DEFAULT NULL,
  `cld_id` varchar(22) DEFAULT NULL,
  `ho_org_id` varchar(22) DEFAULT NULL,
  `org_id` varchar(22) DEFAULT NULL,
  `emp_doc_id` varchar(52) DEFAULT NULL,
  `doc_id` varchar(52) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `catagory`
--

CREATE TABLE `catagory` (
  `id` int(11) NOT NULL,
  `org_id` varchar(20) NOT NULL,
  `catagory_desc` varchar(30) NOT NULL,
  `cat_gallery` int(11) NOT NULL COMMENT '1= for gallery type,0=not gallery type',
  `created_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `solc_id` varchar(25) DEFAULT NULL,
  `cld_id` varchar(22) DEFAULT NULL,
  `ho_org_id` varchar(22) DEFAULT NULL,
  `org_id` varchar(22) DEFAULT NULL,
  `emp_doc_id` varchar(52) DEFAULT NULL,
  `doc_id` varchar(52) DEFAULT NULL,
  `parent_id` int(10) DEFAULT NULL,
  `lft` int(10) DEFAULT NULL,
  `rght` int(10) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `file` varchar(250) DEFAULT NULL,
  `file_alias_name` varchar(100) NOT NULL,
  `doc_receiving_date` date NOT NULL,
  `remark` text NOT NULL,
  `public_doc` varchar(100) NOT NULL DEFAULT '0' COMMENT '0="Not Public" , 1="Public doc"',
  `doc_reference_num` varchar(100) NOT NULL COMMENT 'Document and file reference number',
  `created_by` varchar(200) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `modify_date` datetime NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1' COMMENT '1=''Active'' , 0=''Inactive''',
  `file_req_status` int(11) NOT NULL DEFAULT '1' COMMENT '1="Ready for Request" , 2="Under Used"'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `solc_id`, `cld_id`, `ho_org_id`, `org_id`, `emp_doc_id`, `doc_id`, `parent_id`, `lft`, `rght`, `name`, `file`, `file_alias_name`, `doc_receiving_date`, `remark`, `public_doc`, `doc_reference_num`, `created_by`, `created_date`, `modify_date`, `status`, `file_req_status`) VALUES
(1, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 38, 'PSC', NULL, '', '0000-00-00', 'This is the ROOT folder !!', '0', '', '', '2017-04-18 11:32:58', '0000-00-00 00:00:00', 1, 1),
(2, NULL, NULL, NULL, NULL, NULL, NULL, 1, 2, 7, 'sub folders', NULL, '', '0000-00-00', 'this is remark', '0', 'PSC1482841125', '', '2016-12-19 09:03:57', '0000-00-00 00:00:00', 1, 1),
(3, NULL, NULL, NULL, NULL, NULL, NULL, 2, 3, 4, NULL, 'time.txt', '', '0000-00-00', 'my time', '1', 'PSC/sub folders/time.txt', '', '2016-12-17 06:12:56', '0000-00-00 00:00:00', 1, 1),
(4, NULL, NULL, NULL, NULL, NULL, NULL, 1, 8, 31, 'Demo1', NULL, '', '0000-00-00', '', '0', 'PSC1482218843', '', '2017-04-18 11:32:58', '0000-00-00 00:00:00', 1, 1),
(5, NULL, NULL, NULL, NULL, NULL, NULL, 4, 9, 10, NULL, 'time.txt', '', '0000-00-00', '', '0', 'PSC/Demo1/time.txt', '', '2016-12-19 09:03:57', '0000-00-00 00:00:00', 1, 1),
(6, NULL, NULL, NULL, NULL, NULL, NULL, 4, 11, 12, NULL, 'testingggz.txt', '', '0000-00-00', '', '0', 'PSC/Demo1/testingggz.txt', '', '2016-12-19 09:03:57', '0000-00-00 00:00:00', 1, 1),
(7, NULL, NULL, NULL, NULL, NULL, NULL, 4, 13, 14, NULL, 'testing.txt', '', '0000-00-00', '', '0', 'PSC/Demo1/testing.txt', '', '2016-12-19 09:03:57', '0000-00-00 00:00:00', 1, 1),
(8, NULL, NULL, NULL, NULL, NULL, NULL, 4, 15, 16, NULL, 'timesheettt.txt', '', '0000-00-00', '', '0', 'PSC/Demo1/timesheettt.txt', '', '2016-12-19 09:03:57', '0000-00-00 00:00:00', 1, 1),
(9, NULL, NULL, NULL, NULL, NULL, NULL, 4, 17, 18, NULL, 'LoginCredential.txt', '', '0000-00-00', 'asdf', '0', 'PSC/Demo1/LoginCredential.txt', '', '2016-12-19 09:03:57', '0000-00-00 00:00:00', 1, 1),
(10, NULL, NULL, NULL, NULL, NULL, NULL, 4, 19, 20, NULL, 'testinggg.txt', '', '0000-00-00', '', '0', 'PSC/Demo1/testinggg.txt', '', '2016-12-19 09:03:57', '0000-00-00 00:00:00', 1, 1),
(11, NULL, NULL, NULL, NULL, NULL, NULL, 4, 21, 22, NULL, 'timesheett.txt', '', '0000-00-00', '', '0', 'PSC/Demo1/timesheett.txt', '', '2016-12-19 09:03:57', '0000-00-00 00:00:00', 1, 1),
(12, NULL, NULL, NULL, NULL, NULL, NULL, 4, 23, 24, NULL, 'timesheettbbx.txt', '', '0000-00-00', '', '0', 'PSC/Demo1/timesheettbbx.txt', '', '2016-12-19 09:03:57', '0000-00-00 00:00:00', 1, 1),
(13, NULL, NULL, NULL, NULL, NULL, NULL, 4, 25, 26, NULL, 'downloaded.pdf', 'ppddff', '0000-00-00', '', '1', 'PSC/Demo1/downloaded.pdf', '', '2016-12-19 09:03:57', '0000-00-00 00:00:00', 1, 1),
(14, NULL, NULL, NULL, NULL, NULL, NULL, 4, 27, 28, NULL, 'Tulips.jpg', 'ttuull', '0000-00-00', '', '1', 'PSC/Demo1/Tulips.jpg', '', '2016-12-19 09:03:57', '0000-00-00 00:00:00', 1, 1),
(15, NULL, NULL, NULL, NULL, NULL, NULL, 1, 32, 35, 'Great', NULL, '', '0000-00-00', 'asdfdsdsa', '0', 'PSC1482861960', '', '2017-04-18 11:32:58', '0000-00-00 00:00:00', 1, 1),
(16, NULL, NULL, NULL, NULL, NULL, NULL, 15, 33, 34, NULL, 'time.txt', 'TT', '0000-00-00', 'afadsfasdf', '1', 'PSC/Great/time.txt', '', '2017-04-18 11:32:58', '0000-00-00 00:00:00', 1, 1),
(17, NULL, NULL, NULL, NULL, NULL, NULL, 2, 5, 6, NULL, 'IMG_20161009_132947.jpg', 'Aytush', '0000-00-00', 'test', '1', 'PSC/sub folders/IMG_20161009_132947.jpg', '', '2016-12-19 09:03:57', '0000-00-00 00:00:00', 1, 1),
(18, NULL, NULL, NULL, NULL, NULL, NULL, 1, 36, 37, 'Tes fold', NULL, '', '0000-00-00', 'adsfasdf', '0', 'PSC1482886362', '', '2017-04-18 11:32:58', '0000-00-00 00:00:00', 1, 1),
(19, NULL, NULL, NULL, NULL, NULL, NULL, 4, 29, 30, NULL, 'Screenshotfrom2017-02-2417:02:37-18042017170258.png', 'dijkajdljdlkjdkkdl', '2017-04-13', 'ejnkdj', '1', 'PSC/Demo1/Screenshotfrom2017-02-2417:02:37-18042017170258.png', '', '2017-04-18 11:32:58', '0000-00-00 00:00:00', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `cities`
--

CREATE TABLE `cities` (
  `id` int(11) NOT NULL,
  `city_name` varchar(30) NOT NULL,
  `state_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `city_group`
--

CREATE TABLE `city_group` (
  `id` int(10) NOT NULL,
  `group_name` varchar(100) NOT NULL,
  `status` varchar(10) DEFAULT NULL,
  `created_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `city_group`
--

INSERT INTO `city_group` (`id`, `group_name`, `status`, `created_date`) VALUES
(1, 'CLASS A CITY', '1', '2017-09-16'),
(2, 'CLASS B CITY', '1', '2017-09-16');

-- --------------------------------------------------------

--
-- Table structure for table `city_master`
--

CREATE TABLE `city_master` (
  `id` int(10) NOT NULL,
  `city_name` varchar(100) NOT NULL,
  `group_id` int(10) NOT NULL,
  `status` varchar(10) DEFAULT NULL,
  `created` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `city_master`
--

INSERT INTO `city_master` (`id`, `city_name`, `group_id`, `status`, `created`) VALUES
(1, 'LUCKNOW', 1, '1', '2017-09-15'),
(2, 'DELHI', 1, '1', '2017-09-15'),
(3, 'PILIBHIT', 2, '1', '2017-09-15');

-- --------------------------------------------------------

--
-- Table structure for table `competency`
--

CREATE TABLE `competency` (
  `id` int(11) NOT NULL,
  `competency_name` varchar(100) NOT NULL,
  `description` varchar(250) NOT NULL,
  `status` int(1) NOT NULL,
  `ho_org_id` int(11) NOT NULL,
  `org_id` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_date` datetime NOT NULL,
  `updated_by` int(11) NOT NULL,
  `updated_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `competency_hcm_group_masters`
--

CREATE TABLE `competency_hcm_group_masters` (
  `id` int(11) NOT NULL,
  `competency_id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `competency_rating`
--

CREATE TABLE `competency_rating` (
  `id` int(5) NOT NULL,
  `ho_org_id` varchar(40) NOT NULL,
  `org_id` varchar(40) NOT NULL,
  `rating_scale` int(1) NOT NULL,
  `achievement_from` int(2) NOT NULL,
  `achievement_to` int(2) DEFAULT NULL,
  `comment` text,
  `status` int(1) NOT NULL,
  `created_date` date NOT NULL,
  `created_by` varchar(40) NOT NULL,
  `is_deleted` int(1) NOT NULL,
  `deleted_date` date NOT NULL,
  `deleted_by` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `competency_target`
--

CREATE TABLE `competency_target` (
  `id` int(11) NOT NULL,
  `competency_id` int(11) NOT NULL,
  `financial_year` varchar(50) NOT NULL,
  `emp_code` int(11) NOT NULL,
  `comp_code` varchar(40) NOT NULL,
  `appraiser_id` int(11) NOT NULL,
  `appraiser_comp_code` varchar(40) NOT NULL,
  `appraiser_rating` int(2) NOT NULL,
  `appraiser_comment` text NOT NULL,
  `appraiser_post_date` date NOT NULL,
  `reviewer_id` int(11) NOT NULL,
  `reviewer_comp_code` varchar(40) NOT NULL,
  `reviewer_post_date` date NOT NULL,
  `reviewer_rating` int(2) DEFAULT NULL,
  `reviewer_comment` text NOT NULL,
  `moderator_id` int(11) NOT NULL,
  `moderator_post_date` date NOT NULL,
  `moderator_rating` int(2) NOT NULL,
  `moderator_comment` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `competency_type`
--

CREATE TABLE `competency_type` (
  `id` int(1) NOT NULL,
  `competency_type` int(1) NOT NULL,
  `competency_type_value` varchar(15) NOT NULL,
  `created_date` datetime NOT NULL,
  `updated_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `competency_type`
--

INSERT INTO `competency_type` (`id`, `competency_type`, `competency_type_value`, `created_date`, `updated_date`) VALUES
(1, 2, 'Pre Define', '2016-10-19 00:00:00', '2016-10-19 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `compitency_behaviour`
--

CREATE TABLE `compitency_behaviour` (
  `id` int(11) NOT NULL,
  `compitency_id` int(11) NOT NULL,
  `behaviour_desc` text NOT NULL,
  `status` int(1) NOT NULL,
  `ho_org_id` int(11) NOT NULL,
  `org_id` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_date` datetime NOT NULL,
  `updated_by` int(11) NOT NULL,
  `updated_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `comp_off_leave_trans`
--

CREATE TABLE `comp_off_leave_trans` (
  `id` int(100) NOT NULL,
  `cld_id` varchar(4) DEFAULT NULL,
  `sloc_id` int(2) DEFAULT NULL,
  `ho_org_id` varchar(2) DEFAULT NULL,
  `org_id` varchar(2) DEFAULT NULL,
  `doc_id` varchar(40) DEFAULT NULL,
  `emp_doc_id` varchar(40) DEFAULT NULL,
  `comp_off_dt` date DEFAULT NULL,
  `leave_id` varchar(20) DEFAULT NULL,
  `in_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `out_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `extra_time_hr` varchar(10) DEFAULT NULL,
  `valid_strt_dt` date DEFAULT NULL,
  `valid_end_dt` date DEFAULT NULL,
  `comp_off_dys` int(10) DEFAULT NULL,
  `util_chk` char(1) DEFAULT NULL,
  `util_dt` date DEFAULT NULL,
  `usr_id_create` int(10) DEFAULT NULL,
  `usr_id_create_dt` date DEFAULT NULL,
  `usr_id_mod` int(10) DEFAULT NULL,
  `usr_id_mod_dt` date DEFAULT NULL,
  `rem_bal` int(10) DEFAULT NULL,
  `curr_util_chk` char(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `conveyence_workflow`
--

CREATE TABLE `conveyence_workflow` (
  `id` int(10) NOT NULL,
  `voucher_id` int(10) DEFAULT NULL,
  `emp_code` varchar(40) DEFAULT NULL,
  `fw_date` date DEFAULT NULL,
  `remark` text,
  `approval_date` date DEFAULT NULL,
  `status` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE `countries` (
  `id` int(11) NOT NULL,
  `short_name` varchar(3) NOT NULL,
  `country_name` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`id`, `short_name`, `country_name`) VALUES
(1, 'AF', 'Afghanistan'),
(2, 'AL', 'Albania'),
(3, 'DZ', 'Algeria'),
(4, 'AS', 'American Samoa'),
(5, 'AD', 'Andorra'),
(6, 'AO', 'Angola'),
(7, 'AI', 'Anguilla'),
(8, 'AQ', 'Antarctica'),
(9, 'AG', 'Antigua And Barbuda'),
(10, 'AR', 'Argentina'),
(11, 'AM', 'Armenia'),
(12, 'AW', 'Aruba'),
(13, 'AU', 'Australia'),
(14, 'AT', 'Austria'),
(15, 'AZ', 'Azerbaijan'),
(16, 'BS', 'Bahamas The'),
(17, 'BH', 'Bahrain'),
(18, 'BD', 'Bangladesh'),
(19, 'BB', 'Barbados'),
(20, 'BY', 'Belarus'),
(21, 'BE', 'Belgium'),
(22, 'BZ', 'Belize'),
(23, 'BJ', 'Benin'),
(24, 'BM', 'Bermuda'),
(25, 'BT', 'Bhutan'),
(26, 'BO', 'Bolivia'),
(27, 'BA', 'Bosnia and Herzegovina'),
(28, 'BW', 'Botswana'),
(29, 'BV', 'Bouvet Island'),
(30, 'BR', 'Brazil'),
(31, 'IO', 'British Indian Ocean Territory'),
(32, 'BN', 'Brunei'),
(33, 'BG', 'Bulgaria'),
(34, 'BF', 'Burkina Faso'),
(35, 'BI', 'Burundi'),
(36, 'KH', 'Cambodia'),
(37, 'CM', 'Cameroon'),
(38, 'CA', 'Canada'),
(39, 'CV', 'Cape Verde'),
(40, 'KY', 'Cayman Islands'),
(41, 'CF', 'Central African Republic'),
(42, 'TD', 'Chad'),
(43, 'CL', 'Chile'),
(44, 'CN', 'China'),
(45, 'CX', 'Christmas Island'),
(46, 'CC', 'Cocos (Keeling) Islands'),
(47, 'CO', 'Colombia'),
(48, 'KM', 'Comoros'),
(49, 'CG', 'Congo'),
(50, 'CD', 'Congo The Democratic Republic Of The'),
(51, 'CK', 'Cook Islands'),
(52, 'CR', 'Costa Rica'),
(53, 'CI', 'Cote D\Ivoire (Ivory Coast)'),
(54, 'HR', 'Croatia (Hrvatska)'),
(55, 'CU', 'Cuba'),
(56, 'CY', 'Cyprus'),
(57, 'CZ', 'Czech Republic'),
(58, 'DK', 'Denmark'),
(59, 'DJ', 'Djibouti'),
(60, 'DM', 'Dominica'),
(61, 'DO', 'Dominican Republic'),
(62, 'TP', 'East Timor'),
(63, 'EC', 'Ecuador'),
(64, 'EG', 'Egypt'),
(65, 'SV', 'El Salvador'),
(66, 'GQ', 'Equatorial Guinea'),
(67, 'ER', 'Eritrea'),
(68, 'EE', 'Estonia'),
(69, 'ET', 'Ethiopia'),
(70, 'XA', 'External Territories of Australia'),
(71, 'FK', 'Falkland Islands'),
(72, 'FO', 'Faroe Islands'),
(73, 'FJ', 'Fiji Islands'),
(74, 'FI', 'Finland'),
(75, 'FR', 'France'),
(76, 'GF', 'French Guiana'),
(77, 'PF', 'French Polynesia'),
(78, 'TF', 'French Southern Territories'),
(79, 'GA', 'Gabon'),
(80, 'GM', 'Gambia The'),
(81, 'GE', 'Georgia'),
(82, 'DE', 'Germany'),
(83, 'GH', 'Ghana'),
(84, 'GI', 'Gibraltar'),
(85, 'GR', 'Greece'),
(86, 'GL', 'Greenland'),
(87, 'GD', 'Grenada'),
(88, 'GP', 'Guadeloupe'),
(89, 'GU', 'Guam'),
(90, 'GT', 'Guatemala'),
(91, 'XU', 'Guernsey and Alderney'),
(92, 'GN', 'Guinea'),
(93, 'GW', 'Guinea-Bissau'),
(94, 'GY', 'Guyana'),
(95, 'HT', 'Haiti'),
(96, 'HM', 'Heard and McDonald Islands'),
(97, 'HN', 'Honduras'),
(98, 'HK', 'Hong Kong S.A.R.'),
(99, 'HU', 'Hungary'),
(100, 'IS', 'Iceland'),
(101, 'IN', 'India'),
(102, 'ID', 'Indonesia'),
(103, 'IR', 'Iran'),
(104, 'IQ', 'Iraq'),
(105, 'IE', 'Ireland'),
(106, 'IL', 'Israel'),
(107, 'IT', 'Italy'),
(108, 'JM', 'Jamaica'),
(109, 'JP', 'Japan'),
(110, 'XJ', 'Jersey'),
(111, 'JO', 'Jordan'),
(112, 'KZ', 'Kazakhstan'),
(113, 'KE', 'Kenya'),
(114, 'KI', 'Kiribati'),
(115, 'KP', 'Korea North'),
(116, 'KR', 'Korea South'),
(117, 'KW', 'Kuwait'),
(118, 'KG', 'Kyrgyzstan'),
(119, 'LA', 'Laos'),
(120, 'LV', 'Latvia'),
(121, 'LB', 'Lebanon'),
(122, 'LS', 'Lesotho'),
(123, 'LR', 'Liberia'),
(124, 'LY', 'Libya'),
(125, 'LI', 'Liechtenstein'),
(126, 'LT', 'Lithuania'),
(127, 'LU', 'Luxembourg'),
(128, 'MO', 'Macau S.A.R.'),
(129, 'MK', 'Macedonia'),
(130, 'MG', 'Madagascar'),
(131, 'MW', 'Malawi'),
(132, 'MY', 'Malaysia'),
(133, 'MV', 'Maldives'),
(134, 'ML', 'Mali'),
(135, 'MT', 'Malta'),
(136, 'XM', 'Man (Isle of)'),
(137, 'MH', 'Marshall Islands'),
(138, 'MQ', 'Martinique'),
(139, 'MR', 'Mauritania'),
(140, 'MU', 'Mauritius'),
(141, 'YT', 'Mayotte'),
(142, 'MX', 'Mexico'),
(143, 'FM', 'Micronesia'),
(144, 'MD', 'Moldova'),
(145, 'MC', 'Monaco'),
(146, 'MN', 'Mongolia'),
(147, 'MS', 'Montserrat'),
(148, 'MA', 'Morocco'),
(149, 'MZ', 'Mozambique'),
(150, 'MM', 'Myanmar'),
(151, 'NA', 'Namibia'),
(152, 'NR', 'Nauru'),
(153, 'NP', 'Nepal'),
(154, 'AN', 'Netherlands Antilles'),
(155, 'NL', 'Netherlands The'),
(156, 'NC', 'New Caledonia'),
(157, 'NZ', 'New Zealand'),
(158, 'NI', 'Nicaragua'),
(159, 'NE', 'Niger'),
(160, 'NG', 'Nigeria'),
(161, 'NU', 'Niue'),
(162, 'NF', 'Norfolk Island'),
(163, 'MP', 'Northern Mariana Islands'),
(164, 'NO', 'Norway'),
(165, 'OM', 'Oman'),
(166, 'PK', 'Pakistan'),
(167, 'PW', 'Palau'),
(168, 'PS', 'Palestinian Territory Occupied'),
(169, 'PA', 'Panama'),
(170, 'PG', 'Papua new Guinea'),
(171, 'PY', 'Paraguay'),
(172, 'PE', 'Peru'),
(173, 'PH', 'Philippines'),
(174, 'PN', 'Pitcairn Island'),
(175, 'PL', 'Poland'),
(176, 'PT', 'Portugal'),
(177, 'PR', 'Puerto Rico'),
(178, 'QA', 'Qatar'),
(179, 'RE', 'Reunion'),
(180, 'RO', 'Romania'),
(181, 'RU', 'Russia'),
(182, 'RW', 'Rwanda'),
(183, 'SH', 'Saint Helena'),
(184, 'KN', 'Saint Kitts And Nevis'),
(185, 'LC', 'Saint Lucia'),
(186, 'PM', 'Saint Pierre and Miquelon'),
(187, 'VC', 'Saint Vincent And The Grenadines'),
(188, 'WS', 'Samoa'),
(189, 'SM', 'San Marino'),
(190, 'ST', 'Sao Tome and Principe'),
(191, 'SA', 'Saudi Arabia'),
(192, 'SN', 'Senegal'),
(193, 'RS', 'Serbia'),
(194, 'SC', 'Seychelles'),
(195, 'SL', 'Sierra Leone'),
(196, 'SG', 'Singapore'),
(197, 'SK', 'Slovakia'),
(198, 'SI', 'Slovenia'),
(199, 'XG', 'Smaller Territories of the UK'),
(200, 'SB', 'Solomon Islands'),
(201, 'SO', 'Somalia'),
(202, 'ZA', 'South Africa'),
(203, 'GS', 'South Georgia'),
(204, 'SS', 'South Sudan'),
(205, 'ES', 'Spain'),
(206, 'LK', 'Sri Lanka'),
(207, 'SD', 'Sudan'),
(208, 'SR', 'Suriname'),
(209, 'SJ', 'Svalbard And Jan Mayen Islands'),
(210, 'SZ', 'Swaziland'),
(211, 'SE', 'Sweden'),
(212, 'CH', 'Switzerland'),
(213, 'SY', 'Syria'),
(214, 'TW', 'Taiwan'),
(215, 'TJ', 'Tajikistan'),
(216, 'TZ', 'Tanzania'),
(217, 'TH', 'Thailand'),
(218, 'TG', 'Togo'),
(219, 'TK', 'Tokelau'),
(220, 'TO', 'Tonga'),
(221, 'TT', 'Trinidad And Tobago'),
(222, 'TN', 'Tunisia'),
(223, 'TR', 'Turkey'),
(224, 'TM', 'Turkmenistan'),
(225, 'TC', 'Turks And Caicos Islands'),
(226, 'TV', 'Tuvalu'),
(227, 'UG', 'Uganda'),
(228, 'UA', 'Ukraine'),
(229, 'AE', 'United Arab Emirates'),
(230, 'GB', 'United Kingdom'),
(231, 'US', 'United States'),
(232, 'UM', 'United States Minor Outlying Islands'),
(233, 'UY', 'Uruguay'),
(234, 'UZ', 'Uzbekistan'),
(235, 'VU', 'Vanuatu'),
(236, 'VA', 'Vatican City State (Holy See)'),
(237, 'VE', 'Venezuela'),
(238, 'VN', 'Vietnam'),
(239, 'VG', 'Virgin Islands (British)'),
(240, 'VI', 'Virgin Islands (US)'),
(241, 'WF', 'Wallis And Futuna Islands'),
(242, 'EH', 'Western Sahara'),
(243, 'YE', 'Yemen'),
(244, 'YU', 'Yugoslavia'),
(245, 'ZM', 'Zambia'),
(246, 'ZW', 'Zimbabwe');

-- --------------------------------------------------------

--
-- Table structure for table `database_config`
--

CREATE TABLE `database_config` (
  `id` int(10) NOT NULL,
  `host` varchar(20) NOT NULL,
  `port` varchar(20) NOT NULL,
  `user_name` varchar(20) NOT NULL,
  `password` varchar(20) NOT NULL,
  `created` date NOT NULL,
  `type` varchar(100) NOT NULL,
  `sid` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `data_transfer_sync`
--

CREATE TABLE `data_transfer_sync` (
  `task_name` varchar(20) NOT NULL,
  `task_status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `data_transfer_sync`
--

INSERT INTO `data_transfer_sync` (`task_name`, `task_status`) VALUES
('PORTAL_SYNC', 1);

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `id` int(11) NOT NULL,
  `comp_code` varchar(40) DEFAULT NULL,
  `dept_code` varchar(40) DEFAULT NULL,
  `dept_name` varchar(100) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `status` enum('0','1') DEFAULT NULL,
  `icon_style` varchar(20) DEFAULT NULL,
  `sloc_id` varchar(25) DEFAULT NULL,
  `cld_id` varchar(22) DEFAULT NULL,
  `ho_org_id` varchar(22) DEFAULT NULL,
  `org_id` varchar(22) DEFAULT NULL,
  `emp_doc_id` varchar(52) DEFAULT NULL,
  `doc_id` varchar(52) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `dependent_details`
--

CREATE TABLE `dependent_details` (
  `id` int(20) NOT NULL,
  `member_name` varchar(50) DEFAULT NULL,
  `relation` varchar(50) DEFAULT NULL,
  `occupation` varchar(50) DEFAULT NULL,
  `Dob` date DEFAULT NULL,
  `gender` varchar(10) DEFAULT NULL,
  `myprofile_id` int(10) DEFAULT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Triggers `dependent_details`
--
DELIMITER $$
CREATE TRIGGER `dependant_after_insert` AFTER INSERT ON `dependent_details` FOR EACH ROW IF @DISABLE_TRIGGERS IS NULL THEN
	INSERT INTO newdata VALUES (NEW.id,'dependent_details','I');
END IF
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `dependant_after_update` AFTER UPDATE ON `dependent_details` FOR EACH ROW IF @DISABLE_TRIGGERS IS NULL THEN
	INSERT INTO newdata VALUES (NEW.id,'dependent_details','U');
END IF
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `documents`
--

CREATE TABLE `documents` (
  `id` int(10) NOT NULL,
  `user_id` int(10) DEFAULT NULL,
  `url` varchar(255) NOT NULL,
  `comments` text,
  `created` date NOT NULL,
  `modified` date DEFAULT NULL,
  `solc_id` varchar(25) DEFAULT NULL,
  `cld_id` varchar(22) DEFAULT NULL,
  `ho_org_id` varchar(22) DEFAULT NULL,
  `org_id` varchar(22) DEFAULT NULL,
  `emp_doc_id` varchar(52) DEFAULT NULL,
  `doc_id` varchar(52) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `documents_request`
--

CREATE TABLE `documents_request` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL COMMENT 'myprofile (id)',
  `document_id` int(11) NOT NULL COMMENT 'categories (id)',
  `request_num` varchar(100) NOT NULL,
  `file_ref_num` varchar(100) NOT NULL,
  `reason` text NOT NULL,
  `file_name` varchar(100) NOT NULL,
  `req_status` varchar(100) NOT NULL DEFAULT '1' COMMENT '1="Reciev Req" , 2="forward Req file", 3="Return file"',
  `manual_files` varchar(100) NOT NULL,
  `manual_files_byRequester` varchar(200) NOT NULL COMMENT 'Other manul files from requester',
  `remark` text NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1' COMMENT '1="Active", 2="Inactive"',
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `file_receive_date` datetime NOT NULL COMMENT 'when requester receive the file',
  `file_return_date` datetime NOT NULL COMMENT 'when requester returned the file'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `documents_request`
--

INSERT INTO `documents_request` (`id`, `user_id`, `document_id`, `request_num`, `file_ref_num`, `reason`, `file_name`, `req_status`, `manual_files`, `manual_files_byRequester`, `remark`, `status`, `created_date`, `file_receive_date`, `file_return_date`) VALUES
(1, 171, 3, 'REQ1482451296', 'PSC/sub folders/time.txt', 'this is remark ', 'time.txt', '3', 'abcd.txt,bdx.jpg', '', 'plz receive requested file..', 1, '2016-12-17 06:04:45', '2016-12-17 11:37:51', '2016-12-17 11:42:56');

-- --------------------------------------------------------

--
-- Table structure for table `document_cat_lists`
--

CREATE TABLE `document_cat_lists` (
  `id` int(11) NOT NULL,
  `comp_code` varchar(25) NOT NULL,
  `emp_code` varchar(23) NOT NULL,
  `catagory` varchar(30) NOT NULL,
  `document_name` varchar(40) NOT NULL,
  `document_desc` varchar(255) NOT NULL,
  `file` varchar(188) NOT NULL,
  `open_all` int(11) NOT NULL,
  `restricted_access` int(11) NOT NULL,
  `created_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `dt_course_details`
--

CREATE TABLE `dt_course_details` (
  `id` int(10) NOT NULL,
  `mst_course_masters_id` int(10) DEFAULT NULL,
  `file_name` varchar(255) DEFAULT NULL,
  `file_version` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `dt_employee_sal_mon`
--

CREATE TABLE `dt_employee_sal_mon` (
  `id` int(11) NOT NULL,
  `emp_code` int(10) NOT NULL,
  `sal_id` varchar(255) NOT NULL,
  `claim_date` date NOT NULL,
  `status` int(1) NOT NULL,
  `amount` int(20) NOT NULL,
  `employee_sal_mon_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `dt_exp_voucher`
--

CREATE TABLE `dt_exp_voucher` (
  `id` int(10) NOT NULL,
  `voucher_id` int(10) NOT NULL,
  `emp_code` varchar(40) DEFAULT NULL,
  `org_id` varchar(40) NOT NULL,
  `dept_code` varchar(100) NOT NULL,
  `claim_date` date DEFAULT NULL,
  `travel_mode` int(11) NOT NULL,
  `wheeler_type` int(11) NOT NULL COMMENT '1="Personal" , 2="Commercial"',
  `from_place` varchar(250) NOT NULL,
  `to_place` varchar(250) NOT NULL,
  `miscl_exp` decimal(10,0) DEFAULT NULL,
  `miscl_exp_desc` text,
  `travel_exp` decimal(10,0) NOT NULL,
  `total_exp` decimal(10,0) NOT NULL,
  `distance` decimal(10,0) DEFAULT NULL,
  `conveyence_status` int(10) DEFAULT NULL,
  `payment_status` int(11) NOT NULL DEFAULT '0' COMMENT '0="Not Paid" , 1="Paid"',
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `remark` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Triggers `dt_exp_voucher`
--
DELIMITER $$
CREATE TRIGGER `dt_exp_voucher_after_insert` AFTER UPDATE ON `dt_exp_voucher` FOR EACH ROW if NEW.conveyence_status = 5 then
IF @DISABLE_TRIGGERS IS NULL THEN
	INSERT INTO newdata VALUES (NEW.`voucher_id`,'exp_voucher','I');
END IF;
end if
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `dt_ext_trainer`
--

CREATE TABLE `dt_ext_trainer` (
  `id` int(10) NOT NULL,
  `vc_emp_code` varchar(30) DEFAULT NULL,
  `vc_course_id` varchar(30) DEFAULT NULL,
  `institue_id` varchar(50) DEFAULT NULL,
  `vc_status` varchar(20) DEFAULT NULL,
  `date_created` date DEFAULT NULL,
  `date_modified` date DEFAULT NULL,
  `vc_emp_name` varchar(20) DEFAULT NULL,
  `remarks` varchar(60) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `dt_training_attendence`
--

CREATE TABLE `dt_training_attendence` (
  `id` int(20) NOT NULL,
  `attend_id` int(10) DEFAULT NULL,
  `training_id` int(10) DEFAULT NULL,
  `request_id` int(10) DEFAULT NULL,
  `trainee_code` varchar(20) DEFAULT NULL,
  `pte_status` varchar(10) DEFAULT NULL,
  `attendence_status` varchar(10) DEFAULT NULL,
  `reason` varchar(10) DEFAULT NULL,
  `feedback_status` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `dt_training_feedback_details`
--

CREATE TABLE `dt_training_feedback_details` (
  `id` int(20) DEFAULT NULL,
  `emp_code` int(10) DEFAULT NULL,
  `training_id` int(10) DEFAULT NULL,
  `rate_quality` varchar(20) DEFAULT NULL,
  `rate_contents` varchar(20) DEFAULT NULL,
  `rate_admin` varchar(50) DEFAULT NULL,
  `session_eliminate` varchar(20) DEFAULT NULL,
  `session_desc` varchar(2000) DEFAULT NULL,
  `additional_sess_desc` varchar(20) DEFAULT NULL,
  `duration_training_prog` varchar(20) DEFAULT NULL,
  `amt_time_appro` varchar(20) DEFAULT NULL,
  `amt_time_appro_desc` varchar(20) DEFAULT NULL,
  `satisfied` varchar(20) DEFAULT NULL,
  `satisfied_desc` varchar(20) DEFAULT NULL,
  `entry_date` date DEFAULT NULL,
  `feedback_status` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `dt_training_feedback_trainers`
--

CREATE TABLE `dt_training_feedback_trainers` (
  `id` int(20) DEFAULT NULL,
  `train_id` int(20) DEFAULT NULL,
  `feedback_id` int(50) DEFAULT NULL,
  `comp_code` int(50) DEFAULT NULL,
  `feedback_by` varchar(20) DEFAULT NULL,
  `feedback_for` varchar(20) DEFAULT NULL,
  `rate_present` varchar(20) DEFAULT NULL,
  `subject_know` varchar(20) DEFAULT NULL,
  `handle_query` varchar(20) DEFAULT NULL,
  `entry_date` varchar(20) DEFAULT NULL,
  `session_id` int(20) DEFAULT NULL,
  `feedback_status` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `dt_training_sessions`
--

CREATE TABLE `dt_training_sessions` (
  `id` int(20) DEFAULT NULL,
  `training_id` int(20) DEFAULT NULL,
  `trainer_id` int(50) DEFAULT NULL,
  `session` int(50) DEFAULT NULL,
  `session_hh` int(20) DEFAULT NULL,
  `session_mm` int(20) DEFAULT NULL,
  `session_date` date DEFAULT NULL,
  `date_created` date DEFAULT NULL,
  `date_modified` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `dt_travel_voucher`
--

CREATE TABLE `dt_travel_voucher` (
  `id` int(11) NOT NULL,
  `voucher_id` int(11) DEFAULT NULL,
  `emp_code` varchar(40) DEFAULT NULL,
  `org_id` varchar(40) NOT NULL,
  `adv_amount` int(11) DEFAULT NULL,
  `empadv_name` varchar(22) NOT NULL,
  `da` int(11) DEFAULT NULL,
  `days` int(22) NOT NULL,
  `hotel_stay` int(11) DEFAULT NULL,
  `telephone_exp` int(22) NOT NULL,
  `client_exp` int(22) NOT NULL,
  `other_exp` int(22) NOT NULL,
  `miscellaneous_exp` int(11) DEFAULT NULL,
  `miscellaneous_details` varchar(50) NOT NULL,
  `start_mode` int(22) NOT NULL,
  `end_mode` int(11) NOT NULL,
  `ticket_amount` int(20) NOT NULL,
  `conv_expense` int(22) NOT NULL,
  `conv_details` varchar(22) DEFAULT NULL,
  `pending_amount` int(11) DEFAULT NULL,
  `total_expense` int(11) NOT NULL,
  `place_visit` varchar(100) DEFAULT NULL,
  `return_amount` int(11) DEFAULT NULL,
  `tour_start_date` date DEFAULT NULL,
  `tour_end_date` date DEFAULT NULL,
  `travel_status` int(11) DEFAULT NULL,
  `payment_status` int(11) NOT NULL DEFAULT '0' COMMENT '0="Not Paid" , 1="Paid"',
  `file` varchar(255) DEFAULT NULL,
  `remark` varchar(255) DEFAULT NULL,
  `hotel_days` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `employee_sal_details`
--

CREATE TABLE `employee_sal_details` (
  `id` int(11) NOT NULL,
  `emp_id` int(10) DEFAULT NULL,
  `sal_id` varchar(255) DEFAULT NULL,
  `sal_type` varchar(255) DEFAULT NULL,
  `sal_val` double DEFAULT NULL,
  `sal_behav` varchar(10) DEFAULT NULL,
  `valid_strt_dt` date DEFAULT NULL,
  `valid_end_dt` date DEFAULT NULL,
  `sal_amt` float DEFAULT NULL,
  `ref_sal_id` int(11) DEFAULT NULL,
  `sal_perc_val` float DEFAULT NULL,
  `myprofile_id` int(20) NOT NULL,
  `solc_id` varchar(25) DEFAULT NULL,
  `cld_id` varchar(22) DEFAULT NULL,
  `ho_org_id` varchar(22) DEFAULT NULL,
  `org_id` varchar(22) DEFAULT NULL,
  `emp_doc_id` varchar(52) DEFAULT NULL,
  `doc_id` varchar(52) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `employee_sal_mon`
--

CREATE TABLE `employee_sal_mon` (
  `id` int(11) NOT NULL,
  `voucher_id` int(20) NOT NULL,
  `emp_code` int(10) NOT NULL,
  `created_at` date NOT NULL,
  `claim_date` date NOT NULL,
  `status` int(5) NOT NULL,
  `remark` varchar(255) DEFAULT NULL,
  `approval_date` date DEFAULT NULL,
  `sloc_id` varchar(25) DEFAULT NULL,
  `cld_id` varchar(22) DEFAULT NULL,
  `ho_org_id` varchar(22) DEFAULT NULL,
  `org_id` varchar(22) DEFAULT NULL,
  `emp_doc_id` varchar(52) DEFAULT NULL,
  `doc_id` varchar(52) DEFAULT NULL,
  `sal_id` varchar(20) DEFAULT NULL,
  `sal_val` varchar(20) NOT NULL,
  `sal_amt` varchar(255) NOT NULL,
  `proc_frm_dt` date NOT NULL,
  `proc_to_dt` date NOT NULL,
  `vc_file` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Triggers `employee_sal_mon`
--
DELIMITER $$
CREATE TRIGGER `employee_sal_mon` AFTER UPDATE ON `employee_sal_mon` FOR EACH ROW if NEW.status = 5 then
IF @DISABLE_TRIGGERS IS NULL THEN
	INSERT INTO newdata VALUES (NEW.id,'employee_sal_mon','I');
END IF;
end if
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `employee_sal_proc`
--

CREATE TABLE `employee_sal_proc` (
  `id` int(10) NOT NULL,
  `org_id` varchar(10) DEFAULT NULL,
  `emp_doc_id` varchar(255) DEFAULT NULL,
  `proc_frm_dt` date DEFAULT NULL,
  `proc_to_dt` date DEFAULT NULL,
  `tot_earn` double DEFAULT '0',
  `tot_allow` float DEFAULT '0',
  `tot_gross` double DEFAULT '0',
  `tot_loan` float DEFAULT '0',
  `tot_misc` float DEFAULT '0',
  `tot_tax` float DEFAULT '0',
  `total_ded` float DEFAULT NULL,
  `tot_sal_amt` float DEFAULT NULL,
  `sal_status` int(10) DEFAULT NULL,
  `wrk_hrs` float DEFAULT NULL,
  `wrk_dys` float DEFAULT NULL,
  `solc_id` varchar(25) DEFAULT NULL,
  `cld_id` varchar(22) DEFAULT NULL,
  `ho_org_id` varchar(22) DEFAULT NULL,
  `doc_id` varchar(52) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `employee_sal_proc_ded`
--

CREATE TABLE `employee_sal_proc_ded` (
  `id` int(10) NOT NULL,
  `org_id` varchar(10) DEFAULT NULL,
  `emp_code` varchar(255) DEFAULT NULL,
  `emp_doc_id` varchar(255) DEFAULT NULL,
  `proc_frm_dt` date DEFAULT NULL,
  `proc_to_dt` date DEFAULT NULL,
  `ded_id` varchar(255) DEFAULT '0',
  `ded_doc_id` varchar(255) DEFAULT NULL,
  `ded_behav` int(10) DEFAULT '0',
  `ded_amt` float DEFAULT '0',
  `solc_id` varchar(25) DEFAULT NULL,
  `cld_id` varchar(22) DEFAULT NULL,
  `ho_org_id` varchar(22) DEFAULT NULL,
  `doc_id` varchar(52) DEFAULT NULL,
  `vpf` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `employee_sal_proc_sal`
--

CREATE TABLE `employee_sal_proc_sal` (
  `id` int(10) NOT NULL,
  `employee_sal_proc_sal_id` varchar(50) DEFAULT NULL,
  `org_id` varchar(10) DEFAULT NULL,
  `emp_doc_id` varchar(255) DEFAULT NULL,
  `proc_frm_dt` date DEFAULT NULL,
  `proc_to_dt` date DEFAULT NULL,
  `sal_id` varchar(10) DEFAULT '0',
  `sal_behav` int(10) DEFAULT '0',
  `sal_amt` float DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `emp_address`
--

CREATE TABLE `emp_address` (
  `id` int(10) NOT NULL,
  `emp_code` varchar(255) NOT NULL,
  `cur_address` varchar(300) DEFAULT NULL,
  `cur_city` varchar(100) DEFAULT NULL,
  `cur_state` varchar(100) DEFAULT NULL,
  `cur_country` varchar(100) DEFAULT NULL,
  `cur_pincode` varchar(100) DEFAULT NULL,
  `cur_landline` int(10) NOT NULL,
  `cur_phone` int(10) DEFAULT NULL,
  `per_address` varchar(300) DEFAULT NULL,
  `per_city` varchar(100) DEFAULT NULL,
  `per_state` varchar(100) DEFAULT NULL,
  `per_country` varchar(100) DEFAULT NULL,
  `per_pincode` varchar(100) DEFAULT NULL,
  `per_landline` int(10) NOT NULL,
  `per_phone` int(10) DEFAULT NULL,
  `status` int(10) NOT NULL,
  `remark` varchar(10000) NOT NULL,
  `created_at` date NOT NULL,
  `updated_at` date NOT NULL,
  `document` varchar(255) NOT NULL,
  `approver_id` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `emp_documents`
--

CREATE TABLE `emp_documents` (
  `id` int(11) NOT NULL,
  `emp_code` int(11) NOT NULL,
  `title` varchar(200) DEFAULT NULL,
  `documents` varchar(250) NOT NULL,
  `approve` int(1) DEFAULT '0',
  `created_at` date DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `myprofile_id` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `emp_edu`
--

CREATE TABLE `emp_edu` (
  `id` int(11) NOT NULL,
  `emp_doc_id` varchar(255) NOT NULL,
  `emp_code` int(20) DEFAULT NULL,
  `course_id` varchar(255) DEFAULT NULL,
  `yop` int(20) DEFAULT NULL,
  `mark_obtain` int(20) DEFAULT NULL,
  `qual_type_id` int(5) DEFAULT NULL,
  `myprofile_id` int(22) NOT NULL,
  `ins_nm` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `emp_events`
--

CREATE TABLE `emp_events` (
  `id` int(10) NOT NULL,
  `emp_code` varchar(10) DEFAULT NULL,
  `color` varchar(10) DEFAULT NULL,
  `start` date DEFAULT NULL,
  `end` date DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `emp_exp`
--

CREATE TABLE `emp_exp` (
  `id` int(11) NOT NULL,
  `emp_doc_id` varchar(255) NOT NULL,
  `org_id` varchar(20) NOT NULL,
  `emp_code` int(20) NOT NULL,
  `emp_org_nm` varchar(255) DEFAULT NULL,
  `emp_org_loc` varchar(255) DEFAULT NULL,
  `emp_org_doj` date DEFAULT NULL,
  `emp_org_dol` date DEFAULT NULL,
  `emp_org_desig` varchar(255) DEFAULT NULL,
  `emp_org_sal` int(11) DEFAULT NULL,
  `myprofile_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `emp_incr_arr`
--

CREATE TABLE `emp_incr_arr` (
  `id` int(11) NOT NULL,
  `cld_id` varchar(4) DEFAULT NULL,
  `sloc_id` int(2) DEFAULT NULL,
  `ho_org_id` varchar(2) DEFAULT NULL,
  `org_id` varchar(2) DEFAULT NULL,
  `doc_id` varchar(40) DEFAULT NULL,
  `incr_id` varchar(20) DEFAULT NULL,
  `emp_code` int(20) DEFAULT NULL,
  `grp_id` varchar(20) DEFAULT NULL,
  `arr_strt_dt` date DEFAULT NULL,
  `arr_end_dt` date DEFAULT NULL,
  `usr_id_create` int(10) DEFAULT NULL,
  `usr_id_create_dt` date DEFAULT NULL,
  `usr_id_mod` int(10) DEFAULT NULL,
  `usr_id_mod_dt` date DEFAULT NULL,
  `emp_doc_id` varchar(40) DEFAULT NULL,
  `pay_days` int(5) DEFAULT NULL,
  `sal_id` varchar(20) DEFAULT NULL,
  `arr_amt` int(26) DEFAULT NULL,
  `incr_doc_id` varchar(40) DEFAULT NULL,
  `incr_dt` date DEFAULT NULL,
  `appli_dt` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `emp_invest`
--

CREATE TABLE `emp_invest` (
  `id` int(10) NOT NULL,
  `comp_code` varchar(30) DEFAULT NULL,
  `emp_code` varchar(40) DEFAULT NULL,
  `doc_id` varchar(255) DEFAULT NULL,
  `Fy_id` int(10) DEFAULT NULL,
  `ora_fy_id` int(10) NOT NULL,
  `loc_type` varchar(1) DEFAULT NULL,
  `invest_status` varchar(2) NOT NULL,
  `emp_doc_id` varchar(255) NOT NULL,
  `config` int(5) NOT NULL,
  `sloc_id` varchar(25) DEFAULT NULL,
  `cld_id` varchar(22) DEFAULT NULL,
  `ho_org_id` varchar(22) DEFAULT NULL,
  `org_id` varchar(22) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Triggers `emp_invest`
--
DELIMITER $$
CREATE TRIGGER `mst_emp_invest_after_insert` AFTER INSERT ON `emp_invest` FOR EACH ROW IF @DISABLE_TRIGGERS IS NULL THEN
	INSERT INTO newdata VALUES (NEW.id,'emp_invest','I');
    
END IF
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `emp_invest_dtl`
--

CREATE TABLE `emp_invest_dtl` (
  `id` int(30) NOT NULL,
  `org_id` varchar(40) DEFAULT NULL,
  `emp_invest_id` int(25) DEFAULT NULL,
  `emp_code` varchar(255) DEFAULT NULL,
  `doc_id` varchar(255) DEFAULT NULL,
  `fy_id` int(10) DEFAULT NULL,
  `ora_fy_id` int(10) NOT NULL,
  `invest_doc_id` varchar(255) DEFAULT NULL,
  `sect_id` varchar(20) DEFAULT NULL,
  `invest_id` varchar(20) DEFAULT NULL,
  `invest_amt` varchar(20) DEFAULT NULL,
  `actual_amt` varchar(20) DEFAULT NULL,
  `invest_status` varchar(2) NOT NULL,
  `approver_id` int(50) NOT NULL,
  `emp_doc_id` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Triggers `emp_invest_dtl`
--
DELIMITER $$
CREATE TRIGGER `mst_emp_invest_dtl_after_insert` AFTER INSERT ON `emp_invest_dtl` FOR EACH ROW IF @DISABLE_TRIGGERS IS NULL THEN
	INSERT INTO newdata VALUES (NEW.id,'emp_invest_dtl','I');
    
END IF
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `mst_emp_invest_dtl_after_update` AFTER UPDATE ON `emp_invest_dtl` FOR EACH ROW IF @DISABLE_TRIGGERS IS NULL THEN
	INSERT INTO newdata VALUES (NEW.id,'emp_invest_dtl','U');
    
END IF
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` int(10) NOT NULL,
  `user_id` int(10) NOT NULL,
  `title` varchar(256) NOT NULL,
  `description` varchar(1000) NOT NULL,
  `event_date` date NOT NULL,
  `created` date NOT NULL,
  `status` int(10) NOT NULL,
  `type` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `financial_year`
--

CREATE TABLE `financial_year` (
  `id` int(5) NOT NULL,
  `org_id` varchar(20) DEFAULT NULL,
  `fy_type` varchar(20) DEFAULT NULL,
  `fy_desc` varchar(255) DEFAULT NULL,
  `hcm_fy_start` date DEFAULT NULL,
  `hcm_fy_end` date DEFAULT NULL,
  `solc_id` varchar(25) DEFAULT NULL,
  `cld_id` varchar(22) DEFAULT NULL,
  `ho_org_id` varchar(22) DEFAULT NULL,
  `emp_doc_id` varchar(52) DEFAULT NULL,
  `doc_id` varchar(52) DEFAULT NULL,
  `status` int(20) NOT NULL,
  `ora_fy_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `fnfs`
--

CREATE TABLE `fnfs` (
  `id` int(10) NOT NULL,
  `separation_id` int(10) DEFAULT NULL,
  `emp_code` int(10) DEFAULT NULL,
  `status` int(10) DEFAULT NULL,
  `created` date DEFAULT NULL,
  `final_approver` int(10) DEFAULT NULL,
  `solc_id` varchar(25) DEFAULT NULL,
  `cld_id` varchar(22) DEFAULT NULL,
  `ho_org_id` varchar(22) DEFAULT NULL,
  `org_id` varchar(22) DEFAULT NULL,
  `emp_doc_id` varchar(52) DEFAULT NULL,
  `doc_id` varchar(52) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `fnf_details`
--

CREATE TABLE `fnf_details` (
  `id` int(10) NOT NULL,
  `fnf_id` int(10) DEFAULT NULL,
  `project_id` int(10) DEFAULT NULL,
  `remarks` text,
  `approver_remark` varchar(255) DEFAULT NULL,
  `approver_id` int(10) DEFAULT NULL,
  `status` int(10) DEFAULT '1',
  `completion_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `fnf_workflows`
--

CREATE TABLE `fnf_workflows` (
  `id` int(10) NOT NULL,
  `fnf_id` int(10) DEFAULT NULL,
  `emp_code` int(10) DEFAULT NULL,
  `fw_date` date DEFAULT NULL,
  `remarks` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `group_competency`
--

CREATE TABLE `group_competency` (
  `id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  `competency_id` int(11) NOT NULL,
  `ho_org_id` int(11) NOT NULL,
  `org_id` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_date` date NOT NULL,
  `updated_by` int(11) NOT NULL,
  `updated_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `group_weightage`
--

CREATE TABLE `group_weightage` (
  `id` int(1) NOT NULL,
  `group_master_id` int(1) NOT NULL,
  `kra_weightage` int(11) NOT NULL,
  `comp_weightage` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `hcm_ded`
--

CREATE TABLE `hcm_ded` (
  `id` int(10) NOT NULL,
  `org_id` varchar(255) DEFAULT NULL,
  `doc_id` varchar(255) NOT NULL,
  `ded_desc` varchar(255) DEFAULT NULL,
  `ded_amt` float DEFAULT NULL,
  `ded_type` int(11) DEFAULT NULL,
  `sloc_id` varchar(25) DEFAULT NULL,
  `cld_id` varchar(22) DEFAULT NULL,
  `ho_org_id` varchar(22) DEFAULT NULL,
  `emp_doc_id` varchar(52) DEFAULT NULL,
  `ded_id` varchar(20) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `hcm_desg_prf`
--

CREATE TABLE `hcm_desg_prf` (
  `id` int(10) NOT NULL,
  `doc_id` varchar(256) NOT NULL,
  `ho_org_id` varchar(10) DEFAULT NULL,
  `dept_id` varchar(10) DEFAULT NULL,
  `desg_id` varchar(10) DEFAULT NULL,
  `rptg_desg_id` varchar(10) DEFAULT NULL,
  `created` date NOT NULL,
  `modified` date NOT NULL,
  `actv_flg` enum('Y','N') DEFAULT NULL,
  `valid_strt_dt` date NOT NULL,
  `valid_end_dt` date DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `hcm_group_master`
--

CREATE TABLE `hcm_group_master` (
  `id` int(11) NOT NULL,
  `hcm_id` varchar(20) NOT NULL,
  `group_name` varchar(50) NOT NULL,
  `status` int(1) NOT NULL,
  `ho_org_id` int(11) NOT NULL,
  `org_id` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_date` datetime NOT NULL,
  `updated_by` int(11) NOT NULL,
  `updated_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `hd_training`
--

CREATE TABLE `hd_training` (
  `id` int(10) DEFAULT NULL,
  `comp_code` varchar(10) DEFAULT NULL,
  `emp_code` varchar(10) DEFAULT NULL,
  `training_no` varchar(10) DEFAULT NULL,
  `training_date` date DEFAULT NULL,
  `submit_date` date DEFAULT NULL,
  `training_req` varchar(10) DEFAULT NULL,
  `duration` int(10) DEFAULT NULL,
  `training_type` varchar(20) DEFAULT NULL,
  `training_status` varchar(20) DEFAULT NULL,
  `training_name` varchar(20) DEFAULT NULL,
  `dt_field1` date DEFAULT NULL,
  `dt_field2` date DEFAULT NULL,
  `nu_field1` int(10) DEFAULT NULL,
  `nu_field2` int(10) DEFAULT NULL,
  `vc_field1` varchar(20) DEFAULT NULL,
  `vc_field2` varchar(20) DEFAULT NULL,
  `ch_status1` varchar(20) DEFAULT NULL,
  `ch_status2` varchar(20) DEFAULT NULL,
  `training_end_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `hd_training_sessions`
--

CREATE TABLE `hd_training_sessions` (
  `id` int(20) NOT NULL,
  `training_sessions_id` int(10) DEFAULT NULL,
  `start_time_hh` int(10) DEFAULT NULL,
  `start_time_am_pm` varchar(10) DEFAULT NULL,
  `endtime_hh` int(10) DEFAULT NULL,
  `endtime_mm` int(10) DEFAULT NULL,
  `endtime_am_pm` varchar(10) DEFAULT NULL,
  `session_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `help_desk_dtl`
--

CREATE TABLE `help_desk_dtl` (
  `id` int(11) NOT NULL,
  `mst_ticket_id` int(11) NOT NULL,
  `commenter_id` int(11) NOT NULL,
  `comment` varchar(255) NOT NULL,
  `comment_date` date NOT NULL,
  `comp_code` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `holiday`
--

CREATE TABLE `holiday` (
  `id` int(11) NOT NULL,
  `holiday_date` date NOT NULL,
  `holiday_name` varchar(100) DEFAULT NULL,
  `status` enum('0','1') DEFAULT NULL,
  `solc_id` varchar(25) DEFAULT NULL,
  `cld_id` varchar(22) DEFAULT NULL,
  `ho_org_id` varchar(22) DEFAULT NULL,
  `org_id` varchar(22) DEFAULT NULL,
  `hol_id` varchar(52) DEFAULT NULL,
  `doc_id` varchar(52) DEFAULT NULL,
  `location_id` varchar(30) DEFAULT NULL,
  `op_leave` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `icon`
--

CREATE TABLE `icon` (
  `id` int(10) NOT NULL,
  `shortcut_name` varchar(50) DEFAULT NULL,
  `status` int(10) DEFAULT NULL,
  `function_name` varchar(50) DEFAULT NULL,
  `department_id` int(10) NOT NULL,
  `image` varchar(50) NOT NULL,
  `solc_id` varchar(25) DEFAULT NULL,
  `cld_id` varchar(22) DEFAULT NULL,
  `ho_org_id` varchar(22) DEFAULT NULL,
  `org_id` varchar(22) DEFAULT NULL,
  `emp_doc_id` varchar(52) DEFAULT NULL,
  `doc_id` varchar(52) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `icon`
--

INSERT INTO `icon` (`id`, `shortcut_name`, `status`, `function_name`, `department_id`, `image`, `solc_id`, `cld_id`, `ho_org_id`, `org_id`, `emp_doc_id`, `doc_id`) VALUES
(1, 'MyProfile', 1, 'users/myprofile', 1, '', NULL, NULL, NULL, NULL, NULL, NULL),
(2, 'Add Leaves', 1, 'leaves/add', 1, '', NULL, NULL, NULL, NULL, NULL, NULL),
(3, 'View Leaves', 1, 'leaves/view', 1, '', NULL, NULL, NULL, NULL, NULL, NULL),
(4, 'Add Travel', 1, 'travels/trvoucher', 1, '', NULL, NULL, NULL, NULL, NULL, NULL),
(5, 'View Travel', 0, 'travels/view', 1, '', NULL, NULL, NULL, NULL, NULL, NULL),
(6, 'Leave Approval', 0, 'leaves/approval', 1, '', NULL, NULL, NULL, NULL, NULL, NULL),
(7, 'MyProfile', 1, 'users/myprofile', 2, '', NULL, NULL, NULL, NULL, NULL, NULL),
(8, 'Add Leaves', 1, 'leaves/add', 2, '', NULL, NULL, NULL, NULL, NULL, NULL),
(9, 'View Leaves', 1, 'leaves/view', 2, '', NULL, NULL, NULL, NULL, NULL, NULL),
(10, 'Add Travel', 1, 'travels/trvoucher', 2, '', NULL, NULL, NULL, NULL, NULL, NULL),
(11, 'View Travel', 0, 'travels/view', 2, '', NULL, NULL, NULL, NULL, NULL, NULL),
(12, 'Leave Approval', 0, 'leaves/approval', 2, '', NULL, NULL, NULL, NULL, NULL, NULL),
(13, 'MyProfile', 1, 'users/myprofile', 3, '', NULL, NULL, NULL, NULL, NULL, NULL),
(14, 'Add Leaves', 1, 'leaves/add', 3, '', NULL, NULL, NULL, NULL, NULL, NULL),
(15, 'View Leaves', 1, 'leaves/view', 3, '', NULL, NULL, NULL, NULL, NULL, NULL),
(16, 'Add Travel', 1, 'travels/trvoucher', 3, '', NULL, NULL, NULL, NULL, NULL, NULL),
(17, 'View Travel', 0, 'travels/view', 3, '', NULL, NULL, NULL, NULL, NULL, NULL),
(18, 'Leave Approval', 0, 'leaves/approval', 3, '', NULL, NULL, NULL, NULL, NULL, NULL),
(19, 'MyProfile', 1, 'users/myprofile', 4, '', NULL, NULL, NULL, NULL, NULL, NULL),
(20, 'Add Leaves', 1, 'leaves/add', 4, '', NULL, NULL, NULL, NULL, NULL, NULL),
(21, 'View Leaves', 1, 'leaves/view', 4, '', NULL, NULL, NULL, NULL, NULL, NULL),
(22, 'Add Travel', 1, 'travels/trvoucher', 4, '', NULL, NULL, NULL, NULL, NULL, NULL),
(23, 'View Travel', 0, 'travels/view', 4, '', NULL, NULL, NULL, NULL, NULL, NULL),
(24, 'Leave Approval', 0, 'leaves/approval', 4, '', NULL, NULL, NULL, NULL, NULL, NULL),
(25, 'MyProfile', 1, 'users/myprofile', 5, '', NULL, NULL, NULL, NULL, NULL, NULL),
(26, 'Add Leaves', 1, 'leaves/add', 5, '', NULL, NULL, NULL, NULL, NULL, NULL),
(27, 'View Leaves', 1, 'leaves/view', 5, '', NULL, NULL, NULL, NULL, NULL, NULL),
(28, 'Add Travel', 1, 'travels/trvoucher', 5, '', NULL, NULL, NULL, NULL, NULL, NULL),
(29, 'View Travel', 0, 'travels/view', 5, '', NULL, NULL, NULL, NULL, NULL, NULL),
(30, 'Leave Approval', 0, 'leaves/approval', 5, '', NULL, NULL, NULL, NULL, NULL, NULL),
(31, 'MyProfile', 1, 'users/myprofile', 6, '', NULL, NULL, NULL, NULL, NULL, NULL),
(32, 'Add Leaves', 1, 'leaves/add', 6, '', NULL, NULL, NULL, NULL, NULL, NULL),
(33, 'View Leaves', 1, 'leaves/view', 6, '', NULL, NULL, NULL, NULL, NULL, NULL),
(34, 'Add Travel', 1, 'travels/trvoucher', 6, '', NULL, NULL, NULL, NULL, NULL, NULL),
(35, 'View Travel', 0, 'travels/view', 6, '', NULL, NULL, NULL, NULL, NULL, NULL),
(36, 'Leave Approval', 0, 'leaves/approval', 6, '', NULL, NULL, NULL, NULL, NULL, NULL),
(37, 'MyProfile', 1, 'users/myprofile', 7, '', NULL, NULL, NULL, NULL, NULL, NULL),
(38, 'Add Leaves', 1, 'leaves/add', 7, '', NULL, NULL, NULL, NULL, NULL, NULL),
(39, 'View Leaves', 1, 'leaves/view', 7, '', NULL, NULL, NULL, NULL, NULL, NULL),
(40, 'Add Travel', 1, 'travels/trvoucher', 7, '', NULL, NULL, NULL, NULL, NULL, NULL),
(41, 'View Travel', 0, 'travels/view', 7, '', NULL, NULL, NULL, NULL, NULL, NULL),
(42, 'Leave Approval', 0, 'leaves/approval', 7, '', NULL, NULL, NULL, NULL, NULL, NULL),
(43, 'MyProfile', 1, 'users/myprofile', 8, '', NULL, NULL, NULL, NULL, NULL, NULL),
(44, 'Add Leaves', 1, 'leaves/add', 8, '', NULL, NULL, NULL, NULL, NULL, NULL),
(45, 'View Leaves', 1, 'leaves/view', 8, '', NULL, NULL, NULL, NULL, NULL, NULL),
(46, 'Add Travel', 1, 'travels/trvoucher', 8, '', NULL, NULL, NULL, NULL, NULL, NULL),
(47, 'View Travel', 0, 'travels/view', 8, '', NULL, NULL, NULL, NULL, NULL, NULL),
(48, 'Leave Approval', 0, 'leaves/approval', 8, '', NULL, NULL, NULL, NULL, NULL, NULL),
(49, 'MyProfile', 1, 'users/myprofile', 9, '', NULL, NULL, NULL, NULL, NULL, NULL),
(50, 'Add Leaves', 1, 'leaves/add', 9, '', NULL, NULL, NULL, NULL, NULL, NULL),
(51, 'View Leaves', 1, 'leaves/view', 9, '', NULL, NULL, NULL, NULL, NULL, NULL),
(52, 'Add Travel', 1, 'travels/trvoucher', 9, '', NULL, NULL, NULL, NULL, NULL, NULL),
(53, 'View Travel', 0, 'travels/view', 9, '', NULL, NULL, NULL, NULL, NULL, NULL),
(54, 'Leave Approval', 0, 'leaves/approval', 9, '', NULL, NULL, NULL, NULL, NULL, NULL),
(55, 'MyProfile', 1, 'users/myprofile', 10, '', NULL, NULL, NULL, NULL, NULL, NULL),
(56, 'Add Leaves', 1, 'leaves/add', 10, '', NULL, NULL, NULL, NULL, NULL, NULL),
(57, 'View Leaves', 1, 'leaves/view', 10, '', NULL, NULL, NULL, NULL, NULL, NULL),
(58, 'Add Travel', 1, 'travels/trvoucher', 10, '', NULL, NULL, NULL, NULL, NULL, NULL),
(59, 'View Travel', 0, 'travels/view', 10, '', NULL, NULL, NULL, NULL, NULL, NULL),
(60, 'Leave Approval', 0, 'leaves/approval', 10, '', NULL, NULL, NULL, NULL, NULL, NULL),
(61, 'MyProfile', 1, 'users/myprofile', 11, '', NULL, NULL, NULL, NULL, NULL, NULL),
(62, 'Add Leaves', 1, 'leaves/add', 11, '', NULL, NULL, NULL, NULL, NULL, NULL),
(63, 'View Leaves', 1, 'leaves/view', 11, '', NULL, NULL, NULL, NULL, NULL, NULL),
(64, 'Add Travel', 1, 'travels/trvoucher', 11, '', NULL, NULL, NULL, NULL, NULL, NULL),
(65, 'View Travel', 0, 'travels/view', 11, '', NULL, NULL, NULL, NULL, NULL, NULL),
(66, 'Leave Approval', 0, 'leaves/approval', 11, '', NULL, NULL, NULL, NULL, NULL, NULL),
(67, 'MyProfile', 1, 'users/myprofile', 12, '', NULL, NULL, NULL, NULL, NULL, NULL),
(68, 'Add Leaves', 1, 'leaves/add', 12, '', NULL, NULL, NULL, NULL, NULL, NULL),
(69, 'View Leaves', 1, 'leaves/view', 12, '', NULL, NULL, NULL, NULL, NULL, NULL),
(70, 'Add Travel', 1, 'travels/trvoucher', 12, '', NULL, NULL, NULL, NULL, NULL, NULL),
(71, 'View Travel', 0, 'travels/view', 12, '', NULL, NULL, NULL, NULL, NULL, NULL),
(72, 'Leave Approval', 0, 'leaves/approval', 12, '', NULL, NULL, NULL, NULL, NULL, NULL),
(73, 'MyProfile', 1, 'users/myprofile', 13, '', NULL, NULL, NULL, NULL, NULL, NULL),
(74, 'Add Leaves', 1, 'leaves/add', 13, '', NULL, NULL, NULL, NULL, NULL, NULL),
(75, 'View Leaves', 1, 'leaves/view', 13, '', NULL, NULL, NULL, NULL, NULL, NULL),
(76, 'Add Travel', 1, 'travels/trvoucher', 13, '', NULL, NULL, NULL, NULL, NULL, NULL),
(77, 'View Travel', 0, 'travels/view', 13, '', NULL, NULL, NULL, NULL, NULL, NULL),
(78, 'Leave Approval', 0, 'leaves/approval', 13, '', NULL, NULL, NULL, NULL, NULL, NULL),
(79, 'MyProfile', 1, 'users/myprofile', 14, '', NULL, NULL, NULL, NULL, NULL, NULL),
(80, 'Add Leaves', 1, 'leaves/add', 14, '', NULL, NULL, NULL, NULL, NULL, NULL),
(81, 'View Leaves', 1, 'leaves/view', 14, '', NULL, NULL, NULL, NULL, NULL, NULL),
(82, 'Add Travel', 1, 'travels/trvoucher', 14, '', NULL, NULL, NULL, NULL, NULL, NULL),
(83, 'View Travel', 0, 'travels/view', 14, '', NULL, NULL, NULL, NULL, NULL, NULL),
(84, 'Leave Approval', 0, 'leaves/approval', 14, '', NULL, NULL, NULL, NULL, NULL, NULL),
(85, 'MyProfile', 1, 'users/myprofile', 15, '', NULL, NULL, NULL, NULL, NULL, NULL),
(86, 'Add Leaves', 1, 'leaves/add', 15, '', NULL, NULL, NULL, NULL, NULL, NULL),
(87, 'View Leaves', 1, 'leaves/view', 15, '', NULL, NULL, NULL, NULL, NULL, NULL),
(88, 'Add Travel', 1, 'travels/trvoucher', 15, '', NULL, NULL, NULL, NULL, NULL, NULL),
(89, 'View Travel', 0, 'travels/view', 15, '', NULL, NULL, NULL, NULL, NULL, NULL),
(90, 'Leave Approval', 0, 'leaves/approval', 15, '', NULL, NULL, NULL, NULL, NULL, NULL),
(91, 'MyProfile', 1, 'users/myprofile', 16, '', NULL, NULL, NULL, NULL, NULL, NULL),
(92, 'Add Leaves', 1, 'leaves/add', 16, '', NULL, NULL, NULL, NULL, NULL, NULL),
(93, 'View Leaves', 1, 'leaves/view', 16, '', NULL, NULL, NULL, NULL, NULL, NULL),
(94, 'Add Travel', 1, 'travels/trvoucher', 16, '', NULL, NULL, NULL, NULL, NULL, NULL),
(95, 'View Travel', 0, 'travels/view', 16, '', NULL, NULL, NULL, NULL, NULL, NULL),
(96, 'Leave Approval', 0, 'leaves/approval', 16, '', NULL, NULL, NULL, NULL, NULL, NULL),
(97, 'MyProfile', 1, 'users/myprofile', 17, '', NULL, NULL, NULL, NULL, NULL, NULL),
(98, 'Add Leaves', 1, 'leaves/add', 17, '', NULL, NULL, NULL, NULL, NULL, NULL),
(99, 'View Leaves', 1, 'leaves/view', 17, '', NULL, NULL, NULL, NULL, NULL, NULL),
(100, 'Add Travel', 1, 'travels/trvoucher', 17, '', NULL, NULL, NULL, NULL, NULL, NULL),
(101, 'View Travel', 0, 'travels/view', 17, '', NULL, NULL, NULL, NULL, NULL, NULL),
(102, 'Leave Approval', 0, 'leaves/approval', 17, '', NULL, NULL, NULL, NULL, NULL, NULL),
(103, 'MyProfile', 1, 'users/myprofile', 18, '', NULL, NULL, NULL, NULL, NULL, NULL),
(104, 'Add Leaves', 1, 'leaves/add', 18, '', NULL, NULL, NULL, NULL, NULL, NULL),
(105, 'View Leaves', 1, 'leaves/view', 18, '', NULL, NULL, NULL, NULL, NULL, NULL),
(106, 'Add Travel', 1, 'travels/trvoucher', 18, '', NULL, NULL, NULL, NULL, NULL, NULL),
(107, 'View Travel', 0, 'travels/view', 18, '', NULL, NULL, NULL, NULL, NULL, NULL),
(108, 'Leave Approval', 0, 'leaves/approval', 18, '', NULL, NULL, NULL, NULL, NULL, NULL),
(109, 'MyProfile', 1, 'users/myprofile', 19, '', NULL, NULL, NULL, NULL, NULL, NULL),
(110, 'Add Leaves', 1, 'leaves/add', 19, '', NULL, NULL, NULL, NULL, NULL, NULL),
(111, 'View Leaves', 1, 'leaves/view', 19, '', NULL, NULL, NULL, NULL, NULL, NULL),
(112, 'Add Travel', 1, 'travels/trvoucher', 19, '', NULL, NULL, NULL, NULL, NULL, NULL),
(113, 'View Travel', 0, 'travels/view', 19, '', NULL, NULL, NULL, NULL, NULL, NULL),
(114, 'Leave Approval', 0, 'leaves/approval', 19, '', NULL, NULL, NULL, NULL, NULL, NULL),
(115, 'MyProfile', 1, 'users/myprofile', 20, '', NULL, NULL, NULL, NULL, NULL, NULL),
(116, 'Add Leaves', 1, 'leaves/add', 20, '', NULL, NULL, NULL, NULL, NULL, NULL),
(117, 'View Leaves', 1, 'leaves/view', 20, '', NULL, NULL, NULL, NULL, NULL, NULL),
(118, 'Add Travel', 1, 'travels/trvoucher', 20, '', NULL, NULL, NULL, NULL, NULL, NULL),
(119, 'View Travel', 0, 'travels/view', 20, '', NULL, NULL, NULL, NULL, NULL, NULL),
(120, 'Leave Approval', 0, 'leaves/approval', 20, '', NULL, NULL, NULL, NULL, NULL, NULL),
(121, 'MyProfile', 1, 'users/myprofile', 21, '', NULL, NULL, NULL, NULL, NULL, NULL),
(122, 'Add Leaves', 1, 'leaves/add', 21, '', NULL, NULL, NULL, NULL, NULL, NULL),
(123, 'View Leaves', 1, 'leaves/view', 21, '', NULL, NULL, NULL, NULL, NULL, NULL),
(124, 'Add Travel', 1, 'travels/trvoucher', 21, '', NULL, NULL, NULL, NULL, NULL, NULL),
(125, 'View Travel', 0, 'travels/view', 21, '', NULL, NULL, NULL, NULL, NULL, NULL),
(126, 'Leave Approval', 0, 'leaves/approval', 21, '', NULL, NULL, NULL, NULL, NULL, NULL),
(127, 'MyProfile', 1, 'users/myprofile', 22, '', NULL, NULL, NULL, NULL, NULL, NULL),
(128, 'Add Leaves', 1, 'leaves/add', 22, '', NULL, NULL, NULL, NULL, NULL, NULL),
(129, 'View Leaves', 1, 'leaves/view', 22, '', NULL, NULL, NULL, NULL, NULL, NULL),
(130, 'Add Travel', 1, 'travels/trvoucher', 22, '', NULL, NULL, NULL, NULL, NULL, NULL),
(131, 'View Travel', 0, 'travels/view', 22, '', NULL, NULL, NULL, NULL, NULL, NULL),
(132, 'Leave Approval', 0, 'leaves/approval', 22, '', NULL, NULL, NULL, NULL, NULL, NULL),
(133, 'MyProfile', 1, 'users/myprofile', 23, '', NULL, NULL, NULL, NULL, NULL, NULL),
(134, 'Add Leaves', 1, 'leaves/add', 23, '', NULL, NULL, NULL, NULL, NULL, NULL),
(135, 'View Leaves', 1, 'leaves/view', 23, '', NULL, NULL, NULL, NULL, NULL, NULL),
(136, 'Add Travel', 1, 'travels/trvoucher', 23, '', NULL, NULL, NULL, NULL, NULL, NULL),
(137, 'View Travel', 0, 'travels/view', 23, '', NULL, NULL, NULL, NULL, NULL, NULL),
(138, 'Leave Approval', 0, 'leaves/approval', 23, '', NULL, NULL, NULL, NULL, NULL, NULL),
(139, 'MyProfile', 1, 'users/myprofile', 24, '', NULL, NULL, NULL, NULL, NULL, NULL),
(140, 'Add Leaves', 1, 'leaves/add', 24, '', NULL, NULL, NULL, NULL, NULL, NULL),
(141, 'View Leaves', 1, 'leaves/view', 24, '', NULL, NULL, NULL, NULL, NULL, NULL),
(142, 'Add Travel', 1, 'travels/trvoucher', 24, '', NULL, NULL, NULL, NULL, NULL, NULL),
(143, 'View Travel', 0, 'travels/view', 24, '', NULL, NULL, NULL, NULL, NULL, NULL),
(144, 'Leave Approval', 0, 'leaves/approval', 24, '', NULL, NULL, NULL, NULL, NULL, NULL),
(145, 'MyProfile', 1, 'users/myprofile', 25, '', NULL, NULL, NULL, NULL, NULL, NULL),
(146, 'Add Leaves', 1, 'leaves/add', 25, '', NULL, NULL, NULL, NULL, NULL, NULL),
(147, 'View Leaves', 1, 'leaves/view', 25, '', NULL, NULL, NULL, NULL, NULL, NULL),
(148, 'Add Travel', 1, 'travels/trvoucher', 25, '', NULL, NULL, NULL, NULL, NULL, NULL),
(149, 'View Travel', 0, 'travels/view', 25, '', NULL, NULL, NULL, NULL, NULL, NULL),
(150, 'Leave Approval', 0, 'leaves/approval', 25, '', NULL, NULL, NULL, NULL, NULL, NULL),
(151, 'MyProfile', 1, 'users/myprofile', 26, '', NULL, NULL, NULL, NULL, NULL, NULL),
(152, 'Add Leaves', 1, 'leaves/add', 26, '', NULL, NULL, NULL, NULL, NULL, NULL),
(153, 'View Leaves', 1, 'leaves/view', 26, '', NULL, NULL, NULL, NULL, NULL, NULL),
(154, 'Add Travel', 1, 'travels/trvoucher', 26, '', NULL, NULL, NULL, NULL, NULL, NULL),
(155, 'View Travel', 0, 'travels/view', 26, '', NULL, NULL, NULL, NULL, NULL, NULL),
(156, 'Leave Approval', 0, 'leaves/approval', 26, '', NULL, NULL, NULL, NULL, NULL, NULL),
(157, 'MyProfile', 1, 'users/myprofile', 27, '', NULL, NULL, NULL, NULL, NULL, NULL),
(158, 'Add Leaves', 1, 'leaves/add', 27, '', NULL, NULL, NULL, NULL, NULL, NULL),
(159, 'View Leaves', 1, 'leaves/view', 27, '', NULL, NULL, NULL, NULL, NULL, NULL),
(160, 'Add Travel', 1, 'travels/trvoucher', 27, '', NULL, NULL, NULL, NULL, NULL, NULL),
(161, 'View Travel', 0, 'travels/view', 27, '', NULL, NULL, NULL, NULL, NULL, NULL),
(162, 'Leave Approval', 0, 'leaves/approval', 27, '', NULL, NULL, NULL, NULL, NULL, NULL),
(163, 'MyProfile', 1, 'users/myprofile', 28, '', NULL, NULL, NULL, NULL, NULL, NULL),
(164, 'Add Leaves', 1, 'leaves/add', 28, '', NULL, NULL, NULL, NULL, NULL, NULL),
(165, 'View Leaves', 1, 'leaves/view', 28, '', NULL, NULL, NULL, NULL, NULL, NULL),
(166, 'Add Travel', 1, 'travels/trvoucher', 28, '', NULL, NULL, NULL, NULL, NULL, NULL),
(167, 'View Travel', 0, 'travels/view', 28, '', NULL, NULL, NULL, NULL, NULL, NULL),
(168, 'Leave Approval', 0, 'leaves/approval', 28, '', NULL, NULL, NULL, NULL, NULL, NULL),
(169, 'MyProfile', 1, 'users/myprofile', 29, '', NULL, NULL, NULL, NULL, NULL, NULL),
(170, 'Add Leaves', 1, 'leaves/add', 29, '', NULL, NULL, NULL, NULL, NULL, NULL),
(171, 'View Leaves', 1, 'leaves/view', 29, '', NULL, NULL, NULL, NULL, NULL, NULL),
(172, 'Add Travel', 1, 'travels/trvoucher', 29, '', NULL, NULL, NULL, NULL, NULL, NULL),
(173, 'View Travel', 0, 'travels/view', 29, '', NULL, NULL, NULL, NULL, NULL, NULL),
(174, 'Leave Approval', 0, 'leaves/approval', 29, '', NULL, NULL, NULL, NULL, NULL, NULL),
(175, 'MyProfile', 1, 'users/myprofile', 30, '', NULL, NULL, NULL, NULL, NULL, NULL),
(176, 'Add Leaves', 1, 'leaves/add', 30, '', NULL, NULL, NULL, NULL, NULL, NULL),
(177, 'View Leaves', 1, 'leaves/view', 30, '', NULL, NULL, NULL, NULL, NULL, NULL),
(178, 'Add Travel', 1, 'travels/trvoucher', 30, '', NULL, NULL, NULL, NULL, NULL, NULL),
(179, 'View Travel', 0, 'travels/view', 30, '', NULL, NULL, NULL, NULL, NULL, NULL),
(180, 'Leave Approval', 0, 'leaves/approval', 30, '', NULL, NULL, NULL, NULL, NULL, NULL),
(181, 'MyProfile', 1, 'users/myprofile', 31, '', NULL, NULL, NULL, NULL, NULL, NULL),
(182, 'Add Leaves', 1, 'leaves/add', 31, '', NULL, NULL, NULL, NULL, NULL, NULL),
(183, 'View Leaves', 1, 'leaves/view', 31, '', NULL, NULL, NULL, NULL, NULL, NULL),
(184, 'Add Travel', 1, 'travels/trvoucher', 31, '', NULL, NULL, NULL, NULL, NULL, NULL),
(185, 'View Travel', 0, 'travels/view', 31, '', NULL, NULL, NULL, NULL, NULL, NULL),
(186, 'Leave Approval', 0, 'leaves/approval', 31, '', NULL, NULL, NULL, NULL, NULL, NULL),
(187, 'MyProfile', 1, 'users/myprofile', 32, '', NULL, NULL, NULL, NULL, NULL, NULL),
(188, 'Add Leaves', 1, 'leaves/add', 32, '', NULL, NULL, NULL, NULL, NULL, NULL),
(189, 'View Leaves', 1, 'leaves/view', 32, '', NULL, NULL, NULL, NULL, NULL, NULL),
(190, 'Add Travel', 1, 'travels/trvoucher', 32, '', NULL, NULL, NULL, NULL, NULL, NULL),
(191, 'View Travel', 0, 'travels/view', 32, '', NULL, NULL, NULL, NULL, NULL, NULL),
(192, 'Leave Approval', 0, 'leaves/approval', 32, '', NULL, NULL, NULL, NULL, NULL, NULL),
(193, 'MyProfile', 1, 'users/myprofile', 33, '', NULL, NULL, NULL, NULL, NULL, NULL),
(194, 'Add Leaves', 1, 'leaves/add', 33, '', NULL, NULL, NULL, NULL, NULL, NULL),
(195, 'View Leaves', 1, 'leaves/view', 33, '', NULL, NULL, NULL, NULL, NULL, NULL),
(196, 'Add Travel', 1, 'travels/trvoucher', 33, '', NULL, NULL, NULL, NULL, NULL, NULL),
(197, 'View Travel', 0, 'travels/view', 33, '', NULL, NULL, NULL, NULL, NULL, NULL),
(198, 'Leave Approval', 0, 'leaves/approval', 33, '', NULL, NULL, NULL, NULL, NULL, NULL),
(199, 'MyProfile', 1, 'users/myprofile', 34, '', NULL, NULL, NULL, NULL, NULL, NULL),
(200, 'Add Leaves', 1, 'leaves/add', 34, '', NULL, NULL, NULL, NULL, NULL, NULL),
(201, 'View Leaves', 1, 'leaves/view', 34, '', NULL, NULL, NULL, NULL, NULL, NULL),
(202, 'Add Travel', 1, 'travels/trvoucher', 34, '', NULL, NULL, NULL, NULL, NULL, NULL),
(203, 'View Travel', 0, 'travels/view', 34, '', NULL, NULL, NULL, NULL, NULL, NULL),
(204, 'Leave Approval', 0, 'leaves/approval', 34, '', NULL, NULL, NULL, NULL, NULL, NULL),
(205, 'MyProfile', 1, 'users/myprofile', 35, '', NULL, NULL, NULL, NULL, NULL, NULL),
(206, 'Add Leaves', 1, 'leaves/add', 35, '', NULL, NULL, NULL, NULL, NULL, NULL),
(207, 'View Leaves', 1, 'leaves/view', 35, '', NULL, NULL, NULL, NULL, NULL, NULL),
(208, 'Add Travel', 1, 'travels/trvoucher', 35, '', NULL, NULL, NULL, NULL, NULL, NULL),
(209, 'View Travel', 0, 'travels/view', 35, '', NULL, NULL, NULL, NULL, NULL, NULL),
(210, 'Leave Approval', 0, 'leaves/approval', 35, '', NULL, NULL, NULL, NULL, NULL, NULL),
(211, 'MyProfile', 1, 'users/myprofile', 36, '', NULL, NULL, NULL, NULL, NULL, NULL),
(212, 'Add Leaves', 1, 'leaves/add', 36, '', NULL, NULL, NULL, NULL, NULL, NULL),
(213, 'View Leaves', 1, 'leaves/view', 36, '', NULL, NULL, NULL, NULL, NULL, NULL),
(214, 'Add Travel', 1, 'travels/trvoucher', 36, '', NULL, NULL, NULL, NULL, NULL, NULL),
(215, 'View Travel', 0, 'travels/view', 36, '', NULL, NULL, NULL, NULL, NULL, NULL),
(216, 'Leave Approval', 0, 'leaves/approval', 36, '', NULL, NULL, NULL, NULL, NULL, NULL),
(217, 'MyProfile', 1, 'users/myprofile', 37, '', NULL, NULL, NULL, NULL, NULL, NULL),
(218, 'Add Leaves', 1, 'leaves/add', 37, '', NULL, NULL, NULL, NULL, NULL, NULL),
(219, 'View Leaves', 1, 'leaves/view', 37, '', NULL, NULL, NULL, NULL, NULL, NULL),
(220, 'Add Travel', 1, 'travels/trvoucher', 37, '', NULL, NULL, NULL, NULL, NULL, NULL),
(221, 'View Travel', 0, 'travels/view', 37, '', NULL, NULL, NULL, NULL, NULL, NULL),
(222, 'Leave Approval', 0, 'leaves/approval', 37, '', NULL, NULL, NULL, NULL, NULL, NULL),
(223, 'MyProfile', 1, 'users/myprofile', 38, '', NULL, NULL, NULL, NULL, NULL, NULL),
(224, 'Add Leaves', 1, 'leaves/add', 38, '', NULL, NULL, NULL, NULL, NULL, NULL),
(225, 'View Leaves', 1, 'leaves/view', 38, '', NULL, NULL, NULL, NULL, NULL, NULL),
(226, 'Add Travel', 1, 'travels/trvoucher', 38, '', NULL, NULL, NULL, NULL, NULL, NULL),
(227, 'View Travel', 0, 'travels/view', 38, '', NULL, NULL, NULL, NULL, NULL, NULL),
(228, 'Leave Approval', 0, 'leaves/approval', 38, '', NULL, NULL, NULL, NULL, NULL, NULL),
(229, 'MyProfile', 1, 'users/myprofile', 39, '', NULL, NULL, NULL, NULL, NULL, NULL),
(230, 'Add Leaves', 1, 'leaves/add', 39, '', NULL, NULL, NULL, NULL, NULL, NULL),
(231, 'View Leaves', 1, 'leaves/view', 39, '', NULL, NULL, NULL, NULL, NULL, NULL),
(232, 'Add Travel', 1, 'travels/trvoucher', 39, '', NULL, NULL, NULL, NULL, NULL, NULL),
(233, 'View Travel', 0, 'travels/view', 39, '', NULL, NULL, NULL, NULL, NULL, NULL),
(234, 'Leave Approval', 0, 'leaves/approval', 39, '', NULL, NULL, NULL, NULL, NULL, NULL),
(235, 'MyProfile', 1, 'users/myprofile', 40, '', NULL, NULL, NULL, NULL, NULL, NULL),
(236, 'Add Leaves', 1, 'leaves/add', 40, '', NULL, NULL, NULL, NULL, NULL, NULL),
(237, 'View Leaves', 1, 'leaves/view', 40, '', NULL, NULL, NULL, NULL, NULL, NULL),
(238, 'Add Travel', 1, 'travels/trvoucher', 40, '', NULL, NULL, NULL, NULL, NULL, NULL),
(239, 'View Travel', 0, 'travels/view', 40, '', NULL, NULL, NULL, NULL, NULL, NULL),
(240, 'Leave Approval', 0, 'leaves/approval', 40, '', NULL, NULL, NULL, NULL, NULL, NULL),
(241, 'MyProfile', 1, 'users/myprofile', 41, '', NULL, NULL, NULL, NULL, NULL, NULL),
(242, 'Add Leaves', 1, 'leaves/add', 41, '', NULL, NULL, NULL, NULL, NULL, NULL),
(243, 'View Leaves', 1, 'leaves/view', 41, '', NULL, NULL, NULL, NULL, NULL, NULL),
(244, 'Add Travel', 1, 'travels/trvoucher', 41, '', NULL, NULL, NULL, NULL, NULL, NULL),
(245, 'View Travel', 0, 'travels/view', 41, '', NULL, NULL, NULL, NULL, NULL, NULL),
(246, 'Leave Approval', 0, 'leaves/approval', 41, '', NULL, NULL, NULL, NULL, NULL, NULL),
(247, 'MyProfile', 1, 'users/myprofile', 42, '', NULL, NULL, NULL, NULL, NULL, NULL),
(248, 'Add Leaves', 1, 'leaves/add', 42, '', NULL, NULL, NULL, NULL, NULL, NULL),
(249, 'View Leaves', 1, 'leaves/view', 42, '', NULL, NULL, NULL, NULL, NULL, NULL),
(250, 'Add Travel', 1, 'travels/trvoucher', 42, '', NULL, NULL, NULL, NULL, NULL, NULL),
(251, 'View Travel', 0, 'travels/view', 42, '', NULL, NULL, NULL, NULL, NULL, NULL),
(252, 'Leave Approval', 0, 'leaves/approval', 42, '', NULL, NULL, NULL, NULL, NULL, NULL),
(253, 'MyProfile', 1, 'users/myprofile', 43, '', NULL, NULL, NULL, NULL, NULL, NULL),
(254, 'Add Leaves', 1, 'leaves/add', 43, '', NULL, NULL, NULL, NULL, NULL, NULL),
(255, 'View Leaves', 1, 'leaves/view', 43, '', NULL, NULL, NULL, NULL, NULL, NULL),
(256, 'Add Travel', 1, 'travels/trvoucher', 43, '', NULL, NULL, NULL, NULL, NULL, NULL),
(257, 'View Travel', 0, 'travels/view', 43, '', NULL, NULL, NULL, NULL, NULL, NULL),
(258, 'Leave Approval', 0, 'leaves/approval', 43, '', NULL, NULL, NULL, NULL, NULL, NULL),
(259, 'MyProfile', 1, 'users/myprofile', 44, '', NULL, NULL, NULL, NULL, NULL, NULL),
(260, 'Add Leaves', 1, 'leaves/add', 44, '', NULL, NULL, NULL, NULL, NULL, NULL),
(261, 'View Leaves', 1, 'leaves/view', 44, '', NULL, NULL, NULL, NULL, NULL, NULL),
(262, 'Add Travel', 1, 'travels/trvoucher', 44, '', NULL, NULL, NULL, NULL, NULL, NULL),
(263, 'View Travel', 0, 'travels/view', 44, '', NULL, NULL, NULL, NULL, NULL, NULL),
(264, 'Leave Approval', 0, 'leaves/approval', 44, '', NULL, NULL, NULL, NULL, NULL, NULL),
(265, 'MyProfile', 1, 'users/myprofile', 45, '', NULL, NULL, NULL, NULL, NULL, NULL),
(266, 'Add Leaves', 1, 'leaves/add', 45, '', NULL, NULL, NULL, NULL, NULL, NULL),
(267, 'View Leaves', 1, 'leaves/view', 45, '', NULL, NULL, NULL, NULL, NULL, NULL),
(268, 'Add Travel', 1, 'travels/trvoucher', 45, '', NULL, NULL, NULL, NULL, NULL, NULL),
(269, 'View Travel', 0, 'travels/view', 45, '', NULL, NULL, NULL, NULL, NULL, NULL),
(270, 'Leave Approval', 0, 'leaves/approval', 45, '', NULL, NULL, NULL, NULL, NULL, NULL),
(271, 'MyProfile', 1, 'users/myprofile', 46, '', NULL, NULL, NULL, NULL, NULL, NULL),
(272, 'Add Leaves', 1, 'leaves/add', 46, '', NULL, NULL, NULL, NULL, NULL, NULL),
(273, 'View Leaves', 1, 'leaves/view', 46, '', NULL, NULL, NULL, NULL, NULL, NULL),
(274, 'Add Travel', 1, 'travels/trvoucher', 46, '', NULL, NULL, NULL, NULL, NULL, NULL),
(275, 'View Travel', 0, 'travels/view', 46, '', NULL, NULL, NULL, NULL, NULL, NULL),
(276, 'Leave Approval', 0, 'leaves/approval', 46, '', NULL, NULL, NULL, NULL, NULL, NULL),
(277, 'MyProfile', 1, 'users/myprofile', 47, '', NULL, NULL, NULL, NULL, NULL, NULL),
(278, 'Add Leaves', 1, 'leaves/add', 47, '', NULL, NULL, NULL, NULL, NULL, NULL),
(279, 'View Leaves', 1, 'leaves/view', 47, '', NULL, NULL, NULL, NULL, NULL, NULL),
(280, 'Add Travel', 1, 'travels/trvoucher', 47, '', NULL, NULL, NULL, NULL, NULL, NULL),
(281, 'View Travel', 0, 'travels/view', 47, '', NULL, NULL, NULL, NULL, NULL, NULL),
(282, 'Leave Approval', 0, 'leaves/approval', 47, '', NULL, NULL, NULL, NULL, NULL, NULL),
(283, 'MyProfile', 1, 'users/myprofile', 48, '', NULL, NULL, NULL, NULL, NULL, NULL),
(284, 'Add Leaves', 1, 'leaves/add', 48, '', NULL, NULL, NULL, NULL, NULL, NULL),
(285, 'View Leaves', 1, 'leaves/view', 48, '', NULL, NULL, NULL, NULL, NULL, NULL),
(286, 'Add Travel', 1, 'travels/trvoucher', 48, '', NULL, NULL, NULL, NULL, NULL, NULL),
(287, 'View Travel', 0, 'travels/view', 48, '', NULL, NULL, NULL, NULL, NULL, NULL),
(288, 'Leave Approval', 0, 'leaves/approval', 48, '', NULL, NULL, NULL, NULL, NULL, NULL),
(289, 'MyProfile', 1, 'users/myprofile', 49, '', NULL, NULL, NULL, NULL, NULL, NULL),
(290, 'Add Leaves', 1, 'leaves/add', 49, '', NULL, NULL, NULL, NULL, NULL, NULL),
(291, 'View Leaves', 1, 'leaves/view', 49, '', NULL, NULL, NULL, NULL, NULL, NULL),
(292, 'Add Travel', 1, 'travels/trvoucher', 49, '', NULL, NULL, NULL, NULL, NULL, NULL),
(293, 'View Travel', 0, 'travels/view', 49, '', NULL, NULL, NULL, NULL, NULL, NULL),
(294, 'Leave Approval', 0, 'leaves/approval', 49, '', NULL, NULL, NULL, NULL, NULL, NULL),
(295, 'MyProfile', 1, 'users/myprofile', 50, '', NULL, NULL, NULL, NULL, NULL, NULL),
(296, 'Add Leaves', 1, 'leaves/add', 50, '', NULL, NULL, NULL, NULL, NULL, NULL),
(297, 'View Leaves', 1, 'leaves/view', 50, '', NULL, NULL, NULL, NULL, NULL, NULL),
(298, 'Add Travel', 1, 'travels/trvoucher', 50, '', NULL, NULL, NULL, NULL, NULL, NULL),
(299, 'View Travel', 0, 'travels/view', 50, '', NULL, NULL, NULL, NULL, NULL, NULL),
(300, 'Leave Approval', 0, 'leaves/approval', 50, '', NULL, NULL, NULL, NULL, NULL, NULL),
(301, 'MyProfile', 1, 'users/myprofile', 51, '', NULL, NULL, NULL, NULL, NULL, NULL),
(302, 'Add Leaves', 1, 'leaves/add', 51, '', NULL, NULL, NULL, NULL, NULL, NULL),
(303, 'View Leaves', 1, 'leaves/view', 51, '', NULL, NULL, NULL, NULL, NULL, NULL),
(304, 'Add Travel', 1, 'travels/trvoucher', 51, '', NULL, NULL, NULL, NULL, NULL, NULL),
(305, 'View Travel', 0, 'travels/view', 51, '', NULL, NULL, NULL, NULL, NULL, NULL),
(306, 'Leave Approval', 0, 'leaves/approval', 51, '', NULL, NULL, NULL, NULL, NULL, NULL),
(307, 'MyProfile', 1, 'users/myprofile', 52, '', NULL, NULL, NULL, NULL, NULL, NULL),
(308, 'Add Leaves', 1, 'leaves/add', 52, '', NULL, NULL, NULL, NULL, NULL, NULL),
(309, 'View Leaves', 1, 'leaves/view', 52, '', NULL, NULL, NULL, NULL, NULL, NULL),
(310, 'Add Travel', 1, 'travels/trvoucher', 52, '', NULL, NULL, NULL, NULL, NULL, NULL),
(311, 'View Travel', 0, 'travels/view', 52, '', NULL, NULL, NULL, NULL, NULL, NULL),
(312, 'Leave Approval', 0, 'leaves/approval', 52, '', NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `icon_user`
--

CREATE TABLE `icon_user` (
  `id` int(10) NOT NULL,
  `icon_id` int(10) DEFAULT NULL,
  `myprofile_id` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `icon_user`
--

INSERT INTO `icon_user` (`id`, `icon_id`, `myprofile_id`) VALUES
(164, 50, 171),
(165, 51, 171);

-- --------------------------------------------------------

--
-- Table structure for table `important_doc_category`
--

CREATE TABLE `important_doc_category` (
  `id` int(10) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `comp_code` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `important_doc_category`
--

INSERT INTO `important_doc_category` (`id`, `title`, `comp_code`) VALUES
(1, 'Financial Document', '01'),
(2, 'Educational', '01');

-- --------------------------------------------------------

--
-- Table structure for table `import_log`
--

CREATE TABLE `import_log` (
  `id` int(20) NOT NULL,
  `function_name` varchar(255) NOT NULL,
  `module_related` varchar(255) NOT NULL,
  `last_run` date NOT NULL,
  `status` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `installer_info`
--

CREATE TABLE `installer_info` (
  `id` int(10) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `install_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `installer_info`
--

INSERT INTO `installer_info` (`id`, `name`, `email`, `install_date`) VALUES
(1, 'Rishabh', 'abc@gmail.co', '2017-11-08');

-- --------------------------------------------------------

--
-- Table structure for table `install_country`
--

CREATE TABLE `install_country` (
  `id` int(10) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `url` varchar(100) DEFAULT NULL,
  `others` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `install_country`
--

INSERT INTO `install_country` (`id`, `name`, `url`, `others`) VALUES
(1, 'KENYA', 'http://feeds.feedburner.com/ndtvnews-top-stories', '0'),
(2, 'GHANA', 'http://feeds.feedburner.com/ndtvnews-top-stories', '0'),
(3, 'INDIA', 'http://feeds.feedburner.com/ndtvnews-top-stories', '1'),
(4, 'UGANDA', 'http://www.einnews.com/rss/JMIqSSbYFGEnBaYZ', '0');

-- --------------------------------------------------------

--
-- Table structure for table `invest_dtl`
--

CREATE TABLE `invest_dtl` (
  `id` int(40) NOT NULL,
  `valid_strt_dt` date DEFAULT NULL,
  `valid_end_dt` date DEFAULT NULL,
  `doc_req_chk` varchar(5) DEFAULT NULL,
  `max_limit_rule` varchar(1) DEFAULT NULL,
  `max_limit_chk` varchar(1) DEFAULT NULL,
  `org_id` varchar(40) DEFAULT NULL,
  `sect_id` varchar(30) NOT NULL,
  `invest_id` varchar(30) NOT NULL,
  `invest_max_limit` varchar(30) DEFAULT NULL,
  `max_limit_perc` varchar(30) DEFAULT NULL,
  `remark` varchar(255) DEFAULT NULL,
  `exmp_chk` varchar(1) DEFAULT NULL,
  `fy_id` int(20) DEFAULT NULL,
  `ora_fy_id` int(10) NOT NULL,
  `hover_description` varchar(255) DEFAULT NULL,
  `sloc_id` varchar(25) DEFAULT NULL,
  `cld_id` varchar(22) DEFAULT NULL,
  `ho_org_id` varchar(22) DEFAULT NULL,
  `emp_doc_id` varchar(52) DEFAULT NULL,
  `doc_id` varchar(52) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `kpi_map_emps`
--

CREATE TABLE `kpi_map_emps` (
  `id` int(11) NOT NULL,
  `kra_masters_id` int(11) DEFAULT NULL,
  `kpi_masters_id` int(11) NOT NULL,
  `myprofile_id` int(11) NOT NULL,
  `kpi_user_emp_code` varchar(100) DEFAULT NULL,
  `level_desg_code` varchar(100) DEFAULT NULL,
  `target` int(11) DEFAULT NULL,
  `weightage` varchar(40) DEFAULT NULL,
  `from_date` date DEFAULT NULL,
  `to_date` date DEFAULT NULL,
  `remark` varchar(250) DEFAULT NULL,
  `status` int(11) DEFAULT '0',
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `kpi_masters`
--

CREATE TABLE `kpi_masters` (
  `id` int(11) NOT NULL,
  `kra_id` int(11) NOT NULL,
  `kpi_name` text,
  `weightage` varchar(40) DEFAULT NULL,
  `priority` int(11) DEFAULT NULL,
  `groups` varchar(100) DEFAULT NULL,
  `created_at` date DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `user_emp_code` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `kpi_type`
--

CREATE TABLE `kpi_type` (
  `id` int(1) NOT NULL,
  `kpi_type` int(1) NOT NULL,
  `kpi_type_value` varchar(15) NOT NULL,
  `created_date` datetime NOT NULL,
  `updated_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `kra_comp_overall_rating`
--

CREATE TABLE `kra_comp_overall_rating` (
  `id` int(11) NOT NULL,
  `financial_year` varchar(40) NOT NULL,
  `emp_code` int(11) NOT NULL,
  `comp_code` varchar(50) NOT NULL,
  `emp_self_overall_achiev` float NOT NULL,
  `emp_self_overall_rating` float NOT NULL,
  `appraiser_id` int(11) NOT NULL,
  `appraiser_comp_code` varchar(50) NOT NULL,
  `appraiser_self_overall_achiev` float NOT NULL,
  `appraiser_self_overall_rating` int(2) NOT NULL,
  `appraiser_comp_overall_rating` float NOT NULL,
  `reviewer_id` int(11) NOT NULL,
  `reviewer_comp_code` varchar(50) NOT NULL,
  `reviewer_self_overall_achiev` float NOT NULL,
  `reviewer_self_overall_rating` float NOT NULL,
  `reviewer_comp_overall_rating` float NOT NULL,
  `moderator_id` int(11) NOT NULL,
  `moderator_comp_code` varchar(50) NOT NULL,
  `moderator_self_overall_achiev` float NOT NULL,
  `moderator_self_overall_rating` float NOT NULL,
  `moderator_comp_overall_rating` float NOT NULL,
  `kra_overall_rating` float NOT NULL,
  `comp_overall_rating` float NOT NULL,
  `kra_comp_overall_rating` float NOT NULL,
  `kra_comp_overall_result` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `kra_kpi_process`
--

CREATE TABLE `kra_kpi_process` (
  `id` int(11) NOT NULL,
  `kra_masters_id` int(11) DEFAULT NULL,
  `kpi_masters_id` int(11) DEFAULT NULL,
  `kra_map_emp_id` int(11) DEFAULT NULL,
  `kpi_map_emps_id` int(11) DEFAULT NULL,
  `kra_kpi_assign_user` varchar(200) DEFAULT NULL,
  `myprofile_id` varchar(200) DEFAULT NULL,
  `user_emp_id` varchar(200) DEFAULT NULL,
  `comment` text COMMENT '(Remark)',
  `kra_comments` text COMMENT '(Superrior give the comment to Appraisee)',
  `units` varchar(200) DEFAULT NULL,
  `process_quarter` int(11) DEFAULT '0',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `status` int(10) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `kra_kpi_slab`
--

CREATE TABLE `kra_kpi_slab` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `min_val` varchar(50) DEFAULT NULL,
  `max_val` varchar(50) DEFAULT NULL,
  `amt` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `kra_kpi_slab`
--

INSERT INTO `kra_kpi_slab` (`id`, `name`, `min_val`, `max_val`, `amt`) VALUES
(1, 'Unsatisfactory', '0', '2.50', 1000),
(2, 'Satisfactory', '2.51', '3.00', 2000),
(3, 'Above Average', '3.01', '3.74', 4000),
(4, 'Good', '3.75', '4.50', 6000),
(5, 'Very Good', '4.51', '5.00', 8000);

-- --------------------------------------------------------

--
-- Table structure for table `kra_map_emp`
--

CREATE TABLE `kra_map_emp` (
  `id` int(11) NOT NULL,
  `kramasters_id` int(20) DEFAULT NULL,
  `myprofile_id` int(10) DEFAULT NULL,
  `kra_user_emp_code` varchar(100) DEFAULT NULL,
  `level_desg_code` varchar(100) DEFAULT NULL,
  `target` int(11) DEFAULT NULL,
  `weightage` varchar(40) DEFAULT NULL,
  `from_date` date DEFAULT NULL,
  `to_date` date DEFAULT NULL,
  `remark` varchar(250) DEFAULT NULL,
  `status` int(11) DEFAULT '0',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `kra_masters`
--

CREATE TABLE `kra_masters` (
  `id` int(10) NOT NULL,
  `kra_name` varchar(250) DEFAULT NULL,
  `created_at` date DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `user_emp_code` int(11) DEFAULT NULL,
  `desg_code` varchar(100) DEFAULT NULL,
  `groups` varchar(100) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `kra_priorities`
--

CREATE TABLE `kra_priorities` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `kra_priorities`
--

INSERT INTO `kra_priorities` (`id`, `name`) VALUES
(1, 'Low'),
(2, 'Medium'),
(3, 'High');

-- --------------------------------------------------------

--
-- Table structure for table `kra_rating`
--

CREATE TABLE `kra_rating` (
  `id` int(5) NOT NULL,
  `ho_org_id` varchar(40) NOT NULL,
  `org_id` varchar(40) NOT NULL,
  `rating_scale` int(1) NOT NULL,
  `achievement_from` int(2) NOT NULL,
  `achievement_to` int(2) DEFAULT NULL,
  `comment` text,
  `status` int(1) NOT NULL,
  `created_date` date NOT NULL,
  `created_by` varchar(40) NOT NULL,
  `is_deleted` int(1) NOT NULL,
  `deleted_date` date NOT NULL,
  `deleted_by` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `kra_slabs`
--

CREATE TABLE `kra_slabs` (
  `id` int(11) NOT NULL,
  `comp_code` varchar(20) NOT NULL,
  `desg_code` varchar(20) NOT NULL,
  `dept_code` varchar(20) NOT NULL,
  `kra_rating_min` varchar(100) NOT NULL,
  `amt_inc` int(100) NOT NULL,
  `department_id` int(10) NOT NULL,
  `designation_id` int(10) NOT NULL,
  `kra_rating_max` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `kra_target`
--

CREATE TABLE `kra_target` (
  `id` int(11) NOT NULL,
  `kra_name` text NOT NULL,
  `financial_year` varchar(50) NOT NULL,
  `weightage` int(2) NOT NULL,
  `measure` varchar(250) NOT NULL,
  `qualifying` int(2) NOT NULL,
  `target` int(2) NOT NULL,
  `stretched` int(2) NOT NULL,
  `emp_code` int(11) NOT NULL,
  `comp_code` varchar(40) NOT NULL,
  `emp_status` int(1) NOT NULL,
  `self_score_actual` varchar(10) NOT NULL,
  `self_score_achiev` varchar(10) NOT NULL,
  `self_score_comment` text NOT NULL,
  `appraiser_id` int(11) NOT NULL,
  `appraiser_comp_code` varchar(40) NOT NULL,
  `appraiser_status` int(1) NOT NULL,
  `appraiser_score_achiev` varchar(10) NOT NULL,
  `appraiser_score_comment` text NOT NULL,
  `reviewer_id` int(11) NOT NULL,
  `reviewer_comp_code` varchar(40) NOT NULL,
  `reviewer_status` int(1) NOT NULL,
  `reviewer_score_achiev` varchar(10) NOT NULL,
  `reviewer_score_comment` text NOT NULL,
  `final_status` int(1) NOT NULL,
  `reviewer_final_status` int(1) NOT NULL,
  `appraiser_status_comment` text NOT NULL,
  `emp_status_comment` text NOT NULL,
  `reviewer_status_comment` text NOT NULL,
  `moderator_id` int(11) NOT NULL,
  `moderator_comp_code` varchar(50) NOT NULL,
  `moderator_status` int(1) NOT NULL,
  `moderator_score_achiev` int(5) DEFAULT NULL,
  `moderator_score_comment` text,
  `created_date` date NOT NULL,
  `appraiser_to_reviewer` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `kra_type`
--

CREATE TABLE `kra_type` (
  `id` int(1) NOT NULL,
  `kra_type` int(1) NOT NULL,
  `kra_type_value` varchar(15) NOT NULL,
  `created_date` datetime NOT NULL,
  `updated_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `kra_type`
--

INSERT INTO `kra_type` (`id`, `kra_type`, `kra_type_value`, `created_date`, `updated_date`) VALUES
(1, 2, 'Pre Define', '2016-10-19 00:00:00', '2016-10-19 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `labels`
--

CREATE TABLE `labels` (
  `id` int(11) NOT NULL,
  `label_block_id` int(22) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  `label_status` int(11) DEFAULT NULL,
  `type` varchar(20) DEFAULT NULL,
  `priority` int(10) DEFAULT NULL,
  `options_id` int(20) DEFAULT NULL,
  `css_name` varchar(20) NOT NULL,
  `solc_id` varchar(25) DEFAULT NULL,
  `cld_id` varchar(22) DEFAULT NULL,
  `ho_org_id` varchar(22) DEFAULT NULL,
  `org_id` varchar(22) DEFAULT NULL,
  `emp_doc_id` varchar(52) DEFAULT NULL,
  `doc_id` varchar(52) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `labels`
--

INSERT INTO `labels` (`id`, `label_block_id`, `name`, `label_status`, `type`, `priority`, `options_id`, `css_name`, `solc_id`, `cld_id`, `ho_org_id`, `org_id`, `emp_doc_id`, `doc_id`) VALUES
(1, 2, 'Reporting Manger ', 1, 'others', 1, NULL, '0', NULL, NULL, NULL, NULL, NULL, NULL),
(2, 2, 'Joining Date', 1, NULL, 2, NULL, '0', NULL, NULL, NULL, NULL, NULL, NULL),
(3, 2, 'Date of Birth', 1, NULL, 3, NULL, '0', NULL, NULL, NULL, NULL, NULL, NULL),
(4, 2, 'Blood Group', 1, NULL, 4, NULL, '0', NULL, NULL, NULL, NULL, NULL, NULL),
(5, 6, 'Title', 1, 'text', 1, NULL, 'title', NULL, NULL, NULL, NULL, NULL, NULL),
(6, 6, 'Gender', 1, 'radio', 2, 6, 'gender', NULL, NULL, NULL, NULL, NULL, NULL),
(7, 6, 'Date Of Birth', 1, 'text', 3, NULL, 'dob', NULL, NULL, NULL, NULL, NULL, NULL),
(8, 6, 'Marital Status', 1, 'radio', 4, 2, 'mstatus', NULL, NULL, NULL, NULL, NULL, NULL),
(9, 6, 'Wedding Date', 1, 'text', 5, NULL, 'wedding_date', NULL, NULL, NULL, NULL, NULL, NULL),
(10, 6, 'Pan No', 1, 'text', 6, NULL, 'pan_no', NULL, NULL, NULL, NULL, NULL, NULL),
(11, 6, 'Gaurdian Name', 0, 'text', 6, NULL, 'guardian_name', NULL, NULL, NULL, NULL, NULL, NULL),
(12, 6, 'Gaurdian Relation', 0, 'text', 7, NULL, 'guardian_relation', NULL, NULL, NULL, NULL, NULL, NULL),
(13, 6, 'Blood Group', 1, 'select', 8, 102, 'blood_group', NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `label_block`
--

CREATE TABLE `label_block` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `label_page_id` int(11) NOT NULL,
  `block_status` int(2) NOT NULL,
  `block_heading` varchar(50) NOT NULL,
  `block_priority` int(10) NOT NULL,
  `solc_id` varchar(25) DEFAULT NULL,
  `cld_id` varchar(22) DEFAULT NULL,
  `ho_org_id` varchar(22) DEFAULT NULL,
  `org_id` varchar(22) DEFAULT NULL,
  `emp_doc_id` varchar(52) DEFAULT NULL,
  `doc_id` varchar(52) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `label_block`
--

INSERT INTO `label_block` (`id`, `name`, `label_page_id`, `block_status`, `block_heading`, `block_priority`, `solc_id`, `cld_id`, `ho_org_id`, `org_id`, `emp_doc_id`, `doc_id`) VALUES
(2, 'Profile Pic', 1, 1, 'User Report', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(3, 'Graph', 1, 1, 'User Activity Report', 2, NULL, NULL, NULL, NULL, NULL, NULL),
(4, 'Contact Address', 1, 1, 'Contact Information', 6, NULL, NULL, NULL, NULL, NULL, NULL),
(5, 'Address', 1, 1, 'Address', 5, NULL, NULL, NULL, NULL, NULL, NULL),
(6, 'Personal Information', 1, 1, 'Personal Information', 3, NULL, NULL, NULL, NULL, NULL, NULL),
(7, 'Dependent Details', 1, 0, 'Dependent Details', 4, NULL, NULL, NULL, NULL, NULL, NULL),
(8, 'Qualification', 1, 1, 'Qualification', 7, NULL, NULL, NULL, NULL, NULL, NULL),
(9, 'Previous Employer', 1, 1, 'Previous Employer', 8, NULL, NULL, NULL, NULL, NULL, NULL),
(10, 'Bank Account Details', 1, 1, 'Bank Account Details', 9, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `label_page`
--

CREATE TABLE `label_page` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `applications_id` int(22) DEFAULT NULL,
  `heading` varchar(50) DEFAULT NULL,
  `page_status` int(10) DEFAULT NULL,
  `solc_id` varchar(25) DEFAULT NULL,
  `cld_id` varchar(22) DEFAULT NULL,
  `ho_org_id` varchar(22) DEFAULT NULL,
  `org_id` varchar(22) DEFAULT NULL,
  `emp_doc_id` varchar(52) DEFAULT NULL,
  `doc_id` varchar(52) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `label_page`
--

INSERT INTO `label_page` (`id`, `name`, `applications_id`, `heading`, `page_status`, `solc_id`, `cld_id`, `ho_org_id`, `org_id`, `emp_doc_id`, `doc_id`) VALUES
(1, 'myprofile', 9, 'User Profile', 1, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `leave_configuration`
--

CREATE TABLE `leave_configuration` (
  `id` int(11) NOT NULL,
  `comp_code` varchar(20) NOT NULL,
  `leave_type` varchar(255) NOT NULL,
  `leave_code` varchar(255) NOT NULL,
  `max_days` int(30) NOT NULL,
  `week_off` int(5) NOT NULL,
  `half_day_chk` int(5) NOT NULL,
  `file_upload` int(30) NOT NULL,
  `file_upload_no` int(11) DEFAULT NULL,
  `details` varchar(233) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `leave_configuration`
--

INSERT INTO `leave_configuration` (`id`, `comp_code`, `leave_type`, `leave_code`, `max_days`, `week_off`, `half_day_chk`, `file_upload`, `file_upload_no`, `details`) VALUES
(25, '03', '2', 'PAR0000039', 12, 0, 0, 0, NULL, ''),
(26, '03', '2', 'PAR0000039', 12, 0, 0, 0, NULL, ''),
(27, '01', '2', 'PAR0000108', 12, 0, 0, 0, NULL, ''),
(28, '01', '2', 'PAR0000108', 12, 0, 0, 0, NULL, ''),
(29, '01', '0', 'PAR0000097', 12, 0, 0, 0, NULL, ''),
(30, '02', '0', 'PAR0000048', 12, 0, 0, 0, NULL, ''),
(31, '01', '0', 'PAR0000040', 121, 0, 0, 0, 11, ''),
(32, '01', '0', 'PAR0000097', 1, 0, 1, 1, NULL, ''),
(33, '02', '3', 'PAR0000055', 12, 1, 0, 0, NULL, ''),
(34, '03', '1', 'PAR0000056', 12, 0, 0, 0, NULL, ''),
(35, '03', '0', 'PAR0000028', 123, 0, 0, 0, NULL, ''),
(36, '01', '0', 'PAR0000087', 15, 0, 0, 1, 15, ''),
(37, '01', '1', 'PAR0000108', 15, 0, 0, 1, 14, ''),
(38, 'ESS_Ken', '4', 'PAR0000040', 12, 0, 0, 1, 1, ''),
(40, '01', '0', 'PAR0000087', 10, 0, 0, 1, 191, ''),
(41, '01', '1', 'PAR0000040', 5, 0, 1, 1, 2331, ''),
(42, '02', '1', 'PAR0000040', 1, 1, 1, 1, 3, 'qw');

-- --------------------------------------------------------

--
-- Table structure for table `leave_details`
--

CREATE TABLE `leave_details` (
  `leave_detail_id` int(11) NOT NULL,
  `leave_id` int(11) DEFAULT NULL,
  `emp_code` varchar(40) DEFAULT NULL,
  `leave_code` varchar(40) DEFAULT NULL,
  `leave_reason` varchar(500) DEFAULT NULL,
  `leave_date` date DEFAULT NULL,
  `sanction_date` date DEFAULT NULL,
  `hlfday_leave_chk` varchar(1) DEFAULT NULL,
  `half_type` varchar(10) DEFAULT NULL,
  `leave_status` varchar(20) DEFAULT NULL,
  `leave_action` varchar(20) DEFAULT NULL,
  `remark` varchar(255) DEFAULT NULL,
  `solc_id` varchar(25) DEFAULT NULL,
  `cld_id` varchar(22) DEFAULT NULL,
  `ho_org_id` varchar(22) DEFAULT NULL,
  `org_id` varchar(22) DEFAULT NULL,
  `emp_doc_id` varchar(52) DEFAULT NULL,
  `doc_id` varchar(52) DEFAULT NULL,
  `week_off_chk` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Triggers `leave_details`
--
DELIMITER $$
CREATE TRIGGER `leave_details_after_insert` AFTER UPDATE ON `leave_details` FOR EACH ROW if NEW.leave_status = 5 then
IF @DISABLE_TRIGGERS IS NULL THEN
	INSERT INTO newdata VALUES (NEW.`leave_detail_id`,'leave_details','I');
END IF;
end if
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `leave_encashment_workflow`
--

CREATE TABLE `leave_encashment_workflow` (
  `id` int(10) NOT NULL,
  `leave_encsh_id` int(10) DEFAULT NULL,
  `emp_code` int(20) DEFAULT NULL,
  `fw_date` date DEFAULT NULL,
  `remark` varchar(255) DEFAULT NULL,
  `approval_date` date DEFAULT NULL,
  `encash_status` int(10) DEFAULT NULL,
  `solc_id` varchar(25) DEFAULT NULL,
  `cld_id` varchar(22) DEFAULT NULL,
  `ho_org_id` varchar(22) DEFAULT NULL,
  `org_id` varchar(22) DEFAULT NULL,
  `emp_doc_id` varchar(52) DEFAULT NULL,
  `doc_id` varchar(52) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `leave_encsh`
--

CREATE TABLE `leave_encsh` (
  `id` int(20) NOT NULL,
  `comp_code` varchar(20) DEFAULT NULL,
  `doc_id` varchar(255) NOT NULL,
  `emp_doc_id` varchar(255) NOT NULL,
  `emp_code` varchar(20) DEFAULT NULL,
  `dept_code` varchar(20) DEFAULT NULL,
  `desg_code` varchar(20) DEFAULT NULL,
  `emp_grp_id` varchar(20) DEFAULT NULL,
  `encsh_amt` varchar(20) DEFAULT NULL,
  `doc_dt` date DEFAULT NULL,
  `encsh_status` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Triggers `leave_encsh`
--
DELIMITER $$
CREATE TRIGGER `leave_encsh_after_insert` AFTER INSERT ON `leave_encsh` FOR EACH ROW if NEW.encsh_status = 5 then
IF @DISABLE_TRIGGERS IS NULL THEN
	INSERT INTO newdata VALUES (NEW.id,'leave_encsh','I');
    INSERT INTO newdata VALUES (NEW.id,'leave_encsh_dt','I');
END IF;
end if
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `leave_encsh_after_update` AFTER UPDATE ON `leave_encsh` FOR EACH ROW if NEW.encsh_status = 5 then
IF @DISABLE_TRIGGERS IS NULL THEN
	INSERT INTO newdata VALUES (NEW.id,'leave_encsh','U');
    INSERT INTO newdata VALUES (NEW.id,'leave_encsh_dt','U');
END IF;
end if
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `leave_encsh_dt`
--

CREATE TABLE `leave_encsh_dt` (
  `id` int(10) NOT NULL,
  `comp_code` varchar(20) DEFAULT NULL,
  `emp_code` varchar(20) DEFAULT NULL,
  `doc_id` varchar(236) NOT NULL,
  `emp_doc_id` varchar(255) NOT NULL,
  `leave_id` varchar(20) DEFAULT NULL,
  `leave_encash_limit` varchar(20) DEFAULT NULL,
  `leave_op` varchar(20) DEFAULT NULL,
  `leave_avail` varchar(20) DEFAULT NULL,
  `leave_bal` varchar(20) DEFAULT NULL,
  `encsh_amt` varchar(20) DEFAULT NULL,
  `created_at` date DEFAULT NULL,
  `leave_encsh_id` int(20) NOT NULL,
  `leaveencash_status` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `leave_grp`
--

CREATE TABLE `leave_grp` (
  `id` int(20) NOT NULL,
  `org_id` int(11) NOT NULL,
  `leave_code` varchar(255) DEFAULT NULL,
  `grp_id` varchar(20) NOT NULL,
  `leave_accrual_rate` float NOT NULL,
  `carry_fwd_ch` varchar(255) NOT NULL,
  `leave_proof_ch` varchar(255) NOT NULL,
  `leave_encash_limit` varchar(255) NOT NULL,
  `leave_encash_ch` varchar(20) DEFAULT NULL,
  `leave_max_limit` varchar(20) DEFAULT NULL,
  `mtrnty_leave_chk` varchar(255) NOT NULL,
  `mtrnty_leave_days` varchar(255) NOT NULL,
  `solc_id` varchar(25) DEFAULT NULL,
  `cld_id` varchar(22) DEFAULT NULL,
  `ho_org_id` varchar(22) DEFAULT NULL,
  `emp_doc_id` varchar(52) DEFAULT NULL,
  `doc_id` varchar(52) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `leave_workflow`
--

CREATE TABLE `leave_workflow` (
  `leave_wf_id` int(11) NOT NULL,
  `leave_id` varchar(20) DEFAULT NULL,
  `emp_code` varchar(40) DEFAULT NULL,
  `fw_date` date DEFAULT NULL,
  `remark` text,
  `approval_date` date DEFAULT NULL,
  `status` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `legal_case_details`
--

CREATE TABLE `legal_case_details` (
  `id` int(11) NOT NULL,
  `case_receive_id` int(11) NOT NULL,
  `case_type_id` int(11) NOT NULL,
  `court_type_id` int(11) NOT NULL,
  `court_location_id` int(11) NOT NULL,
  `case_status_id` int(11) NOT NULL,
  `case_outcome_id` int(11) DEFAULT NULL,
  `subject` text NOT NULL,
  `case_particulars` text NOT NULL,
  `case_petitioners` text NOT NULL,
  `case_respondents` text NOT NULL,
  `case_witness` text NOT NULL,
  `bringup_date` date NOT NULL,
  `mention_date` date NOT NULL,
  `next_hearing_date` date DEFAULT NULL,
  `decision_date` date DEFAULT NULL,
  `case_status_details` text NOT NULL,
  `case_outcome_details` text NOT NULL,
  `remark` text NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1' COMMENT '1="Active", 0="Inactive"',
  `notification` int(11) NOT NULL DEFAULT '0' COMMENT '0="Not Send", 1="Send"',
  `created_by` int(11) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `modify_date` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `legal_case_files`
--

CREATE TABLE `legal_case_files` (
  `id` int(11) NOT NULL,
  `case_receive_id` int(11) NOT NULL,
  `case_detail_id` int(11) NOT NULL,
  `folder_name` varchar(100) NOT NULL,
  `file_name` varchar(200) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1' COMMENT '1="Active", 0="Inactive"',
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `legal_case_outcome`
--

CREATE TABLE `legal_case_outcome` (
  `id` int(11) NOT NULL,
  `case_outcome` varchar(100) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0' COMMENT '0="Active", 1="Inactive"',
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `solc_id` varchar(25) DEFAULT NULL,
  `cld_id` varchar(22) DEFAULT NULL,
  `ho_org_id` varchar(22) DEFAULT NULL,
  `org_id` varchar(22) DEFAULT NULL,
  `emp_doc_id` varchar(52) DEFAULT NULL,
  `doc_id` varchar(52) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `legal_case_receive`
--

CREATE TABLE `legal_case_receive` (
  `id` int(11) NOT NULL,
  `ministry_id` int(11) NOT NULL COMMENT 'from ministry tbl',
  `request_id` int(11) NOT NULL COMMENT 'from mst_request tbl',
  `action_officer_id` int(11) NOT NULL COMMENT 'from myprofile tbl',
  `respondents` text NOT NULL,
  `petitioners` text NOT NULL,
  `court_case_number` varchar(100) NOT NULL,
  `psc_file_number` varchar(100) NOT NULL,
  `subject` text NOT NULL,
  `date_of_service` date NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1' COMMENT '1="Accepted",2="Terminated",3="Awaiting Judge Response",4="Under hearing"',
  `created_by` int(11) NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `solc_id` varchar(25) DEFAULT NULL,
  `cld_id` varchar(22) DEFAULT NULL,
  `ho_org_id` varchar(22) DEFAULT NULL,
  `org_id` varchar(22) DEFAULT NULL,
  `emp_doc_id` varchar(52) DEFAULT NULL,
  `doc_id` varchar(52) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `legal_case_status_type`
--

CREATE TABLE `legal_case_status_type` (
  `id` int(11) NOT NULL,
  `case_status` varchar(100) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0' COMMENT '0="Active", 1="Inactive"',
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `solc_id` varchar(25) DEFAULT NULL,
  `cld_id` varchar(22) DEFAULT NULL,
  `ho_org_id` varchar(22) DEFAULT NULL,
  `org_id` varchar(22) DEFAULT NULL,
  `emp_doc_id` varchar(52) DEFAULT NULL,
  `doc_id` varchar(52) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `legal_case_type`
--

CREATE TABLE `legal_case_type` (
  `id` int(11) NOT NULL,
  `casetype` varchar(100) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0' COMMENT '0="Active", 1="Inactive"',
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `solc_id` varchar(25) DEFAULT NULL,
  `cld_id` varchar(22) DEFAULT NULL,
  `ho_org_id` varchar(22) DEFAULT NULL,
  `org_id` varchar(22) DEFAULT NULL,
  `emp_doc_id` varchar(52) DEFAULT NULL,
  `doc_id` varchar(52) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `legal_court_location`
--

CREATE TABLE `legal_court_location` (
  `id` int(11) NOT NULL,
  `court_location` varchar(100) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0' COMMENT '0="Active", 1="Inactive"',
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `solc_id` varchar(25) DEFAULT NULL,
  `cld_id` varchar(22) DEFAULT NULL,
  `ho_org_id` varchar(22) DEFAULT NULL,
  `org_id` varchar(22) DEFAULT NULL,
  `emp_doc_id` varchar(52) DEFAULT NULL,
  `doc_id` varchar(52) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `legal_court_location`
--

INSERT INTO `legal_court_location` (`id`, `court_location`, `status`, `created_on`, `solc_id`, `cld_id`, `ho_org_id`, `org_id`, `emp_doc_id`, `doc_id`) VALUES
(1, 'New location', 0, '2016-10-04 07:29:40', NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `legal_court_type`
--

CREATE TABLE `legal_court_type` (
  `id` int(11) NOT NULL,
  `courttype` varchar(100) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0' COMMENT '0="Active", 1="Inactive"',
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `solc_id` varchar(25) DEFAULT NULL,
  `cld_id` varchar(22) DEFAULT NULL,
  `ho_org_id` varchar(22) DEFAULT NULL,
  `org_id` varchar(22) DEFAULT NULL,
  `emp_doc_id` varchar(52) DEFAULT NULL,
  `doc_id` varchar(52) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `link_kra_kpi`
--

CREATE TABLE `link_kra_kpi` (
  `id` int(1) NOT NULL,
  `link_kra_kpi_type` int(1) NOT NULL,
  `link_kra_kpi_type_value` varchar(5) NOT NULL,
  `created_date` datetime NOT NULL,
  `updated_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `link_kra_kpi`
--

INSERT INTO `link_kra_kpi` (`id`, `link_kra_kpi_type`, `link_kra_kpi_type_value`, `created_date`, `updated_date`) VALUES
(1, 1, 'Yes', '2016-10-21 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `local_expence`
--

CREATE TABLE `local_expence` (
  `id` int(10) NOT NULL,
  `local_claim_date` date NOT NULL,
  `local_claim_mode` varchar(10) NOT NULL,
  `local_claim_amount` varchar(10) NOT NULL,
  `tr_voucher_id` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `logo_master`
--

CREATE TABLE `logo_master` (
  `id` int(10) NOT NULL,
  `logo_file` varchar(100) NOT NULL,
  `created` date NOT NULL,
  `changed` date DEFAULT NULL,
  `created_by` int(10) DEFAULT NULL,
  `org_id` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `logo_master`
--

INSERT INTO `logo_master` (`id`, `logo_file`, `created`, `changed`, `created_by`, `org_id`) VALUES
(3, 'ess-logo.png', '2017-10-23', NULL, NULL, '01');

-- --------------------------------------------------------

--
-- Table structure for table `lta_balance`
--

CREATE TABLE `lta_balance` (
  `id` int(20) NOT NULL,
  `emp_id` varchar(11) DEFAULT NULL,
  `lta_years` varchar(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `lta_bill_amount`
--

CREATE TABLE `lta_bill_amount` (
  `id` int(10) NOT NULL,
  `comp_code` varchar(10) DEFAULT NULL,
  `emp_code` varchar(20) DEFAULT NULL,
  `bill_amount` float(14,2) DEFAULT NULL,
  `created_at` date DEFAULT NULL,
  `modified_at` date DEFAULT NULL,
  `uploaded_file` varchar(255) DEFAULT NULL,
  `jour_start_date` date NOT NULL,
  `jour_end_date` date NOT NULL,
  `status` int(5) NOT NULL,
  `taxable_amt` int(50) NOT NULL,
  `lta_years` int(11) NOT NULL,
  `sal_id` varchar(255) NOT NULL,
  `emp_doc_id` varchar(255) NOT NULL,
  `remark` varchar(255) NOT NULL,
  `solc_id` varchar(25) DEFAULT NULL,
  `fy_id` int(10) DEFAULT NULL,
  `cld_id` varchar(22) DEFAULT NULL,
  `ho_org_id` varchar(22) DEFAULT NULL,
  `org_id` varchar(22) DEFAULT NULL,
  `doc_id` varchar(52) DEFAULT NULL,
  `loc_type` varchar(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Triggers `lta_bill_amount`
--
DELIMITER $$
CREATE TRIGGER `lta_bill_amount_after_update` AFTER UPDATE ON `lta_bill_amount` FOR EACH ROW if NEW.status = 5 then
IF @DISABLE_TRIGGERS IS NULL THEN
	INSERT INTO newdata VALUES (NEW.id,'lta_bill_amount','U');
END IF;
end if
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `lta_group`
--

CREATE TABLE `lta_group` (
  `id` int(10) NOT NULL,
  `org_id` varchar(2) DEFAULT NULL,
  `grp_id` varchar(20) DEFAULT NULL,
  `lta_type` varchar(1) DEFAULT NULL,
  `lta_perc` int(5) DEFAULT NULL,
  `lta_amt` int(10) DEFAULT NULL,
  `blk_frm_dt` date DEFAULT NULL,
  `blk_to_dt` date DEFAULT NULL,
  `min_srvc_prd` int(10) DEFAULT NULL,
  `min_leave_days` int(5) DEFAULT NULL,
  `usr_id_create` int(5) DEFAULT NULL,
  `usr_id_create_dt` date DEFAULT NULL,
  `usr_id_mod` int(5) DEFAULT NULL,
  `usr_id_mod_dt` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `lta_leave`
--

CREATE TABLE `lta_leave` (
  `id` int(10) NOT NULL,
  `org_id` varchar(2) DEFAULT NULL,
  `grp_id` varchar(20) DEFAULT NULL,
  `leave_id` varchar(20) DEFAULT NULL,
  `usr_id_create` int(5) DEFAULT NULL,
  `usr_id_create_dt` date DEFAULT NULL,
  `solc_id` varchar(25) DEFAULT NULL,
  `cld_id` varchar(22) DEFAULT NULL,
  `ho_org_id` varchar(22) DEFAULT NULL,
  `emp_doc_id` varchar(52) DEFAULT NULL,
  `doc_id` varchar(52) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `lta_sal`
--

CREATE TABLE `lta_sal` (
  `id` int(10) NOT NULL,
  `org_id` int(2) DEFAULT NULL,
  `grp_id` varchar(20) DEFAULT NULL,
  `sal_id` varchar(20) DEFAULT NULL,
  `usr_id_create` int(5) DEFAULT NULL,
  `usr_id_create_dt` date DEFAULT NULL,
  `solc_id` varchar(25) DEFAULT NULL,
  `cld_id` varchar(22) DEFAULT NULL,
  `ho_org_id` varchar(22) DEFAULT NULL,
  `emp_doc_id` varchar(52) DEFAULT NULL,
  `doc_id` varchar(52) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `lta_workflow`
--

CREATE TABLE `lta_workflow` (
  `id` int(10) NOT NULL,
  `emp_code` varchar(255) DEFAULT NULL,
  `fw_date` date DEFAULT NULL,
  `lta_status` int(5) DEFAULT NULL,
  `remark` varchar(255) DEFAULT NULL,
  `lta_bill_amount_id` varchar(20) DEFAULT NULL,
  `approval_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `mailer_master`
--

CREATE TABLE `mailer_master` (
  `id` int(11) NOT NULL,
  `org_id` varchar(10) NOT NULL,
  `ho_org_id` varchar(10) NOT NULL,
  `module_code` varchar(10) NOT NULL,
  `event_id` varchar(10) NOT NULL,
  `active_status` int(11) NOT NULL,
  `frequency` int(11) NOT NULL,
  `body_data` varchar(255) NOT NULL,
  `created_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mailer_master`
--

INSERT INTO `mailer_master` (`id`, `org_id`, `ho_org_id`, `module_code`, `event_id`, `active_status`, `frequency`, `body_data`, `created_date`) VALUES
(1, '01', '', '1', '1', 1, 2, 'sahaa', '2016-10-21');

-- --------------------------------------------------------

--
-- Table structure for table `makess_smsstatus`
--

CREATE TABLE `makess_smsstatus` (
  `id` int(11) NOT NULL,
  `content` varchar(200) NOT NULL,
  `status` varchar(2) NOT NULL,
  `num` varchar(40) NOT NULL,
  `send_time` varchar(1) DEFAULT NULL,
  `appr_num` varchar(1) DEFAULT NULL,
  `rej_num` varchar(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `makess_smsstatus`
--

INSERT INTO `makess_smsstatus` (`id`, `content`, `status`, `num`, `send_time`, `appr_num`, `rej_num`) VALUES
(3, 'This is to inform your Appraisal Process Start, kindly login to portal and initiate action. !!!', 'N', '+91 2147483647', NULL, NULL, NULL),
(4, 'This is to inform you that Savi has submitted, his/ her KRA self score, kindly login to portal and initiate action. !!!', 'N', '+91 2147483647', NULL, NULL, NULL),
(5, 'This is to inform you that Savi has submitted, his/ her KRA self score, kindly login to portal and initiate action. !!!', 'N', '+91 2147483647', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `medical_bill_amount`
--

CREATE TABLE `medical_bill_amount` (
  `id` int(10) NOT NULL,
  `comp_code` varchar(10) DEFAULT NULL,
  `emp_code` varchar(20) DEFAULT NULL,
  `medical_month` date DEFAULT NULL,
  `emp_name` varchar(255) DEFAULT NULL,
  `bill_amount` float(14,2) DEFAULT NULL,
  `created_at` date DEFAULT NULL,
  `modified_at` date DEFAULT NULL,
  `vc_sal_month` varchar(255) DEFAULT NULL,
  `uploaded_file` varchar(255) NOT NULL,
  `status` int(5) NOT NULL,
  `bill_date` date NOT NULL,
  `solc_id` varchar(25) DEFAULT NULL,
  `fy_id` int(10) DEFAULT NULL,
  `cld_id` varchar(22) DEFAULT NULL,
  `ho_org_id` varchar(22) DEFAULT NULL,
  `org_id` varchar(22) DEFAULT NULL,
  `emp_doc_id` varchar(52) DEFAULT NULL,
  `doc_id` varchar(52) DEFAULT NULL,
  `loc_type` varchar(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Triggers `medical_bill_amount`
--
DELIMITER $$
CREATE TRIGGER `medical_bill_amount_after_update` AFTER UPDATE ON `medical_bill_amount` FOR EACH ROW if NEW.status = 5 then
IF @DISABLE_TRIGGERS IS NULL THEN
	INSERT INTO newdata VALUES (NEW.id,'medical_bill_amount','U');
END IF;
end if
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `medical_workflow`
--

CREATE TABLE `medical_workflow` (
  `id` int(10) NOT NULL,
  `emp_code` varchar(255) DEFAULT NULL,
  `fw_date` date DEFAULT NULL,
  `medical_status` int(5) DEFAULT NULL,
  `remark` varchar(255) DEFAULT NULL,
  `medical_bill_amount_id` varchar(20) DEFAULT NULL,
  `approval_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `mgt_group_desg`
--

CREATE TABLE `mgt_group_desg` (
  `id` int(11) NOT NULL,
  `mgt_group` int(1) NOT NULL,
  `desg_code` varchar(40) NOT NULL,
  `created_by` int(11) NOT NULL,
  `ho_org_id` int(1) NOT NULL,
  `org_id` varchar(40) NOT NULL,
  `created_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `mid_reviews`
--

CREATE TABLE `mid_reviews` (
  `id` int(11) NOT NULL,
  `emp_code` varchar(40) NOT NULL,
  `appraiser_code` varchar(40) NOT NULL,
  `reviewer_code` int(100) NOT NULL,
  `moderator_code` int(100) NOT NULL,
  `comp_code` varchar(40) NOT NULL,
  `financial_year` varchar(50) NOT NULL,
  `status` int(1) NOT NULL,
  `emp_review_status` int(10) NOT NULL DEFAULT '0',
  `app_review_status` int(10) NOT NULL DEFAULT '0',
  `rev_review_status` int(10) NOT NULL DEFAULT '0',
  `mod_review_status` int(10) NOT NULL DEFAULT '0',
  `created_by` int(11) NOT NULL,
  `created_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ministry`
--

CREATE TABLE `ministry` (
  `id` int(11) NOT NULL,
  `ministry_code` varchar(50) NOT NULL,
  `ministry_name` varchar(100) DEFAULT NULL,
  `email_id` varchar(100) NOT NULL,
  `abbreviation` varchar(100) NOT NULL,
  `ministry_status` int(11) DEFAULT '1' COMMENT '1="Active", 0="Inactive"',
  `solc_id` varchar(25) DEFAULT NULL,
  `cld_id` varchar(22) DEFAULT NULL,
  `ho_org_id` varchar(22) DEFAULT NULL,
  `org_id` varchar(22) DEFAULT NULL,
  `doc_id` varchar(52) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `mom_assign`
--

CREATE TABLE `mom_assign` (
  `id` int(11) NOT NULL,
  `mid` int(11) NOT NULL,
  `task_id` int(11) DEFAULT NULL,
  `subject` varchar(100) NOT NULL,
  `meeting_date` date NOT NULL,
  `meeting_time` varchar(15) NOT NULL,
  `description` varchar(100) NOT NULL,
  `mremark` varchar(300) NOT NULL,
  `responsibility` varchar(100) DEFAULT NULL,
  `remark` varchar(500) NOT NULL,
  `department_id` varchar(40) NOT NULL,
  `meeting_status` int(1) NOT NULL,
  `createby` varchar(50) NOT NULL,
  `uploaded_file` varchar(255) DEFAULT NULL,
  `post_on` date NOT NULL,
  `solc_id` varchar(25) DEFAULT NULL,
  `cld_id` varchar(22) DEFAULT NULL,
  `ho_org_id` varchar(22) DEFAULT NULL,
  `org_id` varchar(22) DEFAULT NULL,
  `doc_id` varchar(52) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `mom_assign_emp`
--

CREATE TABLE `mom_assign_emp` (
  `id` int(11) NOT NULL,
  `mid` int(11) NOT NULL,
  `emp_code` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `mom_emp_response`
--

CREATE TABLE `mom_emp_response` (
  `id` int(11) NOT NULL,
  `mid` int(11) NOT NULL,
  `emp_code` varchar(50) NOT NULL,
  `response` text NOT NULL,
  `response_datetime` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `mom_topic`
--

CREATE TABLE `mom_topic` (
  `tid` int(11) NOT NULL,
  `tname` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `mom_topic_function`
--

CREATE TABLE `mom_topic_function` (
  `fid` int(11) NOT NULL,
  `tid` int(11) NOT NULL,
  `fname` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `mst_acl`
--

CREATE TABLE `mst_acl` (
  `id` int(255) NOT NULL,
  `admin_options_id` int(255) NOT NULL,
  `acl_rights_id` int(255) NOT NULL,
  `emp_code` varchar(255) NOT NULL,
  `status` int(30) NOT NULL,
  `org_id` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `mst_code`
--

CREATE TABLE `mst_code` (
  `id` int(11) NOT NULL,
  `vc_comp_code` varchar(20) DEFAULT NULL,
  `vc_code` varchar(20) DEFAULT NULL,
  `vc_code_desc` varchar(20) DEFAULT NULL,
  `ch_stat_flag` varchar(20) DEFAULT NULL,
  `ch_stat_up_flag` varchar(20) DEFAULT NULL,
  `dt_mod_date` date DEFAULT NULL,
  `vc_default_comp` varchar(20) DEFAULT NULL,
  `vc_auth_code` varchar(20) DEFAULT NULL,
  `vc_field1` varchar(20) DEFAULT NULL,
  `vc_field2` varchar(20) DEFAULT NULL,
  `vc_field3` varchar(20) DEFAULT NULL,
  `vc_field4` varchar(20) DEFAULT NULL,
  `nu_field1` varchar(20) DEFAULT NULL,
  `nu_field2` varchar(20) DEFAULT NULL,
  `dt_field1` date DEFAULT NULL,
  `ft_field2` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mst_code`
--

INSERT INTO `mst_code` (`id`, `vc_comp_code`, `vc_code`, `vc_code_desc`, `ch_stat_flag`, `ch_stat_up_flag`, `dt_mod_date`, `vc_default_comp`, `vc_auth_code`, `vc_field1`, `vc_field2`, `vc_field3`, `vc_field4`, `nu_field1`, `nu_field2`, `dt_field1`, `ft_field2`) VALUES
(1, '01', 'J040', 'Belgium', NULL, NULL, NULL, '01', '1R', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(2, '01', 'M144', 'Hakusan', NULL, NULL, NULL, '01', '1R', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `mst_company`
--

CREATE TABLE `mst_company` (
  `id` int(11) NOT NULL,
  `comp_code` varchar(40) NOT NULL,
  `comp_name` varchar(100) DEFAULT NULL,
  `status` int(10) DEFAULT NULL,
  `solc_id` varchar(25) DEFAULT NULL,
  `cld_id` varchar(22) DEFAULT NULL,
  `ho_org_id` varchar(22) DEFAULT NULL,
  `org_id` varchar(22) DEFAULT NULL,
  `emp_doc_id` varchar(52) DEFAULT NULL,
  `doc_id` varchar(52) DEFAULT NULL,
  `mst_org_id` int(20) NOT NULL,
  `org_alias` varchar(255) DEFAULT NULL,
  `created_at` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `mst_course_masters`
--

CREATE TABLE `mst_course_masters` (
  `id` int(10) NOT NULL,
  `course_name` varchar(20) DEFAULT NULL,
  `comp_code` varchar(20) DEFAULT NULL,
  `date_created` date DEFAULT NULL,
  `date_modified` date DEFAULT NULL,
  `course_status` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mst_course_masters`
--

INSERT INTO `mst_course_masters` (`id`, `course_name`, `comp_code`, `date_created`, `date_modified`, `course_status`) VALUES
(1, 'Advance Tuning', '01', '2015-12-03', '2015-12-03', 'Y'),
(2, 'Communictaion Skills', '01', '2015-12-03', '2015-12-03', 'Y');

-- --------------------------------------------------------

--
-- Table structure for table `mst_desg`
--

CREATE TABLE `mst_desg` (
  `id` int(11) NOT NULL,
  `dept_code` varchar(40) DEFAULT NULL,
  `desg_code` varchar(40) DEFAULT NULL,
  `desc` varchar(100) DEFAULT NULL,
  `status` enum('0','1') DEFAULT NULL,
  `created_date` date DEFAULT NULL,
  `comp_code` varchar(40) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `mst_emp_exp_voucher`
--

CREATE TABLE `mst_emp_exp_voucher` (
  `voucher_id` int(10) NOT NULL,
  `emp_code` varchar(40) DEFAULT NULL,
  `expense_type` char(1) DEFAULT NULL,
  `voucher_date` date DEFAULT NULL,
  `comp_code` varchar(40) DEFAULT NULL,
  `dept_code` varchar(40) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `mst_emp_leaves`
--

CREATE TABLE `mst_emp_leaves` (
  `leave_id` int(10) NOT NULL,
  `comp_code` varchar(40) DEFAULT NULL,
  `emp_code` varchar(40) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `total_leave` varchar(20) DEFAULT NULL,
  `applied_date` datetime DEFAULT NULL,
  `leave_image` varchar(255) DEFAULT NULL,
  `solc_id` varchar(25) DEFAULT NULL,
  `cld_id` varchar(22) DEFAULT NULL,
  `ho_org_id` varchar(22) DEFAULT NULL,
  `org_id` varchar(22) DEFAULT NULL,
  `emp_doc_id` varchar(52) DEFAULT NULL,
  `doc_id` varchar(52) DEFAULT NULL,
  `by_hr` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `mst_emp_leave_allot`
--

CREATE TABLE `mst_emp_leave_allot` (
  `id` int(10) NOT NULL,
  `leave_op` float DEFAULT NULL,
  `leave_code` varchar(40) NOT NULL,
  `emp_code` varchar(40) NOT NULL,
  `allot_leave` decimal(10,0) NOT NULL,
  `created_date` date NOT NULL,
  `org_id` varchar(10) NOT NULL,
  `leave_year` varchar(10) NOT NULL,
  `leave_bal` float NOT NULL,
  `leave_accrual_rate` float NOT NULL,
  `modified` date NOT NULL,
  `solc_id` varchar(25) DEFAULT NULL,
  `cld_id` varchar(22) DEFAULT NULL,
  `ho_org_id` varchar(22) DEFAULT NULL,
  `emp_doc_id` varchar(52) DEFAULT NULL,
  `doc_id` varchar(52) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Triggers `mst_emp_leave_allot`
--
DELIMITER $$
CREATE TRIGGER `mst_emp_leave_allot_after_update` AFTER UPDATE ON `mst_emp_leave_allot` FOR EACH ROW IF @DISABLE_TRIGGERS IS NULL THEN
	INSERT INTO newdata VALUES (NEW.id,'mst_emp_leave_allot','U');
END IF
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `mst_emp_status`
--

CREATE TABLE `mst_emp_status` (
  `id` int(11) NOT NULL,
  `st_name` varchar(40) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mst_emp_status`
--

INSERT INTO `mst_emp_status` (`id`, `st_name`) VALUES
(1, 'Active'),
(2, 'Inactive'),
(3, 'Resigned'),
(4, 'Transfered');

-- --------------------------------------------------------

--
-- Table structure for table `mst_event_types`
--

CREATE TABLE `mst_event_types` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mst_event_types`
--

INSERT INTO `mst_event_types` (`id`, `name`) VALUES
(1, 'Upcoming Events'),
(2, 'Company Announcements');

-- --------------------------------------------------------

--
-- Table structure for table `mst_help_desk`
--

CREATE TABLE `mst_help_desk` (
  `id` int(10) NOT NULL,
  `ticket_id` int(10) DEFAULT NULL,
  `ticket_type` varchar(20) DEFAULT NULL,
  `complainer_id` varchar(20) DEFAULT NULL,
  `priority` varchar(20) DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL,
  `remark` varchar(255) DEFAULT NULL,
  `proof_file` varchar(255) DEFAULT NULL,
  `complainer_email` varchar(255) DEFAULT NULL,
  `complaint_date` date NOT NULL,
  `complainer_name` varchar(25) NOT NULL,
  `assigned` int(11) NOT NULL DEFAULT '0',
  `assign_to` varchar(10) DEFAULT NULL,
  `comment_done` int(2) NOT NULL DEFAULT '0',
  `current_status` int(2) NOT NULL DEFAULT '0',
  `st_change_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mst_help_desk`
--

INSERT INTO `mst_help_desk` (`id`, `ticket_id`, `ticket_type`, `complainer_id`, `priority`, `status`, `remark`, `proof_file`, `complainer_email`, `complaint_date`, `complainer_name`, `assigned`, `assign_to`, `comment_done`, `current_status`, `st_change_date`) VALUES
(1, 1, '1', '12786', '1', NULL, 'hello this is not working', 'FEB 2017 SCHEDULE.xlsx', 'ayush.pant@essindia.com', '2017-03-06', 'Shivam.RATHOR', 1, '13098', 0, 3, '2017-03-06'),
(2, 2, '2', '12786', '1', NULL, 'hiii heheheh', 'Chrysanthemum.jpg', 'ayush.pant@essindia.com', '2017-03-06', 'Shivam.RATHOR', 1, '13098', 1, 2, '2017-03-06'),
(3, 3, '3', '12740', '1', NULL, 'sssssss', '', 'ayush.pant@essindia.com', '2017-03-06', 'KULDEEP.SINGH', 1, '12740', 1, 3, '2017-07-06'),
(4, 4, '3', '12786', '1', NULL, 'hello', '24 jan AGL.xlsx', 'ayush.pant@essindia.com', '2017-03-08', 'Shivam.RATHOR', 1, '13098', 1, 3, '2017-03-08'),
(5, 5, '2', '12786', '1', NULL, 'ESS noida sector 63', '24 jan AGL.xlsx', 'ayush.pant@essindia.com', '2017-03-08', 'Shivam.RATHOR', 0, '', 0, 0, NULL),
(6, 6, '3', '12786', '1', NULL, '', 'FEB 2017 SCHEDULE.xlsx', 'ayush.pant@essindia.com', '2017-03-08', 'Shivam.RATHOR', 0, '', 0, 0, NULL),
(7, 7, '4', '12786', '1', NULL, '', '', 'ayush.pant@essindia.com', '2017-03-08', 'Shivam.RATHOR', 0, '', 0, 0, NULL),
(8, 8, '3', '12786', '2', NULL, '', 'mail pass.txt', 'ayush.pant@essindia.com', '2017-03-08', 'Shivam.RATHOR', 0, '', 0, 0, NULL),
(9, 9, '4', '12786', '1', NULL, '', 'Extension List.xls', 'ayush.pant@essindia.com', '2017-03-08', 'Shivam.RATHOR', 1, '12740', 1, 3, '2017-03-08'),
(10, 10, '1', '12740', '2', NULL, 'hello', '24 jan AGL.xlsx', 'ayush.pant@essindia.com', '2017-03-09', 'KULDEEP.SINGH', 0, '', 0, 0, NULL),
(11, 11, '4', '12740', '1', NULL, 'jjjjjjjjjjjjjjjjjjjjjjjjjj', 'HR_PORTLA_List.xls', 'ayush.pant@essindia.com', '2017-03-09', 'KULDEEP.SINGH', 1, '12740', 1, 3, '2017-07-06'),
(12, 12, '1', '12740', '1', NULL, 'megha yadav', 'Chrysanthemum.jpg', 'ayush.pant@essindia.com', '2017-03-09', 'KULDEEP.SINGH', 1, '13098', 0, 3, '2017-03-09'),
(13, 13, '2', '12785', '1', NULL, 'hhhhhhhhhhhhhhhh', 'Tulips.jpg', 'ayush.pant@essindia.com', '2017-03-09', 'Shantakaram.murthi', 0, '', 0, 0, NULL),
(14, 14, '3', '12786', '1', NULL, 'kuch ni chala', 'Lighthouse.jpg', 'ayush.pant@essindia.com', '2017-03-09', '????', 1, '13098', 0, 3, '2017-03-09'),
(15, 15, '1', '12740', '0', NULL, 'test', '', 'ayush.pant@essindia.com', '2017-07-04', 'KULDEEP.SINGH', 1, '12740', 1, 3, '2017-07-06'),
(16, 16, '1', '12740', '0', NULL, 'TESTS ', 'knj8QqPF.png', 'ayush.pant@essindia.com', '2017-07-05', 'KULDEEP.SINGH', 0, '', 0, 0, NULL),
(17, 17, '1', '12740', '0', NULL, 'TEST', '', 'ayush.pant@essindia.com', '2017-07-05', 'KULDEEP.SINGH', 0, '', 0, 0, NULL),
(18, 18, '1', '12740', '1', NULL, 'DTETST', '', 'ayush.pant@essindia.com', '2017-07-05', 'KULDEEP.SINGH', 0, '', 0, 0, NULL),
(19, 18, '1', '12740', '1', NULL, 'DTETST', '', 'ayush.pant@essindia.com', '2017-07-05', 'KULDEEP.SINGH', 0, '', 0, 0, NULL),
(20, 20, '1', '12740', '0', NULL, 'jGKDJGDJDH', '', 'ayush.pant@essindia.com', '2017-07-05', 'KULDEEP.SINGH', 0, '', 0, 0, NULL),
(21, 21, '1', '12740', '0', NULL, 'DLKJDLJJDLJDJL', '', 'ayush.pant@essindia.com', '2017-07-05', 'KULDEEP.SINGH', 1, '12740', 0, 3, '2017-07-06'),
(22, 22, '1', '12740', '1', NULL, 'djhdkhdkhhdkjhdjk', '', 'ayush.pant@essindia.com', '2017-07-05', 'KULDEEP.SINGH', 1, '13150', 0, 0, NULL),
(23, 23, '1', '12740', '1', NULL, 'dlkjdjldljlkd', '', 'ayush.pant@essindia.com', '2017-07-05', 'KULDEEP.SINGH', 1, '13346', 0, 0, NULL),
(24, 23, '1', '12740', '1', NULL, 'dlkjdjldljlkd', '', 'ayush.pant@essindia.com', '2017-07-05', 'KULDEEP.SINGH', 1, '13270', 0, 0, NULL),
(25, 25, '1', '12740', '0', NULL, 'yetete', '', 'ayush.pant@essindia.com', '2017-07-05', 'KULDEEP.SINGH', 1, '13150', 0, 0, NULL),
(26, 26, '1', '12740', '1', NULL, 'dkjhdkjkjdhkjdhkjd', '', 'ayush.pant@essindia.com', '2017-07-06', 'KULDEEP.SINGH', 1, '12740', 1, 3, '2017-07-06'),
(27, 27, '1', '12740', '0', NULL, 'dkhkhdkjdhjljkdd', '', 'ayush.pant@essindia.com', '2017-07-06', 'KULDEEP.SINGH', 1, '13328', 0, 0, NULL),
(28, 28, '1', '12740', '1', NULL, 'TEST IT', '', 'ayush.pant@essindia.com', '2017-07-06', 'KULDEEP.SINGH', 1, '13147', 0, 0, NULL),
(29, 29, '1', '12740', '1', NULL, 'edluhydekhhdkjhdkjhdj', '', 'ayush.pant@essindia.com', '2017-07-06', 'KULDEEP.SINGH', 1, '12740', 0, 3, '2017-07-06'),
(30, 30, '1', '12740', '0', NULL, 'slkuslhlsjjls', '', 'ayush.pant@essindia.com', '2017-07-06', 'KULDEEP.SINGH', 1, '12740', 1, 3, '2017-07-06'),
(31, 30, '1', '12740', '0', NULL, 'slkuslhlsjjls', '', 'ayush.pant@essindia.com', '2017-07-06', 'KULDEEP.SINGH', 1, '12740', 0, 3, '2017-07-06'),
(32, 32, '1', '12740', '1', NULL, 'khgsjgsjhgshs', 'ess-logo-2.png', 'ayush.pant@essindia.com', '2017-07-07', 'KULDEEP.SINGH', 0, '', 0, 0, NULL),
(33, 33, '1', '1538', '1', NULL, 'okie', 'youwillbemissed.jpg', '', '2017-10-07', 'Shiv.Khandelwal', 0, NULL, 0, 0, NULL),
(34, 34, '1', '1538', '1', NULL, 'okie', 'youwillbemissed.jpg', '', '2017-10-07', 'Shiv.Khandelwal', 0, NULL, 0, 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `mst_leave_type`
--

CREATE TABLE `mst_leave_type` (
  `id` int(11) NOT NULL,
  `leave_code` varchar(40) NOT NULL,
  `org_id` varchar(10) NOT NULL,
  `leave_name` varchar(100) NOT NULL,
  `status` enum('0','1') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `mst_org`
--

CREATE TABLE `mst_org` (
  `id` int(20) NOT NULL,
  `org_name` varchar(255) DEFAULT NULL,
  `created_at` date DEFAULT NULL,
  `modify_at` date DEFAULT NULL,
  `org_id` varchar(20) DEFAULT NULL,
  `org_alias` varchar(255) DEFAULT NULL,
  `org_cld_id` int(10) DEFAULT NULL,
  `org_type` int(4) DEFAULT NULL,
  `status` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `mst_promotion_type`
--

CREATE TABLE `mst_promotion_type` (
  `id` int(11) NOT NULL,
  `promotion_name` varchar(100) NOT NULL,
  `promotion_code` varchar(50) NOT NULL,
  `promotion_status` tinyint(1) NOT NULL,
  `created_date` date NOT NULL,
  `created_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mst_promotion_type`
--

INSERT INTO `mst_promotion_type` (`id`, `promotion_name`, `promotion_code`, `promotion_status`, `created_date`, `created_by`) VALUES
(3, 'sxasx', 'xaxasxasx', 1, '2016-09-05', 209),
(4, 'asasa', 'sasas', 1, '2016-09-05', 209),
(5, 'AKJSDHAKSJH', 'KSDJFSKDJS', 1, '2016-09-05', 209),
(6, 'SDASDASDASD', '23234IUIUY', 1, '2016-09-05', 209),
(7, 'SDASD', 'IUYIUYIU', 1, '2016-09-05', 209),
(8, 'I', '87972938729323', 1, '2016-09-05', 209);

-- --------------------------------------------------------

--
-- Table structure for table `mst_request`
--

CREATE TABLE `mst_request` (
  `id` int(20) NOT NULL,
  `req_type_name` varchar(255) NOT NULL,
  `req_type_code` varchar(25) NOT NULL,
  `abbreviation` varchar(100) NOT NULL,
  `created_by` varchar(25) NOT NULL,
  `created_date` date NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mst_request`
--

INSERT INTO `mst_request` (`id`, `req_type_name`, `req_type_code`, `abbreviation`, `created_by`, `created_date`, `status`) VALUES
(1, 'Request1', '102', 'LET', '209', '2016-09-15', 1),
(2, 'Request2', '103', 'het', '209', '2016-09-15', 1),
(3, 'Request3', '104', 'THT', '209', '2016-09-15', 1);

-- --------------------------------------------------------

--
-- Table structure for table `mst_scheme_of_service`
--

CREATE TABLE `mst_scheme_of_service` (
  `id` int(11) NOT NULL,
  `scheme_code` varchar(50) NOT NULL,
  `scheme_name` varchar(100) DEFAULT NULL,
  `scheme_status` tinyint(1) DEFAULT NULL,
  `created_date` date NOT NULL,
  `created_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `mst_session_masters`
--

CREATE TABLE `mst_session_masters` (
  `id` int(10) DEFAULT NULL,
  `vc_comp_code` varchar(20) DEFAULT NULL,
  `vc_course_id` varchar(20) DEFAULT NULL,
  `vc_session` varchar(20) DEFAULT NULL,
  `vc_date_created` date DEFAULT NULL,
  `vc_date_modifited` date DEFAULT NULL,
  `vc_session_status` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mst_session_masters`
--

INSERT INTO `mst_session_masters` (`id`, `vc_comp_code`, `vc_course_id`, `vc_session`, `vc_date_created`, `vc_date_modifited`, `vc_session_status`) VALUES
(1, '01', '1', 'java configuration', '2015-12-14', '2015-12-14', 'A'),
(2, '01', '2', 'Verbal', '2015-12-14', '2015-12-14', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `mst_signatory`
--

CREATE TABLE `mst_signatory` (
  `id` int(10) NOT NULL,
  `department_id` varchar(25) NOT NULL,
  `signatory_id` varchar(25) NOT NULL,
  `created_by` varchar(25) NOT NULL,
  `created_date` date NOT NULL,
  `status` varchar(25) NOT NULL,
  `signature` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mst_signatory`
--

INSERT INTO `mst_signatory` (`id`, `department_id`, `signatory_id`, `created_by`, `created_date`, `status`, `signature`) VALUES
(1, 'DEPT00002', '237', '209', '2016-09-16', '1', ''),
(2, 'DEPT00002', '239', '209', '2016-09-16', '1', ''),
(4, 'DEPT00002', '244', '209', '2016-09-16', '1', ''),
(6, 'DEPT00002', '109', '209', '2016-09-16', '1', ''),
(8, 'DEPT00004', '6111', '209', '2016-09-16', '1', ''),
(9, 'DEPT00004', '6394', '209', '2016-09-16', '1', '');

-- --------------------------------------------------------

--
-- Table structure for table `mst_terms_of_service`
--

CREATE TABLE `mst_terms_of_service` (
  `id` int(11) NOT NULL,
  `tos_name` varchar(100) DEFAULT NULL,
  `tos_status` tinyint(1) DEFAULT NULL,
  `created_date` date NOT NULL,
  `created_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mst_terms_of_service`
--

INSERT INTO `mst_terms_of_service` (`id`, `tos_name`, `tos_status`, `created_date`, `created_by`) VALUES
(1, 'Terms of Service Type', 1, '2016-09-06', 209),
(2, 'Terms of Service Type2', 1, '2016-09-06', 209);

-- --------------------------------------------------------

--
-- Table structure for table `mst_trainer_masters`
--

CREATE TABLE `mst_trainer_masters` (
  `id` int(20) NOT NULL,
  `comp_code` int(10) DEFAULT NULL,
  `course_id` varchar(10) DEFAULT NULL,
  `trainer_id` varchar(10) DEFAULT NULL,
  `date_created` date DEFAULT NULL,
  `date_modified` date DEFAULT NULL,
  `trainer_status` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mst_trainer_masters`
--

INSERT INTO `mst_trainer_masters` (`id`, `comp_code`, `course_id`, `trainer_id`, `date_created`, `date_modified`, `trainer_status`) VALUES
(1, 1, '1', '179', '2016-01-13', '2016-01-13', '1'),
(2, 1, '2', '179', '2015-12-03', '2016-01-13', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `mst_training_attendes`
--

CREATE TABLE `mst_training_attendes` (
  `id` int(20) DEFAULT NULL,
  `attende_id` int(10) DEFAULT NULL,
  `training_id` int(10) DEFAULT NULL,
  `entry_date` date DEFAULT NULL,
  `attende_status` varchar(20) DEFAULT NULL,
  `reason` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `mst_training_budget`
--

CREATE TABLE `mst_training_budget` (
  `id` int(20) DEFAULT NULL,
  `bud_id` int(10) DEFAULT NULL,
  `comp_code` int(10) DEFAULT NULL,
  `training_region` varchar(20) DEFAULT NULL,
  `total_trainees` int(20) DEFAULT NULL,
  `time_trainers` int(50) DEFAULT NULL,
  `time_trainees` int(20) DEFAULT NULL,
  `region_head` varchar(20) DEFAULT NULL,
  `date_created` date DEFAULT NULL,
  `date_modified` date DEFAULT NULL,
  `year` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `mst_training_calenders`
--

CREATE TABLE `mst_training_calenders` (
  `id` int(10) NOT NULL,
  `identified_from` varchar(20) DEFAULT NULL,
  `training_from` date DEFAULT NULL,
  `training_to` date DEFAULT NULL,
  `topic_type` varchar(20) DEFAULT NULL,
  `topic_id` varchar(20) DEFAULT NULL,
  `training_name` varchar(20) DEFAULT NULL,
  `start_hh` int(10) DEFAULT NULL,
  `start_mm` int(10) DEFAULT NULL,
  `start_am_pm` varchar(20) DEFAULT NULL,
  `end_hh` int(5) DEFAULT NULL,
  `end_mm` int(5) DEFAULT NULL,
  `end_am_pm` int(5) DEFAULT NULL,
  `duration_hh` int(5) DEFAULT NULL,
  `duration_mm` int(5) DEFAULT NULL,
  `training_mode` varchar(20) DEFAULT NULL,
  `training_type` varchar(20) DEFAULT NULL,
  `min_trainees` int(10) DEFAULT NULL,
  `max_trainees` int(10) DEFAULT NULL,
  `pte_required` varchar(20) DEFAULT NULL,
  `pte_after` int(10) DEFAULT NULL,
  `pte_days_months` int(10) DEFAULT NULL,
  `most_popular` varchar(10) DEFAULT NULL,
  `more_session` varchar(10) DEFAULT NULL,
  `date_created` varchar(10) DEFAULT NULL,
  `date_modified` varchar(10) DEFAULT NULL,
  `scheduled_by` varchar(10) DEFAULT NULL,
  `training_status` varchar(10) DEFAULT NULL,
  `training_scheduled_date` varchar(10) DEFAULT NULL,
  `remark` varchar(10) DEFAULT NULL,
  `approved_by` varchar(10) DEFAULT NULL,
  `training_region` varchar(10) DEFAULT NULL,
  `feedback_rate` varchar(10) DEFAULT NULL,
  `ques_file` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mst_training_calenders`
--

INSERT INTO `mst_training_calenders` (`id`, `identified_from`, `training_from`, `training_to`, `topic_type`, `topic_id`, `training_name`, `start_hh`, `start_mm`, `start_am_pm`, `end_hh`, `end_mm`, `end_am_pm`, `duration_hh`, `duration_mm`, `training_mode`, `training_type`, `min_trainees`, `max_trainees`, `pte_required`, `pte_after`, `pte_days_months`, `most_popular`, `more_session`, `date_created`, `date_modified`, `scheduled_by`, `training_status`, `training_scheduled_date`, `remark`, `approved_by`, `training_region`, `feedback_rate`, `ques_file`) VALUES
(1, 'O', '2016-01-30', '2016-01-30', 'E', NULL, 'Advance Tuning', 10, 30, 'AM', 11, 30, 0, 1, 55, 'WEBEX', 'INTERNAL', 5, 10, NULL, NULL, NULL, 'N', NULL, '30-Jan-201', '30-Jan-201', '209', 'SCHEDULED', '30-Jan-201', NULL, NULL, NULL, NULL, NULL),
(2, NULL, '2016-07-01', '2016-07-01', 'E', NULL, 'Advance Tuning', NULL, NULL, 'AM', NULL, NULL, 0, 2, 0, '', '', NULL, NULL, NULL, NULL, NULL, 'N', NULL, '01-Jul-201', '01-Jul-201', '1244', 'SCHEDULED', '01-Jul-201', NULL, NULL, NULL, NULL, NULL),
(3, NULL, '2016-07-01', '2016-07-01', 'E', NULL, NULL, NULL, NULL, 'AM', NULL, NULL, 0, NULL, NULL, '', '', NULL, NULL, NULL, NULL, NULL, 'N', NULL, '01-Jul-201', '01-Jul-201', '1244', 'SCHEDULED', '01-Jul-201', NULL, NULL, NULL, NULL, NULL),
(4, NULL, '2016-07-01', '2016-07-01', 'E', NULL, NULL, NULL, NULL, 'AM', NULL, NULL, 0, NULL, NULL, '', '', NULL, NULL, NULL, NULL, NULL, 'N', NULL, '01-Jul-201', '01-Jul-201', '1244', 'SCHEDULED', '01-Jul-201', NULL, NULL, NULL, NULL, NULL),
(5, NULL, '2016-07-01', '2016-07-01', 'E', NULL, NULL, NULL, NULL, 'AM', NULL, NULL, 0, NULL, NULL, '', '', NULL, NULL, NULL, NULL, NULL, 'N', NULL, '01-Jul-201', '01-Jul-201', '1244', 'SCHEDULED', '01-Jul-201', NULL, NULL, NULL, NULL, NULL),
(6, 'I', '2016-07-01', '2016-07-01', 'E', NULL, 'Advance Tuning', 1, 0, 'PM', 1, 20, 0, 2, 30, 'ONLINE', 'INTERNAL', 12, 15, NULL, NULL, NULL, 'Y', NULL, '01-Jul-201', '01-Jul-201', '1244', 'SCHEDULED', '01-Jul-201', NULL, NULL, NULL, NULL, NULL),
(7, NULL, '2016-07-01', '2016-07-01', 'E', NULL, 'Communictaion Skills', 2, 30, 'AM', 2, 30, 0, 3, 30, 'WEBEX', 'EXTERNAL', 30, 50, NULL, NULL, NULL, 'Y', NULL, '01-Jul-201', '01-Jul-201', '1244', 'PENDING', '01-Jul-201', NULL, NULL, NULL, NULL, NULL),
(8, NULL, '2016-07-01', '2016-07-01', 'E', NULL, 'Advance Tuning', 1, 30, 'PM', 1, 30, 0, 1, 30, 'ONLINE', 'EXTERNAL', 10, 15, NULL, NULL, NULL, 'Y', NULL, '01-Jul-201', '01-Jul-201', '209', 'PENDING', '01-Jul-201', NULL, NULL, NULL, NULL, NULL),
(9, NULL, '2016-06-30', '2016-06-30', 'E', NULL, 'Advance Tuning', NULL, NULL, 'AM', NULL, NULL, 0, 1, 12, '', '', NULL, NULL, NULL, NULL, NULL, 'N', NULL, '01-Jul-201', '01-Jul-201', '209', 'SCHEDULED', '01-Jul-201', NULL, NULL, NULL, NULL, NULL),
(10, NULL, '2016-06-30', '2016-06-30', 'E', NULL, 'Advance Tuning', 1, 1, 'PM', 1, 1, 0, 1, 12, 'WEBEX', 'INTERNAL', 1, 1, NULL, NULL, NULL, 'N', NULL, '01-Jul-201', '01-Jul-201', '209', 'SCHEDULED', '01-Jul-201', NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `mst_training_parmeters`
--

CREATE TABLE `mst_training_parmeters` (
  `id` int(20) DEFAULT NULL,
  `comp_code` int(20) DEFAULT NULL,
  `parameter_value` varchar(20) DEFAULT NULL,
  `parameter_code` varchar(20) DEFAULT NULL,
  `parameter_desc` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `mst_training_region_head`
--

CREATE TABLE `mst_training_region_head` (
  `id` int(20) DEFAULT NULL,
  `comp_code` int(10) DEFAULT NULL,
  `training_region` varchar(50) DEFAULT NULL,
  `region_head` varchar(20) DEFAULT NULL,
  `date_created` date DEFAULT NULL,
  `date_modified` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `mst_training_requests`
--

CREATE TABLE `mst_training_requests` (
  `id` int(11) NOT NULL,
  `request_id` varchar(20) DEFAULT NULL,
  `comp_code` varchar(20) DEFAULT NULL,
  `training_topic_type` varchar(20) DEFAULT NULL,
  `training_name` varchar(20) DEFAULT NULL,
  `training_date` varchar(20) DEFAULT NULL,
  `duration_hh` varchar(20) DEFAULT NULL,
  `duration_mm` varchar(20) DEFAULT NULL,
  `identified_from` varchar(20) DEFAULT NULL,
  `identified_by` varchar(20) DEFAULT NULL,
  `self_include` varchar(20) DEFAULT NULL,
  `approved_by` varchar(20) DEFAULT NULL,
  `training_status` varchar(20) DEFAULT NULL,
  `training_topic_id` varchar(20) DEFAULT NULL,
  `request_status` varchar(20) DEFAULT NULL,
  `request_reason` varchar(20) DEFAULT NULL,
  `training_id` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mst_training_requests`
--

INSERT INTO `mst_training_requests` (`id`, `request_id`, `comp_code`, `training_topic_type`, `training_name`, `training_date`, `duration_hh`, `duration_mm`, `identified_from`, `identified_by`, `self_include`, `approved_by`, `training_status`, `training_topic_id`, `request_status`, `request_reason`, `training_id`) VALUES
(1, '1', '01', 'E', 'Communictaion Skills', '01/27/2016', '1', '55', 'I', '492', 'Y', '78', 'PENDING', '2', 'RM', NULL, NULL),
(2, '2', '01', 'E', 'Advance Tuning', '01/30/2016', '1', '55', 'O', '492', 'Y', '78', 'SCHEDULED', '1', 'PR', NULL, '1'),
(3, '3', '01', 'E', 'Advance Tuning', '06/30/2016', '1', '30', 'O', '209', '', '', 'PENDING', '1', 'RM', NULL, NULL),
(4, '4', '01', 'E', 'Advance Tuning', '06/30/2016', '1', '12', 'O', '209', '', '1269', 'SCHEDULED', '1', 'PR', NULL, '10'),
(5, '4', '01', 'E', 'Advance Tuning', '06/30/2016', '1', '12', 'O', '209', 'Y', '1269', 'SCHEDULED', '1', 'PR', NULL, '10'),
(6, '4', '01', 'N', 'Advance Tuning', '06/30/2016', '1', '12', 'O', '209', 'Y', '1269', 'SCHEDULED', '1', 'PR', NULL, '10'),
(7, '8', '01', 'E', 'Advance Tuning', '06/30/2016', '1', '12', 'O', '209', '', '179', 'SCHEDULED', '1', 'PR', NULL, '9'),
(8, '8', '01', 'E', 'Advance Tuning', '06/30/2016', '1', '12', 'O', '1269', 'Y', '1269', 'SCHEDULED', '1', 'PR', NULL, '9'),
(9, '9', '01', 'E', 'Communictaion Skills', '07/01/2016', '2', '00', 'O', '1269', 'Y', '1244', 'SCHEDULED', '1', 'PR', NULL, '7'),
(10, '10', '01', 'E', 'Advance Tuning', '07/01/2016', '1', '30', 'O', '1269', 'Y', '209', 'SCHEDULED', '1', 'PR', NULL, '8'),
(11, '10', '01', 'E', 'Advance Tuning', '07/01/2016', '1', '30', 'O', '535', 'Y', '179', 'SCHEDULED', '1', 'PR', NULL, '8');

-- --------------------------------------------------------

--
-- Table structure for table `mst_training_schedule_details`
--

CREATE TABLE `mst_training_schedule_details` (
  `id` int(20) DEFAULT NULL,
  `comp_code` varchar(20) DEFAULT NULL,
  `emp_code` int(50) DEFAULT NULL,
  `dt_train_scheduled_date` date DEFAULT NULL,
  `scheduled_by` varchar(20) DEFAULT NULL,
  `entry_date` date DEFAULT NULL,
  `training_name` varchar(20) DEFAULT NULL,
  `duration` varchar(20) DEFAULT NULL,
  `schedule_status` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `mst_travel_mode_type`
--

CREATE TABLE `mst_travel_mode_type` (
  `id` int(10) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `status` enum('0','1') DEFAULT NULL,
  `created_date` date DEFAULT NULL,
  `modified_date` date DEFAULT NULL,
  `solc_id` varchar(25) DEFAULT NULL,
  `cld_id` varchar(22) DEFAULT NULL,
  `ho_org_id` varchar(22) DEFAULT NULL,
  `org_id` varchar(22) DEFAULT NULL,
  `emp_doc_id` varchar(52) DEFAULT NULL,
  `doc_id` varchar(52) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mst_travel_mode_type`
--

INSERT INTO `mst_travel_mode_type` (`id`, `name`, `status`, `created_date`, `modified_date`, `solc_id`, `cld_id`, `ho_org_id`, `org_id`, `emp_doc_id`, `doc_id`) VALUES
(1, 'Travel Mode', '1', '2015-08-06', '2015-08-07', NULL, NULL, NULL, '01', NULL, NULL),
(2, 'Travel DA', '1', '2015-08-06', '2015-08-07', NULL, NULL, NULL, '01', NULL, NULL),
(3, 'TATA', '1', '2016-09-29', NULL, NULL, NULL, '', '02', NULL, NULL),
(4, 'car', '1', '2017-03-28', NULL, NULL, NULL, '', '01', NULL, NULL),
(5, 'Helicopter', '1', '2017-10-25', NULL, NULL, NULL, '', '04', NULL, NULL),
(6, 'Plane', '1', '2017-10-25', NULL, NULL, NULL, '', '04', NULL, NULL),
(7, 'Rickshaw', '1', '2017-10-25', NULL, NULL, NULL, '', '02', NULL, NULL),
(8, 'Auto', '1', '2017-10-26', NULL, NULL, NULL, '', '01', NULL, NULL),
(9, 'fasfs', '1', '2017-10-27', NULL, NULL, NULL, NULL, '', NULL, NULL),
(11, 'AUTOS', '1', '2017-11-01', NULL, NULL, NULL, '', '03', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `mst_travel_voucher`
--

CREATE TABLE `mst_travel_voucher` (
  `id` int(11) NOT NULL,
  `type` varchar(111) DEFAULT NULL,
  `desc` varchar(111) DEFAULT NULL,
  `status` enum('0','1') DEFAULT NULL,
  `created_date` date DEFAULT NULL,
  `module_name` varchar(111) DEFAULT NULL,
  `solc_id` varchar(25) DEFAULT NULL,
  `cld_id` varchar(22) DEFAULT NULL,
  `ho_org_id` varchar(22) DEFAULT NULL,
  `org_id` varchar(22) DEFAULT NULL,
  `emp_doc_id` varchar(52) DEFAULT NULL,
  `doc_id` varchar(52) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mst_travel_voucher`
--

INSERT INTO `mst_travel_voucher` (`id`, `type`, `desc`, `status`, `created_date`, `module_name`, `solc_id`, `cld_id`, `ho_org_id`, `org_id`, `emp_doc_id`, `doc_id`) VALUES
(49, '3', 'Test', '1', '2017-11-06', 'Travel Voucher', NULL, NULL, '01', '01', NULL, NULL),
(50, '3', 'Test', '1', '2017-11-06', 'Travel Voucher', NULL, NULL, '03', '03', NULL, NULL),
(51, '5', 'ABCD', '1', '2017-11-06', 'Travel Voucher', NULL, NULL, '01', '01', NULL, NULL),
(52, '2', 'er', '1', '2017-11-08', 'Travel Voucher', NULL, NULL, '02', '02', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `mst_vehical_master`
--

CREATE TABLE `mst_vehical_master` (
  `id` int(11) NOT NULL,
  `vehical_name` varchar(111) DEFAULT NULL,
  `status` enum('0','1') DEFAULT NULL,
  `created_date` date DEFAULT NULL,
  `solc_id` varchar(25) DEFAULT NULL,
  `cld_id` varchar(22) DEFAULT NULL,
  `ho_org_id` varchar(22) DEFAULT NULL,
  `org_id` varchar(22) DEFAULT NULL,
  `emp_doc_id` varchar(52) DEFAULT NULL,
  `doc_id` varchar(52) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mst_vehical_master`
--

INSERT INTO `mst_vehical_master` (`id`, `vehical_name`, `status`, `created_date`, `solc_id`, `cld_id`, `ho_org_id`, `org_id`, `emp_doc_id`, `doc_id`) VALUES
(1, 'Two Wheeler', '1', '2017-08-14', NULL, NULL, NULL, '01', NULL, NULL),
(2, 'Two Wheeler', '1', '2017-08-14', NULL, NULL, NULL, '04', NULL, NULL),
(3, 'Two Wheeler', '1', '2017-08-14', NULL, NULL, NULL, '05', NULL, NULL),
(4, 'Two Wheeler', '1', '2017-08-14', NULL, NULL, NULL, '06', NULL, NULL),
(5, 'Two Wheeler', '1', '2017-08-14', NULL, NULL, NULL, '07', NULL, NULL),
(6, 'Two Wheeler', '1', '2017-08-14', NULL, NULL, NULL, '08', NULL, NULL),
(7, 'Two Wheeler', '1', '2017-08-14', NULL, NULL, NULL, '09', NULL, NULL),
(8, 'Two Wheeler', '1', '2017-08-14', NULL, NULL, NULL, '0L', NULL, NULL),
(9, 'Two Wheeler', '1', '2017-08-14', NULL, NULL, NULL, '02', NULL, NULL),
(10, 'Two Wheeler', '1', '2017-08-14', NULL, NULL, NULL, '0A', NULL, NULL),
(11, 'Two Wheeler', '1', '2017-08-14', NULL, NULL, NULL, '0B', NULL, NULL),
(12, 'Two Wheeler', '1', '2017-08-14', NULL, NULL, NULL, '0C', NULL, NULL),
(13, 'Two Wheeler', '1', '2017-08-14', NULL, NULL, NULL, '0D', NULL, NULL),
(14, 'Two Wheeler', '1', '2017-08-14', NULL, NULL, NULL, '0E', NULL, NULL),
(15, 'Two Wheeler', '1', '2017-08-14', NULL, NULL, NULL, '0F', NULL, NULL),
(16, 'Two Wheeler', '1', '2017-08-14', NULL, NULL, NULL, '0G', NULL, NULL),
(17, 'Two Wheeler', '1', '2017-08-14', NULL, NULL, NULL, '0H', NULL, NULL),
(18, 'Two Wheeler', '1', '2017-08-14', NULL, NULL, NULL, '0I', NULL, NULL),
(19, 'Two Wheeler', '1', '2017-08-14', NULL, NULL, NULL, '0J', NULL, NULL),
(20, 'Two Wheeler', '1', '2017-08-14', NULL, NULL, NULL, '0K', NULL, NULL),
(21, 'Two Wheeler', '1', '2017-08-14', NULL, NULL, NULL, '03', NULL, NULL),
(22, 'Three Wheeler', '1', '2017-08-14', NULL, NULL, NULL, '01', NULL, NULL),
(24, 'Three Wheeler', '1', '2017-08-14', NULL, NULL, NULL, '05', NULL, NULL),
(25, 'Three Wheeler', '1', '2017-08-14', NULL, NULL, NULL, '06', NULL, NULL),
(26, 'Three Wheeler', '1', '2017-08-14', NULL, NULL, NULL, '07', NULL, NULL),
(27, 'Three Wheeler', '1', '2017-08-14', NULL, NULL, NULL, '08', NULL, NULL),
(28, 'Three Wheeler', '1', '2017-08-14', NULL, NULL, NULL, '09', NULL, NULL),
(29, 'Three Wheeler', '1', '2017-08-14', NULL, NULL, NULL, '0L', NULL, NULL),
(30, 'Three Wheeler', '1', '2017-08-14', NULL, NULL, NULL, '02', NULL, NULL),
(31, 'Three Wheeler', '1', '2017-08-14', NULL, NULL, NULL, '0A', NULL, NULL),
(32, 'Three Wheeler', '1', '2017-08-14', NULL, NULL, NULL, '0B', NULL, NULL),
(33, 'Three Wheeler', '1', '2017-08-14', NULL, NULL, NULL, '0C', NULL, NULL),
(34, 'Three Wheeler', '1', '2017-08-14', NULL, NULL, NULL, '0D', NULL, NULL),
(35, 'Three Wheeler', '1', '2017-08-14', NULL, NULL, NULL, '0E', NULL, NULL),
(36, 'Three Wheeler', '1', '2017-08-14', NULL, NULL, NULL, '0F', NULL, NULL),
(37, 'Three Wheeler', '1', '2017-08-14', NULL, NULL, NULL, '0G', NULL, NULL),
(38, 'Three Wheeler', '1', '2017-08-14', NULL, NULL, NULL, '0H', NULL, NULL),
(39, 'Three Wheeler', '1', '2017-08-14', NULL, NULL, NULL, '0I', NULL, NULL),
(40, 'Three Wheeler', '1', '2017-08-14', NULL, NULL, NULL, '0J', NULL, NULL),
(41, 'Three Wheeler', '1', '2017-08-14', NULL, NULL, NULL, '0K', NULL, NULL),
(42, 'Three Wheeler', '1', '2017-08-14', NULL, NULL, NULL, '03', NULL, NULL),
(43, 'Four Wheeler', '1', '2017-08-14', NULL, NULL, NULL, '01', NULL, NULL),
(44, 'Four Wheeler', '1', '2017-08-14', NULL, NULL, NULL, '04', NULL, NULL),
(45, 'Four Wheeler', '1', '2017-08-14', NULL, NULL, NULL, '05', NULL, NULL),
(46, 'Four Wheeler', '1', '2017-08-14', NULL, NULL, NULL, '06', NULL, NULL),
(47, 'Four Wheeler', '1', '2017-08-14', NULL, NULL, NULL, '07', NULL, NULL),
(48, 'Four Wheeler', '1', '2017-08-14', NULL, NULL, NULL, '08', NULL, NULL),
(49, 'Four Wheeler', '1', '2017-08-14', NULL, NULL, NULL, '09', NULL, NULL),
(50, 'Four Wheeler', '1', '2017-08-14', NULL, NULL, NULL, '0L', NULL, NULL),
(51, 'Four Wheeler', '1', '2017-08-14', NULL, NULL, NULL, '02', NULL, NULL),
(52, 'Four Wheeler', '1', '2017-08-14', NULL, NULL, NULL, '0A', NULL, NULL),
(53, 'Four Wheeler', '1', '2017-08-14', NULL, NULL, NULL, '0B', NULL, NULL),
(54, 'Four Wheeler', '1', '2017-08-14', NULL, NULL, NULL, '0C', NULL, NULL),
(55, 'Four Wheeler', '1', '2017-08-14', NULL, NULL, NULL, '0D', NULL, NULL),
(56, 'Four Wheeler', '1', '2017-08-14', NULL, NULL, NULL, '0E', NULL, NULL),
(57, 'Four Wheeler', '1', '2017-08-14', NULL, NULL, NULL, '0F', NULL, NULL),
(58, 'Four Wheeler', '1', '2017-08-14', NULL, NULL, NULL, '0G', NULL, NULL),
(59, 'Four Wheeler', '1', '2017-08-14', NULL, NULL, NULL, '0H', NULL, NULL),
(60, 'Four Wheeler', '1', '2017-08-14', NULL, NULL, NULL, '0I', NULL, NULL),
(61, 'Four Wheeler', '1', '2017-08-14', NULL, NULL, NULL, '0J', NULL, NULL),
(62, 'Four Wheeler', '1', '2017-08-14', NULL, NULL, NULL, '0K', NULL, NULL),
(63, 'Four Wheeler', '1', '2017-08-14', NULL, NULL, NULL, '03', NULL, NULL),
(64, 'Cab', '1', '2017-08-14', NULL, NULL, NULL, '01', NULL, NULL),
(65, 'Cab', '1', '2017-08-14', NULL, NULL, NULL, '04', NULL, NULL),
(66, 'Cab', '1', '2017-08-14', NULL, NULL, NULL, '05', NULL, NULL),
(67, 'Cab', '1', '2017-08-14', NULL, NULL, NULL, '06', NULL, NULL),
(68, 'Cab', '1', '2017-08-14', NULL, NULL, NULL, '07', NULL, NULL),
(69, 'Cab', '1', '2017-08-14', NULL, NULL, NULL, '08', NULL, NULL),
(70, 'Cab', '1', '2017-08-14', NULL, NULL, NULL, '09', NULL, NULL),
(71, 'Cab', '1', '2017-08-14', NULL, NULL, NULL, '0L', NULL, NULL),
(72, 'Cab', '1', '2017-08-14', NULL, NULL, NULL, '02', NULL, NULL),
(73, 'Cab', '1', '2017-08-14', NULL, NULL, NULL, '0A', NULL, NULL),
(74, 'Cab', '1', '2017-08-14', NULL, NULL, NULL, '0B', NULL, NULL),
(75, 'Cab', '1', '2017-08-14', NULL, NULL, NULL, '0C', NULL, NULL),
(76, 'Cab', '1', '2017-08-14', NULL, NULL, NULL, '0D', NULL, NULL),
(77, 'Cab', '1', '2017-08-14', NULL, NULL, NULL, '0E', NULL, NULL),
(78, 'Cab', '1', '2017-08-14', NULL, NULL, NULL, '0F', NULL, NULL),
(79, 'Cab', '1', '2017-08-14', NULL, NULL, NULL, '0G', NULL, NULL),
(80, 'Cab', '1', '2017-08-14', NULL, NULL, NULL, '0H', NULL, NULL),
(83, 'Cab', '1', '2017-08-14', NULL, NULL, NULL, '0K', NULL, NULL),
(84, 'Cab', '1', '2017-08-14', NULL, NULL, NULL, '03', NULL, NULL),
(85, 'auto', '1', '2017-10-24', NULL, NULL, NULL, '03', NULL, NULL),
(86, 'bail gaadi', '1', '2017-10-24', NULL, NULL, NULL, '04', NULL, NULL),
(87, 'Commercial', '1', '2017-10-25', NULL, NULL, NULL, '03', NULL, NULL),
(89, 'safal', '1', '2017-10-25', NULL, NULL, NULL, '04', NULL, NULL),
(90, 'caarrrr', '1', '2017-10-25', NULL, NULL, NULL, '01', NULL, NULL),
(91, 'paiidaaaallllll', '1', '2017-10-26', NULL, NULL, NULL, '03', NULL, NULL),
(92, 'anjsn', '1', '2017-10-31', NULL, NULL, NULL, '01', NULL, NULL),
(95, 'bycycle', '1', '2017-11-06', NULL, NULL, NULL, '01', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `mst_wheeler_type`
--

CREATE TABLE `mst_wheeler_type` (
  `id` int(10) NOT NULL,
  `org_id` varchar(100) DEFAULT NULL,
  `vehical` int(11) NOT NULL,
  `wheeler_type` int(11) NOT NULL,
  `price` float DEFAULT NULL,
  `effected_date` date NOT NULL,
  `status` enum('0','1') DEFAULT NULL,
  `effected_status` int(11) NOT NULL DEFAULT '1' COMMENT '1="Active", 0="Inactive"',
  `created` date DEFAULT NULL,
  `modified` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mst_wheeler_type`
--

INSERT INTO `mst_wheeler_type` (`id`, `org_id`, `vehical`, `wheeler_type`, `price`, `effected_date`, `status`, `effected_status`, `created`, `modified`) VALUES
(3, '01', 1, 2, 12, '2017-02-04', '1', 1, '2017-02-08', '2017-02-08'),
(4, '01', 2, 2, 122, '2017-06-02', '1', 1, '2017-02-08', '2017-02-08'),
(6, '01', 1, 2, 122, '2017-02-06', '1', 1, '2017-02-08', '2017-02-08'),
(8, '01', 4, 1, 13, '2017-02-02', '1', 1, '2017-02-10', '2017-02-10'),
(9, '01', 1, 1, 22, '2017-02-08', '1', 1, '2017-02-24', '2017-02-24'),
(10, '01', 2, 1, 23, '2017-02-20', '1', 1, '2017-02-24', '2017-02-24'),
(11, '01', 0, 1, 26, '2017-08-15', '1', 1, '2017-08-18', '2017-08-18'),
(12, '01', 1, 1, 40, '2017-09-20', '1', 1, '2017-09-18', '2017-09-18'),
(13, '01', 1, 1, 100, '2016-10-12', '1', 1, '2017-10-24', '2017-10-24'),
(14, '03', 43, 1, 10000, '2016-12-10', '1', 1, '2017-10-24', '2017-10-24'),
(15, '03', 43, 1, 10000, '2016-10-12', '1', 1, '2017-10-24', '2017-10-24'),
(16, '02', 9, 1, 23, '2017-10-24', '1', 1, '2017-10-24', '2017-10-24'),
(17, '02', 9, 1, 12, '2017-10-23', '1', 1, '2017-10-24', '2017-10-24'),
(18, '04', 86, 2, 100, '2017-10-26', '1', 1, '2017-10-25', '2017-10-25'),
(19, '01', 22, 1, 215.25, '2017-10-23', '1', 1, '2017-10-25', '2017-10-25'),
(21, '04', 90, 2, 120.13, '1970-01-01', '1', 1, '2017-10-25', '2017-10-25'),
(22, '03', 91, 1, 10, '2017-10-26', '1', 1, '2017-10-26', '2017-10-26'),
(23, '03', 1, 1, 10, '2017-10-22', '1', 1, '2017-10-26', '2017-10-26'),
(24, '01', 1, 1, 22, '2017-10-25', '1', 1, '2017-10-26', '2017-10-26'),
(25, '01', 1, 1, 22, '1970-01-01', '1', 1, '2017-10-27', '2017-10-27'),
(26, '01', 1, 2, 21, '1970-01-01', '1', 1, '2017-10-31', '2017-10-31'),
(27, '01', 1, 2, 21, '1970-01-07', '1', 1, '2017-10-31', '2017-10-31'),
(28, '01', 1, 2, 21, '2017-10-07', '1', 1, '2017-10-31', '2017-10-31'),
(29, '01', 90, 1, 10, '2017-11-01', '1', 1, '2017-11-01', '2017-11-01'),
(30, '03', 63, 1, 22, '2017-10-31', '1', 1, '2017-11-01', '2017-11-01'),
(31, '03', 91, 1, 11, '2017-11-02', '1', 1, '2017-11-02', '2017-11-02'),
(32, '03', 1, 1, 11, '2017-11-01', '1', 1, '2017-11-02', '2017-11-02'),
(33, '03', 21, 1, 12, '2017-11-01', '1', 1, '2017-11-02', '2017-11-02'),
(34, '03', 1, 1, 12, '2017-10-31', '1', 1, '2017-11-02', '2017-11-02'),
(35, '03', 1, 2, 12, '2017-10-31', '1', 1, '2017-11-02', '2017-11-02'),
(36, '01', 1, 2, 11.5, '2017-10-31', '1', 1, '2017-11-06', '2017-11-06'),
(37, '03', 87, 1, 10, '2017-11-05', '1', 1, '2017-11-06', '2017-11-06'),
(38, '03', 1, 1, 10, '2017-05-17', '1', 1, '2017-11-08', '2017-11-08');

-- --------------------------------------------------------

--
-- Table structure for table `myprofile`
--

CREATE TABLE `myprofile` (
  `id` int(11) NOT NULL,
  `doc_id` varchar(255) NOT NULL,
  `emp_code` varchar(40) DEFAULT NULL,
  `emp_id` varchar(255) NOT NULL,
  `dept_code` varchar(40) DEFAULT NULL,
  `desg_code` varchar(40) DEFAULT NULL,
  `emp_grp_id` varchar(255) NOT NULL,
  `emp_nm_ttl` varchar(20) DEFAULT NULL,
  `emp_firstname` varchar(100) DEFAULT NULL,
  `emp_middle` varchar(255) DEFAULT NULL,
  `emp_lastname` varchar(100) DEFAULT NULL,
  `emp_full_name` varchar(255) DEFAULT NULL,
  `comp_code` varchar(40) DEFAULT NULL,
  `gender` varchar(40) DEFAULT NULL,
  `contact` varchar(40) DEFAULT NULL,
  `personal_phone` varchar(20) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `join_date` date DEFAULT NULL,
  `image` varchar(100) DEFAULT NULL,
  `cur_address` varchar(100) DEFAULT NULL,
  `cur_city_id` varchar(40) DEFAULT NULL,
  `cur_phone` int(255) DEFAULT NULL,
  `cur_landline` varchar(20) DEFAULT NULL,
  `cur_state_id` varchar(40) DEFAULT NULL,
  `cur_country_id` varchar(40) DEFAULT NULL,
  `cur_pincode` varchar(40) DEFAULT NULL,
  `per_address` varchar(100) DEFAULT NULL,
  `per_city_id` varchar(40) DEFAULT NULL,
  `per_state_id` varchar(40) DEFAULT NULL,
  `per_country_id` varchar(40) DEFAULT NULL,
  `per_phone` int(255) NOT NULL,
  `per_landline` int(20) DEFAULT NULL,
  `per_pincode` varchar(40) DEFAULT NULL,
  `per_email` varchar(255) DEFAULT NULL,
  `region_id` varchar(40) DEFAULT NULL,
  `marital_code` varchar(40) DEFAULT NULL,
  `blood_group` varchar(40) DEFAULT NULL,
  `wedding_date` date DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL,
  `modified_date` date DEFAULT NULL,
  `card_no` varchar(40) DEFAULT NULL,
  `location_code` varchar(40) DEFAULT NULL,
  `emp_pay_mode` varchar(40) DEFAULT NULL,
  `bank_code` varchar(40) DEFAULT NULL,
  `branch_code` varchar(40) DEFAULT NULL,
  `account_type` varchar(40) DEFAULT NULL,
  `account_no` varchar(40) DEFAULT NULL,
  `ifsc_code` varchar(40) DEFAULT NULL,
  `swift_code` varchar(40) DEFAULT NULL,
  `pan_no` varchar(40) DEFAULT NULL,
  `guardian_name` varchar(100) DEFAULT NULL,
  `guardian_relation` varchar(40) DEFAULT NULL,
  `manager_code` varchar(40) DEFAULT NULL,
  `notice_period` varchar(40) DEFAULT NULL,
  `father_name` varchar(255) DEFAULT NULL,
  `mother_name` varchar(255) DEFAULT NULL,
  `son` varchar(255) DEFAULT NULL,
  `pf_no` varchar(255) DEFAULT NULL,
  `ess_no` varchar(255) DEFAULT NULL,
  `config` int(5) DEFAULT NULL,
  `grd_id` varchar(20) DEFAULT NULL,
  `notch_id` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Triggers `myprofile`
--
DELIMITER $$
CREATE TRIGGER `myprofile_after_update` AFTER UPDATE ON `myprofile` FOR EACH ROW IF @DISABLE_TRIGGERS IS NULL THEN
	INSERT INTO newdata VALUES (NEW.id,'myprofile','U');
END IF
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `newdata`
--

CREATE TABLE `newdata` (
  `id` int(3) NOT NULL,
  `table_name` varchar(50) NOT NULL,
  `operation` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `notice_periods`
--

CREATE TABLE `notice_periods` (
  `id` int(10) NOT NULL,
  `emp_service` int(10) DEFAULT NULL,
  `notice_period` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `notification_reminder_type`
--

CREATE TABLE `notification_reminder_type` (
  `id` int(1) NOT NULL,
  `notification_reminder_type` int(1) NOT NULL,
  `notification_reminder_type_value` varchar(30) NOT NULL,
  `reminder_days` int(1) NOT NULL,
  `created_date` datetime NOT NULL,
  `updated_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `notification_reminder_type`
--

INSERT INTO `notification_reminder_type` (`id`, `notification_reminder_type`, `notification_reminder_type_value`, `reminder_days`, `created_date`, `updated_date`) VALUES
(1, 1, 'Yes', 2, '2016-10-20 00:00:00', '2016-10-20 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `options`
--

CREATE TABLE `options` (
  `id` int(20) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `opt_status` int(20) DEFAULT NULL,
  `attribute_type_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `options_count`
--

CREATE TABLE `options_count` (
  `id` int(10) NOT NULL,
  `number` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `options_count`
--

INSERT INTO `options_count` (`id`, `number`) VALUES
(1, 4);

-- --------------------------------------------------------

--
-- Table structure for table `option_attribute`
--

CREATE TABLE `option_attribute` (
  `id` varchar(20) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `options_id` int(20) DEFAULT NULL,
  `sloc_id` varchar(25) DEFAULT NULL,
  `cld_id` varchar(22) DEFAULT NULL,
  `ho_org_id` varchar(22) DEFAULT NULL,
  `org_id` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `option_attribute_org`
--

CREATE TABLE `option_attribute_org` (
  `id` int(20) DEFAULT NULL,
  `cld_id` varchar(20) DEFAULT NULL,
  `sloc_id` varchar(20) DEFAULT NULL,
  `ho_org_id` varchar(20) DEFAULT NULL,
  `org_id` varchar(20) DEFAULT NULL,
  `param_id` varchar(255) DEFAULT NULL,
  `created_at` date DEFAULT NULL,
  `modify` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `option_attribute_org`
--

INSERT INTO `option_attribute_org` (`id`, `cld_id`, `sloc_id`, `ho_org_id`, `org_id`, `param_id`, `created_at`, `modify`) VALUES
(NULL, '0000', '1', '01', '01', 'PAR0000050', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '01', '01', 'PAR0000051', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '01', '01', 'PAR0000052', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '01', '01', 'PAR0000027', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '01', '01', 'PAR0000039', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '01', '01', 'PAR0000040', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '01', '01', 'PAR0000102', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '01', '01', 'PAR0000104', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '01', '01', 'PAR0000108', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '01', '01', 'PAR0000116', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '01', '01', 'PAR0000001', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '01', '01', 'PAR0000002', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '01', '01', 'PAR0000003', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '01', '01', 'PAR0000005', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '01', '01', 'PAR0000006', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '01', '01', 'PAR0000007', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '01', '01', 'PAR0000008', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '01', '01', 'PAR0000009', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '01', '01', 'PAR0000010', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '01', '01', 'PAR0000011', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '01', '01', 'PAR0000012', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '01', '01', 'PAR0000013', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '01', '01', 'PAR0000014', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '01', '01', 'PAR0000015', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '01', '01', 'PAR0000016', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '01', '01', 'PAR0000017', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '01', '01', 'PAR0000018', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '01', '01', 'PAR0000019', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '01', '01', 'PAR0000020', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '01', '01', 'PAR0000021', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '01', '01', 'PAR0000022', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '01', '01', 'PAR0000030', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '01', '01', 'PAR0000033', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '01', '01', 'PAR0000036', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '01', '01', 'PAR0000029', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '01', '01', 'PAR0000042', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '01', '01', 'PAR0000043', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '01', '01', 'PAR0000034', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '01', '01', 'PAR0000037', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '01', '01', 'PAR0000038', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '01', '01', 'PAR0000024', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '01', '01', 'PAR0000044', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '01', '01', 'PAR0000045', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '01', '01', 'PAR0000025', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '01', '01', 'PAR0000035', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '01', '01', 'PAR0000046', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '01', '01', 'PAR0000047', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '01', '01', 'PAR0000048', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '01', '01', 'PAR0000049', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '01', '01', 'PAR0000053', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '01', '01', 'PAR0000054', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '01', '01', 'PAR0000055', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '01', '01', 'PAR0000031', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '01', '01', 'PAR0000056', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '01', '01', 'PAR0000023', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '01', '01', 'PAR0000057', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '02', '02', 'PAR0000040', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '02', '02', 'PAR0000041', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '02', '02', 'PAR0000043', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '02', '02', 'PAR0000044', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '02', '02', 'PAR0000042', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '01', '01', 'PAR0000062', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '01', '01', 'PAR0000063', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '01', '01', 'PAR0000064', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '01', '01', 'PAR0000065', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '01', '01', 'PAR0000066', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '01', '01', 'PAR0000095', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '01', '01', 'PAR0000087', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '01', '01', 'PAR0000097', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '01', '01', 'PAR0000098', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '01', '01', 'PAR0000099', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '02', '02', 'PAR0000007', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '02', '02', 'PAR0000028', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '02', '02', 'PAR0000030', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '02', '02', 'PAR0000031', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '02', '02', 'PAR0000029', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '02', '02', 'PAR0000036', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '02', '02', 'PAR0000037', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '02', '02', 'PAR0000038', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '02', '02', 'PAR0000039', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '01', '01', 'PAR0000041', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '01', '01', 'PAR0000058', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '01', '01', 'PAR0000059', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '01', '01', 'PAR0000060', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '01', '01', 'PAR0000061', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '01', '01', 'PAR0000067', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '01', '01', 'PAR0000068', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '01', '01', 'PAR0000069', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '01', '01', 'PAR0000070', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '01', '01', 'PAR0000071', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '01', '01', 'PAR0000072', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '01', '01', 'PAR0000073', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '01', '01', 'PAR0000074', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '01', '01', 'PAR0000075', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '01', '01', 'PAR0000076', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '01', '01', 'PAR0000077', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '01', '01', 'PAR0000078', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '01', '01', 'PAR0000079', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '01', '01', 'PAR0000080', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '01', '01', 'PAR0000081', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '01', '01', 'PAR0000082', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '01', '01', 'PAR0000083', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '01', '01', 'PAR0000084', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '01', '01', 'PAR0000085', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '01', '01', 'PAR0000086', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '01', '01', 'PAR0000090', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '01', '01', 'PAR0000091', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '01', '01', 'PAR0000092', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '01', '01', 'PAR0000093', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '02', '02', 'PAR0000003', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '02', '02', 'PAR0000004', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '02', '02', 'PAR0000047', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '01', '01', 'PAR0000096', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '03', '03', 'PAR0000002', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '03', '03', 'PAR0000003', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '03', '03', 'PAR0000005', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '03', '03', 'PAR0000007', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '03', '03', 'PAR0000008', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '03', '03', 'PAR0000009', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '03', '03', 'PAR0000010', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '03', '03', 'PAR0000011', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '03', '03', 'PAR0000012', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '03', '03', 'PAR0000013', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '03', '03', 'PAR0000014', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '03', '03', 'PAR0000015', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '03', '03', 'PAR0000016', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '03', '03', 'PAR0000017', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '03', '03', 'PAR0000018', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '03', '03', 'PAR0000019', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '03', '03', 'PAR0000020', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '03', '03', 'PAR0000021', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '03', '03', 'PAR0000022', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '03', '03', 'PAR0000023', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '03', '03', 'PAR0000024', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '03', '03', 'PAR0000025', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '03', '03', 'PAR0000026', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '03', '03', 'PAR0000027', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '03', '03', 'PAR0000028', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '03', '03', 'PAR0000029', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '03', '03', 'PAR0000030', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '03', '03', 'PAR0000031', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '03', '03', 'PAR0000032', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '03', '03', 'PAR0000033', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '03', '03', 'PAR0000034', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '03', '03', 'PAR0000035', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '02', '02', 'PAR0000011', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '02', '02', 'PAR0000008', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '02', '02', 'PAR0000009', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '02', '02', 'PAR0000010', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '02', '02', 'PAR0000012', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '02', '02', 'PAR0000013', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '02', '02', 'PAR0000014', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '02', '02', 'PAR0000015', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '02', '02', 'PAR0000018', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '02', '02', 'PAR0000019', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '02', '02', 'PAR0000020', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '02', '02', 'PAR0000021', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '02', '02', 'PAR0000022', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '02', '02', 'PAR0000023', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '02', '02', 'PAR0000024', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '02', '02', 'PAR0000025', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '02', '02', 'PAR0000026', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '02', '02', 'PAR0000027', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '02', '02', 'PAR0000001', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '02', '02', 'PAR0000002', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '02', '02', 'PAR0000005', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '02', '02', 'PAR0000006', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '02', '02', 'PAR0000032', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '02', '02', 'PAR0000033', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '02', '02', 'PAR0000034', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '02', '02', 'PAR0000035', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '03', '03', 'PAR0000001', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '01', '01', 'PAR0000103', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '01', '01', 'PAR0000105', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '01', '01', 'PAR0000106', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '01', '01', 'PAR0000109', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '01', '01', 'PAR0000110', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '01', '01', 'PAR0000111', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '01', '01', 'PAR0000112', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '01', '01', 'PAR0000113', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '01', '01', 'PAR0000115', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '01', '01', 'PAR0000026', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '01', '01', 'PAR0000122', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '01', '01', 'PAR0000120', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '03', '03', 'PAR0000036', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '01', '01', 'PAR0000127', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '03', '03', 'PAR0000042', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '03', '03', 'PAR0000043', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '03', '03', 'PAR0000037', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '02', '02', 'PAR0000048', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '02', '02', 'PAR0000058', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '01', '01', 'PAR0000130', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '01', '01', 'PAR0000131', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '01', '01', 'PAR0000132', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '01', '01', 'PAR0000133', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '01', '01', 'PAR0000135', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '01', '01', 'PAR0000136', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '01', '01', 'PAR0000137', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '01', '01', 'PAR0000138', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '01', '01', 'PAR0000139', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '01', '01', 'PAR0000140', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '01', '01', 'PAR0000141', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '01', '01', 'PAR0000142', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '01', '01', 'PAR0000143', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '01', '01', 'PAR0000144', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '03', '03', 'PAR0000063', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '01', '01', 'PAR0000145', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '01', '01', 'PAR0000146', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '01', '01', 'PAR0000149', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '03', '03', 'PAR0000071', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '03', '03', 'PAR0000072', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '03', '03', 'PAR0000073', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '03', '03', 'PAR0000074', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '01', '01', 'PAR0000152', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '01', '01', 'PAR0000156', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '03', '03', 'PAR0000077', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '03', '03', 'PAR0000078', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '03', '03', 'PAR0000079', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '03', '03', 'PAR0000080', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '03', '03', 'PAR0000081', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '03', '03', 'PAR0000082', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '03', '03', 'PAR0000083', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '03', '03', 'PAR0000084', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '03', '03', 'PAR0000085', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '03', '03', 'PAR0000086', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '02', '02', 'PAR0000063', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '02', '02', 'PAR0000064', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '01', '01', 'PAR0000119', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '01', '01', 'PAR0000121', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '01', '01', 'PAR0000126', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '01', '01', 'PAR0000004', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '01', '01', 'PAR0000128', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '01', '01', 'PAR0000129', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '03', '03', 'PAR0000046', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '03', '03', 'PAR0000047', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '03', '03', 'PAR0000048', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '03', '03', 'PAR0000049', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '03', '03', 'PAR0000050', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '03', '03', 'PAR0000051', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '03', '03', 'PAR0000053', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '02', '02', 'PAR0000059', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '03', '03', 'PAR0000056', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '03', '03', 'PAR0000057', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '01', '01', 'PAR0000147', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '03', '03', 'PAR0000064', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '03', '03', 'PAR0000065', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '03', '03', 'PAR0000066', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '03', '03', 'PAR0000067', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '03', '03', 'PAR0000068', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '03', '03', 'PAR0000069', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '01', '01', 'PAR0000028', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '01', '01', 'PAR0000032', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '01', '01', 'PAR0000151', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '01', '01', 'PAR0000153', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '01', '01', 'PAR0000154', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '03', '03', 'PAR0000045', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '02', '02', 'PAR0000062', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '01', '01', 'PAR0000117', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '01', '01', 'PAR0000118', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '01', '01', 'PAR0000123', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '01', '01', 'PAR0000124', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '01', '01', 'PAR0000125', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '03', '03', 'PAR0000040', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '03', '03', 'PAR0000041', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '03', '03', 'PAR0000044', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '03', '03', 'PAR0000039', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '02', '02', 'PAR0000049', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '02', '02', 'PAR0000050', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '02', '02', 'PAR0000053', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '02', '02', 'PAR0000054', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '02', '02', 'PAR0000052', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '02', '02', 'PAR0000051', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '02', '02', 'PAR0000055', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '02', '02', 'PAR0000056', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '02', '02', 'PAR0000057', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '03', '03', 'PAR0000088', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '03', '03', 'PAR0000054', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '03', '03', 'PAR0000055', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '03', '03', 'PAR0000058', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '03', '03', 'PAR0000059', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '03', '03', 'PAR0000060', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '03', '03', 'PAR0000061', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '03', '03', 'PAR0000062', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '01', '01', 'PAR0000148', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '02', '02', 'PAR0000060', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '01', '01', 'PAR0000150', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '01', '01', 'PAR0000155', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '03', '03', 'PAR0000075', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '03', '03', 'PAR0000076', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '02', '02', 'PAR0000061', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '03', '03', 'PAR0000087', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '03', '03', 'PAR0000089', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '03', '03', 'PAR0000090', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '03', '03', 'PAR0000091', '2017-11-09', '2017-11-09'),
(NULL, '0000', '1', '01', '01', 'PAR0000163', '2017-11-09', '2017-11-09'),
(0, '0000', '1', '03', '03', 'PAR0000086', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `oracle_app_eo`
--

CREATE TABLE `oracle_app_eo` (
  `id` int(10) NOT NULL,
  `eo_sloc_id` int(2) NOT NULL,
  `eo_mst_id` int(20) NOT NULL,
  `eo_type` int(5) NOT NULL,
  `eo_id` int(20) NOT NULL,
  `eo_alias` varchar(20) DEFAULT NULL,
  `eo_leg_code` varchar(20) DEFAULT NULL,
  `eo_nm` varchar(250) NOT NULL,
  `eo_nm_chq` varchar(250) DEFAULT NULL,
  `eo_nm_doc` varchar(250) DEFAULT NULL,
  `eo_nacc_id` int(20) DEFAULT NULL,
  `eo_acc_id` int(20) DEFAULT NULL,
  `eo_lmt` int(10) DEFAULT NULL,
  `eo_actv` varchar(1) NOT NULL DEFAULT 'y',
  `eo_resv` varchar(1) NOT NULL DEFAULT 'y',
  `usr_id_create` int(4) NOT NULL,
  `usr_id_create_dt` date NOT NULL,
  `usr_id_mod` int(4) DEFAULT NULL,
  `usr_id_mod_dt` date DEFAULT NULL,
  `ss_id` int(11) DEFAULT NULL,
  `eo_bhav` varchar(1) DEFAULT NULL,
  `eo_data_ins` varchar(1) DEFAULT NULL,
  `eo_na_create` varchar(1) DEFAULT NULL,
  `eo_org_id` varchar(2) DEFAULT '01',
  `eo_ho_org_id` varchar(2) DEFAULT '01',
  `eo_cld_id` varchar(4) DEFAULT '0000',
  `curr_id_sp` int(20) DEFAULT NULL,
  `catg_id` int(5) DEFAULT NULL,
  `legecy_id` varchar(8) DEFAULT NULL,
  `eo_ifsc_cd` varchar(15) DEFAULT NULL,
  `eo_swift_cd` varchar(15) DEFAULT NULL,
  `app_eo_typ_mig` varchar(2) DEFAULT 'n',
  `eo_src` varchar(3) DEFAULT 'app',
  `app_eo_bnk_brn_code` varchar(30) DEFAULT NULL,
  `eo_for_org` varchar(1) NOT NULL DEFAULT 'n',
  `eo_for_org_id` varchar(2) DEFAULT NULL,
  `eo_catg_bp_id` int(10) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `oracle_hcm_dependant_dtl`
--

CREATE TABLE `oracle_hcm_dependant_dtl` (
  `cld_id` varchar(4) DEFAULT NULL,
  `sloc_id` int(10) DEFAULT NULL,
  `ho_org_id` varchar(2) DEFAULT NULL,
  `org_id` varchar(2) DEFAULT NULL,
  `doc_id` varchar(40) DEFAULT NULL,
  `mem_nm` varchar(200) DEFAULT NULL,
  `mem_dob` date DEFAULT NULL,
  `mem_age` varchar(50) DEFAULT NULL,
  `mem_rel` varchar(250) DEFAULT NULL,
  `mem_occu` varchar(200) DEFAULT NULL,
  `mem_gen` varchar(20) DEFAULT NULL,
  `usr_id_create` int(10) DEFAULT NULL,
  `usr_id_create_dt` date DEFAULT NULL,
  `usr_id_mod` int(10) DEFAULT NULL,
  `usr_id_mod_dt` date DEFAULT NULL,
  `mem_dob_loc` varchar(250) DEFAULT NULL,
  `mem_add` varchar(255) DEFAULT NULL,
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `oracle_hcm_dependant_dtl`
--

INSERT INTO `oracle_hcm_dependant_dtl` (`cld_id`, `sloc_id`, `ho_org_id`, `org_id`, `doc_id`, `mem_nm`, `mem_dob`, `mem_age`, `mem_rel`, `mem_occu`, `mem_gen`, `usr_id_create`, `usr_id_create_dt`, `usr_id_mod`, `usr_id_mod_dt`, `mem_dob_loc`, `mem_add`, `id`) VALUES
('0000', 1, '01', '01', '0000.01.01.0001.07Pp.00.1UKzgwXakX', 'MILANDF', '1992-11-15', NULL, 'SOUL CONNECTION.. ', 'VELLAGIRI', 'PAR0000009', 1, '2016-12-27', 1, '2016-12-27', 'Nadiad', 'Guru Krupa Society', 1),
('0000', 1, '01', '01', '0000.01.01.0001.07Pp.00.1UKzgwXakX', 'MILANDF', '1992-11-15', NULL, 'SOUL CONNECTION.. ', 'VELLAGIRI', 'PAR0000009', 1, '2016-12-27', 1, '2016-12-27', 'Nadiad', 'Guru Krupa Society', 2),
('0000', 1, '01', '01', '0000.01.01.0001.07Pp.00.1UKzi1Pcce', 'BARCELONA INDIA', '2016-11-21', NULL, 'COMPETITOR', 'FOOTBALLER', 'PAR0000009', 1, '2016-12-27', 1, '2016-12-27', 'CHINA', 'BEIJING', 3);

-- --------------------------------------------------------

--
-- Table structure for table `oracle_hcm_emp_exp`
--

CREATE TABLE `oracle_hcm_emp_exp` (
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

-- --------------------------------------------------------

--
-- Table structure for table `oracle_hcm_emp_leave`
--

CREATE TABLE `oracle_hcm_emp_leave` (
  `id` int(11) NOT NULL,
  `cld_id` varchar(4) DEFAULT NULL,
  `sloc_id` int(10) DEFAULT NULL,
  `ho_org_id` varchar(2) DEFAULT NULL,
  `org_id` varchar(2) DEFAULT NULL,
  `doc_id` varchar(40) DEFAULT NULL,
  `emp_code` varchar(255) DEFAULT NULL,
  `leave_id` varchar(20) DEFAULT NULL,
  `leave_year` int(10) NOT NULL,
  `leave_bal` float DEFAULT NULL,
  `leave_accrual_rate` float DEFAULT NULL,
  `valid_strt_dt` date DEFAULT NULL,
  `valid_end_dt` date DEFAULT NULL,
  `usr_id_create` varchar(255) NOT NULL,
  `usr_id_create_dt` date NOT NULL,
  `usr_id_mod` varchar(255) DEFAULT NULL,
  `usr_id_mod_dt` date DEFAULT NULL,
  `leave_op` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `oracle_hcm_emp_leave`
--

INSERT INTO `oracle_hcm_emp_leave` (`id`, `cld_id`, `sloc_id`, `ho_org_id`, `org_id`, `doc_id`, `emp_code`, `leave_id`, `leave_year`, `leave_bal`, `leave_accrual_rate`, `valid_strt_dt`, `valid_end_dt`, `usr_id_create`, `usr_id_create_dt`, `usr_id_mod`, `usr_id_mod_dt`, `leave_op`) VALUES
(413, '0000', 1, '01', '01', '0000.01.25.0001.07Pp.00.1UI60a6ojq', '350', 'PAR0000064', 2016, 5, 2.5, '2016-01-01', NULL, '1', '2016-01-01', '1', '2016-04-08', 30),
(414, '0000', 1, '01', '01', '0000.01.25.0001.07Pp.00.1UI60a6ojq', '350', 'PAR0000064', 2016, 5, 2.5, '2016-01-01', NULL, '1', '2016-01-01', '1', '2016-04-08', 30),
(415, '0000', 1, '01', '01', '0000.01.25.0001.07Pp.00.1UI60a6ojq', '350', 'PAR0000064', 2016, 5, 2.5, '2016-01-01', NULL, '1', '2016-01-01', '1', '2016-04-08', 30),
(416, '0000', 1, '01', '01', '0000.01.25.0001.07Pp.00.1UI60a6ojq', '350', 'PAR0000064', 2016, 5, 2.5, '2016-01-01', NULL, '1', '2016-01-01', '1', '2016-04-08', 30),
(417, '0000', 1, '01', '01', '0000.01.25.0001.07Pp.00.1UI60a6ojq', '350', 'PAR0000064', 2016, 5, 2.5, '2016-01-01', NULL, '1', '2016-01-01', '1', '2016-04-08', 30),
(418, '0000', 1, '01', '01', '0000.01.25.0001.07Pp.00.1UI60a6ojq', '350', 'PAR0000064', 2016, 5, 2.5, '2016-01-01', NULL, '1', '2016-01-01', '1', '2016-04-08', 30),
(419, '0000', 1, '01', '01', '0000.01.25.0001.07Pp.00.1UI60a6ojq', '350', 'PAR0000064', 2016, 5, 2.5, '2016-01-01', NULL, '1', '2016-01-01', '1', '2016-04-08', 30),
(420, '0000', 1, '01', '01', '0000.01.25.0001.07Pp.00.1UI60a6ojq', '350', 'PAR0000064', 2016, 5, 2.5, '2016-01-01', NULL, '1', '2016-01-01', '1', '2016-04-08', 30),
(421, '0000', 1, '01', '01', '0000.01.25.0001.07Pp.00.1UI60a6ojq', '350', 'PAR0000064', 2016, 5, 2.5, '2016-01-01', NULL, '1', '2016-01-01', '1', '2016-04-08', 30),
(422, '0000', 1, '01', '01', '0000.01.25.0001.07Pp.00.1UI60a6ojq', '350', 'PAR0000064', 2016, 5, 2.5, '2016-01-01', NULL, '1', '2016-01-01', '1', '2016-04-08', 30),
(1041, '0000', 1, '01', '01', '0000.01.25.0001.07Pp.00.1UI60a8skd', '1025', 'PAR0000064', 2016, 5.00057, 2.5, '2016-01-01', NULL, '1', '2016-01-01', '1', '2016-04-08', 27.0006),
(1043, '0000', 1, '01', '01', '0000.01.01.0001.07Pp.00.1UKxn05rZh', '12740', 'PAR0000528', 2017, 1, 2.5, '2016-01-01', '2017-02-28', '1', '2017-02-28', NULL, NULL, NULL),
(1045, '0000', 1, '01', '01', '0000.01.01.0001.07Pp.00.1UKxn05rZh', '12740', 'PAR0000528', 2017, 2, 2.5, '2016-01-01', '2017-02-28', '1', '2017-02-28', NULL, NULL, NULL),
(1046, '0000', 1, '01', '01', '0000.01.01.0001.07Pp.00.1UKxn05rZh', '12740', 'PAR0000528', 2017, 2, 2.5, '2016-01-01', '2017-02-28', '1', '2017-02-28', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `oracle_hcm_emp_leave_encsh`
--

CREATE TABLE `oracle_hcm_emp_leave_encsh` (
  `id` int(11) NOT NULL,
  `cld_id` varchar(4) DEFAULT NULL,
  `sloc_id` int(2) DEFAULT NULL,
  `ho_org_id` varchar(2) DEFAULT NULL,
  `org_id` varchar(2) DEFAULT NULL,
  `doc_id` varchar(40) DEFAULT NULL,
  `doc_dt` date DEFAULT NULL,
  `emp_doc_id` varchar(40) DEFAULT NULL,
  `emp_dept_id` varchar(20) DEFAULT NULL,
  `emp_loc_id` varchar(20) DEFAULT NULL,
  `emp_grp_id` varchar(20) DEFAULT NULL,
  `encsh_amt` int(26) DEFAULT NULL,
  `usr_id_create` int(10) DEFAULT NULL,
  `usr_id_create_dt` date DEFAULT NULL,
  `usr_id_mod` int(10) DEFAULT NULL,
  `usr_id_mod_dt` date DEFAULT NULL,
  `encsh_status` varchar(2) DEFAULT NULL,
  `operation` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `oracle_hcm_emp_leave_encsh_dtl`
--

CREATE TABLE `oracle_hcm_emp_leave_encsh_dtl` (
  `CLD_ID` varchar(4) DEFAULT NULL,
  `SLOC_ID` int(2) DEFAULT NULL,
  `HO_ORG_ID` varchar(2) DEFAULT NULL,
  `ORG_ID` varchar(2) DEFAULT NULL,
  `DOC_ID` varchar(40) DEFAULT NULL,
  `DOC_DT` date DEFAULT NULL,
  `EMP_DOC_ID` varchar(40) DEFAULT NULL,
  `LEAVE_ID` varchar(20) DEFAULT NULL,
  `LEAVE_ENCASH_LIMIT` int(26) DEFAULT NULL,
  `LEAVE_OP` int(26) DEFAULT NULL,
  `LEAVE_AVAIL` int(26) DEFAULT NULL,
  `LEAVE_BAL` int(26) DEFAULT NULL,
  `ENCSH_AMT` int(26) DEFAULT NULL,
  `USR_ID_CREATE` int(10) DEFAULT NULL,
  `USR_ID_CREATE_DT` date DEFAULT NULL,
  `USR_ID_MOD` int(10) DEFAULT NULL,
  `USR_ID_MOD_DT` date DEFAULT NULL,
  `OPERATION` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `oracle_hcm_emp_loan`
--

CREATE TABLE `oracle_hcm_emp_loan` (
  `id` int(11) NOT NULL,
  `cld_id` varchar(4) DEFAULT NULL,
  `sloc_id` int(2) DEFAULT NULL,
  `ho_org_id` varchar(2) DEFAULT NULL,
  `org_id` varchar(2) DEFAULT NULL,
  `doc_id` varchar(40) DEFAULT NULL,
  `loan_id` varchar(20) DEFAULT NULL,
  `emp_doc_id` varchar(40) DEFAULT NULL,
  `tot_loan_amt` int(26) DEFAULT NULL,
  `emp_no_emi` int(5) DEFAULT NULL,
  `emi_strt_dt` date DEFAULT NULL,
  `subsidy_rate` int(26) DEFAULT NULL,
  `interest_rate` int(26) DEFAULT NULL,
  `down_payment` int(26) DEFAULT NULL,
  `penal_interest_rate` int(26) DEFAULT NULL,
  `valid_strt_dt` date DEFAULT NULL,
  `valid_end_dt` date DEFAULT NULL,
  `usr_id_create` int(10) DEFAULT NULL,
  `usr_id_create_dt` date DEFAULT NULL,
  `usr_id_mod` int(10) DEFAULT NULL,
  `usr_id_mod_dt` date DEFAULT NULL,
  `loan_doc_id` varchar(40) DEFAULT NULL,
  `loan_amt` int(26) DEFAULT NULL,
  `effective_dt` date DEFAULT NULL,
  `fix_emp_emi_amt_chk` varchar(1) DEFAULT NULL,
  `fix_emp_emi_amt` int(26) DEFAULT NULL,
  `loan_app_doc_id` varchar(40) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `oracle_hcm_emp_loan`
--

INSERT INTO `oracle_hcm_emp_loan` (`id`, `cld_id`, `sloc_id`, `ho_org_id`, `org_id`, `doc_id`, `loan_id`, `emp_doc_id`, `tot_loan_amt`, `emp_no_emi`, `emi_strt_dt`, `subsidy_rate`, `interest_rate`, `down_payment`, `penal_interest_rate`, `valid_strt_dt`, `valid_end_dt`, `usr_id_create`, `usr_id_create_dt`, `usr_id_mod`, `usr_id_mod_dt`, `loan_doc_id`, `loan_amt`, `effective_dt`, `fix_emp_emi_amt_chk`, `fix_emp_emi_amt`, `loan_app_doc_id`) VALUES
(1, '0000', 1, '01', '01', '0000.01.01.001S.07gA.00.1UNW2rnc9d', 'PAR0000123', '0000.01.25.0001.07Pp.00.1UI7SAIoM1', 200000, 0, '2017-05-01', 0, 0, 0, 0, '2017-05-01', '2017-05-01', 90, '2017-01-07', 90, '2017-05-27', '0000.01.01.0001.07g8.00.1UKn7WVg4S', 200000, '2017-05-01', 'Y', 137161, '0000.01.01.001S.07g9.00.1UKzM8gfGo'),
(2, '0000', 1, '01', '01', '0000.01.01.001S.07gA.00.1UNW2rnekQ', 'PAR0000123', '0000.01.25.0001.07Pp.00.1UI7SAIoQP', 50000, 10, '2017-01-01', 0, 0, 0, 0, '2017-01-01', NULL, 90, '2017-01-07', NULL, NULL, '0000.01.01.0001.07g8.00.1UKn7WVg4S', 50000, '2017-01-01', 'N', NULL, '0000.01.01.001S.07g9.00.1UKzM8hg2w'),
(3, '0000', 1, '01', '01', '0000.01.01.001S.07gA.00.1UNW2rngGQ', 'PAR0000123', '0000.01.25.0001.07Pp.00.1UI7S89os2', 60000, 12, '2016-08-01', 0, 0, 0, 0, '2016-08-01', NULL, 90, '2017-01-07', NULL, NULL, '0000.01.01.0001.07g8.00.1UKn7WVg4S', 60000, '2016-08-01', 'N', NULL, '0000.01.01.001S.07g9.00.1UKtyBuqJv'),
(4, '0000', 1, '01', '01', '0000.01.01.001S.07gA.00.1UNW2rnimw', 'PAR0000123', '0000.01.01.0004.07Pp.00.1UKgFp8pMB', 20000, 1, '2016-08-01', 0, 0, 0, 0, '2016-08-01', NULL, 90, '2017-01-07', NULL, NULL, '0000.01.01.0001.07g8.00.1UKn7WVg4S', 20000, '2016-08-01', 'N', NULL, '0000.01.01.001S.07g9.00.1UKtyBphtQ'),
(5, '0000', 1, '01', '01', '0000.01.01.001S.07gA.00.1UNbH7KjzW', 'PAR0000123', '0000.01.25.0001.07Pp.00.1UI7S8AeDm', 20000, 5, '2017-04-01', 0, 0, 0, 0, '2017-04-01', NULL, 90, '2017-04-04', NULL, NULL, '0000.01.01.0001.07g8.00.1UKn7WVg4S', 20000, '2017-04-01', 'N', NULL, '0000.01.01.001S.07g9.00.1UNbH7Ju3V'),
(6, '0000', 1, '01', '01', '0000.01.01.001S.07gA.00.1UNdQEKLfU', 'PAR0000123', '0000.01.25.0001.07Pp.00.1UI7S8AEoa', 15000, 3, '2017-06-01', 0, 0, 0, 0, '2017-06-01', NULL, 90, '2017-05-26', NULL, NULL, '0000.01.01.0001.07g8.00.1UKn7WVg4S', 15000, '2017-06-01', 'N', NULL, '0000.01.01.001S.07g9.00.1UNdQE1U4I'),
(7, '0000', 1, '01', '01', '0000.01.01.001S.07gA.00.1UNdQEKR8C', 'PAR0000123', '0000.01.01.0004.07Pp.00.1UKgFp6MS3', 30000, 3, '2017-06-01', 0, 0, 0, 0, '2017-06-01', NULL, 90, '2017-05-26', NULL, NULL, '0000.01.01.0001.07g8.00.1UKn7WVg4S', 30000, '2017-06-01', 'N', NULL, '0000.01.01.001S.07g9.00.1UNdQE0jQp'),
(8, '0000', 1, '01', '01', '0000.01.01.001S.07gA.00.1UNdQEKUy6', 'PAR0000123', '0000.01.25.0001.07Pp.00.1UI7SAIn11', 45000, 9, '2017-06-01', 0, 0, 0, 0, '2017-06-01', NULL, 90, '2017-05-26', NULL, NULL, '0000.01.01.0001.07g8.00.1UKn7WVg4S', 45000, '2017-06-01', 'N', NULL, '0000.01.01.001S.07g9.00.1UNdQE2KhD'),
(9, '0000', 1, '01', '01', '0000.01.01.001S.07gA.00.1UNdQEKl1p', 'PAR0000123', '0000.01.25.0001.07Pp.00.1UI7S89mrU', 30000, 0, '2017-06-01', 0, 0, 0, 0, '2017-06-01', '2017-10-31', 90, '2017-05-26', 90, '2017-05-26', '0000.01.01.0001.07g8.00.1UKn7WVg4S', 30000, '2017-06-01', 'Y', 6000, '0000.01.01.001S.07g9.00.1UNdQE0Eqe'),
(10, '0000', 1, '01', '01', '0000.01.01.001S.07gA.00.1UNW9RhzQ9', 'PAR0000123', '0000.01.25.0001.07Pp.00.1UI7S89mix', 30000, 5, '2017-01-13', 0, 0, 0, 0, '2017-01-13', NULL, 90, '2017-01-13', NULL, NULL, '0000.01.01.0001.07g8.00.1UKn7WVg4S', 30000, '2017-01-13', 'N', NULL, '0000.01.01.001S.07g9.00.1UNW9RejUS'),
(11, '0000', 1, '01', '01', '0000.01.01.001S.07gA.00.1UNW9Ri2Uv', 'PAR0000123', '0000.01.25.0001.07Pp.00.1UI7S89mnC', 70000, 10, '2017-01-13', 0, 0, 0, 0, '2017-01-13', NULL, 90, '2017-01-13', NULL, NULL, '0000.01.01.0001.07g8.00.1UKn7WVg4S', 70000, '2017-01-13', 'N', NULL, '0000.01.01.001S.07g9.00.1UNW9RfWxF'),
(12, '0000', 1, '01', '01', '0000.01.01.0007.07gA.00.1UNW2rfeyo', 'PAR0000123', '0000.01.25.0001.07Pp.00.1UI7S89mrU', 25000, 0, '2017-05-01', 0, 0, 0, 0, '2017-05-01', '2017-05-01', 7, '2017-01-07', 7, '2017-05-24', '0000.01.01.0001.07g8.00.1UKn7WVg4S', 25000, '2017-05-01', 'Y', 2952, '0000.01.01.001S.07g9.00.1UKxWdlo17'),
(13, '0000', 1, '01', '01', '0000.01.01.001S.07gA.00.1UNW9Ri10h', 'PAR0000123', '0000.01.01.0004.07Pp.00.1UKlSxf7Bq', 20000, 4, '2017-01-13', 0, 0, 0, 0, '2017-01-13', NULL, 90, '2017-01-13', NULL, NULL, '0000.01.01.0001.07g8.00.1UKn7WVg4S', 20000, '2017-01-13', 'N', NULL, '0000.01.01.001S.07g9.00.1UNW9RhBfD'),
(14, '0000', 1, '01', '01', '0000.01.01.001S.07gA.00.1UNZY9ovKJ', 'PAR0000123', '0000.01.01.0004.07Pp.00.1UKnE7L6Mk', 13000, 3, '2017-03-01', 0, 0, 0, 0, '2017-03-01', NULL, 90, '2017-03-06', NULL, NULL, '0000.01.01.0001.07g8.00.1UKn7WVg4S', 13000, '2017-03-01', 'N', NULL, '0000.01.01.001S.07g9.00.1UNZY9o6So'),
(15, '0000', 1, '01', '01', '0000.01.01.001S.07gA.00.1UNbZgS3HB', 'PAR0000123', '0000.01.25.0001.07Pp.00.1UI7SAIniG', 200000, 10, '2017-04-01', 0, 0, 0, 0, '2017-04-01', NULL, 90, '2017-04-21', NULL, NULL, '0000.01.01.0001.07g8.00.1UKn7WVg4S', 200000, '2017-04-01', 'N', NULL, '0000.01.01.001S.07g9.00.1UNbZgRNvv'),
(16, '0000', 1, '01', '01', '0000.01.01.001S.07gA.00.1UNZv2JoQz', 'PAR0000123', '0000.01.25.0001.07Pp.00.1UI7SAIoQP', 60000, 12, '2017-04-01', 0, 0, 0, 0, '2017-04-01', '2018-04-01', 90, '2017-03-27', 7, '2017-05-24', '0000.01.01.0001.07g8.00.1UKn7WVg4S', 60000, '2017-04-01', 'N', NULL, '0000.01.01.001S.07g9.00.1UNZv2J0dN'),
(17, '0000', 1, '01', '01', '0000.01.01.001S.07gA.00.1UKxknVyuq', 'PAR0000123', '0000.01.25.0001.07Pp.00.1UI7SAIn11', 400000, 20, '2016-10-01', 0, 0, 0, 0, '2016-08-01', NULL, 90, '2016-11-16', 90, '2016-11-17', '0000.01.01.0001.07g8.00.1UKn7WVg4S', 400000, '2016-08-01', 'N', NULL, '0000.01.01.001S.07g9.00.1UKtyBttTB'),
(18, '0000', 1, '01', '01', '0000.01.01.0007.07gA.00.1UKxknelt3', 'PAR0000123', '0000.01.25.0001.07Pp.00.1UI7S89mix', 4000, 1, '2016-11-16', 0, 0, 0, 0, '2016-11-16', NULL, 7, '2016-11-16', NULL, NULL, '0000.01.01.0001.07g8.00.1UKn7WVg4S', 4000, '2016-11-16', 'N', NULL, '0000.01.01.001S.07g9.00.1UKxknSFnt'),
(19, '0000', 1, '01', '01', '0000.01.01.001S.07gA.00.1UNW2t2ltY', 'PAR0000123', '0000.01.25.0001.07Pp.00.1UI7S89nyR', 15000, 3, '2017-01-01', 0, 0, 0, 0, '2017-01-01', NULL, 90, '2017-01-07', NULL, NULL, '0000.01.01.0001.07g8.00.1UKn7WVg4S', 15000, '2017-01-01', 'N', NULL, '0000.01.01.001S.07g9.00.1UNW2sUNYC'),
(20, '0000', 1, '01', '01', '0000.01.01.001S.07gA.00.1UNW2t2sbN', 'PAR0000123', '0000.01.25.0001.07Pp.00.1UI7S8AgkD', 40000, 4, '2017-01-01', 0, 0, 0, 0, '2017-01-01', NULL, 90, '2017-01-07', NULL, NULL, '0000.01.01.0001.07g8.00.1UKn7WVg4S', 40000, '2017-01-01', 'N', NULL, '0000.01.01.001S.07g9.00.1UNW2sMrQd'),
(21, '0000', 1, '01', '01', '0000.01.01.001S.07gA.00.1UNW2t37YY', 'PAR0000123', '0000.01.25.0001.07Pp.00.1UI7S8Agok', 30000, 3, '2017-01-01', 0, 0, 0, 0, '2017-01-01', NULL, 90, '2017-01-07', NULL, NULL, '0000.01.01.0001.07g8.00.1UKn7WVg4S', 30000, '2017-01-01', 'N', NULL, '0000.01.01.001S.07g9.00.1UNW2sP4ra'),
(22, '0000', 1, '01', '01', '0000.01.01.001S.07gA.00.1UNW2t3AOD', 'PAR0000123', '0000.01.25.0001.07Pp.00.1UI7S89tNP', 40000, 4, '2017-01-01', 0, 0, 0, 0, '2017-01-01', NULL, 90, '2017-01-07', NULL, NULL, '0000.01.01.0001.07g8.00.1UKn7WVg4S', 40000, '2017-01-01', 'N', NULL, '0000.01.01.001S.07g9.00.1UNW2t1wkD'),
(23, '0000', 1, '01', '01', '0000.01.01.001S.07gA.00.1UNW2t3CQT', 'PAR0000123', '0000.01.25.0001.07Pp.00.1UI7S8AZvb', 62500, 2, '2017-01-01', 0, 0, 0, 0, '2017-01-01', NULL, 90, '2017-01-07', NULL, NULL, '0000.01.01.0001.07g8.00.1UKn7WVg4S', 62500, '2017-01-01', 'N', NULL, '0000.01.01.001S.07g9.00.1UNW2sTb3s'),
(24, '0000', 1, '01', '01', '0000.01.01.001S.07gA.00.1UNW2t3Gpe', 'PAR0000123', '0000.01.25.0001.07Pp.00.1UI7S89n9I', 4000, 1, '2017-01-01', 0, 0, 0, 0, '2017-01-01', NULL, 90, '2017-01-07', NULL, NULL, '0000.01.01.0001.07g8.00.1UKn7WVg4S', 4000, '2017-01-01', 'N', NULL, '0000.01.01.001S.07g9.00.1UNW2sTBg2'),
(25, '0000', 1, '01', '01', '0000.01.01.001S.07gA.00.1UNW2t3MWz', 'PAR0000123', '0000.01.25.0001.07Pp.00.1UI7S89s15', 24000, 3, '2017-01-01', 0, 0, 0, 0, '2017-01-01', NULL, 90, '2017-01-07', NULL, NULL, '0000.01.01.0001.07g8.00.1UKn7WVg4S', 24000, '2017-01-01', 'N', NULL, '0000.01.01.001S.07g9.00.1UNW2sNe0U'),
(26, '0000', 1, '01', '01', '0000.01.01.001S.07gA.00.1UNW2t3c4h', 'PAR0000123', '0000.01.25.0001.07Pp.00.1UI7S8AWrX', 12000, 3, '2017-01-01', 0, 0, 0, 0, '2017-01-01', NULL, 90, '2017-01-07', NULL, NULL, '0000.01.01.0001.07g8.00.1UKn7WVg4S', 12000, '2017-01-01', 'N', NULL, '0000.01.01.001S.07g9.00.1UNW2sShlh'),
(27, '0000', 1, '01', '01', '0000.01.01.001S.07gA.00.1UNW2t3hI2', 'PAR0000123', '0000.01.25.0001.07Pp.00.1UI7S8AVgh', 25000, 5, '2017-01-01', 0, 0, 0, 0, '2017-01-01', NULL, 90, '2017-01-07', NULL, NULL, '0000.01.01.0001.07g8.00.1UKn7WVg4S', 25000, '2017-01-01', 'N', NULL, '0000.01.01.001S.07g9.00.1UNW2sJxKw'),
(28, '0000', 1, '01', '01', '0000.01.01.001S.07gA.00.1UNW2t3kaQ', 'PAR0000123', '0000.01.25.0001.07Pp.00.1UI7S8AVuT', 20000, 4, '2017-01-01', 0, 0, 0, 0, '2017-01-01', NULL, 90, '2017-01-07', NULL, NULL, '0000.01.01.0001.07g8.00.1UKn7WVg4S', 20000, '2017-01-01', 'N', NULL, '0000.01.01.001S.07g9.00.1UNW2sRmoB'),
(29, '0000', 1, '01', '01', '0000.01.01.001S.07gA.00.1UNW2t40Wp', 'PAR0000123', '0000.01.01.0004.07Pp.00.1UKgFp8pMB', 50000, 5, '2017-01-01', 0, 0, 0, 0, '2017-01-01', NULL, 90, '2017-01-07', NULL, NULL, '0000.01.01.0001.07g8.00.1UKn7WVg4S', 50000, '2017-01-01', 'N', NULL, '0000.01.01.001S.07g9.00.1UNW2rpeY7'),
(30, '0000', 1, '01', '01', '0000.01.01.001S.07gA.00.1UNW2t45es', 'PAR0000123', '0000.01.25.0001.07Pp.00.1UI7S89pu3', 30000, 6, '2017-01-01', 0, 0, 0, 0, '2017-01-01', NULL, 90, '2017-01-07', NULL, NULL, '0000.01.01.0001.07g8.00.1UKn7WVg4S', 30000, '2017-01-01', 'N', NULL, '0000.01.01.001S.07g9.00.1UNW2sPs2U'),
(31, '0000', 1, '01', '01', '0000.01.01.001S.07gA.00.1UNXkmFGJO', 'PAR0000123', '0000.01.25.0001.07Pp.00.1UI7SAImrh', 100000, 8, '2017-02-01', 0, 0, 0, 0, '2017-02-01', NULL, 90, '2017-02-04', NULL, NULL, '0000.01.01.0001.07g8.00.1UKn7WVg4S', 100000, '2017-02-01', 'N', NULL, '0000.01.01.001S.07g9.00.1UNXkmDvaR'),
(32, '0000', 1, '01', '01', '0000.01.01.001S.07gA.00.1UNXqFUudL', 'PAR0000123', '0000.01.25.0001.07Pp.00.1UI7SAImZG', 200000, 10, '2017-02-01', 0, 0, 0, 0, '2017-02-01', NULL, 90, '2017-02-09', NULL, NULL, '0000.01.01.0001.07g8.00.1UKn7WVg4S', 200000, '2017-02-01', 'N', NULL, '0000.01.01.001S.07g9.00.1UNXqFTSpH'),
(33, '0000', 1, '01', '01', '0000.01.01.001S.07gA.00.1UNY4PD0TZ', 'PAR0000123', '0000.01.25.0001.07Pp.00.1UI7S8AfYs', 50000, 5, '2017-02-01', 0, 0, 0, 0, '2017-02-01', NULL, 90, '2017-02-22', NULL, NULL, '0000.01.01.0001.07g8.00.1UKn7WVg4S', 50000, '2017-02-01', 'N', NULL, '0000.01.01.001S.07g9.00.1UNY4PBn07'),
(34, '0000', 1, '01', '01', '0000.01.01.001S.07gA.00.1UNd8r4dre', 'PAR0000123', '0000.01.25.0001.07Pp.00.1UI7S8AeDm', 30000, 3, '2017-09-01', 0, 0, 0, 0, '2017-09-01', NULL, 90, '2017-05-10', NULL, NULL, '0000.01.01.0001.07g8.00.1UKn7WVg4S', 30000, '2017-09-01', 'N', NULL, '0000.01.01.001S.07g9.00.1UNd8r3m2C'),
(35, '0000', 1, '01', '01', '0000.01.01.001S.07gA.00.1UNf73NRrk', 'PAR0000123', '0000.01.25.0001.07Pp.00.1UI7S89kVt', 150000, 10, '2017-06-01', 0, 0, 0, 0, '2017-06-01', NULL, 90, '2017-06-22', NULL, NULL, '0000.01.01.0001.07g8.00.1UKn7WVg4S', 150000, '2017-06-01', 'N', NULL, '0000.01.01.001S.07g9.00.1UNf73MunL'),
(36, '0000', 1, '01', '01', '0000.01.01.001S.07gA.00.1UNf73NfQc', 'PAR0000123', '0000.01.25.0001.07Pp.00.1UI7S89mix', 40000, 4, '2017-07-01', 0, 0, 0, 0, '2017-07-01', NULL, 90, '2017-06-22', NULL, NULL, '0000.01.01.0001.07g8.00.1UKn7WVg4S', 40000, '2017-07-01', 'N', NULL, '0000.01.01.001S.07g9.00.1UNf73MBsF'),
(37, '0000', 1, '01', '01', '0000.01.01.001S.07gA.00.1UNf73NlAk', 'PAR0000123', '0000.01.01.0004.07Pp.00.1UKxVXAJpz', 100000, 7, '2017-06-01', 0, 0, 0, 0, '2017-06-01', NULL, 90, '2017-06-22', NULL, NULL, '0000.01.01.0001.07g8.00.1UKn7WVg4S', 100000, '2017-06-01', 'N', NULL, '0000.01.01.001S.07g9.00.1UNf73LX4c'),
(38, '0000', 1, '01', '01', '0000.01.01.001S.07gA.00.1UNeyHqjuw', 'PAR0000123', '0000.01.25.0001.07Pp.00.1UI7SAImmc', 30000, 3, '2017-06-01', 0, 0, 0, 0, '2017-06-01', NULL, 90, '2017-06-14', NULL, NULL, '0000.01.01.0001.07g8.00.1UKn7WVg4S', 30000, '2017-06-01', 'N', NULL, '0000.01.01.001S.07g9.00.1UNeyHpqWx'),
(39, '0000', 1, '01', '01', '0000.01.01.001S.07gA.00.1UNf3pdzWU', 'PAR0000123', '0000.01.25.0001.07Pp.00.1UI7S89mnC', 20000, 4, '2017-11-01', 0, 0, 0, 0, '2017-11-01', NULL, 90, '2017-06-19', NULL, NULL, '0000.01.01.0001.07g8.00.1UKn7WVg4S', 20000, '2017-11-01', 'N', NULL, '0000.01.01.001S.07g9.00.1UNf3pdDTA'),
(40, '0000', 1, '01', '01', '0000.01.01.001S.07gA.00.1UNggByg9l', 'PAR0000123', '0000.01.25.0001.07Pp.00.1UI7S8AfYs', 50000, 5, '2017-07-01', 0, 0, 0, 0, '2017-07-01', NULL, 90, '2017-07-11', NULL, NULL, '0000.01.01.0001.07g8.00.1UKn7WVg4S', 50000, '2017-07-01', 'N', NULL, '0000.01.01.001S.07g9.00.1UNggBxvYt'),
(41, '0000', 1, '01', '01', '0000.01.01.001S.07gA.00.1UNkK8bHXR', 'PAR0000123', '0000.01.25.0001.07Pp.00.1UI7S8A6bD', 50000, 5, '2017-09-01', 0, 0, 0, 0, '2017-09-01', '2018-01-31', 90, '2017-09-18', 90, '2017-09-18', '0000.01.01.0001.07g8.00.1UKn7WVg4S', 50000, '2017-09-01', 'N', NULL, '0000.01.01.001S.07g9.00.1UNkK8ahmR'),
(42, '0000', 1, '01', '01', '0000.01.01.001S.07gA.00.1UNkK8cAmD', 'PAR0000123', '0000.01.25.0001.07Pp.00.1UI7S8AJId', 15000, 3, '2017-09-01', 0, 0, 0, 0, '2017-09-01', NULL, 90, '2017-09-18', NULL, NULL, '0000.01.01.0001.07g8.00.1UKn7WVg4S', 15000, '2017-09-01', 'N', NULL, '0000.01.01.001S.07g9.00.1UNkK8bii3');

-- --------------------------------------------------------

--
-- Table structure for table `oracle_hcm_emp_lta`
--

CREATE TABLE `oracle_hcm_emp_lta` (
  `id` int(11) NOT NULL,
  `cld_id` varchar(4) DEFAULT NULL,
  `sloc_id` int(10) DEFAULT NULL,
  `ho_org_id` varchar(2) DEFAULT NULL,
  `org_id` varchar(2) DEFAULT NULL,
  `doc_id` varchar(40) DEFAULT NULL,
  `emp_code` varchar(255) DEFAULT NULL,
  `lta_id` varchar(20) DEFAULT NULL,
  `lta_year` int(10) NOT NULL,
  `lta_bal` float DEFAULT NULL,
  `lta_accrual_rate` float DEFAULT NULL,
  `valid_strt_dt` date DEFAULT NULL,
  `valid_end_dt` date DEFAULT NULL,
  `usr_id_create` varchar(255) NOT NULL,
  `usr_id_create_dt` date NOT NULL,
  `usr_id_mod` varchar(255) DEFAULT NULL,
  `usr_id_mod_dt` date DEFAULT NULL,
  `lta_op` float DEFAULT NULL,
  `prev_lta_bal` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `oracle_hcm_emp_prf`
--

CREATE TABLE `oracle_hcm_emp_prf` (
  `id` int(11) NOT NULL,
  `cld_id` varchar(255) DEFAULT NULL,
  `sloc_id` int(2) DEFAULT NULL,
  `ho_org_id` varchar(255) DEFAULT NULL,
  `org_id` varchar(255) DEFAULT NULL,
  `doc_id` varchar(255) DEFAULT NULL,
  `emp_code` int(20) DEFAULT NULL,
  `emp_id` varchar(255) NOT NULL,
  `emp_nm` varchar(255) NOT NULL,
  `emp_nm_1` varchar(255) DEFAULT NULL,
  `emp_nm_2` varchar(255) DEFAULT NULL,
  `emp_nm_3` varchar(255) DEFAULT NULL,
  `emp_nm_4` varchar(255) DEFAULT NULL,
  `emp_card_no` varchar(255) DEFAULT NULL,
  `emp_dob` date NOT NULL,
  `emp_doj` date NOT NULL,
  `emp_dept_id` varchar(255) NOT NULL,
  `emp_desg_id` varchar(255) NOT NULL,
  `emp_loc_id` varchar(255) NOT NULL,
  `emp_grp_id` varchar(255) NOT NULL,
  `wrk_stat` int(5) NOT NULL,
  `wrk_stat_dt` date NOT NULL,
  `emp_gen` varchar(255) NOT NULL,
  `emp_ded_ch` varchar(255) NOT NULL,
  `emp_perm_add` varchar(255) DEFAULT NULL,
  `emp_curr_add` varchar(255) DEFAULT NULL,
  `emp_email` varchar(255) DEFAULT NULL,
  `emp_phone1` varchar(50) DEFAULT NULL,
  `emp_phone2` varchar(50) DEFAULT NULL,
  `emp_pay_mode` int(5) DEFAULT NULL,
  `emp_bnk_id` int(20) DEFAULT NULL,
  `bnk_brnch_id` int(20) DEFAULT NULL,
  `acc_no` varchar(20) DEFAULT NULL,
  `acc_type` varchar(20) DEFAULT NULL,
  `actv_flg` varchar(1) NOT NULL,
  `usr_id_create` int(10) NOT NULL,
  `usr_id_create_dt` date NOT NULL,
  `usr_id_mod` int(10) DEFAULT NULL,
  `usr_id_mod_dt` date DEFAULT NULL,
  `ifsc_code` varchar(20) DEFAULT NULL,
  `swift_code` varchar(20) DEFAULT NULL,
  `emp_pan_no` varchar(20) DEFAULT NULL,
  `emp_eo_nm` varchar(250) DEFAULT NULL,
  `emp_guard_nm` varchar(250) DEFAULT NULL,
  `emp_rel` varchar(250) DEFAULT NULL,
  `req_area_flg` varchar(10) DEFAULT NULL,
  `spon_nm` varchar(250) DEFAULT NULL,
  `emp_mrtl_stat` int(5) DEFAULT NULL,
  `emp_nation` int(5) DEFAULT NULL,
  `mgr_doc_id` varchar(40) DEFAULT NULL,
  `mgr_code` int(20) DEFAULT NULL,
  `usr_id` int(20) DEFAULT NULL,
  `emp_ret_dt` date DEFAULT NULL,
  `emp_conf_dt` date DEFAULT NULL,
  `bnk_code` varchar(30) DEFAULT NULL,
  `emp_wrk_hours` int(3) DEFAULT NULL,
  `emp_bld_grp` int(5) DEFAULT NULL,
  `emp_notice` int(2) DEFAULT NULL,
  `emp_dol` date DEFAULT NULL,
  `lta_appli_chk` varchar(1) DEFAULT NULL,
  `sep_reason` varchar(500) DEFAULT NULL,
  `grd_id` varchar(20) DEFAULT NULL,
  `emp_ref_doc_id` varchar(40) DEFAULT NULL,
  `emp_type` int(5) DEFAULT NULL,
  `emp_probation` int(5) DEFAULT NULL,
  `emp_perm_pin` varchar(20) DEFAULT NULL,
  `emp_curr_pin` varchar(20) DEFAULT NULL,
  `lic_id` varchar(30) DEFAULT NULL,
  `kin_nm` varchar(200) DEFAULT NULL,
  `kin_phn` varchar(50) DEFAULT NULL,
  `kin_rel` varchar(50) DEFAULT NULL,
  `r_no` varchar(50) DEFAULT NULL,
  `alien_no` varchar(50) DEFAULT NULL,
  `prj_doc_id` varchar(40) DEFAULT NULL,
  `ofc_email` varchar(50) DEFAULT NULL,
  `emp_nm_ttl` int(5) DEFAULT NULL,
  `emp_bld_grp_bkup` varchar(10) DEFAULT NULL,
  `emp_status` varchar(10) DEFAULT NULL,
  `emp_wrk_loc` varchar(50) DEFAULT NULL,
  `t_emp_perm_pin` varchar(20) DEFAULT NULL,
  `t_emp_curr_pin` varchar(20) DEFAULT NULL,
  `ref_eo_id` int(20) DEFAULT NULL,
  `emp_loc_code` varchar(20) DEFAULT NULL,
  `emp_anal_code` varchar(20) DEFAULT NULL,
  `emp_anal_name` varchar(50) DEFAULT NULL,
  `emp_cc_nm` varchar(50) DEFAULT NULL,
  `emp_cc_code` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `oracle_hcm_emp_prf`
--

-- --------------------------------------------------------

--
-- Table structure for table `oracle_hcm_emp_qual`
--

CREATE TABLE `oracle_hcm_emp_qual` (
  `cld_id` varchar(4) DEFAULT NULL,
  `sloc_id` int(2) DEFAULT NULL,
  `ho_org_id` varchar(2) DEFAULT NULL,
  `org_id` varchar(4) DEFAULT NULL,
  `doc_id` varchar(40) DEFAULT NULL,
  `emp_code` int(20) DEFAULT NULL,
  `ins_nm` varchar(250) DEFAULT NULL,
  `uni_nm` varchar(250) DEFAULT NULL,
  `course_id` varchar(20) DEFAULT NULL,
  `yop` varchar(4) DEFAULT NULL,
  `mark_obtain` int(5) DEFAULT NULL,
  `usr_id_create` int(10) DEFAULT NULL,
  `usr_id_create_dt` date DEFAULT NULL,
  `usr_id_mod` int(10) DEFAULT NULL,
  `usr_id_mod_dt` date DEFAULT NULL,
  `qual_type_id` int(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `oracle_hcm_emp_sal_mon`
--

CREATE TABLE `oracle_hcm_emp_sal_mon` (
  `cld_id` varchar(20) DEFAULT NULL,
  `sloc_id` int(2) DEFAULT NULL,
  `ho_org_id` varchar(20) DEFAULT NULL,
  `org_id` varchar(20) DEFAULT NULL,
  `doc_id` varchar(255) DEFAULT NULL,
  `emp_code` int(20) DEFAULT NULL,
  `sal_id` varchar(20) DEFAULT NULL,
  `sal_val` int(26) DEFAULT NULL,
  `sal_behav` int(5) DEFAULT NULL,
  `sal_amt` int(26) DEFAULT NULL,
  `emp_dept_id` varchar(20) DEFAULT NULL,
  `emp_loc_id` varchar(20) DEFAULT NULL,
  `emp_grp_id` varchar(20) DEFAULT NULL,
  `proc_frm_dt` date DEFAULT NULL,
  `proc_to_dt` date DEFAULT NULL,
  `usr_id_create` int(10) DEFAULT NULL,
  `usr_id_create_dt` date DEFAULT NULL,
  `usr_id_mod` int(10) DEFAULT NULL,
  `usr_id_mod_dt` date DEFAULT NULL,
  `othr_ded_chk` varchar(1) DEFAULT NULL,
  `emp_doc_id` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `oracle_hcm_it_proc`
--

CREATE TABLE `oracle_hcm_it_proc` (
  `id` int(11) NOT NULL,
  `cld_id` varchar(4) DEFAULT NULL,
  `sloc_id` int(10) DEFAULT NULL,
  `ho_org_id` varchar(2) DEFAULT NULL,
  `org_id` varchar(2) DEFAULT NULL,
  `doc_id` varchar(40) DEFAULT NULL,
  `proc_frm_dt` date DEFAULT NULL,
  `proc_to_dt` date DEFAULT NULL,
  `emp_doc_id` varchar(40) DEFAULT NULL,
  `ded_doc_id` varchar(40) DEFAULT NULL,
  `ttl_earning` int(11) DEFAULT NULL,
  `encash_amt` int(11) DEFAULT NULL,
  `it_perq_amt` int(11) DEFAULT NULL,
  `grss_income` int(11) DEFAULT NULL,
  `it_invest_amt` int(11) DEFAULT NULL,
  `it_exam_amt` int(11) DEFAULT NULL,
  `profsnl_tax_amt` int(11) DEFAULT NULL,
  `sal_allow_amt` int(11) DEFAULT NULL,
  `arr_sal_allow_amt` int(11) DEFAULT NULL,
  `taxable_income` int(11) DEFAULT NULL,
  `gross_it_tax` decimal(10,2) DEFAULT NULL,
  `ded_relf_amt` int(11) DEFAULT NULL,
  `gvt_relf_amt` int(11) DEFAULT NULL,
  `oth_tax_amt` decimal(10,2) DEFAULT NULL,
  `paid_tax_amt` int(11) DEFAULT NULL,
  `ttl_tax` int(11) DEFAULT NULL,
  `fy_id` int(10) DEFAULT NULL,
  `usr_id_create` int(10) DEFAULT NULL,
  `usr_id_create_dt` date DEFAULT NULL,
  `usr_id_mod` int(10) DEFAULT NULL,
  `usr_id_mod_dt` date DEFAULT NULL,
  `pf_it_amt` int(11) DEFAULT NULL,
  `mon_tax_amt` int(11) DEFAULT NULL,
  `perq_amt` int(11) DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `oracle_org`
--

CREATE TABLE `oracle_org` (
  `id` int(10) NOT NULL,
  `org_cld_id` varchar(4) DEFAULT NULL,
  `org_id` varchar(2) DEFAULT NULL,
  `org_type` int(5) DEFAULT NULL,
  `org_desc` varchar(250) DEFAULT NULL,
  `org_alias` varchar(5) DEFAULT NULL,
  `org_id_parent` varchar(2) DEFAULT NULL,
  `org_id_parent_l0` varchar(2) DEFAULT NULL,
  `org_country_id` int(5) DEFAULT NULL,
  `org_create_ref_sloc_id` int(2) DEFAULT NULL,
  `org_curr_id_bs` int(5) DEFAULT NULL,
  `org_trf_acc` int(11) DEFAULT NULL,
  `org_fy_st_dt` date DEFAULT NULL,
  `org_doc_reset_freq` int(5) DEFAULT NULL,
  `org_active` varchar(1) DEFAULT NULL,
  `usr_id_create` int(10) DEFAULT NULL,
  `usr_id_create_dt` date DEFAULT NULL,
  `usr_id_mod` int(10) DEFAULT NULL,
  `usr_id_mod_dt` date DEFAULT NULL,
  `org_vat_no` varchar(20) DEFAULT NULL,
  `org_parent_curr_id` int(5) DEFAULT NULL,
  `org_parent_curr_conv` int(26) DEFAULT NULL,
  `org_l0_curr_id` int(5) DEFAULT NULL,
  `org_l0_curr_conv` int(26) DEFAULT NULL,
  `org_duty_adj_acc` int(22) DEFAULT NULL,
  `fd_intrst_acc` int(20) DEFAULT NULL,
  `vrt_id` varchar(10) DEFAULT NULL,
  `org_bp_id` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `oracle_org`
--
-- --------------------------------------------------------

--
-- Table structure for table `oracle_org_hcm_salary`
--

CREATE TABLE `oracle_org_hcm_salary` (
  `id` int(100) NOT NULL,
  `cld_id` varchar(4) DEFAULT NULL,
  `sloc_id` int(2) DEFAULT NULL,
  `ho_org_id` varchar(2) DEFAULT NULL,
  `org_id` varchar(2) DEFAULT NULL,
  `sal_id` varchar(20) DEFAULT NULL,
  `remarks` varchar(300) DEFAULT NULL,
  `sal_behav` int(5) DEFAULT NULL,
  `sal_paid_freq` int(5) DEFAULT NULL,
  `sal_type` varchar(1) DEFAULT 'f',
  `sal_fur_proof_ch` varchar(1) DEFAULT 'n',
  `sal_printable_ch` varchar(1) DEFAULT 'y',
  `coa_id` int(10) DEFAULT NULL,
  `valid_strt_dt` date DEFAULT NULL,
  `valid_end_dt` date DEFAULT NULL,
  `usr_id_create` int(10) DEFAULT NULL,
  `usr_id_create_dt` date DEFAULT NULL,
  `usr_id_mod` int(10) DEFAULT NULL,
  `usr_id_mod_dt` date DEFAULT NULL,
  `sal_notation` varchar(5) DEFAULT NULL,
  `othr_ded_chk` varchar(1) DEFAULT NULL,
  `seq_no` int(10) DEFAULT NULL,
  `legacy_code` varchar(20) DEFAULT NULL,
  `union_ded_chk` varchar(1) DEFAULT 'n',
  `it_exam_chk` varchar(1) DEFAULT 'n',
  `it_exam_amt` int(26) DEFAULT NULL,
  `sal_encash_chk` varchar(1) DEFAULT 'n',
  `it_exam_prf_req_chk` varchar(1) DEFAULT 'n',
  `sal_type_id` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ora_hcm_mon_nssf_ded`
--

CREATE TABLE `ora_hcm_mon_nssf_ded` (
  `cld_id` varchar(4) DEFAULT NULL,
  `sloc_id` int(2) DEFAULT NULL,
  `ho_org_id` varchar(2) DEFAULT NULL,
  `org_id` varchar(2) DEFAULT NULL,
  `emp_code` int(20) DEFAULT NULL,
  `ded_prf` int(5) DEFAULT NULL,
  `proc_frm_dt` date DEFAULT NULL,
  `proc_to_dt` date DEFAULT NULL,
  `usr_id_create` int(10) DEFAULT NULL,
  `usr_id_create_dt` date DEFAULT NULL,
  `usr_id_mod` int(10) DEFAULT NULL,
  `usr_id_mod_dt` date DEFAULT NULL,
  `emp_doc_id` varchar(40) DEFAULT NULL,
  `emp_ded_amt` int(26) DEFAULT NULL,
  `empr_ded_amt` int(26) DEFAULT NULL,
  `doc_id` varchar(40) DEFAULT NULL,
  `ded_doc_id` varchar(40) DEFAULT NULL,
  `ded_type` int(5) DEFAULT '89',
  `emp_amt` int(5) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `org_hcm_desg_prf`
--

CREATE TABLE `org_hcm_desg_prf` (
  `id` int(10) NOT NULL,
  `ho_org_id` varchar(10) NOT NULL,
  `org_id` varchar(10) NOT NULL,
  `doc_id` varchar(256) NOT NULL,
  `desg_lvl` int(10) NOT NULL,
  `created` date NOT NULL,
  `modified` date NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `org_hcm_leave`
--

CREATE TABLE `org_hcm_leave` (
  `id` int(11) NOT NULL,
  `cld_id` varchar(4) DEFAULT NULL,
  `sloc_id` int(11) DEFAULT NULL,
  `ho_org_id` varchar(2) DEFAULT NULL,
  `org_id` varchar(2) DEFAULT NULL,
  `leave_id` varchar(20) DEFAULT NULL,
  `remarks` varchar(250) DEFAULT NULL,
  `usr_id_create` int(11) DEFAULT NULL,
  `usr_id_create_dt` date DEFAULT NULL,
  `usr_id_mod` int(11) DEFAULT NULL,
  `usr_id_mod_dt` date DEFAULT NULL,
  `leave_notation` varchar(5) DEFAULT NULL,
  `auth_stat` varchar(2) DEFAULT NULL,
  `comp_off_chk` varchar(2) DEFAULT NULL,
  `absent_ded_chk` varchar(1) DEFAULT NULL,
  `leave_adj_days` float DEFAULT NULL,
  `seq_no` int(11) DEFAULT NULL,
  `leave_coa_id` int(11) DEFAULT NULL,
  `deflt_leave_chk` varchar(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `org_hcm_leave`
--

INSERT INTO `org_hcm_leave` (`id`, `cld_id`, `sloc_id`, `ho_org_id`, `org_id`, `leave_id`, `remarks`, `usr_id_create`, `usr_id_create_dt`, `usr_id_mod`, `usr_id_mod_dt`, `leave_notation`, `auth_stat`, `comp_off_chk`, `absent_ded_chk`, `leave_adj_days`, `seq_no`, `leave_coa_id`, `deflt_leave_chk`) VALUES
(1, '0000', 1, '01', '01', 'PAR0000001', NULL, 7, '2015-08-13', NULL, NULL, 'EL', 'N', 'N', 'N', 0.25, 1, NULL, NULL),
(2, '0000', 1, '01', '01', 'PAR0000002', NULL, 7, '2015-08-13', NULL, NULL, 'CL', 'N', 'N', 'N', NULL, 2, NULL, NULL),
(3, '0000', 1, '01', '01', 'PAR0000003', NULL, 7, '2015-08-13', NULL, NULL, 'SL', 'N', 'N', 'N', NULL, 3, NULL, NULL),
(4, '0000', 1, '01', '01', 'PAR0000004', NULL, 7, '2015-08-13', NULL, NULL, 'QL', 'N', 'N', 'N', NULL, 4, NULL, NULL),
(5, '0000', 1, '01', '01', 'PAR0000005', NULL, 7, '2015-08-13', NULL, NULL, 'COFF', 'N', 'Y', 'N', NULL, 5, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` int(11) NOT NULL,
  `vc_permission_name` varchar(255) DEFAULT NULL,
  `nu_application_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `vc_permission_name`, `nu_application_id`) VALUES
(1, 'ADD', 2),
(2, 'VIEW', 2),
(3, 'APPROVE', 2),
(4, 'REPORT', 2),
(12, 'ASSIGN', 16),
(13, 'VIEW', 16),
(14, 'CHECK', 16);

-- --------------------------------------------------------

--
-- Table structure for table `permissions_acos`
--

CREATE TABLE `permissions_acos` (
  `id` int(11) NOT NULL,
  `nu_permission_id` int(11) DEFAULT NULL,
  `nu_aco_id` int(11) DEFAULT NULL,
  `ch_allow` char(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `permissions_acos`
--

INSERT INTO `permissions_acos` (`id`, `nu_permission_id`, `nu_aco_id`, `ch_allow`) VALUES
(1, 1, 1296, '1'),
(2, 1, 1299, '1'),
(3, 1, 1300, '1'),
(4, 1, 1301, '1'),
(5, 1, 1302, '1'),
(6, 1, 1303, '1'),
(7, 1, 1305, '1'),
(8, 1, 1318, '1'),
(9, 1, 1319, '1'),
(10, 2, 1298, '1'),
(11, 2, 209, '1'),
(12, 2, 1303, '1'),
(13, 2, 1312, '1'),
(14, 2, 1317, '1'),
(15, 2, 1318, '1'),
(16, 3, 1315, '1'),
(17, 3, 1316, '1'),
(33, 12, 2258, '1'),
(34, 12, 2259, '1'),
(35, 13, 2269, '1'),
(36, 13, 2274, '1'),
(37, 13, 2277, '1'),
(38, 13, 2259, '1'),
(39, 13, 667, '-1'),
(40, 13, 2278, '1'),
(41, 1, 2, '1'),
(42, 1, 3, '1');

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `id` int(10) NOT NULL,
  `name` varchar(128) DEFAULT NULL,
  `Author` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`id`, `name`, `Author`) VALUES
(1, 'Handover of responsibilities  to the Reporting Manager', 'Reporting Manager'),
(2, 'Any Outstanding Dues (to be checked by Accounts)', 'Accounts Team'),
(3, 'Email id of resignee  required for a period of                          days', 'Reporting Manager'),
(4, 'Handover of Cases /responsibilities from CARE-i3 to the Reporting Manager/Functional Head and DMS upload(if applicable)\r\n', 'Reporting Manager\r\n'),
(5, 'ID Card submitted ', 'HR Team');

-- --------------------------------------------------------

--
-- Table structure for table `rating`
--

CREATE TABLE `rating` (
  `id` int(11) NOT NULL,
  `rating_name` varchar(100) NOT NULL,
  `rating_scale_from` float NOT NULL,
  `rating_scale_to` float DEFAULT NULL,
  `description` text NOT NULL,
  `status` int(1) NOT NULL,
  `ho_org_id` int(11) NOT NULL,
  `org_id` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_date` datetime NOT NULL,
  `updated_by` int(11) NOT NULL,
  `updated_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rating`
--

INSERT INTO `rating` (`id`, `rating_name`, `rating_scale_from`, `rating_scale_to`, `description`, `status`, `ho_org_id`, `org_id`, `created_by`, `created_date`, `updated_by`, `updated_date`) VALUES
(38, 'Far Exceeds Expectation (FEE)', 4.5, 5, 'Performance is clearly distinguished. Far exceeds expectations in terms of qualitative and quantitative goals. ', 1, 1, 1, 546, '2017-01-07 00:00:00', 546, '2017-01-07 00:00:00'),
(39, 'Exceeds Expectation (EE)', 3.75, 4.5, 'Consistently meets all required expectations and standards of the job.						\r\n', 1, 1, 1, 546, '2017-01-07 00:00:00', 0, '0000-00-00 00:00:00'),
(40, 'Meets Expectation (ME)	', 3, 3.75, 'Meets expectations and required standards.', 1, 1, 1, 546, '2017-01-07 00:00:00', 0, '0000-00-00 00:00:00'),
(41, 'Needs improvement (NI)', 2.5, 3, 'Meets expectations in some areas, and may not meet all expectations on certain key goals.\r\n', 1, 1, 1, 546, '2017-01-07 00:00:00', 0, '0000-00-00 00:00:00'),
(42, 'Doesnâ€™t meet expectations (DME)', 2.5, NULL, 'Few expectations are met and performance on the job in many areas is well below expected levels.', 1, 1, 1, 546, '2017-01-07 00:00:00', 0, '0000-00-00 00:00:00'),
(43, 'FE', 90, 100, 'FAR EXCEEDS-----------', 1, 1, 1, 8310, '2017-03-21 00:00:00', 0, '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `request_notification_type`
--

CREATE TABLE `request_notification_type` (
  `id` int(1) NOT NULL,
  `req_notification_type` int(1) NOT NULL,
  `req_notification_type_value` varchar(30) NOT NULL,
  `created_date` datetime NOT NULL,
  `updated_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `request_notification_type`
--

INSERT INTO `request_notification_type` (`id`, `req_notification_type`, `req_notification_type_value`, `created_date`, `updated_date`) VALUES
(1, 0, '', '2016-10-20 00:00:00', '2016-10-20 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `resignation`
--

CREATE TABLE `resignation` (
  `id` int(11) NOT NULL,
  `reason` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `resignation`
--

INSERT INTO `resignation` (`id`, `reason`) VALUES
(1, ' Better Prospects'),
(2, 'Personal'),
(3, 'Higher Studies'),
(4, 'Issues with Supervisor'),
(5, 'Compensation'),
(6, 'Health Reasons'),
(7, 'Disciplinary Grounds'),
(8, 'Absconding'),
(9, 'Termination'),
(10, 'Deceased'),
(11, 'Location'),
(12, 'Retirement');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `nu_application_id` int(11) DEFAULT NULL,
  `created` date DEFAULT NULL,
  `modified` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `nu_application_id`, `created`, `modified`) VALUES
(1, 'Employee', 2, '2016-12-06', '2016-12-06'),
(2, 'Manager', 2, '2016-12-06', '2016-12-06'),
(3, 'HR', 2, '2016-12-06', '2016-12-06'),
(7, 'Assigner', 16, '2016-12-13', '2016-12-13'),
(8, 'Viewer', 16, '2016-12-13', '2016-12-13'),
(9, 'Hawkeye', 16, '2016-12-13', '2016-12-13');

-- --------------------------------------------------------

--
-- Table structure for table `roles_permissions`
--

CREATE TABLE `roles_permissions` (
  `id` int(11) NOT NULL,
  `nu_role_id` int(11) DEFAULT NULL,
  `nu_permission_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `roles_permissions`
--

INSERT INTO `roles_permissions` (`id`, `nu_role_id`, `nu_permission_id`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 2, 1),
(4, 2, 2),
(5, 2, 3),
(6, 3, 1),
(7, 3, 2),
(8, 3, 3),
(9, 3, 4),
(19, 7, 12),
(20, 7, 13);

-- --------------------------------------------------------

--
-- Table structure for table `sect_dtl`
--

CREATE TABLE `sect_dtl` (
  `id` int(11) NOT NULL,
  `org_id` varchar(20) DEFAULT NULL,
  `cptr_id` varchar(50) DEFAULT NULL,
  `sect_id` varchar(50) DEFAULT NULL,
  `sect_max_limit` varchar(40) DEFAULT NULL,
  `valid_strt_dt` date DEFAULT NULL,
  `valid_end_dt` date DEFAULT NULL,
  `remark` varchar(255) DEFAULT NULL,
  `fy_id` int(20) NOT NULL,
  `ora_fy_id` int(10) NOT NULL,
  `ho_org_id` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `separations`
--

CREATE TABLE `separations` (
  `id` int(10) NOT NULL,
  `emp_code` int(10) DEFAULT NULL,
  `reason` varchar(128) DEFAULT NULL,
  `status` int(10) DEFAULT NULL,
  `created` date DEFAULT NULL,
  `join_date` date DEFAULT NULL,
  `dept_code` varchar(128) DEFAULT NULL,
  `desg_code` varchar(128) DEFAULT NULL,
  `remark` varchar(255) NOT NULL,
  `org_id` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Triggers `separations`
--
DELIMITER $$
CREATE TRIGGER `separations_val` AFTER UPDATE ON `separations` FOR EACH ROW if NEW.status = 5 then
IF @DISABLE_TRIGGERS IS NULL THEN
	INSERT INTO newdata VALUES (NEW.id,'separations','I');
END IF;
end if
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `separation_workflows`
--

CREATE TABLE `separation_workflows` (
  `id` int(10) NOT NULL,
  `separation_id` int(10) DEFAULT NULL,
  `emp_code` int(10) DEFAULT NULL,
  `fw_date` date DEFAULT NULL,
  `remarks` varchar(128) DEFAULT NULL,
  `approval_date` date DEFAULT NULL,
  `status` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `setup_check`
--

CREATE TABLE `setup_check` (
  `id` int(10) NOT NULL,
  `status` int(10) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `setup_check`
--

INSERT INTO `setup_check` (`id`, `status`, `name`, `email`) VALUES
(1, 1, '', '');

-- --------------------------------------------------------

--
-- Table structure for table `smtp_configuration_type`
--

CREATE TABLE `smtp_configuration_type` (
  `id` int(1) NOT NULL,
  `smtp_configuration_type` int(1) NOT NULL,
  `smtp_configuration_type_value` varchar(10) NOT NULL,
  `created_date` datetime NOT NULL,
  `updated_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `smtp_configuration_type`
--

INSERT INTO `smtp_configuration_type` (`id`, `smtp_configuration_type`, `smtp_configuration_type_value`, `created_date`, `updated_date`) VALUES
(1, 1, 'Yes', '2016-10-20 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `specl_managers`
--

CREATE TABLE `specl_managers` (
  `id` int(11) NOT NULL,
  `emp_code` int(11) DEFAULT NULL,
  `emp_name` varchar(1000) DEFAULT NULL,
  `comp_code` varchar(20) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `app_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `specl_managers`
--

INSERT INTO `specl_managers` (`id`, `emp_code`, `emp_name`, `comp_code`, `status`, `app_id`) VALUES
(1, 1537, 'Anjali Singh', '01', 1, NULL),
(2, 1539, 'D.K Srivastava', '01', 1, NULL),
(3, 1540, 'R.K Gupta', '01', 1, NULL),
(4, 1538, 'Shiv Shankar Khandelwal', '01', 1, NULL),
(5, 1543, 'Ashutosh Pachauri', '01', 1, NULL),
(6, 1541, 'G.N Prasad', '01', 1, NULL),
(7, 1544, 'Vinod Kumar Tiwari', '01', 1, NULL),
(8, 589, 'Mohit Sharad', '01', 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `states`
--

CREATE TABLE `states` (
  `id` int(11) NOT NULL,
  `state_name` varchar(30) NOT NULL,
  `country_id` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `states`
--
-- --------------------------------------------------------

--
-- Table structure for table `support_email`
--

CREATE TABLE `support_email` (
  `id` int(10) NOT NULL,
  `email` varchar(100) NOT NULL,
  `comp_code` varchar(10) NOT NULL,
  `status` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `support_email`
--

INSERT INTO `support_email` (`id`, `email`, `comp_code`, `status`) VALUES
(1, 'av@gmail.com', '01', 1),
(2, 'ayush.pant@essindia.com', '02', 1),
(3, 'av@gmail.com', '01', 0);

-- --------------------------------------------------------

--
-- Table structure for table `survey_master`
--

CREATE TABLE `survey_master` (
  `id` int(10) NOT NULL,
  `date` date NOT NULL,
  `status` int(10) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `survey_master`
--

INSERT INTO `survey_master` (`id`, `date`, `status`) VALUES
(1, '2017-04-21', 0),
(3, '0000-00-00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `survey_options`
--

CREATE TABLE `survey_options` (
  `id` int(10) NOT NULL,
  `question_id` int(10) NOT NULL,
  `option_desc` varchar(100) NOT NULL,
  `created_date` date NOT NULL,
  `status` varchar(10) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `survey_options`
--

INSERT INTO `survey_options` (`id`, `question_id`, `option_desc`, `created_date`, `status`) VALUES
(1, 1, 'Strongly  Agree', '2017-04-19', '0'),
(2, 1, 'Agree', '2017-04-19', '0'),
(3, 1, 'Neither  agree nor disagree', '2017-04-19', '0'),
(4, 1, 'Disagree', '2017-04-19', '0'),
(5, 1, 'Strongly  disagree', '2017-04-19', '0'),
(6, 1, 'Dont know/No experience', '2017-04-19', '0'),
(7, 2, 'Strongly  Agree', '2017-04-19', '0'),
(8, 2, 'Agree', '2017-04-19', '0'),
(9, 2, 'Neither  agree nor disagree', '2017-04-19', '0'),
(10, 2, 'Disagree', '2017-04-19', '0'),
(11, 2, 'Strongly  disagree', '2017-04-19', '0'),
(12, 2, 'Dont know/No experience', '2017-04-19', '0'),
(13, 3, 'Strongly  Agree', '2017-04-19', '0'),
(14, 3, 'Agree', '2017-04-19', '0'),
(15, 3, 'Neither  agree nor disagree', '2017-04-19', '0'),
(16, 3, 'Disagree', '2017-04-19', '0'),
(17, 3, 'Strongly  disagree', '2017-04-19', '0'),
(18, 3, 'Dont know/No experience', '2017-04-19', '0'),
(19, 4, 'Strongly  Agree', '2017-04-19', '0'),
(20, 4, 'Agree', '2017-04-19', '0'),
(21, 4, 'Neither  agree nor disagree', '2017-04-19', '0'),
(22, 4, 'Disagree', '2017-04-19', '0'),
(23, 4, 'Strongly  disagree', '2017-04-19', '0'),
(24, 4, 'Dont know/No experience', '2017-04-19', '0'),
(25, 5, 'Strongly  Agree', '2017-04-19', '0'),
(26, 5, 'Agree', '2017-04-19', '0'),
(27, 5, 'Neither  agree nor disagree', '2017-04-19', '0'),
(28, 5, 'Disagree', '2017-04-19', '0'),
(29, 5, 'Strongly  disagree', '2017-04-19', '0'),
(30, 5, 'Dont know/No experience', '2017-04-19', '0'),
(31, 6, 'Strongly  Agree', '2017-04-19', '0'),
(32, 6, 'Agree', '2017-04-19', '0'),
(33, 6, 'Neither  agree nor disagree', '2017-04-19', '0'),
(34, 6, 'Disagree', '2017-04-19', '0'),
(35, 6, 'Strongly  disagree', '2017-04-19', '0'),
(36, 6, 'Dont know/No experience', '2017-04-19', '0'),
(37, 7, 'Strongly  Agree', '2017-04-20', '0'),
(38, 7, 'Agree', '2017-04-20', '0'),
(39, 7, 'Neither  agree nor disagree', '2017-04-20', '0'),
(40, 7, 'Disagree', '2017-04-20', '0'),
(41, 7, 'Strongly  disagree', '2017-04-20', '0'),
(42, 7, 'Dont know/No experience', '2017-04-20', '0'),
(43, 8, 'Strongly  Agree', '2017-04-20', '0'),
(44, 8, 'Agree', '2017-04-20', '0'),
(45, 8, 'Neither  agree nor disagree', '2017-04-20', '0'),
(46, 8, 'Disagree', '2017-04-20', '0'),
(47, 8, 'Strongly  disagree', '2017-04-20', '0'),
(48, 8, 'Dont know/No experience', '2017-04-20', '0'),
(49, 9, 'Strongly  Agree', '2017-04-20', '0'),
(50, 9, 'Agree', '2017-04-20', '0'),
(51, 9, 'Neither  agree nor disagree', '2017-04-20', '0'),
(52, 9, 'Disagree', '2017-04-20', '0'),
(53, 9, 'Strongly  disagree', '2017-04-20', '0'),
(54, 9, 'Dont know/No experience', '2017-04-20', '0'),
(55, 10, 'Strongly  Agree', '2017-04-20', '0'),
(56, 10, 'Agree', '2017-04-20', '0'),
(57, 10, 'Neither  agree nor disagree', '2017-04-20', '0'),
(58, 10, 'Disagree', '2017-04-20', '0'),
(59, 10, 'Strongly  disagree', '2017-04-20', '0'),
(60, 10, 'Dont know/No experience', '2017-04-20', '0'),
(61, 11, 'Strongly  Agree', '2017-04-20', '0'),
(62, 11, 'Agree', '2017-04-20', '0'),
(63, 11, 'Neither  agree nor disagree', '2017-04-20', '0'),
(64, 11, 'Disagree', '2017-04-20', '0'),
(65, 11, 'Strongly  disagree', '2017-04-20', '0'),
(66, 11, 'Dont know/No experience', '2017-04-20', '0'),
(67, 12, 'Strongly  Agree', '2017-04-20', '0'),
(68, 12, 'Agree', '2017-04-20', '0'),
(69, 12, 'Neither  agree nor disagree', '2017-04-20', '0'),
(70, 12, 'Disagree', '2017-04-20', '0'),
(71, 12, 'Strongly  disagree', '2017-04-20', '0'),
(72, 12, 'Dont know/No experience', '2017-04-20', '0'),
(73, 13, 'Strongly  Agree', '2017-04-20', '0'),
(74, 13, 'Agree', '2017-04-20', '0'),
(75, 13, 'Neither  agree nor disagree', '2017-04-20', '0'),
(76, 13, 'Disagree', '2017-04-20', '0'),
(77, 13, 'Strongly  disagree', '2017-04-20', '0'),
(78, 13, 'Dont know/No experience', '2017-04-20', '0'),
(79, 14, 'Strongly  Agree', '2017-04-20', '0'),
(80, 14, 'Agree', '2017-04-20', '0'),
(81, 14, 'Neither  agree nor disagree', '2017-04-20', '0'),
(82, 14, 'Disagree', '2017-04-20', '0'),
(83, 14, 'Strongly  disagree', '2017-04-20', '0'),
(84, 14, 'Dont know/No experience', '2017-04-20', '0'),
(85, 15, 'Strongly  Agree', '2017-04-20', '0'),
(86, 15, 'Agree', '2017-04-20', '0'),
(87, 15, 'Neither  agree nor disagree', '2017-04-20', '0'),
(88, 15, 'Disagree', '2017-04-20', '0'),
(89, 15, 'Strongly  disagree', '2017-04-20', '0'),
(90, 15, 'Dont know/No experience', '2017-04-20', '0'),
(91, 16, 'Strongly  Agree', '2017-04-20', '0'),
(92, 16, 'Agree', '2017-04-20', '0'),
(93, 16, 'Neither  agree nor disagree', '2017-04-20', '0'),
(94, 16, 'Disagree', '2017-04-20', '0'),
(95, 16, 'Strongly  disagree', '2017-04-20', '0'),
(96, 16, 'Dont know/No experience', '2017-04-20', '0'),
(97, 17, 'Strongly  Agree', '2017-04-21', '0'),
(98, 17, 'Agree', '2017-04-21', '0'),
(99, 17, 'Neither  agree nor disagree', '2017-04-21', '0'),
(100, 17, 'Disagree', '2017-04-21', '0'),
(101, 17, 'Strongly  disagree', '2017-04-21', '0'),
(102, 17, 'Dont know/No experience', '2017-04-21', '0'),
(103, 18, 'Strongly  Agree', '2017-04-21', '0'),
(104, 18, 'Agree', '2017-04-21', '0'),
(105, 18, 'Neither  agree nor disagree', '2017-04-21', '0'),
(106, 18, 'Disagree', '2017-04-21', '0'),
(107, 18, 'Strongly  disagree', '2017-04-21', '0'),
(108, 18, 'Dont know/No experience', '2017-04-21', '0'),
(109, 19, 'Strongly  Agree', '2017-04-21', '0'),
(110, 19, 'Agree', '2017-04-21', '0'),
(111, 19, 'Neither  agree nor disagree', '2017-04-21', '0'),
(112, 19, 'Disagree', '2017-04-21', '0'),
(113, 19, 'Strongly  disagree', '2017-04-21', '0'),
(114, 19, 'Dont know/No experience', '2017-04-21', '0'),
(115, 20, 'Strongly  Agree', '2017-04-21', '0'),
(116, 20, 'Agree', '2017-04-21', '0'),
(117, 20, 'Neither  agree nor disagree', '2017-04-21', '0'),
(118, 20, 'Disagree', '2017-04-21', '0'),
(119, 20, 'Strongly  disagree', '2017-04-21', '0'),
(120, 20, 'Dont know/No experience', '2017-04-21', '0'),
(121, 21, 'Strongly  Agree', '2017-04-21', '0'),
(122, 21, 'Agree', '2017-04-21', '0'),
(123, 21, 'Neither  agree nor disagree', '2017-04-21', '0'),
(124, 21, 'Disagree', '2017-04-21', '0'),
(125, 21, 'Strongly  disagree', '2017-04-21', '0'),
(126, 21, 'Dont know/No experience', '2017-04-21', '0'),
(127, 22, 'Strongly  Agree', '2017-04-21', '0'),
(128, 22, 'Agree', '2017-04-21', '0'),
(129, 22, 'Neither  agree nor disagree', '2017-04-21', '0'),
(130, 22, 'Disagree', '2017-04-21', '0'),
(131, 22, 'Strongly  disagree', '2017-04-21', '0'),
(132, 22, 'Dont know/No experience', '2017-04-21', '0'),
(133, 23, 'Strongly  Agree', '2017-04-21', '0'),
(134, 23, 'Agree', '2017-04-21', '0'),
(135, 23, 'Neither  agree nor disagree', '2017-04-21', '0'),
(136, 23, 'Disagree', '2017-04-21', '0'),
(137, 23, 'Strongly  disagree', '2017-04-21', '0'),
(138, 23, 'Dont know/No experience', '2017-04-21', '0'),
(139, 24, 'Strongly  Agree', '2017-04-21', '0'),
(140, 24, 'Agree', '2017-04-21', '0'),
(141, 24, 'Neither  agree nor disagree', '2017-04-21', '0'),
(142, 24, 'Disagree', '2017-04-21', '0'),
(143, 24, 'Strongly  disagree', '2017-04-21', '0'),
(144, 24, 'Dont know/No experience', '2017-04-21', '0'),
(145, 25, 'Strongly  Agree', '2017-04-21', '0'),
(146, 25, 'Agree', '2017-04-21', '0'),
(147, 25, 'Neither  agree nor disagree', '2017-04-21', '0'),
(148, 25, 'Disagree', '2017-04-21', '0'),
(149, 25, 'Strongly  disagree', '2017-04-21', '0'),
(150, 25, 'Dont know/No experience', '2017-04-21', '0'),
(151, 26, 'Strongly  Agree', '2017-04-21', '0'),
(152, 26, 'Agree', '2017-04-21', '0'),
(153, 26, 'Neither  agree nor disagree', '2017-04-21', '0'),
(154, 26, 'Disagree', '2017-04-21', '0'),
(155, 26, 'Strongly  disagree', '2017-04-21', '0'),
(156, 26, 'Dont know/No experience', '2017-04-21', '0'),
(157, 27, 'Strongly  Agree', '2017-04-21', '0'),
(158, 27, 'Agree', '2017-04-21', '0'),
(159, 27, 'Neither  agree nor disagree', '2017-04-21', '0'),
(160, 27, 'Disagree', '2017-04-21', '0'),
(161, 27, 'Strongly  disagree', '2017-04-21', '0'),
(162, 27, 'Dont know/No experience', '2017-04-21', '0'),
(163, 28, 'Strongly  Agree', '2017-04-21', '0'),
(164, 28, 'Agree', '2017-04-21', '0'),
(165, 28, 'Neither  agree nor disagree', '2017-04-21', '0'),
(166, 28, 'Disagree', '2017-04-21', '0'),
(167, 28, 'Strongly  disagree', '2017-04-21', '0'),
(168, 28, 'Dont know/No experience', '2017-04-21', '0'),
(169, 29, 'Strongly  Agree', '2017-04-21', '0'),
(170, 29, 'Agree', '2017-04-21', '0'),
(171, 29, 'Neither  agree nor disagree', '2017-04-21', '0'),
(172, 29, 'Disagree', '2017-04-21', '0'),
(173, 29, 'Strongly  disagree', '2017-04-21', '0'),
(174, 29, 'Dont know/No experience', '2017-04-21', '0'),
(175, 30, 'Strongly  Agree', '2017-04-21', '0'),
(176, 30, 'Agree', '2017-04-21', '0'),
(177, 30, 'Neither  agree nor disagree', '2017-04-21', '0'),
(178, 30, 'Disagree', '2017-04-21', '0'),
(179, 30, 'Strongly  disagree', '2017-04-21', '0'),
(180, 30, 'Dont know/No experience', '2017-04-21', '0'),
(181, 31, 'Strongly  Agree', '2017-04-21', '0'),
(182, 31, 'Agree', '2017-04-21', '0'),
(183, 31, 'Neither  agree nor disagree', '2017-04-21', '0'),
(184, 31, 'Disagree', '2017-04-21', '0'),
(185, 31, 'Strongly  disagree', '2017-04-21', '0'),
(186, 31, 'Dont know/No experience', '2017-04-21', '0'),
(187, 32, 'Strongly  Agree', '2017-04-21', '0'),
(188, 32, 'Agree', '2017-04-21', '0'),
(189, 32, 'Neither  agree nor disagree', '2017-04-21', '0'),
(190, 32, 'Disagree', '2017-04-21', '0'),
(191, 32, 'Strongly  disagree', '2017-04-21', '0'),
(192, 32, 'Dont know/No experience', '2017-04-21', '0'),
(193, 33, 'Strongly  Agree', '2017-04-21', '0'),
(194, 33, 'Agree', '2017-04-21', '0'),
(195, 33, 'Neither  agree nor disagree', '2017-04-21', '0'),
(196, 33, 'Disagree', '2017-04-21', '0'),
(197, 33, 'Strongly  disagree', '2017-04-21', '0'),
(198, 33, 'Dont know/No experience', '2017-04-21', '0'),
(199, 34, 'Strongly  Agree', '2017-04-21', '0'),
(200, 34, 'Agree', '2017-04-21', '0'),
(201, 34, 'Neither  agree nor disagree', '2017-04-21', '0'),
(202, 34, 'Disagree', '2017-04-21', '0'),
(203, 34, 'Strongly  disagree', '2017-04-21', '0'),
(204, 34, 'Dont know/No experience', '2017-04-21', '0'),
(205, 35, 'Strongly  Agree', '2017-04-21', '0'),
(206, 35, 'Agree', '2017-04-21', '0'),
(207, 35, 'Neither  agree nor disagree', '2017-04-21', '0'),
(208, 35, 'Disagree', '2017-04-21', '0'),
(209, 35, 'Strongly  disagree', '2017-04-21', '0'),
(210, 35, 'Dont know/No experience', '2017-04-21', '0'),
(211, 36, 'Strongly  Agree', '2017-04-21', '0'),
(212, 36, 'Agree', '2017-04-21', '0'),
(213, 36, 'Neither  agree nor disagree', '2017-04-21', '0'),
(214, 36, 'Disagree', '2017-04-21', '0'),
(215, 36, 'Strongly  disagree', '2017-04-21', '0'),
(216, 36, 'Dont know/No experience', '2017-04-21', '0'),
(217, 37, 'Strongly  Agree', '2017-04-21', '0'),
(218, 37, 'Agree', '2017-04-21', '0'),
(219, 37, 'Neither  agree nor disagree', '2017-04-21', '0'),
(220, 37, 'Disagree', '2017-04-21', '0'),
(221, 37, 'Strongly  disagree', '2017-04-21', '0'),
(222, 37, 'Dont know/No experience', '2017-04-21', '0');

-- --------------------------------------------------------

--
-- Table structure for table `survey_parameter`
--

CREATE TABLE `survey_parameter` (
  `id` int(10) NOT NULL,
  `name` varchar(50) NOT NULL,
  `created_date` date NOT NULL,
  `status` varchar(10) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `survey_parameter`
--

INSERT INTO `survey_parameter` (`id`, `name`, `created_date`, `status`) VALUES
(1, 'Customer Focus', '0000-00-00', '0'),
(2, 'AYUSH', '0000-00-00', '1'),
(3, 'Goal &Strategy', '2017-04-19', '0'),
(4, 'Quality and Resources', '2017-04-19', '0'),
(5, ' Empowerment', '2017-04-19', '0'),
(6, 'Performance', '2017-04-19', '0'),
(7, ' Professional Growth', '2017-04-19', '0'),
(8, 'Recognition and Rewards', '2017-04-19', '0'),
(9, 'Fairness', '2017-04-19', '0'),
(10, ' Teamwork and Cooperation', '2017-04-19', '0'),
(11, 'Manager', '2017-04-19', '0'),
(12, 'Leadership', '2017-04-19', '0'),
(13, 'Satisfaction', '2017-04-19', '0'),
(14, 'Engagement', '2017-04-19', '0');

-- --------------------------------------------------------

--
-- Table structure for table `survey_question`
--

CREATE TABLE `survey_question` (
  `id` int(10) NOT NULL,
  `parameter_id` int(10) NOT NULL,
  `qsn_desc` text NOT NULL,
  `created_date` date NOT NULL,
  `status` varchar(10) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `survey_question`
--


-- --------------------------------------------------------

--
-- Table structure for table `survey_record`
--

CREATE TABLE `survey_record` (
  `id` int(11) NOT NULL,
  `parameter_id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `date` int(11) NOT NULL,
  `email_id` int(11) DEFAULT NULL,
  `dept_id` varchar(20) NOT NULL,
  `user_id` varchar(110) DEFAULT NULL,
  `user_ip` int(11) DEFAULT NULL,
  `mac_add` int(11) DEFAULT NULL,
  `option_id` int(11) NOT NULL,
  `survey_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `survey_record`
--

-- --------------------------------------------------------

--
-- Table structure for table `target`
--

CREATE TABLE `target` (
  `id` int(11) NOT NULL,
  `target_name` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `target`
--

INSERT INTO `target` (`id`, `target_name`) VALUES
(1, 'weekly'),
(2, '3 month'),
(3, '6 month'),
(4, '1 Year');

-- --------------------------------------------------------

--
-- Table structure for table `task_alert`
--

CREATE TABLE `task_alert` (
  `id` int(11) NOT NULL,
  `tid` int(11) NOT NULL,
  `sdate` date DEFAULT NULL,
  `statusid` int(11) DEFAULT NULL,
  `emp_reply` varchar(250) DEFAULT NULL,
  `comment` varchar(200) DEFAULT NULL,
  `desg_code` varchar(100) DEFAULT NULL,
  `mstatusid` varchar(20) DEFAULT NULL,
  `emp_code` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `task_alert`
--

INSERT INTO `task_alert` (`id`, `tid`, `sdate`, `statusid`, `emp_reply`, `comment`, `desg_code`, `mstatusid`, `emp_code`) VALUES
(1, 4, NULL, 1, '  Reply 1', 'Alert 1', 'PAR0000284', NULL, '12740');

-- --------------------------------------------------------

--
-- Table structure for table `task_assigns`
--

CREATE TABLE `task_assigns` (
  `id` int(11) NOT NULL,
  `tid` int(11) NOT NULL,
  `tname` varchar(30) NOT NULL,
  `assignto` varchar(150) NOT NULL,
  `tpriority` varchar(15) NOT NULL,
  `starttime` date NOT NULL,
  `endtime` date NOT NULL,
  `pid` int(11) NOT NULL,
  `mid` int(11) DEFAULT NULL,
  `remark` varchar(100) DEFAULT NULL,
  `status` varchar(20) NOT NULL,
  `fstatus` varchar(20) NOT NULL,
  `sdate` date DEFAULT NULL,
  `fsdate` date DEFAULT NULL,
  `assignby` varchar(20) DEFAULT NULL,
  `comment` varchar(200) DEFAULT NULL,
  `scomment` varchar(200) DEFAULT NULL,
  `forwardby` varchar(20) DEFAULT NULL,
  `department_id` varchar(20) DEFAULT NULL,
  `mom_related` varchar(4) DEFAULT NULL,
  `mom_id` varchar(4) DEFAULT NULL,
  `assign_by_id` int(10) NOT NULL,
  `solc_id` varchar(25) DEFAULT NULL,
  `cld_id` varchar(22) DEFAULT NULL,
  `ho_org_id` varchar(22) DEFAULT NULL,
  `org_id` varchar(22) DEFAULT NULL,
  `doc_id` varchar(52) DEFAULT NULL,
  `ticket_id` int(10) DEFAULT NULL,
  `ticket_type` varchar(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `task_assign_emp`
--

CREATE TABLE `task_assign_emp` (
  `id` int(11) NOT NULL,
  `tid` int(11) NOT NULL,
  `emp_code` varchar(50) NOT NULL,
  `cstatus` int(10) DEFAULT '0',
  `statusid` varchar(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `task_project`
--

CREATE TABLE `task_project` (
  `pid` int(11) NOT NULL,
  `pname` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `task_project_module`
--

CREATE TABLE `task_project_module` (
  `mid` int(11) NOT NULL,
  `pid` int(11) NOT NULL,
  `mname` varchar(30) NOT NULL,
  `status` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `temp_workflow`
--

CREATE TABLE `temp_workflow` (
  `id` int(10) NOT NULL,
  `employee_sal_mon_id` int(10) NOT NULL,
  `emp_code` int(10) NOT NULL,
  `temp_status` int(10) DEFAULT NULL,
  `fw_date` date DEFAULT NULL,
  `remark` varchar(255) DEFAULT NULL,
  `approve_date` date DEFAULT NULL,
  `voucher_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ticker`
--

CREATE TABLE `ticker` (
  `id` int(20) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `status` int(10) DEFAULT NULL,
  `department_id` int(11) NOT NULL,
  `function_name` varchar(50) NOT NULL,
  `solc_id` varchar(25) DEFAULT NULL,
  `cld_id` varchar(22) DEFAULT NULL,
  `ho_org_id` varchar(22) DEFAULT NULL,
  `org_id` varchar(22) DEFAULT NULL,
  `doc_id` varchar(52) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ticker`
--

INSERT INTO `ticker` (`id`, `name`, `status`, `department_id`, `function_name`, `solc_id`, `cld_id`, `ho_org_id`, `org_id`, `doc_id`) VALUES
(1, 'Total Leave', 1, 1, 'totalLeave', NULL, NULL, NULL, NULL, NULL),
(2, 'Travel Voucher Applied', 1, 1, 'travelVoucherApplied', NULL, NULL, NULL, NULL, NULL),
(3, 'Appraisal', 1, 1, 'totAppraisal', NULL, NULL, NULL, NULL, NULL),
(4, 'Leave Pending', 1, 1, 'leavePen', NULL, NULL, NULL, NULL, NULL),
(5, 'Travel Voucher Pending', 0, 1, 'travelPen', NULL, NULL, NULL, NULL, NULL),
(6, 'Training', 0, 1, 'totTraining', NULL, NULL, NULL, NULL, NULL),
(7, 'Total Leave', 1, 2, 'totalLeave', NULL, NULL, NULL, NULL, NULL),
(8, 'Travel Voucher Applied', 1, 2, 'travelVoucherApplied', NULL, NULL, NULL, NULL, NULL),
(9, 'Appraisal', 1, 2, 'totAppraisal', NULL, NULL, NULL, NULL, NULL),
(10, 'Leave Pending', 1, 2, 'leavePen', NULL, NULL, NULL, NULL, NULL),
(11, 'Travel Voucher Pending', 0, 2, 'travelPen', NULL, NULL, NULL, NULL, NULL),
(12, 'Training', 0, 2, 'totTraining', NULL, NULL, NULL, NULL, NULL),
(13, 'Total Leave', 1, 3, 'totalLeave', NULL, NULL, NULL, NULL, NULL),
(14, 'Travel Voucher Applied', 1, 3, 'travelVoucherApplied', NULL, NULL, NULL, NULL, NULL),
(15, 'Appraisal', 1, 3, 'totAppraisal', NULL, NULL, NULL, NULL, NULL),
(16, 'Leave Pending', 1, 3, 'leavePen', NULL, NULL, NULL, NULL, NULL),
(17, 'Travel Voucher Pending', 0, 3, 'travelPen', NULL, NULL, NULL, NULL, NULL),
(18, 'Training', 0, 3, 'totTraining', NULL, NULL, NULL, NULL, NULL),
(19, 'Total Leave', 1, 4, 'totalLeave', NULL, NULL, NULL, NULL, NULL),
(20, 'Travel Voucher Applied', 1, 4, 'travelVoucherApplied', NULL, NULL, NULL, NULL, NULL),
(21, 'Appraisal', 1, 4, 'totAppraisal', NULL, NULL, NULL, NULL, NULL),
(22, 'Leave Pending', 1, 4, 'leavePen', NULL, NULL, NULL, NULL, NULL),
(23, 'Travel Voucher Pending', 0, 4, 'travelPen', NULL, NULL, NULL, NULL, NULL),
(24, 'Training', 0, 4, 'totTraining', NULL, NULL, NULL, NULL, NULL),
(25, 'Total Leave', 1, 5, 'totalLeave', NULL, NULL, NULL, NULL, NULL),
(26, 'Travel Voucher Applied', 1, 5, 'travelVoucherApplied', NULL, NULL, NULL, NULL, NULL),
(27, 'Appraisal', 1, 5, 'totAppraisal', NULL, NULL, NULL, NULL, NULL),
(28, 'Leave Pending', 1, 5, 'leavePen', NULL, NULL, NULL, NULL, NULL),
(29, 'Travel Voucher Pending', 0, 5, 'travelPen', NULL, NULL, NULL, NULL, NULL),
(30, 'Training', 0, 5, 'totTraining', NULL, NULL, NULL, NULL, NULL),
(31, 'Total Leave', 1, 6, 'totalLeave', NULL, NULL, NULL, NULL, NULL),
(32, 'Travel Voucher Applied', 1, 6, 'travelVoucherApplied', NULL, NULL, NULL, NULL, NULL),
(33, 'Appraisal', 1, 6, 'totAppraisal', NULL, NULL, NULL, NULL, NULL),
(34, 'Leave Pending', 1, 6, 'leavePen', NULL, NULL, NULL, NULL, NULL),
(35, 'Travel Voucher Pending', 0, 6, 'travelPen', NULL, NULL, NULL, NULL, NULL),
(36, 'Training', 0, 6, 'totTraining', NULL, NULL, NULL, NULL, NULL),
(37, 'Total Leave', 1, 7, 'totalLeave', NULL, NULL, NULL, NULL, NULL),
(38, 'Travel Voucher Applied', 1, 7, 'travelVoucherApplied', NULL, NULL, NULL, NULL, NULL),
(39, 'Appraisal', 1, 7, 'totAppraisal', NULL, NULL, NULL, NULL, NULL),
(40, 'Leave Pending', 1, 7, 'leavePen', NULL, NULL, NULL, NULL, NULL),
(41, 'Travel Voucher Pending', 0, 7, 'travelPen', NULL, NULL, NULL, NULL, NULL),
(42, 'Training', 0, 7, 'totTraining', NULL, NULL, NULL, NULL, NULL),
(43, 'Total Leave', 1, 8, 'totalLeave', NULL, NULL, NULL, NULL, NULL),
(44, 'Travel Voucher Applied', 1, 8, 'travelVoucherApplied', NULL, NULL, NULL, NULL, NULL),
(45, 'Appraisal', 1, 8, 'totAppraisal', NULL, NULL, NULL, NULL, NULL),
(46, 'Leave Pending', 1, 8, 'leavePen', NULL, NULL, NULL, NULL, NULL),
(47, 'Travel Voucher Pending', 0, 8, 'travelPen', NULL, NULL, NULL, NULL, NULL),
(48, 'Training', 0, 8, 'totTraining', NULL, NULL, NULL, NULL, NULL),
(49, 'Total Leave', 1, 9, 'totalLeave', NULL, NULL, NULL, NULL, NULL),
(50, 'Travel Voucher Applied', 1, 9, 'travelVoucherApplied', NULL, NULL, NULL, NULL, NULL),
(51, 'Appraisal', 1, 9, 'totAppraisal', NULL, NULL, NULL, NULL, NULL),
(52, 'Leave Pending', 1, 9, 'leavePen', NULL, NULL, NULL, NULL, NULL),
(53, 'Travel Voucher Pending', 0, 9, 'travelPen', NULL, NULL, NULL, NULL, NULL),
(54, 'Training', 0, 9, 'totTraining', NULL, NULL, NULL, NULL, NULL),
(55, 'Total Leave', 1, 10, 'totalLeave', NULL, NULL, NULL, NULL, NULL),
(56, 'Travel Voucher Applied', 1, 10, 'travelVoucherApplied', NULL, NULL, NULL, NULL, NULL),
(57, 'Appraisal', 1, 10, 'totAppraisal', NULL, NULL, NULL, NULL, NULL),
(58, 'Leave Pending', 1, 10, 'leavePen', NULL, NULL, NULL, NULL, NULL),
(59, 'Travel Voucher Pending', 0, 10, 'travelPen', NULL, NULL, NULL, NULL, NULL),
(60, 'Training', 0, 10, 'totTraining', NULL, NULL, NULL, NULL, NULL),
(61, 'Total Leave', 1, 11, 'totalLeave', NULL, NULL, NULL, NULL, NULL),
(62, 'Travel Voucher Applied', 1, 11, 'travelVoucherApplied', NULL, NULL, NULL, NULL, NULL),
(63, 'Appraisal', 1, 11, 'totAppraisal', NULL, NULL, NULL, NULL, NULL),
(64, 'Leave Pending', 1, 11, 'leavePen', NULL, NULL, NULL, NULL, NULL),
(65, 'Travel Voucher Pending', 0, 11, 'travelPen', NULL, NULL, NULL, NULL, NULL),
(66, 'Training', 0, 11, 'totTraining', NULL, NULL, NULL, NULL, NULL),
(67, 'Total Leave', 1, 12, 'totalLeave', NULL, NULL, NULL, NULL, NULL),
(68, 'Travel Voucher Applied', 1, 12, 'travelVoucherApplied', NULL, NULL, NULL, NULL, NULL),
(69, 'Appraisal', 1, 12, 'totAppraisal', NULL, NULL, NULL, NULL, NULL),
(70, 'Leave Pending', 1, 12, 'leavePen', NULL, NULL, NULL, NULL, NULL),
(71, 'Travel Voucher Pending', 0, 12, 'travelPen', NULL, NULL, NULL, NULL, NULL),
(72, 'Training', 0, 12, 'totTraining', NULL, NULL, NULL, NULL, NULL),
(73, 'Total Leave', 1, 13, 'totalLeave', NULL, NULL, NULL, NULL, NULL),
(74, 'Travel Voucher Applied', 1, 13, 'travelVoucherApplied', NULL, NULL, NULL, NULL, NULL),
(75, 'Appraisal', 1, 13, 'totAppraisal', NULL, NULL, NULL, NULL, NULL),
(76, 'Leave Pending', 1, 13, 'leavePen', NULL, NULL, NULL, NULL, NULL),
(77, 'Travel Voucher Pending', 0, 13, 'travelPen', NULL, NULL, NULL, NULL, NULL),
(78, 'Training', 0, 13, 'totTraining', NULL, NULL, NULL, NULL, NULL),
(79, 'Total Leave', 1, 14, 'totalLeave', NULL, NULL, NULL, NULL, NULL),
(80, 'Travel Voucher Applied', 1, 14, 'travelVoucherApplied', NULL, NULL, NULL, NULL, NULL),
(81, 'Appraisal', 1, 14, 'totAppraisal', NULL, NULL, NULL, NULL, NULL),
(82, 'Leave Pending', 1, 14, 'leavePen', NULL, NULL, NULL, NULL, NULL),
(83, 'Travel Voucher Pending', 0, 14, 'travelPen', NULL, NULL, NULL, NULL, NULL),
(84, 'Training', 0, 14, 'totTraining', NULL, NULL, NULL, NULL, NULL),
(85, 'Total Leave', 1, 15, 'totalLeave', NULL, NULL, NULL, NULL, NULL),
(86, 'Travel Voucher Applied', 1, 15, 'travelVoucherApplied', NULL, NULL, NULL, NULL, NULL),
(87, 'Appraisal', 1, 15, 'totAppraisal', NULL, NULL, NULL, NULL, NULL),
(88, 'Leave Pending', 1, 15, 'leavePen', NULL, NULL, NULL, NULL, NULL),
(89, 'Travel Voucher Pending', 0, 15, 'travelPen', NULL, NULL, NULL, NULL, NULL),
(90, 'Training', 0, 15, 'totTraining', NULL, NULL, NULL, NULL, NULL),
(91, 'Total Leave', 1, 16, 'totalLeave', NULL, NULL, NULL, NULL, NULL),
(92, 'Travel Voucher Applied', 1, 16, 'travelVoucherApplied', NULL, NULL, NULL, NULL, NULL),
(93, 'Appraisal', 1, 16, 'totAppraisal', NULL, NULL, NULL, NULL, NULL),
(94, 'Leave Pending', 1, 16, 'leavePen', NULL, NULL, NULL, NULL, NULL),
(95, 'Travel Voucher Pending', 0, 16, 'travelPen', NULL, NULL, NULL, NULL, NULL),
(96, 'Training', 0, 16, 'totTraining', NULL, NULL, NULL, NULL, NULL),
(97, 'Total Leave', 1, 17, 'totalLeave', NULL, NULL, NULL, NULL, NULL),
(98, 'Travel Voucher Applied', 1, 17, 'travelVoucherApplied', NULL, NULL, NULL, NULL, NULL),
(99, 'Appraisal', 1, 17, 'totAppraisal', NULL, NULL, NULL, NULL, NULL),
(100, 'Leave Pending', 1, 17, 'leavePen', NULL, NULL, NULL, NULL, NULL),
(101, 'Travel Voucher Pending', 0, 17, 'travelPen', NULL, NULL, NULL, NULL, NULL),
(102, 'Training', 0, 17, 'totTraining', NULL, NULL, NULL, NULL, NULL),
(103, 'Total Leave', 1, 18, 'totalLeave', NULL, NULL, NULL, NULL, NULL),
(104, 'Travel Voucher Applied', 1, 18, 'travelVoucherApplied', NULL, NULL, NULL, NULL, NULL),
(105, 'Appraisal', 1, 18, 'totAppraisal', NULL, NULL, NULL, NULL, NULL),
(106, 'Leave Pending', 1, 18, 'leavePen', NULL, NULL, NULL, NULL, NULL),
(107, 'Travel Voucher Pending', 0, 18, 'travelPen', NULL, NULL, NULL, NULL, NULL),
(108, 'Training', 0, 18, 'totTraining', NULL, NULL, NULL, NULL, NULL),
(109, 'Total Leave', 1, 19, 'totalLeave', NULL, NULL, NULL, NULL, NULL),
(110, 'Travel Voucher Applied', 1, 19, 'travelVoucherApplied', NULL, NULL, NULL, NULL, NULL),
(111, 'Appraisal', 1, 19, 'totAppraisal', NULL, NULL, NULL, NULL, NULL),
(112, 'Leave Pending', 1, 19, 'leavePen', NULL, NULL, NULL, NULL, NULL),
(113, 'Travel Voucher Pending', 0, 19, 'travelPen', NULL, NULL, NULL, NULL, NULL),
(114, 'Training', 0, 19, 'totTraining', NULL, NULL, NULL, NULL, NULL),
(115, 'Total Leave', 1, 20, 'totalLeave', NULL, NULL, NULL, NULL, NULL),
(116, 'Travel Voucher Applied', 1, 20, 'travelVoucherApplied', NULL, NULL, NULL, NULL, NULL),
(117, 'Appraisal', 1, 20, 'totAppraisal', NULL, NULL, NULL, NULL, NULL),
(118, 'Leave Pending', 1, 20, 'leavePen', NULL, NULL, NULL, NULL, NULL),
(119, 'Travel Voucher Pending', 0, 20, 'travelPen', NULL, NULL, NULL, NULL, NULL),
(120, 'Training', 0, 20, 'totTraining', NULL, NULL, NULL, NULL, NULL),
(121, 'Total Leave', 1, 21, 'totalLeave', NULL, NULL, NULL, NULL, NULL),
(122, 'Travel Voucher Applied', 1, 21, 'travelVoucherApplied', NULL, NULL, NULL, NULL, NULL),
(123, 'Appraisal', 1, 21, 'totAppraisal', NULL, NULL, NULL, NULL, NULL),
(124, 'Leave Pending', 1, 21, 'leavePen', NULL, NULL, NULL, NULL, NULL),
(125, 'Travel Voucher Pending', 0, 21, 'travelPen', NULL, NULL, NULL, NULL, NULL),
(126, 'Training', 0, 21, 'totTraining', NULL, NULL, NULL, NULL, NULL),
(127, 'Total Leave', 1, 22, 'totalLeave', NULL, NULL, NULL, NULL, NULL),
(128, 'Travel Voucher Applied', 1, 22, 'travelVoucherApplied', NULL, NULL, NULL, NULL, NULL),
(129, 'Appraisal', 1, 22, 'totAppraisal', NULL, NULL, NULL, NULL, NULL),
(130, 'Leave Pending', 1, 22, 'leavePen', NULL, NULL, NULL, NULL, NULL),
(131, 'Travel Voucher Pending', 0, 22, 'travelPen', NULL, NULL, NULL, NULL, NULL),
(132, 'Training', 0, 22, 'totTraining', NULL, NULL, NULL, NULL, NULL),
(133, 'Total Leave', 1, 23, 'totalLeave', NULL, NULL, NULL, NULL, NULL),
(134, 'Travel Voucher Applied', 1, 23, 'travelVoucherApplied', NULL, NULL, NULL, NULL, NULL),
(135, 'Appraisal', 1, 23, 'totAppraisal', NULL, NULL, NULL, NULL, NULL),
(136, 'Leave Pending', 1, 23, 'leavePen', NULL, NULL, NULL, NULL, NULL),
(137, 'Travel Voucher Pending', 0, 23, 'travelPen', NULL, NULL, NULL, NULL, NULL),
(138, 'Training', 0, 23, 'totTraining', NULL, NULL, NULL, NULL, NULL),
(139, 'Total Leave', 1, 24, 'totalLeave', NULL, NULL, NULL, NULL, NULL),
(140, 'Travel Voucher Applied', 1, 24, 'travelVoucherApplied', NULL, NULL, NULL, NULL, NULL),
(141, 'Appraisal', 1, 24, 'totAppraisal', NULL, NULL, NULL, NULL, NULL),
(142, 'Leave Pending', 1, 24, 'leavePen', NULL, NULL, NULL, NULL, NULL),
(143, 'Travel Voucher Pending', 0, 24, 'travelPen', NULL, NULL, NULL, NULL, NULL),
(144, 'Training', 0, 24, 'totTraining', NULL, NULL, NULL, NULL, NULL),
(145, 'Total Leave', 1, 25, 'totalLeave', NULL, NULL, NULL, NULL, NULL),
(146, 'Travel Voucher Applied', 1, 25, 'travelVoucherApplied', NULL, NULL, NULL, NULL, NULL),
(147, 'Appraisal', 1, 25, 'totAppraisal', NULL, NULL, NULL, NULL, NULL),
(148, 'Leave Pending', 1, 25, 'leavePen', NULL, NULL, NULL, NULL, NULL),
(149, 'Travel Voucher Pending', 0, 25, 'travelPen', NULL, NULL, NULL, NULL, NULL),
(150, 'Training', 0, 25, 'totTraining', NULL, NULL, NULL, NULL, NULL),
(151, 'Total Leave', 1, 26, 'totalLeave', NULL, NULL, NULL, NULL, NULL),
(152, 'Travel Voucher Applied', 1, 26, 'travelVoucherApplied', NULL, NULL, NULL, NULL, NULL),
(153, 'Appraisal', 1, 26, 'totAppraisal', NULL, NULL, NULL, NULL, NULL),
(154, 'Leave Pending', 1, 26, 'leavePen', NULL, NULL, NULL, NULL, NULL),
(155, 'Travel Voucher Pending', 0, 26, 'travelPen', NULL, NULL, NULL, NULL, NULL),
(156, 'Training', 0, 26, 'totTraining', NULL, NULL, NULL, NULL, NULL),
(157, 'Total Leave', 1, 27, 'totalLeave', NULL, NULL, NULL, NULL, NULL),
(158, 'Travel Voucher Applied', 1, 27, 'travelVoucherApplied', NULL, NULL, NULL, NULL, NULL),
(159, 'Appraisal', 1, 27, 'totAppraisal', NULL, NULL, NULL, NULL, NULL),
(160, 'Leave Pending', 1, 27, 'leavePen', NULL, NULL, NULL, NULL, NULL),
(161, 'Travel Voucher Pending', 0, 27, 'travelPen', NULL, NULL, NULL, NULL, NULL),
(162, 'Training', 0, 27, 'totTraining', NULL, NULL, NULL, NULL, NULL),
(163, 'Total Leave', 1, 28, 'totalLeave', NULL, NULL, NULL, NULL, NULL),
(164, 'Travel Voucher Applied', 1, 28, 'travelVoucherApplied', NULL, NULL, NULL, NULL, NULL),
(165, 'Appraisal', 1, 28, 'totAppraisal', NULL, NULL, NULL, NULL, NULL),
(166, 'Leave Pending', 1, 28, 'leavePen', NULL, NULL, NULL, NULL, NULL),
(167, 'Travel Voucher Pending', 0, 28, 'travelPen', NULL, NULL, NULL, NULL, NULL),
(168, 'Training', 0, 28, 'totTraining', NULL, NULL, NULL, NULL, NULL),
(169, 'Total Leave', 1, 29, 'totalLeave', NULL, NULL, NULL, NULL, NULL),
(170, 'Travel Voucher Applied', 1, 29, 'travelVoucherApplied', NULL, NULL, NULL, NULL, NULL),
(171, 'Appraisal', 1, 29, 'totAppraisal', NULL, NULL, NULL, NULL, NULL),
(172, 'Leave Pending', 1, 29, 'leavePen', NULL, NULL, NULL, NULL, NULL),
(173, 'Travel Voucher Pending', 0, 29, 'travelPen', NULL, NULL, NULL, NULL, NULL),
(174, 'Training', 0, 29, 'totTraining', NULL, NULL, NULL, NULL, NULL),
(175, 'Total Leave', 1, 30, 'totalLeave', NULL, NULL, NULL, NULL, NULL),
(176, 'Travel Voucher Applied', 1, 30, 'travelVoucherApplied', NULL, NULL, NULL, NULL, NULL),
(177, 'Appraisal', 1, 30, 'totAppraisal', NULL, NULL, NULL, NULL, NULL),
(178, 'Leave Pending', 1, 30, 'leavePen', NULL, NULL, NULL, NULL, NULL),
(179, 'Travel Voucher Pending', 0, 30, 'travelPen', NULL, NULL, NULL, NULL, NULL),
(180, 'Training', 0, 30, 'totTraining', NULL, NULL, NULL, NULL, NULL),
(181, 'Total Leave', 1, 31, 'totalLeave', NULL, NULL, NULL, NULL, NULL),
(182, 'Travel Voucher Applied', 1, 31, 'travelVoucherApplied', NULL, NULL, NULL, NULL, NULL),
(183, 'Appraisal', 1, 31, 'totAppraisal', NULL, NULL, NULL, NULL, NULL),
(184, 'Leave Pending', 1, 31, 'leavePen', NULL, NULL, NULL, NULL, NULL),
(185, 'Travel Voucher Pending', 0, 31, 'travelPen', NULL, NULL, NULL, NULL, NULL),
(186, 'Training', 0, 31, 'totTraining', NULL, NULL, NULL, NULL, NULL),
(187, 'Total Leave', 1, 32, 'totalLeave', NULL, NULL, NULL, NULL, NULL),
(188, 'Travel Voucher Applied', 1, 32, 'travelVoucherApplied', NULL, NULL, NULL, NULL, NULL),
(189, 'Appraisal', 1, 32, 'totAppraisal', NULL, NULL, NULL, NULL, NULL),
(190, 'Leave Pending', 1, 32, 'leavePen', NULL, NULL, NULL, NULL, NULL),
(191, 'Travel Voucher Pending', 0, 32, 'travelPen', NULL, NULL, NULL, NULL, NULL),
(192, 'Training', 0, 32, 'totTraining', NULL, NULL, NULL, NULL, NULL),
(193, 'Total Leave', 1, 33, 'totalLeave', NULL, NULL, NULL, NULL, NULL),
(194, 'Travel Voucher Applied', 1, 33, 'travelVoucherApplied', NULL, NULL, NULL, NULL, NULL),
(195, 'Appraisal', 1, 33, 'totAppraisal', NULL, NULL, NULL, NULL, NULL),
(196, 'Leave Pending', 1, 33, 'leavePen', NULL, NULL, NULL, NULL, NULL),
(197, 'Travel Voucher Pending', 0, 33, 'travelPen', NULL, NULL, NULL, NULL, NULL),
(198, 'Training', 0, 33, 'totTraining', NULL, NULL, NULL, NULL, NULL),
(199, 'Total Leave', 1, 34, 'totalLeave', NULL, NULL, NULL, NULL, NULL),
(200, 'Travel Voucher Applied', 1, 34, 'travelVoucherApplied', NULL, NULL, NULL, NULL, NULL),
(201, 'Appraisal', 1, 34, 'totAppraisal', NULL, NULL, NULL, NULL, NULL),
(202, 'Leave Pending', 1, 34, 'leavePen', NULL, NULL, NULL, NULL, NULL),
(203, 'Travel Voucher Pending', 0, 34, 'travelPen', NULL, NULL, NULL, NULL, NULL),
(204, 'Training', 0, 34, 'totTraining', NULL, NULL, NULL, NULL, NULL),
(205, 'Total Leave', 1, 35, 'totalLeave', NULL, NULL, NULL, NULL, NULL),
(206, 'Travel Voucher Applied', 1, 35, 'travelVoucherApplied', NULL, NULL, NULL, NULL, NULL),
(207, 'Appraisal', 1, 35, 'totAppraisal', NULL, NULL, NULL, NULL, NULL),
(208, 'Leave Pending', 1, 35, 'leavePen', NULL, NULL, NULL, NULL, NULL),
(209, 'Travel Voucher Pending', 0, 35, 'travelPen', NULL, NULL, NULL, NULL, NULL),
(210, 'Training', 0, 35, 'totTraining', NULL, NULL, NULL, NULL, NULL),
(211, 'Total Leave', 1, 36, 'totalLeave', NULL, NULL, NULL, NULL, NULL),
(212, 'Travel Voucher Applied', 1, 36, 'travelVoucherApplied', NULL, NULL, NULL, NULL, NULL),
(213, 'Appraisal', 1, 36, 'totAppraisal', NULL, NULL, NULL, NULL, NULL),
(214, 'Leave Pending', 1, 36, 'leavePen', NULL, NULL, NULL, NULL, NULL),
(215, 'Travel Voucher Pending', 0, 36, 'travelPen', NULL, NULL, NULL, NULL, NULL),
(216, 'Training', 0, 36, 'totTraining', NULL, NULL, NULL, NULL, NULL),
(217, 'Total Leave', 1, 37, 'totalLeave', NULL, NULL, NULL, NULL, NULL),
(218, 'Travel Voucher Applied', 1, 37, 'travelVoucherApplied', NULL, NULL, NULL, NULL, NULL),
(219, 'Appraisal', 1, 37, 'totAppraisal', NULL, NULL, NULL, NULL, NULL),
(220, 'Leave Pending', 1, 37, 'leavePen', NULL, NULL, NULL, NULL, NULL),
(221, 'Travel Voucher Pending', 0, 37, 'travelPen', NULL, NULL, NULL, NULL, NULL),
(222, 'Training', 0, 37, 'totTraining', NULL, NULL, NULL, NULL, NULL),
(223, 'Total Leave', 1, 38, 'totalLeave', NULL, NULL, NULL, NULL, NULL),
(224, 'Travel Voucher Applied', 1, 38, 'travelVoucherApplied', NULL, NULL, NULL, NULL, NULL),
(225, 'Appraisal', 1, 38, 'totAppraisal', NULL, NULL, NULL, NULL, NULL),
(226, 'Leave Pending', 1, 38, 'leavePen', NULL, NULL, NULL, NULL, NULL),
(227, 'Travel Voucher Pending', 0, 38, 'travelPen', NULL, NULL, NULL, NULL, NULL),
(228, 'Training', 0, 38, 'totTraining', NULL, NULL, NULL, NULL, NULL),
(229, 'Total Leave', 1, 39, 'totalLeave', NULL, NULL, NULL, NULL, NULL),
(230, 'Travel Voucher Applied', 1, 39, 'travelVoucherApplied', NULL, NULL, NULL, NULL, NULL),
(231, 'Appraisal', 1, 39, 'totAppraisal', NULL, NULL, NULL, NULL, NULL),
(232, 'Leave Pending', 1, 39, 'leavePen', NULL, NULL, NULL, NULL, NULL),
(233, 'Travel Voucher Pending', 0, 39, 'travelPen', NULL, NULL, NULL, NULL, NULL),
(234, 'Training', 0, 39, 'totTraining', NULL, NULL, NULL, NULL, NULL),
(235, 'Total Leave', 1, 40, 'totalLeave', NULL, NULL, NULL, NULL, NULL),
(236, 'Travel Voucher Applied', 1, 40, 'travelVoucherApplied', NULL, NULL, NULL, NULL, NULL),
(237, 'Appraisal', 1, 40, 'totAppraisal', NULL, NULL, NULL, NULL, NULL),
(238, 'Leave Pending', 1, 40, 'leavePen', NULL, NULL, NULL, NULL, NULL),
(239, 'Travel Voucher Pending', 0, 40, 'travelPen', NULL, NULL, NULL, NULL, NULL),
(240, 'Training', 0, 40, 'totTraining', NULL, NULL, NULL, NULL, NULL),
(241, 'Total Leave', 1, 41, 'totalLeave', NULL, NULL, NULL, NULL, NULL),
(242, 'Travel Voucher Applied', 1, 41, 'travelVoucherApplied', NULL, NULL, NULL, NULL, NULL),
(243, 'Appraisal', 1, 41, 'totAppraisal', NULL, NULL, NULL, NULL, NULL),
(244, 'Leave Pending', 1, 41, 'leavePen', NULL, NULL, NULL, NULL, NULL),
(245, 'Travel Voucher Pending', 0, 41, 'travelPen', NULL, NULL, NULL, NULL, NULL),
(246, 'Training', 0, 41, 'totTraining', NULL, NULL, NULL, NULL, NULL),
(247, 'Total Leave', 1, 42, 'totalLeave', NULL, NULL, NULL, NULL, NULL),
(248, 'Travel Voucher Applied', 1, 42, 'travelVoucherApplied', NULL, NULL, NULL, NULL, NULL),
(249, 'Appraisal', 1, 42, 'totAppraisal', NULL, NULL, NULL, NULL, NULL),
(250, 'Leave Pending', 1, 42, 'leavePen', NULL, NULL, NULL, NULL, NULL),
(251, 'Travel Voucher Pending', 0, 42, 'travelPen', NULL, NULL, NULL, NULL, NULL),
(252, 'Training', 0, 42, 'totTraining', NULL, NULL, NULL, NULL, NULL),
(253, 'Total Leave', 1, 43, 'totalLeave', NULL, NULL, NULL, NULL, NULL),
(254, 'Travel Voucher Applied', 1, 43, 'travelVoucherApplied', NULL, NULL, NULL, NULL, NULL),
(255, 'Appraisal', 1, 43, 'totAppraisal', NULL, NULL, NULL, NULL, NULL),
(256, 'Leave Pending', 1, 43, 'leavePen', NULL, NULL, NULL, NULL, NULL),
(257, 'Travel Voucher Pending', 0, 43, 'travelPen', NULL, NULL, NULL, NULL, NULL),
(258, 'Training', 0, 43, 'totTraining', NULL, NULL, NULL, NULL, NULL),
(259, 'Total Leave', 1, 44, 'totalLeave', NULL, NULL, NULL, NULL, NULL),
(260, 'Travel Voucher Applied', 1, 44, 'travelVoucherApplied', NULL, NULL, NULL, NULL, NULL),
(261, 'Appraisal', 1, 44, 'totAppraisal', NULL, NULL, NULL, NULL, NULL),
(262, 'Leave Pending', 1, 44, 'leavePen', NULL, NULL, NULL, NULL, NULL),
(263, 'Travel Voucher Pending', 0, 44, 'travelPen', NULL, NULL, NULL, NULL, NULL),
(264, 'Training', 0, 44, 'totTraining', NULL, NULL, NULL, NULL, NULL),
(265, 'Total Leave', 1, 45, 'totalLeave', NULL, NULL, NULL, NULL, NULL),
(266, 'Travel Voucher Applied', 1, 45, 'travelVoucherApplied', NULL, NULL, NULL, NULL, NULL),
(267, 'Appraisal', 1, 45, 'totAppraisal', NULL, NULL, NULL, NULL, NULL),
(268, 'Leave Pending', 1, 45, 'leavePen', NULL, NULL, NULL, NULL, NULL),
(269, 'Travel Voucher Pending', 0, 45, 'travelPen', NULL, NULL, NULL, NULL, NULL),
(270, 'Training', 0, 45, 'totTraining', NULL, NULL, NULL, NULL, NULL),
(271, 'Total Leave', 1, 46, 'totalLeave', NULL, NULL, NULL, NULL, NULL),
(272, 'Travel Voucher Applied', 1, 46, 'travelVoucherApplied', NULL, NULL, NULL, NULL, NULL),
(273, 'Appraisal', 1, 46, 'totAppraisal', NULL, NULL, NULL, NULL, NULL),
(274, 'Leave Pending', 1, 46, 'leavePen', NULL, NULL, NULL, NULL, NULL),
(275, 'Travel Voucher Pending', 0, 46, 'travelPen', NULL, NULL, NULL, NULL, NULL),
(276, 'Training', 0, 46, 'totTraining', NULL, NULL, NULL, NULL, NULL),
(277, 'Total Leave', 1, 47, 'totalLeave', NULL, NULL, NULL, NULL, NULL),
(278, 'Travel Voucher Applied', 1, 47, 'travelVoucherApplied', NULL, NULL, NULL, NULL, NULL),
(279, 'Appraisal', 1, 47, 'totAppraisal', NULL, NULL, NULL, NULL, NULL),
(280, 'Leave Pending', 1, 47, 'leavePen', NULL, NULL, NULL, NULL, NULL),
(281, 'Travel Voucher Pending', 0, 47, 'travelPen', NULL, NULL, NULL, NULL, NULL),
(282, 'Training', 0, 47, 'totTraining', NULL, NULL, NULL, NULL, NULL),
(283, 'Total Leave', 1, 48, 'totalLeave', NULL, NULL, NULL, NULL, NULL),
(284, 'Travel Voucher Applied', 1, 48, 'travelVoucherApplied', NULL, NULL, NULL, NULL, NULL),
(285, 'Appraisal', 1, 48, 'totAppraisal', NULL, NULL, NULL, NULL, NULL),
(286, 'Leave Pending', 1, 48, 'leavePen', NULL, NULL, NULL, NULL, NULL),
(287, 'Travel Voucher Pending', 0, 48, 'travelPen', NULL, NULL, NULL, NULL, NULL),
(288, 'Training', 0, 48, 'totTraining', NULL, NULL, NULL, NULL, NULL),
(289, 'Total Leave', 1, 49, 'totalLeave', NULL, NULL, NULL, NULL, NULL),
(290, 'Travel Voucher Applied', 1, 49, 'travelVoucherApplied', NULL, NULL, NULL, NULL, NULL),
(291, 'Appraisal', 1, 49, 'totAppraisal', NULL, NULL, NULL, NULL, NULL),
(292, 'Leave Pending', 1, 49, 'leavePen', NULL, NULL, NULL, NULL, NULL),
(293, 'Travel Voucher Pending', 0, 49, 'travelPen', NULL, NULL, NULL, NULL, NULL),
(294, 'Training', 0, 49, 'totTraining', NULL, NULL, NULL, NULL, NULL),
(295, 'Total Leave', 1, 50, 'totalLeave', NULL, NULL, NULL, NULL, NULL),
(296, 'Travel Voucher Applied', 1, 50, 'travelVoucherApplied', NULL, NULL, NULL, NULL, NULL),
(297, 'Appraisal', 1, 50, 'totAppraisal', NULL, NULL, NULL, NULL, NULL),
(298, 'Leave Pending', 1, 50, 'leavePen', NULL, NULL, NULL, NULL, NULL),
(299, 'Travel Voucher Pending', 0, 50, 'travelPen', NULL, NULL, NULL, NULL, NULL),
(300, 'Training', 0, 50, 'totTraining', NULL, NULL, NULL, NULL, NULL),
(301, 'Total Leave', 1, 51, 'totalLeave', NULL, NULL, NULL, NULL, NULL),
(302, 'Travel Voucher Applied', 1, 51, 'travelVoucherApplied', NULL, NULL, NULL, NULL, NULL),
(303, 'Appraisal', 1, 51, 'totAppraisal', NULL, NULL, NULL, NULL, NULL),
(304, 'Leave Pending', 1, 51, 'leavePen', NULL, NULL, NULL, NULL, NULL),
(305, 'Travel Voucher Pending', 0, 51, 'travelPen', NULL, NULL, NULL, NULL, NULL),
(306, 'Training', 0, 51, 'totTraining', NULL, NULL, NULL, NULL, NULL),
(307, 'Total Leave', 1, 52, 'totalLeave', NULL, NULL, NULL, NULL, NULL),
(308, 'Travel Voucher Applied', 1, 52, 'travelVoucherApplied', NULL, NULL, NULL, NULL, NULL),
(309, 'Appraisal', 1, 52, 'totAppraisal', NULL, NULL, NULL, NULL, NULL),
(310, 'Leave Pending', 1, 52, 'leavePen', NULL, NULL, NULL, NULL, NULL),
(311, 'Travel Voucher Pending', 0, 52, 'travelPen', NULL, NULL, NULL, NULL, NULL),
(312, 'Training', 0, 52, 'totTraining', NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ticker_user`
--

CREATE TABLE `ticker_user` (
  `id` int(20) NOT NULL,
  `ticker_id` int(10) DEFAULT NULL,
  `myprofile_id` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ticker_user`
--

INSERT INTO `ticker_user` (`id`, `ticker_id`, `myprofile_id`) VALUES
(19, 7, 171),
(20, 8, 171),
(21, 9, 171);

-- --------------------------------------------------------

--
-- Table structure for table `ticket_category`
--

CREATE TABLE `ticket_category` (
  `id` int(10) NOT NULL,
  `category_name` varchar(100) NOT NULL,
  `created_date` date DEFAULT NULL,
  `status` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ticket_category`
--

INSERT INTO `ticket_category` (`id`, `category_name`, `created_date`, `status`) VALUES
(1, 'Hardware Issue', '2017-07-04', 1),
(2, 'Software Issue', '2017-07-04', 1),
(3, 'Networking Issue', '2017-07-04', 1),
(4, 'Others', '2017-07-04', 1);

-- --------------------------------------------------------

--
-- Table structure for table `training_config`
--

CREATE TABLE `training_config` (
  `id` int(11) NOT NULL,
  `email` int(11) NOT NULL,
  `sms` int(11) NOT NULL,
  `open_attendance_hour` int(11) NOT NULL,
  `open_attendance_min` int(11) NOT NULL,
  `close_attendance_hour` int(11) NOT NULL,
  `close_attendance_min` int(11) NOT NULL,
  `comp_code` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `training_course_attendence`
--

CREATE TABLE `training_course_attendence` (
  `id` int(11) NOT NULL,
  `training_creation_id` int(11) NOT NULL,
  `trainee_code` varchar(60) NOT NULL,
  `trainee_comp_code` varchar(60) NOT NULL,
  `open` int(1) DEFAULT '0',
  `open_time` datetime DEFAULT NULL,
  `close` int(1) DEFAULT '0',
  `close_time` datetime DEFAULT NULL,
  `created_at` date DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `feedback_status` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `training_course_creation`
--

CREATE TABLE `training_course_creation` (
  `course_id` int(11) NOT NULL,
  `type_id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `description` text,
  `course_duration_time` int(11) DEFAULT NULL,
  `course_duration_type` char(1) DEFAULT NULL,
  `cost` float DEFAULT NULL,
  `currency` varchar(255) DEFAULT NULL,
  `institute_name` varchar(255) DEFAULT NULL,
  `max_class_capacity` int(11) DEFAULT NULL,
  `course_category_id` int(11) DEFAULT NULL,
  `course_validity_id` int(11) DEFAULT NULL,
  `status` int(1) DEFAULT NULL,
  `active_date` date DEFAULT NULL,
  `inactive_date` date DEFAULT NULL,
  `created_at` date DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `emp_code` varchar(255) DEFAULT NULL,
  `comp_code` varchar(255) DEFAULT NULL,
  `solc_id` varchar(25) DEFAULT NULL,
  `cld_id` varchar(25) DEFAULT NULL,
  `ho_org_id` varchar(25) DEFAULT NULL,
  `org_id` varchar(25) DEFAULT NULL,
  `doc_id` varchar(52) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `training_creation`
--

CREATE TABLE `training_creation` (
  `training_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `schedule_id` int(11) DEFAULT NULL,
  `description` text,
  `remarks` text,
  `training_date` date DEFAULT NULL,
  `training_start_time` varchar(25) DEFAULT NULL,
  `training_end _time` varchar(25) DEFAULT NULL,
  `self` int(1) DEFAULT '0',
  `status` int(1) DEFAULT NULL,
  `identified_by` varchar(25) NOT NULL,
  `initated_by` varchar(5) NOT NULL,
  `created_at` date DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `emp_code` varchar(255) NOT NULL,
  `comp_code` varchar(255) NOT NULL,
  `solc_id` varchar(25) DEFAULT NULL,
  `cld_id` varchar(25) DEFAULT NULL,
  `ho_org_id` varchar(25) DEFAULT NULL,
  `org_id` varchar(25) DEFAULT NULL,
  `doc_id` varchar(52) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `training_development`
--

CREATE TABLE `training_development` (
  `id` int(11) NOT NULL,
  `emp_code` varchar(50) NOT NULL,
  `financial_year` int(2) NOT NULL,
  `dev_plan_id` int(11) NOT NULL,
  `identified_areas_for_development` text NOT NULL,
  `observed_behavior` text NOT NULL,
  `suggested_action_plan` text NOT NULL,
  `timelines` text NOT NULL,
  `responsibility` text NOT NULL,
  `post_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `training_development`
--

-- --------------------------------------------------------

--
-- Table structure for table `training_employee`
--

CREATE TABLE `training_employee` (
  `id` int(11) NOT NULL,
  `training_creation_id` int(11) DEFAULT NULL,
  `trainee_code` varchar(255) DEFAULT NULL,
  `trainee_comp_code` varchar(255) DEFAULT NULL,
  `location` varchar(25) DEFAULT NULL,
  `desg_code` varchar(255) DEFAULT NULL,
  `dept_code` varchar(255) DEFAULT NULL,
  `manager_code` varchar(255) DEFAULT NULL,
  `approved_date` date DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `reg_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `training_parameters`
--

CREATE TABLE `training_parameters` (
  `id` int(11) NOT NULL,
  `comp_code` varchar(65) DEFAULT NULL,
  `parameter_code` varchar(50) DEFAULT NULL,
  `parameter_value` varchar(50) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `training_registrations`
--

CREATE TABLE `training_registrations` (
  `id` int(50) NOT NULL,
  `request_id` varchar(20) DEFAULT NULL,
  `trainee_code` varchar(20) DEFAULT NULL,
  `type` varchar(10) DEFAULT NULL,
  `manager` varchar(20) DEFAULT NULL,
  `tr_status` varchar(20) DEFAULT NULL,
  `remarks` varchar(20) DEFAULT NULL,
  `regis_date` date DEFAULT NULL,
  `approved` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `training_registrations`
--

INSERT INTO `training_registrations` (`id`, `request_id`, `trainee_code`, `type`, `manager`, `tr_status`, `remarks`, `regis_date`, `approved`) VALUES
(1, '1', '492', NULL, '78', 'ALLOWED', NULL, '2016-01-27', NULL),
(2, '2', '492', NULL, '78', 'ALLOWED', 'You are not allowed ', '2016-01-30', NULL),
(4, '7', '1168', 'M', '1269', 'ALLOWED', NULL, '2016-06-30', NULL),
(5, '3', '972', NULL, '', 'ALLOWED', NULL, '2016-06-30', '2016-06-30'),
(31, '9', '1269', NULL, '1244', 'ALLOWED', 'You are not allowed ', '2016-07-01', NULL),
(32, '10', '535', NULL, '209', 'ALLOWED', 'You are not allowed ', '2016-07-01', NULL),
(33, '4', '209', NULL, '1269', 'ALLOWED', 'You are not allowed ', '2016-07-01', NULL),
(34, '8', '1168', NULL, '1269', 'ALLOWED', 'You are not allowed ', '2016-07-01', '2016-07-01');

-- --------------------------------------------------------

--
-- Table structure for table `training_reminder_details`
--

CREATE TABLE `training_reminder_details` (
  `id` int(20) DEFAULT NULL,
  `reminder_type` varchar(20) DEFAULT NULL,
  `training_region` varchar(50) DEFAULT NULL,
  `rem_counter` varchar(20) DEFAULT NULL,
  `last_rem_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `training_request`
--

CREATE TABLE `training_request` (
  `id` int(11) NOT NULL,
  `appraisal_id` varchar(20) DEFAULT NULL,
  `topic_type` varchar(20) DEFAULT NULL,
  `training` varchar(20) DEFAULT NULL,
  `identified_by` varchar(20) DEFAULT NULL,
  `trainee_code` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `training_schedule_creation`
--

CREATE TABLE `training_schedule_creation` (
  `schedule_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `sch_start_date` date DEFAULT NULL,
  `sch_end_date` date DEFAULT NULL,
  `sch_start_time` varchar(20) DEFAULT NULL,
  `sch_end_time` varchar(20) DEFAULT NULL,
  `contact_person` varchar(255) DEFAULT NULL,
  `contact_email` varchar(255) DEFAULT NULL,
  `contact_number` int(10) DEFAULT NULL,
  `facility` varchar(200) DEFAULT NULL,
  `location` varchar(200) DEFAULT NULL,
  `instructor_name` varchar(200) DEFAULT NULL,
  `mode` varchar(200) DEFAULT NULL,
  `final_regis_date` date DEFAULT NULL,
  `status` int(1) DEFAULT NULL,
  `active_date` date DEFAULT NULL,
  `inactive_date` date DEFAULT NULL,
  `created_at` date DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `comp_id` varchar(255) DEFAULT NULL,
  `emp_code` varchar(255) DEFAULT NULL,
  `solc_id` varchar(25) DEFAULT NULL,
  `cld_id` varchar(25) DEFAULT NULL,
  `ho_org_id` varchar(25) DEFAULT NULL,
  `org_id` varchar(25) DEFAULT NULL,
  `doc_id` varchar(52) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `training_workflow`
--

CREATE TABLE `training_workflow` (
  `id` int(11) NOT NULL,
  `training_creation_id` int(11) DEFAULT NULL,
  `fwd_date` date DEFAULT NULL,
  `approved_date` date DEFAULT NULL,
  `remarks` varchar(255) DEFAULT NULL,
  `emp_code` varchar(255) DEFAULT NULL,
  `status` int(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `travel_masters`
--

CREATE TABLE `travel_masters` (
  `department_id` varchar(25) NOT NULL,
  `designation_id` varchar(25) NOT NULL,
  `amount` varchar(20) NOT NULL,
  `id` int(20) NOT NULL,
  `city_type` varchar(10) DEFAULT NULL,
  `hotel_amount` int(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `travel_masters`
--
-- --------------------------------------------------------

--
-- Table structure for table `travel_workflow`
--

CREATE TABLE `travel_workflow` (
  `id` int(11) NOT NULL,
  `voucher_id` int(11) NOT NULL,
  `emp_code` int(11) DEFAULT NULL,
  `fw_date` date DEFAULT NULL,
  `remark` text,
  `approve_date` date DEFAULT NULL,
  `voucher_status` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user-bk`
--
-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `comp_code` varchar(40) DEFAULT NULL,
  `emp_code` varchar(40) DEFAULT NULL,
  `emp_id` varchar(255) NOT NULL,
  `user_name` varchar(100) DEFAULT NULL,
  `user_password` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `status` enum('0','1') NOT NULL DEFAULT '1',
  `session_id` varchar(255) DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  `token` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users_bk`
--

-- --------------------------------------------------------

--
-- Table structure for table `week_holiday`
--

CREATE TABLE `week_holiday` (
  `id` int(10) NOT NULL,
  `day_code` int(10) NOT NULL,
  `numbers` varchar(128) NOT NULL,
  `solc_id` varchar(25) DEFAULT NULL,
  `cld_id` varchar(22) DEFAULT NULL,
  `ho_org_id` varchar(22) DEFAULT NULL,
  `org_id` varchar(22) DEFAULT NULL,
  `emp_doc_id` varchar(52) DEFAULT NULL,
  `doc_id` varchar(52) DEFAULT NULL,
  `emp_group` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `week_holiday`

-- --------------------------------------------------------

--
-- Table structure for table `week_holiday_list`
--

CREATE TABLE `week_holiday_list` (
  `id` int(10) NOT NULL,
  `day_code` int(10) NOT NULL,
  `dt` date NOT NULL,
  `emp_group` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `week_holiday_list`
--
-- --------------------------------------------------------

--
-- Table structure for table `weightage`
--

CREATE TABLE `weightage` (
  `id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `weightage_range` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `weightage`
--

INSERT INTO `weightage` (`id`, `name`, `weightage_range`) VALUES
(1, 'Average Performer', '69'),
(2, 'Good Performer', '84-70'),
(3, 'Excellent Performer', '99-85'),
(4, 'Outstanding Performer', '100');

-- --------------------------------------------------------

--
-- Table structure for table `weightage_calculation_type`
--

CREATE TABLE `weightage_calculation_type` (
  `id` int(1) NOT NULL,
  `weightage_calculation_type` int(1) NOT NULL,
  `weightage_calculation_type_value` varchar(30) NOT NULL,
  `created_date` datetime NOT NULL,
  `updated_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `weightage_calculation_type`
--

INSERT INTO `weightage_calculation_type` (`id`, `weightage_calculation_type`, `weightage_calculation_type_value`, `created_date`, `updated_date`) VALUES
(1, 1, 'Manual', '2016-10-20 00:00:00', '2017-03-18 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `wf_dt_app_map_lvl`
--

CREATE TABLE `wf_dt_app_map_lvl` (
  `wf_id` int(11) NOT NULL,
  `wf_app_map_lvl_id` int(11) DEFAULT NULL,
  `lvl_sequence` int(10) NOT NULL,
  `wf_lvl` varchar(40) DEFAULT NULL,
  `wf_dept_id` varchar(40) DEFAULT NULL,
  `wf_desg_id` varchar(40) DEFAULT NULL,
  `created_date` date DEFAULT NULL,
  `skip_status` int(10) DEFAULT NULL,
  `revoke_level_id` int(11) NOT NULL,
  `solc_id` varchar(25) DEFAULT NULL,
  `cld_id` varchar(22) DEFAULT NULL,
  `ho_org_id` varchar(22) DEFAULT NULL,
  `org_id` varchar(22) DEFAULT NULL,
  `emp_doc_id` varchar(52) DEFAULT NULL,
  `doc_id` varchar(52) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `wf_dt_app_map_lvl`
--

INSERT INTO `wf_dt_app_map_lvl` (`wf_id`, `wf_app_map_lvl_id`, `lvl_sequence`, `wf_lvl`, `wf_dept_id`, `wf_desg_id`, `created_date`, `skip_status`, `revoke_level_id`, `solc_id`, `cld_id`, `ho_org_id`, `org_id`, `emp_doc_id`, `doc_id`) VALUES
(1, 1, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(2, 1, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(3, 1, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(4, 1, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(5, 1, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(6, 1, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(7, 1, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(8, 1, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(9, 2, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(10, 2, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(11, 2, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(12, 2, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(13, 2, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(14, 2, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(15, 2, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(16, 2, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(17, 3, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(18, 3, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(19, 3, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(20, 3, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(21, 3, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(22, 3, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(23, 3, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(24, 3, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(25, 4, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(26, 4, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(27, 4, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(28, 4, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(29, 4, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(30, 4, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(31, 4, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(32, 4, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(33, 12, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(34, 12, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(35, 12, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(36, 12, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(37, 12, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(38, 12, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(39, 12, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(40, 12, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(41, 10, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(42, 10, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(43, 10, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(44, 10, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(45, 10, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(46, 10, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(47, 10, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(48, 10, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(49, 11, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(50, 11, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(51, 11, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(52, 11, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(53, 11, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(54, 11, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(55, 11, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(56, 11, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(57, 8, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(58, 8, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(59, 8, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(60, 8, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(61, 8, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(62, 8, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(63, 8, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(64, 8, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(65, 6, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(66, 6, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(67, 6, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(68, 6, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(69, 6, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(70, 6, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(71, 6, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(72, 6, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(73, 14, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(74, 14, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(75, 14, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(76, 14, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(77, 14, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(78, 14, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(79, 14, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(80, 14, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(81, 15, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(82, 15, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(83, 15, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(84, 15, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(85, 15, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(86, 15, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(87, 15, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(88, 15, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(89, 1, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(90, 1, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(91, 1, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(92, 1, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(93, 1, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(94, 1, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(95, 1, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(96, 1, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(97, 2, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(98, 2, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(99, 2, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(100, 2, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(101, 2, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(102, 2, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(103, 2, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(104, 2, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(105, 3, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(106, 3, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(107, 3, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(108, 3, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(109, 3, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(110, 3, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(111, 3, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(112, 3, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(113, 4, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(114, 4, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(115, 4, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(116, 4, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(117, 4, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(118, 4, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(119, 4, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(120, 4, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(121, 12, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(122, 12, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(123, 12, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(124, 12, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(125, 12, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(126, 12, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(127, 12, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(128, 12, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(129, 10, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(130, 10, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(131, 10, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(132, 10, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(133, 10, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(134, 10, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(135, 10, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(136, 10, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(137, 11, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(138, 11, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(139, 11, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(140, 11, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(141, 11, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(142, 11, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(143, 11, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(144, 11, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(145, 8, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(146, 8, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(147, 8, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(148, 8, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(149, 8, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(150, 8, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(151, 8, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(152, 8, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(153, 6, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(154, 6, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(155, 6, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(156, 6, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(157, 6, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(158, 6, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(159, 6, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(160, 6, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(161, 14, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(162, 14, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(163, 14, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(164, 14, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(165, 14, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(166, 14, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(167, 14, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(168, 14, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(169, 15, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(170, 15, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(171, 15, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(172, 15, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(173, 15, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(174, 15, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(175, 15, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(176, 15, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(177, 1, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(178, 1, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(179, 1, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(180, 1, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(181, 1, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(182, 1, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(183, 1, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(184, 1, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(185, 2, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(186, 2, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(187, 2, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(188, 2, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(189, 2, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(190, 2, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(191, 2, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(192, 2, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(193, 3, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(194, 3, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(195, 3, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(196, 3, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(197, 3, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(198, 3, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(199, 3, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(200, 3, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(201, 4, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(202, 4, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(203, 4, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(204, 4, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(205, 4, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(206, 4, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(207, 4, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(208, 4, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(209, 12, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(210, 12, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(211, 12, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(212, 12, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(213, 12, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(214, 12, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(215, 12, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(216, 12, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(217, 10, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(218, 10, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(219, 10, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(220, 10, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(221, 10, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(222, 10, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(223, 10, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(224, 10, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(225, 11, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(226, 11, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(227, 11, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(228, 11, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(229, 11, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(230, 11, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(231, 11, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(232, 11, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(233, 8, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(234, 8, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(235, 8, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(236, 8, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(237, 8, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(238, 8, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(239, 8, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(240, 8, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(241, 6, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(242, 6, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(243, 6, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(244, 6, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(245, 6, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(246, 6, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(247, 6, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(248, 6, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(249, 14, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(250, 14, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(251, 14, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(252, 14, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(253, 14, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(254, 14, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(255, 14, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(256, 14, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(257, 15, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(258, 15, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(259, 15, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(260, 15, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(261, 15, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(262, 15, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(263, 15, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(264, 15, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-10-10', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(265, 1, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(266, 1, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(267, 1, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(268, 1, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(269, 1, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(270, 1, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(271, 1, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(272, 1, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(273, 2, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(274, 2, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(275, 2, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(276, 2, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(277, 2, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(278, 2, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(279, 2, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(280, 2, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(281, 3, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(282, 3, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(283, 3, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(284, 3, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(285, 3, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(286, 3, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(287, 3, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(288, 3, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(289, 4, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(290, 4, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(291, 4, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(292, 4, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(293, 4, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(294, 4, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(295, 4, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(296, 4, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(297, 12, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(298, 12, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(299, 12, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(300, 12, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(301, 12, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(302, 12, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(303, 12, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(304, 12, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(305, 10, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(306, 10, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(307, 10, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(308, 10, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(309, 10, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(310, 10, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(311, 10, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(312, 10, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(313, 11, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(314, 11, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(315, 11, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(316, 11, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(317, 11, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(318, 11, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(319, 11, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(320, 11, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(321, 8, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(322, 8, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(323, 8, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(324, 8, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(325, 8, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(326, 8, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(327, 8, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(328, 8, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(329, 6, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(330, 6, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(331, 6, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(332, 6, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(333, 6, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(334, 6, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(335, 6, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(336, 6, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(337, 14, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(338, 14, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(339, 14, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(340, 14, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(341, 14, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(342, 14, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(343, 14, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(344, 14, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(345, 15, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(346, 15, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(347, 15, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(348, 15, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(349, 15, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(350, 15, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(351, 15, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(352, 15, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(353, 1, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(354, 1, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(355, 1, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(356, 1, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(357, 1, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(358, 1, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(359, 1, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(360, 1, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(361, 2, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(362, 2, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(363, 2, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(364, 2, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(365, 2, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(366, 2, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(367, 2, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(368, 2, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(369, 3, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(370, 3, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(371, 3, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(372, 3, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(373, 3, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(374, 3, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(375, 3, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(376, 3, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(377, 4, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(378, 4, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(379, 4, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(380, 4, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(381, 4, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(382, 4, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(383, 4, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(384, 4, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(385, 12, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(386, 12, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(387, 12, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(388, 12, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(389, 12, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(390, 12, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(391, 12, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(392, 12, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(393, 10, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(394, 10, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(395, 10, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(396, 10, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(397, 10, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(398, 10, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(399, 10, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(400, 10, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(401, 11, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(402, 11, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(403, 11, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(404, 11, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(405, 11, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(406, 11, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(407, 11, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(408, 11, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(409, 8, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(410, 8, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(411, 8, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(412, 8, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(413, 8, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(414, 8, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(415, 8, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(416, 8, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(417, 6, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(418, 6, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(419, 6, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(420, 6, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(421, 6, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(422, 6, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(423, 6, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(424, 6, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(425, 14, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(426, 14, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(427, 14, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(428, 14, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(429, 14, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(430, 14, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(431, 14, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(432, 14, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(433, 15, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(434, 15, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(435, 15, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(436, 15, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(437, 15, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(438, 15, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(439, 15, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(440, 15, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(441, 1, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(442, 1, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(443, 1, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(444, 1, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(445, 1, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(446, 1, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(447, 1, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(448, 1, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(449, 2, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(450, 2, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(451, 2, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(452, 2, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(453, 2, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(454, 2, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(455, 2, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(456, 2, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(457, 3, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(458, 3, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(459, 3, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(460, 3, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(461, 3, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(462, 3, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(463, 3, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(464, 3, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(465, 4, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(466, 4, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(467, 4, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(468, 4, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(469, 4, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(470, 4, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(471, 4, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(472, 4, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(473, 12, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(474, 12, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(475, 12, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(476, 12, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(477, 12, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `wf_dt_app_map_lvl` (`wf_id`, `wf_app_map_lvl_id`, `lvl_sequence`, `wf_lvl`, `wf_dept_id`, `wf_desg_id`, `created_date`, `skip_status`, `revoke_level_id`, `solc_id`, `cld_id`, `ho_org_id`, `org_id`, `emp_doc_id`, `doc_id`) VALUES
(478, 12, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(479, 12, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(480, 12, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(481, 10, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(482, 10, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(483, 10, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(484, 10, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(485, 10, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(486, 10, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(487, 10, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(488, 10, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(489, 11, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(490, 11, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(491, 11, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(492, 11, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(493, 11, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(494, 11, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(495, 11, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(496, 11, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(497, 8, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(498, 8, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(499, 8, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(500, 8, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(501, 8, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(502, 8, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(503, 8, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(504, 8, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(505, 6, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(506, 6, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(507, 6, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(508, 6, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(509, 6, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(510, 6, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(511, 6, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(512, 6, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(513, 14, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(514, 14, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(515, 14, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(516, 14, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(517, 14, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(518, 14, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(519, 14, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(520, 14, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(521, 15, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(522, 15, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(523, 15, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(524, 15, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(525, 15, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(526, 15, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(527, 15, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(528, 15, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-10-17', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(529, 1, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-10-18', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(530, 1, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-10-18', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(531, 1, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-10-18', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(532, 1, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-10-18', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(533, 1, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-10-18', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(534, 1, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-10-18', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(535, 1, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-10-18', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(536, 1, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-10-18', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(537, 2, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-10-18', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(538, 2, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-10-18', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(539, 2, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-10-18', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(540, 2, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-10-18', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(541, 2, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-10-18', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(542, 2, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-10-18', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(543, 2, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-10-18', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(544, 2, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-10-18', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(545, 3, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-10-18', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(546, 3, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-10-18', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(547, 3, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-10-18', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(548, 3, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-10-18', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(549, 3, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-10-18', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(550, 3, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-10-18', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(551, 3, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-10-18', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(552, 3, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-10-18', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(553, 4, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-10-18', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(554, 4, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-10-18', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(555, 4, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-10-18', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(556, 4, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-10-18', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(557, 4, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-10-18', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(558, 4, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-10-18', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(559, 4, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-10-18', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(560, 4, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-10-18', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(561, 12, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-10-18', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(562, 12, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-10-18', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(563, 12, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-10-18', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(564, 12, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-10-18', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(565, 12, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-10-18', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(566, 12, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-10-18', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(567, 12, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-10-18', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(568, 12, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-10-18', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(569, 10, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-10-18', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(570, 10, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-10-18', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(571, 10, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-10-18', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(572, 10, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-10-18', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(573, 10, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-10-18', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(574, 10, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-10-18', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(575, 10, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-10-18', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(576, 10, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-10-18', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(577, 11, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-10-18', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(578, 11, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-10-18', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(579, 11, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-10-18', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(580, 11, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-10-18', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(581, 11, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-10-18', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(582, 11, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-10-18', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(583, 11, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-10-18', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(584, 11, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-10-18', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(585, 8, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-10-18', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(586, 8, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-10-18', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(587, 8, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-10-18', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(588, 8, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-10-18', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(589, 8, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-10-18', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(590, 8, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-10-18', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(591, 8, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-10-18', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(592, 8, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-10-18', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(593, 6, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-10-18', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(594, 6, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-10-18', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(595, 6, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-10-18', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(596, 6, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-10-18', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(597, 6, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-10-18', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(598, 6, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-10-18', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(599, 6, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-10-18', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(600, 6, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-10-18', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(601, 14, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-10-18', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(602, 14, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-10-18', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(603, 14, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-10-18', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(604, 14, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-10-18', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(605, 14, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-10-18', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(606, 14, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-10-18', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(607, 14, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-10-18', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(608, 14, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-10-18', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(609, 15, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-10-18', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(610, 15, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-10-18', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(611, 15, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-10-18', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(612, 15, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-10-18', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(613, 15, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-10-18', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(614, 15, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-10-18', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(615, 15, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-10-18', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(616, 15, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-10-18', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(617, 1, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(618, 1, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(619, 1, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(620, 1, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(621, 1, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(622, 1, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(623, 1, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(624, 1, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(625, 2, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(626, 2, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(627, 2, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(628, 2, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(629, 2, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(630, 2, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(631, 2, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(632, 2, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(633, 3, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(634, 3, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(635, 3, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(636, 3, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(637, 3, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(638, 3, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(639, 3, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(640, 3, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(641, 4, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(642, 4, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(643, 4, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(644, 4, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(645, 4, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(646, 4, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(647, 4, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(648, 4, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(649, 12, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(650, 12, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(651, 12, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(652, 12, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(653, 12, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(654, 12, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(655, 12, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(656, 12, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(657, 10, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(658, 10, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(659, 10, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(660, 10, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(661, 10, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(662, 10, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(663, 10, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(664, 10, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(665, 11, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(666, 11, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(667, 11, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(668, 11, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(669, 11, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(670, 11, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(671, 11, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(672, 11, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(673, 8, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(674, 8, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(675, 8, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(676, 8, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(677, 8, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(678, 8, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(679, 8, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(680, 8, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(681, 6, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(682, 6, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(683, 6, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(684, 6, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(685, 6, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(686, 6, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(687, 6, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(688, 6, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(689, 14, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(690, 14, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(691, 14, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(692, 14, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(693, 14, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(694, 14, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(695, 14, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(696, 14, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(697, 15, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(698, 15, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(699, 15, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(700, 15, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(701, 15, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(702, 15, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(703, 15, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(704, 15, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(705, 1, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(706, 1, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(707, 1, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(708, 1, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(709, 1, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(710, 1, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(711, 1, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(712, 1, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(713, 2, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(714, 2, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(715, 2, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(716, 2, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(717, 2, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(718, 2, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(719, 2, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(720, 2, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(721, 3, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(722, 3, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(723, 3, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(724, 3, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(725, 3, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(726, 3, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(727, 3, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(728, 3, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(729, 4, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(730, 4, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(731, 4, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(732, 4, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(733, 4, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(734, 4, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(735, 4, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(736, 4, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(737, 12, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(738, 12, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(739, 12, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(740, 12, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(741, 12, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(742, 12, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(743, 12, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(744, 12, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(745, 10, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(746, 10, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(747, 10, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(748, 10, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(749, 10, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(750, 10, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(751, 10, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(752, 10, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(753, 11, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(754, 11, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(755, 11, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(756, 11, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(757, 11, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(758, 11, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(759, 11, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(760, 11, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(761, 8, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(762, 8, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(763, 8, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(764, 8, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(765, 8, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(766, 8, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(767, 8, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(768, 8, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(769, 6, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(770, 6, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(771, 6, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(772, 6, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(773, 6, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(774, 6, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(775, 6, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(776, 6, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(777, 14, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(778, 14, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(779, 14, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(780, 14, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(781, 14, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(782, 14, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(783, 14, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(784, 14, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(785, 15, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(786, 15, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(787, 15, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(788, 15, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(789, 15, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(790, 15, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(791, 15, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(792, 15, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(793, 1, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(794, 1, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(795, 1, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(796, 1, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(797, 1, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(798, 1, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(799, 1, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(800, 1, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(801, 2, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(802, 2, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(803, 2, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(804, 2, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(805, 2, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(806, 2, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(807, 2, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(808, 2, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(809, 3, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(810, 3, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(811, 3, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(812, 3, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(813, 3, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(814, 3, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(815, 3, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(816, 3, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(817, 4, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(818, 4, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(819, 4, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(820, 4, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(821, 4, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(822, 4, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(823, 4, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(824, 4, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(825, 12, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(826, 12, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(827, 12, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(828, 12, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(829, 12, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(830, 12, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(831, 12, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(832, 12, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(833, 10, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(834, 10, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(835, 10, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(836, 10, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(837, 10, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(838, 10, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(839, 10, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(840, 10, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(841, 11, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(842, 11, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(843, 11, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(844, 11, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(845, 11, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(846, 11, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(847, 11, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(848, 11, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(849, 8, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(850, 8, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(851, 8, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(852, 8, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(853, 8, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(854, 8, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(855, 8, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(856, 8, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(857, 6, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(858, 6, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(859, 6, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(860, 6, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(861, 6, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(862, 6, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(863, 6, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(864, 6, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(865, 14, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(866, 14, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(867, 14, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(868, 14, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(869, 14, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(870, 14, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(871, 14, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(872, 14, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(873, 15, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(874, 15, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(875, 15, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(876, 15, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(877, 15, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(878, 15, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(879, 15, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(880, 15, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(881, 1, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(882, 1, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(883, 1, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(884, 1, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(885, 1, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(886, 1, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(887, 1, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(888, 1, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(889, 2, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(890, 2, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(891, 2, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(892, 2, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(893, 2, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(894, 2, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(895, 2, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(896, 2, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(897, 3, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(898, 3, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(899, 3, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(900, 3, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(901, 3, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(902, 3, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(903, 3, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(904, 3, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(905, 4, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(906, 4, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(907, 4, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(908, 4, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(909, 4, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(910, 4, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(911, 4, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(912, 4, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(913, 12, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(914, 12, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(915, 12, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(916, 12, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(917, 12, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(918, 12, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(919, 12, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(920, 12, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(921, 10, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(922, 10, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(923, 10, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(924, 10, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(925, 10, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(926, 10, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(927, 10, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(928, 10, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(929, 11, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(930, 11, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(931, 11, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(932, 11, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(933, 11, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(934, 11, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(935, 11, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(936, 11, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(937, 8, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(938, 8, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(939, 8, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(940, 8, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(941, 8, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(942, 8, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(943, 8, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(944, 8, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(945, 6, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(946, 6, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(947, 6, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(948, 6, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(949, 6, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(950, 6, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(951, 6, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(952, 6, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(953, 14, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `wf_dt_app_map_lvl` (`wf_id`, `wf_app_map_lvl_id`, `lvl_sequence`, `wf_lvl`, `wf_dept_id`, `wf_desg_id`, `created_date`, `skip_status`, `revoke_level_id`, `solc_id`, `cld_id`, `ho_org_id`, `org_id`, `emp_doc_id`, `doc_id`) VALUES
(954, 14, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(955, 14, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(956, 14, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(957, 14, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(958, 14, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(959, 14, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(960, 14, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(961, 15, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(962, 15, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(963, 15, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(964, 15, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(965, 15, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(966, 15, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(967, 15, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(968, 15, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-10-24', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(969, 1, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(970, 1, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(971, 1, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(972, 1, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(973, 1, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(974, 1, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(975, 1, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(976, 1, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(977, 2, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(978, 2, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(979, 2, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(980, 2, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(981, 2, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(982, 2, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(983, 2, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(984, 2, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(985, 3, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(986, 3, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(987, 3, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(988, 3, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(989, 3, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(990, 3, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(991, 3, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(992, 3, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(993, 4, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(994, 4, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(995, 4, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(996, 4, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(997, 4, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(998, 4, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(999, 4, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1000, 4, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1001, 12, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1002, 12, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1003, 12, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1004, 12, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1005, 12, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1006, 12, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1007, 12, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1008, 12, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1009, 10, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1010, 10, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1011, 10, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1012, 10, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1013, 10, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1014, 10, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1015, 10, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1016, 10, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1017, 11, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1018, 11, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1019, 11, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1020, 11, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1021, 11, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1022, 11, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1023, 11, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1024, 11, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1025, 8, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1026, 8, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1027, 8, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1028, 8, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1029, 8, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1030, 8, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1031, 8, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1032, 8, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1033, 6, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1034, 6, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1035, 6, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1036, 6, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1037, 6, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1038, 6, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1039, 6, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1040, 6, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1041, 14, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1042, 14, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1043, 14, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1044, 14, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1045, 14, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1046, 14, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1047, 14, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1048, 14, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1049, 15, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1050, 15, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1051, 15, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1052, 15, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1053, 15, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1054, 15, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1055, 15, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1056, 15, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1057, 1, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1058, 1, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1059, 1, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1060, 1, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1061, 1, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1062, 1, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1063, 1, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1064, 1, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1065, 2, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1066, 2, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1067, 2, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1068, 2, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1069, 2, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1070, 2, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1071, 2, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1072, 2, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1073, 3, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1074, 3, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1075, 3, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1076, 3, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1077, 3, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1078, 3, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1079, 3, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1080, 3, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1081, 4, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1082, 4, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1083, 4, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1084, 4, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1085, 4, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1086, 4, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1087, 4, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1088, 4, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1089, 12, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1090, 12, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1091, 12, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1092, 12, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1093, 12, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1094, 12, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1095, 12, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1096, 12, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1097, 10, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1098, 10, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1099, 10, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1100, 10, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1101, 10, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1102, 10, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1103, 10, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1104, 10, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1105, 11, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1106, 11, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1107, 11, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1108, 11, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1109, 11, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1110, 11, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1111, 11, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1112, 11, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1113, 8, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1114, 8, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1115, 8, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1116, 8, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1117, 8, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1118, 8, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1119, 8, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1120, 8, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1121, 6, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1122, 6, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1123, 6, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1124, 6, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1125, 6, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1126, 6, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1127, 6, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1128, 6, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1129, 14, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1130, 14, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1131, 14, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1132, 14, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1133, 14, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1134, 14, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1135, 14, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1136, 14, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1137, 15, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1138, 15, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1139, 15, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1140, 15, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1141, 15, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1142, 15, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1143, 15, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1144, 15, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1145, 1, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1146, 1, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1147, 1, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1148, 1, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1149, 1, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1150, 1, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1151, 1, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1152, 1, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1153, 2, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1154, 2, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1155, 2, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1156, 2, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1157, 2, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1158, 2, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1159, 2, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1160, 2, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1161, 3, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1162, 3, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1163, 3, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1164, 3, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1165, 3, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1166, 3, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1167, 3, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1168, 3, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1169, 4, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1170, 4, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1171, 4, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1172, 4, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1173, 4, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1174, 4, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1175, 4, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1176, 4, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1177, 12, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1178, 12, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1179, 12, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1180, 12, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1181, 12, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1182, 12, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1183, 12, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1184, 12, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1185, 10, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1186, 10, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1187, 10, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1188, 10, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1189, 10, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1190, 10, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1191, 10, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1192, 10, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1193, 11, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1194, 11, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1195, 11, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1196, 11, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1197, 11, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1198, 11, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1199, 11, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1200, 11, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1201, 8, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1202, 8, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1203, 8, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1204, 8, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1205, 8, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1206, 8, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1207, 8, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1208, 8, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1209, 6, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1210, 6, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1211, 6, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1212, 6, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1213, 6, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1214, 6, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1215, 6, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1216, 6, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1217, 14, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1218, 14, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1219, 14, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1220, 14, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1221, 14, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1222, 14, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1223, 14, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1224, 14, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1225, 15, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1226, 15, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1227, 15, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1228, 15, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1229, 15, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1230, 15, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1231, 15, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1232, 15, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1233, 1, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1234, 1, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1235, 1, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1236, 1, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1237, 1, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1238, 1, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1239, 1, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1240, 1, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1241, 2, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1242, 2, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1243, 2, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1244, 2, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1245, 2, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1246, 2, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1247, 2, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1248, 2, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1249, 3, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1250, 3, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1251, 3, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1252, 3, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1253, 3, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1254, 3, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1255, 3, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1256, 3, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1257, 4, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1258, 4, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1259, 4, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1260, 4, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1261, 4, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1262, 4, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1263, 4, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1264, 4, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1265, 12, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1266, 12, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1267, 12, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1268, 12, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1269, 12, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1270, 12, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1271, 12, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1272, 12, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1273, 10, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1274, 10, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1275, 10, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1276, 10, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1277, 10, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1278, 10, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1279, 10, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1280, 10, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1281, 11, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1282, 11, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1283, 11, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1284, 11, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1285, 11, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1286, 11, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1287, 11, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1288, 11, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1289, 8, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1290, 8, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1291, 8, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1292, 8, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1293, 8, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1294, 8, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1295, 8, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1296, 8, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1297, 6, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1298, 6, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1299, 6, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1300, 6, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1301, 6, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1302, 6, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1303, 6, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1304, 6, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1305, 14, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1306, 14, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1307, 14, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1308, 14, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1309, 14, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1310, 14, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1311, 14, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1312, 14, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1313, 15, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1314, 15, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1315, 15, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1316, 15, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1317, 15, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1318, 15, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1319, 15, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1320, 15, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-10-25', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1321, 1, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-10-31', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1322, 1, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-10-31', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1323, 1, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-10-31', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1324, 1, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-10-31', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1325, 1, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-10-31', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1326, 1, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-10-31', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1327, 1, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-10-31', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1328, 1, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-10-31', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1329, 2, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-10-31', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1330, 2, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-10-31', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1331, 2, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-10-31', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1332, 2, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-10-31', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1333, 2, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-10-31', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1334, 2, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-10-31', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1335, 2, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-10-31', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1336, 2, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-10-31', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1337, 3, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-10-31', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1338, 3, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-10-31', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1339, 3, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-10-31', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1340, 3, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-10-31', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1341, 3, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-10-31', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1342, 3, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-10-31', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1343, 3, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-10-31', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1344, 3, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-10-31', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1345, 4, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-10-31', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1346, 4, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-10-31', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1347, 4, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-10-31', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1348, 4, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-10-31', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1349, 4, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-10-31', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1350, 4, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-10-31', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1351, 4, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-10-31', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1352, 4, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-10-31', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1353, 12, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-10-31', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1354, 12, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-10-31', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1355, 12, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-10-31', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1356, 12, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-10-31', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1357, 12, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-10-31', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1358, 12, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-10-31', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1359, 12, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-10-31', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1360, 12, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-10-31', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1361, 10, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-10-31', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1362, 10, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-10-31', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1363, 10, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-10-31', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1364, 10, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-10-31', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1365, 10, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-10-31', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1366, 10, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-10-31', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1367, 10, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-10-31', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1368, 10, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-10-31', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1369, 11, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-10-31', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1370, 11, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-10-31', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1371, 11, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-10-31', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1372, 11, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-10-31', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1373, 11, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-10-31', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1374, 11, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-10-31', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1375, 11, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-10-31', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1376, 11, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-10-31', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1377, 8, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-10-31', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1378, 8, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-10-31', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1379, 8, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-10-31', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1380, 8, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-10-31', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1381, 8, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-10-31', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1382, 8, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-10-31', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1383, 8, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-10-31', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1384, 8, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-10-31', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1385, 6, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-10-31', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1386, 6, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-10-31', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1387, 6, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-10-31', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1388, 6, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-10-31', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1389, 6, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-10-31', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1390, 6, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-10-31', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1391, 6, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-10-31', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1392, 6, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-10-31', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1393, 14, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-10-31', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1394, 14, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-10-31', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1395, 14, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-10-31', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1396, 14, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-10-31', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1397, 14, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-10-31', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1398, 14, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-10-31', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1399, 14, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-10-31', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1400, 14, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-10-31', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1401, 15, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-10-31', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1402, 15, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-10-31', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1403, 15, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-10-31', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1404, 15, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-10-31', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1405, 15, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-10-31', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1406, 15, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-10-31', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1407, 15, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-10-31', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1408, 15, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-10-31', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1409, 1, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-11-01', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1410, 1, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-11-01', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1411, 1, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-11-01', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1412, 1, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-11-01', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1413, 1, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-11-01', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1414, 1, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-11-01', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1415, 1, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-11-01', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1416, 1, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-11-01', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1417, 2, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-11-01', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1418, 2, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-11-01', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1419, 2, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-11-01', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1420, 2, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-11-01', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1421, 2, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-11-01', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1422, 2, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-11-01', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1423, 2, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-11-01', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1424, 2, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-11-01', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1425, 3, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-11-01', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `wf_dt_app_map_lvl` (`wf_id`, `wf_app_map_lvl_id`, `lvl_sequence`, `wf_lvl`, `wf_dept_id`, `wf_desg_id`, `created_date`, `skip_status`, `revoke_level_id`, `solc_id`, `cld_id`, `ho_org_id`, `org_id`, `emp_doc_id`, `doc_id`) VALUES
(1426, 3, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-11-01', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1427, 3, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-11-01', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1428, 3, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-11-01', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1429, 3, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-11-01', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1430, 3, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-11-01', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1431, 3, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-11-01', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1432, 3, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-11-01', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1433, 4, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-11-01', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1434, 4, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-11-01', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1435, 4, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-11-01', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1436, 4, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-11-01', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1437, 4, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-11-01', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1438, 4, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-11-01', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1439, 4, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-11-01', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1440, 4, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-11-01', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1441, 12, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-11-01', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1442, 12, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-11-01', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1443, 12, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-11-01', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1444, 12, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-11-01', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1445, 12, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-11-01', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1446, 12, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-11-01', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1447, 12, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-11-01', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1448, 12, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-11-01', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1449, 10, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-11-01', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1450, 10, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-11-01', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1451, 10, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-11-01', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1452, 10, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-11-01', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1453, 10, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-11-01', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1454, 10, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-11-01', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1455, 10, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-11-01', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1456, 10, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-11-01', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1457, 11, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-11-01', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1458, 11, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-11-01', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1459, 11, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-11-01', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1460, 11, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-11-01', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1461, 11, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-11-01', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1462, 11, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-11-01', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1463, 11, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-11-01', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1464, 11, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-11-01', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1465, 8, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-11-01', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1466, 8, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-11-01', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1467, 8, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-11-01', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1468, 8, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-11-01', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1469, 8, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-11-01', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1470, 8, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-11-01', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1471, 8, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-11-01', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1472, 8, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-11-01', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1473, 6, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-11-01', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1474, 6, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-11-01', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1475, 6, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-11-01', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1476, 6, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-11-01', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1477, 6, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-11-01', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1478, 6, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-11-01', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1479, 6, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-11-01', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1480, 6, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-11-01', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1481, 14, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-11-01', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1482, 14, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-11-01', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1483, 14, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-11-01', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1484, 14, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-11-01', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1485, 14, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-11-01', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1486, 14, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-11-01', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1487, 14, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-11-01', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1488, 14, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-11-01', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1489, 15, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-11-01', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1490, 15, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-11-01', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1491, 15, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-11-01', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1492, 15, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-11-01', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1493, 15, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-11-01', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1494, 15, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-11-01', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1495, 15, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-11-01', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1496, 15, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-11-01', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1497, 1, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-11-01', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1498, 1, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-11-01', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1499, 1, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-11-01', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1500, 1, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-11-01', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1501, 1, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-11-01', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1502, 1, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-11-01', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1503, 1, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-11-01', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1504, 1, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-11-01', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1505, 2, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-11-01', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1506, 2, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-11-01', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1507, 2, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-11-01', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1508, 2, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-11-01', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1509, 2, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-11-01', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1510, 2, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-11-01', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1511, 2, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-11-01', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1512, 2, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-11-01', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1513, 3, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-11-01', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1514, 3, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-11-01', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1515, 3, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-11-01', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1516, 3, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-11-01', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1517, 3, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-11-01', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1518, 3, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-11-01', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1519, 3, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-11-01', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1520, 3, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-11-01', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1521, 4, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-11-01', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1522, 4, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-11-01', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1523, 4, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-11-01', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1524, 4, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-11-01', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1525, 4, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-11-01', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1526, 4, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-11-01', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1527, 4, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-11-01', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1528, 4, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-11-01', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1529, 12, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-11-01', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1530, 12, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-11-01', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1531, 12, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-11-01', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1532, 12, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-11-01', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1533, 12, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-11-01', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1534, 12, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-11-01', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1535, 12, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-11-01', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1536, 12, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-11-01', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1537, 10, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-11-01', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1538, 10, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-11-01', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1539, 10, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-11-01', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1540, 10, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-11-01', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1541, 10, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-11-01', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1542, 10, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-11-01', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1543, 10, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-11-01', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1544, 10, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-11-01', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1545, 11, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-11-01', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1546, 11, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-11-01', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1547, 11, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-11-01', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1548, 11, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-11-01', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1549, 11, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-11-01', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1550, 11, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-11-01', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1551, 11, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-11-01', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1552, 11, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-11-01', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1553, 8, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-11-01', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1554, 8, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-11-01', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1555, 8, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-11-01', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1556, 8, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-11-01', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1557, 8, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-11-01', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1558, 8, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-11-01', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1559, 8, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-11-01', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1560, 8, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-11-01', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1561, 6, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-11-01', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1562, 6, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-11-01', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1563, 6, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-11-01', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1564, 6, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-11-01', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1565, 6, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-11-01', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1566, 6, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-11-01', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1567, 6, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-11-01', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1568, 6, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-11-01', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1569, 14, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-11-01', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1570, 14, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-11-01', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1571, 14, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-11-01', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1572, 14, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-11-01', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1573, 14, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-11-01', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1574, 14, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-11-01', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1575, 14, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-11-01', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1576, 14, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-11-01', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1577, 15, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-11-01', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1578, 15, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-11-01', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1579, 15, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-11-01', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1580, 15, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-11-01', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1581, 15, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-11-01', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1582, 15, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-11-01', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1583, 15, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-11-01', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1584, 15, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-11-01', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1585, 1, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1586, 1, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1587, 1, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1588, 1, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1589, 1, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1590, 1, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1591, 1, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1592, 1, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1593, 2, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1594, 2, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1595, 2, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1596, 2, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1597, 2, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1598, 2, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1599, 2, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1600, 2, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1601, 3, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1602, 3, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1603, 3, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1604, 3, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1605, 3, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1606, 3, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1607, 3, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1608, 3, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1609, 4, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1610, 4, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1611, 4, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1612, 4, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1613, 4, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1614, 4, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1615, 4, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1616, 4, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1617, 12, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1618, 12, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1619, 12, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1620, 12, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1621, 12, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1622, 12, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1623, 12, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1624, 12, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1625, 10, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1626, 10, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1627, 10, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1628, 10, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1629, 10, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1630, 10, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1631, 10, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1632, 10, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1633, 11, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1634, 11, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1635, 11, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1636, 11, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1637, 11, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1638, 11, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1639, 11, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1640, 11, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1641, 8, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1642, 8, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1643, 8, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1644, 8, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1645, 8, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1646, 8, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1647, 8, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1648, 8, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1649, 6, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1650, 6, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1651, 6, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1652, 6, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1653, 6, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1654, 6, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1655, 6, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1656, 6, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1657, 14, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1658, 14, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1659, 14, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1660, 14, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1661, 14, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1662, 14, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1663, 14, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1664, 14, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1665, 15, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1666, 15, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1667, 15, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1668, 15, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1669, 15, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1670, 15, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1671, 15, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1672, 15, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1673, 1, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1674, 1, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1675, 1, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1676, 1, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1677, 1, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1678, 1, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1679, 1, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1680, 1, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1681, 2, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1682, 2, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1683, 2, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1684, 2, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1685, 2, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1686, 2, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1687, 2, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1688, 2, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1689, 3, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1690, 3, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1691, 3, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1692, 3, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1693, 3, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1694, 3, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1695, 3, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1696, 3, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1697, 4, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1698, 4, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1699, 4, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1700, 4, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1701, 4, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1702, 4, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1703, 4, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1704, 4, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1705, 12, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1706, 12, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1707, 12, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1708, 12, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1709, 12, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1710, 12, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1711, 12, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1712, 12, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1713, 10, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1714, 10, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1715, 10, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1716, 10, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1717, 10, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1718, 10, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1719, 10, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1720, 10, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1721, 11, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1722, 11, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1723, 11, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1724, 11, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1725, 11, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1726, 11, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1727, 11, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1728, 11, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1729, 8, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1730, 8, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1731, 8, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1732, 8, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1733, 8, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1734, 8, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1735, 8, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1736, 8, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1737, 6, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1738, 6, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1739, 6, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1740, 6, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1741, 6, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1742, 6, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1743, 6, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1744, 6, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1745, 14, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1746, 14, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1747, 14, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1748, 14, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1749, 14, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1750, 14, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1751, 14, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1752, 14, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1753, 15, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1754, 15, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1755, 15, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1756, 15, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1757, 15, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1758, 15, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1759, 15, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1760, 15, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1761, 1, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1762, 1, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1763, 1, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1764, 1, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1765, 1, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1766, 1, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1767, 1, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1768, 1, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1769, 2, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1770, 2, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1771, 2, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1772, 2, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1773, 2, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1774, 2, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1775, 2, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1776, 2, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1777, 3, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1778, 3, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1779, 3, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1780, 3, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1781, 3, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1782, 3, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1783, 3, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1784, 3, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1785, 4, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1786, 4, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1787, 4, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1788, 4, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1789, 4, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1790, 4, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1791, 4, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1792, 4, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1793, 12, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1794, 12, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1795, 12, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1796, 12, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1797, 12, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1798, 12, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1799, 12, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1800, 12, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1801, 10, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1802, 10, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1803, 10, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1804, 10, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1805, 10, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1806, 10, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1807, 10, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1808, 10, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1809, 11, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1810, 11, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1811, 11, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1812, 11, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1813, 11, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1814, 11, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1815, 11, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1816, 11, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1817, 8, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1818, 8, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1819, 8, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1820, 8, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1821, 8, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1822, 8, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1823, 8, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1824, 8, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1825, 6, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1826, 6, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1827, 6, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1828, 6, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1829, 6, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1830, 6, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1831, 6, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1832, 6, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1833, 14, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1834, 14, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1835, 14, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1836, 14, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1837, 14, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1838, 14, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1839, 14, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1840, 14, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1841, 15, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1842, 15, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1843, 15, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1844, 15, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1845, 15, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1846, 15, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1847, 15, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1848, 15, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1849, 1, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1850, 1, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1851, 1, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1852, 1, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1853, 1, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1854, 1, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1855, 1, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1856, 1, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1857, 2, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1858, 2, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1859, 2, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1860, 2, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1861, 2, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1862, 2, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1863, 2, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1864, 2, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1865, 3, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1866, 3, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1867, 3, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1868, 3, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1869, 3, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1870, 3, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1871, 3, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1872, 3, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1873, 4, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1874, 4, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1875, 4, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1876, 4, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1877, 4, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1878, 4, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1879, 4, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1880, 4, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1881, 12, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1882, 12, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1883, 12, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1884, 12, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1885, 12, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1886, 12, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1887, 12, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1888, 12, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1889, 10, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1890, 10, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1891, 10, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1892, 10, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1893, 10, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1894, 10, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1895, 10, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1896, 10, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `wf_dt_app_map_lvl` (`wf_id`, `wf_app_map_lvl_id`, `lvl_sequence`, `wf_lvl`, `wf_dept_id`, `wf_desg_id`, `created_date`, `skip_status`, `revoke_level_id`, `solc_id`, `cld_id`, `ho_org_id`, `org_id`, `emp_doc_id`, `doc_id`) VALUES
(1897, 11, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1898, 11, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1899, 11, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1900, 11, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1901, 11, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1902, 11, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1903, 11, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1904, 11, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1905, 8, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1906, 8, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1907, 8, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1908, 8, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1909, 8, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1910, 8, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1911, 8, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1912, 8, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1913, 6, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1914, 6, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1915, 6, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1916, 6, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1917, 6, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1918, 6, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1919, 6, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1920, 6, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1921, 14, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1922, 14, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1923, 14, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1924, 14, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1925, 14, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1926, 14, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1927, 14, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1928, 14, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1929, 15, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1930, 15, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1931, 15, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1932, 15, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1933, 15, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1934, 15, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1935, 15, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1936, 15, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1937, 1, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1938, 1, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1939, 1, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1940, 1, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1941, 1, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1942, 1, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1943, 1, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1944, 1, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1945, 2, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1946, 2, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1947, 2, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1948, 2, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1949, 2, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1950, 2, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1951, 2, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1952, 2, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1953, 3, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1954, 3, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1955, 3, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1956, 3, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1957, 3, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1958, 3, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1959, 3, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1960, 3, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1961, 4, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1962, 4, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1963, 4, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1964, 4, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1965, 4, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1966, 4, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1967, 4, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1968, 4, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1969, 12, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1970, 12, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1971, 12, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1972, 12, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1973, 12, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1974, 12, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1975, 12, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1976, 12, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1977, 10, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1978, 10, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1979, 10, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1980, 10, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1981, 10, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1982, 10, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1983, 10, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1984, 10, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1985, 11, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1986, 11, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1987, 11, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1988, 11, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1989, 11, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1990, 11, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1991, 11, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1992, 11, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1993, 8, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1994, 8, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1995, 8, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1996, 8, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1997, 8, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1998, 8, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(1999, 8, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(2000, 8, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(2001, 6, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(2002, 6, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(2003, 6, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(2004, 6, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(2005, 6, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(2006, 6, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(2007, 6, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(2008, 6, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(2009, 14, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(2010, 14, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(2011, 14, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(2012, 14, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(2013, 14, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(2014, 14, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(2015, 14, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(2016, 14, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(2017, 15, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(2018, 15, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(2019, 15, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(2020, 15, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(2021, 15, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(2022, 15, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(2023, 15, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(2024, 15, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-11-06', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(2025, 1, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-11-09', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(2026, 1, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-11-09', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(2027, 1, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-11-09', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(2028, 1, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-11-09', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(2029, 1, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-11-09', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(2030, 1, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-11-09', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(2031, 1, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-11-09', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(2032, 1, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-11-09', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(2033, 2, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-11-09', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(2034, 2, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-11-09', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(2035, 2, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-11-09', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(2036, 2, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-11-09', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(2037, 2, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-11-09', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(2038, 2, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-11-09', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(2039, 2, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-11-09', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(2040, 2, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-11-09', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(2041, 3, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-11-09', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(2042, 3, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-11-09', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(2043, 3, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-11-09', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(2044, 3, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-11-09', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(2045, 3, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-11-09', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(2046, 3, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-11-09', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(2047, 3, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-11-09', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(2048, 3, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-11-09', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(2049, 4, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-11-09', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(2050, 4, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-11-09', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(2051, 4, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-11-09', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(2052, 4, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-11-09', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(2053, 4, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-11-09', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(2054, 4, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-11-09', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(2055, 4, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-11-09', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(2056, 4, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-11-09', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(2057, 12, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-11-09', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(2058, 12, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-11-09', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(2059, 12, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-11-09', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(2060, 12, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-11-09', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(2061, 12, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-11-09', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(2062, 12, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-11-09', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(2063, 12, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-11-09', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(2064, 12, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-11-09', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(2065, 10, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-11-09', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(2066, 10, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-11-09', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(2067, 10, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-11-09', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(2068, 10, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-11-09', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(2069, 10, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-11-09', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(2070, 10, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-11-09', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(2071, 10, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-11-09', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(2072, 10, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-11-09', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(2073, 11, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-11-09', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(2074, 11, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-11-09', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(2075, 11, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-11-09', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(2076, 11, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-11-09', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(2077, 11, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-11-09', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(2078, 11, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-11-09', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(2079, 11, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-11-09', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(2080, 11, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-11-09', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(2081, 8, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-11-09', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(2082, 8, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-11-09', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(2083, 8, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-11-09', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(2084, 8, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-11-09', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(2085, 8, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-11-09', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(2086, 8, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-11-09', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(2087, 8, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-11-09', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(2088, 8, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-11-09', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(2089, 6, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-11-09', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(2090, 6, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-11-09', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(2091, 6, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-11-09', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(2092, 6, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-11-09', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(2093, 6, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-11-09', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(2094, 6, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-11-09', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(2095, 6, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-11-09', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(2096, 6, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-11-09', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(2097, 14, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-11-09', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(2098, 14, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-11-09', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(2099, 14, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-11-09', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(2100, 14, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-11-09', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(2101, 14, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-11-09', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(2102, 14, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-11-09', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(2103, 14, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-11-09', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(2104, 14, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-11-09', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(2105, 15, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-11-09', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(2106, 15, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-11-09', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(2107, 15, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-11-09', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(2108, 15, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-11-09', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(2109, 15, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-11-09', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(2110, 15, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-11-09', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(2111, 15, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-11-09', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(2112, 15, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-11-09', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(2113, 1, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-11-09', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(2114, 1, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-11-09', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(2115, 1, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-11-09', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(2116, 1, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-11-09', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(2117, 1, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-11-09', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(2118, 1, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-11-09', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(2119, 1, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-11-09', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(2120, 1, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-11-09', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(2121, 2, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-11-09', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(2122, 2, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-11-09', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(2123, 2, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-11-09', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(2124, 2, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-11-09', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(2125, 2, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-11-09', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(2126, 2, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-11-09', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(2127, 2, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-11-09', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(2128, 2, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-11-09', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(2129, 3, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-11-09', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(2130, 3, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-11-09', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(2131, 3, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-11-09', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(2132, 3, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-11-09', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(2133, 3, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-11-09', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(2134, 3, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-11-09', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(2135, 3, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-11-09', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(2136, 3, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-11-09', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(2137, 4, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-11-09', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(2138, 4, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-11-09', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(2139, 4, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-11-09', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(2140, 4, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-11-09', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(2141, 4, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-11-09', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(2142, 4, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-11-09', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(2143, 4, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-11-09', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(2144, 4, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-11-09', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(2145, 12, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-11-09', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(2146, 12, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-11-09', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(2147, 12, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-11-09', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(2148, 12, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-11-09', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(2149, 12, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-11-09', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(2150, 12, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-11-09', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(2151, 12, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-11-09', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(2152, 12, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-11-09', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(2153, 10, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-11-09', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(2154, 10, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-11-09', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(2155, 10, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-11-09', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(2156, 10, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-11-09', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(2157, 10, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-11-09', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(2158, 10, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-11-09', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(2159, 10, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-11-09', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(2160, 10, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-11-09', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(2161, 11, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-11-09', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(2162, 11, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-11-09', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(2163, 11, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-11-09', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(2164, 11, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-11-09', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(2165, 11, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-11-09', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(2166, 11, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-11-09', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(2167, 11, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-11-09', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(2168, 11, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-11-09', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(2169, 8, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-11-09', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(2170, 8, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-11-09', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(2171, 8, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-11-09', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(2172, 8, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-11-09', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(2173, 8, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-11-09', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(2174, 8, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-11-09', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(2175, 8, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-11-09', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(2176, 8, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-11-09', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(2177, 6, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-11-09', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(2178, 6, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-11-09', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(2179, 6, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-11-09', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(2180, 6, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-11-09', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(2181, 6, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-11-09', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(2182, 6, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-11-09', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(2183, 6, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-11-09', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(2184, 6, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-11-09', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(2185, 14, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-11-09', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(2186, 14, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-11-09', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(2187, 14, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-11-09', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(2188, 14, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-11-09', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(2189, 14, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-11-09', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(2190, 14, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-11-09', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(2191, 14, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-11-09', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(2192, 14, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-11-09', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(2193, 15, 1, 'Level1', 'DEPT00005', 'PAR0000034', '2017-11-09', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(2194, 15, 2, 'Level2', 'DEPT00011', 'PAR0000030', '2017-11-09', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(2195, 15, 3, 'Level3', 'DEPT00011', 'PAR0000012', '2017-11-09', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(2196, 15, 4, 'Level4', 'DEPT00020', 'PAR0000002', '2017-11-09', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(2197, 15, 5, 'Level5', 'DEPT00006', 'PAR0000001', '2017-11-09', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(2198, 15, 6, 'Level6', 'DEPT00007', 'PAR0000022', '2017-11-09', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(2199, 15, 7, 'Level7', 'DEPT00020', 'PAR0000001', '2017-11-09', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL),
(2200, 15, 8, 'Level8', 'DEPT00002', 'PAR0000007', '2017-11-09', 0, 9, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `wf_mst_app_map_lvl`
--

CREATE TABLE `wf_mst_app_map_lvl` (
  `wf_id` int(11) NOT NULL,
  `wf_app_id` int(11) DEFAULT NULL,
  `wf_max_lvl` int(11) DEFAULT NULL,
  `wf_dept_id` varchar(40) DEFAULT NULL,
  `created_date` date DEFAULT NULL,
  `comp_code` int(40) DEFAULT NULL,
  `wf_hr_approval` int(11) NOT NULL,
  `review_degree` int(22) DEFAULT NULL,
  `rv_dgr` int(10) NOT NULL,
  `solc_id` varchar(25) DEFAULT NULL,
  `cld_id` varchar(22) DEFAULT NULL,
  `ho_org_id` varchar(22) DEFAULT NULL,
  `org_id` varchar(22) DEFAULT NULL,
  `emp_doc_id` varchar(52) DEFAULT NULL,
  `doc_id` varchar(52) DEFAULT NULL,
  `manager_approval` int(10) DEFAULT NULL,
  `hr_approval` int(10) DEFAULT NULL,
  `sepc_approval` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `wf_mst_app_map_lvl`
--

INSERT INTO `wf_mst_app_map_lvl` (`wf_id`, `wf_app_id`, `wf_max_lvl`, `wf_dept_id`, `created_date`, `comp_code`, `wf_hr_approval`, `review_degree`, `rv_dgr`, `solc_id`, `cld_id`, `ho_org_id`, `org_id`, `emp_doc_id`, `doc_id`, `manager_approval`, `hr_approval`, `sepc_approval`) VALUES
(1, 1, 2, 'DEPT00006', NULL, 1, 1, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(2, 2, 3, 'DEPT00006', NULL, 1, 1, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL),
(3, 3, 3, 'DEPT00006', NULL, 1, 1, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL),
(4, 4, 3, 'DEPT00006', '2015-09-19', 1, 1, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(5, 12, 2, 'DEPT00006', '2015-11-26', 1, 0, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(6, 10, 5, 'DEPT00006', '2015-11-26', 1, 0, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(7, 11, 5, 'DEPT00006', '2015-11-26', 1, 0, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(8, 8, 3, 'DEPT00006', NULL, 1, 0, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(9, 6, 3, 'DEPT00006', '2015-12-04', 1, 0, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(10, 14, 1, 'DEPT00006', NULL, 1, 0, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(11, 15, 1, 'DEPT00006', NULL, 1, 0, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `wf_mst_status`
--

CREATE TABLE `wf_mst_status` (
  `id` int(11) NOT NULL,
  `status_name` varchar(50) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `wf_mst_status`
--

INSERT INTO `wf_mst_status` (`id`, `status_name`, `status`, `created_date`) VALUES
(1, 'Open', 1, '2015-07-22'),
(2, 'Forwarded', 1, '2015-07-22'),
(3, 'Reverted', 1, '2015-07-22'),
(4, 'Rejected', 1, '2015-07-22'),
(5, 'Approved', 1, '2015-07-22'),
(6, 'Pending at HR', 1, '2015-08-13'),
(7, 'Parked', 1, '2015-11-19'),
(8, 'Posted', 1, '2015-11-19');


INSERT INTO `live_db`.`users` (`id`, `comp_code`, `emp_code`, `emp_id`, `user_name`, `user_password`, `email`, `created`, `modified`, `status`, `session_id`, `last_login`, `token`) VALUES (NULL, '01', '0', '0', 'admin', 'b5bfd997acb37317902ded4df5e7bfdb31df2b7d', NULL, '2017-11-11 11:11:04', '2017-11-15 11:26:41', '0', NULL, NULL, NULL);

INSERT INTO `live_db`.`myprofile` (`id`, `doc_id`, `emp_code`, `emp_id`, `dept_code`, `desg_code`, `emp_grp_id`, `emp_nm_ttl`, `emp_firstname`, `emp_middle`, `emp_lastname`, `emp_full_name`, `comp_code`, `gender`, `contact`, `personal_phone`, `dob`, `join_date`, `image`, `cur_address`, `cur_city_id`, `cur_phone`, `cur_landline`, `cur_state_id`, `cur_country_id`, `cur_pincode`, `per_address`, `per_city_id`, `per_state_id`, `per_country_id`, `per_phone`, `per_landline`, `per_pincode`, `region_id`, `marital_code`, `blood_group`, `wedding_date`, `status`, `modified_date`, `card_no`, `location_code`, `emp_pay_mode`, `bank_code`, `branch_code`, `account_type`, `account_no`, `ifsc_code`, `swift_code`, `pan_no`, `guardian_name`, `guardian_relation`, `manager_code`, `notice_period`, `father_name`, `mother_name`, `son`, `pf_no`, `ess_no`, `config`, `per_email`) VALUES (NULL, '0000.01.01.0003.07Pp.00.1UI4QT0jbQ', '0', '0', NULL, NULL, '0', NULL, 'Admin', NULL, 'Admin', 'Admin', '01', '0', '0', '0', '1984-12-18', '2013-06-17', NULL, '91A/UB JAWAHAR NAGAR DELHI-110007     ', NULL, NULL, NULL, NULL, NULL, NULL, '91A/UB JAWAHAR NAGAR DELHI-110007     ', NULL, NULL, NULL, '0', NULL, NULL, NULL, '81', NULL, NULL, '32', NULL, '0', '0', '42', '1', '1', 'S', '05891050293181', 'S', 'S', 'ANSPG4030B', 'j', NULL, '983', '90', NULL, NULL, NULL, '', '', NULL, NULL);


--
-- Indexes for dumped tables
--

--
-- Indexes for table `acl_rights_types`
--
ALTER TABLE `acl_rights_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `acos`
--
ALTER TABLE `acos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_acos_lft_rght` (`lft`,`rght`),
  ADD KEY `idx_acos_alias` (`alias`);

--
-- Indexes for table `admin_options`
--
ALTER TABLE `admin_options`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin_option_org`
--
ALTER TABLE `admin_option_org`
  ADD PRIMARY KEY (`id`),
  ADD KEY `admin_options_id` (`admin_options_id`);

--
-- Indexes for table `applications`
--
ALTER TABLE `applications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `application_constrains`
--
ALTER TABLE `application_constrains`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `appraisal_development_plan`
--
ALTER TABLE `appraisal_development_plan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `appraisal_process`
--
ALTER TABLE `appraisal_process`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `appraisal_req`
--
ALTER TABLE `appraisal_req`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `app_appraisers`
--
ALTER TABLE `app_appraisers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `app_comments`
--
ALTER TABLE `app_comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `app_eo_mst`
--
ALTER TABLE `app_eo_mst`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `app_factors`
--
ALTER TABLE `app_factors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `app_factors_map`
--
ALTER TABLE `app_factors_map`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `app_kras`
--
ALTER TABLE `app_kras`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `app_ratings`
--
ALTER TABLE `app_ratings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `app_slabs`
--
ALTER TABLE `app_slabs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `app_slab_categories`
--
ALTER TABLE `app_slab_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `aros`
--
ALTER TABLE `aros`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_aros_lft_rght` (`lft`,`rght`),
  ADD KEY `idx_aros_alias` (`alias`);

--
-- Indexes for table `aros_acos`
--
ALTER TABLE `aros_acos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_aco_id` (`aco_id`);

--
-- Indexes for table `assign_competency_dept_desg`
--
ALTER TABLE `assign_competency_dept_desg`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `assign_competency_to_emp`
--
ALTER TABLE `assign_competency_to_emp`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `assign_comp_to_emp_details`
--
ALTER TABLE `assign_comp_to_emp_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `assign_desgination_kras`
--
ALTER TABLE `assign_desgination_kras`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `assign_group_to_desg`
--
ALTER TABLE `assign_group_to_desg`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `assign_group_to_desg_details`
--
ALTER TABLE `assign_group_to_desg_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `assign_group_to_desg_id` (`assign_group_to_desg_id`);

--
-- Indexes for table `attendance_details`
--
ALTER TABLE `attendance_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `attendance_detail_dtl`
--
ALTER TABLE `attendance_detail_dtl`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `attendance_with_location`
--
ALTER TABLE `attendance_with_location`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `attribute_type`
--
ALTER TABLE `attribute_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `audit_trail`
--
ALTER TABLE `audit_trail`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bm_data_type`
--
ALTER TABLE `bm_data_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bm_data_type_details`
--
ALTER TABLE `bm_data_type_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bm_meeting_request`
--
ALTER TABLE `bm_meeting_request`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bm_meeting_request_refnum`
--
ALTER TABLE `bm_meeting_request_refnum`
  ADD PRIMARY KEY (`id`),
  ADD KEY `meeting_request_id` (`meeting_request_id`);

--
-- Indexes for table `bm_receive_request`
--
ALTER TABLE `bm_receive_request`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bm_receive_request_forward`
--
ALTER TABLE `bm_receive_request_forward`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bm_recruitment_final`
--
ALTER TABLE `bm_recruitment_final`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bm_report_type_attachment`
--
ALTER TABLE `bm_report_type_attachment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bm_report_type_attach_files`
--
ALTER TABLE `bm_report_type_attach_files`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bm_request_details`
--
ALTER TABLE `bm_request_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bm_title`
--
ALTER TABLE `bm_title`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `catagory`
--
ALTER TABLE `catagory`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cities`
--
ALTER TABLE `cities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `city_group`
--
ALTER TABLE `city_group`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `city_master`
--
ALTER TABLE `city_master`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `competency`
--
ALTER TABLE `competency`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `competency_rating`
--
ALTER TABLE `competency_rating`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `competency_target`
--
ALTER TABLE `competency_target`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `competency_type`
--
ALTER TABLE `competency_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `compitency_behaviour`
--
ALTER TABLE `compitency_behaviour`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `comp_off_leave_trans`
--
ALTER TABLE `comp_off_leave_trans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `conveyence_workflow`
--
ALTER TABLE `conveyence_workflow`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `database_config`
--
ALTER TABLE `database_config`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`),
  ADD KEY `dept_code` (`dept_code`),
  ADD KEY `id_2` (`id`);

--
-- Indexes for table `dependent_details`
--
ALTER TABLE `dependent_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `myprofile_id` (`myprofile_id`);

--
-- Indexes for table `documents`
--
ALTER TABLE `documents`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `url` (`url`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `documents_request`
--
ALTER TABLE `documents_request`
  ADD PRIMARY KEY (`id`),
  ADD KEY `doc_id` (`document_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `document_cat_lists`
--
ALTER TABLE `document_cat_lists`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dt_course_details`
--
ALTER TABLE `dt_course_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dt_employee_sal_mon`
--
ALTER TABLE `dt_employee_sal_mon`
  ADD PRIMARY KEY (`id`),
  ADD KEY `employee_sal_mon_id` (`employee_sal_mon_id`);

--
-- Indexes for table `dt_exp_voucher`
--
ALTER TABLE `dt_exp_voucher`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dt_ext_trainer`
--
ALTER TABLE `dt_ext_trainer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dt_training_attendence`
--
ALTER TABLE `dt_training_attendence`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dt_travel_voucher`
--
ALTER TABLE `dt_travel_voucher`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employee_sal_details`
--
ALTER TABLE `employee_sal_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `myprofile_id` (`myprofile_id`);

--
-- Indexes for table `employee_sal_mon`
--
ALTER TABLE `employee_sal_mon`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employee_sal_proc`
--
ALTER TABLE `employee_sal_proc`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employee_sal_proc_ded`
--
ALTER TABLE `employee_sal_proc_ded`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employee_sal_proc_sal`
--
ALTER TABLE `employee_sal_proc_sal`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `emp_address`
--
ALTER TABLE `emp_address`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `emp_documents`
--
ALTER TABLE `emp_documents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `myprofile_id` (`myprofile_id`);

--
-- Indexes for table `emp_edu`
--
ALTER TABLE `emp_edu`
  ADD PRIMARY KEY (`id`),
  ADD KEY `myprofile_id` (`myprofile_id`);

--
-- Indexes for table `emp_events`
--
ALTER TABLE `emp_events`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `emp_exp`
--
ALTER TABLE `emp_exp`
  ADD PRIMARY KEY (`id`),
  ADD KEY `myprofile_id` (`myprofile_id`);

--
-- Indexes for table `emp_incr_arr`
--
ALTER TABLE `emp_incr_arr`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `emp_invest`
--
ALTER TABLE `emp_invest`
  ADD PRIMARY KEY (`id`),
  ADD KEY `Fy_id` (`Fy_id`);

--
-- Indexes for table `emp_invest_dtl`
--
ALTER TABLE `emp_invest_dtl`
  ADD PRIMARY KEY (`id`),
  ADD KEY `emp_invest_id` (`emp_invest_id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `financial_year`
--
ALTER TABLE `financial_year`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fnfs`
--
ALTER TABLE `fnfs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fnf_details`
--
ALTER TABLE `fnf_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fnf_workflows`
--
ALTER TABLE `fnf_workflows`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `group_competency`
--
ALTER TABLE `group_competency`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `group_weightage`
--
ALTER TABLE `group_weightage`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hcm_ded`
--
ALTER TABLE `hcm_ded`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hcm_desg_prf`
--
ALTER TABLE `hcm_desg_prf`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hcm_group_master`
--
ALTER TABLE `hcm_group_master`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hd_training_sessions`
--
ALTER TABLE `hd_training_sessions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `help_desk_dtl`
--
ALTER TABLE `help_desk_dtl`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `holiday`
--
ALTER TABLE `holiday`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `icon`
--
ALTER TABLE `icon`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `icon_user`
--
ALTER TABLE `icon_user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `myprofile_id` (`myprofile_id`);

--
-- Indexes for table `important_doc_category`
--
ALTER TABLE `important_doc_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `import_log`
--
ALTER TABLE `import_log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `installer_info`
--
ALTER TABLE `installer_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `install_country`
--
ALTER TABLE `install_country`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `invest_dtl`
--
ALTER TABLE `invest_dtl`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kpi_map_emps`
--
ALTER TABLE `kpi_map_emps`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kpi_masters`
--
ALTER TABLE `kpi_masters`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kpi_type`
--
ALTER TABLE `kpi_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kra_comp_overall_rating`
--
ALTER TABLE `kra_comp_overall_rating`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kra_kpi_process`
--
ALTER TABLE `kra_kpi_process`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kra_kpi_slab`
--
ALTER TABLE `kra_kpi_slab`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kra_map_emp`
--
ALTER TABLE `kra_map_emp`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kra_masters`
--
ALTER TABLE `kra_masters`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kra_priorities`
--
ALTER TABLE `kra_priorities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kra_rating`
--
ALTER TABLE `kra_rating`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kra_slabs`
--
ALTER TABLE `kra_slabs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kra_target`
--
ALTER TABLE `kra_target`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kra_type`
--
ALTER TABLE `kra_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `labels`
--
ALTER TABLE `labels`
  ADD PRIMARY KEY (`id`),
  ADD KEY `label_block_id` (`label_block_id`);

--
-- Indexes for table `label_block`
--
ALTER TABLE `label_block`
  ADD PRIMARY KEY (`id`),
  ADD KEY `label_page_id` (`label_page_id`);

--
-- Indexes for table `label_page`
--
ALTER TABLE `label_page`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `leave_configuration`
--
ALTER TABLE `leave_configuration`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `leave_details`
--
ALTER TABLE `leave_details`
  ADD PRIMARY KEY (`leave_detail_id`);

--
-- Indexes for table `leave_encashment_workflow`
--
ALTER TABLE `leave_encashment_workflow`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `leave_encsh`
--
ALTER TABLE `leave_encsh`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `leave_encsh_dt`
--
ALTER TABLE `leave_encsh_dt`
  ADD PRIMARY KEY (`id`),
  ADD KEY `leave_encsh_id` (`leave_encsh_id`);

--
-- Indexes for table `leave_grp`
--
ALTER TABLE `leave_grp`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `leave_workflow`
--
ALTER TABLE `leave_workflow`
  ADD PRIMARY KEY (`leave_wf_id`);

--
-- Indexes for table `legal_case_details`
--
ALTER TABLE `legal_case_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `case_receive_id` (`case_receive_id`),
  ADD KEY `court_type_id` (`court_type_id`),
  ADD KEY `case_status_id` (`case_status_id`),
  ADD KEY `case_outcome_id` (`case_outcome_id`),
  ADD KEY `court_location_id` (`court_location_id`),
  ADD KEY `case_type_id` (`case_type_id`);

--
-- Indexes for table `legal_case_files`
--
ALTER TABLE `legal_case_files`
  ADD PRIMARY KEY (`id`),
  ADD KEY `case_receive_id` (`case_receive_id`),
  ADD KEY `case_detail_id` (`case_detail_id`);

--
-- Indexes for table `legal_case_outcome`
--
ALTER TABLE `legal_case_outcome`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `legal_case_receive`
--
ALTER TABLE `legal_case_receive`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ministry_id` (`ministry_id`),
  ADD KEY `request_id` (`request_id`),
  ADD KEY `action_officer_id` (`action_officer_id`);

--
-- Indexes for table `legal_case_status_type`
--
ALTER TABLE `legal_case_status_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `legal_case_type`
--
ALTER TABLE `legal_case_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `legal_court_location`
--
ALTER TABLE `legal_court_location`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `legal_court_type`
--
ALTER TABLE `legal_court_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `link_kra_kpi`
--
ALTER TABLE `link_kra_kpi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `local_expence`
--
ALTER TABLE `local_expence`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `logo_master`
--
ALTER TABLE `logo_master`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lta_balance`
--
ALTER TABLE `lta_balance`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lta_bill_amount`
--
ALTER TABLE `lta_bill_amount`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lta_group`
--
ALTER TABLE `lta_group`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lta_leave`
--
ALTER TABLE `lta_leave`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lta_sal`
--
ALTER TABLE `lta_sal`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lta_workflow`
--
ALTER TABLE `lta_workflow`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mailer_master`
--
ALTER TABLE `mailer_master`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `makess_smsstatus`
--
ALTER TABLE `makess_smsstatus`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `medical_bill_amount`
--
ALTER TABLE `medical_bill_amount`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `medical_workflow`
--
ALTER TABLE `medical_workflow`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mgt_group_desg`
--
ALTER TABLE `mgt_group_desg`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mid_reviews`
--
ALTER TABLE `mid_reviews`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ministry`
--
ALTER TABLE `ministry`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mom_assign`
--
ALTER TABLE `mom_assign`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`),
  ADD KEY `department_id` (`department_id`),
  ADD KEY `department_id_2` (`department_id`);

--
-- Indexes for table `mom_assign_emp`
--
ALTER TABLE `mom_assign_emp`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mid` (`mid`);

--
-- Indexes for table `mom_emp_response`
--
ALTER TABLE `mom_emp_response`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mid` (`mid`);

--
-- Indexes for table `mom_topic`
--
ALTER TABLE `mom_topic`
  ADD PRIMARY KEY (`tid`);

--
-- Indexes for table `mom_topic_function`
--
ALTER TABLE `mom_topic_function`
  ADD PRIMARY KEY (`fid`);

--
-- Indexes for table `mst_acl`
--
ALTER TABLE `mst_acl`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mst_code`
--
ALTER TABLE `mst_code`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mst_company`
--
ALTER TABLE `mst_company`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mst_org_id` (`mst_org_id`);

--
-- Indexes for table `mst_course_masters`
--
ALTER TABLE `mst_course_masters`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mst_desg`
--
ALTER TABLE `mst_desg`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mst_emp_exp_voucher`
--
ALTER TABLE `mst_emp_exp_voucher`
  ADD PRIMARY KEY (`voucher_id`);

--
-- Indexes for table `mst_emp_leaves`
--
ALTER TABLE `mst_emp_leaves`
  ADD PRIMARY KEY (`leave_id`);

--
-- Indexes for table `mst_emp_leave_allot`
--
ALTER TABLE `mst_emp_leave_allot`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mst_emp_status`
--
ALTER TABLE `mst_emp_status`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mst_event_types`
--
ALTER TABLE `mst_event_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mst_help_desk`
--
ALTER TABLE `mst_help_desk`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mst_leave_type`
--
ALTER TABLE `mst_leave_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mst_org`
--
ALTER TABLE `mst_org`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mst_promotion_type`
--
ALTER TABLE `mst_promotion_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mst_request`
--
ALTER TABLE `mst_request`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mst_scheme_of_service`
--
ALTER TABLE `mst_scheme_of_service`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mst_signatory`
--
ALTER TABLE `mst_signatory`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mst_terms_of_service`
--
ALTER TABLE `mst_terms_of_service`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mst_trainer_masters`
--
ALTER TABLE `mst_trainer_masters`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mst_training_calenders`
--
ALTER TABLE `mst_training_calenders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mst_training_requests`
--
ALTER TABLE `mst_training_requests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mst_travel_mode_type`
--
ALTER TABLE `mst_travel_mode_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mst_travel_voucher`
--
ALTER TABLE `mst_travel_voucher`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mst_vehical_master`
--
ALTER TABLE `mst_vehical_master`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mst_wheeler_type`
--
ALTER TABLE `mst_wheeler_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `myprofile`
--
ALTER TABLE `myprofile`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notice_periods`
--
ALTER TABLE `notice_periods`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notification_reminder_type`
--
ALTER TABLE `notification_reminder_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `options`
--
ALTER TABLE `options`
  ADD PRIMARY KEY (`id`),
  ADD KEY `options_ibfk_1` (`attribute_type_id`);

--
-- Indexes for table `options_count`
--
ALTER TABLE `options_count`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `option_attribute`
--
ALTER TABLE `option_attribute`
  ADD KEY `options_id` (`options_id`);

--
-- Indexes for table `oracle_app_eo`
--
ALTER TABLE `oracle_app_eo`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `oracle_hcm_dependant_dtl`
--
ALTER TABLE `oracle_hcm_dependant_dtl`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `oracle_hcm_emp_leave`
--
ALTER TABLE `oracle_hcm_emp_leave`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `oracle_hcm_emp_leave_encsh`
--
ALTER TABLE `oracle_hcm_emp_leave_encsh`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `oracle_hcm_emp_loan`
--
ALTER TABLE `oracle_hcm_emp_loan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `oracle_hcm_emp_lta`
--
ALTER TABLE `oracle_hcm_emp_lta`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `oracle_hcm_emp_prf`
--
ALTER TABLE `oracle_hcm_emp_prf`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `oracle_hcm_it_proc`
--
ALTER TABLE `oracle_hcm_it_proc`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `oracle_org`
--
ALTER TABLE `oracle_org`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `oracle_org_hcm_salary`
--
ALTER TABLE `oracle_org_hcm_salary`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `org_hcm_desg_prf`
--
ALTER TABLE `org_hcm_desg_prf`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `org_hcm_leave`
--
ALTER TABLE `org_hcm_leave`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `permissions_acos`
--
ALTER TABLE `permissions_acos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rating`
--
ALTER TABLE `rating`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `request_notification_type`
--
ALTER TABLE `request_notification_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `resignation`
--
ALTER TABLE `resignation`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles_permissions`
--
ALTER TABLE `roles_permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sect_dtl`
--
ALTER TABLE `sect_dtl`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `separations`
--
ALTER TABLE `separations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `separation_workflows`
--
ALTER TABLE `separation_workflows`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `setup_check`
--
ALTER TABLE `setup_check`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `smtp_configuration_type`
--
ALTER TABLE `smtp_configuration_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `specl_managers`
--
ALTER TABLE `specl_managers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `states`
--
ALTER TABLE `states`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `support_email`
--
ALTER TABLE `support_email`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `survey_master`
--
ALTER TABLE `survey_master`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `survey_options`
--
ALTER TABLE `survey_options`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `survey_parameter`
--
ALTER TABLE `survey_parameter`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `survey_question`
--
ALTER TABLE `survey_question`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `survey_record`
--
ALTER TABLE `survey_record`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `target`
--
ALTER TABLE `target`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `task_alert`
--
ALTER TABLE `task_alert`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `task_assigns`
--
ALTER TABLE `task_assigns`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `task_assign_emp`
--
ALTER TABLE `task_assign_emp`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `task_project`
--
ALTER TABLE `task_project`
  ADD PRIMARY KEY (`pid`);

--
-- Indexes for table `task_project_module`
--
ALTER TABLE `task_project_module`
  ADD PRIMARY KEY (`mid`);

--
-- Indexes for table `temp_workflow`
--
ALTER TABLE `temp_workflow`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ticker`
--
ALTER TABLE `ticker`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ticker_user`
--
ALTER TABLE `ticker_user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `myprofile_id` (`myprofile_id`);

--
-- Indexes for table `ticket_category`
--
ALTER TABLE `ticket_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `training_config`
--
ALTER TABLE `training_config`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `training_course_attendence`
--
ALTER TABLE `training_course_attendence`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `training_course_creation`
--
ALTER TABLE `training_course_creation`
  ADD PRIMARY KEY (`course_id`);

--
-- Indexes for table `training_creation`
--
ALTER TABLE `training_creation`
  ADD PRIMARY KEY (`training_id`);

--
-- Indexes for table `training_development`
--
ALTER TABLE `training_development`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `training_employee`
--
ALTER TABLE `training_employee`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `training_parameters`
--
ALTER TABLE `training_parameters`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `training_registrations`
--
ALTER TABLE `training_registrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `training_request`
--
ALTER TABLE `training_request`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `training_schedule_creation`
--
ALTER TABLE `training_schedule_creation`
  ADD PRIMARY KEY (`schedule_id`);

--
-- Indexes for table `training_workflow`
--
ALTER TABLE `training_workflow`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `travel_masters`
--
ALTER TABLE `travel_masters`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `travel_workflow`
--
ALTER TABLE `travel_workflow`
  ADD PRIMARY KEY (`id`);


-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `Unique` (`emp_code`);

--
-- Indexes for table `users_bk`
--
ALTER TABLE `users_bk`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `Unique` (`emp_code`);

--
-- Indexes for table `week_holiday`
--
ALTER TABLE `week_holiday`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `week_holiday_list`
--
ALTER TABLE `week_holiday_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `weightage`
--
ALTER TABLE `weightage`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `weightage_calculation_type`
--
ALTER TABLE `weightage_calculation_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wf_dt_app_map_lvl`
--
ALTER TABLE `wf_dt_app_map_lvl`
  ADD PRIMARY KEY (`wf_id`);

--
-- Indexes for table `wf_mst_app_map_lvl`
--
ALTER TABLE `wf_mst_app_map_lvl`
  ADD PRIMARY KEY (`wf_id`);

--
-- Indexes for table `wf_mst_status`
--
ALTER TABLE `wf_mst_status`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `acl_rights_types`
--
ALTER TABLE `acl_rights_types`
  MODIFY `id` int(25) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `acos`
--
ALTER TABLE `acos`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `admin_options`
--
ALTER TABLE `admin_options`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
--
-- AUTO_INCREMENT for table `admin_option_org`
--
ALTER TABLE `admin_option_org`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `applications`
--
ALTER TABLE `applications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT for table `application_constrains`
--
ALTER TABLE `application_constrains`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `appraisal_development_plan`
--
ALTER TABLE `appraisal_development_plan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `appraisal_process`
--
ALTER TABLE `appraisal_process`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `appraisal_req`
--
ALTER TABLE `appraisal_req`
  MODIFY `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `app_appraisers`
--
ALTER TABLE `app_appraisers`
  MODIFY `id` int(7) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `app_comments`
--
ALTER TABLE `app_comments`
  MODIFY `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `app_eo_mst`
--
ALTER TABLE `app_eo_mst`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `app_factors`
--
ALTER TABLE `app_factors`
  MODIFY `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `app_factors_map`
--
ALTER TABLE `app_factors_map`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `app_kras`
--
ALTER TABLE `app_kras`
  MODIFY `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `app_ratings`
--
ALTER TABLE `app_ratings`
  MODIFY `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `app_slabs`
--
ALTER TABLE `app_slabs`
  MODIFY `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `app_slab_categories`
--
ALTER TABLE `app_slab_categories`
  MODIFY `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `aros`
--
ALTER TABLE `aros`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT for table `aros_acos`
--
ALTER TABLE `aros_acos`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;
--
-- AUTO_INCREMENT for table `assign_competency_dept_desg`
--
ALTER TABLE `assign_competency_dept_desg`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `assign_competency_to_emp`
--
ALTER TABLE `assign_competency_to_emp`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `assign_comp_to_emp_details`
--
ALTER TABLE `assign_comp_to_emp_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `assign_desgination_kras`
--
ALTER TABLE `assign_desgination_kras`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `assign_group_to_desg`
--
ALTER TABLE `assign_group_to_desg`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `assign_group_to_desg_details`
--
ALTER TABLE `assign_group_to_desg_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `attendance_details`
--
ALTER TABLE `attendance_details`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `attendance_detail_dtl`
--
ALTER TABLE `attendance_detail_dtl`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `attendance_with_location`
--
ALTER TABLE `attendance_with_location`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `attribute_type`
--
ALTER TABLE `attribute_type`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `audit_trail`
--
ALTER TABLE `audit_trail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `bm_data_type`
--
ALTER TABLE `bm_data_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `bm_data_type_details`
--
ALTER TABLE `bm_data_type_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `bm_meeting_request`
--
ALTER TABLE `bm_meeting_request`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `bm_meeting_request_refnum`
--
ALTER TABLE `bm_meeting_request_refnum`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `bm_receive_request`
--
ALTER TABLE `bm_receive_request`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `bm_receive_request_forward`
--
ALTER TABLE `bm_receive_request_forward`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `bm_recruitment_final`
--
ALTER TABLE `bm_recruitment_final`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `bm_report_type_attachment`
--
ALTER TABLE `bm_report_type_attachment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `bm_report_type_attach_files`
--
ALTER TABLE `bm_report_type_attach_files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `bm_request_details`
--
ALTER TABLE `bm_request_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `bm_title`
--
ALTER TABLE `bm_title`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `catagory`
--
ALTER TABLE `catagory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT for table `cities`
--
ALTER TABLE `cities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `city_group`
--
ALTER TABLE `city_group`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `city_master`
--
ALTER TABLE `city_master`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `competency`
--
ALTER TABLE `competency`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `competency_rating`
--
ALTER TABLE `competency_rating`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `competency_target`
--
ALTER TABLE `competency_target`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `competency_type`
--
ALTER TABLE `competency_type`
  MODIFY `id` int(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `compitency_behaviour`
--
ALTER TABLE `compitency_behaviour`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `comp_off_leave_trans`
--
ALTER TABLE `comp_off_leave_trans`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `conveyence_workflow`
--
ALTER TABLE `conveyence_workflow`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `countries`
--
ALTER TABLE `countries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=247;
--
-- AUTO_INCREMENT for table `database_config`
--
ALTER TABLE `database_config`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `dependent_details`
--
ALTER TABLE `dependent_details`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `documents`
--
ALTER TABLE `documents`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `documents_request`
--
ALTER TABLE `documents_request`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `document_cat_lists`
--
ALTER TABLE `document_cat_lists`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `dt_course_details`
--
ALTER TABLE `dt_course_details`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `dt_employee_sal_mon`
--
ALTER TABLE `dt_employee_sal_mon`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `dt_exp_voucher`
--
ALTER TABLE `dt_exp_voucher`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `dt_ext_trainer`
--
ALTER TABLE `dt_ext_trainer`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `dt_training_attendence`
--
ALTER TABLE `dt_training_attendence`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `dt_travel_voucher`
--
ALTER TABLE `dt_travel_voucher`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `employee_sal_details`
--
ALTER TABLE `employee_sal_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `employee_sal_mon`
--
ALTER TABLE `employee_sal_mon`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `employee_sal_proc`
--
ALTER TABLE `employee_sal_proc`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `employee_sal_proc_ded`
--
ALTER TABLE `employee_sal_proc_ded`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `employee_sal_proc_sal`
--
ALTER TABLE `employee_sal_proc_sal`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `emp_address`
--
ALTER TABLE `emp_address`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `emp_documents`
--
ALTER TABLE `emp_documents`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `emp_edu`
--
ALTER TABLE `emp_edu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `emp_events`
--
ALTER TABLE `emp_events`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `emp_exp`
--
ALTER TABLE `emp_exp`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `emp_incr_arr`
--
ALTER TABLE `emp_incr_arr`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `emp_invest`
--
ALTER TABLE `emp_invest`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `emp_invest_dtl`
--
ALTER TABLE `emp_invest_dtl`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `financial_year`
--
ALTER TABLE `financial_year`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `fnfs`
--
ALTER TABLE `fnfs`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `fnf_details`
--
ALTER TABLE `fnf_details`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `fnf_workflows`
--
ALTER TABLE `fnf_workflows`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `group_competency`
--
ALTER TABLE `group_competency`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `group_weightage`
--
ALTER TABLE `group_weightage`
  MODIFY `id` int(1) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `hcm_ded`
--
ALTER TABLE `hcm_ded`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `hcm_desg_prf`
--
ALTER TABLE `hcm_desg_prf`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `hcm_group_master`
--
ALTER TABLE `hcm_group_master`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `hd_training_sessions`
--
ALTER TABLE `hd_training_sessions`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `help_desk_dtl`
--
ALTER TABLE `help_desk_dtl`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `holiday`
--
ALTER TABLE `holiday`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `icon`
--
ALTER TABLE `icon`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=313;
--
-- AUTO_INCREMENT for table `icon_user`
--
ALTER TABLE `icon_user`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=166;
--
-- AUTO_INCREMENT for table `important_doc_category`
--
ALTER TABLE `important_doc_category`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `import_log`
--
ALTER TABLE `import_log`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `installer_info`
--
ALTER TABLE `installer_info`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `install_country`
--
ALTER TABLE `install_country`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `invest_dtl`
--
ALTER TABLE `invest_dtl`
  MODIFY `id` int(40) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `kpi_map_emps`
--
ALTER TABLE `kpi_map_emps`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `kpi_masters`
--
ALTER TABLE `kpi_masters`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `kpi_type`
--
ALTER TABLE `kpi_type`
  MODIFY `id` int(1) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `kra_comp_overall_rating`
--
ALTER TABLE `kra_comp_overall_rating`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `kra_kpi_process`
--
ALTER TABLE `kra_kpi_process`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `kra_kpi_slab`
--
ALTER TABLE `kra_kpi_slab`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `kra_map_emp`
--
ALTER TABLE `kra_map_emp`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `kra_masters`
--
ALTER TABLE `kra_masters`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `kra_priorities`
--
ALTER TABLE `kra_priorities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `kra_rating`
--
ALTER TABLE `kra_rating`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `kra_slabs`
--
ALTER TABLE `kra_slabs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `kra_target`
--
ALTER TABLE `kra_target`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `kra_type`
--
ALTER TABLE `kra_type`
  MODIFY `id` int(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `labels`
--
ALTER TABLE `labels`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `label_block`
--
ALTER TABLE `label_block`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `label_page`
--
ALTER TABLE `label_page`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `leave_configuration`
--
ALTER TABLE `leave_configuration`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;
--
-- AUTO_INCREMENT for table `leave_details`
--
ALTER TABLE `leave_details`
  MODIFY `leave_detail_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `leave_encashment_workflow`
--
ALTER TABLE `leave_encashment_workflow`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `leave_encsh`
--
ALTER TABLE `leave_encsh`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `leave_encsh_dt`
--
ALTER TABLE `leave_encsh_dt`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `leave_grp`
--
ALTER TABLE `leave_grp`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `leave_workflow`
--
ALTER TABLE `leave_workflow`
  MODIFY `leave_wf_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `legal_case_details`
--
ALTER TABLE `legal_case_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `legal_case_files`
--
ALTER TABLE `legal_case_files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `legal_case_outcome`
--
ALTER TABLE `legal_case_outcome`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `legal_case_receive`
--
ALTER TABLE `legal_case_receive`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `legal_case_status_type`
--
ALTER TABLE `legal_case_status_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `legal_case_type`
--
ALTER TABLE `legal_case_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `legal_court_location`
--
ALTER TABLE `legal_court_location`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `legal_court_type`
--
ALTER TABLE `legal_court_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `link_kra_kpi`
--
ALTER TABLE `link_kra_kpi`
  MODIFY `id` int(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `local_expence`
--
ALTER TABLE `local_expence`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `logo_master`
--
ALTER TABLE `logo_master`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `lta_balance`
--
ALTER TABLE `lta_balance`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `lta_bill_amount`
--
ALTER TABLE `lta_bill_amount`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `lta_group`
--
ALTER TABLE `lta_group`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `lta_leave`
--
ALTER TABLE `lta_leave`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `lta_sal`
--
ALTER TABLE `lta_sal`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `lta_workflow`
--
ALTER TABLE `lta_workflow`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `mailer_master`
--
ALTER TABLE `mailer_master`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `makess_smsstatus`
--
ALTER TABLE `makess_smsstatus`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `medical_bill_amount`
--
ALTER TABLE `medical_bill_amount`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `medical_workflow`
--
ALTER TABLE `medical_workflow`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `mgt_group_desg`
--
ALTER TABLE `mgt_group_desg`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `mid_reviews`
--
ALTER TABLE `mid_reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ministry`
--
ALTER TABLE `ministry`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `mom_assign`
--
ALTER TABLE `mom_assign`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `mom_assign_emp`
--
ALTER TABLE `mom_assign_emp`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `mom_emp_response`
--
ALTER TABLE `mom_emp_response`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `mom_topic`
--
ALTER TABLE `mom_topic`
  MODIFY `tid` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `mom_topic_function`
--
ALTER TABLE `mom_topic_function`
  MODIFY `fid` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `mst_acl`
--
ALTER TABLE `mst_acl`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `mst_code`
--
ALTER TABLE `mst_code`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `mst_company`
--
ALTER TABLE `mst_company`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `mst_course_masters`
--
ALTER TABLE `mst_course_masters`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `mst_desg`
--
ALTER TABLE `mst_desg`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `mst_emp_exp_voucher`
--
ALTER TABLE `mst_emp_exp_voucher`
  MODIFY `voucher_id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `mst_emp_leaves`
--
ALTER TABLE `mst_emp_leaves`
  MODIFY `leave_id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `mst_emp_leave_allot`
--
ALTER TABLE `mst_emp_leave_allot`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `mst_emp_status`
--
ALTER TABLE `mst_emp_status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `mst_event_types`
--
ALTER TABLE `mst_event_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `mst_help_desk`
--
ALTER TABLE `mst_help_desk`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;
--
-- AUTO_INCREMENT for table `mst_leave_type`
--
ALTER TABLE `mst_leave_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `mst_org`
--
ALTER TABLE `mst_org`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `mst_promotion_type`
--
ALTER TABLE `mst_promotion_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `mst_request`
--
ALTER TABLE `mst_request`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `mst_scheme_of_service`
--
ALTER TABLE `mst_scheme_of_service`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `mst_signatory`
--
ALTER TABLE `mst_signatory`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `mst_terms_of_service`
--
ALTER TABLE `mst_terms_of_service`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `mst_trainer_masters`
--
ALTER TABLE `mst_trainer_masters`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `mst_training_calenders`
--
ALTER TABLE `mst_training_calenders`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `mst_training_requests`
--
ALTER TABLE `mst_training_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `mst_travel_mode_type`
--
ALTER TABLE `mst_travel_mode_type`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `mst_travel_voucher`
--
ALTER TABLE `mst_travel_voucher`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;
--
-- AUTO_INCREMENT for table `mst_vehical_master`
--
ALTER TABLE `mst_vehical_master`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=96;
--
-- AUTO_INCREMENT for table `mst_wheeler_type`
--
ALTER TABLE `mst_wheeler_type`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;
--
-- AUTO_INCREMENT for table `myprofile`
--
ALTER TABLE `myprofile`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `notice_periods`
--
ALTER TABLE `notice_periods`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `notification_reminder_type`
--
ALTER TABLE `notification_reminder_type`
  MODIFY `id` int(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `options`
--
ALTER TABLE `options`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `options_count`
--
ALTER TABLE `options_count`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `oracle_app_eo`
--
ALTER TABLE `oracle_app_eo`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `oracle_hcm_dependant_dtl`
--
ALTER TABLE `oracle_hcm_dependant_dtl`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `oracle_hcm_emp_leave`
--
ALTER TABLE `oracle_hcm_emp_leave`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1047;
--
-- AUTO_INCREMENT for table `oracle_hcm_emp_leave_encsh`
--
ALTER TABLE `oracle_hcm_emp_leave_encsh`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `oracle_hcm_emp_loan`
--
ALTER TABLE `oracle_hcm_emp_loan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;
--
-- AUTO_INCREMENT for table `oracle_hcm_emp_lta`
--
ALTER TABLE `oracle_hcm_emp_lta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `oracle_hcm_emp_prf`
--
ALTER TABLE `oracle_hcm_emp_prf`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8021;
--
-- AUTO_INCREMENT for table `oracle_hcm_it_proc`
--
ALTER TABLE `oracle_hcm_it_proc`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `oracle_org`
--
ALTER TABLE `oracle_org`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100;
--
-- AUTO_INCREMENT for table `oracle_org_hcm_salary`
--
ALTER TABLE `oracle_org_hcm_salary`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `org_hcm_desg_prf`
--
ALTER TABLE `org_hcm_desg_prf`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `org_hcm_leave`
--
ALTER TABLE `org_hcm_leave`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `permissions_acos`
--
ALTER TABLE `permissions_acos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;
--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `rating`
--
ALTER TABLE `rating`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;
--
-- AUTO_INCREMENT for table `request_notification_type`
--
ALTER TABLE `request_notification_type`
  MODIFY `id` int(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `resignation`
--
ALTER TABLE `resignation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `roles_permissions`
--
ALTER TABLE `roles_permissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
--
-- AUTO_INCREMENT for table `sect_dtl`
--
ALTER TABLE `sect_dtl`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `separations`
--
ALTER TABLE `separations`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `separation_workflows`
--
ALTER TABLE `separation_workflows`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `setup_check`
--
ALTER TABLE `setup_check`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `smtp_configuration_type`
--
ALTER TABLE `smtp_configuration_type`
  MODIFY `id` int(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `specl_managers`
--
ALTER TABLE `specl_managers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `states`
--
ALTER TABLE `states`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4121;
--
-- AUTO_INCREMENT for table `support_email`
--
ALTER TABLE `support_email`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `survey_master`
--
ALTER TABLE `survey_master`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `survey_options`
--
ALTER TABLE `survey_options`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=223;
--
-- AUTO_INCREMENT for table `ticker`
--
ALTER TABLE `ticker`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=313;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `week_holiday`
--
ALTER TABLE `week_holiday`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;
--
-- AUTO_INCREMENT for table `week_holiday_list`
--
ALTER TABLE `week_holiday_list`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1753;
--
-- AUTO_INCREMENT for table `wf_dt_app_map_lvl`
--
ALTER TABLE `wf_dt_app_map_lvl`
  MODIFY `wf_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2201;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;



CREATE TABLE IF NOT EXISTS `attendance_wf` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `org_id` int(11) NOT NULL,
  `attendance_id` int(11) NOT NULL,
  `emp_id` varchar(111) NOT NULL,
  `emp_doc_id` varchar(25) NOT NULL,
  `attendance_app_lvl` int(50) NOT NULL,
  `emp_code` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `created_date` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=68 ;
