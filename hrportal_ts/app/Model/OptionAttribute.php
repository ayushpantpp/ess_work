<?php
class OptionAttribute extends AppModel {
	//var $useDbConfig = 'hcm';
    var $name = 'OptionAttribute'; 
    public  $useTable ='option_attribute';
    var $belongsTo = array(
        'Options' => array(
            'className' => 'Options',
            'foreignKey' => 'options_id',
           
        ));
   
    
 
}