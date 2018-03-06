<div id="page_content">
    <div id="page_content_inner">
        <h3 class="heading_b uk-margin-bottom">Update Course Schedule ID(<?php echo $details['TrainingScheduleCreation']['schedule_id']; ?>)</h3>
        <?php echo $flash = $this->Session->flash(); ?>
        <div id="alerts"></div>
        <div class="md-card uk-margin-medium-bottom">
            <div class="md-card-content">
                <?php echo $this->Form->create('Training', array('url' => array('controller' => 'training', 'action' => 'updateCourseSchedule'), 'id' => 'form_validation', 'enctype' => 'multipart/form-data', 'onsubmit' => 'return addtype(this)', 'class' => 'uk-form-stacked')); ?>
                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-1-2">
                        <div class="uk-form-row">
                            <label>Course Name*</label>
                            <select id="val_select" required data-md-selectize onchange="course_duration(this)" name="course_id">
                                <?php
                                if (!empty($courselists)) {
                                    foreach ($courselists as $ky => $val) {
                                        ?>
                                        <option value="<?php echo $ky; ?>" <?php if ($details['TrainingScheduleCreation']['course_id'] == $ky) echo 'selected'; ?> ><?php echo $val; ?></option>
                                        <?php
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="uk-form-row">
                            <div class="uk-grid">
                                <div class="uk-width-medium-1-2">
                                    <label>Schedule Start Date*</label>
                                    <input type="text" class="md-input" name="sch_start_date" id="sch_start_date" value="<?php if (!empty($details['TrainingScheduleCreation']['sch_start_date'])) echo date('d-m-Y', strtotime($details['TrainingScheduleCreation']['sch_start_date'])) ?>"/>
                                </div>
                                <div class="uk-width-medium-1-2">
                                    <label>Schedule End Date*</label>
                                    <input type="text" class="md-input" name="sch_end_date" id="sch_end_date" value="<?php if (!empty($details['TrainingScheduleCreation']['sch_end_date'])) echo date('d-m-Y', strtotime($details['TrainingScheduleCreation']['sch_end_date'])); ?>"/>
                                </div>
                            </div>
                        </div>
                        <div class="uk-form-row">
                            <label>Contact Person</label>
                            <input type="text" class="md-input" value="<?php echo $details['TrainingScheduleCreation']['contact_person']; ?>" name="contact_person" id="contact_person"/>
                        </div>
                        <div class="uk-form-row">
                            <label>Contact Number</label>
                            <input type="text" class="md-input" value="<?php echo $details['TrainingScheduleCreation']['contact_number']; ?>" name="contact_number" id="contact_number" maxlength="10"/>
                        </div>
                        <div class="uk-form-row">
                            <label>Location</label>
                            <input type="text" class="md-input" value="<?php echo $details['TrainingScheduleCreation']['location']; ?>" name="location" id="location"/>
                        </div>
                        <div class="uk-form-row">
                            <label>Training Mode*</label>
                            <input type="text" class="md-input" value="<?php echo $details['TrainingScheduleCreation']['mode']; ?>" name="mode" id="mode" />
                        </div>
                        <div class="uk-form-row">
                            <div class="uk-width-medium-3-5">
                                <span class="icheck-inline">
                                    <input type="radio" name="status" value="0" <?php if ($details['TrainingScheduleCreation']['status'] == 0) echo 'checked'; ?> id="radio_demo_inline_1" data-md-icheck />
                                    <label for="radio_demo_inline_1" class="inline-label">Enable</label>
                                </span>
                                <span class="icheck-inline">
                                    <input type="radio" name="status" value="1" <?php if ($details['TrainingScheduleCreation']['status'] == 1) echo 'checked'; ?> id="radio_demo_inline_2" data-md-icheck />
                                    <label for="radio_demo_inline_2" class="inline-label">Disable</label>
                                </span>
                            </div>
                        </div>
                        <div class="uk-form-row">
                            <div class="uk-grid">
                                <div class="uk-width-medium-1-2">
                                    <span class="uk-input-group-addon"><button type="submit" class="md-btn">Save</button></span>
                                </div>
                                <div class="uk-width-medium-1-2">
                                    <span class="uk-input-group-addon"><a class="md-btn md-btn-wave waves-effect waves-button" href="<?php echo $this->webroot; ?>training/scheduleCourse/">Cancel</a></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="uk-width-medium-1-2">
                        <div class="uk-form-row">
                            <label>Course Duration</label>
                            <input type="text" id="course_duration_time" class="md-input label-fixed" value="" readonly=""/>
                        </div>
                        <div class="uk-form-row">
                            <div class="uk-grid">
                                <div class="uk-width-medium-1-2">
                                    <label>Schedule Start Time*</label>
                                    <input type="text" class="" name="sch_start_time" id="sch_start_time" value="<?php echo $details['TrainingScheduleCreation']['sch_start_time']; ?>"/>
                                </div>
                                <div class="uk-width-medium-1-2">
                                    <label>Schedule End Time*</label>
                                    <input type="text" class="" name="sch_end_time" id="sch_end_time" value="<?php echo $details['TrainingScheduleCreation']['sch_end_time']; ?>"/>
                                </div>
                            </div>
                        </div>
                        <div class="uk-form-row">
                            <label>Contact Mail</label>
                            <input type="text" class="md-input" value="<?php echo $details['TrainingScheduleCreation']['contact_email']; ?>" name="contact_email" id="contact_mail"/>
                        </div>
                        <div class="uk-form-row">
                            <label>Facility</label>
                            <input type="text" class="md-input" value="<?php echo $details['TrainingScheduleCreation']['facility']; ?>" name="facility"/>
                        </div>
                        <div class="uk-form-row">
                            <label>Instructor Name*</label>
<!--                            <input type="text" class="md-input" value="<?php echo $details['TrainingScheduleCreation']['instructor_name']; ?>" name="instructor_name" id="instructor_name"/>-->
                            <?php echo $this->Form->input('instructor_name', array('type' => 'select', 'label' => "", 'options' => $employeelist, 'class' => 'md-input', 'empty' => '--Choose--', 'id' => 'instructor_name', "data-md-selectize" => "data-md-selectize", "value" => $details['TrainingScheduleCreation']['instructor_name'])); ?>
                        </div>
                        <div class="uk-form-row">
                            <label>Final Registeration Date*</label>
                            <input type="text" class="md-input" value="<?php if (!empty($details['TrainingScheduleCreation']['final_regis_date'])) echo date('d-m-Y', strtotime($details['TrainingScheduleCreation']['final_regis_date'])); ?>" name="final_regis_date" id="final_regis_date"/>
                        </div>
                        <div class="uk-form-row" style="display: none;">
                            <div class="uk-grid">
                                <div class="uk-width-medium-1-2">
                                    <label>Enable Date</label>
                                    <input type="text" class="md-input" name="active_date" id="active_date" value="<?php if (!empty($details['TrainingScheduleCreation']['active_date'])) echo date('d-m-Y', strtotime($details['TrainingScheduleCreation']['active_date'])); ?>"/>
                                </div>
                                <div class="uk-width-medium-1-2">
                                    <label>Disable Date</label>
                                    <input type="text" class="md-input" name="inactive_date" id="inactive_date" value="<?php if (!empty($details['TrainingScheduleCreation']['inactive_date'])) echo date('d-m-Y', strtotime($details['TrainingScheduleCreation']['inactive_date'])); ?>"/>
                                    <input type="hidden" class="md-input" name="schedule_id" value="<?php echo $details['TrainingScheduleCreation']['schedule_id']; ?>"/>
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
    function course_duration(idd) {
        vl = jQuery(idd).val();
        jQuery.ajax({
            url: '<?php echo $this->webroot ?>training/getCourseDuration/' + vl,
            dataType: 'json',
            success: function (data) {
                if (data.TrainingCourseCreation.course_duration_type.toLowerCase() == 'm')
                    typeValue = data.TrainingCourseCreation.course_duration_time + ' Month';
                if (data.TrainingCourseCreation.course_duration_type.toLowerCase() == 'd')
                    typeValue = data.TrainingCourseCreation.course_duration_time + ' Day';
                if (data.TrainingCourseCreation.course_duration_type.toLowerCase() == 'h')
                    typeValue = data.TrainingCourseCreation.course_duration_time + ' Hour';
                if (data.TrainingCourseCreation.course_duration_type.toLowerCase() == 'y')
                    typeValue = data.TrainingCourseCreation.course_duration_time + ' Year';
                jQuery("#course_duration_time").trigger('click');
                jQuery("#course_duration_time").val(typeValue);
            }
        });
    }
    function course_durations(vl) {
        jQuery.ajax({
            url: '<?php echo $this->webroot ?>training/getCourseDuration/' + vl,
            dataType: 'json',
            success: function (data) {
                if (data.TrainingCourseCreation.course_duration_type.toLowerCase() == 'm')
                    typeValue = data.TrainingCourseCreation.course_duration_time + ' Month';
                if (data.TrainingCourseCreation.course_duration_type.toLowerCase() == 'd')
                    typeValue = data.TrainingCourseCreation.course_duration_time + ' Day';
                if (data.TrainingCourseCreation.course_duration_type.toLowerCase() == 'h')
                    typeValue = data.TrainingCourseCreation.course_duration_time + ' Hour';
                if (data.TrainingCourseCreation.course_duration_type.toLowerCase() == 'y')
                    typeValue = data.TrainingCourseCreation.course_duration_time + ' Year';
                jQuery("#course_duration_time").trigger('click');
                jQuery("#course_duration_time").val(typeValue);
            }
        });
    }
    jQuery(document).ready(function () {
        jQuery("#sch_start_date").datepicker({
            dateFormat: 'dd-mm-yy',
            minDate: '<?php echo date('d-m-Y'); ?>',
            inline: true,
            changeMonth: true,
            changeYear: true,
            autoclose: true,
        });
        jQuery("#final_regis_date").datepicker({
            dateFormat: 'dd-mm-yy',
            minDate: '<?php echo date('d-m-Y'); ?>',
            inline: true,
            changeMonth: true,
            changeYear: true,
            autoclose: true,
        });
        jQuery("#sch_end_date").datepicker({
            dateFormat: 'dd-mm-yy',
            minDate: '<?php echo date('d-m-Y'); ?>',
            inline: true,
            changeMonth: true,
            changeYear: true,
            autoclose: true
        });
        jQuery("#sch_start_date").attr("readonly", true);
        jQuery("#final_regis_date").attr("readonly", true);
        jQuery("#sch_end_date").attr("readonly", true);

        jQuery("#sch_start_time").kendoTimePicker({
            format: "hh:mm tt",
            interval: 5
        });
        $("#sch_start_time").attr("readonly", true);
        jQuery("#sch_end_time").kendoTimePicker({
            format: "hh:mm tt",
            interval: 5
        });
        $("#sch_end_time").attr("readonly", true);
        course_durations(jQuery("#val_select").val());
    });

    function addtype(idd) {
        var intRegex = /^\d+$/;
        var floatRegex = /^((\d+(\.\d *)?)|((\d*\.)?\d+))$/;
        var numberRegex = /^[+-]?\d+(\.\d+)?([eE][+-]?\d+)?$/;
        var regexp = /^[a-zA-Z0-9]+$/;
        var pattern = /^\d+$/;
        var mailpattern = /^([a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+(\.[a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+)*|"((([ \t]*\r\n)?[ \t]+)?([\x01-\x08\x0b\x0c\x0e-\x1f\x7f\x21\x23-\x5b\x5d-\x7e\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|\\[\x01-\x09\x0b\x0c\x0d-\x7f\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))*(([ \t]*\r\n)?[ \t]+)?")@(([a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.)+([a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.?$/i;
        var dateFirst = jQuery('#sch_start_date').val().split('-');
        var dateSecond = jQuery('#sch_end_date').val().split('-');
        var datethird = jQuery('#final_regis_date').val().split('-');
        var valuefirst = new Date(dateFirst[2], dateFirst[1], dateFirst[0]); //Year, Month, Date
        var valuesecond = new Date(dateSecond[2], dateSecond[1], dateSecond[0]);
        var valuethird = new Date(datethird[2], datethird[1], datethird[0]);

        if (jQuery("#val_select").val() == "") {
            $("#alerts").html("<div data-uk-alert='' class='uk-alert uk-alert-danger'><a class='uk-alert-close uk-close' href='#'></a>Please Select the Course Name.").show();
            $("html, body").animate({scrollTop: 0}, "slow");
            return false;
        } else if (jQuery('#sch_start_date').val() == "")
        {
            $("#alerts").html("<div data-uk-alert='' class='uk-alert uk-alert-danger'><a class='uk-alert-close uk-close' href='#'></a>Please enter the Schedule Start Date").show();
            $("html, body").animate({scrollTop: 0}, "slow");
            return false;
        } else if (jQuery('#sch_end_date').val() == "")
        {
            $("#alerts").html("<div data-uk-alert='' class='uk-alert uk-alert-danger'><a class='uk-alert-close uk-close' href='#'></a>Please enter the Schedule End Date").show();
            $("html, body").animate({scrollTop: 0}, "slow");
            return false;
        } else if (valuesecond < valuefirst) {
            $("#alerts").html("<div data-uk-alert='' class='uk-alert uk-alert-danger'><a class='uk-alert-close uk-close' href='#'></a>Schedule End Date should be greater or equal than Schedule Start Date").show();
            $("html, body").animate({scrollTop: 0}, "slow");
            return false;
        } else if (jQuery('#sch_start_time').val() == "")
        {
            $("#alerts").html("<div data-uk-alert='' class='uk-alert uk-alert-danger'><a class='uk-alert-close uk-close' href='#'></a>Please select the Schedule Start Time").show();
            $("html, body").animate({scrollTop: 0}, "slow");
            return false;
        } else if (jQuery('#sch_end_time').val() == "")
        {
            $("#alerts").html("<div data-uk-alert='' class='uk-alert uk-alert-danger'><a class='uk-alert-close uk-close' href='#'></a>Please select the Schedule End Time").show();
            $("html, body").animate({scrollTop: 0}, "slow");
            return false;
        }
//        else if (jQuery('#sch_start_time').val() == jQuery('#sch_end_time').val()) {
//            $("#alerts").html("<div data-uk-alert='' class='uk-alert uk-alert-danger'><a class='uk-alert-close uk-close' href='#'></a>Schedule Start and Schedule End time should not be same.").show();
//            $("html, body").animate({scrollTop: 0}, "slow");
//            return false;
//        }
        else if (jQuery('#final_regis_date').val() == "")
        {
            $("#alerts").html("<div data-uk-alert='' class='uk-alert uk-alert-danger'><a class='uk-alert-close uk-close' href='#'></a>Please select the Final Registeration Date").show();
            $("html, body").animate({scrollTop: 0}, "slow");
            return false;
        } else if (valuethird > valuefirst) {
            $("#alerts").html("<div data-uk-alert='' class='uk-alert uk-alert-danger'><a class='uk-alert-close uk-close' href='#'></a>Final Registeration Date should be below Schedule Start Date").show();
            $("html, body").animate({scrollTop: 0}, "slow");
            return false;
        }
        if ($.trim(jQuery('#contact_person').val()) != "")
        {
            check = jQuery('#contact_person').val();
            if (intRegex.test(check) || floatRegex.test(check)) {
                $("html, body").animate({scrollTop: 0}, "slow");
                $("#alerts").html("<div data-uk-alert='' class='uk-alert uk-alert-danger'><a class='uk-alert-close uk-close' href='#'></a>Enter Proper Contact Person Name").show();
                $("html, body").animate({scrollTop: 0}, "slow");
                return false;
            }
        }
        if ($.trim(jQuery('#contact_number').val()) != "")
        {
            check = jQuery('#contact_number').val();
            if (check.length != 10) {
                $("#alerts").html("<div class='uk-alert uk-alert-danger' data-uk-alert=''><a href='#' class='uk-alert-close uk-close'></a>Please Enter 10 digit Contact number</div>").show();
                $("html, body").animate({scrollTop: 0}, "slow");
                return false;
            }
            if (!pattern.test(check)) {
                $("#alerts").html("<div class='uk-alert uk-alert-danger' data-uk-alert=''><a href='#' class='uk-alert-close uk-close'></a>Enter valid Contact number</div>").show();
                $("html, body").animate({scrollTop: 0}, "slow");
                return false;
            }
        }
        if ($.trim(jQuery('#contact_mail').val()) != "")
        {
            check = jQuery('#contact_mail').val();
            if (!mailpattern.test(check)) {
                $("#alerts").html("<div class='uk-alert uk-alert-danger' data-uk-alert=''><a href='#' class='uk-alert-close uk-close'></a>Enter valid Email Id</div>").show();
                $("html, body").animate({scrollTop: 0}, "slow");
                return false;
            }
        }
        if ($.trim(jQuery('#location').val()) != "")
        {
            check = jQuery('#location').val();
            if (intRegex.test(check) || floatRegex.test(check)) {
                $("html, body").animate({scrollTop: 0}, "slow");
                $("#alerts").html("<div data-uk-alert='' class='uk-alert uk-alert-danger'><a class='uk-alert-close uk-close' href='#'></a>Enter Proper Location Name").show();
                $("html, body").animate({scrollTop: 0}, "slow");
                return false;
            }
        }
        if (jQuery('#instructor_name').val() == "")
        {
            $("html, body").animate({scrollTop: 0}, "slow");
            $("#alerts").html("<div data-uk-alert='' class='uk-alert uk-alert-danger'><a class='uk-alert-close uk-close' href='#'></a>Please Select Instructor Name").show();
            $("html, body").animate({scrollTop: 0}, "slow");
            return false;
        }
        if ($.trim(jQuery('#mode').val()) == "")
        {
            $("html, body").animate({scrollTop: 0}, "slow");
            $("#alerts").html("<div data-uk-alert='' class='uk-alert uk-alert-danger'><a class='uk-alert-close uk-close' href='#'></a>Please Enter Training Mode.").show();
            $("html, body").animate({scrollTop: 0}, "slow");
            return false;
        }
        ////////Check Date Time Compare Start///////////////
        var time = $("#sch_start_time").val();
        var hours = Number(time.match(/^(\d+)/)[1]);
        var minutes = Number(time.match(/:(\d+)/)[1]);
        var AMPM = time.match(/\s(.*)$/)[1];
        if (AMPM == "PM" && hours < 12)
            hours = hours + 12;
        if (AMPM == "AM" && hours == 12)
            hours = hours - 12;
        var sHours = hours.toString();
        var sMinutes = minutes.toString();
        if (hours < 10)
            sHours = "0" + sHours;
        if (minutes < 10)
            sMinutes = "0" + sMinutes;

        var Time1 = new Date(dateFirst[2], dateFirst[1], dateFirst[0], sHours, sMinutes);

        var time = $("#sch_end_time").val();
        var hours = Number(time.match(/^(\d+)/)[1]);
        var minutes = Number(time.match(/:(\d+)/)[1]);
        var AMPM = time.match(/\s(.*)$/)[1];
        if (AMPM == "PM" && hours < 12)
            hours = hours + 12;
        if (AMPM == "AM" && hours == 12)
            hours = hours - 12;
        var sHours = hours.toString();
        var sMinutes = minutes.toString();
        if (hours < 10)
            sHours = "0" + sHours;
        if (minutes < 10)
            sMinutes = "0" + sMinutes;

        var Time2 = new Date(dateSecond[2], dateSecond[1], dateSecond[0], sHours, sMinutes);
        // Should return true 
        if (Time1 >= Time2) {
            $("#alerts").html("<div data-uk-alert='' class='uk-alert uk-alert-danger'><a class='uk-alert-close uk-close' href='#'></a>Schedule End time must be greater than Schedule Start time.").show();
            $("html, body").animate({scrollTop: 0}, "slow");
            return false;
        }
        ////////Check Date Time Compare Ends///////////////
    }
</script>