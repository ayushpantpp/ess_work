<?php
App::uses('AppModel', 'Model');
class LabelBlock extends AppModel{
     public  $useDbConfig = 'default';
    public  $name = 'LabelBlock'; 
    public  $useTable = 'label_block';
    public  $primaryKey = 'id'; 
    var $belongsTo = array(
        'LabelPage' => array(
            'className' => 'LabelPage',
            'foreignKey' => 'label_page_id',
           
        ));
    
}