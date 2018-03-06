<div id="page_content" role="main">
    <div id="page_content_inner">
        
        <?php echo $flash = $this->Session->flash(); ?>
        <div id="alerts"></div>        
        <div class="md-card">
        <div class="md-card-toolbar">
                            <div class="md-card-toolbar-actions">
                                
                               
                            </div>
                            <h3 class="md-card-toolbar-heading-text">
                              Medical Claim Form
                            </h3>
                        </div>
            <div class="md-card-content large-padding">               
              <?php echo $this->Form->create('Medical', array('url' => array('controller' => 'medical', 'action' => 'Medicalclaim'), 'id' => 'form_validation', 'enctype' => 'multipart/form-data', 'class' => 'uk-form-stacked')); ?>
                <div class="uk-grid" data-uk-grid-margin>

                    <div class="uk-width-medium-1-1">
                        <div class="parsley-row">
                            <select class="md-input" name="loc_type" data-md-selectize = "data-md-selectize">
                                <option value="N">Non Metro</option>
                                <option value="M"> Metro</option>
                            </select>
                        </div>
                    </div>

                    <div class="uk-width-medium-1-2">
                        <label>Employee ID</label>
                        <div class="parsley-row">
                            <input type="text" value="<?php echo $emp_details['emp_id'];?>" class="md-input" disabled />
                        </div>
                    </div>

                    <div class="uk-width-medium-1-2">
                        <label>Employee Name </label>
                        <div class="parsley-row">
                        <?php
                        $v = $this->Common->option_attribute_name($gender);

                        if ($v[$gender] == 'MALE') {
                            ?>
                            <input type="text" value="<?php echo "Mr. ".$emp_name." ".$lastname; ?>" class="md-input" disabled /> 
                            <input name="title" type="hidden" value="<?php echo $emp_name; ?>" class="md-input" disabled>
                        <?php } else { ?>
                            <input type="text" value="<?php echo "Mrs. ".$emp_name." ".$lastname; ?>" class="md-input" disabled /> 
                            <input name="title" type="hidden" value="<?php echo $emp_name; ?>" class="md-input" disabled>
                        <?php } ?>

                        </div>

                    </div>


                    <div class="uk-width-medium-1-2">
                        <label>Claim Amount<span>*</span></label>
                        <div class="parsley-row">
                            <input name="bill_amt" type="text" id = 'medclaimamt' class="md-input">
                        </div>
                    </div>
                    <!-- <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Journey Start Date</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                       <?php echo $this->form->input('jour_start_date', array('label'=>false,'class'=>"form-control col-md-7 col-xs-12 ",'type' => 'text', 'id' => 'jour_start_date','readonly'=>true)); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Journey End Date</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                    <?php echo $this->form->input('jour_end_date', array('label'=>false,'class'=>"form-control col-md-7 col-xs-12 ",'type' => 'text', 'id' => 'jour_end_date','readonly'=>true)); ?>    
                        </div>
                    </div>  --> 

                    <div class="uk-width-medium-1-2">                                                        
                        <div class="parsley-row">                                                            
                            <div class="uk-form-file md-btn md-btn-primary">
                                Select
                                <input id="medicaldoc" name="doc_file[]" type="file" multiple="multiple">
                            </div>
                            Multiple Upload Document <span class="req">*</span><br><small>(gif, jpeg, png, jpg,pdf,csv) </small>
                        </div>
                    </div>

                    <div class="uk-grid">
                        <div class="uk-width-1-3 uk-margin-top">                       
                            <input type="submit" class="md-btn md-btn-success" value="Submit" name='post_leave' onclick="return checkSubmit();">     
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript" >
    jQuery(document).ready(function () {
        jQuery("#jour_start_date").datepicker({
            inline: true,
            changeMonth: true,
            autoclose: true,
            orientation: "right bottom",
            format: 'dd-mm-yyyy'

        });
        jQuery("#jour_end_date").datepicker({
            inline: true,
            changeMonth: true,
            autoclose: true,
            orientation: "right bottom",
            dormat: 'dd-mm-yyyy'

        });
        jQuery("#bill_date").datepicker({
            inline: true,
            changeMonth: true,
            autoclose: true,
            //changeYear: true,
            Format: 'dd-mm-yy'

        });
    });
    function checkSubmit()
    {

        var claimAmt = jQuery('#medclaimamt').val();
        var ext = $('#medicaldoc').val().split('.').pop().toLowerCase();
        var doc = $('#medicaldoc').val();
        if (claimAmt !== "") {
            if (claimAmt == 0) {
                $("html, body").animate({scrollTop: 0}, "slow");
                $("#alerts").html("<div data-uk-alert='' class='uk-alert uk-alert-danger'><a class='uk-alert-close uk-close' href='#'></a>Bill Amount can not be zero.</div>").show();
                return false;
            }

            if (claimAmt < 0) {
                $("html, body").animate({scrollTop: 0}, "slow");
                $("#alerts").html("<div data-uk-alert='' class='uk-alert uk-alert-danger'><a class='uk-alert-close uk-close' href='#'></a>Bill Amount can not be -ve number.</div>").show();
                return false;
            }

            var value = $('#medclaimamt').val().replace(/^\s\s*/, '').replace(/\s\s*$/, '');
            //var intRegex = /^\d+(\.\d{0,2})?$/;
            var intRegex = /^(?!0)\d+(\.\d{0,2})?$/;
            if (!intRegex.test(value)) {
                $("html, body").animate({scrollTop: 0}, "slow");
                $("#alerts").html("<div data-uk-alert='' class='uk-alert uk-alert-danger'><a class='uk-alert-close uk-close' href='#'></a>Bill Amount Field must be numeric and it allow up to two decimal digit.</div>").show();
                return false;
            }
        }
        if (claimAmt === "" || claimAmt.replace(/ /g, '') == "")
        {
            $("html, body").animate({scrollTop: 0}, "slow");
            $("#alerts").html("<div data-uk-alert='' class='uk-alert uk-alert-danger'><a class='uk-alert-close uk-close' href='#'></a>Enter claim Amount</div>").show();
            return false;
        } else if (isNaN(claimAmt)) {
            $("html, body").animate({scrollTop: 0}, "slow");
            $("#alerts").html("<div data-uk-alert='' class='uk-alert uk-alert-danger'><a class='uk-alert-close uk-close' href='#'></a>Enter Numeric claim Amount</div>").show();
            return false;
        } else if (doc === '') {
            $("html, body").animate({scrollTop: 0}, "slow");
            $("#alerts").html("<div data-uk-alert='' class='uk-alert uk-alert-danger'><a class='uk-alert-close uk-close' href='#'></a>Upload Document</div>").show();
            return false;
        } else if (doc != '') {
            for (var i = 0; i < $("#medicaldoc").get(0).files.length; ++i) {
                var file1 = $("#medicaldoc").get(0).files[i].name;
                if (file1) {
                    var ext = file1.split('.').pop().toLowerCase();
                    if ($.inArray(ext, ['gif', 'png', 'jpg', 'jpeg', 'pdf', 'csv']) === -1) {
                        $("#alerts").html("<div data-uk-alert='' class='uk-alert uk-alert-danger'><a class='uk-alert-close uk-close' href='#'></a>Invalid File Extention</div>").show();
                        return false;
                    }
                } else {
                    $("#alerts").html("<div data-uk-alert='' class='uk-alert uk-alert-danger'><a class='uk-alert-close uk-close' href='#'></a>Invalid File Extention</div>").show();
                    return false;
                }
            }
        }
    }

</script>