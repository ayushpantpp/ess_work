<div id="page_content">
    <div id="page_content_inner">
        <h3 class="heading_b uk-margin-bottom">Online Training Registration Form</h3>
        <div class="md-card uk-margin-medium-bottom">
            <div class="md-card-content">
                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-1-1">
                        <div class="uk-grid uk-grid-small">
                            <div class="uk-width-large-1-3">
                                <span class="uk-text-muted uk-text-small">Training Required</span>
                            </div>
                            <div class="uk-width-large-2-3">
                                <?php $course_id = $trainingdt['TrainingCreation']['course_id'];   ?>
                                <span class="uk-text-large uk-text-middle"><?php  echo $this->Common->getTrainingClassName($course_id); ?></span>
                            </div>
                        </div>
                        <hr class="uk-grid-divider">
                        <div class="uk-grid uk-grid-small">
                            <div class="uk-width-large-1-3">
                                <span class="uk-text-muted uk-text-small">Training Start Date</span>
                            </div>
                            <div class="uk-width-large-2-3">
                                <span class="uk-text-large uk-text-middle"><?php echo date('d-M-Y', strtotime($trainingdt['TrainingCreation']['training_date']));?></span>
                            </div>
                        </div>
                        <hr class="uk-grid-divider">
                        <div class="uk-grid uk-grid-small">
                            <div class="uk-width-large-1-3">
                                <span class="uk-text-muted uk-text-small">Training End Date</span>
                            </div>
                            <div class="uk-width-large-2-3">
                            <?php if($scheduledt['TrainingScheduleCreation']['sch_end_date']){?>    
                                <span class="uk-text-large uk-text-middle"><?php echo date('d-M-Y', strtotime($scheduledt['TrainingScheduleCreation']['sch_end_date']));  ?></span>
                            <?php }else{?>   
                              <span class="uk-text-large uk-text-middle">N/A</span>
                            <?php }?>
                            </div>
                        </div>
                       <?php if($scheduledt['TrainingScheduleCreation']['sch_start_time']){?>
                        <hr class="uk-grid-divider">
                        <div class="uk-grid uk-grid-small">
                            <div class="uk-width-large-1-3">
                                <span class="uk-text-muted uk-text-small">Training Start Time</span>
                            </div>
                            <div class="uk-width-large-2-3">
                                <span class="uk-text-large uk-text-middle"><?php echo $scheduledt['TrainingScheduleCreation']['sch_start_time']; ?> </span>
                            </div>
                        </div>
                       <?php} if($scheduledt['TrainingScheduleCreation']['sch_end_time']){?>
                        <hr class="uk-grid-divider">
                        <div class="uk-grid uk-grid-small">
                            <div class="uk-width-large-1-3">
                                <span class="uk-text-muted uk-text-small">Training End Time</span>
                            </div>
                           <div class="uk-width-large-2-3">
                                <span class="uk-text-large uk-text-middle"><?php echo $scheduledt['TrainingScheduleCreation']['sch_end_time']; ?> </span>
                            </div>
                        </div>
                       <?php }?>
                    </div>
                </div>
                <div class="uk-grid" data-uk-grid-margin="">
                    <div class="uk-width-medium-1" style="text-align: right;">
                        <a class="md-btn md-btn-danger md-btn-wave waves-effect waves-button" href="<?php echo $this->webroot; ?>training/saveUpcominTraining/<?php echo base64_encode($trainingdt['TrainingCreation']['training_id']); ?>/">Confirm    </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>