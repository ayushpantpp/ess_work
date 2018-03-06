<?php
App::uses('AppModel', 'Model');
class GroupCompetency extends AppModel{
    public  $useDbConfig = 'default';
    public  $name = 'GroupCompetency'; 
    public  $useTable = 'group_competency';
    public  $primaryKey = 'id';
   
}