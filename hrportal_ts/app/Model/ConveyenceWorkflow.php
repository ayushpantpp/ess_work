<?php
App::uses('AppModel', 'Model');
class ConveyenceWorkflow extends AppModel{
	public  $useDbConfig = 'default';
    	public  $name = 'ConveyenceWorkflow'; 
    	public  $useTable = 'conveyence_workflow';
		public  $primaryKey = 'id';

	public function checkstatus($emp_code=NULL, $conveyenceno=NULL){
		 $details = $this->find('count', array('conditions' => array('ConveyenceWorkflow.emp_code'=>$emp_code,
		     'ConveyenceWorkflow.voucher_id'=>$conveyenceno,'ConveyenceWorkflow.fw_date IS NOT NULL')));
		 return $details;
	}

 } 
?>
