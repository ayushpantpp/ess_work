<div id="page_content">
    <div id="page_content_inner">
        <h3 class="heading_b uk-margin-bottom">Training PMS Initiation Request Form</h3>
        <?php echo $flash = $this->Session->flash(); ?>
        <div id="alerts"></div>
        <div class="md-card uk-margin-medium-bottom">
            <div class="md-card-content">
                <?php echo $this->Form->create('Training', array('url' => array('controller' => 'training', 'action' => ''), 'id' => 'form_validation', 'enctype' => 'multipart/form-data', 'onsubmit' => 'return addtype(this)', 'class' => 'uk-form-stacked')); ?>
                <div class="uk-grid uk-grid-divider" data-uk-grid-margin>
                    <div class="uk-width-medium-1-2">
                        <div class="uk-form-row">
                            <label><b>Course Name*</b></label>
                            <select id="course_id" class="md-input data-md-selectize label-fixed" name="course_id">
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
                        <div class="uk-form-row">
                            <label><b>Training Date*</b></label>
                            <input type="text" class="md-input label-fixed" name="training_date" id="training_date" />
                        </div>
                    </div>
                    <div class="uk-width-medium-1-2">
                        <div class="uk-form-row">
                            <label><b style="color: #727272; font-size: 12px;">Training Request Description</b></label>
                            <textarea class="md-input" name="requirement" data-parsley-trigger="keyup"></textarea>
                        </div>
                    </div>
                    <div class="uk-width-medium-1-2">
                        <div class="uk-form-row">
                            <label><b style="color: #727272; font-size: 12px;">Remarks</b></label>
                            <textarea class="md-input" name="remarks" data-parsley-trigger="keyup"></textarea>
                        </div>
                    </div>
                    <div class="uk-width-medium-1-3">
                        <div class="uk-form-row">
                            <label><b style="color: #727272; font-size: 12px;">Training Duration Time*</b></label>
                            <input type="text" class="" name="training_time" id="training_time" />
                        </div>
                    </div>
                    <div class="uk-width-medium-1-3">
                        <div class="uk-form-row">
                            <label><b style="color: #727272; font-size: 12px;">Instructor Name</b></label>
                            <?php echo $this->Form->input('training_instructor_name', array('type' => 'select', 'label' => false, 'options' => $employeelist, 'class' => 'md-input', 'empty' => '--Choose--', 'id' => 'instructor_name', "data-md-selectize" => "data-md-selectize")); ?>
                        </div>
                    </div>
                    <div class="uk-width-medium-1-3">
                        <div class="uk-form-row">
                            <label for="message"><b style="color: #727272; font-size: 12px;">Self Include</b></label>
                            <input type="checkbox" class="" name="self" value="1" id="self"/>
                        </div>
                    </div>
                    <div class="uk-width-medium-1-3">
                        <div class="uk-form-row">
                            <label for="message"><b style="color: #727272; font-size: 12px;">List of Employees:</b></label>
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

    jQuery(document).ready(function () {
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

        jQuery("#training_time").kendoTimePicker({
            format: "HH:mm",
            interval: 5
        });
        jQuery("#training_time").attr("readonly", true);
        jQuery("#training_date").datepicker({
            dateFormat: 'dd-mm-yy',
            inline: true,
            endDate: 'today',
            changeMonth: true,
            changeYear: true,
            autoclose: true,
            minDate: '0',
        });
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
        var training_date = $('#training_date').val();
        if (training_date === "") {
            $("html, body").animate({scrollTop: 0}, "slow");
            $("#alerts").html("<div data-uk-alert='' class='uk-alert uk-alert-danger'><a class='uk-alert-close uk-close' href='#'></a>Enter Training Date").show();
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

        var training_time = $('#training_time').val();
        if (training_time === "") {
            $("html, body").animate({scrollTop: 0}, "slow");
            $("#alerts").html("<div data-uk-alert='' class='uk-alert uk-alert-danger'><a class='uk-alert-close uk-close' href='#'></a>Please select Training Duration Time").show();
            $("html, body").animate({scrollTop: 0}, "slow");
            return false;
        }
        if (training_time == '00:00') {
            $("html, body").animate({scrollTop: 0}, "slow");
            $("#alerts").html("<div data-uk-alert='' class='uk-alert uk-alert-danger'><a class='uk-alert-close uk-close' href='#'></a>Please select Training Duration Time above 00:00.").show();
            $("html, body").animate({scrollTop: 0}, "slow");
            return false;
        }

        if (ct == 0) {
            $("html, body").animate({scrollTop: 0}, "slow");
            $("#alerts").html("<div data-uk-alert='' class='uk-alert uk-alert-danger'><a class='uk-alert-close uk-close' href='#'></a>Please select At least one Trainees.").show();
            $("html, body").animate({scrollTop: 0}, "slow");
            return false;
        }
    }
</script>