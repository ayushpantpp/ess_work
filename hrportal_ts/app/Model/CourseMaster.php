<?php

class CourseMaster extends AppModel {
	
var $name = 'CourseMaster';
	
   	 
	var $useTable = 'mst_course_masters';
	
	var $primaryKey = 'id';
	
	var $hasMany = array(
        'CourseMasterDetail' => array(
            'className' => 'CourseMasterDetail',
			'foreignKey'=>'mst_course_masters_id'
            )
        );
	
	var $validate = array(
		
		'course_name' => array(
				'required' => array(
					'rule' => 'notEmpty',
					'required' =>true,
					'message' => 'Please Fill Course Name'
		),
		'unique' =>array(
				'rule' => 'isUnique',
				'required' =>true,
				'message' => 'Course name already exists'
				
				)
		)
		
	);
	
		
}