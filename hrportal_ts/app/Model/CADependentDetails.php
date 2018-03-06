<?php
App::uses('AppModel', 'Model');
class CADependentDetails extends AppModel {
    public  $useDbConfig = 'default';
    public  $name = 'CADependentDetails'; 
    public  $useTable = 'ca_dependent_details';
    
    public  $belongsTo = array(
                            'CAEmployeeDefinition' => array(
                                'className'  => 'CAEmployeeDefinition',
                                'foreignKey' => 'emp_difini_id'
                                //'bindingKey' => 'emp_difini_id'
                            )
                        );
}
?>
