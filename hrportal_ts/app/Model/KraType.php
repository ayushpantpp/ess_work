<?php
App::uses('AppModel', 'Model');
class kraType extends AppModel{
    public  $useDbConfig = 'default';
    public  $name = 'kraType'; 
    public  $useTable = 'kra_type';
    public  $primaryKey = 'id';
   
}