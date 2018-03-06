<script language="javascript" type="text/javascript">
$(function(){
	   var cntID = <?php echo count($paginateData);?>;
	   for(var i=1;i<=cntID;i++){
			$('#dialog_'+i).dialog({
				autoOpen: false,
				width: 600,
				buttons: {
					"OK": function() {
					    var cont = $('#opened_dialog').val();
						var reqID = $('#hidden_reqID_'+cont).val();
						if($('#hidden_tran_status_'+cont).val() !='CANCELLED'){
						     $.post('<?php echo $this->webroot; ?>trainingmasters/update_remark',{ reqID: reqID },function(data) {
						   });
						 }
					    $(this).dialog("close");
					},
					"CANCEL": function() {
						$(this).dialog("close");
					}
				}
			});
	    }
    });
	
	function reject1(cnt)
    {
        $('#dialog_'+cnt).dialog('open');
		$('#opened_dialog').val(cnt);
        return false;
    }
</script>

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
            <h2>Manage Training Identification  </h2>
          <ul class="nav navbar-right panel_toolbox">
              <li>
              <?php 
               echo $this->Html->link('Online Training Identification Request', array('controller' => 'trainingmasters', 'action' => 'training_identification_form'),array('class'=>'btn btn-primary','title'=>'Online Training Identification Request','id'=>'admorebtn','style'=>'float:right;padding-top:4px;'));  
               ?>
              </li>
          </ul>
          <div class="clearfix"></div>
        </div>
            

     <div class="x_content">

            <table class="table table-striped responsive-utilities jambo_table bulk_action">
              <thead>
                <tr class="head">
                    <th><strong>S.N0.</strong></th>
                    <th><strong>Training Date</strong></th>
                    <th><strong>Training Name</strong></th>
                    <th><strong>Request Status</strong></th>
                    <th><strong>Training Status</strong></th>
                    <th ><strong> Action </strong></th>
	       </tr>  
              </thead>
              <tbody>
                   <?php
			if (count($paginateData) > 0) {
			 $i = 1;$cnt=1;
			 foreach ( $paginateData as $value ){ 
			    $nu_request_id = $value['MstTrainingRequests']['request_id'];
				if($value['MstTrainingRequests']['training_topic_type']=='E'){
				  $vc_course_id = $value['MstTrainingRequests']['training_topic_id'];
				  $topicname = $this->traininghlp->getCouseName($vc_course_id);
				}else{
				  $topicname = $value['MstTrainingRequests']['training_name'];
				}
				if($i%2==0){
				   $class = 'cont1';			
				}else{
				   $class  = 'cont';
				}
				$request_status = $value['MstTrainingRequests']['request_status'];
				
				$training_status = $value['MstTrainingRequests']['training_status'];
				
                              $remarks = $value['MstTrainingRequests']['request_reason'];
			
			  if($request_status=='RM'){
				$rstatus = "PENDING";
			  }else if($request_status=='TI'){
                           $rstatus = "APPROVED";
 			  }else if($request_status=='PR'){
			    $rstatus = "PROCESSED";
			  }else if($request_status=='RR'){
			    $rstatus = "REJECTED";
			  }else{
			    $rstatus = "INTERMEDIATE";
			  }
			?>
			<tr class="<?php echo $class;?>">
				<td align="center">	<?php echo $i; ?></td>
				<td><?php echo date ('d-M-Y',strtotime($value['MstTrainingRequests']['training_date']));?></td>
				<td><?php echo $topicname;?></td>
				<td> <?php echo $rstatus;?></td>
				<td> <?php echo $training_status;?></td>
				<td>
				<input type="hidden" value="<?php echo $training_status;?>" id="hidden_tran_status_<?php echo $i; ?>"/>
				<input type="hidden" value="<?php echo $value['MstTrainingRequests']['request_id'];?>" id="hidden_reqID_<?php echo $i; ?>"/>
				<center>
				<?php 
				  $nu_request_id = base64_encode($value['MstTrainingRequests']['request_id']);
				?>
				 <?php if($remarks !='' || $remarks !=null){ ?>
				  <div id="dialog_<?php echo $i; ?>" title="Remark/Comment" style="display:none">
					<div>
						<textarea name="data[MstTrainingRequests][vc_remarks]" style="width: 550px; height:200px;"><?php echo $remarks;?></textarea>
					</div>
				  </div>
				<?php }?>
				  
				           
					           <?php 
					          echo $this->Html->link('VIEW', array('controller' => 'trainingmasters', 'action' => 'view_manager_training_identification','VIEW',$nu_request_id),array('class'=>'btn btn-success','id'=>'view_img','title'=>'View'));
						   ?>
							
						   <?php if($training_status =='REJECTED' && ($remarks !='' || $remarks !=null)){?>
							
							  <?php 
								echo $this->Html->link('COMMENT','#',array('class'=>'btn btn-primary','title'=>'COMMENT','onclick'=>'return reject1("'.$i.'")'));
							 ?>
							
						  <?php }?>
						  <?php if($request_status=='RR' || $request_status=='MR'){?>
						 
							<?php 
							  echo $this->Html->link('Edit', array('controller' => 'trainingmasters', 'action' => 'training_identification_form_edit','EDIT',$nu_request_id),array('class'=>'btn btn-primary','id'=>'edit_img','title'=>'Edit'));
							?>
						
						<?php }?>
				             
				          </center>
				  <input type="hidden" value="<?php echo $i;?>" id="cntID"/>
				</td>
			</tr>
			 <?php $i++; ?>
			<?php }  ?>
			
			<?php } else { ?>
                    <tr class="cont1" style='text-align: center'>
                        <td colspan="8" style="text-align:center;"> No Record Found  </td>
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


