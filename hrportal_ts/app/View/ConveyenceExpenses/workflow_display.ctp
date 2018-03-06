<script type="text/javascript">
    history.pushState(null, null, location.href);
    window.onpopstate = function (event) {
        history.go(1);
    };
</script>

<div id="page_content" role="main">
    <div id="page_content_inner">
        <h3 class="heading_b uk-margin-bottom">Conveyance Work Flow</h3>
        <?php echo $flash = $this->Session->flash(); ?>
        <div class="md-card">
            <div class="md-card-content large-padding">
                <?php // /echo $this->Form->create('conveyence_expenses', array('url' => array('controller' => 'conveyence_expenses', 'action' => 'saveinfomation'), 'id' => 'trvoucher', 'name' => 'trvoucher', 'class' => 'uk-form-stacked')); ?>
                <?php
                echo $this->Form->create('conveyence_expenses', array('inputDefaults' => array(
                        'label' => false, 'div' => false, 'error' => array('wrap' => 'span', 'class' => 'uk-form-stacked')),
                    'url' => array('action' => 'saveinfomation'), 'id' => 'fwconveyenceid', 'name' => 'fwconveyencename'));
                ?>
                <?php 
                if(is_numeric($conveyence)){
                    $vocherID = $conveyence;
                }else{
                $vocherID = explode(",", $conveyence);
                }
               ?>
                <?php
                    $emp_code = $_SESSION['Auth']['MyProfile']['emp_code'];
					$dept_code = $_SESSION['Auth']['MyProfile']['dept_code'];
					$comp_code = $_SESSION['Auth']['MyProfile']['comp_code'];
					$fwemplist = $this->Common->findLevel($emp_code);

                    ?>
                <?php if (is_numeric($vocherID)) { ?>
                    

                    <div class="uk-grid" data-uk-grid-margin>
                        <div class="uk-width-medium-1-3">
                            <div class="parsley-row">
                                <input type="hidden" value ="<?php echo $conveyence; ?>" name="data[ConveyenceWorkflow][conveyencevoucher_id]">
                                <label for="first-name">Forward *</label>
                                <?php echo $this->Form->input('ConveyenceWorkflow.emp_code', array('type' => 'select', 'label' => "", 'options' => $fwemplist, 'class' => 'md-input', 'id' => 'fwlvempcode', "data-md-selectize" => "data-md-selectize")); ?>
                            </div>
                        </div>
                    </div>

                    


                <?php }elseif(is_array($vocherID)){ ?>
                   <div class="uk-grid" data-uk-grid-margin>
                        <div class="uk-width-medium-1-3">
                            <div class="parsley-row">
                                <input type="hidden" value ="array" name="data[ConveyenceWorkflow][fields]">
                                <?php 
                                $i = 1;
                                foreach($vocherID as $key => $val){ 
                                    ?>
                                <input type="hidden" value ="<?php echo $val; ?>" name="data[ConveyenceWorkflow][voucher_id][<?php echo $key;?>]">
                                <?php $i++ ; } ?>
                                <label for="first-name">Forward *</label>
                                <?php echo $this->Form->input('ConveyenceWorkflow.emp_code', array('type' => 'select', 'label' => "", 'options' => $fwemplist, 'class' => 'md-input', 'id' => 'fwlvempcode', "data-md-selectize" => "data-md-selectize")); ?>
                            </div>
                        </div>
                    </div> 
               <?php  } ?>
                <div class="uk-grid">
                        <div class="uk-width-1-1 uk-margin-top">
                            <button type="submit" name="data[fwlta][save]" class="md-btn md-btn-success" href="#">Save</button>
                            <a class="md-btn md-btn-primary" href="<?php echo $this->webroot; ?>conveyence_expenses/view" title="Click to Cancel.">Cancel</a>
                        </div>
                    </div>
                <?php $this->Form->end(); ?>

            </div>
        </div>
    </div>
</div>


<script type="text/javascript">
    function checkSubmit()
    {
        if ($("#fwlvempcode").val() == '')
        {
            alert("Select the employee name.");
            return false;
        } else {
            return true;
        }
    }
</script>