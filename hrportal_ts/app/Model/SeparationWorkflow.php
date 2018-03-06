<?php
App::uses('AppModel', 'Model');
class SeparationWorkflow extends AppModel{
	public  $useDbConfig = 'default';
    	public  $name = 'SeparationWorkflow'; 
    	public  $useTable = 'separation_workflows';
	public  $primaryKey = 'id';

	 public function checkstatus($emp_code=NULL, $leaveno=NULL){
		 $details = $this->find('count', array('conditions' => array('SeparationWorkflow.emp_code'=>$emp_code,
		     'SeparationWorkflow.leave_id'=>$leaveno,'SeparationWorkflow.fw_date IS NOT NULL')));
		 return $details;
	    }


	    public $belongsTo = array(
		'Separation' => array(
			'className' => 'Separation',
			)
		);

 } 
?>
