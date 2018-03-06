<?php

/* 
  * Property of Eastern Software Systems Pvt. Ltd.
  * Should be modified on by a Cake PHP Professional
  *  ******************************************************************************
  *  Description of Separations_controller.php
  *  ******************************************************************************
  *  file (Leaves_controller.php) version: 0.1.0
  *  file description: Cake PHP Controller file for manupilating Leave data
  *  file change log:
  *            created by Ayush Pant <ayush.pant@essindia.com>
  *            Jan 28, 2017 2:59:31 PM Created controller, and actions add | edit | view | delete.
  *            changed by <user>
  *            <date> <time> <changed-action-name> <change-description> 
  *  
  * ******************************************************************************
  *  project: EssPortal
  *  project version: 0.1.0
  *  @author Ayush Pant <ayush.pant@essindia.com>
  *  @client company: Eastern Software Systems Pvt. Ltd. Expression project.user is undefined on line 21, column 73 in Templates/Licenses/license-default.txt.
  *  @date created: 2017
  *  @date last modified: Jun 28, 2011 2:59:31 PM
  *  ******************************************************************************
 */

App::uses('AppController', 'Controller');

/**
 * Separations Controller
 *
 * @property Separation $Separation
 * @property PaginatorComponent $Paginator
 */
class SeparationsController extends AppController {

    /**
     * Components
     *
     * @var array
     */
    public $uses = array('Separation', 'SeparationWorkflow', 'Project', 'Fnf', 'WfDtAppMapLvl','OptionAttribute','HcmDesgPrf','WfPaginateLvl');
    var $components = array('Session', 'Cookie', 'RequestHandler', 'Auth', 'EmpDetail', 'Paginator','Common');
    var $helpers = array('Html', 'Js', 'Form', 'Session', 'Userdetail', 'Leave', 'Common');

    /**
     * index method
     *
     * @return void
     */
    public function index() {
    
    

        $this->Separation->recursive = -1;
        $this->set('separations', $this->Paginator->paginate(array(
                    'emp_code' => $this->Auth->User('emp_code')
        )));

        //revoke logic
        $emp_code = $this->Auth->User('emp_code');
        $getRevokeStatus = $this->Separation->find('all', array(
            'order' => 'Separation.id DESC',
            'conditions' => array(
                'emp_code' => $emp_code
            ),
            'recursive' => 1
        ));
        $i = 0;

        $emp_det = $this->MyProfile->find('first', array(
            'conditions' => array(
                'emp_code' => $getRevokeStatus[0]['Separation']['emp_code']
            )
        ));
        $maxi = $this->WfDtAppMapLvl->find('first', array(
            'conditions' => array(
                'AND' => array(
                    array('WfDtAppMapLvl.wf_desg_id' => $emp_det['MyProfile']['desg_code']),
                    array('WfDtAppMapLvl.wf_dept_id' => $emp_det['MyProfile']['dept_code']),
                    array('WfDtAppMapLvl.wf_app_map_lvl_id' => 8),
                )
            )
        ));
        //print_r($maxi);
        $max_revoke_level = $maxi['WfDtAppMapLvl']['revoke_level_id'];
        //print_r($max_revoke_level);
        $maxn = $this->WfDtAppMapLvl->find('first', array(
            'conditions' => array(
                'WfDtAppMapLvl.wf_id' => $max_revoke_level,
            )
        ));
        $this->set('max_level_sequence', $maxn['WfDtAppMapLvl']['lvl_sequence']);



        foreach ($getRevokeStatus as $key => $value) {
            if ($value['SeparationWorkflow'][count($value['SeparationWorkflow']) - 1]['status'] != 5) {
                $current_emp_code[$i] = $value['SeparationWorkflow'][count($value['SeparationWorkflow']) - 1]['emp_code'];
            } else {
                $current_emp_code[$i] = null; //ignore this leave as it is approved
            }

            //set leave revoke level

            $levelCount[$i] = count($value['SeparationWorkflow']);
            $i++;
        }
        //get designation id of the employee
        $i = 0;
        foreach ($current_emp_code as $key => $value) {
            if ($value != null) {
                $emp_details[$i] = $this->MyProfile->find('first', array(
                    'conditions' => array(
                        'emp_code' => $value
                    )
                ));
            } else {
                $emp_details[$i] = null;
            }


            $i++;  # code...
        }

        //print_r($emp_details);
        //get the level of Employee
        $i = 0;
        foreach ($emp_details as $key => $value) {
            if ($value != null) {
                $current_levels[$i] = $this->WfDtAppMapLvl->find('first', array(
                    'conditions' => array(
                        'AND' => array(
                            array('WfDtAppMapLvl.wf_desg_id' => $value['MyProfile']['desg_code']),
                            array('WfDtAppMapLvl.wf_dept_id' => $value['MyProfile']['dept_code']),
                            array('WfDtAppMapLvl.wf_app_map_lvl_id' => 8),
                        )
                    )
                ));
            } else {
                $current_levels[$i] = null;
            }

            $i++;
            # code...
        }

        $this->set('separation_level_sequence', $current_levels);

        //Users revoke level limit       
        $this->set('levelCount', $levelCount);
    }

