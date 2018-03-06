<?php
/* 
  * Property of Eastern Software Systems Pvt. Ltd.
  * Should be modified on by a Cake PHP Professional
  *  ******************************************************************************
  *  Description of LeavesType_controller.php
  *  ******************************************************************************
  *  file (Leaves_controller.php) version: 0.1.0
  *  file description: Cake PHP Controller file for manupilating Leave data
  *  file change log:
  *            created by Ayush Pant <ayush.pant@essindia.com>
  *            Jan 28, 2017 2:59:31 PM Created controller, and actions add | edit | view | delete.
  *            changed by <user>
  *            <date> <time> <changed-action-name> <change-description> 
  *  
  * ******************************************************************************
  *  project: EssPortal
  * project version: 0.1.0
  *  @author Ayush Pant <ayush.pant@essindia.com>
  *  @client company: Eastern Software Systems Pvt. Ltd. Expression project.user is undefined on line 21, column 73 in Templates/Licenses/license-default.txt.
  *  @date created: 2017
  *  @date last modified: Jun 28, 2011 2:59:31 PM
  *  ******************************************************************************
 */



class LeavesTypeController extends AppController{
    var $name = 'MstLeaveType';
    var $layout = 'admin';
	public $leaveonents = array('Auth', 'Session', 'Email','Cookie', 'RequestHandler');
    var $uses = array('UserDetail','Departments','OptionAttribute','MyProfile','MstEmpLeaveAllot');
	public $helpers = array('Js','Html','Form','Session','Userdetail','Leave','Common');

