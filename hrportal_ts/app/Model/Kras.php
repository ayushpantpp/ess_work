<?php
App::uses('AppModel', 'Model');
class Kras extends AppModel {

    var $useDbConfig = 'default';
    var $name = 'app_kras';
    var $primaryKey = 'id';
   var $belongsTo = array(
           'Appraisals' => array(
                   'className'  => 'Appraisals',
                   'foreignKey' => 'request_id',
                   'fields' => array('dt_fromdate','dt_todate')
           ),
   );
}