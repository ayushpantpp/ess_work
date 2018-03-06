<?php
/* 
  * Property of Eastern Software Systems Pvt. Ltd.
  * Should be modified on by a Cake PHP Professional
  *  ******************************************************************************
  *  Description of Admins_controller.php
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

App::uses('AppController', 'Controller');

class AdminsController extends AppController {

    public $uses = array('Employees', 'MyProfile', 'MstLogo','Aros', 'Applications','UserDetail','Company');
    public $helpers = array('Js', 'Html', 'Form', 'Session', 'Permission');
    public $components = array('Auth', 'Session', 'Email');

    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow();
        $currentUser = $this->checkUser();
    }

    public function index() {
        $this->layout = 'admin_login';
        if ($this->loggedIn) {
            $this->redirect(array('controller' => 'admins', 'action' => 'dashboard'));
        } else {
            $this->redirect(array('controller' => 'admins', 'action' => 'login'));
        }
    }

    public function login() {
        $this->layout = 'employee-login';
        $logo = $this->MstLogo->find('first');
        $this->set('logo',$logo['MstLogo']['logo_file']);
        try {
            if ($this->Auth->user('id')) {
                $this->redirect(array('controller' => 'users', 'action' => 'dashboard'));
            }
            if (!empty($this->request->data)) {
                if ($this->Auth->login()) {
                    $id = $this->Auth->user('id');
                    
                    if (!empty($id)) {
                        if($this->Auth->user('emp_code')==0 || $this->Auth->user('emp_code')=='sa' ){
                            $this->Session->write('Auth.User.user_type', 'Administrator');
                            $us_data = array();
                            /* Save data for user_detail table */
                            $us_data['id'] = $this->Auth->user('id');
                            $us_data['last_login'] = date('Y-m-d h:i:s');
                            $us_data['session_id'] = $this->Session->id();
                            $this->UserDetail->save($us_data);
                            $this->request->data = null;
                            $this->Session->setFlash('Successfuly Login');
                            $this->redirect(array('controller' => 'admins', 'action' => 'dashboard'));
                        } else {
                            $this->Session->destroy();
                            $this->request->data = null;
                            $this->Session->setFlash($this->Auth->loginError);
                        }
                    } else {
                        $this->request->data = null;
                        $this->Session->setFlash($this->Auth->loginError);
                    }
                } else {
                    $this->request->data = null;
                    $this->Session->setFlash($this->Auth->loginError);
                }
            }
        } catch (Exception $e) {
            echo 'Caught exception: ', $e->getMessage(), "\n";
            exit;
        }
    }

    function logout() {

        try {
            $this->Session->delete('Auth');
            $this->Session->destroy();
            $this->redirect($this->Auth->logout());
        } catch (Exception $e) {
            echo 'Caught exception: ', $e->getMessage(), "\n";
            exit;
        }
    }

    

    public function prListHtml($type = null) {
        try {
            $conditions = array();
            if (!empty($this->request->data)) {
                if (isset($this->request->data['Employees']))
                    $this->redirect($this->request->data['Employees'], null, true);
                if (isset($this->request->data['Search'])) {
                    $searchParams = $this->Serialize->serializeData($this->data['Search']);
                    $this->redirect(array("action" => "prListHtml/edit", $searchParams));
                }
            }
            if (!empty($this->passedArgs['name'])) {
                $conditions['MyProfile.emp_firstname like'] = '%' . strtoupper($this->passedArgs['name']) . '%';
            }

            $conditions['UserDetail.emp_code !='] = 0;

            $this->paginate = array(
		'fields' => array('*','CONCAT_WS(" ",MyProfile.emp_firstname,MyProfile.emp_lastname) as emp_name'),                
		'limit' => '10',
                'order' => 'MyProfile.emp_firstname asc',
                'conditions' => $conditions,
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
            );

            $data = $this->paginate('UserDetail');
	    $this->layout = '';
            $this->set('data', $data);

            if ($type == null)
                $this->render('pr_list_html');
            elseif ($type == 'edit')
                $this->render('pr_list_html_edit');
        } catch (Exception $e) {
            
        }
    }

    function prListAssignedRoleReportHtml() {
        try {
            $conditions = array();
            if (!empty($this->request->data)) {
                $this->redirect($this->request->data['UserDetail'], null, true);
            }
            if (!empty($this->passedArgs['name'])) {
                $conditions['MyProfile.emp_firstname like'] = '%' . strtoupper($this->passedArgs['name']) . '%';
            }
	    $conditions['UserDetail.emp_code !='] = 0;


            if (!empty($this->passedArgs['application']) && $this->passedArgs['application'] != '') {
                $conditions_app['Roles.nu_application_id'] = $this->passedArgs['application'];
                $application = $this->Applications->findById($this->passedArgs['application']);
                $application_name = $application['Applications']['vc_application_name'];
            } else {
                $application = $this->Applications->find('first');
                $conditions_app['Roles.nu_application_id'] = $application['Applications']['id'];
                $application_name = $application['Applications']['vc_application_name'];
            }

            $this->paginate = array(
                'UserDetail' => array(
		    'fields' => array('*','CONCAT_WS(" ",MyProfile.emp_firstname,MyProfile.emp_lastname) as emp_name'),        
                    'limit' => '10',
                    'order' => 'MyProfile.emp_firstname asc',
                    'conditions' => $conditions,
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
                )
            );
            $data = $this->paginate('UserDetail');
            foreach ($data as &$employee) {
                $aros = $this->Aros->find('first', array(
                    'conditions' => array(
                        'Aros.foreign_key' => $employee['UserDetail']['emp_code'],
                        'Aros.model' => 'UserDetail'
                    ),
                    'fields' => array('Roles.name'),
                    'joins' => array(
                        array(
                            'table' => 'aros',
                            'alias' => 'AroParent',
                            'type' => 'inner',
                            'foreignKey' => false,
                            'conditions' => array(
                                'AroParent.id = Aros.parent_id'
                            ),
                            'fields' => array()
                        ),
                        array(
                            'table' => 'roles',
                            'alias' => 'Roles',
                            'type' => 'inner',
                            'foreignKey' => false,
                            'conditions' => array(
                        'AroParent.foreign_key = Roles.id'
                            ) + $conditions_app,
                            'fields' => array()
                        )
                    )
                ));
                if (!empty($aros))
                    $employee = $employee + $aros;
            }

            $this->layout = '';
            $this->set(compact('data', 'application_name'));
        } catch (Exception $e) {
            
        }
    }
    
      function prListAssignedRoleReportXls() {
      
        try {
           
            $conditions = array();
            if (!empty($this->request->data)) {
                $this->redirect($this->request->data['UserDetail'], null, true);
            }
            if (!empty($this->passedArgs['name'])) {
                $conditions['MyProfile.emp_firstname like'] = '%' . strtoupper($this->passedArgs['name']) . '%';
            }
           
            if (!empty($this->passedArgs['application']) && $this->passedArgs['application'] != '') {
                $conditions_app['Roles.nu_application_id'] = $this->passedArgs['application'];
                $application = $this->Applications->findById($this->passedArgs['application']);
                $application_name = $application['Applications']['vc_application_name'];
            } else {
                $application = $this->Applications->find('first');
                $conditions_app['Roles.nu_application_id'] = $application['Applications']['id'];
                $application_name = $application['Applications']['vc_application_name'];
            }
            $data = $this->UserDetail->find('all', array(
                'fields' => array('*','CONCAT_WS(" ",MyProfile.emp_firstname,MyProfile.emp_lastname) as emp_name'),        
                    'order' => 'MyProfile.emp_firstname asc',
                    'conditions' => $conditions,
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
                )
            );
            $application_names = $this->Applications->find('all', array(
                'order' => 'Applications.id ASC',
                    ));
            foreach ($data as &$employee) {
                if ($employee['UserDetail']['emp_code'] != '') {
                    $application = $this->Applications->find('all', array(
                        'fields' => array('Applications.id', 'Applications.vc_application_name', 'Roles.name', 'Aros.id'),
                        'order' => 'Applications.id ASC',
                        'recursive' => -1,
                        'joins' => array(
                            array(
                                'table' => 'roles',
                                'alias' => 'Roles',
                                'type' => 'left',
                                'foreignKey' => false,
                                'conditions' => array(
                                    'Applications.id = Roles.nu_application_id'
                                ),
                                'fields' => array()
                            ),
                            array(
                                'table' => 'aros',
                                'alias' => 'AroParent',
                                'type' => 'left',
                                'foreignKey' => false,
                                'conditions' => array(
                                    'AroParent.foreign_key = Roles.id',
                                    "AroParent.model = 'Roles'"
                                ),
                                'fields' => array()
                            ),
                            array(
                                'table' => 'aros',
                                'alias' => 'Aros',
                                'type' => 'inner',
                                'foreignKey' => false,
                                'conditions' => array(
                                    'AroParent.id = Aros.parent_id',
                                    'Aros.foreign_key = ' . $employee['UserDetail']['emp_code'],
                                ),
                                'fields' => array()
                            ),
			    
                        )
                            ));
                    $employee = $employee + array('Applications' => $application);
                }
            }
            $this->layout = '';
            $this->set(compact('data', 'application_names'));
	    header("HTTP/1.0 200 OK");
            header('Content-type: application/vnd.ms-excel; charset=utf-8');
            header("Content-Disposition: attachment; filename=\"acl_report_" . date('Y-m-d') . ".xls\";");
            header("Cache-Control: no-cache, must-revalidate");
            header("Expires: Mon, 21 Oct 2011 10:30:00 IST");
            header("Pragma: no-cache");
            
            
        } catch (Exception $e) {
           
        }
    }

   
    public function dashboard() {
        if($this->Auth->User('emp_code') == '0'){
        $this->layout = 'admin';
            } else {
        $this->layout = 'superadmin';
        }
        if (null == $this->Auth->User('emp_code')) {
            $this->redirect('login');
        }
        $myprofile_id = $this->MyProfile->find('first', array(
            'fields' => array('id', 'dept_code'),
            'conditions' => array('emp_code' => $this->Auth->User('emp_code'))
        ));
        $company_list = $this->Company->find('list',array(
                        'fields'=> array('comp_code','comp_name'),
                        'conditions' => array('status' => 1)
            )) ;
        $this->set('company_list', $company_list);
    }

}
