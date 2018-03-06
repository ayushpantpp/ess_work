<?php
class MstAllotLeavesController extends AppController{

    //put your code here
    var $names= 'MstAllotLeaves';
    var $layout = 'admin';
	public $components = array('Auth', 'Session', 'Email','Cookie', 'RequestHandler',);
    var $uses = array('UserDetail','MstEmpLeaveAllot','Department','MstAllotLeaves');
	public $helpers = array('Js','Html','Form','Session','Userdetail');

    function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow();
	    
    }
	
    function index() {
       $this->layout = 'admin';
	   $emp=$this->UserDetail->find('fields');
	   $this->set('employee',$emp);
	   pr($emp);die;
	   
	  
	}
    
    function add() {
		$add_var=array();
       if(!empty($this->data)){
			$this->autoRender=false;				
				  $add_var['dept_code']=$this->request->data['MstEmpLeaveAllot']['dept_code'];
				  $add_var['desg_code']=strtoupper($this->request->data['MstEmpLeaveAllot']['desg_code']);
				  $add_var['desc']=strtoupper($this->request->data['MstEmpLeaveAllot']['desc']);
				  $add_var['status']=true;
				  $add_var['created_date']=date('Y-m-d h:i:s');
				  $add_var['comp_code']=$this->request->data['MstEmpLeaveAllot']['comp_code'];
				
				$con=$this->MstEmpLeaveAllot->find('count',array('conditions'=>array('desc'=>$this->request->data['MstEmpLeaveAllot']['desc'],'desg_code'=>$this->request->data['MstEmpLeaveAllot']['desg_code'])));
				 
				  if($con>0) {
						$st= json_encode(array('msg'=>"Duplicate Entry",'type'=>'error'));
				   } else { 
					   if($this->MstEmpLeaveAllot->save($add_var)) {
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
    
    function lists() {
		$q='1=1';
		if(!empty($this->data)){
			$id = $this->data['WfMstAppMapLvl']['wf_id'];
			$max_lvl = strtoupper($this->data['WfMstAppMapLvl']['wf_max_lvl']);
			if($id != ''){
				$q .= " AND WfMstAppMapLvl.id= ".$id;
			}
			if($dept_name != ''){
				$q .= " AND WfMstAppMapLvl.wf_max_lvl=".$max_lvl;
			}
		}
		$conditions=array($q);
		$this->paginate = array(
                              'limit' => 10,
                              'conditions'=>$conditions,
			                  'fields'=>array('WfMstAppMapLvl.wf_id','WfMstAppMapLvl.wf_dept_id','WfMstAppMapLvl.comp_code','WfMstAppMapLvl.wf_max_lvl','WfMstAppMapLvl.wf_app_id'),
				               'order' => array(
									   'WfMstAppMapLvl.wf_id' => 'asc',
                                   )
                             );
							 
		$result = $this->paginate('WfMstAppMapLvl');
		//pr($result); die;
		
		/*$this->paginate = array(
                              'limit' => 10,
                              'conditions'=>$conditions,
			                  'fields'=>array('Department.id','Department.dept_name','Department.dept_code','Department.status'),
				               'order' => array(
									   'Department.id' => 'asc',
                                   )
                             );
							 
		$result = $this->paginate('Department');*/
		$this->set('list',$result);
    }
        
        
        
        
	function edit($id) { //echo'<pre>';print_r($this->data);die('ss');
		$this->autoRender=false;
		$this->layout=false;
		if(!empty($this->data)) {
			$this->request->data['MstEmpLeaveAllot']['id']=$id;
			$con=$this->MstEmpLeaveAllot->find('count',array('conditions'=>array('MstEmpLeaveAllot.desc'=>$this->data['MstEmpLeaveAllot']['desc'],'MstEmpLeaveAllot.desg_code'=>$this->data['MstEmpLeaveAllot']['desg_code'])));         
			 if($con>0) {
				$st= json_encode(array('msg'=>"Duplicate Entry",'type'=>'error'));
			 } else{
                $this->request->data['MstEmpLeaveAllot']['desc'] =strtoupper($this->request->data['MstEmpLeaveAllot']['desc']);
				$this->request->data['MstEmpLeaveAllot']['desg_code']=strtoupper($this->request->data['MstEmpLeaveAllot']['desg_code']);
				$this->request->data['MstEmpLeaveAllot']['id']=$this->request->data['MstEmpLeaveAllot']['id'];
				if($this->MstEmpLeaveAllot->save($this->data)) {
					$st= json_encode(array('msg'=>"Data saved successfully",'type'=>'success','dt'=>date('d-M-Y h:i:s')));
			   } else {
					$st= json_encode(array('msg'=>'Updation not done','type'=>'error'));
				}
			}
			//print_r($con);die;
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
			if($this->MstEmpLeaveAllot->delete($id)) {
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
	function getDepartment($comp_code)
	{
		$deptList = $this->Department->find('list',array('fields'=>array('dept_code','dept_name'),'conditions'=>array('comp_code'=>$comp_code)));
		echo json_encode($deptList);die;
		
	}

}

?>
