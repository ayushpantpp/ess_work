<?php
App::uses('AppModel', 'Model');
class HcmGroupMaster extends AppModel{
    public  $useDbConfig = 'default';
    public  $name = 'HcmGroupMaster'; 
    public  $useTable = 'hcm_group_master';
    public  $primaryKey = 'id';
   
}