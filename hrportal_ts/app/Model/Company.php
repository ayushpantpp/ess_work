<?php
App::uses('AppModel', 'Model');
class Company extends AppModel{
     public  $useDbConfig = 'default';
     public  $name = 'Company'; 
     public  $useTable = 'mst_company';
     public  $primaryKey = 'id';
   
}