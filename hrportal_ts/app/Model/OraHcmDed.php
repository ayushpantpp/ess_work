<?php
App::uses('AppModel', 'Model');
class OraHcmDed extends AppModel {

    var $useDbConfig = 'ora';
     //public  $name = 'MyProfile'; 
    public  $useTable = 'HCM$DED';
}
