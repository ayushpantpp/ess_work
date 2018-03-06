<?php

$checllvl = $this->Common->getAllEmployeeListDepartment($dept_code,$comp_code);
//$checllvl = $this->Common->findcheckLevel1($appid);
//$fwemplist = $this->Common->findLevel1($checllvl,'Apply');
 ?>

<div class="form-group col-md-6 col-sm-6 col-xs-12">
    <label for="middle-name" class="control-label col-md-4 col-sm-4 col-xs-12">Employee Name:<span class="required">*</span></label>
    <div class="col-md-8 col-sm-8 col-xs-12">
                     <?php echo $this->Form->input('employee_name', array('type' => 'select', 'label' => false, 'empty' => '- -Select- -', 'options' =>$checllvl, 'class' => 'form-control s-form-item s-form-all')); ?>
    </div>
</div>