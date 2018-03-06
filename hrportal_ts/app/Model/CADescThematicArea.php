<?php
App::uses('AppModel', 'Model');
class CADescThematicArea extends AppModel {
    public  $useDbConfig = 'default';
    public  $name = 'CADescThematicArea'; 
    public  $useTable = 'ca_desc_thematic_area';
    
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
