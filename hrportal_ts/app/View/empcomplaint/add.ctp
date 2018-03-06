<div class="breadCrumbHolder module">
    <div id="breadCrumb0" class="breadCrumb module">
        <ul>
            <li>
                <a href="#" class="vtip" title="Home">Home</a>
            </li>
            <li>
                <a href="<?php echo $this->webroot.'empcomplaint/';?>">Complaint Management System</a>
            </li>
            <li>
                <a href="<?php echo $this->webroot.'empcomplaint/type';?>">Select Type</a>
            </li>            
            <li>
                Add
            </li>            
        </ul>
    </div>
</div>
<h2 class="demoheaders">Add Complaint</h2>
<?php
echo $this->Form->create('Empcomplaint', array(
    'url' => 'prAddJson',
    'inputDefaults' => array(
        'label' => false,
        'div' => false,
        'error' => array(
            'wrap' => 'span',
            'class' => 'my-error-class'
        )
    )
        )
);

?>

<?php echo $form->hidden('vc_default_comp',array('value'=>'01')); ?>
<?php echo $form->hidden('vc_comp_code',array('value'=>'01')); ?>
<?php echo $form->hidden('nu_dt_complaint_id',array('value'=>$level2)); ?>

<div class="travel-voucher1">
<div class="input-boxs-timesheet">
<table class="exp-voucher" width="100%" cellpadding="5" cellspacing="1">
    <tr class="head">
        <td colspan="4">
            <b><?php echo ($level1 == '1') ? "Application" : "Others"; ?> - <?php echo $level2_name; ?></b>
        </td>
    </tr>
    <tr class="cont1">
        <td>Your Complaint No :</td>
        <td style="text-align: center;font-style:italic;">--Auto Generated--</td>
        <td></td>
        <td></td>
    </tr>
   <tr class="cont1">
        <td>Project :</td>
        <td><?php echo $form->input('nu_project_code', array('type' => 'select', 'options' => $projects)); ?></td>
        <td></td>
        <td></td>
    </tr>

    <tr class="cont1">
        <td>Complaint Type :</td>
        <td><?php echo $form->input('vc_type', array('value' => ($level1 == '1') ? "Application" : "Others", 'readonly' => 'true')); ?></td>
        <td>* Complaint Logged by :</td>
        <td><?php echo $form->input('vc_logged_by',array('value'=>$empName,'readonly'=>true)); ?>
    </tr>
    <tr class="cont1">
            <td>* Logged user email id :</td>
            <td><?php echo $form->input('vc_email',array('value'=>$email,'readonly'=>true)); ?></td>
            <td>Contact Number :</td>
            <td><?php echo $form->input('vc_contact_no'); ?></td>		</tr>
    <?php if (@$common_block == 'Y') { ?>
        <tr class="cont1">
                <td>*Since When : </td>
                <td><?php echo $form->input('dt_problem_date',array('type'=>'text')); ?></td>
                <td>OS Being Used : </td>
                <td><?php echo $form->input('vc_os_version'); ?></td>
    					</tr>
        <tr class="cont1">
                <td> Problem is in all Location(s)  : </td>
                <td>
        <?php echo $form->input('ch_location_flag', array('type' => 'select', 'options' => array('' => '---', 'Y' => 'Yes', 'N' => 'No'))); ?>
                </td>
                <td>Installed JVM Version  : </td>
                <td><?php echo $form->input('vc_jvm_version'); ?></td>
    					</tr>
        <tr class="cont1">
                <td> Problem is in all machine(s) : </td>
                <td><?php echo $form->input('ch_machine_flag', array('type' => 'select', 'options' => array('' => '---', 'Y' => 'Yes', 'N' => 'No'))); ?></td>
                <td>Complete path of JVM Location : </td>
                <td><?php echo $form->input('vc_jvm_path'); ?></td>
    					</tr>
        <tr class="cont1">
                <td>Are you getting any error message  ? </td>
                <td><?php echo $form->input('ch_message_flag', array('type' => 'select', 'options' => array('' => '---', 'Y' => 'Yes', 'N' => 'No'))); ?></td>
                <td>Complete path of JAR Location : </td>
                <td><?php echo $form->input('vc_jar_path'); ?></td>
    					</tr>
        <tr class="cont1">
                <td>Any update done on IE/OS ? </td>
                <td><?php echo $form->input('ch_update_flag', array('type' => 'select', 'options' => array('' => '---', 'Y' => 'Yes', 'N' => 'No'))); ?></td>
                <td>*Installed Browser Version  : </td>
                <td><?php echo $form->input('vc_browser_version'); ?></td>
    					</tr>
        <tr class="cont1">
                <td>Is your Popup blocked ?   </td>
                <td><?php echo $form->input('ch_popup_flag', array('type' => 'select', 'options' => array('' => '---', 'Y' => 'Yes', 'N' => 'No'))); ?></td>
                <td>If Yes, then please mention details :</td>
                <td><?php echo $form->input('vc_popup_desc'); ?></td>
    					</tr>
        <?php
    }
    if ($level1 == '1' and $level2 == '3') {
        ?>
        <tr class="cont1">
                <td>Problem is in <strong><u>F</u></strong>orm/<strong><u>R</u></strong>eport/<strong><u>O</u></strong>thers :</td>
                <td><?php echo $form->input('vc_problem_source', array('type' => 'select', 'options' => array('' => '---', 'F' => 'Form', 'R' => 'Report', 'O' => 'Other'))); ?></td>
                <td colspan="2">&nbsp;</td>
    					</tr>
        <tr class="cont1">
                <td>Please specify the complete menu option :</td>
                <td><?php echo $form->input('vc_menu_option'); ?></td>
                <td colspan="2">(as module\parent-menu\sub-me nu\sub-sub-menu).</td>
    					</tr>
    <?php
    }
    if ($level1 == '1' and $level2 == '4') {
        ?>
        <tr class="cont1">
                <td>Type of message :</td>
                <td><?php echo $form->input('vc_error_message_type', array('type' => 'select', 'options' => array('' => '--Select--', 'A' => 'Application', 'S' => 'System'))); ?></td>
                <td colspan="2">&nbsp;</td>
    					</tr>
        <tr class="cont1">
                <td>Write the error message here in detail :</td>
                <td><?php echo $form->input('vc_error_message_desc'); ?></td>
                <td colspan="2">&nbsp;</td>
    					</tr>
    <?php
    }
    if ($level1 == '1' and $level2 == '5') {
        ?>
        <tr class="cont1">

                <td>Empty Space on your local disk(C Drive) :</td>
                <td><?php echo $form->input('vc_c_drive_space'); ?>
    						in MB</td>
                <td>Empty Space on (D Drive) :</td>
                <td><?php echo $form->input('vc_d_drive_space'); ?>
    						   in MB</td>
    					</tr>
        <tr class="cont1">
                <td>RAM available on your machine :</td>
                <td><?php echo $form->input('vc_ram_size'); ?>
    						in MB</td>
                <td colspan="2">&nbsp;</td>
    					</tr>
        <tr class="cont1">
                <td>How much time it was taking initially :</td>
                <td><?php echo $form->input('nu_initial_time'); ?> in seconds.</td>
                <td>How much time it's taking now :</td>
                <td><?php echo $form->input('nu_final_time'); ?>
    							in seconds.</td>
    					</tr>
    <?php
    }
    if ($level1 == '1' and $level2 == '6') {
        ?>
        <tr class="cont1">
                <td>Problem is in Form(F)/Report(R)/Others(O)</td>
                <td><?php echo $form->input('vc_problem_source', array('type' => 'select', 'options' => array('' => '--', 'F' => 'F', 'R' => 'R', 'O' => 'O'))); ?></td>
                <td>In single field or all fields :</td>
                <td><?php echo $form->input('ch_field_flag', array('type' => 'select', 'options' => array('' => '--Select--', 'A' => 'All', 'S' => 'Single'))); ?></td>
    					</tr>
        <tr class="cont1">
                <td>Since <strong><u>B</u></strong>eginning/<strong><u>N</u></strong>ow :</td>
                <td><?php echo $form->input('ch_period_flag', array('type' => 'select', 'options' => array('' => '--', 'B' => 'B', 'N' => 'N'))); ?></td>
                <td colspan="2">&nbsp;</td>
    					</tr>
        <tr class="cont1">
                <td>What should be the correct value :</td>
                <td><?php echo $form->input('vc_correct_val'); ?></td>
                <td>What's the value it's displaying :</td>
                <td><?php echo $form->input('vc_error_val'); ?></td>
    					</tr>
        <tr class="cont1">
                <td>Please specify the complete menu option :</td>
                <td><?php echo $form->input('vc_menu_option'); ?></td>
                <td colspan="2">(as module\parent-menu\sub-me nu\sub-sub-menu).</td>
    					</tr>
    <?php
    }
    if ($level1 == '1' and $level2 == '7') {
        ?>
        <tr class="cont1">
                <td>Problem is in <strong><u>F</u></strong>orm/<strong><u>R</u></strong>eport/<strong><u>O</u></strong>thers :</td>
                <td><?php echo $form->input('vc_problem_source', array('type' => 'select', 'options' => array('' => '--', 'F' => 'F', 'R' => 'R', 'O' => 'O'))); ?></td>
                <td colspan="2">&nbsp;</td>
    					</tr>
        <tr class="cont1">
                <td>Problem is in all module(s)  :</td>
                <td><?php echo $form->input('ch_module_flag', array('type' => 'select', 'options' => array('' => '---', 'Y' => 'Yes', 'N' => 'No'))); ?></td>
                <td>If Yes,  mention the module name here :</td>
                <td><?php echo $form->input('vc_module_name'); ?></td>
    					</tr>
        <tr class="cont1">
                <td>Problem is in a particular option :</td>
                <td><?php echo $form->input('ch_option_flag', array('type' => 'select', 'options' => array('' => '---', 'Y' => 'Yes', 'N' => 'No'))); ?></td>
                <td>If Yes,  mention the  option path here :</td>
                <td><?php echo $form->input('vc_option_name'); ?></td>
    					</tr>
    <?php } ?>
    <tr class="cont1">
            <td>* Priority :</td>
            <td><?php echo $form->input('vc_priority', array('type' => 'select', 'options' => array('' => '---', 'Low' => 'Low', 'Medium' => 'Medium', 'High' => 'High'))); ?></td>
            <td>Your complaint is  :</td>
            <td><?php echo $form->input('vc_stage', array('type' => 'select',  'options' => array('Recorded' => 'Recorded'),'selected'=>'Recorded')); ?></td>
					</tr>
    <tr class="cont1">
            <td>* Complete Description :(1000 Character)</td>
            <td colspan="3"><?php echo $form->textarea('vc_desc',array('cols'=>'60')); ?></td>
    </tr>
    <tr class="cont1">
            <td>Attach Error screen shot  :</td>
            <td colspan="3">
                <?php echo $form->input('bl_image',array('type'=>'file')); ?>
            </td>
    </tr>    
