<?php
App::uses('AppModel', 'Model');
class KraTarget extends AppModel{
    public  $useDbConfig = 'default';
    public  $name = 'KraTarget'; 
    public  $useTable = 'kra_target';
    public  $primaryKey = 'id';
   
}