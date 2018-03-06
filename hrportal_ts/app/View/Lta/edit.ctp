<div id="page_content" role="main">
    <div id="page_content_inner">        
        <h3 class="heading_b uk-margin-bottom">Edit LTA Claim Form</h3>
        <?php echo $flash = $this->Session->flash(); ?>
        <div class="md-card">
            <div class="md-card-content large-padding">
                
                <?php echo $this->Form->create('lat', array('url' => array('controller' => 'lta', 'action' => 'LtaClaimEdit'), 'id' => 'form_validation', 'enctype' => 'multipart/form-data', 'class' => 'uk-form-stacked')); ?>

                <div class="uk-grid" data-uk-grid-margin>

                    <div class="uk-width-medium-1-3">
                        <div class="parsley-row">
                            <?php echo $this->form->input('task_id', array('label' => "Employee ID", 'type' => "text", 'class' => "md-input", 'value' => $emp_details['emp_id'], 'disabled')); ?>
                        </div>
                    </div>

                    <div class="uk-width-medium-1-3">
                        <div class="parsley-row">
                            <?php
                            $v = $this->Common->option_attribute_name($gender);
                            $options = $this->Common->option_name($emp_nm_tl);
                            if ($v[$gender] == 'MALE') {

                                echo $this->form->input('', array('label' => "Employee Name", 'type' => "text", 'class' => "md-input", 'value' => $options[$emp_nm_tl] . " " . $emp_name, 'disabled'));
                                ?>            

                                <input name="title" type="hidden" value="<?php echo $emp_name; ?>" class="md-input">
                            <?php } else {
                                echo $this->form->input('', array('label' => "Employee Name", 'type' => "text", 'class' => "md-input", 'value' => $options[$emp_nm_tl] . " " . $emp_name, 'disabled'));
                                ?>
                                <input name="title" type="hidden" value="<?php echo $emp_name; ?>" class="md-input">
                                <?php } ?>
                        </div>
                    </div>

                    <div class="uk-width-medium-1-3">
                        <div class="parsley-row">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">LTA Entitlement</label>
                            
                            <select name='ltaclaimyear' class="md-input" data-md-selectize = "data-md-selectize">
                  <?php  for($i=1;$i<=$lta_block;$i++){ ?>
                    <option <?php if($lta_claim['LtaBillAmount']['lta_years']== $i){ echo selected;}?> value=<?php echo $i;?>><?php echo $i;?> Year</option>
                  <?php } ?>  
                    </select>
                            

                            
                        </div>
                    </div>

                    <div class="uk-width-medium-1-3">
                        <div class="parsley-row">
                            <?php echo $this->form->input('bill_amt', array('label' => "Bill Amount *", 'type' => "text", "value" => $lta_claim['LtaBillAmount']['bill_amount'],'class' => "md-input", 'id' => "bill",'required' => TRUE)); ?>
                            
                        </div>
                    </div>
                    
                    <div class="uk-width-medium-1-3">
                        <div class="parsley-row">
                            <?php echo $this->form->input('jour_start_date', array('label' => "Journey Start Date *", 'class' => "md-input", 'type' => 'text','value'=>date('d-m-Y',strtotime($lta_claim['LtaBillAmount']['jour_start_date'])), 'id' => 'uk_dp_start', 'readonly' => true,'required' => TRUE)); ?>
                        </div>
                    </div>
                    
                    <div class="uk-width-medium-1-3">
                        <div class="parsley-row">
                            <?php echo $this->form->input('jour_end_date', array('label' => "Journey End Date *", 'class' => "md-input", 'type' => 'text','value'=>date('d-m-Y',strtotime($lta_claim['LtaBillAmount']['jour_end_date'])), 'id' => 'uk_dp_end', 'readonly' => true,'required' => TRUE)); ?>
                        </div>
                    </div>


                    <div class="uk-width-medium-1-2"> 
                        
                        <div class="parsley-row"> 
                            <img width= 50 height= 50 src="<?php echo $this->webroot.'uploads/Lta/'.$lta_claim['LtaBillAmount']['uploaded_file'];?>">   
                            <div class="uk-form-file md-btn md-btn-primary">
                                Select
                                <input id="doc_file" name="doc_file" type="file">
                            </div>
                            Upload Document <span class="req"></span>
                        </div>
                    </div>                
                </div>


                <div class="uk-grid">
                    <div class="uk-width-1-3 uk-margin-top">                       
                       
                        <input type="submit" class="md-btn md-btn-success" value="Apply" name='post_leave' onclick="return checkSubmit(); ">
                        <input name="ltaid" type="hidden" value="<?php echo $ltaid;?>" class="form-control col-md-7 col-xs-12">
                     
                    </div>
                </div>
            <?php echo $this->Form->end(); ?>
                
                
              
            </div>
        </div>        
    </div>
</div>
<script type="text/javascript" >
    function checkSubmit()
    {
        var jour_start_date = $('#jour_start_date').datepicker("getDate");
        var jour_end_date = $('#jour_end_date').datepicker("getDate")
        var millisecondsPerDay = 1000 * 60 * 60 * 24;
        var millisBetween = jour_end_date.getTime() - jour_start_date.getTime();
        var days = millisBetween / millisecondsPerDay;

        if (days < 0) {
            $("#alerts").html('Please Enter Proper Dates').show();

            return false;

        }
        if ($('#bill').val() !== "") {
            var value = $('#bill').val().replace(/^\s\s*/, '').replace(/\s\s*$/, '');
            var intRegex = /^\d+$/;
            if (!intRegex.test(value)) {
                $("html, body").animate({scrollTop: 0}, "slow");
                $("#alerts").html("<div data-uk-alert='' class='uk-alert uk-alert-danger'><a class='uk-alert-close uk-close' href='#'></a>Bill Amount Field must be numeric").show();
                return false;

            }
        }
        if ($('#bill').val() == "") {
            $("html, body").animate({scrollTop: 0}, "slow");
            $("#alerts").html("<div data-uk-alert='' class='uk-alert uk-alert-danger'><a class='uk-alert-close uk-close' href='#'></a>Enter Bill Amount").show();
            return false;
        }

        else if ($('#jour_start_date').val() == "")
        {
            $("html, body").animate({scrollTop: 0}, "slow");
            $("#alerts").html("<div data-uk-alert='' class='uk-alert uk-alert-danger'><a class='uk-alert-close uk-close' href='#'></a>Start Date Required").show();
            return false;

        }

        else if ($('#jour_end_date').val() == "")
        {
            $("html, body").animate({scrollTop: 0}, "slow");
            $("#alerts").html("<div data-uk-alert='' class='uk-alert uk-alert-danger'><a class='uk-alert-close uk-close' href='#'></a>Ending Date Required").show();
            return false;
        }
        else if ($('#docInput').val() === "" && $('#bill').val() != 0)
        {
            $("html, body").animate({scrollTop: 0}, "slow");
            $("#alerts").html("<div data-uk-alert='' class='uk-alert uk-alert-danger'><a class='uk-alert-close uk-close' href='#'></a>Upload Document").show();
            return false;
        }


    }
</script>   

