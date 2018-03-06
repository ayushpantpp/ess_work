<?php

$empDesg = $this->Common->findDesignationByEmpCode($empId);
$desg_code = $this->common->findDesignationNameByCode($empDesg);
echo $this->form->input('desg_id', array('label' => "Designation", 'value' => $desg_code, 'class' => "md-input", 'type' => 'text', 'id' => 'date', 'required' => true,));
?>                                