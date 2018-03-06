<?php
App::uses('AppModel', 'Model');
class Designations extends AppModel{
     public  $useDbConfig = 'default';
    public  $name = 'Designations';
    public  $useTable = 'mst_desg';
    public  $primaryKey = 'id';
   
}