<?php

class CityMastersController extends AppController {

    //put your code here
    var $name = 'CityMasters';
    var $layout = 'admin';
    public $components = array('Auth', 'Session', 'Email', 'Cookie', 'RequestHandler','Common');
    var $uses = array('MstTravelVoucher','CityGroup');
    public $helpers = array('Js', 'Html', 'Form', 'Session', 'Userdetail');

    function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow();
    }

    function index() {
        $this->layout = 'admin';
    }
	
	function add(){
		if (!empty($this->data)) {
            $this->autoRender = false;
            if (!empty($this->data)) {
                
                $rec['group_name'] = $this->request->data['CityGroup']['group_name'];
                $rec['org_id'] = $this->request->data['CityGroup']['org_id'];
                $rec['status'] = true;
                $rec['created_date'] = date('Y-m-d h:i:s');
                
                $con = $this->CityGroup->find('count', array('conditions' => array('CityGroup.group_name' => $this->request->data['CityGroup']['group_name'])));
				
                if ($con > 0) {
                    $st = json_encode(array('msg' => "Duplicate Entry", 'type' => 'error'));
                } else {
                    if ($this->CityGroup->save($rec)) {
                        $st = json_encode(array('msg' => "Data saved successfully", 'type' => 'success'));
                        //  $this->redirect();
                    } else {
                        $st = json_encode(array('msg' => 'Some Error Occurred', 'type' => 'error'));
                    }
                }
                echo $st;
                exit;
            }
        }
	}
	
	function lists() {
        $q = '1=1';
        if (!empty($this->data)) {
            $id = trim($this->data['group_id']);
            $q = "CityGroup.org_id = '$id'";
        }
        $conditions = array($q);
        $this->paginate = array(
            'limit' => 10,
			'conditions' => $conditions,
            'fields' => array('CityGroup.id', 'CityGroup.group_name', 'CityGroup.status', 'CityGroup.org_id'),
            'order' => array(
                'CityGroup.id' => 'asc',
            )
        );
        $result = $this->paginate('CityGroup');
        $this->set('list', $result);
    }
	
	function delete($id = null) {
        $this->layout = false;
        $this->autoRender = false;
        if (!empty($id)) {
            if ($this->CityGroup->delete($id)) {
                $st = json_encode(array('msg' => 'Record Deleted', 'type' => 'success'));
            } else {
                $st = json_encode(array('msg' => 'Record not deleted', 'type' => 'error'));
            }
        } else
            $st = json_encode(array('msg' => 'No Record Selected', 'type' => 'error'));
        echo $st;
        exit;
    }
	
	function edit($id) {
        $this->autoRender = false;
        $this->layout = false;
        if (!empty($this->data)) {
            $this->request->data['CityGroup']['id'] = $id;
            $con = $this->CityGroup->find('count', array('conditions' => array('CityGroup.group_name' => $this->data['CityGroup']['group_name'])));
            if ($con > 0) {
                $st = json_encode(array('msg' => "Duplicate Entry", 'type' => 'error'));
            } else {
                if ($this->CityGroup->save($this->data)) {
                    $st = json_encode(array('msg' => "Data saved successfully", 'type' => 'success', 'dt' => date('d-M-Y h:i:s')));
                } else {
                    $st = json_encode(array('msg' => 'Updation not done', 'type' => 'error'));
                }
            }
        } else
            $st = json_encode(array('msg' => 'Updation not done', 'type' => 'error'));
        echo $st;
        exit;
    }
}

?>
