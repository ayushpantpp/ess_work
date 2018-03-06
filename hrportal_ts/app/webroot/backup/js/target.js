function TargetEdit()
{

$("#popupdialogtarget").dialog({
 title: '',
 
  buttons: {
    "Yes": function() {
	 $( this ).dialog( "close" );
	 $("#rts").empty().html("<center><img src='../img/ajax-loader1.gif' /></center>");

	 $.ajax({
            type: 'POST',
            data: {},
            url: "temp_target_edit_search",
            success: function(data) {
                jQuery("#rts").html(data);
            }
        });
	},
    "No": function() {
	 $( this ).dialog( "close" );
	 $("#rts").empty().html("<center><img src='../img/ajax-loader1.gif' /></center>");

	 $.ajax({
            type: 'POST',
            data: {},
            url: "target_edit_search",
            success: function(data) {
                jQuery("#rts").html(data);
            }
        });
	}
  }
});


}
function TargetView()
{
$("#rts").empty().html("<center><img src='../img/ajax-loader1.gif' /></center>");
   $.ajax({
            type: 'POST',
            data: {},
            url: "target_search",
            success: function(data) {
                jQuery("#rts").html(data);
            }
        });

}


var rowcount=0;
var reveneIncre=0;
var collectionIncre=0;
var expenseIncre=0;


function CheckPreviousAddRow(obj,divid)
{
    rowcount++;
   // rowcount=parseInt(rowcount)+parseInt(1);
      var id = (obj.tot_ctrl.value-1);
      var totalrow=jQuery("#addtargetrow").val();
      AddControl(obj,divid,totalrow,id);
}

function AddControl(obj,divid,totalrow,id)
{
        var str='';
		var Max_Control=150;
		var tot_ctrl = obj.tot_ctrl.value;
                 $("#loaderbtn").empty().html("<img src='../img/ajax-loader.gif' style='height:24px;'/>");
       if(tot_ctrl < Max_Control)
       {
	   var i=parseInt(tot_ctrl);
	   var j=(i+1);
	   var totalrowfound= parseInt(totalrow) + parseInt(1);
	   document.getElementById("addtargetrow").value=totalrowfound;
	   var region_id =$("#region_id").val();
	   var url = 'targetrow/'+totalrowfound+'/'+region_id;
       document.getElementById("add_button").disabled=true;
		   
	   jQuery.get(url, function(data) 
           {
                jQuery("#"+divid).append(data);
                obj.tot_ctrl.value = parseInt(obj.tot_ctrl.value) + 1 ;
		if(obj.tot_ctrl.value==Max_Control)
                {
                        document.getElementById("add_button").disabled=true;
			document.getElementById("remove_button").disabled=false;
		}else{
			document.getElementById("remove_button").disabled=false;
		}
                var add=parseInt(id+1);
                document.getElementById("add_button").disabled=false;
                  $("#loaderbtn").empty().html();        
              });

	}
}  
function RemoveRow(obj)
{
    var str='';
    var i= parseInt(obj.tot_ctrl.value);
    if(i > 1)
    { rowcount--;
            i= i-1;
            var divid=document.getElementById('add_ctrl');
            var totalrow=jQuery("#addtargetrow").val();
            var row=parseInt(totalrow)-1;
            jQuery("#addtargetrow").val(row);
            jQuery('#redRow'+i).remove();
            jQuery("#tot_ctrl").val(i) ;
            document.getElementById("add_button").disabled=false;
			
    }else{
            alert('You can not remove beyond this limit !');
    }
}

 function CheckRegionByCustomerList(obj,fieldid)
 {
	var obj= obj ;
	var region_id =$("#region_id").val();
	var year =$("#year").val();
	var pID = document.getElementsByName("data[vc_project_status]["+fieldid+"]");

	for(var i = 0; i < pID.length; i++) {
	   if(pID[i].checked == true) {
		   project_type = pID[i].value;
	   }
	 }
	 
	$.ajax({
            type: 'POST',
            data: {region_id:region_id,fieldid:fieldid,project_type:project_type,year:year},
            url: "customerlist",
            success: function(data) {
			if(data==0)
			{
				alert("Data already exist, please check to edit case !");
				 $('#region_id')[0].selectedIndex=0;
				return false;
			}
            }
        });
 }


