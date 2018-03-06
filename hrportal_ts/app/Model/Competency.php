<?php
App::uses('AppModel', 'Model');
class Competency extends AppModel{
    public  $useDbConfig = 'default';
    public  $name = 'Competency'; 
    public  $useTable = 'competency';
    public  $primaryKey = 'id';
   
}