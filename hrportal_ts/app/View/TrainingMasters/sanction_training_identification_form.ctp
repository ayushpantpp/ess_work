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
            <h2>Sanction Training identifiction  </h2>
          
          <div class="clearfix"></div>
        </div>
            

     <div class="x_content">

            <table class="table table-striped responsive-utilities jambo_table bulk_action">
              <thead>
                <tr class="head">
                    <th><strong>S.N.</strong></th>
                    <th><strong> Training Name</strong></th>
                    <th><strong> Training Date</strong></th>
                    <th><strong> Identified By</strong></th>
                    <th><strong> Submitted On</strong></th>
                    <th><strong> Action </strong></th>
	       </tr>  
              </thead>
              <tbody>
                   <?php
			if (count($paginateData) > 0) {
			 $i = 1;
			 foreach ( $paginateData as $value ){ 
			    $nu_request_id = $value['MstTrainingRequests']['request_id'];
				if($value['MstTrainingRequests']['training_topic_type']=='E'){
				  $vc_course_id = $value['MstTrainingRequests']['training_topic_id'];
				 $topicname = $value['MstTrainingRequests']['training_name'];
                                 
				}else{
				  $topicname = $value['MstTrainingRequests']['training_name'];
				}
				if($i%2==0){
				   $class = 'cont1';			
				}else{
				   $class  = 'cont';
				}
				$identifiedBy = $value['MstTrainingRequests']['identified_by'];
				
			?>
			<tr class="<?php echo $class;?>">
			<td align="center"><?php echo $i; ?></td>
			<td> <?php echo $topicname;?></td>
			<td> <?php echo date('d-M-Y',strtotime($value['MstTrainingRequests']['training_date']));?></td>
			<td> <?php echo $this->traininghlp->getEmpName($identifiedBy);?></td>
			<td> <?php echo $value['MstTrainingRequests']['training_date'];?></td>
			<td>
			<?php 
                        
			  $nu_request_id = base64_encode($nu_request_id);
                         
			?>
			<ul style="float: left;">
			        	 
					  <?php 
						  echo $this->Html->link('SANCTION', array('controller' => 'trainingmasters', 'action' => 'manager_training_identification','SANCTION',$nu_request_id),array('class'=>'btn btn-primary' ,'id'=>'approved','title'=>'SANCTION'));
					  ?>
					
                   </ul>
			    </td>
			</tr>
			 <?php $i++; ?>
			<?php } ?>
		   <?php if($paginator){?>
			<tr>
			  <td colspan="7" align="right">[<?php echo $paginator->prev(); ?> ]
                  <?php echo $paginator->numbers(array('separator'=>'&nbsp;|&nbsp;')); ?>
                 [ <?php echo $paginator->next('Next Page'); ?> ]
			  </td>
			</tr>
		 <?php }?>
			<?php } else { ?>
                    <tr class="cont1" style='text-align: center'>
                        <td colspan="7" style="text-align:center;"> No Record Found  </td>
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





 
