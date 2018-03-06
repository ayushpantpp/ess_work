<?php

App::uses('Component', 'Controller');

class EmpDetailComponent extends Component {

    public $uses = array('UserDetail', 'Travelvouchermaster', 'MyProfile', 'TravelMaster',
        'WfMstAppMapLvl', 'DtAppMapLvl', 'Department', 'Designation', 'MstEmpLeaveAllot', 'MstTravelVoucher', 'LeaveDetail', 'LeaveWorkflow', 'MstEmpLeave');

    public function __construct(ComponentCollection $collection, $settings = array()) {
        parent::__construct($collection, $settings);
    }

    public function initialize(Controller $controller) {
        //load required for component models
        if ($this->uses !== false) {
            foreach ($this->uses as $modelClass) {
                $controller->loadModel($modelClass);
                $this->$modelClass = $controller->$modelClass;
            }
        }
    }

    public function beforeRender(Controller $controller) {
        
    }

    public function shutdown(Controller $controller) {
        
    }

    public function startup(Controller $controller) {
        $this->controller = $controller;
    }

    public function getdepartmentdetail() {
        $ho_org_id = $_SESSION['Auth']['MyProfile']['comp_code'];
        $depcode = $_SESSION['Auth']['MyProfile']['dept_code'];
        $dept_val = $this->Department->find('first', array(
            'fields' => array('Department.dept_name'),
            'conditions' => array(
                'dept_code' => $depcode,
                'comp_code' => $ho_org_id)
        ));
        return $dept_val['Department']['dept_name'];
    }

    public function getdesgdetail() {
        $deptcode = $_SESSION['Auth']['MyProfile']['dept_code'];
        $dsgcode = $_SESSION['Auth']['MyProfile']['desg_code'];
        $desg_val = $this->Designation->find('first', array(
            'fields' => array('Designation.desc'),
            'conditions' => array(
                'desg_code' => $dsgcode,
                'dept_code' => $deptcode)
        ));
        return $desg_val['Designation']['desc'];
    }

    public function findtravelamt($type = NULL) {

        //$ho_org_id = $_SESSION['Auth']['MyProfile']['comp_code'];
        $tv = $this->MstTravelVoucher->find('list', array(
            'fields' => array('id', 'desc'),
            'conditions' => array(
                'type' => $type,
                'status' => true)
        ));

        return $tv;
    }

    public function getTravelAmtByDeptDesig($deptCode = NULL, $desigCode = NULL) {

        $tv = $this->TravelMaster->find('all', array(
            'fields' => array('amount'),
            'conditions' => array(
                'department_id' => $deptCode,
                'designation_id' => $desigCode)
        ));

        return $tv[0]['TravelMaster']['amount'];
    }

    public function getdepartmentlist() {
        $comp_code = $_SESSION['Auth']['MyProfile']['comp_code'];
        $deptlist = $this->Department->find('list', array(
            'fields' => array('Department.dept_code', 'Department.dept_name'),
            'conditions' => array(
                'comp_code' => $comp_code)
        ));
        return $deptlist;
    }

    public function getdesignationlist() {
        $comp_code = $_SESSION['Auth']['MyProfile']['comp_code'];
        $deptlist = $this->Designation->find('list', array(
            'fields' => array('Designation.desg_code', 'Designation.desc'),
            'conditions' => array(
                'comp_code' => $comp_code)
        ));
        return $deptlist;
    }

    public function getemployeeinfomation($emp_code = NULL) {
        $user_details = $this->MyProfile->find('first', array(
            'conditions' => array(
                'emp_code' => $emp_code
        )));

        return $user_details;
    }

    public function getlaststagelevel($appid = NULL, $emp_dept_id = NULL) {
        $org_id = $_SESSION['Auth']['MyProfile']['comp_code'];
        $emp_desg_id = $_SESSION['Auth']['MyProfile']['desg_code'];

        $query = $this->WfMstAppMapLvl->find('first', array(
            'fields' => array('WfMstAppMapLvl.wf_dept_id', 'WfMstAppMapLvl.wf_max_lvl', 'DtAppMapLvl.wf_id', 'DtAppMapLvl.wf_lvl',
                'DtAppMapLvl.wf_desg_id'),
            'joins' => array(
                array(
                    'table' => 'wf_dt_app_map_lvl',
                    'alias' => 'DtAppMapLvl',
                    'type' => 'inner',
                    'foreignKey' => false,
                    'conditions' => array('DtAppMapLvl.wf_app_map_lvl_id = WfMstAppMapLvl.wf_id ')
                )
            ),
            'conditions' => array(
                'WfMstAppMapLvl.comp_code' => $org_id,
                'WfMstAppMapLvl.wf_dept_id' => $emp_dept_id,
                'WfMstAppMapLvl.wf_app_id' => $appid,
                'DtAppMapLvl.wf_desg_id' => $emp_desg_id)
        ));
        $status = 0;
        if (!empty($query['WfMstAppMapLvl']['wf_max_lvl'])) {
            $maxlvl = $query['WfMstAppMapLvl']['wf_max_lvl'];
            $lvl = $maxlvl - 1;
            $getlabenm = 'Level' . $lvl;
            if ($getlabenm == $query['DtAppMapLvl']['wf_lvl']) {
                $status = 5;
            }
        }
        return $status;
    }

