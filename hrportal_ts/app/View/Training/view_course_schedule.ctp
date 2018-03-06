<div id="page_content">
    <div id="page_content_inner">
        <h3 class="heading_b uk-margin-bottom">View Scheduled Course</h3>
        <div class="md-card uk-margin-medium-bottom">
            <div class="md-card-content">
                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-1-1">
                        <div class="uk-grid uk-grid-small">
                            <div class="uk-width-large-1-3">
                                <span class="uk-text-muted uk-text-small">Schedule ID</span>
                            </div>
                            <div class="uk-width-large-2-3">
                                <span class="uk-text-large uk-text-middle"><?php echo $details['TrainingScheduleCreation']['schedule_id']; ?></span>
                            </div>
                        </div>
                        <hr class="uk-grid-divider">
                        <div class="uk-grid uk-grid-small">
                            <div class="uk-width-large-1-3">
                                <span class="uk-text-muted uk-text-small">Course Name</span>
                            </div>
                            <div class="uk-width-large-2-3">
                                <span class="uk-text-large uk-text-middle"><?php echo $this->Common->getTrainingClassName($details['TrainingScheduleCreation']['course_id']); ?></span>
                            </div>
                        </div>
                        <hr class="uk-grid-divider">
                        <div class="uk-grid uk-grid-small">
                            <div class="uk-width-large-1-3">
                                <span class="uk-text-muted uk-text-small">Schedule Start Date</span>
                            </div>
                            <div class="uk-width-large-2-3">
                                <span class="uk-text-large uk-text-middle"><?php if (!empty($details['TrainingScheduleCreation']['sch_start_date'])) echo date('d-m-Y', strtotime($details['TrainingScheduleCreation']['sch_start_date'])) ?></span>
                            </div>
                        </div>
                        <hr class="uk-grid-divider">
                        <div class="uk-grid uk-grid-small">
                            <div class="uk-width-large-1-3">
                                <span class="uk-text-muted uk-text-small">Schedule End Date</span>
                            </div>
                            <div class="uk-width-large-2-3">
                                <span class="uk-text-large uk-text-middle"><?php if (!empty($details['TrainingScheduleCreation']['sch_end_date'])) echo date('d-m-Y', strtotime($details['TrainingScheduleCreation']['sch_end_date'])); ?></span>
                            </div>
                        </div>
                        <hr class="uk-grid-divider">
                        <div class="uk-grid uk-grid-small">
                            <div class="uk-width-large-1-3">
                                <span class="uk-text-muted uk-text-small">Schedule Start Time</span>
                            </div>
                            <div class="uk-width-large-2-3">
                                <span class="uk-text-large uk-text-middle"><?php echo $details['TrainingScheduleCreation']['sch_start_time']; ?></span>
                            </div>
                        </div>
                        <hr class="uk-grid-divider">
                        <div class="uk-grid uk-grid-small">
                            <div class="uk-width-large-1-3">
                                <span class="uk-text-muted uk-text-small">Schedule End Time</span>
                            </div>
                            <div class="uk-width-large-2-3">
                                <span class="uk-text-large uk-text-middle"><?php echo $details['TrainingScheduleCreation']['sch_end_time']; ?></span>
                            </div>
                        </div>
                        <hr class="uk-grid-divider">
                        <div class="uk-grid uk-grid-small">
                            <div class="uk-width-large-1-3">
                                <span class="uk-text-muted uk-text-small">Contact Person</span>
                            </div>
                            <div class="uk-width-large-2-3">
                                <span class="uk-text-large uk-text-middle"><?php echo $details['TrainingScheduleCreation']['contact_person']; ?></span>
                            </div>
                        </div>
                        <hr class="uk-grid-divider">
                        <div class="uk-grid uk-grid-small">
                            <div class="uk-width-large-1-3">
                                <span class="uk-text-muted uk-text-small">Contact Mail</span>
                            </div>
                            <div class="uk-width-large-2-3">
                                <span class="uk-text-large uk-text-middle"><?php echo $details['TrainingScheduleCreation']['contact_email']; ?></span>
                            </div>
                        </div>
                        <hr class="uk-grid-divider">
                        <div class="uk-grid uk-grid-small">
                            <div class="uk-width-large-1-3">
                                <span class="uk-text-muted uk-text-small">Contact Number</span>
                            </div>
                            <div class="uk-width-large-2-3">
                                <span class="uk-text-large uk-text-middle"><?php echo $details['TrainingScheduleCreation']['contact_number']; ?></span>
                            </div>
                        </div>
                        <hr class="uk-grid-divider">
                        <div class="uk-grid uk-grid-small">
                            <div class="uk-width-large-1-3">
                                <span class="uk-text-muted uk-text-small">Facility</span>
                            </div>
                            <div class="uk-width-large-2-3">
                                <span class="uk-text-large uk-text-middle"><?php echo $details['TrainingScheduleCreation']['facility']; ?></span>
                            </div>
                        </div>
                        <hr class="uk-grid-divider">
                        <div class="uk-grid uk-grid-small">
                            <div class="uk-width-large-1-3">
                                <span class="uk-text-muted uk-text-small">Location</span>
                            </div>
                            <div class="uk-width-large-2-3">
                                <span class="uk-text-large uk-text-middle"><?php echo $details['TrainingScheduleCreation']['location']; ?></span>
                            </div>
                        </div>
                        <hr class="uk-grid-divider">
                        <div class="uk-grid uk-grid-small">
                            <div class="uk-width-large-1-3">
                                <span class="uk-text-muted uk-text-small">Instructor Name</span>
                            </div>
                            <div class="uk-width-large-2-3">
                                <span class="uk-text-large uk-text-middle"><?php echo $this->Common->findEmpName($details['TrainingScheduleCreation']['instructor_name']); ?></span>
                            </div>
                        </div>
                        <hr class="uk-grid-divider">
                        <div class="uk-grid uk-grid-small">
                            <div class="uk-width-large-1-3">
                                <span class="uk-text-muted uk-text-small">Training Mode</span>
                            </div>
                            <div class="uk-width-large-2-3">
                                <span class="uk-text-large uk-text-middle"><?php echo $details['TrainingScheduleCreation']['mode']; ?></span>
                            </div>
                        </div>
                        <hr class="uk-grid-divider">
                        <div class="uk-grid uk-grid-small">
                            <div class="uk-width-large-1-3">
                                <span class="uk-text-muted uk-text-small">Final Registeration Date</span>
                            </div>
                            <div class="uk-width-large-2-3">
                                <span class="uk-text-large uk-text-middle"><?php if (!empty($details['TrainingScheduleCreation']['final_regis_date'])) echo date('d-m-Y', strtotime($details['TrainingScheduleCreation']['final_regis_date'])); ?></span>
                            </div>
                        </div>
                        <hr class="uk-grid-divider">
                        <div class="uk-grid uk-grid-small">
                            <div class="uk-width-large-1-3">
                                <span class="uk-text-muted uk-text-small">Status</span>
                            </div>
                            <div class="uk-width-large-2-3">
                                <span class="uk-text-large uk-text-middle"><?php
                                    if ($details['TrainingScheduleCreation']['status'] == 0)
                                        echo 'Enable';
                                    else
                                        echo 'Disable';
                                    ?></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="uk-grid" data-uk-grid-margin="">
                    <div class="uk-width-medium-1" style="text-align: right;">
                        <a class="md-btn md-btn-wave waves-effect waves-button" href="<?php echo $this->webroot; ?>training/scheduleCourse/">Back</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>