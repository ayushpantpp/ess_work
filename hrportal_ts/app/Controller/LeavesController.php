<?php
ob_start();
App::import('phpexcel');

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


class LeavesController extends AppController {

    var $uses = array('LeaveEncashmentWorkflow','AttendanceDetail', 'Leave', 'MstEmpLeave', 'MstLeaveType', 'MstEmpLeaveAllot', 'WfMstStatus', 'LeaveDetail', 'LeaveWorkflow', 'Holiday', 'WeekHoliday', 'WeekHolidayList', 'MyProfile', 'WfDtAppMapLvl', 'LeaveGrp', 'LeaveEncsh', 'LeaveEncshDt', 'SalaryDetail', 'SalaryProcessing', 'SalaryProcessingAddition', 'SalaryProcessingDeduction', 'OptionAttribute', 'OrgHcmLeave1', 'LeaveConfiguration');
    var $components = array('Session', 'Cookie', 'RequestHandler', 'Auth', 'EmpDetail','Common');
    var $helpers = array('Html', 'Js', 'Form', 'Session', 'Userdetail', 'Leave', 'Common');
    var $paginate = array(
        'limit' => 10,
        'order' => array(
            'Leave.applied_date' => 'desc'
        )
    );

    public function beforeFilter() {
        parent::beforeFilter();
        $currentUser = $this->checkUser();
        $this->Auth->allow();
        $this->set('status', $this->WfMstStatus->find('list', array('fields' => array('id', 'status_name'))));
        $this->set('appId', 2);
    }

    public function deleteLeaveDetails($leave_id) {
        $leave_id = base64_decode($leave_id);
        $ld = $this->LeaveDetail->find('list', array(
            'conditions' => array(
                'leave_id' => $leave_id
            )
        ));
        foreach ($ld as $key => $value) {
            $this->LeaveDetail->delete($value);
        }
        $wf = $this->LeaveWorkflow->find('list', array(
            'conditions' => array(
                'leave_id' => $leave_id
            )
        ));
        foreach ($wf as $key => $value) {
            $this->LeaveWorkflow->delete($value);
        }
        $ml = $this->MstEmpLeave->find('list', array(
            'conditions' => array(
                'leave_id' => $leave_id
            )
        ));
        foreach ($ml as $key => $value) {
            $this->MstEmpLeave->delete($value);
        }
        $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                            <a href="#" class="uk-alert-close uk-close"></a>Leave Deleted Sucessfully</div>');
        $this->redirect('view/');
    }

    public function view($val) {
       try {
        if(!empty($val))
        {
            $dt=$val;
       $this->set('pen_val',$dt);
        }
         $dt=$this->Common->findpaginateLevel('2');
            $this->layout = 'employee-new';
            $emp_code = $this->Auth->User('emp_code');
            $this->paginate = array(
                'fields' => array('*'),
                //'limit' => $dt,
                'order' => 'MstEmpLeave.leave_id DESC',
                'group' => array('LeaveDetail.leave_id'),
                'joins' => array(
                    array(
                        'table' => 'mst_emp_leaves',
                        'alias' => 'MstEmpLeave',
                        'type' => 'inner',
                        'foreignKey' => false,
                        'conditions' => array('MstEmpLeave.leave_id = LeaveDetail.leave_id ')
                    ),
                ),
                'conditions' => array('MstEmpLeave.emp_code' => $emp_code)
            );

            /*             * *****************************Graph view value dynamic functionality***************************************** */
            if (empty($app_emp_code))
                $app_emp_code = $this->Auth->User('emp_code');
            $leaveType = $this->MstEmpLeaveAllot->find('all', array(
                'fields' => array('type.id', 'type.name', 'MstEmpLeaveAllot.allot_leave', 'MstEmpLeaveAllot.emp_code', 'type.id', 'MstEmpLeaveAllot.leave_op'),
                'conditions' => array('MstEmpLeaveAllot.emp_code' => $app_emp_code),
                'joins' => array(
                    array(
                        'table' => 'option_attribute',
                        'alias' => 'type',
                        'type' => 'INNER',
                        'conditions' => array(
                            'MstEmpLeaveAllot.leave_code = type.id'
                        )
                    )
                ),
            ));


            $this->set('leaveType', $leaveType);
            $i = 0;
            foreach ($leaveType as $type) {
                $i++;
                $bal = $type['MstEmpLeaveAllot']['allot_leave'];
                $remark = $type['type']['name'];
                $empallotleavetype[] = "'$remark'";
                $dappLeaves = $this->LeaveDetail->find('count', array(
                    'fields' => array('LeaveDetail.leave_detail_id'),
                    'conditions' => (array('LeaveDetail.leave_code' => $type['type']['id'], 'LeaveDetail.emp_code' => $this->Auth->User('emp_code'), 'leave_status' => 5, 'hlfday_leave_chk' => 'N'))
                ));
                $dhalfleave = $this->LeaveDetail->find('count', array(
                    'fields' => array('LeaveDetail.leave_detail_id'),
                    'conditions' => (array('LeaveDetail.leave_code' => $type['type']['id'], 'LeaveDetail.emp_code' => $this->Auth->User('emp_code'), 'leave_status' => 5, 'hlfday_leave_chk' => 'Y'))
                ));
                $half = $dhalfleave / 2;
                $a[] = $dappLeaves + $half;
            }
            $lwpapp = $this->LeaveDetail->find('count', array(
                'fields' => array('LeaveDetail.leave_detail_id'),
                'conditions' => (array('LeaveDetail.leave_code' => $this->lwp_leave_code['LeaveConfiguration']['leave_code'], 'LeaveDetail.emp_code' => $this->Auth->User('emp_code'), 'leave_status' => 5, 'hlfday_leave_chk' => 'N'))
            ));
            $a[] = $lwpapp;
            $empallotleavetype[] = "'LWP'";
            $this->set('employeeleave', implode(",", $empallotleavetype));
            $type = implode(',', $a);
            $this->set('leavetype', $type);
            $this->set('leavesDetails', $leaves);
            $data = $this->paginate('LeaveDetail');
            $this->set('leavelist', $data);
        } catch (Exception $e) {
            
        }
    }
    
    public function view_by_hr() {
        try {
             $dt=$this->Common->findpaginateLevel('2');
            $this->layout = 'employee-new';
            $emp_code = $this->Auth->User('emp_code');
            $this->paginate = array(
                'fields' => array('*'),
                //'limit' => $dt,
                'order' => 'MstEmpLeave.leave_id DESC',
                'group' => array('LeaveDetail.leave_id'),
                'joins' => array(
                    array(
                        'table' => 'mst_emp_leaves',
                        'alias' => 'MstEmpLeave',
                        'type' => 'inner',
                        'foreignKey' => false,
                        'conditions' => array('MstEmpLeave.leave_id = LeaveDetail.leave_id ')
                    ),
                ),
                'conditions' => array('MstEmpLeave.by_hr' => 1)
            );

            /*             * *****************************Graph view value dynamic functionality***************************************** */
            if (empty($app_emp_code))
                $app_emp_code = $this->Auth->User('emp_code');
            $leaveType = $this->MstEmpLeaveAllot->find('all', array(
                'fields' => array('type.id', 'type.name', 'MstEmpLeaveAllot.allot_leave', 'MstEmpLeaveAllot.emp_code', 'type.id', 'MstEmpLeaveAllot.leave_op'),
                'conditions' => array('MstEmpLeaveAllot.emp_code' => $app_emp_code),
                'joins' => array(
                    array(
                        'table' => 'option_attribute',
                        'alias' => 'type',
                        'type' => 'INNER',
                        'conditions' => array(
                            'MstEmpLeaveAllot.leave_code = type.id'
                        )
                    )
                ),
            ));


            $this->set('leaveType', $leaveType);
            $i = 0;
            foreach ($leaveType as $type) {
                $i++;
                $bal = $type['MstEmpLeaveAllot']['allot_leave'];
                $remark = $type['type']['name'];
                $empallotleavetype[] = "'$remark'";
                $dappLeaves = $this->LeaveDetail->find('count', array(
                    'fields' => array('LeaveDetail.leave_detail_id'),
                    'conditions' => (array('LeaveDetail.leave_code' => $type['type']['id'], 'LeaveDetail.emp_code' => $this->Auth->User('emp_code'), 'leave_status' => 5, 'hlfday_leave_chk' => 'N'))
                ));
                $dhalfleave = $this->LeaveDetail->find('count', array(
                    'fields' => array('LeaveDetail.leave_detail_id'),
                    'conditions' => (array('LeaveDetail.leave_code' => $type['type']['id'], 'LeaveDetail.emp_code' => $this->Auth->User('emp_code'), 'leave_status' => 5, 'hlfday_leave_chk' => 'Y'))
                ));
                $half = $dhalfleave / 2;
                $a[] = $dappLeaves + $half;
            }
            $lwpapp = $this->LeaveDetail->find('count', array(
                'fields' => array('LeaveDetail.leave_detail_id'),
                'conditions' => (array('LeaveDetail.leave_code' => $this->lwp_leave_code['LeaveConfiguration']['leave_code'], 'LeaveDetail.emp_code' => $this->Auth->User('emp_code'), 'leave_status' => 5, 'hlfday_leave_chk' => 'N'))
            ));
            $a[] = $lwpapp;
            $empallotleavetype[] = "'LWP'";
            $this->set('employeeleave', implode(",", $empallotleavetype));
            $type = implode(',', $a);
            $this->set('leavetype', $type);
            $this->set('leavesDetails', $leaves);
            $data = $this->paginate('LeaveDetail');
            $this->set('leavelist', $data);
        } catch (Exception $e) {
            
        }
    }


