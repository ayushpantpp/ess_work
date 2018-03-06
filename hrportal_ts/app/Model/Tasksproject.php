<?php
App::uses('AppModel', 'Model');
class Tasksproject extends AppModel{
     public  $useDbConfig = 'default';
    public  $name = 'Tasksproject'; 
    public  $useTable = 'task_project';
    public  $primaryKey = 'pid';
   
}
?>