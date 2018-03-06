<?php $auth = $this->Session->read('Auth'); ?>

<div id="page_content" role="main">
    <div id="page_content_inner">
        <h3 class="heading_b uk-margin-bottom">Travel Voucher Work flow</h3>
        <div class="md-card">
            <div class="md-card-content large-padding">   
            <?php 
            echo $this->Form->create('fwtravel', array('url' => array('controller' => 'Travels', 'action' => 'saveinfomation'), 'id' => 'form_validation', 'enctype' => 'multipart/form-data', 'class' => 'uk-form-stacked'));
             if (is_numeric($travel)) { 
              $emp_code = $_SESSION['Auth']['MyProfile']['emp_code'];
              $dept_code = $_SESSION['Auth']['MyProfile']['dept_code'];
              $comp_code = $_SESSION['Auth']['MyProfile']['comp_code'];
              $fwemplist = $this->Common->findLevel($emp_code); ?>
                
                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-1-3">
                        <div class="parsley-row">
                            <input type="hidden" value ="<?php echo $travel; ?>" name="data[TravelWorkflow][travelvoucher_id]"> 
                            <label>Forward *</label>
                            <?php echo $this->Form->input('emp_code', array('type' => 'select', 'label' => "", 'options' => $fwemplist, 'class' => 'md-input', 'id' => 'fwlvempcode', "data-md-selectize" => "data-md-selectize")); ?>
						</div>
                    </div>
                    <div class="uk-grid">
                        <div class="uk-width-1-1 uk-margin-top">                    
                            <button type="submit" name="data[fwtravel][save]" class="md-btn md-btn-success" href="#">Save</button>
                            <a class="md-btn md-btn-primary" href="<?php echo $this->webroot; ?>travels/editvoucher/<?php echo base64_encode($travel); ?>/" title="Click to Cancel.">Cancel</a>   
                        </div>
                    </div>



                <?php } ?>
<?php $this->Form->end(); ?>

            </div>
        </div>
    </div>
</div>
</div>   
<script type="text/javascript">
    $(document).ready(function ()
    {
        $('#alerts').hide();
    });
    function checkSubmit()
    {
        if ($("#fwlvempcode").val() == '')
        {
            var msg = 'Select the employee name';
            $('#alerts').html(msg);
            $('#alerts').show();
            alert("Select the employee name.");
            return false;
        } else {
            return true;
        }
    }
</script>