    public function add() {
        //Configure::write('debug',2);
        ini_set('memory_limit', '256M');
        $this->layout = 'employee-new';
        $this->employeeLeave();
        $this->employeeLeaveDetail();
        $emp_code = $this->Auth->User('emp_code');
        $Appleavecount_tets = $this->LeaveDetail->find('all', array(
                'conditions' => array(
                    "leave_status NOT IN (4,7)", "MONTH(leave_date)" => date('m'), 'emp_code' => $emp_code,
						"leave_code in ('PAR0000112','PAR0kjh000011')"
                ),
                'fields'=>array('shrt_type'),
                'order'=>array('shrt_type asc')
            ));
        if(empty($Appleavecount_tets)){
            $list = array('' => "-Select-",'0'=>'30 Minutes','1'=>'1.5 Hrs','2'=>'2 Hrs');
            
        }
        foreach($Appleavecount_tets as $k){
            if($k['LeaveDetail']['shrt_type']==2){
                $list = array('' => "-Select-");
            }
            if($k['LeaveDetail']['shrt_type']==1){
                $list = array('' => "-Select-",'0'=>'30 Minutes');
            }
            if($k['LeaveDetail']['shrt_type']==1 && count($Appleavecount_tets) >= 2){
                $list = array('' => "-Select-");
            }
            if($k['LeaveDetail']['shrt_type']==0){
                $list = array('' => "-Select-",'0'=>'30 Minutes','1'=>'1.5 Hrs');
            }
            if($k['LeaveDetail']['shrt_type']==0 && count($Appleavecount_tets) >= 2){
                $list = array('' => "-Select-");
            }
        }
        $this->set('shrt_leave_type',$list);
       
       //print_r($Appleavecount_tets); die;
        
        $holidays = $this->Holiday->find('list', array(
            'fields' => 'holiday_date',
            'conditions' => array('op_leave !=' => 1)
        ));
        $optional_holiday = $this->Holiday->find('list', array(
            'fields' => array('holiday_date'),
            'conditions' => array('op_leave' => 1, 'org_id' => $this->Auth->User('comp_code'))
        ));
        App::import("Model", "LeaveConfiguration");
        $leaveConfi = new LeaveConfiguration();
        $cl_leave_code = $leaveConfi->find('first', array('fields' => array('leave_code'), 'conditions' => array('leave_type' => 'CL')));
        $op_leave_code = $leaveConfi->find('first', array('fields' => array('leave_code'), 'conditions' => array('leave_type' => 'OP')));
        $sl_leave_code = $leaveConfi->find('first', array('fields' => array('leave_code'), 'conditions' => array('leave_type' => 'SL')));
        $lwp_leave_code = $leaveConfi->find('first', array('fields' => array('leave_code'), 'conditions' => array('leave_type' => 'LWP')));
        $el_leave_code = $leaveConfi->find('first', array('fields' => array('leave_code'), 'conditions' => array('leave_type' => 'EL')));
        $op_emp = $this->LeaveDetail->find('count', array('conditions' => array('leave_code' => $op_leave_code['LeaveConfiguration']['leave_code'], 'emp_code' => $this->Auth->User('emp_code'), 'leave_status IN(5,2,7,8)')));
        $casual_leave_op = $this->LeaveDetail->find('all', array('conditions' => array('leave_code' => $cl_leave_code['LeaveConfiguration']['leave_code'], 'emp_code' => $this->Auth->User('emp_code'), 'leave_status IN(5,2,7,8)')));
        $ordinary_leave_op = $this->LeaveDetail->find('all', array('conditions' => array('leave_code' => $el_leave_code['LeaveConfiguration']['leave_code'], 'emp_code' => $this->Auth->User('emp_code'), 'leave_status IN(5,2,7,8)')));
        $sick_leave_op = $this->LeaveDetail->find('all', array('conditions' => array('leave_code' => $sl_leave_code['LeaveConfiguration']['leave_code'], 'emp_code' => $this->Auth->User('emp_code'), 'leave_status IN(5,2,7,8)')));
        $cl_op_count = 0;
        foreach ($casual_leave_op as $cl) {
            if ((in_array($cl['LeaveDetail']['leave_date'], $optional_holiday) == true)) {

                if ($cl['LeaveDetail']['bypass_op'] == 1) {
                    $cl_op_count = $cl_op_count + 1;
                }
            }
        }
        foreach ($ordinary_leave_op as $cl) {
            if ((in_array($cl['LeaveDetail']['leave_date'], $optional_holiday) == true)) {

                if ($cl['LeaveDetail']['bypass_op'] == 1) {
                    $ol_op_count = $cl_op_count + 1;
                }
            }
        }
        foreach ($sick_leave_op as $cl) {
            if ((in_array($cl['LeaveDetail']['leave_date'], $optional_holiday) == true)) {

                if ($cl['LeaveDetail']['bypass_op'] == 1) {
                    $sl_op_count = $cl_op_count + 1;
                }
            }
        }
        $op_emp = $op_emp + $cl_op_count + $ol_op_count + $sl_op_count;
        $op_emp_cl = $op_emp + $cl_op_count;
        $op_emp_ol = $op_emp + $ol_op_count;
        $op_emp_sl = $op_emp + $sl_op_count;
        foreach ($optional_holiday as $K => $val) {
            $op_date = date('j-n-Y', strtotime($val));
            $op[] = "'$op_date'";
        }
        $implode = implode(",", $op);
        $gender = $_SESSION['Auth']['MyProfile']['gender'];
        $this->set('gender', $gender);
        $this->set('holidays', $holidays);
        $this->set('optionarray', $optional_holiday);
        $this->set('optional', $implode);
        $this->set('opemp', $op_emp);
        $week_holidays = $this->WeekHolidayList->find('list', array(
            'fields' => 'dt',
                  'conditions'=>array('emp_group'=> $_SESSION['Auth']['MyProfile']['emp_grp_id']
        )));
        
        $this->set('week_holidays', $week_holidays);
        $week_off = $this->LeaveConfiguration->find('list', array(
            'fields' => array('id', 'leave_code'),
            'conditions' => array('week_off' => 1)
        ));
        $this->set('week_offs', $week_off);
        if (!empty($this->request->data)) {
            $this->parksaveLeaveMaster();
            $this->redirect('view/');
        }
    }
    
    
     public function parksaveLeaveMaster() {
        $emp_code = $this->Auth->User('emp_code');
        $org_id = $this->Auth->User('comp_code');
        $startdate = $this->request->data['dt_start_date'];
        $enddate = $this->request->data['dt_end_date'];
        $date1 = new DateTime($startdate);
        $date2 = new DateTime($enddate);
        $datetime1 = $date1->format('Y-m-d');
        $datetime2 = $date2->format('Y-m-d');
        $datetime_1 = $datetime1;
        $datetime_2 = $datetime2;
        $interval = (strtotime($datetime2) - strtotime($datetime1));
        $days = floor($interval / (60 * 60 * 24)) + 1;
        $get_days_chk = $this->EmpDetail->checkApplicationDelay('2',$org_id);
        $today = date('d-M-Y');
        $t = strtotime($today.' -'.$get_days_chk.'day '); echo "<br>";
        $f = strtotime($startdate);
        
        if($get_days_chk != 0){
            if($t > $f){
                $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                                <a href="#" class="uk-alert-close uk-close"></a>' . "You can&#39;t apply leaves after $get_days_chk Days" . '</div>');
                            $this->redirect('add');
            }
        }
        App::import("Model", "LeaveConfiguration");
        $leaveConfi = new LeaveConfiguration();
        $cl_leave_code = $leaveConfi->find('first', array('fields' => array('leave_code'), 'conditions' => array('leave_type' => 'CL')));
        $op_leave_code = $leaveConfi->find('first', array('fields' => array('leave_code'), 'conditions' => array('leave_type' => 'OP')));
        $sl_leave_code = $leaveConfi->find('first', array('fields' => array('leave_code'), 'conditions' => array('leave_type' => 'SL')));
        $lwp_leave_code = $leaveConfi->find('first', array('fields' => array('leave_code'), 'conditions' => array('leave_type' => 'OD')));
        $el_leave_code = $leaveConfi->find('first', array('fields' => array('leave_code'), 'conditions' => array('leave_type' => 'EL')));
        $Appleavecount_tets = $this->LeaveDetail->find('first', array(
                'conditions' => array(
                    "leave_status NOT IN (4,7)", "leave_date" => $datetime_1, 'emp_code' => $emp_code,
						"leave_code in ('PAR0000332','PAR0000011')"
                )
            ));
		if(!empty($Appleavecount_tets)){
			$this->LeaveDetail->delete($Appleavecount_tets['LeaveDetail']['leave_detail_id']);
			$this->MstEmpLeave->delete($Appleavecount_tets['LeaveDetail']['leave_id']);
			$reason_cont = $Appleavecount_tets['LeaveDetail']['leave_reason'];
		}

        $n = 0;
        for ($i = 0; $i < $days; $i++) {
            $Appleavecount = $this->LeaveDetail->find('all', array(
                'conditions' => array(
                    "leave_status NOT IN (4,7)", "leave_date" => $datetime_1, 'emp_code' => $emp_code
                )
            ));
            if (count($Appleavecount) > 0) {
                $n = $n + 1;
            }
            $datetime_1 = date('Y-m-d', strtotime($datetime_1 . ' +1 day'));
        }
        $msg = $this->EmpDetail->leaveConditions($this->data['leave_code'], $this->data['Leave']['nu_tot_leaves'], $emp_code, $this->data['dt_start_date']);

        if ($msg == 1) {
            if ($n > 0) {
                $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                            <a href="#" class="uk-alert-close uk-close"></a>Leave Already Applied for Same Date</div>');
                $this->redirect('/leaves/add');
            } else {
                if ($this->data['leave_code'] !== $lwp_leave_code['LeaveConfiguration']['leave_code'] && $this->data['leave_code'] !== $op_leave_code['LeaveConfiguration']['leave_code'] && $this->data['Leave']['leave_code'] !== $this->ml_leave_code['LeaveConfiguration']['leave_code']) {

                    $bal = $this->EmpDetail->getBalLeave($emp_code, $this->request->data['leave_code']);

                    $Penleavecount = $this->LeaveDetail->find('count', array(
                        'conditions' => array(
                            'emp_code' => $emp_code,
                            'leave_status IN (2,3,7)',
                            'leave_code' => $this->request->data['leave_code'],
                            'hlfday_leave_chk' => 'N')
                    ));
                    $halfleavecount = $this->LeaveDetail->find('count', array(
                        'conditions' => array(
                            'emp_code' => $emp_code,
                            'leave_status IN (2,3,6,7)',
                            'leave_code' => $this->request->data['leave_code'],
                            'hlfday_leave_chk' => 'Y')
                    ));
                    $half = $halfleavecount / 2;
                    $pendings = $Penleavecount + $half;
                    $totalLeave = $this->request->data['Leave']['nu_tot_leaves'];

                    if ($totalLeave > ($bal - $pendings )) {
                        $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                            <a href="#" class="uk-alert-close uk-close"></a>' . "You can&#39;t apply $totalLeave leaves in $bal Balance Leaves and $pendings Pending Leaves." . '</div>');
                        $this->redirect('add');
                    }
                }
                // new file Upload //   
                $lv_val = array();
                if ($_FILES['leave_image']['name'] != '') {
                    $path = "upload/";
                    $name = $_FILES['leave_image']['name'];
                    $ext = end(explode('.', $name));
                    $new_name = date('dmYhis') . $emp_code . "." . $ext;

                    $final_path = $path . $new_name;
                    $type = explode('/', $_FILES['leave_image']['type']);
                    move_uploaded_file($_FILES['leave_image']['tmp_name'], $final_path);
                    $other = 'image';
                }
                $lv_val['start_date'] = $datetime1;
                $lv_val['end_date'] = $datetime2;
                $lv_val['total_leave'] = $this->request->data['Leave']['nu_tot_leaves'];
                $lv_val['emp_code'] = $this->Auth->user('emp_code');
                $lv_val['comp_code'] = $this->Auth->user('comp_code');
                $lv_val['applied_date'] = date('Y-m-d h:i:s');
                $lv_val['leave_image'] = $final_path;
                $lv_save = $this->MstEmpLeave->save($lv_val);
                unset($lv_val);
                $record_id = $this->MstEmpLeave->getLastInsertID();
                if ($lv_save) {
                    $this->parksaveLeave($record_id);
                } else {
                    $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                            <a href="#" class="uk-alert-close uk-close"></a>Leave Failed</div>');
                    $this->redirect('/leaves/add');
                }
            }
        } else {
            $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert="">
                            <a href="#" class="uk-alert-close uk-close"></a>' . $msg . '</div>');
            $this->redirect('add');
        }
    }
   
    
    function add_others_leave() {
        $this->layout = 'employee-new';
        $this->employeeLeave();
        $this->employeeLeaveDetail();
        $holidays = $this->Holiday->find('list', array(
            'fields' => 'holiday_date',
            'conditions' => array('op_leave !=' => 1)
        ));
        $optional_holiday = $this->Holiday->find('list', array(
            'fields' => array('holiday_date'),
            'conditions' => array('op_leave' => 1, 'org_id' => $this->Auth->User('comp_code'))
        ));
        App::import("Model", "LeaveConfiguration");
        $leaveConfi = new LeaveConfiguration();
        $cl_leave_code = $leaveConfi->find('first', array('fields' => array('leave_code'), 'conditions' => array('leave_type' => 'CL')));
        $op_leave_code = $leaveConfi->find('first', array('fields' => array('leave_code'), 'conditions' => array('leave_type' => 'OP')));
        $sl_leave_code = $leaveConfi->find('first', array('fields' => array('leave_code'), 'conditions' => array('leave_type' => 'SL')));
        $lwp_leave_code = $leaveConfi->find('first', array('fields' => array('leave_code'), 'conditions' => array('leave_type' => 'LWP')));
        $el_leave_code = $leaveConfi->find('first', array('fields' => array('leave_code'), 'conditions' => array('leave_type' => 'EL')));
        $op_emp = $this->LeaveDetail->find('count', array('conditions' => array('leave_code' => $op_leave_code['LeaveConfiguration']['leave_code'], 'emp_code' => $this->Auth->User('emp_code'), 'leave_status IN(5,2,7,8)')));
        $casual_leave_op = $this->LeaveDetail->find('all', array('conditions' => array('leave_code' => $cl_leave_code['LeaveConfiguration']['leave_code'], 'emp_code' => $this->Auth->User('emp_code'), 'leave_status IN(5,2,7,8)')));
        $ordinary_leave_op = $this->LeaveDetail->find('all', array('conditions' => array('leave_code' => $el_leave_code['LeaveConfiguration']['leave_code'], 'emp_code' => $this->Auth->User('emp_code'), 'leave_status IN(5,2,7,8)')));
        $sick_leave_op = $this->LeaveDetail->find('all', array('conditions' => array('leave_code' => $sl_leave_code['LeaveConfiguration']['leave_code'], 'emp_code' => $this->Auth->User('emp_code'), 'leave_status IN(5,2,7,8)')));
        $cl_op_count = 0;
        foreach ($casual_leave_op as $cl) {
            if ((in_array($cl['LeaveDetail']['leave_date'], $optional_holiday) == true)) {
                if ($cl['LeaveDetail']['bypass_op'] == 1) {
                    $cl_op_count = $cl_op_count + 1;
                }
            }
        }
        foreach ($ordinary_leave_op as $cl) {
            if ((in_array($cl['LeaveDetail']['leave_date'], $optional_holiday) == true)) {
                if ($cl['LeaveDetail']['bypass_op'] == 1) {
                    $ol_op_count = $cl_op_count + 1;
                }
            }
        }
        foreach ($sick_leave_op as $cl) {
            if ((in_array($cl['LeaveDetail']['leave_date'], $optional_holiday) == true)) {

                if ($cl['LeaveDetail']['bypass_op'] == 1) {
                    $sl_op_count = $cl_op_count + 1;
                }
            }
        }
        $op_emp = $op_emp + $cl_op_count + $ol_op_count + $sl_op_count;
        $op_emp_cl = $op_emp + $cl_op_count;
        $op_emp_ol = $op_emp + $ol_op_count;
        $op_emp_sl = $op_emp + $sl_op_count;
        foreach ($optional_holiday as $K => $val) {
            $op_date = date('j-n-Y', strtotime($val));
            $op[] = "'$op_date'";
        }
        $implode = implode(",", $op);
        $gender = $_SESSION['Auth']['MyProfile']['gender'];
        $this->set('gender', $gender);
        $this->set('holidays', $holidays);
        $this->set('optionarray', $optional_holiday);
        $this->set('optional', $implode);
        $this->set('opemp', $op_emp);
        $week_holidays = $this->WeekHolidayList->find('list', array(
            'fields' => 'dt',
                      'conditions'=>array('emp_group'=> $_SESSION['Auth']['MyProfile']['emp_grp_id']
      
        )
        ));

        $this->set('week_holidays', $week_holidays);
        $week_off = $this->LeaveConfiguration->find('list', array(
            'fields' => array('id', 'leave_code'),
            'conditions' => array('week_off' => 1)
        ));
        $this->set('week_offs', $week_off);
        if (!empty($this->request->data)) {
            $this->parksaveLeaveMasterOther();
            $this->redirect('view/');
        }
    }
    
     public function parksaveLeaveMasterOther() {
        $emp_code = $this->request->data['user_name'];
        $startdate = $this->request->data['dt_start_date'];
        $enddate = $this->request->data['dt_end_date'];
        $comp_code = $this->request->data['comp_code'];
        $date1 = new DateTime($startdate);
        $date2 = new DateTime($enddate);
        $datetime1 = $date1->format('Y-m-d');
        $datetime2 = $date2->format('Y-m-d');
        $datetime_1 = $datetime1;
        $datetime_2 = $datetime2;
        $interval = (strtotime($datetime2) - strtotime($datetime1));
        $days = floor($interval / (60 * 60 * 24)) + 1;
        App::import("Model", "LeaveConfiguration");
        $leaveConfi = new LeaveConfiguration();
        $cl_leave_code = $leaveConfi->find('first', array('fields' => array('leave_code'), 'conditions' => array('leave_type' => 'CL')));
        $op_leave_code = $leaveConfi->find('first', array('fields' => array('leave_code'), 'conditions' => array('leave_type' => 'OP')));
        $sl_leave_code = $leaveConfi->find('first', array('fields' => array('leave_code'), 'conditions' => array('leave_type' => 'SL')));
        $lwp_leave_code = $leaveConfi->find('first', array('fields' => array('leave_code'), 'conditions' => array('leave_type' => 'OD')));
        $el_leave_code = $leaveConfi->find('first', array('fields' => array('leave_code'), 'conditions' => array('leave_type' => 'EL')));
        $n = 0;
        for ($i = 0; $i < $days; $i++) {
            $Appleavecount = $this->LeaveDetail->find('all', array(
                'conditions' => array(
                    "leave_status NOT IN (4,7)", "leave_date" => $datetime_1, 'emp_code' => $emp_code
                )
            ));
            if (count($Appleavecount) > 0) {
                $n = $n + 1;
            }
            $datetime_1 = date('Y-m-d', strtotime($datetime_1 . ' +1 day'));
        }
        $msg = $this->EmpDetail->leaveConditions($this->data['leave_code'], $this->data['Leave']['nu_tot_leaves'], $emp_code, $this->data['dt_start_date']);

        if ($msg == 1) {
            if ($n > 0) {
                $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                            <a href="#" class="uk-alert-close uk-close"></a>Leave Already Applied for Same Date</div>');
                $this->redirect('/leaves/add_others_leave');
            } else {
                if ($this->data['leave_code'] !== $lwp_leave_code['LeaveConfiguration']['leave_code'] && $this->data['leave_code'] !== $op_leave_code['LeaveConfiguration']['leave_code'] && $this->data['Leave']['leave_code'] !== $this->ml_leave_code['LeaveConfiguration']['leave_code']) {

                    $bal = $this->EmpDetail->getBalLeave($emp_code, $this->request->data['leave_code']);

                    $Penleavecount = $this->LeaveDetail->find('count', array(
                        'conditions' => array(
                            'emp_code' => $emp_code,
                            'leave_status IN (2,3,7)',
                            'leave_code' => $this->request->data['leave_code'],
                            'hlfday_leave_chk' => 'N')
                    ));
                    $halfleavecount = $this->LeaveDetail->find('count', array(
                        'conditions' => array(
                            'emp_code' => $emp_code,
                            'leave_status IN (2,3,6,7)',
                            'leave_code' => $this->request->data['leave_code'],
                            'hlfday_leave_chk' => 'Y')
                    ));
                    $half = $halfleavecount / 2;
                    $pendings = $Penleavecount + $half;
                    $totalLeave = $this->request->data['Leave']['nu_tot_leaves'];

                    if ($totalLeave > ($bal - $pendings )) {
                        $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                            <a href="#" class="uk-alert-close uk-close"></a>' . "You can&#39;t apply $totalLeave leaves in $bal Balance Leaves and $pendings Pending Leaves." . '</div>');
                        $this->redirect('add_others_leave');
                    }
                }

                // new file Upload //   
                $lv_val = array();
                if ($_FILES['leave_image']['name'] != '') {
                    $path = "upload/";
                    $name = $_FILES['leave_image']['name'];
                    $ext = end(explode('.', $name));
                    $new_name = date('dmYhis') . $emp_code . "." . $ext;

                    $final_path = $path . $new_name;
                    $type = explode('/', $_FILES['leave_image']['type']);
                    move_uploaded_file($_FILES['leave_image']['tmp_name'], $final_path);
                    $other = 'image';
                }
                $lv_val['start_date'] = $datetime1;
                $lv_val['end_date'] = $datetime2;
                $lv_val['total_leave'] = $this->request->data['Leave']['nu_tot_leaves'];
                $lv_val['emp_code'] = $emp_code;
                $lv_val['comp_code'] = $comp_code;
                $lv_val['applied_date'] = date('Y-m-d h:i:s');
                $lv_val['by_hr'] = 1;
                $lv_val['leave_image'] = $final_path;
                
                $lv_save = $this->MstEmpLeave->save($lv_val);
                unset($lv_val);
                $record_id = $this->MstEmpLeave->getLastInsertID();
                if ($lv_save) {
                    $this->parksaveLeaveOther($record_id);
                } else {
                    $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                            <a href="#" class="uk-alert-close uk-close"></a>Leave Failed</div>');
                    $this->redirect('/leaves/add_others_leave');
                }
            }
        } else {
            $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert="">
                            <a href="#" class="uk-alert-close uk-close"></a>' . $msg . '</div>');
            $this->redirect('add_others_leave');
        }
    }

