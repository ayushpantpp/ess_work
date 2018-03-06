<?php
App::uses('AppModel', 'Model');
class OraHcmEmpLeave extends AppModel {

    var $useDbConfig = 'ora';
     //public  $name = 'MyProfile'; 
    public  $useTable = 'HCM$EMP$LEAVE';
  

}
