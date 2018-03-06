<script>
    function checkSubmit()
    {
        var rem = jQuery('#remark').val();
        if (rem == '') {
            alert('Please Enter Remark');
            return false;
        }
    }
</script>   

<?php
echo $this->Form->create('Attendence', array('inputDefaults' => array(
                'label' => false,
                'div' => false,
                'error' => array(
                        'wrap' => 'span',
                        'class' => 'my-error-class'
                )
        ), 'url' => array('controller' => 'users', 'action' => 'reject_attendance'), 'id' => 'att', 'name' => 'Attendence','enctype'=>'multipart/form-data'));
?>
<div class="form-group col-md-6 col-sm-8 col-xs-6">
    <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Reject Reason:<span class="required">*</span> </label>
    <div class="col-md-8 col-sm-8 col-xs-12">

                     <?php echo $this->Form->input('Attendence.remark', array('label' => false, 'type' => 'textarea','class' => 'md-input','id'=>'remark')); ?>
                        <?php echo $this->Form->input('Attendence.rejectid', array('label' => false, 'type' => 'hidden','class' => 'md-input','value'=>$rejectid)); ?>
    </div>
</div>
<div class="uk-width-1-3 uk-margin-top">
    <div class="parsley-row">
    </div>
</div>
<div class=" col-md-2 col-sm-8" id="Park-Button">
    <input type="submit" value="Reject" class="md-btn md-btn-primary" onclick ="return checkSubmit();">
</div>

<?php $this->form->end(); ?>