    public function parksaveLeaveOther($record_id) {
        $startdate = $this->request->data['dt_start_date'];
        $enddate = $this->request->data['dt_end_date'];
        $comp_code = $this->request->data['comp_code'];
        $date1 = new DateTime($startdate);
        $date2 = new DateTime($enddate);
        $datetime1 = $date1->format('Y-m-d');
        $datetime2 = $date2->format('Y-m-d');
        App::import("Model", "LeaveConfiguration");
        $leaveConfi = new LeaveConfiguration();
        $cl_leave_code = $leaveConfi->find('first', array('fields' => array('leave_code'), 'conditions' => array('leave_type' => 'CL')));
        $op_leave_code = $leaveConfi->find('first', array('fields' => array('leave_code'), 'conditions' => array('leave_type' => 'OP')));
        $sl_leave_code = $leaveConfi->find('first', array('fields' => array('leave_code'), 'conditions' => array('leave_type' => 'SL')));
        $lwp_leave_code = $leaveConfi->find('first', array('fields' => array('leave_code'), 'conditions' => array('leave_type' => 'LWP')));
        $el_leave_code = $leaveConfi->find('first', array('fields' => array('leave_code'), 'conditions' => array('leave_type' => 'EL')));
        
        $interval = (strtotime($datetime2) - strtotime($datetime1));
        $days = floor($interval / (60 * 60 * 24)) + 1;
        $emp_code = $this->request->data['user_name'];
        $leaveeditDetail = $this->LeaveDetail->find('count', array(
            'conditions' => array(
                'emp_code' => $emp_code,
                'leave_id' => $record_id,
                'leave_date' => $startdate)
        ));
        $week_holidays = $this->WeekHolidayList->find('list', array(
            'fields' => 'dt'
        ));
        $week = $this->WeekHolidayList->find('list', array(
            'fields' => array('dt')));
        $holiday = $this->Holiday->find('list', array(
            'fields' => array('holiday_date')));
        $combined = array_merge($week, $holiday);
        $datebefore = date('Y-m-d', strtotime($datetime1 . ' -1 day'));
        $dateafter = date('Y-m-d', strtotime($datetime2 . ' +1 day'));
        $cnt_lv = 0;
        for ($i = 0; $i < 8; $i++) {
            if (in_array($datebefore, $combined)) {
                $datebefore = date('Y-m-d', strtotime($datebefore . ' -1 day'));
                $cnt_lv++;
            }
            if (in_array($dateafter, $combined)) {
                $dateafter = date('Y-m-d', strtotime($dateafter . ' +1 day'));
                $cnt_lv++;
            }
        }
        
        if ($leaveeditDetail > 0) {
            $this->LeaveDetail->updateAll(
                    array('LeaveDetail.leave_code' => $this->request->data['leave_code']), array('LeaveDetail.emp_code' => $emp_code, 'LeaveDetail.leave_date' => $datetime1)
            );
            if ($leave_save) {
                $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                            <a href="#" class="uk-alert-close uk-close"></a>Leave Parked successfully</div>');
                $this->redirect('/leaves/add_others_leave');
            } else {
                $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                            <a href="#" class="uk-alert-close uk-close"></a>Leave Failed</div>');
                $this->redirect('/leaves/view_by_hr');
            }
        } else { 
            for ($i = 0; $i < $days; $i++) {
                if (in_array($datetime1, $week) && $this->request->data['leave_code'] == $cl_leave_code['LeaveConfiguration']['leave_code']) {
                } else {
                    if ($this->request->data['leave_code'] == $this->cl_leave_code['LeaveConfiguration']['leave_code']) {
                        $leavecheckbefore = $this->LeaveDetail->find('all', array('fields' => array('leave_id', 'leave_code', 'Count(leave_id)'), 'conditions' => array('leave_date' => $datebefore, 'emp_code' => $emp_code, 'leave_status' => array(5, 2, 7, 8))));
                        $leavecheckafter = $this->LeaveDetail->find('all', array('fields' => array('leave_id', 'leave_code', 'Count(leave_id)'), 'conditions' => array('leave_date' => $dateafter, 'emp_code' => $emp_code, 'leave_status' => array(5, 2, 7, 8))));
                        $totleavebefore = $this->LeaveDetail->find('all', array('fields' => array('leave_id', 'leave_code', 'Count(leave_id) tot'), 'conditions' => array('leave_id' => $leavecheckbefore[0]['LeaveDetail']['leave_id'], 'emp_code' => $emp_code, 'leave_status' => array(5, 2, 7, 8)), 'group' => array('leave_id')));
                        $totleaveafter = $this->LeaveDetail->find('all', array('fields' => array('leave_id', 'leave_code', 'Count(leave_id) tot'), 'conditions' => array('leave_id' => $leavecheckafter[0]['LeaveDetail']['leave_id'], 'emp_code' => $emp_code, 'leave_status' => array(5, 2, 7, 8)), 'group' => array('leave_id')));
                        $totalleavecountbefore = $totleaveafter[0][0]['tot'] + $totleavebefore[0][0]['tot'] + $this->request->data['Leave']['nu_tot_leaves'] + $cnt_lv;
                    }
                    if (count($totleavebefore) > 0 && count($totleaveafter) <= 0) {
                        $totalleaveid[] = $totleavebefore[0]['LeaveDetail']['leave_id'];
                    } else if (count($totleaveafter) > 0 && count($totleavebefore) <= 0) {
                        $totalleaveid[] = $totleaveafter[0]['LeaveDetail']['leave_id'];
                    } else if (count($totleavebefore) > 0 && count($totleaveafter) > 0) {
                        $totalleaveid[] = array($totleaveafter[0]['LeaveDetail']['leave_id'], $totleavebefore[0]['LeaveDetail']['leave_id']);
                    }
                    $data_val = array();
                    $data_val['leave_id'] = $record_id;
                    $data_val['leave_date'] = $datetime1;
                    if ($totalleavecountbefore > 5) {
                        $data_val['leave_code'] = $this->el_leave_code['LeaveConfiguration']['leave_code'];
                        $el_id = $this->el_leave_code['LeaveConfiguration']['leave_code'];
                             $alert = 'In case You apply for the Casual Leave in this Senario All Last Consicutive leave will be converted to EL Click Save to Continue Else click Cancel';
                        } else {
                        $alert = 'Leave Saved Successfully';
                        $data_val['leave_code'] = $this->request->data['leave_code'];
                    }
                    $data_val['leave_reason'] = $this->request->data['vc_leave_reason'];
                    $data_val['applied_date'] = date('Y-m-d');
                    if ($this->request->data['type'] == 'park') {
                        $data_val['leave_status'] = 7;
                    } else {
                        
                        $data_val['leave_status'] = 7;
                    }
                    if (in_array($datetime1, $week_holidays)) {
                        $data_val['week_off_chk'] = 1;
                    } else {
                        $data_val['week_off_chk'] = 0;
                    }
                    $data_val['emp_code'] = $emp_code;
                    if ($this->request->data['ch_st_daylength'] == "H" && $i == 0) {
                        $data_val['hlfday_leave_chk'] = 'Y';
                        $data_val['half_type'] = $this->request->data['ch_st_dayhalf'];
                    } else if ($this->request->data['ch_ed_daylength'] == "H" && $i == ($days - 1)) {
                        $data_val['hlfday_leave_chk'] = 'Y';
                        $data_val['half_type'] = $this->request->data['ch_ed_dayhalf'];
                    } else
                        $data_val['hlfday_leave_chk'] = 'N';
                    $this->LeaveDetail->create();
                    $this->LeaveDetail->set($data_val);
                    $leave_save = $this->LeaveDetail->save($data_val);
                }
                $datetime1 = date('Y-m-d', strtotime($datetime1 . ' +1 day'));
            }
        }
        $record_id = $this->MstEmpLeave->getLastInsertID();
        if ($leave_save && $this->request->data['type'] == 'park') {
            $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                            <a href="#" class="uk-alert-close uk-close"></a>Leave Parked successfully</div>');
            $this->redirect('/leaves/view_by_hr');
        } else if ($leave_save && $this->request->data['type'] == 'post') {
            $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                            <a href="#" class="uk-alert-close uk-close"></a>'. $alert. '</div>');
                            
            $this->redirect('/leaves/workflow_display/' . $record_id . '/' . $emp_code . '/' . $totalleaveid[0] . '/' . $el_id . '/' );
        } else {
            $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                            <a href="#" class="uk-alert-close uk-close"></a>Leave Failed</div>');
            $this->redirect('/leaves/add_others_leave');
        }
    }


    public function parksaveLeave($record_id) {
       // print_r($this->request->data); die;
        $startdate = $this->request->data['dt_start_date'];
        $enddate = $this->request->data['dt_end_date'];
        $date1 = new DateTime($startdate);
        $date2 = new DateTime($enddate);
        $datetime1 = $date1->format('Y-m-d');
        $datetime2 = $date2->format('Y-m-d');
        App::import("Model", "LeaveConfiguration");
        $leaveConfi = new LeaveConfiguration();
        $cl_leave_code = $leaveConfi->find('first', array('fields' => array('leave_code'), 'conditions' => array('leave_type' => 'CL')));
        $op_leave_code = $leaveConfi->find('first', array('fields' => array('leave_code'), 'conditions' => array('leave_type' => 'OP')));
        $sl_leave_code = $leaveConfi->find('first', array('fields' => array('leave_code'), 'conditions' => array('leave_type' => 'SL')));
        $lwp_leave_code = $leaveConfi->find('first', array('fields' => array('leave_code'), 'conditions' => array('leave_type' => 'LWP')));
        $el_leave_code = $leaveConfi->find('first', array('fields' => array('leave_code'), 'conditions' => array('leave_type' => 'EL')));
        
        $interval = (strtotime($datetime2) - strtotime($datetime1));
        $days = floor($interval / (60 * 60 * 24)) + 1;
        $emp_code = $this->request->data['user_name'];
        $leaveeditDetail = $this->LeaveDetail->find('count', array(
            'conditions' => array(
                'emp_code' => $emp_code,
                'leave_id' => $record_id,
                'leave_date' => $startdate)
        ));
        $week_holidays = $this->WeekHolidayList->find('list', array(
            'fields' => 'dt'
        ));
        $week = $this->WeekHolidayList->find('list', array(
            'fields' => array('dt')));
        $holiday = $this->Holiday->find('list', array(
            'fields' => array('holiday_date')));
        $combined = array_merge($week, $holiday);
        $datebefore = date('Y-m-d', strtotime($datetime1 . ' -1 day'));
        $dateafter = date('Y-m-d', strtotime($datetime2 . ' +1 day'));
        $cnt_lv = 0;
        for ($i = 0; $i < 8; $i++) {
            if (in_array($datebefore, $combined)) {
                $datebefore = date('Y-m-d', strtotime($datebefore . ' -1 day'));
                $cnt_lv++;
            }
            if (in_array($dateafter, $combined)) {
                $dateafter = date('Y-m-d', strtotime($dateafter . ' +1 day'));
                $cnt_lv++;
            }
        }
        
        if ($leaveeditDetail > 0) {
            $this->LeaveDetail->updateAll(
                    array('LeaveDetail.leave_code' => $this->request->data['leave_code']), array('LeaveDetail.emp_code' => $emp_code, 'LeaveDetail.leave_date' => $datetime1)
            );
            if ($leave_save) {
                $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                            <a href="#" class="uk-alert-close uk-close"></a>Leave Parked successfully</div>');
                $this->redirect('/leaves/add');
            } else {
                $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                            <a href="#" class="uk-alert-close uk-close"></a>Leave Failed</div>');
                $this->redirect('/leaves/view');
            }
        } else { 
            for ($i = 0; $i < $days; $i++) {
                if (in_array($datetime1, $week) && $this->request->data['leave_code'] == $cl_leave_code['LeaveConfiguration']['leave_code']) {
                } else {
                    if ($this->request->data['leave_code'] == $this->cl_leave_code['LeaveConfiguration']['leave_code']) {
                        $leavecheckbefore = $this->LeaveDetail->find('all', array('fields' => array('leave_id', 'leave_code', 'Count(leave_id)'), 'conditions' => array('leave_date' => $datebefore, 'emp_code' => $emp_code, 'leave_status' => array(5, 2, 7, 8))));
                        $leavecheckafter = $this->LeaveDetail->find('all', array('fields' => array('leave_id', 'leave_code', 'Count(leave_id)'), 'conditions' => array('leave_date' => $dateafter, 'emp_code' => $emp_code, 'leave_status' => array(5, 2, 7, 8))));
                        $totleavebefore = $this->LeaveDetail->find('all', array('fields' => array('leave_id', 'leave_code', 'Count(leave_id) tot'), 'conditions' => array('leave_id' => $leavecheckbefore[0]['LeaveDetail']['leave_id'], 'emp_code' => $emp_code, 'leave_status' => array(5, 2, 7, 8)), 'group' => array('leave_id')));
                        $totleaveafter = $this->LeaveDetail->find('all', array('fields' => array('leave_id', 'leave_code', 'Count(leave_id) tot'), 'conditions' => array('leave_id' => $leavecheckafter[0]['LeaveDetail']['leave_id'], 'emp_code' => $emp_code, 'leave_status' => array(5, 2, 7, 8)), 'group' => array('leave_id')));
                        $totalleavecountbefore = $totleaveafter[0][0]['tot'] + $totleavebefore[0][0]['tot'] + $this->request->data['Leave']['nu_tot_leaves'] + $cnt_lv;
                    }
                    if (count($totleavebefore) > 0 && count($totleaveafter) <= 0) {
                        $totalleaveid[] = $totleavebefore[0]['LeaveDetail']['leave_id'];
                    } else if (count($totleaveafter) > 0 && count($totleavebefore) <= 0) {
                        $totalleaveid[] = $totleaveafter[0]['LeaveDetail']['leave_id'];
                    } else if (count($totleavebefore) > 0 && count($totleaveafter) > 0) {
                        $totalleaveid[] = array($totleaveafter[0]['LeaveDetail']['leave_id'], $totleavebefore[0]['LeaveDetail']['leave_id']);
                    }
                    $data_val = array();
                    $data_val['leave_id'] = $record_id;
                    $data_val['leave_date'] = $datetime1;
                    if ($totalleavecountbefore > 5) {
                        $data_val['leave_code'] = $this->el_leave_code['LeaveConfiguration']['leave_code'];
                        $el_id = $this->el_leave_code['LeaveConfiguration']['leave_code'];
                             $alert = 'In case You apply for the Casual Leave in this Senario All Last Consicutive leave will be converted to EL Click Save to Continue Else click Cancel';
                        } else {
                        $alert = 'Leave Saved Successfully';
                        $data_val['leave_code'] = $this->request->data['leave_code'];
                    }
                    $data_val['leave_reason'] = $this->request->data['vc_leave_reason'];
                    $data_val['applied_date'] = date('Y-m-d');
                    $data_val['shrt_type'] = $this->request->data['short_leave_type'];
                    if ($this->request->data['type'] == 'park') {
                        $data_val['leave_status'] = 7;
                    } else {
                        
                        $data_val['leave_status'] = 7;
                    }
                    if (in_array($datetime1, $week_holidays)) {
                        $data_val['week_off_chk'] = 1;
                    } else {
                        $data_val['week_off_chk'] = 0;
                    }
                    $data_val['emp_code'] = $emp_code;
                    if ($this->request->data['ch_st_daylength'] == "H" && $i == 0) {
                        $data_val['hlfday_leave_chk'] = 'Y';
                        $data_val['half_type'] = $this->request->data['ch_st_dayhalf'];
                    } else if ($this->request->data['ch_ed_daylength'] == "H" && $i == ($days - 1)) {
                        $data_val['hlfday_leave_chk'] = 'Y';
                        $data_val['half_type'] = $this->request->data['ch_ed_dayhalf'];
                    } else
                        $data_val['hlfday_leave_chk'] = 'N';
                    $this->LeaveDetail->create();
                    $this->LeaveDetail->set($data_val);
                    $leave_save = $this->LeaveDetail->save($data_val);
                }
                $datetime1 = date('Y-m-d', strtotime($datetime1 . ' +1 day'));
            }
        }
        $record_id = $this->MstEmpLeave->getLastInsertID();
        if ($leave_save && $this->request->data['type'] == 'park') {
            $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                            <a href="#" class="uk-alert-close uk-close"></a>Leave Parked successfully</div>');
            $this->redirect('/leaves/view');
        } else if ($leave_save && $this->request->data['type'] == 'post') {
            $this->saveinfomation_skipwf($record_id,$emp_code);
           /* $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                            <a href="#" class="uk-alert-close uk-close"></a>'. $alert. '</div>');
                            
            $this->redirect('/leaves/workflow_display/' . $record_id . '/' . $emp_code . '/' . $totalleaveid[0] . '/' . $el_id );*/
        } else {
            $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                            <a href="#" class="uk-alert-close uk-close"></a>Leave Failed</div>');
            $this->redirect('/leaves/add');
        }
    }

    function leavedetail() {
        try {
            $id = $this->params['pass']['0'];
            $emp_code = $this->params['pass']['1'];
            if($emp_code == ''){
                $emp_code = $this->Auth->User('emp_code');
            }
            if (!empty($id)) {
                $ldetails = $this->MstEmpLeave->find('first', array(
                    'fields' => array('*'),
                    'conditions' => array('leave_id' => $id)
                ));

                $this->set('ldetails', $ldetails);
                $this->layout = '';
                $this->render('leavedetail');
            }
        } catch (Exception $e) {
            
        }
    }

    function leavedatefilter() {
        try {
            $this->layout = 'employee';
            if (!empty($this->data)) {
                $this->redirect($this->data['leaves'], null, true);
            }
            if (!empty($this->passedArgs)) {
                $arroder = array('VcEmpName' => 'vc_emp_name', 'Mgr' => 'mgr', 'ChLveStatus' => 'ch_lve_status', 'VcLeaveCode' => 'vc_leave_code');
                $startDate = date('Y-m-d', strtotime($this->passedArgs['Sdate']));
                $endDate = date('Y-m-d', strtotime($this->passedArgs['Edate']));
                $orderBy = $this->passedArgs['orderBy']; // 

                if (!empty($orderBy)) {
                    $orderBy = "order by " . $arroder[$orderBy] . "";
                }
                $conditions = array("(DT_START_DATE>=to_date('" . $startDate . "','YYYY-MM-DD') or DT_END_DATE>=to_date('" . $startDate . "','YYYY-MM-DD')) and (DT_START_DATE<=to_date('" . $startDate . "','YYYY-MM-DD') or DT_END_DATE<=to_date('" . $endDate . "','YYYY-MM-DD')) " . $orderBy . "");

                $this->set('datesearchresult', $this->paginate('Leavereport', $conditions));
            }
        } catch (Exception $e) {
            
        }
    }

    function leavelist() {
        try {
            $this->layout = 'employee';
            $lstatus = '';
            if (!empty($this->data)) {
                $this->redirect($this->data['leaves'], null, true);
            }
            if ($lstatus == '2' || $lstatus == '') {
                $conditions = array("leave_status= '2'");
            } else {
                $conditions = array("leave_status " => $lstatus);
            }
            $EmpID = $this->Auth->User('emp_code');
            $conditions[] = array('vc_mgr_code =' => $EmpID);
            $val = $this->paginate('LeaveDetail', $conditions);
            $this->set('leavelist', $this->paginate('LeaveDetail', $conditions));
        } catch (Exception $e) {
            
        }
    }

