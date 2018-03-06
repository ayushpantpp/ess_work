<?php
App::uses('AppModel', 'Model');
class KraReport extends AppModel{
    public  $useDbConfig = 'default';
    public  $name = 'KraReport'; 
    public  $useTable = 'kra_report';
    public  $primaryKey = 'id';
   
}