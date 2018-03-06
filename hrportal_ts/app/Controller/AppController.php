<?php

/*
 * Property of Eastern Software Systems Pvt. Ltd.
 * Should be modified on by a Cake PHP Professional
 *  ******************************************************************************
 *  Description of App_controller.php
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


App::uses('Controller', 'Controller');
App::uses('CakeEmail', 'Network/Email');

class AppController extends Controller {

    public $uses = array('UserDetail', 'AdminOption', 'LeaveConfiguration');
    public $helpers = array('Js', 'Html', 'Form', 'Session', 'Time', 'Cache', 'Notify');
    public $components = array('Auth', 'Session', 'RequestHandler', 'Email', 'Acl','Common');

    public function beforeFilter() {
        $this->Auth->loginAction = array('controller' => 'users', 'action' => 'login');
        $this->Auth->loginRedirect = array('controller' => 'users', 'action' => 'dashboard');
        $this->Auth->logoutRedirect = array('controller' => 'users', 'action' => 'login');
        $this->Auth->authError = "You are login in different browser or in different system.";
        $this->Auth->loginError = "Login failed. Invalid username or password";

        $this->Auth->allow(array('integration_update_cron'));

        $this->lwp_leave_code = $this->LeaveConfiguration->find('first', array('fields' => array('leave_code'), 'conditions' => array('leave_type' => 'LWP')));
        $this->ml_leave_code = $this->LeaveConfiguration->find('first', array('fields' => array('leave_code'), 'conditions' => array('leave_type' => 'ML')));
        $this->cl_leave_code = $this->LeaveConfiguration->find('first', array('fields' => array('leave_code'), 'conditions' => array('leave_type' => 'CL')));
        $this->el_leave_code = $this->LeaveConfiguration->find('first', array('fields' => array('leave_code'), 'conditions' => array('leave_type' => 'EL')));
        $this->sl_leave_code = $this->LeaveConfiguration->find('first', array('fields' => array('leave_code'), 'conditions' => array('leave_type' => 'SL')));
        if (isset($this->request->data['UserDetail']['admin_login']) == 'admin_login') {
            $this->Auth->authenticate = array('Form' =>
                array('userModel' => 'UserDetail',
                    'fields' => array('username' => 'user_name', 'password' => 'user_password', 'comp_code' => 'comp_code')));
        } else {
            $adminOptions = $this->AdminOption->find('list', array(
                'fields' => array('name', 'value')
            ));
            if ($adminOptions['username_login']) {
                $this->Auth->authenticate = array('Form' =>
                    array('userModel' => 'UserDetail',
                        'fields' => array('username' => 'user_name', 'password' => 'user_password', 'comp_code' => 'comp_code'),
                        'scope' => array('comp_code' => $this->request->data['UserDetail']['comp_code'])));
            } else {
                $this->Auth->authenticate = array('Form' =>
                    array('userModel' => 'UserDetail',
                        'fields' => array('username' => 'emp_id', 'password' => 'user_password', 'comp_code' => 'comp_code')
                        , 'scope' => array('comp_code' => $this->request->data['UserDetail']['comp_code'])));
            }
        }

        $this->set('name', $this->Session->read('Auth.MyProfile.emp_name'));
        $this->set('uuid', $this->Auth->User('id'));
        if ($this->Session->check('Config.language')) {
            Configure::write('Config.language', $this->Session->read('Config.language'));
        }
    }

    public function beforeRender() {
        $this->response->disableCache();
    }

    public function check() {

        $login = $this->UserDetail->find('count', array(
            'conditions' => array('UserDetail.id' => $this->Auth->user('id'),
                'UserDetail.session_id' => $this->Session->id()
            )
        ));
        return $login;
    }

    protected function checkUser() {
        $result = $this->Auth->User('id');
        if (!isset($result) && $this->params['action'] != 'login' && $this->params['action'] != 'forgetpwd' && $this->params['action'] != 'reset') {
            $this->redirect($this->Auth->logout());
        }
        $this->loggedIn = true;
        $this->set('loggedIn', $this->loggedIn);
        return true;
    }

    public function checkacl($aco) {
        switch ($this->Auth->User('user_type')) {
            case 'Employees':
                $current_user_id = $this->Auth->User('emp_code');
                $acl_permission = Cache::read("{$current_user_id}_{$aco}", "default");
                print_r($acl_permission);
                die;
                if ($acl_permission !== false) {
                    return (boolean) $acl_permission;
                }
                $aros = $this->Acl->Aro->find('all', array(
                    'conditions' => array(
                        'model' => 'UserDetail',
                        'foreign_key' => $current_user_id,
                    ),
                ));
                break;
        }
        foreach ($aros as $aro) {
            if ($this->Acl->check($aro['Aro'], $aco)) {
                //set cache value if to the newly obtained result.
                Cache::write("{$current_user_id}_{$aco}", "1", "default");
                return true;
            }
        }
        Cache::write("{$current_user_id}_{$aco}", "0", "default");
        return false;
    }

    /**
     * This function is executed before calling any action of any controller.
     * The fate of the execution of the controller/action is decided here. 
     * The Acl fucntion check is used to check the authorization of the user
     * to access the page.
     */
    function isAuthorized() {
        switch ($this->Auth->User('user_type')) {
            case 'Administrator':
                //setting Access Controlled Object (ACO) in this case is 
                //controller / action
                $aco = $this->name . '/' . $this->action;
                //setting Access Requester Object(ARO) in this case is the current
                //user.
                $current_user_id = 0;
                $aros = $this->Acl->Aro->find('all', array(
                    'conditions' => array(
                        'model' => 'UserDetail',
                        'foreign_key' => $current_user_id,
                    ),
                ));
                break;
            case 'Employees':
                $aco = $this->name . '/' . $this->action;
                //setting Access Requester Object(ARO) in this case is the current
                //user.                
                $current_user_id = $this->Auth->User('emp_code');
                //check if cache has stored the permission for the current aro 
                //and aco combination.
                $acl_permission = false;
                if ($acl_permission != false) {
                    die('hetrete');
                    if ((boolean) $acl_permission) {
                        return true;
                    } else {
                        if (!$this->isLoggedIn($this->Auth->User('user_type'))) {
                            $this->redirect($this->Auth->logoutRedirect);
                        } else {

                            if ($this->RequestHandler->isAjax()) {
                                $response->status = 0;
                                $response->message = "Permission denied.";
                                $this->layout = '';
                                $this->autoRender = '';
                                header("HTTP/1.0 200 OK");
                                header('Content-type: text/json; charset=utf-8');
                                header("Cache-Control: no-cache, must-revalidate");
                                header("Expires: Mon, 21 Oct 2011 10:30:00 IST");
                                header("Pragma: no-cache");
                                echo json_encode($response);
                                die;
                            } else {
                                $this->redirect("/users/login");
                            }
                        }
                    }
                }
                //Couldnt find cache value. Damn! this is gonna be slowww.
                //setting Access Requester Object(ARO) in this case is the current
                //user.
                $aros = $this->Acl->Aro->find('all', array(
                    'conditions' => array(
                        'model' => 'UserDetail',
                        'foreign_key' => $current_user_id,
                    ),
                ));

                break;
        }
        //pr($aros); die;
        //Now checking whether any of the AROs have access to the current ACO
        foreach ($aros as $aro) {
            if ($this->Acl->check($aro['Aro'], $this->name . '/' . $this->action)) {
                Cache::write("{$current_user_id}_{$aco}", "1", "default");
                return true;
            }
        }
        //Checking if the user is logged in
        if (!$this->isLoggedIn($this->Auth->User('user_type'))) {
            $this->redirect($this->Auth->logoutRedirect);
        } else {
            //User is logged in
            //Checking is this is an Ajax request: based on it a respose / redirection
            //will be given.
            if ($this->RequestHandler->isAjax()) {
                Cache::write("{$current_user_id}_{$aco}", "0", "default");
                $response->status = 0;
                $response->message = "Permission denied.";
                $this->layout = '';
                $this->autoRender = '';
                header("HTTP/1.0 200 OK");
                header('Content-type: text/json; charset=utf-8');
                header("Cache-Control: no-cache, must-revalidate");
                header("Expires: Mon, 21 Oct 2011 10:30:00 IST");
                header("Pragma: no-cache");
                echo json_encode($response);
                die;
            } else {
                Cache::write("{$current_user_id}_{$aco}", "0", "default");
                $this->redirect("/users/dashboard");
            }
        }
        return false;
    }

    public function isLoggedIn($userType = 'Employees') {
        /**
         * **********************************************************************
         * Checks if user of type ->$userType is logged in or not.
         * **********************************************************************
         */
        switch ($userType) {
            case 'Employees':
                return ($this->Auth->User('id') && $this->Auth->User('user_type') == 'Employees');
                break;
            case 'Administrator':
                return ($this->Auth->User('id') == '' && $this->Auth->User('user_type') == 'Administrator');
                break;
            default:
                return false;
                break;
        }
    }
    
    
    public function sendApplicantsMail($data) {// use org_id, application_id,event_id,to_name,to_email,from_name,from_email,subject
//        Configure::write('debug',2);
            try {
                $mail_data = $this->Common->getMailData($data['org_id'],$data['application_id'],$data['event_id']);
                if($mail_data['status'] == false)
                    throw new Exception($mail_data['messsage']);
                
                if(isset($data['to_email']) && empty($data['to_email']))
                    throw new Exception ('To Email Required');
                
                if(isset($data['from_email']) && empty($data['from_email']))
                    throw new Exception ('From Email Required');
                
                $mail_data['mail_body'] = htmlspecialchars_decode($mail_data['mail_body']);
                $mail_data['mail_tags'] = json_decode($mail_data['mail_tags']);
                $data = array_merge($mail_data,$data);
                unset($data['mail_tags']);
                
                foreach($mail_data['mail_tags'] as $tag){
                    if(!array_key_exists(trim($tag), $data))
                            throw new Exception ("Short Tag ".$tag." not found");
                }
                
                $template = $mail_data['mail_body'];
                foreach($data as $key => $value){
                    $template = str_replace('{'.$key.'}', $value, $template);
                }
                $template =  html_entity_decode($template);
                $status = $this->send_mail($data['to_email'],$data['from_email'],$data['to_email'],$data['subject'],'','default',$template);
                if($status)
                    throw new Exception($status);
                return ['status'=>true, 'message' => 'Mail Sent successfully'];
            } catch (Exception $ex) {
                return ['status'=>false, 'message' => $ex->getMessage()];
            }
        }
    
    /*public function sendApplicantsMail($data) {
        try {
            $mail_data = $this->Common->getMailData($data['org_id'],$data['application_id'],$data['event_id']);
            if($mail_data['status'] == false)
                throw new Exception($mail_data['messsage']);
            
            if(isset($data['approver_email']) && empty($data['approver_email']))
                    throw new Exception ('Approver Email Required');
            
            if(isset($data['approver_name']) && empty($data['approver_name']))
                    throw new Exception ('Approver Name Required');
            
            if(isset($data['sender_name']) && empty($data['sender_name']))
                    throw new Exception ('Sender Name Required');
            
            if(isset($data['sender_email']) && empty($data['sender_email']))
                    throw new Exception ('Sender Email Required');
            
            if(isset($data['template']) && empty($data['template']))
                    throw new Exception ('Empty template given');
            
            if(isset($data['subject']) && empty($data['subject']))
                    throw new Exception ('Subject empty');
            $mail_data =     array_merge($mail_data,$data);
            
            $status = $this->send_mail($data['sender_email'],$data['approver_email'],$data['sender_email'],$data['subject'],'',$data['template'],$mail_data);
            if($status)
                throw new Exception($status);
            return ['status' => true, 'message' =>  'mail sent successfully'];
        } catch (Exception $ex) {
            return ['status' => false, 'message' =>  $ex->getMessage()];
        }
    }*/

    
    public function send_mail($From = null, $TO = null, $CC = null, $Subject = null, $Message = null, $Template = null, $data = null) {
        //Configure::write('debug',2);
         $this->Email->smtpOptions = array(
            'port'=>'465',
				'timeout'=>'120',
				'host' => 'ssl://smtpcorp.netcore.co.in',
				'username'=>'ess-portal@essindia.com',
				'password'=>'Ess1234$'
          ); 
        /*$this->Email->smtpOptions = array('port' => '587',
            'timeout' => '120',
            'host' => 'smtp.office365.com',
            'username' => 'surenderg@stlfasteners.com',
            'password' => 'Sterling123',
            'tls' => true);*/
        $this->Email->template = $Template;
        $this->Email->from = $From;
        $this->Email->to = $TO;
        $this->Email->cc = $CC;
        $this->Email->subject = $Subject;
        $this->Email->viewVars = array($data, $Message);
        $this->Email->sendAs = 'html';
        $this->set('message', $Message);
        $this->set('data', $data);
        $this->Email->delivery = 'smtp';
        ini_set('memory_limit', '-1');
        ini_set('max_execution_time', 200);
        try {
//            $n = $this->Email->send();
//            $n = 1;
            if(!$this->Email->send())
                throw new Exception ('Email sending failed');
            return false;
        } catch (Exception $e) {
            return $ex->getMessage();
//            echo $this->Email->smtpError;
//            echo 'cannt sent';
        }
//        if ($n) {
//            echo "Email sent successfully";
//            return 1;
//        } else {
//            echo $this->Email->smtpError;
//            echo "Error in email sending......";
//            return 0;
//        }


        ///////////////Email END///////
    }

}
