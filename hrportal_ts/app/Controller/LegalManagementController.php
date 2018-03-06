<?php
App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');
App::uses('Folder', 'Utility');
App::uses('File', 'Utility');


class LegalManagementController extends AppController {

    public $name = 'LegalManagement';
    public $uses = array('CaseType','MyProfile','DocumentRequest','CaseDetails','CaseFiles','CaseCourtLocation','Category','CourtType','CaseStatus','CaseOutcome','CaseReceive','Ministry','MstRequest');
    public $helpers = array('Js', 'Html', 'Form', 'Session', 'Userdetail', 'Common');
    public $components = array('Auth', 'Session', 'Email', 'Cookie', 'EmpDetail', 'Common', 'RequestHandler','Paginator');


    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow();
        $currentUser = $this->checkUser();
    }
    
    public function index() {
        //Configure::write('debug',2);
        $this->layout = 'employee-new';
        $auth = $this->Session->read('Auth');
        
        $CaseReceive = $this->CaseReceive->find('all',array('conditions' => array('CaseReceive.status' =>'1'),'order' =>array('CaseReceive.id DESC')));
        $notiFlage="No";
        foreach($CaseReceive as $rec){
            if(!empty($rec['CaseDetails'])){
                
                $Notify=end($rec['CaseDetails']);
                
                if($Notify['next_hearing_date']!=''){
                    
                    $Next_h =$Notify['next_hearing_date'];
                    //$notifyID=$Notify['CaseDetails']['notification'];
                    //echo "<br>";
                    $date=date_create($Next_h);
                    date_sub($date,date_interval_create_from_date_string("1 days"));

                    $curDate=date("Y-m-d");
                    $AlertDATE = date_format($date,"Y-m-d");
                    if($AlertDATE == $curDate){
                        $AllCases .=$rec['CaseReceive']['court_case_number'].", ";
                       $notiFlage="Yes";
                    }
                    $this->set(compact('notiFlage','AllCases','Next_h'));
                    }
            }
        }
        
        $this->set(compact('CaseReceive'));
    }
    
    public function case_details($caseID=null) {
       // Configure::write('debug',2);
        $this->layout = 'employee-new';
        $auth = $this->Session->read('Auth');
        $caseID = base64_decode($caseID);
        //echo date("d-m-Y His");die;
        //$this->CaseReceive->recursive = -2;
        $CaseReceive = $this->CaseReceive->find('first',array('conditions' => array('CaseReceive.id' =>$caseID)));
        $CaseDetails = $this->CaseDetails->find('all',array('conditions' => array('CaseDetails.case_receive_id' =>$caseID)));
        
        $this->paginate = array(
            'conditions' => array('CaseDetails.case_receive_id' => $caseID,'CaseDetails.status'=>'1'),
            'limit' => 10,
            'order' => array(
                'CaseDetails.id' => 'desc'
            )
        );
        
        $this->set('ar', $this->paginate($this->CaseDetails));
        $this->set(compact('CaseReceive','CaseDetails'));
    }
    
    public function case_report() {
       //Configure::write('debug',2);
        $this->layout = 'employee-new';
        $auth = $this->Session->read('Auth');
        
        $flag='';
        if(isset($this->request->data['submit']) && $this->request->data['submit']!=''){
            //echo "<pre>";
            //print_r($this->request->data);
            if($this->request->data['date_of_service']=='' && $this->request->data['from_date']=='' && $this->request->data['end_date']=='' && $this->request->data['case_num']=='' && $this->request->data['case_status']=='' && $this->request->data['case_outcome']==''){
                 $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert="">
                            <a href="#" class="uk-alert-close uk-close"></a>Please Enter Atleast One Value !!!!</div>');   
                $this->redirect('case_report');
            }

            if($this->request->data['date_of_service']!=''){
                $ORconditions['date_of_service']   = date('Y-m-d', strtotime($this->request->data['date_of_service']));
                $date_of_service = $this->request->data['date_of_service'];
            }
            
            if($this->request->data['from_date']!='' && $this->request->data['end_date']!=''){
                $bringup_from_date = $this->request->data['from_date'];
                $bringup_end_date  =  $this->request->data['end_date'];
               //$ORconditions['bringup_date <'] = date('Y-m-d', strtotime($this->request->data['end_date']));
               $ORconditions['bringup_date between ? and ?'] = array($bringup_from_date, $bringup_end_date);
            }
            if($this->request->data['case_num']!=''){
                $ORconditions['CaseDetails.case_receive_id']   = $this->request->data['case_num'];
                $case_num = $this->request->data['case_num'];
            }
            if($this->request->data['case_outcome']!=''){
                $ORconditions['case_outcome_id']   = $this->request->data['case_outcome'];
                $case_outcome = $this->request->data['case_outcome'];
            }
            if($this->request->data['case_status']!=''){
                $ORconditions['case_status_id']   = $this->request->data['case_status'];
                $case_status = $this->request->data['case_status'];
            }
            
            $conditions = array('CaseReceive.status !=' =>'0',
                'OR'=>$ORconditions
                );
            
            $CaseDetails = $this->CaseDetails->find('all',array('conditions' => $conditions));
            
            
            foreach($CaseDetails as $rec){
                $CR[]= $rec['CaseReceive']['id'];
            }
            $Case_id=  implode(",", $CR);
            if($Case_id == ''){
                $Case_id = '0';
            }
            $Case_Receives = $this->CaseReceive->find('all',array('conditions' => array('CaseReceive.status !=' =>'0','CaseReceive.id IN ('.$Case_id.')')));
//            echo "<pre>";
//            print_r($CaseReceives);
//            echo "<pre>";
//            print_r($CaseDetails);die;
            if($Case_Receives){
                $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                            <a href="#" class="uk-alert-close uk-close"></a>Report Generated Successfully !!!!</div>');   
                //$this->redirect('case_report'); 
            }else{
                $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert="">
                            <a href="#" class="uk-alert-close uk-close"></a>Sorry, there is no record found !!!!</div>');
            }
            
            
            $flag='open';
            $this->set(compact('Case_Receives','flag','date_of_service','bringup_from_date','bringup_end_date','case_num','case_outcome','case_status'));
        }
        
        
        
        $this->CaseReceive->recursive = -1;
        $CaseReceives = $this->CaseReceive->find('list',array(
            'fields'=>array('id','court_case_number'),
            'conditions' => array('CaseReceive.status !=' =>'0')));
        $CaseType = $this->CaseType->find('list',array('fields'=>'casetype'),array('conditions' => array('status' =>'0')));
        $CaseOutcomes    = $this->CaseOutcome->find('list',array('fields'=>'case_outcome'),array('conditions'=>array('status'=>'0')));
        $Case_Status    = $this->CaseStatus->find('list',array('fields'=>'case_status'),array('conditions'=>array('status'=>'0')));
      
        $a1=array('--Select--');
        $a2=$CaseReceives;
        $CaseReceive=array_merge($a1,$a2);
      
        $b1=array('--Select--');
        $b2=$CaseOutcomes;
        $CaseOutcome=array_merge($b1,$b2);
        
        $c1=array('--Select--');
        $c2=$Case_Status;
        $CaseStatus=array_merge($c1,$c2);

        $this->set(compact('CaseReceives','CaseOutcome','CaseStatus'));
    }
    
    public function generate_allcase_report_pdf($date_of_service=null,$bringup_from_date=null,$bringup_end_date=null,$case_num=null,$case_outcome=null,$case_status=null) {
        //Configure::write('debug',2);
        $this->layout = 'employee-new';
        $auth = $this->Session->read('Auth');
        
        if($date_of_service!=''){
                $ORconditions['date_of_service']   = $date_of_service;
            }
            
            if($bringup_from_date !='' && $bringup_end_date!=''){
               $ORconditions['bringup_date between ? and ?'] = array($bringup_from_date, $bringup_end_date);
            }
            if($case_num !=''){
                $ORconditions['case_receive_id']   = $case_num;
            }
            if($case_outcome !=''){
                $ORconditions['case_outcome_id']   = $case_outcome;
            }
            if($case_status !=''){
                $ORconditions['case_status_id']   = $case_status;
            }
            
            $conditions = array('CaseReceive.status' =>'1',
                'OR'=>$ORconditions
                );
            
            $CaseDetails = $this->CaseDetails->find('all',array('conditions' => $conditions));
            
            
            foreach($CaseDetails as $rec){
                $CR[]= $rec['CaseReceive']['id'];
            }
            $Case_id=  implode(",", $CR);
            if($Case_id == ''){
                $Case_id = '0';
            }
            $CaseReceives = $this->CaseReceive->find('all',array('conditions' => array('CaseReceive.status' =>'1','CaseReceive.id IN ('.$Case_id.')')));
        
//        echo "<pre>";
//        print_r($CaseDetails);die;
        
        
       // $CaseReceives = $this->CaseReceive->find('all',array('conditions' => array('CaseReceive.status' =>'1','CaseReceive.id' =>$caseID)));
                
        App::import('Vendor', 'TCpdf', array('file' => 'mpdf60/mpdf.php'));
        $this->layout = 'pdf';
        $this->set('pdf', new mPDF('utf-8', array(350,500)));
        $this->set('CaseReceives', $CaseReceives);
        
        
        
    }
    
    public function generate_case_report_pdf($caseID) {
        //Configure::write('debug',2);
        $this->layout = 'employee-new';
        $auth = $this->Session->read('Auth');
        $CaseReceives = $this->CaseReceive->find('all',array('conditions' => array('CaseReceive.status' =>'1','CaseReceive.id' =>$caseID)));
        //foreach($CaseReceives as $CRs);    
//        echo $CRs['CaseDetails']['id']; 
//        end($CRs['CaseDetails']);
//        $caseStatus=end($CRs['CaseDetails']);
//        echo $caseStatus['case_status_id'];
//            echo "<pre>";
//            print_r(end($CRs['CaseDetails'])); die;
//            [CaseReceive] => Array
//                (
//                    [id] => 1
//                    [ministry_id] => 1
//                    [request_id] => 2
//                    [action_officer_id] => 613
//                    [respondents] => sdfdasf
//                    [petitioners] => asdfds
//                    [court_case_number] => CN-123456
//                    [psc_file_number] => PSC/1234
//                    [subject] => asdfadsf
//                    [date_of_service] => 2016-10-01
//                    [status] => 1
//                    [created_by] => 183
//                    [created_on] => 2016-10-06 15:14:11
//                    [solc_id] => 
//                    [cld_id] => 
//                    [ho_org_id] => 
//                    [org_id] => 
//                    [emp_doc_id] => 
//                    [doc_id] => 
//                );
        
        App::import('Vendor', 'TCpdf', array('file' => 'mpdf60/mpdf.php'));
        $this->layout = 'pdf';
        $this->set('pdf', new mPDF('utf-8', array(350,500)));
        $this->set('CaseReceives', $CaseReceives);
        
        
        
    }
    
    
    public function case_details_save($caseID=null) {
        //Configure::write('debug',2);
        $this->layout = 'employee-new';
        $auth = $this->Session->read('Auth');
        $caseID = base64_decode($caseID);
        
        if(isset($this->request->data['submit']) && $this->request->data['submit']!=''){
                
            $UPLOAD_FILES=$this->request->data['upl_doc'];
            if($this->request->data['mention_date']!=''){
                $Mention_Date = date("Y-m-d", strtotime($this->request->data['mention_date']));
            }else{
                $Mention_Date = '';
            }
            if($this->request->data['next_h_date']!=''){
                $Next_H_Date=date("Y-m-d", strtotime($this->request->data['next_h_date']));
            }else{
                $Next_H_Date = '';
            }
            if($this->request->data['decision_date']!=''){
                $Decision_Date=date("Y-m-d", strtotime($this->request->data['decision_date']));
            }else{
                $Decision_Date='';
            }
            if(trim($this->request->data['case_outcome']) !=""){
                $case_outcome=$this->request->data['case_outcome'];
            }else{
                $case_outcome= NULL;
            }
            
//            echo "<pre>";
//            print_r($this->request->data);die;
            
            $data['CaseDetails']['case_type_id']        =   $this->request->data['case_type'];
            $data['CaseDetails']['court_type_id']       =   $this->request->data['court_type'];
            $data['CaseDetails']['court_location_id']   =   $this->request->data['court_location'] ;
            $data['CaseDetails']['case_status_id']      =   $this->request->data['case_status'];
            $data['CaseDetails']['case_outcome_id']     =   $case_outcome;
            $data['CaseDetails']['case_receive_id']     =   $this->request->data['caseid'];
            $data['CaseDetails']['subject']             =   $this->request->data['subject'];
            $data['CaseDetails']['case_particulars']    =   $this->request->data['case_particular'] ;
            $data['CaseDetails']['case_petitioners']    =   $this->request->data['petitioner'] ;
            $data['CaseDetails']['case_respondents']    =   $this->request->data['respondent'] ;
            $data['CaseDetails']['case_witness']        =   $this->request->data['witness'] ;
            $data['CaseDetails']['bringup_date']        =   date("Y-m-d", strtotime($this->request->data['bring_date']));
            $data['CaseDetails']['mention_date']        =   $Mention_Date;
            $data['CaseDetails']['next_hearing_date']   =   $Next_H_Date;
            $data['CaseDetails']['case_status_details'] =   $this->request->data['status_details'];
            $data['CaseDetails']['case_outcome_details']=   $this->request->data['outcome_details'];
            $data['CaseDetails']['remark']              =   $this->request->data['remark'] ;
            $data['CaseDetails']['decision_date']       =   $Decision_Date;
            $data['CaseDetails']['created_by']          =   $auth['MyProfile']['id'];
           
            $success = $this->CaseDetails->save($data);
            $CaseDetailsID = $this->CaseDetails->getLastInsertID();
            
            $invl='0';
            if($success){
                if(!empty($UPLOAD_FILES) && $this->request->data['upl_doc'][0]['name']!=''){
                    $DirName = $this->request->data['case_num'];
                    $Dir = WWW_ROOT .'legal';
                    $Path = new Folder($Dir);
                    if(!is_dir($Path->path.DS.$DirName)){
                        if (!mkdir($Path->path.DS.$DirName)) {
                        die('Failed to create folders of '.$DirName);
                        } 
                    }
                   
                    foreach($UPLOAD_FILES as $file_up){
                        $FILE_UPNAME = substr($file_up['name'],0,-4);
                        $extns = strtolower(substr($file_up['name'], strrpos($file_up['name'], '.') + 1));
                        $FILE_NAME  = $FILE_UPNAME."-".date("d-m-Y His").".".$extns;
                        $FOLDER_PATH= $Path->path.DS.$DirName;
                        $FILE_PATH  = $Path->path.DS.$DirName.DS.$FILE_NAME;
                        if(!is_file($FILE_PATH)){ 
                            $filecheck = basename($FILE_NAME);
                            $ext = strtolower(substr($filecheck, strrpos($filecheck, '.') + 1));
                           
                            if(!($ext == 'txt' || $ext == 'jpg' || $ext == 'png' || $ext == 'pdf' || $ext == 'doc' || $ext == 'docx' || $ext == 'odt' || $ext == 'xls' || $ext == 'xlsx') || ($file_up['size'] > 15728640) ){
                                $InvalidFiles .= $file_up['name'].",";
                                $invl='1';
                            }else{
                                if(move_uploaded_file($file_up['tmp_name'],$FILE_PATH)){
                                    $caseID=$this->request->data['caseid'];
                                    $File_Data['CaseFiles']['case_receive_id'] = $caseID;
                                    $File_Data['CaseFiles']['case_detail_id'] = $CaseDetailsID;
                                    $File_Data['CaseFiles']['file_name'] = $FILE_NAME;
                                    $File_Data['CaseFiles']['folder_name'] = $DirName;
                                    $File_Data['CaseFiles']['created_by'] = $auth['MyProfile']['id'];
                                    $this->CaseFiles->create(); 
                                    $success_upld = $this->CaseFiles->save($File_Data); 
                                } 
                            }
                        }
                    }
                }
            }
                if($invl=='0'){
                    $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                            <a href="#" class="uk-alert-close uk-close"></a>Case Details Submited Successfully !</div>');
                
                }elseif($invl=='1'){
                     $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                            <a href="#" class="uk-alert-close uk-close"></a>Case Details Submited Successfully, This is invalid file [<font color="red">'.$InvalidFiles.$invl.'</font>] Only !</div>');   
                
                }
                $this->redirect('case_details/'.base64_encode($this->request->data['caseid']));
        }
        
        $CaseReceive    = $this->CaseReceive->find('first',array('conditions' => array('CaseReceive.id' =>$caseID)));
        $CaseType       = $this->CaseType->find('all',array('conditions' => array('status' =>'0')));
        $Ministry       = $this->Ministry->find('all',array('conditions'=>array('ministry_status'=>'1')));
        $CourtType      = $this->CourtType->find('all',array('conditions'=>array('status'=>'0')));
        $CourtLocation  = $this->CaseCourtLocation->find('all',array('conditions'=>array('status'=>'0')));
        $CaseStatus     = $this->CaseStatus->find('all',array('conditions'=>array('status'=>'0')));
        //$CaseOutcome    = $this->CaseOutcome->find('list',array('fields' => array('case_outcome')),array('conditions'=>array('status'=>'0')));
        $CaseOutcome    = $this->CaseOutcome->find('all',array('conditions'=>array('status'=>'0')));
        
        $this->set(compact('CaseReceive','caseID','CaseType','Ministry','CourtType','CourtLocation','CaseStatus','CaseOutcome'));
    }
    public function case_details_update($caseID=null,$caseDetailID=null,$DetailDel=null) {
        //Configure::write('debug',2);
        $this->layout = 'employee-new';
        $auth = $this->Session->read('Auth');
        $caseID = base64_decode($caseID);
        $caseDetailID = base64_decode($caseDetailID);
        
        if($DetailDel!='' && $DetailDel=='del'){
            $Delsuccess = $this->CaseDetails->updateAll(array('CaseDetails.status'=>'0'), array('CaseDetails.id' => $caseDetailID));
            if($Delsuccess){ 
                $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert="">
                    <a href="#" class="uk-alert-close uk-close"></a>Recored Deleted  !</div>');
                }else{
                    $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert="">
                    <a href="#" class="uk-alert-close uk-close"></a>Sorry, Recored Not Deleted !</div>');   
                }
            $this->redirect('case_details/'.base64_encode($caseID)); 
            
        }
        if(isset($this->request->data['submit']) && $this->request->data['submit']!=''){
            
            
            if($this->request->data['upl_doc'][0]['name'] != ""){
              $UPLOAD_FILES = $this->request->data['upl_doc']; 
            }else{
                $UPLOAD_FILES = array();
            }
            
            
            if($this->request->data['mention_date']!=''){
                $Mention_date=date("Y-m-d", strtotime($this->request->data['mention_date']));
            }else{
                $Mention_date = '';
            }
            if($this->request->data['next_h_date']!=''){
                $Next_H_Date=date("Y-m-d", strtotime($this->request->data['next_h_date']));
            }else{
                $Next_H_Date = '';
            }
            if($this->request->data['decision_date']!=''){
                $Decision_Date=date("Y-m-d", strtotime($this->request->data['decision_date']));
            }else{
                $Decision_Date='';
            }
            if($this->request->data['case_outcome'] != ' '){
                $case_outcome=$this->request->data['case_outcome'];
            }else{
                $case_outcome= NULL;
            }
            $data['CaseDetails']['id']                  =   $this->request->data['caseDetailId'];
            $data['CaseDetails']['case_type_id']        =   $this->request->data['case_type'];
            $data['CaseDetails']['court_type_id']       =   $this->request->data['court_type'];
            $data['CaseDetails']['court_location_id']   =   $this->request->data['court_location'] ;
            $data['CaseDetails']['case_status_id']      =   $this->request->data['case_status'];
            $data['CaseDetails']['case_outcome_id']     =   $case_outcome;
            $data['CaseDetails']['case_receive_id']     =   $this->request->data['caseid'];
            $data['CaseDetails']['subject']             =   $this->request->data['subject'];
            $data['CaseDetails']['case_particulars']    =   $this->request->data['case_particular'] ;
            $data['CaseDetails']['case_petitioners']    =   $this->request->data['petitioner'] ;
            $data['CaseDetails']['case_respondents']    =   $this->request->data['respondent'] ;
            $data['CaseDetails']['case_witness']        =   $this->request->data['witness'] ;
            $data['CaseDetails']['bringup_date']        =   date("Y-m-d", strtotime($this->request->data['bring_date']));
            $data['CaseDetails']['mention_date']        =   $Mention_date;
            $data['CaseDetails']['next_hearing_date']   =   $Next_H_Date;
            $data['CaseDetails']['case_status_details'] =   $this->request->data['status_details'];
            $data['CaseDetails']['case_outcome_details']=   $this->request->data['outcome_details'];
            $data['CaseDetails']['remark']              =   $this->request->data['remark'] ;
            $data['CaseDetails']['decision_date']       =   $Decision_Date;
            $data['CaseDetails']['created_by']          =   $auth['MyProfile']['id'];
           
            
            
            $success = $this->CaseDetails->save($data);
            $CaseDetailsID = $this->request->data['caseDetailId'];
            
            $invl='0';
            if($success){
                if(!empty($UPLOAD_FILES)){
                   
                    $DirName = $this->request->data['case_num'];
                    $Dir = WWW_ROOT .'legal';
                    $Path = new Folder($Dir);
                    if(!is_dir($Path->path.DS.$DirName)){
                        if (!mkdir($Path->path.DS.$DirName)) {
                        die('Failed to create folders of '.$DirName);
                        } 
                    }
                       
                     
                    foreach($UPLOAD_FILES as $file_up){
                        $FILE_UPNAME = substr($file_up['name'],0,-4);
                        $extns = strtolower(substr($file_up['name'], strrpos($file_up['name'], '.') + 1));
                        $FILE_NAME  = $FILE_UPNAME."-".date("d-m-Y His").".".$extns;
                        
                        $FOLDER_PATH= $Path->path.DS.$DirName;
                        $FILE_PATH  = $Path->path.DS.$DirName.DS.$FILE_NAME;
                        if(!is_file($FILE_PATH)){ 
                            $filecheck = basename($FILE_NAME);
                            $ext = strtolower(substr($filecheck, strrpos($filecheck, '.') + 1));
                           
                            if(!($ext == 'txt' || $ext == 'jpg' || $ext == 'png' || $ext == 'pdf' || $ext == 'doc' || $ext == 'docx' || $ext == 'odt') || ($file_up['size'] > 15728640) ){
                                $InvalidFiles .= $file_up['name'].",";
                                $invl='1';
                            }else{
                                if(move_uploaded_file($file_up['tmp_name'],$FILE_PATH)){
                                    $caseID=$this->request->data['caseid'];
                                    $File_Data['CaseFiles']['case_receive_id'] = $caseID;
                                    $File_Data['CaseFiles']['case_detail_id'] = $CaseDetailsID;
                                    $File_Data['CaseFiles']['file_name'] = $FILE_NAME;
                                    $File_Data['CaseFiles']['folder_name'] = $DirName;
                                    $File_Data['CaseFiles']['created_by'] = $auth['MyProfile']['id'];
                                    
                                    $this->CaseFiles->create(); 
                                    $success_upld = $this->CaseFiles->save($File_Data); 
                                }
                            }
                        }

                    }
                }
            }
                if($invl=='0'){
                    $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                            <a href="#" class="uk-alert-close uk-close"></a>Case Details Modified Successfully !</div>');
                
                }else{
                     $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                            <a href="#" class="uk-alert-close uk-close"></a>Case Details Modified Successfully, This is invalid file [<font color="red">'.$InvalidFiles.'</font>] Only !</div>');   
                
                }
                $this->redirect('case_details/'.base64_encode($this->request->data['caseid']));
        }
        
        $CaseDetails    = $this->CaseDetails->find('first',array('conditions' => array('CaseDetails.id' =>$caseID)));
        $CaseReceive    = $this->CaseReceive->find('first',array('conditions' => array('CaseReceive.id' =>$CaseDetails['CaseDetails']['case_receive_id'])));
        $CaseType       = $this->CaseType->find('all',array('conditions' => array('status' =>'0')));
        $Ministry       = $this->Ministry->find('all',array('conditions'=>array('ministry_status'=>'1')));
        $CourtType      = $this->CourtType->find('all',array('conditions'=>array('status'=>'0')));
        $CourtLocation  = $this->CaseCourtLocation->find('all',array('conditions'=>array('status'=>'0')));
        $CaseStatus     = $this->CaseStatus->find('all',array('conditions'=>array('status'=>'0')));
        $CaseOutcome    = $this->CaseOutcome->find('all',array('conditions'=>array('status'=>'0')));
  
        $this->set(compact('CaseReceive','CaseDetails','caseID','CaseType','Ministry','CourtType','CourtLocation','CaseStatus','CaseOutcome'));
    }
    
    public function case_details_file_remove($fileId=null,$DetailID=null){
        $DetailID = base64_decode($DetailID);
        $Delsuccess = $this->CaseFiles->updateAll(array('CaseFiles.status'=>'0'), array('CaseFiles.id' => $fileId));
            if($Delsuccess){ 
                $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert="">
                    <a href="#" class="uk-alert-close uk-close"></a>File Deleted  !</div>');
                }else{
                    $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert="">
                    <a href="#" class="uk-alert-close uk-close"></a>Sorry, File Not Deleted !</div>');   
                }
            $this->redirect('case_details_update/'.base64_encode($DetailID)); 
        
    }
    
    public function case_receive($id=null,$Del=null) {
        //Configure::write('debug',2);
        $this->layout = 'employee-new';
        $auth = $this->Session->read('Auth');
        $id = base64_decode($id);
        
        
        if(isset($this->request->data['submit']) && $this->request->data['submit']!=''){
            $ccnum1 = $this->request->data['cc_num'];
            $ccnum = preg_replace('/[^A-Za-z0-9\-]/', '', $ccnum1);
           if($this->request->data['id']!=''){
               $CaseExist_Edit = $this->CaseReceive->find('first', array('conditions'=>array('CaseReceive.court_case_number' => $ccnum,'CaseReceive.id !='=>$this->request->data['id'])));
                if(!empty($CaseExist_Edit)){
                   $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert="">
                            <a href="#" class="uk-alert-close uk-close"></a>Sorry, Case Number [<b>'.$ccnum.'</b>] is Already Exist !</div>');
                   $this->redirect('case_receive');
                }
               $data['CaseReceive']['id']       =   $this->request->data['id'];
           }else{
               $CaseExist = $this->CaseReceive->find('first', array('conditions'=>array('CaseReceive.court_case_number' => $ccnum,'CaseReceive.status'=>'1')));
                if(!empty($CaseExist)){
                   $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert="">
                            <a href="#" class="uk-alert-close uk-close"></a>Sorry, Case Number [<b>'.$ccnum.'</b>] is Already Exist !</div>');
                   $this->redirect('case_receive');
                }
           } 
           
            if($this->request->data['ref_case'] != ''){
            $data['CaseReceive']['reference_case_id'] =   $this->request->data['ref_case'];
            }
            $data['CaseReceive']['ministry_id']       =   $this->request->data['ministry'];
            $data['CaseReceive']['case_type_id']      =   $this->request->data['case_type'];
            $data['CaseReceive']['action_officer_id'] =   $this->request->data['act_off'];
            $data['CaseReceive']['respondents']       =   $this->request->data['resp'];
            $data['CaseReceive']['petitioners']       =   $this->request->data['peti'];
            $data['CaseReceive']['court_case_number'] =   $ccnum;
            $data['CaseReceive']['psc_file_number']   =   $this->request->data['pfn'];
            $data['CaseReceive']['subject']           =   $this->request->data['subject'];
            $data['CaseReceive']['date_of_service']   =   date("Y-m-d", strtotime($this->request->data['dos']));
            $data['CaseReceive']['created_by']        =   $auth['MyProfile']['id'];
            
            $success = $this->CaseReceive->save($data); 

            if($success){ 
                    if($this->request->data['id']!=''){
                        $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                        <a href="#" class="uk-alert-close uk-close"></a>Case Modified Successfully!</div>');
                    }else{
                        $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                        <a href="#" class="uk-alert-close uk-close"></a>Case Entered Successfully!</div>');
                    }
            }else{
                    if($this->request->data['id']!=''){
                        $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert="">
                        <a href="#" class="uk-alert-close uk-close"></a>Sorry, Case Not Modified !</div>');
                    }else{
                        $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert="">
                        <a href="#" class="uk-alert-close uk-close"></a>Sorry, Case Not Enntered !</div>');
                    }

            }
            $this->redirect('index');

        }
        
        
        
       // $RequestType = $this->MstRequest->find('all',array('conditions' => array('MstRequest.status' =>'1')));
        
        $ReferenceCase    = $this->CaseReceive->find('list',array(
            'fields'=>array('CaseReceive.court_case_number'),
            'conditions' => array('CaseReceive.status !=' =>'0')));
        //array_unshift($ReferenceCase, '---Select---');
        $ReferenceCase[0]='--Select--';
        ksort($ReferenceCase);
//        echo "<pre>";
//        print_r($ReferenceCase);die;
        $CaseType    = $this->CaseType->find('all',array('conditions' => array('CaseType.status' =>'0')));
        $Ministry    = $this->Ministry->find('all',array('conditions'=>array('ministry_status'=>'1')));
        $ActionOff   = $this->MyProfile->find('all',array('fields'=>array('MyProfile.id','MyProfile.emp_full_name','MyProfile.dept_code'),'conditions' =>array('MyProfile.dept_code'=>'DEPT00006')));
        
        $this->set(compact('CaseType','Ministry','ActionOff','ReferenceCase'));
    }
    
    public function case_receive_edit($id=null,$Del=null) {
        //Configure::write('debug',2);
        $this->layout = 'employee-new';
        $auth = $this->Session->read('Auth');
        $id = base64_decode($id);
        
        
        if(isset($this->request->data['submit']) && $this->request->data['submit']!=''){
            $ccnum1 = $this->request->data['cc_num'];
            $ccnum = preg_replace('/[^A-Za-z0-9\-]/', '', $ccnum1);
           if($this->request->data['id']!=''){
               $CaseExist_Edit = $this->CaseReceive->find('first', array('conditions'=>array('CaseReceive.court_case_number' => $ccnum,'CaseReceive.id !='=>$this->request->data['id'])));
                if(!empty($CaseExist_Edit)){
                   $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert="">
                            <a href="#" class="uk-alert-close uk-close"></a>Sorry, Case Number [<b>'.$ccnum.'</b>] is Already Exist !</div>');
                   $this->redirect('case_receive');
                }
               $data['CaseReceive']['id']       =   $this->request->data['id'];
           }else{
               $CaseExist = $this->CaseReceive->find('first', array('conditions'=>array('CaseReceive.court_case_number' => $ccnum,'CaseReceive.status'=>'1')));
                if(!empty($CaseExist)){
                   $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert="">
                            <a href="#" class="uk-alert-close uk-close"></a>Sorry, Case Number [<b>'.$ccnum.'</b>] is Already Exist !</div>');
                   $this->redirect('case_receive');
                }
           } 
           
            if($this->request->data['ref_case'] != ''){
            $data['CaseReceive']['reference_case_id'] =   $this->request->data['ref_case'];
            } 
            $data['CaseReceive']['ministry_id']       =   $this->request->data['ministry'];
            $data['CaseReceive']['case_type_id']      =   $this->request->data['case_type'];
            $data['CaseReceive']['action_officer_id'] =   $this->request->data['act_off'];
            $data['CaseReceive']['respondents']       =   $this->request->data['resp'];
            $data['CaseReceive']['petitioners']       =   $this->request->data['peti'];
            $data['CaseReceive']['court_case_number'] =   $ccnum;
            $data['CaseReceive']['psc_file_number']   =   $this->request->data['pfn'];
            $data['CaseReceive']['subject']           =   $this->request->data['subject'];
            $data['CaseReceive']['date_of_service']   =   date("Y-m-d", strtotime($this->request->data['dos']));
            $data['CaseReceive']['created_by']        =   $auth['MyProfile']['id'];
            
            $success = $this->CaseReceive->save($data); 

            if($success){ 
                    if($this->request->data['id']!=''){
                        $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                        <a href="#" class="uk-alert-close uk-close"></a>Case Modified Successfully!</div>');
                    }else{
                        $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                        <a href="#" class="uk-alert-close uk-close"></a>Case Entered Successfully!</div>');
                    }
            }else{
                    if($this->request->data['id']!=''){
                        $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert="">
                        <a href="#" class="uk-alert-close uk-close"></a>Sorry, Case Not Modified !</div>');
                    }else{
                        $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert="">
                        <a href="#" class="uk-alert-close uk-close"></a>Sorry, Case Not Enntered !</div>');
                    }

            }
            $this->redirect('index');

        }
        
        if($id!=null && $Del==null){
            $EditCaseReceive = $this->CaseReceive->find('all', array('conditions'=>array('CaseReceive.id' => $id,'CaseReceive.status'=>'1')));
            $this->set(compact('EditCaseReceive','id'));
        }
        if($id!=null && $Del=="del"){
            $Delsuccess = $this->CaseReceive->updateAll(array('CaseReceive.status'=>'0'), array('CaseReceive.id' => $id));
            if($Delsuccess){ 
                $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert="">
                    <a href="#" class="uk-alert-close uk-close"></a>Case Deleted  !</div>');
                }else{
                    $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert="">
                    <a href="#" class="uk-alert-close uk-close"></a>Sorry, Case Not Deleted !</div>');   
                }
            $this->redirect('index'); 
            
        }
        
        
        
        $ReferenceCase    = $this->CaseReceive->find('list',array(
            'fields'=>array('CaseReceive.court_case_number'),
            'conditions' => array('CaseReceive.status !=' =>'0')));
        $ReferenceCase[0]='--Select--';
        ksort($ReferenceCase);
//        echo "<pre>";
//        print_r($ReferenceCase);die;
        $CaseType    = $this->CaseType->find('all',array('conditions' => array('CaseType.status' =>'0')));
        $Ministry    = $this->Ministry->find('all',array('conditions'=>array('ministry_status'=>'1')));
        $ActionOff   = $this->MyProfile->find('all',array('fields'=>array('MyProfile.id','MyProfile.emp_full_name','MyProfile.dept_code'),'conditions' =>array('MyProfile.dept_code'=>'DEPT00006')));
        
        $this->set(compact('CaseType','Ministry','ActionOff','ReferenceCase'));
    }
   
    
     public function get_reference_case($id=null) {
        //Configure::write('debug',2);
        //$this->layout = 'employee-new';
        $auth = $this->Session->read('Auth');
        
        
        
        
        if($id!=null){
            $EditCaseReceive = $this->CaseReceive->find('all', array('conditions'=>array('CaseReceive.id' => $id)));
            $this->set(compact('EditCaseReceive','id'));
        }
        
       // $RequestType = $this->MstRequest->find('all',array('conditions' => array('MstRequest.status' =>'1')));
        
        $ReferenceCase    = $this->CaseReceive->find('list',array(
            'fields'=>array('CaseReceive.court_case_number'),
            'conditions' => array('CaseReceive.status !=' =>'0')));
        //array_unshift($ReferenceCase, '---Select---');
        $ReferenceCase[0]='--Select--';
        ksort($ReferenceCase);
//        echo "<pre>";
//        print_r($ReferenceCase);die;
        $CaseType    = $this->CaseType->find('all',array('conditions' => array('CaseType.status' =>'0')));
        $Ministry    = $this->Ministry->find('all',array('conditions'=>array('ministry_status'=>'1')));
        $ActionOff   = $this->MyProfile->find('all',array('fields'=>array('MyProfile.id','MyProfile.emp_full_name','MyProfile.dept_code'),'conditions' =>array('MyProfile.dept_code'=>'DEPT00006')));
        
        $this->set(compact('CaseType','Ministry','ActionOff','ReferenceCase'));
    }
    
    public function get_receive_case() {
        //Configure::write('debug',2);
        //$this->layout = 'employee-new';
        $auth = $this->Session->read('Auth');

//        if($id!=null){
//            $EditCaseReceive = $this->CaseReceive->find('all', array('conditions'=>array('CaseReceive.id' => $id)));
//            $this->set(compact('EditCaseReceive','id'));
//        }
        
        $ReferenceCase    = $this->CaseReceive->find('list',array(
            'fields'=>array('CaseReceive.court_case_number'),
            'conditions' => array('CaseReceive.status !=' =>'0')));
        //array_unshift($ReferenceCase, '---Select---');
        $ReferenceCase[0]='--Select--';
        ksort($ReferenceCase);
//        echo "<pre>";
//        print_r($ReferenceCase);die;
        $CaseType    = $this->CaseType->find('all',array('conditions' => array('CaseType.status' =>'0')));
        $Ministry    = $this->Ministry->find('all',array('conditions'=>array('ministry_status'=>'1')));
        $ActionOff   = $this->MyProfile->find('all',array('fields'=>array('MyProfile.id','MyProfile.emp_full_name','MyProfile.dept_code'),'conditions' =>array('MyProfile.dept_code'=>'DEPT00006')));
        
        $this->set(compact('CaseType','Ministry','ActionOff','ReferenceCase'));
    }
    
    public function court_location($CTid=null,$DelVal=null) {
        //Configure::write('debug',2);
        $this->layout = 'employee-new';
        $auth = $this->Session->read('Auth');
        
        if(isset($this->request->data['submit']) && $this->request->data['submit']!=''){
            
            
            if(isset($this->request->data['ctid']) && $this->request->data['ctid']!=''){
                $data=$this->request->data['casetype'];
                $success = $this->CaseCourtLocation->updateAll(array('court_location'=>"'$data'"), array('id' => $this->request->data['ctid']));
            }else{
                $data['court_location']=$this->request->data['casetype'];
                $success = $this->CaseCourtLocation->save($data);
            }
            
            if($success){ 
            $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                <a href="#" class="uk-alert-close uk-close"></a>Court Location Entered Successfully!</div>');
            }else{
                $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert="">
                <a href="#" class="uk-alert-close uk-close"></a>Sorry, Court Location Not Entered !</div>');   
            }
            $this->redirect('court_location');
        }
        
        
        if($CTid != null && $DelVal==null){
            $EditData = $this->CaseCourtLocation->find('all',array('conditions' => array('id'=>$CTid)));
            $create   = "enable";
            $this->set(compact('EditData','CTid','create'));
        }elseif($CTid != null && $DelVal!=null){
            $success = $this->CaseCourtLocation->updateAll(array('status'=>$DelVal), array('id' => $CTid));
            if($success){
                if($DelVal == '1'){
                    $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert="">
                <a href="#" class="uk-alert-close uk-close"></a>Court Location Inactive !</div>');
                }elseif($DelVal == '0'){
                    $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                <a href="#" class="uk-alert-close uk-close"></a>Court Location Active !</div>');
                }
            }
            $this->redirect('court_location');
        }
        $data = $this->CaseCourtLocation->find('all');
        $this->set('data',$data);
       
    }
    
    public function case_type($CTid=null,$DelVal=null) {
        //Configure::write('debug',2);
        $this->layout = 'employee-new';
        $auth = $this->Session->read('Auth');
        
        if(isset($this->request->data['submit']) && $this->request->data['submit']!=''){
            
            
            if(isset($this->request->data['ctid']) && $this->request->data['ctid']!=''){
                $data=$this->request->data['casetype'];
                $success = $this->CaseType->updateAll(array('casetype'=>"'$data'"), array('id' => $this->request->data['ctid']));
            }else{
                $data['casetype']=$this->request->data['casetype'];
                $success = $this->CaseType->save($data);
            }
            
            if($success){ 
            $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                <a href="#" class="uk-alert-close uk-close"></a>Case Type Entered Successfully!</div>');
            }else{
                $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert="">
                <a href="#" class="uk-alert-close uk-close"></a>Sorry, Case Type Not Entered !</div>');   
            }
            $this->redirect('case_type');
        }
        
        
        if($CTid != null && $DelVal==null){
            $EditData = $this->CaseType->find('all',array('conditions' => array('id'=>$CTid)));
            $create   = "enable";
            $this->set(compact('EditData','CTid','create'));
        }elseif($CTid != null && $DelVal!=null){
            $success = $this->CaseType->updateAll(array('status'=>$DelVal), array('id' => $CTid));
            if($success){
                if($DelVal == '1'){
                    $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert="">
                <a href="#" class="uk-alert-close uk-close"></a>Case Type Inactive !</div>');
                }elseif($DelVal == '0'){
                    $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                <a href="#" class="uk-alert-close uk-close"></a>Case Type Active !</div>');
                }
            }
            $this->redirect('case_type');
        }
        $data = $this->CaseType->find('all');
        $this->set('data',$data);
       
    }
    
    
    public function court_type($CTid=null,$DelVal=null) {
        //Configure::write('debug',2);
        $this->layout = 'employee-new';
        $auth = $this->Session->read('Auth');
        
        if(isset($this->request->data['submit']) && $this->request->data['submit']!=''){
            
            
            if(isset($this->request->data['ctid']) && $this->request->data['ctid']!=''){
                $data=$this->request->data['courttype'];
                $success = $this->CourtType->updateAll(array('courttype'=>"'$data'"), array('id' => $this->request->data['ctid']));
            }else{
                $data['courttype']=$this->request->data['courttype'];
                $success = $this->CourtType->save($data);
            }
            
            if($success){ 
            $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                <a href="#" class="uk-alert-close uk-close"></a>Court Type Entered Successfully!</div>');
            }else{
                $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert="">
                <a href="#" class="uk-alert-close uk-close"></a>Sorry, Court Type Not Entered !</div>');   
            }
            $this->redirect('court_type');
        }
        
        
        if($CTid != null && $DelVal==null){
            $EditData = $this->CourtType->find('all',array('conditions' => array('id'=>$CTid)));
            $create   = "enable";
            $this->set(compact('EditData','CTid','create'));
        }elseif($CTid != null && $DelVal!=null){
            $Updsuccess = $this->CourtType->updateAll(array('status'=>$DelVal), array('id' => $CTid));
            if($Updsuccess){
                if($DelVal == '1'){
                    $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert="">
                <a href="#" class="uk-alert-close uk-close"></a>Court Type Inactive !</div>');
                }elseif($DelVal == '0'){
                    $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                <a href="#" class="uk-alert-close uk-close"></a>Court Type Active !</div>');
                }
                
            }
            $this->redirect('court_type');
        }
        $data = $this->CourtType->find('all');
        $this->set('data',$data);
       
    }
    
    public function case_details_files($caseDetID){
        //Configure::write('debug',2);
        $Allfiles= $this->CaseFiles->find('all',array('conditions'=>array('CaseFiles.case_detail_id'=>$caseDetID,'CaseFiles.status'=>'1')));
        
        $this->set('Allfiles', $Allfiles);
    }
    
    public function case_status($CTid=null,$DelVal=null) {
        //Configure::write('debug',2);
        $this->layout = 'employee-new';
        $auth = $this->Session->read('Auth');
        
        if(isset($this->request->data['submit']) && $this->request->data['submit']!=''){
        
            if(isset($this->request->data['ctid']) && $this->request->data['ctid']!=''){
                $data=$this->request->data['case_status'];
                $success = $this->CaseStatus->updateAll(array('case_status'=>"'$data'"), array('id' => $this->request->data['ctid']));
            }else{
                $data['case_status']=$this->request->data['case_status'];
                $success = $this->CaseStatus->save($data);
            }
            
            if($success){ 
            $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                <a href="#" class="uk-alert-close uk-close"></a>Case Status Entered Successfully!</div>');
            }else{
                $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert="">
                <a href="#" class="uk-alert-close uk-close"></a>Sorry, Case Status Not Entered !</div>');   
            }
            $this->redirect('case_status');
        }
        
        
        if($CTid != null && $DelVal==null){
            $EditData = $this->CaseStatus->find('all',array('conditions' => array('id'=>$CTid)));
            $create   = "enable";
            $this->set(compact('EditData','CTid','create'));
        }elseif($CTid != null && $DelVal!=null){
            $success = $this->CaseStatus->updateAll(array('status'=>$DelVal), array('id' => $CTid));
            if($success){
                if($DelVal == '1'){
                    $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert="">
                <a href="#" class="uk-alert-close uk-close"></a>Case Stauts Inactive !</div>');
                }elseif($DelVal == '0'){
                    $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                <a href="#" class="uk-alert-close uk-close"></a>Case Stauts Active !</div>');
                }
            }
             $this->redirect('case_status');
        }
        
        $data = $this->CaseStatus->find('all');
        $this->set('data',$data);
       
    }
    
    public function case_outcome($CTid=null,$DelVal=null) {
        //Configure::write('debug',2);
        $this->layout = 'employee-new';
        $auth = $this->Session->read('Auth');
        
        if(isset($this->request->data['submit']) && $this->request->data['submit']!=''){
            
            
            if(isset($this->request->data['ctid']) && $this->request->data['ctid']!=''){
                $data=$this->request->data['caseoutcome'];
                $success = $this->CaseOutcome->updateAll(array('case_outcome'=>"'$data'"), array('id' => $this->request->data['ctid']));
            }else{
                $data['case_outcome']=$this->request->data['caseoutcome'];
                $success = $this->CaseOutcome->save($data);
            }
            
            if($success){ 
            $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                <a href="#" class="uk-alert-close uk-close"></a>Case Outcome Entered Successfully!</div>');
            }else{
                $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert="">
                <a href="#" class="uk-alert-close uk-close"></a>Sorry, Case Outcome Not Entered !</div>');   
            }
            $this->redirect('case_outcome');
        }
        
        
        if($CTid != null && $DelVal==null){
            $EditData = $this->CaseOutcome->find('all',array('conditions' => array('id'=>$CTid)));
            $create   = "enable";
            $this->set(compact('EditData','CTid','create'));
        }elseif($CTid != null && $DelVal!=null){
            $success = $this->CaseOutcome->updateAll(array('status'=>$DelVal), array('id' => $CTid));
            if($success){
                if($DelVal == '1'){
                    $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert="">
                <a href="#" class="uk-alert-close uk-close"></a>Case Type Inactive !</div>');
                }else{
                    $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                <a href="#" class="uk-alert-close uk-close"></a>Case Type Active !</div>');
                }
                
            }
            $this->redirect('case_outcome');
        }
        $data = $this->CaseOutcome->find('all');
        $this->set('data',$data);
       
    }
    
    public function download($fileID) {
        
        //ob_start();
        ignore_user_abort(true);
        set_time_limit(0); // disable the time limit for this script
        $Dir_Name=$this->CaseFiles->find('first',array('conditions'=>array('id'=>$fileID,'status'=>'1')));
            
        $DirName=$Dir_Name['CaseFiles']['folder_name'];
        $fileName = $Dir_Name['CaseFiles']['file_name'];
        $path = WWW_ROOT.'legal'.DS.$DirName.DS;
            

	 //$path = "/absolute_path_to_your_files/"; // change the path to fit your websites document structure

//        $dl_file = preg_replace("([^\w\s\d\-_~,;:\[\]\(\).]|[\.]{2,})", '', $fileName); // simple file name validation
//        $dl_file = filter_var($dl_file, FILTER_SANITIZE_URL); // Remove (more) invalid characters
        $fullPath = $path.$fileName;

        if ($fd = fopen ($fullPath, "r")) {
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
            if($ext){
            header("Content-type: application/octet-stream");
            header("Content-Disposition: filename=\"".$path_parts["basename"]."\"");
            }
            
            header("Content-length: $fsize");
            header("Cache-control: private"); //use this to open files directly
            while(!feof($fd)) {
                $buffer = fread($fd, 2048);
                echo $buffer;
            }
        }
        fclose ($fd);
        die;
        
     }
     
    public function randNumber(){

        list($usec, $sec) = explode(' ', microtime());
        return  $sec + $usec * 1000000;
        die;
    }
    
    public function send_case_notification() {
        // Configure::write('debug',2);
        $CaseReceive = $this->CaseReceive->find('all', array(
            'conditions' => array('CaseReceive.status !=' => '0'),
            
        ));
//        echo "<pre>";
//        print_r($CaseReceive);die;
        foreach ($CaseReceive as $rec) {
            if(!empty($rec['CaseDetails'])){
                $CaseDetails = $this->CaseDetails->query("select * from legal_case_details where status='1' and case_receive_id='".$rec['CaseReceive']['id']."' order by id desc limit 0,1");
                
                $PSCfileRefer =  $rec['CaseReceive']['psc_file_number'];
                $CourtCaseNo =  $rec['CaseReceive']['court_case_number'];
                $MentionDate = date("d-m-Y", strtotime($CaseDetails[0]['legal_case_details']['mention_date']));
                $Comment = $CaseDetails[0]['legal_case_details']['remark'];
                
                $bringup_date = date("Y-m-d", strtotime($CaseDetails[0]['legal_case_details']['bringup_date']));
                $datetime1 = date_create($bringup_date);
                $datetime2 = date_create(date('Y-m-d'));
                $interval = date_diff($datetime2, $datetime1);
                $NumOfDays = $interval->format('%R%a');
                if ($NumOfDays == '7' || $NumOfDays == '4') {
                    
                    $data['PSCfileRefer']=$PSCfileRefer;
                    $data['CourtCaseNo']=$CourtCaseNo;
                    $data['MentionDate']=$MentionDate;
                    $data['Comment']=$Comment;
                    
                    $UserMailID = "bajrangi.srivastava@essindia.com"; //// make it comment when going live....
                    $CCMailID = "bajrangi.srivatava@essindia.com";       //// make it comment when going live....
                
                    $From = "megha.yadav@essindia.com" ;
                    $To = $UserMailID;
                    $CC = $CCMailID;
                    $sub = "Case Hearing Notification!!!!";
                    $msg = "Your case hearing is coming soon, case details mention below. ";
                    $template = 'legal_case_hearing';

                    $this->send_mail($From,$To, $CC, $sub, $msg,$template,$data);
                    echo "done";die;
                }
            }
        }
    }
 }
?>














