<?php
App::uses('AppModel', 'Model');
class CADescValuePrinciple extends AppModel {
    public  $useDbConfig = 'default';
    public  $name = 'CADescValuePrinciple'; 
    public  $useTable = 'ca_desc_value_principle';
    
    public  $belongsTo = array(
                            'CASetType' => array(
                                'className'  => 'CASetType',
                                'foreignKey' => 'set_type_id',
                                'bindingKey' => 'id',
                                'conditions'=>array('CASetType.status'=>'0')
                            )
                        );
}
?>
