<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of KpiMastersController
 *
 * @author hp4420-28u
 */
class KpiMastersController extends AppController {

    var $uses = array('KpiMasters', 'KraMasters', 'KpiMapEmps', 'KraMapEmp', 'Departments', 'Target', 'MyProfile', 'KraKpiProcess','kpiType');
    var $components = array('Session', 'Cookie', 'RequestHandler', 'Auth', 'EmpDetail');
    var $helpers = array('Html', 'Js', 'Form', 'Session', 'Userdetail', 'Leave', 'Common');

    function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow();
        $this->layout = 'employee-new';
        $department = $this->Department->find('list', array(
            'fields' => array('Department.dept_code', 'Department.dept_name'),
            'conditions' => array(
                'comp_code' => '01')
        ));
        $kraList = $this->KraMapEmp->find('list', array(
            'joins' => array(
                array(
                    'table' => 'kra_masters',
                    'alias' => 'KraMaster',
                    'type' => 'INNER',
                    'conditions' => array(
                        'KraMaster.id = KraMapEmp.kramasters_id'
                    )
                )
            ),
            'conditions' => array("OR" => array(
                    "KraMapEmp.myprofile_id" => $this->Auth->User('emp_code'),
                    "KraMaster.user_emp_code" => $this->Auth->User('emp_code')
                )),
            'fields' => array('KraMaster.id', 'KraMaster.kra_name'),
            'order' => 'KraMaster.created_at DESC'
        ));

        $targets = $this->Target->find('list', array(
            'fields' => array('Target.id', 'Target.target_name')
        ));
        $kpiNamelist = $this->KpiMapEmps->find('list', array(
            'joins' => array(
                array(
                    'table' => 'kpi_masters',
                    'alias' => 'KpiMaster',
                    'type' => 'INNER',
                    'conditions' => array(
                        'KpiMaster.id = KpiMapEmps.kpi_masters_id'
                    )
                )
            ),
            'conditions' => array("OR" => array(
                    "KpiMapEmps.myprofile_id" => $this->Auth->User('emp_code'),
                    "KpiMaster.user_emp_code" => $this->Auth->User('emp_code')
                )),
            'fields' => array('KpiMaster.id', 'KpiMaster.kpi_name'),
            'order' => 'KpiMaster.created_at DESC'
        ));

