<div class="breadCrumbHolder module">
    <div id="breadCrumb0" class="breadCrumb module">
        <ul>
            <li>
                <a href="#" class="vtip" title="Home">Home</a>
            </li>
            <li>
                <a href="<?php echo $this->webroot; ?>selfservices/#complaint">Complaint Management System</a>
            </li>
            <li>
                View
            </li>            
        </ul>
    </div>
</div>
<?php
echo $form->create('Empcomplaint', array(
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
<h2 class="demoheaders">View Complaint #<?php echo $this->data['Empcomplaint']['vc_complain_no']; ?> </h2>
<div class="travel-voucher1">
    <div class="input-boxs-timesheet">
            <table width="100%" border="0" cellspacing="1" cellpadding="5" class="exp-voucher innerheader">
                <tr class="head">
                    <th scope="row" colspan="4">Details   <?php echo ($level1 == '1') ? "Ebizframe" : "Others";?> - <?php echo $level2_name; ?></th>
                </tr>
                <!-- Start Complaint Form -->
                <tr class="cont1">
                    <th>Your Complaint Date :</th>
                    <td><?php echo date("d-m-Y", strtotime($this->data['Empcomplaint']['dt_complain_date']));?></td>
                    <th>&nbsp;</th>
                    <td>&nbsp;</td>
                </tr>

                <tr class="cont1">
                    <th>Complaint Type :</th>
                    <td><?php echo $this->data['Empcomplaint']['vc_type']; ?></td>
                    <th>Complaint Logged by :</th>
                    <td><?php echo $this->data['Empcomplaint']['vc_logged_by']; ?></td>
                </tr>
                <tr class="cont1">
                        <th> Logged user email id :</th>
                        <td><?php echo $this->data['Empcomplaint']['vc_email']; ?></td>
                        <th>Contact Number :</th>
                        <td><?php echo $this->data['Empcomplaint']['vc_contact_no']; ?></td>		
                </tr>
                <?php if (@$common_block == 'Y') { ?>
                    <tr class="cont1">
                            <th>Since When : </th>
                            <td><?php echo $this->data['Empcomplaint']['dt_problem_date']; ?></td>
                            <th>OS Being Used : </th>
                            <td><?php echo $this->data['Empcomplaint']['vc_os_version']; ?></td>
                                                    </tr>
                    <tr class="cont1">
                            <th> Problem is in all Location(s)  : </th>
                            <td>
                    <?php echo $this->data['Empcomplaint']['ch_location_flag']; ?>
                            </td>
                            <th>Installed JVM Version  : </th>
                            <td><?php echo $this->data['Empcomplaint']['vc_jvm_version']; ?></td>
                                                    </tr>
                    <tr class="cont1">
                            <th> Problem is in all machine(s) : </th>
                            <td><?php echo $this->data['Empcomplaint']['ch_machine_flag']; ?></td>
                            <th>Complete path of JVM Location : </th>
                            <td><?php echo $this->data['Empcomplaint']['vc_jvm_path']; ?></td>
                                                    </tr>
                    <tr class="cont1">
                            <th>Are you getting any error message  ? </th>
                            <td><?php echo $this->data['Empcomplaint']['ch_message_flag']; ?></td>
                            <th>Complete path of JAR Location : </th>
                            <td><?php echo $this->data['Empcomplaint']['vc_jar_path']; ?></td>
                                                    </tr>
                    <tr class="cont1">
                            <th>Any update done on IE/OS ? </th>
                            <td><?php echo $this->data['Empcomplaint']['ch_update_flag']; ?></td>
                            <th>Installed Browser Version  : </th>
                            <td><?php echo $this->data['Empcomplaint']['vc_browser_version']; ?></td>
                                                    </tr>
                    <tr class="cont1">
                            <th>Is your Popup blocked ?   </th>
                            <td><?php echo $this->data['Empcomplaint']['ch_popup_flag']; ?></td>
                            <th>If Yes, then please mention details :</th>
                            <td><?php echo $this->data['Empcomplaint']['vc_popup_desc']; ?></td>
                                                    </tr>
                    <?php
                }
                if ($level1 == '1' and $level2 == '3') {
                    ?>
                    <tr class="cont1">
                            <th>Problem is in <strong><u>F</u></strong>orm/<strong><u>R</u></strong>eport/<strong><u>O</u></strong>thers :</th>
                            <td><?php echo $this->data['Empcomplaint']['vc_problem_source']; ?></td>
                            <td colspan="2">&nbsp;</td>
                                                    </tr>
                    <tr class="cont1">
                            <th>Please specify the complete menu option :</th>
                            <td><?php echo $this->data['Empcomplaint']['vc_menu_option']; ?></td>
                            <td colspan="2">(as module\parent-menu\sub-me nu\sub-sub-menu).</td>
                                                    </tr>
                <?php
                }
                if ($level1 == '1' and $level2 == '4') {
                    ?>
                    <tr class="cont1">
                            <th>Type of message :</th>
                            <td><?php echo $this->data['Empcomplaint'];?></td>
                            <td colspan="2">&nbsp;</td>
                                                    </tr>
                    <tr class="cont1">
                            <th>Write the error message here in detail :</th>
                            <td><?php echo $this->data['Empcomplaint']['vc_error_message_desc']; ?></td>
                            <td colspan="2">&nbsp;</td>
                                                    </tr>
                <?php
                }
                if ($level1 == '1' and $level2 == '5') {
                    ?>
                    <tr class="cont1">

                            <th>Empty Space on your local disk(C Drive) :</th>
                            <td><?php echo $this->data['Empcomplaint']['vc_c_drive_space']; ?>
                                                            in MB</td>
                            <th>Empty Space on (D Drive) :</th>
                            <td><?php echo $this->data['Empcomplaint']['vc_d_drive_space']; ?>
                                                               in MB</td>
                                                    </tr>
                    <tr class="cont1">
                            <th>RAM available on your machine :</th>
                            <td><?php echo $this->data['Empcomplaint']['vc_ram_size']; ?>
                                                            in MB</td>
                            <td colspan="2">&nbsp;</td>
                                                    </tr>
                    <tr class="cont1">
                            <th>How much time it was taking initially :</th>
                            <td><?php echo $this->data['Empcomplaint']['nu_initial_time']; ?> in seconds.</td>
                            <th>How much time it's taking now :</th>
                            <td><?php echo $this->data['Empcomplaint']['nu_final_time']; ?>
                                                                    in seconds.</td>
                                                    </tr>
                <?php
                }
                if ($level1 == '1' and $level2 == '6') {
                    ?>
                    <tr class="cont1">
                            <th>Problem is in Form(F)/Report(R)/Others(O)</th>
                            <td><?php echo $this->data['Empcomplaint']['vc_problem_source'];?></td>
                            <th>In single field or all fields :</th>
                            <td><?php echo $this->data['Empcomplaint']['ch_field_flag']; ?></td>
                                                    </tr>
                    <tr class="cont1">
                            <th>Since <strong><u>B</u></strong>eginning/<strong><u>N</u></strong>ow :</th>
                            <td><?php echo $this->data['Empcomplaint']['ch_period_flag']; ?></td>
                            <td colspan="2">&nbsp;</td>
                                                    </tr>
                    <tr class="cont1">
                            <th>What should be the correct value :</th>
                            <td><?php echo $this->data['Empcomplaint']['vc_correct_val']; ?></td>
                            <th>What's the value it's displaying :</th>
                            <td><?php echo $this->data['Empcomplaint']['vc_error_val']; ?></td>
                                                    </tr>
                    <tr class="cont1">
                            <th>Please specify the complete menu option :</th>
                            <td><?php echo $this->data['Empcomplaint']['vc_menu_option']; ?></td>
                            <td colspan="2">(as module\parent-menu\sub-me nu\sub-sub-menu).</td>
                                                    </tr>
                <?php
                }
                if ($level1 == '1' and $level2 == '7') {
                    ?>
                    <tr class="cont1">
                            <th>Problem is in <strong><u>F</u></strong>orm/<strong><u>R</u></strong>eport/<strong><u>O</u></strong>thers :</th>
                            <td><?php echo $this->data['Empcomplaint']['vc_problem_source']; ?></td>
                            <td colspan="2">&nbsp;</td>
                                                    </tr>
                    <tr class="cont1">
                            <th>Problem is in all module(s)  :</th>
                            <td><?php echo $this->data['Empcomplaint']['ch_module_flag']; ?></td>
                            <th>If Yes,  mention the module name here :</th>
                            <td><?php echo $this->data['Empcomplaint']['vc_module_name']; ?></td>
                                                    </tr>
                    <tr class="cont1">
                            <th>Problem is in a particular option :</th>
                            <td><?php echo $this->data['Empcomplaint']['ch_option_flag']; ?></td>
                            <th>If Yes,  mention the  option path here :</th>
                            <td><?php echo $this->data['Empcomplaint']['vc_option_name']; ?></td>
                                                    </tr>
                <?php } ?>
                <tr class="cont1">
                        <th>Priority :</th>
                        <td><?php echo $this->data['Empcomplaint']['vc_priority']; ?></td>
                        <th>Your complaint is  :</th>
                        <td><?php echo $this->data['Empcomplaint']['vc_stage']; ?></td>
                                                    </tr>
                <tr class="cont1">
                        <th> Complete Description :</th>
                        <td colspan="3">
                            <?php echo $this->data['Empcomplaint']['vc_desc']; ?>
                        </td>
                </tr>
                <tr class="cont1">
                        <th>Attach Error screen shot  :</th>
                        <td colspan="3">
                             <?php if(strstr(strtolower($this->data['Empcomplaint']['vc_image_type']),'image')) { ?>
                            <a class="lightbox attachment vtip" title="View Attachment" href="<?php echo $this->webroot.'empcomplaint/prViewImage/'.$this->data['Empcomplaint']['vc_complain_no'];?>">Image File Attachment</a>
			    <?php } else { ?>
			    <a class="attachment vtip" title="View Attachment" href="<?php echo $this->webroot.'empcomplaint/prViewFile/'.$this->data['Empcomplaint']['vc_complain_no'];?>">File Attachment</a>
			    <?php } ?>
                           
                        </td>
                </tr>                 
                <!-- End Complaint Form -->
                <tr class="head">
                    <th scope="row" colspan="4">Response</th>
                </tr>                
                <tr class="cont1">
                    <th> Final Feedback : </th>
                    <td><?php echo $this->data['Empcomplaint']['vc_feedback']; ?></td>
                    <th> CC Remarks :</th>
                    <td><?php echo $this->data['Empcomplaint']['vc_cc_remarks']; ?></td>

                </tr>
                <tr class="cont1">
                    <th> GM/CM Remarks : </th>
                    <td><?php echo $this->data['Empcomplaint']['vc_cm_remarks']; ?></td>
		    <?php if($this->Session->check("Auth.user_type")) {if($this->Session->read("Auth.user_type")!="Customers") { ?>
			    <th> Man Hours :</th>
			    <td><?php echo $this->data['Empcomplaint']['vc_manhours']; ?></td>
		    <?php } else { ?>
			    <th></th>
			    <td></td>
		    <?php } } ?>
                </tr>
                <tr class="cont1">
                    <th>Expected Closure by :</th>
                    <td><?php 
                              if($this->data['Empcomplaint']['dt_expected_closure'] != "") {
                                    echo date("d-m-Y H:i:s", strtotime($this->data['Empcomplaint']['dt_expected_closure']));
                              }
                        ?>
                    </td>
                    <th>Real Closure on :</th>
                    <td>
                       <?php 
                              if($this->data['Empcomplaint']['dt_real_closure'] != "") {
                                  echo date("d-m-Y H:i:s", strtotime($this->data['Empcomplaint']['dt_real_closure']));
                              }
                        ?>
                   </td>
                </tr>
                <?php if($this->Session->read("Auth.user_type")!="Customers") { ?>
                <tr class="head">
                    <th scope="row" colspan="4">Engineers Assigned</th>
                </tr>
                <tr class="cont1">
                    <td width="25%" colspan="4">
                        <?php echo (count($complain_employees))?'':'<center><em>-No Engineers have been assigned for the resolution of this complain-</em></center>'; ?>
                        <?php foreach($complain_employees as $complain_employee){?>
                            <?php //pr($complain_employee);?>
                            <?php echo '<div class="unasign-div">'. ucwords(strtolower($complain_employee['Employees']['vc_emp_name']));?>
                            <?php echo '<span class="tme">[ Since '.date("d-m-Y H:i:s", strtotime($complain_employee['ComplainEmployees']['dt_created'])).' ';?>
                            <?php if (!empty($complain_employee['ComplainEmployees']['dt_unassigned'])) { ?>
                            <?php       echo 'to '.date("d-m-Y", strtotime($complain_employee['ComplainEmployees']['dt_unassigned'])); ?>
                            <?php } else { ?>
                                <?php if ($this->Session->read("Auth.Employees.vc_emp_id_makess")==$this->data['Projects']['vc_pm_code']) { ?>
                                    <?php echo '<a href="#" class="unassign vtip UnassignProjectEmployee" title="Un Assign" id="'.$complain_employee['ComplainEmployees']['id'].'">UnAssign</a>'.'],';?>
                                <?php } else { ?>
                                    <?php echo ']'; ?>
                                <?php } ?>
                            <?php } ?>
                            <?php echo '</span> '.'</div>';?>
                            <?php } ?>
                    </td>
                </tr> 
                <?php } ?>
            </table>
    </div>

</div>
<?php echo $form->end();
if($this->data['Empcomplaint']['vc_stage'] != "Recorded") {
?>
<div class="travel-voucher">

    <div class="input-boxs">

        <table cellspacing="5" cellpadding="5" border="0" width="100%">
            <tbody><tr>
                    <td align="left"><div class="weekly-heading">Action Report :</div></td>

                </tr>
                <tr>
                    <td>
                        <ul class="commnets-ul">
                            <?php $zebraClass = ''; ?>
                            <?php echo (count($complaint_annotations))?'':'<center><em>-No Comments have been made-</em></center>';?>
                            <?php foreach($complaint_annotations as $complaint_annotation){?>
                            <li class="<?php echo $zebraClass = ($zebraClass=='even')?'odd':'even'; ?>">
                                <?php 
				    //App::import('Model', $complaint_annotation['EmpcomplaintAnnotations']['vc_user_model']);
                                    $annotatorClass = ClassRegistry::init($complaint_annotation['EmpcomplaintAnnotations']['vc_user_model']);
                                    $annotator = $annotatorClass->find('first',array(
                                       'conditions'=>array(
                                           'id'=>$complaint_annotation['EmpcomplaintAnnotations']['vc_user_code']
                                       ) 
                                    ));
				    //print_r($annotatorClass);
				    //echo $complaint_annotation['EmpcomplaintAnnotations']['vc_user_code'];
                                ?>
                                <strong>
				<?php echo ucwords(strtolower($annotatorClass->id.$annotator[0][$complaint_annotation['EmpcomplaintAnnotations']['vc_user_model'].'__name'])); ?></strong><span class="tme"><?php echo $time->relativeTime(strtotime($complaint_annotation['EmpcomplaintAnnotations']['dt_created'])); ?></span><br />
                                <?php echo $complaint_annotation['EmpcomplaintAnnotations']['vc_remark']; ?><br />
                                <?php if(!empty($complaint_annotation['EmpcomplaintAnnotations']['vc_image_name'])){ ?>
                                <a class="lightbox attachment vtip" title="Click to View Attachment" href="<?php echo $this->webroot.'empcomplaintannotations/prViewImage/'.$complaint_annotation['EmpcomplaintAnnotations']['id'];?>">Image File Attachment</a>
                                <?php } ?>
                                <div class="work-in-progress"><?php echo $complaint_annotation['EmpcomplaintAnnotations']['vc_status']; ?></div>                            
                            </li>
                            <?php } ?>
                            <?php if($this->data['Empcomplaint']['vc_stage']!="Closed" && $this->data['Empcomplaint']['vc_stage']!="Forced Closure") { ?>
                            <li class="reply-comments-li">
                              
                                <div class="edit-comments">
                                        <?php
                                        echo $form->create('EmpcomplaintAnnotations', array(
                                            'url'=> array('controller'=>'empcomplaintannotations','action'=>'prAddJson'),
                                            'id'=>'EmpcomplaintAnnotationsAddForm',
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
                                            <div><?php echo $form->textarea('vc_remark',array('style'=>'width:100%;','rows'=>5));?></div>
					   
						<?php echo $form->input('vc_status',array('type'=>'select','style'=>'clear:both; margin:0px 0px 10px 0px;','options'=>array(''=>'--Select Status--','Work In Progress'=>'Work In Progress','ESS Feedback Awaited'=>'ESS Feedback Awaited','Closed'=>'Closed')));?>
					    
					    
                                            <?php echo $form->file('bl_image');?>
                                            <?php echo $form->hidden('vc_complain_no',array('value'=>$this->data['Empcomplaint']['vc_complain_no']));?>
                                            <?php 
                                                              $options = array(
								'label' => 'Post Comment',
								 'name' => 'post_comment',
								 'onClick' => 'return validateForm();'
								);
								echo $form->end($options);
                                                  
					     ?>
                                </div>                                
                            </li>
                            <?php } ?>
                        </ul>

                    </td>

                </tr>

            </tbody></table>

    </div>

</div>
<?php } ?>
<script type="text/javascript" >
	function validateForm(){
                if($('#EmpcomplaintAnnotationsVcRemark').val() == ""){
		alert("Please enter some action taken.");
                $('#EmpcomplaintAnnotationsVcRemark').focus()
		return false;
		}
		if($('#EmpcomplaintAnnotationsVcStatus').val() == ""){
		alert("Please select the status.");
		return false;
		}
		return true;
	}
    jQuery(document).ready(function(){
//        jQuery('input[name="submit"]').click(function(){
//            //jQuery.post(<?php echo $this->webroot.'empcomplaint/prEditJson'; ?>, jQuery(this).parents('form:first').serialize(), function(data){
//                
//            //}, 'json')
//        });
        jQuery('a.lightbox').lightBox({
            maxHeight: 500,
            maxWidth: 900
        });
        jQuery('#EmpcomplaintAnnotationsAddForm').ajaxForm({
            url:'<?php echo $this->webroot.'empcomplaintannotations/prAddJson'; ?>',
            dataType: 'json',
            success: function(data){
                            if(data.status==1){
                                    jQuery('.new-messsages').html('<div style="width:400px;margin:0 auto;text-align:center;" id="response-message">'+data.message+'</div>');
                                    jQuery('#response-message').highlightStyle();
                                    jQuery('#response-message').fadeIn(600).delay(10000).fadeOut(900);
                                    jQuery('ul.commnets-ul').find('li:last').before(decodeURIComponent(data.html));
                                    jQuery('ul.commnets-ul').find('li:last').prev().addClass((jQuery('ul.commnets-ul').find('li:last').prev().prev().attr('class')=='odd')?'even':'odd');
                                    jQuery('ul.commnets-ul').find('li:last').prev().find('a.lightbox').lightBox({
                                        maxHeight: 500,
                                        maxWidth: 900
                                    });
                                    jQuery('#EmpcomplaintAnnotationsAddForm').resetForm();
                                    jQuery('ul.commnets-ul').find('center').remove();
                            }
            }
        });
        jQuery('.UnassignProjectEmployee').click(function(){
            var div = jQuery('<div title="Unassignment Confirmation">Are you sure you want to Unassign employee from this complain?<input type="hidden" value="'+jQuery(this).attr('id')+'"></div>');
            div.dialog({autoOpen:false,modal:true,buttons:{
                    "Yes":function(){
                        jQuery.post('<?php echo $this->webroot.'complainEmployees/prUnassignJson/'?>'+jQuery(this).find('input[type=hidden]:first').val(),function(data){
                                    if(data.status==1){
                                        jQuery('.new-messsages').html('<div style="width:400px;margin:0 auto;text-align:center;" id="response-message">'+data.message+'</div>');
                                        jQuery('#response-message').highlightStyle();
                                        jQuery('#response-message').fadeIn(600).delay(10000).fadeOut(900);
                                        jQuery('.UnassignProjectEmployee[id='+data.id+']').replaceWith('to '+data.date);                                    }
                        },'json');
                        jQuery(this).remove();
                    },
                    "No":function(){
                        jQuery(this).remove();
                    }
            }});
            div.dialog("open");
            return false;
        });
    });
</script>
<div id="debug">
    
</div>