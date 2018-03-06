<div class="uk-width-medium-1-4">
    <div id="modal_overflow" class="uk-modal">
        <div class="uk-modal-dialog uk-modal-dialog-medium">
            <button type="button" class="uk-modal-close uk-close"></button>            
            <div class="uk-overflow-container">
                <span id="empResponse" class="verflow container"></span>
            </div>          
        </div>
    </div>
</div>
<style>
    input[type="checkbox"][readonly] {
        pointer-events: none;
    }
</style>
<div id="page_content" role="main">
    <div id="page_content_inner">        
        <h3 class="heading_b uk-margin-bottom">Training Evolution Matrix  Form</h3>
        <?php
        $auth = $this->Session->read('Auth');
        echo $flash = $this->Session->flash();
        ?>
        <div id="alerts"></div>
        <div class="md-card">
            <div class="md-card-content large-padding">                   
                <div class="uk-overflow-container">
                    <table class="uk-table uk-table-condensed">
                        <tr>
                            <td>Schedule Id :</td>
                            <td><?php echo $training['TrainingCreation']['schedule_id']; ?></td>
                            <td>Course Name :</td>
                            <td><?php $course_id = $training['TrainingCreation']['course_id']; ?>
                                <?php echo $this->Common->getTrainingClassName($course_id); ?></td>
                        </tr>
                        <tr>
                            <td>Course Start Date :</td>
                            <td>   <?php echo date('d-M-Y', strtotime($training['TrainingScheduleCreation']['sch_start_date'])); ?></td>
                            <td>Course End Date :</td>
                            <td>   <?php echo date('d-M-Y', strtotime($training['TrainingScheduleCreation']['sch_end_date'])); ?>
                                <?php $iwcf = $this->Common->getIWCFDate($training['TrainingScheduleCreation']['sch_end_date'], $this->Common->getTrainingValidityId($training['TrainingCourseCreation']['course_validity_id'])); ?>
                            </td>
                        </tr>
                    </table>               
                    <div class="margin-bottom">&nbsp;</div>

                    <div class="md-card-content">
                        <?php echo $this->Form->create('Evaluate', array('url' => array('controller' => 'training', 'action' => 'saveEvaluation'), 'id' => 'form_validation', 'name' => 'matrix', 'class' => 'uk-form-stacked')); ?>
                        <div class="uk-overflow-container">
                            <table border="1" class="uk-table uk-tab-responsive" id="TextBoxesGroup">
                                <tr>
                                    <th  class="uk-text-center md-bg-blue-100 uk-text-small">Employee ID </th>
                                    <th  class="uk-text-center md-bg-blue-100 uk-text-small">Employee Name </th>
                                    <th  class="uk-text-center md-bg-blue-100 uk-text-small">Department</th>
                                    <th  class="uk-text-center md-bg-blue-100 uk-text-small">Designation</th>
                                    <th  class="uk-text-center md-bg-blue-100 uk-text-small">Passed</th>
                                    <th  class="uk-text-center md-bg-blue-100 uk-text-small">Failed</th>
                                    <th  class="uk-text-center md-bg-blue-100 uk-text-small">Present</th>
                                    <th  class="uk-text-center md-bg-blue-100 uk-text-small">No Show</th>
                                    <th  class="uk-text-center md-bg-blue-100 uk-text-small">Course Validity</th>
                                    <th  class="uk-text-center md-bg-blue-100 uk-text-small">Score</th>
                                    <th  class="uk-text-center md-bg-blue-100 uk-text-small">Certificate</th>
                                    <th  class="uk-text-center md-bg-blue-100 uk-text-small">Certificate Date<input type="hidden" name="training_id" value="<?php echo $training['TrainingCreation']['training_id']; ?>">
                                    </th>
                                </tr>
                                <?php
                                $i = 0;
                                foreach ($training['TrainingEmployee'] as $emptraining) {
                                    if ($this->Common->chkEmployeeAttendence($training['TrainingCreation']['training_id'], $emptraining['trainee_code'])) {
                                        $sts = 'checked';
                                    } else {
                                        $sts1 = 'checked';
                                    }
                                    ?>
                                    <tr>
                                        <td><?php echo $this->Common->getempid($emptraining['trainee_code']); ?><input type="hidden" class="md-input" name="trainee_code[<?php echo $i ?>]" value="<?php echo $emptraining['trainee_code']; ?>" readonly/></td>    
                                        <td><?php echo $this->Common->getempname($emptraining['trainee_code']); ?></td>    
                                        <td><?php echo $this->Common->findDepartmentName($emptraining['dept_code'], $emptraining['trainee_comp_code']); ?></td>   
                                        <td><?php echo $this->Common->findDesignationName($emptraining['desg_code'], $emptraining['trainee_comp_code']); ?></td>    
                                        <td><input type="checkbox" class="md-input" name="passed_check[<?php echo $i ?>]" id="passed_check_<?php echo $i ?>" <?php echo $sts; ?> value="1" readonly/>
                                        </td>
                                        <td><input type="checkbox" class="md-input" name="fail_check[<?php echo $i ?>]" id="fail_check_<?php echo $i ?>" <?php echo $sts1; ?> value="1" readonly/></td>
                                        <td><input type="checkbox" class="md-input epresent" name="present[<?php echo $i ?>]" <?php echo $sts; ?> value="1" readonly id="epresent_<?php echo $i; ?>"/>
                                        </td>
                                        <td><input type="checkbox" class="md-input npresent" name="no_show[<?php echo $i ?>]" id="no_show[<?php echo $i ?>]" <?php echo $sts1; ?> value="1" readonly id="npresent_<?php echo $i; ?>"/>
                                        </td>
                                        <td><?php echo $this->Form->input("validity_name_$i", array('type' => 'select', 'options' => $this->Common->getTrainingValidityList(), 'class' => 'md-input', 'label' => false, 'required' => 'required', 'id' => "validity_name_$i", 'default' => $this->Common->getTrainingValidityId($training['TrainingCourseCreation']['course_validity_id']))); ?></td>
                                        <td>
                                            <input type="text" class="md-input" name="score[<?php echo $i ?>]" id="score_<?php echo $i ?>"/>
                                        </td>
                                        <td><input type="text" class="md-input" name="certificate[<?php echo $i ?>]"  id="certificate_<?php echo $i ?>"/></td>
                                        <td><input type="text" class="md-input" name="iwcf_date[<?php echo $i ?>]" value="<?php echo $iwcf; ?>" readonly /></td>
                                    </tr>
                                    <?php
                                    unset($sts, $sts1);
                                    $i++;
                                }
                                ?>
                            </table>
                        </div>
                        <br/><br/>
                        <div class="uk-grid">
                            <div class="uk-width-1-1"> 
                                <input type='submit' class="md-btn md-btn-primary plusbtn"  value='Evaluate' id='addButton' onclick="return checkSubmit();">
                                <a class="md-btn md-btn-wave waves-effect waves-button" href="<?php echo $this->webroot; ?>training/listevolutionMatrix">Cancel</a>
                            </div>
                        </div>
                        <?php echo $this->Form->end(); ?>
                    </div>
                </div>
                <br>
                <br>



            </div>                
        </div>
    </div>
</div>
<script>

    function checkSubmit() {
        q = 0;
        jQuery(".epresent:checked").each(function () {
            idd = jQuery(this).attr('id').replace(/[^\d.]/g, '');
            if (jQuery('#score_' + idd).val().trim() == '') {
                q++;
            }
        });
        if (q > 0) {
            $("html, body").animate({scrollTop: 0}, "slow");
            $("#alerts").html("<div data-uk-alert='' class='uk-alert uk-alert-danger'><a class='uk-alert-close uk-close' href='#'></a>If any employee marked as a present their score can not be empty.").show();
            $("html, body").animate({scrollTop: 0}, "slow");
            return false;
        }
    }

</script>
