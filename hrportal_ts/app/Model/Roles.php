<?php
App::uses('AppModel', 'Model');
class Roles extends AppModel {

   // public  $name = "Roles";
     public  $useDbConfig = 'default';
    public  $name = 'Roles'; 
    public  $useTable = 'roles';
    public  $primaryKey = 'id';
    public  $hasAndBelongsToMany = array(
        'Permissions' =>
        array(
            'className' => 'Permissions',
            'joinTable' => 'roles_permissions',
            'foreignKey' => 'nu_role_id',
            'associationForeignKey' => 'nu_permission_id',
            'unique' => false,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'finderQuery' => '',
            'deleteQuery' => '',
            'insertQuery' => ''
        )
    );
    public  $actsAs = array('Acl' => array('requester'));

    function parentNode() {
        return null;
    }

}