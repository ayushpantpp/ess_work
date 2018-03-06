
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
<div class="breadCrumbHolder module">
    <div id="breadCrumb0" class="breadCrumb module">
        <ul>
            <li>
                <a href="<?php echo $this->webroot;?>employees/dashboard" class="vtip" title="Home">Home</a>
            </li>

          
        </ul>
    </div>
</div>

<h2 class="demoheaders">View</h2>
<!-- Center Content Starts -->
<?php  if(!empty($rwEmpTs["EMP_NAME"][0])){ ?>
    <div class="travel-voucher">
                    <div class="input-boxs">
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
    </div> <?php } $form = $this->Form; ?>
  <div class="travel-voucher">
        <div class="input-boxs">
<?php echo $this->Form->create('timesheet', array('url' => array('controller' => 'Timesheet', 'action' => 'tslist'), 'id' => 'Timesheet', 'name' => 'Timesheet')); ?>

            <table width="100%" border="0" cellspacing="5" cellpadding="5">
                <tr>
                    <th scope="row">From Date :</th>
                                <td><?php echo $form->input('timesheet.from_date', array('label' => false, 'type' => 'text', 'class' => 'required','size'=>'20')); ?>
                                    <script type="text/javascript"> jQuery(function(){jQuery('#timesheetFromDate').datepicker({ inline: true, dateFormat: 'dd-mm-yy' });});</script></td>

                    <th scope="row">To Date :</th>
                                <td><?php echo $form->input('timesheet.to_date', array('label' => false, 'type' => 'text', 'class' => 'required')); ?>
                                        <script type="text/javascript"> jQuery(function(){jQuery('#timesheetToDate').datepicker({ inline: true, dateFormat: 'dd-mm-yy' });});</script></td>
                                <th scope="row">Filter :</th>
                                <td   align="left"> :&nbsp;&nbsp;
                                        <select name="TsFilter" class="textBox" onChange="javascript: this.form.submit();">
                                                <option value="">Show All</option>
                                                <option value="I" <?php if (!empty($_REQUEST['TsFilter'])) echo ($_REQUEST['TsFilter'] == "I") ? 'SELECTED' : '' ?>>Intermediate</option>
                                                <option value="P" <?php if (!empty($_REQUEST['TsFilter'])) echo ($_REQUEST['TsFilter'] == "P") ? 'SELECTED' : '' ?>>Pending</option>
                                                <option value="S" <?php if (!empty($_REQUEST['TsFilter'])) echo ($_REQUEST['TsFilter'] == "S") ? 'SELECTED' : '' ?>>Approved</option>
                                                <option value="R" <?php if (!empty($_REQUEST['TsFilter'])) echo ($_REQUEST['TsFilter'] == "R") ? 'SELECTED' : '' ?>>Rejected</option>
                                        </select></td>
                                <td class="submit-form"> <input type="submit" name="display" value="Search" id="timesheet_search_form"  class="taskbutton"></td>
                        </tr>
                </table>
        </div>

        <?php $totalpages = (integer) ceil(( $numEmpTs1 / $limit)); ?>

        <div class="travel-voucher1" style=" margin-bottom:5px;">
                <div class="input-boxs-timesheet">
                        <div>
                                <table width="100%" border="0" cellspacing="1" cellpadding="5" class="exp-voucher">
                                        <tr class="head">
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
                                        <?php if (empty($numEmpTs) || $numEmpTs == 0) { ?>

               <tr class="cont">
    <td style="text-align:center;" colspan="11">
    <em>--No Records Found--</em>
    </td>
    </tr>

         </div></div>
                    <?php }else{?>


     
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
                                                                <li>
                                                                        <a href="<?php echo $file ?>/<?php echo $rwEmpTs["SNO"][$i] ?>/<?php echo $rwEmpTs["VC_EMP_ID"][$i]; ?>/<?php echo $rwEmpTs["START_DATE"][$i]; ?>/<?php echo $rwEmpTs["END_DATE"][$i] ?>" class="edit vtip" title="Edit">Edit</a>
                                                                </li> 
                                                                <li <?php if ($type != 'Normal') { ?> style="border:none; <?php } ?>">
                                                                        <a href="javascript:void(0);" onClick="javascript: if( confirm('Do you really want to delete this record?\nClick \'OK\' to continue and \'Cancel\' to stop.') ) window.location.href=<?php $this->webroot; ?>'delweektimesheet/Delete/<?php echo $emp_code; ?>/<?php echo $rwEmpTs["START_DATE"][$i]; ?>/<?php echo $rwEmpTs["END_DATE"][$i]; ?>/<? echo $rwEmpTs["SNO"][$i]; ?>/<?php echo $rwEmpTs["VC_EMP_ID"][$i] ?>'; return false;" class="delete vtip" title="Delete">Delete </a></li>
                                                                <?php
                                                                if ($type == 'Normal') {
                                                                        ?>
                                                                        <li style="border:none;">
                                                                                <a href="#" onClick="javascript: if( confirm('Do you really want to switch to consolidate mode?\nClick \'OK\' to continue and \'Cancel\' to stop.') ) window.location.href='changenormal?task=Update&empCode=<?php echo $emp_code; ?>&fromdate=<?php echo $rwEmpTs["START_DATE"][$i]; ?>&todate=<?php echo $rwEmpTs["END_DATE"][$i]; ?>&sno=<? echo $rwEmpTs["SNO"][$i]; ?>&empid=<?php echo $rwEmpTs["VC_EMP_ID"][$i] ?>'; return false;"  class="shuffle vtip" title="Switch to consolidate"></a>
                                                                        </li>
                                                                        <?php
                                                                }
                                                        } else if ($status == 'S') {
														$auth=$this->Session->read('Auth');
														$date1 = date('d-M-Y');
														//echo $auth['Employees']['vc_emp_id_makess'];
														if(($auth['Employees']['vc_emp_id_makess']=='894' || $auth['Employees']['vc_emp_id_makess']=='2023' || $auth['Employees']['vc_emp_id_makess']=='2144' || $auth['Employees']['vc_emp_id_makess']=='1792') && strtotime($rwEmpTs["START_DATE"][$i])>=strtotime('11-JAN-2016')){
														
									?>
									<li style="border:none;">
									<a href="<?php echo $file ?>/<?php echo $rwEmpTs["SNO"][$i] ?>/<?php echo $rwEmpTs["VC_EMP_ID"][$i]; ?>/<?php echo $rwEmpTs["START_DATE"][$i]; ?>/<?php echo $rwEmpTs["END_DATE"][$i] ?>" class="edit vtip" title="Edit">Edit</a>
									<li>
									<?php
									}
									
									if(($auth['Employees']['vc_emp_id_makess']=='1865' || $auth['Employees']['vc_emp_id_makess']=='1992' || $auth['Employees']['vc_emp_id_makess']=='1862' || $auth['Employees']['vc_emp_id_makess']=='2011' || $auth['Employees']['vc_emp_id_makess']=='1565' || $auth['Employees']['vc_emp_id_makess']=='264' || $auth['Employees']['vc_emp_id_makess']=='1895') && strtotime($rwEmpTs["START_DATE"][$i])>=strtotime('14-SEP-2015')){
														
									?>
									<li style="border:none;">
									<a href="<?php echo $file ?>/<?php echo $rwEmpTs["SNO"][$i] ?>/<?php echo $rwEmpTs["VC_EMP_ID"][$i]; ?>/<?php echo $rwEmpTs["START_DATE"][$i]; ?>/<?php echo $rwEmpTs["END_DATE"][$i] ?>" class="edit vtip" title="Edit">Edit</a>
									<li>
									<?php
									}
                                                                ?>
                                                                <li> <a href="tsview/<?php echo $rwEmpTs["SNO"][$i] ?>/<?php echo $rwEmpTs["VC_EMP_ID"][$i]; ?>/<?php echo $rwEmpTs["START_DATE"][$i]; ?>/<?php echo $rwEmpTs["END_DATE"][$i] ?>/2/S/custid" target="blank"  class="view vtip" title="Approved"></a></li>
                                                                <li style="border:none;"> <a href="<?php echo $file ?>/<?php echo $rwEmpTs["SNO"][$i] ?>/<?php echo $rwEmpTs["VC_EMP_ID"][$i]; ?>/<?php echo $rwEmpTs["START_DATE"][$i]; ?>/<?php echo $rwEmpTs["END_DATE"][$i] ?>/milestone" title="Milestone" class="milestone vtip" title="AttachMilestone"></a></li>
                                                                <?php
                                                        } else if ($status == 'P') {
                                                                echo "";
                                                                ?>
                                                        <?php } else if ($status == 'R') { ?>
                                                                <li> <a href="#" onClick="getrejectreson(<?php echo $rwEmpTs["SNO"][$i]; ?>,<?php echo $rwEmpTs["VC_EMP_ID"][$i] ?>)" class="view vtip" title="See Remark"></a>
                                                                <li>      <a href="<?php echo $file ?>/<?php echo $rwEmpTs["SNO"][$i] ?>/<?php echo $rwEmpTs["VC_EMP_ID"][$i]; ?>/<?php echo $rwEmpTs["START_DATE"][$i]; ?>/<?php echo $rwEmpTs["END_DATE"][$i] ?>" class="edit vtip" title="Edit Again">Edit Again</a></li>
                                                                <li style="border:none;">       <a href="javascript:void(0);" onClick="javascript: if( confirm('Do you really want to delete this record?\nClick \'OK\' to continue and \'Cancel\' to stop.') ) window.location.href=<?php $this->webroot; ?>'delweektimesheet/Delete/<?php echo $emp_code; ?>/<?php echo $rwEmpTs["START_DATE"][$i]; ?>/<?php echo $rwEmpTs["END_DATE"][$i]; ?>/<? echo $rwEmpTs["SNO"][$i]; ?>/<?php echo $rwEmpTs["VC_EMP_ID"][$i] ?>'; return false;" class="delete vtip" title="Delete"></a>
                                                                <?php } ?>
                                                </ul>
                                        </td>

                                </tr>
                        <?php } ?>


                <?php } ?>
                </table>
                <?php $form->end(); ?>

                <div class="navigation">
                        <?php show_paging_options($_REQUEST['page'], $totalpages, $param); ?>
                </div>
        </div>
