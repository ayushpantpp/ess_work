<?php
App::uses('AppModel', 'Model');
class AppraisalProcess extends AppModel{
    public  $useDbConfig = 'default';
    public  $name = 'AppraisalProcess'; 
    public  $useTable = 'appraisal_process';
    public  $primaryKey = 'id';
   
}