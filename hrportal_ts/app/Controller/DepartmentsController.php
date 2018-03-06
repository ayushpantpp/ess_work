<?php

/* 
  * Property of Eastern Software Systems Pvt. Ltd.
  * Should be modified on by a Cake PHP Professional
  *  ******************************************************************************
  *  Description of Departments_controller.php
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


class DepartmentsController extends AppController {

    //put your code here
    var $name = 'Department';
    var $layout = 'admin';
    public $components = array('Auth', 'Session', 'Email', 'Cookie', 'RequestHandler');
    var $uses = array('UserDetail', 'Department');
    public $helpers = array('Js', 'Html', 'Form', 'Session', 'Userdetail');

    function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow();
    }

    function index() {
        $this->layout = 'admin';
    }

    function add() {
        if (!empty($this->data)) {
            $this->autoRender = false;
            $add_data = array();
            if (!empty($this->data)) {
                $add_data['comp_code'] = $this->request->data['Department']['company_name']; //= $this->data['Department']['company_name'];
                $add_data['dept_code'] = strtoupper($this->request->data['Department']['dept_code']); // = $this->data['Department']['dept_code'];
                $add_data['dept_name'] = strtoupper($this->request->data['Department']['dept_name']); // = $this->data['Department']['dept_name'];
                $add_data['created'] = date('Y-m-d h:i:s');
                $add_data['modified'] = date('Y-m-d h:i:s');
                $add_data['status'] = true;

                $con = $this->Department->find('count', array('conditions' => array('dept_name' => $this->request->data['Department']['dept_name'], 'comp_code' => $this->request->data['Department']['company_name'])));
                $con1 = $this->Department->find('count', array('conditions' => array('dept_code' => $this->request->data['Department']['dept_code'], 'comp_code' => $this->request->data['Department']['company_name'])));

                if ($con > 0 || $con1 > 0) {
                    $st = json_encode(array('msg' => "Duplicate Entry", 'type' => 'error'));
                } else {
                    if ($this->Department->save($add_data)) {
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
        $q = '';

        if (!empty($this->data)) {
            $id = $this->data['Department']['company_name'];
            $dept_name = strtoupper($this->data['Department']['dept_name']);
            $dept_code = $this->data['Department']['dept_code'];
            if ($id != '') {
                $q .= "  Department.comp_code= " . $id;
            }
            if ($dept_name != ''&& $id!='') {
                $q .= " AND Department.dept_name Like '$dept_name%'";
            }
            else if($dept_name != ''){
                 $q .= "  Department.dept_name Like '$dept_name%'";
            }
             if ($dept_code != ''&& $id!='') {
                $q .= " AND Department.dept_code Like '$dept_code%'";
            }
            else if($dept_code != '' ){
 $q .= " Department.dept_code Like  '$dept_code%'";


            }
        
        $conditions = array($q);
        
        
        $this->paginate = array(
            'limit' => 10,
            'conditions' => $conditions,
            'fields' => array('Department.id', 'Department.dept_name', 'Department.dept_code', 'Department.status', 'Department.comp_code'),
            'order' => array(
                'Department.id' => 'Desc',
            )
        );

        $result = $this->paginate('Department');
        //pr($result); die;
        $this->set('list', $result);
  }  else{


        $this->paginate = array(
            'limit' => 10,
            'conditions' => $conditions,
            'fields' => array('Department.id', 'Department.dept_name', 'Department.dept_code', 'Department.status', 'Department.comp_code'),
            'order' => array(
                'Department.id' => 'Desc',
            )
        );

        $result = $this->paginate('Department');
        //pr($result); die;
        $this->set('list', $result);
    }
}
    

    function edit($id) { //echo'<pre>';print_r($this->data);die('ss');
        $this->autoRender = false;
        $this->layout = false;
        if (!empty($this->data)) {
            $this->request->data['Department']['id'] = $id;
            $con = $this->Department->find('count', array('conditions' => array('dept_name' => $this->request->data['Department']['dept_name'], 'dept_code' => $this->request->data['Department']['dept_code'])));
           /* $con1 = $this->Department->find('count', array('conditions' => array('dept_code' => $this->request->data['Department']['dept_code'], 'comp_code' => $this->request->data['Department']['comp_code'])));*/
            if ($con > 0) {
                $st = json_encode(array('msg' => "Duplicate Entry", 'type' => 'error'));
            } else {
                /*  $this->request->data['Department']['usr_id_mod'] = '1';
                  $this->request->data['Department']['usr_id_mod_dt']=date('Y-m-d'); */
                $this->request->data['Department']['dept_code'] = strtoupper($this->request->data['Department']['dept_code']);
                $this->request->data['Department']['dept_name'] = strtoupper($this->request->data['Department']['dept_name']);
                $this->request->data['Department']['id'] = strtoupper($this->request->data['Department']['id']);
                //pr($this->request->data['Department']);die;
                if ($this->Department->save($this->data)) {
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

    function delete($id = null) {
        $this->layout = false;
        $this->autoRender = false;
        if (!empty($id)) {
            if ($this->Department->delete($id)) {
                $st = json_encode(array('msg' => 'Record Deleted', 'type' => 'success'));
            } else {
                $st = json_encode(array('msg' => 'Record not deleted', 'type' => 'error'));
            }
        } else
            $st = json_encode(array('msg' => 'No Record Selected', 'type' => 'error'));
        echo $st;
        exit;
    }

}

?>
