<?php
App::uses('AppModel', 'Model');
class Ministry extends AppModel{
    public  $useDbConfig = 'default';
    public  $name = 'Ministry'; 
    public  $useTable = 'ministry';
    public  $primaryKey = 'id';
   
}