    function getBalLeave($emp_code, $lvtype) {

        $bal = $this->MstEmpLeaveAllot->find('first', array('conditions' => array('emp_code' => $emp_code, 'leave_code' => $lvtype)));
        if (!empty($bal))
            return $bal['MstEmpLeaveAllot']['leave_bal'];
        else
            return 0;
    }

    //function to calculate the pending notification

    function getPendingLeaves($emp_code) {
        App::import("Model", "LeaveDetail");
        $model = new LeaveDetail();
        App::import("Model", "MstEmpLeave");
        $model2 = new MstEmpLeave();
        $con2 = $model->find('all', array(
            'fields' => array('DISTINCT (LeaveDetail.leave_id)', 'LeaveDetail.leave_status'),
            'conditions' => array(
                'AND' => array(
                    'LeaveDetail.emp_code' => $emp_code,
                    'LeaveDetail.leave_status in (1,2,6)', //open,forwarded,pending at HR
                )
            )
                )
        );
        $leave_ids = array();
        foreach ($con2 as $key => $value) {
            $leave_ids[] = $value['LeaveDetail']['leave_id'];
            # code...
        }

        $leavelist = implode(',', $leave_ids);
        if (!empty($leavelist)) {
            $con3 = $model2->find('all', array(
                'conditions' => array(
                    "MstEmpLeave.leave_id in ($leavelist)",
                )
                    )
            );
        } else {
            $con3 = 0;
        }


        if (empty($con3)) {
            return 0;
        } else {
            return $con3;
        }
    }

    function getOptionName($optionCode) {
        App::import("Model", "OptionAttribute");
        $model = new OptionAttribute();
        $con2 = $model->find('first', array(
            'conditions' => array(
                'OptionAttribute.id' => $optionCode)
        ));
        if (empty($con2)) {
            return 0;
        } else {
            return $con2['OptionAttribute']['name'];
        }
    }

    //get company name
    function getCompanyName($comp_code) {
        App::import("Model", "Company");
        $model = new Company();
        $con2 = $model->find('first', array(
            'conditions' => array(
                'Company.comp_code' => $comp_code)
        ));
        if (empty($con2)) {
            return 0;
        } else {
            return $con2['Company']['comp_name'];
        }
    }

    function getPendingLeave($emp_code) {
        App::import("Model", "LeaveDetail");
        $model = new LeaveDetail();
        $emp_code = $emp_code;
        $result = $model->find('all', array(
            'fields' => array('*'),
            'limit' => 10,
            'order' => 'MstEmpLeave.leave_id DESC',
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
            'conditions' => array(
                'LeaveWorkflow.emp_code' => $emp_code,
                'MstEmpLeave.emp_code != ' . $emp_code,
                'LeaveWorkflow.fw_date ' => NULL,
                'OR' => array(
                    'LeaveWorkflow.status IS NULL',
                    'LeaveWorkflow.status' => 2)
            )
                //'order'=>array('LvMstId.id desc')
        ));
        if (!empty($result))
            return $result;
        else
            return '';
    }

    function getPendingSeperation($emp_code) {
        App::import("Model", "Separation");
        $model = new Separation();
        $emp_code = $emp_code;
        $result = $model->find('all', array(
            'fields' => array('*'),
            'limit' => 10,
            'order' => 'Separation.id DESC',
            'joins' => array(
                array(
                    'table' => 'separation_workflows',
                    'alias' => 'Separation_workflows',
                    'type' => 'inner',
                    'foreignKey' => false,
                    'conditions' => array('Separation_workflows.separation_id = Separation.id')
                )
            ),
            'conditions' => array(
                'Separation_workflows.emp_code' => $emp_code,
                'Separation.emp_code != ' . $emp_code,
                'Separation_workflows.fw_date ' => NULL,
                'OR' => array(
                    'Separation_workflows.status IS NULL',
                    'Separation_workflows.status' => 2)
            )

                //'order'=>array('LvMstId.id desc')
        ));
        //  print_r($result);die;
        if (!empty($result))
            return $result;
        else
            return '';
    }

    function getApprovalFinalFnf($emp_code) {
        App::import("Model", "Fnf");
        $model = new Fnf();
        $emp_code = $emp_code;
        $result = $model->find('all', array(
            'conditions' => array(
                'Fnf.final_approver' => $emp_code,
                'Fnf.status' => 1
            )
        ));

        //  print_r($result);die;
        if (!empty($result))
            return $result;
        else
            return '';
    }

    function getPendingAttendance($emp_code) {
        App::import("Model", "AttendanceDetail");
        $model = new AttendanceDetail();
        $emp_code = $emp_code;
        $result = $model->find('all', array(
            'conditions' => array(
                'AttendanceDetail.approver_id' => $emp_code,
                'status' => 2
            )
        ));
        if (!empty($result))
            return $result;
        else
            return '';
    }

