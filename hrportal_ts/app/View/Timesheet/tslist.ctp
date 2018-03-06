
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
		
		<table width="100%" border="0" cellspacing="5" cellpadding="5">

            <tr>
                    <th scope="row">Employee Name : </th>
                    <td><?php echo $rwEmpTs["EMP_NAME"][0]; ?></td>
                    <th scope="row">Region :</th>
                    <td>
                        <?php echo $rwEmpTs["REGION"][0] ?>  </td>
                    <th scope="row">Date : </th>
                    <td><?php echo date('d-m-Y'); ?></td>
                    <th scope="row"></th>
                   </tr>
			</table>
		</div>
		<div class="md-card"> 
		 <div class="md-card-toolbar">
          

                            <div class="md-card-toolbar-actions">
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
                        for ($i = 0; $i < $numEmpTs; $i++) {
                            if ($rwEmpTs["TS_TYPE"][$i] == 'CO') {
                                $type = 'Consolidate';
                                $file = 'editauto';
                            } else {
                                $type = 'Normal';
                                $file = 'edittimesheet';
                            }
                    ?>

                                <tr class="<?php
                if ($i % 2 == 0) {
                        echo "cont1";
                } else {
                        echo "cont";
                }
                                ?>">
                                        <td align="center" nowrap="nowrap"><?php echo $rwEmpTs["START_DATE"][$i]; ?></td>
                                        <td align="center" nowrap="nowrap"><?php echo $rwEmpTs["END_DATE"][$i]; ?></td>
                                        <td align="center" nowrap="nowrap"><?php echo $rwEmpTs["SUBMITTED_ON"][$i]; ?></td>
                                        <td align="center" nowrap="nowrap"><?php echo $rwEmpTs["APPROVED_ON"][$i]; ?></td>
                                        <td  align="right"><?php echo $rwEmpTs["TOTFRM"][$i]; ?></td>
                                        <td align="right" ><?php echo $rwEmpTs["TOTREP"][$i]; ?></td>
                                        <td align="right"><?php echo $rwEmpTs["TOTHRS"][$i]; ?></td>
                                        <td align="center"><?php echo $type; ?></td>

                                        <?php $status = $rwEmpTs["STATUS"][$i]; ?>
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
                                                                        <a href="<?php echo $file ?>/<?php echo $rwEmpTs["SNO"][$i] ?>/<?php echo $rwEmpTs["VC_EMP_ID"][$i]; ?>/<?php echo $rwEmpTs["START_DATE"][$i]; ?>/<?php echo $rwEmpTs["END_DATE"][$i] ?>" title="Edit"><i class="md-list-addon-icon material-icons"></i></a>
                                                                 <?php if ($type != 'Normal') { ?> <?php } ?>
                                                                        <a href="javascript:void(0);" onClick="javascript: if( confirm('Do you really want to delete this record?\nClick \'OK\' to continue and \'Cancel\' to stop.') ) window.location.href=<?php $this->webroot; ?>'delweektimesheet/Delete/<?php echo $emp_code; ?>/<?php echo $rwEmpTs["START_DATE"][$i]; ?>/<?php echo $rwEmpTs["END_DATE"][$i]; ?>/<? echo $rwEmpTs["SNO"][$i]; ?>/<?php echo $rwEmpTs["VC_EMP_ID"][$i] ?>'; return false;" title="Delete"><i class="material-icons md-24"></i></a></span>
                                                                <?php
                                                               
                                                        } else if ($status == 'S') {
														$auth=$this->Session->read('Auth');
														$date1 = date('d-M-Y');
														//echo $auth['Employees']['vc_emp_id_makess'];
														if(($auth['Employees']['vc_emp_id_makess']=='894' || $auth['Employees']['vc_emp_id_makess']=='2023' || $auth['Employees']['vc_emp_id_makess']=='2144' || $auth['Employees']['vc_emp_id_makess']=='1792') && strtotime($rwEmpTs["START_DATE"][$i])>=strtotime('11-JAN-2016')){
														
									?>
									<span style="border:none;">
									<a href="<?php echo $file ?>/<?php echo $rwEmpTs["SNO"][$i] ?>/<?php echo $rwEmpTs["VC_EMP_ID"][$i]; ?>/<?php echo $rwEmpTs["START_DATE"][$i]; ?>/<?php echo $rwEmpTs["END_DATE"][$i] ?>" title="Edit"><i class="md-list-addon-icon material-icons"></i></a>
									<span>
									<?php
									}
									
									if(($auth['Employees']['vc_emp_id_makess']=='1865' || $auth['Employees']['vc_emp_id_makess']=='1992' || $auth['Employees']['vc_emp_id_makess']=='1862' || $auth['Employees']['vc_emp_id_makess']=='2011' || $auth['Employees']['vc_emp_id_makess']=='1565' || $auth['Employees']['vc_emp_id_makess']=='264' || $auth['Employees']['vc_emp_id_makess']=='1895') && strtotime($rwEmpTs["START_DATE"][$i])>=strtotime('14-SEP-2015')){
														
									?>
									<span style="border:none;">
									<a href="<?php echo $file ?>/<?php echo $rwEmpTs["SNO"][$i] ?>/<?php echo $rwEmpTs["VC_EMP_ID"][$i]; ?>/<?php echo $rwEmpTs["START_DATE"][$i]; ?>/<?php echo $rwEmpTs["END_DATE"][$i] ?>" title="Edit"> <i class="md-list-addon-icon material-icons"></i></a>
									<span>
									<?php
									}
                                                                ?>
                                                                <span> <a href="tsview/<?php echo $rwEmpTs["SNO"][$i] ?>/<?php echo $rwEmpTs["VC_EMP_ID"][$i]; ?>/<?php echo $rwEmpTs["START_DATE"][$i]; ?>/<?php echo $rwEmpTs["END_DATE"][$i] ?>/2/S/custid" target="blank" title="Approved"> <i class="md-list-addon-icon material-icons"></i></a></span>
                                                                <span style="border:none;"> <a href="<?php echo $file ?>/<?php echo $rwEmpTs["SNO"][$i] ?>/<?php echo $rwEmpTs["VC_EMP_ID"][$i]; ?>/<?php echo $rwEmpTs["START_DATE"][$i]; ?>/<?php echo $rwEmpTs["END_DATE"][$i] ?>/milestone" title="Milestone" title="AttachMilestone"> <i class="md-list-addon-icon material-icons"></i> </a></span>
                                                                <?php
                                                        } else if ($status == 'P') {
                                                                echo "";
                                                                ?>
                                                        <?php } else if ($status == 'R') { ?>
                                                                <span> <a href="#" onClick="getrejectreson(<?php echo $rwEmpTs["SNO"][$i]; ?>,<?php echo $rwEmpTs["VC_EMP_ID"][$i] ?>)" class="view vtip" title="See Remark"></a>
                                                                <span>      <a href="<?php echo $file ?>/<?php echo $rwEmpTs["SNO"][$i] ?>/<?php echo $rwEmpTs["VC_EMP_ID"][$i]; ?>/<?php echo $rwEmpTs["START_DATE"][$i]; ?>/<?php echo $rwEmpTs["END_DATE"][$i] ?>" title="Edit Again"><i class="md-list-addon-icon material-icons"></i></a></span>
                                                                <span style="border:none;">       <a href="javascript:void(0);" onClick="javascript: if( confirm('Do you really want to delete this record?\nClick \'OK\' to continue and \'Cancel\' to stop.') ) window.location.href=<?php $this->webroot; ?>'delweektimesheet/Delete/<?php echo $emp_code; ?>/<?php echo $rwEmpTs["START_DATE"][$i]; ?>/<?php echo $rwEmpTs["END_DATE"][$i]; ?>/<? echo $rwEmpTs["SNO"][$i]; ?>/<?php echo $rwEmpTs["VC_EMP_ID"][$i] ?>'; return false;"title="Delete"> <i class="material-icons md-24"></i></a>
                                                                <?php } ?>
                                                </ul>
                                        </td>

                                </tr>
                        <?php } ?>



                        </tbody>
                    </table>
                </div>
                <div class="clearfix"></div>
                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-1-1">
                        <ul class="uk-pagination uk-pagination-right">
                             

                            <?php
                            echo $this->Paginator->prev('Previous', array('tag' => 'li', 'escape' => false), '<a>Previous</a>', array('class' => 'uk-disabled', 'tag' => 'li', 'escape' => false));
                            echo $this->Paginator->numbers(array('separator' => '', 'tag' => 'li', 'currentLink' => true, 'currentClass' => 'uk-active', 'currentTag' => 'a'));
                            echo $this->Paginator->next('Next', array('tag' => 'li', 'escape' => false), '<a>Next</a>', array('class' => 'uk-disabled', 'tag' => 'li', 'escape' => false));
                            ?>
                        </ul>
                    </div>

                </div>

            </div>
		</div>
		

   

<div id="dialog" title="Remark/Comment" style="display:none">
<div id="getrejectionresion"></div>
</div>