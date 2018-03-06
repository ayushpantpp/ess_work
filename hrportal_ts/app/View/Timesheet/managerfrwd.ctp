<?php

App::import('Model', 'General');
$General = new General ;
App::import('Component', 'Functions');
// We need to load the class
 $Function = new FunctionsComponent();
?>

<script type="text/javascript">
    function selectmanager(id,url) {
      
        jQuery(document).ready(function(){
            jQuery( "#managername").autocomplete({
                source: url+'/selectempname/region/0',
                minLength: 2,
                select: function( event, ui ) {
                       jQuery('#chk_id').attr('value', ui.item.id);
                },
                open: function() {
                    //jQuery( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
                },
                close: function() {
                    //jQuery( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
                }
            });
            
            jQuery('#managername').change(function( ){
                  if(jQuery('#managername').val().length == 0 )
                     jQuery('#chk_id').attr('value','');
            });

        });
    }



function InvlidEmployee(id){
	if(document.getElementById("chk_id").value!="" && document.getElementById("managernmae").value==""){
		document.getElementById("chk_id").value="";
		document.getElementById("managernmae").focus();
	}else if(document.getElementById("managernmae").value!="" && document.getElementById("chk_id").value==""){
		document.getElementById("managernmae").focus();
	}

}

    </script>

<script language="javascript">
function CheckDetails(obj){

/*myOption = -1;
for (i=document.login.chk_id.length-1; i > -1; i--) {
	if (document.login.chk_id[i].checked) {
	myOption = i; i = -1;
	}
}
*/
	if(document.login.managername.value==''){
		alert("Please enter manager name to forward timesheet");
		return false;
	} else if(document.login.remark.value==''){
		alert("Please enter forward remark");
		document.login.remark.focus;
		return false;
	}else{
		return true;
	}
}

</script>
<form method="post" name="login" action="tslistunfilled"  onSubmit="return CheckDetails(this);">
<?php    
         $EmailStr='';
         for($i=0;$i<$numEmpTs;$i++){
               $EmailStr .=$rwEmp['VC_LOGIN_NAME'][$i].'@essindia.co.in'.',';
       } ?>
<div id="redRow">
      <h4 style="color:dodgerblue;">Please enter manager name to forward timesheet</h4>

<table width="100%" cellspacing="1" cellpadding="5" border="0" class="exp-voucher">
  <tr class="cont1">
    <th>Manager Name : </th>
       <td valign="top" id='customer1'>
                            <input  type="text" id="managername" name="managernmae"  onselectstart='javascript:return false;' value="" onKeyDown="selectmanager('0','<?php echo $this->webroot . 'Timesheet' ?>');" onBlur="InvlidEmployee('emp_id' , 'emp_name');"  class="textBox"/>
			<INPUT type="hidden" id="chk_id" name="chk_id"value="" style="font-size: 10px; width: 20px;"  readonly/>
                         </td>
</tr>

<tr class="cont1">
      <th>Forward Remarks : </th>
      <td><textarea rows="10" cols="50" name="remark"></textarea>

      <input type="hidden" name="stdate" value="<?php echo $stdate; ?>" />
      <input type="hidden" name="eddate" value="<?php echo $eddate;?>" />
      <input type="hidden" name="s_ids" value="<?php echo $empval;?>">
      </td>
</tr>


      

</table>

</div>

    <div class="submit-form">
              <input type="submit" value="Forward" name="trExpRpAp" /></div>
</form>