<?php
App::uses('AppModel', 'Model');
class HelpDeskDtl extends AppModel {

   // public  $name = "Roles";
    public  $useDbConfig = 'default';
    public  $name = 'HelpDeskDtl'; 
    public  $useTable = 'help_desk_dtl';
    public  $primaryKey = 'id'; 
    
    /* public $belongsTo = array(
        'HelpDesk' => array(
            'className' => 'HelpDesk',
            'foreignKey' => 'mst_ticket_id'
        )
    ); */
}
?>
