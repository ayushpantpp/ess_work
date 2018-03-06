<?php
App::uses('AppModel', 'Model');
class Rating extends AppModel{
    public  $useDbConfig = 'default';
    public  $name = 'Rating'; 
    public  $useTable = 'rating';
    public  $primaryKey = 'id';
   
}