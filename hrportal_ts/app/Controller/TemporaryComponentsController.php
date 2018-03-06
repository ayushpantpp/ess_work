<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 * Description of TemporaryComponentsController
 *
 * @author hp4420-50
 */
class TemporaryComponentsController extends AppController {

    var $uses = array('TemporaryComponentDetail','MyProfile', 'OraOrgHcmSalary', 'OracleOrgHcmSalary', 'EmployeeSalMon', 'TempWorkflow', 'EmployeeSalMonDt');
    var $components = array('Session', 'Cookie', 'RequestHandler', 'Auth', 'EmpDetail', 'Common');
    var $helpers = array('Html', 'Js', 'Form', 'Session', 'Userdetail', 'Leave', 'Common');

    function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow();
        $this->set('appId', 16);
        $currentUser = $this->checkUser();
    }

    function add() {

        $this->layout = 'employee-new';
        $month = date('m');
        $temp_comp = $this->OracleOrgHcmSalary->find('list', array(
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
            'conditions' => array('OracleOrgHcmSalary.sal_type' => 'T')
        ));

        foreach ($temp_comp_month as $temp) {
            $temp_id = $temp['Dt']['sal_id'];
            unset($temp_comp[$temp_id]);
        }
        if (!empty($this->data)) {
            $max_filed = $this->EmployeeSalMon->find('first', array('fields' => array('MAX(voucher_id) as voucher_id')));
            for ($i = 1; $i <= count($this->request->data['temp_code']); $i++) {
                if ($_FILES['file_' . $i]['name'] != '') {
                    $n = rand(0, 100000);
                    $newfilename = $n . basename($_FILES['file_' . $i]['name']);
                    $file = "uploads/TempComp/" . $newfilename;
                    $filename = basename($_FILES['file_' . $i]['name']);
                    $val_arr['vc_file'] = $newfilename;
                }
                move_uploaded_file($_FILES['file_' . $i]['tmp_name'], $file);
                $val_arr['emp_code'] = $this->Auth->User('emp_code');
                $myprofile = $this->MyProfile->find('first', array('fields' => array('doc_id'), 'conditions' => array('emp_code' => $this->Auth->User('emp_code'))));
                $empCode = $val_arr['emp_code'];
                $claimDate = date('Y-m-d', strtotime($this->request->data['tempcomp']['Claimdate']));
                $val_arr['emp_doc_id'] = $myprofile['MyProfile']['doc_id'];
                $val_arr['created_at'] = date('Y-m-d');
                $val_arr['status'] = 1;
                $val_arr['voucher_id'] = $max_filed[0]['voucher_id'] + 1;
                $val_arr['emp_code'] = $this->Auth->User('emp_code');
                $val_arr['sal_id'] = $this->request->data['temp_code'][$i];
                $val_arr['sal_val'] = $this->request->data['amount'][$i];
                $val_arr['sal_amt'] = $this->request->data['amount'][$i];
                $val_arr['claim_date'] = $claimDate;
                $val_arr['status'] = 7;
                $val_arr['cld_id'] = '0000';
                $val_arr['sloc_id'] = 1;
                $val_arr['org_id'] = $this->Auth->User('comp_code');
                $val_arr['ho_org_id'] = $this->Auth->User('comp_code');
                $val_arr['proc_frm_dt'] = date('Y-m-01', strtotime($claimDate));
                $val_arr['proc_to_dt'] = date('Y-m-t', strtotime($claimDate));
                $this->EmployeeSalMon->create();
                if ($this->EmployeeSalMon->save($val_arr)) {
                    $record_id = $val_arr['voucher_id'];
                }
            }
            $this->Session->setFlash("<div data-uk-alert='' class='uk-alert uk-alert-success'><a class='uk-alert-close uk-close' href='#'></a>Temporary component applied succesfully</div>");
            $this->redirect('/temporaryComponents/workflow_display/' . $record_id);
        }

        $this->set('temp', $temp_comp);
        $this->set('temp_comp_month', $temp_comp_month);
    }

    public function workflow_display($id, $v_id) {

        $this->layout = 'employee-new';
        $this->set('id', $id);
        $this->set('voucher_id', $v_id);
    }

    public function saveinfomation() {

        if (!empty($this->request->data)) {
            if (!empty($this->request->data['TempWorkflow']['voucher_id'])) {
                $vouchers = $this->EmployeeSalMon->find('all', array('fields' => array('*'), 'conditions' => array('voucher_id' => $this->request->data['TempWorkflow']['voucher_id'], 'id' => $this->request->data['TempWorkflow']['temp_id'])));
            } else {
                $vouchers = $this->EmployeeSalMon->find('all', array('fields' => array('*'), 'conditions' => array('voucher_id' => $this->request->data['TempWorkflow']['temp_id'])));
            }
            $org_id = $this->Auth->User('comp_code');
            foreach ($vouchers as $v) {
                $save = array();
                $save['employee_sal_mon_id'] = $v['EmployeeSalMon']['id'];
                if (!empty($this->request->data['TempWorkflow']['voucher_id'])) {
                    $this->request->data['TempWorkflow']['voucher_id'] = $this->request->data['TempWorkflow']['voucher_id'];
                } else {
                    $this->request->data['TempWorkflow']['voucher_id'] = $this->request->data['TempWorkflow']['temp_id'];
                }
                $save['voucher_id'] = $this->request->data['TempWorkflow']['voucher_id'];
                $save['emp_code'] = $this->Auth->User('emp_code');
                $save['temp_status'] = 2;
                $save['fw_date'] = date('Y-m-d h:i:s');

                $this->TempWorkflow->create();
                $val = $this->TempWorkflow->save($save);
                if ($val) {
                    unset($save);
                    $save1['emp_code'] = $this->request->data['TempWorkflow']['emp_code'];
                    $save1 = array();
                    $save1['employee_sal_mon_id'] = $v['EmployeeSalMon']['id'];
                    $save1['voucher_id'] = $this->request->data['TempWorkflow']['voucher_id'];
                    $save1['emp_code'] = $this->request->data['TempWorkflow']['emp_code'];

                    $this->TempWorkflow->create();
                    if ($this->TempWorkflow->save($save1)) {
                        unset($save1);
                        $this->EmployeeSalMon->updateAll(
                                array('EmployeeSalMon.status' => '2'), array('EmployeeSalMon.id' => $v['EmployeeSalMon']['id'])
                        );
                    }
                }
            }
//die;
            $this->Session->setFlash("<div data-uk-alert='' class='uk-alert uk-alert-success'><a class='uk-alert-close uk-close' href='#'></a>Temporary component forwarded successfully.</div>");
            $this->redirect(array('controller' => 'TemporaryComponents', 'action' => 'view'));
        }
    }
    
     function delete($id,$voucher_id) {
			    if ($this->EmployeeSalMon->delete($id)) {
				$this->Session->setFlash("<div data-uk-alert='' class='uk-alert uk-alert-danger'><a class='uk-alert-close uk-close' href='#'></a>Temporary component deleted.</div>");
				$this->redirect('/temporaryComponents/view/');
				}
        }


    public function view() {
        $this->layout = 'employee-new';
        $this->paginate = array(
            'fields' => array('*'),
            'conditions' => array('EmployeeSalMon.emp_code' => $this->Auth->User('emp_code')),
            'limit' => '10'
        );
        $data = $this->paginate('EmployeeSalMon');
        //echo '<pre>';print_r($data);die;
        $emp_name = $this->MyProfile->find('first', array('fields' => array('*'), 'conditions' => array('emp_code' => $this->Auth->user('emp_code'))));
        $this->set('temp', $data);
        $this->set('emp_name', $emp_name['MyProfile']['emp_firstname']);
        $this->set('lastname', $emp_name['MyProfile']['emp_lastname']);
        $this->set('emp_id', $emp_name['MyProfile']['emp_id']);
    }

    public function detail_view($id) {

        $this->layout = false;
        $this->loadModel('EmployeeSalMon');

        $employeeSalMonDetail = $this->EmployeeSalMon->find('all', array(
            'fields' => array('*'),
            'joins' => array(
                array(
                    'table' => 'option_attribute',
                    'alias' => 'OA',
                    'type' => 'inner',
                    'foreignKey' => false,
                    'conditions' => array('OA.id = EmployeeSalMon.sal_id'
                    ))
            ),
            'conditions' => array('EmployeeSalMon.id' => $id)
        ));
//print_r($employeeSalMonDetail);die;
        //$employeeSalMonDetail = $this->DtEmployeeSalMon->find('all',array('fields'=>array('*'),'conditions'=>array('employee_sal_mon_id'=>$id)));


        $this->set('employeeSalMonDetail', $employeeSalMonDetail);

        $emp_name = $this->MyProfile->find('first', array('fields' => array('*'), 'conditions' => array('emp_code' => $this->Auth->user('emp_code'))));
        $this->set('emp_name', $emp_name['MyProfile']['emp_firstname']);
        $this->set('lastname', $emp_name['MyProfile']['emp_lastname']);
        $this->set('emp_id', $emp_name['MyProfile']['emp_id']);
    }

    public function approval_detail_view($id) {

        $this->layout = false;
        $this->loadModel('EmployeeSalMon');

        $employeeSalMonDetail = $this->EmployeeSalMon->find('all', array(
            'fields' => array('*'),
            'joins' => array(
                array(
                    'table' => 'option_attribute',
                    'alias' => 'OA',
                    'type' => 'inner',
                    'foreignKey' => false,
                    'conditions' => array('OA.id = EmployeeSalMon.sal_id'
                    ))
            ),
            'conditions' => array('EmployeeSalMon.id' => $id)
        ));

        //$employeeSalMonDetail = $this->DtEmployeeSalMon->find('all',array('fields'=>array('*'),'conditions'=>array('employee_sal_mon_id'=>$id)));


        $this->set('employeeSalMonDetail', $employeeSalMonDetail);

        $emp_name = $this->MyProfile->find('first', array('fields' => array('*'), 'conditions' => array('emp_code' => $this->Auth->user('emp_code'))));
        $this->set('emp_name', $emp_name['MyProfile']['emp_firstname']);
        $this->set('lastname', $emp_name['MyProfile']['emp_lastname']);
        $this->set('emp_id', $emp_name['MyProfile']['emp_id']);
    }

    public function approval() {
        $this->layout = 'employee-new';
        $org_id = $this->Auth->User('comp_code');
        $emp_code = $this->Auth->User('emp_code');
        if (empty($emp_code)) {
            $this->redirect('view');
        }


        $this->paginate = array(
            'fields' => array('*'),
            'limit' => 10,
            'order' => array('EmployeeSalMon.id  DESC '),
            'joins' => array(
                array(
                    'table' => 'temp_workflow',
                    'alias' => 'temp',
                    'type' => 'inner',
                    'foreignKey' => false,
                    'conditions' => array('temp.employee_sal_mon_id =  EmployeeSalMon.id ')
                ),
            ),
            'conditions' => array('temp.emp_code' => $emp_code, 'temp.fw_date' => NULL)
        );


        $pending_temp_employee = $this->paginate('EmployeeSalMon');

        $emp_code_emp = $pending_temp_employee[0]['EmployeeSalMon']['emp_code'];

        $this->set('pending_temp_employee', $pending_temp_employee);
    }

    public function fwtemp($id) {
        $this->layout = 'employee-new';
        $tempid = base64_decode($id);

        if ($tempid) {
            $lta = $this->EmployeeSalMon->find('first', array('fields' => array('*'), 'conditions' => array('id' => $tempid)));

            $ltawfid = $this->TempWorkflow->find('first', array('fields' => array('id'),
                'conditions' => array('emp_code' => $this->Auth->User('emp_code'), 'employee_sal_mon_id' => $tempid)));

            $this->set('tempstatus', $lta['EmployeeSalMon']['status']);
            $this->set('temp_amt_id', $lta['EmployeeSalMon']['id']);
            $this->set('tempwfid', $ltawfid['TempWorkflow']['id']);
        }
    }

    public function tempsaveinfo() {

        if (!empty($this->request->data)) {

            //============== Forward==================
            if ($this->request->data['TempWorkflow']['type'] == 2) {

                $save = array();
                $save['id'] = $this->request->data['TempWorkflow']['id'];
                $save['remark'] = $this->request->data['TempWorkflow']['forward_remark'];
                $save['fw_date'] = date('Y-m-d');
                $save['lta_status'] = 2;

                $this->TempWorkflow->save($save);
                unset($save);
                $check = $this->TempWorkflow->find('first', array('conditions' => array(
                        'id' => $this->request->data['TempWorkflow']['id'],
                        'emp_code' => $this->request->data['TempWorkflow']['forward_emp_code'])));

                if (empty($check)) {
                    $save1 = array();
                    $save1['employee_sal_mon_id'] = $this->request->data['TempWorkflow']['employee_sal_mon_id'];
                    $save1['emp_code'] = $this->request->data['TempWorkflow']['forward_emp_code'];
                    $this->TempWorkflow->create();
                    $this->TempWorkflow->save($save1);
                    unset($save1);
                } else {
                    $remark = $this->request->data['TempWorkflow']['forward_remark'];
                    $this->EmployeeSalMon->updateAll(array('status' => null), array(
                        'id' => $this->request->data['TempWorkflow']['employee_sal_mon_id'],
                        'emp_code' => $this->request->data['TempWorkflow']['forward_emp_code']));
                    $this->TempWorkflow->updateAll(array('temp_status' => 2, 'remark' => "'.$remark.'"), array('id' => $check['TempWorkflow']['id']));
                }

                if ($this->EmpDetail->getlaststagelevel(1) == 0) {

                    $this->EmployeeSalMon->updateAll(
                            array('EmployeeSalMon.status' => 2, 'EmployeeSalMon.remark' => $remark), array('EmployeeSalMon.id' => $this->request->data['TempWorkflow']['employee_sal_mon_id'])
                    );
                } else {

                    $this->EmployeeSalMon->updateAll(
                            array('EmployeeSalMon.status' => 5), array('EmployeeSalMon.id' => $this->request->data['EmployeeSalMon']['employee_sal_mon_id'])
                    );
                }
                $this->Session->setFlash('Temporary Component Forwarded.');
                $this->redirect(array('controller' => 'temporaryComponents', 'action' => 'approval'));
            } else if ($this->request->data['TempWorkflow']['type'] == 3) {

                $save1 = array();
                $save = array();
                $save['id'] = $this->request->data['TempWorkflow']['id'];
                $save['remark'] = $this->request->data['TempWorkflow']['revert_remark'];
                $save['temp_status'] = 3;
                $save['fw_date'] = '';
                $this->TempWorkflow->save($save);
                $check = $this->TempWorkflow->find('first', array('conditions' => array(
                        'employee_sal_mon_id' => $this->request->data['TempWorkflow']['employee_sal_mon_id'],
                        'emp_code' => $this->request->data['employee_sal_mon_id']['revert_emp_code'])));
                if (empty($check)) {
                    $save1['employee_sal_mon_id'] = $this->request->data['TempWorkflow']['employee_sal_mon_id'];
                    $save1['emp_code'] = $this->request->data['TempWorkflow']['revert_emp_code'];
                    $save1['temp_status'] = 2;
                    $this->TempWorkflow->save($save1);
                } else {
                    $revert_reason = $this->request->data['TempWorkflow']['revert_remark'];
                    $this->TempWorkflow->updateAll(array('fw_date' => null, 'remark' => "'.$revert_reason.'"), array('id' => $check['TempWorkflow']['id']));
                    $this->EmployeeSalMon->updateAll(array('EmployeeSalMon.status' => 3, 'EmployeeSalMon.remark' => $revert_reason), array('EmployeeSalMon.id' => $this->request->data['TempWorkflow']['employee_sal_mon_id'])
                    );
                }
                unset($save1);
                unset($save);
                /* $this->ConveyencExpenseDetail->updateAll(
                  array('ConveyencExpenseDetail.conveyence_status' => '3'),
                  array('ConveyencExpenseDetail.voucher_id' => $this->request->data['ConveyenceWorkflow']['voucher_id'])); */
                $this->Session->setFlash('Temporary Component Reverted.');
                $this->redirect(array('controller' => 'temporaryComponents', 'action' => 'approval'));
            } else if ($this->request->data['TempWorkflow']['type'] == 4) {
                $rem = $this->request->data['TempWorkflow']['approve_remark'];
                $lv_rej = $this->EmployeeSalMon->updateAll(
                        array('EmployeeSalMon.status' => 4, 'remark' => "'$rem'", 'approval_date' => date('Y-m-d')), array(
                    'EmployeeSalMon.id' => $this->request->data['TempWorkflow']['employee_sal_mon_id'])
                );
                $remark = $this->request->data['TempWorkflow']['approve_remark'];

                if ($lv_rej) {

                    $newsave = array();
                    $newsave['id'] = $this->request->data['TempWorkflow']['id'];
                    $newsave['emp_code'] = $this->Auth->User('emp_code');
                    $newsave['remark'] = $this->request->data['TempWorkflow']['approve_remark'];
                    $newsave['approve_date'] = date('Y-m-d');
                    $newsave['temp_status'] = 4;
                    $this->TempWorkflow->save($newsave);

                    $this->Session->setFlash("<div data-uk-alert='' class='uk-alert uk-alert-success'><a class='uk-alert-close uk-close' href='#'></a>Temporary Component Rejected", false, array('class' => 'flash flash_error'));
                    $this->redirect(array('controller' => 'temporaryComponents', 'action' => 'approval'));
                }
            } else if ($this->request->data['TempWorkflow']['type'] == 5) {
                $rem = $this->request->data['TempWorkflow']['approve_remark'];
                $lv_app = $this->EmployeeSalMon->updateAll(
                        array('EmployeeSalMon.status' => 5, 'remark' => "'$rem'", 'approval_date' => date('Y-m-d')), array(
                    'EmployeeSalMon.id' => $this->request->data['TempWorkflow']['employee_sal_mon_id'])
                );
                if ($lv_app) {
                    $newsave = array();
                    $newsave['id'] = $this->request->data['TempWorkflow']['id'];
                    $newsave['employee_sal_mon_id'] = $this->request->data['TempWorkflow']['employee_sal_mon_id'];
                    $newsave['emp_code'] = $this->Auth->User('emp_code');
                    $newsave['remark'] = $this->request->data['TempWorkflow']['approve_remark'];
                    $newsave['approve_date'] = date('Y-m-d');
                    $newsave['temp_status'] = 5;

                    $this->TempWorkflow->save($newsave);
                    /* 'emp_code' => $val['ConveyencExpenseDetail']['emp_code'],
                      'voucher_id' => $val['ConveyencExpenseDetail']['voucher_id']
                      )); */
                }

                $this->Session->setFlash("<div data-uk-alert='' class='uk-alert uk-alert-success'><a class='uk-alert-close uk-close' href='#'></a>Temporary Component Approved Successfully</div>", false, array('class' => 'flash flash_error'));
                $this->redirect(array('controller' => 'temporaryComponents', 'action' => 'approval'));
            }
        }
        $this->redirect(array('controller' => 'temporaryComponents', 'action' => 'approval'));
    }
    public function temporary_comp_report() {
        //Configure::write('debug',2);
        $this->layout = 'employee-new';
        $auth = $this->Session->read('Auth');
        $orgID = $auth['MyProfile']['comp_code'];
	$vouch_status = 0;

        $flag = '';
        if (isset($this->request->data['submit']) && $this->request->data['submit'] != '') {

            if (($this->request->data['tempo_status'] == '0' || $this->request->data['tempo_status'] == '') && $this->request->data['from_date'] == '' && $this->request->data['end_date'] == '') {
                $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert="">
                            <a href="#" class="uk-alert-close uk-close"></a>Please Enter Atleast One Value !!!!</div>');
                $this->redirect('temporary_comp_report');
            }

            if ($this->request->data['tempo_status'] != '0' && $this->request->data['tempo_status'] != '') {
                    $ORconditions['TemporaryComponentDetail.status'] = $this->request->data['tempo_status'];

                $vouch_status = $this->request->data['tempo_status'];
            }

            if ($this->request->data['from_date'] != '' && $this->request->data['end_date'] != '') {
                $from_date = date('Y-m-d', strtotime($this->request->data['from_date']));
                $end_date = date('Y-m-d', strtotime($this->request->data['end_date']));
                $ORconditions['TemporaryComponentDetail.claim_date between ? and ?'] = array($from_date, $end_date);
            }

            $ORconditions['ho_org_id'] = $orgID;
            $conditions = array($ORconditions);

             $VoucherDetails = $this->TemporaryComponentDetail->find('all', array(
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
            $this->set(compact('VoucherDetails', 'flag', 'vouch_status', 'from_date', 'end_date'));
        }
        $voucherStatus = array('0' => '---Select---', '2' => 'Forwarded', '5' => 'Approved','4' => 'Rejected');

        $this->set(compact('voucherStatus'));
    }
    
    public function tempo_claim_status() {
        $this->layout = 'employee-new';
        $auth = $this->Session->read('Auth');

        if (isset($this->request->data['submit']) && $this->request->data['submit'] != '') {

            if (!empty($this->request->data['id'])) {
                foreach ($this->request->data['id'] as $val) {
                    $PaymentUpdate = $this->TemporaryComponentDetail->updateAll(array('TemporaryComponentDetail.status' => $this->request->data['status']), array('TemporaryComponentDetail.id' => $val));
                }
                $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                            <a href="#" class="uk-alert-close uk-close"></a>Payment Status Updated Successfully !!</div>');
                $this->redirect('temporary_comp_report');
            } else {
                $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert="">
                            <a href="#" class="uk-alert-close uk-close"></a>Sorry, there is no record to update payment status !!</div>');
                $this->redirect('employee_expense_report');
            }
        } else {
            $this->redirect('temporary_comp_report');
        }
    }

public function generate_tmp_com_report_pdf($from_date = null, $end_date = null, $status = null) {
        //Configure::write('debug',2);
        $this->layout = 'employee-new';
        $auth = $this->Session->read('Auth');
        $orgID = $auth['MyProfile']['comp_code'];


        if ($from_date != 'null' && $end_date != 'null') {
            $ORconditions['TemporaryComponentDetail.claim_date between ? and ?'] = array($from_date, $end_date);
        }

        if ($status != 'null') {
            $ORconditions['TemporaryComponentDetail.status'] = $status;
        }

        $ORconditions['ho_org_id'] = $orgID;
        $conditions = array($ORconditions);

        $VoucherDetails = $this->TemporaryComponentDetail->find('all', array(
            'fields' => array('*'),
            //'limit' => 10,
            //'order' => array('DtTravelVoucher.voucher_id  DESC'),
            'conditions' => $conditions
                //'order'=>array('LvMstId.id desc')
        ));

        App::import('Vendor', 'TCpdf', array('file' => 'mpdf60/mpdf.php'));
        $this->layout = 'pdf';
        $this->set('pdf', new mPDF('utf-8', array(350, 500)));
        $this->set('VoucherDetails', $VoucherDetails);
    }

    public function addnew() {
        Configure::write('debug',2);
        
    }

}
