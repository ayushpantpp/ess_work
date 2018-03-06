<?php
App::uses('AppModel', 'Model');
class BMReceiveRequestForward extends AppModel {
    public  $useDbConfig = 'default';
    public  $name = 'BMReceiveRequestForward'; 
    public  $useTable = 'bm_receive_request_forward';
    
//    public  $belongsTo = array(
//                            'BMReceiveRequest' => array(
//                                'className'  => 'BMReceiveRequest',
//                                'foreignKey' => 'request_receive_id',
//                                'bindingKey' => 'id'
//                            )
//                        );
    
    
}
?>
