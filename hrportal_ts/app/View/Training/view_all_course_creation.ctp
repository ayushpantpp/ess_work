<div id="page_content">
    <div id="page_content_inner">

        <h3 class="heading_b uk-margin-bottom">View All Courses </h3>
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
                                        <th>Course ID</th>
                                        <th>Course Name</th>
                                        <th>Course Duration</th>
                                        <th>Course Cost</th>

                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <?php
                                if (!empty($classLists)) {
                                    $i = 1;
                                    foreach ($classLists as $classList) {
                                        ?>
                                        <tbody>
                                            <tr>
                                                <td class="uk-text-center"><span class="uk-text-small uk-text-muted uk-text-nowrap"><?php echo $ctr = (($this->params['paging']['TrainingCourseCreation']['page'] * $this->params['paging']['TrainingCourseCreation']['limit']) - $this->params['paging']['TrainingCourseCreation']['limit']) + $i; ?></span></td>
                                                <td>
                                                    <?php echo $classList['TrainingCourseCreation']['course_id']; ?>
                                                </td>
                                                <td>
                                                    <?php echo $classList['TrainingCourseCreation']['name']; ?>
                                                </td>
                                                <td>
                                                    <?php echo $classList['TrainingCourseCreation']['course_duration_time'] . " " . $classList['TrainingCourseCreation']['course_duration_type']; ?>
                                                </td>
                                                <td>
                                                    <?php echo $classList['TrainingCourseCreation']['cost'] . " " . $this->Common->getTrainingCurrecnyName($classList['TrainingCourseCreation']['currency']);
                                                    ; ?>
                                                </td>
                                                <td><span class="uk-text-upper">
                                                        <?php if (empty($this->Common->chkCourseCreation($classList['TrainingCourseCreation']['course_id']))) { ?>
                                                            <a href="<?php echo $this->webroot; ?>training/deleteCourse/<?php echo base64_encode($classList['TrainingCourseCreation']['course_id']); ?>/" class="md-btn md-btn-danger md-btn-small md-btn-wave-light waves-effect waves-button waves-light" onclick="return confirm('Are you sure?')">Delete</a>
        <?php } ?>
                                                        <a href="<?php echo $this->webroot; ?>training/editCourseCreation/<?php echo base64_encode($classList['TrainingCourseCreation']['course_id']); ?>/" class="md-btn md-btn-primary md-btn-small md-btn-wave-light waves-effect waves-button waves-light">Edit</a><a href="<?php echo $this->webroot; ?>training/viewCourseCreation/<?php echo base64_encode($classList['TrainingCourseCreation']['course_id']); ?>/" class="md-btn md-btn-primary md-btn-small md-btn-wave-light waves-effect waves-button waves-light">View Details</a></span></td>
                                            </tr>
                                        </tbody>
                                        <?php
                                        $i++;
                                    }
                                }
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