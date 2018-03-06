<?php
App::uses('AppModel', 'Model');
class HrRoleAssign extends AppModel{
     public  $useDbConfig = 'default';
    public  $name = 'HrRoleAssign'; 
    public  $useTable = 'hr_role_assign';
    public  $primaryKey = 'id';
   
}