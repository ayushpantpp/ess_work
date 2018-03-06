<div id="page_content">
    <div id="page_content_inner">
        <h3 class="heading_b uk-margin-bottom">Training Report</h3>
        <?php echo $flash = $this->Session->flash(); ?>
        <div id="alerts"></div>
        <div class="md-card uk-margin-medium-bottom">
            <div class="md-card-content">
                <div class="uk-accordion" data-uk-accordion>
                    <h3 class="uk-accordion-title">Employee Training History</h3>
                    <div class="uk-accordion-content">
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
                                                if ($this->Common->checkTrainingEvolution($classList['TrainingCreation']['training_id'])) {
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
                                                                    <a href="<?php echo $this->webroot; ?>training/viewMatrix/<?php echo base64_encode($classList['TrainingCreation']['training_id']); ?>/" class="md-btn md-btn-danger md-btn-small md-btn-wave-light waves-effect waves-button waves-light">View</a>
                                                                    <a href="<?php echo $this->webroot; ?>training/generateEmpHistoryReportPdf/<?php echo base64_encode($classList['TrainingCreation']['training_id']); ?>/" class="md-btn md-btn-danger md-btn-small md-btn-wave-light waves-effect waves-button waves-light">Generate Report</a>
                                                                </span>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                    <?php
                                                    $i++;
                                                }
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
                    <h3 class="uk-accordion-title">Monthly Training Summary Report</h3>
                    <div class="uk-accordion-content">
                        <div class="uk-grid" data-uk-grid-margin>
                            <div class="uk-width-1-1">
                                <?php echo $this->Form->create('Training', array('url' => array('controller' => 'training', 'action' => 'generateEmpMonthlyReportPdf'), 'id' => 'form_validation', 'enctype' => 'multipart/form-data', 'onsubmit' => 'return monthlyReport(this)', 'class' => 'uk-form-stacked')); ?>
                                <div class="uk-width-medium-1-2">
                                    <div class="uk-form-row">
                                        <div class="uk-grid">
                                            <div class="uk-width-medium-1-2">
                                                <label>Start Date*</label>
                                                <input type="text" class="md-input label-fixed" name="sch_start_date" id="sch_start_date" />
                                            </div>
                                            <div class="uk-width-medium-1-2">
                                                <label>End Date*</label>
                                                <input type="text" class="md-input label-fixed" name="sch_end_date" id="sch_end_date"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="uk-form-row">
                                        <div class="uk-grid">
                                            <div class="uk-width-medium-1-4">
                                                <span class="uk-input-group-addon"><button type="submit" name="submit" value="submit" class="md-btn">Generate</button></span>
                                            </div>
                                            <div class="uk-width-medium-1-4">
                                                <span class="uk-input-group-addon"><a class="md-btn md-btn-wave waves-effect waves-button" href="<?php echo $this->webroot; ?>training/employeeHistoryReport/">Cancel</a></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php echo $this->Form->end(); ?>
                            </div>
                        </div>
                    </div>
                    <h3 class="uk-accordion-title">Course Wise Report</h3>
                    <div class="uk-accordion-content">
                        <div class="uk-grid" data-uk-grid-margin>
                            <div class="uk-width-1-1">
                                <?php echo $this->Form->create('Training', array('url' => array('controller' => 'training', 'action' => 'generateCourseWiseReportPdf'), 'id' => 'form_validation', 'enctype' => 'multipart/form-data', 'onsubmit' => 'return courseReport(this)', 'class' => 'uk-form-stacked')); ?>
                                <div class="uk-width-medium-1-1">
                                    <div class="uk-form-row">
                                        <div class="uk-grid">
                                            <div class="uk-width-medium-1-3">
                                                <label>Course Name</label>
                                                <select id="val_select" name="course_id" class="md-input">
                                                    <?php
                                                    if (!empty($courselists)) {
                                                        foreach ($courselists as $ky => $val) {
                                                            ?>
                                                            <option value="<?php echo $ky; ?>"><?php echo $val; ?></option>
                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="uk-width-medium-1-3">
                                                <label>Start Date*</label>
                                                <input type="text" class="md-input label-fixed" name="min_start_date" id="min_start_date" />
                                            </div>
                                            <div class="uk-width-medium-1-3">
                                                <label>End Date*</label>
                                                <input type="text" class="md-input label-fixed" name="min_end_date" id="min_end_date"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="uk-form-row">
                                        <div class="uk-grid">
                                            <div class="uk-width-medium-1-4">
                                                <span class="uk-input-group-addon"><button type="submit" name="submit" value="submit" class="md-btn">Generate</button></span>
                                            </div>
                                            <div class="uk-width-medium-1-4">
                                                <span class="uk-input-group-addon"><a class="md-btn md-btn-wave waves-effect waves-button" href="<?php echo $this->webroot; ?>training/employeeHistoryReport/">Cancel</a></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php echo $this->Form->end(); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    jQuery("#sch_start_date").datepicker({
        dateFormat: 'dd-mm-yy',
        inline: true,
        changeMonth: true,
        changeYear: true,
        autoclose: true,
    });
    jQuery("#sch_end_date").datepicker({
        dateFormat: 'dd-mm-yy',
        inline: true,
        changeMonth: true,
        changeYear: true,
        autoclose: true
    });
    jQuery("#min_start_date").datepicker({
        dateFormat: 'dd-mm-yy',
        inline: true,
        changeMonth: true,
        changeYear: true,
        autoclose: true,
    });
    jQuery("#min_end_date").datepicker({
        dateFormat: 'dd-mm-yy',
        inline: true,
        changeMonth: true,
        changeYear: true,
        autoclose: true
    });
    jQuery("#sch_start_date").attr("readonly", true);
    jQuery("#sch_end_date").attr("readonly", true);
    jQuery("#min_start_date").attr("readonly", true);
    jQuery("#min_end_date").attr("readonly", true);

    function monthlyReport(idd) {
        var dateFirst = jQuery('#sch_start_date').val().split('-');
        var dateSecond = jQuery('#sch_end_date').val().split('-');
        var valuefirst = new Date(dateFirst[2], dateFirst[1], dateFirst[0]); //Year, Month, Date
        var valuesecond = new Date(dateSecond[2], dateSecond[1], dateSecond[0]);

        if (jQuery('#sch_start_date').val() == "")
        {
            $("#alerts").html("<div data-uk-alert='' class='uk-alert uk-alert-danger'><a class='uk-alert-close uk-close' href='#'></a>Please enter the Start Date").show();
            $("html, body").animate({scrollTop: 0}, "slow");
            return false;
        } else if (jQuery('#sch_end_date').val() == "")
        {
            $("#alerts").html("<div data-uk-alert='' class='uk-alert uk-alert-danger'><a class='uk-alert-close uk-close' href='#'></a>Please enter the End Date").show();
            $("html, body").animate({scrollTop: 0}, "slow");
            return false;
        } else if (valuesecond < valuefirst) {
            $("#alerts").html("<div data-uk-alert='' class='uk-alert uk-alert-danger'><a class='uk-alert-close uk-close' href='#'></a>End Date should be greater or equal than Start Date").show();
            $("html, body").animate({scrollTop: 0}, "slow");
            return false;
        }
    }
    
    function courseReport(idd) {
        var dateFirst = jQuery('#min_start_date').val().split('-');
        var dateSecond = jQuery('#min_end_date').val().split('-');
        var valuefirst = new Date(dateFirst[2], dateFirst[1], dateFirst[0]); //Year, Month, Date
        var valuesecond = new Date(dateSecond[2], dateSecond[1], dateSecond[0]);

        if (jQuery('#min_start_date').val() == "")
        {
            $("#alerts").html("<div data-uk-alert='' class='uk-alert uk-alert-danger'><a class='uk-alert-close uk-close' href='#'></a>Please enter the Start Date").show();
            $("html, body").animate({scrollTop: 0}, "slow");
            return false;
        } else if (jQuery('#min_end_date').val() == "")
        {
            $("#alerts").html("<div data-uk-alert='' class='uk-alert uk-alert-danger'><a class='uk-alert-close uk-close' href='#'></a>Please enter the End Date").show();
            $("html, body").animate({scrollTop: 0}, "slow");
            return false;
        } else if (valuesecond < valuefirst) {
            $("#alerts").html("<div data-uk-alert='' class='uk-alert uk-alert-danger'><a class='uk-alert-close uk-close' href='#'></a>End Date should be greater or equal than Start Date").show();
            $("html, body").animate({scrollTop: 0}, "slow");
            return false;
        }
    }

</script>