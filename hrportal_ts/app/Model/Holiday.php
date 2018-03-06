<?php
App::uses('AppModel', 'Model');
class Holiday extends AppModel{
     public  $useDbConfig = 'default';
    public  $name = 'Holiday'; 
    public  $useTable = 'holiday';
    public  $primaryKey = 'id';
   
}