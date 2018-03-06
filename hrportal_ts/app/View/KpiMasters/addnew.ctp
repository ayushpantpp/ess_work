<?php

$counts=$this->request->data['rowCount'];
?>
<tr class="even pointer" id="row_<?php echo $this->request->data['rowCount'];?>">
    <td>
        <?php
        if(empty($this->request->data['pt'])){
            echo $this->Form->input('kpi_name.'.$this->request->data['rowCount'], array('class'=>'form-control','type' => 'text','label' => false, 'maxlength'=>'100'));
        }else{
             echo $this->Form->input('kpi_name.'.$this->request->data['rowCount'], array('type' => 'select', 'label' => false, 'empty' => '- -Select- -', 'options' => $kpiNamelist, 'class' => 'form-control col-md-4 col-xs-12'));
        }
        ?>
    </td>
    <td>
                                        <?php echo $this->Form->input('kpi_kra_id.'.$this->request->data['rowCount'], array('type' => 'select', 'label' => false, 'empty' => '- -Select- -', 'options' => $kraLists, 'class' => 'form-control col-md-4 col-xs-12')); ?>
    </td>
    <td>
                                        <?php echo $this->Form->input('kpi_department_id.'.$this->request->data['rowCount'], array('type' => 'select', 'label' => false, 'empty' => '- -Select- -', 'options' => $departments, 'id'=>"kra_kpi_department_id_$counts", 'onChange'=>'getDepartmentEmployee(this)', 'class' => 'kra_kpi_department form-control col-md-4 col-xs-12')); ?>
    </td>
    <td id="empselect_<?php echo $counts;?>"></td>
    <td>
                                        <?php echo $this->Form->input('kpi_start_date.'.$this->request->data['rowCount'], array('id'=>"kpi_start_$counts",'label' => false, 'type' => 'text', 'class' => 'form-control required expenseTest', 'MAXLENGTH' => '20', 'autocomplete' => 'off')); ?>
    </td>
    <td>
                                        <?php echo $this->Form->input('kpi_end_date.'.$this->request->data['rowCount'], array('id'=>"kpi_end_$counts",'label' => false, 'type' => 'text', 'class' => 'form-control required expenseTest', 'MAXLENGTH' => '20', 'autocomplete' => 'off')); ?>
    </td>
    <td>
                                        <?php echo $this->form->input('kpi_weightage.'.$this->request->data['rowCount'], array('label'=>false,'class'=>"form-control",'type' => 'text', 'readonly'=>false)); ?>
    </td>
    <td>
                                        <?php echo $this->Form->input('kpi_target.'.$this->request->data['rowCount'], array('type' => 'select', 'label' => false, 'empty' => '- -Select- -', 'options' => $targets,'class' => 'form-control col-md-4 col-xs-12')); ?>
    </td>
</tr>