 /*============================ ADD THE CONTRACT PAGE FOR DISPLAY ============================*/
	function ContractAdd(contractno)
        {
            $("#rts").empty().html("<center><img src='../img/ajax-loader1.gif' /></center>");
                 $.ajax({
                    type: 'POST',
                    data: {contractno:contractno},
                    url: "contract_add",
                    success: function(data) {
                        $("#rts").html(data);
                    }
                });

        }

 /*============================  ADD THE CONTRACT PAGE FOR ADD THE ROW MILESTONE ============================*/
        var rowcount=0;

        function CheckPreviousAddRow(obj,divid,type)
        {
              var addRowID ='add-'+type+'-row';
              var id = (obj.tot_milestone_ctrl.value-1);
              var totalrow=$("#"+addRowID).val();
              AddControl(obj,divid,totalrow,id,addRowID);
        }

 /*============================ ADD THE CONTRACT PAGE FOR ADD THE ROW MILESTONE ============================*/		
        function AddControl(obj,divid,totalrow,id,addRowID)
        {
            $("#loaderbtn").empty().html("<img src='../img/ajax-loader.gif' style='height:24px;'/>");
			var str='';
            var Max_Control=150;
            var tot_milestone_ctrl = obj.tot_milestone_ctrl.value;
			var milestone_id = $("#milstone_id_"+id).val();
            if(tot_milestone_ctrl < Max_Control)
               {
                  var i=parseInt(tot_milestone_ctrl);
                  var j=(i+1);
                  var totalrowfound= parseInt(totalrow) + parseInt(1);
                  document.getElementById(addRowID).value=totalrowfound;
                  document.getElementById("add_button").disabled=true;
                   $.ajax({
                            type: 'POST',
                            data: {totalrowfound:totalrowfound},
                            url: "milestonerow",
                            success: function(data)
                            {
                                $("#"+divid).append(data);
                                rowcount++;
                                obj.tot_milestone_ctrl.value = parseInt(obj.tot_milestone_ctrl.value) + 1 ;
                                if(obj.tot_milestone_ctrl.value == Max_Control)
                                {
                                    document.getElementById("add_button").disabled=true;
                                    document.getElementById("remove_button").disabled=false;
                                }else{
                                        document.getElementById("remove_button").disabled=false;
                                     }
                                var add=parseInt(id+1);
                                document.getElementById("add_button").disabled=false;
								//$("#milstone_id_"+add).val(parseInt(milestone_id)+parseInt(1));
								$("#loaderbtn").empty().html();
                            }
                });


                }
        }  

 /*============================ ADD THE CONTRACT PAGE FOR REMOVE THE ROW MILESTONE ============================*/		
        function RemoveRow(obj,type)
        {
            var str='';
            var addRowID ='add-'+type+'-row';
            var i= parseInt(obj.tot_milestone_ctrl.value);

            if(i > 1)
            { 
                    i= i-1;
                    var divid=document.getElementById('add_ctrl');
                    var totalrow=$("#"+addRowID).val();
                    var row=parseInt(totalrow)-1;
                    rowcount--;
                    $("#"+addRowID).val(row);
                    $('#NewAddRow'+i).remove();
                    $("#tot_milestone_ctrl").val(i) ;
                    document.getElementById("add_button").disabled=false;
                    calculatesum();

            }else{
                    alert('You can not remove beyond this limit !');
            }
        }
		
 /*============================ ADD THE CONTRACT PAGE FOR LISTING THE EMPLOYEES FOR REGION HAED,GM,PM,SQA HEAD ============================*/		
        function ShowListingTypeEmployees(url,type) 
        {    
             var searchItm = jQuery("#"+type+'_name').val();
	         if(searchItm.length==0){		
                var typeName = type+'_name';
                var typeID = type+'_id';
                jQuery('#'+typeID).val(''); 
				$("#loader_"+type).empty().html("<img src='../img/ajax-loader.gif' style='height:20px;'/>");
                jQuery( "#"+typeName).autocomplete({
                source: 'autosuggestion',
                minLength: 2,
                select: function( event, ui ) {
                    jQuery('#'+typeID).attr('value', ui.item.id);
					$("#loader_"+type).empty().html();
                },
                open: function() {
				jQuery(".ui-autocomplete").css('max-height','400px');
				jQuery(".ui-autocomplete").css('overflow','auto');
                },
                close: function() {
                    jQuery( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
                }
            });
            jQuery('#'+typeName).change(function(){
                if(jQuery('#'+typeName).val().length == 0 )
                    jQuery('#'+typeName).attr('value','');
            });
		}
    }
	
/*============================ ADD THE CONTRACT PAGE FOR VAILDAATION ============================*/	
    function AddContractValidationForm()
     {
              var clientId              =  $('#client_id_hid').val();
              var businessId            =  $('#busnissPartner_id_hid').val();
              var orderrefno            =  $('#order_ref_no').val();
              var orderdate             =  $('#order_date').val();
              var projectcommdate       =  $('#project_comm_date').val();
              var projectid             =  $('#project_id').val();
              var gmname                =  $('#gm_name').val();
              var pmname                =  $('#pm_name').val();
              var services_delv         =  $('#services_delv').val();
              var regheadname           =  $('#reg_head_name').val();
              var productprice          =  $('#product_price').val();
              var advanceprodamt        =  $('#advance_prod_amt').val();
              var sqaheadname           =  $('#sqa_head_name').val();
              var projectstratdate      =  $('#project_strat_date').val();
              var budgetmanmonth        =  $('#budget_man_month').val();
              var projectcoordinator    =  $('#project_coordinator').val();
              var sqaheadId             = $('#sqa_head_id').val();
              var gmId 			= $('#gm_id').val();
              var pmId 			= $('#pm_id').val();
              var regheadId 		= $('#reg_head_id').val();
              var regexp =/(^[0-9]*$)/;
              
              var projectenddate      =  $('#project_end_date').val();
              var error='';
              if(clientId=='')
               {
                    error+="Please select client name.\n"  ; 
               } 
              else if(orderrefno=='')
               {
                    error+="Please enter order reference number.\n"  ; 
               } 
               else if(orderdate=='')
               {
                    error+="Please enter order date.\n"  ; 
	       }
			  
               else if(projectcommdate=='')
               {
                    error+="Please enter commencement date.\n"  ; 
               } 
               /*else if(businessId=='')
               {
                    error+="Please select business partner.\n"  ; 
               } 
               else if(parseInt(clientId)===parseInt(businessId))
                {
                    error+="Business Partner and Client name cannot be same.\n"  ; 
                    $('#busnissPartner_id')[0].selectedIndex=0;
                }*/
                else if(projectid=='')
                {
                     error+="Please enter project id.\n"  ; 
                }else if(!regexp.test(projectid) || (projectid == 0))
                {
                         error+="Please enter project id (Positive Integer Number).\n"  ;
                }
                else if(gmname=='')
                {
                     error+="Please enter general manager.\n"  ; 
                     $('#gm_id').val('');
                }else if(gmId=='')
                {
                    error+="Please enter correct general manager.\n";
                }
                else if(pmname=='')
                {
                     error+="Please enter project manager..\n"  ; 
                     $('#pm_id').val('');
                } else if(pmId=='')
                {
                    error+="Please enter correct project manager.\n";
                }
                else if(services_delv=='')
                {
                     error+="Please enter services/deliveries.\n"  ; 
                }else if(!regexp.test(services_delv))
                {
                         error+="Please enter services/deliveries (Positive Integer Number).\n"  ;
                } 
                else if(regheadname=='')
                {
                     error+="Please enter regional head.\n"  ; 
                     $('#reg_head_id').val('');
                } else if(regheadId=='')
                {
                    error+="Please enter correct regional head.\n";
                }
                else if(productprice=='')
                {
                     error+="Please enter product price.\n"  ; 
                } else if(!regexp.test(productprice))
                {
                         error+="Please enter product price(Positive Integer Number).\n"  ;
                } 
                else if(advanceprodamt=='')
                {
                     error+="Please enter advance product amount.\n"  ; 
                } 
                else if(!regexp.test(advanceprodamt))
                {
                         error+="Please enter advance product amount (Positive Integer Number).\n"  ;
                }
                else if(sqaheadname=='')
                {
                     error+="Please enter SQA head.\n"  ; 
                     $('#sqa_head_id').val('');
                } else if(sqaheadId=='')
                {
                    error+="Please enter correct SQA head.\n";
                }
                else if(projectstratdate=='')
                {
                     error+="Please enter project start date.\n"  ; 
                } 
                else if(projectenddate=='')
                    {
                        error+="Please enter project end date.\n"  ; 
                    }
                else if(budgetmanmonth=='')
                {
                     error+="Please enter budgets man month.\n"  ; 
                }
				/*else if(!regexp.test(budgetmanmonth))
                {
                         error+="Please enter budgets man month (Positive Integer Number).\n"  ;
                }*/

						
                var nameValue=0; var effManDayValue=0; var monthlyRezValue=0; var deliveryRezValue=0;
                var startDateValue=0; var endDateValue =0; var startDateformat =1; var endDateformat=1;
                var checkDateValue =1; var checkNewNameValue =1;var effManDayNumValue=1;
                var monthlyRezNumValue=1; var deliveryNumValue=1;
                var sum =0;
               var rowcount=$("#tot_milestone_ctrl").val();
               for(var j=0;j<parseInt(rowcount);j++)
                {			
                        var nameid =jQuery("#vc_name_"+j).val();
                        if($.trim(nameid)=='')
                        {	
                                nameValue=0; 
                                break;
                        }else{ 	
                                nameValue=1;
                               for(var k=parseInt(j)+1;k<=parseInt(rowcount);k++)
                                {   
                                    var newnameid =jQuery("#vc_name_"+k).val();
                                    if($.trim(nameid) == $.trim(newnameid))
                                     {
                                         checkNewNameValue=0;
                                         break;
                                    }
                                }
                        }

                        var startDateId =jQuery("#dt_strat_date_"+j).val();
                        if(startDateId=='')
                        {	
                                startDateValue=0;
                                break;	
                        } else{ 	
                                startDateValue=1;
                             }
                              
                        var endDateId =jQuery("#dt_end_date_"+j).val();
                        if(endDateId=='')
                        {	
                                endDateValue=0;
                                break;	
                        } else{ 
                                endDateValue=1;
                                
                              }

//                        if (new Date(startDateId).getTime() >= new Date(endDateId).getTime())
//                        {
//                                checkDateValue=1;
//                                break;
//                        }else{
//                                checkDateValue=1;
//                             }
                        var effManDayId =jQuery("#nu_eff_man_days_"+j).val();
                        if(effManDayId=='')
                        {
                                effManDayValue=0;
                                break;
                        }
                        else{ 
                                effManDayValue=1;
                                 if(!regexp.test(effManDayId))
                                    {
                                        effManDayNumValue=0;
                                        break
                                    } 
                            }
                          sum = parseInt(sum)+parseInt(effManDayId);     

                        var monthlyRezid =jQuery("#nu_monthly_realisation_"+j).val();
                        
                        var deliveryRezid =jQuery("#nu_delivery_realisation_"+j).val();
                        
                        if(monthlyRezid=='' && deliveryRezid=='' )
                        {
                                monthlyRezValue=0; break;
                        }else{
                                monthlyRezValue=1;
                                if((!regexp.test(monthlyRezid))&& (!regexp.test(deliveryRezid)))
                                    {
                                        monthlyRezNumValue=0;
                                        break
                                    } 
                             }
                        
                        if(monthlyRezid=='' && deliveryRezid=='' )
                        {
                                deliveryRezValue=0;
                                break;
                        }else{
                                deliveryRezValue=1;
                                if((!regexp.test(monthlyRezid))&& (!regexp.test(deliveryRezid)))
                                    {
                                        deliveryNumValue=0;
                                        break
                                    } 
                             }
                }
               var budgetmanday = parseFloat(budgetmanmonth)*24;
               
               var mandaysum = parseFloat($("#nu_eff_man_days_total").val());
               
               
               var relizationsum    =   parseFloat($("#nu_monthly_realisation_total").val());
               var deliverlysum     =   parseFloat($("#nu_delivery_realisation_total").val());
               
               var totalmilestonesum     = parseFloat(relizationsum)+ parseFloat(deliverlysum);
               //var totalpriceallamt      = parseFloat(services_delv)+parseFloat(productprice)+parseFloat(advanceprodamt);
                var totalpriceallamt      = parseFloat(services_delv)+parseFloat(productprice);
               
                if(parseInt(nameValue)== 0)
                {
                        error+="Please enter name/milestone name.\n"  ;
                }else if(parseInt(checkNewNameValue) == 0)
                {
                     error='Name/Milestone must be unique.\n';
                }else if(parseInt(startDateValue) == 0 )
                {
                        error+="Please enter Start date.\n"  ;
                }

                else if(parseInt(endDateValue) == 0 )
                {
                        error+="Please enter End date.\n"  ;
                }

                else if(parseInt(checkDateValue)==0)
                {
                        error+='End Date cannot be smaller than Start Date.';
                }
                else if(parseInt(effManDayValue) == 0 )
                {
                        error+="Please enter efforts man day.\n"  ;
                } else if(parseInt(effManDayNumValue) == 0 )
                {
                        error+="Please enter efforts man day(Positive Integer Number).\n"  ;
                }
                else if(parseInt(monthlyRezValue) == 0 )
                {
                        error+="Please enter monthly realization/delivery realization.\n"  ;
                }else if(parseInt(monthlyRezNumValue) == 0 )
                {
                        error+="Please enter monthly realization/delivery realization (Positive Integer Number).\n"  ;
                }
                else if(parseInt(deliveryRezValue) == 0 )
                {
                        error+="Please enter  monthly realization/delivery realization.\n"  ;
                }else if(parseInt(deliveryNumValue) == 0 )
                {
                        error+="Please enter  monthly realization/delivery realization(Positive Integer Number).\n"  ;
                }
                
                else if (parseFloat(mandaysum) != parseFloat(budgetmanday) ){
                      error+="Sum of Effort (Man Days) is not equal to the Budget man month.\n"  ;
                }else if(parseFloat(totalmilestonesum) != parseFloat(totalpriceallamt))
                    {
                        error+="Sum of Total Price(Product Price+Services/Deliveries) is not equal to the Sum of Monthly Realization and Delivery Realization .\n"  ;
                    }
                 return error;
      }
	
 /*============================ ADD THE CONTRACT PAGE DATA SAVED ============================*/	
 function AddContractSaveFrom()
        {
			/*======== Validation form check=========*/
			 var error = AddContractValidationForm();
			if (error== '')
			{
                            var rw = confirm("Are you sure,you want to save ?");
                            if (rw ==true){

                             }else{
                                    return false;
                                  }
			} else {
				 alert(error);
				 return false;
                                }
			$("#ContractAddForm").css('display','none');
			$("#rts").append("<center><img src='../img/ajax-loader1.gif' /></center>");
			$.ajax({
						   type: "POST",
						   url: 'contractSave',
						   data: $("#ContractAddForm").serialize(),
						   success: function(response){
						   window.location='index';
				   }		
            });  

        }
 
 

 /*============================  SEARCHING THE CONTRACT PAGE FOR DISPLAY============================*/
        function ContractViewSearch()
        {
            $("#rts").empty().html("<center><img src='../img/ajax-loader1.gif' /></center>");
                 $.ajax({
                    type: 'POST',
                    data: {},
                    url: "contract_view_search",
                    success: function(data) {
                        $("#rts").html(data);
                    }
                });

        }
	
        
  /*============================  VIEW THE CONTRACT PAGE FOR DISPLAY ============================*/       
       function ContractView()
        {
            var client_id =$("#client_id").val();
            var error='';
			
            if(parseInt(client_id) == 0)
              {
                    error+="Please select client name !\n"  ;
              }
            if (error== '')
                    {
                    } else {
                             alert(error);
                             return(false);
                     }
            $("#rts").empty().html("<center><img src='../img/ajax-loader1.gif' /></center>");
                 $.ajax({
                    type: 'POST',
                    data: {client_id:client_id},
                    url: "contract_view",
                    success: function(data) {
                        $("#rts").html(data);
                    }
                });

        }
 


function calculatesum()
{
    var sumdelv=0; var sumrelv=0; var sumeffday=0;
    var rowcount=$("#tot_milestone_ctrl").val();
    for(var j=0;j<parseInt(rowcount);j++)
    {
        if(jQuery("#nu_delivery_realisation_"+j).val()!='')
            {
                 sumdelv   =sumdelv+parseFloat(jQuery("#nu_delivery_realisation_"+j).val());
            }else{
                sumdelv=sumdelv+0;
            }
            
            if(jQuery("#nu_monthly_realisation_"+j).val()!='')
            {
                 sumrelv   =sumrelv+parseFloat(jQuery("#nu_monthly_realisation_"+j).val());
            }else{
                sumrelv=sumrelv+0;
            }
            
             if(jQuery("#nu_eff_man_days_"+j).val()!='')
            {
                 sumeffday   =sumeffday+parseFloat(jQuery("#nu_eff_man_days_"+j).val());
            }else{
                sumeffday=sumeffday+0;
            }
            
    }  
   $("#nu_delivery_realisation_total").val(sumdelv);
   $("#nu_monthly_realisation_total").val(sumrelv);
    $("#nu_eff_man_days_total").val(sumeffday);
    
}

/*============================  Edit THE CONTRACT Search PAGE FOR DISPLAY ============================*/     
function ContractEditSearch()
        {
            $("#rts").empty().html("<center><img src='../img/ajax-loader1.gif' /></center>");
                 $.ajax({
                    type: 'POST',
                    data: {},
                    url: "contract_edit_search",
                    success: function(data) {
                        $("#rts").html(data);
                    }
                });

        }
	
        
  /*============================  Edit THE CONTRACT PAGE FOR DISPLAY ============================*/       
       function ContractEdit()
        {
            var client_id =$("#client_id").val();
            var error='';
			
            if(parseInt(client_id) == 0)
              {
                    error+="Please select client name !\n"  ;
              }
            if (error== '')
                    {
                    } else {
                             alert(error);
                             return(false);
                     }
            $("#rts").empty().html("<center><img src='../img/ajax-loader1.gif' /></center>");
                 $.ajax({
                    type: 'POST',
                    data: {client_id:client_id},
                    url: "contract_edit",
                    success: function(data) {
                        $("#rts").html(data);
                    }
                });

        }
        
        
         /*============================ ADD THE CONTRACT PAGE DATA SAVED ============================*/	
 function EditContractSaveFrom()
        {
			/*======== Validation form check=========*/
			 var error = AddContractValidationForm();
			if (error== '')
			{
                            var rw = confirm("Are you want to save ?");
                            if (rw ==true){

                             }else{
                                    return false;
                                  }
			} else {
				 alert(error);
				 return false;
                                }
			$("#ContractEditForm").css('display','none');
			$("#rts").append("<center><img src='../img/ajax-loader1.gif' /></center>");
			$.ajax({
						   type: "POST",
						   url: 'editContractSave',
						   data: $("#ContractEditForm").serialize(),
						   success: function(response){
						   window.location='index';
				   }		
            });  

        }
		
		
		
		
		 function UpdateCostingsheetwithContractFrom()
        {
			/*======== Validation form check=========*/
			 var error = AddContractValidationForm();
			if (error== '')
			{
                            var rw = confirm("Are you want to save ?");
                            if (rw ==true){

                             }else{
                                    return false;
                                  }
			} else {
				 alert(error);
				 return false;
                                }
			$("#ContractEditForm").css('display','none');
			$("#rts").append("<center><img src='../img/ajax-loader1.gif' /></center>");
			$.ajax({
						   type: "POST",
						   url: 'updateCostingSheetWithContractForm',
						   data: $("#ContractEditForm").serialize(),
						   success: function(response){
						   window.location='index';
				   }		
            });  

        }