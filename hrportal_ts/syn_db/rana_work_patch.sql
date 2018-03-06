CREATE TABLE `hrportal`.`sync_status` ( `id` INT(11) NOT NULL AUTO_INCREMENT ,  `sync_value` VARCHAR(255) NOT NULL ,  `created` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ,    PRIMARY KEY  (`id`)) ENGINE = InnoDB;

-- Addded new column in users table
ALTER TABLE `users` ADD `portal_status` TINYINT(1) NOT NULL DEFAULT '1' AFTER `login_ip`;

-- chnages in attendence details table

ALTER TABLE `attendance_details` CHANGE `is_od` `is_od` TINYINT(1) NULL DEFAULT NULL;


ALTER TABLE `attendance_details` ADD `is_pgp` TINYINT(1) NULL DEFAULT NULL AFTER `hr_code`, ADD `od_minutes` TIME NULL AFTER `is_pgp`, ADD `pgp_minutes` TIME NULL AFTER `od_minutes`;


--new table for attendence logs

CREATE TABLE `attendance_details_log` (
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
  `is_od` tinyint(1) DEFAULT NULL,
  `latitude` varchar(50) DEFAULT NULL,
  `longitude` varchar(50) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `modify_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `hr_approval_status` int(11) DEFAULT NULL,
  `hr_code` varchar(122) DEFAULT NULL,
  `is_pgp` tinyint(1) DEFAULT NULL,
  `od_minutes` time DEFAULT NULL,
  `pgp_minutes` time DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



ALTER TABLE `attendance_details_log`
  ADD PRIMARY KEY (`id`);


ALTER TABLE `attendance_details_log`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--trigger to create attendance_details logs after every update

delimiter // 
begin 
  INSERT INTO attendance_details_log 
  SELECT NULL, 
         `id`, 
         `cld_id` , 
         `sloc_id` , 
         `ho_org_id` , 
         `org_id` , 
         `description` , 
         `emp_doc_id` , 
         `atten_dt` , 
         `leave_id` , 
         `extra_time_hr` , 
         `usr_id_create` , 
         `usr_id_create_dt` , 
         `usr_id_mod` , 
         `usr_id_mod_dt` , 
         `in_time` , 
         `out_time` , 
         `ded_ch` , 
         `wk_off_chk` , 
         `hlfday_leave_chk`, 
         `emp_dept_id` , 
         `emp_grp_id` , 
         `emp_loc_id` , 
         `emp_id` , 
         `add_comp_leave_chk` , 
         `qtr_leave_chk` , 
         `leave_proof_submit_chk` , 
         `status` , 
         `approver_id` , 
         `reject_remark` , 
         `is_od` , 
         `latitude` , 
         `longitude` , 
         `address` , 
         `modify_date` , 
         `hr_approval_status` , 
         `hr_code` , 
         `is_pgp` , 
         `od_minutes` , 
         `pgp_minutes` 
  FROM   attendance_details 
  WHERE  id = old.id;END 
delimiter ;


-- change column type for 

ALTER TABLE `attendance_details` CHANGE `od_minutes` `od_minutes` VARCHAR(10) NULL DEFAULT NULL, CHANGE `pgp_minutes` `pgp_minutes` VARCHAR(10) NULL DEFAULT NULL;

ALTER TABLE `attendance_details_log` CHANGE `od_minutes` `od_minutes` VARCHAR(10) NULL DEFAULT NULL, CHANGE `pgp_minutes` `pgp_minutes` VARCHAR(10) NULL DEFAULT NULL;

ALTER TABLE `attendance_details_log` ADD `attd_id` INT(11) NOT NULL AFTER `id`;



---added two new columns in logo_master

ALTER TABLE `logo_master` ADD `color` VARCHAR(100) NULL AFTER `org_id`, ADD `disclaimer` TEXT NULL AFTER `color`;




-- created new column in wf_mst_events

CREATE TABLE `wf_mst_events` (
  `id` int(11) NOT NULL,
  `status_name` varchar(50) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `wf_mst_events` (`id`, `status_name`, `status`, `created_date`) VALUES
(1, 'Open', 1, '2015-07-22'),
(2, 'Forwarded', 1, '2015-07-22'),
(3, 'Reverted', 1, '2015-07-22'),
(4, 'Rejected', 1, '2015-07-22'),
(5, 'Approved', 1, '2015-07-22'),
(6, 'Pending at HR/Finance', 1, '2015-08-13'),
(7, 'Parked', 1, '2015-11-19'),
(8, 'Posted', 1, '2015-11-19');



ALTER TABLE `mailer_master` CHANGE `body_data` `body_data` TEXT CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL;

ALTER TABLE `mailer_master` ADD `tags` VARCHAR(255) NULL DEFAULT NULL AFTER `body_data`;


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


CREATE TABLE IF NOT EXISTS `attendance_with_location` (
 
 `id` int(11) NOT NULL AUTO_INCREMENT,

  `status` int(11) NOT NULL,
  `latitude` varchar(50) DEFAULT NULL,
 
 `longitude` varchar(50) DEFAULT NULL,
 
 `in_radius` varchar(25) NOT NULL,
 
 `comp_code` varchar(11) NOT NULL,
  `org_id` varchar(11) NOT NULL,
 
 `location_code` varchar(50) NOT NULL,

  `created_date` datetime NOT NULL,
 
 PRIMARY KEY (`id`)
) 

ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;
INSERT INTO `attendance_with_location` (`id`, `status`, `latitude`, `longitude`, `in_radius`, `comp_code`, `org_id`, `location_code`, `created_date`) VALUES
(1, 1, '28.617747', '77.377466', '500', '01', '01', 'PAR0000335', '2017-10-24 10:20:20'),
(11, 1, '23.618467', '75.371941', '500', '01', '01', 'PAR0000364', '2017-10-26 00:00:00');

ALTER TABLE `attendance_details` ADD `latitude` VARCHAR(50) NULL DEFAULT NULL 
AFTER `is_od`, ADD `longitude` VARCHAR(50) NULL 
DEFAULT NULL AFTER `latitude`; 
ALTER TABLE `attendance_details` ADD `address` VARCHAR(255) NULL AFTER `longitude`; 

DROP TRIGGER IF EXISTS `leave_details_after_insert`;
CREATE DEFINER=`root`@`localhost` TRIGGER `leave_details_after_insert` AFTER UPDATE ON `leave_details` 
FOR EACH ROW if (NEW.leave_status = 5) then IF @DISABLE_TRIGGERS IS NULL THEN IF (NEW.solc_id is NULL) THEN 
INSERT INTO newdata VALUES (NEW.`leave_detail_id`,'leave_details','I'); END IF; end if; END IF


CREATE TABLE IF NOT EXISTS `hcmempmonextdtl` (
  `id` int(40) NOT NULL AUTO_INCREMENT,
  `cld_id` varchar(40) DEFAULT NULL,
  `sloc_id` varchar(50) DEFAULT NULL,
  `ho_org_id` varchar(50) DEFAULT NULL,
  `org_id` varchar(20) DEFAULT NULL,
  `doc_id` varchar(40) DEFAULT NULL,
  `emp_doc_id` varchar(40) DEFAULT NULL,
  `proc_frm_dt` date DEFAULT NULL,
  `proc_to_dt` date DEFAULT NULL,
  `rule_type` varchar(5) DEFAULT NULL,
  `rule_rate` varchar(10) DEFAULT NULL,
  `rule_rate_unit` varchar(5) DEFAULT NULL,
  `extra_time_hr` varchar(10) DEFAULT NULL,
  `ttl_days` varchar(10) DEFAULT NULL,
  `usr_id_create` varchar(10) DEFAULT NULL,
  `usr_id_create_dt` date DEFAULT NULL,
  `usr_id_mod` varchar(10) DEFAULT NULL,
  `usr_id_mod_dt` date DEFAULT NULL,
  `ext_time_amt` varchar(26) DEFAULT NULL,
  `ttl_ext_mnt` varchar(10) DEFAULT NULL,
  `rule_sub_type` varchar(20) DEFAULT NULL,
  `extra_time_min` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5590 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;





//bew
ALTER TABLE `dt_exp_voucher` ADD `emp_exp` VARCHAR(10) NULL AFTER `total_exp`;
ALTER TABLE `leave_details` ADD `shrt_type` VARCHAR(10) NULL AFTER `week_off_chk`;

ALTER TABLE `task_project_module` CHANGE `mid` `mid` INT(11) NOT NULL AUTO_INCREMENT;
DROP TRIGGER IF EXISTS `leave_details_after_insert`;
CREATE DEFINER=`root`@`localhost` TRIGGER `leave_details_after_insert` AFTER UPDATE ON `leave_details` 
FOR EACH ROW if (NEW.leave_status = 5) then IF @DISABLE_TRIGGERS IS NULL THEN IF (NEW.solc_id is NULL) THEN 
INSERT INTO newdata VALUES (NEW.`leave_detail_id`,'leave_details','I'); END IF; end if; END IF


CREATE TABLE IF NOT EXISTS `hcmempmonextdtl` (
  `id` int(40) NOT NULL AUTO_INCREMENT,
  `cld_id` varchar(40) DEFAULT NULL,
  `sloc_id` varchar(50) DEFAULT NULL,
  `ho_org_id` varchar(50) DEFAULT NULL,
  `org_id` varchar(20) DEFAULT NULL,
  `doc_id` varchar(40) DEFAULT NULL,
  `emp_doc_id` varchar(40) DEFAULT NULL,
  `proc_frm_dt` date DEFAULT NULL,
  `proc_to_dt` date DEFAULT NULL,
  `rule_type` varchar(5) DEFAULT NULL,
  `rule_rate` varchar(10) DEFAULT NULL,
  `rule_rate_unit` varchar(5) DEFAULT NULL,
  `extra_time_hr` varchar(10) DEFAULT NULL,
  `ttl_days` varchar(10) DEFAULT NULL,
  `usr_id_create` varchar(10) DEFAULT NULL,
  `usr_id_create_dt` date DEFAULT NULL,
  `usr_id_mod` varchar(10) DEFAULT NULL,
  `usr_id_mod_dt` date DEFAULT NULL,
  `ext_time_amt` varchar(26) DEFAULT NULL,
  `ttl_ext_mnt` varchar(10) DEFAULT NULL,
  `rule_sub_type` varchar(20) DEFAULT NULL,
  `extra_time_min` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5590 ;

