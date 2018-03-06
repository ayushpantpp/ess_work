<?php
App::uses('AppModel', 'Model');
class AppraisalDevelopmentPlan extends AppModel{
    public  $useDbConfig = 'default';
    public  $name = 'AppraisalDevelopmentPlan'; 
    public  $useTable = 'appraisal_development_plan';
    public  $primaryKey = 'id';
   
}