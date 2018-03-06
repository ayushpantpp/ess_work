<?php

ob_start();
App::import('phpexcel');
App::import('uploader');
App::uses('CakeEmail', 'Network/Email');

class TrainingController extends AppController {

    var $uses = array('Company', 'CourseTypeMaster', 'CourseCategoryMaster', 'CourseValidityMaster', 'TrainingCourseCreation', 'TrainingScheduleCreation', 'fLeaveEncashmentWorkflow', 'Leave', 'MstEmpLeave', 'MstLeaveType', 'MstEmpLeaveAllot', 'WfMstStatus', 'LeaveDetail', 'LeaveWorkflow', 'Holiday', 'WeekHoliday', 'WeekHolidayList', 'MyProfile', 'WfDtAppMapLvl', 'LeaveGrp', 'LeaveEncsh', 'LeaveEncshDt', 'SalaryDetail', 'SalaryProcessing', 'SalaryProcessingAddition', 'SalaryProcessingDeduction', 'OptionAttribute', 'OrgHcmLeave1', 'LeaveConfiguration', 'TrainingCourseCreation', 'TrainingCreation', 'TrainingEmployee', 'TrainingWorkflow', 'TrainingCourseAttendence', 'TrainingConfig', 'TrainingParameters', 'TrainingFeedback', 'TrainingTrainerFeedback', 'TrainingValidityMaster', 'TrainingMatrixAssignEmployee', 'TrainingDtMatrix', 'TrainingMstMatrix');
    var $components = array('Session', 'Cookie', 'RequestHandler', 'Auth', 'EmpDetail', 'TrainingCmp', 'Common', 'ExportXls', 'Email');
    var $helpers = array('Html', 'Js', 'Form', 'Session', 'Userdetail', 'Leave', 'Common');

    function beforeFilter() {
        parent::beforeFilter();
        $currentUser = $this->checkUser();
        $this->Auth->allow();
        $pram_id = $this->OptionAttribute->find('first', array('fields' => array('OptionAttribute.id'), 'conditions' => array('OptionAttribute.name' => 'EXECUTIVE TRAINEE', 'options_id' => 4)));
        $emp_code = $this->Auth->User('emp_code');
        $trainee_emp_details = $this->EmpDetail->getemployeeinfomation($emp_code);
        if (!empty($pram_id)) {
            if ($trainee_emp_details['MyProfile']['desg_code'] == $pram_id['OptionAttribute']['id'])
                $this->set('userType', 'TI');
        }else {
            $this->set('$userType', '');
        }
        $this->set('status', $this->WfMstStatus->find('list', array('fields' => array('id', 'status_name'))));
        $this->set('appId', 6);
    }

    public function initialize() {
        parent::initialize();
        $this->loadComponent('Csrf');
    }

    function index() {

        try {
            
        } catch (Exception $e) {
            
        }
    }

    public function cousre_masters() {
        $this->layout = 'employee-new';
        $emp_code = $this->Auth->User('emp_code');
        $comp_code = $this->Auth->User('comp_code');
        $emp_details = $this->EmpDetail->getemployeeinfomation($emp_code);
        $emp_name = $this->MyProfile->find('first', array('fields' => array('*'), 'conditions' => array('emp_code' => $this->Auth->user('emp_code'))));
        $this->paginate = array(
            'fields' => array('*'),
            'limit' => 60,
            'order' => 'CourseTypeMaster.type_id DESC',
                //'conditions' => array('CourseTypeMaster.emp_code' => $emp_code)
        );
        $courseTypeList = $this->paginate('CourseTypeMaster');
        $this->set('courseTypeLists', $courseTypeList);

        $courseCategoryList = $this->CourseCategoryMaster->find('all', array(
            'fields' => array('*'),
            'order' => 'CourseCategoryMaster.category_id DESC',
//            'conditions' => array(
//                'emp_code' => $this->Auth->User('emp_code'))
        ));

        $this->set('courseCategoryLists', $courseCategoryList);

        $courseValidityList = $this->CourseValidityMaster->find('all', array(
            'fields' => array('*'),
            'order' => 'CourseValidityMaster.validity_id DESC',
//            'conditions' => array(
//                'emp_code' => $this->Auth->User('emp_code'))
        ));
        $this->set('courseValidityLists', $courseValidityList);
        $company_list = $this->Company->find('list', array(
            'fields' => array('comp_code', 'comp_name'),
            'conditions' => array('status' => 1, 'comp_code' => $comp_code)
        ));
        $this->set('company_lists', $company_list);
    }

    /*
     * Add Course Types
     */

    function addCourseType() {
        //Configure::write('debug', 2);
        $emp_code = $this->Auth->User('emp_code');
        $emp_details = $this->EmpDetail->getemployeeinfomation($emp_code);
        $emp_name = $this->MyProfile->find('first', array('fields' => array('*'), 'conditions' => array('emp_code' => $this->Auth->user('emp_code'))));

        $type_value['name'] = $this->data['type_name'];
        $type_value['org_id'] = $this->data['Training']['org_id'];
        if (!empty($this->data['status']))
            $type_value['status'] = $this->data['status'];
        else
            $type_value['status'] = 0;
        $type_value['emp_code'] = $emp_code;
        $type_value['created_at'] = date("Y-m-d");

        $chkName = $this->CourseTypeMaster->find('all', array(
            'fields' => array('count(type_id)'),
            'conditions' => array(
                'lower(name)' => strtolower($type_value['name']), 'org_id' => $type_value['org_id'])
        ));

        if (!empty($chkName) && $chkName[0][0]['count(type_id)'] >= 1) {
            $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert=""><a href="#" class="uk-alert-close uk-close"></a>Course Type Name already exist.</div>');
            $this->redirect('/training/cousre_masters/');
        }

        $this->CourseTypeMaster->create();

        if ($this->CourseTypeMaster->save($type_value)) {
            $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert=""><a href="#" class="uk-alert-close uk-close"></a>Course Type successfully saved.</div>');
            $record_id = $this->CourseTypeMaster->getLastInsertID();
            $this->redirect('/training/cousre_masters/');
        }
    }

    /*
     * Delete Type Course
     */

    function deleteCourseType($type_id) {
        $type_id = base64_decode($type_id);
        $ld = $this->CourseTypeMaster->find('list', array(
            'conditions' => array(
                'type_id' => $type_id
            )
        ));

        foreach ($ld as $key => $value) {
            $this->CourseTypeMaster->delete($key);
        }
        $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                            <a href="#" class="uk-alert-close uk-close"></a>Course Type deleted sucessfully</div>');
        $this->redirect('/training/cousre_masters/');
    }

    /*
     * Get Course Type
     */

    function typedetail() {
        try {
            $id = $this->params['pass']['0'];
            if (!empty($id)) {
                $ldetails = $this->CourseTypeMaster->find('first', array(
                    'fields' => array('*'),
                    'conditions' => array('type_id' => $id)
                ));
                $this->set('ldetails', $ldetails);
                $company_list = $this->Company->find('list', array(
                    'fields' => array('comp_code', 'comp_name'),
                    'conditions' => array('status' => 1)
                ));
                $this->set('company_lists', $company_list);
                $this->layout = '';
                $this->render('typedetail');
            }
        } catch (Exception $e) {
            
        }
    }

    /*
     * Update Course Type
     */

    function updateTypeDetail() {

        $this->autoload = false;
        $emp_code = $this->Auth->User('emp_code');
        $emp_details = $this->EmpDetail->getemployeeinfomation($emp_code);
        $emp_name = $this->MyProfile->find('first', array('fields' => array('*'), 'conditions' => array('emp_code' => $this->Auth->user('emp_code'))));

        $type_value['type_id'] = $this->data['type_id'];
        $type_value['org_id'] = $this->data['Training']['org_id'];
        $type_value['name'] = $this->data['type_name'];
        if (!empty($this->data['status']))
            $type_value['status'] = $this->data['status'];
        else
            $type_value['status'] = 0;
        //$type_value['emp_code'] = $emp_code;

        $chkName = $this->CourseTypeMaster->find('all', array(
            'fields' => array('count(type_id)'),
            'conditions' => array(
                'lower(name)' => strtolower($type_value['name']),
                'type_id !=' => $this->data['type_id'],
                'org_id' => $type_value['org_id']
            )
        ));

        if (!empty($chkName) && $chkName[0][0]['count(type_id)'] >= 1) {
            $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert=""><a href="#" class="uk-alert-close uk-close"></a>Course Type Name already exist.</div>');
            $this->redirect('/training/cousre_masters/');
        }

        if ($this->CourseTypeMaster->save($type_value)) {
            $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert=""><a href="#" class="uk-alert-close uk-close"></a>Course Type updated successfully.</div>');
            $this->redirect('/training/cousre_masters/');
        }
    }

    /*
     * Add Course Category
     */

    function addCourseCategory() {
//Configure::write('debug', 2);
        $emp_code = $this->Auth->User('emp_code');
        $emp_details = $this->EmpDetail->getemployeeinfomation($emp_code);
        $emp_name = $this->MyProfile->find('first', array('fields' => array('*'), 'conditions' => array('emp_code' => $this->Auth->user('emp_code'))));

        $type_value['name'] = $this->data['category_name'];
        $type_value['org_id'] = $this->data['Training']['org_id'];
        if (!empty($this->data['status']))
            $type_value['status'] = $this->data['status'];
        else
            $type_value['status'] = 0;
        $type_value['emp_code'] = $emp_code;
        $type_value['created_at'] = date("Y-m-d");

        $chkName = $this->CourseCategoryMaster->find('all', array(
            'fields' => array('count(category_id)'),
            'conditions' => array(
                'lower(name)' => strtolower($type_value['name']), 'org_id' => $type_value['org_id'])
        ));

        if (!empty($chkName) && $chkName[0][0]['count(category_id)'] >= 1) {
            $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert=""><a href="#" class="uk-alert-close uk-close"></a>Course Category Name already exist.</div>');
            $this->redirect('/training/cousre_masters/');
        }

        $this->CourseCategoryMaster->create();

        if ($this->CourseCategoryMaster->save($type_value)) {
            $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert=""><a href="#" class="uk-alert-close uk-close"></a>Course Category successfully saved.</div>');
            $record_id = $this->CourseCategoryMaster->getLastInsertID();
            $this->redirect('/training/cousre_masters/');
        }
    }

    /*
     * Delete Category Course
     */

    function deleteCategoryType($type_id) {
        $type_id = base64_decode($type_id);
        $ld = $this->CourseCategoryMaster->find('list', array(
            'conditions' => array(
                'category_id' => $type_id
            )
        ));

        foreach ($ld as $key => $value) {
            $this->CourseCategoryMaster->delete($key);
        }
        $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                            <a href="#" class="uk-alert-close uk-close"></a>Course Category deleted sucessfully</div>');
        $this->redirect('/training/cousre_masters/');
    }

    /*
     * Get Course Category
     */

    function categorydetail() {
        try {
            $id = $this->params['pass']['0'];
            if (!empty($id)) {
                $ldetails = $this->CourseCategoryMaster->find('first', array(
                    'fields' => array('*'),
                    'conditions' => array('category_id' => $id)
                ));
                $this->set('ldetails', $ldetails);
                $company_list = $this->Company->find('list', array(
                    'fields' => array('comp_code', 'comp_name'),
                    'conditions' => array('status' => 1)
                ));
                $this->set('company_lists', $company_list);
                $this->layout = '';
                $this->render('categorydetail');
            }
        } catch (Exception $e) {
            
        }
    }

    /*
     * Update Course Category
     */

    function updateCategoryDetail() {

        $this->autoload = false;
        $emp_code = $this->Auth->User('emp_code');
        $emp_details = $this->EmpDetail->getemployeeinfomation($emp_code);
        $emp_name = $this->MyProfile->find('first', array('fields' => array('*'), 'conditions' => array('emp_code' => $this->Auth->user('emp_code'))));

        $type_value['category_id'] = $this->data['category_id'];
        $type_value['name'] = $this->data['category_name'];
        $type_value['org_id'] = $this->data['Training']['org_id'];
        if (!empty($this->data['status']))
            $type_value['status'] = $this->data['status'];
        else
            $type_value['status'] = 0;
        //$type_value['emp_code'] = $emp_code;

        $chkName = $this->CourseCategoryMaster->find('all', array(
            'fields' => array('count(category_id)'),
            'conditions' => array(
                'lower(name)' => strtolower($type_value['name']),
                'category_id !=' => $this->data['category_id'],
                'org_id' => $type_value['org_id']
            )
        ));

        if (!empty($chkName) && $chkName[0][0]['count(category_id)'] >= 1) {
            $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert=""><a href="#" class="uk-alert-close uk-close"></a>Course Category Name already exist.</div>');
            $this->redirect('/training/cousre_masters/');
        }

        if ($this->CourseCategoryMaster->save($type_value)) {
            $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert=""><a href="#" class="uk-alert-close uk-close"></a>Course Category updated successfully.</div>');
            $this->redirect('/training/cousre_masters/');
        }
    }

    /*
     * Add Course Validity
     */

    function addCourseValidity() {

        $emp_code = $this->Auth->User('emp_code');
        $emp_details = $this->EmpDetail->getemployeeinfomation($emp_code);
        $emp_name = $this->MyProfile->find('first', array('fields' => array('*'), 'conditions' => array('emp_code' => $this->Auth->user('emp_code'))));

        $type_value['validity_master_id'] = $this->data['Training']['validity_name'];
        $type_value['org_id'] = $this->data['Training']['org_id'];
        if (!empty($this->data['status']))
            $type_value['status'] = $this->data['status'];
        else
            $type_value['status'] = 0;
        $type_value['emp_code'] = $emp_code;
        $type_value['created_at'] = date("Y-m-d");

        $chkName = $this->CourseValidityMaster->find('all', array(
            'fields' => array('count(validity_id)'),
            'conditions' => array(
                'validity_master_id' => $this->data['Training']['validity_name'], 'org_id' => $type_value['org_id'])
        ));

        if (!empty($chkName) && $chkName[0][0]['count(validity_id)'] >= 1) {
            $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert=""><a href="#" class="uk-alert-close uk-close"></a>Course Validity Name already exist.</div>');
            $this->redirect('/training/cousre_masters/');
        }

        $this->CourseValidityMaster->create();

        if ($this->CourseValidityMaster->save($type_value)) {
            $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert=""><a href="#" class="uk-alert-close uk-close"></a>Course Validity successfully saved.</div>');
            $record_id = $this->CourseValidityMaster->getLastInsertID();
            $this->redirect('/training/cousre_masters/');
        }
    }

    /*
     * Delete Validity Course
     */

    function deleteValidityType($type_id) {
        $type_id = base64_decode($type_id);
        $ld = $this->CourseValidityMaster->find('list', array(
            'conditions' => array(
                'validity_id' => $type_id
            )
        ));

        foreach ($ld as $key => $value) {
            $this->CourseValidityMaster->delete($key);
        }
        $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                            <a href="#" class="uk-alert-close uk-close"></a>Course Validity deleted sucessfully</div>');
        $this->redirect('/training/cousre_masters/');
    }

    /*
     * Get Course Validity
     */

    function validitydetail() {
        try {
            $id = $this->params['pass']['0'];
            if (!empty($id)) {
                $ldetails = $this->CourseValidityMaster->find('first', array(
                    'fields' => array('*'),
                    'conditions' => array('validity_id' => $id)
                ));
                $this->set('ldetails', $ldetails);
                $company_list = $this->Company->find('list', array(
                    'fields' => array('comp_code', 'comp_name'),
                    'conditions' => array('status' => 1)
                ));
                $this->set('company_lists', $company_list);
                $this->layout = '';
                $this->render('validitydetail');
            }
        } catch (Exception $e) {
            
        }
    }

    /*
     * Update Course Validity
     */

    function updateValidityDetail() {

        $this->autoload = false;
        $emp_code = $this->Auth->User('emp_code');
        $emp_details = $this->EmpDetail->getemployeeinfomation($emp_code);
        $emp_name = $this->MyProfile->find('first', array('fields' => array('*'), 'conditions' => array('emp_code' => $this->Auth->user('emp_code'))));

        $type_value['validity_id'] = $this->data['validity_id'];
        $type_value['validity_master_id'] = $this->data['Training']['validity_name'];
        $type_value['org_id'] = $this->data['Training']['org_id'];
        if (!empty($this->data['status']))
            $type_value['status'] = $this->data['status'];
        else
            $type_value['status'] = 0;
        //$type_value['emp_code'] = $emp_code;

        $chkName = $this->CourseValidityMaster->find('all', array(
            'fields' => array('count(validity_id)'),
            'conditions' => array(
                'validity_master_id' => $this->data['Training']['validity_name'],
                'validity_id !=' => $this->data['validity_id'],
                'org_id' => $type_value['org_id']
            )
        ));

        if (!empty($chkName) && $chkName[0][0]['count(validity_id)'] >= 1) {
            $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert=""><a href="#" class="uk-alert-close uk-close"></a>Course Validity Name already exist.</div>');
            $this->redirect('/training/cousre_masters/');
        }

        if ($this->CourseValidityMaster->save($type_value)) {
            $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert=""><a href="#" class="uk-alert-close uk-close"></a>Course Validity updated successfully.</div>');
            $this->redirect('/training/cousre_masters/');
        }
    }

    /*
     * Add Course Schedule 
     */

    function addCourseSchedule() {
        $this->layout = 'employee-new';
        $emp_code = $this->Auth->User('emp_code');
        $emp_details = $this->EmpDetail->getemployeeinfomation($emp_code);
        $emp_name = $this->MyProfile->find('first', array('fields' => array('*'), 'conditions' => array('emp_code' => $this->Auth->user('emp_code'))));
        $courselist = $this->TrainingCourseCreation->find('list', array(
            'fields' => 'name',
            'conditions' => array('status !=' => 1, 'comp_code' => $emp_details['MyProfile']['comp_code'])
        ));
        $employeelist = $this->Common->getEmployeesListByCompCode();
        $this->set('employeelist', $employeelist);

        $this->set('courselists', $courselist);
    }

    function addCourseCreation() {
        $this->layout = 'employee-new';
        $emp_code = $this->Auth->User('emp_code');
        $comp_code = $this->Auth->User('comp_code');
        $emp_details = $this->EmpDetail->getemployeeinfomation($emp_code);
        $emp_name = $this->MyProfile->find('first', array('fields' => array('*'), 'conditions' => array('emp_code' => $this->Auth->user('emp_code'))));
        $courselist = $this->CourseTypeMaster->find('list', array(
            'fields' => 'name',
            'conditions' => array('status !=' => 1, 'org_id' => $comp_code)
        ));
        $this->set('courselists', $courselist);
        $coursecat = $this->CourseCategoryMaster->find('list', array(
            'fields' => 'name',
            'conditions' => array('status !=' => 1, 'org_id' => $comp_code)
        ));
        $coursevalidity = $this->CourseValidityMaster->find('list', array('fields' => 'validity_master_id', 'conditions' => array('status !=' => 1, 'org_id' => $comp_code)));
        $this->set('coursevalidity', $coursevalidity);
        $this->set('coursecat', $coursecat);
    }

