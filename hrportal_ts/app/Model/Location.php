<?php
App::uses('AppModel', 'Model');
class Location extends AppModel{
     public  $useDbConfig = 'default';
     public  $name = 'Location'; 
     public  $useTable = 'attendance_with_location';
     public  $primaryKey = 'id';
   
}