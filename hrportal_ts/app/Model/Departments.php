<?php
App::uses('AppModel', 'Model');
class Departments extends AppModel{
     public  $useDbConfig = 'default';
    public  $name = 'Departments'; 
    public  $useTable = 'departments';
    public  $primaryKey = 'id';
    
}