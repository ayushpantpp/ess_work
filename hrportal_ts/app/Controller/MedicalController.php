<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MedicalController
 *
 * @author hp4420-28u
 */
class MedicalController extends AppController {

    var $uses = array('WfMstStatus', 'MedicalBillAmount', 'MyProfile', 'MedicalWorkflow','WfPaginateLvl');
    var $components = array('Session', 'Cookie', 'RequestHandler', 'Auth', 'EmpDetail', 'Common');
    var $helpers = array('Html', 'Js', 'Form', 'Session', 'Userdetail', 'Leave', 'Common');

    function beforeFilter() {

        parent::beforeFilter();
        $this->Auth->allow();
        $this->set('status', $this->WfMstStatus->find('list', array('fields' => array('id', 'status_name'))));
        $this->set('appId', 15);
        $currentUser = $this->checkUser();
    }

    public function add() {
        $this->layout = 'employee-new';
        $emp_code = $this->Auth->User('emp_code');
        $emp_details = $this->EmpDetail->getemployeeinfomation($emp_code);
        $emp_name = $this->MyProfile->find('first', array('fields' => array('*'), 'conditions' => array('emp_code' => $this->Auth->user('emp_code'))));
        $this->set('gender', $emp_details['MyProfile']['gender']);
        $this->set('lastname', $emp_details['MyProfile']['emp_lastname']);
        $this->set('emp_name', $emp_details['MyProfile']['emp_firstname']);
        $this->set('emp_details', $emp_details['MyProfile']);
    }

    public function Medicalclaim() {

        $medical_value = array();

        foreach ($_FILES['doc_file']['name'] as $ky => $ve) {
            $n = rand(0, 100000);
            $newfilename = $n . basename($_FILES['doc_file']['name'][$ky]);
            $newfilenames[$ky] = $n . basename($_FILES['doc_file']['name'][$ky]);
            $file = "uploads/Medical/" . $newfilename;
            $filename = basename($_FILES['doc_file']['name'][$ky]);
            move_uploaded_file($_FILES['doc_file']['tmp_name'][$ky], $file);
        }

        $emp_code = $this->Auth->User('emp_code');
        $emp_details = $this->EmpDetail->getemployeeinfomation($emp_code);
        $emp_name = $this->MyProfile->find('first', array('fields' => array('*'), 'conditions' => array('emp_code' => $this->Auth->user('emp_code'))));

        $date = date('Y-m-d');
        $time = strtotime($date);
        $year = date("Y", $time);

        $medical_bill_sum = $this->MedicalBillAmount->find('all', array(
            'fields' => array('sum(bill_amount)'),
            'conditions' => array(
                'YEAR(created_at)' => $year,
                'status !=' => 4,
                'emp_code' => $this->Auth->User('emp_code'))
        ));

        if ($medical_bill_sum[0][0]['sum(bill_amount)'] + $this->data['bill_amt'] > 15000) {
            $this->Session->setFlash('<div class="uk-alert uk-alert-warning" data-uk-alert=""><a href="#" class="uk-alert-close uk-close"></a>Medical Claim can not be greater than 15000 in a calendar year.</div>');
            $this->redirect('/medical/add');
        }

        if (!empty($_FILES['doc_file']['name']) && !empty($emp_code)) {
            if (!empty($newfilenames)) {
                // print_r($this->data);die;
                $medical_value['comp_code'] = $this->Auth->user('comp_code');
                $medical_value['emp_code'] = $this->Auth->user('emp_code');
                $medical_value['emp_name'] = $emp_details['MyProfile']['emp_firstname'];
                $medical_value['bill_amount'] = $this->data['bill_amt'];
                $medical_value['created_at'] = date('Y-m-d');
                $medical_value['uploaded_file'] = implode(",", $newfilenames);
                $medical_value['status'] = 1;
                $medical_value['bill_date'] = date('Y-m-d', strtotime($this->data['bill_date']));
                $medical_value['fy_id'] = $this->Common->findfy_id(date('Y-m-d'));
                $medical_value['loc_type'] = $this->data['loc_type'];
                $this->MedicalBillAmount->create();
                if ($this->MedicalBillAmount->save($medical_value)) {
                    $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert=""><a href="#" class="uk-alert-close uk-close"></a>Medical Claim successfully saved.</div>');
                    $record_id = $this->MedicalBillAmount->getLastInsertID();
                    $this->redirect('/medical/workflow_display/' . $record_id);
                }
                //$this->Session->setFlash('Medical Claim successfully for approval.');
                $record_id = $this->MedicalBillAmount->getLastInsertID();

                $this->redirect('/medical/workflow_display/' . $record_id);
            } else {
                $this->Session->setFlash('<div class="uk-alert uk-alert-warning" data-uk-alert=""><a href="#" class="uk-alert-close uk-close"></a>Medical Claim not submitted.</div>');
                $this->redirect('/users/dashboard');
            }
        } else {
            $this->Session->setFlash('<div class="uk-alert uk-alert-warning" data-uk-alert=""><a href="#" class="uk-alert-close uk-close"></a>Medical Claim not submitted.</div>');

            $this->redirect('/users/dashboard');
        }
    }

