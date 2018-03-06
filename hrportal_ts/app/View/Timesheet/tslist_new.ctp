<script type="text/javascript">
        $(function(){
                // Dialog
                $('#dialog').dialog({
                        autoOpen: false,
                        width: 600,
                        modal:true,
                        buttons: {
                                "Ok": function() {
                                        $(this).dialog("close");
                                        document.trvoucher.submit();

                                }
                        }
                });
        });
</script>
<script type="text/javascript">
        function getrejectreson(sno,empid){
                jQuery.get('<?php echo $this->webroot; ?>timesheet/getrejectionresion/'+sno+'/'+empid,{}, function(data){
                        jQuery('#getrejectionresion').html(data);

                });
                jQuery('#dialog').dialog('open');
        }
        jQuery(function(){            
                jQuery('#timesheet_search_form').click(function(){
                        if(jQuery('#timesheetFromDate').val().length == 10 || jQuery('#timesheetToDate').val().length == 10){
                                var flag = true;
                                if(jQuery('#timesheetFromDate').val().length < 10)
                                        flag = false;
                                if( jQuery('#timesheetToDate').val().length < 10)
                                        flag = false;
                                if(flag)
                                        return true;
                                else{
                                        $('.new-messsages').html('<div style="width:400px;margin:0 auto;text-align:center;" id="response-message">From and To date(s) can not be left blank.</div>');
                                        $('#response-message').errorStyle();
                                        $('#response-message').show().delay(10000).fadeOut(600);    
                                        return false;
                                }
                        }else{
                                return true;
                        }
                });    
        });
