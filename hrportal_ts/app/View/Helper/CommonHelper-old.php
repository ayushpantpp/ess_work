<?php

App::uses('AppHelper', 'View/Helper');

class CommonHelper extends AppHelper {

    var $helpers = array('Session');
    var $name = 'CommonHelper';

    public function findSatus($id = null) {
        App::import("Model", "WfMstStatus");
        $model = new WfMstStatus();
        $query = $model->find('first', array(
            'conditions' => array(
                'id' => $id,
                'status' => true)
        ));
        if (empty($query['WfMstStatus']['status_name'])) {
            return 0;
        } else {
            return $query['WfMstStatus']['status_name'];
        }
    }

    public function findimpdoc() {

        $comp_code = $_SESSION['Auth']['MyProfile']['comp_code'];

        App::import("Model", "ImportantDocCategory");
        $model = new ImportantDocCategory();
        $query = $model->find('all', array('fields' => array('*'), 'conditions' => array('ImportantDocCategory.comp_code' => $comp_code)));

        return $query;
    }

    public function findDesglvl($id = NULL) {

        $comp_code = $_SESSION['Auth']['MyProfile']['comp_code'];
        $emp_dept_id = $_SESSION['Auth']['MyProfile']['dept_code'];
        $emp_desg_id = $_SESSION['Auth']['MyProfile']['desg_code'];
        App::import("Model", "DtAppMapLvl");
        $model = new DtAppMapLvl();
        $query = $model->find('all', array(
            'joins' => array(
                array(
                    'table' => 'wf_mst_app_map_lvl',
                    'alias' => 'WfMstAppMapLvl',
                    'type' => 'inner',
                    'foreignKey' => false,
                    'conditions' => array('DtAppMapLvl.wf_app_map_lvl_id = WfMstAppMapLvl.wf_id')
                )
            ),
            'conditions' => array('DtAppMapLvl.wf_app_map_lvl_id' => $id, 'DtAppMapLvl.wf_desg_id' => $emp_desg_id, 'DtAppMapLvl.wf_dept_id' => $emp_dept_id)
        ));

        if (!empty($query)) {
            return $query[0]['DtAppMapLvl']['wf_desg_id'];
        }
    }

    //Gets employee list for Forward if applicable
    public function findLevel() {

        $comp_code = $_SESSION['Auth']['MyProfile']['comp_code'];
        $emp_dept_id = $_SESSION['Auth']['MyProfile']['dept_code'];
        $emp_desg_id = $_SESSION['Auth']['MyProfile']['desg_code'];
        $emp_code = $_SESSION['Auth']['MyProfile']['emp_code'];

//        App::import("Model", "HcmDesgPrf");
//        $model = new HcmDesgPrf();
//        $query = $model->find('first', array(
//            'fields' => array('dept_id','desg_id','rptg_desg_id'),
//            'conditions' => array('HcmDesgPrf.dept_id' => $emp_dept_id, 'HcmDesgPrf.ho_org_id' =>$comp_code,'HcmDesgPrf.desg_id'=>$emp_desg_id)
//        ));
        // print_r($query);die;
        App::import("Model", "MyProfile");

        $model = new MyProfile();
        $query = $model->find('first', array('fields' => array(
                'manager_code', 'dept_code', 'desg_code'), 'conditions' => array('emp_code' => $emp_code, 'comp_code' => $comp_code)));

        if (!empty($query['MyProfile']['manager_code'])) {
            $desglist = $model->find('list', array('fields' => array(
                    'emp_code', 'emp_name'), 'conditions' => array('emp_code' => $query['MyProfile']['manager_code'])));
        } else if ($query['MyProfile']['manager_code'] == NULL && !empty($query)) {

            $desglist = $this->getHrList($emp_code);
        } else {
            $desglist = array();
        }

        return $desglist;
    }

    public function findSepLevel($workflow) {

        $comp_code = $_SESSION['Auth']['MyProfile']['comp_code'];
        $emp_dept_id = $_SESSION['Auth']['MyProfile']['dept_code'];
        $emp_desg_id = $_SESSION['Auth']['MyProfile']['desg_code'];
        $emp_code = $_SESSION['Auth']['MyProfile']['emp_code'];

//        App::import("Model", "HcmDesgPrf");
//        $model = new HcmDesgPrf();
//        $query = $model->find('first', array(
//            'fields' => array('dept_id','desg_id','rptg_desg_id'),
//            'conditions' => array('HcmDesgPrf.dept_id' => $emp_dept_id, 'HcmDesgPrf.ho_org_id' =>$comp_code,'HcmDesgPrf.desg_id'=>$emp_desg_id)
//        ));
        // print_r($query);die;
        App::import("Model", "MyProfile");

        $model = new MyProfile();
        $query = $model->find('first', array('fields' => array(
                'manager_code', 'dept_code', 'desg_code'), 'conditions' => array('emp_code' => $emp_code, 'comp_code' => $comp_code)));

        if (!empty($query['MyProfile']['manager_code'])) {
            $desglist = $model->find('list', array('fields' => array(
                    'emp_code', 'emp_name'), 'conditions' => array('emp_code' => $query['MyProfile']['manager_code'])));
        } else if ($query['MyProfile']['manager_code'] == NULL && !empty($query)) {

            $desglist = $this->getSepHrList($emp_code, $workflow);
        } else {
            $desglist = array();
        }

        return $desglist;
    }

    function getHrList($emp_code) {

        App::import("Model", "MyProfile");
        $comp_code = $_SESSION['Auth']['MyProfile']['comp_code'];
        $model = new MyProfile();
        $query = $model->find('list', array('fields' => array(
                'emp_code', 'emp_name'), 'conditions' => array('dept_code' => 'DEPT00009', 'comp_code' => $comp_code, 'emp_code !=' . $emp_code, 'status' => 32)));

        return $query;
    }

    function getSepHrList($emp_code, $workflow) {
        foreach ($workflow as $workflow) {
            $emp_ids[] = $workflow['emp_code'];
        }

        $emp_id = implode(",", $emp_ids);

        App::import("Model", "MyProfile");
        $comp_code = $_SESSION['Auth']['MyProfile']['comp_code'];
        $model = new MyProfile();
        $query = $model->find('list', array('fields' => array(
                'emp_code', 'emp_name'), 'conditions' => array('dept_code' => 'DEPT00009', 'comp_code' => $comp_code, "emp_code NOT IN($emp_id)", 'status' => 32)));

        return $query;
    }

    public function findAppLevel($appid) {
        App::import("Model", "WfMstAppMapLvl");
        $model = new WfMstAppMapLvl();
        $lvl = $model->find('first', array('fields' => array('wf_max_lvl'), 'conditions' => array('wf_app_id' => $appid)));
        if ($lvl) {
            $level = $lvl['WfMstAppMapLvl']['wf_max_lvl'];
            return $level;
        }
    }

    //function to 
    public function findcheckLevel1($id = NULL) {
        $sess = $this->Session->read('Auth');
        $comp_code = $_SESSION['Auth']['MyProfile']['comp_code'];
        $emp_dept_id = $_SESSION['Auth']['MyProfile']['dept_code'];
        App::import("Model", "WfMstAppMapLvl");
        $model = new WfMstAppMapLvl();
        $query = $model->find('first', array(
            'fields' => array('WfMstAppMapLvl.wf_app_id'),
            'joins' => array(
                array(
                    'table' => 'wf_dt_app_map_lvl',
                    'alias' => 'DtAppMapLvl',
                    'type' => 'inner',
                    'foreignKey' => false,
                    'conditions' => array('DtAppMapLvl.wf_app_map_lvl_id = WfMstAppMapLvl.wf_app_id')
                )
            ),
            'conditions' => array(
                'WfMstAppMapLvl.comp_code' => $comp_code,
                'WfMstAppMapLvl.wf_dept_id' => $emp_dept_id,
                'WfMstAppMapLvl.wf_app_id' => $id)
        ));

        if (!empty($query['WfMstAppMapLvl']['wf_app_id'])) {
            return $query['WfMstAppMapLvl']['wf_app_id'];
        } else {
            return 0;
        }
    }

    //Gets employee list for Forward if applicable
    public function findLevel1($id = NULL, $type = 'Forward') {
        $sess = $this->Session->read('Auth');
        $comp_code = $_SESSION['Auth']['MyProfile']['comp_code'];
        $emp_dept_id = $_SESSION['Auth']['MyProfile']['dept_code'];
        $emp_desg_id = $_SESSION['Auth']['MyProfile']['desg_code'];

        App::import("Model", "DtAppMapLvl");
        $model = new DtAppMapLvl();
        $query = $model->find('all', array(
            'joins' => array(
                array(
                    'table' => 'wf_mst_app_map_lvl',
                    'alias' => 'WfMstAppMapLvl',
                    'type' => 'inner',
                    'foreignKey' => false,
                    'conditions' => array('DtAppMapLvl.wf_app_map_lvl_id = WfMstAppMapLvl.wf_app_id')
                )
            ),
            'conditions' => array('DtAppMapLvl.wf_app_map_lvl_id' => $id, 'DtAppMapLvl.wf_desg_id' => $emp_desg_id, 'DtAppMapLvl.wf_dept_id' => $emp_dept_id)
        ));

        if (count($query) > 0) {
            $getseq = $query[0]['DtAppMapLvl']['lvl_sequence'];
            $maxlvl = $getseq + 1;
        } else {
            $maxlvl = 1;
        }

        //Finds level details for next level of approval
        $query1 = $model->find('first', array(
            'conditions' => array('DtAppMapLvl.wf_app_map_lvl_id' => $id, 'DtAppMapLvl.lvl_sequence' => $maxlvl)
        ));
        //Checks whether current level employee has approval right for lower level employees
        if (!empty($query1['DtAppMapLvl']['wf_desg_id']) && $type == 'Apply') {
            $desglist = $this->listdesgbyemp($query1['DtAppMapLvl']['wf_desg_id'], $query1['DtAppMapLvl']['wf_dept_id']);
        } else if (!empty($query1['DtAppMapLvl']['wf_desg_id']) && $type == 'Forward') {
            $desglist = $this->listdesgbyemp($query1['DtAppMapLvl']['wf_desg_id'], $query1['DtAppMapLvl']['wf_dept_id']);
        } else {
            $desglist = array();
        }
        // print_r($desglist);die;
        return $desglist;
    }

    public function listdesgbyemp($emp_desg_id = NULL, $emp_dept_id = NULL) {
        $comp_code = $_SESSION['Auth']['MyProfile']['comp_code'];
        App::import("Model", "MyProfile");
        $model = new MyProfile();
        $conditions[] = 'comp_code = ' . $comp_code;
        if (!empty($emp_desg_id))
            $conditions[] = "desg_code = '$emp_desg_id'";
        if (!empty($emp_dept_id))
            $conditions[] = "dept_code = '$emp_dept_id'";
        $desglist = $model->find('list', array(
            'fields' => array('MyProfile.emp_code', 'MyProfile.emp_name'),
            'conditions' => $conditions
        ));
        return $desglist;
    }

    public function getempinfo($emp_code = NULL) {
        $comp_code = $_SESSION['Auth']['MyProfile']['comp_code'];

        App::import("Model", "MyProfile");
        $model = new MyProfile();
        $empinfo = $model->find('first', array(
            'fields' => array('MyProfile.emp_name'),
            'conditions' => array(
                'emp_code' => $emp_code,
                'comp_code' => $comp_code)
        ));
        if (!empty($empinfo))
            return $empinfo['MyProfile']['emp_name'];
        else
            return 'No record found';
    }

    public function getempinfodocid($emp_code = NULL) {
        $comp_code = $_SESSION['Auth']['MyProfile']['comp_code'];

        App::import("Model", "MyProfile");
        $model = new MyProfile();
        $empinfo = $model->find('first', array(
            'fields' => array('MyProfile.emp_name'),
            'conditions' => array(
                'doc_id' => $emp_code,
                'comp_code' => $comp_code)
        ));
        if (!empty($empinfo))
            return $empinfo['MyProfile']['emp_name'];
        else
            return 'No record found';
    }

    public function gettravelinfomation($id) {
        /* App::import("Model", "Travelvouchermaster");
          $model = new Travelvouchermaster();
          $tv = $model->find('first', array(
          'fields'=>array('vc_desc'),
          'conditions' => array(
          'id' =>$id)
          ));
          // pr($tv);die;
          return $tv['Travelvouchermaster']['vc_desc']; */
    }

    public function getdepartmentbyid($id) {

        App::import("Model", "Department");
        $model = new Department();
        $tv = $model->find('first', array(
            'fields' => array('dept_name'),
            'conditions' => array(
                'dept_code' => $id
            )
        ));
        return $tv['Department']['dept_name'];
    }

    public function getlevelbytvid($vid) {
        App::import("Model", "TravelWfLvl");
        $model = new TravelWfLvl();
        $tv = $model->find('all', array('conditions' => array('voucher_id' => $vid),
            'order' => array('id ASC')
        ));
        return $tv;
    }

    public function getemocodebydept($emp_code = NULL) {
        $comp_code = $_SESSION['Auth']['MyProfile']['comp_code'];
        App::import("Model", "MyProfile");
        $model = new MyProfile();
        $empinfo = $model->find('first', array(
            'fields' => array('MyProfile.dept_code'),
            'conditions' => array(
                'emp_code' => $emp_code,
                'comp_code' => $comp_code)
        ));

        return $empinfo['MyProfile']['dept_code'];
    }

    public function findcheckmulitpleLevel($id = NULL, $emp_dept_id = NULL) {
        App::import("Model", "WfMstAppMapLvl");
        $model = new WfMstAppMapLvl();
        $comp_code = $_SESSION['Auth']['MyProfile']['comp_code'];
        $query = $model->find('first', array(
            'fields' => array('WfMstAppMapLvl.wf_id'),
            'joins' => array(
                array(
                    'table' => 'wf_dt_app_map_lvl',
                    'alias' => 'DtAppMapLvl',
                    'type' => 'inner',
                    'foreignKey' => false,
                    'conditions' => array('DtAppMapLvl.wf_app_map_lvl_id = WfMstAppMapLvl.wf_id')
                )
            ),
            'conditions' => array(
                'WfMstAppMapLvl.comp_code' => $comp_code,
                'WfMstAppMapLvl.wf_dept_id' => $emp_dept_id,
                'WfMstAppMapLvl.wf_app_id' => $id)
        ));
        if (!empty($query['WfMstAppMapLvl']['wf_id'])) {
            return $query['WfMstAppMapLvl']['wf_id'];
        } else {
            return 0;
        }
    }

    public function findLeaveType($leave_code = null) {

        App::import("Model", "OptionAttribute");
        $model = new OptionAttribute();
        $query = $model->find('first', array(
            'conditions' => array('OptionAttribute.id' => $leave_code, 'OptionAttribute.options_id' => 21)
        ));

        if (empty($query['OptionAttribute']['name'])) {
            return 0;
        } else {
            return $query['OptionAttribute']['name'];
        }
    }

    public function countPendingLeave($emp_code, $leave_code, $leave_id = '""') {

        App::import("Model", "LeaveDetail");
        $model = new LeaveDetail();
        App::import("Model", "WeekHolidayList");
        $WeekHolidayList = new WeekHolidayList();
        $Penleavecount = $model->find('count', array(
            'conditions' => array(
                'emp_code' => $emp_code,
                'leave_status IN (2,3,6,7)',
                'leave_id != ' . $leave_id,
                'leave_code' => $leave_code,
                'hlfday_leave_chk' => 'N')
        ));
        $halfleavecount = $model->find('count', array(
            'conditions' => array(
                'emp_code' => $emp_code,
                'leave_status IN (2,3,6,7)',
                'leave_code' => $leave_code,
                'hlfday_leave_chk' => 'Y')
        ));

        $dummyPenleavecount = $model->find('list', array(
            'fields' => array('leave_date'),
            'conditions' => array(
                'emp_code' => $emp_code,
                'leave_status IN (2,3,6,7)',
                'leave_code' => $leave_code,
                'hlfday_leave_chk' => 'N')
        ));

        if ($leave_code == 'PAR0000063') {
            $week = $WeekHolidayList->find('list', array(
                'fields' => array('dt')
            ));

            $arr = array_diff($dummyPenleavecount, $week);
        } else {
            $arr = $dummyPenleavecount;
        }

        $half = $halfleavecount / 2;

        return count($arr) + $half;
    }

