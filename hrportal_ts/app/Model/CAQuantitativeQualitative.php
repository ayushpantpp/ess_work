<?php
App::uses('AppModel', 'Model');
class CAQuantitativeQualitative extends AppModel {
    public  $useDbConfig = 'default';
    public  $name = 'CAQuantitativeQualitative'; 
    public  $useTable = 'ca_quantitative_qualitative';
    
    public  $belongsTo = array(
                            'CASetType' => array(
                                'className'  => 'CASetType',
                                'foreignKey' => 'thematic_area',
                                'bindingKey' => 'id',
                                'conditions'=>array('CASetType.status'=>'0')
                            ),
                            'Ministry' => array(
                                'className'  => 'Ministry',
                                'foreignKey' => 'ministry_id',
                                'bindingKey' => 'id',
                                'conditions'=>array('Ministry.ministry_status'=>'1')
                            )
                        );
}
?>