    function employeeLeave($app_emp_code = null) {
        if (empty($app_emp_code))
            $app_emp_code = $this->Auth->User('emp_code');
            $leave_name = $this->Leave->find('list', array(
            'fields' => array('Leave.leave_code', 'Leave.leave_name'),
            'conditions' => array('allot.emp_code' => $app_emp_code),
            'joins' => array(
                array(
                    'table' => 'mst_emp_leave_allot',
                    'alias' => 'allot',
                    'type' => 'INNER',
                    'conditions' => array(
                        'Leave.leave_code = allot.leave_code'
                    )
                )
            )
        ));
        $leave_name1 = $this->Leave->find('list', array(
            'fields' => array('Leave.leave_code', 'Leave.leave_name'),
            'conditions' => array('Leave.status' => true),
        ));
                $leave_name = array_merge($leave_name,$leave_name1);
                
            
        $vals = $this->Common->getDocID($app_emp_code);
        $model_1 = new Model(array('table' => 'comp_off_leave_trans', 'ds' => 'default'));
        $comp_count = $model_1->find('count', array(
            'fields' => array('leave_code', 'leave_name'),
            'conditions' => array('emp_doc_id' => $vals,'util_chk'=>'N')
        ));
        $comp_id = $model_1->find('first', array(
            'fields' => array('leave_id'),
            'conditions' => array('emp_doc_id' => $vals,'util_chk'=>'N')
        ));
        if($comp_count > 0){
        $leave_name[$comp_id['Model']['leave_id']] = 'COMP OFF';
        }
        $this->set('leave_name', $leave_name);
    }

    function employeeLeaveDetail($app_emp_code = null , $app_comp_code = null) {
        if (empty($app_emp_code))
        $app_emp_code = $this->Auth->User('emp_code');
        if (empty($app_comp_code))
        $app_comp_code = $this->Auth->User('comp_code');
        $comp = $this->Auth->User('comp_code');
        $leaveType = $this->MstEmpLeaveAllot->find('all', array(
            'fields' => array('type.name', 'MstEmpLeaveAllot.allot_leave', 'MstEmpLeaveAllot.leave_bal', 'MstEmpLeaveAllot.emp_code', 'type.id', 'MstEmpLeaveAllot.leave_op'),
            'conditions' => array('MstEmpLeaveAllot.emp_code' => $app_emp_code,'type.ho_org_id'=> $app_comp_code),
            'joins' => array(
                array(
                    'table' => 'option_attribute',
                    'alias' => 'type',
                    'type' => 'INNER',
                    'conditions' => array(
                        'MstEmpLeaveAllot.leave_code = type.id',
                    )
                )
            ),
        ));
        
        $leaveDetail = $this->MstEmpLeave->find('all', array(
            'conditions' => array('MstEmpLeave.emp_code' => $app_emp_code)
        ));
        $vals = $this->Common->getDocID($app_emp_code);
        $model_1 = new Model(array('table' => 'comp_off_leave_trans', 'ds' => 'default'));
        $comp_count = $model_1->find('count', array(
            'fields' => array('leave_code', 'leave_name'),
            'conditions' => array('emp_doc_id' => $vals,'util_chk'=>'N')
        ));
        
        $comp_id = $model_1->find('first', array(
            'fields' => array('leave_id'),
            'conditions' => array('emp_doc_id' => $vals,'util_chk'=>'N')
        ));
        $this->set('comp_off_id',$comp_id['Model']['leave_id']);
        $this->set('leaveDetail', $leaveDetail);
        if($comp_count > 0){
        $leaveType[]=array('type'=>array('name'=>'COMP OFF','id'=>$comp_id['Model']['leave_id']),'MstEmpLeaveAllot' => Array(
                    'allot_leave' => $comp_count,
                    'leave_bal' => $comp_count,
                    'emp_code' => 0,
                    'leave_op' => 0 ));
        }
        $this->set('leaveType', $leaveType);
        $this->set('comp_off_count',$comp_count);
    }

    function editSubmit($id) {
        $this->layout = 'employee-new';
        $this->employeeLeave();
        $this->employeeLeaveDetail();
        $this->paginate = array(
            'fields' => array('*'),
            'joins' => array(
                array(
                    'table' => 'mst_emp_leaves',
                    'alias' => 'MstEmpLeave',
                    'type' => 'inner',
                    'foreignKey' => false,
                    'conditions' => array('LeaveDetail.leave_id = MstEmpLeave.leave_id')
                )
            ),
            'conditions' => array('LeaveDetail.leave_id' => base64_decode($id))
        );
        
        $Appleavecount_tets = $this->LeaveDetail->find('all', array(
                'conditions' => array(
                    "leave_status NOT IN (4,7)", "MONTH(leave_date)" => date('m'), 'emp_code' => $emp_code,
						"leave_code in ('PAR0000112','PAR0kjh000011')"
                ),
                'fields'=>array('shrt_type'),
                'order'=>array('shrt_type asc')
            ));
        if(empty($Appleavecount_tets)){
            $list = array('' => "-Select-",'0'=>'30 Minutes','1'=>'1.5 Hrs','2'=>'2 Hrs');
            
        }
        foreach($Appleavecount_tets as $k){
            if($k['LeaveDetail']['shrt_type']==2){
                $list = array('' => "-Select-");
            }
            if($k['LeaveDetail']['shrt_type']==1){
                $list = array('' => "-Select-",'0'=>'30 Minutes');
            }
            if($k['LeaveDetail']['shrt_type']==1 && count($Appleavecount_tets) >= 2){
                $list = array('' => "-Select-");
            }
            if($k['LeaveDetail']['shrt_type']==0){
                $list = array('' => "-Select-",'0'=>'30 Minutes','1'=>'1.5 Hrs');
            }
            if($k['LeaveDetail']['shrt_type']==0 && count($Appleavecount_tets) >= 2){
                $list = array('' => "-Select-");
            }
        }
        $this->set('shrt_leave_type',$list);
       

        $empleavedetail = $this->paginate('LeaveDetail');
        $this->set('empleavedetailfirst', $empleavedetail[0]);

        if (sizeof($empleavedetail) - 1 == 0) {

            $this->set('empleavedetaillast', 'N');
        } else {
            $this->set('empleavedetaillast', $empleavedetail[sizeof($empleavedetail) - 1]);
        }

        $optional_holiday = $this->Holiday->find('list', array(
            'fields' => array('holiday_date'),
            'conditions' => array('op_leave' => 1, 'org_id' => $this->Auth->User('comp_code'))
        ));
        foreach ($optional_holiday as $K => $val) {
            $op_date = date('j-n-Y', strtotime($val));
            $op[] = "'$op_date'";
        }
        $implode = implode(",", $op);
        $this->set('optionarray', $optional_holiday);
        $this->set('optional', $implode);
        $holidays = $this->Holiday->find('list', array(
            'fields' => 'holiday_date'
        ));
        $this->set('holidays', $holidays);
        $week_holidays = $this->WeekHolidayList->find('list', array(
            'fields' => 'dt'
        ));
        $this->set('week_holidays', $week_holidays);
    }

    function editsaveinfo() {
        $this->autoload = false;
        $emp_code = $this->Auth->User('emp_code');
        $org_id = $this->Auth->User('comp_code');
        $startdate = $this->request->data['Leave']['dt_start_date'];
        $enddate = $this->request->data['Leave']['dt_end_date'];
        $date1 = new DateTime($startdate);
        $date2 = new DateTime($enddate);
        $datetime1 = $date1->format('Y-m-d');
        $datetime2 = $date2->format('Y-m-d');
        $datetime_1 = $datetime1;
        
        $get_days_chk = $this->EmpDetail->checkApplicationDelay('2',$org_id);
        $today = date('d-M-Y');
        $t = strtotime($today.' -'.$get_days_chk.'day ');
        $f = strtotime($startdate);
        
        if($get_days_chk != 0){
            if($t > $f){
                $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                                <a href="#" class="uk-alert-close uk-close"></a>' . "You can&#39;t apply leaves after $get_days_chk Days" . '</div>');
                            $this->redirect('add');
            }
        }
        
        App::import("Model", "LeaveConfiguration");
        $leaveConfi = new LeaveConfiguration();
        $cl_leave_code = $leaveConfi->find('first', array('fields' => array('leave_code'), 'conditions' => array('leave_type' => 'CL')));
        $op_leave_code = $leaveConfi->find('first', array('fields' => array('leave_code'), 'conditions' => array('leave_type' => 'OP')));
        $sl_leave_code = $leaveConfi->find('first', array('fields' => array('leave_code'), 'conditions' => array('leave_type' => 'SL')));
        $lwp_leave_code = $leaveConfi->find('first', array('fields' => array('leave_code'), 'conditions' => array('leave_type' => 'OD')));
        $el_leave_code = $leaveConfi->find('first', array('fields' => array('leave_code'), 'conditions' => array('leave_type' => 'EL')));
        $interval = (strtotime($datetime1) - strtotime($datetime2));
        $days = floor($interval / (60 * 60 * 24)) + 1;
        $msg = $this->EmpDetail->editLeaveConditions($this->data['Leave']['leave_code'], $this->data['Leave']['nu_tot_leaves'], $emp_code, $this->data['Leave']['dt_start_date'], $this->data['Leave']['leaveid']);
        if ($msg == 1) {
            $n = 0;
            for ($i = 0; $i < $days; $i++) {
                $Appleavecount = $this->LeaveDetail->find('all', array(
                    'conditions' => array(
                        "leave_status NOT IN (4,7)", "leave_date" => $datetime_1, 'emp_code' => $emp_code
                    )
                ));
                if (count($Appleavecount) > 0) {
                    $n = $n + 1;
                }
                $datetime_1 = date('Y-m-d', strtotime($datetime_1 . ' +1 day'));
            }

            if ($n > 0) {
                $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                            <a href="#" class="uk-alert-close uk-close"></a>Leave Already Applied for Same Date</div>');
                $this->redirect('/leaves/editSubmit/' . base64_encode($this->data['Leave']['leaveid']));
            } else {
                if ($this->data['Leave']['leave_code'] != 'PAR0000112' && $this->data['leave_code'] !== $lwp_leave_code['LeaveConfiguration']['leave_code']) {

                    $bal = $this->EmpDetail->getBalLeave($emp_code, $this->data['Leave']['leave_code']);
                    $Penleavecount = $this->LeaveDetail->find('count', array(
                        'conditions' => array(
                            'emp_code' => $emp_code,
                            'leave_status IN (2,3,7)',
                            'leave_code' => $this->data['Leave']['leave_code'],
                            'leave_id !=' . $this->data['Leave']['leaveid'],
                            'hlfday_leave_chk' => 'N')
                    ));
                    $halfleavecount = $this->LeaveDetail->find('count', array(
                        'conditions' => array(
                            'emp_code' => $emp_code,
                            'leave_status IN (2,3,6,7)',
                            'leave_code' => $this->data['Leave']['leave_code'],
                            'leave_id !=' . $this->data['Leave']['leaveid'],
                            'hlfday_leave_chk' => 'Y')
                    ));
                    $half = $halfleavecount / 2;
                    $pendings = $Penleavecount + $half;
                    $totalLeave = $this->data['Leave']['nu_tot_leaves'];
                    if ($totalLeave > ($bal - $pendings )) {
                        $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                            <a href="#" class="uk-alert-close uk-close"></a>' . "You can&#39;t apply $totalLeave leaves in $bal Balance Leaves and $pendings Pending Leaves." . '</div>');
                        $this->redirect('/leaves/editSubmit/' . base64_encode($this->data['Leave']['leaveid']));
                    }
                }
                $leavedetails = $this->LeaveDetail->find('all', array(
                    'fields' => array('LeaveDetail.leave_detail_id'),
                    'conditions' => array('LeaveDetail.leave_id' => $this->data['Leave']['leaveid'])
                ));

                foreach ($leavedetails as $leave) {
                    $this->LeaveDetail->delete($leave['LeaveDetail']['leave_detail_id']);
                }
                $save = array();
                if ($_FILES['leave_image']['name'] != '') {
                    $path = "upload/";
                    $name = $_FILES['leave_image']['name'];
                    $ext = end(explode('.', $name));
                    $new_name = date('dmYhis') . $emp_code . "." . $ext;

                    $final_path = $path . $new_name;
                    $type = explode('/', $_FILES['leave_image']['type']);
                    move_uploaded_file($_FILES['leave_image']['tmp_name'], $final_path);
                    $other = 'image';
                }
                $save['leave_id'] = $this->data['Leave']['leaveid'];
                $save['start_date'] = $datetime1;
                $save['end_date'] = $datetime2;
                $save['total_leave'] = $this->data['Leave']['nu_tot_leaves'];
                $lv_val['leave_image'] = $final_path;
                $this->MstEmpLeave->save($save);
                unset($save);
                $this->editsaveLeave($this->data['Leave']['leaveid']);
            }
        } else {
            $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                            <a href="#" class="uk-alert-close uk-close"></a>' . $msg . '</div>');
            $this->redirect('/leaves/editSubmit/' . base64_encode($this->data['Leave']['leaveid']));
        }
    }

    function editsaveLeave($record_id) {
        $startdate = $this->request->data['Leave']['dt_start_date'];
        $enddate = $this->request->data['Leave']['dt_end_date'];
        $date1 = new DateTime($startdate);
        $date2 = new DateTime($enddate);
        $datetime1 = $date1->format('Y-m-d');
        $datetime2 = $date2->format('Y-m-d');
        $interval = (strtotime($datetime2) - strtotime($datetime1));
        $days = floor($interval / (60 * 60 * 24)) + 1;
        $emp_code = $this->Auth->user('emp_code');
        $startdate = date('Y-m-d', strtotime($this->request->data['Leave']['dt_start_date']));
        $leaveeditDetail = $this->LeaveDetail->find('count', array(
            'conditions' => array(
                'emp_code' => $emp_code,
                'leave_id' => $record_id,
                'leave_date' => $datetime1)
        ));
        $week = $this->WeekHolidayList->find('list', array(
            'fields' => array('dt')));
        $holiday = $this->Holiday->find('list', array(
            'fields' => array('holiday_date')));
        $combined = array_merge($week, $holiday);
        $datebefore = date('Y-m-d', strtotime($datetime1 . ' -1 day'));
        $dateafter = date('Y-m-d', strtotime($datetime2 . ' +1 day'));
        $cnt_lv = 0;
        for ($i = 0; $i < 8; $i++) {
            if (in_array($datebefore, $combined)) {
                $datebefore = date('Y-m-d', strtotime($datebefore . ' -1 day'));
                $cnt_lv++;
            }
            if (in_array($dateafter, $combined)) {
                $dateafter = date('Y-m-d', strtotime($dateafter . ' +1 day'));
                $cnt_lv++;
            }
        }
        if ($leaveeditDetail > 0) {
            $this->LeaveDetail->updateAll(
                    array('LeaveDetail.leave_code' => $this->request->data['Leave']['leave_code']), array('LeaveDetail.emp_code' => $emp_code, 'LeaveDetail.leave_date' => $datetime1)
            );
            if ($leave_save) {
                $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                            <a href="#" class="uk-alert-close uk-close"></a>Leave Saved successfully</div>');
                $this->redirect('/leaves/add');
            } else {
                $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                            <a href="#" class="uk-alert-close uk-close"></a>Leave Failed</div>');
                $this->redirect('/leaves/workflow_display/' . $record_id);
            }
        } else {
            $week = $this->WeekHolidayList->find('list', array(
                'fields' => array('dt')));
            for ($i = 0; $i < $days; $i++) {
                if (in_array($datetime1, $week)) {
                } else {
                    if ($this->request->data['Leave']['leave_code'] == $this->cl_leave_code['LeaveConfiguration']['leave_code']) {
                        $leavecheckbefore = $this->LeaveDetail->find('all', array('fields' => array('leave_id', 'leave_code', 'Count(leave_id)'), 'conditions' => array('leave_date' => $datebefore, 'emp_code' => $emp_code, 'leave_status' => array(5, 2, 7, 8))));
                        $leavecheckafter = $this->LeaveDetail->find('all', array('fields' => array('leave_id', 'leave_code', 'Count(leave_id)'), 'conditions' => array('leave_date' => $dateafter, 'emp_code' => $emp_code, 'leave_status' => array(5, 2, 7, 8))));
                        $totleavebefore = $this->LeaveDetail->find('all', array('fields' => array('leave_id', 'leave_code', 'Count(leave_id) tot'), 'conditions' => array('leave_id' => $leavecheckbefore[0]['LeaveDetail']['leave_id'], 'emp_code' => $emp_code, 'leave_status' => array(5, 2, 7, 8)), 'group' => array('leave_id')));
                        $totleaveafter = $this->LeaveDetail->find('all', array('fields' => array('leave_id', 'leave_code', 'Count(leave_id) tot'), 'conditions' => array('leave_id' => $leavecheckafter[0]['LeaveDetail']['leave_id'], 'emp_code' => $emp_code, 'leave_status' => array(5, 2, 7, 8)), 'group' => array('leave_id')));
                        $totalleavecountbefore = $totleaveafter[0][0]['tot'] + $totleavebefore[0][0]['tot'] + $this->request->data['Leave']['nu_tot_leaves'] + $cnt_lv;
                    }
                    if (count($totleavebefore) > 0 && count($totleaveafter) <= 0) {
                        $totalleaveid[] = $totleavebefore[0]['LeaveDetail']['leave_id'];
                    } else if (count($totleaveafter) > 0 && count($totleavebefore) <= 0) {
                        $totalleaveid[] = $totleaveafter[0]['LeaveDetail']['leave_id'];
                    } else if (count($totleavebefore) > 0 && count($totleaveafter) > 0) {
                        $totalleaveid[] = array($totleaveafter[0]['LeaveDetail']['leave_id'], $totleavebefore[0]['LeaveDetail']['leave_id']);
                    }
                    $data_val = array();
                    $data_val['leave_id'] = $record_id;
                    $data_val['leave_date'] = $datetime1;
                    if ($totalleavecountbefore > 5) {
                        $data_val['leave_code'] = $this->el_leave_code['LeaveConfiguration']['leave_code'];
                        $el_id = $this->el_leave_code['LeaveConfiguration']['leave_code'];
                        $alert = 'In case You apply for the Casual Leave in this Senario All Last Consicutive leave will be converted to EL Click Save to Continue Else click Cancel';
                    } else {
                        $alert = 'Leave Saved Successfully';
                        $data_val['leave_code'] = $this->request->data['Leave']['leave_code'];
                    }
                    $data_val['leave_reason'] = $this->request->data['Leave']['vc_leave_reason'];
                    $data_val['applied_date'] = date('Y-m-d');
                    $data_val['leave_status'] = 7;
                    $data_val['shrt_type'] = $this->request->data['short_leave_type'];
                    if (in_array($datetime1, $week_holidays)) {
                        $data_val['week_off_chk'] = 1;
                    } else {
                        $data_val['week_off_chk'] = 0;
                    }
                    if ($this->data['ch_st_daylength'] == "H" && $i == 0) {
                        $data_val['hlfday_leave_chk'] = 'Y';
                        $data_val['half_type'] = $this->data['Leave']['ch_st_dayhalf'];
                    }
                    /* else
                      $data_val['hlfday_leave_chk']='N'; */ 
                    else if ($this->data['ch_ed_daylength'] == "H" && $i == ($days - 1)) {
                        $data_val['hlfday_leave_chk'] = 'Y';
                        $data_val['half_type'] = $this->data['Leave']['ch_ed_dayhalf'];
                    } else
                        $data_val['hlfday_leave_chk'] = 'N';
                    $data_val['emp_code'] = $emp_code;
                    $this->LeaveDetail->create();
                    $this->LeaveDetail->set($data_val);
                    $leave_save = $this->LeaveDetail->save($data_val);
                }

                $datetime1 = date('Y-m-d', strtotime($datetime1 . ' +1 day'));
            }
        }
        if ($leave_save) {
            $this->saveinfomation_skipwf($record_id,$emp_code);
            /*$this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                            <a href="#" class="uk-alert-close uk-close"></a>' . $alert . '</div>');
            $this->redirect('/leaves/workflow_display/' . $record_id . '/' . $el_id . '/' . $totalleaveid[0]); */
        } else {
            $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                            <a href="#" class="uk-alert-close uk-close"></a>Leave Failed</div>');
            $this->redirect('/leaves/add');
        }
    }

