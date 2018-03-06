<?php

$auth = $this->Session->read('Auth'); ?>

<div id="page_content" role="main">
    <div id="page_content_inner">
        <h3 class="heading_b uk-margin-bottom">Leave Approval</h3>
        <?php echo $flash = $this->Session->flash(); ?>
        <div id="alerts"></div>
        <div class="md-card">
            <div class="md-card-content large-padding">
                <?php
                echo $this->Form->create('fwleave', array('inputDefaults' => array(
                        'label' => false, 'div' => false, 'error' => array('wrap' => 'span', 'class' => 'my-error-class')),
                    'url' => array('controller' => 'leaves', 'action' => 'leavewfsaveinfo'), 'id' => 'leavewfid', 'name' => 'leavewfname'));
                ?>
                <?php
                if (is_numeric($leave)) {
                    $getlvl = $this->Common->getlevelbylvid($leave);
                    $getlevel = $this->Common->getlevelAll($leave);
                    ?>
                <table class="uk-table">
                <?php if (count($getlvl) > 0) { ?>
                    <thead>
                        <tr class="headings">

                            <th>Level</th>
                            <th>Name</th>                        
                            <th> Forwarded Date</th>
                            <th>Remarks (if any)</th>
                        </tr>
                    </thead>
                    <tbody>
                                <?php
                                $i = 0;
                                foreach ($getlvl as $v) {
                                    if ($i % 2 == 0)
                                        $class = "cont1";
                                    else
                                        $class = "cont";
                                    ?>
                        <tr class="<?php echo $class; ?>">
                            <td ><strong><?php echo "Level-" . $i; ?></strong> </td>
                            <td ><strong><?php echo $this->Common->getempinfo($v['LeaveWorkflow']['emp_code']); ?> </strong> </td>
                            <td ><strong>
                                                <?php
                                                if (!empty($v['LeaveWorkflow']['fw_date'])) {
                                                    echo date('d-M-Y', strtotime($v['LeaveWorkflow']['fw_date']));
                                                } else {
                                                    echo date("d-M-Y");
                                                }
                                                ?>
                                </strong> </td>

                            <td><strong>
                                                <?php if (!empty($v['LeaveWorkflow']['remark'])) {
                                                    echo $v['LeaveWorkflow']['remark']
                                                    ?>
            <?php } else echo "N/A" ?>        
                                </strong>

                            </td><tr>
                                        <?php
                                        $i++;
                                    }
                                }
                                ?> 

                        <tr>
                            <td colspan="3" style="display:none"> 
                                <input type="hidden" value ="<?php echo $leave; ?>" name="data[LeaveWorkflow][leave_id]"> 
                                <input type="hidden" value ="<?php echo $LeaveWorkflowid['LeaveWorkflow']['leave_wf_id']; ?>" name="data[LeaveWorkflow][id]">
                            </td>
                        <tr>
                                <?php
                                $deptcode = $this->Common->getemocodebydept($getlvl[0]['LeaveWorkflow']['emp_code']);
                                $checklvlapp = $this->Common->findAppLevel($appId);
                                $leaveConfi = new LeaveConfiguration();
                              
                                $cl_leave_code = $leaveConfi->find('first',array('fields'=>array('leave_code'),'conditions'=>array('leave_type'=>'CL')));
                                $ol_leave_code = $leaveConfi->find('first',array('fields'=>array('leave_code'),'conditions'=>array('leave_type'=>'OL')));
                                $sl_leave_code = $leaveConfi->find('first',array('fields'=>array('leave_code'),'conditions'=>array('leave_type'=>'SL')));
                                $lwp_leave_code = $leaveConfi->find('first',array('fields'=>array('leave_code'),'conditions'=>array('leave_type'=>'LWP')));
                                $el_leave_code = $leaveConfi->find('first',array('fields'=>array('leave_code'),'conditions'=>array('leave_type'=>'EL')));
						
                                echo $lvl = count($getlevel) - 1;
								//&& ($leavetype != $cl_leave_code["LeaveConfiguration"]["leave_code"] || $leavetype != $el_leave_code["LeaveConfiguration"]["leave_code"])
                                if (count($getlevel) == $checklvlapp) {
                                  // die ("here");
                                    $fwemplist = $this->Common->getHrList($auth['MyProfile']['emp_code']);
                                } else {
                                  //  die("there");
                                    $fwemplist = $this->Common->findLevel();
                                }
                                if (count($getlevel) > 2) {
                                    $checkrevert = $this->Common->checkleaverevert($leave);
                                }
                                ?>
                        <tr class="hidehr"> 
                            <!--                    
                                <?php if($lvl < $checklvlapp && $leaveStatus != 6 && ($leavetype == $cl_leave_code["LeaveConfiguration"]["leave_code"] || $leavetype == $el_leave_code["LeaveConfiguration"]["leave_code"])) { ?>
                                     <td>
                                    <input type="radio" class="flat" name="data[LeaveWorkflow][type]" value="5" checked="checked" > <strong>
                                    <?php echo "Approve";
                                    ?>
                                       
                                    </strong>
                                  </td>
                                   
                                  
    <?php } else { ?>
                                   <td><input type="radio" class="flat" name="data[LeaveWorkflow][type]" value="2" checked="checked" ><strong> Forward 
                                  </strong></td>
                                <?php } ?>
                            -->


                                <?php
                                if ($leavetype == $cl_leave_code["LeaveConfiguration"]["leave_code"] || $leavetype == $el_leave_code["LeaveConfiguration"]["leave_code"]) {
                                    if ($lvl < $checklvlapp) {
                                        ?>
                            <td>
                                <input type="radio" class="flat" name="data[LeaveWorkflow][type]" value="5" checked="checked" onclick="displaytype(this.value);"> <strong>Approve </strong>
                            </td>
                                        <?php
                                    }
                                } else {
                                    if ($lvl < $checklvlapp) {
                                        ?>

                            <td><input type="radio" class="flat" name="data[LeaveWorkflow][type]" value="2" checked="checked" onclick="displaytype(this.value);" ><strong> Forward </strong>
                            </td>      
                                        <?php
                                    } else {
                                        ?>
                            <td>
                                <input type="radio" class="flat" name="data[LeaveWorkflow][type]" value="5" checked="checked" onclick="displaytype(this.value);" > <strong>Approve           
                                </strong>
                            </td>
                                    <?php }
                                } ?>


    <?php if ($checkrevert) {
        ?>
                            <td>
                                <input type="radio" class=" flat" name="data[LeaveWorkflow][type]" value="3" onclick="displaytype(this.value);"><strong> Revert </strong>
                            </td>
                                <?php } ?>
                            <td colspan="3">
                                <input type="radio"  class="form-control flat" name="data[LeaveWorkflow][type]" onclick="displaytype(this.value);" value="4"><strong> Reject </strong>
                            </td>


                        </tr>

                        <tr id="reject" style="display:none;">
                            <td align="right">Remark*</td>
                            <td colspan="5">
                                <table>
                                    <tr>
                                        <td>
                                            <textarea class="form-control" style="width: 348px; height: 95px;"  name="data[LeaveWorkflow][reject_remark]" id="rejcmnt" col="100" row="100"  ></textarea>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr> 
    <?php
    if ($checkrevert) {
        $revertemplist = $this->Common->getRevertEmp($leave);
        ?>
                        <tr id="revert" style="display:none;">
                            <td align="right">Revert*</td>
                            <td colspan="5">
                                <table>
                                    <tr>
                                        <td>
        <?php echo $this->Form->input('LeaveWorkflow.revert_emp_code', array('type' => 'select', 'label' => false, 'options' => $revertemplist, 'class' => 'form-control round_select', 'id' => 'revertempcode')); ?> 
                                    <tr>
                                        <td><textarea name="data[LeaveWorkflow][revert_remark]" id="revcmnt" col="100" row="100" ></textarea>
                                        </td>
                                    </tr>
                                </table>      
                            </td>
                        </tr> 


    <?php } ?>      
    <?php
    if ($lvl < $checklvlapp && $leaveStatus != 6 && !($leavetype == $cl_leave_code["LeaveConfiguration"]["leave_code"] || $leavetype == $el_leave_code["LeaveConfiguration"]["leave_code"])) {
        ?>
                        <tr id="forward" class="hidehr">          
                            <td align="right">Forward :</td>
                            <td colspan="5">
                                <table>
                                    <tr>
                                        <td>
        <?php echo $this->Form->input('LeaveWorkflow.forward_emp_code', array('type' => 'select', 'label' => false, 'options' => $fwemplist, 'class' => 'form-control round_select', 'id' => 'fwlvlempcode')); ?>
                                        </td></tr><tr><td><textarea cols="form-control"  name="data[LeaveWorkflow][forward_remark]" id="frwdcmnt" col="100" row="100" > </textarea>
                                        </td>
                                    </tr>
                                </table>
                        </tr>
    <?php } else { ?>


                                <?php
                                if ($checkForwardHr) {
                                    $hrList = $this->Common->getHrList($auth['MyProfile']['emp_code']);
                                    ?>
                        <tr id="forward_hr_tr" class="hidehr">          
                            <td align="right">Forward to HR :</td>
                            <td colspan="2">
                                <table>
                                    <tr><td>
            <?php echo $this->Form->input('LeaveWorkflow.hr_emp_code', array('type' => 'select', 'label' => false, 'empty' => '- -Select- -', 'options' => $hrList, 'class' => 'form-control round_select', 'id' => 'fwhrempcode')); ?>
                                        </td></tr><tr><td><textarea  style="width: 348px; height: 95px;" class="form-control"  name="data[LeaveWorkflow][hr_forward_remark]" id="frwdcmnt" col="100" row="100" > </textarea></td></tr></table>

                                                    <?php } else { ?>

                        <tr id="approved_tr" class="hidehr">
                            <td align="right">Remark :</td>
                            <td colspan="5">
                                <table>    
                                    <tr>
                                        <td ><textarea class="form-control" style="width: 348px; height: 95px;" name="data[LeaveWorkflow][approve_remark]" id="appcmnt" col="100" row="100" ></textarea>
                                        </td>
                                    </tr>
                                </table>
                        </tr>       
        <?php } ?>
    <?php } ?>
                    </tbody>
                </table>
                            <?php echo $this->Form->submit('APPROVE', array('onClick' => 'return checkSubmit()', 'name' => 'data[LeaveWorkflow][save]', 'class' => 'md-btn md-btn-success')); ?>
<?php } ?>     
                <?php $this->Form->end(); ?>
            </div>

        </div>
    </div>
