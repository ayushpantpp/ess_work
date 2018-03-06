<?php

class CourseMasterDetail extends AppModel {

    var $name = 'CourseMasterDetail';
    var $useTable = 'DT_COURSE_DETAILS';
    var $primaryKey = 'id';
    var $belongsTo = array('CourseMaster');
    var $validate = array(
        'course_name' => array(
            'required' => array(
                'rule' => 'notEmpty',
                'required' => true,
                'message' => 'Please Fill Course Name'
            ),
            'unique' => array(
                'rule' => 'isUnique',
                'required' => true,
                'message' => 'Course name already exists'
            )
        )
    );

}
