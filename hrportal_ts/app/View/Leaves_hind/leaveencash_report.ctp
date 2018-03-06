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
    <div id="page_heading" data-uk-sticky="{ top: 48, media: 960 }">
        <h1>Employee LeaveEncash Report</h1>
    </div>
    <div id="page_content_inner">
        <?php echo $flash = $this->Session->flash(); ?> 
        <div class="md-card">  
            <div class="md-card-content large-padding">
                <?php
                echo $this->Form->create('doc', array('url' => array('controller' => 'Leaves', 'action' => 'leaveencash_report'), 'type' => 'file', 'id' => 'form_validation', 'class' => 'uk-form-stacked'));
                ?>
                <h3 class="heading_a">LeaveEncash Report<?php //echo $flag;  ?></h3>
                <div class="uk-grid" data-uk-grid-margin>

                    <div class="uk-width-medium-1-2" >
                        <div class="parsley-row">
                            <label for="folder" class="md-input label-fixed">LeaveEncash Status</label>
                            <?php
                            echo $this->form->input('status', array('label' => false, 'type' => "select", 'empty' => ' -- Select --', 'options' => $voucherStatus, 'class' => "md-input data-md-selectize"));
                            ?>
                        </div>
                    </div>


                </div> 
                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-1-1" >
                        <div class="parsley-row">
                            <label for="dos" class="md-input label-fixed">Date Wise Reports </label>

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
                        <a class="md-btn md-btn-primary" href="<?php echo $this->Html->url('leave_report') ?>">Reset</a>                       
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
                    <h3 class="heading_a uk-margin-small-bottom">LeaveEncash Report</h3>
                    <div class="clearfix"></div>
                    <div class="uk-overflow-container uk-margin-bottom">
                        <?php echo $this->Form->create('LeaveReport', array('url' => array('controller' => 'Leaves', 'action' => 'expense_payment_status'), 'id' => 'form_validation', 'class' => 'uk-form-stacked')); ?>
                        <table class="uk-table uk-table-align-vertical uk-table-nowrap tablesorter tablesorter-altair" >
                            <thead>
                                <tr>
                                    <?php if ($vouch_status == '9') { ?>
                                        <th class="filter-false remove sorter-false"><input type="checkbox" class="ts_checkbox_all"></th>
                                    <?php } ?>
                                    <th class="uk-text-center">S.No.</th>
                                    <th class="uk-text-center">Employee Name</th>
                                    <th class="uk-text-center">Leave Date</th>
                                    <th class="uk-text-center">Leave Type</th>
                                    <th class="uk-text-center">Leave Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                //print_r($VoucherDetails); die;
                                foreach ($VoucherDetails as $rec) {
                                    if ($rec['ConveyencExpenseDetail']['payment_status'] == '1') {
                                        $paymentStatus = "Paid";
                                        $payChacked = "checked = ''";
                                        $cls = "uk-badge uk-badge-info";
                                    } else {
                                        $paymentStatus = "Due";
                                        $payChacked = "";
                                        $cls = "uk-badge uk-badge-danger";
                                    }
                                    ?>
                                    <tr>
                                        <?php if ($vouch_status == '9') { ?>
                                            <td><input type="checkbox" data-md-icheck  <?php echo $payChacked; ?> name="id[]" class="ts_checkbox" value="<?php echo $rec['ConveyencExpenseDetail']['id']; ?>"></td>                        
                                        <?php } ?>
                                        <td class="uk-text-small uk-text-muted uk-text-center"><?php echo $i; ?></td>
                                         <td><span class="uk-text-small uk-text-muted uk-text-nowrap"><?php echo $this->Common->getempname($rec['LeaveEncshDt']['emp_code']); ?></span></td>
                                        <td><span class="uk-text-small uk-text-muted uk-text-nowrap"><?php echo date("d/m/Y", strtotime($rec['LeaveEncshDt']['created_at'])); ?></span></td>
                                        <td class="uk-text-small uk-text-muted uk-text-center"><?php echo $this->Common->findLeaveType($rec['LeaveEncshDt']['leave_id']); ?></td>
                                        <td class="uk-text-small uk-text-muted uk-text-center"><?php echo $this->Common->findSatus($rec['LeaveEncshDt']['leaveencash_status']); ?></td>
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
   


                            </tbody>
                        </table>

                        <div class="clearfix"></div>
    <?php if ($vouch_status == '9') { ?>
                            <div class="uk-grid" data-uk-grid-margin>
                                <div class="uk-width-medium-1-2">
                                    <div class="parsley-row">
                                        <label for="hobbies" class="uk-form-label">Payment Status (1 minimum):</label>

                                        <span class="icheck-inline">
                                            <input type="radio" value="1" name="payment_status" id="payment_status" checked="checked" required="" data-md-icheck />
                                            <label for="val_check_ski" class="inline-label">Paid</label>
                                        </span>
                                        <span class="icheck-inline">
                                            <input type="radio" value="0" name="payment_status" id="payment_status" data-md-icheck />
                                            <label for="val_check_run" class="inline-label">Due</label>
                                        </span>                             
                                    </div>
                                    <input type="submit" name="submit" class="md-btn md-btn-success" value="Status Update">
                                    <!--<button type="reset" name="reset" class="md-btn md-btn-primary">Reset</button>-->

                                </div>
                                <div class="uk-width-medium-1-2">
                                    <div class="parsley-row">
                                        <a class="uk-badge uk-badge-primery" id="form_open" href="<?php echo $this->Html->url('generate_leaveencash_report/' . $from_date . '/' . $end_date . '/' . $vouch_status); ?>">Generate PDF</a>
                                    </div>
                                </div>

                            </div>
    <?php } else { ?>
                            <div class="uk-grid" data-uk-grid-margin>
                                <div class="uk-width-medium-1-2">

                                </div>
                                <div class="uk-width-medium-1-2">
                                    <div class="parsley-row">
                                        <a class="uk-badge uk-badge-primery" id="form_open" href="<?php echo $this->Html->url('generate_leaveencash_report/' . $from_date . '/' . $end_date . '/' . $vouch_status); ?>">Generate PDF</a>
                                    </div>
                                </div>
                            </div>
    <?php } ?>
    <?php echo $this->Form->end(); ?>
                    </div>


                </div>
            </div>
<?php } ?>


