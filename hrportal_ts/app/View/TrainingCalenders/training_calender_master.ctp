
<?php
echo $this->Form->create('Trainingcalender', array('url' => array('controller' => 'trainingcalenders', 'action' => 'training_calender_master'),'onsubmit'=>'return calendarValidate();'));
		
echo $this->Form->input('Trainingcalender.nu_request_id', array('type' =>'hidden','value'=>@$requestID));

echo $this->Form->input('processingType', array('type' =>'hidden','value'=>@$this->params['pass']['2'] ?@$this->params['pass']['2'] : 'CONS','name'=>'data[processingType]'));

$idf = @$trainingData['TrainingMaster']['vc_identified_from'];
?>

<div role="main" class="right_col">
      <div class="">
       
        <div class="clearfix"></div>
        <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
             <div class="x_panel">
              <div class="x_title">
                <h2>Assign Training Calendar</h2>
              <div class="clearfix"></div>
              </div>
              <div></div><div class="x_content"> <br />
                
                  <div class="form-group col-md-6 col-sm-6 col-xs-6">
                    <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Training Identified : </label>
                    <div class="col-md-8 col-sm-8 col-xs-12">
                    <div class='col-md-3' >
                    <input name="data[Trainingcalender][vc_identified_from]" class='flat' id="type_I" value="I" <?php if($idf=='I'){?>checked="checked"<?php }?> type="radio">&nbsp; Induction
                    </div>
                    <div class='col-md-3'>
                       <input name="data[Trainingcalender][vc_identified_from]" class='flat' id="type_A" <?php if($idf=='A'){?>checked="checked"<?php }?>value="M" type="radio">&nbsp; Appraisal
                    </div>
                    <div class='col-md-3'>
                       <input name="data[Trainingcalender][vc_identified_from]" class='flat' id="type_M" <?php if($idf=='M'){?>checked="checked"<?php }?>value="M" type="radio">&nbsp; MD/VP
                    </div>
                    <div class='col-md-3'>
                       <input name="data[Trainingcalender][vc_identified_from]" class='flat' id="type_O" value="O" type="radio" <?php if($idf=='O'){?>checked="checked"<?php }?>>&nbsp; Others
                    </div>
			
                    </div>
                  </div>
                   <div class="form-group col-md-6 col-sm-6 col-xs-6">
                    <label class="control-label col-md-4 col-sm-4 col-xs-12">Training Required :</label>
                    <div class="col-md-8 col-sm-8 col-xs-12">
                      <?php 
                      $topicId = @$trainingData['MstTrainingRequests']['training_topic_id'];
                      
                      echo $this->Form->input('Trainingcalender.vc_topic_id', array('type' => 'select','class'=>'form-control','label' => false,'options'=>$courselist,'selected'=>@$topicId,'onchange'=>'getFiles()')); ?>
                    </div>
                  </div>
                  <div class="form-group col-md-6 col-sm-6 col-xs-6">
                    <label class="control-label col-md-4 col-sm-4 col-xs-12" for="last-name">Training Type: <span class="required">*</span> </label>
                    <div class="col-md-8 col-sm-8 col-xs-12">
                      <?php echo $this->Form->input('Trainingcalender.vc_training_type', array('type' => 'select', 'class' =>'form-control', 'label' => false,'div' => false,'options'=>array(''=>'Select','INTERNAL'=>'Internal','EXTERNAL'=>'External')));?>
                    </div>
                  </div>
                  <div class="form-group col-md-6 col-sm-6 col-xs-12" style="line-height:35px;">
                    <label for="middle-name" class="control-label col-md-4 col-sm-4 col-xs-12">Training Start Date:</label>
                    <div class="col-md-5 col-sm-5 col-xs-12">
                        <?php 
				
                        $request_date = @$trainingData['MstTrainingRequests']['training_date'];

                        if(isset($request_date)){
                           $trng_date = date ('m/d/Y',strtotime($request_date));
                        }else{			
                           //$trng_date = date('m/d/Y',strtotime("+15 days", strtotime(date('Y-m-d'))));

                           $trng_date = date('m/d/Y',strtotime(date('Y-m-d')));
                        }
                        echo $this->Form->input('Trainingcalender.vc_training_from',
                           array('type' => 'text',
                           'class' =>'form-control', 
                           'label' => false,
                           'readonly'=>true,
                           'value'=>$trng_date)); 
                        ?>
                    </div>

                    
                  </div>
                 
                  <div class="form-group col-md-6 col-sm-6 col-xs-6">
                    <label for="middle-name" class="control-label col-md-4 col-sm-4 col-xs-12">Training End Date:</label>
                   
                      <div class="col-md-8 col-sm-8 col-xs-12">
                      <?php echo $this->Form->input('Trainingcalender.vc_training_to',
				   array('type' => 'text',
				   'class' =>'form-control', 
				   'label' => false,    
				   'readonly'=>true,
				   'value'=>$trng_date)); 
				?>
                      </div>
                 </div>
                  
                <div class="form-group col-md-6 col-sm-6 col-xs-6">
                    <label class="control-label col-md-4 col-sm-4 col-xs-12">Training Start Time </label>
                    <div class="col-md-8 col-sm-8 col-xs-12">
                    <div class='col-md-3'>
                    <?php echo $this->Form->input('Trainingcalender.nu_start_hh', array('type' => 'text',
					'class' =>'form-control', 
					'label' => false,
					'div' => false,
					'maxlength'=> 2,
					'onkeypress'=>'return isNumberKey(event)',
					'style'=>'width:59px;',
					'placeholder'=>'HH'));?>	
			    
                    </div>
                    <div class='col-md-3'>
                    <?php echo $this->Form->input('Trainingcalender.nu_start_mm', array('type' => 'text', 
					'class' =>'form-control', 
					'label' => false,
					'div' => false,
					'maxlength'=> 2,
					'onkeypress'=> 'return isNumberKey(event)',
					'style'=>'width:57px;',
					'placeholder'=>'MM'));?>    
                    </div>
                    <div class='col-md-3'>
                        <?php echo $this->Form->input('Trainingcalender.vc_start_am_pm', array('type' => 'select', 'class' =>'form-control', 
					'label' => false,
					'div' => false,
					'style'=>'width:80px;',
					'options'=>array('AM'=>'AM','PM'=>'PM')));?>
                    </div>    
                     
                    </div>
                  </div>
                  <div class="form-group col-md-6 col-sm-6 col-xs-12" style="line-height:35px;">                      
                    <label for="middle-name" class="control-label col-md-4 col-sm-4 col-xs-12">Training End Time<span class="required">*</span></label>
                    <div class="col-md-5 col-sm-5 col-xs-12">
                      <div class='col-md-3'>
                        <?php echo $this->Form->input('Trainingcalender.nu_end_hh', array('type' => 'text', 
					'class' =>'form-control',
					'label' => false,
					'div' => false,
					'maxlength'=> 2,
                                        'style'=>'width:59px;',
					'onkeypress'=>'return isNumberKey(event)',
					'placeholder'=>'HH'));?>	
				    
                      </div> 
                      <div class='col-md-3'>
                       <?php echo $this->Form->input('Trainingcalender.nu_end_mm', array('type' => 'text',
                        'class' =>'form-control',
                        'label' => false,
                        'div' => false,
                        'maxlength'=> 2,
                        'style'=>'width:57px;',   
                        'onkeypress'=> 'return isNumberKey(event)',
                        'placeholder'=>'MM'));?>
				     
                      </div>    
                      <div class='col-md-3'>
                        <?php echo $this->Form->input('Trainingcalender.vc_end_am_pm', array('type' => 'select',
                            'class' =>'form-control', 
                            'label' => false,
                            'div' => false,
                            'style'=>'width:80px;',
                            'options'=>array('AM'=>'AM','PM'=>'PM')));?> 
    
                      </div>      
                    		
                    </div>
                    
                    </div>
                
                  <div class="form-group col-md-6 col-sm-6 col-xs-6">
                    <label for="heard" class="control-label col-md-4 col-sm-4 col-xs-12">Training Duration:</label>
                    <div class="col-md-8 col-sm-8 col-xs-12">
                        <div class='col-md-3'>
                       <?php echo $this->Form->input('Trainingcalender.nu_duration_hh', array('type' => 'text',
                        'class' =>'form-control',
                        'label' => false,
                        'div' => false,
                        'value'=>@$trainingData['MstTrainingRequests']['duration_hh'],
                        'style'=>'width:80px;',
                        'maxlength' => '2',
                        'onkeypress'=> 'return isNumberKey(event)',
                        'placeholder'=>'Hours')
			);
			?>
                        </div> 
                        <div class='col-md-3'>
                        <?php echo $this->Form->input('Trainingcalender.nu_duration_mm', array('type' => 'text',
                                        'class' =>'form-control', 
                                        'label' => false,
                                        'div' => false,
                                        'style'=>'width:80px;',
                                        'maxlength' => '2',
                                        'onkeypress'=> 'return isNumberKey(event)',
                                        'value'=>@$trainingData['MstTrainingRequests']['duration_mm'],
                                        'placeholder'=>'Minutes'));
                        ?>
                       </div>      
                    </div>
                  </div>
                  
                   <div class="form-group col-md-6 col-sm-6 col-xs-6">
                    <label for="heard" class="control-label col-md-4 col-sm-4 col-xs-12">Required Trainee:</label>
                    <div class="col-md-8 col-sm-8 col-xs-12">
                        <div class='col-md-3'> 
                            <?php echo $this->Form->input('Trainingcalender.nu_min_trainees', array('type' => 'text', 
					'class' =>'form-control',
					'label' => false,
					'div' => false,
					'maxlength' => '4',
					'onkeypress'=> 'return isNumberKey(event)',
					));?>
                            <div class='col-md-3'> <strong>Minimum</strong></div>
					
                        </div>
                        <div class='col-md-3'>
                         <?php echo $this->Form->input('Trainingcalender.nu_max_trainees', 
					array('type' => 'text', 
					'class' =>'form-control',
					'maxlength' => '4',
					'onkeypress'=> 'return isNumberKey(event)',
					'label' => false,
					
					'div' => false));?>
					<div class='col-md-3'> <strong>Maximum</strong></div>
                       
                    </div>
                  </div>
                    </div>  
                   <div class="form-group col-md-6 col-sm-6 col-xs-6">
                    <label for="heard" class="control-label col-md-4 col-sm-4 col-xs-12">Most Popular Training:</label>
                    <div class="col-md-8 col-sm-8 col-xs-12">
                      <input name="data[Trainingcalender][vc_most_popular]" class= 'flat' id="most_popular" value="Y" type="radio">&nbsp; Yes
                      <input name="data[Trainingcalender][vc_most_popular]" class= 'flat'  id="most_popular" value="N" type="radio" checked="checked">&nbsp; No
                    </div>
                  </div>
                  <div class="form-group col-md-6 col-sm-6 col-xs-6">
                    <label for="heard" class="control-label col-md-4 col-sm-4 col-xs-12">Training Mode:</label>
                    <div class="col-md-8 col-sm-8 col-xs-12">
                       <?php echo $this->Form->input('Trainingcalender.vc_training_mode', array('type' => 'select', 'class' =>'form-control', 'label' => false,'div' => false,'style'=>'width:178px;','options'=>array(''=>'Select','WEBEX'=>'Webex','ONLINE'=>'Online','Class'=>'form-control','BOTH'=>'Both'),'id'=>'training_mode'));?>
                    </div>
                  </div>
                 
                 
                   <div class="form-group col-md-6 col-sm-6 col-xs-6">
                    <label for="heard" class="control-label col-md-4 col-sm-4 col-xs-12">Post Training Required:</label>
                    <div class="col-md-8 col-sm-8 col-xs-12">
                     <input name="data[Trainingcalender][vc_pte_required]" id="post_trainingY" class= 'flat' value="Y" onclick="disable_mode(),getFiles()" type="radio">&nbsp; Yes
                     <input name="data[Trainingcalender][vc_pte_required]" id="post_trainingN" class= 'flat' value="N" type="radio" onclick="disable_mode(),getFiles()"	checked="checked">&nbsp; No
                    </div>
                  </div>
                   
                 
                  </div>
                   
                 
                  <div class="ln_solid"></div>
                  <div class="form-group col-md-12 col-sm-6 col-xs-6">
                  <div class="col-md-8 col-sm-8 col-xs-12  " id="Park-Button">
                    
                    <input  type="submit" class="btn btn-success" name='data[Submit]' id ='assigncal' value="Assign Calendar"   >
                      
                  </div>
                   
                  </div> 
                   <input name="data[Trainingcalender][vc_topic_type]" value="E" type="hidden" />
                  <?php $this->form->end(); ?>

              </div>
          </div>
        </div>
      </div>
      </div>
    

