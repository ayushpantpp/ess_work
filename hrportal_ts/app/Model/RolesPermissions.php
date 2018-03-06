<?php
App::uses('AppModel', 'Model');
class RolesPermissions extends AppModel{
   public  $useDbConfig = 'default';
    public  $name = 'RolesPermissions'; 
    public  $useTable = 'roles_permissions';
    public  $primaryKey = 'id';
}