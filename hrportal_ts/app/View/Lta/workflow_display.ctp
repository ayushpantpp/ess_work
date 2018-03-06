<?php

$auth = $this->Session->read('Auth'); ?>

<div id="page_content" role="main">
    <div id="page_content_inner">
        <h3 class="heading_b uk-margin-bottom">LTA Claim Work Flow</h3>
        <?php echo $flash = $this->Session->flash(); ?>
        <div id="alerts"></div>
        <div class="md-card">
            <div class="md-card-content large-padding">
                <?php
                echo $this->Form->create('fwlta', array('url' => array('controller' => 'lta', 'action' => 'saveinfomation'), 'id' => 'form_validation', 'enctype' => 'multipart/form-data', 'class' => 'uk-form-stacked'));
                if (is_numeric($id)) {
                    $dept_code = $_SESSION['Auth']['MyProfile']['dept_code'];
                    $comp_code = $_SESSION['Auth']['MyProfile']['comp_code'];
                 
                    $checllvl = $this->Common->findcheckLevelHr($appId);
                    
                    if($checllvl['WfMstAppMapLvl']['hr_approval'] == 1){
                      $fwemplist = $this->Common->getHrList($auth['MyProfile']['emp_code']);
                   }elseif($checllvl['WfMstAppMapLvl']['manager_approval'] == 1){
                     $fwemplist = $this->Common->findDynamicLevel($checllvl['WfMstAppMapLvl']['wf_id'], 'Forward');    
                   }else{
                      $fwemplist = $this->Common->findLevel();
                   }
                  
                    ?>
                <div class="uk-grid" data-uk-grid-margin>

                    <div class="uk-width-medium-1-3">
                        <div class="parsley-row">
                            <input type="hidden" value ="<?php echo $id; ?>" name="lta_id">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Forward *</label>
                                <?php echo $this->Form->input('emp_code', array('type' => 'select', 'label' => "", 'options' => $fwemplist, 'class' => 'md-input', 'id' => 'fwlvempcode', "data-md-selectize" => "data-md-selectize")); ?>

                        </div>
                    </div>
                </div>

                <div class="uk-grid">
                    <div class="uk-width-1-1 uk-margin-top">                    
                        <button type="submit" name="data[fwlta][save]" class="md-btn md-btn-success" href="#" onclick="return checkSubmit();">Forward</button>
                        <a class="md-btn md-btn-primary" href="<?php echo $this->webroot; ?>lta/view/" title="Click to Cancel.">Cancel</a>

                    </div>
                </div>

                <?php } ?>
                <?php $this->Form->end(); ?>
            </div>
        </div>       
    </div>
</div>

<script>
    function checkSubmit() {
        if ($.trim($("#fwlvempcode").val()) == "")
        {
            $("html, body").animate({scrollTop: 0}, "slow");
            $("#alerts").html("<div data-uk-alert='' class='uk-alert uk-alert-danger'><a class='uk-alert-close uk-close' href='#'></a>Please Select Manager. !!!</div>").show();
            return false;
        }
    }
</script>