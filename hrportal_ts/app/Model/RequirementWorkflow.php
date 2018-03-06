<?php
App::uses('AppModel', 'Model');
class RequirementWorkflow extends AppModel{
	public  $useDbConfig = 'default';
    	public  $name = 'RequirementWorkflow'; 
    	public  $useTable = 'requirement_workflow';
	public  $primaryKey = 'id';

	/* public function checkstatus($emp_code=NULL, $leaveno=NULL){
		 $details = $this->find('count', array('conditions' => array('LeaveWorkflow.emp_code'=>$emp_code,
		     'LeaveWorkflow.leave_id'=>$leaveno,'LeaveWorkflow.fw_date IS NOT NULL')));
		 return $details;
	    }*/

 } 
?>