    function updateCourseCreation() {
        $value['course_id'] = $this->data['courseid'];
        $value['type_id'] = $this->data['course_id'];
        $value['name'] = $this->data['course_name'];
        $value['description'] = $this->data['course_description'];
        $value['course_duration_time'] = $this->data['course_duration'];
        $value['course_duration_type'] = $this->data['course_duration_type'];
        $value['cost'] = $this->data['course_Cost'];
        $value['currency'] = $this->data['Training']['course_currency'];
        $value['institute_name'] = $this->data['institute_name'];
        $value['max_class_capacity'] = $this->data['max_capacity'];
// $value['status'] = $this->data['status'];
        $value['course_category_id'] = $this->data['course_category'];
        $value['course_validity_id'] = $this->data['course_validity'];
        $value['updated_at'] = date("Y-m-d");

        if (!empty($this->data['status'])) {
            if ($this->data['status'] == 0) {
                $value['status'] = $this->data['status'];
                $value['active_date'] = date("Y-m-d");
            } else {
                $value['status'] = $this->data['status'];
                $value['inactive_date'] = date("Y-m-d");
            }
        } else {
            $value['status'] = 0;
            $value['active_date'] = date("Y-m-d");
        }

        $chkName = $this->TrainingCourseCreation->find('all', array(
            'fields' => array('count(course_id)'),
            'conditions' => array(
                'type_id' => $value['type_id'], 'course_category_id' => $value['course_category_id'], 'course_validity_id' => $value['course_validity_id'], 'lower(name)' => strtolower($value['name']), 'course_duration_time' => $value['course_duration_time'], 'course_duration_type' => $value['course_duration_type'], 'cost' => $value['cost'], 'currency' => $value['currency'], 'lower(institute_name)' => strtolower($value['institute_name']), 'course_id !=' => $value['course_id'])
        ));
        if (!empty($chkName) && $chkName[0][0]['count(course_id)'] >= 1) {
            $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert=""><a href="#" class="uk-alert-close uk-close"></a>Course is already exist in ths system with the filled details.</div>');
            $this->redirect('/training/editCourseCreation/' . base64_encode($value['course_id']));
        }

        if ($this->TrainingCourseCreation->save($value)) {
            $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert=""><a href="#" class="uk-alert-close uk-close"></a> Course updated successfully .</div>');
            $this->redirect(array('controller' => 'Training', 'action' => 'viewAllCourseCreation'));
        }
    }

    function saveCourseCreation() {

        $emp_code = $this->Auth->User('emp_code');
        $comp_code = $this->Auth->User('comp_code');
        $emp_details = $this->EmpDetail->getemployeeinfomation($emp_code);
        $emp_name = $this->MyProfile->find('first', array('fields' => array('*'), 'conditions' => array('emp_code' => $this->Auth->user('emp_code'))));

        $value['type_id'] = $this->data['course_id'];
        $value['name'] = $this->data['course_name'];
        $value['description'] = $this->data['course_description'];
        $value['course_duration_time'] = $this->data['course_duration'];
        $value['course_duration_type'] = $this->data['course_duration_type'];
        $value['cost'] = $this->data['course_Cost'];
        $value['currency'] = $this->data['Training']['course_currency'];
        $value['institute_name'] = $this->data['institute_name'];
        $value['max_class_capacity'] = $this->data['max_capacity'];
// $value['status'] = $this->data['status'];
        $value['course_category_id'] = $this->data['course_category'];
        $value['course_validity_id'] = $this->data['course_validity'];
        $value['emp_code'] = $emp_code;
        $value['comp_code'] = $comp_code;
        $value['created_at'] = date("Y-m-d");

        if (!empty($this->data['status'])) {
            if ($this->data['status'] == 0) {
                $value['status'] = $this->data['status'];
                $value['active_date'] = date("Y-m-d");
            } else {
                $value['status'] = $this->data['status'];
                $value['inactive_date'] = date("Y-m-d");
            }
        } else {
            $value['status'] = 0;
            $value['active_date'] = date("Y-m-d");
        }

        $chkName = $this->TrainingCourseCreation->find('all', array(
            'fields' => array('count(course_id)'),
            'conditions' => array(
                'type_id' => $value['type_id'], 'course_category_id' => $value['course_category_id'], 'course_validity_id' => $value['course_validity_id'], 'lower(name)' => strtolower($value['name']), 'course_duration_time' => $value['course_duration_time'], 'course_duration_type' => $value['course_duration_type'], 'cost' => $value['cost'], 'currency' => $value['currency'], 'lower(institute_name)' => strtolower($value['institute_name']))
        ));
        if (!empty($chkName) && $chkName[0][0]['count(course_id)'] >= 1) {
            $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert=""><a href="#" class="uk-alert-close uk-close"></a>Course is already exist in ths system with the filled details.</div>');
            $this->redirect('/training/addCourseCreation/');
        }

        $this->TrainingCourseCreation->create();

        if ($this->TrainingCourseCreation->save($value)) {
            $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert=""><a href="#" class="uk-alert-close uk-close"></a> Course Created successfully saved.</div>');
            $record_id = $this->TrainingCourseCreation->getLastInsertID();
            $this->redirect('/training/viewAllCourseCreation/');
        }
    }

    /*
     * Save Course Schedule
     */

    function saveCourseSchedule() {

        $emp_code = $this->Auth->User('emp_code');
        $emp_details = $this->EmpDetail->getemployeeinfomation($emp_code);
        $emp_name = $this->MyProfile->find('first', array('fields' => array('*'), 'conditions' => array('emp_code' => $this->Auth->user('emp_code'))));

        $value['course_id'] = $this->data['course_id'];
        if (!empty($this->data['sch_start_date']))
            $value['sch_start_date'] = date("Y-m-d", strtotime($this->data['sch_start_date']));
        if (!empty($this->data['sch_end_date']))
            $value['sch_end_date'] = date("Y-m-d", strtotime($this->data['sch_end_date']));
        if (!empty($this->data['final_regis_date']))
            $value['final_regis_date'] = date("Y-m-d", strtotime($this->data['final_regis_date']));
        $value['sch_start_time'] = $this->data['sch_start_time'];
        $value['sch_end_time'] = $this->data['sch_end_time'];
        $value['contact_person'] = $this->data['contact_person'];
        $value['contact_number'] = $this->data['contact_number'];
        $value['location'] = $this->data['location'];
        $value['mode'] = $this->data['mode'];
        $value['contact_email'] = $this->data['contact_email'];
        $value['facility'] = $this->data['facility'];
        $value['instructor_name'] = $this->data['Training']['instructor_name'];
        $value['emp_code'] = $emp_code;
        $value['comp_id'] = $emp_details['MyProfile']['comp_code'];
        $value['created_at'] = date("Y-m-d");

        if (!empty($this->data['status'])) {
            if ($this->data['status'] == 0) {
                $value['status'] = $this->data['status'];
                $value['active_date'] = date("Y-m-d");
            } else {
                $value['status'] = $this->data['status'];
                $value['inactive_date'] = date("Y-m-d");
            }
        } else {
            $value['status'] = 0;
            $value['active_date'] = date("Y-m-d");
        }

        $chkName = $this->TrainingScheduleCreation->find('all', array(
            'fields' => array('count(schedule_id)'),
            'conditions' => array(
                'course_id' => $this->data['course_id'], 'sch_start_date' => $value['sch_start_date'], 'sch_end_date' => $value['sch_end_date'], 'sch_start_time' => $this->data['sch_start_time'], 'sch_end_time' => $this->data['sch_end_time'], 'instructor_name' => $value['instructor_name'])
        ));
        if (!empty($chkName) && $chkName[0][0]['count(schedule_id)'] >= 1) {
            $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert=""><a href="#" class="uk-alert-close uk-close"></a>Schedule is already exist in ths system with the filled details.</div>');
            $this->redirect('/training/addCourseSchedule/');
        }

        $this->TrainingScheduleCreation->create();

        if ($this->TrainingScheduleCreation->save($value)) {
            $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert=""><a href="#" class="uk-alert-close uk-close"></a>Schedule Course successfully saved.</div>');
            $record_id = $this->TrainingScheduleCreation->getLastInsertID();
            $this->redirect('/training/scheduleCourse/');
        }
    }

    /*
     * Update Course Schedule
     */

    function editCourseCreation($course_id) {

        $course_id = base64_decode($course_id);
        $this->layout = 'employee-new';
        $emp_code = $this->Auth->User('emp_code');
        $comp_code = $this->Auth->User('comp_code');
        $emp_details = $this->EmpDetail->getemployeeinfomation($emp_code);
        $emp_name = $this->MyProfile->find('first', array('fields' => array('*'), 'conditions' => array('emp_code' => $this->Auth->user('emp_code'))));

        if (empty($course_id)) {
            $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert=""><a href="#" class="uk-alert-close uk-close"></a>Please select correct Course.</div>');
            $this->redirect('/training/cousre_masters/');
        }

        $course = $this->TrainingCourseCreation->find('first', array(
            'fields' => '*',
            'conditions' => array('course_id' => $course_id)
        ));
        $coursevalidity = $this->CourseValidityMaster->find('list', array('fields' => 'validity_master_id', 'conditions' => array('status !=' => 1, 'org_id' => $comp_code)));
        $courselist = $this->CourseTypeMaster->find('list', array(
            'fields' => 'name',
            'conditions' => array('status !=' => 1, 'org_id' => $comp_code)
        ));

        $this->set('courselists', $courselist);
        $this->set('coursevalidity', $coursevalidity);
        $coursecat = $this->CourseCategoryMaster->find('list', array(
            'fields' => 'name',
            'conditions' => array('status !=' => 1, 'org_id' => $comp_code)
        ));

        $this->set('coursecat', $coursecat);
        $this->set('course', $course);
        $this->set('courseid', $course_id);
    }

    function editCourseSchedule($schedule_id) {

        $schedule_id = base64_decode($schedule_id);
        $this->layout = 'employee-new';
        $emp_code = $this->Auth->User('emp_code');
        $emp_details = $this->EmpDetail->getemployeeinfomation($emp_code);
        $emp_name = $this->MyProfile->find('first', array('fields' => array('*'), 'conditions' => array('emp_code' => $this->Auth->user('emp_code'))));

        if (empty($schedule_id)) {
            $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert=""><a href="#" class="uk-alert-close uk-close"></a>Please select correct schedule.</div>');
            $this->redirect('/training/cousre_masters/');
        }

        $courselist = $this->TrainingCourseCreation->find('list', array(
            'fields' => 'name',
            'conditions' => array('status !=' => 1)
        ));
        $this->set('courselists', $courselist);
        $ldetails = $this->TrainingScheduleCreation->find('first', array(
            'fields' => array('*'),
            'conditions' => array('schedule_id' => $schedule_id)
        ));
        $employeelist = $this->Common->getEmployeesListByCompCode();
        $this->set('details', $ldetails);
        $this->set('employeelist', $employeelist);
    }

    /*
     * update Course Schedule
     */

    function updateCourseSchedule() {

        $emp_code = $this->Auth->User('emp_code');
        $emp_details = $this->EmpDetail->getemployeeinfomation($emp_code);
        $emp_name = $this->MyProfile->find('first', array('fields' => array('*'), 'conditions' => array('emp_code' => $this->Auth->user('emp_code'))));

        $value['course_id'] = $this->data['course_id'];
        if (!empty($this->data['sch_start_date']))
            $value['sch_start_date'] = date("Y-m-d", strtotime($this->data['sch_start_date']));
        if (!empty($this->data['sch_end_date']))
            $value['sch_end_date'] = date("Y-m-d", strtotime($this->data['sch_end_date']));
        if (!empty($this->data['final_regis_date']))
            $value['final_regis_date'] = date("Y-m-d", strtotime($this->data['final_regis_date']));

        $value['sch_start_time'] = $this->data['sch_start_time'];
        $value['sch_end_time'] = $this->data['sch_end_time'];
        $value['contact_person'] = $this->data['contact_person'];
        $value['contact_number'] = $this->data['contact_number'];
        $value['location'] = $this->data['location'];
        $value['mode'] = $this->data['mode'];
        $value['contact_email'] = $this->data['contact_email'];
        $value['facility'] = $this->data['facility'];
        $value['instructor_name'] = $this->data['Training']['instructor_name'];
        //$value['emp_code'] = $emp_code;
        //$value['comp_id'] = $emp_details['MyProfile']['comp_code'];

        if (!empty($this->data['status'])) {
            if ($this->data['status'] == 0) {
                $value['status'] = $this->data['status'];
                if (!empty($this->data['active_date']))
                    $value['active_date'] = date("Y-m-d", strtotime($this->data['active_date']));
                else
                    $value['active_date'] = date("Y-m-d");
            } else {
                $value['status'] = $this->data['status'];
                if (!empty($this->data['inactive_date']))
                    $value['inactive_date'] = date("Y-m-d", strtotime($this->data['inactive_date']));
                else
                    $value['inactive_date'] = date("Y-m-d");
            }
        } else {
            $value['status'] = 0;
            $value['active_date'] = date("Y-m-d");
        }

        $value['schedule_id'] = $this->data['schedule_id'];

        $chkName = $this->TrainingScheduleCreation->find('all', array(
            'fields' => array('count(schedule_id)'),
            'conditions' => array(
                'course_id' => $this->data['course_id'], 'sch_start_date' => $value['sch_start_date'], 'sch_end_date' => $value['sch_end_date'], 'sch_start_time' => $this->data['sch_start_time'], 'sch_end_time' => $this->data['sch_end_time'], 'instructor_name' => $value['instructor_name'], 'schedule_id !=' => $value['schedule_id'])
        ));

        if (!empty($chkName) && $chkName[0][0]['count(schedule_id)'] >= 1) {
            $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert=""><a href="#" class="uk-alert-close uk-close"></a>Schedule is already exist in ths system with the filled details.</div>');
            $this->redirect('/training/editCourseSchedule/' . base64_encode($value['schedule_id']));
        }

        if ($this->TrainingScheduleCreation->save($value)) {
            $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert=""><a href="#" class="uk-alert-close uk-close"></a>Schedule Course successfully updated.</div>');
            $this->redirect('/training/scheduleCourse/');
        }
    }

    /*
     * List Schedule Course
     */

    function scheduleCourse($course_id) {
        $course_id = base64_decode($course_id);
        $this->layout = 'employee-new';
        $emp_code = $this->Auth->User('emp_code');
        $emp_details = $this->EmpDetail->getemployeeinfomation($emp_code);
        $emp_name = $this->MyProfile->find('first', array('fields' => array('*'), 'conditions' => array('emp_code' => $this->Auth->user('emp_code'))));

        if (!empty($course_id)) {
            $this->paginate = array(
                'fields' => array('*'),
                'limit' => 40,
                'order' => 'TrainingScheduleCreation.schedule_id DESC',
                'conditions' => array('TrainingScheduleCreation.comp_id' => $emp_details['MyProfile']['comp_code'], 'TrainingScheduleCreation.course_id' => $course_id)
            );
        } else {
            $this->paginate = array(
                'fields' => array('*'),
                'limit' => 40,
                'order' => 'TrainingScheduleCreation.schedule_id DESC',
                'conditions' => array('TrainingScheduleCreation.comp_id' => $emp_details['MyProfile']['comp_code'])
            );
        }
        $coursescheduleList = $this->paginate('TrainingScheduleCreation');
        $this->set('coursescheduleLists', $coursescheduleList);
        $this->set('emp_code', $emp_code);
    }

    /*
     * Delete Scheduled Course
     */

    function deleteScheduleCourse($schedule_id) {
        $schedule_id = base64_decode($schedule_id);
        $ld = $this->TrainingScheduleCreation->find('list', array(
            'conditions' => array(
                'schedule_id' => $schedule_id
            )
        ));

        foreach ($ld as $key => $value) {
            $this->TrainingScheduleCreation->delete($key);
        }
        $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                            <a href="#" class="uk-alert-close uk-close"></a>Schedule Course deleted sucessfully.</div>');
        $this->redirect('/training/scheduleCourse/');
    }

    /*
     * View Schedule Course ID
     */

    function viewCourseSchedule($schedule_id) {
        $schedule_id = base64_decode($schedule_id);
        $this->layout = 'employee-new';
        $emp_code = $this->Auth->User('emp_code');
        $emp_details = $this->EmpDetail->getemployeeinfomation($emp_code);
        $emp_name = $this->MyProfile->find('first', array('fields' => array('*'), 'conditions' => array('emp_code' => $this->Auth->user('emp_code'))));

        if (empty($schedule_id)) {
            $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert=""><a href="#" class="uk-alert-close uk-close"></a>Please select correct schedule.</div>');
            $this->redirect('/training/cousre_masters/');
        }

        $courselist = $this->TrainingCourseCreation->find('list', array(
            'fields' => 'name',
            'conditions' => array('status !=' => 1)
        ));
        $this->set('courselists', $courselist);
        $ldetails = $this->TrainingScheduleCreation->find('first', array(
            'fields' => array('*'),
            'conditions' => array('schedule_id' => $schedule_id)
        ));
        $this->set('details', $ldetails);
    }

    function viewCourseCreation($course_id) {
        $course_id = base64_decode($course_id);
        $this->layout = 'employee-new';
        $emp_code = $this->Auth->User('emp_code');
        $emp_details = $this->EmpDetail->getemployeeinfomation($emp_code);
        $emp_name = $this->MyProfile->find('first', array('fields' => array('*'), 'conditions' => array('emp_code' => $this->Auth->user('emp_code'))));

        if (empty($course_id)) {
            $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert=""><a href="#" class="uk-alert-close uk-close"></a>Please select correct course.</div>');
            $this->redirect('/training/cousre_masters/');
        }

        $courselist = $this->TrainingCourseCreation->find('first', array(
            'fields' => '*',
            'conditions' => array('course_id' => $course_id)
        ));

        $this->set('courselist', $courselist);
    }

    function viewCourseCreations($course_id) {
        $course_id = base64_decode($course_id);
        $this->layout = 'employee-new';
        $emp_code = $this->Auth->User('emp_code');
        $emp_details = $this->EmpDetail->getemployeeinfomation($emp_code);
        $emp_name = $this->MyProfile->find('first', array('fields' => array('*'), 'conditions' => array('emp_code' => $this->Auth->user('emp_code'))));

        if (empty($course_id)) {
            $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert=""><a href="#" class="uk-alert-close uk-close"></a>Please select correct course.</div>');
            $this->redirect('/training/cousre_masters/');
        }

        $courselist = $this->TrainingCourseCreation->find('first', array(
            'fields' => '*',
            'conditions' => array('course_id' => $course_id)
        ));

        $this->set('courselist', $courselist);
    }

    /*
     * Get Course Duration
     */

    function getCourseDuration($courseID) {

        $ldetails = $this->TrainingCourseCreation->find('first', array(
            'fields' => array('TrainingCourseCreation.course_duration_time,TrainingCourseCreation.course_duration_type'),
            'conditions' => array('course_id' => $courseID)
        ));
        echo json_encode($ldetails);
        exit();
    }

    /*
     * Listings All courses and their schedules
     */

    function viewAllCourseSchedule() {
        $this->layout = 'employee-new';
        $emp_code = $this->Auth->User('emp_code');
        $emp_details = $this->EmpDetail->getemployeeinfomation($emp_code);
        $emp_name = $this->MyProfile->find('first', array('fields' => array('*'), 'conditions' => array('emp_code' => $this->Auth->user('emp_code'))));

        $this->paginate = array(
            'fields' => array('*'),
            'limit' => 40,
            'order' => 'TrainingCourseCreation.course_id DESC'
        );
        $classList = $this->paginate('TrainingCourseCreation');
        $this->set('classLists', $classList);
        $this->set('emp_code', $emp_code);
    }

    function viewAllCourseCreation() {
        $this->layout = 'employee-new';
        $emp_code = $this->Auth->User('emp_code');
        $comp_code = $this->Auth->User('comp_code');
        $emp_details = $this->EmpDetail->getemployeeinfomation($emp_code);
        $emp_name = $this->MyProfile->find('first', array('fields' => array('*'), 'conditions' => array('emp_code' => $this->Auth->user('emp_code'))));

        $this->paginate = array(
            'fields' => array('*'),
            'limit' => 40,
            'order' => 'TrainingCourseCreation.course_id DESC',
            'conditions' => array('TrainingCourseCreation.comp_code' => $comp_code)
        );
        $classList = $this->paginate('TrainingCourseCreation');
        $this->set('classLists', $classList);
        $this->set('emp_code', $emp_code);
    }

