<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of qsdrole_controller
 *
 * @author Administrator
 */
class WorkflowsController extends AppController{

    //put your code here
    var $name = 'Workflows';
    var $layout = 'admin';
	public $components = array('Auth', 'Session', 'Email','Cookie', 'RequestHandler');
    var $uses = array('UserDetail','Applications','Company');
	public $helpers = array('Js','Html','Form','Session','Userdetail');

    function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow();
	$currentUser = $this->checkUser();
	    
    }
	
    function index() {
       $this->layout = 'admin';
       
    }
    
    function applications() {
       $this->layout = 'admin';
       
    }
    
    function add() {
       if(!empty($this->data)){
			$this->autoRender=false;		
			if(!empty($this->data)) {
				  $this->request->data['Applications']['sloc_id'] = '1';
                                  $this->request->data['Applications']['org_id']=$this->request->data['Application']['comp_code'];
                                  $ho_id = $this->Company->find('first', array('conditions' => array('org_id' => $this->request->data['Application']['comp_code'])));
                                  $this->request->data['Applications']['ho_org_id'] = $ho_id['Company']['ho_org_id'];
                                  $this->request->data['Applications']['vc_application_name'] = $this->data['Applications']['vc_application_name'];
				  $this->request->data['Applications']['usr_id_create'] = '1';
				  $this->request->data['Applications']['usr_id_create_dt']=date('Y-m-d h:i:s');
				  $this->request->data['Applications']['wf_status'] = 1;
				  $this->request->data['Applications']['cld_id'] = '0000';
				  $con=$this->Applications->find('count',array('conditions'=>array('Applications.vc_application_name'=>$this->data['Applications']['vc_application_name'])));
				  if($con>0) {
						$st= json_encode(array('msg'=>"Duplicate Entry",'type'=>'error'));
				   } else { 
					   if($this->Applications->save($this->data)) {
						 $st = json_encode(array('msg'=>"Data saved successfully",'type'=>'success'));
					   } else {
						 $st = json_encode(array('msg'=>'Some Error Occurred','type'=>'error'));
					   }
					}
				echo $st;
				exit;
			}   
       }
    }
    
    function lists() {
		$q='1=1';
		if(!empty($this->data)){
			$id = $this->data['Applications']['id'];
			$vc_application_name = strtoupper($this->data['Applications']['vc_application_name']);
			if($id != ''){
				$q .= " AND Applications.id= ".$id;
			}
			if($vc_application_name != ''){
				$q .= " AND Applications.vc_application_name=".$vc_application_name;
			}
		}
		$conditions=array($q);
		$this->paginate = array(
                              'limit' => 10,
                              'conditions'=>$conditions,
			                  'fields'=>array('Applications.id','Applications.vc_application_name','Applications.wf_status'),
				               'order' => array(
									   'Applications.id' => 'asc',
                                   )
                             );
							 
		$result = $this->paginate('Applications');
		//pr($result); die;
		$this->set('list',$result);
    }
        
        
        
        
	function edit($id) {
		$this->autoRender=false;
		$this->layout=false;
		if(!empty($this->data)) {
			$this->request->data['Applications']['id']=$id;
			$con=$this->Applications->find('count',array('conditions'=>array('Applications.vc_application_name'=>$this->data['Applications']['vc_application_name'])));         
			 if($con>0) {
				$st= json_encode(array('msg'=>"Duplicate Entry",'type'=>'error'));
			 } else{
                $this->request->data['Applications']['usr_id_mod'] = '1';
				$this->request->data['Applications']['usr_id_mod_dt']=date('Y-m-d');
				if($this->Applications->save($this->data)) {
					$st= json_encode(array('msg'=>"Data saved successfully",'type'=>'success','dt'=>date('d-M-Y h:i:s')));
			   } else {
					$st= json_encode(array('msg'=>'Updation not done','type'=>'error'));
				}
			}
		}
		else
			$st= json_encode(array('msg'=>'Updation not done','type'=>'error'));
	   echo $st;
	   exit;  
	}
        
	function delete($id=null) {
		$this->layout=false;
		$this->autoRender=false;
        if(!empty($id)) {
			if($this->Applications->delete($id)) {
              $st= json_encode(array('msg'=>'Record Deleted','type'=>'success'));
		   } else {
			  $st= json_encode(array('msg'=>'Record not deleted','type'=>'error'));
		   }
		}
		else
			$st= json_encode(array('msg'=>'No Record Selected','type'=>'error'));
		echo $st;
		exit;
	}

}

?>
