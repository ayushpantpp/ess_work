//Validation points for reports. 
  function check_validation(){

	var $region = $('#CompanyRegion').val();
	var $calendar_year = $('#CompanyCalendarYear').val();
	var $error='';
    if($region==''){
        $error+="Please select the Region.\n"  ;
      }
    if($calendar_year==''){
            $error+="Please select the Calendar Year.\n"  ;
    }  
	if ($error== ''){

	}else {
		 alert($error);
		 return(false);
	 }
  } 
/*Added by Vijay on 23/07/2013 for calendar year validation*/  
function validateForm(){
var calendaryear = document.getElementById("calyear").value;
var calendarMonth = document.getElementById("calmonth").value;

    var $error='';
    if(calendaryear==''){
        $error+="Please select the Calendar Year.\n"  ;
      }
    if(calendarMonth==''){
            $error+="Please select the Calendar Month.\n"  ;
    }  
	if ($error== ''){

	}else {
		 alert($error);
		 return(false);
	 }

}

/*Added by Vijay on 23/07/2013 for Region and calendar year validation*/
function validatebudgetvsActualForm(){
var calendaryear = document.getElementById("calyear").value;
var regionOption = document.getElementById("regionOption").value;

var $error='';
	if(regionOption==''){
        $error+="Please select Region.\n"  ;
      }
    if(calendaryear==''){
        $error+="Please select the Calendar Year.\n"  ;
      }
      
	if ($error== ''){
	return true;
	}else {
		 alert($error);
		 return(false);
	 }

}

//Validation points for reports. 
  function validation_rsummary(){
    
	var $comp_code = $('#compcode').val();
	var $region = $('#CompanyRegion').val();
	var $calendar_month = $('#CompanyCalendarMonth').val();
	var $calendar_year = $('#CompanyCalendarYear').val();
	var $figures = $('#CompanyFiguresIn').val();
	var $error='';
        var $div_factor = 1;
        var $PrecisionIn = $('#PrecisionIn').val();
        var $finyear = $('#fin-year-id').val();
    if($region==''){
        $error+="Please select the Region.\n"  ;
      }
    if($calendar_month==''){
            $error+="Please select the Calendar Month.\n"  ;
    }  
	if($calendar_year==''){
            $error+="Please select the Calendar Year.\n"  ;
    }  
	if ($error== ''){
     var $url='';
	 var $htmlfile ="C:/test.html";
	 $htmlfile =encodeURIComponent($htmlfile);
         $pdffile = "D:/ebiz/sales/reports/bil_rep_lac.rdf";
         $pdffile =encodeURIComponent($pdffile);
	 
         
           if($figures=='THOUSANDS'){
		 $div_factor = 1000;
	  }else if($figures=='LACS'){
		$div_factor = 100000;
	 }else {
		$div_factor = 1;		
	 }
     $host = 'http://203.122.58.133:9002';
	 $reportserver = 'RptSvr_essindia_asinst_1';
     $url =$host+'/reports/rwservlet?report='+$pdffile+'+comp_Code='+$comp_code+'+month='+$calendar_month+'+region='+$region+'+year='+$calendar_year+'+div_factor='+$div_factor+'+per='+$PrecisionIn+'+fin_year='+$finyear+'+server='+$reportserver+'+userid=ebiz/ebiz@orcl+destype=cache+desformat=pdf+desname='+$htmlfile+'';		
		
	   window.open($url, '_blank');
	   return(false);
	}else {
		 alert($error);
		 return(false);
	 }
  } 
  
  
  
  //Validation points for reports. 
  function validation_resionwisesummary(){
    
	var $comp_code = $('#compcode').val();
	var $region = $('#MstTargetZones').val();
	var $calendar_month = $('#calmonth').val();
	var $calendar_year = $('#calyear').val();
	var $figures = $('#figures_in').val();
	var $error='';
    if($region==''){
        $error+="Please select the Region.\n"  ;
      }
    if($calendar_month==''){
            $error+="Please select the Calendar Month.\n"  ;
    }  
	if($calendar_year==''){
            $error+="Please select the Calendar Year.\n"  ;
    }  
	if ($error== ''){
     var $url='';
	 var $htmlfile ="C:/test.html";
	 $htmlfile =encodeURIComponent($htmlfile);
	  if($figures=='ASITIS'){
		  $pdffile = "D:/ebiz/sales/reports/bil_rep.rdf";
		  $pdffile =encodeURIComponent($pdffile);
	  }else{
		$pdffile = "D:/ebiz/sales/reports/bil_rep_lac.rdf";
		$pdffile =encodeURIComponent($pdffile);
	 }
	  
	 //http://hp4520-57:8889/reports/rwservlet?report=D:/ebiz/sales/reports/bil_rep.rdf+comp_Code=01+month=01+region=J001+year=2014+server=hp4520-57+userid=finance/finance@bill+destype=cache+desformat=pdf+desname=C%3A%2Ftest.html
	 
	 
	 $url ='http://hp4520-57:8889/reports/rwservlet?report='+$pdffile+'+comp_Code='+$comp_code+'+month='+$calendar_month+'+region='+$region+'+year='+$calendar_year+'+server=hp4520-57+userid=finance/finance@bill+destype=cache+desformat=pdf+desname='+$htmlfile+'';		
	   window.open($url, '_blank');
	   return(false);
	}else {
		 alert($error);
		 return(false);
	 }
  } 