<?php

//NAME - HAKIM SINGH NIGAMchkTraineeEmployee
//Define Class - Trainingcmp

class TrainingCmpComponent extends object {

    var $uses = array('MyProfile', 'DtAppMapLvl', 'UserDetail', 'Codes', 'CourseMaster', 'MstTrainingRequests', 'TrainingFeedback', 'TrainingTrainerFeedback', 'TrainingAttendance', 'InstituteMasterDetail', 'Trainingcalender', 'SkillMatrix', 'QuestionnaireMaster', 'TrainingReminder', 'TrainingEmployee');
    var $components = array('Auth');

    function initialize(&$controller) {
        //load required for component models
        if ($this->uses !== false) {
            foreach ($this->uses as $modelClass) {
                $controller->loadModel($modelClass);
                $this->$modelClass = $controller->$modelClass;
            }
        }
    }

//    public function beforeRender(Controller $controller)
//    {
//    }
    public function shutdown(Controller $controller) {
        
    }

    public function startup(Controller $controller) {
        $this->controller = $controller;
    }

    function courselisting() {

        $courselisting = $this->CourseMaster->find('list', array(
            'fields' => array(
                'CourseMaster.id',
                'CourseMaster.course_name',
            ),
            'conditions' => array(
                'CourseMaster.course_status' => 'Y'
            ),
            'order' => array('CourseMaster.course_name ASC')
        ));
        $courselisting = array('' => 'Select') + $courselisting;

        return $courselisting;
    }

    function reportedEmpList($comp_code, $emp_code, $userType) {

        $dept_code = $_SESSION['Auth']['MyProfile']['dept_code'];
        $desg_code = $_SESSION['Auth']['MyProfile']['desg_code'];

        if ($userType == 'TI') {
            //TI=>Training Incharge
            $conditions = array('MyProfile.status' => 32);
            $emplisting = $this->MyProfile->find('list', array('fields' => array(
                    'MyProfile.emp_code',
                    'MyProfile.emp_firstname'
                ),
                'conditions' => $conditions,
                'order' => array('MyProfile.emp_firstname ASC')
            ));
            return $emplisting;
        } else {

            $emplisting = $this->MyProfile->find('list', array('fields' => array(
                    'MyProfile.emp_code',
                    'MyProfile.emp_firstname'
                ),
                'conditions' => array('MyProfile.manager_code' => $emp_code),
                'order' => array('MyProfile.emp_firstname ASC')
            ));

            return $emplisting;
        }
    }

    public function getEmpIds($empCode) {
        App::import("Model", "MyProfile");
        $model = new MyProfile();

        $emplist = $model->find('first', array(
            'fields' => array('MyProfile.emp_id'),
            'conditions' => array("emp_code = '$empCode'")
        ));

        return $emplist['MyProfile']['emp_id'];
    }

    function reportedEmpLists($comp_code, $emp_code, $userType) {
        $dept_code = $_SESSION['Auth']['MyProfile']['dept_code'];
        $desg_code = $_SESSION['Auth']['MyProfile']['desg_code'];
        $emp_codes = $_SESSION['Auth']['MyProfile']['emp_code'];

        if ($userType == 'TI') {
            //TI=>Training Incharge
            $conditions = array('MyProfile.status' => 32, 'MyProfile.comp_code' => $comp_code, 'MyProfile.emp_code !=' => $emp_codes);
            $emplisting = $this->MyProfile->find('list', array('fields' => array(
                    'MyProfile.emp_code',
                    'MyProfile.emp_full_name'
                ),
                'conditions' => $conditions,
                'order' => array('MyProfile.emp_firstname ASC')
            ));
            if (!empty($emplisting)) {
                foreach ($emplisting as $empkey => $empvalue) {
                    $emplisting[$empkey] = $empvalue . " (" . $this->getEmpIds($empkey) . ")";
                }
            }
            return $emplisting;
        } else {
            $emplisting = $this->MyProfile->find('list', array('fields' => array(
                    'MyProfile.emp_code',
                    'MyProfile.emp_full_name'
                ),
                'conditions' => array('MyProfile.status' => 32, 'MyProfile.manager_code' => $emp_code, 'MyProfile.comp_code' => $comp_code),
                'order' => array('MyProfile.emp_firstname ASC')
            ));
            if (!empty($emplisting)) {
                foreach ($emplisting as $empkey => $empvalue) {
                    $emplisting[$empkey] = $empvalue . " (" . $this->getEmpIds($empkey) . ")";
                }
            }
            return $emplisting;
        }
    }

    function getDesignationCode($emp_code) {

        $this->MyProfile->recursive = -1;


        $empData = $this->MyProfile->find('first', array(
            'fields' => array(
                'MyProfile.desg_code'
            ),
            'conditions' => array(
                'MyProfile.status' => 1,
                'MyProfile.emp_code' => $emp_code
            )
        ));


        $desg_code = $empData['MyProfile']['desg_code'];

        $desg = 'DesignationNotDefined';

        if (!empty($desg_code)) {

            $modelObj = ClassRegistry::init('Designations');

            $desgData = $modelObj->find('first', array(
                'fields' => array(
                    'Designations.desc'
                ),
                'conditions' => array(
                    'Designations.desg_code' => $desg_code
                )
            ));

            $desg = $desgData['Designations']['desc'];
        }

        return $desg_code;
    }