    public function leaveConditions($leave_code, $tot, $emp_code, $applydate) {

        //echo "ffffffffff".$leave_code;die;
        //if($leave_code == 'PAR0000069'){
        // if ($tot > 90)
        // $msg = 'You cannot avail Maternity Leave for more than 90 days ';
//      return $msg;
        //}

        App::import("Model", "LeaveDetail");
        $leaveDetail = new LeaveDetail();
        App::import("Model", "MstEmpLeave");
        $mstempleave = new MstEmpLeave();
        App::import("Model", "MyProfile");
        $myprofile = new MyProfile();
        App::import("Model", "MstEmpLeaveAllot");
        $mstempleaveallot = new MstEmpLeaveAllot();
        App::import("Model", "LeaveConfiguration");
        $leaveConfi = new LeaveConfiguration();
        $leave_type = $leaveConfi->find('first', array('fields' => array('leave_type'), 'conditions' => array('leave_code' => $leave_code)));
        //print_r($leave_type);die;
        // Leave code according to leave type
        $cl_leave_code = $leaveConfi->find('first', array('fields' => array('leave_code'), 'conditions' => array('leave_type' => 'CL')));
        $ol_leave_code = $leaveConfi->find('first', array('fields' => array('leave_code'), 'conditions' => array('leave_type' => 'OL')));
        $sl_leave_code = $leaveConfi->find('first', array('fields' => array('leave_code'), 'conditions' => array('leave_type' => 'SL')));
        $lwp_leave_code = $leaveConfi->find('first', array('fields' => array('leave_code'), 'conditions' => array('leave_type' => 'LWP')));
        $el_leave_code = $leaveConfi->find('first', array('fields' => array('leave_code'), 'conditions' => array('leave_type' => 'EL')));

        //print_r($cl_leave_code);die;
        $date = date('Y-m-d');
        $time = strtotime($date);
        $year = date("Y", $time);
        $cl_penfull = $leaveDetail->find('count', array('fields' => array('leave_id'), 'conditions' => array('year(leave_date)' => $year, 'emp_code' => $emp_code, 'leave_status' => array(5, 2, 7, 8), 'leave_code' => $cl_leave_code['LeaveConfiguration']['leave_code'], 'hlfday_leave_chk' => 'N'),
        ));

        $cl_penhalf = $leaveDetail->find('count', array('fields' => array('leave_id'), 'conditions' => array('year(leave_date)' => $year, 'emp_code' => $emp_code, 'leave_status' => array(5, 2, 7, 8), 'leave_code' => $cl_leave_code['LeaveConfiguration']['leave_code'], 'hlfday_leave_chk' => 'Y'),
        ));
        $half = $cl_penhalf / 2;
        $cl_pen = $cl_penfull + $half;
        $cl_allot = $mstempleaveallot->find('first', array('fields' => array('allot_leave'), 'conditions' => array('emp_code' => $emp_code, 'leave_code' => $cl_leave_code['LeaveConfiguration']['leave_code'])));
        if ($cl_allot) {
            $clbal = $cl_allot['MstEmpLeaveAllot']['allot_leave'] - $cl_pen;
        } else {
            $clbal = 0;
        }

        // Leave code according to leave type

        $ocassion = $leaveDetail->find('count', array('fields' => array('leave_id'), 'conditions' => array('year(leave_date)' => $year, 'emp_code' => $emp_code, 'leave_status' => array(5, 2, 7, 8), 'leave_code' => $ol_leave_code),
            'group' => array('leave_id')));
        $dot = $myprofile->find('first', array('fields' => array('join_date'), 'conditions' => array('emp_code' => $emp_code)));

        $date = new DateTime($dot['MyProfile']['join_date']);
        $date2 = new DateTime(date('y-m-d'));
        $diff = date_diff($date, $date2);
        $dojyears = $diff->y;

//print_r($leave_type['LeaveConfiguration']['leave_type']);die;
        switch ($leave_type['LeaveConfiguration']['leave_type']) {
            case 'EL':
                $date = date('Y-m-d');
                $time = strtotime($date);
                $year = date("Y", $time);
                $leave_start_date = $applydate;

                $datetime1 = date('Y-m-d', strtotime($leave_start_date . ' -1 day'));
                $datetime2 = date('Y-m-d', strtotime($applydate . ' +1 day'));
                //print_r($cl_leave_code); die;
                $leavecheckcasual = $leaveDetail->find('count', array('fields' => array('leave_id'), 'conditions' => array('leave_date' => $datetime1, 'emp_code' => $emp_code, 'leave_status' => array(5, 2, 7), 'leave_code' => '$cl_leave_code')));
                $leavecheckcasualbefore = $leaveDetail->find('count', array('fields' => array('leave_id'), 'conditions' => array('leave_date' => $datetime2, 'emp_code' => $emp_code, 'leave_status' => array(5, 2, 7), 'leave_code' => '$cl_leave_code')));
                if ($leavecheckcasual > 0 || $leavecheckcasualbefore > 0) {
                    $msg = 'OL cannot be combined with casual Leave';
                    return $msg;
                }
                $query = $leaveDetail->find('count', array('fields' => array('leave_id'), 'conditions' => array('year(leave_date)' => $year, 'emp_code' => $emp_code, 'leave_status' => array(5, 2, 7), 'leave_code' => '$ol_leave_code')));
                if ($query <= 30) {
                    $total_leave = $query + $tot;
                    if ($total_leave > 30) {
                        $msg = 'You exceed maximum limit of ordinary Leave';
                        return $msg;
                    } else {
                        // echo $tot; die;
                        if ($tot <= 5) {
                            if ($clbal < 5) {
                                if ($clbal == $tot) {
                                    $msg = 'You cannot avail ordinary Leave if  CL balance is equal to OL';
                                    return $msg;
                                } else {
                                    return true;
                                }
                            } else {
                                $msg = 'You cannot avail OL for less than 5 days As Casual Leave Balance is greater than 5';
                                return $msg;
                            }
                        } else {

                            if ($clbal > 0) {
                                if ($clbal == $tot) {
                                    $msg = 'You cannot avail ordinary Leave if  CL balance is equal to OL';
                                    return $msg;
                                } else {
                                    return true;
                                }
                            } else {
                                $msg = 'You cannot avail ordinary Leave for more than 5 days if Casual Leave balance is not there ';

                                return $msg;
                            }
                        }
                    }
                } else {
                    $msg = 'You exceed maximum limit of ordinary Leave';
                    return $msg;
                }

                break;
            case 'CL':
                $date = date('Y-m-d');
                $time = strtotime($date);
                $year = date("Y", $time);
                $leave_start_date = $applydate;
                $datetime1 = date('Y-m-d', strtotime($leave_start_date . ' -1 day'));
                $datetime2 = date('Y-m-d', strtotime($applydate . ' +1 day'));
                $leaveol = $leaveDetail->find('count', array('fields' => array('leave_id'), 'conditions' => array('leave_date' => $datetime1, 'emp_code' => $emp_code, 'leave_status' => array(5, 2, 7, 8), 'leave_code' => $ol_leave_code['LeaveConfiguration']['leave_code'])));
                $leaveolbefore = $leaveDetail->find('count', array('fields' => array('leave_id'), 'conditions' => array('leave_date' => $datetime2, 'emp_code' => $emp_code, 'leave_status' => array(5, 2, 7, 8), 'leave_code' => $ol_leave_code['LeaveConfiguration']['leave_code'])));
                if ($leaveol > 0 || $leaveolbefore > 0) {
                    $msg = 'CL cannot be combined with OL';
                    return $msg;
                }
                $query = $leaveDetail->find('count', array('fields' => array('leave_id'), 'conditions' => array('year(leave_date)' => $year, 'emp_code' => $emp_code, 'leave_status' => array(5, 2, 7, 8), 'leave_code' => $cl_leave_code['LeaveConfiguration']['leave_code'], 'hlfday_leave_chk' => 'N')));
               // print_r($query);die;
                if ($query < 12) {

                    $leave_total = $query + $tot;

                    if ($leave_total > 12) {
                        $msg = 'You can avail maximum 12 casual Leaves in a calender year';
                        return $msg;
                    } else {
                        if ($tot > 5) {
                            $msg = 'you can avail maximum 5 leaves at a time';
                            return $msg;
                        } else {
                            return true;
                        }
                    }
                } else {
                    $msg = 'You can avail maximum 12 casual Leaves in a calender year';
                    return $msg;
                }
                break;
            case 'SL':

                $date = date('Y-m-d');
                $time = strtotime($date);
                $year = date("Y", $time);

                $query = $leaveDetail->find('count', array('fields' => array('leave_id'), 'conditions' => array('year(leave_date)' => $year, 'emp_code' => $emp_code, 'leave_status' => array(5, 2, 7, 8), 'leave_code' => $sl_leave_code['LeaveConfiguration']['leave_code'])));

                if ($dojyears < 1) {
                    $msg = 'Sick Leave can be applied once you completed your one year';
                    return $msg;
                } else {
                    if ($query <= 15) {

                        $leave_total = $query + $tot;

                        /* if($leave_total > 15){
                          $msg = 'Maximum avail sick limit has been exceed';
                          return $msg;
                          } */
                        if ($clbal > 3) {
                            if ($tot < 3) {
                                $msg = 'No Sick Leave will be snactioned for less than 3 days if  CL is balance is greater than 3 ';
                                return $msg;
                            } else {
                                return true;
                            }
                        } else {
                            return true;
                        }
                    } else {
                        $msg = 'You excced maximum Sick Leave Limit';
                        return $msg;
                    }
                }

                break;

            case 'ML':
                $datetime1 = date('Y-m-d', strtotime($leave_start_date . ' -1 day'));
                $datetime2 = date('Y-m-d', strtotime($applydate . ' +1 day'));
                $leavecheckcasual = $leaveDetail->find('count', array('fields' => array('leave_id'), 'conditions' => array('leave_date' => $datetime1, 'emp_code' => $emp_code, 'leave_status' => array(5, 2, 7), 'leave_code' => $cl_leave_code['LeaveConfiguration']['leave_code'])));
                $leavecheckcasualbefore = $leaveDetail->find('count', array('fields' => array('leave_id'), 'conditions' => array('leave_date' => $datetime2, 'emp_code' => $emp_code, 'leave_status' => array(5, 2, 7), 'leave_code' => $cl_leave_code['LeaveConfiguration']['leave_code'])));
                if ($leavecheckcasual > 0 || $leavecheckcasualbefore > 0) {
                    $msg = 'OL cannot be combined with casual Leave';
                    return $msg;
                }
                $query = $leaveDetail->find('count', array('fields' => array('leave_id'), 'conditions' => array('year(leave_date)' => $year, 'emp_code' => $emp_code, 'leave_status' => array(5, 2, 7), 'leave_code' => 'PAR0000066')));

                $ocassion = $leaveDetail->find('count', array('fields' => array('leave_id'), 'conditions' => array('emp_code' => $emp_code, 'leave_status' => array(5, 2, 7), 'leave_code' => 'PAR0000066'),
                    'group' => array('leave_id')));
                if ($ocassion > 2) {
                    $msg = 'You cannot avail Maternity Leave for more than 180 days ';
                    return $msg;
                } else {
                    $leave_total = $query + $tot;
                    if ($leave_total > 90) {
                        $msg = 'You cannot avail Maternity Leave for more than 90 days ';
                        return $msg;
                    } else {
                        if ($leave_total < 90) {
                            $msg = 'You cannot avail Maternity Leave for less than 90 days ';
                            return $msg;
                        } else {
                            return true;
                        }
                    }
                }

            case 'LWP':

                return true;

                break;
            case 'OP':

                return true;

                break;
            case 'PAR0000067':

                return true;

                break;
            default:
                return true;
                break;
        }
    }

