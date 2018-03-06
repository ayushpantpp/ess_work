<?php

/*
 * Property of Eastern Software Systems Pvt. Ltd.
 * Should be modified on by a Cake PHP Professional
 *  ******************************************************************************
 *  Description of Imports_controller.php
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

class SetupController extends AppController {

    var $name = 'Setup';
    
    public $components = array('Auth', 'Session', 'Email', 'Cookie', 'RequestHandler');
    
    var $uses = array('MstVehicalMaster', 'MstOrg', 'Company', 'OraOrgHcmSal', 'MstEmpLeave', 'SalComponet', 'Holiday', 'OracleHcmEmpLoan', 'OracleHcmEmpPrf', 'DependentDetails', 'OraOrgHcmSalary', 'FinancialYear', 'OracleOrgHcmSalary', 'EmpInvest', 'EmpInvestDtl', 'OracleHcmItProc', 'OraHcmItProc', 'OracleHcmEmpLta', 'OraHcmEmpLta', 'OraDataTransferSync', 'LeaveEncsh', 'LeaveEncshDt', 'LtaBalance', 'OraDataInfo', 'GeneralOracle', 'General', 'OracleHcmEmpLeave', 'OracleHcmEmpLeaveEncsh', 'OraHcmEmpLeaveEncshDtl', 'OraHcmEmpLeaveEncsh', 'OraHcmMonEsiDed', 'OraHcmMonLoanDed', 'OraHcmMonPfDed', 'OraHcmMonProfsnlDed', 'OraHcmMonSuperDed', 'OraHcmMonTaxDed', 'OraHcmDed', 'HcmDed', 'InvestDtl', 'OraHcmInvestDtl', 'WfMstAppMapLvl', 'SectDtl', 'OraHcmSectDtl', 'MyProfile', 'UserDetail', 'Leave', 'Ticker', 'Icon', 'LeaveGrp', 'Department', 'MstEmpLeaveAllot', 'OraDsAtt', 'OraHcmSetup', 'Options', 'OptionAttribute', 'Ora', 'OraAppDept', 'OraHcmEmpSal', 'OraHcmSalProc', 'OraHcmSalProcSal', 'OraHcmSalProcDed', 'OraHcmEmpLeave', 'OraHcmEmpLeaveGrp', 'OraHcmTimeMoveEditDtl', 'SalaryDetail', 'SalaryProcessing', 'SalaryProcessingAddition', 'SalaryProcessingDeduction', 'WfDtAppMapLvl', 'OrgHcmDesgPrf', 'OraOrgHcmDesgPrf', 'HcmDesgPrf', 'OraHcmDesgPrf', 'AttendanceDetail', 'OraHcmGrpLtaSal', 'LtaSal', 'LtaLeave', 'OraHcmLtaLeave', 'OraHcmLeaveGroup', 'LtaGroup', 'EmpEdu', 'EmpExp', 'EmployeeSalMon', 'EmployeeSalMonDt', 'OracleHcmEmpSalMon', 'OraHcmEmpSalMon', 'AttributeType', 'ImportLog', 'OracleHcmDependantDtl', 'OracleHcmEmpExp', 'LeaveDetail');
    
    public $helpers = array('Js', 'Html', 'Form', 'Session', 'Userdetail');

    function beforeFilter() {
        parent::beforeFilter();
        $this->autoRender = false;
        $this->Auth->allow();
        ini_set('memory_limit', '-1');
        ini_set('max_execution_time', 20000);
    }

    function index() {
        $this->autoRender = true;
        $this->layout = 'admin_setup';
    }

    public function check_connection() {
        $exp1 = ConnectionManager::getDataSource('ora');
        $exp2 = ConnectionManager::getDataSource('app');
        if (!$exp1->isConnected()) {
            echo '<p><span class="notice-failure">Not able to connect to the database HCM. Please Check Database.php Config</span></p></br>';
        } else {
            echo '<p><span class="notice-failure">Connected to the database HCM.</span></p></br>';
        }
        if (!$exp2->isConnected()) {
            echo '<p><span class="notice-failure">Not able to connect to the database APP. Please Check Database.php Config</span></p></br>';
        } else {
            echo '<p><span class="notice-failure">Connected to the database APP.</span></p> </br>';
        }

        if (!$exp1->isConnected() && !$exp2->isConnected()) {
            echo '<p><span class="notice-failure">Not able to connect to the database. Please Check Database.php Config</span></p>';
        } else {
            echo '<p><span class="notice-failure">Connect to the database.</span></p>';
        }
    }

    function import_data() {
       // Configure::write('debug',2);
        $this->autoRender = false;
        
        $exp = new Model(array('table' => 'ORG', 'ds' => 'app', 'name' => 'ORG'));
        $oracle_data = $exp->find('all', array('order' => array('org_type')));
       // print_r($oracle_data); die;
        foreach ($oracle_data as $key => $val) {
            if ($val['ORG']['org_active'] == 'Y') {
                $status = 1;
            } else {
                $status = 0;
            }
            if ($val['ORG']['org_id_parent_l0'] == '') {
                $data['org_name'] = $val['ORG']['org_desc'];
                $data['org_alias'] = $val['ORG']['org_alias'];
                $data['org_id'] = $val['ORG']['org_id'];
                $data['created_at'] = date('Y-m-d', strtotime($val['ORG']['usr_id_create_dt']));
                $data['org_cld_id'] = $val['ORG']['org_cld_id'];
                $data['org_type'] = $val['ORG']['org_type'];
                $data['status'] = $status;
                $this->MstOrg->create();
                if($this->MstOrg->save($data)){

                $comp_data['mst_org_id'] = $this->MstOrg->getLastInsertID();
                $comp_data['comp_code'] = $val['ORG']['org_id'];
                $comp_data['comp_name'] = $val['ORG']['org_desc'];
                $comp_data['org_alias'] = $val['ORG']['org_alias'];
                $comp_data['status'] = $status;
                $comp_data['cld_id'] = $val['ORG']['org_cld_id'];
                $comp_data['org_id'] = $val['ORG']['org_id'];
                $comp_data['ho_org_id'] = '';
                $comp_data['created_at'] = date('Y-m-d', strtotime($val['ORG']['usr_id_create_dt']));
                $this->Company->create();
                $this->Company->save($comp_data);
                }
            } else {
                $id = $this->MstOrg->find('first', array('fields' => array('id', 'org_id'), 'conditions' => array('org_id' => $val['ORG']['org_id_parent_l0'])));
                $comp_data['mst_org_id'] = $id['MstOrg']['id'];
                $comp_data['comp_code'] = $val['ORG']['org_id'];
                $comp_data['comp_name'] = $val['ORG']['org_desc'];
                $comp_data['org_alias'] = $val['ORG']['org_alias'];
                $comp_data['status'] = $status;
                $comp_data['cld_id'] = $val['ORG']['org_cld_id'];
                $comp_data['org_id'] = $val['ORG']['org_id'];
                $comp_data['ho_org_id'] = $val['ORG']['org_id_parent_l0'];
                $comp_data['created_at'] = date('Y-m-d', strtotime($val['ORG']['usr_id_create_dt']));
                $this->Company->create();
                $this->Company->save($comp_data);
            }
        }
        $data_log['function_name'] = 'import_org';
        $data_log['module_related'] = 'SALARY';
        $data_log['last_run'] = date('Y-m-d');
        $data_log['status'] = 1;
        if($this->ImportLog->save($data_log))
        {
        echo "Check 1 Imported Company Data <br>";
        }
        else{
                 echo "Error  Company Data Not Imported";
        }
    
        /*$this->import_users();*/
    }

    function import_users() {
        $this->autoRender = false;
        $data_oracle = $this->Ora->find('all', array('conditions' => array('wrk_stat' => 32)));
        $name = 'hcm$emp$ded';
        $nameb = 'hcm$ded';
        $empded = 'hcm$emp$ded';
        $hcmded = 'hcm$ded';
        $nou = 0;
        foreach ($data_oracle as $k => $v) {
            $data['emp_pay_mode'] = $v['Ora']['emp_pay_mode'];
            $data['emp_code'] = $v['Ora']['emp_code'];
            $data['emp_id'] = $v['Ora']['emp_id'];
            $data['dept_code'] = $v['Ora']['emp_dept_id'];
            $data['desg_code'] = $v['Ora']['emp_desg_id'];
            $data['comp_code'] = $v['Ora']['org_id'];
            $data['gender'] = $v['Ora']['emp_gen'];
            $data['contact'] = $v['Ora']['emp_phone1'];
            $data['personal_phone'] = $v['Ora']['emp_phone2'];
            $data['dob'] = $v['Ora']['emp_dob'];
            $data['join_date'] = $v['Ora']['emp_doj'];
            $data['cur_address'] = $v['Ora']['emp_curr_add'];
            $data['per_address'] = $v['Ora']['emp_perm_add'];
            $data['marital_code'] = $v['Ora']['emp_mrtl_stat'];
            $data['blood_group'] = $v['Ora']['emp_bld_grp'];
            $data['card_no'] = $v['Ora']['emp_card_no'];
            $data['location_code'] = $v['Ora']['emp_loc_id'];
            $data['emp_pay_mode'] = $v['Ora']['emp_pay_mode'];
            $data['bank_code'] = $v['Ora']['emp_bnk_id'];
            $data['branch_code'] = $v['Ora']['bnk_brnch_id'];
            $data['account_type'] = $v['Ora']['acc_type'];
            $data['account_no'] = $v['Ora']['acc_no'];
            $data['ifsc_code'] = $v['Ora']['ifsc_code'];
            $data['swift_code'] = $v['Ora']['swift_code'];
            $data['pan_no'] = $v['Ora']['emp_pan_no'];
            $data['guardian_name'] = $v['Ora']['emp_guard_nm'];
            $data['guardian_relation'] = $v['Ora']['emp_rel'];
            $data['notice_period'] = $v['Ora']['emp_notice'];
            $data['manager_code'] = $v['Ora']['mgr_code'];
            $data['emp_grp_id'] = $v['Ora']['emp_grp_id'];
            $data['doc_id'] = $v['Ora']['doc_id'];
            $data['emp_full_name'] = $v['Ora']['emp_nm'];
            $data['emp_middle'] = $v['Ora']['emp_nm_2'];
            $data['status'] = $v['Ora']['wrk_stat'];
            $data['emp_nm_ttl'] = $v['Ora']['emp_nm_ttl'];
            $data['per_email'] = $v['Ora']['ofc_email'];
            $data['grd_id'] = $v['Ora']['grd_id'];
            $data['notch_id'] = $v['Ora']['notch_id'];
            $doc_id = $v['Ora']['doc_id'];
            $q = "SELECT A.MISC_DOC_NO DOC_NUMBER
            FROM $name A, $nameb B
            WHERE A.CLD_ID = B.CLD_ID
            AND A.SLOC_ID = B.SLOC_ID
            AND A.HO_ORG_ID = B.HO_ORG_ID
            AND A.ORG_ID = B.ORG_ID
            AND A.DED_DOC_ID = B.DOC_ID
            AND B.DED_DESC = 'PF'
			AND EMP_DOC_ID= '$doc_id'";
            $qn = "SELECT A.MISC_DOC_NO DOC_NUMBER FROM $empded A , $hcmded B WHERE A.CLD_ID = B.CLD_ID AND A.SLOC_ID = B.SLOC_ID AND A.HO_ORG_ID = B.HO_ORG_ID AND A.ORG_ID = B.ORG_ID AND A.DED_DOC_ID = B.DOC_ID AND B.DED_DESC = 'ESI' AND EMP_DOC_ID= '$doc_id'";

            $db = ConnectionManager::getDataSource('ora');
            $myData = $db->query($q);
            $myData1 = $db->query($qn);

            if (!empty($myData)) {
                $data['pf_no'] = $myData[0]['A']['doc_number'];
            }
            if (!empty($myData1)) {
                if ($myData1[0]['A']['doc_number'] != '') {
                    $data['ess_no'] = $myData1[0]['A']['doc_number'];
                } else {
                    $data['ess_no'] = '';
                }
            }

            $user = explode(' ', trim($v['Ora']['emp_nm']));
            if ($user[0] == 'Mr.' || $user[0] == 'Ms.' || $user[0] == 'Mrs.') {
                $data['emp_firstname'] = $user[1];
                if (sizeof($user) >= 2) {
                    $data['emp_lastname'] = $user[sizeof($user) - 1];
                }
            } else {
                $data['emp_firstname'] = $user[0];
                if (sizeof($user) >= 2) {
                    $data['emp_lastname'] = $user[sizeof($user) - 1];
                }
            }
            $data_user['emp_code'] = $v['Ora']['emp_code'];
            $data_user['emp_id'] = $v['Ora']['emp_id'];
            $data_user['email'] = $v['Ora']['emp_email'];
            $data_user['comp_code'] = $v['Ora']['org_id'];
            $data_user['user_password'] = 'b5bfd997acb37317902ded4df5e7bfdb31df2b7d';
            $data_user['user_name'] = $data['emp_firstname'];
            if (isset($data['emp_lastname'])) {
                $data_user['user_name'] .= '.' . $data['emp_lastname'];
            }
            $emp_codes = $this->MyProfile->find('list', array(
                'fields' => array('emp_code')
            ));
            if (in_array($v['Ora']['emp_code'], $emp_codes)) {
                $id = $this->MyProfile->find('first', array(
                    'conditions' => array(
                        'emp_code' => $v['Ora']['emp_code'],
                    )
                ));
                $this->MyProfile->id = $id['MyProfile']['id'];
                $this->MyProfile->save($data);

                $userId = $this->UserDetail->find('first', array(
                    'conditions' => array(
                        'emp_code' => $v['Ora']['emp_code'],
                    )
                ));
                if ($userId) {
                    unset($data_user['user_password']);

                    $this->UserDetail->id = $userId['UserDetail']['id'];
                    $this->UserDetail->save($data_user);
                } else {
                    $this->UserDetail->create();
                    $this->UserDetail->save($data_user);
                }
            } else {
                $this->MyProfile->create();
                $this->MyProfile->save($data);
                $this->UserDetail->create();
                $this->UserDetail->save($data_user);
                $data_log['function_name'] = 'import_users';
                $data_log['module_related'] = 'User Profile';
                $data_log['last_run'] = date('Y-m-d');
                $data_log['status'] = 1;
            $imp=$this->ImportLog->save($data_log);
               
            }
        }
         if($imp)
                {
                     echo "Check 2 Imported Users Data <br>";
                }
                else{

                       echo "Check 2  Users Data Does not imported <br>";
                }
       
        
        /*$this->import_attribute_type();*/
    }

    function import_attribute_type() {
        $this->autoRender = false;
        $this->General->query('SET FOREIGN_KEY_CHECKS = 0');
        $this->General->query('TRUNCATE attribute_type');
        $this->General->query('SET FOREIGN_KEY_CHECKS = 1');
        $hcm_ds_att_type = new Model(array('table' => 'HCM$DS$ATT$TYPE', 'ds' => 'ora', 'name' => 'HCMDSATTTYPE'));
        $data_oracle = $hcm_ds_att_type->find('all');
        foreach ($data_oracle as $k => $v) {
            $data['name'] = $v['HCMDSATTTYPE']['att_type_nm'];
            if ($v['HCMDSATTTYPE']['att_type_actv'] == 'Y') {
                $data['at_status'] = 1;
            } else {
                $data['at_status'] = 0;
            }
            $data['att_type_id'] = $v['HCMDSATTTYPE']['att_type_id'];
            $this->AttributeType->create();
            $this->AttributeType->save($data);
        }
        $data_log['function_name'] = 'import_attribute_type';
        $data_log['module_related'] = 'User Settings';
        $data_log['last_run'] = date('Y-m-d');
        $data_log['status'] = 1;
        if($this->ImportLog->save($data_log))
        {
        echo "Check 3: Imported Attribute Data <br>";
    }

else{
     echo "Check 3: Attribute Data does not Imported  <br>";
}
        $this->import_options();
    }

    function import_options() {
        $this->autoRender = false;
        $data_oracle = $this->OraDsAtt->find('all');
        $this->General->query('SET FOREIGN_KEY_CHECKS = 0');
        $this->General->query('TRUNCATE options');
        $this->General->query('SET FOREIGN_KEY_CHECKS = 1');
        foreach ($data_oracle as $k => $v) {
            $data['id'] = $v['OraDsAtt']['att_id'];
            $data['name'] = $v['OraDsAtt']['att_nm'];
            $data['opt_status'] = 1;
            $attribute_id = $this->AttributeType->find('first',array('conditions' => 
                array('AttributeType.att_type_id' => $v['OraDsAtt']['att_type_id'])
                ));
            $data['attribute_type_id'] = $attribute_id['AttributeType']['id'];
            $desg_ids = $this->Options->find('list', array(
                'fields' => array('id')
            ));
            if (in_array($v['OraDsAtt']['att_id'], $desg_ids)) {
                $id = $this->Options->find('first', array(
                    'conditions' => array(
                        'Options.id' => $v['OraDsAtt']['att_id'],
                    )
                ));
                $this->Options->id = $id['Options']['id'];
                $this->Options->save($data);
            } else {
                $this->Options->create();
                $this->Options->save($data);
                $data_log['function_name'] = 'import_options';
                $data_log['module_related'] = 'Setting Options';
                $data_log['last_run'] = date('Y-m-d');
                $data_log['status'] = 1;
               $imp=$this->ImportLog->save($data_log);
             

            }
        }
        if($imp)
        {
         echo "Check 3:Imported Option Data <br>";  
        }
        else{
               echo "Check 3: Option Data Not Imported <br>";  
        }
       
        $this->import_options_attr();
    }

    function import_options_attr() {
        $this->autoRender = false;
        $this->General->query('TRUNCATE option_attribute');
        $this->General->query('SET FOREIGN_KEY_CHECKS = 0');
        $this->General->query('TRUNCATE mst_leave_type');
        $data_oracle = $this->OraHcmSetup->find('all');
        foreach ($data_oracle as $k => $v) {
            $data_id = $data['id'] = $v['OraHcmSetup']['param_id'];
            $data_name = $data['name'] = $v['OraHcmSetup']['param_desc'];
            $option_id = $this->Options->find('first', array('conditions' => array('Options.id' => $v['OraHcmSetup']['param_type'])));
            $data_options_id = $data['options_id'] = $v['OraHcmSetup']['param_type'];
            $data_sloc_id = $data['sloc_id'] = $v['OraHcmSetup']['sloc_id'];
            $data_cld_id = $data['cld_id'] = $v['OraHcmSetup']['cld_id'];
            $data_ho_org_id = $data['ho_org_id'] = $v['OraHcmSetup']['ho_org_id'];
            $data_leave['leave_code'] = $data['id'];
            $data_leave['org_id'] = $v['OraHcmSetup']['ho_org_id'];
            $data_leave['leave_name'] = $data['name'];
            $data_leave['status'] = '1';
            $desg_ids = $this->OptionAttribute->find('list', array(
                'fields' => array('id')
            ));
            $this->OptionAttribute->create();
            $this->OptionAttribute->query("insert into option_attribute (id,name,options_id,sloc_id,cld_id,ho_org_id) values ('$data_id','$data_name','$data_options_id','$data_sloc_id','$data_cld_id','$data_ho_org_id')");
            if ($v['OraHcmSetup']['param_type'] == '21') {
                $this->Leave->create();
                $this->Leave->save($data_leave);
            }
        }
            $data_log['function_name'] = 'import_options_attr';
            $data_log['module_related'] = 'User Settings';
            $data_log['last_run'] = date('Y-m-d');
            $data_log['status'] = 1;
            if($this->ImportLog->save($data_log))
            {
            echo "Check 3:Imported Option Attr Data <br>";
        }
        else{
              echo "Check 3:  Option Attr Data Does not Imported <br>";

        }
            
            $this->org_hcm_setup();
    }

    function org_hcm_setup() {
        $this->autoRender = false;
        $this->General->query('SET FOREIGN_KEY_CHECKS = 0');
        $this->General->query('TRUNCATE option_attribute_org');
        $hcm_org_setup = new Model(array('table' => 'ORG$HCM$SETUP', 'ds' => 'ora', 'name' => 'ORGHCMSETUP'));
        $data_oracle = $hcm_org_setup->find('all');
        $org_setup = new Model(array('table' => 'option_attribute_org', 'ds' => 'default', 'name' => 'orgsetup'));
        foreach ($data_oracle as $k => $v) {
            $data_param_id = $data['param_id'] = $v['ORGHCMSETUP']['param_id'];
            $data_sloc_id = $data['sloc_id'] = $v['ORGHCMSETUP']['sloc_id'];
            $data_cld_id = $data['cld_id'] = $v['ORGHCMSETUP']['cld_id'];
            $data_ho_org_id = $data['ho_org_id'] = $v['ORGHCMSETUP']['ho_org_id'];
            $data_org_id = $data['org_id'] = $v['ORGHCMSETUP']['org_id'];
            $created_at = date('Y-m-d');
            $modify = date('Y-m-d');
            $org_setup->query("insert into option_attribute_org (sloc_id,cld_id,ho_org_id,org_id,param_id,created_at,modify) values ('$data_sloc_id','$data_cld_id','$data_ho_org_id','$data_org_id','$data_param_id','$created_at','$modify')");
        }
            $data_log['function_name'] = 'org_hcm_setup';
            $data_log['module_related'] = 'HCM SETUP';
            $data_log['last_run'] = date('Y-m-d');
            $data_log['status'] = 1;
            if($this->ImportLog->save($data_log))
            {

            echo "Check 3: Imported Setup Data <br>";
}
else{
    echo "Check 3: Setup Data  not Imported <br>";
}
            $this->import_departments();
        }

    function import_departments() {
        $data_oracle = $this->OraAppDept->find('all');
        $this->General->query('SET FOREIGN_KEY_CHECKS = 0');
        $this->General->query('TRUNCATE departments');
        foreach ($data_oracle as $k => $v) {
            $data = array();
            $data['Department']['dept_code'] = $v['OraAppDept']['dept_id'];
            $name = str_replace(' ', '_', $v['OraAppDept']['dept_nm']);
            $data['Department']['dept_name'] = $v['OraAppDept']['dept_nm'];
            $data['Department']['comp_code'] = $v['OraAppDept']['ho_org_id'];
            $data['Department']['status'] = '1';
            $comp_code = $v['OraAppDept']['ho_org_id'];
            $dept_id = $v['OraAppDept']['dept_id'];
            $dept_name = $v['OraAppDept']['dept_nm'];
            $this->Department->create(false);
            $this->Department->query("insert into departments (comp_code,dept_code,dept_name,status) values ('$comp_code','$dept_id','$dept_name',1)");
        }
            $data_log['function_name'] = 'import_departments';
            $data_log['module_related'] = 'DEPATMENTS';
            $data_log['last_run'] = date('Y-m-d');
            $data_log['status'] = 1;
            if($this->ImportLog->save($data_log))
            {
            echo "Check 3: Imported Department Data <br>";
        }
        else{
             echo "Check 3: Department Data Does Not Imported <br>";
        }

            /*$this->import_leaves();///*/
    }

    public function import_leaves() {
        $this->autoRender = false;
        $this->General->query('SET FOREIGN_KEY_CHECKS = 0');
        $this->General->query('TRUNCATE mst_emp_leave_allot');
        $data_oracle = $this->OraHcmEmpLeave->find('all');
        $ctr = 0;
        foreach ($data_oracle as $k => $v) {
            $data_leave_code = $v['OraHcmEmpLeave']['leave_id'];
            $data_emp_code = $v['OraHcmEmpLeave']['emp_code'];
            $data_org_id = $v['OraHcmEmpLeave']['ho_org_id'];
            $data_leave_year = $v['OraHcmEmpLeave']['leave_year'];
            $data_leave_bal = $v['OraHcmEmpLeave']['leave_bal'];
            $data_leave_accrual_rate = $v['OraHcmEmpLeave']['leave_accrual_rate'];
            $data_created = $v['OraHcmEmpLeave']['usr_id_create_dt'];
            $data_modified = $v['OraHcmEmpLeave']['usr_id_mod_dt'];
            $data_leave_op = $v['OraHcmEmpLeave']['leave_op'];
            $present_data = $this->MstEmpLeaveAllot->find('first', array('conditions' => array('emp_code' => $v['OraHcmEmpLeave']['emp_code'], 'leave_code' => $v['OraHcmEmpLeave']['leave_id'])));
            if ($present_data) {
                $this->MstEmpLeaveAllot->id = $present_data['MstEmpLeaveAllot']['id'];
                $this->MstEmpLeaveAllot->save($data_leave_op);
            } else {
                $this->MstEmpLeaveAllot->create();
                $this->MstEmpLeaveAllot->query("insert into mst_emp_leave_allot (leave_code,emp_code,org_id,leave_year,leave_bal,allot_leave,leave_accrual_rate,created_date,modified,leave_op) values ('$data_leave_code','$data_emp_code','$data_org_id','$data_leave_year','$data_leave_bal','$data_leave_bal','$data_leave_accrual_rate','$data_created','$data_modified','$data_leave_op')");
            }
        }
            $data_log['function_name'] = 'import_leaves';
            $data_log['module_related'] = 'LEAVE';
            $data_log['last_run'] = date('Y-m-d');
            $data_log['status'] = 1;
            if($this->ImportLog->save($data_log))
            {
            echo "Check 4: Imported Leave Data <br>";
        }
        else
{
   echo "Check 4: Leave Data  Does Not Imported <br>"; 
}


            $this->import_lta();
    }

    function import_lta() {
            $this->autoRender = false;
            $this->General->query('SET FOREIGN_KEY_CHECKS = 0');
            $this->General->query('TRUNCATE lta_balance');
            $data_oracle = new Model(array('table' => 'HCM$EMP$LTA', 'ds' => 'ora', 'name' => 'HCMEMPLTA'));
            $data_lta = $data_oracle->find('all');
            $ctr = 0;
            foreach ($data_lta as $k => $v) {
                $emp_cd = $this->MyProfile->find('first', array(
                    'conditions' => array(
                        'emp_code' => $v['HCMEMPLTA']['emp_code'],
                        'comp_code' => $v['HCMEMPLTA']['org_id']
                    ),
                    'fields' => array('emp_id')
                ));
                $data['emp_id'] = $emp_cd['MyProfile']['emp_id'];
                $data['lta_years'] = $v['HCMEMPLTA']['lta_bal'];
                $this->LtaBalance->create();
                $this->LtaBalance->save($data);
            }
            $data_log['function_name'] = 'import_lta';
            $data_log['module_related'] = 'LTA IMPORT';
            $data_log['last_run'] = date('Y-m-d');
            $data_log['status'] = 1;
            if($this->ImportLog->save($data_log))
            {
                echo "Check 4: Imported Leave Group Data <br>";

            }
            else{
                echo "Check 4: Leave Group Data  Does Not Imported <br>";
            }
            $this->import_leave_groups();
            
    }

    function import_leave_groups() {
            $this->autoRender = false;
            $this->General->query('SET FOREIGN_KEY_CHECKS = 0');
            $this->General->query('TRUNCATE lta_group');
            $data_oracle = $this->OraHcmEmpLeaveGrp->find('all');
            $ctr = 0;
            foreach ($data_oracle as $k => $v) {
                $data_org_id = $v['OraHcmEmpLeaveGrp']['org_id'];
                $data_leave_code = $v['OraHcmEmpLeaveGrp']['leave_id'];
                $data_grp_id = $v['OraHcmEmpLeaveGrp']['grp_id'];
                $data_leave_accrual_rate = $v['OraHcmEmpLeaveGrp']['leave_accrual_rate'];
                $data_carry_fw_ch = $v['OraHcmEmpLeaveGrp']['carry_fwd_ch'];
                $data_leave_proof_ch = $v['OraHcmEmpLeaveGrp']['leave_proof_ch'];
                $data_leave_encash_limit = $v['OraHcmEmpLeaveGrp']['leave_encash_limit'];
                $data_leave_encash_ch = $v['OraHcmEmpLeaveGrp']['leave_encash_ch'];
                $data_leav_max_limit = $v['OraHcmEmpLeaveGrp']['leave_max_limit'];
                $data_mtrnty_leave_check = $v['OraHcmEmpLeaveGrp']['mtrnty_leave_chk'];
                $data_mtrnty_leave_days = $v['OraHcmEmpLeaveGrp']['mtrnty_leave_days'];
                $this->LeaveGrp->create();
                $this->LeaveGrp->query("insert into leave_grp (org_id, leave_code, grp_id, leave_accrual_rate, carry_fwd_ch, leave_proof_ch, leave_encash_limit, leave_encash_ch, leave_max_limit,mtrnty_leave_chk, mtrnty_leave_days) values ('$data_org_id','$data_leave_code','$data_grp_id','$data_leave_accrual_rate','$data_carry_fw_ch','$data_leave_proof_ch','$data_leave_encash_limit','$data_leave_encash_ch','$data_leav_max_limit','$data_mtrnty_leave_check','data_mtrnty_leave_days')");
            }
            $data_log['function_name'] = 'import_leave_groups';
            $data_log['module_related'] = 'LEAVE GROUP';
            $data_log['last_run'] = date('Y-m-d');
            $data_log['status'] = 1;
            if($this->ImportLog->save($data_log))
            {
                echo "Check 4:Imported Desg Level Data <br>";
            }
            else{
            echo "Check 4:  Level Data  Does Not Imported <br>";
        }
        $this->import_desg_levels();
    }

    public function import_desg_levels() {
        $this->autoRender = false;
        $this->General->query('SET FOREIGN_KEY_CHECKS = 0');
        $this->General->query('TRUNCATE hcm_desg_prf');
        $data_oracle = $this->OraHcmDesgPrf->find('all');
        $ctr = 0;
        $final_arr = array();
        foreach ($data_oracle as $k => $v) {
            $desg_ids = $this->HcmDesgPrf->find('list', array(
                'fields' => array('desg_id')
            ));

            $data = $v['OraHcmDesgPrf'];
            if (in_array($v['OraHcmDesgPrf']['desg_id'], $desg_ids)) {
                $found = $this->HcmDesgPrf->find('first', array(
                    'conditions' => array(
                        'desg_id' => $v['OraHcmDesgPrf']['desg_id'],
                    )
                ));
                if (!empty($found)) {
                    if ($found['HcmDesgPrf']['valid_strt_dt'] < $data['valid_strt_dt']) {
                        $this->HcmDesgPrf->id = $found['HcmDesgPrf']['id'];
                        $final_arr[] = $data;
                        $this->HcmDesgPrf->save($data);
                    } else {
                        continue;
                    }
                }
            } else {
                $this->HcmDesgPrf->create();
                $final_arr[] = $data;
                $this->HcmDesgPrf->save($data);
            }
        }

        $final_arr2 = array();
        foreach ($final_arr as $v) {
            if ($v['rptg_desg_id'] == null) {
                $final_arr2[] = $v;
            }
        }


        for ($i = 0; $i < sizeof($final_arr2); $i++) {
            $last = $final_arr2[sizeof($final_arr2) - 1];
            foreach ($final_arr as $v) {
                if ($v['rptg_desg_id'] == $last['desg_id']) {
                    $final_arr2[] = $v;
                    break;
                }
            }
        }

        $final_arr2 = array_reverse($final_arr2);

        $apps = $this->WfMstAppMapLvl->find('list', array(
            'fields' => 'wf_app_id'
        ));

        foreach ($apps as $v) {
            $ctr = 0;
            foreach ($final_arr2 as $val) {
                $ctr++;
                $data = array();
                $data['wf_app_map_lvl_id'] = $v;
                $data['lvl_sequence'] = $ctr;
                $data['wf_lvl'] = 'Level' . $ctr;
                $data['wf_dept_id'] = $val['dept_id'];
                $data['wf_desg_id'] = $val['desg_id'];
                $data['created_date'] = date('Y-m-d');
                $data['skip_status'] = 0;
                $data['revoke_level_id'] = 9;
                $this->WfDtAppMapLvl->create();
                $this->WfDtAppMapLvl->save($data);
            }
        }
        $data_log['function_name'] = 'import_desg_levels';
        $data_log['module_related'] = 'DESIGNATION';
        $data_log['last_run'] = date('Y-m-d');
        $data_log['status'] = 1;
        if($this->ImportLog->save($data_log))
        {
        echo "Check 4:LEVEL DATA<br>";
    }
    else{
        echo "Check 4:LEVEL DATA ERROR";
    }

        $this->ticker_and_icons();/////
    }

    public function ticker_and_icons() {
        $departments = $this->Department->find('list', array(
            'fields' => 'id'
                )
        );
        $this->General->query('SET FOREIGN_KEY_CHECKS = 0');
        $this->General->query('TRUNCATE ticker');
        $this->General->query('TRUNCATE icon');
        foreach ($departments as $key => $value) {
            $data['name'] = 'Total Leave';
            $data['status'] = 1;
            $data['department_id'] = $value;
            $data['function_name'] = 'totalLeave';
            $this->Ticker->create();
            $this->Ticker->save($data);
            $data['name'] = 'Travel Voucher Applied';
            $data['status'] = 1;
            $data['department_id'] = $value;
            $data['function_name'] = 'travelVoucherApplied';
            $this->Ticker->create();
            $this->Ticker->save($data);
            $data['name'] = 'Appraisal';
            $data['status'] = 1;
            $data['department_id'] = $value;
            $data['function_name'] = 'totAppraisal';
            $this->Ticker->create();
            $this->Ticker->save($data);
            $data['name'] = 'Leave Pending';
            $data['status'] = 1;
            $data['department_id'] = $value;
            $data['function_name'] = 'leavePen';
            $this->Ticker->create();
            $this->Ticker->save($data);
            $data['name'] = 'Travel Voucher Pending';
            $data['status'] = 0;
            $data['department_id'] = $value;
            $data['function_name'] = 'travelPen';
            $this->Ticker->create();
            $this->Ticker->save($data);
            $data['name'] = 'Training';
            $data['status'] = 0;
            $data['department_id'] = $value;
            $data['function_name'] = 'totTraining';
            $this->Ticker->create();
            $this->Ticker->save($data);
            $data['shortcut_name'] = 'MyProfile';
            $data['status'] = 1;
            $data['department_id'] = $value;
            $data['function_name'] = 'users/myprofile';
            $this->Icon->create();
            $this->Icon->save($data);
            $data['shortcut_name'] = 'Add Leaves';
            $data['status'] = 1;
            $data['department_id'] = $value;
            $data['function_name'] = 'leaves/add';
            $this->Icon->create();
            $this->Icon->save($data);
            $data['shortcut_name'] = 'View Leaves';
            $data['status'] = 1;
            $data['department_id'] = $value;
            $data['function_name'] = 'leaves/view';
            $this->Icon->create();
            $this->Icon->save($data);
            $data['shortcut_name'] = 'Add Travel';
            $data['status'] = 1;
            $data['department_id'] = $value;
            $data['function_name'] = 'travels/trvoucher';
            $this->Icon->create();
            $this->Icon->save($data);
            $data['shortcut_name'] = 'View Travel';
            $data['status'] = 0;
            $data['department_id'] = $value;
            $data['function_name'] = 'travels/view';
            $this->Icon->create();
            $this->Icon->save($data);
            $data['shortcut_name'] = 'Leave Approval';
            $data['status'] = 0;
            $data['department_id'] = $value;
            $data['function_name'] = 'leaves/approval';
            $this->Icon->create();
            $this->Icon->save($data);
        }
        $data_log['function_name'] = 'ticker_and_icons';
        $data_log['module_related'] = 'SETUP TICKER';
        $data_log['last_run'] = date('Y-m-d');
        $data_log['status'] = 1;
        if($this->ImportLog->save($data_log))
        {


        echo "Check 4: Imported ICON AND TICKER Data <br>";
    }
    else{
        echo "Check 4:  ICON AND TICKER Data Does Not Imported <br>";
        /*$this->import_attendance();*/
    }
        

    }

    public function import_attendance() {
        
        $this->General->query('SET FOREIGN_KEY_CHECKS = 0');
        $this->General->query('TRUNCATE attendance_details');
        $n = '$';
        $table = 'HCM' . $n . 'TIME' . $n . 'MOVE' . $n . 'EDIT' . $n . 'DTL';
         $qn = "SELECT OraHcmTimeMoveEditDtl.hlffay_leave_type, OraHcmTimeMoveEditDtl.cld_id, OraHcmTimeMoveEditDtl.sloc_id, OraHcmTimeMoveEditDtl.ho_org_id, OraHcmTimeMoveEditDtl.org_id, OraHcmTimeMoveEditDtl.emp_doc_id, OraHcmTimeMoveEditDtl.atten_dt, OraHcmTimeMoveEditDtl.leave_id, OraHcmTimeMoveEditDtl.extra_time_hr, OraHcmTimeMoveEditDtl.usr_id_create, OraHcmTimeMoveEditDtl.usr_id_create_dt, OraHcmTimeMoveEditDtl.usr_id_mod, OraHcmTimeMoveEditDtl.usr_id_mod_dt, to_char(OraHcmTimeMoveEditDtl.in_time,'dd-mm-yyyy HH24:MI:SS') as in_time, to_char(OraHcmTimeMoveEditDtl.out_time,'dd-mm-yyyy HH24:MI:SS') as out_time, OraHcmTimeMoveEditDtl.ded_ch, OraHcmTimeMoveEditDtl.wk_off_chk, OraHcmTimeMoveEditDtl.hlfday_leave_chk, OraHcmTimeMoveEditDtl.emp_dept_id, OraHcmTimeMoveEditDtl.emp_grp_id, OraHcmTimeMoveEditDtl.emp_loc_id, OraHcmTimeMoveEditDtl.emp_id, OraHcmTimeMoveEditDtl.add_comp_leave_chk, OraHcmTimeMoveEditDtl.qtr_leave_chk, OraHcmTimeMoveEditDtl.leave_proof_submit_chk, OraHcmTimeMoveEditDtl.prj_doc_id, OraHcmTimeMoveEditDtl.rest_day_chk FROM $table OraHcmTimeMoveEditDtl"; 
        $db = ConnectionManager::getDataSource('ora');
        $myData = $db->query($qn);
        foreach ($myData as $k => $v) {
            
            $data_org = $v['OraHcmTimeMoveEditDtl'];
            $atten_dt = $data_org['atten_dt'];
            if (!empty($v['0']['in_time']) && !empty($v['0']['out_time'])) {
                $data_org['in_time'] = date('Y-m-d H:i:s', strtotime($v['0']['in_time']));
                $data_org['out_time'] = date('Y-m-d H:i:s', strtotime($v['0']['out_time']));
            } else {
                $data_org['in_time'] = date('Y-m-d H:i:s', strtotime($v['0']['in_time']));
                $data_org['out_time'] = date('Y-m-d H:i:s', strtotime($v['0']['out_time']));
            }
            
            $this->AttendanceDetail->create();
            $this->AttendanceDetail->save($data_org);
        
        }
        
        $data_log['function_name'] = 'import_attendance';
        $data_log['module_related'] = 'ATTENDANCE';
        $data_log['last_run'] = date('Y-m-d');
        $data_log['status'] = 1;
        if($this->ImportLog->save($data_log))
        {
        echo "Check 5: Imported Attendance Data <br>";
    }
    else{
        echo "Check 5:  Attendance Data NOT Imported <br>";
    }
        
        /*$this->import_app_eo();*/
    }

    function import_app_eo() {
        $this->autoRender = false;
        $this->General->query('SET FOREIGN_KEY_CHECKS = 0');
        $this->General->query('TRUNCATE oracle_app_eo');
        $eo_model = new Model(array('table' => 'APP$EO', 'ds' => 'app', 'name' => 'OraAppEo'));
        $oracle_data = $eo_model->find('all', array('conditions' => array('eo_type' => 74)));
        $portal_app_eo = new Model(array('table' => 'oracle_app_eo', 'ds' => 'default', 'name' => 'OracleAppEo'));
        foreach ($oracle_data as $val) {
            $data['OracleAppEo'] = $val['OraAppEo'];
            $portal_app_eo->create();
            $portal_app_eo->save($data);
        }
        $data_log['function_name'] = 'import_app_eo';
        $data_log['module_related'] = 'APP ';
        $data_log['last_run'] = date('Y-m-d');
        $data_log['status'] = 1;
        if($this->ImportLog->save($data_log))
        {
             echo "Check 6: Imported Bank Data <br>";
        }
        else{
        echo "Check 6:  Bank Data Not Imported<br>";
}
        $this->import_app_eo_mst();
    }

    function import_app_eo_mst() {
        $this->autoRender = false;
        $this->General->query('SET FOREIGN_KEY_CHECKS = 0');
        $this->General->query('TRUNCATE app_eo_mst');
        $eo_model = new Model(array('table' => 'APP$EO$MST', 'ds' => 'app', 'name' => 'OraAppEoMst'));
        $oracle_data = $eo_model->find('all');
        $portal_app_eo = new Model(array('table' => 'app_eo_mst', 'ds' => 'default', 'name' => 'OracleAppEoMst'));
        foreach ($oracle_data as $val) {
            $data['OracleAppEoMst'] = $val['OraAppEoMst'];
            $portal_app_eo->create();
            $portal_app_eo->save($data);
        }
        $data_log['function_name'] = 'import_app_eo_mst';
        $data_log['module_related'] = 'APP ';
        $data_log['last_run'] = date('Y-m-d');
        $data_log['status'] = 1;
        if($this->ImportLog->save($data_log))
        {
        echo "Check 6: Imported BANK Data MASTER <br>";
}
else{
    echo "Check 6:BANK Data MASTER NOT Imported <br>";
}
        $this->import_fy();
    }

    function import_fy() {
        $this->General->query('SET FOREIGN_KEY_CHECKS = 0');
        $this->General->query('TRUNCATE financial_year');
        $fy_id = new Model(array('table' => 'ORG$FY', 'ds' => 'app', 'name' => 'ORGFY'));
        $oracle_data = $fy_id->find('all');
        foreach ($oracle_data as $fy) {
            $data = array();
            $data['org_id'] = $fy['ORGFY']['org_id'];
            $data['fy_type'] = $fy['ORGFY']['fy_type'];
            $data['fy_desc'] = $fy['ORGFY']['fy_desc'];
            $data['hcm_fy_start'] = $fy['ORGFY']['hcm_fy_strt'];
            $data['hcm_fy_end'] = $fy['ORGFY']['hcm_fy_end'];
            $data['ora_fy_id'] = $fy['ORGFY']['org_fy_id'];
            $this->FinancialYear->create();
            $this->FinancialYear->save($data);
        }
        $data_log['function_name'] = 'import_fy';
        $data_log['module_related'] = 'FINANCIAL YEAR ';
        $data_log['last_run'] = date('Y-m-d');
        $data_log['status'] = 1;
        if($this->ImportLog->save($data_log))
        {
 echo "Check 6: Imported Finacial Year Data <br>";

        }
       else{
         echo "Check 6: Finacial Year Data Not Imported <br>";
       }

        $this->import_dependants();
    }

    function import_dependants() {
        $this->General->query('SET FOREIGN_KEY_CHECKS = 0');
        $this->General->query('TRUNCATE dependent_details');
        $dep = new Model(array('table' => 'HCM$EMP$DPND$DTL', 'ds' => 'ora', 'name' => 'HCMEMPDPNDDTL'));
        $oracle_data = $dep->find('all');
        foreach ($oracle_data as $dy) {
            $data['member_name'] = $dy['HCMEMPDPNDDTL']['mem_nm'];
            $data['relation'] = $dy['HCMEMPDPNDDTL']['mem_rel'];
            $data['occupation'] = $dy['HCMEMPDPNDDTL']['mem_occu'];
            $data['Dob'] = $dy['HCMEMPDPNDDTL']['mem_dob'];
            $data['gender'] = $dy['HCMEMPDPNDDTL']['mem_gen'];
            $myprofile = $this->MyProfile->find('first', array('fields' => array('id'), 'conditions' => array('doc_id' => $dy['HCMEMPDPNDDTL']['doc_id'])));
            $data['myprofile_id'] = $myprofile['MyProfile']['id'];
            $data['status'] = 5;
            $this->DependentDetails->create();
            $this->DependentDetails->save($data);
        }
        $data_log['function_name'] = 'import_dependants';
        $data_log['module_related'] = 'DEPENDENT';
        $data_log['last_run'] = date('Y-m-d');
        $data_log['status'] = 1;
        if($this->ImportLog->save($data_log))
        {
           echo "Check 6:Imported Dependent Data <br>";  
        }
       else{
         echo "Check 6: Dependent Data Not Imported <br>";  
       }
        $this->import_emp_edu();
    }

    function import_emp_edu() {
        $this->General->query('SET FOREIGN_KEY_CHECKS = 0');
        $this->General->query('TRUNCATE emp_edu');
        $edu = new Model(array('table' => 'HCM$EMP$QUAL', 'ds' => 'ora', 'name' => 'HCMEMPQUAL'));
        $oracle_data = $edu->find('all');
        foreach ($oracle_data as $edu) {
            $data['emp_doc_id'] = $edu['HCMEMPQUAL']['doc_id'];
            $data['emp_code'] = $edu['HCMEMPQUAL']['emp_code'];
            $data['course_id'] = $edu['HCMEMPQUAL']['course_id'];
            $data['yop'] = $edu['HCMEMPQUAL']['yop'];
            $data['mark_obtain'] = $edu['HCMEMPQUAL']['mark_obtain'];
            $data['qual_type_id'] = $edu['HCMEMPQUAL']['qual_type_id'];
            $data['ins_nm'] = $edu['HCMEMPQUAL']['ins_nm'];
            $this->EmpEdu->create();
            $this->EmpEdu->save($data);
        }
        $data_log['function_name'] = 'import_emp_edu';
        $data_log['module_related'] = 'EDUCATION EMPLOYEE';
        $data_log['last_run'] = date('Y-m-d');
        $data_log['status'] = 1;
        if($this->ImportLog->save($data_log))
        {
             echo "Check 6:Imported EMP Edu Data <br>";
        }
        else{
             echo "Check 6: EMP Edu Data  Not Imported <br>";
        }
       

        
    }

    function import_holiday() {

        $this->General->query('SET FOREIGN_KEY_CHECKS = 0');
        $this->General->query('TRUNCATE holiday');
        $edu = new Model(array('table' => 'HCM$HOL$CAL', 'ds' => 'ora', 'name' => 'HCMHOLCAL'));
        $oracle_data = $edu->find('all', array('conditions' => array('hol_type in' => array('40', '39'))));
        $hol_loc = new Model(array('table' => 'ORG$HCM$HOL$CAL$LOC', 'ds' => 'ora', 'name' => 'HCMHOLCALLOC'));
        foreach ($oracle_data as $edu) {
            $loc_data = $hol_loc->find('all', array('conditions' => array('hol_id' => $edu['HCMHOLCAL']['hol_id'],
                    'ho_org_id' => $edu['HCMHOLCAL']['ho_org_id'])));
            foreach ($loc_data as $lc) {
                $this->request->data['Holiday']['ho_org_id'] = $edu['HCMHOLCAL']['ho_org_id'];
                $this->request->data['Holiday']['holiday_date'] = date('Y-m-d', strtotime($edu['HCMHOLCAL']['random_hol_dt']));
                $this->request->data['Holiday']['holiday_name'] = $edu['HCMHOLCAL']['hol_desc'];
                $this->request->data['Holiday']['hol_id'] = $edu['HCMHOLCAL']['hol_id'];
                $this->request->data['Holiday']['location_id'] = $lc['HCMHOLCALLOC']['loc_id'];
                $this->request->data['Holiday']['org_id'] = $lc['HCMHOLCALLOC']['org_id'];
                $this->request->data['Holiday']['op_leave'] = 0;
                $this->request->data['Holiday']['status'] = true;
                $this->Holiday->create();
                $this->Holiday->save($this->data);
            }
        }
        $data_log['function_name'] = 'import_emp_edu';
        $data_log['module_related'] = 'EDUCATION EMPLOYEE';
        $data_log['last_run'] = date('Y-m-d');
        $data_log['status'] = 1;
        if($this->ImportLog->save($data_log))
        {
        echo "Check 7:Imported Holiday Data <br>";
    }
    else{
        echo "Check 7: Holiday Data  Not Imported<br>";
    }

        $this->import_emp_exp();
    }

    function import_emp_exp() {
        $this->General->query('SET FOREIGN_KEY_CHECKS = 0');
        $this->General->query('TRUNCATE emp_edu');
        $exp = new Model(array('table' => 'HCM$EMP$Exp', 'ds' => 'ora', 'name' => 'HCMEMPExp'));
        $oracle_data = $exp->find('all');
        foreach ($oracle_data as $edu) {
            $data['emp_doc_id'] = $edu['HCMEMPExp']['doc_id'];
            $data['emp_code'] = $edu['HCMEMPExp']['emp_code'];
            $data['org_id'] = $edu['HCMEMPExp']['org_id'];
            $data['emp_org_nm'] = $edu['HCMEMPExp']['emp_org_nm'];
            $data['emp_org_doj'] = $edu['HCMEMPExp']['emp_org_doj'];
            $data['emp_org_dol'] = $edu['HCMEMPExp']['emp_org_dol'];
            $data['emp_org_desig'] = $edu['HCMEMPExp']['emp_org_desig'];
            $data['emp_org_loc'] = $edu['HCMEMPExp']['emp_org_loc'];
            $this->EmpExp->create();
            $this->EmpExp->save($data);
        }
        $data_log['function_name'] = 'import_emp_exp';
        $data_log['module_related'] = 'EXPERINCE EMPLOYEE';
        $data_log['last_run'] = date('Y-m-d');
        $data_log['status'] = 1;
        if($this->ImportLog->save($data_log))
        {
        echo "Check 7: Imported Leave Group Data <br>";
    }
    else
{

     echo "Check 7:  Leave Group Data Not Imported <br>";
}



        $this->import_section();
    }

    public function import_section() {
        $this->autoRender = false;
        $this->General->query('SET FOREIGN_KEY_CHECKS = 0');
        $this->General->query('TRUNCATE sect_dtl');
        $data_oracle = $this->OraHcmSectDtl->find('all');
        foreach ($data_oracle as $k => $val) {
            $dataSect['org_id'] = $val['OraHcmSectDtl']['ho_org_id'];
            $dataSect['cptr_id'] = $val['OraHcmSectDtl']['cptr_id'];
            $dataSect['sect_id'] = $val['OraHcmSectDtl']['sect_id'];
            $dataSect['sect_max_limit'] = $val['OraHcmSectDtl']['sect_max_limit'];
            $dataSect['ho_org_id'] = $val['OraHcmSectDtl']['ho_org_id'];
            $dataSect['valid_strt_dt'] = $val['OraHcmSectDtl']['valid_strt_dt'];
            $dataSect['valid_end_dt'] = $val['OraHcmSectDtl']['valid_end_dt'];
            $dataSect['remark'] = $val['OraHcmSectDtl']['remark'];
            $get_id = $this->FinancialYear->find('first', array('fields' => array('id'), 'conditions' => array('org_id' => $val['OraHcmSectDtl']['ho_org_id'], 'ora_fy_id' => $val['OraHcmSectDtl']['fy_id'])));
            $dataSect['fy_id'] = $get_id['FinancialYear']['id'];
            $this->SectDtl->Create();
            $this->SectDtl->save($dataSect);
        }
        $data_log['function_name'] = 'import_section';
        $data_log['module_related'] = 'ATTENDANCE';
        $data_log['last_run'] = date('Y-m-d');
        $data_log['status'] = 1;
        if($this->ImportLog->save($data_log))
        {
        echo "Check 7: Imported Leave Group Data <br>";
    }
    else
{
 echo "Check 7:Leave Group Data Not Imported <br>";

}





        $this->import_invest_dtl();
    }

    function import_invest_dtl() {
        $this->autoRender = false;
        $this->General->query('SET FOREIGN_KEY_CHECKS = 0');
        $this->General->query('TRUNCATE invest_dtl');
        $data_oracle = $this->OraHcmInvestDtl->find('all');

        foreach ($data_oracle as $k => $val) {
            $datainvest['valid_strt_dt'] = $val['OraHcmInvestDtl']['valid_strt_dt'];
            $datainvest['valid_end_dt'] = $val['OraHcmInvestDtl']['valid_end_dt'];
            $datainvest['doc_req_chk'] = $val['OraHcmInvestDtl']['doc_req_chk'];
            $datainvest['max_limit_rule'] = $val['OraHcmInvestDtl']['sect_max_limit'];
            $datainvest['max_limit_chk'] = $val['OraHcmInvestDtl']['ho_org_id'];
            $datainvest['org_id'] = $val['OraHcmInvestDtl']['ho_org_id'];
            $datainvest['sect_id'] = $val['OraHcmInvestDtl']['sect_id'];
            $datainvest['invest_id'] = $val['OraHcmInvestDtl']['invest_id'];
            $datainvest['invest_max_limit'] = $val['OraHcmInvestDtl']['invest_max_limit'];
            $datainvest['max_limit_perc'] = $val['OraHcmInvestDtl']['max_limit_perc'];
            $datainvest['remark'] = $val['OraHcmInvestDtl']['remark'];
            $datainvest['exmp_chk'] = $val['OraHcmInvestDtl']['exmp_chk'];
            $get_id = $this->FinancialYear->find('first', array('fields' => array('id'), 'conditions' => array('org_id' => $val['OraHcmInvestDtl']['ho_org_id'], 'ora_fy_id' => $val['OraHcmInvestDtl']['fy_id'])));
            $datainvest['fy_id'] = $get_id['FinancialYear']['id'];
            $datainvest['hover_description'] = $val['OraHcmInvestDtl']['remark'];
            $this->InvestDtl->Create();
            $this->InvestDtl->save($datainvest);
        }
        $data_log['function_name'] = 'import_invest_dtl';
        $data_log['module_related'] = 'INVESTMENT';
        $data_log['last_run'] = date('Y-m-d');
        $data_log['status'] = 1;
        if($this->ImportLog->save($data_log))
        {
        echo "Check 7: Imported Invest Detail <br>";
        }
        else{
           echo "Check 7: Invest Detail  Not Imported <br>";  
        }
        $this->import_lta_grp_sal();
    }

    function import_lta_grp_sal() {
        $this->autoRender = false;
        $this->General->query('SET FOREIGN_KEY_CHECKS = 0');
        $this->General->query('TRUNCATE lta_sal');
        $data_oracle = $this->OraHcmGrpLtaSal->find('all');
        foreach ($data_oracle as $k => $val) {
            $dataltagrpsal['org_id'] = $val['OraHcmGrpLtaSal']['ho_org_id'];
            $dataltagrpsal['grp_id'] = $val['OraHcmGrpLtaSal']['grp_id'];
            $dataltagrpsal['sal_id'] = $val['OraHcmGrpLtaSal']['sal_id'];
            $dataltagrpsal['usr_id_create'] = $val['OraHcmGrpLtaSal']['usr_id_create'];
            $dataltagrpsal['usr_id_create_dt'] = $val['OraHcmGrpLtaSal']['usr_id_create_dt'];
            $this->LtaSal->Create();
            $this->LtaSal->save($dataltagrpsal);
        }
        $data_log['function_name'] = 'import_lta_grp_sal';
        $data_log['module_related'] = 'LTA GRP SAL';
        $data_log['last_run'] = date('Y-m-d');
        $data_log['status'] = 1;
        if($this->ImportLog->save($data_log))
        {
        echo "Check 7:Imported Leave Group Data <br>";
    }
    else
 {
        echo "Check 7:Imported Leave Group Data <br>";
    }
        $this->import_lta_leave();
    }

    function import_lta_leave() {
        $this->autoRender = false;
        $this->General->query('SET FOREIGN_KEY_CHECKS = 0');
        $this->General->query('TRUNCATE lta_sal');
        $data_oracle = $this->OraHcmLtaLeave->find('all');
        foreach ($data_oracle as $k => $val) {
            $dataltaLeave['org_id'] = $val['OraHcmLtaLeave']['ho_org_id'];
            $dataltaLeave['grp_id'] = $val['OraHcmLtaLeave']['grp_id'];
            $dataltaLeave['leave_id'] = $val['OraHcmLtaLeave']['leave_id'];
            $dataltaLeave['usr_id_create'] = $val['OraHcmLtaLeave']['usr_id_create'];
            $dataltaLeave['usr_id_create_dt'] = $val['OraHcmLtaLeave']['usr_id_create_dt'];
            $this->LtaLeave->Create();
            $this->LtaLeave->save($dataltaLeave);
        }
        $data_log['function_name'] = 'import_lta_leave';
        $data_log['module_related'] = 'LTA LEAVE';
        $data_log['last_run'] = date('Y-m-d');
        $data_log['status'] = 1;
        if($this->ImportLog->save($data_log))
        {
        echo "Check 7: Imported LTA Leave Data <br>";
    }
    else
{
    echo "Check 7:LTA Leave Data  Not Imported<br>";
}


        $this->import_lta_group();
    }

    function import_lta_group() {
        $this->autoRender = false;
        $this->General->query('SET FOREIGN_KEY_CHECKS = 0');
        $this->General->query('TRUNCATE lta_group');
        $data_oracle = $this->OraHcmLeaveGroup->find('all');
        foreach ($data_oracle as $k => $val) {
            $datagroup['org_id'] = $val['OraHcmLeaveGroup']['ho_org_id'];
            $datagroup['grp_id'] = $val['OraHcmLeaveGroup']['grp_id'];
            $datagroup['lta_type'] = $val['OraHcmLeaveGroup']['lta_type'];
            $datagroup['lta_perc'] = $val['OraHcmLeaveGroup']['lta_perc'];
            $datagroup['lta_amt'] = $val['OraHcmLeaveGroup']['lta_amt'];
            $datagroup['blk_frm_dt'] = $val['OraHcmLeaveGroup']['blk_frm_dt'];
            $datagroup['blk_to_dt'] = $val['OraHcmLeaveGroup']['blk_to_dt'];
            $datagroup['min_srvc_prd'] = $val['OraHcmLeaveGroup']['min_srvc_prd'];
            $datagroup['min_leave_days'] = $val['OraHcmLeaveGroup']['min_leave_days'];
            $datagroup['usr_id_create'] = $val['OraHcmLeaveGroup']['usr_id_create'];
            $datagroup['usr_id_create_dt'] = $val['OraHcmLeaveGroup']['usr_id_create_dt'];
            $datagroup['usr_id_mod'] = $val['OraHcmLeaveGroup']['usr_id_mod'];
            $datagroup['usr_id_mod_dt'] = $val['OraHcmLeaveGroup']['usr_id_mod_dt'];
            $this->LtaGroup->Create();
            $this->LtaGroup->save($datagroup);
        }
        $data_log['function_name'] = 'import_lta_group';
        $data_log['module_related'] = 'LTA GROUP';
        $data_log['last_run'] = date('Y-m-d');
        $data_log['status'] = 1;
        if($this->ImportLog->save($data_log))
        {
        echo "Check 7: Imported LTA group <br>";
    }
    else
    {
          echo "Check 7: LTA group Not Imported <br>";
    }
        $this->import_leave_encsh();
    }

    function import_leave_encsh() {
        $this->autoRender = false;
        $this->General->query('SET FOREIGN_KEY_CHECKS = 0');
        $this->General->query('TRUNCATE leave_encsh');
        $this->General->query('TRUNCATE leave_encsh_dt');
        $this->General->query('SET FOREIGN_KEY_CHECKS = 1');
        $oracle_data = $this->OraHcmEmpLeaveEncsh->find('all');
        foreach ($oracle_data as $key => $val) {
            $data['comp_code'] = $val['OraHcmEmpLeaveEncsh']['org_id'];
            $data['doc_id'] = $val['OraHcmEmpLeaveEncsh']['doc_id'];
            $data['emp_doc_id'] = $val['OraHcmEmpLeaveEncsh']['emp_doc_id'];
            $emp_cd = $this->MyProfile->find('first', array(
                'conditions' => array(
                    'doc_id' => $val['OraHcmEmpLeaveEncsh']['emp_doc_id']
                ),
                'fields' => array('emp_code')
            ));
            $data['emp_code'] = $emp_cd['MyProfile']['emp_code'];
            $data['dept_code'] = $val['OraHcmEmpLeaveEncsh']['emp_dept_id'];
            $data['emp_grp_id'] = $val['OraHcmEmpLeaveEncsh']['emp_grp_id'];
            $data['doc_id'] = $val['OraHcmEmpLeaveEncsh']['doc_id'];
            $data['encsh_amt'] = $val['OraHcmEmpLeaveEncsh']['encsh_amt'];
            $data['doc_dt'] = $val['OraHcmEmpLeaveEncsh']['doc_dt'];
            if ($val['OraHcmEmpLeaveEncsh']['encsh_status'] == 'A') {
                $data['encsh_status'] = 5;
            } elseif ($val['OraHcmEmpLeaveEncsh']['encsh_status'] == 'P') {
                $data['encsh_status'] = 2;
            } else {
                $data['encsh_status'] = 4;
            }
            $this->LeaveEncsh->create();
            if ($this->LeaveEncsh->save($data)) {
                $oracle_data_dt = $this->OraHcmEmpLeaveEncshDtl->find('first', array(
                    'conditions' => array('doc_id' => $val['OraHcmEmpLeaveEncsh']['doc_id'])));
                $dt_data = array();
                $dt_data['comp_code'] = $val['OraHcmEmpLeaveEncsh']['org_id'];
                $dt_data['emp_code'] = $emp_cd['MyProfile']['emp_code'];
                $dt_data['doc_id'] = $val['OraHcmEmpLeaveEncsh']['doc_id'];
                $dt_data['emp_doc_id'] = $val['OraHcmEmpLeaveEncsh']['emp_doc_id'];
                $dt_data['leave_id'] = $oracle_data_dt['OraHcmEmpLeaveEncshDtl']['leave_id'];
                $dt_data['leave_encash_limit'] = $oracle_data_dt['OraHcmEmpLeaveEncshDtl']['leave_encash_limit'];
                $dt_data['leave_op'] = $oracle_data_dt['OraHcmEmpLeaveEncshDtl']['leave_op'];
                $dt_data['leave_avail'] = $oracle_data_dt['OraHcmEmpLeaveEncshDtl']['leave_avail'];
                $dt_data['leaveencsh_amt_bal'] = $oracle_data_dt['OraHcmEmpLeaveEncshDtl']['leave_bal'];
                $dt_data['encsh_amt'] = $oracle_data_dt['OraHcmEmpLeaveEncshDtl']['encsh_amt'];
                $dt_data['created_at'] = $oracle_data_dt['OraHcmEmpLeaveEncshDtl']['usr_id_create'];
                $dt_data['leave_encsh_id'] = $this->LeaveEncsh->getLastInsertID();
                if ($val['OraHcmEmpLeaveEncsh']['encsh_status'] == 'A') {
                    $dt_data['leaveencash_status'] = 5;
                } elseif ($val['OraHcmEmpLeaveEncsh']['encsh_status'] == 'P') {
                    $dt_data['leaveencash_status'] = 2;
                } else {
                    $dt_data['leaveencash_status'] = 4;
                }
                $this->LeaveEncshDt->create();
                $this->LeaveEncshDt->save($dt_data);
            }
        }
        $data_log['function_name'] = 'import_leave_encsh';
        $data_log['module_related'] = 'LEAVE ENCASH';
        $data_log['last_run'] = date('Y-m-d');
        $data_log['status'] = 1;
        if($this->ImportLog->save($data_log))
        {
        echo "Check 7:Imported Leave Encash Data <br>";
    }
    else
{
    echo "Check 7: Leave Encash Data NOT Imported <br>";
}


        $this->import_emp_invest();
    }

    function import_emp_invest() {
        $this->autoRender = false;
        $this->General->query('SET FOREIGN_KEY_CHECKS = 0');
        $this->General->query('TRUNCATE emp_invest');
        $this->General->query('TRUNCATE emp_invest_dtl');
        $hcm_emp_invest = new Model(array('table' => 'HCM$IT$EMP$INVEST', 'ds' => 'ora', 'name' => 'HCMITEMPINVEST'));
        $hcm_emp_invest_dtl = new Model(array('table' => 'HCM$IT$EMP$INVEST$DTL', 'ds' => 'ora', 'name' => 'HCMITEMPINVESTDTL'));
        $oracle_data = $hcm_emp_invest->find('all');
        foreach ($oracle_data as $key => $val) {
            $data['comp_code'] = $val['HCMITEMPINVEST']['org_id'];
            $data['doc_id'] = $val['HCMITEMPINVEST']['doc_id'];
            $data['emp_doc_id'] = $val['HCMITEMPINVEST']['emp_doc_id'];
            $emp_cd = $this->MyProfile->find('first', array(
                'conditions' => array(
                    'doc_id' => $val['HCMITEMPINVEST']['emp_doc_id']
                ),
                'fields' => array('emp_code')
            ));
            $data['emp_code'] = $emp_cd['MyProfile']['emp_code'];
            $data['Fy_id'] = $val['HCMITEMPINVEST']['fy_id'];
            $data['loc_type'] = $val['HCMITEMPINVEST']['loc_type'];
            $data['invest_status'] = 5;
            $data['config'] = 1;
            $this->EmpInvest->create();
            if ($this->EmpInvest->save($data)) {
                $oracle_data_dt = $hcm_emp_invest_dtl->find('all', array(
                    'conditions' => array('doc_id' => $val['HCMITEMPINVEST']['doc_id'])));
                foreach ($oracle_data_dt as $dk => $dval) {
                    $dt_data = array();
                    $dt_data['org_id'] = $val['HCMITEMPINVEST']['org_id'];
                    $dt_data['emp_code'] = $emp_cd['MyProfile']['emp_code'];
                    $dt_data['doc_id'] = $val['HCMITEMPINVEST']['doc_id'];
                    $dt_data['emp_doc_id'] = $val['HCMITEMPINVEST']['emp_doc_id'];
                    $dt_data['fy_id'] = $dval['HCMITEMPINVESTDTL']['fy_id'];
                    $dt_data['invest_doc_id'] = $dval['HCMITEMPINVESTDTL']['invest_doc_id'];
                    $dt_data['sect_id'] = $dval['HCMITEMPINVESTDTL']['sect_id'];
                    $dt_data['invest_id'] = $dval['HCMITEMPINVESTDTL']['invest_id'];
                    $dt_data['invest_amt'] = $dval['HCMITEMPINVESTDTL']['invest_amt'];
                    $dt_data['actual_amt'] = $dval['HCMITEMPINVESTDTL']['actual_amt'];
                    $dt_data['created_at'] = $dval['HCMITEMPINVESTDTL']['usr_id_create_dt'];
                    $dt_data['approver_id'] = 209;
                    $dt_data['invest_status'] = 5;
                    $dt_data['emp_invest_id'] = $this->EmpInvest->getLastInsertID();
                    $this->EmpInvestDtl->create();
                    $this->EmpInvestDtl->save($dt_data);
                }
            }
        }
        $data_log['function_name'] = 'import_emp_invest';
        $data_log['module_related'] = 'EMPLOYEE ENVESTMENT';
        $data_log['last_run'] = date('Y-m-d');
        $data_log['status'] = 1;
        if($this->ImportLog->save($data_log))
        {
        echo "Check 7:Imported EMP INVEST Data <br>";
    }
    else
    {
        echo "Check 7: EMP INVEST Data Not Impotred <br>"; 
    }
        
        
    }

    public function import_salary() {
    
        
        $this->autoRender = false;
        $this->General->query('SET FOREIGN_KEY_CHECKS = 0');
        $this->General->query('TRUNCATE employee_sal_details');
        $data_oracle = $this->OraHcmEmpSal->find('all');
        foreach ($data_oracle as $k => $v) {
            $data = $v['OraHcmEmpSal'];
            $data['emp_id'] = $data['emp_code'];
            unset($data['emp_code']);
            $this->SalaryDetail->create();
            $this->SalaryDetail->save($data);
        }
        $data_log['function_name'] = 'import_salary';
        $data_log['module_related'] = 'SALARY';
        $data_log['last_run'] = date('Y-m-d');
        $data_log['status'] = 1;
        if($this->ImportLog->save($data_log))
        {
        echo "Check 8: Imported Emp Salary Details<br>";
    }

else{
 echo "Check 8:  Emp Salary Details Not Imported<br>";
}
        
        $this->import_ded();
    }

    public function import_ded() {
        $this->autoRender = false;
        $oracle_data = $this->OraHcmDed->find('all');
        $this->General->query('SET FOREIGN_KEY_CHECKS = 0');
        $this->General->query('TRUNCATE hcm_ded');
        foreach ($oracle_data as $key => $val) {
            $data['org_id'] = $val['OraHcmDed']['org_id'];
            $data['doc_id'] = $val['OraHcmDed']['doc_id'];
            $data['ded_desc'] = $val['OraHcmDed']['ded_desc'];
            $data['ded_id'] = $val['OraHcmDed']['ded_id'];
            $data['sloc_id'] = $val['OraHcmDed']['sloc_id'];
            $data['ho_org_id'] = $val['OraHcmDed']['ho_org_id'];
            $data['ded_amt'] = $val['OraHcmDed']['ded_amt'];
            $data['ded_type'] = $val['OraHcmDed']['ded_type'];
            $this->HcmDed->create();
            $this->HcmDed->save($data);
        }
        $data_log['function_name'] = 'import_ded';
        $data_log['module_related'] = 'DEDUCTIONS';
        $data_log['last_run'] = date('Y-m-d');
        $data_log['status'] = 1;
        if($this->ImportLog->save($data_log))
        {
        echo "Check 8: Imported Emp Salary Deductions<br>";
}
else{
     echo "Check 8: Emp Salary Deductions Not Imported<br>";
}
        $this->import_deductions();
        /*$this->import_loan_prf();*/
    }

    function import_deductions() {
        $this->autoRender = false;
        $data_oracle_lwf = new Model(array('table' => 'HCM$MON$LWF', 'ds' => 'ora', 'name' => 'HCMMONLWF'));
        $oracle_data_lwf = $data_oracle_lwf->find('all');
        foreach ($oracle_data_lwf as $val) {
            $data['org_id'] = $val['HCMMONLWF']['org_id'];
            $data['emp_code'] = $val['HCMMONLWF']['emp_code'];
            $data['emp_doc_id'] = $val['HCMMONLWF']['emp_doc_id'];
            $data['proc_frm_dt'] = $val['HCMMONLWF']['proc_frm_dt'];
            $data['proc_to_dt'] = $val['HCMMONLWF']['proc_to_dt'];
            $data['ded_doc_id'] = $val['HCMMONLWF']['doc_id'];
            $data['ded_amt'] = $val['HCMMONLWF']['emp_amt'];
            $this->SalaryProcessingDeduction->create();
            $this->SalaryProcessingDeduction->save($data);
        }
        //ESI deduction
        $oracle_data = $this->OraHcmMonEsiDed->find('all');
        foreach ($oracle_data as $val) {
            $data['org_id'] = $val['OraHcmMonEsiDed']['org_id'];
            $data['emp_code'] = $val['OraHcmMonEsiDed']['emp_code'];
            $data['emp_doc_id'] = $val['OraHcmMonEsiDed']['emp_doc_id'];
            $data['proc_frm_dt'] = $val['OraHcmMonEsiDed']['proc_frm_dt'];
            $data['proc_to_dt'] = $val['OraHcmMonEsiDed']['proc_to_dt'];
            $data['ded_doc_id'] = $val['OraHcmMonEsiDed']['ded_doc_id'];
            $data['ded_amt'] = $val['OraHcmMonEsiDed']['emp_ded_amt'];
            $data['doc_id'] = $val['OraHcmMonEsiDed']['doc_id'];
            $this->SalaryProcessingDeduction->create();
            $this->SalaryProcessingDeduction->save($data);
        }
        $oracle_data = $this->OraHcmMonLoanDed->find('all');
        foreach ($oracle_data as $val) {
            $data['org_id'] = $val['OraHcmMonLoanDed']['org_id'];
            $data['emp_code'] = $val['OraHcmMonLoanDed']['emp_code'];
            $data['emp_doc_id'] = $val['OraHcmMonLoanDed']['emp_doc_id'];
            $data['proc_frm_dt'] = $val['OraHcmMonLoanDed']['proc_frm_dt'];
            $data['proc_to_dt'] = $val['OraHcmMonLoanDed']['proc_to_dt'];
            $data['ded_doc_id'] = $val['OraHcmMonLoanDed']['ded_doc_id'];
            $data['ded_amt'] = $val['OraHcmMonLoanDed']['emp_ded_amt'];
            $data['doc_id'] = $val['OraHcmMonLoanDed']['doc_id'];
            $this->SalaryProcessingDeduction->create();
            $this->SalaryProcessingDeduction->save($data);
        }
        //PF deduction
        $oracle_data = $this->OraHcmMonPfDed->find('all');
        foreach ($oracle_data as $val) {
            $data['org_id'] = $val['OraHcmMonPfDed']['org_id'];
            $data['emp_code'] = $val['OraHcmMonPfDed']['emp_code'];
            $data['emp_doc_id'] = $val['OraHcmMonPfDed']['emp_doc_id'];
            $data['proc_frm_dt'] = $val['OraHcmMonPfDed']['proc_frm_dt'];
            $data['proc_to_dt'] = $val['OraHcmMonPfDed']['proc_to_dt'];
            $data['ded_doc_id'] = $val['OraHcmMonPfDed']['ded_doc_id'];
            $data['ded_amt'] = $val['OraHcmMonPfDed']['emp_ded_amt'];
            $data['epf_amt'] = $val['OraHcmMonPfDed']['epf_amt'];
            $data['fpf_amt'] = $val['OraHcmMonPfDed']['fpf_amt'];
            $data['doc_id'] = $val['OraHcmMonPfDed']['doc_id'];
            $this->SalaryProcessingDeduction->create();
            $this->SalaryProcessingDeduction->save($data);
        }
        //Professional tax deduction
        $oracle_data = $this->OraHcmMonProfsnlDed->find('all');
        foreach ($oracle_data as $val) {
            $data['org_id'] = $val['OraHcmMonProfsnlDed']['org_id'];
            $data['emp_code'] = $val['OraHcmMonProfsnlDed']['emp_code'];
            $data['emp_doc_id'] = $val['OraHcmMonProfsnlDed']['emp_doc_id'];
            $data['proc_frm_dt'] = $val['OraHcmMonProfsnlDed']['proc_frm_dt'];
            $data['proc_to_dt'] = $val['OraHcmMonProfsnlDed']['proc_to_dt'];
            $data['ded_doc_id'] = $val['OraHcmMonProfsnlDed']['ded_doc_id'];
            $data['ded_amt'] = $val['OraHcmMonProfsnlDed']['emp_ded_amt'];
            $data['doc_id'] = $val['OraHcmMonProfsnlDed']['doc_id'];
            $this->SalaryProcessingDeduction->create();
            $this->SalaryProcessingDeduction->save($data);
        }
        //Super deduction
        $oracle_data = $this->OraHcmMonSuperDed->find('all');
        foreach ($oracle_data as $val) {
            $data['org_id'] = $val['OraHcmMonSuperDed']['org_id'];
            $data['emp_code'] = $val['OraHcmMonSuperDed']['emp_code'];
            $data['emp_doc_id'] = $val['OraHcmMonSuperDed']['emp_doc_id'];
            $data['proc_frm_dt'] = $val['OraHcmMonSuperDed']['proc_frm_dt'];
            $data['proc_to_dt'] = $val['OraHcmMonSuperDed']['proc_to_dt'];
            $data['ded_doc_id'] = $val['OraHcmMonSuperDed']['ded_doc_id'];
            $data['ded_amt'] = $val['OraHcmMonSuperDed']['emp_ded_amt'];
            $data['doc_id'] = $val['OraHcmMonSuperDed']['doc_id'];
            $this->SalaryProcessingDeduction->create();
            $this->SalaryProcessingDeduction->save($data);
        }
        //Tax deduction
        $oracle_data = $this->OraHcmMonTaxDed->find('all');
        foreach ($oracle_data as $val) {
            $data['org_id'] = $val['OraHcmMonTaxDed']['org_id'];
            $data['emp_code'] = $val['OraHcmMonTaxDed']['emp_code'];
            $data['emp_doc_id'] = $val['OraHcmMonTaxDed']['emp_doc_id'];
            $data['proc_frm_dt'] = $val['OraHcmMonTaxDed']['proc_frm_dt'];
            $data['proc_to_dt'] = $val['OraHcmMonTaxDed']['proc_to_dt'];
            $data['ded_doc_id'] = $val['OraHcmMonTaxDed']['ded_doc_id'];
            $data['ded_amt'] = $val['OraHcmMonTaxDed']['emp_ded_amt'];
            $data['doc_id'] = $val['OraHcmMonTaxDed']['doc_id'];
            $this->SalaryProcessingDeduction->create();
            $this->SalaryProcessingDeduction->save($data);
        }
        $data_oracle_nssf = new Model(array('table' => 'HCM$MON$NSSF$DED', 'ds' => 'ora', 'name' => 'HCMMONNSSFDED'));
        $oracle_data_nssf = $data_oracle_nssf->find('all');
        foreach ($oracle_data_nssf as $val) {
            $data['org_id'] = $val['HCMMONNSSFDED']['org_id'];
            $data['emp_code'] = $val['HCMMONNSSFDED']['emp_code'];
            $data['emp_doc_id'] = $val['HCMMONNSSFDED']['emp_doc_id'];
            $data['proc_frm_dt'] = $val['HCMMONNSSFDED']['proc_frm_dt'];
            $data['proc_to_dt'] = $val['HCMMONNSSFDED']['proc_to_dt'];
            $data['ded_doc_id'] = $val['HCMMONNSSFDED']['ded_doc_id'];
            $data['ded_amt'] = $val['HCMMONNSSFDED']['emp_ded_amt'];
            $this->SalaryProcessingDeduction->create();
            $this->SalaryProcessingDeduction->save($data);
        }
        $data_log['function_name'] = 'import_deductions';
        $data_log['module_related'] = 'DEDUCTIONS';
        $data_log['last_run'] = date('Y-m-d');
        $data_log['status'] = 1;
        if($this->ImportLog->save($data_log))
        {
             echo "Check 8: Imported Emp Monthly Deductions<br>";
        }
else
{

      echo "Check 8:Emp Monthly Deductions Not Imported<br>";
     
}
      
        $this->import_loan_prf();
    }

    function import_loan_prf() {
        $this->General->query('SET FOREIGN_KEY_CHECKS = 0');
        $this->General->query('TRUNCATE oracle_hcm_emp_loan');
        $this->autoRender = false;
        $loan_prf = new Model(array('table' => 'HCM$EMP$LOAN', 'ds' => 'ora', 'name' => 'HCMEMPLOAN'));
        $oracle_data = $loan_prf->find('all');
        foreach ($oracle_data as $val) {
            $data['OracleHcmEmpLoan'] = $val['HCMEMPLOAN'];
            $this->OracleHcmEmpLoan->create();
           $loan_prf=$this->OracleHcmEmpLoan->save($data);
        }

if($loan_prf)
{
        echo "Check 8: Imported Emp Loan Details<br>";
    }
  else
{
        echo "Check 8: Emp Loan Details Not Imported<br>";
 
}




        $this->import_it_proc();
    }

    function import_comp_off_trans() {
        $this->General->query('SET FOREIGN_KEY_CHECKS = 0');
        $this->General->query('TRUNCATE comp_off_leave_trans');
        $this->autoRender = false;
        $comp_off = new Model(array('table' => 'comp_off_leave_trans', 'ds' => 'default', 'name' => 'COMPOFF'));
        $loan_prf = new Model(array('table' => 'hcm$comp$off$leave$trans', 'ds' => 'ora', 'name' => 'HCMCOMPOFF'));
        $oracle_data = $loan_prf->find('all');
        foreach ($oracle_data as $val) {
            $data['COMPOFF'] = $val['HCMCOMPOFF'];
            $comp_off->create();
            $comp_off->save($data);

            $this->import_it_proc();
        }
    }

    function import_it_proc() {
        $this->autoRender = false;
        $this->General->query('SET FOREIGN_KEY_CHECKS = 0');
        $this->General->query('TRUNCATE oracle_hcm_it_proc');
        $oracle_data = $this->OraHcmItProc->find('all');
        foreach ($oracle_data as $val) {
            $data['OracleHcmItProc'] = $val['OraHcmItProc'];
            $this->OracleHcmItProc->create();
            $this->OracleHcmItProc->save($data);
        }
        $data_log['function_name'] = 'import_it_proc';
        $data_log['module_related'] = 'DEDUCTIONS';
        $data_log['last_run'] = date('Y-m-d');
        $data_log['status'] = 1;
        if($this->ImportLog->save($data_log))
        {
           echo "Check 8: Imported IT Proc Details<br>";  
        }
        else{
            echo "Check 8:  IT Proc Details Not Imported<br>";  
        }
       
        $this->import_org_hcm_salary();
    }

    function import_org_hcm_salary() {
        $this->autoRender = false;
        $this->General->query('SET FOREIGN_KEY_CHECKS = 0');
        $this->General->query('TRUNCATE oracle_org_hcm_salary');
        $oracle_data = $this->OraOrgHcmSalary->find('all');
        foreach ($oracle_data as $val) {
            $data['OracleOrgHcmSalary'] = $val['OraOrgHcmSalary'];
            $this->OracleOrgHcmSalary->create();
            $this->OracleOrgHcmSalary->save($data);
        }
        $data_log['function_name'] = 'import_org_hcm_salary';
        $data_log['module_related'] = 'HCM SALARY';
        $data_log['last_run'] = date('Y-m-d');
        $data_log['status'] = 1;
        if($this->ImportLog->save($data_log))
        {
        echo "Check 8:Imported Emp HCM Salary Details<br>";
    }
    else
{
   echo "Check 8: Emp HCM Salary Details Not Imported<br>";  
}


        $this->import_salary_proc();
    }