function ProjectType(project_type,fieldid)
{
 var region_id =jQuery("#region_id").val();
 if(region_id=='')
      {
        error="Please select region !\n"  ;
		alert(error);
		return false;
      }
    
	$.ajax({
				type: 'POST',
				data: {region_id:region_id,fieldid:fieldid,project_type:project_type},
				url: "customerlist",
				success: function(data) {
				   jQuery("#cuslist_"+fieldid).html(data);
				}
			});	

}

function OrignalAnnualProjection(obj,fieldid)
{
    var region_id =jQuery("#region_id").val();
    var transaction_no =jQuery("#transaction_no").val();
    var manday =jQuery("#man_day").val();
    var year =jQuery("#year").val();
	var currencyId =jQuery("#currency_id").val();
	var pID = document.getElementsByName("data[vc_project_status]["+fieldid+"]");

	for(var i = 0; i < pID.length; i++) {
	   if(pID[i].checked == true) {
		   project_type = pID[i].value;
	   }
	 }
  // var project_type =jQuery(".vc_project_status_"+fieldid).val();
   /*
   =====When Project/customer  name is  Dropdown List========   
   
   var project_code =jQuery("#project_code_"+fieldid).val();
   var project_name = jQuery("#project_code_"+fieldid+" option:selected").text();*/
   
   var project_code =jQuery("#project_code_"+fieldid).val();
   var project_name = jQuery("#vc_project_name_"+fieldid).val();
   
    error='';
    if(region_id=='')
      {
        error+="Please select region !\n"  ;
      }
      if(currencyId=='')
       {
            error+="Please select currency !\n"  ;
       } 
      if(year=='')
       {
            error+="Please select year !\n"  ;
       }  
        var regexp =/(^[1-9][0-9]*$)/;
        
        if(!regexp.test(manday))
       {
           error+="Please enter man days(Positive Integer Number) !\n"  ;
       
	   } 
	  else if(parseInt(manday) > 100000){
	   
		 error+="Man days integer value must be greater than zero and less than 100000 !\n"  ;	
	   
	   }
        if(project_code=='')
       {
            error+="Please select customer/project !\n"  ;
       } 
        if (error== '')
        {
        } else {
             alert(error);
             return(false);
         }
       
    var totalrowfound='1';
	
	$("#rts").empty().html("<center><img src='../img/ajax-loader1.gif' /></center>");
	 $.ajax({
            type: 'POST',
            data: {region_id:region_id,transaction_no:transaction_no,manday:manday,
			year:year,project_type:project_type,project_code:project_code,
			project_name:project_name,currencyId:currencyId},
            url: "annual_target_add",
            success: function(data) {
                jQuery("#rts").html(data);
            }
        });

}



function CollectionAddRow(obj,divid)
{
      rowcount++;
	  collectionIncre++;
      var id = (obj.collection_tot_ctrl.value-1);
      var totalrow=jQuery("#addcollectionrow").val();
      CollectionAddControl(obj,divid,totalrow,id);
}