    public function deleteCourse($courseid) {
        $course_id = base64_decode($courseid);

        if (!empty($course_id)) {
            if ($this->TrainingCourseCreation->delete($course_id)) {
                $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert=""><a href="#" class="uk-alert-close uk-close"></a>Record Deleted Succesfully</div>');
                $this->redirect('/training/viewAllCourseCreation/');
            } else {
                $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert=""><a href="#" class="uk-alert-close uk-close"></a>Record not deleted</div>');
                $this->redirect('/training/viewAllCourseCreation/');
            }
        }
    }

    /*
     * Manage training identification form
     */

    function manageTrainingIdentificationForm() {

        $this->layout = 'employee-new';
        $emp_code = $this->Auth->User('emp_code');
        $emp_details = $this->EmpDetail->getemployeeinfomation($emp_code);
        $emp_name = $this->MyProfile->find('first', array('fields' => array('*'), 'conditions' => array('emp_code' => $this->Auth->user('emp_code'))));
        $userType = $this->TrainingCmp->getTrainingUserType();
        if ($userType == 'TI') {
            $this->paginate = array(
                'fields' => array('*'),
                'limit' => 40,
                'order' => 'TrainingCreation.training_id DESC',
            );
        } else {
            $this->paginate = array(
                'fields' => array('*'),
                'limit' => 40,
                'order' => 'TrainingCreation.training_id DESC',
                'conditions' => array('TrainingCreation.identified_by' => $emp_code)
            );
        }

        $trainingList = $this->paginate('TrainingCreation');
        $this->set("trainingLists", $trainingList);
        $this->set("emp_codes", $emp_code);
    }

    function sanctionTrainingRequests() {

        $this->layout = 'employee-new';
        $emp_code = $this->Auth->User('emp_code');

        $this->paginate = array(
            'fields' => array('*'),
            'limit' => 40,
            'order' => 'TrainingCreation.training_id DESC',
            'joins' => array(
                array(
                    'table' => 'training_workflow',
                    'alias' => 'TrainingWorkflow',
                    'type' => 'inner',
                    'foreignKey' => false,
                    'conditions' => array('TrainingWorkflow.training_creation_id = TrainingCreation.training_id')
                )
            ),
            'conditions' => array('TrainingWorkflow.emp_code' => $emp_code, 'TrainingCreation.emp_code != ' . $emp_code, 'TrainingWorkflow.fwd_date' => NULL)
        );
        $trainingList = $this->paginate('TrainingCreation');
        $this->set("trainingLists", $trainingList);
    }

    public function fwtraining($id) {
        $this->layout = 'employee-new';

        if ($id) {
            $training = $this->TrainingCreation->find('first', array('fields' => array('*'), 'conditions' => array('training_id' => $id)));
            //  print_r($training);die;
            $trainingwfid = $this->TrainingWorkflow->find('first', array('fields' => array('id'),
                'conditions' => array('emp_code' => $this->Auth->User('emp_code'), 'training_creation_id' => $id)));
            $this->set('trainingstatus', $training['TrainingCreation']['status']);
            $this->set('training_id', $training['TrainingCreation']['training_id']);
            $this->set('trainings', $training);
            $this->set('trainingwfid', $trainingwfid['TrainingWorkflow']['id']);
        }
    }

    public function trainingsaveinfo() {
        //Configure::write('debug', 2);
        if (!empty($this->request->data)) {

            //============== Forward==================
            if ($this->request->data['TrainingWorkflow']['type'] == 2) {

                $save = array();
                $save['id'] = $this->request->data['TrainingWorkflow']['id'];
                $save['remarks'] = $this->request->data['TrainingWorkflow']['forward_remark'];
                $save['fwd_date'] = date('Y-m-d');
                $save['status'] = 2;

                $this->TrainingWorkflow->save($save);
                unset($save);
                $check = $this->TrainingWorkflow->find('first', array('conditions' => array(
                        'id' => $this->request->data['TrainingWorkflow']['id'],
                        'emp_code' => $this->request->data['TrainingWorkflow']['forward_emp_code'])));

                if (empty($check)) {
                    $save1 = array();
                    $save1['training_creation_id'] = $this->request->data['TrainingWorkflow']['training_creation_id'];
                    $save1['emp_code'] = $this->request->data['TrainingWorkflow']['forward_emp_code'];
                    $this->TrainingWorkflow->create();
                    $this->TrainingWorkflow->save($save1);
                    unset($save1);
                } else {
                    $remark = $this->request->data['TrainingWorkflow']['forward_remark'];
                    $this->TrainingCreation->updateAll(array('status' => null), array(
                        'training_creation_id' => $this->request->data['TrainingWorkflow']['training_creation_id'],
                        'emp_code' => $this->request->data['TrainingWorkflow']['forward_emp_code']));
                    $this->TrainingWorkflow->updateAll(array('status' => 2, 'remarks' => "'.$remark.'"), array('id' => $check['TrainingWorkflow']['id']));
                }

                if ($this->EmpDetail->getlaststagelevel(1) == 0) {

                    //Email goes to manager for approval
                    $training_config = $this->TrainingConfig->find('first', array('fields' => array('*'), 'conditions' => array('comp_code' => $this->Auth->user('comp_code'))));
                    if ($training_config['TrainingConfig']['email']) {
                        $training_vals = $this->TrainingCreation->find('first', array(
                            'conditions' => array('TrainingCreation.training_id' => $this->request->data['TrainingWorkflow']['training_creation_id'])
                        ));

                        $Frommail = $this->TrainingCmp->getEmailID($this->Auth->User('emp_code'));
                        $From = $Frommail['UserDetail']['email'];
                        $Tommail = $this->TrainingCmp->getEmailID($this->request->data['TrainingWorkflow']['forward_emp_code']);
                        $To = $Tommail['UserDetail']['email'];
                        $sub = "Approval of " . $training_vals['TrainingCourseCreation']['name'] . " training request";
                        $template = 'trainingemail_template';
                        $data['appName'] = $Tommail['UserDetail']['user_name'];
                        $data['logo'] = 'logo_email.png';

                        $msg = "<div>This is to bring into your notice that I have submitted an online training request for <b>" . $training_vals['TrainingCourseCreation']['name'] . "</b>.<br /><br />I would appreciate if you could please approve it.</div> <br />";
                        if (isset($To)) {
                            $this->send_mail($From, $To, $CC, $sub, $msg, $template, $data);
                        }
                    }
                    //Email ends here

                    $this->TrainingCreation->updateAll(
                            array('TrainingCreation.status' => 2), array('TrainingCreation.training_id' => $this->request->data['TrainingWorkflow']['training_creation_id'])
                    );
                } else {

                    $this->TrainingCreation->updateAll(
                            array('TrainingCreation.status' => 5), array('TrainingCreation.training_id' => $this->request->data['TrainingWorkflow']['training_creation_id'])
                    );
                }

                $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                            <a href="#" class="uk-alert-close uk-close"></a>Training Request Forwarded. </div>');
                $this->redirect(array('controller' => 'training', 'action' => 'sanctionTrainingRequests'));
            } else if ($this->request->data['TrainingWorkflow']['type'] == 4) {
                $rem = $this->request->data['TrainingWorkflow']['reject_remark'];
                $lv_rej = $this->TrainingCreation->updateAll(
                        array('TrainingCreation.status' => 4, 'TrainingCreation.schedule_id' => NULL, 'remarks' => "'$rem'"), array(
                    'TrainingCreation.training_id' => $this->request->data['TrainingWorkflow']['training_creation_id'])
                );
                $remark = $this->request->data['TrainingWorkflow']['reject_remark'];

                if ($lv_rej) {

                    $newsave = array();
                    $newsave['id'] = $this->request->data['TrainingWorkflow']['id'];
                    $newsave['emp_code'] = $this->Auth->User('emp_code');
                    $newsave['remarks'] = $this->request->data['TrainingWorkflow']['reject_remark'];
                    $newsave['approved_date'] = date('Y-m-d', strtotime(date('Y-m-d')));
                    $newsave['status'] = 4;
                    $this->TrainingWorkflow->save($newsave);

                    //Email Starts
                    $training_config = $this->TrainingConfig->find('first', array('fields' => array('*'), 'conditions' => array('comp_code' => $this->Auth->user('comp_code'))));
                    if ($training_config['TrainingConfig']['email']) {
                        $vals = $this->TrainingCreation->find('first', array(
                            'conditions' => array('TrainingCreation.training_id' => $this->request->data['TrainingWorkflow']['training_creation_id'])
                        ));

                        $Frommail = $this->TrainingCmp->getEmailID($this->Auth->User('emp_code'));
                        $From = $Frommail['UserDetail']['email'];
                        $Tommail = $this->TrainingCmp->getEmailID($vals['TrainingCreation']['identified_by']);
                        $To = $Tommail['UserDetail']['email'];
                        $sub = 'Rejection of ' . $vals['TrainingCourseCreation']['name'] . ' training request';
                        $template = 'trainingemail_template';
                        $data['appName'] = $Tommail['UserDetail']['user_name'];
                        $data['logo'] = 'logo_email.png';
                        $msg = "<div>This is to inform that your request regarding the " . $vals['TrainingCourseCreation']['name'] . "  training been rejected <strong>" . $this->request->data['TrainingWorkflow']['reject_remark'] . "</strong>.<br/>For any further clarification please feel free to reach me.</div><br/>";
                        if (isset($To)) {
                            $this->send_mail($From, $To, $CC, $sub, $msg, $template, $data);
                        }
                    }
                    //Email Ends

                    $this->Session->setFlash('<div class="uk-alert uk-alert-warning" data-uk-alert=""><a href="#" class="uk-alert-close uk-close"></a>Training  Rejected.</div>', false, array('class' => 'flash flash_error'));
                    $this->redirect(array('controller' => 'training', 'action' => 'sanctionTrainingRequests'));
                }
            } else if ($this->request->data['TrainingWorkflow']['type'] == 5) {

                $rem = $this->request->data['TrainingWorkflow']['approve_remark'];
                $lv_app = $this->TrainingCreation->updateAll(
                        array('TrainingCreation.status' => 5, 'remarks' => "'$rem'"), array(
                    'TrainingCreation.training_id' => $this->request->data['TrainingWorkflow']['training_creation_id'])
                );

                if ($lv_app) {
                    $newsave = array();

                    $newsave['id'] = $this->request->data['TrainingWorkflow']['id'];
                    $newsave['training_creation_id'] = $this->request->data['TrainingWorkflow']['training_creation_id'];
                    $newsave['emp_code'] = $this->Auth->User('emp_code');
                    $newsave['remarks'] = $this->request->data['TrainingWorkflow']['approve_remark'];
                    $newsave['approved_date'] = date('Y-m-d');
                    $newsave['status'] = 5;
                    $this->TrainingWorkflow->save($newsave);

                    //Email Starts
                    $training_config = $this->TrainingConfig->find('first', array('fields' => array('*'), 'conditions' => array('comp_code' => $this->Auth->user('comp_code'))));
                    if ($training_config['TrainingConfig']['email']) {
                        $training_vals = $this->TrainingCreation->find('first', array(
                            'conditions' => array('TrainingCreation.training_id' => $this->request->data['TrainingWorkflow']['training_creation_id'])
                        ));
                        foreach ($training_vals['TrainingWorkflow'] as $trainworkfow) {
                            //if ($trainworkfow['emp_code'] != $this->Auth->User('emp_code')) {
                            $Tommail = $this->TrainingCmp->getEmailID($trainworkfow['emp_code']);
                            $manageremp_code[] = $Tommail['UserDetail']['email'];
                            $data_app_name[] = $Tommail['UserDetail']['user_name'];
                            //}
                        }

                        $Frommail = $this->TrainingCmp->getEmailID($this->Auth->User('emp_code'));
                        $From = $Frommail['UserDetail']['email'];
                        //$To = implode(",", $manageremp_code);
                        $sub = 'Approved of ' . $training_vals['TrainingCourseCreation']['name'] . ' training request';

                        $msg .='The List of employees involved in the training :<br/>';
                        $msg .='<div><table width="60%" cellspacing="1" cellpadding="5" border="1" class="exp-voucher" style="align:right  !important;font-size:11px;">
								<tr>
									<th scope="row" style="text-align:left;" width="5%"><strong>S.N.</strong></th>
									<th scope="row" width="15%" style="text-align:left;"><strong>Employee Name</strong></th>
									<th scope="row" width="15%" style="text-align:left;"><strong>Trainee Name</strong></th>
								</tr>';
                        $sn1 = 1;

                        foreach ($training_vals['TrainingEmployee'] as $trainees) {
                            $emp_detail = $this->EmpDetail->getemployeeinfomation($trainees['trainee_code']);

                            $trainee_name = ucwords(strtolower($traineeData['Employees']['vc_emp_name']));
                            $msg .='<tr>
										<td valign="top">' . $sn1 . '</td>
										<td valign="top">' . ucwords(strtolower($emp_detail['MyProfile']['emp_full_name'])) . '</td>
										<td valign="top">' . $training_vals['TrainingCourseCreation']['name'] . '</td>
									</tr>';
                            $sn1++;
                        }
                        $msg .='</table></div><br/><br/>';
                        $template = 'trainingemail_template';
                        $data['logo'] = 'logo_email.png';

                        if (!empty($manageremp_code)) {
                            foreach ($manageremp_code as $ky => $manageremp_code_mail) {
                                if (!empty($manageremp_code_mail) && !empty($data_app_name[$ky])) {
                                    $data['appName'] = $data_app_name[$ky];
                                    $this->send_mail($From, $manageremp_code_mail, $CC, $sub, $msg, $template, $data);
                                }
                            }
                        }
                    }
                    //Email Ends
                }

                $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                            <a href="#" class="uk-alert-close uk-close"></a>Training Approved Successfully !!! </div>');
                $this->redirect(array('controller' => 'Training', 'action' => 'sanctionTrainingRequests'));
            }
        }
        $this->redirect(array('controller' => 'Training', 'action' => 'sanctionTrainingRequests'));
    }

    /*
     * Training Identification Request Form
     */

    function trainingIdentificationRequestForm() {
        $this->layout = 'employee-new';
        $emp_code = $this->Auth->User('emp_code');
        $emp_details = $this->EmpDetail->getemployeeinfomation($emp_code);
        $emp_name = $this->MyProfile->find('first', array('fields' => array('*'), 'conditions' => array('emp_code' => $this->Auth->user('emp_code'))));

        $userType = $this->TrainingCmp->getTrainingUserType();

        $employeelist = $this->Common->getEmployeesListByCompCode();

        $courselist = $this->TrainingCourseCreation->find('list', array(
            'fields' => 'name',
            'conditions' => array('status !=' => 1, 'comp_code' => $emp_details['MyProfile']['comp_code'])
        ));
        if ($userType == 'TI') {
            $desg_wise_employee = $this->MyProfile->find('all', array(
                'fields' => array('count(MyProfile.id) as ct,MyProfile.emp_code,MyProfile.emp_firstname,MyProfile.comp_code,MyProfile.desg_code,MyProfile.location_code'),
                'group' => array('MyProfile.desg_code,MyProfile.location_code'),
                'conditions' => array('MyProfile.comp_code' => $emp_details['MyProfile']['comp_code'], 'MyProfile.emp_code !=' => $emp_code)
            ));
        } else {
            $desg_wise_employee = $this->MyProfile->find('all', array(
                'fields' => array('count(MyProfile.id) as ct,MyProfile.emp_code,MyProfile.emp_firstname,MyProfile.comp_code,MyProfile.desg_code,MyProfile.location_code'),
                'group' => array('MyProfile.desg_code,MyProfile.location_code'),
                'conditions' => array('MyProfile.manager_code' => $emp_code, 'MyProfile.comp_code' => $emp_details['MyProfile']['comp_code'])
            ));
        }
        $reported_emp = $this->TrainingCmp->reportedEmpLists($emp_details['MyProfile']['comp_code'], $emp_code, $userType);

        if (!empty($this->data)) {
            if (!empty($this->data['update_training_id'])) {

                if (!empty($this->data['Training']['traineecode']) && !empty($this->data['Training']['traineedesgcode'])) {
                    $traineeEmployees = array_merge($this->data['Training']['traineecode'], array_diff($this->data['Training']['traineedesgcode'], $this->data['Training']['traineecode']));
                } elseif ($this->data['Training']['traineecode']) {
                    $traineeEmployees = $this->data['Training']['traineecode'];
                } else {
                    if (!empty($this->data['Training']['traineedesgcode']))
                        $traineeEmployees = $this->data['Training']['traineedesgcode'];
                    else
                        $traineeEmployees = array();
                }

                $value['training_id'] = $this->data['update_training_id'];
                if (!empty($this->data['self']))
                    $value['self'] = 1;
                $training_id = $this->data['update_training_id'];
                $value['training_instructor_name'] = $this->data['Training']['training_instructor_name'];
                if (!empty($this->TrainingCmp->getAllTraineeEmployee($this->data['update_training_id']))) {
                    $allEmpLists = $this->TrainingCmp->getAllTraineeEmployee($this->data['update_training_id']);

                    foreach ($traineeEmployees as $key => $empIds) {
                        foreach ($allEmpLists as $allEmpListKey => $allEmpListKeyVal) {
                            if ($empIds == $allEmpListKeyVal) {
                                if (!empty($this->TrainingCmp->chkTraineeEmployee($empIds, $training_id))) {
                                    $this->TrainingEmployee->id = $allEmpListKey;
                                    $this->TrainingEmployee->delete();
                                }
                            }
                        }
                    }
                }
                //Check For Employee Training Maximum Capacity Student Start
                $cot_employee = array_unique(array_merge_recursive($this->TrainingCmp->getAllTraineeEmployee($this->data['update_training_id']), $traineeEmployees));

                if (in_array($emp_code, $cot_employee)) {
                    $allctemp = count($cot_employee);
                } elseif ($value['self'] == 1) {
                    $allctemp = count($cot_employee) + 1;
                } else {
                    $allctemp = count($cot_employee);
                }
                $max_course_capacity = $this->Common->getCourseMaxCapacity($this->data['course_id']);

                if ($allctemp > $max_course_capacity) {
                    $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert=""><a href="#" class="uk-alert-close uk-close"></a>Maximum number of trainee should not be greater than ' . $max_course_capacity . '.</div>');
                    $this->redirect('/training/trainingIdentificationRequestForm/');
                }
                if (!empty($this->data['Training']['training_instructor_name'])) {
                    if (in_array($this->data['Training']['training_instructor_name'], $traineeEmployees)) {
                        $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert=""><a href="#" class="uk-alert-close uk-close"></a>Instructor and trainee can not be same.</div>');
                        $this->redirect('/training/trainingIdentificationRequestForm/');
                    }
                }
                //Check For Employee Training Maximum Capacity Student Ends
                if ($this->TrainingCreation->save($value)) {
                    $training_id = $this->data['update_training_id'];
                    if (!empty($this->data['update_training_id'])) {
                        foreach ($traineeEmployees as $key => $empValues) {
                            if (empty($this->TrainingCmp->chkTraineeEmployee($empValues, $training_id))) {
                                $trainee_emp_details = $this->EmpDetail->getemployeeinfomation($empValues);
                                $val['training_creation_id'] = $training_id;
                                $val['trainee_code'] = $empValues;
                                $val['trainee_comp_code'] = $trainee_emp_details['MyProfile']['comp_code'];
                                $val['location'] = $trainee_emp_details['MyProfile']['location_code'];
                                $val['desg_code'] = $trainee_emp_details['MyProfile']['desg_code'];
                                $val['dept_code'] = $trainee_emp_details['MyProfile']['dept_code'];
                                $val['manager_code'] = $emp_code;
                                $val['approved_date'] = date("Y-m-d");
                                $this->TrainingEmployee->create();
                                $this->TrainingEmployee->save($val);
                            }
                        }
                    }
                    if (empty($this->TrainingCmp->chkTraineeEmployee($emp_code, $training_id))) {
                        if (!empty($this->data['self'])) {
                            $trainee_emp_details = $this->EmpDetail->getemployeeinfomation($emp_code);
                            $val['training_creation_id'] = $training_id;
                            $val['trainee_code'] = $emp_code;
                            $val['trainee_comp_code'] = $trainee_emp_details['MyProfile']['comp_code'];
                            $val['location'] = $trainee_emp_details['MyProfile']['location_code'];
                            $val['desg_code'] = $trainee_emp_details['MyProfile']['desg_code'];
                            $val['dept_code'] = $trainee_emp_details['MyProfile']['dept_code'];
                            $val['manager_code'] = $emp_code;
                            $val['approved_date'] = date("Y-m-d");
                            $this->TrainingEmployee->create();
                            $this->TrainingEmployee->save($val);
                        }
                    }

                    $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert=""><a href="#" class="uk-alert-close uk-close"></a>Training Enrollment Form successfully saved and it futher approved by Train in charge.</div>');
                    $this->redirect('/training/manageTrainingIdentificationForm/');
                }
            } else {

                if (!empty($this->data['Training']['traineecode']) && !empty($this->data['Training']['traineedesgcode'])) {
                    $traineeEmployees = array_merge($this->data['Training']['traineecode'], array_diff($this->data['Training']['traineedesgcode'], $this->data['Training']['traineecode']));
                } elseif ($this->data['Training']['traineecode']) {
                    $traineeEmployees = $this->data['Training']['traineecode'];
                } else {
                    $traineeEmployees = $this->data['Training']['traineedesgcode'];
                }

                $value['course_id'] = $this->data['course_id'];
                $value['description'] = $this->data['message'];
                $value['schedule_id'] = $this->data['schedule_id'];
                $value['training_instructor_name'] = $this->data['Training']['training_instructor_name'];
                $value['remarks'] = $this->data['remarks'];
                if (!empty($this->data['training_date']))
                    $value['training_date'] = date("Y-m-d", strtotime($this->data['training_date']));
                if (!empty($this->data['self']))
                    $value['self'] = 1;
                $value['training_start_time'] = $this->data['training_time'];
                $value['identified_by'] = $emp_code;
                $value['status'] = 1;
                $value['initated_by'] = 'E';
                $value['created_at'] = date("Y-m-d");
                $value['emp_code'] = $emp_code;
                $value['comp_code'] = $emp_details['MyProfile']['comp_code'];
                $this->TrainingCreation->create();
                //Check For Employee Training Maximum Capacity Student Start
                $max_course_capacity = $this->Common->getCourseMaxCapacity($this->data['course_id']);
                if (count($traineeEmployees) + $value['self'] > $max_course_capacity) {
                    $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert=""><a href="#" class="uk-alert-close uk-close"></a>Maximum number of trainee should not be greater than  ' . $max_course_capacity . '.</div>');
                    $this->redirect('/training/trainingIdentificationRequestForm/');
                }
                if (!empty($this->data['Training']['training_instructor_name'])) {
                    if (in_array($this->data['Training']['training_instructor_name'], $traineeEmployees)) {
                        $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert=""><a href="#" class="uk-alert-close uk-close"></a>Instructor and trainee can not be same.</div>');
                        $this->redirect('/training/trainingIdentificationRequestForm/');
                    }
                }
                //Check For Employee Training Maximum Capacity Student Ends
                if ($this->TrainingCreation->save($value)) {
                    $training_id = $this->TrainingCreation->getLastInsertID();
                    if (!empty($this->data['Training'])) {
                        foreach ($traineeEmployees as $key => $empValues) {
                            $trainee_emp_details = $this->EmpDetail->getemployeeinfomation($empValues);
                            $val['training_creation_id'] = $training_id;
                            $val['trainee_code'] = $empValues;
                            $val['trainee_comp_code'] = $trainee_emp_details['MyProfile']['comp_code'];
                            $val['location'] = $trainee_emp_details['MyProfile']['location_code'];
                            $val['desg_code'] = $trainee_emp_details['MyProfile']['desg_code'];
                            $val['dept_code'] = $trainee_emp_details['MyProfile']['dept_code'];
                            $val['manager_code'] = $emp_code;
                            $val['approved_date'] = date("Y-m-d");
                            $this->TrainingEmployee->create();
                            $this->TrainingEmployee->save($val);
                        }
                    }
                    if (!empty($this->data['self'])) {
                        $trainee_emp_details = $this->EmpDetail->getemployeeinfomation($emp_code);
                        $val['training_creation_id'] = $training_id;
                        $val['trainee_code'] = $emp_code;
                        $val['trainee_comp_code'] = $trainee_emp_details['MyProfile']['comp_code'];
                        $val['location'] = $trainee_emp_details['MyProfile']['location_code'];
                        $val['desg_code'] = $trainee_emp_details['MyProfile']['desg_code'];
                        $val['dept_code'] = $trainee_emp_details['MyProfile']['dept_code'];
                        $val['manager_code'] = $emp_code;
                        $val['approved_date'] = date("Y-m-d");
                        $this->TrainingEmployee->create();
                        $this->TrainingEmployee->save($val);
                    }

                    $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert=""><a href="#" class="uk-alert-close uk-close"></a>Training Enrollment Form successfully saved.</div>');
                    $record_id = $this->TrainingCreation->getLastInsertID();
                    $this->redirect('/training/workflow_display/' . base64_encode($record_id));
                }
            }
        }

        $employee = $this->paginate('MyProfile');
        $this->set('reported_emp', $reported_emp);
        $this->set('emp_code', $emp_code);
        $this->set('courselists', $courselist);
        $this->set('desg_wise_employee', $desg_wise_employee);
        $this->set('employeelist', $employeelist);
    }