    function beforeFilter() {
        parent::beforeFilter();

        $this->layout = 'employee-new';
        $this->Auth->allow();
        $this->set('appId', 8);
	$currentUser = $this->checkUser();
    }

    /**
     * view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function view($id = null) {
        if (!$this->Separation->exists($id)) {
            throw new NotFoundException(__('Invalid separation'));
        }
        $options = array('conditions' => array('Separation.' . $this->Separation->primaryKey => $id));
        $this->set('separation', $this->Separation->find('first', $options));
    }

    /**
     * add method
     *
     * @return void
     */
    public function add() {
        //Configure::write('debug',2);
        //print_r($this->Auth->User('emp_code'));
        $existing_separation = $this->Separation->find('first', array(
            'conditions' => array(
                'emp_code' => $this->Auth->User('emp_code'),
                'Separation.status !=' => 4
            )
        ));
        if (!empty($existing_separation)) {
            $this->redirect('separation_exists');
        }
        $dept = $this->MyProfile->find('first', array(
            'field' => array('MyProfile.dept_code'),
            'conditions' => array('MyProfile.emp_code' => $this->Auth->User('emp_code'))
        ));
        $desg = $this->MyProfile->find('first', array(
            'field' => array('MyProfile.desg_code'),
            'conditions' => array('MyProfile.emp_code' => $this->Auth->User('emp_code'))
        ));
        $desg_code = $dept['MyProfile']['desg_code'];
        $desg_name = $this->OptionAttribute->find('first', array(
            'fileds' => array('name'),
            'conditions' => array('OptionAttribute.id' => $desg_code)));
        
        $dept_code = $dept['MyProfile']['dept_code'];
        $dept_name = $this->Department->find('first', array(
            'fileds' => array('dept_name'),
            'conditions' => array('dept_code' => $dept_code)));
        $this->set('desg_code', $desg_name['OptionAttribute']['name']);

        $this->set('dept_code', $dept_name['Department']['dept_name']);
        $departments = $this->EmpDetail->getdepartmentlist();
        $this->set('departments', $departments);
        $designations = $this->EmpDetail->getdesignationlist();
        $this->set('designations', $designations);
        $emp_details = $this->EmpDetail->getemployeeinfomation($this->Auth->User('emp_code'));
        $this->set('emp_details', $emp_details);

        if ($this->request->is('post')) {

            //print_r($this->request->data);die;

            $this->Separation->create();
            $this->request->data['Separation']['status'] = 1;
            $this->request->data['Separation']['created'] = date('Y-m-d', strtotime($this->request->data['Separation']['dt_resign_date']));

            if ($this->Separation->save($this->request->data)) {
                $record_id = $this->Separation->getLastInsertID();//die;
                $this->redirect('workflow_display/' . $record_id);
                return $this->flash(__('The separation has been saved.'), array('action' => 'index'));
            } else {
                
            }
        }
    }