</table>
</div>
</div>


<div align="center" class="submit"> <?php echo $form->submit('Add Complaint',array('class'=>'successButton'));?></div>
<?php echo $form->end(); ?>
<script language="javascript">
    jQuery('document').ready(function(){
        jQuery('input[id^=EmpcomplaintDt]').datepicker();
        jQuery('input[type=submit]').parents('form:first').ajaxForm({
            url:'<?php echo $this->webroot.'empcomplaint/prAddJson'; ?>',
            dataType: 'json',
	    beforeSubmit: function(arr, $form, options) { 
		jQuery('input[type=submit]').attr('disabled','disabled');
	    },
            success: function(data){
                            if(data.status==1){
                                //$('.new-messsages').html('<div style="width:400px;margin:0 auto;text-align:center;" id="response-message">'+data.message+'</div>');
                                //$('#response-message').highlightStyle();
                                //$('#response-message').fadeIn(600).delay(10000).fadeOut(900);
                                jQuery('input[type=submit]').parents('form:first').resetForm();
				window.location.href='<?php echo $this->webroot.'empcomplaint/' ?>';
                            }else{
                                $('.new-messsages').html('<div style="width:400px;margin:0 auto;text-align:center;" id="response-message">'+data.message+'</div>');
                                $('#response-message').errorStyle();
                                $('#response-message').fadeIn(600).delay(10000).fadeOut(900);
                                showErrorQTip(data.errors, 'Empcomplaint');
				jQuery('input[type=submit]').removeAttr('disabled');
                            }                            
            }
        });        
    });
</script>