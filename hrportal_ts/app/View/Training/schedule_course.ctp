<div id="page_content">
    <div id="page_content_inner">

        <h3 class="heading_b uk-margin-bottom">Scheduled Courses</h3>
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
                                        <th>Schedule ID</th>
                                        <th>Course Name</th>
                                        <th>Schedule Start Date</th>
                                        <th>Schedule Ends Date</th>
                                        <th>Schedule Starts Time</th>
                                        <th>Schedule Ends Time</th>
                                        <th>Created At</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <?php
                                if (!empty($coursescheduleLists)) {
                                    $i = 1;
                                    foreach ($coursescheduleLists as $coursescheduleList) {
                                        ?>
                                        <tbody>
                                            <tr>
                                                <td class="uk-text-center"><span class="uk-text-small uk-text-muted uk-text-nowrap"><?php echo $ctr = (($this->params['paging']['TrainingScheduleCreation']['page'] * $this->params['paging']['TrainingScheduleCreation']['limit']) - $this->params['paging']['TrainingScheduleCreation']['limit']) + $i; ?></span></td>
                                                <td>
                                                    <?php echo $coursescheduleList['TrainingScheduleCreation']['schedule_id']; ?>
                                                </td>
                                                <td>
                                                    <?php echo $this->Common->getTrainingClassName($coursescheduleList['TrainingScheduleCreation']['course_id']); ?>
                                                </td>
                                                <td>
                                                    <?php if (!empty($coursescheduleList['TrainingScheduleCreation']['sch_start_date'])) echo date('d-m-Y', strtotime($coursescheduleList['TrainingScheduleCreation']['sch_start_date'])) ?>
                                                </td>
                                                <td>
                                                    <?php if (!empty($coursescheduleList['TrainingScheduleCreation']['sch_end_date'])) echo date('d-m-Y', strtotime($coursescheduleList['TrainingScheduleCreation']['sch_end_date'])) ?>
                                                </td>
                                                <td>
                                                    <?php echo $coursescheduleList['TrainingScheduleCreation']['sch_start_time']; ?>
                                                </td>
                                                <td>
                                                    <?php echo $coursescheduleList['TrainingScheduleCreation']['sch_end_time']; ?>
                                                </td>
                                                <td><span class="uk-badge"><?php if (!empty($coursescheduleList['TrainingScheduleCreation']['created_at'])) echo date('d-m-Y', strtotime($coursescheduleList['TrainingScheduleCreation']['created_at'])) ?></span></td>
                                                <td>
                                                    <?php
                                                    if ($coursescheduleList['TrainingScheduleCreation']['status'] == 0)
                                                        echo 'Enable';
                                                    else
                                                        echo 'Disable';
                                                    ?>
                                                </td>
                                                <td><span class="uk-text-upper"><a href="<?php echo $this->webroot; ?>training/viewCourseSchedule/<?php echo base64_encode($coursescheduleList['TrainingScheduleCreation']['schedule_id']); ?>/" class="md-btn md-btn-primary md-btn-small md-btn-wave-light waves-effect waves-button waves-light">View</a>
                                                        <a href="<?php echo $this->webroot; ?>training/editCourseSchedule/<?php echo base64_encode($coursescheduleList['TrainingScheduleCreation']['schedule_id']); ?>/" class="md-btn md-btn-primary md-btn-small md-btn-wave-light waves-effect waves-button waves-light">Edit</a>
                                                        <?php if (empty($this->Common->chkScheduleCreation($coursescheduleList['TrainingScheduleCreation']['schedule_id']))) { ?>
                                                            <a class="md-btn md-btn-danger md-btn-small md-btn-wave-light waves-effect waves-button waves-light" href="<?php echo $this->webroot; ?>training/deleteScheduleCourse/<?php echo base64_encode($coursescheduleList['TrainingScheduleCreation']['schedule_id']); ?>/" title="Delete" onclick="return confirm('Are you sure?')" >Delete</a>
                                                        <?php } ?>
                                                    </span></td>
                                            </tr>
                                        </tbody>
                                        <?php
                                        $i++;
                                    }
                                } else {
                                    ?>
                                    <tbody>
                                        <tr><td>No Record Found</td></tr>
                                    </tbody>
                                <?php }
                                ?>
                            </table>
                        </div>
                        <div class="uk-grid" data-uk-grid-margin>
                            <div class="uk-width-medium-1-1">
                                <ul class="uk-pagination uk-pagination-right">
                                    <?php
                                    echo $this->Paginator->prev('Previous', array('tag' => 'li', 'escape' => false), '<a>Previous</a>', array('class' => 'uk-disabled', 'tag' => 'li', 'escape' => false));
                                    echo $this->Paginator->numbers(array('separator' => '', 'tag' => 'li', 'currentLink' => true, 'currentClass' => 'uk-active', 'currentTag' => 'a'));
                                    echo $this->Paginator->next('Next', array('tag' => 'li', 'escape' => false), '<a>Next</a>', array('class' => 'uk-disabled', 'tag' => 'li', 'escape' => false));
                                    ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>