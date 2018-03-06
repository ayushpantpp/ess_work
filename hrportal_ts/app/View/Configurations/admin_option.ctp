
<div class="breadCrumbHolder module">
    <div id="breadCrumb0" class="breadCrumb module">
        <ul>
            <li>
                <a class="vtip" title="Home">Home</a>
            </li>
            <li>
                Configurations
            </li>
            <li>
                Admin options
            </li>            
        </ul>
    </div>
</div>
<br>
<div id="add_msg_div">
    <h2 class="demoheaders">Add/View Modules<a href="#" id="create"></a></h2>
    <?php echo $this->Form->create('Module', array('url' => '#', 'name' => 'msgForm', 'inputDefaults' => array('label' => false, 'div' => false))); ?>
    <div class="travel-voucher">
        <div class="input-boxs">
            <table  border="0" width="97%" cellspacing="10" cellpadding="0" align="center" style="margin:0px auto;">
                <tr>
                    <td>
                <tr>
                   <?php $company = $this->Common->findCompanyName();?>
                    <th scope="row"><strong>Select Organization :</strong>  </th>
                    <td><?php echo $this->Form->input('org_id', array('type'=>'select','options'=>$company,'empty'=>'Select Company','class' => 'round_select', 'id' => 'org_name')); ?>
                        <div id="dCnameErr" style="color:red"></div>
                    </td>
                </tr>
                <tr style='display:none' id = 'module_name'>
                   <?php $option = $this->Common->findModuleName();?>
                    <th scope="row"><strong>Select Module :</strong>  </th>
                    <td><?php echo $this->Form->input('admin_options_id', array('type'=>'select','options'=>$option,'empty'=>'Select Module','class' => 'round_select', 'id' => 'admin_options_id')); ?>
                        <div id="dCnameErr" style="color:red"></div>
                    </td>
                </tr>
                
                <tr>
                    <td colspan="4" align="center">
			<div align="center" class="submit">
			<?php echo $this->Form->button('Submit', array('type' => 'button', 'id' => 'add','class'=>'submit-btn')); ?>
                        &nbsp; 	&nbsp; 	&nbsp; 	&nbsp; 
                        <?php echo $this->Form->button('Submit', array('type' => 'button', 'id' => 'addmore_submit','class'=>'submit-btn','style'=>'display:none')); ?>
                        &nbsp; 	&nbsp; 	&nbsp; 	&nbsp; 
                        <?php echo $this->Form->button('Reset', array('type' => 'reset', 'id'=>'Reset','onclick'=>'location.reload();','class'=>'submit-btn')); ?>
                        &nbsp; 	&nbsp; 	&nbsp; 	&nbsp; 
                        <?php echo $this->Form->button('Add More', array('type' => 'button','class'=>'new submit-btn','id'=>'addmore','style'=>'display:none')); ?>
			</div>
                    </td>
                </tr>
                
            </table>
        </div>
    </div>
    <?php
    echo $this->Form->end();
    ?>

</div>


    <div id="list_msg_div1">
        
        <h2 class="demoheaders">List Of Modules</h2>
        <div class="travel-voucher1" style="min-height: 300px;">
            <div class="input-boxs">

                <div id="result"></div>


            </div>
        </div>
        <div id="files"></div>
    </div>
</div>


<script>
    jQuery(document).ready(function(){
        //lists();



    });
        /*Add record script*/ 
        
        jQuery("#add").click(function() {   
            var org_id = jQuery("#org_name").val();
			if(org_id=='')
			{
			alert("Please select organisation Name");
			jQuery('#org_name').focus();
			return false;
			}
            lists(org_id);
           
        });

            jQuery("#Reset").click(function() {   
           jQuery("#finish").hide();
           
        });
        jQuery("#addmore").click(function() {   
            jQuery("#add").hide();
            jQuery('#addmore').hide();
            jQuery("#addmore_submit").show();
            jQuery("#module_name").show();
        });
        jQuery("#addmore_submit").click(function() {  
		
            var org_id = jQuery("#org_name").val();
			if(org_id=='')
			{
			alert("Please select organisation Name");
			jQuery('#org_name').focus();
			return false;
			}
            var ref_id = jQuery('#admin_options_id').val();
			if(ref_id=='')
			{
			alert("Please select Module");
			jQuery('#admin_options_id').focus();
			return false;
			}
            var fdata = 'org_id='+org_id+'&ref_id='+ref_id
     
            jQuery.post('<?php echo $this->webroot; ?>Configurations/add_module',
                fdata,
                function(data) {
                    lists(org_id);
                    console.log(data);
                },'html'
            ).error(function(e) {alert("Duplicate entry Not allowed : "); 
              });
   
        });
        
        
        jQuery("form[name='msgForm']").keypress(function (e) {
            if ((e.which && e.which == 13) || (e.keyCode && e.keyCode == 13)) {
                doChk();
                return false;
            } else {
                
            }
        });
        
        jQuery('.option_values').find('input[type=checkbox]').live('click',function(e){
            if($(this).is(':checked')) {
                val = 1;
            }
            else {
                val = 0;
            }
            var org_id = jQuery("#org_name").val();
            var fdata = 'id='+$(this).parent().find('.id').val()+'&value='+val+'&org='+org_id
            console.log(fdata);
            jQuery.post('<?php echo $this->webroot; ?>Configurations/update_value',
                fdata,
                function(data) {
                    // jQuery("#result").html(data);
                    
                    console.log(data);
                },'html'
            ).error(function(e) {  alert("Error : "+e.statusText);   });

        });
        
        
        function lists(id) {
            var data='<div align="center" style="margin-top:100px; font-size:12px;"><?php echo $this->Html->image("../img/load.gif"); ?><br/><b>Loading Please Wait....</b> </div>';
            jQuery("#result").html(data);
            var fdata=jQuery("#searchForm").serialize();
            jQuery.post('<?php echo $this->webroot; ?>Configurations/lists/'+ id,
                fdata,
                function(data) {
                    jQuery("#addmore").show();
                    jQuery("#module_name").hide();
                    jQuery("#result").html(data);                    
                },'html'
            ).error(function(e) {  alert("Error : "+e.statusText);   });
        }



</script>   
<style>
.submit{text-align:left;}
</style>