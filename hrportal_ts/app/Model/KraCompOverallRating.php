<?php
App::uses('AppModel', 'Model');
class KraCompOverallRating extends AppModel{
    public  $useDbConfig = 'default';
    public  $name = 'KraCompOverallRating'; 
    public  $useTable = 'kra_comp_overall_rating';
    public  $primaryKey = 'id';
   
}