</div>
</div>
</div>

   

<div id="dialog" title="Remark/Comment" style="display:none">
<div id="getrejectionresion"></div>
</div>
<?php

function show_paging_options($page_number, $totalpages, $param = null) {
        global $limit, $cur_file;
        ?>
        <?php
        if ($totalpages > 1) {
                echo $page_number . " of " . $totalpages . " Pages";
                if ($page_number != 1) {
                        echo "<span><a class='prev' href='" . $cur_file . "?page=1&" . $param . "'>[&lt;&lt;First]</a></span>";
                        echo "<span><a class='prev' href='" . $cur_file . "?page=" . ($page_number - 1) . $param . "'>[&lt;&lt;Previous]</a></span>";
                } else {
                        echo "<span class='disabled'>[&lt;&lt;First]</span>";
                        echo "<span class='disabled'>[&lt;&lt;Prev]</span>";
                }
                ?>


                <?php
                $start_no = ($page_number > 10) ? $page_number - 10 : 1;
                $end_no = $page_number + 9;

                for ($i = $start_no; $i <= $end_no; $i++) {
                        $page_class = ($i == $page_number) ? 'pagination-v' : 'pagination-a';

                        if ($page_number == $i) {
                                echo "<span>";
                                echo $i;
                                echo "</span>";
                                if ($i != $totalpages)
                                        echo "|";
                        } else {
                                if ($i < $totalpages) {
                                        echo '<span><a class="paginationtext"  href="?page=' . $i . $param . '" />' . $i . '</a></span>|';
                                }
                                if ($i == $totalpages) {
                                        echo '<span><a class="paginationtext"  href="?page=' . $i . $param . '" />' . $i . '</a></span>';
                                }
                        }
                }

                if ($page_number != $totalpages) {
                        echo "<span><a class='next' href='" . $cur_file . "?page=" . ($page_number + 1) . $param . "'>[Next&gt;&gt;]</a></span>";
                        echo "<span><a class='next' href='" . $cur_file . "?page=" . ($totalpages) . $param . "'>[Last&gt;&gt;]</a></span>";
                } else {
                        echo "<span>[Next&gt;&gt;]</span>";
                        echo "<span>[Last&gt;&gt;]</span>";
                }
        }
}
?>