    public function editLeaveConditions($leave_code, $tot, $emp_code, $applydate, $leaveid) {


        App::import("Model", "LeaveDetail");
        $leaveDetail = new LeaveDetail();
        App::import("Model", "MstEmpLeave");
        $mstempleave = new MstEmpLeave();
        App::import("Model", "MyProfile");
        $myprofile = new MyProfile();
        App::import("Model", "MstEmpLeaveAllot");
        $mstempleaveallot = new MstEmpLeaveAllot();
        App::import("Model", "LeaveConfiguration");
        $leaveConfi = new LeaveConfiguration();
        $leave_type = $leaveConfi->find('first', array('fields' => array('leave_type'), 'conditions' => array('leave_code' => $leave_code)));
        //print_r($leave_code);die;
        // Leave code according to leave type
        $cl_leave_code = $leaveConfi->find('first', array('fields' => array('leave_code'), 'conditions' => array('leave_type' => 'CL')));
        //print_r($cl_leave_code);die;
        $date = date('Y-m-d');
        $time = strtotime($date);
        $year = date("Y", $time);
        $cl_penfull = $leaveDetail->find('count', array('fields' => array('leave_id'), 'conditions' => array('year(leave_date)' => $year, 'emp_code' => $emp_code, 'leave_status' => array(5, 2, 7, 8), 'leave_code' => $cl_leave_code['LeaveConfiguration']['leave_code'], 'hlfday_leave_chk' => 'N'),
        ));

        $cl_penhalf = $leaveDetail->find('count', array('fields' => array('leave_id'), 'conditions' => array('year(leave_date)' => $year, 'emp_code' => $emp_code, 'leave_status' => array(5, 2, 7, 8), 'leave_code' => $cl_leave_code['LeaveConfiguration']['leave_code'], 'hlfday_leave_chk' => 'Y'),
        ));
        $half = $cl_penhalf / 2;
        $cl_pen = $cl_penfull + $half;
        $cl_allot = $mstempleaveallot->find('first', array('fields' => array('allot_leave'), 'conditions' => array('emp_code' => $emp_code, 'leave_code' => $cl_leave_code['LeaveConfiguration']['leave_code'])));
        if ($cl_allot) {
            $clbal = $cl_allot['MstEmpLeaveAllot']['allot_leave'] - $cl_pen;
        } else {
            $clbal = 0;
        }

        // Leave code according to leave type
        $ol_leave_code = $leaveConfi->find('first', array('fields' => array('leave_code'), 'conditions' => array('leave_type' => 'OL')));
        $sl_leave_code = $leaveConfi->find('first', array('fields' => array('leave_code'), 'conditions' => array('leave_type' => 'SL')));

        $ocassion = $leaveDetail->find('count', array('fields' => array('leave_id'), 'conditions' => array('year(leave_date)' => $year, 'emp_code' => $emp_code, 'leave_status' => array(5, 2, 7, 8), 'leave_code' => $ol_leave_code['LeaveConfiguration']['leave_code']),
            'group' => array('leave_id')));
        $dot = $myprofile->find('first', array('fields' => array('join_date'), 'conditions' => array('emp_code' => $emp_code)));

        $date = new DateTime($dot['MyProfile']['join_date']);
        $date2 = new DateTime(date('y-m-d'));
        $diff = date_diff($date, $date2);
        $dojyears = $diff->y;

//print_r($leave_type['LeaveConfiguration']['leave_type']);die;
        switch ($leave_type['LeaveConfiguration']['leave_type']) {
            case 'EL':
                $date = date('Y-m-d');
                $time = strtotime($date);
                $year = date("Y", $time);
                $leave_start_date = $applydate;

                $datetime1 = date('Y-m-d', strtotime($leave_start_date . ' -1 day'));
                $datetime2 = date('Y-m-d', strtotime($applydate . ' +1 day'));
                $leavecheckcasual = $leaveDetail->find('count', array('fields' => array('leave_id'), 'conditions' => array('leave_date' => $datetime1, 'emp_code' => $emp_code, 'leave_status' => array(5, 2, 7), 'leave_code' => $cl_leave_code['LeaveConfiguration']['leave_code'])));
                $leavecheckcasualbefore = $leaveDetail->find('count', array('fields' => array('leave_id'), 'conditions' => array('leave_date' => $datetime2, 'emp_code' => $emp_code, 'leave_status' => array(5, 2, 7), 'leave_code' => $cl_leave_code['LeaveConfiguration']['leave_code'])));
                if ($leavecheckcasual > 0 || $leavecheckcasualbefore > 0) {
                    $msg = 'OL cannot be combined with casual Leave';
                    return $msg;
                }
                $query = $leaveDetail->find('count', array('fields' => array('leave_id'), 'conditions' => array('year(leave_date)' => $year, 'emp_code' => $emp_code, 'leave_status' => array(5, 2, 7), 'leave_code' => $ol_leave_code['LeaveConfiguration']['leave_code'])));
                if ($query <= 30) {
                    $total_leave = $query + $tot;
                    if ($total_leave > 30) {
                        $msg = 'You exceed maximum limit of Earned Leave';
                        return $msg;
                    } else {
                        if ($tot <= 5) {
                            if ($clbal < 5) {
                                if ($clbal == $tot) {
                                    $msg = 'You cannot avail Earned Leave if  CL balance is equal to OL';
                                    return $msg;
                                } else {
                                    return true;
                                }
                            } else {
                                $msg = 'You cannot avail Earned Leave for less than 5 days As Casual Leave Balance is greater than 5';
                                return $msg;
                            }
                        } else {

                            if ($clbal > 0) {
                                if ($clbal == $tot) {
                                    $msg = 'You cannot avail Earned Leave if  CL balance is equal to OL';
                                    return $msg;
                                } else {
                                    return true;
                                }
                            } else {
                                $msg = 'You cannot avail Earned Leave for more than 5 days if Casual Leave balance is not there ';

                                return $msg;
                            }
                        }
                    }
                } else {
                    $msg = 'You exceed maximum limit of ordinary Leave';
                    return $msg;
                }

                break;
            case 'CL':
                $date = date('Y-m-d');
                $time = strtotime($date);
                $year = date("Y", $time);
                $leave_start_date = $applydate;
                $datetime1 = date('Y-m-d', strtotime($leave_start_date . ' -1 day'));
                $datetime2 = date('Y-m-d', strtotime($applydate . ' +1 day'));
                $leaveol = $leaveDetail->find('count', array('fields' => array('leave_id'), 'conditions' => array('leave_date' => $datetime1, 'emp_code' => $emp_code, 'leave_status' => array(5, 2, 7), 'leave_code' => $ol_leave_code['LeaveConfiguration']['leave_code'])));
                $leaveolbefore = $leaveDetail->find('count', array('fields' => array('leave_id'), 'conditions' => array('leave_date' => $datetime2, 'emp_code' => $emp_code, 'leave_status' => array(5, 2, 7), 'leave_code' => $ol_leave_code['LeaveConfiguration']['leave_code'])));
                if ($leaveol > 0 || $leaveolbefore > 0) {
                    $msg = 'CL cannot be combined with OL';
                    return $msg;
                }
                $query = $leaveDetail->find('count', array('fields' => array('leave_id'), 'conditions' => array('year(leave_date)' => $year, 'emp_code' => $emp_code, 'leave_status' => array(5, 2, 7), 'leave_code' => $cl_leave_code['LeaveConfiguration']['leave_code'], 'hlfday_leave_chk' => 'N')));

                if ($query < 12) {
                    $leave_total = $query + $tot;
                    if ($leave_total > 12) {
                        $msg = 'You can avail maximum 12 casual Leaves in a calender year';
                        return $msg;
                    } else {
                        if ($tot > 5) {
                            $msg = 'you can avail maximum 5 leaves at a time';
                            return $msg;
                        } else {
                            return true;
                        }
                    }
                } else {
                    $msg = 'You can avail maximum 12 casual Leaves in a calender year';
                    return $msg;
                }
                break;
            case 'SL':

                $date = date('Y-m-d');
                $time = strtotime($date);
                $year = date("Y", $time);

                $query = $leaveDetail->find('count', array('fields' => array('leave_id'), 'conditions' => array('year(leave_date)' => $year, 'emp_code' => $emp_code, 'leave_status' => array(5, 2, 7), 'leave_code' => $sl_leave_code['LeaveConfiguration']['leave_code'])));

                if ($dojyears < 1) {
                    $msg = 'Sick Leave can be applied once you completed your one year';
                    return $msg;
                } else {
                    if ($query <= 15) {

                        $leave_total = $query + $tot;

                        /* if($leave_total > 15){
                          $msg = 'Maximum avail sick limit has been exceed';
                          return $msg;
                          } */
                        if ($clbal > 3) {
                            if ($tot < 3) {
                                $msg = 'No Sick Leave will be snactioned for less than 3 days if  CL is balance is greater than 3 ';
                                return $msg;
                            } else {
                                return true;
                            }
                        } else {
                            return true;
                        }
                    } else {
                        $msg = 'You excced maximum Sick Leave Limit';
                        return $msg;
                    }
                }

                break;

            case 'ML':
                $datetime1 = date('Y-m-d', strtotime($leave_start_date . ' -1 day'));
                $datetime2 = date('Y-m-d', strtotime($applydate . ' +1 day'));
                $leavecheckcasual = $leaveDetail->find('count', array('fields' => array('leave_id'), 'conditions' => array('leave_date' => $datetime1, 'emp_code' => $emp_code, 'leave_status' => array(5, 2, 7), 'leave_code' => $cl_leave_code['LeaveConfiguration']['leave_code'])));
                $leavecheckcasualbefore = $leaveDetail->find('count', array('fields' => array('leave_id'), 'conditions' => array('leave_date' => $datetime2, 'emp_code' => $emp_code, 'leave_status' => array(5, 2, 7), 'leave_code' => $cl_leave_code['LeaveConfiguration']['leave_code'])));
                if ($leavecheckcasual > 0 || $leavecheckcasualbefore > 0) {
                    $msg = 'OL cannot be combined with casual Leave';
                    return $msg;
                }
                $query = $leaveDetail->find('count', array('fields' => array('leave_id'), 'conditions' => array('year(leave_date)' => $year, 'emp_code' => $emp_code, 'leave_status' => array(5, 2, 7), 'leave_code' => 'PAR0000066')));

                $ocassion = $leaveDetail->find('count', array('fields' => array('leave_id'), 'conditions' => array('emp_code' => $emp_code, 'leave_status' => array(5, 2, 7), 'leave_code' => 'PAR0000066'),
                    'group' => array('leave_id')));
                if ($ocassion > 2) {
                    $msg = 'You cannot avail Maternity Leave for more than 180 days ';
                    return $msg;
                } else {
                    $leave_total = $query + $tot;
                    if ($leave_total > 90) {
                        $msg = 'You cannot avail Maternity Leave for more than 90 days ';
                        return $msg;
                    } else {
                        if ($leave_total < 90) {
                            $msg = 'You cannot avail Maternity Leave for less than 90 days ';
                            return $msg;
                        } else {
                            return true;
                        }
                    }
                }

            case 'LWP':

                return true;

                break;
            case 'OP':

                return true;

                break;
            case 'PAR0000067':

                return true;
                break;

            default:
                return true;
                break;
        }
    }

