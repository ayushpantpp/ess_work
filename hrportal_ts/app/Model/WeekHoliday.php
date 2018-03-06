<?php
App::uses('AppModel', 'Model');
class WeekHoliday extends AppModel{
     public  $useDbConfig = 'default';
    public  $name = 'WeekHoliday'; 
    public  $useTable = 'week_holiday';
    public  $primaryKey = 'id';
   
}