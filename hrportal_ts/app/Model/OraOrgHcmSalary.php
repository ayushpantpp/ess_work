<?php
App::uses('AppModel', 'Model');
class OraOrgHcmSalary extends AppModel {

    var $useDbConfig = 'ora';
     //public  $name = 'MyProfile'; 
    public  $useTable = 'ORG$HCM$SALARY';
}
