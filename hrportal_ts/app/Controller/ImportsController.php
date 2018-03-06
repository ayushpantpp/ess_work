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

class ImportsController extends AppController {

//put your code herei
    var $name = 'Import';
    var $layout = 'admin';
    public $components = array('Auth', 'Session', 'Email', 'Cookie', 'RequestHandler', 'EmpDetail', 'Common');
    var $uses = array('MstOrg', 'Company', 'OraOrgHcmSal', 'MstEmpLeave', 'SalComponet', 'Holiday', 'OracleHcmEmpLoan', 'OracleHcmEmpPrf', 'DependentDetails', 'OraOrgHcmSalary', 'FinancialYear', 'OracleOrgHcmSalary', 'EmpInvest', 'EmpInvestDtl', 'OracleHcmItProc', 'OraHcmItProc', 'OracleHcmEmpLta', 'OraHcmEmpLta', 'OraDataTransferSync', 'LeaveEncsh', 'LeaveEncshDt', 'LtaBalance', 'OraDataInfo', 'GeneralOracle', 'General', 'OracleHcmEmpLeave', 'OracleHcmEmpLeaveEncsh', 'OraHcmEmpLeaveEncshDtl', 'OraHcmEmpLeaveEncsh', 'OraHcmMonEsiDed', 'OraHcmMonLoanDed', 'OraHcmMonPfDed', 'OraHcmMonProfsnlDed', 'OraHcmMonSuperDed', 'OraHcmMonTaxDed', 'OraHcmDed', 'HcmDed', 'InvestDtl', 'OraHcmInvestDtl', 'WfMstAppMapLvl', 'SectDtl', 'OraHcmSectDtl', 'MyProfile', 'UserDetail', 'Leave', 'Ticker', 'Icon', 'LeaveGrp', 'Department', 'MstEmpLeaveAllot', 'OraDsAtt', 'OraHcmSetup', 'Options', 'OptionAttribute', 'Ora', 'OraAppDept', 'OraHcmEmpSal', 'OraHcmSalProc', 'OraHcmSalProcSal', 'OraHcmSalProcDed', 'OraHcmEmpLeave', 'OraHcmEmpLeaveGrp', 'OraHcmTimeMoveEditDtl', 'SalaryDetail', 'SalaryProcessing', 'SalaryProcessingAddition', 'SalaryProcessingDeduction', 'WfDtAppMapLvl', 'OrgHcmDesgPrf', 'OraOrgHcmDesgPrf', 'HcmDesgPrf', 'OraHcmDesgPrf', 'AttendanceDetail', 'OraHcmGrpLtaSal', 'LtaSal', 'LtaLeave', 'OraHcmLtaLeave', 'OraHcmLeaveGroup', 'LtaGroup', 'EmpEdu', 'EmpExp', 'EmployeeSalMon', 'EmployeeSalMonDt', 'OracleHcmEmpSalMon', 'OraHcmEmpSalMon', 'AttributeType', 'ImportLog', 'OracleHcmDependantDtl', 'OracleHcmEmpExp', 'LeaveDetail', 'KraTarget');
    public $helpers = array('Js', 'Html', 'Form', 'Session', 'Userdetail');

    function beforeFilter() {


        parent::beforeFilter();
            $arr = new Model(array('table' => 'database_config', 'ds' => 'default', 'name' => 'DBCONF'));
        $values = $arr->find('first', array('conditions' => array('type' => 'HCM')));
        if (!empty($values)) {
            App::import('Model', 'ConnectionManager');
            ConnectionManager::create('ora', $config = array('datasource' => 'Database/Oracle',
                'persistent' => false,
                'host' => $values['DBCONF']['host'],
                'port' => $values['DBCONF']['port'],
                'login' => $values['DBCONF']['user_name'],
                'password' => $values['DBCONF']['password'],
                'database' => $values['DBCONF']['host'] . ':' . $values['DBCONF']['port'] . '/' . $values['DBCONF']['sid'],
                    )
            );
        }
        $values_app = $arr->find('first', array('conditions' => array('type' => 'APP')));
        if (!empty($values_app)) {
            ConnectionManager::create('app', $config = array('datasource' => 'Database/Oracle',
                'persistent' => false,
                'host' => $values_app['DBCONF']['host'],
                'port' => $values_app['DBCONF']['port'],
                'login' => $values_app['DBCONF']['user_name'],
                'password' => $values_app['DBCONF']['password'],
                'database' => $values_app['DBCONF']['host'] . ':' . $values_app['DBCONF']['port'] . '/' . $values_app['DBCONF']['sid'],
                    )
            );
        }
        $this->autoRender = false;
        $this->Auth->allow();
        ini_set('memory_limit', '-1');
        ini_set('max_execution_time', 20000);
    }

    function index() {
        $this->set($val, 'val');
        $this->autoRender = true;
        $this->layout = 'admin';
    }

    function import_users() {

        //Configure::write('debug',2);
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
            if (!empty($myData[0])) {
                $data['pf_no'] = $myData[0]['A']['doc_number'];
            }
            if ($myData1[0]['A']['doc_number'] != '') {
                $data['ess_no'] = $myData1[0]['A']['doc_number'];
            } else {
                $data['ess_no'] = '';
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
            $data_user['user_password'] = $this->Auth->password(date('dmY', strtotime(trim($data['dob']))));
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
                $this->ImportLog->save($data_log);
            }
        }

        exit();
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
            $attribute_id = $this->AttributeType->find('first', array('conditions' => array('AttributeType.att_type_id' => $v['OraDsAtt']['att_type_id'])));
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
                $this->ImportLog->save($data_log);
            }
        }
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
        $this->ImportLog->save($data_log);
    }

    function import_options_attr() {
        $this->autoRender = false;
        $this->General->query('TRUNCATE option_attribute');
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
        $this->ImportLog->save($data_log);
    }

    function org_hcm_setup() {
        $this->autoRender = false;
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
        $this->ImportLog->save($data_log);
    }

    function import_departments() {
        $data_oracle = $this->OraAppDept->find('all');
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
        $this->ImportLog->save($data_log);
    }

    function import_ded() {
        $this->autoRender = false;
        $oracle_data = $this->OraHcmDed->find('all');
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
        $this->ImportLog->save($data_log);
        exit();
    }


    function addition_component() {
        $data_oracle_ext_dtl = new Model(array('table' => 'HCM$EMP$MON$EXT$DTL', 'ds' => 'ora', 'name' => 'HCMEMPMONEXTDTL'));
        $data_oracle_ext_ded = $data_oracle_ext_dtl->find('all');
        $data_oracle_done = new Model(array('table' => 'hcmempmonextdtl', 'ds' => 'default',
            'name' => 'HCMEMP'));
        //echo "<pre>"; print_r($data_oracle_ext_ded); die;
        foreach ($data_oracle_ext_ded as $val) {
            $data['HCMEMP'] = $val['HCMEMPMONEXTDTL'];
            $data_oracle_done->create();
            $data_oracle_done->save($data);
        }
    }

    function import_deductions() {
        $this->autoRender = false;
        $data_oracle_advance = new Model(array('table' => 'HCM$EMP$ADVNCE', 'ds' => 'ora', 'name' => 'HCMEMPADVNCE'));
        $data_oracle_advance_ded = $data_oracle_advance->find('all');

        //echo "<pre>"; print_r($data_oracle_advance_ded); die;
        foreach ($data_oracle_advance_ded as $val) {

            $data['org_id'] = $val['HCMEMPADVNCE']['org_id'];
            $emp_code = $this->Common->getEmpCodeByDocID($val['HCMEMPADVNCE']['emp_doc_id']);
            $data['emp_code'] = $emp_code;
            $data['emp_doc_id'] = $val['HCMEMPADVNCE']['emp_doc_id'];
            $data['proc_frm_dt'] = $val['HCMEMPADVNCE']['proc_frm_dt'];
            $data['proc_to_dt'] = $val['HCMEMPADVNCE']['proc_to_dt'];
            $data['ded_doc_id'] = $val['HCMEMPADVNCE']['doc_id'];
            $data['ded_amt'] = $val['HCMEMPADVNCE']['advance_paid_amt'];
            $this->SalaryProcessingDeduction->create();
            $this->SalaryProcessingDeduction->save($data);
        }

        $data_oracle_ded_emp = new Model(array('table' => 'HCM$MON$EMP$DED', 'ds' => 'ora', 'name' => 'HCMMONEMPDED'));
        $oracle_data_ded_ded = $data_oracle_ded_emp->find('all', array('conditions' => array('ded_type' => 374)));
        //print_r($oracle_data_ded_ded); die;
        foreach ($oracle_data_ded_ded as $val) {
            $data['org_id'] = $val['HCMMONEMPDED']['org_id'];
            $emp_code = $this->Common->getEmpCodeByDocID($val['HCMMONEMPDED']['emp_doc_id']);
            $data['emp_code'] = $emp_code;
            $data['emp_doc_id'] = $val['HCMMONEMPDED']['emp_doc_id'];
            $data['proc_frm_dt'] = $val['HCMMONEMPDED']['proc_frm_dt'];
            $data['proc_to_dt'] = $val['HCMMONEMPDED']['proc_to_dt'];
            $data['ded_doc_id'] = $val['HCMMONEMPDED']['ded_doc_id'];
            $data['ded_amt'] = $val['HCMMONEMPDED']['emp_ded_amt'];
            $this->SalaryProcessingDeduction->create();
            $this->SalaryProcessingDeduction->save($data);
        }

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
        $data_oracle_nhif = new Model(array('table' => 'HCM$MON$NHIF$DED', 'ds' => 'ora', 'name' => 'HCMMONNHIFDED'));
        $data_oracle_nhif_ded = $data_oracle_nhif->find('all');
        foreach ($data_oracle_nhif_ded as $val) {
            $data['org_id'] = $val['HCMMONNHIFDED']['org_id'];
            $data['emp_code'] = $val['HCMMONNHIFDED']['emp_code'];
            $data['emp_doc_id'] = $val['HCMMONNHIFDED']['emp_doc_id'];
            $data['proc_frm_dt'] = $val['HCMMONNHIFDED']['proc_frm_dt'];
            $data['proc_to_dt'] = $val['HCMMONNHIFDED']['proc_to_dt'];
            $data['ded_doc_id'] = $val['HCMMONNHIFDED']['ded_doc_id'];
            $data['ded_amt'] = $val['HCMMONNHIFDED']['emp_amt'];
            $this->SalaryProcessingDeduction->create();
            $this->SalaryProcessingDeduction->save($data);
        }


        //HCM$EMP$MON$EXT$DTL
        //ESI deduction HCM$MON$NHIF$DED
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
        //Loan deduction
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
            $data['vpf'] = $val['OraHcmMonPfDed']['vpf_amt'];
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
        $this->ImportLog->save($data_log);
        exit();
    }

    function import_loan_prf() {
        $this->General->query('TRUNCATE oracle_hcm_emp_loan');

        $this->autoRender = false;
        $loan_prf = new Model(array('table' => 'HCM$EMP$LOAN', 'ds' => 'ora', 'name' => 'HCMEMPLOAN'));
        $oracle_data = $loan_prf->find('all');

        foreach ($oracle_data as $val) {
            $data['OracleHcmEmpLoan'] = $val['HCMEMPLOAN'];
            $this->OracleHcmEmpLoan->create();
            $this->OracleHcmEmpLoan->save($data);
        }
    }

    function import_comp_off_trans() {
        $this->General->query('TRUNCATE comp_off_leave_trans');
        $this->autoRender = false;
        $comp_off = new Model(array('table' => 'comp_off_leave_trans', 'ds' => 'default', 'name' => 'COMPOFF'));
        $loan_prf = new Model(array('table' => 'hcm$comp$off$leave$trans', 'ds' => 'ora', 'name' => 'HCMCOMPOFF'));
        $oracle_data = $loan_prf->find('all');
        foreach ($oracle_data as $val) {
            $data['COMPOFF'] = $val['HCMCOMPOFF'];
            $comp_off->create();
            $comp_off->save($data);
        }
    }

    function import_it_proc() {
        $this->autoRender = false;
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
        $this->ImportLog->save($data_log);
    }

    function import_org_hcm_salary() {
        $this->autoRender = false;
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
        $this->ImportLog->save($data_log);
    }

    function import_salary() {
        $this->autoRender = false;
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
        $this->ImportLog->save($data_log);
    }

    //function to import the processed salary
    function import_salary_proc() {
        $this->autoRender = false;
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
        $this->ImportLog->save($data_log);
    }

//function to import the processed salary addition
    function import_salary_proc_addition() {
        $this->autoRender = false;
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
        $this->ImportLog->save($data_log);
    }

//function to import the processed salary deductions
    function import_salary_proc_deduction() {
        $this->autoRender = false;
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
        $this->ImportLog->save($data_log);
    }

//function to import leaves ...hardcoded value of leaves to import in mst_leave_type table
    function import_leaves() {
        $this->autoRender = false;
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
        $this->ImportLog->save($data_log);
    }

    function import_lta() {
        $this->autoRender = false;
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
        $this->ImportLog->save($data_log);
        exit();
    }

    function import_leave_groups() {
        $this->autoRender = false;
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
        $this->ImportLog->save($data_log);
    }

//function to import whole desg table
    function import_desg_levels() {
        $this->autoRender = false;
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
        $this->ImportLog->save($data_log);
    }

//function to create ticker and icons for each department
    function ticker_and_icons() {
        $departments = $this->Department->find('list', array(
            'fields' => 'id'
                )
        );
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
            //add default data to icons
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
        $this->ImportLog->save($data_log);

        exit();
    }

