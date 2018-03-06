<?php
App::uses('AppModel', 'Model');
class DocumentRequest extends AppModel {
    public  $useDbConfig = 'default';
    public  $name = 'DocumentRequest'; 
    public  $useTable = 'documents_request';
    public  $belongsTo = array(
                            'MyProfile' => array(
                                'className' => 'MyProfile',
                                'foreignKey' => 'user_id'
                            )
                        );
    
    public  $hasMany  = array(
                         'DocumentReceiveRequestForward' => array(
                             'className' => 'DocumentReceiveRequestForward',
                             'foreignKey' => 'request_receive_id'
                         )
                     );
    
    
}
?>
