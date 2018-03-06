<?php
App::uses('AppModel', 'Model');
class CompetencyTarget extends AppModel{
    public  $useDbConfig = 'default';
    public  $name = 'CompetencyTarget'; 
    public  $useTable = 'competency_target';
    public  $primaryKey = 'id';
   
}