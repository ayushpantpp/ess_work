<?php
App::uses('AppModel', 'Model');
class Appraisalslabs extends AppModel {

    var $useDbConfig = 'default';
    var $name = 'Appraisalslabs';
    var $primaryKey = 'id';
    var $useTable = 'app_slabs';
    var $belongsTo = array(
        
        'Department' => array(
            'className' => 'Departments',
            'foreignKey' => 'department_id',
           
        ),
         'Designation' => array(
            'className' => 'Designation',
            'foreignKey' => 'designation_id',
           
        )
        
    );

}