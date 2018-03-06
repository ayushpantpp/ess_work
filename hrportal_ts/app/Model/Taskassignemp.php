<?php
App::uses('AppModel', 'Model');
class Taskassignemp extends AppModel{
     public  $useDbConfig = 'default';
    public  $name = 'Taskassignemp'; 
    public  $useTable = 'task_assign_emp';
    public  $primaryKey = 'id';
   
}
?>