<?php
App::uses('AppModel', 'Model');
class CAThematicAreaMaster extends AppModel {
    public  $useDbConfig = 'default';
    public  $name = 'CAThematicAreaMaster'; 
    public  $useTable = 'ca_thematic_area_master';
    
//    public  $belongsTo = array(
//                            'CASetType' => array(
//                                'className'  => 'CASetType',
//                                'foreignKey' => 'set_type_id',
//                                'bindingKey' => 'id',
//                                'conditions'=>array('CASetType.status'=>'0')
//                            )
//                        );
}
?>