function CollectionAddControl(obj,divid,totalrow,id)
{
        var str='';
  	var Max_Control=150;
	var collection_tot_ctrl = obj.collection_tot_ctrl.value;
       if(collection_tot_ctrl < Max_Control)
       {
	   var i=parseInt(collection_tot_ctrl);
	   var j=(i+1);
           var totalrowfound= parseInt(totalrow) + parseInt(1);
           document.getElementById("addcollectionrow").value=totalrowfound;
           var checkid                  = $("#checkid").val();
           var NewRegionId              = $("#new_region_id").val();
          var NewYearId              = $("#new_year_id").val();
	   var url = 'collectionrow/'+totalrowfound+'/'+NewRegionId+'/'+checkid+'/'+NewYearId;
           document.getElementById("collection_add_button").disabled=true;
	   jQuery.get(url, function(data) 
           {
                jQuery("#"+divid).append(data);
                obj.collection_tot_ctrl.value = parseInt(obj.collection_tot_ctrl.value) + 1 ;
		if(obj.collection_tot_ctrl.value==Max_Control)
                {
                        document.getElementById("collection_add_button").disabled=true;
			document.getElementById("collection_remove_button").disabled=false;
		}else{
			document.getElementById("collection_remove_button").disabled=false;
		}
                var add=parseInt(id+1);
                document.getElementById("collection_add_button").disabled=false;
                       
              });

	}
}  
function CollectionRemoveRow(obj,section)
{
    var str='';
    rowcount--;
	collectionIncre--;
    var i= parseInt(obj.collection_tot_ctrl.value);
    if(i > 1)
    {
            i= i-1;
            var divid=document.getElementById('collection_add_ctrl');
            var totalrow=jQuery("#addcollectionrow").val();
            var row=parseInt(totalrow)-1;
            jQuery("#addcollectionrow").val(row);
            jQuery('#collectionredRow'+i).remove();
            jQuery("#collection_tot_ctrl").val(i) ;
            document.getElementById("collection_add_button").disabled=false;
			resetFormAnualTarget(section);
    }else{
            alert('You can not remove beyond this limit !');
    }
}


function RevenueAddRow(obj,divid)
{
      rowcount++;
	  reveneIncre++;
      var id = (obj.revenue_tot_ctrl.value-1);
      var totalrow=jQuery("#addrevenuerow").val();
      RevenueAddControl(obj,divid,totalrow,id);
}

function RevenueAddControl(obj,divid,totalrow,id)
{
        var str='';
  	var Max_Control=150;
	var revenue_tot_ctrl = obj.revenue_tot_ctrl.value;
       if(revenue_tot_ctrl < Max_Control)
       {
	   var i=parseInt(revenue_tot_ctrl);
	   var j=(i+1);
           var totalrowfound= parseInt(totalrow) + parseInt(1);
           document.getElementById("addrevenuerow").value=totalrowfound;
            var checkid                  = $("#checkid").val();
           var NewRegionId              = $("#new_region_id").val();
          var NewYearId              = $("#new_year_id").val();
	   var url = 'revenuerow/'+totalrowfound+'/'+NewRegionId+'/'+checkid+'/'+NewYearId;
           document.getElementById("revenue_add_button").disabled=true;
	   jQuery.get(url, function(data) 
           {
                jQuery("#"+divid).append(data);
                obj.revenue_tot_ctrl.value = parseInt(obj.revenue_tot_ctrl.value) + 1 ;
		if(obj.revenue_tot_ctrl.value==Max_Control)
                {
                        document.getElementById("revenue_add_button").disabled=true;
			document.getElementById("revenue_remove_button").disabled=false;
		}else{
			document.getElementById("revenue_remove_button").disabled=false;
		}
                var add=parseInt(id+1);
                document.getElementById("revenue_add_button").disabled=false;
                       
              });

	}
}  
function RevenueRemoveRow(obj, section)
{
    var str='';
     rowcount--;
	 reveneIncre--;
    var i= parseInt(obj.revenue_tot_ctrl.value);
    if(i > 1)
    {
            i= i-1;
            var divid=document.getElementById('revenue_add_ctrl');
            var totalrow=jQuery("#addrevenuerow").val();
            var row=parseInt(totalrow)-1;
            jQuery("#addrevenuerow").val(row);
            jQuery('#revenueredRow'+i).remove();
            jQuery("#revenue_tot_ctrl").val(i) ;
            document.getElementById("revenue_add_button").disabled=false;
			
			resetFormAnualTarget(section);
			
			
    }else{
            alert('You can not remove beyond this limit !');
    }
}

function ExpenseAddRow(obj,divid)
{
      var id = (obj.expense_tot_ctrl.value-1);
      rowcount++;
	  expenseIncre++;
      var totalrow=jQuery("#addexpenserow").val();
      ExpenseAddControl(obj,divid,totalrow,id);
}

