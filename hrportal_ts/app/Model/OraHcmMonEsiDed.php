<?php
App::uses('AppModel', 'Model');
class OraHcmMonEsiDed extends AppModel {

    var $useDbConfig = 'ora';
     //public  $name = 'MyProfile'; 
    public  $useTable = 'HCM$MON$ESI$DED';
}
