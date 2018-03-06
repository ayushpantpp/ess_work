<?php
App::uses('AppModel', 'Model');
class BMReportTypeAttachment extends AppModel {
    public  $useDbConfig = 'default';
    public  $name = 'BMReportTypeAttachment'; 
    public  $useTable = 'bm_report_type_attachment';
    
    public  $hasMany = array(
                            'BMReportTypeAttachFiles' => array(
                                'className'  => 'BMReportTypeAttachFiles',
                                'foreignKey' => 'report_type_attach_id',
                                'bindingKey' => 'id',
                                'conditions'=>array('BMReportTypeAttachFiles.status'=>'0')
                            )
                        );
    
}
?>
