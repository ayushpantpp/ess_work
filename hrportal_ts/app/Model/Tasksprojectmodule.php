<?php
App::uses('AppModel', 'Model');
class Tasksprojectmodule extends AppModel{
     public  $useDbConfig = 'default';
    public  $name = 'Tasksprojectmodule'; 
    public  $useTable = 'task_project_module';
    public  $primaryKey = 'mid';
   
}
?>

