<div id="page_content" role="main">
    <div id="page_content_inner">
        <h3 class="heading_b uk-margin-bottom">Final Step To Apply</h3>
        <?php echo $flash = $this->Session->flash(); ?>
        <div class="md-card">
            <div class="md-card-content large-padding">
                <?php
                echo $this->Form->create('fwtraining', array('inputDefaults' => array('label' => false, 'div' => false, 'error' => array('wrap' => 'span', 'class' => 'uk-form-stacked')), 'url' => array('controller' => 'training', 'action' => 'saveinfomation'), 'id' => 'fwtrainingid', 'name' => 'fwtrainingname'));

                $dept_code = $_SESSION['Auth']['MyProfile']['dept_code'];
                $comp_code = $_SESSION['Auth']['MyProfile']['comp_code'];
                $fwemplist = $this->Common->findTrainingLevel();
                ?>

                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-1-3">
                        <div class="parsley-row">
                            <input type="hidden" value ="<?php echo $training_id; ?>" name="data[TrainingWorkflow][training_id]"> 
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Forward *</label>
                            <?php echo $this->Form->input('TrainingWorkflow.emp_code', array('type' => 'select', 'label' => "", 'options' => $fwemplist, 'class' => 'md-input', 'id' => 'fwlvempcode', "data-md-selectize" => "data-md-selectize")); ?>
                        </div>
                    </div>
                </div>

                <div class="uk-grid">
                    <div class="uk-width-1-1 uk-margin-top">                    
                        <button type="submit" name="data[TrainingWorkflow][save]" class="md-btn md-btn-success" href="#" onClick = "return checkSubmit()">APPLY</button>
                        <a class="md-btn md-btn-wave waves-effect waves-button" href="<?php echo $this->webroot; ?>training/manageTrainingIdentificationForm">Cancel</a>

                    </div>
                </div>
                <?php $this->Form->end(); ?>
            </div>            
        </div>
    </div>
</div>
