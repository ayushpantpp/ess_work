<?php
App::uses('AppModel', 'Model');
class MDMaster extends AppModel {

   // public  $name = "Roles";
    public  $useDbConfig = 'default';
    public  $name = 'MDMaster'; 
    public  $useTable = 'md_master';
    public  $primaryKey = 'id';
    
 
}