</script>
<!-- Header Ends -->
<div id="page_content">
    <div id="page_content_inner">
        <?php echo $flash = $this->Session->flash(); ?>
        <div id="alerts"></div>
        <div class="md-card"> 
			<div class="md-card-content">
		<table class="uk-table uk-tab-responsive main tbl" id="TextBoxesGroup" border="1">

            <tr >	<th class="uk-text-left md-bg-blue-100 uk-te uk-text-small" scope="row">Employee ID : </th>
                    <th><?php echo $rwEmpTs[0]['MstTimesheet']['vc_emp_id']; ?></th>
                    <th class="uk-text-left md-bg-blue-100 uk-te uk-text-small" scope="row">Employee Name : </th>
                    <th><?php echo $this->Common->getempname($rwEmpTs[0]['MstTimesheet']['vc_emp_id']); ?></th>
                    <th class="uk-text-left md-bg-blue-100 uk-te uk-text-small" scope="row">Date :</th>
                    <th><?php echo date('d-m-Y'); ?></th>
                     </tr>
			</table>
			</div>
		</div>
		<div class="md-card"> 
		<div class="md-card-toolbar">
          
						<div class="md-card-toolbar-actions">
						<?php if (($rwTsRec[0]['MstTimesheet']['vc_status'] != 'P')) { ?>
							<a href="<?php echo $this->webroot; ?>timesheet/tsauto" title="Generate Timesheet"><button class="md-btn md-btn-primary"><span>Generate Timesheet</span></button></a>
						<?php } ?>
									
                            </div>
                            <h3 class="md-card-toolbar-heading-text">
                              <b> Timesheet List</b>
                            </h3>
                        </div>  
	
	<div class="md-card-content">
                <div class="uk-overflow-container uk-margin-bottom">

                    <table class="uk-table uk-table-align-vertical uk-table-nowrap tablesorter tablesorter-altair" id="dt_colVis">
                        <thead>
                            <tr>                
                                <th> Start Date</th>
                                                <th>End Date</th>
                                                <th>Submitted On</th>
                                                <th>Approved On</th>
                                                <th>Forms</th>
                                                <th>Reports</th>
                                                <th>Total Hours </th>
                                                <th>TS Type 	</th>
                                                <th>Status</th>
                                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                        foreach($rwEmpTs as $v) {
                            if ($v['MstTimesheet']["TS_TYPE"] == 'CO') {
                                $type = 'Consolidate';
                                $file = 'editauto';
                            } else {
                                $type = 'Normal';
                                $file = 'editauto';
                            }
                    ?>

                                <tr class="<?php
                if ($i % 2 == 0) {
                        echo "cont1";
                } else {
                        echo "cont";
                }
                                ?>">
                                        <td align="center" nowrap="nowrap"><?php echo date('d-M-Y',strtotime($v['MstTimesheet']["dt_start_date"])); ?></td>
                                        <td align="center" nowrap="nowrap"><?php echo date('d-M-Y',strtotime($v['MstTimesheet']["dt_end_date"])); ?></td>
                                        <td align="center" nowrap="nowrap"><?php echo date('d-M-Y',strtotime($v['MstTimesheet']["dt_applied"])); ?></td>
                                        <td align="center" nowrap="nowrap"><?php echo $v['MstTimesheet']["dt_approved"]; ?></td>
                                        <td  align="right"><?php echo $v['MstTimesheet']["vc_tot_frms"]; ?></td>
                                        <td align="right" ><?php echo $v['MstTimesheet']["vc_tot_reps"]; ?></td>
                                        <td align="right"><?php echo $v['MstTimesheet']["vc_tot_hrs"]; ?></td>
                                        <td align="center"><?php echo $type; ?></td>

                                        <?php $status = $v['MstTimesheet']["vc_status"]; ?>
                                        <td><?php
                        ;
                        if ($status == 'P') {
                                echo "PENDING";
                        } else if ($status == 'R') {
                                echo "REJECTED";
                        } else if ($status == 'S') {
                                echo "APPROVED";
                        } else if ($status == 'I') {
                                echo "INTERMEDIATE";
                        } else {
                                echo '';
                        }
                                        ?>

                                        <td>
                                                <ul class="edit-delete-icon">

                                                        <?php if ($status == 'I') { ?>
                                                                <span>
                                                                        <a href="<?php echo $file ?>/<?php echo $v['MstTimesheet']["s_no"] ?>/<?php echo $v['MstTimesheet']["vc_emp_id"]; ?>/<?php echo $v['MstTimesheet']["dt_start_date"]; ?>/<?php echo $v['MstTimesheet']["dt_end_date"] ?>" title="Edit"><i class="md-list-addon-icon material-icons">mode_edit</i></a>
                                                                 <?php if ($type != 'Normal') { ?> <?php } ?>
                                                                  <!--      <a href="javascript:void(0);" оnClick="javascript: if( confirm('Do you really want to delete this record?\nClick \'OK\' to continue and \'Cancel\' to stop.') ) window.location.href=<?php $this->webroot; ?>'delweektimesheet/Delete/<?php echo $emp_code; ?>/<?php echo $v['MstTimesheet']["id"]; ?>/<?php echo $v['MstTimesheet']["s_no"]; ?>/<?php echo $v['MstTimesheet']["vc_emp_id"] ?>'; return false;" title="Delete"><i class="material-icons md-24"></i></a></span> -->
                                                                <?php
                                                               
                                                        } else if ($status == 'S') {$auth=$this->Session->read('Auth');
									$date1 = date('d-M-Y'); ?>
									<span style="border:none;">
									<a href="<?php echo $file ?>/<?php echo $v['MstTimesheet']["s_no"] ?>/<?php echo $v['MstTimesheet']["vc_emp_id"]; ?>/<?php echo $v['MstTimesheet']["dt_start_date"]; ?>/<?php echo $v['MstTimesheet']["dt_end_date"] ?>" title="Edit"><i class="md-list-addon-icon material-icons">mode_edit</i></a>
									<span>
									<?php
									                           ?>
                                                                <span> <a href="tsview_new/<?php echo $v['MstTimesheet']["s_no"] ?>/<?php echo $v['MstTimesheet']["vc_emp_id"]; ?>/<?php echo $v['MstTimesheet']["dt_start_date"]; ?>/<?php echo $v['MstTimesheet']["dt_end_date"] ?>/2/S/custid" target="blank" title="Approved"> <i class="md-list-addon-icon material-icons">remove_red_eye</i></a></span>
                                                                <?php
                                                        } else if ($status == 'P') {
                                                                echo "PENDING";
                                                                ?>
                                                        <?php } else if ($status == 'R') { ?>
                                                                <span> <a href="#" data-uk-modal="{target:'#modal_overflow'}" onclick="Get_Details('<?php echo $v['MstTimesheet']['s_no']; ?>')" class="view vtip" title="See Remark"><i class="md-list-addon-icon material-icons">remove_red_eye</i></a></span>
                                                                <span>      <a href="<?php echo $file ?>/<?php echo $v['MstTimesheet']["s_no"] ?>/<?php echo $v['MstTimesheet']["vc_emp_id"]; ?>/<?php echo $v['MstTimesheet']["dt_start_date"]; ?>/<?php echo $v['MstTimesheet']["dt_end_date"] ?>" title="Edit Again"><i class="md-list-addon-icon material-icons">mode_edit</i></a></span>
                                                                
                                                                <?php } ?>
                                                </ul>
                                        </td>

                                </tr>
                        <?php } ?>



                        </tbody>
                    </table>
                </div>
            </div>
	</div>
		

<div class="uk-width-medium-1-4">
    <div id="modal_overflow" class="uk-modal">
        <div class="uk-modal-dialog uk-modal-dialog-medium">
            <button type="button" class="uk-modal-close uk-close"></button>            
            <div class="uk-overflow-container">
            <h4>Reject Remark:</h4>
            </div>
    </div>
</div>
  

<script>
    function Get_Details(id)
    {
        jQuery.ajax({
            url: '<?php echo $this->webroot ?>timesheet/rej_remark/' + id,
            success: function (data) {
                jQuery('#empResponse').html(data);
            }
        });
    }
</script>

