<?php
App::uses('AppModel', 'Model');
class kpiType extends AppModel{
    public  $useDbConfig = 'default';
    public  $name = 'kpiType'; 
    public  $useTable = 'kpi_type';
    public  $primaryKey = 'id';
   
}