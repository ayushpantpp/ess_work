<!-- page content -->

<div id="page_content" role="main">
    <div id="page_content_inner">
        <h3 class="heading_b uk-margin-bottom">Leave Form</h3>
        <?php echo $flash = $this->Session->flash();?>
        <div id="alerts"></div>
        <div class="md-card">
            <div class="md-card-content large-padding">
                <?php echo $this->Form->create('Leave', array('url' => array('controller' => 'leaves', 'action' => 'add'), 'id' => 'form_validation', 'enctype' => 'multipart/form-data', 'class' => 'uk-form-stacked')); ?>

                <?php
                $auth = $this->Session->read('Auth');
                $options = $this->Common->option_name($auth['MyProfile']['emp_nm_ttl']);
                ?>
                <div class="uk-grid" data-uk-grid-margin>

                    <div class="uk-width-medium-1-2">
                        <div class="parsley-row">
                            <?php echo $this->form->input('user_name', array('label' => "Employee Name", 'type' => 'text', 'value' => $options[$auth['MyProfile']['emp_nm_ttl']] . $auth['MyProfile']['emp_full_name'] . '-' . $auth['MyProfile']['emp_id'], 'class' => "md-input", 'required' => true, 'id' => 'first_name')); ?>
                        </div>
                    </div>                    

                    <div class="uk-width-medium-1-2">
                        <div class="parsley-row">
                            <?php
                            $v = $this->Common->option_attribute_name($gender);
                            $leave_name['PAR0000068'] = 'LWP LEAVE';
                            if ($opemp < 2) {
                                $leave_name['PAR0000391'] = 'OPTIONAL LEAVE';
                            }
                            if ($v[$gender] == 'FEMALE') {
                                $leave_name['PAR0000066'] = 'MATERNITY LEAVE';
                            }
                            asort($leave_name);
                            ?>
                            <?php echo $this->form->input('Leave.leave_code', array('class' => "md-input", 'label' => "Leave Type", 'type' => 'select', 'options' => array_map('strtoupper', $leave_name), 'default' => 'C', 'id' => 'leave')); ?>
                        </div>
                    </div>

                    <div class="uk-width-medium-1-2">
                        <label>Start Date</label>
                        <div class="parsley-row">
                            <?php echo $this->form->input('Leave.dt_start_date', array('label' => "", 'class' => "md-input", 'type' => 'text', 'id' => 'startdate1', 'readonly' => true,'value' => date('d-m-Y',$leave_date))); ?>
                        </div>
                    </div>

                    <div class="uk-width-medium-1-2" >
                        <label>End Date</label>
                        <div class="parsley-row">                        
                           <?php echo $this->form->input('Leave.dt_end_date', array('label' => "", 'class' => "md-input", 'type' => 'text', 'id' => 'enddate1', 'readonly' => true, 'default' => $_POST['Leave']['dt_end_date'],'value' => date('d-m-Y',$leave_date))); ?>
                        </div>
                    </div>
                    <div class="uk-width-medium-1-2">
                        <label>Total Leaves *</label>
                        <div class="parsley-row">
                            <?php
                            echo $this->form->input('Leave.nu_tot_leaves', array('label' => "", 'class' => "md-input",
                                'type' => 'text', 'readonly' => 'readonly', 'id' => 'total_leave'));
                            ?>
                        </div>
                    </div>

                    <div class="uk-width-medium-1-2">
                        <div class="parsley-row">
                            <label for="message">Reason (20 chars min, 150 max)*</label>
<?php echo $this->form->textarea('vc_leave_reason', array('label' => "Reason *", 'class' => "md-input", "data-parsley-minlength" => "20", "data-parsley-maxlength" => "150", "data-parsley-validation-threshold" => "10","id" => "LeaveVcLeaveReason", "data-parsley-minlength-message" => "Come on! You need to enter at least a 20 caracters long comment..")); ?>
                        </div>
                    </div>

                    <div class="uk-width-medium-1-2" style = "display:none">
                        <div class="parsley-row">
                            <input type="file" name="leave_image" id="leave_image" />                            
                        </div>
                    </div>
                <div class="uk-grid">
                        <div class="uk-width-1-1 uk-margin-top">
                            <input type="submit" class="md-btn md-btn-primary" value="Apply" name='post_leave' onclick="return post();
                                    ">
                            <a class="md-btn md-btn-danger" href="<?php echo $this->Html->url('/users/dashboard') ?>">Cancel</a>
                        </div>
                </div>

                    </form>
                </div>
                <div class="uk-grid uk-margin-medium-top uk-margin-large-bottom" data-uk-grid-margin>
                    <div class="uk-width-large-1-1">
                        <div class="uk-overflow-container uk-margin-bottom">
                            <table class="uk-table uk-table-striped uk-text-nowrap">



                                <thead>
                                    <tr class="headings">

                                        <th class="column-title">Leave Type </th>
                                        <th class="column-title">1st January Opening Balance</th>
                                        <th class="column-title">Balance Leave</th>
                                        <th class="column-title">Applied Leaves</th>
                                        <th class="column-title">Pending Leaves for approval</th>
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
                                            <th><?php echo $total; ?></th>
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
                    </div></div>
            </div>
        </div>
    </div>
