<?php

App::import('Model', 'General');
$General = new General ;
App::import('Component', 'Functions');
// We need to load the class
 $Function = new FunctionsComponent();
?>

<!-- Header Ends -->
 <!-- Center Content Starts -->
 <div style="float:right; margin-bottom:10px;"><img src="<?php echo $this->webroot;?>img/esslogo2.gif"></div>


<div id="page_content">
    <div id="page_content_inner">
        <?php echo $flash = $this->Session->flash(); ?>
        <div id="alerts"></div>
		<div class="md-card">
	<div class="md-card-content">
	<div class="uk-overflow-container uk-margin-bottom" >

            
    <table class="uk-table uk-tab-responsive main tbl" id="TextBoxesGroup"  border = '1'>

	<tr class="uk-text-left md-bg-blue-100 uk-te uk-text-small">
		<th align="left">Eastern Software Systems</td>
		<th>Document Title : TIME SHEET</td>
		<th >Document Number : ESS/PROJ/FRM/016/08</td>
		<th >Date: 27-07-2006</td>
	</tr>
</table>
 <table class="uk-table uk-tab-responsive main tbl" id="TextBoxesGroup" border = '1'>
            <tr>
			<!--<th class="uk-text-left md-bg-blue-100 uk-te uk-text-small">Customer:</th>
			<td >
            <select name="customer_filter" class="textBox" onChange="this.form.submit();">
                <option value="">All</option><?php for($i=0;$i<$numCus;$i++){?>
                <option value="<?php echo $rwCus['CID'][$i]?>" <?php if(!empty($customer1))  if($rwCus['CID'][$i]==$customer1) { echo 'SELECTED'; }?>>
            <?php echo $rwCus['CNAME'][$i] ?></option><?php }?></select></td> -->
			<th class="uk-text-left md-bg-blue-100 uk-te uk-text-small" align="right">Employee Id:</th>
			<td ><?php echo $empid; ?></td>
			<th class="uk-text-left md-bg-blue-100 uk-te uk-text-small" align="right"><strong>Employee Name:</strong></th>
			<td ><?php echo $this->Common->getempnamebyid($rwCus[0]['MstTimesheet']['vc_emp_id']);?></td>
		</tr>
		<tr>
			<th class="uk-text-left md-bg-blue-100 uk-te uk-text-small" align="right"><b>Week Start Date:</b></th>
			<td ><?php echo date('d-M-Y',strtotime($rwCus[0]['MstTimesheet']['dt_start_date']));?></td>
			<th class="uk-text-left md-bg-blue-100 uk-te uk-text-small" align="right"><b>Week End Date:</b></th>
			<td ><?php echo date('d-M-Y',strtotime($rwCus[0]['MstTimesheet']['dt_end_date'])); ?></td>
		</tr>
	</table>
</div>
</div>
</div>

<div class="md-card">
	<div class="md-card-content">
            
   
		<tr>
	<td colspan="10">
		<table class="uk-table uk-tab-responsive main tbl" id="TextBoxesGroup" border = '1'>
			<tr >
				
				<td class="uk-text-left md-bg-blue-100 uk-te uk-text-small"><b>Date</b></td>
				<td class="uk-text-left md-bg-blue-100 uk-te uk-text-small"><b>TMS ID</b></td>
				<td class="uk-text-left md-bg-blue-100 uk-te uk-text-small"><b>Customer Name</b></td>
                                <td class="uk-text-left md-bg-blue-100 uk-te uk-text-small"><b>Customer Milestone</b></td>
				<td class="uk-text-left md-bg-blue-100 uk-te uk-text-small"><b>Primary Milestone</b></td>
				<td class="uk-text-left md-bg-blue-100 uk-te uk-text-small"><b>Start Time</b></td>
				<td class="uk-text-left md-bg-blue-100 uk-te uk-text-small"><b>End Time</b></td>
				<td class="uk-text-left md-bg-blue-100 uk-te uk-text-small"><b>Hours</b></td>
				<td class="uk-text-left md-bg-blue-100 uk-te uk-text-small"><b>Module</b></td>
				<td class="uk-text-left md-bg-blue-100 uk-te uk-text-small"><b>Remarks</b></td>
				<td class="uk-text-left md-bg-blue-100 uk-te uk-text-small"><b>Leave</b></td>
				<td class="uk-text-left md-bg-blue-100 uk-te uk-text-small"><b>Program Name</b></td>
				<td class="uk-text-left md-bg-blue-100 uk-te uk-text-small">
				<div align="center"><b>F(orm)<br>
			      /R(eport)</b></div>
				</td>
			</tr>

