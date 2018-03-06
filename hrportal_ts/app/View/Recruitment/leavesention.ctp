<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
$arrleavemode=array('C'=>'Casual','M'=>'Medical','E'=>'Earned','L'=>'LWP','R'=>'Reject');
$chdaytype=array('F'=> 'Full Day','H'=> 'Half Day');
?>
<script>
    function Changeleavetype()
    {
        jQuery('#leavetype').hide();
        jQuery('#showltype').show();
        jQuery('#ch').hide();
        jQuery('#cl').show();
    }
    function setdefault()
    {
       jQuery('#showltype').hide(); 
       jQuery('#ch').show();
       jQuery('#leavetype').show()
       jQuery('#cl').hide();
    }
</script>
<?php
        echo $form->create('leaves', array(
            'url' => 'movetohr',
            'name'=>'leaveapprove',
            'inputDefaults' => array(
                'label' => false,
                'div' => false,
                'error' => array(
                    'wrap' => 'span',
                    'class' => 'my-error-class'
                )
            )
                )
        );?>
<table width="800" cellspacing="4"  BORDER="0">
<tr>
<td WIDTH="50%">
<table width="100%" class="exp-voucher">
    <tr class="cont1">
        <td>Employee Name : </td>
        <td><?php echo $lsdetails['0']['Leave']['vc_emp_name'];?></td>
    </tr>
    <tr class="cont">
        <td>Leave Apply Date : </td>
        <td><?php echo $lsdetails['0']['Leave']['dt_app_date'];?></td>
    </tr>
    <tr class="cont1">
        <td>Leave From : </td>
        <td><?php echo $lsdetails['0']['Leave']['dt_start_date'];?>&nbsp;&nbsp;<?php echo @$chdaytype[$lsdetails['0']['Leave']['ch_st_daylength']];?></td>
    </tr><tr class="cont">
        <td>Leave To : </td>
        <td><?php echo $lsdetails['0']['Leave']['dt_end_date'];?>&nbsp;&nbsp;<?php echo @$chdaytype[$lsdetails['0']['Leave']['ch_ed_daylength']];?></td>
    </tr>
    <tr class="cont1">
        <td>Total Leave : </td>
        <td><?php echo $lsdetails['0']['Leave']['nu_tot_leaves'];?></td>
    </tr>
    <tr class="cont">
        <td>Leave Type : </td>
        <td><span id="leavetype"><?php echo @$arrleavemode[$lsdetails['0']['Leave']['vc_leave_code']];?></span>
            <span id="showltype" style="display: none">
    <?php echo $form->Input('lstatus' , array('options'=>$arrleavemode,'default'=>$lsdetails['0']['Leave']['vc_leave_code'] ,'label'=>false, 'empty'=>false,'id'=>'lstatus')); ?>
    </span>
            &nbsp; &nbsp;<span id="ch"><a href="#"><font color="blue" onclick="Changeleavetype()">Change</font></a></span>
            <span id="cl" style="display: none"></span>
        
        </td>
        </tr>
    <tr class="cont1">
        <td>Leave Reason : </td>
        <td><?php echo $lsdetails['0']['Leave']['vc_leave_reason'];?></td>
    </tr>
    <tr class="cont">
        <td>Employee Address : </td>
        <td><?php echo $lsdetails['0']['Leave']['vc_contact_add'];?></td>
    </tr>
    
    <tr class="cont1">
        <td>Employee Phone : </td>
        <td><?php echo $lsdetails['0']['Leave']['vc_contact_phone'];?></td>
    </tr>
   
</table>
</td>
<td width="50%" class="cont">
<table>
<tr bgcolor="silver" height="25">
<td align="center"> Total Leaves <b><?php echo $tlv; ?></b> in Year : <?php echo date('Y');?>
</td>
</tr>
<tr bgcolor="silver" height="25">
<td align="center"> Remain Leave <b><?php echo $remainleave; ?>
</td>
</tr>
<tr>
<td>
</td>
</tr>
</table>
</td>
</tr>
<!--tr class="head">

<th width="100%" Align="center" colspan="2" class="titlebar" >
Monthly leave report
</th>

</tr>
<tr >
<td width="100%" colspan="2">
</td>
</tr-->
</table>
<?php echo $form->input('empid',array('type'=>'hidden','value'=>@$empid)); ?>
<?php echo $form->input('cid',array('type'=>'hidden','value'=>$cid)); ?>
<?php echo $form->input('sdate',array('type'=>'hidden','value'=>$sdate)); ?>
<?php echo $form->input('edate',array('type'=>'hidden','value'=>$edate)); ?>
<?php echo $form->input('appdate',array('type'=>'hidden','value'=>$appdate)); ?>

<?php echo $form->end(); ?>
