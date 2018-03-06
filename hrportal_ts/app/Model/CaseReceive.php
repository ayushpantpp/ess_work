<?php
App::uses('AppModel', 'Model');
class CaseReceive extends AppModel {
    public  $useDbConfig = 'default';
    public  $name = 'CaseReceive'; 
    public  $useTable = 'legal_case_receive';
    public  $belongsTo = array(
                            'MyProfile' => array(
                                'className'  => 'MyProfile',
                                'foreignKey' => 'action_officer_id',
                                'bindingKey' => 'id'
                            ),
                            'Ministry' => array(
                                'className'  => 'Ministry',
                                'foreignKey' => 'ministry_id',
                                'bindingKey' => 'id'
                            ),
                            'CaseType' => array(
                                'className'  => 'CaseType',
                                'foreignKey' => 'case_type_id',
                                'bindingKey' => 'id'
                            )
//                            'MstRequest' => array(
//                                'className'  => 'MstRequest',
//                                'foreignKey' => 'request_id',
//                                'bindingKey' => 'id'
//                            )
        
                        );
            public $hasMany = array(
                                'CaseDetails' => array(
                                    'className' => 'CaseDetails',
                                    'foreignKey' => 'case_receive_id',
                                    'bindingKey' => 'id',
                                    'conditions' => array('CaseDetails.status' => '1')
                                ),
                                'CaseFiles' => array(
                                    'className' => 'CaseFiles',
                                    'foreignKey' => 'case_receive_id',
                                    'bindingKey' => 'id',
                                    'conditions' => array('CaseFiles.status' => '1')
                                )
                
            );
            
    
}
?>
