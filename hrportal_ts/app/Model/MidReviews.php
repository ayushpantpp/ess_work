<?php
App::uses('AppModel', 'Model');
class MidReviews extends AppModel{
    public  $useDbConfig = 'default';
    public  $name = 'MidReviews'; 
    public  $useTable = 'mid_reviews';
    public  $primaryKey = 'id';
   
}