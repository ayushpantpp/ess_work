<script type="text/javascript" >
jQuery(document).ready(function(){
jQuery("#startdate").datepicker({inline:true,dateFormat:'dd-mm-yy'});
jQuery("#enddate").datepicker({inline:true,dateFormat:'dd-mm-yy'});

}); 

function get_searchresult()
{
    var data='Loding....'; 
    jQuery('#searchresult').html(data);
       
}

</script>
<div class="travel-voucher1">
<div class="input-boxs-timesheet">
<div>
<?php
echo $form->create('leaves', array(
    'url' => '',
    'inputDefaults' => array(
        'label' => false,
        'div' => false,
        'error' => array(
            'wrap' => 'span',
            'class' => 'my-error-class'
        )
    )
        )
);

?>
<table width="100%" border="0" cellspacing="1" cellpadding="5" class="exp-voucher">
  <tr class="head">
    <th scope="row" colspan="4">Leave Filter</th>
  </tr>
   <tr class="cont1">
    <th width="25%"> From Date : </th>
    <td width="25%"><?php echo $form->input('Sdate',array('type'=>'text','id'=>'startdate','value'=>@$this->passedArgs['Sdate'])); ?></td>
    <th width="25%">To Date :</th>
    <td width="25%"><?php echo $form->input('Edate',array('type'=>'text','id'=>'enddate','value'=>@$this->passedArgs['Edate'])); ?></td>
   <?php $options=array('VcEmpName'=>'Employee Name','Mgr'=>'Manager Name','ChLveStatus'=>'Leave Status','VcLeaveCode'=>'Leave Code'); ?>
   <tr>
    <th width="25%">Short By  :</th>
 <?php if(empty($this->passedArgs['orderBy'])) { $default='VcEmpName';} else {$default=$this->passedArgs['orderBy']; } ?>
    <td width="25%"><?php echo $form->select('orderBy',$options,array('default'=>$default ,'empty'=>'Short By','id'=>'orderBy')); ?></td>
    <td><div class="submit"><input type="submit" value="Search" id="btnserch" onClick="get_searchresult()"></div></td> 
   </tr> 
 <?php echo $form->input('hsed',array('type'=>'hidden','id'=>'hsed','value'=>@md5(date('YMDhis')))); ?>
</table>
 <?php $form->end();?>
</div>

 <div id="searchresult"> 
<?php if(!empty($datesearchresult)){ ?>
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
<?php echo $paginator->numbers(array('separator'=>'&nbsp;&nbsp;')); ?>
<?php echo $paginator->next('Next Page'); ?> </td></tr></table>
<?php }  ?>
 </div>

</div>
</div>

