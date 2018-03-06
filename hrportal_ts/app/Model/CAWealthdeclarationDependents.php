<?php
App::uses('AppModel', 'Model');
class CAWealthdeclarationDependents extends AppModel {
    public  $useDbConfig = 'default';
    public  $name = 'CAWealthdeclarationDependents'; 
    public  $useTable = 'ca_wealthdeclaration_dependents';
    
    public  $belongsTo = array(
                            'CADependentDetails' => array(
                                'className'  => 'CADependentDetails',
                                'foreignKey' => 'dependents_id'
                                
                            )
                        );
}
?>
