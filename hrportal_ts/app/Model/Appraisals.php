<?php

App::uses('AppModel', 'Model');
class Appraisals extends AppModel {

    var $useDbConfig = 'default';
    var $name = 'Appraisals';
    var $primaryKey = 'id';
    var $useTable = 'appraisal_req';
    var $recursive = 3;
    var $companyCode = '00';
    var $hasMany = array(
        'Appraisers' => array(
            'className' => 'Appraisers',
            'foreignKey' => 'request_id',
           
        ),
        'Kras' => array(
            'className' => 'Kras',
            'foreignKey' => 'request_id',
            'type' => 'right'
        ),
    );
    var $belongsTo = array(
        'MyProfile' => array(
            'className' => 'MyProfile',
            'foreignKey' => 'myprofile_id',
            'fields' => array('emp_firstname','desg_code'),
	    
        ),
        'Departments' => array(
            'className' => 'Departments',
            'foreignKey' => 'departments_id',
            'fields' => 'dept_name',
            'conditions' => array('Departments.comp_code' => '01'),
            ),
        
        'Category' => array(
            'className' => 'Appraisalslabcategories',
            'foreignKey' => 'slab_category_id',
            'fields' => 'description',
            'conditions' => array('Category.comp_code' => '01'),
        //'order' => 'Comment.created DESC',
        //'limit' => '5',
        //'dependent'=> true
        ),        
        
    );
    

}