<?php

		$totalSecond=0;
		foreach($rwCus[0]['DtTimesheet'] as $rs){
                        if(!empty($rs['vc_hrs'])){
			    $totalSecond +=$Function->ConvertTime($rs['vc_hrs']);
                        }
?>
			<tr>
				<td ><?php echo date('d-M-Y',strtotime($rs['dt_wk_date']));?></td>
				<td ><?php if($rs['tms_id'] == 0){echo 'Others'; }else{ echo $rs['tms_id']; };?></td>
				<td ><?php echo $rs['vc_customer_name'];?></td>
                                <td ><?php echo $this->Common->getPrimaryMilestone($rs['primary_milestone_id']);?></td>
                                <td ><?php echo $this->Common->getPrimaryMilestone($rs['primary_milestone_id']);?></td>
                                <td ><?php echo $rs['vc_strt_time'];?> </td>
				<td ><?php echo $rs['vc_end_time'];?></td>
				<td ><?php echo $rs['vc_hrs'];?></td>
                                <td ><?php echo ($rs['vc_module'])?$rs['vc_module']:'-';?></td>
				 <td><textarea  name="remarks<?php echo $x ?>" id="remarks<?php echo $x ?>" <?php echo $read0nly ?>><?php echo ($rs['vc_remarks']!='')?nl2br($rs['vc_remarks']):'-'; ?></textarea></td>
				<td ><?php if(!empty($rs['vc_leave'])){ echo "Yes";}else { echo '-'; }?></td>
				<td >

				<?php echo ($rs['vc_pm_code']!='')?str_replace(",", " , " , $rs['vc_pm_code']):'-';?>
				</td>
				<td ><?php echo ($rs['vc_f_r'] !='')?$rs['vc_f_r']:'-';?></td>
			</tr>
<?php }?>
		</table>	</td>
	</tr>



		<tr>
		<td>

		<table class="uk-table uk-tab-responsive main tbl" id="TextBoxesGroup" border = '1'>
		<tr class="uk-text-left md-bg-blue-100 uk-te uk-text-small">
			<td ><b>Weekly Summary:</b> </td>
			<td class="uk-text-left md-bg-blue-100 uk-te uk-text-small"><b>Total Hours:</b> </td>
			<td ><?php echo $Function->ConvertTime($totalSecond , true);?>&nbsp;<?php //echo $rows['TOTHRS'][0];?></td>

		<?php if($type=='Consolidated' and !empty($_REQUEST['customer'])){?>
		  <td class="uk-text-left md-bg-blue-100 uk-te uk-text-small"><b>Total Week Hours:</b></td>
		  <td ><?php echo $tothrs1;?></td>
		  </tr>
		  <?php }?>
			<td class="uk-text-left md-bg-blue-100 uk-te uk-text-small"><b>Total Forms:</b></td>
			<td ><?php echo $rwCus[0]['MstTimesheet']['vc_tot_frms'];?></td>
			<td class="uk-text-left md-bg-blue-100 uk-te uk-text-small"><b>Total Reports</b> <strong>:</strong></td>
			<td ><?php echo $rwCus[0]['MstTimesheet']['vc_tot_reps'];?></td>
		</table></td></tr>
		<tr>
		<td colspan="10">
		<table class="uk-table uk-tab-responsive main tbl" id="TextBoxesGroup" border = '1'>
		<tr>
			<td class="uk-text-left md-bg-blue-100 uk-te uk-text-small"><b>Signature of Engineer:<br/><center><?php echo $this->Common->getempnamebyid($rwCus[0]['MstTimesheet']['vc_emp_id']);?></center></b> </td>
			<td class="uk-text-left md-bg-blue-100 uk-te uk-text-small"><b>Signature of Customer:</b> </td>
			<td class="uk-text-left md-bg-blue-100 uk-te uk-text-small"><b>Signature of Project Manager/Chief Manager/General Manager: <br/><center><?php $this->Common->getempname($rwCus[0]['MstTimesheet']['vc_cur_mgr_id'])?></center></b></td>
		</tr>

		</table>
		</td></tr>
		<tr>
			<td colspan="10">&nbsp;</td>
		</tr>
		<tr>
			<td colspan="10"><b><i>This is system generated timesheet</i></b></td>
		</tr>

</table>
    </form>
</div>
</div>
</div>
</div>


  
