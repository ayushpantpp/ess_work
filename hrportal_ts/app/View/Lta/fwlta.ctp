<?php

$auth = $this->Session->read('Auth'); ?>

<div id="page_content" role="main">
    <div id="page_content_inner">
        <h3 class="heading_b uk-margin-bottom">LTA Claim Form</h3>
        <?php echo $flash = $this->Session->flash(); ?>
        <div id="alerts"></div>
        <div class="md-card">
            <div class="md-card-content large-padding">

                <?php
                echo $this->Form->create('fwlta', array('inputDefaults' => array(
                        'label' => false, 'div' => false, 'error' => array('wrap' => 'span', 'class' => 'uk-form-stacked')),
                    'url' => array('controller' => 'lta', 'action' => 'ltasaveinfo'), 'id' => 'ltaid', 'name' => 'ltaname'));
                if (is_numeric($lta_amt_id)) {
                    $getlvl = $this->Common->getltalevelbyid($lta_amt_id);
                    //echo "<pre>";print_r($getlvl);echo "<pre>";
                    //die('hiii');
                    //echo'<pre>'; print_r($getlvl); die;?>


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
                                    ?>
                        <tr>
                            <td ><?php echo "Level-" . $i; ?></td>
                            <td ><?php echo $this->Common->getempinfo($v['LtaWorkflow']['emp_code']); ?></td>
                            <td >

                                            <?php
                                            if (!empty($v['LtaWorkflow']['fw_date'])) {
                                                echo date('d-M-Y', strtotime($v['LtaWorkflow']['fw_date']));
                                            } else {
                                                echo date('d-M-Y');
                                            }
                                            ?>
                            </td>
                            <td >

                                            <?php
                                            if (!empty($v['LtaWorkflow']['status'])) {
                                                echo $this->Common->findSatus($v['LtaWorkflow']['status']);
                                            } else {
                                                echo $this->Common->findSatus(2);
                                            }
                                            ?>

                            </td>
                            <td>
                                            <?php
                                            if (!empty($v['LtaWorkflow']['remark'])) {
                                                echo $v['LtaWorkflow']['remark'];
                                                ?>
                                            <?php } else echo "N/A" ?>



                            </td>
                        <tr>
                                        <?php
                                        $i++;
                                    }
                                    ?>
                        </tr>
    <?php } ?>
                        <tr>
                    <input type="hidden" value ="<?php echo $lta_amt_id; ?>" name="data[LtaWorkflow][lta_bill_amount_id]"> 
                    <input type="hidden" value ="<?php echo $ltawfid; ?>" name="data[LtaWorkflow][id]">
                                <?php
                                $deptcode = $this->Common->getemocodebydept($getlvl[0]['LtaWorkflow']['emp_code']);
                                $checllvl = $this->Common->findcheckmulitpleLevel($appId,$deptcode);
                                
                                $checklvlapp = $this->Common->findAppLevel($appId);
                                
                                $lvl=count($getlvl)-1;
                                
                                if($checllvl['WfMstAppMapLvl']['manager_approval'] == 1){
       
                                 $fwemplist = $this->Common->findDynamicLevel($checllvl['WfMstAppMapLvl']['wf_id'], 'Forward'); //    
                                 }
                                 else
                                 {
                                  $fwemplist= $this->Common->findLevel();
                                  }
    
                             
                                if (count($getlvl) > 2) {
                                    $checkrevert = $this->Common->checkltarevert($ltaid);
                                }
                                ?>
                    <tr class="hidehr">
     <?php if ($lvl < $checklvlapp && $ltastatus != 6) { ?>
                        <td>
                            <span class="icheck-inline">
                                <input type="radio" name="data[LtaWorkflow][type]" value="2" class="" onclick="displaytype(this.value);" checked="checked"/>
                                <label for="val_radio_male" class="inline-label">Forward</label>
                            </span>                                        
                        </td>
    <?php } else { ?>
                        <td>
                            <span class="icheck-inline">
                                <input type="radio" name="data[LtaWorkflow][type]" value="5" class="" onclick="displaytype(this.value);" checked="checked" />
                                <label for="val_radio_male" class="inline-label">Approve</label>
                            </span>
                        </td>
                                <?php } ?>

                                <?php
                                if ($checkrevert && $ltastatus != 6) {
                                    $revertemplist = $this->Common->getLtaRevertEmp($ltaid);
                                    ?>
                        <td>
                            <span class="icheck-inline">
                                <input type="radio" name="data[LtaWorkflow][type]" value="3" class="" onclick="displaytype(this.value);"/>
                                <label for="val_radio_male" class="inline-label">Revert</label>
                            </span>                                        
                        </td>
    <?php } ?>
                        <td>
                            <span class="icheck-inline">
                                <input type="radio" name="data[LtaWorkflow][type]" value="4" class="" onclick="displaytype(this.value);"/>
                                <label for="val_radio_male" class="inline-label">Reject</label>
                            </span>                               

                        </td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>

                    <tr id="reject" style="display:none;"><br/>
                    <td>Remark *:</td>
                    <td colspan="4">
                        <textarea style="width: 482px; height: 124px;" name="data[LtaWorkflow][reject_remark]" id="cmnt" col="100" row="100" > </textarea>
                    </td>
                    </tr> 
                        <?php
                        if ($checkrevert && $ltastatus != 6) {
                            $revertemplist = $this->Common->getLtaRevertEmp($lta);
                            ?>

                    <tr id="revert" style="display:none;">
                        <td align="right">Revert :</td><br/>
                    <td colspan="4">
                        <table>
                            <tr><td>
        <?php echo $this->Form->input('LtaWorkflow.revert_emp_code', array('type' => 'select', 'label' => false, 'empty' => '- -Select- -', 'options' => $revertemplist, 'class' => 'form-control s-form-item s-form-all', 'id' => 'revertempcode')); ?> </td></tr>
                            <tr><td><textarea name="data[LtaWorkflow][revert_remark]" id="revcmnt" col="100" row="100" class="form-control"></textarea></td></tr>
                        </table>
                    </td>
                    </tr>  
                        <?php } ?>			
                        <?php
                        if ($lvl < $checklvlapp) {
                            ?>
                    <tr id="forward" class="hidehr">					
                        <td align="right">Forward :</td><br/>
                    <td colspan="8">
                        <table>
                            <tr>
                                <td>
        <?php echo $this->Form->input('LtaWorkflow.forward_emp_code', array('type' => 'select', 'label' => false, 'empty' => '- -Select- -', 'options' => $fwemplist, 'class' => 'form-control s-form-item s-form-all', 'id' => 'fwlvlempcode')); ?>
                                </td>
                                <td>&nbsp; &nbsp;&nbsp;</td>
                                <td><textarea  name="data[LtaWorkflow][forward_remark]" id="frwdcmnt" col="100" row="100" > </textarea></td>
                            </tr>
                        </table>
                        </tr>
                            <?php } else { ?>
                                <?php
                                if ($checkForwardHr) {

                                    $hrList = $this->Common->getHrList($auth['MyProfile']['emp_code']);
                                    ?>
                    <tr id="forward_hr_tr" class="hidehr">					
                        <td align="right">Forward to HR:</td>
                        <td colspan="2"
                            <table>
                                <tr><td>
            <?php echo $this->Form->input('LtaWorkflow.hr_emp_code', array('type' => 'select', 'label' => false, 'empty' => '- -Select- -', 'options' => $hrList, 'class' => 'form-control s-form-item s-form-all', 'id' => 'fwhrempcode')); ?>
                                    </td></tr><tr><td><textarea  name="data[LtaWorkflow][hr_forward_remark]" id="frwdcmnt" col="100" row="100" > </textarea></td></tr>

                            </table></td>
                    </tr>

        <?php } else { ?>
                    <tr id="approved_tr" class="hidehr">
                        <td>Remark :</td>
                        <td colspan="4"><textarea style="width: 482px; height: 124px;" name="data[LtaWorkflow][approve_remark]" id="appcmnt" col="100" row="100" ></textarea></td>
                    </tr>
        <?php } ?>



                    <!--tr id="approved_tr" class="hidehr">
                            <td align="right">Approved :</td>
                            <td colspan="2"><textarea  name="data[ConveyenceWorkflow][approve_remark]" id="appcmnt" col="100" row="100" ></textarea></td>
                    </tr-->
    <?php } ?>


                    </tbody>
                </table>
                <div class="uk-grid">
                    <div class="uk-width-1-1">
                                <?php echo $this->Form->submit('SAVE', array('onClick' => 'return checkSubmit()', 'name' => 'data[LtaWorkflow][save]', 'class' => 'md-btn md-btn-success')); ?>                                
                    </div>
                </div>

                <br>

            </div>
            <?php } ?>     
