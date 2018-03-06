
<script language="javascript" type="text/javascript">
	$(document).ready(function() {
		$('#btnRight').click(function(e) {
			var selectedOpts = $('#lstBox1 option:selected');
			var selectedOptsVals = $('#lstBox1').val().toString();
			if (selectedOpts.length == 0) {
				alert("Nothing to move.");
				e.preventDefault();
			}
			$('#lstBox2').append($(selectedOpts).clone());
                        
			$(selectedOpts).remove();
                        
			e.preventDefault();
			
			var myArray = selectedOptsVals.split(',');

			for(var i=0;i<myArray.length;i++){
			   $('#trainees_list_div').append('<input type="hidden" name="data[TrainingMasterDetail][trainee_code][]" value="'+myArray[i]+'"/>');
			}
		});	
		$('#btnLeft').click(function(e) {
			var selectedOpts = $('#lstBox2 option:selected');
			var selectedOptsVals = $('#lstBox2').val().toString();
			if (selectedOpts.length == 0) {
				alert("Nothing to move.");
				e.preventDefault();
			}
			$('#lstBox1').append($(selectedOpts).clone());
			$(selectedOpts).remove();
			e.preventDefault();
			var myArray = selectedOptsVals.split(',');
			for(var i=0;i<myArray.length;i++){
	                     $('input[value="'+myArray[i]+'"]').remove();
			}
		});
		 $("#TrainingMasterVcTrainingDate").datepicker({
			numberOfMonths: 1,
			minDate: '+<?php echo $date;?>D',			
			beforeShowDay: function(dt) {
			
			var day = dt.getDay();

			var month = dt.getMonth();

			var year = dt.getFullYear();
			var date_str = "<?php echo $dateStr;?>";
			var datelist = date_str.split(",");
			var dmy = "";
			dmy += ("00" + dt.getDate()).slice(-2) + "-";
			dmy += ("00" + (dt.getMonth() + 1)).slice(-2) + "-";
			dmy += dt.getFullYear();
			
			    if (day == 6 ){
				   if($.inArray(dmy, datelist) >= 0) {
					   return [false, ""]
					}else{
					   return [true, ""]
					}
				}else if(day == 0) {
			   
				  return [false, ""]
				  
				}else {
				  return [true, ""]
			   }
			}
         });
	});
/**
**
*Function to check that users fill  number only
**
**/
	
	function isNumberKey(evt){
    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;
    return true;
}	
</script>
				
<script type="text/javascript">

function formValidate(){

$topic_type = $('#topicType').val();

$trainDate = $('#TrainingMasterVcTrainingDate').val();

$durationH = $('#TrainingMasterNuDurationHh').val();

$durationM = $('#TrainingMasterNuDurationMm').val();

var $error='';

if($topic_type=='E' && $('#TrainingMasterVcTrainingTopicId').val() ==''){

 $error+="Training required shall not be empty.\n"

}else if($topic_type=='N' && $('#TrainingMasterVcTrainingName').val() ==''){

 $error+="Training required shall not be empty.\n"

}

if($trainDate==''){

$error+="Please fill training date.\n"

}
if($durationH=='' && $durationM==''){

	$error+="Please fill duration.\n"
}

if($durationH=='0' && $durationM=='' || $durationH=='' && $durationM=='0' || $durationH=='00' && $durationM=='' || $durationH=='' && $durationM=='00'){

	$error+="Training duration should be greater than zero.\n"

}

if($durationH=='0' && $durationM=='0' || $durationH=='00' && $durationM=='00' || $durationH=='00' && $durationM=='0' || $durationH=='0' && $durationM=='00'){

	$error+="Training duration shall be greater than zero.\n"

}

if($durationM >= 60){

	$error+="Training duration minutes shall not be greater than 59.\n"
}

if ($error== ''){

		}else {
				 alert($error);
				 return(false);
		 }	
}
</script>

   <?php
if ($desig_code == 'PAR0000035') {
    $date = '0';
} else {
    $date = '16';
}
$dateStr = '';

if (date('Y')) {
    for ($i = date('m'); $i <= 12; $i++) {
        if ($i < 10) {
            $i = '0' . $i;
        }
        $year = date('Y');
        $monthName = date("F", mktime(0, 0, 0, $i, 10));

        $dateStr .= date('d-m-Y', strtotime('second sat of ' . $monthName . ' ' . $year)) . ',';

        $dateStr .= date('d-m-Y', strtotime('fourth sat of ' . $monthName . ' ' . $year)) . ',';
    }
}

