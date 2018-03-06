<?php

App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');
App::uses('Folder', 'Utility');
App::uses('File', 'Utility');

class ComplianceAuditController extends AppController {

    public $name = 'ComplianceAudit';
    public $uses = array('MyProfile', 'Departments','CAThematicAreaMaster', 'CAWealthAssets','CAWealthdeclarationDependents','MailOfficeAttachFiles', 'CAInvestigation', 'CAComplianDoc', 'CASetChecklistTypeAuditMonitoring', 'CADescAuditChecklist', 'CAAllLabelAM', 'CAQuantitativeQualitative', 'CASetTypeAuditMonitoring', 'CADescValuePrinciple', 'CADescThematicArea', 'CASetType', 'CAWealthdeclaration', 'CADeclarationDate', 'CAEmployeeDefinition', 'CADependentDetails', 'Ministry');
    public $helpers = array('Js', 'Html', 'Form', 'Session', 'Userdetail', 'Common');
    public $components = array('Auth', 'Session', 'Email', 'Cookie', 'EmpDetail', 'Common', 'RequestHandler', 'Paginator');

    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow();
        $currentUser = $this->checkUser();
    }

    public function emp_definition() {
        // Configure::write('debug',2);
        $this->layout = 'employee-new';
        $auth = $this->Session->read('Auth');
        $empID = $auth['MyProfile']['id'];


        $EmployeeDefinition = $this->CAEmployeeDefinition->find('all', array(
            'conditions' => array('CAEmployeeDefinition.status' => '0', 'CAEmployeeDefinition.created_by' => $empID),
            'order' => 'CAEmployeeDefinition.id desc'
        ));

        $this->paginate = array(
            'conditions' => array('CADependentDetails.status' => '0', 'CAEmployeeDefinition.created_by' => $empID),
            'limit' => 10,
            'order' => array(
                'CADependentDetails.id' => 'asc'
            )
        );
        
        $wealthdeclarType = $this->CAWealthdeclaration->query("Select * from ca_wealthdeclaration where status=0 and emp_difini_id='".$EmployeeDefinition['0']['CAEmployeeDefinition']['id']."' order by declaration_type desc limit 0,1");
        $wealthdeclar_Type = $wealthdeclarType[0]['ca_wealthdeclaration']['declaration_type'];
        
        
        
        $curDate = date('Y');
        $EmpWealthDecla = $this->CAWealthdeclaration->find('all', array(
            'conditions' => array(
                'CAWealthdeclaration.status' => '0', 
                'CAWealthdeclaration.emp_difini_id' => $EmployeeDefinition['0']['CAEmployeeDefinition']['id'],
                'CAWealthdeclaration.declaration_type' => $wealthdeclar_Type,
                'EXTRACT(YEAR FROM declaration_date)' => $curDate
                ),
        ));
        
        $DeclarationStatus = $EmpWealthDecla[0]['CAWealthdeclaration']['declaration_status'];
        
        
        ///////////////////Check for wealthdeclaration ///////////////
        
        $decl_Date = $this->CADeclarationDate->find("all",array(
            'conditions' => array('CADeclarationDate.status' => '0'),
        ));
//        echo "<pre>";
//        print_r($decl_Date);die;
        
        $emp_decl_start_date = strtotime(date("Y-m-d", strtotime($decl_Date['0']['CADeclarationDate']['emp_from'])));
        $emp_decl_end_date = strtotime(date("Y-m-d", strtotime($decl_Date['0']['CADeclarationDate']['emp_to'])));
        $commi_decl_start_date = strtotime(date("Y-m-d", strtotime($decl_Date['0']['CADeclarationDate']['commission_from'])));
        $commi_decl_end_date = strtotime(date("Y-m-d", strtotime($decl_Date['0']['CADeclarationDate']['commission_to'])));
        $emp_days_from_joining = $decl_Date['0']['CADeclarationDate']['days_from_joining'];
        $emp_days_from_exit = $decl_Date['0']['CADeclarationDate']['days_from_exit'];
        
        $date_of_joining = date("Y-m-d", strtotime($EmployeeDefinition['0']['CAEmployeeDefinition']['date_of_joining']));
       if($EmployeeDefinition['0']['CAEmployeeDefinition']['date_of_exit'] != ''){
        $date_of_exit = date("Y-m-d", strtotime($EmployeeDefinition['0']['CAEmployeeDefinition']['date_of_exit']));
       }
        
        $FormAccessRight = '0';
        
       /*
        * Case : Initial Declaration
        */
        
            $dateOFjoining = date_create($date_of_joining);
            $curDate = date_create(date('Y-m-d'));
            $interval = date_diff($dateOFjoining, $curDate);
            $NumOfDaysJoining = $interval->format('%R%a');
            
            if($NumOfDaysJoining <= $emp_days_from_joining){
               $FormAccessRight = '1';
                
            }
            
            
         /*
          * Case : Benial Declaration
          */   
            $cur_Date = strtotime(date('Y-m-d'));
            if($emp_decl_start_date <= $cur_Date && $emp_decl_end_date >= $cur_Date) {
                 $FormAccessRight = '1';
            }
            
        /*
         * Case : Rejected by Commission
         */    
           if((($commi_decl_start_date <= $cur_Date) && ($commi_decl_end_date >= $cur_Date)) && ($DeclarationStatus == '1')) {
                 $FormAccessRight = '1';
            }
            
            
            
        /*
         * Case : Final Declaration 
         */ 
            if($EmployeeDefinition['0']['CAEmployeeDefinition']['date_of_exit'] != ''){
            $dateOFexit = date_create($date_of_exit);
            $curDate = date_create(date('Y-m-d'));
            $interval = date_diff($dateOFexit, $curDate);
            $NumOfDaysExit = $interval->format('%R%a');
            
            if($NumOfDaysExit <= $emp_days_from_exit){
               $FormAccessRight = '1';
            }  
          }
        ////////////////////////////////End///////////////////////////

          
          
          
        $this->set('DependentDetails', $this->paginate($this->CADependentDetails));
        $this->set(compact('FormAccessRight', 'EmployeeDefinition', 'empID'));
    }

    public function emp_all_wealth_declaration() {
        // Configure::write('debug',2);
        $this->layout = 'employee-new';
        $auth = $this->Session->read('Auth');
        $empID = $auth['MyProfile']['id'];


        $this->paginate = array(
            'conditions' => array('CAEmployeeDefinition.status' => '0'),
            'limit' => 10,
            'order' => array(
                'CAEmployeeDefinition.id' => 'asc'
            )
        );
        
        
        
        ///////////////////Check for wealthdeclaration ///////////////
        
        $decl_Date = $this->CADeclarationDate->find("all",array(
            'conditions' => array(
                'CADeclarationDate.status' => '0'),
        ));
        

        
        $commi_decl_start_date = strtotime(date("Y-m-d", strtotime($decl_Date['0']['CADeclarationDate']['commission_from'])));
        $commi_decl_end_date = strtotime(date("Y-m-d", strtotime($decl_Date['0']['CADeclarationDate']['commission_to'])));
//        $emp_days_from_joining = $decl_Date['0']['CADeclarationDate']['days_from_joining'];
//        $emp_days_from_exit = $decl_Date['0']['CADeclarationDate']['days_from_exit'];
//        
//        $date_of_joining = date("Y-m-d", strtotime($EmployeeDefinition['0']['CAEmployeeDefinition']['date_of_joining']));
//       if($EmployeeDefinition['0']['CAEmployeeDefinition']['date_of_exit'] != ''){
//        $date_of_exit = date("Y-m-d", strtotime($EmployeeDefinition['0']['CAEmployeeDefinition']['date_of_exit']));
//       }
        
        $FormAccessRight = '0';
        
       /*
        * Case : Initial Declaration
        */
        
//            $dateOFjoining = date_create($date_of_joining);
//            $curDate = date_create(date('Y-m-d'));
//            $interval = date_diff($dateOFjoining, $curDate);
//            $NumOfDaysJoining = $interval->format('%R%a');
//            
//            if($NumOfDaysJoining <= $emp_days_from_joining){
//               $FormAccessRight = '1';
//                
//            }
            
            
         /*
          * Case : Benial Declaration
          */   
            $cur_Date = strtotime(date('Y-m-d'));
            if(($commi_decl_start_date <= $cur_Date) && ($commi_decl_end_date >= $cur_Date)){
                 $FormAccessRight = '1';
            }
           
            
        /*
         * Case : Final Declaration 
         */ 
//            if($EmployeeDefinition['0']['CAEmployeeDefinition']['date_of_exit'] != ''){
//            $dateOFexit = date_create($date_of_exit);
//            $curDate = date_create(date('Y-m-d'));
//            $interval = date_diff($dateOFexit, $curDate);
//            $NumOfDaysExit = $interval->format('%R%a');
//            
//            if($NumOfDaysExit <= $emp_days_from_exit){
//               $FormAccessRight = '1';
//            }  
//          }
        ////////////////////////////////End///////////////////////////

          
          
          
        $this->set('EmployeeDefinition', $this->paginate($this->CAEmployeeDefinition));
        $this->set(compact('FormAccessRight','empID'));
    }

    public function compliant_investigation() {
        // Configure::write('debug',2);
        $this->layout = 'employee-new';
        $auth = $this->Session->read('Auth');
        $empID = $auth['MyProfile']['id'];

        $this->paginate = array(
            'conditions' => array('CAInvestigation.status' => '0', 'CAInvestigation.created_by' => $empID),
            'limit' => 10,
            'order' => array(
                'CAInvestigation.id' => 'desc'
            )
        );

//        echo "<pre>";
//        print_r($EmployeeDefinition);die;
        $this->set('InvestCompliants', $this->paginate($this->CAInvestigation));
    }

    
    public function compliant_status($complID=null , $complStatus=null) {
        // Configure::write('debug',2);
        
        if($complStatus != ''){
            
            $comStatus = $this->CAInvestigation->updateAll(array('CAInvestigation.compliant_status' => $complStatus), array('CAInvestigation.id' => $complID));
   
            $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                <a href="#" class="uk-alert-close uk-close"></a>Status Changed Successfully!</div>');
           exit;
        }
    }
    
    public function compliant_received() {
        // Configure::write('debug',2);
        $this->layout = 'employee-new';
        $auth = $this->Session->read('Auth');
        $empID = $auth['MyProfile']['id'];
        $manager_code = $auth['MyProfile']['emp_code'];
        
        $sendToCEO = $this->CAInvestigation->updateAll(array('CAInvestigation.current_status' => "0",'CAInvestigation.notify' => "0", 'CAInvestigation.ceo_id' => '1'), array('CAInvestigation.current_status' => "0",'CAInvestigation.notify' => "1"));
        $this->paginate = array(
            'conditions' => array('CAInvestigation.status' => '0', 'CAInvestigation.ceo_id' => '1'),
            'limit' => 10,
            'order' => array(
                'CAInvestigation.id' => 'desc'
            )
        );

//        echo "<pre>";
//        print_r($EmployeeDefinition);die;
        $this->set('InvestCompliants', $this->paginate($this->CAInvestigation));
    }
    
    public function compliant_received_compliance_audit() {
        // Configure::write('debug',2);
        $this->layout = 'employee-new';
        $auth = $this->Session->read('Auth');
        $empID = $auth['MyProfile']['id'];
        
        $sendToCEO = $this->CAInvestigation->updateAll(array('CAInvestigation.current_status' => "0",'CAInvestigation.notify' => "0"), array('CAInvestigation.current_status' => "1",'CAInvestigation.notify' => "2"));
        $this->paginate = array(
            'conditions' => array('CAInvestigation.status' => '0','CAInvestigation.ceo_action'=>'2', 'CAInvestigation.forward_to' => $empID),
            'limit' => 10,
            'order' => array(
                'CAInvestigation.id' => 'asc'
            )
        );

//        echo "<pre>";
//        print_r($auth);die;
        $this->set('InvestCompliants', $this->paginate($this->CAInvestigation));
    }

    public function complain_action_field($actionID = null) {
        $this->set('actionID', $actionID);
    }

    public function compliant_response_send($complID = null) {
        // Configure::write('debug',2);
        $this->layout = 'employee-new';
        $auth = $this->Session->read('Auth');
        $empID = $auth['MyProfile']['id'];

        $complID = base64_decode($complID);

        if (isset($this->request->data['submit']) && $this->request->data['submit'] != '') {
//            echo "<pre>";
//            print_r($this->request->data);die;
            $sendToCEO = $this->CAInvestigation->updateAll(array('CAInvestigation.current_status' => "1",'CAInvestigation.notify' => "2"), array('CAInvestigation.id' => $this->request->data['compliant_id']));

            if ($this->request->data['action_type'] == '1') {
                //Type 1 = Forward to department
                //for department , we have to change the desg_code for HOD , there should be single user for HOD in single Department.
                //And we have to change the comp_code for PSC. 
                $DeptUser = $this->MyProfile->find('first', array(
                    'conditions' => array('MyProfile.dept_code' => $this->request->data['dept_id'],'MyProfile.desg_code' => 'PAR0000034','MyProfile.comp_code' =>'01')
                ));
                $data['CAInvestigation']['forward_to'] = $DeptUser['MyProfile']['id'];
            } elseif ($this->request->data['action_type'] == '2') {
                //Type 2 = Forward to compliance
                $data['CAInvestigation']['forward_to'] = $this->request->data['compliance_dierector'];
            } elseif ($this->request->data['action_type'] == '3') {
                //Type 3 = Direct response
                $complDetails = $this->CAInvestigation->find('first', array(
                    'conditions' => array('CAInvestigation.id' => $this->request->data['compliant_id'])
                ));
                
                $data['CAInvestigation']['ceo_response'] = $this->request->data['direct_response'];
                $data['CAInvestigation']['forward_to'] = $complDetails['CAInvestigation']['created_by'];
            }

            $data['CAInvestigation']['id'] = $this->request->data['compliant_id'];
            $data['CAInvestigation']['current_status'] = '1';
            $data['CAInvestigation']['ceo_action'] = $this->request->data['action_type'];
            $data['CAInvestigation']['date_of_response'] = date("Y-m-d", strtotime($this->request->data['response_date']));
            $data['CAInvestigation']['ceo_remark'] = $this->request->data['ceo_remark'];
           
            $success = $this->CAInvestigation->save($data);
            if ($success) {
                $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                    <a href="#" class="uk-alert-close uk-close"></a>Response Send Successfully !</div>');
            } else {
                $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert="">
                    <a href="#" class="uk-alert-close uk-close"></a>Sorry, Not Send !</div>');
            }
            $this->redirect('compliant_received');
        }

        $this->set('complID', $complID);
    }
    
    public function ca_compliant_response_send($complID = null) {
        // Configure::write('debug',2);
        $this->layout = 'employee-new';
        $auth = $this->Session->read('Auth');
        $empID = $auth['MyProfile']['id'];

        $complID = base64_decode($complID);

        if (isset($this->request->data['submit']) && $this->request->data['submit'] != '') {


            $data['CAInvestigation']['id'] = $this->request->data['compliant_id'];
            $data['CAInvestigation']['current_status'] = '2';
            $data['CAInvestigation']['significance_of_compliat'] = $this->request->data['signi_compl'];
            $data['CAInvestigation']['symantec_problem'] = $this->request->data['doc']['syman_prob'];
            $data['CAInvestigation']['scope_problem'] = $this->request->data['scope_prob'];
            $data['CAInvestigation']['resource_requirement'] = $this->request->data['resource_req'];
            $data['CAInvestigation']['authrization_required'] = $this->request->data['doc']['authorization'];
            $data['CAInvestigation']['nature_outcome'] = $this->request->data['nature_outcome'];
            $data['CAInvestigation']['compliance_description'] = $this->request->data['description'];
           
            $success = $this->CAInvestigation->save($data);
            if ($success) {
                $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                    <a href="#" class="uk-alert-close uk-close"></a>Response Send Successfully !</div>');
            } else {
                $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert="">
                    <a href="#" class="uk-alert-close uk-close"></a>Sorry, Not Send !</div>');
            }
            $this->redirect('compliant_received_compliance_audit');
        }

        $this->set('complID', $complID);
    }

    public function show_details($compl_id = null,$response = null) {
        // Configure::write('debug',2);
        // $this->layout = 'employee-new';
        $auth = $this->Session->read('Auth');
        $empID = $auth['MyProfile']['id'];

        $showDet = $this->CAInvestigation->find('all', array(
            'conditions' => array('CAInvestigation.status' => '0', 'CAInvestigation.id' => $compl_id)
        ));

        $this->set(compact('showDet','response'));
    }

    public function qual_quan_show_details($id = null, $TypeId = null) {
        // Configure::write('debug',2);
        //$this->layout = 'employee-new';
        $auth = $this->Session->read('Auth');
        $empID = $auth['MyProfile']['id'];



        $QuanQual = $this->CAQuantitativeQualitative->find('all', array(
            'conditions' => array('CAQuantitativeQualitative.status' => '0', 'CAQuantitativeQualitative.id' => $id)
        ));

        foreach ($QuanQual as $rec)
            ;
        $perf_indic = $this->CADescThematicArea->find('first', array(
            'fields' => array('performance_indicator'),
            'conditions' => array('CADescThematicArea.status' => '0', 'CADescThematicArea.id' => $rec['CAQuantitativeQualitative']['performance_indicator_quant'])
        ));

        $this->set(compact('QuanQual', 'TypeId', 'perf_indic'));
    }

    public function set_value_principle($Typeid = NULL, $del = NULL) {
        //Configure::write('debug',2);
        $this->layout = 'employee-new';
        $auth = $this->Session->read('Auth');
        $empID = $auth['MyProfile']['id'];

        if ($Typeid != null && $del == 'del') {
            $Del_ = $this->CASetType->updateAll(array('CASetType.status' => "1"), array('CASetType.id' => $Typeid));

            if ($Del_) {
                $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert="">
                    <a href="#" class="uk-alert-close uk-close"></a>Record Deleted !</div>');
            } else {
                $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert="">
                    <a href="#" class="uk-alert-close uk-close"></a>Sorry, Not Deleted !</div>');
            }
            $this->redirect('set_value_principle');
        }
        if (isset($this->request->data['submit']) && $this->request->data['submit'] != '') {

            if ($this->request->data['vpTypeid'] != "") {
                $data['CASetType']['id'] = $this->request->data['vpTypeid'];
            }
            $data['CASetType']['set_name'] = $this->request->data['vpType'];
            $data['CASetType']['set_type'] = '1'; // For value and principle
            $data['CASetType']['created_by'] = $empID;
            $success = $this->CASetType->save($data);
            if ($success) {
                $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                    <a href="#" class="uk-alert-close uk-close"></a>Saved Successfully !</div>');
            } else {
                $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert="">
                    <a href="#" class="uk-alert-close uk-close"></a>Sorry, Not Save !</div>');
            }
            $this->redirect('set_value_principle');
        }


        $this->paginate = array(
            'conditions' => array('CASetType.status' => '0', 'CASetType.set_type' => '1'),
            'limit' => 10,
            'order' => array(
                'CASetType.id' => 'desc'
            )
        );
        if ($Typeid != "") {
            $EditData = $this->CASetType->find('all', array(
                'conditions' => array('CASetType.status' => '0', 'CASetType.id' => $Typeid)
            ));
            $create = "enable";
        }
        $this->set('setType', $this->paginate($this->CASetType));
        $this->set(compact('EditData', 'create', 'Typeid', 'empID'));
    }

    public function audit_form_type($audit_param_type = NULL,$form_for=NULL) {
        //Configure::write('debug',2);
        //$this->layout = 'employee-new';
        $auth = $this->Session->read('Auth');
        $empID = $auth['MyProfile']['id'];


        $AuditFormType = $this->CAAllLabelAM->find('all', array(
            'conditions' => array('CAAllLabelAM.status' => '0', 'CAAllLabelAM.id' => $audit_param_type)
        ));

        $this->set(compact('AuditFormType', 'audit_param_type','form_for'));
    }

    public function audit_checklist_form_type($audit_param_type = NULL) {
        //Configure::write('debug',2);
        //$this->layout = 'employee-new';
        $auth = $this->Session->read('Auth');
        $empID = $auth['MyProfile']['id'];



        $AuditFormType = $this->CADescAuditChecklist->find('all', array(
            'conditions' => array('CADescAuditChecklist.checklist_type' => $audit_param_type)
        ));

        $this->set(compact('AuditFormType', 'audit_param_type'));
    }

    public function form_type($Thematic = NULL, $Typeid = NULL) {
        //Configure::write('debug',2);
        //$this->layout = 'employee-new';
        $auth = $this->Session->read('Auth');
        $empID = $auth['MyProfile']['id'];


        $perf_indic = $this->CADescThematicArea->find('list', array(
            'fields' => array('id', 'performance_indicator'),
            'conditions' => array('CADescThematicArea.status' => '0', 'CADescThematicArea.set_type_id' => $Thematic)
        ));

        $this->set(compact('Typeid', 'perf_indic'));
    }

    public function fields_measur($val = null) {
        $FormData = $this->CADescThematicArea->find('first', array(
            'conditions' => array('CADescThematicArea.status' => '0', 'CADescThematicArea.id' => $val)
        ));

        $default = $FormData['CADescThematicArea']['measurment_type'];
        $measurType = array("1" => "Number", "2" => "Percent(%)", "3" => "Ratio", "4" => "Boolean(Yes/No)", "5" => "Character");
        $this->set(compact('default', 'measurType'));
    }

    public function set_audit_param_type($Typeid = NULL, $del = NULL) {
        //Configure::write('debug',2);
        $this->layout = 'employee-new';
        $auth = $this->Session->read('Auth');
        $empID = $auth['MyProfile']['id'];

        if ($Typeid != null && $del != null) {
            if ($del == '1') {
                $sts = "1";
            } else {
                $sts = "0";
            }

            $Del_ = $this->CASetTypeAuditMonitoring->updateAll(array('CASetTypeAuditMonitoring.status' => $sts), array('CASetTypeAuditMonitoring.id' => $Typeid));
            if ($del == '0') {
                $stus = "Activeted";
            } else {
                $stus = "Inactiveted";
            }
            if ($Del_) {
                $this->Session->setFlash('<div class="uk-alert uk-alert-info" data-uk-alert="">
                    <a href="#" class="uk-alert-close uk-close"></a>Record ' . $stus . ' !</div>');
            } else {
                $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert="">
                    <a href="#" class="uk-alert-close uk-close"></a>Sorry, Record is still active !</div>');
            }
            $this->redirect('set_audit_param_type');
        }
        if (isset($this->request->data['submit']) && $this->request->data['submit'] != '') {

            if ($this->request->data['vpTypeID'] != '') {
                $data['CASetTypeAuditMonitoring']['id'] = $this->request->data['vpTypeID'];
            }
            $data['CASetTypeAuditMonitoring']['set_name'] = $this->request->data['vpType'];
            $data['CASetTypeAuditMonitoring']['set_type'] = '1';
            $data['CASetTypeAuditMonitoring']['status_for_monitoring'] = $this->request->data['for_monitoring'];
            $data['CASetTypeAuditMonitoring']['created_by'] = $empID;
            $success = $this->CASetTypeAuditMonitoring->save($data);
            if ($success) {
                $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                    <a href="#" class="uk-alert-close uk-close"></a>Saved Successfully !</div>');
            } else {
                $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert="">
                    <a href="#" class="uk-alert-close uk-close"></a>Sorry, Not Save !</div>');
            }
            $this->redirect('set_audit_param_type');
        }


        $this->paginate = array(
            'conditions' => array('CASetTypeAuditMonitoring.set_type' => '1'),
            'limit' => 10,
            'order' => array(
                'CASetTypeAuditMonitoring.id' => 'desc'
            )
        );
        if ($Typeid != "") {
            $EditData = $this->CASetTypeAuditMonitoring->find('all', array(
                'conditions' => array('CASetTypeAuditMonitoring.status' => '0', 'CASetTypeAuditMonitoring.id' => $Typeid)
            ));
            $create = "enable";
        }
        $this->set('setType', $this->paginate($this->CASetTypeAuditMonitoring));
        $this->set(compact('EditData', 'create', 'Typeid', 'empID'));
    }

    public function set_monitor_param_type($Typeid = NULL, $del = NULL) {
        //Configure::write('debug',2);
        $this->layout = 'employee-new';
        $auth = $this->Session->read('Auth');
        $empID = $auth['MyProfile']['id'];

        if ($Typeid != null && $del != null) {
            if ($del == '1') {
                $sts = "1";
            } else {
                $sts = "0";
            }

            $Del_ = $this->CASetTypeAuditMonitoring->updateAll(array('CASetTypeAuditMonitoring.status' => $sts), array('CASetTypeAuditMonitoring.id' => $Typeid));
            if ($del == '0') {
                $stus = "Activeted";
            } else {
                $stus = "Inactiveted";
            }
            if ($Del_) {
                $this->Session->setFlash('<div class="uk-alert uk-alert-info" data-uk-alert="">
                    <a href="#" class="uk-alert-close uk-close"></a>Record ' . $stus . ' !</div>');
            } else {
                $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert="">
                    <a href="#" class="uk-alert-close uk-close"></a>Sorry, Record is still active !</div>');
            }
            $this->redirect('set_monitor_param_type');
        }
        if (isset($this->request->data['submit']) && $this->request->data['submit'] != '') {

            if ($this->request->data['vpTypeID'] != '') {
                $data['CASetTypeAuditMonitoring']['id'] = $this->request->data['vpTypeID'];
            }
            $data['CASetTypeAuditMonitoring']['set_name'] = $this->request->data['vpType'];
            $data['CASetTypeAuditMonitoring']['set_type'] = '2';
            $data['CASetTypeAuditMonitoring']['status_for_monitoring'] = '1';
            $data['CASetTypeAuditMonitoring']['created_by'] = $empID;
            $success = $this->CASetTypeAuditMonitoring->save($data);
            if ($success) {
                $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                    <a href="#" class="uk-alert-close uk-close"></a>Saved Successfully !</div>');
            } else {
                $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert="">
                    <a href="#" class="uk-alert-close uk-close"></a>Sorry, Not Save !</div>');
            }
            $this->redirect('set_monitor_param_type');
        }


        $this->paginate = array(
            'conditions' => array('CASetTypeAuditMonitoring.status_for_monitoring' => '1'),
            'limit' => 10,
            'order' => array(
                'CASetTypeAuditMonitoring.id' => 'desc'
            )
        );
        if ($Typeid != "") {
            $EditData = $this->CASetTypeAuditMonitoring->find('all', array(
                'conditions' => array('CASetTypeAuditMonitoring.status' => '0', 'CASetTypeAuditMonitoring.id' => $Typeid)
            ));
            $create = "enable";
        }
        $this->set('setType', $this->paginate($this->CASetTypeAuditMonitoring));
        $this->set(compact('EditData', 'create', 'Typeid', 'empID'));
    }

    public function set_audit_checklist_type($Typeid = NULL, $del = NULL) {
        //Configure::write('debug',2);
        $this->layout = 'employee-new';
        $auth = $this->Session->read('Auth');
        $empID = $auth['MyProfile']['id'];

        if ($Typeid != null && $del != null) {
            $Del_ = $this->CASetChecklistTypeAuditMonitoring->updateAll(array('CASetChecklistTypeAuditMonitoring.status' => $del), array('CASetChecklistTypeAuditMonitoring.id' => $Typeid));

            if ($del == '0') {
                $sts = "Activeted";
            } else {
                $sts = "Inactiveted";
            }
            if ($Del_) {
                $this->Session->setFlash('<div class="uk-alert uk-alert-info" data-uk-alert="">
                    <a href="#" class="uk-alert-close uk-close"></a>Record ' . $sts . ' !</div>');
            } else {
                $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert="">
                    <a href="#" class="uk-alert-close uk-close"></a>Sorry, Not Deleted !</div>');
            }
            $this->redirect('set_audit_checklist_type');
        }
        if (isset($this->request->data['submit']) && $this->request->data['submit'] != '') {

            if ($this->request->data['vpTypeID'] != '') {
                $data['CASetChecklistTypeAuditMonitoring']['id'] = $this->request->data['vpTypeID'];
            }
            $data['CASetChecklistTypeAuditMonitoring']['checklist_name'] = $this->request->data['vpType'];
            $data['CASetChecklistTypeAuditMonitoring']['set_type'] = '1';
            $data['CASetChecklistTypeAuditMonitoring']['status_for_monitoring'] = $this->request->data['for_monitoring'];
            $data['CASetChecklistTypeAuditMonitoring']['created_by'] = $empID;
            $success = $this->CASetChecklistTypeAuditMonitoring->save($data);
            if ($success) {
                $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                    <a href="#" class="uk-alert-close uk-close"></a>Saved Successfully !</div>');
            } else {
                $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert="">
                    <a href="#" class="uk-alert-close uk-close"></a>Sorry, Not Save !</div>');
            }
            $this->redirect('set_audit_checklist_type');
        }


        $this->paginate = array(
            'conditions' => array('CASetChecklistTypeAuditMonitoring.set_type' => '1'),
            'limit' => 10,
            'order' => array(
                'CASetChecklistTypeAuditMonitoring.id' => 'desc'
            )
        );
        if ($Typeid != "") {
            $EditData = $this->CASetChecklistTypeAuditMonitoring->find('all', array(
                'conditions' => array('CASetChecklistTypeAuditMonitoring.status' => '0', 'CASetChecklistTypeAuditMonitoring.id' => $Typeid)
            ));
            $create = "enable";
        }
        $this->set('setType', $this->paginate($this->CASetChecklistTypeAuditMonitoring));
        $this->set(compact('EditData', 'create', 'Typeid', 'empID'));
    }

    public function set_monitor_checklist_type($Typeid = NULL, $del = NULL) {
        //Configure::write('debug',2);
        $this->layout = 'employee-new';
        $auth = $this->Session->read('Auth');
        $empID = $auth['MyProfile']['id'];

        if ($Typeid != null && $del != null) {
            $Del_ = $this->CASetChecklistTypeAuditMonitoring->updateAll(array('CASetChecklistTypeAuditMonitoring.status' => $del), array('CASetChecklistTypeAuditMonitoring.id' => $Typeid));

            if ($del == '0') {
                $sts = "Activeted";
            } else {
                $sts = "Inactiveted";
            }
            if ($Del_) {
                $this->Session->setFlash('<div class="uk-alert uk-alert-info" data-uk-alert="">
                    <a href="#" class="uk-alert-close uk-close"></a>Record ' . $sts . ' !</div>');
            } else {
                $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert="">
                    <a href="#" class="uk-alert-close uk-close"></a>Sorry, Not Deleted !</div>');
            }
            $this->redirect('set_monitor_checklist_type');
        }
        if (isset($this->request->data['submit']) && $this->request->data['submit'] != '') {

            if ($this->request->data['vpTypeID'] != '') {
                $data['CASetChecklistTypeAuditMonitoring']['id'] = $this->request->data['vpTypeID'];
            }
            $data['CASetChecklistTypeAuditMonitoring']['checklist_name'] = $this->request->data['vpType'];
            $data['CASetChecklistTypeAuditMonitoring']['set_type'] = '2';
            $data['CASetChecklistTypeAuditMonitoring']['status_for_monitoring'] = '1';
            $data['CASetChecklistTypeAuditMonitoring']['created_by'] = $empID;
            $success = $this->CASetChecklistTypeAuditMonitoring->save($data);
            if ($success) {
                $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                    <a href="#" class="uk-alert-close uk-close"></a>Saved Successfully !</div>');
            } else {
                $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert="">
                    <a href="#" class="uk-alert-close uk-close"></a>Sorry, Not Save !</div>');
            }
            $this->redirect('set_monitor_checklist_type');
        }


        $this->paginate = array(
            'conditions' => array('CASetChecklistTypeAuditMonitoring.status_for_monitoring' => '1'),
            'limit' => 10,
            'order' => array(
                'CASetChecklistTypeAuditMonitoring.id' => 'desc'
            )
        );
        if ($Typeid != "") {
            $EditData = $this->CASetChecklistTypeAuditMonitoring->find('all', array(
                'conditions' => array('CASetChecklistTypeAuditMonitoring.status' => '0', 'CASetChecklistTypeAuditMonitoring.id' => $Typeid)
            ));
            $create = "enable";
        }
        $this->set('setType', $this->paginate($this->CASetChecklistTypeAuditMonitoring));
        $this->set(compact('EditData', 'create', 'Typeid', 'empID'));
    }

    public function desc_lable_audit($Typeid = NULL, $del = NULL) {
        //Configure::write('debug', 2);
        $this->layout = 'employee-new';
        $auth = $this->Session->read('Auth');
        $empID = $auth['MyProfile']['id'];


        if (isset($this->request->data['submit']) && $this->request->data['submit'] != '') {


//            echo "<pre>";
//            print_r($this->request->data);
//            die;

            App::import('Model', 'ConnectionManager');
            $con = new ConnectionManager;
            $cn = $con->getDataSource('default');
            /* User table schema */
            $tableName = str_replace(" ", "", strtolower($this->request->data['desc']));
            $NewFile = 'CAAuditLabel' . $tableName;

            $VPtype = $this->CAAllLabelAM->find('all', array(
                'conditions' => array('CAAllLabelAM.status' => '0', 'CAAllLabelAM.model_name' => $NewFile)
            ));

            if (!empty($VPtype)) {
                $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert="">
                    <a href="#" class="uk-alert-close uk-close"></a>Sorry, this description is already save !</div>');

                $this->redirect('desc_lable_audit');
            }

            $column = '';
            for ($i = 0; $i < $this->request->data['ComplianceAudit']['rowCount']; $i++) {
                $column .= str_replace(" ", "_", strtolower($this->request->data['ComplianceAudit']['label'][$i]))." VARCHAR( 100 ) NOT NULL ,";
            }
            $sql = "CREATE TABLE IF NOT EXISTS ca_audit_label_" . $tableName . "(
								id INT( 11 ) UNSIGNED NOT NULL AUTO_INCREMENT ,
                                                                ministry_id INT( 11 ) UNSIGNED NOT NULL,
                                                                audit_parameter INT( 11 ) UNSIGNED NOT NULL,
                                                                entry_date date NOT NULL,
                                                                " . $column . " created TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP(),
								PRIMARY KEY ( `id` ) ,
								INDEX ( `id` )
								)";
            if ($cn->query($sql)) {


                define('WWW_MODEL', ROOT . DS . APP_DIR . DS . 'Model' . DS);
                echo $folderPath = WWW_MODEL;
                if (is_dir($folderPath)) {
                    $file = fopen($folderPath . $NewFile . ".php", "w");
                    $useDbConfig = "useDbConfig";
                    $name = "name";
                    $useTable = "useTable";
                    $content = "<?php
                                    App::uses('AppModel', 'Model');
                                    class CAAuditLabel" . $tableName . " extends AppModel {
                                        public  $" . $useDbConfig . " = 'default';
                                        public  $" . $name . " = 'CAAuditLabel" . $tableName . "'; 
                                        public  $" . $useTable . " = 'ca_audit_label_" . $tableName . "';


                                    }
                                    ?>";
                    fwrite($file, $content);
                    fclose($file);
                    $file_path = $folderPath . '\ ' . $NewFile . ".php";
                    chmod($file_path, 0777);
                }

                $label = implode($this->request->data['ComplianceAudit']['label'], ",");

                $data['CAAllLabelAM']['set_type_am_id'] = $this->request->data['vp_type'];
                $data['CAAllLabelAM']['description'] = $this->request->data['desc'];
                $data['CAAllLabelAM']['model_name'] = $NewFile;
                $data['CAAllLabelAM']['table_name'] = 'ca_audit_label_' . $tableName;
                $data['CAAllLabelAM']['label'] = $label;
                $data['CAAllLabelAM']['created_by'] = $empID;

                $success = $this->CAAllLabelAM->save($data);
                if ($success) {

                    define('WWW_CACHE', ROOT . DS . APP_DIR . DS . 'tmp' . DS . 'cache' . DS . 'models' . DS);
                    echo $folderPath = WWW_CACHE;

                    $files = glob(WWW_CACHE . '*'); //get all file names
                    foreach ($files as $file) {
                        if (is_file($file))
                            unlink($file); //delete file
                    }

                    $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                    <a href="#" class="uk-alert-close uk-close"></a>Saved Successfully !</div>');
                } else {
                    $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert="">
                    <a href="#" class="uk-alert-close uk-close"></a>Sorry, Not Save !</div>');
                }
                $this->redirect('desc_lable_audit');
            }
        }





        $this->paginate = array(
            'conditions' => array('CAAllLabelAM.status' => '0', 'CASetTypeAuditMonitoring.status' => '0', 'CASetTypeAuditMonitoring.set_type' => '1'),
            'limit' => 10,
            'order' => array(
                'CAAllLabelAM.id' => 'desc'
            )
        );
        if ($Typeid != "") {
            $EditData = $this->CADescValuePrinciple->find('all', array(
                'conditions' => array('CADescValuePrinciple.status' => '0', 'CADescValuePrinciple.id' => $Typeid)
            ));
            $create = "enable";
        }
        $VPtype = $this->CASetTypeAuditMonitoring->find('list', array(
            'fields' => array('id', 'set_name'),
            'conditions' => array('CASetTypeAuditMonitoring.status' => '0', 'CASetTypeAuditMonitoring.set_type' => '1')
        ));
        $belongsTo = array("1" => "Legislation", "2" => "Policy", "3" => "Regulations", "4" => "Guidelines");
        $this->set('CAAllLabelAM', $this->paginate($this->CAAllLabelAM));
        $this->set(compact('EditData', 'create', 'Typeid', 'empID', 'belongsTo', 'VPtype'));
    }

    public function desc_lable_monitor($Typeid = NULL, $del = NULL) {
        //Configure::write('debug', 2);
        $this->layout = 'employee-new';
        $auth = $this->Session->read('Auth');
        $empID = $auth['MyProfile']['id'];


        if (isset($this->request->data['submit']) && $this->request->data['submit'] != '') {


//            echo "<pre>";
//            print_r($this->request->data);
//            die;

            App::import('Model', 'ConnectionManager');
            $con = new ConnectionManager;
            $cn = $con->getDataSource('default');
            /* User table schema */
            $tableName = str_replace(" ", "", strtolower($this->request->data['desc']));
            $NewFile = 'CAAuditLabel' . $tableName;

            $VPtype = $this->CAAllLabelAM->find('all', array(
                'conditions' => array('CAAllLabelAM.status' => '0', 'CAAllLabelAM.model_name' => $NewFile)
            ));

            if (!empty($VPtype)) {
                $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert="">
                    <a href="#" class="uk-alert-close uk-close"></a>Sorry, this description is already save !</div>');

                $this->redirect('desc_lable_monitor');
            }

            $column = '';
            for ($i = 0; $i < $this->request->data['ComplianceAudit']['rowCount']; $i++) {
                $column .= $this->request->data['ComplianceAudit']['label'][$i] . " VARCHAR( 100 ) NOT NULL ,";
            }
            $sql = "CREATE TABLE IF NOT EXISTS ca_audit_label_" . $tableName . "(
								id INT( 11 ) UNSIGNED NOT NULL AUTO_INCREMENT ,
                                                                ministry_id INT( 11 ) UNSIGNED NOT NULL,
                                                                audit_parameter INT( 11 ) UNSIGNED NOT NULL,
                                                                entry_date date NOT NULL,
                                                                " . $column . " created TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP(),
								PRIMARY KEY ( `id` ) ,
								INDEX ( `id` )
								)";
            if ($cn->query($sql)) {


                define('WWW_MODEL', ROOT . DS . APP_DIR . DS . 'Model' . DS);
                echo $folderPath = WWW_MODEL;
                if (is_dir($folderPath)) {
                    $file = fopen($folderPath . $NewFile . ".php", "w");
                    $useDbConfig = "useDbConfig";
                    $name = "name";
                    $useTable = "useTable";
                    $content = "<?php
                                    App::uses('AppModel', 'Model');
                                    class CAAuditLabel" . $tableName . " extends AppModel {
                                        public  $" . $useDbConfig . " = 'default';
                                        public  $" . $name . " = 'CAAuditLabel" . $tableName . "'; 
                                        public  $" . $useTable . " = 'ca_audit_label_" . $tableName . "';


                                    }
                                    ?>";
                    fwrite($file, $content);
                    fclose($file);
                    $file_path = $folderPath . '\ ' . $NewFile . ".php";
                    chmod($file_path, 0777);
                }

                $label = implode($this->request->data['ComplianceAudit']['label'], ",");

                $data['CAAllLabelAM']['set_type_am_id'] = $this->request->data['vp_type'];
                $data['CAAllLabelAM']['description'] = $this->request->data['desc'];
                $data['CAAllLabelAM']['model_name'] = $NewFile;
                $data['CAAllLabelAM']['table_name'] = 'ca_audit_label_' . $tableName;
                $data['CAAllLabelAM']['label'] = $label;
                $data['CAAllLabelAM']['created_by'] = $empID;

                $success = $this->CAAllLabelAM->save($data);
                if ($success) {

                    define('WWW_CACHE', ROOT . DS . APP_DIR . DS . 'tmp' . DS . 'cache' . DS . 'models' . DS);
                    echo $folderPath = WWW_CACHE;

                    $files = glob(WWW_CACHE . '*'); //get all file names
                    foreach ($files as $file) {
                        if (is_file($file))
                            unlink($file); //delete file
                    }

                    $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                    <a href="#" class="uk-alert-close uk-close"></a>Saved Successfully !</div>');
                } else {
                    $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert="">
                    <a href="#" class="uk-alert-close uk-close"></a>Sorry, Not Save !</div>');
                }
                $this->redirect('desc_lable_monitor');
            }
        }





        $this->paginate = array(
            'conditions' => array('CAAllLabelAM.status' => '0', 'CASetTypeAuditMonitoring.status' => '0', 'CASetTypeAuditMonitoring.status_for_monitoring' => '1'),
            'limit' => 10,
            'order' => array(
                'CAAllLabelAM.id' => 'desc'
            )
        );

        $VPtype = $this->CASetTypeAuditMonitoring->find('list', array(
            'fields' => array('id', 'set_name'),
            'conditions' => array('CASetTypeAuditMonitoring.status' => '0', 'CASetTypeAuditMonitoring.status_for_monitoring' => '1')
        ));
        $belongsTo = array("1" => "Legislation", "2" => "Policy", "3" => "Regulations", "4" => "Guidelines");
        $this->set('CAAllLabelAM', $this->paginate($this->CAAllLabelAM));
        $this->set(compact('EditData', 'create', 'Typeid', 'empID', 'belongsTo', 'VPtype'));
    }

    public function desc_audit_checklist($Typeid = NULL, $del = NULL) {
        //Configure::write('debug', 2);
        $this->layout = 'employee-new';
        $auth = $this->Session->read('Auth');
        $empID = $auth['MyProfile']['id'];

        if ($Typeid != null && $del != null) {
            $Del_ = $this->CADescAuditChecklist->updateAll(array('CADescAuditChecklist.status' => $del), array('CADescAuditChecklist.id' => $Typeid));
            if ($del == '0') {
                $sts = "Activeted";
            } else {
                $sts = "Inactiveted";
            }
            if ($Del_) {
                $this->Session->setFlash('<div class="uk-alert uk-alert-info" data-uk-alert="">
                    <a href="#" class="uk-alert-close uk-close"></a>Record ' . $sts . ' !</div>');
            } else {
                $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert="">
                    <a href="#" class="uk-alert-close uk-close"></a>Sorry, Record is still active !</div>');
            }
            $this->redirect('desc_audit_checklist');
        }
        if (isset($this->request->data['submit']) && $this->request->data['submit'] != '') {


//            echo "<pre>";
//            print_r($this->request->data);
//            die;
            if ($this->request->data['parameterid'] != '') {
                $data['CADescAuditChecklist']['id'] = $this->request->data['parameterid'];
            }

            for ($i = 0; $i < $this->request->data['ComplianceAudit']['rowCount']; $i++) {
                $data['CADescAuditChecklist']['checklist_type'] = $this->request->data['vp_type'];
                $data['CADescAuditChecklist']['description'] = $this->request->data['ComplianceAudit']['desc'][$i];
                //$data['CADescAuditChecklist']['result'] = $this->request->data['result'];
                $data['CADescAuditChecklist']['created_by'] = $empID;
                $this->CADescAuditChecklist->create();
                $success = $this->CADescAuditChecklist->save($data);
            }


            if ($success) {

                $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                    <a href="#" class="uk-alert-close uk-close"></a>Saved Successfully !</div>');
            } else {
                $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert="">
                    <a href="#" class="uk-alert-close uk-close"></a>Sorry, Not Save !</div>');
            }
            $this->redirect('desc_audit_checklist');
        }






        $this->paginate = array(
            'conditions' => array('CASetChecklistTypeAuditMonitoring.set_type' => '1'),
            'limit' => 10,
            'order' => array(
                'CADescAuditChecklist.id' => 'desc'
            )
        );
        if ($Typeid != "") {
            $EditData = $this->CADescAuditChecklist->find('all', array(
                'conditions' => array('CADescAuditChecklist.status' => '0', 'CADescAuditChecklist.id' => $Typeid)
            ));
            $create = "enable";
        }
        $VPtype = $this->CASetChecklistTypeAuditMonitoring->find('list', array(
            'fields' => array('id', 'checklist_name'),
            'conditions' => array('CASetChecklistTypeAuditMonitoring.status' => '0', 'CASetChecklistTypeAuditMonitoring.set_type' => '1')
        ));
        $this->set('allrecord', $this->paginate($this->CADescAuditChecklist));
        $this->set(compact('EditData', 'create', 'Typeid', 'empID', 'belongsTo', 'VPtype'));
    }

    public function desc_monitor_checklist($Typeid = NULL, $del = NULL) {
        //Configure::write('debug', 2);
        $this->layout = 'employee-new';
        $auth = $this->Session->read('Auth');
        $empID = $auth['MyProfile']['id'];

        if ($Typeid != null && $del != null) {
            $Del_ = $this->CADescAuditChecklist->updateAll(array('CADescAuditChecklist.status' => $del), array('CADescAuditChecklist.id' => $Typeid));
            if ($del == '0') {
                $sts = "Activeted";
            } else {
                $sts = "Inactiveted";
            }
            if ($Del_) {
                $this->Session->setFlash('<div class="uk-alert uk-alert-info" data-uk-alert="">
                    <a href="#" class="uk-alert-close uk-close"></a>Record ' . $sts . ' !</div>');
            } else {
                $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert="">
                    <a href="#" class="uk-alert-close uk-close"></a>Sorry, Record is still active !</div>');
            }
            $this->redirect('desc_monitor_checklist');
        }
        if (isset($this->request->data['submit']) && $this->request->data['submit'] != '') {


//            echo "<pre>";
//            print_r($this->request->data);
//            die;

            if ($this->request->data['parameterid'] != '') {
                $data['CADescAuditChecklist']['id'] = $this->request->data['parameterid'];
            }

            for ($i = 0; $i < $this->request->data['ComplianceAudit']['rowCount']; $i++) {
                $data['CADescAuditChecklist']['checklist_type'] = $this->request->data['vp_type'];
                $data['CADescAuditChecklist']['description'] = $this->request->data['ComplianceAudit']['desc'][$i];
                //$data['CADescAuditChecklist']['result'] = $this->request->data['result'];
                $data['CADescAuditChecklist']['created_by'] = $empID;
                $this->CADescAuditChecklist->create();
                $success = $this->CADescAuditChecklist->save($data);
            }

            if ($success) {
                $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                    <a href="#" class="uk-alert-close uk-close"></a>Saved Successfully !</div>');
            } else {
                $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert="">
                    <a href="#" class="uk-alert-close uk-close"></a>Sorry, Not Save !</div>');
            }
            $this->redirect('desc_monitor_checklist');
        }


        $this->paginate = array(
            'conditions' => array('CASetChecklistTypeAuditMonitoring.status_for_monitoring' => '1'),
            'limit' => 10,
            'order' => array(
                'CADescAuditChecklist.id' => 'desc'
            )
        );
        if ($Typeid != "") {
            $EditData = $this->CADescAuditChecklist->find('all', array(
                'conditions' => array('CADescAuditChecklist.status' => '0', 'CADescAuditChecklist.id' => $Typeid)
            ));
            $create = "enable";
        }
        $VPtype = $this->CASetChecklistTypeAuditMonitoring->find('list', array(
            'fields' => array('id', 'checklist_name'),
            'conditions' => array('CASetChecklistTypeAuditMonitoring.status' => '0', 'CASetChecklistTypeAuditMonitoring.status_for_monitoring' => '1')
        ));
        $this->set('allrecord', $this->paginate($this->CADescAuditChecklist));
        $this->set(compact('EditData', 'create', 'Typeid', 'empID', 'belongsTo', 'VPtype'));
    }

    
    public function thematic_area_master($Typeid = NULL, $del = NULL) {
       //Configure::write('debug',2);
        $this->layout = 'employee-new';
        $auth = $this->Session->read('Auth');
        $empID = $auth['MyProfile']['id'];

        if ($Typeid != null && $del == 'del') {
            $Del_ = $this->CAThematicAreaMaster->updateAll(array('CAThematicAreaMaster.status' => "1"), array('CAThematicAreaMaster.id' => $Typeid));

            if ($Del_) {
                $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert="">
                    <a href="#" class="uk-alert-close uk-close"></a>Record Deleted !</div>');
            } else {
                $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert="">
                    <a href="#" class="uk-alert-close uk-close"></a>Sorry, Not Deleted !</div>');
            }
            $this->redirect('thematic_area_master');
        }
        if (isset($this->request->data['submit']) && $this->request->data['submit'] != '') {

            if ($this->request->data['thematic_area_id'] != "") {
                $data['CAThematicAreaMaster']['id'] = $this->request->data['thematic_area_id'];
            }
            $data['CAThematicAreaMaster']['thematic_area'] = $this->request->data['thematic_area'];
            $data['CAThematicAreaMaster']['artical'] = $this->request->data['artical'];
            $data['CAThematicAreaMaster']['template'] = $this->request->data['templant'];
            $data['CAThematicAreaMaster']['created_by'] = $empID;
            $success = $this->CAThematicAreaMaster->save($data);
            if ($success) {
                $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                    <a href="#" class="uk-alert-close uk-close"></a>Saved Successfully !</div>');
            } else {
                $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert="">
                    <a href="#" class="uk-alert-close uk-close"></a>Sorry, Not Save !</div>');
            }
            $this->redirect('thematic_area_master');
        }


        $this->paginate = array(
            'conditions' => array('CAThematicAreaMaster.status' => '0'),
            'limit' => 10,
            'order' => array(
                'CAThematicAreaMaster.id' => 'desc'
            )
        );
        if ($Typeid != "") {
            $EditData = $this->CAThematicAreaMaster->find('all', array(
                'conditions' => array('CAThematicAreaMaster.status' => '0', 'CAThematicAreaMaster.id' => $Typeid)
            ));
            $create = "enable";
        }
//        $VPtype = $this->CASetType->find('list', array(
//            'fields' => array('id', 'set_name'),
//            'conditions' => array('CASetType.status' => '0', 'CASetType.set_type' => '1')
//        ));
//        $belongsTo = array("1" => "Legislation", "2" => "Policy", "3" => "Regulations", "4" => "Guidelines");
        $this->set('setType', $this->paginate($this->CAThematicAreaMaster));
        $this->set(compact('EditData', 'create', 'Typeid', 'empID', 'belongsTo', 'VPtype'));
    }
    
    public function desc_value_principle($Typeid = NULL, $del = NULL) {
        //Configure::write('debug',2);
        $this->layout = 'employee-new';
        $auth = $this->Session->read('Auth');
        $empID = $auth['MyProfile']['id'];

        if ($Typeid != null && $del == 'del') {
            $Del_ = $this->CADescValuePrinciple->updateAll(array('CADescValuePrinciple.status' => "1"), array('CADescValuePrinciple.id' => $Typeid));

            if ($Del_) {
                $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert="">
                    <a href="#" class="uk-alert-close uk-close"></a>Record Deleted !</div>');
            } else {
                $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert="">
                    <a href="#" class="uk-alert-close uk-close"></a>Sorry, Not Deleted !</div>');
            }
            $this->redirect('desc_value_principle');
        }
        if (isset($this->request->data['submit']) && $this->request->data['submit'] != '') {

            if ($this->request->data['parameterid'] != "") {
                $data['CADescValuePrinciple']['id'] = $this->request->data['parameterid'];
            }
            $data['CADescValuePrinciple']['set_type_id'] = $this->request->data['vp_type'];
            $data['CADescValuePrinciple']['thematic_area_id'] = $this->request->data['belongs_to'];
            $data['CADescValuePrinciple']['description'] = $this->request->data['desc'];
            $data['CADescValuePrinciple']['app_legislation'] = $this->request->data['app_legislation'];
            $data['CADescValuePrinciple']['applicable'] = $this->request->data['applicable'];
            $data['CADescValuePrinciple']['created_by'] = $empID;
            $success = $this->CADescValuePrinciple->save($data);
            if ($success) {
                $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                    <a href="#" class="uk-alert-close uk-close"></a>Saved Successfully !</div>');
            } else {
                $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert="">
                    <a href="#" class="uk-alert-close uk-close"></a>Sorry, Not Save !</div>');
            }
            $this->redirect('desc_value_principle');
        }


        $this->paginate = array(
            'conditions' => array('CADescValuePrinciple.status' => '0'),
            'limit' => 10,
            'order' => array(
                'CADescValuePrinciple.id' => 'desc'
            )
        );
        if ($Typeid != "") {
            $EditData = $this->CADescValuePrinciple->find('all', array(
                'conditions' => array('CADescValuePrinciple.status' => '0', 'CADescValuePrinciple.id' => $Typeid)
            ));
            $create = "enable";
        }
        $VPtype = $this->CASetType->find('list', array(
            'fields' => array('id', 'set_name'),
            'conditions' => array('CASetType.status' => '0', 'CASetType.set_type' => '1')
        ));
        
        $themAreaMaster = $this->CAThematicAreaMaster->find('list', array(
            'fields' => array('id', 'thematic_area'),
            'conditions' => array('CAThematicAreaMaster.status' => '0')
        ));
        
        //$belongsTo = array("1" => "Legislation", "2" => "Policy", "3" => "Regulations", "4" => "Guidelines");
        
        $this->set('setType', $this->paginate($this->CADescValuePrinciple));
        $this->set(compact('EditData', 'create', 'themAreaMaster','Typeid', 'empID', 'belongsTo', 'VPtype'));
    }

    public function desc_thematic_area($Typeid = NULL, $del = NULL) {
        //Configure::write('debug',2);
        $this->layout = 'employee-new';
        $auth = $this->Session->read('Auth');
        $empID = $auth['MyProfile']['id'];

        if ($Typeid != null && $del == 'del') {
            $Del_ = $this->CADescThematicArea->updateAll(array('CADescThematicArea.status' => "1"), array('CADescThematicArea.id' => $Typeid));

            if ($Del_) {
                $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert="">
                    <a href="#" class="uk-alert-close uk-close"></a>Record Deleted !</div>');
            } else {
                $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert="">
                    <a href="#" class="uk-alert-close uk-close"></a>Sorry, Not Deleted !</div>');
            }
            $this->redirect('desc_thematic_area');
        }
        if (isset($this->request->data['submit']) && $this->request->data['submit'] != '') {

            if ($this->request->data['parameterid'] != "") {
                $data['CADescThematicArea']['id'] = $this->request->data['parameterid'];
            }
            $data['CADescThematicArea']['set_type_id'] = $this->request->data['vp_type'];
            $data['CADescThematicArea']['measurment_type'] = $this->request->data['measur_type'];
            $data['CADescThematicArea']['performance_indicator'] = $this->request->data['desc'];
            $data['CADescThematicArea']['created_by'] = $empID;

            $success = $this->CADescThematicArea->save($data);

            if ($success) {
                $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                    <a href="#" class="uk-alert-close uk-close"></a>Saved Successfully !</div>');
            } else {
                $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert="">
                    <a href="#" class="uk-alert-close uk-close"></a>Sorry, Not Save !</div>');
            }
            $this->redirect('desc_thematic_area');
        }


        $this->paginate = array(
            'conditions' => array('CADescThematicArea.status' => '0'),
            'limit' => 10,
            'order' => array(
                'CADescThematicArea.id' => 'desc'
            )
        );
        if ($Typeid != "") {
            $EditData = $this->CADescThematicArea->find('all', array(
                'conditions' => array('CADescThematicArea.status' => '0', 'CADescThematicArea.id' => $Typeid)
            ));
            $create = "enable";
        }
//        $VPtype = $this->CASetType->find('list', array(
//            'fields' => array('id', 'set_name'),
//            'conditions' => array('CASetType.status' => '0', 'CASetType.set_type' => '2')
//        ));
        
        $VPtype = $this->CAThematicAreaMaster->find('list', array(
            'fields' => array('id', 'thematic_area'),
            'conditions' => array('CAThematicAreaMaster.status' => '0')
        ));
        $measurType = array("1" => "Number", "2" => "Percent(%)", "3" => "Ratio", "4" => "Boolean(Yes/No)", "5" => "Character");
        $this->set('setType', $this->paginate($this->CADescThematicArea));
        $this->set(compact('EditData', 'create', 'Typeid', 'empID', 'measurType', 'VPtype'));
    }

    public function quant_qual_save() {
        //Configure::write('debug',2);
        $this->layout = 'employee-new';
        $auth = $this->Session->read('Auth');
        $empID = $auth['MyProfile']['id'];


        if (isset($this->request->data['submit']) && $this->request->data['submit'] != '') {


            $data['CAQuantitativeQualitative']['ministry_id'] = $this->request->data['mda'];
            $data['CAQuantitativeQualitative']['thematic_area'] = $this->request->data['thematic_area'];
            $data['CAQuantitativeQualitative']['type'] = $this->request->data['type_id'];
            $data['CAQuantitativeQualitative']['performance_indicator_quant'] = $this->request->data['per_indicator'];
            $data['CAQuantitativeQualitative']['measurement_type'] = $this->request->data['measurement_type'];
            $data['CAQuantitativeQualitative']['comment'] = $this->request->data['comment'];
            $data['CAQuantitativeQualitative']['description'] = $this->request->data['description'];
            $data['CAQuantitativeQualitative']['performance_standard'] = $this->request->data['perform_stantd'];
            $data['CAQuantitativeQualitative']['performance_indicator_qual'] = $this->request->data['perform_indicat'];
            $data['CAQuantitativeQualitative']['analysis_finding'] = $this->request->data['analysis_findings'];
            $data['CAQuantitativeQualitative']['progress_achieve'] = $this->request->data['progress_achieved'];
            $data['CAQuantitativeQualitative']['challenge_face'] = $this->request->data['challeng_face'];
            $data['CAQuantitativeQualitative']['recommendation'] = $this->request->data['recommend'];
            $data['CAQuantitativeQualitative']['conclusion'] = $this->request->data['conclusion'];
            $data['CAQuantitativeQualitative']['created_by'] = $empID;
            $success = $this->CAQuantitativeQualitative->save($data);
            if ($success) {
                $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                    <a href="#" class="uk-alert-close uk-close"></a>Saved Successfully !</div>');
            } else {
                $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert="">
                    <a href="#" class="uk-alert-close uk-close"></a>Sorry, Not Save !</div>');
            }
            $this->redirect('quant_qual_list/' . $this->request->data['type_id']);
        }

        $Ministry = $this->Ministry->find('list', array('fields' => 'ministry_name',
            'conditions' => array('ministry_status' => '1')));

//        $ThematicArea = $this->CASetType->find('list', array('fields' => 'CASetType.set_name',
//            'conditions' => array('CASetType.status' => '0', 'CASetType.set_type' => '2')));
        
        $ThematicArea = $this->CAThematicAreaMaster->find('list', array(
            'fields' => array('id', 'thematic_area'),
            'conditions' => array('CAThematicAreaMaster.status' => '0')
        ));

        $this->set(compact('Ministry', 'ThematicArea'));
    }

    public function quant_qual_edit($dataID = NULL, $Typeid = NULL, $del = NULL) {
        //Configure::write('debug',2);
        $this->layout = 'employee-new';
        $auth = $this->Session->read('Auth');
        $empID = $auth['MyProfile']['id'];



        if ($Typeid != null && $del == 'del') {
            $Del_ = $this->CAQuantitativeQualitative->updateAll(array('CAQuantitativeQualitative.status' => "1"), array('CAQuantitativeQualitative.id' => $dataID));

            if ($Del_) {
                $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert="">
                    <a href="#" class="uk-alert-close uk-close"></a>Record Deleted !</div>');
            } else {
                $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert="">
                    <a href="#" class="uk-alert-close uk-close"></a>Sorry, Not Deleted !</div>');
            }
            $this->redirect('quant_qual_list/' . $Typeid);
        }
        if (isset($this->request->data['submit']) && $this->request->data['submit'] != '') {

            $data['CAQuantitativeQualitative']['id'] = $this->request->data['data_id'];
            $data['CAQuantitativeQualitative']['ministry_id'] = $this->request->data['mda'];
            $data['CAQuantitativeQualitative']['thematic_area'] = $this->request->data['thematic_area'];
            $data['CAQuantitativeQualitative']['type'] = $this->request->data['type_id'];
            $data['CAQuantitativeQualitative']['performance_indicator_quant'] = $this->request->data['per_indicator'];
            $data['CAQuantitativeQualitative']['measurement_type'] = $this->request->data['measurement_type'];
            $data['CAQuantitativeQualitative']['comment'] = $this->request->data['comment'];
            $data['CAQuantitativeQualitative']['description'] = $this->request->data['description'];
            $data['CAQuantitativeQualitative']['performance_standard'] = $this->request->data['perform_stantd'];
            $data['CAQuantitativeQualitative']['performance_indicator_qual'] = $this->request->data['perform_indicat'];
            $data['CAQuantitativeQualitative']['analysis_finding'] = $this->request->data['analysis_findings'];
            $data['CAQuantitativeQualitative']['progress_achieve'] = $this->request->data['progress_achieved'];
            $data['CAQuantitativeQualitative']['challenge_face'] = $this->request->data['challeng_face'];
            $data['CAQuantitativeQualitative']['recommendation'] = $this->request->data['recommend'];
            $data['CAQuantitativeQualitative']['conclusion'] = $this->request->data['conclusion'];
            $data['CAQuantitativeQualitative']['created_by'] = $empID;
            $success = $this->CAQuantitativeQualitative->save($data);
            if ($success) {
                $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                    <a href="#" class="uk-alert-close uk-close"></a>Modified Successfully !</div>');
            } else {
                $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert="">
                    <a href="#" class="uk-alert-close uk-close"></a>Sorry, Not Modified !</div>');
            }
            $this->redirect('quant_qual_list/' . $this->request->data['type_id']);
        }



        $EditRecord = $this->CAQuantitativeQualitative->find('all', array(
            'conditions' => array('CAQuantitativeQualitative.status' => '0', 'CAQuantitativeQualitative.id' => $dataID),
        ));
        foreach ($EditRecord as $rec)
            ;
//        echo "<pre>";
//        print_r($EditRecord);die;
        $Ministry = $this->Ministry->find('list', array('fields' => 'ministry_name',
            'conditions' => array('ministry_status' => '1')));

        $ThematicArea = $this->CASetType->find('list', array('fields' => 'CASetType.set_name',
            'conditions' => array('CASetType.status' => '0', 'CASetType.set_type' => '2')));

        $perf_indic = $this->CADescThematicArea->find('list', array(
            'fields' => array('id', 'performance_indicator'),
            'conditions' => array('CADescThematicArea.status' => '0', 'CADescThematicArea.set_type_id' => $rec['CAQuantitativeQualitative']['thematic_area'])
        ));

        $measurType = array("1" => "Number", "2" => "Percent(%)", "3" => "Ratio", "4" => "Boolean(Yes/No)", "5" => "Character");

        $this->set(compact('EditRecord', 'perf_indic', 'Ministry', 'ThematicArea', 'Typeid', 'measurType', 'dataID'));
    }

    public function quant_qual_list($Typeid = NULL) {
        //Configure::write('debug',2);
        $this->layout = 'employee-new';
        $auth = $this->Session->read('Auth');
        $empID = $auth['MyProfile']['id'];




        if (isset($this->request->data['submit']) && $this->request->data['submit'] != '') {

            if ($this->request->data['vpTypeid'] != "") {
                $data['CASetType']['id'] = $this->request->data['vpTypeid'];
            }
            $data['CASetType']['set_name'] = $this->request->data['vpType'];
            $data['CASetType']['set_type'] = '2'; // For value and principle
            $data['CASetType']['created_by'] = $empID;
            $success = $this->CASetType->save($data);
            if ($success) {
                $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                    <a href="#" class="uk-alert-close uk-close"></a>Saved Successfully !</div>');
            } else {
                $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert="">
                    <a href="#" class="uk-alert-close uk-close"></a>Sorry, Not Save !</div>');
            }
            $this->redirect('set_thematic_area');
        }


        $this->paginate = array(
            'conditions' => array('CAQuantitativeQualitative.status' => '0', 'CAQuantitativeQualitative.type' => $Typeid),
            'limit' => 10,
            'order' => array(
                'CAQuantitativeQualitative.id' => 'desc'
            )
        );

        $this->set('allRecord', $this->paginate($this->CAQuantitativeQualitative));
        $this->set(compact('EditData', 'create', 'Typeid', 'empID'));
    }

    public function audit_entry($auditID = NULL) {
        //Configure::write('debug',2);
        $this->layout = 'employee-new';
        $auth = $this->Session->read('Auth');
        $empID = $auth['MyProfile']['id'];


        $audit__param = $this->CAAllLabelAM->find('all', array(
            'fields' => array('CAAllLabelAM.id', 'CAAllLabelAM.description'),
            'conditions' => array('CASetTypeAuditMonitoring.status' => '0', 'CAAllLabelAM.status' => '0', 'CASetTypeAuditMonitoring.set_type' => '1')
        ));
        $audit_param = array();
        foreach ($audit__param as $key => $val) {
            $audit_param[$val['CAAllLabelAM']['id']] = $val['CAAllLabelAM']['description'];
        }
        if ($auditID != '') {
            $auditparam = $this->CAAllLabelAM->find('first', array(
                'conditions' => array('CAAllLabelAM.status' => '0', 'CAAllLabelAM.id' => $auditID)));
            $model__Name = $auditparam['CAAllLabelAM']['model_name'];
            $tblName = $auditparam['CAAllLabelAM']['table_name'];
            $paramName = $auditparam['CAAllLabelAM']['description'];

            $Model = ClassRegistry::init(array('class' => $model__Name, 'table' => $tblName));
            $audit_param_list = $Model->find('all');


            $labels = explode(",", $auditparam ['CAAllLabelAM']['label']);

            $this->set('allRecord', $audit_param_list);
            $this->set(compact('model__Name', 'labels', 'paramName'));
        }

        $this->set(compact('EditData', 'create', 'Typeid', 'empID', 'audit_param'));
    }

    public function monitor_entry($auditID = NULL) {
        //Configure::write('debug',2);
        $this->layout = 'employee-new';
        $auth = $this->Session->read('Auth');
        $empID = $auth['MyProfile']['id'];

//        $audit_param = $this->CAAllLabelAM->find('list', array('fields' => array('CAAllLabelAM.id', 'CAAllLabelAM.description'),
//            'conditions' => array('CAAllLabelAM.status' => '0')));
        $audit__param = $this->CAAllLabelAM->find('all', array(
            'fields' => array('CAAllLabelAM.id', 'CAAllLabelAM.description'),
            'conditions' => array('CASetTypeAuditMonitoring.status' => '0', 'CAAllLabelAM.status' => '0')
        ));
        $audit_param = array();
        foreach ($audit__param as $key => $val) {
            $audit_param[$val['CAAllLabelAM']['id']] = $val['CAAllLabelAM']['description'];
        }
        if ($auditID != '') {
            $auditparam = $this->CAAllLabelAM->find('first', array(
                'conditions' => array('CAAllLabelAM.status' => '0', 'CAAllLabelAM.id' => $auditID)));
            $model__Name = $auditparam['CAAllLabelAM']['model_name'];
            $tblName = $auditparam['CAAllLabelAM']['table_name'];
            $paramName = $auditparam['CAAllLabelAM']['description'];

            $Model = ClassRegistry::init(array('class' => $model__Name, 'table' => $tblName));
            $audit_param_list = $Model->find('all');


            $labels = explode(",", $auditparam ['CAAllLabelAM']['label']);

            $this->set('allRecord', $audit_param_list);
            $this->set(compact('model__Name', 'labels', 'paramName'));
        }




        $this->set(compact('EditData', 'create', 'Typeid', 'empID', 'audit_param'));
    }

    public function audit_entry_save() {
        //Configure::write('debug',2);
        $this->layout = 'employee-new';
        $auth = $this->Session->read('Auth');
        $empID = $auth['MyProfile']['id'];


        if (isset($this->request->data['submit']) && $this->request->data['submit'] != '') {
//            echo "<pre>";
//            print_r($this->request->data);
            define('WWW_CACHE', ROOT . DS . APP_DIR . DS . 'tmp' . DS . 'cache' . DS . 'models' . DS);
            $folderPath = WWW_CACHE;

            $files = glob(WWW_CACHE . '*'); //get all file names
            foreach ($files as $file) {
                if (is_file($file))
                    unlink($file); //delete file
            }
            
            
            $model_name = $this->request->data['model_name'];
            $label_name = $this->request->data['label_name'];
            $labelname = explode(",", $label_name);
            //print_r($labelname);
            //$cnt=count($this->request->data[$labelname[0]]);
            $cnt=count($labelname);
            $this->loadModel($model_name);
            for ($i = 0; $i < $cnt; $i++) {
                
                for ($j = 0; $j < count($labelname); $j++) {
                $label__name = str_replace(" ", "_", strtolower($labelname[$j]));
                $data[$model_name][$label__name] = $this->request->data[$label__name][$i];
                }
                $data[$model_name]['ministry_id'] = $this->request->data['mda'];
                $data[$model_name]['audit_parameter'] = $this->request->data['audit_param'];
                $data[$model_name]['entry_date'] = date("Y-m-d", strtotime($this->request->data['entry_date']));
//                echo "<pre>";
//                print_r($data);die;
                $this->$model_name->create();
                $success = $this->$model_name->save($data);
            }
            
            if ($success) {
                $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                    <a href="#" class="uk-alert-close uk-close"></a>Saved Successfully !</div>');
            } else {
                $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert="">
                    <a href="#" class="uk-alert-close uk-close"></a>Sorry, Not Save !</div>');
            }
            $this->redirect('audit_entry');
        }

        $Ministry = $this->Ministry->find('list', array('fields' => 'ministry_name',
            'conditions' => array('ministry_status' => '1')));

        $audit__param = $this->CAAllLabelAM->find('all', array(
            'fields' => array('CAAllLabelAM.id', 'CAAllLabelAM.description'),
            'conditions' => array('CASetTypeAuditMonitoring.status' => '0', 'CAAllLabelAM.status' => '0', 'CASetTypeAuditMonitoring.set_type' => '1')
        ));

        $audit_param = array();
        foreach ($audit__param as $key => $val) {
            $audit_param[$val['CAAllLabelAM']['id']] = $val['CAAllLabelAM']['description'];
        }

        $this->set(compact('Ministry', 'audit_param'));
    }

    public function audit_checklist_save() {
        // Configure::write('debug',2);
        $this->layout = 'employee-new';
        $auth = $this->Session->read('Auth');
        $empID = $auth['MyProfile']['id'];


        if (isset($this->request->data['submit']) && $this->request->data['submit'] != '') {


//            echo "<pre>";
//            print_r($this->request->data['param_id']);

            for ($i = 0; $i < count($this->request->data['param_id']); $i++) {
                $this->CADescAuditChecklist->create();
                $success = $this->CADescAuditChecklist->updateAll(array('CADescAuditChecklist.result' => $this->request->data['result'][$i], 'CADescAuditChecklist.remark' => "'" . $this->request->data['remark'][$i] . "'"), array('CADescAuditChecklist.id' => $this->request->data['param_id'][$i]));
            }

//            echo "<pre>";
//            print_r($this->request->data);die;
//           
            if ($success) {
                $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                    <a href="#" class="uk-alert-close uk-close"></a>Saved Successfully !</div>');
            } else {
                $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert="">
                    <a href="#" class="uk-alert-close uk-close"></a>Sorry, Not Save !</div>');
            }
            $this->redirect('audit_checklist_save');
        }

//        $Ministry = $this->Ministry->find('list', array('fields' => 'ministry_name',
//            'conditions' => array('ministry_status' => '1')));

        $audit_param = $this->CASetChecklistTypeAuditMonitoring->find('list', array(
            'fields' => array('CASetChecklistTypeAuditMonitoring.id', 'CASetChecklistTypeAuditMonitoring.checklist_name'),
            'conditions' => array('CASetChecklistTypeAuditMonitoring.status' => '0', 'CASetChecklistTypeAuditMonitoring.set_type' => '1')
        ));



        $this->set(compact('Ministry', 'audit_param'));
    }

    public function monitor_checklist_save() {
        // Configure::write('debug',2);
        $this->layout = 'employee-new';
        $auth = $this->Session->read('Auth');
        $empID = $auth['MyProfile']['id'];


        if (isset($this->request->data['submit']) && $this->request->data['submit'] != '') {


//            echo "<pre>";
//            print_r($this->request->data['param_id']);

            for ($i = 0; $i < count($this->request->data['param_id']); $i++) {
                $this->CADescAuditChecklist->create();
                $success = $this->CADescAuditChecklist->updateAll(array('CADescAuditChecklist.result' => $this->request->data['result'][$i], 'CADescAuditChecklist.remark' => "'" . $this->request->data['remark'][$i] . "'"), array('CADescAuditChecklist.id' => $this->request->data['param_id'][$i]));
            }

//            echo "<pre>";
//            print_r($this->request->data);die;
//           
            if ($success) {
                $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                    <a href="#" class="uk-alert-close uk-close"></a>Saved Successfully !</div>');
            } else {
                $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert="">
                    <a href="#" class="uk-alert-close uk-close"></a>Sorry, Not Save !</div>');
            }
            $this->redirect('monitor_checklist_save');
        }

//        $Ministry = $this->Ministry->find('list', array('fields' => 'ministry_name',
//            'conditions' => array('ministry_status' => '1')));

        $audit_param = $this->CASetChecklistTypeAuditMonitoring->find('list', array(
            'fields' => array('CASetChecklistTypeAuditMonitoring.id', 'CASetChecklistTypeAuditMonitoring.checklist_name'),
            'conditions' => array('CASetChecklistTypeAuditMonitoring.status' => '0', 'CASetChecklistTypeAuditMonitoring.status_for_monitoring' => '1')
        ));



        $this->set(compact('Ministry', 'audit_param'));
    }

    public function monitor_entry_save() {
        //Configure::write('debug',2);
        $this->layout = 'employee-new';
        $auth = $this->Session->read('Auth');
        $empID = $auth['MyProfile']['id'];


        if (isset($this->request->data['submit']) && $this->request->data['submit'] != '') {

            define('WWW_CACHE', ROOT . DS . APP_DIR . DS . 'tmp' . DS . 'cache' . DS . 'models' . DS);
            $folderPath = WWW_CACHE;

            $files = glob(WWW_CACHE . '*'); //get all file names
            foreach ($files as $file) {
                if (is_file($file))
                    unlink($file); //delete file
            }

//            $model_name = $this->request->data['model_name'];
//            $label_name = $this->request->data['label_name'];
//            $labelname = explode(",", $label_name);
//            $this->loadModel($model_name);
//            for ($i = 0; $i < count($labelname); $i++) {
//                $data[$model_name][$labelname[$i]] = $this->request->data[$labelname[$i]];
//               
//            }
//            $data[$model_name]['ministry_id'] = $this->request->data['mda'];
//            $data[$model_name]['audit_parameter'] = $this->request->data['audit_param'];
//            $data[$model_name]['entry_date'] = date("Y-m-d", strtotime($this->request->data['entry_date']));
//
//
//            $success = $this->$model_name->save($data);
            
            
             $model_name = $this->request->data['model_name'];
            $label_name = $this->request->data['label_name'];
            $labelname = explode(",", $label_name);
            //print_r($labelname);
            //$cnt=count($this->request->data[$labelname[0]]);
            $cnt=count($labelname);
            $this->loadModel($model_name);
            for ($i = 0; $i < $cnt; $i++) {
                
                for ($j = 0; $j < count($labelname); $j++) {
                //$data[$model_name][$labelname[$j]] = $this->request->data[$labelname[$j]][$i];
                $label__name = str_replace(" ", "_", strtolower($labelname[$j]));
                $data[$model_name][$label__name] = $this->request->data[$label__name][$i];
                }
                $data[$model_name]['ministry_id'] = $this->request->data['mda'];
                $data[$model_name]['audit_parameter'] = $this->request->data['audit_param'];
                $data[$model_name]['entry_date'] = date("Y-m-d", strtotime($this->request->data['entry_date']));

                $this->$model_name->create();
                $success = $this->$model_name->save($data);
            }
            
            
            
            
            if ($success) {
                $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                    <a href="#" class="uk-alert-close uk-close"></a>Saved Successfully !</div>');
            } else {
                $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert="">
                    <a href="#" class="uk-alert-close uk-close"></a>Sorry, Not Save !</div>');
            }
            $this->redirect('monitor_entry');
        }

        $Ministry = $this->Ministry->find('list', array('fields' => 'ministry_name',
            'conditions' => array('ministry_status' => '1')));

        $audit__param = $this->CAAllLabelAM->find('all', array(
            'fields' => array('CAAllLabelAM.id', 'CAAllLabelAM.description'),
            'conditions' => array('CASetTypeAuditMonitoring.status' => '0', 'CAAllLabelAM.status' => '0', 'CASetTypeAuditMonitoring.status_for_monitoring' => '1')
        ));

        $audit_param = array();
        foreach ($audit__param as $key => $val) {
            $audit_param[$val['CAAllLabelAM']['id']] = $val['CAAllLabelAM']['description'];
        }

        $this->set(compact('Ministry', 'audit_param'));
    }

    public function set_thematic_area($Typeid = NULL, $del = NULL) {
        //Configure::write('debug',2);
        $this->layout = 'employee-new';
        $auth = $this->Session->read('Auth');
        $empID = $auth['MyProfile']['id'];

        if ($Typeid != null && $del == 'del') {
            $Del_ = $this->CASetType->updateAll(array('CASetType.status' => "1"), array('CASetType.id' => $Typeid));

            if ($Del_) {
                $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert="">
                    <a href="#" class="uk-alert-close uk-close"></a>Record Deleted !</div>');
            } else {
                $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert="">
                    <a href="#" class="uk-alert-close uk-close"></a>Sorry, Not Deleted !</div>');
            }
            $this->redirect('set_thematic_area');
        }


        if (isset($this->request->data['submit']) && $this->request->data['submit'] != '') {

            if ($this->request->data['vpTypeid'] != "") {
                $data['CASetType']['id'] = $this->request->data['vpTypeid'];
            }
            $data['CASetType']['set_name'] = $this->request->data['vpType'];
            $data['CASetType']['set_type'] = '2'; // For value and principle
            $data['CASetType']['created_by'] = $empID;
            $success = $this->CASetType->save($data);
            if ($success) {
                $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                    <a href="#" class="uk-alert-close uk-close"></a>Saved Successfully !</div>');
            } else {
                $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert="">
                    <a href="#" class="uk-alert-close uk-close"></a>Sorry, Not Save !</div>');
            }
            $this->redirect('set_thematic_area');
        }


        $this->paginate = array(
            'conditions' => array('CASetType.status' => '0', 'CASetType.set_type' => '2'),
            'limit' => 10,
            'order' => array(
                'CASetType.id' => 'desc'
            )
        );
        if ($Typeid != "") {
            $EditData = $this->CASetType->find('all', array(
                'conditions' => array('CASetType.status' => '0', 'CASetType.id' => $Typeid)
            ));
            $create = "enable";
        }
        $this->set('setType', $this->paginate($this->CASetType));
        $this->set(compact('EditData', 'create', 'Typeid', 'empID'));
    }

    public function emp_wealthdeclaration_selfform($formID = null) {
    $this->set(compact('formID'));
    }
    
    public function emp_wealthdeclaration_spouseform($formID = null,$emp_difin_id=null) {
       // Configure::write('debug',2);
        
        $EmpWealthDecla= $this->CAEmployeeDefinition->find('all', array(
            'conditions' => array('CAEmployeeDefinition.status' => '0', 'CAEmployeeDefinition.id' => $emp_difin_id),
            'order' => 'CAEmployeeDefinition.id desc'
        ));

//        $EmpWealthDecla = $this->CAWealthdeclaration->find('all', array(
//            'conditions' => array('CAWealthdeclaration.status' => '0', 'CAWealthdeclaration.emp_difini_id' => $emp_difin_id),
//        ));
        $spouses = $this->CADependentDetails->find('list', array('fields' => array('CADependentDetails.id','CADependentDetails.fname'),
            'conditions' => array('CADependentDetails.depend_status' => '1','CADependentDetails.dependent_type' => '1','CADependentDetails.emp_difini_id' => $emp_difin_id)));

        $this->set(compact('formID','spouses','EmpWealthDecla'));
    }
    
    public function emp_wealthdeclaration_childrenform($formID = null,$emp_difin_id=null) {
        $EmployeeDefinition = $this->CAEmployeeDefinition->find('all', array(
            'conditions' => array('CAEmployeeDefinition.status' => '0', 'CAEmployeeDefinition.id' => $emp_difin_id),
            'order' => 'CAEmployeeDefinition.id desc'
        ));

//        $EmpWealthDecla = $this->CAWealthdeclaration->find('all', array(
//            'conditions' => array('CAWealthdeclaration.status' => '0', 'CAWealthdeclaration.emp_difini_id' => $emp_difin_id),
//        ));
        
        $children = $this->CADependentDetails->find('list', array('fields' => array('CADependentDetails.id','CADependentDetails.fname'),
            'conditions' => array('CADependentDetails.depend_status' => '1','CADependentDetails.dependent_type' => '2','CADependentDetails.emp_difini_id' => $emp_difin_id)));
        $this->set(compact('formID','children'));
    }
    public function emp_wealthdeclaration($emp_difin_id = null, $assetID = null, $del = null) {
        //Configure::write('debug',2);
        $this->layout = 'employee-new';
        $auth = $this->Session->read('Auth');
        $empID = $auth['MyProfile']['id'];
        $emp_difin_id = base64_decode($emp_difin_id);
        
        
        $EmployeeDefinition = $this->CAEmployeeDefinition->find('all', array(
            'conditions' => array('CAEmployeeDefinition.status' => '0', 'CAEmployeeDefinition.id' => $emp_difin_id),
            'order' => 'CAEmployeeDefinition.id desc'
        ));
        
        $wealthdeclarType = $this->CAWealthdeclaration->query("Select declaration_type from ca_wealthdeclaration where status=0 and emp_difini_id='".$emp_difin_id."' order by declaration_type desc limit 0,1");
        $wealthdeclar_Type = $wealthdeclarType[0]['ca_wealthdeclaration']['declaration_type'];
        
        $EmpWealthDecla = $this->CAWealthdeclaration->find('all', array(
            'conditions' => array('CAWealthdeclaration.status' => '0', 'CAWealthdeclaration.emp_difini_id' => $emp_difin_id,'CAWealthdeclaration.declaration_type' => $wealthdeclar_Type),
        ));
        
        
        $DeclarationStatus = $EmpWealthDecla[0]['CAWealthdeclaration']['declaration_status'];
        
        
        ///////////////////Check for wealthdeclaration ///////////////
        
        $decl_Date = $this->CADeclarationDate->find("all",array(
            'conditions' => array('CADeclarationDate.status' => '0'),
        ));
        $StatmentDate = date("d-m-Y", strtotime($decl_Date['0']['CADeclarationDate']['emp_from']));
        
//        echo "<pre>";
//        print_r($EmployeeDefinition);die;
        
        $emp_decl_start_date = strtotime(date("Y-m-d", strtotime($decl_Date['0']['CADeclarationDate']['emp_from'])));
        $emp_decl_end_date = strtotime(date("Y-m-d", strtotime($decl_Date['0']['CADeclarationDate']['emp_to'])));
        $commi_decl_start_date = strtotime(date("Y-m-d", strtotime($decl_Date['0']['CADeclarationDate']['commission_from'])));
        $commi_decl_end_date = strtotime(date("Y-m-d", strtotime($decl_Date['0']['CADeclarationDate']['commission_to'])));
        
        $emp_days_from_joining = $decl_Date['0']['CADeclarationDate']['days_from_joining'];
        $emp_days_from_exit = $decl_Date['0']['CADeclarationDate']['days_from_exit'];
        
        $date_of_joining = date("Y-m-d", strtotime($EmployeeDefinition['0']['CAEmployeeDefinition']['date_of_joining']));
       if($EmployeeDefinition['0']['CAEmployeeDefinition']['date_of_exit'] != ''){
        $date_of_exit = date("Y-m-d", strtotime($EmployeeDefinition['0']['CAEmployeeDefinition']['date_of_exit']));
       }
        
        $FormAccess_Right = '0';
        $FormAccessFor = '';
        
        
       /*
        * Case : Initial Declaration
        */
        
            $dateOFjoining = date_create($date_of_joining);
            $curDate = date_create(date('Y-m-d'));
            $interval = date_diff($dateOFjoining, $curDate);
            $NumOfDaysJoining = $interval->format('%R%a');
            
            if($NumOfDaysJoining <= $emp_days_from_joining){
               $FormAccess_Right = '1';
               $FormAccessFor = '1';
                
            }
            
            
         /*
          * Case : Benial Declaration
          */   
            $cur_Date = strtotime(date('Y-m-d'));
            if(($emp_decl_start_date <= $cur_Date) && ($emp_decl_end_date >= $cur_Date)){
                 $FormAccess_Right = '1';
                 $FormAccessFor = '2';
            }
           
         /*
         * Case : Rejected by Commission
         */    
           if((($commi_decl_start_date <= $cur_Date) && ($commi_decl_end_date >= $cur_Date)) && ($DeclarationStatus == '1')) {
                 
                 $FormAccess_Right = '1';
                 $FormAccessFor = '2';
                 
            }
             
            
        /*
         * Case : Final Declaration 
         */ 
            if($EmployeeDefinition['0']['CAEmployeeDefinition']['date_of_exit'] != ''){
            $dateOFexit = date_create($date_of_exit);
            $curDate = date_create(date('Y-m-d'));
            $interval = date_diff($dateOFexit, $curDate);
            $NumOfDaysExit = $interval->format('%R%a');
            
            if($NumOfDaysExit <= $emp_days_from_exit){
               $FormAccess_Right = '1';
               $FormAccessFor = '3';
            }  
          }
         
          if(isset($FormAccess_Right) && $FormAccess_Right == '0' && $emp_difin_id!=null){ 
             $this->redirect('emp_definition');
          }
          
          
        ////////////////////////////////End///////////////////////////
        
        
        if ($assetID != null && $del == 'del') {
            $Del_ass = $this->CAWealthAssets->updateAll(array('CAWealthAssets.status' => "1"), array('CAWealthAssets.id' => $assetID));

            if ($Del_ass) {
                $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert="">
                    <a href="#" class="uk-alert-close uk-close"></a>Assetus Deleted !</div>');
            } else {
                $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert="">
                    <a href="#" class="uk-alert-close uk-close"></a>Sorry, Not Deleted !</div>');
            }
            $this->redirect('emp_wealthdeclaration/' . $emp_difin_id);
        }


        if (isset($this->request->data['submit']) && $this->request->data['submit'] != '') {
            
            $curDate = date('Y');
            $couter_result = $this->CAWealthdeclaration->query("Select count(id) as total,id from ca_wealthdeclaration where declaration_status='0' and emp_difini_id='".$this->request->data['emp_difin_id']."' and declaration_type='".$this->request->data['declar_type']."' and EXTRACT(YEAR FROM declaration_date)='".$curDate."'");
            $cout_result = $couter_result[0][0]['total'];
            $welID = $couter_result[0]['ca_wealthdeclaration']['id'];
//            echo "<pre>";
//            print_r($this->request->data);die
//            echo "<pre>";
//            print_r($this->request->data);
//            die;
            if($cout_result > 0 ){
                    $data['CAWealthdeclaration']['id'] = $welID;
            
            $data['CAWealthdeclaration']['emp_difini_id'] = $this->request->data['emp_difin_id'];
            $data['CAWealthdeclaration']['financial_statement'] = $this->request->data['financial_stmnt'];
            $data['CAWealthdeclaration']['satement_date'] = date("Y-m-d", strtotime($this->request->data['stmnt_date']));
            if ($this->request->data['from_date'] != '') {
                $data['CAWealthdeclaration']['period_from'] = date("Y-m-d", strtotime($this->request->data['from_date']));
            }
            if ($this->request->data['to_date'] != '') {
                $data['CAWealthdeclaration']['period_to'] = date("Y-m-d", strtotime($this->request->data['to_date']));
            }
            $data['CAWealthdeclaration']['other_info'] = $this->request->data['info'];
            $data['CAWealthdeclaration']['declaration_type'] = $this->request->data['declar_type'];
            $data['CAWealthdeclaration']['declaration_date'] = date("Y-m-d", strtotime($this->request->data['declar_date']));

            $success = $this->CAWealthdeclaration->save($data);
            //$welID = $this->request->data['wealthdecla_id'];
            
            
            if(count($this->request->data['wealth_dependent_id']) > 0){
                      $this->CAWealthdeclarationDependents->deleteAll(array('wealthdeclaration_id' => $welID));
                        for($n = 0 ; $n < count($this->request->data['wealth_dependent_id']); $n++ ){
                            
                        $data['CAWealthdeclarationDependents']['wealthdeclaration_id'] = $welID;
                        $data['CAWealthdeclarationDependents']['dependents_id'] = $this->request->data['wealth_dependent_id'][$n];
                        $data['CAWealthdeclarationDependents']['wealth_dependent_type'] = $this->request->data['wealth_dependent_type'][$n];
                        $data['CAWealthdeclarationDependents']['wealth_dependent_status'] = '1';
                        
                        $this->CAWealthdeclarationDependents->create();
                        $success_dep = $this->CAWealthdeclarationDependents->save($data);
                    
                        }
                        
                    }
            
            
                if ($this->request->data['ComplianceAudit']['wealth_depnd_type'] == '0' || $this->request->data['ComplianceAudit']['wealth_depnd_type'] == '1' || $this->request->data['ComplianceAudit']['wealth_depnd_type']=='2') {
                
                    if($this->request->data['ComplianceAudit']['wealth_depnd_type'] == '0'){
                        $this->CAWealthAssets->deleteAll(array('wealth_dependent_type'=>'0','declaration_type'=>$this->request->data['declar_type'],'wealthdeclaration_id'=>$welID));
                    }elseif($this->request->data['ComplianceAudit']['wealth_depnd_type'] == '1'){
                        $this->CAWealthAssets->deleteAll(array('wealth_dependent_type'=>'1','declaration_type'=>$this->request->data['declar_type'],'wealthdeclaration_id'=>$welID));
                    }if($this->request->data['ComplianceAudit']['wealth_depnd_type'] == '2'){
                        $this->CAWealthAssets->deleteAll(array('wealth_dependent_type'=>'2','declaration_type'=>$this->request->data['declar_type'],'wealthdeclaration_id'=>$welID));
                    }
                    
                    
                    $TotFormAssetsCount1 = $this->request->data['tot_form'];
                
                for ($k = 1; $k <= ($TotFormAssetsCount1-1); $k++) {
                    $AssetsCount1 = $this->request->data['ComplianceAudit']['rowCount1-'.$k];
                    for ($i1 = 0; $i1 < ($AssetsCount1-1); $i1++) {
                        $Assetdata1['CAWealthAssets']['wealthdeclaration_id'] = $welID;
                        $Assetdata1['CAWealthAssets']['declaration_type'] = $this->request->data['declar_type'];
                        $Assetdata1['CAWealthAssets']['wealth_dependent_type'] = $this->request->data['ComplianceAudit']['wealth_depnd_type'];
                        $Assetdata1['CAWealthAssets']['declare_dependent_type'] = $this->request->data['ComplianceAudit']['declar_depend_type'.$k];
                        $Assetdata1['CAWealthAssets']['emp_difini_id'] = $this->request->data['emp_difin_id'];
                        $Assetdata1['CAWealthAssets']['assets_for'] = '1';
                        $Assetdata1['CAWealthAssets']['description'] = $this->request->data['ComplianceAudit']['desc_1_'.$k][$i1];
                        $Assetdata1['CAWealthAssets']['approx_amount'] = $this->request->data['ComplianceAudit']['aprox_amt_1_'.$k][$i1];
                        $Assetdata1['CAWealthAssets']['created_by'] = $empID;
                       
                        
                        $this->CAWealthAssets->create();
                        $this->CAWealthAssets->save($Assetdata1);
                        }
                        
                        
                        $AssetsCount2 = $this->request->data['ComplianceAudit']['rowCount2-'.$k];
                    for ($i2 = 0; $i2 < ($AssetsCount2-1); $i2++) {
                        $Assetdata2['CAWealthAssets']['wealthdeclaration_id'] = $welID;
                        $Assetdata2['CAWealthAssets']['wealth_dependent_type'] = $this->request->data['ComplianceAudit']['wealth_depnd_type'];
                        $Assetdata2['CAWealthAssets']['declaration_type'] = $this->request->data['declar_type'];
                        $Assetdata2['CAWealthAssets']['declare_dependent_type'] = $this->request->data['ComplianceAudit']['declar_depend_type'.$k];
                        $Assetdata2['CAWealthAssets']['emp_difini_id'] = $this->request->data['emp_difin_id'];
                        $Assetdata2['CAWealthAssets']['assets_for'] = '2';
                        $Assetdata2['CAWealthAssets']['description'] = $this->request->data['ComplianceAudit']['desc_2_'.$k][$i2];
                        $Assetdata2['CAWealthAssets']['approx_amount'] = $this->request->data['ComplianceAudit']['aprox_amt_2_'.$k][$i2];
                        $Assetdata2['CAWealthAssets']['created_by'] = $empID;

                        $this->CAWealthAssets->create();
                        $this->CAWealthAssets->save($Assetdata2);
                        }
                        
                        $AssetsCount3 = $this->request->data['ComplianceAudit']['rowCount3-'.$k];
                    for ($i3 = 0; $i3 < ($AssetsCount3-1); $i3++) {
                        $Assetdata3['CAWealthAssets']['wealthdeclaration_id'] = $welID;
                        $Assetdata3['CAWealthAssets']['wealth_dependent_type'] = $this->request->data['ComplianceAudit']['wealth_depnd_type'];
                        $Assetdata3['CAWealthAssets']['declaration_type'] = $this->request->data['declar_type'];
                        $Assetdata3['CAWealthAssets']['declare_dependent_type'] = $this->request->data['ComplianceAudit']['declar_depend_type'.$k];
                        $Assetdata3['CAWealthAssets']['emp_difini_id'] = $this->request->data['emp_difin_id'];
                        $Assetdata3['CAWealthAssets']['assets_for'] = '3';
                        $Assetdata3['CAWealthAssets']['description'] = $this->request->data['ComplianceAudit']['desc_3_'.$k][$i3];
                        $Assetdata3['CAWealthAssets']['approx_amount'] = $this->request->data['ComplianceAudit']['aprox_amt_3_'.$k][$i3];
                        $Assetdata3['CAWealthAssets']['created_by'] = $empID;

                        $this->CAWealthAssets->create();
                        $this->CAWealthAssets->save($Assetdata3);
                        }
                }
                
            }
                
            }else{
                      
                    $data['CAWealthdeclaration']['emp_difini_id'] = $this->request->data['emp_difin_id'];
                    $data['CAWealthdeclaration']['financial_statement'] = $this->request->data['financial_stmnt'];
                    $data['CAWealthdeclaration']['satement_date'] = date("Y-m-d", strtotime($this->request->data['stmnt_date']));
                    if ($this->request->data['from_date'] != '') {
                        $data['CAWealthdeclaration']['period_from'] = date("Y-m-d", strtotime($this->request->data['from_date']));
                    }
                    if ($this->request->data['to_date'] != '') {
                        $data['CAWealthdeclaration']['period_to'] = date("Y-m-d", strtotime($this->request->data['to_date']));
                    }
                    $data['CAWealthdeclaration']['other_info'] = $this->request->data['info'];
                    $data['CAWealthdeclaration']['declaration_type'] = $this->request->data['declar_type'];
                    $data['CAWealthdeclaration']['declaration_date'] = date("Y-m-d", strtotime($this->request->data['declar_date']));

                    $success = $this->CAWealthdeclaration->save($data);
                    $welID = $this->CAWealthdeclaration->getLastInsertID();
                    
                    if(count($this->request->data['wealth_dependent_id']) > 0){
                      
                        for($n = 0 ; $n < count($this->request->data['wealth_dependent_id']); $n++ ){
                            
                        $data['CAWealthdeclarationDependents']['wealthdeclaration_id'] = $welID;
                        $data['CAWealthdeclarationDependents']['dependents_id'] = $this->request->data['wealth_dependent_id'][$n];
                        $data['CAWealthdeclarationDependents']['wealth_dependent_type'] = $this->request->data['wealth_dependent_type'][$n];
                        $data['CAWealthdeclarationDependents']['wealth_dependent_status'] = '1';
                        
                        $this->CAWealthdeclarationDependents->create();
                        $success_depnd = $this->CAWealthdeclarationDependents->save($data);
                    
                        }
                        
                    }
                    
                     if ($this->request->data['ComplianceAudit']['wealth_depnd_type'] == '0' || $this->request->data['ComplianceAudit']['wealth_depnd_type'] == '1' || $this->request->data['ComplianceAudit']['wealth_depnd_type']=='2') {
                $TotFormAssetsCount1 = $this->request->data['tot_form'];
                
                for ($k = 1; $k <= ($TotFormAssetsCount1-1); $k++) {
                    $AssetsCount1 = $this->request->data['ComplianceAudit']['rowCount1-'.$k];
                    for ($i1 = 0; $i1 < ($AssetsCount1-1); $i1++) {
                        $Assetdata1['CAWealthAssets']['wealthdeclaration_id'] = $welID;
                        $Assetdata1['CAWealthAssets']['wealth_dependent_type'] = $this->request->data['ComplianceAudit']['wealth_depnd_type'];
                        $Assetdata1['CAWealthAssets']['declaration_type'] = $this->request->data['declar_type'];
                        $Assetdata1['CAWealthAssets']['declare_dependent_type'] = $this->request->data['ComplianceAudit']['declar_depend_type'.$k];
                        $Assetdata1['CAWealthAssets']['emp_difini_id'] = $this->request->data['emp_difin_id'];
                        $Assetdata1['CAWealthAssets']['assets_for'] = '1';
                        $Assetdata1['CAWealthAssets']['description'] = $this->request->data['ComplianceAudit']['desc_1_'.$k][$i1];
                        $Assetdata1['CAWealthAssets']['approx_amount'] = $this->request->data['ComplianceAudit']['aprox_amt_1_'.$k][$i1];
                        $Assetdata1['CAWealthAssets']['created_by'] = $empID;
                       
                        
                        $this->CAWealthAssets->create();
                        $this->CAWealthAssets->save($Assetdata1);
                        }
                        
                        
                        $AssetsCount2 = $this->request->data['ComplianceAudit']['rowCount2-'.$k];
                    for ($i2 = 0; $i2 < ($AssetsCount2-1); $i2++) {
                        $Assetdata2['CAWealthAssets']['wealthdeclaration_id'] = $welID;
                        $Assetdata2['CAWealthAssets']['wealth_dependent_type'] = $this->request->data['ComplianceAudit']['wealth_depnd_type'];
                        $Assetdata2['CAWealthAssets']['declaration_type'] = $this->request->data['declar_type'];
                        $Assetdata2['CAWealthAssets']['declare_dependent_type'] = $this->request->data['ComplianceAudit']['declar_depend_type'.$k];
                        $Assetdata2['CAWealthAssets']['emp_difini_id'] = $this->request->data['emp_difin_id'];
                        $Assetdata2['CAWealthAssets']['assets_for'] = '2';
                        $Assetdata2['CAWealthAssets']['description'] = $this->request->data['ComplianceAudit']['desc_2_'.$k][$i2];
                        $Assetdata2['CAWealthAssets']['approx_amount'] = $this->request->data['ComplianceAudit']['aprox_amt_2_'.$k][$i2];
                        $Assetdata2['CAWealthAssets']['created_by'] = $empID;

                        $this->CAWealthAssets->create();
                        $this->CAWealthAssets->save($Assetdata2);
                        }
                        
                        $AssetsCount3 = $this->request->data['ComplianceAudit']['rowCount3-'.$k];
                    for ($i3 = 0; $i3 < ($AssetsCount3-1); $i3++) {
                        $Assetdata3['CAWealthAssets']['wealthdeclaration_id'] = $welID;
                        $Assetdata3['CAWealthAssets']['wealth_dependent_type'] = $this->request->data['ComplianceAudit']['wealth_depnd_type'];
                        $Assetdata3['CAWealthAssets']['declaration_type'] = $this->request->data['declar_type'];
                        $Assetdata3['CAWealthAssets']['declare_dependent_type'] = $this->request->data['ComplianceAudit']['declar_depend_type'.$k];
                        $Assetdata3['CAWealthAssets']['emp_difini_id'] = $this->request->data['emp_difin_id'];
                        $Assetdata3['CAWealthAssets']['assets_for'] = '3';
                        $Assetdata3['CAWealthAssets']['description'] = $this->request->data['ComplianceAudit']['desc_3_'.$k][$i3];
                        $Assetdata3['CAWealthAssets']['approx_amount'] = $this->request->data['ComplianceAudit']['aprox_amt_3_'.$k][$i3];
                        $Assetdata3['CAWealthAssets']['created_by'] = $empID;

                        $this->CAWealthAssets->create();
                        $this->CAWealthAssets->save($Assetdata3);
                        }
                     }
                  }
            }
            
            
            
            
            

            if ($success) {
                
                 $From = "megha.yadav@essindia.com";
                 //$UserMailID = $this->Common->getWealthEmpEmialID($this->request->data['emp_difin_id']);////make enable when going live....
                 $UserMailID = "abhishek.verma@essindia.com"; //// make it comment when going live....
                 $ManagerMailID = "bajrangi.srivastava@essindia.com";       //// make it comment when going live....

                  $To = $UserMailID;
                  //$CC = $ManagerMailID;
//                $CC = "";
                  $sub = "Wealth Declaration !";
                  $msg = "Now, Your wealth declaration submited! ";
                  $template = 'wealth_declaration';

                 $this->send_mail($From, $To, $CC, $sub, $msg, $template, $data);

                 $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                    <a href="#" class="uk-alert-close uk-close"></a>Employee Wealth Declaration Entered Successfully !</div>');
            } else {
                $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert="">
                    <a href="#" class="uk-alert-close uk-close"></a>Sorry, Wealth Declaration Not Entered !</div>');
            }
            $this->redirect('emp_definition');
        }

        
        
        
//       echo "<pre>";
//       print_r($EmpWealthDecla);die;

        $this->set(compact('EmployeeDefinition','FormAccessFor', 'StatmentDate','empID', 'EmpWealthDecla', 'emp_difin_id'));
    }

    public function show_wealth_declaration($emp_difin_id) {
        // Configure::write('debug',2);
        $auth = $this->Session->read('Auth');
        $empID = $auth['MyProfile']['id'];

        $EmpWealthDecla = $this->CAWealthdeclaration->find('all', array(
            'conditions' => array('CAWealthdeclaration.status' => '0', 'CAWealthdeclaration.emp_difini_id' => $emp_difin_id),
            'group by' => 'CAWealthdeclaration.emp_difini_id',
            'order' => array('CAWealthdeclaration.declaration_type' => 'ASC')
        ));
        
//               echo "<pre>";
//       print_r($EmpWealthDecla);die;
        
        $this->set(compact('EmpWealthDecla','response'));
    }
    
    public function comment_emp_wealthdeclaration($emp_difin_id) {
        // Configure::write('debug',2);
        $this->layout = 'employee-new';
        $auth = $this->Session->read('Auth');
        $empID = $auth['MyProfile']['id'];
        $emp_difin_id = base64_decode($emp_difin_id);
        
        
        
        $decl_Date = $this->CADeclarationDate->find("all",array(
            'conditions' => array(
                'CADeclarationDate.status' => '0'),
        ));
        
//        echo "<pre>";
//        print_r($decl_Date);die;
        
        $commi_decl_start_date = strtotime(date("Y-m-d", strtotime($decl_Date['0']['CADeclarationDate']['commission_from'])));
        $commi_decl_end_date = strtotime(date("Y-m-d", strtotime($decl_Date['0']['CADeclarationDate']['commission_to'])));
//        $emp_days_from_joining = $decl_Date['0']['CADeclarationDate']['days_from_joining'];
//        $emp_days_from_exit = $decl_Date['0']['CADeclarationDate']['days_from_exit'];
//        
//        $date_of_joining = date("Y-m-d", strtotime($EmployeeDefinition['0']['CAEmployeeDefinition']['date_of_joining']));
//       if($EmployeeDefinition['0']['CAEmployeeDefinition']['date_of_exit'] != ''){
//        $date_of_exit = date("Y-m-d", strtotime($EmployeeDefinition['0']['CAEmployeeDefinition']['date_of_exit']));
//       }
        
        $FormAccessRight = '0';
        
       /*
        * Case : Initial Declaration
        */
        
//            $dateOFjoining = date_create($date_of_joining);
//            $curDate = date_create(date('Y-m-d'));
//            $interval = date_diff($dateOFjoining, $curDate);
//            $NumOfDaysJoining = $interval->format('%R%a');
//            
//            if($NumOfDaysJoining <= $emp_days_from_joining){
//               $FormAccessRight = '1';
//                
//            }
            
            
         /*
          * Case : Benial Declaration
          */   
            $cur_Date = strtotime(date('Y-m-d'));
            if(($commi_decl_start_date <= $cur_Date) && ($commi_decl_end_date >= $cur_Date)){
                 $FormAccessRight = '1';
             
            }else{
                $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert="">
                    <a href="#" class="uk-alert-close uk-close"></a>Sorry, Access Denied!</div>');
               $this->redirect('emp_all_wealth_declaration');
            }
           
            
        /*
         * Case : Final Declaration 
         */ 
//            if($EmployeeDefinition['0']['CAEmployeeDefinition']['date_of_exit'] != ''){
//            $dateOFexit = date_create($date_of_exit);
//            $curDate = date_create(date('Y-m-d'));
//            $interval = date_diff($dateOFexit, $curDate);
//            $NumOfDaysExit = $interval->format('%R%a');
//            
//            if($NumOfDaysExit <= $emp_days_from_exit){
//               $FormAccessRight = '1';
//            }  
//          }
        ////////////////////////////////End///////////////////////////

          
        
        
        
        
        
        if (isset($this->request->data['submit']) && $this->request->data['submit'] != '') {
//             echo "<pre>";
//       print_r($this->request->data);die;
       
       
            $data['CAWealthdeclaration']['id'] = $this->request->data['wealthdeclaration_id'];
            $data['CAWealthdeclaration']['commission_feedback'] = $this->request->data['feedback'];
            $data['CAWealthdeclaration']['declaration_status'] = $this->request->data['declaration_status'];
            
            $success = $this->CAWealthdeclaration->save($data);

            if ($success) {
               if($this->request->data['declaration_status'] == '1'){
                 $From = "megha.yadav@essindia.com";
                 //$UserMailID = $this->Common->getWealthEmpEmialID($this->request->data['emp_difin_id']);////make enable when going live....
                 $UserMailID = "abhishek.verma@essindia.com"; //// make it comment when going live....
                 $ManagerMailID = "bajrangi.srivastava@essindia.com";       //// make it comment when going live....

                  $To = $UserMailID;
                  $CC = $ManagerMailID;
//                $CC = "";
                  $sub = "Wealth Declaration !";
                  $msg = "Please go for wealth declaration ! ".$this->request->data['feedback'];
                  $template = 'wealth_declaration';

                 $this->send_mail($From, $To, $CC, $sub, $msg, $template, $data);
               }
                $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                    <a href="#" class="uk-alert-close uk-close"></a>Feedback send successfully !</div>');
            } else {
                $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert="">
                    <a href="#" class="uk-alert-close uk-close"></a>Sorry, Feedback Not Send!</div>');
            }
            $this->redirect('emp_all_wealth_declaration');
       
        }
        $wealthdeclarType = $this->CAWealthdeclaration->query("Select declaration_type from ca_wealthdeclaration where status=0 and emp_difini_id='".$emp_difin_id."' order by declaration_type desc limit 0,1");
        $wealthdeclar_Type = $wealthdeclarType[0]['ca_wealthdeclaration']['declaration_type'];
        
        $EmpWealthDecla = $this->CAWealthdeclaration->find('all', array(
            'conditions' => array('CAWealthdeclaration.declaration_status' => '0', 'CAWealthdeclaration.emp_difini_id' => $emp_difin_id,'CAWealthdeclaration.declaration_type' => $wealthdeclar_Type),
        ));
        
//        $EmpWealthDecla = $this->CAWealthdeclaration->find('all', array(
//            'conditions' => array('CAWealthdeclaration.status' => '0', 'CAWealthdeclaration.emp_difini_id' => $emp_difin_id),
//            'group by' => 'CAWealthdeclaration.emp_difini_id'
//        ));
        
        $EmployeeDefinition = $this->CAEmployeeDefinition->find('all', array(
            'conditions' => array('CAEmployeeDefinition.status' => '0', 'CAEmployeeDefinition.id' => $emp_difin_id),
            'order' => 'CAEmployeeDefinition.id desc'
        ));
        
//               echo "<pre>";
//       print_r($EmpWealthDecla);die;
        
        $this->set(compact('EmpWealthDecla','response','emp_difin_id','wealthdeclar_Type'));
    }
    public function emp_definition_save($existid = null) {
       // Configure::write('debug',2);
        $this->layout = 'employee-new';
        $auth = $this->Session->read('Auth');
        $empID = $auth['MyProfile']['id'];
        
        

        if ($existid == '') {
            $result = $this->CAEmployeeDefinition->query("Select count(id) as total from ca_employee_definition where status=0 and created_by='" . $empID . "'");

            $total = $result[0][0]['total'];
            if ($total > 0) {
                $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert="">
                      <a href="#" class="uk-alert-close uk-close"></a>You already fill the details, Please go for edit !!</div>');
                $this->redirect('emp_definition');
            }
        }



        if (isset($this->request->data['submit']) && $this->request->data['submit'] != '') {
//            echo "<pre>";
//            print_r($this->request->data);
            if($this->request->data['doe']!=''){
                $doe = date("Y-m-d", strtotime($this->request->data['doe']));
            }else{
                $doe = '';
            }
            $data['CAEmployeeDefinition']['type_of_organisation'] = $this->request->data['t_o_org'];
            $data['CAEmployeeDefinition']['ministry_id'] = $this->request->data['ministry'];
            $data['CAEmployeeDefinition']['organisation_id'] = '';
            $data['CAEmployeeDefinition']['organisation_name'] = $this->request->data['orgname'];
            $data['CAEmployeeDefinition']['nature_of_employment'] = $this->request->data['nature_employment'];
            $data['CAEmployeeDefinition']['employment_number'] = $this->request->data['employment_number'];
            $data['CAEmployeeDefinition']['department_id'] = $this->request->data['department'];
            $data['CAEmployeeDefinition']['kra_pin'] = $this->request->data['kra_pin'];
            $data['CAEmployeeDefinition']['id_number'] = $this->request->data['id_number'];
            $data['CAEmployeeDefinition']['salutation'] = $this->request->data['salutation'];
            $data['CAEmployeeDefinition']['first_name'] = $this->request->data['fname'];
            $data['CAEmployeeDefinition']['surname'] = $this->request->data['srname'];
            $data['CAEmployeeDefinition']['othername'] = $this->request->data['oth_name'];
            $data['CAEmployeeDefinition']['designation_id'] = $this->request->data['designation'];
            $data['CAEmployeeDefinition']['date_of_joining'] = date("Y-m-d", strtotime($this->request->data['doj']));
            $data['CAEmployeeDefinition']['date_of_exit'] = $doe;
            $data['CAEmployeeDefinition']['gender'] = $this->request->data['doc']['gender'];
            $data['CAEmployeeDefinition']['dob'] = date("Y-m-d", strtotime($this->request->data['dob']));
            $data['CAEmployeeDefinition']['place_of_birth'] = $this->request->data['pob'];
            $data['CAEmployeeDefinition']['marital_status'] = $this->request->data['marital_status'];
            $data['CAEmployeeDefinition']['official_email'] = $this->request->data['email'];
            $data['CAEmployeeDefinition']['emp_mobile'] = $this->request->data['mobile'];
            $data['CAEmployeeDefinition']['physical_add'] = $this->request->data['phy_add'];
            $data['CAEmployeeDefinition']['postal_add'] = $this->request->data['post_add'];
            $data['CAEmployeeDefinition']['emp_status'] = $this->request->data['doc']['emp_status'];
            $data['CAEmployeeDefinition']['created_by'] = $empID;
           
            
             
            
            $success = $this->CAEmployeeDefinition->save($data);

            if ($success) {
               
//                $From = "ayush.pant@essindia.com";
//                //$manager_ID = $this->Common->getManagerCodeByID($UserID);
//                //$ManagerMailID = $this->Common->getUserEmailByID($manager_ID);////make enable when going live....
//                //$UserMailID = $this->Common->getUserEmailByID($UserID);
//                $UserMailID = "bajrangi.srivastava@essindia.com"; //// make it comment when going live....
//                $ManagerMailID = "ayush.pant@essindia.com";       //// make it comment when going live....
//
//
//                $To = $UserMailID;
//                $CC = $ManagerMailID;
//                $CC = "";
//                $sub = "Your Details Entered!";
//                $msg = "Now, You are registed to fill the wealth declaration ! ";
//                $template = 'bm_req_receive';
//
//                $this->Common->send_mail($From, $To, $CC, $sub, $msg, $template, $data);
                
                $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                    <a href="#" class="uk-alert-close uk-close"></a>Employee Details entered successfully !</div>');
            } else {
                $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert="">
                    <a href="#" class="uk-alert-close uk-close"></a>Sorry, Details Not Entered !</div>');
            }
            $this->redirect('emp_definition');
        }


        $Ministry = $this->Ministry->find('list', array('fields' => 'ministry_name',
            'conditions' => array('ministry_status' => '1')));
//         
//         $department = $this->Departments->find('list', array(
//            'fields' => array('Departments.dept_code', 'Departments.dept_name'),
//            'conditions' => array('Departments.status' => '1')
//        ));
//        
//         $EmpDefinition = $this->CAEmployeeDefinition->find('all', array(
//            'conditions' => array('CAEmployeeDefinition.status' => '0')
//        ));


        $this->set(compact('allRecReq', 'empID', 'Ministry'));
    }

    public function compliant_invest_save($existid = null) {
        //Configure::write('debug',2);
        $this->layout = 'employee-new';
        $auth = $this->Session->read('Auth');
        $empID = $auth['MyProfile']['id'];


        if (isset($this->request->data['submit']) && $this->request->data['submit'] != '') {

//            echo "<pre>";
//            print_r($this->request->data);die;
            $data['CAInvestigation']['compliant_category'] = $this->request->data['comp_category'];
            $data['CAInvestigation']['case_no'] = $this->request->data['case_no'];
            $data['CAInvestigation']['compliant_type'] = $this->request->data['comp_type'];
            $data['CAInvestigation']['compliant_designation'] = $this->request->data['compl_designation'];
            $data['CAInvestigation']['compliant_entity'] = $this->request->data['entity_compl'];
            $data['CAInvestigation']['info_name'] = $this->request->data['person_name'];
            $data['CAInvestigation']['info_mobile'] = $this->request->data['info_mobile'];
            $data['CAInvestigation']['info_email'] = $this->request->data['info_mail'];
            $data['CAInvestigation']['compliant_description'] = $this->request->data['compl_desc'];
            $data['CAInvestigation']['id_details_type'] = $this->request->data['id_detail_type'];
            $data['CAInvestigation']['id_details'] = $this->request->data['id_details'];
            $data['CAInvestigation']['date_of_compliant'] = date("Y-m-d", strtotime($this->request->data['doc']));
            $data['CAInvestigation']['date_of_compliant_received'] = date("Y-m-d", strtotime($this->request->data['docr']));
            $data['CAInvestigation']['mode_of_compliant_received'] = $this->request->data['complian_mode'];
            $data['CAInvestigation']['department'] = $this->request->data['department'];
            $data['CAInvestigation']['email'] = $this->request->data['email'];
            $data['CAInvestigation']['postal_add'] = $this->request->data['postal_add'];
            $data['CAInvestigation']['phone_number'] = $this->request->data['mobile'];
            $data['CAInvestigation']['created_by'] = $empID;

            $success = $this->CAInvestigation->save($data);
            $complID = $this->CAInvestigation->getLastInsertID();
            if ($complID > 0) {

                $FILE_UPNAME = str_replace(".", "", substr($this->request->data['receive_doc']['name'], 0, -4));
                $filecheck = basename($this->request->data['receive_doc']['name']);
                $ext = strtolower(substr($filecheck, strrpos($filecheck, '.') + 1));
                $file__name = $FILE_UPNAME . "-" . date("dmYHis") . "." . $ext;
                $filename = str_replace(" ", "", $file__name);

                $data['CAComplianDoc']['complian_invest_id'] = $complID;
                $data['CAComplianDoc']['file'] = $filename;
                $data['CAComplianDoc']['file_real_name'] = $this->request->data['receive_doc']['name'];
                $data['CAComplianDoc']['doc_status'] = '1';


                $filePath = WWW_ROOT . 'ca_investigation' . DS . $filename;
                chmod($filePath, 0777);
                $filevalidation = '0';
                $valdMSG = "";
                if (!is_file($filePath)) {

                    if (!($ext == 'pdf' || $ext == 'jpg' || $ext == 'jpeg' || $ext == 'png' || $ext == 'txt' || $ext == 'doc' || $ext == 'docx' || $ext == 'xlsx' || $ext == 'xls') || ($this->request->data['upl_doc']['size'] > 2048000)) {
                        if ($this->request->data['receive_doc']['size'] > 2048000) {
                            $filevalidation = '1';
                            $valdMSG = "Sorry, uploaded file is invalid, please check the size !";
                            //$this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert=""><a href="#" class="uk-alert-close uk-close"></a>Sorry, this is invalid file, please check the size !</div>');
                        }elseif(!($ext == 'pdf' || $ext == 'jpg' || $ext == 'png' || $ext == 'txt' || $ext == 'doc' || $ext == 'docx' || $ext == 'xlsx' || $ext == 'xls') && $ext != '') {
                           echo  $filevalidation = '2';
                           echo  $valdMSG = "Sorry, uploaded file is invalid, please check the extention !";
                           die; //$this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert=""><a href="#" class="uk-alert-close uk-close"></a>Sorry, this is invalid file, please check the extention !</div>');
                        }
                    } else {
                        if ($this->CAComplianDoc->save($data)) {
                            if (move_uploaded_file($this->request->data['receive_doc']['tmp_name'], $filePath)){
                             $filevalidation = '3';
                             $valdMSG = "";
                               // $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert=""><a href="#" class="uk-alert-close uk-close"></a>Your file has been uploaded successfully!</div>');
                            }else{
                                $filevalidation = '4';
                            $valdMSG = "Your file uploading failed!";
                               // $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert=""><a href="#" class="uk-alert-close uk-close"></a>Your file uploading failed!</div>');
                            }
                        }
                    }
                }else {
                    $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert=""><a href="#" class="uk-alert-close uk-close"></a>Sorry, this file is already exist!</div>');
                }
            }

            if ($success) {
                
                $From = "megha.yadav@essindia.com";
                 //$UserMailID = $this->request->data['email'];////make enable when going live....
                 $UserMailID = "abhishek.verma@essindia.com"; //// make it comment when going live....
                 $ManagerMailID = "bajrangi.srivastava@essindia.com";       //// make it comment when going live....

                  $To = $UserMailID;
                  $CC = $ManagerMailID;
//                $CC = "";
                  $sub = "Compliant Registration!";
                  $msg = "Now, Your compliant saved submited! ";
                  $template = 'wealth_declaration';

                 $this->send_mail($From, $To, $CC, $sub, $msg, $template, $data);
                if($filevalidation == '0'){
                    $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                    <a href="#" class="uk-alert-close uk-close"></a>Complaint Details entered successfully!</div>');
                }else{
                    $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                    <a href="#" class="uk-alert-close uk-close"></a>Complaint Details entered successfully, '.$valdMSG.'!</div>');
                }
                
            } else {
                $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert="">
                    <a href="#" class="uk-alert-close uk-close"></a>Sorry, Details Not Entered !</div>');
            }
            $this->redirect('compliant_investigation');
        }

        
         $lastId = $this->CAInvestigation->find('first', array('fields' => array('id','case_no'),
               // 'conditions' => array('status' => '0'),
                'order' => array('id' => 'DESC')
            )); 
          
          
          /////////If Year change then serial no. start from 1//////////////
          
          $lastSerialNo = substr($lastId['CAInvestigation']['case_no'],12);
          $slNo = explode("/", $lastId['CAInvestigation']['case_no']);
          $lastSerialYear = $slNo['1'];
          if(date('Y') > $lastSerialYear){
              $lastSerialNo = 0;
          }
          
            if(count($lastId)==0){$lastId =1;}else{$lastId = ($lastSerialNo+1);}
            $this->set('SerialNo','PSC-'.date('m/Y').'/'.str_pad($lastId, 5, '0', STR_PAD_LEFT));

        
        
        
        
        
        $Ministry = $this->Ministry->find('list', array('fields' => 'ministry_name',
            'conditions' => array('ministry_status' => '1')));
//         
//         $department = $this->Departments->find('list', array(
//            'fields' => array('Departments.dept_code', 'Departments.dept_name'),
//            'conditions' => array('Departments.status' => '1')
//        ));
//        
//         $EmpDefinition = $this->CAEmployeeDefinition->find('all', array(
//            'conditions' => array('CAEmployeeDefinition.status' => '0')
//        ));


        $this->set(compact('allRecReq', 'empID', 'Ministry'));
    }
    
    public function compliant_invest_edit($complID = null, $del = null, $send = null) {
        //Configure::write('debug',2);
        $this->layout = 'employee-new';
        $auth = $this->Session->read('Auth');
        $empID = $auth['MyProfile']['id'];
        $manager_emp_code = $auth['MyProfile']['manager_code'];
        $complID = base64_decode($complID);



        if ($complID != '' && $del == 'del' && $send == null) {
            $compl_del = $this->CAInvestigation->updateAll(array('CAInvestigation.status' => "1"), array('CAInvestigation.id' => $complID));
            if ($compl_del) {
                $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert="">
                    <a href="#" class="uk-alert-close uk-close"></a>Complaint Deleted !</div>');
            } else {
                $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert="">
                    <a href="#" class="uk-alert-close uk-close"></a>Sorry, Not Deleted !</div>');
            }
            $this->redirect('compliant_investigation');
        }

        if ($complID != '' && $del == 'del' && $send == 'send') {
           
            $sendToCEO = $this->CAInvestigation->updateAll(array('CAInvestigation.current_status' => "0",'CAInvestigation.notify' => "1"), array('CAInvestigation.id' => $complID));
            if ($sendToCEO) {
                $this->Session->setFlash('<div class="uk-alert uk-alert-primery" data-uk-alert="">
                    <a href="#" class="uk-alert-close uk-close"></a>Complaint Send to CEO !</div>');
            } else {
                $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert="">
                    <a href="#" class="uk-alert-close uk-close"></a>Sorry, Not Send !</div>');
            }
            $this->redirect('compliant_investigation');
        }

        if (isset($this->request->data['submit']) && $this->request->data['submit'] != '') {

//            echo "<pre>";
//            print_r($this->request->data);die;
            $data['CAInvestigation']['id'] = $this->request->data['compliant_id'];
            $data['CAInvestigation']['compliant_category'] = $this->request->data['comp_category'];
            $data['CAInvestigation']['case_no'] = $this->request->data['case_no'];
            $data['CAInvestigation']['compliant_type'] = $this->request->data['comp_type'];
            $data['CAInvestigation']['compliant_designation'] = $this->request->data['compl_designation'];
            $data['CAInvestigation']['compliant_entity'] = $this->request->data['entity_compl'];
            $data['CAInvestigation']['info_name'] = $this->request->data['person_name'];
            $data['CAInvestigation']['info_mobile'] = $this->request->data['info_mobile'];
            $data['CAInvestigation']['info_email'] = $this->request->data['info_mail'];
            $data['CAInvestigation']['compliant_description'] = $this->request->data['compl_desc'];
            $data['CAInvestigation']['id_details_type'] = $this->request->data['id_detail_type'];
            $data['CAInvestigation']['id_details'] = $this->request->data['id_details'];
            $data['CAInvestigation']['date_of_compliant'] = date("Y-m-d", strtotime($this->request->data['doc']));
            $data['CAInvestigation']['date_of_compliant_received'] = date("Y-m-d", strtotime($this->request->data['docr']));
            $data['CAInvestigation']['mode_of_compliant_received'] = $this->request->data['complian_mode'];
            $data['CAInvestigation']['department'] = $this->request->data['entity_compl'];
            $data['CAInvestigation']['email'] = $this->request->data['email'];
            $data['CAInvestigation']['postal_add'] = $this->request->data['postal_add'];
            $data['CAInvestigation']['phone_number'] = $this->request->data['mobile'];
            $data['CAInvestigation']['created_by'] = $empID;
            
            
            
            
//            $data['CAInvestigation']['id'] = $this->request->data['compliant_id'];
//            $data['CAInvestigation']['compliant_category'] = $this->request->data['comp_category'];
//            $data['CAInvestigation']['compliant_description'] = $this->request->data['compl_desc'];
//            $data['CAInvestigation']['id_details_type'] = $this->request->data['id_detail_type'];
//            $data['CAInvestigation']['id_details'] = $this->request->data['id_detail'];
//            $data['CAInvestigation']['date_of_compliant'] = date("Y-m-d", strtotime($this->request->data['doc']));
//            $data['CAInvestigation']['date_of_compliant_received'] = date("Y-m-d", strtotime($this->request->data['docr']));
//            $data['CAInvestigation']['mode_of_compliant_received'] = $this->request->data['complian_mode'];
//            $data['CAInvestigation']['department'] = $this->request->data['department'];
//            $data['CAInvestigation']['email'] = $this->request->data['email'];
//            $data['CAInvestigation']['postal_add'] = $this->request->data['postal_add'];
//            $data['CAInvestigation']['phone_number'] = $this->request->data['mobile'];
//            $data['CAInvestigation']['created_by'] = $empID;

            $success = $this->CAInvestigation->save($data);
//            $complID = $this->CAInvestigation->getLastInsertID();
            $complID = $this->request->data['compliant_id'];
            if ($complID > 0) {
                
                //$file_replace = $this->CAComplianDoc->updateAll(array('CAComplianDoc.status' => "1"), array('CAComplianDoc.complian_invest_id' => $complID));

                $FILE_UPNAME = substr($this->request->data['receive_doc']['name'], 0, -4);
                $filecheck = basename($this->request->data['receive_doc']['name']);
                $ext = strtolower(substr($filecheck, strrpos($filecheck, '.') + 1));
                $file__name = $FILE_UPNAME . "-" . date("dmYHis") . "." . $ext;
                $filename = str_replace(" ", "", $file__name);

                $deletoldfile = $this->CAComplianDoc->updateAll(array('CAComplianDoc.doc_status' => "0"), array('CAComplianDoc.complian_invest_id' => $complID));
                $data['CAComplianDoc']['complian_invest_id'] = $complID;
                $data['CAComplianDoc']['file'] = $filename;
                $data['CAComplianDoc']['file_real_name'] = $this->request->data['receive_doc']['name'];
                $data['CAComplianDoc']['doc_status'] = '1';


                $filePath = WWW_ROOT . 'ca_investigation' . DS . $filename;

                if (!is_file($filePath)) {

                    if (!($ext == 'pdf' || $ext == 'jpg' || $ext == 'png' || $ext == 'txt' || $ext == 'doc' || $ext == 'docx') || ($this->request->data['upl_doc']['size'] > 2048000)) {
                        if ($this->request->data['receive_doc']['size'] > 2048000) {
                            $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert=""><a href="#" class="uk-alert-close uk-close"></a>Sorry, this is invalid file, please check the size !</div>');
                        } elseif (!($ext == 'pdf' || $ext == 'jpg' || $ext == 'png' || $ext == 'txt' || $ext == 'doc' || $ext == 'docx')) {
                            $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert=""><a href="#" class="uk-alert-close uk-close"></a>Sorry, this is invalid file, please check the extention !</div>');
                        }
                    } else {
                        if ($this->CAComplianDoc->save($data)) {
                            if (move_uploaded_file($this->request->data['receive_doc']['tmp_name'], $filePath))
                                $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert=""><a href="#" class="uk-alert-close uk-close"></a>Your file has been uploaded successfully!</div>');
                            else
                                $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert=""><a href="#" class="uk-alert-close uk-close"></a>Your file uploading failed!</div>');
                        }
                    }
                }else {
                    $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert=""><a href="#" class="uk-alert-close uk-close"></a>Sorry, this file is already exist!</div>');
                }
            }

            if ($success) {
                $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                    <a href="#" class="uk-alert-close uk-close"></a>Complaint Details Updated Successfully !</div>');
            } else {
                $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert="">
                    <a href="#" class="uk-alert-close uk-close"></a>Sorry, Details Not Entered !</div>');
            }
            $this->redirect('compliant_investigation');
        }


//        $Ministry = $this->Ministry->find('list', array('fields' => 'ministry_name',
//            'conditions' => array('ministry_status' => '1')));

        $Compliants = $this->CAInvestigation->find('all', array(
            'conditions' => array('CAInvestigation.status' => '0', 'CAInvestigation.id' => $complID)
        ));

        $this->set(compact('Compliants'));
    }
    
    public function compliant_invest_documents($complID = null) {
        //Configure::write('debug',2);
        $this->layout = 'employee-new';
        $auth = $this->Session->read('Auth');
        $empID = $auth['MyProfile']['id'];
        $manager_emp_code = $auth['MyProfile']['manager_code'];
        $complID = base64_decode($complID);



        if (isset($this->request->data['submit']) && $this->request->data['submit'] != '') {

//            echo "<pre>";
//            print_r($this->request->data);die;
            $complID = $this->request->data['compliant_id'];
            if ($complID > 0) {

                //$file_replace = $this->CAComplianDoc->updateAll(array('CAComplianDoc.status' => "1"), array('CAComplianDoc.complian_invest_id' => $complID));
                $err_files = '';
                for($i = '1' ; $i<='4' ;$i++){
                    $reqFile = '';
                    $reqtempFile = '';
                    $reqsizeFile = '';
                    if($i == '1'){
                     $reqFile =   $this->request->data['term_reference']['name'] ;
                     $reqtempFile =   $this->request->data['term_reference']['tmp_name'] ;
                     $reqsizeFile =   $this->request->data['term_reference']['tmp_name'] ;
                     $docType = $i;
                    }elseif($i == '2'){
                        $reqFile =   $this->request->data['letter_appointing']['name'] ;
                        $reqtempFile =   $this->request->data['letter_appointing']['tmp_name'] ;
                        $reqsizeFile =   $this->request->data['letter_appointing']['tmp_name'] ;
                        $docType = $i;
                    }elseif($i == '3'){
                        $reqFile =   $this->request->data['doc_evidence']['name'] ;
                        $reqtempFile =   $this->request->data['doc_evidence']['tmp_name'] ;
                        $reqsizeFile =   $this->request->data['doc_evidence']['tmp_name'] ;
                        $docType = $i;
                    }elseif($i == '4'){
                        $reqFile =   $this->request->data['invest_report']['name'] ;
                        $reqtempFile =   $this->request->data['invest_report']['tmp_name'] ;
                        $reqsizeFile =   $this->request->data['invest_report']['tmp_name'] ;
                        $docType = $i;
                        
                    }
                    if($reqFile != ''){
                $FILE_UPNAME = substr($reqFile, 0, -4);
                $filecheck = basename($reqFile);
                $ext = strtolower(substr($filecheck, strrpos($filecheck, '.') + 1));
                $file__name = $FILE_UPNAME . "-" . date("dmYHis") . "." . $ext;
                $filename = str_replace(" ", "", $file__name);


                $data['CAComplianDoc']['complian_invest_id'] = $complID;
                $data['CAComplianDoc']['file'] = $filename;
                $data['CAComplianDoc']['file_real_name'] = $reqFile;
                $data['CAComplianDoc']['doc_status'] = '2';
                $data['CAComplianDoc']['final_doc_type'] = $docType;


                $filePath = WWW_ROOT . 'ca_investigation' . DS . $filename;
                chmod($filePath, 0777);
                if (!is_file($filePath)) {

                    if (!($ext == 'pdf' || $ext == 'jpg' || $ext == 'png' || $ext == 'txt' || $ext == 'doc' || $ext == 'docx' || $ext == 'xlsx' || $ext == 'xls') || ($reqsizeFile > 2048000)) {
                        if ($reqsizeFile > 2048000) {
                            $err_files .= $reqFile.',';
                            $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert=""><a href="#" class="uk-alert-close uk-close"></a>Sorry, this is invalid file, please check the size !</div>');
                        } elseif (!($ext == 'pdf' || $ext == 'jpg' || $ext == 'png' || $ext == 'txt' || $ext == 'doc' || $ext == 'docx' || $ext == 'xlsx' || $ext == 'xls')) {
                            $err_files .= $reqFile.',';
                            $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert=""><a href="#" class="uk-alert-close uk-close"></a>Sorry, this is invalid file, please check the extention !</div>');
                        }
                    } else {
                        $this->CAComplianDoc->create();
                        if ($success=$this->CAComplianDoc->save($data)) {
                            if (move_uploaded_file($reqtempFile, $filePath))
                                $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert=""><a href="#" class="uk-alert-close uk-close"></a>Your file has been uploaded successfully!</div>');
                            else
                                $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert=""><a href="#" class="uk-alert-close uk-close"></a>Your file uploading failed!</div>');
                        }
                    }
                }else {
                    $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert=""><a href="#" class="uk-alert-close uk-close"></a>Sorry, this file is already exist!</div>');
                }
            
            }
                }
            }
            if ($success) {
                if($err_files != ''){
                    $errFiles = $err_files.' files are not uploaded';
                }
                $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                    <a href="#" class="uk-alert-close uk-close"></a>File Uploaded successfully "'.$errFiles.'"!</div>');
            } else {
                $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert="">
                    <a href="#" class="uk-alert-close uk-close"></a>Sorry, Details Not Entered !</div>');
            }
            $this->redirect('compliant_received_compliance_audit');
        }


//        $Ministry = $this->Ministry->find('list', array('fields' => 'ministry_name',
//            'conditions' => array('ministry_status' => '1')));

        $Compliants = $this->CAInvestigation->find('all', array(
            'conditions' => array('CAInvestigation.status' => '0', 'CAInvestigation.id' => $complID)
        ));

        $this->set(compact('Compliants'));
    }

    public function investigation_file_remove($complid = null, $fileID = null,$docType = null) {
        //$complid = base64_decode($complid);
        $fileID = base64_decode($fileID);

//        $fileData = $this->CAComplianDoc->query("Select * from ca_complian_doc where status='0' and id='".$fileID."' ");
//            if ($fileData['0']['ca_complian_doc']['id'] != '') {
//               
//                    $filename = $fileData['0']['ca_complian_doc']['file'];
//                    $filePath = WWW_ROOT.'ca_investigation'.DS.$filename ;
//                    unlink($filePath);
//            }
        $file_remove = $this->CAComplianDoc->updateAll(array('CAComplianDoc.status' => "1"), array('CAComplianDoc.id' => $fileID));
        if ($file_remove) {
            $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert="">
                    <a href="#" class="uk-alert-close uk-close"></a>File Removed !</div>');
        } else {
            $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert="">
                    <a href="#" class="uk-alert-close uk-close"></a>Sorry, Not Deleted !</div>');
        }
        if($docType != '' && $docType == 'final_doc'){
            $this->redirect('compliant_invest_documents/' . $complid);
        }else{
        $this->redirect('compliant_invest_edit/' . $complid);
        }
    }

    public function getMDAemail($id) {
        $Ministry = $this->Ministry->find('first', array('fields' => 'email_id',
            'conditions' => array('Ministry.id' => $id)));

        echo $Ministry['Ministry']['email_id'];
        exit;
    }

    public function wealthdeclaration_date() {
        //Configure::write('debug',2);
        $this->layout = 'employee-new';
        $auth = $this->Session->read('Auth');
        $empID = $auth['MyProfile']['id'];

        if (isset($this->request->data['submit']) && $this->request->data['submit'] != '') {
            //$curDate = date('Y');
            $emp_to_date = strtotime(date("Y", strtotime($this->request->data['emp_to'])));
            $commi_from_date = strtotime(date("Y", strtotime($this->request->data['commi_from'])));
            $commi_from_to = strtotime(date("Y", strtotime($this->request->data['commi_to'])));
            if(($emp_to_date != $commi_from_date) || ($emp_to_date!= $commi_from_to)){
                $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert="">
                    <a href="#" class="uk-alert-close uk-close"></a>Sorry, Please enter same Year for all date !</div>');
                $this->redirect('wealthdeclaration_date');
            }
            //die;
            $decl_Date = $this->CADeclarationDate->query("Select count(id) as total,id from ca_declaration_date where status=0 and EXTRACT(YEAR FROM emp_to)='".date("Y", strtotime($this->request->data['emp_to']))."' and EXTRACT(YEAR FROM commission_from)='".date("Y", strtotime($this->request->data['commi_from']))."'");

            if ($decl_Date['0']['0']['total'] > 0) {
                //$Date_success = $this->CADeclarationDate->updateAll(array('CADeclarationDate.status' => "1"), array('CADeclarationDate.id' => $decl_Date['0']['ca_declaration_date']['id']));
                $data['CADeclarationDate']['id'] = $decl_Date['0']['ca_declaration_date']['id'];
            }
            
            
            $data['CADeclarationDate']['emp_from'] = date("Y-m-d", strtotime($this->request->data['emp_from']));
            $data['CADeclarationDate']['emp_to'] = date("Y-m-d", strtotime($this->request->data['emp_to']));
            $data['CADeclarationDate']['commission_from'] = date("Y-m-d", strtotime($this->request->data['commi_from']));
            $data['CADeclarationDate']['commission_to'] = date("Y-m-d", strtotime($this->request->data['commi_to']));
            $data['CADeclarationDate']['days_from_joining'] = $this->request->data['days_joining'];
            $data['CADeclarationDate']['days_from_exit'] = $this->request->data['days_exit'];       
            $data['CADeclarationDate']['created_by'] = $empID;
           
            $success = $this->CADeclarationDate->save($data);
            if ($success) {
                $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                    <a href="#" class="uk-alert-close uk-close"></a>Declaration Date entered successfully !</div>');
            } else {
                $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert="">
                    <a href="#" class="uk-alert-close uk-close"></a>Sorry, Date Not Entered !</div>');
            }
            $this->redirect('wealthdeclaration_date_listing');
        }
        $declDate = $this->CADeclarationDate->find('all', array(
            'conditions' => array('CADeclarationDate.status' => '0','EXTRACT(YEAR FROM CADeclarationDate.emp_from)' => date('Y'))
        ));
        $this->set(compact('declDate'));
    }

    public function wealthdeclaration_date_listing($Date_id = null, $Del = null) {
        //Configure::write('debug',2);
        $this->layout = 'employee-new';
        $auth = $this->Session->read('Auth');
        $empID = $auth['MyProfile']['id'];
        $Date_id = base64_decode($Date_id);

        if (isset($Date_id) && $Date_id != '' && $Del == '') {
            
            $active_Date = $this->CADeclarationDate->query("update ca_declaration_date set status = CASE WHEN id = '".$Date_id."' THEN '0' WHEN id != '".$Date_id."' THEN '1' END");
            
            if ($active_Date > 0) {
                $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                    <a href="#" class="uk-alert-close uk-close"></a>Declaration Date Activeted Successfully !</div>');
            } else {
                $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert="">
                    <a href="#" class="uk-alert-close uk-close"></a>Sorry, Date Not Activeted !</div>');
            }
            $this->redirect('wealthdeclaration_date_listing');
        }
        
        if (isset($Date_id) && $Date_id != '' && $Del == 'Del') {
            $Date_delete = $this->CADeclarationDate->delete($Date_id);
            
            if ($Date_delete > 0) { 
                $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                    <a href="#" class="uk-alert-close uk-close"></a>Declaration Date Deleted Successfully !</div>');
            } else {
                $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert="">
                    <a href="#" class="uk-alert-close uk-close"></a>Sorry, Date Not Deleted !</div>');
            }
            $this->redirect('wealthdeclaration_date_listing');
        }
        
        
        $this->paginate = array(
            'conditions' => array('CADeclarationDate.status' => '0'),
            'limit' => 10,
            'order' => array(
                'CADeclarationDate.emp_from' => 'desc'
                //'EXTRACT(YEAR FROM CADeclarationDate.emp_from)' => 'desc'
            )
        );
        $this->set('AllDeclarDate', $this->paginate($this->CADeclarationDate));
        
    }
    public function emp_definition_edit($id, $del = null) {
        //Configure::write('debug',2);
        $this->layout = 'employee-new';
        $auth = $this->Session->read('Auth');
        $empID = $auth['MyProfile']['id'];
        $id = base64_decode($id);
        
        if (isset($this->request->data['submit']) && $this->request->data['submit'] != '') {
//            echo "<pre>";
//            print_r($this->request->data);
            if($this->request->data['doe']!=''){
                $doe = date("Y-m-d", strtotime($this->request->data['doe']));
            }else{
                $doe = '';
            }
            $data['CAEmployeeDefinition']['id'] = $this->request->data['emp_define_id'];
            $data['CAEmployeeDefinition']['type_of_organisation'] = $this->request->data['t_o_org'];
            $data['CAEmployeeDefinition']['ministry_id'] = $this->request->data['ministry'];
            $data['CAEmployeeDefinition']['organisation_id'] = '';
            $data['CAEmployeeDefinition']['organisation_name'] = $this->request->data['orgname'];
            $data['CAEmployeeDefinition']['nature_of_employment'] = $this->request->data['nature_employment'];
            $data['CAEmployeeDefinition']['employment_number'] = $this->request->data['employment_number'];
            $data['CAEmployeeDefinition']['department_id'] = $this->request->data['department'];
            $data['CAEmployeeDefinition']['kra_pin'] = $this->request->data['kra_pin'];
            $data['CAEmployeeDefinition']['id_number'] = $this->request->data['id_number'];
            $data['CAEmployeeDefinition']['salutation'] = $this->request->data['salutation'];
            $data['CAEmployeeDefinition']['first_name'] = $this->request->data['fname'];
            $data['CAEmployeeDefinition']['surname'] = $this->request->data['srname'];
            $data['CAEmployeeDefinition']['othername'] = $this->request->data['oth_name'];
            $data['CAEmployeeDefinition']['designation_id'] = $this->request->data['designation'];
            $data['CAEmployeeDefinition']['date_of_joining'] = date("Y-m-d", strtotime($this->request->data['doj']));
            $data['CAEmployeeDefinition']['date_of_exit'] = $doe;
            $data['CAEmployeeDefinition']['gender'] = $this->request->data['gender'];
            $data['CAEmployeeDefinition']['dob'] = date("Y-m-d", strtotime($this->request->data['dob']));
            $data['CAEmployeeDefinition']['place_of_birth'] = $this->request->data['pob'];
            $data['CAEmployeeDefinition']['marital_status'] = $this->request->data['marital_status'];
            $data['CAEmployeeDefinition']['official_email'] = $this->request->data['email'];
            $data['CAEmployeeDefinition']['emp_mobile'] = $this->request->data['mobile'];
            $data['CAEmployeeDefinition']['physical_add'] = $this->request->data['phy_add'];
            $data['CAEmployeeDefinition']['postal_add'] = $this->request->data['post_add'];
            $data['CAEmployeeDefinition']['emp_status'] = $this->request->data['doc']['emp_status'];
            $data['CAEmployeeDefinition']['created_by'] = $empID;

//            echo "<pre>";
//            print_r($data);die;
            $success = $this->CAEmployeeDefinition->save($data);

            if ($success) {
                $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                    <a href="#" class="uk-alert-close uk-close"></a>Employee Details Modified successfully !</div>');
            } else {
                $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert="">
                    <a href="#" class="uk-alert-close uk-close"></a>Sorry, Details Not Moified !</div>');
            }
            $this->redirect('emp_definition');
        }


        $Ministry = $this->Ministry->find('list', array('fields' => 'ministry_name',
            'conditions' => array('ministry_status' => '1')));
        array_unshift($Ministry, '---Select---');
//         
//         $department = $this->Departments->find('list', array(
//            'fields' => array('Departments.dept_code', 'Departments.dept_name'),
//            'conditions' => array('Departments.status' => '1')
//        ));
//        
//         $EmpDefinition = $this->CAEmployeeDefinition->find('all', array(
//            'conditions' => array('CAEmployeeDefinition.status' => '0')
//        ));

        $EmployeeDefinition = $this->CAEmployeeDefinition->find('all', array(
            'conditions' => array('CAEmployeeDefinition.id' => $id, 'CAEmployeeDefinition.status' => '0')));
        
         $dependentExist = '0';
         if(!empty($EmployeeDefinition[0]['CADependentDetails'])){
             $dependentExist = '1';
         }
//        echo "<pre>";
//         print_r($EmployeeDefinition);die;
        $this->set(compact('EmployeeDefinition', 'empID', 'Ministry','dependentExist'));
    }

    public function emp_dependent_detail_save($EmpDifID = null) {
        //Configure::write('debug',2);
        $this->layout = 'employee-new';
        $auth = $this->Session->read('Auth');
        $empID = $auth['MyProfile']['id'];
        $EmpDifID = base64_decode($EmpDifID);
     
        if (isset($this->request->data['submit']) && $this->request->data['submit'] != '') {
            $TotalRec = $this->request->data['ComplianceAudit']['rowCount'];
//echo "<pre>";
//     print_r($this->request->data);die;
            for ($i = 0; $i < $TotalRec; $i++) {
                $data['CADependentDetails']['emp_difini_id'] = $this->request->data['ComplianceAudit']['emp_dif_id'];
                $data['CADependentDetails']['dependent_type'] = $this->request->data['ComplianceAudit']['dependent'][$i];
                $data['CADependentDetails']['fname'] = $this->request->data['ComplianceAudit']['fname'][$i];
                $data['CADependentDetails']['surname'] = $this->request->data['ComplianceAudit']['surname'][$i];
                $data['CADependentDetails']['othername'] = $this->request->data['ComplianceAudit']['othername'][$i];
                $data['CADependentDetails']['dob'] = date("Y-m-d", strtotime($this->request->data['ComplianceAudit']['dob'][$i]));
                $data['CADependentDetails']['comment'] = $this->request->data['ComplianceAudit']['comment'][$i];
                $data['CADependentDetails']['depend_status'] = $this->request->data['ComplianceAudit']['status'][$i];
                $data['CADependentDetails']['created_by'] = $empID;

                $this->CADependentDetails->create();
                $success = $this->CADependentDetails->save($data);
            }
//            echo "<pre>";
//            print_r($this->request->data);die;


            if ($success) {
                $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                    <a href="#" class="uk-alert-close uk-close"></a>Dependent Details entered successfully !</div>');
            } else {
                $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert="">
                    <a href="#" class="uk-alert-close uk-close"></a>Sorry, Details Not Entered !</div>');
            }
            $this->redirect('emp_definition');
        }

        $this->set(compact('EmpDifID'));
    }

    public function emp_dependent_detail_edit($DepenID = null, $del = null) {
        //Configure::write('debug',2);
        $this->layout = 'employee-new';
        $auth = $this->Session->read('Auth');
        $empID = $auth['MyProfile']['id'];
        $DepenID = base64_decode($DepenID);

        if (isset($this->request->data['submit']) && $this->request->data['submit'] != '') {


            $data['CADependentDetails']['id'] = $this->request->data['ComplianceAudit']['depnd_id'];
            $data['CADependentDetails']['emp_difini_id'] = $this->request->data['ComplianceAudit']['emp_dif_id'];
            $data['CADependentDetails']['dependent_type'] = $this->request->data['ComplianceAudit']['dependent'];
            $data['CADependentDetails']['fname'] = $this->request->data['ComplianceAudit']['fname'];
            $data['CADependentDetails']['surname'] = $this->request->data['ComplianceAudit']['surname'];
            $data['CADependentDetails']['othername'] = $this->request->data['ComplianceAudit']['othername'];
            $data['CADependentDetails']['dob'] = date("Y-m-d", strtotime($this->request->data['ComplianceAudit']['dob']));
            $data['CADependentDetails']['comment'] = $this->request->data['ComplianceAudit']['comment'];
            $data['CADependentDetails']['depend_status'] = $this->request->data['ComplianceAudit']['status'];
            $data['CADependentDetails']['created_by'] = $empID;

            $this->CADependentDetails->create();
            $success = $this->CADependentDetails->save($data);

//            echo "<pre>";
//            print_r($this->request->data);die;


            if ($success) {
                $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                    <a href="#" class="uk-alert-close uk-close"></a>Dependent Details Modified successfully !</div>');
            } else {
                $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert="">
                    <a href="#" class="uk-alert-close uk-close"></a>Sorry, Details Not Entered !</div>');
            }
            $this->redirect('emp_definition');
        }

        $DependentDetail = $this->CADependentDetails->find('all', array(
            'conditions' => array('CADependentDetails.id' => $DepenID, 'CADependentDetails.status' => '0')));
//        echo "<pre>";
//            print_r($DependentDetail);die;
        $this->set(compact('DependentDetail'));
    }

    public function send_requester_notification() {
        // Configure::write('debug',2);
        $FwrdUser = $this->BMReceiveRequestForward->find('all', array(
            'conditions' => array('BMReceiveRequestForward.frwd_status' => '0'),
        ));

        foreach ($FwrdUser as $rec) {
            $frwd_date = date("Y-m-d", strtotime($rec['BMReceiveRequestForward']['forward_date']));
            $datetime1 = date_create($frwd_date);
            $datetime2 = date_create(date('Y-m-d'));
            $interval = date_diff($datetime1, $datetime2);
            $NumOfDays = $interval->format('%R%a');
            if ($NumOfDays >= 10) {

                $UserID = $rec['BMReceiveRequestForward']['req_receive_by'];
                $UserDet = $this->MyProfile->find('all', array('conditions' => array('MyProfile.id' => $UserID)));
                foreach ($UserDet as $ud)
                    ;
                $data['id'] = $ud['MyProfile']['id'];
                $data['name'] = $ud['MyProfile']['emp_name'];

                $ReqNum = $this->Common->getReqRefNumByReqID($rec['BMReceiveRequestForward']['request_receive_id']);
                /////////Send Mail////
                $From = "ess-portal@essindia.com";
                $manager_ID = $this->Common->getManagerCodeByID($UserID);
                //$ManagerMailID = $this->Common->getUserEmailByID($manager_ID);////make enable when going live....
                //$UserMailID = $this->Common->getUserEmailByID($UserID);
                $UserMailID = "bajrangi.srivastava@essindia.com"; //// make it comment when going live....
                $ManagerMailID = "ayush.pant@essindia.com";       //// make it comment when going live....


                $To = $UserMailID;
                $CC = $ManagerMailID;
                $sub = "Request Pending Notification!!!!";
                $msg = "Your request no. " . $ReqNum . " is still pending, please take a prompt action on urgent basis!! ";
                $template = 'bm_req_receive';

                $this->Common->send_mail($From, $To, $CC, $sub, $msg, $template, $data);
                /////////End//////////
            }
        }
    }

    public function randNumber() {

        list($usec, $sec) = explode(' ', microtime());
        return $sec + $usec * 1000000;
        die;
    }

    public function bm_reports() {
        //Configure::write('debug',2);
        $this->layout = 'employee-new';
        $auth = $this->Session->read('Auth');


        $flag = '';
        if (isset($this->request->data['submit']) && $this->request->data['submit'] != '') {
            if ($this->request->data['meet_num'] == '' && $this->request->data['depart'] == '' && $this->request->data['meet_from_date'] == '' && $this->request->data['meet_to_date'] == '' && $this->request->data['req_from_date'] == '' && $this->request->data['req_to_date'] == '' && $this->request->data['req_receive'] == '') {
                $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert="">
                            <a href="#" class="uk-alert-close uk-close"></a>Please Enter Atleast One Value !!!!</div>');
                $this->redirect('bm_reports');
            }

            if ($this->request->data['meet_num'] != '') {
                $ORconditions['BMMeetingRequestRefnum.meeting_request_id'] = $this->request->data['meet_num'];
                $meet_num = $this->request->data['meet_num'];
            }
            if ($this->request->data['depart'] != '') {
                $ORconditions['BMReceiveRequest.dept_code'] = $this->request->data['depart'];
                $depart = $this->request->data['depart'];
            }
            if ($this->request->data['meet_from_date'] != '' && $this->request->data['meet_to_date'] != '') {

                $meet_from_date = date('Y-m-d', strtotime($this->request->data['meet_from_date']));
                $meet_to_date = date('Y-m-d', strtotime($this->request->data['meet_to_date']));
                $ORconditions1['BMMeetingRequest.meeting_date between ? and ?'] = array($meet_from_date, $meet_to_date);
            }
            if ($this->request->data['req_from_date'] != '' && $this->request->data['req_to_date'] != '') {
                $req_from_date = date('Y-m-d', strtotime($this->request->data['req_from_date']));
                $req_to_date = date('Y-m-d', strtotime($this->request->data['req_to_date']));
                $ORconditions2['BMReceiveRequest.date_of_receive between ? and ?'] = array($req_from_date, $req_to_date);
            }
            if ($this->request->data['req_receive'] != '') {
                $ORconditions3['BMReceiveRequest.id'] = $this->request->data['req_receive'];
                $req_receive = $this->request->data['req_receive'];
            }

            $conditions = array('BMMeetingRequestRefnum.status' => '0',
                'OR' => array($ORconditions1, $ORconditions2, $ORconditions3, $ORconditions)
            );

            $Meeting_Request_Refnum = $this->BMMeetingRequestRefnum->find('all', array('conditions' => $conditions));
//            echo "<pre>";
//            print_r($Meeting_Request_Refnum);die;
            if ($Meeting_Request_Refnum) {
                $flag = 'open';
                $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                            <a href="#" class="uk-alert-close uk-close"></a>Report Generated Successfully !!!!</div>');
            } else {
                $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert="">
                            <a href="#" class="uk-alert-close uk-close"></a>Sorry, there is no record found !!!!</div>');
            }


            $this->set(compact('Meeting_Request_Refnum', 'flag', 'meet_num', 'depart', 'meet_from_date', 'meet_to_date', 'req_from_date', 'req_to_date', 'req_receive'));
        }

        $Meetinglist = $this->BMMeetingRequest->find('list', array('fields' => 'meeting_number'), array('conditions' => array('BMMeetingRequest.status' => '0')));
        array_unshift($Meetinglist, '---Select---');

        $reqRef = $this->BMReceiveRequest->find('list', array(
            'fields' => array('id', 'reference_num'),
            'conditions' => array('status' => '1')
        ));
        array_unshift($reqRef, '---Select---');


        $this->set(compact('Meetinglist', 'reqRef'));
    }

    public function dept_employee($deptId) {
        //Configure::write('debug',2);
        $this->layout = 'employee-new';
        $comp_code = $this->Auth->user('comp_code');

        if (!empty($deptId)) {
            $departmentId = base64_decode($deptId);
        }
        //echo $departmentId; die;
        $profile = $this->MyProfile->find('all', array(
            'conditions' => array(
                'dept_code' => "$departmentId",
                'comp_code' => $comp_code,
                'status' => 32
            )
        ));
        //print_r($profile); die;
        $this->set("profile", $profile);
        $this->set("departmentId", $departmentId);
    }

    public function generate_bm_report_pdf($meet_num = null, $depart = null, $meet_from_date = null, $meet_to_date = null, $req_from_date = null, $req_to_date = null, $req_receive = null) {
        //Configure::write('debug', 2);
        $this->layout = 'employee-new';
        $auth = $this->Session->read('Auth');

        if ($meet_num == 'null') {
            $meet_num = null;
        }
        if ($depart == 'null') {
            $depart = null;
        }
        if ($meet_from_date == 'null' && $meet_to_date == 'null') {
            $meet_from_date = null;
            $meet_to_date = null;
        }
        if ($req_from_date == 'null' && $req_to_date == 'null') {
            $req_from_date = null;
            $req_to_date = null;
        }
        if ($req_receive == 'null') {
            $req_receive = null;
        }

        if ($meet_num != '') {
            $ORconditions['BMMeetingRequestRefnum.meeting_request_id'] = $meet_num;
        }
        if ($depart != '') {
            $ORconditions['BMReceiveRequest.dept_code'] = $depart;
        }
        if ($meet_from_date != '' && $meet_to_date != '') {
            $ORconditions1['BMMeetingRequest.meeting_date between ? and ?'] = array($meet_from_date, $meet_to_date);
        }
        if ($req_from_date != '' && $req_to_date != '') {
            $ORconditions2['BMReceiveRequest.date_of_receive between ? and ?'] = array($req_from_date, $req_to_date);
        }
        if ($req_receive != '') {
            $ORconditions3['BMReceiveRequest.id'] = $req_receive;
        }

        $conditions = array('BMMeetingRequestRefnum.status' => '0',
            'OR' => array($ORconditions1, $ORconditions2, $ORconditions3, $ORconditions)
        );

        $Meeting_Request_Refnum = $this->BMMeetingRequestRefnum->find('all', array('conditions' => $conditions));

        App::import('Vendor', 'TCpdf', array('file' => 'mpdf60/mpdf.php'));
        $this->layout = 'pdf';
        $this->set('pdf', new mPDF('utf-8', array(350, 500)));
        $this->set('Meeting_Request_Refnum', $Meeting_Request_Refnum);
    }

    public function generate_bm_report_sec_pdf($ministry = null, $depart = null, $meet_from_date = null, $meet_to_date = null, $action_officer = null) {
        //Configure::write('debug', 2);
        $this->layout = 'employee-new';
        $auth = $this->Session->read('Auth');

        if ($ministry == 'null') {
            $ministry = null;
        }
        if ($depart == 'null') {
            $depart = null;
        }
        if ($meet_from_date == 'null' && $meet_to_date == 'null') {
            $meet_from_date = null;
            $meet_to_date = null;
        }
        if ($action_officer == 'null') {
            $action_officer = null;
        }

        if ($ministry != '') {
            $ORconditions['BMRequestDetails.ministry_id'] = $ministry;
        }
        if ($depart != '') {
            $ORconditions2['BMReceiveRequest.dept_code'] = $depart;
        }
        if ($meet_from_date != '' && $meet_to_date != '') {
            $ORconditions1['BMMeetingRequest.meeting_date between ? and ?'] = array($meet_from_date, $meet_to_date);
        }
        if ($action_officer != '') {
            //$ORconditions3['BMReceiveRequest.action_officer_id'] = $action_officer;
            $ORconditions3['BMReceiveRequestForward.req_receive_by'] = $action_officer;
        }

        $conditions = array('BMMeetingRequestRefnum.status' => '0',
            'OR' => array($ORconditions1, $ORconditions2, $ORconditions3, $ORconditions)
        );

        $Meeting_Request_Refnum = $this->BMMeetingRequestRefnum->find('all', array('conditions' => $conditions));
        $TotalReq = count($Meeting_Request_Refnum);
        $count_Final = 0;
        foreach ($Meeting_Request_Refnum as $rec) {
            if ($rec['BMMeetingRequestRefnum']['finalize_status'] == '1') {
                $count_Final++;
            }
        }
        $Pending = $TotalReq - $count_Final;
        App::import('Vendor', 'TCpdf', array('file' => 'mpdf60/mpdf.php'));
        $this->layout = 'pdf';
        $this->set('pdf', new mPDF('utf-8', array(350, 500)));
        $this->set('Meeting_Request_Refnum', $Meeting_Request_Refnum);
        $this->set('TotalReq', $TotalReq);
        $this->set('count_Final', $count_Final);
        $this->set('Pending', $Pending);
    }

    public function employeelist($deptCode) {
        if ($deptCode) {
            $employee_name = $this->MyProfile->find('list', array('fields' => array('emp_code', 'emp_name'),
                'conditions' => array('dept_code' => $deptCode),
                'order' => array('MyProfile.emp_name' => 'ASC')
            ));
            return $employee_name;
        }
    }

    public function download($fileID) {

        //ob_start();
        ignore_user_abort(true);
        set_time_limit(0); // disable the time limit for this script
        $Dir_Name = $this->BMReportTypeAttachFiles->find('first', array('conditions' => array('id' => $fileID, 'status' => '0')));

        $DirName = $Dir_Name['BMReportTypeAttachFiles']['folder_name'];
        $fileName = $Dir_Name['BMReportTypeAttachFiles']['attach_file'];
        $path = WWW_ROOT . 'bom' . DS . $DirName . DS;


        //$path = "/absolute_path_to_your_files/"; // change the path to fit your websites document structure
//        $dl_file = preg_replace("([^\w\s\d\-_~,;:\[\]\(\).]|[\.]{2,})", '', $fileName); // simple file name validation
//        $dl_file = filter_var($dl_file, FILTER_SANITIZE_URL); // Remove (more) invalid characters
        $fullPath = $path . $fileName;

        if ($fd = fopen($fullPath, "r")) {
            $fsize = filesize($fullPath);
            $path_parts = pathinfo($fullPath);
            $ext = strtolower($path_parts["extension"]);
            switch ($ext) {
//                case "pdf":
//                header("Content-type: application/pdf");
//                header("Content-Disposition: attachment; filename=\"".$path_parts["basename"]."\""); // use 'attachment' to force a file download
//                break;
//                case "txt":
//                header("Content-type: application/txt");
//                header("Content-Disposition: attachment; filename=\"".$path_parts["basename"]."\""); // use 'attachment' to force a file download
//                break;
                // add more headers for other content types here
//                default;
//                header("Content-type: application/octet-stream");
//                header("Content-Disposition: filename=\"".$path_parts["basename"]."\"");
//                break;
            }
            if ($ext) {
                header("Content-type: application/octet-stream");
                header("Content-Disposition: filename=\"" . $path_parts["basename"] . "\"");
            }

            header("Content-length: $fsize");
            header("Cache-control: private"); //use this to open files directly
            while (!feof($fd)) {
                $buffer = fread($fd, 2048);
                echo $buffer;
            }
        }
        fclose($fd);
        die;
    }

    public function investigation_file_download($id) {

        //ob_start();
        ignore_user_abort(true);
        set_time_limit(0); // disable the time limit for this script

        $auth = $this->Session->read('Auth');
        $empID = $auth['MyProfile']['id'];

        $Compliants = $this->CAComplianDoc->find('all', array(
            'conditions' => array('CAComplianDoc.id' => $id, 'CAComplianDoc.status' => '0'),
        ));

        $DirName = "ca_investigation";
        $fileName = $Compliants[0]['CAComplianDoc']['file'];
        $path = WWW_ROOT . $DirName . DS;

        $fullPath = $path . $fileName;

        if ($fd = fopen($fullPath, "r")) {
            $fsize = filesize($fullPath);
            $path_parts = pathinfo($fullPath);
            $ext = strtolower($path_parts["extension"]);
            if ($ext) {
                header("Content-type: application/octet-stream");
                header("Content-Disposition: filename=\"" . $path_parts["basename"] . "\"");
            }

            header("Content-length: $fsize");
            header("Cache-control: private"); //use this to open files directly
            while (!feof($fd)) {
                $buffer = fread($fd, 2048);
                echo $buffer;
            }
        }
        fclose($fd);
        die;
    }
    
    
    public function download_mailoffice($id) {

        //ob_start();
        ignore_user_abort(true);
        set_time_limit(0); // disable the time limit for this script

        $auth = $this->Session->read('Auth');
        $empID = $auth['MyProfile']['id'];

        $Compliants = $this->MailOfficeAttachFiles->find('all', array(
            'conditions' => array('MailOfficeAttachFiles.id' => $id, 'MailOfficeAttachFiles.status' => '0'),
        ));
//echo "<pre>";
//print_r($Compliants);die;
        $DirName = "mail_office";
        $fileName = $Compliants[0]['MailOfficeAttachFiles']['attach_file'];
        $path = WWW_ROOT . $DirName . DS;

        $fullPath = $path . $fileName;

        if ($fd = fopen($fullPath, "r")) {
            $fsize = filesize($fullPath);
            $path_parts = pathinfo($fullPath);
            $ext = strtolower($path_parts["extension"]);
            if ($ext) {
                header("Content-type: application/octet-stream");
                header("Content-Disposition: filename=\"" . $path_parts["basename"] . "\"");
            }

            header("Content-length: $fsize");
            header("Cache-control: private"); //use this to open files directly
            while (!feof($fd)) {
                $buffer = fread($fd, 2048);
                echo $buffer;
            }
        }
        fclose($fd);
        die;
    }
    
    
    public function report_attach_files($ReportAttachID){
        //Configure::write('debug',2);
        $Allfiles = $this->MailOfficeAttachFiles->find('all',array('conditions'=>array('MailOfficeAttachFiles.mail_office_id'=>$ReportAttachID,'MailOfficeAttachFiles.status'=>'0')));
        
        $this->set('Allfiles', $Allfiles);
    }
    
       public function test_mail() {
        $To = "bajrangi.srivastava@essindia.com";
        //$CC = "rahul.tripathi@essindia.com";
        $From = "ayush.pant@essindia.com";
        $sub = "test mail";
        $msg = "This is to inform you that Arti Gupta has submitted, his/ her KRA self score, kindly login to portal and initiate action. !!!";
        $template = 'kra_fill_notification';
        
        //$data['appName'] = "Anita yadav";

        if (isset($To)) {
			
            $this->send_mail($From, $To, $CC, $sub, $msg, $template, $data);
        }
        echo 'hjhhjjhj';
die;
		}
}

?>
