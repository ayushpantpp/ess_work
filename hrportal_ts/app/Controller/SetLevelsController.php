<?php
class SetLevelsController extends AppController{

    //put your code here
    var $name = 'WfMstAppMapLvl';
    var $layout = 'admin';
	public $components = array('Auth', 'Session', 'Email','Cookie', 'RequestHandler',);
    var $uses = array('UserDetail','Designation','Department','WfMstAppMapLvl');
	public $helpers = array('Js','Html','Form','Session','Userdetail','Common');

    function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow();
	    
    }
	
    function index() {
       $this->layout = 'admin';
	  
	}
    
    function add() {
		$add_var=array();
       if(!empty($this->data)){
			$this->autoRender=false;				
				  $add_var['dept_code']=$this->request->data['Designation']['dept_code'];
				  $add_var['desg_code']=strtoupper($this->request->data['Designation']['desg_code']);
				  $add_var['desc']=strtoupper($this->request->data['Designation']['desc']);
				  
				  $add_var['status']=true;
				  $add_var['created_date']=date('Y-m-d h:i:s');
				  $add_var['comp_code']=$this->request->data['Designation']['comp_code'];
				
				$con=$this->Designation->find('count',array('conditions'=>array('desc'=>$this->request->data['Designation']['desc'],'desg_code'=>$this->request->data['Designation']['desg_code'])));
				 
				  if($con>0) {
						$st= json_encode(array('msg'=>"Duplicate Entry",'type'=>'error'));
				   } else { 
					   if($this->Designation->save($add_var)) {
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
			$id = $this->data['WfMstAppMapLvl']['id'];
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
			                  'fields'=>array('WfMstAppMapLvl.id','WfMstAppMapLvl.wf_dept_id','WfMstAppMapLvl.comp_code','WfMstAppMapLvl.wf_max_lvl','WfMstAppMapLvl.wf_app_id'),
				               'order' => array(
									   'WfMstAppMapLvl.id' => 'asc',
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
			$this->request->data['Designation']['id']=$id;
			$con=$this->Designation->find('count',array('conditions'=>array('Designation.desc'=>$this->data['Designation']['desc'],'Designation.desg_code'=>$this->data['Designation']['desg_code'])));         
			 if($con>0) {
				$st= json_encode(array('msg'=>"Duplicate Entry",'type'=>'error'));
			 } else{
                $this->request->data['Designation']['desc'] =strtoupper($this->request->data['Designation']['desc']);
				$this->request->data['Designation']['desg_code']=strtoupper($this->request->data['Designation']['desg_code']);
				$this->request->data['Designation']['id']=$this->request->data['Designation']['id'];
				if($this->Designation->save($this->data)) {
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
			if($this->Designation->delete($id)) {
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