    function workflow_display($record_id = null , $emp_code = null, $leave_id = null, $el_id = null) {
        $this->layout = 'employee-new';
        $this->set('emp_code', $emp_code);
        $this->set('leave', $record_id);
        $this->set('leave_code', $el_id);
        $this->set('leave_id', $leave_id);
    }
    function saveinfomation_skipwf($record_id = NULL , $emp_code = NULL) {
       // print_r($this->request->data); die;
        if (!empty($this->request->data)) {
            $emp_code = $this->request->data['LeaveWorkflow']['emp_code'];
            $org_id = $_SESSION['Auth']['MyProfile']['comp_code'];
            $leave_id = $record_id;
            $leave_code = $this->request->data['LeaveWorkflow']['leave_code'];
            $save = array();
            $save['leave_id'] = $record_id;
            $save['emp_code'] = $this->Auth->User('emp_code');
            $user_details = $this->EmpDetail->getemployeeinfomation($this->Auth->User('emp_code'));
            $save['fw_date'] = date('Y-m-d h:i:s');
            if ($this->LeaveWorkflow->save($save)) {
                unset($save);
                $save1 = array();
                $save1['leave_id'] = $record_id;
                $save1['emp_code'] = $emp_code;
                $save1['status'] = 2;
                $this->LeaveWorkflow->create();
                if ($this->LeaveWorkflow->save($save1)) {
                    unset($save1);
                    $this->LeaveDetail->updateAll(
                            array('LeaveDetail.leave_status' => '2'), array('LeaveDetail.leave_id' => $record_id)
                    );
                    $leave_id_check = $this->request->data['LeaveWorkflow']['leave_id'];
                    if($leave_id != '' && $leave_code != ''){
                    $updateleave = $this->LeaveDetail->updateAll(
                                array('LeaveDetail.leave_code' => "'$leave_code'"), array('LeaveDetail.leave_id' => $leave_id)
                        );
                    $leave_id_check = $leave_id;
                        
                    }
                    $leave_data = $this->Common->getLeaveDetail($leave_id_check);
                    $From = $this->Common->getSuportEmailId('01');
                    $data['name'] = 'Sir/Ma`am';
                    $leaveer_name = $this->Common->getEmpDetails($leave_data['MstEmpLeave']['emp_code']);
                    $email_id_send = $this->Common->getEmpEmailId($leave_data['MstEmpLeave']['emp_code']);
                    $mgr_code = $this->Common->getManagerCode($leave_data['MstEmpLeave']['emp_code']);
                    $email_id_mgr = $this->Common->getEmpEmailId($mgr_code);
                    $data['logo'] = 'logo_email.png';
                    //$this->send_mail($From, $email_id_mgr, $email_id_send, 'Leave Applied by - ' . $leaveer_name['MyProfile']['emp_full_name'], 'Leave dated ' . $leave_data['MstEmpLeave']['start_date'] . ' to ' .$leave_data['MstEmpLeave']['end_date']. ' is applied by '.$leaveer_name['MyProfile']['emp_full_name']. ' , Please review the same.', 'default', $data);
           
                    $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                            <a href="#" class="uk-alert-close uk-close"></a>Leave forwarded Successfully</div>');
                    if($leave_data['MstEmpLeave']['by_hr'] == 1){
                        $this->redirect(array('controller' => 'leaves', 'action' => 'view_by_hr')); } else {
                        $this->redirect(array('controller' => 'leaves', 'action' => 'view')); }
                } else {
                    $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                            <a href="#" class="uk-alert-close uk-close"></a>Leave is not forward.</div>');
                    $this->redirect(array('controller' => 'leaves', 'action' => 'view'));
                }
            }
        }
        $this->redirect(array('controller' => 'leaves', 'action' => 'view'));
    }

    function saveinfomation($record_id = NULL , $emp_code = NULL) {
        if (!empty($this->request->data)) {
            $org_id = $_SESSION['Auth']['MyProfile']['comp_code'];
            $leave_id = $this->request->data['LeaveWorkflow']['emp_leave_id'];
            $leave_code = $this->request->data['LeaveWorkflow']['leave_code'];
            $save = array();
            $save['leave_id'] = $this->request->data['LeaveWorkflow']['leave_id'];
            $save['emp_code'] = $this->Auth->User('emp_code');
            $user_details = $this->EmpDetail->getemployeeinfomation($this->Auth->User('emp_code'));
            $save['fw_date'] = date('Y-m-d h:i:s');
            if ($this->LeaveWorkflow->save($save)) {
                unset($save);
                $save1 = array();
                $save1['leave_id'] = $this->request->data['LeaveWorkflow']['leave_id'];
                $save1['emp_code'] = $this->request->data['LeaveWorkflow']['emp_code'];
                
                $save1['status'] = 2;
                $this->LeaveWorkflow->create();
                if ($this->LeaveWorkflow->save($save1)) {
                    unset($save1);
                    $this->LeaveDetail->updateAll(
                            array('LeaveDetail.leave_status' => '2'), array('LeaveDetail.leave_id' => $this->request->data['LeaveWorkflow']['leave_id'])
                    );
                    $leave_id_check = $this->request->data['LeaveWorkflow']['leave_id'];
                    if($leave_id != '' && $leave_code != ''){
                    $updateleave = $this->LeaveDetail->updateAll(
                                array('LeaveDetail.leave_code' => "'$leave_code'"), array('LeaveDetail.leave_id' => $leave_id)
                        );
                    $leave_id_check = $leave_id;
                        
                    }
                    $leave_data = $this->Common->getLeaveDetail($leave_id_check);
                    $From = $this->Common->getSuportEmailId('01');
                    $data['name'] = 'Sir/Ma`am';
                    $leaveer_name = $this->Common->getEmpDetails($leave_data['MstEmpLeave']['emp_code']);
                    $email_id_send = $this->Common->getEmpEmailId($leave_data['MstEmpLeave']['emp_code']);
                    $mgr_code = $this->Common->getManagerCode($leave_data['MstEmpLeave']['emp_code']);
                    $email_id_mgr = $this->Common->getEmpEmailId($mgr_code);
                    $data['logo'] = 'logo_email.png';
                    //$this->send_mail($From, $email_id_mgr, $email_id_send, 'Leave Applied by - ' . $leaveer_name['MyProfile']['emp_full_name'], 'Leave dated ' . $leave_data['MstEmpLeave']['start_date'] . ' to ' .$leave_data['MstEmpLeave']['end_date']. ' is applied by '.$leaveer_name['MyProfile']['emp_full_name']. ' , Please review the same.', 'default', $data);
           
                    $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                            <a href="#" class="uk-alert-close uk-close"></a>Leave forwarded Successfully</div>');
                    if($leave_data['MstEmpLeave']['by_hr'] == 1){
                        $this->redirect(array('controller' => 'leaves', 'action' => 'view')); } else {
                        $this->redirect(array('controller' => 'leaves', 'action' => 'view_by_hr')); }
                } else {
                    $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                            <a href="#" class="uk-alert-close uk-close"></a>Leave is not forward.</div>');
                    $this->redirect(array('controller' => 'leaves', 'action' => 'view'));
                }
            }
        }
        $this->redirect(array('controller' => 'leaves', 'action' => 'view'));
    }

    function approval($val) {
        $this->layout = 'employee-new';
        $org_id = $this->Auth->User('comp_code');
        $emp_code = $this->Auth->User('emp_code');
        if (empty($emp_code)) {
            $this->redirect('view');
        }
        /*if (!$this->Common->check_access_right($this->Auth->User('emp_code'), $this->Auth->User('comp_code'), 'leave_module', 'approval')) {
            $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                            <a href="#" class="uk-alert-close uk-close"></a>You Do not have approval Rights</div>');

            $this->redirect('view');
        } */
        if(!empty($val))
        {
            $dt=$val;
            $this->set('pen_val',$dt);
        }
        else{
 $dt=$this->Common->findpaginateLevel('2');
}
        $designation_code = $_SESSION['Auth']['MyProfile']['desg_code'];
        $dept_code = $_SESSION['Auth']['MyProfile']['dept_code'];
        $this->paginate = array(
            'fields' => array('*'),
            //'limit' => $dt,
            'order' => 'MstEmpLeave.leave_id DESC',
            'group' => array('LeaveDetail.leave_id'),
            'joins' => array(
                array(
                    'table' => 'mst_emp_leaves',
                    'alias' => 'MstEmpLeave',
                    'type' => 'inner',
                    'foreignKey' => false,
                    'conditions' => array('LeaveDetail.leave_id = MstEmpLeave.leave_id')
                ),
                array(
                    'table' => 'leave_workflow',
                    'alias' => 'LeaveWorkflow',
                    'type' => 'inner',
                    'foreignKey' => false,
                    'conditions' => array('LeaveWorkflow.leave_id = LeaveDetail.leave_id')
                )
            ),
            'conditions' => array('LeaveWorkflow.emp_code' => $emp_code, 
                'LeaveWorkflow.status in (2,5)'),
                //array('OR'=>array('LeaveWorkflow.status'=>2),array('LeaveWorkflow.status'=>5))),
            'order'=>'LeaveWorkflow.status'
        );

        $pending_leave_employee = $this->paginate('LeaveDetail');
        $this->set('pending_leave_employee', $pending_leave_employee);
    }

    function rejectleave() {
        $wf_id = $this->params['data']['wf_id'];
        $comp = $this->params['data']['comp_code'];
        $sdate = $this->params['data']['start_date'];
        $edDate = $this->params['data']['end_date'];
        $leave_no = $this->params['data']['leave_no'];
        $rejectreson = $this->params['data']['rejectreson'];

        $save = array();
        $save['leave_status'] = '4';
        $save['leave_id'] = $leave_no;
        $lv_rej = $this->LeaveDetail->updateAll(
                array('LeaveDetail.leave_status' => '4'), array('LeaveDetail.leave_id' => $leave_no)
        );
        if ($lv_rej) {

            $newsave = array();
            $newsave['leave_wf_id'] = $wf_id;
            $newsave['leave_id'] = $leave_no;
            $newsave['emp_code'] = $this->Auth->User('emp_code');
            $newsave['remark'] = $rejectreson;
            $newsave['approval_date'] = date('Y-m-d');
            $newsave['status'] = '4';
            if ($this->LeaveWorkflow->save($newsave)) {
                $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                            <a href="#" class="uk-alert-close uk-close"></a>Leave Rejected Successfully</div>');
                $this->redirect(array('controller' => 'leaves', 'action' => 'approval'));
            }
        }
    }

    function editleave($cmpcode = '', $leaveid = '', $emcode = '') {
        
        $this->layout = 'employee-new';
        $cmpcode_app = base64_decode($cmpcode);
        $leaveid_app = base64_decode($leaveid);
        $empcode_app = base64_decode($emcode);
        $this->set('leave_comp_emp', $cmpcode . '/' . $leaveid . '/' . $emcode);
        $this->paginate = array(
            'fields' => array('*'),
            'joins' => array(
                array(
                    'table' => 'mst_emp_leaves',
                    'alias' => 'MstEmpLeave',
                    'type' => 'inner',
                    'foreignKey' => false,
                    'conditions' => array('LeaveDetail.leave_id = MstEmpLeave.leave_id')
                )
            ),
            'conditions' => array('LeaveDetail.leave_id' => $leaveid_app)
        );
        $empleavedetail = $this->paginate('LeaveDetail');
        $this->employeeLeave($emcode);
        $this->set('empleavedetail', $empleavedetail);
        $app_emp_code = $empleavedetail[0]['LeaveDetail']['emp_code'];

        $this->employeeLeave($app_emp_code);
        $this->employeeLeaveDetail($app_emp_code);
        if (!empty($this->request->data)) {
            $this->redirect('/leaves/leavewf/' . $leaveid_app);
        }
    }

    function leavewf($leaveno = '') {
        //print_r($this->request->data); die;
			if(!empty($this->request->data)){
				App::import("Model", "LeaveConfiguration");
				$leaveConfi = new LeaveConfiguration();
				$lwp_leave_code = $leaveConfi->find('first', array('fields' => array('leave_code'), 'conditions' => array('leave_type' => 'OD')));
				
			$emp_code = $this->request->data['LeaveWorkflow']['emp_code'];
			$bal = $this->EmpDetail->getBalLeave($emp_code, $this->request->data['LeaveWorkflow']['leave_code']);
				if ($this->request->data['LeaveWorkflow']['leave_code'] != 'PAR0000112' && $this->request->data['LeaveWorkflow']['leave_code'] !== $lwp_leave_code['LeaveConfiguration']['leave_code']) {
                
                    $Penleavecount = $this->LeaveDetail->find('count', array(
                        'conditions' => array(
                            'emp_code' => $emp_code,
                            'leave_status IN (2,3,7)',
                            'leave_code' => $this->request->data['LeaveWorkflow']['leave_code'],
                            'hlfday_leave_chk' => 'N')
                    ));
                    $halfleavecount = $this->LeaveDetail->find('count', array(
                        'conditions' => array(
                            'emp_code' => $emp_code,
                            'leave_status IN (2,3,6,7)',
                            'leave_code' => $this->request->data['LeaveWorkflow']['leave_code'],
                            'hlfday_leave_chk' => 'Y')
                    ));
                    $half = $halfleavecount / 2;
                    $pendings = $Penleavecount + $half;
                    $totalLeave = $this->request->data['LeaveWorkflow']['total_leave'];

                    if ($totalLeave > ($bal)) {
                        $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert="">
                            <a href="#" class="uk-alert-close uk-close"></a>' . "You can&#39;t approve $totalLeave leaves in $bal Balance Leaves and $pendings Pending Leaves." . '</div>');
                        $this->redirect('editleave/'
                                            . base64_encode('01')
                                            . '/' . base64_encode($this->request->data['LeaveWorkflow']['leave_id'])
                                            . '/' . base64_encode($this->request->data['LeaveWorkflow']['emp_code']));
                    }
				}
			
			}
		$this->layout = 'employee-new';
        $cnt = count($this->request->data['LeaveWorkflow']['leave_count']);
        $getlvl = $this->LeaveWorkflow->find('count', array('fields' => array('id'), 'conditions' => array('leave_id' => $this->data['LeaveWorkflow']['leave_id'])));
        $applvl = $this->WfMstAppMapLvl->find('first', array('fields' => array('wf_max_lvl'), 'conditions' => array('wf_app_id' => 2)));
		if ($this->request->data) {
            $this->set('leavetype', $this->request->data['LeaveWorkflow']['leave_code']);
        }
		if (empty($leaveno))
            $leaveno = $this->request->data['LeaveWorkflow']['leave_id'];
        else
            $leaveno = $leaveno;

        $this->set('leave', $leaveno);
        $check = $this->LeaveDetail->find('first', array('conditions' => array('leave_id' => $leaveno)));
		$this->set('leaveStatus', $check['LeaveDetail']['leave_status']);
        $LeaveWorkflowid = $this->LeaveWorkflow->find('all', array('fields'=>array('MAX(leave_wf_id) as leave_wf_id'),
           'conditions' => array('LeaveWorkflow.emp_code' => $this->Auth->user('emp_code'), 'LeaveWorkflow.leave_id' => $leaveno)));
		$this->set('LeaveWorkflowid', $LeaveWorkflowid);
        $ckcount = $this->LeaveWorkflow->checkstatus($this->Auth->user('emp_code'), $leaveno);
		if ($ckcount > 0) {
            $this->redirect(array('controller' => 'leaves', 'action' => 'approval'));
        }
    }

