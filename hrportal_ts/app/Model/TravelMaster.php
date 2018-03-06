<?php
App::uses('AppModel', 'Model');
class TravelMaster extends AppModel{
    public  $useDbConfig = 'default';
    public  $name = 'TravelMaster'; 
    public  $useTable = 'travel_masters';
    public  $primaryKey = 'id';
}