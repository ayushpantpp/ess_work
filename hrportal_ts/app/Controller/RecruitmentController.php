<?php
ob_start();
App::import('phpexcel');

/* 
  * Property of Eastern Software Systems Pvt. Ltd.
  * Should be modified on by a Cake PHP Professional
  *  ******************************************************************************
  *  Description of Leaves_controller.php
  *  ******************************************************************************
  *  file (Recruitmentcontroller.php) version: 0.1.0
  *  file description: Cake PHP Controller file for Recruitment  data
  *  file change log:
  *            created by Rishabh Gupta <ayush.pant@essindia.com>
  *            Jan 28, 2017 2:59:31 PM Created controller, and actions add | edit | view | delete.
  *            changed by <user>
  *            <date> <time> <changed-action-name> <change-description> 
  *  
  * ******************************************************************************
  *  project: EssPortal
  * project version: 0.1.0
  *  @author Rishabh Gupta <Rishabh.gupta@essindia.com>
  *  @client company: Eastern Software Systems Pvt. Ltd. Expression project.user is undefined on line 21, column 73 in Templates/Licenses/license-default.txt.
  *  @date created: 2017
  *  @date last modified: Dec 27, 2017 2:59:31 PM
  *  ******************************************************************************
 */


class RecruitmentController extends AppController {

    var $uses = array('LeaveEncashmentWorkflow','AttendanceDetail', 'Leave', 'MstEmpLeave', 'MstLeaveType', 'MstEmpLeaveAllot', 'WfMstStatus', 'LeaveDetail', 'LeaveWorkflow',
        'Holiday', 'WeekHoliday', 'WeekHolidayList', 'MyProfile', 'WfDtAppMapLvl', 'LeaveGrp', 'LeaveEncsh', 'LeaveEncshDt', 
        'SalaryDetail', 'SalaryProcessing', 'SalaryProcessingAddition', 'SalaryProcessingDeduction', 'OptionAttribute', 'OrgHcmLeave1',
        'LeaveConfiguration','RequirementDetail','RequirementWorkflow','Requirementskills','CandidateDetail','Candidateskills',
        'CandidateDocumentsDetail','CandidateShortlist','LabelBlock','LabelPage','InterviewerDetails','ScheduleInterviewDetails',
        'InterviewerRatingDetails','SkillRatingDetails','Competencylvlmaster','ComptencyTypeMaster','InterviewerComptencyRating');
    var $components = array('Session', 'Cookie', 'RequestHandler', 'Auth', 'EmpDetail','Common');
    var $helpers = array('Html', 'Js', 'Form', 'Session', 'Userdetail', 'Leave', 'Common');
    var $paginate = array(
        'limit' => 30,
        'order' => array(
            'RequirementDetail.id' => 'desc'
        )
    );