</div>
        <script type="text/javascript" >
            function post()
            {
                var tot = $('#total_leave').val();
                var leave_code = jQuery('#leave').val();
                var leave_image = jQuery('#leave_image').val();
                if ((leave_code == 'PAR0000003' || leave_code == 'PAR0000006') && tot > 2) {

                    if (leave_image == '') {
                        alert('Please Upload Medical Document');
                        return false;
                    }
                }


                document.Form1.action = "postLeaves";
                return CheckLeaveCount();
            }


            jQuery(document).keydown(function (e) {
                if (e.keyCode == 90 && e.altKey) {
                    history.go(-1);
                }

            });
            jQuery(document).ready(function () {
                dateDiff(jQuery('#startdate1').datepicker("getDate"), jQuery('#enddate1').datepicker("getDate"));


            });
        </script>
        <script>
            function dateDiff(startDate, endDate) {

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
                        $("#alerts").html("<div data-uk-alert='' class='uk-alert uk-alert-danger'><a class='uk-alert-close uk-close' href='#'></a>You cannot claim Two half day for Same Date").show();
                        $('#ed_half_type_div').hide();
                        jQuery("input[name='ch_ed_daylength']").val(unchecked);


                    }
                }
                jQuery('#vc_date_diff').val(difdate1);
                //alert(difdate1);
                if (difdate < 0) {
                    $("html, body").animate({scrollTop: 0}, "slow");
                    $("#alerts").html("<div data-uk-alert='' class='uk-alert uk-alert-danger'><a class='uk-alert-close uk-close' href='#'></a>Total Days cannot be less than 0! Please Enter Proper Dates").show();
                    jQuery('#total_leave').val('');
                    return false;
                } else {
                    jQuery('#total_leave').val(difdate1);

                }
                var leavetyp = $("#leave").val();
                // alert(leavetyp);
                if ((leavetyp != 'PAR0000003') && (leavetyp != 'PAR0000011') && (leavetyp != 'PAR0000001') && (leavetyp != 'PAR0000006') && (leavetyp != 'PAR0000002')) {
                    //substract leaves on the basis of holidays

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
            }
            $(window).load(function () {

                var type = $('#leave').val();
                console.log(type);
                var tot = $('#total_leave').val();
                if (type === 'PAR0000001') {
                    $('#leave_image,#image').hide();
                    $('#ch_st_daylengthh').parent().show();
                    $('#ch_ed_daylengthh').parent().show();
                } else if (type === 'PAR00000011') {
                    $('#leave_image,#image').hide();
                    $('#ch_st_daylengthh').parent().hide();
                    $('#ch_ed_daylengthh').parent().hide();
                } else if (type === 'PAR0000006' && tot > 2) {
                    $('#leave_image,#image').show();
                    $('#ch_st_daylengthh').parent().hide();
                    $('#ch_ed_daylengthh').parent().hide();
                } else if (type == 'PAR0000003' && tot > 2) {
                    $('#leave_image,#image').show();
                    $('#ch_st_daylengthh').parent().show();
                    $('#ch_ed_daylengthh').parent().show();
                } else if (type == 'PAR0000002') {
                    $('#leave_image,#image').hide();
                    $('#ch_st_daylengthh').parent().show();
                    $('#ch_ed_daylengthh').parent().show();
                }
            });

            $('#leave').change(function () {

                var stdate = jQuery('#startdate').val();
                var endate = jQuery('#enddate').val();
                //alert(stdate);alert(endate);
                if (stdate != '' && endate != '') {
                    var diff = dateDiff(jQuery('#startdate').datepicker("getDate"),
                            jQuery('#enddate').datepicker("getDate"));
                }


                jQuery('input[name=ch_st_daylength]').change(function () {
                    dateDiff(jQuery('#startdate').datepicker("getDate"), jQuery('#enddate').datepicker("getDate"))
                });
                jQuery('input[name=ch_ed_daylength]').change(function () {
                    dateDiff(jQuery('#startdate').datepicker("getDate"), jQuery('#enddate').datepicker("getDate"))
                });
                var type = $('#leave').val();

                var tot = $('#total_leave').val();
                if (type === 'PAR0000001') {
                    $('#leave_image,#image').hide();

                    $('#ch_st_daylengthf').parent().find('.iCheck-helper').trigger('click');
                    $('#ch_ed_daylengthf').parent().find('.iCheck-helper').trigger('click');
                    $('#ch_st_daylengthh').parent().parent().show();
                    $('#ch_ed_daylengthh').parent().parent().show();
                } else if (type === 'PAR00000011') {
                    $('#leave_image,#image').hide();

                    $('#ch_st_daylengthf').parent().find('.iCheck-helper').trigger('click');
                    $('#ch_ed_daylengthf').parent().find('.iCheck-helper').trigger('click');
                    $('#ch_st_daylengthh').parent().parent().hide();
                    $('#ch_ed_daylengthh').parent().parent().hide();
                } else if (type === 'PAR0000006') {
                    if (tot > 2) {
                        $('#leave_image,#image').show();
                    } else {
                        $('#leave_image,#image').hide();
                    }

                    $('#ch_st_daylengthf').parent().find('.iCheck-helper').trigger('click');
                    $('#ch_ed_daylengthf').parent().find('.iCheck-helper').trigger('click');
                    $('#ch_st_daylengthh').parent().parent().show();
                    $('#ch_ed_daylengthh').parent().parent().show();
                } else if (type == 'PAR0000003') {

                    if (tot > 2) {
                        $('#leave_image,#image').show();
                    } else {
                        $('#leave_image,#image').hide();
                    }

                    $('#ch_st_daylengthf').parent().find('.iCheck-helper').trigger('click');
                    $('#ch_ed_daylengthf').parent().find('.iCheck-helper').trigger('click');
                    $('#ch_st_daylengthh').parent().parent().show();
                    $('#ch_ed_daylengthh').parent().parent().show();
                } else if (type == 'PAR0000002') {
                    $('#leave_image,#image').hide();
                    $('#ch_st_daylengthh').parent().parent().show();
                    $('#ch_ed_daylengthh').parent().parent().show();
                }


            });
            function CheckLeaveCount()
            {

                var tot = $('#total_leave').val();
                var leave_code = jQuery('#leave').val();
                var leave_image = jQuery('#leave_image').val();
                if ((leave_code == 'PAR0000003' || leave_code == 'PAR0000006') && tot > 2) {

                    if (leave_image == '') {
                        alert('Please Upload Medical Document');
                        return false;
                    }
                }

                var leave_id = jQuery('#leave').val();
                //var leave_id=parseInt(leave);
                //alert(leave_id);
                jQuery("#bal_leave_" + leave_id).text().trim();
                jQuery('#total_leave').val();
                var doc = $('#leave_image').val();
                var medical = jQuery('#leave').val();
                var tot = $('#total_leave').val();
                if (jQuery('#total_leave').val() === '') {

                    $("html, body").animate({scrollTop: 0}, "slow");
                    $("#alerts").html("<div data-uk-alert='' class='uk-alert uk-alert-danger'><a class='uk-alert-close uk-close' href='#'></a>Please Enter Leave Date.!").show();
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

                }
                else if (parseInt(jQuery('#total_leave').val().trim()) > (parseInt(jQuery("#bal_leave_" + leave_id).text().trim()) - parseInt(jQuery("#pending_leave_" + leave_id).text().trim()))) {

                    $("html, body").animate({scrollTop: 0}, "slow");
                    $("#alerts").html("<div data-uk-alert='' class='uk-alert uk-alert-danger'><a class='uk-alert-close uk-close' href='#'></a>You can't apply " + jQuery('#total_leave').val() + " leaves in " + jQuery('#bal_leave_' + leave_id).text().trim() + " Balance Leaves and " + jQuery('#pending_leave_' + leave_id).text().trim() + " Pending Leaves.").show();
                    $("html, body").animate({scrollTop: 0}, "slow");
                    return false;
                }
                else if (jQuery('#total_leave').val() == 'NaN') {
                    $("html, body").animate({scrollTop: 0}, "slow");
                    $("#alerts").html("<div data-uk-alert='' class='uk-alert uk-alert-danger'><a class='uk-alert-close uk-close' href='#'></a>Please Enter Start Date.!").show();
                    $("html, body").animate({scrollTop: 0}, "slow");
                    return false;
                }
                else if ($('#LeaveVcLeaveReason').val() == "") {
                    $("html, body").animate({scrollTop: 0}, "slow");
                    $("#alerts").html("<div data-uk-alert='' class='uk-alert uk-alert-danger'><a class='uk-alert-close uk-close' href='#'></a>Please Enter Leave Reason").show();
                    $("html, body").animate({scrollTop: 0}, "slow");
                    return false;
                }
                else if (medical === 'PAR00000327' && tot > 2 && doc == "") {
                    $("html, body").animate({scrollTop: 0}, "slow");
                    $("#alerts").html("<div data-uk-alert='' class='uk-alert uk-alert-danger'><a class='uk-alert-close uk-close' href='#'></a>Please Upload Medical Certificate").show();
                    $("html, body").animate({scrollTop: 0}, "slow");
                    return false;
                } else {
                    return true;
                }
            }
        </script>
    </div>
