var rowcount=0;

function validationcheck()
{
     var error ='';
    var region_id =jQuery("#region_id").val();
    if(region_id=='')
      {
        error+="Please select region !\n"  ;
      }    
      if($("#nu_year").val()==0)
      {
        error+="Please select year !\n"  ;
      }
      
      if($("#nu_month").val()==0)
      {
        error+="Please select month !\n"  ;
      }
      
      return error;
}


function CheckPreviousAddRow(obj,divid)
{
     if(validationcheck()!='')
        {
            alert(validationcheck());
            return false;
        } 
      rowcount++;
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
            var year =$("#nu_year").val();
             var month =$("#nu_month").val();
	   var url = 'addrow/'+totalrowfound+'/'+region_id+'/'+year+'/'+month;
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

 


function ProjectType(project_type,fieldid)
{
 var region_id =jQuery("#region_id").val();
 if(region_id=='')
      {
        error="Please select region !\n"  ;
		alert(error);
		return false;
      }
     var month =$("#nu_month").val();
     var year =$("#nu_year").val();
	$.ajax({
				type: 'POST',
				data: {region_id:region_id,fieldid:fieldid,project_type:project_type,year:year,month:month},
				url: "customerlist",
				success: function(data) {
				   jQuery("#cuslist_"+fieldid).html(data);
				}
			});	

}


function CheckRegionByCustomerList(obj,fieldid)
 {
	var obj= obj ;
	var region_id =$("#region_id").val();
	var year =$("#nu_year").val();
	var pID = document.getElementsByName("data[EmpTarget]["+fieldid+"][vc_project_status]");

	for(var i = 0; i < pID.length; i++) {
	   if(pID[i].checked == true) {
		   project_type = pID[i].value;
	   }
	 }
	  var month =$("#nu_month").val();
         if(validationcheck()!='')
        {
            return false;
        }
	$.ajax({
            type: 'POST',
            data: {region_id:region_id,fieldid:fieldid,project_type:project_type,year:year,month:month},
            url: "customerlist",
            success: function(data) {
			if(data==0)
			{
				alert("Data already exist, please check to edit case !");
				 $('#region_id')[0].selectedIndex=0;
				return false;
			}else{
                             jQuery("#cuslist_"+fieldid).html(data);
                        }
            }
        });
 }

 function CheckProjectList(obj,row)
 {
     var total=rowcount;
     var obj= obj ;
     var proId ='vc_project_code_'+row;
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
          var newproId      ='vc_project_code_'+i;
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
          var newproId      ='vc_project_code_'+i;
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

function checkDecimalValue(item,evt) {
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode==46)
        {
            var regex = new RegExp(/\./g)
            var count = $(item).val().match(regex).length;
            if (count > 1)
            {
                return false;
            }
        }
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            return false;
        }
        return true;
    } 


 function addsubmit()
{
    if(validationcheck()!='')
        {
            alert(validationcheck());
            return false;
        } 
        
         if(formvaildation()!='')
        {
            alert(formvaildation());
            return false;
        } 
    var didconfirm = confirm("Are you sure you want to save?");
    if (didconfirm == false) {
        return false;
    } else {
        $('#addtargetempformid').submit();
        return true;
    }
}

function editsubmit()
{
     var mandayValue=0;
     for(var j=0;j<=parseInt($("#countrow").val());j++)
    {
        var mandayId = jQuery("#man_day_" + j).val();
        if (mandayId == 0)
        {
            mandayValue = 0;
            break;
        } else {
            mandayValue = 1;
        }
    }
    var msg ='';
    
    if(mandayValue==0)
     {
         msg+="Please Enter the Man Day !\n"
     }   
     if(msg !='')
         {
             alert(msg);
             return false;
         }
    var didconfirm = confirm("Are you sure you want to save?");
    if (didconfirm == false) {
        return false;
    } else {
        $('#edittargetempformid').submit();
        return true;
    }
}
 
 function formvaildation ()
 {
      var custValue=0; var mandayValue=0;
     for(var j=0;j<=parseInt(rowcount);j++)
    {
        var custId = jQuery("#vc_project_code_" + j).val();
        if (custId == '')
        {
            custValue = 0;
            break;
        } else {
            custValue = 1;
        }

        var mandayId = jQuery("#man_day_" + j).val();
        if (mandayId == 0)
        {
            mandayValue = 0;
            break;
        } else {
            mandayValue = 1;
        }
    }
    var msg ='';
    if(custValue==0)
     {
         msg+="Please select the customer !\n"
     }
    if(mandayValue==0)
     {
         msg+="Please Enter the Man Day !\n"
     }   
      return msg;
 }
 
  function copypreviourmonthsubmit()
{
    if(validationcheck()!='')
        {
            alert(validationcheck());
            return false;
        } 
        
        var region_id =$("#region_id").val();
	var year =$("#nu_year").val();
        var month =$("#nu_month").val();
        $("#copydataprevMonthid").empty().html("<center><img src='../img/ajax-loader1.gif' /></center>");
       $.ajax({
            type: 'POST',
            data: {region_id:region_id,year:year,month:month},
            url: "previousmonthprlisting",
            success: function(data) {
                 data = $.parseJSON(data); 
                 $("#copydataprevMonthid").html(data.view);
                 $("#copypreviourmonthButton").css('display', 'none');
            }
        });
   
}