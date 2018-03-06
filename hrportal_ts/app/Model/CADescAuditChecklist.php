<?php
App::uses('AppModel', 'Model');
class CADescAuditChecklist extends AppModel {
    public  $useDbConfig = 'default';
    public  $name = 'CADescAuditChecklist'; 
    public  $useTable = 'ca_desc_audit_checklist';
    
    public  $belongsTo = array(
                            'CASetChecklistTypeAuditMonitoring' => array(
                                'className'  => 'CASetChecklistTypeAuditMonitoring',
                                'foreignKey' => 'checklist_type'
                                //'bindingKey' => 'checklist_type'
                            )
                        );
}
?>