//function to get the attendance of all the employee
    function import_attendance() {
        $this->General->query('TRUNCATE attendance_details');
        $n = '$';
        $table = 'HCM' . $n . 'TIME' . $n . 'MOVE' . $n . 'EDIT' . $n . 'DTL';
        $qn = "SELECT OraHcmTimeMoveEditDtl.extra_time_hr_bkp, OraHcmTimeMoveEditDtl.hlffay_leave_type, OraHcmTimeMoveEditDtl.cld_id, OraHcmTimeMoveEditDtl.sloc_id, OraHcmTimeMoveEditDtl.ho_org_id, OraHcmTimeMoveEditDtl.org_id, OraHcmTimeMoveEditDtl.emp_doc_id, OraHcmTimeMoveEditDtl.atten_dt, OraHcmTimeMoveEditDtl.leave_id, OraHcmTimeMoveEditDtl.extra_time_hr, OraHcmTimeMoveEditDtl.usr_id_create, OraHcmTimeMoveEditDtl.usr_id_create_dt, OraHcmTimeMoveEditDtl.usr_id_mod, OraHcmTimeMoveEditDtl.usr_id_mod_dt, to_char(OraHcmTimeMoveEditDtl.in_time,'dd-mm-yyyy HH24:MI:SS') as in_time, to_char(OraHcmTimeMoveEditDtl.out_time,'dd-mm-yyyy HH24:MI:SS') as out_time, OraHcmTimeMoveEditDtl.ded_ch, OraHcmTimeMoveEditDtl.wk_off_chk, OraHcmTimeMoveEditDtl.hlfday_leave_chk, OraHcmTimeMoveEditDtl.emp_dept_id, OraHcmTimeMoveEditDtl.emp_grp_id, OraHcmTimeMoveEditDtl.emp_loc_id, OraHcmTimeMoveEditDtl.emp_id, OraHcmTimeMoveEditDtl.add_comp_leave_chk, OraHcmTimeMoveEditDtl.qtr_leave_chk, OraHcmTimeMoveEditDtl.leave_proof_submit_chk, OraHcmTimeMoveEditDtl.prj_doc_id, OraHcmTimeMoveEditDtl.rest_day_chk, OraHcmTimeMoveEditDtl.remarks FROM $table OraHcmTimeMoveEditDtl";
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
			$data_org['description'] = $v['OraHcmTimeMoveEditDtl']['remarks'];
            
            $this->AttendanceDetail->create();
            $this->AttendanceDetail->save($data_org);
        }
        $data_log['function_name'] = 'import_attendance';
        $data_log['module_related'] = 'ATTENDANCE';
        $data_log['last_run'] = date('Y-m-d');
        $data_log['status'] = 1;
        $this->ImportLog->save($data_log);
        exit();
    }

    function import_attendance_today() {

                //$this->General->query('TRUNCATE attendance_details');

        $n = '$';
        $table = 'HCM' . $n . 'TIME' . $n . 'MOVE' . $n . 'EDIT' . $n . 'DTL';
        $date = date('d-M-Y', strtotime(date('d-m-Y') . ' -1 day'));
          $qn = "SELECT OraHcmTimeMoveEditDtl.extra_time_hr_bkp, OraHcmTimeMoveEditDtl.hlffay_leave_type, OraHcmTimeMoveEditDtl.cld_id, OraHcmTimeMoveEditDtl.sloc_id, OraHcmTimeMoveEditDtl.ho_org_id, OraHcmTimeMoveEditDtl.org_id, OraHcmTimeMoveEditDtl.emp_doc_id, OraHcmTimeMoveEditDtl.atten_dt, OraHcmTimeMoveEditDtl.leave_id, OraHcmTimeMoveEditDtl.extra_time_hr, OraHcmTimeMoveEditDtl.usr_id_create, OraHcmTimeMoveEditDtl.usr_id_create_dt, OraHcmTimeMoveEditDtl.usr_id_mod, OraHcmTimeMoveEditDtl.usr_id_mod_dt, to_char(OraHcmTimeMoveEditDtl.in_time,'dd-mm-yyyy HH24:MI:SS') as in_time, to_char(OraHcmTimeMoveEditDtl.out_time,'dd-mm-yyyy HH24:MI:SS') as out_time, OraHcmTimeMoveEditDtl.ded_ch, OraHcmTimeMoveEditDtl.wk_off_chk, OraHcmTimeMoveEditDtl.hlfday_leave_chk, OraHcmTimeMoveEditDtl.emp_dept_id, OraHcmTimeMoveEditDtl.emp_grp_id, OraHcmTimeMoveEditDtl.emp_loc_id, OraHcmTimeMoveEditDtl.emp_id, OraHcmTimeMoveEditDtl.add_comp_leave_chk, OraHcmTimeMoveEditDtl.qtr_leave_chk, OraHcmTimeMoveEditDtl.leave_proof_submit_chk, OraHcmTimeMoveEditDtl.prj_doc_id, OraHcmTimeMoveEditDtl.rest_day_chk, OraHcmTimeMoveEditDtl.remarks FROM $table OraHcmTimeMoveEditDtl where to_char(OraHcmTimeMoveEditDtl.atten_dt,'dd-Mon-yyyy') = '$date'";
        $db = ConnectionManager::getDataSource('ora');
        $myData = $db->query($qn);

		//print_r($myData);die;
         foreach ($myData as $k => $v) {
            $data_org = $v['OraHcmTimeMoveEditDtl'];
            $atten_dt = $data_org['atten_dt'];
			$chk = $this->AttendanceDetail->find('first',array('conditions'=>array('atten_dt'=>$atten_dt,'emp_doc_id'=>$data_org['emp_doc_id'])));
		 if(!empty($chk)){
			$this->AttendanceDetail->delete($chk['AttendanceDetail']['id']);
		} 

            if (!empty($v['0']['in_time']) && !empty($v['0']['out_time'])) {
                $data_org['in_time'] = date('Y-m-d H:i:s', strtotime($v['0']['in_time']));
                $data_org['out_time'] = date('Y-m-d H:i:s', strtotime($v['0']['out_time']));
            } else {
                $data_org['in_time'] = date('Y-m-d H:i:s', strtotime($v['0']['in_time']));
                $data_org['out_time'] = date('Y-m-d H:i:s', strtotime($v['0']['out_time']));
            }

                        $data_org['description'] = $v['OraHcmTimeMoveEditDtl']['remarks'];
                        $this->AttendanceDetail->create();
            $this->AttendanceDetail->save($data_org);
        }
                $data_log['function_name'] = 'import_attendance';

        $data_log['module_related'] = 'ATTENDANCE';
        $data_log['last_run'] = date('Y-m-d');
        $data_log['status'] = 1;
        $this->ImportLog->save($data_log);
        exit();
    }
 


    function update_attendance() {
        $data_oracle = $this->OraHcmTimeMoveEditDtl->find('all');
        foreach ($data_oracle as $k => $v) {
            $data_org = $v['OraHcmTimeMoveEditDtl'];
            $atten_dt = $data_org['atten_dt'];
            $t = date('Y-m-d', strtotime($atten_dt));
            $in_t = $t . '09:' . rand(15, 59) . ':00';
            $out_t = $t . '18:' . rand(15, 59) . ':00';
            $data_org['in_time'] = date('Y-m-d H:i:s', strtotime($in_t));
            $data_org['out_time'] = date('Y-m-d H:i:s', strtotime($out_t));
            $this->AttendanceDetail->create();
            $this->AttendanceDetail->save($data_org);
        }
        $data_log['function_name'] = 'import_attendance';
        $data_log['module_related'] = 'ATTENDANCE';
        $data_log['last_run'] = date('Y-m-d');
        $data_log['status'] = 1;
        $this->ImportLog->save($data_log);
        exit();
    }

    function import_section() {
        $this->autoRender = false;
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
        $this->ImportLog->save($data_log);
        exit();
    }

    function import_invest_dtl() {
        $this->autoRender = false;
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
        $this->ImportLog->save($data_log);

        exit();
    }

    function import_lta_grp_sal() {
        $this->autoRender = false;
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
        $this->ImportLog->save($data_log);
        exit();
    }

    function import_lta_leave() {
        $this->autoRender = false;
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
        $this->ImportLog->save($data_log);
        exit();
    }

    function import_lta_group() {
        $this->autoRender = false;
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
        $this->ImportLog->save($data_log);
        exit();
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
        $this->ImportLog->save($data_log);
        exit();
    }

    function import_emp_invest() {
        $this->autoRender = false;
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
        $this->ImportLog->save($data_log);
        exit();
    }

    function import_app_eo() {
        // This is for Bank Detail Master
        $this->autoRender = false;
        $this->General->query('TRUNCATE oracle_app_eo');

        $eo_model = new Model(array('table' => 'APP$EO', 'ds' => 'app', 'name' => 'OraAppEo'));
        $oracle_data = $eo_model->find('all', array('conditions' => array('eo_type in (74,68)')));
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
        $this->ImportLog->save($data_log);
    }

    function import_app_eo_mst() {
// This is for Bank Detail Master
        $this->autoRender = false;
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
        $this->ImportLog->save($data_log);
    }

    function integration_update_cron() {
        $oracle_sync_data = $this->OraDataTransferSync->find('first', array(
            'conditions' => array(
                'task_name' => 'HCM_SYNC'
            )
        ));
        $new_cnt = 0;
        $syn = $oracle_sync_data['OraDataTransferSync']['task_status'];
        if ($syn == 0) {
            $this->General->query('UPDATE data_transfer_sync set task_status = 1;');
            $oracle_ch_data = $this->OraDataInfo->find('all', array(
                'conditions' => array(
                    'operation !=' => 'DELETE'
                )
            ));
            $this->General->query('SET @DISABLE_TRIGGERS = 1;');
            foreach ($oracle_ch_data as $val) {
                echo $new_cnt;
                $new_cnt++;
                $oracle_condi = array(
                    $val['OraDataInfo']['col_name'] => $val['OraDataInfo']['col_data'],
                );
                $cols = explode(',', $val['OraDataInfo']['col_name']);
                $vals = explode(',', $val['OraDataInfo']['col_data']);
                $i = 0;
                foreach ($cols as $v) {
                    $oracle_cond[$cols[$i]] = $vals[$i];
                    $i++;
                }
                $tbname = str_replace('$', '_', $val['OraDataInfo']['tab_name']);
                $use_id = $val['OraDataInfo']['id'];
                $dep = new Model(array('table' => 'HCM$EMP$DPND$DTL', 'ds' => 'ora', 'name' => 'HCMEMPDPNDDTL'));
                $emp_sal_mon = new Model(array('table' => 'HCM$EMP$SAL$MON', 'ds' => 'ora', 'name' => 'HCMEMPSALMON'));
                switch ($tbname) {
                    case 'ORG_HCM_SALARY':
                        $data_oracle = $this->OraOrgHcmSalary->find('first', array('conditions' => $oracle_cond));
                        $data = $data_oracle['OraOrgHcmSalary'];
                        $present_data = $this->OracleOrgHcmSalary->find('first', array(
                            'conditions' => array(
                                'sal_id' => $data['sal_id'],
                                'org_id' => $data['org_id'],
                        )));
                        if ($present_data) {
                            $present_id = $present_data['OracleOrgHcmSalary']['id'];
                            $this->OracleOrgHcmSalary->id = $present_id;
                            $this->OracleOrgHcmSalary->save($data);
                        } else {
                            $this->OracleOrgHcmSalary->create();
                            $this->OracleOrgHcmSalary->save($data);
                        }
                        print_r("Done ORG_HCM_SALARY");
                        break;
                    case 'HCM_EMP_LOAN':
                        $loan_prf = new Model(array('table' => 'HCM$EMP$LOAN', 'ds' => 'ora', 'name' => 'HCMEMPLOAN'));
                        $oracle_data = $loan_prf->find('first', array('conditions' => $oracle_cond));
                        $data['OracleHcmEmpLoan'] = $oracle_data['HCMEMPLOAN'];
                        $present_data = $this->OracleHcmEmpLoan->find('first', array(
                            'conditions' => array(
                                'doc_id' => $data['OracleHcmEmpLoan']['doc_id'],
                                'org_id' => $data['OracleHcmEmpLoan']['org_id'],
                                'emp_doc_id' => $data['OracleHcmEmpLoan']['emp_doc_id'],
                                'loan_id' => $data['OracleHcmEmpLoan']['loan_id']
                        )));
                        if ($present_data) {
                            $present_id = $present_data['OracleHcmEmpLoan']['id'];
                            $this->OracleHcmEmpLoan->id = $present_id;
                            $this->OracleHcmEmpLoan->save($data);
                        } else {
                            $this->OracleHcmEmpLoan->create();
                            $this->OracleHcmEmpLoan->save($data);
                        }
                        print_r("Done HCM_EMP_LOAN");
                        break;

                    case 'HCM_EMP_SAL':
                        $data_oracle = $this->OraHcmEmpSal->find('first', array('conditions' => $oracle_cond));
                        $data = $data_oracle['OraHcmEmpSal'];
                        $data['emp_id'] = $data['emp_code'];
                        unset($data['emp_code']);
                        $present_data = $this->SalaryDetail->find('first', array(
                            'conditions' => array(
                                'doc_id' => $data['doc_id'],
                                'org_id' => $data['org_id'],
                                'sal_id' => $data['sal_id']
                        )));
                        if ($present_data) {
                            $present_id = $present_data['SalaryDetail']['id'];
                            $this->SalaryDetail->id = $present_id;
                            $this->SalaryDetail->save($data);
                        } else {
                            $this->SalaryDetail->create();
                            $this->SalaryDetail->save($data);
                        }
                        print_r("Done HCM_EMP_SAL");
                        break;

                    case 'HCM_DED':
                        $data_oracle = $this->OraHcmDed->find('first', array('conditions' => $oracle_cond));
                        $data['org_id'] = $data_oracle['OraHcmDed']['org_id'];
                        $data['doc_id'] = $data_oracle['OraHcmDed']['doc_id'];
                        $data['ded_desc'] = $data_oracle['OraHcmDed']['ded_desc'];
                        $data['ded_id'] = $data_oracle['OraHcmDed']['ded_id'];
                        $data['sloc_id'] = $data_oracle['OraHcmDed']['sloc_id'];
                        $data['ho_org_id'] = $data_oracle['OraHcmDed']['ho_org_id'];
                        $data['ded_amt'] = $data_oracle['OraHcmDed']['ded_amt'];
                        $data['ded_type'] = $data_oracle['OraHcmDed']['ded_type'];
                        $present_data = $this->HcmDed->find('first', array(
                            'conditions' => array(
                                'doc_id' => $data['doc_id'],
                                'org_id' => $data['org_id']
                        )));
                        if ($present_data) {
                            $present_id = $present_data['HcmDed']['id'];
                            $this->HcmDed->id = $present_id;
                            $this->HcmDed->save($data);
                        } else {
                            $this->HcmDed->create();
                            $this->HcmDed->save($data);
                        }
                        print_r("Done HCM_EMP_SAL");
                        break;

                    case 'HCM_LEAVE_GRP':
                        $qual = new Model(array('table' => 'HCM$LEAVE$GRP', 'ds' => 'ora', 'name' => 'HCMLEAVEGRP'));
                        $row = $qual->find('first', array('conditions' => $oracle_cond));
                        if ($val['OraDataInfo']['operation'] == 'UPDATE') {
                            echo "update";
                            $data_org_id = $row['HCMLEAVEGRP']['org_id'];
                            $data_leave_code = $row['HCMLEAVEGRP']['leave_id'];
                            $data_grp_id = $row['HCMLEAVEGRP']['grp_id'];
                            $data_leave_accrual_rate = $row['HCMLEAVEGRP']['leave_accrual_rate'];
                            $data_carry_fw_ch = $row['HCMLEAVEGRP']['carry_fwd_ch'];
                            $data_leave_proof_ch = $row['HCMLEAVEGRP']['leave_proof_ch'];
                            $data_leave_encash_limit = $row['HCMLEAVEGRP']['leave_encash_limit'];
                            $data_leave_encash_ch = $row['HCMLEAVEGRP']['leave_encash_ch'];
                            $data_leav_max_limit = $row['HCMLEAVEGRP']['leave_max_limit'];
                            $data_mtrnty_leave_check = $row['HCMLEAVEGRP']['mtrnty_leave_chk'];
                            $this->LeaveGrp->query("update leave_grp SET org_id='$data_org_id', leave_code='$data_leave_code', grp_id='$data_grp_id', leave_accrual_rate='$data_leave_accrual_rate', carry_fwd_ch='$data_carry_fw_ch', leave_proof_ch='$data_leave_proof_ch', leave_encash_limit='$data_leave_encash_limit', leave_encash_ch='$data_leave_encash_ch', leave_max_limit='$data_leav_max_limit',mtrnty_leave_chk='$data_mtrnty_leave_check', mtrnty_leave_days='data_mtrnty_leave_days' where org_id='$data_org_id' and leave_code='$data_leave_code' and grp_id='$data_grp_id'");
                        } elseif ($val['OraDataInfo']['operation'] == 'DELETE') {
                            echo "delete";
                            $data_org_id = $row['HCMLEAVEGRP']['org_id'];
                            $data_leave_code = $row['HCMLEAVEGRP']['leave_id'];
                            $data_grp_id = $row['HCMLEAVEGRP']['grp_id'];
                            $this->LeaveGrp->query("DELETE FROM leave_grp WHERE org_id='$data_org_id' and leave_code='$data_leave_code' and grp_id='$data_grp_id'");
                        } elseif ($val['OraDataInfo']['operation'] == 'INSERT') {
                            $data_org_id = $row['HCMLEAVEGRP']['org_id'];
                            $data_leave_code = $row['HCMLEAVEGRP']['leave_id'];
                            $data_grp_id = $row['HCMLEAVEGRP']['grp_id'];
                            $data_leave_accrual_rate = $row['HCMLEAVEGRP']['leave_accrual_rate'];
                            $data_carry_fw_ch = $row['HCMLEAVEGRP']['carry_fwd_ch'];
                            $data_leave_proof_ch = $row['HCMLEAVEGRP']['leave_proof_ch'];
                            $data_leave_encash_limit = $row['HCMLEAVEGRP']['leave_encash_limit'];
                            $data_leave_encash_ch = $row['HCMLEAVEGRP']['leave_encash_ch'];
                            $data_leav_max_limit = $row['HCMLEAVEGRP']['leave_max_limit'];
                            $data_mtrnty_leave_check = $row['HCMLEAVEGRP']['mtrnty_leave_chk'];
                            $this->LeaveGrp->create();
                            $this->LeaveGrp->query("insert into leave_grp (org_id, leave_code, grp_id, leave_accrual_rate, carry_fwd_ch, leave_proof_ch, leave_encash_limit, leave_encash_ch, leave_max_limit,mtrnty_leave_chk, mtrnty_leave_days) values ('$data_org_id','$data_leave_code','$data_grp_id','$data_leave_accrual_rate','$data_carry_fw_ch','$data_leave_proof_ch','$data_leave_encash_limit','$data_leave_encash_ch','$data_leav_max_limit','$data_mtrnty_leave_check','data_mtrnty_leave_days')");
                        }
                        print_r("Done HCM_LEAVE_GRP");
                        break;

                    case 'HCM_EMP_QUAL':
                        $qual = new Model(array('table' => 'HCM$EMP$QUAL', 'ds' => 'ora', 'name' => 'HCMEMPQUAL'));
                        $edu = $qual->find('first', array('conditions' => $oracle_cond));
                        $data['emp_doc_id'] = $edu['HCMEMPQUAL']['doc_id'];
                        $data['emp_code'] = $edu['HCMEMPQUAL']['emp_code'];
                        $data['course_id'] = $edu['HCMEMPQUAL']['course_id'];
                        $data['yop'] = $edu['HCMEMPQUAL']['yop'];
                        $data['mark_obtain'] = $edu['HCMEMPQUAL']['mark_obtain'];
                        $data['qual_type_id'] = $edu['HCMEMPQUAL']['qual_type_id'];
                        $data['ins_nm'] = $edu['HCMEMPQUAL']['ins_nm'];
                        $present_data = $this->EmpEdu->find('first', array(
                            'conditions' => array(
                                'emp_doc_id' => $edu['HCMEMPQUAL']['doc_id'],
                                'course_id' => $edu['HCMEMPQUAL']['course_id']
                        )));
                        if ($present_data) {
                            $present_id = $present_data['EmpEdu']['id'];
                            $this->EmpEdu->id = $present_id;
                            $this->EmpEdu->save($data);
                        } else {
                            $this->EmpEdu->create();
                            $this->EmpEdu->save($data);
                        }
                        print_r('done HCM_EMP_QUAL');
                        break;

                    case 'HCM_EMP_EXP':
                        $qual = new Model(array('table' => 'HCM$EMP$EXP', 'ds' => 'ora', 'name' => 'HCMEMPEXP'));
                        $org_id = $oracle_cond[' ORG_ID'];
                        $emp_doc_id = $oracle_cond[' DOC_ID'];
                        $join_dt = $oracle_cond[' EMP_ORG_DOJ'];
                        $org_name = $oracle_cond[' EMP_ORG_NM'];
                        $exp = $qual->find('first', array('conditions' => array('ORG_ID' => $org_id, 'DOC_ID' => $emp_doc_id, "to_char(EMP_ORG_DOJ,'DD-MON-YY')" => $join_dt, 'EMP_ORG_NM' => $org_name)));
                        $data['emp_doc_id'] = $exp['HCMEMPEXP']['doc_id'];
                        $data['emp_code'] = $exp['HCMEMPEXP']['emp_code'];
                        $data['org_id'] = $exp['HCMEMPEXP']['org_id'];
                        $data['emp_org_nm'] = $exp['HCMEMPEXP']['emp_org_nm'];
                        $data['emp_org_doj'] = $exp['HCMEMPEXP']['emp_org_doj'];
                        $data['emp_org_dol'] = $exp['HCMEMPEXP']['emp_org_dol'];
                        $data['emp_org_sal'] = $exp['HCMEMPEXP']['emp_org_sal'];
                        $data['emp_org_desig'] = $exp['HCMEMPEXP']['emp_org_desig'];
                        $data['emp_org_loc'] = $exp['HCMEMPEXP']['emp_org_loc'];
                        $present_data = $this->EmpExp->find('first', array(
                            'conditions' => array(
                                'emp_doc_id' => $exp['HCMEMPEXP']['doc_id'],
                                'org_id' => $exp['HCMEMPEXP']['org_id'],
                                'emp_code' => $exp['HCMEMPEXP']['emp_code'],
                                'emp_org_nm' => $exp['HCMEMPEXP']['emp_org_nm']
                        )));
                        if ($present_data) {
                            $present_id = $present_data['EmpExp']['id'];
                            $this->EmpExp->id = $present_id;
                            $this->EmpExp->save($data);
                        } else {
                            $this->EmpExp->create($data);
                            $this->EmpExp->save($data);
                        }
                        print_r("Done HCM_EMP_EXP");
                        break;

                    case 'HCM_EMP_DPND_DTL':
                        $qual = new Model(array('table' => 'HCM$EMP$DPND$DTL', 'ds' => 'ora', 'name' => 'HCMEMPDPNDTL'));
                        $dy = $qual->find('first', array('conditions' => $oracle_cond));
                        $data['member_name'] = $dy['HCMEMPDPNDTL']['mem_nm'];
                        $data['relation'] = $dy['HCMEMPDPNDTL']['mem_rel'];
                        $data['occupation'] = $dy['HCMEMPDPNDTL']['mem_occu'];
                        $data['Dob'] = $dy['HCMEMPDPNDTL']['mem_dob'];
                        $data['gender'] = $dy['HCMEMPDPNDTL']['mem_gen'];
                        $myprofile = $this->MyProfile->find('first', array('fields' => array('id'), 'conditions' => array('doc_id' => $dy['HCMEMPDPNDTL']['doc_id'])));
                        $data['myprofile_id'] = $myprofile['MyProfile']['id'];
                        $data['status'] = 5;
                        $present_data = $this->DependentDetails->find('first', array(
                            'conditions' => array(
                                'myprofile_id' => $myprofile['MyProfile']['id'],
                                'member_name' => $dy['HCMEMPDPNDTL']['mem_nm']
                        )));
                        if ($val['OraDataInfo']['operation'] == 'DELETE') {
                            echo "delete";
                            $this->DependentDetails->query("DELETE FROM `dependent_details` WHERE `id`=" . $present_data['DependentDetails']['id'] . "");
                        } else {
                            if ($present_data) {
                                $present_id = $present_data['DependentDetails']['id'];
                                $this->DependentDetails->id = $present_id;
                                $this->DependentDetails->save($data);
                            } else {
                                $this->DependentDetails->create($data);
                                $this->DependentDetails->save($data);
                            }
                        }
                        $this->OracleHcmDependantDtl->delete($replica_id);
                        print_r("Done HCM_EMP_DPND_DTL");
                        break;

                    case 'ORG_HCM_EMP_PRF':
                        //get updated row
                        $row = $this->Ora->find('first', array(
                            'conditions' => $oracle_cond));
                        $replica_data['OracleHcmEmpPrf'] = $row['Ora'];
                        $this->OracleHcmEmpPrf->create();
                        $this->OracleHcmEmpPrf->save($replica_data);
                        $replica_id = $this->OracleHcmEmpPrf->getLastInsertID();
                        $v = $this->OracleHcmEmpPrf->findById($replica_id);
                        /*                         * ************* Test *********************************** */
                        $data['emp_pay_mode'] = $v['OracleHcmEmpPrf']['emp_pay_mode'];
                        $data['emp_code'] = $v['OracleHcmEmpPrf']['emp_code'];
                        $data['emp_id'] = $v['OracleHcmEmpPrf']['emp_id'];
                        $data['dept_code'] = $v['OracleHcmEmpPrf']['emp_dept_id'];
                        $data['desg_code'] = $v['OracleHcmEmpPrf']['emp_desg_id'];
                        $data['comp_code'] = $v['OracleHcmEmpPrf']['org_id'];
                        $data['gender'] = $v['OracleHcmEmpPrf']['emp_gen'];
                        $data['contact'] = $v['OracleHcmEmpPrf']['emp_phone1'];
                        $data['personal_phone'] = $v['OracleHcmEmpPrf']['emp_phone2'];
                        $data['dob'] = $v['OracleHcmEmpPrf']['emp_dob'];
                        $data['join_date'] = $v['OracleHcmEmpPrf']['emp_doj'];
                        $data['cur_address'] = $v['OracleHcmEmpPrf']['emp_curr_add'];
                        $data['per_address'] = $v['OracleHcmEmpPrf']['emp_perm_add'];
                        $data['marital_code'] = $v['OracleHcmEmpPrf']['emp_mrtl_stat'];
                        $data['blood_group'] = $v['OracleHcmEmpPrf']['emp_bld_grp'];
                        $data['card_no'] = $v['OracleHcmEmpPrf']['emp_card_no'];
                        $data['location_code'] = $v['OracleHcmEmpPrf']['emp_loc_id'];
                        $data['emp_pay_mode'] = $v['OracleHcmEmpPrf']['emp_pay_mode'];
                        $data['bank_code'] = $v['OracleHcmEmpPrf']['emp_bnk_id'];
                        $data['branch_code'] = $v['OracleHcmEmpPrf']['bnk_brnch_id'];
                        $data['account_type'] = $v['OracleHcmEmpPrf']['acc_type'];
                        $data['account_no'] = $v['OracleHcmEmpPrf']['acc_no'];
                        $data['ifsc_code'] = $v['OracleHcmEmpPrf']['ifsc_code'];
                        $data['swift_code'] = $v['OracleHcmEmpPrf']['swift_code'];
                        $data['pan_no'] = $v['OracleHcmEmpPrf']['emp_pan_no'];
                        $data['guardian_name'] = $v['OracleHcmEmpPrf']['emp_guard_nm'];
                        $data['guardian_relation'] = $v['OracleHcmEmpPrf']['emp_rel'];
                        $data['notice_period'] = $v['OracleHcmEmpPrf']['emp_notice'];
                        $data['manager_code'] = $v['OracleHcmEmpPrf']['mgr_code'];
                        $data['emp_grp_id'] = $v['OracleHcmEmpPrf']['emp_grp_id'];
                        $data['doc_id'] = $v['OracleHcmEmpPrf']['doc_id'];
                        $data['emp_full_name'] = $v['OracleHcmEmpPrf']['emp_nm'];
                        $data['emp_middle'] = $v['OracleHcmEmpPrf']['emp_nm_2'];
                        $data['status'] = $v['OracleHcmEmpPrf']['wrk_stat'];
                        $data['emp_nm_ttl'] = $v['OracleHcmEmpPrf']['emp_nm_ttl'];
                        $data['emp_firstname'] = $v['OracleHcmEmpPrf']['emp_nm_1'];
                        $data['emp_lastname'] = $v['OracleHcmEmpPrf']['emp_nm_3'];
                        $data['per_email'] = $v['OracleHcmEmpPrf']['ofc_email'];
                        $user = explode(' ', trim($v['OracleHcmEmpPrf']['emp_nm']));
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
//create data for user table
                        $data_user['emp_code'] = $v['OracleHcmEmpPrf']['emp_code'];
                        $data_user['emp_id'] = $v['OracleHcmEmpPrf']['emp_id'];
                        $data_user['email'] = $v['OracleHcmEmpPrf']['emp_email'];
                        $data_user['comp_code'] = $v['OracleHcmEmpPrf']['org_id'];
                        $data_user['user_password'] = 'b5bfd997acb37317902ded4df5e7bfdb31df2b7d';
                        $data_user['user_name'] = $data['emp_firstname'];
                        if (isset($data['emp_lastname'])) {
                            $data_user['user_name'] .= '.' . $data['emp_lastname'];
                        }
                        $present_data = $this->MyProfile->find('first', array(
                            'conditions' => array(
                                'emp_code' => $v['OracleHcmEmpPrf']['emp_code'],
                                'comp_code' => $v['OracleHcmEmpPrf']['org_id'],
                        )));
                        $userId = $this->UserDetail->find('first', array(
                            'conditions' => array(
                                'emp_code' => $v['OracleHcmEmpPrf']['emp_code'],
                                'comp_code' => $v['OracleHcmEmpPrf']['org_id'],
                            )
                        ));
                        if ($present_data) {
                            $present_user = $userId['UserDetail']['id'];
                            $present_id = $present_data['MyProfile']['id'];
                            $present_user_id = $userId['UserDetail']['id'];

                            if ($userId) {
                                unset($data_user['user_password']);

                                $this->UserDetail->id = $userId;
                                $this->UserDetail->save($data_user);
                            }
                            $this->MyProfile->id = $present_id;
                            $present_data['MyProfile']['id'] = $present_id;
                            $this->MyProfile->save($data);
                            $emp_code = $data_user['emp_code'];
                            $appraiser_id = $this->Common->getManagerCode($emp_code);
                            $reviewer_id = $this->Common->getManagerCode($appraiser_id);
                            $moderator_id = $this->Common->getManagerCode($reviewer_id);
                            $success = $this->KraTarget->UpdateAll(
                                    array('KraTarget.appraiser_id' => $appraiser_id, 'KraTarget.reviewer_id' => $reviewer_id, 'KraTarget.moderator_id' => $moderator_id
                                    ), array('KraTarget.emp_code' => $emp_code));
                        } else {
                            $this->UserDetail->save($data_user);
                            $this->MyProfile->save($data);
                        }
                        $this->OracleHcmEmpPrf->delete($replica_id);
                        print_r('DONE ORG_HCM_EMP_PRF');
                        break;

                    case "HCM_EMP_LEAVE_ENCSH":
                        $row = $this->OraHcmEmpLeaveEncsh->find('first', array(
                            'conditions' => $oracle_cond
                        ));
                        $replica_data['OracleHcmEmpLeaveEncsh'] = $row['OraHcmEmpLeaveEncsh'];
                        $this->OracleHcmEmpLeaveEncsh->create();
                        $this->OracleHcmEmpLeaveEncsh->save($replica_data);
                        $replica_id = $this->OracleHcmEmpLeaveEncsh->getLastInsertID();
                        $replica_row = $this->OracleHcmEmpLeaveEncsh->findById($replica_id);

                        $final_data['comp_code'] = $replica_row['OracleHcmEmpLeaveEncsh']['org_id'];
                        $final_data['emp_doc_id'] = $replica_row['OracleHcmEmpLeaveEncsh']['emp_doc_id'];
                        $emp_cd = $this->MyProfile->find('first', array(
                            'conditions' => array(
                                'doc_id' => $replica_row['OracleHcmEmpLeaveEncsh']['emp_dept_id']
                            ),
                            'fields' => array('emp_code')
                        ));
                        $final_data['emp_code'] = $emp_cd['MyProfile']['emp_code'];
                        $final_data['doc_id'] = $replica_row['OracleHcmEmpLeaveEncsh']['doc_id'];
                        $final_data['dept_code'] = $replica_row['OracleHcmEmpLeaveEncsh']['emp_dept_id'];
                        $final_data['desg_code'] = $replica_row['OracleHcmEmpLeaveEncsh']['emp_dept_id'];
                        $final_data['emp_grp_id'] = $replica_row['OracleHcmEmpLeaveEncsh']['emp_grp_id'];
                        $final_data['encsh_amt'] = $replica_row['OracleHcmEmpLeaveEncsh']['encsh_amt'];
                        $final_data['doc_dt'] = $replica_row['OracleHcmEmpLeaveEncsh']['doc_dt'];
                        $final_data['encsh_status'] = $replica_row['OracleHcmEmpLeaveEncsh']['encsh_status'];

                        $present_data = $this->LeaveEncsh->find('first', array(
                            'conditions' => array(
                                'emp_doc_id' => $replica_row['OracleHcmEmpLeaveEncsh']['emp_doc_id'],
                                'doc_dt' => $replica_row['OracleHcmEmpLeaveEncsh']['doc_dt'],
                            )
                        ));
                        if ($present_data) {
                            $present_id = $present_data['LeaveEncsh']['id'];
                            $this->LeaveEncsh->id = $present_id;
                            $this->LeaveEncsh->save($final_data);
                        } else {
                            $this->LeaveEncsh->save($final_data);
                        }
                        $this->OracleHcmEmpLeaveEncsh->delete($replica_id);
                        print_r("Done HCM_EMP_LEAVE_ENCSH");
                        break;

                    case "HCM_EMP_LTA":
                        $row = $this->OraHcmEmpLta->find('first', array(
                            'conditions' => $oracle_cond
                        ));
                        $replica_data['OracleHcmEmpLta'] = $row['OraHcmEmpLta'];
                        $this->OracleHcmEmpLta->create();
                        $this->OracleHcmEmpLta->save($replica_data);
                        $replica_id = $this->OracleHcmEmpLta->getLastInsertID();
                        $replica_row = $this->OracleHcmEmpLta->findById($replica_id);
                        $lta_emp_id = $this->MyProfile->find('first', array('fields' => array('emp_id'), 'conditions' => array('emp_code' => $replica_row['OracleHcmEmpLta']['emp_code'])));
                        $final_data['lta_years'] = $replica_row['OracleHcmEmpLta']['lta_bal'];
                        $final_data['emp_id'] = $lta_emp_id['MyProfile']['emp_id'];
                        $present_data = $this->LtaBalance->find('first', array(
                            'conditions' => array(
                                'emp_id' => $lta_emp_id['MyProfile']['emp_id'],
                            )
                        ));
                        if ($present_data) {
                            $present_id = $present_data['LtaBalance']['id'];
                            $this->LtaBalance->id = $present_id;
                            $this->LtaBalance->save($final_data);
                        } else {
                            $this->LtaBalance->save($final_data);
                        }
                        $this->OracleHcmEmpLta->delete($replica_id);
                        print_r('DONE HCM_EMP_LEAVE_ENCSH');
                        break;

                    case "HCM_EMP_LEAVE":
                        $row = $this->OraHcmEmpLeave->find('first', array(
                            'conditions' => $oracle_cond
                        ));

                        $replica_data['OracleHcmEmpLeave'] = $row['OraHcmEmpLeave'];
                        $this->OracleHcmEmpLeave->create();
                        $this->OracleHcmEmpLeave->save($replica_data);
                        $replica_id = $this->OracleHcmEmpLeave->getLastInsertID();

                        $replica_row = $this->OracleHcmEmpLeave->findById($replica_id);
                        $final_data['leave_op'] = $replica_row['OracleHcmEmpLeave']['leave_op'];
                        $final_data['leave_code'] = $replica_row['OracleHcmEmpLeave']['leave_id'];
                        $final_data['emp_code'] = $replica_row['OracleHcmEmpLeave']['emp_code'];
                        $final_data['allot_leave'] = $replica_row['OracleHcmEmpLeave']['leave_bal'];
                        $final_data['created_date'] = $replica_row['OracleHcmEmpLeave']['org_id'];
                        $final_data['org_id'] = $replica_row['OracleHcmEmpLeave']['org_id'];
                        $final_data['leave_year'] = $replica_row['OracleHcmEmpLeave']['leave_year'];
                        $final_data['leave_bal'] = $replica_row['OracleHcmEmpLeave']['leave_bal'];
                        $final_data['leave_accrual_rate'] = $replica_row['OracleHcmEmpLeave']['leave_accrual_rate'];
                        $final_data['modified'] = $replica_row['OracleHcmEmpLeave']['usr_id_mod_dt'];
                        $present_data = $this->MstEmpLeaveAllot->find('first', array(
                            'conditions' => array(
                                'emp_code' => $replica_row['OracleHcmEmpLeave']['emp_code'],
                                'leave_code' => $replica_row['OracleHcmEmpLeave']['leave_id'],
                            )
                        ));

                        if ($present_data) {
                            $present_id = $present_data['MstEmpLeaveAllot']['id'];
                            $this->MstEmpLeaveAllot->id = $present_id;
                            $this->MstEmpLeaveAllot->save($final_data);
                        } else {
                            $this->MstEmpLeaveAllot->save($final_data);
                        }
                        $this->OracleHcmEmpLeave->delete($replica_id);
                        print_r('DONE HCM_EMP_LEAVE_ALLOT');
                        break;
                        break;

                    case "HCM_DS_ATT_TYPE":
                        $org = new Model(array('table' => 'HCM$DS$ATT$TYPE', 'ds' => 'ora', 'name' => 'HCMDSATTTYPE'));
                        $data_oracle = $org->find('first', array('conditions' => $oracle_cond));
                        $data['name'] = $data_oracle['HCMDSATTTYPE']['att_type_nm'];
                        $data['at_status'] = 1;
                        $data['att_type_id'] = $data_oracle['HCMDSATTTYPE']['att_type_id'];
                        $present_data = $this->AttributeType->find('first', array('conditions' => array('att_type_id' => $data_oracle['HCMDSATTTYPE']['att_type_id'])));
                        if ($present_data) {
                            $this->AttributeType->id = $present_data['AttributeType']['id'];
                            $this->AttributeType->save($data);
                        } else {
                            $this->AttributeType->create();
                            $this->AttributeType->save($data);
                        }
                        print_r('HCM_DS_ATT_TYPE Done');
                        break;

                    case "HCM_DS_ATT":
                        $org = new Model(array('table' => 'HCM$DS$ATT', 'ds' => 'ora', 'name' => 'HCMDSATT'));
                        $data_oracle = $org->find('first', array('conditions' => $oracle_cond));

                        $data['name'] = $data_oracle['HCMDSATT']['att_nm'];
                        $data['opt_status'] = 1;
                        $attribute_type_id = $this->AttributeType->find('first', array('conditions' => array('att_type_id' => $data_oracle['HCMDSATT']['att_type_id'])));
                        $data['attribute_type_id'] = $attribute_type_id['AttributeType']['id'];
                        $present_data = $this->Options->find('first', array('conditions' => array('Options.id' => $data_oracle['HCMDSATT']['att_id'])));
                        if ($present_data) {
                            $this->Options->id = $present_data['Options']['id'];
                            $this->Options->save($data);
                        } else {
                            $this->Options->create();
                            $this->Options->save($data);
                        }
                        print_r('HCM_DS_ATT Done');
                        break;
                    case "HCM_SETUP":
                        $org = new Model(array('table' => 'HCM$SETUP', 'ds' => 'ora', 'name' => 'HCMSETUP'));
                        $data_oracle = $org->find('first', array('conditions' => $oracle_cond));

                        $data['id'] = $data_oracle['HCMSETUP']['param_id'];
                        $data['name'] = $data_oracle['HCMSETUP']['param_desc'];
                        $option_id = $this->Options->find('first', array('conditions' => array('Options.id' => $data_oracle['HCMSETUP']['param_type'])));
                        $data['options_id'] = $option_id['Options']['id'];
                        $data['sloc_id'] = $data_oracle['HCMSETUP']['sloc_id'];
                        $data['cld_id'] = $data_oracle['HCMSETUP']['cld_id'];
                        $data['ho_org_id'] = $data_oracle['HCMSETUP']['ho_org_id'];
                        $data['org_id'] = $data_oracle['HCMSETUP']['ho_org_id'];
                        $present_data = $this->OptionAttribute->find('first', array('conditions' => array('OptionAttribute.id' => $data_oracle['HCMSETUP']['param_id'])));
                        if ($present_data) {
                            $this->OptionAttribute->id = $present_data['Options']['id'];
                            $this->OptionAttribute->save($data);
                        } else {
                            $this->OptionAttribute->create();
                            $this->OptionAttribute->save($data);
                        }
                        print_r('HCM_SETUP Done');
                        break;
                    case "ORG_HCM_SETUP":
                        $org = new Model(array('table' => 'ORG$HCM$SETUP', 'ds' => 'ora', 'name' => 'ORGHCMSETUP'));
                        $org_setup = new Model(array('table' => 'option_attribute_org', 'ds' => 'default', 'name' => 'orgsetup'));
                        $data_oracle = $org->find('first', array('conditions' => $oracle_cond));
                        $data['param_id'] = $data_oracle['ORGHCMSETUP']['param_id'];
                        $data['sloc_id'] = $data_oracle['ORGHCMSETUP']['sloc_id'];
                        $data['cld_id'] = $data_oracle['ORGHCMSETUP']['cld_id'];
                        $data['ho_org_id'] = $data_oracle['ORGHCMSETUP']['ho_org_id'];
                        $data['org_id'] = $data_oracle['ORGHCMSETUP']['org_id'];
                        $present_data = $org_setup->find('first', array('conditions' => array('param_id' => $data_oracle['ORGHCMSETUP']['param_id'])));
                        if ($present_data) {
                            $org_setup->id = $present_data['orgsetup']['id'];
                            $org_setup->save($data);
                        } else {
                            $org_setup->create();
                            $org_setup->save($data);
                        }
                        print_r('ORG_HCM_SETUP Done');
                        break;
                    case "ORG":
                        $org = new Model(array('table' => 'ORG', 'ds' => 'app', 'name' => 'ORG'));
                        $org_sql = new Model(array('table' => 'oracle_org', 'ds' => 'default', 'name' => 'ORACLEORG'));
                        $row = $org->find('first', array('conditions' => $oracle_cond));
                        $replica_data['ORACLEORG'] = $row['ORG'];
                        $org_sql->create();
                        $org_sql->save($replica_data);
                        $replica_id = $org_sql->getLastInsertID();
                        $replica_row = $org_sql->findById($replica_id);
                        if ($row['ORG']['org_active'] == 'Y') {
                            $status = 1;
                        } else {
                            $status = 0;
                        }
//echo "<pre>"; print_r($replica_row); die;
                        if ($row['ORG']['org_id_parent_l0'] == '') {
                            echo "yes";
                            $present_data = $this->MstOrg->find('first', array('conditions' => array('org_id' => $replica_row['ORACLEORG']['org_id'])));
//echo "<pre>"; print_r($present_data);
                            if ($present_data) {
                                echo "great";
                                $data['id'] = $present_data['MstOrg']['id'];
                                $data['org_name'] = $row['ORG']['org_desc'];
                                $data['org_alias'] = $row['ORG']['org_alias'];
                                $data['org_id'] = $row['ORG']['org_id'];
                                $data['created_at'] = date('Y-m-d', strtotime($row['ORG']['usr_id_create_dt']));
                                $data['org_cld_id'] = $row['ORG']['org_cld_id'];
                                $data['org_type'] = $row['ORG']['org_type'];
                                $data['status'] = $status;
                                $this->MstOrg->create();
                                $this->MstOrg->save($data);
                                $present_data_1 = $this->Company->find('first', array('conditions' => array('mst_org_id' => $present_data['MstOrg']['id'])));

                                $comp_data['id'] = $present_data_1['Company']['id'];
                                $comp_data['mst_org_id'] = $present_data['MstOrg']['id'];
                                $comp_data['comp_code'] = $row['ORG']['org_id'];
                                $comp_data['comp_name'] = $row['ORG']['org_desc'];
                                $comp_data['org_alias'] = $row['ORG']['org_alias'];
                                $comp_data['status'] = $status;
                                $comp_data['cld_id'] = $row['ORG']['org_cld_id'];
                                $comp_data['org_id'] = $row['ORG']['org_id'];
                                $comp_data['ho_org_id'] = '';
                                $comp_data['created_at'] = date('Y-m-d', strtotime($row['ORG']['usr_id_create_dt']));
                                $this->Company->create();
                                $this->Company->save($comp_data);
                            } else {
                                $data['org_name'] = $row['ORG']['org_desc'];
                                $data['org_alias'] = $row['ORG']['org_alias'];
                                $data['org_id'] = $row['ORG']['org_id'];
                                $data['created_at'] = date('Y-m-d', strtotime($val['ORG']['usr_id_create_dt']));
                                $data['org_cld_id'] = $row['ORG']['org_cld_id'];
                                $data['org_type'] = $row['ORG']['org_type'];
                                $data['status'] = $status;
                                $this->MstOrg->create();
                                $this->MstOrg->save($data);
                                $present_data_1 = $this->Company->find('first', array('conditions' => array('org_id' => $row['ORG']['org_id_parent_l0'])));
                                $comp_data['mst_org_id'] = $this->MstOrg->getLastInsertID();
                                $comp_data['comp_code'] = $row['ORG']['org_id'];
                                $comp_data['comp_name'] = $row['ORG']['org_desc'];
                                $comp_data['org_alias'] = $row['ORG']['org_alias'];
                                $comp_data['status'] = $status;
                                $comp_data['cld_id'] = $row['ORG']['org_cld_id'];
                                $comp_data['org_id'] = $row['ORG']['org_id'];
                                $comp_data['ho_org_id'] = '';
                                $comp_data['created_at'] = date('Y-m-d', strtotime($row['ORG']['usr_id_create_dt']));
                                $this->Company->create();
                                $this->Company->save($comp_data);
                            }
                        } else {
                            $present_data_1 = $this->Company->find('first', array('conditions' => array('ho_org_id' => $row['ORG']['org_id_parent_l0'], 'org_id' => $row['ORG']['org_id'])));
                            $present_data_mst = $this->MstOrg->find('first', array('conditions' => array('id' => $present_data_1['Company']['mst_org_id'])));
//echo "<pre>"; print_r($present_data_mst); die;
                            if ($present_data_1) {
                                $comp_data['id'] = $present_data_1['Company']['id'];
                                $comp_data['mst_org_id'] = $present_data_mst['MstOrg']['id'];
                                $comp_data['comp_code'] = $row['ORG']['org_id'];
                                $comp_data['comp_name'] = $row['ORG']['org_desc'];
                                $comp_data['org_alias'] = $row['ORG']['org_alias'];
                                $comp_data['status'] = $status;
                                $comp_data['cld_id'] = $row['ORG']['org_cld_id'];
                                $comp_data['org_id'] = $row['ORG']['org_id'];
                                $comp_data['ho_org_id'] = $row['ORG']['org_id_parent_l0'];
                                $comp_data['created_at'] = date('Y-m-d', strtotime($row['ORG']['usr_id_create_dt']));
                                $this->Company->create();
                                $this->Company->save($comp_data);
                            } else {
                                $comp_data['mst_org_id'] = $present_data_mst['MstOrg']['id'];
                                $comp_data['comp_code'] = $row['ORG']['org_id'];
                                $comp_data['comp_name'] = $row['ORG']['org_desc'];
                                $comp_data['org_alias'] = $row['ORG']['org_alias'];
                                $comp_data['status'] = $status;
                                $comp_data['cld_id'] = $row['ORG']['org_cld_id'];
                                $comp_data['org_id'] = $row['ORG']['org_id'];
                                $comp_data['ho_org_id'] = $row['ORG']['org_id_parent_l0'];
                                $comp_data['created_at'] = date('Y-m-d', strtotime($row['ORG']['usr_id_create_dt']));
                                $this->Company->create();
                                $this->Company->save($comp_data);
                            }
                        }
//check if already present
//delete the row from replica
                        print_r('DONE ORG');
                        $org->delete($replica_id);

                        break;
                    case 'HCM_IT_SECT_DTL':
                        $qual = new Model(array('table' => 'HCM$IT$SECT$DTL', 'ds' => 'ora', 'name' => 'OraHcmSectDtl'));
                        $val = $qual->find('first', array('conditions' => $oracle_cond));

                        $dataSect['org_id'] = $val['OraHcmSectDtl']['ho_org_id'];
                        $dataSect['cptr_id'] = $val['OraHcmSectDtl']['cptr_id'];
                        $dataSect['sect_id'] = $val['OraHcmSectDtl']['sect_id'];
                        $dataSect['sect_max_limit'] = $val['OraHcmSectDtl']['sect_max_limit'];
                        $dataSect['org_id'] = $val['OraHcmSectDtl']['ho_org_id'];
                        $dataSect['valid_strt_dt'] = $val['OraHcmSectDtl']['valid_strt_dt'];
                        $dataSect['valid_end_dt'] = $val['OraHcmSectDtl']['valid_end_dt'];
                        $dataSect['remark'] = $val['OraHcmSectDtl']['remark'];
                        $get_id = $this->FinancialYear->find('first', array('fields' => array('id'), 'conditions' => array('org_id' => $val['OraHcmSectDtl']['ho_org_id'], 'ora_fy_id' => $val['OraHcmSectDtl']['fy_id'])));
                        $dataSect['fy_id'] = $get_id['FinancialYear']['id'];

                        //$dataSect['fy_id'] = $val['OraHcmSectDtl']['fy_id'];
                        $present_data = $this->SectDtl->find('first', array('conditions' => array('cptr_id' => $val['OraHcmSectDtl']['cptr_id'], 'sect_id' => $val['OraHcmSectDtl']['sect_id'])));
                        //echo '<pre>';print_r($dataSect);
                        if ($present_data) {
                            $this->SectDtl->id = $present_data['SectDtl']['id'];
                            $this->SectDtl->save($dataSect);
                        } else {
                            $this->SectDtl->create();
                            $this->SectDtl->save($dataSect);
                        }

                        print_r("HCM_IT_SECT_DTL Done");
                        break;
                    case 'HCM_IT_INVEST_DTL':
                        $qual = new Model(array('table' => 'HCM$IT$INVEST$DTL', 'ds' => 'ora', 'name' => 'HCMITINVESTDTL'));
                        $val = $qual->find('first', array('conditions' => $oracle_cond));

                        $dt_data1 = array();

                        $dt_data1['org_id'] = $val['HCMITINVESTDTL']['ho_org_id'];
                        $dt_data1['doc_id'] = $val['HCMITINVESTDTL']['doc_id'];
                        $dt_data1['sect_id'] = $val['HCMITINVESTDTL']['sect_id'];
                        $dt_data1['invest_id'] = $val['HCMITINVESTDTL']['invest_id'];
                        $dt_data1['invest_max_limit'] = $val['HCMITINVESTDTL']['invest_max_limit'];
                        $dt_data1['max_limit_perc'] = $val['HCMITINVESTDTL']['max_limit_perc'];
                        $dt_data1['valid_strt_dt'] = $val['HCMITINVESTDTL']['valid_strt_dt'];
                        $dt_data1['valid_end_dt'] = $val['HCMITINVESTDTL']['valid_end_dt'];
                        $dt_data1['doc_req_chk'] = $val['HCMITINVESTDTL']['doc_req_chk'];
                        $dt_data1['max_limit_rule'] = $val['HCMITINVESTDTL']['max_limit_rule'];
                        $dt_data1['max_limit_chk'] = $val['HCMITINVESTDTL']['max_limit_chk'];
                        $dt_data1['hover_description'] = $val['HCMITINVESTDTL']['remark'];
                        $dt_data1['remark'] = $val['HCMITINVESTDTL']['remark'];
                        //$dt_data1['fy_id'] = $val['HCMITINVESTDTL']['usr_id_create'];
                        $dt_data1['invest_doc_id'] = $val['HCMITINVESTDTL']['usr_id_create_dt'];
                        $get_id = $this->FinancialYear->find('first', array('fields' => array('id'), 'conditions' => array('org_id' => $val['HCMITINVESTDTL']['ho_org_id'], 'ora_fy_id' => $val['HCMITINVESTDTL']['fy_id'])));
                        $dt_data1['fy_id'] = $get_id['FinancialYear']['id'];
                        $dt_data1['ora_fy_id'] = $val['HCMITINVESTDTL']['fy_id'];


                        //$dt_data1['fy_id'] = $val['HCMITINVESTDTL']['fy_id'];
                        $dt_data1['exmp_chk'] = $val['HCMITINVESTDTL']['exmp_chk'];
                        $dt_data1['sloc_id'] = $val['HCMITINVESTDTL']['sloc_id'];
                        $dt_data1['cld_id'] = $val['HCMITINVESTDTL']['cld_id'];
                        $dt_data1['ho_org_id'] = $val['HCMITINVESTDTL']['ho_org_id'];


                        $present_data = $this->InvestDtl->find('first', array('conditions' => array('sect_id' => $val['HCMITINVESTDTL']['sect_id'], 'invest_id' => $val['HCMITINVESTDTL']['invest_id'])));

                        if ($present_data) {
                            $this->InvestDtl->id = $present_data['InvestDtl']['id'];
                            $this->InvestDtl->save($dt_data1);
                        } else {

                            $this->InvestDtl->create();
                            $this->InvestDtl->save($dt_data1);
                        }

                        print_r("HCM_IT_INVEST_DTL Done");
                        break;

                    case 'HCM_IT_EMP_INVEST':

                        $qual = new Model(array('table' => 'HCM$IT$EMP$INVEST', 'ds' => 'ora', 'name' => 'HCMITEMPINVEST'));
                        $val = $qual->find('first', array('conditions' => $oracle_cond));

                        $MyProfile = $this->MyProfile->find('first', array('conditions' => array('doc_id' => $val['HCMITEMPINVEST']['emp_doc_id'])));
                        $dt_data1['comp_code'] = $val['HCMITEMPINVEST']['ho_org_id'];
                        $dt_data1['emp_code'] = $MyProfile['MyProfile']['emp_code'];
                        $dt_data1['doc_id'] = $val['HCMITEMPINVEST']['doc_id'];
                        // $dt_data1['Fy_id'] = $val['HCMITEMPINVEST']['fy_id'];
                        $dt_data1['loc_type'] = $val['HCMITEMPINVEST']['loc_type'];
                        $dt_data1['invest_status'] = '2';
                        $dt_data1['emp_doc_id'] = $val['HCMITEMPINVEST']['emp_doc_id'];
                        $dt_data1['config'] = '0';
                        $dt_data1['sloc_id'] = $val['HCMITEMPINVEST']['sloc_id'];
                        $dt_data1['cld_id'] = $val['HCMITEMPINVEST']['cld_id'];
                        $dt_data1['ho_org_id'] = $val['HCMITEMPINVEST']['ho_org_id'];
                        $dt_data1['org_id'] = $val['HCMITEMPINVEST']['org_id'];

                        $get_id = $this->FinancialYear->find('first', array('fields' => array('id'), 'conditions' => array('org_id' => $val['HCMITEMPINVEST']['ho_org_id'], 'ora_fy_id' => $val['HCMITEMPINVEST']['fy_id'])));
                        $dt_data1['Fy_id'] = $get_id['FinancialYear']['id'];
                        $dt_data1['ora_fy_id'] = $val['HCMITEMPINVEST']['fy_id'];

                        $present_data = $this->EmpInvest->find('first', array('conditions' => array('fy_id' => $get_id['FinancialYear']['id'], 'emp_doc_id' => $val['HCMITEMPINVEST']['emp_doc_id'])));

                        echo '<pre>';
                        print_r($dt_data1);
                        if ($present_data) {

                            $this->EmpInvest->id = $present_data['EmpInvest']['id'];
                            $this->EmpInvest->save($dt_data1);
                        } else {

                            $this->EmpInvest->create();
                            $this->EmpInvest->save($dt_data1);
                        }

                        print_r("HCM_IT_EMP_INVEST Done");
                        break;

                    case 'HCM_IT_EMP_INVEST_DTL':
                        Configure::write('debug', 2);
                        $qual = new Model(array('table' => 'HCM$IT$EMP$INVEST$DTL', 'ds' => 'ora', 'name' => 'HCMITEMPINVESTDTL'));
                        $val = $qual->find('first', array('conditions' => $oracle_cond));

                        $dt_data1 = array();
                        //print_r($oracle_cond);
                        //echo '<pre>';print_r($val);
                        $MyProfile = $this->MyProfile->find('first', array('conditions' => array('doc_id' => $val['HCMITEMPINVESTDTL']['emp_doc_id'])));
                        $dt_data1['org_id'] = $val['HCMITEMPINVESTDTL']['org_id'];
                        $dt_data1['emp_code'] = $MyProfile['MyProfile']['emp_code'];
                        $dt_data1['doc_id'] = $val['HCMITEMPINVESTDTL']['doc_id'];
                        //$dt_data1['fy_id'] = $val['HCMITEMPINVESTDTL']['fy_id'];
                        $dt_data1['invest_doc_id'] = $val['HCMITEMPINVESTDTL']['invest_doc_id'];
                        $dt_data1['sect_id'] = $val['HCMITEMPINVESTDTL']['sect_id'];
                        $dt_data1['invest_id'] = $val['HCMITEMPINVESTDTL']['invest_id'];
                        $dt_data1['invest_amt'] = $val['HCMITEMPINVESTDTL']['invest_amt'];
                        $dt_data1['actual_amt'] = $val['HCMITEMPINVESTDTL']['actual_amt'];
                        $dt_data1['invest_status'] = '2';
                        $dt_data1['approver_id'] = '209';
                        $dt_data1['emp_doc_id'] = $val['HCMITEMPINVESTDTL']['emp_doc_id'];

                        $get_id = $this->FinancialYear->find('first', array('fields' => array('id'), 'conditions' => array('org_id' => $val['HCMITEMPINVESTDTL']['ho_org_id'], 'ora_fy_id' => $val['HCMITEMPINVESTDTL']['fy_id'])));
                        $dt_data1['fy_id'] = $get_id['FinancialYear']['id'];
                        $dt_data1['ora_fy_id'] = $val['HCMITEMPINVESTDTL']['fy_id'];
                        echo '<pre>';
                        print_r($dt_data1);
                        $present_data = $this->EmpInvestDtl->find('first', array('conditions' => array('org_id' => $val['HCMITEMPINVESTDTL']['org_id'], 'fy_id' => $get_id['FinancialYear']['id'], 'sect_id' => $val['HCMITEMPINVESTDTL']['sect_id'], 'invest_id' => $val['HCMITEMPINVESTDTL']['invest_id'], 'emp_doc_id' => $val['HCMITEMPINVESTDTL']['emp_doc_id'])));
                        echo '<pre>';
                        print_r($present_data);
                        if ($present_data) {
                            $this->EmpInvestDtl->id = $present_data['EmpInvestDtl']['id'];
                            $this->EmpInvestDtl->save($dt_data1);
                        } else {
                            //echo 'noo';die;
                            $emp_invest_id = $this->EmpInvest->find('first', array('conditions' => array('emp_doc_id' => $val['HCMITEMPINVESTDTL']['emp_doc_id'])));

                            $dt_data1['emp_invest_id'] = $emp_invest_id['EmpInvest']['id'];

                            $this->EmpInvestDtl->create();
                            $this->EmpInvestDtl->save($dt_data1);
                        }

                        print_r("HCM_IT_EMP_INVEST_DTL Done");
                        break;

                    case 'HCM_TIME_MOVE_EDIT_DTL':
                        $n = '$';
                        $table = 'HCM' . $n . 'TIME' . $n . 'MOVE' . $n . 'EDIT' . $n . 'DTL';
                        $org_id = $oracle_cond[' ORG_ID'];
                        $emp_doc_id = $oracle_cond[' EMP_DOC_ID'];
                        $date_at = $oracle_cond[' ATTEN_DT'];
                        $qual_tme = new Model(array('table' => 'HCM$TIME$MOVE$EDIT$DTL', 'ds' => 'ora', 'name' => 'HCMTIMEMOVEEDITDTL'));
                        $val = $this->GeneralOracle->query("SELECT HCMTIMEMOVEEDITDTL.rest_day_chk, HCMTIMEMOVEEDITDTL.prj_doc_id, HCMTIMEMOVEEDITDTL.leave_proof_submit_chk, HCMTIMEMOVEEDITDTL.qtr_leave_chk, HCMTIMEMOVEEDITDTL.add_comp_leave_chk, HCMTIMEMOVEEDITDTL.emp_id, HCMTIMEMOVEEDITDTL.emp_loc_id, HCMTIMEMOVEEDITDTL.emp_grp_id, HCMTIMEMOVEEDITDTL.emp_dept_id, HCMTIMEMOVEEDITDTL.hlfday_leave_chk, HCMTIMEMOVEEDITDTL.wk_off_chk, HCMTIMEMOVEEDITDTL.ded_ch, to_char(HCMTIMEMOVEEDITDTL.out_time,'dd-mm-yyyy HH24:MI:SS') as out_time, to_char(HCMTIMEMOVEEDITDTL.in_time,'dd-mm-yyyy HH24:MI:SS') as in_time, HCMTIMEMOVEEDITDTL.usr_id_mod_dt, HCMTIMEMOVEEDITDTL.usr_id_mod, HCMTIMEMOVEEDITDTL.usr_id_create_dt, HCMTIMEMOVEEDITDTL.usr_id_create, HCMTIMEMOVEEDITDTL.extra_time_hr, HCMTIMEMOVEEDITDTL.leave_id, HCMTIMEMOVEEDITDTL.atten_dt, HCMTIMEMOVEEDITDTL.emp_doc_id, HCMTIMEMOVEEDITDTL.org_id, HCMTIMEMOVEEDITDTL.ho_org_id, HCMTIMEMOVEEDITDTL.sloc_id, HCMTIMEMOVEEDITDTL.cld_id, HCMTIMEMOVEEDITDTL.hlffay_leave_type, HCMTIMEMOVEEDITDTL.remarks FROM $table HCMTIMEMOVEEDITDTL WHERE ORG_ID = '" . $org_id . "' AND EMP_DOC_ID = '" . $emp_doc_id . "' AND to_char(ATTEN_DT,'DD-MON-YY') = '" . $date_at . "'");
                        $data_org = array();
						$data_org = $val[0]['HCMTIMEMOVEEDITDTL'];
                        $atten_dt = $data_org['atten_dt'];
                        if (!empty($val[0]['0']['in_time']) && !empty($val[0]['0']['out_time'])) {
                            $data_org['in_time'] = date('Y-m-d H:i:s', strtotime($val[0]['0']['in_time']));
                            $data_org['out_time'] = date('Y-m-d H:i:s', strtotime($val[0]['0']['out_time']));
                        } else {
                            $data_org['in_time'] = date('Y-m-d H:i:s', strtotime($val[0]['0']['in_time']));
                            $data_org['out_time'] = date('Y-m-d H:i:s', strtotime($val[0]['0']['out_time']));
                        }
                        $present_data = $this->AttendanceDetail->find('first', array('conditions' =>
                            array('org_id' => $data_org['org_id'], 'emp_doc_id' => $data_org['emp_doc_id'],
                                'atten_dt' => date('Y-m-d', strtotime($data_org['atten_dt'])))));
                        if ($present_data) {
                            $emp_data = $this->MyProfile->find('first', array('conditions' => array(
                                    'emp_id' => $data_org['emp_id'], 'comp_code' => $data_org['org_id'])));
                            $this->AttendanceDetail->id = $present_data['AttendanceDetail']['id'];
                            $this->AttendanceDetail->save($data_org);
                            echo $emp_data['MyProfile']['emp_code'];
                            if ($data_org['leave_id'] != '' || $data_org['ded_ch'] == 'F' || $data_org['ded_ch'] == 'H') {
                                $lv_data = $this->MstEmpLeave->find('first', array('conditions' =>
                                    array('start_date' => date('Y-m-d', strtotime($data_org['atten_dt'])),
                                        'end_date' => date('Y-m-d', strtotime($data_org['atten_dt'])),
                                        'emp_code' => $emp_data['MyProfile']['emp_code'],
                                )));
                                $lv_val['start_date'] = $data_org['atten_dt'];
                                $lv_val['end_date'] = $data_org['atten_dt'];
                                $lv_val['total_leave'] = 1;
                                $lv_val['emp_code'] = $emp_data['MyProfile']['emp_code'];
                                $lv_val['comp_code'] = $data_org['org_id'];
                                $lv_val['applied_date'] = date('Y-m-d h:i:s');
                                if (!empty($lv_data)) {
                                    echo "Not new</br>";
                                   // $this->MstEmpLeave->id = $lv_data['MstEmpLeave']['leave_id'];
                                    //$lv_save = $this->MstEmpLeave->save($lv_val);
                                    $record_id = $lv_data['MstEmpLeave']['leave_id'];
                                } else {
                                    echo "New</br>";
                                   // $this->MstEmpLeave->create();
                                   // $lv_save = $this->MstEmpLeave->save($lv_val);
                                   // $record_id = $this->MstEmpLeave->getLastInsertID();
                                }
                                $data_val['solc_id'] = 'ERP';
                                $data_val['leave_id'] = $record_id;
                                $data_val['leave_date'] = $data_org['atten_dt'];
                                if ($data_org['ded_ch'] == 'F' || $data_org['ded_ch'] == 'H') {
                                    $data_val['leave_code'] = 'PAR0000011';
                                } else {
                                    $data_val['leave_code'] = $data_org['leave_id'];
                                }
                                $data_val['leave_reason'] = 'Updated From ERP';
                                $data_val['applied_date'] = date('Y-m-d');
                                $data_val['leave_status'] = 5;
                                if (in_array($datetime1, $week_holidays)) {
                                    $data_val['week_off_chk'] = 1;
                                } else {
                                    $data_val['week_off_chk'] = 0;
                                }
                                $data_val['emp_code'] = $emp_data['MyProfile']['emp_code'];
                                if ($data_org['ded_ch'] == 'F') {
                                    $data_val['hlfday_leave_chk'] = 'N';
                                } else if ($data_org['ded_ch'] == 'H') {
                                    $data_val['hlfday_leave_chk'] = 'Y';
                                } else {
                                    $data_val['hlfday_leave_chk'] = 'N';
                                }
                                $lv_data_dt = $this->LeaveDetail->find('first', array('conditions' =>
                                    array('leave_date' => date('Y-m-d', strtotime($data_org['atten_dt'])),
                                        'emp_code' => $emp_data['MyProfile']['emp_code'],
                                )));
                                if (!empty($lv_data_dt)) {
                                    //$this->LeaveDetail->id = $lv_data_dt['LeaveDetail']['leave_detail_id'];
                                    //$leave_save = $this->LeaveDetail->save($data_val);
                                } else {
                                    //$this->LeaveDetail->create();
                                    //$this->LeaveDetail->set($data_val);
                                    //$leave_save = $this->LeaveDetail->save($data_val);
                                }
                            }
                        } else {
                            //  die('here');
                            if ($data_org['leave_id'] != '' || $data_org['ded_ch'] == 'F' || $data_org['ded_ch'] == 'H') {
                                //die()
                                $lv_val['start_date'] = $data_org['atten_dt'];
                                $lv_val['end_date'] = $data_org['atten_dt'];
                                $lv_val['total_leave'] = 1;
                                $emp_data = $this->MyProfile->find('first', array('conditions' => array(
                                        'emp_id' => $data_org['emp_id'], 'comp_code' => $data_org['org_id'])));
                                $lv_val['emp_code'] = $emp_data['MyProfile']['emp_code'];
                                $lv_val['comp_code'] = $data_org['org_id'];
                                $lv_val['applied_date'] = date('Y-m-d h:i:s');
                                //$lv_save = $this->MstEmpLeave->save($lv_val);
                                //$record_id = $this->MstEmpLeave->getLastInsertID();
                                $data_val['leave_id'] = $record_id;
                                $data_val['leave_date'] = $data_org['atten_dt'];
                                if ($data_org['ded_ch'] == 'F' || $data_org['ded_ch'] == 'H') {
                                    $data_val['leave_code'] = 'PAR0000011';
                                } else {
                                    //die('in else');
                                    $data_val['leave_code'] = $data_org['leave_id'];
                                }
                                $data_val['leave_reason'] = 'Updated From ERP';
                                $data_val['applied_date'] = date('Y-m-d');
                                $data_val['leave_status'] = 5;

                                if (in_array($datetime1, $week_holidays)) {
                                    $data_val['week_off_chk'] = 1;
                                } else {
                                    $data_val['week_off_chk'] = 0;
                                }
                                $data_val['emp_code'] = $emp_data['MyProfile']['emp_code'];
                                if ($data_org['ded_ch'] == 'F') {
                                    $data_val['hlfday_leave_chk'] = 'N';
                                } else if ($data_org['ded_ch'] == 'H') {
                                    $data_val['hlfday_leave_chk'] = 'Y';
                                } else {
                                    $data_val['hlfday_leave_chk'] = 'N';
                                }
                                //$this->LeaveDetail->create();
                                //$this->LeaveDetail->set($data_val);
                                //$leave_save = $this->LeaveDetail->save($data_val);
                                $this->AttendanceDetail->create();
                                $this->AttendanceDetail->save($data_org);
                            } else {
                                $this->AttendanceDetail->create();
                                $this->AttendanceDetail->save($data_org);
                            }
                        }

                        print_r("HCM_TIME_MOVE_EDIT_DTL Done");
                        break;

                    case "HCM_EMP_MON_SAL":
                        //Configure::write('debug',2);
                        $org_id = $oracle_cond[' ORG_ID'];
                        $emp_doc_id = $oracle_cond[' DOC_ID'];
                        $frm_dt = $oracle_cond[' PROC_FRM_DT'];
                        $emp_dode = $oracle_cond[' EMP_CODE'];
                        $to_dt = $oracle_cond[' PROC_TO_DT'];
                        $sal_id = $oracle_cond[' SAL_ID'];
                        $val = $this->OraHcmEmpSalMon->find('first', array(
                            'conditions' => array('ORG_ID' => $org_id, 'DOC_ID' => $emp_doc_id, 'EMP_CODE' => $emp_dode,
                                'SAL_ID' => $sal_id, "to_char(PROC_FRM_DT,'DD-MON-YY')" => $frm_dt, "to_char(PROC_TO_DT,'DD-MON-YY')" => $to_dt)));
                        //print_r($val); die;
                        $final_data['status'] = 5;
                        $final_data['approval_date'] = date('Y-m-d');
                        $final_data['created_at'] = $val['OraHcmEmpSalMon']['usr_id_create_dt'];
                        $final_data['claim_date'] = $val['OraHcmEmpSalMon']['usr_id_create_dt'];
                        $final_data['emp_code'] = $val['OraHcmEmpSalMon']['emp_code'];
                        $final_data['emp_doc_id'] = $val['OraHcmEmpSalMon']['emp_doc_id'];
                        $final_data['doc_id'] = $val['OraHcmEmpSalMon']['doc_id'];
                        $final_data['proc_frm_dt'] = $val['OraHcmEmpSalMon']['proc_frm_dt'];
                        $final_data['proc_to_dt'] = $val['OraHcmEmpSalMon']['proc_to_dt'];
                        $final_data['sal_id'] = $val['OraHcmEmpSalMon']['sal_id'];
                        $final_data['sal_val'] = $val['OraHcmEmpSalMon']['sal_val'];
                        $final_data['sal_amt'] = $val['OraHcmEmpSalMon']['sal_amt'];
                        $final_data['cld_id'] = $val['OraHcmEmpSalMon']['cld_id'];
                        $final_data['sloc_id'] = $val['OraHcmEmpSalMon']['sloc_id'];
                        $final_data['ho_org_id'] = $val['OraHcmEmpSalMon']['ho_org_id'];
                        $proc_frm_dt = date('Y-m-d', strtotime($val['OraHcmEmpSalMon']['proc_frm_dt']));
                        $proc_to_dt = date('Y-m-d', strtotime($val['OraHcmEmpSalMon']['proc_to_dt']));

                        $present_data = $this->EmployeeSalMon->find('first', array(
                            'conditions' => array(
                                'emp_code' => $val['OraHcmEmpSalMon']['emp_code'],
                                'emp_doc_id' => $val['OraHcmEmpSalMon']['emp_doc_id'],
                                'sal_id' => $val['OraHcmEmpSalMon']['sal_id'],
                                'proc_frm_dt' => $proc_frm_dt,
                                'proc_to_dt' => $proc_to_dt
                            )
                        ));
                        if ($present_data) {
                            $present_id = $present_data['EmployeeSalMon']['id'];
                            $this->EmployeeSalMon->id = $present_id;
                            $this->EmployeeSalMon->save($final_data);
                        } else {
                            $max_filed = $this->EmployeeSalMon->find('first', array('fields' => array('MAX(voucher_id) as voucher_id')));
                            $final_data['voucher_id'] = $max_filed[0]['voucher_id'] + 1;

                            $this->EmployeeSalMon->create();
                            $this->EmployeeSalMon->save($final_data);
                        }
                        print_r('HCM_EMP_MON_SAL Done');
                        break;

                    case "HCM_COMP_OFF_LEAVE_TRANS":
                        print_r($oracle_cond);
                        $comp_off = new Model(array('table' => 'comp_off_leave_trans', 'ds' => 'default', 'name' => 'COMPOFF'));
                        $loan_prf = new Model(array('table' => 'hcm$comp$off$leave$trans', 'ds' => 'ora', 'name' => 'HCMCOMPOFF'));
                        $org_id = $oracle_cond['ORG_ID'];
                        $doc_id = $oracle_cond['DOC_ID'];
                        $emp_doc_id = $oracle_cond['EMP_DOC_ID'];
                        $frm_dt = $oracle_cond['COMP_OFF_DT'];
                        $leave_id = $oracle_cond['LEAVE_ID'];
                        $val = $loan_prf->find('first', array('conditions' => array('ORG_ID' => $org_id, 'DOC_ID' => $doc_id,
                                'EMP_DOC_ID' => $emp_doc_id, 'LEAVE_ID' => $leave_id, "to_char(COMP_OFF_DT,'DD-MON-YY')" => $frm_dt)));
                        $present_data = $comp_off->find('first', array(
                            'conditions' => array(
                                'emp_doc_id' => $val['HCMCOMPOFF']['emp_doc_id'],
                                'leave_id' => $val['HCMCOMPOFF']['leave_id'],
                                'org_id' => $val['HCMCOMPOFF']['org_id'],
                                'doc_id' => $val['HCMCOMPOFF']['doc_id'],
                                'comp_off_dt' => $val['HCMCOMPOFF']['comp_off_dt']
                            )
                        ));

                        $final_data['COMPOFF'] = $val['HCMCOMPOFF'];
                        if ($present_data) {
                            $present_id = $present_data['COMPOFF']['id'];
                            $comp_off->id = $present_id;
                            $comp_off->save($final_data);
                        } else {
                            $comp_off->create();
                            $comp_off->save($final_data);
                        }
                        print_r('HCM_COMP_OFF_LEAVE_TRANS Done');
                        break;


                    default:
                        break;
                }
                //$this->GeneralOracle->query("DELETE DATA_INFO WHERE ID = '$use_id'");
                unset($oracle_cond);
            }
            $this->GeneralOracle->query('DELETE DATA_INFO');
//enable all triggers
            $this->General->query('SET @DISABLE_TRIGGERS = NULL;');
//disable data sync
            $this->General->query('UPDATE data_transfer_sync set task_status = 0;');
            exit();
        }
    }

    function perform_operation($table_name, $id, $data, $operation) {
        switch ($operation) {
            case 'INSERT' :

                break;
            default:
                break;
        }
    }

    function test() {
        $v = $this->General->query('SELECT task_status FROM data_transfer_sync WHERE task_name = "PORTAL_SYNC";');
        ;
        $inc = $v[0]['data_transfer_sync']['task_status'];
        $inc++;
        $this->General->query("UPDATE data_transfer_sync set task_status = $inc;");
        exit();
    }

    function import_fy() {
        Configure::write('debug', 2);
        $this->General->query('TRUNCATE financial_year');
        $fy_id = new Model(array('table' => 'ORG$FY', 'ds' => 'app', 'name' => 'ORGFY'));
        $oracle_data = $fy_id->find('all');
        //echo '<pre>'; print_r($oracle_data); die;
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
        $this->ImportLog->save($data_log);
    }

    function import_dependants() {
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
        $this->ImportLog->save($data_log);
    }

    function import_emp_edu() {
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
        $this->ImportLog->save($data_log);
        exit();
    }

    function import_holiday() {
        //Configure::write('debug',2);
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
        $this->ImportLog->save($data_log);
        exit();
    }

    function import_emp_exp() {
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
        $this->ImportLog->save($data_log);
        exit();
    }

    function import_employee_sal_mon() {
        $this->autoRender = false;
        $this->General->query('TRUNCATE employee_sal_mon');

        $oracle_data = $this->OraHcmEmpSalMon->find('all');
        foreach ($oracle_data as $key => $val) {
            //$data['doc_id'] = $val['OraHcmEmpLeaveEncsh']['doc_id'];
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


            //print_r($proc_frm_dt);die;
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
            //$data['desg_code'] = $val['OraHcmEmpLeaveEncsh']['emp_grp_id'];
        }
        $data_log['function_name'] = 'import_employee_sal_mon';
        $data_log['module_related'] = 'SALARY';
        $data_log['last_run'] = date('Y-m-d');
        $data_log['status'] = 1;

        $this->ImportLog->save($data_log);
        exit();
    }

    function import_org() {
        Configure::write('debug',2);
        $this->General->query('SET FOREIGN_KEY_CHECKS = 0');
        $this->General->query('TRUNCATE mst_company');
        $this->General->query('TRUNCATE mst_org');
        $this->General->query('SET FOREIGN_KEY_CHECKS = 1');


        $this->autoRender = false;
        $exp = new Model(array('table' => 'ORG', 'ds' => 'app', 'name' => 'ORG'));
        $oracle_data = $exp->find('all', array('order' => array('org_type')));
        //print_r($oracle_data); die;
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
                $this->MstOrg->save($data);
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

        $this->ImportLog->save($data_log);
        exit();
    }

    public function import_arr() {
        //Configure::write('debug',2);
        $this->General->query('TRUNCATE emp_incr_arr');

        $arr = new Model(array('table' => 'HCM$INCR$ARR', 'ds' => 'ora', 'name' => 'HCMINCRARR'));
        $oracle_data = $arr->find('all');
        // print_r(count($orcale_data));die;
        if ($oracle_data) {
            foreach ($oracle_data as $k => $v) {
                $data = $v['HCMINCRARR'];
                $this->EmpIncrArr->create();
                $this->EmpIncrArr->save($data);
            }
        }
    }

    public function get_sal_dtl() {
        $arr = new Model(array('table' => 'HCM$SAL$SYNC', 'ds' => 'ora', 'name' => 'HCMSALSYNC'));
        $oracle_data = $arr->find('all');
        //print_r($oracle_data); die;
        foreach ($oracle_data as $v) {
            $oracle_data_proc = $this->OraHcmItProc->find('all', array('conditions' => array('proc_frm_dt' => $v['HCMSALSYNC']['proc_frm_dt'], 'proc_to_dt' => $v['HCMSALSYNC']['proc_to_dt'])));
            //print_r($oracle_data_proc); die;
            foreach ($oracle_data_proc as $val_it) {
                $data_it['OracleHcmItProc'] = $val_it['OraHcmItProc'];
                $this->OracleHcmItProc->create();
                $this->OracleHcmItProc->save($data_it);
            }
            $data_oracle_sal_proc = $this->OraHcmSalProc->find('all', array('conditions' => array('proc_frm_dt' => $v['HCMSALSYNC']['proc_frm_dt'], 'proc_to_dt' => $v['HCMSALSYNC']['proc_to_dt'])));
            foreach ($data_oracle_sal_proc as $k => $val_sal_proc) {
                $data_sal_proc = $val_sal_proc['OraHcmSalProc'];
                $this->SalaryProcessing->create();
                $this->SalaryProcessing->save($data_sal_proc);
            }
            $data_oracle_pr_sal = $this->OraHcmSalProcSal->find('all', array('conditions' => array('proc_frm_dt' => $v['HCMSALSYNC']['proc_frm_dt'], 'proc_to_dt' => $v['HCMSALSYNC']['proc_to_dt'])));
            //print_r($data_oracle); die;
            foreach ($data_oracle_pr_sal as $k => $val_pr) {
                $data_pr = $val_pr['OraHcmSalProcSal'];
                $data_pr['employee_sal_proc_sal_id'] = $val_pr['OraHcmSalProcSal']['doc_id'];
                unset($data_pr['OraHcmSalProcSal']['doc_id']);
                $this->SalaryProcessingAddition->create();
                $this->SalaryProcessingAddition->save($data_pr);
            }

            $data_oracle_ded = $this->OraHcmSalProcDed->find('all', array('conditions' => array('proc_frm_dt' => $v['HCMSALSYNC']['proc_frm_dt'], 'proc_to_dt' => $v['HCMSALSYNC']['proc_to_dt'])));
            foreach ($data_oracle_ded as $k => $v_ded) {
                $data_ded = $v_ded['OraHcmSalProcDed'];
                $this->SalaryProcessingDeduction->create();
                $this->SalaryProcessingDeduction->save($data_ded);
            }

            $oracle_data_mon = $this->OraHcmEmpSalMon->find('all', array('conditions' => array('proc_frm_dt' => $v['HCMSALSYNC']['proc_frm_dt'], 'proc_to_dt' => $v['HCMSALSYNC']['proc_to_dt'])));
            foreach ($oracle_data_mon as $key => $val_mon) {
                //$data['doc_id'] = $val['OraHcmEmpLeaveEncsh']['doc_id'];
                $data_mon['status'] = 5;
                $data_mon['approval_date'] = date('Y-m-d');
                $data_mon['created_at'] = $val_mon['OraHcmEmpSalMon']['proc_frm_dt'];
                $data_mon['emp_code'] = $val_mon['OraHcmEmpSalMon']['emp_code'];
                $data_mon['emp_doc_id'] = $val_mon['OraHcmEmpSalMon']['emp_doc_id'];
                $data_mon['doc_id'] = $val_mon['OraHcmEmpSalMon']['doc_id'];
                $data_mon['proc_frm_dt'] = $val_mon['OraHcmEmpSalMon']['proc_frm_dt'];
                $data_mon['proc_to_dt'] = $val_mon['OraHcmEmpSalMon']['proc_to_dt'];
                $data_mon['sal_id'] = $val_mon['OraHcmEmpSalMon']['sal_id'];
                $data_mon['sal_val'] = $val_mon['OraHcmEmpSalMon']['sal_val'];
                $data_mon['sal_amt'] = $val_mon['OraHcmEmpSalMon']['sal_amt'];
                $data_mon['cld_id'] = $val_mon['OraHcmEmpSalMon']['cld_id'];
                $data_mon['sloc_id'] = $val_mon['OraHcmEmpSalMon']['sloc_id'];
                $data_mon['ho_org_id'] = $val_mon['OraHcmEmpSalMon']['ho_org_id'];
                $proc_frm_dt = date('Y-m-d', strtotime($val_mon['OraHcmEmpSalMon']['proc_frm_dt']));
                $proc_to_dt = date('Y-m-d', strtotime($val_mon['OraHcmEmpSalMon']['proc_to_dt']));

                //print_r($proc_frm_dt);die;
                $present_emp_sal = $this->EmployeeSalMon->find('first', array(
                    'conditions' => array(
                        'emp_code' => $val_mon['OraHcmEmpSalMon']['emp_code'],
                        'proc_frm_dt' => $proc_frm_dt,
                        'proc_to_dt' => $proc_to_dt,
                        'sal_id' => $val_mon['OraHcmEmpSalMon']['sal_id']
                    )
                ));
                if (!empty($present_emp_sal)) {
                    $this->EmployeeSalMon->id = $present_emp_sal['EmployeeSalMon']['id'];
                    $this->EmployeeSalMon->save($data_mon);
                } else {
                    $this->EmployeeSalMon->create();
                    $this->EmployeeSalMon->save($data_mon);
                }
                //$data['desg_code'] = $val['OraHcmEmpLeaveEncsh']['emp_grp_id'];
            }


            $oracle_data_esi = $this->OraHcmMonEsiDed->find('all', array('conditions' => array('proc_frm_dt' => $v['HCMSALSYNC']['proc_frm_dt'], 'proc_to_dt' => $v['HCMSALSYNC']['proc_to_dt'])));
            foreach ($oracle_data_esi as $val_esi) {

                $data_esi['org_id'] = $val_esi['OraHcmMonEsiDed']['org_id'];
                $data_esi['emp_code'] = $val_esi['OraHcmMonEsiDed']['emp_code'];
                $data_esi['emp_doc_id'] = $val_esi['OraHcmMonEsiDed']['emp_doc_id'];
                $data_esi['proc_frm_dt'] = $val_esi['OraHcmMonEsiDed']['proc_frm_dt'];
                $data_esi['proc_to_dt'] = $val_esi['OraHcmMonEsiDed']['proc_to_dt'];
                $data_esi['ded_doc_id'] = $val_esi['OraHcmMonEsiDed']['ded_doc_id'];
                $data_esi['ded_amt'] = $val_esi['OraHcmMonEsiDed']['emp_ded_amt'];
                $data_esi['doc_id'] = $val_esi['OraHcmMonEsiDed']['doc_id'];

                $this->SalaryProcessingDeduction->create();
                $this->SalaryProcessingDeduction->save($data_esi);
            }

            //Loan deduction
            $oracle_data_loan = $this->OraHcmMonLoanDed->find('all', array('conditions' => array('proc_frm_dt' => $v['HCMSALSYNC']['proc_frm_dt'], 'proc_to_dt' => $v['HCMSALSYNC']['proc_to_dt'])));
            foreach ($oracle_data_loan as $val_loan) {

                $data_loan['org_id'] = $val_loan['OraHcmMonLoanDed']['org_id'];
                $data_loan['emp_code'] = $val_loan['OraHcmMonLoanDed']['emp_code'];
                $data_loan['emp_doc_id'] = $val_loan['OraHcmMonLoanDed']['emp_doc_id'];
                $data_loan['proc_frm_dt'] = $val_loan['OraHcmMonLoanDed']['proc_frm_dt'];
                $data_loan['proc_to_dt'] = $val_loan['OraHcmMonLoanDed']['proc_to_dt'];
                $data_loan['ded_doc_id'] = $val_loan['OraHcmMonLoanDed']['ded_doc_id'];
                $data_loan['ded_amt'] = $val_loan['OraHcmMonLoanDed']['emp_ded_amt'];
                $data_loan['doc_id'] = $val_loan['OraHcmMonLoanDed']['doc_id'];

                $this->SalaryProcessingDeduction->create();
                $this->SalaryProcessingDeduction->save($data_loan);
            }

            //PF deduction
            $oracle_data_pf = $this->OraHcmMonPfDed->find('all', array('conditions' => array('proc_frm_dt' => $v['HCMSALSYNC']['proc_frm_dt'], 'proc_to_dt' => $v['HCMSALSYNC']['proc_to_dt'])));
            foreach ($oracle_data_pf as $val_pf) {

                $data_pf['org_id'] = $val_pf['OraHcmMonPfDed']['org_id'];
                $data_pf['emp_code'] = $val_pf['OraHcmMonPfDed']['emp_code'];
                $data_pf['emp_doc_id'] = $val_pf['OraHcmMonPfDed']['emp_doc_id'];
                $data_pf['proc_frm_dt'] = $val_pf['OraHcmMonPfDed']['proc_frm_dt'];
                $data_pf['proc_to_dt'] = $val_pf['OraHcmMonPfDed']['proc_to_dt'];
                $data_pf['ded_doc_id'] = $val_pf['OraHcmMonPfDed']['ded_doc_id'];
                $data_pf['ded_amt'] = $val_pf['OraHcmMonPfDed']['emp_ded_amt'];
                $data_pf['epf_amt'] = $val_pf['OraHcmMonPfDed']['epf_amt'];
                $data_pf['fpf_amt'] = $val_pf['OraHcmMonPfDed']['fpf_amt'];
                $data_pf['doc_id'] = $val_pf['OraHcmMonPfDed']['doc_id'];

                $this->SalaryProcessingDeduction->create();
                $this->SalaryProcessingDeduction->save($data_pf);
            }


            //Professional tax deduction
            $oracle_data_prof = $this->OraHcmMonProfsnlDed->find('all', array('conditions' => array('proc_frm_dt' => $v['HCMSALSYNC']['proc_frm_dt'], 'proc_to_dt' => $v['HCMSALSYNC']['proc_to_dt'])));
            foreach ($oracle_data_prof as $val_prof) {

                $data_prof['org_id'] = $val_prof['OraHcmMonProfsnlDed']['org_id'];
                $data_prof['emp_code'] = $val_prof['OraHcmMonProfsnlDed']['emp_code'];
                $data_prof['emp_doc_id'] = $val_prof['OraHcmMonProfsnlDed']['emp_doc_id'];
                $data_prof['proc_frm_dt'] = $val_prof['OraHcmMonProfsnlDed']['proc_frm_dt'];
                $data_prof['proc_to_dt'] = $val_prof['OraHcmMonProfsnlDed']['proc_to_dt'];
                $data_prof['ded_doc_id'] = $val_prof['OraHcmMonProfsnlDed']['ded_doc_id'];
                $data_prof['ded_amt'] = $val_prof['OraHcmMonProfsnlDed']['emp_ded_amt'];
                $data_prof['doc_id'] = $val_prof['OraHcmMonProfsnlDed']['doc_id'];

                $this->SalaryProcessingDeduction->create();
                $this->SalaryProcessingDeduction->save($data_prof);
            }
            //Super deduction
            $oracle_data_sup = $this->OraHcmMonSuperDed->find('all', array('conditions' => array('proc_frm_dt' => $v['HCMSALSYNC']['proc_frm_dt'], 'proc_to_dt' => $v['HCMSALSYNC']['proc_to_dt'])));
            foreach ($oracle_data_sup as $val_sup) {

                $data_sup['org_id'] = $val_sup['OraHcmMonSuperDed']['org_id'];
                $data_sup['emp_code'] = $val_sup['OraHcmMonSuperDed']['emp_code'];
                $data_sup['emp_doc_id'] = $val_sup['OraHcmMonSuperDed']['emp_doc_id'];
                $data_sup['proc_frm_dt'] = $val_sup['OraHcmMonSuperDed']['proc_frm_dt'];
                $data_sup['proc_to_dt'] = $val_sup['OraHcmMonSuperDed']['proc_to_dt'];
                $data_sup['ded_doc_id'] = $val_sup['OraHcmMonSuperDed']['ded_doc_id'];
                $data_sup['ded_amt'] = $val_sup['OraHcmMonSuperDed']['emp_ded_amt'];
                $data_sup['doc_id'] = $val_sup['OraHcmMonSuperDed']['doc_id'];

                $this->SalaryProcessingDeduction->create();
                $this->SalaryProcessingDeduction->save($data_sup);
            }

            //Tax deduction
            $oracle_data_tax = $this->OraHcmMonTaxDed->find('all', array('conditions' => array('proc_frm_dt' => $v['HCMSALSYNC']['proc_frm_dt'], 'proc_to_dt' => $v['HCMSALSYNC']['proc_to_dt'])));
            foreach ($oracle_data_tax as $val_tax) {

                $data_tax['org_id'] = $val_tax['OraHcmMonTaxDed']['org_id'];
                $data_tax['emp_code'] = $val_tax['OraHcmMonTaxDed']['emp_code'];
                $data_tax['emp_doc_id'] = $val_tax['OraHcmMonTaxDed']['emp_doc_id'];
                $data_tax['proc_frm_dt'] = $val_tax['OraHcmMonTaxDed']['proc_frm_dt'];
                $data_tax['proc_to_dt'] = $val_tax['OraHcmMonTaxDed']['proc_to_dt'];
                $data_tax['ded_doc_id'] = $val_tax['OraHcmMonTaxDed']['ded_doc_id'];
                $data_tax['ded_amt'] = $val_tax['OraHcmMonTaxDed']['emp_ded_amt'];
                $data_tax['doc_id'] = $val_tax['OraHcmMonTaxDed']['doc_id'];

                $this->SalaryProcessingDeduction->create();
                $this->SalaryProcessingDeduction->save($data_tax);
            }

            $data_oracle_nssf = new Model(array('table' => 'HCM$MON$NSSF$DED', 'ds' => 'ora', 'name' => 'HCMMONNSSFDED'));
            //$portal_nssf = new Model(array('table' =>'ora_hcm_mon_nssf_ded', 'ds' => 'default', 'name' => 'NSSFDED'));
            $oracle_data_nssf = $data_oracle_nssf->find('all', array('conditions' => array('proc_frm_dt' => $v['HCMSALSYNC']['proc_frm_dt'], 'proc_to_dt' => $v['HCMSALSYNC']['proc_to_dt'])));
            foreach ($oracle_data_nssf as $val_nssf) {
                $data['org_id'] = $val_nssf['HCMMONNSSFDED']['org_id'];
                $data['emp_code'] = $val_nssf['HCMMONNSSFDED']['emp_code'];
                $data['emp_doc_id'] = $val_nssf['HCMMONNSSFDED']['emp_doc_id'];
                $data['proc_frm_dt'] = $val_nssf['HCMMONNSSFDED']['proc_frm_dt'];
                $data['proc_to_dt'] = $val_nssf['HCMMONNSSFDED']['proc_to_dt'];
                $data['ded_doc_id'] = $val_nssf['HCMMONNSSFDED']['ded_doc_id'];
                $data['ded_amt'] = $val_nssf['HCMMONNSSFDED']['emp_ded_amt'];
                $this->SalaryProcessingDeduction->create();
                $this->SalaryProcessingDeduction->save($data);
            }
            $arr = new Model(array('table' => 'HCM$INCR$ARR', 'ds' => 'ora', 'name' => 'HCMINCRARR'));
            $oracle_data_arr = $arr->find('all', array('conditions' => array('arr_strt_dt' => $v['HCMSALSYNC']['proc_frm_dt'], 'arr_end_dt' => $v['HCMSALSYNC']['proc_to_dt'])));
            // print_r(count($orcale_data));die;
            if ($oracle_data_arr) {
                foreach ($oracle_data_arr as $k => $v_arr) {
                    $data = $v_arr['HCMINCRARR'];
                    $this->EmpIncrArr->create();
                    $this->EmpIncrArr->save($data);
                }
            }
        }
    }

    function integration_update_salary() {
        $oracle_sync_data = $this->OraDataTransferSync->find('first', array(
            'conditions' => array(
                'task_name' => 'HCM_SYNC'
            )
        ));

        $syn = $oracle_sync_data['OraDataTransferSync']['task_status'];

        if ($syn == 0) {
            $this->General->query('UPDATE data_transfer_sync set task_status = 1;');
            // $this->General->query('TRUNCATE newdata');
            //$oracle_ch_data = $this->OraDataInfo->find('all');
            $data = new Model(array('table' => 'DATA_INFO_SAL', 'ds' => 'ora', 'name' => 'OraDataInfo'));
            $oracle_ch_data = $data->find('all');
            //echo '<pre>';print_r($oracle_ch_data);  die("here");
            //disable all triggers
            $this->General->query('SET @DISABLE_TRIGGERS = 1;');
            foreach ($oracle_ch_data as $val) {
                $oracle_condi = array(
                    $val['OraDataInfo']['col_name'] => $val['OraDataInfo']['col_data'],
                );
                $cols = explode(',', $val['OraDataInfo']['col_name']);
                $vals = explode(',', $val['OraDataInfo']['col_data']);
                $i = 0;
                foreach ($cols as $v) {

                    $oracle_cond[$cols[$i]] = $vals[$i];
                    $i++;
                }
                echo $tbname = str_replace('$', '_', $val['OraDataInfo']['tab_name']);
                die;

                switch ($tbname) {

                    case 'HCM_SAL_PROC':
                        $data_oracle = $this->OraHcmSalProc->find('first', array('conditions' => $oracle_cond));

                        //for first time importing all the contacts
                        $data = $data_oracle['OraHcmSalProc'];

                        $present_data = $this->SalaryProcessing->find('first', array(
                            'conditions' => array(
                                'doc_id' => $data['doc_id'],
                                'emp_doc_id' => $data['emp_doc_id'],
                                'org_id' => $data['org_id']
                        )));
                        //print_r($data);
                        //print_r($present_data);die;
                        if ($present_data) {
                            $present_id = $present_data['SalaryProcessing']['id'];
                            $this->SalaryProcessing->id = $present_id;
                            $this->SalaryProcessing->save($data);
                        } else {
                            $this->SalaryProcessing->create();
                            $this->SalaryProcessing->save($data);
                        }

                        print_r("Done");
                        break;

                    case 'HCM_SAL_PROC_SAL':

                        $data_oracle = $this->OraHcmSalProcSal->find('first', array('conditions' => $oracle_cond));
                        $data = $data_oracle['OraHcmSalProcSal'];
                        $present_data = $this->SalaryProcessingAddition->find('first', array(
                            'conditions' => array(
                                'employee_sal_proc_sal_id' => $data['doc_id'],
                                'emp_doc_id' => $data['emp_doc_id'],
                                'SalaryProcessingAddition.org_id' => $data['org_id'],
                                'sal_id' => $data['sal_id']
                        )));

                        // print_r($present_data);die;
                        if ($present_data) {
                            $present_id = $present_data['SalaryProcessingAddition']['id'];
                            $this->SalaryProcessingAddition->id = $present_id;
                            $this->SalaryProcessingAddition->save($data);
                        } else {
                            $data['employee_sal_proc_sal_id'] = $data_oracle['OraHcmSalProcSal']['doc_id'];
                            unset($data['OraHcmSalProcSal']['doc_id']);
                            $this->SalaryProcessingAddition->create();
                            $this->SalaryProcessingAddition->save($data);
                        }

                        print_r("Done");
                        break;

                    case 'HCM_SAL_PROC_DED':

                        $data_oracle = $this->OraHcmSalProcDed->find('first', array('conditions' => $oracle_cond));
                        $data = $data_oracle['OraHcmSalProcDed'];
                        $present_data = $this->SalaryProcessingDeduction->find('first', array(
                            'conditions' => array(
                                'ded_doc_id' => $data['doc_id'],
                                'emp_doc_id' => $data['emp_doc_id'],
                                'org_id' => $data['org_id'],
                                'ded_id' => $data['ded_id']
                        )));

                        if ($present_data) {
                            $present_id = $present_data['SalaryProcessingDeduction']['id'];
                            $this->SalaryProcessingDeduction->id = $present_id;
                            $this->SalaryProcessingDeduction->save($data);
                        } else {
                            $data['ded_doc_id'] = $data_oracle['OraHcmSalProcDed']['doc_id'];
                            unset($data['OraHcmSalProcDed']['doc_id']);
                            $this->SalaryProcessingDeduction->create();
                            $this->SalaryProcessingDeduction->save($data);
                        }

                        print_r("Done");
                        break;

                    case 'HCM_MON_ESI_DED':
                        $org_id = $oracle_cond['ORG_ID'];
                        $emp_doc_id = $oracle_cond['EMP_DOC_ID'];
                        $proc_from = $oracle_cond['PROC_FRM_DT'];
                        $proc_to = $oracle_cond['PROC_TO_DT'];
                        $data_oracle = $this->OraHcmMonEsiDed->find('first', array('conditions' =>
                            array('ORG_ID' => $org_id, 'EMP_DOC_ID' => $emp_doc_id, "TO_CHAR(PROC_FRM_DT,'DD-MON-YY')" => $proc_from, "TO_CHAR(PROC_TO_DT,'DD-MON-YY')" => $proc_to)));
                        $data_new = $data_oracle['OraHcmMonEsiDed'];
                        $present_data = $this->SalaryProcessingDeduction->find('first', array(
                            'conditions' => array(
                                'ded_doc_id' => $data_new['ded_doc_id'],
                                'emp_doc_id' => $data_new['emp_doc_id'],
                                'org_id' => $data_new['org_id'],
                                'doc_id' => $data_new['doc_id'],
                                'proc_frm_dt' => $data['proc_frm_dt'],
                                'proc_to_dt' => $data['proc_to_dt']
                        )));

                        $data['org_id'] = $data_oracle['OraHcmMonEsiDed']['org_id'];
                        $data['emp_code'] = $data_oracle['OraHcmMonEsiDed']['emp_code'];
                        $data['emp_doc_id'] = $data_oracle['OraHcmMonEsiDed']['emp_doc_id'];
                        $data['proc_frm_dt'] = $data_oracle['OraHcmMonEsiDed']['proc_frm_dt'];
                        $data['proc_to_dt'] = $data_oracle['OraHcmMonEsiDed']['proc_to_dt'];
                        $data['ded_doc_id'] = $data_oracle['OraHcmMonEsiDed']['ded_doc_id'];
                        $data['ded_amt'] = $data_oracle['OraHcmMonEsiDed']['emp_ded_amt'];
                        $data['doc_id'] = $data_oracle['OraHcmMonEsiDed']['doc_id'];

                        //print_r($present_data); die;
                        if ($present_data) {
                            $present_id = $present_data['SalaryProcessingDeduction']['id'];
                            $this->SalaryProcessingDeduction->id = $present_id;
                            $this->SalaryProcessingDeduction->save($data);
                        } else {
                            $this->SalaryProcessingDeduction->create();
                            $this->SalaryProcessingDeduction->save($data);
                        }

                        print_r("Done");
                        break;

                    case 'HCM_MON_LOAN_DED':

                        $org_id = $oracle_cond['ORG_ID'];
                        $emp_doc_id = $oracle_cond['EMP_DOC_ID'];
                        $proc_from = $oracle_cond['PROC_FRM_DT'];
                        $proc_to = $oracle_cond['PROC_TO_DT'];
                        $data_oracle = $this->OraHcmMonLoanDed->find('first', array('conditions' =>
                            array('ORG_ID' => $org_id, 'EMP_DOC_ID' => $emp_doc_id, "TO_CHAR(PROC_FRM_DT,'DD-MON-YY')" => $proc_from, "TO_CHAR(PROC_TO_DT,'DD-MON-YY')" => $proc_to)));
                        $data_new = $data_oracle['OraHcmMonLoanDed'];
                        $present_data = $this->SalaryProcessingDeduction->find('first', array(
                            'conditions' => array(
                                'ded_doc_id' => $data_new['ded_doc_id'],
                                'emp_doc_id' => $data_new['emp_doc_id'],
                                'org_id' => $data_new['org_id'],
                                'doc_id' => $data_new['doc_id'],
                                'proc_frm_dt' => $data['proc_frm_dt'],
                                'proc_to_dt' => $data['proc_to_dt']
                        )));
                        $data['org_id'] = $data_oracle['OraHcmMonLoanDed']['org_id'];
                        $data['emp_code'] = $data_oracle['OraHcmMonLoanDed']['emp_code'];
                        $data['emp_doc_id'] = $data_oracle['OraHcmMonLoanDed']['emp_doc_id'];
                        $data['proc_frm_dt'] = $data_oracle['OraHcmMonLoanDed']['proc_frm_dt'];
                        $data['proc_to_dt'] = $data_oracle['OraHcmMonLoanDed']['proc_to_dt'];
                        $data['ded_doc_id'] = $data_oracle['OraHcmMonLoanDed']['ded_doc_id'];
                        $data['ded_amt'] = $data_oracle['OraHcmMonLoanDed']['emp_ded_amt'];
                        $data['doc_id'] = $data_oracle['OraHcmMonLoanDed']['doc_id'];

                        //print_r($present_data); die;
                        if ($present_data) {
                            $present_id = $present_data['SalaryProcessingDeduction']['id'];
                            $this->SalaryProcessingDeduction->id = $present_id;
                            $this->SalaryProcessingDeduction->save($data);
                        } else {
                            $this->SalaryProcessingDeduction->create();
                            $this->SalaryProcessingDeduction->save($data);
                        }


                        print_r("Done");
                        break;

                    case 'HCM_MON_PF_DED':
                        $org_id = $oracle_cond['ORG_ID'];
                        $emp_doc_id = $oracle_cond['EMP_DOC_ID'];
                        $proc_from = $oracle_cond['PROC_FRM_DT'];
                        $proc_to = $oracle_cond['PROC_TO_DT'];
                        $data_oracle = $this->OraHcmMonPfDed->find('first', array('conditions' =>
                            array('ORG_ID' => $org_id, 'EMP_DOC_ID' => $emp_doc_id, "TO_CHAR(PROC_FRM_DT,'DD-MON-YY')" => $proc_from, "TO_CHAR(PROC_TO_DT,'DD-MON-YY')" => $proc_to)));
                        $data_new = $data_oracle['OraHcmMonPfDed'];
                        $present_data = $this->SalaryProcessingDeduction->find('first', array(
                            'conditions' => array(
                                'ded_doc_id' => $data_new['ded_doc_id'],
                                'emp_doc_id' => $data_new['emp_doc_id'],
                                'org_id' => $data_new['org_id'],
                                'doc_id' => $data_new['doc_id'],
                                'proc_frm_dt' => $data['proc_frm_dt'],
                                'proc_to_dt' => $data['proc_to_dt']
                        )));

                        $data['org_id'] = $data_oracle['OraHcmMonPfDed']['org_id'];
                        $data['emp_code'] = $data_oracle['OraHcmMonPfDed']['emp_code'];
                        $data['emp_doc_id'] = $data_oracle['OraHcmMonPfDed']['emp_doc_id'];
                        $data['proc_frm_dt'] = $data_oracle['OraHcmMonPfDed']['proc_frm_dt'];
                        $data['proc_to_dt'] = $data_oracle['OraHcmMonPfDed']['proc_to_dt'];
                        $data['ded_doc_id'] = $data_oracle['OraHcmMonPfDed']['ded_doc_id'];
                        $data['ded_amt'] = $data_oracle['OraHcmMonPfDed']['emp_ded_amt'];
                        $data['doc_id'] = $data_oracle['OraHcmMonPfDed']['doc_id'];

                        //print_r($present_data); die;
                        if ($present_data) {
                            $present_id = $present_data['SalaryProcessingDeduction']['id'];
                            $this->SalaryProcessingDeduction->id = $present_id;
                            $this->SalaryProcessingDeduction->save($data);
                        } else {
                            $this->SalaryProcessingDeduction->create();
                            $this->SalaryProcessingDeduction->save($data);
                        }



                        print_r("Done");
                        break;

                    case 'HCM_MON_PROFSNL_DED':

                        $org_id = $oracle_cond['ORG_ID'];
                        $emp_doc_id = $oracle_cond['EMP_DOC_ID'];
                        $proc_from = $oracle_cond['PROC_FRM_DT'];
                        $proc_to = $oracle_cond['PROC_TO_DT'];
                        $data_oracle = $this->OraHcmMonProfsnlDed->find('first', array('conditions' =>
                            array('ORG_ID' => $org_id, 'EMP_DOC_ID' => $emp_doc_id, "TO_CHAR(PROC_FRM_DT,'DD-MON-YY')" => $proc_from, "TO_CHAR(PROC_TO_DT,'DD-MON-YY')" => $proc_to)));
                        $data_new = $data_oracle['OraHcmMonProfsnlDed'];
                        $present_data = $this->SalaryProcessingDeduction->find('first', array(
                            'conditions' => array(
                                'ded_doc_id' => $data_new['ded_doc_id'],
                                'emp_doc_id' => $data_new['emp_doc_id'],
                                'org_id' => $data_new['org_id'],
                                'doc_id' => $data_new['doc_id'],
                                'proc_frm_dt' => $data['proc_frm_dt'],
                                'proc_to_dt' => $data['proc_to_dt']
                        )));

                        $data['org_id'] = $data_oracle['OraHcmMonProfsnlDed']['org_id'];
                        $data['emp_code'] = $data_oracle['OraHcmMonProfsnlDed']['emp_code'];
                        $data['emp_doc_id'] = $data_oracle['OraHcmMonProfsnlDed']['emp_doc_id'];
                        $data['proc_frm_dt'] = $data_oracle['OraHcmMonProfsnlDed']['proc_frm_dt'];
                        $data['proc_to_dt'] = $data_oracle['OraHcmMonProfsnlDed']['proc_to_dt'];
                        $data['ded_doc_id'] = $data_oracle['OraHcmMonProfsnlDed']['ded_doc_id'];
                        $data['ded_amt'] = $data_oracle['OraHcmMonProfsnlDed']['emp_ded_amt'];
                        $data['doc_id'] = $data_oracle['OraHcmMonProfsnlDed']['doc_id'];

                        //print_r($present_data); die;
                        if ($present_data) {
                            $present_id = $present_data['SalaryProcessingDeduction']['id'];
                            $this->SalaryProcessingDeduction->id = $present_id;
                            $this->SalaryProcessingDeduction->save($data);
                        } else {
                            $this->SalaryProcessingDeduction->create();
                            $this->SalaryProcessingDeduction->save($data);
                        }


                        print_r("Done");
                        break;

                    case 'HCM_MON_SUPER_DED':

                        $org_id = $oracle_cond['ORG_ID'];
                        $emp_doc_id = $oracle_cond['EMP_DOC_ID'];
                        $proc_from = $oracle_cond['PROC_FRM_DT'];
                        $proc_to = $oracle_cond['PROC_TO_DT'];
                        $data_oracle = $this->OraHcmMonSuperDed->find('first', array('conditions' =>
                            array('ORG_ID' => $org_id, 'EMP_DOC_ID' => $emp_doc_id, "TO_CHAR(PROC_FRM_DT,'DD-MON-YY')" => $proc_from, "TO_CHAR(PROC_TO_DT,'DD-MON-YY')" => $proc_to)));
                        $data_new = $data_oracle['OraHcmMonSuperDed'];
                        $present_data = $this->SalaryProcessingDeduction->find('first', array(
                            'conditions' => array(
                                'ded_doc_id' => $data_new['ded_doc_id'],
                                'emp_doc_id' => $data_new['emp_doc_id'],
                                'org_id' => $data_new['org_id'],
                                'doc_id' => $data_new['doc_id'],
                                'proc_frm_dt' => $data['proc_frm_dt'],
                                'proc_to_dt' => $data['proc_to_dt']
                        )));

                        $data['org_id'] = $data_oracle['OraHcmMonSuperDed']['org_id'];
                        $data['emp_code'] = $data_oracle['OraHcmMonSuperDed']['emp_code'];
                        $data['emp_doc_id'] = $data_oracle['OraHcmMonSuperDed']['emp_doc_id'];
                        $data['proc_frm_dt'] = $data_oracle['OraHcmMonSuperDed']['proc_frm_dt'];
                        $data['proc_to_dt'] = $data_oracle['OraHcmMonSuperDed']['proc_to_dt'];
                        $data['ded_doc_id'] = $data_oracle['OraHcmMonSuperDed']['ded_doc_id'];
                        $data['ded_amt'] = $data_oracle['OraHcmMonSuperDed']['emp_ded_amt'];
                        $data['doc_id'] = $data_oracle['OraHcmMonSuperDed']['doc_id'];

                        //print_r($present_data); die;
                        if ($present_data) {
                            $present_id = $present_data['SalaryProcessingDeduction']['id'];
                            $this->SalaryProcessingDeduction->id = $present_id;
                            $this->SalaryProcessingDeduction->save($data);
                        } else {
                            $this->SalaryProcessingDeduction->create();
                            $this->SalaryProcessingDeduction->save($data);
                        }


                        print_r("Done");
                        break;

                    case 'HCM_MON_TAX_DED':
                        $org_id = $oracle_cond['ORG_ID'];
                        $emp_doc_id = $oracle_cond['EMP_DOC_ID'];
                        $proc_from = $oracle_cond['PROC_FRM_DT'];
                        $proc_to = $oracle_cond['PROC_TO_DT'];
                        $data_oracle = $this->OraHcmMonTaxDed->find('first', array('conditions' =>
                            array('ORG_ID' => $org_id, 'EMP_DOC_ID' => $emp_doc_id, "TO_CHAR(PROC_FRM_DT,'DD-MON-YY')" => $proc_from, "TO_CHAR(PROC_TO_DT,'DD-MON-YY')" => $proc_to)));
                        $data_new = $data_oracle['OraHcmMonTaxDed'];
                        $present_data = $this->SalaryProcessingDeduction->find('first', array(
                            'conditions' => array(
                                'ded_doc_id' => $data_new['ded_doc_id'],
                                'emp_doc_id' => $data_new['emp_doc_id'],
                                'org_id' => $data_new['org_id'],
                                'doc_id' => $data_new['doc_id'],
                                'proc_frm_dt' => $data['proc_frm_dt'],
                                'proc_to_dt' => $data['proc_to_dt']
                        )));

                        $data['org_id'] = $data_oracle['OraHcmMonTaxDed']['org_id'];
                        $data['emp_code'] = $data_oracle['OraHcmMonTaxDed']['emp_code'];
                        $data['emp_doc_id'] = $data_oracle['OraHcmMonTaxDed']['emp_doc_id'];
                        $data['proc_frm_dt'] = $data_oracle['OraHcmMonTaxDed']['proc_frm_dt'];
                        $data['proc_to_dt'] = $data_oracle['OraHcmMonTaxDed']['proc_to_dt'];
                        $data['ded_doc_id'] = $data_oracle['OraHcmMonTaxDed']['ded_doc_id'];
                        $data['ded_amt'] = $data_oracle['OraHcmMonTaxDed']['emp_ded_amt'];
                        $data['doc_id'] = $data_oracle['OraHcmMonTaxDed']['doc_id'];

                        //print_r($present_data); die;
                        if ($present_data) {
                            $present_id = $present_data['SalaryProcessingDeduction']['id'];
                            $this->SalaryProcessingDeduction->id = $present_id;
                            $this->SalaryProcessingDeduction->save($data);
                        } else {
                            $this->SalaryProcessingDeduction->create();
                            $this->SalaryProcessingDeduction->save($data);
                        }


                        print_r("Done");
                        break;

                    case 'HCM_IT_PROC':

                        $data_oracle = $this->OraHcmItProc->find('first', array('conditions' => $oracle_cond));
                        $org_id = $oracle_cond['ORG_ID'];
                        $emp_doc_id = $oracle_cond['EMP_DOC_ID'];
                        $proc_from = $oracle_cond['PROC_FRM_DT'];
                        $proc_to = $oracle_cond['PROC_TO_DT'];
                        $data_oracle = $this->OraHcmItProc->find('first', array('conditions' =>
                            array('ORG_ID' => $org_id, 'EMP_DOC_ID' => $emp_doc_id, "TO_CHAR(PROC_FRM_DT,'DD-MON-YY')" => $proc_from, "TO_CHAR(PROC_TO_DT,'DD-MON-YY')" => $proc_to)));

                        $data = $data_oracle['OraHcmItProc'];
                        $data['OracleHcmItProc'] = $data_oracle['OraHcmItProc'];
                        $present_data = $this->OracleHcmItProc->find('first', array(
                            'conditions' => array(
                                'doc_id' => $data['doc_id'],
                                'org_id' => $data['org_id'],
                                'proc_frm_dt' => $data['proc_frm_dt'],
                                'proc_to_dt' => $data['proc_to_dt']
                        )));

                        if ($present_data) {
                            $present_id = $present_data['OracleHcmItProc']['id'];
                            $this->OracleHcmItProc->id = $present_id;
                            $this->OracleHcmItProc->save($data);
                        } else {
                            $this->OracleHcmItProc->create();
                            $this->OracleHcmItProc->save($data);
                        }

                        print_r("Done");
                        break;

                    default:
                        break;
                }
                unset($oracle_cond);
            }
            $this->GeneralOracle->query('DELETE DATA_INFO');
			$this->General->query('SET @DISABLE_TRIGGERS = NULL;');
            $this->General->query('UPDATE data_transfer_sync set task_status = 0;');
            exit();
        }
    }

    function updatepass() {
        $result = $this->UserDetail->find('all', array('fields' => array('emp_code', 'user_password')));
        foreach ($result as $pass) {
            $dob = $this->MyProfile->find('first', array('fields' => array('dob'), 'conditions' => array('emp_code' => $pass['UserDetail']['emp_code'])));

            $newDate = date("dmY", strtotime(trim($dob['MyProfile']['dob'])));
            $password = $this->Auth->password(trim($newDate));
            $updatecommand = $this->UserDetail->updateAll(
                    array('UserDetail.user_password' => "'$password'"), array('UserDetail.emp_code' => $pass['UserDetail']['emp_code'])
            );
        }
    }

	function ee(){
		Configure::write('debug',2);
		$data_user['emp_code']='8483';
		$emp_code= $data_user['emp_code'];
		$appraiser_id = $this->Common->getManagerCode($emp_code);
		$reviewer_id = $this->Common->getManagerCode($appraiser_id);
		
		echo 'emp -> '.$emp_code.'<br>app code -> '.$appraiser_id.'<br>rev code -> '.$reviewer_id;
		
		$success = $this->KraTarget->UpdateAll(
			array(
				'KraTarget.appraiser_id' => $appraiser_id,
				'KraTarget.reviewer_id' => $reviewer_id
				), 
			array(
				'KraTarget.emp_code' => $emp_code
				)
			);
			
		die;
	}

    
    function truncate_info(){
        $this->General->query('TRUNCATE data_info');
    }


    function get_hd_costing_data() {
        $this->autoRender = false;
        $data_oracle = $this->HdCosting->find('all');
        foreach ($data_oracle as $k => $v) {
            $data = $v['OraHcmSalProcDed'];
            $this->HdCosting->create();
            $this->HdCosting->save($data);
        }
    }

    function get_dt_costing_data() {
        $this->autoRender = false;
        $data_oracle = $this->DtCosting->find('all');
        foreach ($data_oracle as $k => $v) {
            $data = $v['OraHcmSalProcDed'];
            $this->DtCosting->create();
            $this->DtCosting->save($data);
        }
    }
}
?>
 
