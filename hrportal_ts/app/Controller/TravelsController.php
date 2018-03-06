<?php
App::uses('AppController', 'Controller');

class TravelsController extends AppController {

    public $name = 'Travels';
    public $uses = array('LocalExp', 'Application', 'UserDetail', 'MstEmpExpVoucher', 'DtExpVoucher', 'TravelWfLvl', 'DtTravelVoucher', 'MstAppMapLvl', 'DtAppMapLvl', 'TravelWfLvl', 'ConveyencExpenseDetail', 'OptionAttribute','WfPaginateLvl');
    public $helpers = array('Js', 'Html', 'Form', 'Session', 'Common');
    public $components = array('Auth', 'Session', 'Email', 'Cookie', 'RequestHandler', 'EmpDetail','Common');

    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow();
        $currentUser = $this->checkUser();
        $this->set('appId', 1);

    }

    public function index() {
        $this->layout = 'employee-new';
        $this->redirect('/travels/trvoucher');
    }

    public function deleteTravelDetails($travel_id) {
        $travel_id = base64_decode($travel_id);
        $ld = $this->TravelWfLvl->find('list', array(
            'conditions' => array(
                'voucher_id' => $travel_id
            )
        ));
        foreach ($ld as $key => $value) {
            $this->DtTravelVoucher->delete($value);
        }
        $wf = $this->TravelWfLvl->find('list', array(
            'conditions' => array(
                'voucher_id' => $travel_id
            )
        ));
        foreach ($wf as $key => $value) {
            $this->TravelWfLvl->delete($value);
        }
        $ml = $this->MstEmpExpVoucher->find('list', array(
            'conditions' => array(
                'voucher_id' => $travel_id, 'expense_type' => 'T'
            )
        ));
        foreach ($ml as $key => $value) {
            $this->MstEmpExpVoucher->delete($value);
        }
        $this->Session->setFlash('Travel  Deleted Sucessfully');
        $this->redirect('view/');
    }

    public function trvoucher() {
        $this->layout = 'employee-new';
        $n = rand(0, 100000);
        $org_id = $this->Auth->User('comp_code');
        $emp_code = $this->Auth->User('emp_code');
        $auth = $this->Session->read('Auth');
        $con = new Model(array('table' => 'city_master', 'ds' => 'default', 'name' => 'CityMaster'));
        $city_list = $con->find('list', array('fields' => array('id', 'city_name')));
        $city_list[0] = 'Others';
        $this->set('city_grp_list', $city_list);
        $designation_code = $this->Session->read('Auth.MyProfile.desg_code');
        $dept_code = $this->Session->read('Auth.MyProfile.dept_code');
        $this->set('dept_code_oly', $dept_code);
        $dept_name = $this->Department->find('first', array(
            'fileds' => array('dept_name'),
            'conditions' => array('dept_code' => $dept_code)));
        $this->set('dept_code', $dept_name['Department']['dept_name']);
        $tvamtprice = $this->EmpDetail->getTravelAmtByDeptDesig($auth['MyProfile']['dept_code'], $auth['MyProfile']['desg_code']);

        $this->set('d_amount', $tvamtprice);

        $flag = 0;
        $department = $this->EmpDetail->getdepartmentlist();
        $Going_by = $this->EmpDetail->findtravelamt();
		
        $Coming_by = $this->EmpDetail->findtravelamt();
        if (!empty($this->request->data)) {
            $stDate = date('Y-m-d', strtotime($this->request->data['Voucher']['Tour_start_date']));
            $endDate = date('Y-m-d', strtotime($this->request->data['Voucher']['Tour_end_date']));

            //check whether expense voucher for entered date is already in database or not
            $travel_expense = $this->DtTravelVoucher->find('all', array(
                'conditions' => array(
                    "NOT" => array("travel_status" => array(4)),
                    "OR" => array("tour_start_date" => $stDate),
                    "OR" => array("tour_end_date" => $endDate),
                    'emp_code' => $this->Auth->User('emp_code'))
            ));

            if (count($travel_expense) > 0) {
                $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert="">
                            <a href="#" class="uk-alert-close uk-close"></a>Travel Voucher Already Applied !!</div>', false, array('class' => 'flash flash_error'));
                $this->redirect('/travels/trvoucher');
            }
            if ($stDate > date('Y-m-d')) {
                $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert="">
                            <a href="#" class="uk-alert-close uk-close"></a>Travel Voucher cannot be applied in advance !!</div>', false, array('class' => 'flash flash_error'));
                $this->redirect('/travels/trvoucher');
            }
            $date = new DateTime($stDate);
            $date2 = new DateTime(date('y-m-d'));
            $diff = date_diff($date, $date2);
            $days = $diff->days;
            if ($days > 15) {
                $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert="">
                            <a href="#" class="uk-alert-close uk-close"></a>Travel Voucher should  be applied within 15 days of travel.Sorry you are late to apply !!</div>', false, array('class' => 'flash flash_error'));
                $this->redirect('/travels/trvoucher');
            }
            $this->request->data['Voucher']['Other_total_expnse'] = $this->request->data['Voucher']['Total_expense_incurred'];
            $deptName = $this->request->data['Voucher']['Emp_department'];
            $visitPlace = $this->request->data['Voucher']['city_group'];
            
            App::import("Model", "MstTravelVoucher");
            $model = new MstTravelVoucher();
            $query = $model->find('first', array(
                'fields' => array('MstTravelVoucher.id'),
                'conditions' => array(
                    'MstTravelVoucher.type' => 1,
                    'MstTravelVoucher.desc' => 'Others'
                )
            ));
            $others_id = $query['MstTravelVoucher']['id'];
            if ($this->request->data['Voucher']['Going_by'] != $others_id) {
                $stravelMode = $this->request->data['Voucher']['Going_by'];
            } else {
                $newsave = array();
                $newsave['type'] = '4';
                $newsave['desc'] = $this->request->data['others_goingby'];
                $newsave['status'] = true;
                $newsave['created_date'] = date('Y-m-d h:i:s');
                $newsave['module_name'] = 'Travel_Expense';
                $this->MstTravelVoucher->create();
                if ($this->MstTravelVoucher->save($newsave)) {
                    $stravelMode = $this->MstTravelVoucher->id;
                    unset($newsave);
                }
            }
            if ($this->request->data['Voucher']['Coming_by'] != $others_id) {
                $etravelMode = $this->request->data['Voucher']['Coming_by'];
            } else {
                $save = array();
                $save['type'] = '4';
                $save['desc'] = $this->request->data['others_comingby'];
                $save['status'] = true;
                $save['created_date'] = date('Y-m-d h:i:s');
                $save['module_name'] = 'Travel_Expense';
                $this->MstTravelVoucher->create();
                if ($this->MstTravelVoucher->save($save)) {

                    $etravelMode = $this->MstTravelVoucher->id;
                }
            }

            $newfilename = $this->request->data['Voucher']['doc_file']['name'];
            $file = "uploads/Travel/" . $newfilename;
            if (!empty($this->request->data['Voucher']['doc_file']['name']) && !empty($emp_code)) {

                if (move_uploaded_file($this->request->data['Voucher']['doc_file']['tmp_name'], $file)) {
                    $save1['file'] = $newfilename;
                }
            }

            $stdate = $this->request->data['Voucher']['Tour_start_date'];
            $edDate = $this->request->data['Voucher']['Tour_end_date'];
            $tktExp = $this->request->data['Voucher']['Booked_amt'];
            $convExp = $this->request->data['Voucher']['Conveyence_amt'];
            $convRemk = $this->request->data['Voucher']['detail_local_conceyence'];
            $totDailyExp = $this->request->data['Voucher']['Daily_allow_days'];
            $days = intval($this->request->data['Voucher']['days']);
            $dailyAmt = $this->request->data['Voucher']['daily_amt'];
            $hotExp = $this->request->data['Voucher']['Hotel_stay_expense'];
            $miscExp = $this->request->data['Voucher']['Miscellaneous_exp_during_travil'];
            $miscRemk = $this->request->data['Voucher']['detail_miscellaneous_exp'];
            $teleExp = $this->request->data['Voucher']['Telephone_expense'];
            $clientExp = $this->request->data['Voucher']['Expense_incurred_travel'];
            $otherExp = $this->request->data['Voucher']['Another_expense'];
            $totalExp = $this->request->data['Voucher']['Total_expense_incurred'];
            $advAmount = $this->request->data['Voucher']['Advance_taken_employee'];
            $advEmpName = $this->request->data['Voucher']['Other_employee_name'];
            $balAmount = $this->request->data['Voucher']['Balance_amt_paid'];
            $retAmount = $this->request->data['Voucher']['Amount_return_head_office'];
            $tourAdvance = 0.0;
            $totAmount = $tktExp + $convExp + $totDailyExp + $hotExp + $miscExp + $teleExp + $clientExp + $otherExp;
            $advances = $tourAdvance + $advAmount;
            $netAmount = $totAmount - $advances;
            if ($netAmount > 0) {
                $amountB = $netAmount;
                $amountR = 0.0;
            } else if ($netAmount < 0) {
                $amountB = 0.0;
                $amountR = abs($netAmount);
            } else {
                $amountB = 0.0;
                $amountR = 0.0;
            }

            $department = $this->MyProfile->find('first', array(
                'fields' => array('MyProfile.dept_code'),
                'conditions' => array('MyProfile.emp_code' => $this->Auth->User('emp_code'))
            ));
            $save['emp_code'] = $emp_code;
            $save['expense_type'] = 'T';
            $save['voucher_date'] = date('Y-m-d h:i:s');
            ;
            $save['comp_code'] = $org_id;
            $save['dept_code'] = $department['MyProfile']['dept_code'];
            $con = $this->MstEmpExpVoucher->save($save);
            if ($con) {
                $save1['voucher_id'] = $this->MstEmpExpVoucher->getLastInsertID();
                $save1['emp_code'] = $emp_code;
                $save1['org_id'] = $org_id;
                $save1['da'] = $dailyAmt;
                $save1['days'] = $this->data['Voucher']['days'];
                $save1['hotel_stay'] = $hotExp;
                $save1['miscellaneous_exp'] = $miscExp;
                $save1['miscellaneous_details'] = $this->data['Voucher']['detail_miscellaneous_exp'];
                $save1['telephone_exp'] = $teleExp;
                $save1['client_exp'] = $clientExp;
                $save1['other_exp'] = $otherExp;
                $save1['hotel_days']= $this->request->data['Voucher']['hotel_days'];
                $save1['start_mode'] = $stravelMode;
                $save1['end_mode'] = $etravelMode;
                $save1['pending_amount'] = $balAmount;
                $save1['ticket_amount'] = $tktExp;
                $save1['conv_expense'] = $convExp;
                $save1['conv_details'] = $convRemk;
                $save1['total_expense'] = $totalExp;
                $save1['place_visit'] = $visitPlace;
                $save1['return_amount'] = $retAmount;
                $save1['tour_start_date'] = date('Y-m-d', strtotime($stdate));
                $save1['tour_end_date'] = date('Y-m-d', strtotime($edDate));
                $save1['adv_amount'] = $advAmount;
                $save1['empadv_name'] = $advEmpName;
                $save1['travel_status'] = 7;
                if ($con1 = $this->DtTravelVoucher->save($save1)) {
                    $len = sizeof($this->data['Voucher']['local_claim_date']);
                    for ($i = 0; $i < $len; $i++) {
                    $data_local['LocalExp']['local_claim_date'] = date('Y-m-d', strtotime($this->data['Voucher']['local_claim_date'][$i]));
                    $data_local['LocalExp']['local_claim_mode'] = $this->data['Voucher']['local_claim_mode'][$i];
                    $data_local['LocalExp']['local_claim_amount'] = $this->data['Voucher']['local_claim_amount'][$i];
                    $data_local['LocalExp']['tr_voucher_id'] = $this->DtTravelVoucher->getLastInsertID();
                    $this->LocalExp->create();
                    $this->LocalExp->save($data_local);
                    unset($data_local);
                }

                
                    $record_id = $this->MstEmpExpVoucher->getLastInsertID();
                    $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                            <a href="#" class="uk-alert-close uk-close"></a>Data Saved Successfully !!</div>');
                    $this->redirect('/travels/view/');
                }
            } else {
                $this->Session->setFlash('error Data Not Saved.', array('class' => 'flash flash_success'));
                $this->redirect('/travels/trvoucher/');
            }
        }
        $this->set('designation_code', $designation_code);
        $this->set('department', $department);
        $this->set('Going_by', $Going_by);
        $this->set('Coming_by', $Coming_by);
    }

    public function posttravel() {
        //echo "<pre>"; print_r($this->request->data); die;
        //Configure::write('debug',2);
        $this->layout = 'employee-new';
        $n = rand(0, 100000);
        $org_id = $this->Auth->User('comp_code');
        $emp_code = $this->Auth->User('emp_code');
        $designation_code = $this->Session->read('Auth.MyProfile.desg_code');
        $desg_code = $this->Session->read('Auth.MyProfile.dept_code');
        $emp_designation = $this->OptionAttribute->find('first', array(
            'fields' => array('OptionAttribute.name'),
            'conditions' => array('OptionAttribute.id' => $designation_code)
                )
        );

        $tvamtprice = $this->EmpDetail->findtravelamt('2');
        $designation = $emp_designation['OptionAttribute']['name'];
        if ($designation == 'SR PROJECT MANAGER' || $emp_designation == 'DIRECTOR') {
            $this->set('d_amount', $tvamtprice[3]);
        } else {

            $this->set('d_amount', $tvamtprice[5]);
        }
        $stDate = date('Y-m-d', strtotime($this->request->data['Voucher']['Tour_start_date']));
        $endDate = date('Y-m-d', strtotime($this->request->data['Voucher']['Tour_end_date']));
        $travel_expense = $this->DtTravelVoucher->find('all', array(
            'conditions' => array(
                "NOT" => array("travel_status" => array(4)),
                "OR" => array("tour_start_date" => $stDate),
                "OR" => array("tour_end_date" => $endDate),
                'emp_code' => $this->Auth->User('emp_code'))
        ));
        $date = new DateTime($stDate);
        $date2 = new DateTime(date('y-m-d'));
        $diff = date_diff($date, $date2);
        $days = $diff->days;
        if ($days > 15) {
            $this->Session->setFlash('Travel Voucher should  be applied within 15 days of travel.Sorry you are late to apply');
            $this->redirect('/travels/trvoucher');
        }
        if (count($travel_expense) > 0) {
            $this->Session->setFlash('Travel Voucher Already Applied');
            $this->redirect('/travels/trvoucher');
        }
        if ($stDate > date('Y-m-d')) {
            $this->Session->setFlash('Travel Voucher cannot be applied in advance');
            $this->redirect('/travels/trvoucher');
        }
        $department = $this->EmpDetail->getdepartmentlist();
        $Going_by = $this->EmpDetail->findtravelamt('1');
        $Coming_by = $this->EmpDetail->findtravelamt('1');
        if (!empty($this->request->data)) {
            $this->request->data['Voucher']['Other_total_expnse'] = $this->request->data['Voucher']['Total_expense_incurred'];
            $deptName = $this->data['Voucher']['Emp_department '];
            $visitPlace = $this->request->data['Voucher']['city_group'];
            $stDate = $this->request->data['Voucher']['Tour_start_date'];
            App::import("Model", "MstTravelVoucher");
            $model = new MstTravelVoucher();
            $query = $model->find('first', array(
                'fields' => array('MstTravelVoucher.id'),
                'conditions' => array(
                    'MstTravelVoucher.type' => 1,
                    'MstTravelVoucher.desc' => 'Others'
                )
            ));
            $others_id = $query['MstTravelVoucher']['id'];

            if ($this->request->data['Voucher']['Going_by'] != $others_id) {
                $stravelMode = $this->request->data['Voucher']['Going_by'];
            } else {
                $newsave = array();
                $newsave['type'] = '4';
                $newsave['desc'] = $this->request->data['others_goingby'];
                $newsave['status'] = true;
                $newsave['created_date'] = date('Y-m-d h:i:s');
                $newsave['module_name'] = 'Travel_Expense';
                $this->MstTravelVoucher->create();
                if ($this->MstTravelVoucher->save($newsave)) {

                    $stravelMode = $this->MstTravelVoucher->id;
                    unset($newsave);
                }
            }
            if ($this->request->data['Voucher']['Coming_by'] != $others_id) {
                $etravelMode = $this->request->data['Voucher']['Coming_by'];
            } else {
                $save = array();
                $save['type'] = '4';
                $save['desc'] = $this->request->data['others_comingby'];
                $save['status'] = true;
                $save['created_date'] = date('Y-m-d h:i:s');
                $save['module_name'] = 'Travel_Expense';
                $this->MstTravelVoucher->create();
                if ($this->MstTravelVoucher->save($save)) {
                    $etravelMode = $this->MstTravelVoucher->id;
                }
            }
            $stdate = $this->request->data['Voucher']['Tour_start_date'];
            $edDate = $this->request->data['Voucher']['Tour_end_date'];
            $tktExp = $this->request->data['Voucher']['Booked_amt'];
            $convExp = $this->request->data['Voucher']['Conveyence_amt'];
            $convRemk = $this->request->data['Voucher']['detail_local_conceyence'];
            $totDailyExp = $this->request->data['Voucher']['Daily_allow_days'];
            $dailyAmt = $this->request->data['Voucher']['daily_amt'];
            $hotExp = $this->request->data['Voucher']['Hotel_stay_expense'];
            $miscExp = $this->request->data['Voucher']['Miscellaneous_exp_during_travil'];
            $miscRemk = $this->request->data['Voucher']['detail_miscellaneous_exp'];
            $teleExp = $this->request->data['Voucher']['Telephone_expense'];
            $clientExp = $this->request->data['Voucher']['Expense_incurred_travel'];
            $otherExp = $this->request->data['Voucher']['Another_expense'];
            $totalExp = $this->request->data['Voucher']['Total_expense_incurred'];
            $advAmount = $this->request->data['Voucher']['Advance_taken_employee'];
            $advEmpName = $this->request->data['Voucher']['Other_employee_name'];
            $balAmount = $this->request->data['Voucher']['Balance_amt_paid'];
            $retAmount = $this->request->data['Voucher']['Amount_return_head_office'];
            $tourAdvance = 0.0;
            $totAmount = $tktExp + $convExp + $totDailyExp + $hotExp + $miscExp + $teleExp + $clientExp + $otherExp;
            $advances = $tourAdvance + $advAmount;
            $netAmount = $totAmount - $advances;
            if ($netAmount > 0) {
                $amountB = $netAmount;
                $amountR = 0.0;
            } else if ($netAmount < 0) {
                $amountB = 0.0;
                $amountR = abs($netAmount);
            } else {
                $amountB = 0.0;
                $amountR = 0.0;
            }
            $save['emp_code'] = $emp_code;
            $save['expense_type'] = 'T';
            $save['voucher_date'] = date('Y-m-d h:i:s');
            $save['comp_code'] = $org_id;
            $save['dept_code'] = $desg_code;
            $con = $this->MstEmpExpVoucher->save($save);
            if ($con) {

                $newfilename = $this->request->data['Voucher']['doc_file']['name'];
                $file = "uploads/Travel/" . $newfilename;
                if (!empty($this->request->data['Voucher']['doc_file']['name']) && !empty($emp_code)) {

                    if (move_uploaded_file($this->request->data['Voucher']['doc_file']['tmp_name'], $file)) {
                        $save1['file'] = $newfilename;
                    }
                }

                $save1['voucher_id'] = $this->MstEmpExpVoucher->getLastInsertID();
                $save1['emp_code'] = $emp_code;
                $save1['org_id'] = $org_id;
                $save1['da'] = $dailyAmt;
                $save1['days'] = $this->data['Voucher']['days'];
                $save1['hotel_stay'] = $hotExp;
                $save1['miscellaneous_exp'] = $miscExp;
                $save1['miscellaneous_details'] = $this->data['Voucher']['detail_miscellaneous_exp'];
                $save1['telephone_exp'] = $teleExp;
                $save1['client_exp'] = $clientExp;
                $save1['other_exp'] = $otherExp;
                $save1['start_mode'] = $stravelMode;
                $save1['hotel_days']= $this->request->data['Voucher']['hotel_days'];
                $save1['end_mode'] = $etravelMode;
                $save1['pending_amount'] = $balAmount;
                $save1['ticket_amount'] = $tktExp;
                $save1['conv_expense'] = $convExp;
                $save1['conv_details'] = $convRemk;
                $save1['total_expense'] = $totalExp;
                $save1['place_visit'] = $visitPlace;
                $save1['return_amount'] = $retAmount;
                $save1['tour_start_date'] = date('Y-m-d', strtotime($stdate));
                $save1['tour_end_date'] = date('Y-m-d', strtotime($edDate));
                $save1['adv_amount'] = $advAmount;
                $save1['empadv_name'] = $advEmpName;
                $save1['travel_status'] = 7;
                if ($con1 = $this->DtTravelVoucher->save($save1)) {
                    $len = sizeof($this->data['Voucher']['local_claim_date']);
                    for ($i = 0; $i < $len; $i++) {
                    $data_local['LocalExp']['local_claim_date'] = date('Y-m-d', strtotime($this->data['Voucher']['local_claim_date'][$i]));
                    $data_local['LocalExp']['local_claim_mode'] = $this->data['Voucher']['local_claim_mode'][$i];
                    $data_local['LocalExp']['local_claim_amount'] = $this->data['Voucher']['local_claim_amount'][$i];
                    $data_local['LocalExp']['tr_voucher_id'] = $this->DtTravelVoucher->getLastInsertID();
                    $this->LocalExp->create();
                    $this->LocalExp->save($data_local);
                    unset($data_local);
                }
                    $record_id = $this->DtTravelVoucher->getLastInsertID();
                    $this->Session->setFlash('Data Saved Successfully.', array('class' => 'flash flash_success'));
                    $this->redirect('/travels/workflow_display/' . $record_id);
                }
            } else {
                $this->Session->setFlash('error Data Not Saved.', array('class' => 'flash flash_success'));
                $this->redirect('/travels/trvoucher/');
            }
        }
        $this->set('designation_code', $designation_code);
        $this->set('department', $department);
        $this->set('Going_by', $Going_by);
        $this->set('Coming_by', $Coming_by);
    }

    function workflow_display($record_id = null) {
        $this->layout = 'employee-new';
        $this->set('travel', $record_id);
    }

    public function getvoucherno($voucherno = '') {
        $this->layout = 'employee-new';
        $this->set('voucher', $voucherno);
        $ckcount = $this->TravelWfLvl->checkstatus($this->Auth->User('doc_id'), $voucherno);
        if ($ckcount > 0) {
            $this->redirect(array('controller' => 'travels', 'action' => 'summary'));
        }
    }

    public function saveinfomation() {
        if (!empty($this->request->data)) {
            $org_id = $this->Auth->User('org_id');
            $save = array();
            $save['voucher_id'] = $this->request->data['TravelWorkflow']['travelvoucher_id'];
            $user_details = $this->EmpDetail->getemployeeinfomation($this->Auth->User('emp_code'));
            $save['emp_code'] = $user_details['MyProfile']['emp_code'];
            $save['fw_date'] = date('Y-m-d h:i:s');
            $save['voucher_status'] = '2';
            if ($this->TravelWfLvl->save($save)) {
                unset($save);
                $save1 = array();
                $save1['voucher_id'] = $this->request->data['TravelWorkflow']['travelvoucher_id'];
                $save1['emp_code'] = $this->request->data['fwtravel']['emp_code'];
                $this->TravelWfLvl->create();
                if ($this->TravelWfLvl->save($save1)) {
                    unset($save1);
                    $this->DtTravelVoucher->updateAll(
                            array('DtTravelVoucher.travel_status' => 2), array('DtTravelVoucher.id' => $this->request->data['TravelWorkflow']['travelvoucher_id'])
                    );
                    $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                            <a href="#" class="uk-alert-close uk-close"></a>Travel Voucher Forwarded !!!</div>');
                    $this->redirect(array('controller' => 'Travels', 'action' => 'view'));
                }
            }
        }
        $this->redirect(array('controller' => 'travels', 'action' => 'summary'));
    }

    function view($val) {
        
        try {

            $this->layout = 'employee-new';
            if(!empty($val))
            {
                $dt=$val;
                      $this->set('pen_val',$dt);
            }
            else{
            $dt=$this->Common->findpaginateLevel('1');
        }
 $auth = $this->Session->read('Auth');
            $emp_code = $this->Auth->User('emp_code');
            
        
            $this->paginate = array(
                'fields' => array('*'),
                'limit' => $dt,
                'order' => 'MstEmpExpVoucher.voucher_id DESC',
                'joins' => array(
                    array(
                        'table' => 'mst_emp_exp_voucher',
                        'alias' => 'MstEmpExpVoucher',
                        'type' => 'INNER',
                        'foreignKey' => false,
                        'conditions' => array('MstEmpExpVoucher.voucher_id = DtTravelVoucher.voucher_id')
                    )
                ),
                'conditions' => array('MstEmpExpVoucher.emp_code' => $emp_code)
            );
            $data = $this->paginate('DtTravelVoucher');
            $this->set('travellist', $data);
        } catch (Exception $e) {
            
        }
    }

    function previousVoucher() {
        try {
            $emp_code = $this->Auth->User('emp_code');
            $this->paginate = array(
                'fields' => array('*'),
                'limit' => 10,
                'order' => 'MstEmpExpVoucher.voucher_id DESC',
                'joins' => array(
                    array(
                        'table' => 'mst_emp_exp_voucher',
                        'alias' => 'MstEmpExpVoucher',
                        'type' => 'INNER',
                        'foreignKey' => false,
                        'conditions' => array('MstEmpExpVoucher.voucher_id = DtTravelVoucher.voucher_id')
                    )
                ),
                'conditions' => array('MstEmpExpVoucher.emp_code' => $emp_code)
            );
            $data = $this->paginate('DtTravelVoucher');
            $this->set('travellist', $data);
        } catch (Exception $e) {
            
        }
    }

    public function previousVoucherEmp($emp_code = NULL) {
        try {
            $this->paginate = array(
                'fields' => array('*'),
                'limit' => 10,
                'order' => 'MstEmpExpVoucher.voucher_id DESC',
                'joins' => array(
                    array(
                        'table' => 'mst_emp_exp_voucher',
                        'alias' => 'MstEmpExpVoucher',
                        'type' => 'INNER',
                        'foreignKey' => false,
                        'conditions' => array('MstEmpExpVoucher.voucher_id = DtTravelVoucher.voucher_id')
                    )
                ),
                'conditions' => array('MstEmpExpVoucher.emp_code' => $emp_code, 'DtTravelVoucher.travel_status' => 5)
            );
            $data = $this->paginate('DtTravelVoucher');
            $this->set('travellist', $data);
        } catch (Exception $e) {
            
        }
    }

    public function summary() {
        $this->layout = 'employee-new';
        $org_id = $this->Auth->User('org_id');
        $emp_code = $this->Auth->User('emp_code');

        $this->paginate = array(
            'fields' => array('Travelmain.vc_voucher_no', 'Travelmain.nu_balance_amount', 'Travelmain.nu_return_amount',
                'Travelmain.nu_emp_total', 'Travelmain.nu_mgr_total', 'Travel.vc_visit_place', 'Travel.nu_advance',
                'Travel.nu_total_expense', 'Travelmain.ch_vouch_status', 'Travel.dt_start_date',
                'Travel.dt_end_date', 'Travelmain.dt_app_date'),
            'limit' => 10,
            'joins' => array(
                array(
                    'table' => 'dt_travel_voucher',
                    'alias' => 'Travel',
                    'type' => 'inner',
                    'foreignKey' => false,
                    'conditions' => array('Travelmain.vc_voucher_no = Travel.vc_voucher_no AND 
                               Travelmain.vc_comp_code = Travel.vc_comp_code AND  Travelmain.dt_start_date = Travel.dt_start_date
                               AND Travelmain.dt_end_date = Travel.dt_end_date')
                )
            ),
            'conditions' => array('Travelmain.vc_emp_code' => $emp_code, 'Travelmain.vc_comp_code' => $org_id),
            'order' => array('Travel.dt_start_date desc')
        );
        $get_voucher_detail = $this->paginate('Travelmain');
        $this->set('voucher_detail', $get_voucher_detail);
    }

    public function approval($val) {
        $this->layout = 'employee-new';
         $auth = $this->Session->read('Auth');
         if(!empty($val))
         {
            $dt=$val;
            $this->set('pen_val',$dt);
         }
         else{
         $dt=$this->Common->findpaginateLevel('1');
     }
        $org_id = $this->Auth->User('comp_code');
        $emp_code = $this->Auth->User('emp_code');
        $this->paginate = array(
            'fields' => array('*'),
            'limit' => $dt,
            'order' => array('DtTravelVoucher.voucher_id  DESC '),
            'joins' => array(
                array(
                    'table' => 'mst_emp_exp_voucher',
                    'alias' => 'mst',
                    'type' => 'inner',
                    'foreignKey' => false,
                    'conditions' => array('mst.voucher_id = DtTravelVoucher.voucher_id ')
                ),
                array(
                    'table' => 'travel_workflow',
                    'alias' => 'TravelWfLvl',
                    'type' => 'inner',
                    'foreignKey' => false,
                    'conditions' => array('TravelWfLvl.voucher_id = DtTravelVoucher.id ')
                )
            ),
            'conditions' => array('TravelWfLvl.emp_code' => $emp_code, 'mst.emp_code != ' . $emp_code),
            'group by' => array('DtTravelVoucher.voucher_id')
        );
        $pending_voucher_employee = $this->paginate('DtTravelVoucher');
        $this->set('pending_voucher_employee', $pending_voucher_employee);
    }

    public function getInfo() {
        try {
            $id = $this->params['pass']['0'];

            if (!empty($id)) {
                $cdetails = $this->DtTravelVoucher->find('all', array(
                    'fields' => array('*'),
                    'conditions' => array('DtTravelVoucher.voucher_id' => $id, 'DtTravelVoucher.emp_code' => $this->Auth->User('emp_code'))));

                $travellist = $cdetails[0];
                $this->set('travellist', $travellist);

                $this->layout = '';
                $this->render('traveldetails');
            }
        } catch (Exception $e) {
            
        }
    }

    public function copyprevious() {

        $empdeparment = $this->MyProfile->find('first', array(
            'fields' => array('dept_code'),
            'conditions' => array('emp_code' => $this->Auth->User('emp_code'))
        ));
        $dept = $empdeparment['MyProfile']['dept_code'];
        try {
            $id = $this->params['pass']['0'];

            if (!empty($id)) {
                $cdetails = $this->DtTravelVoucher->find('all', array(
                    'fields' => array('*'),
                    'conditions' => array('DtTravelVoucher.voucher_id' => $id, 'DtTravelVoucher.emp_code' => $this->Auth->User('emp_code'))));
                $cdetails[0]['DtTravelVoucher']['dept'] = $dept;

                $this->set('travellist', $cdetails);
                $this->layout = '';
                $this->render('copyprevious');
            }
        } catch (Exception $e) {
            
        }
    }

    function edittravel($cmpcode = '', $voucherid = '', $emcode = '') {
        $this->layout = 'employee-new';
        $cmpcode_app = base64_decode($cmpcode);
        $voucherid_app = base64_decode($voucherid);
        $empcode_app = base64_decode($emcode);
        $this->paginate = array(
            'fields' => array('*'),
            'joins' => array(
                array(
                    'table' => 'mst_emp_exp_voucher',
                    'alias' => 'MstEmpConveyence',
                    'type' => 'inner',
                    'foreignKey' => false,
                    'conditions' => array('DtTravelVoucher.voucher_id = MstEmpConveyence.voucher_id')
                )
            ),
            'conditions' => array('DtTravelVoucher.voucher_id' => $voucherid_app)
        );
        $emptraveldetail = $this->paginate('DtTravelVoucher');
        $daily = $emptraveldetail[0]['DtTravelVoucher']['da'];
        $conveyance = $emptraveldetail[0]['DtTravelVoucher']['conv_expense'];
        $mis = $emptraveldetail[0]['DtTravelVoucher']['miscellaneous_exp'];
        $hotel_stay = $emptraveldetail[0]['DtTravelVoucher']['hotel_stay'];
        $other_exp = $emptraveldetail[0]['DtTravelVoucher']['other_exp'];
        $balance = $emptraveldetail[0]['DtTravelVoucher']['pending_amount'];
        $total_exp = array($daily, $conveyance, $mis, $hotel_stay, $other_exp, $balance);
        $exp = implode(',', $total_exp);
        $this->set('exp', $exp);
        $this->set('emptraveldetail', $emptraveldetail);

        $app_emp_code = $emptraveldetail[0]['DtTravelVoucher']['emp_code'];
        $this->set('emp_code', $app_emp_code);
        if (!empty($this->request->data)) {
            $this->redirect('/travels/fwtravel/' . $voucherid_app);
        }
    }

    function fwtravel($travelno = '') {
        $this->layout = 'employee-new';
        if ($this->request->data) {
            $fulldata = $this->request->data['TravelWorkflow'];
            if (empty($travelno))
                $travelno = $this->request->data['TravelWorkflow']['voucher_id'];
            else
                $travelno = $travelno;
            $this->set('travel', $travelno);
            $check = $this->DtTravelVoucher->find('first', array('conditions' => array('id' => $travelno)));
            if ($this->data['return_amount'] > 0) {
                $update = $this->DtTravelVoucher->updateAll(
                        array('DtTravelVoucher.return_amount' => $this->data['return_amount']), array('DtTravelVoucher.id' => $travelno));
            } else {
                $update = $this->DtTravelVoucher->updateAll(
                        array('DtTravelVoucher.pending_amount' => $this->data['claim_amount']), array('DtTravelVoucher.id' => $travelno));
            }
            $this->set('TravelStatus', $check['DtTravelVoucher']['travel_status']);
            $TravelWorkflowid = $this->TravelWfLvl->find('first', array(
                'conditions' => array('TravelWfLvl.emp_code' => $this->Auth->User('emp_code'), 'TravelWfLvl.voucher_id' => $travelno)));
            $travelid = $TravelWorkflowid['TravelWfLvl']['id'];
            $this->set('travelid', $travelid);
        }
    }

    public function rejectvoucher() {

        $comp = $this->params['data']['comp_code'];
        $sdate = $this->params['data']['start_date'];
        $id = $this->params['data']['end_date'];
        $voucher_no = $this->params['data']['voucher_no'];
        $rejectreson = $this->params['data']['rejectreson'];
        $save = array();
        $save['travel_Status'] = '4';
        $save['voucher_id'] = $voucher_no;
        $travel_rej = $this->DtTravelVoucher->updateAll(
                array('DtTravelVoucher.travel_Status' => '4'), array('DtTravelVoucher.voucher_id' => $voucher_no)
        );

        if ($travel_rej) {
            unset($save);
            $date = date('Y-m-d');
            $travel_rej = $this->TravelWfLvl->updateAll(
                    array('TravelWfLvl.voucher_status' => "4", 'TravelWfLvl.remark' => "'$rejectreson'", 'TravelWfLvl.approve_date' => "'.$date.'"), array('TravelWfLvl.voucher_id' => $voucher_no, 'TravelWfLvl.emp_code' => $this->Auth->User('emp_code')));



            $this->Session->setFlash('Voucher Rejected Successfully', false, array('class' => 'flash flash_error'));
        }


        if ($this->params['data']['varfy'] == '2') {
            $this->redirect(array('controller' => 'travels', 'action' => 'ceoapproval'));
        } else {
            $this->redirect(array('controller' => 'travels', 'action' => 'approval'));
        }
    }

    public function editvoucher($id) {
        $this->layout = 'employee-new';
        $id = base64_decode($id);
        $empdeparment = $this->MyProfile->find('first', array(
            'fields' => array('dept_code'),
            'conditions' => array('emp_code' => $this->Auth->User('emp_code'))
        ));
        $auth = $this->Session->read('Auth');
        $dept = $empdeparment['MyProfile']['dept_code'];

        $travel_info = $this->DtTravelVoucher->find('first', array(
            'fields' => array('*'),
            'conditions' => array('DtTravelVoucher.id' => $id)
        ));
        
        $mst_travel = $this->MstEmpExpVoucher->find('first', array(
            'fields' => array('*'),
            'conditions' => array('MstEmpExpVoucher.voucher_id' => $travel_info['DtTravelVoucher']['voucher_id'])
        ));
        $con = new Model(array('table' => 'city_master', 'ds' => 'default', 'name' => 'CityMaster'));
        $city_list = $con->find('list', array('fields' => array('id', 'city_name')));
        $city_list[0] = 'Others';
        $this->set('city_grp_list', $city_list);
        $local_conv = new Model(array('table' => 'local_expence', 'ds' => 'default', 'name' => 'LocalExpense'));
        $local_expense_list = $local_conv->find('all', array('conditions' => array('tr_voucher_id'=> $id)));
        $this->set('local_expense_dtl',$local_expense_list);
        $strtDate = $travel_info['DtTravelVoucher']['tour_start_date'];
        $endDate = $travel_info['DtTravelVoucher']['tour_end_date'];
        $plc_visit = $travel_info['DtTravelVoucher']['place_visit'];
        $city_type = $con->find('first', array('fields' => array('id', 'group_id'), 'conditions' => array('id' => $plc_visit)));
        $date = new DateTime($strtDate);
        $date2 = new DateTime($endDate);
        $diff = date_diff($date, $date2);
        $optionDays = $diff->days;
        for ($i = 0; $i <= ($optionDays + 1); $i++) {
            $option_days[$i] = $i;
        }
        
        $tvamtprice = $this->EmpDetail->getTravelAmtByDeptDesig($auth['MyProfile']['dept_code'], $auth['MyProfile']['desg_code'],$city_type['CityMaster']['group_id']);
        $tvhotelamtprice = $this->EmpDetail->getTravelHtlAmtByDeptDesig($auth['MyProfile']['dept_code'], $auth['MyProfile']['desg_code'],$city_type['CityMaster']['group_id']);
        $department = $this->EmpDetail->getdepartmentlist();
        $Going_by = $this->EmpDetail->findtravelamt('1');
        $Coming_by = $this->EmpDetail->findtravelamt('1');
        $designation_code = $this->Session->read('Auth.MyProfile.desg_code');
        $DA_Days = $travel_info['DtTravelVoucher']['days'];
        $this->set('DA_Days', $DA_Days);
        $this->set('d_amount', $tvamtprice);
        $this->set('hotel_amount', $tvhotelamtprice);
        $this->set('option_days', $option_days);
        $this->set('travelid', $id);
        $this->set('dept', $dept);
        $this->set('designation_code', $designation_code);
        $this->set('Going_by', $Going_by);
        $this->set('Coming_by', $Coming_by);
        $this->set('department', $department);
        $this->set('travel_info', $travel_info);
        $this->set('mstTravel', $mst_travel);
    }

    public function post_travel() {
        $this->layout = 'employee-new';
        $n = rand(0, 100000);
        $emp_code = $this->Auth->User('emp_code');
        if (!empty($this->request->data)) {
            $this->request->data['Voucher']['Other_total_expnse'] = $this->request->data['Voucher']['Total_expense_incurred'];
            $deptName = $this->request->data['Voucher']['Emp_department'];
            $visitPlace = $this->request->data['Voucher']['city_group'];
            
            $stDate = $this->request->data['Voucher']['Tour_start_date'];
            App::import("Model", "MstTravelVoucher");
            $model = new MstTravelVoucher();
            $query = $model->find('first', array(
                'fields' => array('MstTravelVoucher.id'),
                'conditions' => array(
                    'MstTravelVoucher.type' => 1,
                    'MstTravelVoucher.desc' => 'Others'
                )
            ));
            $others_id = $query['MstTravelVoucher']['id'];

            if ($this->request->data['Voucher']['Going_by'] != $others_id) {
                $stravelMode = $this->request->data['Voucher']['Going_by'];
            } else {
                $newsave = array();
                $newsave['type'] = '4';
                $newsave['desc'] = $this->request->data['others_goingby'];
                $newsave['status'] = true;
                $newsave['created_date'] = date('Y-m-d h:i:s');
                $newsave['module_name'] = 'Travel_Expense';
                $this->MstTravelVoucher->create();
                if ($this->MstTravelVoucher->save($newsave)) {

                    $stravelMode = $this->MstTravelVoucher->id;
                    unset($newsave);
                }
            }
            if ($this->request->data['Voucher']['Coming_by'] != $others_id) {
                $etravelMode = $this->request->data['Voucher']['Coming_by'];
            } else {
                $save = array();
                $save['type'] = '4';
                $save['desc'] = $this->request->data['others_comingby'];
                $save['status'] = true;
                $save['created_date'] = date('Y-m-d h:i:s');
                $save['module_name'] = 'Travel_Expense';
                $this->MstTravelVoucher->create();
                if ($this->MstTravelVoucher->save($save)) {

                    $etravelMode = $this->MstTravelVoucher->id;
                }
            }
            $stdate = $this->request->data['Voucher']['Tour_start_date'];
            $edDate = $this->request->data['Voucher']['Tour_end_date'];
            $tktExp = $this->request->data['Voucher']['Booked_amt'];
            $convExp = $this->request->data['Voucher']['Conveyence_amt'];
            $convRemk = $this->request->data['Voucher']['detail_local_conceyence'];
            $totDailyExp = $this->request->data['Voucher']['Daily_allow_days'];
            $dailyAmt = $this->request->data['Voucher']['daily_amt'];
            $hotExp = $this->request->data['Voucher']['Hotel_stay_expense'];
            $miscExp = $this->request->data['Voucher']['Miscellaneous_exp_during_travil'];
            $miscRemk = $this->request->data['Voucher']['detail_miscellaneous_exp'];
            $teleExp = $this->request->data['Voucher']['Telephone_expense'];
            $clientExp = $this->request->data['Voucher']['Expense_incurred_travel'];
            $otherExp = $this->request->data['Voucher']['Another_expense'];
            $totalExp = $this->request->data['Voucher']['Total_expense_incurred'];
            $advAmount = $this->request->data['Voucher']['Advance_taken_employee'];
            $advEmpName = $this->request->data['Voucher']['Other_employee_name'];
            $balAmount = $this->request->data['Voucher']['Balance_amt_paid'];
            $retAmount = $this->request->data['Voucher']['Amount_return_head_office'];
            $tourAdvance = 0.0;
            $totAmount = $tktExp + $convExp + $totDailyExp + $hotExp + $miscExp + $teleExp + $clientExp + $otherExp;
            $advances = $tourAdvance + $advAmount;
            $netAmount = $totAmount - $advances;
            if ($netAmount > 0) {
                $amountB = $netAmount;
                $amountR = 0.0;
            } else if ($netAmount < 0) {
                $amountB = 0.0;
                $amountR = abs($netAmount);
            } else {
                $amountB = 0.0;
                $amountR = 0.0;
            }

            if ($this->data) {
                if ($_FILES['doc_file']['name'] != '') {
                    $newfilename = $n . basename($_FILES['doc_file']['name']);
                    $file = "uploads/Travel/" . $newfilename;
                    $filename = basename($_FILES['doc_file']['name']);
                    if (!empty($_FILES['doc_file']['name']) && !empty($emp_code)) {

                        if (move_uploaded_file($_FILES['doc_file']['tmp_name'], $file)) {
                            $save1['file'] = $newfilename;
                        }
                    }
                }
                $save1['id'] = $this->data['travelid'];
                $save1['da'] = $dailyAmt;
                $save1['days'] = $this->data['Voucher']['days'];
                $save1['emp_code'] = $this->Auth->User('emp_code');
                $save1['hotel_stay'] = $hotExp;
                $save1['miscellaneous_exp'] = $miscExp;
                $save1['miscellaneous_details'] = $this->data['Voucher']['detail_miscellaneous_exp'];
                $save1['telephone_exp'] = $teleExp;
                $save1['client_exp'] = $clientExp;
                $save1['other_exp'] = $otherExp;
                $save1['start_mode'] = $stravelMode;
                $save1['end_mode'] = $etravelMode;
                $save1['hotel_days']= $this->request->data['Voucher']['hotel_days'];
                $save1['pending_amount'] = $balAmount;
                $save1['ticket_amount'] = $tktExp;
                $save1['conv_expense'] = $convExp;
                $save1['conv_details'] = $convRemk;
                $save1['total_expense'] = $balAmount;
                $save1['place_visit'] = $visitPlace;
                $save1['return_amount'] = $retAmount;
                $save1['tour_start_date'] = date('Y-m-d', strtotime($stdate));
                $save1['tour_end_date'] = date('Y-m-d', strtotime($edDate));
                if ($con1 = $this->DtTravelVoucher->save($save1)) {
                    $this->LocalExp->deleteAll(array('tr_voucher_id'=>$this->data['travelid']));
                    $len = sizeof($this->data['Voucher']['local_claim_date']);
                    for($i = 0; $i < $len; $i++) {
                    $data_local['LocalExp']['local_claim_date'] = date('Y-m-d', strtotime($this->data['Voucher']['local_claim_date'][$i]));
                    $data_local['LocalExp']['local_claim_mode'] = $this->data['Voucher']['local_claim_mode'][$i];
                    $data_local['LocalExp']['local_claim_amount'] = $this->data['Voucher']['local_claim_amount'][$i];
                    $data_local['LocalExp']['tr_voucher_id'] = $this->data['travelid'];
                    $this->LocalExp->create();
                    $this->LocalExp->save($data_local);
                    unset($data_local);
                }
                    $this->Session->setFlash('Data Saved Successfully.', array('class' => 'flash flash_success'));
                    $this->redirect('/travels/workflow_display/' . $this->data['travelid']);
                }
            } else {
                $this->Session->setFlash('error Data Not Saved.', array('class' => 'flash flash_success'));
                $this->redirect('/travels/trvoucher/');
            }
        }
        $this->set('designation_code', $designation_code);
        $this->set('department', $department);
        $this->set('Going_by', $Going_by);
        $this->set('Coming_by', $Coming_by);
    }

    public function travelwf($voucherno = '') {

        $this->layout = 'employee-new';
        $this->set('voucher', $voucherno);
        $TravelWfLvlid = $this->TravelWfLvl->find('first', array('conditions' => array('TravelWfLvl.doc_id' => $this->Auth->User('doc_id'),
                'TravelWfLvl.voucher_id' => $voucherno)));
        $this->set('TravelWfLvlid', $TravelWfLvlid);
        $ckcount = $this->TravelWfLvl->checkstatus($this->Auth->User('doc_id'), $voucherno);
        if ($ckcount > 0) {
            $this->redirect(array('controller' => 'travels', 'action' => 'approval'));
        }
    }

    public function accountsearch() {
        $this->layout = 'employee-new';
    }

    public function accountapproval() {
        $this->layout = 'employee-new';
        $pending_emp_details = '';

        $fromDate = $this->request->data['Account_Voucher']['from_date'];
        $toDate = $this->request->data['Account_Voucher']['to_date'];
        $this->set('fromDate', $fromDate);
        $this->set('toDate', $toDate);
        if (!empty($this->request->data)) {
            $org_id = $this->Auth->User('org_id');
            $emp_code = $this->Auth->User('emp_code');
            $doc_id = $this->Auth->User('doc_id');
            $empid = $this->Auth->User('id');
            $sort_by = $this->request->data['Account_Voucher']['sort'];
            $status = $this->request->data['Account_Voucher']['status'];
            $designation_code = $this->Auth->User('emp_desg_id');
            $desg_code = $this->Auth->User('emp_dept_id');
            $emp_datail = $this->EmpDetail->getdesgdetail();
            $this->set('emp_designation', $emp_datail);
            $this->paginate = array(
                'fields' => array('Travelmain.vc_comp_code', 'Travelmain.vc_voucher_no', 'Travelmain.vc_dept_name', 'Travelmain.vc_emp_code', 'Travelmain.dt_start_date',
                    'Travelmain.dt_end_date', 'Travelmain.nu_balance_amount', 'Travelmain.nu_return_amount',
                    'Travelmain.nu_emp_total', 'Travelmain.nu_mgr_total', 'Travel.vc_visit_place', 'Travel.nu_advance',
                    'Travel.nu_total_expense', 'Travelmain.ch_vouch_status', 'Travel.dt_start_date',
                    'Travel.dt_end_date', 'Travelmain.dt_app_date', 'TravelWfLvl.doc_id', 'TravelWfLvl.emp_id',
                    'TravelWfLvl.emp_code', 'TravelWfLvl.fw_date'),
                'limit' => 10,
                'joins' => array(
                    array(
                        'table' => 'dt_travel_voucher',
                        'alias' => 'Travel',
                        'type' => 'inner',
                        'foreignKey' => false,
                        'conditions' => array('Travelmain.vc_voucher_no = Travel.vc_voucher_no AND 
                               Travelmain.vc_comp_code = Travel.vc_comp_code AND  Travelmain.dt_start_date = Travel.dt_start_date
                               AND Travelmain.dt_end_date = Travel.dt_end_date')
                    ),
                    array(
                        'table' => 'travel_wf_lvl',
                        'alias' => 'TravelWfLvl',
                        'type' => 'inner',
                        'foreignKey' => false,
                        'conditions' => array('TravelWfLvl.voucher_id = Travelmain.vc_voucher_no')
                    )
                ),
                'conditions' => array('TravelWfLvl.emp_code' => $emp_code, 'TravelWfLvl.doc_id' => $doc_id, 'Travelmain.ch_vouch_status' => $status),
                'order' => array('Travel.dt_start_date desc')
            );
            $peding_datail = $this->paginate('Travelmain');
            $this->set('pending_emp_details', $peding_datail);
        }
    }

    public function editaccountvoucher($comp_code, $voucherno, $empcode, $emp_name, $start_date, $enddate) {
        $this->layout = 'employee-new';
        $org_id = $this->Auth->User('org_id');
        $emp_code = $this->Auth->User('emp_code');
        $doc_id = $this->Auth->User('doc_id');
        $empid = $this->Auth->User('id');
        $designation_code = $this->Auth->User('emp_desg_id');
        $this->set('designation_code', $designation_code);
        $comp_code = base64_decode($comp_code);
        $voucher_no = base64_decode($voucherno);
        $empcode = base64_decode($empcode);
        $empname = base64_decode($emp_name);
        $startdate = base64_decode($start_date);
        $enddate = base64_decode($enddate);

        $emp_designation = $this->EmpDetail->getdesgdetail();
        $this->set('designation', $emp_designation);
        $sanction_detail = array($comp_code, $voucher_no, $empcode, $empname, $startdate, $enddate);
        $this->set('empdetail', $sanction_detail);

        $peding_datail = $this->Travelmain->find('first', array(
            'fields' => array('Travelmain.vc_voucher_no', 'Travelmain.vc_dept_name', 'Travelmain.vc_emp_desg', 'Travelmain.nu_balance_amount', 'Travelmain.nu_return_amount',
                'Travelmain.nu_emp_total', 'Travelmain.nu_mgr_total', 'Travel.vc_visit_place', "To_char(Travel.dt_start_date,'hh24:mi')AS dt_start_time",
                'Travel.nu_total_expense', 'Travelmain.ch_vouch_status', 'Travel.nu_advance', 'Travel.vc_sttravel_mode',
                "To_char(Travel.dt_end_date,'hh24:mi') dt_end_time", 'Travelmain.dt_app_date',
                'Travel.vc_edtravel_mode', 'Travel.nu_ticket_amount', 'Travel.nu_conv_expense',
                'Travel.nu_total_allowance', 'Travel.nu_hotel_stay', 'Travel.nu_hotel_expense',
                'Travel.nu_misc_expense', 'Travel.nu_tele_expense', 'Travel.nu_client_expense',
                'Travel.nu_other_expense', 'Travel.nu_other_advance', 'Travel.vc_empadv_name',
                "NVL(Travel.vc_conv_remark,'.') AS vc_conv_remark", "NVL(Travel.vc_misc_remark,'.') AS vc_misc_remark",),
            'limit' => 10,
            'joins' => array(
                array(
                    'table' => 'dt_travel_voucher',
                    'alias' => 'Travel',
                    'type' => 'inner',
                    'foreignKey' => false,
                    'conditions' => array('Travelmain.vc_voucher_no = Travel.vc_voucher_no AND 
                               Travelmain.vc_comp_code = Travel.vc_comp_code AND  Travelmain.dt_start_date = Travel.dt_start_date
                               AND Travelmain.dt_end_date = Travel.dt_end_date AND Travelmain.vc_comp_code = Travel.vc_comp_code')
                )
            ),
            'conditions' => array('Travelmain.vc_emp_code' => $empcode, 'Travelmain.vc_comp_code' => $comp_code,
                'Travelmain.vc_voucher_no' => $voucher_no),
            'order' => array('Travel.dt_start_date desc')));

        $this->set('approval_detail', $peding_datail);
        $department = $this->Auth->User('emp_dept_id');
        $this->set('emp_department', $department);

        if (!empty($this->request->data)) {
            $hidden_fields = $this->params['form'];
            $compCode = $hidden_fields['compCode'];
            $vouchNo = $hidden_fields['vouchNo'];
            $stDate = $hidden_fields['stDate'];
            $edDate = $hidden_fields['edDate'];
            $vStatus = $hidden_fields['vStatus'];
            $advAmount = $hidden_fields['advAmount'];
            $tktExp = $this->request->data['Voucher']['Booked_amt'];
            $convExp = $this->request->data['Voucher']['Conveyence_amt'];
            $convRemk = $this->request->data['Voucher']['detail_local_conceyence'];
            $totDailyExp = $this->request->data['Voucher']['Daily_allow_days'];
            $days = $this->request->data['Voucher']['days'];
            $save1['hotel_days']= $this->request->data['Voucher']['hotel_days'];
            $dailyAmt = $this->request->data['Voucher']['daily_amt'];
            $hotExp = $this->request->data['Voucher']['Hotel_stay_expense'];
            $miscExp = $this->request->data['Voucher']['Miscellaneous_exp_during_travil'];
            $miscRemk = $this->request->data['Voucher']['detail_miscellaneous_exp'];
            $teleExp = $this->request->data['Voucher']['Telephone_expense'];
            $clientExp = $this->request->data['Voucher']['Expense_incurred_travel'];
            $otherExp = $this->request->data['Voucher']['Another_expense'];
            $totalExp = $this->request->data['Voucher']['Total_expense_incurred'];
            $advEmpName = $this->request->data['Voucher']['Other_employee_name'];
            $balAmount = $this->request->data['Voucher']['Balance_amt_paid'];
            $retAmount = $this->request->data['Voucher']['Amount_return_head_office'];
            $tourAdvance = 0.0;
            $totAmount = $tktExp + $convExp + $totDailyExp + $hotExp + $miscExp + $teleExp + $clientExp + $otherExp;
            $advances = $tourAdvance + $advAmount;
            $netAmount = $totAmount - $advances;
            if ($netAmount > 0) {
                $amountB = $netAmount;
                $amountR = 0.0;
            } else if ($netAmount < 0) {
                $amountB = 0.0;
                $amountR = $netAmount;
            } else {
                $amountB = 0.0;
                $amountR = 0.0;
            }
            $sys_date = $this->Travelmain->query("SELECT TO_CHAR( SYSDATE, 'DD-MM-RRRR')" . "NOW FROM DUAL");
            $voucherdate = $sys_date[0][0]['SYSDATE'];
            $conStr1 = $this->Travelmain->query("UPDATE dt_travel_voucher  SET NU_TICKET_AMOUNT=" . $tktExp . ",NU_CONV_EXPENSE=" . $convExp . ", NU_HOTEL_STAY=" . $days . ",
                     NU_TOTAL_ALLOWANCE=" . $totDailyExp . ",NU_HOTEL_EXPENSE=" . $hotExp . ",NU_MISC_EXPENSE=" . $miscExp . ",NU_TELE_EXPENSE=" . $teleExp . ",
                     NU_CLIENT_EXPENSE=" . $clientExp . ",NU_OTHER_EXPENSE=" . $otherExp . " WHERE VC_COMP_CODE='" . $compCode . "' AND VC_VOUCHER_NO='" . $vouchNo . "'
                     and DT_START_DATE=to_date('" . $stDate . "','DD-MM-RRRR') and DT_END_DATE=to_date('" . $edDate . "','DD-MM-RRRR')");
            $conStr2 = $this->Travelmain->query("UPDATE dt_travel_voucher  SET NU_TOTAL_EXPENSE=" . $totAmount . ", NU_ADVANCE=" . $tourAdvance . ", NU_OTHER_ADVANCE=" . $advAmount . "
                      WHERE VC_COMP_CODE='" . $compCode . "' AND VC_VOUCHER_NO='" . $vouchNo . "' AND DT_START_DATE=To_date('" . $stDate . "','DD-MM-RRRR')
                      and DT_END_DATE=to_date('" . $edDate . "','DD-MM-RRRR')");

            $conStr3 = $this->Travelmain->query("UPDATE hd_travel_voucher  SET CH_VOUCH_STATUS='" . $vStatus . "', DT_SANCTION_DATE=To_date('" . $voucherdate . "','DD-MM-RRRR'), NU_BALANCE_AMOUNT=" . $amountB . ",
                     NU_RETURN_AMOUNT=" . $amountR . ", NU_EMP_TOTAL=" . $totAmount . ", NU_MGR_TOTAL=" . $totAmount . " WHERE VC_COMP_CODE='" . $compCode . "' AND VC_VOUCHER_NO='" . $vouchNo . "'
                     AND DT_START_DATE=to_date('" . $stDate . "','DD-MM-RRRR') AND DT_END_DATE=to_date('" . $edDate . "','DD-MM-RRRR')");
            $this->Session->setFlash($this->Errormsg->getErrorList('APPROVED'), false, array('class' => 'flash flash_success'));

            if ($department == "ACCOUNTS") {
                $this->redirect('accountsearch');
            } else {
                $this->redirect('ceoapproval');
            }
        }
    }

    function travelwfsaveinfo() {
        if (!empty($this->request->data)) {
            //============== Forward==================
            if ($this->request->data['TravelWorkflow']['type'] == 2) {
                $save = array();
                $save['id'] = $this->request->data['TravelWfLvl']['id'];
                $save['voucher_id'] = $this->request->data['TravelWfLvl']['voucher_id'];
                if ($this->request->data['TravelWorkflow']['forward_remark'] != " ") {
                    $save['remark'] = $this->request->data['TravelWorkflow']['forward_remark'];
                }
                $save['fw_date'] = date('Y-m-d');
                $save['voucher_status'] = '2';

                $this->TravelWfLvl->save($save);
                unset($save);
                $check = $this->TravelWfLvl->find('first', array('conditions' => array(
                        'voucher_id' => $this->request->data['TravelWfLvl']['voucher_id'],
                        'emp_code' => $this->request->data['TravelWorkflow']['forward_emp_code'])));

                if (empty($check)) {
                    $save1 = array();
                    $save1['voucher_id'] = $this->request->data['TravelWfLvl']['voucher_id'];
                    $save1['emp_code'] = $this->request->data['TravelWorkflow']['forward_emp_code'];
                    $this->TravelWfLvl->create();
                    $this->TravelWfLvl->save($save1);
                    unset($save1);
                } else {
                    if ($this->request->data['TravelWorkflow']['forward_remark'] == "") {
                        $remark = 'Null';
                    } else {
                        $remark = $this->request->data['TravelWorkflow']['forward_remark'];
                    }

                    $this->DtTravelVoucher->updateAll(array('travel_status' => 2, 'remark' => "'$remark'"), array(
                        'voucher_id' => $this->request->data['TravelWfLvl']['voucher_id'],
                        'emp_code' => $this->request->data['TravelWorkflow']['forward_emp_code']));
                    $this->TravelWfLvl->updateAll(array('voucher_status' => 2), array('id' => $check['TravelWfLvl']['id']));
                }

                if ($this->EmpDetail->getlaststagelevel(1) == 0) {

                    $this->DtTravelVoucher->updateAll(
                            array('DtTravelVoucher.travel_status' => '2'), array('DtTravelVoucher.voucher_id' => $this->request->data['TravelWfLvl']['voucher_id'])
                    );
                } else {

                    $this->DtTravelVoucher->updateAll(
                            array('DtTravelVoucher.travel_status' => '5'), array('DtTravelVoucher.voucher_id' => $this->request->data['TravelWfLvl']['voucher_id'])
                    );
                }
                $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                            <a href="#" class="uk-alert-close uk-close"></a>Travel Voucher Forwarded !!!</div>');
                $this->redirect(array('controller' => 'travels', 'action' => 'approval'));
            } else if ($this->request->data['TravelWorkflow']['type'] == 3) {
                $save1 = array();
                $save = array();
                $save['id'] = $this->request->data['TravelWfLvl']['id'];
                $save['remark'] = $this->request->data['TravelWorkflow']['revert_remark'];
                $save['voucher_status'] = 3;
                $save['fw_date'] = '';
                $this->TravelWfLvl->save($save);
                $check = $this->TravelWfLvl->find('first', array('conditions' => array(
                        'voucher_id' => $this->request->data['TravelWfLvl']['voucher_id'],
                        'emp_code' => $this->request->data['TravelWorkflow']['revert_emp_code'])));
                if (empty($check)) {
                    $save1['voucher_id'] = $this->request->data['TravelWfLvl']['voucher_id'];
                    $save1['emp_code'] = $this->request->data['TravelWorkflow']['revert_emp_code'];
                    $save1['voucher_status'] = 2;
                    $this->TravelWfLvl->save($save1);
                } else {
                    $revert_reason = $this->request->data['TravelWorkflow']['revert_remark'];
                    $this->TravelWfLvl->updateAll(array('fw_date' => null), array('id' => $check['TravelWfLvl']['id']));
                    $this->DtTravelVoucher->updateAll(array('DtTravelVoucher.travel_status' => '3', 'remark' => "'$revert_reason'"), array('DtTravelVoucher.voucher_id' => $this->request->data['TravelWfLvl']['voucher_id'])
                    );
                }
                unset($save1);
                unset($save);
                $this->Session->setFlash('Travel  Voucher Reverted.');
                $this->redirect(array('controller' => 'travels', 'action' => 'approval'));
            } else if ($this->request->data['TravelWorkflow']['type'] == 4) {

                $remark = $this->request->data['TravelWorkflow']['reject_remark'];
                $lv_rej = $this->DtTravelVoucher->updateAll(
                        array(
                    'DtTravelVoucher.travel_status' => '4', 'remark' => "'$remark'"), array(
                    'DtTravelVoucher.id' => $this->request->data['TravelWfLvl']['voucher_id'])
                );
                if ($lv_rej) {
                    $newsave = array();
                    $newsave['id'] = $this->request->data['TravelWfLvl']['id'];
                    $newsave['voucher_id'] = $this->request->data['TravelWfLvl']['voucher_id'];
                    $newsave['emp_code'] = $this->Auth->User('emp_code');
                    $newsave['remark'] = $this->request->data['TravelWorkflow']['reject_remark'];
                    $newsave['approval_date'] = date('Y-m-d');
                    $newsave['voucher_status'] = '4';
                    $this->TravelWfLvl->save($newsave);
                    $updatSts = $this->TravelWfLvl->updateAll(
                            array('TravelWfLvl.voucher_status' => 4), array(
                        'TravelWfLvl.voucher_id' => $this->request->data['TravelWfLvl']['voucher_id'], 'TravelWfLvl.fw_date !=' => null)
                    );
                    $this->Session->setFlash('Travel Voucher Rejected', false, array('class' => 'flash flash_error'));
                    $this->redirect(array('controller' => 'travels', 'action' => 'approval'));
                }
            } else if ($this->request->data['TravelWorkflow']['type'] == 6) {
                $save = array();
                $save['id'] = $this->request->data['TravelWfLvl']['id'];
                $save['remark'] = $this->request->data['TravelWorkflow']['hr_forward_remark'];
                $save['fw_date'] = date('Y-m-d');
                $save['voucher_status'] = '6';
                $this->TravelWfLvl->save($save);
                unset($save);
                $lv_app = $this->DtTravelVoucher->updateAll(
                        array('DtTravelVoucher.travel_status' => '6'), array('DtTravelVoucher.voucher_id' => $this->request->data['TravelWfLvl']['voucher_id'])
                );

                //Forward to HR             
                $newsave = array();
                $newsave['voucher_id'] = $this->request->data['TravelWfLvl']['voucher_id'];
                $newsave['emp_code'] = $this->request->data['TravelWorkflow']['hr_emp_code'];

                $this->TravelWfLvl->create();
                $this->TravelWfLvl->save($newsave);
                $this->Session->setFlash('Travel Voucher Forwarded to HR', false, array('class' => 'flash flash_error'));
                $this->redirect(array('controller' => 'travels', 'action' => 'approval'));
            } else if ($this->request->data['TravelWorkflow']['type'] == 5) {

                $mstLeave = $this->MstEmpExpVoucher->find('first', array('conditions' => array('voucher_id' => $this->request->data['TravelWfLvl']['voucher_id'])));
                $tempLeave = array();
                $newsave = array();
                $newsave['id'] = $this->request->data['TravelWfLvl']['id'];
                $newsave['voucher_id'] = $this->request->data['TravelWfLvl']['voucher_id'];
                $newsave['emp_code'] = $this->Auth->User('emp_code');
                $newsave['remark'] = $this->request->data['TravelWorkflow']['approve_remark'];
                $newsave['approval_date'] = date('Y-m-d');
                $newsave['voucher_status'] = '5';
                $this->TravelWfLvl->save($newsave);
                $updatSts = $this->TravelWfLvl->updateAll(
                        array('TravelWfLvl.voucher_status' => 5), array(
                    'TravelWfLvl.voucher_id' => $this->request->data['TravelWfLvl']['voucher_id'], 'TravelWfLvl.fw_date !=' => null)
                );
                $remark = $this->request->data['TravelWorkflow']['approve_remark'];
                $lv_app = $this->DtTravelVoucher->updateAll(
                        array('DtTravelVoucher.travel_status' => 5, 'remark' => "'$remark'"), array(
                    'DtTravelVoucher.id' => $this->request->data['TravelWfLvl']['voucher_id'])
                );
                $this->Session->setFlash('Travel Voucher Approved Successfully', false, array('class' => 'flash flash_error'));
                $this->redirect(array('controller' => 'travels', 'action' => 'approval'));
            }
        }
        $this->redirect(array('controller' => 'travels', 'action' => 'approval'));
    }

    public function employee_travel_report() {
        //Configure::write('debug',2);
        $this->layout = 'employee-new';
        $auth = $this->Session->read('Auth');
        $orgID = $auth['MyProfile']['comp_code'];
        $flag = '';
        if (isset($this->request->data['submit']) && $this->request->data['submit'] != '') {
            if (($this->request->data['voucher_status'] == '0' || $this->request->data['voucher_status'] == '') && $this->request->data['from_date'] == '' && $this->request->data['end_date'] == '') {
                $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert="">
                            <a href="#" class="uk-alert-close uk-close"></a>Please Enter Atleast One Value !!!!</div>');
                $this->redirect('employee_travel_report');
            }

            if ($this->request->data['voucher_status'] != '0' && $this->request->data['voucher_status'] != '') {
                $ANDconditions['DtTravelVoucher.travel_status'] = $this->request->data['voucher_status'];

                $vouch_status = $this->request->data['voucher_status'];
            }
             if (!empty($this->request->data['Employee'])) {
                     $ORconditions['DtTravelVoucher.emp_code'] = $this->request->data['Employee'];
                    $emp_group = $this->request->data['Employee'];
                 $emp_group = base64_encode(serialize($emp_group));  
            }
            

            if ($this->request->data['from_date'] != '' && $this->request->data['end_date'] != '') {
                $from_date = date('Y-m-d', strtotime($this->request->data['from_date']));
                $end_date = date('Y-m-d', strtotime($this->request->data['end_date']));
                $ORconditions['DtTravelVoucher.tour_start_date between ? and ?'] = array($from_date, $end_date);
            }

            
           





             $ORconditions['mst.comp_code'] = $orgID;
            $conditions = array($ORconditions);
            

            $VoucherDetails = $this->DtTravelVoucher->find('all', array(
                'fields' => array('*'),
                'joins' => array(
                    array(
                        'table' => 'mst_emp_exp_voucher',
                        'alias' => 'mst',
                        'type' => 'inner',
                        'foreignKey' => false,
                        'conditions' => array('mst.voucher_id = DtTravelVoucher.voucher_id')
                    )
                ),
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
            $this->set(compact('VoucherDetails', 'flag', 'vouch_status','emp_group', 'from_date', 'end_date'));
        }
        $voucherStatus = array('0' => '---Select---', '2' => 'Pending', '5' => 'Approved', '4' => 'Rejected');
        $this->set(compact('voucherStatus'));
    }

    public function travel_payment_status() {
        $this->layout = 'employee-new';
        $auth = $this->Session->read('Auth');
        if (isset($this->request->data['submit']) && $this->request->data['submit'] != '') {
            if (!empty($this->request->data['id'])) {
                foreach ($this->request->data['id'] as $val) {
                    $PaymentUpdate = $this->DtTravelVoucher->updateAll(array('DtTravelVoucher.payment_status' => $this->request->data['payment_status']), array('DtTravelVoucher.id' => $val));
                }
                $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                            <a href="#" class="uk-alert-close uk-close"></a>Payment Status Updated Successfully !!</div>');
                $this->redirect('employee_travel_report');
            } else {
                $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert="">
                            <a href="#" class="uk-alert-close uk-close"></a>Sorry, there is no record to update payment status !!</div>');
                $this->redirect('employee_travel_report');
            }
        } else {
            $this->redirect('employee_travel_report');
        }
    }
    
    public function getLocalExpDetail($voucher_id){
        $details = $this->LocalExp->find('all',
                array('conditions'=>array('tr_voucher_id'=>$voucher_id)
                    ));
        $this->set('details',$details);
    }

    public function generate_emp_travel_report_pdf($from_date = null, $end_date = null, $voucher_status = null,$emp_group) {
        Configure::write('debug',2);
          $emp_group =  unserialize(base64_decode($emp_group));
        $this->layout = 'employee-new';
        $auth = $this->Session->read('Auth');
        $orgID = $auth['MyProfile']['comp_code'];

        if ($from_date != 'null' && $end_date != 'null') {
            $ORconditions['DtTravelVoucher.tour_start_date between ? and ?'] = array($from_date, $end_date);
        }

        if ($from_date != 'null' && $end_date != 'null') {
            $ORconditions['DtTravelVoucher.tour_end_date between ? and ?'] = array($from_date, $end_date);
        }
         if (!empty($emp_group)) {
            $ORconditions['DtTravelVoucher.emp_code'] = $emp_group;
        }

        if ($voucher_status != 'null') {
            $ANDconditions['DtTravelVoucher.travel_status'] = $voucher_status;
        }


        $ANDconditions['mst.comp_code'] = $orgID;
        $conditions = array($ANDconditions,
            'OR' => $ORconditions);
        $VoucherDetails = $this->DtTravelVoucher->find('all', array(
            'fields' => array('*'),
            'joins' => array(
                array(
                    'table' => 'mst_emp_exp_voucher',
                    'alias' => 'mst',
                    'type' => 'inner',
                    'foreignKey' => false,
                    'conditions' => array('mst.voucher_id = DtTravelVoucher.voucher_id')
                )
            ),
            'conditions' => $conditions
        ));
        App::import('Vendor', 'TCpdf', array('file' => 'mpdf60/mpdf.php'));
        $this->layout = 'pdf';
        $this->set('pdf', new mPDF('utf-8', array(350, 500)));
        $this->set('VoucherDetails', $VoucherDetails);
    }

}
