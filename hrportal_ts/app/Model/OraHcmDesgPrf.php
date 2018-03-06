<?php
App::uses('AppModel', 'Model');
class OraHcmDesgPrf extends AppModel {

    var $useDbConfig = 'ora';
     //public  $name = 'MyProfile'; 
    public  $useTable = 'HCM$DESG$PRF';
}
