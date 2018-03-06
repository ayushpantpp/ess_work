<?php
App::uses('AppModel', 'Model');
class CityGroup extends AppModel{
    public  $useDbConfig = 'default';
    public  $name = 'CityGroup'; 
    public  $useTable = 'city_group';
    public  $primaryKey = 'id';
}
