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
 public function findshortlist($id = null) {

        App::import("Model", "CandidateShortlist");
        $model = new CandidateShortlist();
        
        $query = $model->find('all', array('fields'=>array('*'),
            'conditions' => array(
                'candidate_id' => $id,
                'status' => array(2,5))
        ));
    
        if (empty($query)) {
            return 0;
        } else {
            return $query;
        }
    }



 public function findreqlevel($req_id = null) {
        App::import("Model", "RequirementWorkflow");
        $model = new RequirementWorkflow();
        $query = $model->find('count', array(
            'conditions' => array(
                
                'req_id'=>$req_id)
        ));
        if (empty($query)) {
            return 0;
        } else {
            return $query;
        }
    }

    public function findappstatus($req_id = null) {
        App::import("Model", "RequirementWorkflow");
        $model = new RequirementWorkflow();
        $query = $model->find('first', array(
            'conditions' => array(
                'emp_code' =>$_SESSION['Auth']['MyProfile']['emp_code'],
                'req_id'=>$req_id)
        ));
        if (empty($query['RequirementWorkflow']['status'])) {
            return 0;
        } else {
            return $query['RequirementWorkflow']['status'];
        }
    }
    
    public function getCityName($id)
    {
        $support = new Model(array('table' => 'city_master', 'ds' => 'default', 'name' => 'CITY'));
        $data = $support->find('first', array('fields' => array('city_name'), 'conditions' => array('id' => 1)));
        return $data['CITY']['city_name'];
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

    public function get_app_check($id) {

        $comp_code = $_SESSION['Auth']['MyProfile']['comp_code'];
        $emp_dept_id = $_SESSION['Auth']['MyProfile']['dept_code'];
        $emp_desg_id = $_SESSION['Auth']['MyProfile']['desg_code'];
        App::import("Model", "WfMstAppMapLvl");
        $model = new WfMstAppMapLvl();
        $query = $model->find('first', array('fields' => array('sepc_approval'), 'conditions' => array('wf_app_id' => $id)));
        if (!empty($query)) {
            return $query['WfMstAppMapLvl']['sepc_approval'];
        }
    }

    //Gets employee list for Forward if applicable
    public function findLevel($emp_code = null , $comp_code = null) {
        $emp_dept_id = $this->getempdept($emp_code);
        $emp_desg_id = $this->getempdesg($emp_code);

        if ($emp_code == '' || $emp_code == null) {
            $emp_code = $_SESSION['Auth']['MyProfile']['emp_code'];
        }
        if ($comp_code == '' || $comp_code == null) {
            $comp_code = $_SESSION['Auth']['MyProfile']['comp_code'];
        }
        App::import("Model", "MyProfile");
        $model = new MyProfile();
        $query = $model->find('first', array('fields' => array(
                'manager_code', 'dept_code', 'desg_code'), 'conditions' => array('emp_code' => $emp_code, 'comp_code' => $comp_code)));

        if (!empty($query['MyProfile']['manager_code'])) {
            $desglist = $model->find('list', array('fields' => array(
                    'emp_code','emp_name_wd_id'), 'conditions' => array('emp_code' => $query['MyProfile']['manager_code'])));
        } else if ($query['MyProfile']['manager_code'] == NULL && !empty($query)) {
            $desglist = $this->getHrList($emp_code);
        } else {
            $desglist = array();
        }

        return $desglist;
    }

    public function findLevelTravel($des_code = null) {
        $comp_code = $_SESSION['Auth']['MyProfile']['comp_code'];
        $emp_dept_id = $this->getempdept($emp_code);
        $emp_desg_id = $this->getempdesg($emp_code);

        App::import("Model", "MyProfile");
        $model = new MyProfile();
        $desglist = $model->find('list', array('fields' => array(
                'emp_code', 'emp_name'), 'conditions' => array('desg_code' => $des_code)));
//            echo "<pre>";
//            print_r($desglist);
//            die('herer');
        return $desglist;
    }

    public function findTrainingLevel() {

        $comp_code = $_SESSION['Auth']['MyProfile']['comp_code'];
        $emp_dept_id = $_SESSION['Auth']['MyProfile']['dept_code'];
        $emp_desg_id = $_SESSION['Auth']['MyProfile']['desg_code'];
        $emp_code = $_SESSION['Auth']['MyProfile']['emp_code'];
        App::import("Model", "MyProfile");
        $model = new MyProfile();
        $query = $model->find('first', array('fields' => array(
                'manager_code', 'dept_code', 'desg_code'), 'conditions' => array('emp_code' => $emp_code, 'comp_code' => $comp_code)));

        if (!empty($query['MyProfile']['manager_code'])) {
            $desglist = $model->find('list', array('fields' => array(
                    'emp_code', 'emp_name'), 'conditions' => array('emp_code' => $query['MyProfile']['manager_code'])));
        } elseif ($this->getTrainingUserType() == 'TI' || $query['MyProfile']['manager_code'] == $emp_code) {
            $desglist = $this->findTrainingIncharge();
        } else if ($query['MyProfile']['manager_code'] == NULL && !empty($query)) {
            $desglist = $this->findTrainingIncharge();
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
        App::import("Model", "HRMaster");
        $model1 = new HRMaster();
        $empinfo = $model1->find('list', array(
            'fields' => array('hr_code'),
            //'conditions' => array('application_id' =>$appid),
            'order' => 'id asc'
        ));
        //print_r($empinfo); die;
        $query = $model->find('list', array('fields' => array(
                'emp_code', 'emp_name_wd_id'),
                'conditions' => array("emp_code" => $empinfo,
                //'comp_code' => $comp_code,
                //'emp_code !=' . $emp_code,
                'status' => 32),
            'order' => array("emp_name ASC")));
        return $query;
    }
	
    function getHrListByLoc($emp_code) {
		App::import("Model", "MyProfile");
        $comp_code = $_SESSION['Auth']['MyProfile']['comp_code'];
        $model = new MyProfile();
        $query = $model->find('list', array('fields' => array(
                'emp_code', 'emp_name'),
                'conditions' => array("emp_code in ('365','868862','939917')",
                'emp_code !=' . $emp_code,
                'status' => 32),
            'order' => array("emp_name ASC")));
        return $query;
    }

    function getAccList($emp_code) {

        App::import("Model", "MyProfile");
        $comp_code = $_SESSION['Auth']['MyProfile']['comp_code'];
        $model = new MyProfile();
        $query = $model->find('list', array('fields' => array(
                'emp_code', 'emp_name_wd_id'),
                'conditions' => array("emp_code in ('3446','9335','8708')",
                'emp_code !=' . $emp_code,
                'status' => 32),
            'order' => array("emp_name ASC")));
        return $query;
    }

     function getEMPist($emp_code) {

        App::import("Model", "MyProfile");
        $comp_code = $_SESSION['Auth']['MyProfile']['comp_code'];
        $model = new MyProfile();
        $query = $model->find('list', array('fields' => array(
                'emp_code', 'emp_name'),
                'conditions' => array(
                'status' => 32),
            'order' => array("emp_name ASC")));
        return $query;
    }
      function getatEMPist($emp_code) {

        App::import("Model", "MyProfile");
        $comp_code = $_SESSION['Auth']['MyProfile']['comp_code'];
        $model = new MyProfile();
        $query = $model->find('list', array('fields' => array(
                'doc_id', 'emp_name'),
                'conditions' => array(
                'status' => 32),
            'order' => array("emp_name ASC")));
        return $query;
    }

    function getSepcList($emp_code) {
        $emp_code = $_SESSION['Auth']['MyProfile']['emp_code'];
        $support = new Model(array('table' => 'specl_managers', 'ds' => 'default', 'name' => 'SPCLMGR'));
        $query = $model->find('list', array('fields' => array(
                'emp_code', 'emp_name'),
            'emp_code !=' . $emp_code,
            'status' => 32));
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
      public function findinterviewerlevel($emp_code=null,$interviewer_level=null,$can_id=null) {
        App::import("Model", "InterviewerDetails");
        $model = new InterviewerDetails();
        $lvl = $model->find('count', array( 'conditions' => array('interviewer_code' =>$emp_code,'interviewer_level'=>$interviewer_level,'candidate_id'=>$can_id)));
       
        if ($lvl) {
           
            return $lvl;
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

        App::import("Model", "MyProfile");
        $model = new MyProfile();
        $empinfo = $model->find('first', array(
            'fields' => array('MyProfile.emp_name'),
            'conditions' => array(
                'emp_code' => $emp_code,
            )
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

    public function getempdept($emp_code = NULL) {
        App::import("Model", "MyProfile");
        $model = new MyProfile();
        $empinfo = $model->find('first', array(
            'fields' => array('MyProfile.dept_code'),
            'conditions' => array(
                'emp_code' => $emp_code,
                'comp_code' => $comp_code)
        ));
        if (!empty($empinfo))
            return $empinfo['MyProfile']['dept_code'];
        else
            return 'No record found';
    }

    public function getempid($emp_code = NULL) {
        App::import("Model", "MyProfile");
        $model = new MyProfile();
        $empinfo = $model->find('first', array(
            'fields' => array('MyProfile.emp_id'),
            'conditions' => array(
                'emp_code' => $emp_code)
        ));
        if (!empty($empinfo))
            return $empinfo['MyProfile']['emp_id'];
        else
            return 'No record found';
    }
     public function findEmpnamebycode($emp_code = NULL) {
        App::import("Model", "MyProfile");
        $model = new MyProfile();
        $empinfo = $model->find('first', array(
            'fields' => array('MyProfile.emp_full_name'),
            'conditions' => array(
                'emp_code' => $emp_code)
        ));

        
        if (!empty($empinfo))
            return $empinfo['MyProfile']['emp_full_name'];
        else
            return 'No record found';
    }

    public function getempdesg($emp_code = NULL) {
        $comp_code = $_SESSION['Auth']['MyProfile']['comp_code'];

        App::import("Model", "MyProfile");
        $model = new MyProfile();
        $empinfo = $model->find('first', array(
            'fields' => array('MyProfile.desg_code'),
            'conditions' => array(
                'emp_code' => $emp_code,
                'comp_code' => $comp_code)
        ));
        if (!empty($empinfo))
            return $empinfo['MyProfile']['desg_code'];
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

        App::import("Model", "Departments");
        $model = new Departments();
        $tv = $model->find('first', array(
            'fields' => array('dept_name'),
            'conditions' => array(
                'dept_code' => $id
            )
        ));
        return $tv['Departments']['dept_name'];
    }

    public function findDepartmentNameByDeptCode($comp_code = null, $dept_code = null) {
        //function to find all company name
        App::import("Model", "Departments");
        $model = new Departments();
        $query = $model->find('first', array('fields' => array('dept_name'), 'conditions' => array('comp_code' => $comp_code, 'dept_code' => $dept_code)));
        if (empty($query)) {
            return 0;
        } else {
            return $query['Departments']['dept_name'];
        }
    }

    public function findAllDepartmentsNameByDesgCode($desg_code = null) {
        //function to find all company name
        App::import("Model", "Departments");
        $model = new Departments();
        $query = $model->find('all', array(
		'fields' => array('mp.desg_code', 'mp.dept_code', 'Departments.dept_name'),
		'joins' => array(
                array(
                    'table' => 'MyProfile',
                    'alias' => 'mp',
                    'type' => 'inner',
                    'foreignKey' => false,
                    'conditions' => array('mp.dept_code = Departments.dept_code')
                )
            ),
		'conditions' => array('mp.desg_code' => $desg_code),
		'group'=> 'mp.dept_code'));
        if (empty($query)) {
            return 0;
        } else {
            return $query;
        }
    }

    public function getdepartmentlist() {

        App::import("Model", "Department");
        $comp_code = $_SESSION['Auth']['MyProfile']['comp_code'];
        $model = new Department();
        $dept = $model->find('list', array(
            'fields' => array('dept_code', 'dept_name'),
            'conditions' => array(
                'comp_code' => $comp_code
            )
        ));
        return $dept;
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
        if ($leave_code == 'PAR0000298') {
            $query['OptionAttribute']['name'] = 'LWP LEAVE';
        } elseif ($leave_code == 'PAR0000006') {
            $query['OptionAttribute']['name'] = 'MATERNITY LEAVE';
        } elseif ($leave_code == 'PAR0000391') {
            $query['OptionAttribute']['name'] = 'OPTIONAL LEAVE';
        }
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
        App::import("Model", "LeaveConfiguration");
        $leaveConfi = new LeaveConfiguration();
        $leave_type = $leaveConfi->find('first', array('fields' => array('leave_type'), 'conditions' => array('leave_code' => $leave_code)));
        $cl_leave_code = $leaveConfi->find('first', array('fields' => array('leave_code'), 'conditions' => array('leave_type' => 'CL')));
        $ol_leave_code = $leaveConfi->find('first', array('fields' => array('leave_code'), 'conditions' => array('leave_type' => 'EL')));
        $sl_leave_code = $leaveConfi->find('first', array('fields' => array('leave_code'), 'conditions' => array('leave_type' => 'SL')));
        $ml_leave_code = $leaveConfi->find('first', array('fields' => array('leave_code'), 'conditions' => array('leave_type' => 'ML')));
        $pl_leave_code = $leaveConfi->find('first', array('fields' => array('leave_code'), 'conditions' => array('leave_type' => 'PL')));
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
     function getreqlevelbylvid($id) {

        App::import('Model', 'RequirementWorkflow');
        $model = new RequirementWorkflow();
        $level = $model->find('all', array('conditions' => array('req_id' => $id), 'order' => array('id ASC')));
        
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

    function gettraininglevelbyid($id) {
        App::import('Model', 'TrainingWorkflow');
        $model = new TrainingWorkflow();
        $level = $model->find('all', array('conditions' => array('training_creation_id' => $id), 'order' => array('id ASC')));
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

    public function getTrainingUserTypeDesg($emp_code) {
        $desg_code = $this->getempdesgcode($emp_code);
        App::Import("Model", 'OptionAttribute');
        $model = new OptionAttribute();
        $pram_id = $model->find('first', array('fields' => array('OptionAttribute.id'), 'conditions' => array('OptionAttribute.name' => 'EXECUTIVE TRAINEE', 'options_id' => 4)));
        if (!empty($pram_id)) {
            if ($desg_code == $pram_id['OptionAttribute']['id'])
                $userType = 'TI';
            else
                $userType = '';
        }else {
            $userType = '';
        }
        return $userType;
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
public function finddocumentlist() {
        //function to find all modulelist
     $comp_code = $_SESSION['Auth']['MyProfile']['comp_code'];
        App::import("Model", "MstCat");
        $model = new MstCat();
        $query = $model->find('list', array('fields' => array('id', 'catagory_desc'),'conditions' => array('org_id' =>$comp_code)));
    
        if (empty($query)) {
            return 0;
        } else {
            
            return  $query;

        }
    }
    public function findcatgallery_status($k) {
       // Configure::write('debug',2);
        //function to find all modulelist
     $comp_code = $_SESSION['Auth']['MyProfile']['comp_code'];
        App::import("Model", "MstCat");
        $model = new MstCat();
        $query = $model->find('first', array('fields' => array('cat_gallery'),'conditions' => array('org_id' =>$comp_code,'id'=>$k)));
   

         if (!empty($query)) {
            return $query['MstCat']['cat_gallery'];
        } else {
            
            return false;

        }
    }
    
    public function finddocumentlistBycode($cat=null) {
        //function to find all modulelist
     $comp_code = $_SESSION['Auth']['MyProfile']['comp_code'];
        App::import("Model", "MstCat");
        $model = new MstCat();
        $query = $model->find('first', array('fields' => array('id', 'catagory_desc'),'conditions' => array('MstCat.id' =>$cat)));
        if (empty($query)) {
            return 0;
        } else {
            return  $query['MstCat']['catagory_desc'];

        }
    }


      public function findEmployeeName() {
        //function to find all company name
        App::import("Model", "OptionAttribute");
        $model = new OptionAttribute();
        $query = $model->find('list', array('fields' => array('id', 'name'),'conditions' => array('options_id' =>'1' )));
        if (empty($query)) {
            return 0;
        } else {
            return $query;
        }
    }
    public function findLeaveCode() {
        //function to find all Leave code 
        App::import("Model", "Leave");
        $model = new Leave();
        $query = $model->find('list', array('fields' => array('leave_code', 'leave_name'),'group' => 'leave_name'));
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
    public function findEmployeeGroupNameByCode($emp_group= null) {

        App::import("Model", "OptionAttribute");
        $model = new OptionAttribute();
        $query = $model->find('all', array('fields' => array('name'), 'conditions' => array('OptionAttribute.id' => $emp_group)));

        if (empty($query)) {
            return 0;
        } else {
            return $query[0]['OptionAttribute']['name'];
        }
    }
    public function findEmpGroupNameByCode($emp_group= null) {

        App::import("Model", "OptionAttribute");
        $model = new OptionAttribute();
        $query = $model->find('list', array('fields' => array('OptionAttribute.id','OptionAttribute.name'), 'conditions' => array('OptionAttribute.id' => $emp_group,'OptionAttribute.options_id'=>1)));

        if (empty($query)) {
            return 0;
        } else {
            return $query;
        }
    }

    public function findDesignationNameByCode($desg_code = null) {

        //function to find all company name
        
        App::import("Model", "OptionAttribute");
        $model = new OptionAttribute();
        $query = $model->find('all', array('fields' => array('name'), 'conditions' => array('OptionAttribute.id' => $desg_code)));
        
        if (empty($query)) {
            return 0;
        } else {
            return $query[0]['OptionAttribute']['name'];
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

        // echo $emp_code; die;
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
            return 'Ayush Pant';
    }
      public function getcandidatenamebyid($can_id=null)
      {
            App::import("Model", "CandidateDetail");
        $model = new CandidateDetail();
        $empinfo = $model->find('first', array(
            'fields' => array('CandidateDetail.cndt_nm'),
            'conditions' => array(
                'id' => $can_id)
        ));
        
        if (!empty($empinfo))
            return $empinfo['CandidateDetail']['cndt_nm'];
        else
            return 'No records found';
    
      }
    public function getempnamewdid($emp_code = NULL) {

        // echo $emp_code; die;
        App::import("Model", "MyProfile");
        $model = new MyProfile();
        $empinfo = $model->find('first', array(
            'fields' => array('MyProfile.emp_name_wd_id'),
            'conditions' => array(
                'emp_code' => $emp_code)
        ));
        if (!empty($empinfo))
            return $empinfo['MyProfile']['emp_name'];
        else
            return 'Ayush Pant';
    }
	 public function getempnamebyid($emp_code = NULL) {

        // echo $emp_code; die;
        App::import("Model", "MyProfile");
        $model = new MyProfile();
        $empinfo = $model->find('first', array(
            'fields' => array('MyProfile.emp_name_wd_id'),
            'conditions' => array(
                'emp_id' => $emp_code)
        ));
        if (!empty($empinfo))
            return $empinfo['MyProfile']['emp_name_wd_id'];
        else
            return 'Ayush Pant';
    }

      public function findManagerNameCode($emp_code = NULL) {

        // echo $emp_code; die;
        App::import("Model", "UserDetail");
        $model = new UserDetail();
        $empinfo = $model->find('first', array(
            'fields' => array('UserDetail.user_name'),
            'conditions' => array(
                'emp_code' => $emp_code)
        ));
        if (!empty($empinfo))
            return $empinfo['UserDetail']['user_name'];
        else
            return 'No records found';
    }
       public function findapplydate($emp_id = NULL) {

        // echo $emp_code; die;
        App::import("Model", "AttendanceDetail");
        $model = new AttendanceDetail();
        $date = $model->find('first', array(
            'fields' => array('AttendanceDetail.usr_id_create_dt','AttendanceDetail.status'),
            'conditions' => array(
                'emp_id' => $emp_id)
        ));


        if (!empty($date))
        {
            return $date['AttendanceDetail']['usr_id_create_dt'];
        }
        else
        {
            return 'No records found';
        }
    }
 public function findapprovestatus($emp_id = NULL) {

        App::import("Model", "AttendanceDetail");
        $model = new AttendanceDetail();
        $status = $model->find('first', array(
            'fields' => array('AttendanceDetail.status'),
            'conditions' => array(
                'emp_id' => $emp_id)
        ));
        if (!empty($status))
        { return $status['AttendanceDetail']['status'];
        }
        else {
            return 'No records found';
        }
    }
    public function getempname_bydoc_id($emp_code = NULL) {
        App::import("Model", "MyProfile");
        $model = new MyProfile();
        $empinfo = $model->find('first', array(
            'fields' => array('MyProfile.emp_name'),
            'conditions' => array(
                'doc_id' => $emp_code)
        ));
        if (!empty($empinfo))
            return $empinfo['MyProfile']['emp_name'];
        else
            return 'No records found';
    }
    public function getskilllist() {
        App::import("Model", "OptionAttribute");
        $model = new OptionAttribute();
        $empinfo1 = $model->find('list', array(
            'fields' => array('OptionAttribute.id', 'OptionAttribute.name'),
             'conditions' => array('OptionAttribute.options_id'=>4),
                
            'order' => 'OptionAttribute.name'
        ));
        if (!empty($empinfo1))
            return $empinfo1;
        else
            return 'No record found';
    }
      public function getskilllistbyskillcode($skillcode=null) {
        App::import("Model", "OptionAttribute");
        $model = new OptionAttribute();
        $empinfo1 = $model->find('first', array(
            'fields' => array('OptionAttribute.id', 'OptionAttribute.name'),
             'conditions' => array('OptionAttribute.options_id'=>4,'OptionAttribute.id'=>$skillcode),
                
            'order' => 'OptionAttribute.name'
        ));
       
        if (!empty($empinfo1['OptionAttribute']['name']))
            return $empinfo1['OptionAttribute']['name'];
        else
            return 'No record found';
    }
     public function getskilllistbycode($req_id=null) {
        //Configure::write('debug',2);
        App::import("Model", "Requirementskills");
        $model = new Requirementskills();
        $empinfo11 = $model->find('all', array(
            'fields' => array('*'),
            'joins' => array(
                array(
                    'table' => 'option_attribute',
                    'alias' => 'MstRequirement',
                    'type' => 'INNER',
                    'foreignKey' => 'req_id',
                   'conditions' => array('Requirementskills.skills = MstRequirement.id','MstRequirement.options_id'=>4,'MstRequirement.ho_org_id'=>1)
                )
            ),
            'conditions' => array('Requirementskills.req_id' =>$req_id),
            'order'=>'Requirementskills.id '
            
        ));

        if (!empty($empinfo11))
            return $empinfo11;
        else
            return 'No record found';
    }

    public function getemplist() {
        App::import("Model", "MyProfile");
        $model = new MyProfile();
        $empinfo = $model->find('list', array(
            'fields' => array('MyProfile.emp_code', 'MyProfile.emp_name_wd_id'),
            'order' => 'MyProfile.emp_name'
        ));
        if (!empty($empinfo))
            return $empinfo;
        else
            return 'No record found';
    }
    public function getempgroup() {
        App::import("Model", "OptionAttribute");
        $model = new OptionAttribute();
        $empinfo = $model->find('list', array(
            'fields' => array('OptionAttribute.id','OptionAttribute.name'),
            'conditions'=>array('OptionAttribute.options_id'=>1),
            'order' => 'OptionAttribute.id'
        ));

       
        if (!empty($empinfo))
            return $empinfo;
        else
            return 'No record found';
    }
     public function getemloyeelist($emp_code=null) {
        App::import("Model", "MyProfile");
        $model = new MyProfile();
        $empinfo = $model->find('list', array(
            'fields' => array('MyProfile.emp_code','MyProfile.emp_name_wd_id'),
            'conditions' => array('emp_code' =>$emp_code),
            'order' => 'MyProfile.emp_name'
        ));
    

        if (!empty($empinfo))
            return $empinfo;
        else
            return 'No record found';
    }
    
    public function gethrmasterlist($appid=null) {
        App::import("Model", "HRMaster");
        $model = new HRMaster();
        $empinfo = $model->find('list', array(
            'fields' => array('hr_code'),
            'conditions' => array('application_id' =>$appid),
            'order' => 'id asc'
        ));
        if (!empty($empinfo))
            return $empinfo;
        else
            return 'No record found';
    }
    
    public function getmd($comp_code=null)
    {
        App::import("Model", "MDMaster");
        $model = new MDMaster();
        if($comp_code==1)
        {
             $empinfo = $model->find('list', array(
            'fields' => array('MDMaster.md_code'),
            'conditions' => array('comp_code' =>$comp_code),
            'order' => 'id asc'
        ));


            
        }
        elseif($comp_code==2){

              $empinfo = $model->find('list', array(
            'fields' => array('MDMaster.md_code'),
            'conditions' => array('comp_code' =>$comp_code),
            'order' => 'id asc'
        ));


        }
        else{

  $empinfo = $model->find('list', array(
            'fields' => array('MDMaster.md_code'),
            'conditions' => array('comp_code' =>$comp_code),
            'order' => 'id asc'
        ));

        }

return $empinfo;
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

    public function getemplistbyDeptDesig($dept_id = null, $desig_code = null) {
        App::import("Model", "MyProfile");
        $model = new MyProfile();
        $empinfo = $model->find('list', array(
            'fields' => array('MyProfile.id', 'MyProfile.emp_full_name'),
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
            'order' => array('MyProfile.emp_name' => 'DESC')
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
        if(empty($wf_app_id))
            return 'No Record Found';
        App::import("Model", "Applications");
        $model = new Applications();
        $app_name = $model->find('first', array(
            'fields' => array('vc_application_name'),
            'conditions' => array('id=' . $wf_app_id,
                'wf_status ="1"',
        )));
        return $app_name['Applications']['vc_application_name'];
    }
    
    function getEventNamebyid($id) {
        if(empty($id))
            return 'No Record Found';
        App::import("Model", "WfMstEvents");
        $model = new WfMstEvents();
        $app_name = $model->find('first', array(
            'fields' => array('status_name'),
            'conditions' => array('id=' . $id,
                'status ="1"',
        )));
        return $app_name['WfMstEvents']['status_name'];
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

    public function findAllDepartmentName($comp_code = null) { 
        //echo 'ss='.$comp_code;
        App::import("Model", "Department");
        $model = new Department();
        if (!empty($comp_code))
            $conditions = array('comp_code' => $comp_code);
        else
            $conditions = array();
        $dept_name = $model->find("list", array(
            'fields' => array('Department.dept_code', 'Department.dept_name'),
            'conditions' => $conditions
        )); 

        if (!empty($dept_name))
            return $dept_name;
        else
            return false;
    }

    public function findAllDepartmentWithIconsAndName($comp_code = null) {
        App::import("Model", "Department");
        $model = new Department();

        $dept_name = $model->find("all", array(
            'fields' => array('Department.dept_code', 'Department.dept_name', 'Department.icon_style'),
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

    public function findAllVehical($org_id) {
        //ddsssConfigure::write('debug',2);
        App::import("Model", "MstVehicalMaster");
        $model = new MstVehicalMaster();
        $vehical = $model->find('list', array(
            'fields' => array('id', 'vehical_name'),
            'conditions' => array('org_id' => $org_id)
        ));
        //print_r($vehical); die;
        if (!empty($vehical))
            return $vehical;
        else
            return false;
    }

    public function getVehicalByID($id) {
        App::import("Model", "MstVehicalMaster");
        $model = new MstVehicalMaster();
        $vehical = $model->find('first', array(
            'fields' => array('vehical_name'),
            'conditions' => array('status' => true, 'id' => $id)
        ));
        if (!empty($vehical))
            return $vehical['MstVehicalMaster']['vehical_name'];
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

    public function getConveyenceTravelModeById($id) {
        App::import("Model", "MstVehicalMaster");
        $model = new MstVehicalMaster();
        $v_name = $model->find('all', array(
            'fields' => array('MstVehicalMaster.vehical_name'),
            'conditions' => array('MstVehicalMaster.status' => true, 'MstVehicalMaster.id' => $id)
        ));
        if (!empty($v_name))
            return $v_name[0]['MstVehicalMaster']['vehical_name'];
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

    function checkForwardHr($appId, $v_id = null) {
        App::import("Model", "WfMstAppMapLvl");
        $model = new WfMstAppMapLvl();

        if ($appId == 2) {
            App::import("Model", "MstEmpLeave");
            $model1 = new MstEmpLeave();
            $res = $model1->find('first', array('conditions' => array('leave_id' => $v_id)));
            //$desg = $this->getempdesgcode($res['MstEmpLeave']['emp_code']);
            $dept = $this->getemocodebydept($res['MstEmpLeave']['emp_code']);
            $check = $model->find('first', array('conditions' => array('WfMstAppMapLvl.wf_app_id' => $appId)));
            if ($check['WfMstAppMapLvl']['wf_hr_approval'] == 0)
                return false;
                else
                return true;
        }
        if ($appId == 3) {
            App::import("Model", "MstEmpExpVoucher");
            $model1 = new MstEmpExpVoucher();
            $res = $model1->find('first', array('conditions' => array('voucher_id' => $v_id)));
            $dept = $this->getemocodebydept($res['MstEmpExpVoucher']['emp_code']);
            $check = $model->find('first', array('conditions' => array('WfMstAppMapLvl.wf_app_id' => $appId, 'WfMstAppMapLvl.wf_dept_id' => $dept)));
            if ($check['WfMstAppMapLvl']['wf_hr_approval'] == 0)
                return false;
                else
                return true;
        }
    }

    function getHrCheck($appId) {
        App::import("Model", "WfMstAppMapLvl");
        $model = new WfMstAppMapLvl();
        $check = $model->find('first', array('conditions' => array('WfMstAppMapLvl.wf_app_id' => $appId)));
       // print_r($check);
        if ($check['WfMstAppMapLvl']['wf_hr_approval'] == 1) return true; else return false;
    }

   

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
     public function getcompetenciesbymgtcode($mgtcode=null) {
        // print_r($id);die;
        App::import("Model", 'ComptencyTypeMaster');
        $modellabels = new ComptencyTypeMaster();
        $competency = $modellabels->find('all', array(
            'fields' => array('*'),
            'conditions' => array('ComptencyTypeMaster.mgt_code' =>$mgtcode),
            'order' => array('ComptencyTypeMaster.mgt_code')
        ));

        if ($competency) {
            return $competency;
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

    public function option_attribute_loc_name($id) {


        $comp_code = $_SESSION['Auth']['MyProfile']['comp_code'];

        App::import("Model", 'OptionAttribute');
        $modelattri = new OptionAttribute();
        $attribute = $modelattri->find('first', array(
            'fields' => array('OptionAttribute.name'),
            'conditions' => array('OptionAttribute.id' => $id, 'OptionAttribute.options_id' => 3),
        ));

        if ($attribute) {
            return $attribute['OptionAttribute']['name'];
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

    public function findAllSalaryType() {

        App::import("Model", 'Options');
        $modelopt = new Options();
        $sal_typ = $modelopt->find('all', array(
            'conditions' => array('attribute_type_id' => 15),
        ));

        if ($sal_typ) {
            return $sal_typ;
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
            'fields' => array('MyProfile.emp_firstname', 'MyProfile.emp_lastname', 'MyProfile.emp_full_name'),
            'conditions' => array('MyProfile.emp_code' => $emp_code)
        ));
        return $emp_name['MyProfile']['emp_full_name'];
    }

    public function findEmpId($emp_code) {
        App::import("Model", 'MyProfile');
        $modelprofile = new MyProfile();
        $emp_name = $modelprofile->find('first', array(
            'fields' => array('MyProfile.emp_id'),
            'conditions' => array('MyProfile.emp_code' => $emp_code)
        ));
        return $emp_name['MyProfile']['emp_id'];
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
    public function attendance_status() {
        App::import("Model", "AttendanceStatus");
        $model = new AttendanceStatus();
        $query = $model->find('first', array('fields' => array('id','status','latitude','longitude','in_radius'),
            'conditions'=>array('location_code'=>$_SESSION['Auth']['MyProfile']['location_code'])));
         if (empty($query)) {
            return 0;
        } else {
            
            return  $query;

        }
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
                $tot += $empinfoes['kra_kpi_process']['units'];
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
                $tot += $empinfoes['kra_kpi_process']['units'];
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
                $tot += $empinfoes['kra_kpi_process']['units'];
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
                $unitTotal += $empinfoval['kra_kpi_process']['units'];
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
                $empSum += $kralistEmployeeVal['KraKpiProcess']['units'];
            }
            $emp[$k] = $empSum;
            unset($empSum);
            $k++;
        }
        foreach ($emp as $ke => $vl) {
            $temp[$ke] = $vl / count($kralist);
        }
        foreach ($temp as $tval) {
            $tsemp += $tval;
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

    public function getdepddname($emp_code) {
        App::import("Model", "Departments");
        $model = new Departments();
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
                'OptionAttribute.options_id' => 4
            )
        ));
        if (!empty($query['OptionAttribute']['name'])) {
            return $query['OptionAttribute']['name'];
        } else {
            return '';
        }
    }

    public function findDesignationList() {
        App::import("Model", "OptionAttribute");
        $model = new OptionAttribute();
        $query = $model->find('list', array(
            'fields' => array('OptionAttribute.id', 'OptionAttribute.name'),
            'conditions' => array('OptionAttribute.options_id' => 4)
        ));
        if (!empty($query)) {
            return $query;
        } else {
            return 'Not Found';
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
	
	public function getTsActivity($cust_id){
		App::import("Model", "DtCosting");
        $model = new DtCosting();
		//echo $cust_id;
		$section_dtl = $model->find('list', array(
            'fields' => array('DtCosting.vc_dsno', 'DtCosting.vc_activity'),
            'joins' => array(
                array(
                    'table' => 'hd_costing_sheet',
                    'alias' => 'HdCosting',
                    'type' => 'left',
                    'foreignKey' => false,
                    'conditions' => array('HdCosting.vc_sno = DtCosting.vc_sno')
                ),
            ),
            'conditions' => array('HdCosting.nu_cust_code' => $cust_id)
        ));
		//print_r($section_dtl); die;
		 return $section_dtl;
        }


    public function findManagerCode($manager_code) {
        App::import("Model", "MyProfile");
        $model = new MyProfile();
        $manager_code = $model->find('first', array('fields' => array('manager_code'), 'conditions' => array('emp_code' => $manager_code)));
        return $manager_code['MyProfile']['manager_code'];
    }

    //Kra Function Ends

    public function get_admin_option($name) {
        //echo $name;
        App::import("Model", "AdminOption");
        $model = new AdminOption();
        $admin_option = $model->find('first', array('fields' => array('id'), 'conditions' => array('name' => $name)));
        App::import("Model", "AdminOptionOrg");
        $model_new = new AdminOptionOrg();
        $admin_option_org = $model_new->find('first', array('fields' => array('status'), 'conditions' => array('admin_options_id' => $admin_option['AdminOption']['id'], 'org_id' => $_SESSION['Auth']['MyProfile']['comp_code'])));
        //    print_r($admin_option_org);
        if (!empty($admin_option_org))
        {
            return $admin_option_org['AdminOptionOrg']['status'];
        }

        else
        {
            return false;
        }
    }

    public function getAllAclRights() {
        App::import("Model", "AclRights");
        $aclrights = new AclRights();

        $aclrights = $aclrights->find('list', array(
            'fileds' => array('AclRights.name'),
            'conditions' => array('AclRights.status' => 1)
        ));
        return $aclrights;
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

    //Check Salary component enable and disable for MedicalWorkflow
    public function checkMedComSt() {

        App::import("Model", "SalaryDetail");
        $doc_id = $_SESSION['Auth']['MyProfile']['doc_id'];
        $emp_code = $_SESSION['Auth']['MyProfile']['emp_code'];
        $db = ConnectionManager::getDataSource("default"); // name of your database connection
        $dtl = $db->fetchAll("select * from employee_sal_details inner join oracle_org_hcm_salary on employee_sal_details.sal_id= oracle_org_hcm_salary.sal_id where oracle_org_hcm_salary.sal_type_id=331 and employee_sal_details.doc_id='" . $doc_id . "'");

        if (!empty($dtl)) {
            if (($dtl[0]['employee_sal_details']['valid_strt_dt'] <= date('Y-m-d')) && empty($dtl[0]['employee_sal_details']['valid_end_dt'])) {
                $chk = true;
            } elseif (($dtl[0]['employee_sal_details']['valid_strt_dt'] <= date('Y-m-d')) && ($dtl[0]['employee_sal_details']['valid_end_dt'] >= date('Y-m-d'))) {
                $chk = true;
            } else {
                $chk = false;
            }
        } else {
            $chk = false;
        }

        return $chk;
    }

    public function checkLTAComSt() {

        App::import("Model", "SalaryDetail");
        $doc_id = $_SESSION['Auth']['MyProfile']['doc_id'];
        $emp_code = $_SESSION['Auth']['MyProfile']['emp_code'];
        $db = ConnectionManager::getDataSource("default"); // name of your database connection
        $dtl = $db->fetchAll("select * from employee_sal_details inner join oracle_org_hcm_salary on employee_sal_details.sal_id= oracle_org_hcm_salary.sal_id where oracle_org_hcm_salary.sal_type_id=258 and employee_sal_details.doc_id='" . $doc_id . "'");

        if (!empty($dtl)) {
            if (($dtl[0]['employee_sal_details']['valid_strt_dt'] <= date('Y-m-d')) && empty($dtl[0]['employee_sal_details']['valid_end_dt'])) {
                $chk = true;
            } elseif (($dtl[0]['employee_sal_details']['valid_strt_dt'] <= date('Y-m-d')) && ($dtl[0]['employee_sal_details']['valid_end_dt'] >= date('Y-m-d'))) {
                $chk = true;
            } else {
                $chk = false;
            }
        } else {
            $chk = false;
        }

        return $chk;
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
        $bank_name = $portal_app_eo->find('first', array('fields' => array('eo_nm'), 'conditions' => array('eo_mst_id' => $id)));
        return $bank_name['OracleAppEo']['eo_nm'];
    }

    function findfyDesc($fy) {
        App::import("Model", "FinancialYear");
        $fy_model = new FinancialYear();
        $data = $fy_model->find('first', array('fields' => array('*'), 'conditions' => array('id' => $fy)));
        return $data['FinancialYear']['fy_desc'];
    }

    function findfy_id($fy) {
        App::import("Model", "FinancialYear");
        $fy_model = new FinancialYear();
        $data = $fy_model->find('first', array('fields' => array('*'), 'conditions' => array('status' => '1')));
        return $data['FinancialYear']['id'];
    }

    function findAllTempComponent($sal_typ) {
        App::import("Model", "OracleOrgHcmSalary");
        App::import("Model", "EmployeeSalMon");
        App::import("Model", "DtEmployeeSalMon");

        $orgHcm = new OracleOrgHcmSalary();
        $empSalMon = new EmployeeSalMon();

        $emp_code = $_SESSION['Auth']['MyProfile']['emp_code'];
        $month = date('m');

        $temp_comp_month = $empSalMon->find('all', array(
            'fields' => array('sal_id'),
            'conditions' => array('month(claim_date)' => $month, 'emp_code' => $emp_code)
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
            'conditions' => array('OracleOrgHcmSalary.sal_type' => 'T', 'OracleOrgHcmSalary.sal_behav' => array($sal_typ))
        ));

        foreach ($temp_comp_month as $temp) {
            $temp_id = $temp['EmployeeSalMon']['sal_id'];
            unset($temp_comp[$temp_id]);
        }
//print_r($temp_comp_month);die;
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

    function findTaskListemp($id) {
        //echo $id;
        $model = new Model(array('table' => 'task_assign_emp', 'ds' => 'default', 'name' => 'TaskEmp'));
        //Configure::write('debug',2);
        $result = $model->find('all', array('fields' => array('SUM(cstatus) as SUM'), 'conditions' => array('tid' => $id)));
        $count = $model->find('count', array('conditions' => array('tid' => $id)));
        $result = $result[0][0]['SUM'] / $count;
        return (int) $result;
    }

    function findParameterName() {
        App::import("Model", "AttributeType");
        $model = new AttributeType();
        $result = $model->find('list', array('fields' => array('name'), 'order' => array('name ASC')));
        return $result;
    }

    public function findLocationName() {
        //function to find all company name
        App::import("Model", "OptionAttribute");
        $model = new OptionAttribute();
        $query = $model->find('list', array('fields' => array('id', 'name'), 'conditions' => array('options_id' => 3)));

        if (empty($query)) {
            return 0;
        } else {
            return $query;
        }
    }

     public function findholidayLocationName() {
        //function to find all company name
        App::import("Model", "OptionAttribute");
        $model = new OptionAttribute();

        $query = $model->find('list', array('fields' => array('id', 'name'), 'conditions' => array('options_id' => 3) ,'order' => 'name asc'));
       // $query[0] = 'All';
        if (empty($query)) {
            return 0;
        } else {
            return $query;
        }
    }

    public function findLocationNameByCode($locationCode, $comp_code) {
        App::import("Model", "OptionAttribute");
        $model = new OptionAttribute();
        $query = $model->find('first', array('fields' => array('OptionAttribute.name'), 'conditions' => array('OptionAttribute.id' => $locationCode, 'OptionAttribute.options_id' => 3)));

        if (empty($query)) {
            return 0;
        } else {

            return $query['OptionAttribute']['name'];
        }
    }
 
public function LocationName() {
        //function to find all company name
        App::import("Model", "Location");
        $model = new Location();
        $query = $model->find('all', array('fields' => array('id', 'latitude','longitude','in_radius','location_code'),'order' => 'id desc'));

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
            return $query['MyProfile']['desg_code'];
        }
    }

    public function findDepartmentByEmpCode($empId) {
        // echo $empId; die;    
        //function to find all company name

        App::import("Model", "MyProfile");
        $model = new MyProfile();
        $query = $model->find('first', array('fields' => array('dept_code'), 'conditions' => array('MyProfile.emp_code' => $empId)));
        if (empty($query)) {
            return 0;
        } else {
            return $query['MyProfile']['dept_code'];
        }
    }

    public function getAllDesignationByDept($deptCode) {
        //echo $desg_code;      
        //function to find all company name     
        App::import("Model", "MyProfile");
        $model = new MyProfile();
        $query = $model->find('list', array('fields' => array('desg_code', 'desg_code'), 'conditions' => array('MyProfile.dept_code' => "$deptCode"), 'group' => 'MyProfile.desg_code'));
        if (empty($query)) {
            return 0;
        } else {
            return $query;
        }
    }

    public function getAllDesignationByDeptandMgmtGrp($deptCode, $grp_id) {
        //echo $desg_code;      
        //function to find all company name     
        Configure::write('debug', 2);
        App::import("Model", "MyProfile");
        App::import("Model", "MgtGroupDesg");
        $model = new MyProfile();
        $query = $model->find('list', array(
            'fields' => array('desg_code', 'desg_code'),
            'joins' => array(
                array(
                    'table' => 'mgt_group_desg',
                    'alias' => 'MgtGroupDesg',
                    'type' => 'INNER',
                    'foreignKey' => false,
                    'conditions' =>
                    array(
                        'MyProfile.desg_code = MgtGroupDesg.desg_code'
                    )
                )
            ),
            'conditions' => array('MyProfile.dept_code' => "$deptCode", 'MgtGroupDesg.mgt_group' => "$grp_id"),
            'group' => 'MyProfile.desg_code'
                )
        );

        if (empty($query)) {
            return 0;
        } else {
            return $query;
        }
    }

    public function getAllDesignationByDeptandMgmtGrp1($deptCode, $grp_id) {
        //echo $desg_code;      
        //function to find all company name     
        Configure::write('debug', 2);
        App::import("Model", "MyProfile");
        App::import("Model", "MgtGroupDesg");
        $model = new MyProfile();
        $query = $model->find('list', array(
            'fields' => array('desg_code', 'desg_code'),
            'joins' => array(
                array(
                    'table' => 'mgt_group_desg',
                    'alias' => 'MgtGroupDesg',
                    'type' => 'INNER',
                    'foreignKey' => false,
                    'conditions' =>
                    array(
                        'MyProfile.desg_code = MgtGroupDesg.desg_code'
                    )
                )
            ),
            'conditions' => array('MgtGroupDesg.mgt_group' => "$grp_id"),
            'group' => 'MyProfile.desg_code'
                )
        );

        if (empty($query)) {
            return 0;
        } else {
            return $query;
        }
    }

    public function findEmpListByDesgCode($desgCode, $deptCode) {
        //echo $desg_code;		
        //function to find all company name		
 //Configure::write('debug', 2);
        App::import("Model", "MyProfile");
        $model = new MyProfile();
		
        $query = $model->query('SELECT `MyProfile`.`emp_code`, CONCAT(`MyProfile`.`emp_full_name`, " -> ", `MyProfile`.`emp_id`) AS emp_full_name FROM `myprofile` AS `MyProfile` LEFT JOIN `option_attribute` AS `OptionAttribute` ON (`MyProfile`.`location_code` = `OptionAttribute`.`id`) WHERE `MyProfile`.`desg_code` = "'.$desgCode.'" AND `MyProfile`.`dept_code` = "'.$deptCode.'" ORDER BY `MyProfile`.`emp_full_name` ASC');
		//print_r($query);die;

        if (empty($query)) {
            return 0;
        } else {
            return $query;
        }
    }

    public function findEmpListByJoiningDate($sDate, $eDate) {

        $startDate = date('Y-m-d', strtotime($sDate));
        $endDate = date('Y-m-d', strtotime($eDate));

        App::import("Model", "MyProfile");
        $model = new MyProfile();
        $query = $model->find('all', array(
            'fields' => array('emp_code', 'emp_full_name','desg_code','comp_code'),
            'conditions' => array('MyProfile.join_date BETWEEN ? AND ? ' => array($startDate, $endDate)),
            'order' => 'MyProfile.emp_full_name ASC'));
        return $query;
    }

    public function findAnnEmpListByJoiningDate($sDate, $eDate) {
//Configure::write('debug',2);
        $startDate = date('Y-m-d', strtotime($sDate));
        $endDate = date('Y-m-d', strtotime($eDate));

        App::import("Model", "MyProfile");
        $model = new MyProfile();
		
		$kra_config = $this->Session->read('sess_kra_config');
		
		if($kra_config['MstPmsConfig']['mid_review']== 1){
        $query = $model->find('all', array(
            'fields' => array('emp_code', 'emp_full_name','desg_code','comp_code'),
			'joins' => array(
					array(
						'table' => 'mid_reviews',
						'alias' => 'MidReviews',
						'type' => 'inner',
						'foreignKey' => false,
						'conditions' => array('MidReviews.emp_code = MyProfile.emp_code')
					),
					array(
						'table' => 'competency_status',
						'alias' => 'cs',
						'type' => 'inner',
						'foreignKey' => false,
						'conditions' => array('MidReviews.emp_code = cs.emp_code')
					)
				),
            'conditions' => array('MyProfile.join_date BETWEEN ? AND ? ' => array($startDate, $endDate),'MidReviews.status' => 1,'MidReviews.emp_review_status' => 1,'MidReviews.app_review_status' => 1,'MidReviews.rev_review_status' => 1,'MidReviews.mod_review_status' => 1,'cs.app_mid_status' => 1,'cs.rev_mid_status' => 1,'cs.mod_mid_status' => 1,'MyProfile.status'=>32),
            'order' => 'MyProfile.emp_full_name ASC'));
		}
		
		if($kra_config['MstPmsConfig']['mid_review']== 2){
        $query = $model->find('all', array(
            'fields' => array('emp_code', 'emp_full_name','desg_code','comp_code'),
			'joins' => array(
					array(
						'table' => 'kra_approval_status',
						'alias' => 'kas',
						'type' => 'inner',
						'foreignKey' => false,
						'conditions' => array('kas.emp_code = MyProfile.emp_code')
					)
				),
            'conditions' => array('MyProfile.join_date BETWEEN ? AND ? ' => array($startDate, $endDate),'MyProfile.status'=>32,'kas.emp_status'=>1,'kas.app_status'=>1,'kas.rev_status'=>1),
            'order' => 'MyProfile.emp_full_name ASC'));
		}
		//print_r($query);
        return $query;
    }

	
    public function getAllEmployeeListByDepartment($departmentId, $organisationId) {
        App::import("Model", "MyProfile");
        $model = new MyProfile();
        $name = $model->find('all', array(
            'fields' => array('emp_code', 'emp_name', 'desg_code'),
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

    function findGroupMasterList($hoOrgId, $orgId) {
        App::import("Model", "HcmGroupMaster");
        $model = new HcmGroupMaster();
        $result = $model->find('list', array(
            'fields' => array('id', 'group_name'), 'order' => array('group_name ASC'),
            'conditions' => array('status' => "1", 'ho_org_id' => $hoOrgId, 'org_id' => $orgId)));
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
        $result = $model->find('list', array('fields' => array('id', 'competency_name'), 'order' => array('competency_name ASC'), 'conditions' => array('status' => "1")));
        return $result;
    }

    function findCompetencyRatList() {
        //Configure::write('debug',2);
		$kra_config = $this->Session->read('sess_kra_config');
		if($kra_config['MstPmsConfig']['app_type']== 1){
        App::import("Model", "CompetencyRating");
        $model = new CompetencyRating();
        $result = $model->find('all', array('fields' => array('rating_scale'), 'order' => array('rating_scale ASC'), 'conditions' => array('status' => "1"))); 
        }
		if($kra_config['MstPmsConfig']['app_type']== 2){
        $result = array('1.0','0.95','0.90','0.85','0.80','0.75','0.70','0.65','0.60','0.55','0.45','0.40','0.35','0.30','0.25');
        }
        return $result;
    }

    
    function findCompetencyName($competencyId) {
        App::import("Model", "Competency");
        $model = new Competency();
        $result = $model->find('all', array('fields' => array('competency_name'), 'order' => array('competency_name ASC'), 'conditions' => array('id' => $competencyId)));

        return $result[0]['Competency']['competency_name'];
    }

    function findCompetencyListByGroupId($groupId) {
        App::import("Model", "GroupCompetency");
        $model = new GroupCompetency();
        $result = $model->find('list', array('fields' => array('id', 'competency_id'), 'order' => array('competency_id ASC'), 'conditions' => array('group_id' => $groupId)));
        return $result;
    }

    public function findDynamicLevel($id = NULL, $type = 'Forward') {
        print_r($id);
        die;
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
        if (count($query) > 0) {
            $getlvl = $query[0]['DtAppMapLvl']['wf_lvl'];
            $lvl = explode('Level', $getlvl);
            $maxlvl = $lvl[1] + 1;
            $level = 'Level' . $maxlvl;
        } else {
            $level = 'Level1';
        }

        //Finds level details for next level of approval        
        $query1 = $model->find('first', array(
            'conditions' => array('DtAppMapLvl.wf_app_map_lvl_id' => $id, 'DtAppMapLvl.wf_lvl' => $level)
        ));
        //print_r($id);die;             
        //Checks whether current level employee has approval right for lower level employees        
        if (!empty($query1['DtAppMapLvl']['wf_desg_id']) && $type == 'Apply') {
            $desglist = $this->listdesgbyemp($query1['DtAppMapLvl']['wf_desg_id'], $query1['DtAppMapLvl']['wf_dept_id']);
        } else if (!empty($query1['DtAppMapLvl']['wf_desg_id']) && $type == 'Forward' && @$query[0]['DtAppMapLvl']['skip_status'] != 1) {
            $desglist = $this->listdesgbyemp($query1['DtAppMapLvl']['wf_desg_id'], $query1['DtAppMapLvl']['wf_dept_id']);
        } else {
            $desglist = array();
        }
        return $desglist;
    }

    public function findcheckLevelHr($id = NULL) {
        $comp_code = $_SESSION['Auth']['MyProfile']['comp_code'];
        $emp_dept_id = $_SESSION['Auth']['MyProfile']['dept_code'];
        App::import("Model", "WfMstAppMapLvl");
        $model = new WfMstAppMapLvl();
        $query = $model->find('first', array(
            'fields' => array('WfMstAppMapLvl.wf_id', 'WfMstAppMapLvl.manager_approval', 'WfMstAppMapLvl.hr_approval'),
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

    public function findcheckLevel($id = NULL) {

        $comp_code = $_SESSION['Auth']['MyProfile']['comp_code'];
        $emp_dept_id = $_SESSION['Auth']['MyProfile']['dept_code'];
        App::import("Model", "WfMstAppMapLvl");
        $model = new WfMstAppMapLvl();
        $query = $model->find('first', array(
            'fields' => array('WfMstAppMapLvl.wf_id', 'WfMstAppMapLvl.manager_approval'),
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

    public function findCaseType($CTid) {
        //function to find CaseType name        
        App::import("Model", "CaseType");
        $model = new CaseType();
        $CaseType = $model->find('first', array('fields' => array('casetype'), 'conditions' => array('id' => $CTid)));
        return $CaseType['CaseType']['casetype'];
    }

    public function findCourtType($CTid) {
        //function to find CourtType name       
        App::import("Model", "CourtType");
        $model = new CourtType();
        $CourtType = $model->find('first', array('fields' => array('courttype'), 'conditions' => array('id' => $CTid)));
        return $CourtType['CourtType']['courttype'];
    }

    public function CaseCourtLocation($CTid) {
        //function to find CourtType name       
        App::import("Model", "CaseCourtLocation");
        $model = new CaseCourtLocation();
        $CaseCourtLocation = $model->find('first', array('fields' => array('court_location'), 'conditions' => array('id' => $CTid)));
        return $CaseCourtLocation['CaseCourtLocation']['court_location'];
    }

    public function findCaseStatus($CTid) {
        //function to find CourtType name       
        App::import("Model", "CaseStatus");
        $model = new CaseStatus();
        $CaseStatus = $model->find('first', array('fields' => array('case_status'), 'conditions' => array('id' => $CTid)));
        return $CaseStatus['CaseStatus']['case_status'];
    }

    public function findCaseOutcome($CTid) {
        //function to find CourtType name       
        App::import("Model", "CaseOutcome");
        $model = new CaseOutcome();
        $CaseOutcome = $model->find('first', array('fields' => array('case_outcome'), 'conditions' => array('id' => $CTid)));
        return $CaseOutcome['CaseOutcome']['case_outcome'];
    }

    public function findRequestType($RTid) {
        //function to find CourtType name       
        App::import("Model", "MstRequest");
        $model = new MstRequest();
        $RequestType = $model->find('first', array('fields' => array('req_type_name'), 'conditions' => array('id' => $RTid, 'status' => '1')));
        return $RequestType['MstRequest']['req_type_name'];
    }

    public function getKraTargetByEmpCode($empCode, $financialYear) {
        App::import("Model", "KraTarget");
        $model = new KraTarget();

        $desglist = $model->find('all', array(
            'fields' => array('KraTarget.id'),
            'conditions' => array("emp_code = '$empCode'", 'KraTarget.financial_year' => "$financialYear", "appraiser_status = '5'")
        ));
        return count($desglist);
    }

    public function getTotalKraTarge($empCode, $financialYear) {
        App::import("Model", "KraTarget");
        $model = new KraTarget();
        $currentYear = date("Y");
        $desglist = $model->find('all', array(
            'fields' => array('KraTarget.id'),
            'conditions' => array('emp_code' => "$empCode", 'KraTarget.financial_year' => "$financialYear", 'KraTarget.emp_status' => 2)
        ));
        return count($desglist);
    }
     public function getTotalreq() {
        App::import("Model", "RequirementDetail");
        $model = new RequirementDetail();
        //$currentYear = date("Y");
        $reqlist = $model->find('all', array(
            'fields' => array('*'),
            'conditions' => array('RequirementDetail.hiring_type' => array('1','2','3'), 'RequirementDetail.status' => 5)
        ));
   
        return $reqlist;
    }
      public function getTotalinterviewscheduled($emp_code=null) {
        App::import("Model", "InterviewerDetails");
        $model = new InterviewerDetails();
        //$currentYear = date("Y");
        $reqlist = $model->find('all', array(
            'fields' => array('*'),
            'conditions' => array('InterviewerDetails.interviewer_code' => $emp_code, 'InterviewerDetails.status' => 1)
        ));
    //print_r($reqlist);
        return $reqlist;
    }

    public function getKraTargetByEmpCodeForReviewer($empCode, $financialYear) {
        App::import("Model", "KraTarget");
        $model = new KraTarget();

        $desglist = $model->find('all', array(
            'fields' => array('KraTarget.id'),
            'conditions' => array("emp_code = '$empCode'", 'KraTarget.financial_year' => "$financialYear", "reviewer_status = '5'", 'appraiser_status' => '5')
        ));
        return count($desglist);
    }

    public function getKraTargetEmpSelfScore($empCode, $financialYear) {
        App::import("Model", "KraTarget");
        $model = new KraTarget();

        $selfScore = $model->find('all', array(
            'fields' => array('KraTarget.id'),
            'joins' => array(
                array(
                    'table' => 'appraisal_development_plan',
                    'alias' => 'adp',
                    'type' => 'inner',
                    'foreignKey' => false,
                    'conditions' => array('KraTarget.emp_code = adp.emp_code')
                )
            ),
            'conditions' => array("KraTarget.emp_code = '$empCode'", 'KraTarget.financial_year' => "$financialYear",
                "KraTarget.appraiser_status" => '5',
                'KraTarget.self_score_actual != ' => '',
                'KraTarget.self_score_achiev != ' => '',
            ),
        ));
        return count($selfScore);
    }
	
	public function getCompEmpSelfScore($empCode, $financialYear) {
        App::import("Model", "AppraisalDevelopmentPlan");
        $model = new AppraisalDevelopmentPlan();

        $selfScore = $model->find('all', array(
            'fields' => array('*'),
            'conditions' => array("AppraisalDevelopmentPlan.emp_code = '$empCode'", 'AppraisalDevelopmentPlan.financial_year' => "$financialYear",
                "AppraisalDevelopmentPlan.emp_review_status" => 1
            ),
        ));
        return count($selfScore);
    }
    
    public function getKraMidTargetLevelOne($empCode, $financialYear) {
        App::import("Model", "KraTarget");
        $model = new KraTarget();

        $selfScore = $model->find('all', array(
            'fields' => array('KraTarget.id'),
            'conditions' => array("emp_code = '$empCode'", 'KraTarget.financial_year' => "$financialYear",
                "appraiser_status" => '5',
                'mid_self_actual != ' => '',
                'mid_self_acheivement != ' => '')
        ));
        return count($selfScore);
    }

    public function getKraMidTargetLevelTwo($empCode, $financialYear) {
        App::import("Model", "KraTarget");
        $model = new KraTarget();

        $selfScore = $model->find('all', array(
            'fields' => array('KraTarget.id'),
            'conditions' => array("emp_code = '$empCode'", 'KraTarget.financial_year' => "$financialYear",
                "appraiser_status" => '5',
                'mid_self_actual != ' => '',
                'mid_self_acheivement != ' => '',
                'mid_appraiser_score_comment != ' => '')
        ));
        return count($selfScore);
    }

    public function getKraMidTargetLevelThree($empCode, $financialYear) {
        App::import("Model", "KraTarget");
        $model = new KraTarget();

        $selfScore = $model->find('all', array(
            'fields' => array('KraTarget.id'),
            'conditions' => array("emp_code = '$empCode'", 'KraTarget.financial_year' => "$financialYear",
                "appraiser_status" => '5',
                'mid_self_actual != ' => '',
                'mid_self_acheivement != ' => '',
                'mid_appraiser_score_comment != ' => '',
                'mid_reviewer_score_comment != ' => '')
        ));
        return count($selfScore);
    }

    public function getKraMidTargetLevelFour($empCode, $financialYear) {
        App::import("Model", "KraTarget");
        $model = new KraTarget();

        $selfScore = $model->find('all', array(
            'fields' => array('KraTarget.id'),
            'conditions' => array("emp_code = '$empCode'", 'KraTarget.financial_year' => "$financialYear",
                "appraiser_status" => '5',
                'mid_self_actual != ' => '',
                'mid_self_acheivement != ' => '',
                'mid_appraiser_score_comment != ' => '',
                'mid_reviewer_score_comment != ' => '', 
                'mid_moderator_score_comment IS NOT NULL')
        ));
        return count($selfScore);
    }
    

    public function getKraTargetLevelOne($empCode, $financialYear) {
        App::import("Model", "KraTarget");
        $model = new KraTarget();

        $selfScore = $model->find('all', array(
            'fields' => array('KraTarget.id'),
            'conditions' => array("emp_code = '$empCode'", 'KraTarget.financial_year' => "$financialYear",
                "appraiser_status" => '5',
                'self_score_actual != ' => '',
                'self_score_achiev != ' => '')
        ));
        return count($selfScore);
    }

    public function getKraTargetLevelTwo($empCode, $financialYear) {
        App::import("Model", "KraTarget");
        $model = new KraTarget();

        $selfScore = $model->find('all', array(
            'fields' => array('KraTarget.id'),
            'conditions' => array("emp_code = '$empCode'", 'KraTarget.financial_year' => "$financialYear",
                "appraiser_status" => '5',
                'self_score_actual != ' => '',
                'self_score_achiev != ' => '',
                'appraiser_score_comment != ' => '',
                'appraiser_score_achiev != ' => '')
        ));
        return count($selfScore);
    }

    public function getKraTargetLevelThree($empCode, $financialYear) {
        App::import("Model", "KraTarget");
        $model = new KraTarget();

        $selfScore = $model->find('all', array(
            'fields' => array('KraTarget.id'),
            'conditions' => array("emp_code = '$empCode'", 'KraTarget.financial_year' => "$financialYear",
                "appraiser_status" => '5',
                'self_score_actual != ' => '',
                'self_score_achiev != ' => '',
                'appraiser_score_comment != ' => '',
                'appraiser_score_achiev != ' => '',
                'reviewer_score_comment != ' => '',
                'reviewer_score_achiev != ' => '')
        ));
        return count($selfScore);
    }

    public function getKraTargetLevelFour($empCode, $financialYear) {
        App::import("Model", "KraTarget");
        $model = new KraTarget();

        $selfScore = $model->find('all', array(
            'fields' => array('KraTarget.id'),
            'conditions' => array("emp_code = '$empCode'", 'KraTarget.financial_year' => "$financialYear",
                "appraiser_status" => '5',
                'self_score_actual != ' => '',
                'self_score_achiev != ' => '',
                'appraiser_score_comment != ' => '',
                'appraiser_score_achiev != ' => '',
                'reviewer_score_comment IS NOT NULL',
                'reviewer_score_achiev != ' => '', 'moderator_score_comment IS NOT NULL',
                'moderator_score_achiev != ' => '')
        ));
        return count($selfScore);
    }

    public function getKraoverallratings($emp_code, $financial_year) {
        App::import("Model", "KraCompOverallRating");
        $reviewerCode = $_SESSION['Auth']['MyProfile']['emp_code'];
        $model = new KraCompOverallRating();

        $overallScore = $model->find('all', array(
            'fields' => array('*'),
            'conditions' => array("KraCompOverallRating.emp_code = '$emp_code'", 'KraCompOverallRating.financial_year' => "$financial_year")
        ));

        if (!empty($overallScore)) {
            return $overallScore;
        } else {
            return 0;
        }
    }

    public function getKraTargetAppraiserScore($empCode, $financialYear) {
        App::import("Model", "KraTarget");
        $reviewerCode = $_SESSION['Auth']['MyProfile']['emp_code'];
        $model = new KraTarget();

        $selfScore = $model->find('all', array(
            'fields' => array('KraTarget.id'),
            'joins' => array(
                array(
                    'table' => 'competency_target',
                    'alias' => 'ct',
                    'type' => 'inner',
                    'foreignKey' => false,
                    'conditions' => array('KraTarget.emp_code = ct.emp_code')
                ),
                array(
                    'table' => 'appraisal_development_plan',
                    'alias' => 'adp',
                    'type' => 'inner',
                    'foreignKey' => false,
                    'conditions' => array('KraTarget.emp_code = adp.emp_code')
                )
            ),
            'conditions' => array("KraTarget.emp_code = '$empCode'", 'KraTarget.financial_year' => "$financialYear",
                "KraTarget.appraiser_status = '5'",
                "KraTarget.reviewer_id = $reviewerCode",
                'KraTarget.self_score_actual != ' => '',
                'KraTarget.self_score_achiev != ' => '',
                'KraTarget.appraiser_score_achiev != ' => '',
                'adp.appraiser_areas_strength != ' => '',
                'adp.appraiser_areas_development != ' => '')
        ));
        return count($selfScore);
    }

    public function getKraTargetReviewerScore($empCode, $financialYear) {
        App::import("Model", "KraTarget");
        $moderatorCode = $_SESSION['Auth']['MyProfile']['emp_code'];
        $model = new KraTarget();

        $selfScore = $model->find('all', array(
            'fields' => array('KraTarget.id'),
            'joins' => array(
                array(
                    'table' => 'competency_target',
                    'alias' => 'ct',
                    'type' => 'inner',
                    'foreignKey' => false,
                    'conditions' => array('KraTarget.emp_code = ct.emp_code', 'ct.reviewer_rating != NULL', 'ct.reviewer_comment !="" ')
                ),
                array(
                    'table' => 'appraisal_development_plan',
                    'alias' => 'adp',
                    'type' => 'inner',
                    'foreignKey' => false,
                    'conditions' => array('KraTarget.emp_code = adp.emp_code')
                )
            ),
            'conditions' => array("KraTarget.emp_code = '$empCode'", 'KraTarget.financial_year' => "$financialYear",
                "KraTarget.appraiser_status = '5'",
                "KraTarget.moderator_id = $moderatorCode",
                'KraTarget.self_score_actual != ' => '',
                'KraTarget.self_score_achiev != ' => '',
                'KraTarget.appraiser_score_achiev != ' => '',
                'adp.appraiser_areas_strength != ' => '',
                'adp.appraiser_areas_development != ' => '')
        ));
        return count($selfScore);
    }

    public function getKraTargetAllApprovedScore($empCode, $financialYear) {
        App::import("Model", "KraTarget");
        //echo "<pre>"; print_r($_SESSION); die;
        $reviewerCode = $_SESSION['Auth']['MyProfile']['emp_code'];
        $model = new KraTarget();

        $allScores = $model->find('all', array(
            'fields' => array('KraTarget.id'),
            'conditions' => array("emp_code = '$empCode'", 'KraTarget.financial_year' => "$financialYear",
                "appraiser_status = '5'",
                "reviewer_status = '5'",
                "reviewer_id = $reviewerCode",
                'self_score_actual != ' => '',
                'self_score_achiev != ' => '',
                'appraiser_score_achiev != ' => '')
        ));
        count($allScores);
    }

    public function findDepNamebycode($dept_code) {
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

        $emplist = $model->find('first', array(
            'fields' => array('MyProfile.emp_code', 'MyProfile.emp_id', 'MyProfile.manager_code', 'MyProfile.emp_full_name', 'MyProfile.join_date', 'MyProfile.dept_code', 'MyProfile.desg_code', 'MyProfile.comp_code', 'MyProfile.comp_code', 'MyProfile.cur_country_id'),
            'conditions' => array("emp_code = '$empCode'")
        ));
        return $emplist;
    }

    public function getKraTargetAllApprovedScoreForAppraiser($empCode, $financialYear) {
        App::import("Model", "KraTarget");

        $appraiserId = $_SESSION['Auth']['User']['emp_code'];
        $model = new KraTarget();
        $currentYear = date("Y");

        $allScores = $model->find('all', array(
            'fields' => array('KraTarget.id', 'KraTarget.weightage', 'KraTarget.self_score_actual', 'KraTarget.self_score_achiev', 'KraTarget.appraiser_score_actual', 'KraTarget.appraiser_score_achiev'),
            'conditions' => array("emp_code = '$empCode'", 'KraTarget.financial_year' => "$financialYear",
                "appraiser_status = '5'",
                "appraiser_id = $appraiserId",
                'self_score_actual != ' => '',
               'self_score_achiev != ' => '', 
                'appraiser_score_achiev != ' => '')
        ));
        return $allScores;
    }

    public function getKraTargetAllApprovedScoreForReviewer($empCode, $financialYear) {
        App::import("Model", "KraTarget");

        $reviewerCode = $_SESSION['Auth']['User']['emp_code'];
        $model = new KraTarget();
        $currentYear = date("Y");

        $allScores = $model->find('all', array(
            'fields' => array('KraTarget.id', 'KraTarget.weightage', 'KraTarget.self_score_actual', 'KraTarget.self_score_achiev', 'KraTarget.appraiser_score_actual', 'KraTarget.appraiser_score_achiev', 'KraTarget.reviewer_score_actual', 'KraTarget.reviewer_score_achiev'),
            'conditions' => array("emp_code = '$empCode'", 'KraTarget.financial_year' => "$financialYear",
                "appraiser_status = '5'",
                "reviewer_id = $reviewerCode",
                'self_score_actual != ' => '',
                'self_score_achiev != ' => '', 'reviewer_score_achiev != ' => '',
                'appraiser_score_achiev != ' => '')
        ));
        return $allScores;
    }

    public function getKraTargetAllApprovedScoreForModerator($empCode, $financialYear) {
        App::import("Model", "KraTarget");

        $reviewerCode = $_SESSION['Auth']['User']['emp_code'];
        $model = new KraTarget();
        $currentYear = date("Y");

        $allScores = $model->find('all', array(
            'fields' => array('KraTarget.id', 'KraTarget.weightage', 'KraTarget.self_score_actual', 'KraTarget.self_score_achiev', 'KraTarget.appraiser_score_actual', 'KraTarget.appraiser_score_achiev', 'KraTarget.reviewer_score_actual', 'KraTarget.reviewer_score_achiev', 'KraTarget.moderator_score_actual', 'KraTarget.moderator_score_achiev'),
            'conditions' => array("emp_code = '$empCode'", 'KraTarget.financial_year' => "$financialYear",
                "appraiser_status = '5'",
                "moderator_id = $reviewerCode",
                'self_score_actual != ' => '',
                'self_score_achiev != ' => '',
                'moderator_score_achiev != ' => '',
                'reviewer_score_achiev != ' => '')
        ));
        return $allScores;
    }

    public function getKraTargetAllApprovedScoreForEmp($financialYear) {
        App::import("Model", "KraTarget");

        $empCode = $_SESSION['Auth']['User']['emp_code'];
        $model = new KraTarget();
        $currentYear = date("Y");

        $allScores = $model->find('all', array(
            'fields' => array('KraTarget.id', 'KraTarget.self_score_achiev'),
            'conditions' => array("emp_code = '$empCode'", 'KraTarget.financial_year' => "$financialYear",
                "appraiser_status = '5'",
                'self_score_actual != ' => '',
                'self_score_achiev != ' => '', 'reviewer_score_achiev != ' => '', 'YEAR(KraTarget.created_date)' => $currentYear,
                'appraiser_score_achiev != ' => '')
        ));
        return $allScores;
    }

    public function getKraTargetOpenStatusForEmp($empCode, $financialYear) {
        //Configure::write('debug',2);
        App::import("Model", "KraTarget");
        $appraiserId = $_SESSION['Auth']['User']['emp_code'];
        $model = new KraTarget();
        $currentYear = date("Y");
        $statusList = $model->find('all', array(
            'fields' => array('KraTarget.id'),
            'conditions' => array('emp_code' => "$empCode", 'KraTarget.financial_year' => "$financialYear",
                "appraiser_status = '1'", "emp_status = '2'",
                'YEAR(KraTarget.created_date)' => "$currentYear")
        ));
        return $statusList;
    }

    public function getKraTargetOpenStatusForEmp1($empCode, $financialYear) {
        //Configure::write('debug',2);
        App::import("Model", "KraTarget");
        $appraiserId = $_SESSION['Auth']['User']['emp_code'];
        $model = new KraTarget();
        $currentYear = date("Y");
        $statusList = $model->find('all', array(
            'fields' => array('KraTarget.id'),
            'conditions' => array('emp_code' => "$empCode", 'KraTarget.financial_year' => "$financialYear",
                "appraiser_status = '5'", "emp_status = '2'",
                'YEAR(KraTarget.created_date)' => "$currentYear")
        ));
        return $statusList;
    }

    public function getKraTargetRevertStatusforEmpByAppraiser($empCode, $financialYear) {
        //$appraiserId = $_SESSION['Auth']['User']['emp_code'];
        App::import("Model", "KraTarget");
        $model = new KraTarget();
        $currentYear = date("Y");
        $statusList = $model->find('all', array(
            'fields' => array('KraTarget.id'),
			'joins' => array(
								array(
									'table' => 'kra_approval_status',
									'alias' => 'kas',
									'type' => 'inner',
									'foreignKey' => false,
									'conditions' => array('kas.emp_code = KraTarget.emp_code')
								)
							),
            'conditions' => array('KraTarget.emp_code' => "$empCode", 'KraTarget.financial_year' => "$financialYear",
                "KraTarget.appraiser_status" => array(1, 3), "KraTarget.final_status = '0'", "KraTarget.emp_status = '2'",
                'KraTarget.financial_year' => "$financialYear",'kas.emp_status' => 0,'kas.app_status' => 1)
        ));
        return $statusList;
    }

    public function getKraTargetRevertStatusforEmpByReviewer($empCode, $financialYear) {
        //$appraiserId = $_SESSION['Auth']['User']['emp_code'];
        App::import("Model", "KraTarget");
        $model = new KraTarget();
        $currentYear = date("Y");
        $statusList = $model->find('all', array(
            'fields' => array('KraTarget.id'),
            'conditions' => array('emp_code' => "$empCode", 'KraTarget.financial_year' => "$financialYear",
                "reviewer_status" => array(0, 3), "reviewer_final_status = '0'", "emp_status = '2'",
                'KraTarget.financial_year' => "$financialYear")
        ));
        return $statusList;
    }

    public function getKraTargetApprovedStatusForEmp($empCode, $financialYear) {
        //$appraiserId = $_SESSION['Auth']['User']['emp_code'];
        App::import("Model", "KraTarget");
        $model = new KraTarget();
        //$currentYear = date("Y");
        $statusList = $model->find('all', array(
            'fields' => array('KraTarget.id', 'KraTarget.self_score_achiev', 'KraTarget.self_score_actual', 'KraTarget.weightage'),
		
            'conditions' => array('KraTarget.emp_code' => "$empCode", 'KraTarget.financial_year' => "$financialYear",
                "KraTarget.appraiser_status = '5'", "KraTarget.emp_status = '2'")
        ));
        return $statusList;
    }
	
	 public function getOpenKraStatusLevel($empCode, $financialYear,$page) {
        //$appraiserId = $_SESSION['Auth']['User']['emp_code'];
        App::import("Model", "KraTarget");
        $model = new KraTarget();
        //$currentYear = date("Y");
		if($page=='emp'){
			$statusLista = $model->find('all', array(
				'fields' => array('KraTarget.id'),
				'joins' => array(
									array(
										'table' => 'kra_approval_status',
										'alias' => 'kas',
										'type' => 'inner',
										'foreignKey' => false,
										'conditions' => array('kas.emp_code = KraTarget.emp_code')
									)
								),
				'conditions' => array('KraTarget.emp_code' => "$empCode", 'KraTarget.financial_year' => "$financialYear",
					 "KraTarget.emp_status = '2'","kas.emp_status = 0","kas.app_status = 1","kas.rev_status = 0"),
				'group'=>'KraTarget.emp_code'
			));
			
			$statusListb = $model->find('all', array(
				'fields' => array('KraTarget.id'),
				'joins' => array(
									array(
										'table' => 'kra_approval_status',
										'alias' => 'kas',
										'type' => 'inner',
										'foreignKey' => false,
										'conditions' => array('kas.emp_code = KraTarget.emp_code')
									)
								),
				'conditions' => array('KraTarget.emp_code' => "$empCode", 'KraTarget.financial_year' => "$financialYear",
					 "KraTarget.emp_status = '2'","kas.emp_status = 0","kas.app_status = 0","kas.rev_status = 1"),
				'group'=>'KraTarget.emp_code'
			));
			
			$statusListc = $model->find('all', array(
				'fields' => array('KraTarget.id'),
				'joins' => array(
									array(
										'table' => 'kra_approval_status',
										'alias' => 'kas',
										'type' => 'inner',
										'foreignKey' => false,
										'conditions' => array('kas.emp_code = KraTarget.emp_code')
									)
								),
				'conditions' => array('KraTarget.emp_code' => "$empCode", 'KraTarget.financial_year' => "$financialYear",
					 "KraTarget.emp_status = '2'","kas.emp_status = 0","kas.app_status = 1","kas.rev_status = 1"),
				'group'=>'KraTarget.emp_code'
			));
			
			$statusListd = array_merge($statusLista,$statusListb);
			$statusList = array_merge($statusListd,$statusListc);
			
		}elseif($page=='app'){
			$statusLista = $model->find('all', array(
				'fields' => array('KraTarget.id'),
				'joins' => array(
									array(
										'table' => 'kra_approval_status',
										'alias' => 'kas',
										'type' => 'inner',
										'foreignKey' => false,
										'conditions' => array('kas.emp_code = KraTarget.emp_code')
									)
								),
				'conditions' => array('KraTarget.emp_code' => "$empCode", 'KraTarget.financial_year' => "$financialYear",
					 "KraTarget.emp_status = '2'","kas.emp_status = 1","kas.app_status = 0","kas.rev_status = 0"),
				'group'=>'KraTarget.emp_code'
			));
			
			$statusListb = $model->find('all', array(
				'fields' => array('KraTarget.id'),
				'joins' => array(
									array(
										'table' => 'kra_approval_status',
										'alias' => 'kas',
										'type' => 'inner',
										'foreignKey' => false,
										'conditions' => array('kas.emp_code = KraTarget.emp_code')
									)
								),
				'conditions' => array('KraTarget.emp_code' => "$empCode", 'KraTarget.financial_year' => "$financialYear",
					 "KraTarget.emp_status = '2'","kas.emp_status = 1","kas.app_status = 0","kas.rev_status = 1"),
				'group'=>'KraTarget.emp_code'
			));
			
			$statusList = array_merge($statusLista,$statusListb);
			
		}elseif($page=='rev'){
			$statusList = $model->find('all', array(
				'fields' => array('KraTarget.id'),
				'joins' => array(
									array(
										'table' => 'kra_approval_status',
										'alias' => 'kas',
										'type' => 'inner',
										'foreignKey' => false,
										'conditions' => array('kas.emp_code = KraTarget.emp_code')
									)
								),
				'conditions' => array('KraTarget.emp_code' => "$empCode", 'KraTarget.financial_year' => "$financialYear",
					 "KraTarget.emp_status = '2'","kas.emp_status = 1","kas.app_status = 1","kas.rev_status = 0"),
				'group'=>'KraTarget.emp_code'
			));
		}
        return count($statusList);
    }
	
	public function getOpenFinalKraStatusLevel($empCode, $financialYear,$page) {
        //$appraiserId = $_SESSION['Auth']['User']['emp_code'];
        App::import("Model", "KraTarget");
        $model = new KraTarget();
        //$currentYear = date("Y");
		
			$statusList = $model->find('all', array(
				'fields' => array('KraTarget.id'),
				'joins' => array(
									array(
										'table' => 'kra_approval_status',
										'alias' => 'kas',
										'type' => 'inner',
										'foreignKey' => false,
										'conditions' => array('kas.emp_code = KraTarget.emp_code')
									)
								),
				'conditions' => array('KraTarget.emp_code' => "$empCode", 'KraTarget.financial_year' => "$financialYear",
					 "KraTarget.emp_status = '2'","kas.emp_status = 1","kas.app_status = 1","kas.rev_status = 1"),
				'group'=>'KraTarget.emp_code'
			));
			
		
        return count($statusList);
    }
	
	public function getKraTargetApprovalStatus($empCode, $financialYear) {
        //$appraiserId = $_SESSION['Auth']['User']['emp_code'];
        App::import("Model", "KraTarget");
        $model = new KraTarget();
        //$currentYear = date("Y");
        $statusList = $model->find('all', array(
            'fields' => array('*'),
            'conditions' => array('emp_code' => "$empCode", 'KraTarget.financial_year' => "$financialYear",'KraTarget.appraiser_status' => 5,'KraTarget.reviewer_status' => 5,"emp_status = '2'")
        ));
        return $statusList;
    }

    public function allApprRecordsForRev($empCode, $financialYear) {
        //$appraiserId = $_SESSION['Auth']['User']['emp_code'];
        App::import("Model", "KraTarget");
        $model = new KraTarget();
        //$currentYear = date("Y");
        $statusList = $model->find('all', array(
            'fields' => array('KraTarget.id', 'KraTarget.reviewer_status', 'KraTarget.reviewer_final_status'),
            'conditions' => array('emp_code' => "$empCode", 'KraTarget.financial_year' => "$financialYear",
                "appraiser_status = '5'", "final_status = '1'","reviewer_status" => array(5), "reviewer_final_status = '1'", "emp_status = '2'")
        ));
        return $statusList;
    }

    public function getKraTargetOpenStatus($empCode, $financialYear) {
        App::import("Model", "KraTarget");
        $appraiserId = $_SESSION['Auth']['User']['emp_code'];
        $model = new KraTarget();
        $currentYear = date("Y");
        $statusList = $model->find('all', array(
            'fields' => array('KraTarget.id'),
            'conditions' => array('emp_code' => "$empCode", 'KraTarget.financial_year' => "$financialYear",
                'appraiser_id' => "$appraiserId", "appraiser_status = '1'", "emp_status = '2'",
                'YEAR(KraTarget.created_date)' => "$currentYear")
        ));
        return $statusList;
    }

    public function getKraTargetRevertStatus($empCode, $financialYear) {
        $appraiserId = $_SESSION['Auth']['User']['emp_code'];
        App::import("Model", "KraTarget");
        $model = new KraTarget();
        $currentYear = date("Y");
        $statusList = $model->find('all', array(
            'fields' => array('KraTarget.id'),
            'conditions' => array('emp_code' => "$empCode", 'KraTarget.financial_year' => "$financialYear",
                'appraiser_id' => "$appraiserId", "appraiser_status = '3'", "emp_status = '2'",
                'YEAR(KraTarget.created_date)' => "$currentYear")
        ));
        return $statusList;
    }

    public function getKraTargetRevertStatusForAppraiser($empCode, $appraiserId, $financialYear) {

        App::import("Model", "KraTarget");
        $model = new KraTarget();
        $currentYear = date("Y");
        $statusList = $model->find('all', array(
            'fields' => array('KraTarget.id'),
            'conditions' => array('emp_code' => "$empCode", 'KraTarget.financial_year' => "$financialYear",
                'appraiser_id' => "$appraiserId", "appraiser_status = '3'", "emp_status = '2'",
                'YEAR(KraTarget.created_date)' => "$currentYear")
        ));
        return $statusList;
    }

    public function getKraTargetApprovedStatus($empCode, $financialYear) {
        $appraiserId = $_SESSION['Auth']['User']['emp_code'];
        App::import("Model", "KraTarget");
        $model = new KraTarget();
        $currentYear = date("Y");
        $statusList = $model->find('all', array(
            'fields' => array('KraTarget.id'),
            'conditions' => array('emp_code' => "$empCode", 'KraTarget.financial_year' => "$financialYear",
                'appraiser_id' => "$appraiserId",
                "appraiser_status = '5'", "emp_status = '2'",
                'YEAR(KraTarget.created_date)' => "$currentYear")
        ));
        return $statusList;
    }

    public function getKraTargetApprovedStatusApp($empCode, $financialYear) {
        App::import("Model", "KraTarget");
        $model = new KraTarget();
        $currentYear = date("Y");
        $statusList = $model->find('all', array(
            'fields' => array('KraTarget.id'),
            'conditions' => array('emp_code' => "$empCode", 'KraTarget.financial_year' => "$financialYear",
                "appraiser_status = '5'", "emp_status = '2'",
            )
        ));
        return $statusList;
    }

    public function getKraTargetApprovedStatusRev($empCode, $financialYear) {
        App::import("Model", "KraTarget");
        $model = new KraTarget();
        $currentYear = date("Y");
        $statusList = $model->find('all', array(
            'fields' => array('KraTarget.id'),
            'conditions' => array('emp_code' => "$empCode", 'KraTarget.financial_year' => "$financialYear",
                "appraiser_status = '5'", "reviewer_status = '5'", "emp_status = '2'",
            )
        ));
        return $statusList;
    }

    public function getKraTargetOpenStatusByAppraiser($empCode, $financialYear) {
        App::import("Model", "KraTarget");
        $reviewerCode = $_SESSION['Auth']['User']['emp_code'];
        $model = new KraTarget();

        $statusList = $model->find('all', array(
            'fields' => array('KraTarget.id'),
            'conditions' => array('emp_code' => "$empCode", 'KraTarget.financial_year' => "$financialYear",
                "reviewer_id" => "$reviewerCode",
                "appraiser_status" => array(1, 3), "emp_status = '2'", "reviewer_status" => array(0))
        ));
        return $statusList;
    }

    public function getKraTargetOpenStatusForReviewer($empCode, $financialYear) {
        App::import("Model", "KraTarget");
        $reviewerCode = $_SESSION['Auth']['User']['emp_code'];
        $model = new KraTarget();

        $statusList = $model->find('all', array(
            'fields' => array('KraTarget.id'),
			'joins' => array(
				array(
					'table' => 'kra_approval_status',
					'alias' => 'kas',
					'type' => 'inner',
					'foreignKey' => false,
					'conditions' => array('kas.emp_code = KraTarget.emp_code')
				)
			),
		'conditions' => array('KraTarget.financial_year' => "$financialYear",
                "KraTarget.reviewer_id" => "$reviewerCode",
                "KraTarget.appraiser_status = '5'", "KraTarget.emp_status = '2'", "KraTarget.reviewer_status" => array(0, 3),'kas.emp_status' => 1,'kas.app_status' => 1,'kas.rev_status' => 0)
        ));
        return $statusList;
    }

    public function getKraTargetOpenStatusForReviewer1($empCode, $financialYear) {
        App::import("Model", "KraTarget");
        $reviewerCode = $_SESSION['Auth']['User']['emp_code'];
        $model = new KraTarget();

        $statusList = $model->find('all', array(
            'fields' => array('KraTarget.id'),
			'joins' => array(
				array(
					'table' => 'kra_approval_status',
					'alias' => 'kas',
					'type' => 'inner',
					'foreignKey' => false,
					'conditions' => array('kas.emp_code = KraTarget.emp_code')
				)
			),
            'conditions' => array('KraTarget.financial_year' => "$financialYear",
                "KraTarget.reviewer_id" => "$reviewerCode",
                "KraTarget.emp_status = '2'", "KraTarget.reviewer_status" => array(3),'kas.emp_status' => 1,'kas.app_status' => 1,'kas.rev_status' => 0)
        ));

        return $statusList;
    }

    public function getKraTargetOpenStatusByReviewer($empCode, $financialYear) {
        //Configure::write('debug',2);
        App::import("Model", "KraTarget");
        $reviewerCode = $_SESSION['Auth']['User']['emp_code'];
        $model = new KraTarget();

        $statusList = $model->find('all', array(
            'fields' => array('KraTarget.id'),
            'conditions' => array('emp_code' => "$empCode", 'KraTarget.financial_year' => "$financialYear",
                "reviewer_id" => "$reviewerCode",
                "emp_status = '2'", "reviewer_status" => array(3))
        ));
        //print_r(count($statusList));die;
        return $statusList;
    }

    public function getKraTargetRevertStatusForReviewer($empCode, $financialYear) {
        App::import("Model", "KraTarget");
        $reviewerCode = $_SESSION['Auth']['User']['emp_code'];
        $model = new KraTarget();
        $currentYear = date("Y");
        $statusList = $model->find('all', array(
            'fields' => array('KraTarget.id'),
            'conditions' => array('emp_code' => "$empCode", 'KraTarget.financial_year' => "$financialYear",
                "reviewer_id" => "$reviewerCode",
                "emp_status = '2'", "appraiser_status" => '3', "reviewer_status" => '3')
        ));
        //print_r(count($statusList));die;
        return $statusList;
    }

    public function getKraTargetApprovedStatusForReviewer($empCode, $financialYear) {
        App::import("Model", "KraTarget");
        $reviewerCode = $_SESSION['Auth']['User']['emp_code'];
        $model = new KraTarget();
        $currentYear = date("Y");
        $statusList = $model->find('all', array(
            'fields' => array('KraTarget.id'),
            'conditions' => array('emp_code' => "$empCode", 'KraTarget.financial_year' => "$financialYear", "reviewer_id" => "$reviewerCode",
                "appraiser_status = '5'", "emp_status = '2'", "reviewer_status" => '5')
        ));
        return $statusList;
    }

    public function getKraTargetApprovedStatusForReviewer1($empCode, $financialYear) {
        App::import("Model", "KraTarget");
        $reviewerCode = $_SESSION['Auth']['User']['emp_code'];
        $model = new KraTarget();
        $currentYear = date("Y");
        $statusList = $model->find('all', array(
            'fields' => array('KraTarget.id'),
            'conditions' => array('emp_code' => "$empCode", 'KraTarget.financial_year' => "$financialYear", "reviewer_id" => "$reviewerCode",
                "appraiser_status = '5'", "emp_status = '2'", "reviewer_status" => '3')
        ));
        return $statusList;
    }

    public function getKraTargetApprovedStatusForModerator($empCode, $financialYear) {
        App::import("Model", "KraTarget");
        $moderatorCode = $_SESSION['Auth']['User']['emp_code'];
        $model = new KraTarget();
        $currentYear = date("Y");
        $statusList = $model->find('all', array(
            'fields' => array('KraTarget.id'),
            'conditions' => array('emp_code' => "$empCode", 'KraTarget.financial_year' => "$financialYear", "moderator_id" => "$moderatorCode",
                "emp_status = '2'", "moderator_status" => '5')
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
            'fields' => array('name'),
            'order' => 'name ASC'
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
                'OptionAttribute.id' => $ID,
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
                'BMReceiveRequest.id' => $ReqRef,
                'BMReceiveRequest.status' => '1'
            ),
            'fields' => array('BMReceiveRequest.reference_num')
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
                'id' => $id,
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
                'id' => $id,
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
                'id' => $id,
                'ministry_status' => '1'
            )
        ));
        if (!empty($values))
            return $values['Ministry']['ministry_name'] . " [" . $values['Ministry']['abbreviation'] . "]";
        else
            return '';
    }

    function getMinistryList() {
        App::import("Model", "Ministry");
        $model = new Ministry();
        $values = $model->find('list', array('fields' => array('id', 'ministry_name'),
            'conditions' => array(
                'ministry_status' => '1'
            )
        ));
        if (!empty($values))
            return $values;
        else
            return '';
    }

    function getMinistryEmailByID($id) {
        App::import("Model", "Ministry");
        $model = new Ministry();
        $values = $model->find('first', array(
            'conditions' => array(
                'id' => $id,
                'ministry_status' => '1'
            )
        ));
        if (!empty($values))
            return $values['Ministry']['email_id'];
        else
            return '';
    }

    function getReqRefDetailByReqID($ReqRef) {
        App::import("Model", "BMReceiveRequest");
        $model = new BMReceiveRequest();
        $values = $model->find('first', array(
            'conditions' => array(
                'BMReceiveRequest.id' => $ReqRef,
                'BMReceiveRequest.status' => '1'
            ),
            'fields' => array('BMReceiveRequest.id', 'BMReceiveRequest.req_ref_serial_no', 'BMReceiveRequest.reference_num', 'BMReceiveRequest.subject', 'BMReceiveRequest.date_of_request')
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
            'fields' => array('Departments.dept_code', 'Departments.dept_name'),
        ));
        if (!empty($query)) {
            return $query;
        } else {
            return 0;
        }
    }

    public function findKraRatingList() {
        App::import("Model", "KraRating");
        $model = new KraRating();
        $query = $model->find('all', array(
            'fields' => array('KraRating.rating_scale', 'KraRating.comment', 'KraRating.achievement_from', 'KraRating.achievement_to'),
            'conditions' => array('KraRating.is_deleted' => 0, 'KraRating.status' => 1),
            'order' => 'rating_scale DESC',
        ));
        if (!empty($query)) {
            return $query;
        } else {
            return 0;
        }
    }
    
     public function findOverAllRatingList() {
        App::import("Model", "Rating");
        $model = new Rating();
        $query = $model->find('all', array(
            'fields' => array('Rating.rating_name','Rating.description', 'Rating.rating_scale_from', 'Rating.rating_scale_to'),
            'conditions' => array('Rating.status' => 1),
            'order' => 'id ASC',
        ));
        if (!empty($query)) {
            return $query;
        } else {
            return 0;
        }
    }

    public function findCompetencyRatingList() {
        App::import("Model", "CompetencyRating");
        $model = new CompetencyRating();
        $query = $model->find('all', array(
            'fields' => array('CompetencyRating.rating_scale', 'CompetencyRating.comment', 'CompetencyRating.achievement_from', 'CompetencyRating.achievement_to'),
            'conditions' => array('CompetencyRating.is_deleted' => 0, 'CompetencyRating.status' => 1),
            'order' => 'rating_scale DESC',
        ));
        if (!empty($query)) {
            return $query;
        } else {
            return 0;
        }
    }

    public function findAppraisalProcessList($empCode, $currentFinancialYear) {
        App::import("Model", "AppraisalProcess");
        $model = new AppraisalProcess();
        $totalAppraisalProcess = $model->find('all', array(
            'fields' => array('AppraisalProcess.id'),
            'conditions' => array('AppraisalProcess.status' => '1',
                'AppraisalProcess.financial_year' => $currentFinancialYear,
                'AppraisalProcess.emp_code' => $empCode,
				'AppraisalProcess.status' => 1),
        ));

        //echo count($totalAppraisalProcess); 

        if (count($totalAppraisalProcess) >= 1) {
            return 1;
        } else {
            return count($totalAppraisalProcess);
        }
    }

    public function findAppraisalProcessListApp($empCode, $currentFinancialYear) {
        //Configure::write('debug',2);
        App::import("Model", "AppraisalProcess");
        $model = new AppraisalProcess();
        $totalAppraisalProcess = $model->find('all', array(
            'fields' => array('AppraisalProcess.id'),
            'joins' => array(
                array(
                    'table' => 'appraisal_development_plan',
                    'alias' => 'adp',
                    'type' => 'inner',
                    'foreignKey' => false,
                    'conditions' => array('AppraisalProcess.emp_code = adp.emp_code')
                )
            ),
            'conditions' => array('AppraisalProcess.status' => '1',
                'AppraisalProcess.financial_year' => $currentFinancialYear,
                'AppraisalProcess.emp_code' => $empCode,
                'adp.self_areas_strength !=' => "",
                'adp.self_areas_development !=' => "",
            ),
        ));

        //echo count($totalAppraisalProcess); 

        if (count($totalAppraisalProcess) >= 1) {
            return 1;
        } else {
            return count($totalAppraisalProcess);
        }
    }

    public function findAppraisalProcessListRev($empCode, $currentFinancialYear) {
        //Configure::write('debug',2);
        App::import("Model", "AppraisalProcess");
        $model = new AppraisalProcess();
        $totalAppraisalProcess = $model->find('all', array(
            'fields' => array('AppraisalProcess.id'),
            'joins' => array(
                array(
                    'table' => 'competency_target',
                    'alias' => 'ct',
                    'type' => 'inner',
                    'foreignKey' => false,
                    'conditions' => array('AppraisalProcess.emp_code = ct.emp_code')
                ),
                array(
                    'table' => 'appraisal_development_plan',
                    'alias' => 'adp',
                    'type' => 'inner',
                    'foreignKey' => false,
                    'conditions' => array('AppraisalProcess.emp_code = adp.emp_code')
                )
            ),
            'conditions' => array('AppraisalProcess.status' => '1',
                'AppraisalProcess.financial_year' => $currentFinancialYear,
                'AppraisalProcess.emp_code' => $empCode,
                'adp.appraiser_areas_strength !=' => "",
                'adp.self_areas_strength !=' => "",
            ),
        ));

        //echo count($totalAppraisalProcess); 

        if (count($totalAppraisalProcess) >= 1) {
            return 1;
        } else {
            return count($totalAppraisalProcess);
        }
    }

    public function findAppraisalProcessListMod($empCode, $currentFinancialYear) {
        //Configure::write('debug',2);
        App::import("Model", "AppraisalProcess");
        $model = new AppraisalProcess();
        $totalAppraisalProcess = $model->find('all', array(
            'fields' => array('AppraisalProcess.id'),
            'joins' => array(
                array(
                    'table' => 'competency_target',
                    'alias' => 'ct',
                    'type' => 'inner',
                    'foreignKey' => false,
                    'conditions' => array('AppraisalProcess.emp_code = ct.emp_code')
                ),
                array(
                    'table' => 'appraisal_development_plan',
                    'alias' => 'adp',
                    'type' => 'inner',
                    'foreignKey' => false,
                    'conditions' => array('AppraisalProcess.emp_code = adp.emp_code')
                )
            ),
            'conditions' => array('AppraisalProcess.status' => '1',
                'AppraisalProcess.financial_year' => $currentFinancialYear,
                'AppraisalProcess.emp_code' => $empCode,
                'adp.appraiser_areas_strength !=' => "",
                'adp.self_areas_strength !=' => "",
                'ct.reviewer_comment !=' => "",
            ),
        ));

        //echo count($totalAppraisalProcess); 

        if (count($totalAppraisalProcess) >= 1) {
            return 1;
        } else {
            return count($totalAppraisalProcess);
        }
    }

    public function findMidReviewsListEmp($empCode, $currentFinancialYear) {
        App::import("Model", "MidReviews");
        $model = new MidReviews();
        $totalMidReviews = $model->find('all', array(
            'fields' => array('MidReviews.id'),
            'conditions' => array('MidReviews.status' => '1',
                'MidReviews.financial_year' => $currentFinancialYear,
                'MidReviews.emp_code' => $empCode,
                'MidReviews.emp_review_status' => 0),
        ));
        if (count($totalMidReviews) >= 1) {
            return 1;
        } else {
            return count($totalMidReviews);
        }
    }

   public function midReviewsAllStatus($empCode, $currentFinancialYear) {
        App::import("Model", "MidReviews");
        $model = new MidReviews();
        $totalMidReviews = $model->find('all', array(
            'fields' => array('MidReviews.id'),
			 'joins' => array(
                array(
                    'table' => 'competency_status',
                    'alias' => 'ct',
                    'type' => 'LEFT',
                    'foreignKey' => false,
                    'conditions' => array('MidReviews.emp_code = ct.emp_code')
                )
            ),
            'conditions' => array('MidReviews.status' => '1',
                'MidReviews.financial_year' => $currentFinancialYear,
                'MidReviews.emp_code' => $empCode,
                'MidReviews.emp_review_status' => 1,
				'MidReviews.app_review_status' => 1,
				'MidReviews.rev_review_status' => 1,
				'MidReviews.mod_review_status' => 1,
				'ct.app_mid_status' => 1,
				'ct.rev_mid_status' => 1,
				'ct.mod_mid_status' => 1),
        ));
        if (count($totalMidReviews) >= 1) {
            return 1;
        } else {
            return count($totalMidReviews);
        }
    }

   public function annReviewsAllStatus($empCode, $currentFinancialYear) {
        App::import("Model", "AppraisalProcess");
        $model = new AppraisalProcess();
        $totalannReviews = $model->find('all', array(
            'fields' => array('AppraisalProcess.id'),
			 'joins' => array(
                array(
                    'table' => 'competency_target',
                    'alias' => 'ct',
                    'type' => 'LEFT',
                    'foreignKey' => false,
                    'conditions' => array('AppraisalProcess.emp_code = ct.emp_code')
                ),
				 array(
                    'table' => 'kra_target',
                    'alias' => 'kt',
                    'type' => 'LEFT',
                    'foreignKey' => false,
                    'conditions' => array('AppraisalProcess.emp_code = kt.emp_code')
                ),
				 array(
                    'table' => 'appraisal_development_plan',
                    'alias' => 'adp',
                    'type' => 'LEFT',
                    'foreignKey' => false,
                    'conditions' => array('AppraisalProcess.emp_code = adp.emp_code')
                ),
				 array(
                    'table' => 'kra_comp_overall_rating',
                    'alias' => 'kcor',
                    'type' => 'LEFT',
                    'foreignKey' => false,
                    'conditions' => array('AppraisalProcess.emp_code = kcor.emp_code')
                )
            ),
            'conditions' => array('AppraisalProcess.status' => '1',
                'AppraisalProcess.financial_year' => $currentFinancialYear,
                'AppraisalProcess.emp_code' => $empCode,
                'AppraisalProcess.emp_review_status' => 1,
				'AppraisalProcess.app_review_status' => 1,
				'AppraisalProcess.rev_review_status' => 1,
				'AppraisalProcess.mod_review_status' => 1,
				'ct.appraiser_rating != ""',
				'ct.reviewer_rating != ""',
				'ct.moderator_rating != ""',),
        ));
        if (count($totalMidReviews) >= 1) {
            return 1;
        } else {
            return count($totalMidReviews);
        }
    }

	
    public function findMidReviewsList($empCode, $currentFinancialYear) {

        App::import("Model", "MidReviews");
        $model = new MidReviews();
        $totalMidReviews = $model->find('all', array(
            'fields' => array('MidReviews.id'),
            'conditions' => array(
                'MidReviews.financial_year' => $currentFinancialYear,
                'MidReviews.emp_code' => $empCode,
            ),
        ));
        if (count($totalMidReviews) >= 1) {
            return 1;
        } else {
            return count($totalMidReviews);
        }
    }

    public function findAnnualList($empCode, $currentFinancialYear) {

        App::import("Model", "AppraisalProcess");
        $model = new AppraisalProcess();
        $totalAnnReviews = $model->find('all', array(
            'fields' => array('AppraisalProcess.id'),
            'conditions' => array(
                'AppraisalProcess.financial_year' => $currentFinancialYear,
                'AppraisalProcess.emp_code' => $empCode,
            ),
        ));
        if (count($totalAnnReviews) >= 1) {
            return 1;
        } else {
            return count($totalAnnReviews);
        }
    }

    public function findFInancialYearDesc($compCode) {

        if (isset($compCode)) {
            App::import("Model", "FinancialYear");
            $fy_model = new FinancialYear();
            $data = $fy_model->find('first', array('fields' => array('*'),
                'conditions' => array('org_id' => "$compCode"),
                'order' => 'id desc'));
            return $data;
        }
    }

    public function findMidReviewsDetails($empCode, $currentFinancialYear) {
        App::import("Model", "MidReviews");
        $model = new MidReviews();
        $totalMidReviews = $model->find('all', array(
            'fields' => array('MidReviews.id'),
            'conditions' => array('MidReviews.status' => '1',
                'MidReviews.financial_year' => $currentFinancialYear,
                'MidReviews.emp_code' => $empCode,
                'MidReviews.emp_review_status' => 1,
            ),
        ));
        if (count($totalMidReviews) >= 1) {
            return 1;
        } else {
            return count($totalMidReviews);
        }
    }

    public function findMidReviewsListApp($empCode, $currentFinancialYear) {
        App::import("Model", "MidReviews");
        $model = new MidReviews();
        $totalMidReviews = $model->find('all', array(
            'fields' => array('MidReviews.id'),
            'conditions' => array('MidReviews.status' => '1',
                'MidReviews.financial_year' => $currentFinancialYear,
                'MidReviews.emp_code' => $empCode,
                'MidReviews.emp_review_status' => 1),
        ));
        if (count($totalMidReviews) >= 1) {
            return 1;
        } else {
            return count($totalMidReviews);
        }
    }

    public function findMidReviewsDetailsApp($empCode, $currentFinancialYear) {
        App::import("Model", "MidReviews");
        $model = new MidReviews();
        $totalMidReviews = $model->find('all', array(
            'fields' => array('MidReviews.id'),
            'conditions' => array('MidReviews.status' => '1',
                'MidReviews.financial_year' => $currentFinancialYear,
                'MidReviews.emp_code' => $empCode,
                'MidReviews.emp_review_status' => 1,
                'MidReviews.app_review_status' => 0,
            ),
        ));
        if (count($totalMidReviews) >= 1) {
            return 1;
        } else {
            return count($totalMidReviews);
        }
    }
	
	 public function findMidsReviewsDetailsApp($empCode, $currentFinancialYear) {
        App::import("Model", "MidReviews");
        $model = new MidReviews();
        $totalMidReviews = $model->find('all', array(
            'fields' => array('MidReviews.id'),
            'conditions' => array('MidReviews.status' => '1',
                'MidReviews.financial_year' => $currentFinancialYear,
                'MidReviews.emp_code' => $empCode,
                'MidReviews.emp_review_status' => 1,
                'MidReviews.app_review_status' => 1,
            ),
        ));
        if (count($totalMidReviews) >= 1) {
            return 1;
        } else {
            return count($totalMidReviews);
        }
    }
    
    public function findCountCompetency($empCode, $currentFinancialYear) {
        App::import("Model", "CompetencyStatus");
        $model = new CompetencyStatus();
        $totalMidReviews = $model->find('all', array(
            'fields' => array('CompetencyStatus.id'),
            'conditions' => array(
                'CompetencyStatus.financial_year' => $currentFinancialYear,
                'CompetencyStatus.emp_code' => $empCode,
				'CompetencyStatus.app_mid_status' => 1
            ),
        ));
       
            return count($totalMidReviews);
       
    }
	
	public function findCountCompetencyMod($empCode, $currentFinancialYear) {
        App::import("Model", "CompetencyStatus");
        $model = new CompetencyStatus();
        $totalMidReviews = $model->find('all', array(
            'fields' => array('CompetencyStatus.id'),
            'conditions' => array(
                'CompetencyStatus.financial_year' => $currentFinancialYear,
                'CompetencyStatus.emp_code' => $empCode,
				'CompetencyStatus.app_ann_status' => 1,'CompetencyStatus.rev_ann_status' => 1,'CompetencyStatus.mod_ann_status' => 1,
            ),
        ));
       
            return count($totalMidReviews);
       
    }

    
    public function findCompMidReviewsDetailsApp($empCode, $currentFinancialYear) {
        App::import("Model", "CompetencyTarget");
        $model = new CompetencyTarget();
        $totalMidReviews = $model->find('all', array(
            'fields' => array('CompetencyTarget.id'),
			'joins' => array(
                array(
                    'table' => 'competency_status',
                    'alias' => 'cs',
                    'type' => 'LEFT',
                    'foreignKey' => false,
                    'conditions' => array('CompetencyTarget.emp_code = cs.emp_code')
                )
            ),
            'conditions' => array(
                'CompetencyTarget.financial_year' => $currentFinancialYear,
                'CompetencyTarget.emp_code' => $empCode,
                'cs.app_mid_status' => 1,
            ),
        ));
       
            return count($totalMidReviews);
       
    }
	
	public function findCompAnnReviewsDetailsApp($empCode, $currentFinancialYear) {
        App::import("Model", "CompetencyStatus");
        $model = new CompetencyStatus();
        $totalMidReviews = $model->find('all', array(
            'fields' => array('CompetencyStatus.id'),
			'conditions' => array(
                'CompetencyStatus.financial_year' => $currentFinancialYear,
                'CompetencyStatus.emp_code' => $empCode,
                'CompetencyStatus.app_ann_status' => 1,
            ),
        ));
       
            return count($totalMidReviews);
       
    }

    public function findCompMidReviewsDetailsRev($empCode, $currentFinancialYear) {
        App::import("Model", "CompetencyStatus");
        $model = new CompetencyStatus();
        $totalMidReviews = $model->find('all', array(
            'fields' => array('CompetencyStatus.id'),
            'conditions' => array(
                'CompetencyStatus.financial_year' => $currentFinancialYear,
                'CompetencyStatus.emp_code' => $empCode,
                'CompetencyStatus.app_mid_status' => 1,
                'CompetencyStatus.rev_mid_status' => 1,
            ),
        ));
       
            return count($totalMidReviews);
       
    }

    public function findCompMidReviewsDetailsMod($empCode, $currentFinancialYear) {
        App::import("Model", "CompetencyStatus");
        $model = new CompetencyStatus();
        $totalMidReviews = $model->find('all', array(
            'fields' => array('CompetencyStatus.id'),
            'conditions' => array(
                'CompetencyStatus.financial_year' => $currentFinancialYear,
                'CompetencyStatus.emp_code' => $empCode,
                'CompetencyStatus.app_mid_status' => 1,
                'CompetencyStatus.rev_mid_status' => 1,
				'CompetencyStatus.mod_mid_status' => 1,
				
            ),
        ));
       
            return count($totalMidReviews);
       
    }

    
    public function findMidReviewsDetailsAppAlert($appraiser_code, $currentFinancialYear) {
        App::import("Model", "MidReviews");
        $model = new MidReviews();
        $totalMidReviews = $model->find('all', array(
            'fields' => array('MidReviews.id'),
            'conditions' => array('MidReviews.status' => '1',
                'MidReviews.financial_year' => $currentFinancialYear,
                'MidReviews.appraiser_code' => $appraiser_code,
                'MidReviews.emp_review_status' => 1,
                'MidReviews.app_review_status' => 0,
            ),
        ));
        if (count($totalMidReviews) >= 1) {
            return 1;
        } else {
            return count($totalMidReviews);
        }
    }

    public function findMidReviewsListRev($empCode, $currentFinancialYear) {
        App::import("Model", "MidReviews");
        $model = new MidReviews();
        $totalMidReviews = $model->find('all', array(
            'fields' => array('MidReviews.id'),
			 'joins' => array(
                array(
                    'table' => 'competency_status',
                    'alias' => 'cs',
                    'type' => 'INNER',
                    'foreignKey' => false,
                    'conditions' => array('MidReviews.emp_code = cs.emp_code')
                )
            ),
            'conditions' => array('MidReviews.status' => '1',
                'MidReviews.financial_year' => $currentFinancialYear,
                'MidReviews.emp_code' => $empCode,
                'MidReviews.emp_review_status' => 1,
                'MidReviews.app_review_status' => 1,
				'cs.app_mid_status'=>1,
			),
        ));
        if (count($totalMidReviews) >= 1) {
            return 1;
        } else {
            return 0;
        }
    }

    public function findMidReviewsDetailsRevAlert($revCode, $currentFinancialYear) {
        App::import("Model", "MidReviews");
        $model = new MidReviews();
        $totalMidReviews = $model->find('all', array(
            'fields' => array('MidReviews.id'),
            'conditions' => array('MidReviews.status' => '1',
                'MidReviews.financial_year' => $currentFinancialYear,
                'MidReviews.reviewer_code' => $revCode,
                'MidReviews.emp_review_status' => 1,
                'MidReviews.app_review_status' => 1,
                'MidReviews.rev_review_status' => 0,
            ),
        ));
        if (count($totalMidReviews) >= 1) {
            return 1;
        } else {
            return count($totalMidReviews);
        }
    }

    public function findMidReviewsDetailsRev($empCode, $currentFinancialYear) {
        App::import("Model", "MidReviews");
        $model = new MidReviews();
        $totalMidReviews = $model->find('all', array(
            'fields' => array('MidReviews.id'),
            'conditions' => array('MidReviews.status' => '1',
                'MidReviews.financial_year' => $currentFinancialYear,
                'MidReviews.emp_code' => $empCode,
                'MidReviews.emp_review_status' => 1,
                'MidReviews.app_review_status' => 1,
                'MidReviews.rev_review_status' => 0,
            ),
        ));
        if (count($totalMidReviews) >= 1) {
            return 1;
        } else {
            return count($totalMidReviews);
        }
    }

    public function findMidReviewsListMod($empCode, $currentFinancialYear) {
        App::import("Model", "MidReviews");
        $model = new MidReviews();
        $totalMidReviews = $model->find('all', array(
            'fields' => array('MidReviews.id'),
			 'joins' => array(
                array(
                    'table' => 'competency_status',
                    'alias' => 'ct',
                    'type' => 'LEFT',
                    'foreignKey' => false,
                    'conditions' => array('MidReviews.emp_code = ct.emp_code')
                )
            ),
            'conditions' => array('MidReviews.status' => '1',
                'MidReviews.financial_year' => $currentFinancialYear,
                'MidReviews.emp_code' => $empCode,
                'MidReviews.emp_review_status' => 1,
                'MidReviews.app_review_status' => 1,
                'MidReviews.rev_review_status' => 1,
				'ct.app_mid_status'=>1,
				'ct.rev_mid_status'=>1),
        ));
        if (count($totalMidReviews) >= 1) {
            return 1;
        } else {
            return count($totalMidReviews);
        }
    }

    public function findMidReviewsDetailsMod($empCode, $currentFinancialYear) {
        //Configure::write('debug',2);
        App::import("Model", "MidReviews");
        $model = new MidReviews();
        $totalMidReviews = $model->find('all', array(
            'fields' => array('MidReviews.id'),
            'conditions' => array('MidReviews.status' => '1',
                'MidReviews.financial_year' => $currentFinancialYear,
                'MidReviews.emp_code' => $empCode,
                'MidReviews.emp_review_status' => 1,
                'MidReviews.app_review_status' => 1,
                'MidReviews.rev_review_status' => 1,
                'MidReviews.mod_review_status' => 0,
            ),
        ));

        if (count($totalMidReviews) >= 1) {
            return 1;
        } else {
            return count($totalMidReviews);
        }
    }

	public function findAnnReviewsDetailsMod($empCode, $currentFinancialYear) {
        //Configure::write('debug',2);
        App::import("Model", "AppraisalProcess");
        $model = new AppraisalProcess();
        $totalAnnReviews = $model->find('all', array(
            'fields' => array('AppraisalProcess.id'),
            'conditions' => array('AppraisalProcess.status' => '1',
                'AppraisalProcess.financial_year' => $currentFinancialYear,
                'AppraisalProcess.emp_code' => $empCode,
                'AppraisalProcess.emp_review_status' => 1,
                'AppraisalProcess.app_review_status' => 1,
                'AppraisalProcess.rev_review_status' => 1,
                'AppraisalProcess.mod_review_status' => 0,
            ),
        ));

        if (count($totalAnnReviews) >= 1) {
            return 1;
        } else {
            return count($totalAnnReviews);
        }
    }

	public function findAnnReviewsDetailsRev($empCode, $currentFinancialYear) {
        //Configure::write('debug',2);
        App::import("Model", "AppraisalProcess");
        $model = new AppraisalProcess();
        $totalAnnReviews = $model->find('all', array(
            'fields' => array('AppraisalProcess.id'),
            'conditions' => array('AppraisalProcess.status' => '1',
                'AppraisalProcess.financial_year' => $currentFinancialYear,
                'AppraisalProcess.emp_code' => $empCode,
                'AppraisalProcess.emp_review_status' => 1,
                'AppraisalProcess.app_review_status' => 1,
                'AppraisalProcess.rev_review_status' => 0,
                //'AppraisalProcess.mod_review_status' => 0,
            ),
        ));

        if (count($totalAnnReviews) >= 1) {
            return 1;
        } else {
            return count($totalAnnReviews);
        }
    }

	public function findAnnReviewsDetailsApp($empCode, $currentFinancialYear) {
        //Configure::write('debug',2);
        App::import("Model", "AppraisalProcess");
        $model = new AppraisalProcess();
        $totalAnnReviews = $model->find('all', array(
            'fields' => array('AppraisalProcess.id'),
            'conditions' => array('AppraisalProcess.status' => '1',
                'AppraisalProcess.financial_year' => $currentFinancialYear,
                'AppraisalProcess.emp_code' => $empCode,
                'AppraisalProcess.emp_review_status' => 1,
                'AppraisalProcess.app_review_status' => 0,
				
            ),
        ));

        if (count($totalAnnReviews) >= 1) {
            return 1;
        } else {
            return 0;
        }
    }
	


	public function findAnnReviewsDetailsEmp($empCode, $currentFinancialYear) {
        //Configure::write('debug',2);
        App::import("Model", "AppraisalProcess");
        $model = new AppraisalProcess();
        $totalAnnReviews = $model->find('all', array(
            'fields' => array('AppraisalProcess.id'),
            'conditions' => array('AppraisalProcess.status' => '1',
                'AppraisalProcess.financial_year' => $currentFinancialYear,
                'AppraisalProcess.emp_code' => $empCode,
                'AppraisalProcess.emp_review_status' => 0,
                'AppraisalProcess.app_review_status' => 0,
				'AppraisalProcess.rev_review_status' => 0,
                'AppraisalProcess.mod_review_status' => 0,
            ),
        ));

        if (count($totalAnnReviews) >= 1) {
            return 1;
        } else {
            return count($totalAnnReviews);
        }
    }

	public function findAnnReviewsDetails($empCode, $currentFinancialYear) {
        //Configure::write('debug',2);
        App::import("Model", "AppraisalProcess");
        $model = new AppraisalProcess();
        $totalAnnReviews = $model->find('all', array(
            'fields' => array('AppraisalProcess.id'),
            'conditions' => array('AppraisalProcess.status' => '1',
                'AppraisalProcess.financial_year' => $currentFinancialYear,
                'AppraisalProcess.emp_code' => $empCode,
                'AppraisalProcess.emp_review_status' => 1,
                'AppraisalProcess.app_review_status' => 1,
				'AppraisalProcess.rev_review_status' => 1,
                'AppraisalProcess.mod_review_status' => 1,
            ),
        ));

        if (count($totalAnnReviews) >= 1) {
            return 1;
        } else {
            return count($totalAnnReviews);
        }
    }

		public function findAnnReviewsDetailsTabMod($empCode, $currentFinancialYear) {
        //Configure::write('debug',2);
        App::import("Model", "AppraisalProcess");
        $model = new AppraisalProcess();
        $totalAnnReviews = $model->find('all', array(
            'fields' => array('AppraisalProcess.id'),
            'conditions' => array('AppraisalProcess.status' => '1',
                'AppraisalProcess.financial_year' => $currentFinancialYear,
                'AppraisalProcess.emp_code' => $empCode,
                'AppraisalProcess.emp_review_status' => 1,
                'AppraisalProcess.app_review_status' => 1,
                'AppraisalProcess.rev_review_status' => 1,
               // 'AppraisalProcess.mod_review_status' => 0,
            ),
        ));

        if (count($totalAnnReviews) >= 1) {
            return 1;
        } else {
            return count($totalAnnReviews);
        }
    }

	public function findAnnReviewsDetailsTabRev($empCode, $currentFinancialYear) {
        //Configure::write('debug',2);
        App::import("Model", "AppraisalProcess");
        $model = new AppraisalProcess();
        $totalAnnReviews = $model->find('all', array(
            'fields' => array('AppraisalProcess.id'),
            'conditions' => array('AppraisalProcess.status' => '1',
                'AppraisalProcess.financial_year' => $currentFinancialYear,
                'AppraisalProcess.emp_code' => $empCode,
                'AppraisalProcess.emp_review_status' => 1,
                'AppraisalProcess.app_review_status' => 1,
               // 'AppraisalProcess.rev_review_status' => 0,
                //'AppraisalProcess.mod_review_status' => 0,
            ),
        ));

        if (count($totalAnnReviews) >= 1) {
            return 1;
        } else {
            return count($totalAnnReviews);
        }
    }

	public function findAnnReviewsDetailsTabApp($empCode, $currentFinancialYear) {
        //Configure::write('debug',2);
        App::import("Model", "AppraisalProcess");
        $model = new AppraisalProcess();
        $totalAnnReviews = $model->find('all', array(
            'fields' => array('AppraisalProcess.id'),
            'conditions' => array('AppraisalProcess.status' => '1',
                'AppraisalProcess.financial_year' => $currentFinancialYear,
                'AppraisalProcess.emp_code' => $empCode,
                'AppraisalProcess.emp_review_status' => 1,
                //'AppraisalProcess.app_review_status' => 0,
				
            ),
        ));

        if (count($totalAnnReviews) >= 1) {
            return 1;
        } else {
            return count($totalAnnReviews);
        }
    }

	
    public function findMidReviewsDetailsModAlert($modCode, $currentFinancialYear) {
        //Configure::write('debug',2);
        App::import("Model", "MidReviews");
        $model = new MidReviews();
        $totalMidReviews = $model->find('all', array(
            'fields' => array('MidReviews.id'),
            'conditions' => array('MidReviews.status' => '1',
                'MidReviews.financial_year' => $currentFinancialYear,
                'MidReviews.moderator_code' => $modCode,
                'MidReviews.emp_review_status' => 1,
                'MidReviews.app_review_status' => 1,
                'MidReviews.rev_review_status' => 1,
                'MidReviews.mod_review_status' => 0,
            ),
        ));

        if (count($totalMidReviews) >= 1) {
            return 1;
        } else {
            return count($totalMidReviews);
        }
    }

    public function findAssignCompetencyDeptDesgList($deptCode, $desgCode, $empCode, $currentFinancialYear) {
        App::import("Model", "AssignCompetencyDeptDesg");
        $model = new AssignCompetencyDeptDesg();

        $totalAssignCompetencyDeptDesg = $model->find('list', array(
            'joins' => array(
                array(
                    'table' => 'competency',
                    'alias' => 'Competency',
                    'type' => 'inner',
                    'foreignKey' => false,
                    'conditions' => array('AssignCompetencyDeptDesg.competency_id = Competency.id')
                )
            ),
            'fields' => array('AssignCompetencyDeptDesg.competency_id', 'Competency.competency_name'),
            'conditions' => array('AssignCompetencyDeptDesg.financial_year' => $currentFinancialYear,
                'AssignCompetencyDeptDesg.dept_id' => "$deptCode",
                'AssignCompetencyDeptDesg.desg_id' => "$desgCode",
                'AssignCompetencyDeptDesg.emp_id' => $empCode)
        ));

        return $totalAssignCompetencyDeptDesg;
    }

    public function findAssignGroupToEmpList($desgCode, $empCode, $currentFinancialYear) {
        App::import("Model", "AssignGroupToDesg");
        $model = new AssignGroupToDesg();

        $totalAssignGroupToDesg = $model->find('list', array(
            'joins' => array(
                array(
                    'table' => 'assign_group_to_desg_details',
                    'alias' => 'AssignGroupToDesgDetails',
                    'type' => 'inner',
                    'foreignKey' => false,
                    'conditions' => array('AssignGroupToDesgDetails.assign_group_to_desg_id = AssignGroupToDesg.id')
                )
            ),
            'fields' => array('AssignGroupToDesg.group_comp_id', 'AssignGroupToDesgDetails.desg_id'),
            'conditions' => array('AssignGroupToDesg.financial_year' => $currentFinancialYear,
                'AssignGroupToDesgDetails.desg_id' => "$desgCode")
        ));


        $out = array();
        foreach ($totalAssignGroupToDesg as $key => $value) {
            array_push($out, "$key");
        }
        $allGroupIds = implode(', ', $out);

        //echo count($allGroupIds);
        if (count($allGroupIds) >= 1) {
            return $allGroupIds;
        } else {
            return false;
        }
    }

    public function findGroupCompetencyDeptDesgList($GroupIds) {
        App::import("Model", "GroupCompetency");
        $model = new GroupCompetency();

        if ($GroupIds != "") {
            $allGroupIds = $GroupIds;
        } else {
            $allGroupIds = '0';
        }

        $totalCompetency = $model->find('list', array(
            'joins' => array(
                array(
                    'table' => 'competency',
                    'alias' => 'Competency',
                    'type' => 'inner',
                    'foreignKey' => false,
                    'conditions' => array('GroupCompetency.competency_id = Competency.id')
                )
            ),
            'fields' => array('GroupCompetency.competency_id', 'Competency.competency_name'),
            'conditions' => array("GroupCompetency.group_id IN ($allGroupIds)"),
            'group' => array("competency_id")
        ));

        return $totalCompetency;
    }

     public function getCompMidAppraiserReview($empCode,$compID, $currentFinancialYear) {
        App::import("Model", 'CompetencyTarget');
        $model = new CompetencyTarget();
        $CompetencyId = $model->find('first', array(
            'fields' => array('CompetencyTarget.appraiser_mid_rating_comment'),
            'conditions' => array('CompetencyTarget.competency_id' => $compID, 'CompetencyTarget.financial_year' => $currentFinancialYear, 'CompetencyTarget.emp_code' => $empCode),
        ));
        return $CompetencyId['CompetencyTarget']['appraiser_mid_rating_comment'];
    }
	
	public function getCompAnnAppraiserReview($empCode,$compcode,$compID, $currentFinancialYear) {
        App::import("Model", 'CompetencyTarget');
        $model = new CompetencyTarget();
        $CompetencyId = $model->find('first', array(
            'fields' => array('CompetencyTarget.appraiser_rating','CompetencyTarget.appraiser_comment'),
            'conditions' => array('CompetencyTarget.competency_id' => $compID,'CompetencyTarget.comp_code' => $compcode,'CompetencyTarget.financial_year' => $currentFinancialYear, 'CompetencyTarget.emp_code' => $empCode),
        ));
        return $CompetencyId;
    }
    
	public function getCompAnnReviewerReview($empCode, $currentFinancialYear) {
        App::import("Model", 'CompetencyTarget');
        $model = new CompetencyTarget();
        $CompetencyId = $model->find('all', array(
            'fields' => array('CompetencyTarget.reviewer_rating','CompetencyTarget.reviewer_comment'),
            'conditions' => array('CompetencyTarget.financial_year' => $currentFinancialYear, 'CompetencyTarget.emp_code' => $empCode),
        ));
        return $CompetencyId;
    }
     public function getCompReviewerReview($empCode,$compID, $currentFinancialYear) {
         //Configure::write("debug",2);
        App::import("Model", 'CompetencyTarget');
        $model = new CompetencyTarget();
        $CompetencyId = $model->find('first', array(
            'fields' => array('CompetencyTarget.reviewer_mid_rating_comment'),
            'conditions' => array('CompetencyTarget.id' => $compID, 'CompetencyTarget.financial_year' => $currentFinancialYear,'CompetencyTarget.emp_code' => $empCode,'CompetencyTarget.appraiser_mid_rating_comment !=' => ''),
        ));
        return $CompetencyId['CompetencyTarget']['reviewer_mid_rating_comment'];
    }
    
     public function getCompModeratorReview($empCode,$compID, $currentFinancialYear) {
         //Configure::write("debug",2);
        App::import("Model", 'CompetencyTarget');
        $model = new CompetencyTarget();
        $CompetencyId = $model->find('first', array(
            'fields' => array('CompetencyTarget.moderator_mid_rating_comment'),
            'conditions' => array('CompetencyTarget.id' => $compID, 'CompetencyTarget.financial_year' => $currentFinancialYear,'CompetencyTarget.emp_code' => $empCode,'CompetencyTarget.appraiser_mid_rating_comment !=' => '','CompetencyTarget.moderator_mid_rating_comment !=' => ''),
        ));
        return $CompetencyId['CompetencyTarget']['moderator_mid_rating_comment'];
    }
    
    
    public function findCompetencyIDByName($competencyName) {
        App::import("Model", 'Competency');
        $model = new Competency();
        $CompetencyId = $model->find('first', array(
            'fields' => array('Competency.id'),
            'conditions' => array('Competency.competency_name' => $competencyName)
        ));
        return $CompetencyId['Competency']['id'];
    }

    public function findCompetencyNameByID($competencyID) {
        App::import("Model", 'Competency');
        $model = new Competency();
        $CompetencyId = $model->find('first', array(
            'fields' => array('Competency.competency_name'),
            'conditions' => array('Competency.id' => $competencyID)
        ));
        return $CompetencyId['Competency']['competency_name'];
    }

	public function findCompetencyDescByID($competencyID) {
        App::import("Model", 'Competency');
        $model = new Competency();
        $CompetencyId = $model->find('first', array(
            'fields' => array('Competency.description'),
            'conditions' => array('Competency.id' => $competencyID)
        ));
        return $CompetencyId['Competency']['description'];
    }
	
    public function getCompetencyTargetDetails($empCode, $financialYear) {
        App::import("Model", "CompetencyTarget");
        $model = new CompetencyTarget();

        $list = $model->find('all', array(
            'fields' => array('*'),
            'conditions' => array('emp_code' => "$empCode",
                "CompetencyTarget.appraiser_rating != '0.00'",
                "CompetencyTarget.reviewer_rating != '0.00'",
				"CompetencyTarget.moderator_rating" => '0.00',
                'CompetencyTarget.financial_year' => "$financialYear")
        ));
        return $list;
    }

	
	public function getCompetencyTargetDetailsRevComp($empCode, $financialYear) {
        App::import("Model", "CompetencyTarget");
        $model = new CompetencyTarget();

        $list = $model->find('all', array(
            'fields' => array('*'),
            'conditions' => array('emp_code' => "$empCode",
                "CompetencyTarget.appraiser_rating != '0.00'",
                "CompetencyTarget.reviewer_rating != '0.00'",
				//"CompetencyTarget.moderator_rating" => '0.00',
                'CompetencyTarget.financial_year' => "$financialYear")
        ));
        return $list;
    }

   public function getCompetencyTargetDetailsRev($empCode, $financialYear) {
        App::import("Model", "CompetencyStatus");
        $model = new CompetencyStatus();

       $list = $model->find('all', array(
            'fields' => array('*'),
            'conditions' => array('emp_code' => "$empCode",
                "CompetencyStatus.app_ann_status" => 1,
                "CompetencyStatus.rev_ann_status" => 1,
                'CompetencyStatus.financial_year' => "$financialYear")
        ));
        return $list;
    }

	public function getCompetencyTargetDetailsApp($empCode, $financialYear) {
        App::import("Model", "CompetencyStatus");
        $model = new CompetencyStatus();

       $list = $model->find('all', array(
            'fields' => array('*'),
            'conditions' => array('emp_code' => "$empCode",
                "CompetencyStatus.app_ann_status" => 1,
                'CompetencyStatus.financial_year' => "$financialYear")
        ));
        return $list;
    }
	
	public function getMidCompetencyTargetDetailsApp($empCode, $financialYear) {
        App::import("Model", "CompetencyStatus");
        $model = new CompetencyStatus();

       $list = $model->find('all', array(
            'fields' => array('*'),
            'conditions' => array('emp_code' => "$empCode",
                "CompetencyStatus.app_mid_status" => 1,
                'CompetencyStatus.financial_year' => "$financialYear")
        ));
        return $list;
    }
	
	

	public function getADPTargetDetailsApp($empCode, $financialYear) {
        App::import("Model", "AppraisalDevelopmentPlan");
        $model = new AppraisalDevelopmentPlan();

        $list = $model->find('all', array(
            'fields' => array('*'),
            'conditions' => array('emp_code' => "$empCode",
                "app_review_status" => 1,
                'financial_year' => "$financialYear")
        ));
        return $list;
    }


	public function getCompetencyTargetDetailsEmp($empCode, $financialYear) {
        App::import("Model", "CompetencyTarget");
        $model = new CompetencyTarget();

        $list = $model->find('all', array(
            'fields' => array('*'),
            'conditions' => array('emp_code' => "$empCode",
                "CompetencyTarget.appraiser_rating != '0.00'",
                "CompetencyTarget.reviewer_rating != '0.00'",
                "CompetencyTarget.moderator_rating != '0.00'",
                'CompetencyTarget.financial_year' => "$financialYear")
        ));
        return $list;
    }

    public function getCompetencyTargetLevelOne($empCode, $financialYear) {
        App::import("Model", "CompetencyTarget");
        $model = new CompetencyTarget();

        $list = $model->find('all', array(
            'fields' => array('*'),
            'conditions' => array('emp_code' => "$empCode",
                "CompetencyTarget.appraiser_rating != ''",
                'CompetencyTarget.financial_year' => "$financialYear")
        ));
        return $list;
    }

    public function getCompetencyTarget($empCode, $financialYear) {
        App::import("Model", "CompetencyTarget");
        $model = new CompetencyTarget();

        $list = $model->find('all', array(
            'fields' => array('*'),
            'conditions' => array('emp_code' => "$empCode",
                "CompetencyTarget.appraiser_rating != 0",
                "CompetencyTarget.reviewer_rating != 0",
                "CompetencyTarget.moderator_rating != 0",
                'CompetencyTarget.financial_year' => "$financialYear")
        ));
        return $list;
    }

    public function getTotalAssignCompetencyList($empCode, $financialYear) {
        App::import("Model", "CompetencyTarget");
        $model = new CompetencyTarget();

        $list = $model->find('all', array(
            'fields' => array('*'),
            'conditions' => array('emp_code' => "$empCode", 'CompetencyTarget.financial_year' => "$financialYear")
        ));
        return $list;
    }

    public function getTotalCompAppraiserCompetencyList($empCode, $appraiserId, $financialYear) {
        App::import("Model", "CompetencyTarget");
        $model = new CompetencyTarget();

        $list = $model->find('all', array(
            'fields' => array('*'),
            'conditions' => array('emp_code' => "$empCode",
                'appraiser_id' => "$appraiserId",  'appraiser_rating != ""', 'appraiser_comment != ""',
                'CompetencyTarget.financial_year' => "$financialYear")
        ));
        return $list;
    }

	public function getCompAnnualStatus($empCode, $reviewerId, $financialYear) {
        App::import("Model", "CompetencyStatus");
        $model = new CompetencyStatus();

        $list = $model->find('all', array(
            'fields' => array('*'),
            'conditions' => array('emp_code' => "$empCode", 'rev_ann_status'=> 1,
                'CompetencyStatus.financial_year' => "$financialYear")
        ));
        return $list;
    }
	
	public function getCompAnnualStatusMod($empCode,$financialYear) {
        App::import("Model", "CompetencyStatus");
        $model = new CompetencyStatus();

        $list = $model->find('all', array(
            'fields' => array('*'),
            'conditions' => array('emp_code' => "$empCode", 'mod_ann_status'=> 1,
                'CompetencyStatus.financial_year' => "$financialYear")
        ));
        return $list;
    }
	
	public function overAllAnnualStatus($empCode,$financialYear) {
        App::import("Model", "AppraisalProcess");
        $model = new AppraisalProcess();

        $list = $model->find('all', array(
            'fields' => array('*'),
			'joins' => array(
                array(
                    'table' => 'competency_status',
                    'alias' => 'cs',
                    'type' => 'inner',
                    'foreignKey' => false,
                    'conditions' => array('cs.emp_code = AppraisalProcess.emp_code')
                ),
				array(
                    'table' => 'appraisal_development_plan',
                    'alias' => 'adp',
                    'type' => 'inner',
                    'foreignKey' => false,
                    'conditions' => array('adp.emp_code = AppraisalProcess.emp_code')
                ),
            ),
            'conditions' => array('AppraisalProcess.emp_code' => "$empCode",'AppraisalProcess.financial_year' => "$financialYear",'cs.financial_year' => "$financialYear",'adp.financial_year' => "$financialYear",'adp.emp_review_status' => 1,'adp.app_review_status' =>1,'adp.mod_review_status' =>1,'AppraisalProcess.emp_review_status' => 1,'AppraisalProcess.app_review_status' => 1,'AppraisalProcess.rev_review_status' => 1,'AppraisalProcess.mod_review_status' => 1,'cs.mod_ann_status' => 1,'cs.rev_ann_status' => 1,'cs.app_ann_status' => 1)
        ));
        return $list;
    }
	
	public function overAllMidStatus($empCode,$financialYear) {
        App::import("Model", "MidReviews");
        $model = new MidReviews();

        $list = $model->find('all', array(
            'fields' => array('*'),
			'joins' => array(
                array(
                    'table' => 'competency_status',
                    'alias' => 'cs',
                    'type' => 'inner',
                    'foreignKey' => false,
                    'conditions' => array('cs.emp_code = MidReviews.emp_code')
                ),
				
            ),
            'conditions' => array('MidReviews.emp_code' => "$empCode",'MidReviews.financial_year' => "$financialYear",'cs.financial_year' => "$financialYear",'MidReviews.emp_review_status' => 1,'MidReviews.app_review_status' => 1,'MidReviews.rev_review_status' => 1,'MidReviews.mod_review_status' => 1,'cs.mod_mid_status' => 1,'cs.rev_mid_status' => 1,'cs.app_mid_status' => 1)
        ));
        return $list;
    }
	
	 public function getCompApp($empCode, $financialYear) {
        App::import("Model", "CompetencyStatus");
        $model = new CompetencyStatus();

        $list = $model->find('all', array(
            'fields' => array('*'),
            'conditions' => array('emp_code' => "$empCode",
                'CompetencyStatus.financial_year' => "$financialYear",
				'CompetencyStatus.app_ann_status' => 1,
				'CompetencyStatus.rev_ann_status' => null,
				)
        ));
        return $list;
    }

    public function getTotalCompReviewerCompetencyList($empCode, $reviewerId, $financialYear) {
        App::import("Model", "CompetencyTarget");
        $model = new CompetencyTarget();

        $list = $model->find('all', array(
            'fields' => array('*'),
            'conditions' => array('emp_code' => "$empCode",
                'reviewer_id' => "$reviewerId", 'reviewer_rating != ""', 'reviewer_comment != ""',
                'CompetencyTarget.financial_year' => "$financialYear")
        ));
        return $list;
    }

    public function getTotalCompModeratorCompetencyList($empCode, $moderatorId, $financialYear) {
        App::import("Model", "CompetencyTarget");
        $model = new CompetencyTarget();

        $list = $model->find('all', array(
            'fields' => array('*'),
			 'joins' => array(
                array(
                    'table' => 'competency_status',
                    'alias' => 'cs',
                    'type' => 'inner',
                    'foreignKey' => false,
                    'conditions' => array('cs.emp_code = CompetencyTarget.emp_code')
                )
            ),
            'conditions' => array('CompetencyTarget.emp_code' => "$empCode",
                'CompetencyTarget.moderator_id' => "$moderatorId", 'cs.mod_ann_status'=>1,
                'CompetencyTarget.financial_year' => "$financialYear")
        ));
        return $list;
    }

    function truncate_number($number, $precision = 2) {
        // Zero causes issues, and no need to truncate
        if (0 == (int) $number) {
            return $number;
        }
        // Are we negative?
        $negative = $number / abs($number);
        // Cast the number to a positive to solve rounding
        $number = abs($number);
        // Calculate precision number for dividing / multiplying
        $precision = pow(10, $precision);
        // Run the math, re-applying the negative value to ensure returns correctly negative / positive
        return floor($number * $precision) / $precision * $negative;
    }

    function getreqnum()
    {
        App::import("Model", "RequirementDetail");
        $model = new RequirementDetail();

        $req_id=$model->find('first',array(
            'fields'=>'RequirementDetail.id',
            'order'=>'RequirementDetail.id desc'));
if(empty($req_id))
{
    return 1;
}
else

{
    
            return $req_id['RequirementDetail']['id']+1;
}    
}

    public function OpenDevpPlanForAppraiser($empCode, $financialYear) {
        App::import("Model", "AppraisalDevelopmentPlan");
        $model = new AppraisalDevelopmentPlan();

        $list = $model->find('all', array(
            'fields' => array('*'),
            'conditions' => array('emp_code' => "$empCode",
                "AppraisalDevelopmentPlan.self_areas_strength != ''",
                'AppraisalDevelopmentPlan.financial_year' => "$financialYear")
        ));
        return $list;
    }

    public function OpenDevpPlanForReviewer($empCode, $financialYear) {
        App::import("Model", "AppraisalDevelopmentPlan");
        $model = new AppraisalDevelopmentPlan();

        $list = $model->find('all', array(
            'fields' => array('*'),
            'conditions' => array('emp_code' => "$empCode",
                "AppraisalDevelopmentPlan.appraiser_areas_strength != ''",
                'AppraisalDevelopmentPlan.financial_year' => "$financialYear")
        ));
        return $list;
    }

    public function openSummaryDiscussion($empCode, $financialYear) {
        App::import("Model", "AppraisalDevelopmentPlan");
        $model = new AppraisalDevelopmentPlan();

        $list = $model->find('all', array(
            'fields' => array('*'),
            'conditions' => array('emp_code' => "$empCode",
                "AppraisalDevelopmentPlan.emp_review_status" => 1,
                "AppraisalDevelopmentPlan.app_review_status" => 1,
                'AppraisalDevelopmentPlan.financial_year' => "$financialYear")
        ));
        return $list;
    }

    public function ratingList() {
        $options = array(
            '' => ' - Select Rating - ',
            '1' => '1',
            '2' => '2',
            '3' => '3',
            '4' => '4',
            '5' => '5'
        );

        return $options;
    }

    public function achievementList() {
        $options = array(
            '' => ' - Select Achievement - ',
            '0' => '0',
            //'80' => '80',
            '100' => '100',
            '120' => '120'
        );

        return $options;
    }

    public function findCompetencyBehvList($id) {
        App::import("Model", "CompetencyBehaviour");
        $model = new CompetencyBehaviour();
        $query = $model->find('all', array(
            'conditions' => array('CompetencyBehaviour.status' => 1, 'CompetencyBehaviour.compitency_id in' => $id),
        ));

        if (!empty($query)) {
            return $query;
        } else {
            return 0;
        }
    }

    public function findAllDesignationInMyProfile() {
        Configure::write('debug', 2);
        //function to find all Designation Code     
        App::import("Model", "MyProfile");
        $model = new MyProfile();
        $values = $model->find('list', array(
            'fields' => array('desg_code', 'desg_code'),
			'joins' => array(
                array(
                    'table' => 'option_attribute',
                    'alias' => 'option_attribute',
                    'type' => 'LEFT',
                    'foreignKey' => false,
                    'conditions' => array('option_attribute.id = MyProfile.desg_code')
                )
            ),
            'group' => 'desg_code',
			'order' => 'name',
			
        ));
        if (!empty($values))
            return $values;
        else
            return '';
    }
	
    public function findAllDesignationInMyProfileandMgmtGrp() {
        Configure::write('debug', 2);
        //function to find all Designation Code and in mgmt grp
        App::import("Model", "MyProfile");
        App::import("Model", "MgtGroupDesg");
        $model = new MyProfile();
        $values = $model->find('list', array(
            'fields' => array('desg_code', 'desg_code'),
            'joins' => array(
                array(
                    'table' => 'mgt_group_desg',
                    'alias' => 'MgtGroupDesg',
                    'type' => 'INNER',
                    'foreignKey' => false,
                    'conditions' =>
                    array(
                        'MyProfile.desg_code = MgtGroupDesg.desg_code'
                    )
                )
            ),
            'group' => 'MyProfile.desg_code'
                )
        );

        if (!empty($values))
            return $values;
        else
            return '';
    }

    public function getKraCommentByID($empCode, $financialYear) {
        App::import("Model", "KraTarget");
        $model = new KraTarget();
        $list = $model->find('all', array(
            'fields' => array('KraTarget.appraiser_status_comment', 'KraTarget.emp_status_comment'),
            'conditions' => array('KraTarget.emp_code' => $empCode, 'KraTarget.financial_year' => $financialYear)
        ));
        return $list;
    }

    public function developmentPlanTab($empCode, $financialYear) {
        App::import("Model", "KraTarget");
        $model = new KraTarget();

        $totalRecord = $model->find('list', array(
            'fields' => array('KraTarget.id'),
            'conditions' => array("KraTarget.emp_code" => $empCode,
                "KraTarget.self_score_actual != ''", "KraTarget.self_score_achiev != ''",
                "KraTarget.appraiser_score_achiev != ''", "KraTarget.appraiser_status" => array('5'),
                "KraTarget.financial_year" => $financialYear)
        ));
        return count($totalRecord);
    }

    public function getKraCompOverallRating($empCode, $fincialYear) {
        App::import("Model", "KraCompOverallRating");
        $model = new KraCompOverallRating();
        $list = $model->find('all', array(
            'fields' => array('*'),
            'conditions' => array('KraCompOverallRating.emp_code' => $empCode, 'KraCompOverallRating.financial_year' => $fincialYear)
        ));

        //echo "<pre>";print_r($list);die;
        return $list;
    }
    
    public function getModCompOverallActual($empCode, $fincialYear) {
        App::import("Model", "CompetencyTarget");
        $model = new CompetencyTarget();
        $list = $model->find('first', array(
            'fields' => array('SUM(`moderator_rating`) as comp_sum_mod'),
            'conditions' => array('CompetencyTarget.emp_code' => $empCode, 'CompetencyTarget.financial_year' => $fincialYear)
        ));

        //echo "<pre>";print_r($list);die;
        return $list;
    }

    public function saveKraCompetencyOverallRatingAndResult($empCode, $financialYear, $kraCompetencyOverallRating, $kraCompetencyOverallResult) {
        App::import("Model", "KraCompOverallRating");
        $kraCompOverallRating = new KraCompOverallRating();

        $q = "UPDATE `kra_comp_overall_rating` SET kra_comp_overall_rating = $kraCompetencyOverallRating, kra_comp_overall_result = '$kraCompetencyOverallResult' WHERE emp_code = $empCode AND financial_year = $financialYear";
        $db = ConnectionManager::getDataSource('default');
        $myData = $db->query($q);
    }

    public function bankId_tets($id) {
        $bank = new Model(array('table' => 'oracle_app_eo', 'ds' => 'default', 'name' => 'BANK_DETAILS'));
        $val = $bank->find('first', array('fields' => array('eo_id'), 'conditions' => array('eo_id' => $id)));
        if (!empty($val)) {
            return $val['BANK_DETAILS']['eo_id'];
            ;
        } else {
            return 'N/A';
        }
    }

    public function checkImport($function_name) {
        $value = 1;
        $import_log = new Model(array('table' => 'import_log', 'ds' => 'default', 'name' => 'IMPORT_LOG'));
        $val = $import_log->find('first', array('conditions' => array('function_name' => $function_name)));
        if (!empty($val)) {
            return $val['IMPORT_LOG']['status'];
        } else {
            return 0;
        }
    }

    public function impDate($function_name) {
        $import_log = new Model(array('table' => 'import_log', 'ds' => 'default', 'name' => 'IMPORT_LOG'));
        $val = $import_log->find('first', array('conditions' => array('function_name' => $function_name)));
        if (!empty($val)) {
            return $val['IMPORT_LOG']['last_run'];
        } else {
            return 'N/A';
        }
    }

    public function bankList_branch($id) {
        $bank = new Model(array('table' => 'oracle_app_eo', 'ds' => 'default', 'name' => 'BANK_DETAILS'));
        $val = $bank->find('list', array('fields' => array('eo_id', 'eo_nm'), 'conditions' => array('eo_type' => 74, 'eo_mst_id' => $id)));
        if (!empty($val)) {
            return $val;
        } else {
            return 'N/A';
        }
    }

    public function bankList() {
        //Configure::write('debug',2);
        $bank = new Model(array('table' => 'oracle_app_eo', 'ds' => 'default', 'name' => 'BANK_DETAILS'));
        $bank_mst = new Model(array('table' => 'app_eo_mst', 'ds' => 'default', 'name' => 'BANK'));

        $val = $bank->query('SELECT eo_mst_id from oracle_app_eo where eo_type = 74');
        //print_r($val); die;
        if (!empty($val)) {
            foreach ($val as $v) {
                $k[] = $v['oracle_app_eo']['eo_mst_id'];
            }
            $bak_list = $bank_mst->find('list', array('fields' => array('eo_mst_id', 'eo_mst_nm'), 'conditions' => array('eo_mst_id in' => $k)));
            // print_r($bak_list); die;
            if (!empty($bak_list)) {
                return $bak_list;
            } else {
                return 'N/A';
            }
        } else {
            return 'N/A';
        }
    }

    public function getOverAllRatingList() {
        App::import("Model", "Rating");
        $model = new Rating();
        $list = $model->find('all', array(
            'fields' => array('*'),
            'order' => "id ASC"
        ));

        //echo "<pre>";print_r($list);die;
        return $list;
    }

    public function findGroupDesg($desgCode) {
        App::import("Model", "MgtGroupDesg");
        $model = new MgtGroupDesg();
        $list = $model->find('first', array(
            'fields' => array('mgt_group'),
            'conditions' => array('MgtGroupDesg.desg_code' => $desgCode)
        ));
        return $list['MgtGroupDesg']['mgt_group'];
    }

    public function getmgtname($mgcode) {
        App::import("Model", "HcmGroupMaster");
        $model = new HcmGroupMaster();
        $list = $model->find('first', array(
            'fields' => array('HcmGroupMaster.group_name'),
            'conditions' => array('HcmGroupMaster.id' => $mgcode)
        ));

        return $list['HcmGroupMaster']['group_name'];
    }

    public function findAllGroupDesg() {
        App::import("Model", "MgtGroupDesg");
        $model = new MgtGroupDesg();
        $list = $model->find('all', array(
            'fields' => array('*'),
                //'conditions' => array('MgtGroupDesg.desg_code' => $desgCode)
        ));
        return $list;
    }

    public function findGroupWeightage($groupId) {
        App::import("Model", "GroupWeightage");
        $model = new GroupWeightage();
        $list = $model->find('first', array(
            'fields' => array('kra_weightage', 'comp_weightage'),
            'conditions' => array('GroupWeightage.group_master_id' => $groupId)
        ));
        return $list;
    }

    public function findTrainingDevelopmentList($devPlanId, $empCode, $financialYear) {
        App::import("Model", "TrainingDevelopment");
        $model = new TrainingDevelopment();
        $list = $model->find('all', array(
            'fields' => array('id', 'identified_areas_for_development', 'observed_behavior', 'suggested_action_plan', 'timelines', 'responsibility'),
            'conditions' => array('TrainingDevelopment.dev_plan_id' => $devPlanId,
                'TrainingDevelopment.emp_code' => $empCode, 'TrainingDevelopment.financial_year' => $financialYear)
        ));
        return $list;
    }

    public function getKraTargetOpenStatusForAppraiser($appraiserId, $financialYear) {
        App::import("Model", "KraTarget");
        $model = new KraTarget();
        $empList = $model->find('all', array(
            'fields' => array('KraTarget.id', 'KraTarget.emp_code', 'KraTarget.financial_year'),
			'joins' => array(
								array(
									'table' => 'kra_approval_status',
									'alias' => 'kas',
									'type' => 'inner',
									'foreignKey' => false,
									'conditions' => array('kas.emp_code = KraTarget.emp_code')
								)
							),
            'conditions' => array('KraTarget.financial_year' => "$financialYear",'KraTarget.appraiser_id' => "$appraiserId","KraTarget.emp_status = '2'","kas.emp_status = '1'","kas.app_status = '0'"),
            'group' => array('KraTarget.emp_code')
        ));
        return count($empList);
    }

    public function getKraTargetEmpSelfScoreForAppraiser($appraiserId, $financialYear) {
        App::import("Model", "KraTarget");
        //Configure::write('debug',2);
        $model = new KraTarget();

        $selfScore = $model->find('all', array(
            'fields' => array('KraTarget.id'),
            'joins' => array(
                array(
                    'table' => 'appraisal_development_plan',
                    'alias' => 'adp',
                    'type' => 'inner',
                    'foreignKey' => false,
                    'conditions' => array('KraTarget.appraiser_id = adp.appraiser_id')
                )
            ),
            'conditions' => array("KraTarget.appraiser_id = '$appraiserId'", 'KraTarget.financial_year' => "$financialYear",
                "KraTarget.appraiser_status" => '5',
                'KraTarget.self_score_actual != ' => '',
                'KraTarget.self_score_achiev != ' => '',
                'KraTarget.appraiser_score_achiev' => ""),
            'group' => array('KraTarget.emp_code')
        ));
        return count($selfScore);
    }

    public function getKraTargetAppraiserSelfScoreForReviewer($reviewerId, $financialYear) {
        App::import("Model", "KraTarget");
        //Configure::write('debug',2);
        $model = new KraTarget();

        $selfScore = $model->find('all', array(
            'fields' => array('KraTarget.id'),
            'joins' => array(
                array(
                    'table' => 'competency_target',
                    'alias' => 'ct',
                    'type' => 'inner',
                    'foreignKey' => false,
                    'conditions' => array('KraTarget.reviewer_id = ct.reviewer_id')
                ),
                array(
                    'table' => 'appraisal_development_plan',
                    'alias' => 'adp',
                    'type' => 'inner',
                    'foreignKey' => false,
                    'conditions' => array('KraTarget.reviewer_id = adp.reviewer_code')
                )
            ),
            'conditions' => array("KraTarget.reviewer_id = '$reviewerId'", 'KraTarget.financial_year' => "$financialYear",
                "KraTarget.appraiser_status" => '5',
                'KraTarget.self_score_actual != ' => '',
                'KraTarget.self_score_achiev != ' => '',
                'KraTarget.appraiser_score_achiev !=' => "",
                'KraTarget.reviewer_score_achiev' => ""),
            'group' => array('KraTarget.emp_code')
        ));
        return count($selfScore);
    }

    public function getKraTargetReviewerSelfScoreForModerator($moderatorId, $financialYear) {
        App::import("Model", "KraTarget");
        $model = new KraTarget();

        $selfScore = $model->find('all', array(
            'fields' => array('KraTarget.id'),
            'conditions' => array("moderator_id = '$moderatorId'", 'KraTarget.financial_year' => "$financialYear",
                "appraiser_status" => '5',
                'self_score_actual != ' => '',
                'self_score_achiev != ' => '',
                'appraiser_score_achiev !=' => "",
                'reviewer_score_achiev != ' => "",
                'moderator_score_achiev =' => "",),
            'group' => array('emp_code')
        ));
        return count($selfScore);
    }

    public function getempJoinDate($emp_code = NULL) {
        $comp_code = $_SESSION['Auth']['MyProfile']['comp_code'];
        $emp_code = $_SESSION['Auth']['MyProfile']['emp_code'];
        App::import("Model", "MyProfile");
        $model = new MyProfile();
        $empinfo = $model->find('first', array(
            'fields' => array('MyProfile.join_date'),
            'conditions' => array(
                'emp_code' => $emp_code,
                'comp_code' => $comp_code)
        ));

        if (!empty($empinfo))
            return $empinfo['MyProfile']['join_date'];
        else
            return 'No record found';
    }

    public function findtravelamt($id = NULL) {

        //$ho_org_id = $_SESSION['Auth']['MyProfile']['comp_code'];

        App::import("Model", "MstTravelVoucher");
        $model = new MstTravelVoucher();

        $tv = $model->find('first', array(
            'fields' => array('desc'),
            'conditions' => array(
                'id' => $id,
                'status' => true)
        ));

        return $tv['MstTravelVoucher']['desc'];
    }

    public function kraEmpList($locationID) {
        // Configure::write('debug', 2);
        App::import("Model", "KraTarget");
        $model = new KraTarget();

        if ($locationID == "0") {
            $kraTargetList = $model->find('all', array(
                'joins' => array(
                    array(
                        'table' => 'myprofile',
                        'alias' => 'myprofile',
                        'type' => 'inner',
                        'foreignKey' => false,
                        'conditions' => array('KraTarget.emp_code = myprofile.emp_code')
                    )
                ),
                'fields' => array('myprofile.emp_code', 'myprofile.emp_id', 'myprofile.emp_full_name'),
				'conditions' => array("myprofile.status " => 32),
                'group' => array('KraTarget.emp_code'),
            ));
        } else {
            $kraTargetList = $model->find('all', array(
                'joins' => array(
                    array(
                        'table' => 'myprofile',
                        'alias' => 'myprofile',
                        'type' => 'inner',
                        'foreignKey' => false,
                        'conditions' => array('KraTarget.emp_code = myprofile.emp_code')
                    )
                ),
                'fields' => array('myprofile.emp_code', 'myprofile.emp_id', 'myprofile.emp_full_name'),
                'conditions' => array("myprofile.location_code LIKE" => $locationID . "%", "myprofile.status " => 32),
                'group' => array('KraTarget.emp_code'),
            ));
        }

        return $kraTargetList;
    }

    public function kraEmpListDetails($type,$locationID) {
        // Configure::write('debug', 2);
        App::import("Model", "KraTarget");
        $model = new KraTarget();

        if ($type == "kradet") {
			if ($locationID == "0") {
            $kraTargetList = $model->find('all', array(
                'joins' => array(
                    array(
                        'table' => 'myprofile',
                        'alias' => 'myprofile',
                        'type' => 'inner',
                        'foreignKey' => false,
                        'conditions' => array('KraTarget.emp_code = myprofile.emp_code')
                    )
                ),
                'fields' => array('myprofile.emp_code', 'myprofile.emp_id', 'myprofile.emp_full_name'),
				'conditions' => array("myprofile.status " => 32),
                'group' => array('KraTarget.emp_code'),
            ));
        } else {
            $kraTargetList = $model->find('all', array(
                'joins' => array(
                    array(
                        'table' => 'myprofile',
                        'alias' => 'myprofile',
                        'type' => 'inner',
                        'foreignKey' => false,
                        'conditions' => array('KraTarget.emp_code = myprofile.emp_code')
                    )
                ),
                'fields' => array('myprofile.emp_code', 'myprofile.emp_id', 'myprofile.emp_full_name'),
                'conditions' => array("myprofile.location_code LIKE" => $locationID . "%", "myprofile.status " => 32),
                'group' => array('KraTarget.emp_code'),
            ));
        }
		
		}else{
			if ($locationID == "0") {
            $kraTargetList = $model->find('all', array(
                'joins' => array(
                    array(
                        'table' => 'myprofile',
                        'alias' => 'myprofile',
                        'type' => 'inner',
                        'foreignKey' => false,
                        'conditions' => array('KraTarget.emp_code = myprofile.emp_code')
                    ),
					array(
                    'table' => 'competency_target',
                    'alias' => 'ct',
                    'type' => 'LEFT',
                    'foreignKey' => false,
                    'conditions' => array('KraTarget.emp_code = ct.emp_code')
                ),
				array(
                        'table' => 'mid_reviews',
                        'alias' => 'mr',
                        'type' => 'LEFT',
                        'foreignKey' => false,
                        'conditions' => array('KraTarget.emp_code = mr.emp_code')
                    )
                ),
                'fields' => array('myprofile.emp_code', 'myprofile.emp_id', 'myprofile.emp_full_name'),
				'conditions' => array("myprofile.status " => 32,'ct.appraiser_mid_rating_comment != ""','mr.emp_review_status' => 1,'mr.app_review_status' => 1,'mr.rev_review_status' => 1,'mr.mod_review_status' => 1),
                'group' => array('KraTarget.emp_code'),
            ));
        } else {
            $kraTargetList = $model->find('all', array(
                'joins' => array(
                    array(
                        'table' => 'myprofile',
                        'alias' => 'myprofile',
                        'type' => 'inner',
                        'foreignKey' => false,
                        'conditions' => array('KraTarget.emp_code = myprofile.emp_code')
                    ),
					array(
                    'table' => 'competency_target',
                    'alias' => 'ct',
                    'type' => 'LEFT',
                    'foreignKey' => false,
                    'conditions' => array('KraTarget.emp_code = ct.emp_code')
                ),
				array(
                        'table' => 'mid_reviews',
                        'alias' => 'mr',
                        'type' => 'LEFT',
                        'foreignKey' => false,
                        'conditions' => array('KraTarget.emp_code = mr.emp_code')
                    )
                ),
                'fields' => array('myprofile.emp_code', 'myprofile.emp_id', 'myprofile.emp_full_name'),
				'conditions' => array("myprofile.location_code LIKE" => $locationID . "%","myprofile.status " => 32,'ct.appraiser_mid_rating_comment != ""','mr.emp_review_status' => 1,'mr.app_review_status' => 1,'mr.rev_review_status' => 1,'mr.mod_review_status' => 1),
                
                'group' => array('KraTarget.emp_code'),
            ));
        }
		}
        return $kraTargetList;
    }

    public function KraEmpListDevelopmentPlan($locationID) {
        // Configure::write('debug', 2);
        App::import("Model", "AppraisalDevelopmentPlan");
        $model = new AppraisalDevelopmentPlan();

        if ($locationID == "0") {
            $devPlanList = $model->find('all', array(
                'joins' => array(
                    array(
                        'table' => 'myprofile',
                        'alias' => 'myprofile',
                        'type' => 'inner',
                        'foreignKey' => false,
                        'conditions' => array('AppraisalDevelopmentPlan.emp_code = myprofile.emp_code')
                    )
                ),
                'fields' => array('myprofile.emp_code', 'myprofile.emp_id', 'myprofile.emp_full_name'),
                'group' => array('AppraisalDevelopmentPlan.emp_code'),
            ));
        } else {
            $devPlanList = $model->find('all', array(
                'joins' => array(
                    array(
                        'table' => 'myprofile',
                        'alias' => 'myprofile',
                        'type' => 'inner',
                        'foreignKey' => false,
                        'conditions' => array('AppraisalDevelopmentPlan.emp_code = myprofile.emp_code')
                    )
                ),
                'fields' => array('myprofile.emp_code', 'myprofile.emp_id', 'myprofile.emp_full_name'),
                'conditions' => array("myprofile.location_code LIKE" => $locationID . "%"),
                'group' => array('AppraisalDevelopmentPlan.emp_code'),
            ));
        }

        return $devPlanList;
    }

    public function check_access_right($emp_code, $comp_code, $mod_alias, $right_alias) {
        //Configure::write('debug',2);
        App::import("Model", "AdminOption");
        $admin_option = new AdminOption();
        App::import("Model", "AclRights");
        $acl_right = new AclRights();
        App::import("Model", "MstAcl");
        $mst_acl = new MstAcl();

        $alias1 = $admin_option->find('all', array(
            'fields' => array('id'),
            'conditions' => array("name = " => $mod_alias)
        ));


        $mod_alias = $alias1['0']['AdminOption']['id'];

        $alias2 = $acl_right->find('all', array(
            'fields' => array('id'),
            'conditions' => array("name = " => $right_alias)
        ));

        $right_alias = $alias2['0']['AclRights']['id'];

        if ($mod_alias != '' && $right_alias != '') {

            $acl_status = $mst_acl->find('all', array(
                'fields' => array('status'),
                'conditions' => array("admin_options_id = " => $mod_alias, "acl_rights_id = " => $right_alias, "emp_code" => $emp_code, "org_id" => $comp_code)
            ));

            if ($acl_status['0']['MstAcl']['status'] == 1) {
                return 1;
            } else {
                return 0;
            }
        } else {
            return 0;
        }
    }

    public function getTrainingClassName($courseID) {

        $comp_code = $_SESSION['Auth']['MyProfile']['comp_code'];
        $emp_code = $_SESSION['Auth']['MyProfile']['emp_code'];
        App::import("Model", "TrainingCourseCreation");
        $model = new TrainingCourseCreation();
        $empinfo = $model->find('first', array(
            'fields' => array('TrainingCourseCreation.name'),
            'conditions' => array(
                'course_id' => $courseID)
        ));

        if (!empty($empinfo))
            return $empinfo['TrainingCourseCreation']['name'];
        else
            return 'No record found';
    }

    public function getTypeClassName($type_id) {
        $comp_code = $_SESSION['Auth']['MyProfile']['comp_code'];
        $emp_code = $_SESSION['Auth']['MyProfile']['emp_code'];
        App::import("Model", "CourseTypeMaster");
        $model = new CourseTypeMaster();
        $empinfo = $model->find('first', array(
            'fields' => array('CourseTypeMaster.name'),
            'conditions' => array(
                'type_id' => $type_id)
        ));

        if (!empty($empinfo))
            return $empinfo['CourseTypeMaster']['name'];
        else
            return '';
    }

    public function getCategoryClassName($category_id) {
        $comp_code = $_SESSION['Auth']['MyProfile']['comp_code'];
        $emp_code = $_SESSION['Auth']['MyProfile']['emp_code'];
        App::import("Model", "CourseCategoryMaster");
        $model = new CourseCategoryMaster();
        $empinfo = $model->find('first', array(
            'fields' => array('CourseCategoryMaster.name'),
            'conditions' => array(
                'category_id' => $category_id)
        ));

        if (!empty($empinfo))
            return $empinfo['CourseCategoryMaster']['name'];
        else
            return '';
    }

    public function getValidityClassName($validity_id) {
        $comp_code = $_SESSION['Auth']['MyProfile']['comp_code'];
        $emp_code = $_SESSION['Auth']['MyProfile']['emp_code'];
        App::import("Model", "CourseValidityMaster");
        $model = new CourseValidityMaster();
        $empinfo = $model->find('first', array(
            'fields' => array('CourseValidityMaster.name'),
            'conditions' => array(
                'validity_id' => $validity_id)
        ));

        if (!empty($empinfo))
            return $empinfo['CourseValidityMaster']['name'];
        else
            return '';
    }

    public function survey_parameter_name($id) {
        App::Import("Model", 'SurveyParameter');
        $model = new SurveyParameter();
        $val = $model->find('first', array('fields' => array('name'), 'conditions' => array('id' => $id)));
        if (!empty($val)) {
            return $val['SurveyParameter']['name'];
        } else {
            return 'No Record Found';
        }
    }

    public function findTrainingIncharge() {
        $emp_code = $_SESSION['Auth']['MyProfile']['emp_code'];
        App::import("Model", 'MyProfile');
        $modelprofile = new MyProfile();
        App::import("Model", 'OptionAttribute');
        $opp = new OptionAttribute();
        $pram_id = $opp->find('first', array('fields' => array('OptionAttribute.id'), 'conditions' => array('OptionAttribute.name' => 'EXECUTIVE TRAINEE', 'options_id' => 4)));
        //$val = $modelprofile->find('list', array('fields' => array('emp_code', 'emp_firstname'), 'conditions' => array('desg_code' => $pram_id['OptionAttribute']['id'], 'emp_code !=' => $emp_code)));
        $con3 = $modelprofile->query('SELECT `MyProfile`.`emp_code`, CONCAT(`MyProfile`.`emp_full_name`, " (", `MyProfile`.`emp_id`,")") as `emp_name` FROM `myprofile` AS `MyProfile` where `MyProfile`.`status` = "32" AND `MyProfile`.`comp_code` = "01" AND `MyProfile`.`desg_code` = "' . $pram_id['OptionAttribute']['id'] . '" AND `MyProfile`.`emp_code` != "' . $emp_code . '" ');

        foreach ($con3 as $value) {
            $val[$value['MyProfile']['emp_code']] = $value[0]['emp_name'];
        }
        return $val;
    }

    public function findEmpNameCode($emp_code, $desg_code, $loc_code) {
        App::import("Model", 'MyProfile');
        $modelprofile = new MyProfile();

        if ($this->getTrainingUserType() == 'TI') {
            $emp_name = $modelprofile->find('all', array(
                'fields' => array('MyProfile.emp_firstname', 'MyProfile.emp_code', 'MyProfile.desg_code', 'MyProfile.location_code'),
                'conditions' => array('MyProfile.desg_code' => $desg_code, 'MyProfile.location_code' => $loc_code)
            ));
        } else {
            $emp_name = $modelprofile->find('all', array(
                'fields' => array('MyProfile.emp_firstname', 'MyProfile.emp_code', 'MyProfile.desg_code', 'MyProfile.location_code'),
                'conditions' => array('MyProfile.manager_code' => $emp_code, 'MyProfile.desg_code' => $desg_code, 'MyProfile.location_code' => $loc_code)
            ));
        }
        return $emp_name;
    }


    
    public function get_qsn_options($id) {
        App::Import("Model", 'SurveyOption');
        $model = new SurveyOption();
        $val = $model->find('all', array('conditions' => array('question_id' => $id)));
        if (!empty($val)) {
            return $val;
        } else {
            return 'No Record Found';
        }
    }

    public function getTrainingUserType() {
        $emp_code = $_SESSION['Auth']['MyProfile']['emp_code'];
        $desg_code = $_SESSION['Auth']['MyProfile']['desg_code'];
        App::Import("Model", 'OptionAttribute');
        $model = new OptionAttribute();
        $pram_id = $model->find('first', array('fields' => array('OptionAttribute.id'), 'conditions' => array('OptionAttribute.name' => 'EXECUTIVE TRAINEE', 'options_id' => 4)));
        if (!empty($pram_id)) {
            if ($desg_code == $pram_id['OptionAttribute']['id'])
                $userType = 'TI';
            else
                $userType = '';
        }else {
            $userType = '';
        }
        return $userType;
    }

    public function chkTrainingApproval($training_id) {

        App::Import("Model", 'TrainingWorkflow');
        $model = new TrainingWorkflow();
        $emp_code = $_SESSION['Auth']['MyProfile']['emp_code'];
        $val = $model->find('first', array('conditions' => array('training_creation_id' => $training_id, 'emp_code' => $emp_code)));

        if (!empty($val) && $val['TrainingWorkflow']['status'] == NULL) {
            return true;
        } else {
            return false;
        }
    }

    /*
     * Check For Attendence in Training
     */

    public function checkTrainingAttendence($training_id, $emp_code = null) {
        App::Import("Model", 'TrainingCourseAttendence');
        $model = new TrainingCourseAttendence();
        $emp_code = $_SESSION['Auth']['MyProfile']['emp_code'];
        $val = $model->find('first', array('conditions' => array('TrainingCourseAttendence.training_creation_id' => $training_id, 'TrainingCourseAttendence.trainee_code' => $emp_code)));
        if (!empty($val)) {
            return $val;
        } else {
            return '';
        }
    }

    function getAuditMonitoringParamByID($id) {
        App::import("Model", "CAAllLabelAM");
        $model = new CAAllLabelAM();
        $values = $model->find('first', array(
            'conditions' => array(
                'CAAllLabelAM.id' => $id,
                'CAAllLabelAM.status' => '0'
            )
        ));
        if (!empty($values))
            return $values['CAAllLabelAM']['description'];
        else
            return '';
    }

    public function checkReortEmpCount() {
        $emp_code = $_SESSION['Auth']['MyProfile']['emp_code'];
        $comp_code = $_SESSION['Auth']['MyProfile']['comp_code'];
        App::Import("Model", 'MyProfile');
        $model = new MyProfile();
        $emplisting = $model->find('list', array('fields' => array(
                'MyProfile.emp_code',
                'MyProfile.emp_firstname'
            ),
            'conditions' => array('MyProfile.manager_code' => $emp_code, 'MyProfile.comp_code' => $comp_code),
            'order' => array('MyProfile.emp_firstname ASC')
        ));
        return $emplisting;
    }

    function gettrainingDetails($training_id) {
        App::import('Model', 'TrainingCreation');
        $model = new TrainingCreation();
        $detail = $model->find('first', array('conditions' => array('training_id' => $training_id)));
        return $detail;
    }

    public function chkCourseCreation($course_id) {
        $comp_code = $_SESSION['Auth']['MyProfile']['comp_code'];
        $emp_code = $_SESSION['Auth']['MyProfile']['emp_code'];
        App::import("Model", "TrainingCreation");
        $model = new TrainingCreation();
        $empinfo = $model->find('count', array(
            'fields' => array('TrainingCreation.training_id'),
            'conditions' => array(
                'TrainingCreation.course_id' => $course_id)
        ));
        if (!empty($empinfo))
            return $empinfo;
        else
            return '';
    }

    public function chkScheduleCreation($schedule_id) {
        $comp_code = $_SESSION['Auth']['MyProfile']['comp_code'];
        $emp_code = $_SESSION['Auth']['MyProfile']['emp_code'];
        App::import("Model", "TrainingCreation");
        $model = new TrainingCreation();
        $empinfo = $model->find('count', array(
            'fields' => array('TrainingCreation.training_id'),
            'conditions' => array(
                'TrainingCreation.schedule_id' => $schedule_id)
        ));
        if (!empty($empinfo))
            return $empinfo;
        else
            return '';
    }

    public function chkTypeAsgnCourse($type_id, $comp_code) {
        $comp_code = $_SESSION['Auth']['MyProfile']['comp_code'];
        $emp_code = $_SESSION['Auth']['MyProfile']['emp_code'];
        App::import("Model", "TrainingCourseCreation");
        $model = new TrainingCourseCreation();
        $empinfo = $model->find('count', array(
            'fields' => array('TrainingCourseCreation.course_id'),
            'conditions' => array(
                'type_id' => $type_id, 'comp_code' => $comp_code)
        ));
        if (!empty($empinfo))
            return $empinfo;
        else
            return '';
    }

    public function chkCategoryAsgnCourse($cat_id, $comp_code) {
        $comp_code = $_SESSION['Auth']['MyProfile']['comp_code'];
        $emp_code = $_SESSION['Auth']['MyProfile']['emp_code'];
        App::import("Model", "TrainingCourseCreation");
        $model = new TrainingCourseCreation();
        $empinfo = $model->find('count', array(
            'fields' => array('TrainingCourseCreation.course_id'),
            'conditions' => array(
                'course_category_id' => $cat_id, 'comp_code' => $comp_code)
        ));
        if (!empty($empinfo))
            return $empinfo;
        else
            return '';
    }

    public function chkValidityAsgnCourse($val_id, $comp_code) {
        $comp_code = $_SESSION['Auth']['MyProfile']['comp_code'];
        $emp_code = $_SESSION['Auth']['MyProfile']['emp_code'];
        App::import("Model", "TrainingCourseCreation");
        $model = new TrainingCourseCreation();
        $empinfo = $model->find('count', array(
            'fields' => array('TrainingCourseCreation.course_id'),
            'conditions' => array(
                'course_validity_id' => $val_id, 'comp_code' => $comp_code)
        ));
        if (!empty($empinfo))
            return $empinfo;
        else
            return '';
    }

    public function getTrainingCurrecny() {
        $emp_code = $_SESSION['Auth']['MyProfile']['emp_code'];
        $comp_code = $_SESSION['Auth']['MyProfile']['comp_code'];
        App::Import("Model", 'TrainingCurrency');
        $model = new TrainingCurrency();
        $listing = $model->find('list', array('fields' => array(
                'TrainingCurrency.id',
                'TrainingCurrency.name'
            ),
            'order' => array('TrainingCurrency.name ASC')
        ));
        return $listing;
    }

    public function getTrainingCurrecnyName($id) {
        $emp_code = $_SESSION['Auth']['MyProfile']['emp_code'];
        $comp_code = $_SESSION['Auth']['MyProfile']['comp_code'];
        App::Import("Model", 'TrainingCurrency');
        $model = new TrainingCurrency();
        $listing = $model->find('first', array('fields' => array(
                'TrainingCurrency.name'
            ), 'conditions' => array(
                'id' => $id
            )
        ));
        return $listing['TrainingCurrency']['name'];
    }

    public function getTrainingValidityList() {
        App::import("Model", 'TrainingValidityMaster');
        $modelprofile = new TrainingValidityMaster();
        $val = $modelprofile->find('list', array('fields' => array('id', 'name'), 'conditions' => array('status' => 0)));
        return $val;
    }

    public function getTrainingValidityMasterName($id) {
        App::Import("Model", 'TrainingValidityMaster');
        $model = new TrainingValidityMaster();
        $listing = $model->find('first', array('fields' => array(
                'TrainingValidityMaster.name'
            ), 'conditions' => array(
                'id' => $id
            )
        ));

        return $listing['TrainingValidityMaster']['name'];
    }

    public function getTrainingValidityId($id) {
        App::Import("Model", 'CourseValidityMaster');
        $model = new CourseValidityMaster();
        $listing = $model->find('first', array('fields' => array(
                'CourseValidityMaster.validity_master_id'
            ), 'conditions' => array(
                'validity_id' => $id
            )
        ));

        return $listing['CourseValidityMaster']['validity_master_id'];
    }

    public function getFeedbackId($training_id, $emp_code) {
        App::Import("Model", 'TrainingFeedback');
        $model = new TrainingFeedback();
        $feedback = $model->find('first', array(
            'conditions' => array('TrainingFeedback.training_creation_id' => $training_id, 'TrainingFeedback.emp_code' => $emp_code)
        ));
        return $feedback['TrainingFeedback']['feedback_id'];
    }

    function getTicketCat($id) {
        $ticket_category = new Model(array('table' => 'ticket_category', 'ds' => 'default', 'name' => 'TICKETCAT'));
        $data = $ticket_category->find('first', array('fields' => array('category_name'), 'conditions' => array('id' => $id)));
        return $data['TICKETCAT']['category_name'];
    }

    public function getCAgetdependentsByID($id) {
        App::Import("Model", 'CADependentDetails');
        $model = new CADependentDetails();
        $dependents = $model->find('first', array(
            'conditions' => array('CADependentDetails.id' => $id)
        ));
        return $dependents;
    }

    public function chkEmployeeAttendence($training_id, $emp_code) {
        App::import('Model', 'TrainingCreation');
        $model = new TrainingCreation();
        $details = $model->find('first', array('conditions' => array('training_id' => $training_id)));
        $count = 0;
        foreach ($details['TrainingEmployee'] as $value) {
            if ($value['trainee_code'] == $emp_code) {
                if ($value['status'] == 5) {
                    $count = 1;
                }
            }
        }

        if ($count == 1) {
            foreach ($details['TrainingCourseAttendence'] as $val) {
                if ($val['trainee_code'] == $emp_code) {
                    if ($val['open'] == 1 && $val['close'] == 1) {
                        $count = 2;
                    }
                }
            }
        }
        if ($count == 1 || $count == 0) {
            return false;
        } elseif ($count == 2) {
            return true;
        }
    }

    public function getIWCFDate($date, $validityId) {
        $lists = $this->getTrainingValidityList();
        if ($validityId == 1) {
            $date = date_create($date);
            date_add($date, date_interval_create_from_date_string('1 months'));
            return date_format($date, 'd-m-Y');
        } elseif ($validityId == 2) {
            $date = date_create($date);
            date_add($date, date_interval_create_from_date_string('1 weeks'));
            return date_format($date, 'd-m-Y');
        } elseif ($validityId == 3) {
            $date = date_create($date);
            date_add($date, date_interval_create_from_date_string('365 days'));
            return date_format($date, 'd-m-Y');
        } elseif ($validityId == 4) {
            $date = date_create($date);
            date_add($date, date_interval_create_from_date_string('6 months'));
            return date_format($date, 'd-m-Y');
        } elseif ($validityId == 5) {
            $date = date_create($date);
            date_add($date, date_interval_create_from_date_string('3 months'));
            return date_format($date, 'd-m-Y');
        } elseif ($validityId == 6) {
            $date = date_create($date);
            date_add($date, date_interval_create_from_date_string('365 days'));
            return '';
        }
    }

    public function checkTrainingEvolution($training_id) {
        App::import('Model', 'TrainingMstMatrix');
        $model = new TrainingMstMatrix();
        $details = $model->find('first', array('conditions' => array('TrainingMstMatrix.training_id' => $training_id)));
        if (!empty($details))
            return true;
        else
            return false;
    }

    public function getEmployeeMatrixDetail($emp_code, $training_id) {
        App::import('Model', 'TrainingDtMatrix');
        $model = new TrainingDtMatrix();
        $details = $model->find('first', array('conditions' => array('TrainingDtMatrix.training_creation_id' => $training_id, 'TrainingDtMatrix.emp_code' => $emp_code)));
        if (!empty($details))
            return $details;
        else
            return '';
    }


    public function getTrainingEmplyeeMatrixChk($emp_code) {
        App::import('Model', 'TrainingMatrixAssignEmployee');
        $model = new TrainingMatrixAssignEmployee();
        $details = $model->find('first', array('conditions' => array('TrainingMatrixAssignEmployee.matrix_assign_emp_code' => $emp_code)));
        if (!empty($details))
            return $details;
        else
            return '';
    }


    public function getAllEmpList() {
        App::import("Model", "MyProfile");
        $model = new MyProfile();
        $comp_code = $_SESSION['Auth']['MyProfile']['comp_code'];

        $empAllList = $model->find('all', array(
            'fields' => array('MyProfile.emp_id', 'MyProfile.emp_full_name'),
            'conditions' => array("MyProfile.comp_code = $comp_code")
        ));
        return $empAllList;
    }
    
    
    public function getAllEmpListWithID() {
        App::import("Model", "MyProfile");
        $model = new MyProfile();

        $empAllList = $model->find('all', array(
            'fields' => array('MyProfile.id', 'MyProfile.emp_full_name',"MyProfile.emp_code","MyProfile.comp_code"),
            'conditions' => array("MyProfile.comp_code ='01'"),
            'order'=>'MyProfile.emp_full_name ASC'
        ));

        return $empAllList;
    }
    
    public function findThematicAreaById($id) {
        App::import("Model", "CAThematicAreaMaster");
        $model = new CAThematicAreaMaster();

        $themArea = $model->find('all', array(
            'fields' => array('CAThematicAreaMaster.thematic_area'),
            'conditions' => array("CAThematicAreaMaster.id"=>$id),
        ));

        return $themArea[0]['CAThematicAreaMaster']['thematic_area'];
    }
    
    public function getNewsUrl() {
        $support = new Model(array('table' => 'install_country', 'ds' => 'default', 'name' => 'COUNTRY'));
        $data = $support->find('first', array('fields' => array('url'), 'conditions' => array('others' => 1)));
        return $data['COUNTRY']['url'];
    }
    
    function processtext($text,$nr=20)  {
                                    $mytext=explode(" ",trim($text));
                                    $newtext=array();
                                    foreach($mytext as $k=>$txt) {
                                        if (strlen($txt)>$nr) {
                                            $txt=wordwrap($txt, $nr, "<br>",1);
                                        }
                                        $newtext[]=$txt;
                                    }
                                    return implode(" ",$newtext);
                                }
                                
                                
    function getHrListProfile($emp_code) {
    App::import("Model", "MyProfile");
    $comp_code = $_SESSION['Auth']['MyProfile']['comp_code'];
    $model = new MyProfile();
    $query = $model->find('list', array('fields' => array(
            'emp_code', 'emp_name'),
        'conditions' => array(
            'comp_code' => $comp_code,
            'emp_code '=> $emp_code,
            'status' => 32),
        'order' => array("emp_name ASC")));
    return $query;
}
    public function findEmpCompany($emp_code){
        App::import("Model", "MyProfile");
        $model = new MyProfile();
        $data = $model->find('first',
                array('fileds'=>array('comp_code'),
                    'conditions'=>array('emp_code'=>$emp_code)));
        return $data['MyProfile']['comp_code'];
  
        
        
    }
	
	public function isUserActive($emp_code){
        App::import("Model", "MyProfile");
        $model = new MyProfile();
        $data = $model->find('first',
                array('fields'=>array('emp_code'),
                    'conditions'=>array('emp_code'=>$emp_code,'status'=>32)));
		if(count($data)>=1){
			return 1;
		}else{
			return 0;
		}
		
	}

     public function findMidCompDetailsApp($empCode, $currentFinancialYear) {
        App::import("Model", "CompetencyStatus");
        $model = new CompetencyStatus();
        $totalMidReviews = $model->find('all', array(
            'fields' => array('CompetencyStatus.id'),
            'conditions' => array(
            'CompetencyStatus.financial_year' => $currentFinancialYear,
                'CompetencyStatus.emp_code' => $empCode,
                'CompetencyStatus.app_mid_status' => 1 ,
            ),
        ));
        if (count($totalMidReviews) >= 1) {
            return 1;
        } else {
            return count($totalMidReviews);
        }
    }
	
	 public function getCompRatingEdit($empCode, $currentFinancialYear) {
        App::import("Model", "CompetencyStatus");
        $model = new CompetencyStatus();
        $totalMidReviews = $model->find('all', array(
            'fields' => array('CompetencyStatus.id'),
            'conditions' => array(
            'CompetencyStatus.financial_year' => $currentFinancialYear,
                'CompetencyStatus.emp_code' => $empCode,
                'CompetencyStatus.app_ann_status' => 1 ,
				'CompetencyStatus.rev_ann_status' => 0 ,
            ),
        ));
        if (count($totalMidReviews) >= 1) {
            return 1;
        } else {
            return count($totalMidReviews);
        }
    }

    public function findMidCompDetailsRev($empCode, $currentFinancialYear) {
        App::import("Model", "CompetencyStatus");
        $model = new CompetencyStatus();
        $totalMidReviews = $model->find('all', array(
            'fields' => array('CompetencyStatus.id'),
            'conditions' => array(
            'CompetencyStatus.financial_year' => $currentFinancialYear,
                'CompetencyStatus.emp_code' => $empCode,
                'CompetencyStatus.app_mid_status' => 1 ,
                'CompetencyStatus.rev_mid_status' => 1 ,
            ),
        ));
        if (count($totalMidReviews) >= 1) {
            return 1;
        } else {
            return count($totalMidReviews);
        }
    }

public function findMidCompDetailsMod($empCode, $currentFinancialYear) {
        App::import("Model", "CompetencyTarget");
        $model = new CompetencyTarget();
        $totalMidReviews = $model->find('all', array(
            'fields' => array('CompetencyTarget.id'),
            'conditions' => array(
            'CompetencyTarget.financial_year' => $currentFinancialYear,
                'CompetencyTarget.emp_code' => $empCode,
                'CompetencyTarget.appraiser_mid_rating_comment != ' => '' ,
                'CompetencyTarget.reviewer_mid_rating_comment != ' => '' ,
                'CompetencyTarget.moderator_mid_rating_comment != ' => '' ,
            ),
        ));
        if (count($totalMidReviews) >= 1) {
            return 1;
        } else {
            return count($totalMidReviews);
        }
    }
    
    function getVoucherDistance($id = NULL){
            $support = new Model(array('table' => 'dt_exp_voucher', 'ds' => 'default', 'name' => 'ExpVoucher'));
            $data = $support->find('first', array('fields' => array('SUM(distance) as total_dist'), 'conditions' => array('voucher_id' => $id)));
            return $data[0]['total_dist'];
            
    }
    
    function getVoucherTotalAmt($id = NULL){
            $support = new Model(array('table' => 'dt_exp_voucher', 'ds' => 'default', 'name' => 'ExpVoucher'));
            $data = $support->find('first', array('fields' => array('SUM(total_exp) as total'), 'conditions' => array('voucher_id' => $id)));
            return $data[0]['total'];
    }
    
    function getPrimaryMilestone($id = NULL){
            $primary_milestone = new Model(array('table' => 'primary_milestone', 'ds' => 'default', 'name' => 'MILESTONE'));
            $primary_milestone_list = $primary_milestone->find('first', array('fields' => array('name'),array('conditions'=>array('id'=>$id))));
            return $primary_milestone_list['MILESTONE']['name'];
    }
        

	public function findMidCompDetailsAppAlert($empCode, $currentFinancialYear) {
        App::import("Model", "CompetencyTarget");
        $model = new CompetencyTarget();
        $totalMidReviews = $model->find('all', array(
            'fields' => array('CompetencyTarget.id'),
            'conditions' => array(
			'CompetencyTarget.financial_year' => $currentFinancialYear,
                'CompetencyTarget.appraiser_id' => $empCode,
                'CompetencyTarget.appraiser_mid_rating_comment = ' => '' ,
            ),
        ));
        if (count($totalMidReviews) >= 1) {
            return 1;
        } else {
            return count($totalMidReviews);
        }
    }

	public function findMidCompDetailsRevAlert($empCode, $currentFinancialYear) {
        App::import("Model", "CompetencyTarget");
        $model = new CompetencyTarget();
        $totalMidReviews = $model->find('all', array(
            'fields' => array('CompetencyTarget.id'),
            'conditions' => array(
			'CompetencyTarget.financial_year' => $currentFinancialYear,
                'CompetencyTarget.reviewer_id' => $empCode,
                'CompetencyTarget.appraiser_mid_rating_comment != ' => '' ,
				'CompetencyTarget.reviewer_mid_rating_comment = ' => '' ,
            ),
        ));
        if (count($totalMidReviews) >= 1) {
            return 1;
        } else {
            return count($totalMidReviews);
        }
    }


public function findMidCompDetailsModAlert($empCode, $currentFinancialYear) {
        App::import("Model", "CompetencyTarget");
        $model = new CompetencyTarget();
        $totalMidReviews = $model->find('all', array(
            'fields' => array('CompetencyTarget.id'),
            'conditions' => array(
			'CompetencyTarget.financial_year' => $currentFinancialYear,
                'CompetencyTarget.moderator_id' => $empCode,
                'CompetencyTarget.appraiser_mid_rating_comment != ' => '' ,
				'CompetencyTarget.reviewer_mid_rating_comment != ' => '' ,
				'CompetencyTarget.moderator_mid_rating_comment = ' => '' ,
            ),
        ));
        if (count($totalMidReviews) >= 1) {
            return 1;
        } else {
            return count($totalMidReviews);
        }
    }

	public function findMidCompDetailsModAlert1($empCode, $currentFinancialYear) {
        App::import("Model", "CompetencyTarget");
        $model = new CompetencyTarget();
        $totalMidReviews = $model->find('all', array(
            'fields' => array('CompetencyTarget.id'),
            'conditions' => array(
			'CompetencyTarget.financial_year' => $currentFinancialYear,
                'CompetencyTarget.moderator_id' => $empCode,
                'CompetencyTarget.appraiser_mid_rating_comment != ' => '' ,
				'CompetencyTarget.reviewer_mid_rating_comment != ' => '' ,
				'CompetencyTarget.moderator_mid_rating_comment = ' => '' ,
            ),
        ));
        if (count($totalMidReviews) >= 1) {
            return 1;
        } else {
            return count($totalMidReviews);
        }
    }

	public function findDesignationListAll() {
        App::import("Model", "OptionAttribute");
        $model = new OptionAttribute();
        $query = $model->find('list', array(
            'fields' => array('OptionAttribute.id', 'OptionAttribute.id'),
            'conditions' => array('OptionAttribute.options_id' => 4),
			'order' => array('OptionAttribute.name' => 'asc')
        ));
        if (!empty($query)) {
            return $query;
        } else {
            return 'Not Found';
        }
    }
    
    public function getWfEvents() {
        App::import("Model", "WfMstEvents");
        $model = new WfMstEvents();
        $query = $model->find('list', array(
            'fields' => array('WfMstEvents.id', 'WfMstEvents.status_name'),
            'conditions' => array('WfMstEvents.status' => 1),
			'order' => array('WfMstEvents.id' => 'asc')
        ));
        if (!empty($query)) {
            return $query;
        } else {
            return 'Not Found';
        }
    }

}
   

?>
