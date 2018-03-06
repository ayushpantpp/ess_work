<?php
App::uses('AppModel', 'Model');
class MailOffice extends AppModel {
    public  $useDbConfig = 'default';
    public  $name = 'MailOffice'; 
    public  $useTable = 'mail_office';
//    public  $belongsTo = array(
//                            'MyProfile' => array(
//                                'className' => 'MyProfile',
//                                'foreignKey' => 'user_id'
//                            )
//                        );
//    
    public  $hasMany  = array(
                         'MailOfficeAttachFiles' => array(
                             'className' => 'MailOfficeAttachFiles',
                             'foreignKey' => 'mail_office_id',
                             'conditions'=>array('status'=>'0')
                         )
                     );
    
    
}
?>
