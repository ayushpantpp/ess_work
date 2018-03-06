<?php
/* 
  * Property of Eastern Software Systems Pvt. Ltd.
  * Should be modified on by a Cake PHP Professional
  *  ******************************************************************************
  *  Description of WeekHolidays_controller.php
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
  *  project version: 0.1.0
  *  @author Ayush Pant <ayush.pant@essindia.com>
  *  @client company: Eastern Software Systems Pvt. Ltd. Expression project.user is undefined on line 21, column 73 in Templates/Licenses/license-default.txt.
  *  @date created: 2017
  *  @date last modified: Jun 28, 2011 2:59:31 PM
  *  ******************************************************************************
 */

class WeekHolidaysController extends AppController {

    //put your code here
    var $name = 'WeekHoliday';
    var $layout = 'admin';
    public $components = array('Auth', 'Session', 'Email', 'Cookie', 'RequestHandler','Common');
    var $uses = array('WeekHoliday', 'WeekHolidayList');
    public $helpers = array('Js', 'Html', 'Form', 'Session','Common');

    function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow();
    }

    function index() {
		
        $this->layout = 'admin';
        $holiday = $this->WeekHoliday->find('all');
		
        $weekdays = array('Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday');
        $this->set('WeekHoliday', $holiday);
        $this->set('weekdays', $weekdays);
    }

    function add() {
		
        if (!empty($this->data)) {
        	
            $this->autoRender = false;
            if (!empty($this->data)) {
				
                $num = array($this->data['WeekHoliday']['first'], $this->data['WeekHoliday']['second'], $this->data['WeekHoliday']['third'], $this->data['WeekHoliday']['fourth'], $this->data['WeekHoliday']['fifth']);
                $data['WeekHoliday']['numbers'] = serialize($num);
                $data['WeekHoliday']['day_code'] = $this->data['WeekHoliday']['day_code'];
                $data['WeekHoliday']['emp_group'] = $this->data['WeekHoliday']['emp_group'];
                $data['WeekHoliday']['ho_org_id'] = $this->Common->getHO($this->request->data['WeekHoliday']['org_id']);
                $data['WeekHoliday']['org_id'] = $this->request->data['WeekHoliday']['org_id'];

                $con = $this->WeekHoliday->find('count', array('conditions' => 
                    array('day_code' => $this->request->data['WeekHoliday']['day_code'],
                        'emp_group' => $this->request->data['WeekHoliday']['emp_group'])));
                $this->add_weekHolidayList($data['WeekHoliday']['day_code'], $num,$this->request->data['WeekHoliday']['emp_group']);
				
                if ($con > 0) {
					
                    $st = json_encode(array('msg' => "Duplicate Entry", 'type' => 'error'));
                } else {
					
                    if ($this->WeekHoliday->save($data)) {
				
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
        $q = '1=1';
        if (!empty($this->data)) {
            $id = $this->data['WeekHoliday']['id'];
            if ($id != '') {
                $q .= " AND WeekHoliday.id= " . $id;
            }
            if ($day_code != '') {
                $q .= " AND WeekHoliday.day_code=" . $day_code;
            }
        }
        $conditions = array($q);
        $this->paginate = array(
            'limit' => 10,
            'conditions' => $conditions,
            'fields' => array('WeekHoliday.id', 'WeekHoliday.day_code','WeekHoliday.emp_group' ,'WeekHoliday.numbers'),
            'order' => array(
                'WeekHoliday.id' => 'asc',
            )
        );

        $result = $this->paginate('WeekHoliday');
        $this->set('list', $result);
    }

    function delete($id = null) {
        $this->layout = false;
        $this->autoRender = false;
        if (!empty($id)) {
            $this->delete_weekHolidayList($id);
            if ($this->WeekHoliday->delete($id)) {
                $st = json_encode(array('msg' => 'Record Deleted', 'type' => 'success'));
            } else {
                $st = json_encode(array('msg' => 'Record not deleted', 'type' => 'error'));
            }
        } else
            $st = json_encode(array('msg' => 'No Record Selected', 'type' => 'error'));
        echo $st;
        exit;
    }

    function add_weekHolidayList($day_code, $num, $group_code) {

        // Array of the Month's
        $month_array = array("jan", "Feb", "Mar", "Apr", "May", "Jun", "july", 'Aug', "Sep", "Oct", "Nov", "Dec");
        //$month_array=array("Oct");
        $dowMap = array('sun', 'mon', 'tue', 'wed', 'thu', 'fri', 'sat');

        // Array of the Years's
        $year_array = array("2018","2019");

        foreach ($num as $key => $value) {
            # code...
            $which = '';
            if ($value == 1) {
                switch ($key) {
                    case 0: $which = 'first';
                        break;
                    case 1: $which = 'second';
                        break;
                    case 2: $which = 'third';
                        break;
                    case 3: $which = 'fourth';
                        break;
                    case 4: $which = 'fifth';
                        break;

                    default:
                        # code...
                        break;
                }
                foreach ($year_array as $year) {
                    foreach ($month_array as $month) {
                        $insdate = date('Y-m-d', strtotime("$which $dowMap[$day_code] of $month $year"));
                        $data['WeekHolidayList']['day_code'] = $day_code;
                        $data['WeekHolidayList']['emp_group'] = $group_code;
                        $data['WeekHolidayList']['dt'] = $insdate;
                        $this->WeekHolidayList->create();
                        $this->WeekHolidayList->save($data);
                    }
                }
            }
        }
    }

    public function delete_weekHolidayList($id) {

        $weekHol = $this->WeekHoliday->find('all', array(
            'conditions' => array(
                'WeekHoliday.id' => $id,
            ),
        ));
        $day_code = $weekHol[0]['WeekHoliday']['day_code'];
        $this->WeekHolidayList->deleteAll(array('WeekHolidayList.day_code' => $day_code), false);
    }

}

?>