    public function workflow_display($id) {
        $this->layout = 'employee-new';
        $this->set('id', $id);
    }

    public function saveinfomation() {

        if (!empty($this->request->data)) {

            $org_id = $this->Auth->User('comp_code');
            $save = array();

            $save['medical_bill_amount_id'] = $this->request->data['medical_id'];
            $save['emp_code'] = $this->Auth->User('emp_code');
            $save['medical_status'] = 2;
            $save['fw_date'] = date('Y-m-d h:i:s');

            if ($this->MedicalWorkflow->save($save)) {
                unset($save);
                $save1 = array();
                $save1['medical_bill_amount_id'] = $this->request->data['medical_id'];
                $save1['emp_code'] = $this->request->data['fwmedical']['emp_code'];
                $this->MedicalWorkflow->create();
                if ($this->MedicalWorkflow->save($save1)) {
                    unset($save1);
                    $this->MedicalBillAmount->updateAll(
                            array('MedicalBillAmount.status' => '2'), array('MedicalBillAmount.id' => $this->request->data['medical_id'])
                    );
                    $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert=""><a href="#" class="uk-alert-close uk-close"></a>Medical Claim forwarded.</div>');
                    $this->redirect(array('controller' => 'Medical', 'action' => 'view'));
                }
            }
        }
    }

    public function view($val) {

        try {
            $this->layout = 'employee-new';
            if(!empty($val))
            {
                $dt=$val;
                $this->set('pen_val',$dt);
            }
            else{
             $dt=$this->Common->findpaginateLevel('15');
            }
  
            $emp_code = $this->Auth->User('emp_code');
            $this->paginate = array(
                'fields' => array('*'),
                'limit' => $dt,
                'order' => 'MedicalBillAmount.id DESC',
                'conditions' => array('MedicalBillAmount.emp_code' => $emp_code)
                    // 'conditions' => array('TravelWfLvl.emp_code' => $emp_code, 'MstEmpExpVoucher.emp_code '=> $emp_code),
                    //'group by' => array('TravelWfLvl.voucher_id')
            );
            $medical_view = $this->paginate('MedicalBillAmount');

            $this->set('MedicalDetails', $medical_view);
        } catch (Exception $e) {
            
        }
//        $medical_view = $this->paginate('MedicalBillAmount', array('emp_code' => $this->Auth->User('emp_code')));
//        $this->set('MedicalDetails', $medical_view);
    }

    public function approval() {
        $this->layout = 'employee-new';
        $org_id = $this->Auth->User('comp_code');
        $emp_code = $this->Auth->User('emp_code');

        $this->paginate = array(
            'fields' => array('*'),
            'limit' => 10,
            'order' => 'MedicalBillAmount.id DESC',
            'joins' => array(
                array(
                    'table' => 'medical_workflow',
                    'alias' => 'medical',
                    'type' => 'inner',
                    'foreignKey' => false,
                    'conditions' => array('medical.medical_bill_amount_id =  MedicalBillAmount.id')
                )
            ),
            'conditions' => array('medical.emp_code' => $emp_code, 'medical.fw_date' => NULL)
        );
        $pending_medical_employee = $this->paginate('MedicalBillAmount');

        $this->set('pending_medical_employee', $pending_medical_employee);
    }

