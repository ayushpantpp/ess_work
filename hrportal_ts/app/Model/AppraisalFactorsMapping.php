<?php
App::uses('AppModel', 'Model');
class AppraisalFactorsMapping extends AppModel {

    var $useDbConfig = 'default';
    var $name = 'AppraisalFactorsMapping';
    var $primaryKey = 'id';
    var $useTable = 'app_factors_map';
    var $belongsTo = array(
        'Appraisalfactors' => array(
            'className' => 'Appraisalfactors',
            'foreignKey' => 'app_factors_id',
            
        ),
        'MyProfile' => array(
            'className' => 'MyProfile',
            'foreignKey' => 'myprofile_id',
           
        ),
        
    );

}