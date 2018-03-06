<?php

App::uses('AppController', 'Controller');

/**
 * TravelMasters Controller
 *
 * @property TravelMaster $TravelMaster
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class TravelMastersController extends AppController {

    /**
     * Components
     *
     * @var array
     */
    public $components = array('Paginator', 'Session','Common');
    var $uses = array('TravelMaster', 'UserDetail', 'Designation', 'Department',);

    /**
     * bforeFilter
     */
    public function beforeFilter() {
        parent::beforeFilter();
        $this->layout = 'employee-new';
    }

    /**
     * Components
     *
     * @var array
     */
    public $helpers = array('Js', 'Html', 'Form', 'Session');

    /**
     * index method
     *
     * @return void
     */
    public function index($val) {
        if(!empty($val))
        {
            $dt=$val;
            $this->set('pen_val',$dt);
        }
        else{
        $dt=$this->Common->findpaginateLevel('1');
    }
        $this->paginate = array(
            'fields' => array('*'),
            'limit' =>$dt
        );
        //$incometax = $this->EmpInvest->find('all',array('fields'=>array('*'),'conditions'=>array('emp_code'=>$this->Auth->User('emp_code'))));
        $incometax = $this->paginate('TravelMaster');
        $this->set('travelmasters', $incometax);
      
    }

    /**
     * view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function view($id = null) {
        if (!$this->TravelMaster->exists($id)) {
            throw new NotFoundException(__('Invalid travelmaster'));
        }
        $options = array('conditions' => array('TravelMaster.' . $this->TravelMaster->primaryKey => $id));
        $this->set('travelmaster', $this->TravelMaster->find('first', $options));
    }

    /**
     * add method
     *
     * @return void
     */
    public function add() {
        $comp_code = $this->Auth->user('comp_code');
        $deptList = $this->Department->find('list', array('fields' => array('dept_code', 'dept_name'), 'conditions' => array('comp_code' => $comp_code)));
        $this->set('deptList', $deptList);
        $dep = new Model(array('table' => 'city_group', 'ds' => 'default', 'name' => 'CityGroup'));
        $city_group = $dep->find('list', array('fields' => array('id', 'group_name')));
        $this->set('city_grp_list', $city_group);

        $desgList = $this->Designation->find('list', array('fields' => array('desg_code', 'desc'), 'conditions' => array('comp_code' => $comp_code)));
        $this->set('desgList', $desgList);
        if ($this->request->is('post')) {
            $check = $this->TravelMaster->find('first', array('conditions' => array('designation_id' => $this->request->data['designation_id'], 'department_id' => $this->request->data['department_id'], 'city_type' => $this->request->data['city_type'])));
            if (!empty($check)) {
                //$this->Session->setFlash(__('Duplicate Entry. Please, try again.'));
                $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                            <a href="#" class="uk-alert-close uk-close"></a>Duplicate Entry. Please, try again. !!!</div>');
            } else {
                $this->TravelMaster->create();
                //  print_r($this->request->data); die;
                if ($this->TravelMaster->save($this->request->data)) {
                    $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                    <a href="#" class="uk-alert-close uk-close"></a>The travelmaster has been saved !!</div>');
                    return $this->redirect(array('action' => 'index'));
                } else {
                    $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert="">
                    <a href="#" class="uk-alert-close uk-close"></a>The travelmaster could not be saved. Please, try again.</div>');
                    return $this->redirect(array('action' => 'index'));
                }
            }
        }
    }

    /**
     * edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function edit($id = null) {
        $this->TravelMaster->id = $id;
        if (!$this->TravelMaster->exists($id)) {
            throw new NotFoundException(__('Invalid travelmaster'));
        }
        $dep = new Model(array('table' => 'city_group', 'ds' => 'default', 'name' => 'CityGroup'));
        $city_group = $dep->find('list', array('fields' => array('id', 'group_name')));
        $this->set('city_grp_list', $city_group);

        if ($this->request->is(array('post', 'put'))) {
            //print_r($this->request->data);die;
            if ($this->TravelMaster->save($this->request->data)) {
                $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                    <a href="#" class="uk-alert-close uk-close"></a>The travelmaster has been saved!!</div>');
                return $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert="">
                    <a href="#" class="uk-alert-close uk-close"></a>The travelmaster could not be saved. Please, try again !!</div>');
                return $this->redirect(array('action' => 'index'));
            }
        } else {
            $options = array('conditions' => array('TravelMaster.' . $this->TravelMaster->primaryKey => $id));
            $trdata = $this->TravelMaster->find('first', $options);
            $this->set('trdata', $trdata);
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
        $this->TravelMaster->id = $id;
        if (!$this->TravelMaster->exists()) {
            throw new NotFoundException(__('Invalid travelmaster'));
        }
        // $this->request->allowMethod('post', 'delete');
        if ($this->TravelMaster->delete($this->TravelMaster->id)) {
            $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                    <a href="#" class="uk-alert-close uk-close"></a>The travelmaster has been deleted!!</div>');
        } else {
            $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                    <a href="#" class="uk-alert-close uk-close"></a>The travelmaster could not be deleted. Please, try again!!</div>');
        }
        return $this->redirect(array('action' => 'index'));
    }

    function getCity($id) {
        $this->layout = FALSE;

        $con = new Model(array('table' => 'city_master', 'ds' => 'default', 'name' => 'CityMaster'));
        $city_list = $con->find('list', array('fields' => array('id', 'city_name'), 'conditions' => array('group_id' => $id)));
        $city_list[0] = 'Others';
        $this->set('city_list', $city_list);
    }

    function getCityPrice($id, $dept, $desg) {
        
       Configure::write('debug',2);
        $this->layout = FALSE;
        $con = new Model(array('table' => 'city_master', 'ds' => 'default', 'name' => 'CityMaster'));
        $city_type = $con->find('first', array('fields' => array('id', 'group_id'), 'conditions' => array('id' => $id)));
        $get_price = $this->TravelMaster->find('first', array('conditions' => array('city_type' => $city_type['CityMaster']['group_id'], 'department_id' => $dept, 'designation_id' => $desg)));
        echo json_encode($get_price['TravelMaster']);
        die;
    }

}
