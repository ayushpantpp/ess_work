<?php
/* 
  * Property of Eastern Software Systems Pvt. Ltd.
  * Should be modified on by a Cake PHP Professional
  *  ******************************************************************************
  *  Description of Leaves_controller.php
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

class LeaveMasterController extends AppController {
    
    //put your code here
    var $name = 'LeaveMaster';
    var $layout = 'admin';
    public $components = array('Auth', 'Session', 'Email', 'Cookie', 'RequestHandler');
    var $uses = array('LeaveMaster','Leave');
    public $helpers = array('Js', 'Html', 'Form', 'Session');

    function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow();
    }

    function index() {
        $this->layout = 'admin';
     
        $leave = $this->LeaveMaster->find('all');
        
        $this->set('LeaveMaster', $leave);
    }
 function add() {

        if (!empty($this->data)) {
          //print_r($this->data);
            $this->autoRender = false;
            if (!empty($this->data)) {

                          /* echo "<pre>";
                           print_r($this->data);
                           die('here');*/
                $this->request->data['LeaveMaster']['comp_code'] = $this->request->data['LeaveMaster']['org_id'];

                $this->request->data['LeaveMaster']['leave_type'] = $this->request->data['LeaveMaster']['type'];
                $this->request->data['LeaveMaster']['week_off'] = $this->request->data['LeaveMaster']['wo'];
                $this->request->data['LeaveMaster']['leave_code'] = $this->request->data['LeaveMaster']['leave_code'];
                $this->request->data['LeaveMaster']['max_days'] = $this->request->data['LeaveMaster']['Leavemaxdays'];
                 $this->request->data['LeaveMaster']['half_day_chk'] = $this->request->data['LeaveMaster']['halfday'];
                $this->request->data['LeaveMaster']['file_upload'] = $this->request->data['LeaveMaster']['file_upload'];
                $this->request->data['LeaveMaster']['file_upload_no'] = $this->request->data['LeaveMaster']['nfiles'];
                 $this->request->data['LeaveMaster']['details']= $this->request->data['LeaveMaster']['info'];

                $con = $this->LeaveMaster->find('count', array('conditions' => array('comp_code' => $this->request->data['LeaveMaster']['comp_code'],'LeaveMaster.leave_code' => $this->data['LeaveMaster']['leave_code'])));
                if ($con > 1) {
                    $st = json_encode(array('msg' => "Duplicate Entry", 'type' => 'error'));
                } else {
                      
                    if ($this->LeaveMaster->save($this->data)) {
                        $st = json_encode(array('msg' => "Data saved successfully", 'type' => 'success'));
                        //$this->redirect( $_SERVER['PHP_SELF']);
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
            $id = $this->data['LeaveMaster']['id'];
            $dept_name = strtoupper($this->data['LeaveMaster']['leave_type']);
            if ($id != '') {
                $q .= " AND LeaveMaster.id= " . $id;
            }
            if ($LeaveMaster_name != '') {
                $q .= " AND LeaveMaster.LeaveMaster_name=" . $LeaveMaster_name;
            }
        }
        $conditions = array($q);
        $this->paginate = array(
            'limit' => 10,
            'conditions' => $conditions,
            'fields' => array('LeaveMaster.id', 'LeaveMaster.comp_code', 'LeaveMaster.leave_type', 'LeaveMaster.week_off', 'LeaveMaster.leave_code','LeaveMaster.max_days','LeaveMaster.half_day_chk','LeaveMaster.half_day_chk','LeaveMaster.file_upload','LeaveMaster.file_upload_no','LeaveMaster.details'),
            'order' => array(
                'LeaveMaster.id' => 'desc',
            )
        );

        $result = $this->paginate('LeaveMaster');
        $this->set('list', $result);

      }

function edit($id)
{

   $this->autoRender = false;
        $this->layout = false;
        if (!empty($this->data)) {

  $data['LeaveMaster']['id'] = $id;
   $data['LeaveMaster']['leave_type'] = $this->data['LeaveMaster']['leave_type'];
   $data['LeaveMaster']['leave_code'] = $this->data['LeaveMaster']['leave_code'];
             $data['LeaveMaster']['comp_code']=$this->data['LeaveMaster']['comp_code'];
              $data['LeaveMaster']['max_days'] = $this->data['LeaveMaster']['max_days'];
             $data['LeaveMaster']['week_off']=$this->data['LeaveMaster']['week_off'];
            $data['LeaveMaster']['half_day_chk'] = $this->data['LeaveMaster']['half_day_chk'];
             $data['LeaveMaster']['file_upload']=$this->data['LeaveMaster']['file_upload'];
               $data['LeaveMaster']['file_upload_no']=$this->data['LeaveMaster']['file_upload_no'];
               $data['LeaveMaster']['details']=$this->data['LeaveMaster']['details'];
              
 //$con = $this->LeaveMaster->find('count', array('conditions' => array('LeaveMaster.leave_code' => $this->data['LeaveMaster']['leave_code'])));

            if (empty($this->data)) {
                $st = json_encode(array('msg' => "Some thing went wrong!", 'type' => 'error'));
            } else {
             
                if ($this->LeaveMaster->save($data)) {
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
            if ($this->LeaveMaster->delete($id)) {
                $st = json_encode(array('msg' => 'Record Deleted', 'type' => 'success'));
            } else {
                $st = json_encode(array('msg' => 'Record not deleted', 'type' => 'error'));
            }
        } else
            $st = json_encode(array('msg' => 'No Record Selected', 'type' => 'error'));
        echo $st;
        exit;
    }
    function getleavecode($comp_code) {

      $deptList = $this->Leave->find('list',array('fields'=>array('leave_code','leave_name'),'conditions'=>array('org_id'=>$comp_code)));
    
    echo json_encode($deptList);die;

        
    }
    }

       ?>