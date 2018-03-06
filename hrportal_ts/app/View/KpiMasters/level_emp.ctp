<?php

$checllvl = $this->Common->findcheckLevel1($appid);
$fwemplist = $this->Common->findLevel1($checllvl,'Apply');
 ?>

                     <?php echo $this->Form->input('employee_name.'.$_REQUEST['rowCount'][0], array('type' => 'select', 'label' => false, 'empty' => '- -Select- -', 'options' =>$fwemplist, 'class' => 'form-control s-form-item s-form-all')); ?>