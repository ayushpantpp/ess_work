<?php
App::uses('AppModel', 'Model');
class WeightageCalculationType extends AppModel{
    public  $useDbConfig = 'default';
    public  $name = 'WeightageCalculationType'; 
    public  $useTable = 'weightage_calculation_type';
    public  $primaryKey = 'id';   
}