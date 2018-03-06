<?php

App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');
App::import('uploader');

class UsersController extends AppController {

    public $name = 'Users';
    public $uses = array('WeekHolidayList', 'EmpEvent', 'TaskAssign', 'MstLogo', 'MomAssign', 'BMMeetingRequestRefnum', 'Tasksprojectmodule', 'MstEmpExpVoucher', 'ConveyencExpenseDetail', 'Tasksproject', 'Holiday', 'AttendanceDetail', 'AttendanceDetailDtl1', 'EmpAddress', 'UserDetail', 'Icon', 'IconUser', 'UserAudittrail', 'MyProfile', 'KraKpiProcess', 'LabelPage', 'LabelBlock', 'Labels', 'Ticker', 'TickerUser', 'Departments', 'Event', 'Separation', 'DtTravelVoucher', 'DtExpVoucher', 'EmpDocuments', 'ImportantDocCategory', 'ImportantDoc', 'DependentDetails', 'MedicalBillAmount', 'LtaBillAmount', 'LeaveEncsh', 'EmployeeSalMon', 'EmpEdu', 'EmpExp', 'AdminOptions', 'Company', 'LeaveDetails', 'FinancialYear', 'Attendanceworkflow', 'WfPaginateLvl', 'WfMstStatus');
    public $helpers = array('Js', 'Html', 'Form', 'Session', 'Userdetail', 'Common');
    public $components = array('Auth', 'Session', 'Email', 'Cookie', 'EmpDetail', 'Common', 'RequestHandler');

    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('get_attendance_details', 'forgetpwd', 'reset', 'getInOutTime');
        $currentUser = $this->checkUser();
    }

    public function index() {
        $this->layout = 'default';
        if ($this->loggedIn) {
            $this->redirect(array('controller' => 'users', 'action' => 'dashboard'));
        } else {
            $this->redirect(array('controller' => 'users', 'action' => 'login'));
        }
    }

    public function login() {
		 $arr = new Model(array('table' => 'setup_check', 'ds' => 'default', 'name' => 'Setup'));
        $val = $arr->find('all', array('conditions' => array('Setup.status' => 0)));
        if (!empty($val)) {
            $this->redirect(array('controller' => 'Setup', 'action' => 'select_country'));
            exit();
        }
        $this->layout = 'employee-login';
        $logo = $this->MstLogo->find('first');
        $this->set('logo', $logo['MstLogo']['logo_file']);
        $company_list = $this->Company->find('list', array(
            'fields' => array('comp_code', 'comp_name'),
            'conditions' => array('status' => 1)
        ));
        $this->set('company_list', $company_list);
        try {
            if ($this->Auth->user('id')) {
                $this->redirect(array('controller' => 'users', 'action' => 'dashboard'));
            }
            //print_r($this->request->data); die;
            if (!empty($this->request->data)) {
                if ($this->Auth->login()) {
                    $id = $this->Auth->user('id');
                    if (!empty($id)) {
                        $profile = $this->MyProfile->find('first', array('conditions' => array('emp_code' => $this->Auth->user('emp_code'))));
                        $logo = $this->MstLogo->find('first', array('conditions' => array('org_id' => $this->Auth->user('comp_code'))));

                        $fYear = $this->FinancialYear->find('first', array('conditions' => array('org_id' => $this->Auth->user('comp_code')), 'fields' => array('*'), 'order' => 'id desc'));


                        $this->Session->write('Auth.User.logo', $logo['MstLogo']['logo_file']);

                        $this->Session->write('Auth.User.user_type', 'Employees');
                        $this->Session->write('Auth.MyProfile', $profile['MyProfile']);

                        $this->Session->write('Auth.User.financial_year', $fYear['FinancialYear']['id']);
                        //print_r($profile['MyProfile']['status']);
                        if ($profile['MyProfile']['status'] != 32) {//die("asss");
                            $this->request->data = null;
                            $this->Session->setFlash($this->Auth->loginError);
                            $this->Auth->logout();
                        } else {
//die("aaa");
                            $this->aftersavelogin();
                            $this->request->data = null;
                            $this->Auth->redirectUrl();
                            $this->redirect($this->referer());
                        }
                    } else {
//die("aaabbb");
                        $this->request->data = null;
                        $this->Session->setFlash($this->Auth->loginError);
                    }
                } else {
//die("aaaccc");
                    $this->request->data = null;
                    $this->Session->setFlash($this->Auth->loginError);
                }
            }
        } catch (Exception $e) {
            echo 'Caught exception: ', $e->getMessage(), "\n";
            exit;
        }
    }

    public function get_ip() {
        /* Get ip address of login system */
        if (isset($_SERVER["HTTP_CF_CONNECTING_IP"])) {
            return $_SERVER['HTTP_CF_CONNECTING_IP'];
        }
        if (isset($_SERVER["HTTP_X_FORWARDED_FOR"])) {
            return $_SERVER['HTTP_X_FORWARDED_FOR'];
        }
        if (isset($_SERVER["REMOTE_ADDR"])) {
            return $_SERVER['REMOTE_ADDR'];
        }
    }

    public function aftersavelogin() {
        $us_data = array();
        /* Save data for user_detail table */
        $is_first_login = $this->UserDetail->find('first', array('field' => array('last_login'), 'conditions' => array('id' => $this->Auth->user('id'))));
        if ($is_first_login['UserDetail']['last_login'] == NULL) {
            $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert="">
            <a href="#" class="uk-alert-close uk-close"></a>Your Password is deflaut password , please change the same to be Secure.</div>');

         //   $this->redirect('changepass/1');
        }
        $us_data['id'] = $this->Auth->user('id');
        $us_data['last_login'] = date('Y-m-d h:i:s');
        $us_data['session_id'] = $this->Session->id();
        $us_data['status'] = 1;
        $us_data['login_ip'] = $this->get_ip();
        $this->UserDetail->save($us_data);
        unset($us_data);
        $other = '';
        $this->audittrail('login', $other);
    }

    public function logout() {
        Configure::write('debug', 2);
        try {

            if ($this->Auth->user('id')) {
                $data = array();
                $data['id'] = $this->Auth->user('id');
                $data['session_id'] = NULL;
                $data['status'] = 0;
                // $this->UserDetail->save($data);
                $other = '';
                $this->audittrail('logout', $other);
            }
            $this->Session->delete('Auth');
            $this->Session->destroy();
            $this->redirect($this->Auth->logout());
        } catch (Exception $e) {
            echo 'logout exception: ', $e->getMessage(), "\n";
            exit;
        }
    }

    public function audittrail($action = NULL, $other) {
        $ad_data = array();

        /* Save data for audit/trail table */
        // $ad_data['id'] = $this->UserAudittrail->getMaxid();
        $ad_data['user_id'] = $this->Auth->user('id');
        $ad_data['ip'] = $this->get_ip();
        $ad_data['time'] = date('Y-m-d h:i:s');
        $ad_data['browser'] = $_SERVER['HTTP_USER_AGENT'];
        $ad_data['action'] = $action;
        $ad_data['other'] = $other;

        $this->UserAudittrail->save($ad_data);

        unset($ad_data);
    }

    public function afterLoginSessionset() {
        
    }

    public function dashboard() {
        //Configure::write('debug',2);
        $this->layout = 'employee-new';
        $logo = $this->MstLogo->find('first', array('conditions' => array('org_id' => $this->Auth->User('comp_code'))));
        $this->set('logo', $logo['MstLogo']['logo_file']);
        if (null == $this->Auth->User('emp_code')) {
            $this->redirect('login');
        }
        $currentUser = $auth['MyProfile']['id'];

        if ($this->Common->check_access_right($this->Auth->User('emp_code'), $this->Auth->User('comp_code'), 'ceo_dashboard', 'approval')) {
            $this->redirect('ceodashboard');
        }
        $myprofile_id = $this->MyProfile->find('first', array(
            'fields' => array('id', 'dept_code'),
            'conditions' => array('emp_code' => $this->Auth->User('emp_code'))
        ));
        $department = $this->Departments->find('first', array(
            'fields' => array('id'),
            'conditions' => array('dept_code' => $myprofile_id['MyProfile']['dept_code'])));
        $id = $myprofile_id['MyProfile']['id'];
        $tickers = $this->TickerUser->find('all', array(
            'fields' => array('ticker_id'),
            'conditions' => array('myprofile_id' => $id)
        ));
        $icons = $this->IconUser->find('all', array(
            'fields' => array('icon_id'),
            'conditions' => array('myprofile_id' => $id)
        ));
        $tickerName = array();
        foreach ($tickers as $ticker) {
            $tickerName[] = $this->Ticker->find('first', array(
                'fields' => array('name', 'function_name'),
                'conditions' => array('id' => $ticker['TickerUser']['ticker_id'])
            ));
        }
        $this->MyProfile->recursive = -1;
        $bdaylist = $this->MyProfile->find('all', array(
            'fields' => array('MyProfile.emp_full_name', 'MyProfile.emp_code', 'MyProfile.image', 'MyProfile.dob'),
            'conditions' => array('status' => '32', 'MONTH(dob)' => date('m'), 'DAY(dob)' => date('d')
            ),
            'order' => 'dob asc'
        ));
        $this->MyProfile->recursive = -1;
        $bdayUpcoming = $this->MyProfile->find('all', array(
            'fields' => array('MyProfile.emp_firstname', 'MyProfile.dob'),
            'conditions' => array('status' => '32', 'MONTH(dob)' => date('m'), 'DAY(dob) >' => date('d')),
            'limit' => 2,
            'order' => 'DAY(dob) asc'
        ));

        $this->set('bday_today', $bdaylist);
        $this->set('bday_upcoming', $bdayUpcoming);
        $iconName = array();
        foreach ($icons as $icon) {
            $iconName[] = $this->Icon->find('first', array(
                'fields' => array('shortcut_name', 'function_name', 'image'),
                'conditions' => array('id' => $icon['IconUser']['icon_id'])
            ));
        }
        if (!empty($icons)) {
            $this->set('icon', $iconName);
        } else {
            $defaulticon = $this->Icon->find('all', array(
                'fields' => array('shortcut_name', 'function_name'),
                'conditions' => array('department_id' => $department['Departments']['id'], 'status' => 1)
            ));
            $this->set('icon', $defaulticon);
        }

        if (!empty($tickers)) {
            $this->set('ticker', $tickerName);
        } else {
            $defaultticker = $this->Ticker->find('all', array(
                'fields' => array('name', 'function_name'),
                'conditions' => array('department_id' => $department['Departments']['id'], 'status' => 1)
            ));
            $this->set('ticker', $defaultticker);
        }

        //------------------Getting Task Details on Dash board -----------//
        $emp_code = $this->Auth->User('emp_code');
        $comp_code = $this->Auth->User('comp_code');
        $this->paginate = array(
            'fields' => array('*'),
            'limit' => 5,
            'order' => 'TaskAssign.tid ASC',
            'joins' => array(
                array(
                    'table' => 'task_assign_emp',
                    'alias' => 'Assigned',
                    'type' => 'LEFT',
                    'foreignKey' => false,
                    'conditions' => array('Assigned.tid = TaskAssign.tid'
                    )),
                array(
                    'table' => 'task_alert',
                    'alias' => 'Alert',
                    'type' => 'LEFT',
                    'foreignKey' => false,
                    'conditions' => array('Alert.tid = TaskAssign.tid'
                    )),
            ),
            'fields' => array('TaskAssign.*', 'Assigned.*', 'Alert.statusid'),
            'conditions' => array('Assigned.emp_code' => $emp_code)
        );
        $notify = $this->getNotification();
        $leave_count = $this->Common->getLeaveCount($emp_code, $comp_code);
        $conveyance_count = $this->Common->getConveyanceCount($emp_code, $comp_code);
        $travel_count = $this->Common->getTravelCount($emp_code, $comp_code);
        //$mom_count = $this->Common->getMomCount($emp_code, $comp_code);
        $count2 = $this->TaskAssign->find('count', array(
            'conditions' => array(),
            'joins' => array(
                array(
                    'table' => 'task_assign_emp',
                    'alias' => 'Assigned',
                    'type' => 'LEFT',
                    'conditions' => array(
                        'Assigned.tid = TaskAssign.tid'
                    )
                ),
            ),
            'fields' => array(
                'TaskAssign.*',
                'Assigned.*'
            ), 'conditions' => array('Assigned.emp_code' => $emp_code, 'TaskAssign.status' => 0)
        ));

        $data = $this->paginate('TaskAssign');
        $this->set('mom_count', $mom_count);
        $this->set('leave_count', $leave_count);
        $this->set('conveyance_count', $conveyance_count);
        $this->set('travel_count', $travel_count);
        $this->set('count2', $count2);
        $this->set('assignedTask', $data);
        ///// get Total Kra Target For Appraiser /////

        $appraiserKraTarget = $this->Common->getTotalKraTargetForAppraiser($this->Auth->User('emp_code'));
        //echo count($appraiserKraTarget);die;
        if (count($appraiserKraTarget) == 0 || empty($appraiserKraTarget)) {
            $this->set('appraiserKraTargetCount', 0);
            $this->Session->write('sessAppraiserKraTargetCount', 0);
        } else {
            $this->set('appraiserKraTargetCount', count($appraiserKraTarget));
            $this->Session->write('sessAppraiserKraTargetCount', count($appraiserKraTarget));
        }

        ///// End Total Kra Target For Appraiser /////
        ///// get Total Kra Target For Reviewer /////

        $reviewerKraTarget = $this->Common->getTotalKraTargetForReviewer($this->Auth->User('emp_code'));

        if (count($reviewerKraTarget) == 0 || empty($reviewerKraTarget)) {
            $this->set('reviewerKraTargetCount', 0);
            $this->Session->write('sessReviewerKraTargetCount', 0);
        } else {
            $this->set('reviewerKraTargetCount', count($reviewerKraTarget));
            $this->Session->write('sessReviewerKraTargetCount', count($reviewerKraTarget));
        }

        ///// End Total Kra Target For Appraiser /////
        ///// get Total Kra Target For Moderator /////

        $moderatorKraTarget = $this->Common->getTotalKraTargetForModerator($this->Auth->User('emp_code'));
        if (count($moderatorKraTarget) == 0 || empty($moderatorKraTarget)) {
            $this->set('moderatorKraTargetCount', 0);
            $this->Session->write('sessModeratorKraTargetCount', 0);
        } else {
            $this->set('moderatorKraTargetCount', count($moderatorKraTarget));
            $this->Session->write('sessModeratorKraTargetCount', count($moderatorKraTarget));
        }

        ///////////////////////////////FOR TEMPORARY COMPONENT //////////////////////////////////////////


        $san_temp = $this->Common->getTempApproval($this->Auth->User('emp_code'));
        if (count($san_temp) == 0 || empty($san_temp)) {
            $this->set('sanTempCount', 0);
            $this->Session->write('sess_temp_count', 0);
        } else {
            $this->set('sanTempCount', count($san_temp));
            $this->Session->write('sess_temp_count', count($san_temp));
        }

        if (count($san_temp) <= 0 || empty($san_temp)) {
            $this->set('sanTempCount', 0);
        } else if (count($san_temp) < 10) {
            $this->set('sanTempPerc', (count($san_temp) / 10) * 100);
        } else if (count($san_temp) < 20) {
            $this->set('sanTempPerc', (count($san_temp) / 20) * 100);
        }

        ///// End Total Kra Target For Moderator /////

        $san_lta = $this->Common->getLtaApproval($this->Auth->User('emp_code'));
        if (count($san_lta) == 0 || empty($san_lta)) {
            $this->set('sanLtaCount', 0);
            $this->Session->write('sess_lta_count', 0);
        } else {
            $this->set('sanLtaCount', count($san_lta));
            $this->Session->write('sess_lta_count', count($san_lta));
        }

        ///////////////////////////////FOR getting PMS config details //////////////////////////////////////////
        //Configure::write('debug',2);
        $kra_config = $this->Common->findKraMasterConfig($this->Auth->User('comp_code'));
        //print_r( $kra_config );die;
        if (empty($kra_config)) {
            $this->set('sanKraConfig', 0);
            $this->Session->write('sess_kra_config', 0);
        } else {
            $this->set('sanKraConfig', $kra_config);
            $this->Session->write('sess_kra_config', $kra_config);
        }
        ///////////////////////////
        ///// End LTA Claim////
        ////////////////////////////// FOR SANCTION MEDICAL//////////////////////////////////////

        $san_medical = $this->Common->getMedicalApproval($this->Auth->User('emp_code'));
        //print_r($san_medical);
        if (count($san_medical) == 0 || empty($san_medical)) {
            $this->set('sanMedicalCount', 0);
            $this->Session->write('sess_medical_count', 0);
        } else {
            $this->set('sanMedicalCount', count($san_medical));
            $this->Session->write('sess_medical_count', count($san_medical));
        }
        if (count($san_medical) <= 0 || empty($san_medical)) {
            $this->set('sanMedicalCount', 0);
        } else if (count($san_medical) < 10) {
            $this->set('sanMedicalPerc', (count($san_medical) / 10) * 100);
        } else if (count($san_medical) < 20) {
            $this->set('sanMedicalPerc', (count($san_medical) / 20) * 100);
        }
        $this->set("pending_medical_employee", $san_medical);

        ///////////////////////////////For Sanction Travel////////////////////////////////////
        $san_Travel = $this->Common->getTravelApproval($this->Auth->User('emp_code'));

        if (count($san_Travel) == 0 || empty($san_Travel)) {
            $this->set('sanTravelCount', 0);
            $this->Session->write('san_travel_count', 0);
        } else {
            $this->set('sanTravelCount', count($san_Travel));
            $this->Session->write('san_travel_count', count($san_Travel));
        }
        if (count($san_Travel) <= 0 || empty($san_Travel)) {
            $this->set('sanTravelPerc', 0);
        } else if (count($san_Travel) < 10) {
            $this->set('sanTravelPerc', (count($san_Travel) / 10) * 100);
        } else if (count($san_Travel) < 20) {
            $this->set('sanTravelPerc', (count($san_Travel) / 20) * 100);
        }
        $this->set("pending_travel_employee", $san_Travel);
        ///////////////////////////////For Sanction Convence////////////////////////////////////
        //////////////////////////For  Leave Encash Approval ////////////////////////////////////
        $san_encash = $this->Common->getEncashApproval($this->Auth->User('emp_code'));
        if (count($san_encash) == 0 || empty($san_encash)) {
            $this->set('san_encash_count', 0);
            $this->Session->write('san_encash_count', 0);
        } else {
            $this->set('san_encash_count', count($san_encash));
            $this->Session->write('san_encash_count', count($san_encash));
        }
        if (count($san_encash) <= 0 || empty($san_encash)) {
            $this->set('san_encash_prec', 0);
        } else if (count($san_encash) < 10) {
            $this->set('san_encash_prec', (count($san_encash) / 10) * 100);
        } else if (count($san_encash) < 20) {
            $this->set('san_encash_prec', (count($san_encash) / 20) * 100);
        }
        $this->set("pending_encash_employee", $san_encash);

        ///////////////////////////////For Sanction Leave////////////////////////////////////
        $san_Leave = $this->EmpDetail->getPendingLeave($this->Auth->User('emp_code'));
        if (count($san_Leave) == 0 || empty($san_Leave)) {
            $this->set('sanLeaveCount', 0);
            $this->Session->write('sess_leave_count', 0);
        } else {
            $this->set('sanLeaveCount', count($san_Leave));
            $this->Session->write('sess_leave_count', count($san_Leave));
        }
        if (count($san_Leave) <= 0 || empty($san_Leave)) {
            $this->set('sanLeavePerc', 0);
        } else if (count($san_Leave) < 10) {
            $this->set('sanLeavePerc', (count($san_Leave) / 10) * 100);
        } else if (count($san_Leave) < 20) {
            $this->set('sanLeavePerc', (count($san_Leave) / 20) * 100);
        }
        $this->set("pending_leave_employee", $san_Leave);
        $holidays_count = $this->Holiday->find('all', array('fields' => array('COUNT(*)'), 'conditions' => array(
                'org_id' => $_SESSION['Auth']['MyProfile']['comp_code'],
                'MONTH(holiday_date)' => date('m'))));
        //'location_id' => $_SESSION['Auth']['MyProfile']['location_code'],
        $this->set("holidays_count", $holidays_count[0][0]['COUNT(*)']);
    }

    public function ceodashboard() {
        //Configure::write('debug',2);
        $this->layout = 'employee-new';
        $logo = $this->MstLogo->find('first', array('conditions' => array('org_id' => $this->Auth->User('comp_code'))));
        $this->set('logo', $logo['MstLogo']['logo_file']);
        $auth = $this->Session->read('Auth');

        if (null == $this->Auth->User('emp_code')) {
            $this->redirect('login');
        }

        $currentUser = $auth['MyProfile']['id'];

        if ($this->Common->check_access_right($this->Auth->User('emp_code'), $this->Auth->User('comp_code'), 'ceo_dashboard', 'approval')) {
            $accessUser = $this->Auth->User('id');
        } else {
            $accessUser = "";
        }
        if ($accessUser == '') {
            //$this->redirect('login');
        }



        $myprofile_id = $this->MyProfile->find('first', array(
            'fields' => array('id', 'dept_code'),
            'conditions' => array('emp_code' => $this->Auth->User('emp_code'))
        ));
        $department = $this->Departments->find('first', array(
            'fields' => array('id'),
            'conditions' => array('dept_code' => $myprofile_id['MyProfile']['dept_code'])));
        $id = $myprofile_id['MyProfile']['id'];
        $tickers = $this->TickerUser->find('all', array(
            'fields' => array('ticker_id'),
            'conditions' => array('myprofile_id' => $id)
        ));
        $icons = $this->IconUser->find('all', array(
            'fields' => array('icon_id'),
            'conditions' => array('myprofile_id' => $id)
        ));
        $tickerName = array();
        foreach ($tickers as $ticker) {
            $tickerName[] = $this->Ticker->find('first', array(
                'fields' => array('name', 'function_name'),
                'conditions' => array('id' => $ticker['TickerUser']['ticker_id'])
            ));
        }
        //$birthdays_upcoming = $this->Commom->GetBdays();
        //$today_birthday = $this->Common->GetTodayBday();
        $this->MyProfile->recursive = -1;
        $bdaylist = $this->MyProfile->find('all', array(
            'fields' => array('MyProfile.emp_full_name', 'MyProfile.emp_code', 'MyProfile.image', 'MyProfile.dob'),
            'conditions' => array('status' => '32', 'MONTH(dob)' => date('m'), 'DAY(dob)' => date('d')
            )
        ));

        $this->MyProfile->recursive = -1;
        $bdayUpcoming = $this->MyProfile->find('all', array(
            'fields' => array('MyProfile.emp_firstname', 'MyProfile.dob'),
            'conditions' => array('status' => '32', 'MONTH(dob)' => date('m'), 'DAY(dob) >=' => date('d')),
            'limit' => 2,
            'order' => 'dob asc'
        ));

        $this->set('bday_today', $bdaylist);
        $this->set('bday_upcoming', $bdayUpcoming);
        $iconName = array();
        foreach ($icons as $icon) {
            $iconName[] = $this->Icon->find('first', array(
                'fields' => array('shortcut_name', 'function_name', 'image'),
                'conditions' => array('id' => $icon['IconUser']['icon_id'])
            ));
        }
        if (!empty($icons)) {
            $this->set('icon', $iconName);
        } else {
            $defaulticon = $this->Icon->find('all', array(
                'fields' => array('shortcut_name', 'function_name'),
                'conditions' => array('department_id' => $department['Departments']['id'], 'status' => 1)
            ));
            $this->set('icon', $defaulticon);
        }

        if (!empty($tickers)) {
            $this->set('ticker', $tickerName);
        } else {
            $defaultticker = $this->Ticker->find('all', array(
                'fields' => array('name', 'function_name'),
                'conditions' => array('department_id' => $department['Departments']['id'], 'status' => 1)
            ));
            $this->set('ticker', $defaultticker);
        }

        //------------------Getting Task Details on Dash board -----------//
        $emp_code = $this->Auth->User('emp_code');
        $comp_code = $this->Auth->User('comp_code');
        $this->paginate = array(
            'fields' => array('*'),
            'limit' => 5,
            'order' => 'TaskAssign.tid ASC',
            'fields' => array('TaskAssign.*')
        );
        //$notify = $this->getNotification();
        $leave_count = $this->Common->getAllLeaveCount($comp_code);
        $conveyance_count = $this->Common->getAllConveyanceCount($comp_code);
        $travel_count = $this->Common->getAllTravelCount($comp_code);
        $mom_count = $this->Common->getMomCount($emp_code, $comp_code);
        $attendace_Count = $this->Common->getAttenCount($emp_code, $comp_code);
        $employee_count = $this->Common->getEmpCount($comp_code);
        $count2 = $this->TaskAssign->find('count', array(
            'conditions' => array('TaskAssign.status' => 0)
        ));
        $this->set('attendace_Count', $attendace_Count);

        $data = $this->paginate('TaskAssign');
//        App::import("Model", "DtExpVoucher");
//        $model = new DtExpVoucher();
//        $month = date('m');
//        $conv_approved  = $model->find('all', array(
//            'conditions' => array(
//            'MONTH(claim_date) = '.$month),
//            'fields' => 'SUM(total_exp)',
//            ));
        //print_r($conv_approved); die;
        //$this->set('conv_count', $conv_approved[0][0]['SUM(total_exp)']);
        //////////////////Start Leave Chart/////////////////
        $lastDate = date('Y-m-d', strtotime('today - 30 days'));
        $curDate = date('Y-m-d');
        $conditions['LeaveDetail.leave_date between ? and ?'] = array($lastDate, $curDate);
        $conditions['MstEmpLeave.comp_code'] = $this->Auth->User('comp_code');
        $options = array(
            'conditions' => $conditions,
            'fields' => array('COUNT(`LeaveDetail`.`leave_id`) as `leave_count`', '`LeaveDetail`.`leave_code`'),
            'joins' => array('LEFT JOIN `leave_details` AS LeaveDetail ON `LeaveDetail`.`leave_id` = `MstEmpLeave`.`leave_id`'),
            'group' => '`LeaveDetail`.`leave_code`',
        );


        $leaveCharts = $this->MstEmpLeave->find('all', $options);
        $leaveType = array();
        if (!empty($leaveCharts)) {
            foreach ($leaveCharts as $val) {
                $leaveType[$val[0]['leave_count']] = $this->Common->findLeaveType($val['LeaveDetail']['leave_code']);
            }
        } else {
            $leaveType[1] = 'No Record';
        }

        ////////////////// End Leave Chart////////////////
        /////////////////Start Conveyance Chart////////////

        $dept_code = $auth['MyProfile']['dept_code'];
        $month = date('m');
        $ConveyanceCharts = $this->ConveyencExpenseDetail->find('all', array(
            'conditions' => array('org_id' => $this->Auth->User('comp_code'), 'MONTH(claim_date)' => $month),
            'fields' => 'sum(total_exp) as Total_exp,dept_code,org_id',
            'group' => 'dept_code'
        ));

        $ConvType = array();
        if (!empty($ConveyanceCharts)) {
            foreach ($ConveyanceCharts as $val) {
                $ConvType[$val[0]['Total_exp']] = $this->Common->findDepartmentNameByDeptCode($val['ConveyencExpenseDetail']['org_id'], $val['ConveyencExpenseDetail']['dept_code']);
            }
        } else {
            $ConvType[1] = 'No Record';
        }


        ///////////////////////////////////////////////////
        /////////////////Start Travels Chart////////////

        $dept_code = $auth['MyProfile']['dept_code'];
        $monthName = date('m');
        $TravelCharts = $this->DtTravelVoucher->find('all', array(
            'conditions' => array('DtTravelVoucher.org_id' => $this->Auth->User('comp_code'), 'MyProfile.comp_code' => $this->Auth->User('comp_code'), 'MONTH(DtTravelVoucher.tour_start_date)' => $monthName),
            'fields' => 'sum(DtTravelVoucher.total_expense) as Total_exp,DtTravelVoucher.org_id,MyProfile.dept_code',
            'joins' => array('LEFT JOIN `myprofile` AS MyProfile ON `MyProfile`.`emp_code` = `DtTravelVoucher`.`emp_code`'),
            'group' => 'MyProfile.dept_code'
        ));

        $TravType = array();
        if (!empty($TravelCharts)) {
            foreach ($TravelCharts as $val) {
                $TravType[$val[0]['Total_exp']] = $this->Common->findDepartmentNameByDeptCode($val['DtTravelVoucher']['org_id'], $val['MyProfile']['dept_code']);
            }
        } else {
            $TravType[1] = 'No Record';
        }


        ///////////////////////////////////////////////////
        /////////////////Start MOM Chart////////////

        $dept_code = $auth['MyProfile']['dept_code'];
        $MOMCharts = $this->MomAssign->find('all', array(
            'conditions' => array('MyProfile.comp_code' => $this->Auth->User('comp_code')),
            'fields' => 'COUNT(MomAssign.id) as tot_meeting,MomAssign.meeting_status,MyProfile.comp_code',
            'joins' => array('LEFT JOIN `myprofile` AS MyProfile ON `MyProfile`.`emp_code` = `MomAssign`.`createby`'),
            'group' => 'MomAssign.meeting_status'
        ));

        $MOMType = array();
        if (!empty($MOMCharts)) {
            foreach ($MOMCharts as $val) {
                $MOMType['a']['tot_meeting'][] = $val[0]['tot_meeting'];
                $MOMType['a']['status'][] = $this->Common->getMomStatus($val['MomAssign']['meeting_status']);
            }
        } else {
            $MOMType['a']['tot_meeting'][] = 1;
            $MOMType['a']['status'][] = 'No Record';
        }


        ///////////////////////////////////////////////////
        /////////////////Start BOM Chart////////////

        $dept_code = $auth['MyProfile']['dept_code'];
        $this->BMMeetingRequestRefnum->recursive = -1;
        $BOMCharts = $this->BMMeetingRequestRefnum->find('all', array(
            'conditions' => array('MyProfile.comp_code' => $this->Auth->User('comp_code')),
            'fields' => 'COUNT(BMMeetingRequestRefnum.id) as tot_meeting,BMMeetingRequestRefnum.finalize_status,MyProfile.comp_code',
            'joins' => array('LEFT JOIN `myprofile` AS MyProfile ON `MyProfile`.`id` = `BMMeetingRequestRefnum`.`created_by`'),
            'group' => 'BMMeetingRequestRefnum.finalize_status'
        ));

        $BOMType = array();
        if (!empty($BOMCharts)) {
            foreach ($BOMCharts as $val) {
                $BOMType['a']['tot_meeting'][] = $val[0]['tot_meeting'];
                $BOMType['a']['status'][] = $this->Common->getBOMStatus($val['BMMeetingRequestRefnum']['finalize_status']);
            }
        } else {
            $BOMType['a']['tot_meeting'][] = 1;
            $BOMType['a']['status'][] = 'No Record';
        }


        ///////////////////////////////////////////////////
        ///////////////// Start Attendance Chart//////////////


        $attanCharts = $this->AttendanceDetail->query("SELECT COUNT(id) as atten_count,atten_dt,leave_id From attendance_details
            WHERE YEARWEEK(atten_dt)=YEARWEEK(NOW())  group by atten_dt");
        //print_r($attanCharts); die;



        $day_Name = date('D');


        $dayName = array();
        $totAtten = array();
        if ($day_Name == 'Mon') {
            $totAtten['Atten']['days'] = array("Mon");
            foreach ($attanCharts as $val) {
                if (date('D', strtotime($val['attendance_details']['atten_dt'])) == 'Mon') {
                    if ($val['attendance_details']['leave_id'] != Null) {
                        $totAtten['Atten']['count'][] = '0';
                    } else {
                        $totAtten['Atten']['count'][] = $val['0']['atten_count'];
                    }
                }
            }
        } elseif ($day_Name == 'Tue') {
            $totAtten['Atten']['days'] = array("Mon", "Tue");
            foreach ($attanCharts as $val) {
                if (date('D', strtotime($val['attendance_details']['atten_dt'])) == 'Mon') {
                    if ($val['attendance_details']['leave_id'] != Null) {
                        $totAtten['Atten']['count'][] = '0';
                    } else {
                        $totAtten['Atten']['count'][] = $val['0']['atten_count'];
                    }
                } else if (date('D', strtotime($val['attendance_details']['atten_dt'])) == 'Tue') {
                    if ($val['attendance_details']['leave_id'] != Null) {
                        $totAtten['Atten']['count'][] = '0';
                    } else {
                        $totAtten['Atten']['count'][] = $val['0']['atten_count'];
                    }
                }
            }
        } elseif ($day_Name == 'Wed') {
            $totAtten['Atten']['days'] = array("Mon", "Tue", "Wed");
            foreach ($attanCharts as $val) {
                if (date('D', strtotime($val['attendance_details']['atten_dt'])) == 'Mon') {
                    if ($val['attendance_details']['leave_id'] != Null) {
                        $totAtten['Atten']['count'][] = '0';
                    } else {
                        $totAtten['Atten']['count'][] = $val['0']['atten_count'];
                    }
                } else if (date('D', strtotime($val['attendance_details']['atten_dt'])) == 'Tue') {
                    if ($val['attendance_details']['leave_id'] != Null) {
                        $totAtten['Atten']['count'][] = '0';
                    } else {
                        $totAtten['Atten']['count'][] = $val['0']['atten_count'];
                    }
                } else if (date('D', strtotime($val['attendance_details']['atten_dt'])) == 'Wed') {
                    if ($val['attendance_details']['leave_id'] != Null) {
                        $totAtten['Atten']['count'][] = '0';
                    } else {
                        $totAtten['Atten']['count'][] = $val['0']['atten_count'];
                    }
                }
            }
        } elseif ($day_Name == 'Thu') {
            $totAtten['Atten']['days'] = array("Mon", "Tue", "Wed", "Thu");
            foreach ($attanCharts as $val) {
                if (date('D', strtotime($val['attendance_details']['atten_dt'])) == 'Mon') {
                    if ($val['attendance_details']['leave_id'] != Null) {
                        $totAtten['Atten']['count'][] = '0';
                    } else {
                        $totAtten['Atten']['count'][] = $val['0']['atten_count'];
                    }
                } else if (date('D', strtotime($val['attendance_details']['atten_dt'])) == 'Tue') {
                    if ($val['attendance_details']['leave_id'] != Null) {
                        $totAtten['Atten']['count'][] = '0';
                    } else {
                        $totAtten['Atten']['count'][] = $val['0']['atten_count'];
                    }
                } else if (date('D', strtotime($val['attendance_details']['atten_dt'])) == 'Wed') {
                    if ($val['attendance_details']['leave_id'] != Null) {
                        $totAtten['Atten']['count'][] = '0';
                    } else {
                        $totAtten['Atten']['count'][] = $val['0']['atten_count'];
                    }
                } else if (date('D', strtotime($val['attendance_details']['atten_dt'])) == 'Thu') {
                    if ($val['attendance_details']['leave_id'] != Null) {
                        $totAtten['Atten']['count'][] = '0';
                    } else {
                        $totAtten['Atten']['count'][] = $val['0']['atten_count'];
                    }
                }
            }
            //$totAtten[] = '[200, 60, 120, 200]';
        } elseif ($day_Name == 'Fri') {
            $totAtten['Atten']['days'] = array("Mon", "Tue", "Wed", "Thu", "Fri");
            foreach ($attanCharts as $val) {
                if (date('D', strtotime($val['attendance_details']['atten_dt'])) == 'Mon') {
                    if ($val['attendance_details']['leave_id'] != Null) {
                        $totAtten['Atten']['count'][] = '0';
                    } else {
                        $totAtten['Atten']['count'][] = $val['0']['atten_count'];
                    }
                } else if (date('D', strtotime($val['attendance_details']['atten_dt'])) == 'Tue') {
                    if ($val['attendance_details']['leave_id'] != Null) {
                        $totAtten['Atten']['count'][] = '0';
                    } else {
                        $totAtten['Atten']['count'][] = $val['0']['atten_count'];
                    }
                } else if (date('D', strtotime($val['attendance_details']['atten_dt'])) == 'Wed') {
                    if ($val['attendance_details']['leave_id'] != Null) {
                        $totAtten['Atten']['count'][] = '0';
                    } else {
                        $totAtten['Atten']['count'][] = $val['0']['atten_count'];
                    }
                } else if (date('D', strtotime($val['attendance_details']['atten_dt'])) == 'Thu') {
                    if ($val['attendance_details']['leave_id'] != Null) {
                        $totAtten['Atten']['count'][] = '0';
                    } else {
                        $totAtten['Atten']['count'][] = $val['0']['atten_count'];
                    }
                } else if (date('D', strtotime($val['attendance_details']['atten_dt'])) == 'Fri') {
                    if ($val['attendance_details']['leave_id'] != Null) {
                        $totAtten['Atten']['count'][] = '0';
                    } else {
                        $totAtten['Atten']['count'][] = $val['0']['atten_count'];
                    }
                }
            }
        }



        $daysdata = '';
        $daysdata .= '[';
        $countdaysarr = count($totAtten['Atten']['days']);
        $i = 1;
        foreach ($totAtten['Atten']['days'] as $val) {
            $daysdata .= '"';
            $daysdata .= $val . '"';
            if ($i < $countdaysarr) {
                $daysdata .= ',';
            }
            $i++;
        }
        $daysdata .= ']';

        $AttenCount = '[' . implode(",", $totAtten['Atten']['count']) . ']';

        //////////////// End Attendance Chart/////////////////

        $this->set('AttenDAYS', $daysdata);
        $this->set('AttenCount', $AttenCount);
        $this->set('leaveType', $leaveType);
        $this->set('ConvType', $ConvType);
        $this->set('TravType', $TravType);
        $this->set('MOMType', $MOMType);
        $this->set('BOMType', $BOMType);
        $this->set('conveyance_count', $conveyance_count);
        $this->set('travel_count', $travel_count);
        $this->set('mom_count', $mom_count);
        $this->set('leave_count', $leave_count);
        $this->set('emp_count', $employee_count);
        $this->set('count2', $count2);
        $this->set('assignedTask', $data);


        ///// get Total Kra Target For Appraiser /////

        $appraiserKraTarget = $this->Common->getTotalKraTargetForAppraiser($this->Auth->User('emp_code'));

        if (count($appraiserKraTarget) == 0 || empty($appraiserKraTarget)) {
            $this->set('appraiserKraTargetCount', 0);
            $this->Session->write('sessAppraiserKraTargetCount', 0);
        } else {
            $this->set('appraiserKraTargetCount', count($appraiserKraTarget));
            $this->Session->write('sessAppraiserKraTargetCount', count($appraiserKraTarget));
        }

        ///// End Total Kra Target For Appraiser /////
        ///// get Total Kra Target For Reviewer /////
        ///// End Total Kra Target For Appraiser /////
        ///// End LTA Claim////
        ////////////////////////////// FOR SANCTION MEDICAL//////////////////////////////////////
        ///////////////////////////////For Sanction Travel////////////////////////////////////
        ///////////////////////////////For Sanction Leave////////////////////////////////////
    }

    public function managerdashboard() {
        //Configure::write('debug',2);
        $this->layout = 'employee-new';
        $logo = $this->MstLogo->find('first', array('conditions' => array('org_id' => $this->Auth->User('comp_code'))));
        $this->set('logo', $logo['MstLogo']['logo_file']);
        if (null == $this->Auth->User('emp_code')) {
            $this->redirect('login');
        }
        $auth = $this->Session->read('Auth');
//        
//        echo "<pre>";
//        print_r($auth = $this->Session->read('Auth'));die;
        $myprofile_id = $this->MyProfile->find('first', array(
            'fields' => array('id', 'dept_code'),
            'conditions' => array('emp_code' => $this->Auth->User('emp_code'))
        ));
        $department = $this->Departments->find('first', array(
            'fields' => array('id'),
            'conditions' => array('dept_code' => $myprofile_id['MyProfile']['dept_code'])));
        $id = $myprofile_id['MyProfile']['id'];
        $tickers = $this->TickerUser->find('all', array(
            'fields' => array('ticker_id'),
            'conditions' => array('myprofile_id' => $id)
        ));
        $icons = $this->IconUser->find('all', array(
            'fields' => array('icon_id'),
            'conditions' => array('myprofile_id' => $id)
        ));
        $tickerName = array();
        foreach ($tickers as $ticker) {
            $tickerName[] = $this->Ticker->find('first', array(
                'fields' => array('name', 'function_name'),
                'conditions' => array('id' => $ticker['TickerUser']['ticker_id'])
            ));
        }
        //$birthdays_upcoming = $this->Commom->GetBdays();
        //$today_birthday = $this->Common->GetTodayBday();
        $bdaylist = $this->MyProfile->find('all', array(
            'fields' => array('MyProfile.emp_full_name', 'MyProfile.emp_code', 'MyProfile.image', 'MyProfile.dob'),
            'conditions' => array('status' => '32', 'MONTH(dob)' => date('m'), 'DAY(dob)' => date('d')
            )
        ));
        $bdayUpcoming = $this->MyProfile->find('all', array(
            'fields' => array('MyProfile.emp_firstname', 'MyProfile.dob'),
            'conditions' => array('status' => '32', 'MONTH(dob)' => date('m'), 'DAY(dob) >=' => date('d')),
            'limit' => 2,
            'order' => 'dob asc'
        ));

        $this->set('bday_today', $bdaylist);
        $this->set('bday_upcoming', $bdayUpcoming);
        $iconName = array();
        foreach ($icons as $icon) {
            $iconName[] = $this->Icon->find('first', array(
                'fields' => array('shortcut_name', 'function_name', 'image'),
                'conditions' => array('id' => $icon['IconUser']['icon_id'])
            ));
        }
        if (!empty($icons)) {
            $this->set('icon', $iconName);
        } else {
            $defaulticon = $this->Icon->find('all', array(
                'fields' => array('shortcut_name', 'function_name'),
                'conditions' => array('department_id' => $department['Departments']['id'], 'status' => 1)
            ));
            $this->set('icon', $defaulticon);
        }

        if (!empty($tickers)) {
            $this->set('ticker', $tickerName);
        } else {
            $defaultticker = $this->Ticker->find('all', array(
                'fields' => array('name', 'function_name'),
                'conditions' => array('department_id' => $department['Departments']['id'], 'status' => 1)
            ));
            $this->set('ticker', $defaultticker);
        }

        //------------------Getting Task Details on Dash board -----------//
        $emp_code = $this->Auth->User('emp_code');
        $comp_code = $this->Auth->User('comp_code');
        $this->paginate = array(
            'fields' => array('*'),
            'limit' => 5,
            'order' => 'TaskAssign.tid ASC',
            'fields' => array('TaskAssign.*')
        );
        //$notify = $this->getNotification();
        $leave_count = $this->Common->getAllLeaveCount($comp_code);
        $conveyance_count = $this->Common->getAllConveyanceCount($comp_code);
        $travel_count = $this->Common->getAllTravelCount($comp_code);
        $mom_count = $this->Common->getMomCount($emp_code, $comp_code);
        $attendace_Count = $this->Common->getAttenCount($emp_code, $comp_code);
        $employee_count = $this->Common->getEmpCount($comp_code);
        $count2 = $this->TaskAssign->find('count', array(
            'conditions' => array('TaskAssign.status' => 0)
        ));
        $data = $this->paginate('TaskAssign');
//        App::import("Model", "DtExpVoucher");
//        $model = new DtExpVoucher();
//        $month = date('m');
//        $conv_approved  = $model->find('all', array(
//            'conditions' => array(
//            'MONTH(claim_date) = '.$month),
//            'fields' => 'SUM(total_exp)',
//            ));
        //print_r($conv_approved); die;
        //$this->set('conv_count', $conv_approved[0][0]['SUM(total_exp)']);
        //////////////////Start Leave Chart/////////////////
        $last_Date = date('Y-m-d', strtotime('today - 30 days'));
        $cur_Date = date('Y-m-d');
        $Allconditions['LeaveDetail.leave_date between ? and ?'] = array($last_Date, $cur_Date);
        $Allconditions['MyProfile.comp_code'] = $this->Auth->User('comp_code');
        $Allconditions['MyProfile.dept_code'] = $auth['MyProfile']['dept_code'];
        $EMPoptions = array(
            'conditions' => $Allconditions,
            'fields' => array('COUNT(`LeaveDetail`.`leave_id`) as `leave_count`', '`LeaveDetail`.`leave_code`'),
            'joins' => array('LEFT JOIN `myprofile` AS MyProfile ON `MyProfile`.`emp_code` = `LeaveDetail`.`emp_code`'),
            'group' => '`LeaveDetail`.`leave_code`',
        );
        $leaveCharts = $this->LeaveDetail->find('all', $EMPoptions);

        $leaveType = array();
        if (!empty($leaveCharts)) {
            foreach ($leaveCharts as $val) {
                $leaveType[$val[0]['leave_count']] = $this->Common->findLeaveType($val['LeaveDetail']['leave_code']);
            }
        } else {
            $leaveType[1] = 'No Record';
        }

        ////////////////// End Leave Chart////////////////
        /////////////////Start Conveyance Chart////////////

        $last_Date = date('Y-m-d', strtotime('today - 90 days'));
        $cur_Date = date('Y-m-d');
        $conditions['claim_date between ? and ?'] = array($last_Date, $cur_Date);

        $dept_code = $auth['MyProfile']['dept_code'];
        $month = date('m');
        $ConveyanceCharts = $this->ConveyencExpenseDetail->find('all', array(
            'conditions' => array('org_id' => $this->Auth->User('comp_code'), $conditions, 'dept_code' => $dept_code),
            'fields' => 'sum(total_exp) as Total_exp,dept_code,org_id,dept_code,claim_date',
            'group' => 'MONTH(claim_date)'
        ));

        $ConvType = array();
        if (!empty($ConveyanceCharts)) {
            foreach ($ConveyanceCharts as $val) {
                $ConvType[$val[0]['Total_exp']] = date('d-m-Y', strtotime($val['ConveyencExpenseDetail']['claim_date']));
            }
        } else {
            $ConvType[1] = 'No Record';
        }

        ///////////////////////////////////////////////////
        /////////////////Start Travels Chart////////////
        $last_Date = date('Y-m-d', strtotime('today - 90 days'));
        $cur_Date = date('Y-m-d');
        $condition['DtTravelVoucher.tour_start_date between ? and ?'] = array($last_Date, $cur_Date);

        $dept_code = $auth['MyProfile']['dept_code'];
        $monthName = date('m');
        $TravelCharts = $this->DtTravelVoucher->find('all', array(
            'conditions' => array('DtTravelVoucher.org_id' => $this->Auth->User('comp_code'), $condition, 'MyProfile.comp_code' => $this->Auth->User('comp_code'), 'MyProfile.dept_code' => $dept_code),
            'fields' => 'sum(DtTravelVoucher.total_expense) as Total_exp,DtTravelVoucher.org_id,MyProfile.dept_code',
            'joins' => array('LEFT JOIN `myprofile` AS MyProfile ON `MyProfile`.`emp_code` = `DtTravelVoucher`.`emp_code`'),
            'group' => 'MyProfile.dept_code'
        ));

        $TravType = array();
        if (!empty($TravelCharts)) {
            foreach ($TravelCharts as $val) {
                $TravType[$val[0]['Total_exp']] = $this->Common->findDepartmentNameByDeptCode($val['DtTravelVoucher']['org_id'], $val['MyProfile']['dept_code']);
            }
        } else {
            $TravType[1] = 'No Record';
        }
        ///////////////////////////////////////////////////
        /////////////////Start MOM Chart////////////

        $dept_code = $auth['MyProfile']['dept_code'];
        $MOMCharts = $this->MomAssign->find('all', array(
            'conditions' => array('MyProfile.comp_code' => $this->Auth->User('comp_code'), 'MyProfile.dept_code' => $dept_code),
            'fields' => 'COUNT(MomAssign.id) as tot_meeting,MomAssign.meeting_status,MyProfile.comp_code',
            'joins' => array('LEFT JOIN `myprofile` AS MyProfile ON `MyProfile`.`emp_code` = `MomAssign`.`createby`'),
            'group' => 'MomAssign.meeting_status'
        ));

        $MOMType = array();
        if (!empty($MOMCharts)) {
            foreach ($MOMCharts as $val) {
                $MOMType['a']['tot_meeting'][] = $val[0]['tot_meeting'];
                $MOMType['a']['status'][] = $this->Common->getMomStatus($val['MomAssign']['meeting_status']);
            }
        } else {
            $MOMType['a']['tot_meeting'][] = '1';
            $MOMType['a']['status'][] = 'No Record';
        }
        ///////////////////////////////////////////////////
        /////////////////Start BOM Chart////////////

        $dept_code = $auth['MyProfile']['dept_code'];
        $this->BMMeetingRequestRefnum->recursive = -1;
        $BOMCharts = $this->BMMeetingRequestRefnum->find('all', array(
            'conditions' => array('MyProfile.comp_code' => $this->Auth->User('comp_code'), 'MyProfile.dept_code' => $dept_code),
            'fields' => 'COUNT(BMMeetingRequestRefnum.id) as tot_meeting,BMMeetingRequestRefnum.finalize_status,MyProfile.comp_code',
            'joins' => array('LEFT JOIN `myprofile` AS MyProfile ON `MyProfile`.`id` = `BMMeetingRequestRefnum`.`created_by`'),
            'group' => 'BMMeetingRequestRefnum.finalize_status'
        ));

        $BOMType = array();
        if (!empty($BOMCharts)) {
            foreach ($BOMCharts as $val) {
                $BOMType['a']['tot_meeting'][] = $val[0]['tot_meeting'];
                $BOMType['a']['status'][] = $this->Common->getBOMStatus($val['BMMeetingRequestRefnum']['finalize_status']);
            }
        } else {
            $BOMType['a']['tot_meeting'][] = 1;
            $BOMType['a']['status'][] = 'No Record';
        }


        ///////////////////////////////////////////////////
        ///////////////// Start Attendance Chart//////////////

        $attanCharts = $this->AttendanceDetail->query("SELECT COUNT(id) as atten_count,atten_dt,leave_id From attendance_details
            WHERE YEARWEEK(atten_dt)=YEARWEEK(NOW()) and emp_dept_id = '" . $auth['MyProfile']['dept_code'] . "'  group by atten_dt");


        $day_Name = date('D');

        $dayName = array();
        $totAtten = array();
        if ($day_Name == 'Mon') {
            $totAtten['Atten']['days'] = array("Mon");
            foreach ($attanCharts as $val) {
                if (date('D', strtotime($val['attendance_details']['atten_dt'])) == 'Mon') {
                    if ($val['attendance_details']['leave_id'] != Null) {
                        $totAtten['Atten']['count'][] = '0';
                    } else {
                        $totAtten['Atten']['count'][] = $val['0']['atten_count'];
                    }
                }
            }
        } elseif ($day_Name == 'Tue') {
            $totAtten['Atten']['days'] = array("Mon", "Tue");
            foreach ($attanCharts as $val) {
                if (date('D', strtotime($val['attendance_details']['atten_dt'])) == 'Mon') {
                    if ($val['attendance_details']['leave_id'] != Null) {
                        $totAtten['Atten']['count'][] = '0';
                    } else {
                        $totAtten['Atten']['count'][] = $val['0']['atten_count'];
                    }
                } else if (date('D', strtotime($val['attendance_details']['atten_dt'])) == 'Tue') {
                    if ($val['attendance_details']['leave_id'] != Null) {
                        $totAtten['Atten']['count'][] = '0';
                    } else {
                        $totAtten['Atten']['count'][] = $val['0']['atten_count'];
                    }
                }
            }
        } elseif ($day_Name == 'Wed') {
            $totAtten['Atten']['days'] = array("Mon", "Tue", "Wed");
            foreach ($attanCharts as $val) {
                if (date('D', strtotime($val['attendance_details']['atten_dt'])) == 'Mon') {
                    if ($val['attendance_details']['leave_id'] != Null) {
                        $totAtten['Atten']['count'][] = '0';
                    } else {
                        $totAtten['Atten']['count'][] = $val['0']['atten_count'];
                    }
                } else if (date('D', strtotime($val['attendance_details']['atten_dt'])) == 'Tue') {
                    if ($val['attendance_details']['leave_id'] != Null) {
                        $totAtten['Atten']['count'][] = '0';
                    } else {
                        $totAtten['Atten']['count'][] = $val['0']['atten_count'];
                    }
                } else if (date('D', strtotime($val['attendance_details']['atten_dt'])) == 'Wed') {
                    if ($val['attendance_details']['leave_id'] != Null) {
                        $totAtten['Atten']['count'][] = '0';
                    } else {
                        $totAtten['Atten']['count'][] = $val['0']['atten_count'];
                    }
                }
            }
        } elseif ($day_Name == 'Thu') {
            $totAtten['Atten']['days'] = array("Mon", "Tue", "Wed", "Thu");
            foreach ($attanCharts as $val) {
                if (date('D', strtotime($val['attendance_details']['atten_dt'])) == 'Mon') {
                    if ($val['attendance_details']['leave_id'] != Null) {
                        $totAtten['Atten']['count'][] = '0';
                    } else {
                        $totAtten['Atten']['count'][] = $val['0']['atten_count'];
                    }
                } else if (date('D', strtotime($val['attendance_details']['atten_dt'])) == 'Tue') {
                    if ($val['attendance_details']['leave_id'] != Null) {
                        $totAtten['Atten']['count'][] = '0';
                    } else {
                        $totAtten['Atten']['count'][] = $val['0']['atten_count'];
                    }
                } else if (date('D', strtotime($val['attendance_details']['atten_dt'])) == 'Wed') {
                    if ($val['attendance_details']['leave_id'] != Null) {
                        $totAtten['Atten']['count'][] = '0';
                    } else {
                        $totAtten['Atten']['count'][] = $val['0']['atten_count'];
                    }
                } else if (date('D', strtotime($val['attendance_details']['atten_dt'])) == 'Thu') {
                    if ($val['attendance_details']['leave_id'] != Null) {
                        $totAtten['Atten']['count'][] = '0';
                    } else {
                        $totAtten['Atten']['count'][] = $val['0']['atten_count'];
                    }
                }
            }
            //$totAtten[] = '[200, 60, 120, 200]';
        } elseif ($day_Name == 'Fri') {
            $totAtten['Atten']['days'] = array("Mon", "Tue", "Wed", "Thu", "Fri");
            foreach ($attanCharts as $val) {
                if (date('D', strtotime($val['attendance_details']['atten_dt'])) == 'Mon') {
                    if ($val['attendance_details']['leave_id'] != Null) {
                        $totAtten['Atten']['count'][] = '0';
                    } else {
                        $totAtten['Atten']['count'][] = $val['0']['atten_count'];
                    }
                } else if (date('D', strtotime($val['attendance_details']['atten_dt'])) == 'Tue') {
                    if ($val['attendance_details']['leave_id'] != Null) {
                        $totAtten['Atten']['count'][] = '0';
                    } else {
                        $totAtten['Atten']['count'][] = $val['0']['atten_count'];
                    }
                } else if (date('D', strtotime($val['attendance_details']['atten_dt'])) == 'Wed') {
                    if ($val['attendance_details']['leave_id'] != Null) {
                        $totAtten['Atten']['count'][] = '0';
                    } else {
                        $totAtten['Atten']['count'][] = $val['0']['atten_count'];
                    }
                } else if (date('D', strtotime($val['attendance_details']['atten_dt'])) == 'Thu') {
                    if ($val['attendance_details']['leave_id'] != Null) {
                        $totAtten['Atten']['count'][] = '0';
                    } else {
                        $totAtten['Atten']['count'][] = $val['0']['atten_count'];
                    }
                } else if (date('D', strtotime($val['attendance_details']['atten_dt'])) == 'Fri') {
                    if ($val['attendance_details']['leave_id'] != Null) {
                        $totAtten['Atten']['count'][] = '0';
                    } else {
                        $totAtten['Atten']['count'][] = $val['0']['atten_count'];
                    }
                }
            }
        }



        $daysdata = '';
        $daysdata .= '[';
        $countdaysarr = count($totAtten['Atten']['days']);
        $i = 1;
        foreach ($totAtten['Atten']['days'] as $val) {
            $daysdata .= '"';
            $daysdata .= $val . '"';
            if ($i < $countdaysarr) {
                $daysdata .= ',';
            }
            $i++;
        }

        $daysdata .= ']';

        $AttenCount = '[' . implode(",", $totAtten['Atten']['count']) . ']';
        //////////////// End Attendance Chart/////////////////

        $this->set('AttenDAYS', $daysdata);
        $this->set('AttenCount', $AttenCount);
        $this->set('leaveType', $leaveType);
        $this->set('ConvType', $ConvType);
        $this->set('TravType', $TravType);
        $this->set('MOMType', $MOMType);
        $this->set('BOMType', $BOMType);
        $this->set('conveyance_count', $conveyance_count);
        $this->set('travel_count', $travel_count);
        $this->set('mom_count', $mom_count);
        $this->set('leave_count', $leave_count);
        $this->set('attendace_Count', $attendace_Count);

        $this->set('emp_count', $employee_count);
        $this->set('count2', $count2);
        $this->set('assignedTask', $data);


        ///// get Total Kra Target For Appraiser /////

        $appraiserKraTarget = $this->Common->getTotalKraTargetForAppraiser($this->Auth->User('emp_code'));
        if (count($appraiserKraTarget) == 0 || empty($appraiserKraTarget)) {
            $this->set('appraiserKraTargetCount', 0);
            $this->Session->write('sessAppraiserKraTargetCount', 0);
        } else {
            $this->set('appraiserKraTargetCount', count($appraiserKraTarget));
            $this->Session->write('sessAppraiserKraTargetCount', count($appraiserKraTarget));
        }

        ///// End Total Kra Target For Appraiser /////
        ///// get Total Kra Target For Reviewer /////
        ///// End Total Kra Target For Appraiser /////
        ///// End LTA Claim////
        ////////////////////////////// FOR SANCTION MEDICAL//////////////////////////////////////
        ///////////////////////////////For Sanction Travel////////////////////////////////////
        ///////////////////////////////For Sanction Leave////////////////////////////////////
    }

    function changepass($id) {
        if ($id) {
            $this->layout = "employee_d";
        } else {
            $this->layout = "employee-new";
        }
        if (!empty($this->request->data)) {

            if (trim($this->request->data['connewpass']) != trim($this->request->data['newpass'])) {
                $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert="">
            <a href="#" class="uk-alert-close uk-close"></a>New Password and Confirm Password do not match</div>');

                $this->redirect("changepass");
            }
            $oldPass = $this->UserDetail->find('first', array(
                'conditions' => array(
                    'UserDetail.id' => $this->Auth->user('id')
                )
            ));
            if (count($oldPass) > 0) {
                if ($oldPass['UserDetail']['user_password'] == $this->Auth->password(trim($this->request->data['newpass']))) {
                    $this->Session->setFlash('<div class="uk-alert uk-alert-info" data-uk-alert="">
            <a href="#" class="uk-alert-close uk-close"></a>Previous password will be not accepted.Please Choose Others password.</div>');

                    $this->redirect("changepass");
                }
                if ($oldPass['UserDetail']['user_password'] == $this->Auth->password(trim($this->request->data['old_pass']))) {
                    $this->UserDetail->id = $this->UserDetail->field('id', array('id' => $this->Auth->user('id')));
                    if ($this->UserDetail->id) {
                        $this->UserDetail->saveField('user_password', $this->Auth->password(trim($this->request->data['newpass'])));
                        $us_data = array();
                        $us_data['id'] = $this->Auth->user('id');
                        $us_data['last_login'] = date('Y-m-d h:i:s');
                        $us_data['session_id'] = $this->Session->id();
                        $us_data['status'] = 1;
                        $us_data['login_ip'] = $this->get_ip();
                        $this->UserDetail->save($us_data);
                        unset($us_data);
                        $other = '';
                        $this->audittrail('Change Password', $other);
                        $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
            <a href="#" class="uk-alert-close uk-close"></a>Password Changed Succesfully.</div>');
                        $this->redirect("logout");
                    }
                }
            }
        }
    }

    function forgetpwd() {
        //Configure::write('debug',2);
        $this->layout = "employee-login";
        $this->autoload = false;
        if (!empty($this->request->data)) {
            if (empty($this->request->data['email'])) {
                $this->Session->setFlash('Please Provide Your Email Adress that You used to Register with Us');
            } else {
                $email = $this->request->data['email'];
                $fu = $this->UserDetail->find('first', array('conditions' => array('UserDetail.email' => $email)));
                if ($fu) {
                    $key = Security::hash(String::uuid(), 'sha512', true);
                    $hash = sha1($fu['UserDetail']['user_name'] . rand(0, 100));
                    $url = 'http://' . $_SERVER['HTTP_HOST'] . $this->webroot . 'users/reset/' . $key . '#' . $hash;
                    $ms = $url;
                    $ms = wordwrap($ms, 1000);
                    $fu['UserDetail']['token'] = $key;
                    $this->UserDetail->id = $fu['UserDetail']['id'];
                    if ($this->UserDetail->saveField('token', $fu['UserDetail']['token'])) {
                        $this->Email->smtpOptions = array(
                            'port' => '25',
                            'timeout' => '120',
                            'host' => 'smtp.essindia.com',
                            'username' => 'ess-portal@essindia.com',
                            'password' => 'Ess1234$'
                        );
                        $this->Email->template = 'resetpw';
                        $this->Email->from = 'Your Email <ayush.pant@essindia.com>';
                        $this->Email->to = $fu['UserDetail']['user_name'] . '<' . $fu['UserDetail']['email'] . '>';
                        $this->Email->subject = 'Reset Your Ess Portal Password';
                        $this->Email->sendAs = 'both';

                        $this->Email->delivery = 'smtp';
                        $this->set('ms', $ms);
                        $name = $this->MyProfile->find('first', array('fields' => array('emp_firstname'), 'conditions' => array('emp_id' => $fu['UserDetail']['emp_id'])));
                        $this->set('name', $name['MyProfile']['emp_firstname']);

                        if ($this->Email->send()) {
                            $this->Session->setFlash(__('Check Your Email To Reset your password', true));
                            $this->redirect('login');
                        } else {
                            $this->Session->setFlash(__('Mail Not Sent', true));
                            $this->set('smtp_errors', $this->Email->smtpError);
                            $this->redirect('forgetpwd');
                        }
                        //============EndEmail=============//
                    } else {
                        $this->Session->setFlash("Error Generating Reset link");
                        $this->redirect('login');
                    }
                } else {
                    $this->Session->setFlash('Email does Not Exist');
                    $this->redirect('login');
                }
            }
        }
    }

    function reset($token = null) {
        //die;
        $this->layout = "employee-login";
        $this->UserDetail->recursive = -1;
        $this->set('token', $token);
        if (!empty($token)) {

            $u = $this->UserDetail->findBytoken($token);
            if ($u) {
                $this->UserDetail->id = $u['UserDetail']['id'];
                if (!empty($this->request->data)) {
                    if ($this->request->data['User']['password'] != $this->request->data['User']['password_confirm']) {
                        $this->Session->setFlash('Password and confirm password mistmatch');
                        $this->redirect(array('controller' => 'users', 'action' => 'login'));
                    }
                    if ($this->request->data['User']['password']) {
                        $data = array();
                        $data['token'] = '';
                        $data['user_password'] = $this->Auth->password(trim($this->request->data['User']['password']));
                        $data['id'] = $this->UserDetail->id;
                        $this->UserDetail->save($data);
                        $other = '';
                        $this->audittrail('Reset Password', $other);
                        $this->Session->setFlash('Password has been Updated');
                        $this->redirect(array('controller' => 'users', 'action' => 'login'));
                    }
                }
            } else {
                $this->Session->setFlash('Token Corrupted,Please Retry.the reset link work only for once.');
            }
        } else {
            $this->redirect('/');
        }
    }

    function myprofile($empCode = NULL) {
        if ($empCode != "") {
            $employeeCode = base64_decode($empCode);
            $hideEditButton = "displayNone";
        } else {
            $employeeCode = $this->Auth->User('emp_code');
            $hideEditButton = "";
        }
        $this->layout = 'employee-new';
        $profile = $this->MyProfile->find('all', array(
            'conditions' => array(
                'emp_code' => $employeeCode,
            )
        ));

        $changeAddStatus = $this->EmpAddress->find('first', array(
            'conditions' => array(
                'emp_code' => $employeeCode
            ),
            'order' => array('id desc')
        ));

        $myprofile_id = $profile[0]['MyProfile']['id'];


        /*         * *********************** code to find blocks ********************************** */
        $page_id = $this->LabelPage->find('first', array(
            'fields' => array('LabelPage.id', 'LabelPage.heading'),
            'conditions' => array('LabelPage.name' => 'myprofile')
        ));

        $emp_dept_id = $_SESSION['Auth']['MyProfile']['dept_code'];

        $department_id = $this->Department->find('first', array(
            'fields' => array('Department.dept_name'),
            'conditions' => array('Department.dept_code' => $emp_dept_id),
        ));

        $block = $this->LabelBlock->find('all', array(
            'fields' => array('*'),
            'conditions' => array('LabelBlock.label_page_id' => $page_id['LabelPage']['id']),
            'order' => array('LabelBlock.block_priority')
        ));
        $qualification = $this->EmpEdu->find('all', array('fields' => array('*'), 'conditions' => array('emp_code' => $this->Auth->User('emp_code'))));


        $this->set('pageheading', $page_id['LabelPage']['heading']);
        $this->set('block', $block);
        $user = $this->UserDetail->find('all', array(
            'conditions' => array(
                'emp_code' => $employeeCode,
            )
        ));

        $dependents = $this->DependentDetails->find('all', array(
            'conditions' => array(
                'myprofile_id' => $myprofile_id
            )
        ));
//echo '<pre>';print_r($dependents);//die;
        $per_exp = $this->EmpExp->find('all', array('fields' => array('*'), 'conditions' => array('emp_code' => $employeeCode)));


        $this->set('exp', $per_exp);
        $this->set('dependents', $dependents);
        $this->set('detail', $user[0]);
        $this->set('profile', $profile[0]);
        $manager_det = $this->MyProfile->find('first', array(
            'conditions' => array(
                'emp_code' => $profile[0]['MyProfile']['manager_code'],
            )
        ));
        $this->set('changeAddRemark', $changeAddStatus['EmpAddress']['remark']);
        $this->set('emp_code', $employeeCode);
        $this->set('manager_det', $manager_det);
        $this->set('qualification', $qualification);
        $this->set('department', $department_id['Department']['dept_name']);
        $this->set("hideEditButton", $hideEditButton);
    }

    public function updatePersonalInfo() {
        $this->autoload = false;
//Configure::write('debug',2);
//echo '<pre>';print_r($this->request);
        if ($this->request->is('POST')) {

            if ($this->request->data['wedding_date'] != "") {
                $wedingdate = date("Y-m-d", strtotime($this->request->data['wedding_date']));
            } else {
                $wedingdate = "0000-00-00";
            }

            //print_r($wedingdate);die;
            $gaudian_name = $this->request->data['guardian_name'];
            $gaudain_relation = $this->request->data['guardian_relation'];
            $id = $this->request->data['id'];

            //$this->request->data['wedding_date'] =  date('Y-m-d',strtotime($this->request->data['wedding_date']));;
            $this->MyProfile->updateAll(
                    array('MyProfile.wedding_date' => "'$wedingdate'", 'MyProfile.guardian_name' => "'$gaudian_name'", 'MyProfile.guardian_relation' => "'$gaudain_relation'"), array('MyProfile.id' => $id)
            );
            $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
            <a href="#" class="uk-alert-close uk-close"></a>Personal Information Updated Successfully.</div>');
            $this->redirect('myprofile');
        }
    }

    function update_myprofile() {
        $this->layout = 'employee-new';
        $this->autoRender = false;
        Configure::write('debug', 2);
        if ($this->request->is('POST')) {

            $cur_phone = $this->request->data['contact'];
            $per_email = $this->request->data['per_email'];
            $email = $this->request->data['email'];
            $per_phone = $this->request->data['personal_phone'];
            $id = $this->request->data['id'];

            //$this->request->data['wedding_date'] =  date('Y-m-d',strtotime($this->request->data['wedding_date']));;
            $succ = $this->MyProfile->updateAll(
                    array('MyProfile.contact' => "'$cur_phone'", 'MyProfile.personal_phone' => "'$per_phone'", 'MyProfile.per_email' => "'$per_email'"), array('MyProfile.id' => $id)
            );

            $success = $this->UserDetail->updateAll(
                    array('UserDetail.email' => "'$email'"), array('UserDetail.id' => $id)
            );
            if ($success && $succ) {
                $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
            <a href="#" class="uk-alert-close uk-close"></a>Contact Information Updated Successfully.</div>');
            } else {
                $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
            <a href="#" class="uk-alert-close uk-close"></a>Contact information not updated. Please enter only numbers (10 digits).</div>');
            }
            $this->redirect('myprofile');
        } else {
            echo 'not updated';
        }
        /* if(isset($_REQUEST['doc_id']) && $_REQUEST['doc_id'])
          $doc_id=$_REQUEST['doc_id'];
          else
          $doc_id=$this->Auth->user('doc_id'); */
    }

    function saveMyProfile() {
//        $targ_w = $targ_h = 150;
//        $jpeg_quality = 90;
//
//        $src = 'demo_files/pool.jpg';
//        $img_r = imagecreatefromjpeg($src);
//        $dst_r = ImageCreateTrueColor($targ_w, $targ_h);
//
//        imagecopyresampled($dst_r, $img_r, 0, 0, $_POST['x'], $_POST['y'], $targ_w, $targ_h, $_POST['w'], $_POST['h']);
//
//        header('Content-type: image/jpeg');
//        imagejpeg($dst_r, null, $jpeg_quality);

        $temp_data = array();
        $temp_data['login_id'] = $this->Auth->user('id');
        //$temp_data['emp_gen']=$_POST['emp_gen'];

        if ($_FILES['avatar_file']['name']) {
            $tempimg_data = array();
            echo $path = $_SERVER['DOCUMENT_ROOT'] . ltrim($this->webroot, 1) . 'app/webroot/user_img/';
            exit();
            //$name=explode('.',$_FILES['user_img']['name']);
            //$new_path=trim($path).$name[0];
            $name = $_FILES['avatar_file']['name'];
            $type = explode('/', $_FILES['user_img']['type']);
            $tempimg_data['image'] = $this->Auth->user('id');
            $tempimg_data['temp_user_login_id'] = $this->Auth->user('id');
            $tempimg_data['img_path'] = $new_path;
            $tempimg_data['img_file_type'] = trim($type[1]);
            $tempimg_data['img_file_nm'] = trim($_FILES['avatar_file']['name']);
            move_uploaded_file($_FILES['avatar_file']['tmp_name'], $path . $_FILES['avatar_file']['name']);
            $other = 'image';
            $this->UserImgtempdata->save($tempimg_data);
            unset($tempimg_data);
        }
        die('herer');
        if ($this->UserTempdata->save($temp_data)) {
            $this->audittrail('update profile', $other);
            $this->sendMailToHr();
            unset($temp_data);
            echo $result = '1';
            exit();
        } else {
            echo $result = '0';
        }
    }

    function savetempdataofficial() {
        $temp_data = array();
        $temp_data['login_id'] = $this->Auth->user('id');
        //$temp_data['emp_gen']=$_POST['emp_gen'];
        $temp_data['emp_mrtl_stat'] = $_POST['emp_mrtl_stat'];

        $other = 'emp_official_detail';
        if ($_FILES['user_img']['name']) {
            $other = '';
            $tempimg_data = array();
            //$path='D:\Images\Item\ ';
            //$path='http://'.$_SERVER['HTTP_HOST'].$this->webroot.'user_img';
            $path = $_SERVER['DOCUMENT_ROOT'] . ltrim($this->webroot, 1) . 'app/webroot/user_img/';
            //$name=explode('.',$_FILES['user_img']['name']);
            //$new_path=trim($path).$name[0];
            $name = $_FILES['user_img']['name'];
            $type = explode('/', $_FILES['user_img']['type']);
            $tempimg_data['temp_user_login_id'] = $this->Auth->user('id');
            $tempimg_data['img_path'] = $new_path;
            $tempimg_data['img_file_type'] = trim($type[1]);
            $tempimg_data['img_file_nm'] = trim($_FILES['user_img']['name']);
            move_uploaded_file($_FILES['user_img']['tmp_name'], $path . $_FILES['user_img']['name']);
            $other = 'image';
            $this->UserImgtempdata->save($tempimg_data);
            unset($tempimg_data);
        }
        if ($this->UserTempdata->save($temp_data)) {
            $this->audittrail('update profile', $other);
            $this->sendMailToHr();
            unset($temp_data);
            echo $result = '1';
            exit();
        } else {
            echo $result = '0';
        }
    }

    function savetempdataperdetail() {
        $temp_data = array();
        $temp_data['login_id'] = $this->Auth->user('id');
        $temp_data['emp_curr_add'] = $_POST['emp_curr_add'];
        $temp_data['emp_perm_add'] = $_POST['emp_perm_add'];
        $temp_data['emp_phone1'] = $_POST['emp_phone1'];
        $temp_data['emp_phone2'] = $_POST['emp_phone2'];
        $other = 'emp_curr_add,emp_perm_add,emp_phone1,emp_phone2';
        if ($this->UserTempdata->save($temp_data)) {
            $this->audittrail('update profile', $other);
            $this->sendMailToHr();
            unset($temp_data);
            echo $result = '1';
            exit();
        } else {
            echo $result = '0';
        }
    }

    function savetempdatapaydetail() {
        $temp_data = array();
        $temp_data['login_id'] = $this->Auth->user('id');
        $temp_data['acc_no'] = $_POST['acc_no'];
        $other = 'acc_no';
        if ($this->UserTempdata->save($temp_data)) {
            $this->audittrail('update profile', $other);
            $this->sendMailToHr();
            unset($temp_data);
            echo $result = '1';
            exit();
        } else {
            echo $result = '0';
        }
    }

    /* function savetempdatasalarydetail()
      {
      $temp_data=array();
      $temp_data['login_id']=$this->Auth->user('id');
      $temp_data['sal_id']=$_POST['sal_select'];
      $temp_data['sal_val']=$_POST['sal_value'];
      $temp_data['valid_start_dt']=$_POST['sal_datepicker_afrom'];
      $temp_data['valid_end_dt']=$_POST['sal_datepicker_aupto'];
      $temp_data['sal_type']=$_POST['sal_type'];
      $temp_data['sal_amt']=$_POST['sal_amount'];
      $other='salary_detail';
      if($this->UserTempdata->save($temp_data))
      {
      $this->audittrail('update profile',$other);
      unset($temp_data);
     * 
     * 
      echo $result='1';
      exit();
      }
      else
      {
      echo $result='0';
      }
      } */

    function savetempdataotherdetail() {
        $temp_data = array();
        $temp_data['login_id'] = $this->Auth->user('id');
        $temp_data['oth_dtl_typ_id'] = $_POST['other_select'];
        $temp_data['doc_issue_place'] = $_POST['other_iss_pl'];
        $temp_data['doc_exp_dt'] = $_POST['other_datepicker_ex'];
        $temp_data['doc_no'] = $_POST['other_doc_no'];
        $temp_data['doc_issue_dt'] = $_POST['other_datepicker_iss'];
        $other = 'other_detail';
        //pr($temp_data);die('gg');
        if ($this->UserTempdata->save($temp_data)) {
            $this->audittrail('update profile', $other);
            $this->sendMailToHr();
            unset($temp_data);
            echo $result = '1';
            exit();
        } else {
            echo $result = '0';
        }
    }

    function savetempdatadepntdetail() {
        $temp_data = array();
        $temp_data['login_id'] = $this->Auth->user('id');
        $temp_data['mem_nm'] = $_POST['depnt_mem_name'];
        $temp_data['mem_rel'] = $_POST['depnt_relation'];
        $temp_data['mem_occu'] = $_POST['depnt_occ_bus'];
        $temp_data['mem_dob'] = $_POST['depnt_dob'];
        $temp_data['mem_gen'] = $_POST['depnt_gender'];
        $other = 'depnt_detail';
        if ($this->UserTempdata->save($temp_data)) {
            $this->audittrail('update profile', $other);
            $this->sendMailToHr();
            unset($temp_data);
            echo $result = '1';
            exit();
        } else {
            echo $result = '0';
        }
    }

    function sendMailToHr() {
        $this->Email->smtpOptions = array(
            'port' => '25',
            'timeout' => '120',
            'host' => 'smtp.essindia.com',
            'username' => 'ess-portal@essindia.com',
            'password' => 'Mugu7601$'
        );
        $this->Email->layout = 'profiletohr';
        $this->Email->template = 'profiletohr';
        $this->Email->from = 'Your Email <accounts@example.com>';
        $this->Email->to = "abhilash.jaiswal@essindia.com"; //$this->Auth->user('emp_name').'<'.$this->Auth->user('email').'>';
        $this->Email->subject = 'Update profile request from ' . $this->Auth->user('emp_name');
        $this->Email->sendAs = 'both';

        $user = $this->Auth->user('emp_name') . '(' . $this->Auth->user('email') . ')';
        $this->Email->delivery = 'smtp';
        $this->set('user', $user);
        $this->Email->send();

        //debug($this->Email->smtpError);
        $this->set('smtp_errors', $this->Email->smtpError);
    }

    function hrprofile() {
        $this->layout = 'employee';
        $this->displayAllUsers();
    }

    function displayAllUsers() {

        $user = $this->UserDetail->find('all', array('fields' => array('UserDetail.emp_name', 'UserDetail.doc_id'),
            'joins' => array(
                array('table' => 'temp_user_profile',
                    'alias' => 'UserTempdata',
                    'type' => 'INNER',
                    'conditions' => array(
                        'UserDetail.emp_code = UserTempdata.login_id'
                    )
                )
        )));

        $this->set('user', $user);
    }

    function empprofiletohr() {
        $this->myprofile();
    }

    function hrEmpProfileSave() {
        if (isset($_REQUEST['doc_id']) && $_REQUEST['doc_id'])
            $doc_id = $_REQUEST['doc_id'];
        else
            $doc_id = $this->Auth->user('doc_id');

        if (isset($_POST['hidden_attach_doc']) && ($_POST['hidden_attach_doc'])) {
            $tempAttachVal = $this->Userattachtempdata->find('first', array(
                'conditions' => array(
                    'id' => $_POST['hidden_attach_doc'])
            ));

            $actual_attach_data = array();
            $actual_attach_temp_data = array();
            $a = $_POST['hidden_attach_doc'];
            if (isset($_POST['check_attach_doc_' . $a]) && ($_POST['check_attach_doc_' . $a])) {
                $actual_attach_data['disp_fl_nm'] = $tempAttachVal['Userattachtempdata']['doc_nm'];
                $actual_attach_data['doc_id'] = $doc_id;
                $actual_attach_temp_data['doc_nm'] = '';

                $this->MyProfileattach->save($actual_attach_data);
                $this->Userattachtempdata->delete($tempAttachVal['Userattachtempdata']['id']);
            }
        }

        $tempVal = $this->UserTempdata->find('first', array(
            'conditions' => array(
                'login_id' => $_POST['hidden_emp_code'])
        ));

        $actual_prf_data = array();
        $actual_temp_data = array();
        $actual_oth_dtl_data = array();
        $actual_oth_dtl_temp_data = array();
        $actual_depnt_dtl_data = array();
        $actual_depnt_dtl_temp_data = array();
        $actual_emp_img_data = array();
        $actual_emp_img_temp_data = array();
        $actual_prf_data['doc_id'] = $_POST['doc_id'];
        $actual_temp_data['login_id'] = $_POST['hidden_emp_code'];

        if (isset($_POST['checkbox_emp_mrtl_stat']) && ($_POST['checkbox_emp_mrtl_stat'] == 1)) {
            $actual_prf_data['emp_mrtl_stat'] = $tempVal['UserTempdata']['emp_mrtl_stat'];
            $actual_temp_data['emp_mrtl_stat'] = '';
        }
        if (isset($_POST['checkbox_emp_img']) && ($_POST['checkbox_emp_img'] == 1)) {
            $tempImgVal = $this->UserImgtempdata->find('first', array(
                'conditions' => array(
                    'temp_user_login_id' => $_POST['hidden_emp_code'])
            ));

            $name = explode('.', $tempImgVal['UserImgtempdata']['img_file_nm']);
            $actual_emp_img_data['img_id'] = $name[0];
            $actual_emp_img_temp_data['img_file_nm'] = '';

            $this->MyProfileimage->save($actual_emp_img_data);
            $this->UserImgtempdata->save($actual_emp_img_temp_data);
        }
        if (isset($_POST['checkbox_curadd']) && ($_POST['checkbox_curadd'] == 1)) {
            $actual_prf_data['emp_curr_add'] = $tempVal['UserTempdata']['emp_curr_add'];
            $actual_temp_data['emp_curr_add'] = '';
            $this->MyProfile->save($actual_prf_data);
            $this->UserTempdata->save($actual_temp_data);
        }
        if (isset($_POST['checkbox_peradd']) && ($_POST['checkbox_peradd'] == 1)) {
            $actual_prf_data['emp_perm_add'] = $tempVal['UserTempdata']['emp_perm_add'];
            $actual_temp_data['emp_perm_add'] = '';
            $this->MyProfile->save($actual_prf_data);
            $this->UserTempdata->save($actual_temp_data);
        }
        if (isset($_POST['checkbox_priphn']) && ($_POST['checkbox_priphn'] == 1)) {
            $actual_prf_data['emp_phone1'] = $tempVal['UserTempdata']['emp_phone1'];
            $actual_temp_data['emp_phone1'] = '';
            $this->MyProfile->save($actual_prf_data);
            $this->UserTempdata->save($actual_temp_data);
        }
        if (isset($_POST['checkbox_sec_phn']) && ($_POST['checkbox_sec_phn'] == 1)) {
            $actual_prf_data['emp_phone2'] = $tempVal['UserTempdata']['emp_phone2'];
            $actual_temp_data['emp_phone2'] = '';
            $this->MyProfile->save($actual_prf_data);
            $this->UserTempdata->save($actual_temp_data);
        }
        if (isset($_POST['checkbox_acc_no']) && ($_POST['checkbox_acc_no'] == 1)) {
            $actual_prf_data['acc_no'] = $tempVal['UserTempdata']['acc_no'];
            $actual_temp_data['acc_no'] = '';
            $this->MyProfile->save($actual_prf_data);
            $this->UserTempdata->save($actual_temp_data);
        }

        if (isset($_POST['hidden_oth_dtl']) && ($_POST['hidden_oth_dtl'])) {
            //echo 'aa='.$tempVal['UserTempdata']['emp_code'];die('ff');
            $i = $_POST['hidden_oth_dtl'];
            if (isset($_POST['checkbox_oth_dtl_' . $i]) && ($_POST['checkbox_oth_dtl_' . $i])) {
                $actual_oth_dtl_data['doc_id'] = $doc_id;
                $actual_oth_dtl_temp_data['login_id'] = $_POST['hidden_emp_code'];

                if (isset($tempVal['UserTempdata']['oth_dtl_typ_id']) && ($tempVal['UserTempdata']['oth_dtl_typ_id'])) {
                    $actual_oth_dtl_data['oth_dtl_typ_id'] = $tempVal['UserTempdata']['oth_dtl_typ_id'];
                    $actual_oth_dtl_temp_data['oth_dtl_typ_id'] = '';
                }
                if (isset($tempVal['UserTempdata']['doc_no']) && ($tempVal['UserTempdata']['doc_no'])) {
                    $actual_oth_dtl_data['emp_doc_no'] = $tempVal['UserTempdata']['doc_no'];
                    $actual_oth_dtl_temp_data['doc_no'] = '';
                }
                if (isset($tempVal['UserTempdata']['doc_issue_place']) && ($tempVal['UserTempdata']['doc_issue_place'])) {
                    $actual_oth_dtl_data['doc_issue_place'] = $tempVal['UserTempdata']['doc_issue_place'];
                    $actual_oth_dtl_temp_data['doc_issue_place'] = '';
                }

                if (isset($tempVal['UserTempdata']['doc_issue_dt']) && ($tempVal['UserTempdata']['doc_issue_dt'])) {
                    $actual_oth_dtl_data['doc_issue_dt'] = $tempVal['UserTempdata']['doc_issue_dt'];
                    $actual_oth_dtl_temp_data['doc_issue_dt'] = '';
                }

                if (isset($tempVal['UserTempdata']['doc_exp_dt']) && ($tempVal['UserTempdata']['doc_exp_dt'])) {
                    $actual_oth_dtl_data['doc_exp_dt'] = $tempVal['UserTempdata']['doc_exp_dt'];
                    $actual_oth_dtl_temp_data['doc_exp_dt'] = '';
                }
                /* if(isset($tempVal['UserTempdata']['iss_auth']) && ($tempVal['UserTempdata']['iss_auth']))
                  {
                  $actual_oth_dtl_data['iss_auth']=$tempVal['UserTempdata']['iss_auth'];
                  $actual_oth_dtl_temp_data['iss_auth']='';
                  } */
                //pr($actual_oth_dtl_temp_data);die('dd');
                $this->MyProfileotherdetail->save($actual_oth_dtl_data);
                $this->UserTempdata->save($actual_oth_dtl_temp_data);
            }
        }
        if (isset($_POST['hidden_depnt_dtl']) && ($_POST['hidden_depnt_dtl'])) {
            $j = $_POST['hidden_depnt_dtl'];
            if (isset($_POST['checkbox_depnt_dtl_' . $j]) && ($_POST['checkbox_depnt_dtl_' . $j])) {
                if (isset($_REQUEST['doc_id']) && $_REQUEST['doc_id'])
                    $doc_id = $_REQUEST['doc_id'];
                else
                    $doc_id = $this->Auth->user('doc_id');

                $actual_depnt_dtl_data['doc_id'] = $doc_id;
                $actual_depnt_dtl_temp_data['login_id'] = $_POST['hidden_emp_code'];

                if (isset($tempVal['UserTempdata']['mem_nm']) && ($tempVal['UserTempdata']['mem_nm'])) {
                    $actual_depnt_dtl_data['mem_nm'] = $tempVal['UserTempdata']['mem_nm'];
                    $actual_depnt_dtl_temp_data['mem_nm'] = '';
                }
                if (isset($tempVal['UserTempdata']['mem_dob']) && ($tempVal['UserTempdata']['mem_dob'])) {
                    $actual_depnt_dtl_data['mem_dob'] = $tempVal['UserTempdata']['mem_dob'];
                    $actual_depnt_dtl_temp_data['mem_dob'] = '';
                }
                if (isset($tempVal['UserTempdata']['mem_rel']) && ($tempVal['UserTempdata']['mem_rel'])) {
                    $actual_depnt_dtl_data['mem_rel'] = $tempVal['UserTempdata']['mem_rel'];
                    $actual_depnt_dtl_temp_data['mem_rel'] = '';
                }
                if (isset($tempVal['UserTempdata']['mem_occu']) && ($tempVal['UserTempdata']['mem_occu'])) {
                    $actual_depnt_dtl_data['mem_occu'] = $tempVal['UserTempdata']['mem_occu'];
                    $actual_depnt_dtl_temp_data['mem_occu'] = '';
                }
                if (isset($tempVal['UserTempdata']['mem_gen']) && ($tempVal['UserTempdata']['mem_gen'])) {
                    $actual_depnt_dtl_data['mem_gen'] = $tempVal['UserTempdata']['mem_gen'];
                    $actual_depnt_dtl_temp_data['mem_gen'] = '';
                }
                $this->MyProfiledepnt->save($actual_depnt_dtl_data);
                $this->UserTempdata->save($actual_depnt_dtl_temp_data);
            }
        }

        unset($actual_prf_data);
        unset($actual_temp_data);
        unset($actual_oth_dtl_data);
        unset($actual_oth_dtl_temp_data);
        unset($actual_depnt_dtl_data);
        unset($actual_depnt_dtl_temp_data);

        echo $result = '1';
        exit();
    }

    /*
     * GET All Pending Non Approved Document
     * 0->Non Approved
     * 1->Approved
     */

    public function pendingDocuments() {

        if ($this->request->is('post') && !empty($this->request->data)) {
            $data = $this->request->data['pending_docs'];
            if (!empty($data)) {
                foreach ($data as $key => $value) {
                    if ($value == 1) {
                        $this->EmpDocuments->id = $this->request->data['pending_docs_vl'][$key];
                        $this->EmpDocuments->saveField('approve', 1);
                    }
                }
            }
        }

        $this->layout = 'employee-new';
        try {
            $this->paginate = array(
                'conditions' => array(
                    'approve' => 0,
                    'emp_code !=' => $this->Auth->user('emp_code')
                ),
                'fields' => array('*'),
                'limit' => '10',
                'order' => 'id DESC'
            );
            $documents = $this->paginate('EmpDocuments');
        } catch (Exception $e) {
            
        }


        $this->set("documents", $documents);
    }

    public function dependentsApproval($id) {


        if (base64_decode($id) != '') {

            $this->DependentDetails->id = base64_decode($id);
            $this->DependentDetails->saveField('status', 5);
            $this->Session->setFlash('Dependents Approved successfully');
            $this->redirect('dependentsApproval');
        }

        $this->layout = 'employee-new';
        $documents = $this->DependentDetails->find('all', array(
            'conditions' => array(
                'DependentDetails.status' => 2
            ),
            'fields' => array('*'),
            'order' => 'DependentDetails.id DESC'
        ));


        $this->set("documents", $documents);
    }

    public function dependentsReject($id) {
        if (base64_decode($id) !== '') {

            $this->DependentDetails->id = base64_decode($id);
            $this->DependentDetails->saveField('status', 4);
            $this->Session->setFlash('Dependents rejected successfully');
            $this->redirect('dependentsApproval');
        }
    }

    function savetempdataAttachdetail() {
        if ($_FILES['attach_file']['name']) {
            $other = '';
            $tempattach_data = array();

            $path = $_SERVER['DOCUMENT_ROOT'] . ltrim($this->webroot, 1) . 'app/webroot/user_attach_doc/';

            $tempattach_data['temp_user_login_id'] = $this->Auth->user('id');
            $tempattach_data['id'] = $this->Userattachtempdata->getAttachMaxid();
            $tempattach_data['doc_nm'] = trim($_FILES['attach_file']['name']);
            move_uploaded_file($_FILES['attach_file']['tmp_name'], $path . $_FILES['attach_file']['name']);
            if ($this->Userattachtempdata->save($tempattach_data)) {
                $other = 'attach_doc';
                $this->audittrail('update profile', $other);
                $this->sendMailToHr();
                unset($tempattach_data);
                echo $result = '1';
                exit();
            } else {
                echo $result = '0';
                exit();
            }
        } else {
            echo $result = '0';
        }
    }

    function prListJson() {
        $this->layout = '';
        $this->autoRender = false;
        $employees = $this->MyProfile->find('all', array('fields' => array('Concat_ws(" ",MyProfile.emp_firstname,MyProfile.emp_lastname) as label', 'UPPER(MyProfile.emp_code) as id', 'LOWER(email) as VCNAME'),
            'joins' => array(
                array('table' => 'users',
                    'alias' => 'users',
                    'type' => 'INNER',
                    'conditions' => array(
                        'MyProfile.emp_code = users.emp_code AND MyProfile.comp_code=users.comp_code')
                )
            ),
            'conditions' => array('emp_firstname LIKE' => "%" . strtoupper($this->params['url']['term']) . "%")
        ));
        foreach ($employees as &$employee) {
            $employee = $employee[0];
        }
        echo json_encode($employees);
    }

    function changeimage() {
        $this->layout = "";
    }

    function uploader() {
        $this->layout = '';
        $emp_code = $this->Auth->User('emp_code');
        $newfilename = $this->Auth->User('emp_code') . basename($_FILES['avatar_file']['name']);

        $file = "uploads/profile/" . $newfilename;
        $filename = basename($_FILES['avatar_file']['name']);
        if (move_uploaded_file($_FILES['avatar_file']['tmp_name'], $file)) {
            $this->MyProfile->updateAll(
                    array('MyProfile.image' => "'$newfilename'"), array('MyProfile.emp_code' => $emp_code)
            );
            $_SESSION['Auth']['MyProfile']['image'] = $newfilename;
            $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
            <a href="#" class="uk-alert-close uk-close"></a>Profile picture successfully uploaded.</div>');
            $this->redirect('/users/myprofile');
        } else {
            $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert="">
            <a href="#" class="uk-alert-close uk-close"></a>Profile picture successfully not uploaded.</div>');
            $this->redirect('/users/myprofile');
        }
    }

    function uploadDocument() {
        $emp_code = $this->Auth->User('emp_code');
        $newfilename = $this->Auth->User('emp_code') . basename($_FILES['doc_file']['name']);
        $file = "uploads/document/" . $newfilename;
        $filename = basename($_FILES['doc_file']['name']);
        $query = $this->MyProfile->find('first', array('fields' => array(
                'emp_code', 'emp_name'), 'conditions' => array(
                 //'dept_code' => 'DEPT00002',
                //'comp_code' => $comp_code,
                'emp_code !=' . $emp_code,
                'status' => 32),
            'order' => array("emp_name ASC")));
        $myprofile_id = $this->MyProfile->find('first', array('conditions' => array('emp_code' => $query['MyProfile']['emp_code'])));
        $ext = strtolower(substr($filename, strrpos($filename, '.') + 1));
        if (!($ext == 'pdf' || $ext == 'jpg' || $ext == 'png' || $ext == 'txt' || $ext == 'doc' || $ext == 'docx') || ($this->request->data['upl_doc']['size'] > 2048000)) {
            if ($this->request->data['upl_doc']['size'] > 2048000) {
                $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert=""><a href="#" class="uk-alert-close uk-close"></a>Sorry, this is invalid file, please check the size !</div>');
            } elseif (!($ext == 'pdf' || $ext == 'jpg' || $ext == 'png' || $ext == 'txt' || $ext == 'doc' || $ext == 'docx')) {
                $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert=""><a href="#" class="uk-alert-close uk-close"></a>Sorry, this is invalid file, please check the extention !</div>');
            }
            $this->redirect('/users/myprofile');
        } else {
            if (!empty($_FILES['doc_file']['name']) && !empty($emp_code)) {
                if (move_uploaded_file($_FILES['doc_file']['tmp_name'], $file)) {
                    $this->EmpDocuments->create();
                    $value['emp_code'] = $emp_code;
                    $value['title'] = $this->request->data['title'];
                    $value['documents'] = $newfilename;
                    $value['created_at'] = date("Y-m-d");
                    $value['myprofile_id'] = $myprofile_id['MyProfile']['id'];
                    $this->EmpDocuments->save($value);
                    $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
		    <a href="#" class="uk-alert-close uk-close"></a>Document successfully uploaded.</div>');

                    $this->redirect('/users/myprofile');
                } else {
                    $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert="">
		    <a href="#" class="uk-alert-close uk-close"></a>Document successfully not uploaded.</div>');
                    $this->redirect('/users/myprofile');
                }
            } else {
                $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert="">
		    <a href="#" class="uk-alert-close uk-close"></a>Document successfully not uploaded.</div>');
                $this->redirect('/users/myprofile');
            }
        }
    }

    function uploadBankdetails() {
        $this->autoload = false;
        //Configure::write('debug',2);
        if ($this->request->is('POST')) {
            if ($this->request->data['account_number'] != "") {
                $acc_no = $this->request->data['account_number'];
                $ifsc_code = $this->request->data['ifsc_code'];
                $bank_code = $this->request->data['eo_id'];
                $branch_code = $this->request->data['branch_code'];
                $id = $this->request->data['id'];
            } else {
                $acc_no = "0000000";
                $ifsc_code = $this->request->data['ifsc_code'];
                $bank_code = $this->request->data['eo_id'];
                $id = $this->request->data['id'];
            }
            echo $bank_code; //die;
            $this->MyProfile->updateAll(
                    array('MyProfile.account_no' => "'$acc_no'", 'MyProfile.bank_code' => "'$bank_code'", 'MyProfile.ifsc_code' => "'$ifsc_code'", 'MyProfile.branch_code' => "'$branch_code'"), array('MyProfile.id' => $id)
            );
            $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
            <a href="#" class="uk-alert-close uk-close"></a>Bank Details Updated Successfully.</div>');
            $this->redirect('myprofile');
        }
    }

    function updateMember() {

        $this->autorender = 'false';
        $my_profile_id = $this->Auth->User('id');

        if (!empty($this->data)) {
            for ($i = 1; $i <= count($this->request->data['member']); $i++) {
                $arraydep = array();
                if ($this->data['id'][$i]) {
                    $arraydep['id'] = $this->data['id'][$i];
                }
                $arraydep['member_name'] = $this->data['member'][$i];
                $arraydep['relation'] = $this->data['relation'][$i];
                $arraydep['occupation'] = $this->data['occupation'][$i];
                $arraydep['Dob'] = date('Y-m-d', strtotime($this->data['dob'][$i]));
                $arraydep['gender'] = $this->data["gender_$i"];
                $arraydep['myprofile_id'] = $my_profile_id;
                if ($this->data['status'][$i] == 5) {
                    $arraydep['status'] = 5;
                } else {
                    $arraydep['status'] = 2;
                }

                $this->DependentDetails->create();
                $this->DependentDetails->save($arraydep);
            }
            $this->Session->setFlash('Dependent saved successfully');
            $this->redirect('/users/myprofile');
        } else {
            $this->Session->setFlash('Empty Data Try Again');
            $this->redirect('/users/myprofile');
        }
    }

    function deleteDependent($id) {
        if ($this->DependentDetails->deleteAll(
                        array(
                            "DependentDetails.id" => $id
                        )
                )) {
            $this->Session->setFlash('Dependent Deleted Successfully');
            $this->redirect('/users/myprofile');
        } else {
            $this->Session->setFlash('Dependent Not Remove Suceesfully.');
            $this->redirect('/users/myprofile');
        }
    }

    function updateAddress() {
        //Configure::write('debug', 2);
        $emp_code = $this->Auth->User('emp_code');
        $newfilename = $this->Auth->User('emp_code') . basename($_FILES['doc_file']['name']);
        $file = "uploads/document/" . $newfilename;
        $filename = basename($_FILES['doc_file']['name']);
        $ext = strtolower(substr($filename, strrpos($filename, '.') + 1));
//echo '<pre>';print_r($_FILES);die;
        if (!($ext == 'pdf' || $ext == 'jpg' || $ext == 'png' || $ext == 'txt' || $ext == 'doc' || $ext == 'docx') || ($_FILES['doc_file']['size'] > 2048000)) {
            if ($_FILES['doc_file']['size'] > 2048000) {
                $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert=""><a href="#" class="uk-alert-close uk-close"></a>Sorry, this is invalid file, please check the size !</div>');
            } elseif (!($ext == 'pdf' || $ext == 'jpg' || $ext == 'png' || $ext == 'txt' || $ext == 'doc' || $ext == 'docx')) {
                $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert=""><a href="#" class="uk-alert-close uk-close"></a>Sorry, this is invalid file, please check the extention !</div>');
            }
            $this->redirect('/users/myprofile');
        } else {
            if (!empty($_FILES['doc_file']['name']) && !empty($emp_code)) {
                if (move_uploaded_file($_FILES['doc_file']['tmp_name'], $file)) {
                    $this->EmpAddress->create();
                    $value['emp_code'] = $emp_code;
                    $value['cur_address'] = $this->request->data['cur_address'];
                    $value['cur_city'] = $this->request->data['cur_city_id'];
                    $value['cur_state'] = $this->request->data['cur_state_id'];
                    $value['cur_country'] = $this->request->data['cur_country_id'];
                    $value['cur_pincode'] = $this->request->data['cur_pincode'];
                    // $value['cur_landline'] = $this->request->data['cur_landline'];
                    $value['cur_phone'] = $this->request->data['cur_phone'];
                    $value['per_address'] = $this->request->data['per_address'];
                    $value['per_city'] = $this->request->data['per_city_id'];
                    $value['per_state'] = $this->request->data['per_state_id'];
                    $value['per_country'] = $this->request->data['per_country_id'];
                    $value['per_pincode'] = $this->request->data['per_pincode'];
                    //$value['per_landline'] = $this->request->data['per_landline'];
                    $value['per_phone'] = $this->request->data['per_phone'];
                    $value['approver_id'] = $this->request->data['forwardlvl'];
                    $value['document'] = $newfilename;
                    $value['created_at'] = date("Y-m-d");
                    $value['status'] = 2;

                    $this->EmpAddress->save($value);
                    $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
            <a href="#" class="uk-alert-close uk-close"></a>Address submitted to HR for approval.</div>');
                    $this->redirect('/users/myprofile');
                } else {
                    $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert="">
            <a href="#" class="uk-alert-close uk-close"></a>Address not succesfully uploaded.</div>');
                    $this->redirect('/users/myprofile');
                }
            } else {
                $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert="">
            <a href="#" class="uk-alert-close uk-close"></a>Address not succesfully uploaded.</div>');
                $this->redirect('/users/myprofile');
            }
        }
    }

    public function docDelete() {
        $this->autoRender = false;
        $vl = base64_decode($this->params['pass']['0']);
        if ($this->EmpDocuments->deleteAll(
                        array(
                            "EmpDocuments.id" => $vl,
                            "EmpDocuments.emp_code" => $this->Auth->User('emp_code')
                        )
                )) {
            echo "success";
        } else {
            echo "false";
        }
    }

    function addressApproval() {
        $this->layout = 'employee-new';
        $this->paginate = array(
            'fields' => array('*'),
            'limit' => 10,
            'conditions' => array('approver_id' => $this->Auth->User('emp_code'), 'emp_code !=' => $this->Auth->user('emp_code'), 'status' => array('2', '5', '4'))
        );

        $pendinglist = $this->paginate('EmpAddress');


        $this->set('pendingAdress', $pendinglist);
    }

    public function editAddress($id) {
        $this->layout = 'employee-new';
        $adress_id = base64_decode($id);
        $address_info = $this->EmpAddress->find('first', array(
            'fields' => array('*'),
            'conditions' => array('id' => $adress_id)
        ));
        //print_r($address_info);die;
        $this->set('address_info', $address_info);
        $this->set('addressid', $adress_id);
    }

    public function addressSaveInfo() {
        $this->autoload = false;
        $address_info = $this->EmpAddress->find('first', array(
            'fields' => array('*'),
            'conditions' => array('id' => $this->request->data['addressid'])
        ));

        $orig_address = $this->MyProfile->find('first', array(
            'fields' => array('*'),
            'conditions' => array('emp_code' => $this->request->data['emp_code'])
        ));
        $org_id = $orig_address['MyProfile']['id'];
        $remark = $this->request->data['remark'];
        if ($this->request->data['AddressWorkflow']['type'] == 5) {
            $address = array();
            $address['id'] = $org_id;
            $address['cur_address'] = $address_info['EmpAddress']['cur_address'];
            $address['cur_city_id'] = $address_info['EmpAddress']['cur_city'];
            $address['cur_state_id'] = $address_info['EmpAddress']['cur_state'];
            $address['cur_country_id'] = $address_info['EmpAddress']['cur_country'];
            $address['cur_pincode'] = $address_info['EmpAddress']['cur_pincode'];
            $address['cur_phone'] = $address_info['EmpAddress']['cur_phone'];
            $address['per_address'] = $address_info['EmpAddress']['per_address'];
            $address['per_city_id'] = $address_info['EmpAddress']['per_city'];
            $address['per_state_id'] = $address_info['EmpAddress']['per_state'];
            $address['per_country_id'] = $address_info['EmpAddress']['per_country'];
            $address['per_pincode'] = $address_info['EmpAddress']['per_pincode'];
            $address['per_phone'] = $address_info['EmpAddress']['per_phone'];

            if ($this->MyProfile->save($address)) {

                $approve_address = $this->EmpAddress->updateAll(
                        array('EmpAddress.status' => '5', 'EmpAddress.remark' => "'$remark'"), array('EmpAddress.id' => $this->request->data['addressid'])
                );
                $this->Session->setFlash('Address approved successfully');
            }
        } else {
            $rej_address = $this->EmpAddress->updateAll(
                    array('EmpAddress.status' => '4', 'EmpAddress.remark' => "'$remark'"), array('EmpAddress.id' => $this->request->data['addressid'])
            );
            $this->Session->setFlash('Change Address Request Rejected');
        }
        $this->redirect(array('controller' => 'Users', 'action' => 'addressApproval'));
    }

    public function setting() {
        $this->layout = 'employee-new';
        $emp_code = $this->Auth->User('emp_code');
        $myprofile_id = $this->MyProfile->find('first', array(
            'fields' => array('id', 'dept_code'),
            'conditions' => array('emp_code' => $this->Auth->User('emp_code'))
        ));
        $id = $myprofile_id['MyProfile']['id'];
        $department = $this->MyProfile->find('first', array(
            'fields' => array('dept_code'),
            'conditions' => array('emp_code' => $emp_code)));
        $department_id = $this->Departments->find('first', array(
            'fields' => array('id'),
            'conditions' => array('dept_code' => $department['MyProfile']['dept_code'])
        ));

        $ticker = $this->Ticker->find('list', array(
            'fields' => array('Ticker.id', 'Ticker.name'),
            'conditions' => array('department_id' => $department_id['Departments']['id'])
        ));

        $tickeremp = $this->TickerUser->find('list', array(
            'fields' => array('ticker_id'),
            'conditions' => array('myprofile_id' => $id)
        ));
        $icons = $this->IconUser->find('list', array(
            'fields' => array('icon_id'),
            'conditions' => array('myprofile_id' => $id)
        ));
        //print_r($icons);die;
        $this->set('tickeremp', $tickeremp);
        $this->set('iconemp', $icons);
        $icon = $this->Icon->find('list', array(
            'fields' => array('Icon.id', 'Icon.shortcut_name'),
            'conditions' => array('department_id' => $department_id['Departments']['id'])
        ));

        $this->set('ticker', $ticker);
        $this->set('icon', $icon);
    }

    public function saveSetting() {

        $id = $this->MyProfile->find('first', array(
            'fields' => array('id'),
            'conditions' => array('emp_code' => $this->Auth->User('emp_code'))));
        $this->autorender = '';
        if (!empty($this->data['ticker'])) {
            $users = $this->TickerUser->find('all', array('field' => array('id'), 'conditions' => array('myprofile_id' => $id['MyProfile']['id'])));
            foreach ($users as $user) {
                $this->TickerUser->delete($user['TickerUser']['id']);
            }
            $ticker = $this->data['ticker'];
            foreach ($ticker as $k => $val) {
                $ticker = array();
                $ticker['ticker_id'] = $val;
                $ticker['myprofile_id'] = $id['MyProfile']['id'];
                $this->TickerUser->create();
                if ($this->TickerUser->save($ticker)) {
                    unset($ticker);
                }
            }
        }
        if (!empty($this->data['icon'])) {
            $iconusers = $this->IconUser->find('all', array('field' => array('id'), 'conditions' => array('myprofile_id' => $id['MyProfile']['id'])));
            foreach ($iconusers as $iconuser) {
                $this->IconUser->delete($iconuser['IconUser']['id']);
            }
            $icon = $this->data['icon'];
            foreach ($icon as $k => $val) {
                $icon = array();
                $icon['icon_id'] = $val;
                $icon['myprofile_id'] = $id['MyProfile']['id'];
                $this->IconUser->create();
                if ($this->IconUser->save($icon)) {
                    unset($icon);
                    $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
            <a href="#" class="uk-alert-close uk-close"></a>Ticker & Shortcut Icon Saved Succesfully</div>');
                }
            }
        }
        $this->redirect('/users/setting');
    }

    public function deleteImportantDoc($doc_id) {
        //print_r($this->data);die;
        $this->layout = 'employee-new';
        $this->autoRender = false;
        $comp_code = $this->Auth->User('comp_code');
        $important = $this->ImportantDoc->delete($doc_id);
        $this->set('important', $important);
        if ($important) {
            return true;
        } else {
            return false;
        }
    }

    public function addImportantDoc() {
        //print_r($this->data);die;
        $this->layout = 'employee-new';
        $comp_code = $this->Auth->User('comp_code');
        $important = $this->ImportantDocCategory->find('list', array('fields' => array('id', 'title'), 'conditions' => array('comp_code' => $comp_code)));
        $this->set('important', $important);
    }

    public function saveUpload() {
        $n = rand(0, 100000);
        $newfilename = $n . basename($_FILES['doc_file']['name']);
        $file = "uploads/document/" . $newfilename;
        $filename = basename($_FILES['doc_file']['name']);
        $emp_code = $this->Auth->User('emp_code');

        if (!empty($_FILES['doc_file']['name']) && !empty($emp_code)) {
            if (move_uploaded_file($_FILES['doc_file']['tmp_name'], $file)) {
                // print_r($this->data);die;
                $this->ImportantDoc->create();
                $value['filename'] = $newfilename;
                $value['title'] = $this->data['title'];
                $value['important_doc_category_id'] = $this->data['important_doc'];
                $this->ImportantDoc->save($value);
                $this->Session->setFlash('Document successfully uploaded.');
                $this->redirect('/users/dashboard');
            } else {
                $this->Session->setFlash('Document successfully not uploaded.');
                $this->redirect('/users/dashboard');
            }
        } else {
            $this->Session->setFlash('Document successfully not uploaded.');
            $this->redirect('/users/dashboard');
        }
    }

    public function importantDocDetails($id) {
        $this->layout = 'employee-new';
        $imp_doc_category = $this->ImportantDoc->find('all', array('fields' => array('*'), 'conditions' => array('im1portant_doc_category_id' => $id)));
        $this->set('importantDocument', $imp_doc_category);
    }

    public function get_attendance_details() {
        $this->autoRender = false;
        $emp_doc_id = $_SESSION['Auth']['MyProfile']['doc_id'];
        $emp_code = $this->Auth->User('emp_code');
        $attendance = $this->AttendanceDetail->find('all', array(
            'conditions' => array(
                'emp_doc_id' => $emp_doc_id,
                'status' => 5,
            ))
        );

        $data = array();
        $i = 0;
        $leave = $this->LeaveDetails->find('list', array('fields' => array('leave_detail_id', 'leave_date'), 'conditions' => array('emp_code' => $this->Auth->User('emp_code'))));
        $adjust_leave = $this->AttendanceDetailDtl1->find('all', array('fields' => array('atten_dt', 'leave_id'), 'conditions' => array('emp_id' => $this->Auth->User('emp_id'))));
        $adjust_leave1 = $this->AttendanceDetailDtl1->find('list', array('fields' => array('atten_dt', 'leave_id'), 'conditions' => array('emp_id' => $this->Auth->User('emp_id'))));
        foreach ($attendance as $key => $value) {
            $record_dates[] = $value['AttendanceDetail']['atten_dt'];
            $invalue[] = $value['AttendanceDetail']['in_time'];
            $invalue[] = $value['AttendanceDetail']['out_time'];
        }

        foreach ($adjust_leave as $k => $v) {
            $ad_leave[] = $v['AttendanceDetailDtl1']['atten_dt'];
        }
        // Week Offs
        //echo $_SESSION['Auth']['MyProfile']['emp_grp_id']; 
        $weekoffs = $this->WeekHolidayList->find('list', array(
            'fields' => array('dt'),
            'conditions' => array('emp_group' => $_SESSION['Auth']['MyProfile']['emp_grp_id']
        )));

        //print_r($weekoffs); die;
        // Holidays
        $holidays = $this->Holiday->find('list', array(
            'fields' => array('holiday_date'),
            'conditions' => array('org_id' => $_SESSION['Auth']['MyProfile']['comp_code'])
                )
        );
        //print_r($holidays); die;
        //'location_id' => $_SESSION['Auth']['MyProfile']['location_code'],
        $emp_events = $this->EmpEvent->find('all', array('conditions' => array('emp_code' => $emp_code)));
        $this->paginate = array(
            'fields' => array('*'),
            'limit' => 20,
            'joins' => array(
                array(
                    'table' => 'option_attribute',
                    'alias' => 'op',
                    'type' => 'inner',
                    'foreignKey' => false,
                    'conditions' => array('op.id = LeaveDetail.leave_code ')
                ),
            ),
            'conditions' => array('LeaveDetail.emp_code' => $this->Auth->User('emp_code'))
        );
        $data_leave = $this->paginate('LeaveDetail');
        foreach ($data_leave as $key => $value) {
            $lname[$value['LeaveDetail']['leave_date']] = $value['op']['name'];
        }
        $holidays_list = $this->Holiday->find('all', array('conditions' => array('location_id' => $_SESSION['Auth']['MyProfile']['location_code'],
                'org_id' => $_SESSION['Auth']['MyProfile']['comp_code'])));
        foreach ($holidays_list as $key => $value) {
            $hol[$value['Holiday']['holiday_date']] = $value['Holiday']['holiday_name'];
        }
        // Getting Attendance List
        $this->loadModel('AttendanceDetailDtl1');
        $AttendanceDetailDtl1 = $this->AttendanceDetailDtl1->find('list', array(
            'fields' => array('atten_dt'),
            'conditions' => array(
                'emp_doc_id' => $emp_doc_id,
            )
        ));
        $task_done = $this->TaskAssign->find('all', array(
            'conditions' => array(),
            'joins' => array(
                array(
                    'table' => 'task_assign_emp',
                    'alias' => 'Assigned',
                    'type' => 'LEFT',
                    'conditions' => array(
                        'Assigned.tid = TaskAssign.tid'
                    )
                ),
            ),
            'fields' => array(
                'TaskAssign.*',
                'Assigned.*'
            ), 'conditions' => array('Assigned.emp_code' => $emp_code)
        ));

        $st = strtotime("Jan 01 2018");
        $c = 0;
        $today = date('d-M-Y');
        $t = strtotime($today . '+ 20 day');
        while ($st <= strtotime(date('Y-m-d', $t))) {
            if (in_array(date('Y-m-d', $st), $record_dates)) {
                $attendance = $this->AttendanceDetail->find('first', array(
                    'conditions' => array(
                        'emp_doc_id' => $emp_doc_id,
                        'status' => 5,
                        'atten_dt' => date('Y-m-d', $st)
                    ))
                );
                $data[$i]['id'] = $attendance['AttendanceDetail']['id'];
                if ($attendance['AttendanceDetail']['leave_id'] == '' && $attendance['AttendanceDetail']['ded_ch'] == '') {
                    $data[$i]['title'] = 'In - ' . date('H : i ', strtotime($attendance['AttendanceDetail']['in_time'])) . 'Out - ' . date('H : i ', strtotime($attendance['AttendanceDetail']['out_time']));
                    $data[$i]['color'] = "#55E61B";
                    $data[$i]['url'] = 'attendance_list';
                } else if ($attendance['AttendanceDetail']['ded_ch'] == 'F') {
                    $data[$i]['title'] = 'FULL DAY LWP';
                    $data[$i]['color'] = "#57D68F";
                    $data[$i]['url'] = 'http://' . $_SERVER["SERVER_NAME"] . '/hrportal/leaves/add';
                } else if ($attendance['AttendanceDetail']['ded_ch'] == 'H') {
                    $data[$i]['title'] = 'HALF DAY LWP';
                    $data[$i]['color'] = "#57D68F";
                    $data[$i]['url'] = 'http://' . $_SERVER["SERVER_NAME"] . '/hrportal/leaves/add';
                } else {
                    $data[$i]['title'] = $this->Common->findLeaveType($attendance['AttendanceDetail']['leave_id']);
                    $data[$i]['color'] = "#F7DC6F";
                }
                $data[$i]['start'] = date('Y-m-d', $st);
                $data[$i]['end'] = date('Y-m-d', $st);
                $i++;
            } elseif (in_array(date('Y-m-d', $st), $weekoffs)) {
                $data[$i]['id'] = rand(100);
                $data[$i]['title'] = 'Week off';
                $data[$i]['url'] = 'attendance_list';
                $data[$i]['color'] = "#B2BABB";

                $data[$i]['start'] = date('Y-m-d', $st);
                $data[$i]['end'] = date('Y-m-d', $st);

                $i++;
            } elseif (in_array(date('Y-m-d', $st), $leave)) {

                $data[$i]['id'] = rand(100);
                $data[$i]['title'] = $lname[date('Y-m-d', $st)];
                $data[$i]['url'] = 'http://' . $_SERVER["SERVER_NAME"] . '/hrportal/leaves/add';
                $data[$i]['color'] = "#F7DC6F";
                $data[$i]['start'] = date('Y-m-d', $st);
                $data[$i]['end'] = date('Y-m-d', $st);
                $i++;
            } elseif (in_array(date('Y-m-d', $st), $ad_leave)) {
                $data[$i]['id'] = rand(100);
                $data[$i]['title'] = 'Adjust Leave';
                $data[$i]['url'] = 'http://' . $_SERVER["SERVER_NAME"] . '/hrportal/leaves/add/2/' . base64_encode($adjust_leave1[date('Y-m-d', $st)]) . '/' . base64_encode($st);
                $data[$i]['color'] = "#F7DC6F";
                $data[$i]['start'] = date('Y-m-d', $st);
                $data[$i]['end'] = date('Y-m-d', $st);
                $i++;
            } else {
                $data[$i]['id'] = rand(100);
                $data[$i]['title'] = 'Absent';
                $data[$i]['url'] = 'add_attendance';
                $data[$i]['color'] = "#E53813";

                $data[$i]['start'] = date('Y-m-d', $st);
                $data[$i]['end'] = date('Y-m-d', $st);

                $i++;
            }
            if (in_array(date('Y-m-d', $st), $holidays)) {
                $data[$i]['id'] = rand(100);
                $data[$i]['title'] = $hol[date('Y-m-d', $st)];
                $data[$i]['url'] = 'http://' . $_SERVER["SERVER_NAME"] . '/hrportal/Holidays/holidaylisting';
                $data[$i]['color'] = "#BB8FCE";

                $data[$i]['start'] = date('Y-m-d', $st);
                $data[$i]['end'] = date('Y-m-d', $st);

                $i++;
            }
            $st = strtotime('+1 days', $st);
        }


        foreach ($task_done as $tk) {
            $data[$i]['id'] = rand(100);
            $data[$i]['title'] = $tk['TaskAssign']['tname'];
            $data[$i]['url'] = 'http://' . $_SERVER["SERVER_NAME"] . '/hrportal/tasks/emptask';
            $data[$i]['color'] = "#3498DB";

            $data[$i]['start'] = $tk['TaskAssign']['starttime'];
            $data[$i]['end'] = $tk['TaskAssign']['endtime'];
            $i++;
        }
        foreach ($emp_events as $empe) {
            $data[$i]['id'] = rand(100);
            $data[$i]['title'] = $empe['EmpEvent']['title'];
            $data[$i]['url'] = 'http://' . $_SERVER["SERVER_NAME"] . '/hrportal/users/emp_events_view';
            $data[$i]['color'] = $empe['EmpEvent']['title'];
            $data[$i]['start'] = $empe['EmpEvent']['start'];
            $data[$i]['end'] = $empe['EmpEvent']['end'];
            $i++;
        }
        echo json_encode($data);
    }

    //function to add attendance by the user to get it approved by the manager
    function add_attendance() {

        $this->layout = 'employee-new';
    }

    public function save_attendance() {
        //Configure::write('debug', 2);
        $this->autoRender = false;
        $data = $this->data;
        $det = $this->EmpDetail->getemployeeinfomation($this->Auth->User('emp_code'));
        $attendance_detail = $this->AttendanceDetail->find('first', array('conditions' =>
            array('atten_dt' => date('Y-m-d', strtotime($data['atten_dt'])),
                'status' => array(2, 5), 'emp_doc_id' => $det['MyProfile']['doc_id']))
        );
        $datetime_1 = date('Y-m-d', strtotime($data['atten_dt']));
        $Appleavecount_tets_not = $this->LeaveDetail->find('first', array(
            'conditions' => array(
                "leave_status NOT IN (4,7)", "leave_date" => $datetime_1, 'emp_code' => $this->Auth->User('emp_code'),
                'hlfday_leave_chk' =>'N',"leave_code not in ('PAR0000332','PAR0000011')"
            )
        ));
        if (!empty($Appleavecount_tets_not)) {
            $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert="">
            <a href="#" class="uk-alert-close uk-close"></a>Leave already Approved for same date.</div>');
            $this->redirect('add_attendance');
        }
        $Appleavecount_tets = $this->LeaveDetail->find('first', array(
            'conditions' => array(
                "leave_status NOT IN (4,7)", "leave_date" => $datetime_1, 'emp_code' => $this->Auth->User('emp_code'),
                "leave_code in ('PAR0000332','PAR0000011')"
            )
        ));
        if (!empty($Appleavecount_tets)) {
            // $this->LeaveDetail->delete($Appleavecount_tets['LeaveDetail']['leave_detail_id']);
            //$this->MstEmpLeave->delete($Appleavecount_tets['LeaveDetail']['leave_id']);
            $reason_cont = $Appleavecount_tets['LeaveDetail']['leave_reason'];
        }
        if ($attendance_detail) {
            $data['id'] = $attendance_detail['AttendanceDetail']['id'];
            $data['ded_ch'] = '';
            $data['leave_id'] = '';
        }

        $data['status'] = 2;
        $data['atten_dt'] = date('Y-m-d', strtotime($data['atten_dt']));
        $data['in_time'] = date('Y-m-d H:i', strtotime($data['atten_dt'] . ' ' . $data['in_time']));
        $data['out_time'] = date('Y-m-d H:i', strtotime($data['atten_dt'] . ' ' . $data['out_time']));
        $data['emp_doc_id'] = $det['MyProfile']['doc_id'];
        $data['usr_id_create'] = $det['MyProfile']['emp_code'];
        $data['emp_id'] = $det['MyProfile']['emp_id'];
        $data['usr_id_create_dt'] = date('Y-m-d');
        $data['org_id'] = $det['MyProfile']['comp_code'];
        $data['ho_org_id'] = $det['MyProfile']['comp_code'];
        $data['cld_id'] = '0000';
        $data['sloc_id'] = 1;
        $data['latitude'] = $data['latitude'];
        $data['longitude'] = $data['longitude'];
        $data['address'] = $data['address'];
        $data1['emp_id'] = $det['MyProfile']['emp_id'];
        $data1['status'] = 2;
        $data1['org_id'] = $det['MyProfile']['comp_code'];
        $data1['emp_doc_id'] = $det['MyProfile']['doc_id'];

        if ($det['MyProfile']['manager_code'] != NULL) {
            $data['approver_id'] = $det['MyProfile']['manager_code'];
            $data1['emp_code'] = $det['MyProfile']['manager_code'];
        } else {
            $data['approver_id'] = '209';
            $data1['emp_code'] = '209';
        }

        //$data['approver_id'] = ;
        if ($this->AttendanceDetail->save($data)) {
            if (isset($attendance_detail['AttendanceDetail']['id']))
                $this->Attendanceworkflow->deleteAll(array("attendance_id" => $attendance_detail['AttendanceDetail']['id']));

            $emp_code = $this->Auth->User('emp_code');
            $last_id = $this->AttendanceDetail->getLastInsertID() ? $this->AttendanceDetail->getLastInsertID() : $attendance_detail['AttendanceDetail']['id'];
            $data1['attendance_id'] = $last_id;
            $this->Attendanceworkflow->save($data1);
            $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
            <a href="#" class="uk-alert-close uk-close"></a>Attendance sent for moderation to your manager.</div>');
            $this->redirect('pen_attend_approval');
        } else {
            $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert="">
            <a href="#" class="uk-alert-close uk-close"></a>Some issue in saving attendance.</div>');

            $this->redirect('add_attendance');
        }
    }

    public function attendance_listing() {

        $this->layout = 'employee-new';
        $details = $this->EmpDetail->getemployeeinfomation($this->Auth->User('emp_code'));
        $this->set('details', $details);
    }

    public function pen_attend_approval($val) {
        //Configure::write('debug',2);

        $this->layout = 'employee-new';
        $det = $this->EmpDetail->getemployeeinfomation($this->Auth->User('emp_code'));
        if (!empty($val)) {

            $dt = $val;
            $this->set('pen_val', $dt);
        } else {
            $dt = $this->Common->findpaginateLevel('21');
        }
        $this->paginate = array(
            'fields' => array('*'),
            'conditions' => array(
                'AttendanceDetail.status in' => array(2, 5, 6), 'AttendanceDetail.emp_id' => $this->Auth->User('emp_id')),
            /* 'or'=>array(

              'AttendanceDetail.approver_id' => $det['MyProfile']['emp_code'],
              'AttendanceDetail.emp_doc_id' => $det['MyProfile']['doc_id'],

              )), */
            'limit' => $dt,
            'order' => 'atten_dt DESC',
        );

        $pen_attendances = $this->paginate('AttendanceDetail');
        $this->set('page_heading', "List of Applied Attendance");

        $this->set('pen_attendances', $pen_attendances);

        $this->set('page_name', 'PENDING_ATTENDANCE');
    }

    public function attendance_approve($val) {
        //Configure::write('debug',2);
        if (!empty($val)) {

            $dt = $val;
            $this->set('pen_val', $dt);
        } else {
            $dt = $this->Common->findpaginateLevel('21');
        }
        $this->layout = 'employee-new';
        $det = $this->EmpDetail->getemployeeinfomation($this->Auth->User('emp_code'));
        $this->paginate = array(
            'fields' => array('*'),
            'joins' => array(
                array(
                    'table' => 'attendance_wf',
                    'alias' => 'at',
                    'type' => 'inner',
                    'foreignKey' => false,
                    'conditions' => array('at.emp_doc_id = AttendanceDetail.emp_doc_id', 'at.attendance_id = AttendanceDetail.id', 'at.emp_code' => $this->Auth->User('emp_code'))
                ),
            ),
            'order' => 'AttendanceDetail.atten_dt DESC'
        );

        $pen_attendances = $this->paginate('AttendanceDetail');
        $this->set('pen_attendances', $pen_attendances);
    }

    public function hr_attendance_approve() {
        //Configure::write('debug',2);
        $this->layout = 'employee-new';


        $det = $this->EmpDetail->getemployeeinfomation($this->Auth->User('emp_code'));

        $dt = $this->Common->findpaginateLevel('21');

        $this->paginate = array(
            'fields' => array('*'),
            'conditions' => array(
                'AttendanceDetail.approver_id' => $det['MyProfile']['emp_code'],
                'AttendanceDetail.status' => 6),
            'limit' => $dt,
            'order' => 'atten_dt DESC'
        );


        $pen_attendances = $this->paginate('AttendanceDetail');
        $this->set('pen_attendances', $pen_attendances);
    }

    public function approve_attendance($atten_id) {
        //Configure::write('debug',2);
        //$det = $this->EmpDetail->getemployeeinfomation($this->Auth->User('emp_code'));
        $this->autoRender = false;
        $data['id'] = $atten_id;
        $data['status'] = 5;
        $data1['attendance_id'] = $atten_id;
        $data1['status'] = 5;

//print_r($data);die;
        $this->AttendanceDetail->save($data);
        //$this->Attendanceworkflow->save($data1);

        $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                            <a href="#" class="uk-alert-close uk-close"></a>Attendance approved successfully !!!</div>');

        $this->redirect('attendance_approve');
    }

    public function forward_attendance($atten_id) {
        //Configure::write('debug',2);
        $this->layout = 'employee-new';


        $det = $this->EmpDetail->getemployeeinfomation($this->Auth->User('emp_code'));
        $dt = $this->Common->findpaginateLevel('21');
        $this->paginate = array(
            'fields' => array('*'),
            'conditions' => array(
                'AttendanceDetail.approver_id' => $det['MyProfile']['emp_code'], 'AttendanceDetail.id' => $atten_id,
                'AttendanceDetail.status' => 2),
            'limit' => $dt,
            'order' => 'atten_dt DESC'
        );
        $pen_attendances = $this->paginate('AttendanceDetail');
        $this->set('pen_attendances', $pen_attendances);
    }

    public function hr_approve_attendance() {

        $this->autoRender = false;
        $data['id'] = $this->data['AttendanceDetail']['id'];
        $data['hr_code'] = $this->data['AttendanceDetail']['hr_emp_code'];
        $data['approver_id'] = $this->data['AttendanceDetail']['hr_emp_code'];
        $data['hr_approval_status'] = $this->data['AttendanceDetail']['type'];
        $data['status'] = $this->data['AttendanceDetail']['reject_remark']? 4:6;
        $data['modify_date'] = date('y-m-d');
        $data['reject_remark'] = $this->data['AttendanceDetail']['approve_remark']?$this->data['AttendanceDetail']['approve_remark']:$this->data['AttendanceDetail']['reject_remark'];
        
        $forward = $this->AttendanceDetail->save($data);
        
        if (!empty($forward)) {
            if($data['status'] == 4){
                $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert="">
                            <a href="#" class="uk-alert-close uk-close"></a>Attendance rejected successfully !!!</div>');
            }
            else{
                $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                            <a href="#" class="uk-alert-close uk-close"></a>Attendance forward successfully !!!</div>');
            }
            

            $this->redirect('attendance_approve');
        }
    }

    public function reject_attendance() {

        $this->autoRender = false;
        $data['id'] = $this->data['Attendence']['rejectid'];
        $data['status'] = 4;
        $data['reject_remark'] = $this->data['Attendence']['remark'];

        $this->AttendanceDetail->save($data);
        $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                            <a href="#" class="uk-alert-close uk-close"></a>Attendance rejected </div>');

        $this->redirect('attendance_approve');
    }

    public function attendance_report($mon_new = null, $yr_new = null, $today = null) {

        $user_code = $this->request->data['Users']['Employee'];
        $mon_new = $this->request->data('Users.month');
        $yr_new = $this->request->data('Users.year');
        $date = date('Y-m-d');
        $months = array(
            '0' => 'Select month',
            '1' => 'January',
            '2' => 'February',
            '3' => 'March',
            '4' => 'April',
            '5' => 'May',
            '6' => 'June',
            '7' => 'July',
            '8' => 'August',
            '9' => 'September',
            '10' => 'October',
            '11' => 'November',
            '12' => 'December',
        );
        $years = array('0' => 'Select year', '2016' => '2016', '2017' => '2017', '2018' => '2018');
        if (!isset($mon) || $mon == 0) {
            $mon = date('m');
        }
        if (!isset($yr) || $yr == 0) {
            $yr = date('Y');
        }
        if ($mon_new != null && $yr_new != null) {
            $condition['atten_dt >='] = "$yr_new-$mon_new-01";
            $condition['atten_dt <='] = "$yr_new-$mon_new-31";
        } else {
            $condition['atten_dt ='] = $date;
        }


        $this->layout = 'employee-new';
        if (!empty($this->request->data['Users']['Employee'])) {




            $condition['emp_doc_id'] = $this->request->data['Users']['Employee'];
        }

//print_r($condition);die;
        $det = $this->EmpDetail->getemployeeinfomation($this->Auth->User('emp_code'));
        $all_attendance = $this->AttendanceDetail->find('all', array(
            'conditions' => $condition,
            'order' => 'atten_dt',
            'fields' => array('usr_id_create_dt', 'description', 'atten_dt', 'in_time', 'out_time', 'status', 'reject_remark', 'emp_doc_id')
        ));

        // Configure::write('debug',2);
        $header = array('Sno', 'Employee Name', 'Attendance Date', 'Applied Date', 'in_time', 'out_time', 'status');
        $ctr = 1;
        if ($this->request->data('post_Salary') == 'EXPORT') {

            $this->autoRender = false;

            foreach ($all_attendance as $key => $value) {
                $value['AttendanceDetails']['emp_doc_id'] = $this->Common->getempname_bydoc_id($value['AttendanceDetail']['emp_doc_id']);
                $value['AttendanceDetails']['attendance_data'] = date('d-m-y', strtotime($value['AttendanceDetail']['atten_dt']));
                $value['AttendanceDetails']['usr_id_create_dt'] = date('d-m-y', strtotime($value['AttendanceDetail']['usr_id_create_dt']));
                $value['AttendanceDetails']['in_time'] = $value['AttendanceDetail']['in_time'];
                $value['AttendanceDetails']['out_time'] = $value['AttendanceDetail']['out_time'];
                $value['AttendanceDetails']['status'] = $this->Common->findstatus($value['AttendanceDetail']['status']);

                $val['Sno'] = $ctr;
                $val = array_merge($val, $value['AttendanceDetails']);

                $input_array[$ctr] = $val;

                $ctr++;
            }
            $this->convert_to_csv_download($input_array, $header, 'Attendance.csv', ',');
        }
        $this->Session->write('AttendanceList', $all_attendance);
        $input_array = $this->Session->read('AttendanceList');
        $this->set('page_heading', "Attendance list");
        $this->set('months', $months);
        $this->set('current_month', $mon);
        $this->set('current_year', $yr);
        $this->set('years', $years);
        $this->set('pen_attendances', $all_attendance);
        $this->set('page_name', 'ATTENDANCE_LIST');
        $this->render('attendance_report');
    }

    public function attendance_list($mon_new = null, $yr_new = null) {

        $months = array(
            '0' => 'Select month',
            '1' => 'January',
            '2' => 'February',
            '3' => 'March',
            '4' => 'April',
            '5' => 'May',
            '6' => 'June',
            '7' => 'July',
            '8' => 'August',
            '9' => 'September',
            '10' => 'October',
            '11' => 'November',
            '12' => 'December',
        );

        $years = array('0' => 'Select year', '2016' => '2016', '2017' => '2017', '2018' => '2018');
        if (!isset($mon) || $mon == 0) {
            $mon = date('m');
        }
        if (!isset($yr) || $yr == 0) {
            $yr = date('Y');
        }
        if ($mon_new != null && $yr_new != null) {
            $condition['atten_dt >='] = "$yr_new-$mon_new-01";
            $condition['atten_dt <='] = "$yr_new-$mon_new-31";
        }
        $this->layout = 'employee-new';
        $det = $this->EmpDetail->getemployeeinfomation($this->Auth->User('emp_code'));
        //print_r($det); die;
        $condition['emp_doc_id'] = $det['MyProfile']['doc_id'];
        $all_attendance = $this->AttendanceDetail->find('all', array(
            'conditions' => $condition,
            'fields' => array('usr_id_create_dt', 'description', 'atten_dt', 'in_time', 'out_time', 'status', 'reject_remark')
        ));

        $this->Session->write('AttendanceList', $all_attendance);
        $input_array = $this->Session->read('AttendanceList');
        $this->set('page_heading', "Attendance list");
        $this->set('months', $months);
        $this->set('current_month', $mon);
        $this->set('current_year', $yr);
        $this->set('years', $years);
        $this->set('pen_attendances', $all_attendance);
        $this->set('page_name', 'ATTENDANCE_LIST');
        $this->render('pen_attend_approval');
    }

    public function filter_attendance() {
        $this->autoRender = false;
        if ($this->request->data) {

            $mon = $this->data['Users']['month'];
            $yr = $this->data['Users']['year'];
            $det = $this->EmpDetail->getemployeeinfomation($this->Auth->User('emp_code'));
            $all_attendance = $this->AttendanceDetail->find('all', array(
                'conditions' => array(
                    'emp_doc_id' => $det['MyProfile']['doc_id'],
                    'atten_dt BETWEEN ? and ?' => array("$yr-$mon-01", "$yr-$mon-31"),
                ),
                'fields' => array('description', 'atten_dt', 'in_time', 'out_time')
            ));
            $header = array('Sno', 'Description', 'Date', 'in_time', 'out_time');

            $ctr = 1;
            if ($this->request->data('post_Salary') == 'EXPORT') {
                //print_r($all_attendance); die;
                foreach ($all_attendance as $key => $value) {
                    $val['Sno'] = $ctr;
                    $val = array_merge($val, $value['AttendanceDetail']);
                    $input_array[$ctr] = $val;
                    $ctr++;
                }
                $this->convert_to_csv_download($input_array, $header, 'Attendance.csv', ',');
            } else {
                $this->attendance_list($mon, $yr);
            }
        }
    }

    //function to allow user to download file in CSV format
    function convert_to_csv_download($input_array, $header, $output_file_name, $delimiter) {
        $f = fopen('php://memory', 'w');
        /** loop through array  */
        fputcsv($f, $header, $delimiter);

        foreach ($input_array as $line) {
            /** default php csv handler * */
            fputcsv($f, $line, $delimiter);
        }
        fseek($f, 0);
        // tell the browser it's going to be a csv file
        header('Content-Type: application/csv');
        // tell the browser we want to save it instead of displaying it
        header('Content-Disposition: attachment; filename="' . $output_file_name . '";');
        // make php send the generated csv lines to the browser
        fpassthru($f);
        exit();
    }

    public function addnew() {
        $this->layout = false;
    }

    public function rejectId($id) {
        $this->layout = false;
        $this->set('rejectid', $id);
    }

    public function EmployeeList() {
        $this->layout = 'employee-new';
        $list = $this->paginate('MyProfile');
        $this->set('emp', $list);
    }

    public function medicalConfig() {
        $this->autoload = false;
        if ($this->request->is('post') && !empty($this->request->data)) {
            if ($this->data['settingsave'] == 'Enable') {
                $data = $this->request->data['pending_docs'];
                if (!empty($data)) {
                    foreach ($data as $key => $value) {
                        $this->MyProfile->id = $this->request->data['pending_docs_vl'][$key];
                        $this->MyProfile->saveField('config', 1);
                    }
                    $this->Session->setFlash('Medical Link Enabled');
                    $this->redirect('dashboard');
                }
            } else {
                $data = $this->request->data['pending_docs'];
                if (!empty($data)) {
                    foreach ($data as $key => $value) {

                        $this->MyProfile->id = $this->request->data['pending_docs_vl'][$key];
                        $this->MyProfile->saveField('config', 0);
                    }
                    $this->Session->setFlash('Medical Link Disabled');
                    $this->redirect('dashboard');
                }
            }
        }
    }

    public function emp_events() {
        $this->autoload = false;
        $emp_code = $this->Auth->User('emp_code');
        $value = array();
        if ($_POST['title'] != '') {
            $value['title'] = $_POST['title'];
            ;
            $value['start'] = date('Y-m-d ', $_POST['date'] / 1000);
            $value['end'] = date('Y-m-d ', $_POST['date'] / 1000);
            if ($_POST['color'] != '') {
                $value['color'] = $_POST['color'];
            } else {
                $value['color'] = '#ef6c00';
            }
            $value['emp_code'] = $emp_code;
        }
        $this->EmpEvent->save($value);
    }

    public function emp_events_view() {
        $this->autoload = false;
        $this->layout = 'employee-new';
        $emp_code = $this->Auth->User('emp_code');
        $events = $this->EmpEvent->find('all', array('conditions' => array('emp_code' => $emp_code)));
        $this->set('events', $events);
    }

    public function getNotification() {
        
    }

    public function getIFSC($id) {
        $this->autoRender = false;
        $bank = new Model(array('table' => 'oracle_app_eo', 'ds' => 'default', 'name' => 'BANK_DETAILS'));
        $val = $bank->find('first', array('fields' => array('eo_ifsc_cd'), 'conditions' => array('eo_id' => $id)));
        if (!empty($val)) {
            return $val['BANK_DETAILS']['eo_ifsc_cd'];
        } else {
            return 'N/A';
        }
    }

    public function getBranch($id) {
        // echo $id;
        Configure::write('debug', 2);
        $this->autoRender = false;
        $bank = new Model(array('table' => 'oracle_app_eo', 'ds' => 'default', 'name' => 'BANK_DETAILS'));
        $val = $bank->find('all', array('fields' => array('eo_id', 'eo_nm'), 'conditions' => array('eo_type' => 74, 'eo_mst_id' => $id)));
        //print_r($val); die;
        if (!empty($val)) {
            $html = '<select class="md-input" name="branch_code" data-md-selectize-inline onChange="getIFSC(this.value)">';
            foreach ($val as $v) {
                $html .= '<option  value=' . $v["BANK_DETAILS"]["eo_id"] . '>' . $v["BANK_DETAILS"]["eo_nm"] . '</option>';
            }
            $html .= '</select>';
            echo $html;
            die;
        }
    }

    public function get_table_list() {
        $db = ConnectionManager::getDataSource('default');
        foreach ($db->listSources() as $model) {
            $new[$model] = $db->describe($model);
        }
        echo "<pre>";
        print_r($new);
        die;
    }

    public function language() {
        $lang = $this->request->data['langu'];
        $this->Session->write('Config.language', $lang);
        if ($lang == 'fr') {
            $this->Session->setFlash('Langue avec succès changé');
        } else if ($lang == 'hin') {
            $this->Session->setFlash('भाषा सफलतापूर�?वक बदल');
        } else
            $this->Session->setFlash('Language successfully changed');
        $this->redirect($_SERVER['HTTP_REFERER']);
    }

    public function getInOutTime() {
        if ($this->data['date']) {
            $attendance_detail = $this->AttendanceDetail->
                    find('first', array('fields' =>
                array('in_time', 'out_time'),
                'conditions' => array(
                    'atten_dt' => date('Y-m-d', strtotime($this->data['date'])),
                    'status' => array(2, 5),
                    'emp_id' => $this->Auth->user('emp_id'))));

            echo json_encode($attendance_detail);
            exit;
        }
    }

}
