<div id="page_content">
    <div id="page_content_inner">
        <h3 class="heading_b uk-margin-bottom">List of All Trainings</h3>
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
                                        <th>Schedule Start Time</th>
                                        <th>Schedule End Time</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <?php
                                if (!empty($list)) {
                                    $i = 1;
                                    foreach ($list as $classList) {
                                        ?>
                                        <tbody>
                                            <tr>
                                                <td class="uk-text-center"><span class="uk-text-small uk-text-muted uk-text-nowrap"><?php echo $ctr = (($this->params['paging']['TrainingCreation']['page'] * $this->params['paging']['TrainingCreation']['limit']) - $this->params['paging']['TrainingCreation']['limit']) + $i; ?></span></td>
                                                <td>
                                                    <?php $course_id = $classList['TrainingCreation']['course_id'];                                                          //  print_r($course_id);die;?>
                                                    <?php echo $this->Common->getTrainingClassName($course_id); ?>
                                                </td>
                                                <td>
                                                    <?php echo date('d-M-Y', strtotime($classList['TrainingCreation']['training_date'])); ?>
                                                </td>
                                                <td>
                                                    <?php echo $classList['schedule']['sch_start_time']; ?>
                                                </td>
                                                <td>
                                                    <?php echo $classList['schedule']['sch_end_time']; ?>
                                                </td>
                                                <td><span class="uk-text-upper">
                                                        <?php if ($this->Common->checkTrainingEvolution($classList['TrainingCreation']['training_id'])) { ?>
                                                            <a href="<?php echo $this->webroot; ?>training/viewMatrix/<?php echo base64_encode($classList['TrainingCreation']['training_id']); ?>/" class="md-btn md-btn-danger md-btn-small md-btn-wave-light waves-effect waves-button waves-light">View</a>
                                                        <?php } else {
                                                            ?>
                                                            <a href="<?php echo $this->webroot; ?>training/evolutionMatrix/<?php echo base64_encode($classList['TrainingCreation']['training_id']); ?>/" class="md-btn md-btn-danger md-btn-small md-btn-wave-light waves-effect waves-button waves-light">Evolution Matrix</a>
                                                        <?php } ?>
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