function ExpenseAddControl(obj,divid,totalrow,id)
{
 
    var str='';
  	var Max_Control=150;
	var expense_tot_ctrl = obj.expense_tot_ctrl.value;
       if(expense_tot_ctrl < Max_Control)
       {
	   var i=parseInt(expense_tot_ctrl);
	   var j=(i+1);
           var totalrowfound= parseInt(totalrow) + parseInt(1);
           document.getElementById("addexpenserow").value=totalrowfound;
           
          var checkid                  = $("#checkid").val();
          var NewRegionId              = $("#new_region_id").val();
          var NewYearId              = $("#new_year_id").val();
           
	   var url = 'expenserow/'+totalrowfound+'/'+NewRegionId+'/'+checkid+'/'+NewYearId;
           document.getElementById("expense_add_button").disabled=true;
	   jQuery.get(url, function(data) 
           {
                jQuery("#"+divid).append(data);
                obj.expense_tot_ctrl.value = parseInt(obj.expense_tot_ctrl.value) + 1 ;
		if(obj.expense_tot_ctrl.value==Max_Control)
                {
                        document.getElementById("expense_add_button").disabled=true;
			document.getElementById("expense_remove_button").disabled=false;
		}else{
			document.getElementById("expense_remove_button").disabled=false;
		}
                var add=parseInt(id+1);
                document.getElementById("expense_add_button").disabled=false;
                       
              });

	}
}  
function ExpenseRemoveRow(obj,section)
{
    var str='';
    rowcount--;
	expenseIncre--;
    var i= parseInt(obj.expense_tot_ctrl.value);
    if(i > 1)
    {
            i= i-1;
            var divid=document.getElementById('expense_add_ctrl');
            var totalrow=jQuery("#addexpenserow").val();
            var row=parseInt(totalrow)-1;
            jQuery("#addexpenserow").val(row);
            jQuery('#expenseredRow'+i).remove();
            jQuery("#expense_tot_ctrl").val(i) ;
            document.getElementById("expense_add_button").disabled=false;
			resetFormAnualTarget(section);
			
    }else{
            alert('You can not remove beyond this limit !');
    }
}