    public function revoke($id) {
        //print_r($this->Auth->User('emp_code'));
        $existing_separation = $this->Separation->find('first', array(
            'conditions' => array(
                'Separation.id' => base64_decode($id)
            )
        ));
        $this->set('separation', $existing_separation);
        $departments = $this->EmpDetail->getdepartmentlist();
        $this->set('departments', $departments);
        $designations = $this->EmpDetail->getdesignationlist();
        $this->set('designations', $designations);
        $emp_details = $this->EmpDetail->getemployeeinfomation($this->Auth->User('emp_code'));
        $this->set('emp_details', $emp_details);

        if ($this->request->is('post')) {


            if (isset($this->request->data['update_separation'])) {
                $this->deleteSeparationDetails($this->request->data['Separation']['revoke_separation_id']);
                $this->Separation->create();
                $this->request->data['Separation']['status'] = 1;
                if ($this->Separation->save($this->request->data)) {
                    $record_id = $this->Separation->getLastInsertID();
                    $this->redirect('workflow_display/' . $record_id);
                } else {
                    
                }
            } else {
                $this->deleteSeparationDetails($this->request->data['Separation']['revoke_separation_id']);
                $this->flash(__('The separation has been deleted.'));
                $this->redirect(array('action' => 'index'));
            }
        }
    }

    function deleteSeparationDetails($sep_id) {

        $wf = $this->SeparationWorkflow->find('list', array(
            'conditions' => array(
                'separation_id' => $sep_id
            )
        ));
        foreach ($wf as $key => $value) {
            $this->SeparationWorkflow->delete($value);
        }
        $ml = $this->Separation->find('list', array(
            'conditions' => array(
                'id' => $sep_id
            ),
            'fields' => array('id')
        ));
        foreach ($ml as $key => $value) {
            $this->Separation->delete($value);
        }
    }

    function separation_exists() {
        $this->layout = 'employee-new';
    }

    function workflow_display($record_id = null) {
        $this->layout = 'employee-new';
        $this->set('separation', $record_id);
    }

    function approval() {

        $this->layout = 'employee-new';
        $org_id = $this->Auth->User('comp_code');
        $emp_code = $this->Auth->User('emp_code');
        //Designation code
        $designation_code = $_SESSION['Auth']['MyProfile']['desg_code'];

        //Department code
        $dept_code = $_SESSION['Auth']['MyProfile']['dept_code'];
        /* $pending_separationbak = $this->paginate('SeparationWorkflow',array(
          'AND' => array(
          'SeparationWorkflow.emp_code' => $emp_code,
          //'SeparationWorkflow.fw_date' => null
          ),
          ));
          print_r($pending_separationbak); */
        $others_separations = $this->Separation->find('list', array(
            'conditions' => array(
                'Separation.emp_code !=' => $emp_code,
            ),
            'fields' => 'id',
            'recursive' => 0
        ));
        foreach ($others_separations as $value) {
            $other_flows[$value] = $this->SeparationWorkflow->find('all', array(
                'conditions' => array(
                    'AND' => array(
                        'SeparationWorkflow.separation_id' => $value,
                    ),
                ),
                'recursive' => 0
            ));
        };
        $pending_separation = array();
        foreach ($other_flows as $key => $value) {
            if ($value[sizeof($value) - 1]['SeparationWorkflow']['emp_code'] != $emp_code) {
                unset($other_flows[$key]);
            } else {
                $pending_separation[] = $value[sizeof($value) - 1];
            }
        }

        $this->set('pending_separation', $pending_separation);
    }

