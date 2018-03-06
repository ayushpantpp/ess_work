<div id="page_content">
<p>Welcome To eBizframe 10 ESS Portal Installation</p>
<table width="100%" border="0" cellspacing="1" cellpadding="5" class="exp-voucher">
   <tr>
     <td colspan="4"><b>Select Country To be installed</b></td> 
   </tr>
   <tr class="cont">
        <td>Country News URL</td>
        <td><label for="mom_id">Select Country: <span class="req">*</span></label>
                                <?php echo $this->form->input('country_id', array('label'=>false, 'type' => 'select',
                                'options' => array('' => 'Select Country',$country_list),
                                'value' => '','required'=>true,'id'=>'country_id',onChange=>"return get_url(this.value)")); ?>
        </td>
        <td>
            <textarea id="get_url" name="news_url"></textarea>
        </td>
        
           <td>Set Support Mail</td>
          
        <td><input type="text" name="support_mail" id = "support_mail" value="<?php echo $supp_email; ?>" ></input></td>
       
        <td>
            <button type="button" id="update_email" class="successButton" onclick="return update_url()">Update</button>
        </td> <!-- <button type="button" id="update_pass" class="successButton" onclick="return update_url()">Update</button> -->
        

    </tr> 
    <tr class="cont">
        
    </tr>
    <tr class="cont">
        <td>Installer Name</td>
        <td><input type="text" name="installer_name" id = "installer_name" ></input></td>   
        <td>Installer Email Id</td>
        <td><input type="text" name="installer_mail" id = "installer_mail" ></input></td>   
        <td>
            <button type="button" id="update_installer" class="successButton" onclick="return update_installer()">Update</button>
        </td>
    </tr>
    <tr>
        <td>
            <span id="country_display"></span><br>
                        <span id="email_display"></span><br>
                                    <span id="result_display"></span>
        </td>
        <td colspan="3">
            <a href="db_config" ><button id= "next_page" style = "display:none" type="button" id="NEXT" class="successButton">Next</button></a>
        </td>
    </tr>
</table>
</div>

<script>
function get_url(id){
    $.ajax({
            type: "POST",
            url: '<?php echo $this->webroot ?>Setup/get_url/' + id,
            success: function (data) {
                 $("#get_url").val();
                 $("#get_url").val(data);
            }
        });
    }

function update_url(){

    var id = jQuery('#country_id').val();
    if(id=='')
    {
        alert("please select Country");
        jQuery('#country_id').focus();
        return false;

    }
    var email = jQuery('#support_mail').val();
    var emailReg=/^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
     if(email=='')
    {
        alert("please enter support Email");
        jQuery('#support_mail').focus();
        return false;

    }
    else if(!emailReg.test( email )) {

    
    
         alert("please enter valid Email");
         jQuery('#support_mail').val('');
        jQuery('#support_mail').focus();
        return false;
    }
    var url = jQuery('#get_url').val();
    $.ajax({
            type: "POST",
            url: '<?php echo $this->webroot ?>Setup/update_url/'+id +'/'+url,
            success: function (data) {
                 $("#update_pass").val(data);
                 $("#country_display").html("Country Updated Successfully");
                 $("#next_page").show();


            }
        });

     $.ajax({
            type: "POST",
            url: '<?php echo $this->webroot ?>Setup/update_email/'+email,
            success: function (data) {
                 $("#support_mail").val(data);
                 $("#email_display").html("Country & Email Updated Successfully");
                 $("#next_page").show();
            }
        });
    }
/*function update_email($email){
    
   
    }*/
function update_installer(){
    var email = jQuery('#installer_mail').val();
    var name = jQuery('#installer_name').val();
if(name=='')
    {
      alert("please enter Name");
        jQuery('#installer_name').focus();
        return false;  
    }
    else if(!/^[a-zA-Z ]*$/g.test(name))
    {
         alert("please enter Valid Name");
         jQuery('#installer_name').val('');
        jQuery('#installer_name').focus();

        return false; 
    }
     var emailReg=/^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
     if(email=='')
    {
        alert("please enter installer Email");

        jQuery('#installer_mail').focus();
        return false;

    }
    else if(!emailReg.test( email )) {

    
    
         alert("please enter valid Installer Email");
         jQuery('#installer_mail').val('');
        jQuery('#installer_mail').focus();
        return false;
    }
    

    $.ajax({
            type: "POST",
            url: '<?php echo $this->webroot ?>Setup/update_installer/'+name+'/'+email,
            success: function (data) {
                 var obj = JSON.parse(data);
                 $("#installer_name").val(obj['Installer'].name);
                 $("#installer_email").val(obj['Installer'].email);
                 $("#result_display").html(" Installer  Updated Successfully");
                 $("#next_page").show();
            }
        });
    }

</script>










