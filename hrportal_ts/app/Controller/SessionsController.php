<?php
App::uses('AppController', 'Controller');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SessionsController
 *
 * @author hp4420-28u
 */
class SessionsController extends AppController {
   
var $uses = array('MstTrainingRequests','TrainerMaster', 'TrainingRegistrations', 'MyProfile', 'Users','TrainingCalender','TrainingAttendance','SessionMaster','TrainingSession');
var $components = array('Session', 'RequestHandler', 'TrainingCmp', 'Email');
var $helpers = array('Html', 'Form', 'Session', 'Traininghlp');
var $layout = 'employee-new';
var $desg = array('DIRECTOR' => 'PAR0000028', 'SR PROJECT MANAGER' => 'PAR0000027');
function beforeFilter()
    {
        parent::beforeFilter();
        $this->Auth->allow();
        $this->layout = 'employee-new';
}
function assign_sessions_slub(){
    
		
	  if(isset($this->params['pass']['0']) && $this->params['pass']['0'] !=''){	
		
		$calenderID = base64_decode($this->params['pass']['0']);
		
		$topicID = base64_decode($this->params['pass']['1']);
		
		$training_topic = $this->TrainingCmp->getCouseName($topicID);
		
		
	  if(is_numeric($topicID)) {
		   $sessionlist = $this->SessionMaster->find('list',array(
					 'conditions'=>array('SessionMaster.vc_course_id' =>$topicID),
					 'fields'=>array('SessionMaster.id','SessionMaster.vc_session')
		));
             
	   $this->set('sessionlist',$sessionlist);
           $this->set('topicType','E');
	   
	   $TrainingData = $this->Trainingcalender->find('first',array('conditions'=>
	   array('Trainingcalender.id' =>$calenderID),
			'fields'=>array('Trainingcalender.training_type','Trainingcalender.training_from','Trainingcalender.training_to')));
            
	   $this->set('TrainingData',$TrainingData);	  
           
	   if($TrainingData['Trainingcalender']['training_type']=='INTERNAL'){
          $trainerlist = $this->TrainerMaster->find('list',array(
                'joins' => array(array(
                    'table' => 'myprofile',
                    'alias' => 'Personaldetails',
                    'type' => 'RIGHT',
                    'conditions' => array('TrainerMaster.trainer_id = Personaldetails.emp_code')
                  )
                ),
                'conditions' => array('TrainerMaster.course_id' =>$topicID),
                'fields' => array('TrainerMaster.trainer_id','Personaldetails.emp_firstname')
           ));
           
         }else{		 
		  $trainerlist = $this->InstituteMasterDetail->find('list',array('conditions'=>array('InstituteMasterDetail.vc_course_id'=> $topicID,'InstituteMasterDetail.vc_status'=>'A'),'fields' => array('InstituteMasterDetail.vc_emp_code','InstituteMasterDetail.vc_emp_name')));

		 } 
                 
          $this->set('trainerlist',$trainerlist);
        }
        //print_r($training_topic);die;
	    $this->set('training_topic',$training_topic);
		$this->set('calenderID',$calenderID);
		
	 }else {
            
		if(!empty($this->data)){

			$trainingID = $this->data['calenderID'];
							
		    $training_status = $this->data['training_status'];	
			    
			    foreach($this->data['INS'] as $key=>$v) {
					if(!empty($v)){
						$insData = array();
						
						 $insData['TrainingSession'] = array(
										 
										 'nu_session'=>$v['nu_session'],
										 'nu_training_id'=>$trainingID,
										 'vc_trainer_id'=>$v['vc_trainer_id'],
										 'nu_session_hh'=>0,
										 'nu_session_mm'=>0,
										 'vc_session_date'=>$v['vc_session_date'],
										 'vc_date_created'=>date('Y-m-d',strtotime(date('d-M-Y'))),
										 'vc_date_modified'=>date('Y-m-d',strtotime(date('d-M-Y')))
						);
						//print_r($insData);die;
					   $query_status = $this->TrainingSession->save($insData);	

						/******************** SAVE DATA IN THE HD_TRAINING_SESSIONS TABLE  ********/
						
                                            $this->loadModel('HdTrainingSession');						
                                            //print_r($v);die;
						foreach($v[$key] as $time_slabs){
						
							
							
							$time_slabs['training_sessions_id']= $v['nu_session'];	
                                                        $time_slabs['session_date'] = $v['vc_session_date'];
                                                        $time_slabs['start_time_hh'] = $time_slabs['nu_start_time_hh'];
                                                        $time_slabs['start_time_mm'] = $time_slabs['nu_start_time_mm'];
                                                        $time_slabs['start_time_am_pm'] = $time_slabs['vc_start_time_am_pm'];
                                                        $time_slabs['endtime_hh']= $time_slabs['nu_end_time_hh'];
                                                        $time_slabs['endtime_mm']= $time_slabs['nu_end_time_mm'];
                                                        $time_slabs['endtime_am_pm']= $time_slabs['vc_end_time_am_pm'];
                                                        $time_slabs['session_date'] = $v['vc_session_date'];
							
							$this->HdTrainingSession->save($time_slabs);									
						}
					}
				}
				//$this->sendEmailToAll($trainingID,$training_status);
				$this->Session->setFlash('Details successfully saved', 'default', array('class' => 'succuss'));
				//$this->redirect('trainingmasters/process_training_identification_form');
		     }								  
	      }
       }

}
