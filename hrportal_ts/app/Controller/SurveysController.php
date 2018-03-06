<?php

App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');
App::uses('Folder', 'Utility');
App::uses('File', 'Utility');

//App::uses('PHPExcel', 'Vendor/Classes/PHPExcel');



/*
 * Property of Eastern Software Systems Pvt. Ltd.
 * Should be modified on by a Cake PHP Professional
 *  ******************************************************************************
 *  Description of Surveyscontroller.php
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

class SurveysController extends AppController {

    public $name = 'Surveys';
    public $uses = array('SurveyParameter', 'MyProfile', 'SurveyQuestion', 'SurveyOption', 'SurveyRecord', 'SurveyMaster');
    public $helpers = array('Js', 'Html', 'Form', 'Session', 'Userdetail', 'Common');
    public $components = array('Auth', 'Session', 'Email', 'Cookie', 'EmpDetail', 'Common', 'RequestHandler', 'Paginator');

    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow();
        // $currentUser = $this->checkUser();
    }

    public function index($id) {
        //Configure::write('debug',2);
        $this->layout = 'employee-new';
        $this->set('survey_id', $id);
        $auth = $this->Session->read('Auth');
        $value = $this->SurveyParameter->find('all', array('conditions' => array('status' => 0)));
        $this->set('qsn_ans', $value);
    }

    public function case_details($caseID = null) {
        $this->layout = 'employee-new';
        $auth = $this->Session->read('Auth');
        $CaseReceive = $this->CaseReceive->find('first', array('conditions' => array('CaseReceive.id' => $caseID)));
        $CaseDetails = $this->CaseDetails->find('all', array('conditions' => array('CaseDetails.case_receive_id' => $caseID)));
        $this->paginate = array(
            'conditions' => array('CaseDetails.case_receive_id' => $caseID, 'CaseDetails.status' => '1'),
            'limit' => 2,
            'order' => array(
                'CaseDetails.id' => 'desc'
            )
        );
        $this->set('ar', $this->paginate($this->CaseDetails));
        $this->set(compact('CaseReceive', 'CaseDetails'));
    }

    public function parameter_type($CTid = null, $DelVal = null) {
        $this->layout = 'employee-new';
        $auth = $this->Session->read('Auth');
        if (isset($this->request->data['submit']) && $this->request->data['submit'] != '') {
            if (isset($this->request->data['id']) && $this->request->data['id'] != '') {
                $data = $this->request->data['name'];

                $success = $this->SurveyParameter->updateAll(array('name' => "'$data'"), array('id' => $this->request->data['id']));
            } else {
                $data['name'] = $this->request->data['name'];
                $data['created_date'] = date('Y-m-d');
                $success = $this->SurveyParameter->save($data);
            }
            if ($success) {
                $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                <a href="#" class="uk-alert-close uk-close"></a>Survey Parameter Entered Successfully!</div>');
            } else {
                $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert="">
                <a href="#" class="uk-alert-close uk-close"></a>Sorry, Survey Parameter Not Entered !</div>');
            }
            $this->redirect('parameter_type');
        }
        if ($CTid != null && $DelVal == null) {
            $EditData = $this->SurveyParameter->find('all', array('conditions' => array('id' => $CTid, 'status' => '0')));
            $create = "enable";
            $this->set(compact('EditData', 'CTid', 'create'));
        } elseif ($CTid != null && $DelVal != null) {
            $Updsuccess = $this->SurveyParameter->updateAll(array('status' => '1'), array('id' => $CTid));
            if ($Updsuccess) {
                $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert="">
                <a href="#" class="uk-alert-close uk-close"></a>Survey Parameter Deleted !</div>');
            }
            //$this->redirect('court_type');
        }
        $this->paginate = array(
            'fields' => array('*'),
            'limit' => 10,
            'conditions' => array('SurveyParameter.status' => '0')
        );
        $data = $this->paginate('SurveyParameter');
        $this->set('data', $data);
    }

    public function question_master($CTid = null, $DelVal = null) {
		//Configure::write('debug',2);
        $this->layout = 'employee-new';
        $auth = $this->Session->read('Auth');
        $para_list = $this->SurveyParameter->find('list', array('fields' => array('id', 'name'), 'conditions' => array('status' => '0')));
        $this->set('para_list', $para_list);
		//print_r($this->request->data); die;
        if (isset($this->request->data['submit']) && $this->request->data['submit'] != '') {
            if (isset($this->request->data['id']) && $this->request->data['id'] != '') {
                $data = $this->request->data['qsn_desc'];
                $data1 = $this->request->data['parameter_id'];
                $success1 = $this->SurveyQuestion->updateAll(array('qsn_desc' => "'$data'", 'parameter_id' => "$data1"), array('id' => $this->request->data['id']));
            } else {
                $data['parameter_id'] = $this->request->data['parameter_id'];
                $data['qsn_desc'] = $this->request->data['qsn_desc'];
                $data['created_date'] = date('Y-m-d');
                $success = $this->SurveyQuestion->save($data);
            }
            if ($success) {
                if ($this->request->data['check_it'] == 'N') {
                    foreach ($this->request->data['option'] as $op) {
                        $data_1['option_desc'] = $op;
                        $data_1['question_id'] = $this->SurveyQuestion->getLastInsertID();
                        $data_1['created_date'] = date('Y-m-d');
                        $this->SurveyOption->create();
                        $this->SurveyOption->save($data_1);
                    }
                } else {
                    $default_option = array('Strongly  Agree', 'Agree', 'Neither  agree nor disagree', 'Disagree', 'Strongly  disagree', 'Dont know/No experience');
                    //print_r($default_option); die;
                    foreach ($default_option as $op) {
                        $data_1['option_desc'] = $op;
                        $data_1['question_id'] = $this->SurveyQuestion->getLastInsertID();
                        $data_1['created_date'] = date('Y-m-d');
                        $this->SurveyOption->create();
                        $this->SurveyOption->save($data_1);
                    }
                }
                $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                <a href="#" class="uk-alert-close uk-close"></a>Survey Question Entered Successfully!</div>');
            } else if($success1) { 
			$this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                <a href="#" class="uk-alert-close uk-close"></a>Survey Question Updated Successfully!</div>');
			
			} else {
				
                $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert="">
                <a href="#" class="uk-alert-close uk-close"></a>Sorry, Survey Question Not Entered !</div>');
            }
            $this->redirect('question_master');
        }
        if ($CTid != null && $DelVal == null) {
            $EditData = $this->SurveyQuestion->find('all', array('conditions' => array('id' => $CTid, 'status' => '0')));
            $create = "enable";
            $this->set(compact('EditData', 'CTid', 'create'));
        } elseif ($CTid != null && $DelVal != null) {
            $Updsuccess = $this->SurveyQuestion->updateAll(array('status' => '1'), array('id' => $CTid));
            if ($Updsuccess) {
                $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert="">
                <a href="#" class="uk-alert-close uk-close"></a>Survey Question Deleted !</div>');
            }
            //$this->redirect('court_type');
        }
        $this->paginate = array(
            'fields' => array('*'),
            'limit' => 10,
            'conditions' => array('SurveyQuestion.status' => '0')
        );
        $data = $this->paginate('SurveyQuestion');
        $this->set('data', $data);
    }

    public function save_record() {
        //Configure::write('debug',2);
        foreach ($this->data['Question'] as $val) {
            $data['SurveyRecord']['parameter_id'] = $val['parameter_id'];
            $data['SurveyRecord']['question_id'] = $val['qsn_id'];
            $data['SurveyRecord']['option_id'] = $val['option_id'];
            $data['SurveyRecord']['survey_id'] = $this->data['Detail']['survey_id'];
            $data['SurveyRecord']['dept_id'] = $this->data['Detail']['dept_id'];
            $data['SurveyRecord']['user_id'] = $this->data['Detail']['emp_name'];
            $data['SurveyRecord']['date'] = date('Y-m-d');
            $this->SurveyRecord->create();
            $saved = $this->SurveyRecord->save($data);
        }
        if ($saved) {
            $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                <a href="#" class="uk-alert-close uk-close"></a>Survey Completed Successfully!</div>');
            $this->redirect('thankyou');
        }
    }

    public function thankyou() {
        $this->layout = 'employee-new';
    }

    public function create_survey($id) {
        $this->layout = 'employee-new';
        $value = $this->SurveyMaster->find('all', array('conditions' => array('status' => 0)));
        $this->set('data', $value);
        if (isset($this->request->data['submit']) && $this->request->data['submit'] != '') {
            $data['date'] = date('Y-m-d', strtotime($this->request->data['date']));
            $success = $this->SurveyMaster->save($data);

            if ($success) {
                $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                <a href="#" class="uk-alert-close uk-close"></a>Survey Created Successfully!</div>');
            } else {
                $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert="">
                <a href="#" class="uk-alert-close uk-close"></a>Sorry, Survey Parameter Not Entered !</div>');
            }
            $this->redirect('create_survey');
        }
    }

       public function survey_detail($id) {
	$this->layout = 'employee-new';
        $fetch_values = $this->SurveyRecord->find('all', array('conditions' => array('survey_id' => $id)));
        $survey_result = $this->SurveyRecord->find('all', array('fields' =>
            array('parameter_id', 'question_id', 'option_id', 'COUNT(*)'),
            'group' => array('parameter_id', 'option_id'),
            'order' => array('parameter_id')
        ));
        foreach ($survey_result as $arg) {
            if($arg[0]['COUNT(*)'] == ''){
                $cnt = 0;
            } else {
                $cnt = $arg[0]['COUNT(*)'];
            }
            $tmp[$arg[SurveyRecord]['parameter_id']][$arg[SurveyRecord]['option_id']] = $cnt;
            
        }
       if(!empty($tmp)){ $this->excel($tmp); } else {$this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                <a href="#" class="uk-alert-close uk-close"></a>No Survey Form Have Been Filled Yet.!</div>');
				$this->redirect('create_survey');}
        
    }

    public function download($fileID) {
        ignore_user_abort(true);
        set_time_limit(0);
        $Dir_Name = $this->CaseFiles->find('first', array('conditions' => array('id' => $fileID, 'status' => '1')));
        $DirName = $Dir_Name['CaseFiles']['folder_name'];
        $fileName = $Dir_Name['CaseFiles']['file_name'];
        $path = WWW_ROOT . 'legal' . DS . $DirName . DS;
        $fullPath = $path . $fileName;
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

    public function randNumber() {

        list($usec, $sec) = explode(' ', microtime());
        return $sec + $usec * 1000000;
        die;
    }

    function excel($data) {
        //Configure::write('debug', 2);
        //print_r($data); die;
        App::import('Vendor', 'PHPExcel/Classes/PHPExcel');
        $folderToSaveXls = '/var/www/html';
        $inputFileName = 'survey-report.xls';
        $objReader = PHPExcel_IOFactory::createReader("Excel5");
        $objPHPExcel = $objReader->load($inputFileName);
        $objPHPExcel->getActiveSheet()->insertNewRowBefore(5, 1);
        $no = 7;
        $sno = 0;
        $comp_code = $this->Auth->User('vc_comp_code');
        //$objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
                ->setLastModifiedBy("Maarten Balliauw")
                ->setTitle("PHPExcel Test Document")
                ->setSubject("PHPExcel Test Document")
                ->setDescription("Test document for PHPExcel, generated using PHP classes.")
                ->setKeywords("office PHPExcel php")
                ->setCategory("Test result file");
        $no = 3;
        foreach($data as $da){
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.++$no, $da[1]);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$no, $da[2]);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$no, $da[3]);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$no, $da[4]);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$no, $da[5]);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$no, $da[6]);
        }
        ob_clean();
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        //$objWriter->save( $folderToSaveXls . '/ayush.xls' );
        header('Content-Type: application/vnd.ms-excel');
        header("Content-Type:application/force-download");
        header('Content-Disposition: attachment;filename="survey_excel.xls"');
        header('Cache-Control: max-age=0');
        $objWriter->save('php://output');
    }

}
?>














