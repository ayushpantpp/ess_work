<?php
App::uses('AppModel', 'Model');
class HelpDesk extends AppModel {

   // public  $name = "Roles";
    public  $useDbConfig = 'default';
    public  $name = 'HelpDesk'; 
    public  $useTable = 'mst_help_desk';
    public  $primaryKey = 'id';
    
   public $hasMany = array(
        'HelpDeskDtl' => array(
            'className' => 'HelpDeskDtl',
            'foreignKey' => 'mst_ticket_id',
        )
    );
    
}
    
?>
