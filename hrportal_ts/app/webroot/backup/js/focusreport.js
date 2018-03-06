//Validation points for reports. 
  function check_validation(passval){

	var $region = $('#CompanyRegion').val();
	var $calendar_year = $('#CompanyCalendarYear').val();
	var $manger = $('#CompanyVcMgrName').val();
	var $quarter = $('#CompanyQuarter').val();
	var $error='';
    if($region==''){
        $error+="Please select the Region.\n";
      }
	if(passval !='CPR'){
		if($manger=='' && $region==''){
			$error+="Please select the project manager.\n";
		 }
		 if($manger=='' && $region !=''){
			$error+="There is no project manager exists in the selected region.\n";
		 }
	 }
	 if($quarter==''){
        $error+="Please select the Quarter .\n";
     }
    if($calendar_year==''){
            $error+="Please select the Fin Year.\n";
    }  
	if ($error== ''){

	}else {
		 alert($error);
		 return(false);
	 }
  }