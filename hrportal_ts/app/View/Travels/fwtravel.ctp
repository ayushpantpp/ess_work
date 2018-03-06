<?php $auth = $this->Session->read('Auth');
$desg_code = $_SESSION['Auth']['MyProfile']['desg_code'];
?>      

<div id="page_content" role="main">
    <div id="page_content_inner">
        <h3 class="heading_b uk-margin-bottom">Travel Voucher</h3>
        <?php echo $flash = $this->Session->flash(); ?>
        <div id="alerts"></div>
        <div class="md-card">
            <div class="md-card-content large-padding">
                <div class="uk-overflow-container">
                        <?php
                        echo $this->Form->create('fwtravel', array('inputDefaults' => array(
                                 'error' => array('wrap' => 'span', 'class' => 'uk-form-stacked')),
                            'url' => array('controller' => 'travels', 'action' => 'travelwfsaveinfo'), 'id' => 'travelwfid', 'name' => 'travelwfname'));

                        if (is_numeric($travel)) {
                            $getlvl = $this->Common->gettravellevelbylvid($travel);

                            $getlevel = $this->Common->getTravellevel($travel);
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
                                            if ($i % 2 == 0)
                                                $class = "cont1";
                                            else
                                                $class = "cont";
                                            ?>
                                            <tr class="<?php echo $class; ?>">
                                                <td ><strong><?php echo "Level-" . $i; ?></strong> </td>
                                                <td ><strong><?php echo $this->Common->getempinfo($v['TravelWfLvl']['emp_code']); ?> </strong> </td>
                                                <td >
                                                    <strong>
                                                        <?php
                                                        if (!empty($v['TravelWfLvl']['fw_date'])) {
                                                            echo date('d-m-Y', strtotime($v['TravelWfLvl']['fw_date']));
                                                        } else {
                                                            echo date('d-m-Y');
                                                        }
                                                        ?>
                                                    </strong></td>
                                                <td >
                                                    <strong>
                                                        <?php
                                                        if (!empty($v['TravelWfLvl']['voucher_status'])) {
                                                            echo $this->Common->findSatus($v['TravelWfLvl']['voucher_status']);
                                                        } else {
                                                            echo $this->Common->findSatus(2);
                                                        }
                                                        ?>
                                                    </strong> 
                                                </td>
                                                <td>
                                                    <strong>
            <?php
            if (!empty($v['TravelWfLvl']['remark']) || $v['TravelWfLvl']['remark']!=NULL || $v['TravelWfLvl']['remark']!= "") {
                echo $v['TravelWfLvl']['remark'];
                ?>
                                                <?php } else echo "N/A" ?>


                                                    </strong>
                                                </td>
                                            <tr>
                                                <?php $i++;
                                            } ?>
                                        </tr>
                                        <?php } ?>
                                    
                                            <input type="hidden" value ="<?php echo $travel; ?>" name="data[TravelWfLvl][voucher_id]"> 
                                            <input type="hidden" value ="<?php echo $travelid; ?>" name="data[TravelWfLvl][id]">
                                    
                                        <?php
                                        $deptcode = $this->Common->getemocodebydept($getlvl[0]['TravelWfLvl']['emp_code']);

                                        //$fwemplist = $this->Common->findLevel();
                                        $checklvlapp = $this->Common->findAppLevel($appId);
                                        if($desg_code == 'PAR0000284'){
                                            $fwemplist = $this->Common->findLevelTravel('PAR0000284');
                                            $checklvlapp=2;
                                        }elseif($desg_code == 'PAR0000034'){
                                            $fwemplist = $this->Common->findLevelTravel('PAR0000034');
                                            $checklvlapp=1;
                                        }