</div>

<!-- footer content --> 
<!--<footer>
  <div class="">
    <p class="pull-right">HR Portal by <a href="https://essindia.com/" target="_blank">ESS</a>. | <span class="lead"> <img src="images/ess-logo.png" width="" height="20" alt="Ess Logo"></span> </p>
  </div>
  <div class="clearfix"></div>
</footer>--> 
<!-- /footer content --> 

</div>



<script type="text/javascript">
    function displaytype(a)
    {

        //var typeval = $("input[name='data[TravelWorkflow][type]']:checked").val();
        //alert(a);
        var typeval = a;
        if (typeval == 2)
        {
            $("#reject").css('display', 'none');
            $("#revert").css('display', 'none');
            $("#forward").css('display', '');
            $("#approved_tr").css('display', 'none');
            $("#forward_hr_tr").css('display', 'none');
        } else if (typeval == 3)
        {
            $("#reject").css('display', 'none');
            $("#revert").css('display', '');
            $("#forward").css('display', 'none');
            $("#approved_tr").css('display', 'none');
            $("#forward_hr_tr").css('display', 'none');
        } else if (typeval == 4)
        {
            $("#reject").css('display', '');
            $("#revert").css('display', 'none');
            $("#forward").css('display', 'none');
            $("#approved_tr").css('display', 'none');
            $("#forward_hr_tr").css('display', 'none');
        } else if (typeval == 5)
        {
            $("#reject").css('display', 'none');
            $("#revert").css('display', 'none');
            $("#forward").css('display', 'none');
            $("#approved_tr").css('display', '');
            $("#forward_hr_tr").css('display', 'none');
        } else if (typeval == 6)
        {
            $("#reject").css('display', 'none');
            $("#revert").css('display', 'none');
            $("#forward").css('display', 'none');
            $("#approved_tr").css('display', 'none');
            $("#forward_hr_tr").css('display', '');
        }
    }
    function checkSubmit()
    {
        if ($('#forward').is(':visible'))
        {
            if ($("#fwlvlempcode").val() == '')
            {
                $("html, body").animate({scrollTop: 0}, "slow");
                $("#alerts").html("<div data-uk-alert='' class='uk-alert uk-alert-danger'><a class='uk-alert-close uk-close' href='#'></a>Select the employee name to whom you want to forward.").show();
                return false;
            }
        } else if ($('#revert').is(':visible'))
        {
            if ($("#revertempcode").val() == '')
            {
                $("html, body").animate({scrollTop: 0}, "slow");
                $("#alerts").html("<div data-uk-alert='' class='uk-alert uk-alert-danger'><a class='uk-alert-close uk-close' href='#'></a>Select the employee name to whom you want to revert.").show();
                return false;
            }
            if ($("#revcmnt").val() == '')
            {
                $("html, body").animate({scrollTop: 0}, "slow");
                $("#alerts").html("<div data-uk-alert='' class='uk-alert uk-alert-danger'><a class='uk-alert-close uk-close' href='#'></a>Enter Revert Comment").show();
                return false;
            }
        } else if ($('#reject').is(':visible'))
        {
            if ($.trim($("#rejcmnt").val()) == "")
            {
                $("html, body").animate({scrollTop: 0}, "slow");
                $("#alerts").html("<div data-uk-alert='' class='uk-alert uk-alert-danger'><a class='uk-alert-close uk-close' href='#'></a>Enter Reject Remark.").show();
                return false;
            }
        }
        if ($('#forward_hr_tr').is(':visible'))
        {
            if ($("#fwhrempcode").val() == '')
            {
                alert("Select the HR Name to whom you want to forward.");
                return false;
            }
        }
        return true;
    }


</script>