<?php $this->Form->end(); ?>

            <div class="clear"></div>
        </div>
    </div>
</div>





<script type="text/javascript">
    function checkSubmit()
    {
        if ($('#forward').is(':visible'))
        {
            if ($("#fwlvlempcode").val() === '')
            {

                $("#alerts").html("Select the employee name to whom you want to forward.").show().delay(8000).fadeOut("slow");

                return false;
            }
        } else if ($('#revert').is(':visible'))
        {
            if ($("#revertempcode").val() === '')
            {

                $("#alerts").html("<div data-uk-alert='' class='uk-alert uk-alert-danger'><a class='uk-alert-close uk-close' href='#'></a>Select the employee name to whom you want to revert.</div>").show().delay(8000).fadeOut("slow");
                return false;
            }
            if ($("#revcmnt").val() === '')
            {

                $("#alerts").html("<div data-uk-alert='' class='uk-alert uk-alert-danger'><a class='uk-alert-close uk-close' href='#'></a>Enter Revert Remark.</div>").show().delay(8000).fadeOut("slow");
                return false;
            }
        } else if ($('#reject').is(':visible'))
        {
            
            if ($.trim($("#cmnt").val()) == "")
            {
                $("#alerts").html("<div data-uk-alert='' class='uk-alert uk-alert-danger'><a class='uk-alert-close uk-close' href='#'></a>Enter Reject Comment</div>").show().delay(8000).fadeOut("slow");
                return false;
            }
        } else {
            return true;
        }

    }
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
    $(document).ready(function () {
        $('#alerts').hide();
    });

</script>
