<?php
App::uses('AppModel', 'Model');
class Country extends AppModel {

   // public  $name = "Roles";
    public  $useDbConfig = 'default';
    public  $name = 'Country'; 
    public  $useTable = 'countries';
    public  $primaryKey = 'id';
    
 
}

