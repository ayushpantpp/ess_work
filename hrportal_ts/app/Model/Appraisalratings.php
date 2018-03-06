<?php
App::uses('AppModel', 'Model');
class Appraisalratings extends AppModel {

    var $useDbConfig = 'default';
    var $name = 'Appraisalratings';
    var $primaryKey = 'id';
    var $useTable = 'app_ratings';
    var $belongsTo = array(    
                'Appraisalfactors' => array(
                                'className' => 'Appraisalfactors',
                                'foreignKey' => 'factor_id',
                                'fields' => 'factor_name'
                                //'conditions' => array('Comment.status' => '1'),
                                //'order' => 'Comment.created DESC',
                                //'limit' => '5',
                                //'dependent'=> true
                ), 
    );        
}