<?php
class Options extends AppModel {
	//var $useDbConfig = 'hcm';
    var $name = 'Options'; 
    public  $useTable ='options'; 
    public $belongsTo  = array(
        'AttributeType' => array(
            'className' => 'AttributeType',
            'foreignKey' => 'attribute_type_id',
            )
    );
 
}