        $this->set("kpiNamelist", $kpiNamelist);
        $this->set('kraLists', $kraList);
        $this->set('departments', $department);
        $this->set('targets', $targets);
        $this->set('appId', 12);
    }

    public function add() {
        
    }

    public function levelEmp($dept_code, $appid, $desg_code) {
        $this->set('dept_code', $dept_code);
        $this->set('appid', $appid);
        $this->set('desg_code', $desg_code);
    }

    public function addnew() {
        
    }

    public function kpiSaveInfo() {

        if ($this->__kpiSave($this->request->data))
            $this->Session->setFlash('Kpi addead Successfully');
        else
            $this->Session->setFlash('Kpi not addead Successfully');
        $this->redirect('/kpiMasters/view');
    }

    protected function __kpiSave($param) {
        $values = $param;
        App::import('Helper', 'Common');
        $commonHelper = new CommonHelper();
        $myprofile = $this->MyProfile->find('first', array(
            'fields' => array('MyProfile.desg_code', 'MyProfile.comp_code'),
            'conditions' => array(
                'emp_code' => $this->Auth->User('emp_code'))
        ));
        try {
            if (!empty($values['kpi_name'])) {
                foreach ($values['kpi_name'] as $key => $val) {
                    if (!empty($values['kpi_name'][$key])) {
                        $value['kpi_name'] = $values['kpi_name'][$key];
                        $value['created_at'] = date('Y-m-d');
                        $value['user_emp_code'] = $this->Auth->User('emp_code');
                        $value['department_id'] = $commonHelper->findDepartmentId($values['kpi_department_id'][$key]);
                        $this->KpiMasters->create();
                        if ($this->KpiMasters->save($value)) {
                            $lastInsertedId = $this->KpiMasters->getLastInsertId();
                            $kpiMapValue['kra_masters_id'] = $values['kpi_kra_id'][$key];
                            $kpiMapValue['kpi_masters_id'] = $lastInsertedId;
                            $kpiMapValue['myprofile_id'] = $values['employee_name'][$key];
                            $kpiMapValue['kpi_user_emp_code'] = $this->Auth->User('emp_code');
                            $kpiMapValue['level_desg_code'] = $myprofile['MyProfile']['desg_code'];
                            $kpiMapValue['target'] = $values['kpi_target'][$key];
                            $kpiMapValue['weightage'] = $values['kpi_weightage'][$key];
                            $kpiMapValue['from_date'] = date('Y-m-d', strtotime($values['kpi_start_date'][$key]));
                            $kpiMapValue['to_date'] = date('Y-m-d', strtotime($values['kpi_end_date'][$key]));
                            $this->KpiMapEmps->create();
                            $this->KpiMapEmps->save($kpiMapValue);
                            $status = true;
                        } else {
                            $status = false;
                        }
                        unset($value, $kpiMapValue);
                    }
                }
            }
        } catch (Exception $ex) {
            
        }
        return $status;
    }

    public function view() {
        try {
            $this->layout = 'employee-new';
            $kpiValues = $this->KpiMapEmps->find('all', array(
                'joins' => array(
                    array(
                        'table' => 'myprofile',
                        'alias' => 'MyProfile',
                        'type' => 'INNER',
                        'conditions' => array(
                            'MyProfile.emp_code = KpiMapEmps.myprofile_id'
                        )
                    ),
                    array(
                        'table' => 'kpi_masters',
                        'alias' => 'KpiMaster',
                        'type' => 'INNER',
                        'conditions' => array(
                            'KpiMaster.id = KpiMapEmps.kpi_masters_id'
                        )
                    ),
                    array(
                        'table' => 'kra_masters',
                        'alias' => 'KraMaster',
                        'type' => 'INNER',
                        'conditions' => array(
                            'KraMaster.id = KpiMapEmps.kra_masters_id'
                        )
                    )
                ),
                'conditions' => array(
                    'KpiMapEmps.kpi_user_emp_code' => $this->Auth->User('emp_code')
                ),
                'fields' => array('KpiMapEmps.*', 'KpiMaster.kpi_name', 'MyProfile.emp_firstname', 'MyProfile.emp_lastname', 'KraMaster.kra_name'),
                'order' => 'KpiMaster.created_at DESC'
            ));

            $this->set('kpiValues', $kpiValues);
        } catch (Exception $ex) {
            
        }
    }

    public function editKpiDetail($id) {
        $this->layout = 'employee-new';
        App::import('Helper', 'Common');
        $commonHelper = new CommonHelper();
        $id = base64_decode($id);
        try {
            if (!empty($id)) {
                $kpiValues = $this->KpiMapEmps->find('first', array(
                    'joins' => array(
                        array(
                            'table' => 'myprofile',
                            'alias' => 'MyProfile',
                            'type' => 'INNER',
                            'conditions' => array(
                                'MyProfile.emp_code = KpiMapEmps.myprofile_id'
                            )
                        ),
                        array(
                            'table' => 'kpi_masters',
                            'alias' => 'KpiMaster',
                            'type' => 'INNER',
                            'conditions' => array(
                                'KpiMaster.id = KpiMapEmps.kpi_masters_id'
                            )
                        )
                        ,
                        array(
                            'table' => 'kra_masters',
                            'alias' => 'KraMaster',
                            'type' => 'INNER',
                            'conditions' => array(
                                'KraMaster.id = KpiMapEmps.kra_masters_id'
                            )
                        )
                    ),
                    'conditions' => array(
                        'KpiMapEmps.kpi_user_emp_code' => $this->Auth->User('emp_code'),
                        'KpiMapEmps.id' => $id
                    ),
                    'fields' => array('KpiMapEmps.*', 'KpiMaster.kpi_name', 'MyProfile.emp_firstname', 'MyProfile.emp_lastname', 'KraMaster.kra_name'),
                    'order' => 'KpiMaster.created_at DESC'
                ));
                $departmentList = $this->EmpDetail->getdepartmentlist();
                $dept = $this->Departments->find('first', array(
                    'fields' => array('Departments.dept_code'),
                    'conditions' => array('Departments.id' => 1)
                ));
                $targets = $this->Target->find('list', array(
                    'fields' => array('Target.id', 'Target.target_name')
                ));

                $dept_code = $dept['Departments']['dept_code'];
                $this->set('departmentList', $departmentList);
                $this->set('dept_code', $dept_code);
                $this->set('targets', $targets);
                $this->set('target', $kpiValues['KpiMapEmps']['target']);
                $this->set('weightage', $kpiValues['KpiMapEmps']['weightage']);
                $this->set('kpiName', $kpiValues['KpiMaster']['kpi_name']);
                $this->set('kraId', $kpiValues['KpiMapEmps']['kra_masters_id']);
                $this->set('kpiMapEmpId', $kpiValues['KpiMapEmps']['id']);
                $this->set('kpiId', $kpiValues['KpiMapEmps']['kpi_masters_id']);
                $this->set('employeeID', $kpiValues['KpiMapEmps']['myprofile_id']);
                $this->set('kraName', $kpiValues['KraMaster']['kra_name']);
                $this->set('kpi_start_date', $kpiValues['KpiMapEmps']['from_date']);
                $this->set('kpi_end_date', $kpiValues['KpiMapEmps']['to_date']);
                $this->set('appId', 12);
                $this->render('editKpiDetail');
            } else {
                
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function editKpiSaveInfo() {
        $values = $this->request->data;
        $this->KpiMasters->id = $values['kpiId'];
        $myprofile = $this->MyProfile->find('first', array(
            'fields' => array('MyProfile.desg_code', 'MyProfile.comp_code'),
            'conditions' => array(
                'emp_code' => $this->Auth->User('emp_code'))
        ));
        if (!$this->KpiMasters->exists()) {
            throw new NotFoundException(__('Invalid model'));
        }
        App::import('Helper', 'Common');
        $commonHelper = new CommonHelper();
        if (!empty($values['Kpi']['department_id']) && !empty($values['Kpi']['employee_name']) && $this->request->is('post')) {
            $value['kpi_name'] = $values['Kpi']['kpiName'];
            $value['user_emp_code'] = $this->Auth->User('emp_code');
            $value['department_id'] = $commonHelper->findDepartmentId($values['Kpi']['department_id']);
            $value['id'] = $this->KpiMasters->id;
            $this->KpiMapEmps->id = $values['kpiMapId'];
            if ($this->KpiMasters->save($value)) {
                $employeeProfileID = $values['Kpi']['employee_name'];
                if (!empty($this->KpiMapEmps->id)) {
                    $this->KpiMapEmps->saveField('kra_masters_id', $values['kraId']);
                    $this->KpiMapEmps->saveField('kpi_masters_id', $values['kpiId']);
                    $this->KpiMapEmps->saveField('myprofile_id', $employeeProfileID);
                    $this->KpiMapEmps->saveField('kpi_user_emp_code', $this->Auth->User('emp_code'));
                    $this->KpiMapEmps->saveField('level_desg_code', $myprofile['MyProfile']['desg_code']);
                    $this->KpiMapEmps->saveField('target', $values['Kpi']['target']);
                    $this->KpiMapEmps->saveField('weightage', $values['weightage']);
                    $this->KpiMapEmps->saveField('from_date', date('Y-m-d', strtotime($values['kpi_start_date'])));
                    $this->KpiMapEmps->saveField('to_date', date('Y-m-d', strtotime($values['kpi_end_date'])));
                    $this->Session->setFlash(__('The Kpi has been saved'));
                    $this->redirect('/kpiMasters/view');
                }
            } else {
                $this->Session->setFlash(__('The Kpi could not be saved. Please, try again.'));
                $this->redirect('/kpiMasters/view');
            }
        } else {
            
        }
    }

    public function kpidetail() {
        try {
            $id = $this->params['pass']['0'];

            if (!empty($id)) {
                $kpiValues = $this->KpiMapEmps->find('first', array(
                    'joins' => array(
                        array(
                            'table' => 'myprofile',
                            'alias' => 'MyProfile',
                            'type' => 'INNER',
                            'conditions' => array(
                                'MyProfile.emp_code = KpiMapEmps.myprofile_id'
                            )
                        ),
                        array(
                            'table' => 'kpi_masters',
                            'alias' => 'KpiMaster',
                            'type' => 'INNER',
                            'conditions' => array(
                                'KpiMaster.id = KpiMapEmps.kpi_masters_id'
                            )
                        )
                        ,
                        array(
                            'table' => 'kra_masters',
                            'alias' => 'KraMaster',
                            'type' => 'INNER',
                            'conditions' => array(
                                'KraMaster.id = KpiMapEmps.kra_masters_id'
                            )
                        )
                    ),
                    'conditions' => array(
                        'KpiMapEmps.kpi_user_emp_code' => $this->Auth->User('emp_code'),
                        'KpiMapEmps.id' => $id
                    ),
                    'fields' => array('KpiMapEmps.*', 'KpiMaster.kpi_name', 'MyProfile.emp_firstname', 'MyProfile.emp_lastname', 'KraMaster.kra_name'),
                    'order' => 'KpiMaster.created_at DESC'
                ));

                $this->set('kpiValues', $kpiValues);
                $this->set('tab', $this->__calcAssessmentTab($kpiValues['KpiMapEmps']['target'], $kpiValues['KpiMapEmps']['from_date'], $kpiValues['KpiMapEmps']['to_date']));
                $this->set('kpiName', $kpiValues['KpiMaster']['kpi_name']);
                $this->set('kraName', $kpiValues['KraMaster']['kra_name']);
                $this->set('kraId', $kpiValues['KpiMapEmps']['kra_masters_id']);
                $this->set('kpiMapEmpId', $kpiValues['KpiMapEmps']['id']);
                $this->set('kpiId', $kpiValues['KpiMapEmps']['kpi_masters_id']);
                $this->set('assign_emp_code', $kpiValues['KpiMapEmps']['kpi_user_emp_code']);
                $this->set('appId', 12);
                $this->set('myprofile_id', $this->Auth->User('emp_code'));
                $this->layout = '';
                $this->render('kpidetail');
            }
        } catch (Exception $e) {
            
        }
    }

    public function assignKpi() {
        
    }

    public function kpiAssignSaveInfo() {
        $values = $this->request->data;
        App::import('Helper', 'Common');
        $commonHelper = new CommonHelper();
        $myprofile = $this->MyProfile->find('first', array(
            'fields' => array('MyProfile.desg_code', 'MyProfile.comp_code'),
            'conditions' => array(
                'emp_code' => $this->Auth->User('emp_code'))
        ));
        try {
            if (!empty($values['kpi_name'])) {
                foreach ($values['kpi_name'] as $key => $val) {
                    if (!empty($values['kpi_name'][$key])) {
                        $this->KpiMapEmps->create();
                        $kpiMapValue['kra_masters_id'] = $values['kpi_kra_id'][$key];
                        $kpiMapValue['kpi_masters_id'] = $values['kpi_name'][$key];
                        $kpiMapValue['myprofile_id'] = $values['employee_name'][$key];
                        $kpiMapValue['kpi_user_emp_code'] = $this->Auth->User('emp_code');
                        $kpiMapValue['level_desg_code'] = $myprofile['MyProfile']['desg_code'];
                        $kpiMapValue['target'] = $values['kpi_target'][$key];
                        $kpiMapValue['weightage'] = $values['kpi_weightage'][$key];
                        $kpiMapValue['from_date'] = date('Y-m-d', strtotime($values['kpi_start_date'][$key]));
                        $kpiMapValue['to_date'] = date('Y-m-d', strtotime($values['kpi_end_date'][$key]));
                        $this->KpiMapEmps->save($kpiMapValue);
                        unset($kpiMapValue);
                    }
                }
                $this->Session->setFlash(__('The Kpi has been saved'));
                $this->redirect('/kpiMasters/view');
            }
        } catch (Exception $ex) {
            
        }
    }

    public function index() {
        $kralist = $this->KpiMapEmps->find('all', array(
            'joins' => array(
                array(
                    'table' => 'kpi_masters',
                    'alias' => 'KpiMaster',
                    'type' => 'INNER',
                    'conditions' => array(
                        'KpiMaster.id = KpiMapEmps.kpi_masters_id'
                    )
                ),
                array(
                    'table' => 'kra_masters',
                    'alias' => 'KraMaster',
                    'type' => 'INNER',
                    'conditions' => array(
                        'KraMaster.id = KpiMapEmps.kra_masters_id'
                    )
                ),
                array(
                    'table' => 'myprofile',
                    'alias' => 'MyProfile',
                    'type' => 'INNER',
                    'conditions' => array(
                        'MyProfile.emp_code = KpiMapEmps.myprofile_id'
                    )
                )
            ),
            'conditions' => array(
                'KpiMapEmps.myprofile_id' => $this->Auth->User('emp_code'),
                'KraMaster.status' => 0,
            ),
            'fields' => array('KpiMapEmps.*', 'MyProfile.emp_firstname', 'MyProfile.emp_lastname', 'KraMaster.kra_name', 'KpiMaster.kpi_name'),
            'order' => 'KpiMaster.created_at DESC'
        ));

        $kpiProcessList = $this->KpiMapEmps->find('all', array(
            'joins' => array(
                array(
                    'table' => 'kpi_masters',
                    'alias' => 'KpiMaster',
                    'type' => 'INNER',
                    'conditions' => array(
                        'KpiMaster.id = KpiMapEmps.kpi_masters_id'
                    )
                ),
                array(
                    'table' => 'kra_masters',
                    'alias' => 'KraMaster',
                    'type' => 'INNER',
                    'conditions' => array(
                        'KraMaster.id = KpiMapEmps.kra_masters_id'
                    )
                ),
                array(
                    'table' => 'myprofile',
                    'alias' => 'MyProfile',
                    'type' => 'INNER',
                    'conditions' => array(
                        'MyProfile.emp_code = KpiMapEmps.myprofile_id'
                    )
                ),
                array(
                    'table' => 'kra_kpi_process',
                    'alias' => 'KraKpiProcess',
                    'type' => 'INNER',
                    'conditions' => array(
                        'KraKpiProcess.kpi_masters_id = KpiMapEmps.kpi_masters_id',
                        'KraKpiProcess.kra_masters_id = KpiMapEmps.kra_masters_id',
                        'KraKpiProcess.kpi_map_emps_id = KpiMapEmps.id'
                    )
                )
            ),
            'conditions' => array(
                'KpiMapEmps.myprofile_id' => $this->Auth->User('emp_code'),
                'KraMaster.status' => 0,
            ),
            'fields' => array('KpiMapEmps.*', 'KraKpiProcess.*', 'MyProfile.emp_firstname', 'MyProfile.emp_lastname', 'KraMaster.kra_name', 'KpiMaster.kpi_name'),
             'order' => 'KraKpiProcess.process_quarter DESC,KraKpiProcess.updated_at ASC'
        ));

        $targets = $this->Target->find('list', array(
            'fields' => array('Target.id', 'Target.target_name')
        ));

        $this->set('targets', $targets);
        $this->set("kraValues", $kralist);
        $this->set("kpiProcessList", $kpiProcessList);
    }

    public function editKpi($id) {
        $this->layout = 'employee-new';
        App::import('Helper', 'Common');
        $commonHelper = new CommonHelper();
        $id = base64_decode($id);

        try {
            if (!empty($id)) {
                $kpiValues = $this->KpiMapEmps->find('first', array(
                    'joins' => array(
                        array(
                            'table' => 'myprofile',
                            'alias' => 'MyProfile',
                            'type' => 'INNER',
                            'conditions' => array(
                                'MyProfile.emp_code = KpiMapEmps.myprofile_id'
                            )
                        ),
                        array(
                            'table' => 'kpi_masters',
                            'alias' => 'KpiMaster',
                            'type' => 'INNER',
                            'conditions' => array(
                                'KpiMaster.id = KpiMapEmps.kpi_masters_id'
                            )
                        )
                        ,
                        array(
                            'table' => 'kra_masters',
                            'alias' => 'KraMaster',
                            'type' => 'INNER',
                            'conditions' => array(
                                'KraMaster.id = KpiMapEmps.kra_masters_id'
                            )
                        ),
                        array(
                            'table' => 'kra_kpi_process',
                            'alias' => 'KraKpiProcess',
                            'type' => 'INNER',
                            'conditions' => array(
                                'KraKpiProcess.kpi_masters_id = KpiMapEmps.kpi_masters_id',
                                'KraKpiProcess.kra_masters_id = KpiMapEmps.kra_masters_id',
                                'KraKpiProcess.kpi_map_emps_id = KpiMapEmps.id'
                            )
                        )
                    ),
                    'conditions' => array(
                        'KpiMapEmps.myprofile_id' => $this->Auth->User('emp_code'),
                        'KraKpiProcess.id' => $id
                    ),
                    'fields' => array('KpiMapEmps.*', 'KraKpiProcess.*', 'KpiMaster.*', 'MyProfile.*', 'KraMaster.*'),
                    'order' => 'KpiMaster.created_at DESC'
                ));
                $departmentList = $this->EmpDetail->getdepartmentlist();
                $dept = $this->Departments->find('first', array(
                    'fields' => array('Departments.dept_code'),
                    'conditions' => array('Departments.id' => 1)
                ));
                $targets = $this->Target->find('list', array(
                    'fields' => array('Target.id', 'Target.target_name')
                ));

                $dept_code = $dept['Departments']['dept_code'];
                $this->set('kpiName', $kpiValues['KpiMaster']['kpi_name']);
                $this->set('kraName', $kpiValues['KraMaster']['kra_name']);
                $this->set('kraId', $kpiValues['KpiMapEmps']['kra_masters_id']);
                $this->set('kpiMapEmpId', $kpiValues['KpiMapEmps']['id']);
                $this->set('kpiId', $kpiValues['KpiMapEmps']['kpi_masters_id']);
                $this->set('assign_emp_code', $kpiValues['KpiMapEmps']['kpi_user_emp_code']);
                $this->set('comment', $kpiValues['KraKpiProcess']['comment']);
                $this->set('units', $kpiValues['KraKpiProcess']['units']);
                $this->set('kraKpiProcess', $kpiValues['KraKpiProcess']['id']);
                $this->set('appId', 12);
                $this->set('myprofile_id', $this->Auth->User('emp_code'));
                $this->render('editKpi');
            } else {
                
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function editKpiSave() {
        $values = $this->request->data;

        App::import('Helper', 'Common');
        $commonHelper = new CommonHelper();
        $myprofile = $this->MyProfile->find('first', array(
            'fields' => array('MyProfile.desg_code', 'MyProfile.comp_code'),
            'conditions' => array(
                'emp_code' => $this->Auth->User('emp_code'))
        ));
        try {
            if (!empty($values['kraId']) && !empty($values['kraKpiProcess']) && (!empty($values['kpiId']))) {
                $value['kra_masters_id'] = $values['kraId'];
                $value['kpi_masters_id'] = $values['kpiId'];
                $value['kpi_map_emps_id'] = $values['kpiMapEmpId'];
                $value['myprofile_id'] = $values['myprofile_id'];
                $value['comment'] = $values['Kpi']['kpiComment'];
                $value['units'] = $values['Kpi']['kpiUnit'];
                $value['user_emp_id'] = $values['assign_emp_code'];
                $this->KraKpiProcess->id = $values['kraKpiProcess'];
                if ($this->KraKpiProcess->save($value)) {
                    $this->Session->setFlash('Kpi Edited Successfully');
                    $this->redirect('/kpiMasters');
                } else {
                    $this->Session->setFlash('Kpi Not Edited Successfully');
                    $this->redirect('/kpiMasters');
                }
                unset($value, $kpiMapValue);
            }
        } catch (Exception $ex) {
            
        }
    }

    public function addKpiUnit($id) {
        $this->layout = 'employee-new';
        App::import('Helper', 'Common');
        $commonHelper = new CommonHelper();
        $id = base64_decode($id);

        try {
            if (!empty($id)) {
                $kpiValues = $this->KpiMapEmps->find('first', array(
                    'joins' => array(
                        array(
                            'table' => 'myprofile',
                            'alias' => 'MyProfile',
                            'type' => 'INNER',
                            'conditions' => array(
                                'MyProfile.emp_code = KpiMapEmps.myprofile_id'
                            )
                        ),
                        array(
                            'table' => 'kpi_masters',
                            'alias' => 'KpiMaster',
                            'type' => 'INNER',
                            'conditions' => array(
                                'KpiMaster.id = KpiMapEmps.kpi_masters_id'
                            )
                        )
                        ,
                        array(
                            'table' => 'kra_masters',
                            'alias' => 'KraMaster',
                            'type' => 'INNER',
                            'conditions' => array(
                                'KraMaster.id = KpiMapEmps.kra_masters_id'
                            )
                        )
                    ),
                    'conditions' => array(
                        'KpiMapEmps.myprofile_id' => $this->Auth->User('emp_code'),
                        'KpiMapEmps.id' => $id
                    ),
                    'fields' => array('KpiMapEmps.*', 'KpiMaster.*', 'MyProfile.*', 'KraMaster.*'),
                    'order' => 'KpiMaster.created_at DESC'
                ));
                $departmentList = $this->EmpDetail->getdepartmentlist();
                $dept = $this->Departments->find('first', array(
                    'fields' => array('Departments.dept_code'),
                    'conditions' => array('Departments.id' => 1)
                ));
                $targets = $this->Target->find('list', array(
                    'fields' => array('Target.id', 'Target.target_name')
                ));

                $dept_code = $dept['Departments']['dept_code'];
                $this->set('tab', $this->__calcAssessmentTab($kpiValues['KpiMapEmps']['target'], $kpiValues['KpiMapEmps']['from_date'], $kpiValues['KpiMapEmps']['to_date']));
                $this->set('kpiName', $kpiValues['KpiMaster']['kpi_name']);
                $this->set('kraName', $kpiValues['KraMaster']['kra_name']);
                $this->set('kraId', $kpiValues['KpiMapEmps']['kra_masters_id']);
                $this->set('kpiMapEmpId', $kpiValues['KpiMapEmps']['id']);
                $this->set('kpiId', $kpiValues['KpiMapEmps']['kpi_masters_id']);
                $this->set('assign_emp_code', $kpiValues['KpiMapEmps']['kpi_user_emp_code']);
                $this->set('appId', 12);
                $this->set('myprofile_id', $this->Auth->User('emp_code'));
                $this->render('addKpiUnit');
            } else {
                
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function addKpiUnitSave() {
        $values = $this->request->data;

        App::import('Helper', 'Common');
        $commonHelper = new CommonHelper();
        $myprofile = $this->MyProfile->find('first', array(
            'fields' => array('MyProfile.desg_code', 'MyProfile.comp_code'),
            'conditions' => array(
                'emp_code' => $this->Auth->User('emp_code'))
        ));
        try {
            if (!empty($values['kraId']) && (!empty($values['kpiId']))) {
                $value['kra_masters_id'] = $values['kraId'];
                $value['kpi_masters_id'] = $values['kpiId'];
                $value['kpi_map_emps_id'] = $values['kpiMapEmpId'];
                $value['myprofile_id'] = $values['myprofile_id'];
                $value['comment'] = $values['Kpi']['kpiComment'];
                $value['units'] = $values['Kpi']['kpiUnit'];
                $value['user_emp_id'] = $values['assign_emp_code'];
                $value['process_quarter'] = $values['process_quarter'];
                $this->KraKpiProcess->create();
                if ($this->KraKpiProcess->save($value)) {
                    $this->Session->setFlash('Kpi addead Successfully');
                    $this->redirect('/kpiMasters');
                } else {
                    $this->Session->setFlash('Kpi not addead Successfully');
                    $this->redirect('/kpiMasters');
                }
                unset($value, $kpiMapValue);
            }
        } catch (Exception $ex) {
            
        }
    }

    protected function __dateDifference($date_1, $date_2, $differenceFormat = '%a') {
        $datetime1 = date_create($date_1);
        $datetime2 = date_create($date_2);
        $interval = date_diff($datetime1, $datetime2);
        return $interval->format($differenceFormat);
    }

    protected function __diff_in_weeks_and_days($from, $to) {
        $day = 24 * 3600;
        $from = strtotime($from);
        $to = strtotime($to) + $day;
        $diff = abs($to - $from);
        $weeks = floor($diff / $day / 7);
        $days = $diff / $day - $weeks * 7;
        $out = array();
        if ($weeks)
            $out[] = "$weeks" . ($weeks > 1 ? '' : '');
        if ($days)
            $out[] = "$days" . ($days > 1 ? '' : '');

        return $out[0];
    }

    protected function __diff_in_month($from, $to) {
        $d1 = strtotime("$from");
        $d2 = strtotime("$to");
        $min_date = min($d1, $d2);
        $max_date = max($d1, $d2);
        $i = 0;
        while (($min_date = strtotime("+1 MONTH", $min_date)) <= $max_date) {
            $i++;
        }
        return $i;
    }

    protected function __calcAssessmentTab($target, $from, $to) {
        $value = '';
        if ($target == 1) {
            $weak = $this->__diff_in_weeks_and_days($to, $from);
            $value = $weak;
        } elseif ($target == 2) {
            $month = $this->__diff_in_month($from, $to);
            $value = $month;
            if ($month < 3) {
                $value = $month;
            } else {
                $value = $month / 3;
            }
        } elseif ($target == 3) {
            $month = $this->__diff_in_month($from, $to);
            $value = $month;
            if ($month < 6) {
                $value = $month;
            } else {
                $value = $month / 6;
            }
        } elseif ($target == 4) {
            $year = $this->__dateDifference($to, $from);
            $value = $year;
        }
        return $value;
    }
    public function addKpiType() {
        $this->layout = 'admin';
        $kpiArray = array();
        
        $totalRecords = $this->kpiType->find('first', array('fields' => array('kpi_type'),
            'order' => array('id' => 'DESC')));
        
        
        $this->set('totalRecords', $totalRecords['kpiType']['kpi_type']);
        
        if($this->request->data){
                $kpiArray['kpi_type'] = $this->request->data['kpiMasters']['kpi_type'];            
                if($kpiArray['kpi_type'] == 1){
                    $kpiArray['kpi_type_value'] = "Manual";
                }else if($kpiArray['kra_type'] == 2){
                    $kpiArray['kpi_type_value'] = "Pre Define";
                }else if($kpiArray['kra_type'] == 3){
                    $kpiArray['kpi_type_value'] = "Both";
                }
                $kpiArray['created_date'] = date("Y-m-d");
                $kpiType = $kpiArray['kpi_type'];
                $kpiTypeValue = $kpiArray['kpi_type_value'];
                $createdDate = $kpiArray['created_date'];                
            
            if(count($totalRecords) == 0){
                $success = $this->kpiType->save($kpiArray);
                $this->Session->setFlash('<div class="alert success">
                            <span class="closebtn" onclick="this.parentElement.style.display=\'none\';">&times;</span>
                                KPI type saved successfully. !!!
                            </div>');
                $this->redirect('addKpiType');
            }else{
                $success = $this->kpiType->updateAll(array('kpi_type' => "'$kpiType'",'updated_date' => "'$createdDate'",'kpi_type_value' => "'$kpiTypeValue'"),array('id' => 1));             
                $this->Session->setFlash('<div class="alert success">
                            <span class="closebtn" onclick="this.parentElement.style.display=\'none\';">&times;</span>
                                KPI type updated successfully. !!!
                            </div>');
                $this->redirect('addKpiType');
            }
        }
    }

}
