<div class="form-group col-md-8 col-sm-8 col-xs-8">
<label class="control-label col-md-6 col-sm-8 col-xs-12" for="last-name">Designation: <span class="required">*</span> </label>
<div class="form-group col-md-6 col-sm-8 col-xs-12">
 <?php echo $this->Form->input('designation_name', array('type' => 'select', 'label' => false, 'empty' => '- -Select- -', 'options' =>$desg, 'class' => 'form-control s-form-item s-form-all')); ?> </div>
</div>
</div>