 /*********Added by Abhishek Tewari 26th July, 2013********/
 
/***************Parameters List*******************/
$( document ).ready(function() {
  $('#showExcelDiv').hide(0);
});

function showParametersReport(){
      parametersId = $('#parameterDropDown :selected').val();
	  parametersVal = $('#parameterDropDown :selected').text();

	var url = 'show_parameters_list/'+ parametersVal +','+ parametersId;
    var excel_url="<?php echo $html->url(array('controller'=>'reports', 'action'=>'parameters_list_excel'));?>"+'/'+ parametersVal +','+ parametersId;
	$('#showExcelDiv').show(0);
	jQuery.get(url, function(data) 
    {  
        jQuery("#parameters").html(data);
		jQuery("#link_excel").attr('href',excel_url);
	
	});
}

/***************Prospect List*******************/

function showProspectReport(){
	var regionsId = $('#vc_region_code :selected').val();
	var regionsVal = $('#vc_region_code :selected').text();
	
    var url = 'show_prospects_list/'+ regionsId + ","+ regionsVal;
	var excel_url="<?php echo $html->url(array('controller'=>'reports', 'action'=>'prospects_list_excel'));?>"+'/'+ regionsId + ","+ regionsVal;
	$('#showExcelDiv').show(0);
	jQuery.get(url, function(data) 
    {  
        jQuery("#prospects").html(data);
		jQuery("#link_excel").attr('href',excel_url);
	
	});
}
/************************END***********************/

/*********Invoice Advice for Coming Month**********/
function showInvoiceReport(){ 
	var regionsId = $('#CompanyRegion :selected').val();
	var regionsVal = $('#CompanyRegion :selected').text();
	var calenderMonthId = $('#CompanyCalenderMonth :selected').val();
	var calenderMonthVal = $('#CompanyCalenderMonth :selected').text();
	
	if(regionsId == ""){
	  alert("Please select Region");
	  return false;
	 }
	if(calenderMonthId == ""){
		alert("Please select a month");
	}
    var url = 'show_invoice_advice_for_coming_month/'+ regionsId + ","+ regionsVal+ ","+ calenderMonthVal;
	var excel_url="<?php echo $html->url(array('controller'=>'reports', 'action'=>'invoice_advice_for_coming_month_excel'));?>"+'/'+ regionsId + ","+ regionsVal+ "," + calenderMonthVal;
	$('#showExcelDiv').show(0);
	jQuery.get(url, function(data) 
    {  
        jQuery("#invoice").html(data);
		jQuery("#link_excel").attr('href',excel_url);
	
	});
}
/************************END***********************/