    function process_approval($separation_id = null) {
        $this->layout = 'employee-new';

        if ($this->request->is('POST')) {
            $data = $this->request->data;
            $status = $data['SeparationWorkflow']['type'];
            unset($data['SeparationWorkflow']['type']);
            //forwarded

            $separation_id = $data['SeparationWorkflow']['id'];
            unset($data['SeparationWorkflow']['id']);
            $data['SeparationWorkflow']['separation_id'] = $separation_id;



            if ($status == 2) {
                $data1['Separation']['remark'] =  $data['SeparationWorkflow']['forward_remark'];;
                $update_wf['SeparationWorkflow']['remarks'] = $data['SeparationWorkflow']['forward_remark'];
                unset($data['SeparationWorkflow']['forward_remark']);
                unset($data['SeparationWorkflow']['reject_remark']);
            }
            //rejected
            if ($status == 4) {
                $data1['Separation']['remark'] =  $data['SeparationWorkflow']['reject_remark'];    
                $update_wf['SeparationWorkflow']['remarks'] = $data['SeparationWorkflow']['reject_remark'];
                unset($data['SeparationWorkflow']['forward_remark']);
                unset($data['SeparationWorkflow']['reject_remark']);
            }
            //for approved 
            if ($status == 5) {
                $update_wf['SeparationWorkflow']['remarks'] = $data['SeparationWorkflow']['approve_remark'];
                unset($data['SeparationWorkflow']['forward_remark']);
                unset($data['SeparationWorkflow']['reject_remark']);
            }


            //update current wf and create a new wf
            $update_wf['SeparationWorkflow']['fw_date'] = date('Y-m-d h:i:s');
            $update_wf['SeparationWorkflow']['id'] = $data['SeparationWorkflow']['wf_id'];
            unset($data['SeparationWorkflow']['wf_id']);
           
            if ($this->SeparationWorkflow->save($update_wf)) {
                if ($status == 2) {
                    $this->SeparationWorkflow->create();
                    if ($this->SeparationWorkflow->save($data)) {
                         
                        $this->Session->setFlash('Separation forwarded');
                    } else {
                        $this->Session->setFlash('Separation not forwarded');
                    }
                }

                //$this->redirect(array('controller' => 'separations', 'action' => 'view'));
            } else {
                $this->Session->setFlash('Separation workflow not updated');
                //$this->redirect(array('controller' => 'separations', 'action' => 'view'));
            }

            //update separation status
            $data1['Separation']['id'] = $separation_id;
            
            if ($status == 5) {
                 $data1['Separation']['remark'] = $data['SeparationWorkflow']['approve_remark'];
                $data1['Separation']['status'] = 6;
            } else {
                $data1['Separation']['status'] = $status;
            }

           //    print_r($data1);die;
            $this->Separation->save($data1);

            //for approved create a new fnf and submit the details
            if ($status == 5) {
                $fnf_data['Fnf']['separation_id'] = $separation_id;
                $sep_emp_code = $this->Separation->findById($separation_id);
                $fnf_data['Fnf']['emp_code'] = $sep_emp_code['Separation']['emp_code'];
                $fnf_data['Fnf']['status'] = 1;
                $fnf_data['Fnf']['final_approver'] = $this->Auth->User('emp_code');
                //print_r($fnf_data);
                //exit();
                $this->Fnf->create();
                if ($this->Fnf->save($fnf_data)) {
                    $fnf_id = $this->Fnf->getLastInsertID();
                    $this->redirect(array('controller' => 'fnfs', 'action' => 'fnf_details', $fnf_id));
                }
            }

            $this->redirect(array('controller' => 'separations', 'action' => 'approval'));
        } else {

            //print_r($this->Common->getempinfo($this->Auth->User('emp_code')));
            //exit();

            $separation = $this->Separation->find('first', array(
                'conditions' => array(
                    'Separation.id' => $separation_id,
                )
            ));
            //print_r($separation);
            $current_wf_id = $separation['SeparationWorkflow'][sizeof($separation['SeparationWorkflow']) - 1];
            //exit();
            $this->set('current_separation_level',count($separation['SeparationWorkflow']));
            $this->set('separation', $separation);
            $this->set('current_wf_id', $current_wf_id['id']);
        }
    }

