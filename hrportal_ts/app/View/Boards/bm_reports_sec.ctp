<script type="text/javascript">
function checkdate(){
    
    var start = $('#meet_from_date').val();
    var end = $('#meet_to_date').val();
    var start_req = $('#req_from_date').val();
    var end_req = $('#req_to_date').val();
 if(start!='' && end!=''){
        var date1 = Date.parse(start);
        var date2 = Date.parse(end);

        if (date1 > date2) {
            alert ("From Date should be less than To Date for Meeting Date !!");
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
        <h1>Generate Report 2</h1>
    </div>
    <div id="page_content_inner">
        <?php echo $flash = $this->Session->flash(); ?> 
        <div class="md-card">  
            <div class="md-card-content large-padding">
                <?php
                echo $this->Form->create('doc', array('url' => array('controller' => 'Boards', 'action' => 'bm_reports_sec'), 'type' => 'file', 'id' => 'form_validation', 'class' => 'uk-form-stacked'));
                ?>
                <h3 class="heading_a">Board Management Report</h3>
                <div class="uk-grid" data-uk-grid-margin>

                    <div class="uk-width-medium-1-2" >
                        <div class="parsley-row">
                            <label for="folder" class="md-input label-fixed">Ministry</label>
                            <?php
                            echo $this->form->input('ministry', array('label' => false, 'type' => "select", 'empty' => ' -- Select --', 'options' => $Ministry, 'class' => "md-input data-md-selectize"));
                            ?>
                        </div>
                    </div>
                    <div class="uk-width-medium-1-2" >
                        <div class="parsley-row">
                            <label for="folder" class="md-input label-fixed">Department</label>
                            <?php
                            $department = $this->common->findDepartmentList();
                            array_unshift($department, '---Select---');
                            echo $this->form->input('depart', array('label' => false, 'type' => "select", 'empty' => ' -- Select --', 'options' => $department, 'class' => "md-input data-md-selectize"));
                            ?>
                        </div>
                    </div>

                </div> 
                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-1-1" >
                        <div class="parsley-row">
                            <label for="dos" class="md-input label-fixed">Time Period(Meeting Date) </label>

                            <span class="md-input-bar"></span>
                        </div>
                    </div>

                </div>
                <div class="uk-grid" data-uk-grid-margin>

                    <div class="uk-width-medium-1-2" >
                        <div class="parsley-row">
                            <label for="dos" class="md-input label-fixed">From Date </label>
                            <?php
                            echo $this->form->input('meet_from_date', array('type' => "text", 'id'=>'meet_from_date','label' => false, 'data-uk-datepicker' => '{format:"YYYY-MM-DD"}', 'class' => "md-input"));
                            ?>
                            <span class="md-input-bar"></span>
                        </div>
                    </div>

                    <div class="uk-width-medium-1-2">
                        <div class="parsley-row">
                            <label for="dos" class="md-input label-fixed">To Date </label>
                            <?php
                            echo $this->form->input('meet_to_date', array('type' => "text", 'id'=>'meet_to_date','label' => false, 'data-uk-datepicker' => '{format:"YYYY-MM-DD"}', 'class' => "md-input"));
                            ?>
                            <span class="md-input-bar"></span>
                        </div>
                    </div>
                </div>
                
                <div class="uk-grid" data-uk-grid-margin></div>
                <div class="uk-grid data-uk-grid-margin">
                    <div class="uk-width-medium-1-2">
                        <div class="parsley-row">
                            <label for="case_outcome" class="md-input label-fixed">Marking Officer </label>
                            <?php
                            echo $this->form->input('action_officer', array('label' => false, 'type' => "select", 'empty' => ' -- Select --', 'options' => $ActionOfficer, 'class' => "md-input", 'data-md-selectize'));
                            ?>
                        </div>
                    </div>
                 </div>
                <div class="uk-grid data-uk-grid-margin">
                    <div class="  uk-width-1-2  uk-margin-top ">                            
                        <button type="submit" name="submit" value="submit" class="md-btn md-btn-success " onclick="return checkdate();" href="#">Generate</button>                    
                    </div>
                    <div class="uk-width-1-3 uk-margin-top  ">                            
                        <a class="md-btn md-btn-primary" href="<?php echo $this->Html->url('bm_reports_sec') ?>">Reset</a>                       
                    </div>
                </div>

                <?php echo $this->Form->end(); ?>

            </div>
        </div>
    </div>

    <?php if ($flag == 'open') { ?>
        <div id="page_content_inner">
            <?php echo $flash = $this->Session->flash(); ?> 
            <div class="md-card" >
                <div class="md-card-content ">
                    <h3 class="heading_a uk-margin-small-bottom">Board Management Service Report</h3>
                    <div class="clearfix"></div>
                    <div class="uk-overflow-container uk-margin-bottom">
                        <table class="uk-table uk-table-align-vertical uk-table-nowrap tablesorter tablesorter-altair" id="ts_issues">
                            <thead>
                                <tr>
                                    <th class="uk-text-center">Total Number of Request</th>
                                    <th>Number of Request Finalized</th>
                                    <th>Number of Pending Request</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                //$i = 1;
                                //foreach ($Meeting_Request_Refnum as $rec) {
                                    ?>
                                    <tr>
                                        <td><span class="uk-text-small uk-text-muted uk-text-nowrap uk-text-center"><?php echo $TotalReq; ?></span></td>
                                        <td><span class="uk-text-small uk-text-muted uk-text-nowrap uk-text-center"><?php echo $count_Final; ?></span></td>
                                        <td><span class="uk-text-small uk-text-muted uk-text-nowrap uk-text-center"><?php echo $Pending; ?></span></td>
                                    </tr>
                                    <?php //$i++;
                                //}
                                ?>
                                <tr>
                                    <td colspan="6" style="text-align:center;">
                                        <?php
                                        if ($ministry == '') {
                                            $ministry = 'null';
                                        }
                                        if ($depart == '') {
                                            $depart = 'null';
                                        }
                                        if ($meet_from_date == '' && $meet_to_date == '') {
                                            $meet_from_date = 'null';
                                            $meet_to_date = 'null';
                                        }
                                        if ($action_officer == '') {
                                            $action_officer = 'null';
                                        }
                                        ?>
                                        <a class="uk-badge uk-badge-primery" style="text-align:center;" id="form_open" href="<?php echo $this->Html->url('generate_bm_report_sec_pdf/' . $ministry . "/" . $depart . "/" . $meet_from_date . "/" . $meet_to_date . "/" . $action_officer); ?>">Generate PDF</a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
<?php } ?>
</div>