    function remainingAllEmps($comp_code, $selectedEmp, $selectType) {

        if ($selectType == 'REMAINS') {

            $conditions = array(//'MyProfile.status'=>1,
                'NOT' => array(
                    'MyProfile.emp_code' => $selectedEmp
            ));
        } else {
            $conditions = array(
                //'MyProfile.status'=>1,
                'MyProfile.emp_code' => $selectedEmp);
        }

        $emplisting = $this->MyProfile->find('list', array('fields' => array('MyProfile.emp_code',
                'MyProfile.emp_name'),
            'conditions' => $conditions,
            'order' => array('MyProfile.emp_firstname ASC')));
        return $emplisting;
    }

    function remainingEmpList($comp_code, $emp_code, $selectedEmp, $selectType) {

        if ($selectType == 'REMAINS') {

            $conditions = array(//'MyProfile.status'=>1,
                'MyProfile.manager_code' => $emp_code,
                'NOT' => array(
                    'MyProfile.emp_code' => $selectedEmp
            ));
        } else {
            $conditions = array(// 'MyProfile.status'=>1, 
                'MyProfile.manager_code' => $emp_code,
                'MyProfile.emp_code' => $selectedEmp);
        }


        $emplisting = $this->MyProfile->find('list', array(
            'fields' => array(
                'MyProfile.emp_code',
                'MyProfile.emp_firstname'
            ),
            'conditions' => $conditions,
            'order' => array('MyProfile.emp_firstname ASC')
        ));

        return $emplisting;
    }

    function remainingEmpList1($comp_code, $emp_code, $selectedEmp, $selectType) {

        $dept_code = $_SESSION['Auth']['MyProfile']['dept_code'];

        $desg_code = $_SESSION['Auth']['MyProfile']['desg_code'];

        if ($selectType == 'REMAINS') {

            $level = $this->DtAppMapLvl->find('first', array(
                'fileds' => array('DtAppMapLvl.wf_lvl'),
                'conditions' => array('DtAppMapLvl.wf_dept_id' => $dept_code, 'DtAppMapLvl.wf_desg_id' => $desg_code, 'DtAppMapLvl.wf_app_map_lvl_id' => 9)));
            $level = $level['DtAppMapLvl']['wf_lvl'];

            if ($level == 'Level1') {
                
            } elseif ($level == 'Level2') {

                $desg_code = $this->DtAppMapLvl->find('first', array
                    ('fields' => array('wf_desg_id'),
                    'conditions' => array('wf_lvl' => 'Level1', 'wf_app_map_lvl_id' => 9)));

                $emplisting = $this->MyProfile->find('list', array('fields' => array(
                        'MyProfile.emp_code',
                        'MyProfile.emp_firstname'
                    ),
                    'conditions' => array('MyProfile.desg_code' => $desg_code['DtAppMapLvl']['wf_desg_id'], 'NOT' => array('MyProfile.emp_code' => $selectedEmp)),
                    'order' => array('MyProfile.emp_firstname ASC')
                ));

                return $emplisting;
            } elseif ($level == 'Level3') {
                $desg_code = $this->DtAppMapLvl->find('first', array
                    ('fields' => array('wf_desg_id'), 'conditions' => array('wf_lvl' => 'Level2', 'wf_app_map_lvl_id' => 9)));
                $emplisting = $this->MyProfile->find('list', array('fields' => array(
                        'MyProfile.emp_code',
                        'MyProfile.emp_firstname'
                    ),
                    'conditions' => array('MyProfile.desg_code' => $desg_code['DtAppMapLvl']['wf_desg_id'], 'NOT' => array('MyProfile.emp_code' => $selectedEmp)),
                    'order' => array('MyProfile.emp_firstname ASC')
                ));
                return $emplisting;
            }
        } else {
            $level = $this->DtAppMapLvl->find('first', array(
                'fileds' => array('DtAppMapLvl.wf_lvl'),
                'conditions' => array('DtAppMapLvl.wf_dept_id' => $dept_code, 'DtAppMapLvl.wf_desg_id' => $desg_code, 'DtAppMapLvl.wf_app_map_lvl_id' => 9)));
            $level = $level['DtAppMapLvl']['wf_lvl'];
            if ($level == 'Level1') {
                
            } elseif ($level == 'Level2') {
                $desg_code = $this->DtAppMapLvl->find('first', array
                    ('fields' => array('wf_desg_id'),
                    'conditions' => array('wf_lvl' => 'Level1', 'wf_app_map_lvl_id' => 9)));
                $emplisting = $this->MyProfile->find('list', array('fields' => array(
                        'MyProfile.emp_code',
                        'MyProfile.emp_firstname'
                    ),
                    'conditions' => array('MyProfile.desg_code' => $desg_code['DtAppMapLvl']['wf_desg_id'], 'MyProfile.emp_code' => $selectedEmp),
                    'order' => array('MyProfile.emp_firstname ASC')
                ));
                return $emplisting;
            } elseif ($level == 'Level3') {
                $desg_code = $this->DtAppMapLvl->find('first', array
                    ('fields' => array('wf_desg_id'), 'conditions' => array('wf_lvl' => 'Level2', 'wf_app_map_lvl_id' => 9)));
                $emplisting = $this->MyProfile->find('list', array('fields' => array(
                        'MyProfile.emp_code',
                        'MyProfile.emp_firstname'
                    ),
                    'conditions' => array('MyProfile.desg_code' => $desg_code['DtAppMapLvl']['wf_desg_id'], 'MyProfile.emp_code' => $selectedEmp),
                    'order' => array('MyProfile.emp_firstname ASC')
                ));
                return $emplisting;
            }
        }
    }

