<div class="form-group col-md-6 col-sm-6 col-xs-6">
<label class="control-label col-md-4 col-sm-4 col-xs-8" for="first-name">Department Name<span class="required">*</span> </label>
<div class=" form-group col-md-4 col-sm-8 col-xs-8">
<?php echo $this->Form->input('department_name', array('type' => 'select', 'label' => false, 'empty' => '- -Select- -', 'options' => $dept, 'class' => 'form-control s-form-item s-form-all')); ?> </div>
</div>