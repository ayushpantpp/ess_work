<div id="page_content">
    <div id="page_content_inner">
        <h3 class="heading_b uk-margin-bottom">View Created Course</h3>
        <div class="md-card uk-margin-medium-bottom">
            <div class="md-card-content">
                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-1-1">
                        <div class="uk-grid uk-grid-small">
                            <div class="uk-width-large-1-3">
                                <span class="uk-text-muted uk-text-small">Course ID</span>
                            </div>
                            <div class="uk-width-large-2-3">
                                <span class="uk-text-large uk-text-middle"><?php echo $courselist['TrainingCourseCreation']['course_id']; ?></span>
                            </div>
                        </div>
                        <hr class="uk-grid-divider">
                        <div class="uk-grid uk-grid-small">
                            <div class="uk-width-large-1-3">
                                <span class="uk-text-muted uk-text-small">Course Name</span>
                            </div>
                            <div class="uk-width-large-2-3">
                                <span class="uk-text-large uk-text-middle"><?php echo $courselist['TrainingCourseCreation']['name']; ?></span>
                            </div>
                        </div>
                        <hr class="uk-grid-divider">
                        <div class="uk-grid uk-grid-small">
                            <div class="uk-width-large-1-3">
                                <span class="uk-text-muted uk-text-small">Course Description</span>
                            </div>
                            <div class="uk-width-large-2-3">
                                <span class="uk-text-large uk-text-middle"><?php echo $courselist['TrainingCourseCreation']['description']; ?></span>
                            </div>
                        </div>
                        <hr class="uk-grid-divider">
                        <div class="uk-grid uk-grid-small">
                            <div class="uk-width-large-1-3">
                                <span class="uk-text-muted uk-text-small">Course Duration Time</span>
                            </div>
                            <div class="uk-width-large-2-3">
                                <span class="uk-text-large uk-text-middle"></span><?php echo $courselist['TrainingCourseCreation']['course_duration_time']; ?>

                                <?php if ($courselist['TrainingCourseCreation']['course_duration_type'] === 'D') { ?>                           <span class="uk-text-large uk-text-middle">Day</span>
                                <?php } elseif ($courselist['TrainingCourseCreation']['course_duration_type'] === 'M') { ?>   <span class="uk-text-large uk-text-middle">Months</span>
                                <?php } elseif ($courselist['TrainingCourseCreation']['course_duration_type'] === 'Y') { ?>
                                    <span class="uk-text-large uk-text-middle">Year</span>
                                <?php } else { ?>
                                    <span class="uk-text-large uk-text-middle">Hour</span>
                                <?php } ?>
                            </div>
                        </div>
                        <hr class="uk-grid-divider">
                        <div class="uk-grid uk-grid-small">
                            <div class="uk-width-large-1-3">
                                <span class="uk-text-muted uk-text-small">Course Cost</span>
                            </div>
                            <div class="uk-width-large-2-3">
                                <span class="uk-text-large uk-text-middle"><?php echo $courselist['TrainingCourseCreation']['cost']; ?></span><span class="uk-text-large uk-text-middle"><?php echo " " . $this->Common->getTrainingCurrecnyName($courselist['TrainingCourseCreation']['currency']); ?></span>
                            </div>
                        </div>
                        <hr class="uk-grid-divider">
                        <div class="uk-grid uk-grid-small">
                            <div class="uk-width-large-1-3">
                                <span class="uk-text-muted uk-text-small">Institute Name</span>
                            </div>
                            <div class="uk-width-large-2-3">
                                <span class="uk-text-large uk-text-middle"><?php echo $courselist['TrainingCourseCreation']['institute_name']; ?></span>
                            </div>
                        </div>
                        <hr class="uk-grid-divider">
                        <div class="uk-grid uk-grid-small">
                            <div class="uk-width-large-1-3">
                                <span class="uk-text-muted uk-text-small">Maximum Course Capacity</span>
                            </div>
                            <div class="uk-width-large-2-3">
                                <span class="uk-text-large uk-text-middle"><?php echo $courselist['TrainingCourseCreation']['max_class_capacity']; ?></span>
                            </div>
                        </div>
                        <hr class="uk-grid-divider">
                        <div class="uk-grid uk-grid-small">
                            <div class="uk-width-large-1-3">
                                <span class="uk-text-muted uk-text-small">Course Category</span>
                            </div>
                            <div class="uk-width-large-2-3">
                                <span class="uk-text-large uk-text-middle"><?php echo $this->Common->getCategoryClassName($courselist['TrainingCourseCreation']['course_category_id']); ?></span>
                            </div>
                        </div>
                        <hr class="uk-grid-divider">
                        <div class="uk-grid uk-grid-small">
                            <div class="uk-width-large-1-3">
                                <span class="uk-text-muted uk-text-small">Course Validity</span>
                            </div>
                            <div class="uk-width-large-2-3">
                                <span class="uk-text-large uk-text-middle"><?php echo $this->Common->getTrainingValidityMasterName($this->Common->getTrainingValidityId($courselist['TrainingCourseCreation']['course_validity_id'])); ?></span>
                            </div>
                        </div>
                        <hr class="uk-grid-divider">
                        <div class="uk-grid uk-grid-small">
                            <div class="uk-width-large-1-3">
                                <span class="uk-text-muted uk-text-small">Course Type</span>
                            </div>
                            <div class="uk-width-large-2-3">
                                <span class="uk-text-large uk-text-middle"><?php echo $this->Common->getTypeClassName($courselist['TrainingCourseCreation']['type_id']); ?></span>
                            </div>
                        </div>
                        <hr class="uk-grid-divider">
                        <div class="uk-grid uk-grid-small">
                            <div class="uk-width-large-1-3">
                                <span class="uk-text-muted uk-text-small">Status</span>
                            </div>
                            <div class="uk-width-large-2-3">
                                <span class="uk-text-large uk-text-middle"><?php
                                    if ($courselist['TrainingCourseCreation']['status'] == 0)
                                        echo 'Enable';
                                    else
                                        echo 'Disable';
                                    ?></span>
                            </div>
                        </div>
                        <hr class="uk-grid-divider">


                    </div>
                </div>
                <div class="uk-grid" data-uk-grid-margin="">
                    <div class="uk-width-medium-1" style="text-align: right;">
                        <a class="md-btn md-btn-wave waves-effect waves-button" href="<?php echo $this->webroot; ?>training/viewAllCourseCreation/">Back</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>