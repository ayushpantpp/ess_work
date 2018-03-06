<?php if($desig_code =='PAR0000035'){
  $date = '0';
}else{
  $date = '16';
}
$dateStr = '';

  if(date('Y')){
		for( $i = date('m'); $i<=12; $i++){
			if($i < 10){
			  $i = '0'.$i;		
			}
			$year = date('Y');
			$monthName = date("F", mktime(0, 0, 0, $i, 10));
			
			$dateStr .= date('d-m-Y', strtotime('second sat of '.$monthName.' '.$year)).',';

			$dateStr .= date('d-m-Y', strtotime('fourth sat of '.$monthName.' '.$year)).',';

		}
  }
  
  for($i = 1;$i<=12;$i++){
           
		   if($i < 10){
			  $i = '0'.$i;		
			}
	       
		   $nextyear = date('Y')+1;
			
			$monthName = date("F", mktime(0, 0, 0, $i, 10));
			
			$dateStr .= date('d-m-Y', strtotime('second sat of '.$monthName.' '.$nextyear)).',';

			$dateStr .= date('d-m-Y', strtotime('fourth sat of '.$monthName.' '.$nextyear)).',';
    }
 
?>
<script language="javascript" type="text/javascript">
	$(document).ready(function() {
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
			
			$workingdays_count = 0;
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

   $(function(){
        $('#dialog').dialog({
            autoOpen: false,
            width: 600,
            buttons: {
                "Ok": function() {
                    var cmnt = $('#cmnt').val();
					 $("#new_remark").val(cmnt);
                    if(cmnt==' ')
                    {     $('#errdis').show('slow', function() {
                            // Animation complete.
                        });
                        return false;
                    }else{
			$(this).dialog("close");
                          $("#TrainingMasterManagerTrainingIdentificationForm").submit();
                    }
                },
                "Cancel": function() {
                    $(this).dialog("close");
                }
            }
        });
		$('#more_trainees').dialog({
				autoOpen: false,
				width: 790
			});
    });
	
function reject1(sno,empid)
    {

        $('#dialog').dialog('open');
        return false;
    }

    function getcmtval()
    {
        var voucherno=document.getElementById("cmnt").value;
        var rjres=document.getElementById("rejectres").value=voucherno;

    }
	
	function addMoreTrainees()
    {
		
		
		var reqID = $('#reqestID').val();
		
		$.post('<?php echo $this->webroot; ?>trainingmasters/reportedEmps',{reqID:reqID},function(data) {
                    
		   $('.HRcontent').html(data);		 
		});

    }

</script>
<div id="popup1" class="HRoverlay">
  <div class="HRpopup">
    <a class="HRclose" href="#">×</a>
    <div class="HRcontent big-table"> </div>
  </div>
</div>

<div class="right_col" role="main">
      <div class="">
        <div class="page-title">
          <div class="title_left">
            <h3>Sanction Training Identification Request</h3>
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
                
               <?php echo $this->Form->create('TrainingMaster', array('url' => array('controller' => 'trainingmasters', 'action' => 'manager_training_identification'),'onsubmit'=>'return formValidate();','name'=>'sanction_manager_frm'));
		
		echo $this->Form->input('TrainingMaster.nu_request_id', array('type' =>'hidden','value'=>$nu_request_id,'id'=>'reqestID'));
		echo $this->Form->input('vc_remarks', array('type' =>'hidden','id'=>'new_remark'));
		?>
	
                <?php $auth=$this->Session->read('Auth');?>
                  <div class="form-group col-md-6 col-sm-6 col-xs-12">
                    <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Training Required:<span class="required">*</span> </label>
                      <div class="col-md-8 col-sm-8 col-xs-12">
                    <?php 
				$topic_type = $requestData['MstTrainingRequests']['training_topic_type'];
				
				if($topic_type == 'E'){
				    $topicId = $requestData['MstTrainingRequests']['training_topic_id'];
				?>
				<?php echo $this->form->input('vc_training_topic_id', array('type' => 'select', 'name'=>'data[MstTrainingRequests][topic_id]', 'class' =>'form-control', 'label' => false, 'options'=>$courselist,'default'=>$topicId)); ?> 
				
				<?php } else { 
				  $topicname = $requestData['MstTrainingRequests']['training_name'];
				?>
				<?php echo $this->form->input('vc_training_name', array('type' => 'text','name'=>'data[TrainingMaster][topic_name]', 'class' =>'form-control col-md-7 col-xs-12','label' => false,'placeholder'=>'Training Topic Name','value'=>$topicname)); ?>
				<?php }?>
				   <input type="hidden" name="data[MstTrainingRequests][training_topic_type]" value="<?php echo $topic_type;?>" id="topicType"/>
                    </div>
                  </div>
                 
                 
                  <div class="form-group col-md-6 col-sm-6 col-xs-12">
                    <label for="middle-name" class="control-label col-md-4 col-sm-4 col-xs-12">Desired Training Date:<span class="required">*</span></label>
                    <div class="col-md-6 col-sm-6 col-xs-6">
                      <input type="text" id="TrainingMasterVcTrainingDate" value="<?php echo date('m/d/Y',strtotime($requestData['MstTrainingRequests']['training_date']));?>" readonly="readonly" class="form-control col-md-7 col-xs-12" name="data[TrainingMaster][vc_training_date]">
                    </div>
                  </div>
                  <div class="form-group col-md-6 col-sm-6 col-xs-12" style="line-height:35px;">
                    <label for="middle-name" class="control-label col-md-4 col-sm-4 col-xs-12">Training Duration:<span class="required">*</span></label>
                    <div class="col-md-5 col-sm-5 col-xs-12">
                        <div class='col-md-4'>
                         <input type="text" id="TrainingMasterNuDurationHh"  onkeypress="return isNumberKey(event)" maxlength="2" placeholder="Hours" value="<?php echo $requestData['MstTrainingRequests']['duration_hh'];?>" class="form-control" name="data[TrainingMaster][nu_duration_hh]"/>				
		          
                        </div> 
                        <div class='col-md-3'>
                            <input type="text" id="TrainingMasterNuDurationMm" style='width:60px;' onkeypress="return isNumberKey(event)" maxlength="2" placeholder="Minutes" value="<?php echo $requestData['MstTrainingRequests']['duration_mm'];?>" class="form-control" name="data[TrainingMaster][nu_duration_mm]"/>
                        </div>     
                       

                    </div>
                 </div>
                <?php  if(count($traineeData) <= 1 ) { $addMore = 'Y';?>
                <div class="form-group col-md-6 col-sm-6 col-xs-12" >
                    <label for="middle-name" class="control-label col-md-4 col-sm-4 col-xs-12">Employee Name:</label>
                    <div class="col-md-8 col-sm-8 col-xs-12">
                        <?php
                         
                         $traineeCode = $traineeData[0]['TrainingRegistrations']['trainee_code'];
                         
		         echo $this->traininghlp->getEmpName($traineeCode);?>
                        
                     
			<input type="hidden" name="data[TrainingMasterDetail][trainee_code][]" value="<?php echo $traineeCode;?>" id="current_emp"/>
                    </div>
                   
                    
                <?php } else { $addMore = 'N';?>
                     <table class="table table-striped responsive-utilities jambo_table bulk_action">
                                                <thead>
                                                  <tr class="headings">

                                                      <th><strong>S.N0.</strong></th>
                                                      <th><strong>Employee Code</strong></th>
                                                      <th><strong>Employee Name</strong></th>
                                                  </tr>
                                                </thead>
                                                <tbody>
                                                <?php     
							if (count($traineeData) > 1) {
							 $i = 1;
							 foreach ( $traineeData as $value ){ 
								$reg_id = base64_encode($value['TrainingRegistrations']['id']);
                                                               // print_r($TrainingMasterDetail);die;
								$traineeCode = $value['TrainingRegistrations']['trainee_code'];
								if($i%2==0){
								   $class = 'cont1';			
								}else{
								   $class  = 'cont';
								}
							?>
                                                       
						   <tr class="<?php  echo $class;?>">
								<td align="center">	<?php echo $i; ?></td>
								<td><?php echo $traineeCode;?></td>
                                                                <td><?php echo $this->traininghlp->getEmpName($traineeCode);?>
								<input type="hidden" name="data[TrainingMasterDetail][trainee_code][]" value="<?php echo $traineeCode;?>"/>
								</td>
								
						     </tr>
						      <?php $i++;
						       }
							 }?>
               
           </tr>
            </tbody>
            </table>
									
                 <?php } ?>
                
               
              </div>
                
                  <div class="ln_solid"></div>
                  
                  <div class="form-group col-md-12 col-sm-6 col-xs-6">
                    <div class="col-md-8 col-sm-8 col-xs-12">
                    
                     <div class='col-md-3'>    
                      <?php
                       $checklvlapp = $this->Common->findAppLevel($appId);
                      $getlvl = $this->Common->getleveltraining($requestData['MstTrainingRequests']['identified_from'],$requestData['MstTrainingRequests']['approved_by']);
                   // $checllvl = $this->Common->findcheckLevel(6,'DEPT00006',01);
                    $fwemplist = $this->Common->findLevel();
                    if($checklvlapp < $getlvl ){ 
                     echo $this->Form->input('TrainingMaster.emp_code', array('type' => 'select', 'label' => false, 'empty' => '- -Select- -', 'options' => $fwemplist, 'class' => 'form-control col-md-7 col-xs-12','id'=>'fwlvempcode'));?>   
                     </div>
                    <div class='col-md-3'> 
                       <input type="submit" class="form-group btn btn-success" value="Submit to manager" name ='data[forward]'>         
                    
                    <?php }else{?>
                           
                     <input type="submit" class="form-group btn btn-success" value="Approve" name ='data[Approve]'>            
                    
                   <?php }
                    ?>
	            </div>   
                        <div class='col-md-3'>
                            <?php  echo $this->Html->link('Add More Trainees','#popup1',array('class'=>'btn btn-primary','id'=>'admorebtn','onclick'=>'return addMoreTrainees()'));?> 
                        </div>    
                    </div>
                  </div>
                 
              <div id="hidden_values"></div>
               <?php echo $this->Form->end(); ?>
        
              </div>
            </div>
          </div>
        </div>
      </div>

	    
 <script type="text/javascript">
function formValidate(){
$existing = $('#TrainingMasterVcTrainingTopicId').val();

$New = $('#TrainingMasterVcTrainingName').val();

$trainDate = $('#TrainingMasterVcTrainingDate').val();

$durationH = $('#TrainingMasterNuDurationHh').val();

$durationM = $('#TrainingMasterNuDurationMm').val();

var $error='';

if($existing=='' && $New==''){

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


