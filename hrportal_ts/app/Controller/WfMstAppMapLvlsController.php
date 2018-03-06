<?php
class WfMstAppMapLvlsController extends AppController{

    //put your code here
    var $names= 'WfMstAppMapLvls';
    var $layout = 'admin';
	public $components = array('Auth', 'Session', 'Email','Cookie', 'RequestHandler',);
    var $uses = array('UserDetail','Designation','Department','WfMstAppMapLvl','WfDtAppMapLvl','Company');
	public $helpers = array('Js','Html','Form','Session','Userdetail');

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
			$add_var['comp_code']=$this->request->data['WfMstAppMapLvl']['comp_code'];
                        $add_var['org_id']=$this->request->data['WfMstAppMapLvl']['comp_code'];
                        $ho_id = $this->Company->find('first', array('conditions' => array('org_id' => $this->request->data['WfMstAppMapLvl']['org_id'])));
                        $add_var['ho_org_id'] = $ho_id['Company']['ho_org_id'];
                        $add_var['wf_dept_id']=$this->request->data['WfMstAppMapLvl']['dept_code'];
			$add_var['wf_app_id']=$this->request->data['WfMstAppMapLvl']['app_code'];
			$add_var['wf_max_lvl']=$this->request->data['WfMstAppMapLvl']['max_lvl'];
			$add_var['wf_hr_approval']=$this->request->data['WfMstAppMapLvl']['wf_hr_approval'];
                        $add_var['manager_approval']=$this->request->data['WfMstAppMapLvl']['manager_approval'];
                        $add_var['created_date']=date('Y-m-d');
                        
                       
			$con=$this->WfMstAppMapLvl->find('count',array('conditions'=>array('wf_app_id'=>$this->request->data['WfMstAppMapLvl']['app_code'],'wf_dept_id'=>$this->request->data['WfMstAppMapLvl']['dept_code'],'comp_code'=>$this->request->data['WfMstAppMapLvl']['comp_code'])));
			if($con>0) {
				$st= json_encode(array('msg'=>"Duplicate Entry",'type'=>'error'));
			} 
			else { 
				if($this->WfMstAppMapLvl->save($add_var)) {
					$st= json_encode(array('msg'=>"Data saved successfully",'type'=>'success'));
					unset($add_var);   
				} else {
					$st= json_encode(array('msg'=>'Some Error Occurred','type'=>'error'));
				}
			}
			echo $st;
			exit;
		}         
    }
    
   
 




    function lists() {
    	//Configure::write('debug',2);
		$q='';
		if(!empty($this->data)){
	
			$id = $this->data['WfMstAppMapLvl']['comp_code'];

			$dept= $this->data['WfMstAppMapLvl']['dept_code'];


			$max_lvl = strtoupper($this->data['WfMstAppMapLvl']['max_lvl']);
						$appcode = $this->data['WfMstAppMapLvl']['app_code'];
		
			if($id!= ''){
				$q .= "  WfMstAppMapLvl.org_id= ".$id;
			}
			if($dept!='' &&$id!='')
			{
				$q .= " AND WfMstAppMapLvl.wf_dept_id Like '$dept%'";
				
			}
			
if($id!=''&&$appcode!=''){
				$q .= " AND  WfMstAppMapLvl.wf_app_id= ".$appcode;
			}
			else if($appcode!=''){
				$q .= "   WfMstAppMapLvl.wf_app_id= ".$appcode;
			}

			if($max_lvl!= ''&&$id!=''){
				$q .= " AND WfMstAppMapLvl.wf_max_lvl=".$max_lvl;
			}
			else if($max_lvl!= ''){
$q .= "  WfMstAppMapLvl.wf_max_lvl=".$max_lvl;
			}
		
		$conditions=array($q);
		


		$this->paginate = array(
		  'limit' => 10,
		  'conditions'=>$conditions,
		  'fields'=>array('WfMstAppMapLvl.wf_id','WfMstAppMapLvl.wf_dept_id','WfMstAppMapLvl.org_id','WfMstAppMapLvl.wf_max_lvl','WfMstAppMapLvl.wf_app_id,WfMstAppMapLvl.wf_hr_approval','WfMstAppMapLvl.manager_approval'),
		   'order' => array(
				   'WfMstAppMapLvl.wf_id' => 'desc',
			   )
		);							 
		$result = $this->paginate('WfMstAppMapLvl');
		$this->set('list',$result);
    }
    else{
    	
		$this->paginate = array(
		  'limit' => 10,
		  'conditions'=>$conditions,
		  'fields'=>array('WfMstAppMapLvl.wf_id','WfMstAppMapLvl.wf_dept_id','WfMstAppMapLvl.org_id','WfMstAppMapLvl.wf_max_lvl','WfMstAppMapLvl.wf_app_id,WfMstAppMapLvl.wf_hr_approval','WfMstAppMapLvl.manager_approval'),
		   'order' => array(
				   'WfMstAppMapLvl.wf_id' => 'desc',
			   )
		);							 
		$result = $this->paginate('WfMstAppMapLvl');
		$this->set('list',$result);
    }}
	function edit($id) { //pr($this->request->data);die;
		$this->autoRender=false;
		$this->layout=false;
		$val=array();
		$st='';
		if(!empty($this->request->data)) {
			$con=$this->WfDtAppMapLvl->find('count',array('conditions'=>array('WfDtAppMapLvl.wf_app_map_lvl_id'=>$this->request->data['wf_id'])));
			if($con==0){
				$st= json_encode(array('msg'=>"Level not defined corresponding to this application in Detail App Master",'type'=>'success'));	
			}
			else if($con>0) {
				if($con<$this->request->data['wf_max_lvl'])
				{
					$st= json_encode(array('msg'=>"Data updated successfully. Please insert corresponding levels to Detail App Master.",'type'=>'success'));
				}
				else if($con>$this->request->data['wf_max_lvl'])
				{
					$st= json_encode(array('msg'=>"Data not updated. Please delete corresponding levels to Detail App Master.",'type'=>'error'));
					echo $st;
					exit;
				}
			}
			
			$val['wf_max_lvl'] =$this->request->data['wf_max_lvl'];
			$val['wf_hr_approval'] =$this->request->data['wf_hr_approval'];
                        $val['wf_hr_approval'] =$this->request->data['manager_approval'];
			$val['wf_id']=$id;//pr($val);die;
			if($this->WfMstAppMapLvl->save($val)) {
				if($st!='')
					$st=$st;
				else
					$st= json_encode(array('msg'=>"Data updated successfully",'type'=>'success','dt'=>date('d-M-Y h:i:s')));
			} else {
				$st= json_encode(array('msg'=>'Updation not done','type'=>'error'));
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
			if($this->WfMstAppMapLvl->delete($id)) {
				$con=$this->WfDtAppMapLvl->find('count',array('conditions'=>array('WfDtAppMapLvl.wf_app_map_lvl_id'=>$id)));
				if($con)
					$this->WfDtAppMapLvl->deleteAll(array('WfDtAppMapLvl.wf_app_map_lvl_id'=>$id));
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
