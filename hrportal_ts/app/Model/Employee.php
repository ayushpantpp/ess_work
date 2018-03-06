<?php
App::uses('AppModel', 'Model');
class Employee extends AppModel {

   // public  $name = "Roles";
    public  $useDbConfig = 'default';
    public  $name = 'Employee'; 
    public  $useTable = 'myprofile';
    public  $primaryKey = 'id';
    
 
}

