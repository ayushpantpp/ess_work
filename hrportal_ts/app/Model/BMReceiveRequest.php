<?php
App::uses('AppModel', 'Model');
class BMReceiveRequest extends AppModel {
    public  $useDbConfig = 'default';
    public  $name = 'BMReceiveRequest'; 
    public  $useTable = 'bm_receive_request';
    
    public  $hasOne = array(
                            'BMReceiveRequestForward' => array(
                                'className'  => 'BMReceiveRequestForward',
                                'foreignKey' => 'request_receive_id',
                                'bindingKey' => 'id'
                            )
                        );
    
}
?>