//                                        echo "<pre>";
//                                        print_r($fwemplist);
//                                        echo $checklvlapp;
//                                        echo $desg_code;
//                                        die('herer');
                                        
                                        //$checklvlapp = $this->Common->findAppLevel($appId);
                                        $lvl = count($getlevel) - 1;
                                        if (count($getlevel) > 2) {
                                            $checkrevert = $this->Common->checktravelrevert($travel);
                                        }
                                        ?>
                                    <tr class="hidehr">             
                                <?php if ($lvl < $checklvlapp && $TravelStatus != 6) { ?>
                                    <td><input type="radio" class ="flat " checked="checked" name="data[TravelWorkflow][type]" value="2" onclick="displaytype(this.value);"><strong> Forward 
                                        </strong>
                                    </td>
                                    <?php } else { ?>
                                    <td>

        <?php if ($checkForwardHr) {
            ?>
                                            <label>
                                                <input type="radio"  name="data[TravelWorkflow][type]" value="6" class="flat" onclick="displaytype(this.value);"> <strong>

                                            </label>
            <?php echo "Forward to HR";
        } else {
            ?>

                                            <input type="radio" name="data[TravelWorkflow][type]" value="5" class="flat" checked="checked" onclick="displaytype(this.value);"> <strong>Approve</strong>

                                    <?php } ?>

                                    </td>
                                <?php } ?>

    <?php
    if ($checkrevert && $TravelStatus != 6) {
        $revertemplist = $this->Common->getTravelRevertEmp($travel);
        ?>
                                    <td colspan="0">
                                        <input type="radio"  name="data[TravelWorkflow][type]" value="3" class ="flat" onclick="displaytype(this.value);"><strong> Revert </strong>
                                    </td>
    <?php } ?>
                                    <td colspan="4">
                                    <input type="radio"  name="data[TravelWorkflow][type]" value="4" class ="flat" onclick="displaytype(this.value);"><strong> Reject </strong>
                                </td>

                                </tr>

                                <tr id="reject" style="display:none;"><br/>
                                <td align="right">Remark*:</td>
                                <td colspan="5">
                                    <textarea style="width: 265px; height: 88px;" name="data[TravelWorkflow][reject_remark]" id="cmnt" col="100" row="100" > </textarea>
                                </td>
                                </tr> 
    <?php
    if ($checkrevert && $TravelStatus != 6) {
        $revertemplist = $this->Common->getTravelRevertEmp($travel);
        ?>

                                    <tr id="revert" style="display:none;">
                                        <td align="right">Revert* :</td><br/>
                                    <td colspan="5">
                                        <table>
                                            <tr><td>
                                    <?php echo $this->Form->input('TravelWorkflow.revert_emp_code', array('type' => 'select', 'label' => false, 'options' => $revertemplist, 'class' => 'round_select', 'id' => 'revertempcode')); ?> </td></tr>
                                            <tr><td><textarea style="width: 265px; height: 88px;" name="data[TravelWorkflow][revert_remark]" id="revcmnt" col="100" row="100" ></textarea></td></tr></table>
                                    </td>
                                    </tr>  
    <?php } ?>			
    <?php
    if ($lvl < $checklvlapp) {
        ?>
                                    <tr id="forward" class="hidehr">					
                                    <td align="right">Forward :</td><br/>
                                    <td colspan="5">
                                        <table border="0" width="100%">
                                            <tr>
                                                <td width="20%">
                                                    <?php echo $this->Form->input('TravelWorkflow.forward_emp_code', array('type' => 'select', 'label' => false, 'options' => $fwemplist, 'style' => 'width: 200px; padding:5px;', 'id' => 'fwlvlempcode')); ?>
                                                </td>
                                                
                                                <td><textarea style="width: 265px; height: 88px;" name="data[TravelWorkflow][forward_remark]" id="frwdcmnt" > </textarea></td>
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
            <?php echo $this->Form->input('TravelWorkflow.hr_emp_code', array('type' => 'select', 'label' => false, 'empty' => '- -Select- -', 'options' => $hrList, 'class' => 'round_select', 'id' => 'fwhrempcode')); ?>
                                                        </td></tr><tr><td><textarea style="width: 265px; height: 88px;"  name="data[TravelWorkflow][hr_forward_remark]" id="frwdcmnt" col="100" row="100" > </textarea></td></tr>
                                                </table></td>
                                        </tr>

        <?php } else { ?>
                                        <tr id="approved_tr" class="hidehr">
                                            <td align="right">Remark :</td>
                                            <td colspan="5"><textarea style="width: 265px; height: 88px;" name="data[TravelWorkflow][approve_remark]" id="appcmnt" col="100" row="100" ></textarea></td>
                                        </tr>
        <?php } ?>



                                    <!--tr id="approved_tr" class="hidehr">
                                            <td align="right">Approved :</td>
                                            <td colspan="2"><textarea  name="data[ConveyenceWorkflow][approve_remark]" id="appcmnt" col="100" row="100" ></textarea></td>
                                    </tr-->
                        <?php } ?>


                                </tbody>
                            </table><?php echo $this->Form->submit('Proceed', array('onClick' => 'return checkSubmit()', 'name' => 'data[TravelWorkflow][save]', 'class' =>"md-btn md-btn-success")); ?></div>
            <?php } ?>     
            <?php $this->Form->end(); ?>
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
                $("#alerts").html("<div data-uk-alert='' class='uk-alert uk-alert-danger'><a class='uk-alert-close uk-close' href='#'></a>Select the employee name to whom you want to forward.").show();
                return false;
            }
        }
        else if ($('#revert').is(':visible'))
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
        }
        else if ($('#reject').is(':visible'))
        {

            if ($("#cmnt").val() === " ")
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
    $(document).ready(function () {
        $('#alerts').hide();
    });

</script>