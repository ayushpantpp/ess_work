<script type="text/javascript">
    function checkdate() {
        var start = $('.from_date').val();
        var end = $('.end_date').val();

        if (start != '' && end != '') {
            var date1 = Date.parse(start);
            var date2 = Date.parse(end);

            if (date1 > date2) {
                alert("From Date should be less than To Date !!");
                return false;
            }

        } else if ((start == '' && end != '') || (start != '' && end == '')) {
            alert('Please Select Both Date');
            return false;
        }

    }
</script>
<div id="page_content">
    
    <div id="page_content_inner">
        <?php echo $flash = $this->Session->flash(); ?> 
        <div class="md-card">  
        <div class="md-card-toolbar">
                            <div class="md-card-toolbar-actions">
                                
                               
                            </div>
                            <h3 class="md-card-toolbar-heading-text">
                                Employee Medical Report
                            </h3>
                        </div>
            <div class="md-card-content large-padding">
                <?php
                echo $this->Form->create('doc', array('url' => array('controller' => 'Medical', 'action' => 'employee_medical_report'), 'type' => 'file', 'id' => 'form_validation', 'class' => 'uk-form-stacked'));
                ?>
            
                <div class="uk-grid" data-uk-grid-margin>

                    <div class="uk-width-medium-1-2" >
                        <div class="parsley-row">
                            <label for="folder" class="md-input label-fixed">Medical Status</label>
                            <?php
                            echo $this->form->input('medical_status', array('label' => false, 'type' => "select", 'empty' => ' -- Select --', 'options' => $voucherStatus, 'class' => "md-input data-md-selectize"));
                            ?>
                        </div>
                    </div>
                </div> 
                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-1-1" >
                        <div class="parsley-row">
                            <label for="dos" class="md-input label-fixed">Claim date wise reports </label>

                            <span class="md-input-bar"></span>
                        </div>
                    </div>

                </div>
                <div class="uk-grid" data-uk-grid-margin>

                    <div class="uk-width-medium-1-2" >
                        <div class="parsley-row">
                            <label for="dos" class="md-input label-fixed">From Date </label>
                            <?php
                            echo $this->form->input('from_date', array('type' => "text", 'label' => false, 'data-uk-datepicker' => '{format:"YYYY-MM-DD"}', 'id' => 'uk_dp_start', 'readonly' => 'readonly', 'class' => "from_date md-input"));
                            ?>
                            <span class="md-input-bar"></span>
                        </div>
                    </div>

                    <div class="uk-width-medium-1-2">
                        <div class="parsley-row">
                            <label for="dos" class="md-input label-fixed">End Date </label>
                            <?php
                            echo $this->form->input('end_date', array('type' => "text", 'id' => 'uk_dp_end', 'label' => false, 'data-uk-datepicker' => '{format:"YYYY-MM-DD"}', 'readonly' => 'readonly', 'class' => "end_date md-input"));
                            ?>
                            <span class="md-input-bar"></span>
                        </div>
                    </div>
                </div>
                <div class="uk-grid" data-uk-grid-margin></div>

                <div class="uk-grid data-uk-grid-margin">
                    <div class="  uk-width-1-2  uk-margin-top ">                            
                        <button type="submit" name="submit" value="submit"  class="md-btn md-btn-success "  onclick="return checkdate();" href="#">Generate</button>                    
                    </div>
                    <div class="uk-width-1-3 uk-margin-top  ">                            
                        <a class="md-btn md-btn-primary" href="<?php echo $this->Html->url('employee_medical_report') ?>">Reset</a>                       
                    </div>
                </div>

                <?php echo $this->Form->end(); ?>

            </div>
        </div>
    </div>

    <script src="<?php echo $this->webroot; ?>js/jquery.min.js"></script>
    <script src="<?php echo $this->webroot; ?>js/jquery-ui.min.js"></script>
    <?php if ($flag == 'open') { ?>


    <div id="page_content_inner">
            <?php echo $flash = $this->Session->flash(); ?> 
        <div class="md-card" >
            <div class="md-card-content ">
                <h3 class="heading_a uk-margin-small-bottom">Report</h3>
                <div class="clearfix"></div>
                <div class="uk-overflow-container uk-margin-bottom">
                    <table class="uk-table uk-table-align-vertical uk-table-nowrap tablesorter tablesorter-altair" >
                        <thead>
                            <tr>
                                <th class="uk-text-center">S.No.</th>
                                <th class="uk-text-center">Employee Name</th>
                                <th class="uk-text-center">Claim Date</th>
                            </tr>
                        </thead>
                        <tbody>
                                <?php
                                $i = 1;
                                    
                                foreach ($VoucherDetails as $rec) {
                                    if ($rec['MedicalBillAmount']['status'] == '1') {
                                       
                                    } else {
                                        
                                    }
                                    ?>
                            <tr>
                                <td class="uk-text-small uk-text-muted uk-text-center"><?php echo $i; ?></td>
                                <td><span class="uk-text-small uk-text-muted uk-text-nowrap"><?php echo $this->Common->getempname($rec['MedicalBillAmount']['emp_code']); ?></span></td>
                                <td class="uk-text-small uk-text-muted uk-text-center"><?php echo date("d/m/Y", strtotime($rec['MedicalBillAmount']['created_at'])); ?></td>
                            </tr>


                                    <?php
                                    $i++;
                                }
                                ?>

                                <?php
                                if ($from_date == '') {
                                    $from_date = 'null';
                                }
                                if ($end_date == '') {
                                    $end_date = 'null';
                                }
                                if ($vouch_status == '') {
                                    $vouch_status = 'null';
                                }
                                ?>
    <!--<tr><td colspan="9" style="text-align:center;"><a class="uk-badge uk-badge-primery" id="form_open" href="<?php //echo $this->Html->url('generate_allcase_report_pdf/'.$date_of_service.'/'.$bringup_from_date.'/'.$bringup_end_date.'/'.$case_num.'/'.$case_outcome.'/'.$case_status); ?>">Generate PDF</a></td></tr>-->




                        </tbody>
                    </table>

                    <div class="clearfix"></div>
    <?php if ($vouch_status == '5') { ?>
                    <div class="uk-grid" data-uk-grid-margin style="text-align: center">
                        <div class="uk-width-medium-1">
                            <div class="parsley-row">
                                <a class="uk-badge uk-badge-primery" id="form_open" href="<?php echo $this->Html->url('generate_emp_medical_report_pdf/' . $from_date . '/' . $end_date . '/' . $vouch_status); ?>">Generate PDF</a>
                            </div>
                        </div>

                    </div>
    <?php } else { ?>
                    <div class="uk-grid" data-uk-grid-margin>
                        <div class="uk-width-medium-1-2">

                        </div>
                        <div class="uk-width-medium-1" style="text-align: center">
                            <div class="parsley-row">
                                <a class="uk-badge uk-badge-primery" id="form_open" href="<?php echo $this->Html->url('generate_emp_medical_report_pdf/' . $from_date . '/' . $end_date . '/' . $vouch_status); ?>">Generate PDF</a>
                            </div>
                        </div>
                    </div>
    <?php } ?>
                </div>


            </div>
        </div>
<?php } ?>


