<?php
App::uses('AppModel', 'Model');
class Appraisalfactors extends AppModel {

    var $useDbConfig = 'default';
    var $name = 'Appraisalfactors';
    var $primaryKey = 'id';
    var $useTable = 'app_factors';
    var $belongsTo = array(
        'Department' => array(
            'className' => 'Department',
            'foreignKey' => 'department_id',
            'fields' => array('*')            
        
    ));
}