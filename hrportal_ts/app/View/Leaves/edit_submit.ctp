<?php 
$comp_code = $_SESSION['Auth']['MyProfile']['comp_code'];
$comp_code = $this->Common->findEmpCompany($emp_code);
$fwemplist = $this->Common->findLevel($emp_code,$comp_code);
$auth = $this->Session->read('Auth');
?>
<div id="page_content">
    <div id="page_content_inner">
        <?php echo $flash = $this->Session->flash(); ?>
        <div id="alerts"></div>
        <div class="md-card">  
            <div class="md-card-content large-padding">
                <?php
                echo $this->form->create('Leave', array('url' => '', 'action' => 'editsaveinfo', 'inputDefaults' => array('label' => false, 'div' => false, 'error' => array('wrap' => 'span', 'class' => 'uk-form-stacked'))));
                echo $this->form->input('leaveid', array('value' => $empleavedetailfirst['LeaveDetail']['leave_id'], 'type' => 'hidden'));
                ?>
                
                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-1-2">
                        <div class="parsley-row">
                            <?php echo $this->form->input('user_name', array('label' => "Employee Name", 'value' => $this->Common->getempname($empleavedetailfirst['LeaveDetail']['emp_code']), 'type' => 'text', 'class' => "md-input", 'required' => true, 'id' => 'first_name', 'readonly' => 'readonly')); ?>
                        </div>
                    </div> 
                    <div class="uk-width-medium-1-2">
                        <div class="parsley-row">
                            <label for="department">Employee Department <span class="req">*</span></label>
                                <?php   $department=$this->Common->getdepartmentbyid($auth['MyProfile']['dept_code']);?>
                                <?php echo $this->form->input('dept_name', array('label'=>false, 'type' => 'text', 'readonly' => true, 'value' =>$department,'class' => "md-input",'required'=>true,'id'=>'first_name')); ?>
                        </div>
                    </div>
                </div>
                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-1-2">
                        <div class="parsley-row">
                            <label for="resp" class="fixed">Employee Designation <span class="req fixed">*</span></label>
                            <?php 
                            $desgName =$this->Common->findDesignationName($auth['MyProfile']['desg_code'],$auth['MyProfile']['comp_code']);
                            echo $this->form->input('desg_name', array('label'=>false, 'type' => 'text', 'readonly' => 'readonly', 'value' => $desgName,'class' => "md-input",'required'=>true,'id'=>'first_name')); 
                            ?>                
                        </div>
                    </div>
                    <div class="uk-width-medium-1-2">
                        <div class="parsley-row">
                            <?php
                            $v = $this->Common->option_attribute_name($gender);
                            if ($opemp < 2) {
                              //  $leave_name['PAR0000391'] = 'OPTIONAL LEAVE';
                            }
                            if ($v[$gender] == 'FEMALE') {
                             //   $leave_name['PAR0000066'] = 'MATERNITY LEAVE';
                            }
                           
                            asort($leave_name);
                            ?>
                            <?php echo $this->form->input('Leave.leave_code', array('class' => "md-input", 'label' => "Leave Type", 'type' => 'select', 'options' => array_map('strtoupper', $leave_name), 'default' => $empleavedetailfirst['LeaveDetail']['leave_code'], 'id' => 'leave')); ?>
                        </div>
                    </div>
                </div>
                <div class="uk-grid" data-uk-grid-margin>

                    <div class="uk-width-medium-1-2">
                        <label>Start Date</label>
                        <div class="parsley-row">
                            <?php echo $this->form->input('Leave.dt_start_date', array('label' => "", 'class' => "md-input", 'type' => 'text', 'id' => 'startdate', 'readonly' => true, 'value' => date('d-m-Y', strtotime($empleavedetailfirst['MstEmpLeave']['start_date'])))); ?>
                        </div>
                    </div>
                     <div class="uk-width-medium-1-2" id = "enddate_div">
                        <label>End Date<span class="required">*</span></label>
                        <div class="parsley-row"> 
                            <?php if ($empleavedetaillast == 'N') { ?>
                                <?php echo $this->form->input('dt_end_date', array('label' => false, 'class' => "md-input", 'type' => 'text', 'id' => 'enddate', 'readonly' => true, 'value' => date('d-m-Y', strtotime($empleavedetailfirst['MstEmpLeave']['end_date'])))); ?> 
                            <?php } else { ?>
                                <?php echo $this->form->input('dt_end_date', array('label' => false, 'class' => "md-input", 'type' => 'text', 'id' => 'enddate', 'readonly' => true, 'value' => date('d-m-Y', strtotime($empleavedetaillast['MstEmpLeave']['end_date'])))); ?>
                            <?php } ?>  

                        </div>
                    </div>
                    <div class="uk-width-medium-1-2" id = "short_leave_type_div">
                        <div class="uk-width-medium-1-1">
                            <div class="parsley-row">
                            <?php
                            echo $this->form->input('short_leave_type', array('class' => "md-input", 'label' => false, 'type' => 'select', 'options' => $shrt_leave_type, 'default' => $empleavedetailfirst['LeaveDetail']['shrt_type'], 'id' => 'short_leave_type', 'style' => 'display:none;'));
                           
                            ?>
                            </div>
                        </div>
                        </div>
                </div>

                <div class="uk-grid" data-uk-grid-margin id="duration_div_start">
                    <div class="uk-width-medium-1-2">
                        <label>Start Duration<span class="required">*</span></label>
                        <div class="uk-width-medium-1-1">
                            <div class="parsley-row">
                                <input type="radio" class="iCheck-helper"  name="ch_st_daylength" id="ch_st_daylengthf" value="F" checked="checked"  >
                                <label for="ch_st_daylengthf" class="inline-label">Full Day</label>
                                <input type="radio" class="flat" name="ch_st_daylength" id="ch_st_daylengthh" <?php
                                if ($empleavedetailfirst['LeaveDetail']['hlfday_leave_chk'] == 'Y') {
                                    echo 'checked="checked"';
                                }
                                ?> value="H">
                                <label id='halflabelstart' for="ch_st_daylengthh" class="inline-label">Half Day</label>
                            </div>
                        </div>

                        <div class="uk-width-medium-1-1">
                            <div class="parsley-row">
                                <?php
                                if ($empleavedetailfirst['LeaveDetail']['hlfday_leave_chk'] == 'Y') {
                                    echo $this->form->input('ch_st_dayhalf', array('class' => "md-input", 'label' => false, 'type' => 'select', 'options' => array('F' => "First half", 'S' => "Second half"), 'default' => $empleavedetailfirst['LeaveDetail']['half_type'], 'id' => 'st_half_type_div'));
                                } else {
                                    echo $this->form->input('ch_st_dayhalf', array('class' => "md-input", 'label' => false, 'type' => 'select', 'options' => array('F' => "First half", 'S' => "Second half"), 'default' => 'F', 'id' => 'st_half_type_div', 'style' => 'display:none;'));
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="uk-width-medium-1-2" id ="duration_div_end">
                        <label>End Duration<span class="required">*</span></label>
                        <div class="uk-width-medium-1-1">
                            <input type="radio" class="flat" name="ch_ed_daylength" id="ch_ed_daylengthf" value="F" checked="checked"> 
                            <label  for="ch_st_daylengthf" class="inline-label">Full Day</label>

                            <?php if ($empleavedetaillast == 'N') { ?> 
                                <input type="radio" class="flat" name="ch_ed_daylength" id="ch_ed_daylengthh" value="H"> 

                            <?php } else { ?>
                                <input type="radio" class="flat" name="ch_ed_daylength" id="ch_ed_daylengthh" <?php
                                if ($empleavedetaillast['LeaveDetail']['hlfday_leave_chk'] == 'Y') {
                                    echo 'checked="checked"';
                                }
                                ?>value="H"> 
                                   <?php } ?> 
                            <label id='halflabelend' for="ch_st_daylengthh" class="inline-label">Half Day</label>
                        </div>
                        <div class="uk-width-medium-1-1">
                            <div class="parsley-row">
                                <?php
                                if ($empleavedetaillast == 'N') {
                                    echo $this->form->input('ch_ed_dayhalf', array('class' => "md-input", 'label' => false, 'type' => 'select', 'options' => array('F' => "First half", 'S' => "Second half"), 'default' => 'F', 'id' => 'ed_half_type_div', 'style' => 'display:none;'));
                                } else {
                                    if ($empleavedetaillast['LeaveDetail']['half_type'] == 'Y')
                                        echo $this->form->input('ch_ed_dayhalf', array('class' => "md-input", 'label' => false, 'type' => 'select', 'options' => array('F' => "First half", 'S' => "Second half"), 'default' => $empleavedetaillast['LeaveDetail']['half_type'], 'id' => 'ed_half_type_div'));
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="uk-grid" data-uk-grid-margin id="reason_div">
                    <div class="uk-width-medium-1-2">
                        <label>Total Leaves<span class="required">*</span></label>
                        <div class="uk-width-medium-1-1">
                            <?php echo $this->form->input('nu_tot_leaves', array('label' => false, 'class' => "md-input", 'type' => 'text', 'readonly' => 'readonly', 'id' => 'total_leave', 'value' => $empleavedetailfirst['MstEmpLeave']['total_leave'])); ?>
                        </div>
                    </div>

                    <div class="uk-width-medium-1-2" id = "reason_div">
                        <div class="parsley-row">
                            <label for="message">Reason (20 chars min, 150 max)*</label>
                            <?php echo $this->form->textarea('vc_leave_reason', array('label' => "Reason *", 'class' => "md-input", "data-parsley-minlength" => "20", 'maxlength' => "145", "data-parsley-validation-threshold" => "10", "id" => "LeaveVcLeaveReason", "data-parsley-minlength-message" => "Come on! You need to enter at least a 20 caracters long comment..", 'value' => $empleavedetailfirst['LeaveDetail']['leave_reason'])); ?>
                        </div>
                    </div>
                </div>
                

                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-1-2">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="Message" id="image" style = "display:none">Medical Certificate <span class="required">*</span> </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <input type="file" name="leave_image" id="leave_image" style = "display:none" />
                        </div>


                    </div>
                </div>
                
                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-1-3">
                        <div class="parsley-row">
                            <input type="hidden" value ="<?php echo $leave; ?>" name="data[LeaveWorkflow][leave_id]"> 
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">To be approved by:*</label>
                            <?php echo $this->Form->input('LeaveWorkflow.emp_code', array('type' => 'select', 'label' => "", 'options' => $fwemplist, 'class' => 'md-input', 'id' => 'fwlvempcode', "data-md-selectize" => "data-md-selectize")); ?>
                        </div>
                    </div>
                </div>

                <div class="uk-grid" data-uk-grid-margin>     

                    <div class="uk-grid">
                        <div class="uk-width-1-1 uk-margin-top">                            
                            <input type="submit" class="md-btn md-btn-primary" value="Apply" name="update_leave" onclick="return CheckLeaveCount();">
                            <a class="md-btn md-btn-danger" href="<?php echo $this->Html->url('/leaves/view') ?>">Cancel</a>
                        </div>
                    </div>
                </div>
                </form>
                <div class="uk-grid uk-margin-medium-top uk-margin-large-bottom" data-uk-grid-margin>
                    <div class="uk-width-large-1-1">
                        <div class="uk-overflow-container uk-margin-bottom">
                            <table class="uk-table uk-table-striped uk-text-nowrap">



                                <thead>
                                    <tr class="headings">

                                        <th class="column-title">Leave Type </th>
                                        <th class="column-title">Total Leave</th>
                                        <th class="column-title">Balance Leave</th>
                                        <th class="column-title">Approved Leaves</th>
                                        <th class="column-title">Applied Leaves</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 0;

                                    foreach ($leaveType as $type) {
                                        ?>  
                                        <?php
                                        if ($i % 2 == 0)
                                            $class = "cont1";
                                        else
                                            $class = "cont";
                                        $bal = $type['MstEmpLeaveAllot']['leave_bal'];
                                        $total = $type['MstEmpLeaveAllot']['leave_op'];
                                        $applied = $this->Common->countAppliedLeave($type['MstEmpLeaveAllot']['emp_code'], $type['type']['id']);
                                        ?>
                                        <tr class="<?php echo $class; ?>">
                                            <th ><?php echo $type['type']['name']; ?></th>
                                            <th><?php echo $total ?></th>
                                            <td id="bal_leave_<?php echo $type['type']['id'] ?>"><?php echo $bal; ?></td>
                                            <td><?php echo $applied; ?></td>
                                            <td id="pending_leave_<?php echo $type['type']['id'] ?>">
                                                <?php echo $this->Common->countPendingLeave($type['MstEmpLeaveAllot']['emp_code'], $type['type']['id']); ?> </td></tr>
                                                <?php
                                                $i++;
                                            }
                                            ?>

                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>



            </div>
        </div>
    </div>
</div>

<script type="text/javascript">

    /** Days to be disabled as an array */
    $(function () {
        $("#startdate").datepicker({
            dateFormat: 'dd-mm-yy',
            changeMonth: true,
            changeYear: true,
            minDate: '<?php echo date('d-m-Y', strtotime('01-Jan-2018')); ?>',
            onSelect: function (selected) {
                jQuery("#enddate").datepicker("option", "minDate", selected);
                var diff = dateDiff(jQuery('#startdate').datepicker("getDate"));
                jQuery('#enddate').datepicker("getDate");

                if (jQuery('#enddate').val() !== "") {
                    var diff = dateDiff(jQuery('#startdate').datepicker("getDate"),
                            jQuery('#enddate').datepicker("getDate"));
                }

            }
        });
    });

    $(function () {
        $("#enddate").datepicker({
            dateFormat: 'dd-mm-yy',
            changeMonth: true,
            changeYear: true,
            minDate: '<?php echo date('d-m-Y', strtotime('01-Jan-2018')); ?>',
            onSelect: function (selected) {
                jQuery("#startdate").datepicker("option", "maxDate", selected);
                var medical = jQuery('#leave').val();
                jQuery.ajax({
                    url: '<?php echo $this->webroot ?>leaves/getCode/' + medical,
                    success: function (data) {
                        //alert(data);
                        var obj = jQuery.parseJSON(data);
                        jQuery.each(obj, function (key, value) {
                            var medical = jQuery('#leave').val();
                            var tot = jQuery('#total_leave').val();
                            //alert(tot);alert(medical);

                            var leave_image = jQuery('#leave_image').val();
                            if (tot > value.LeaveConfiguration.file_upload_no) {
                                jQuery('#leave_image,#image').show();
                                if (leave_image === '') {
                                    jQuery("html, body").animate({scrollTop: 0}, "slow");
                                    jQuery("#alerts").html("<div data-uk-alert='' class='uk-alert uk-alert-danger'><a class='uk-alert-close uk-close' href='#'></a>Please Upload Medical Certificate").show();
                                    jQuery("html, body").animate({scrollTop: 0}, "slow");
                                    return false;
                                } else {
                                    //alert('ecit');
                                    jQuery('#leave_image,#image').hide();
                                }

                            } else {
                                jQuery('#leave_image,#image').hide();
                            }

                        });
                    }

                });
                var diff = dateDiff(jQuery('#startdate').datepicker("getDate"),
                        jQuery('#enddate').datepicker("getDate"));

            }
        });
    });


    jQuery('#startdate').change(function () {
        if (jQuery('#enddate') != "") {
            var diff = dateDiff(jQuery('#startdate').datepicker("getDate"),
                    jQuery('#enddate').datepicker("getDate"));
        }

    });

</script>
<script type="text/javascript" >

    jQuery(document).keydown(function (e) {
        if (e.keyCode == 90 && e.altKey) {
            history.go(-1);
        }

    });

    jQuery('input[name=ch_st_daylength]').change(function () {
        dateDiff(jQuery('#startdate').datepicker("getDate"), jQuery('#enddate').datepicker("getDate"))
    });
    jQuery('input[name=ch_ed_daylength]').change(function () {

        dateDiff(jQuery('#startdate').datepicker("getDate"), jQuery('#enddate').datepicker("getDate"))
    });
</script>
<script>
    function dateDiff(startDate, endDate) {
        //  alert('ahah');
        var difdate = 0;
        var difdate1 = 0;
        if (jQuery("#startdate").val() == '' && jQuery("#enddate").val() == '') {

            $("html, body").animate({scrollTop: 0}, "slow");
            $("#alerts").html("<div data-uk-alert='' class='uk-alert uk-alert-danger'><a class='uk-alert-close uk-close' href='#'></a>Please select start date and end date").show();
            jQuery('#total_leave').val('');
            return false;
        }
        if (jQuery("#startdate").val() == '') {

            $("html, body").animate({scrollTop: 0}, "slow");
            $("#alerts").html("<div data-uk-alert='' class='uk-alert uk-alert-danger'><a class='uk-alert-close uk-close' href='#'></a>Please select Start Date").show();
            jQuery('#total_leave').val('');
            return false;
        }
        if (endDate && startDate) //make sure we don't call .getTime() on a null
            difdate = (endDate.getTime() - startDate.getTime()) / (1000 * 60 * 60 * 24);
        if (jQuery('#enddate').val() != "") {
            difdate1 = difdate + 1;
            difdate_1 = difdate + 1;
        }
        var ed_date = jQuery("input[name='ch_ed_daylength']:checked").val();
        var st_date = jQuery("input[name='ch_st_daylength']:checked").val();
        if (ed_date == 'H' && st_date != 'H') {
            difdate1 = difdate1 - 0.5;
        }
        if (st_date == 'H' && ed_date != 'H') {
            difdate1 = difdate1 - 0.5;
        }
        if (st_date == 'H' && ed_date == 'H') {
            difdate1 = difdate1 - 1.0;
            if (difdate1 == 0) {
                $("html, body").animate({scrollTop: 0}, "slow");
                $('#ed_half_type_div').hide();
                $('#st_half_type_div').hide();
                $('#ch_st_daylengthf').prop('checked', true);
                $('#ch_ed_daylengthf').prop('checked', true);
                jQuery('#total_leave').val(difdate_1);
                $("#alerts").html("<div data-uk-alert='' class='uk-alert uk-alert-danger'><a class='uk-alert-close uk-close' href='#'></a>You cannot claim Two half day for Same Date").show();
            }
                jQuery('#total_leave').val(difdate1);
        

        } else {
            jQuery('#vc_date_diff').val(difdate1);
            if (difdate < 0) {
                $("html, body").animate({scrollTop: 0}, "slow");
                $("#alerts").html("<div data-uk-alert='' class='uk-alert uk-alert-danger'><a class='uk-alert-close uk-close' href='#'></a>Total Days cannot be less than 0! Please Enter Proper Dates").show();
                jQuery('#total_leave').val('');
                return false;
            } else {
                jQuery('#total_leave').val(difdate1);
            }
        }
        var leavetyp = $("#leave").val();





        //	jQuery.ajax({
        //        url: '<?php echo $this->webroot ?>leaves/getleaveConfi/',
        //        
        //        success: function(data){
        var w = <?php echo json_encode($week_offs); ?>;
        console.log(w);
        var listweek = Object.keys(w).map(function (k) {
            return w[k]
        });
        if (jQuery.inArray(leavetyp, listweek) !== -1) {
            var all_dates = getDates(startDate, endDate);
            jQuery(all_dates).each(function (e, v) {
                //check holidays
                var holidays = <?php echo json_encode($holidays); ?>;
                var dt = v.getFullYear() + '-' + ("0" + (v.getMonth() + 1)).slice(-2) + '-' + ("0" + v.getDate()).slice(-2);
                var hol = Object.keys(holidays).map(function (k) {
                    return holidays[k]
                });
                console.log(hol);
                if (jQuery.inArray(dt, hol) !== -1) {
                    jQuery('#total_leave').val(jQuery('#total_leave').val() - 1);
                }
                //check week holidays
                var week_holidays = <?php echo json_encode($week_holidays); ?>;
                var dtw = v.getFullYear() + '-' + ("0" + (v.getMonth() + 1)).slice(-2) + '-' + ("0" + v.getDate()).slice(-2);
                var holw = Object.keys(week_holidays).map(function (k) {
                    return week_holidays[k]
                });
                console.log(holw);
                if (jQuery.inArray(dtw, holw) !== -1) {
                    jQuery('#total_leave').val(jQuery('#total_leave').val() - 1);
                }

            });
        }
        if ((leavetyp !== 'PAR0000391')) {
            //substract leaves on the basis of holidays

            var all_dates = getDates(startDate, endDate);
            // alert(startDate);
            var i = 0;
            jQuery(all_dates).each(function (e, v) {
                //check holidays
                var dt = v.getFullYear() + '-' + ("0" + (v.getMonth() + 1)).slice(-2) + '-' + ("0" + v.getDate()).slice(-2);
                var optionalholidays = <?php echo json_encode($optionarray); ?>;

                var ophol = Object.keys(optionalholidays).map(function (k) {
                    return optionalholidays[k]
                });
                if (jQuery.inArray(dt, ophol) !== -1) {
                    $('#include_op_div').show();
                }


            });

        }

    }
    $(window).load(function () {
        var type = $('#leave').val();
        var tot = $('#total_leave').val();
<<<<<<< HEAD
         if(type == 'PAR0000112'){
=======
         if(type == 'PAR0000296'){
>>>>>>> 6214f620888c1d38e4edf01ce0ccff0b7532319a
            jQuery('#duration_div_end,#duration_div_start,#reason_div,#enddate,#total_leave,#total_leave_div,#enddate_div').hide();
            jQuery('#startdate,#enddate').val(jQuery('#startdate').val());
            jQuery('#short_leave_type,#short_leave_type_div').show();
            dateDiff(jQuery('#startdate').datepicker("getDate"), jQuery('#enddate').datepicker("getDate"));
            var st__date = jQuery('#startdate').val();
            jQuery.ajax({
            url: '<?php echo $this->webroot ?>leaves/getshortleavedetail/' + st__date,
            success: function (data) {
                }
            });
            
        } else {
            jQuery('#duration_div_end,#duration_div_start,#reason_div,#enddate,#total_leave,#total_leave_div,#enddate_div').show();
            jQuery('#short_leave_type,#short_leave_type_div').hide();
        }
        jQuery.ajax({
            url: '<?php echo $this->webroot ?>leaves/getleaveConfi/',
            success: function (data) {

                var obj = jQuery.parseJSON(data);
                $.each(obj, function (key, value) {

                    if (value.LeaveConfiguration.leave_code == type && value.LeaveConfiguration.half_day_chk == 0) {
                        $('#leave_image,#image').hide();
                        $('#ch_st_daylengthh').parent().show();
                        $('#ch_ed_daylengthh').parent().show();
                    } else if (value.LeaveConfiguration.leave_code == type && value.LeaveConfiguration.half_day_chk == 1) {
                        if (value.LeaveConfiguration.file_upload == 1)
                        {
                            if (tot > value.LeaveConfiguration.file_upload_no) {
                                $('#leave_image,#image').show();
                            } else {
                                $('#leave_image,#image').hide();
                            }

                            $('#ch_st_daylengthf').find('.iCheck-helper').trigger('click');
                            $('#ch_ed_daylengthf').find('.iCheck-helper').trigger('click');
                            $('#ch_st_daylengthh').hide();
                            $('#halflabelstart').hide();
                            $('#halflabelend').hide();
                            $('#ch_ed_daylengthh').hide();
                        } else
                        {
                            $('#leave_image,#image').hide();
                            $('#ch_st_daylengthf').find('.iCheck-helper').trigger('click');
                            $('#ch_ed_daylengthf').find('.iCheck-helper').trigger('click');
                            $('#ch_st_daylengthh').hide();
                            $('#halflabelstart').hide();
                            $('#halflabelend').hide();
                            $('#ch_ed_daylengthh').hide();

                        }
                    }
                });
            }

        });


    });

    $('#leave').change(function () {

        var availableDates = [<?php echo $optional ?>];
        function startavailable(date) {
            dmy = date.getDate() + "-" + (date.getMonth() + 1) + "-" + date.getFullYear();
            if ($.inArray(dmy, availableDates) !== -1) {

                return [true, 'optional Holiday'];
            } else {

                return false;
            }
        }
        function endavailable(date) {

            dmy = date.getDate() + "-" + (date.getMonth() + 1) + "-" + date.getFullYear();
            if ($.inArray(dmy, availableDates) !== -1) {

                return [true, 'optional Holiday'];
            } else {

                return false;
            }
        }
        var $dates = $('#startdate, #enddate').datepicker();

        var stdate = jQuery('#startdate').val();

        var endate = jQuery('#enddate').val();

        jQuery('input[name=ch_st_daylength]').change(function () {
            dateDiff(jQuery('#startdate').datepicker("getDate"), jQuery('#enddate').datepicker("getDate"))
        });
        jQuery('input[name=ch_ed_daylength]').change(function () {
            dateDiff(jQuery('#startdate').datepicker("getDate"), jQuery('#enddate').datepicker("getDate"))
        });
        var type = $('#leave').val();
        
        if(type == 'PAR0000112'){
            jQuery('#duration_div_end,#duration_div_start,#reason_div,#enddate,#total_leave,#total_leave_div,#enddate_div').hide();
            jQuery('#startdate,#enddate').val(jQuery('#startdate').val());
            jQuery('#short_leave_type,#short_leave_type_div').show();
            dateDiff(jQuery('#startdate').datepicker("getDate"), jQuery('#enddate').datepicker("getDate"));
            var st__date = jQuery('#startdate').val();
            jQuery.ajax({
            url: '<?php echo $this->webroot ?>leaves/getshortleavedetail/' + st__date,
            success: function (data) {
                }
            });
            
        } else {
            jQuery('#duration_div_end,#duration_div_start,#reason_div,#enddate,#total_leave,#total_leave_div,#enddate_div').show();
            jQuery('#short_leave_type,#short_leave_type_div').hide();
        }

        var tot = $('#total_leave').val();
        jQuery.ajax({
            url: '<?php echo $this->webroot ?>leaves/getleaveConfi',
            success: function (data) {
                var obj = jQuery.parseJSON(data);
                $.each(obj, function (key, value) {

                    if (value.LeaveConfiguration.leave_code == type && value.LeaveConfiguration.half_day_chk == 0) {
                        $dates.datepicker('setDate', null);
                        jQuery('#total_leave').val(" ");

                        if (value.LeaveConfiguration.leave_type === 'EL' && value.LeaveConfiguration.leave_code === type) {
                            $("#startdate").datepicker("option", "maxDate", '0');
                        } else {
                            $("#startdate").datepicker("option", "maxDate", null);
                        }
                        if (value.LeaveConfiguration.leave_type !== 'SL' && value.LeaveConfiguration.leave_code === type) {
                            $("#startdate").datepicker("option", "maxDate", '0');
                        } else {
                            $("#startdate").datepicker("option", "maxDate", null);
                        }
                        $("#startdate").datepicker("option", "maxDate", null);
                        $("#enddate").datepicker("option", "maxDate", null);

                        if (value.LeaveConfiguration.leave_type === 'OP')
                        {

                            function available(date) {

                                $('#include_op_div').hide();
                                dmy = date.getDate() + "-" + (date.getMonth() + 1) + "-" + date.getFullYear();
                                // console.log(availableDates);
                                if ($.inArray(dmy, availableDates) !== -1) {

                                    return [true, 'optional Holiday'];
                                } else {

                                    return false;
                                }
                            }
                            $("#startdate").datepicker('option', 'beforeShowDay', available);
                            $("#enddate").datepicker('option', 'beforeShowDay', available);

                            $dates.datepicker('setDate', null);
                            jQuery('#total_leave').val(" ");
                        }
                        if (value.LeaveConfiguration.leave_type !== 'OP') {

                            $("#startdate").datepicker('option', 'beforeShowDay', false);
                            $("#enddate").datepicker('option', 'beforeShowDay', false);

                        }

                        $('#leave_image,#image').hide();
                        $('#ch_st_daylengthf').find('.iCheck-helper').trigger('click');
                        $('#ch_ed_daylengthf').find('.iCheck-helper').trigger('click');
                        $('#ch_st_daylengthh').show();
                        $('#ch_ed_daylengthh').show();
                        $('#halflabelstart').show();
                        $('#halflabelend').show();

                        if (value.LeaveConfiguration.file_upload == 1)
                        {
                            if (tot > value.LeaveConfiguration.file_upload_no) {
                                //  alert('hehr');
                                $('#leave_image,#image').show();
                            } else {
                                $('#leave_image,#image').hide();
                            }

                            $('#ch_st_daylengthf').find('.iCheck-helper').trigger('click');
                            $('#ch_ed_daylengthf').find('.iCheck-helper').trigger('click');
                            $('#ch_st_daylengthf').prop('checked', true);
                            $('#ch_ed_daylengthf').prop('checked', true);

                            $('#ed_half_type_div').hide();
                            $('#st_half_type_div').hide();

                            // var diff = dateDiff(jQuery('#startdate').datepicker("getDate"), jQuery('#enddate').datepicker("getDate"));

                            $('#ch_st_daylengthh').hide();
                            $('#halflabelstart').hide();
                            $('#halflabelend').hide();
                            $('#ch_ed_daylengthh').hide();
                            $("#startdate").datepicker('option', 'beforeShowDay', false);
                            $("#enddate").datepicker('option', 'beforeShowDay', false);

                        } else
                        {
                            $('#leave_image,#image').hide();
                            $('#ch_st_daylengthf').find('.iCheck-helper').trigger('click');
                            $('#ch_ed_daylengthf').find('.iCheck-helper').trigger('click');
                            $('#ch_st_daylengthf').prop('checked', true);
                            $('#ch_ed_daylengthf').prop('checked', true);

                            $('#ed_half_type_div').hide();
                            $('#st_half_type_div').hide();

                            //var diff = dateDiff(jQuery('#startdate').datepicker("getDate"), jQuery('#enddate').datepicker("getDate"));

                            $('#ch_st_daylengthh').hide();
                            $('#halflabelstart').hide();
                            $('#halflabelend').hide();
                            $('#ch_ed_daylengthh').hide();
                            $("#startdate").datepicker('option', 'beforeShowDay', false);
                            $("#enddate").datepicker('option', 'beforeShowDay', false);

                        }



                    } else if (value.LeaveConfiguration.leave_code == type && value.LeaveConfiguration.half_day_chk == 1)
                    {
                        $dates.datepicker('setDate', null);
                        jQuery('#total_leave').val(" ");

                        if (value.LeaveConfiguration.leave_type === 'EL' && value.LeaveConfiguration.leave_code === type) {
                            $("#startdate").datepicker("option", "maxDate", '0');
                        } else {
                            $("#startdate").datepicker("option", "maxDate", null);
                        }
                        if (value.LeaveConfiguration.leave_type !== 'SL' && value.LeaveConfiguration.leave_code === type) {
                            $("#startdate").datepicker("option", "maxDate", '0');
                        } else {
                            $("#startdate").datepicker("option", "maxDate", null);
                        }
                        $("#startdate").datepicker("option", "maxDate", null);
                        $("#enddate").datepicker("option", "maxDate", null);


                        if (value.LeaveConfiguration.leave_type === 'OP')
                        {
                            function available(date) {

                                $('#include_op_div').hide();
                                dmy = date.getDate() + "-" + (date.getMonth() + 1) + "-" + date.getFullYear();
                                console.log(availableDates);
                                if ($.inArray(dmy, availableDates) !== -1) {

                                    return [true, 'optional Holiday'];
                                } else {

                                    return false;
                                }
                            }
                            $("#startdate").datepicker('option', 'beforeShowDay', available);
                            $("#enddate").datepicker('option', 'beforeShowDay', available);

                            $dates.datepicker('setDate', null);
                            jQuery('#total_leave').val(" ");
                        }



                        if (value.LeaveConfiguration.leave_type !== 'OP') {
                            $("#startdate").datepicker('option', 'beforeShowDay', false);
                            $("#enddate").datepicker('option', 'beforeShowDay', false);

                            if (value.LeaveConfiguration.file_upload == 1)
                            {
                                if (tot > value.LeaveConfiguration.file_upload_no) {
                                    //  alert('hehr');
                                    $('#leave_image,#image').show();
                                } else {
                                    $('#leave_image,#image').hide();
                                }

                                $('#ch_st_daylengthf').find('.iCheck-helper').trigger('click');
                                $('#ch_ed_daylengthf').find('.iCheck-helper').trigger('click');
                                $('#ch_st_daylengthf').prop('checked', true);
                                $('#ch_ed_daylengthf').prop('checked', true);

                                $('#ed_half_type_div').hide();
                                $('#st_half_type_div').hide();

                                // var diff = dateDiff(jQuery('#startdate').datepicker("getDate"), jQuery('#enddate').datepicker("getDate"));

                                $('#ch_st_daylengthh').hide();
                                $('#halflabelstart').hide();
                                $('#halflabelend').hide();
                                $('#ch_ed_daylengthh').hide();
                                $("#startdate").datepicker('option', 'beforeShowDay', false);
                                $("#enddate").datepicker('option', 'beforeShowDay', false);

                            } else
                            {
                                $('#leave_image,#image').hide();
                                $('#ch_st_daylengthf').find('.iCheck-helper').trigger('click');
                                $('#ch_ed_daylengthf').find('.iCheck-helper').trigger('click');
                                $('#ch_st_daylengthf').prop('checked', true);
                                $('#ch_ed_daylengthf').prop('checked', true);

                                $('#ed_half_type_div').hide();
                                $('#st_half_type_div').hide();

                                //var diff = dateDiff(jQuery('#startdate').datepicker("getDate"), jQuery('#enddate').datepicker("getDate"));

                                $('#ch_st_daylengthh').hide();
                                $('#halflabelstart').hide();
                                $('#halflabelend').hide();
                                $('#ch_ed_daylengthh').hide();
                                $("#startdate").datepicker('option', 'beforeShowDay', false);
                                $("#enddate").datepicker('option', 'beforeShowDay', false);

                            }
                        }
                    }

                    if (value.LeaveConfiguration.leave_type === 'SL' && value.LeaveConfiguration.leave_code === type) {
                        $("#startdate").datepicker("option", "maxDate", '0');
                        $("#enddate").datepicker("option", "maxDate", '0');
                    } else
                    {

                    }

                });
            }
        });

    });

    function getDates(d1, d2) {
        var oneDay = 24 * 3600 * 1000;
        for (var d = [], ms = d1 * 1, last = d2 * 1; ms <= last; ms += oneDay) {
            d.push(new Date(ms));
        }
        return d;
    }

    jQuery('#ch_st_daylengthh').click(function () {
        jQuery('#st_half_type_div').show();


    });
    jQuery('#ch_ed_daylengthh').click(function () {
        jQuery('#ed_half_type_div').show();


    });
    jQuery('#ch_st_daylengthf').click(function () {
        jQuery('#st_half_type_div').hide();


    });
    jQuery('#ch_ed_daylengthf').click(function () {
        jQuery('#ed_half_type_div').hide();


    });



</script>   

<script>
function CheckLeaveCount() {
        var tot = $('#total_leave').val();
        var leave_code = jQuery('#leave').val();
        var leave_image = jQuery('#leave_image').val();
        var ext = $('#leave_image').val().split('.').pop().toLowerCase();
        var leave_id = jQuery('#leave').val();
        jQuery("#bal_leave_" + leave_id).text().trim();
        var doc = $('#leave_image').val();

        var tot = $('#total_leave').val();
        if(leave_id === 'PAR0000112') {
            //alert(jQuery('#short_leave_type').val());
            if(jQuery('#short_leave_type').val() === ''){
            $("html, body").animate({scrollTop: 0}, "slow");
            $("#alerts").html("<div data-uk-alert='' class='uk-alert uk-alert-danger'><a class='uk-alert-close uk-close' href='#'></a>You cannot apply Short Leave all have been claimed for this month").show();
            $("html, body").animate({scrollTop: 0}, "slow");
            return false;
               }
        }
        if (jQuery('#total_leave').val() === '') {
            $("html, body").animate({scrollTop: 0}, "slow");
            $("#alerts").html("<div data-uk-alert='' class='uk-alert uk-alert-danger'><a class='uk-alert-close uk-close' href='#'></a>Please Enter Leave Date.!").show().delay(2000).fadeOut();
            $("html, body").animate({scrollTop: 0}, "slow");
            return false;
        } else if (jQuery('#total_leave').val() == 0) {

            $("html, body").animate({scrollTop: 0}, "slow");
            $("#alerts").html("<div data-uk-alert='' class='uk-alert uk-alert-danger'><a class='uk-alert-close uk-close' href='#'></a>Total Days cannot be less than 0! Please Enter Proper Dates").show();
            $("html, body").animate({scrollTop: 0}, "slow");
            return false;

        } else if (jQuery('#total_leave').val() < 0) {

            $("html, body").animate({scrollTop: 0}, "slow");
            $("#alerts").html("<div data-uk-alert='' class='uk-alert uk-alert-danger'><a class='uk-alert-close uk-close' href='#'></a>Total Days cannot be less than 0! Please Enter Proper Dates").show();
            $("html, body").animate({scrollTop: 0}, "slow");
            return false;

        } else if (parseInt(jQuery('#total_leave').val().trim()) > (parseInt(jQuery("#bal_leave_" + leave_id).text().trim()) - parseInt(jQuery("#pending_leave_" + leave_id).text().trim()))) {

            $("html, body").animate({scrollTop: 0}, "slow");
            $("#alerts").html("<div data-uk-alert='' class='uk-alert uk-alert-danger'><a class='uk-alert-close uk-close' href='#'></a>You can't apply " + jQuery('#total_leave').val() + " leaves in " + jQuery('#bal_leave_' + leave_id).text().trim() + " Balance Leaves and " + jQuery('#pending_leave_' + leave_id).text().trim() + " Pending Leaves.").show();
            $("html, body").animate({scrollTop: 0}, "slow");
            return false;
        } else if (jQuery('#total_leave').val() === 'NaN') {
            $("html, body").animate({scrollTop: 0}, "slow");
            $("#alerts").html("<div data-uk-alert='' class='uk-alert uk-alert-danger'><a class='uk-alert-close uk-close' href='#'></a>Please Enter Start Date.!").show();
            $("html, body").animate({scrollTop: 0}, "slow");
            return false;
        } else if ($.trim($("#LeaveVcLeaveReason").val()) == "" && leave_id != 'PAR0000112'){
            $("html, body").animate({scrollTop: 0}, "slow");
            $("#alerts").html("<div data-uk-alert='' class='uk-alert uk-alert-danger'><a class='uk-alert-close uk-close' href='#'></a>Please Enter Leave Reason").show();

            return false;
        } else if (medical === 'PAR0000527' && tot > 2 && doc == "") {
            $("html, body").animate({scrollTop: 0}, "slow");
            $("#alerts").html("<div data-uk-alert='' class='uk-alert uk-alert-danger'><a class='uk-alert-close uk-close' href='#'></a>Please Upload Medical Certificate").show();
            $("html, body").animate({scrollTop: 0}, "slow");
            return false;
        } else if (medical === 'PAR0000391' && tot > 2) {
            $("html, body").animate({scrollTop: 0}, "slow");
            $("#alerts").html("<div data-uk-alert='' class='uk-alert uk-alert-danger'><a class='uk-alert-close uk-close' href='#'></a>You can apply two optional leave in one year").show();
            $("html, body").animate({scrollTop: 0}, "slow");
            return false;
        } else if (medical === 'PAR0000391' && tot > 2) {
            $("html, body").animate({scrollTop: 0}, "slow");
            $("#alerts").html("<div data-uk-alert='' class='uk-alert uk-alert-danger'><a class='uk-alert-close uk-close' href='#'></a>You can apply two optional leave in one year").show();
            $("html, body").animate({scrollTop: 0}, "slow");
            return false;
            
           } else if (op && tot > 1 && medical === 'PAR0000391') {
            $("html, body").animate({scrollTop: 0}, "slow");
            $("#alerts").html("<div data-uk-alert='' class='uk-alert uk-alert-danger'><a class='uk-alert-close uk-close' href='#'></a>You can apply one optional leave ").show();
            $("html, body").animate({scrollTop: 0}, "slow");
            return false;
        } else if (medical === 'PAR0000063') {
            var startDate = jQuery('#startdate').datepicker("getDate");

            var endDate = jQuery('#enddate').datepicker("getDate");
            var all_dates = getDates(startDate, endDate);

            var i = 0;

            jQuery(all_dates).each(function (e, v) {
                var optionalholidays = <?php echo json_encode($optionarray); ?>;
                var opdt = v.getFullYear() + '-' + ("0" + (v.getMonth() + 1)).slice(-2) + '-' + ("0" + v.getDate()).slice(-2);
                var ophol = Object.keys(optionalholidays).map(function (k) {
                    return optionalholidays[k]
                });
                if (jQuery.inArray(opdt, ophol) !== -1) {
                    i = i + 1;
                }
            });

            if (op && i > 1) {
                $("html, body").animate({scrollTop: 0}, "slow");
                $("#alerts").html("<div data-uk-alert='' class='uk-alert uk-alert-danger'><a class='uk-alert-close uk-close' href='#'></a>Only One Optional Leave Can be added as Casual Leave ").show();
                $("html, body").animate({scrollTop: 0}, "slow");
                return false;
            } else if (op >= 2 && i > 0) {
                $("html, body").animate({scrollTop: 0}, "slow");
                $("#alerts").html("<div data-uk-alert='' class='uk-alert uk-alert-danger'><a class='uk-alert-close uk-close' href='#'></a>you Cannot add  Optional Leave as  Casual Leave as you have already applied two optional leave ").show();
                $("html, body").animate({scrollTop: 0}, "slow");
                return false;
            }

        } else {
            return true;
        }
    }
    

</script>
    
    