
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
            <h2>Process Training Identification  </h2>
          
          <div class="clearfix"></div>
        </div>
            

     <div class="x_content">

            <table class="table table-striped responsive-utilities jambo_table bulk_action">
              <thead>
                <tr class="head">
                   <th><strong>S.N.</strong></th>
				<th><strong>Training Name</strong></th>
				<th><strong>Topic Type</strong></th>
				<th><strong>Training Date</strong></th>
				<th><strong>Identified From</strong></th>
				<th><strong>Identified By</strong></th>
				<th><strong>Approved By</strong></th>
				
				<th width="12%"><strong>Action </strong></th>
	       </tr>  
              </thead>
              <tbody>
                   <?php
			if (count($paginateData) > 0) {
			 $i = 1;
			 foreach ( $paginateData as $value ) { 
			    $nu_request_id = $value['MstTrainingRequests']['request_id'];
				$type = $value['MstTrainingRequests']['training_topic_type'];
				if($type=='E'){
				  $vc_course_id = $value['MstTrainingRequests']['training_topic_id'];
				  $topicname = $this->traininghlp->getCouseName($vc_course_id);
				  $tpc_type = 'Existing';
				}else{
				  $topicname = $value['MstTrainingRequests']['training_name'];
				  $tpc_type = 'New';
				}
				if($i%2==0){
				   $class = 'cont1';			
				}else{
				   $class  = 'cont';
				}
				$identifiedBy = $value['MstTrainingRequests']['identified_by'];
				
				$approvedBy = $value['MstTrainingRequests']['approved_by'];
				
				$idf = $value['MstTrainingRequests']['identified_from'];
				
				if($idf == 'A'){
				  $idf_sourse = 'Appraisal';
				}else if($idf == 'I'){
				  $idf_sourse = 'Induction';
			    }else if($idf == 'M'){
				  $idf_sourse = 'MD/Director/GM/VP';
				}else{
				  $idf_sourse = 'Others';
				}
			?>
			<tr class="<?php echo $class;?>">
			<td align="center">	<?php echo $i; ?></td>
			<td><?php echo $topicname;?></td>
			<td><?php echo $tpc_type;?></td>
			<td><?php echo date('d-M-Y',strtotime($value['MstTrainingRequests']['training_date']));?></td>
			<td><?php echo $idf_sourse;?></td>
			<td><?php echo $this->traininghlp->getEmpName($identifiedBy);?></td>
			<td><?php echo $this->traininghlp->getEmpName($approvedBy);?></td>
			
			
			<td>
			<?php
                              
			  $nu_request_id = base64_encode($nu_request_id);

			?>
			
			       
				<?php 
                                      
					if($type =='N'){
					  echo $this->Html->link('ASSIGN CALENDARR', array('controller' => 'trainingcalenders', 'action' => 'training_calender_master','ASSIGNCALENDAR',$nu_request_id,'IND'),array('class'=>' btn btn-primary','id'=>'assign_cal','title'=>'ASSIGN CALENDAR'),'You must add course name under course master with their sessions before assign training calendar');
					}else{
					  echo $this->Html->link('ASSIGN CALENDAR', array('controller' => 'trainingcalenders', 'action' => 'training_calender_master','ASSIGNCALENDAR',$nu_request_id,'IND'),array('class'=>'btn btn-primary','id'=>'assign_cal','title'=>'ASSIGN CALENDAR'));
					}
				?>
				
			    </td>
			</tr>
			 <?php $i++; ?>
			<?php } ?>
			<?php if($paginator){?>
			<tr>
			  <td colspan="10" align="right">[<?php echo $paginator->prev(); ?> ]
                  <?php echo $paginator->numbers(array('separator'=>'&nbsp;|&nbsp;')); ?>
                 [ <?php echo $paginator->next('Next Page'); ?> ]
			  </td>
			</tr>
		 <?php }?>		 
		  <?php if (count($paginateData) >=2){?>
			<tr height="20"><td colspan="10"></td></tr>
			<tr>
			    
	      <?php }?>
			<?php } else { ?>
                    <tr class="cont1" style='text-align: center'>
                        <td colspan="10" style="text-align:center;"> No Record Found  </td>
                    </tr>
                <?php } ?>
            </tbody>
            </table>
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







