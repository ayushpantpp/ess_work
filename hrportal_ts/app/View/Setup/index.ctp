

<div id="page_content">
<p>Welcome To eBizframe 10 ESS Portal Installation</p>
<table width="100%" border="0" cellspacing="1" cellpadding="5" class="exp-voucher">
   <tr>
     <td colspan="4"><b>One Time Setup Screen</b></td> 
   </tr>
   <tr class="head">
        <th width="7%">S. No.</th>
        <th width="20%">Description</th> 
        <th width="20%">Action</th>
    <th width="20%">Result</th>
   </tr>
    
   <tr class="cont">
        <td>1</td>
        <td>Check DB Connection</td> 
    <td>
            <button type="button" id="import_data" class="successButton" onclick="return check_connection()">Check</button>
			 <button style="display:none" type="button" id="result_db_Done" class="successButton" >Done</button>
       
         
        </td>
        <td id="result_db_check"></td>
    </tr>
      

    <tr class="cont">
        <td>2</td>
        <td>Reset Portal (Truncate Data)</td> 
    <td>
            <button type="button" id="truncate" class="successButton" onclick="return truncate()">Reset</button>
            <button style="display:none" type="button" id="truncate_done_up" class="successButton" >Done</button>
       
        </td>
        <td id="truncate_done"></td>
    </tr>
    
   <tr class="cont">
        <td>3</td>
        <td>Import Company Data From ebizFrame 10</td> 
    <td>
            <button type="button" id="import_data_1" class="successButton" onclick="return get_data()">Import</button>
            <button style="display:none" type="button" id="import_data_done" class="successButton" >Done</button>
        </td>
        <td id="import_data_result"></td>
    </tr>
    <tr class="cont">
        <td>4</td>
        <td>Import Users Data From ebizFrame 10</td> 
    <td>
            <button type="button" id="import_usersdata_1" class="successButton" onclick="return Users_data()">Import</button>
            <button style="display:none" type="button" id="import_usersdata_done" class="successButton" >Done</button>
        </td>
        <td id="import_usersdata_result"></td>
    </tr>
	<tr class="cont">
        <td>5</td>
        <td>Make User DOB as Password</td> 
    <td>
            <button type="button" id="update_pass" class="successButton" onclick="return update_pass()">Update</button>
            <button style="display:none" type="button" id="update_pass_done" class="successButton" >Done</button>
       
        </td>
        <td id="update_pass_result"></td>
    </tr>
     <tr class="cont">
        <td>6</td>
        <td>Import Option Data From ebizFrame 10</td> 
    <td>
            <button type="button" id="import_optiondata_1" class="successButton" onclick="return option_data()">Import</button>
            <button style="display:none" type="button" id="import_optiondata_done" class="successButton" >Done</button>
        </td>
        <td id="import_optiondata_result"></td>
    </tr>
    <tr class="cont">
        <td>7</td>
        <td>Import Leave Data From ebizFrame 10</td> 
    <td>
            <button type="button" id="import_leavedata_1" class="successButton" onclick="return leave_data()">Import</button>
            <button style="display:none" type="button" id="import_leavedata_done" class="successButton" >Done</button>
        </td>
        <td id="import_leavedata_result"></td>
    </tr>
    <tr class="cont">
        <td>8</td>
        <td>Import Attendence Data From ebizFrame 10</td> 
    <td>
            <button type="button" id="import_atdata_1" class="successButton" onclick="return attendence_data()">Import</button>
            <button style="display:none" type="button" id="import_atdata_done" class="successButton" >Done</button>
        </td>
        <td id="import_atdata_result"></td>
    </tr>
    <tr class="cont">
        <td>9</td>
        <td>Import Bank Data From ebizFrame 10</td> 
    <td>
            <button type="button" id="bank_atdata_1" class="successButton" onclick="return bank_data()">Import</button>
            <button style="display:none" type="button" id="bank_atdata_done" class="successButton" >Done</button>
        </td>
        <td id="import_bankatdata_result"></td>
    </tr>
    <tr class="cont">
        <td>10</td>
        <td>Import Holiday Data From ebizFrame 10</td> 
    <td>
            <button type="button" id="import_holidaydata_1" class="successButton" onclick="return holiday_data()">Import</button>
            <button style="display:none" type="button" id="import_holidaydata_done" class="successButton" >Done</button>
        </td>
        <td id="import_holidaydata_result"></td>
    </tr>
    <tr class="cont">
        <td>11</td>
        <td>Import Salary Data From ebizFrame 10</td> 
    <td>
            <button type="button" id="import_data_2" class="successButton" onclick="return get_salary()">Import</button>
            <button style="display:none" type="button" id="import_sal_done" class="successButton" >Done</button>
       
        </td>
        <td id="import_salary_result"></td>
    </tr>
    
     
    
    <tr>
        <td><a href="<?php echo $this->webroot;?>Configurations/admin_option"><button type="button" id="NEXT" class="successButton" style="align:right;">Next</button></a></td>
        <td colspan="4" ><a href="db_config"><button type="button" id="Back" class="successButton" style="align:center;" onclick="return confirm('Are you sure? you want to be import data  again')" >Back</button></a></td>
    </tr>
   
    
</table>
</div>

<script>