for ($i = 1; $i <= 12; $i++) {

    if ($i < 10) {
        $i = '0' . $i;
    }

    $nextyear = date('Y') + 1;

    $monthName = date("F", mktime(0, 0, 0, $i, 10));

    $dateStr .= date('d-m-Y', strtotime('second sat of ' . $monthName . ' ' . $nextyear)) . ',';

    $dateStr .= date('d-m-Y', strtotime('fourth sat of ' . $monthName . ' ' . $nextyear)) . ',';
}
?>

    <div class="right_col" role="main">
      <div class="">
        <div class="page-title">
          <div class="title_left">
            <h3>Update Training Identification Request</h3>
          </div>
        </div>
        <div class="clearfix"></div>
        <div class="row" >
          <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
              <div class="x_title">
                <h2>Update Training Identification Request</h2>
                </ul>
                <div class="clearfix"></div>
              </div>
              <div class="x_content"> <br />
                
                <?php echo $this->form->create('TrainingMaster', array('url' => array('controller' => 'trainingmasters', 'action' => 'training_identification_form_edit'),'onsubmit'=>'return formValidate();'));
		  echo $this->form->input('TrainingMaster.nu_request_id', array('type' =>'hidden','value'=>$nu_request_id));
	        ?>
	
                <?php $auth=$this->Session->read('Auth');?>
                  <div class="form-group col-md-6 col-sm-6 col-xs-12">
                    <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Training Name:<span class="required">*</span> </label>
                      <div class="col-md-8 col-sm-8 col-xs-12">
                    <?php 
				$topic_type = $trainData['MstTrainingRequests']['training_topic_type'];
				
				if($topic_type == 'E'){
				    $topicId = $trainData['MstTrainingRequests']['training_topic_id'];
				?>
				<?php echo $this->form->input('vc_training_topic_id', array('type' => 'select', 'name'=>'data[MstTrainingRequests][topic_id]', 'class' =>'form-control', 'label' => false, 'options'=>$courselist,'default'=>$topicId)); ?> 
				
				<?php } else { 
				  $topicname = $trainData['MstTrainingRequests']['training_name'];
				?>
				<?php echo $this->form->input('vc_training_name', array('type' => 'text','name'=>'data[TrainingMaster][topic_name]', 'class' =>'form-control col-md-7 col-xs-12','label' => false,'placeholder'=>'Training Topic Name','value'=>$topicname)); ?>
				<?php }?>
				   <input type="hidden" name="data[MstTrainingRequests][training_topic_type]" value="<?php echo $topic_type;?>" id="topicType"/>
                    </div>
                  </div>
                 
                 
                  <div class="form-group col-md-6 col-sm-6 col-xs-12">
                    <label for="middle-name" class="control-label col-md-4 col-sm-4 col-xs-12">Desired Training Date:<span class="required">*</span></label>
                    <div class="col-md-6 col-sm-6 col-xs-6">
                      <input type="text" id="TrainingMasterVcTrainingDate" value="<?php echo date('m/d/Y',strtotime($trainData['MstTrainingRequests']['training_date']));?>" readonly="readonly" class="form-control col-md-7 col-xs-12" name="data[TrainingMaster][vc_training_date]">
                    </div>
                  </div>
                  <div class="form-group col-md-6 col-sm-6 col-xs-12" style="line-height:35px;">
                    <label for="middle-name" class="control-label col-md-4 col-sm-4 col-xs-12">Training Duration:<span class="required">*</span></label>
                    <div class="col-md-5 col-sm-5 col-xs-12">
                        <div class='col-md-4'>
                            <input type="text" id="TrainingMasterNuDurationHh"  onkeypress="return isNumberKey(event)" maxlength="2" placeholder="Hours" value="<?php echo $trainData['MstTrainingRequests']['duration_hh'];?>" class="form-control"  name="data[TrainingMaster][nu_duration_hh]"/>				   
                        </div>
                        <div class='col-md-3'>
                          <input type="text" id="TrainingMasterNuDurationMm"  onkeypress="return isNumberKey(event)" maxlength="2" placeholder="Minutes" value="<?php echo $trainData['MstTrainingRequests']['duration_mm'];?>" class="form-control" style="width:60px; "name="data[TrainingMaster][nu_duration_mm]"/>   
                        </div>
                       
		      

                    </div>
                 </div>
                <?php if ( count($selected_emps)!=0 || $desig_code == 'PAR0000035') { ?>
                <div class="form-group col-md-6 col-sm-6 col-xs-12" >
                    <label for="middle-name" class="control-label col-md-4 col-sm-4 col-xs-12">Self Include:<span class="required">*</span></label>
                    <div class="col-md-8 col-sm-8 col-xs-12">
                      <input name="data[MstTrainingRequests][self_include]" class='flat' id="ch_st_daylengthf" value="Y" type="radio" <?php if($trainData['MstTrainingRequests']['self_include']=='Y'){?>checked="checked"<?php }?>>&nbsp; Yes
		      <input name="data[MstTrainingRequests][vc_self_include]" class='flat' id="ch_st_daylengthh" value="N" type="radio" <?php if($trainData['MstTrainingRequests']['self_include']=='N'){?>checked="checked"<?php }?>>&nbsp; No
                    </div>
                   
                    <div class="form-group col-md-10 col-sm-6 col-xs-12">
                    <label for="middle-name" class="control-label col-md-4 col-sm-4 col-xs-12"> List of Employees:<span class="required">*</span></label>
                    <div class="col-md-6">
                        <?php echo $this->form->input('', array('type' => 'select',
                        'class' =>'form-control', 
                        'multiple' => true,
                        'label' => false,
                        'options'=>$remaining_emps,
                        'id'=>'lstBox1',
                        'style'=>'height:140px;')); 
                        ?>
                         
                    </div>
                    <div class='col-md-1'>
                        <input type="button" id="btnRight" value =" => "/>
                    </div>
                    <div class='col-md-1'>
                        <input type="button" id="btnLeft" value =" <= "/>
                    </div>    
                    </div>
                    
                <div class="form-group col-md-6 col-sm-8 col-xs-12">
                    <label class="control-label col-md-4 col-sm-4 col-xs-12" for="Message">List of Trainees:<span class="required">*</span> </label>
                    <div class="col-md-8 col-sm-8 col-xs-16">
                    
                    <?php echo $this->form->input('TrainingMasterDetail.vc_trainee_code', array('type' => 'select', 
							'class' =>'form-control',
							'multiple' => true,
							'label' => false,
							'options' =>$selected_emps,
							'id'=>'lstBox2',
							'style'=>'height:140px;')); ?>
							<div id="trainees_list_div">
							<?php foreach($selected_emps as $k=>$val){?>
							   <input type="hidden" name="data[TrainingMasterDetail][trainee_code][]" value="<?php echo $k;?>"/>
							<?php }?>
							</div>
                        <input name="data[TrainingMasterDetail][vc_type]" id="type_manager" value="M" type="hidden">
                    </div>
                  </div>
               </div>
                <?php } else { ?>
                    <input name="data[TrainingMaster][vc_self_include]" type="hidden" value="Y"/>
                 <?php } ?>
                
               
              </div>
                
                  <div class="ln_solid"></div>
                  
                  <div class="form-group col-md-12 col-sm-6 col-xs-6">
                    <div class="col-md-8 col-sm-8 col-xs-12">
                   <div class ="col-md-3">
                    <input type="submit" class="form-group btn btn-success" value="Update" name ='data[Update]'>      
                   
                   </div>    
                    <div class ="col-md-3"> 
                    <?php if(in_array($desig_code,$designations)){?>
                    <?php echo $this->form->submit(__('final Submit',true), array('name'=>'data[Submit]'));?>
                   <?php }else {
                        $checllvl = $this->Common->findcheckLevel(6,'DEPT00006',01);
                        $fwemplist = $this->Common->findLevel($checllvl,'Apply');
                       ?>
                    
                      <?php echo $this->Form->input('TrainingMaster.emp_code', array('type' => 'select', 'label' => false, 'empty' => '- -Select- -', 'options' => $fwemplist, 'class' => 'form-control','id'=>'fwlvempcode')); ?>
                         </div>    
                        <div class='col-md-3'>
                       <input type="submit" class="form-group btn btn-success" value="Submit to manager" name ='data[MoveTo]'>       
                      
                        </div>
                    <?php }?>
                   
                    </div>
                  </div>
                 
              <div id="hidden_values"></div>
               <?php echo $this->Form->end(); ?>
        
              </div>
            </div>
          </div>
        </div>
      </div>


    