    public function fwmedical($id) {
        $this->layout = 'employee-new';
        $medicalid = base64_decode($id);
        // echo $medicalid; die;
        if ($medicalid) {
            $medical = $this->MedicalWorkflow->find('first', array('fields' => array('id'), 'conditions' => array('medical_bill_amount_id' => $medicalid, 'emp_code' => $this->Auth->User('emp_code'))));
            $this->paginate = array(
                'fields' => array('*'),
                'limit' => 10,
                'order' => array('MedicalBillAmount.id  DESC '),
                'joins' => array(
                    array(
                        'table' => 'medical_workflow',
                        'alias' => 'medical',
                        'type' => 'inner',
                        'foreignKey' => false,
                        'conditions' => array('medical.medical_bill_amount_id =  MedicalBillAmount.id ')
                    )
                ),
                'conditions' => array('medical.emp_code' => $emp_code, 'medical.fw_date' => NULL)
            );
            $pending_medical_employee = $this->paginate('MedicalBillAmount');
            $this->set('medicalstatus', $medical['MedicalWorkflow']['status']);
            $this->set('medical_amt_id', $medicalid);
            $this->set('medicalwfid', $medical['MedicalWorkflow']['id']);
        }
    }

    public function medicalsaveinfo() {
        if (!empty($this->request->data)) {

            //============== Forward==================
            if ($this->request->data['MedicalWorkflow']['type'] == 2) {

                $save = array();
                $save['id'] = $this->request->data['MedicalWorkflow']['id'];
                $save['remark'] = $this->request->data['MedicalWorkflow']['forward_remark'];
                $save['fw_date'] = date('Y-m-d');
                $save['medical_status'] = 2;
                $this->MedicalWorkflow->save($save);
                unset($save);
                $check = $this->MedicalWorkflow->find('first', array('conditions' => array(
                        'id' => $this->request->data['MedicalWorkflow']['id'],
                        'emp_code' => $this->request->data['MedicalWorkflow']['forward_emp_code'])));

                if (empty($check)) {
                    $save1 = array();
                    $save1['medical_bill_amount_id'] = $this->request->data['MedicalWorkflow']['medical_bill_amount_id'];
                    $save1['emp_code'] = $this->request->data['MedicalWorkflow']['forward_emp_code'];
                    $this->MedicalWorkflow->create();
                    $this->MedicalWorkflow->save($save1);
                    unset($save1);
                } else {
                    $remark = $this->request->data['MedicalWorkflow']['forward_remark'];
                    $this->MedicalBillAmount->updateAll(array('status' => null), array(
                        'medical_bill_amount_id' => $this->request->data['MedicalWorkflow']['medical_bill_amount_id'],
                        'emp_code' => $this->request->data['MedicalWorkflow']['forward_emp_code']));
                    $this->MedicalWorkflow->updateAll(array('medical_status' => 2, 'remark' => "'.$remark.'"), array('id' => $check['MedicalWorkflow']['id']));
                }

                if ($this->EmpDetail->getlaststagelevel(1) == 0) {


                    $this->MedicalBillAmount->updateAll(
                            array('MedicalBillAmount.status' => 2), array('MedicalBillAmount.id' => $this->request->data['MedicalWorkflow']['medical_bill_amount_id'])
                    );
                } else {

                    $this->MedicalBillAmount->updateAll(
                            array('MedicalBillAmount.status' => 5), array('MedicalBillAmount.id' => $this->request->data['MedicalBillAmount']['medical_bill_amount_id'])
                    );
                }
                $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert=""><a href="#" class="uk-alert-close uk-close"></a>Medical Claim forwarded.</div>');
                $this->redirect(array('controller' => 'medical', 'action' => 'approval'));
            } else if ($this->request->data['MedicalBillAmount']['type'] == 3) {


                $save1 = array();
                $save = array();
                $save['id'] = $this->request->data['MedicalWorkflow']['id'];
                $save['remark'] = $this->request->data['MedicalWorkflow']['revert_remark'];
                $save['medical_status'] = 3;
                $save['fw_date'] = '';
                $this->MedicalWorkflow->save($save);
                $check = $this->MedicalWorkflow->find('first', array('conditions' => array(
                        'medical_bill_amount_id' => $this->request->data['MedicalWorkflow']['medical_bill_amount_id'],
                        'emp_code' => $this->request->data['MedicalWorkflow']['revert_emp_code'])));
                if (empty($check)) {
                    $save1['medical_bill_amount_id'] = $this->request->data['MedicalWorkflow']['medical_bill_amount_id'];
                    $save1['emp_code'] = $this->request->data['MedicalWorkflow']['revert_emp_code'];
                    $save1['medical_status'] = 2;
                    $this->MedicalWorkflow->save($save1);
                } else {
                    $revert_reason = $this->request->data['MedicalWorkflow']['revert_remark'];
                    $this->MedicalWorkflow->updateAll(array('fw_date' => null, 'remark' => "'.$revert_reason.'"), array('id' => $check['MedicalWorkflow']['id']));
                    $this->MedicalBillAmount->updateAll(array('MedicalBillAmount.status' => '3'), array('MedicalBillAmount.id' => $this->request->data['MedicalBillAmount']['medical_bill_amount_id'])
                    );
                }
                unset($save1);
                unset($save);
                /* $this->ConveyencExpenseDetail->updateAll(
                  array('ConveyencExpenseDetail.conveyence_status' => '3'),
                  array('ConveyencExpenseDetail.voucher_id' => $this->request->data['ConveyenceWorkflow']['voucher_id'])); */
                $this->Session->setFlash('<div class="uk-alert uk-alert-warning" data-uk-alert=""><a href="#" class="uk-alert-close uk-close"></a>Medical  Approval Rejected.</div>');
                $this->redirect(array('controller' => 'medical', 'action' => 'approval'));
            } else if ($this->request->data['MedicalWorkflow']['type'] == 4) {

                $lv_rej = $this->MedicalBillAmount->updateAll(
                        array(
                    'MedicalBillAmount.status' => 4), array(
                    'MedicalBillAmount.id' => $this->request->data['MedicalWorkflow']['medical_bill_amount_id'])
                );
                $remark = $this->request->data['MedicalWorkflow']['reject_remark'];

                if ($lv_rej) {

                    $newsave = array();
                    $newsave['id'] = $this->request->data['MedicalWorkflow']['id'];
                    $newsave['emp_code'] = $this->Auth->User('emp_code');
                    $newsave['remark'] = $this->request->data['MedicalWorkflow']['reject_remark'];
                    $newsave['approval_date'] = date('Y-m-d');
                    $newsave['medical_status'] = 4;
                    $this->MedicalWorkflow->save($newsave);
                    $this->Session->setFlash('<div class="uk-alert uk-alert-warning" data-uk-alert=""><a href="#" class="uk-alert-close uk-close"></a>Medical  Approval Rejected.</div>', false, array('class' => 'flash flash_error'));
                    $this->redirect(array('controller' => 'medical', 'action' => 'approval'));
                }
            } else if ($this->request->data['MedicalWorkflow']['type'] == 5) {
                //die('5');
                //print_r($this->data); die;


                $lv_app = $this->MedicalBillAmount->updateAll(
                        array('MedicalBillAmount.status' => 5), array(
                    'MedicalBillAmount.id' => $this->request->data['MedicalWorkflow']['medical_bill_amount_id'])
                );

                if ($lv_app) {
                    //die('Done ');
                    $newsave = array();
                    $newsave['id'] = $this->request->data['MedicalWorkflow']['id'];
                    $newsave['emp_code'] = $this->Auth->User('emp_code');
                    $newsave['remark'] = $this->request->data['MedicalWorkflow']['approve_remark'];
                    $newsave['approval_date'] = date('Y-m-d');
                    $newsave['medical_status'] = 5;

                    $done1 = $this->MedicalWorkflow->save($newsave);
                    // print_r($done1); die;

                    /* 'emp_code' => $val['ConveyencExpenseDetail']['emp_code'],
                      'voucher_id' => $val['ConveyencExpenseDetail']['voucher_id']
                      )); */
                }

                $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert=""><a href="#" class="uk-alert-close uk-close"></a>Medical Approved Successfully.</div>', false, array('class' => 'flash flash_error'));
                $this->redirect(array('controller' => 'medical', 'action' => 'approval'));
            }
        }
        $this->redirect(array('controller' => 'medical', 'action' => 'approval'));
    }

