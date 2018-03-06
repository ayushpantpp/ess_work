<div id="page_content" role="main">
    <div id="page_content_inner">        
        <h3 class="heading_b uk-margin-bottom"></h3>
        <?php echo $flash = $this->Session->flash(); ?>
        <div id="alerts"></div> 
        <div class="md-card">
        
        <div class="md-card-toolbar">
                            <div class="md-card-toolbar-actions">
                                
                               
                            </div>
                            <h3 class="md-card-toolbar-heading-text">
                <font><b>LTA Claim Form</b></font>
                            </h3>
                        </div>
            <div class="md-card-content large-padding">
                <?php if (!$checklta && $ltamonthchkprocess == true) { ?>
                    <?php echo $this->Form->create('lat', array('url' => array('controller' => 'lta', 'action' => 'Ltaclaim'), 'id' => 'form_validation', 'enctype' => 'multipart/form-data', 'class' => 'uk-form-stacked')); ?>

                    <div class="uk-grid" data-uk-grid-margin>
                        <div class="uk-width-medium-1-1">
                            <div class="parsley-row">
                                <select class="md-input" name="loc_type" data-md-selectize = "data-md-selectize">
                                    <option value="N">Non Metro</option>
                                    <option value="M"> Metro</option>
                                </select>
                            </div>
                        </div>
                        <div class="uk-width-medium-1-3">
                            <label>Employee ID</label>
                            <div class="parsley-row">
                                <?php echo $this->form->input('task_id', array('label' => false, 'type' => "text", 'class' => "md-input", 'value' => $emp_details['emp_id'], 'disabled')); ?>
                            </div>
                        </div>

                        <div class="uk-width-medium-1-3">
                            <label>Employee Name</label>
                            <div class="parsley-row">
                                <?php
                                $v = $this->Common->option_attribute_name($gender);
                                $options = $this->Common->option_name($emp_nm_tl);
                                if ($v[$gender] == 'MALE') {

                                    echo $this->form->input('', array('label' => false, 'type' => "text", 'class' => "md-input", 'value' => $options[$emp_nm_tl] . " " . $emp_name, 'disabled'));
                                    ?>            

                                    <input name="title" type="hidden" value="<?php echo $emp_name; ?>" class="md-input">
                                <?php
                                } else {
                                    echo $this->form->input('', array('label' => false, 'type' => "text", 'class' => "md-input", 'value' => $options[$emp_nm_tl] . " " . $emp_name, 'disabled'));
                                    ?>
                                    <input name="title" type="hidden" value="<?php echo $emp_name; ?>" class="md-input">
    <?php } ?>
                            </div>
                        </div>

                        <div class="uk-width-medium-1-3">
                            <label>LTA Entitlement</label>
                            <div class="parsley-row">
                                <select  name='ltaclaimyear' data-md-selectize = "data-md-selectize">
                                    <?php if ($lta_block == 0) { ?>
                                        <option value="">0 Year</option>
                                    <?php } else { ?>
                                        <?php for ($i = 1; $i <= $lta_block; $i++) { ?>
                                            <option value=<?php echo $i; ?>><?php echo $i; ?> Year</option>
        <?php }
    } ?>  
                                </select> 
                            </div>
                        </div>

                        <div class="uk-width-medium-1-3">
                            <div class="parsley-row">
    <?php echo $this->form->input('bill_amt', array('label' => "Bill Amount *", 'type' => "text", 'class' => "md-input", 'id' => "bill", 'required' => TRUE)); ?>

                            </div>
                        </div>

                        <div class="uk-width-medium-1-3">
                            <div class="parsley-row">
    <?php $stdate = date("d-m-Y", strtotime(date('Y-m-d'))); ?>
    <?php echo $this->form->input('jour_start_date', array('label' => "Journey Start Date *", 'class' => "md-input", 'type' => 'text', 'id' => 'uk_dp_starts', 'readonly' => true, 'required' => TRUE)); ?>
                            </div>
                        </div>

                        <div class="uk-width-medium-1-3">
                            <div class="parsley-row">
    <?php echo $this->form->input('jour_end_date', array('label' => "Journey End Date *", 'class' => "md-input", 'type' => 'text', 'id' => 'uk_dp_ends', 'readonly' => true, 'required' => TRUE, 'onclick' => "return chstdate()")); ?>
                            </div>
                        </div>


                        <div class="uk-width-medium-1-2">                                                        
                            <div class="parsley-row">                                                            
                                <div class="uk-form-file md-btn md-btn-primary">
                                    Select
                                    <input id="doc_file" name="doc_file" type="file">
                                </div>
                                Upload Document <span class="req"></span><br><small>(gif, jpeg, png, jpg,pdf,csv) </small>
                            </div>
                        </div>                
                    </div>


                    <div class="uk-grid">
                        <div class="uk-width-1-3 uk-margin-top">                       
                                <?php if ($lta_block <= 0) { ?>
                                <p>LTA cannot be claimed,your LTA balance is Zero<p>
                                <?php } else { ?> 
                                    <input type="submit" class="md-btn md-btn-success" value="Apply" name='post_leave' onclick="return checkSubmit();">     
                    <?php } ?>                                           
                        </div>
                    </div>
                    <?php echo $this->Form->end(); ?>
                <?php } else { ?>
                    <h4> Your LTA is already submit.Please wait till it get approved.</h4>    
<?php } ?>  
            </div>
        </div>        
    </div>