    function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow();
	    
    }
	
    function index() {
       $this->layout = 'admin';
	   //$dept=$this->Departments->find('list',array('fields'=>array('dept_code','dept_name')));
      //echo '<pre>';print_r($dept);die;
		//$this->set('Department',$dept);
		$leave=$this->OptionAttribute->find('all');
      //echo '<pre>';print_r($dept);die;
		$this->set('MstLeaveType',$leave);
	}
    
    function add() {
       if(!empty($this->data)){
			$this->autoRender=false;		
			if(!empty($this->data)) {
                                  $this->request->data['OptionAttribute']['id'] = $this->request->data['MstLeaveType']['leave_code'];
				  $this->request->data['OptionAttribute']['name'] = $this->request->data['MstLeaveType']['name'];
				  $this->request->data['OptionAttribute']['options_id'] = 21;
                                  $this->request->data['OptionAttribute']['org_id'] = '01';
                                  $this->request->data['OptionAttribute']['ho_org_id'] = 1;
                                 $con=$this->OptionAttribute->find('count',array('conditions'=>array('OptionAttribute.name'=>$this->request->data['OptionAttribute']['name'],'options_id'=>21)));
				 $con1=$this->OptionAttribute->find('count',array('conditions'=>array('OptionAttribute.id'=>$this->request->data['OptionAttribute']['id'],'options_id'=>21)));
				 
				  if($con>0 || $con1>0) {
						$st= json_encode(array('msg'=>"Duplicate Entry",'type'=>'error'));
				   } else { 
					   if($this->OptionAttribute->save($this->data)) {
								   $st= json_encode(array('msg'=>"Data saved successfully",'type'=>'success'));
								 //$this->redirect('index');
						} else {
							 $st= json_encode(array('msg'=>'Some Error Occurred','type'=>'error'));
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
			$id = $this->data['OptionAttribute']['id'];
			$dept_name = strtoupper($this->data['OptionAttribute']['name']);
			if($id != ''){
				$q .= " AND OptionAttribute.id= ".$id;
			}
			if($name != ''){
				$q .= " AND OptionAttribute.name=".$name;
			}
		}
                $conditions=array($q);
		$this->paginate = array(
                              'limit' => 10,
                              'conditions'=>array('options_id' => 21),
			                  'fields'=>array('OptionAttribute.id','OptionAttribute.name','OptionAttribute.id'),
				               'order' => array('OptionAttribute.id' => 'asc',
                                   )
                             );
							 
		$result = $this->paginate('OptionAttribute');
		$this->set('list',$result);
    }
        
        
        
        
	function edit($id) { //echo'<pre>';print_r($this->data);die('ss');
		$this->autoRender=false;
		$this->layout=false;
		if(!empty($this->data)) {
			$this->request->data['OptionAttribute']['id']=$id;
			$con=$this->OptionAttribute->find('count',array('conditions'=>array('OptionAttribute.name'=>$this->data['OptionAttribute']['name'],'id'=>$this->request->data['OptionAttribute']['id'])));         
			 if($con>0) {
				$st= json_encode(array('msg'=>"Duplicate Entry",'type'=>'error'));
			 } else{
               		if($this->OptionAttribute->save($this->data)) {
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
			if($this->OptionAttribute->delete($id)) {
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
	
    function addallot() {
       if(!empty($this->data)){
			$this->autoRender=false;		
			if(!empty($this->data)) {
				
				  
				  $this->request->data['MstEmpLeaveAllot']['emp_code'] = $this->request->data['MstEmpLeaveAllot']['emp_code'];
				  $this->request->data['MstEmpLeaveAllot']['id'] = $this->request->data['MstEmpLeaveAllot']['id'];
				  $this->request->data['MstEmpLeaveAllot']['allot_leave'] = $this->request->data['MstEmpLeaveAllot']['allot_leave'];
				  
				 $con=$this->MstEmpLeaveAllot->find('count',array('conditions'=>array('emp_code'=>$this->request->data['MstEmpLeaveAllot']['emp_code'],'id'=>$this->request->data['MstEmpLeaveAllot']['id'])));
				 			 
				  if($con>0) {
						$st= json_encode(array('msg'=>"Duplicate Entry",'type'=>'error'));
				   } else { 
					   if($this->MstEmpLeaveAllot->save($this->data)) {
								   $st= json_encode(array('msg'=>"Data saved successfully",'type'=>'success'));
						} else {
							 $st= json_encode(array('msg'=>'Some Error Occurred','type'=>'error'));
					   }
					}
				echo $st;
				exit;
			}   
                    }
                 }
    
    function allotview() {
		$this->paginate = array(
                              'limit' => 10,
                              'fields'=>array('MstEmpLeaveAllot.id','MstEmpLeaveAllot.id','MstEmpLeaveAllot.allot_leave','MstEmpLeaveAllot.emp_code','MstEmpLeaveAllot.created_date'),
				               'order' => array('MstEmpLeaveAllot.id' => 'asc',
                                   ),'group'=> array('MstEmpLeaveAllot.emp_code'));
							 
		$result = $this->paginate('MstEmpLeaveAllot');
		$this->set('list',$result);
    }
    
    function leavedetail() {        
        try {
		$id = $this->params['pass']['0'];
		if(!empty($id)){
			$ldetails = $this->MstEmpLeaveAllot->find('all', array(
				'conditions' => array('emp_code' => $id)
						));
			$this->set('ldetails',$ldetails);
			$this->layout = '';
			$this->render('allotlists');
                	}
        	} catch (Exception $e) {
        }
    }
    
    function editallot() {        
        try {
		$id = $this->params['pass']['0'];
		if(!empty($id)){
			$ldetails = $this->MstEmpLeaveAllot->find('all', array(
				'conditions' => array('emp_code' => $id)
						));
			$this->set('ldetails',$ldetails);
			$this->layout = '';
			$this->render('editallot');
			
		}
		
	} catch (Exception $e) {
        }
    }

    function editleave() {
		foreach($this->request->data['Edit_leave'] as $k=>$val)
		{
			$id = end(explode('_',$k));
			$lv_update=$this->MstEmpLeaveAllot->updateAll(array(
				'allot_leave' => $val
			),array(
				'emp_code' => $this->request->data['emp_code'],
				'id' => $id
			)); 
		}
		$this->redirect(array('controller' => 'leavestype', 'action' => 'allotview'));
		  
	}
    }


?>
