<?php

 class MstTrainingRequests extends AppModel {
    var $useDbConfig = 'default';
    var $name = 'MstTrainingRequests';
    var $primaryKey = 'id';
    var $useTable = 'mst_training_requests';
    
    var $hasMany = array(
        'TrainingMasterDetail' => array(
            'className' => 'TrainingRegistration',
			'foreignKey'=>'request_id'
            )
        );	
    }
