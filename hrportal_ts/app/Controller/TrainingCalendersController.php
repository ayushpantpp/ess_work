<?php
App::uses('AppController', 'Controller');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TrainingCalendersController
 *
 * @author hp4420-28u
 */
class TrainingCalendersController extends AppController
{
   
    var $uses = array('TrainingMaster', 'TrainingMasterDetail', 'MyProfile', 'Users','TrainingCalender','TrainingAttendance','TrainingSession');
    var $components = array('Session', 'RequestHandler', 'TrainingCmp', 'Email');
    var $helpers = array('Html', 'Form', 'Session', 'Traininghlp');
    var $layout = 'employee-new';
    var $desg = array('DIRECTOR' => 'PAR0000028', 'SR PROJECT MANAGER' => 'PAR0000027');
    function beforeFilter()
    {
        parent::beforeFilter();
        $this->Auth->allow();
        
}
function training_calender_master()
{
 
		try { 
                   
		     if((isset($this->params['pass']['0'])) && ($this->params['pass']['0']=='ASSIGNCALENDAR') && ($this->data['Submit']!='Submit')){
			    
				if($this->params['pass']['1'] !='CONS'){
					
				$requestID = base64_decode($this->params['pass']['1']);
					
				}else{
				     $requestID = $_SESSION['reqIDs']['0'];

                              }				
				$this->MstTrainingRequests->recursive = -1;
				
				$trainingData = $this->MstTrainingRequests->find('first',array('conditions'=>array('MstTrainingRequests.comp_code'=>$this->Auth->User('comp_code'),'MstTrainingRequests.request_status'=>'TI','MstTrainingRequests.request_id'=>$requestID)));
                              
				$this->set('trainingData',$trainingData);
			
				$this->set('requestID',$requestID);
				$questFiles ='';
				if($trainingData['TrainingMaster']['vc_training_topic_id'] !=''){
				
				   $questFiles = $this->TrainingCmp->getQeustionireList($trainingData['TrainingMaster']['vc_training_topic_id']);
				}
				$this->set('questFiles',$questFiles);
					
			 }else{
			 
                /**************************** To process individual Training Request & assign calendar *********************/				
				 
				if(isset($this->data['processingType']) && $this->data['processingType']=='IND'){
				
			        $requestID = $this->data['Trainingcalender']['nu_request_id'];
					
			               
			                $trainingcalenders = array();
                                        $trainingcalenders['date_created'] = date('d-M-Y');
					$trainingcalenders['date_modified'] = date('d-M-Y');
					$trainingcalenders['identified_from'] = $this->data['Trainingcalender']['vc_identified_from'];
					$trainingcalenders['training_from'] = date('Y-m-d',strtotime($this->data['Trainingcalender']['vc_training_from']));
                                        $trainingcalenders['training_to']=date('Y-m-d',strtotime($this->data['Trainingcalender']['vc_training_to']));
                                        $trainingcalenders['start_hh'] = $this->data['Trainingcalender']['nu_start_hh'];
                                        $trainingcalenders['start_mm'] = $this->data['Trainingcalender']['nu_start_mm'];
                                        $trainingcalenders['start_am_pm'] = $this->data['Trainingcalender']['vc_start_am_pm'];
                                        $trainingcalenders['end_hh'] = $this->data['Trainingcalender']['nu_end_hh'];
                                        $trainingcalenders['end_mm'] = $this->data['Trainingcalender']['nu_end_mm'];
                                        $trainingcalenders['end_am_pm'] = $this->data['Trainingcalender']['vc_end_am_pm'];
                                        $trainingcalenders['duration_hh'] = $this->data['Trainingcalender']['nu_duration_hh'];
                                        $trainingcalenders['duration_mm'] = $this->data['Trainingcalender']['nu_duration_mm'];
                                        $trainingcalenders['min_trainees'] = $this->data['Trainingcalender']['nu_min_trainees'];
                                        $trainingcalenders['max_trainees'] = $this->data['Trainingcalender']['nu_max_trainees'];
                                        $trainingcalenders['training_mode'] = $this->data['Trainingcalender']['vc_training_mode'];
                                        $trainingcalenders['training_type'] = $this->data['Trainingcalender']['vc_training_type'];
                                       
                                        $trainingcalenders['most_popular'] = $this->data['Trainingcalender']['vc_most_popular'];
					$trainingcalenders['scheduled_by']= $this->Auth->User('emp_code');
					$trainingcalenders['training_scheduled_date']= date('d-M-Y');
                                       // print_r($trainingcalenders);die;
					$trn_status = 'SCHEDULED';
					
					if($this->data['Trainingcalender']['vc_training_type'] =='EXTERNAL'){
					  $trn_status = 'PENDING';
					}
					
					$trainingcalenders['training_status']= $trn_status;
                                        $trainingcalenders['topic_type'] ='E';
					
					$topicID = $this->data['Trainingcalender']['vc_topic_id'];
					$training_name = $this->TrainingCmp->getCouseName($topicID);
										
					$trainingcalenders['training_name']= $training_name;
					
					if($this->data['Trainingcalender']['vc_pte_required']=='N'){
                                        $trainingcalenders['pte_after'] = '';
                                        $trainingcalenders['pte_days_months'] ='';
				    }
					$this->TrainingCalender->create();
                                       
					if($this->TrainingCalender->save($trainingcalenders)){					
					   $date_modified = date('d-M-Y:h:i');
					   $trndate = date('d-M-y',strtotime($this->data['Trainingcalender']['vc_training_from']));
					   $training_status = 'SCHEDULED';
                                           $reqStatus = 'PR';
					   $status = $this->MstTrainingRequests->updateAll(
								array(  
									
									'MstTrainingRequests.training_name'=>"'$training_name'",										
									'MstTrainingRequests.training_status'=>"'$training_status'",						
									'MstTrainingRequests.request_status'=>"'$reqStatus'",						
									'MstTrainingRequests.training_id'=>$this->TrainingCalender->getLastInsertId()
								),
								array(
									'MstTrainingRequests.request_id'=>$requestID,
									'MstTrainingRequests.comp_code'=>$this->Auth->User('comp_code')
								)
						);
						
					/****************************Training Attendees ********************************/
                    
                    //$this->addTraineesFromTrainingQueue($topicID,$calenderID);

                                 //$this->addTraineesFromTrainingRequest($requestID,$calenderID);					
 			
				    /***********************************************************************************/
								
					$this->Session->setFlash('Training calendar assigned successfully', 'default', array('class' => 'succuss'));
							
					//$this->redirect(array('controller' => 'sessionmasters', 'action' => 'scheduled_training_sessions',base64_encode($calenderID),base64_encode($topicID),base64_encode($trn_status)));	
					
					$this->redirect(array('controller' => 'sessions', 'action' => 'assign_sessions_slub',base64_encode($this->TrainingCalender->getLastInsertId()),base64_encode($topicID),base64_encode($trn_status)));	
					
				   }
			    }
			  
			  
		     }
			$courselist = $this->TrainingCmp->courselisting();
			$this->set("courselist", $courselist);
			
		 
	    } catch (Exception $e) {
            /**
             * ************************************************************************
             * OUTPUT ERROR set output header, variable destruction, set layout, set view
             * ************************************************************************
             */
        }
    }
	
}
