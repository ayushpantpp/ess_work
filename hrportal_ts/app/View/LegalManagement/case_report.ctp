<script type="text/javascript">
function checkdate(){
    var start = $('#from_date').val();
    var end = $('#end_date').val();
    
 if(start!='' && end!=''){
        var date1 = Date.parse(start);
        var date2 = Date.parse(end);

            if (date1 > date2) {
            alert ("From Date should be less than To Date !!");
            return false;
        }
        
   }else if((start=='' && end!='') || (start!='' && end=='')){
       alert('Please Select Both Request Received Date');
       return false;
   }
   
}
</script>
<div id="page_content">
    <div id="page_heading" data-uk-sticky="{ top: 48, media: 960 }">
        <h1>Generate Report</h1>
    </div>
    <div id="page_content_inner">
        <?php echo $flash = $this->Session->flash(); ?> 
        <div class="md-card">  
            <div class="md-card-content large-padding">
                <?php
                echo $this->Form->create('doc', array('url' => array('controller' => 'LegalManagement', 'action' => 'case_report'), 'type' => 'file', 'id' => 'form_validation', 'class' => 'uk-form-stacked'));
                ?>
                <h3 class="heading_a">Court Case Report</h3>
                <div class="uk-grid" data-uk-grid-margin>

                    <div class="uk-width-medium-1-2" >
                        <div class="parsley-row">
                            <label for="folder" class="md-input label-fixed">Received Cases</label>
                            <?php
                            echo $this->form->input('case_num', array('label' => false, 'type' => "select", 'empty' => ' -- Select --', 'options' => $CaseReceives, 'class' => "md-input data-md-selectize"));
                            ?>
                        </div>
                    </div>

                    <div class="uk-width-medium-1-2">
                        <div class="parsley-row">
                            <label for="dos" class="md-input label-fixed">Date of Service </label>
                            <?php
                            echo $this->form->input('date_of_service', array('type' => "text", 'label' => false, 'data-uk-datepicker' => '{format:"DD-MM-YYYY"}', 'class' => "md-input"));
                            ?>
                            <span class="md-input-bar"></span>
                        </div>
                    </div>
                </div> 
                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-1-1" >
                        <div class="parsley-row">
                            <label for="dos" class="md-input label-fixed">Court Case Analysis By (Bring up Date) </label>

                            <span class="md-input-bar"></span>
                        </div>
                    </div>

                </div>
                <div class="uk-grid" data-uk-grid-margin>

                    <div class="uk-width-medium-1-2" >
                        <div class="parsley-row">
                            <label for="dos" class="md-input label-fixed">From Date </label>
                            <?php
                            echo $this->form->input('from_date', array('type' => "text", 'id'=>'from_date','label' => false, 'data-uk-datepicker' => '{format:"YYYY-MM-DD"}', 'class' => "md-input"));
                            ?>
                            <span class="md-input-bar"></span>
                        </div>
                    </div>

                    <div class="uk-width-medium-1-2">
                        <div class="parsley-row">
                            <label for="dos" class="md-input label-fixed">End Date </label>
                            <?php
                            echo $this->form->input('end_date', array('type' => "text", 'id'=>'end_date', 'label' => false, 'data-uk-datepicker' => '{format:"YYYY-MM-DD"}', 'class' => "md-input"));
                            ?>
                            <span class="md-input-bar"></span>
                        </div>
                    </div>
                </div>
                <div class="uk-grid" data-uk-grid-margin></div>
                <div class="uk-grid data-uk-grid-margin">
                    <div class="uk-width-medium-1-2">
                        <div class="parsley-row">
                            <?php //echo $this->form->input('task_id', array('label' => "Task List", 'type' => "select",'empty' => ' -- Select Task --', 'options' => $CaseOutcome, 'class' => "md-input",'id' => 'task_id','data-md-selectize')); ?>
                            <label for="case_outcome" class="md-input label-fixed">Case Outcome </label>
                            <?php
                            echo $this->form->input('case_outcome', array('label' => false, 'type' => "select", 'empty' => ' -- Select --', 'options' => $CaseOutcome, 'class' => "md-input", 'data-md-selectize'));
                            ?>
                        </div>
                    </div>
                    <div class="uk-width-medium-1-2">
                        <div class="parsley-row">
                            <label for="case_status" class="md-input label-fixed">Case Status <span class="req">*</span></label>
                            <?php
                            echo $this->form->input('case_status', array('label' => false, 'type' => "select", 'empty' => ' -- Select --', 'options' => $CaseOutcome, 'class' => "md-input", 'data-md-selectize'));
                            ?>
                        </div>
                    </div> 

                </div>
                <div class="uk-grid data-uk-grid-margin">
                    <div class="  uk-width-1-2  uk-margin-top ">                            
                        <button type="submit" name="submit" value="submit"  class="md-btn md-btn-success "  onclick="return checkdate();" href="#">Generate</button>                    
                    </div>
                    <div class="uk-width-1-3 uk-margin-top  ">                            
                        <a class="md-btn md-btn-primary" href="<?php echo $this->Html->url('case_report') ?>">Reset</a>                       
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
                    <h3 class="heading_a uk-margin-small-bottom">Court Case Report



                        <div class="clearfix"></div>
                        <div class="uk-overflow-container uk-margin-bottom">
                            <table class="uk-table uk-table-align-vertical uk-table-nowrap tablesorter tablesorter-altair" id="ts_issues">
                                <thead>
                                    <tr>
                                        <th class="uk-text-center">S.No.</th>
                                        <th class="uk-text-center">Case Number</th>
                                        <th>PSC file Number</th>
                                        <th>Ministry</th>
                                        <th>Request Category</th>
                                        <th>Action Officer</th>
                                        <th>Subject</th>
                                        <th>Date of Service</th>
                                        <th class="filter-false remove sorter-false">Report</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
