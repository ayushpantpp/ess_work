
<div id="page_content" role="main">
    <div id="page_content_inner">
        <h3 class="heading_b uk-margin-bottom">Forward Medical</h3>
        <?php //echo $flash = $this->Session->flash(); ?>
        <div id="alerts"></div>
        <div class="md-card">
            <div class="md-card-content large-padding">
                <?php
                //echo $this->Form->create('fwmedical', array('inputDefaults' => array('label' => false, 'div' => false, 'error' => array('wrap' => 'span', 'class' => 'uk-form-stacked')),'url' => array('controller' => 'medical', 'action' => 'medicalsaveinfo'), 'id' => 'medicalid', 'name' => 'medicalname')); ?>

                <div class="right_col" role="main">
                    <div class="">
                        <div class="page-title">
                            <div class="title_left">

                            </div>
                            <div class="title_right">
                                <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">

                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="row">
                            <div class="clearfix"></div>
                            <div class="col-md-12 col-sm-12 col-xs-12">

                                <div class="x_panel">
                                    <div class="x_content">
<?php 
echo $this->Form->create('fwmedical', array('inputDefaults' => array(
        'label' => false, 'div' => false, 'error' => array('wrap' => 'span', 'class' => 'my-error-class')),
    'url' => array('controller' => 'medical', 'action' => 'medicalsaveinfo'), 'id' => 'medicalid', 'name' => 'medicalname'));