$(document).ready(function()
{
    
     $("#import_data_1").hide();

     $("#truncate").hide();
     $("#import_usersdata_1").hide();
      $("#import_optiondata_1").hide();
         $("#import_leavedata_1").hide();
          $("#import_atdata_1").hide();
          $("#bank_atdata_1").hide();
          $("#import_holidaydata_1").hide();
          $("#import_data_2").hide();
            $("#update_pass").hide();
            $("#NEXT").hide();
});
   function check_connection(){
    
       $("#result_db_check").html('Loading--');
    $.ajax({
            type: "POST",
            url: '<?php echo $this->webroot ?>Setup/check_connection',
            success: function (data) {
                 $("#result_db_check").html(data);
                 $("#result_db_Done").show();
				 $("#import_data").hide();
            }
        });
     
     $("#truncate").show();
    }
    
    function get_data(){
     $("#import_data_result").html('Loading--');
     $("#NEXT").hide();
    $.ajax({
            type: "POST",
            url: '<?php echo $this->webroot ?>Setup/import_data',
            success: function (data) {
                 $("#import_data_result").html(data);
                 $("#import_data_done").show();
                 $("#import_data_1").hide();
                  $("#import_usersdata_1").show();
                  
$("#NEXT").show();
            }
        });
    }
    function Users_data(){
     $("#import_usersdata_result").html('Loading--');
     $("#NEXT").hide();
    $.ajax({
            type: "POST",
            url: '<?php echo $this->webroot ?>Setup/import_users',
            success: function (data) {
                 $("#import_usersdata_result").html(data);
                 $("#import_usersdata_done").show();
                 $("#import_usersdata_1").hide();
                  $("#import_optiondata_1").show();
				        $("#update_pass").show();
                  $("#NEXT").show();
            }
        });
    }
       function option_data(){
     $("#import_optiondata_result").html('Loading--');
     $("#NEXT").hide();
    $.ajax({
            type: "POST",
            url: '<?php echo $this->webroot ?>Setup/import_attribute_type',
            success: function (data) {
                 $("#import_optiondata_result").html(data);
                 $("#import_optiondata_done").show();
                 $("#import_optiondata_1").hide();
                    $("#import_leavedata_1").show();
                    $("#NEXT").show();
            }
        });
    }
      function leave_data(){
     $("#import_leavedata_result").html('Loading--');
     $("#NEXT").hide();
    $.ajax({
            type: "POST",
            url: '<?php echo $this->webroot ?>Setup/import_leaves',
            success: function (data) {
                 $("#import_leavedata_result").html(data);
                 $("#import_leavedata_done").show();
                 $("#import_leavedata_1").hide();
                 $("#import_atdata_1").show();
                 $("#NEXT").show();
            }
        });
    }
       function attendence_data(){
     $("#import_atdata_result").html('Loading--');
     $("#NEXT").hide();
    $.ajax({
            type: "POST",
            url: '<?php echo $this->webroot ?>Setup/import_attendance',
            success: function (data) {
                 $("#import_atdata_result").html(data);
                 $("#import_atdata_done").show();
                 $("#import_atdata_1").hide();
                 $("#bank_atdata_1").show();
                 $("#NEXT").show();
            }
        });
    }
     function bank_data(){
     $("#import_bankatdata_result").html('Loading--');
     $("#NEXT").hide();
    $.ajax({
            type: "POST",
            url: '<?php echo $this->webroot ?>Setup/import_app_eo',
            success: function (data) {
                 $("#import_bankatdata_result").html(data);
                 $("#bank_atdata_done").show();

                 $("#bank_atdata_1").hide();
                 $("#import_holidaydata_1").show();
                 $("#NEXT").show();

				  $("#import_holidaydata_1").show();
                 

            }
        });
    }
      function holiday_data(){
     $("#import_holidaydata_result").html('Loading--');
     $("#NEXT").hide();
    $.ajax({
            type: "POST",
            url: '<?php echo $this->webroot ?>Setup/import_holiday',
            success: function (data) {
                 $("#import_holidaydata_result").html(data);
                 $("#import_holidaydata_done").show();

                 $("#import_holidaydata_1").hide();
                 $("#import_data_2").show();
                 $("#NEXT").show();
            }
        });
    }
        function get_salary(){
    $("#import_salary_result").html('Loading--');
    $("#NEXT").hide();
    $.ajax({
            type: "POST",
            url: '<?php echo $this->webroot ?>Setup/import_salary',
            success: function (data) {
                 $("#import_salary_result").html(data);
                 $("#import_sal_done").show();
                 $("#import_data_2").hide();
                  /*$("#update_pass").show();*/
                  $("#NEXT").show();
            }
        });

    }

    function update_pass(){
    $("#update_pass_result").html('Loading--');
    $.ajax({
            type: "POST",
            url: '<?php echo $this->webroot ?>Setup/updatepass',
            success: function (data) {
                 $("#update_pass_result").html(data);
                 $("#update_pass_done").show();
                 $("#update_pass").hide();
            }
        });
    }
    
    function truncate(){
    $("#truncate_done").html('Loading--');
    $.ajax({
            type: "POST",
            url: '<?php echo $this->webroot ?>Setup/reset_portal',
            success: function (data) {
                 $("#truncate_done").html(data);
                 $("#truncate_done_up").show();
                 $("#truncate").hide();
                 $("#import_data_1").show();
            }
        });

    }

</script>

    