    /*
     * Training Identification Initate Form
     */

    function trainingIdentificationInitateForm() {
        $this->layout = 'employee-new';
        $emp_code = $this->Auth->User('emp_code');
        $emp_details = $this->EmpDetail->getemployeeinfomation($emp_code);
        $emp_name = $this->MyProfile->find('first', array('fields' => array('*'), 'conditions' => array('emp_code' => $this->Auth->user('emp_code'))));

        $userType = $this->TrainingCmp->getTrainingUserType();

        $courselist = $this->TrainingCourseCreation->find('list', array(
            'fields' => 'name',
            'conditions' => array('status !=' => 1, 'comp_code' => $emp_details['MyProfile']['comp_code'])
        ));

        $employeelist = $this->Common->getEmployeesListByCompCode();

        if ($userType == 'TI') {
            $desg_wise_employee = $this->MyProfile->find('all', array(
                'fields' => array('count(MyProfile.id) as ct,MyProfile.emp_code,MyProfile.emp_firstname,MyProfile.comp_code,MyProfile.desg_code,MyProfile.location_code'),
                'group' => array('MyProfile.desg_code,MyProfile.location_code'),
                'conditions' => array('MyProfile.comp_code' => $emp_details['MyProfile']['comp_code'], 'MyProfile.emp_code !=' => $emp_code)
            ));
        } else {
            $desg_wise_employee = $this->MyProfile->find('all', array(
                'fields' => array('count(MyProfile.id) as ct,MyProfile.emp_code,MyProfile.emp_firstname,MyProfile.comp_code,MyProfile.desg_code,MyProfile.location_code'),
                'group' => array('MyProfile.desg_code,MyProfile.location_code'),
                'conditions' => array('MyProfile.manager_code' => $emp_code, 'MyProfile.comp_code' => $emp_details['MyProfile']['comp_code'])
            ));
        }

        $reported_emp = $this->TrainingCmp->reportedEmpLists($emp_details['MyProfile']['comp_code'], $emp_code, $userType);

        if (!empty($this->data)) {

            if (!empty($this->data['Training']['traineecode']) && !empty($this->data['Training']['traineedesgcode'])) {
                $traineeEmployees = array_merge($this->data['Training']['traineecode'], array_diff($this->data['Training']['traineedesgcode'], $this->data['Training']['traineecode']));
            } elseif ($this->data['Training']['traineecode']) {
                $traineeEmployees = $this->data['Training']['traineecode'];
            } else {
                $traineeEmployees = $this->data['Training']['traineedesgcode'];
            }

            $value['course_id'] = $this->data['course_id'];
            $value['description'] = $this->data['requirement'];
            $value['remarks'] = $this->data['remarks'];
            if (!empty($this->data['training_date']))
                $value['training_date'] = date("Y-m-d", strtotime($this->data['training_date']));
            if (!empty($this->data['self']))
                $value['self'] = 1;
            $value['training_start_time'] = $this->data['training_time'];
            $value['identified_by'] = $emp_code;
            $value['training_instructor_name'] = $this->data['Training']['training_instructor_name'];
            $value['status'] = 1;
            $value['initated_by'] = 'I';
            $value['created_at'] = date("Y-m-d");
            $value['emp_code'] = $emp_code;
            $value['comp_code'] = $emp_details['MyProfile']['comp_code'];
            $this->TrainingCreation->create();
            //Check For Employee Training Maximum Capacity Student Start
            $max_course_capacity = $this->Common->getCourseMaxCapacity($this->data['course_id']);
            if (count($traineeEmployees) + $value['self'] > $max_course_capacity) {
                $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert=""><a href="#" class="uk-alert-close uk-close"></a>Maximum number of trainee should not be greater than  ' . $max_course_capacity . '.</div>');
                $this->redirect('/training/trainingIdentificationInitateForm/');
            }
            if (!empty($this->data['Training']['training_instructor_name'])) {
                if (in_array($this->data['Training']['training_instructor_name'], $traineeEmployees)) {
                    $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert=""><a href="#" class="uk-alert-close uk-close"></a>Instructor and trainee can not be same.</div>');
                    $this->redirect('/training/trainingIdentificationInitateForm/');
                }
            }
            //Check For Employee Training Maximum Capacity Student Ends
            if ($this->TrainingCreation->save($value)) {
                $training_id = $this->TrainingCreation->getLastInsertID();
                if (!empty($this->data['Training'])) {
                    foreach ($traineeEmployees as $key => $empValues) {
                        $trainee_emp_details = $this->EmpDetail->getemployeeinfomation($empValues);
                        $val['training_creation_id'] = $training_id;
                        $val['trainee_code'] = $empValues;
                        $val['trainee_comp_code'] = $trainee_emp_details['MyProfile']['comp_code'];
                        $val['location'] = $trainee_emp_details['MyProfile']['location_code'];
                        $val['desg_code'] = $trainee_emp_details['MyProfile']['desg_code'];
                        $val['dept_code'] = $trainee_emp_details['MyProfile']['dept_code'];
                        $val['manager_code'] = $emp_code;
                        $val['approved_date'] = date("Y-m-d");
                        $this->TrainingEmployee->create();
                        $this->TrainingEmployee->save($val);
                    }
                }
                if (!empty($this->data['self'])) {
                    $trainee_emp_details = $this->EmpDetail->getemployeeinfomation($emp_code);
                    $val['training_creation_id'] = $training_id;
                    $val['trainee_code'] = $emp_code;
                    $val['trainee_comp_code'] = $trainee_emp_details['MyProfile']['comp_code'];
                    $val['location'] = $trainee_emp_details['MyProfile']['location_code'];
                    $val['desg_code'] = $trainee_emp_details['MyProfile']['desg_code'];
                    $val['dept_code'] = $trainee_emp_details['MyProfile']['dept_code'];
                    $val['manager_code'] = $emp_code;
                    $val['approved_date'] = date("Y-m-d");
                    $this->TrainingEmployee->create();
                    $this->TrainingEmployee->save($val);
                }

                $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert=""><a href="#" class="uk-alert-close uk-close"></a>Training Initiation successfully saved.</div>');
                $record_id = $this->TrainingCreation->getLastInsertID();
                // $this->redirect('/training/trainingIdentificationInitateForm/');
                $this->redirect('/training/workflow_display/' . base64_encode($record_id));
            }
        }

        $this->set('emp', $employee);
        $this->set('emp_code', $emp_code);
        $this->set('reported_emp', $reported_emp);
        $this->set('desg_wise_employee', $desg_wise_employee);
        $this->set('courselists', $courselist);
        $this->set('employeelist', $employeelist);
    }

    /*
     * Function for appraisal
     */

    function trainingIdentificationInitatePmsForm() {
        $this->layout = 'employee-new';
        $emp_code = $this->Auth->User('emp_code');
        $emp_details = $this->EmpDetail->getemployeeinfomation($emp_code);
        $emp_name = $this->MyProfile->find('first', array('fields' => array('*'), 'conditions' => array('emp_code' => $this->Auth->user('emp_code'))));

        $userType = $this->TrainingCmp->getTrainingUserType();

        $courselist = $this->TrainingCourseCreation->find('list', array(
            'fields' => 'name',
            'conditions' => array('status !=' => 1, 'comp_code' => $emp_details['MyProfile']['comp_code'])
        ));

        $employeelist = $this->Common->getEmployeesListByCompCode();

        if ($userType == 'TI') {
            $desg_wise_employee = $this->MyProfile->find('all', array(
                'fields' => array('count(MyProfile.id) as ct,MyProfile.emp_code,MyProfile.emp_firstname,MyProfile.comp_code,MyProfile.desg_code,MyProfile.location_code'),
                'group' => array('MyProfile.desg_code,MyProfile.location_code'),
                'conditions' => array('MyProfile.comp_code' => $emp_details['MyProfile']['comp_code'], 'MyProfile.emp_code !=' => $emp_code)
            ));
        } else {
            $desg_wise_employee = $this->MyProfile->find('all', array(
                'fields' => array('count(MyProfile.id) as ct,MyProfile.emp_code,MyProfile.emp_firstname,MyProfile.comp_code,MyProfile.desg_code,MyProfile.location_code'),
                'group' => array('MyProfile.desg_code,MyProfile.location_code'),
                'conditions' => array('MyProfile.manager_code' => $emp_code, 'MyProfile.comp_code' => $emp_details['MyProfile']['comp_code'])
            ));
        }

        $reported_emp = $this->TrainingCmp->reportedEmpLists($emp_details['MyProfile']['comp_code'], $emp_code, $userType);

        if (!empty($this->data)) {

            if (!empty($this->data['Training']['traineecode']) && !empty($this->data['Training']['traineedesgcode'])) {
                $traineeEmployees = array_merge($this->data['Training']['traineecode'], array_diff($this->data['Training']['traineedesgcode'], $this->data['Training']['traineecode']));
            } elseif ($this->data['Training']['traineecode']) {
                $traineeEmployees = $this->data['Training']['traineecode'];
            } else {
                $traineeEmployees = $this->data['Training']['traineedesgcode'];
            }

            $value['course_id'] = $this->data['course_id'];
            $value['description'] = $this->data['requirement'];
            $value['remarks'] = $this->data['remarks'];
            if (!empty($this->data['training_date']))
                $value['training_date'] = date("Y-m-d", strtotime($this->data['training_date']));
            if (!empty($this->data['self']))
                $value['self'] = 1;
            $value['training_start_time'] = $this->data['training_time'];
            $value['identified_by'] = $emp_code;
            $value['training_instructor_name'] = $this->data['Training']['training_instructor_name'];
            $value['status'] = 1;
            $value['initated_by'] = 'P';
            $value['created_at'] = date("Y-m-d");
            $value['emp_code'] = $emp_code;
            $value['comp_code'] = $emp_details['MyProfile']['comp_code'];
            $this->TrainingCreation->create();
            //Check For Employee Training Maximum Capacity Student Start
            $max_course_capacity = $this->Common->getCourseMaxCapacity($this->data['course_id']);
            if (count($traineeEmployees) + $value['self'] > $max_course_capacity) {
                $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert=""><a href="#" class="uk-alert-close uk-close"></a>Maximum number of trainee should not be greater than  ' . $max_course_capacity . '.</div>');
                $this->redirect('/training/trainingIdentificationInitatePmsForm/');
            }
            if (!empty($this->data['Training']['training_instructor_name'])) {
                if (in_array($this->data['Training']['training_instructor_name'], $traineeEmployees)) {
                    $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert=""><a href="#" class="uk-alert-close uk-close"></a>Instructor and trainee can not be same.</div>');
                    $this->redirect('/training/trainingIdentificationInitatePmsForm/');
                }
            }
            //Check For Employee Training Maximum Capacity Student Ends
            if ($this->TrainingCreation->save($value)) {
                $training_id = $this->TrainingCreation->getLastInsertID();
                if (!empty($this->data['Training'])) {
                    foreach ($traineeEmployees as $key => $empValues) {
                        $trainee_emp_details = $this->EmpDetail->getemployeeinfomation($empValues);
                        $val['training_creation_id'] = $training_id;
                        $val['trainee_code'] = $empValues;
                        $val['trainee_comp_code'] = $trainee_emp_details['MyProfile']['comp_code'];
                        $val['location'] = $trainee_emp_details['MyProfile']['location_code'];
                        $val['desg_code'] = $trainee_emp_details['MyProfile']['desg_code'];
                        $val['dept_code'] = $trainee_emp_details['MyProfile']['dept_code'];
                        $val['manager_code'] = $emp_code;
                        $val['approved_date'] = date("Y-m-d");
                        $this->TrainingEmployee->create();
                        $this->TrainingEmployee->save($val);
                    }
                }
                if (!empty($this->data['self'])) {
                    $trainee_emp_details = $this->EmpDetail->getemployeeinfomation($emp_code);
                    $val['training_creation_id'] = $training_id;
                    $val['trainee_code'] = $emp_code;
                    $val['trainee_comp_code'] = $trainee_emp_details['MyProfile']['comp_code'];
                    $val['location'] = $trainee_emp_details['MyProfile']['location_code'];
                    $val['desg_code'] = $trainee_emp_details['MyProfile']['desg_code'];
                    $val['dept_code'] = $trainee_emp_details['MyProfile']['dept_code'];
                    $val['manager_code'] = $emp_code;
                    $val['approved_date'] = date("Y-m-d");
                    $this->TrainingEmployee->create();
                    $this->TrainingEmployee->save($val);
                }

                $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert=""><a href="#" class="uk-alert-close uk-close"></a>Training Initiation successfully saved.</div>');
                $record_id = $this->TrainingCreation->getLastInsertID();
                // $this->redirect('/training/trainingIdentificationInitateForm/');
                $this->redirect('/training/workflow_display/' . base64_encode($record_id));
            }
        }

        $this->set('emp', $employee);
        $this->set('emp_code', $emp_code);
        $this->set('reported_emp', $reported_emp);
        $this->set('desg_wise_employee', $desg_wise_employee);
        $this->set('courselists', $courselist);
        $this->set('employeelist', $employeelist);
    }

    /*
     * Get Course Schedule List
     */

    function workflow_display($record_id = null) {
        $this->layout = 'employee-new';
        $record_id = base64_decode($record_id);
        // print_r($record_id);die;
        $this->set('training_id', $record_id);
    }

