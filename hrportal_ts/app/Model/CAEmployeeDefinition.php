<?php
App::uses('AppModel', 'Model');
class CAEmployeeDefinition extends AppModel {
    public  $useDbConfig = 'default';
    public  $name = 'CAEmployeeDefinition'; 
    public  $useTable = 'ca_employee_definition';
    
    public  $hasMany = array(
                            'CADependentDetails' => array(
                                'className'  => 'CADependentDetails',
                                'foreignKey' => 'emp_difini_id',
                                'bindingKey' => 'id'
                            ),
                            'CAWealthdeclaration' => array(
                                'className'  => 'CAWealthdeclaration',
                                'foreignKey' => 'emp_difini_id',
                                'bindingKey' => 'id',
                                'conditions' =>array('CAWealthdeclaration.status' => '0')
                            )
                        );
}
?>
