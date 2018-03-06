<?php
App::uses('AppModel', 'Model');
class Permissions extends AppModel {

   // var $name = "Permissions";
    public  $useDbConfig = 'default';
    public  $name = 'Permissions'; 
    public  $useTable = 'permissions';
    public  $primaryKey = 'id';
    public $hasAndBelongsToMany = array(
        'Roles' =>
        array(
            'className' => 'Roles',
            'joinTable' => 'roles_permissions',
            'foreignKey' => 'nu_permission_id',
            'associationForeignKey' => 'nu_role_id',
            'unique' => false,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'finderQuery' => '',
            'deleteQuery' => '',
            'insertQuery' => ''
        ),
        'Acos' =>
        array(
            'className' => 'Acos',
            'joinTable' => 'permissions_acos',
            'foreignKey' => 'nu_permission_id',
            'associationForeignKey' => 'nu_aco_id',
            'unique' => false,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'finderQuery' => '',
            'deleteQuery' => '',
            'insertQuery' => ''
        ),        
    );

}