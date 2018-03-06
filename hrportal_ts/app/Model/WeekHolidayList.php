<?php
App::uses('AppModel', 'Model');
class WeekHolidayList extends AppModel{
     public  $useDbConfig = 'default';
    public  $name = 'WeekHolidayList'; 
    public  $useTable = 'week_holiday_list';
    public  $primaryKey = 'id';
   
}