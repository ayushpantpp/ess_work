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

class HolidaysController extends AppController {

    //put your code here
    var $name = 'Holiday';
    var $layout = 'admin';
    public $components = array('Auth', 'Session', 'Email', 'Cookie', 'RequestHandler','Common');
    var $uses = array('Holiday', 'OptionAttribute','myprofile','WfPaginateLvl');
    public $helpers = array('Js', 'Html', 'Form', 'Session');

    function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow();
    }

    function index() {
        $this->layout = 'admin';
        //$dept=$this->Departments->find('list',array('fields'=>array('dept_code','dept_name')));
        //echo '<pre>';print_r($dept);die;
        //$this->set('Department',$dept);
        $holiday = $this->Holiday->find('all');
        //echo '<pre>';print_r($holiday);die;
        $this->set('Holiday', $holiday);
    }

    function add() {
        if (!empty($this->data)) {
            $this->autoRender = false;
            if (!empty($this->data)) {
                $this->request->data['Holiday']['org_id'] = $this->request->data['Holiday']['org_id'];
                $this->request->data['Holiday']['holiday_date'] = date('Y-m-d', strtotime($this->request->data['Holiday']['holiday_dates']));
                $this->request->data['Holiday']['holiday_name'] = $this->request->data['Holiday']['holiday_name'];
                $this->request->data['Holiday']['op_leave'] = $this->request->data['Holiday']['op_leave'];
                $this->request->data['Holiday']['status'] = true;

                $con = $this->Holiday->find('count', array('conditions' => array('holiday_name' => $this->request->data['Holiday']['holiday_name'], 'org_id' => $this->request->data['Holiday']['org_id'], 'holiday_date' => $this->request->data['Holiday']['holiday_date'],'location_id' => $this->request->data['Holiday']['location_id'])));
                if ($con > 0) {
                    $st = json_encode(array('msg' => "Duplicate Entry", 'type' => 'error'));
                } else {
                    if ($this->Holiday->save($this->data)) {
                        $st = json_encode(array('msg' => "Data saved successfully", 'type' => 'success'));
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
            $id = $this->data['Holiday']['org_id'];
            $holiday_name = strtoupper($this->data['Holiday']['holiday_name']);
            $location_id = $this->data['Holiday']['location_id'];
            $date=$this->data['Holiday']['holiday_dates'];
            if($date!='')
            {
                 $date= date('Y-m-d', strtotime($date));
            }
            if ($id != '') {
                $q.= " Holiday.org_id= '".$id."'";
            }
            if($location_id!=''&&  $id!='')
            {
                 $q.= " AND Holiday.location_id= '".$location_id."'";
            }
            else if($location_id!=''){
                 $q.= "  Holiday.location_id='".$location_id."'";

            }
            if ($holiday_name!= '' && $location_id!='') {
                $q.= " AND Holiday.holiday_name Like'$holiday_name%'";
            }
            else if($holiday_name!='' ){
                $q.= "Holiday.holiday_name LIKE '$holiday_name%'";
            }
            if($date!='' && $id!='')
            {
               $q.= " AND Holiday.holiday_date  Like '$date%'";
            }
            else if($date!=''){
                 $q.= "Holiday.holiday_date Like '$date%'";
            }
        
        $conditions = array($q);
        $this->paginate = array(
            'limit' => 10,
            'conditions' => $conditions,
            'fields' => array('Holiday.id', 'Holiday.holiday_name', 'Holiday.holiday_date', 'Holiday.op_leave', 'Holiday.org_id','Holiday.location_id'),
            'order' => array(
                'Holiday.id' => 'Desc'
            )
        );
        $result = $this->paginate('Holiday');
        $this->set('list', $result);
            } else {
        $this->paginate = array(
            'limit' => 10,
            'conditions' => $conditions,
            'fields' => array('Holiday.id', 'Holiday.holiday_name', 'Holiday.holiday_date', 'Holiday.op_leave', 'Holiday.org_id','Holiday.location_id'),
            'order' => array(
                'Holiday.id' => 'Desc'
            )
        );
        $result = $this->paginate('Holiday');
        $this->set('list', $result);
    }
}

    function holidaylisting($val,$date) {
        $this->layout = 'employee-new';
        $auth = $this->Session->read('Auth');
        if(!empty($val)){
                $dt=$val;
                $this->set('pen_val',$dt);
            } else {
         $dt=$this->Common->findpaginateLevel('14');
        }
        $location_id=$auth['MyProfile']['location_code'];
                  $comp_code=$auth['User']['comp_code'];
        if ($date == null) {
            $date = date('Y');
        }
        $con= $this->paginate = array(
            'fields' => array('*'),
            'conditions' => array('YEAR(Holiday.holiday_date)' => $date,'Holiday.org_id'=>$comp_code,
                'Holiday.location_id'=>$location_id),
            'limit' => $dt
        );
        $Hlist = $this->paginate('Holiday');
        $this->set('location_idsel', $location_id);
        $this->set('holidaylist', $Hlist);
        $this->set('selectedDate', $date);
    }
    
    function locationlisting($loc=null) {
        $this->layout = 'employee-new';
        $comp_code = $this->Auth->user('comp_code');
        $auth = $this->Session->read('Auth');
           if ($date == null) {
            $date = '2017';
        }
        $location_id=$auth['MyProfile']['location_code'];
        if ($loc == null) {
            $loc =  $location_id;
        }
        if($date==null)
        {
            $date='2017';
        }
        if(!empty($val))
        {
          $dt=$val;
          $this->set('pen_val',$dt);
        }
        else{
            $dt=$this->Common->findpaginateLevel('14');
        }
       $con= $this->paginate = array(
            'fields' => array('*'),
            'conditions' => array('Holiday.org_id'=>$comp_code,'Holiday.location_id'=>$loc),
            'limit' => $dt
        );
        $Hlist = $this->paginate('Holiday');
        $this->set('locationlist', $Hlist);
        $this->set('selectedlocation', $loc);
    }


    function edit($id) { //echo'<pre>';print_r($this->data);
        $this->autoRender = false;
        $this->layout = false;
        if (!empty($this->data)) {
            $this->request->data['Holiday']['id'] = $id;
            $this->request->data['Holiday']['holiday_date'] = date('Y-m-d', strtotime($this->request->data['Holiday']['holiday_date']));
            $con = $this->Holiday->find('count', array('conditions' => array('Holiday.holiday_name' => $this->data['Holiday']['holiday_name'], 'holiday_date' => $this->request->data['Holiday']['holiday_date'], 'op_leave' => $this->request->data['Holiday']['op_leave'], 'id !=' => $this->request->data['Holiday']['id'])));
            if ($con > 0) {
                $st = json_encode(array('msg' => "Duplicate Entry", 'type' => 'error'));
            } else {
                if ($this->Holiday->save($this->data)) {
                    $st = json_encode(array('msg' => "Data updated successfully", 'type' => 'success', 'dt' => date('d-M-Y h:i:s')));
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
            if ($this->Holiday->delete($id)) {
                $st = json_encode(array('msg' => 'Record Deleted', 'type' => 'success'));
            } else {
                $st = json_encode(array('msg' => 'Record not deleted', 'type' => 'error'));
            }
        } else
            $st = json_encode(array('msg' => 'No Record Selected', 'type' => 'error'));
        echo $st;
        exit;
    }

    function get_location($org_id) {
        $data = $this->OptionAttribute->find('list', array('fields' => array('id', 'name'), 'conditions' => array('options_id' => 3)));
        print_r($data);
    }

}

?>
