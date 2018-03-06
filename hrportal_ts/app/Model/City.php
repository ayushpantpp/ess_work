<?php
App::uses('AppModel', 'Model');
class City extends AppModel {

   // public  $name = "Roles";
    public  $useDbConfig = 'default';
    public  $name = 'City'; 
    public  $useTable = 'cities';
    public  $primaryKey = 'id';
    
 
}

