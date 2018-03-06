<?php

App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');

class MomsController extends AppController {

    public $name = 'Moms';
    public $uses = array('MomAssign','MomEmpResponse', 'MomAssignEmp', 'MyProfile','Departments');
    public $helpers = array('Js', 'Html', 'Form', 'Session', 'Userdetail', 'Common');
    public $components = array('Auth', 'Session', 'Email', 'Cookie', 'EmpDetail', 'Common', 'RequestHandler');
    var $paginate = array(
        'limit' => 10,
        'order' => array(
            'MomAssign.mid' => 'asc'
        )
    );

    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow();
        $currentUser = $this->checkUser();
    }

    public function addMeeting() {
        $this->layout = 'employee-new';
        $auth = $this->Session->read('Auth');
        $m = $auth['MyProfile']['emp_code'];
        
        // --------- MOM Id Auto insert in Text Box----------------------
        $totalRecords = $this->MomAssign->find('first', array('fields' => array('id'),
            'order' => array('id' => 'DESC')));        
        
        if ($totalRecords == Null) {
            $t = 0;
        } else {
            $t = $totalRecords['MomAssign']['id'];
        }        
        $meetingId = $t + 1;
        
        $dept = $this->Departments->find('list', array(
                    'fields' => array('Departments.dept_code','Departments.dept_name'),
                    'conditions' => array('Departments.comp_code' => '01')
                ));       
        
        $this->set("department_list", $dept);        
        $this->set("meetingId", $meetingId);
       
    }

    public function assign() {
        Configure::write('debug',2);
        $auth = $this->Session->read('Auth');
        $empCode = $auth['MyProfile']['emp_code'];
        $n = time();
        if(!empty($_FILES['doc_file']['name'])){
            $newfilename = $n . basename($_FILES['doc_file']['name']);
            $file = "uploads/mom/" . $newfilename;
            $filename = basename($_FILES['doc_file']['name']);
            move_uploaded_file($_FILES['doc_file']['tmp_name'], $file);            
        }else{
            $newfilename = "";
        }
       
        $tk_val = array();
        
        $tk_val['meeting_date'] = date("Y-m-d",  strtotime($this->request->data['meeting_date']));
        $tk_val['meeting_time'] = $this->request->data['meeting_time'];
        $tk_val['mid'] = $this->request->data['mid'];
        $tk_val['task_id'] = isset($this->request->data['task_id'])?$this->request->data['task_id']:0; 
        $tk_val['subject'] = $this->request->data['subject'];
        $tk_val['description'] = $this->request->data['des'];        
        $tk_val['responsibility'] = $this->request->data['res'];
        $tk_val['remark'] = $this->request->data['remark'];     
        $tk_val['mremark'] = $this->request->data['meeting_remark'];
        $tk_val['department_id'] = $this->request->data['department_id'];
        $tk_val['createby'] = $empCode;
        
        $tk_val['uploaded_file'] = $newfilename;
        $tk_val['meeting_status'] = 1;
        $tk_val['post_on'] = date("Y-m-d");

        $success = $this->MomAssign->save($tk_val);
        
        if ($success) {
            $task = array();
            $new = 0;
            foreach ($this->data['employee_id'] as $k) {
                $task['mid'] = $this->request->data['mid'];
                $task['emp_code'] = $this->data['employee_id'][$new];
                $new++;
                $this->MomAssignEmp->create();
                $success1 = $this->MomAssignEmp->save($task);
            }
            if ($success1){
                $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
            <a href="#" class="uk-alert-close uk-close"></a>Meeting details saved succesfully. !!!</div>');
                unset($tk_val);
            }
        } else {
            $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert="">
            <a href="#" class="uk-alert-close uk-close"></a>Oops !! Some error Occured. !!!</div>');
        }

        $this->redirect('viewMeeting');
    }

    public function viewMeeting() {
        $this->layout = 'employee-new';
        $auth = $this->Session->read('Auth');
        $empCode = $auth['MyProfile']['emp_code'];
        
        $this->paginate = array(
            'limit' => 10,
            'fields' => array('MomAssign.id','MomAssign.mid','MomAssign.task_id', 'MomAssign.subject','meeting_date','meeting_time','meeting_status' ,'description', 'mremark', 'responsibility', 'remark', 'createby', 'uploaded_file'),
            'conditions' => array('MomAssign.createby' => $empCode),
            'order' => array('MomAssign.id' => 'desc')
        );
        
        $data = $this->paginate('MomAssign');  
        $this->set("ar",$data); 
        
        //// Update Meeting Status /////
        
        if($this->request->data){
            if(isset($this->request->data['id'])){
                $meeting_id = $this->request->data['id'];
                $meeting_status = $this->request->data['meeting_status'];        
                $task = array();
                    $m = 0;
                    foreach ($this->data['id'] as $k) {
                        $mID = $this->request->data['id'][$m];
                        $meeting_status = $this->data['meeting_status'];
                        $m++;
                        $success = $this->MomAssign->updateAll(array('meeting_status' => $meeting_status),array('id' => $mID));
                    }
                    if ($success){
                        $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                        <a href="#" class="uk-alert-close uk-close"></a>Meeting status saved succesfully. !!!</div>');
                        $this->redirect("viewMeeting");
                    }
            }else{
                $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert="">
                <a href="#" class="uk-alert-close uk-close"></a>Please select at least one Meeting. !!!</div>');
                $this->redirect("viewMeeting");
            }        
        }
    }
    
    public function empresponse($id){          
        $ar= $this->MomAssign->find('first',array('feilds'=>array('mid','response'),'conditions'=>array('mid'=>$id)));
        $this->set("ar",$ar);          
    }

    public function response($momID){ 
        
        $empMeeting = $this->params['url']['empMeeting'];
        
        if($empMeeting == ""){
            $id = $momID;
        }else{
            $id = $this->params['url']['momID'];
        }        
        
        $empResponse = $this->MomEmpResponse->find('all', array('fields' => array('MomEmpResponse.response', 'MomEmpResponse.response_datetime','Name.emp_firstname','Name.emp_lastname','Name.image','Name.desg_code','Name.comp_code'),            
            'conditions' => array('MomEmpResponse.mid' => $id),
            'joins' => array(
                array(
                    'table' => 'myprofile',
                    'alias' => 'Name',
                    'type' => 'LEFT',
                    'conditions' => array(
                        'Name.emp_code = MomEmpResponse.emp_code'
                    )),
            ),
        ));
        $this->set("empResponse", $empResponse); 
        $this->set("meetingID",$id);
        $this->set('empMeeting',$empMeeting);
        
    }   
      
    public function responseSave(){
        
        $auth = $this->Session->read('Auth');        
        
        $empCode = $auth['MyProfile']['emp_code'];        
        $empMeeting = $this->request->data['mom']['empMeeting'];        
        
        if(isset($this->request->data['mom']['response']))
        {
            $response_arr = array();   
            $response_arr['mid'] = $this->request->data['mom']['mid'];
            $response_arr['response'] = $this->request->data['mom']['response'];
            $response_arr['emp_code'] = $empCode;
            $response_arr['response_datetime'] = date("Y-m-d h:i:s");                       
            $success = $this->MomEmpResponse->save($response_arr);
            
            if($success){
                $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                <a href="#" class="uk-alert-close uk-close"></a>Response save successfully. !!!</div>'); 
            }else{
               $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert="">
                <a href="#" class="uk-alert-close uk-close"></a>Response not save successfully. !!!</div>');  
            }
            if($empMeeting == ""){
                $this->redirect("viewMeeting");
            }else{
                $this->redirect("empMeeting");
            }
        }       
        
      }
    
    public function employeelist($val) {
        $employee_name = $this->MyProfile->find('list', array('fields' => array('emp_code', 'emp_name'),
            'conditions' => array('dept_code' => $val),
            'order' => array('MyProfile.emp_name'=> 'DESC')
        ));
        $this->set("employee_list", $employee_name);
    }
    
    public function momdetails($id) {
        
        $ar = $this->MomAssign->find('all', array(
            'conditions' => array('id' => $id)
        ));
        $this->set("ar", $ar);
        
        $emp = $this->MomAssignEmp->find('all', array(
            'conditions' => array('MomAssignEmp.mid' => $id),
            'joins' => array(
                array(
                    'table' => 'myprofile',
                    'alias' => 'Name',
                    'type' => 'LEFT',
                    'conditions' => array(
                        'Name.emp_code = MomAssignEmp.emp_code'
                    )),
            ),
            'fields' => array('Name.emp_firstname','Name.emp_lastname','Name.image','Name.desg_code','Name.comp_code')
        ));
        
//        echo "<pre>";
//        print_r($emp);
        
        $assignby = $this->MomAssign->find('first', array('fields' => array('createby'),
            'conditions' => array('mid' => $id)
        ));

        $this->set("emp", $emp);
        $this->set("assignby", $assignby);
    }
    
    public function momedit($id) {
        $this->layout = 'employee-new';
        
        $a = $this->MomAssign->find('first', 
                array('fields' => array('MomAssignEmp.*','MomAssign.id','MomAssign.mid','MomAssign.task_id', 'MomAssign.subject','meeting_date','meeting_time', 'description', 'mremark', 'responsibility', 'remark', 'department_id','createby', 'uploaded_file'),
           'conditions' => array('MomAssign.id' => $id),
           'joins' => array(
                array(
                    'table' => 'mom_assign_emp',
                    'alias' => 'MomAssignEmp',
                    'type' => 'LEFT',
                    'conditions' => array(
                        'MomAssign.mid = MomAssignEmp.mid'
                    )),
            )
        ));
//        echo "<pre>";
//        print_r($a);die;
        $dept = $this->Departments->find('list', array(
                    'fields' => array('Departments.dept_code','Departments.dept_name'),
                    'conditions' => array('Departments.comp_code' => '01')
                ));
        
        
        $this->set("department_list", $dept);
        
        $listing = $this->MyProfile->find('list',array('fields'=>array('emp_code', 'emp_full_name'),
                                'conditions' => array('dept_code' => $a['MomAssign']['department_id'])
                                ));
        
        
//         echo "<pre>";
//        print_r($listing);die;
        
        $selectedListing = $this->MomAssignEmp->find('list',array('fields'=>array('emp_code'),
                                'conditions' => array('mid' => $id)
                                ));
        
        
        
        $this->set("selectedListing", $selectedListing);
        $this->set("listing", $listing );     

        $auth = $this->Session->read('Auth');        
        $this->set("a", $a);
        
    }

    public function momupdate() {
        $auth = $this->Session->read('Auth');
        
        $empCode = $auth['MyProfile']['emp_code'];
        $momID = $this->request->data['mid'];        
              
        $success1 = $this->MomAssignEmp->deleteAll(array('mid' => $momID));
        
        $uploaded_file = $this->request->data['upload_file'];      
       
        
        if($_FILES['doc_file']['name'] != ""){
            if($uploaded_file != ""){
                $newfilename = $uploaded_file;
            }else{
                $newfilename = PSC."_".time()."_".basename($_FILES['doc_file']['name']);
            }
            $file = "uploads/mom/" . $newfilename;
            $filename = basename($_FILES['doc_file']['name']);
            move_uploaded_file($_FILES['doc_file']['tmp_name'], $file);
        }else{            
            $file = "uploads/mom/" . $uploaded_file;
            $newfilename = $uploaded_file; 
            move_uploaded_file($_FILES['doc_file']['tmp_name'], $file);
        }
       
        
        $tk_val = array();
        
        $meeting_date = date("Y-m-d",  strtotime($this->request->data['meeting_date']));
        $meeting_time = $this->request->data['meeting_time'];
        
        $task_id = isset($this->request->data['task_id'])?$this->request->data['task_id']:0; 
        $subject = $this->request->data['subject'];
        $description = $this->request->data['des'];        
        $responsibility = $this->request->data['res'];
        $remark = $this->request->data['remark'];     
        $meeting_remark = $this->request->data['meeting_remark'];
        $department_id = $this->request->data['department_id'];     
        
        $uploaded_file = $newfilename;
        $meeting_status = 1;
        $tk_val['post_on'] = date("Y-m-d");
        
        

        $success = $this->MomAssign->updateAll(array('meeting_date' => "'$meeting_date'",'meeting_time' => "'$meeting_time'",'subject' => "'$subject'",
            'task_id' => $task_id,'description' => "'$description'", 'mremark' => "'$meeting_remark'", 'responsibility' => "'$responsibility'",
            'remark' => "'$remark'",'department_id' => "'$department_id'", 'createby' => "'$empCode'",'uploaded_file' => "'$newfilename'"), 
            
            array('mid' => $momID));
        if ($success) {
            $task = array();
            $new = 0;
            foreach ($this->data['employee_id'] as $k) {
                $task['mid'] = $momID;
                $task['emp_code'] = $this->data['employee_id'][$new];
                $new++;
                $this->MomAssignEmp->create();
                $success1 = $this->MomAssignEmp->save($task);
            }
            if ($success1) {
                $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
            <a href="#" class="uk-alert-close uk-close"></a>Record updated succesfully. !!!</div>');
                unset($tk_val);
            }
        } else {
            $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert="">
            <a href="#" class="uk-alert-close uk-close"></a>Oops !! Some error Occured. !!!</div>');
        }

        $this->redirect('viewMeeting');
    }

    public function momdelete($sid) {
        $auth = $this->Session->read('Auth');
        $success1 = $this->MomAssign->deleteAll(array('mid' => $sid));
        $success2 = $this->MomAssignEmp->deleteAll(array('mid' => $sid));
        $success3 = $this->MomEmpResponse->deleteAll(array('mid' => $sid));
        $this->redirect('viewMeeting');
    }

    public function empMeeting(){
        $emp_code = $this->Auth->User('emp_code');
        $this->layout = 'employee-new';
        $auth = $this->Session->read('Auth');
        $emp = $auth['MyProfile']['emp_code'];
        
        $this->paginate = array(
            'conditions' => array('MomAssignEmp.emp_code' => $emp),
            'joins' => array(
                array(
                    'alias' => 'MomAssignEmp',
                    'table' => 'mom_assign_emp',
                    'type' => 'INNER',
                    'conditions' => '`MomAssign`.`mid` = `MomAssignEmp`.`mid`'
                )
            ),
            'limit' => 10,
            'order' => array(
                'MomList.id' => 'desc'
            )
        );
        $this->set('ar', $this->paginate($this->MomAssign ));       
        $this->set("emp", $emp);
    }

}

?>