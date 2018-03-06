<?php
App::uses('AppModel', 'Model');
class Labels extends AppModel{
    public  $useDbConfig = 'default';
    public  $name = 'Labels'; 
    public  $useTable = 'labels';
    public  $primaryKey = 'id';
     var $belongsTo = array(
        'LabelBlock' => array(
            'className' => 'LabelBlock',
            'foreignKey' => 'label_block_id',
           
        ),
        'Options' => array(
            'className' => 'Options',
            'foreignKey' => 'options_id',
           
        ));
         
   
}