    function leavewfsaveinfo() {
        //print_r($this->request->data); die;
		if (!empty($this->request->data)) {
			$org_id = $_SESSION['Auth']['MyProfile']['comp_code'];
            //============== Forward==================
            if ($this->request->data['LeaveWorkflow']['type'] == 2) {
                $save = array();
                $save['leave_wf_id'] = $this->request->data['LeaveWorkflow']['id'];
                $save['remark'] = $this->request->data['LeaveWorkflow']['forward_remark'];
                $save['fw_date'] = date('Y-m-d');
                $save['status'] = 2;
		$this->LeaveWorkflow->save($save);
                unset($save);
                $check = $this->LeaveWorkflow->find('first', array('conditions' => array(
                        'leave_id' => $this->request->data['LeaveWorkflow']['leave_id'],
                        'emp_code' => $this->request->data['LeaveWorkflow']['forward_emp_code'])));

                if (empty($check)) {
                    $save1 = array();
                    $save1['leave_id'] = $this->request->data['LeaveWorkflow']['leave_id'];
                    $save1['emp_code'] = $this->request->data['LeaveWorkflow']['forward_emp_code'];
                    $this->LeaveWorkflow->create();
                    $this->LeaveWorkflow->save($save1);
                    unset($save1);
                } else {
                    $remark = $this->request->data['LeaveWorkflow']['forward_remark'];
                    $this->LeaveWorkflow->updateAll(array('status' => null), array(
                        'leave_id' => $this->request->data['LeaveWorkflow']['leave_id'],
                        'emp_code' => $this->request->data['LeaveWorkflow']['forward_emp_code']));
					$lv_cd = $this->request->data['LeaveWorkflow']['leave_type'];
					$this->LeaveDetail->updateAll(array('leave_status' => 2, 'remark' => "'.$remark.'",'leave_code'=> "'$lv_cd'"), 
					array('leave_id' => $check['LeaveWorkflow']['leave_id']));
                }
                    $From = $this->Common->getSuportEmailId('01');
                    $leave_data = $this->Common->getLeaveDetail($this->request->data['LeaveWorkflow']['leave_id']);
                    $forward_name = $this->Common->getEmpDetails($this->Auth->User('emp_code'));
                    $data['name'] = 'Sir/Ma`am';
                    $leaveer_name = $this->Common->getEmpDetails($leave_data['MstEmpLeave']['emp_code']);
                    $email_id_send = $this->Common->getEmpEmailId($leave_data['MstEmpLeave']['emp_code']);
                    $email_id_mgr = $this->Common->getEmpEmailId($this->request->data['LeaveWorkflow']['forward_emp_code']);
                    $data['logo'] = 'logo_email.png';
                    //$this->send_mail($From, $email_id_mgr, $email_id_send, 'Leave by - ' . $leaveer_name['MyProfile']['emp_full_name'], 'Leave dated ' . $leave_data['MstEmpLeave']['start_date'] . ' to ' .$leave_data['MstEmpLeave']['end_date']. ' of ' .$leaveer_name['MyProfile']['emp_full_name']. ' is forwarded by '.$forward_name['MyProfile']['emp_full_name']. ' , Please review the same.', 'default', $data);
           
                $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                            <a href="#" class="uk-alert-close uk-close"></a>Leave Forwarded Successfully</div>');
                $this->redirect(array('controller' => 'leaves', 'action' => 'approval'));
            } else if ($this->request->data['LeaveWorkflow']['type'] == 3) {
                $save1 = array();
                $save = array();
                $save['leave_wf_id'] = $this->request->data['LeaveWorkflow']['id'];
                $save['remark'] = $this->request->data['LeaveWorkflow']['revert_remark'];
                $save['status'] = 3;
                $save['fw_date'] = '';
                $this->LeaveWorkflow->save($save);
                $check = $this->LeaveWorkflow->find('first', array('conditions' => array(
                        'leave_id' => $this->request->data['LeaveWorkflow']['leave_id'],
                        'emp_code' => $this->request->data['LeaveWorkflow']['revert_emp_code'])));
                if (empty($check)) {
                    $save1['leave_id'] = $this->request->data['LeaveWorkflow']['leave_id'];
                    $save1['emp_code'] = $this->request->data['LeaveWorkflow']['revert_emp_code'];
                    $save1['status'] = 3;
                    $this->LeaveWorkflow->save($save1);
                } else {
                    $revert_reason = $this->request->data['LeaveWorkflow']['revert_remark'];
                    $this->LeaveWorkflow->updateAll(array('fw_date' => null), array('leave_wf_id' => $check['LeaveWorkflow']['leave_wf_id']));
                    $this->LeaveDetail->updateAll(array('LeaveDetail.leave_status' => '3', 'remark' => "'$revert_reason'"), array('LeaveDetail.leave_id' => $this->request->data['LeaveWorkflow']['leave_id'])
                    );
                }
                unset($save1);
                unset($save);
                    $From = $this->Common->getSuportEmailId('01');
                    $leave_data = $this->Common->getLeaveDetail($this->request->data['LeaveWorkflow']['leave_id']);
                    $forward_name = $this->Common->getEmpDetails($this->Auth->User('emp_code'));
                    $data['name'] = 'Sir/Ma`am';
                    $leaveer_name = $this->Common->getEmpDetails($leave_data['MstEmpLeave']['emp_code']);
                    $email_id_send = $this->Common->getEmpEmailId($leave_data['MstEmpLeave']['emp_code']);
                    $email_id_mgr = $this->Common->getEmpEmailId($this->request->data['LeaveWorkflow']['revert_emp_code']);
                    $data['logo'] = 'logo_email.png';
                    //$this->send_mail($From, $email_id_mgr, $email_id_send, 'Leave by - ' . $leaveer_name['MyProfile']['emp_full_name'], 'Leave dated ' . $leave_data['MstEmpLeave']['start_date'] . ' to ' .$leave_data['MstEmpLeave']['end_date']. ' of ' .$leaveer_name['MyProfile']['emp_full_name']. ' is Reverted by '.$forward_name['MyProfile']['emp_full_name']. ' , Please review the same.', 'default', $data);
           
                $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                            <a href="#" class="uk-alert-close uk-close"></a>Leave Revert.</div>');
                $this->redirect(array('controller' => 'leaves', 'action' => 'approval'));
            } else if ($this->request->data['LeaveWorkflow']['type'] == 4) {
                $remark = $this->request->data['LeaveWorkflow']['reject_remark'];
                $lv_rej = $this->LeaveDetail->updateAll(
                        array('LeaveDetail.leave_status' => '4', 'remark' => "'$remark'"), array('LeaveDetail.leave_id' => $this->request->data['LeaveWorkflow']['leave_id']));
                $lv_rej_below = $this->LeaveWorkflow->updateAll(
                        array(
                    'LeaveWorkflow.status' => 4), array(
                    'LeaveWorkflow.leave_id' => $this->request->data['LeaveWorkflow']['leave_id']));
                if ($lv_rej) {
                    $newsave = array();
                    $newsave['leave_wf_id'] = $this->request->data['LeaveWorkflow']['id'];
                    $newsave['leave_id'] = $this->request->data['LeaveWorkflow']['leave_id'];
                    $newsave['emp_code'] = $this->Auth->User('emp_code');
                    $newsave['remark'] = $this->request->data['LeaveWorkflow']['reject_remark'];
                    $newsave['approval_date'] = date('Y-m-d');
                    $newsave['status'] = '4';
                    $this->LeaveWorkflow->save($newsave);
                    $From = $this->Common->getSuportEmailId('01');
                    $leave_data = $this->Common->getLeaveDetail($this->request->data['LeaveWorkflow']['leave_id']);
                    $forward_name = $this->Common->getEmpDetails($this->Auth->User('emp_code'));
                    $data['name'] = 'Sir/Ma`am';
                    $leaveer_name = $this->Common->getEmpDetails($leave_data['MstEmpLeave']['emp_code']);
                    $email_id_send = $this->Common->getEmpEmailId($leave_data['MstEmpLeave']['emp_code']);
                    $email_id_mgr = $this->Common->getEmpEmailId($this->request->data['LeaveWorkflow']['revert_emp_code']);
                    $data['logo'] = 'logo_email.png';
                    //$this->send_mail($From, $email_id_send, $email_id_mgr, 'Leave by - ' . $leaveer_name['MyProfile']['emp_full_name'], 'Leave dated ' . $leave_data['MstEmpLeave']['start_date'] . ' to ' .$leave_data['MstEmpLeave']['end_date']. ' of ' .$leaveer_name['MyProfile']['emp_full_name']. ' is Rejected by '.$forward_name['MyProfile']['emp_full_name']. '.', 'default', $data);
           
                    $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                            <a href="#" class="uk-alert-close uk-close"></a>Leave Rejected Successfully</div>');
                    $this->redirect(array('controller' => 'leaves', 'action' => 'approval'));
                }
            } else if ($this->request->data['LeaveWorkflow']['type'] == 6) {
                $save = array();
                $save['leave_wf_id'] = $this->request->data['LeaveWorkflow']['id'];
                $save['remark'] = $this->request->data['LeaveWorkflow']['hr_forward_remark'];
                $save['fw_date'] = date('Y-m-d');
                $save['status'] = 2;
		$this->LeaveWorkflow->save($save);
                unset($save);
                $lv_app = $this->LeaveDetail->updateAll(
                        array('LeaveDetail.leave_status' => '6'), array('LeaveDetail.leave_id' => $this->request->data['LeaveWorkflow']['leave_id'])
                );
                $newsave = array();
                $newsave['leave_id'] = $this->request->data['LeaveWorkflow']['leave_id'];
                $newsave['emp_code'] = $this->request->data['LeaveWorkflow']['hr_emp_code'];
                $newsave['status'] = 2;
                $this->LeaveWorkflow->create();
                $this->LeaveWorkflow->save($newsave);
                $lv_cd = $this->request->data['LeaveWorkflow']['leave_type'];
				$lv_app = $this->LeaveDetail->updateAll(
                        array('LeaveDetail.leave_status' => '2', 'remark' => "'$rem'",'LeaveDetail.leave_code'=> "'$lv_cd'"), array('LeaveDetail.leave_id' => $this->request->data['LeaveWorkflow']['leave_id'])
                );
                    $From = $this->Common->getSuportEmailId('01');
                    $leave_data = $this->Common->getLeaveDetail($this->request->data['LeaveWorkflow']['leave_id']);
                    $forward_name = $this->Common->getEmpDetails($this->Auth->User('emp_code'));
                    $data['name'] = 'Sir/Ma`am';
                    $leaveer_name = $this->Common->getEmpDetails($leave_data['MstEmpLeave']['emp_code']);
                    $email_id_send = $this->Common->getEmpEmailId($leave_data['MstEmpLeave']['emp_code']);
                    $email_id_mgr = $this->Common->getEmpEmailId($this->request->data['LeaveWorkflow']['hr_emp_code']);
                    $data['logo'] = 'logo_email.png';
                    //$this->send_mail($From, $email_id_mgr, $email_id_send, 'Leave by - ' . $leaveer_name['MyProfile']['emp_full_name'], 'Leave dated ' . $leave_data['MstEmpLeave']['start_date'] . ' to ' .$leave_data['MstEmpLeave']['end_date']. ' of ' .$leaveer_name['MyProfile']['emp_full_name']. ' is forwarded by '.$forward_name['MyProfile']['emp_full_name']. ' to HR Department.', 'default', $data);
           
                $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                            <a href="#" class="uk-alert-close uk-close"></a>Leave Forwarded to HR </div>');
                $this->redirect(array('controller' => 'leaves', 'action' => 'approval'));
            } else if ($this->request->data['LeaveWorkflow']['type'] == 5) {
                $rem = $this->data['LeaveWorkflow']['approve_remark'];
				$lv_cd = $this->request->data['LeaveWorkflow']['leave_type'];
				$lv_app = $this->LeaveDetail->updateAll(
                        array('LeaveDetail.leave_status' => '5', 'remark' => "'$rem'",'LeaveDetail.leave_code'=> "'$lv_cd'"), array('LeaveDetail.leave_id' => $this->request->data['LeaveWorkflow']['leave_id'])
                );
                if ($lv_app) {
                    $newsave = array();
                    $newsave['leave_wf_id'] = $this->request->data['LeaveWorkflow']['id'];
                    $newsave['leave_id'] = $this->request->data['LeaveWorkflow']['leave_id'];
                    $newsave['emp_code'] = $this->Auth->User('emp_code');
                    $newsave['remark'] = $this->request->data['LeaveWorkflow']['approve_remark'];
                    $newsave['approval_date'] = date('Y-m-d');
                    $newsave['status'] = '5';
                    $this->LeaveWorkflow->save($newsave);
                }
                $allLeaves = $this->LeaveDetail->find('all', array('conditions' => array('leave_id' => $this->request->data['LeaveWorkflow']['leave_id'], 'week_off_chk' => 0)));
                foreach ($allLeaves as $k => $val) {
                    $check = $this->MstEmpLeaveAllot->find('first', array('conditions' => array(
                            'emp_code' => $val['LeaveDetail']['emp_code'],
                            'leave_code' => $val['LeaveDetail']['leave_code']
                    )));
                    $this->MstEmpLeaveAllot->updateAll(array(
                        'leave_bal' => 'leave_bal-1'
                            ), array(
                        'emp_code' => $val['LeaveDetail']['emp_code'],
                        'leave_code' => $val['LeaveDetail']['leave_code']
                    ));
                }
                $approveworkflow = $this->LeaveWorkflow->updateAll(
                        array('status' => '5'), array('LeaveWorkflow.leave_id' => $this->request->data['LeaveWorkflow']['leave_id'])
                );
                
                    $From = $this->Common->getSuportEmailId('01');
                    $leave_data = $this->Common->getLeaveDetail($this->request->data['LeaveWorkflow']['leave_id']);
                    $forward_name = $this->Common->getEmpDetails($this->Auth->User('emp_code'));
                    $data['name'] = 'Sir/Ma`am';
                    $leaveer_name = $this->Common->getEmpDetails($leave_data['MstEmpLeave']['emp_code']);
                    $email_id_send = $this->Common->getEmpEmailId($leave_data['MstEmpLeave']['emp_code']);
                    $email_id_mgr = $this->Common->getEmpEmailId($leaveer_name['MyProfile']['manager_code']);
                    $data['logo'] = 'logo_email.png';
                    //$this->send_mail($From, $email_id_send, $email_id_mgr, 'Leave Approved - ' . $leaveer_name['MyProfile']['emp_full_name'], 'Leave dated ' . $leave_data['MstEmpLeave']['start_date'] . ' to ' .$leave_data['MstEmpLeave']['end_date']. ' of ' .$leaveer_name['MyProfile']['emp_full_name']. ' is approved by '.$forward_name['MyProfile']['emp_full_name'], 'default', $data);
           
                $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                            <a href="#" class="uk-alert-close uk-close"></a>Leave Approved Successfully</div>');

                $this->redirect(array('controller' => 'leaves', 'action' => 'approval'));
            }
        }
        $this->redirect(array('controller' => 'leaves', 'action' => 'approval'));
    }
    
    function approvedleaves($id) {

        try {
            $ldetails = $this->LeaveDetail->find('all', array(
                'fields' => array('*'),
                'conditions' => array('LeaveDetail.emp_code' => $id, 'LeaveDetail.leave_status' => 5)
            ));
            $this->set('ldetails', $ldetails);
            $this->layout = "";
        } catch (Exception $e) {
            
        }
    }

    function appliedleave($startdate, $enddate, $emp_code) {
        $startdate = new DateTime($startdate);
        $start = $startdate->format('Y-m-d');
        $enddate = new DateTime($enddate);
        $diff = date_diff($enddate, $startdate);
        $days = $diff->days;
        for ($i = 0; $i <= $days; $i++) {
            $leaveapp[] = $this->LeaveDetail->find('all', array(
                'fields' => array('*'),
                'conditions' => array("LeaveDetail.leave_date" => $start, 'LeaveDetail.leave_status IN(2,5,7)', 'emp_code !=' . $emp_code)
            ));
            $start = date('Y-m-d', strtotime($start . ' +1 day'));
        }
        //print_r($leaveapp); die;
        $this->set('leaveapp', $leaveapp);
        $this->layout = "";
        $this->render('appliedleave');
    }