    public function lta_calculate($lta_year) {
        App::import("Model", "LtaBillAmount");
        $lta = new LtaBillAmount();
        $date = date('Y-m-d');
        $time = strtotime($date);
        $year = date("Y", $time);
        $cal_year = date("Y", strtotime("-3 year"));
        $previous_year = date("Y", strtotime("-1 year"));
        $query = $lta->find('all', array(
            'fields' => array('lta_years', 'year(jour_start_date) as created_at'),
            'conditions' => array('year(jour_start_date)>=' . $cal_year, 'year(jour_start_date) <=' . $year)
        ));

        $lta_block = 0;
        $lta_years = array();
        $i = 0;
        foreach ($query as $res) {
            $lta_years[] = $res[$i]['created_at'];
            $lta_block = $lta_block + $res['LtaBillAmount']['lta_years'];
            $i = $i + 1;
        }

        $flag = 0;
        switch ($lta_claim_flag) {
            case 0:
                $flag = 1;
                break;
            case 1:
                if (in_array($lta_years, $previous_year) && $lta_year > 1) {
                    $flag = 0;
                } else {
                    if ($lta_year > 3) {
                        $flag = 0;
                    } else {
                        $flag = 1;
                    }
                }
                break;
            case 2:
                if (in_array($lta_years, $previous_year) && $lta_year > 1) {
                    $flag = 0;
                } else {
                    if ($lta_year > 2) {
                        $flag = 0;
                    } else {
                        $flag = 1;
                    }
                }
                break;
            case 3:
                if (in_array($lta_years, $previous_year) && $lta_year > 1) {
                    $flag = 0;
                } else {
                    if ($lta_year > 2) {
                        $flag = 0;
                    } else {
                        $flag = 1;
                    }
                }
                break;
            case 4:
                if (in_array($lta_years, $previous_year) && $lta_year > 1) {
                    $flag = 0;
                } else {
                    if ($lta_year > 2) {
                        $flag = 0;
                    } else {
                        $flag = 1;
                    }
                }
                break;
            default:
                break;
        }
    }

