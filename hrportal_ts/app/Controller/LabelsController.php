<?php

/* 
  * Property of Eastern Software Systems Pvt. Ltd.
  * Should be modified on by a Cake PHP Professional
  *  ******************************************************************************
  *  Description of Labels_controller.php
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


class LabelsController extends AppController {

    //put your code here
    var $name = 'Label';
    var $layout = 'admin';
    public $components = array('Auth', 'Session', 'Email', 'Cookie', 'RequestHandler');
    var $uses = array('UserDetail', 'Departments', 'Company', 'Labels', 'Applications', 'LabelBlock', 'LabelPage');
    public $helpers = array('Js', 'Html', 'Form', 'Session', 'Userdetail');

    function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow();
    }

    function index() {
        $this->layout = 'admin';
        //$dept=$this->Departments->find('list',array('fields'=>array('dept_code','dept_name')));
        //echo '<pre>';print_r($dept);die;
        //$this->set('Department',$dept);
        $comp = $this->Labels->find('all');

        //echo '<pre>';print_r($dept);die;
        $this->set('Company', $comp);
    }

    function lists() {
        $q = '1=1';
        /* if(!empty($this->data)){
          $id = $this->data['Company']['id'];
          $comp_name = strtoupper($this->data['Company']['comp_name']);
          if($id != ''){
          $q .= " AND Label.id= ".$id;
          }
          if($comp_name != ''){
          $q .= " AND Label.name=".$comp_name;
          }
          } */
        //$conditions=array($q);
        $this->paginate = array(
            'limit' => 100, 'fields' => array('Labels.id', 'Labels.name'),
            'order' => array('Labels.id' => 'asc',)
        );

        $result = $this->paginate('Labels');


        /* $this->paginate = array(
          'limit' => 10,
          'conditions'=>$conditions,
          'fields'=>array('Departments.id','Departments.dept_name','Departments.dept_code','Departments.status'),
          'order' => array(
          'Departments.id' => 'asc',
          )
          );

          $result = $this->paginate('Departments'); */
        $this->set('list', $result);
    }

    function edit($id) {

        $this->autoRender = false;
        $this->layout = false;
        if (!empty($this->data)) {
            $this->request->data['Labels']['id'] = $id;
            $con = $this->Labels->find('count', array('conditions' => array('Labels.name' => $this->data['Labels']['name'])));
            if ($con > 0) {
                $st = json_encode(array('msg' => "Duplicate Entry", 'type' => 'error'));
            } else {
                /*  $this->request->data['Designations']['usr_id_mod'] = '1';
                  $this->request->data['Designations']['usr_id_mod_dt']=date('Y-m-d'); */
                if ($this->Labels->save($this->data)) {
                    $st = json_encode(array('msg' => "Data saved successfully", 'type' => 'success', 'dt' => date('d-M-Y h:i:s')));
                } else {
                    $st = json_encode(array('msg' => 'Updation not done', 'type' => 'error'));
                }
            }
            //print_r($con);die;
        } else
            $st = json_encode(array('msg' => 'Updation not done', 'type' => 'error'));
        echo $st;
        exit;
    }

    function delete($id = null) {
        $this->layout = false;
        $this->autoRender = false;
        if (!empty($id)) {
            if ($this->Labels->delete($id)) {
                $st = json_encode(array('msg' => 'Record Deleted', 'type' => 'success'));
            } else {
                $st = json_encode(array('msg' => 'Record not deleted', 'type' => 'error'));
            }
        } else
            $st = json_encode(array('msg' => 'No Record Selected', 'type' => 'error'));
        echo $st;
        exit;
    }

    function labelPage() {
        $this->layout = 'admin';
        $page = $this->LabelPage->find('all');
        $applications = $this->Applications->find('list', array(
            'fields' => array('Applications.id', 'Applications.vc_application_name')
        ));

        $this->set('applications', $applications);
        $this->set('page', $page);
        // print_r($page);die;
    }

    function pageList($id) {

        $page = $this->LabelPage->find('all', array(
            'fields' => array('*'),
            'conditions' => array('LabelPage.applications_id' => $id)
        ));

        //print_r($page);die;
        $this->set('page', $page);
        // print_r($page);die;
    }

}

?>
