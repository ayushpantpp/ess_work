<?php $auth = $this->Session->read('Auth'); ?>
<table class="uk-table uk-table-no-border">
    <?php
    $level = count($ldetails['LeaveWorkflow']);
    $i = 1;
    foreach ($ldetails['LeaveDetail'] as $ldetail) {
        if ($ldetail['hlfday_leave_chk'] == 'N')
            $length = 'Full Day';
        else
            $length = 'Half Day';
        ?>
        <tr><td><?php echo $i; ?></td><td>Leave Type :</td><td><?php echo $this->Common->findLeaveType($ldetail['leave_code']); ?></td></tr>
        <tr><td></td><td>Leave Length :</td><td><?php echo $length; ?></td></tr>
        <tr><td></td><td>Date :</td><td><?php echo date('d-M-Y', strtotime($ldetail['leave_date'])) ?></td></tr>
        <tr><td></td><td>Leave Status :</td><td><?php echo $this->Common->findSatus($ldetail['leave_status']); ?></td></tr>		



        <?php
        $i++;
    } if (empty($ldetails['LeaveWorkflow'][$level - 1]['approval_date']))
        $sanDate = '';
    else
        $sanDate = date('d-M-Y', strtotime($ldetails['LeaveWorkflow'][$level - 1]['approval_date']));
    ?>   
    <tr><td></td><td>Leave Applied Date  : </td><td><?php echo date('d-M-Y', strtotime($ldetails['MstEmpLeave']['applied_date'])); ?></td></tr>
    <tr><td></td><td>Leave Sanction date : </td><td><?php echo $sanDate; ?></td></tr>

</table>
