<?php
App::uses('AppController', 'Controller');
/**
 * WfDtAppMapLvls Controller
 *
 * @property WfDtAppMapLvl $WfDtAppMapLvl
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class WfDtAppMapLvlsController extends AppController {

/**
 * Helpers
 *
 * @var array
 */
	//public $uses = array('Departments');
	public $helpers = array('Common');

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator', 'Session', 'Common');

	function beforeFilter() {
	    parent::beforeFilter();
	    $this->Auth->allow();
	    $currentUser = $this->checkUser();
	    $this->layout = 'admin';
	    $this->Paginator->settings = array(
	        'order' => array(
					'wf_app_map_lvl_id' =>'ASC',
					'wf_lvl' =>'ASC'
					),
	        'limit' => 10
	    );
	}
/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->WfDtAppMapLvl->recursive = 1;
		$this->set('wfDtAppMapLvls', $this->Paginator->paginate());

	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->WfDtAppMapLvl->exists($id)) {
			throw new NotFoundException(__('Invalid wf dt app map lvl'));
		}
		$options = array('conditions' => array('WfDtAppMapLvl.' . $this->WfDtAppMapLvl->primaryKey => $id));
		$this->set('wfDtAppMapLvl', $this->WfDtAppMapLvl->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		
		App::import('Model','Applications');
		$this->Application = new Applications();
		App::import('Model','Department');
		$this->Department = new Department();
		App::import('Model','Designation');
		$this->Designation = new Designation();

		if ($this->request->is('post')) {
			$this->WfDtAppMapLvl->create();
			if ($this->WfDtAppMapLvl->save($this->request->data)) {
				$this->Session->setFlash(__('The wf dt app map lvl has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The wf dt app map lvl could not be saved. Please, try again.'));
			}
		}
		
		//department list
			$applications = $this->Application->find('list',array(
				'fields'=> 'vc_application_name'
				));
			$this->set('applications',$applications);
			$departments = $this->Department->find('list',array(
				'fields'=> array('dept_code','dept_name')
				));
			$this->set('departments',$departments);

			$designations = $this->Designation->find('list',array(
				'fields'=> array('desg_code','desc')
				));
			$this->set('designations',$designations);


	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		$this->WfDtAppMapLvl->recursive = 0;

		App::import('Model','Applications');
		$this->Application = new Applications();
		App::import('Model','Department');
		$this->Department = new Department();
		App::import('Model','Designation');
		$this->Designation = new Designation();
		
		if (!$this->WfDtAppMapLvl->exists($id)) {
			throw new NotFoundException(__('Invalid wf dt app map lvl'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->WfDtAppMapLvl->save($this->request->data)) {
				$this->Session->setFlash(__('The wf dt app map lvl has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The wf dt app map lvl could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('WfDtAppMapLvl.' . $this->WfDtAppMapLvl->primaryKey => $id));
			
			//to assign the revoke level
			$app_level_id = $this->WfDtAppMapLvl->find('first',array(
				'conditions'=>array(
					'WfDtAppMapLvl.wf_id'=>$id
					),
				'fields'=>'wf_app_map_lvl_id'
				));
			$levels = $this->WfDtAppMapLvl->find('list',array(
				'conditions'=>array(
					'AND' => array(
							'WfDtAppMapLvl.wf_app_map_lvl_id'=>$app_level_id['WfDtAppMapLvl']['wf_app_map_lvl_id'],
							'WfDtAppMapLvl.wf_id >'=>$id
						)
					),
				'fields'=>'wf_lvl'
				));
			$this->set('levels',$levels);

			//department list
			$applications = $this->Application->find('list',array(
				'fields'=> 'vc_application_name'
				));
			$this->set('applications',$applications);
			$departments = $this->Department->find('list',array(
				'fields'=> array('dept_code','dept_name')
				));
			$this->set('departments',$departments);

			$designations = $this->Designation->find('list',array(
				'fields'=> array('desg_code','desc')
				));
			$this->set('designations',$designations);

			$this->request->data = $this->WfDtAppMapLvl->find('first', $options);
		}
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->autoRender = false;
		$this->WfDtAppMapLvl->id = $id;
		if (!$this->WfDtAppMapLvl->exists()) {
			throw new NotFoundException(__('Invalid wf dt app map lvl'));
		}
		//$this->request->allowMethod('post', 'delete');
		if ($this->WfDtAppMapLvl->delete()) {
			return 'true';
			$this->Session->setFlash(__('The wf dt app map lvl has been deleted.'));
		} else {
			$this->Session->setFlash(__('The wf dt app map lvl could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}

	function app_wise_levels($app_id) {
//to assign the revoke level
		$this->autoRender = false;
			$levels = $this->WfDtAppMapLvl->find('list',array(
				'conditions'=>array(
					'AND' => array(
							'wf_app_map_lvl_id'=>$app_id,
						)
					),
				'fields'=>'wf_lvl'
				));
			return json_encode($levels);

	}

}
