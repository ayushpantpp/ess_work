<?php

/*

* EPCH- Export Promotion Council for Handicrafts.
* Copyright (C) 2011



* File Name: app/controllers/components/errormsg.php

* Author Name: Anil Singh

* Creation Date: 04 Merch 2011

* Modification Date : 

* Modified By : 

* Description: The file is a component file which contains all functions 

*               for handling error display.

*/

class ErrormsgComponent extends object{

	// Get Error list w r t lang.

    function getErrorList($ln,$conname=NULL){

	$arr['SUCCESS']="Inserted Successfully.";

	$arr['LAPPLYSUCCESS']="Leave applied successfully";
	$arr['LAPPLYUNSUCCESS']="Leave apllication fail.Please try later or contact site admin";

	$arr['LSANCSUCCESS']	="Leave sanctioned successfully.";
	$arr['LSANCUNSUCCESS']	="Leave sanction fail.Please try later or contact site admin";



        $arr['REJECT']="Voucher Rejected Successfully.";
        $arr['APPROVED']="Voucher Approved Successfully.";
        $arr['SANCTION']="Voucher Approved Successfully.";



	$arr['UNSUCCESS']="Bad Bad Server!!.Please try later or contact ESS.";
	$arr['ALLREDYEXIST']="Duplicate record found!! ".$conname." Already exist!";
	$arr['UPDATE']="Updated successfully.";
	$arr['USERNAMEVALIDATE']="Please enter valid password.";
	$arr['PASSWORDVALIDATE']="Password must be at least 5 characters long.";
	$arr['ALTERNATEVALIDATE']="Please enter valid alternate email address.";
	$arr['REMOVE']="Removed successfully.";
    $arr['NOMEMBER']="Member is not exist.";
	$arr['EXPENSE']="Recomded amount not greater than to max amount";
      

	return $arr[$ln];
    }
}