    function identifiedBY($request_id) {


        $identify = $this->MstTrainingRequests->find('first', array('fields' => array('identified_by'),
            'conditions' => array('request_id' => $request_id), 'recursive' => -1));

        return $identify['MstTrainingRequests']['identified_by'];
    }

    function getEmailID($id) {

        $logininfo = $this->UserDetail->find('first', array('fields' => array('user_name', 'email'), 'conditions' => array('emp_code' => $id), 'recursive' => -1));

        return $logininfo;
    }

    function getCouseName($courseID) {

        $coursedata = $this->CourseMaster->find('first', array(
            'fields' => array(
                'CourseMaster.course_name'
            ),
            'conditions' => array(
                'CourseMaster.id' => $courseID
            )
        ));
        return $coursedata['CourseMaster']['course_name'];
    }

    function getNamePrefix($empcode, $pf) {

        $this->Personaldetails->recursive = -1;
        $managerData = $this->MyProfile->find('first', array(
            'fields' => array(
                'MyProfile.gender'
            ),
            'conditions' => array(
                'MyProfile.status' => 1,
                'MyProfile.emp_code' => $empcode
            )
        ));

        $sex = $managerData['MyProfile']['gender'];

        $type = '';
        if ($pf == 'RM') {

            if ($sex == 'F') {

                $type = 'Mam';
            } else {
                $type = 'Sir';
            }
        } else {

            if ($sex == 'F') {
                $type = 'Ms. ';
            } else {
                $type = 'Mr. ';
            }
        }

        return $type;
    }

    function getTrainingIncharge() {

        $this->Personaldetails->recursive = -1;

        $empData = $this->MyProfile->find('first', array(
            'fields' => array(
                'MyProfile.emp_code'
            ),
            'conditions' => array(
                'MyProfile.status' => 1,
                'MyProfile.desg_code' => 'PAR0000035'
            )
        ));

        $emp_code = $empData['MyProfile']['emp_code'];

        return $emp_code;
    }

    function regionLising() {
        $comp_code = $_SESSION['Auth']['MyProfile']['comp_code'];
        $region = $this->Code->find('list', array(
            'joins' => array(array(
                    'table' => 'mst_customer_loc',
                    'alias' => 'MstCustomerLoc',
                    'type' => 'RIGHT',
                    'conditions' => array('MstCustomerLoc.vc_region_code = Codes.vc_code', 'MstCustomerLoc.vc_comp_code = Codes.vc_comp_code')
                )
            ),
            'conditions' => array('MstCustomerLoc.vc_comp_code' => $comp_code),
            'fields' => array('Codes.vc_code', 'Codes.vc_code_desc'),
            'order' => 'Codes.vc_code_desc'
        ));
        $region = array('' => '-----Select Region----', 'Consolidated' => 'Consolidated') + $region;
        return $region;
    }

    function chkTraineeEmployee($emp_code, $training_id) {

        $empData = $this->TrainingEmployee->find('first', array(
            'fields' => array(
                'id'
            ),
            'conditions' => array(
                'TrainingEmployee.trainee_code' => $emp_code,
                'TrainingEmployee.training_creation_id' => $training_id
            )
        ));

        $id = $empData['TrainingEmployee']['id'];

        return $id;
    }

    function getAllTraineeEmployee($training_id) {

        $empData = $this->TrainingEmployee->find('list', array(
            'fields' => array(
                'trainee_code'
            ),
            'conditions' => array(
                'TrainingEmployee.training_creation_id' => $training_id
            )
        ));
        
        return $empData;
    }

    public function getTrainingUserType() {
        $emp_code = $_SESSION['Auth']['MyProfile']['emp_code'];
        $desg_code = $_SESSION['Auth']['MyProfile']['desg_code'];
        App::Import("Model", 'OptionAttribute');
        $model = new OptionAttribute();
        $pram_id = $model->find('first', array('fields' => array('OptionAttribute.id'), 'conditions' => array('OptionAttribute.name' => 'EXECUTIVE TRAINEE', 'options_id' => 4)));
        if (!empty($pram_id)) {
            if ($desg_code == $pram_id['OptionAttribute']['id'])
                $userType = 'TI';
            else
                $userType = '';
        }else {
            $userType = '';
        }
        return $userType;
    }

}
