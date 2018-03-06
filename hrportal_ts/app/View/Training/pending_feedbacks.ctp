<div id="page_content">
    <div id="page_content_inner">

        <h3 class="heading_b uk-margin-bottom">Training Feedback Summary</h3>
        <?php echo $flash = $this->Session->flash(); ?>
        <div class="md-card uk-margin-medium-bottom">
            <div class="md-card-content">
                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-1-1">
                        <!-- Start Type---->
                        <div class="uk-overflow-container uk-margin-bottom">
                            <table class="uk-table uk-table-align-vertical uk-table-nowrap tablesorter tablesorter-altair" id="ts_issues">
                                <thead>
                                    <tr>
                                        <th class="uk-text-center">S No.</th>
                                        <th>Training Name</th>
                                        <th>Employee Name</th>
                                        <th>Training Date</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <?php
                                $pendingTrainingFeedbacks = $this->Notify->pendingTrainingFeedback();

                                if (!empty($details)) {
                                    $i = 1;
                                    foreach ($details as $pendingTrainingFeedback) {
                                        $trainingdetail = $this->Common->gettrainingDetails($pendingTrainingFeedback['TrainingCourseAttendence']['training_creation_id']);
                                        ?>
                                        <tbody>
                                            <tr>
                                                <td class="uk-text-center"><span class="uk-text-small uk-text-muted uk-text-nowrap"><?php echo $ctr = $i; ?></span></td>
                                                <td>
                                                    <?php echo $trainingdetail['TrainingCourseCreation']['name']; ?>
                                                </td>
                                                <td>
                                                    <?php echo $this->Common->findEmpName($pendingTrainingFeedback['TrainingCourseAttendence']['trainee_code']); ?>
                                                </td>
                                                <td>
                                                    <?php echo date('d-M-Y', strtotime($trainingdetail['TrainingCreation']['training_date'])); ?>
                                                </td>
                                                <td>
                                                    <?php
                                                    if ($pendingTrainingFeedback['TrainingCourseAttendence']['feedback_status'] == 0) {
                                                        echo '<a class="md-btn md-btn-primary md-btn-small md-btn-wave-light waves-effect waves-button waves-light" href="#">Opened</a>';
                                                    } else {
                                                        $feedbackId = $this->Common->getFeedbackId($pendingTrainingFeedback['TrainingCourseAttendence']['training_creation_id'], $pendingTrainingFeedback['TrainingCourseAttendence']['trainee_code']);
                                                        echo '<a class="md-btn md-btn-success md-btn-small md-btn-wave-light waves-effect waves-button waves-light" href="#">Closed</a>';
                                                    }
                                                    ?>
                                                </td>
                                                <td>
                                                    <span class="uk-text-upper">

                                                        <?php
                                                        if ($pendingTrainingFeedback['TrainingCourseAttendence']['feedback_status'] == 1) {
                                                            $url = $this->webroot . "training/viewTrainingFeedback/" . base64_encode($feedbackId);
                                                            echo '<a class="md-btn md-btn-wave md-btn-small waves-effect waves-button" href="' . $url . '">View</a>';
                                                        }
                                                        $datetime1 = date_create($pendingTrainingFeedback['TrainingCourseAttendence']['close_time']);
                                                        $datetime2 = date_create('now');
                                                        $interval = date_diff($datetime1, $datetime2);
                                                        if ($pendingTrainingFeedback['TrainingCourseAttendence']['feedback_status'] == 0 && $pendingTrainingFeedback['TrainingCourseAttendence']['trainee_code'] == $emp_code && $interval->format('%a') >= 0 && $interval->format('%a') <= 3) {
                                                            ?>
                                                            <a href="<?php echo $this->webroot; ?>training/onlineTrainingFeedback/<?php echo base64_encode($trainingdetail['TrainingCreation']['training_id']); ?>/" class="md-btn md-btn-danger md-btn-small md-btn-wave-light waves-effect waves-button waves-light">Open Feedback Form</a>
                                                        <?php } ?>
                                                    </span>
                                                </td>
                                            </tr>
                                        </tbody>
                                        <?php
                                        $i++;
                                    }
                                } else {
                                    echo '<tbody><tr><td class="uk-text-center">No Record Found</td></tr></tbody>';
                                }
                                ?>
                            </table>
                        </div>
                        <!--                        <div class="uk-grid" data-uk-grid-margin>
                                                    <div class="uk-width-medium-1-1">
                                                        <ul class="uk-pagination uk-pagination-right">
                        <?php
                        echo $this->Paginator->prev('Previous', array('tag' => 'li', 'escape' => false), '<a>Previous</a>', array('class' => 'uk-disabled', 'tag' => 'li', 'escape' => false));
                        echo $this->Paginator->numbers(array('separator' => '', 'tag' => 'li', 'currentLink' => true, 'currentClass' => 'uk-active', 'currentTag' => 'a'));
                        echo $this->Paginator->next('Next', array('tag' => 'li', 'escape' => false), '<a>Next</a>', array('class' => 'uk-disabled', 'tag' => 'li', 'escape' => false));
                        ?>
                                                        </ul>
                                                    </div>
                                                </div>-->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>