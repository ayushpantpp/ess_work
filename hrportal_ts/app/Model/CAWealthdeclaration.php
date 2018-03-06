<?php
App::uses('AppModel', 'Model');
class CAWealthdeclaration extends AppModel {
    public  $useDbConfig = 'default';
    public  $name = 'CAWealthdeclaration'; 
    public  $useTable = 'ca_wealthdeclaration';
    
    public  $hasMany = array(
                            'CAWealthAssets' => array(
                                'className'  => 'CAWealthAssets',
                                'foreignKey' => 'wealthdeclaration_id',
                                'bindingKey' => 'id',
                                'conditions'=>array('CAWealthAssets.status'=>'0')
                            ),
                             'CAWealthdeclarationDependents' => array(
                                'className'  => 'CAWealthdeclarationDependents',
                                'foreignKey' => 'wealthdeclaration_id',
                                'bindingKey' => 'id',
                                'conditions'=>array('CAWealthdeclarationDependents.status'=>'0')
                            ),
                        );
}
?>
