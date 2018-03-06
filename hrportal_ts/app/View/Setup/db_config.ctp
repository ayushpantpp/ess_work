
<div id="page_content">
<p>Welcome To eBizframe 10 ESS Portal Installation</p>
<table width="100%" border="0" cellspacing="1" cellpadding="5" class="exp-voucher">
  
    <tr class="cont">
        <td> TYPE : <select name="db_type" id = "db_type" onChange = "return getConfig(this.value)">
		<option value = ''>Select Connection Type</option>
                        <option value = 'HCM'>HCM</option>
                        <option value = 'APP'>APP</option>
        </select></td>
        <td>HOST HCM : <input type="text" name="db_host" id = "db_host" ></input></td>   
        <td>PORT HCM : <input type="text" name="db_port" id = "db_port" ></input></td>
        <td width='5%'>SID : <input type="text" name="db_sid" id = "db_sid" ></input></td>   
        <td>DB USER NAME : <input type="text" name="db_name" id = "db_name" ></input></td> 
        <td>DB Password : <input type="password" name="db_pass" id = "db_pass" ></input></td>
        <td>
            <button type="button" id="update_installer_1" class="successButton" onclick="return update_dbconf()">Update</button>
        </td>
    <tr>
        <td id="result_db_check"></td>
        <td>
            <span id="result_display"></span>
        </td>
        <td colspan="3">
            <button type="button" id="import_data" class="successButton" onclick="return check_connection()">Check Connection</button>
            <a href="index" ><button id= "next_page" style = "display:none" type="button" id="NEXT" class="successButton">Next</button></a>
        </td>
    </tr>
</table>
</div>

<script>
function update_dbconf(){
var host= jQuery('#db_host').val(); 
                  var  port =jQuery('#db_port').val();
                   var  name =jQuery('#db_name').val();
                   var password = jQuery('#db_pass').val();
                 var   type = jQuery('#db_type').val();
                  var  sid =jQuery('#db_sid').val();
				      if(type=='')
				  {
				   alert("please Enter Database type");
				   jQuery('#db_type').focus();
				  return false;
				  }
				  if(host=='')
				  {
				  alert("please Enter Databse Host");
				  ('#db_host').focus();
				  return false;
				  }
				  if(port=='')
				  {
				   alert("please Enter port Number");
				   jQuery('#db_port').focus();
				  return false;
				  }
				   if(sid=='')
				  {
				   alert("please Enter Database sid");
				   jQuery('#db_sid').focus();
				  return false;
				  }
				    if(name=='')
				  {
				   alert("please Enter Database User Name");
				   jQuery('#db_name').focus();
				  return false;
				  }
				    if(password=='')
				  {
				   alert("please Enter Database password");
				   jQuery('#db_pass').focus();
				  return false;
				  }
				  
				  

    var formData = {'host' : jQuery('#db_host').val() , 
                    'port' : jQuery('#db_port').val() , 
                    'name' : jQuery('#db_name').val() , 
                    'password' : jQuery('#db_pass').val(),
                    'type' : jQuery('#db_type').val(),
                    'sid' : jQuery('#db_sid').val()};
    $.ajax({
            type: "POST",
            data: formData,
            url: '<?php echo $this->webroot ?>Setup/update_dbconf/',
            success: function (data) {
                 var obj = JSON.parse(data);
                 $("#result_display").html("Updated Successfully");
                 $("#next_page").show();
            }
        });
    }
function getConfig(type){
    $.ajax({
            type: "GET",
            url: '<?php echo $this->webroot ?>Setup/getConfig/' + type,
            success: function (data) {
                 var obj = JSON.parse(data);
                        jQuery('#db_host').val(obj['DBCONF'].host); 
                        jQuery('#db_port').val(obj['DBCONF'].port); 
                        jQuery('#db_name').val(obj['DBCONF'].user_name); 
                        jQuery('#db_pass').val(obj['DBCONF'].password);
                        jQuery('#db_sid').val(obj['DBCONF'].sid);
            }
        });
    }

function check_connection(){
       $("#result_db_check").html('Loading--');
    $.ajax({
            type: "POST",
            url: '<?php echo $this->webroot ?>Setup/check_connection',
            success: function (data) {
                 $("#result_display").html("");
                 $("#result_db_check").html(data);
                 $("#next_page").show();
                 
            }
        });
    }
</script>
