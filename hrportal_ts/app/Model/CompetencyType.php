<?php
App::uses('AppModel', 'Model');
class CompetencyType extends AppModel{
    public  $useDbConfig = 'default';
    public  $name = 'CompetencyType'; 
    public  $useTable = 'competency_type';
    public  $primaryKey = 'id';
   
}