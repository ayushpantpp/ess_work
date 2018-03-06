<?php
App::uses('AppModel', 'Model');


class Employees extends AppModel {
    var $useDbConfig = 'default';
    var $name='Employees';
    var $useTable = 'emp_account'; 
    var $primaryKey = 'vc_emp_id_makess';    
  
    var $recursive = 3;
    var $actsAs = array('Acl' => array('requester'));
    
    function parentNode() {
        return null;    
    }    
    function hashPasswords($data) {
        return $data;
    }
}