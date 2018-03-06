<?php echo $this->Form->create('TrainingMaster', array('url' => array('controller' => 'trainingmasters', 'action' => 'add_more_trainees'),'name'=>'add_trainee_form'));
  echo $this->Form->input('TrainingMaster.nu_request_id', array('type' =>'hidden','id'=>'reguest_id','value'=>$requestid));
?>
  <table width="100%" cellspacing="1" cellpadding="5" border="0" class="exp-voucher" style="text-align: center !important;">
	 <tbody>
		<tr class="head">
				<th width="3%" height="30"><input type="checkbox" value="1" id="chkAll" name="data[chkAll]"></th>
				<th width="9%" height="30"><strong>Employee Code</strong></th>
				<th width="19%" height="30"><strong>Employee Name</strong></th>
				<th width="20%" height="30"><strong>Designation</strong></th>
				<th width="12%" height="30"><strong>Department</strong></th>
		</tr>
		<tr class="cont1">
		<?php 
			$mgrcode = $_SESSION['Auth']['MyProfile']['emp_code'];
			$mgrname = $_SESSION['Auth']['MyProfile']['emp_firstname'];
		?>
			<td><input type="checkbox" value="<?php echo $mgrcode;?>" class="chk" name="data[vc_emp_code][]"></td>
			<td><?php echo $mgrcode;?></td>
			<td><?php echo $mgrname;?>
			<td><?php echo $this->traininghlp->getDesg($mgrcode);?></td>
			<td><?php echo $this->traininghlp->getDept($mgrcode);?></td>
		 </tr>
		<?php
		 $i = 1;
		 foreach ( $data as $emp_code => $emp_name ){ 
			if($i%2==0){
			   $class = 'cont1';			
			}else{
			   $class  = 'cont';
			}
		?>
	    <tr class="<?php echo $class;?>">
			<td><input type="checkbox" value="<?php echo $emp_code;?>" class="chk" name="data[vc_emp_code][]"></td>
			<td><?php echo $emp_code;?></td>
			<td><?php echo $emp_name;?>
			<td><?php echo $this->traininghlp->getDesg($emp_code);?></td>
			<td><?php echo $this->traininghlp->getDept($emp_code);?></td>
		 </tr>
		  <?php $i++;
		   }
		 ?>
	  </table>	 
	<div class="submit-form">
		<?php
			echo $this->Form->submit(__('Approve & Move Forward',true),array('name'=>'data[AddMore]','class'=>'taskbutton','id'=>'add_trainee')); 
		?>
	</div>	  
  <?php echo $this->Form->end(); ?>