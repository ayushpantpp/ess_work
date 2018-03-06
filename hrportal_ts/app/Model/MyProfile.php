<?php

App::uses('AppModel', 'Model');

class MyProfile extends AppModel {

    public $useDbConfig = 'default';
    public $name = 'MyProfile';
    public $useTable = 'myprofile';
    public $primaryKey = 'id';
    public $virtualFields = array(
        'emp_name' => 'CONCAT_WS(" ",MyProfile.emp_full_name)',
        'emp_name_wd_id' => 'CONCAT_WS(" ",MyProfile.emp_full_name,MyProfile.emp_id)'
    );
    public $belongsTo = array(
        'OptionAttribute' => array(
            'className' => 'OptionAttribute',
            'foreignKey' => 'location_code',
        )
    );

}
