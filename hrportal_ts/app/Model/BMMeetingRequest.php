<?php
App::uses('AppModel', 'Model');
class BMMeetingRequest extends AppModel {
    public  $useDbConfig = 'default';
    public  $name = 'BMMeetingRequest'; 
    public  $useTable = 'bm_meeting_request';
    
    public $hasOne = array(
        'BMMeetingRequestRefnum' => array(
            'className' => 'BMMeetingRequestRefnum',
            'foreignKey' => 'meeting_request_id',
            'bindingKey' => 'id',
            //'conditions' => array('BMMeetingRequest.status' => '0')
        )
    );
}
?>
