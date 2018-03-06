/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
 function auto_comp_name(elemt_id) {
   //alert(elemt_id);
	var companyID = document.getElementsByName("data[Salesdetails][company_id]");
	//alert(elemt_id);
	for(var i = 0; i < companyID.length; i++) {
	   if(companyID[i].checked == true) {
		   company_name = companyID[i].value;
	   }
	 }
	//alert(region_id);alert(year);
	var msg='';
     
	if (msg== ''){
	  var url ='';
        jQuery(document).ready(function(){
		    $("#loader_"+elemt_id).empty().html("<img src='../img/ajax-loader.gif' style='height:20px;'/>");
            jQuery( "#vc_project_code_"+elemt_id ).autocomplete({
                source:'autosuggestion?compname='+region_id+'&year='+year+'&project_type='+project_type,
                minLength: 2,
                select: function( event, ui ){
					jQuery('#project_code_'+elemt_id).val(ui.item.id);
					jQuery('#vc_project_name_'+elemt_id).val(ui.item.value);
					$("#loader_"+elemt_id).empty().html();
					if(CheckProjectListAutosuggestion(elemt_id)=='U'){
					  ui.item.value='';
					  jQuery('#vc_project_name_'+elemt_id).val(ui.item.value);
					  jQuery('#project_code_'+elemt_id).val(ui.item.id);
					}
                }
            });
        });
	}else {
		 alert(msg);
		 return(false);
	 }
	 
  }
  
  function CheckProjectListAutosuggestion(row)
  {
     var total=rowcount;
     var proId ='project_code_'+row;
     var proValue =$('#'+proId).val();
     var region_id =$("#region_id").val();
     var error='';
     if(region_id=='')
      {
         error="Please select region !\n"  ;
         alert(error);
         return "U";
      }
     for(var i=0;i<row;i++)
      {
          var newproId      ='project_code_'+i;
		  
          var newproValue   =$('#'+newproId).val();
          
          if(parseInt(proValue)===parseInt(newproValue))
           {
			error="Unique name is required !\n"  ; 
			alert(error);
			$('#'+proId).val('');
               return "U";
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
                $('#'+proId).val('');
                  return "U";
              }
      }
   
 }
 
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

        function CheckPreviousAddRow(obj,divid,type,saleid,newurl)
        {
              var addRowID ='add-'+type+'-row';
              var id = (obj.tot_milestone_ctrl.value-1);
              var totalrow=$("#"+addRowID).val();
              AddControl(obj,divid,totalrow,id,addRowID,saleid,newurl);
        }

 /*============================ ADD THE CONTRACT PAGE FOR ADD THE ROW MILESTONE ============================*/		
        function AddControl(obj,divid,totalrow,id,addRowID,saleid,newurl)
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
                            url: newurl+"salesdetails/contactrow/"+saleid,
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

            }else{
                    alert('You can not remove beyond this limit !');
            }
        }


