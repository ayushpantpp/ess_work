<?php if($leaveapp[0]){ ?>
<table class="uk-table uk-table-align-vertical uk-table-nowrap tablesorter tablesorter-altair">
        <?php   
        
	foreach($leaveapp as $ldetail)
	{ 
            foreach($ldetail as $ldetail){
                
            if($ldetail['LeaveDetail']['hlfday_leave_chk']=='N')
			$length='Full Day';
		else
			$length='Half Day';
	?>
    
                <tr class="cont1"><td>Employee Name :</td><td><?php echo $this->Common->findEmpName($ldetail['LeaveDetail']['emp_code']); ?></td></tr>
		<tr class="cont1"><td>Leave Type :</td><td><?php echo $this->Common->findLeaveType($ldetail['LeaveDetail']['leave_code']); ?></td></tr>
		<tr class="cont1"><td>Leave Length :</td><td><?php echo $length; ?></td></tr>
		<tr class="cont"><td>Date :</td><td><?php echo date('d-M-Y', strtotime($ldetail['LeaveDetail']['leave_date'])) ?></td></tr>
		<tr class="cont"><td>Leave Status :</td><td><?php echo $this->Common->findSatus($ldetail['LeaveDetail']['leave_status']); ?></td></tr>		
	<tr><td colspan="2" height="3"></td></tr>
		

            <?php  }} ?>   
    
</table>
<?php } else {?>
<p class = 'RejectedLeave'> No applied leaves found </p>
<?php } ?>
