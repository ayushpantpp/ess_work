<?php

class ConveyenceExpensesController extends AppController {

    var $uses = array('ConveyencExpenseDetail', 'MstWheelerType', 'ConveyenceWorkflow', 'MstVehicalMaster', 'MstEmpExpVoucher', 'DtExpVoucher', 'WfPaginateLvl');
    var $components = array('Session', 'Cookie', 'RequestHandler', 'Auth', 'EmpDetail', 'Common');
    var $helpers = array('Html', 'Js', 'Form', 'Session', 'Userdetail');

    const APPLICATION_ID = 3;

    function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow();
        $currentUser = $this->checkUser();
        $this->set('appId', 3);
    }

    function index() {
        try {
            
        } catch (Exception $e) {
            
        }
    }

    function deleteConveyenceDetails($conveyence_id) {
        $conveyence_id = base64_decode($conveyence_id);
        $ld = $this->ConveyencExpenseDetail->find('list', array(
            'conditions' => array(
                'voucher_id' => $conveyence_id
            )
        ));
        foreach ($ld as $key => $value) {
            $this->ConveyencExpenseDetail->delete($value);
        }
        $wf = $this->ConveyenceWorkflow->find('list', array(
            'conditions' => array(
                'voucher_id' => $conveyence_id
            )
        ));
        foreach ($wf as $key => $value) {
            $this->ConveyenceWorkflow->delete($value);
        }
        $ml = $this->MstEmpExpVoucher->find('list', array(
            'conditions' => array(
                'voucher_id' => $conveyence_id, 'expense_type' => 'C'
            )
        ));
        foreach ($ml as $key => $value) {
            $this->MstEmpExpVoucher->delete($value);
        }
        $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                            <a href="#" class="uk-alert-close uk-close"></a>Conveyence  Deleted Sucessfully !!!</div>');
        $this->redirect('view/');
    }

    /* view of the conveyance Voucher */

    public function view($val) {
        $this->layout = 'employee-new';
        $auth = $this->Session->read('Auth');
        $emp_code = $auth['MyProfile']['emp_code'];
        if (!empty($val)) {

            $dt = $val;
            $this->set('pen_val', $dt);
        } else {
            $dt = $this->Common->findpaginateLevel('3');
        }
        $this->paginate = array(
            'fields' => array('ExpVoucher.total_exp', 'ExpVoucher.id', 'ExpVoucher.voucher_id', 'ExpVoucher.emp_code',
                'ExpVoucher.claim_date', 'ExpVoucher.travel_mode', 'ExpVoucher.wheeler_type', 'ExpVoucher.from_place', 'ExpVoucher.to_place', 'ExpVoucher.miscl_exp_desc',
                'ExpVoucher.miscl_exp_desc', 'ExpVoucher.travel_exp', 'ExpVoucher.distance', 'ExpVoucher.conveyence_status', 'ExpVoucher.created_on',
                'MstEmpExpVoucher.expense_type', 'MstEmpExpVoucher.comp_code',
                'MstEmpExpVoucher.dept_code'),
            //'limit' => $dt,
            'order' => 'ExpVoucher.id desc',
            'joins' => array
                (
                array(
                    'table' => 'dt_exp_voucher',
                    'alias' => 'ExpVoucher',
                    'type' => 'INNER',
                    'foreignKey' => FALSE,
                    'conditions' => array('MstEmpExpVoucher.voucher_id=ExpVoucher.voucher_id'),
                )
            ),
            'group' => 'ExpVoucher.voucher_id',
            'conditions' => array('MstEmpExpVoucher.emp_code' => $emp_code)
        );
        $data = $this->paginate('MstEmpExpVoucher');
        $this->set('searchdetail', $data);
    }

    public function getInfo() {
        try {
            $id = $this->params['pass']['0'];
            if (!empty($id)) {
                $cdetails = $this->ConveyencExpenseDetail->find('all', array(
                    'fields' => array('*'),
                    'conditions' => array('ConveyencExpenseDetail.voucher_id' => $id, 'ConveyencExpenseDetail.emp_code' => $this->Auth->User('emp_code'))));
                $this->set('cdetails', $cdetails);
                $this->layout = '';
                $this->render('conveyancedetails');
            }
        } catch (Exception $e) {
            
        }
    }

    public function get_convey_Info() {
        try {
            $id = $this->params['pass']['0'];
            if (!empty($id)) {
                $cdetails = $this->ConveyencExpenseDetail->find('all', array(
                    'fields' => array('*'),
                    'conditions' => array('ConveyencExpenseDetail.voucher_id' => $id)));
                $this->set('cdetails', $cdetails);
                $this->layout = '';
                $this->render('conveyancedetails');
            }
        } catch (Exception $e) {
            
        }
    }

    public function add() {
        $this->layout = 'employee-new';
        $auth = $this->Session->read('Auth');
        $val_arr = array();
        $convenyence_detail = $this->MstWheelerType->find('all', array(
            'fields' => array('vehical', 'price')));
        $org_id = $this->Auth->User('comp_code');
        $get_days_chk = $this->EmpDetail->checkApplicationDelay('3', $org_id);

        $this->set('convenyence_detail', $convenyence_detail);

        /* $count=$this->ConveyencExpenseDetail->find('all',
          array('conditions'=>array('claim_date'=>)));
          print_r($count);die; */

        for ($i = 0; $i < count($this->request->data['ConveyenceExpenses']['claimdate']); $i++) {
            $claimDate = date('Y-m-d', strtotime($this->request->data['ConveyenceExpenses']['claimdate'][$i]));
            if ($claimDate > date('Y-m-d')) {
                $this->Session->setFlash('<div class="uk-alert uk-alert-warning" data-uk-alert="">
                            <a href="#" class="uk-alert-close uk-close"></a>Conveyence Voucher cannot be applied in advance !!!</div>');
                $this->redirect('/conveyence_expenses/add');
            }
            echo date('Y-m-d', strtotime('today - ' . $get_days_chk . 'days'));
            if ($claimDate <= date('Y-m-d', strtotime('today - ' . $get_days_chk . 'days'))) {
                $this->Session->setFlash('<div class="uk-alert uk-alert-warning" data-uk-alert="">
                            <a href="#" class="uk-alert-close uk-close"></a>Conveyence Voucher cannot be applied in after ' . $get_days_chk . 'Days !!!</div>');
                $this->redirect('/conveyence_expenses/add');
            }
        }
        $auth = $this->Session->read('Auth');
        if (!empty($this->data)) {
            if (isset($this->request->data['draft'])) {
                $conveyence_status = '7';
            } else {
                $conveyence_status = '8';
            }
            $record_id = array();
            $count = $this->request->data['ConveyenceExpenses']['rowCount'];
            $val_arr['emp_code'] = $this->Auth->User('emp_code');
            $val_arr['expense_type'] = 'C';
            $val_arr['voucher_date'] = date('Y-m-d');
            $val_arr['comp_code'] = $this->Auth->User('comp_code');
            $val_arr['dept_code'] = $auth['MyProfile']['dept_code'];
            $this->MstEmpExpVoucher->create();
            $this->MstEmpExpVoucher->set($val_arr);
            if ($this->MstEmpExpVoucher->save($val_arr)) {
                $record_id = $this->MstEmpExpVoucher->getLastInsertID();

                for ($i = 0; $i < $count; $i++) {


                    $val = array();

                    $val['voucher_id'] = $this->MstEmpExpVoucher->getLastInsertID();
                    $val['emp_code'] = $this->Auth->User('emp_code');
                    $val['org_id'] = $this->Auth->User('comp_code');
                    $val['dept_code'] = $auth['MyProfile']['dept_code'];
                    $val['claim_date'] = date('Y-m-d', strtotime($this->request->data['ConveyenceExpenses']['claimdate'][$i]));
                    $val['travel_mode'] = $this->request->data['ConveyenceExpenses']['travelmode'][$i];
                    $val['wheeler_type'] = $this->request->data['ConveyenceExpenses']['wheeler_type'][$i];
                    $val['from_place'] = $this->request->data['ConveyenceExpenses']['from_place'][$i];
                    $val['to_place'] = $this->request->data['ConveyenceExpenses']['to_place'][$i];
                    $val['miscl_exp'] = $this->request->data['ConveyenceExpenses']['misc_exp'][$i];
                    $val['miscl_exp_desc'] = $this->request->data['ConveyenceExpenses']['misc_exp_desc'][$i];
                    $val['distance'] = $this->request->data['ConveyenceExpenses']['distance'][$i];
                    $val['travel_exp'] = $this->request->data['ConveyenceExpenses']['travel_exp'][$i];
                    $val['total_exp'] = $this->request->data['ConveyenceExpenses']['total_exp'][$i];
                    $val['emp_exp'] = $this->request->data['ConveyenceExpenses']['total_exp'][$i];
                    $val['conveyence_status'] = $conveyence_status;
                    $claim_date_count = $this->ConveyencExpenseDetail->find('count', array('conditions' => array('claim_date' => $val['claim_date'], 'emp_code' => $val['emp_code'])));



                    if ($claim_date_count > 0) {
                        $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert="">
                            <a href="#" class="uk-alert-close uk-close"></a> Claim Date ' . date('d-m-y', strtotime($val['claim_date'])) . ' Already Exist !!!</div>');
                        $this->redirect('/conveyence_expenses/add');
                    }
                    $this->ConveyencExpenseDetail->create();
                    $this->ConveyencExpenseDetail->set($val);
                    $this->ConveyencExpenseDetail->save($val);
                    unset($val);
                }
            }

            $recordID = $record_id;
            if (isset($this->request->data['draft'])) {
                $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                            <a href="#" class="uk-alert-close uk-close"></a>Voucher Parked successfully !!!</div>');
                $this->redirect('/conveyence_expenses/view');
            } else {
                $mail_data['event_id'] = $conveyence_status;
                $mail_data['org_id'] = $auth['User']['comp_code'];
                $mail_data['to_email'] = $this->Common->getEmpEmailId($auth['MyProfile']['manager_code']);
                $mail_data['to_name'] = $this->Common->findEmpName($auth['MyProfile']['manager_code']);
                $mail_data['application_id'] = self::APPLICATION_ID;
                $mail_data['from_name'] = $auth['MyProfile']['emp_full_name'];
                $mail_data['from_email'] = $auth['User']['email'];
                $mail_data['subject'] =  'Conveyence Voucher Applied by - ' . $auth['MyProfile']['emp_full_name'];
                $message = $this->sendApplicantsMail($mail_data);
                $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                            <a href="#" class="uk-alert-close uk-close"></a>Voucher Posted successfully !!!</div>');
                $this->redirect('/conveyence_expenses/workflow_display/' . $recordID);
            }
        }
        $org_id = $this->Auth->User('comp_code');
        $vehical = $this->MstVehicalMaster->find('list', array(
            'fields' => array('id', 'vehical_name'),
            'conditions' => array('org_id' => $this->Auth->User('comp_code'))
        ));

        $this->set('list', $vehical);
    }

    public function getVehicalRate($claimdate = null, $travelmode = null, $wheeler_type = null, $distance = null) {
        $auth = $this->Session->read('Auth');
        $comp_code = $auth['User']['comp_code'];
        if ($claimdate != '' && $travelmode != '' && $wheeler_type != '') {
            $claim_Date = date('Y-m-d', strtotime($claimdate));
            $vehicalRate = $this->MstWheelerType->query("SELECT a.price FROM mst_wheeler_type AS a 
            WHERE effected_date = (SELECT MAX(effected_date) FROM mst_wheeler_type AS b 
            WHERE a.org_id = b.org_id AND a.vehical = b.vehical AND a.wheeler_type = b.wheeler_type  and b.effected_date<='" . $claim_Date . "' ) and a.org_id='" . $comp_code . "' and a.vehical='" . $travelmode . "' and a.wheeler_type='" . $wheeler_type . "'");
            $vihecalPrice = $vehicalRate[0]['a']['price'];

            echo $total = $vihecalPrice * $distance;
        } else {
            echo "NA";
        }
        exit;
    }

    public function post() {
        $this->layout = 'employee-new';
        $val_arr = array();
        $convenyence_detail = $this->MstWheelerType->find('all', array(
            'fields' => array('name', 'price')));
        $this->set('convenyence_detail', $convenyence_detail);
        $org_id = $this->Auth->User('comp_code');
        $get_days_chk = $this->EmpDetail->checkApplicationDelay('3', $org_id);

        for ($i = 0; $i < count($this->request->data['description']); $i++) {
            $claimDate = date('Y-m-d', strtotime($this->request->data['ConveyenceExpenses']['claimdate'][$i]));
            if ($claimDate > date('Y-m-d')) {
                $this->Session->setFlash('<div class="uk-alert uk-alert-warning" data-uk-alert="">
                            <a href="#" class="uk-alert-close uk-close"></a>Conveyence Voucher cannot be applied in advance !!!</div>');
                $this->redirect('/conveyence_expenses/add');
            }
            if ($claimDate <= date('Y-m-d', strtotime('today - ' . $get_days_chk . 'days'))) {
                $this->Session->setFlash('<div class="uk-alert uk-alert-warning" data-uk-alert="">
                            <a href="#" class="uk-alert-close uk-close"></a>Conveyence Voucher cannot be applied in after ' . $get_days_chk . ' Days !!!</div>');
                $this->redirect('/conveyence_expenses/add');
            }
        }
        if (!empty($this->data)) {
            $val_arr['emp_code'] = $this->Auth->User('emp_code');
            $val_arr['expense_type'] = 'C';
            $val_arr['voucher_date'] = date('Y-m-d');
            $val_arr['comp_code'] = $this->Auth->User('comp_code');
            $val_arr['dept_code'] = $this->request->data['ConveyenceExpense']['Emp_department'];
            if ($this->MstEmpExpVoucher->save($val_arr)) {
                for ($i = 1; $i <= count($this->request->data['description']); $i++) {
                    $val = array();
                    $val['voucher_id'] = $this->MstEmpExpVoucher->getLastInsertID();
                    $val['emp_code'] = $this->Auth->User('emp_code');
                    $val['claim_amount'] = $this->request->data['claim_amt'][$i];
                    $val['description'] = $this->request->data['description'][$i];
                    $val['distance'] = $this->request->data['distance'][$i];
                    $val['claim_date'] = date('Y-m-d', strtotime($this->request->data['Claimdate'][$i]));
                    $val['mode'] = $this->request->data['Travel_mode'][$i];
                    $val['voucher_date'] = date('Y-m-d');
                    $val['conveyence_status'] = '8';
                    $this->ConveyencExpenseDetail->create();
                    $this->ConveyencExpenseDetail->set($val);
                    $this->ConveyencExpenseDetail->save($val);
                    unset($val);
                }
                $record_id = $this->MstEmpExpVoucher->getLastInsertID();
                $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                            <a href="#" class="uk-alert-close uk-close"></a>Voucher Posted successfully !!!</div>');
                $this->redirect('/conveyence_expenses/workflow_display/' . $record_id);
            }
        }
    }

    function workflow_display($record_id = null) {
        $this->layout = 'employee-new';
        $this->set('conveyence', $record_id);
    }

    public function saveinfomation() {
        if (!empty($this->request->data)) {

            if (isset($this->request->data['ConveyenceWorkflow']['fields']) && $this->request->data['ConveyenceWorkflow']['fields'] == "array") {
                echo count($this->request->data['ConveyenceWorkflow']['voucher_id']);

                for ($i = 0; $i < count($this->request->data['ConveyenceWorkflow']['voucher_id']); $i++) {
                    $save = array();
                    $save['voucher_id'] = $this->request->data['ConveyenceWorkflow']['voucher_id'][$i];
                    $save['emp_code'] = $_SESSION['Auth']['MyProfile']['emp_code'];
                    $save['status'] = 2;
                    $user_details = $this->EmpDetail->getemployeeinfomation($this->Auth->User('emp_code'));
                    $save['fw_date'] = date('Y-m-d h:i:s');
                    if ($this->ConveyenceWorkflow->save($save)) {
                        unset($save);
                        $save1 = array();
                        $save1['voucher_id'] = $this->request->data['ConveyenceWorkflow']['voucher_id'][$i];
                        $save1['emp_code'] = $this->request->data['ConveyenceWorkflow']['emp_code'];
                        $save1['status'] = null;
                        $this->ConveyenceWorkflow->create();
                        if ($this->ConveyenceWorkflow->save($save1)) {
                            unset($save1);
                            //update values if it is not new
                            $this->ConveyencExpenseDetail->updateAll(
                                    array('ConveyencExpenseDetail.conveyence_status' => '2'), array('ConveyencExpenseDetail.voucher_id' => $this->request->data['ConveyenceWorkflow']['voucher_id'][$i])
                            );
                        }
                    }
                }
                $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                            <a href="#" class="uk-alert-close uk-close"></a>Voucher forwarded. !!!</div>');
                $this->redirect(array('controller' => 'conveyence_expenses', 'action' => 'view'));
            } else {
                $save = array();
                $save['voucher_id'] = $this->request->data['ConveyenceWorkflow']['conveyencevoucher_id'];
                $save['emp_code'] = $_SESSION['Auth']['MyProfile']['emp_code'];
                $user_details = $this->EmpDetail->getemployeeinfomation($this->Auth->User('emp_code'));
                $save['fw_date'] = date('Y-m-d h:i:s');
                $save['status'] = 2;

                if ($this->ConveyenceWorkflow->save($save)) {
                    unset($save);
                    $save1 = array();
                    $save1['voucher_id'] = $this->request->data['ConveyenceWorkflow']['conveyencevoucher_id'];
                    $save1['emp_code'] = $this->request->data['ConveyenceWorkflow']['emp_code'];
                    $save1['status'] = null;
                    $this->ConveyenceWorkflow->create();
                    if ($this->ConveyenceWorkflow->save($save1)) {
                        unset($save1);
                        //update values if it is not new
                        $this->ConveyencExpenseDetail->updateAll(
                                array('ConveyencExpenseDetail.conveyence_status' => '2'), array('ConveyencExpenseDetail.voucher_id' => $this->request->data['ConveyenceWorkflow']['conveyencevoucher_id'])
                        );
                        $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                            <a href="#" class="uk-alert-close uk-close"></a>Voucher forward. !!!</div>');
                        $this->redirect(array('controller' => 'conveyence_expenses', 'action' => 'view'));
                    } else {
                        $this->Session->setFlash('<div class="uk-alert uk-alert-primary" data-uk-alert="">
                            <a href="#" class="uk-alert-close uk-close"></a>Voucher is not forward. !!!</div>');
                        $this->redirect(array('controller' => 'conveyence_expenses', 'action' => 'view'));
                    }
                }
            }
        }
        $this->redirect(array('controller' => 'conveyence_expenses', 'action' => 'view'));
    }

    function approval($val) {
        $this->layout = 'employee-new';
        $emp_code = $_SESSION['Auth']['MyProfile']['emp_code'];
        if (!empty($val)) {
            $dt = $val;
            $this->set('pen_val', $dt);
        } else {
            $dt = $this->Common->findpaginateLevel('3');
        }
        $this->paginate = array(
            'fields' => array('*'),
            //'limit' => $dt,
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
            'conditions' => array('ConveyenceWorkflow.emp_code' => $emp_code,
                'OR' => array(
                    array('ConveyenceWorkflow.status' => null),
                    array('ConveyenceWorkflow.status' => 5),
                )),
            'group' => array('ConveyencExpenseDetail.voucher_id')
        );
        //, 'MstEmpConveyence.emp_code != ' . $emp_code
        $pending_conveyence_employee = $this->paginate('ConveyencExpenseDetail'); //echo'<pre>';print_r($pending_conveyence_employee);
        $this->set('pending_conveyence_employee', $pending_conveyence_employee);
    }

    function editconveyence($voucherid = '') {
        $this->layout = 'employee-new';
        $voucherid_app = base64_decode($voucherid);
        $this->paginate = array(
            'fields' => array('*'),
            'joins' => array(
                array(
                    'table' => 'mst_emp_exp_voucher',
                    'alias' => 'MstEmpConveyence',
                    'type' => 'inner',
                    'foreignKey' => false,
                    'conditions' => array('ConveyencExpenseDetail.voucher_id = MstEmpConveyence.voucher_id')
                )
            ),
            'conditions' => array('ConveyencExpenseDetail.voucher_id' => $voucherid_app)
        );
        $empconveyencedetail = $this->paginate('ConveyencExpenseDetail');

        $this->set('empconveyencedetail', $empconveyencedetail);

        $app_emp_code = $empconveyencedetail[0]['ConveyencExpenseDetail']['emp_code'];
        $this->set('emp_code', $app_emp_code);
        if (!empty($this->request->data)) {
            $this->redirect('/conveyence_expenses/conveyencewf/' . $voucherid_app);
        }
    }

    function conveyencewf($conveyenceno = '') {
        $this->layout = 'employee-new';
        if ($this->request->data) {
            $cnt = count($this->request->data['ConveyenceWorkflow_amount']['id']);
            for ($i = 0; $i < $cnt; $i++) {
                $cv_update = $this->ConveyencExpenseDetail->updateAll(
                        array('total_exp' => $this->request->data['ConveyenceWorkflow_amount']['claim_amount'][$i]), array('emp_code' => $this->request->data['ConveyenceWorkflow_amount']['emp_code'][$i],
                    'id' => $this->request->data['ConveyenceWorkflow_amount']['id'][$i]));
            }
            if (empty($conveyenceno))
                $conveyenceno = $this->request->data['ConveyenceWorkflow']['voucher_id'];
            else
                $conveyenceno = $conveyenceno;

            $this->set('conveyence', $conveyenceno);
            $this->set('emp_code', $this->request->data['ConveyenceWorkflow_amount']['emp_code']);
            $check = $this->ConveyencExpenseDetail->find('first', array('conditions' => array('voucher_id' => $conveyenceno)));
            $this->set('conveyenceStatus', $check['ConveyencExpenseDetail']['conveyence_status']);

            $ConveyenceWorkflowid = $this->ConveyenceWorkflow->find('first', array('fields' => array('MAX(id) AS id'),
                'conditions' => array('ConveyenceWorkflow.emp_code' => $this->Auth->User('emp_code'),
                    'ConveyenceWorkflow.voucher_id' => $conveyenceno)));
            $this->set('ConveyenceWorkflowid', $ConveyenceWorkflowid);
            //$ckcount = $this->ConveyenceWorkflow->checkstatus($this->Auth->User('emp_code'), $conveyenceno);
            if ($ckcount > 0) {
                // $this->redirect(array('controller' => 'conveyence_expenses', 'action' => 'approval'));
            }
        }
    }

    function rejectconveyence() {
        $comp = $this->params['data']['comp_code'];
        $cdate = $this->params['data']['cdate'];
        //$edDate = $this->params['data']['end_date'];
        $conveyence_no = $this->params['data']['conveyence_no'];
        $rejectreson = $this->params['data']['rejectreson'];

        $save = array();
        $save['conveyence_status'] = '4';
        $save['voucher_id'] = $conveyence_no;
        $cv_rej = $this->ConveyencExpenseDetail->updateAll(
                array('ConveyencExpenseDetail.conveyence_status' => '4'), array('ConveyencExpenseDetail.voucher_id' => $conveyence_no)
        );
        if ($cv_rej) {
            $newsave = array();
            $newsave['id'] = $conveyence_no;
            $newsave['emp_code'] = $this->Auth->User('emp_code');
            $newsave['remark'] = $rejectreson;
            $newsave['approval_date'] = date('Y-m-d');
            $newsave['status'] = '4';
            $this->ConveyenceWorkflow->save($newsave);

            $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                            <a href="#" class="uk-alert-close uk-close"></a>Conveyenc Voucher Rejected Successfully</div>', false, array('class' => 'flash flash_error'));
            $this->redirect(array('controller' => 'conveyence_expenses', 'action' => 'approval'));
        }
    }

    public function getconveyencerate() {
        $wheeler_type = $this->MstWheelerType->find('all', array('fields' => array('MstWheelerType.name', 'MstWheelerType.price')));
        //$this->set('wheeler',$wheeler_type);
        echo json_encode($wheeler_type);
        die;
    }

    public function addnew() {
        
    }

    function conveyencewfsaveinfo() {
        // Configure::write('debug',2);
        //print_r($this->request->data); die('khkj');
        if (!empty($this->request->data)) {
            //============== Forward==================
            if ($this->request->data['ConveyenceWorkflow']['type'] == 2) {
                //die('here');
                $save = array();
                //pr($this->request->data);die;
                $save['id'] = $this->request->data['ConveyenceWorkflow']['id'];
                $save['remark'] = $this->request->data['ConveyenceWorkflow']['forward_remark'];
                $save['fw_date'] = date('Y-m-d');
                $save['status'] = 2;
                $this->ConveyenceWorkflow->save($save);
                unset($save);
                $check = $this->ConveyenceWorkflow->find('first', array('conditions' => array(
                        'voucher_id' => $this->request->data['ConveyenceWorkflow']['voucher_id'],
                        'emp_code' => $this->request->data['ConveyenceWorkflow']['forward_emp_code'])));
                if (empty($check)) {
                    $save1 = array();
                    $save1['voucher_id'] = $this->request->data['ConveyenceWorkflow']['voucher_id'];
                    $save1['emp_code'] = $this->request->data['ConveyenceWorkflow']['forward_emp_code'];
                    $save1['status'] = 2;
                    $this->ConveyenceWorkflow->create();
                    $this->ConveyenceWorkflow->save($save1);
                    unset($save1);
                } else {
                    $this->ConveyenceWorkflow->updateAll(array('status' => 2), array(
                        'voucher_id' => $this->request->data['ConveyenceWorkflow']['voucher_id'],
                        'emp_code' => $this->request->data['ConveyenceWorkflow']['forward_emp_code']));
                }
                $remark = $this->request->data['ConveyenceWorkflow']['forward_remark'];
                if ($this->EmpDetail->getlaststagelevel(1) == 0) {

                    $this->ConveyencExpenseDetail->updateAll(
                            array('ConveyencExpenseDetail.conveyence_status' => 2, 'remark' => "'$remark'"), array('ConveyencExpenseDetail.voucher_id' => $this->request->data['ConveyenceWorkflow']['voucher_id'])
                    );
                } else {
                    $this->ConveyencExpenseDetail->updateAll(
                            array('ConveyencExpenseDetail.conveyence_status' => 5, 'remark' => "'$remark'"), array('ConveyencExpenseDetail.voucher_id' => $this->request->data['ConveyenceWorkflow']['voucher_id'])
                    );
                }
                $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                            <a href="#" class="uk-alert-close uk-close"></a>Conveyence forward. !!!</div>');
                $this->redirect(array('controller' => 'conveyence_expenses', 'action' => 'approval'));
            } else if ($this->request->data['ConveyenceWorkflow']['type'] == 3) {
                $save1 = array();
                $save = array();
                $save['id'] = $this->request->data['ConveyenceWorkflow']['id'];
                $save['remark'] = $this->request->data['ConveyenceWorkflow']['revert_remark'];
                $save['status'] = 3;
                $save['fw_date'] = '';
                $this->ConveyenceWorkflow->save($save);
                $check = $this->ConveyenceWorkflow->find('first', array('conditions' => array(
                        'voucher_id' => $this->request->data['ConveyenceWorkflow']['voucher_id'],
                        'emp_code' => $this->request->data['ConveyenceWorkflow']['revert_emp_code'])));
                if (empty($check)) {
                    $save1['voucher_id'] = $this->request->data['ConveyenceWorkflow']['voucher_id'];
                    $save1['emp_code'] = $this->request->data['ConveyenceWorkflow']['revert_emp_code'];
                    $this->ConveyenceWorkflow->save($save1);
                } else {
                    $this->ConveyenceWorkflow->updateAll(array('fw_date' => null), array('id' => $check['ConveyenceWorkflow']['id']));
                }
                unset($save1);
                unset($save);
                $remark = $this->request->data['ConveyenceWorkflow']['revert_remark'];
                $this->ConveyencExpenseDetail->updateAll(
                        array('ConveyencExpenseDetail.conveyence_status' => 3, 'remark' => "'$remark'"), array('ConveyencExpenseDetail.voucher_id' => $this->request->data['ConveyenceWorkflow']['voucher_id'])
                );
                /* $this->ConveyencExpenseDetail->updateAll(
                  array('ConveyencExpenseDetail.conveyence_status' => '3'),
                  array('ConveyencExpenseDetail.voucher_id' => $this->request->data['ConveyenceWorkflow']['voucher_id'])); */
                $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                            <a href="#" class="uk-alert-close uk-close"></a>Conveyence Reverted.!!!!</div>');
                $this->redirect(array('controller' => 'conveyence_expenses', 'action' => 'approval'));
            } else if ($this->request->data['ConveyenceWorkflow']['type'] == 4) {
                $remark = $this->request->data['ConveyenceWorkflow']['reject_remark'];
                $lv_rej = $this->ConveyencExpenseDetail->updateAll(
                        array(
                    'ConveyencExpenseDetail.conveyence_status' => 4, 'ConveyencExpenseDetail.remark' => "'$remark'"), array(
                    'ConveyencExpenseDetail.voucher_id' => $this->request->data['ConveyenceWorkflow']['voucher_id'])
                );

                if ($lv_rej) {
                    //unset($save);
                    $newsave = array();
                    $newsave['id'] = $this->request->data['ConveyenceWorkflow']['id'];
                    $newsave['voucher_id'] = $this->request->data['ConveyenceWorkflow']['voucher_id'];
                    $newsave['emp_code'] = $this->Auth->User('emp_code');
                    $newsave['remark'] = $this->request->data['ConveyenceWorkflow']['reject_remark'];
                    $newsave['approval_date'] = date('Y-m-d');
                    $newsave['status'] = 4;
                    $this->ConveyenceWorkflow->save($newsave);
                    $remark = $this->request->data['ConveyenceWorkflow']['reject_remark'];

                    $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                            <a href="#" class="uk-alert-close uk-close"></a>Conveyence Rejected Successfully</div>', false, array('class' => 'flash flash_error'));
                    $this->redirect(array('controller' => 'conveyence_expenses', 'action' => 'approval'));
                }
            } else if ($this->request->data['ConveyenceWorkflow']['type'] == 6) {
                $save = array();
                $save['id'] = $this->request->data['ConveyenceWorkflow']['id'];
                $save['remark'] = $this->request->data['ConveyenceWorkflow']['hr_forward_remark'];
                $save['fw_date'] = date('Y-m-d');
                $save['status'] = 2;

                $this->ConveyenceWorkflow->save($save);
                unset($save);
                $lv_app = $this->ConveyencExpenseDetail->updateAll(
                        array('ConveyencExpenseDetail.conveyence_status' => '6'), array('ConveyencExpenseDetail.voucher_id' => $this->request->data['ConveyenceWorkflow']['voucher_id'])
                );

                //Forward to HR				
                $newsave = array();
                $newsave['voucher_id'] = $this->request->data['ConveyenceWorkflow']['voucher_id'];
                $newsave['emp_code'] = $this->request->data['ConveyenceWorkflow']['hr_emp_code'];
                $newsave['status'] = null;
                $this->ConveyenceWorkflow->create();
                $this->ConveyenceWorkflow->save($newsave);
                $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                            <a href="#" class="uk-alert-close uk-close"></a>Conveyance Forwarded to Accounts !!!</div>', false, array('class' => 'flash flash_error'));
                $this->redirect(array('controller' => 'conveyence_expenses', 'action' => 'approval'));
            } else if ($this->request->data['ConveyenceWorkflow']['type'] == 5) {
                $mstLeave = $this->MstEmpExpVoucher->find('first', array('conditions' => array('voucher_id' => $this->request->data['ConveyenceWorkflow']['voucher_id'])));
                $tempLeave = array();
                $remark = $this->data['ConveyenceWorkflow']['approve_remark'];
                $lv_app = $this->ConveyencExpenseDetail->updateAll(
                        array(
                    'ConveyencExpenseDetail.conveyence_status' => 5, 'ConveyencExpenseDetail.remark' => "'$remark'"), array(
                    'ConveyencExpenseDetail.voucher_id' => $this->request->data['ConveyenceWorkflow']['voucher_id'])
                );
                if ($lv_app) {
                    $newsave = array();
                    $newsave['id'] = $this->request->data['ConveyenceWorkflow']['id'];
                    $newsave['voucher_id'] = $this->request->data['ConveyenceWorkflow']['voucher_id'];
                    $newsave['emp_code'] = $this->Auth->User('emp_code');
                    $newsave['remark'] = $this->request->data['ConveyenceWorkflow']['approve_remark'];
                    $newsave['approval_date'] = date('Y-m-d');
                    $newsave['status'] = 5;
                    $this->ConveyenceWorkflow->save($newsave);
                    $this->ConveyenceWorkflow->updateAll(array('status' => 5), array('voucher_id' => $this->request->data['ConveyenceWorkflow']['voucher_id']));
                }

                $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                            <a href="#" class="uk-alert-close uk-close"></a>Conveyence Approved Successfully !!!</div>', false, array('class' => 'flash flash_error'));
                $this->redirect(array('controller' => 'conveyence_expenses', 'action' => 'approval'));
            }
        }
        $this->redirect(array('controller' => 'conveyence_expenses', 'action' => 'approval'));
    }

    function previousConveyence($emp_code) {
        $this->layout = '';
        $previousCon = $this->ConveyencExpenseDetail->find('all', array(
            //'fields' => array('voucher_id', 'description', 'voucher_date', 'SUM(claim_amount) as claim ', 'SUM(distance) as distance'),
            'conditions' => array('emp_code' => $emp_code, 'conveyence_status' => 5),
            'group' => array('voucher_id')
        ));


        $this->set('previous', $previousCon);
    }

    function claimmaster() {
        $auth = $this->Session->read('Auth');
        $comp_code = $auth['User']['comp_code'];

        $convenyence_detail = $this->MstWheelerType->query("SELECT a.vehical,a.wheeler_type,a.price,a.effected_date FROM mst_wheeler_type AS a 
            WHERE effected_date = (SELECT MAX(effected_date) FROM mst_wheeler_type AS b 
            WHERE a.org_id = b.org_id AND a.vehical = b.vehical AND a.wheeler_type = b.wheeler_type ) and a.org_id='" . $comp_code . "' order by vehical,wheeler_type ");

        $this->set('convenyence_detail', $convenyence_detail);
    }

    function allrates() {
        $this->layout = 'employee-new';
        $auth = $this->Session->read('Auth');
        $comp_code = $auth['User']['comp_code'];
        $Rate_detail = $this->MstWheelerType->find('all', array('conditions' => array('org_id' => $comp_code), 'order' => array('wheeler_type', 'vehical')));
        $this->set('allRate', $Rate_detail);
    }

    function parkedit($voucherid = "") {
        $this->layout = 'employee-new';
        $auth = $this->Session->read('Auth');
        $comp_code = $auth['User']['comp_code'];
        $convenyence_detail = $this->MstWheelerType->find('all', array(
            'fields' => array('vehical', 'price')));
        $org_id = $this->Auth->User('comp_code');
        $get_days_chk = $this->EmpDetail->checkApplicationDelay('3', $org_id);

        $this->set('convenyence_detail', $convenyence_detail);
        for ($i = 0; $i < count($this->request->data['ConveyenceExpenses']['claimdate']); $i++) {
            $claimDate = date('Y-m-d', strtotime($this->request->data['ConveyenceExpenses']['claimdate'][$i]));
            if ($claimDate > date('Y-m-d')) {
                $this->Session->setFlash('<div class="uk-alert uk-alert-warning" data-uk-alert="">
                            <a href="#" class="uk-alert-close uk-close"></a>Conveyence Voucher cannot be applied in advance !!!</div>');
                $this->redirect('/conveyence_expenses/add');
            }
            echo date('Y-m-d', strtotime('today - ' . $get_days_chk . 'days'));
            if ($claimDate <= date('Y-m-d', strtotime('today - ' . $get_days_chk . 'days'))) {
                $this->Session->setFlash('<div class="uk-alert uk-alert-warning" data-uk-alert="">
                            <a href="#" class="uk-alert-close uk-close"></a>Conveyence Voucher cannot be applied in after ' . $get_days_chk . 'Days !!!</div>');
                $this->redirect('/conveyence_expenses/add');
            }
        }


        $this->set('convenyence_detail', $convenyence_detail);
        $voucherid_app = base64_decode($voucherid);


        $this->paginate = array(
            'fields' => array('*'),
            'joins' => array(
                array(
                    'table' => 'mst_emp_exp_voucher',
                    'alias' => 'MstEmpConveyence',
                    'type' => 'inner',
                    'foreignKey' => false,
                    'conditions' => array('ConveyencExpenseDetail.voucher_id = MstEmpConveyence.voucher_id')
                )
            ),
            'conditions' => array('ConveyencExpenseDetail.voucher_id' => $voucherid_app)
        );
        $empconveyencedetail = $this->paginate('ConveyencExpenseDetail');
        $vehical = $this->MstVehicalMaster->find('list', array(
            'fields' => array('id', 'vehical_name'),
            'conditions' => array('org_id' => $this->Auth->User('comp_code'))
        ));
        $this->set('travelmodev', $vehical);
        $count = count($this->data['ConveyenceExpenses']['claimdate']);
        $this->set('empconveyencedetail', $empconveyencedetail);
        $app_emp_code = $empconveyencedetail[0]['ConveyencExpenseDetail']['emp_code'];
        //print_r($this->data); die;
        if (!empty($this->data)) {
            for ($i = 0; $i < $count; $i++) {
                $val = array();
                $val['id'] = $this->request->data['ConveyenceExpenses']['id'];
                $val['voucher_id'] = $this->request->data['ConveyenceExpenses']['voucher_id'][$i];
                $val['emp_code'] = $this->Auth->User('emp_code');
                $val['claim_date'] = date('Y-m-d', strtotime($this->request->data['ConveyenceExpenses']['claimdate'][$i]));
                $val['travel_mode'] = $this->request->data['ConveyenceExpenses']['travelmode'][$i];
                $val['wheeler_type'] = $this->request->data['ConveyenceExpenses']['wheeler_type'][$i];
                $val['from_place'] = $this->request->data['ConveyenceExpenses']['from_place'][$i];
                $val['to_place'] = $this->request->data['ConveyenceExpenses']['to_place'][$i];
                $val['miscl_exp'] = $this->request->data['ConveyenceExpenses']['misc_exp'][$i];
                $val['miscl_exp_desc'] = $this->request->data['ConveyenceExpenses']['misc_exp_desc'][$i];
                $val['distance'] = $this->request->data['ConveyenceExpenses']['distance'][$i];
                $val['travel_exp'] = $this->request->data['ConveyenceExpenses']['travel_exp'][$i];
                $val['total_exp'] = $this->request->data['ConveyenceExpenses']['total_exp'][$i];
                $val['emp_exp'] = $this->request->data['ConveyenceExpenses']['total_exp'][$i];
                $val['conveyence_status'] = '8';
                $this->ConveyencExpenseDetail->create();
                $this->ConveyencExpenseDetail->set($val);
                $this->ConveyencExpenseDetail->save($val);
                unset($val);
            }
            $record_id = $this->request->data['ConveyenceExpenses']['voucher_id'][0];
            $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                            <a href="#" class="uk-alert-close uk-close"></a>Voucher Parked successfully !!!</div>');
            $this->redirect('/conveyence_expenses/workflow_display/' . $record_id);
        }
    }

    public function employee_expense_report() {
        $this->layout = 'employee-new';
        $auth = $this->Session->read('Auth');
        $orgID = $auth['MyProfile']['comp_code'];

        $flag = '';
        if (isset($this->request->data['submit']) && $this->request->data['submit'] != '') {

            if (($this->request->data['voucher_status'] == '0' || $this->request->data['voucher_status'] == '') && $this->request->data['from_date'] == '' && $this->request->data['end_date'] == '') {
                $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert="">
                            <a href="#" class="uk-alert-close uk-close"></a>Please Enter Atleast One Value !!!!</div>');
                $this->redirect('employee_expense_report');
            }

            if ($this->request->data['voucher_status'] != '0' && $this->request->data['voucher_status'] != '') {
                $ORconditions['ConveyencExpenseDetail.conveyence_status'] = $this->request->data['voucher_status'];

                $vouch_status = $this->request->data['voucher_status'];
            }
			if ($this->request->data['paid_status'] != '') {
                $ORconditions['ConveyencExpenseDetail.payment_status'] = $this->request->data['paid_status'];

                $paid_status = $this->request->data['paid_status'];
				$this->set('paid_status',$paid_status);
            }

            if (!empty($this->request->data['Employee'])) {
                     $ORconditions['ConveyencExpenseDetail.emp_code'] = $this->request->data['Employee'];
                    $emp_group = $this->request->data['Employee'];
                 $emp_group = base64_encode(serialize($emp_group));  
            } else {
				$emp_group = 'null';
			}

            if ($this->request->data['from_date'] != '' && $this->request->data['end_date'] != '') {
                $from_date = date('Y-m-d', strtotime($this->request->data['from_date']));
                $end_date = date('Y-m-d', strtotime($this->request->data['end_date']));
                $ORconditions['ConveyencExpenseDetail.claim_date between ? and ?'] = array($from_date, $end_date);
            }
		    $ORconditions['mst.comp_code'] = $orgID;
			$ORconditions['MyProfile.location_code'] = $auth['MyProfile']['location_code'];;
			
            $conditions = array($ORconditions);
            $VoucherDetails = $this->ConveyencExpenseDetail->find('all', array(
                'fields' => array('*'),
                'joins' => array(
                    array(
                        'table' => 'mst_emp_exp_voucher',
                        'alias' => 'mst',
                        'type' => 'inner',
                        'foreignKey' => false,
                        'conditions' => array('mst.voucher_id = ConveyencExpenseDetail.voucher_id')
                    ),
					array(
						'table' => 'myprofile',
						'alias' => 'MyProfile',
						'type' => 'INNER',
						'conditions' => array(
							'MyProfile.emp_code = ConveyencExpenseDetail.emp_code'
						)
					)
                ),
				'fields' => array('ConveyencExpenseDetail.*','MyProfile.location_code'),
				'order' => array('MyProfile.emp_full_name'),
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
            $this->set(compact('VoucherDetails', 'flag', 'vouch_status','emp_group', 'from_date', 'end_date','paid_status'));
        }
        $voucherStatus = array('0' => '---Select---', '2' => 'Pending', '5' => 'Approved', '4' => 'Rejected');

        $this->set(compact('voucherStatus'));
    }

    public function expense_payment_status() {
        //Configure::write('debug',2);
        $this->layout = 'employee-new';
        $auth = $this->Session->read('Auth');


        if (isset($this->request->data['submit']) && $this->request->data['submit'] != '') {

            if (!empty($this->request->data['id'])) {
                foreach ($this->request->data['id'] as $val) {
                    $PaymentUpdate = $this->ConveyencExpenseDetail->updateAll(array('ConveyencExpenseDetail.payment_status' => $this->request->data['payment_status']), array('ConveyencExpenseDetail.id' => $val));
                }
                $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                            <a href="#" class="uk-alert-close uk-close"></a>Payment Status Updated Successfully !!</div>');
                $this->redirect('employee_expense_report');
            } else {
                $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert="">
                            <a href="#" class="uk-alert-close uk-close"></a>Sorry, there is no record to update payment status !!</div>');
                $this->redirect('employee_expense_report');
            }
        } else {
            $this->redirect('employee_expense_report');
        }
    }

    public function generate_emp_exp_report_pdf($from_date = null, $end_date = null, $voucher_status = null,$emp_group = null ,$paid_status) {
		ini_set('memory_limit', '512M');
        $emp_group =  unserialize(base64_decode($emp_group));
        $this->layout = 'employee-new';
        $auth = $this->Session->read('Auth');
        $orgID = $auth['MyProfile']['comp_code'];


        if ($from_date != 'null' && $end_date != 'null') {
            $ORconditions['ConveyencExpenseDetail.claim_date between ? and ?'] = array($from_date, $end_date);
        }

        if ($voucher_status != 'null') {
            $ORconditions['ConveyencExpenseDetail.conveyence_status'] = $voucher_status;
        }
         if (!empty($emp_group) && $emp_group != null) {
            $ORconditions['ConveyencExpenseDetail.emp_code'] = $emp_group;
        }
		if ($paid_status != '') {
			    $ORconditions['ConveyencExpenseDetail.payment_status'] = $paid_status;
			}
			

        $ORconditions['mst.comp_code'] = $orgID;
		$ORconditions['MyProfile.location_code'] = $auth['MyProfile']['location_code'];;
			
        $conditions = array($ORconditions);

        $VoucherDetails = $this->ConveyencExpenseDetail->find('all', array(
            'fields' => array('*'),
            //'limit' => 10,
            //'order' => array('DtTravelVoucher.voucher_id  DESC'),
            'joins' => array(
                array(
                    'table' => 'mst_emp_exp_voucher',
                    'alias' => 'mst',
                    'type' => 'inner',
                    'foreignKey' => false,
                    'conditions' => array('mst.voucher_id = ConveyencExpenseDetail.voucher_id')
                ),
				array(
						'table' => 'myprofile',
						'alias' => 'MyProfile',
						'type' => 'INNER',
						'conditions' => array(
							'MyProfile.emp_code = ConveyencExpenseDetail.emp_code'
						)
					)
            ),
            'conditions' => $conditions,
                //'order'=>array('LvMstId.id desc')
				'order' => array('MyProfile.emp_full_name'),
                
        ));

        App::import('Vendor', 'TCpdf', array('file' => 'mpdf60/mpdf.php'));
        $this->layout = 'pdf';
        $this->set('pdf', new mPDF('utf-8', array(350, 500)));
        $this->set('VoucherDetails', $VoucherDetails);
    }

}

?>
