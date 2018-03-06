<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


?>

<table width="100%" border="0" cellspacing="1" cellpadding="5" class="exp-voucher">
<tr class="head">
<th>Sr.No</th>
<th>Employee Name</th>
<th>Manager's Name</th>
<th>Submission Date</th>
<th>Leave From</th>
<th>Leave upto</th>
<th>Status</th>
<th>Leave Type</th>
<?php 
$arrleavemode=array('C'=>'Casual','M'=>'Medical','E'=>'Earned','L'=>'LWP');
$arrleavestatus=array('Y'=>'Approved','R'=>'Rejected','P'=>'Panding','N'=> 'Cancel');
$i=1;
//pr($datesearchresult);
foreach($datesearchresult as $sresult)
{
if($i%2==0)$class='cont'; else $class='cont1';
if(!empty($sresult['Leavereport']['ch_lve_status']))
{
    $status=$sresult['Leavereport']['ch_lve_status'];
} else
{
 $status='P';
}

?>
<tr class="<?php echo $class; ?>">
    <td><?php echo $i; ?></td>
    <td><?php echo $sresult['Leavereport']['vc_emp_name'];  ?></td>
    <td><?php echo $sresult['Leavereport']['mgr'];  ?></td>
    <td><?php echo $sresult['Leavereport']['dt_app_date'];  ?></td>
    
    <td><?php echo $sresult['Leavereport']['dt_start_date'];  ?></td>
    <td><?php echo $sresult['Leavereport']['dt_end_date'];  ?></td>
    <td><?php echo $arrleavestatus[$status]; ?></td>
    <td><?php echo @$arrleavemode[$sresult['Leavereport']['vc_leave_code']]; ?></td>
      
</tr>   
    
<?php $i++; } ?>

<tr><td colspan="8" algin="right"><?php echo $paginator->prev(); ?> -
<?php echo $paginator->numbers(array('separator'=>' - ')); ?>
<?php echo $paginator->next('Next Page'); ?> </td></tr>
