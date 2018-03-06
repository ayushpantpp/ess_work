<div id="page_content">
    <div id="page_content_inner">
        <h3 class="heading_b uk-margin-bottom">Training Initiation Enrollment Form</h3>
        <?php echo $flash = $this->Session->flash(); ?>
        <div id="alerts"></div>
        <div class="md-card uk-margin-medium-bottom">
            <div class="md-card-content">
                <?php echo $this->Form->create('Training', array('url' => array('controller' => 'training', 'action' => ''), 'id' => 'form_validation', 'enctype' => 'multipart/form-data', 'onsubmit' => 'return addtype(this)', 'class' => 'uk-form-stacked')); ?>
                <div class="uk-grid uk-grid-divider" data-uk-grid-margin>
                    <div class="uk-width-medium-1-2">
                        <div class="uk-form-row">
                            <label><b>Course Name*</b></label>
                            <select id="course_id" class="md-input data-md-selectize label-fixed" onchange="course_duration(this)" name="course_id">
                                <option value="0">Choose..</option>
                                <?php
                                if (!empty($courselists)) {
                                    foreach ($courselists as $ky => $val) {
                                        ?>
                                        <option value="<?php echo $ky; ?>"><?php echo $val; ?></option>
                                        <?php
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="uk-width-medium-1-2">
                        <div class="uk-form-row" id="newfield">
                            <label><b>Course Schedule List*</b></label>
                            <select class="md-input data-md-selectize label-fixed" id="schedule_id">
                                <option value="0">Choose..</option>
                            </select>
                        </div>
                    </div>
                    <div class="uk-width-medium-1-2">
                        <div class="uk-form-row">
                            <label for="message"><b>Training Start Date*</b></label>
                            <input type="text" class="md-input label-fixed" name="training_date" id="training_date" readonly/>
                        </div>
                    </div>
                    <div class="uk-width-medium-1-2">
                        <div class="uk-form-row">
                            <label for="message"><b>Training Duration Time*</b></label>
                            <input type="text" class="md-input label-fixed" name="training_time" id="training_time" />
                            <input type="hidden" class="" name="update_training_id" id="update_training_id" value="" />
                        </div>
                    </div>
                    <div class="uk-width-medium-1-2">
                        <div class="uk-form-row">
                            <label for="message"><b>Training Request Description</b></label>
                            <textarea class="md-input label-fixed" name="message" id="message" data-parsley-trigger="keyup"></textarea>
                        </div>
                    </div>
                    <div class="uk-width-medium-1-2">
                        <div class="uk-form-row">
                            <label for="message"><b>Remarks</b></label>
                            <textarea class="md-input label-fixed" id="remarks" name="remarks"  data-parsley-trigger="keyup"></textarea>
                        </div>
                    </div>
                    <div class="uk-width-medium-1-2">
                        <div class="uk-form-row">
                            <label for="message"><b>Instructor Name</b></label>
                            <input type="text" id="instructor_name" class="md-input label-fixed" readonly value=""/>
                            <?php echo $this->Form->input('training_instructor_name', array('type' => 'select', 'label' => "", 'options' => $employeelist, 'style' => 'display:none', 'class' => 'md-input', 'empty' => '--Choose--', 'id' => 'training_instructor_name')); ?>
                        </div>
                    </div>
                    <div class="uk-width-medium-1-2">
                        <?php if (!$reported_emp) { ?>       
                            <div class="uk-form-row" style="display: none;">
                                <label for="message"><b style="color: #727272; font-size: 12px;">Self Include</b></label>
                                    <input type="checkbox" checked name="self" value="1" id="self" />
                            </div>
                        <?php } else { ?> 
                            <div class="uk-form-row">
                                    <label for="message"><b style="color: #727272; font-size: 12px;">Self Include</b></label>
                                    <input type="checkbox" class="" name="self" value="1" id="self" />
                            </div>     
                        <?php } ?>        
                    </div>

                    <?php if ($reported_emp) { ?>
                        <div class="uk-width-medium-1-3">
                            <div class="uk-form-row">
                                <label><b style="color: #727272; font-size: 12px;">List of Employees:</b></label>
                                <?php
                                echo $this->Form->input('vc_trainee_code', array('type' => 'select',
                                    'class' => 'md-input',
                                    'multiple' => true,
                                    'label' => false,
                                    'id' => 'lstBox1',
                                    'options' => $reported_emp,
                                ));
                                ?>
                            </div>
                        </div>
                        <div class="uk-width-medium-1-3" style="text-align: center;">
                            <div class="uk-form-row">
                                <input type="button" id="btnRight" value =" => "/>
                            </div>   
                            <div class="uk-form-row">
                                <input type="button" id="btnLeft" value =" <= "/>
                            </div>  
                        </div>
                        <div class="uk-width-medium-1-3">
                            <div class="uk-form-row">
                                <div id="trainees_list_div"></div>
                                <label for="message"><b style="color: #727272; font-size: 12px;">List of Trainees:</b></label>
                                <?php
                                echo $this->Form->input('vc_trainee_code', array('type' => 'select',
                                    'class' => 'md-input',
                                    'multiple' => true,
                                    'label' => false,
                                    'id' => 'lstBox2'
                                ));
                                ?>
                            </div>
                        </div>  
                    <?php } ?>

                    <?php if (!empty($desg_wise_employee)) { ?>
                        <div class="uk-width-medium-1-1">
                            <div class="uk-form-row">
                                <div class="uk-overflow-container">
                                    <table class="uk-table uk-text-nowrap">
                                        <thead>
                                            <tr>
                                                <th class="uk-width-1-10 uk-text-center">S No.</th>
                                                <th class="uk-width-1-10 uk-text-center">Total Employee</th>
                                                <th class="uk-width-2-10">Designation Code</th>
                                                <th class="uk-width-2-10 uk-text-center">Designation Name</th>
                                                <th class="uk-width-2-10 uk-text-center">Location</th>
                                                <th class="uk-width-2-10 uk-text-center">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if (!empty($desg_wise_employee)) {
                                                $o = 1;
                                                foreach ($desg_wise_employee as $desg_wise_employees) {
                                                    ?>
                                                    <tr>
                                                        <td class="uk-text-center"><?php echo $o; ?></td>
                                                        <td class="uk-text-center"><?php echo $desg_wise_employees[0]['ct']; ?></td>
                                                        <td><?php echo $desg_wise_employees['MyProfile']['desg_code']; ?></td>
                                                        <td class="uk-text-center"><?php echo ucfirst(strtolower($this->Common->findDesignationName($desg_wise_employees['MyProfile']['desg_code'], $desg_wise_employees['MyProfile']['comp_code']))); ?></td>
                                                        <td class="uk-text-center"><?php if (!empty($this->Common->findLocationNameByCode($desg_wise_employees['MyProfile']['location_code'], $desg_wise_employees['MyProfile']['comp_code']))) echo ucfirst(strtolower($this->Common->findLocationNameByCode($desg_wise_employees['MyProfile']['location_code'], $desg_wise_employees['MyProfile']['comp_code']))); ?></td>
                                                        <td class="uk-text-center"><input type="checkbox" name="data[Training][traineede][]" value="<?php echo $desg_wise_employees['MyProfile']['desg_code'] . "_" . $desg_wise_employees['MyProfile']['location_code']; ?>" onclick="checkEmplyee(this)" id="chkEmp_<?php echo $o; ?>" class="locdesg"/>
                                                            <?php
                                                            if (!empty($this->Common->findEmpNameCode($emp_code, $desg_wise_employees['MyProfile']['desg_code'], $desg_wise_employees['MyProfile']['location_code']))) {
                                                                $desgEmployees = $this->Common->findEmpNameCode($emp_code, $desg_wise_employees['MyProfile']['desg_code'], $desg_wise_employees['MyProfile']['location_code']);

                                                                foreach ($desgEmployees as $desgEmployees) {
                                                                    ?>
                                                                    <input style="display: none;" type="checkbox" name="data[Training][traineedesgcode][]" value="<?php echo $desgEmployees['MyProfile']['emp_code']; ?>" class="empcd_<?php echo $o; ?>">
                                                                    <?php
                                                                }
                                                            }
                                                            ?>
                                                        </td>
                                                    </tr>
                                                    <?php
                                                    $o++;
                                                }
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    <?php } ?>



                    <div class="uk-width-medium-1-4">
                        <div class="uk-form-row">
                            <div class="uk-grid">
                                <div class="uk-width-medium-1-2">
                                    <span class="uk-input-group-addon"><button type="submit" class="md-btn" onclick="return checkSubmit();">Save</button></span>
                                </div>
                                <div class="uk-width-medium-1-2">
                                    <span class="uk-input-group-addon"><a class="md-btn md-btn-wave waves-effect waves-button" href="<?php echo $this->webroot; ?>training/manageTrainingIdentificationForm/">Cancel</a></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php echo $this->Form->end(); ?>
            </div>
        </div>
    </div>
</div>

<script>
    function checkEmplyee(idd) {
        if (idd.checked) {
            jQuery(".empcd_" + jQuery(idd).attr("id").replace(/[^\d.]/g, '')).prop('checked', true);
        } else {
            jQuery(".empcd_" + jQuery(idd).attr("id").replace(/[^\d.]/g, '')).prop('checked', false);
        }
    }

    function addtype(idd) {
        var start_time = jQuery("#sch_start_time").val();
        var end_time = jQuery("#sch_end_time").val();
        start_time = start_time.split(" ");
        var time = start_time[0].split(":");
        var stime = time[0];
        start_time = stime + ":" + time[1];

        end_time = end_time.split(" ");
        var time1 = end_time[0].split(":");
        var etime = time1[0];
        end_time = etime + ":" + time1[1];

        if (start_time != '' && end_time != '') {
            alert(start_time);
            alert(end_time);
            if (end_time <= start_time) {
                alert('select valid time');
            }
        }
        return false;
    }

    function course_duration(idd) {
        vl = jQuery(idd).val();
        jQuery.ajax({
            url: '<?php echo $this->webroot ?>training/getCourseScheduleList/' + vl,
            success: function (data) {
                $("#newfield").html(data);
                jQuery("#training_date").val('');
                jQuery("#training_time").val('');
                jQuery("#update_training_id").val('');
                jQuery("#instructor_name").val('');
                jQuery("#training_instructor_name").val('');
                jQuery("#remarks").val('');
                jQuery("#message").val('');
                jQuery("#remarks").attr("readonly", false);
                jQuery("#message").attr("readonly", false);
            }
        });
    }

    function getSchedule(idd) {
        jQuery("#training_date").val('');
        jQuery("#training_time").val('');
        jQuery("#update_training_id").val('');
        jQuery("#instructor_name").val('');
        jQuery("#training_instructor_name").val('');
        jQuery("#remarks").val('');
        jQuery("#message").val('');
        jQuery("#remarks").attr("readonly", false);
        jQuery("#message").attr("readonly", false);
        vl = jQuery(idd).val();
        jQuery.ajax({
            type: "POST",
            async: false,
            data: {sid: vl},
            dataType: 'json',
            url: '<?php echo $this->webroot ?>training/getCourseScheduleDetails/',
            cache: false,
            success: function (data) {
                if (vl != 0) {
                    jQuery("#training_date").val(data.date);
                    jQuery("#training_time").val(data.time);
                    jQuery("#update_training_id").val(data.training_id);
                    jQuery("#instructor_name").val(data.inst_full_name);
                    jQuery("#training_instructor_name").val(data.inst_name);
                    jQuery("#remarks").val(data.remarks);
                    jQuery("#message").val(data.description);
                }
                if (data.training_id == 0) {
                    jQuery("#remarks").attr("readonly", false);
                    jQuery("#message").attr("readonly", false);
                } else {
                    jQuery("#remarks").attr("readonly", true);
                    jQuery("#message").attr("readonly", true);
                }
            }
        });
    }

    function isEmpty(myObject) {
        for (var key in myObject) {
            if (myObject.hasOwnProperty(key)) {
                return false;
            }
        }

        return true;
    }

    function addtypes(idd) {
        if (jQuery("#val_select").val() == "") {
            alert("Please enter the Course Name");
            return false;
        } else if (jQuery('#sch_start_date').val() == "")
        {
            alert("Please enter the Schedule Start Date");
            return false;
        } else if (jQuery('#sch_end_date').val() == "")
        {
            alert("Please enter the Schedule End Date");
            return false;
        } else if ((Date.parse(jQuery('#sch_end_date').val()) < Date.parse(jQuery('#sch_start_date').val()))) {
            alert("Schedule End Date should be greater than Schedule Start Date");
            return false;
        } else {
            return true;
        }
        return false;
    }
    jQuery(document).ready(function () {
        jQuery("#sch_start_date").datepicker({
            dateFormat: 'dd-mm-yy',
            inline: true,
            changeMonth: true,
            changeYear: true,
            autoclose: true,
        });
        jQuery("#final_regis_date").datepicker({
            dateFormat: 'dd-mm-yy',
            inline: true,
            changeMonth: true,
            changeYear: true,
            autoclose: true,
        });
        jQuery("#sch_end_date").datepicker({
            dateFormat: 'dd-mm-yy',
            inline: true,
            changeMonth: true,
            changeYear: true,
            autoclose: true
        });
        jQuery('#btnRight').click(function (e) {
            var selectedOpts = jQuery('#lstBox1 option:selected');
            var selectedOptsVals = jQuery('#lstBox1').val().toString();
            if (selectedOpts.length == 0) {
                alert("Nothing to move.");
                e.preventDefault();
            }
            jQuery('#lstBox2').append($(selectedOpts).clone());
            jQuery(selectedOpts).remove();
            e.preventDefault();

            var myArray = selectedOptsVals.split(',');

            for (var i = 0; i < myArray.length; i++) {

                jQuery('#trainees_list_div').append('<input type="hidden" name="data[Training][traineecode][]" value="' + myArray[i] + '"/>');
            }
        });
        jQuery('#btnLeft').click(function (e) {
            var selectedOpts = $('#lstBox2 option:selected');
            var selectedOptsVals = $('#lstBox2').val().toString();
            if (selectedOpts.length == 0) {
                alert("Nothing to move.");
                e.preventDefault();
            }

            jQuery('#lstBox1').append($(selectedOpts).clone());
            jQuery(selectedOpts).remove();
            e.preventDefault();

            var myArray = selectedOptsVals.split(',');

            for (var i = 0; i < myArray.length; i++) {
                $('input[value="' + myArray[i] + '"]').remove();
            }
        });
        //        jQuery("#training_time").kendoTimePicker({
        //            format: "HH:mm",
        //            interval: 5
        //        });
        jQuery("#training_time").attr("readonly", true);
        //        jQuery("#training_date").datepicker({
        //            dateFormat: 'dd-mm-yy',
        //            inline: true,
        //            changeMonth: true,
        //            changeYear: true,
        //            autoclose: true,
        //            minDate: '0',
        //        });
    });
    function checkSubmit() {

        var str = $('#course_id').val();
        var ct = 0;
        if (str == 0) {
            $("html, body").animate({scrollTop: 0}, "slow");
            $("#alerts").html("<div data-uk-alert='' class='uk-alert uk-alert-danger'><a class='uk-alert-close uk-close' href='#'></a>Please select Course Name").show();
            $("html, body").animate({scrollTop: 0}, "slow");
            return false;

        }
        var schedule_id = $('#schedule_id').val();
        if (schedule_id == 0) {
            $("html, body").animate({scrollTop: 0}, "slow");
            $("#alerts").html("<div data-uk-alert='' class='uk-alert uk-alert-danger'><a class='uk-alert-close uk-close' href='#'></a>Please Select Schedule for Course").show();
            $("html, body").animate({scrollTop: 0}, "slow");
            return false;

        }
        var training_date = $('#training_date').val();
        if (training_date === "") {
            $("html, body").animate({scrollTop: 0}, "slow");
            $("#alerts").html("<div data-uk-alert='' class='uk-alert uk-alert-danger'><a class='uk-alert-close uk-close' href='#'></a>Enter Training Date").show();
            $("html, body").animate({scrollTop: 0}, "slow");
            return false;

        }
        var training_time = $('#training_time').val();
        if (training_time === "") {
            $("html, body").animate({scrollTop: 0}, "slow");
            $("#alerts").html("<div data-uk-alert='' class='uk-alert uk-alert-danger'><a class='uk-alert-close uk-close' href='#'></a>Enter Training Time").show();
            $("html, body").animate({scrollTop: 0}, "slow");
            return false;
        }
        if (training_time == '00:00') {
            $("html, body").animate({scrollTop: 0}, "slow");
            $("#alerts").html("<div data-uk-alert='' class='uk-alert uk-alert-danger'><a class='uk-alert-close uk-close' href='#'></a>Please select Training Duration Time above 00:00.").show();
            $("html, body").animate({scrollTop: 0}, "slow");
            return false;
        }

        if (document.getElementById("lstBox2").length != 0) {
            ct++;
        }
        if ($("[class='locdesg']:checked").length != 0) {
            ct++;
        }
        if ($('#self').prop('checked') != false) {
            ct++;
        }
        if (ct == 0) {
            $("html, body").animate({scrollTop: 0}, "slow");
            $("#alerts").html("<div data-uk-alert='' class='uk-alert uk-alert-danger'><a class='uk-alert-close uk-close' href='#'></a>Please select At least one Trainees.").show();
            $("html, body").animate({scrollTop: 0}, "slow");
            return false;
        }

    }
</script>