    function saveinfomation() {
        if (!empty($this->request->data)) {
            $org_id = $_SESSION['Auth']['MyProfile']['comp_code'];
            $training_id = $this->request->data['TrainingWorkflow']['training_id'];
            $leave_code = $this->request->data['LeaveWorkflow']['leave_code'];
            $save = array();
            $save['training_creation_id'] = $this->request->data['TrainingWorkflow']['training_id'];
            $save['emp_code'] = $this->Auth->User('emp_code');
            $user_details = $this->EmpDetail->getemployeeinfomation($this->Auth->User('emp_code'));
            $save['fwd_date'] = date('Y-m-d h:i:s');
            if ($this->TrainingWorkflow->save($save)) {
                unset($save);
                $save1 = array();
                $save1['training_creation_id'] = $this->request->data['TrainingWorkflow']['training_id'];
                $save1['emp_code'] = $this->request->data['TrainingWorkflow']['emp_code'];
                $this->TrainingWorkflow->create();
                if ($this->TrainingWorkflow->save($save1)) {
                    unset($save1);
                    $this->TrainingCreation->updateAll(
                            array('TrainingCreation.status' => '2'), array('TrainingCreation.training_id' => $this->request->data['TrainingWorkflow']['training_id'])
                    );

                    //Email goes to manager for approval
                    $training_config = $this->TrainingConfig->find('first', array('fields' => array('*'), 'conditions' => array('comp_code' => $this->Auth->user('comp_code'))));
                    if ($training_config['TrainingConfig']['email']) {
                        $vals = $this->TrainingCreation->find('first', array(
                            'conditions' => array('TrainingCreation.training_id' => $this->request->data['TrainingWorkflow']['training_id'])
                        ));

                        $Frommail = $this->TrainingCmp->getEmailID($this->Auth->User('emp_code'));
                        $From = $Frommail['UserDetail']['email'];
                        $Tommail = $this->TrainingCmp->getEmailID($this->request->data['TrainingWorkflow']['emp_code']);
                        $To = $Tommail['UserDetail']['email'];
                        $sub = "Approval of " . $vals['TrainingCourseCreation']['name'] . " training request";
                        $template = 'trainingemail_template';
                        $data['appName'] = $Tommail['UserDetail']['user_name'];
                        $data['logo'] = 'logo_email.png';
                        $msg = "<div>This is to bring into your notice that I have submitted an online training request for <b>" . $vals['TrainingCourseCreation']['name'] . "</b>.<br /><br />I would appreciate if you could please approve it.</div> <br />";

                        if (isset($To)) {
                            $this->send_mail($From, $To, $CC, $sub, $msg, $template, $data);
                        }
                    }
                    //Email ends here

                    $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                            <a href="#" class="uk-alert-close uk-close"></a>Training Initiation forwarded Successfully.</div>');
                    $this->redirect(array('controller' => 'Training', 'action' => 'manageTrainingIdentificationForm'));
                } else {
                    $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                            <a href="#" class="uk-alert-close uk-close"></a>Training Initiation not forwarded.</div>');
                    $this->redirect(array('controller' => 'Training', 'action' => 'manageTrainingIdentificationForm'));
                }
            }
        }
        $this->redirect(array('controller' => 'Training', 'action' => 'manageTrainingIdentificationForm'));
    }

    function checkScheduleStatus($schedule_id) {
        $training = $this->TrainingCreation->find('all', array('order' => 'TrainingCreation.training_id DESC', 'conditions' => array('TrainingCreation.schedule_id' => $schedule_id)));
        return $training[0]['TrainingCreation']['status'];
    }

    function checkScheduleAssignTraining($schedule_id, $training_id) {
        $training = $this->TrainingCreation->find('all', array('order' => 'TrainingCreation.training_id DESC', 'conditions' => array('TrainingCreation.schedule_id' => $schedule_id)));
        $count = 0;
        if (!empty($training)) {
            foreach ($training as $ky => $val) {
                if ($val['TrainingCreation']['training_id'] == $training_id) {
                    $count = 0;
                    break;
                } else {
                    if ($val['TrainingCreation']['status'] == 4)
                        $count = 0;
                    else
                        $count++;
                }
            }
        }
        if ($count == 0) {
            return true;
        } else {
            return false;
        }
    }

    function getCourseScheduleList($courseID) {

        if (strpos($courseID, "&") === false) {
            $courseID = $courseID;
        } else {
            $course = explode("&", $courseID);
            $course1 = explode("=", $course[1]);
            $courseID = $course[0];
            $trainingid = $course1[1];
        }

        $ldetails = $this->TrainingScheduleCreation->find('list', array(
            'fields' => 'sch_start_date',
            'conditions' => array('course_id' => $courseID, 'status' => 0, 'sch_start_date >=' => date('Y-m-d'))
        ));
        $cousrDetail = $this->TrainingCourseCreation->find('first', array(
            'fields' => 'name',
            'conditions' => array('course_id' => $courseID, 'status' => 0)
        ));

        if (!empty($trainingid)) {
            $trainingDetail = $this->TrainingCreation->find('first', array(
                'fields' => 'schedule_id',
                'conditions' => array('training_id' => $trainingid)
            ));
            $schedule_id = $trainingDetail['TrainingCreation']['schedule_id'];
        } else {
            $schedule_id = 0;
        }

        $html = '<label><b style="color: #727272; font-size: 12px;">Course Schedule List*</b></label><select id="schedule_id" class="md-input data-md-selectize label-fixed" name="schedule_id" onchange="getSchedule(this)"><option value="0">Choose..</option>';
        if (!empty($ldetails)) {
            foreach ($ldetails as $key => $value) {
                if ($this->checkScheduleStatus($key) != 5) {
                    if ($this->checkScheduleAssignTraining($key, $trainingid)) {
                        if ($key == $schedule_id)
                            $selected = 'selected';
                        $html .='<option value="' . $key . '" ' . $selected . '>' . $cousrDetail['TrainingCourseCreation']['name'] . " (" . date('d-m-Y', strtotime($value)) . ")" . '</option>';
                        unset($selected);
                    }
                }
            }
        } else {
            $html .= '</select>';
        }
        echo $html;
        exit();
    }

    function getCourseScheduleListSanction($courseID) {

        if (strpos($courseID, "&") === false) {
            $courseID = $courseID;
        } else {
            $course = explode("&", $courseID);
            $course1 = explode("=", $course[1]);
            $courseID = $course[0];
            $trainingid = $course1[1];
        }

        $ldetails = $this->TrainingScheduleCreation->find('list', array(
            'fields' => 'sch_start_date',
            'conditions' => array('course_id' => $courseID, 'status' => 0, 'sch_start_date >=' => date('Y-m-d'))
        ));
        $cousrDetail = $this->TrainingCourseCreation->find('first', array(
            'fields' => 'name',
            'conditions' => array('course_id' => $courseID, 'status' => 0)
        ));

        if (!empty($trainingid)) {
            $trainingDetail = $this->TrainingCreation->find('first', array(
                'fields' => 'schedule_id',
                'conditions' => array('training_id' => $trainingid)
            ));
            $schedule_id = $trainingDetail['TrainingCreation']['schedule_id'];
        } else {
            $schedule_id = 0;
        }

        $html = '<label><b style="color: #727272; font-size: 12px;">Course Schedule List*</b></label><select id="schedule_id" class="md-input data-md-selectize label-fixed" name="schedule_id" onchange="getSchedule(this)"><option value="0">Choose..</option>';
        if (!empty($ldetails)) {
            foreach ($ldetails as $key => $value) {
                if ($this->checkScheduleStatus($key) != 5) {
                    if ($this->checkScheduleAssignTraining($key, $trainingid)) {
//                        if ($key == $schedule_id)
//                            $selected = 'selected';
                        $html .='<option value="' . $key . '">' . $cousrDetail['TrainingCourseCreation']['name'] . " (" . date('d-m-Y', strtotime($value)) . ")" . '</option>';
                        unset($selected);
                    }
                }
            }
        } else {
            $html .= '</select>';
        }
        echo $html;
        exit();
    }

    function getCourseScheduleListSanctions($courseID) {

        if (strpos($courseID, "&") === false) {
            $courseID = $courseID;
        } else {
            $course = explode("&", $courseID);
            $course1 = explode("=", $course[1]);
            $courseID = $course[0];
            $trainingid = $course1[1];
        }

        $ldetails = $this->TrainingScheduleCreation->find('list', array(
            'fields' => 'sch_start_date',
            'conditions' => array('course_id' => $courseID, 'status' => 0, 'sch_start_date >=' => date('Y-m-d'))
        ));
        $cousrDetail = $this->TrainingCourseCreation->find('first', array(
            'fields' => 'name',
            'conditions' => array('course_id' => $courseID, 'status' => 0)
        ));

        if (!empty($trainingid)) {
            $trainingDetail = $this->TrainingCreation->find('first', array(
                'fields' => 'schedule_id',
                'conditions' => array('training_id' => $trainingid)
            ));
            $schedule_id = $trainingDetail['TrainingCreation']['schedule_id'];
        } else {
            $schedule_id = 0;
        }

        $html = '<label><b style="color: #727272; font-size: 12px;">Course Schedule List*</b></label><select id="schedule_id" class="md-input data-md-selectize label-fixed" name="schedule_id" onchange="getSchedule(this)"><option value="0">Choose..</option>';
        if (!empty($ldetails)) {
            foreach ($ldetails as $key => $value) {
                if ($this->checkScheduleStatus($key) != 5) {
                    if ($this->checkScheduleAssignTraining($key, $trainingid)) {
                        if ($key == $schedule_id)
                            $selected = 'selected';
                        $html .='<option value="' . $key . '" ' . $selected . '>' . $cousrDetail['TrainingCourseCreation']['name'] . " (" . date('d-m-Y', strtotime($value)) . ")" . '</option>';
                        unset($selected);
                    }
                }
            }
        } else {
            $html .= '</select>';
        }
        echo $html;
        exit();
    }

    function sanctionTrainingIdentificationForm($training_id) {

        $training_id = base64_decode($training_id);

        $this->layout = 'employee-new';
        $emp_code = $this->Auth->User('emp_code');
        $emp_details = $this->EmpDetail->getemployeeinfomation($emp_code);
        $emp_name = $this->MyProfile->find('first', array('fields' => array('*'), 'conditions' => array('emp_code' => $this->Auth->user('emp_code'))));


        $userType = $this->TrainingCmp->getTrainingUserType();
        $employeelist = $this->Common->getEmployeesListByCompCode();

        $courselist = $this->TrainingCourseCreation->find('list', array(
            'fields' => 'name',
            'conditions' => array('status !=' => 1, 'comp_code' => $emp_details['MyProfile']['comp_code'])
        ));

        $reported_emp = $this->TrainingCmp->reportedEmpLists($emp_details['MyProfile']['comp_code'], $emp_code, $userType);

        if ($userType == 'TI') {
            $desg_wise_employee = $this->MyProfile->find('all', array(
                'fields' => array('count(MyProfile.id) as ct,MyProfile.emp_code,MyProfile.emp_firstname,MyProfile.comp_code,MyProfile.desg_code,MyProfile.location_code'),
                'group' => array('MyProfile.desg_code,MyProfile.location_code'),
                'conditions' => array('MyProfile.comp_code' => $emp_details['MyProfile']['comp_code'], 'MyProfile.emp_code !=' => $emp_details['MyProfile']['emp_code'])
            ));
        } else {
            $desg_wise_employee = $this->MyProfile->find('all', array(
                'fields' => array('count(MyProfile.id) as ct,MyProfile.emp_code,MyProfile.emp_firstname,MyProfile.comp_code,MyProfile.desg_code,MyProfile.location_code'),
                'group' => array('MyProfile.desg_code,MyProfile.location_code'),
                'conditions' => array('MyProfile.manager_code' => $emp_code, 'MyProfile.comp_code' => $emp_details['MyProfile']['comp_code'])
            ));
        }

        $trainingDetail = $this->TrainingCreation->find('first', array(
            'fields' => '*',
            'conditions' => array('training_id' => $training_id)
        ));

        $emplisting = $this->TrainingEmployee->find('list', array(
            'joins' => array(array(
                    'table' => 'myprofile',
                    'alias' => 'MyProfile',
                    'type' => 'RIGHT',
                    'conditions' => array('MyProfile.emp_code = TrainingEmployee.trainee_code')
                )
            ),
            'conditions' => array('TrainingEmployee.training_creation_id' => $training_id),
            'fields' => array('MyProfile.emp_code', 'MyProfile.emp_full_name'),
            'order' => 'MyProfile.emp_firstname ASC'
        ));

        if (!empty($emplisting)) {
            foreach ($emplisting as $empkey => $empvalue) {
                $emplisting[$empkey] = $empvalue . " (" . $this->TrainingCmp->getEmpIds($empkey) . ")";
            }
        }

        if (!empty($reported_emp)) {

            foreach ($reported_emp as $key => $value) {

                if (!empty($emplisting)) {

                    foreach ($emplisting as $key1 => $value1) {

                        if ($key == $key1)
                            unset($reported_emp[$key]);
                    }
                }
            }
        }

        $this->set('reported_emp', $reported_emp);
        $this->set('emplisting', $emplisting);
        $this->set('trainingDetail', $trainingDetail);
        $this->set('emp_code', $emp_code);
        $this->set('desg_wise_employee', $desg_wise_employee);
        $this->set('courselists', $courselist);
        $this->set('employeelist', $employeelist);
    }

    function sanctionTrainingIdentificationPmsForm($training_id) {

        $training_id = base64_decode($training_id);

        $this->layout = 'employee-new';
        $emp_code = $this->Auth->User('emp_code');
        $emp_details = $this->EmpDetail->getemployeeinfomation($emp_code);
        $emp_name = $this->MyProfile->find('first', array('fields' => array('*'), 'conditions' => array('emp_code' => $this->Auth->user('emp_code'))));


        $userType = $this->TrainingCmp->getTrainingUserType();
        $employeelist = $this->Common->getEmployeesListByCompCode();

        $courselist = $this->TrainingCourseCreation->find('list', array(
            'fields' => 'name',
            'conditions' => array('status !=' => 1, 'comp_code' => $emp_details['MyProfile']['comp_code'])
        ));

        $reported_emp = $this->TrainingCmp->reportedEmpLists($emp_details['MyProfile']['comp_code'], $emp_code, $userType);

        if ($userType == 'TI') {
            $desg_wise_employee = $this->MyProfile->find('all', array(
                'fields' => array('count(MyProfile.id) as ct,MyProfile.emp_code,MyProfile.emp_firstname,MyProfile.comp_code,MyProfile.desg_code,MyProfile.location_code'),
                'group' => array('MyProfile.desg_code,MyProfile.location_code'),
                'conditions' => array('MyProfile.comp_code' => $emp_details['MyProfile']['comp_code'])
            ));
        } else {
            $desg_wise_employee = $this->MyProfile->find('all', array(
                'fields' => array('count(MyProfile.id) as ct,MyProfile.emp_code,MyProfile.emp_firstname,MyProfile.comp_code,MyProfile.desg_code,MyProfile.location_code'),
                'group' => array('MyProfile.desg_code,MyProfile.location_code'),
                'conditions' => array('MyProfile.manager_code' => $emp_code, 'MyProfile.comp_code' => $emp_details['MyProfile']['comp_code'])
            ));
        }

        $trainingDetail = $this->TrainingCreation->find('first', array(
            'fields' => '*',
            'conditions' => array('training_id' => $training_id)
        ));

        $emplisting = $this->TrainingEmployee->find('list', array(
            'joins' => array(array(
                    'table' => 'myprofile',
                    'alias' => 'MyProfile',
                    'type' => 'RIGHT',
                    'conditions' => array('MyProfile.emp_code = TrainingEmployee.trainee_code')
                )
            ),
            'conditions' => array('TrainingEmployee.training_creation_id' => $training_id),
            'fields' => array('MyProfile.emp_code', 'MyProfile.emp_full_name'),
            'order' => 'MyProfile.emp_firstname ASC'
        ));

        if (!empty($emplisting)) {
            foreach ($emplisting as $empkey => $empvalue) {
                $emplisting[$empkey] = $empvalue . " (" . $this->TrainingCmp->getEmpIds($empkey) . ")";
            }
        }

        if (!empty($reported_emp)) {

            foreach ($reported_emp as $key => $value) {

                if (!empty($emplisting)) {

                    foreach ($emplisting as $key1 => $value1) {

                        if ($key == $key1)
                            unset($reported_emp[$key]);
                    }
                }
            }
        }

        $this->set('reported_emp', $reported_emp);
        $this->set('emplisting', $emplisting);
        $this->set('trainingDetail', $trainingDetail);
        $this->set('emp_code', $emp_code);
        $this->set('desg_wise_employee', $desg_wise_employee);
        $this->set('courselists', $courselist);
        $this->set('employeelist', $employeelist);
    }

    function sanctionTrainingEnrollmentForm($training_id) {

        $training_id = base64_decode($training_id);
        $this->layout = 'employee-new';
        $emp_code = $this->Auth->User('emp_code');
        $emp_details = $this->EmpDetail->getemployeeinfomation($emp_code);
        $emp_name = $this->MyProfile->find('first', array('fields' => array('*'), 'conditions' => array('emp_code' => $this->Auth->user('emp_code'))));
        $userType = $this->TrainingCmp->getTrainingUserType();
        $employeelist = $this->Common->getEmployeesListByCompCode();
        $courselist = $this->TrainingCourseCreation->find('list', array(
            'fields' => 'name',
            'conditions' => array('status !=' => 1, 'comp_code' => $emp_details['MyProfile']['comp_code'])
        ));
        $training = $this->TrainingCreation->find('first', array('conditions' => array('training_id' => $training_id)));
        $schedulelist = $this->TrainingScheduleCreation->find('list', array(
            'fields' => 'sch_start_date',
            'conditions' => array('status !=' => 1, 'course_id' => $training['TrainingCreation']['course_id'], 'comp_id' => $emp_details['MyProfile']['comp_code'], 'sch_start_date >=' => date('Y-m-d'))
        ));

        $reported_emp = $this->TrainingCmp->reportedEmpLists($emp_details['MyProfile']['comp_code'], $emp_code, $userType);
        $userType = $this->TrainingCmp->getTrainingUserType();
        if ($userType == 'TI') {
            $desg_wise_employee = $this->MyProfile->find('all', array(
                'fields' => array('count(MyProfile.id) as ct,MyProfile.emp_code,MyProfile.emp_firstname,MyProfile.comp_code,MyProfile.desg_code,MyProfile.location_code'),
                'group' => array('MyProfile.desg_code,MyProfile.location_code'),
                'conditions' => array('MyProfile.comp_code' => $emp_details['MyProfile']['comp_code'], 'MyProfile.emp_code !=' => $emp_code)
            ));
        } else {
            $desg_wise_employee = $this->MyProfile->find('all', array(
                'fields' => array('count(MyProfile.id) as ct,MyProfile.emp_code,MyProfile.emp_firstname,MyProfile.comp_code,MyProfile.desg_code,MyProfile.location_code'),
                'group' => array('MyProfile.desg_code,MyProfile.location_code'),
                'conditions' => array('MyProfile.manager_code' => $emp_code, 'MyProfile.comp_code' => $emp_details['MyProfile']['comp_code'])
            ));
        }

        $trainingDetail = $this->TrainingCreation->find('first', array(
            'fields' => '*',
            'conditions' => array('training_id' => $training_id)
        ));

        $emplisting = $this->TrainingEmployee->find('list', array(
            'joins' => array(array(
                    'table' => 'myprofile',
                    'alias' => 'MyProfile',
                    'type' => 'RIGHT',
                    'conditions' => array('MyProfile.emp_code = TrainingEmployee.trainee_code')
                )
            ),
            'conditions' => array('TrainingEmployee.training_creation_id' => $training_id),
            'fields' => array('MyProfile.emp_code', 'MyProfile.emp_full_name'),
            'order' => 'MyProfile.emp_firstname ASC'
        ));

        if (!empty($emplisting)) {
            foreach ($emplisting as $empkey => $empvalue) {
                $emplisting[$empkey] = $empvalue . " (" . $this->TrainingCmp->getEmpIds($empkey) . ")";
            }
        }

        if (!empty($reported_emp)) {
            foreach ($reported_emp as $key => $value) {
                if (!empty($emplisting)) {

                    foreach ($emplisting as $key1 => $value1) {

                        if ($key == $key1)
                            unset($reported_emp[$key]);
                    }
                }
            }
        }

        $this->set('reported_emp', $reported_emp);
        $this->set('emplisting', $emplisting);
        $this->set('emp_code', $emp_code);
        $this->set('trainingDetail', $trainingDetail);
        $this->set('courselists', $courselist);
        $this->set('schedulelists', $schedulelist);
        $this->set('desg_wise_employee', $desg_wise_employee);
        $this->set('employeelist', $employeelist);
    }

    /*
     * 
     */