</div>
<script type="text/javascript" >

    function chstdate() {
        if ($('#uk_dp_starts').val() == "") {
            $('#uk_dp_ends').val('');
            alert('Please Select Start Date First.');
            return false;
        } else {
            return true;
        }
    }

    function checkSubmit()
    {
        //var jour_start_date = $('#uk_dp_start').datepicker("getDate");
        //var jour_end_date = $('#uk_dp_end').datepicker("getDate")
        //var millisecondsPerDay = 1000 * 60 * 60 * 24;
        var ext = $('#doc_file').val().split('.').pop().toLowerCase();
        var doc = $('#doc_file').val();
        //var millisBetween = jour_end_date.getTime() - jour_start_date.getTime();
        //var days = millisBetween / millisecondsPerDay;

        /*if (days < 0) {
         $("#alerts").html('Please Enter Proper Dates').show();
         
         return false;
         
         }*/

        if ($('#bill').val() !== "") {
            var value = $('#bill').val().replace(/^\s\s*/, '').replace(/\s\s*$/, '');
            //var intRegex = /^\d+$/;
            var intRegex = /^\d+(\.\d{0,2})?$/;
            if (!intRegex.test(value)) {
                $("html, body").animate({scrollTop: 0}, "slow");
                $("#alerts").html("<div data-uk-alert='' class='uk-alert uk-alert-danger'><a class='uk-alert-close uk-close' href='#'></a>Bill Amount Field must be numeric and it allow up to two decimal digit.</div>").show();
                return false;
            }
        }
        if ($('#bill').val() == "") {
            $("html, body").animate({scrollTop: 0}, "slow");
            $("#alerts").html("<div data-uk-alert='' class='uk-alert uk-alert-danger'><a class='uk-alert-close uk-close' href='#'></a>Enter Bill Amount</div>").show();
            return false;
        } else if ($('#uk_dp_starts').val() == "")
        {
            $("html, body").animate({scrollTop: 0}, "slow");
            $("#alerts").html("<div data-uk-alert='' class='uk-alert uk-alert-danger'><a class='uk-alert-close uk-close' href='#'></a>Start Date Required</div>").show();
            return false;
        } else if ($('#uk_dp_ends').val() == "")
        {
            $("html, body").animate({scrollTop: 0}, "slow");
            $("#alerts").html("<div data-uk-alert='' class='uk-alert uk-alert-danger'><a class='uk-alert-close uk-close' href='#'></a>Ending Date Required</div>").show();
            return false;
        } else if ((Date.parse($('#uk_dp_ends').val()) < Date.parse($('#uk_dp_starts').val()))) {
            $("html, body").animate({scrollTop: 0}, "slow");
            $("#alerts").html("<div data-uk-alert='' class='uk-alert uk-alert-danger'><a class='uk-alert-close uk-close' href='#'></a>End date should be greater than Start date.</div>").show();
            return false;
        } else if (doc === '') {
            if ($('#bill').val() != 0) {
                $("html, body").animate({scrollTop: 0}, "slow");
                $("#alerts").html("<div data-uk-alert='' class='uk-alert uk-alert-danger'><a class='uk-alert-close uk-close' href='#'></a>upload Document</div>").show();
                return false;
            }
        } else if ($.inArray(ext, ['gif', 'png', 'jpg', 'jpeg', 'pdf', 'csv']) === -1) {
            $("#alerts").html("<div data-uk-alert='' class='uk-alert uk-alert-danger'><a class='uk-alert-close uk-close' href='#'></a>Invalid File Extention</div>").show();
            return false;
        }
    }
    $(document).ready(function () {
        jQuery("#uk_dp_starts").datepicker({
            inline: true,
            changeMonth: true,
            changeYear: true,
            autoclose: true,
            minDate: '<?php echo date("m/d/Y", strtotime($this->Common->getempJoinDate($auth['User']['emp_code']))); ?>',
            maxDate: 'today'

        });
        jQuery("#uk_dp_ends").datepicker({
            inline: true,
            changeMonth: true,
            changeYear: true,
            autoclose: true,
            minDate: '<?php echo date("m/d/Y", strtotime($this->Common->getempJoinDate($auth['User']['emp_code']))); ?>',
            maxDate: 'today'

        });
    });
</script>