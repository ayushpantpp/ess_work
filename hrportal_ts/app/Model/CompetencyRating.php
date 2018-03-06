<?php
App::uses('AppModel', 'Model');
class CompetencyRating extends AppModel{
    public  $useDbConfig = 'default';
    public  $name = 'CompetencyRating'; 
    public  $useTable = 'competency_rating';
    public  $primaryKey = 'id';
   
}