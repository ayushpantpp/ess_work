<div id="page_content" role="main">
    <div id="page_content_inner">
        <h3 class="heading_b uk-margin-bottom">Online Training Attendance</h3>
        <?php echo $flash = $this->Session->flash(); ?>
        <div class="md-card">
            <div class="md-card-content large-padding">
                <?php echo $this->Form->create('Training', array('url' => array('controller' => 'training', 'action' => 'saveOpenAttendence'), 'id' => 'form_validation', 'enctype' => 'multipart/form-data', 'onsubmit' => 'return addtype(this)', 'class' => 'uk-form-stacked')); ?>
                <?php
                $dept_code = $_SESSION['Auth']['MyProfile']['dept_code'];
                $comp_code = $_SESSION['Auth']['MyProfile']['comp_code'];
                ?>
                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-1-3">
                        <div class="parsley-row">
                            <label><b>Training Name: </b></label>
                            <span><?php echo $this->Common->getTrainingClassName($vals['TrainingCreation']['course_id']); ?></span>
                        </div>
                    </div>
                    <div class="uk-width-medium-1-3">
                        <div class="parsley-row">
                            <label for="title"><b>Training Type: </b></label>
                            <span><?php
                                if ($vals['TrainingCreation']['initated_by'] == 'I')
                                    echo 'Indentification';
                                elseif ($vals['TrainingCreation']['initated_by'] == 'E')
                                    echo 'Enrollment';
                                elseif ($vals['TrainingCreation']['initated_by'] == 'P')
                                    echo 'Perforamce Management System';
                                ?></span>
                        </div>
                    </div>
                    <div class="uk-width-medium-1-3">
                        <div class="parsley-row">
                            <label for="title"><b>Training Mode: </b></label>
                            <span><?php echo $vals['TrainingScheduleCreation']['mode']; ?></span>
                        </div>
                    </div>
                </div>
                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-1-3">
                        <div class="parsley-row">
                            <label for="title"><b>Training Start Date: </b></label>
                            <span><?php echo date("d-m-Y", strtotime($vals['TrainingScheduleCreation']['sch_start_date'])); ?></span>
                        </div>
                    </div>
                    <div class="uk-width-medium-1-3">
                        <div class="parsley-row">
                            <label for="title"><b>Training End Date: </b></label>
                            <span><?php echo date("d-m-Y", strtotime($vals['TrainingScheduleCreation']['sch_end_date'])); ?></span>
                        </div>
                    </div>
                    <div class="uk-width-medium-1-3">
                        <div class="parsley-row">
                            <label for="title"><b>Training Duration: </b></label>
                            <span><?php echo $vals['TrainingCreation']['training_start_time']; ?></span>
                        </div>
                    </div>
                </div>
                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-1-3">
                        <div class="parsley-row">
                            <label for="title"><b>Training Start Time: </b></label>
                            <span><?php echo $vals['TrainingScheduleCreation']['sch_start_time']; ?></span>
                        </div>
                    </div>
                    <div class="uk-width-medium-1-3">
                        <div class="parsley-row">
                            <label for="title"><b>Training End Time: </b></label>
                            <span><?php echo $vals['TrainingScheduleCreation']['sch_end_time']; ?>
                                <input type="hidden" name="tid" value="<?php echo base64_encode($vals['TrainingCreation']['training_id']); ?>">
                            </span>
                        </div>
                    </div>
                </div>
                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-1-1">
                        <div class="uk-form-row">
                            <div class="uk-grid">
                                <div class="uk-width-medium-1-1">
                                    <span class="uk-input-group-addon"><button type="submit" class="md-btn">Open Attendance</button></span>
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