if (is_numeric($medical_amt_id)) {	
 $getlvl = $this->Common->getmedicallevelbyid($medical_amt_id);
      //echo'<pre>';pr($getlvl);?>

    <?php $auth=$this->Session->read('Auth');?>     

    <?php $deptcode = $this->Common->getemocodebydept($getlvl[0]['MedicalWorkflow']['emp_code']);
    
    $fwemplist= $this->Common->findLevel();
    $checklvlapp = $this->Common->findAppLevel($appId);
    $lvl = count($getlvl) - 1;
   
    $deptcode = $this->Common->getemocodebydept($getlvl[0]['LtaWorkflow']['emp_code']);
    $checllvl = $this->Common->findcheckmulitpleLevel($appId,$deptcode);

    $checklvlapp = $this->Common->findAppLevel($appId);
    if($checllvl['WfMstAppMapLvl']['manager_approval'] == 1){

     $fwemplist = $this->Common->findDynamicLevel($checllvl['WfMstAppMapLvl']['wf_id'], 'Forward'); //    
     }
     else
     {
      $fwemplist= $this->Common->findLevel();
      }
    if(count($getlvl) > 2){
    $checkrevert = $this->Common->checkmedicalrevert($medicalid);     
   }            
               
      ?>
                                        <tr class="hidehr"> 
                                        <style>
                                            .flattravel12{

                                                opacity: 1 !important;
                                                margin-left: -9px !important;
                                            }
                                            .flattravel13{

                                                opacity: 1 !important;
                                                margin-left: -12px !important;
                                            }
                                        </style>


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
                                                    <td><strong><?php echo "Level-" . $i; ?></strong> </td>
                                                    <td ><strong><?php echo $this->Common->getempinfo($v['MedicalWorkflow']['emp_code']); ?> </strong> </td>
                                                    <td >
                                                        <strong>
                                                <?php
                                                if (!empty($v['MedicalWorkflow']['fw_date'])) {
                                                    echo date('d-M-Y', strtotime($v['MedicalWorkflow']['fw_date']));
                                                } else {
                                                    echo date('d-M-Y');
                                                }
                                                ?>
                                                        </strong></td>
                                                    <td >
                                                        <strong>
                                                <?php
                                                if (!empty($v['MedicalWorkflow']['status'])) {
                                                    echo $this->Common->findSatus($v['MedicalWorkflow']['status']);
                                                } else {
                                                    echo $this->Common->findSatus(2);
                                                }
                                                ?>
                                                        </strong> 
                                                    </td>
                                                    <td>
                                                        <strong>
                                                <?php
                                                if (!empty($v['MedicalWorkflow']['remark'])) {
                                                    echo $v['MedicalWorkflow']['remark'];
                                                    ?>
                                                <?php } else echo "N/A" ?>


                                                        </strong>
                                                    </td>
                                                </tr>

                                <?php $i++;  } ?>

                                <?php } ?>
                                <?php $auth = $this->Session->read('Auth'); ?>     
                                            <input type="hidden" value ="<?php echo $medical_amt_id; ?>" name="data[MedicalWorkflow][medical_bill_amount_id]"> 
                                            <input type="hidden" value ="<?php echo $medicalwfid; ?>" name="data[MedicalWorkflow][id]">
                                <?php
                                $deptcode = $this->Common->getemocodebydept($getlvl[0]['MedicalWorkflow']['emp_code']);

                                $fwemplist = $this->Common->findLevel();
                                $checklvlapp = $this->Common->findAppLevel($appId);
                                $lvl = count($getlvl) - 1;

                                if ($lvl == ($checllvl - 1)) {
                                    $fwemplist = $this->Common->findLevel($checllvl, 'Apply');
                                } else {
                                    $fwemplist = $this->Common->getHrList($auth['MyProfile']['emp_code']);
                                }
                                if (count($getlvl) > 2) {
                                    $checkrevert = $this->Common->checkmedicalrevert($medicalid);
                                }
                                ?>
                                            <tr class="hidehr"> 

    <?php if ($lvl < $checklvlapp && $medicalstatus != 6) { ?>
                                                <td>
                                                    <span class="icheck-inline">
                                                        <input type="radio" name="data[MedicalWorkflow][type]" value="2" class="" onclick="displaytype(this.value);" checked="checked" />
                                                        <label for="val_radio_male" class="inline-label">Forward</label>
                                                    </span>
                                                </td>
    <?php } else { ?>
                                                <td>
                                                    <span class="icheck-inline">
                                                        <input type="radio" name="data[MedicalWorkflow][type]" value="5" class="" onclick="displaytype(this.value);" checked="checked" />
                                                        <label for="val_radio_male" class="inline-label">Approve</label>
                                                    </span>                                       
                                                </td>
                                <?php } ?>

                                <?php
                                if ($checkrevert && $medicalstatus != 6) {
                                    $revertemplist = $this->Common->getMedicalRevertEmp($medicalid);
                                    ?>
                                                <td>
                                                    <span class="icheck-inline">
                                                        <input type="radio" name="data[MedicalWorkflow][type]" value="3" class="" onclick="displaytype(this.value);"/>
                                                        <label for="val_radio_male" class="inline-label">Revert</label>
                                                    </span>  

                                                </td>
    <?php } ?>
                                                <td><span class="icheck-inline">
                                                        <input type="radio" name="data[MedicalWorkflow][type]" value="4" class="" onclick="displaytype(this.value);"/>
                                                        <label for="val_radio_male" class="inline-label">Reject</label>
                                                    </span> 

                                                </td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                            </tr>

                                            <tr id="reject" style="display:none;"><br/>
                                            <td>Remark* :</td>
                                            <td colspan="5"><textarea style="width: 482px; height: 124px;" name="data[MedicalWorkflow][reject_remark]" id="cmnt" col="100" row="100" required="" class="md-input"> </textarea>
                                            </td>
                                            </tr> 
                            <?php
                            if ($checkrevert && $medicalstatus != 6) {
                                $revertemplist = $this->Common->getMedicalRevertEmp($medical);
                            ?>

                                            <tr id="revert" style="display:none;">
                                                <td align="right">Revert :</td><br/>
                                            <td colspan="2">
                                                <table>
                                                    <tr><td>
                                    <?php echo $this->Form->input('MedicalWorkflow.revert_emp_code', array('type' => 'select', 'label' => false, 'empty' => '- -Select- -', 'options' => $revertemplist, 'class' => 'md-input round_select', 'id' => 'revertempcode')); ?> </td></tr>
                                                    <tr><td><textarea style="width: 482px; height: 124px;" name="data[MedicalWorkflow][revert_remark]" id="revcmnt" col="100" row="100" class="md-input"></textarea></td></tr></table>
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
        <?php echo $this->Form->input('MedicalWorkflow.forward_emp_code', array('type' => 'select', 'label' => false, 'empty' => '- -Select- -', 'options' => $fwemplist, 'class' => 'md-input round_select', 'id' => 'fwlvlempcode')); ?>
                                                        </td>
                                                        <td>&nbsp; &nbsp;&nbsp;</td>
                                                        <td><textarea  name="data[MedicalWorkflow][forward_remark]" id="frwdcmnt" col="100" row="100"  class="md-input"> </textarea></td>
                                                    </tr>
                                                </table>
                                            </td>
                                            </tr>
                            <?php } else { ?>
                                <?php
                                if ($checkForwardHr) {

                                    $hrList = $this->Common->getHrList($auth['MyProfile']['emp_code']);
                                    ?>
                                            <tr id="forward_hr_tr" class="hidehr">					
                                                <td align="right">Forward to HR:</td>
                                                <td colspan="2">
                                                    <table>
                                                        <tr><td>
                                <?php echo $this->Form->input('TravelWorkflow.hr_emp_code', array('type' => 'select', 'label' => false, 'empty' => '- -Select- -', 'options' => $hrList, 'class' => 'md-input round_select', 'id' => 'fwhrempcode')); ?>
                                                            </td></tr><tr><td><textarea style="width: 482px; height: 124px;"  name="data[TravelWorkflow][hr_forward_remark]" id="frwdcmnt" col="100" row="100" class="md-input"> </textarea></td></tr>
                                                    </table></td>
                                            </tr>

                            <?php } else { ?>
                                            <tr id="approved_tr" class="hidehr">
                                                <td>Remark :</td>
                                                <td colspan="5"><textarea style="width: 482px; height: 124px;" name="data[MedicalWorkflow][approve_remark]" id="appcmnt" col="100" row="100" class="md-input"></textarea></td>
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
                                <?php echo $this->Form->submit('SAVE', array('onClick' => 'return checkSubmit()', 'name' => 'data[MedicalWorkflow][save]', 'class' => 'md-btn md-btn-success')); ?>                                
                                            </div>
                                        </div>

<?php } ?>     
<?php $this->Form->end(); ?>

                                    </div>
                                </div>
                            </div>
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
                            <!--                            <div class="navigation">
<?php echo $this->Paginator->counter(); ?> Pages
<?php echo $this->Paginator->prev('[<< Previous]', null, null, array('class' => 'disabled')); ?>
<?php echo $this->Paginator->numbers(); ?>
<?php echo $this->Paginator->next('[Next >>]', null, null, array('class' => 'disabled')); ?>
                                                        </div>-->

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

                                $("html, body").animate({scrollTop: 0}, "slow");
                                $("#alerts").html("<div data-uk-alert='' class='uk-alert uk-alert-danger'><a class='uk-alert-close uk-close' href='#'></a>Select the employee name to whom you want to forward.").show();

                                return false;
                            }
                        } else if ($('#revert').is(':visible'))
                        {
                            if ($("#revertempcode").val() === '')
                            {

                                $("html, body").animate({scrollTop: 0}, "slow");
                                $("#alerts").html("<div data-uk-alert='' class='uk-alert uk-alert-danger'><a class='uk-alert-close uk-close' href='#'></a>Select the employee name to whom you want to revert.</div>").show();
                                return false;
                            }
                            if ($("#revcmnt").val() === '')
                            {

                                $("html, body").animate({scrollTop: 0}, "slow");
                                $("#alerts").html("<div data-uk-alert='' class='uk-alert uk-alert-danger'><a class='uk-alert-close uk-close' href='#'></a>Enter Revert Remark.</div>").show();
                                return false;
                            }
                        } else if ($('#reject').is(':visible'))
                        {
                            if ($.trim($("#cmnt").val()) == "")
                            {
                                $("html, body").animate({scrollTop: 0}, "slow");
                                $("#alerts").html("<div data-uk-alert='' class='uk-alert uk-alert-danger'><a class='uk-alert-close uk-close' href='#'></a>Enter Reject Comment</div>").show();
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
                    $(document).ready(function () {
                        $('#alerts').hide();
                    });

                </script>
