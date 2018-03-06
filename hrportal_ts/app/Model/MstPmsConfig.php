<?php
App::uses('AppModel', 'Model');
class MstPmsConfig extends AppModel{
    public  $useDbConfig = 'default';
    public  $name = 'MstPmsConfig'; 
    public  $useTable = 'mst_pms_config';
    public  $primaryKey = 'id';
   
}