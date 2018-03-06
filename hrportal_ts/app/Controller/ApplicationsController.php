<?php
/* 
  * Property of Eastern Software Systems Pvt. Ltd.
  * Should be modified on by a Cake PHP Professional
  *  ******************************************************************************
  *  Description of Applications_controller.php
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


class ApplicationsController extends AppController {

    public $uses = array('Applications','Roles','Employees','UserDetail');
    public $components = array('Session', 'Cookie', 'RequestHandler', 'Applicationscmp');
    public $helpers = array('Html', 'Js',  'Form', 'Session'); //Helper

   public function beforeFilter() {
        if($this->Auth->user('user_type')!='Administrator')
        {
           $this->redirect(array('controller'=>'admins', 'action'=>'login'));
        }
        parent::beforeFilter();
        $this->Auth->allow();
    }

    public function pr_create() {
        $this->autoRender = false;
	$this->request->data['Applications']['sloc_id'] = '1';
	$this->request->data['Applications']['usr_id_create'] = '1';
	$this->request->data['Applications']['usr_id_create_dt']=date('Y-m-d h:i:s');
	$this->request->data['Applications']['wf_status'] = 1;
	$this->request->data['Applications']['cld_id'] = '0000';
        $this->Applications->set($this->request->data);
        $response = new stdClass();
        $response->message = '';
        if ($this->Applications->validates()) {
	    $this->Applications->save();
            $response->message = 'Applicaton created successfully.';
        } else {
            $errors = $this->Applications->invalidFields();
            foreach ($errors as $err) {
                $response->message .=$err . PHP_EOL;
            }
        }
        header("HTTP/1.0 200 OK");
        header('Content-type: text/json; charset=utf-8');
        header("Cache-Control: no-cache, must-revalidate");
        header("Expires: Mon, 21 Oct 2011 10:30:00 IST");
        header("Pragma: no-cache");
        echo json_encode($response);
    }

    public function prDelete() {
        $this->autoRender = false;
        $response = new stdClass();
        $response->message = '';
	$this->Applications->delete($this->request->data['Applications']['id']);
        $response->message = 'Applicaton deleted successfully.';
        header("HTTP/1.0 200 OK");
        header('Content-type: text/json; charset=utf-8');
        header("Cache-Control: no-cache, must-revalidate");
        header("Expires: Mon, 21 Oct 2011 10:30:00 IST");
        header("Pragma: no-cache");
        echo json_encode($response);
    }    
    
    public function pr_arptreelist_json() {
        $this->layout = '';
        $this->autoRender = false;
        header("HTTP/1.0 200 OK");
        //header('Content-type: text/json; charset=utf-8');
        header("Cache-Control: no-cache, must-revalidate");
        header("Expires: Mon, 21 Oct 2011 10:30:00 IST");
        header("Pragma: no-cache");
      //  die;
        echo $this->Applicationscmp->getApplicationsTreeJson();
    }
   public function prListHtml(){
       
        try {
         
            $data = $this->Applications->find('all');
            $ids = array(); 
            $isEmpIds = false;
            if (isset($this->request->data['empIdList']))
            if(!empty($this->request->data['empIdList']) OR $this->request->data['empIdList']=='0'){
                $isEmpIds = true;
            }
            if($isEmpIds){
                    $ids = explode(',',$this->request->data['empIdList']);
                    $aros_roles = array();
                    if(count($ids) == 1){
                        ////////////////////////////////////////////////////////////
                        //Find the selected role
                        ////////////////////////////////////////////////////////////
                        $aros_employees = $this->Acl->Aro->find('list',array(
                            'conditions' => array(
                                'model'=> 'UserDetail',
                                'foreign_key'=>$ids[0],
                            ),
                            'fields' => 'parent_id'
                        ));
			//  pr($aros_employees);die;
                       // pr($aros_employees);die;
                        $aros_employees = array(0)+$aros_employees;
                        @$aros_roles = $this->Acl->Aro->find('all',array(
                            'conditions' => array(
                                'Aro.id'=>$aros_employees,
                            ),
                            'joins' => array(
                                array(
                                        'table' => 'roles',
                                        'type' => 'left',
                                        'foreignKey' => false,
                                        'conditions' => array(
                                            'roles.id = Aro.foreign_key'
                                        ),
                                        //'fields' => array('vc_rep_to','ch_work_status','vc_dept_code')                                
                                )
                            ),
                            'fields'=>array('Aro.foreign_key','roles.id','roles.name','roles.nu_application_id'),
                        ));
                      
                    } 
                    ////////////////////////////////////////////////////////////
                    $names = $this->UserDetail->find('all',array(
                        'fields' => array('CONCAT_WS(" ",MyProfile.emp_firstname,MyProfile.emp_lastname) as emp_name'),                
			'conditions' => array(
                            'UserDetail.emp_code' => $ids
                        ),
			'joins' => array(
			array(
				'table' => 'myprofile',
			    	'alias' => 'MyProfile',
			    	'type' => 'left',
			    	'conditions' => array(
					'MyProfile.emp_code = UserDetail.emp_code'	
					)
			)
		)
                    ));
                    if(in_array(0,$ids))  $names[] = array('User'=>array('emp_name'=>'Administrator'));
            }
            /**
             * ************************************************************************
             * OUTPUT set output header, variable destruction, set layout, set view 
             * ************************************************************************
             */
            $this->layout = '';
            $this->set(compact('data','names','ids','aros_roles'));
        } catch (Exception $e) {
            /**
             * ************************************************************************
             * OUTPUT ERROR set output header, variable destruction, set layout, set view
             * ************************************************************************
             */
        }        
    }
}
