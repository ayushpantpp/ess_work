
<?php

App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');
App::uses('Folder', 'Utility');
App::uses('File', 'Utility');

class ProjectManagesController extends AppController {

    public $name = 'ProjectManages';
    public $uses = array('Documentlist', 'DocumentRequest', 'Category', 'MstCat', 'Gallerylist', 'DocumentReceiveRequestForward', 'MailOffice', 'MailOfficeAttachFiles', 'WfPaginateLvl');
    public $helpers = array('Js', 'Html', 'Form', 'Session', 'Userdetail', 'Common');
    public $components = array('Auth', 'Session', 'Email', 'Cookie', 'EmpDetail', 'Common', 'RequestHandler');
    var $paginate = array(
        'limit' => 10,
        'order' => array(
            'TaskAssign.tid' => 'asc'
        )
    );
    var $paginate1 = array(
        'limit' => 2,
        'order' => array(
            'Tasksproject.pid' => 'asc'
        )
    );

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

}
?>
 









