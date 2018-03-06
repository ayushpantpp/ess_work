<?php
App::uses('AppModel', 'Model');
class MomTopic extends AppModel{
     public  $useDbConfig = 'default';
    public  $name = 'MomTopic'; 
    public  $useTable = 'mom_topic';
    public  $primaryKey = 'tid';
   
}
?>