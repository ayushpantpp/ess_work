
<?php $read0nly = ($empdetail[4] == "milestone") ? 'readonly="readonly"' : ''; ?>
<form name="lveForm" action="" method="post" autocomplete="off">
    <div id="page_content">
		<div id="page_content_inner">
        <?php echo $flash = $this->Session->flash(); ?>
        <div id="alerts"></div>
		 <div class="md-card">
			<div class="md-card-toolbar">
			<div class="md-card-toolbar-actions">
							<div style="text-align:right;">* Under Pilot: not mandatory</div>
                            </div>
                            <h3 class="md-card-toolbar-heading-text">
                              <b>Add Timesheet
							</b>
                            </h3>
                        </div>
			<div class="md-card-content">
            <div class="uk-overflow-container uk-margin-bottom">
			<div class="input-boxs">
                <input type="hidden" name ="tot_ctrl" value="<?php echo $numTsRec ?>" id="Control_Number">
                <input type="hidden" name ="posted" value="1" id="posted">
                <input type="hidden" name ="task" value="Update Consolidate" id="updateTS">
                <input type="hidden" name ="customer" value="<?php // echo $rows['CUSTOMER'][0];   ?>">
                        <input type="hidden" name ="addtimesheetrow" id="addtimesheetrow" value="<?php
if ($numTsRec != '') {
        echo $numTsRec;
} else {
        echo '1';
}
?>">
			<input type="hidden" name ="flag" value="<?php echo $flag; ?>">
				<table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td colspan='11' align='center' nowrap="nowrap" id='error_div'></td>
                    </tr>
                    <tr>
                        <th scope="row">Region :</th>
                        <td><?php echo $rwTsRec[0]['MstTimesheet']['vc_region']; ?>
                            <input type="hidden" name ="region" value="<?php echo $rows['RCODE'][0] ?>">
                            <input type="hidden" name ="sno" value="<?php echo $rows['SNO'][0] ?>">
                            <input type="hidden" name ="is_manager" id="is_manager" value="0">
                             <input type="hidden" id="rejectres" name="rejectreson" value=""/>
                             <input type="hidden" id="rej" name="rej" value=""/>
                        </td>
                        
                        <th scope="row">Employee Name :</th>
                        <td><?php echo $this->Common->getempname($rwTsRec['MstTimesheet']['vc_emp_id']); ?>
                            <input type="hidden" name ="employee" value="<?php echo $empdetail[1]; ?>">
                        </td>
                        <th scope="row">Employee ID :</th>
<?php //pr($empdetail);   ?>
                        <td><?php echo $rwTsRec['MstTimesheet']['vc_emp_id']; ?><input name="empid" type="hidden" id="empid" value="<?php echo $rwTsRec[0]['MstTimesheet']['vc_emp_id']; ?>"size="4"></td>
						<?php
                     ?>
                        <th scope="row" >Week Start Date :</th>
                        <td id="YearWeeks"><?php echo $rwTsRec['MstTimesheet']['dt_start_date']; ?><input name="sDate" type="hidden" id="sDate"  value="<?php echo $rwTsRec['MstTimesheet']['dt_end_date']; ?>" size="10" maxlength="20"  readonly>
                        </td>
                        <th scope="row">Week End Date :</th>
                        <td> <?php echo $rwTsRec['MstTimesheet']['dt_end_date']; ?><input name="wstDate" type="hidden" id="wstDate"  value="<?php echo $rwTsRec['MstTimesheet']['dt_end_date']; ?>" size="10" maxlength="20"  readonly>&nbsp;
                            <input name="wedDate" type="hidden" id="wedDate"   value="<?php echo $rwTsRec['MstTimesheet']['dt_end_date']; ?>" size="10" maxlength="20"  readonly></td>
                        <th scope="row"></th>
                    </tr>
				</table>
            </div>
        </div>
		</div>
		</div>
		
		<div class="md-card"> 
		<div class="md-card-content">
				<div class="uk-overflow-container uk-margin-bottom" >
					<table border="1" class="uk-table uk-tab-responsive main tbl" id="TextBoxesGroup">
			    <thead class = "uk-text-contrast">
                         <tr>
							<th class="uk-text-center md-bg-blue-100 uk-te uk-text-small">TMS ID*</th>
							<th class="uk-text-center md-bg-blue-100 uk-te uk-text-small">Customer</th>
                            <th class="uk-text-center md-bg-blue-100 uk-te uk-text-small">Activity/Milestone</th>
							<th class="uk-text-center md-bg-blue-100 uk-te uk-text-small">Detail-Date</th>
                            <th class="uk-text-center md-bg-blue-100 uk-te uk-text-small">Leave</th>
                            <th class="uk-text-center md-bg-blue-100 uk-te uk-text-small">Start Time</th>
                            <th class="uk-text-center md-bg-blue-100 uk-te uk-text-small">End Time</th>
                            <th class="uk-text-center md-bg-blue-100 uk-te uk-text-small">Hours</th>
                            <th class="uk-text-center md-bg-blue-100 uk-te uk-text-small">Module</th>
                            <th class="uk-text-center md-bg-blue-100 uk-te uk-text-small">Remarks</th>
                            <th class="uk-text-center md-bg-blue-100 uk-te uk-text-small">Forms/Reports</th>
                        </tr>
						</thead>

                <tr>
                            <td colspan="13" style="padding:0px;">
                                <div id="add_ctrl"></div>
                            </td>
                        </tr>
                    </table>
                </div>
            
			<div class="submit">

