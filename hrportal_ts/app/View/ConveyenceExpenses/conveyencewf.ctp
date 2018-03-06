<script>
    function Get_Details(emp_code)
    { 
        jQuery.ajax({
            url: '<?php echo $this->webroot ?>conveyenceexpenses/previousConveyence/'+emp_code,
            success: function (data) {
                //alert(data);
                jQuery('#empResponse').html(data);
            }
        });
    }

</script>

<div class="uk-width-medium-1-4">
    <div id="modal_overflow" class="uk-modal">
        <div class="uk-modal-dialog uk-modal-dialog-large">
            <button type="button" class="uk-modal-close uk-close"></button>            
            <div class="uk-overflow-container">
                <span id="empResponse" class="verflow container"></span>
            </div>          
        </div>
    </div>
</div>



<div id="page_content" role="main">
    <div id="page_content_inner"> 


        <h3 class="heading_b uk-margin-bottom">Conveyance Voucher Approval Workflow </h3>
        
        <?php echo $flash = $this->Session->flash(); 
        $auth = $this->Session->read('Auth'); ?>
        <div id="alerts"></div>
        <div class="md-card">
            <div class="md-card-content large-padding">
                
             <a data-uk-modal="{target:'#modal_overflow'}" class="uk-badge uk-badge-primary alignright" onclick="Get_Details(<?php echo $emp_code; ?>)" title="Click to View."> Previously applied Expense voucher</a>           
                        
                        <?php
                        echo $this->Form->create('fwconveyence', array('inputDefaults' => array('label' => false, 'div' => false, 'error' => array('wrap' => 'span', 'class' => 'my-error-class')),
                            'url' => array('controller' => 'conveyence_expenses', 'action' => 'conveyencewfsaveinfo'), 'id' => 'conveyencewfid', 'name' => 'conveyencewfname'));
                        if (is_numeric($conveyence)) {
                            $getlvl = $this->Common->getconveyencelevelbylvid($conveyence); //echo'<pre>';pr($getlvl);
                            $getlevel = $this->Common->getConveyencelevel($conveyence);
                            ?>
             <div class="uk-overflow-container">
                        <table class="uk-table uk-table-condensed">                            
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
                                                <td ><strong><?php echo "Level-" . $i; ?></strong> </td>
                                                <td ><strong><?php echo $this->Common->getempinfo($v['ConveyenceWorkflow']['emp_code']); ?> </strong> </td>
                                                <td >
                                                    <strong>
                                                        <?php
                                                        if (!empty($v['ConveyenceWorkflow']['fw_date'])) {
                                                            echo date('d-m-Y', strtotime($v['ConveyenceWorkflow']['fw_date']));
                                                        } else {
                                                            echo date('d-m-Y');
                                                        }
                                                        ?>
                                                    </strong></td>
                                                <td >
                                                    <strong>
                                                        <?php
                                                        if (!empty($v['ConveyenceWorkflow']['status'])) {
                                                            echo $this->Common->findSatus($v['ConveyenceWorkflow']['status']);
                                                        } else {
                                                            echo $this->Common->findSatus(2);
                                                        }
                                                        ?>
                                                    </strong> 
                                                </td>
                                                <td>
                                                    <strong>
                                                        <?php
                                                        if (!empty($v['ConveyenceWorkflow']['remark'])) {
                                                            echo $v['ConveyenceWorkflow']['remark'];
                                                            ?>
            <?php } else echo "N/A" ?>


                                                    </strong>
                                                </td>
                                            <tr>
            <?php $i++;
        } ?>
                                        </tr>
                                        <?php } ?>
                                     
                                            <input type="hidden" value ="<?php echo $conveyence; ?>" name="data[ConveyenceWorkflow][voucher_id]"> 
                                            <input type="hidden" value ="<?php echo $ConveyenceWorkflowid[0]['id']; ?>" name="data[ConveyenceWorkflow][id]">
                                        <?php
                                        $deptcode = $this->Common->getemocodebydept($getlvl[0]['ConveyenceWorkflow']['emp_code']);
                                        $fwemplist = $this->Common->findLevel();
										$checklvlapp = $this->Common->findAppLevel($appId);
										$checklvl = $this->Common->get_app_check($appId);
										$checkForwardHr = $this->Common->getHrCheck($appId);
										if($checklvl == 1){
										$fwemplist = $this->Common->getSepcList();
										}
                                        $lvl = count($getlevel) - 1;
                                        if (count($getlevel) > 2) {
                                            $checkrevert = $this->Common->checkconveyencerevert($conveyence);
                                        }
                                        ?>
                                    <tr class="hidehr"> 

                                        <?php if (count($getlevel)  < $checklvlapp && $conveyenceStatus != 6) { ?>
                                            <td><input type="radio"  class ="flat " name="data[ConveyenceWorkflow][type]" value="2" checked="checked" onclick="displaytype();"><strong> Forward</strong>
                                            </td>

                                            <?php } else { ?>
                                            <td>

                                                    <?php if ($checkForwardHr && count($getlevel)  <= $checklvlapp) { ?>
                                                    <input type="radio" class ="flat " name="data[ConveyenceWorkflow][type]" value="6" checked="checked" onclick="displaytype();"> <strong>
                                                            <?php echo "Forward to Accounts";
                                                        } else {
                                                            ?>
                                                        <input type="radio" class ="flat " name="data[ConveyenceWorkflow][type]" value="5" checked="checked" onclick="displaytype();"> <strong>
                                                <?php echo "Approve";
                                            } ?>
                                                    </strong>
                                            </td>
                                        <?php } ?>

                                        <?php if ($checkrevert && $conveyenceStatus != 6) { ?>
                                            <td>
                                                <input type="radio" class ="flat " name="data[ConveyenceWorkflow][type]" value="3" onclick="displaytype();"><strong> Revert </strong>
                                            </td>
                                        <?php } ?>
                                        <td>
                                            <input type="radio" class ="flat " name="data[ConveyenceWorkflow][type]" value="4" onclick="displaytype();"><strong> Reject </strong>
                                        </td>
                                        <td></td>
                                        <td></td>
                                        <td></td>   
                                    </tr>

                                    <tr id="reject" style="display:none;">
                                        <td align="right">Reject* :</td>
                                        <td colspan="5">
                                            <textarea style="width: 253px; height: 93px;"  name="data[ConveyenceWorkflow][reject_remark]" id="rejectcmnt" col="100" row="100" > </textarea>
                                        </td>
                                    </tr> 
    <?php
    if ($checkrevert && $conveyenceStatus != 6) {
        $revertemplist = $this->Common->getConveyenceRevertEmp($conveyence);
        ?>

                                        <tr id="revert" style="display:none;">
                                            <td align="right">Revert*:</td>
                                            <td colspan="2">
                                                <table>
                                                    <tr>
                                                        <td><?php echo $this->Form->input('ConveyenceWorkflow.revert_emp_code', array('type' => 'select', 'label' => false, 'options' => $revertemplist, 'class' => 'round_select', 'id' => 'revertempcode')); ?> </td>
                                                        <td><textarea style="width: 253px; height: 93px;"  name="data[ConveyenceWorkflow][revert_remark]" id="revcmnt" col="100" row="100" ></textarea></td>
                                                    </tr></table>
                                            </td>
                                        </tr> 

    <?php } ?>			
    <?php 
    if (count($getlevel) < $checklvlapp && $conveyenceStatus != 6) {
        ?>  
                                        <tr id="forward" class="hidehr">					
                                            
                                            <td colspan="5"><br>
                                                <div class="uk-grid" data-uk-grid-margin>
                                                    <div class="uk-width-medium-1-6">
                                                        <div class="parsley-row alignright">
                                                            <label style="text-aligh:right">Forward :</label>
                                                        </div>
                                                    </div>
                                                    <div class="uk-width-medium-1-5">
                                                        <div class="parsley-row">
                                                            <?php echo $this->Form->input('ConveyenceWorkflow.forward_emp_code', array('type' => 'select','style' => 'width:177px; height:30px;', 'label' => false, 'options' => $fwemplist,'id' => 'fwlvlempcode')); ?>
                                                            &nbsp;
                                                            <textarea style="width: 253px; height: 93px;" name="data[ConveyenceWorkflow][forward_remark]" id="frwdcmnt" col="100" row="100" > </textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                
                                                
                                        </tr>
    <?php } else { ?>

                                                            <?php if($checkForwardHr && count($getlevel)  <= $checklvlapp) {
                                                               $hrList = $this->Common->getAccList($auth['MyProfile']['emp_code']);
                                                                ?>
                                            <tr id="forward_hr_tr" class="hidehr">					
                                                <td align="right">Forward to Accounts :</td>
                                                <td colspan="2">
                                                    <table>
                                                        <tr><td>
            <?php echo $this->Form->input('ConveyenceWorkflow.hr_emp_code', array('type' => 'select', 'label' => false, 'empty' => '- -Select- -', 'options' => $hrList, 'class' => 'round_select', 'id' => 'fwhrempcode')); ?>
                                                            </td></tr><tr><td><textarea style="width: 253px; height: 93px;"  name="data[ConveyenceWorkflow][hr_forward_remark]" id="frwdcmnt" col="100" row="100" > </textarea></td></tr>
                                                    </table></td>
                                            </tr>

        <?php } else { ?>
                                            <tr id="approved_tr" class="hidehr">
                                                <td align="right">Remark :</td>
                                                <td colspan="2"><textarea style="width: 253px; height: 93px;"  name="data[ConveyenceWorkflow][approve_remark]" id="appcmnt" col="100" row="100" ></textarea></td>
                                            </tr>
                                        <?php } ?>

    <?php } ?>

                                </tbody>
                            </table>
                 </div><br><input type="submit" class="md-btn md-btn-success" value="Save " onclick=" return checkSubmit();
            ">  
            <?php } ?>     
            <?php $this->Form->end(); ?>

                </div>
            </div>
        </div>
    </div>
