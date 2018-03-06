<?php
App::uses('AppModel', 'Model');
class TaskAssing extends AppModel {

   // public  $name = "Roles";
    public  $useDbConfig = 'default';
    public  $name = 'TaskAssign'; 
    public  $useTable = 'task_assigns';
    public  $primaryKey = 'id';
}
?>
