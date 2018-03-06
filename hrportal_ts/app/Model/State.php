<?php
App::uses('AppModel', 'Model');
class State extends AppModel {

   // public  $name = "Roles";
    public  $useDbConfig = 'default';
    public  $name = 'State'; 
    public  $useTable = 'states';
    public  $primaryKey = 'id';
    
 
}

