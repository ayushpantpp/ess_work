<?php
App::uses('AppModel', 'Model');
class CompetencyBehaviour extends AppModel{
    public  $useDbConfig = 'default';
    public  $name = 'CompetencyBehaviour'; 
    public  $useTable = 'compitency_behaviour';
    public  $primaryKey = 'id';
   
}