/*
 * 
 */
 
 function CheckProjectList(obj,row)
 {
     var total=rowcount;
     var obj= obj ;
     var proId ='project_code_'+row;
     var proValue =$('#'+proId).val();
     var region_id =$("#region_id").val();
     var error='';
     if(region_id=='')
      {
         error="Please select region !\n"  ;
         alert(error);
         return(false);
      }
     for(var i=0;i<row;i++)
      {
          var newproId      ='project_code_'+i;
          var newproValue   =$('#'+newproId).val();
          
          if(parseInt(proValue)===parseInt(newproValue))
           {
               error="Unique name is required !\n"  ; 
               alert(error);
              $('#'+proId)[0].selectedIndex=0;
              return(false);
              }
      }
      for(var i=parseInt(row)+1;i<=rowcount;i++)
      {
          var newproId      ='project_code_'+i;
          var newproValue  =$('#'+newproId).val();
          if(parseInt(proValue)===parseInt(newproValue))
              {
                 error="Unique name is required !\n"  ; 
                 alert(error);
                 $('#'+proId)[0].selectedIndex=0;
                  return(false);
              }
      }
   
 }
 
 
 function getExpenseCalcutale(obj, section, quater, month, row)
 {
   var expenseTypeId        ='expense_id_'+row;
   var manDayRate           = $("#man_day_rate").val();
   var expenseTypeName      = $("#expense_id_"+row+" option:selected").text();
   var ExpenseObjId         = section+'-'+quater+'-'+month+'-'+row;
  
   if(expenseTypeName=="man day exp")
   {
       var expqurval =$('#'+ExpenseObjId).val()*manDayRate;
       
       $('#'+ExpenseObjId).val(expqurval);
       
   }    
    
 }
 function getTotalValue(obj, section, quater, month, row)
 {  
  
     var obj= obj ;
     
     var section= section.toLowerCase();
     
     var quater= quater.toLowerCase();
     
     var month= month.toLowerCase();
     
	 var row = row;
     
     var hiddObjId = section+'-'+quater+'-'+month+'-'+row+'-hidd'; 
     
     var hiddValue = $('#'+hiddObjId).val();
     
     
     var columnTotalId  = section+'-'+quater+'-'+month+'-total';
     
     var columnTotalIdHidd  = section+'-'+quater+'-'+month+'-total-hidd';
     
     
     var rowTotalId =section+'-row-'+row+'-total';
     
     var rowTotalIdHidd = rowTotalId+'-hidd';
     
     var rowfinaltotalId =section+'-row-final-total'; 
     
     //var regexp =/^[0-9]+$/;
var regexp = /^-?\d+$/	; 
	 var total = 0;
	 
	 var rowTotal= 0;
	 
	 var totalRowfinal =0;
	 
	 
	if(!regexp.test($(obj).val()))
	{
	    if( $(obj).val() == '' ){
			
			$(obj).val(0);
		
		}else {
			
			$(obj).val(hiddValue);
			
			//return false;
		
		}
	
	}
   
	$('.'+section+'-'+month).each(function(){
		
		swap = 0;
		
		if( $(this).val() == '' || $(this).val() == NaN  || $(this).val() == 0  ) {

			swap = 0;


		}else {
		
			swap  = $(this).val();
		
		}
		
		total += parseFloat(swap);

	});
			
			$('.'+section+'-'+row).each(function(){
				
				swap = 0;
				
				if( $(this).val() == '' || $(this).val() == NaN  ) {

					swap = 0;


				}else {
				
					swap  = $(this).val();
					
					rowTotal += parseFloat(swap);
				
				}
				
				

			});
			
			
			
			/***** Click Object Id Hidden*******/ 
			$('#'+hiddObjId).val($(obj).val());



			/***********Column End Total Id*******************/
			$('#'+columnTotalId).val(parseFloat(total));
			$('#'+columnTotalIdHidd).val(parseFloat(total));



			/***********Row End Total Id*******************/
			$('#'+rowTotalId).val(parseFloat(rowTotal)); 
			$('#'+rowTotalIdHidd).val(parseFloat(rowTotal)); 
			
			
			/**********Final Row Total***************************/
			
			$('.'+section+'-final').each(function(){
				
				swap = 0;
				
				if( $(this).val() == '' || $(this).val() == NaN || $(this).val() == 0  ) {

					swap = 0;


				}else {
				
					swap  = $(this).val();
					
					totalRowfinal += parseFloat(swap);
				
				}
				
				

			});
			
			$('#'+rowfinaltotalId).val(parseFloat(totalRowfinal)); 
	 
	 
	 
	 /*===================  Calculate Margin Quartetr BY Month ==================================*/
	 getMarginTotalValue();
     
 }
 
 
 function getMarginTotalValue()
 {  
      var month= [['jan','q1'],['feb','q1'],['mar','q1'],['apr','q2'],['may','q2'],['june','q2'],['july','q3'],['aug','q3'], ['sept','q3'],['oct','q4'],['nov','q4'],['dec','q4']];
      for(i=0; i< month.length;i++)
		{
			newmonth = month[i];
			var et=$("#expense-"+newmonth[1]+"-"+newmonth[0]+"-total").val();
			var rt=$("#revenue-"+newmonth[1]+"-"+newmonth[0]+"-total").val();
			if( rt != '') 
			{
				rt=$("#revenue-"+newmonth[1]+"-"+newmonth[0]+"-total").val();
			}else{
					rt=0;
				 }
			 if( et != '') {
					et=$("#expense-"+newmonth[1]+"-"+newmonth[0]+"-total").val();
			 }else{
					et=0;
			 }
	
			 var diff=parseFloat(rt)-parseFloat(et);
			 $("#margin-"+newmonth[1]+"-"+newmonth[0]+"-total").val(diff);
                          if(diff < 0)
                          {   
                            $("#margin-"+newmonth[1]+"-"+newmonth[0]+"-total").css('color','Red');
                          }else{
                               $("#margin-"+newmonth[1]+"-"+newmonth[0]+"-total").css('color','');
                          }
		}	
		
			var finalEt=$("#expense-row-final-total").val();
			var finalRt=$("#revenue-row-final-total").val();
			if( finalRt != '') 
			{
				finalRt=$("#revenue-row-final-total").val();
			}else{
					finalRt=0;
				 }
			 if( finalEt != '') {
					finalEt=$("#expense-row-final-total").val();
			 }else{
					finalEt=0;
			 }
	
			 var diff=parseFloat(finalRt)-parseFloat(finalEt);
			 $("#margin-q-mon-total").val(diff);
                         if(diff < 0)
                          {   
                            $("#margin-q-mon-total").css('color','Red');
                          }else{
                              $("#margin-q-mon-total").css('color','');
                          }
}
 
