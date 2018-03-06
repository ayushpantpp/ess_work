<?php

App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');
App::import('uploader');

class MdaController extends AppController {

    public $name = 'Mda';
    public $uses = array('MstMda');
    public $helpers = array('Js', 'Html', 'Form', 'Session', 'Userdetail', 'Common');
    public $components = array('Auth', 'Session', 'Email', 'Cookie', 'EmpDetail', 'Common', 'RequestHandler',);

/*    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('Mda_details', 'user_name', 'reset');
        $currentUser = $this->checkUser();
    }*/

    public function index() {
        $this->layout = 'default';
        if ($this->loggedIn) {
            $this->redirect(array('controller' => 'Mda', 'action' => 'dashboard'));
        } else { 
            $this->redirect(array('controller' => 'Mda', 'action' => 'login'));
        }
    }


   

  
}