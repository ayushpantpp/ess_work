<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CompetencyController
 *
 * @author hp4420-50 (Arti Gupta)
 */
class CompetencyController extends AppController {

    var $uses = array('CompetencyType', 'Competency', 'HcmGroupMaster', 'GroupCompetency', 'AssignCompetencyDeptDesg', 'Departments', 'OptionAttribute', 'AssignCompetencyToEmp', 'AssignCompToEmpDetails', 'AssignGroupToDesgDetails' ,'CompetencyRating','AssignGroupToDesg','MgtGroupDesg','KraTarget','CompetencyTarget');
    var $components = array('Session', 'Cookie', 'RequestHandler', 'Auth', 'EmpDetail','Common');
    var $helpers = array('Html', 'Js', 'Form', 'Session', 'Userdetail', 'Leave', 'Common');

    function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow();
        $this->layout = 'employee-new';
        $this->set('appId', 12);
        $this->set('emp_code', $this->Auth->User('emp_code'));
        $currentUser = $this->checkUser();
    }

    public function addCompetencyType() {
        $this->layout = 'admin';
        $competencyArray = array();

        $totalRecords = $this->CompetencyType->find('first', array('fields' => array('competency_type'),
            'order' => array('id' => 'DESC')));


        $this->set('totalRecords', $totalRecords['CompetencyType']['competency_type']);

        if ($this->request->data) {
            $competencyArray['competency_type'] = $this->request->data['competency']['competency_type'];
            if ($competencyArray['competency_type'] == 1) {
                $competencyArray['competency_type_value'] = "Manual";
            } else if ($competencyArray['competency_type'] == 2) {
                $competencyArray['competency_type_value'] = "Pre Define";
            } else if ($competencyArray['competency_type'] == 3) {
                $competencyArray['competency_type_value'] = "Both";
            }
            $competencyArray['created_date'] = date("Y-m-d");
            $CompetencyType = $competencyArray['competency_type'];
            $CompetencyTypeValue = $competencyArray['competency_type_value'];
            $createdDate = $competencyArray['created_date'];

            if (count($totalRecords) == 0) {
                $success = $this->CompetencyType->save($competencyArray);
                $this->Session->setFlash(' <div class="alert success">
                    <span class="closebtn" onclick="this.parentElement.style.display=\'none\';">&times;</span>
                        Competency setup type saved successfully. !!!
                    </div>');

                $this->redirect('addCompetencyType');
            } else {
                $success = $this->CompetencyType->updateAll(array('competency_type' => "'$CompetencyType'", 'updated_date' => "'$createdDate'", 'competency_type_value' => "'$CompetencyTypeValue'"), array('id' => 1));
                $this->Session->setFlash(' <div class="alert success">
                    <span class="closebtn" onclick="this.parentElement.style.display=\'none\';">&times;</span>
                        Competency setup type updated successfully. !!!
                    </div>');
                $this->redirect('addCompetencyType');
            }
        }
    }

    public function addCompetency() {
        $this->layout = 'employee-new';
        
        //echo "<pre>";print_r($this->Auth->User());die;

        $this->paginate = array(
            'fields' => array('*'),
            'order' => array('Competency.id' => 'desc')
        );

        $competencyList = $this->paginate('Competency');
        $this->set("competencyList", $competencyList);

        if (empty($this->request->data['id'])) {

            if ($this->request->is('post') && !empty($this->request->data['Competency']['competencyName'])) {

                $arrayCompetency['competency_name'] = $this->request->data['Competency']['competencyName'];
                //$arrayCompetency['description'] = $this->request->data['Competency']['comment'];
                
                $comment = $this->request->data['Competency']['comment'];
                
                $arrayCompetency['description'] = str_replace("'","&#39",$comment);
                $arrayCompetency['comp_type'] = $this->request->data['Competency']['comp_type'];
                $arrayCompetency['status'] = $this->request->data['Competency']['status'];
                $arrayCompetency['created_by'] = $this->Auth->User('emp_code');
                $arrayCompetency['ho_org_id'] = $this->Common->getHO($this->Auth->User('comp_code'));
                $arrayCompetency['org_id'] = $this->Auth->User('comp_code');
                $arrayCompetency['created_date'] = date("Y-m-d");

                $conditions = array('Competency.competency_name' => $arrayCompetency["competency_name"]);
                $data = $this->Competency->find('all', array('conditions' => $conditions));

                if (count($data) >= 1) {
                    $this->Session->setFlash('<div class="uk-alert uk-alert-primary" data-uk-alert="">
                            <a href="#" class="uk-alert-close uk-close"></a>Competency already exists. !!!</div>');
                    $this->redirect('/Competency/addCompetency');
                } else {
                    $this->Competency->save($arrayCompetency);
                    $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                            <a href="#" class="uk-alert-close uk-close"></a>Competency added successfully. !!!</div>');
                    $this->redirect('/Competency/addCompetency');
                }
            }
        }

        ///// Update Competency /////
        if (isset($this->request->params['pass'][0]) == "competencyEdit") {

            $competencyEdit = isset($this->request->params['pass'][0]) ? $this->request->params['pass'][0] : "";
            $competencyEditId = isset($this->request->params['pass'][1]) ? $this->request->params['pass'][1] : "";

            $editCompetency = $this->Competency->find('first', array('fields' => array('Competency.id', 'Competency.competency_name', 'Competency.description', 'Competency.comp_type', 'Competency.status'),
                'conditions' => array('id' => $competencyEditId)
            ));

            if (!empty($this->request->data['Competency']['competencyName'])) {

                $competency_name = $this->request->data['Competency']['competencyName'];
                $comment = $this->request->data['Competency']['comment'];
                
                $description = str_replace("'","&#39",$comment);
                $comp_type = $this->request->data['Competency']['comp_type'];
				$status = $this->request->data['Competency']['status'];
                $updated_by = $this->Auth->User('emp_code');
                $updated_date = date("Y-m-d");
                
                $conditions = array('Competency.competency_name' => $competency_name, "id != $competencyEditId");
                $data = $this->Competency->find('all', array('conditions' => $conditions));
                
                if (count($data) == 0) {
                    
                    $successUpdate = $this->Competency->updateAll(array('competency_name' => "'$competency_name'", 
                    'description' => "'$description'", 'comp_type' => "'$comp_type'", 'status' => "'$status'", 'updated_date' => "'$updated_date'",'updated_by' => $updated_by), array('id' => $competencyEditId));
                
                    $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                            <a href="#" class="uk-alert-close uk-close"></a>Competency added successfully. !!!</div>');
                    $this->redirect('/Competency/addCompetency');                    
                    
                } else {
                    $this->Session->setFlash('<div class="uk-alert uk-alert-primary" data-uk-alert="">
                            <a href="#" class="uk-alert-close uk-close"></a>Competency already exists. !!!</div>');
                    $this->redirect('/Competency/addCompetency');
                    
                }
            }

            $this->set('competencyEdit', $competencyEdit);
            $this->set('competencyEditId', $competencyEditId);
            $this->set('editCompetency', $editCompetency);
        }
    }

    public function competencyDelete($id = null) {
        $this->layout = false;
        $this->autoRender = false;
        if (!empty($id)) {
            if ($this->Competency->delete($id)) {
                $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                        <a href="#" class="uk-alert-close uk-close"></a>Competency deleted successfully. !!!</div>');
                $this->redirect("addCompetency");
            } else {
                $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                        <a href="#" class="uk-alert-close uk-close"></a>Competency not deleted successfully. !!!</div>');
                $this->redirect("addCompetency");
            }
        } else {
            $this->Session->setFlash('<div class="uk-alert uk-alert-warning" data-uk-alert="">
                        <a href="#" class="uk-alert-close uk-close"></a>Competency is not selected. !!!</div>');
        }
        $this->redirect("addCompetency");
        exit;
    }

    public function addGroup() {
        $this->layout = 'employee-new';
        
        $ho_org_id = $this->Common->getHO($this->Auth->User('comp_code'));
        $org_id = $this->Auth->User('comp_code');
        $this->paginate = array(
            'limit' => 10,
            'fields' => array('*'),
            'conditions' => array('ho_org_id' => $ho_org_id,'org_id' => $org_id),
            'order' => array('HcmGroupMaster.id' => 'desc')
        );

        $groupList = $this->paginate('HcmGroupMaster');
        $this->set("groupList", $groupList);

        if (empty($this->request->data['id'])) {

            if ($this->request->is('post') && !empty($this->request->data['Competency']['groupName'])) {

                $arrayGroup['group_name'] = $this->request->data['Competency']['groupName'];
                $arrayGroup['status'] = $this->request->data['Competency']['status'];
                $arrayGroup['created_by'] = $this->Auth->User('emp_code');
                $arrayGroup['ho_org_id'] = $ho_org_id;
                $arrayGroup['org_id'] = $org_id;                
                $arrayGroup['created_date'] = date("Y-m-d");
                
                

                $conditions = array('HcmGroupMaster.group_name' => $arrayGroup["group_name"]);
                $data = $this->HcmGroupMaster->find('all', array('conditions' => $conditions));

                if (count($data) >= 1) {
                    $this->Session->setFlash('<div class="uk-alert uk-alert-primary" data-uk-alert="">
                            <a href="#" class="uk-alert-close uk-close"></a>Group master already exists. !!!</div>');
                    $this->redirect('/Competency/addGroup');
                } else {
                    
                    $this->HcmGroupMaster->create();
                    $this->HcmGroupMaster->save($arrayGroup);
                    $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                            <a href="#" class="uk-alert-close uk-close"></a>Group master added successfully. !!!</div>');
                    $this->redirect('/Competency/addGroup');
                }
            }
        }

        ///// Update Competency /////
        if (isset($this->request->params['pass'][0]) == "competencyEdit") {
            
            $groupEdit = isset($this->request->params['pass'][0]) ? $this->request->params['pass'][0] : "";
            $groupEditId = isset($this->request->params['pass'][1]) ? $this->request->params['pass'][1] : "";

            $editGroup = $this->HcmGroupMaster->find('first', array('fields' => array('HcmGroupMaster.id', 'HcmGroupMaster.group_name', 'HcmGroupMaster.status'),
                'conditions' => array('id' => $groupEditId)
            ));

            if (!empty($this->request->data['Competency']['groupName'])) {

                $group_name = $this->request->data['Competency']['groupName'];
                $status = $this->request->data['Competency']['status'];
                $updated_by = $this->Auth->User('emp_code');
                $updated_date = date("Y-m-d");
                
                $conditions = array('HcmGroupMaster.group_name' => $group_name,'HcmGroupMaster.id !=' => $groupEditId);
                $data = $this->HcmGroupMaster->find('all', array('conditions' => $conditions));

                if (count($data) >= 1) {
                    $this->Session->setFlash('<div class="uk-alert uk-alert-primary" data-uk-alert="">
                            <a href="#" class="uk-alert-close uk-close"></a>Group master already exists. !!!</div>');
                    $this->redirect('/Competency/addGroup');
                } else {
                    
                    $successUpdate = $this->HcmGroupMaster->updateAll(array('group_name' => "'$group_name'", 'status' => "'$status'", 'updated_date' => "'$updated_date'",'updated_by' => "$updated_by"), array('id' => $groupEditId));

                    $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                            <a href="#" class="uk-alert-close uk-close"></a>Group master updated successfully. !!!</div>');
                    $this->redirect('/Competency/addGroup');
                }
            }

            $this->set('groupEdit', $groupEdit);
            $this->set('groupEditId', $groupEditId);
            $this->set('editGroup', $editGroup);
        }
    }

    function groupDelete($id = null) {
        $this->layout = false;
        $this->autoRender = false;
        if (!empty($id)) {
            if ($this->HcmGroupMaster->delete($id)) {
                $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                        <a href="#" class="uk-alert-close uk-close"></a>Group master deleted successfully. !!!</div>');
                $this->redirect("addGroup");
            } else {
                $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                        <a href="#" class="uk-alert-close uk-close"></a>Group master not deleted successfully. !!!</div>');
                $this->redirect("addGroup");
            }
        } else {
            $this->Session->setFlash('<div class="uk-alert uk-alert-warning" data-uk-alert="">
                        <a href="#" class="uk-alert-close uk-close"></a>Group master is not selected. !!!</div>');
        }
        $this->redirect("addGroup");
        exit;
    }

    public function addGroupCompetency() {
        //Configure::write('debug',2);
        $this->layout = 'employee-new';
        $empCode = $this->Auth->User('emp_code');
        $hoOrgId = $this->Common->getHO($this->Auth->User('comp_code'));
        $orgId = $this->Auth->User('comp_code'); 
        
        $this->set('empCode', $empCode);
        $this->set('hoOrgId', $hoOrgId);
        $this->set('orgId', $orgId);

        $this->paginate = array(
            'limit' => 500,
            'fields' => array('*'),
            'order' => array('GroupCompetency.id' => 'desc')
        );

        $competencyGroupList = $this->paginate('GroupCompetency');
        $this->set("competencyGroupList", $competencyGroupList);

        if (empty($this->request->data['id'])) {

            if ($this->request->is('post') && !empty($this->request->data['group_id'])) {
                $new = 0;
                foreach ($this->data['competency_id'] as $k) {
                    $arrayGroupCompetency['group_id'] = $this->request->data['group_id'];
                    $arrayGroupCompetency['competency_id'] = $this->data['competency_id'][$new];
                    $arrayGroupCompetency['created_by'] = $this->Auth->User('emp_code');
                    $arrayGroupCompetency['ho_org_id'] = $this->Common->getHO($this->Auth->User('comp_code'));
                    $arrayGroupCompetency['org_id'] = $this->Auth->User('comp_code');                
                    $arrayGroupCompetency['created_date'] = date("Y-m-d");

                    $new++;
                    $conditions = array('GroupCompetency.competency_id' => $arrayGroupCompetency["competency_id"], 'group_id' => $arrayGroupCompetency['group_id']);
                    $data = $this->GroupCompetency->find('all', array('conditions' => $conditions));

                    if (count($data) >= 1) {
                        $this->Session->setFlash('<div class="uk-alert uk-alert-primary" data-uk-alert="">
                                <a href="#" class="uk-alert-close uk-close"></a>Competency Group already exists. !!!</div>');
                        //$this->redirect('/Competency/addGroupCompetency');
                    } else {
                        $this->GroupCompetency->create();
                        $saveMessage = $this->GroupCompetency->save($arrayGroupCompetency);
                    }
                }
            }

            if ($saveMessage) {
                $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                    <a href="#" class="uk-alert-close uk-close"></a>Competency Group added successfully. !!!</div>');
                $this->redirect('/Competency/addGroupCompetency');
            }
        }

        ///// Update Competency /////
        if (isset($this->request->params['pass'][0]) == "competencyGroupEdit") {

            $GroupcompetencyEdit = isset($this->request->params['pass'][0]) ? $this->request->params['pass'][0] : "";
            $competencyGroupEditId = isset($this->request->params['pass'][1]) ? $this->request->params['pass'][1] : "";

            $editGroupCompetency = $this->GroupCompetency->find('first', array('fields' => array('GroupCompetency.id', 'GroupCompetency.competency_id', 'GroupCompetency.group_id'),
                'conditions' => array('id' => $competencyGroupEditId)
            ));

            $new = 0;

            foreach ($this->data['competency_id'] as $k) {
                $groupId = $this->request->data['group_id'];
                $competencyId = $this->data['competency_id'][$new];
                $updated_by = $this->Auth->User('emp_code');
                $updated_date = date("Y-m-d");

                $new++;
                $conditions = array("GroupCompetency.competency_id = $competencyId", "group_id = $groupId","id NOT IN($competencyGroupEditId)");
                $data = $this->GroupCompetency->find('all', array('conditions' => $conditions));
                
                if (count($data) >= 1) {
                    $this->Session->setFlash('<div class="uk-alert uk-alert-primary" data-uk-alert="">
                            <a href="#" class="uk-alert-close uk-close"></a>Competency Group already exists. !!!</div>');
                    //$this->redirect('/Competency/addGroupCompetency');
                } else {
                    $this->GroupCompetency->create();
                    $updateMessage = $this->GroupCompetency->updateAll(array('competency_id' => "'$competencyId'", 'group_id' => "'$groupId'", 'updated_date' => "'$updated_date'",'updated_by' => "$updated_by"), array("id = $competencyGroupEditId"));
                }
            }
            if ($updateMessage) {
                $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                        <a href="#" class="uk-alert-close uk-close"></a>Competency updated successfully. !!!</div>');
                $this->redirect("addGroupCompetency");
            }

            $this->set('competencyGroupEdit', $competencyGroupEdit);
            $this->set('competencyGroupEditId', $competencyGroupEditId);
            $this->set('editGroupCompetency', $editGroupCompetency);
        }
    }

    function groupCompetencyDelete($id = null) {
        $this->layout = false;
        $this->autoRender = false;
        if (!empty($id)) {
            if ($this->GroupCompetency->delete($id)) {
                $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                        <a href="#" class="uk-alert-close uk-close"></a>Competency group deleted successfully. !!!</div>');
                $this->redirect("addGroupCompetency");
            } else {
                $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                        <a href="#" class="uk-alert-close uk-close"></a>Competency group not deleted successfully. !!!</div>');
                $this->redirect("addGroupCompetency");
            }
        } else {
            $this->Session->setFlash('<div class="uk-alert uk-alert-warning" data-uk-alert="">
                        <a href="#" class="uk-alert-close uk-close"></a>Competency group is not selected. !!!</div>');
        }
        $this->redirect("addGroupCompetency");
        exit;
    }

    function AssignCompetencyDeptDesg() {
        $this->layout = 'employee-new';
       
        $data = $this->Common->findFInancialYearDesc($this->Auth->User('comp_code'));
        $currentFinancialYear = $data['FinancialYear']['id'];
        
        //$currentFinancialYear = "Apr ".date("Y")." - Mar ".date('Y', strtotime('+1 years'));
        $this->set('currentFinancialYear',$currentFinancialYear);
        
        $empCode = $this->Auth->User('emp_code');
        $hoOrgId = ltrim($this->Common->getHO($this->Auth->User('comp_code')),'0');
        $orgId = ltrim($this->Auth->User('comp_code'), '0'); 

        $this->paginate = array(
            'limit' => '500',
            'fields' => array('*'),
            'order' => array('AssignCompetencyDeptDesg.id' => 'desc')
        );

        $assignCompetencyDeptDesgList = $this->paginate('AssignCompetencyDeptDesg');
        $this->set("assignCompetencyDeptDesgList", $assignCompetencyDeptDesgList);

        $dept = $this->Departments->find('list', array(
            'fields' => array('Departments.dept_code', 'Departments.dept_name'),
            'conditions' => array('Departments.comp_code' => $this->Auth->User('comp_code')),
            'order' => array('Departments.dept_name ASC')
        ));

        $this->set("department_list", $dept);

        $desg = $this->OptionAttribute->find('list', array(
            'fields' => array('OptionAttribute.id', 'OptionAttribute.name'),
            'conditions' => array('OptionAttribute.options_id' => '4','ho_org_id' => $hoOrgId, 'org_id' => $orgId),
            'order' => array('OptionAttribute.name ASC')
        ));
      
        $this->set("designation_list", $desg);

        if (empty($this->request->data['id'])) {

            if ($this->request->is('post') && !empty($this->request->data['dept_id'])) {
                $new = 0;
                foreach ($this->data['competency_id'] as $k) {
                    $arrayAssignCompetencyDeptDesg['financial_year'] = $currentFinancialYear;
                    $arrayAssignCompetencyDeptDesg['dept_id'] = $this->request->data['dept_id'];
                    $arrayAssignCompetencyDeptDesg['desg_id'] = $this->request->data['desg_id'];
                    $arrayAssignCompetencyDeptDesg['emp_id'] = $this->request->data['emp_id'];
                    $arrayAssignCompetencyDeptDesg['competency_id'] = $this->data['competency_id'][$new];
                    $arrayAssignCompetencyDeptDesg['created_by'] = $this->Auth->User('emp_code');
                    $arrayAssignCompetencyDeptDesg['ho_org_id'] = $this->Common->getHO($this->Auth->User('comp_code'));
                    $arrayAssignCompetencyDeptDesg['org_id'] = $this->Auth->User('comp_code');                
                    $arrayAssignCompetencyDeptDesg['created_date'] = date("Y-m-d");

                    $new++;
                    
                    $conditions = array('AssignCompetencyDeptDesg.financial_year' => $arrayAssignCompetencyDeptDesg["financial_year"],
                        'AssignCompetencyDeptDesg.competency_id' => $arrayAssignCompetencyDeptDesg["competency_id"], 
                        'dept_id' => $arrayAssignCompetencyDeptDesg['dept_id'], 
                        'desg_id' => $arrayAssignCompetencyDeptDesg['desg_id'],
                        'emp_id' => $arrayAssignCompetencyDeptDesg['emp_id']);
                    
                    $data = $this->AssignCompetencyDeptDesg->find('all', array('conditions' => $conditions));                    
                 
                    if (count($data) >= 1) {
                        $this->Session->setFlash('<div class="uk-alert uk-alert-primary" data-uk-alert="">
                                <a href="#" class="uk-alert-close uk-close"></a>Assign Competency already exists in this department & designation. !!!</div>');
                        //$this->redirect('/Competency/AssignCompetencyDeptDesg');
                    } else {
                        $this->AssignCompetencyDeptDesg->create();
                        $saveMessage = $this->AssignCompetencyDeptDesg->save($arrayAssignCompetencyDeptDesg);
						
                    }
                }
            }

            if (count($saveMessage)==1) {
                
                /////////Send Mail////
				$kra_config = $this->Session->read('sess_kra_config');
				$From    = $kra_config['MstPmsConfig']['hr_name'];
                $empList = $this->EmpDetail->getEmpEmailDetails($arrayAssignCompetencyDeptDesg['emp_id'],$arrayAssignCompetencyDeptDesg['org_id']);
                
                $empID = $empList['UserDetail']['email'];
                
                $empDetails = $this->EmpDetail->getEmpDetails($arrayAssignCompetencyDeptDesg['emp_id']);                
                
                $data['name'] = $empDetails['MyProfile']['emp_full_name'];
				$data['logo'] ='logo_email.png';
                $contact_number = $empDetails['MyProfile']['contact'];
                
                $To = $empID;
                $CC = $ManagerMailID;
                $sub = "HR has initiated goal setting process, please enter your KRAs";
                $msg = "HR has initiated the goal setting process, kindly login to portal and fill the KRAs.";
                $template = 'pms_notification';
                
                if(isset($To)){
                    echo $success = $this->send_mail($From,$To, $CC, $sub, $msg,$template,$data);
                }
                if(isset($contact_number)){
                     if (isset($contact_number) && preg_match("/^[789]\d{9}$/", $contact_number)) {
                }
                
                $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                    <a href="#" class="uk-alert-close uk-close"></a>Competency assigned successfully. !!!</div>');
                $this->redirect('/Competency/AssignCompetencyDeptDesg');
            }
        }

        ///// Update Competency /////
        if (isset($this->request->params['pass'][0]) == "assignCompetencyDeptDesgEdit") {

            $AssignCompetencyDeptDesgEdit = isset($this->request->params['pass'][0]) ? $this->request->params['pass'][0] : "";
            $assignCompetencyDeptDesgEditId = isset($this->request->params['pass'][1]) ? $this->request->params['pass'][1] : "";

            $editAssignCompetencyDeptDesg = $this->AssignCompetencyDeptDesg->find('first', array('fields' => array('*'),
                'conditions' => array('id' => $assignCompetencyDeptDesgEditId)
            ));

            $new = 0;

            foreach ($this->data['competency_id'] as $k) {
                
                $deptId = $this->request->data['dept_id'];
                $desgId = $this->request->data['desg_id'];
                $empId = $this->request->data['emp_id'];
                $competencyId = $this->data['competency_id'][$new];
                $updated_by = $this->Auth->User('emp_code');
                $updated_date = date("Y-m-d");

                $new++;
                $conditions = array('AssignCompetencyDeptDesg.competency_id' => $competencyId, 'dept_id' => $deptId, 'desg_id' => $desgId, 'emp_id' => $empId,"id NOT IN ($assignCompetencyDeptDesgEditId)");
                $data = $this->AssignCompetencyDeptDesg->find('all', array('conditions' => $conditions));

                if (count($data) >= 1) {
                    $this->Session->setFlash('<div class="uk-alert uk-alert-primary" data-uk-alert="">
                            <a href="#" class="uk-alert-close uk-close"></a>Assign Competency already exists. !!!</div>');
                    //$this->redirect('/Competency/AssignCompetencyDeptDesg');
                } else {
                    $this->AssignCompetencyDeptDesg->create();
                    $updateMessage = $this->AssignCompetencyDeptDesg->updateAll(array('competency_id' => "'$competencyId'", 'dept_id' => "'$deptId'", 'emp_id' => $empId, 'desg_id' => "'$desgId'", 'updated_date' => "'$updated_date'",'updated_by' => "$updated_by"), array('id' => $assignCompetencyDeptDesgEditId));
                }
            }
            if ($updateMessage) {
                $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                        <a href="#" class="uk-alert-close uk-close"></a>Assign Competency updated successfully. !!!</div>');
                $this->redirect("AssignCompetencyDeptDesg");
            }

            $this->set('assignCompetencyDeptDesgEdit', $assignCompetencyDeptDesgEdit);
            $this->set('assignCompetencyDeptDesgEditId', $assignCompetencyDeptDesgEditId);
            $this->set('editAssignCompetencyDeptDesg', $editAssignCompetencyDeptDesg);
        }
    }
	}

    function assignCompetencyDeptDesgDelete($id = null) {
        $this->layout = false;
        $this->autoRender = false;
        if (!empty($id)) {
            if ($this->AssignCompetencyDeptDesg->delete($id)) {
                $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                        <a href="#" class="uk-alert-close uk-close"></a>Assign competency deleted successfully. !!!</div>');
                $this->redirect("AssignCompetencyDeptDesg");
            } else {
                $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                        <a href="#" class="uk-alert-close uk-close"></a>Assign competency not deleted successfully. !!!</div>');
                $this->redirect("AssignCompetencyDeptDesg");
            }
        } else {
            $this->Session->setFlash('<div class="uk-alert uk-alert-warning" data-uk-alert="">
                        <a href="#" class="uk-alert-close uk-close"></a>Record is not selected. !!!</div>');
        }
        $this->redirect("AssignCompetencyDeptDesg");
        exit;
    }

    function AssignCompetencyToEmp() {
        $this->layout = 'employee-new';
        
        $empCode = $this->Auth->User('emp_code');
        $hoOrgId = ltrim($this->Common->getHO($this->Auth->User('comp_code')),'0');
        $orgId = ltrim($this->Auth->User('comp_code'), '0'); 
        
        $this->set('empCode',$empCode);
        $this->set('hoOrgId', $hoOrgId);
        $this->set('orgId', $orgId);
        
        $dept = $this->Departments->find('list', array(
            'fields' => array('Departments.dept_code', 'Departments.dept_name'),
            'conditions' => array('Departments.comp_code' => $this->Auth->User('comp_code'))
        ));

        $this->set("department_list", $dept);
        $this->set('appId', 12);

        if (empty($this->request->data['id'])) {

            if ($this->request->is('post') && !empty($this->request->data['dept_id'])) {
              
//                echo "<pre>";
//                print_r($this->request->data);
//                die;
                
                $arrayAssignCompetencyToEmp['group_comp_id'] = $this->request->data['group_comp_id'];
                $arrayAssignCompetencyToEmp['dept_id'] = $this->request->data['dept_id'];
                $arrayAssignCompetencyToEmp['desg_id'] = $this->request->data['desg_id'];
                $arrayAssignCompetencyToEmp['created_by'] = $this->Auth->User('emp_code');
                $arrayAssignCompetencyToEmp['ho_org_id'] = $this->Common->getHO($this->Auth->User('comp_code'));
                $arrayAssignCompetencyToEmp['org_id'] = $this->Auth->User('comp_code');                
                $arrayAssignCompetencyToEmp['created_date'] = date("Y-m-d");

                $saveMessage = $this->AssignCompetencyToEmp->save($arrayAssignCompetencyToEmp);
                $assignCompetencyToEmpId = $this->AssignCompetencyToEmp->getLastInsertID();
                
                
                $groupCompId = $arrayAssignCompetencyToEmp['group_comp_id'];                
                $deptId = $arrayAssignCompetencyToEmp['dept_id'];
                $desgId = $arrayAssignCompetencyToEmp['desg_id'];

                $new = 0;
                $arrayAssignCompetencyEmp = array();
                foreach ($this->data['emp_id'] as $k) {

                    $arrayAssignCompetencyEmp['assign_comp_to_emp_id'] = $assignCompetencyToEmpId;
                    $arrayAssignCompetencyEmp['emp_id'] = $this->data['emp_id'][$new];
                    $arrayAssignCompetencyEmp['created_date'] = date("Y-m-d");

                    $new++;

                    $dataCount = $this->AssignCompetencyToEmp->find('all', array(
                        'fields' => array('AssignCompetencyToEmp.id'),
                        'joins' => array(
                            array(
                                'table' => 'assign_comp_to_emp_details',
                                'alias' => 'AssignCompToEmpDetails',
                                'type' => 'left',
                                'foreignKey' => false,
                                'conditions' => array("AssignCompetencyToEmp.id = AssignCompToEmpDetails.assign_comp_to_emp_id")
                            )
                        ),
                        'conditions' => array('AssignCompToEmpDetails.emp_id' => $arrayAssignCompetencyEmp['emp_id'],'AssignCompetencyToEmp.group_comp_id' => $groupCompId,'AssignCompetencyToEmp.desg_id' => $desgId)
                    ));

                    if (count($dataCount) == 0) {
                        $this->AssignCompToEmpDetails->create();
                        $saveMessage = $this->AssignCompToEmpDetails->save($arrayAssignCompetencyEmp);
                        
                    } else {
                        $this->AssignCompetencyToEmp->delete($assignCompetencyToEmpId);
                    }
                }
            }
            
            if ($saveMessage) {
                $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                    <a href="#" class="uk-alert-close uk-close"></a>Competency assign added successfully. !!!</div>');
                $this->redirect('/Competency/ViewAssignCompetencyToEmp');
            }
        }
    }
    
    function AssignGroupToDesg() {
        $this->layout = 'employee-new';
        //Configure::write('debug',2);
        $data = $this->Common->findFInancialYearDesc($this->Auth->User('comp_code'));
        $currentFinancialYear = $data['FinancialYear']['id'];
        
        //$currentFinancialYear = "Apr ".date("Y")." - Mar ".date('Y', strtotime('+1 years'));
        $this->set('currentFinancialYear',$currentFinancialYear);
        
        $empCode = $this->Auth->User('emp_code');
        $hoOrgId = ltrim($this->Common->getHO($this->Auth->User('comp_code')),'0');
        $orgId = ltrim($this->Auth->User('comp_code'), '0'); 
        
        $this->set('empCode',$empCode);
        $this->set('hoOrgId', $hoOrgId);
        $this->set('orgId', $orgId);
        
        $dept = $this->Departments->find('list', array(
            'fields' => array('Departments.dept_code', 'Departments.dept_name'),
            'conditions' => array('Departments.comp_code' => $this->Auth->User('comp_code')),
            'order' => 'dept_name ASC'
        ));

        $this->set("department_list", $dept);
        $this->set('appId', 12);

        if (empty($this->request->data['id'])) {
            
            


            if ($this->request->is('post') && !empty($this->request->data['group_comp_id'])){
               
                
                $arrayAssignGroupToDesg['financial_year'] = $currentFinancialYear;
                $arrayAssignGroupToDesg['group_comp_id'] = $this->request->data['group_comp_id'];
                //$arrayAssignGroupToDesg['dept_id'] = $this->request->data['dept_id'];                
                $arrayAssignGroupToDesg['created_by'] = $this->Auth->User('emp_code');
                $arrayAssignGroupToDesg['ho_org_id'] = $this->Common->getHO($this->Auth->User('comp_code'));
                $arrayAssignGroupToDesg['org_id'] = $this->Auth->User('comp_code');                
                $arrayAssignGroupToDesg['created_date'] = date("Y-m-d");
                
                $AssignGroupToDesgId = $this->AssignGroupToDesg->find('all', array(
                    'fields' => array('AssignGroupToDesg.id'),
                    'conditions' => array('AssignGroupToDesg.financial_year' => $arrayAssignGroupToDesg['financial_year'],
                        'AssignGroupToDesg.group_comp_id' => $arrayAssignGroupToDesg['group_comp_id'])
                ));
                
                if(count($AssignGroupToDesgId) == 0){
                    $saveMessage = $this->AssignGroupToDesg->save($arrayAssignGroupToDesg);
                    $AssignGroupToDesgId = $this->AssignGroupToDesg->getLastInsertID();
                
                    $financialYear = $arrayAssignGroupToDesg['financial_year'];                
                    $deptId = $arrayAssignGroupToDesg['dept_id'];
                    //$desgId = $arrayAssignGroupToDesg['desg_id'];
                    
                }else{
                    //echo "<pre>";print_r($AssignGroupToDesgId);die;
                    $AssignGroupToDesgId = $AssignGroupToDesgId[0]['AssignGroupToDesg']['id'];                    
                }

                

                $new = 0;
                $arrayAssignGroupToDesgDetails = array();
                
                foreach ($this->data['desg_id'] as $k) {

                    $arrayAssignGroupToDesgDetails['assign_group_to_desg_id'] = $AssignGroupToDesgId;
                    $arrayAssignGroupToDesgDetails['desg_id'] = $this->data['desg_id'][$new];
                    $arrayAssignGroupToDesgDetails['created_date'] = date("Y-m-d");

                    $new++;
                    
                    $dataCount = $this->AssignGroupToDesgDetails->find('all', array(
                        'fields' => array('AssignGroupToDesgDetails.id'),
                        'conditions' => array(
                            'AssignGroupToDesgDetails.assign_group_to_desg_id' => $AssignGroupToDesgId,
                            'AssignGroupToDesgDetails.desg_id' => $arrayAssignGroupToDesgDetails['desg_id'])
                    ));
                    
                    if (count($dataCount) == 0) {
                        $this->AssignGroupToDesgDetails->create();
                        $saveMessage = $this->AssignGroupToDesgDetails->save($arrayAssignGroupToDesgDetails);
                        
                        /////////////////// Send Mail Start //////////////
                        $kra_config = $this->Session->read('sess_kra_config');
                        $From    = $kra_config['MstPmsConfig']['hr_name'];
					//	Configure::write('debug',2);
						
                        $empListByDesg = $this->Common->findEmpListByDesgCodeDOJ($arrayAssignGroupToDesgDetails['desg_id'],$this->request->data['Competency']['j_date_from'],$this->request->data['Competency']['j_date_to']); 
						//echo '<pre>';print_r($empListByDesg);die;
                        for($i = 0 ; $i < count($empListByDesg); $i++){
                            $empCode = $empListByDesg[$i]['MyProfile']['emp_code'];
                            $compCode = $empListByDesg[$i]['MyProfile']['comp_code'];

                            $empList = $this->EmpDetail->getEmpEmailDetails($empCode,$compCode);
                            $empID = $empList['UserDetail']['email'];

                            $empDetails = $this->EmpDetail->getEmpDetails($empCode);                
                            $data['name'] = $empDetails['MyProfile']['emp_full_name'];
							$data['logo'] ='logo_email.png';
                            $contact_number = $empDetails['MyProfile']['contact'];

                           $kra_config = $this->Session->read('sess_kra_config');
							$ManagerMailID = $kra_config['MstPmsConfig']['hr_name'];
							
                            $To = $empID;
                            $CC = $ManagerMailID;
							$sub = "HR has initiated goal setting process, please enter your KRAs";
							$msg = "HR has initiated the goal setting process, kindly login to portal and fill the KRAs.";
                            
                            $template = 'pms_notification';

                            
                            if(isset($To)){
                                $this->send_mail($From,$To, $CC, $sub, $msg,$template,$data);
                            }
                            
                            if (isset($contact_number) && preg_match("/^[789]\d{9}$/", $contact_number)) {
                                $this->Common->sendSms($contact_number,$msg);
                            }
                        }
                        //////////////////// Send Mail End ///////////////    
                        
                    }else{
                        $this->Session->setFlash('<div class="uk-alert uk-alert-warning" data-uk-alert="">
                        <a href="#" class="uk-alert-close uk-close"></a>Competency Group already assigned. !!!</div>');
                
                    }
                }
            }
            
            if ($saveMessage) {
                
                $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                    <a href="#" class="uk-alert-close uk-close"></a>Competency Group assign successfully. !!!</div>');
                $this->redirect('/Competency/AssignGroupToDesg');
            }
        }
    }
    
    function assignGroupToDesgDelete($id = null) {
        $this->layout = false;
        $this->autoRender = false;
        if (!empty($id)) {
            if ($this->AssignGroupToDesg->delete($id)) {
                
                $this->AssignGroupToDesgDetails->deleteAll(array('AssignGroupToDesgDetails.assign_group_to_desg_id'=> $id));
                $this->AssignGroupToDesg->deleteAll(array('AssignGroupToDesg.id'=> $id));
                
                $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                        <a href="#" class="uk-alert-close uk-close"></a>Assign Group deleted successfully. !!!</div>');
                $this->redirect("ViewAssignGroupToDesg");
            } else {
                $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                        <a href="#" class="uk-alert-close uk-close"></a>Assign Group not deleted successfully. !!!</div>');
                $this->redirect("ViewAssignGroupToDesg");
            }
        } else {
            $this->Session->setFlash('<div class="uk-alert uk-alert-warning" data-uk-alert="">
                        <a href="#" class="uk-alert-close uk-close"></a>Assign Group is not selected. !!!</div>');
        }
        $this->redirect("ViewAssignGroupToDesg");
        exit;
    }

     function levelEmp($dept_code, $appid, $desg_code) {
        $this->set('comp_code', $_SESSION['Auth']['MyProfile']['comp_code']);
        $this->set('dept_code', $dept_code);
        $this->set('appid', $appid);
        $this->set('desg_code', $desg_code);
    }

     function EmpList($desgCode,$deptCode) {
        $this->set('desgCode', $desgCode);
        $this->set('deptCode', $deptCode);
    }
    
     function EmpListSecond($desgCode,$deptCode) {
        $this->set('desgCode', $desgCode);
        $this->set('deptCode', $deptCode);
        $this->set('compCode', $this->Auth->User('comp_code'));
    }

    function DesgList($deptCode) {
		Configure::write('debug',2);
		$this->set('deptCode', $deptCode);
        //$this->set('deptCode', $_POST['dept_id']);
		//$this->set('grp_id', $_POST['grp_id']);		
    }
    
    function DesgListSecond($deptCode) {
        //$this->set('desgCode', $desgCode);
        
        $this->set('deptCode', $deptCode);
        $this->layout = FALSE;  
    }
    
    function ViewAssignGroupToDesg(){
        $this->layout = 'employee-new';
        
        $empCode = $this->Auth->User('emp_code');
        $hoOrgId = ltrim($this->Common->getHO($this->Auth->User('comp_code')),'0');
        $orgId = $this->Auth->User('comp_code');
        
        $this->set('empCode',$empCode);
        $this->set('hoOrgId', $hoOrgId);
        $this->set('orgId', $orgId);

        $this->paginate = array(
            'limit' => 10,
            'fields' => array('*'),
            'conditions' => array('ho_org_id' => $hoOrgId, 'org_id' => $orgId),
            'order' => array('AssignGroupToDesg.id' => 'desc')
        );

        $assignGroupToDesgList = $this->paginate('AssignGroupToDesg');
        $this->set("assignGroupToDesgList", $assignGroupToDesgList);
    }
    
    function AssignGroupToDesgDetails($assignID){
        if($assignID != ""){
            $id = $assignID;
        }else{
            $id = "";
        }        
        
        $assignDesgList = $this->AssignGroupToDesgDetails->find('all', array('fields' => array('OptionAttribute.name'),            
            'conditions' => array('AssignGroupToDesgDetails.assign_group_to_desg_id' => $id),
            'joins' => array(
                array(
                    'table' => 'option_attribute',
                    'alias' => 'OptionAttribute',
                    'type' => 'LEFT',
                    'conditions' => array(
                        'OptionAttribute.id = AssignGroupToDesgDetails.desg_id'
                    )),
            ),
        ));
        $this->set("assignDesgList", $assignDesgList);
        
    }
    
    function AssignCompetencyToEmpDelete($id = null) {
        $this->layout = false;
        $this->autoRender = false;
        if (!empty($id)) {
            if ($this->AssignCompetencyToEmp->delete($id)) {
                
                $this->AssignCompToEmpDetails->deleteAll(array('AssignCompToEmpDetails.assign_comp_to_emp_id'=> $id));
                
                $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                        <a href="#" class="uk-alert-close uk-close"></a>Assign Group deleted successfully. !!!</div>');
                $this->redirect("ViewAssignCompetencyToEmp");
            } else {
                $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                        <a href="#" class="uk-alert-close uk-close"></a>Assign Group not deleted successfully. !!!</div>');
                $this->redirect("ViewAssignCompetencyToEmp");
            }
        } else {
            $this->Session->setFlash('<div class="uk-alert uk-alert-warning" data-uk-alert="">
                        <a href="#" class="uk-alert-close uk-close"></a>Assign Group is not selected. !!!</div>');
        }
        $this->redirect("ViewAssignCompetencyToEmp");
        exit;
    }
    
    function addCompetencyRating() {
        $this->layout = 'employee-new';
        $this->paginate = array(
            'limit' => 15,
            'fields' => array('*'),
            'conditions' => array('CompetencyRating.is_deleted' => 0),
            'order' => array('CompetencyRating.rating_scale' => 'DESC')
        );

        $kraRatingList = $this->paginate('CompetencyRating');
        $this->set("kraRatingList", $kraRatingList);

        if (empty($this->request->data['id'])) {

            if ($this->request->is('post') && !empty($this->request->data['CompetencyRating']['ratingScale'])) {

                $arrayCompetencyRating['rating_scale'] = $this->request->data['CompetencyRating']['ratingScale'];
                //$arrayCompetencyRating['achievement_from'] = $this->request->data['CompetencyRating']['achievement_from'];
                //$arrayCompetencyRating['achievement_to'] = $this->request->data['CompetencyRating']['achievement_to'];
                $arrayCompetencyRating['comment'] = $this->request->data['CompetencyRating']['comment'];
                $arrayCompetencyRating['status'] = $this->request->data['CompetencyRating']['status'];
                
                $arrayCompetencyRating['ho_org_id'] = $this->Common->getHO($this->Auth->User('comp_code'));
                $arrayCompetencyRating['org_id'] = $this->Auth->User('comp_code');
                $arrayCompetencyRating['created_date'] = date("Y-m-d");
                $arrayCompetencyRating['created_by'] = $this->Auth->User('emp_code');

                $conditions = array('CompetencyRating.rating_scale' => $arrayCompetencyRating["rating_scale"],
                    'CompetencyRating.is_deleted' => 0,
                    );
                $data = $this->CompetencyRating->find('all', array('conditions' => $conditions));

                if (count($data) >= 1) {
                    $this->Session->setFlash('<div class="uk-alert uk-alert-primary" data-uk-alert="">
                            <a href="#" class="uk-alert-close uk-close"></a>Competency Rating already exists. !!!</div>');
                    $this->redirect('/Competency/addCompetencyRating');
                } else {
                    $this->CompetencyRating->save($arrayCompetencyRating);
                    $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                            <a href="#" class="uk-alert-close uk-close"></a>Competency Rating added successfully. !!!</div>');
                    $this->redirect('/Competency/addCompetencyRating');
                }
            }
        }        
    }
    
    function competencyRatingDelete($cRId) {
        $this->layout = false;
        $this->autoRender = false;
		$id = base64_decode($cRId);
        $deletedDate = date("Y-d-m");
        if (!empty($id)) {
            $success = $this->CompetencyRating->updateAll(array('deleted_by' => $this->Auth->User('emp_code'), 'is_deleted' => '1', 'deleted_date' => "'$deletedDate'"), array('id' => $id));
            if ($success) {
                $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                        <a href="#" class="uk-alert-close uk-close"></a>Competency deleted successfully. !!!</div>');
                $this->redirect("/Competency/addCompetencyRating");
            } else {
                $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                        <a href="#" class="uk-alert-close uk-close"></a>Competency Rating not deleted successfully. !!!</div>');
                $this->redirect("/Competency/addCompetencyRating");
            }
        } else {
            $this->Session->setFlash('<div class="uk-alert uk-alert-warning" data-uk-alert="">
                        <a href="#" class="uk-alert-close uk-close"></a>Competency is not selected. !!!</div>');
        }
        $this->redirect("/Competency/addCompetencyRating");
        exit;
    }
    
    function CompetencyRatingList() {
       $this->layout = false;
    }
        
    function CompetencyBehaviourList() {
       $ids = json_decode($_POST['id']);
       $this->set('id',$ids);
       $this->layout = false;
       
    }
    
    function AssignMgtGroupToDesg() {
//Configure::write('debug',2);
	$this->layout = 'employee-new';
        
        $empCode = $this->Auth->User('emp_code');
        $hoOrgId = ltrim($this->Common->getHO($this->Auth->User('comp_code')),'0');
        $orgId = $this->Auth->User('comp_code');
        
        $this->set('empCode',$empCode);
        $this->set('hoOrgId', $hoOrgId);
        $this->set('orgId', $orgId);
        
        $this->paginate = array(
            'limit' => 500,
            'fields' => array('*'),
            'conditions' => array('ho_org_id' => $hoOrgId, 'org_id' => $orgId),
            'order' => array('MgtGroupDesg.id' => 'desc')
        );

        $assignMgtGroupToDesgList = $this->paginate('MgtGroupDesg');
        $this->set("assignMgtGroupToDesgList", $assignMgtGroupToDesgList);
	
	$dept = $this->Departments->find('list', array(
		'fields' => array('Departments.dept_code', 'Departments.dept_name'),
		'conditions' => array('Departments.comp_code' => $this->Auth->User('comp_code')),
		'order' => 'dept_name ASC'
	));

	$this->set("department_list", $dept);
	$this->set('appId', 12);

	if (empty($this->request->data['id'])) {
		
            if ($this->request->is('post') && !empty($this->request->data['mgt_group'])){               
                $new = 0;
                
                foreach ($this->request->data['desg_id'] as $k) {

                    $arrayAssignGroupToDesg['mgt_group'] = $this->request->data['mgt_group'];
                    $arrayAssignGroupToDesg['desg_code'] = $this->request->data['desg_id'][$new];                
                    $arrayAssignGroupToDesg['created_by'] = $this->Auth->User('emp_code');
                    $arrayAssignGroupToDesg['ho_org_id'] = $this->Common->getHO($this->Auth->User('comp_code'));
                    $arrayAssignGroupToDesg['org_id'] = $this->Auth->User('comp_code');                
                    $arrayAssignGroupToDesg['created_date'] = date("Y-m-d");

                    $new++;
                    $AssignMgtGroupToDesgId = $this->MgtGroupDesg->find('all', array(
                            'fields' => array('MgtGroupDesg.id'),
                            'conditions' => array('MgtGroupDesg.desg_code' => $arrayAssignGroupToDesg['desg_code'], 'MgtGroupDesg.mgt_group' => $arrayAssignGroupToDesg['mgt_group'])
                    ));

                    if (count($AssignMgtGroupToDesgId) == 0) {
                            $this->MgtGroupDesg->create();
                            $saveMessage = $this->MgtGroupDesg->save($arrayAssignGroupToDesg); 
                            
                    }else{
                            $this->Session->setFlash('<div class="uk-alert uk-alert-warning" data-uk-alert="">
                            <a href="#" class="uk-alert-close uk-close"></a>You can not assign multiple group in one designation.!!!</div>');
                    }
                }
                if ($saveMessage) {
                $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                                <a href="#" class="uk-alert-close uk-close"></a>Designation assign successfully. !!!</div>');
                            
                $this->redirect('/Competency/AssignMgtGroupToDesg');
                }
                
            }
	}      
        
    }
    
    function assignMgtGroupToDesgDelete($id = null) {
        $this->layout = false;
        $this->autoRender = false;
        if (!empty($id)) {
            if ($this->MgtGroupDesg->delete($id)) {
                $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                        <a href="#" class="uk-alert-close uk-close"></a>Designation deleted successfully. !!!</div>');
                $this->redirect("assignMgtGroupToDesg");
            } else {
                $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                        <a href="#" class="uk-alert-close uk-close"></a>Designation not deleted successfully. !!!</div>');
                $this->redirect("assignMgtGroupToDesg");
            }
        } else {
            $this->Session->setFlash(	'<div class="uk-alert uk-alert-warning" data-uk-alert="">
                        <a href="#" class="uk-alert-close uk-close"></a>Designation is not selected. !!!</div>');
        }
        $this->redirect("assignMgtGroupToDesg");
        exit;
    }
    
    function compAssessmentReport(){   
	//Configure::write('debug',2);     
        $data = $this->Common->findFInancialYearDesc($this->Auth->User('comp_code'));
        $currentFinancialYear = $data['FinancialYear']['id'];
        
        $empList = $this->KraTarget->find('all', array(
            'fields' => array('MyProfile.emp_code','MyProfile.emp_id', 'MyProfile.emp_full_name'),
            'order' => array('MyProfile.emp_full_name ASC'),
            'joins' => array(
                array(
                    'table' => 'myprofile',
                    'alias' => 'MyProfile',
                    'type' => 'left',
                    'foreignKey' => false,
                    'conditions' => array('KraTarget.emp_code = MyProfile.emp_code')
                )),
            'group' => array('KraTarget.emp_code'),
			'limit' => 500
            ));

        $this->set('empList', $empList);
        $this->set('currentFinancialYear', $currentFinancialYear);
        
        if (isset($this->request->data['comp_code'])) {            
            $queryCon = "";
            if($this->request->data['emp_id'] != 0){
                $empCode = $this->request->data['emp_id'];
               $queryCon.= "CompetencyTarget.emp_code = $empCode AND ";
            }else{
                $queryCon.= "";
                $empCode = 0;
            }
            
            if ($this->request->data['financialYear'] != "" && $this->request->data['comp_code'] != "0") {
                $financialYear = $this->request->data['financialYear'];
                $queryCon .= "CompetencyTarget.financial_year = $financialYear AND ";
            } else {
                $queryCon.= "";
            }

            if ($this->request->data['financialYear'] != "" && $this->request->data['comp_code'] == "0") {
                $financialYear = $this->request->data['financialYear'];
                $queryCon .= "CompetencyTarget.financial_year = $financialYear";
            } else {
                $queryCon.= "";
            }

            if ($this->request->data['comp_code'] != "" && $this->request->data['comp_code'] != "0") {
                $compCode = $this->request->data['comp_code'] . "%";
                $queryCon .= "myprofile.location_code LIKE '$compCode'";
            } else {
                $queryCon.= "";
            }

            if ($this->request->data['comp_code'] == "0") {
                $compCode = $this->request->data['comp_code'];
                $queryCon.= "";
            }
            
            $conditions = array($queryCon);
            $this->paginate = array(                
                'joins' => array(
                    array(
                        'table' => 'myprofile',
                        'alias' => 'myprofile',
                        'type' => 'inner',
                        'foreignKey' => false,
                        'conditions' => array('CompetencyTarget.emp_code = myprofile.emp_code')
                    ),
					array(
                        'table' => 'appraisal_process',
                        'alias' => 'appraisal_process',
                        'type' => 'inner',
                        'foreignKey' => false,
                        'conditions' => array('CompetencyTarget.emp_code = appraisal_process.emp_code')
                    )
                ),
                'fields' => array('CompetencyTarget.*','myprofile.location_code'),
                'conditions' => $conditions,
                'group' => array('CompetencyTarget.emp_code'),
                
            );

            $compRecordList = $this->paginate('CompetencyTarget');
            $this->set('compRecordList', $compRecordList);
            
            $this->set("empCode",$empCode);
            $this->set("fYear",$financialYear);
            $this->set("companyCode", $this->request->data['comp_code']);
        }
    }
    
    function compAssessmentReportFile($employeeCode, $fYear, $compCode){
        $this->autoRender = false;
        $empCode = base64_decode($employeeCode);
        $financialYear = base64_decode($fYear);
        $cCode = base64_decode($compCode);

        if ($cCode != "0") {
            $companyCode = base64_decode($compCode) . "%";
        } else {
            $companyCode = base64_decode($compCode);
        }
        
        $queryCon = "";
        if($empCode != 0){
            $queryCon.= "emp_code = $empCode AND ";
        }else{
            $queryCon.= "";
            $empCode = 0;
        }

        if ($financialYear != "" && $companyCode != "0") {
            $queryCon .= "CompetencyTarget.financial_year = $financialYear AND ";
        } else {
            $queryCon.= "";
        }

        if ($financialYear != "" && $companyCode == "0") {
            $queryCon .= "CompetencyTarget.financial_year = $financialYear";
        } else {
            $queryCon.= "";
        }

        if ($companyCode != "" && $companyCode != "0") {
            $queryCon .= "myprofile.location_code LIKE '$companyCode'";
        } else {
            $queryCon.= "";
        }

        if ($companyCode == "0") {
            $queryCon.= "";
        }

        $conditions = array($queryCon);
        $this->paginate = array(                
            'fields' => array('CompetencyTarget.*'),
            'conditions' => $conditions,
            'group' => array('emp_code')
        );

        $compRecordList = $this->paginate('CompetencyTarget');
        $this->set('compRecordList', $compRecordList);
        
        $header = array('Sr_No', 'Employee_Code', 'Name', 'Location', 'Department', 'Designation', 'Date_of_Joining', 'Appraiser_Name', 'Appraiser_Designation', 'Reviewer_Name', 'Reviewer_Designation', 'Moderator_Name', 'Moderator_Designation', 'Level_1_Status', 'Level_2_Status', 'Level_3_Status');
        
        
        $ctr = 1;
        foreach ($compRecordList as $key => $value) {

            $appSelfScoreStatus = count($this->Common->getCompetencyTargetLevelOne($compRecordList[$key]['CompetencyTarget']['emp_code'],$compRecordList[$key]['CompetencyTarget']['financial_year']));
            $rewSelfScoreStatus = count($this->Common->getCompetencyTargetDetails($compRecordList[$key]['CompetencyTarget']['emp_code'],$compRecordList[$key]['CompetencyTarget']['financial_year']));
            $modSelfScoreStatus = count($this->Common->getCompetencyTarget($compRecordList[$key]['CompetencyTarget']['emp_code'],$compRecordList[$key]['CompetencyTarget']['financial_year']));
            
            if($appSelfScoreStatus >= 1){                                        
                $levelZeroStatus = "Completed";
            }else{
                $levelZeroStatus = "Pending";
            }

            if($rewSelfScoreStatus >= 1){                                        
                $levelOneStatus = "Completed";
            }else{
                $levelOneStatus = "Pending";
            }

            if($modSelfScoreStatus >= 1){
                $levelTwoStatus = "Completed";
            }else{
                $levelTwoStatus = "Pending";
            }
            
            $location = $this->EmpDetail->getCompanyName($compRecordList[$key]['CompetencyTarget']['comp_code']);
            $desgCode = $this->EmpDetail->findDesignationByEmpCode($compRecordList[$key]['CompetencyTarget']['emp_code']);
            $desgName = $this->EmpDetail->findDesignationName($desgCode,$compRecordList[$key]['CompetencyTarget']['comp_code']);
            
            $empDetails = $this->EmpDetail->getEmpDetails($compRecordList[$key]['CompetencyTarget']['emp_code']);                                       

            $joiningDate =  date('d-m-Y', strtotime($empDetails['MyProfile']['join_date']));
            $manager_code = $this->EmpDetail->findEmpName($empDetails['MyProfile']['manager_code']);
            
            $AppraiserDesgCode =  $this->EmpDetail->getempdesgcode($empDetails['MyProfile']['manager_code']);
            $appraiserDesgName = $this->EmpDetail->findDesignationName($AppraiserDesgCode,$empDetails['MyProfile']['comp_code']);
            
            $reviewerManagerCode = $this->EmpDetail->getManagerCode($empDetails['MyProfile']['manager_code']);
            $reviewerCode =  $this->EmpDetail->findEmpName($reviewerManagerCode);
            
            $reviewerDesgCode = $this->EmpDetail->getempdesgcode($reviewerManagerCode);
            $reviewerDesgName = $this->EmpDetail->findDesignationName($reviewerDesgCode,$empDetails['MyProfile']['comp_code']);
            
            $moderatorName = $this->EmpDetail->findEmpName($compRecordList[$key]['CompetencyTarget']['moderator_id']);
            
            
            $moderatorManagerCode = $this->EmpDetail->getManagerCode($compRecordList[$key]['CompetencyTarget']['moderator_id']);
            $moderatorDesgCode = $this->EmpDetail->getempdesgcode($compRecordList[$key]['CompetencyTarget']['moderator_id']);
            $moderatorDesgName = $this->EmpDetail->findDesignationName($moderatorDesgCode,$empDetails['MyProfile']['comp_code']);
            
            
            $empCode = $compRecordList[$key]['CompetencyTarget']['emp_id'];
            $empName = ucfirst($this->EmpDetail->findEmpName($compRecordList[$key]['CompetencyTarget']['emp_code']));
			$deptCode = $this->EmpDetail->findDepartmentByEmpCode($compRecordList[$key]['CompetencyTarget']['emp_code']); 
            $deptName = $this->EmpDetail->findDepartmentNameByCode($deptCode);
            # code...
		$val['Sr_no'] = $ctr;		
		$val['Employee_Code'] = $empCode;
		$val['Name'] = $empName;
		$val['Location'] = $location;
		$val['Department'] = $deptName;
		$val['Designation'] = $desgName;
		$val['Date_of_Joining'] =  $joiningDate;
		$val['Appraiser_Name'] =  $manager_code;
		$val['Appraiser_Designation'] = $appraiserDesgName;
		$val['Reviewer_Name'] =  $reviewerCode;
		$val['Reviewer_Designation'] = $reviewerDesgName;
		$val['Moderator_Name'] =  $moderatorName;
		$val['Moderator_Designation'] =  $moderatorDesgName;
		$val['Level_0_Status'] =  $levelZeroStatus;
		$val['Level_1_Status'] =  $levelOneStatus;
		$val['Level_2_Status'] =  $levelTwoStatus;		

		$input_array[$ctr] = $val;

		$ctr++;
        }
    // remove html and php tags etc.
        //$contents = strip_tags($contents);
        
        // $this->convert_to_csv_download($input_array,$header,'Competency_Assessment_Report.csv',' ');
		$this->excel($input_array, $header, 'Competency_Assessment_Report.xls');

        //header to make force download the file
        //header('Content-type: application/ms-excel'); /// you can set csv format
        //header("Content-Disposition: attachment; filename=KRA_Assessment_Report_" . date('d-m-Y') . '_' . time() . '.csv');
        //echo $contents;
    }
    
    function convert_to_csv_download($input_array, $header, $output_file_name, $delimiter){
         $f = fopen('php://memory', 'w');
        /** loop through array  */
        fputcsv($f, $header, $delimiter);
        
        foreach ($input_array as $line) {
            /** default php csv handler **/
            fputcsv($f, $line, $delimiter);
        }
        fseek($f, 0);
        // tell the browser it's going to be a csv file
        header('Content-Type: application/csv');
        // tell the browser we want to save it instead of displaying it
        header('Content-Disposition: attachment; filename="'.$output_file_name.'";');
        // make php send the generated csv lines to the browser
        fpassthru($f);
    } 
	function excel($data, $header, $filename) {
       // Configure::write('debug', 2);
       // print_r($data); die;
        App::import('Vendor', 'PHPExcel/Classes/PHPExcel');
        //$folderToSaveXls = 'C:\wamp\www\hrportal_live';
        
        $objReader = PHPExcel_IOFactory::createReader("Excel5");
        $objPHPExcel = new PHPExcel();
		
		$objPHPExcel->getProperties()->setCreator("ESS India")
                ->setLastModifiedBy("ESS India")
                ->setTitle("Online Report")
                ->setSubject("Online Report")
                ->setDescription("ESS India")
                ->setKeywords("ESS India")
                ->setCategory("ESS India");
		
		$no=1;
		$letter = 'A';
				
		foreach($header as $ha){
			//print_r($ha);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($letter++.$no, $ha);
        }
		
		$no=2;
		$letter = 'A';
		
		foreach($data as $da){
			//print_r($da);
			foreach($da as $val){
				//print_r($val);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue($letter++.$no, $val);
			}
			
           
			$no++;
			$letter = 'A';
        }
		
        ob_clean();
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        header('Content-Type: application/vnd.ms-excel');
        header("Content-Type:application/force-download");
        header('Content-Disposition: attachment;filename="'.$filename.'"');
        header('Cache-Control: max-age=0');
	$objWriter->save('php://output');
		
    }

}