    public function countAppliedLeave($emp_code, $leave_code) {
        App::import("Model", "LeaveDetail");
        $model = new LeaveDetail();
        App::import("Model", "WeekHolidayList");
        $WeekHolidayList = new WeekHolidayList();
        $Penleavecount = $model->find('count', array(
            'conditions' => array(
                'emp_code' => $emp_code,
                'leave_status' => '5',
                'leave_code' => $leave_code,
                'hlfday_leave_chk' => 'N')
        ));
        $dummyPenleavecount = $model->find('list', array(
            'fields' => array('leave_date'),
            'conditions' => array(
                'emp_code' => $emp_code,
                'leave_status' => '5',
                'leave_code' => $leave_code,
                'hlfday_leave_chk' => 'N')
        ));
        if ($leave_code == 'PAR0000064' && $leave_code == 'PAR0000065' && $leave_code == 'PAR0000069') {
            $week = $WeekHolidayList->find('list', array(
                'fields' => array('dt')
            ));

            $arr = array_diff($dummyPenleavecount, $week);
        } else {
            $arr = $dummyPenleavecount;
        }

        $halfleavecount = $model->find('count', array(
            'conditions' => array(
                'emp_code' => $emp_code,
                'leave_status' => '5',
                'leave_code' => $leave_code,
                'hlfday_leave_chk' => 'Y')
        ));
        $half = $halfleavecount / 2;
        return count($arr) + $half;
    }

    function getlevelbylvid($id) {
        App::import('Model', 'LeaveWorkflow');
        $model = new LeaveWorkflow();
        $level = $model->find('all', array('conditions' => array('leave_id' => $id), 'order' => array('leave_wf_id ASC')));
        return $level;
    }

    function getlevelAll($id) {
        App::import('Model', 'LeaveWorkflow');
        $model = new LeaveWorkflow();
        $level = $model->find('all', array('conditions' => array('leave_id' => $id, '(LeaveWorkflow.status NOT IN(3)  OR LeaveWorkflow.status Is NULL)'), 'order' => array('leave_wf_id ASC')));
        return $level;
    }

    function getConveyencelevel($id) {
        App::import('Model', 'ConveyenceWorkflow');
        $model = new ConveyenceWorkflow();
        $level = $model->find('all', array('conditions' => array('voucher_id' => $id, '(ConveyenceWorkflow.status NOT IN(3)  OR ConveyenceWorkflow.status Is NULL)'), 'order' => array('id ASC')));
        return $level;
    }

    function getTravellevel($id) {
        App::import('Model', 'TravelWfLvl');
        $model = new TravelWfLvl();
        $level = $model->find('all', array('conditions' => array('voucher_id' => $id, '(TravelWfLvl.voucher_status NOT IN(3)  OR TravelWfLvl.voucher_status Is NULL)'), 'order' => array('id ASC')));
        return $level;
    }

    function getLtaBalance($emp_id) {
        App::import('Model', 'LtaBalance');
        $model = new LtaBalance();
        App::import('Model', 'MyProfile');
        $myprofile = new MyProfile();

        $lta_emp_id = $myprofile->find('first', array('fields' => array('emp_id'), 'conditions' => array('emp_code' => $emp_id)));
        $lta_balance = $model->find('first', array('fields' => array('*'), 'conditions' => array('emp_id' => $lta_emp_id['MyProfile']['emp_id'])));
        return $lta_balance['LtaBalance']['lta_years'];
    }

    function getltalevelbyid($id) {
        App::import('Model', 'LtaWorkflow');
        $model = new LtaWorkflow();
        $level = $model->find('all', array('conditions' => array('lta_bill_amount_id' => $id), 'order' => array('id ASC')));
        return $level;
    }

    function gettemplevelbyid($id) {

        App::import('Model', 'TempWorkflow');
        $model = new TempWorkflow();
        $level = $model->find('all', array('conditions' => array('employee_sal_mon_id' => $id), 'order' => array('id ASC')));
        return $level;
    }

    function getmedicallevelbyid($id) {
        App::import('Model', 'MedicalWorkflow');
        $model = new MedicalWorkflow();
        $level = $model->find('all', array('conditions' => array('medical_bill_amount_id' => $id), 'order' => array('id ASC')));
        return $level;
    }