    public function company_details() {
        
    }

    public function lta_per($emp_code, $comp_code) {

        App::import("Model", "LtaBillAmount");
        $lta = new LtaBillAmount();
        App::import("Model", "MyProfile");
        $myprofile = new MyProfile();

        $flag = 0;
        $date = date('Y-m-d');
        $time = strtotime($date);
        $year = date("Y", $time);
        $cal_year = date("Y", strtotime("-3 year"));
        $previous_year = date("Y", strtotime("-1 year"));
        $sec_previous = date("Y", strtotime("-2 year"));
        $query = $lta->find('all', array(
            'fields' => array('lta_years', 'year(jour_start_date) as created_at'),
            'conditions' => array('year(jour_start_date)>=' . $cal_year, 'year(jour_start_date) <=' . $year, 'emp_code' => $emp_code, 'comp_code' => $comp_code, 'status NOT IN(4,7)')
        ));

        if ($query) {
            $lta_years = array();
            $i = 0;
            foreach ($query as $res) {
                $lta_years[] = $res[$i]['created_at'];
                //$lta_block = $lta_block + $res['LtaBillAmount']['lta_years'];
                $i = $i + 1;
            }

            if (in_array($previous_year, $lta_years)) {
                $flag = 1;
            } elseif (in_array($sec_previous, $lta_years)) {
                $flag = 2;
            } elseif (in_array($cal_year, $lta_years)) {
                $flag = 3;
            } else {
                $flag = 4;
            }
            return $flag;
        } else {
            $dob = $myprofile->find('first', array(
                'fields' => array('join_date'),
                'conditions' => array('emp_code' => $emp_code)));
            $date = new DateTime($dob['MyProfile']['join_date']);
            $date2 = new DateTime(date('Y-m-d'));
            $diff = date_diff($date, $date2);
            $dojyears = $diff->y;
            if ($dojyears >= 4) {
                return $flag = 4;
            } elseif ($dojyears >= 3) {
                return $flag = 3;
            } elseif ($dojyears >= 2) {
                return $flag = 2;
            } else {
                return $flag = 1;
            }
        }
    }