    function savesanctionTrainingEnrollmentForm() {

        $emp_code = $this->Auth->User('emp_code');
        $emp_details = $this->EmpDetail->getemployeeinfomation($emp_code);
        $emp_name = $this->MyProfile->find('first', array('fields' => array('*'), 'conditions' => array('emp_code' => $this->Auth->user('emp_code'))));

        if (!empty($this->data)) {

            if (!empty($this->data['Training']['traineecode']) && !empty($this->data['Training']['traineedesgcode'])) {
                $traineeEmployees = array_merge($this->data['Training']['traineecode'], array_diff($this->data['Training']['traineedesgcode'], $this->data['Training']['traineecode']));
            } elseif ($this->data['Training']['traineecode']) {
                $traineeEmployees = $this->data['Training']['traineecode'];
            } else {
                $traineeEmployees = $this->data['Training']['traineedesgcode'];
            }

            $value['training_id'] = $this->data['training_id'];
            $value['course_id'] = $this->data['course_id'];
            $value['schedule_id'] = $this->data['schedule_id'];
            $value['description'] = $this->data['requirement'];
            $value['remarks'] = $this->data['remarks'];

            if (!empty($this->data['training_date']))
                $value['training_date'] = date("Y-m-d", strtotime($this->data['training_date']));

            if (!empty($this->data['self']))
                $value['self'] = 1;

            $value['training_start_time'] = $this->data['training_time'];
            $value['status'] = 2;
            $value['initated_by'] = 'E';
            $value['training_instructor_name'] = $this->data['Training']['training_instructor_name'];
            $training_id = $this->data['training_id'];

            //Check For Employee Training Maximum Capacity Student Start
            $cot_employee = $traineeEmployees;
            if (in_array($emp_code, $cot_employee)) {
                $allctemp = count($cot_employee);
            } elseif ($value['self'] == 1) {
                $allctemp = count($cot_employee) + 1;
            } else {
                $allctemp = count($cot_employee);
            }
            $max_course_capacity = $this->Common->getCourseMaxCapacity($this->data['course_id']);
            if ($allctemp > $max_course_capacity) {
                $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert=""><a href="#" class="uk-alert-close uk-close"></a>Maximum number of trainee should not be greater than  ' . $max_course_capacity . '.</div>');
                $this->redirect('/training/sanctionTrainingEnrollmentForm/' . base64_encode($training_id));
            }
            if (!empty($this->data['Training']['training_instructor_name'])) {
                if (in_array($this->data['Training']['training_instructor_name'], $traineeEmployees)) {
                    $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert=""><a href="#" class="uk-alert-close uk-close"></a>Instructor and trainee can not be same.</div>');
                    $this->redirect('/training/sanctionTrainingEnrollmentForm/' . base64_encode($training_id));
                }
            }
            //Check For Employee Training Maximum Capacity Student Ends

            if (!empty($this->TrainingCmp->getAllTraineeEmployee($this->data['training_id']))) {
                $allEmpLists = $this->TrainingCmp->getAllTraineeEmployee($this->data['training_id']);
                foreach ($traineeEmployees as $key => $empIds) {
                    foreach ($allEmpLists as $allEmpListKey => $allEmpListKeyVal) {
                        if ($empIds != $allEmpListKeyVal) {
                            if (!empty($this->TrainingCmp->chkTraineeEmployee($empIds, $training_id))) {
                                $this->TrainingEmployee->id = $allEmpListKey;
                                $this->TrainingEmployee->delete();
                            }
                        }
                    }
                }
            }

            if ($this->TrainingCreation->save($value)) {
                $training_id = $this->data['training_id'];
                if (!empty($this->data['Training'])) {
                    foreach ($traineeEmployees as $key => $empValues) {
                        if (empty($this->TrainingCmp->chkTraineeEmployee($empValues, $training_id))) {
                            $trainee_emp_details = $this->EmpDetail->getemployeeinfomation($empValues);
                            $val['training_creation_id'] = $training_id;
                            $val['trainee_code'] = $empValues;
                            $val['trainee_comp_code'] = $trainee_emp_details['MyProfile']['comp_code'];
                            $val['location'] = $trainee_emp_details['MyProfile']['location_code'];
                            $val['desg_code'] = $trainee_emp_details['MyProfile']['desg_code'];
                            $val['dept_code'] = $trainee_emp_details['MyProfile']['dept_code'];
                            $val['manager_code'] = $emp_code;
                            $val['approved_date'] = date("Y-m-d");
                            $this->TrainingEmployee->create();
                            $this->TrainingEmployee->save($val);
                        }
                    }
                }
                if (empty($this->TrainingCmp->chkTraineeEmployee($emp_code, $training_id))) {
                    if (!empty($this->data['self'])) {
                        $trainee_emp_details = $this->EmpDetail->getemployeeinfomation($emp_code);
                        $val['training_creation_id'] = $training_id;
                        $val['trainee_code'] = $emp_code;
                        $val['trainee_comp_code'] = $trainee_emp_details['MyProfile']['comp_code'];
                        $val['location'] = $trainee_emp_details['MyProfile']['location_code'];
                        $val['desg_code'] = $trainee_emp_details['MyProfile']['desg_code'];
                        $val['dept_code'] = $trainee_emp_details['MyProfile']['dept_code'];
                        $val['manager_code'] = $emp_code;
                        $val['approved_date'] = date("Y-m-d");
                        $this->TrainingEmployee->create();
                        $this->TrainingEmployee->save($val);
                    }
                }

                $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert=""><a href="#" class="uk-alert-close uk-close"></a>Training Enrollment Form successfully saved.</div>');
                $this->redirect('/training/fwtraining/' . $this->data['training_id']);
            }
        }
    }

    function savesanctionTrainingIdentificationForm() {
        //Configure::write('debug',2);
        $emp_code = $this->Auth->User('emp_code');
        $emp_details = $this->EmpDetail->getemployeeinfomation($emp_code);
        $emp_name = $this->MyProfile->find('first', array('fields' => array('*'), 'conditions' => array('emp_code' => $this->Auth->user('emp_code'))));

        if (!empty($this->data)) {

            if (!empty($this->data['Training']['traineecode']) && !empty($this->data['Training']['traineedesgcode'])) {
                $traineeEmployees = array_merge($this->data['Training']['traineecode'], array_diff($this->data['Training']['traineedesgcode'], $this->data['Training']['traineecode']));
            } elseif ($this->data['Training']['traineecode']) {
                $traineeEmployees = $this->data['Training']['traineecode'];
            } else {
                $traineeEmployees = $this->data['Training']['traineedesgcode'];
            }

            $value['training_id'] = $this->data['training_id'];
            $value['course_id'] = $this->data['course_id'];
            $value['schedule_id'] = $this->data['schedule_id'];
            $value['description'] = $this->data['requirement'];
            $value['remarks'] = $this->data['remarks'];

            if (!empty($this->data['training_date']))
                $value['training_date'] = date("Y-m-d", strtotime($this->data['training_date']));

            if (!empty($this->data['self']))
                $value['self'] = 1;

            $value['training_start_time'] = $this->data['training_time'];
            $value['status'] = 2;
            $value['initated_by'] = 'I';
            $value['training_instructor_name'] = $this->data['Training']['training_instructor_name'];
            $training_id = $this->data['training_id'];

            //Check For Employee Training Maximum Capacity Student Start
            //$cot_employee = array_unique(array_merge_recursive($this->TrainingCmp->getAllTraineeEmployee($this->data['training_id']), $traineeEmployees));
            $cot_employee = $traineeEmployees;
            if (in_array($emp_code, $cot_employee)) {
                $allctemp = count($cot_employee);
            } elseif ($value['self'] == 1) {
                $allctemp = count($cot_employee) + 1;
            } else {
                $allctemp = count($cot_employee);
            }

            $max_course_capacity = $this->Common->getCourseMaxCapacity($this->data['course_id']);

            if ($allctemp > $max_course_capacity) {
                $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert=""><a href="#" class="uk-alert-close uk-close"></a>Maximum number of trainee should not be greater than  ' . $max_course_capacity . '.</div>');
                $this->redirect('/training/sanctionTrainingIdentificationForm/' . base64_encode($training_id));
            }
            if (!empty($this->data['Training']['training_instructor_name'])) {
                if (in_array($this->data['Training']['training_instructor_name'], $traineeEmployees)) {
                    $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert=""><a href="#" class="uk-alert-close uk-close"></a>Instructor and trainee can not be same.</div>');
                    $this->redirect('/training/sanctionTrainingIdentificationForm/' . base64_encode($training_id));
                }
            }

            //Check For Employee Training Maximum Capacity Student Ends

            if (!empty($this->TrainingCmp->getAllTraineeEmployee($this->data['training_id']))) {
                $allEmpLists = $this->TrainingCmp->getAllTraineeEmployee($this->data['training_id']);
                foreach ($traineeEmployees as $key => $empIds) {
                    foreach ($allEmpLists as $allEmpListKey => $allEmpListKeyVal) {
                        if ($empIds != $allEmpListKeyVal) {
                            if (!empty($this->TrainingCmp->chkTraineeEmployee($empIds, $training_id))) {
                                $this->TrainingEmployee->id = $allEmpListKey;
                                $this->TrainingEmployee->delete();
                            }
                        }
                    }
                }
            }

            if ($this->TrainingCreation->save($value)) {
                $training_id = $this->data['training_id'];
                if (!empty($this->data['Training'])) {
                    foreach ($traineeEmployees as $key => $empValues) {
                        if (empty($this->TrainingCmp->chkTraineeEmployee($empValues, $training_id))) {
                            $trainee_emp_details = $this->EmpDetail->getemployeeinfomation($empValues);
                            $val['training_creation_id'] = $training_id;
                            $val['trainee_code'] = $empValues;
                            $val['trainee_comp_code'] = $trainee_emp_details['MyProfile']['comp_code'];
                            $val['location'] = $trainee_emp_details['MyProfile']['location_code'];
                            $val['desg_code'] = $trainee_emp_details['MyProfile']['desg_code'];
                            $val['dept_code'] = $trainee_emp_details['MyProfile']['dept_code'];
                            $val['manager_code'] = $emp_code;
                            $val['approved_date'] = date("Y-m-d");
                            $this->TrainingEmployee->create();
                            $this->TrainingEmployee->save($val);
                        }
                    }
                }
                if (empty($this->TrainingCmp->chkTraineeEmployee($emp_code, $training_id))) {
                    if (!empty($this->data['self'])) {
                        $trainee_emp_details = $this->EmpDetail->getemployeeinfomation($emp_code);
                        $val['training_creation_id'] = $training_id;
                        $val['trainee_code'] = $emp_code;
                        $val['trainee_comp_code'] = $trainee_emp_details['MyProfile']['comp_code'];
                        $val['location'] = $trainee_emp_details['MyProfile']['location_code'];
                        $val['desg_code'] = $trainee_emp_details['MyProfile']['desg_code'];
                        $val['dept_code'] = $trainee_emp_details['MyProfile']['dept_code'];
                        $val['manager_code'] = $emp_code;
                        $val['approved_date'] = date("Y-m-d");
                        $this->TrainingEmployee->create();
                        $this->TrainingEmployee->save($val);
                    }
                }
                $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert=""><a href="#" class="uk-alert-close uk-close"></a>Training Identification Form successfully saved.</div>');
                $this->redirect('/training/fwtraining/' . $this->data['training_id']);
            }
        }
    }

    function savesanctionPmsTrainingIdentificationForm() {
        //Configure::write('debug',2);
        $emp_code = $this->Auth->User('emp_code');
        $emp_details = $this->EmpDetail->getemployeeinfomation($emp_code);
        $emp_name = $this->MyProfile->find('first', array('fields' => array('*'), 'conditions' => array('emp_code' => $this->Auth->user('emp_code'))));

        if (!empty($this->data)) {

            if (!empty($this->data['Training']['traineecode']) && !empty($this->data['Training']['traineedesgcode'])) {
                $traineeEmployees = array_merge($this->data['Training']['traineecode'], array_diff($this->data['Training']['traineedesgcode'], $this->data['Training']['traineecode']));
            } elseif ($this->data['Training']['traineecode']) {
                $traineeEmployees = $this->data['Training']['traineecode'];
            } else {
                $traineeEmployees = $this->data['Training']['traineedesgcode'];
            }

            $value['training_id'] = $this->data['training_id'];
            $value['course_id'] = $this->data['course_id'];
            $value['schedule_id'] = $this->data['schedule_id'];
            $value['description'] = $this->data['requirement'];
            $value['remarks'] = $this->data['remarks'];

            if (!empty($this->data['training_date']))
                $value['training_date'] = date("Y-m-d", strtotime($this->data['training_date']));

            if (!empty($this->data['self']))
                $value['self'] = 1;

            $value['training_start_time'] = $this->data['training_time'];
            $value['status'] = 2;
            $value['initated_by'] = 'P';
            $value['training_instructor_name'] = $this->data['Training']['training_instructor_name'];
            $training_id = $this->data['training_id'];

            //Check For Employee Training Maximum Capacity Student Start
            $cot_employee = array_unique(array_merge_recursive($this->TrainingCmp->getAllTraineeEmployee($this->data['training_id']), $traineeEmployees));
            if (in_array($emp_code, $cot_employee)) {
                $allctemp = count($cot_employee);
            } elseif ($value['self'] == 1) {
                $allctemp = count($cot_employee) + 1;
            } else {
                $allctemp = count($cot_employee);
            }

            $max_course_capacity = $this->Common->getCourseMaxCapacity($this->data['course_id']);

            if ($allctemp > $max_course_capacity) {
                $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert=""><a href="#" class="uk-alert-close uk-close"></a>Maximum number of trainee should not be greater than  ' . $max_course_capacity . '.</div>');
                $this->redirect('/training/sanctionTrainingIdentificationPmsForm/' . base64_encode($training_id));
            }
            if (!empty($this->data['Training']['training_instructor_name'])) {
                if (in_array($this->data['Training']['training_instructor_name'], $traineeEmployees)) {
                    $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert=""><a href="#" class="uk-alert-close uk-close"></a>Instructor and trainee can not be same.</div>');
                    $this->redirect('/training/sanctionTrainingIdentificationPmsForm/' . base64_encode($training_id));
                }
            }

            //Check For Employee Training Maximum Capacity Student Ends

            if (!empty($this->TrainingCmp->getAllTraineeEmployee($this->data['training_id']))) {
                $allEmpLists = $this->TrainingCmp->getAllTraineeEmployee($this->data['training_id']);
                foreach ($traineeEmployees as $key => $empIds) {
                    foreach ($allEmpLists as $allEmpListKey => $allEmpListKeyVal) {
                        if ($empIds != $allEmpListKeyVal) {
                            if (!empty($this->TrainingCmp->chkTraineeEmployee($empIds, $training_id))) {
                                $this->TrainingEmployee->id = $allEmpListKey;
                                $this->TrainingEmployee->delete();
                            }
                        }
                    }
                }
            }

            if ($this->TrainingCreation->save($value)) {
                $training_id = $this->data['training_id'];
                if (!empty($this->data['Training'])) {
                    foreach ($traineeEmployees as $key => $empValues) {
                        if (empty($this->TrainingCmp->chkTraineeEmployee($empValues, $training_id))) {
                            $trainee_emp_details = $this->EmpDetail->getemployeeinfomation($empValues);
                            $val['training_creation_id'] = $training_id;
                            $val['trainee_code'] = $empValues;
                            $val['trainee_comp_code'] = $trainee_emp_details['MyProfile']['comp_code'];
                            $val['location'] = $trainee_emp_details['MyProfile']['location_code'];
                            $val['desg_code'] = $trainee_emp_details['MyProfile']['desg_code'];
                            $val['dept_code'] = $trainee_emp_details['MyProfile']['dept_code'];
                            $val['manager_code'] = $emp_code;
                            $val['approved_date'] = date("Y-m-d");
                            $this->TrainingEmployee->create();
                            $this->TrainingEmployee->save($val);
                        }
                    }
                }
                if (empty($this->TrainingCmp->chkTraineeEmployee($emp_code, $training_id))) {
                    if (!empty($this->data['self'])) {
                        $trainee_emp_details = $this->EmpDetail->getemployeeinfomation($emp_code);
                        $val['training_creation_id'] = $training_id;
                        $val['trainee_code'] = $emp_code;
                        $val['trainee_comp_code'] = $trainee_emp_details['MyProfile']['comp_code'];
                        $val['location'] = $trainee_emp_details['MyProfile']['location_code'];
                        $val['desg_code'] = $trainee_emp_details['MyProfile']['desg_code'];
                        $val['dept_code'] = $trainee_emp_details['MyProfile']['dept_code'];
                        $val['manager_code'] = $emp_code;
                        $val['approved_date'] = date("Y-m-d");
                        $this->TrainingEmployee->create();
                        $this->TrainingEmployee->save($val);
                    }
                }
                $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert=""><a href="#" class="uk-alert-close uk-close"></a>Training Identification Form successfully saved.</div>');
                $this->redirect('/training/fwtraining/' . $this->data['training_id']);
            }
        }
    }

    public function getInfo() {
        try {
            $id = base64_decode($this->params['pass']['0']);
            if (!empty($id)) {
                $tdetails = $this->TrainingCreation->find('all', array(
                    'fields' => array('*'),
                    'conditions' => array('TrainingCreation.training_id' => $id)));
                $this->set('tdetails', $tdetails);
                $this->layout = '';
                $this->render('trainingdetails');
            }
        } catch (Exception $e) {
            
        }
    }

    /*
     * Delete Training Records
     */

    function deleteTraining($training_id) {
        $training_id = base64_decode($training_id);
        $ld = $this->TrainingCreation->find('list', array(
            'conditions' => array(
                'training_id' => $training_id
            )
        ));
        foreach ($ld as $key => $value) {
            $this->TrainingCreation->delete($value);
        }
        $wf = $this->TrainingEmployee->find('list', array(
            'conditions' => array(
                'training_creation_id' => $training_id
            )
        ));
        foreach ($wf as $key => $value) {
            $this->TrainingEmployee->delete($value);
        }
        $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                            <a href="#" class="uk-alert-close uk-close"></a>Training Deleted Sucessfully</div>');
        $this->redirect('manageTrainingIdentificationForm/');
    }

    public function upcomingTraining() {
        //Configure::write('debug', 2);
        $this->layout = 'employee-new';
        $emp_code = $this->Auth->User('emp_code');
        $comp_code = $this->Auth->User('comp_code');
        $query = $this->TrainingCreation->find('all', array(
            'fields' => array('*'),
            'joins' => array(
                array(
                    'table' => 'training_employee',
                    'alias' => 'TrainingEmployee',
                    'type' => 'inner',
                    'foreignKey' => false,
                    'conditions' => array('TrainingEmployee.training_creation_id = TrainingCreation.training_id')
                ), array(
                    'table' => 'training_schedule_creation',
                    'alias' => 'training_schedule_creation',
                    'type' => 'inner',
                    'foreignKey' => false,
                    'conditions' => array('training_schedule_creation.schedule_id = TrainingCreation.schedule_id')
                )
            ),
            'conditions' => array('training_schedule_creation.sch_start_date >=' => date('Y-m-d'), 'training_schedule_creation.final_regis_date >=' => date('Y-m-d'), 'training_schedule_creation.status !=' => 1, 'TrainingCreation.status' => 5, 'TrainingEmployee.trainee_code' => $emp_code, 'TrainingEmployee.trainee_comp_code' => $comp_code, 'TrainingEmployee.status !=' => 5),
        ));
        $this->set('uptraining', $query);
    }

    public function upcomingApply($training_id) {
        $this->layout = 'employee-new';
        $training_id = base64_decode($training_id);
        $trainingdetails = $this->TrainingCreation->find('first', array('conditions' => array('TrainingCreation.training_id' => $training_id)));
        $schedule_id = $trainingdetails['TrainingCreation']['schedule_id'];
        $schedule_dtl = $this->TrainingScheduleCreation->find('first', array('conditions' => array('schedule_id' => $schedule_id)));

        $this->set('trainingdt', $trainingdetails);
        $this->set('scheduledt', $schedule_dtl);
    }

