<?php
App::uses('AppModel', 'Model');
class BMMeetingRequestRefnum extends AppModel {
    public  $useDbConfig = 'default';
    public  $name = 'BMMeetingRequestRefnum'; 
    public  $useTable = 'bm_meeting_request_refnum';
    
 public $belongsTo = array(
        'BMReceiveRequest' => array(
            'className' => 'BMReceiveRequest',
            'foreignKey' => 'request_receive_id',
            'bindingKey' => 'id',
            //'conditions' => array('BMReceiveRequest.status' => '1')
        ),
        'BMRequestDetails' => array(
            'className' => 'BMRequestDetails',
            'foreignKey' => 'request_receive_id',
            'bindingKey' => 'request_id',
            //'conditions' => array('BMReceiveRequest.status' => '1')
        ),
        'BMMeetingRequest' => array(
            'className' => 'BMMeetingRequest',
            'foreignKey' => 'meeting_request_id',
            'bindingKey' => 'id',
            //'conditions' => array('BMMeetingRequest.status' => '0')
        ),
     'BMReceiveRequestForward' => array(
            'className' => 'BMReceiveRequestForward',
            'foreignKey' => 'request_receive_id',
            'bindingKey' => 'request_receive_id',
            //'conditions' => array('BMReceiveRequestForward.frwd_status' => '0')
        )
    );
 
 
    
}
?>
