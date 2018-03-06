<?php if($ldetails){?>  
<?php  $i = 0; ?>
<table class="uk-table uk-table-align-vertical uk-table-nowrap tablesorter tablesorter-altair">
        <?php   
        //print_r($ldetails);die;
	foreach($ldetails as $ldetail)
	{ 
		if($ldetail['LeaveDetail']['hlfday_leave_chk']=='N')
			$length='Full Day';
		else
			$length='Half Day';
                if($i%2 == 0) 
                  $class = "cont1";
                 else
                 $class = "cont";
	?>
		<tr class="<?php echo $class; ?>"><td>Leave Type :</td><td><?php echo $this->Common->findLeaveType($ldetail['LeaveDetail']['leave_code']); ?></td></tr>
		<tr class="<?php echo $class; ?>"><td>Leave Length :</td><td><?php echo $length; ?></td></tr>
		<tr class="<?php echo $class; ?>"><td>Date :</td><td><?php echo date('d-M-Y', strtotime($ldetail['LeaveDetail']['leave_date'])) ?></td></tr>
		<tr class="<?php echo $class; ?>"><td>Leave Status :</td><td><?php echo $this->Common->findSatus($ldetail['LeaveDetail']['leave_status']); ?></td></tr>		
	<tr><td colspan="2" height="3"></td></tr>

	<?php $i++; } ?>   
  
</table>
<?php }else {?>
<p class='PendingLeaves'> No Approved Leaves Found</p>
<?php } ?>