    /*
     * Function Training Attendence List
     */

    public function trainingAttendence() {
        //Configure::write('debug', 2);
        $this->layout = 'employee-new';
        $emp_code = $this->Auth->User('emp_code');
        $emp_details = $this->EmpDetail->getemployeeinfomation($emp_code);
        $emp_name = $this->MyProfile->find('first', array('fields' => array('*'), 'conditions' => array('emp_code' => $this->Auth->user('emp_code'))));
        $this->set('emp_code', $emp_code);
    }

    /*
     * Open Attendence Form
     */

    function openAttendence($training_id) {
        $training_id = base64_decode($training_id);
        $this->layout = 'employee-new';
        $emp_code = $this->Auth->User('emp_code');
        $emp_details = $this->EmpDetail->getemployeeinfomation($emp_code);
        $emp_name = $this->MyProfile->find('first', array('fields' => array('*'), 'conditions' => array('emp_code' => $this->Auth->user('emp_code'))));
        if (!empty($training_id)) {
            $vals = $this->TrainingCreation->find('first', array(
                'conditions' => array('TrainingCreation.training_id' => $training_id)
            ));

            if (!empty($vals)) {
                $this->set('vals', $vals);
            } else {
                $this->redirect(array('controller' => 'Training', 'action' => 'trainingAttendence'));
            }
        } else {
            $this->redirect(array('controller' => 'Training', 'action' => 'trainingAttendence'));
        }
    }

    /*
     * Save Open Attendence
     */

    function saveOpenAttendence() {
        //$this->autoRender = false;
        $emp_code = $this->Auth->User('emp_code');
        $comp_code = $this->Auth->User('comp_code');
        $emp_details = $this->EmpDetail->getemployeeinfomation($emp_code);
        $emp_name = $this->MyProfile->find('first', array('fields' => array('*'), 'conditions' => array('emp_code' => $this->Auth->user('emp_code'))));

        $training_id = base64_decode($this->data['tid']);
        $chkName = $this->TrainingCourseAttendence->find('all', array(
            'fields' => array('count(id)'),
            'conditions' => array(
                'training_creation_id' => $training_id, 'trainee_code' => $training_id, 'trainee_comp_code' => $training_id)
        ));

        if (!empty($chkName) && $chkName[0][0]['count(id)'] >= 1) {
            $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert=""><a href="#" class="uk-alert-close uk-close"></a>Open Attendence already applied.</div>');
            $this->redirect('/training/openAttendence/');
        }

        $this->TrainingCourseAttendence->create();
        $type_value['training_creation_id'] = $training_id;
        $type_value['trainee_code'] = $emp_code;
        $type_value['trainee_comp_code'] = $comp_code;
        $type_value['open'] = 1;
        $type_value['open_time'] = date('Y-m-d h:i:s a');
        $type_value['created_at'] = date('Y-m-d');

        if ($this->TrainingCourseAttendence->save($type_value)) {
            $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert=""><a href="#" class="uk-alert-close uk-close"></a>Attendance Opened Successfully.</div>');
            $record_id = $this->TrainingCourseAttendence->getLastInsertID();
            $this->redirect('/training/openAttendence/');
        }
    }

    /*
     * Close Attendence Form
     */

    function closeAttendence($attendence_id) {
        $attendence_id = base64_decode($attendence_id);
        $this->layout = 'employee-new';
        $emp_code = $this->Auth->User('emp_code');
        $emp_details = $this->EmpDetail->getemployeeinfomation($emp_code);
        $emp_name = $this->MyProfile->find('first', array('fields' => array('*'), 'conditions' => array('emp_code' => $this->Auth->user('emp_code'))));
        if (!empty($attendence_id)) {
            $attendence = $this->TrainingCourseAttendence->find('first', array('conditions' => array('TrainingCourseAttendence.id' => $attendence_id)));

            $vals = $this->TrainingCreation->find('first', array(
                'conditions' => array('TrainingCreation.training_id' => $attendence['TrainingCourseAttendence']['training_creation_id'])
            ));

            if (!empty($vals)) {
                $this->set('attendence_id', $attendence_id);
                $this->set('vals', $vals);
            } else {
                $this->redirect(array('controller' => 'Training', 'action' => 'trainingAttendence'));
            }
        } else {
            $this->redirect(array('controller' => 'Training', 'action' => 'trainingAttendence'));
        }
    }

    /*
     * Save close Attendence
     */

    function saveCloseAttendence() {
        //Configure::write('debug', 2);
        $emp_code = $this->Auth->User('emp_code');
        $comp_code = $this->Auth->User('comp_code');
        $emp_details = $this->EmpDetail->getemployeeinfomation($emp_code);
        $emp_name = $this->MyProfile->find('first', array('fields' => array('*'), 'conditions' => array('emp_code' => $this->Auth->user('emp_code'))));

        $training_id = base64_decode($this->data['tid']);
        $attendence_id = base64_decode($this->data['aid']);
        $chkName = $this->TrainingCourseAttendence->find('all', array(
            'fields' => array('count(TrainingCourseAttendence.id)', 'TrainingCourseAttendence.open', 'TrainingCourseAttendence.close'),
            'conditions' => array(
                'TrainingCourseAttendence.training_creation_id' => $training_id, 'TrainingCourseAttendence.id' => $attendence_id, 'TrainingCourseAttendence.trainee_code' => $emp_code)
        ));

        if (!empty($chkName) && $chkName['TrainingCourseAttendence']['open'] == 1 && !empty($chkName['TrainingCourseAttendence']['close'])) {
            $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert=""><a href="#" class="uk-alert-close uk-close"></a>Attendence already applied.</div>');
            $this->redirect('/training/trainingAttendence/');
        }

        $type_value['id'] = $attendence_id;
        $type_value['training_creation_id'] = $training_id;
        $type_value['trainee_code'] = $emp_code;
        $type_value['trainee_comp_code'] = $comp_code;
        $type_value['close'] = 1;
        $type_value['close_time'] = date('Y-m-d h:i:s a');

        if ($this->TrainingCourseAttendence->save($type_value)) {

            //Email Start
            $training_config = $this->TrainingConfig->find('first', array('fields' => array('*'), 'conditions' => array('comp_code' => $this->Auth->user('comp_code'))));
            if ($training_config['TrainingConfig']['email']) {
                $training_vals = $this->TrainingCreation->find('first', array(
                    'conditions' => array('TrainingCreation.training_id' => $training_id)
                ));
                $emp_details = $this->EmpDetail->getemployeeinfomation($training_vals['TrainingWorkflow'][count($training_vals['TrainingWorkflow']) - 1]['emp_code']);

                $Frommail = $this->TrainingCmp->getEmailID($emp_details['MyProfile']['emp_code']);
                $From = $Frommail['UserDetail']['email'];
                $Tommail = $this->TrainingCmp->getEmailID($emp_code);
                $To = $Tommail['UserDetail']['email'];
                $sub = 'Submission of Training Feedback Form - ' . strtoupper($training_vals['TrainingCourseCreation']['name']);
                $template = 'trainingemail_template';
                $data['appName'] = $Tommail['UserDetail']['user_name'];
                $data['logo'] = 'logo_email.png';

                $msg = "<div>This is to inform that the training feedback on " . strtoupper($training_vals['TrainingCourseCreation']['name']) . " conducted on " . date('d-m-Y', strtotime($training_vals['TrainingCreation']['training_date'])) . " for submission and available on portal so please login and submit your valuable feedback.<br />The feedback form needs to be submitted within 3 days from the date of training.<br />Please let me know in case you are not able to access the same.<br />In case if the feedback form is not submitted your attendance would not be considered and you will be marked as absent.<br /><br />For any further assistance please feel free to reach me.</div> <br />";
                if (isset($To)) {
                    $this->send_mail($From, $To, $CC, $sub, $msg, $template, $data);
                }
            }
            //Email Ends

            $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert=""><a href="#" class="uk-alert-close uk-close"></a>Attendance Closed Successfully.</div>');
            $this->redirect('/training/trainingAttendence/');
        }
    }

    public function saveUpcominTraining($training_id) {
        $training_id = base64_decode($training_id);
        //print_r($training_id);die;
        $emp_code = $this->Auth->User('emp_code');
        $this->autoload = false;
        $date = date('Y-m-d');
        // print_r($date);die;
        $this->TrainingEmployee->updateAll(
                array('TrainingEmployee.status' => 5, 'TrainingEmployee.reg_date' => "'$date'"), array('TrainingEmployee.trainee_code' => $emp_code, 'TrainingEmployee.training_creation_id' => $training_id)
        );
        $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                            <a href="#" class="uk-alert-close uk-close"></a>Training Registration Applied Sucessfully</div>');
        $this->redirect('upcomingTraining');
    }

    public function listevolutionMatrix() {
        $this->layout = 'employee-new';
        $currentdate = date('Y-m-d');
        $this->paginate = array(
            'fields' => array('*'),
            'limit' => 40,
            'order' => 'TrainingCreation.training_id DESC',
            'joins' => array(
                array(
                    'table' => 'training_schedule_creation',
                    'alias' => 'schedule',
                    'type' => 'inner',
                    'foreignKey' => false,
                    'conditions' => array('TrainingCreation.schedule_id = schedule.schedule_id')
                )
            ),
            'conditions' => array('TrainingCreation.status' => 5, 'schedule.sch_end_date <' => $currentdate)
        );
        $listalltraining = $this->paginate('TrainingCreation');
        $this->set('list', $listalltraining);
    }

    public function evolutionMatrix($training_id) {
        $this->layout = 'employee-new';
        $training_id = base64_decode($training_id);
        $training = $this->TrainingCreation->find('first', array('conditions' => array('training_id' => $training_id)));
        $this->set('training', $training);
    }

    public function viewMatrix($training_id) {
        $this->layout = 'employee-new';
        $training_id = base64_decode($training_id);
        $training = $this->TrainingCreation->find('first', array('conditions' => array('training_id' => $training_id)));
        $this->set('training', $training);
    }

    public function saveEvaluation() {
        $emp_code = $this->Auth->User('emp_code');
        $comp_code = $this->Auth->User('comp_code');
        if (!empty($this->data)) {
            $training_id = $this->data['training_id'];
            $vals = $this->TrainingCreation->find('first', array(
                'conditions' => array('TrainingCreation.training_id' => $training_id)
            ));

            $this->TrainingMstMatrix->create();
            $value['training_id'] = $vals['TrainingCreation']['training_id'];
            $value['schedule_id'] = $vals['TrainingCreation']['schedule_id'];
            $value['comp_code'] = $comp_code;
            $value['evolution_emp_code'] = $emp_code;
            $value['created_at'] = date('Y-m-d');
            if ($this->TrainingMstMatrix->save($value)) {
                $matrix_id = $this->TrainingMstMatrix->getLastInsertID();
                if (!empty($this->data['trainee_code'])) {
                    foreach ($this->data['trainee_code'] as $key => $val) {
                        $this->TrainingDtMatrix->create();
                        $feedvalue['mst_training_matrix_id'] = $matrix_id;
                        $feedvalue['training_creation_id'] = $vals['TrainingCreation']['training_id'];
                        $feedvalue['emp_code'] = $val;
                        $feedvalue['comp_code'] = $comp_code;
                        if (!empty($this->data['passed_check'][$key]))
                            $feedvalue['passed'] = 1;
                        if (!empty($this->data['fail_check'][$key]))
                            $feedvalue['fail'] = 1;
                        if (!empty($this->data['present'][$key]))
                            $feedvalue['present'] = 1;
                        if (!empty($this->data['no_show'][$key]))
                            $feedvalue['no_show'] = 1;
                        $feedvalue['score'] = $this->data['score'][$key];
                        $feedvalue['course_validity'] = $this->data['Evaluate']['validity_name_' . $key];
                        $feedvalue['certificate'] = $this->data['certificate'][$key];
                        if (empty($this->data['iwcf_date'][$key])) {
                            //$feedvalue['iwcf_date'] = '0000-00-00';
                        } else {
                            $feedvalue['iwcf_date'] = date('Y-m-d', strtotime($this->data['iwcf_date'][$key]));
                        }
                        $feedvalue['created_at'] = date('Y-m-d');
                        $this->TrainingDtMatrix->save($feedvalue);
                        unset($feedvalue);
                    }
                }

                $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert=""><a href="#" class="uk-alert-close uk-close"></a>Training Evolute Successfully.</div>');
                $this->redirect('/training/listevolutionMatrix/');
            }
        }
    }

    public function onlineTrainingFeedback($trainingid) {
        //Configure::write('debug', 2);
        $this->layout = 'employee-new';
        $emp_code = $this->Auth->User('emp_code');
        $comp_code = $this->Auth->User('comp_code');
        $emp_details = $this->EmpDetail->getemployeeinfomation($emp_code);
        $emp_name = $this->MyProfile->find('first', array('fields' => array('*'), 'conditions' => array('emp_code' => $this->Auth->user('emp_code'))));

        $listvalues = $this->TrainingParameters->find('list', array('conditions' => array('TrainingParameters.comp_code' => $comp_code, "TrainingParameters.parameter_code like '%RAT%' "), 'fields' => array('TrainingParameters.parameter_code', 'TrainingParameters.name'), 'order' => array(
                'TrainingParameters.parameter_code' => 'ASC'
        )));

        $this->set('listvalues', $listvalues);

        $decissionlistvalues = $this->TrainingParameters->find('list', array('conditions' => array('TrainingParameters.comp_code' => $comp_code, "TrainingParameters.parameter_code like '%AGR%' "), 'fields' => array('TrainingParameters.parameter_code', 'TrainingParameters.name'), 'order' => array(
                'TrainingParameters.parameter_value' => 'desc'
        )));

        $this->set('decissionlistvalues', $decissionlistvalues);
        $TIMelistvalues = $this->TrainingParameters->find('list', array('conditions' => array('TrainingParameters.comp_code' => $comp_code, "TrainingParameters.parameter_code like '%TIM0%' "), 'fields' => array('TrainingParameters.parameter_code', 'TrainingParameters.name'), 'order' => array(
                'TrainingParameters.parameter_code' => 'asc'
        )));
        $this->set('TIMelistvalues', $TIMelistvalues);
        $training_id = base64_decode($trainingid);
        $vals = $this->TrainingCreation->find('first', array(
            'conditions' => array('TrainingCreation.training_id' => $training_id)
        ));
        $check = $this->TrainingFeedback->find('first', array(
            'conditions' => array('TrainingFeedback.training_creation_id' => $training_id, 'TrainingFeedback.emp_code' => $emp_code)
        ));
        if (!empty($check)) {
            $this->redirect('/training/pendingFeedbacks/');
        }
        $this->set('vals', $vals);
        $this->set('emps', $emp_name);
    }

    public function save_feedback_details() {
        if (!empty($this->data)) {
            $emp_code = $this->Auth->User('emp_code');
            $comp_code = $this->Auth->User('comp_code');
            $training_id = base64_decode($this->data['Training']['f_id']);
            $vals = $this->TrainingCreation->find('first', array(
                'conditions' => array('TrainingCreation.training_id' => $training_id)
            ));
            $this->TrainingFeedback->create();
            $value['comp_code'] = $comp_code;
            $value['emp_code'] = $emp_code;
            $value['training_creation_id'] = $training_id;
            $value['rate_quality'] = $this->data['TrainingFeedback']['rate_quality'];
            $value['rate_admin'] = $this->data['TrainingFeedback']['rate_admin'];
            $value['rate_contents'] = $this->data['TrainingFeedback']['rate_contents'];
            $value['session_eliminate'] = $this->data['TrainingFeedback']['session_eliminate'];
            $value['session_desc'] = $this->data['TrainingFeedback']['session_desc'];
            $value['additional_sess_eliminate'] = $this->data['TrainingFeedback']['additional_sess_eliminate'];
            $value['additional_sess_desc'] = $this->data['TrainingFeedback']['additional_sess_desc'];
            $value['duration_training_prog'] = $this->data['TrainingFeedback']['duration_training_prog'];
            $value['amt_time_appro'] = $this->data['TrainingFeedback']['amt_time_appro'];
            $value['amt_time_appro_desc'] = $this->data['TrainingFeedback']['amt_time_appro_desc'];
            $value['satisfied'] = $this->data['TrainingFeedback']['satisfied'];
            $value['satisfied_desc'] = $this->data['TrainingFeedback']['satisfied_desc'];
            $value['entry_date'] = date('Y-m-d H:i:s');
            if ($this->TrainingFeedback->save($value)) {
                $feedback_id = $this->TrainingFeedback->getLastInsertID();
                $this->TrainingTrainerFeedback->create();
                $feedvalue['training_creation_id'] = $training_id;
                $feedvalue['feedback_id'] = $feedback_id;
                $feedvalue['comp_code'] = $comp_code;
                $feedvalue['feedback_by'] = $emp_code;
                $feedvalue['feedback_for'] = $vals['TrainingScheduleCreation']['instructor_name'];
                $feedvalue['rate_present'] = $this->data['TrainingTrainerFeedback']['rate_present'];
                $feedvalue['subject_know'] = $this->data['TrainingTrainerFeedback']['subject_know'];
                $feedvalue['handle_query'] = $this->data['TrainingTrainerFeedback']['handle_query'];
                $feedvalue['course_id'] = $vals['TrainingCreation']['course_id'];
                $feedvalue['schedule_id'] = $vals['TrainingCreation']['schedule_id'];
                $feedvalue['entry_date'] = date('Y-m-d H:i:s');
                $this->TrainingTrainerFeedback->save($feedvalue);
                $this->TrainingCourseAttendence->updateAll(array('feedback_status' => 1), array(
                    'training_creation_id' => $training_id,
                    'trainee_code' => $emp_code));
                $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert=""><a href="#" class="uk-alert-close uk-close"></a>Feedback saved successfully.</div>');
                $this->redirect('/training/pendingFeedbacks/');
            }
        }
    }

    /*
     * Training Mail
     */

    function training_emails($from_emp_code, $to_emp_code, $subject, $msg_body_text) {

        $from_details = $this->Trainingcmp->getEmailID($from_emp_code);

        $to_details = $this->Trainingcmp->getEmailID($to_emp_code);

        $this->Email->from = $from_details['Employees']['vc_email'];

        $this->Email->to = $to_details['Employees']['vc_email'];

        //$this->Email->to       = 'hakim.singh@essindia.co.in';

        $this->Email->subject = $subject;

        $this->Email->layout = 'trainemail_template';

        $this->Email->template = 'trainemail_template';

        $this->Email->sendAs = 'html';

        $sign_off = ucwords(strtolower($from_details['Employees']['vc_emp_name']));

        $this->set('sign_off', $sign_off);

        $prefix = $this->Trainingcmp->getNamePrefix($to_emp_code, 'RM');

        $this->set('name', $prefix . ucwords($name));

        $this->set('mesg', $msg_body_text);

        //$this->Email->send($msg_body_text);
    }

    /*
     * Email of absent Employee
     */