    function leaveencash() {
        $this->layout = 'employee-new';
        $emp_code = $this->Auth->User('emp_code');
        $desg_code = $_SESSION['Auth']['MyProfile']['desg_code'];
        $grpid = $_SESSION['Auth']['MyProfile']['emp_grp_id'];
        $comp_code = $_SESSION['Auth']['MyProfile']['comp_code'];
        $firstname = $_SESSION['Auth']['MyProfile']['emp_firstname'];
        $emp_name = $_SESSION['Auth']['MyProfile']['emp_full_name'];
        $lastname = $_SESSION['Auth']['MyProfile']['emp_lastname'];
        $emp_id = $_SESSION['Auth']['MyProfile']['emp_id'];
        $gender = $_SESSION['Auth']['MyProfile']['gender'];
        $date = date('Y-m-d');
        $time = strtotime($date);
        $year = date("Y", $time);
        $checkencsh = $this->LeaveEncshDt->find('first', array('conditions' => array('year(created_at)' => $year, 'leaveencash_status NOT IN(4)', 'emp_code' => $this->Auth->User('emp_code'))));
        $this->set('checkencsh', $checkencsh);
        $this->set('firstname', $firstname);
        $this->set('emp_id', $emp_id);
        $this->set('lastname', $lastname);
        $this->set('emp_name', $emp_name);
        $this->set('gender', $gender);
        $this->set('desgcode', $desg_code);
        $leave_enchtype = $this->LeaveGrp->find('all', array('fields' => array
                ('LeaveGrp.leave_code', 'LeaveGrp.leave_encash_limit'),
            'conditions' => array('leave_encash_ch' => 'Y', 'grp_id' => $grpid, 'org_id' => $comp_code))
        );
        foreach ($leave_enchtype as $type) {
            $leavetyp[] = $this->OptionAttribute->find('list', array(
                'fields' => array('id', 'name'), 'conditions' => array('id' => $type['LeaveGrp']['leave_code'])));
        }
        $merge = array_merge($leavetyp);
        $this->set('leavetype', $leavetyp);
        if (!empty($this->data)) {
            if (!empty($checkencsh)) {
                $this->redirect('leaveencash');
            } else {
                $ench = array();
                $encsh_amt = $this->data['leaveencash']['noofleavestoencash'] * $this->data['saloneday'];
                $ench['comp_code'] = $this->Auth->User('comp_code');
                $ench['emp_code'] = $this->Auth->User('emp_code');
                $ench['dept_code'] = $_SESSION['Auth']['MyProfile']['dept_code'];
                $ench['desg_code'] = $_SESSION['Auth']['MyProfile']['desg_code'];
                $grp_id = $this->MyProfile->find('first', array('fields' => array('emp_grp_id', 'doc_id'), 'conditions' => array('emp_code' => $this->Auth->User('emp_code'), 'comp_code' => $this->Auth->User('comp_code'))));
                $ench['emp_grp_id'] = $grp_id['MyProfile']['emp_grp_id'];
                $ench['emp_doc_id'] = $grp_id['MyProfile']['doc_id'];
                $ench['encsh_amt'] = $encsh_amt;
                $ench['doc_dt'] = date('y-m-d');
                $ench['encsh_status'] = 1;
                $this->LeaveEncsh->create();
                if ($this->LeaveEncsh->save($ench)) {
                    $leavecode = $this->OptionAttribute->find('first', array('fields' => array('OptionAttribute.id'), 'conditions' => array('OptionAttribute.name' => $this->data['leavetype'])));
                    $mstempallot = $this->MstEmpLeaveAllot->find('first', array('conditions' => array('leave_code' => $leavecode['OptionAttribute']['id'], 'emp_code' => $this->Auth->User('emp_code'))));
                    if (!empty($mstempallot))
                        $leave_op = $mstempallot['MstEmpLeaveAllot']['leave_op'];
                    else
                        $leave_op = 0;
                    $dt_ench = array();
                    $dt_ench['comp_code'] = $this->Auth->User('comp_code');
                    $dt_ench['emp_code'] = $this->Auth->User('emp_code');
                    $dt_ench['emp_doc_id'] = $grp_id['MyProfile']['doc_id'];
                    $dt_ench['leave_id'] = $leavecode['OptionAttribute']['id'];
                    $dt_ench['leave_encash_limit'] = $this->data['maxlimit'];
                    $dt_ench['leave_op'] = $leave_op;
                    $dt_ench['leave_avail'] = $this->data['leaveencash']['noofleavestoencash'];
                    $dt_ench['leave_bal'] = $this->data['leavepen'] - $this->data['leaveencash']['noofleavestoencash'];
                    $dt_ench['encsh_amt'] = $encsh_amt;
                    $dt_ench['created_at'] = date('Y-m-d');
                    $dt_ench['leaveencash_status'] = 1;
                    $dt_ench['leave_encsh_id'] = $this->LeaveEncsh->getLastInsertID();
                    $this->LeaveEncshDt->create();
                    if ($this->LeaveEncshDt->save($dt_ench)) {
                        $record_id = $this->LeaveEncsh->getLastInsertID();
                        $this->redirect('/leaves/encash_workflow_display/' . $record_id);
                        $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                            <a href="#" class="uk-alert-close uk-close"></a>Leave Submitted to Manager Sucessfully>/div>');
                    }
                }
            }
        }
    }

    function encash_workflow_display($id) {
        $this->layout = 'employee-new';
        $this->set('leaveencash', $id);
    }

    function pendingEncashment() {
        $this->layout = 'employee-new';
        $org_id = $this->Auth->User('comp_code');
        $emp_code = $this->Auth->User('emp_code');
        if (empty($emp_code)) {
            $this->redirect('encashview');
        }
        $designation_code = $_SESSION['Auth']['MyProfile']['desg_code'];

        $dept_code = $_SESSION['Auth']['MyProfile']['dept_code'];
        $this->paginate = array(
            'fields' => array('*'),
            'limit' => 10,
            'order' => 'LeaveEncsh.id DESC',
            'joins' => array(
                array(
                    'table' => 'leave_encsh',
                    'alias' => 'LeaveEncsh',
                    'type' => 'inner',
                    'foreignKey' => false,
                    'conditions' => array('LeaveEncshDt.leave_encsh_id = LeaveEncsh.id')
                ),
                array(
                    'table' => 'leave_encashment_workflow',
                    'alias' => 'LeaveEncshWorkflow',
                    'type' => 'inner',
                    'foreignKey' => false,
                    'conditions' => array('LeaveEncshWorkflow.leave_encsh_id = LeaveEncshDt.leave_encsh_id')
                )
            ),
            'conditions' => array('LeaveEncshWorkflow.emp_code' => $emp_code, 'LeaveEncsh.emp_code != ' . $emp_code, 'LeaveEncshWorkflow.fw_date ' => NULL)
                //'order'=>array('LvMstId.id desc')
        );
        $pending_encsh_dt = $this->paginate('LeaveEncshDt');
        $this->set('pending_encsh_dt', $pending_encsh_dt);
    }

    function saveencashinformation() {

        if (!empty($this->request->data)) {
            $save = array();
            $save['leave_encsh_id'] = $this->request->data['LeaveEncashWorkflow']['leaveencash'];
            $save['emp_code'] = $this->Auth->User('emp_code');
            $save['fw_date'] = date('Y-m-d h:i:s');
            $this->LeaveEncashmentWorkflow->create();
            if ($this->LeaveEncashmentWorkflow->save($save)) {
                unset($save);
                $save1 = array();
                $save1['leave_encsh_id'] = $this->request->data['LeaveEncashWorkflow']['leaveencash'];
                $save1['emp_code'] = $this->request->data['LeaveEncashWorkflow']['emp_code'];
                $this->LeaveEncashmentWorkflow->create();
                if ($this->LeaveEncashmentWorkflow->save($save1)) {
                    unset($save1);
                    //update values if it is not new
                    $this->LeaveEncshDt->updateAll(
                            array('LeaveEncshDt.leaveencash_status' => '2'), array('LeaveEncshDt.leave_encsh_id' => $this->request->data['LeaveEncashWorkflow']['leaveencash'])
                    );
                    $this->LeaveEncsh->updateAll(
                            array('LeaveEncsh.encsh_status' => '2'), array('LeaveEncsh.id' => $this->request->data['LeaveEncashWorkflow']['leaveencash'])
                    );
                    $leave_avail = $this->LeaveEncshDt->find('first', array(
                        'fields' => array('*'),
                        'conditions' => array('LeaveEncshDt.leave_encsh_id' => $this->request->data['LeaveEncashWorkflow']['leaveencash'])
                    ));
                    $leave_avail_amt = $leave_avail['LeaveEncshDt']['leave_avail'];

                    $mst_allot_leave_deduct = $this->MstEmpLeaveAllot->updateAll(
                            array('MstEmpLeaveAllot.leave_bal' => "MstEmpLeaveAllot.leave_bal - $leave_avail_amt"), array('MstEmpLeaveAllot.emp_code' => $leave_avail['LeaveEncshDt']['emp_code'], 'MstEmpLeaveAllot.leave_code' => $leave_avail['LeaveEncshDt']['leave_id'])
                    );

                    $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                            <a href="#" class="uk-alert-close uk-close"></a>Leave Encashment Forwarded.</div>');
                    $this->redirect(array('controller' => 'leaves', 'action' => 'encashview'));
                } else {
                    $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                            <a href="#" class="uk-alert-close uk-close"></a>Leave Encashment is not forward.</div>');
                    $this->redirect(array('controller' => 'leaves', 'action' => 'leaveencash'));
                }
            }
        }
        $this->redirect(array('controller' => 'leaves', 'action' => 'leaveencash'));
    }

    function leaveEncshWf($leave_encsh_id) {
        $this->layout = 'employee-new';
        $leave_encsh_id = base64_decode($leave_encsh_id);
        $check = $this->LeaveEncshDt->find('first', array('conditions' => array('leave_encsh_id' => $leave_encsh_id)));
        $this->set('LeaveEncshStatus', $check['LeaveEncshDt']['leaveencash_status']);
        $LeaveEncshWorkflowid = $this->LeaveEncashmentWorkflow->find('first', array(
            'conditions' => array('LeaveEncashmentWorkflow.emp_code' => $this->Auth->User('emp_code'), 'LeaveEncashmentWorkflow.leave_encsh_id' => $leave_encsh_id)));
        $LeaveEncshid = $LeaveEncshWorkflowid['LeaveEncashmentWorkflow']['id'];
        $this->set('LeaveEncshid', $leave_encsh_id);
        $this->set('LeaveEncshWorkflowid', $LeaveEncshid);
    }

    function leaveencshwfsaveinfo() {

        if (!empty($this->request->data)) {
            $org_id = $_SESSION['Auth']['MyProfile']['comp_code'];
            //============== Forward==================
            if ($this->request->data['LeaveEncashmentWorkflow']['type'] == 2) {
                $this->LeaveEncshDt->updateAll(array('leaveencash_status' => 2), array('leave_encsh_id' => $check['LeaveEncashmentWorkflow']['leave_encsh_id']));
                $this->LeaveEncsh->updateAll(array('encsh_status' => 2), array('id' => $check['LeaveEncashmentWorkflow']['leave_encsh_id']));
                $save = array();
                $save['id'] = $this->request->data['LeaveEncashmentWorkflow']['id'];
                $save['remark'] = $this->request->data['LeaveEncashmentWorkflow']['forward_remark'];
                $save['fw_date'] = date('Y-m-d');
                $save['encash_status'] = 2;
                $this->LeaveEncashmentWorkflow->save($save);
                unset($save);
                $check = $this->LeaveEncashmentWorkflow->find('first', array('conditions' => array(
                        'leave_encsh_id' => $this->request->data['LeaveEncashmentWorkflow']['leave_encsh_id'],
                        'emp_code' => $this->request->data['LeaveEncashmentWorkflow']['forward_emp_code'])));

                if (empty($check)) {
                    $save1 = array();
                    $save1['leave_encsh_id'] = $this->request->data['LeaveEncashmentWorkflow']['leave_encsh_id'];
                    $save1['emp_code'] = $this->request->data['LeaveEncashmentWorkflow']['forward_emp_code'];
                    $this->LeaveEncashmentWorkflow->create();
                    $this->LeaveEncashmentWorkflow->save($save1);
                    unset($save1);
                } else {
                    $remark = $this->request->data['LeaveEncashmentWorkflow']['forward_remark'];
                    $this->LeaveEncashmentWorkflow->updateAll(array('encash_status' => null), array(
                        'leave_encsh_id' => $this->request->data['LeaveEncashmentWorkflow']['leave_encsh_id'],
                        'emp_code' => $this->request->data['LeaveEncashmentWorkflow']['forward_emp_code']));
                }

                $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                            <a href="#" class="uk-alert-close uk-close"></a>Leave Encashment forward Successfully.</div>');
                $this->redirect(array('controller' => 'leaves', 'action' => 'pendingEncashment'));
            } else if ($this->request->data['LeaveEncashmentWorkflow']['type'] == 4) {

                $lv_rej = $this->LeaveEncshDt->updateAll(
                        array('LeaveEncshDt.leaveencash_status' => 4), array('LeaveEncshDt.leave_encsh_id' => $this->request->data['LeaveEncashmentWorkflow']['leave_encsh_id']));

                $lv_rej = $this->LeaveEncsh->updateAll(
                        array('LeaveEncsh.encsh_status' => 4), array('LeaveEncsh.id' => $this->request->data['LeaveEncashmentWorkflow']['leave_encsh_id'])
                );
                $leave_encsh_dt = $this->LeaveEncshDt->find('first', array(
                    'fields' => array('leave_avail', 'leave_id', 'emp_code'),
                    'conditions' => array('leave_encsh_id' => $this->request->data['LeaveEncashmentWorkflow']['leave_encsh_id']),
                ));
                $leave_avail = $leave_encsh_dt['LeaveEncshDt']['leave_avail'];
                $mst_allot_leave_deduct = $this->MstEmpLeaveAllot->updateAll(
                        array('MstEmpLeaveAllot.leave_bal' => "MstEmpLeaveAllot.leave_bal + $leave_avail"), array('MstEmpLeaveAllot.emp_code' => $leave_encsh_dt['LeaveEncshDt']['emp_code'], 'MstEmpLeaveAllot.leave_code' => $leave_encsh_dt['LeaveEncshDt']['leave_id']));

                if ($lv_rej) {
                    $newsave = array();
                    $newsave['id'] = $this->request->data['LeaveEncashmentWorkflow']['id'];
                    $newsave['leave_encsh_id'] = $this->request->data['LeaveEncashmentWorkflow']['leave_encsh_id'];
                    $newsave['emp_code'] = $this->Auth->User('emp_code');
                    $newsave['remark'] = $this->request->data['LeaveEncashmentWorkflow']['reject_remark'];
                    $newsave['approval_date'] = date('Y-m-d');
                    $newsave['encash_status'] = 4;
                    $this->LeaveEncashmentWorkflow->save($newsave);
                    $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                            <a href="#" class="uk-alert-close uk-close"></a>LeaveEncashment Rejected Successfully</div>');
                    $this->redirect(array('controller' => 'leaves', 'action' => 'pendingEncashment'));
                }
            } else if ($this->request->data['LeaveEncashmentWorkflow']['type'] == 5) {
                $mstLeave = $this->LeaveEncsh->find('first', array('conditions' => array('id' => $this->request->data['LeaveEncashmentWorkflow ']['leave_encsh_id'])));

                $lv_app = $this->LeaveEncshDt->updateAll(
                        array('LeaveEncshDt.leaveencash_status' => 5), array('LeaveEncshDt.leave_encsh_id' => $this->request->data['LeaveEncashmentWorkflow']['leave_encsh_id'])
                );

                $lv_app = $this->LeaveEncsh->updateAll(
                        array('LeaveEncsh.encsh_status' => 5), array('LeaveEncsh.id' => $this->request->data['LeaveEncashmentWorkflow']['leave_encsh_id'])
                );


                if ($lv_app) {
                    $newsave = array();
                    $newsave['id'] = $this->request->data['LeaveEncashmentWorkflow']['id'];
                    $newsave['leave_encsh_id'] = $this->request->data['LeaveEncashmentWorkflow']['leave_encsh_id'];
                    $newsave['emp_code'] = $this->Auth->User('emp_code');
                    $newsave['remark'] = $this->request->data['LeaveEncashmentWorkflow']['approve_remark'];
                    $newsave['approval_date'] = date('Y-m-d');
                    $newsave['encash_status'] = 5;

                    $this->LeaveEncashmentWorkflow->save($newsave);
                }

                $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                            <a href="#" class="uk-alert-close uk-close"></a>Leave Encashed Approved Successfully</div>');

                $this->redirect(array('controller' => 'leaves', 'action' => 'pendingEncashment'));
            }
        }
        $this->redirect(array('controller' => 'leaves', 'action' => 'pendingEncashment'));
    }

