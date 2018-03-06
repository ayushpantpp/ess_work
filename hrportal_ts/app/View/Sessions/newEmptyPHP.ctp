<div class="center-content">
<div class="breadCrumbHolder module">
    <div id="breadCrumb0" class="breadCrumb module">
        <ul>
            <li><a href="<?php echo $this->webroot;?>employees/dashboard" class="vtip" title="Home">Home</a></li>
            <li><a href="<?php echo $this->webroot;?>selfservices/#training" class="vtip" title="Training Management">Training Management</a></li>
            <li>Session Master</li>
        </ul>
    </div>
</div>
<h2 class="demoheaders">Session Master</h2>
<div class="travel-voucher1">
  <div class="input-boxs">
  
		<?php echo $this->Form->create('TrainingSession', array('url' => array('controller' => 'sessions', 'action' => 'assign_sessions_slub')));
 
		$training_date = date('m/d/Y',strtotime($TrainingData['Trainingcalender']['training_from']));
		
		$training_end_date = date ('m/d/Y',strtotime($TrainingData['Trainingcalender']['training_to']));
		
		if($training_date !=$training_end_date){
		  $msg = 'Training date from '.$training_date.' To '.$training_end_date;
		}else{
		  $msg = 'Training date '.$training_date;
		}
		
		?>
		<input type="hidden" name="data[training_status]" value="<?php echo base64_decode($this->params['pass']['2']);?>" />
		<table class="exp-voucher" border="0" cellpadding="5" cellspacing="0" width="100%" id="master_table">
		<tbody>
		       <tr class="head">
		         <th scope="row" colspan="6" width="100%" align="left">Define Sessions for Training : <?php echo $training_topic;?></th>
			   </tr>
		</tbody>
      </table>
	  </br></br>
	  <?php echo $this->Form->input('nu_training_id',array('type' =>'hidden','name'=>'data[calenderID]','value'=>$calenderID));?>
	  <table width="100%" cellspacing="1" cellpadding="5" border="0" class="exp-voucher" id="session_master_tbl">
     <tbody>
        <tr class="head">
             <th width="22%" height="30"><strong><center>Trainer Name</center></strong></th>
             <th width="20%" height="30"><strong><center>Training Session</center></strong></th>
			 <th width="9%" height="30"><strong><center>Session Date</center></strong></th>
             <th width="" height="30"><strong><center>Session Start Time - Session End Time</center></strong></th>             
			 <th width="6%" height="30"><strong><center>Action</center></strong></th>
		</tr>
           <?php 
           
            if(isset($topicType) && $topicType=='E'){
                
			 $k=1;
             foreach($trainerlist as $key=>$list){?>
             <tr class="cont" id="session_row_<?php echo $k;?>">
				 <td height="30">				 
				 <?php 
				    if(!empty($trainerlist)){
						 echo $this->Form->input('trainer_code_'.$k, array('type' => 'select',
						 'class' =>'round_select', 
						 'label' => false,
						 'div' => false,
						 'name'=>'data[INS]['.$key.'][vc_trainer_id]',
						 'options'=>$trainerlist));
			        }else { 					  
					    echo $this->Form->input('trainer_name_'.$k, array('type' => 'text',
						 'class' =>'round_select', 
						 'label' => false,
						 'div' => false,
						 'name'=>'data[INS]['.$key.'][trainer_name]',
						 'id'=>'trainer_name_'.$k,
						 'onkeydown'=>'trainer_name_auto("'.$k.'")'));						 
						echo $this->Form->input('trainer_code_'.$k, array('type' => 'hidden',
                        'id'=>'trainer_code_'.$k,
						'name'=>'data[INS]['.$key.'][vc_trainer_id]',
                        'div' => false));
				 }?> 
				 </td>
				 <td height="30"><?php echo $this->Form->input('session_'.$k, array('type' => 'select', 
				 'class' =>'round_select', 
				 'label' => false,
				 'div' => false,
				 'name'=>'data[INS]['.$key.'][nu_session]',
				 'options'=>$sessionlist));
				 ?>
				 </td>
				 <td height="30">
                                    
				  <?php echo $this->Form->input('date_'.$k,
					array('type' => 'text',
					 'class' =>'round_select vtip', 
					 'label' => false,
					 'id'=>'startdate_'.$k,
					 'readonly'=>'readonly',
                                         'style'=>'text-align: center;width:95%;',
					 'name'=>'data[INS]['.$key.'][vc_session_date]',
					 'value'=>date('Y-m-d',strtotime($TrainingData['Trainingcalender']['training_from'])),
					 'title'=>$msg
					 )); 
				     ?>
				 </td>
				 <td height="30">
				 <div style="float: left; overflow-x: hidden; overflow-y: scroll; max-height: 214%;" id="parent_div_<?php echo $k;?>"> 
				   
					 <!-------- START FIRST CHILD DIV ----------------------->
					 <div class="child_div_<?php echo $k;?>_1" style="width: 100%;">
					    <input type="text" name="data[INS][<?php echo $key;?>][<?php echo $key;?>][1][nu_start_time_hh]" class="round_select" maxlength="2" placeholder="HH" style="margin: 1px;width:13%" onkeypress="isNumberKey(event)" alt="HOURS"/>
						
						<input type="text" name="data[INS][<?php echo $key;?>][<?php echo $key;?>][1][nu_start_time_mm]" class="round_select" maxlength="2" placeholder="MM" style="margin: 1px;width:13%" onkeypress="isNumberKey(event)" alt="MINUTES"/>
						
						<select style="margin: 1px;width:13%;" class="round_select" name="data[INS][<?php echo $key;?>][<?php echo $key;?>][1][vc_start_time_am_pm]"><option value="AM">AM</option><option value="PM">PM</option></select>
						 -
						 <input type="text" name="data[INS][<?php echo $key;?>][<?php echo $key;?>][1][nu_end_time_hh]" class="round_select" maxlength="2" placeholder="HH" style="margin: 1px;width:13%" onkeypress="isNumberKey(event)" alt="HOURS"/>
						 
						<input type="text" name="data[INS][<?php echo $key;?>][<?php echo $key;?>][1][nu_end_time_mm]" class="round_select" maxlength="2" placeholder="MM" style="margin: 1px;width:13%" onkeypress="isNumberKey(event)" alt="MINUTES"/>
						
						<select style="margin: 1px;width:13%;" class="round_select" name="data[INS][<?php echo $key;?>][<?php echo $key;?>][1][vc_end_time_am_pm]"><option value="AM">AM</option><option value="PM">PM</option></select>
					  </div>
				  <!-------- END FIRST CHILD DIV ----------------------->
				 <?php echo $this->Html->link('','#',array('class'=>'add_control_img','name'=>$k.'_1','id'=>'control_img_'.$k.'_1','onclick'=>'add_time_slab("'.$k.'")'));?>
				</div>
                    <input type="hidden" id="child_count_<?php echo $k;?>" value="1">
					<input type="hidden" id="child_key_<?php echo $k;?>" value="<?php echo $key;?>">	
				 </td>
                 <td height="30">
				  <?php echo $this->Html->link('','#',array('class'=>'vtip','name'=>'remove_btn_'.$k,'id'=>'remove_img','title'=>'Remove session','onclick'=>'remove_row("'.$k.'")'));?>
				 </td>					 
             </tr>
           <?php $k++;}?>
           <?php }?>
		      <?php //echo $this->Form->input('duration_hh', array('type' => 'hidden','id' => 'duration_hh','name'=>'data[nu_session_hh]'));?>
			  <?php //echo $this->Form->input('duration_mm', array('type' => 'hidden','id' => 'duration_mm','name'=>'data[nu_session_mm]'));?>
             <input type="hidden" id="countRows" value="<?php echo count($sessionlist);?>"/>
			 <tr>
               <td height="30" colspan="2">&nbsp;</td>
               <td height="30">
			   <center>
				   <div class="submit-form">
					 <input type="submit" value="SUBMIT" id="submit_btn">
				   </div>
			    </center>
			   </td>
               <td width="50px;" colspan="2">&nbsp;</td>
             </tr>
     </tbody>
     </table>
	 <?php echo $this->Form->end(); ?>
	</div>
  </div>
 </div>