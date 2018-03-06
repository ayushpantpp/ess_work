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

<div id="page_content" role="main">
    <div id="page_content_inner">        
        <h3 class="heading_b uk-margin-bottom">View Training Evolution Matrix Form</h3>
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
                                    <th  class="uk-text-center md-bg-blue-100 uk-text-small">Certificate Date</th>
                                </tr>
                                <?php
                                $i = 0;
                                foreach ($training['TrainingEmployee'] as $emptraining) {
                                    $details = $this->Common->getEmployeeMatrixDetail($emptraining, $training['TrainingCreation']['training_id']);
                                    ?>
                                    <tr>
                                        <td><?php echo $this->Common->getempid($emptraining['trainee_code']); ?><input type="hidden" class="md-input" name="trainee_code[<?php echo $i ?>]" value="<?php echo $emptraining['trainee_code']; ?>" readonly/></td>    
                                        <td><?php echo $this->Common->getempname($emptraining['trainee_code']); ?></td>    
                                        <td><?php echo $this->Common->findDepartmentName($emptraining['dept_code'], $emptraining['trainee_comp_code']); ?></td>   
                                        <td><?php echo $this->Common->findDesignationName($emptraining['desg_code'], $emptraining['trainee_comp_code']); ?></td>    
                                        <td><input type="checkbox" class="md-input" name="passed_check[<?php echo $i ?>]" id="passed_check_<?php echo $i ?>" value="1" <?php if ($details['TrainingDtMatrix']['passed'] == 1) echo 'checked'; ?>/>
                                        </td>
                                        <td><input type="checkbox" class="md-input" name="fail_check[<?php echo $i ?>]" id="fail_check_<?php echo $i ?>" value="1" <?php if ($details['TrainingDtMatrix']['fail'] == 1) echo 'checked'; ?>/></td>
                                        <td><input type="checkbox" class="md-input" name="present[<?php echo $i ?>]" <?php echo $sts; ?> value="1" <?php if ($details['TrainingDtMatrix']['present'] == 1) echo 'checked'; ?>/>
                                        </td>
                                        <td><input type="checkbox" class="md-input" name="no_show[<?php echo $i ?>]" id="no_show[<?php echo $i ?>]" <?php echo $sts1; ?> value="1" <?php if ($details['TrainingDtMatrix']['no_show'] == 1) echo 'checked'; ?>/>
                                        </td>
                                        <td><?php echo $this->Form->input("validity_name_$i", array('type' => 'select', 'options' => $this->Common->getTrainingValidityList(), 'class' => 'md-input', 'label' => false, 'required' => 'required', 'id' => "validity_name_$i", 'default' => $details['TrainingDtMatrix']['course_validity'])); ?></td>
                                        <td>
                                            <input type="text" class="md-input" name="score[<?php echo $i ?>]" value="<?php echo $details['TrainingDtMatrix']['score']; ?>" readonly/>
                                        </td>
                                        <td><input type="text" class="md-input" name="certificate[<?php echo $i ?>]" value="<?php echo $details['TrainingDtMatrix']['certificate']; ?>" readonly/></td>
                                        <td><input type="text" class="md-input" name="iwcf_date[<?php echo $i ?>]" value="<?php if($details['TrainingDtMatrix']['iwcf_date'] != '0000-00-00') echo date('d-m-Y', strtotime($details['TrainingDtMatrix']['iwcf_date'])); ?>" readonly /></td>
                                    </tr>
                                    <?php
                                    unset($sts, $sts1);
                                    $i++;
                                }
                                ?>
                            </table>
                        </div>
                        <br/><br/>
                    </div>
                </div>
                <br>
                <br>



            </div>                
        </div>
    </div>
</div>    
<?php //$this->Form->end();          ?>   






