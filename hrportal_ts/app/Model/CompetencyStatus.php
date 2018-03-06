<?php
App::uses('AppModel', 'Model');
class CompetencyStatus extends AppModel{
    public  $useDbConfig = 'default';
    public  $name = 'CompetencyStatus'; 
    public  $useTable = 'competency_status';
    public  $primaryKey = 'id';
   
}