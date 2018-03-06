<?php
App::uses('AppModel', 'Model');
class EmpStatus extends AppModel {

   // public  $name = "Roles";
    public  $useDbConfig = 'default';
    public  $name = 'EmpStatus'; 
    public  $useTable = 'mst_emp_status';
    public  $primaryKey = 'id';
    
 
}

?>