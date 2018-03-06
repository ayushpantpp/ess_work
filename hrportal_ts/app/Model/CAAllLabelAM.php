<?php
App::uses('AppModel', 'Model');
class CAAllLabelAM extends AppModel {
    public  $useDbConfig = 'default';
    public  $name = 'CAAllLabelAM'; 
    public  $useTable = 'ca_all_label_audit_monitoring';
    
    public  $belongsTo = array(
                            'CASetTypeAuditMonitoring' => array(
                                'className'  => 'CASetTypeAuditMonitoring',
                                'foreignKey' => 'set_type_am_id',
                                //'bindingKey' => 'id',
                                //'conditions'=>array('CASetTypeAuditMonitoring.status'=>'1')
                            )
                        );
}
?>