function resetFormAnualTarget(section){

		var section= section.toLowerCase(); 
		
		var month= [['jan','q1'],['feb','q1'],['mar','q1'],['apr','q2'],['may','q2'],['june','q2'],['july','q3'],['aug','q3'], ['sept','q3'],['oct','q4'],['nov','q4'],['dec','q4']];
		
		var totalRowfinal = 0;
		
		var rowfinaltotalId =section+'-row-final-total'; 
		
		for(i=0; i< month.length;i++) {
		
		    total = 0;
			
			newmonth = month[i];
			
			$('.'+section+'-'+newmonth[0]).each(function(){
			
				swap = 0;
				
				if( $(this).val() == '' || $(this).val() == NaN  ) {

					swap = 0;


				}else {
				
					swap  = $(this).val();
					
					total += parseFloat(swap);
				
				}
				
				
				

			});	
			
			columnTotalId  = section+'-'+newmonth[1]+'-'+newmonth[0]+'-total';
     
			columnTotalIdHidd  = columnTotalId+'-total-hidd';
			
			/***********Column End Total Id*******************/
			$('#'+columnTotalId).val(parseFloat(total));
			$('#'+columnTotalIdHidd).val(parseFloat(total));
		
		}
		
		
		/**********Final Row Total***************************/
			
			$('.'+section+'-final').each(function(){
				
				swap = 0;
				
				if( $(this).val() == '' || $(this).val() == NaN  ) {

					swap = 0;


				}else {
				
					swap  = $(this).val();
					totalRowfinal += parseFloat(swap);
				
				}
				
				

			});
			
			$('#'+rowfinaltotalId).val(parseFloat(totalRowfinal)); 
			
			/*===================  Calculate Margin Quarter BY Month ==================================*/
			getMarginTotalValue();
	

}
 
 function SectionCheckList(obj,row,section)
 {
     var total=rowcount;
     var obj= obj ;
     var secId =section+'_'+row;
     var secValue =$('#'+secId).val();
     var error='';
   
  
     for(var i=0;i<row;i++)
      {
          var newsecId      =section+'_'+i;
          var newsecValue   =$('#'+newsecId).val();
		  
        if(newsecValue=='')
		{
			error="Please select name !\n"  ;
			alert(error);
			// $('#'+secId)[0].selectedIndex=0;
			return(false);
		}
          if(section=='revenue_id' || section=='collection_id')
            {  
                if(parseInt(secValue)===parseInt(newsecValue))
                 {
					if(section=='revenue_id')
					{
					 error="Revenue parameter type value already used !\n"  ; 
					}else{
					 error="Collection parameter type value already used !\n" ; 
					}	
                    alert(error);
                    $('#'+secId)[0].selectedIndex=0;
                    return(false);
                    }
            }else{
                if(secValue==newsecValue)
                 {
                     error="Expense parameter type value already used !\n"  ; 
                     alert(error);
                    $('#'+secId)[0].selectedIndex=0;
                    return(false);
                    }
            }
      }
      for(var i=parseInt(row)+1;i<=rowcount;i++)
      {
          var newsecId      =section+'_'+i;
          var newsecValue  =$('#'+newsecId).val();
		  
		 if(newsecValue=='')
		{
			 //error="Please Select Name !\n"  ;
			 //alert(error);
			 $('#'+secId)[0].selectedIndex=0;
			//return(false);
		}
        if(section=='revenue_id' || section=='collection_id')
        {  
          if(parseInt(secValue)===parseInt(newsecValue))
              {
                 if(section=='revenue_id')
					{
					 error="Revenue parameter type value already used !\n"  ; 
					}else{
					 error="Collection parameter type value already used !\n" ; 
					}
                 alert(error);
                 $('#'+secId)[0].selectedIndex=0;
                  return(false);
              }
        }else{
            if(secValue==newsecValue)
              {
                 error="Expense parameter type value already used !\n"  ; 
                 alert(error);
                 $('#'+secId)[0].selectedIndex=0;
                  return(false);
              }
             }   
      }
      /*===========================================================*/
        var expenseTypeName      = $("#expense_id_"+row+" option:selected").text();
      if(section=="expense_id" && expenseTypeName =='man day exp')
        {  
          
           var manDayRate           = $("#man_day_rate").val();
           if(expenseTypeName =='man day exp')
            {
                    
                if(confirm("Do you want to reset value to zero?"))
                {    
                    var month= [['jan','q1'],['feb','q1'],['mar','q1'],['apr','q2'],['may','q2'],['june','q2'],['july','q3'],['aug','q3'], ['sept','q3'],['oct','q4'],['nov','q4'],['dec','q4']];
                    for(i=0; i< month.length;i++)
                         {
                                 newmonth = month[i];
                                 $("#expense-"+newmonth[1]+"-"+newmonth[0]+"-"+row).val('0');
                                 getTotalValue(obj, 'expense', newmonth[1], newmonth[0], row)
                         }

                           var select = document.getElementById(secId);
                            for(var i = 0;i < select.options.length;i++)
                            {
                                if(select.options[i].value == secValue ){
                                    select.options[i].selected = true;
                                }
                            }
                }else{
                    $('#'+secId)[0].selectedIndex=0;
                    return false;
                }
                
            }
        }  
 }
 
 /*==========Display the Original Annual projection ================= */

 function ViewOrignalAnnualProjection(obj,project_code,transaction_no,project_name,nu_man_day_rate,regionId,pagetype)
{
	$("#rts").empty().html("<center><img src='../img/ajax-loader1.gif' /></center>");
	 $.ajax({
            type: 'POST',
            data: {transaction_no:transaction_no,project_code:project_code,
			project_name:project_name,nu_man_day_rate:nu_man_day_rate,regionId:regionId,pagetype:pagetype},
            url: "annual_target_view",
            success: function(data) {
                jQuery("#rts").html(data);
            }
        });

}

 function ViewRollingAnnualProjection(obj,project_code,transaction_no,project_name,nu_man_day_rate,regionId,yearId)
{
	$("#rts").empty().html("<center><img src='../img/ajax-loader1.gif' /></center>");
	 $.ajax({
            type: 'POST',
            data: {transaction_no:transaction_no,project_code:project_code,
			project_name:project_name,nu_man_day_rate:nu_man_day_rate,regionId:regionId,yearId:yearId},
            url: "rolling_target_view",
            success: function(data) {
                jQuery("#rts").html(data);
            }
        });

}

 function AddTempRollingAnnualProjection(obj,project_code,transaction_no,project_name,nu_man_day_rate,regionId,yearId,status)
{
	if(status=="add")
	{
		var newurl="rolling_target_add";
	}else{
		var newurl="rolling_target_edit";
	}	
	
	$("#rts").empty().html("<center><img src='../img/ajax-loader1.gif' /></center>");
	 $.ajax({
            type: 'POST',
            data: {transaction_no:transaction_no,project_code:project_code,
			project_name:project_name,nu_man_day_rate:nu_man_day_rate,
			regionId:regionId,yearId:yearId,status:status},
            url: newurl,
            success: function(data) {
                jQuery("#rts").html(data);
            }
        });

}