    function medicaldetail() {
        try {
            $id = $this->params['pass']['0'];
            if (!empty($id)) {
                $ldetails = $this->MedicalBillAmount->find('first', array(
                    'fields' => array('*'),
                    'conditions' => array('id' => $id, 'emp_code' => $this->Auth->User('emp_code'))
                ));

                $this->set('ldetails', $ldetails);
                $this->layout = '';
                $this->render('medicaldetail');
            }
        } catch (Exception $e) {
            
        }
    }

    function medicaldetailapproval() {
        try {
            $id = $this->params['pass']['0'];
            if (!empty($id)) {
                $ldetails = $this->MedicalBillAmount->find('first', array(
                    'fields' => array('*'),
                    'conditions' => array('id' => $id)
                ));

                $this->set('ldetails', $ldetails);
                $this->layout = '';
                $this->render('medicaldetail');
            }
        } catch (Exception $e) {
            
        }
    }

    public function employee_medical_report() {
        //Configure::write('debug',2);
        $this->layout = 'employee-new';
        $auth = $this->Session->read('Auth');
        $orgID = $auth['MyProfile']['comp_code'];
        $empID = $auth['MyProfile']['emp_code'];

        $flag = '';
        if (isset($this->request->data['submit']) && $this->request->data['submit'] != '') {

            if (($this->request->data['medical_status'] == '0' || $this->request->data['medical_status'] == '') && $this->request->data['from_date'] == '' && $this->request->data['end_date'] == '') {
                $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert="">
                            <a href="#" class="uk-alert-close uk-close"></a>Please Enter Atleast One Value !!!!</div>');
                $this->redirect('employee_medical_report');
            }

            if ($this->request->data['medical_status'] != '0' && $this->request->data['medical_status'] != '') {
                $ORconditions['status'] = $this->request->data['medical_status'];

                $vouch_status = $this->request->data['medical_status'];
            }

            if ($this->request->data['from_date'] != '' && $this->request->data['end_date'] != '') {
                $from_date = date('Y-m-d', strtotime($this->request->data['from_date']));
                $end_date = date('Y-m-d', strtotime($this->request->data['end_date']));
                $ORconditions['created_at between ? and ?'] = array($from_date, $end_date);
                //$ORconditions['ConveyencExpenseDetail.claim_date <='] = $end_date;
            }

            $ORconditions['comp_code'] = $orgID;
            $ORconditions['emp_code'] = $empID;
            $conditions = array($ORconditions);

            $VoucherDetails = $this->MedicalBillAmount->find('all', array(
                'fields' => array('*'),
                //'limit' => 10,
                //'order' => array('DtTravelVoucher.voucher_id  DESC'),
                'conditions' => $conditions
                    //'order'=>array('LvMstId.id desc')
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
        $voucherStatus = array('0' => '---Select---', '2' => 'Pending', '5' => 'Approved', '4' => 'Rejected');

        $this->set(compact('voucherStatus'));
    }

    public function generate_emp_medical_report_pdf($from_date = null, $end_date = null, $voucher_status = null) {
        //Configure::write('debug',2);
        $this->layout = 'employee-new';
        $auth = $this->Session->read('Auth');
        $orgID = $auth['MyProfile']['comp_code'];
        $empID = $auth['MyProfile']['emp_code'];


        if ($from_date != 'null' && $end_date != 'null') {
            $ORconditions['created_at between ? and ?'] = array($from_date, $end_date);
        }

        if ($voucher_status != 'null') {
            $ORconditions['status'] = $voucher_status;
        }

        $ORconditions['comp_code'] = $orgID;
        $ORconditions['emp_code'] = $empID;
        $conditions = array($ORconditions);

        $VoucherDetails = $this->MedicalBillAmount->find('all', array(
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

}
