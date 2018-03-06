
<?php

App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');
App::uses('Folder', 'Utility');
App::uses('File', 'Utility');

class ProjectManageController extends AppController {

    public $name = 'ProjectManage';
    public $uses = array('Documentlist', 'DocumentRequest', 'Category', 'MstCat', 'Gallerylist', 'DocumentReceiveRequestForward', 'MailOffice', 'MailOfficeAttachFiles', 'WfPaginateLvl');
    public $helpers = array('Js', 'Html', 'Form', 'Session', 'Userdetail', 'Common');
    public $components = array('Auth', 'Session', 'Email', 'Cookie', 'EmpDetail', 'Common', 'RequestHandler');
    
    public function beforeFilter() {

        parent::beforeFilter();
        $this->Auth->allow();
//        $currentUser = $this->checkUser();
    }
	
	public function index() {
        $this->layout = 'employee-new';
    }
	
	public function add_project() {
        $this->layout = 'employee-new';
    }
	public function project_information() {
		//Configure::write('debug',2);
        $this->layout = 'employee-new';
    }
	public function time_line() {
		//Configure::write('debug',2);
        $this->layout = 'employee-new';
    }
	public function issue_tracking() {
		//Configure::write('debug',2);
        $this->layout = 'employee-new';
    }
	public function delivery_commitment() {
		//Configure::write('debug',2);
        $this->layout = 'employee-new';
    }
	public function risk_category() {
		//Configure::write('debug',2);
        $this->layout = 'employee-new';
    }
	public function manage_resource() {
		//Configure::write('debug',2);
        $this->layout = 'employee-new';
    }
	public function license_information() {
		//Configure::write('debug',2);
        $this->layout = 'employee-new';
    }
	public function quality_summary() {
		//Configure::write('debug',2);
        $this->layout = 'employee-new';
    }
	public function hardware_information() {
		//Configure::write('debug',2);
        $this->layout = 'employee-new';
    }
	public function other_information() {
		//Configure::write('debug',2);
        $this->layout = 'employee-new';
    }
	
	}
?>










