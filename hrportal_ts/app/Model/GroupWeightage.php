<?php
App::uses('AppModel', 'Model');
class GroupWeightage extends AppModel{
    public  $useDbConfig = 'default';
    public  $name = 'GroupWeightage'; 
    public  $useTable = 'group_weightage';
    public  $primaryKey = 'id';
   
}