    public function findDesignationName($id, $org_id) {

        App::import("Model", "OptionAttribute");
        $model = new OptionAttribute();
        $query = $model->find('first', array(
            'fields' => array('OptionAttribute.name'),
            'conditions' => array(
                'OptionAttribute.id' => $id,
                'OptionAttribute.ho_org_id' => $org_id,
                'OptionAttribute.options_id' => 4
            )
        ));
        if (!empty($query['OptionAttribute']['name'])) {
            return $query['OptionAttribute']['name'];
        } else {
            return '';
        }
    }

    public function findDesignationByEmpCode($empId) {
        //echo $desg_code;		
        //function to find all company name

        App::import("Model", "MyProfile");
        $model = new MyProfile();
        $query = $model->find('first', array('fields' => array('desg_code'), 'conditions' => array('MyProfile.emp_code' => $empId)));
        if (empty($query)) {
            return 0;
        } else {
            return $query['MyProfile']['desg_code'];
        }
    }

    public function getEmpEmailDetails($empCode, $compCode) {
        App::import("Model", "UserDetail");
        $model = new UserDetail();

        $emplist = $model->find('first', array(
            'fields' => array('UserDetail.emp_code', 'UserDetail.email', 'UserDetail.comp_code'),
            'conditions' => array("emp_code = '$empCode'", 'comp_code' => $compCode)
        ));
        return $emplist;
    }

