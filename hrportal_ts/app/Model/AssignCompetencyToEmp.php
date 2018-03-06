<?php
App::uses('AppModel', 'Model');
class AssignCompetencyToEmp extends AppModel{
    public  $useDbConfig = 'default';
    public  $name = 'AssignCompetencyToEmp'; 
    public  $useTable = 'assign_competency_to_emp';
    public  $primaryKey = 'id';
   
}