//                                    echo "<pre>";
//                                    print_r($CaseReceives);die;
                                    $i = 1;
                                    foreach ($Case_Receives as $rec) {
                                        ?>
                                        <tr>
                                            <td><span class="uk-text-small uk-text-muted uk-text-nowrap"><?php echo $i; ?></span></td>
                                            <td><span class="uk-text-small uk-text-muted uk-text-nowrap"><?php echo $rec['CaseReceive']['court_case_number']; ?></span></td>
                                            <td><span class="uk-text-small uk-text-muted uk-text-nowrap"><?php echo $rec['CaseReceive']['psc_file_number']; ?></span></td>
                                            <td><span class="uk-text-small uk-text-muted uk-text-nowrap"><?php echo $rec['Ministry']['ministry_name'] . " [" . $rec['Ministry']['ministry_code'] . "]"; ?></span></td>
                                            <td><span class="uk-text-small uk-text-muted uk-text-nowrap"><?php echo $rec['MstRequest']['req_type_name']; ?></span></td>
                                            <td><span class="uk-text-small uk-text-muted uk-text-nowrap"><?php echo $rec['MyProfile']['emp_full_name']; ?></span></td>
                                            <td><span class="uk-text-small uk-text-muted uk-text-nowrap"><?php echo $rec['CaseReceive']['subject']; ?></span></td>
                                            <td><span class="uk-text-small uk-text-muted uk-text-nowrap"><?php echo date("d/m/Y", strtotime($rec['CaseReceive']['date_of_service'])); ?></span></td>
                                            <td><span class="uk-text-small uk-text-muted uk-text-nowrap">
                                                    <!--<a class="uk-badge uk-badge-primery" id="form_open" href="<?php //echo $this->Html->url('case_details/'.$rec['CaseReceive']['id']);  ?>">Case Details</a>-->
                                                    <a class="uk-badge uk-badge-primery" id="form_open" href="<?php echo $this->Html->url('generate_case_report_pdf/' . $rec['CaseReceive']['id']); ?>">Generate PDF</a>
                                                </span>
                                            </td>

                                        </tr>
                                        <?php
                                        $i++;
                                    }

                                    if ($date_of_service == '') {
                                        $date_of_service = 'null';
                                    }
                                    if ($bringup_from_date == '' && $bringup_end_date == '') {
                                        $bringup_from_date = 'null';
                                        $bringup_end_date = 'null';
                                    }
                                    if ($case_num == '') {
                                        $case_num = 'null';
                                    }
                                    if ($case_outcome == '') {
                                        $case_outcome = 'null';
                                    }
                                    if ($case_status == '') {
                                        $case_status = 'null';
                                    }
                                    ?>
                                    <tr><td colspan="9" style="text-align:center;"><a class="uk-badge uk-badge-primery" id="form_open" href="<?php echo $this->Html->url('generate_allcase_report_pdf/'.$date_of_service.'/'.$bringup_from_date.'/'.$bringup_end_date.'/'.$case_num.'/'.$case_outcome.'/'.$case_status); ?>">Generate PDF</a></td></tr>
                                </tbody>
                            </table>
                        </div>
                </div>
            </div>
        </div>

    <?php } ?>
</div>

