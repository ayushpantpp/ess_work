<?php
App::uses('AppModel', 'Model');
class TrainingDevelopment extends AppModel{
    public  $useDbConfig = 'default';
    public  $name = 'TrainingDevelopment'; 
    public  $useTable = 'training_development';
    public  $primaryKey = 'id';
   
}