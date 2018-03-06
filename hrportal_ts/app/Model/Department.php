<?php
App::uses('AppModel', 'Model');
class Department extends AppModel{
     public  $useDbConfig = 'default';
    public  $name = 'Department'; 
    public  $useTable = 'departments';
    public  $primaryKey = 'id';
  
}