    function getEncshlevelbylvid($id) {
        App::import('Model', 'LeaveEncashmentWorkflow');
        $model = new LeaveEncashmentWorkflow();
        $level = $model->find('all', array('conditions' => array('leave_encsh_id' => $id), 'order' => array('id ASC')));
        return $level;
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

    function checkforrevert($id, $v_id) {
        $comp_code = $_SESSION['Auth']['MyProfile']['comp_code'];
        $emp_dept_id = $_SESSION['Auth']['MyProfile']['dept_code'];
        $emp_desg_id = $_SESSION['Auth']['MyProfile']['desg_code'];
        App::import("Model", "DtAppMapLvl");
        $model = new DtAppMapLvl();
        $query = $model->find('all', array(
            'fields' => array('DtAppMapLvl.wf_id', 'DtAppMapLvl.wf_lvl', 'DtAppMapLvl.wf_desg_id', 'DtAppMapLvl.wf_app_map_lvl_id'),
            'joins' => array(
                array(
                    'table' => 'wf_mst_app_map_lvl',
                    'alias' => 'WfMstAppMapLvl',
                    'type' => 'inner',
                    'foreignKey' => false,
                    'conditions' => array('DtAppMapLvl.wf_app_map_lvl_id = WfMstAppMapLvl.wf_id')
                )
            ),
            'conditions' => array('WfMstAppMapLvl.wf_app_id' => $id, 'DtAppMapLvl.wf_desg_id' => $emp_desg_id)
        ));
        if (empty($query))
            return false;
        $getlvl = $query[0]['DtAppMapLvl']['wf_lvl'];
        $lvl = explode('Level', $getlvl);
        $approver_lvl = $lvl[1];
        if ($id == 1) {
            App::import("Model", "MstEmpExpVoucher");
            $model1 = new MstEmpExpVoucher();
            $res = $model1->find('first', array('conditions' => array('voucher_id' => $v_id)));
            $desg = $this->getempdesgcode($res['MstEmpExpVoucher']['emp_code']);
            $dept = $this->getemocodebydept($res['MstEmpExpVoucher']['emp_code']);
            $check = $model->find('first', array('conditions' => array('DtAppMapLvl.wf_app_map_lvl_id' => $query[0]['DtAppMapLvl']['wf_app_map_lvl_id'], 'DtAppMapLvl.wf_desg_id' => $desg, 'DtAppMapLvl.wf_dept_id' => $dept)));

            if (empty($check) && $approver_lvl == 1) {
                return false;
            } else if (!empty($check['DtAppMapLvl'])) {
                $getlvl = $check['DtAppMapLvl']['wf_lvl'];
                $lvl = explode('Level', $getlvl);
                $emp_lvl = $lvl[1];

                if ($approver_lvl - $emp_lvl == 1)
                    return false;
                else
                    return true;
            } else
                return true;
        }
        elseif ($id == 2) {
            App::import("Model", "MstEmpLeave");
            $model1 = new MstEmpLeave();
            $res = $model1->find('first', array('conditions' => array('leave_id' => $v_id)));
            $desg = $this->getempdesgcode($res['MstEmpLeave']['emp_code']);
            $dept = $this->getemocodebydept($res['MstEmpLeave']['emp_code']);
            $check = $model->find('first', array('conditions' => array('DtAppMapLvl.wf_app_map_lvl_id' => $query[0]['DtAppMapLvl']['wf_app_map_lvl_id'], 'DtAppMapLvl.wf_desg_id' => $desg, 'DtAppMapLvl.wf_dept_id' => $dept)));
            if (empty($check) && $approver_lvl == 1) {
                return false;
            } else if (!empty($check['DtAppMapLvl'])) {
                $getlvl = $check['DtAppMapLvl']['wf_lvl'];
                $lvl = explode('Level', $getlvl);
                $emp_lvl = $lvl[1];

                if ($approver_lvl - $emp_lvl == 1)
                    return false;
                else
                    return true;
            } else
                return true;
        }
        else if ($id == 3) {
            App::import("Model", "MstEmpExpVoucher");
            $model1 = new MstEmpExpVoucher();
            $res = $model1->find('first', array('conditions' => array('voucher_id' => $v_id))); //pr($res);
            $desg = $this->getempdesgcode($res['MstEmpExpVoucher']['emp_code']); //die;
            $dept = $this->getemocodebydept($res['MstEmpExpVoucher']['emp_code']);
            $check = $model->find('first', array('conditions' => array('DtAppMapLvl.wf_app_map_lvl_id' => $query[0]['DtAppMapLvl']['wf_app_map_lvl_id'], 'DtAppMapLvl.wf_desg_id' => $desg, 'DtAppMapLvl.wf_dept_id' => $dept)));
            if (empty($check) && $approver_lvl == 1) {
                return false;
            } else if (!empty($check['DtAppMapLvl'])) {
                $getlvl = $check['DtAppMapLvl']['wf_lvl'];
                $lvl = explode('Level', $getlvl);
                $emp_lvl = $lvl[1];

                if ($approver_lvl - $emp_lvl == 1)
                    return false;
                else
                    return true;
            } else
                return true;
        }
        return true;
    }

    public function checkleaverevert($leaveid) {
        $emp_code = $_SESSION['Auth']['MyProfile']['emp_code'];
        App::import("Model", "LeaveWorkflow");
        App::import("Model", "MyProfile");
        $model = new LeaveWorkflow();
        $model1 = new MyProfile();
        $flowlvl = $model->find('first', array('fields' => array('leave_wf_id'), 'conditions' => array('leave_id' => $leaveid, 'emp_code' => $emp_code)));

        if ($flowlvl) {
            $revert = $flowlvl['LeaveWorkflow']['leave_wf_id'] - 1;
            $revertemp = $model->find('first', array('fields' => array('leave_wf_id', 'emp_code'), 'conditions' => array('leave_wf_id' => $revert)));
            $revertemplist = $model1->find('list', array('fields' => array('emp_code', 'emp_firstname'), 'conditions' => array('emp_code' => $revertemp['LeaveWorkflow']['emp_code'])));
            return $revertemplist;
        }
    }

    public function checktravelrevert($travel) {
        $emp_code = $_SESSION['Auth']['MyProfile']['emp_code'];
        App::import("Model", "TravelWfLvl");
        App::import("Model", "MyProfile");
        $model = new TravelWfLvl();
        $model1 = new MyProfile();
        $flowlvl = $model->find('first', array('fields' => array('id'), 'conditions' => array('voucher_id' => $travel, 'emp_code' => $emp_code)));

        if ($flowlvl) {
            $revert = $flowlvl['TravelWfLvl']['id'] - 1;
            $revertemp = $model->find('first', array('fields' => array('id', 'emp_code'), 'conditions' => array('id' => $revert)));
            $revertemplist = $model1->find('list', array('fields' => array('emp_code', 'emp_firstname'), 'conditions' => array('emp_code' => $revertemp['TravelWfLvl']['emp_code'])));
            return $revertemplist;
        }
    }

    public function checkltarevert($id) {
        $emp_code = $_SESSION['Auth']['MyProfile']['emp_code'];
        App::import("Model", "LtaWorkflow");
        App::import("Model", "MyProfile");
        $model = new LtaWorkflow();
        $model1 = new MyProfile();
        $flowlvl = $model->find('first', array('fields' => array('id'), 'conditions' => array('id' => $id, 'emp_code' => $emp_code)));

        if ($flowlvl) {
            $revert = $flowlvl['LtaWorkflow']['id'] - 1;
            $revertemp = $model->find('first', array('fields' => array('id', 'emp_code'), 'conditions' => array('id' => $revert)));
            $revertemplist = $model1->find('list', array('fields' => array('emp_code', 'emp_firstname'), 'conditions' => array('emp_code' => $revertemp['LtaWorkflow']['emp_code'])));
            return $revertemplist;
        }
    }

    public function checktemprevert($id) {
        $emp_code = $_SESSION['Auth']['MyProfile']['emp_code'];
        App::import("Model", "TempWorkflow");
        App::import("Model", "MyProfile");
        $model = new TempWorkflow();
        $model1 = new MyProfile();
        $flowlvl = $model->find('first', array('fields' => array('id'), 'conditions' => array('id' => $id, 'emp_code' => $emp_code)));

        if ($flowlvl) {
            $revert = $flowlvl['TempWorkflow']['id'] - 1;
            $revertemp = $model->find('first', array('fields' => array('id', 'emp_code'), 'conditions' => array('id' => $revert)));
            $revertemplist = $model1->find('list', array('fields' => array('emp_code', 'emp_firstname'), 'conditions' => array('emp_code' => $revertemp['TempWorkflow']['emp_code'])));
            return $revertemplist;
        }
    }

    public function checkmedicalrevert($id) {
        $emp_code = $_SESSION['Auth']['MyProfile']['emp_code'];
        App::import("Model", "MedicalWorkflow");
        App::import("Model", "MyProfile");
        $model = new MedicalWorkflow();
        $model1 = new MyProfile();
        $flowlvl = $model->find('first', array('fields' => array('id'), 'conditions' => array('id' => $id, 'emp_code' => $emp_code)));

        if ($flowlvl) {
            $revert = $flowlvl['MedicalWorkflow']['id'] - 1;
            $revertemp = $model->find('first', array('fields' => array('id', 'emp_code'), 'conditions' => array('id' => $revert)));
            $revertemplist = $model1->find('list', array('fields' => array('emp_code', 'emp_firstname'), 'conditions' => array('emp_code' => $revertemp['MedicalWorkflow']['emp_code'])));
            return $revertemplist;
        }
    }

    public function checkconveyencerevert($conveyence) {
        $emp_code = $_SESSION['Auth']['MyProfile']['emp_code'];
        App::import("Model", "ConveyenceWorkflow");
        App::import("Model", "MyProfile");
        $model = new ConveyenceWorkflow();
        $model1 = new MyProfile();
        $flowlvl = $model->find('first', array('fields' => array('id'), 'conditions' => array('voucher_id' => $conveyence, 'emp_code' => $emp_code)));

        if ($flowlvl) {
            $revert = $flowlvl['ConveyenceWorkflow']['id'] - 1;
            $revertemp = $model->find('first', array('fields' => array('id', 'emp_code'), 'conditions' => array('id' => $revert)));
            $revertemplist = $model1->find('list', array('fields' => array('emp_code', 'emp_firstname'), 'conditions' => array('emp_code' => $revertemp['ConveyenceWorkflow']['emp_code'])));
            return $revertemplist;
        }
    }

    public function findCompanyName() {
        //function to find all company name
        App::import("Model", "Company");
        $model = new Company();
        $query = $model->find('list', array('fields' => array('comp_code', 'comp_name')));
        if (empty($query)) {
            return 0;
        } else {
            return $query;
        }
    }
    public function findModuleName() {
        //function to find all company name
        App::import("Model", "AdminOption");
        $model = new AdminOption();
        $query = $model->find('list', array('fields' => array('id', 'description')));
        if (empty($query)) {
            return 0;
        } else {
            return $query;
        }
    }

    function getRevertEmp($id) {
        App::import("Model", "LeaveWorkflow");
        $model = new LeaveWorkflow();
        $data = $model->find('first', array(
            'fields' => array('LeaveWorkflow.emp_code', "CONCAT_WS(' ',MyProfile.emp_firstname, MyProfile.emp_lastname) as emp_name"),
            'conditions' => array('LeaveWorkflow.leave_id = ' . $id, 'LeaveWorkflow.fw_date IS NOT NULL'),
            'order' => array('leave_wf_id DESC'),
            'joins' => array(
                array(
                    'table' => 'myprofile',
                    'alias' => 'MyProfile',
                    'type' => 'left',
                    'foreignKey' => false,
                    'conditions' => array('LeaveWorkflow.emp_code = MyProfile.emp_code')
                )
        )));
        if (!empty($data))
            return array($data['LeaveWorkflow']['emp_code'] => $data[0]['emp_name']);
        else
            return array();
    }

    public function findCompanyNameByCode($comp_code = null) {
        
        App::import("Model", "Company");
        $model = new Company();
        $query = $model->find('first', array('fields' => array('Company.comp_name'), 'conditions' => array('Company.comp_code' => $comp_code)));

        if (empty($query)) {
            return 0;
        } else {
            return $query['Company']['comp_name'];
        }
    }

    public function findDesignationNameByCode($desg_code = null) {
        
        //function to find all company name
        App::import("Model", "Designation");
        $model = new Designation();
        $query = $model->find('all', array('fields' => array('desc'), 'conditions' => array('Designation.desg_code' => $desg_code)));
        if (empty($query)) {
            return 0;
        } else {
            return $query[0]['Designation']['desc'];
        }
    }

    public function findUserDetailByEmpCode($emp_code = null) {
        //function to find all company name
        App::import("Model", "UserDetail");
        $model = new UserDetail();
        $query = $model->find('all', array('fields' => array('user_name', 'email'), 'conditions' => array('UserDetail.emp_code' => $emp_code)));
        if (empty($query)) {
            return 0;
        } else {
            return $query;
        }
    }

    public function getPendingLeave() {
        $emp_code = $_SESSION['Auth']['MyProfile']['emp_code'];
        App::import("Model", "LeaveDetail");
        $model = new LeaveDetail();
        $val = $model->find('count', array(
            'conditions' => array(
                'emp_code = ' . $emp_code,
                'leave_status IN (2,3,6)'
        )));
        if (empty($val)) {
            return 0;
        } else {
            return $val;
        }
    }

    public function getPendingSanctionLeave() {
        $emp_code = $_SESSION['Auth']['MyProfile']['emp_code'];
        App::import("Model", "LeaveWorkflow");
        $model = new LeaveWorkflow();
        $val = $model->find('count', array(
            'conditions' => array(
                'emp_code = ' . $emp_code,
                'status IS NULL',
                'fw_date IS NULL',
        )));
        if (empty($val)) {
            return 0;
        } else {
            return $val;
        }
    }

    public function todayBirthday() {
        App::import("Model", "MyProfile");
        $model = new MyProfile();
        $today = date('Y-m-d');
        $birthdays = $model->find("all", array(
            'fields' => array('emp_firstname', 'emp_lastname', 'image', 'dob'),
            'conditions' => array(
                "DATE_FORMAT(dob,'%m-%d') = DATE_FORMAT('$today','%m-%d')", "dob NOT IN ('0000-00-00')", 'status' => 32)
        ));
        return $birthdays;
    }

    public function upcomingBirthday() {
        App::import("Model", "MyProfile");
        $model = new MyProfile();
        $tomorow = date("Y-m-d", strtotime("+1 day"));
        $week = date("Y-m-d", strtotime("+1 week"));
        $upcoming_bday = $model->find("all", array(
            'fields' => array('emp_firstname', 'emp_lastname', 'image', 'dob'),
            'conditions' => array("DATE_FORMAT(dob,'%m-%d') BETWEEN DATE_FORMAT('$tomorow','%m-%d') AND DATE_FORMAT('$week','%m-%d')", "dob NOT IN ('0000-00-00')", 'status' => 32),
            'order' => "DAYOFYEAR(dob) ASC"
        ));
        return $upcoming_bday;
    }

    public function getLeaveType() {
        App::import("Model", "OptionAttribute");
        $model = new OptionAttribute();
        $query = $model->find('list', array('fields' => array('id', 'name'), 'conditions' => array('options_id' => 21)));
        if (empty($query)) {
            return 0;
        } else {
            return $query;
        }
    }

    public function getempname($emp_code = NULL) {
        App::import("Model", "MyProfile");
        $model = new MyProfile();
        $empinfo = $model->find('first', array(
            'fields' => array('MyProfile.emp_name'),
            'conditions' => array(
                'emp_code' => $emp_code)
        ));
        if (!empty($empinfo))
            return $empinfo['MyProfile']['emp_name'];
        else
            return 'No record found';
    }

    public function getemplist() {
        App::import("Model", "MyProfile");
        $model = new MyProfile();
        $empinfo = $model->find('list', array(
            'fields' => array('MyProfile.emp_code', 'MyProfile.emp_name')
        ));
        if (!empty($empinfo))
            return $empinfo;
        else
            return 'No record found';
    }
    public function getemplistbyDept($dept_id) {
        App::import("Model", "MyProfile");
        $model = new MyProfile();
        $empinfo = $model->find('list', array(
            'fields' => array('MyProfile.emp_code', 'MyProfile.emp_name'),
            'conditions' => array('dept_code' => $dept_id)
        ));
        if (!empty($empinfo))
            return $empinfo;
        else
            return 'No record found';
    }
    
    public function employeelistMultibyDept($val) {
        $employee_name = $this->MyProfile->find('list', array('fields' => array('emp_code', 'emp_name'),
            'conditions' => array('dept_code' => $val),
            'order' => array('MyProfile.emp_name'=> 'DESC')
        ));
        $xyz = "";
        foreach ($employee_list as $k => $val) { 
            $xyz .= '<option  value="$k">$val</option>';
        }
        $html = '<script src="<?php echo $this->webroot ?>js/js/pages/kendoui.min.js"></script>
                <label for="kUI_multiselect_basic" class="uk-form-label">Select Employee</label>
                <select id="kUI_multiselect_basic" name="employee_id[]" required="" id="employee_id" multiple="multiple" data-placeholder="Select Employee...">
                $xyz</select>';
        $this->set("employee_list", $employee_name);
    }

    function getApplicationNamebyid($wf_app_id) {
        App::import("Model", "Applications");
        $model = new Applications();
        $app_name = $model->find('first', array(
            'fields' => array('vc_application_name'),
            'conditions' => array('id=' . $wf_app_id,
                'wf_status ="1"',
        )));
        return $app_name['Applications']['vc_application_name'];
    }

    function getApplicationList() {
        App::import("Model", "Applications");
        $model = new Applications();
        $app_namelist = $model->find('list', array(
            'fields' => array('id', 'vc_application_name'),
            'conditions' => array('wf_status ="1"'
        )));
        return $app_namelist;
    }

    function getModuleList() {
        App::import("Model", "LabelModule");
        $model = new LabelModule();
        $app_namelist = $model->find('list', array(
            'fields' => array('id', 'name'),
            'conditions' => array('label_status ="1"'
        )));
        return $app_namelist;
    }

    public function findAllDepartmentName($comp_code = null) { //echo 'ss='.$comp_code;
        App::import("Model", "Department");
        $model = new Department();
        if (!empty($comp_code))
            $conditions = array('status' => true, 'comp_code' => $comp_code);
        else
            $conditions = array();
        $dept_name = $model->find("list", array(
            'fields' => array('Department.dept_code', 'Department.dept_name'),
            'conditions' => $conditions
        )); //pr($conditions);
        if (!empty($dept_name))
            return $dept_name;
        else
            return false;
    }
    
    public function findAllDepartmentWithIconsAndName($comp_code = null) {
        App::import("Model", "Department");
        $model = new Department();
        
        $dept_name = $model->find("all", array(
            'fields' => array('Department.dept_code', 'Department.dept_name','Department.icon_style'),
            'order' => array('dept_name ASC')
        )); //pr($conditions);
        if (!empty($dept_name))
            return $dept_name;
        else
            return false;
    }

    //Find All Resignation Name
    public function findAllResignationName() {
        App::import("Model", "Resignation");
        $resignation = new Resignation();
        $resig_list = $resignation->find("list", array(
            'fields' => array('Resignation.id', 'Resignation.reason')
        ));

        if (!empty($resig_list))
            return $resig_list;
        else
            return '';
    }

    //Find All Resignation Name
    public function findResignation($id) {

        App::import("Model", "Resignation");
        $resignation = new Resignation();
        $resig_list = $resignation->find("first", array(
            'fields' => array('Resignation.reason'),
            'conditions' => array('id' => $id)
        ));

        if (!empty($resig_list))
            return $resig_list['Resignation']['reason'];
        else
            return '';
    }

    public function findAllWheelerMode() {
        App::import("Model", "MstTravelVoucher");
        $model = new MstTravelVoucher();
        $travel_mode = $model->find('list', array(
            'fields' => array('MstTravelVoucher.id', 'MstTravelVoucher.desc'),
            'conditions' => array('status' => true, 'type' => '3')
        ));
        if (!empty($travel_mode))
            return $travel_mode;
        else
            return false;
    }

    public function findWheelerType() {
        App::import("Model", "MstWheelerType");
        App::import("Model", "MstTravelVoucher");
        $model1 = new MstWheelerType();
        $model2 = new MstTravelVoucher();
        $wheeler_type = $model2->find('all', array(
            'fields' => array('MstTravelVoucher.desc', 'MstWheeler.price', 'MstTravelVoucher.id'),
            'joins' => array(
                array(
                    'table' => 'mst_wheeler_type',
                    'alias' => 'MstWheeler',
                    'type' => 'INNER',
                    'foreignKey' => false,
                    'conditions' => array('MstWheeler.name = MstTravelVoucher.id')
                )
            ),
            'conditions' => array('MstTravelVoucher.type' => '3', 'MstTravelVoucher.status' => true)
        ));

        if (!empty($wheeler_type))
            return $wheeler_type;
        else
            return false;
    }

    public function findAllTravelMode() {
        App::import("Model", "MstTravelMode");
        $model = new MstTravelMode();
        $travel_mode = $model->find('list', array(
            'fields' => array('MstTravelMode.id', 'MstTravelMode.name'),
            'conditions' => array('status' => true)
        ));
        if (!empty($travel_mode))
            return $travel_mode;
        else
            return false;
    }

    public function findTravelModeById($id) {
        App::import("Model", "MstTravelVoucher");
        $model = new MstTravelVoucher();
        $mode_name = $model->find('all', array(
            'fields' => array('MstTravelVoucher.desc'),
            'conditions' => array('status' => true, 'type' => '3', 'MstTravelVoucher.id' => $id)
        ));
        if (!empty($mode_name))
            return $mode_name[0]['MstTravelVoucher']['desc'];
        else
            return false;
    }

    function getconveyencelevelbylvid($id) {
        App::import('Model', 'ConveyenceWorkflow');
        $model = new ConveyenceWorkflow();
        $level = $model->find('all', array('conditions' => array('voucher_id' => $id), 'order' => array('id ASC')));
        return $level;
    }

    function getConveyenceRevertEmp($id) {
        App::import("Model", "ConveyenceWorkflow");
        $model = new ConveyenceWorkflow();
        $data = $model->find('first', array(
            'fields' => array('ConveyenceWorkflow.emp_code', "CONCAT_WS(' ',MyProfile.emp_firstname, MyProfile.emp_lastname) as emp_name"),
            'conditions' => array('ConveyenceWorkflow.voucher_id = ' . $id, 'ConveyenceWorkflow.fw_date IS NOT NULL'),
            'order' => array('ConveyenceWorkflow.id DESC'),
            'joins' => array(
                array(
                    'table' => 'myprofile',
                    'alias' => 'MyProfile',
                    'type' => 'left',
                    'foreignKey' => false,
                    'conditions' => array('ConveyenceWorkflow.emp_code = MyProfile.emp_code')
                )
        )));
        //pr($data); die;
        if (!empty($data))
            return array($data['ConveyenceWorkflow']['emp_code'] => $data[0]['emp_name']);
        else
            return array();
    }

    function checkForwardHr($appId, $v_id) {
        App::import("Model", "WfMstAppMapLvl");
        $model = new WfMstAppMapLvl();

        if ($appId == 2) {
            App::import("Model", "MstEmpLeave");
            $model1 = new MstEmpLeave();
            $res = $model1->find('first', array('conditions' => array('leave_id' => $v_id)));
            //$desg = $this->getempdesgcode($res['MstEmpLeave']['emp_code']);
            $dept = $this->getemocodebydept($res['MstEmpLeave']['emp_code']);
            $check = $model->find('first', array('conditions' => array('WfMstAppMapLvl.wf_app_id' => $appId, 'WfMstAppMapLvl.wf_dept_id' => $dept)));
            if ($check['WfMstAppMapLvl']['wf_hr_approval'] == 0)
                return false;
            if ($res['LeaveDetail'][0]['leave_status'] == 6)
                return false;
        }
        if ($appId == 3) {
            App::import("Model", "MstEmpExpVoucher");
            $model1 = new MstEmpExpVoucher();
            $res = $model1->find('first', array('conditions' => array('voucher_id' => $v_id)));
            $dept = $this->getemocodebydept($res['MstEmpExpVoucher']['emp_code']);
            $check = $model->find('first', array('conditions' => array('WfMstAppMapLvl.wf_app_id' => $appId, 'WfMstAppMapLvl.wf_dept_id' => $dept)));
            if ($check['WfMstAppMapLvl']['wf_hr_approval'] == 0)
                return false;
            if ($res['ConveyencExpenseDetail'][0]['conveyence_status'] == 6)
                return false;
        }
        return false;
    }

    /* function getHrList() {
      App::import("Model", "HrRoleAssign");
      $model = new HrRoleAssign();
      $hrs = $model->find('list', array('fields' => array('emp_code'), 'conditions' => array('status' => 1)));
      $allEmps = $this->listdesgbyemp();
      $allHr = array();
      foreach ($hrs as $k => $val) {
      $allHr[$val] = $allEmps[$val];
      }
      return $allHr;
      } */

    function gettravellevelbylvid($id) {
        App::import('Model', 'TravelWfLvl');
        $model = new TravelWfLvl();
        $level = $model->find('all', array('conditions' => array('voucher_id' => $id), 'order' => array('id ASC')));
        return $level;
    }

    function getTravelRevertEmp($id) {

        App::import("Model", "TravelWfLvl");
        $model = new TravelWfLvl();
        $data = $model->find('first', array(
            'fields' => array('TravelWfLvl.emp_code', "CONCAT_WS(' ',MyProfile.emp_firstname, MyProfile.emp_lastname) as emp_name"),
            'conditions' => array('TravelWfLvl.voucher_id = ' . $id, 'TravelWfLvl.fw_date IS NOT NULL'),
            'order' => array('TravelWfLvl.id DESC'),
            'joins' => array(
                array(
                    'table' => 'myprofile',
                    'alias' => 'MyProfile',
                    'type' => 'left',
                    'foreignKey' => false,
                    'conditions' => array('TravelWfLvl.emp_code = MyProfile.emp_code')
                )
        )));
        //pr($data); die;
        if (!empty($data))
            return array($data['TravelWfLvl']['emp_code'] => $data[0]['emp_name']);
        else
            return array();
    }

    function LtaRevertEmp($id) {
        App::import("Model", "LtaWorkflow");
        $model = new LtaWorkflow();
        $data = $model->find('first', array(
            'fields' => array('LtaWorkflow.emp_code', "CONCAT_WS(' ',MyProfile.emp_firstname, MyProfile.emp_lastname) as emp_name"),
            'conditions' => array('LtaWorkflow.id = ' . $id, 'LtaWorkflow.fw_date IS NOT NULL'),
            'order' => array('LtaWorkflow.id DESC'),
            'joins' => array(
                array(
                    'table' => 'myprofile',
                    'alias' => 'MyProfile',
                    'type' => 'left',
                    'foreignKey' => false,
                    'conditions' => array('LtaWorkflow.emp_code = MyProfile.emp_code')
                )
        )));
        //pr($data); die;
        if (!empty($data))
            return array($data['LtaWorkflow']['emp_code'] => $data[0]['emp_name']);
        else
            return array();
    }

    function findEmpLevelSequence($emp_code, $app_code) {
        App::import('Model', 'WfDtAppMapLvl');
        $wfdt = new WfDtAppMapLvl();
        App::import('Model', 'MyProfile');
        $profile = new MyProfile();
        $empinfo = $profile->find('first', array(
            'conditions' => array(
                'emp_code' => $emp_code
            )
        ));

        $data = $wfdt->find('first', array(
            'conditions' => array(
                'WfDtAppMapLvl.wf_dept_id' => $empinfo['MyProfile']['dept_code'],
                'WfDtAppMapLvl.wf_desg_id' => $empinfo['MyProfile']['desg_code'],
                'WfDtAppMapLvl.wf_app_map_lvl_id' => $app_code
            )
        ));
        if (!empty($data))
            return $data['WfDtAppMapLvl']['lvl_sequence'];
        else
            return array();
    }

    function moreLevelExists($levelSeq, $app_code) {
        App::import('Model', 'WfDtAppMapLvl');
        $wfdt = new WfDtAppMapLvl();

        $data = $wfdt->find('first', array(
            'conditions' => array(
                'WfDtAppMapLvl.lvl_sequence >' => $levelSeq,
                'WfDtAppMapLvl.wf_app_map_lvl_id' => $app_code
            )
        ));

        if (!empty($data))
            return true;
        else
            return false;
    }

    function getFnfFromSeperationId($sepId) {
        App::import('Model', 'Fnf');
        $fnf = new Fnf();
        $data = $fnf->find('first', array(
            'conditions' => array(
                'Fnf.separation_id' => $sepId,
            ),
            'fields' => array('id', 'status'),
        ));

        if (!empty($data))
            return $data['Fnf'];
        else
            return false;
    }

    public function findcheckLevelappraisal($id = NULL, $dept_code = NULL, $comp_Code = NULL) {
        $comp_code = $comp_Code;
        $emp_dept_id = $dept_code;

        App::import("Model", "WfMstAppMapLvl");
        $model = new WfMstAppMapLvl();
        $query = $model->find('first', array(
            'fields' => array('WfMstAppMapLvl.wf_id,DtAppMapLvl.wf_desg_id', 'WfMstAppMapLvl.review_degree'),
            'joins' => array(
                array(
                    'table' => 'wf_dt_app_map_lvl',
                    'alias' => 'DtAppMapLvl',
                    'type' => 'inner',
                    'foreignKey' => false,
                    'conditions' => array('DtAppMapLvl.wf_app_map_lvl_id = WfMstAppMapLvl.wf_id')
                )
            ),
            'conditions' => array(
                'WfMstAppMapLvl.comp_code' => $comp_code,
                'WfMstAppMapLvl.wf_dept_id' => $emp_dept_id,
                'WfMstAppMapLvl.wf_app_id' => $id)
        ));

        if (!empty($query['WfMstAppMapLvl']['wf_id'])) {
            return $query;
        } else {
            return 0;
        }
    }

    public function findAppraisalRep($emp_code, $comp_code) {


        App::import("Model", "MyProfile");

        $model = new MyProfile();
        $query = $model->find('first', array('fields' => array(
                'manager_code', 'dept_code', 'desg_code'), 'conditions' => array('emp_code' => $emp_code, 'comp_code' => $comp_code)));

        if (!empty($query['MyProfile']['manager_code'])) {
            $desglist = $model->find('list', array('fields' => array(
                    'emp_code', 'emp_firstname'), 'conditions' => array('emp_code' => $query['MyProfile']['manager_code'])));
        } else if ($query['MyProfile']['manager_code'] == NULL && !empty($query)) {

            $desglist = $this->listdesgbyemp('PAR0000044', $query['HcmDesgPrf']['dept_id']);
        } else {
            $desglist = array();
        }

        return $desglist;
    }

    public function findLevelappraisal($id = NULL, $type = 'Apply', $dept_code, $desg_code, $comp_code) {
        // print_r($id);die;
        $comp_code = $comp_code;
        $emp_dept_id = $dept_code;
        $emp_desg_id = $desg_code;
        App::import("Model", "DtAppMapLvl");
        $model = new DtAppMapLvl();
        $query = $model->find('all', array(
            'joins' => array(
                array(
                    'table' => 'wf_mst_app_map_lvl',
                    'alias' => 'WfMstAppMapLvl',
                    'type' => 'inner',
                    'foreignKey' => false,
                    'conditions' => array('DtAppMapLvl.wf_app_map_lvl_id = WfMstAppMapLvl.wf_id')
                )
            ),
            'conditions' => array('DtAppMapLvl.wf_app_map_lvl_id' => $id, 'DtAppMapLvl.wf_desg_id' => $emp_desg_id, 'DtAppMapLvl.wf_dept_id' => $emp_dept_id)
        ));

        if (count($query) > 0) {
            $getlvl = $query[0]['DtAppMapLvl']['wf_lvl'];
            $lvl = explode('Level', $getlvl);
            $maxlvl = $lvl[1] + 1;
            $level = 'Level' . $maxlvl;
        } else {
            $level = 'Level1';
        }
        //print_r($level);die;
        //Finds
        // level details for next level of approval
        $query1 = $model->find('first', array(
            'conditions' => array('DtAppMapLvl.wf_app_map_lvl_id' => $id, 'DtAppMapLvl.wf_lvl' => $level)
        ));

        //Checks whether current level employee has approval right for lower level employees
        if (!empty($query1['DtAppMapLvl']['wf_desg_id']) && $type == 'Apply') {
            $desglist = $this->listdesgbyemp($query1['DtAppMapLvl']['wf_desg_id'], $query1['DtAppMapLvl']['wf_dept_id']);
        } else if (!empty($query1['DtAppMapLvl']['wf_desg_id']) && $type == 'Forward' && @$query[0]['DtAppMapLvl']['skip_status'] != 1) {
            $desglist = $this->listdesgbyemp($query1['DtAppMapLvl']['wf_desg_id'], $query1['DtAppMapLvl']['wf_dept_id']);
        } else {
            $desglist = array();
        }
        // print_r($desglist);die;
        return $desglist;
    }

    public function findLevelseperation($id = NULL, $type = 'Apply', $dept_code, $desg_code, $comp_code) {
        // print_r($id);die;
        $comp_code = $comp_code;
        $emp_dept_id = $dept_code;
        $emp_desg_id = $desg_code;
        App::import("Model", "DtAppMapLvl");
        $model = new DtAppMapLvl();
        $query = $model->find('all', array(
            'joins' => array(
                array(
                    'table' => 'wf_mst_app_map_lvl',
                    'alias' => 'WfMstAppMapLvl',
                    'type' => 'inner',
                    'foreignKey' => false,
                    'conditions' => array('DtAppMapLvl.wf_app_map_lvl_id = WfMstAppMapLvl.wf_id')
                )
            ),
            'conditions' => array('DtAppMapLvl.wf_app_map_lvl_id' => $id, 'DtAppMapLvl.wf_desg_id' => $emp_desg_id, 'DtAppMapLvl.wf_dept_id' => $emp_dept_id)
        ));

        if (count($query) > 0) {
            $getlvl = $query[0]['DtAppMapLvl']['wf_lvl'];
            $lvl = explode('Level', $getlvl);
            $maxlvl = $lvl[1] + 1;
            $level = 'Level' . $maxlvl;
        } else {
            $level = 'Level1';
        }
        //print_r($level);die;
        //Finds
        // level details for next level of approval
        $query1 = $model->find('first', array(
            'conditions' => array('DtAppMapLvl.wf_app_map_lvl_id' => $id, 'DtAppMapLvl.wf_lvl' => $level)
        ));

        //Checks whether current level employee has approval right for lower level employees
        if (!empty($query1['DtAppMapLvl']['wf_desg_id']) && $type == 'Apply') {
            $desglist = $this->listdesgbyemp($query1['DtAppMapLvl']['wf_desg_id'], $query1['DtAppMapLvl']['wf_dept_id']);
        } else if (!empty($query1['DtAppMapLvl']['wf_desg_id']) && $type == 'Forward' && @$query[0]['DtAppMapLvl']['skip_status'] != 1) {
            $desglist = $this->listdesgbyemp($query1['DtAppMapLvl']['wf_desg_id'], $query1['DtAppMapLvl']['wf_dept_id']);
        } else {
            $desglist = array();
        }
        // print_r($desglist);die;
        return $desglist;
    }

    function findcountAppraiser($id) {
        App::import("Model", "Appraisers");
        $model = new Appraisers();

        $countAppraiser = $model->find('count', array(
            'conditions' => array(
                'Appraisers.request_id' => $id,
                'Appraisers.dt_appraise' => null
            )
        ));

        return $countAppraiser;
    }

    public function findAppraisalLevel($id) {

        App::import("Model", "Appraisers");
        $model = new Appraisers();

        $countAppraiser = $model->find('count', array(
            'conditions' => array(
                'Appraisers.request_id' => $id,
                'Appraisers.peer_appraiser IS  NULL'
            )
        ));

        return $countAppraiser;
    }

    function findfactoremplist() {
        App::import("Model", 'AppraisalFactorsMapping');
        $model = new AppraisalFactorsMapping();
        $emplist = $model->find('all', array(
            'fields' => array('*'),
            'conditions' => array('AppraisalFactorsMapping.myprofile_id' => '1')
        ));
        return $emplist;
    }

    function emplistfactors($id) {

        App::import("Model", 'MyProfile');
        App::import("Model", 'AppraisalFactorsMapping');
        $modelemp = new MyProfile();
        $model = new AppraisalFactorsMapping();
        $factor_emp = $model->find('all', array(
            'conditions' => array('AppraisalFactorsMapping.app_factors_id' => $id)
        ));

        if ($factor_emp) {

            foreach ($factor_emp as $factors) {
                $profile[] = $factors['appraisalFactorsMapping']['myprofile_id'];
            }
            $ids = implode(",", $profile);

            $emplist_factors = $modelemp->find('list', array(
                'fields' => array('MyProfile.id', 'MyProfile.emp_firstname'),
                'conditions' => array("MyProfile.id NOT IN($ids)")
            ));
        } else {
            $emplist_factors = $modelemp->find('list', array(
                'fields' => array('MyProfile.id', 'MyProfile.emp_firstname'),
            ));
        }
        return $emplist_factors;
    }

    public function peerlist($emp_code) {

        App::import("Model", 'MyProfile');
        $modelemp = new MyProfile();
        $desgCode = $modelemp->find('first', array(
            'fields' => array('MyProfile.desg_code'),
            'conditions' => array('MyProfile.emp_code' => $emp_code)
        ));

        //  print_r($desgCode['MyProfile']['desg_code']);die;
        $peerlist = $modelemp->find('list', array(
            'fields' => array('MyProfile.emp_code', 'MyProfile.emp_firstname'),
            'conditions' => array('MyProfile.desg_code' => $desgCode['MyProfile']['desg_code'], "MyProfile.emp_code NOT IN ($emp_code)")
        ));
        //print_r($peerlist);die;
        return $peerlist;
    }

    public function block_labels($id) {
        // print_r($id);die;
        App::import("Model", 'Labels');
        $modellabels = new Labels();
        $labels = $modellabels->find('all', array(
            'fields' => array('*'),
            'conditions' => array('Labels.label_block_id' => $id),
            'order' => array('Labels.priority')
        ));

        if ($labels) {
            return $labels;
        }
    }

    public function option_attribute($id) {

        $comp_code = $_SESSION['Auth']['MyProfile']['comp_code'];

        App::import("Model", 'OptionAttribute');
        $modelattri = new OptionAttribute();
        $attribute = $modelattri->find('list', array(
            'fields' => array('OptionAttribute.id', 'OptionAttribute.name'),
            'conditions' => array('OptionAttribute.options_id' => $id, 'org_id' => $comp_code),
        ));

        if ($attribute) {
            return $attribute;
        }
    }

    public function option_attribute_name($id) {


        $comp_code = $_SESSION['Auth']['MyProfile']['comp_code'];

        App::import("Model", 'OptionAttribute');
        $modelattri = new OptionAttribute();
        $attribute = $modelattri->find('list', array(
            'fields' => array('OptionAttribute.name'),
            'conditions' => array('OptionAttribute.id' => $id),
        ));
        return $attribute;
        if ($attribute) {
            return $attribute;
        } else {
            return 'not';
        }
    }

    public function findGenderName($id) {

        $comp_code = $_SESSION['Auth']['MyProfile']['comp_code'];

        App::import("Model", 'OptionAttribute');
        $modelattri = new OptionAttribute();
        $attribute = $modelattri->find('first', array(
            'fields' => array('OptionAttribute.name'),
            'conditions' => array('OptionAttribute.id' => $id),
        ));

        return $attribute['OptionAttribute']['name'];
        if ($attribute) {
            return $attribute['OptionAttribute']['name'];
        } else {
            return 'not';
        }
    }

    public function option_name($id) {

        App::import("Model", 'Options');
        $modelopt = new Options();
        $opt_name = $modelopt->find('list', array(
            'fields' => array('Options.id', 'Options.name'),
            'conditions' => array('Options.id' => $id),
        ));

        if ($opt_name) {
            return $opt_name;
        }
    }

    public function findEmpNameDocID($doc_id) {
        App::import("Model", 'MyProfile');
        $modelprofile = new MyProfile();
        $emp_name = $modelprofile->find('first', array(
            'fields' => array('MyProfile.emp_firstname', 'MyProfile.emp_lastname'),
            'conditions' => array('MyProfile.doc_id' => $doc_id)
        ));
        return $emp_name['MyProfile']['emp_firstname'] . " " . $emp_name['MyProfile']['emp_lastname'];
    }

    public function findEmpName($emp_code) {
        App::import("Model", 'MyProfile');
        $modelprofile = new MyProfile();
        $emp_name = $modelprofile->find('first', array(
            'fields' => array('MyProfile.emp_firstname', 'MyProfile.emp_lastname'),
            'conditions' => array('MyProfile.emp_code' => $emp_code)
        ));
        return $emp_name['MyProfile']['emp_firstname'] . " " . $emp_name['MyProfile']['emp_lastname'];
    }

    public function finddepEmpName($emp_id) {
        App::import("Model", 'MyProfile');
        $modelprofile = new MyProfile();
        $emp_name = $modelprofile->find('first', array(
            'fields' => array('MyProfile.emp_firstname', 'MyProfile.emp_lastname'),
            'conditions' => array('MyProfile.id' => $emp_id)
        ));
        return $emp_name['MyProfile']['emp_firstname'] . " " . $emp_name['MyProfile']['emp_lastname'];
    }

    public function gettravelmode($id = Null) {
        App::import("Model", 'MstTravelVoucher');
        $modelprofile = new MstTravelVoucher();
        $mode = $modelprofile->find('first', array(
            'fields' => array('desc'),
            'conditions' => array('id' => $id)
        ));
        $modename = $mode['MstTravelVoucher']['desc'];

        return $modename;
    }

    public function totalLeave() {
        App::import("Model", 'MstEmpLeaveAllot');
        $emp_code = $_SESSION['Auth']['MyProfile']['emp_code'];
        $modelLeaveAlot = new MstEmpLeaveAllot();
        $totalLeave = $modelLeaveAlot->find('list', array(
            'fields' => array('MstEmpLeaveAllot.leave_code', 'MstEmpLeaveAllot.leave_bal'),
            'conditions' => array('MstEmpLeaveAllot.emp_code' => $emp_code)
        ));
        $sum = 0;
        foreach ($totalLeave as $k => $val) {
            $sum = $sum + $val;
        }
        if (!empty($sum)) {
            return $sum;
        } else {
            return 0;
        }
    }

    public function travelVoucherApplied() {
        App::import("Model", 'DtTravelVoucher');
        $modelTravel = new DtTravelVoucher();
        $emp_code = $_SESSION['Auth']['MyProfile']['emp_code'];
        $totalApplied = $modelTravel->find('count', array(
            'fields' => array('DtTravelVoucher.id'),
            'conditions' => array('DtTravelVoucher.emp_code' => $emp_code, 'DtTravelVoucher.travel_status' => 5)
        ));
        if (!empty($totalApplied)) {
            return $totalApplied;
        } else {
            return 0;
        }
    }

    public function totAppraisal() {
        App::import("Model", 'Appraisals');
        $modelApp = new Appraisals();
        $emp_code = $_SESSION['Auth']['MyProfile']['emp_code'];
        $totalApp = $modelApp->find('count', array(
            'fields' => array('Appraisals.id'),
            'conditions' => array('Appraisals.emp_code' => $emp_code, 'Appraisals.ch_status' => 'Complete')
        ));
        // print_r($totalApp);die;
        if (!empty($totalApp)) {
            return $totalApp;
        } else {
            return 0;
        }
    }

    public function leavePen() {
        App::import("Model", 'LeaveDetail');
        $modelleavepen = new LeaveDetail();
        $emp_code = $_SESSION['Auth']['MyProfile']['emp_code'];
        $totalleavepen = $modelleavepen->find('count', array(
            'fields' => array('id'),
            'conditions' => array('emp_code' => $emp_code, 'leave_status' => array(2, 3, 8, 7))
        ));
        if (!empty($totalleavepen)) {
            return $totalleavepen;
        } else {
            return 0;
        }
    }

    public function travelPen() {
        App::import("Model", 'DtTravelVoucher');
        $modelTravel = new DtTravelVoucher();
        $emp_code = $_SESSION['Auth']['MyProfile']['emp_code'];
        $totalpen = $modelTravel->find('count', array(
            'fields' => array('id'),
            'conditions' => array('emp_code' => $emp_code, 'travel_status' => array(2, 3, 7, 8, 6))
        ));
        if (!empty($totalpen)) {
            return $totalpen;
        } else {
            return 0;
        }
    }

    public function totTraining() {
        App::import("Model", 'TrainingRequest');
        $modelTraining = new TrainingRequest();
        $emp_code = $_SESSION['Auth']['MyProfile']['emp_code'];
        $totaltraining = $modelTraining->find('count', array(
            'fields' => array('id'),
            'conditions' => array('trainee_code' => $emp_code)
        ));
        if (!empty($totaltraining)) {
            return $totaltraining;
        } else {
            return 0;
        }
    }

    //Kra Function Start
    public function findDepartmentId($dept_code = null) {

        App::import("Model", "Departments");
        $model = new Departments();
        $query = $model->find('first', array(
            'fields' => array('Departments.id'),
            'conditions' => array(
                'Departments.dept_code' => $dept_code)
        ));
        if (!empty($query['Departments']['id'])) {
            return $query['Departments']['id'];
        } else {
            return 0;
        }
    }

    public function findTargetNameById($id = null) {

        App::import("Model", "Target");
        $model = new Target();
        $query = $model->find('first', array(
            'fields' => array('Target.target_name'),
            'conditions' => array(
                'Target.id' => $id)
        ));
        if (!empty($query['Target']['target_name'])) {
            return $query['Target']['target_name'];
        } else {
            return 0;
        }
    }

    public function kpiCalculation($targetAchived, $target, $weightage) {
        $score = ($targetAchived / $weightage * 100);
        return number_format((float) $score, 2, '.', '') . "%";
    }

    public function kpiCalculationUnits($targetAchived, $target, $weightage) {
        $score = ($targetAchived * $weightage / 100);
        return $score;
    }

    public function getKpiUnits($kpi_masters_id, $kra_masters_id, $kpi_map_emps_id) {
        $comp_code = $_SESSION['Auth']['MyProfile']['comp_code'];

        App::import("Model", "KraKpiProcess");
        $model = new KraKpiProcess();
        $empinfo = $model->find('first', array(
            'fields' => array('units'),
            'conditions' => array(
                'kpi_masters_id' => $kpi_masters_id,
                'kra_masters_id' => $kra_masters_id,
                'kpi_map_emps_id' => $kpi_map_emps_id
            )
        ));
        if (!empty($empinfo))
            return $empinfo['kra_kpi_process']['units'];
        else
            return '';
    }

    public function getKpiQuarter($kpi_masters_id, $kra_masters_id, $kpi_map_emps_id) {
        $comp_code = $_SESSION['Auth']['MyProfile']['comp_code'];

        App::import("Model", "KraKpiProcess");
        $model = new KraKpiProcess();
        $empinfo = $model->find('first', array(
            'fields' => array('units'),
            'conditions' => array(
                'kpi_masters_id' => $kpi_masters_id,
                'kra_masters_id' => $kra_masters_id,
                'kpi_map_emps_id' => $kpi_map_emps_id
            )
        ));
        if (!empty($empinfo))
            return $empinfo['kra_kpi_process']['process_quarter'];
        else
            return '';
    }

    public function getKpiQuarters($kpi_masters_id, $kra_masters_id, $kpi_map_emps_id, $quarter = 0) {
        App::import("Model", "KraKpiProcess");
        $model = new KraKpiProcess();
        $empinfo = $model->find('first', array(
            'fields' => array('units'),
            'conditions' => array(
                'kpi_masters_id' => $kpi_masters_id,
                'kra_masters_id' => $kra_masters_id,
                'kpi_map_emps_id' => $kpi_map_emps_id,
                'process_quarter' => $quarter
            )
        ));
        if (!empty($empinfo))
            return true;
        else
            return false;
    }

    public function getKpiQuarterAllDetail($kpi_masters_id, $kra_masters_id, $kpi_map_emps_id) {
        App::import("Model", "KraKpiProcess");
        $model = new KraKpiProcess();
        $empinfo = $model->find('all', array(
            'conditions' => array(
                'kpi_masters_id' => $kpi_masters_id,
                'kra_masters_id' => $kra_masters_id,
                'kpi_map_emps_id' => $kpi_map_emps_id
            ),
            'order' => 'process_quarter ASC'
        ));

        if (!empty($empinfo))
            return $empinfo;
        else
            return '';
    }

    public function getKpiQuarterAllCalculation($kpi_masters_id, $kra_masters_id, $kpi_map_emps_id) {
        App::import("Model", "KraKpiProcess");
        $model = new KraKpiProcess();
        $empinfo = $model->find('all', array(
            'conditions' => array(
                'kpi_masters_id' => $kpi_masters_id,
                'kra_masters_id' => $kra_masters_id,
                'kpi_map_emps_id' => $kpi_map_emps_id
            ),
            'order' => 'process_quarter ASC'
        ));
        App::import("Model", "KpiMapEmps");
        $model1 = new KpiMapEmps();
        $kpiMapEmp = $model1->find('all', array(
            'conditions' => array(
                'id' => $kpi_map_emps_id
            )
        ));

        if (!empty($empinfo)) {
            $cot = count($empinfo);
            $tot = 0;
            foreach ($empinfo as $empinfoes) {
                $tot+=$empinfoes['kra_kpi_process']['units'];
            }
        }
        if (!empty($tot))
            return $tot . "  (" . $this->kpiCalculation($tot, '100', $kpiMapEmp[0]['kpi_map_emps']['weightage']) . ")";
        else
            return '';
    }

    public function getKpiQuarterAllCalculationOne($kpi_masters_id, $kra_masters_id, $kpi_map_emps_id) {
        App::import("Model", "KraKpiProcess");
        $model = new KraKpiProcess();
        $empinfo = $model->find('all', array(
            'conditions' => array(
                'kpi_masters_id' => $kpi_masters_id,
                'kra_masters_id' => $kra_masters_id,
                'kpi_map_emps_id' => $kpi_map_emps_id
            ),
            'order' => 'process_quarter ASC'
        ));
        App::import("Model", "KpiMapEmps");
        $model1 = new KpiMapEmps();
        $kpiMapEmp = $model1->find('all', array(
            'conditions' => array(
                'id' => $kpi_map_emps_id
            )
        ));

        if (!empty($empinfo)) {
            $cot = count($empinfo);
            $tot = 0;
            foreach ($empinfo as $empinfoes) {
                $tot+=$empinfoes['kra_kpi_process']['units'];
            }
        }
        if (!empty($tot))
            return $tot;
        else
            return '';
    }

    public function getKraQuarterAllCalculation($kra_masters_id, $kra_map_emp_id) {
        App::import("Model", "KraKpiProcess");
        $model = new KraKpiProcess();
        $empinfo = $model->find('all', array(
            'conditions' => array(
                'kra_masters_id' => $kra_masters_id,
                'kra_map_emp_id' => $kra_map_emp_id
            )
        ));
        App::import("Model", "KraMapEmp");
        $model1 = new KraMapEmp();
        $kraMapEmp = $model1->find('all', array(
            'conditions' => array(
                'id' => $kra_map_emp_id
            )
        ));
        if (!empty($empinfo)) {
            $cot = count($empinfo);
            $tot = 0;
            foreach ($empinfo as $empinfoes) {
                $tot+=$empinfoes['kra_kpi_process']['units'];
            }
        }
        if (!empty($tot))
            return $tot . "  (" . $this->kpiCalculation($tot, '100', $kraMapEmp[0]['kra_map_emp']['weightage']) . ")";
        else
            return '';
    }

    public function getKpiQuarterDetail($kpi_masters_id, $kra_masters_id, $kpi_map_emps_id, $quarter) {
        App::import("Model", "KraKpiProcess");
        $model = new KraKpiProcess();
        $empinfo = $model->find('first', array(
            'joins' => array(
                array(
                    'table' => 'kpi_masters',
                    'alias' => 'KpiMaster',
                    'type' => 'INNER',
                    'conditions' => array(
                        'KpiMaster.id = kra_kpi_process.kpi_masters_id'
                    )
                ),
                array(
                    'table' => 'kpi_map_emps',
                    'alias' => 'KpiMapEmps',
                    'type' => 'INNER',
                    'conditions' => array(
                        'KpiMapEmps.id = kra_kpi_process.kpi_map_emps_id'
                    )
                ),
                array(
                    'table' => 'kra_masters',
                    'alias' => 'KraMaster',
                    'type' => 'INNER',
                    'conditions' => array(
                        'KraMaster.id = kra_kpi_process.kra_masters_id'
                    )
                )
            ),
            'conditions' => array(
                'kra_kpi_process.kpi_masters_id' => $kpi_masters_id,
                'kra_kpi_process.kra_masters_id' => $kra_masters_id,
                'kra_kpi_process.kpi_map_emps_id' => $kpi_map_emps_id,
                'kra_kpi_process.process_quarter' => $quarter
            ),
            'fields' => array('kra_kpi_process.*', 'KpiMapEmps.*', 'KpiMaster.*', 'KraMaster.*'),
            'order' => 'KpiMaster.created_at DESC'
        ));
        if (!empty($empinfo))
            return $empinfo;
        else
            return '';
    }

    public function getKpiQuarterCount($kpi_masters_id, $kra_masters_id, $kpi_map_emps_id) {
        App::import("Model", "KraKpiProcess");
        $model = new KraKpiProcess();
        $empinfo = $model->find('all', array(
            'fields' => array('units'),
            'conditions' => array(
                'kpi_masters_id' => $kpi_masters_id,
                'kra_masters_id' => $kra_masters_id,
                'kpi_map_emps_id' => $kpi_map_emps_id
            )
        ));
        $tmp = count($empinfo);
        if (!empty($tmp))
            return $tmp;
        else
            return '';
    }

    public function getKpiQuarterCheck($kpi_masters_id, $kra_masters_id, $kpi_map_emps_id) {
        App::import("Model", "KpiMapEmps");
        $model1 = new KpiMapEmps();
        $kpiValues = $model1->find('first', array(
            'joins' => array(
                array(
                    'table' => 'myprofile',
                    'alias' => 'MyProfile',
                    'type' => 'INNER',
                    'conditions' => array(
                        'MyProfile.emp_code = kpi_map_emps.myprofile_id'
                    )
                ),
                array(
                    'table' => 'kpi_masters',
                    'alias' => 'KpiMaster',
                    'type' => 'INNER',
                    'conditions' => array(
                        'KpiMaster.id = kpi_map_emps.kpi_masters_id'
                    )
                )
                ,
                array(
                    'table' => 'kra_masters',
                    'alias' => 'KraMaster',
                    'type' => 'INNER',
                    'conditions' => array(
                        'KraMaster.id = kpi_map_emps.kra_masters_id'
                    )
                )
            ),
            'conditions' => array(
                'kpi_map_emps.myprofile_id' => $_SESSION['Auth']['MyProfile']['emp_code'],
                'kpi_map_emps.id' => $kpi_masters_id
            ),
            'fields' => array('kpi_map_emps.*', 'KpiMaster.*', 'MyProfile.*', 'KraMaster.*'),
            'order' => 'KpiMaster.created_at DESC'
        ));

        $quarter = $this->__calcAssessmentTab($kpiValues['kpi_map_emps']['target'], $kpiValues['kpi_map_emps']['from_date'], $kpiValues['kpi_map_emps']['to_date']);
        App::import("Model", "KraKpiProcess");
        $model = new KraKpiProcess();
        $empinfo = $model->find('all', array(
            'fields' => array('units'),
            'conditions' => array(
                'kpi_masters_id' => $kpi_masters_id,
                'kra_masters_id' => $kra_masters_id,
                'kpi_map_emps_id' => $kpi_map_emps_id
            )
        ));

        if (count($empinfo) == $quarter)
            return false;
        else
            return true;
    }

    public function getKraUnits($kra_masters_id, $kra_map_emp_id) {
        $comp_code = $_SESSION['Auth']['MyProfile']['comp_code'];

        App::import("Model", "KraKpiProcess");
        $model = new KraKpiProcess();
        $empinfo = $model->find('first', array(
            'fields' => array('units'),
            'conditions' => array(
                'kra_masters_id' => $kra_masters_id,
                'kra_map_emp_id' => $kra_map_emp_id
            )
        ));
        if (!empty($empinfo))
            return $empinfo['kra_kpi_process']['units'];
        else
            return '';
    }

    public function getKraQuarters($kra_masters_id, $kra_map_emp_id, $quarter = 0) {
        App::import("Model", "KraKpiProcess");
        $model = new KraKpiProcess();
        $empinfo = $model->find('first', array(
            'fields' => array('units'),
            'conditions' => array(
                'kra_masters_id' => $kra_masters_id,
                'kra_map_emp_id' => $kra_map_emp_id,
                'process_quarter' => $quarter
            )
        ));
        if (!empty($empinfo))
            return true;
        else
            return false;
    }

    public function getKraQuarterDetail($kra_masters_id, $kra_map_emp_id, $quarter) {
        App::import("Model", "KraKpiProcess");
        $model = new KraKpiProcess();
        $empinfo = $model->find('first', array(
            'joins' => array(
                array(
                    'table' => 'kra_masters',
                    'alias' => 'KraMaster',
                    'type' => 'INNER',
                    'conditions' => array(
                        'KraMaster.id = kra_kpi_process.kra_masters_id'
                    )
                ),
                array(
                    'table' => 'kra_map_emp',
                    'alias' => 'KraMapEmp',
                    'type' => 'INNER',
                    'conditions' => array(
                        'KraMapEmp.id = kra_kpi_process.kra_map_emp_id'
                    )
                )
            ),
            'conditions' => array(
                'kra_kpi_process.kra_masters_id' => $kra_masters_id,
                'kra_kpi_process.kra_map_emp_id' => $kra_map_emp_id,
                'kra_kpi_process.process_quarter' => $quarter
            ),
            'fields' => array('KraMapEmp.*', 'kra_kpi_process.*', 'KraMaster.*'),
            'order' => 'KraMaster.created_at DESC'
        ));

        if (!empty($empinfo))
            return $empinfo;
        else
            return '';
    }

    public function getKraKpiQuarterDetail($kra_masters_id, $quarter, $weightage) {
        App::import("Model", "KraKpiProcess");
        $model = new KraKpiProcess();
        $empinfo = $model->find('all', array(
            'conditions' => array(
                'user_emp_id' => $_SESSION['Auth']['MyProfile']['emp_code'],
                'kra_masters_id' => $kra_masters_id,
                'process_quarter' => $quarter
            )
        ));
        if (!empty($empinfo)) {
            foreach ($empinfo as $empinfoval) {
                $unitTotal+=$empinfoval['kra_kpi_process']['units'];
            }
        }
        if (!empty($unitTotal))
            return (($unitTotal / 100) * $weightage);
        else
            return 'NA';
    }

    public function getKraQuarterCount($kra_masters_id, $kra_map_emp_id) {
        App::import("Model", "KraKpiProcess");
        $model = new KraKpiProcess();
        $empinfo = $model->find('all', array(
            'fields' => array('units'),
            'conditions' => array(
                'kra_masters_id' => $kra_masters_id,
                'kra_map_emp_id' => $kra_map_emp_id,
            )
        ));
        $tmp = count($empinfo);
        if (!empty($tmp))
            return $tmp;
        else
            return '';
    }

    public function getInvestmentDtl($id) {
        App::import("Model", "OptionAttribute");
        $model1 = new OptionAttribute();
        $sectioname = $model1->find('first', array('fields' => array('OptionAttribute.name'), 'conditions' => array('OptionAttribute.id' => $id, 'OptionAttribute.options_id' => 152)));
        return $sectioname['OptionAttribute']['name'];
    }

    public function getSectionDtl($id) {
        App::import("Model", "OptionAttribute");
        $model1 = new OptionAttribute();
        $sectioname = $model1->find('first', array('fields' => array('OptionAttribute.name'), 'conditions' => array('OptionAttribute.id' => $id, 'OptionAttribute.options_id' => 151)));
        return $sectioname['OptionAttribute']['name'];
    }

    public function getInvestment($id) {
        App::import("Model", "InvestDtl");
        $model1 = new InvestDtl();
        $investMaxLimit = $model1->find('first', array('fields' => array('invest_max_limit'), 'conditions' => array('invest_id' => $id)));
        return $investMaxLimit['InvestDtl']['invest_max_limit'];
    }

    public function getKraQuarterCheck($kra_masters_id, $kra_map_emp_id) {
        App::import("Model", "KraMapEmp");
        $model1 = new KraMapEmp();

        $kraValues = $model1->find('first', array(
            'joins' => array(
                array(
                    'table' => 'kra_masters',
                    'alias' => 'KraMaster',
                    'type' => 'INNER',
                    'conditions' => array(
                        'KraMaster.id = kra_map_emp.kramasters_id'
                    )
                )
            ),
            'conditions' => array(
                'kra_map_emp.myprofile_id' => $_SESSION['Auth']['MyProfile']['emp_code'],
                'kra_map_emp.id' => $kra_map_emp_id
            ),
            'fields' => array('kra_map_emp.*', 'KraMaster.*'),
            'order' => 'KraMaster.created_at DESC'
        ));

        $quarter = $this->__calcAssessmentTab($kraValues['kra_map_emp']['target'], $kraValues['kra_map_emp']['from_date'], $kraValues['kra_map_emp']['to_date']);
        App::import("Model", "KraKpiProcess");
        $model = new KraKpiProcess();
        $empinfo = $model->find('all', array(
            'fields' => array('units'),
            'conditions' => array(
                'kra_masters_id' => $kra_masters_id,
                'kra_map_emp_id' => $kra_map_emp_id
            )
        ));

        if (count($empinfo) == $quarter)
            return false;
        else
            return true;
    }

    /*
     * Get Priority List
     */

    public function getPriorityList() {
        App::import("Model", "KraPriorities");
        $model = new KraPriorities();
        $priority = $model->find("list", array(
            'fields' => array('id', 'name')
        ));
        return $priority;
    }

    /*
     * Get Kra Name
     */

    public function getKraName($id) {
        App::import("Model", "KraMasters");
        $model = new KraMasters();
        $name = $model->find('first', array(
            'fields' => array('kra_name'),
            'conditions' => array(
                'id' => $id
            )
        ));

        if (!empty($name['kra_masters']['kra_name']))
            return $name['kra_masters']['kra_name'];
        else
            return '';
    }

    /*
     * Get Priority Name
     */

    public function getPriorityName($id) {
        App::import("Model", "KraPriorities");
        $model = new KraPriorities();
        $name = $model->find('first', array(
            'fields' => array('name'),
            'conditions' => array(
                'id' => $id
            )
        ));

        if (!empty($name['kra_priorities']['name']))
            return $name['kra_priorities']['name'];
        else
            return 'NA';
    }

    /*
     * Get All Employee List By Department and Organisation
     */

    public function getAllEmployeeListDepartment($departmentId, $organisationId) {
        App::import("Model", "MyProfile");
        $model = new MyProfile();
        $name = $model->find('list', array(
            'fields' => array('emp_code', 'emp_name'),
            'conditions' => array(
                'dept_code' => $departmentId,
                'comp_code' => $organisationId
            )
        ));

        if (!empty($name))
            return $name;
        else
            return 'NA';
    }

    /*
     * Get All Kpi Relate to Kra
     */

    public function getKpiCount($id) {
        App::import("Model", "KpiMasters");
        $model = new KpiMasters();
        $name = $model->find('all', array(
            'fields' => array('id'),
            'conditions' => array(
                'kra_id' => $id
            )
        ));

        if (!empty($name))
            return count($name);
        else
            return '';
    }

    /*
     * Get all Kpi Relate to Kra
     */

    public function getKpiIds($id) {
        App::import("Model", "KpiMasters");
        $model = new KpiMasters();
        $name = $model->find('all', array(
            'fields' => array('id'),
            'conditions' => array(
                'kra_id' => $id
            )
        ));

        if (!empty($name))
            return $name;
        else
            return '';
    }

    /*
     * Get kpi Detail By id
     */

    public function getKpiDetail($id) {
        App::import("Model", "KpiMasters");
        $model = new KpiMasters();
        $name = $model->find('first', array(
            'conditions' => array(
                'id' => $id
            )
        ));

        if (!empty($name))
            return $name;
        else
            return '';
    }

//Check employee check who assgn kra to emplyee (Final Label)
    public function findFinalKraAssignEmployeeCheck($assign_emp_code) {
        App::import("Model", "KraMapEmp");
        $models = new KraMapEmp();
        $list = $models->find('first', array(
            'conditions' => array('myprofile_id' => $assign_emp_code, 'status' => 0),
            'group' => 'myprofile_id'
        ));
        App::import("Model", "MyProfile");
        $model = new MyProfile();
        $desglists = $model->find('first', array('fields' => array(
                'emp_code'), 'conditions' => array('emp_code' => $list['kra_map_emp']['kra_user_emp_code'])));
        if (!empty($desglists)) {
            $desglist = $desglists['MyProfile']['emp_code'];
        } else {
            $desglist = '';
        }
        return $desglist;
    }

    //Gets employee list for Forward if applicable
    public function findPreviousLevel($assign_emp_code, $last = NULL) {

        $lastStage = 'Final';
        $comp_code = $_SESSION['Auth']['MyProfile']['comp_code'];
        $emp_dept_id = $_SESSION['Auth']['MyProfile']['dept_code'];
        $emp_desg_id = $_SESSION['Auth']['MyProfile']['desg_code'];
        $emp_code = $_SESSION['Auth']['MyProfile']['emp_code'];
        App::import("Model", "MyProfile");
        $model = new MyProfile();
        $query = $model->find('first', array('fields' => array(
                'manager_code', 'dept_code', 'desg_code'), 'conditions' => array('emp_code' => $emp_code, 'comp_code' => $comp_code)));

        if ($lastStage == $last) {
            App::import("Model", "KraMapEmp");
            $models = new KraMapEmp();
            $list = $models->find('first', array(
                'conditions' => array('myprofile_id' => $assign_emp_code, 'status' => 0),
                'group' => 'myprofile_id'
            ));
            $desglist = $model->find('list', array('fields' => array(
                    'emp_code', 'emp_firstname'), 'conditions' => array('emp_code' => $list['kra_map_emp']['kra_user_emp_code'])));
            //$desglist = $this->listdesgbyemp('PAR0000044', $query['HcmDesgPrf']['dept_id']);
        } else if (!empty($query['MyProfile']['manager_code'])) {
            $desglist = $model->find('list', array('fields' => array(
                    'emp_code', 'emp_firstname'), 'conditions' => array('emp_code' => $query['MyProfile']['manager_code'])));
        } else {
            $desglist = array();
        }

        return $desglist;
    }

    /*
     * Get Employee Document
     */

    function getApprovedDocuments() {
        App::import("Model", "EmpDocuments");
        $model = new EmpDocuments();
        $documents = $model->find('all', array(
            'conditions' => array(
                'emp_code' => $_SESSION['Auth']['MyProfile']['emp_code'],
                'approve' => 1
            ),
            'fields' => array('*'),
            'order' => 'id DESC'
        ));
        if (!empty($documents))
            return $documents;
        else
            return '';
    }

    function getNonApprovedDocuments() {
        App::import("Model", "EmpDocuments");
        $model = new EmpDocuments();
        $documents = $model->find('all', array(
            'conditions' => array(
                'emp_code' => $_SESSION['Auth']['MyProfile']['emp_code'],
                'approve' => 0
            ),
            'fields' => array('*'),
            'order' => 'id DESC'
        ));
        if (!empty($documents))
            return $documents;
        else
            return '';
    }

    /*
     *  Find All Calculation Regarding Average
     */

    public function calculateAverageByEmployee($emp_code, $date) {
        App::import("Model", "KpiMapEmps");
        $model = new KpiMapEmps();
        $kralist = $model->find('all', array(
            'conditions' => array(
                'myprofile_id' => $emp_code,
                'from_date' => $date
            ),
            'fields' => array('*'),
            'order' => 'id DESC'
        ));
        $kraEmpAvgWtg = $model->find('all', array(
            'joins' => array(
                array(
                    'table' => 'kra_kpi_process',
                    'alias' => 'KraKpiProcess',
                    'type' => 'INNER',
                    'conditions' => array(
                        'KraKpiProcess.kra_masters_id = kpi_map_emps.kra_masters_id',
                        'KraKpiProcess.kpi_masters_id = kpi_map_emps.kpi_masters_id',
                        'KraKpiProcess.kpi_map_emps_id = kpi_map_emps.id'
                    )
                )
            ),
            'conditions' => array(
                'KraKpiProcess.kra_kpi_assign_user' => $emp_code,
                'kpi_map_emps.from_date' => $date
            ),
            'fields' => array('KraKpiProcess.myprofile_id'),
            'order' => 'KraKpiProcess.id ASC',
            'group' => 'KraKpiProcess.myprofile_id ASC'
        ));
        $k = 0;
        foreach ($kraEmpAvgWtg as $kraEmpAvgWtgVal) {
            $kralistEmployee = $model->find('all', array(
                'joins' => array(
                    array(
                        'table' => 'kra_kpi_process',
                        'alias' => 'KraKpiProcess',
                        'type' => 'INNER',
                        'conditions' => array(
                            'KraKpiProcess.kra_masters_id = kpi_map_emps.kra_masters_id',
                            'KraKpiProcess.kpi_masters_id = kpi_map_emps.kpi_masters_id',
                            'KraKpiProcess.kpi_map_emps_id = kpi_map_emps.id'
                        )
                    )
                ),
                'conditions' => array(
                    'KraKpiProcess.kra_kpi_assign_user' => $emp_code,
                    'KraKpiProcess.myprofile_id' => $kraEmpAvgWtgVal['KraKpiProcess']['myprofile_id'],
                    'kpi_map_emps.from_date' => $date
                ),
                'fields' => array('KraKpiProcess.id', 'KraKpiProcess.myprofile_id', 'KraKpiProcess.units'),
                'order' => 'KraKpiProcess.id ASC'
            ));

            foreach ($kralistEmployee as $kralistEmployeeVal) {
                $empSum+=$kralistEmployeeVal['KraKpiProcess']['units'];
            }
            $emp[$k] = $empSum;
            unset($empSum);
            $k++;
        }
        foreach ($emp as $ke => $vl) {
            $temp[$ke] = $vl / count($kralist);
        }
        foreach ($temp as $tval) {
            $tsemp+=$tval;
        }
        $orervallAvg = $tsemp / count($temp);
        return number_format($orervallAvg, 2, '.', '');
    }

    /*
     * Get All Employees Units Detail By on Each Kra
     */

    function getEmployeesUnitsByKra($kra_masters_id, $kpi_masters_id, $kra_kpi_assign_user, $kpi_map_emps_id) {
        App::import("Model", "KraKpiProcess");
        $model = new KraKpiProcess();
        $values = $model->find('all', array(
            'conditions' => array(
                'kra_kpi_assign_user' => $kra_kpi_assign_user,
                'kra_masters_id' => $kra_masters_id,
                'kpi_masters_id' => $kpi_masters_id,
                'kpi_map_emps_id' => $kpi_map_emps_id
            ),
            'fields' => array('units'),
            'order' => 'id DESC'
        ));
        if (!empty($values))
            return $values;
        else
            return '';
    }

    /*
     * Find Department Name
     */

    public function findDepartmentName($dept_code, $org_id) {
        App::import("Model", "Departments");
        $model = new Departments();
        $query = $model->find('first', array(
            'fields' => array('Departments.dept_name'),
            'conditions' => array(
                'Departments.dept_code' => $dept_code,
                'Departments.comp_code' => $org_id,
            )
        ));
        if (!empty($query['Departments']['dept_name'])) {
            return $query['Departments']['dept_name'];
        } else {
            return '';
        }
    }

    public function bloodGroup($id) {
        App::import("Model", "Options");
        $model = new Options();
        $query = $model->find('first', array(
            'fields' => array('Options.name'),
            'conditions' => array(
                'Options.id' => $id,
            )
        ));
        if (!empty($query['Options']['name'])) {
            return $query['Options']['name'];
        } else {
            return '';
        }
    }

    /*
     * Find Designation Name
     */

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

    public function findLoc($id) {
        App::import("Model", "OptionAttribute");
        $model = new OptionAttribute();
        $query = $model->find('first', array(
            'fields' => array('OptionAttribute.name'),
            'conditions' => array(
                'OptionAttribute.id' => $id,
                'OptionAttribute.org_id' => $org_id,
                'OptionAttribute.options_id' => 3
            )
        ));
        if (!empty($query['OptionAttribute']['name'])) {
            return $query['OptionAttribute']['name'];
        } else {
            return '';
        }
    }

    /*
     * Get Kra Kpi Slab Position
     */

    public function empKraKpiSlab($param) {
        App::import("Model", "KraKpiSlab");
        $model = new KraKpiSlab();
        $result = $model->query("SELECT name FROM `kra_kpi_slab` WHERE $param >= `min_val` and $param <= `max_val`");
        if (!empty($result))
            return $result[0]['kra_kpi_slab']['name'];
        else
            return '';
    }

    /*
     * Get Kra Kpi Slab Increment Amount
     */

    public function empKraKpiIncAmt($param) {
        App::import("Model", "KraKpiSlab");
        $model = new KraKpiSlab();
        $result = $model->query("SELECT amt FROM `kra_kpi_slab` WHERE $param >= `min_val` and $param <= `max_val`");
        if (!empty($result))
            return $result[0]['kra_kpi_slab']['amt'];
        else
            return '';
    }

    protected function __dateDifference($date_1, $date_2, $differenceFormat = '%a') {
        $datetime1 = date_create($date_1);
        $datetime2 = date_create($date_2);
        $interval = date_diff($datetime1, $datetime2);
        return $interval->format($differenceFormat);
    }

    protected function __diff_in_weeks_and_days($from, $to) {
        $day = 24 * 3600;
        $from = strtotime($from);
        $to = strtotime($to) + $day;
        $diff = abs($to - $from);
        $weeks = floor($diff / $day / 7);
        $days = $diff / $day - $weeks * 7;
        $out = array();
        if ($weeks)
            $out[] = "$weeks" . ($weeks > 1 ? '' : '');
        if ($days)
            $out[] = "$days" . ($days > 1 ? '' : '');

        return $out[0];
    }

    protected function __diff_in_month($from, $to) {
        $d1 = strtotime("$from");
        $d2 = strtotime("$to");
        $min_date = min($d1, $d2);
        $max_date = max($d1, $d2);
        $i = 0;
        while (($min_date = strtotime("+1 MONTH", $min_date)) <= $max_date) {
            $i++;
        }
        return $i;
    }

    protected function __calcAssessmentTab($target, $from, $to) {
        $value = '';
        if ($target == 1) {
            $weak = $this->__diff_in_weeks_and_days($to, $from);
            $value = $weak;
        } elseif ($target == 2) {
            $month = $this->__diff_in_month($from, $to);
            $value = $month;
            if ($month < 3) {
                $value = $month;
            } else {
                $value = $month / 3;
            }
        } elseif ($target == 3) {
            $month = $this->__diff_in_month($from, $to);
            $value = $month;
            if ($month < 6) {
                $value = $month;
            } else {
                $value = $month / 6;
            }
        } elseif ($target == 4) {
            $year = $this->__dateDifference($to, $from);
            $value = $year;
        }
        return $value;
    }

    public function getleveltraining($from, $to) {
        App::import("Model", "MyProfile");
        $model = new MyProfile();
        while ($to) {
            $count = 1;
            $manager_code = $model->find('first', array('fields' => array('manager_code'), 'conditions' => array('emp_code' => $from)));
            $nxtcode = $manager_code['MyProfile']['manager_code'];
            $to = $this->findManagerCode($nxtcode);
            $count = $count + 1;
        }
    }

    public function findManagerCode($manager_code) {
        App::import("Model", "MyProfile");
        $model = new MyProfile();
        $manager_code = $model->find('first', array('fields' => array('manager_code'), 'conditions' => array('emp_code' => $manager_code)));
        return $manager_code['MyProfile']['manager_code'];
    }

    //Kra Function Ends

    public function get_admin_option($name) {
        App::import("Model", "AdminOption");
        $model = new AdminOption();
        $admin_option = $model->find('first', array('fields' => array('id'), 'conditions' => array('name' => $name)));
        App::import("Model", "AdminOptionOrg");
        $model_new = new AdminOptionOrg();
        $admin_option_org = $model_new->find('first', array('fields' => array('status'), 'conditions' => array('admin_options_id' => $admin_option['AdminOption']['id'],'org_id'=>$_SESSION['Auth']['MyProfile']['comp_code'])));
       
        if (!empty($admin_option_org))
            return $admin_option_org['AdminOptionOrg']['status'];
        else
            return false;
    }

    public function sectionname($section_id) {
        App::import("Model", "OptionAttribute");
        $option_name = new OptionAttribute();
        $section_name = $option_name->find('first', array(
            'fileds' => array('OptionAttribute.name'),
            'conditions' => array('OptionAttribute.id' => $section_id)
        ));
        return $section_name;
    }

    public function findInvestName($id) {
        App::import("Model", "OptionAttribute");
        $option_name = new OptionAttribute();
        $invest_name = $option_name->find('first', array(
            'fileds' => array('OptionAttribute.name'),
            'conditions' => array('OptionAttribute.id' => $id)
        ));
        return $invest_name;
    }

    public function findsection($section_id, $fy_id) {

        App::import("Model", "OptionAttribute");
        App::import("Model", "InvestDtl");
        $invest_dtl = new InvestDtl();
        $option_name = new OptionAttribute();
        $section_dtl = $invest_dtl->find('all', array(
            'fields' => array('InvestDtl.invest_id', 'op1.name', 'InvestDtl.invest_max_limit', 'InvestDtl.hover_description'),
            'joins' => array(
                array(
                    'table' => 'option_attribute',
                    'alias' => 'op1',
                    'type' => 'inner',
                    'foreignKey' => false,
                    'conditions' => array('op1.id = InvestDtl.sect_id  ')
                ),
            ),
            'conditions' => array('InvestDtl.sect_id' => $section_id, 'fy_id' => $fy_id)
        ));

        return $section_dtl;
    }

    public function findChapterName($sect_id) {

        App::import("Model", "SectDtl");
        $sect_dtl = new SectDtl();
        App::import("Model", "OptionAttribute");
        $option_name = new OptionAttribute();
        $chapter = $sect_dtl->find('first', array('fields' => array('cptr_id'), 'conditions' => array('sect_id' => $sect_id)));
        $opt_name = $option_name->find('first', array('fields' => array('name'), 'conditions' => array('OptionAttribute.id' => $chapter['SectDtl']['cptr_id'])));
        return $opt_name['OptionAttribute']['name'];
    }

    public function findHover($invest_id) {
        App::import("Model", "InvestDtl");
        $invest_dtl = new InvestDtl();
        $hover_desc = $invest_dtl->find('first', array('fields' => array('hover_description', 'invest_max_limit'), 'conditions' => array('invest_id' => $invest_id)));
        return $hover_desc;
    }

    public function getIncomeTaxDec() {
        App::import("Model", "EmpInvest");
        $emp_invest = new EmpInvest();
        $emp_code = $_SESSION['Auth']['MyProfile']['emp_code'];
        $currentdate = date('Y-m-d');
        $q = "SELECT `FinancialYear`.`id` FROM financial_year AS `FinancialYear` WHERE '$currentdate' BETWEEN hcm_fy_start and hcm_fy_end";
        $db = ConnectionManager::getDataSource('default');
        $myData = $db->query($q);
        $fy_id = $myData[0]['FinancialYear']['id'];

        $dec = $emp_invest->find('first', array('fields' => array('*'), 'conditions' => array('emp_code' => $emp_code, 'Fy_id' => $fy_id)));

        if ($dec) {
            return 1;
        } else {
            return 0;
        }
    }

    public function getInvestAmt($emp_invest_id, $invest_id) {

        App::import("Model", "EmpInvestDtl");
        $emp_invest = new EmpInvestDtl();
        $query = $emp_invest->find('first', array('fields' => array('invest_amt', 'actual_amt', 'id'), 'conditions' => array('emp_invest_id' => $emp_invest_id, 'invest_id' => $invest_id)));
        if ($query) {
            return $query;
        } else {
            return 0;
        }
    }

    function getReason($reason_id) {

        App::import("Model", "Resignation");
        $reason = new Resignation();
        $query = $reason->find('first', array('fields' => array('reason'), 'conditions' => array('id' => $reason_id)));
        return $query['Resignation']['reason'];
    }

    function bank_name($id) {
        $portal_app_eo = new Model(array('table' => 'oracle_app_eo', 'ds' => 'default', 'name' => 'OracleAppEo'));
        $bank_name = $portal_app_eo->find('first', array('fields' => array('eo_nm'), 'conditions' => array('eo_id' => $id)));
        return $bank_name['OracleAppEo']['eo_nm'];
    }

    function findfyDesc($fy) {
        App::import("Model", "FinancialYear");
        $fy_model = new FinancialYear();
        $data = $fy_model->find('first', array('fields' => array('*'), 'conditions' => array('id' => $fy)));
        return $data['FinancialYear']['fy_desc'];
    }

    function findAllTempComponent() {
        App::import("Model", "OracleOrgHcmSalary");
        App::import("Model", "EmployeeSalMon");
        App::import("Model", "DtEmployeeSalMon");

        $orgHcm = new OracleOrgHcmSalary();
        $empSalMon = new EmployeeSalMon();

        $emp_code = $_SESSION['Auth']['MyProfile']['emp_code'];
        $month = date('m');

        $temp_comp_month = $empSalMon->find('all', array(
            'fields' => array('Dt.sal_id'),
            'joins' => array(
                array(
                    'table' => 'dt_employee_sal_mon',
                    'alias' => 'Dt',
                    'type' => 'inner',
                    'foreignKey' => false,
                    'conditions' => array('Dt.employee_sal_mon_id = EmployeeSalMon.id'
                    ))
            ),
            'conditions' => array('month(claim_date)' => $month, 'Dt.emp_code' => $emp_code)
        ));

        $temp_comp = $orgHcm->find('list', array(
            'fields' => array('OracleOrgHcmSalary.sal_id', 'OA.name'),
            'joins' => array(
                array(
                    'table' => 'option_attribute',
                    'alias' => 'OA',
                    'type' => 'inner',
                    'foreignKey' => false,
                    'conditions' => array('OA.id = OracleOrgHcmSalary.sal_id'
                    ))
            ),
            'conditions' => array('OracleOrgHcmSalary.sal_type' => 'T', 'OracleOrgHcmSalary.sal_behav' => array(12, 13))
        ));

        foreach ($temp_comp_month as $temp) {
            $temp_id = $temp['Dt']['sal_id'];
            unset($temp_comp[$temp_id]);
        }

        return $temp_comp;
    }

    function emp_option() {
        $emp_code = $_SESSION['Auth']['MyProfile']['emp_code'];
        App::import("Model", "MyProfile");
        $profile = new MyProfile();
        $data = $profile->find('first', array('fields' => array('config'), 'conditions' => array('emp_code' => $emp_code)));
        if ($data['MyProfile']['config'] == 1) {
            return 1;
        } else {
            return 0;
        }
    }
    
    function findTaskName($taskID) {
        
        App::import("Model", "TaskAssing");
        $model = new TaskAssing();        
        $result = $model->find('first', array('fields' => array('tname'), 'conditions' => array('id' => $taskID)));       
        
        return $result['TaskAssign']['tname'];
    }
    
    function findTaskList() {
        App::import("Model", "TaskAssing");
        $model = new TaskAssing();
        $result = $model->find('list', array('fields' => array('tname'), 'order' => array('tname ASC')));
        return $result;
    }
    function findParameterName(){
     App::import("Model", "AttributeType");
     $model = new AttributeType();
     $result = $model->find('list', array('fields' => array('name'), 'order' => array('name ASC')));
     
     return $result;   
    }
    public function findLocationName() {
        //function to find all company name
        App::import("Model", "OptionAttribute");
        $model = new OptionAttribute();
        $query = $model->find('list',array('fields'=>array('id','name'),'conditions'=>array('options_id'=>3)));
        if (empty($query)) {
            return 0;
        } else {
            return $query;
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
            return $query[0]['MyProfile']['desg_code'];		
        }		
    }		
    		
    public function getAllDesignationByDept($deptCode) {		
        //echo $desg_code;		
        //function to find all company name		
        App::import("Model", "MyProfile");		
        $model = new MyProfile();		
        $query = $model->find('list', array('fields' => array('desg_code','desg_code'), 'conditions' => array('MyProfile.dept_code' => "$deptCode"),'group' => 'MyProfile.desg_code'));		
        if (empty($query)) {		
            return 0;		
        } else {		
            return $query;		
        }		
    }		
    		
    public function findEmpListByDesgCode($desgCode,$deptCode) {		
        //echo $desg_code;		
        //function to find all company name		
        		
        App::import("Model", "MyProfile");		
        $model = new MyProfile();		
        $query = $model->find('list', array('fields' => array('emp_code','emp_full_name'), 'conditions' => array('MyProfile.desg_code' => $desgCode, 'MyProfile.dept_code' => $deptCode),'order' => 'MyProfile.emp_full_name ASC'));		
        if (empty($query)) {		
            return 0;		
        } else {		
            return $query;		
        }		
    }
    
     public function getAllEmployeeListByDepartment($departmentId, $organisationId) {		
        App::import("Model", "MyProfile");		
        $model = new MyProfile();		
        $name = $model->find('all', array(		
            'fields' => array('emp_code', 'emp_name','desg_code'),		
            'conditions' => array(		
                'dept_code' => $departmentId,		
                'comp_code' => $organisationId		
            )		
        ));		
        if (!empty($name))		
            return $name;		
        else		
            return 'NA';		
    }	
    
    public function findDepartmentNameByCode($dept_code) {		
        App::import("Model", "Departments");		
        $model = new Departments();		
        $query = $model->find('first', array(		
            'fields' => array('Departments.dept_name'),		
            'conditions' => array(		
                'Departments.dept_code' => $dept_code		
            )		
        ));		
        if (!empty($query['Departments']['dept_name'])) {		
            return $query['Departments']['dept_name'];		
        } else {		
            return '';		
        }		
    }		
    
    function findGroupMasterList($hoOrgId,$orgId){		
        App::import("Model", "HcmGroupMaster");		
        $model = new HcmGroupMaster();		
        $result = $model->find('list', array(
            'fields' => array('id','group_name'), 'order' => array('group_name ASC'),
            'conditions' => array('status' => "1",'ho_org_id' => $hoOrgId,'org_id' => $orgId)));		
        return $result;		
    }		
    		
    function findGroupMasterName($groupId) {		
        App::import("Model", "HcmGroupMaster");		
        $model = new HcmGroupMaster();		
        $result = $model->find('all', array(
            'fields' => array('group_name'), 
            'order' => array('group_name ASC'),
            'conditions' => array('id' => $groupId)));        		
        return $result[0]['HcmGroupMaster']['group_name'];		
    }		
    		
    function findCompetencyList() {		
        App::import("Model", "Competency");		
        $model = new Competency();		
        $result = $model->find('list', array('fields' => array('id','competency_name'), 'order' => array('competency_name ASC'),'conditions' => array('status' => "1")));		
        return $result;		
    }		
    		
    function findCompetencyName($competencyId) {		
        App::import("Model", "Competency");		
        $model = new Competency();		
        $result = $model->find('all', array('fields' => array('competency_name'), 'order' => array('competency_name ASC'),'conditions' => array('id' => $competencyId)));        		
        		
        return $result[0]['Competency']['competency_name'];		
    }		
    		
    function findCompetencyListByGroupId($groupId) {		
        App::import("Model", "GroupCompetency");		
        $model = new GroupCompetency();		
        $result = $model->find('list', array('fields' => array('id','competency_id'), 'order' => array('competency_id ASC'),'conditions' => array('group_id' => $groupId)));		
        return $result;		
    }		
    	
 	public function findDynamicLevel($id=NULL, $type='Forward') {		  		
       // print_r($id);die;		  
		$comp_code = $_SESSION['Auth']['MyProfile']['comp_code'];		
		$emp_dept_id = $_SESSION['Auth']['MyProfile']['dept_code'];		
		$emp_desg_id = $_SESSION['Auth']['MyProfile']['desg_code'];		
		App::import("Model", "DtAppMapLvl");		
		$model = new DtAppMapLvl();		
		$query = $model->find('all', array(		
			     'joins' => array(		
				  array(		
				           'table' => 'wf_mst_app_map_lvl',		
				           'alias' => 'WfMstAppMapLvl',		
				           'type' => 'inner',		
				           'foreignKey' => false,		
				           'conditions' => array('DtAppMapLvl.wf_app_map_lvl_id = WfMstAppMapLvl.wf_id')		
				       )		
				   ),		
			    'conditions' => array('DtAppMapLvl.wf_app_map_lvl_id'=>$id,'DtAppMapLvl.wf_desg_id'=>$emp_desg_id, 'DtAppMapLvl.wf_dept_id'=>$emp_dept_id )		
		));		
              		
		if (count($query)>0 ){		
			$getlvl = $query[0]['DtAppMapLvl']['wf_lvl'];		
		 	$lvl = explode('Level',$getlvl);		
		  	$maxlvl=$lvl[1]+1;		
		 	$level='Level'.$maxlvl;		
		} else {		
		    	$level='Level1';		
		}		
               		
		//Finds level details for next level of approval		
		$query1 = $model->find('first', array(		
		    		'conditions' => array('DtAppMapLvl.wf_app_map_lvl_id'=>$id, 'DtAppMapLvl.wf_lvl'=>$level)		
			));		
                        //print_r($id);die;      		
		//Checks whether current level employee has approval right for lower level employees		
	      if(!empty($query1['DtAppMapLvl']['wf_desg_id']) && $type=='Apply'){		
			$desglist = $this->listdesgbyemp($query1['DtAppMapLvl']['wf_desg_id'],$query1['DtAppMapLvl']['wf_dept_id']);		
	      } else if(!empty($query1['DtAppMapLvl']['wf_desg_id']) && $type=='Forward' &&  @$query[0]['DtAppMapLvl']['skip_status']!=1 ){		
			$desglist = $this->listdesgbyemp($query1['DtAppMapLvl']['wf_desg_id'],$query1['DtAppMapLvl']['wf_dept_id']);		
		} else {		
		  	$desglist = array();		
		}		
		return $desglist;		
	}		
    				
 public function findcheckLevel($id=NULL) {		
             		
		$comp_code = $_SESSION['Auth']['MyProfile']['comp_code'];		
		$emp_dept_id = $_SESSION['Auth']['MyProfile']['dept_code'];		
		App::import("Model", "WfMstAppMapLvl");		
		$model = new WfMstAppMapLvl();		
		$query = $model->find('first', array(		
		    'fields'=>array('WfMstAppMapLvl.wf_id','WfMstAppMapLvl.manager_approval'),		
		    'joins' => array(		
			  array(		
				   'table' => 'wf_dt_app_map_lvl',		
				   'alias' => 'DtAppMapLvl',		
				   'type'  => 'inner',		
				   'foreignKey' => false,		
				   'conditions' => array('DtAppMapLvl.wf_app_map_lvl_id = WfMstAppMapLvl.wf_id')		
			       )		
			   ),		
		    'conditions' => array(		
			'WfMstAppMapLvl.comp_code' => $comp_code,		
			'WfMstAppMapLvl.wf_dept_id' => $emp_dept_id,		
			'WfMstAppMapLvl.wf_app_id'=>  $id )		
		));		
               		
		if(!empty($query['WfMstAppMapLvl']['wf_id'])){		
			return $query;		
		}else{		
			return 0;		
		}		
	}		
        		
    public function findCaseType($CTid) {		
    //function to find CaseType name		
    App::import("Model", "CaseType");		
    $model = new CaseType();		
    $CaseType = $model->find('first',array('fields'=>array('casetype'),'conditions'=>array('id'=>$CTid,'status'=>'0')));		
    return $CaseType['CaseType']['casetype'];		
   }		
   		
   public function findCourtType($CTid) {		
        //function to find CourtType name		
        App::import("Model", "CourtType");		
        $model = new CourtType();		
        $CourtType = $model->find('first',array('fields'=>array('courttype'),'conditions'=>array('id'=>$CTid,'status'=>'0')));		
        return $CourtType['CourtType']['courttype'];		
        		
    }		
    		
    public function CaseCourtLocation($CTid) {		
        //function to find CourtType name		
        App::import("Model", "CaseCourtLocation");		
        $model = new CaseCourtLocation();		
        $CaseCourtLocation = $model->find('first',array('fields'=>array('court_location'),'conditions'=>array('id'=>$CTid,'status'=>'0')));		
        return $CaseCourtLocation['CaseCourtLocation']['court_location'];		
        		
    }		
    		
    public function findCaseStatus($CTid) {		
        //function to find CourtType name		
        App::import("Model", "CaseStatus");		
        $model = new CaseStatus();		
        $CaseStatus = $model->find('first',array('fields'=>array('case_status'),'conditions'=>array('id'=>$CTid,'status'=>'0')));		
        return $CaseStatus['CaseStatus']['case_status'];		
        		
    }		
    		
    public function findCaseOutcome($CTid) {		
        //function to find CourtType name		
        App::import("Model", "CaseOutcome");		
        $model = new CaseOutcome();		
        $CaseOutcome = $model->find('first',array('fields'=>array('case_outcome'),'conditions'=>array('id'=>$CTid,'status'=>'0')));		
        return $CaseOutcome['CaseOutcome']['case_outcome'];		
        		
    }		
      		
    public function findRequestType($RTid) {		
        //function to find CourtType name		
        App::import("Model", "MstRequest");		
        $model = new MstRequest();		
        $RequestType = $model->find('first',array('fields'=>array('req_type_name'),'conditions'=>array('id'=>$RTid,'status'=>'1')));		
        return $RequestType['MstRequest']['req_type_name'];		
        		
    }		
    		
    public function getKraTargetByEmpCode($empCode) {        		
        App::import("Model", "KraTarget");		
        $model = new KraTarget();		
        		
        $desglist = $model->find('all', array(		
            'fields' => array('KraTarget.id'),		
            'conditions' => array("emp_code = '$empCode'","appraiser_status = '5'")		
        ));		
        return count($desglist);		
    }		
    		
    public function getTotalKraTarge($empCode){        		
        App::import("Model", "KraTarget");		
        $model = new KraTarget();		
        $currentYear = date("Y");		
        $desglist = $model->find('all', array(		
            'fields' => array('KraTarget.id'),		
            'conditions' => array('emp_code' => "$empCode",'YEAR(KraTarget.created_date)' => "$currentYear")		
        ));		
        return count($desglist);		
    }		
    		
    public function getKraTargetByEmpCodeForReviewer($empCode) {        		
        App::import("Model", "KraTarget");		
        $model = new KraTarget();		
        		
        $desglist = $model->find('all', array(		
            'fields' => array('KraTarget.id'),		
            'conditions' => array("emp_code = '$empCode'","reviewer_status = '5'",'appraiser_status' => '5')		
        ));		
        return count($desglist);		
    }		
    		
    public function getKraTargetEmpSelfScore($empCode) {        		
        App::import("Model", "KraTarget");		
        $model = new KraTarget();		
        		
        $selfScore = $model->find('all', array(		
            'fields' => array('KraTarget.id'),		
            'conditions' => array("emp_code = '$empCode'",		
                "appraiser_status" => '5',		
                'self_score_actual != ' => '',		
                'self_score_achiev != ' => '')		
        ));		
        return count($selfScore);		
    }		
    		
    public function getKraTargetAppraiserScore($empCode){        		
        App::import("Model", "KraTarget");		
        $reviewerCode = $_SESSION['Auth']['MyProfile']['emp_code'];		
        $model = new KraTarget();		
        		
        $selfScore = $model->find('all', array(		
            'fields' => array('KraTarget.id'),		
            'conditions' => array("emp_code = '$empCode'",		
                "appraiser_status = '5'",		
                "reviewer_id = $reviewerCode",		
                'self_score_actual != ' => '',		
                'self_score_achiev != ' => '',		
                'appraiser_score_achiev != ' => '')		
        ));		
        return count($selfScore);		
    }		
    		
    public function getKraTargetAllApprovedScore($empCode){      		
        App::import("Model", "KraTarget");		
        echo "<pre>";		
        print_r($_SESSION);		
        die;		
        $reviewerCode = $_SESSION['Auth']['MyProfile']['emp_code'];		
        $model = new KraTarget();		
        		
        $allScores = $model->find('all', array(		
            'fields' => array('KraTarget.id'),		
            'conditions' => array("emp_code = '$empCode'",		
                "appraiser_status = '5'",		
                "reviewer_status = '5'",		
                "reviewer_id = $reviewerCode",		
                'self_score_actual != ' => '',		
                'self_score_achiev != ' => '',		
                'appraiser_score_achiev != ' => '')		
        ));		
        echo  count($allScores);		
    }

	public function findDepNamebycode($dept_code){
            App::import("Model", "Departments");
        $model = new Departments();
        $query = $model->find('first', array(
            'fields' => array('Departments.dept_name'),
            'conditions' => array(
                'Departments.dept_code' => $dept_code,
            )
        ));
        if (!empty($query['Departments']['dept_name'])) {
            return $query['Departments']['dept_name'];
        } else {
            return '';
        }
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

    public function getEmpDetails($empCode) {        
        App::import("Model", "MyProfile");
        $model = new MyProfile();
        
        $desglist = $model->find('first', array(
            'fields' => array('MyProfile.emp_code','MyProfile.manager_code','MyProfile.emp_full_name','MyProfile.join_date','MyProfile.dept_code','MyProfile.desg_code','MyProfile.comp_code'),
            'conditions' => array("emp_code = '$empCode'")
        ));
        return $desglist;
    }

    public function getKraTargetAllApprovedScoreForAppraiser($empCode){      
        App::import("Model", "KraTarget");
        
        $reviewerCode = $_SESSION['Auth']['User']['emp_code'];
        $model = new KraTarget();
        $currentYear = date("Y");
        
        $allScores = $model->find('all', array(
            'fields' => array('KraTarget.id','KraTarget.self_score_achiev','KraTarget.appraiser_score_achiev'),
            'conditions' => array("emp_code = '$empCode'",
                "appraiser_status = '5'",
                "reviewer_status = '5'",
                "appraiser_id = $reviewerCode",
                'self_score_actual != ' => '',
                'self_score_achiev != ' => '','reviewer_score_achiev != ' => '','YEAR(KraTarget.created_date)' => $currentYear,
                'appraiser_score_achiev != ' => '')
        ));
        return $allScores;
    }
    
    public function getKraTargetAllApprovedScoreForReviewer($empCode){      
        App::import("Model", "KraTarget");
        
        $reviewerCode = $_SESSION['Auth']['User']['emp_code'];
        $model = new KraTarget();
        $currentYear = date("Y");
        
        $allScores = $model->find('all', array(
            'fields' => array('KraTarget.id','KraTarget.self_score_achiev','KraTarget.appraiser_score_achiev','KraTarget.reviewer_score_achiev'),
            'conditions' => array("emp_code = '$empCode'",
                "appraiser_status = '5'",
                "reviewer_status = '5'",
                "reviewer_id = $reviewerCode",
                'self_score_actual != ' => '',
                'self_score_achiev != ' => '','reviewer_score_achiev != ' => '','YEAR(KraTarget.created_date)' => $currentYear,
                'appraiser_score_achiev != ' => '')
        ));
        return $allScores;
    }
    
    public function getKraTargetAllApprovedScoreForEmp(){      
        App::import("Model", "KraTarget");
        
        $empCode = $_SESSION['Auth']['User']['emp_code'];
        $model = new KraTarget();
        $currentYear = date("Y");
        
        $allScores = $model->find('all', array(
            'fields' => array('KraTarget.id','KraTarget.self_score_achiev'),
            'conditions' => array("emp_code = '$empCode'",
                "appraiser_status = '5'",
                "reviewer_status = '5'",                
                'self_score_actual != ' => '',
                'self_score_achiev != ' => '','reviewer_score_achiev != ' => '','YEAR(KraTarget.created_date)' => $currentYear,
                'appraiser_score_achiev != ' => '')
        ));
        return $allScores;
    }
    
    public function getKraTargetOpenStatus($empCode){        
        App::import("Model", "KraTarget");
        $appraiserId = $_SESSION['Auth']['User']['emp_code'];
        $model = new KraTarget();
        $currentYear = date("Y");
        $statusList = $model->find('all', array(
            'fields' => array('KraTarget.id'),
            'conditions' => array('emp_code' => "$empCode",'appraiser_id' =>"$appraiserId", "appraiser_status = '1'", "emp_status = '2'",
                'YEAR(KraTarget.created_date)' => "$currentYear")
        ));
        return $statusList;
    }
    
    public function getKraTargetRevertStatus($empCode){
        $appraiserId = $_SESSION['Auth']['User']['emp_code'];
        App::import("Model", "KraTarget");
        $model = new KraTarget();
        $currentYear = date("Y");
        $statusList = $model->find('all', array(
            'fields' => array('KraTarget.id'),
            'conditions' => array('emp_code' => "$empCode",'appraiser_id' =>"$appraiserId", "appraiser_status = '3'","emp_status = '2'",
                'YEAR(KraTarget.created_date)' => "$currentYear")
        ));
        return $statusList;
    }
    
    public function getKraTargetApprovedStatus($empCode){    
        $appraiserId = $_SESSION['Auth']['User']['emp_code'];
        App::import("Model", "KraTarget");
        $model = new KraTarget();
        $currentYear = date("Y");
        $statusList = $model->find('all', array(
            'fields' => array('KraTarget.id'),
            'conditions' => array('emp_code' => "$empCode",'appraiser_id' =>"$appraiserId",
                "appraiser_status = '5'","emp_status = '2'",
                'YEAR(KraTarget.created_date)' => "$currentYear")
        ));
        return $statusList;
    }
    
    public function getKraTargetOpenStatusForReviewer($empCode){        
        App::import("Model", "KraTarget");
        $reviewerCode = $_SESSION['Auth']['User']['emp_code'];
        $model = new KraTarget();
        $currentYear = date("Y");
        $statusList = $model->find('all', array(
            'fields' => array('KraTarget.id'),
            'conditions' => array('emp_code' => "$empCode","reviewer_id" => "$reviewerCode",                
                "appraiser_status = '5'","emp_status = '2'","reviewer_status" => '1',                
                'YEAR(KraTarget.created_date)' => "$currentYear")
        ));
        return $statusList;
    }
    
    public function getKraTargetRevertStatusForReviewer($empCode){        
        App::import("Model", "KraTarget");
        $reviewerCode = $_SESSION['Auth']['User']['emp_code'];
        $model = new KraTarget();
        $currentYear = date("Y");
        $statusList = $model->find('all', array(
            'fields' => array('KraTarget.id'),
            'conditions' => array('emp_code' => "$empCode","reviewer_id" => "$reviewerCode",                
                "appraiser_status = '3'","emp_status = '2'","reviewer_status" => '3',                
                'YEAR(KraTarget.created_date)' => "$currentYear")
        ));
        return $statusList;
    }
    
    public function getKraTargetApprovedStatusForReviewer($empCode){        
        App::import("Model", "KraTarget");
        $reviewerCode = $_SESSION['Auth']['User']['emp_code'];
        $model = new KraTarget();
        $currentYear = date("Y");
        $statusList = $model->find('all', array(
            'fields' => array('KraTarget.id'),
            'conditions' => array('emp_code' => "$empCode","reviewer_id" => "$reviewerCode",                
                "appraiser_status = '5'","emp_status = '2'","reviewer_status" => '5',                
                'YEAR(KraTarget.created_date)' => "$currentYear")
        ));
        return $statusList;
    }

       
 	/*
     * Get All Designation Name For Listing (Dropdown)
     */

    function getDesignationList() {
        App::import("Model", "OptionAttribute");
        $model = new OptionAttribute();
        $values = $model->find('list', array(
            'conditions' => array(
                'options_id' => 4
            ),
            'fields' => array('name')
        ));
        if (!empty($values))
            return $values;
        else
            return '';
    }
    
    /*
     * Get Designation Name 
     */

    function getDesignationNameByID($ID) {
        App::import("Model", "OptionAttribute");
        $model = new OptionAttribute();
        $values = $model->find('first', array(
            'conditions' => array(
                'OptionAttribute.id'=>$ID,
                'OptionAttribute.options_id' => 4
            ),
            'fields' => array('name')
        ));
       
        if (!empty($values))
            return $values['OptionAttribute']['name'];
        else
            return '';
    }
    
    /*
     * Get the Request's Reference number (in board management)
     */

    function getReqRefNumByReqID($ReqRef) {
        App::import("Model", "BMReceiveRequest");
        $model = new BMReceiveRequest();
        $values = $model->find('first', array(
            'conditions' => array(
                'id'=>$ReqRef,
                'status' => '1'
            ),
            'fields' => array('reference_num')
        ));
        if (!empty($values))
            return $values['BMReceiveRequest']['reference_num'];
        else
            return '';
    }
    
    function getDataEntryTypebyID($id) {
        App::import("Model", "DataType");
        $model = new DataType();
        $values = $model->find('first', array(
            'conditions' => array(
                'id'=>$id,
                'status' => '0'
            ),
            'fields' => array('datatype')
        ));
        if (!empty($values))
            return $values['DataType']['datatype'];
        else
            return '';
    }
    
    function getTitle($id) {
        App::import("Model", "BMTitle");
        $model = new BMTitle();
        $values = $model->find('first', array(
            'conditions' => array(
                'id'=>$id,
                'status' => '0'
            ),
            'fields' => array('title')
        ));
        if (!empty($values))
            return $values['BMTitle']['title'];
        else
            return '';
    }
    
    function getMinistryByID($id) {
        App::import("Model", "Ministry");
        $model = new Ministry();
        $values = $model->find('first', array(
            'conditions' => array(
                'id'=>$id,
                'ministry_status' => '1'
            )
        ));
        if (!empty($values))
            return $values['Ministry']['ministry_name']." [".$values['Ministry']['abbreviation']."]";
        else
            return '';
    }   
	
    function getReqRefDetailByReqID($ReqRef) {
        App::import("Model", "BMReceiveRequest");
        $model = new BMReceiveRequest();
        $values = $model->find('first', array(
            'conditions' => array(
                'id'=>$ReqRef,
                'status' => '1'
            ),
            'fields' => array('id','reference_num','subject','date_of_request')
        ));
        if (!empty($values))
            return $values;
        else
            return '';
    }
		
    public function findDepartmentList() {
        App::import("Model", "Departments");
        $model = new Departments();
        $query = $model->find('list', array(
            'fields' => array('Departments.dept_code','Departments.dept_name'),
        ));
        if (!empty($query)) {
            return $query;
        } else {
            return 0;
        }
    }
    		

    
}