function EditTempOrignalAnnualProjection(obj,fieldid)
{
    var region_id =jQuery("#region_id").val();
    var transaction_no =jQuery("#transaction_no").val();
    var manday =jQuery("#man_day").val();
    var year =jQuery("#year").val();
	var currency_id =jQuery("#currency_id").val();
	var pID = document.getElementsByName("data[vc_project_status]["+fieldid+"]");

	for(var i = 0; i < pID.length; i++) {
	   if(pID[i].checked == true) {
		   project_type = pID[i].value;
	   }
	 }
  // var project_type =jQuery(".vc_project_status_"+fieldid).val();
    var project_code =jQuery("#project_code_"+fieldid).val();
 
   var project_name = jQuery("#vc_project_code_"+fieldid+" option:selected").text();
    error='';
    if(region_id=='')
      {
        error+="Please select region !\n"  ;
      }
      if(currency_id=='')
      {
        error+="Please select currency !\n"  ;
      }
      if(year=='')
       {
            error+="Please select year !\n"  ;
       }  
        var regexp =/(^[1-9][0-9]*$)/;
        if(!regexp.test(manday))
       {
           error+="Please enter man days(Positive Integer Number) !\n"  ;
       
	   } else if(parseInt(manday) > 100000 ){
	   
		 error+="Man days integer value must be greater than zero and less than 100000 !\n"  ;	
	   
	   }
        if(project_code=='')
       {
            error+="Please select customer/project !\n"  ;
       } 
        if (error== '')
        {
        } else {
             alert(error);
             return(false);
         }
       
    var totalrowfound='1';
	
	//$("#rts").empty().html("<img src='../img/ajax-loader1.gif' />");
	 $.ajax({
            type: 'POST',
            data: {region_id:region_id,transaction_no:transaction_no,manday:manday,
			year:year,project_type:project_type,project_code:project_code,
			project_name:project_name,currency_id:currency_id},
            url: "annual_target_edit",
            success: function(data) {
                jQuery("#rts").html(data);
            }
        });

}

