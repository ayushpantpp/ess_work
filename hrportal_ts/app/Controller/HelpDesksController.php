<?php

/*
 * Property of Eastern Software Systems Pvt. Ltd.
 * Should be modified on by a Cake PHP Professional
 *  ******************************************************************************
 *  Description of HelpDesks_controller.php
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
 * project version: 0.1.0
 *  @author Ayush Pant <ayush.pant@essindia.com>
 *  @client company: Eastern Software Systems Pvt. Ltd. Expression project.user is undefined on line 21, column 73 in Templates/Licenses/license-default.txt.
 *  @date created: 2017
 *  @date last modified: Jun 28, 2011 2:59:31 PM
 *  ******************************************************************************
 */

App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');

class HelpDesksController extends AppController {

    public $name = 'HelpDesks';
    public $uses = array('HelpDesk', 'Tasksproject', 'AttendanceDetail', 'EmpAddress', 'MomAssign', 'UserDetail', 'Icon', 'IconUser', 'UserAudittrail', 'MyProfile', 'KraKpiProcess', 'LabelPage', 'LabelBlock', 'Labels', 'Ticker', 'TickerUser', 'Departments', 'Event', 'Separation', 'DtTravelVoucher', 'DtExpVoucher', 'EmpDocuments', 'ImportantDocCategory', 'HelpDeskDtl', 'DependentDetails', 'Tasksprojectmodule', 'Taskassignemp', 'TaskAlert', 'WfMstStatus');
    public $helpers = array('Js', 'Html', 'Form', 'Session', 'Userdetail', 'Common');
    public $components = array('Auth', 'Session', 'Email', 'Cookie', 'EmpDetail', 'Common', 'RequestHandler');
    var $paginate = array(
        'limit' => 10,
        'order' => array(
            'HelpDesk.ticket_id' => 'desc'
        )
    );
    var $paginate1 = array(
        'limit' => 10,
        'order' => array(
            'Tasksproject.pid' => 'desc'
        )
    );

    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow();
        $currentUser = $this->checkUser();
    }

    public function test() {
        $Email = new CakeEmail();
        $Email->config('smtp');
        $Email->from('testemail@essindia.com');
        $Email->to('ankit.kumar2@essindia.com');
        $Email->subject('Assign New Task');
        ;

        if ($Email->send('Hello , You get new task.. ')) {


            echo "Email sent successfully";
        } else {
            echo $this->Email->smtpError;
            echo "Error in email sending......";
        }
        die;
    }

    public function index() {
        $complainer_name = $this->Auth->User('user_name');
        $complainer_email = $this->Auth->User('email');
        $complainer_id = $this->Auth->User('emp_code');
        $this->set('complainer_email', $complainer_email);
        $this->set('complainer_name', $complainer_name);
        $this->set('complainer_id', $complainer_id);
        $lastCreated = $this->HelpDesk->find('first', array('fields' => array('id'),
            'order' => array('HelpDesk.id' => 'desc')
        ));
        $ticket_category = new Model(array('table' => 'ticket_category', 'ds' => 'default', 'name' => 'TICKETCAT'));
        $data_oracle = $ticket_category->find('list', array('fields' => array('id', 'category_name')));
        $this->set('cat_list', $data_oracle);
        if (empty($lastCreated)) {
            $lastCreated['HelpDesk']['id'] = 0;
        }
        $this->set('last_id', $lastCreated['HelpDesk']['id']);
        $dept = $this->Departments->find('list', array(
            'fields' => array('Departments.dept_code', 'Departments.dept_name'),
            'conditions' => array('Departments.comp_code' => '01')
        ));
        $this->set("department_list", $dept);
        $moms = $this->MomAssign->find('list', array(
            'fields' => array('MomAssign.task_id', 'MomAssign.subject'))
        );
        $this->set("mom_list", $moms);
        $dept = $this->Departments->find('list', array(
            'fields' => array('Departments.dept_code', 'Departments.dept_name'),
            'conditions' => array('Departments.comp_code' => '01')
        ));
        $this->set("department_list", $dept);
        $this->layout = 'employee-new';
        $auth = $this->Session->read('Auth');
        //print_r($auth); die;
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
        $a = $this->HelpDesk->find('first', array('fields' => array('id'),
            'order' => array('id' => 'DESC')));

        if ($a == Null) {
            $t = 0;
        } else {
            $t = $a['HelpDesk']['id'];
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

    public function ticketraise() {
        $this->layout = 'employee-new';
        $auth = $this->Session->read('Auth');
        
        if (!empty($_FILES['proof_file']['name'])) {
            $newfilename = $n . basename($_FILES['proof_file']['name']);
            $file = "uploads/complaints/" . $newfilename;
            $filename = basename($_FILES['proof_file']['name']);
            move_uploaded_file($_FILES['proof_file']['tmp_name'], $file);
        } else {
            $newfilename = "";
        }
        $max_ticket_id = $this->HelpDesk->find('first',array('fields'=>array('MAX(ticket_id) as max_ticket_id')));
        $tk_val = array();
        $tk_val['ticket_id'] = $max_ticket_id[0]['max_ticket_id'] + 1;
        $tk_val['ticket_type'] = $this->request->data['ticket_type'];
        $tk_val['priority'] = $this->request->data['priority'];
        $tk_val['complainer_id'] = $this->request->data['complainer_id'];
        $tk_val['complainer_name'] = $this->request->data['complainer_name'];
        $tk_val['complainer_email'] = $this->request->data['complainer_email'];
        $tk_val['status'] = $this->request->data['status'];
        $tk_val['remark'] = $this->request->data['remark'];
        $tk_val['complaint_date'] = date('Y-m-d');
        $tk_val['proof_file'] = $newfilename;
        $success = $this->HelpDesk->save($tk_val);
        $From = $this->Common->getSuportEmailId('01');
        $id = $this->request->data['ticket_id'];
        $data['name'] = $this->request->data['complainer_name'];
        $data['logo'] = 'logo_email.png';
        $this->send_mail($From, $this->request->data['complainer_email'], $CC, 'Complaint Registered Ticket No -' . $id, 'Your Complaint Have been registered with Ticket No -' . $id . ' Successfully', 'default', $data);
        $this->send_mail($From, $From, $CC, 'Complaint Registered Ticket No -' . $id, 'A Complaint Have been registered with Ticket No -' . $id . ' Please Assign Assign the Same', 'default', $data);


        if ($success) {
            $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                <a href="#" class="uk-alert-close uk-close"></a>Task details saved succesfully. !!!</div>');
        } else {
            $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                <a href="#" class="uk-alert-close uk-close"></a>Some error Occured . !!!</div>');
        }
        $this->redirect('emp_complaints');
    }

    public function emp_list($id) {
        $values = $this->Common->getEmployeesList();

        $html = '<select class="md-input" name="emp_code" id="tpriority" data-md-selectize-inline>';
        foreach ($values as $v) {
            $html .= '<option  value=' . $v["MyProfile"]["emp_code"] . '>' . $v["MyProfile"]["emp_name"] . '</option>';
        }
        $html .= '</select>';
        $html .= '<input type="hidden" name="ticket_id" value=' . $id . '>';
        echo $html;
        die;
    }

    public function assignto() {
        $id = $this->request->data['ticket_id'];
        $emp_code = $this->request->data['emp_code'];
        $success11 = $this->HelpDesk->updateAll(array('assigned' => 1, 'assign_to' => $emp_code), array('id' => $id));
        $From = $this->Common->getSuportEmailId('01');
        $detail = $this->Common->findEmpMail($emp_code);
        //print_r($detail); die;
        $data['name'] = $detail['UserDetail']['user_name'];
        $data['logo'] = 'logo_email.png';
        $this->send_mail($From, $detail['UserDetail']['email'], $CC, 'Complaint Assigned Ticket No -' . $id, 'A Complaint with Ticket No - ' . $id . 'have been Assigned to you , Kindly login into the Portal to view the same.', 'default', $data);

        $this->redirect('complaints');
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

    public function complaints() {
        $emp_code = $this->Auth->User('emp_code');
        $this->layout = 'employee-new';
        $data = $this->paginate('HelpDesk');
        $this->set('assignedTask', $data);
    }

    public function assign_complaints() {
        $emp_code = $this->Auth->User('emp_code');
        $this->layout = 'employee-new';
        $data = $this->paginate('HelpDesk', array('assign_to' => $emp_code, 'current_status !=' => 3));
//		/print_r($data);
        $this->set('assignedTask', $data);
    }

    public function emp_complaints() {
        $emp_code = $this->Auth->User('emp_code');
        $this->layout = 'employee-new';
        $data = $this->paginate('HelpDesk', array('complainer_id' => $emp_code));
        $this->set('assignedTask', $data);
    }

    public function task_form() {
        $emp_code = $this->Auth->User('emp_code');
        $this->layout = '';
        $dept = $this->Departments->find('list', array(
            'fields' => array('Departments.dept_code', 'Departments.dept_name'),
            'conditions' => array('Departments.comp_code' => '01')
        ));
        //echo "<pre>"; print_r($dept); die;
        $this->set("department_list", $dept);
        $ar = $this->Tasksproject->find('list', array('fields' => array('pid', 'pname')));
        $this->set('ar', $ar);
    }

    public function get_comments($id) {

        $comments = $this->HelpDeskDtl->find('all', array('conditions' => array('mst_ticket_id' => $id)));
        $comment_dtl = $this->HelpDesk->find('all', array('conditions' => array('id' => $id)));
        $this->set('comments', $comments);
        $this->set('comment_dtl', $comment_dtl[0]);
    }

    public function add_comment($id, $comment) {
        //print_r($this->request->data); die;
        $emp_code = $this->Auth->User('emp_code');
        $comp_code = $this->Auth->User('comp_code');
        if (!empty($this->request->data)) {
            $comment = $this->request->data['HelpDesks']['ticket_comment'];
            $id_form = $this->request->data['ticket_id'];
            $tk_val = array();
            $tk_val['mst_ticket_id'] = $this->request->data['ticket_id'];
            $tk_val['commenter_id'] = $emp_code;
            $tk_val['comp_code'] = $comp_code;
            $tk_val['comment'] = $this->request->data['ticket_comment'];
            $tk_val['comment_date'] = date('Y-m-d');
            $success = $this->HelpDeskDtl->save($tk_val);
            if ($success) {
                $success11 = $this->HelpDesk->updateAll(array('comment_done' => 1), array('id' => $id_form));
                $get_data = $this->HelpDesk->find('first', array('conditions' => array('ticket_id' => $this->request->data['ticket_id'])));
                $From = $this->Common->getSuportEmailId('01');

                $data['name'] = $this->Auth->User('user_name');
                $data['logo'] = 'logo_email.png';
                $this->send_mail($From, $get_data['HelpDesk']['complainer_email'], $CC, 'Comment Added to Ticket No -' . $id, 'A Comment is added to Ticket No - ' . $id . 'Kindly login into the Portal to view the same.', 'default', $data);
            }

            $this->redirect('assign_complaints');
            $this->autoRender = false;
        } else if ($id != '' && $comment != '') {
            $tk_val = array();
            $tk_val['mst_ticket_id'] = $id;
            $tk_val['commenter_id'] = $emp_code;
            $tk_val['comp_code'] = $comp_code;
            $tk_val['comment'] = $comment;
            $tk_val['comment_date'] = date('Y-m-d');
            $success = $this->HelpDeskDtl->save($tk_val);
            if ($success) {
                $get_data = $this->HelpDesk->find('first', array('conditions' => array('ticket_id' => $id)));
                $From = $this->Common->getSuportEmailId('01');
                $get_data['HelpDesk']['complainer_email'];
                $data['name'] = $this->Auth->User('user_name');
                $data['logo'] = 'logo_email.png';
                $this->send_mail($From, $get_data['HelpDesk']['complainer_email'], $CC, 'Comment Added to Ticket No -' . $id, 'A Comment is added to Ticket No - ' . $id . 'Kindly login into the Portal to view the same.', 'default', $data);
            }
        }
        $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                <a href="#" class="uk-alert-close uk-close"></a>Comment Saved succesfully. !!!</div>');
    }

    public function get_ticket_details($id) {
        $values = $this->HelpDesk->find('all', array('conditions' => array('id' => $id)));
        echo json_encode($values);
        die;
    }

    public function updatestatus($fstatus, $id) {
        //Configure::write('debug',2);
        $p = date('Y-m-d');
        $success = $this->HelpDesk->updateAll(array('current_status' => $fstatus, 'st_change_date' => "'$p'"), array('id' => $id));
        if($fstatus == 3){
            $get_data = $this->HelpDesk->find('first', array('conditions' => array('ticket_id' => $id)));
            $From = $this->Common->getSuportEmailId('01');
            $get_data['HelpDesk']['complainer_email'];
            $data['name'] = $this->Auth->User('user_name'); 
            $data['logo'] = 'logo_email.png';
            $this->send_mail($From, $get_data['HelpDesk']['complainer_email'], $CC, 'Closed Ticket No -' . $id, 'Your Ticket No - ' . $id . ' is closed from the Help Team , Kindly login into the Portal to Review the same.', 'default', $data);
            }
        
        if ($success) {
            
            $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                <a href="#" class="uk-alert-close uk-close"></a>Status Changed succesfully. !!!</div>');
            $this->redirect('HelpDesks/complaints');
        } else {
            $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                <a href="#" class="uk-alert-close uk-close"></a>Status Not Changed. !!!</div>');
            $this->redirect('HelpDesks/complaints');
        }
        $this->redirect('HelpDesks/complaints');
    }

}
?>














