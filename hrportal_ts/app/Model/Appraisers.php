<?php
App::uses('AppModel', 'Model');
class Appraisers extends AppModel {

    var $useDbConfig = 'default';
    var $name        = 'Appraisers';
    var $primaryKey = 'id';
    var $useTable = 'app_appraisers';
    var $recursive = 2;
    var $hasMany = array(
                'Appraisalratings' => array(
                                'className' => 'Appraisalratings',
                                'foreignKey' => 'appraiser_id',
                                //'conditions' => array('Comment.status' => '1'),
                                'order' => 'Appraisalratings.id ASC',
                                //'limit' => '5',
                                //'dependent'=> true
                ),
    );
    var $hasOne = array(
                'Appraisalcomments' => array(
                                'className' => 'Appraisalcomments',
                                'foreignKey' => 'appraiser_id',
                                //'conditions' => array('Comment.status' => '1'),
                                //'order' => 'Comment.created DESC',
                                //'limit' => '5',
                                //'dependent'=> true
                ),        
    );
    var $belongsTo = array(
                'MyProfile' => array(
                                'className' => 'MyProfile',
                                'foreignKey' => 'myprofile_id',
                                'fields' => 'emp_name',
                                
                                ),
                'Appraisals' => array(
                                'className' => 'Appraisals',
                                'foreignKey' => 'request_id',
                                
                ),
    );
    
}