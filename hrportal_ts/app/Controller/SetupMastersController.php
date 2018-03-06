<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SetupMasters
 *
 * @author hp4420-28u
 */
class SetupMastersController extends AppController {

    var $names = 'WfMstAppMapLvls';
    var $layout = 'admin';
    public $components = array('Auth', 'Session', 'Email', 'Cookie', 'RequestHandler');
    var $uses = array('AttributeType', 'Options', 'OptionAttribute','RequestNotificationType','NotificationReminderType','WeightageCalculationType','SmtpConfigurationType');
    public $helpers = array('Js', 'Html', 'Form', 'Session', 'Userdetail');

    function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow();
    }

    function index() {
        $this->layout = 'admin';

        $this->set('options', $this->AttributeType->Options->find('list'));
    }

    function lists() {

        $this->paginate = array(
            'fields' => array('*'),
            'limit' => 20,
        );
        //$incometax = $this->EmpInvest->find('all',array('fields'=>array('*'),'conditions'=>array('emp_code'=>$this->Auth->User('emp_code'))));
        $options = $this->paginate('OptionAttribute');

        //echo "aaa"; die;
        //$option_list = $this->paginate('Options');

        $this->set('list', $options);
    }

    function edit($id) {
        $this->autoRender = false;
        $this->layout = false;

        if (!empty($this->data)) {
            $this->data['id'] = $id;
            $con = $this->OptionAttribute->find('count', array('conditions' => array('OptionAttribute.name' => $this->data['option']['param_name'], 'OptionAttribute.id' => $this->request->data['id'])));

            if ($con > 0) {
                $st = json_encode(array('msg' => "Duplicate Entry", 'type' => 'error'));
            } else {
                $this->OptionAttribute->id = $this->data['id'];

                if ($this->OptionAttribute->save($this->data)) {
                    $st = json_encode(array('msg' => "Data Saved Successfully", 'type' => 'success', 'dt' => date('d-M-Y h:i:s')));
                } else {
                    $st = json_encode(array('msg' => 'Updation Not Done', 'type' => 'error'));
                }
            }
            //print_r($con);die;
        } else
            $st = json_encode(array('msg' => 'Updation not done', 'type' => 'error'));
        echo $st;
        exit;
    }

    function delete($id = null) {

        $this->layout = false;
        $this->autoRender = false;
        if (!empty($id)) {
            if ($this->OptionAttribute->delete($id)) {
                $st = json_encode(array('msg' => 'Record Deleted', 'type' => 'success'));
            } else {
                $st = json_encode(array('msg' => 'Record not deleted', 'type' => 'error'));
            }
        } else
            $st = json_encode(array('msg' => 'No Record Selected', 'type' => 'error'));
        echo $st;
        exit;
    }

    function link() {
        print_r($this->data);
        die;
    }

    function selectcat($id) {
        print_r($id);
        die;
    }
    
    public function addReqNotificationType() {
        $this->layout = 'admin';
        $requestNotificationArray = array();
        
        //echo "<pre>";
        //print_r($this->request->data);
        //die;
        
        $totalRecords = $this->RequestNotificationType->find('first', array('fields' => array('req_notification_type'),
            'order' => array('id' => 'DESC')));
        
        
        $this->set('totalRecords', $totalRecords['RequestNotificationType']['req_notification_type']);
        
        if($this->request->data){
                $requestNotificationArray['req_notification_type'] = $this->request->data['setupMasters']['req_notification_type'];            
                if($requestNotificationArray['req_notification_type'] == 1){
                    $requestNotificationArray['req_notification_type_value'] = "Portal Notification";
                }else if($requestNotificationArray['req_notification_type'] == 2){
                    $requestNotificationArray['req_notification_type_value'] = "Mail";
                }else if($requestNotificationArray['req_notification_type'] == 3){
                    $requestNotificationArray['req_notification_type_value'] = "Both";
                }
                $requestNotificationArray['created_date'] = date("Y-m-d");
                $CompetencyType = $requestNotificationArray['req_notification_type'];
                $CompetencyTypeValue = $requestNotificationArray['req_notification_type_value'];
                $createdDate = $requestNotificationArray['created_date'];
                $updatedDate = date("Y-m-d");
            
            if(count($totalRecords) == 0){
                $success = $this->RequestNotificationType->save($requestNotificationArray);
                $this->Session->setFlash(' <div class="alert success">
                    <span class="closebtn" onclick="this.parentElement.style.display=\'none\';">&times;</span>
                        Request notification setup type saved successfully. !!!
                    </div>');

                $this->redirect('addReqNotificationType');
            }else{
                $success = $this->RequestNotificationType->updateAll(array('req_notification_type' => "'$CompetencyType'",'updated_date' => "'$updatedDate'",'req_notification_type_value' => "'$CompetencyTypeValue'"),array('id' => 1));             
                $this->Session->setFlash(' <div class="alert success">
                    <span class="closebtn" onclick="this.parentElement.style.display=\'none\';">&times;</span>
                        Request notification setup type updated successfully. !!!
                    </div>');
                $this->redirect('addReqNotificationType');
            }
        }
    }
    
    public function addNotificationReminderType() {
        $this->layout = 'admin';
        $notificationReminderArray = array();
        
        $totalRecords = $this->NotificationReminderType->find('first', array('fields' => array('notification_reminder_type','reminder_days'),
            'order' => array('id' => 'DESC')));
        
        
        $this->set('notificationReminderType', $totalRecords['NotificationReminderType']['notification_reminder_type']);
        $this->set('reminderDays', $totalRecords['NotificationReminderType']['reminder_days']);
        
        if($this->request->data){
                $notificationReminderArray['notification_reminder_type'] = $this->request->data['setupMasters']['notification_reminder_type'];
                $notificationReminderArray['reminder_days'] = $this->request->data['setupMasters']['reminder_days'];
                
                if($notificationReminderArray['notification_reminder_type'] == 1){
                    $notificationReminderArray['notification_reminder_type_value'] = "Yes";
                }else if($notificationReminderArray['notification_reminder_type'] == 2){
                    $notificationReminderArray['notification_reminder_type_value'] = "No";
                }
                
                $notificationReminderArray['created_date'] = date("Y-m-d");                
                $notificationReminderType = $notificationReminderArray['notification_reminder_type'];
                $notificationReminderTypeValue = $notificationReminderArray['notification_reminder_type_value'];
                $reminderDays = $notificationReminderArray['reminder_days'];
                $createdDate = $notificationReminderArray['created_date'];
                $updatedDate = date("Y-m-d");
            
            if(count($totalRecords) == 0){
                $success = $this->NotificationReminderType->save($notificationReminderArray);
                $this->Session->setFlash(' <div class="alert success">
                    <span class="closebtn" onclick="this.parentElement.style.display=\'none\';">&times;</span>
                        Notification reminder setup type saved successfully. !!!
                    </div>');

                $this->redirect('addNotificationReminderType');
            }else{
                $success = $this->NotificationReminderType->updateAll(array('notification_reminder_type' => "'$notificationReminderType'",'updated_date' => "'$updatedDate'",'notification_reminder_type_value' => "'$notificationReminderTypeValue'",'reminder_days' => "'$reminderDays'"),array('id' => 1));             
                $this->Session->setFlash(' <div class="alert success">
                    <span class="closebtn" onclick="this.parentElement.style.display=\'none\';">&times;</span>
                        Notification reminder  setup type updated successfully. !!!
                    </div>');
                $this->redirect('addNotificationReminderType');
            }
        }
    }
    
    public function addWeightageCalculationType() {
        $this->layout = 'admin';
        $weightageCalculationArray = array();
        
        //echo "<pre>";
        //print_r($this->request->data);
        //die;
        
        $totalRecords = $this->WeightageCalculationType->find('first', array('fields' => array('weightage_calculation_type'),
            'order' => array('id' => 'DESC')));
        
        
        $this->set('totalRecords', $totalRecords['WeightageCalculationType']['weightage_calculation_type']);
        
        if($this->request->data){
                $weightageCalculationArray['weightage_calculation_type'] = $this->request->data['setupMasters']['weightage_calculation_type'];            
                if($weightageCalculationArray['weightage_calculation_type'] == 1){
                    $weightageCalculationArray['weightage_calculation_type_value'] = "Manual";
                }else if($weightageCalculationArray['weightage_calculation_type'] == 2){
                    $weightageCalculationArray['weightage_calculation_type_value'] = "Rule";
                }
                
                $weightageCalculationArray['created_date'] = date("Y-m-d");
                $weightageCalculationType = $weightageCalculationArray['weightage_calculation_type'];
                $weightageCalculationTypeValue = $weightageCalculationArray['weightage_calculation_type_value'];
                $createdDate = $weightageCalculationArray['created_date'];
                $updatedDate = date("Y-m-d");
            
            if(count($totalRecords) == 0){
                $success = $this->WeightageCalculationType->save($weightageCalculationArray);
                $this->Session->setFlash(' <div class="alert success">
                    <span class="closebtn" onclick="this.parentElement.style.display=\'none\';">&times;</span>
                        Weightage calculation setup type saved successfully. !!!
                    </div>');

                $this->redirect('addWeightageCalculationType');
            }else{
                $success = $this->WeightageCalculationType->updateAll(array('weightage_calculation_type' => "'$weightageCalculationType'",'updated_date' => "'$updatedDate'",'weightage_calculation_type_value' => "'$weightageCalculationTypeValue'"),array('id' => 1));             
                $this->Session->setFlash(' <div class="alert success">
                    <span class="closebtn" onclick="this.parentElement.style.display=\'none\';">&times;</span>
                        Weightage calculation setup type updated successfully. !!!
                    </div>');
                $this->redirect('addWeightageCalculationType');
            }
        }
    }
    
    public function addSmtpConfigurationType() {
        $this->layout = 'admin';
        $smtpConfigurationArray = array();
        
        $totalRecords = $this->SmtpConfigurationType->find('first', array('fields' => array('smtp_configuration_type'),
            'order' => array('id' => 'DESC')));
        
        
        $this->set('totalRecords', $totalRecords['SmtpConfigurationType']['smtp_configuration_type']);
        
        if($this->request->data){
                $smtpConfigurationArray['smtp_configuration_type'] = $this->request->data['setupMasters']['smtp_configuration_type'];            
                if($smtpConfigurationArray['smtp_configuration_type'] == 1){
                    $smtpConfigurationArray['smtp_configuration_type_value'] = "Yes";
                }else if($smtpConfigurationArray['smtp_configuration_type'] == 2){
                    $smtpConfigurationArray['smtp_configuration_type_value'] = "No";
                }
				
                $smtpConfigurationArray['created_date'] = date("Y-m-d");
                $SmtpConfigurationType = $smtpConfigurationArray['smtp_configuration_type'];
                $SmtpConfigurationTypeValue = $smtpConfigurationArray['smtp_configuration_type_value'];
                $createdDate = $smtpConfigurationArray['created_date'];                
				$updatedDate = date("Y-m-d");
            
            if(count($totalRecords) == 0){
                $success = $this->SmtpConfigurationType->save($smtpConfigurationArray);
                $this->Session->setFlash(' <div class="alert success">
                    <span class="closebtn" onclick="this.parentElement.style.display=\'none\';">&times;</span>
                        Weightage Calculation setup type saved successfully. !!!
                    </div>');

                $this->redirect('addWeightageCalculationType');
            }else{
                $success = $this->SmtpConfigurationType->updateAll(array('smtp_configuration_type' => "'$SmtpConfigurationType'",'updated_date' => "'$updatedDate'",'smtp_configuration_type_value' => "'$SmtpConfigurationTypeValue'"),array('id' => 1));             
                $this->Session->setFlash(' <div class="alert success">
                    <span class="closebtn" onclick="this.parentElement.style.display=\'none\';">&times;</span>
                        Weightage Calculation setup type updated successfully. !!!
                    </div>');
                $this->redirect('addWeightageCalculationType');
            }
        }
    }

}
