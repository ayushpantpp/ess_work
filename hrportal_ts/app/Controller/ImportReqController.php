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

    function import_deductions() {
        $this->autoRender = false;
        $data_oracle_advance = new Model(array('table' => 'HCM$EMP$ADVNCE', 'ds' => 'ora', 'name' => 'HCMEMPADVNCE'));
        $data_oracle_advance_ded = $data_oracle_advance->find('all');
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
                        $data_user['user_password'] = $this->Auth->password(date('dmY', strtotime(trim($v['OracleHcmEmpPrf']['dob']))));
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
                                    $leave_save = $this->LeaveDetail->save($data_val);
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
                                $record_id = $this->MstEmpLeave->getLastInsertID();
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

    function truncate_info() {
        $this->General->query('TRUNCATE data_info');
    }

}
?>

