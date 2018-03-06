<center>
<?php 
 echo $this->Form->create('Edit_leave', array('url' => array('controller'=>'leavestype','action'=>'editleave'), 'name' => 'msgForm', 'inputDefaults' => array('label' => false, 'div' => false)));
?>
<table cellspacing="0" width="280px" class="exp-voucher">
<tr class = "head"><th>Leaves Type</th><th>Alloted Leaves</th></tr>
<?php
	foreach($ldetails as $ldetail)
	{?>
		<tr class="cont1"><td><?php echo $this->Common->findLeaveType($ldetail['MstEmpLeaveAllot']['leave_code']); ?></td>
		<td><?php echo $this->Form->input("allot_leave_".$ldetail['MstEmpLeaveAllot']['leave_code'], array('class' => 'round_select', 'id' => 'appName','maxLength'=>90,'value'=>$ldetail['MstEmpLeaveAllot']['allot_leave']));?>  </td></tr>
	<?php } ?>	
</table>
<input type="hidden" name="emp_code" value="<?php echo $ldetail['MstEmpLeaveAllot']['emp_code']; ?>">
<?php echo $this->Form->end('Submit'); ?></center>