//function to import leave of users
    //function to import the processed salary
    function import_salary_proc() {
        $this->autoRender = false;
        $this->General->query('SET FOREIGN_KEY_CHECKS = 0');
        $this->General->query('TRUNCATE employee_sal_proc');
        $data_oracle = $this->OraHcmSalProc->find('all');
        foreach ($data_oracle as $k => $v) {
            $data = $v['OraHcmSalProc'];
            $this->SalaryProcessing->create();
            $this->SalaryProcessing->save($data);
        }
        $data_log['function_name'] = 'import_salary_proc';
        $data_log['module_related'] = 'SALARY';
        $data_log['last_run'] = date('Y-m-d');
        $data_log['status'] = 1;
        if($this->ImportLog->save($data_log))
        {
            echo "Check 8: Imported Emp Salary Addition Details<br>"; 
        }
        else{

             echo "Check 8:  Emp Salary Addition Details Not Imported<br>"; 
        }
       

        $this->import_salary_proc_addition();
    }

    function import_salary_proc_addition() {
        $this->autoRender = false;
        $this->General->query('SET FOREIGN_KEY_CHECKS = 0');
        $this->General->query('TRUNCATE employee_sal_proc_sal');
        $data_oracle = $this->OraHcmSalProcSal->find('all');
        foreach ($data_oracle as $k => $v) {
            $data = $v['OraHcmSalProcSal'];
            $data['employee_sal_proc_sal_id'] = $v['OraHcmSalProcSal']['doc_id'];
            unset($data['OraHcmSalProcSal']['doc_id']);
            $this->SalaryProcessingAddition->create();
            $this->SalaryProcessingAddition->save($data);
        }
        $data_log['function_name'] = 'import_salary_proc_addition';
        $data_log['module_related'] = 'SALARY';
        $data_log['last_run'] = date('Y-m-d');
        $data_log['status'] = 1;
        if($this->ImportLog->save($data_log))
        {
        echo "Check 8:Imported Emp Salary Additions<br>";
    }
    else{
        echo "Check 8:Emp Salary Additions Not Imported<br>";
    }



        $this->import_salary_proc_deduction();
    }

    public function import_salary_proc_deduction() {
        $this->autoRender = false;
        $this->General->query('SET FOREIGN_KEY_CHECKS = 0');
        $this->General->query('TRUNCATE employee_sal_proc_ded');
        $data_oracle = $this->OraHcmSalProcDed->find('all');
        foreach ($data_oracle as $k => $v) {
            $data = $v['OraHcmSalProcDed'];
            $this->SalaryProcessingDeduction->create();
            $this->SalaryProcessingDeduction->save($data);
        }
        $data_log['function_name'] = 'import_salary_proc_deduction';
        $data_log['module_related'] = 'SALARY';
        $data_log['last_run'] = date('Y-m-d');
        $data_log['status'] = 1;
        if($this->ImportLog->save($data_log))
        {
        echo "Check 8: Imported Salary Deductions<br>";
    }
    else
{
echo "Check 8:  Salary Deductions Not Imported<br>";
}


        $this->import_employee_sal_mon();
    }

    function import_employee_sal_mon() {
        $this->autoRender = false;
        $this->General->query('SET FOREIGN_KEY_CHECKS = 0');
        $this->General->query('TRUNCATE employee_sal_mon');
        $oracle_data = $this->OraHcmEmpSalMon->find('all');
        foreach ($oracle_data as $key => $val) {
            $data['status'] = 5;
            $data['approval_date'] = date('Y-m-d');
            $data['claim_date'] = $val['OraHcmEmpSalMon']['usr_id_create_dt'];
            $data['created_at'] = $val['OraHcmEmpSalMon']['usr_id_create_dt'];
            $data['emp_code'] = $val['OraHcmEmpSalMon']['emp_code'];
            $data['emp_doc_id'] = $val['OraHcmEmpSalMon']['emp_doc_id'];
            $data['doc_id'] = $val['OraHcmEmpSalMon']['doc_id'];
            $data['proc_frm_dt'] = $val['OraHcmEmpSalMon']['proc_frm_dt'];
            $data['proc_to_dt'] = $val['OraHcmEmpSalMon']['proc_to_dt'];
            $data['sal_id'] = $val['OraHcmEmpSalMon']['sal_id'];
            $data['sal_val'] = $val['OraHcmEmpSalMon']['sal_val'];
            $data['sal_amt'] = $val['OraHcmEmpSalMon']['sal_amt'];
            $data['cld_id'] = $val['OraHcmEmpSalMon']['cld_id'];
            $data['sloc_id'] = $val['OraHcmEmpSalMon']['sloc_id'];
            $data['ho_org_id'] = $val['OraHcmEmpSalMon']['ho_org_id'];
            $proc_frm_dt = date('Y-m-d', strtotime($val['OraHcmEmpSalMon']['proc_frm_dt']));
            $proc_to_dt = date('Y-m-d', strtotime($val['OraHcmEmpSalMon']['proc_to_dt']));
            $present_emp_sal = $this->EmployeeSalMon->find('first', array(
                'conditions' => array(
                    'emp_code' => $val['OraHcmEmpSalMon']['emp_code'],
                    'created_at' => $proc_frm_dt,
                    'proc_to_dt' => $proc_to_dt
                )
            ));
            if (!empty($present_emp_sal)) {
                $this->EmployeeSalMon->id = $present_emp_sal['EmployeeSalMon']['id'];
                $this->EmployeeSalMon->save($data);
            } else {
                $max_filed = $this->EmployeeSalMon->find('first', array('fields' => array('MAX(voucher_id) as voucher_id')));
                $final_data['voucher_id'] = $max_filed[0]['voucher_id'] + 1;

                $this->EmployeeSalMon->create();
                $this->EmployeeSalMon->save($data);
            }
        }
        $data_log['function_name'] = 'import_employee_sal_mon';
        $data_log['module_related'] = 'SALARY';
        $data_log['last_run'] = date('Y-m-d');
        $data_log['status'] = 1;
        if($this->ImportLog->save($data_log))
        {
 echo "Check 8: Imported Mothly SalaryData<br>";
        }
        else{
 echo "Check 8:  Mothly SalaryData Not Immported<br>";
        }




       

        exit();
    }

    public function import_arr() {
        $this->General->query('SET FOREIGN_KEY_CHECKS = 0');
        $this->General->query('TRUNCATE emp_incr_arr');
        $arr = new Model(array('table' => 'HCM$INCR$ARR', 'ds' => 'ora', 'name' => 'HCMINCRARR'));
        $oracle_data = $arr->find('all');
        if ($oracle_data) {
            foreach ($oracle_data as $k => $v) {
                $data = $v['HCMINCRARR'];
                $this->EmpIncrArr->create();
                $this->EmpIncrArr->save($data);
            }
        }
    }

    public function updatepass() {
        $result = $this->UserDetail->find('all', array('fields' => array('emp_code', 'user_password')));
        foreach ($result as $pass) {
            $dob = $this->MyProfile->find('first', array('fields' => array('dob'), 'conditions' => array('emp_code' => $pass['UserDetail']['emp_code'])));
         $newDate = date("dmY", strtotime($dob['MyProfile']['dob']));
         $password = $this->Auth->password(trim($newDate));
         $updatecommand = $this->UserDetail->updateAll(
                  array('UserDetail.user_password' => "'$password'"), 
                  array('UserDetail.emp_code' => $pass['UserDetail']['emp_code'])
            );
        }
        echo "All Password Updated";
    }

    public function truncate_info() {
        $this->GeneralOracle->query('TRUNCATE data_info');
    }

    public function reset_portal() {
        $this->General->query('SET FOREIGN_KEY_CHECKS = 0; 
                            truncate mst_org;
                            TRUNCATE appraisal_process;
                            TRUNCATE appraisal_development_plan;
                            TRUNCATE app_factors_map;
                            TRUNCATE app_factors;
                            TRUNCATE assign_competency_dept_desg;
                            TRUNCATE assign_competency_to_emp;
                            TRUNCATE assign_comp_to_emp_details;
                            TRUNCATE assign_desgination_kras;
                            TRUNCATE assign_group_to_desg;
                            TRUNCATE assign_group_to_desg_details;
                            TRUNCATE attendance_with_location;
                            TRUNCATE attribute_type;
                            TRUNCATE audit_trail;
                            TRUNCATE emp_documents;
                            TRUNCATE emp_events;
                            TRUNCATE import_log;
                            TRUNCATE events;
                            TRUNCATE financial_year;
                            TRUNCATE group_competency;
                            TRUNCATE kra_comp_overall_rating;
                            TRUNCATE kpi_masters;
                            TRUNCATE kra_masters;
                            TRUNCATE kra_rating;
                            TRUNCATE kra_slabs;
                            TRUNCATE kra_target;
                            TRUNCATE group_weightage;
                            TRUNCATE hcm_desg_prf;
                            TRUNCATE hcm_group_master;
                            TRUNCATE help_desk_dtl;
                            TRUNCATE competency;
                            TRUNCATE competency_rating;
                            TRUNCATE holiday;
                            TRUNCATE conveyence_workflow;
                            TRUNCATE dt_exp_voucher;
                            TRUNCATE employee_sal_mon;
                            TRUNCATE emp_address;
                            TRUNCATE local_expence;
                            TRUNCATE lta_leave;
                            TRUNCATE medical_bill_amount;
                            TRUNCATE medical_workflow;
                            truncate mst_company;
                            TRUNCATE mgt_group_desg;
                            TRUNCATE mid_reviews;
                            TRUNCATE mom_assign_emp;
                            TRUNCATE mom_topic;
                            TRUNCATE mom_topic_function;
                            truncate users;
                            truncate myprofile;
                            truncate dependent_details;
                            TRUNCATE mst_emp_exp_voucher;
                            TRUNCATE task_assigns;
                            TRUNCATE task_assign_emp;
                            TRUNCATE task_project;
                            TRUNCATE temp_workflow;
                            truncate emp_edu;
                            TRUNCATE mst_acl;
                            TRUNCATE mst_desg;
                            truncate emp_exp;
                            truncate options;
                            truncate option_attribute;
                            truncate departments;
                            truncate mst_emp_leave_allot;
                            truncate leave_grp;
                            truncate employee_sal_details;
                            truncate employee_sal_proc;
                            truncate employee_sal_proc_sal;
                            truncate employee_sal_proc_ded;
                            truncate employee_sal_proc_ded;
                            truncate hcm_ded;
                            truncate oracle_hcm_it_proc;
                            truncate oracle_org_hcm_salary;
                            truncate leave_details;
                            truncate leave_workflow;
                            truncate mst_emp_leaves;
                            truncate leave_encsh;
                            truncate leave_encsh_dt;
                            truncate leave_encashment_workflow;
                            truncate separations;
                            truncate separation_workflows;
                            truncate fnfs;
                            truncate fnf_details;
                            truncate fnf_workflows;
                            truncate sect_dtl;
                            truncate invest_dtl;
                            truncate emp_invest;
                            truncate emp_invest_dtl;
                            truncate attendance_details;
                            truncate lta_workflow;
                            truncate lta_bill_amount;
                            truncate emp_invest;
                            truncate emp_invest_dtl;
                            DELETE FROM `mst_emp_exp_voucher` WHERE expense_type = "T";
                            truncate travel_workflow;
                            truncate dt_travel_voucher;
                            truncate appraisal_req;
                            truncate app_appraisers;
                            truncate app_comments;
                            truncate app_ratings;
                            truncate app_comments;
                            truncate kpi_map_emps;
                            truncate kra_kpi_process;
                            truncate kra_map_emp;
                            truncate separations;
                            truncate separation_workflows;
                            truncate fnfs;
                            truncate fnf_details;
                            truncate fnf_workflows;
                            truncate appraisal_req;
                            truncate app_appraisers;
                            truncate app_comments;
                            truncate app_ratings;
                            truncate kpi_map_emps;
                            truncate kra_kpi_process;
                            truncate kra_map_emp;
                            truncate leave_encsh;
                            truncate leave_encsh_dt;
                            truncate leave_encashment_workflow;
                            truncate mst_emp_leaves;
                            truncate leave_details;
                            truncate leave_workflow;
                            truncate oracle_app_eo;
                            truncate app_eo_mst;
                            SET FOREIGN_KEY_CHECKS = 1;');
        echo "All Data Truncated";
    }

    function select_country() {
        $arr = new Model(array('table' => 'support_email', 'ds' => 'default', 'name' => 'SuppEmail'));
        $email = $arr->find('first', array('fields' => 'email'), array('SuppEmail.comp_code' => '01'));
        $this->set('supp_email', $email['SuppEmail']['email']);
        $this->layout = 'admin_setup';
        $arr = new Model(array('table' => 'install_country', 'ds' => 'default', 'name' => 'Country'));
        $country = $arr->find('all');
        $country_list = $arr->find('list', array('fields' => array('id', 'name')));
        $this->set('country', $country);
        $this->set('country_list', $country_list);
        $this->render('select_country');
    }

    function get_url($id) {
        $arr = new Model(array('table' => 'install_country', 'ds' => 'default', 'name' => 'Country'));
        $country = $arr->find('first', array('fields' => array('url'), 'conditions' => array('id' => $id)));
        return $country['Country']['url'];
    }

    function update_url($id, $url) {

        $this->autoRender = false;
        $arr = new Model(array('table' => 'install_country', 'ds' => 'default', 'name' => 'Country'));
        $country = $arr->id = $id;
        $arr->saveField('url', $url);
        $arr->saveField('others', 1);
        return "Updated";
    }

    function update_email($email) {
        $this->autoRender = false;
        $arr = new Model(array('table' => 'support_email', 'ds' => 'default', 'name' => 'SuppEmail'));
        $arr->updateAll(array('email' => "'$email'"), array('SuppEmail.comp_code' => '01'));
        return $email;
    }

    function finish() {
        $this->autoRender = false;
        $arr = new Model(array('table' => 'setup_check', 'ds' => 'default', 'name' => 'Setup'));
        $email = $arr->updateAll(array('status' => 1));
        $this->Auth->logout();
        $this->redirect(array('controller' => 'users', 'action' => 'login'));
    }

    function update_installer($name, $email) {
        $this->autoRender = false;
        $this->General->query('truncate installer_info');
        $arr = new Model(array('table' => 'installer_info', 'ds' => 'default', 'name' => 'Installer'));
        $data['name'] = $name;
        $data['email'] = $email;
        $data['install_date'] = date('Y-m-d');
        $arr->save($data);
        $values = $arr->find('first');
        echo json_encode($values);
    }

    function db_config() {
        $this->layout = 'admin';
        $this->render('db_config');
    }

    function update_dbconf() {
        $this->autoRender = 'false';
        $arr = new Model(array('table' => 'database_config', 'ds' => 'default', 'name' => 'DBCONF'));
        $data['host'] = $_POST['host'];
        $data['port'] = $_POST['port'];
        $data['user_name'] = $_POST['name'];
        $data['password'] = $_POST['password'];
        $data['type'] = $_POST['type'];
        $data['sid'] = $_POST['sid'];
        $data['created'] = date('Y-m-d');
        if ($_POST['type'] == 'HCM') {
            $this->General->query('delete from database_config where type = "HCM" ');
        } else if ($_POST['type'] == 'APP') {
            $this->General->query('delete from database_config where type = "APP" ');
        }
        $arr->save($data);
        $values = $arr->find('first');
        echo json_encode($values);
        die;
    }

    function getConfig($type) {
        $this->autoRender = 'false';
        $arr = new Model(array('table' => 'database_config', 'ds' => 'default', 'name' => 'DBCONF'));
        $values = $arr->find('first', array('conditions' => array('type' => $type)));
        echo json_encode($values);
        die;
    }

    public function test_mail1() {
        Configure::write('debug', 2);
        $this->autorender = false;
        $mst_company = $this->MstOrg->find('all', array(
            'fields' => array('*')
        ));

        foreach ($mst_company as $comp) {
            $data['vehical_name'] = 'Cab';
            $data['status'] = 1;
            $data['created_date'] = '2017-08-14';
            $data['org_id'] = $comp['MstOrg']['org_id'];
            echo '<pre>';
            print_r($data);
            $this->MstVehicalMaster->create();
            $success = $this->MstVehicalMaster->save($data);
        }
    }
    function getdb_backup() {
        $dbhost = 'localhost';
        $dbuser = 'root';
        $dbpass = '';
        $db = 'test';
        $connection = mysqli_connect($dbhost, $dbuser, $dbpass, $db);
        if ($connection === false) {
            die("ERROR: Could not connect. " . mysqli_connect_error());
        }
        $full_path = $_SERVER['DOCUMENT_ROOT'] . '/db_backup/';
        $full_path1 = $_SERVER['DOCUMENT_ROOT'] . '/img/data/';

        if (!file_exists($full_path)) {
            mkdir('db_backup', 0777, true);
        }
        $d = date("Y-m-d_H-i-s");
        $path = $full_path . 'live_db' . $d . '.sql';
        $drive = explode('/', $_SERVER['DOCUMENT_ROOT']);
        $final_drive = $drive[0];
        $path_to_mysqldump = $final_drive . "\wamp\bin\mysql\mysql5.6.17\bin";
        $query = "$path_to_mysqldump\mysqldump.exe -u $dbuser $db > $path";
        if (exec($query)) {
            echo "Backup Successfull";
        } else {
           // echo "Backup Not Taken Please contact Portal Team";
        }
    }

}
?>
 