</div>
</div>
<?php $this->Form->end(); ?>



<script type="text/javascript">

    function checkSubmit()
    {
        if ($('#forward').is(':visible'))
        {
            if ($("#fwlvlempcode").val() == '')
            {
                $("html, body").animate({scrollTop: 0}, "slow");
                $("#alerts").html("<div data-uk-alert='' class='uk-alert uk-alert-danger'><a class='uk-alert-close uk-close' href='#'></a>Select the employee name to whom you want to Forward.").show();
                return false;
            }
        }
        else if ($('#revert').is(':visible'))
        {
            if ($("#revertempcode").val() == "")
            {
                $("html, body").animate({scrollTop: 0}, "slow");
                $("#alerts").html("<div data-uk-alert='' class='uk-alert uk-alert-danger'><a class='uk-alert-close uk-close' href='#'></a>Select the employee name to whom you want to revert.").show();

                return false;
            }
            if ($("#revcmnt").val() == "")
            {
                $("html, body").animate({scrollTop: 0}, "slow");
                $("#alerts").html("<div data-uk-alert='' class='uk-alert uk-alert-danger'><a class='uk-alert-close uk-close' href='#'></a>Enter Revert Remark.").show();
                return false;
            }
        }
        else if ($('#reject').is(':visible'))
        {
            var rej = $('#rejectcmnt').val();
            
            if (rej === " ")
            {
                $("html, body").animate({scrollTop: 0}, "slow");
                $("#alerts").html("<div data-uk-alert='' class='uk-alert uk-alert-danger'><a class='uk-alert-close uk-close' href='#'></a>Enter Reject Remark.").show();

                return false;
            }
        }
        else
        {
            return true;
        }


    }

    function displaytype()
    {
        var typeval = $("input[name='data[ConveyenceWorkflow][type]']:checked").val();
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