    function absenteemailToReportingManager() {
        //Configure::write('debug', 2);
        $before_five_days = date('Y-m-d', strtotime('-3 days'));
        $query = $this->TrainingCreation->find('all', array(
            'fields' => array('*'),
            'conditions' => array('TrainingScheduleCreation.sch_end_date =' => $before_five_days, 'TrainingCreation.status' => 5, 'TrainingCreation.comp_code' => $this->Auth->User('comp_code')),
        ));

        if (!empty($query)) {
            foreach ($query as $queryVal) {

                foreach ($queryVal['TrainingWorkflow'] as $trainworkfow) {
                    if ($trainworkfow['status'] != 5) {
                        $Tommail = $this->TrainingCmp->getEmailID($trainworkfow['emp_code']);
                        $manageremp_code[] = $Tommail['UserDetail']['email'];
                        $data_app_name[] = $Tommail['UserDetail']['user_name'];
                    } else {
                        $trainincharge = $trainworkfow['emp_code'];
                    }
                }

                $Frommail = $this->TrainingCmp->getEmailID($trainincharge);
                $From = $Frommail['UserDetail']['email'];
                $Tommail = $this->TrainingCmp->getEmailID($this->request->data['TrainingWorkflow']['emp_code']);
                //$To = implode(',', $manageremp_code);
                $sub = 'List of absentees of ' . strtoupper($queryVal['TrainingCourseCreation']['name']) . ' Training';
                $template = 'trainingemail_template';
                //$data['appName'] = implode(',', $data_app_name);
                $data['logo'] = 'logo_email.png';

                //$Frommail = $this->TrainingCmp->getEmailID($trainincharge);
                //$From = $Frommail['UserDetail']['email'];
                //$To = implode(',', $manageremp_code);
                //$subject = 'List of absentees of ' . strtoupper($queryVal['TrainingCourseCreation']['name']) . ' Training';
                $datagrid = '';

                $datagrid = "<div>The list of absentees for the training " . strtoupper($queryVal['TrainingCourseCreation']['name']) . " conducted on " . date('d-m-Y', strtotime($queryVal['TrainingCreation']['training_date'])) . "  is given below :<br/><br/>";
                $datagrid .= '<div>
			             <table width="40%" cellspacing="1" cellpadding="5" border="1" class="exp-voucher" style="align:right  !important;font-size:11px;">
							<tr>
								<th scope="row"><strong>S.N.</strong></th>
								<th scope="row"><strong>Employee Code </strong></th>
								<th scope="row"><strong>Employee Name</strong></th>
							</tr>';
                $i = 1;
                foreach ($queryVal['TrainingEmployee'] as $empVal) {
                    if (empty($this->Common->checkAbsentTrainee($empVal['training_creation_id'], $empVal['trainee_code']))) {
                        $trainee_emp_detail = $this->EmpDetail->getemployeeinfomation($empVal['trainee_code']);
                        $absentees .= '<tr>
								<td valign="top">' . $i . '</td>
								<td valign="top">' . $trainee_emp_detail['MyProfile']['emp_id'] . '</td>
								<td valign="top">' . $trainee_emp_detail['MyProfile']['emp_full_name'] . '</td>
							</tr>';
                        $i++;
                    }
                    unset($trainee_emp_detail);
                }

                $datagrid .= $absentees;
                $datagrid .= '</table></div> <br/>';
                $datagrid .= 'I would appreciate if you could kindly provide me the details for the unavailability. <br/>';
                $datagrid .= 'For any further query please feel free to reach me. </div><br />';
                $msg = $datagrid;

                if (!empty($manageremp_code)) {
                    foreach ($manageremp_code as $ky => $manageremp_code_mail) {
                        if (!empty($manageremp_code_mail) && !empty($data_app_name[$ky])) {
                            $data['appName'] = $data_app_name[$ky];
                            echo "oooooooooooooo";
                            $this->send_mail($From, $manageremp_code_mail, $CC, $sub, $msg, $template, $data);
                        }
                    }
                }
                unset($datagrid, $manageremp_code, $absentees, $data_app_name);
            }
        }
        die();
    }

    function feedbackList() {

        $this->layout = 'employee-new';
        $emp_code = $this->Auth->User('emp_code');
        $emp_details = $this->EmpDetail->getemployeeinfomation($emp_code);
        $emp_name = $this->MyProfile->find('first', array('fields' => array('*'), 'conditions' => array('emp_code' => $this->Auth->user('emp_code'))));
        $userType = $this->TrainingCmp->getTrainingUserType();
        if ($userType == 'TI') {
            $this->paginate = array(
                'fields' => array('*'),
                'limit' => 40,
                'order' => 'TrainingFeedback.feedback_id DESC',
                'joins' => array(
                    array(
                        'table' => 'training_feedback_trainers',
                        'alias' => 'TrainingTrainerFeedback',
                        'type' => 'inner',
                        'foreignKey' => false,
                        'conditions' => array('TrainingTrainerFeedback.feedback_id =  TrainingFeedback.feedback_id')
                    )
                ),
            );
        } else {
            $this->paginate = array(
                'fields' => array('*'),
                'limit' => 40,
                'order' => 'TrainingFeedback.feedback_id DESC',
                'joins' => array(
                    array(
                        'table' => 'training_feedback_trainers',
                        'alias' => 'TrainingTrainerFeedback',
                        'type' => 'inner',
                        'foreignKey' => false,
                        'conditions' => array('TrainingTrainerFeedback.feedback_id =  TrainingFeedback.feedback_id')
                    )
                ),
                'conditions' => array('TrainingFeedback.feedback_by' => $emp_code)
            );
        }

        $feedbackList = $this->paginate('TrainingFeedback');
        $this->set("feedbakcLists", $feedbackList);
    }

    function pendingFeedbacks() {
        //Configure::write('debug', 2);
        $this->layout = 'employee-new';
        $emp_code = $this->Auth->User('emp_code');
        $emp_details = $this->EmpDetail->getemployeeinfomation($emp_code);
        $emp_name = $this->MyProfile->find('first', array('fields' => array('*'), 'conditions' => array('emp_code' => $this->Auth->user('emp_code'))));
        $userType = $this->TrainingCmp->getTrainingUserType();
        if ($userType == 'TI') {
            $details = $this->TrainingCourseAttendence->find('all', array(
                'conditions' => array(
                    'TrainingCourseAttendence.open' => 1, 'TrainingCourseAttendence.close' => 1)
            ));
        } else {
            $details = $this->TrainingCourseAttendence->find('all', array(
                'conditions' => array(
                    'TrainingCourseAttendence.open' => 1, 'TrainingCourseAttendence.close' => 1, 'TrainingCourseAttendence.trainee_code' => $emp_code)
            ));
        }

        $this->set('details', $details);
        $this->set('usertype', $userType);
        $this->set('emp_code', $emp_code);
    }

    function getCourseScheduleDetails() {
        $schedule_id = $_REQUEST['sid'];
        $ldetails = $this->TrainingScheduleCreation->find('first', array(
            'conditions' => array('schedule_id' => $schedule_id, 'status' => 0)
        ));

        $cousrDetail = $this->TrainingCourseCreation->find('first', array(
            'fields' => 'name',
            'conditions' => array('course_id' => $ldetails['TrainingScheduleCreation']['course_id'], 'status' => 0)
        ));

        $training = $this->TrainingCreation->find('first', array('conditions' => array('TrainingCreation.schedule_id' => $schedule_id)));

        if (!empty($training['TrainingCreation']['training_id'])) {
            $value['training_id'] = $training['TrainingCreation']['training_id'];
            $value['description'] = $training['TrainingCreation']['description'];
            $value['remarks'] = $training['TrainingCreation']['remarks'];
        } else {
            $value['training_id'] = 0;
            $value['description'] = '';
            $value['remarks'] = '';
        }
        $starttime = $ldetails['TrainingScheduleCreation']['sch_start_time'];
        $endtime = $ldetails['TrainingScheduleCreation']['sch_end_time'];
        $startdate = $ldetails['TrainingScheduleCreation']['sch_start_date'];
        $value['date'] = date('d-m-Y', strtotime($startdate));
        $value['inst_name'] = $ldetails['TrainingScheduleCreation']['instructor_name'];
        $empdetails = $this->Common->getEmpDetails($value['inst_name']);
        $value['inst_full_name'] = $empdetails['MyProfile']['emp_full_name'] . " (" . $empdetails['MyProfile']['emp_id'] . ")";
        $dateOne = new DateTime("$startdate $starttime");
        $dateTwo = new DateTime("$startdate $endtime");
        $interval = $dateOne->diff($dateTwo);
        if (strlen($interval->h) == 1)
            $hour = '0' . $interval->h;
        else
            $hour = $interval->h;

        if (strlen($interval->i) == 1)
            $minute = '0' . $interval->i;
        else
            $minute = $interval->i;

        $value['time'] = $hour . ":" . $minute;
        echo json_encode($value);
        exit();
    }

    public function viewTrainingFeedback($feedback_id) {
        $this->layout = 'employee-new';
        $emp_code = $this->Auth->User('emp_code');
        $comp_code = $this->Auth->User('comp_code');
        $emp_details = $this->EmpDetail->getemployeeinfomation($emp_code);
        $emp_name = $this->MyProfile->find('first', array('fields' => array('*'), 'conditions' => array('emp_code' => $this->Auth->user('emp_code'))));

        $listvalues = $this->TrainingParameters->find('list', array('conditions' => array('TrainingParameters.comp_code' => $comp_code, "TrainingParameters.parameter_code like '%RAT%' "), 'fields' => array('TrainingParameters.parameter_code', 'TrainingParameters.name'), 'order' => array(
                'TrainingParameters.parameter_code' => 'ASC'
        )));

        $this->set('listvalues', $listvalues);

        $decissionlistvalues = $this->TrainingParameters->find('list', array('conditions' => array('TrainingParameters.comp_code' => $comp_code, "TrainingParameters.parameter_code like '%AGR%' "), 'fields' => array('TrainingParameters.parameter_code', 'TrainingParameters.name'), 'order' => array(
                'TrainingParameters.parameter_value' => 'desc'
        )));

        $this->set('decissionlistvalues', $decissionlistvalues);
        $TIMelistvalues = $this->TrainingParameters->find('list', array('conditions' => array('TrainingParameters.comp_code' => $comp_code, "TrainingParameters.parameter_code like '%TIM0%' "), 'fields' => array('TrainingParameters.parameter_code', 'TrainingParameters.name'), 'order' => array(
                'TrainingParameters.parameter_code' => 'asc'
        )));
        $this->set('TIMelistvalues', $TIMelistvalues);
        $feedback_id = base64_decode($feedback_id);

        $details = $this->TrainingFeedback->find('first', array(
            'fields' => array('*'),
            'joins' => array(array(
                    'table' => 'training_feedback_trainers',
                    'alias' => 'trainers',
                    'type' => 'inner',
                    'foreignKey' => false,
                    'conditions' => array('trainers.feedback_id = TrainingFeedback.feedback_id')
                )
            ),
            'conditions' => array('TrainingFeedback.feedback_id' => $feedback_id)
        ));
        $vals = $this->TrainingCreation->find('first', array(
            'conditions' => array('TrainingCreation.training_id' => $details['TrainingFeedback']['training_creation_id'])
        ));
        $this->set('vals', $vals);
        $this->set('details', $details);
        $this->set('emps', $emp_name);
    }

    public function test_mail() {

        $this->autorender = false;
        // $To = "anita.yadav@essindia.com";
        $To = "prashant.pandey@essindia.com";
        //$CC = "rahul.tripathi@essindia.com";
        $From = "anita.yadav@essindia.com";
        $sub = "test mail";
        $msg = "This is to inform you that Anita Yadav has submitted, his/ her KRA self score, kindly login to portal and initiate action.";
        $template = 'kra_fill_notification';
        $template = 'trainingemail_template';
        $data['appName'] = "Anita Yadav";
        $data['logo'] = 'logo_email.png';

        if (isset($To)) {
            $this->send_mail($From, $To, $CC, $sub, $msg, $template, $data);
        }
        die;
    }

    public function assignEmployeeMatrix() {
        $this->layout = 'employee-new';
        $emp_code = $this->Auth->User('emp_code');
        $emp_details = $this->EmpDetail->getemployeeinfomation($emp_code);
        $emp_name = $this->MyProfile->find('first', array('fields' => array('*'), 'conditions' => array('emp_code' => $this->Auth->user('emp_code'))));
        $userType = $this->TrainingCmp->getTrainingUserType();
        $employeelist = $this->Common->getEmployeesListByCompCode();
        $matrix_employee = $this->TrainingMatrixAssignEmployee->find('list', array('fields' => array('matrix_assign_emp_code'), 'conditions' => array('matrix_assign_comp_code' => $this->Auth->user('comp_code'))));
        if (!empty($matrix_employee)) {
            foreach ($matrix_employee as $key => $value) {
                unset($employeelist[$value]);
            }
        }

        $this->set("employeelist", $employeelist);
        $this->set("userType", $userType);
    }

    function savesassignemployeematrix() {
        $emp_code = $this->Auth->User('emp_code');
        $emp_details = $this->EmpDetail->getemployeeinfomation($emp_code);
        $emp_name = $this->MyProfile->find('first', array('fields' => array('*'), 'conditions' => array('emp_code' => $this->Auth->user('emp_code'))));

        if (!empty($this->data['Training']['employee_code'])) {
            foreach ($this->data['Training']['employee_code'] as $key => $val) {
                $this->TrainingMatrixAssignEmployee->create();
                $value['matrix_assign_emp_code'] = $val;
                $value['matrix_assign_comp_code'] = $this->Auth->User('comp_code');
                $value['identified_by'] = $emp_code;
                $this->TrainingMatrixAssignEmployee->save($value);
            }
        }
        $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert=""><a href="#" class="uk-alert-close uk-close"></a>Employee have assigned successfully.</div>');
        $this->redirect('/training/viewAssignedEmployeeMatrix/');
    }

    public function viewAssignedEmployeeMatrix() {

        $this->layout = 'employee-new';
        $emp_code = $this->Auth->User('emp_code');
        $emp_details = $this->EmpDetail->getemployeeinfomation($emp_code);
        $emp_name = $this->MyProfile->find('first', array('fields' => array('*'), 'conditions' => array('emp_code' => $this->Auth->user('emp_code'))));
        $userType = $this->TrainingCmp->getTrainingUserType();
        if ($userType == 'TI') {
            $this->paginate = array(
                'fields' => array('*'),
                'limit' => 40,
                'order' => 'TrainingMatrixAssignEmployee.id DESC',
            );
        } else {
            
        }

        $Lists = $this->paginate('TrainingMatrixAssignEmployee');
        $this->set("lists", $Lists);
    }

    function deleteMatrixEmployeee($id) {
        $id = base64_decode($id);
        $ld = $this->TrainingMatrixAssignEmployee->find('list', array(
            'conditions' => array(
                'id' => $id
            )
        ));

        foreach ($ld as $key => $value) {
            $this->TrainingMatrixAssignEmployee->delete($key);
        }
        $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                            <a href="#" class="uk-alert-close uk-close"></a>Employee deleted sucessfully.</div>');
        $this->redirect('/training/viewAssignedEmployeeMatrix/');
    }

    public function employeeHistoryReport() {
        $this->layout = 'employee-new';
        $emp_code = $this->Auth->User('emp_code');
        $emp_details = $this->EmpDetail->getemployeeinfomation($emp_code);
        $emp_name = $this->MyProfile->find('first', array('fields' => array('*'), 'conditions' => array('emp_code' => $this->Auth->user('emp_code'))));
        $userType = $this->TrainingCmp->getTrainingUserType();
        $currentdate = date('Y-m-d');
        $this->paginate = array(
            'fields' => array('*'),
            'limit' => 40,
            'order' => 'TrainingCreation.training_id DESC',
            'joins' => array(
                array(
                    'table' => 'training_schedule_creation',
                    'alias' => 'schedule',
                    'type' => 'inner',
                    'foreignKey' => false,
                    'conditions' => array('TrainingCreation.schedule_id = schedule.schedule_id')
                )
            ),
            'conditions' => array('TrainingCreation.status' => 5, 'schedule.sch_end_date <=' => $currentdate)
        );
        $listalltraining = $this->paginate('TrainingCreation');
        $courselist = $this->TrainingCourseCreation->find('list', array(
            'fields' => 'name',
            'order' => 'course_id DESC',
            'conditions' => array('status !=' => 1, 'comp_code' => $emp_details['MyProfile']['comp_code'])
        ));
        $this->set('list', $listalltraining);
        $this->set('courselists', $courselist);
    }

    public function generateEmpHistoryReportPdf($training_id = null) {
        $this->layout = 'employee-new';
        $auth = $this->Session->read('Auth');
        $orgID = $auth['MyProfile']['comp_code'];
        $empID = $auth['MyProfile']['emp_code'];

        if (!empty($training_id)) {
            $training_id = base64_decode($training_id);
        }

        $training = $this->TrainingCreation->find('first', array('conditions' => array('TrainingCreation.training_id' => $training_id)));

        App::import('Vendor', 'TCpdf', array('file' => 'mpdf60/mpdf.php'));
        $this->layout = 'pdf';
        $this->set('pdf', new mPDF('utf-8', array(350, 500)));
        $this->set('training', $training);
    }

    public function generateEmpMonthlyReportPdf() {
        $this->layout = 'employee-new';
        $auth = $this->Session->read('Auth');
        $orgID = $auth['MyProfile']['comp_code'];
        $empID = $auth['MyProfile']['emp_code'];
        if (isset($this->request->data['submit']) && $this->request->data['submit'] != '') {
            if ($this->request->data['sch_start_date'] == '' && $this->request->data['sch_end_date'] == '') {
                $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert="">
                            <a href="#" class="uk-alert-close uk-close"></a>Please Select Dates !!!!</div>');
                $this->redirect('employeeHistoryReport');
            }

            if ($this->request->data['sch_start_date'] != '' && $this->request->data['sch_end_date'] != '') {

                $meet_from_date = date('Y-m-d', strtotime($this->request->data['sch_start_date']));
                $meet_to_date = date('Y-m-d', strtotime($this->request->data['sch_end_date']));
                $ORconditions1['TrainingCreation.training_date between ? and ?'] = array($meet_from_date, $meet_to_date);
            }

            $conditions = array('TrainingCreation.status' => '5',
                'OR' => array($ORconditions1)
            );

            $Meeting_Request_Refnum = $this->TrainingCreation->find('all', array('conditions' => $conditions));

            $this->set(compact('Meeting_Request_Refnum', 'flag', 'meet_num', 'depart', 'meet_from_date', 'meet_to_date', 'req_from_date', 'req_to_date', 'req_receive'));
        }
        App::import('Vendor', 'TCpdf', array('file' => 'mpdf60/mpdf.php'));
        $this->layout = 'pdf';
        $this->set('pdf', new mPDF('utf-8', array(350, 500)));
        $this->set('training', $Meeting_Request_Refnum);
    }

    public function generateCourseWiseReportPdf() {
        $this->layout = 'employee-new';
        $auth = $this->Session->read('Auth');
        $orgID = $auth['MyProfile']['comp_code'];
        $empID = $auth['MyProfile']['emp_code'];
        if (isset($this->request->data['submit']) && $this->request->data['submit'] != '') {

            if ($this->request->data['min_start_date'] == '' && $this->request->data['min_end_date'] == '' && $this->request->data['course_id'] == '') {
                $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert="">
                            <a href="#" class="uk-alert-close uk-close"></a>Please Select Dates !!!!</div>');
                $this->redirect('employeeHistoryReport');
            }

            if ($this->request->data['min_start_date'] != '' && $this->request->data['min_end_date'] != '') {

                $meet_from_date = date('Y-m-d', strtotime($this->request->data['min_start_date']));
                $meet_to_date = date('Y-m-d', strtotime($this->request->data['min_end_date']));
                $ORconditions1['TrainingCreation.training_date between ? and ?'] = array($meet_from_date, $meet_to_date);
            }

            $conditions = array('TrainingCreation.status' => '5', 'TrainingCreation.course_id' => $this->request->data['course_id'],
                'OR' => array($ORconditions1)
            );

            $Meeting_Request_Refnum = $this->TrainingCreation->find('all', array('conditions' => $conditions));
        }

        App::import('Vendor', 'TCpdf', array('file' => 'mpdf60/mpdf.php'));
        $this->layout = 'pdf';
        $this->set('pdf', new mPDF('utf-8', array(350, 500)));
        $this->set('training', $Meeting_Request_Refnum);
    }

}

?>
