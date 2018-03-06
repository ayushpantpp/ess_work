<div id="page_content">
    <div id="page_content_inner">
        <h3 class="heading_b uk-margin-bottom">Edit Course</h3>
        <?php echo $flash = $this->Session->flash(); ?>
        <div id="alerts"></div>
        <div class="md-card uk-margin-medium-bottom">
            <div class="md-card-content">
                <?php echo $this->Form->create('Training', array('url' => array('controller' => 'training', 'action' => 'updateCourseCreation'), 'id' => 'form_validation', 'enctype' => 'multipart/form-data', 'onsubmit' => 'return addtype(this)', 'class' => 'uk-form-stacked')); ?>
                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-1-2">
                        <div class="uk-form-row">
                            <label>Course Type*</label>
                            <select id="course_type" required data-md-selectize name="course_id">
                                <option value="0">Choose..</option>
                                <?php
                                if (!empty($courselists)) {
                                    foreach ($courselists as $ky => $val) {
                                        ?>
                                        <option value="<?php echo $ky; ?>" <?php if ($course['TrainingCourseCreation']['type_id'] == $ky) echo 'selected'; ?> ><?php echo $val; ?></option>

                                        <?php
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="uk-form-row">
                            <div class="uk-grid">
                                <div class="uk-width-medium-1-2">
                                    <label>Course Name*</label>
                                    <input type="text" class="md-input" name="course_name" id="course_name" value="<?php echo $course['TrainingCourseCreation']['name'] ?>" />
                                    <input type="hidden" class="md-input" name="courseid" id="coursename" value="<?php echo $courseid ?>" />
                                </div>
                                <div class="uk-width-medium-1-2">
                                    <label>Course Description</label>
                                    <input type="text" class="md-input" name="course_description" id="course_description" value="<?php echo $course['TrainingCourseCreation']['description'] ?>"/>
                                </div>
                            </div>
                        </div>
                        <div class="uk-form-row">
                            <div class="uk-grid">
                                <div class="uk-width-medium-1-2">
                                    <label>Course Duration*</label>
                                    <input type="text" class="md-input" name="course_duration" id="course_duration" value="<?php echo $course['TrainingCourseCreation']['course_duration_time'] ?>" maxlength="7"/>    
                                </div>
                                <div class="uk-width-medium-1-2">
                                    <select required data-md-selectize name="course_duration_type">
                                        <option value="Y" <?php if ($course['TrainingCourseCreation']['course_duration_type'] == "Y") echo 'selected'; ?>>Year</option>
                                        <option value="M" <?php if ($course['TrainingCourseCreation']['course_duration_type'] == "M") echo 'selected'; ?>>Month</option>
                                        <option value="D" <?php if ($course['TrainingCourseCreation']['course_duration_type'] == "D") echo 'selected'; ?>>Day</option>
                                        <option value="H" <?php if ($course['TrainingCourseCreation']['course_duration_type'] == "H") echo 'selected'; ?>>Hour</option>
                                    </select>     
                                </div>
                            </div>
                        </div>    
                        <div class="uk-form-row">
                            <div class="uk-grid">
                                <div class="uk-width-medium-1-2">    
                                    <label>Course Cost*</label>
                                    <input type="text" class="md-input"  name="course_Cost" id="course_Cost" value="<?php echo $course['TrainingCourseCreation']['cost'] ?>" maxlength="15"/>
                                </div>
                                <div class="uk-width-medium-1-2">
                                    <?php echo $this->Form->input('course_currency', array('type' => 'select', 'options' => $this->common->getTrainingCurrecny(), 'class' => 'md-input data-md-selectize', 'label' => false, 'required' => 'required', 'default' => $course['TrainingCourseCreation']['currency'])); ?>
                                </div>   
                            </div> 
                        </div>    
                        <div class="uk-form-row">
                            <label>Institute Name*</label>
                            <input type="text" class="md-input"  name="institute_name" id="institute_name" value="<?php echo $course['TrainingCourseCreation']['institute_name'] ?>"/>
                        </div>
                        <div class="uk-form-row">
                            <label>Maximum Course Capacity</label>
                            <input type="text" class="md-input" id="max_capacity" name="max_capacity" value="<?php echo $course['TrainingCourseCreation']['max_class_capacity'] ?>"  maxlength="10"/>
                        </div>
                        <div class="uk-form-row">
                            <label>Course Status</label>
                            <div class="uk-width-medium-3-5">
                                <span class="icheck-inline">
                                    <input type="radio" name="status" value="0"  id="radio_demo_inline_1" data-md-icheck checked="checked" />
                                    <label for="radio_demo_inline_1" class="inline-label">Active</label>
                                </span>
                                <span class="icheck-inline">
                                    <input type="radio" name="status" value="1" id="radio_demo_inline_2" data-md-icheck  <?php
                                    if ($course['TrainingCourseCreation']['status'] == 1) {
                                        echo 'checked="checked"';
                                    }
                                    ?>  />
                                    <label for="radio_demo_inline_2" class="inline-label">Inactive</label>
                                </span>
                            </div>
                        </div>
                        <div class="uk-form-row">
                            <div class="uk-grid">
                                <div class="uk-width-medium-1-2">
                                    <span class="uk-input-group-addon"><button type="submit" class="md-btn" onclick="return checkSubmit();">Save</button></span>
                                </div>
                                <div class="uk-width-medium-1-2">
                                    <span class="uk-input-group-addon"><a class="md-btn" href="<?php echo $this->webroot; ?>training/viewAllCourseCreation/">Cancel</a></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="uk-width-medium-1-2">
                        <div class="uk-form-row">
                            <label>Course Category*</label>
                            <select id="course_category" required data-md-selectize onchange="course_duration(this)" name="course_category">
                                <option value="0">Choose..</option>
                                <?php
                                if (!empty($coursecat)) {
                                    foreach ($coursecat as $ky => $val) {
                                        ?>
                                        <option value="<?php echo $ky; ?>" <?php if ($course['TrainingCourseCreation']['course_category_id'] == $ky) echo 'selected'; ?> ><?php echo $val; ?></option>
                                        <?php
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="uk-form-row">
                            <div class="uk-grid">
                                <div class="uk-width-medium-1-2">
                                    <label>Course Validity*</label>
                                    <select id="course_validity" required data-md-selectize onchange="course_duration(this)" name="course_validity">
                                        <option value="">Choose..</option>
                                        <?php
                                        if (!empty($coursevalidity)) {
                                            foreach ($coursevalidity as $ky => $val) {
                                                ?>
                                                <option value="<?php echo $ky; ?>" <?php if ($course['TrainingCourseCreation']['course_validity_id'] == $ky) echo 'selected'; ?> ><?php echo $this->Common->getTrainingValidityMasterName($val); ?></option>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>

                            </div>
                        </div>

                        <div class="uk-form-row">
                            <div class="uk-grid">
                                <div class="uk-width-medium-1-2">

                                    <input type="hidden" class="md-input" readonly name="active_date" id="active_date"/>
                                </div>
                                <div class="uk-width-medium-1-2">

                                    <input type="hidden" class="md-input" readonly name="inactive_date" id="inactive_date"/>
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

    function checkSubmit() {

        var intRegex = /^\d+$/;
        var floatRegex = /^((\d+(\.\d *)?)|((\d*\.)?\d+))$/;
        var str = $('#course_name').val();
        var course_type = $('#course_type').val();
        var regExp = /^0[0-9].*$/

        if (course_type == 0) {
            $("html, body").animate({scrollTop: 0}, "slow");
            $("#alerts").html("<div data-uk-alert='' class='uk-alert uk-alert-danger'><a class='uk-alert-close uk-close' href='#'></a>Choose Course Type").show();
            $("html, body").animate({scrollTop: 0}, "slow");
            return false;
        }
        var course_cat = $('#course_category').val();
        if (course_cat == 0) {
            $("html, body").animate({scrollTop: 0}, "slow");
            $("#alerts").html("<div data-uk-alert='' class='uk-alert uk-alert-danger'><a class='uk-alert-close uk-close' href='#'></a>Choose Course Category").show();
            $("html, body").animate({scrollTop: 0}, "slow");
            return false;
        }
        var course_val = $('#course_validity').val();
        if (course_val == 0) {
            $("html, body").animate({scrollTop: 0}, "slow");
            $("#alerts").html("<div data-uk-alert='' class='uk-alert uk-alert-danger'><a class='uk-alert-close uk-close' href='#'></a>Choose Course Validity").show();
            $("html, body").animate({scrollTop: 0}, "slow");
            return false;
        }
        if (!str || jQuery.trim(str) == "") {
            $("html, body").animate({scrollTop: 0}, "slow");
            $("#alerts").html("<div data-uk-alert='' class='uk-alert uk-alert-danger'><a class='uk-alert-close uk-close' href='#'></a>Please Enter Course Name").show();
            $("html, body").animate({scrollTop: 0}, "slow");
            return false;
        }
        if (intRegex.test(str) || floatRegex.test(str)) {
            $("html, body").animate({scrollTop: 0}, "slow");
            $("#alerts").html("<div data-uk-alert='' class='uk-alert uk-alert-danger'><a class='uk-alert-close uk-close' href='#'></a>Enter Proper Course Name").show();
            $("html, body").animate({scrollTop: 0}, "slow");
            return false;

        }
        var course_duration = $('#course_duration').val();
        if (course_duration == '') {
            $("html, body").animate({scrollTop: 0}, "slow");
            $("#alerts").html("<div data-uk-alert='' class='uk-alert uk-alert-danger'><a class='uk-alert-close uk-close' href='#'></a>Please enter course duration.").show();
            $("html, body").animate({scrollTop: 0}, "slow");
            return false;
        }
        if (!floatRegex.test(course_duration)) {
            $("html, body").animate({scrollTop: 0}, "slow");
            $("#alerts").html("<div data-uk-alert='' class='uk-alert uk-alert-danger'><a class='uk-alert-close uk-close' href='#'></a>Course Duration must be numeric").show();
            $("html, body").animate({scrollTop: 0}, "slow");
            return false;

        }
        if (regExp.test(course_duration)) {
            $("html, body").animate({scrollTop: 0}, "slow");
            $("#alerts").html("<div data-uk-alert='' class='uk-alert uk-alert-danger'><a class='uk-alert-close uk-close' href='#'></a>Course Duration must be numeric.").show();
            $("html, body").animate({scrollTop: 0}, "slow");
            return false;
        }
        if (!intRegex.test(course_duration)) {
            $("html, body").animate({scrollTop: 0}, "slow");
            $("#alerts").html("<div data-uk-alert='' class='uk-alert uk-alert-danger'><a class='uk-alert-close uk-close' href='#'></a>Course Duration must be numeric.").show();
            $("html, body").animate({scrollTop: 0}, "slow");
            return false;
        }
        if (course_duration == 0) {
            $("html, body").animate({scrollTop: 0}, "slow");
            $("#alerts").html("<div data-uk-alert='' class='uk-alert uk-alert-danger'><a class='uk-alert-close uk-close' href='#'></a>Course Duration must be numeric.").show();
            $("html, body").animate({scrollTop: 0}, "slow");
            return false;
        }
        var course_cost = $('#course_Cost').val();
        if (course_cost == '') {
            $("html, body").animate({scrollTop: 0}, "slow");
            $("#alerts").html("<div data-uk-alert='' class='uk-alert uk-alert-danger'><a class='uk-alert-close uk-close' href='#'></a>Please enter course cost.").show();
            $("html, body").animate({scrollTop: 0}, "slow");
            return false;
        }
        if (!floatRegex.test(course_cost)) {
            $("html, body").animate({scrollTop: 0}, "slow");
            $("#alerts").html("<div data-uk-alert='' class='uk-alert uk-alert-danger'><a class='uk-alert-close uk-close' href='#'></a>Course Cost must be numeric").show();
            $("html, body").animate({scrollTop: 0}, "slow");
            return false;
        }
        if (regExp.test(course_cost)) {
            $("html, body").animate({scrollTop: 0}, "slow");
            $("#alerts").html("<div data-uk-alert='' class='uk-alert uk-alert-danger'><a class='uk-alert-close uk-close' href='#'></a>Course Cost must be numeric.").show();
            $("html, body").animate({scrollTop: 0}, "slow");
            return false;
        }

        var ins_name = $('#institute_name').val();
        if (intRegex.test(ins_name) || floatRegex.test(ins_name) || ins_name === "") {
            $("html, body").animate({scrollTop: 0}, "slow");
            $("#alerts").html("<div data-uk-alert='' class='uk-alert uk-alert-danger'><a class='uk-alert-close uk-close' href='#'></a>Enter Proper Institute Name").show();
            $("html, body").animate({scrollTop: 0}, "slow");
            return false;

        }
        var max_capacity = $('#max_capacity').val();
        if ($.trim(max_capacity) != '') {
            if (!floatRegex.test(max_capacity)) {
                $("html, body").animate({scrollTop: 0}, "slow");
                $("#alerts").html("<div data-uk-alert='' class='uk-alert uk-alert-danger'><a class='uk-alert-close uk-close' href='#'></a>Maximum Course Capacity must be Integer").show();
                $("html, body").animate({scrollTop: 0}, "slow");
                return false;
            }
            if (regExp.test(max_capacity)) {
                $("html, body").animate({scrollTop: 0}, "slow");
                $("#alerts").html("<div data-uk-alert='' class='uk-alert uk-alert-danger'><a class='uk-alert-close uk-close' href='#'></a>Maximum Course Capacity must be Integer.").show();
                $("html, body").animate({scrollTop: 0}, "slow");
                return false;
            }
            if (!intRegex.test(max_capacity)) {
                $("html, body").animate({scrollTop: 0}, "slow");
                $("#alerts").html("<div data-uk-alert='' class='uk-alert uk-alert-danger'><a class='uk-alert-close uk-close' href='#'></a>Maximum Course Capacity must be Integer.").show();
                $("html, body").animate({scrollTop: 0}, "slow");
                return false;
            }
            if (max_capacity == 0) {
                $("html, body").animate({scrollTop: 0}, "slow");
                $("#alerts").html("<div data-uk-alert='' class='uk-alert uk-alert-danger'><a class='uk-alert-close uk-close' href='#'></a>Maximum Course Capacity must be some number.").show();
                $("html, body").animate({scrollTop: 0}, "slow");
                return false;
            }
        }

    }


</script>