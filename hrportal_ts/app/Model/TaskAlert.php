<?php
App::uses('AppModel', 'Model');
class TaskAlert extends AppModel {

   // public  $name = "Roles";
    public  $useDbConfig = 'default';
    public  $name = 'TaskAlert'; 
    public  $useTable = 'task_alert';
    public  $primaryKey = 'id';
}
?>
