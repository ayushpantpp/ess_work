<?php
App::uses('AppModel', 'Model');
class DocumentReceiveRequestForward extends AppModel {
    public  $useDbConfig = 'default';
    public  $name = 'DocumentReceiveRequestForward'; 
    public  $useTable = 'document_receive_request_forward';
    
 
//    public  $belongsToMany = array(
//                            'DocumentRequest' => array(
//                                'className' => 'DocumentRequest',
//                                'foreignKey' => 'DocumentRequest.id',
//                                'bindKey' => 'DocumentReceiveRequestForward.request_receive_id'
//                            )
//                        );
    
    
}
?>