    public function beforeFilter() {
        parent::beforeFilter();
        $currentUser = $this->checkUser();
        $this->Auth->allow();
        $this->set('status', $this->WfMstStatus->find('list', array('fields' => array('id', 'status_name'))));
        $this->set('appId', 2);
    }
public function download($id) {
  //configure::write('debug',2);
        ignore_user_abort(true);
        set_time_limit(0);
        $parents = $this->CandidateDocumentsDetail->find('first', array('conditions' =>
            array('candidate_id' => base64_decode($id))
                )
        );
                $emp_code=$this->Auth->User('emp_code');
        $file = "uploads/document/" . $parents['CandidateDocumentsDetail']['document_name'];
  
        echo $filePath = WWW_ROOT . $file;

        $dl_file = preg_replace("([^\w\s\d\-_~,;:\[\]\(\).]|[\.]{2,})", '', $fileName); // simple file name validation
        $dl_file = filter_var($dl_file, FILTER_SANITIZE_URL); // Remove (more) invalid characters
        $fullPath = $filePath;

        if ($fd = fopen($fullPath, "r")) {
            $fsize = filesize($fullPath);
            $path_parts = pathinfo($fullPath);
            $ext = strtolower($path_parts["extension"]);
            switch ($ext) {
                
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
    public function download1($id) {
  //configure::write('debug',2);
        ignore_user_abort(true);

     

        set_time_limit(0);
        $parents = $this->RequirementDetail->find('first', array('conditions' =>
            array('req_id' => base64_decode($id))
                )
        );
    
         $auth = $this->Session->read('Auth');
      
$emp_code=$this->Auth->User('emp_code');

          $fileName = $parents['RequirementDetail']['jd_doc'];
  $DirName = "uploads/document/";
        
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
    public function deleteLeaveDetails($req_id) {
        //print_r($req_id);die;
        $req_id = base64_decode($req_id);
        $required_ld = $this->RequirementDetail->find('list', array(
            'conditions' => array(
                'id' => $req_id
            )
        ));
        foreach ($required_ld as $key => $value) {
            $this->RequirementDetail->delete($value);
        }
        $wf = $this->RequirementWorkflow->find('list', array(
            'conditions' => array(
                'id' => $req_id
            )
        ));
        foreach ($wf as $key => $value) {
            $this->RequirementWorkflow->delete($value);
        }
        /*$ml = $this->Requirementskills->find('list', array(
            'conditions' => array(
                'leave_id' => $leave_id
            )
        ));*/
       /* foreach ($ml as $key => $value) {
            $this->MstEmpLeave->delete($value);
        }*/
        $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                            <a href="#" class="uk-alert-close uk-close"></a>Requisition Deleted Sucessfully!</div>');
       
                $this->redirect('/Recruitment/view');
    }
  public function deleteCandidateDetails($id) {
        //Configure::write('debug',2);
    $emp_code=$this->Auth->User('emp_code');
        $id = base64_decode($id);
        $Candidate_ld = $this->CandidateDetail->find('list', array(
            'conditions' => array(
                'id' => $id
            )
        ));
        
        foreach ($Candidate_ld as $key => $value) {
            $this->CandidateDetail->updateAll(array('CandidateDetail.status'=>10,'CandidateDetail.modified_by'=>$emp_code,'CandidateDetail.modified_date'=>date("Y-m-d")),array('CandidateDetail.id'=>$value));
        }
        $wf = $this->CandidateDocumentsDetail->find('list', array(
            'conditions' => array(
                'candidate_id' => $id
            )
        ));
        foreach ($wf as $key => $value) {
            $this->CandidateDocumentsDetail->updateAll(array('CandidateDocumentsDetail.status'=>10),array('CandidateDocumentsDetail.candidate_id'=>$value));
          }
        /*$ml = $this->Requirementskills->find('list', array(
            'conditions' => array(
                'leave_id' => $leave_id
            )
        ));*/
       /* foreach ($ml as $key => $value) {
            $this->MstEmpLeave->delete($value);
        }*/
        $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert="">
                            <a href="#" class="uk-alert-close uk-close"></a>Candidate profile Deactivated Sucessfully!</div>');
       
                $this->redirect('/Recruitment/view_can_list');
    }
    public function view() {
    //Configure::write('debug',2);
      
            $this->layout = 'employee-new';
            $emp_code = $this->Auth->User('emp_code');
           
            $this->paginate = array(
                'fields' => array('RequirementDetail.*'),
                'conditions' => array('RequirementDetail.user_raised' => $emp_code),
              
                'order' => 'RequirementDetail.id DESC'
                
                
            );

            /* * *****************************Requirement List Developed BY Rishabh Gupta ***************************************** */
     

            $data = $this->paginate('RequirementDetail');

                       $this->set('requirelist', $data);
        } 
    

       public function opening()
       {
        
            $this->layout = 'employee-new';
            $emp_code = $this->Auth->User('emp_code');
           
            $this->paginate = array(
                'fields' => array('RequirementDetail.*'),
                'conditions' => array('RequirementDetail.hiring_type' => array('1','2','3'),'RequirementDetail.status'=>5),
               //  'limit' =>$dt,
                'order' => 'RequirementDetail.id desc'
                
                
            );

            /* * *****************************Requirement List Developed BY Rishabh Gupta ***************************************** */
     

            $data = $this->paginate('RequirementDetail');

                       $this->set('requirelist', $data);
        } 

       
        public function view_shortcan_list()
        {
          //print_r($this->data);die;
         // Configure::write('debug',2);
          $this->layout = 'employee-new';
          $can=$this->CandidateDetail->find('all',array('fields' =>array("*"),
            'joins' => array(
                array(
                    'table' => 'candidate_shortlist_details',
                    'alias' => 'CandidateShortlist',
                    'type' => 'inner',
                    'foreignKey' =>'candidate_id',
                    'conditions' => array('CandidateDetail.id = CandidateShortlist.candidate_id')
                )),
          'conditions'=>array('CandidateShortlist.status'=>array(2,5),'CandidateDetail.status!=10'),
          'order'=>'CandidateShortlist.id Desc' ));
  
$this->set('candidateprofile',$can);
 if(!empty($this->data['candidate_shortlist']['can_list']))
           {

                $emp_code = $this->Auth->User('emp_code');
              $can_id=explode(",",$this->data['candidate_shortlist']['can_list']);
        
              

       
             $this->CandidateShortlist->updateAll(
    array('CandidateShortlist.status' =>5),
    array('CandidateShortlist.candidate_id' =>$can_id)
);

         /*   for($i=0;$i<$count;$i++)
            {
          $data['candidate_id']=$can_id[$i];
           $this->CandidateShortlist->create();
          $this->CandidateShortlist->save($data);
            }*/
             $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                            <a href="#" class="uk-alert-close uk-close"></a>Candidate Shortlisting Approved Sucessfully!</div>');
       
               // $this->redirect('/Recruitment/view_shortcan_list');
           

          
        }
        }
       public function shortlisting()
       {
      //Configure::write('debug',2);

        try {
          $this->layout = 'employee-new';
           $this->autoRender = false;
           if(!empty($this->data['candidate_shortlist']['can_list']))
           {

                $emp_code = $this->Auth->User('emp_code');
              $can_id=explode(",",$this->data['candidate_shortlist']['can_list']);
      
              $count=count($can_id);
              $data['emp_code']=$emp_code;
              $data['status']=2;
              $data['created_date']=date("Y-m-d");

            for($i=0;$i<$count;$i++)
            {
        $duplicate_count=$this->CandidateShortlist->find('count',array('fields'=>'id','conditions'=>array('candidate_id'=>$can_id[$i])));
            if($duplicate_count==0)
            {
          $data['candidate_id']=$can_id[$i];
           $this->CandidateShortlist->create();
          $this->CandidateShortlist->save($data);
            }}
             $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                            <a href="#" class="uk-alert-close uk-close"></a>Candidate Shortlisted  Sucessfully!</div>');
       
                $this->redirect('/Recruitment/view_can_list');
           

          
        }
        else{
           $this->redirect('/Recruitment/view_can_list');
        }

      } catch (Exception $e) {
            
        }
      
       }
    
   
   


public function candidateprofile($id)
{
//Configure::write('debug',2);
  $this->layout = 'employee-new';
  $vals = $this->RequirementDetail->find('first',array(
                  'conditions'=>array('id'=>base64_decode($id))));
$this->set('reqdetails',$vals);

if(!empty($this->data))
{
  //Configure::write('debug',2);


 $data['org_id']=$this->Auth->User('comp_code');
 $data['position_name']=$this->data['Position Name'];
$data['cndt_dept_id']=$this->data['dept_name'];  
$data['cndt_desg_id']=$this->data['desg_name'];  
$data['cndt_loc_id']=$this->data['location'];  
$data['cndt_gen']=$this->data['Gender'];  
$data['cndt_perm_add']=$this->data['Permanent Address'];  
$data['cndt_curr_add']=$this->data['current Address'];  
$data['cndt_pan_no']=$this->data['Candidate Adhar'];  
$data['cndt_rel']=$this->data['Religion'];
$data['cndt_current_org']=$this->data['Current orgname'];
$data['cndt_mrtl_stat']=$this->data['Permanent Address'];  
$data['cndt_notice_prd']=$this->data['Candidate NoticePeriod'];  
$data['cndt_exp']=$this->data['Experience'];
$data['cndt_crnt_sal']=$this->data['Candidate CTC'];   
$data['cndt_expect_sal']=$this->data['Expected CTC'];  
$data['cndt_leav_reason']=$this->data['Leave Reason'];  
$data['usr_id_create']=$this->Auth->User('emp_code');
$data['usr_id_create_dt']=date('y-m-d');
$data['cndt_mrtl_stat']=$this->data['marital'];  
$data['cndt_relgion']=$this->data['Religion'];    
$data['cndt_nm']=$this->data['Candidate Name']; 
$data['cndt_type']=$this->data['Candidate Type']; 
$data['cndt_join_date']=date("Y-m-d",strtotime($this->data['Join Date']));  
$data['cndt_email']=$this->data['email']; 
$data['cndt_phone1']=$this->data['mobileno']; 
$data['cndt_nation']=$this->data['Nationality']; 
$data['status']=1;
$data['modified_date']=date("Y-m-d");
$this->CandidateDetail->save($data);

if($this->CandidateDetail->save($data))

{
  $candidate_id=$this->CandidateDetail->find('first',
       array('fields'=>array('CandidateDetail.id'),
  'conditions'=>array('CandidateDetail.usr_id_create'=>$this->Auth->User('emp_code')),
       'order'=>'CandidateDetail.id Desc'));

  if(!empty(count($this->data['Skill List'])))
  {
  for($i=0;$i<count($this->data['Skill List']);$i++)
  {
  $data1['org_id']=$this->Auth->User('comp_code');
  $data1['cndt_code']=$candidate_id['CandidateDetail']['id'];
  $data1['skil_id']=$this->data['Skill List'][$i];
  
    $this->Candidateskills->create();
    $this->Candidateskills->save($data1);
}
}


if(!empty(count($_FILES['data']['name']['file'])))
{
  

    $emp_code=$this->Auth->User('emp_code');
  //print_r($this->data['file'][0]['name']);die;
  for($j=0;$j<count($_FILES['data']['name']['file']);$j++)
  {

 $newfilename = $candidate_id['CandidateDetail']['id'] . date('Ymdhis') . basename($_FILES['data']['name']['file'][$j]);
            $file = "uploads/document/" . $newfilename;
            $filename = $candidate_id['CandidateDetail']['id']. date('Ymdhis') . basename($_FILES['data']['name']['file'][$j]);
            $files = $_FILES['data']['tmp_name']['file'][$j];
            $filePath = WWW_ROOT .$file;
              if (!empty($filename)) {
               
             
                $upload=move_uploaded_file($files, $filePath);
                
            }
            $data2['candidate_id']=$candidate_id['CandidateDetail']['id'];
  $data2['document_name']=  $filename;
  $data2['document_path']=$filePath;
  $data2['created_by']=$this->Auth->User('emp_code');
  $data2['date']=date('y-m-d');
          
  $this->CandidateDocumentsDetail->create();
  $this->CandidateDocumentsDetail->save($data2);
}
}

   $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                            <a href="#" class="uk-alert-c
                            lose uk-close"></a>Candidate Details  Saved Successfully</div>');
                $this->redirect('/Recruitment/view_can_list');
}
else{
   $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                            <a href="#" class="uk-alert-c
                            lose uk-close"></a>Something went worng</div>');
                $this->redirect('/Recruitment/candidateprofile');
}
}
}
 function candidateeditprofile($id=null)
{
  //Configure::write('debug',2);
  $this->layout=false;

  $candidate_details=$this->CandidateDetail->find('all',array('fields' =>array('*'),
  'joins' => array(
                array(
                    'table' => 'candidate_document_details',
                    'alias' => 'CandidateDocuments',
                    'type' => 'inner',
                    'foreignKey' =>'candidate_id',
                    'conditions' => array('CandidateDocuments.candidate_id' =>$id)
                )),
          'conditions'=>array('CandidateDetail.id'=>$id),
           ));

$this->set('CandidatessDetail',$candidate_details);
}
   function skillmaster() {
        //Configure::write('debug',2);

                      $this->layout = ''; 
               $skill =$_GET['term'];

               // $emp_code = $this->Auth->User('emp_code');
            if (!empty($skill)) {
              //$empdetails = $this->MyProfile->find('all');
                $result = $this->OptionAttribute->find('first', array(
                    'fields' => array('OptionAttribute.id','OptionAttribute.name'),
                    'conditions' => array('OptionAttribute.name Like'=>'%'.$skill.'%')
                ));
              }
      
 $this->set('result', $result);
               
               
            

     
    }
   public function scheduleinterview($id)
   {
    $this->layout = 'employee-new'; 
    $candidate_details=$this->CandidateDetail->find('first',array('fields' =>array('*'),
    'conditions'=>array('id' =>base64_decode($id))));
     $page_id = $this->LabelPage->find('first', array(
            'fields' => array('LabelPage.id', 'LabelPage.heading'),
            'conditions' => array('LabelPage.name' => 'ScheduleInterviewDetails')
        ));
     
      $block = $this->LabelBlock->find('all', array(
            'fields' => array('*'),
            'conditions' => array('LabelBlock.label_page_id' => $page_id['LabelPage']['id']),
            'order' => array('LabelBlock.block_priority')
        ));

  $this->set('pageheading', $page_id['LabelPage']['heading']);
        $this->set('block', $block);

      $this->set('candidatedetails',$candidate_details);
   }
      public function saveintinfo()
       {

$this->autoRender = false;
      
        if(!empty($this->data))
        {
         
         
           $auth = $this->Session->read('Auth');
            $emp_code=$auth['MyProfile']['emp_code'];


if(!empty($this->data['rowcounter']))
{
        $counter=$this->data['rowcounter'];
        
     }
     else{
       $counter=1;
     }
        
           
   
    $data1['candidate_id']=$this->data['id'];
    $data1['candidate_no']=$this->data['Candidate No'];
    $data1['req_int_date']=date('Y-m-d',strtotime($this->data['Join Date']));
    $data1['avl_int_date']=date('Y-m-d',strtotime($this->data['Available Date']));
    $data1['created_date']=date('Y-m-d');
  
 $this->ScheduleInterviewDetails->save($data1);
        for($i=1;$i<=$counter;$i++)
        {
        
           $emp_code=$auth['MyProfile']['emp_code'];
           
        $int_code=$this->InterviewerDetails->find('count',array('fields'=>array('InterviewerDetails.candidate_id'),
              'conditions'=>array('InterviewerDetails.candidate_id' => $data1['candidate_id'],'InterviewerDetails.interviewer_code'=>$this->data['interviewer_'.$i])));
        if($int_code==0)
        {
        $data['emp_code']=$emp_code;
         $data['candidate_id']=$this->data['id'];
        $data['interviewer_code']=$this->data['interviewer_'.$i];
         $data['int_type']=$this->data['int_type'.$i];
          $data['int_time']=date("h:i:sa",strtotime($this->data['in_time'.$i]));
           $data['int_date']=date('Y-m-d',strtotime($this->data['interview_date'.$i]));
             $data['status']=1;
            $data['interviewer_level']=$i;
          $data['created_date']=date('Y-m-d');
        
      $this->InterviewerDetails->create();
      $interviewer=$this->InterviewerDetails->save($data);
       }
}

     

      $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert=""><a href="#" class="uk-alert-close uk-close"></a>Interview  Scheduled  successfully!</div>');
       $id=base64_encode($this->data['id']);
      $this->redirect("scheduleinterview/$id");
     }
     }
     public function Scheduledintlist()
{
  //Configure::write('debug',2);
   $this->layout = 'employee-new';
    $auth = $this->Session->read('Auth');
    $emp_code=$auth['MyProfile']['emp_code'];

    $candidate_details=$this->InterviewerDetails->find('all',array('fields' =>array('*'),
          'joins' => array(
                array(
                    'table' => 'sch_interview_details',
                    'alias' => 'scheduleinterview',
                    'type' => 'inner',
                    'foreignKey' =>'candidate_id',
                    'conditions' => array('InterviewerDetails.candidate_id = scheduleinterview.candidate_id')
                )),
          'conditions'=>array('InterviewerDetails.interviewer_code'=>$emp_code),
          'order'=>'InterviewerDetails.id Desc' ));
     $this->set('candidatedetails', $candidate_details);
   $page_id = $this->LabelPage->find('first', array(
            'fields' => array('LabelPage.id', 'LabelPage.heading'),
            'conditions' => array('LabelPage.name' => 'ScheduleInterviewDetails')
        ));
    
      $block = $this->LabelBlock->find('all', array(
            'fields' => array('*'),
            'conditions' => array('LabelBlock.label_page_id' => $page_id['LabelPage']['id']),
            'order' => array('LabelBlock.block_priority')
        ));

 
        $this->set('block', $block);
     
}


 public function interviewrating($id)
{
  //Configure::write('debug',2);
 

   $this->layout = 'employee-new';
    $auth = $this->Session->read('Auth');
    $emp_code=$auth['MyProfile']['emp_code'];
     $candidate_details=$this->CandidateDetail->find('all',array('fields' =>array('*'),
    'conditions'=>array('id' =>base64_decode($id))));
   //print_r($candidate_details[0]['CandidateDetail']['cndt_desg_id']);
    $management_code=$this->Common->getmgtcode($candidate_details[0]['CandidateDetail']['cndt_desg_id']);

    
     $count=$this->InterviewerDetails->find('count',array('fields'=>array('InterviewerDetails.candidate_id'),
              'conditions'=>array('InterviewerDetails.candidate_id' => base64_decode($id))));
            

     $this->set('count',$count);
     $InterviewerDetails=$this->InterviewerDetails->find('all',array('fields'=>array('*'),
              'conditions'=>array('InterviewerDetails.candidate_id' => base64_decode($id))));
         //  print_r($InterviewerDetails);  

     $this->set('InterviewerDetails',$InterviewerDetails);
     $this->set('candidate_details',$candidate_details);

   $page_id = $this->LabelPage->find('first', array(
            'fields' => array('LabelPage.id', 'LabelPage.heading'),
            'conditions' => array('LabelPage.name' => 'INTERVIEW ASSESSMENT SHEET')
        ));
    
      $block = $this->LabelBlock->find('all', array(
            'fields' => array('*'),
            'conditions' => array('LabelBlock.label_page_id' => $page_id['LabelPage']['id']),
            'order' => array('LabelBlock.block_priority asc')
        ));

 $competency_level=$this->Competencylvlmaster->find('first', array(
            'fields' => array('Competencylvlmaster.competency_lvl,Competencylvlmaster.management_code'),
            'conditions' => array('Competencylvlmaster.management_code' =>$management_code),
            'order' => array('Competencylvlmaster.id asc')
        ));
 
        $this->set('competency_lvl', $competency_level);
        $this->set('block', $block);
        $this->set('pageheading', $page_id['LabelPage']['heading']);
     
}
public function interviewerratingDetails()
{
  Configure::write('debug',2);
// print_r($this->data['ComptencyTypeMaster']['Ratings']);die;
  $this->autoRender=false;
  $this->layout='employee-new';
 $auth = $this->Session->read('Auth');
 $emp_code=$auth['MyProfile']['emp_code'];
$data1['candidate_id']=$this->data['id'];
$data1['position_applied']=$this->data['Position Applied'];
$data1['date_of_interview']=date("Y-m-d",strtotime($this->data['Date of Interview']));
$data1['cndt_total_exp']=$this->data['Total Experience'];
$data1['interviewer_code']=$emp_code;
$data1['source_of_cv']=$this->data['Source of CV'];
$data1['qualification_rating']=$this->data['Rating1'];
$data1['relevent_exp_rating']=$this->data['Rating2']; 
$data1['tech_skill_rating']=$this->data['Rating3']; 
$data1['qualification_observation']=$this->data['rating remark1']; 
$data1['relevent_exp_observation']=$this->data['rating remark2']; 
$data1['tech_skill_observation']=$this->data['rating remark3']; 
$data1['cndt_communication_observation']=$this->data['com skills']; 
$data1['cndt_strength']=$this->data['strength'];
$data1['Area_of_improvement']=$this->data['imp area']; 
$data1['recommendation_status']=$this->data['selectvalue'];
$data1['reason_for_recomend']=$this->data['reasonofrecommend'];
$data1['interviewer_sign']=$emp_code;
$data1['current_ctc']=$this->data['CCTC'];
$data1['ctc_offered']=$this->data['ECTC'];
$data1['expected_date_joining']=date("Y-m-d",strtotime($this->data['Expected Date']));
$data1['hr_remarks']=$this->data['final remark'];
$data1['created_date']=date("Y-m-d");
$count=count($this->data['ComptencyTypeMaster']['Ratings']);

for($i=0;$i<$count;$i++)
{

$data['candidate_id']=$this->data['id'];
$data['interviewer_code']=$emp_code;
$data['mgmt_code']=$this->data['managementcode'];
$data['competency_type_id']=$i+1;
$data['competency_rating']=$this->data['ComptencyTypeMaster']['Ratings'][$i];
$data['competency_observation']=$this->data['ComptencyTypeMaster']['observation'][$i];
$data['created_date']=date("Y-m-d");

$this->InterviewerComptencyRating->create();
$this->InterviewerComptencyRating->save($data);
}

             $this->InterviewerDetails->updateAll(
    array('InterviewerDetails.Interviewer_panel_staus' =>2),
    array('InterviewerDetails.candidate_id' =>$this->data['id'],'InterviewerDetails.interviewer_code' =>$emp_code));
if($this->InterviewerRatingDetails->save($data1))
{
//$this->SkillRatingDetails->save($data1);
}
 $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert=""><a href="#" class="uk-alert-close uk-close"></a>Panel Data  successfully Submitted!</div>');
       
      $this->redirect("Scheduledintlist");

}

        public function add() {
//print_r($this->data);
        $this->layout = 'employee-new';
        if(!empty($this->data))
       {
       
 $data2['RequirementDetail']['required_skills']=$this->data['required_skills1'];
  $skills=$data2['RequirementDetail']['required_skills'];
 

  $auth = $this->Session->read('Auth');
        
        $req_id=$this->RequirementDetail->find('first',array(
            'fields'=>'id',
            'order'=>'id desc'));
      
$req_id=$req_id['RequirementDetail']['id'];


        if(empty($req_id))
        {
            $req_id=0;
        }


          $data['RequirementDetail']['req_id']=$req_id+1;
          $data['RequirementDetail']['dept_code']=$this->data['dept_name'];
          $data['RequirementDetail']['desg_code']=$this->data['desg_name'];
          $data['RequirementDetail']['resource_req']=$this->data['nop'];
          $data['RequirementDetail']['user_raised']=$auth['MyProfile']['emp_code'];
          $data['RequirementDetail']['position_name']=$this->data['Position Name'];
           $data['RequirementDetail']['location_name']=$this->data['location'];
         /* $data['RequirementDetail']['hiring_type']=$this->data['RequirementWorkflow']['hiring_type'];*/
            $data['RequirementDetail']['position_type']=$this->data['p_type'];
             $data['RequirementDetail']['replace_emp_name']=$this->data['emp_name'];
                  $data['RequirementDetail']['emp_group']=$this->data['emp_group'];
             $data['RequirementDetail']['max_join_date']=date('y-m-d',strtotime($this->data['Join Date']));
             $data['RequirementDetail']['details']=$this->data['Description'];
            $data['RequirementDetail']['required_exp']=$this->data['required_exp'];
             $data['RequirementDetail']['created_date']=date('y-m-d');
              $data['RequirementDetail']['approver_id']=$this->data['RequirementWorkflow']['manager_Code'];
               $newfilename =$data['RequirementDetail']['req_id'].date("Ymd").basename($_FILES['data']['name']['Jd_file']);
              $data['RequirementDetail']['jd_doc']= $newfilename;
            $file = "uploads/document/" . $newfilename;
              $filename =$data['RequirementDetail']['req_id'].date("Ymd").basename($_FILES['data']['name']['Jd_file']);
            $files = $_FILES['data']['tmp_name']['Jd_file'];
            $file_size =$_FILES['data']['size'];

            $filePath = WWW_ROOT .$file;
   $extension = explode(".", $filename);
   
                    $ext = $extension[1];
                    if (!($ext == 'doc' || $ext == 'pdf')) {

                        $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert=""><a href="#" class="uk-alert-close uk-close"></a>Sorry, this is invalid file, please upload doc or pdf file only !</div>');
                        $this->redirect('add');
                      }

               if ($this->request->data['type']=='park'){
               
               $data['RequirementDetail']['status']=7;

           
               if(!empty($this->RequirementDetail->save($data)))
             { 
            if (!empty($filename)) {
               
             
                $upload=move_uploaded_file($files, $filePath);
                
            }
             if(!empty(count($skills)))
              {    
              
               for($i=0;$i<count($skills);$i++)
               {
               $skills_count=$this->Requirementskills->find('count',
                    array(
                        'fields'=>array('*'),
                    'conditions'=>array('Requirementskills.skills'=>$skills[$i],'Requirementskills.req_id'=>$req_id+1,'Requirementskills.desg_code'=>$this->data['desg_name'])));
     
                if($skills_count==0)
                {

                 $data1['Requirementskills']['req_id']=$req_id+1;
                 $data1['Requirementskills']['desg_code']=$this->data['desg_name'];
                 $data1['Requirementskills']['skills']=$skills[$i];
         
                 $this->Requirementskills->create();
                 $this->Requirementskills->save($data1);
             }
                }
              
                  $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                            <a href="#" class="uk-alert-c
                            lose uk-close"></a>Requisition Parked Successfully</div>');
                $this->redirect('/Recruitment/view');

            }
            
            }
        }

          else if ($this->request->data['type'] == 'post')
         {
             $data['RequirementDetail']['status']=2;
             
        
              if($this->RequirementDetail->save($data))
             { 

              if (!empty($filename)) {
               
             
                $upload=move_uploaded_file($files, $filePath);
                
            }
          $data1['RequirementWorkflow']['req_id']=$req_id+1;
          $data1['RequirementWorkflow']['emp_code']=$auth['MyProfile']['emp_code'];
         $data1['RequirementWorkflow']['fw_date']=date('Y-m-d h:i:s');
         $data1['RequirementWorkflow']['status']=2;
      
         if($this->RequirementWorkflow->save($data1))
             unset($data1);

         {
             if(!empty(count($skills)))
            {
 
               for($i=0;$i<count($skills)-1;$i++)
               {

                $skills_count=$this->Requirementskills->find('count',
                    array(
                        'fields'=>array('*'),
                    'conditions'=>array('Requirementskills.skills'=>$skills[$i],'Requirementskills.req_id'=>$req_id+1,'Requirementskills.desg_code'=>$this->data['desg_name'])));
            
                if($skills_count==0)
                {

                 $data11['Requirementskills']['req_id']=$req_id+1;
                 $data11['Requirementskills']['desg_code']=$this->data['desg_name'];
                 $data11['Requirementskills']['skills']=$skills[$i];
                 $this->Requirementskills->create();
                 $this->Requirementskills->save($data11);
             }
                }
 

            }
     
          $data2['RequirementWorkflow']['req_id']=$req_id+1;
          $data2['RequirementWorkflow']['status']=2;
          $data2['RequirementWorkflow']['emp_code']=$this->data['RequirementWorkflow']['manager_Code'];
         $this->RequirementWorkflow->create();
         $this->RequirementWorkflow->save($data2);
        unset($data2);
         $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                            <a href="#" class="uk-alert-close uk-close"></a>Requisition Forwarded successfully !!!</div>');
         $this->redirect('/Recruitment/view');
              }
             }           
           }
 
    }
    }
    
   
    
    
   

  


   

    function reqdetail() {
        //Configure::write('debug',2);

                      $this->layout = ''; 
               $id = $this->params['pass']['0'];
                $emp_code = $this->Auth->User('emp_code');
            if (!empty($id)) {
                $reqdetails = $this->RequirementDetail->find('first', array(
                    'fields' => array('*'),
                    'conditions' => array('id' => $id, 'user_raised' => $emp_code)
                ));
               
 $this->set('req', $reqdetails);
               
                //$this->render('reqdetail');
            }

     
    }
      function emp_details() {
      //Configure::write('debug',2);

                      $this->layout = ''; 
               $id = $this->params['pass']['0'];

               // $emp_code = $this->Auth->User('emp_code');
            if (!empty($id)) {
              //$empdetails = $this->MyProfile->find('all');
                $empdetails = $this->MyProfile->find('first', array(
                    'fields' => array('MyProfile.emp_name','MyProfile.dept_code','MyProfile.desg_code','MyProfile.emp_grp_id'),
                    'conditions' => array('MyProfile.emp_code' => $id)
                ));
              }
              
 $this->set('EmpDetail', $empdetails);
               
               
            

     
    }
     function pos_details($val) {
      //Configure::write('debug',2);

                      $this->layout = ''; 
                      if($val==1)

              
               // $emp_code = $this->Auth->User('emp_code');
            
              
 $this->set('posDetail', $val);
               
               
            

     
    }
 

 
  

   

   

    function editSubmit($id) {
      //  Configure::write('debug',2);
 $auth = $this->Session->read('Auth');
        $this->layout = 'employee-new';
        $this->paginate = array(
            'fields' => array('*'),
            /*'joins' => array(
                array(
                    'table' => 'req_skills_master',
                    'alias' => 'MstRequirement',
                    'type' => 'inner',
                    'foreignKey' => 'req_id',
                   //'conditions' => array('RequirementDetail.req_id = MstRequirement.req_id')
                )
            ),*/
            'conditions' => array('RequirementDetail.id' => base64_decode($id))
        );

        $reqdetail = $this->paginate('RequirementDetail');

        $this->set('reqdetail', $reqdetail);
        if(!empty($this->data))
        {

$findrejectstatus=$this->RequirementDetail->find('first',array('fields'=>array('*'),'conditions'=>array('id'=>$this->data['id'],'status'=>4)));

if($findrejectstatus['RequirementDetail']['status']==4)
{
   $forward1=$this->RequirementDetail->updateAll(
    array('RequirementDetail.status'=>2,'RequirementDetail.approver_id'=>$this->data['RequirementWorkflow']['manager_Code'],'RequirementDetail.modified_date'=>date('Y-m-d'),'RequirementDetail.hr_approval_status'=>null,'RequirementDetail.hr_code'=>null), array('RequirementDetail.status' =>4,'RequirementDetail.req_id' => $this->data['req_id'],'RequirementDetail.id'=>$this->data['id'])    
);
}

 $data['RequirementDetail']['skills']=$this->data['required_skills'];

 
$skills= $data['RequirementDetail']['skills'];


                 $data1['RequirementDetail']['id']=$this->data['id'];
             $data1['RequirementDetail']['req_id']=$this->data['reqid'];
          $data1['RequirementDetail']['dept_code']=$this->data['dept_name'];
          $data1['RequirementDetail']['desg_code']=$this->data['desg_name'];
          $data1['RequirementDetail']['resource_req']=$this->data['nop'];
          $data1['RequirementDetail']['user_raised']=$auth['MyProfile']['emp_code'];
          $data1['RequirementDetail']['position_name']=$this->data['Position Name'];
           $data1['RequirementDetail']['location_name']=$this->data['location'];
          $data1['RequirementDetail']['max_join_date']=date('y-m-d',strtotime($this->data['Join Date']));
          $data1['RequirementDetail']['details']=$this->data['Description'];
          $data1['RequirementDetail']['required_exp']=$this->data['required_exp'];
           $data1['RequirementDetail']['hiring_type']=$this->data['RequirementDetail']['hiring_type'];
          $data1['RequirementDetail']['created_date']=date('y-m-d');

       if(empty($_FILES['data']['name']['Jd_file']))
       {

 $jdfile=$this->RequirementDetail->find('first',
    array('fields'=>array('*'),'conditions'=>array('req_id'=>$this->data['reqid']))); 

           $data1['RequirementDetail']['jd_doc']=$jdfile['RequirementDetail']['jd_doc'];
       }
       else{
        
        
       
                $newfilename = $data1['RequirementDetail']['req_id'] . date('Ymd') . basename($_FILES['data']['name']['Jd_file']);
                $data1['RequirementDetail']['jd_doc']=$newfilename ;
              }
            $file = "uploads/document/" . $newfilename;
            $filename = $data1['RequirementDetail']['req_id']. date('Ymd') . basename($_FILES['data']['name']['Jd_file']);

            $files = $_FILES['data']['tmp_name']['Jd_file'];
            $filePath = WWW_ROOT .$file;
            if(!empty($files))
            {
   $extension = explode(".", $filename);
   
                    $ext = $extension[1];
                    if (!($ext == 'doc' || $ext == 'pdf')) {
  $editid=base64_encode($this->data['id']);
                        $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert=""><a href="#" class="uk-alert-close uk-close"></a>Sorry, this is invalid file, please upload doc or pdf file only !</div>');
                        $this->redirect("editSubmit/$editid");
                      }
                    }
      if ($this->request->data['type']=='post'){
        //Configure::write('debug',2);
               $data1['RequirementDetail']['status']=2;
       
               if($this->RequirementDetail->save($data1))
{
  if (!empty($filename)) {
               
             
                $upload=move_uploaded_file($files, $filePath);
                
            }
    unset($data1);
$reject_code=$this->RequirementWorkflow->find('first',array('fields'=>array('*'),'conditions'=>array('req_id'=>$this->data['reqid'],'status'=>4)));
print_r($reject_code);
if($reject_code['RequirementWorkflow']['status']==4)
{

$this->RequirementWorkflow->updateAll(array('RequirementWorkflow.status'=>2),
array('RequirementWorkflow.emp_code'=>$reject_code['RequirementWorkflow']['emp_code'],'RequirementWorkflow.req_id'=>$reject_code['RequirementWorkflow']['req_id']));
}
else{
//print_r($this->data['reqid']);die;
$data11['RequirementWorkflow']['req_id']=$this->data['reqid'];
          $data11['RequirementWorkflow']['emp_code']=$auth['MyProfile']['emp_code'];
         $data11['RequirementWorkflow']['fw_date']=date('Y-m-d h:i:s');
             $data2['RequirementWorkflow']['status']=2;
      
         $this->RequirementWorkflow->save($data11);
             unset($data11);


 $data2['RequirementWorkflow']['req_id']=$this->data['reqid'];
          $data2['RequirementWorkflow']['status']=2;
          $data2['RequirementWorkflow']['emp_code']=$this->data['RequirementWorkflow']['manager_Code'];
         $this->RequirementWorkflow->create();
         $this->RequirementWorkflow->save($data2);
        unset($data2);


}

if(!empty(count($skills)))
              {    
               for($i=0;$i<count($skills)-1;$i++)
               {
               $skills_count=$this->Requirementskills->find('count',
                    array(
                        'fields'=>array('*'),
                    'conditions'=>array('Requirementskills.skills'=>$skills[$i])));
               //print_r($skills_count);die;
                if($skills_count==0)
                {

                 $data1['Requirementskills']['req_id']=$this->data['reqid'];
                 $data1['Requirementskills']['desg_code']=$this->data['desg_name'];
                 $data1['Requirementskills']['skills']=$skills[$i];
                
                 $this->Requirementskills->create();
                 $this->Requirementskills->save($data1);
             }
                }

              
                  $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                            <a href="#" class="uk-alert-c
                            lose uk-close"></a>Requisition Forwarded Successfully</div>');
                $this->redirect('/Recruitment/view');

            }

}

        }
}
        
    }




    function workflow_display($record_id = null , $emp_code = null, $leave_id = null, $el_id = null) {
        $this->layout = 'employee-new';
        $this->set('emp_code', $emp_code);
        $this->set('leave', $record_id);
        $this->set('leave_code', $el_id);
        $this->set('leave_id', $leave_id);
    }


    function saveinfomation($record_id = NULL , $emp_code = NULL) {
        if (!empty($this->request->data)) {
            $org_id = $_SESSION['Auth']['MyProfile']['comp_code'];
            $leave_id = $this->request->data['LeaveWorkflow']['emp_leave_id'];
            $leave_code = $this->request->data['LeaveWorkflow']['leave_code'];
            $save = array();
            $save['leave_id'] = $this->request->data['LeaveWorkflow']['leave_id'];
            $save['emp_code'] = $this->Auth->User('emp_code');
            $user_details = $this->EmpDetail->getemployeeinfomation($this->Auth->User('emp_code'));
            $save['fw_date'] = date('Y-m-d h:i:s');
            if ($this->LeaveWorkflow->save($save)) {
                unset($save);
                $save1 = array();
                $save1['leave_id'] = $this->request->data['LeaveWorkflow']['leave_id'];
                $save1['emp_code'] = $this->request->data['LeaveWorkflow']['emp_code'];
                $this->LeaveWorkflow->create();
                if ($this->LeaveWorkflow->save($save1)) {
                    unset($save1);
                    $this->LeaveDetail->updateAll(
                            array('LeaveDetail.leave_status' => '2'), array('LeaveDetail.leave_id' => $this->request->data['LeaveWorkflow']['leave_id'])
                    );
                    $leave_id_check = $this->request->data['LeaveWorkflow']['leave_id'];
                    if($leave_id != '' && $leave_code != ''){
                    $updateleave = $this->LeaveDetail->updateAll(
                                array('LeaveDetail.leave_code' => "'$leave_code'"), array('LeaveDetail.leave_id' => $leave_id)
                        );
                    $leave_id_check = $leave_id;
                        
                    }
                    $leave_data = $this->Common->getLeaveDetail($leave_id_check);
                    $From = $this->Common->getSuportEmailId('01');
                    $data['name'] = 'Sir/Ma`am';
                    $leaveer_name = $this->Common->getEmpDetails($leave_data['MstEmpLeave']['emp_code']);
                    $email_id_send = $this->Common->getEmpEmailId($leave_data['MstEmpLeave']['emp_code']);
                    $mgr_code = $this->Common->getManagerCode($leave_data['MstEmpLeave']['emp_code']);
                    $email_id_mgr = $this->Common->getEmpEmailId($mgr_code);
                    $data['logo'] = 'logo_email.png';
                    $this->send_mail($From, $email_id_mgr, $email_id_send, 'Leave Applied by - ' . $leaveer_name['MyProfile']['emp_full_name'], 'Leave dated ' . $leave_data['MstEmpLeave']['start_date'] . ' to ' .$leave_data['MstEmpLeave']['end_date']. ' is applied by '.$leaveer_name['MyProfile']['emp_full_name']. ' , Please review the same.', 'default', $data);
           
                    $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                            <a href="#" class="uk-alert-close uk-close"></a>Leave forwarded Successfully</div>');
                    if($leave_data['MstEmpLeave']['by_hr'] == 1){
                        $this->redirect(array('controller' => 'leaves', 'action' => 'view')); } else {
                        $this->redirect(array('controller' => 'leaves', 'action' => 'view_by_hr')); }
                } else {
                    $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                            <a href="#" class="uk-alert-close uk-close"></a>Leave is not forward.</div>');
                    $this->redirect(array('controller' => 'leaves', 'action' => 'view'));
                }
            }
        }
        $this->redirect(array('controller' => 'leaves', 'action' => 'view'));
    }
    


    function approval() {
    // Configure::write('debug',2);
        $this->layout = 'employee-new';
        $org_id = $this->Auth->User('comp_code');
        $emp_code = $this->Auth->User('emp_code');
        if (empty($emp_code)) {
            $this->redirect('view');
        }
        if (!$this->Common->check_access_right($this->Auth->User('emp_code'), $this->Auth->User('comp_code'), 'Recruitment_Module', 'approval')) {
            $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                            <a href="#" class="uk-alert-close uk-close"></a>You Do not have approval Rights</div>');

            $this->redirect('view');
        }
       
        $designation_code = $_SESSION['Auth']['MyProfile']['desg_code'];
        $dept_code = $_SESSION['Auth']['MyProfile']['dept_code'];
       $emp_code = $this->Auth->User('emp_code');
           
            $this->paginate = array(
                'fields' => array('RequirementDetail.*'),
                'joins' => array(
                array(
                    'table' => 'requirement_workflow',
                    'alias' => 'rw',
                    'type' => 'inner',
                    'foreignKey' => false,
                    'conditions' => array('rw.req_id = RequirementDetail.req_id','rw.emp_code' =>$this->Auth->User('emp_code'))
                ),
            ),
                /* 'limit' =>$dt,*/
                'order' => 'RequirementDetail.id DESC'
                
                
            );


        $pending_Requisition = $this->paginate('RequirementDetail');

        $this->set('pending_Requisition', $pending_Requisition);
    }

public function forward_req($id) 
{
   
  $auth = $this->Session->read('Auth');
        $this->layout = 'employee-new';
        $this->paginate = array(
            'fields' => array('*'),
           
            'conditions' => array('RequirementDetail.id' => base64_decode($id))
        );

        $reqdetail = $this->paginate('RequirementDetail');


        $this->set('reqdetail', $reqdetail);
       
        
    }

   
     public function rejectId($id) {
        $this->layout = false;
        $this->set('rejectid', $id);
    }
    public function hr_approve_Requisition() {

  //Configure::write('debug',2);

$auth = $this->Session->read('Auth');
 $this->layout = 'employee-new';

    $this->autoRender = false;


if(!empty($this->data))
        {


if($this->data['type']==Reject)
{
  $auth = $this->Session->read('Auth');

        $this->autoRender = false;
        $data['id'] = $this->data['id'];
        $data['status'] = 4;
        if($this->data['position_type']==1)
        {
         $data['hr_approval_status'] = 9;
        }

        $data['reject_remark'] = $this->data['RequirementDetail']['remark'];
         $data1['req_id']= $this->data['reqid'];
          $emp_code=$auth['MyProfile']['emp_code'];
          $date=date('Y-m-d');
          $date =date('Y-m-d',strtotime($date));
          $data1['fw_date']="'$date'";
           $data1['status']= 4;
          $avl =$this->data['RequirementDetail']['remark'];
          $data1['remark']= "'$avl'";


      $forward1=$this->RequirementWorkflow->find('all',
    array('fields'=>array('*'),'conditions'=>array('RequirementWorkflow.status!=2','RequirementWorkflow.req_id' => $data1['req_id']))    
);
      foreach ($forward1 as $value) {

         $this->RequirementWorkflow->delete($value['RequirementWorkflow']['id']);
    
      }
    
      
     
    

        $this->RequirementDetail->save($data);
        $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert="">
                            <a href="#" class="uk-alert-close uk-close"></a>Requisition rejected! </div>');

        $this->redirect('approval');
}

if($this->data['type']==final_App)
{
//Configure::write('debug',2);
  $auth = $this->Session->read('Auth');
  $atten_id=$this->data['id'];
         $det = $this->EmpDetail->getemployeeinfomation($this->Auth->User('emp_code'));
        $this->autoRender = false;
        $data['RequirementDetail']['id'] = $atten_id;
        $data['RequirementDetail']['status'] = 5;
$data['RequirementDetail']['hr_approval_status'] = 5;
$data['RequirementDetail']['skills']=$this->data['required_skills'];

$skills= $data['RequirementDetail']['skills'];
$data['RequirementDetail']['req_id']=$this->data['reqid'];
$data['RequirementDetail']['dept_code']=$this->data['dept_name'];
$data['RequirementDetail']['desg_code']=$this->data['desg_name'];
$data['RequirementDetail']['resource_req']=$this->data['nop'];
//$data['RequirementDetail']['user_raised']=$auth['MyProfile']['emp_code'];
$data['RequirementDetail']['position_name']=$this->data['Position Name'];
$data['RequirementDetail']['location_name']=$this->data['location'];
$data['RequirementDetail']['max_join_date']=date('y-m-d',strtotime($this->data['Join Date']));
$data['RequirementDetail']['details']=$this->data['Description'];
$data['RequirementDetail']['required_exp']=$this->data['required_exp'];
$data['RequirementDetail']['hiring_type']=$this->data['RequirementDetail']['hiring_type'];
$data['RequirementDetail']['created_date']=date('y-m-d');
        /* $data1['req_id'] =$data['id'];
        $data1['status'] = 5;*/


        $this->RequirementDetail->save($data);
     $data1['req_id']=$atten_id;
      $emp_code=$auth['MyProfile']['emp_code'];
       $date=date('Y-m-d');
      $date =date('Y-m-d',strtotime($date));
   $data1['fw_date']="'$date'";
   $data1['status']=5;
   //$avl =$this->data['RequirementDetail']['remark'];
   $data1['remark']= "'Approved'";
     $data1['emp_code']=$this->data['RequirementDetail']['hr_emp_code']; 
   $forward1=$this->RequirementWorkflow->updateAll(
    array('RequirementWorkflow.status'=>$data1['status'],'RequirementWorkflow.remark'=>$data1['remark'],'RequirementWorkflow.fw_date'=> $data1['fw_date']), array('RequirementWorkflow.emp_code' =>$emp_code,'RequirementWorkflow.req_id' => $data1['req_id'])    
);
       /* $this->RequirementWorkflow->save($data1);*/
        
        $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                            <a href="#" class="uk-alert-close uk-close"></a>Requisition approved successfully !!!</div>');

        $this->redirect('approval');
}

 $data['RequirementDetail']['skills']=$this->data['required_skills'];


$skills=$data['RequirementDetail']['skills'];


          $data['RequirementDetail']['id']=$this->data['id'];
          $data['RequirementDetail']['req_id']=$this->data['reqid'];
          $data['RequirementDetail']['dept_code']=$this->data['dept_name'];
          $data['RequirementDetail']['desg_code']=$this->data['desg_name'];
          $data['RequirementDetail']['resource_req']=$this->data['nop'];
          $data['RequirementDetail']['emp_group']=$this->data['emp_group'];
          $data['RequirementDetail']['position_name']=$this->data['Position Name'];
           $data['RequirementDetail']['location_name']=$this->data['location'];
          $data['RequirementDetail']['max_join_date']=date('y-m-d',strtotime($this->data['Join Date']));
          $data['RequirementDetail']['details']=$this->data['Description'];
          $data['RequirementDetail']['required_exp']=$this->data['required_exp'];
          $data['RequirementDetail']['created_date']=date('y-m-d');
          $data['RequirementDetail']['hr_code'] = $this->data['RequirementDetail']['hr_emp_code']; 
          $data['RequirementDetail']['approver_id'] = $this->data['RequirementDetail']['hr_emp_code']; 
              $emp_code=$auth['MyProfile']['emp_code'];
$status=$this->RequirementWorkflow->find('first',array('fields'=>array('RequirementWorkflow.status'),'conditions'=>array('RequirementWorkflow.emp_code'=>$emp_code,'RequirementWorkflow.req_id'=>$data['RequirementDetail']['req_id'])));

if($this->data['position_type']==1&&$status['RequirementWorkflow']['status']==2)
{
    
          $data['RequirementDetail']['status'] =9;
}
else{
    $data['RequirementDetail']['status'] =6;
}

          $data['RequirementDetail']['hr_approval_status'] =6;   
        
          $data['RequirementDetail']['modified_date'] =date('y-m-d');
           $data['RequirementDetail']['modified_by'] = $this->data['RequirementDetail']['hr_emp_code']; 
         $forward=$this->RequirementDetail->save($data);
       if(!empty(count($skills)))
              {    
           
               for($i=0;$i<count($skills)-1;$i++)
               {
              
               $skills_count=$this->Requirementskills->find('count',
                    array(
                        'fields'=>array('*'),
                    'conditions'=>array('Requirementskills.skills'=>$skills[$i],'Requirementskills.req_id'=>$this->data['reqid'],'Requirementskills.desg_code'=>$this->data['desg_name'])));
               
                if($skills_count==0)
                {

                 $data1['Requirementskills']['req_id']=$this->data['reqid'];
                 $data1['Requirementskills']['desg_code']=$this->data['desg_name'];
                 $data1['Requirementskills']['skills']=$skills[$i];
                
                 $this->Requirementskills->create();
                 $this->Requirementskills->save($data1);
                   
             }
                }

              
               

            }

       
  $data12['req_id']=$this->data['id'];
  $emp_code=$auth['MyProfile']['emp_code'];
   $date=date('Y-m-d');
   $date =date('Y-m-d',strtotime($date));
   $data12['fw_date']="'$date'";
   

   if($this->data['position_type']==1&&$status['RequirementWorkflow']['status']==2)
{
    
         $data12['status']=9;
}
else{
        $data12['status']=2;
}
   
   $avl =$this->data['RequirementDetail']['remark'];
   $data12['remark']= "'$avl'";
     $data12['emp_code']=$this->data['RequirementDetail']['hr_emp_code']; 
   $forward1=$this->RequirementWorkflow->updateAll(
    array('RequirementWorkflow.status'=>$data1['status'],'RequirementWorkflow.remark'=>$data12['remark'],'RequirementWorkflow.fw_date'=> $data12['fw_date']), array('RequirementWorkflow.emp_code' =>$emp_code,'RequirementWorkflow.req_id' => $data12['req_id'])    
);
  
   if(!empty($data['RequirementDetail']['hr_code']))
{
    
   $data111['req_id']=$this->data['id'];
    $emp_code=$auth['MyProfile']['emp_code'];
   
  if($this->data['position_type']==1&&$status['RequirementWorkflow']['status']==2)
{
    
         $data111['status']=9;
}
else{
       $data111['status']=3;
}

    $data111['emp_code']=$this->data['RequirementDetail']['hr_emp_code'];

   $forward11=$this->RequirementWorkflow->save($data111);

 }
 
   
        if(!empty($forward))
{
 
 $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                            <a href="#" class="uk-alert-close uk-close"></a>Requisition  forward successfully !!!</div>');

       $this->redirect('approval');
       }
 
}

    }


    

   

    

      public function view_can_list() {
      //Configure::write('debug',2);
      $comp_code = $_SESSION['Auth']['MyProfile']['comp_code'];
        $this->layout = 'employee-new';
        $candidateprofile=$this->CandidateDetail->find('all',array('fields'=>array('*'),
          'conditions'=>array('org_id'=>$comp_code),
          'order'=>'id desc'));

        $this->set('candidateprofile',$candidateprofile);
        
    }
   public function select_consultant($id)

{
  $this->layout = 'employee-new';
  
  if(!(empty($this->data['type']==post)))
  {

  $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                            <a href="#" class="uk-alert-close uk-close"></a>Mail sent successfully !!!</div>');

       $this->redirect('approval');

}
if($this->data['type']==park )
  {
 


       $this->redirect('approval');

}


}

}
   