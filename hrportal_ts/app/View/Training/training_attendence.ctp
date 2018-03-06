<div id="page_content">
    <div id="page_content_inner">
        <h3 class="heading_b uk-margin-bottom">Training Attendance Summary</h3>
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
                                        <th>Course Name</th>
                                        <th>Training Date</th>
                                        <th>Training Start date</th>
                                        <th>Training End date</th>
                                        <th>Training Start Time</th>
                                        <th>Training End Time</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <?php
                                $pendingTrainingAttendences = $this->Notify->pendingTrainingAttendence();
                                $pendingTrainingAttendencesCloses = $this->Notify->pendingTrainingAttendenceClose();

                                if (!empty($pendingTrainingAttendencesCloses)) {
                                    $i = 1;
                                    foreach ($pendingTrainingAttendencesCloses as $pendingTrainingAttendencesClose) {
                                        ?>
                                        <tbody>
                                            <tr>
                                                <td class="uk-text-center"><span class="uk-text-small uk-text-muted uk-text-nowrap"><?php echo $i; ?></span></td>
                                                <td>
                                                    <?php echo $this->Common->getTrainingClassName($pendingTrainingAttendencesClose['TrainingCreation']['course_id']); ?>
                                                </td>
                                                <td>
                                                    <?php echo date("d-m-Y", strtotime($pendingTrainingAttendencesClose['TrainingCreation']['training_date'])); ?>
                                                </td>
                                                <td>
                                                    <?php echo date("d-m-Y", strtotime($pendingTrainingAttendencesClose['TrainingScheduleCreation']['sch_start_date'])); ?>
                                                </td>
                                                <td>
                                                    <?php echo date("d-m-Y", strtotime($pendingTrainingAttendencesClose['TrainingScheduleCreation']['sch_end_date'])); ?>
                                                </td>
                                                <td>
                                                    <?php echo $pendingTrainingAttendencesClose['TrainingScheduleCreation']['sch_start_time']; ?>
                                                </td>
                                                <td>
                                                    <?php echo $pendingTrainingAttendencesClose['TrainingScheduleCreation']['sch_end_time']; ?>
                                                </td>
                                                <td>
                                                    <span class="uk-text-upper">
                                                        <?php
                                                        $chtd = $this->Common->checkTrainingAttendence($pendingTrainingAttendencesClose['TrainingCreation']['training_id'], $emp_code);
                                                        if (!empty($chtd)) {
                                                            if ($chtd['TrainingCourseAttendence']['open'] != 1) {
                                                                echo '<a class="md-btn md-btn-flat md-btn-wave waves-effect waves-button" href="#">N/A</a>';
                                                            } elseif ($chtd['TrainingCourseAttendence']['close'] != 1) {
                                                                echo '<a class="md-btn md-btn-flat md-btn-flat-primary md-btn-wave waves-effect waves-button" href="#">Opened</a>';
                                                            }
                                                        } else {
                                                            echo '<a class="md-btn md-btn-flat md-btn-wave waves-effect waves-button" href="#">N/A</a>';
                                                        }
                                                        ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class="uk-text-upper">
                                                        <?php
                                                        $chtd = $this->Common->checkTrainingAttendence($pendingTrainingAttendencesClose['TrainingCreation']['training_id'], $emp_code);
                                                        if (!empty($chtd)) {
                                                            if ($chtd['TrainingCourseAttendence']['open'] != 1) {
                                                                ?>
                                                                <a href="<?php echo $this->webroot; ?>training/openAttendence/<?php echo base64_encode($pendingTrainingAttendencesClose['TrainingCreation']['training_id']); ?>/" class="md-btn md-btn-primary md-btn-small md-btn-wave-light waves-effect waves-button waves-light">Apply</a>

                                                            <?php } elseif ($chtd['TrainingCourseAttendence']['close'] != 1) { ?>
                                                                <a href="<?php echo $this->webroot; ?>training/closeAttendence/<?php echo base64_encode($chtd['TrainingCourseAttendence']['id']); ?>/" class="md-btn md-btn-primary md-btn-small md-btn-wave-light waves-effect waves-button waves-light">Apply</a>
                                                                <?php
                                                            }
                                                        } else {
                                                            ?>
                                                            <a href="<?php echo $this->webroot; ?>training/openAttendence/<?php echo base64_encode($pendingTrainingAttendencesClose['TrainingCreation']['training_id']); ?>/" class="md-btn md-btn-primary md-btn-small md-btn-wave-light waves-effect waves-button waves-light">Apply</a>
                                                        <?php }
                                                        ?>
                                                    </span>
                                                </td>
                                            </tr>
                                        </tbody>
                                        <?php
                                        $i++;
                                    }
                                }

                                if (!empty($pendingTrainingAttendences)) {
                                    $i = 1;
                                    foreach ($pendingTrainingAttendences as $pendingTrainingAttendence) {
                                        ?>
                                        <tbody>
                                            <tr>
                                                <td class="uk-text-center"><span class="uk-text-small uk-text-muted uk-text-nowrap"><?php echo $i; ?></span></td>
                                                <td>
                                                    <?php echo $this->Common->getTrainingClassName($pendingTrainingAttendence['TrainingCreation']['course_id']); ?>
                                                </td>
                                                <td>
                                                    <?php echo date("d-m-Y", strtotime($pendingTrainingAttendence['TrainingCreation']['training_date'])); ?>
                                                </td>
                                                <td>
                                                    <?php echo date("d-m-Y", strtotime($pendingTrainingAttendence['TrainingScheduleCreation']['sch_start_date'])); ?>
                                                </td>
                                                <td>
                                                    <?php echo date("d-m-Y", strtotime($pendingTrainingAttendence['TrainingScheduleCreation']['sch_end_date'])); ?>
                                                </td>
                                                <td>
                                                    <?php echo $pendingTrainingAttendence['TrainingScheduleCreation']['sch_start_time']; ?>
                                                </td>
                                                <td>
                                                    <?php echo $pendingTrainingAttendence['TrainingScheduleCreation']['sch_end_time']; ?>
                                                </td>
                                                <td>
                                                    <span class="uk-text-upper">
                                                        <?php
                                                        $chtd = $this->Common->checkTrainingAttendence($pendingTrainingAttendencesClose['TrainingCreation']['training_id'], $emp_code);
                                                        if (!empty($chtd)) {
                                                            if ($chtd['TrainingCourseAttendence']['open'] != 1) {
                                                                echo '<a class="md-btn md-btn-flat md-btn-wave waves-effect waves-button" href="#">N/A</a>';
                                                            } elseif ($chtd['TrainingCourseAttendence']['close'] != 1) {
                                                                echo '<a class="md-btn md-btn-flat md-btn-flat-primary md-btn-wave waves-effect waves-button" href="#">Opened</a>';
                                                            }
                                                        } else {
                                                            echo '<a class="md-btn md-btn-flat md-btn-wave waves-effect waves-button" href="#">N/A</a>';
                                                        }
                                                        ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class="uk-text-upper">
                                                        <?php
                                                        $chtd = $this->Common->checkTrainingAttendence($pendingTrainingAttendence['TrainingCreation']['training_id'], $emp_code);
                                                        if (!empty($chtd)) {
                                                            if ($chtd['TrainingCourseAttendence']['open'] != 1) {
                                                                ?>
                                                                <a href="<?php echo $this->webroot; ?>training/openAttendence/<?php echo base64_encode($pendingTrainingAttendence['TrainingCreation']['training_id']); ?>/" class="md-btn md-btn-primary md-btn-small md-btn-wave-light waves-effect waves-button waves-light">Apply</a>

                                                            <?php } elseif ($chtd['TrainingCourseAttendence']['close'] != 1) { ?>
                                                                <a href="<?php echo $this->webroot; ?>training/closeAttendence/<?php echo base64_encode($chtd['TrainingCourseAttendence']['id']); ?>/" class="md-btn md-btn-primary md-btn-small md-btn-wave-light waves-effect waves-button waves-light">Apply</a>
                                                                <?php
                                                            }
                                                        } else {
                                                            ?>
                                                            <a href="<?php echo $this->webroot; ?>training/openAttendence/<?php echo base64_encode($pendingTrainingAttendence['TrainingCreation']['training_id']); ?>/" class="md-btn md-btn-primary md-btn-small md-btn-wave-light waves-effect waves-button waves-light">Apply</a>
                                                        <?php }
                                                        ?>
                                                    </span>
                                                </td>
                                            </tr>
                                        </tbody>
                                        <?php
                                        $i++;
                                    }
                                }
                                ?>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>