<?php
App::uses('AppModel', 'Model');
class KraRating extends AppModel{
    public  $useDbConfig = 'default';
    public  $name = 'KraRating'; 
    public  $useTable = 'kra_rating';
    public  $primaryKey = 'id';
   
}