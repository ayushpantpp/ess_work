<?php

//ob_start();
App::uses('Controller', 'Controller');

class AppController extends Controller {

    public $uses = array('UserDetail','AdminOption');
    public $helpers = array('Js', 'Html', 'Form', 'Session', 'Time', 'Cache');
    public $components = array('Auth', 'Session', 'RequestHandler', 'Email', 'Acl');

    public function beforeFilter() {
        //$this->Auth->allow();	
        $this->Auth->loginAction = array('controller' => 'users', 'action' => 'login');
        $this->Auth->loginRedirect = array('controller' => 'users', 'action' => 'dashboard');
        $this->Auth->logoutRedirect = array('controller' => 'users', 'action' => 'login');
        $this->Auth->authError = "You are login in different browser or in different system.";
        $this->Auth->loginError = "Login failed. Invalid username or password";
        $this->Auth->authorize = 'Controller';
        $this->Auth->actionPath = 'controllers/';
        $this->Auth->autoRedirect = false;
        $adminOptions = $this->AdminOption->find('list',array(
            'fields' => array('name','value')
            ));
        if($adminOptions['username_login']) {
            $this->Auth->authenticate = array('Form' => array('userModel' => 'UserDetail', 'fields' => array('username' => 'user_name', 'password' => 'user_password')));
        }
        else {
        $this->Auth->authenticate = array('Form' => array('userModel' => 'UserDetail', 'fields' => array('username' => 'emp_code', 'password' => 'user_password'))); 
        }



        $this->set('name', $this->Session->read('Auth.MyProfile.emp_name'));
        $this->set('uuid', $this->Auth->User('id'));
        if ($this->Session->check('Config.language')) {
            Configure::write('Config.language', $this->Session->read('Config.language'));
        }

        $login = $this->check();
        if ($login == 0) {
            $this->Auth->logout();
        }

        $islogin = $this->checkUser();
        if (!$islogin) {
            $this->Auth->logout();
        }
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
        if (!isset($result)) {
            return false;
        }
        $this->loggedIn = true;
        $this->set('loggedIn', $this->loggedIn);
        return true;
    }

    /* This function checks if the given ACO can be accessed by the current user. */

    public function checkacl($aco) {
        switch ($this->Auth->User('user_type')) {
            case 'Employees':
                $current_user_id = $this->Auth->User('emp_code');
                $acl_permission = Cache::read("{$current_user_id}_{$aco}", "default");
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
                //setting Access Controlled Object (ACO) in this case is 
                //controller / action                
                $aco = $this->name . '/' . $this->action;
                //setting Access Requester Object(ARO) in this case is the current
                //user.                
                $current_user_id = $this->Auth->User('emp_code');
                //check if cache has stored the permission for the current aro 
                //and aco combination.
                $acl_permission = false;
                //$acl_permission = Cache::read("{$current_user_id}_{$aco}", "default");
                //$acl_permission = false;		
                //identical compare permission with boolean false because there 
                //are three cases / values which $acl_permission can take i.e.
                //false, true and blank. PHP takes blanks as false, so we need to 
                //specific.

                if ($acl_permission != false) {

                    //if true return true i.e. execute the requested page
                    if ((boolean) $acl_permission) {
                        return true;
                    } else {

                        //if false throw user to login page / permission denied page
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
            case 'Customers':
                //setting Access Requester Object(ARO) in this case is the current
                //user.                
                $aros = $this->Acl->Aro->find('all', array(
                    'conditions' => array(
                        'model' => 'Customers',
                        'foreign_key' => $this->Auth->User('nu_customer_code'),
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

}
