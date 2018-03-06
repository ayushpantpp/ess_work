<?php
App::uses('AppModel', 'Model');
class OraHcmItProc extends AppModel {

    var $useDbConfig = 'ora';
     //public  $name = 'MyProfile'; 
    public  $useTable = 'HCM$IT$PROC';
}