    /**
     * edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function edit($id = null) {
        if (!$this->Separation->exists($id)) {
            throw new NotFoundException(__('Invalid separation'));
        }
        if ($this->request->is(array('post', 'put'))) {
            if ($this->Separation->save($this->request->data)) {
                return $this->flash(__('The separation has been saved.'), array('action' => 'index'));
            }
        } else {
            $options = array('conditions' => array('Separation.' . $this->Separation->primaryKey => $id));
            $this->request->data = $this->Separation->find('first', $options);
        }
    }

    /**
     * delete method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function delete($id = null) {
        $this->Separation->id = $id;
        if (!$this->Separation->exists()) {
            throw new NotFoundException(__('Invalid separation'));
        }
        $this->request->allowMethod('post', 'delete');
        if ($this->Separation->delete()) {
            return $this->flash(__('The separation has been deleted.'), array('action' => 'index'));
        } else {
            return $this->flash(__('The separation could not be deleted. Please, try again.'), array('action' => 'index'));
        }
    }

    function saveinfomation() {
        if (!empty($this->request->data)) {
            $remark = $this->Separation->find('first', array(
                'fields' => array('reason'),
                'conditions' => array(
                    'Separation.id' => $this->request->data['SeparationWorkflow']['separation_id']
                )
            ));
            $org_id = $_SESSION['Auth']['MyProfile']['comp_code'];
            $save = array();
            $save['separation_id'] = $this->request->data['SeparationWorkflow']['separation_id'];
            $save['emp_code'] = $this->Auth->User('emp_code');
            $user_details = $this->EmpDetail->getemployeeinfomation($this->Auth->User('emp_code'));
            $save['fw_date'] = date('Y-m-d h:i:s');
            $save['remarks'] = $remark['Separation']['reason'];
            if ($this->SeparationWorkflow->save($save)) {
                unset($save);
                $save1 = array();
                $save1['separation_id'] = $this->request->data['SeparationWorkflow']['separation_id'];
                $save1['emp_code'] = $this->request->data['SeparationWorkflow']['emp_code'];
                $this->SeparationWorkflow->create();
                if ($this->SeparationWorkflow->save($save1)) {
                     $this->Separation->updateAll(
                            array('Separation.status' => 2), array('Separation.id' =>$this->request->data['SeparationWorkflow']['separation_id'])
                    );
                    $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert=""><a href="#" class="uk-alert-close uk-close"></a>Separation forwarded.</div>');
                    $this->redirect(array('controller' => 'separations', 'action' => 'index'));
                } else {
                    $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert=""><a href="#" class="uk-alert-close uk-close"></a>Separation not forwarded.</div>');
                    $this->redirect(array('controller' => 'separations', 'action' => 'index'));
                }
            }
        }
        $this->redirect(array('controller' => 'separations', 'action' => 'index'));
    }

    function add_project_detail() {

        $project_list = $this->Project->find('list');
        $this->set('project_list', $project_list);
        if ($this->request->is('POST')) {
            print_r($this->request->data);
            exit();
        }
    }
    
    
    function approvername($id){
      $author = $this->Project->find('first',array('fileds'=>array('Project.Author'),'conditions'=>array('Project.id'=>$id)));  
      
      $emp_id = $_GET['user_id'];
      $n = $author['Project']['Author'] ;
     
      $comp_code = $_SESSION['Auth']['MyProfile']['comp_code'];
      $emp_dept_id = $_SESSION['Auth']['MyProfile']['dept_code'];
      $emp_desg_id = $_SESSION['Auth']['MyProfile']['desg_code'];
       
        switch ($n) {
            
            case 'Reporting Manager':
          
            $usr_dt = $this->EmpDetail->getemployeeinfomation($_GET['user_id']);
           
            if(!$usr_dt['MyProfile']['manager_code']){
            $desglist = $this->MyProfile->find('list',array('fields'=>array('MyProfile.emp_code','MyProfile.emp_firstname'),'conditions'=>array('comp_code'=>$comp_code,'dept_code'=>'DEPT00009','emp_code !='.$emp_id)));    
            }   
            else {
             $desglist = $this->MyProfile->find('list',array('fields'=>array('MyProfile.emp_code','MyProfile.emp_firstname'),'conditions'=>array('comp_code'=>$comp_code,'emp_code'=>$usr_dt['MyProfile']['manager_code'])));   
            }
           
            $this->set('emplist',$desglist);
            break;
            case 'Accounts Team':
           
             $emplist = $this->MyProfile->find('list',array('fields'=>array('MyProfile.emp_code','MyProfile.emp_firstname'),'conditions'=>array('comp_code'=>$comp_code,'dept_code'=>'DEPT00001','emp_code !='.$emp_id)));
             
             $this->set('emplist',$emplist);
            break;
            case 'HR Team':
            $emplist = $this->MyProfile->find('list',array('fields'=>array('MyProfile.emp_code','MyProfile.emp_firstname'),'conditions'=>array('comp_code'=>$comp_code,'dept_code'=>'DEPT00009','emp_code !='.$emp_id)));
           
             $this->set('emplist',$emplist);
            break;

            default:
            $emplist = $this->MyProfile->find('list',array('fields'=>array('MyProfile.emp_code','MyProfile.emp_firstname'),'conditions'=>array('comp_code'=>$comp_code,'dept_code'=>'DEPT00009','emp_code !='.$emp_id)));
           
             $this->set('emplist',$emplist);
        }
      }

    }


