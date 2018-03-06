
<div id="popup1" class="HRoverlay">
  <div class="HRpopup">
    <a class="HRclose" href="#">×</a>
    <div class="HRcontent"> </div>
  </div>
</div>

<div class="right_col" role="main">
      <div class="">
        <div class="page-title">
          <div class="title_left">
           
          </div>
          <div class="title_right">
            <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
             
            </div>
          </div>
        </div>
        <div class="clearfix"></div>
        <div class="row">
          <div class="clearfix"></div>
          <div class="col-md-12 col-sm-12 col-xs-12">
    
      <div class="x_panel">
        <div class="x_title">
            <h2>Define Sessions for Training : <?php echo $training_topic;?> </h2>
          
          <div class="clearfix"></div>
        </div>
            
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
          <div class="x_content">
             <?php echo $this->Form->input('nu_training_id',array('type' =>'hidden','name'=>'data[calenderID]','value'=>$calenderID));?>
            <table class="table table-striped responsive-utilities jambo_table bulk_action">
              <thead>
                <tr class="head">
                   <th><strong>Trainer Name</strong></th>
                    <th><strong>Training Session</strong></th>
                    <th><strong>Session Date</strong></th>
                    <th><strong>Session Start Time - Session End Time</strong></th>
                    <th><strong>Action</strong></th>
               </tr>  
              </thead>
              <tbody>
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
			   <left>
				   <div >
					 <input type="submit" value="SUBMIT" class ='btn btn-success' id="submit_btn">
				   </div>
			    </left>
			   </td>
               <td width="50px;" colspan="2">&nbsp;</td>
             </tr>
            </tbody>
            </table>
              <?php echo $this->Form->end(); ?>
 </div>
</div>
</div>
<div class="navigation">
     <?php echo $this->Paginator->counter(); ?> Pages
     <?php echo $this->Paginator->prev('[<< Previous]', null, null, array('class' => 'disabled')); ?>
     <?php echo $this->Paginator->numbers(); ?>
     <?php echo $this->Paginator->next('[Next >>]', null, null, array('class' => 'disabled')); ?>
  </div>

  </div>
  </div>
 </div>








 <script type="text/javascript">
     $(document).ready(function(){
            var rows = <?php echo count($sessionlist);?>;
                for(var i=1;i<=rows;i++){     
                   $("#startdate_"+i).datepicker({
						numberOfMonths: 1,
						minDate: 0
                   });
                }
			var total_hrs = 0;var total_mnts = 0;
            $("[alt|='HOURS']").each(function() {
                 
               if (!isNaN(this.value) && this.value.length != 0) {
             
                  total_hrs = parseInt(total_hrs) + parseInt(this.value);
            
               }
              });

             $('#duration_hh').val(total_hrs);			  
			  
             $("[alt|='MINUTES']").each(function() {
                 
               if (!isNaN(this.value) && this.value.length != 0) {
             
                  total_mnts = parseInt(total_mnts) + parseInt(this.value);
            
               }
              });  
            $('#duration_mm').val(total_mnts);				  
        });    

   function add_time_slab(row_id){
   
        var nchld_count = $("#child_count_"+row_id).val();
				
		var key = $("#child_key_"+row_id).val();
                  
		var curr_elmt = '#control_img_'+row_id+'_'+nchld_count;
		
		$(curr_elmt).removeClass('add_control_img').addClass('remove_control_img');
			
        var chld_count = parseInt(nchld_count) + 1;		
		
		$('#control_img_'+row_id+'_'+chld_count).addClass('add_control_img'); 
		
		var html_row = '<div class="child_div_'+row_id+'_'+chld_count+'" style="width: 100%;"><input type="text" name="data[INS]['+key+']['+key+']['+chld_count+'][nu_start_time_hh]" class="round_select" maxlength="2" placeholder="HH" style="margin:2px;width:13%;" onkeypress="isNumberKey(event)" alt="HOURS"/><input type="text" name="data[INS]['+key+']['+key+']['+chld_count+'][nu_start_time_mm]" class="round_select" maxlength="2" placeholder="MM" style="margin:2px;width:13%;" onkeypress="isNumberKey(event)" alt="MINUTES"/><select style="margin: 3px;width:13%;" class="round_select" name="data[INS]['+key+']['+key+']['+chld_count+'][vc_start_time_am_pm]"><option value="AM">AM</option><option value="PM">PM</option></select>- <input type="text" name="data[INS]['+key+']['+key+']['+chld_count+'][nu_end_time_hh]" class="round_select" maxlength="2" placeholder="HH" style="margin:1px;width:13%;" onkeypress="isNumberKey(event)" alt="HOURS"/><input type="text" name="data[INS]['+key+']['+key+']['+chld_count+'][nu_end_time_mm]" class="round_select" maxlength="2" placeholder="MM" style="margin:4px;width:13%;" onkeypress="isNumberKey(event)" alt="MINUTES"/><select style="margin:1px;width:13%;" class="round_select" name="data[INS]['+key+']['+key+']['+chld_count+'][vc_end_time_am_pm]"><option value="AM">AM</option><option value="PM">PM</option></select></div><a href="#" class="add_control_img" onclick="add_time_slab('+row_id+')" id="control_img_'+row_id+'_'+chld_count+'" name="'+row_id+'_'+chld_count+'"/>';
        
		$("#parent_div_"+row_id+":last-of-type").append(html_row);
		
		$("#child_count_"+row_id).val(chld_count);	
		
		$('.remove_control_img').removeAttr("onclick", '');
	
	    $(".remove_control_img").click(function(){ remove_me(this); });
				
   }   

    function remove_me(obj){
    
	$('#control_img_'+obj.name).remove();
	
	$('.child_div_'+obj.name).remove();

    }  
</script>