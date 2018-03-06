<?php
App::uses('AppModel', 'Model');
class OraHcmMonPfDed extends AppModel {

    var $useDbConfig = 'ora';
     //public  $name = 'MyProfile'; 
    public  $useTable = 'HCM$MON$PF$DED';
}
