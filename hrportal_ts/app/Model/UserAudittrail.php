<?php
App::uses('AppModel', 'Model');
class UserAudittrail extends AppModel {
    var $useDbConfig = 'default';
    var $name = 'UserAudittrail'; 
    var $useTable = 'audit_trail'; 
    var $primaryKey = 'id';
    
	public function getMaxid()
	{
		$val=$this->find('first',array('fields'=>array('id'),'order'=>array('id desc')));
		$maxid=$val['UserAudittrail']['id']+1;
		return $maxid;
		
	}
}
?>