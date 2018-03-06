<div class="center-content">
<div class="breadCrumbHolder module">
	<div id="breadCrumb0" class="breadCrumb module">
		<ul>
			<li><a href="<?php echo $this->webroot;?>employees/dashboard" class="vtip" title="Home">Home</a></li>
			<li><a href="<?php echo $this->webroot;?>selfservices/#training" class="vtip" title="Training Management">Training Management</a></li>
			<li>Sanctioned Training Requests</li>
		</ul>
	</div>
</div>
<div id="myDiv"></div>
<h2 class="demoheaders">Sanctioned Training Requests</h2>
<div class="travel-voucher1">
  <div class="input-boxs" style="min-height:300px;">
    <table width="100%" cellspacing="1" cellpadding="5" border="0" class="exp-voucher" style="text-align: center !important;">
		<tbody>
			<tr class="head">
			    <th><strong>S.N.</strong></th>
				<th><strong> Training Name</strong></th>
				<th><strong> Training Date</strong></th>
				<th><strong> Identified By</strong></th>
				<th><strong> Submitted On</strong></th>
				<th><strong> Sanctioned On </strong></th>
			</tr>
			<?php
			if (count($paginateData) > 0) {
			 $i = 1;
			 foreach ( $paginateData as $value ){ 
			    $nu_request_id = $value['TrainingMaster']['nu_request_id'];
				if($value['TrainingMaster']['vc_training_topic_type']=='E'){
				  $vc_course_id = $value['TrainingMaster']['vc_training_topic_id'];
				  $topicname = $traininghlp->getCouseName($vc_course_id);
				}else{
				  $topicname = $value['TrainingMaster']['vc_training_name'];
				}
				if($i%2==0){
				   $class = 'cont1';			
				}else{
				   $class  = 'cont';
				}
				$identifiedBy = $value['TrainingMaster']['vc_identified_by'];
				
			?>
			<tr class="<?php echo $class;?>">
			<td align="center">	<?php echo $i; ?></td>
			<td> <?php echo $topicname;?></td>
			<td> <?php echo date('d-M-Y',strtotime($value['TrainingMaster']['vc_training_date']));?></td>
			<td> <?php echo $traininghlp->getEmpName($identifiedBy);?></td>
			<td> <?php echo $value['TrainingMaster']['vc_date_created'];?></td>
			<td><?php $newdate = explode(':',$value['TrainingMaster']['vc_date_modified']); echo $newdate['0'];?></td>
			</tr>
			 <?php $i++; ?>
			<?php } ?>
		  <?php if($paginator->hasPage(2)){?>
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
 