    public function getEmpDetails($empCode) {
        App::import("Model", "MyProfile");
        $model = new MyProfile();

        $emplist = $model->find('first', array(
            'fields' => array('MyProfile.emp_code', 'MyProfile.manager_code', 'MyProfile.emp_full_name', 'MyProfile.join_date', 'MyProfile.dept_code', 'MyProfile.desg_code', 'MyProfile.comp_code', 'MyProfile.cur_phone'),
            'conditions' => array("emp_code = '$empCode'")
        ));
        return $emplist;
    }

    public function findEmpName($emp_code) {
        App::import("Model", 'MyProfile');
        $modelprofile = new MyProfile();
        $emp_name = $modelprofile->find('first', array(
            'fields' => array('MyProfile.emp_firstname', 'MyProfile.emp_lastname', 'MyProfile.emp_full_name'),
            'conditions' => array('MyProfile.emp_code' => $emp_code)
        ));
        return $emp_name['MyProfile']['emp_full_name'];
    }

    public function getManagerCode($empCode) {
        App::import("Model", "MyProfile");
        $model = new MyProfile();

        $desglist = $model->find('first', array(
            'fields' => array('MyProfile.manager_code'),
            'conditions' => array("emp_code = '$empCode'")
        ));
        return $desglist['MyProfile']['manager_code'];
    }

    public function getempdesgcode($emp_code = NULL) {
        $comp_code = $_SESSION['Auth']['MyProfile']['comp_code'];
        App::import("Model", "MyProfile");
        $model = new MyProfile();
        $empinfo = $model->find('first', array(
            'fields' => array('MyProfile.desg_code'),
            'conditions' => array(
                'emp_code' => $emp_code,
                'comp_code' => $comp_code)
        ));

        return $empinfo['MyProfile']['desg_code'];
    }

}
