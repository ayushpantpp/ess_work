<?php
App::uses('AppModel', 'Model');
class LabelPage extends AppModel{
    public  $useDbConfig = 'default';
    public  $name = 'LabelPage'; 
    public  $useTable = 'label_page';
    public  $primaryKey = 'id';
     var $belongsTo = array(
        'Applications' => array(
            'className' => 'Applications',
            'foreignKey' => 'applications_id',
           
        ));
   
}