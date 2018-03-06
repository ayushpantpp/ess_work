<?php
App::uses('AppModel', 'Model');
class LeaveWorkflow extends AppModel{
	public  $useDbConfig = 'default';
    	public  $name = 'LeaveWorkflow'; 
    	public  $useTable = 'leave_workflow';
	public  $primaryKey = 'leave_wf_id';

	 public function checkstatus($emp_code=NULL, $leaveno=NULL){
		 $details = $this->find('count', array('conditions' => array('LeaveWorkflow.emp_code'=>$emp_code,
		     'LeaveWorkflow.leave_id'=>$leaveno,'LeaveWorkflow.fw_date IS NOT NULL','LeaveWorkflow.status IS NOT NULL')));
		 return $details;
	    }

 } 
?>
