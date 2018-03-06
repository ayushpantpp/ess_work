<?php
App::uses('AppModel', 'Model');
class AssignCompToEmpDetails extends AppModel{
    public  $useDbConfig = 'default';
    public  $name = 'AssignCompToEmpDetails'; 
    public  $useTable = 'assign_comp_to_emp_details';
    public  $primaryKey = 'id';
   
}