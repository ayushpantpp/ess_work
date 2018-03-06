<center>
<table cellspacing="0" width="280px" class="exp-voucher">
<tr class = "head"><th>Leaves Type</th><th>Alloted Leaves</th></tr>
<?php 
$tollv=0;
$i=0;
	foreach($ldetails as $ldetail)
	{
		if($i%2==0)$class='cont1'; else $class='cont';
		$tollv= $tollv + $ldetail['MstEmpLeaveAllot']['allot_leave'];
		
	?>
		<tr class="<?php echo $class ;?>"><td><?php echo $this->Common->findLeaveType($ldetail['MstEmpLeaveAllot']['leave_code']); ?></td><td><?php echo $ldetail['MstEmpLeaveAllot']['allot_leave']; ?></td></tr>
	<?php
$i++; } ?>	
	<tr class="cont1"><th>Total Leaves</th><td><?php echo $tollv ?></td></tr>
</table></center>
