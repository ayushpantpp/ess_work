<?php

App::uses('Component', 'Controller');
App::uses('CakeEmail', 'Network/Email');

class CommonComponent extends Component {

    public $uses = array('UserDetail', 'MakessSmsstatus', 'MyProfile');
    public $component = array('Email');
    const DEFAULT_COLOR = 'blue';
    public function __construct(ComponentCollection $collection, $settings = array()) {
        parent::__construct($collection, $settings);
    }

    public function initialize(Controller $controller) {
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

    public function findstatus($id = null) {
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
     public function getmgtcode($desg = NULL) {

        App::import("Model", "MgtGroupDesg");
        $model = new MgtGroupDesg();
        $empinfo = $model->find('first', array(
            'fields' => array('MgtGroupDesg.mgt_group'),
            'conditions' => array(
                'MgtGroupDesg.desg_code
                ' => $desg)
        ));
       
        if (!empty($empinfo))
            return $empinfo['MgtGroupDesg']['mgt_group'];
        else
            return 'No records found';
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
    public function get_all_admin_option($comp_code) {
        App::import("Model", "AdminOption");
        $model = new AdminOption();
        App::import("Model", "AdminOptionOrg");
        $model_new = new AdminOptionOrg();

        $admin_options = $model->find('all', array(
            'fields' => array('AdminOption.description', 'AdminOption.id', 'aoo.status'),
            'joins' => array(
                array(
                    'table' => 'admin_option_org',
                    'alias' => 'aoo',
                    'type' => 'inner',
                    'foreignKey' => false,
                    'conditions' => array('aoo.admin_options_id=AdminOption.id')
                ),
            ),
            'conditions' => array('aoo.org_id' => $comp_code, 'aoo.status' => 1)
        ));

        if (!empty($admin_options))
            return $admin_options;
        else
            return false;
    }

    public function findpaginateLevel($appid) {

        App::import("Model", "WfPaginateLvl");
        $model = new WfPaginateLvl();
        $paginatelvl = $model->find('first', array('fields' => array('paginate_lvl'), 'conditions' => array('appid' => $appid)));

        if ($paginatelvl) {
            $paginatelevel = $paginatelvl['WfPaginateLvl']['paginate_lvl'];
            return $paginatelevel;
        }
    }

    public function findDepartmentName($comp_code = null) {
        //function to find all company name
        App::import("Model", "Departments");
        $model = new Departments();
        $query = $model->find('list', array('fields' => array('dept_code', 'dept_name'), 'conditions' => array('comp_code' => $comp_code)));
        if (empty($query)) {
            return 0;
        } else {
            return $query;
        }
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

    function getDepartmentList($compCode) {
        App::import("Model", "Department");
        $model = new Department();
        $con2 = $model->find('list', array('fields' => array('Department.dept_code', 'Department.dept_name'), 'conditions' => array('Department.comp_code' => $compCode)));
        if (empty($con2)) {
            return 0;
        } else {
            return $con2;
        }
    }

    function getDesignationList($deptCode) {
        App::import("Model", "Designation");
        $model = new Designation();
        $con2 = $model->find('list', array('fields' => array('Designation.desg_code', 'Designation.desc'), 'conditions' => array('Designation.dept_code' => $deptCode)));
        if (empty($con2)) {
            return 0;
        } else {
            return $con2;
        }
    }

    function getDesignationName($desgCode) {
        App::import("Model", "Designation");
        $model = new Designation();
        $con2 = $model->find('first', array('fields' => array('Designation.desc'),
            'conditions' => array('Designation.desg_code' => $desgCode)
        ));
        if (empty($con2)) {
            return 0;
        } else {
            return $con2;
        }
    }

    function getEmployeesList() {
        // Configure::write('debug',2);
        App::import("Model", "MyProfile");
        $comp_code = $_SESSION['Auth']['MyProfile']['comp_code'];
        $dept_code = $_SESSION['Auth']['MyProfile']['dept_code'];
        $model = new MyProfile();
        $con2 = $model->find('all', array('fields' => array('MyProfile.emp_code', 'MyProfile.emp_name'), 'conditions' => array('MyProfile.status' => '32',
                'MyProfile.comp_code' => $comp_code, 'MyProfile.dept_code' => $dept_code)));
        if (empty($con2)) {
            return 0;
        } else {
            return $con2;
        }
    }

    function getEmployeesListByCompCode() {
        App::import("Model", "MyProfile");
        $comp_code = $_SESSION['Auth']['MyProfile']['comp_code'];
        $model = new MyProfile();
        $con3 = $model->query('SELECT `MyProfile`.`emp_code`, CONCAT(`MyProfile`.`emp_full_name`, " (", `MyProfile`.`emp_id`,")") as `emp_name` FROM `myprofile` AS `MyProfile` where `MyProfile`.`status` = "32" AND `MyProfile`.`comp_code` = " ' . $comp_code . '"');

        foreach ($con3 as $value) {
            $con2[$value['MyProfile']['emp_code']] = $value[0]['emp_name'];
        }
        if (empty($con2)) {
            return '';
        } else {
            return $con2;
        }
    }

    function getHO($org_id) {
        App::import("Model", "Company");
        $model = new Company();
        $con2 = $model->find('first', array('fields' => array('Company.ho_org_id', 'Company.org_id'), 'conditions' => array('Company.org_id' => $org_id)));
        if (empty($con2)) {
            return 0;
        } else {
            if ($con2['Company']['ho_org_id'] == '') {
                return $con2['Company']['org_id'];
            } else {
                return $con2['Company']['ho_org_id'];
            }
        }
    }

    function getStateList($countryCode) {
        App::import("Model", "State");
        $model = new State();
        $con2 = $model->find('list', array('fields' => array('State.id', 'State.statename'), 'conditions' => array('State.countryid' => $countryCode)));
        if (empty($con2)) {
            return 0;
        } else {
            return $con2;
        }
    }

    function getCityList($stateCode) {
        App::import("Model", "City");
        $model = new City();
        $con2 = $model->find('list', array('fields' => array('City.id', 'City.city'), 'conditions' => array('City.stateid' => $stateCode)));
        if (empty($con2)) {
            return 0;
        } else {
            return $con2;
        }
    }

    function getOptionName($optionCode) {
        App::import("Model", "OptionAttribute");
        $model = new OptionAttribute();
        $con2 = $model->find('first', array('fields' => array('OptionAttribute.name'),
            'conditions' => array(
                'OptionAttribute.id' => $optionCode)
        ));
        if (empty($con2['OptionAttribute']['name'])) {
            return 0;
        } else {
            return $con2['OptionAttribute']['name'];
        }
    }

    // Dashboard Saction Travel Approval List
    function getTravelApproval($emp_code) {
        App::import("Model", "DtTravelVoucher");
        $model = new DtTravelVoucher();
        $result = $model->find('all', array(
            'fields' => array('*'),
            'limit' => 10,
            'order' => array('DtTravelVoucher.voucher_id  DESC'),
            'joins' => array(
                array(
                    'table' => 'mst_emp_exp_voucher',
                    'alias' => 'mst',
                    'type' => 'inner',
                    'foreignKey' => false,
                    'conditions' => array('mst.voucher_id = DtTravelVoucher.voucher_id')
                ),
                array(
                    'table' => 'travel_workflow',
                    'alias' => 'TravelWfLvl',
                    'type' => 'inner',
                    'foreignKey' => false,
                    'conditions' => array('TravelWfLvl.voucher_id = DtTravelVoucher.voucher_id')
                )
            ),
            'conditions' => array('TravelWfLvl.emp_code' => $emp_code, 'mst.emp_code != ' . $emp_code, 'TravelWfLvl.fw_date' => NULL),
                //'order'=>array('LvMstId.id desc')
        ));
        if (!empty($result))
            return $result;
        else
            return '';
    }

    /*
     * Sanction Pending Convence Approve List
     */

    function getMedicalApproval($emp_code) {
        App::import("Model", "MedicalBillAmount");
        $model = new MedicalBillAmount();
        $result = $model->find('all', array(
            'fields' => array('*'),
            'limit' => 10,
            'order' => array('MedicalBillAmount.id  DESC'),
            'joins' => array(
                array(
                    'table' => 'medical_workflow',
                    'alias' => 'work_flow',
                    'type' => 'inner',
                    'foreignKey' => false,
                    'conditions' => array('work_flow.medical_bill_amount_id = MedicalBillAmount.id')
                )
            ),
            'conditions' => array('work_flow.emp_code' => $emp_code, 'work_flow.fw_date' => NULL, 'work_flow.medical_status' => null),
                //'order'=>array('LvMstId.id desc')
        ));

        //print_r($result); die;
        if (!empty($result))
            return $result;
        else
            return '';
    }

    function getLtaApproval($emp_code) {
        App::import("Model", "LtaBillAmount");
        $model = new LtaBillAmount();
        $result = $model->find('all', array(
            'fields' => array('*'),
            'limit' => 10,
            'order' => array('LtaBillAmount.id  DESC'),
            'joins' => array(
                array(
                    'table' => 'lta_workflow',
                    'alias' => 'work_flow',
                    'type' => 'inner',
                    'foreignKey' => false,
                    'conditions' => array('work_flow.lta_bill_amount_id = LtaBillAmount.id')
                )
            ),
            'conditions' => array('work_flow.emp_code' => $emp_code, 'work_flow.fw_date' => NULL, 'work_flow.lta_status' => null),
                //'order'=>array('LvMstId.id desc')
        ));

        //print_r($result); die;
        if (!empty($result))
            return $result;
        else
            return '';
    }

    function getTempApproval($emp_code) {
        App::import("Model", "EmployeeSalMon");
        $model = new EmployeeSalMon();
        $result = $model->find('all', array(
            'fields' => array('*'),
            'limit' => 10,
            'order' => array('EmployeeSalMon.id  DESC'),
            'joins' => array(
                array(
                    'table' => 'temp_workflow',
                    'alias' => 'work_flow',
                    'type' => 'inner',
                    'foreignKey' => false,
                    'conditions' => array('work_flow.employee_sal_mon_id = EmployeeSalMon.id')
                )
            ),
            'conditions' => array('work_flow.emp_code' => $emp_code, 'work_flow.fw_date' => NULL, 'work_flow.temp_status' => null),
                //'order'=>array('LvMstId.id desc')
        ));

        //print_r($result); die;
        if (!empty($result))
            return $result;
        else
            return '';
    }

    function getEncashApproval($emp_code) {
        App::import("Model", "LeaveEncsh");
        $model = new LeaveEncsh();
        $result = $model->find('all', array(
            'fields' => array('*'),
            'limit' => 10,
            'order' => array('LeaveEncsh.id  DESC'),
            'joins' => array(
                array(
                    'table' => 'leave_encashment_workflow',
                    'alias' => 'work_flow',
                    'type' => 'inner',
                    'foreignKey' => false,
                    'conditions' => array('work_flow.leave_encsh_id = LeaveEncsh.id')
                )
            ),
            'conditions' => array('work_flow.emp_code' => $emp_code, 'work_flow.fw_date' => NULL, 'LeaveEncsh.encsh_status' => 2),
                //'order'=>array('LvMstId.id desc')
        ));

        // print_r($result); die;
        if (!empty($result))
            return $result;
        else
            return '';
    }

    function getConvenceApprovalList($emp_code) {
        App::import("Model", "ConveyencExpenseDetail");
        $model = new ConveyencExpenseDetail();
        $result = $model->find('all', array(
            'fields' => array('*'),
            'limit' => 10,
            'order' => 'MstEmpConveyence.voucher_id DESC',
            'joins' => array(
                array(
                    'table' => 'mst_emp_exp_voucher',
                    'alias' => 'MstEmpConveyence',
                    'type' => 'inner',
                    'foreignKey' => false,
                    'conditions' => array('ConveyencExpenseDetail.voucher_id = MstEmpConveyence.voucher_id')
                ),
                array(
                    'table' => 'conveyence_workflow',
                    'alias' => 'ConveyenceWorkflow',
                    'type' => 'inner',
                    'foreignKey' => false,
                    'conditions' => array('ConveyenceWorkflow.voucher_id = ConveyencExpenseDetail.voucher_id')
                )
            ),
            'conditions' => array('ConveyenceWorkflow.emp_code' => $emp_code, 'MstEmpConveyence.emp_code != ' . $emp_code, 'ConveyenceWorkflow.fw_date' => NULL),
            'group' => array('ConveyencExpenseDetail.voucher_id')
        ));


        if (!empty($result))
            return $result;
        else
            return '';
    }

    /*
     * Sanction Pending Seperation Approve List
     */

    function findVehicleNameByID($id) {
        echo $id;
        App::import("Model", "MstVehicalMaster");
        $model = new MstVehicalMaster();
        $vehical = $model->find('list', array(
            'fields' => array('vehical_name'),
            'conditions' => array('id' => $id)
        ));
        if (!empty($vehical))
            return $vehical['MstVehicalMaster']['vehical_name'];
        else
            return false;
    }

    function getSeperationApprovalList($emp_code) {
        App::import("Model", "Separation");
        $model = new Separation();
        App::import("Model", "SeparationWorkflow");
        $model1 = new SeparationWorkflow();
        $emp_code = $emp_code;
        $others_separations = $model->find('list', array(
            'conditions' => array(
                'Separation.emp_code !=' => $emp_code,
            ),
            'fields' => 'id',
            'recursive' => 0
        ));
        foreach ($others_separations as $value) {
            $other_flows[$value] = $model1->find('all', array(
                'conditions' => array(
                    'AND' => array(
                        'SeparationWorkflow.separation_id' => $value,
                    ),
                ),
                'recursive' => 0
            ));
        };
        $pending_separation = array();
        foreach ($other_flows as $key => $value) {
            if ($value[sizeof($value) - 1]['SeparationWorkflow']['emp_code'] != $emp_code) {
                unset($other_flows[$key]);
            } else {
                $pending_separation[] = $value[sizeof($value) - 1];
            }
        }
        // print_r($pending_separation); die;
        if (!empty($pending_separation))
            return $pending_separation;
        else
            return '';
    }

    function getFnfApprovalList($emp_code) {
        App::import("Model", "FnfDetail");
        $model = new FnfDetail();
        $result = $model->find('all', array('fields' => array('*'), 'conditions' => array('approver_id' => $emp_code, 'FnfDetail.status' => 1)));

        if (!empty($result)) {
            return $result;
        } else {
            return '';
        }
    }

    function getFnfFinalApprovalList($emp_code) {
        App::import("Model", "Fnf");
        $model = new Fnf();
        $result = $model->find('all', array('fields' => array('*'), 'conditions' => array('final_approver' => $emp_code, 'Fnf.status' => 1)));

        if (!empty($result)) {
            return $result;
        } else {
            return '';
        }
    }

    function findLeaveOp($emp_code, $leave_id) {
        App::import("Model", "MstEmpLeaveAllot");
        $model = new MstEmpLeaveAllot();
        $result = $model->find('first', array('fields' => array('*'), 'conditions' => array('emp_code' => $emp_code, 'leave_code' => $leave_id)));
        return $result['MstEmpLeaveAllot']['leave_op'];
    }

    function getCurrentMonthSal($claimDate, $salID, $empCode) {

        App::import("Model", "EmployeeSalMon");
        App::import("Model", "DtEmployeeSalMon");
        $month = date('m');

        //echo $claimDate. " ". $salID . " ".$empCode;


        $empSalMon = new EmployeeSalMon();

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
            'conditions' => array('month(claim_date)' => $month, 'Dt.emp_code' => $empCode, 'Dt.sal_id' => $salID)
        ));

        return $temp_comp_month;
    }

    public function findDocByRefno($doc_ref_no) {
        App::import("Model", "Category");
        $model = new Category();
        $query = $model->find('first', array(
            'fields' => array('*'),
            'conditions' => array(
                'Category.id' => $doc_ref_no,
            )
        ));
        return $query;
    }

    function findLeaveBal($emp_code, $leave_id) {
        App::import("Model", "MstEmpLeaveAllot");
        $model = new MstEmpLeaveAllot();
        $result = $model->find('first', array('fields' => array('*'), 'conditions' => array('emp_code' => $emp_code, 'leave_code' => $leave_id)));
        return $result['MstEmpLeaveAllot']['leave_bal'];
    }

    public function getManagerCode($empCode) {
        $comp_code = $_SESSION['Auth']['MyProfile']['comp_code'];
        App::import("Model", "MyProfile");
        $model = new MyProfile();

        $desglist = $model->find('first', array(
            'fields' => array('MyProfile.manager_code'),
            'conditions' => array("emp_code = '$empCode'")
        ));
        return $desglist['MyProfile']['manager_code'];
    }
    public function getManagerCodebyID($empCode) {
        $comp_code = $_SESSION['Auth']['MyProfile']['comp_code'];
        App::import("Model", "MyProfile");
        $model = new MyProfile();

        $desglist = $model->find('first', array(
            'fields' => array('MyProfile.manager_code'),
            'conditions' => array("emp_id = '$empCode'")
        ));
        return $desglist['MyProfile']['manager_code'];
    }

    public function getManagerCompCode($empCode) {
        $comp_code = $_SESSION['Auth']['MyProfile']['comp_code'];
        App::import("Model", "MyProfile");
        $model = new MyProfile();

        $desglist = $model->find('first', array(
            'fields' => array('MyProfile.comp_code'),
            'conditions' => array("emp_code = '$empCode'")
        ));
        return $desglist['MyProfile']['comp_code'];
    }

    public function getTotalKraTargetForAppraiser($empCode) {
        $empCode = $_SESSION['Auth']['MyProfile']['emp_code'];
        App::import("Model", "KraTarget");
        $model = new KraTarget();
        $currentYear = date("Y");
        $desglist = $model->find('all', array(
            'fields' => array('KraTarget.id'),
            'conditions' => array('emp_status' => '2',
                'appraiser_status' => array(1, 3, 5), 'appraiser_id' => "$empCode",
            )
        ));
        return $desglist;
    }

    public function getTotalKraTargetForReviewer($empCode) {

        $empCode = $_SESSION['Auth']['MyProfile']['emp_code'];
        App::import("Model", "KraTarget");
        $model = new KraTarget();
        $currentYear = date("Y");
        $desglist = $model->find('all', array(
            'fields' => array('KraTarget.id'),
            //'conditions' => array('emp_status' => '2', 'appraiser_status' => array(5),
            'conditions' => array('emp_status' => '2',
                'reviewer_id' => "$empCode",
                'appraiser_to_reviewer' => 1,
            )
        ));

        return $desglist;
    }

    public function getTotalKraTargetForModerator($empCode) {
        $empCode = $_SESSION['Auth']['MyProfile']['emp_code'];
        App::import("Model", "KraTarget");
        $model = new KraTarget();
        $currentYear = date("Y");
        $desglist1 = $model->find('all', array(
            'fields' => array('KraTarget.id'),
            'conditions' => array('emp_status' => '2', 'appraiser_status' => array(5),
                'reviewer_score_achiev != ""', 'moderator_id' => "$empCode",
            )
        ));

        $totalMidReviews = $model->find('all', array(
            'fields' => array('*'),
            'joins' => array(
                array(
                    'table' => 'mid_reviews',
                    'alias' => 'mr',
                    'type' => 'inner',
                    'foreignKey' => false,
                    'conditions' => array('KraTarget.emp_code = mr.emp_code')
                )
            ),
            'group' => array('KraTarget.financial_year', 'KraTarget.emp_code'),
            'conditions' => array('KraTarget.moderator_id' => $_SESSION['Auth']['MyProfile']['emp_code'], 'mr.emp_review_status' => 1, 'mr.app_review_status' => 1, 'mr.rev_review_status' => 1),
                )
        );

        //$desglist= array_unique(array_merge($desglist1,$totalMidReviews));
        $desglist = array_merge(
                array_intersect($totalMidReviews, $desglist1), array_diff($totalMidReviews, $desglist1), array_diff($desglist1, $totalMidReviews)
        );


        return $desglist;
    }

    public function getLeaveCount($emp_code, $comp_code) {
        App::import("Model", "MstEmpLeave");
        $model = new MstEmpLeave();
        $count = $model->find('all', array('fields' => 'sum(total_leave)', 'conditions' => array('emp_code' => $emp_code, 'comp_code' => $comp_code)));
        return $count[0][0]['sum(total_leave)'];
    }

    public function getLeaveDetail($id) {
        App::import("Model", "MstEmpLeave");
        $model = new MstEmpLeave();
        $count = $model->find('first', array('fields' => array('emp_code', 'start_date', 'end_date', 'total_leave'), 'conditions' => array('leave_id' => $id)));
        return $count;
    }

    public function getConveyanceCount($emp_code, $comp_code) {
        App::import("Model", "ConveyencExpenseDetail");
        $model = new ConveyencExpenseDetail();
        $month = date('m');
        $count = $model->find('all', array('fields' => 'sum(total_exp)', 'conditions' => array('emp_code' => $emp_code, 'MONTH(claim_date) = ' . $month)));
        return $count[0][0]['sum(total_exp)'];
    }

    public function getAllConveyanceCount($comp_code) {
        App::import("Model", "ConveyencExpenseDetail");
        $model = new ConveyencExpenseDetail();
        $month = date('m');
        $count = $model->find('all', array('fields' => 'sum(total_exp)', 'conditions' => array('MONTH(claim_date) = ' . $month)));
        return $count[0][0]['sum(total_exp)'];
    }

    public function getTravelCount($emp_code, $comp_code) {
        App::import("Model", "DtTravelVoucher");
        $model = new DtTravelVoucher();
        $month = date('m');
        $count = $model->find('all', array('fields' => 'sum(total_expense)', 'conditions' => array('emp_code' => $emp_code, 'MONTH(tour_start_date) = ' . $month)));
        return $count[0][0]['sum(total_expense)'];
    }

    public function getAllTravelCount($comp_code) {
        App::import("Model", "DtTravelVoucher");
        $model = new DtTravelVoucher();
        $month = date('m');
        $count = $model->find('all', array('fields' => 'sum(total_expense) as tr', 'conditions' => array('MONTH(tour_start_date) = ' . $month)));
        if ($count[0][0]['tr'] > 0) {
            return $count[0][0]['tr'];
        } else {
            return 0;
        }
    }

    public function getAllLeaveCount($comp_code) {
        App::import("Model", "MstEmpLeave");
        $month = date('m');
        $model = new MstEmpLeave();
        $count = $model->find('all', array('fields' => 'sum(total_leave)', 'conditions' => array('comp_code' => $comp_code,
                'MONTH(start_date) = ' . $month
        )));
        return $count[0][0]['sum(total_leave)'];
    }

    public function getAttenCount($emp_code, $comp_code) {
        $doc_id = $_SESSION['Auth']['MyProfile']['doc_id'];
        $date = date('Y-m-d');
        App::import("Model", "AttendanceDetail");
        $model = new AttendanceDetail();
        $count = $model->find('count', array(
            'conditions' => array('AttendanceDetail.atten_dt' => $date),
        ));
        //print_r($count); die;
        return $count;
    }

    public function getMomCount($emp_code, $comp_code) {
        App::import("Model", "MomAssign");
        $model = new MomAssign();
        $count = $model->find('count', array(
            'conditions' => array('MomAssignEmp.emp_code' => $emp_code),
            'joins' => array(
                array(
                    'alias' => 'MomAssignEmp',
                    'table' => 'mom_assign_emp',
                    'type' => 'INNER',
                    'conditions' => '`MomAssign`.`mid` = `MomAssignEmp`.`mid`'
                )
            )
        ));
        return $count;
    }

    public function getMomStatus($mom_status) {
        if ($mom_status == '5') {
            return "Finalized";
        } else {
            return "Pending";
        }
    }

    public function getBOMStatus($mom_status) {
        if ($mom_status == '1') {
            return "Finalized";
        } else {
            return "Pending";
        }
    }

    public function findEmpMail($emp_code = null) {
        //function to find all company name
        App::import("Model", "UserDetail");
        $model = new UserDetail();
        $query = $model->find('first', array('fields' => array('UserDetail.user_name', 'UserDetail.email'), 'conditions' => array('UserDetail.emp_code' => $emp_code)));
        if (empty($query)) {
            return 0;
        } else {
            return $query;
        }
    }

    public function getEmpCount($comp_code) {
        App::import("Model", "MyProfile");
        $model = new MyProfile();
        $list = $model->find('count', array(
            'conditions' => array('MyProfile.status' => 32, 'comp_code' => $comp_code)
        ));
        // print_r($list); die;
        return $list;
    }

    public function getKraWeightageByID($kraTargetID) {
        App::import("Model", "KraTarget");
        $model = new KraTarget();
        $list = $model->find('all', array(
            'fields' => array('KraTarget.weightage'),
            'conditions' => array('KraTarget.id' => $kraTargetID)
        ));

        //echo "<pre>";print_r($list);die;
        return $list[0]['KraTarget']['weightage'];
    }

    public function getKraCommentByID($kraTargetID) {
        App::import("Model", "KraTarget");
        $model = new KraTarget();
        $list = $model->find('all', array(
            'fields' => array('KraTarget.appraiser_status_comment', 'KraTarget.emp_status_comment'),
            'conditions' => array('KraTarget.id' => $kraTargetID)
        ));

        //echo "<pre>";print_r($list);die;
        return $list;
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

    public function getTotalApprovedByAppraiser($empCode, $fincialYear) {
        App::import("Model", "KraTarget");
        $model = new KraTarget();
        $list = $model->find('all', array(
            'fields' => array('KraTarget.id', 'KraTarget.reviewer_id', 'KraTarget.reviewer_score_achiev', 'KraTarget.reviewer_score_comment', 'KraTarget.moderator_id'),
            'conditions' => array(
                'KraTarget.emp_code' => $empCode,
                'KraTarget.financial_year' => $fincialYear,
                'KraTarget.appraiser_status' => 5)
        ));

        //echo "<pre>";print_r($list);die;
        return $list;
    }

    public function getTotalApprovedByReviewer($empCode, $fincialYear) {
        App::import("Model", "KraTarget");
        $model = new KraTarget();
        $list = $model->find('all', array(
            'fields' => array('KraTarget.id', 'KraTarget.reviewer_id', 'KraTarget.reviewer_score_achiev', 'KraTarget.reviewer_score_comment', 'KraTarget.moderator_id'),
            'conditions' => array(
                'KraTarget.emp_code' => $empCode,
                'KraTarget.financial_year' => $fincialYear,
                'KraTarget.reviewer_status' => 5)
        ));

        //echo "<pre>";print_r($list);die;
        return $list;
    }

    public function getKraTargetDetails($empCode, $fincialYear) {
        App::import("Model", "KraTarget");
        $model = new KraTarget();
        $list = $model->find('all', array(
            'fields' => array('KraTarget.id', 'KraTarget.emp_code', 'KraTarget.comp_code', 'KraTarget.appraiser_id', 'KraTarget.appraiser_comp_code', 'KraTarget.reviewer_id', 'KraTarget.reviewer_comp_code', 'KraTarget.reviewer_score_achiev', 'KraTarget.reviewer_score_comment', 'KraTarget.mid_reviewer_score_comment', 'KraTarget.moderator_id', 'KraTarget.moderator_comp_code', 'KraTarget.mid_app_actual_upload', 'KraTarget.mid_rev_actual_upload'),
            'conditions' => array(
                'KraTarget.emp_code' => $empCode,
                'KraTarget.financial_year' => $fincialYear)
        ));

        //echo "<pre>";print_r($list);die;
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

    public function getDesgCode($empCode) {
        $comp_code = $_SESSION['Auth']['MyProfile']['comp_code'];
        App::import("Model", "MyProfile");
        $model = new MyProfile();

        $desglist = $model->find('first', array(
            'fields' => array('MyProfile.desg_code'),
            'conditions' => array("emp_code = '$empCode'")
        ));
        return $desglist['MyProfile']['desg_code'];
    }

    public function findGroupDesg($desgCode) {

        App::import("Model", "MgtGroupDesg");
        $model = new MgtGroupDesg();
        $list = $model->find('first', array(
            'fields' => array('mgt_group'),
            'conditions' => array('MgtGroupDesg.desg_code' => "$desgCode")
        ));
        return $list['MgtGroupDesg']['mgt_group'];
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
            'conditions' => array('emp_code' => "$empCode", 'KraTarget.financial_year' => "$financialYear",
                "appraiser_status" => array(1, 3), "final_status = '0'", "emp_status = '2'",
                'KraTarget.financial_year' => "$financialYear")
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

    public function getKraTargetRevertStatusforEmp($empCode, $financialYear) {
        //$appraiserId = $_SESSION['Auth']['User']['emp_code'];
        App::import("Model", "KraTarget");
        $model = new KraTarget();
        $currentYear = date("Y");
        $statusList = $model->find('all', array(
            'fields' => array('KraTarget.id'),
            'conditions' => array('emp_code' => "$empCode", 'KraTarget.financial_year' => "$financialYear",
                "appraiser_status" => array(1, 3), "final_status = '0'", "emp_status = '2'",
                'KraTarget.financial_year' => "$financialYear")
        ));
        return $statusList;
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

    public function getCompetencyTargetDetails($empCode, $financialYear) {
        App::import("Model", "CompetencyTarget");
        $model = new CompetencyTarget();

        $list = $model->find('all', array(
            'fields' => array('*'),
            'conditions' => array('emp_code' => "$empCode",
                "CompetencyTarget.appraiser_rating != ''",
                "CompetencyTarget.reviewer_rating != ''",
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

    public function send_mail_OLD($From = null, $TO = null, $CC = null, $Subject = null, $Message = null, $Template = null, $data = null) {
        //Configure::write('debug', 2);
        ////////////Email///////////////
        $Email = new CakeEmail();
        $Email->config('smtp');
        $Email->template($Template);
        $Email->from($From);
        $Email->to($TO);
        $Email->cc($CC);
        $Email->subject($Subject);
        $Email->viewVars(['message' => $Message]);
        $Email->viewVars($data);
        $Email->emailFormat('both');
        if ($Email->send()) {
            echo "Email sent successfully";
        } else {
            echo $this->Email->smtpError;
            echo "Error in email sending......";
        }
        ///////////////Email END///////
    }

    public function send_mail($From = null, $TO = null, $CC = null, $Subject = null, $Message = null, $Template = null, $data = null) {
        //Configure::write('debug', 2);
        ////////////Email///////////////
        $Email = new CakeEmail();
        $Email->config('smtp');

        //$Email->template($Template);
        $Email->from($From);
        $Email->to($TO);
        $Email->cc($CC);
        $Email->subject($Subject);
        $Email->viewVars(['message' => $Message]);
        $Email->viewVars($data);
        $Email->emailFormat('both');
//		echo '<pre>';
//		print_r($Email->template());

        try {
            $n = $Email->send();
        } catch (Exception $e) {
            print_r($this->Email->smtpError);
            echo 'cannt sent';
        }
        if ($n) {
            echo "Email sent successfully";
            //return 1;
        } else {
            echo $this->Email->smtpError;
            echo "Error in email sending......";

            //return 0;
        }

        ///////////////Email END///////
    }

    public function findEmpListByDesgCode($desgCode) {
        $compCode = $_SESSION['Auth']['MyProfile']['comp_code'];
        //function to find all company name		

        App::import("Model", "MyProfile");
        $model = new MyProfile();
        $query = $model->find('all', array('fields' => array('emp_code', 'emp_full_name', 'comp_code'),
            'conditions' => array('MyProfile.desg_code' => $desgCode, 'MyProfile.comp_code' => $compCode),
            'order' => 'MyProfile.emp_full_name ASC'));
        return $query;
    }

    public function findEmpListByDesgCodeDOJ($desgCode, $startDate, $endDate) {
        $compCode = $_SESSION['Auth']['MyProfile']['comp_code'];
        //function to find all company name		

        $startDate = date('Y-m-d', strtotime($startDate));
        $endDate = date('Y-m-d', strtotime($endDate));


        App::import("Model", "MyProfile");
        $model = new MyProfile();
        $query = $model->find('all', array('fields' => array('emp_code', 'emp_full_name', 'comp_code', 'join_date'),
            'conditions' => array('MyProfile.desg_code' => $desgCode, 'MyProfile.comp_code' => $compCode, 'MyProfile.join_date BETWEEN ? AND ? ' => array($startDate, $endDate)),
            'order' => 'MyProfile.emp_full_name ASC'));
        return $query;
    }

    public function sendSms($phoneNumber, $content) {
        App::import("Model", "MakessSmsstatus");
        $makessSmsstatus = new MakessSmsstatus();

        $dataSms['content'] = $content;
        $dataSms['status'] = "N";
        $dataSms['num'] = "+91" . $phoneNumber;
        $dataSms['send_time'] = Null;
        $dataSms['appr_num'] = 0;
        $dataSms['rej_num'] = 0;

        //echo "<pre>"; print_r($dataSms); die;

        $makessSmsstatus->save($dataSms);
    }

    public function OpenDevpPlanForAppraiser($empCode, $financialYear) {
        App::import("Model", "appraisalDevelopmentPlan");
        $model = new appraisalDevelopmentPlan();

        $list = $model->find('all', array(
            'fields' => array('*'),
            'conditions' => array('emp_code' => "$empCode",
                "appraisalDevelopmentPlan.self_areas_strength != ''",
                'appraisalDevelopmentPlan.financial_year' => "$financialYear")
        ));
        return $list;
    }

    public function openSummaryDiscussion($empCode, $financialYear) {
        App::import("Model", "AppraisalDevelopmentPlan");
        $model = new AppraisalDevelopmentPlan();

        $list = $model->find('all', array(
            'fields' => array('*'),
            'conditions' => array('emp_code' => "$empCode",
                "AppraisalDevelopmentPlan.self_areas_strength != ''",
                "AppraisalDevelopmentPlan.self_areas_development != ''",
                "AppraisalDevelopmentPlan.appraiser_areas_strength != ''",
                "AppraisalDevelopmentPlan.appraiser_areas_development != ''",
                'AppraisalDevelopmentPlan.financial_year' => "$financialYear")
        ));
        return $list;
    }

    function findfy_id($fy) {
        App::import("Model", "FinancialYear");
        $fy_model = new FinancialYear();
        $data = $fy_model->find('first', array('fields' => array('*'), 'conditions' => array('status' => '1')));
        return $data['FinancialYear']['id'];
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

    public function getDocID($emp_code) {
        App::import("Model", "MyProfile");
        $model = new MyProfile();
        $result = $model->find('first', array('field' => array('doc_id'),
            'conditions' => array('emp_code' => $emp_code),
        ));
        return $result['MyProfile']['doc_id'];
    }

    public function chkLTAProcess() {
        App::import("Model", "LtaBillAmount");
        $model = new LtaBillAmount();
        $doc_id = $_SESSION['Auth']['MyProfile']['doc_id'];
        $emp_code = $_SESSION['Auth']['MyProfile']['emp_code'];

        $result = $model->find('first', array(
            'fields' => array('*'),
            'limit' => 1,
            'order' => array('LtaBillAmount.id  DESC'),
            'conditions' => array('LtaBillAmount.emp_code' => $emp_code),
        ));
        if (!empty($result) && ($result['LtaBillAmount']['status'] == 5)) {
            $date = $result['LtaBillAmount']['created_at'];
            $db = ConnectionManager::getDataSource("default"); // name of your database connection
            $dtl = $db->fetchAll("SELECT *  FROM `employee_sal_proc` WHERE `emp_doc_id`='" . $doc_id . "' and '" . $date . "' between proc_frm_dt and proc_to_dt");
            if (!empty($dtl))
                $chk = true;
            else
                $chk = false;
        }elseif (!empty($result) && ($result['LtaBillAmount']['status'] == 4)) {
            $chk = true;
        } else {
            $chk = true;
        }
        return $chk;
    }

    public function getEmpDetails($empCode) {
        App::import("Model", "MyProfile");
        $model = new MyProfile();

        $emplist = $model->find('first', array(
            'fields' => array('MyProfile.emp_code', 'MyProfile.emp_id', 'MyProfile.manager_code', 'MyProfile.emp_full_name', 'MyProfile.join_date', 'MyProfile.location_code', 'MyProfile.dept_code', 'MyProfile.desg_code', 'MyProfile.comp_code'),
            'conditions' => array("emp_code = '$empCode'")
        ));
        return $emplist;
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

    function getCourseMaxCapacity($courseid) {
        App::import("Model", "TrainingCourseCreation");
        $course = new TrainingCourseCreation();

        $detail = $course->find('first', array(
            'fields' => 'max_class_capacity',
            'conditions' => array("course_id" => $courseid)
        ));
        return $detail['TrainingCourseCreation']['max_class_capacity'];
    }

    public function checkAbsentTrainee($training_id, $emp_code) {
        App::import("Model", "TrainingCourseAttendence");
        $model = new TrainingCourseAttendence();
        $val = $model->find('first', array(
            'conditions' => array(
                'TrainingCourseAttendence.feedback_status' => 1, 'TrainingCourseAttendence.open' => 1, 'TrainingCourseAttendence.close' => 1, 'TrainingCourseAttendence.trainee_code' => $emp_code, 'TrainingCourseAttendence.training_creation_id' => $training_id)
        ));
        if (!empty($val))
            return $val;
        else
            return '';
    }

    function getSuportEmailId($comp_code) {
        $support_email = new Model(array('table' => 'support_email', 'ds' => 'default', 'name' => 'SUPPEMAIL'));
        $data = $support_email->find('first', array('fields' => array('email'), 'conditions' => array('comp_code' => $comp_code)));
        //print_r($data); die;
        return $data['SUPPEMAIL']['email'];
    }

    function getEmpEmailId($id) {
        $support_email = new Model(array('table' => 'users', 'ds' => 'default', 'name' => 'USERS'));
        $data = $support_email->find('first', array('fields' => array('email'), 'conditions' => array('emp_code' => $id)));
        //print_r($data); die;
        return $data['USERS']['email'];
    }

    function getMgrEmailId($id) {
        $support_email = new Model(array('table' => 'users', 'ds' => 'default', 'name' => 'USERS'));
        $data = $support_email->find('first', array('fields' => array('email'), 'conditions' => array('emp_code' => $id)));
        //print_r($data); die;
        return $data['USERS']['email'];
    }

    public function getWealthEmpEmialID($emp_difini_id) {
        App::import("Model", "CAEmployeeDefinition");
        $model = new MyProfile();

        $emplist = $model->find('first', array(
            'fields' => array('MyProfile.emp_code', 'MyProfile.emp_id', 'MyProfile.manager_code', 'MyProfile.emp_full_name', 'MyProfile.join_date', 'MyProfile.dept_code', 'MyProfile.desg_code', 'MyProfile.comp_code'),
            'conditions' => array("emp_code = '$empCode'")
        ));
        return $emplist;
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

    public function findCompRatingList() {
        App::import("Model", "CompetencyRating");
        $model = new CompetencyRating();
        $query = $model->find('all', array(
            'fields' => array('CompetencyRating.rating_scale', 'CompetencyRating.achievement_from', 'CompetencyRating.achievement_to'),
            'conditions' => array('CompetencyRating.is_deleted' => 0, 'CompetencyRating.status' => 1),
            'order' => 'rating_scale DESC',
        ));
        if (!empty($query)) {
            return $query;
        } else {
            return 0;
        }
    }

    public function findKraMasterConfig($comp_code) {
        App::import("Model", "MstPmsConfig");
        $model = new MstPmsConfig();
        $query = $model->find('first', array(
            'fields' => array('*'),
            'conditions' => array('MstPmsConfig.comp_code' => $comp_code)
        ));
        if (!empty($query)) {
            return $query;
        } else {
            return 0;
        }
    }

    public function findMidReviewsDetailsEmp($empCode, $currentFinancialYear) {
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

    public function findMidReviewsDetailsApp($empCode, $currentFinancialYear) {
        App::import("Model", "MidReviews");
        $model = new MidReviews();
        $totalMidReviews = $model->find('all', array(
            'fields' => array('MidReviews.id'),
            'joins' => array(
                array(
                    'table' => 'competency_target',
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
                'ct.appraiser_mid_rating_comment != ""',),
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
            'joins' => array(
                array(
                    'table' => 'competency_target',
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
                'ct.appraiser_mid_rating_comment != ""',
                'ct.reviewer_mid_rating_comment != ""',
            ),
        ));
        if (count($totalMidReviews) >= 1) {
            return 1;
        } else {
            return count($totalMidReviews);
        }
    }

    public function findMidReviewsDetailsMod($empCode, $currentFinancialYear) {
        App::import("Model", "MidReviews");
        $model = new MidReviews();
        $totalMidReviews = $model->find('all', array(
            'fields' => array('MidReviews.id'),
            'joins' => array(
                array(
                    'table' => 'competency_target',
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
                'ct.appraiser_mid_rating_comment != ""',
                'ct.reviewer_mid_rating_comment != ""',
                'ct.moderator_mid_rating_comment != ""',
            ),
        ));
        if (count($totalMidReviews) >= 1) {
            return 1;
        } else {
            return count($totalMidReviews);
        }
    }

    function findfyDesc($fy) {
        App::import("Model", "FinancialYear");
        $fy_model = new FinancialYear();
        $data = $fy_model->find('first', array('fields' => array('*'), 'conditions' => array('id' => $fy)));
        return $data['FinancialYear']['fy_desc'];
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

    public function findEmpName($emp_code) {
        App::import("Model", 'MyProfile');
        $modelprofile = new MyProfile();
        $emp_name = $modelprofile->find('first', array(
            'fields' => array('MyProfile.emp_firstname', 'MyProfile.emp_lastname', 'MyProfile.emp_full_name'),
            'conditions' => array('MyProfile.emp_code' => $emp_code)
        ));
        return $emp_name['MyProfile']['emp_full_name'];
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
    
    public function findCompanyName($org_id) {
        //function to find all company name
        App::import("Model", "Company");
        $model = new Company();
        $query = $model->find('first', array('fields' => array('comp_name'),
                'conditions' => array(
                    'comp_code' => $org_id)));
        if (empty($query)) {
            return 0;
        } else {
            return $query;
        }
    }

    public function getMailData($org_id, $application_id, $event_id) {
        App::import("Model", "MailerMaster");
        $mailer_master_model = new MailerMaster();
        App::import("Model", "MstLogo");
        $logo_master_model = new MstLogo();
        
        try {
            if (empty($org_id) || empty($application_id) || empty($event_id))
                throw new Exception('Invalid Data to fetch mail body');
            $mail_data = $mailer_master_model->find('first', array(
                'fields' => array('*'),
                'conditions' => array(
                    'org_id' => $org_id, 'event_id' => $event_id, 'active_status' => 1)
            ));
            if (empty($mail_data))
                throw new Exception('No data found for given application id , event_id, org_id');

            if (isset($mail_data['MailerMaster']['body_data']) && empty($mail_data['MailerMaster']['body_data']))
                throw new Exception('Mail Body not avialable');
            
            if (isset($mail_data['MailerMaster']['tags']) && empty($mail_data['MailerMaster']['tags']))
                throw new Exception('Short Tags not avialable');
            
            $mail_body = $mail_data['MailerMaster']['body_data'];
            $mail_tags = $mail_data['MailerMaster']['tags'];
            $mail_data = $logo_master_model->find('first', array(
                'fields' => array('*'),
                'conditions' => array(
                    'org_id' => $org_id)
            ));
            if(empty($mail_data))
                throw new Exception('Data not found in logo for given organisation');
            
            if (isset($mail_data['MstLogo']['logo_file']) && empty($mail_data['MstLogo']['logo_file']))
                throw new Exception('Logo not found');
            $poject_url = Router::url('/',true);
            $org_logo = $poject_url.'img/'.$mail_data['MstLogo']['logo_file'];
            $color = isset($mail_data['MstLogo']['color']) ? $mail_data['MstLogo']['color'] : self::DEFAULT_COLOR;
            $disclaimer = isset($mail_data['MstLogo']['disclaimer']) ? $mail_data['MstLogo']['disclaimer'] : '';
            if(isset($this->findCompanyName($org_id)['Company']['comp_name']) && empty($this->findCompanyName($org_id)['Company']['comp_name']))
                throw new Exception ('Company Name not found');
            $company_name = $this->findCompanyName($org_id)['Company']['comp_name'];
            
            return ['status' => true,'logo' =>$org_logo,'mail_body' =>$mail_body,'color' =>$color,'disclaimer' =>$disclaimer,'company_name'=> $company_name,'mail_tags'=>$mail_tags,'url'=>$poject_url];
        } catch (Exception $ex) {
           return  ['status' => false,'messsage' => $ex->getMessage()];
        }
    }

}