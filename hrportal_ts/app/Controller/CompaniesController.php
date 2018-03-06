<?php

/* 
  * Property of Eastern Software Systems Pvt. Ltd.
  * Should be modified on by a Cake PHP Professional
  *  ******************************************************************************
  *  Description of Companies_controller.php
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


class CompaniesController extends AppController {

    //put your code here
    var $name = 'Company';
    var $layout = 'admin';
    public $components = array('Auth', 'Session', 'Email', 'Cookie', 'RequestHandler');
    var $uses = array('UserDetail', 'Departments', 'Company', 'MstOrg','MstCat','Location');
    public $helpers = array('Js', 'Html', 'Form', 'Session', 'Userdetail');

    function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow();
        $currentUser = $this->checkUser();
    }

    function index() {
        //Configure::write('debug',2);
        $this->layout = 'admin';
        $ho_comp = $this->MstOrg->find('list', array('fields' => array('id', 'org_id')));
        $this->set('ho_org', $ho_comp);
        $comp = $this->Company->find('all');
        $this->set('Company', $comp);
    }

    function add() {
		
        if (!empty($this->data)) {
            $this->autoRender = false;
            if (!empty($this->data)) {
                $this->request->data['Company']['comp_code'] = $this->request->data['Company']['comp_code'];
                $this->request->data['Company']['comp_name'] = $this->request->data['Company']['comp_name'];
                $this->request->data['Company']['status'] = true;
                $this->request->data['Company']['mst_org_id'] = $this->request->data['Company']['org_id'];
                $this->request->data['Company']['org_alias'] = $this->request->data['Company']['comp_alias'];
                ;
                $this->request->data['Company']['cld_id'] = '';
                $this->request->data['Company']['org_id'] = $this->request->data['Company']['comp_code'];
                $this->request->data['Company']['ho_org_id'] = $this->request->data['Company']['org_id'];
                $this->request->data['Company']['created_at'] = date('Y-m-d');
                //echo "<pre>"; print_r($this->data); die;
                $con = $this->Company->find('count', array('conditions' => array('comp_name' => $this->request->data['Company']['comp_name'])));
                $con1 = $this->Company->find('count', array('conditions' => array('comp_code' => $this->request->data['Company']['comp_code'])));
                if ($con > 0 || $con1 > 0) {
                    $st = json_encode(array('msg' => "Duplicate Entry", 'type' => 'error'));
                } else {
                    if ($this->Company->save($this->data)) {
                        $st = json_encode(array('msg' => "Data saved successfully", 'type' => 'success'));
                        //$this->redirect('index');
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
            $id = $this->data['Company']['id'];
            $dept_name = strtoupper($this->data['Company']['comp_name']);
            if ($id != '') {
                $q .= " AND Company.id= " . $id;
            }
            if ($comp_name != '') {
                $q .= " AND Company.comp_name=" . $comp_name;
            }
        }
        $conditions = array($q);
        $this->paginate = array(
            'limit' => 10,
            'conditions' => $conditions,
            'fields' => array('Company.id', 'Company.comp_name', 'Company.comp_code'),
            'order' => array('Company.id' => 'Desc',));

        $result = $this->paginate('Company');
        $this->set('list', $result);
    }

    function edit($id) {
        $this->autoRender = false;
        $this->layout = false;

        if (!empty($this->data)) {
            $this->request->data['Company']['id'] = $id;
            $con = $this->Company->find('count', array('conditions' => array('Company.comp_name' => $this->data['Company']['comp_name'], 'comp_code' => $this->request->data['Company']['comp_code'])));
            if ($con > 0) {
                $st = json_encode(array('msg' => "Duplicate Entry", 'type' => 'error'));
            } else {
                if ($this->Company->save($this->data)) {
                    $st = json_encode(array('msg' => "Data Saved Successfully", 'type' => 'success', 'dt' => date('d-M-Y h:i:s')));
                } else {
                    $st = json_encode(array('msg' => 'Updation Not Done', 'type' => 'error'));
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
            if ($this->Company->delete($id)) {
                $st = json_encode(array('msg' => 'Record Deleted', 'type' => 'success'));
            } else {
                $st = json_encode(array('msg' => 'Record not deleted', 'type' => 'error'));
            }
        } else
            $st = json_encode(array('msg' => 'No Record Selected', 'type' => 'error'));
        echo $st;
        exit;
    }
    function delete_cat($id = null) {
        $this->layout = false;
        $this->autoRender = false;
        if (!empty($id)) {
            if ($this->MstCat->delete($id)) {
                $st = json_encode(array('msg' => 'Record Deleted', 'type' => 'success'));
            } else {
                $st = json_encode(array('msg' => 'Record not deleted', 'type' => 'error'));
            }
        } else
            $st = json_encode(array('msg' => 'No Record Selected', 'type' => 'error'));
        echo $st;
        exit;
    }
    function delete_loc($id = null) {
        $this->layout = false;
        $this->autoRender = false;
        if (!empty($id)) {
            if ($this->Location->delete($id)) {
                $st = json_encode(array('msg' => 'Record Deleted', 'type' => 'success'));
            } else {
                $st = json_encode(array('msg' => 'Record not deleted', 'type' => 'error'));
            }
        } else
            $st = json_encode(array('msg' => 'No Record Selected', 'type' => 'error'));
        echo $st;
        exit;
    }

    function index_ho() {
        //Configure::write('debug',2);
        $this->layout = 'admin';
        $comp = $this->MstOrg->find('all');
        $this->set('Company', $comp);
    }
 
    function add_ho() {
        Configure::write('debug', 2);
        if (!empty($this->data)) {
            $this->autoRender = false;
            if (!empty($this->data)) {
                $data['org_name'] = $this->request->data['Company']['org_name'];
                ;
                $data['org_alias'] = $this->request->data['Company']['org_alias'];
                $data['org_id'] = $this->request->data['Company']['org_id'];
                $data['created_at'] = date('Y-m-d');
                $data['org_cld_id'] = 0000;
                $data['org_type'] = '';
                $data['status'] = 1;
                $con = $this->MstOrg->find('count', array('conditions' => array('org_name' => $this->request->data['Company']['org_name'])));
                $con1 = $this->MstOrg->find('count', array('conditions' => array('org_id' => $this->request->data['Company']['org_id'])));
                if ($con > 0 || $con1 > 0) {
                    $st = json_encode(array('msg' => "Duplicate Entry", 'type' => 'error'));
                } else {
                    if ($this->MstOrg->save($data)) {
                        $this->request->data['Company']['comp_code'] = $this->request->data['Company']['org_id'];
                        $this->request->data['Company']['comp_name'] = $this->request->data['Company']['org_name'];
                        $this->request->data['Company']['status'] = true;
                        $this->request->data['Company']['mst_org_id'] = $this->MstOrg->getLastInsertID();
                        $this->request->data['Company']['org_alias'] = $this->request->data['Company']['org_alias'];
                        $this->request->data['Company']['cld_id'] = '';
                        $this->request->data['Company']['org_id'] = $this->request->data['Company']['org_id'];
                        $this->request->data['Company']['ho_org_id'] = $this->request->data['Company']['org_id'];
                        $this->request->data['Company']['created_at'] = date('Y-m-d');
                        $this->Company->save($this->data);
                        $st = json_encode(array('msg' => "Data saved successfully", 'type' => 'success'));
                        //$this->redirect('index');
                    } else {
                        $st = json_encode(array('msg' => 'Some Error Occurred', 'type' => 'error'));
                    }
                }
                echo $st;
                exit;
            }
        }
    }
function index_catagory() {
   // Configure::write('debug',2);
        $this->layout = 'admin';
        $comp = $this->MstCat->find('all');
        $this->set('MstCat', $comp);
    }
    function index_location() {
   // Configure::write('debug',2);
        $this->layout = 'admin';
        //$comp = $this->MstCat->find('all');
        $this->set('MstCat');
    }
     function cat_lists() {
        //Configure::write('debug',2);
        $q = '1=1';
        if (!empty($this->data)) {
            $id = $this->data['MstCat']['id'];
            $dept_name = strtoupper($this->data['MstCat']['comp_name']);
            if ($id != '') {
                $q .= " AND MstCat.id= " . $id;
            }
            if ($comp_name != '') {
                $q .= " AND MstCat.comp_name=" . $comp_name;
            }
        }
        $conditions = array($q);
        $this->paginate = array(
            'limit' => 10,
            'conditions' => $conditions,
            'fields' => array('*'),
            'order' => array('MstCat.id' => 'asc',));

        $result = $this->paginate('MstCat');
        $this->set('list', $result);
    }
     function add_cat() {
       // Configure::write('debug', 1);
//echo"<pre>";print_r($this->data);die;
        if (!empty($this->data)) {
            $this->autoRender = false;
            if (!empty($this->data)) {
   
                $data['org_id'] = $this->request->data['Company']['org_id'];
                 $data['catagory_desc'] = $this->request->data['Company']['cat_desc'];
				   $data['is_gallery'] = $this->request->data['Company']['cat_gallery'];
                $data['created_date'] = date('Y-m-d');
              $con = $this->MstCat->find('count', array('conditions' => array('org_id' => $this->request->data['Company']['catagory_desc'])));
               // $con1 = $this->MstOrg->find('count', array('conditions' => array('org_id' => $this->request->data['Company']['org_id'])));
                if ($con > 0 ) {
                    $st = json_encode(array('msg' => "Duplicate Entry", 'type' => 'error'));
                } else {
                    if ($this->MstCat->save($data)) {
                       $this->request->data['MstCat']['org_id'] = $this->request->data['Company']['org_id'];
                        $this->request->data['MstCat']['catagory_desc'] = $this->request->data['Company']['cat_desc'];
						$this->request->data['MstCat']['cat_gallery'] = $this->request->data['Company']['is_gallery'];
                        $this->request->data['MstCat']['created_date'] = date('Y-m-d');
                        $this->MstCat->save($this->data);
                        $st = json_encode(array('msg' => "Data saved successfully", 'type' => 'success'));
                        //$this->redirect('index');
                    } else {
                        $st = json_encode(array('msg' => 'Some Error Occurred', 'type' => 'error'));
                    }
                }
                echo $st;
                exit;
            }
        }
    }

    function add_location() {
        //print_r($this->data);die;
        //Configure::write('debug',2);
        //echo $comp_code = $_SESSION['Auth']['MyProfile']['comp_code'];die;
        if (!empty($this->data)) {
            $this->autoRender = false;
            if (!empty($this->data)) {
                $data['Location']['comp_code'] ='01';
                $data['Location']['org_id'] = '01';
                $data['Location']['status'] = true;
                $data['Location']['latitude'] = $this->request->data['Location']['Latitude'];
                $data['Location']['longitude'] = $this->request->data['Location']['Longitude'];
                $data['Location']['in_radius'] = $this->request->data['Location']['Radius'];
                $data['Location']['location_code'] = $this->request->data['Location']['orgName'];
               $data['Location']['created_date'] = date('Y-m-d');
				 $con = $this->Location->find('count', array('conditions' => array('longitude' => $this->request->data['Location']['Longitude'],'latitude'=>$this->request->data['Location']['Latitude'],'location_code'=>$this->request->data['Location']['orgName'])));
				 
				  if ($con > 0 ) {
                    $st = json_encode(array('msg' => "Duplicate Entry", 'type' => 'error'));
                } 
				else{
                if ($this->Location->save($data)) {
				
                      $st = json_encode(array('msg' => "Data saved successfully", 'type' => 'success'));
			
				}}
                echo $st;
				
                exit;
            
        }
    }
}
	

    function lists_ho() {
        
        $q = '1=1';
        if (!empty($this->data)) {
            $id = $this->data['MstOrg']['id'];
            $dept_name = strtoupper($this->data['MstOrg']['comp_name']);
            if ($id != '') {
                $q .= " AND MstOrg.id= " . $id;
            }
            if ($comp_name != '') {
                $q .= " AND MstOrg.comp_name=" . $comp_name;
            }
        }
        $conditions = array($q);
        $this->paginate = array(
            'limit' => 10,
            'conditions' => $conditions,
            'fields' => array('*'),
            'order' => array('MstOrg.id' => 'asc',));

        $result = $this->paginate('MstOrg');
        $this->set('list', $result);
    }

    function edit_ho($id) {
        Configure::write('debug', 2);
        $this->autoRender = false;
        $this->layout = false;
        if (!empty($this->data)) {
            $this->request->data['MstOrg']['id'] = $id;
            $con = $this->MstOrg->find('count', array('conditions' => array('MstOrg.org_name' => $this->data['Company']['org_name'], 'MstOrg.org_id' => $this->request->data['Company']['org_id'])));
            if ($con > 0) {
                $st = json_encode(array('msg' => "Duplicate Entry", 'type' => 'error'));
            } else {
                if ($this->MstOrg->save($this->data)) {
                    $st = json_encode(array('msg' => "Data Saved Successfully", 'type' => 'success', 'dt' => date('d-M-Y h:i:s')));
                } else {
                    $st = json_encode(array('msg' => 'Updation Not Done', 'type' => 'error'));
                }
            }
            //print_r($con);die;
        } else
            $st = json_encode(array('msg' => 'Updation not done', 'type' => 'error'));
        echo $st;
        exit;
    }

    function delete_ho($id = null) {
        $this->layout = false;
        $this->autoRender = false;
        if (!empty($id)) {
            if ($this->MstOrg->delete($id)) {
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
