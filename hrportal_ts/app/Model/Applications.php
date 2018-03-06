<?php
App::uses('AppModel', 'Model');
class Applications extends AppModel{
     public  $useDbConfig = 'default';
    public  $name = 'Applications'; 
    public  $useTable = 'applications';
    public  $primaryKey = 'id';
    public  $hasMany = array(
        'Roles' => array(
            'className' => 'Roles',
            'foreignKey' => 'nu_application_id'
           // 'conditions'=>array('Roles.nu_application_id'=>'Applications.id')
        
        ),
        'Permissions' => array(
            'className' => 'Permissions',
            'foreignKey' => 'nu_application_id'
            //'conditions'=>array('Permissions.nu_application_id'=>'Applications.id')
        
        )
    );    
//    public  $validate = array(
//        'vc_application_name' => array(
//            'notempty' => array(
//                'rule' => array('notempty'),
//                'message' => 'Application name is required to create an application.',
//            ),
//            'length' => array(
//                'rule' => array('maxLength',100),
//                'message' => 'The maximum length of an Application Name is 100 characters.',
//            ),
//        )
//   );
}