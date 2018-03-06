<?php
App::uses('AppModel', 'Model');
class HRMaster extends AppModel {

   // public  $name = "Roles";
    public  $useDbConfig = 'default';
    public  $name = 'HRMaster'; 
    public  $useTable = 'hr_master';
    public  $primaryKey = 'id';
    
 
}