<?php if (($manager != 'manager') && ($flag != 'milestone')) { ?>
                    <input type="button" id="add_button" name="Add2" value="Add More" onClick="CheckPreviousRow1(this.form,'add_ctrl','1');" style="margin-right:5px;" />
                    <input type="button" value="Remove" style="margin-right:5px;" id="remove_button" onClick="RemoveControl(this.form)" disabled="disabled"/>
<?php } ?>
            <?php if ($manager != 'manager') {
 ?>
                                <input name="sheet_status_save" type="button" class="taskbutton" value="Save Changes" id="SaveChanges" >
 <?php if ($flag != 'milestone') { ?>
                                    <input name="sheet_status_manager" type="button" id="manager"value="Submit To Manager"  onClick="return checkcon1(this.form,this.name, '1');">
<?php } ?>
                    
<?php } else { ?>
                    <input name="sheet_status_manager" type="button" class="taskbutton" value="Approved" id="Approved"  onClick="return checkcon1(this.form,this.name, '2');">
                    <input name="Reject" id="reject" type="button" class="taskbutton" value="Reject"  onclick="return reject1('<?php echo $sno;?>','<?php echo $empdetail[1]?>')"/>
<?php } ?>
                        <input type="button" value="Back"  id="back_button" onClick="javascript:history.back(-1);" style="margin-right:5px;"/>
						</div>
				</div>		
        </div>
		<div class="md-card">
			
			<div class="md-card-content">
				<table width="100%" cellspacing="5" cellpadding="5" border="1" class="uk-table uk-tab-responsive main tbl" id="TextBoxesGroup">
                                    <tbody>
									<tr class="uk-text-center md-bg-blue-100 uk-te uk-text-small">Weekly Summary :</tr>
                                        <tr >
                                            <th scope="row"><strong>Total Hours:</strong>  :</th>
                                            <td><input class='md-input' name="tothr" type="text" id="tothr"  value="<?php echo $rwTsRec[0]['MstTimesheet']['vc_tot_hrs']; ?>" size="8" readonly></td>
                                            <th scope="row"><strong>Total Forms</strong>  :</th>
                                            <td><td colspan="9"><input class='md-input' name="totfr" type="text" id="totfr" value="<?php echo$rwTsRec[0]['MstTimesheet']['vc_tot_frms']; ?>" size="8"></td>
                                            <th scope="row"><strong>Total Reports</strong>  :</th>
                                            <td><input class='md-input'  name="totrep" type="text" id="totrep" value="<?php echo $rwTsRec[0]['MstTimesheet']['vc_tot_reps']; ?>" size="8"></td>

                                        </tr>

                                </table>
						
					</div></div>
								
 <div id="dialog" title="Remark/Comment" style="display:none">
                         <div>
                            <textarea  name="reject_reson" id="cmnt" col="100" row="100" style="width: 550px; height:200px;" onKeypress="getcmtval()" > </textarea>
                            <div class="ui-widget" id="errdis" style="display:none">
                                <div class="ui-state-error ui-corner-all" style="margin-top: px; padding: 0pt 9em; margin-left: 0px;">
                                    <p><span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>
                                        <strong></strong> Please write rejection reason.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                            </div>
                        </div>
                    
                </form>


                <!-- SET AUTO SUGGESTION -->
                <script type="text/javascript">




</script>
<script>

</script>
<script src="<?php echo $this->webroot ?>js/js/timesheet_all.js"></script>
        
<!-- Center Content Ends -->
