<div id="page_content" role="main">
    <div id="page_content_inner">
        <h3 class="heading_b uk-margin-bottom">Leave Encashment Approval</h3>
        <?php echo $flash = $this->Session->flash(); ?>
        <div id="alerts"></div>
        <div class="md-card">
            <div class="md-card-content large-padding">
                <?php
                echo $this->Form->create('fwleaveencsh', array('inputDefaults' => array(
                        'label' => false, 'div' => false, 'error' => array('wrap' => 'span', 'class' => 'my-error-class')),
                    'url' => array('controller' => 'leaves', 'action' => 'leaveencshwfsaveinfo'), 'id' => 'leavewfid', 'name' => 'leaveencsh'));
                ?>
                <?php
                if (is_numeric($LeaveEncshid)) {
                    $getlvl = $this->Common->getEncshlevelbylvid($LeaveEncshid);
                    ?>
                    <table class="uk-table">
                        <?php if (count($getlvl) > 0) { ?>
                            <thead>
                                <tr>                     
                                    <th>Level</th>
                                    <th>Name</th>                        
                                    <th>Date</th>
                                    <th>Status</th>
                                    <th>Remarks (if any)</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 0;
                                foreach ($getlvl as $v) {
                                    //Get First Workflow emp_code
                                    if ($i == 0)
                                        $applierEmpCode = $v['LeaveEncashmentWorkflow']['emp_code'];

                                    if ($i % 2 == 0)
                                        $class = "cont1";
                                    else
                                        $class = "cont";
                                    ?>
                                    <tr class="<?php echo $class; ?>">
                                        <td ><strong><?php echo "Level-" . $i; ?></strong> </td>
                                        <td ><strong><?php echo $this->Common->getempinfo($v['LeaveEncashmentWorkflow']['emp_code']); ?> </strong> </td>
                                        <td ><strong>
                                                <?php
                                                if (!empty($v['LeaveEncashmentWorkflow']['fw_date'])) {
                                                    echo date('d-M-Y', strtotime($v['LeaveEncashmentWorkflow']['fw_date']));
                                                } else {
                                                    echo date("d-M-Y");
                                                }
                                                ?>
                                            </strong> </td>
                                        <td ><strong>
                                                <?php
                                                if (!empty($v['LeaveEncashmentWorkflow']['encash_status'])) {
                                                    echo $status[$v['LeaveEncashmentWorkflow']['encash_status']];
                                                } else {
                                                    echo $status[2];
                                                }
                                                ?>
                                            </strong> </td>
                                        <td><strong>
                                                <?php
                                                if ($v['LeaveEncashmentWorkflow']['remark']) {
                                                    echo $v['LeaveEncashmentWorkflow']['remark']
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
                                <td colspan="4" style="display:none"> 
                                    <input type="hidden" value ="<?php echo $LeaveEncshid; ?>" name="data[LeaveEncashmentWorkflow][leave_encsh_id]"> 
                                    <input type="hidden" value ="<?php echo $LeaveEncshWorkflowid ?>" name="data[LeaveEncashmentWorkflow][id]">
                                </td>
                            <tr>
                                <?php $auth = $this->Session->read('Auth'); ?>
                                <?php
                                $deptcode = $this->Common->getemocodebydept($getlvl[0]['LeaveEncashmentWorkflow']['emp_code']);

                                $checklvlapp = $this->Common->findAppLevel($appId);
                                $countchecklvl = $checklvlapp - 1;
                                $lvl = count($getlvl) - 1;
                                if ($countchecklvl == $lvl) {
                                    $fwemplist = $this->Common->getHrList($auth['MyProfile']['emp_code']);
                                    if (array_key_exists($applierEmpCode, $fwemplist)) {
                                        unset($fwemplist[$applierEmpCode]);
                                    }
                                } else {
                                    $fwemplist = $this->Common->findLevel();
                                }
                                ?>
                            <tr class="hidehr"> 

                                <?php if ($lvl < $checklvlapp && $LeaveEncshStatus != 6) { ?>
                                    <td><input type="radio" class="flat" name="data[LeaveEncashmentWorkflow][type]" value="2" checked="checked" onclick="displaytype(this.value);" ><strong> Forward 
                                        </strong></td>

                                <?php } else { ?>
                                    <td>
                                        <input type="radio" class="flat" name="data[LeaveEncashmentWorkflow][type]" value="5" checked="checked" onclick="displaytype(this.value);" > <strong>
                                            <?php echo "Approve";
                                            ?>

                                        </strong>
                                    </td>
                                <?php } ?>

                                <td colspan="4">
                                    <input type="radio"  class=" flat" name="data[LeaveEncashmentWorkflow][type]" value="4" onclick="displaytype(this.value);"><strong> Reject </strong>
                                </td>

                            </tr>

                            <tr id="reject" style="display:none;">
                                <td align="right">Remark*:</td>
                                <td colspan="4">
                                    <table>
                                        <tr>
                                            <td>
                                                <textarea class="md-input form-control" name="data[LeaveEncashmentWorkflow][reject_remark]" id="rejcmnt" col="100" row="100"  ></textarea>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr> 



                            <?php
                            if ($lvl < $checklvlapp && $LeaveEncshStatus != 6) {
                                ?>
                                <tr id="forward" class="hidehr">          
                                    <td align="right">Forward :</td>
                                    <td colspan="5">
                                        <table>
                                            <tr>
                                                <td>
                                                    <?php echo $this->Form->input('LeaveEncashmentWorkflow.forward_emp_code', array('type' => 'select', 'style' => 'padding:6px; width:180px;', 'label' => false, 'options' => $fwemplist, 'class' => 'md-input form-control round_select', 'id' => 'fwlvlempcode', "data-md-selectize" => "data-md-selectize")); ?>
                                                </td>

                                                <td><textarea cols="md-input form-control" style="width: 373px; height: 123px;"  name="data[LeaveEncashmentWorkflow][forward_remark]" id="frwdcmnt" col="100" row="100" ></textarea>
                                                </td>
                                            </tr>
                                        </table>
                                </tr>
                            <?php } else { ?>


                                <?php
                                if ($checkForwardHr) {
                                    $hrList = $this->Common->getHrList();
                                    ?>
                                    <tr id="forward_hr_tr" class="hidehr">          
                                        <td align="right">Forward to HR :</td>
                                        <td colspan="3">
                                            <table>
                                                <tr>
                                                    <td>
                                                        <?php echo $this->Form->input('LeaveWorkflow.hr_emp_code', array('type' => 'select', 'label' => false, 'empty' => '- -Select- -', 'style' => 'padding:6px;', 'options' => $hrList, 'class' => 'md-input form-control round_select', 'id' => 'fwhrempcode')); ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><textarea  class="md-input" style="width: 373px; height: 123px;"  name="data[LeaveWorkflow][hr_forward_remark]" id="frwdcmnt" col="100" row="100" ></textarea>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>

                                <?php } else { ?>
                                    <tr id="approved_tr" class="hidehr">
                                        <td align="right">Remark :</td>
                                        <td colspan="5">
                                            <table>
                                                <tr>
                                                    <td>
                                                        <textarea class="md-input form-control" style="width: 373px; height: 123px;" name="data[LeaveEncashmentWorkflow][approve_remark]" id="appcmnt" col="100" row="100" ></textarea>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>



                                <?php } ?>
                            <?php } ?>
                        </tbody>
                    </table>
                    <?php echo $this->Form->submit('SAVE', array('onClick' => 'return checkSubmit()', 'name' => 'data[LeaveEncashmentWorkflow][save]', 'class' => 'md-btn md-btn-success')); ?>
                <?php } ?>     
                <?php $this->Form->end(); ?>
            </div>
        </div>
    </div>
</div>
</div>

<script type="text/javascript">
    function checkSubmit()
    {

        if ($('#forward').is(':visible'))
        {
            if ($('#fwlvlempcode').val() === '')
            {

                $("html, body").animate({scrollTop: 0}, "slow");
                $("#alerts").html("<div data-uk-alert='' class='uk-alert uk-alert-danger'><a class='uk-alert-close uk-close' href='#'></a>Select the employee name to whom you want to forward. !!!</div>").show();

                return false;
            }
        } else if ($('#revert').is(':visible'))
        {
            if ($('#revertempcode').val() === '')
            {

                $("html, body").animate({scrollTop: 0}, "slow");
                $("#alerts").html("<div data-uk-alert='' class='uk-alert uk-alert-danger'><a class='uk-alert-close uk-close' href='#'></a>Select the employee name to whom you want to revert. !!!</div>").show();
                return false;
            }
            if ($('#revcmnt').val() === '')
            {

                $("html, body").animate({scrollTop: 0}, "slow");
                $("#alerts").html("<div data-uk-alert='' class='uk-alert uk-alert-danger'><a class='uk-alert-close uk-close' href='#'></a>Enter Revert Remark. !!!</div>").show();
                return false;
            } else if ($('#revcmnt').val() !== '') {
                var length = $.trim($("#revcmnt").val()).length;
                if (length == 0) {
                    $("html, body").animate({scrollTop: 0}, "slow");
                    $("#alerts").html("<div data-uk-alert='' class='uk-alert uk-alert-danger'><a class='uk-alert-close uk-close' href='#'></a>Space not allowed in the Revert Remark. !!!</div>").show();
                    return false;
                }
            }
        } else if ($('#reject').is(':visible'))
        {

            if ($.trim($("#rejcmnt").val()) == "")
            {
                $("html, body").animate({scrollTop: 0}, "slow");
                $("#alerts").html("<div data-uk-alert='' class='uk-alert uk-alert-danger'><a class='uk-alert-close uk-close' href='#'></a>Enter Reject Comments. !!!</div>").show();
                return false;
            }
        } else {
            return true;
        }

    }
    function displaytype(a)
    {
        //var typeval = $("input[name='data[TravelWorkflow][type]']:checked").val();
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
</script>
