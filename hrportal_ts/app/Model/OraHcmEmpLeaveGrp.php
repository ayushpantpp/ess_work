<?php
App::uses('AppModel', 'Model');
class OraHcmEmpLeaveGrp extends AppModel {

    var $useDbConfig = 'ora';
     //public  $name = 'MyProfile'; 
    public  $useTable = 'HCM$LEAVE$GRP';
  

}
