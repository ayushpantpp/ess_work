<?php
App::uses('AppModel', 'Model');
class Appmaster extends AppModel{
     public  $useDbConfig = 'default';
    public  $name = 'Appmaster'; 
    public  $useTable = 'application_constrains';
    public  $primaryKey = 'id';
   
}