function AddCopyFromOrignalTarget(obj,project_code,transaction_no,project_name,nu_man_day_rate,regionId,yearId,status)
	{
			var newurl="copy_rolling_target_add";
			$("#rts").empty().html("<center><img src='../img/ajax-loader1.gif' /></center>");
			 $.ajax({
					type: 'POST',
					data: {transaction_no:transaction_no,project_code:project_code,
					project_name:project_name,nu_man_day_rate:nu_man_day_rate,
					regionId:regionId,yearId:yearId,status:status},
					url: newurl,
					success: function(data) {
						jQuery("#rts").html(data);
					}
				});
				document.getElementById("AddCopyFromOrignalTargetId").disabled=true;
	}

	
/*================ Start To Actual Annual Target ================================*/	

function AddActualAnnualProjection(obj,project_code,transaction_no,project_name,nu_man_day_rate,regionId,yearId,status)
{
	if(status=="add")
	{
		var newurl="actual_target_add";
	}else{
		var newurl="actual_target_edit";
	}	
	
	$("#rts").empty().html("<center><img src='../img/ajax-loader1.gif' /></center>");
	 $.ajax({
            type: 'POST',
            data: {transaction_no:transaction_no,project_code:project_code,
			project_name:project_name,nu_man_day_rate:nu_man_day_rate,
			regionId:regionId,yearId:yearId,status:status},
            url: newurl,
            success: function(data) {
                jQuery("#rts").html(data);
            }
        });

}


function AddActualCopyFromOrignalTarget(obj,project_code,transaction_no,project_name,nu_man_day_rate,regionId,yearId,status)
	{
			
		   var newurl="actual_copy_target_add";
			if(status=='add')
			{
				$("#AddActualAnnualTagetFrom").css('display','none');	
			}else{
				$("#EditActualAnnualTagetFrom").css('display','none');	
			}
			
			$("#rts").append("<center><img src='../img/ajax-loader1.gif' /></center>");
			 $.ajax({
					type: 'POST',
					data: {transaction_no:transaction_no,project_code:project_code,
					project_name:project_name,nu_man_day_rate:nu_man_day_rate,
					regionId:regionId,yearId:yearId,status:status},
					url: newurl,
					success: function(data) {
						jQuery("#rts").html(data);
					}
				});
				document.getElementById("AddActualCopyFromOrignalTargetId").disabled=true;
	}

 function ViewActualAnnualProjection(obj,project_code,transaction_no,project_name,nu_man_day_rate,regionId,yearId)
{
	$("#rts").empty().html("<center><img src='../img/ajax-loader1.gif' /></center>");
	 $.ajax({
            type: 'POST',
            data: {transaction_no:transaction_no,project_code:project_code,
			project_name:project_name,nu_man_day_rate:nu_man_day_rate,regionId:regionId,yearId:yearId},
            url: "actual_target_view",
            success: function(data) {
                jQuery("#rts").html(data);
            }
        });

}
 
/*================ End To Actual Annual Target ================================*/	