    function leaveencshajax($leavetype) {

        $this->layout = false;
        $desg_code = $_SESSION['Auth']['MyProfile']['emp_grp_id'];
        $leavetyp = $this->OptionAttribute->find('first', array(
            'fields' => array('name'),
            'conditions' => array('OptionAttribute.id' => $leavetype)));
        $this->set('leavetypename', $leavetyp['OptionAttribute']['name']);

        $leave_enchtype = $this->LeaveGrp->find('first', array('fields' => array
                ('LeaveGrp.leave_code', 'LeaveGrp.leave_encash_limit'),
            'conditions' => array('leave_encash_ch' => 'Y', 'grp_id' => $desg_code, 'leave_code' => $leavetype))
        );
        $this->set('max', $leave_enchtype['LeaveGrp']['leave_encash_limit']);
        $countleave = $this->LeaveDetail->find('count', array('fields' => array('id'),
            'conditions' => array('leave_code' => $leavetype, 'emp_code' => $this->Auth->User('emp_code'), 'leave_status IN(5,2,7,3)')
        ));
        $totallotedleave = $this->MstEmpLeaveAllot->find('first', array('fields' =>
            array('leave_bal'),
            'conditions' => array('leave_code' => $leavetype, 'emp_code' => $this->Auth->User('emp_code'))));

        $penleave = $totallotedleave['MstEmpLeaveAllot']['leave_bal'] - $countleave;
        $salcomp = $this->SalaryDetail->find('all', array(
            'fields' => array('sal_id', 'sal_val', 'sal_amt', 'ref_sal_id', 'sal_perc_val'),
            'conditions' => array('emp_id' => $this->Auth->User('emp_code'))
        ));
        $data_for_addition = array();
        $data_for_deduction = array();
        $tot_earning_arr = array();
        $tot_deduction_arr = array();
        $sal_details_earnings = $this->SalaryDetail->find('all', array(
            'conditions' => array(
                'emp_id' => $this->Auth->User('emp_code'),
                'sal_type' => 'A'
            )
        ));
        $tot_earnings = 0;
        $ctr = 0;
        foreach ($sal_details_earnings as $key => $value) {
            if ($value['SalaryDetail']['sal_val']) {
                //add direct values
                $tot_earnings += $value['SalaryDetail']['sal_amt'];
                //$data_for_addition[] = $data;
                $tot_earning_arr[$ctr]['sal_amt'] = $value['SalaryDetail']['sal_amt'];
            } else {
                //calculate and add percentage components of salary
                $val = $this->SalaryDetail->findById($value['SalaryDetail']['ref_sal_id']);
                if ($value['SalaryDetail']['sal_amt']) {
                    $amt = $value['SalaryDetail']['sal_amt'];
                } else {
                    $amt = ($value['SalaryDetail']['sal_perc_val'] / 100 ) * $val['SalaryDetail']['sal_val'];
                }
                $tot_earnings += $amt;
                $tot_earning_arr[$ctr]['sal_amt'] = $amt;
            }
            $tot_earning_arr[$ctr]['sal_id'] = $value['SalaryDetail']['sal_id'];
            $ctr++;
        }
        $totalsal = 0;
        foreach ($tot_earning_arr as $tot) {
            $totalsal = $totalsal + $tot['sal_amt'];
        }
        $this->set('totalsal', $totalsal);
        $saloneday = $totalsal / 30;
        $this->set('saloneday', $saloneday);
        $this->set('pendingLeave', $penleave);
        $leavetypelimit = $leave_enchtype['LeaveGrp']['leave_max_limit'];
        $this->set('maxleave', $leavetypelimit);
        $this->set('leaveid', $leavetype);
    }

    function encashview() {
        $this->layout = 'employee-new';
        $ench = $this->LeaveEncsh->find('all', array(
            'joins' => array(
                array(
                    'table' => 'leave_encsh_dt',
                    'alias' => 'LeaveEncshDt',
                    'type' => 'INNER',
                    'conditions' => array(
                        'LeaveEncshDt.leave_encsh_id = LeaveEncsh.id'
                    )
                )
            ),
            'conditions' => array(
                'LeaveEncsh.emp_code' => $this->Auth->User('emp_code')
            ),
            'fields' => array('LeaveEncsh.*', 'LeaveEncshDt.*')
        ));
        $emp_name = $this->MyProfile->find('first', array('fields' => array('*'), 'conditions' => array('emp_code' => $this->Auth->user('emp_code'))));
        $this->set('emp_name', $emp_name['MyProfile']['emp_full_name']);
        $this->set('last_name', $emp_name['MyProfile']['emp_lastname']);


        $this->set('emp_id', $emp_name['MyProfile']['emp_id']);

        $this->set('enchdetails', $ench);
    }

    public function cronLeaveForward() {
        $this->autoRender = false;
        $leave = $this->LeaveWorkflow->find('all', array('fields' => 
            array('leave_id', 'emp_code', 'fw_date', 'count(leave_wf_id) as totalcount'), 
            'conditions' => array('fw_date IS NOT NULL', 'DATEDIFF(SYSDATE(),fw_date) >= ' => 3), 
            'group' => array('leave_id')));
        
        if ($leave) {
            foreach ($leave as $leave) {
                $leavefwd = $this->LeaveWorkflow->find('first', array('fields' => array('*'), 'conditions' => array('fw_date IS NULL', 'leave_id' => $leave['LeaveWorkflow']['leave_id'])));
                if ($leavefwd) {
                    $fwdemp = $leavefwd['LeaveWorkflow']['emp_code'];
                    $leave_id = $leavefwd['LeaveWorkflow']['leave_id'];
                    $repmanager = $this->MyProfile->find('first', array('fields' => array('manager_code'), 'conditions' => array('emp_code' => $fwdemp)));
                    $appcount = $this->WfMstAppMapLvl->find('first', array('fields' => array('wf_max_lvl'), 'conditions' => array('wf_app_id' => 2)));
                    if ($appcount['WfMstAppMapLvl']['wf_max_lvl'] == $leave[0]['totalcount']) {
                        $leavewrkflow = array();
                        $leavewrkflow['leave_id '] = $leave_id;
                        $leavewrkflow['emp_code'] = 8243;
                        $leavewrkflow['fw_date'] = null;
                        $leavewrkflow['status'] = 2;
                        $this->LeaveWorkflow->create();
                        $this->LeaveWorkflow->save($leavewrkflow);
                        $date = "'".date('Y-m-d')."'";
                        $lv_app = $this->LeaveWorkflow->updateAll(
                                array('LeaveWorkflow.fw_date' => $date,'LeaveWorkflow.remark' => 'Auto Forwarded after 3 days'), 
                                array('LeaveWorkflow.leave_id' => $leave_id, 'LeaveWorkflow.emp_code' => $fwdemp));
                    } else {
                        $leavewrkflow = array();
                        $leavewrkflow['leave_id'] = $leave_id;
                        $leavewrkflow['emp_code'] = $repmanager['MyProfile']['manager_code'];
                        $leavewrkflow['fw_date'] = null;
                        $leavewrkflow['status'] = 2;
                        $this->LeaveWorkflow->create();
                        $this->LeaveWorkflow->save($leavewrkflow);
                        $date = "'".date('Y-m-d')."'";
                        $lv_app = $this->LeaveWorkflow->updateAll(
                                array('LeaveWorkflow.fw_date' => $date,'LeaveWorkflow.remark' => 'Auto Forwarded after 3 days'), 
                                array('LeaveWorkflow.leave_id' => $leave_id, 'LeaveWorkflow.emp_code' => $fwdemp));
                    }
                }
            }
         echo "Leaves Auto Approved";  
        } else {
            echo "No Leave Found For Auto Approved";
        }
    }

    public function cronLeaveApproval() {
        $this->Autoload = false;
        $date = date('Y-m-d');
        $days_ago = date('Y-m-d', strtotime('-3 days', strtotime($date)));
        $query = $this->LeaveDetail->find('all',array(
                'conditions' => array('LeaveDetail.leave_date' => $days_ago, 'LeaveDetail.leave_status' => array(2, 3)))
                );
        echo "<pre>"; print_r($query); die;
        foreach ($query as $query) {
            $lv_app = $this->LeaveDetail->updateAll(
                    array('LeaveDetail.leave_status' => '5'), 
                    array('LeaveDetail.leave_id' => $query['LeaveDetail']['leave_detail_id'])
            );
            $lv_workflow = $this->LeaveWorkflow->updateAll(
                    array('LeaveWorkflow.status' => '5', 'LeaveWorkflow.approval_date' => date('Y-m-d')), 
                    array('LeaveWorkflow.leave_id' => $query['LeaveWorkflow']['leave_id'])
            );
        }
    }

    public function adjustleave() {

        $this->layout = 'employee-new';
        $this->employeeLeave();
        $this->employeeLeaveDetail();
        $holidays = $this->Holiday->find('list', array(
            'fields' => 'holiday_date'
        ));
        $gender = $_SESSION['Auth']['MyProfile']['gender'];
        $this->set('gender', $gender);
        $this->set('holidays', $holidays);
        $week_holidays = $this->WeekHolidayList->find('list', array(
            'fields' => 'dt'
        ));
        $starTime = date('d-m-Y');
        $endTime = date('d-m-Y');
        $this->set('week_holidays', $week_holidays);
        $this->set(compact('starTime', 'endTime'));

        if (!empty($this->request->data)) {
            $this->parksaveLeaveMaster();
            $this->redirect('view/');
        }
    }

    function getCode($id = null) {
        $this->layout = '';
        $leave_code = $this->LeaveConfiguration->find('all', array('fields' => array('*'), 'conditions' => array('file_upload' => 1, 'leave_code' => $id)));
        $this->set('leave_code', $leave_code);
    }

    function getleaveConfi() {
        $this->layout = '';
        $leave_code = $this->LeaveConfiguration->find('all', array('fields' => array('*')));
        $this->set('leave_code', $leave_code);
    }
    
    function getshortleavedetail($st) {
        $this->autoRender = false;
        $emp_code = $this->Auth->User('emp_code');
        $emp_id = $this->Auth->User('emp_id');
        $in_out_detail = $this->AttendanceDetail->find('first', array(
            'conditions'=>array('atten_dt' => date('Y-m-d', strtotime($st)),'emp_id' => $emp_id),
            'fields' => array('in_time','out_time')));
        $leave_count = $this->LeaveDetail->find('count',
                array('conditions'=>array('leave_code' => 'PAR0000112',
                        'MONTH(leave_date)' => date('m',strtotime($st)),
                         'emp_code' => $emp_code)));
        print_r($in_out_detail);
        $this->set('leave_code', $leave_code);
    }

    function back_leave($datetime) {
        App::import("Model", "LeaveConfiguration");
        $leaveConfi = new LeaveConfiguration();
        $this->autoRender = false;
        $cl_leave_code = $leaveConfi->find('first', array('fields' => array('leave_code'), 'conditions' => array('leave_type' => 'CL')));
        $op_leave_code = $leaveConfi->find('first', array('fields' => array('leave_code'), 'conditions' => array('leave_type' => 'OP')));
        $sl_leave_code = $leaveConfi->find('first', array('fields' => array('leave_code'), 'conditions' => array('leave_type' => 'SL')));
        $lwp_leave_code = $leaveConfi->find('first', array('fields' => array('leave_code'), 'conditions' => array('leave_type' => 'LWP')));
        $el_leave_code = $leaveConfi->find('first', array('fields' => array('leave_code'), 'conditions' => array('leave_type' => 'EL')));
        $leave = [$cl_leave_code['LeaveConfiguration']['leave_code'], $lwp_leave_code['LeaveConfiguration']['leave_code'], $el_leave_code['LeaveConfiguration']['leave_code'], $sl_leave_code['LeaveConfiguration']['leave_code']];
        $datebefore = date('Y-m-d', strtotime($datetime . ' -1 day'));
        $dateafter = date('Y-m-d', strtotime($datetime . ' +1 day'));
        $check_before = $this->LeaveDetail->find('count', array('conditions' =>
            array('emp_code' => $this->Auth->user('emp_code'),
                //'comp_code'=>$this->Auth->user('comp_code'),
                'leave_code in' => $leave,
                'leave_date' => $datebefore)));
        $check_after = $this->LeaveDetail->find('count', array('conditions' =>
            array('emp_code' => $this->Auth->user('emp_code'),
                //'comp_code'=>$this->Auth->user('comp_code'),
                'leave_code in' => $leave,
                'leave_date' => $dateafter)));
        if ($check_before > 0 || $check_after > 0) {
            return true;
        } else {
            return false;
        }
    }

    function today_leave() {
        $this->layout = "employee-new";
        $date = date('Y-m-d');
        $this->paginate = array(
            'fields' => array('*'),
            'limit' => 20,
            'conditions' => array('LeaveDetail.leave_date' => $date
            )
        );

        $data = $this->paginate('LeaveDetail');
        $this->set('leavelist', $data);
    }

    public function leave_report() {
        $this->layout = 'employee-new';
        $auth = $this->Session->read('Auth');
        $orgID = $auth['MyProfile']['comp_code'];
        if (!$this->Common->check_access_right($this->Auth->User('emp_code'), $this->Auth->User('comp_code'), 'leave_module', 'reports')) {
            $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                            <a href="#" class="uk-alert-close uk-close"></a>You do not have rights to access reports</div>');
           // $this->redirect('view');
        }

        $flag = '';
        if (isset($this->request->data['submit']) && $this->request->data['submit'] != '') {
            if (($this->request->data['status'] == '0' || $this->request->data['status'] == '') && $this->request->data['from_date'] == '' && $this->request->data['end_date'] == '') {
                $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert="">
                            <a href="#" class="uk-alert-close uk-close"></a>Please Enter Atleast One Value !!!!</div>');
                $this->redirect('leave_report');
            }
            if ($this->request->data['status'] != '0' && $this->request->data['status'] != '') {
                $ORconditions['LeaveDetail.leave_status'] = $this->request->data['status'];
            }
            $vouch_status = $this->request->data['status'];
            if ($this->request->data['from_date'] != '' && $this->request->data['end_date'] != '') {
                $from_date = date('Y-m-d', strtotime($this->request->data['from_date']));
                $end_date = date('Y-m-d', strtotime($this->request->data['end_date']));
                $ORconditions['LeaveDetail.leave_date between ? and ?'] = array($from_date, $end_date);
            }
             if (!empty($this->request->data['Employee'])) {
                     $ORconditions['LeaveDetail.emp_code'] = $this->request->data['Employee'];
                    $emp_group = $this->request->data['Employee'];
                 $emp_group = base64_encode(serialize($emp_group));  
            }
            $conditions = array($ORconditions);
            $VoucherDetails = $this->LeaveDetail->find('all', array(
                'fields' => array('*'),
                'conditions' => $conditions
            ));

            if ($VoucherDetails) {
                $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                            <a href="#" class="uk-alert-close uk-close"></a>Report Generated Successfully !!!!</div>');
            } else {
                $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert="">
                            <a href="#" class="uk-alert-close uk-close"></a>Sorry, there is no record found !!!!</div>');
            }


            $flag = 'open';
            $this->set(compact('VoucherDetails', 'flag', 'vouch_status', 'emp_group','from_date', 'end_date'));
        }
        $voucherStatus = array('0' => 'All', '2' => 'Pending', '5' => 'Approved', '4' => 'Rejected');

        $this->set(compact('voucherStatus'));
    }

    public function generate_leave_report($from_date = null, $end_date = null, $voucher_status = null,$emp_group) {
        $emp_group =  unserialize(base64_decode($emp_group));
        $this->layout = 'employee-new';
        $auth = $this->Session->read('Auth');
        $orgID = $auth['MyProfile']['comp_code'];


        if ($from_date != 'null' && $end_date != 'null') {
            $ORconditions['LeaveDetail.leave_date between ? and ?'] = array($from_date, $end_date);
        }
        if ($voucher_status != 0) {
            $ORconditions['LeaveDetail.leave_status'] = $voucher_status;
        }
         if (!empty($emp_group)) {
            $ORconditions['LeaveDetail.emp_code'] = $emp_group;
        }
        $conditions = array($ORconditions);
        $VoucherDetails = $this->LeaveDetail->find('all', array(
            'fields' => array('*'),
            'conditions' => $conditions
        ));
        App::import('Vendor', 'TCpdf', array('file' => 'mpdf60/mpdf.php'));
        $this->layout = 'pdf';
        $this->set('pdf', new mPDF('utf-8', array(350, 500)));
        $this->set('VoucherDetails', $VoucherDetails);
    }

    public function DeptDesgDetail($id){
        $dept_desg = $this->MyProfile->find('first',
                        array('fields'=> array('MyProfile.dept_code','MyProfile.desg_code','MyProfile.comp_code'),
                            'conditions'=>array('MyProfile.emp_code'=>$id)));
        $dept_name = $this->Common->findDepartmentNameByDeptCode('01',$dept_desg['MyProfile']['dept_code']);
        $desg_name = $this->Common->getOptionName($dept_desg['MyProfile']['desg_code']);
        $new = array($dept_desg['MyProfile']['dept_code'],$dept_name,$dept_desg['MyProfile']['desg_code'],$desg_name,$dept_desg['MyProfile']['comp_code']);
        echo json_encode($new); die;
    }
   
}

?>
