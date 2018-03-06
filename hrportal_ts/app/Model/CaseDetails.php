<?php
App::uses('AppModel', 'Model');
class CaseDetails extends AppModel {
    public  $useDbConfig = 'default';
    public  $name = 'CaseDetails'; 
    public  $useTable = 'legal_case_details';
    public  $belongsTo = array(
                            'CaseReceive' => array(
                                'className'  => 'CaseReceive',
                                'foreignKey' => 'case_receive_id',
                                'bindingKey' => 'id'
                            )
                        );
    public $hasMany = array(
                                'CaseFiles' => array(
                                    'className' => 'CaseFiles',
                                    'foreignKey' => 'case_detail_id',
                                    'bindingKey' => 'id',
                                    'conditions' => array('CaseFiles.status' => '1')
                                )
            );
}
?>
