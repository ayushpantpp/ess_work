 function auto_cust_name(elemt_id) {
   //alert(elemt_id);
	var pID = document.getElementsByName("data[vc_project_status]["+elemt_id+"]");
	//alert(elemt_id);
	for(var i = 0; i < pID.length; i++) {
	   if(pID[i].checked == true) {
		   project_type = pID[i].value;
	   }
	 }
	var region_id =$("#region_id").val();
	var year =$("#year").val();
	//alert(region_id);alert(year);
	var msg='';
    if(region_id==''){
        msg+="Please select the Region.\n"  ;
      }
    if(year==''){
            msg+="Please select the Year.\n"  ;
    }  
	if (msg== ''){
	  var url ='';
        jQuery(document).ready(function(){
		    $("#loader_"+elemt_id).empty().html("<img src='../img/ajax-loader.gif' style='height:20px;'/>");
            jQuery( "#vc_project_code_"+elemt_id ).autocomplete({
                source:'autosuggestion?region_id='+region_id+'&year='+year+'&project_type='+project_type,
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