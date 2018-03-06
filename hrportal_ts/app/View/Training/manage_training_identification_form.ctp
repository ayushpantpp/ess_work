<script>
    function Get_Details(id)
    {
        jQuery.ajax({
            url: '<?php echo $this->webroot ?>training/getInfo/' + id,
            success: function (data) {
                //alert(data);
                jQuery('#empResponse').html(data);
            }
        });
    }
</script>

<div class="uk-width-medium-1-4">
    <div id="modal_overflow" class="uk-modal">
        <div class="uk-modal-dialog uk-modal-dialog-large">
            <button type="button" class="uk-modal-close uk-close"></button>            
            <div class="uk-overflow-container">
                <span id="empResponse" class="verflow container"></span>
            </div>          
        </div>
    </div>
</div>

<div id="page_content">
    <div id="page_content_inner">

        <h3 class="heading_b uk-margin-bottom">Manage Training Indentification</h3>
        <?php echo $flash = $this->Session->flash(); ?>
        <div class="md-card uk-margin-medium-bottom">
            <div class="md-card-content">
                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-1-1">
                        <!-- Start Type---->
                        <div class="uk-overflow-container uk-margin-bottom">
                            <?php
                            //echo $this->Html->link('Online Training Identification Request', array('controller' => 'training', 'action' => 'trainingIdentificationInitateForm'), array('class' => 'md-btn md-btn-primary md-btn-wave-light waves-effect waves-button waves-light', 'title' => 'Online Training Identification Request', 'id' => 'admorebtn', 'style' => 'float:right;padding-top:4px;'));
                            ?>
                            <table class="uk-table uk-table-align-vertical uk-table-nowrap tablesorter tablesorter-altair" id="ts_issues">
                                <thead>
                                    <tr>
                                        <th class="uk-text-center">S No.</th>
                                        <th>Course Name</th>
                                        <th>Training Date</th>
                                        <th>Training Duration Time</th>
                                        <th>Training Request Type</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <?php
                                if (!empty($trainingLists)) {
                                    $i = 1;
                                    foreach ($trainingLists as $trainingList) {
                                        ?>
                                        <tbody>
                                            <tr>
                                                <td class="uk-text-center"><span class="uk-text-small uk-text-muted uk-text-nowrap"><?php echo $ctr = (($this->params['paging']['TrainingCreation']['page'] * $this->params['paging']['TrainingCreation']['limit']) - $this->params['paging']['TrainingCreation']['limit']) + $i; ?></span></td>
                                                <td>
                                                    <?php echo $this->Common->getTrainingClassName($trainingList['TrainingCreation']['course_id']); ?>
                                                </td>
                                                <td>
                                                    <?php echo date("d-m-Y", strtotime($trainingList['TrainingCreation']['training_date'])); ?>
                                                </td>
                                                <td>
                                                    <?php echo $trainingList['TrainingCreation']['training_start_time']; ?>
                                                </td>
                                                <td>
                                                    <?php
                                                    if ($trainingList['TrainingCreation']['initated_by'] == 'I')
                                                        echo 'Indentification';
                                                    elseif ($trainingList['TrainingCreation']['initated_by'] == 'E')
                                                        echo 'Enrollment';
                                                    elseif ($trainingList['TrainingCreation']['initated_by'] == 'P')
                                                        echo 'Perforamce Management System';
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php
                                                    if ($trainingList['TrainingCreation']['status'] == '4') {
                                                        echo "<span class='uk-badge uk-badge-danger'>" . $this->Common->findSatus(4) . "</span>";
                                                    } else if ($trainingList['TrainingCreation']['status'] == '5') {
                                                        echo "<span class='uk-badge uk-badge-success'>" . $this->Common->findSatus(5) . "</span>";
                                                    } else if ($trainingList['TrainingCreation']['status'] == '2') {
                                                        echo "<span class='uk-badge uk-badge-primary'>" . $this->Common->findSatus(2) . "</span>";
                                                    } else if ($trainingList['TrainingCreation']['status'] == '1') {
                                                        echo "<span class='uk-badge uk-badge-primary'>" . $this->Common->findSatus(1) . "</span>";
                                                    }
                                                    ?>
                                                </td>
                                                <td><span class="uk-text-upper">
                                                        <?php if ($trainingList['TrainingCreation']['status'] == 1 && $trainingList['TrainingCreation']['emp_code'] == $emp_codes) { ?>
                                                            <a href="<?php echo $this->webroot; ?>training/workflow_display/<?php echo base64_encode($trainingList['TrainingCreation']['training_id']); ?>/" class="md-btn md-btn-primary md-btn-small md-btn-wave-light waves-effect waves-button waves-light">Forward</a>
                                                            <a class="md-btn md-btn-small uk-badge uk-badge-danger" href="<?php echo $this->webroot; ?>training/deleteTraining/<?php echo base64_encode($trainingList['TrainingCreation']['training_id']); ?>/" title="Click to Edit." onclick="return confirm('Are you sure?')" >Delete</a>
                                                        <?php } ?>
                                                        <a data-uk-modal="{target:'#modal_overflow'}" onclick="Get_Details('<?php echo base64_encode($trainingList['TrainingCreation']['training_id']); ?>')" class="md-btn md-btn-primary md-btn-small md-btn-wave-light waves-effect waves-button waves-light">View</a>
                                                    </span></td>
                                            </tr>
                                        </tbody>
                                        <?php
                                        $i++;
                                    }
                                } else {
                                    ?>
                                    <tbody>
                                        <tr>
                                            <td>
                                                No Record Found
                                            </td>
                                        </tr>
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