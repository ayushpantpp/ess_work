<?php

/*
 * Property of Eastern Software Systems Pvt. Ltd.
 * Should be modified on by a Cake PHP Professional
 *  ******************************************************************************
 *  Description of Tasks_controller.php
 *  ******************************************************************************
 *  file (Leaves_controller.php) version: 0.1.0
 *  file description: Cake PHP Controller file for manupilating Leave data
 *  file change log:
 *            created by Ankit Kumar <ankit.kumar@essindia.com>
 *            Jan 28, 2017 2:59:31 PM Created controller, and actions add | edit | view | delete.
 *            changed by <user>
 *            <date> <time> <changed-action-name> <change-description> 
 *  
 * ******************************************************************************
 *  project: EssPortal
 *  project version: 0.1.0
 *  @author Ankit Kumar <ankit.kumar@essindia.com>
 *  @client company: Eastern Software Systems Pvt. Ltd. Expression project.user is undefined on line 21, column 73 in Templates/Licenses/license-default.txt.
 *  @date created: 2017
 *  @date last modified: Jun 28, 2011 2:59:31 PM
 *  ******************************************************************************
 */

App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');

class TasksController extends AppController {

    public $name = 'Tasks';
    public $uses = array('TaskAssign', 'Tasksproject', 'AttendanceDetail', 'EmpAddress', 'MomAssign', 'UserDetail', 'Icon', 'IconUser', 'UserAudittrail', 'MyProfile', 'KraKpiProcess', 'LabelPage', 'LabelBlock', 'Labels', 'Ticker', 'TickerUser', 'Departments', 'Event', 'Separation', 'DtTravelVoucher', 'DtExpVoucher', 'EmpDocuments', 'ImportantDocCategory', 'TaskAssign', 'DependentDetails', 'Tasksprojectmodule', 'Taskassignemp', 'TaskAlert', 'WfMstStatus','WfPaginateLvl');
    public $helpers = array('Js', 'Html', 'Form', 'Session', 'Userdetail', 'Common');
    public $components = array('Auth', 'Session', 'Email', 'Cookie', 'EmpDetail', 'Common', 'RequestHandler','Common');
    var $paginate = array(
        'limit' => 5,
        'order' => array(
            'TaskAssign.tid' => 'asc'
        )
    );
    var $paginate1 = array(
        'limit' => 2,
        'order' => array(
            'Tasksproject.pid' => 'asc'
        )
    );

    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow();
        //$this->isAuthorized();
        $currentUser = $this->checkUser();
    }

    public function index() {
        $lastCreated = $this->TaskAssign->find('first', array('fields' => array('id'),
            'order' => array('TaskAssign.id' => 'desc')
        ));
        $this->set('last_id', $lastCreated);
        $dept = $this->Departments->find('list', array(
            'fields' => array('Departments.dept_code', 'Departments.dept_name'),
            'conditions' => array('Departments.comp_code' => '01')
        ));
        $this->set("department_list", $dept);
        $moms = $this->MomAssign->find('list', array(
            'fields' => array('MomAssign.id', 'MomAssign.subject'))
        );
        $moms= array(''=>'--select--',$moms);
        $this->set("mom_list", $moms);
        $dept = $this->Departments->find('list', array(
            'fields' => array('Departments.dept_code', 'Departments.dept_name'),
            'conditions' => array('Departments.comp_code' => '01')
        ));
        $this->set("department_list", $dept);
        $this->layout = 'employee-new';
        $auth = $this->Session->read('Auth');
        $m = $auth['MyProfile']['emp_code'];

        $mr = $this->MyProfile->find('first', array('fields' => array('desg_code'),
            'conditions' => array('emp_code' => $m)
        ));
        if ($mr['MyProfile']['desg_code'] == 'PAR0000031') {
            $employee_name = $this->MyProfile->find('list', array('fields' => array('emp_code', 'emp_name'),
                'conditions' => array('emp_code !=' => $m)
            ));
        } elseif ($mr['MyProfile']['desg_code'] == 'PAR0000019') {
            $employee_name = $this->MyProfile->find('list', array('fields' => array('emp_code', 'emp_name'),
                'conditions' => array('desg_code !=' => 'PAR0000031')
            ));
        } else {
            $employee_name = $this->MyProfile->find('list', array('fields' => array('emp_code', 'emp_name'),
                'conditions' => array('desg_code !=' => array('PAR0000031', 'PAR0000019'))
            ));
        }
        $ar = $this->Tasksproject->find('list', array('fields' => array('pid', 'pname')));
        $ar1 = $this->Tasksprojectmodule->find('list', array('fields' => array('mid', 'mname')));

        // --------- Task Id Auto insert in Text Box----------------------
        $a = $this->TaskAssign->find('first', array('fields' => array('id'),
            'order' => array('id' => 'DESC')));

        if ($a == Null) {
            $t = 0;
        } else {
            $t = $a['TaskAssign']['id'];
        }
        $t = $t + 1;
        $dt1 = new DateTime();
        $dt = $dt1->format('d-m-y');
        $this->set("employee_name", $employee_name);
        $this->set("ar1", $ar1);
        $this->set("asd", $t);
        $this->set("ar", $ar);
        $this->set("dt", $dt);
    }

    public function taskassign() {
        $this->layout = 'employee-new';
        $auth = $this->Session->read('Auth');
        $elogin = $auth['MyProfile']['emp_firstname'];
        $c11 = $auth['MyProfile']['desg_code'];
        $emp11 = $auth['MyProfile']['emp_code'];
        $s = 0;
        if ($c11 != 'PAR0000031' && $c11 != 'PAR0000019') {
            for ($i = 0; $i < count($this->data['employee_id']); $i++) {
                if ($this->data['employee_id'][$i] != '$emp11') {
                    $s = 1;
                }
            }
        }
        $em_p = 0;
        foreach ($this->data['employee_id'] as $k) {
            $em_p++;
        }
        $tk_val = array();

        $lastCreated = $this->TaskAssign->find('first', array('fields' => array('id'),
            'order' => array('TaskAssign.id' => 'desc')
        ));
        if ($this->request->data['tid'] != '') {
            $getId = $this->TaskAssign->find('first', array('fields' => array('id'),
                'conditions' => array('TaskAssign.tid' => $this->request->data['tid'])
            ));
            $tk_val['id'] = $getId['TaskAssign']['id'];
            $tk_val['tid'] = $this->request->data['tid'];
        } else {
            $tk_val['tid'] = $lastCreated['TaskAssign']['id'] + 1;
        }
        $tk_val['tname'] = $this->request->data['tname'];
        $tk_val['assignto'] = $em_p;
        $tk_val['tpriority'] = $this->request->data['tpriority'];
        $date1 = new DateTime($this->request->data['startdate']);
        $date2 = new DateTime($this->request->data['enddate']);
        $datetime1 = $date1->format('Y-m-d');
        $datetime2 = $date2->format('Y-m-d');
        $tk_val['starttime'] = $datetime1;
        $tk_val['endtime'] = $datetime2;
        $tk_val['pid'] = $this->request->data['pname'];
        $tk_val['mid'] = $this->request->data['mname'];
        $tk_val['remark'] = $this->request->data['remark'];
        $tk_val['department_id'] = $this->request->data['department_id'];
        $tk_val['status'] = 0;
        $tk_val['fstatus'] = 0;
        $tk_val['assignby'] = $elogin;
        $tk_val['desg_code'] = $c11;
        $tk_val['mom_id'] = $this->request->data['mom_id'];
        $tk_val['mom_related'] = $this->request->data['mom_related'];
        $tk_val['assign_by_id'] = $emp11;
        $tk_val['ticket_id'] = $this->request->data['ticket_id'];
        $tk_val['ticket_type'] = $this->request->data['ticket_type'];
        $success = $this->TaskAssign->save($tk_val);

        if ($success) {

            if ($this->request->data['tid'] != '') {
                $emp2 = $this->Taskassignemp->find('list', array(
                    'conditions' => array('Taskassignemp.tid' => $this->request->data['tid']),
                    'joins' => array(
                        array(
                            'table' => 'myprofile',
                            'alias' => 'Name',
                            'type' => 'LEFT',
                            'conditions' => array(
                                'Name.emp_code = Taskassignemp.emp_code'
                            )),
                    ),
                    'fields' => array(
                        'Name.emp_code'
                    )
                ));
                foreach ($emp2 as $k) {
                    $emp[] = $k;
                }
                //  print_r($emp); die;
                $task = array();
                $new = 0;

                foreach ($this->data['employee_id'] as $k) {
                    if (!in_array($k, $emp)) {
                        $task['tid'] = $this->request->data['tid'];
                        $task['emp_code'] = $k;
                        $task['cstatus'] = 0;
                        $new++;
                        $this->Taskassignemp->create();
                        $success1 = $this->Taskassignemp->save($task);
                        $To[] = $this->Common->getEmpEmailId($k);
                    }
                }
                $From = $this->Common->getSuportEmailId('01');
                $id = $this->request->data['tid'];
                $data['logo'] = 'logo_email.png';
                $this->send_mail($From, $To, $CC, 'Task Assigned No -' . $id, 'Your Have been assigned with Task No -' . $id . ' Successfully', 'default', $data);
                $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                <a href="#" class="uk-alert-close uk-close"></a>Task Forwarded Succesfully. !!!</div>');
                $this->redirect('mtaskdashboard');
            } else {
                $task = array();
                $new = 0;
                foreach ($this->data['employee_id'] as $k) {
                    $task['tid'] = $this->request->data['tid'];
                    $task['emp_code'] = $this->data['employee_id'][$new];
                    $task['cstatus'] = 0;
                    $new++;
                    $this->Taskassignemp->create();
                    $success1 = $this->Taskassignemp->save($task);
                }

                if ($success1) {
                    unset($tk_val);
                    if ($s == 1) {
                        $task1 = array();
                        $task1['tid'] = $this->request->data['tid'];
                        $task1['emp_code'] = $emp11;
                        $this->Taskassignemp->create();
                        $success5 = $this->Taskassignemp->save($task1);
                    }
                    $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                <a href="#" class="uk-alert-close uk-close"></a>Task details saved succesfully. !!!</div>');
                }
            }
        } else {
            $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                <a href="#" class="uk-alert-close uk-close"></a>Some error Occured . !!!</div>');
        }
        if ($auth['MyProfile']['desg_code'] == 'PAR0000031') {
            $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                <a href="#" class="uk-alert-close uk-close"></a>Task details saved succesfully. !!!</div>');
            $this->redirect('emptask');
        } else if ($auth['MyProfile']['desg_code'] == 'PAR0000019') {
            $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                <a href="#" class="uk-alert-close uk-close"></a>Task details saved succesfully. !!!</div>');
            $this->redirect('mtaskdashboard');
        } else {
            $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                <a href="#" class="uk-alert-close uk-close"></a>Task details saved succesfully. !!!</div>');
            $this->redirect('mtaskdashboard');
        }
    }

    public function srtask() {
        $this->layout = 'employee-new';
        $ar = $this->Tasksproject->find('list', array('fields' => array('pid', 'pname')));
        $ar1 = $this->Tasksprojectmodule->find('list', array('fields' => array('mid', 'mname')));
        $employee_name = $this->MyProfile->find('list', array('fields' => array('emp_code', 'emp_name')));
        // --------- Task Id Auto insert in Text Box----------------------
        $a = $this->TaskFassign->find('first', array('fields' => array('id'),
            'order' => array('id' => 'DESC')));

        // print_r($a); die;
        if ($a == Null) {
            $t = 0;
        } else {
            $t = $a['TaskFassign']['id'];
        }
        $t = $t + 1;
        $this->set("employee_name", $employee_name);
        $this->set("ar1", $ar1);
        $this->set("asd", $t);
        $this->set("ar", $ar);
    }

    public function taskupdate() {
        // die('jhgejhgejh');
        $this->autoRender = false;

        $auth = $this->Session->read('Auth');
        $tid = $this->request->data['tid'];
        $success1 = $this->Taskassignemp->deleteAll(array('tid' => $tid));
        $em_p = 0;
        //print_r($this->request->data); die;
        foreach ($this->data['ticker'] as $k) {
            $em_p++;
        }
        $tid = $this->request->data['tid'];
        $tk_val = array();
        $tn = $tk_val['tname'] = $this->request->data['tname'];
        $st = $tk_val['assignto'] = $em_p;
        $tp = $tk_val['tpriority'] = $this->request->data['task']['tpriority'];
        $date1 = DateTime::createFromFormat('d-m-y', $this->request->data['startdate']);
        $date2 = DateTime::createFromFormat('d-m-y', $this->request->data['enddate']);
        $datetime1 = $date1->format('Y-m-d');
        $datetime2 = $date2->format('Y-m-d');
        $tk_val['starttime'] = $datetime1;
        $tk_val['endtime'] = $datetime2;
        $pn = $tk_val['pid'] = $this->request->data['task']['pname'];
        $mn = $tk_val['mid'] = $this->request->data['task']['mname'];
        $re = $tk_val['remark'] = $this->request->data['task']['remark'];
        $s = $tk_val['status'] = 0;
        $s1 = $tk_val['fstatus'] = 0;
        $success = $this->TaskAssign->updateAll(array('tname' => "'$tn'", 'assignto' => "'$st'", 'tpriority' => "'$tp'",
            'starttime' => "'$datetime1'", 'endtime' => "'$datetime2'", 'pid' => "'$pn'", 'mid' => "'$mn'", 'remark' => "'$re'",
            'status' => "'$s'", 'fstatus' => "'$s1'"), array('tid' => $tid));
        if ($success) {
            $task = array();
            $new = 0;
            foreach ($this->data['ticker'] as $k) {

                $task['tid'] = $this->request->data['tid'];
                $task['emp_code'] = $this->data['ticker'][$new];
                $task['cstatus'] = 0;
                $new++;
                $this->Taskassignemp->create();
                $success1 = $this->Taskassignemp->save($task);
            }
            if ($success1) {
                $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                <a href="#" class="uk-alert-close uk-close"></a>Saved Succesfully.</div>');
                unset($tk_val);
            }
        } else {
            $this->Session->setFlash('Oops !! Some error Occured.');
        }

        if ($auth['MyProfile']['desg_code'] == 'PAR0000031') {
            $this->redirect('taskdashboard');
        }
        if ($auth['MyProfile']['desg_code'] == 'PAR0000019') {
            $this->redirect('mtaskdashboard');
        } else {
            $this->redirect('emptask');
        }
    }

    public function cancel() {
        $this->layout = 'employee-new';
        $auth = $this->Session->read('Auth');
        //echo "hiiiii"; die;
        if ($auth['MyProfile']['desg_code'] == 'PAR0000031') {
            $this->redirect('taskdashboard');
        }
        if ($auth['MyProfile']['desg_code'] == 'PAR0000019') {
            $this->redirect('mtaskdashboard');
        } else {
            $this->redirect('emptask');
        }
    }

    public function forwardto() {

        $auth = $this->Session->read('Auth');
        $dcode = $auth['MyProfile']['emp_firstname'];

        if ($this->request->data['h2'] == "") {
            $msd = 0;
        } else {
            $msd = $this->request->data['h2'];
        }
        $this->layout = 'employee-new';
        $auth = $this->Session->read('Auth');
        $tid = $this->request->data['task']['tid'];
        $success1 = $this->Taskassignemp->deleteAll(array('tid' => $tid));
        $em_p = 0;
        foreach ($this->data['ticker'] as $k) {
            $em_p++;
        }
        $tid = $this->request->data['task']['tid'];
        $tk_val = array();
        $tn = $tk_val['tname'] = $this->request->data['task']['tname'];
        $st = $tk_val['assignto'] = $em_p;
        $tp = $tk_val['tpriority'] = $this->request->data['task']['tpriority'];
        $date1 = DateTime::createFromFormat('d-m-y', $this->request->data['task']['dt_start_date']);
        $date2 = DateTime::createFromFormat('d-m-y', $this->request->data['task']['dt_end_date']);
        $datetime1 = $date1->format('Y-m-d');
        $datetime2 = $date2->format('Y-m-d');
        $tk_val['starttime'] = $datetime1;
        $tk_val['endtime'] = $datetime2;
        $pn = $tk_val['pid'] = $this->request->data['h1']; //$this->request->data['task']['pname'];
        $mn = $tk_val['mid'] = $msd; //$this->request->data['task']['mname'];
        $re = $tk_val['remark'] = $this->request->data['task']['remark'];
        $s = $tk_val['status'] = 0;
        $s1 = $tk_val['fstatus'] = 0;
        $dc1 = $tk_val['forwardby'] = $dcode;
        $success = $this->TaskAssign->updateAll(array('tname' => "'$tn'", 'assignto' => "'$st'", 'tpriority' => "'$tp'",
            'starttime' => "'$datetime1'", 'endtime' => "'$datetime2'", 'pid' => "'$pn'", 'mid' => "'$mn'", 'remark' => "'$re'",
            'status' => "'$s'", 'fstatus' => "'$s1'", 'forwardby' => "'$dc1'"), array('tid' => $tid));
        if ($success) {
            $task = array();
            $new = 0;
            foreach ($this->data['ticker'] as $k) {
                $task['tid'] = $this->request->data['task']['tid'];
                $task['emp_code'] = $this->data['ticker'][$new];
                $task['cstatus'] = 0;
                $new++;
                $this->Taskassignemp->create();
                $success1 = $this->Taskassignemp->save($task);
            }
            if ($success1) {
                $this->Session->setFlash('Saved Succesfully.');

                unset($tk_val);
            }
        } else {
            $this->Session->setFlash('Oops !! Some error Occured.');
        }

        if ($auth['MyProfile']['desg_code'] == 'PAR0000031') {
            $this->redirect('taskdashboard');
        }
        if ($auth['MyProfile']['desg_code'] == 'PAR0000019') {
            $this->redirect('mtaskdashboard');
        } else {
            $this->redirect('emptask');
        }
    }

    public function forwardemp() {
        $auth = $this->Session->read('Auth');
        $dcode = $auth['MyProfile']['emp_firstname'];
        if ($this->request->data['h2'] == "") {
            $msd = 0;
        } else {
            $msd = $this->request->data['h2'];
        }
        $this->layout = 'employee-new';
        $auth = $this->Session->read('Auth');
        $m = $auth['MyProfile']['emp_code'];
        $tid = $this->request->data['task']['tid'];
        $tr = $this->data['ticker'];
        $ar = $this->Taskassignemp->find('first', array('feilds' => array('id'),
            'conditions' => array('tid' => $tid, 'AND' => array('emp_code' => $m))
        ));
        $t = count($this->data['ticker']);
        $success = $this->TaskAssign->find('first', array('feilds' => array('tid', 'assignto'),
            'conditions' => array('tid' => $tid)
        ));
        $a = $success['TaskAssign']['assignto'];
        $p = $t + $a - 1;
        $tk_val = array();
        $tn = $tk_val['tname'] = $this->request->data['task']['tname'];
        $st = $tk_val['assignto'] = $em_p;
        $tp = $tk_val['tpriority'] = $this->request->data['task']['tpriority'];
        $date1 = DateTime::createFromFormat('d-m-y', $this->request->data['task']['dt_start_date']);
        $date2 = DateTime::createFromFormat('d-m-y', $this->request->data['task']['dt_end_date']);
        $datetime1 = $date1->format('Y-m-d');
        $datetime2 = $date2->format('Y-m-d');
        $tk_val['starttime'] = $datetime1;
        $tk_val['endtime'] = $datetime2;
        $pn = $tk_val['pid'] = $this->request->data['h1']; //$this->request->data['task']['pname'];
        $mn = $tk_val['mid'] = $msd; //$this->request->data['task']['mname'];
        $re = $tk_val['remark'] = $this->request->data['task']['remark'];
        $s = $tk_val['status'] = 0;
        $s1 = $tk_val['fstatus'] = 0;
        $dc1 = $tk_val['forwardby'] = $dcode;
        $c1 = $this->TaskAssign->updateAll(array('tname' => "'$tn'", 'assignto' => "'$p'", 'tpriority' => "'$tp'",
            'starttime' => "'$datetime1'", 'endtime' => "'$datetime2'", 'pid' => "'$pn'", 'mid' => "'$mn'", 'remark' => "'$re'",
            'status' => "'$s'", 'fstatus' => "'$s1'", 'forwardby' => "'$dc1'"), array('tid' => $tid));
        if ($c1) {
            $task = array();
            $new = 0;
            foreach ($this->data['ticker'] as $k) {
                $task['tid'] = $this->request->data['task']['tid'];
                $task['emp_code'] = $this->data['ticker'][$new];
                $task['cstatus'] = 0;
                $new++;
                $this->Taskassignemp->create();
                $success2 = $this->Taskassignemp->save($task);
            }
            if ($success2) {
                $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                <a href="#" class="uk-alert-close uk-close"></a>Saved Succesfully.</div>');
                unset($task);
            }
        } else {
            $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                <a href="#" class="uk-alert-close uk-close"></a>Oops !! Some error Occured.</div>');
        }
        $this->redirect('emptask');
    }

    public function taskdelete($tid) {
        $auth = $this->Session->read('Auth');
        $success1 = $this->TaskAssign->deleteAll(array('tid' => $tid));
        $success2 = $this->Taskassignemp->deleteAll(array('tid' => $tid));
        $success3 = $this->TaskAlert->deleteAll(array('tid' => $tid));
        if ($auth['MyProfile']['desg_code'] == 'PAR0000031') {
            $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                <a href="#" class="uk-alert-close uk-close"></a>Task Deleted Succesfully</div>');

            $this->redirect('taskdashboard');
        }
        if ($auth['MyProfile']['desg_code'] == 'PAR0000019') {
            $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                <a href="#" class="uk-alert-close uk-close"></a>Task Deleted Succesfully</div>');

            $this->redirect('mtaskdashboard');
        } else {
            $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                <a href="#" class="uk-alert-close uk-close"></a>Task Deleted Succesfully</div>');

            $this->redirect('mtaskdashboard');
        }
    }

    public function projectdelete($pid) {
        $auth = $this->Session->read('Auth');
        $success1 = $this->TaskAssign->deleteAll(array('pid' => $pid));
        $success2 = $this->Tasksproject->deleteAll(array('pid' => $pid));
        $success3 = $this->Tasksprojectmodule->deleteAll(array('pid' => $pid));
        if ($auth['MyProfile']['desg_code'] == 'PAR0000031') {
            $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                <a href="#" class="uk-alert-close uk-close"></a>Project Deleted Succesfully</div>');

            $this->redirect('taskproject');
        }
        if ($auth['MyProfile']['desg_code'] == 'PAR0000019') {
            $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                <a href="#" class="uk-alert-close uk-close"></a>Project Deleted Succesfully</div>');

            $this->redirect('taskproject');
        } else {
            $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                <a href="#" class="uk-alert-close uk-close"></a>Project Deleted Succesfully</div>');

            $this->redirect('taskproject');
        }
    }

    public function taskdashboard() {
        $this->layout = 'employee-new';
        $pcount = $this->Tasksprojectmodule->find('all', array('field' => array('count(*) as noofmod', 'pid'), 'group' => array('pid HAVING COUNT(*) >= 1')));
        $completedTask = $this->TaskAssign->find('count', array('conditions' => array('fstatus in (6,7)')));
        $this->set('completedTask', $completedTask);
        $pendingTask = $this->TaskAssign->find('count', array('conditions' => array('fstatus in (1,2,3,4,5)')));
        $this->set('pendingTask', $pendingTask);
        $notstartedTask = $this->TaskAssign->find('count', array('conditions' => array('fstatus in (0)')));
        $this->set('notstartedTask', $notstartedTask);

        $this->paginate = array(
            'fields' => array('*'),
            'limit' => 10,
            'order' => 'TaskAssign.tid ASC',
            'joins' => array(
                array(
                    'table' => 'task_project',
                    'alias' => 'Project',
                    'type' => 'LEFT',
                    'foreignKey' => false,
                    'conditions' => array('Project.pid = TaskAssign.pid'
                    )),
                array(
                    'table' => 'task_alert',
                    'alias' => 'Alert',
                    'type' => 'LEFT',
                    'foreignKey' => false,
                    'conditions' => array('Alert.tid = TaskAssign.tid'
                    )),
            ),
            'fields' => array('TaskAssign.*', 'Project.*', 'Alert.emp_reply', 'Alert.statusid')
        );
        $data = $this->paginate('TaskAssign');
        $this->set('tabledata', $data);
        foreach ($data as $d) {
            $datanew[] = $d['TaskAssign'];
        }
        $jsondata = json_encode($datanew, JSON_NUMERIC_CHECK);
        $this->set('jdata', $jsondata);
    }

    public function mtaskdashboard() {
        $this->layout = 'employee-new';
        $emp_code22 = $this->Auth->User('emp_code');
        $pcount = $this->Tasksprojectmodule->find('all', array('field' => array('count(*) as noofmod', 'pid'), 'group' => array('pid HAVING COUNT(*) >= 1')));
        $completedTask = $this->TaskAssign->find('count', array('conditions' => array('status in (6,7)')));
        $this->set('completedTask', $completedTask);
        $completedTask1 = $this->TaskAssign->find('count', array('conditions' => array('fstatus in (6,7)')));
        $this->set('completedTask1', $completedTask1);
        $pendingTask = $this->TaskAssign->find('count', array('conditions' => array('status in (1,2,3,4,5)')));
        $this->set('pendingTask', $pendingTask);
        $pendingTask1 = $this->TaskAssign->find('count', array('conditions' => array('fstatus in (1,2,3,4,5)')));
        $this->set('pendingTask1', $pendingTask1);
        $notstartedTask = $this->TaskAssign->find('count', array('conditions' => array('status in (0)')));
        $this->set('notstartedTask', $notstartedTask);
        $notstartedTask1 = $this->TaskAssign->find('count', array('conditions' => array('fstatus in (0)')));
        $this->set('notstartedTask1', $notstartedTask1);
        $this->paginate = array(
            'fields' => array('*'),
            'limit' => 8,
            'order' => 'TaskAssign.tid ASC',
            'joins' => array(
                array(
                    'table' => 'task_project',
                    'alias' => 'Project',
                    'type' => 'LEFT',
                    'foreignKey' => false,
                    'conditions' => array('Project.pid = TaskAssign.pid'
                    )),
                array(
                    'table' => 'task_alert',
                    'alias' => 'Alert',
                    'type' => 'LEFT',
                    'foreignKey' => false,
                    'conditions' => array('Alert.tid = TaskAssign.tid'
                    )),
            ),
            'fields' => array('TaskAssign.*', 'Project.*', 'Alert.emp_reply', 'Alert.statusid', 'Alert.desg_code')
        );
        $data = $this->paginate('TaskAssign');
        $this->set('tabledata', $data);
        foreach ($data as $d) {
            $datanew[] = $d['TaskAssign'];
        }
        $jsondata = json_encode($datanew, JSON_NUMERIC_CHECK);
        $this->set('jdata', $jsondata);
    }

    public function empTask($val) {
        $emp_code = $this->Auth->User('emp_code');

        $this->layout = 'employee-new';
        if(!empty($val))
        {
 $dt=$val;
 $this->set('pen_val',$dt);
}
else
{
     $dt=$this->Common->findpaginateLevel('16');
}


  
        $this->paginate = array(
            'fields' => array('*'),
            'limit' => $dt,
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

        $count = $this->TaskAssign->find('count', array(
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
            ), 'conditions' => array('Assigned.emp_code' => $emp_code, 'TaskAssign.status in (6,7)')
        ));
        $count1 = $this->TaskAssign->find('count', array(
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
            ), 'conditions' => array('Assigned.emp_code' => $emp_code, 'TaskAssign.status in (1,2,3,4,5)')
        ));
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

        $ar = $this->Tasksproject->find('all', array('fields' => array('pid', 'pname')));
        $ar1 = $this->Tasksprojectmodule->find('all', array('fields' => array('mid', 'mname')));
        $this->set('ar', $ar);
        $this->set('ar1', $ar1);

        $data = $this->paginate('TaskAssign');

        //print_r($data); die;
        $this->set('count', $count);
        $this->set('count1', $count1);
        $this->set('count2', $count2);
        $this->set('assignedTask', $data);
    }

    public function alert($tid) {
        $auth = $this->Session->read('Auth');
        $elogin = $auth['MyProfile']['emp_firstname'];
        $emp33 = $auth['MyProfile']['emp_code'];
        $comp_code = $auth['User']['comp_code'];
        $ar2 = $this->TaskAlert->find('all', array('conditions' => array('tid' => $tid)
        ));
        $this->set('comp_code', $comp_code);
        $this->set("ar2", $ar2);
        $this->set("tid", $tid);
        if (isset($this->request->data['task']['cm'])) {
            $emp_reply = $this->request->data['task']['cm'];
            $tid = $this->request->data['task']['tid'];
            $rr = $this->TaskAlert->find('first', array('feilds' => array('tid', 'emp_reply'),
                'conditions' => array('tid' => $tid)
            ));
            $st = $rr['TaskAlert']['emp_reply'];
            $cm1 = $emp_reply;
            $output = sprintf('%s  %s', $st, $cm1);
            $tk_val = array();
            $statusid = 3;
            $success = $this->TaskAlert->updateAll(array('statusid' => $statusid, 'emp_reply' => "'$output'"), array('tid' => $tid));
            $success11 = $this->Taskassignemp->updateAll(array('statusid' => $statusid), array('tid' => $tid, 'AND' => array('emp_code' => $emp33)));
            $list_mail = $this->taskassignemp->find('all',array('fields'=>array('emp_code'),'conditions'=>array('tid'=>$tid)));
            $From = $this->Common->getSuportEmailId('01');
            $id = $this->request->data['tid'];
            $data['logo'] = 'logo_email.png';
            $To = 'ayush.pant@essindia.com';
            $this->send_mail($From, $To, $CC, 'Alert Added to Task No -' . $id, 'An alert Message is generated for Task No -' . $id . ' Please check', 'default', $data);
            if ($auth['MyProfile']['desg_code'] == 'PAR0000019') {
                $this->redirect('mtaskdashboard');
            } else {
                $this->redirect('emptask');
            }
        }
    }

    public function alertcomment($tid) {
        if (!empty($this->request->data)) {
            $this->autoRender = false;
        }
        $auth = $this->Session->read('Auth');
        $elogin = $auth['MyProfile']['emp_firstname'];
        $dscode = $auth['MyProfile']['desg_code'];
        $emp_code = $auth['MyProfile']['emp_code'];
        $employee_name = $this->Taskassignemp->find('list', array(
            'conditions' => array('Taskassignemp.tid' => $tid),
            'joins' => array(
                array(
                    'table' => 'myprofile',
                    'alias' => 'Name',
                    'type' => 'LEFT',
                    'conditions' => array(
                        'Name.emp_code = Taskassignemp.emp_code'
                    )),
            ),
            'fields' => array('Name.emp_firstname')
        ));
        $this->set("tid", $tid);
        $this->set("employee_name", $employee_name);
        if (isset($this->request->data['task']['addcomment'])) {
            $tid = $this->request->data['task']['tid'];
            $cm = $this->request->data['task']['addcomment'];
            $ar = $this->Taskassignemp->find('all', array('fields' => array('emp_code'),
                'conditions' => array('tid' => $tid),
                'joins' => array(
                    array(
                        'table' => 'myprofile',
                        'alias' => 'Name',
                        'type' => 'LEFT',
                        'conditions' => array(
                            'Name.emp_code = Taskassignemp.emp_code'
                        )),
                ),
                'fields' => array(
                    'Name.emp_code', 'Name.emp_firstname'
                )
            ));
            $tk_val = array();
            $tk_val['tid'] = $tid;
            $tk_val['statusid'] = 8;
            $tk_val['desg_code'] = $dscode;
            $tk_val['emp_code'] = $emp_code;
            if ($this->request->data['task']['addcomment'] == NULL) {
                $pp = "Please give current status of task";
            } else {
                $pp = $this->request->data['task']['addcomment'];
            }
            $tk_val['comment'] = $pp; //$this->request->data['task']['addcomment'];
            $ar = $this->TaskAlert->find('first', array('fields' => array('tid'),
                'conditions' => array('tid' => $tid)
            ));
            if ($ar == NULL) {
                $success = $this->TaskAlert->save($tk_val);
                $success22 = $this->Taskassignemp->updateAll(array('statusid' => $tk_val['statusid']), array('tid' => $tid));
                if ($auth['MyProfile']['desg_code'] == 'PAR0000031') {
                    $this->redirect('taskdashboard');
                }
                if ($auth['MyProfile']['desg_code'] == 'PAR0000019') {
                    $this->redirect('mtaskdashboard');
                }
                $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                <a href="#" class="uk-alert-close uk-close"></a>Alert Sent Successfully. !!!</div>');
                $this->redirect('mtaskdashboard');
            } else {
                $success1 = $this->TaskAlert->updateAll(array('statusid' => $tk_val['statusid'], 'comment' => "'$pp'", 'desg_code' => "'$dscode'"), array('tid' => $tid));
                $success22 = $this->Taskassignemp->updateAll(array('statusid' => $tk_val['statusid']), array('tid' => $tid));
                if ($auth['MyProfile']['desg_code'] == 'PAR0000031') {
                    $this->redirect('taskdashboard');
                }
                if ($auth['MyProfile']['desg_code'] == 'PAR0000019') {
                    $this->redirect('mtaskdashboard');
                }
                $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                <a href="#" class="uk-alert-close uk-close"></a>Alert Already Sent. !!!</div>');
                $this->redirect('mtaskdashboard');
            }
        }
    }

    public function chartdata() {
        $projects = $this->TaskAssign->find('all', array(
            'conditions' => array(),
            'joins' => array(
                array(
                    'table' => 'task_project',
                    'alias' => 'Project',
                    'type' => 'LEFT',
                    'conditions' => array(
                        'Project.pid = TaskAssign.pid'
                    )),
            ),
            'fields' => array(
                'pname as name',
                'assignto as y')
        ));

        $data = array();
        foreach ($projects as $n) {
            $data[]['TaskAssign'] = array('name' => $n['Project']['name'],
                'y' => $n['TaskAssign']['y']);
        }
        foreach ($data as $d) {
            $datanew[] = $d['TaskAssign'];
        }
        echo $jsondata = json_encode($datanew, JSON_NUMERIC_CHECK);
        die;
    }

    public function tooltip($id) {
        $new = $this->Taskassignemp->find('all', array(
            'conditions' => array('Taskassignemp.tid' => $id),
            'joins' => array(
                array(
                    'table' => 'myprofile',
                    'alias' => 'Name',
                    'type' => 'LEFT',
                    'conditions' => array(
                        'Name.emp_code = Taskassignemp.emp_code'
                    )),
            ),
            'fields' => array(
                'Name.emp_full_name'
            )
        ));
        $name = '';
        foreach ($new as $n) {
            $name .= ' ' . $n['Name']['emp_full_name'] . ',';
        }
        echo $name;
        die;
    }

    public function view($tid) {
        $sr = $this->TaskAssign->find('all', array('fields' => array('pid', 'mid'),
            'conditions' => array('TaskAssign.tid' => $tid),
            'joins' => array(
                array(
                    'table' => 'task_project',
                    'alias' => 'TP',
                    'type' => 'LEFT',
                    'conditions' => array(
                        'TP.pid = TaskAssign.pid'
                    )),
                array(
                    'table' => 'task_project_module',
                    'alias' => 'TM',
                    'type' => 'LEFT',
                    'conditions' => array(
                        'TM.mid = TaskAssign.mid'
                    )),
            ),
            'fields' => array('TP.pname', 'TM.mname')
        ));
        $this->set("sr", $sr);
    }

    public function view1($id) {
        $sr = $this->Tasksprojectmodule->find('all', array('fields' => array('mid', 'pid', 'mname', 'status'),
            'conditions' => array('pid' => $id)
        ));
        $sr1 = $this->Tasksproject->find('first', array('fields' => array('pid', 'pname'),
            'conditions' => array('pid' => $id)
        ));
        $this->set("sr", $sr);
        $this->set("sr1", $sr1);
    }

    public function editfunction($id) {
        $sr = $this->Tasksprojectmodule->find('first', array('fields' => array('mid', 'pid', 'mname'),
            'conditions' => array('mid' => $id)
        ));
        $this->set("sr", $sr);
    }

    public function view2($id) {
        $p = $this->TaskAssign->find('first', array('fields' => array('pid', 'mid', 'tname', 'assignby'),
            'joins' => array(
                array(
                    'table' => 'task_project',
                    'alias' => 'TP',
                    'type' => 'LEFT',
                    'conditions' => array(
                        'TP.pid = TaskAssign.pid'
                    )),
                array(
                    'table' => 'task_project_module',
                    'alias' => 'TM',
                    'type' => 'LEFT',
                    'conditions' => array(
                        'TM.mid = TaskAssign.mid'
                    )),
            ),
            'fields' => array('TP.*', 'TM.*', 'TaskAssign.*'),
            'conditions' => array('TaskAssign.tid' => $id)
        ));
        $emp = $this->Taskassignemp->find('all', array(
            'conditions' => array('Taskassignemp.tid' => $id),
            'joins' => array(
                array(
                    'table' => 'myprofile',
                    'alias' => 'Name',
                    'type' => 'LEFT',
                    'conditions' => array(
                        'Name.emp_code = Taskassignemp.emp_code'
                    )),
            ),
            'fields' => array('Name.emp_firstname', 'Taskassignemp.cstatus')
        ));
        $assignby = $this->TaskAssign->find('first', array('fields' => array('assignby'),
            'conditions' => array('tid' => $id)
        ));
        $forwardby = $this->TaskAssign->find('first', array('fields' => array('forwardby'),
            'conditions' => array('tid' => $id)
        ));
        $rem = $this->TaskAssign->find('first', array('fields' => array('remark'),
            'conditions' => array('tid' => $id)
        ));
        $new[] = $p;
        $this->set("sr", $new);
        $this->set("emp", $emp);
        $this->set("assignby", $assignby);
        $this->set("forwardby", $forwardby);
        $this->set("rem", $rem);
        $this->set("p", $p);
    }

    public function remark($id) {
        $sr = $this->TaskAssign->find('first', array('fields' => array('remark'),
            'conditions' => array('TaskAssign.tid' => $id)
        ));
        if ($sr != NULL) {
            echo '<h4>--&nbsp;&nbsp;&nbsp;' . $sr['TaskAssign']['remark'];
            die;
        } else {
            echo '<h4>-------No Remark Found-------';
            die;
        }
    }

    public function updatestatus($status, $id, $ecode) {
        $dt = new DateTime();
        $p = $dt->format('Y-m-d');
        if ($status == 6) {
            $success11 = $this->Taskassignemp->updateAll(
                    array('cstatus' => "'$status'"), array('tid' => $id, 'AND' => array('emp_code' => $ecode))
            );
            $success = $this->TaskAssign->updateAll(
                    array('status' => "'$status'", 'sdate' => "'$p'"), array('tid' => $id)
            );
        } else {
            $tstatus = $this->TaskAssign->find('first', array('fields' => array('tid', 'status'),
                'conditions' => array('tid' => $id)
            ));
            if ($status == 0) {
                $nm1 = 0;
            }
            if ($status == 1 && $status < 2) {
                $nm1 = 1;
            }
            if ($status == 2 && $status < 3) {
                $nm1 = 2;
            }
            if ($status == 3 && $status < 4) {
                $nm1 = 3;
            }
            if ($status == 4 && $status < 5) {
                $nm1 = 4;
            }
            if ($status == 5) {
                $nm1 = 5;
            }

            $success1 = $this->TaskAssign->updateAll(
                    array('status' => "'$nm1'"), array('tid' => $id)
            );


            $success = $this->Taskassignemp->updateAll(
                    array('cstatus' => "'$status'"), array('tid' => $id, 'AND' => array('emp_code' => $ecode))
            );
        }
        if ($success) {
            echo 'done';
            die;
        } else {
            echo 'notdone';
            die;
        }
    }

    public function updatestatus1($fstatus, $id) {
        $dt = new DateTime();
        $p = $dt->format('Y-m-d');
        if ($fstatus == 6) {
            $success = $this->TaskAssign->updateAll(
                    array('fstatus' => "'$fstatus'", 'fsdate' => "'$p'"), array('tid' => $id)
            );
        } else {
            $success = $this->TaskAssign->updateAll(
                    array('fstatus' => "'$fstatus'"), array('tid' => $id)
            );
        }

        if ($success) {
            echo 'done';
            die;
        } else {
            echo 'notdone';
            die;
        }
    }

    public function updatestatusmodule($status, $id) {
        $success = $this->Tasksprojectmodule->updateAll(
                array('status' => "'$status'"), array('mid' => $id)
        );
        if ($success) {
            echo 'done';
            die;
        } else {
            echo 'notdone';
            die;
        }
    }

    public function projectdetail() {
        $this->layout = 'employee-new';
        $ar = $this->Tasksproject->find('all', array('fields' => array('pid', 'pname')));
        $ar1 = $this->Tasksprojectmodule->find('all', array('fields' => array('mid', 'pid')));
        $ar2 = $this->Tasksprojectmodule->find('all', array(
            'fields' => array('pid', 'count(*) as NO_Module'),
            'group' => array('pid HAVING COUNT(*) >= 1')));
        $module = array();
        foreach ($ar2 as $k) {
            $module[] = $k[0]['NO_Module'];
        }
        //------------------ End Table Code ---------------------------------------  
        $this->set("module", $module);
        $this->set("ar1", $ar1);
        $this->set("ar", $ar);
    }

    public function taskproject() {
        //Configure::write('debug',2);
        $ar = $this->Tasksproject->find('list', array('fields' => array('pid', 'pname')));
        $this->set("sr", $ar);
        $this->layout = 'employee-new';
        $pid = $this->request->data['task']['pnameold'];
        if ($this->data['proj'] == 'existing') {
            $pid = $this->request->data['task']['pnameold'];
            $pid1 = $this->request->data['mname'];
            $mname = $this->request->data['mname'];
            $mr = $this->Tasksproject->find('all', array('fields' => array('pname'),
                'conditions' => array('pid' => $pid)
            ));
            $tk_val = array();
            $tk_val['pid'] = $pid;
            $tk_val['mname'] = $mname;
            $tk_val['status'] = 0;
            $success = $this->Tasksprojectmodule->save($tk_val);
            if ($success) {
                $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                <a href="#" class="uk-alert-close uk-close"></a>New Project Saved SuccessFully</div>');
                $this->redirect('taskproject');
            }
        } else if ($this->data['proj'] == 'new') {
            $tk_val = array();
            $tk_val['pname'] = $this->request->data['pnamenew'];
            $success = $this->Tasksproject->save($tk_val);
            $newid = $this->Tasksproject->getLastInsertId();
            $tk_new = array();
            $tk_new['pid'] = $newid;
            $tk_new['mname'] = $this->request->data['mname'];
            $tk_new['status'] = 0;
            $success1 = $this->Tasksprojectmodule->save($tk_new);
            if ($success && $success1) {
                $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                <a href="#" class="uk-alert-close uk-close"></a>New Project Saved SuccessFully</div>');
                $this->redirect('taskproject');
            }
        }

        //------------- Table Code --------------------------------------------
        $ar = $this->Tasksproject->find('all', array('fields' => array('pid', 'pname')));
        //------------------ End Table Code --------------------------------------- 

        $this->paginate = array('all',
            'fields' => array('pid', 'pname'),
            'limit' => 10,
            'order' => 'Tasksproject.pid ASC'
        );

        $data = $this->paginate('Tasksproject');
        $this->set("ar", $data);
    }

    public function module($val) {
        $sr = $this->Tasksprojectmodule->find('list', array('fields' => array('mid', 'mname'),
            'conditions' => array('pid' => $val)
        ));
        $this->set("sr", $sr);
    }

    public function approved($val, $tid) {
        if ($val == 7) {
            $s = 7;
            $success = $this->TaskAssign->updateAll(array('status' => $s), array('tid' => $tid));
        }
        if ($val == 0) {
            $s = 0;
            $success = $this->TaskAssign->updateAll(array('status' => $s), array('tid' => $tid));
        }
    }

    public function approved1($tid) {
        $s = 7;
        $success = $this->TaskAssign->updateAll(array('fstatus' => $s), array('tid' => $tid));
        $this->redirect('taskapproval');
    }

    public function approved2($tid) {
        $s = 7;
        $success = $this->TaskAssign->updateAll(array('status' => $s), array('tid' => $tid));
        $success11 = $this->Taskassignemp->updateAll(array('cstatus' => $s), array('tid' => $tid));
        $this->redirect('mtaskapproval');
    }

    public function rejecttask($tid) {
        $auth = $this->Session->read('Auth');
        $this->set("tid", $tid);
        if (isset($this->request->data['task']['cm'])) {
            $tid = $this->request->data['task']['tid'];
            $cm = $this->request->data['task']['cm'];
            $s = 0;
            $success = $this->TaskAssign->updateAll(array('status' => $s, 'comment' => "'$cm'"), array('tid' => $tid));
            $success11 = $this->Taskassignemp->updateAll(array('cstatus' => $s), array('tid' => $tid));
            $this->redirect("mtaskapproval");
        }
    }

    public function rejecttask1($tid) {
        $auth = $this->Session->read('Auth');
        $this->set("tid", $tid);
        if (isset($this->request->data['task']['cm'])) {
            $tid = $this->request->data['task']['tid'];
            $cm = $this->request->data['task']['cm'];
            $s = 0;
            $success = $this->TaskAssign->updateAll(array('fstatus' => $s, 'scomment' => "'$cm'"), array('tid' => $tid));
            $this->redirect("taskapproval");
        }
    }

    public function showreject($tid) {
        $auth = $this->Session->read('Auth');
        $ar2 = $this->TaskAssign->find('first', array('fields' => array('comment'),
            'conditions' => array('tid' => $tid)
        ));
        $this->set("ar2", $ar2);
        $this->set("tid", $tid);
        if (isset($this->request->data['task']['cm'])) {

            $tid = $this->request->data['task']['tid'];
            $cm = "Read It";
            $s = 0;
            $success = $this->TaskAssign->updateAll(array('status' => $s, 'comment' => "'$cm'"), array('tid' => $tid));

            $this->redirect("emptaskapproval");
        }
    }

    public function showreject1($tid) {
        $auth = $this->Session->read('Auth');
        $ar2 = $this->TaskAssign->find('first', array('fields' => array('scomment'),
            'conditions' => array('tid' => $tid)
        ));
        $this->set("ar2", $ar2);
        $this->set("tid", $tid);
        if (isset($this->request->data['task']['cm'])) {
            $tid = $this->request->data['task']['tid'];
            $cm = "Read It";
            $s = 0;
            $success = $this->TaskAssign->updateAll(array('fstatus' => $s, 'scomment' => "'$cm'"), array('tid' => $tid));
            $this->redirect("mtaskapproval");
        }
    }

    public function taskedit($id) {
        $this->layout = 'employee-new';
        $a = $this->TaskAssign->find('first', array('fields' => array('tname', 'tpriority', 'starttime', 'endtime', 'remark', 'status'),
            'conditions' => array('tid' => $id)
        ));
        $p = $this->Tasksproject->find('first', array('fields' => array('pid', 'pname'),
            "joins" => array(
                array(
                    "table" => "task_assigns",
                    "alias" => "TP",
                    "type" => "LEFT",
                    "conditions" => array(
                        "Tasksproject.pid = TP.pid"
                    )
                ),
            ),
            'conditions' => array(
                'TP.tid' => $id
            )
        ));
        $md = $this->Tasksprojectmodule->find('first', array('fields' => array('mid', 'mname'),
            "joins" => array(
                array(
                    "table" => "task_assigns",
                    "alias" => "TP",
                    "type" => "LEFT",
                    "conditions" => array(
                        "Tasksprojectmodule.mid = TP.mid"
                    )
                ),
            ),
            'conditions' => array(
                'TP.tid' => $id
            )
        ));
        $m1 = $this->Tasksprojectmodule->find('list', array('fields' => array('mid', 'mname'),
            'conditions' => array('pid' => $p['Tasksproject']['pid'])
        ));
        $emp1 = $this->Taskassignemp->find('all', array(
            'conditions' => array('Taskassignemp.tid' => $id),
            'joins' => array(
                array(
                    'table' => 'myprofile',
                    'alias' => 'Name',
                    'type' => 'LEFT',
                    'conditions' => array(
                        'Name.emp_code = Taskassignemp.emp_code'
                    )),
            ),
            'fields' => array(
                'Name.emp_code'
            )
        ));
        $emp2 = $this->Taskassignemp->find('list', array(
            'conditions' => array('Taskassignemp.tid' => $id),
            'joins' => array(
                array(
                    'table' => 'myprofile',
                    'alias' => 'Name',
                    'type' => 'LEFT',
                    'conditions' => array(
                        'Name.emp_code = Taskassignemp.emp_code'
                    )),
            ),
            'fields' => array(
                'Name.emp_code'
            )
        ));
        for ($i = 0; $i < count($emp1); $i++) {
            $emp[$i] = $this->MyProfile->find('all', array('fields' => array('emp_code', 'emp_name'),
                'conditions' => array('emp_code' => $emp1[$i]['Name']['emp_code'])
            ));
        }
        $ar = $this->Tasksproject->find('list', array('fields' => array('pid', 'pname')));
        $ar1 = $this->Tasksprojectmodule->find('list', array('fields' => array('mid', 'mname')));
        $auth = $this->Session->read('Auth');
        $m = $auth['MyProfile']['emp_code'];
        $mr = $this->MyProfile->find('first', array('fields' => array('desg_code'),
            'conditions' => array('emp_code ' => $m)
        ));
        if ($mr['MyProfile']['desg_code'] == 'PAR0000031') {
            $employee_name = $this->MyProfile->find('list', array('fields' => array('emp_code', 'emp_name'),
                'conditions' => array('emp_code !=' => $m)
            ));
        } elseif ($mr['MyProfile']['desg_code'] == 'PAR0000019') {
            $employee_name = $this->MyProfile->find('list', array('fields' => array('emp_code', 'emp_name'),
                'conditions' => array('desg_code !=' => 'PAR0000031')
            ));
        } else {
            $employee_name = $this->MyProfile->find('list', array('fields' => array('emp_code', 'emp_name'),
                'conditions' => array('desg_code !=' => array('PAR0000031', 'PAR0000019'))
            ));
        }

        $dt1 = DateTime::createFromFormat('Y-m-d', $a['TaskAssign']['starttime']);
        $dt = $dt1->format('d-m-y');
        $this->set("dt", $dt);


        $edt1 = DateTime::createFromFormat('Y-m-d', $a['TaskAssign']['endtime']);
        $edt = $edt1->format('d-m-y');
        $this->set("edt", $edt);
        $sr = $this->Tasksprojectmodule->find('list', array('fields' => array('mid', 'mname')
        ));
        $this->set("sr", $sr);

        $this->set("employee_name", $employee_name);
        $this->set("a", $a);
        $this->set("asd", $id);
        $this->set("ar", $ar);
        $this->set("ar1", $ar1);
        $this->set("p", $p);
        $this->set("m", $m);
        $this->set("m1", $m1);
        $this->set("emp", $emp);
        $this->set('emp2', $emp2);
        $this->set("md", $md);
    }

    public function projectedit($pid) {

        $ar = $this->Tasksproject->find('first', array('fields' => array('pid', 'pname'),
            'conditions' => array('pid' => $pid)
        ));
        $this->set("ar", $ar);
    }

    public function projectupdate() {
        $pid = $this->request->data['task']['pid'];
        $pn = $this->request->data['task']['pname'];
        $success = $this->Tasksproject->updateAll(array('pname' => "'$pn'"), array('pid' => $pid));
        $this->redirect("taskproject");
    }

    public function functionupdate() {
        $pid = $this->request->data['task']['pid'];
        $pn = $this->request->data['task']['mname'];
        $success = $this->Tasksprojectmodule->updateAll(array('mname' => "'$pn'"), array('mid' => $pid));
        $this->redirect("taskproject");
    }

    public function taskapproval() {
        $this->layout = 'employee-new';
        $join = $this->TaskAssign->find('all', array('fields' => array('tid', 'tname', 'starttime', 'endtime', 'status', 'fstatus', 'sdate', 'fsdate')
        ));
        $data = $this->paginate('TaskAssign');
        $this->set("join", $data);
    }

    public function emptaskapproval() {
        $this->layout = 'employee-new';
        $auth = $this->Session->read('Auth');
        $emp_code = $auth['MyProfile']['emp_code'];
        $this->paginate = array(
            'fields' => array('*'),
            'limit' => 10,
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
            'fields' => array('TaskAssign.*', 'Assigned.*', 'Alert.*'),
            'conditions' => array('Assigned.emp_code' => $emp_code)
        );
        $data = $this->paginate('TaskAssign');
        $this->set("join", $data);
    }

    public function mtaskapproval() {
        $this->layout = 'employee-new';
        $join = $this->TaskAssign->find('all', array('fields' => array('tid', 'tname', 'starttime', 'endtime', 'status', 'fstatus', 'sdate', 'fsdate')
        ));
        $a = array_filter($join); //----- Remove null element in array
        $new = array_values($a); //------ Re-arrange index value 
        $data = $this->paginate('TaskAssign');
        $this->set("join", $data);
    }

    public function sendalert($tid) {
        $auth = $this->Session->read('Auth');
        $ar = $this->Taskassignemp->find('all', array('fields' => array('emp_code'),
            'conditions' => array('tid' => $tid),
            'joins' => array(
                array(
                    'table' => 'myprofile',
                    'alias' => 'Name',
                    'type' => 'LEFT',
                    'conditions' => array(
                        'Name.emp_code = Taskassignemp.emp_code'
                    )),
            ),
            'fields' => array(
                'Name.emp_code', 'Name.emp_firstname'
            )
        ));
        $tk_val = array();
        $tk_val['tid'] = $tid;
        $tk_val['statusid'] = 8;

        $ar = $this->TaskAlert->find('first', array('fields' => array('tid'),
            'conditions' => array('tid' => $tid)
        ));

        if ($ar == NULL) {
            $success = $this->TaskAlert->save($tk_val);
            if ($auth['MyProfile']['desg_code'] == 'PAR0000031') {
                $this->redirect('taskdashboard');
            }
            if ($auth['MyProfile']['desg_code'] == 'PAR0000019') {
                $this->redirect('mtaskdashboard');
            }

            $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                <a href="#" class="uk-alert-close uk-close"></a>Alert Send Succesfully.</div>');
        } else {

            $success1 = $this->TaskAlert->updateAll(array('statusid' => $tk_val['statusid']), array('tid' => $tid));
            $success22 = $this->Taskassignemp->updateAll(array('statusid' => $tk_val['statusid']), array('tid' => $tid));
            if ($auth['MyProfile']['desg_code'] == 'PAR0000031') {
                $this->redirect('taskdashboard');
            }
            if ($auth['MyProfile']['desg_code'] == 'PAR0000019') {
                $this->redirect('mtaskdashboard');
            }
            $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                <a href="#" class="uk-alert-close uk-close"></a>Alert Allready send.</div>');
        }
    }

    public function getalertupdate($tid) {
        $auth = $this->Session->read('Auth');
        $ar = $this->TaskAlert->find('first', array('fields' => array('statusid', 'emp_reply'),
            'conditions' => array('tid' => $tid)
        ));
        // print_r($ar);
        $this->set("tid", $tid);
        $this->set("ar", $ar);
    }

    public function getalert($tid) {
        $auth = $this->Session->read('Auth');
        $ar = $this->TaskAlert->find('first', array('fields' => array('statusid', 'emp_reply', 'comment'),
            'conditions' => array('tid' => $tid)
        ));
        $this->set("tid", $tid);
        $this->set("ar", $ar);
        if (isset($this->request->data['task']['tid'])) {
            $tid = $this->request->data['task']['tid'];
            $statusid = 1;
            $emp_reply = $this->request->data['task']['emp'];
            $success = $this->TaskAlert->updateAll(array('statusid' => $statusid, 'emp_reply' => "'$emp_reply'"), array('tid' => $tid));
            if ($auth['MyProfile']['desg_code'] == 'PAR0000031') {
                $this->redirect('taskdashboard');
            }
            if ($auth['MyProfile']['desg_code'] == 'PAR0000019') {
                $this->redirect('mtaskdashboard');
            } else {
                $this->redirect('emptask');
            }
        }
    }

    public function taskforward($id) {

        $this->layout = 'employee-new';
        $a = $this->TaskAssign->find('first', array('fields' => array('tname', 'tpriority', 'starttime', 'endtime', 'remark', 'status'),
            'conditions' => array('tid' => $id)
        ));

        $p = $this->Tasksproject->find('first', array('fields' => array('pid', 'pname'),
            "joins" => array(
                array(
                    "table" => "task_assigns",
                    "alias" => "TP",
                    "type" => "LEFT",
                    "conditions" => array(
                        "Tasksproject.pid = TP.pid"
                    )
                ),
            ),
            'conditions' => array(
                'TP.tid' => $id
            )
        ));
        $md = $this->Tasksprojectmodule->find('first', array('fields' => array('mid', 'mname'),
            "joins" => array(
                array(
                    "table" => "task_assigns",
                    "alias" => "TP",
                    "type" => "LEFT",
                    "conditions" => array(
                        "Tasksprojectmodule.mid = TP.mid"
                    )
                ),
            ),
            'conditions' => array(
                'TP.tid' => $id
            )
        ));
        $m1 = $this->Tasksprojectmodule->find('list', array('fields' => array('mid', 'mname'),
            'conditions' => array('pid' => $p['Tasksproject']['pid'])
        ));

        $emp1 = $this->Taskassignemp->find('all', array(
            'conditions' => array('Taskassignemp.tid' => $id),
            'joins' => array(
                array(
                    'table' => 'myprofile',
                    'alias' => 'Name',
                    'type' => 'LEFT',
                    'conditions' => array(
                        'Name.emp_code = Taskassignemp.emp_code'
                    )),
            ),
            'fields' => array(
                'Name.emp_code'
            )
        ));
        $emp2 = $this->Taskassignemp->find('list', array(
            'conditions' => array('Taskassignemp.tid' => $id),
            'joins' => array(
                array(
                    'table' => 'myprofile',
                    'alias' => 'Name',
                    'type' => 'LEFT',
                    'conditions' => array(
                        'Name.emp_code = Taskassignemp.emp_code'
                    )),
            ),
            'fields' => array(
                'Name.emp_code'
            )
        ));
        //print_r($emp2); die;
        for ($i = 0; $i < count($emp1); $i++) {
            $emp[$i] = $this->MyProfile->find('all', array('fields' => array('emp_code', 'emp_name'),
                'conditions' => array('emp_code' => $emp1[$i]['Name']['emp_code'])
            ));
        }
        $ar = $this->Tasksproject->find('list', array('fields' => array('pid', 'pname')));
        $ar1 = $this->Tasksprojectmodule->find('list', array('fields' => array('mid', 'mname')));
        $auth = $this->Session->read('Auth');
        $m = $auth['MyProfile']['emp_code'];
        $mr = $this->MyProfile->find('first', array('fields' => array('desg_code'),
            'conditions' => array('emp_code' => $m)
        ));
        if ($mr['MyProfile']['desg_code'] == 'PAR0000031') {
            $employee_name = $this->MyProfile->find('list', array('fields' => array('emp_code', 'emp_name'),
                'conditions' => array('emp_code !=' => $m)
            ));
        } elseif ($mr['MyProfile']['desg_code'] == 'PAR0000019') {
            $employee_name = $this->MyProfile->find('list', array('fields' => array('emp_code', 'emp_name'),
                'conditions' => array('desg_code !=' => 'PAR0000031')
            ));
        } else {
            $employee_name = $this->MyProfile->find('list', array('fields' => array('emp_code', 'emp_name'),
                'conditions' => array('desg_code !=' => array('PAR0000031', 'PAR0000019'))
            ));
        }
        $dt1 = new DateTime();
        $dt = $dt1->format('d-m-y');
        $this->set("dt", $dt);
        $sr = $this->Tasksprojectmodule->find('list', array('fields' => array('mid', 'mname'), 'conditions' => array('pid' => $p['Tasksproject']['pid'])
        ));
        $this->set("sr", $sr);
        $edt1 = DateTime::createFromFormat('Y-m-d', $a['TaskAssign']['endtime']);
        $edt = $edt1->format('d-m-y');
        $this->set("edt", $edt);
        $this->set("employee_name", $employee_name);
        $this->set("a", $a);
        $this->set("asd", $id);
        $this->set("ar", $ar);
        $this->set("ar1", $ar1);
        $this->set("p", $p);
        $this->set("m", $m);
        $this->set("m1", $m1);
        $this->set("emp", $emp);
        $this->set("emp1", $emp1);
        $this->set("emp2", $emp2);
        $this->set("md", $md);
    }

    public function employeelist($val) {
        $employee_name = $this->MyProfile->find('list', array('fields' => array('emp_code', 'emp_name'),
            'conditions' => array('dept_code' => $val),
            'order' => array('MyProfile.emp_name' => 'DESC')
        ));
        $this->set("employee_list", $employee_name);
    }
    
    function mail_test(){
                $From = $this->Common->getSuportEmailId('01');
                
            $data['logo'] = 'logo_email.png';
            $To = 'ayush.pant@essindia.com';
            $this->send_mail($From, $To, $CC, 'Alert Added to Task No -' . $id, 'An alert Message is generated for Task No -' . $id . ' Please check', 'default', $data);
            die('here');
        
    }

}
?>















