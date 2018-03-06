<?php
/* 
  * Property of Eastern Software Systems Pvt. Ltd.
  * Should be modified on by a Cake PHP Professional
  *  ******************************************************************************
  *  Description of Leaves_controller.php
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

class MailerMasterController extends AppController{
    var $names= 'MailerMaster';
    var $layout = 'admin';
	public $components = array('Auth', 'Session', 'Email','Cookie', 'RequestHandler',);
    var $uses = array('UserDetail','Designation','Department','MailerMaster','MailerMaster','Company','Applications');
	public $helpers = array('Js','Html','Form','Session','Userdetail');
    function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow();
    }
	
    function index() {
       $this->layout = 'admin';	  
	}
    
    function add() { 
//        Configure::write('debug', 2);
	$add_var=array();
        if(!empty($this->data)){
			$this->autoRender=false;				
			$add_var['org_id']=$this->request->data['Application']['comp_code'];
                        $ho_id = $this->Company->find('first', array('conditions' => array('org_id' => $this->request->data['Application']['comp_code'])));
                        $add_var['ho_org_id'] = $ho_id['Company']['ho_org_id'];
                        $add_var['module_code']=$this->request->data['Application']['app_code'];
                        $add_var['tags']= json_encode(explode(',', $this->request->data['Application']['tags'])) ;
			$add_var['event_id']=$this->request->data['Application']['event_code'];
			$add_var['active_status']=$this->request->data['Application']['active_status'];
                        $add_var['frequency']=$this->request->data['Application']['frequency']?$this->request->data['Application']['frequency']:0;
                        $add_var['body_data']=htmlentities(htmlspecialchars($this->request->data['Application']['body_data']));
                        $add_var['created_date']=date('Y-m-d');
			$con=$this->MailerMaster->find('count',array('conditions'=>array('module_code'=>$this->request->data['Application']['app_code'],'org_id'=>$this->request->data['Application']['comp_code'],'event_id'=>$this->request->data['Application']['event_code'])));
			if($con>0) {
				$st= json_encode(array('msg'=>"Duplicate Entry",'type'=>'error'));
			} 
			else { 
				if($this->MailerMaster->save($add_var)) {
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
        	
		$q='1=1';
		if(!empty($this->data)){
			$id = $this->data['MailerMaster']['id'];
			$max_lvl = strtoupper($this->data['MailerMaster']['wf_max_lvl']);
			if($id != ''){
				$q .= " AND MailerMaster.id= ".$id;
			}
			if($dept_name != ''){
				$q .= " AND MailerMaster.module_code=".$max_lvl;
			}
		}
		$conditions=array($q);
		$this->paginate = array(
		  'limit' => 10,
		  'conditions'=>$conditions,
		  'fields'=>array('MailerMaster.id','MailerMaster.module_code','MailerMaster.event_id','MailerMaster.frequency','MailerMaster.body_data,MailerMaster.ho_org_id','MailerMaster.org_id','MailerMaster.active_status','MailerMaster.body_data','MailerMaster.tags'),
		   'order' => array(
				   'MailerMaster.id' => 'asc',
			   )
		);							 
		$result = $this->paginate('MailerMaster');
		$this->set('list',$result);
    }
	function edit($id) { //pr($this->request->data);die;
            Configure::write('debug',2);
		$this->autoRender=false;
		$this->layout=false;
		$val=array();
		if(!empty($this->request->data)) {
			$val['active_status'] =$this->request->data['active_status'];
			$val['body_data'] =htmlentities(htmlspecialchars($this->request->data['body_data']));
                        $val['frequency'] =$this->request->data['frequency'];
			$val['id']=$id;//pr($val);die;
                        if($this->MailerMaster->save($val)) {
                            echo    json_encode(array('msg'=>"Data updated successfully",'type'=>'success','dt'=>date('d-M-Y h:i:s')));
			} else {
			    echo json_encode(array('msg'=>'Updation not done','type'=>'error'));
			}
		}
		else
			echo json_encode(array('msg'=>'Updation not done','type'=>'error'));
		exit;  
	}
        
	function delete($id=null) { 
            Configure::write('debug',2);
		$this->layout=false;
		$this->autoRender=false;
        if(!empty($id)) {
			if($this->MailerMaster->delete($id)) {
				$con=$this->MailerMaster->find('count',array('conditions'=>array('MailerMaster.wf_app_map_lvl_id'=>$id)));
				if($con)
					$this->MailerMaster->deleteAll(array('MailerMaster.wf_app_map_lvl_id'=>$id));
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
	function getApplications($comp_code)
	{
		$appList = $this->Applications->find('list',array('fields'=>array('id','vc_application_name'),'conditions'=>array('org_id'=>$comp_code)));
		echo json_encode($appList);die;	
	}
}

?>
