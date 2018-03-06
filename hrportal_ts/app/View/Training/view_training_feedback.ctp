<div id="page_content">
    <div id="page_content_inner">
        <h3 class="heading_b uk-margin-bottom">View Training Evaluation Form</h3>
        <div class="md-card uk-margin-medium-bottom">
            <div class="md-card-content">
                <div class="uk-overflow-container">
                    <table class="uk-table uk-table-striped">
                        <tbody>
                            <tr>
                                <td><strong>Training Programme : </strong></td>
                                <td><?php echo strtoupper($vals['TrainingCourseCreation']['name']); ?></td>
                            </tr>
                            <tr>
                                <td><strong>Name of the Trainee : </strong></td>
                                <td><?php echo $this->Common->findEmpName($details['TrainingFeedback']['emp_code']); ?></td>
                            </tr>
                            <tr>
                                <td><strong>Training Date(s) : </strong></td>
                                <td><?php echo date('d-M-Y', strtotime($vals['TrainingCreation']['training_date'])); ?></td>
                            </tr>
                            <tr>
                                <td><strong>Duration : </strong></td>
                                <td><?php echo $vals['TrainingCreation']['training_start_time']; ?></td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="travel-voucher">
                        <h3>Overall</h3>
                        <h4> 1. How do you rate the following: </h4>
                        <table>
                            <tbody>
                                <tr>
                                    <td>Quality of course material</td>
                                    <td>
                                        <?php echo $this->Form->input('TrainingFeedback.rate_quality', array('div' => false, 'label' => false, 'type' => 'select', 'options' => array('' => 'Select') + $listvalues, 'class' => 'md-input','value' => $details['TrainingFeedback']['rate_quality'])); ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Contents of training course</td>
                                    <td>
                                        <?php echo $this->Form->input('TrainingFeedback.rate_contents', array('div' => false, 'label' => false, 'type' => 'select', 'options' => array('' => 'Select') + $listvalues, 'class' => 'md-input','value' => $details['TrainingFeedback']['rate_contents'])); ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Administrative arrangements</td>
                                    <td>
                                        <?php echo $this->Form->input('TrainingFeedback.rate_admin', array('div' => false, 'label' => false, 'type' => 'select', 'options' => array('' => 'Select') + $listvalues, 'class' => 'md-input','value' => $details['TrainingFeedback']['rate_admin'])); ?>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <table>
                            <tbody>
                                <tr>
                                    <td><strong> 2. Do you think there are sessions/subjects that should be eliminated? </strong> &nbsp;&nbsp;&nbsp;</td>
                                    <td>
                                        <?php echo $this->Form->input('TrainingFeedback.session_eliminate', array('div' => false, 'label' => false, 'type' => 'select', 'options' => array('' => 'Select') + $decissionlistvalues, 'class' => 'md-input','value' => $details['TrainingFeedback']['session_eliminate']));
                                        ?>				
                                    </td>
                                </tr>
                                <tr>
                                    <td> If yes, briefly indicate session/subjects and reasons.
                                        <br>
                                        <?php
                                        echo $this->Form->input('TrainingFeedback.session_desc', array('label' => false, 'div' => false, 'class' => 'md-input', 'cols' => "50", 'style' => "width: 332px; height: 77px;", 'type' => 'textarea', 'maxlength' => 1000,'value' => $details['TrainingFeedback']['session_desc']));
                                        ?>                   
                                    </td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td><strong>3. Do you think that any other additional sessions/subjects should have been included?</strong></td>
                                    <td>
                                        <?php echo $this->Form->input('TrainingFeedback.additional_sess_eliminate', array('div' => false, 'label' => false, 'type' => 'select', 'options' => array('' => 'Select') + $decissionlistvalues, 'class' => 'md-input','value' => $details['TrainingFeedback']['additional_sess_eliminate'])); ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td> If yes, briefly indicate the sessions/subjects and reasons.
                                        <br>
                                        <?php
                                        echo $this->Form->input('TrainingFeedback.additional_sess_desc', array('label' => false, 'div' => false, 'class' => 'md-input', 'cols' => "50", 'style' => "width: 332px; height: 77px;", 'type' => 'textarea', 'maxlength' => 1000,'value' => $details['TrainingFeedback']['additional_sess_desc']));
                                        ?>
                                    </td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td><strong>4. Do you think that the duration of the training programme was:</strong></td>
                                    <td>
                                        <?php echo $this->Form->input('TrainingFeedback.duration_training_prog', array('div' => false, 'label' => false, 'type' => 'select', 'options' => array('' => 'Select') + $TIMelistvalues, 'class' => 'md-input','value' => $details['TrainingFeedback']['duration_training_prog'])); ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>5. Was the amount of time appropriated to each subject adequate?</strong></td>
                                    <td>
                                        <?php echo $this->Form->input('TrainingFeedback.amt_time_appro', array('div' => false, 'label' => false, 'type' => 'select', 'options' => array('' => 'Select') + $decissionlistvalues, 'class' => 'md-input','value' => $details['TrainingFeedback']['amt_time_appro'])); ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>If no, how should it be modified?<br>
                                        <?php echo $this->Form->input('TrainingFeedback.amt_time_appro_desc', array('label' => false, 'div' => false, 'rows' => "1", 'class' => 'md-input', 'cols' => "50", 'style' => "width: 332px; height: 77px;", 'type' => 'textarea', 'maxlength' => 1000,'value' => $details['TrainingFeedback']['amt_time_appro_desc'])); ?>
                                    </td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td><strong>6. Are you satisfied with the training? </strong></td>
                                    <td>
                                        <?php echo $this->Form->input('TrainingFeedback.satisfied', array('div' => false, 'label' => false, 'type' => 'select', 'options' => array('' => 'Select') + $decissionlistvalues, 'class' => 'md-input','value' => $details['TrainingFeedback']['satisfied'])); ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Please state reasons in both the cases. <strong>(It is compulsory to answer this question)</strong>
                                        <br><?php
                                        echo $this->Form->input('TrainingFeedback.satisfied_desc', array('label' => false, 'div' => false, 'rows' => "1", 'class' => 'md-input', 'cols' => "50", 'style' => "width: 332px; height: 77px;", 'type' => 'textarea', 'maxlength' => 1000,'value' => $details['TrainingFeedback']['satisfied_desc']));
                                        echo $this->Form->input('TrainingFeedback.nu_train_id', array('div' => false, 'label' => false, 'type' => 'hidden', 'value' => $training_id));
                                        ?>                 
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="travel-voucher">
                        <h4>Session Wise</h4>
                        <br>For each session, please assign rating to trainer on the given parameters:<br>
                        <table class="uk-table">
                            <thead>
                                <tr>
                                    <th><strong>S.N.</strong></th>
                                    <th><strong>Session Name</strong></th>
                                    <th><strong>Trainer Name</strong></th>
                                    <th><strong>Trainer's Presentation Skills</strong></th>
                                    <th><strong>Trainer's Subject Knowledge</strong></th>
                                    <th><strong>Trainer's Ability to Handle Queries</strong></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                <tr>
                                    <td><?php echo $i; ?></td>
                                    <td><?php echo strtoupper($vals['TrainingCourseCreation']['name']); ?></td>
                                    <td><?php echo $this->Common->findEmpName($vals['TrainingScheduleCreation']['instructor_name']); ?></td>
                                    <td>
                                        <?php echo $this->Form->input('TrainingTrainerFeedback.rate_present', array('div' => false, 'label' => false, 'type' => 'select', 'options' => array('' => 'Select') + $listvalues, 'class' => 'md-input','value' => $details['trainers']['rate_present'])); ?>
                                    </td>
                                    <td>
                                        <?php echo $this->Form->input('TrainingTrainerFeedback.subject_know', array('div' => false, 'label' => false, 'type' => 'select', 'options' => array('' => 'Select') + $listvalues, 'class' => 'md-input','value' => $details['trainers']['subject_know'])); ?>
                                    </td>
                                    <td>
                                        <?php
                                        echo $this->Form->input('TrainingTrainerFeedback.handle_query', array('div' => false, 'label' => false, 'type' => 'select', 'options' => array('' => 'Select') + $listvalues, 'class' => 'md-input','value' => $details['trainers']['handle_query']));
                                        echo $this->Form->input('f_id', array('div' => false, 'label' => false, 'type' => 'hidden', 'class' => 'round_select', 'value' => base64_encode($vals['TrainingCreation']['training_id'])));
                                        ?>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>