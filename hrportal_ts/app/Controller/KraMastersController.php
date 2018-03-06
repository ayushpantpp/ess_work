<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of KraMastersController
 *
 * @author hp4420-50 Arti Gupta
 */
App::import('uploader');
App::uses('CakeEmail', 'Network/Email');

class KraMastersController extends AppController {

    var $uses = array('KraMasters', 'KpiMasters', 'KraMapEmp', 'Departments', 'Target', 'MyProfile', 'KraKpiProcess', 'OptionAttribute', 'EmpDocuments', 'AssignDesignationKras', 'kraType', 'LinkKraKpi', 'KraTarget', 'KraRating', 'AppraisalProcess', 'AssignCompetencyDeptDesg', 'CompetencyTarget', 'AppraisalDevelopmentPlan', 'KraCompOverallRating', 'TrainingDevelopment', 'MidReviews','KraComptencyFeedback','MstPmsConfig','KraReport','CompetencyStatus','KraApprovalStatus');
    var $components = array('Session', 'Cookie', 'RequestHandler', 'Auth', 'EmpDetail', 'Common', 'ExportXls', 'Email');
    var $helpers = array('Html', 'Js', 'Form', 'Session', 'Userdetail', 'Leave', 'Common');

    function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow();
        $this->layout = 'employee-new';
        $this->set('appId', 12);
        $this->set('emp_code', $this->Auth->User('emp_code'));
		
			///////////////////////////////FOR getting PMS config details //////////////////////////////////////////
		//Configure::write('debug',2);
        $kra_config = $this->Common->findKraMasterConfig($this->Auth->User('comp_code'));
	    //print_r( $kra_config );die;
        if (empty($kra_config)) {
            $this->set('sanKraConfig', 0);
            $this->Session->write('sess_kra_config', 0);
        } else {
            $this->set('sanKraConfig', $kra_config);
            $this->Session->write('sess_kra_config', $kra_config);
        }
		///////////////////////////
		
		$currentUser = $this->checkUser();
    }

    public function index() {
       $this->layout = 'admin';
    }

    public function addKraType() {
        $this->layout = 'admin';
        $kraArray = array();


        $totalRecords = $this->kraType->find('first', array('fields' => array('kra_type'),
            'order' => array('id' => 'DESC')));


        $this->set('totalRecords', $totalRecords['kraType']['kra_type']);

        if ($this->request->data) {
            $kraArray['kra_type'] = $this->request->data['kraMasters']['kra_type'];
            if ($kraArray['kra_type'] == 1) {
                $kraArray['kra_type_value'] = "Manual";
            } else if ($kraArray['kra_type'] == 2) {
                $kraArray['kra_type_value'] = "Pre Define";
            } else if ($kraArray['kra_type'] == 3) {
                $kraArray['kra_type_value'] = "Both";
            }
            $kraArray['created_date'] = date("Y-m-d");
            $kraType = $kraArray['kra_type'];
            $kraTypeValue = $kraArray['kra_type_value'];
            $createdDate = $kraArray['created_date'];

            if (count($totalRecords) == 0) {
                $success = $this->kraType->save($kraArray);
                $this->Session->setFlash(' <div class="alert success">
                    <span class="closebtn" onclick="this.parentElement.style.display=\'none\';">&times;</span>
                        KRA type saved successfully. !!!
                    </div>');

                $this->redirect('addKraType');
            } else {
                $success = $this->kraType->updateAll(array('kra_type' => "'$kraType'", 'updated_date' => "'$createdDate'", 'kra_type_value' => "'$kraTypeValue'"), array('id' => 1));
                $this->Session->setFlash(' <div class="alert success">
                    <span class="closebtn" onclick="this.parentElement.style.display=\'none\';">&times;</span>
                        KRA type updated successfully. !!!
                    </div>');
                $this->redirect('addKraType');
            }
        }
    }

    public function linkKraKpi() {
        $this->layout = 'admin';
        $linkKraKpiArray = array();

        $totalRecords = $this->LinkKraKpi->find('first', array('fields' => array('link_kra_kpi_type'),
            'order' => array('id' => 'DESC')));


        $this->set('totalRecords', $totalRecords['LinkKraKpi']['link_kra_kpi_type']);

        if ($this->request->data) {
            //echo "<pre>";
            //print_r($this->request->data);
            //die;
            echo $linkKraKpiArray['link_kra_kpi_type'] = $this->request->data['kraMasters']['link_kra_kpi_type'];
            if ($linkKraKpiArray['link_kra_kpi_type'] == 1) {
                $linkKraKpiArray['link_kra_kpi_type_value'] = "Yes";
            } else if ($linkKraKpiArray['link_kra_kpi_type'] == 2) {
                $linkKraKpiArray['link_kra_kpi_type_value'] = "No";
            }

            $linkKraKpiArray['created_date'] = date("Y-m-d");
            $LinkKraKpi = $linkKraKpiArray['link_kra_kpi_type'];
            $LinkKraKpiValue = $linkKraKpiArray['link_kra_kpi_type_value'];
            $createdDate = $linkKraKpiArray['created_date'];

            if (count($totalRecords) == 0) {
                $success = $this->LinkKraKpi->save($linkKraKpiArray);
                $this->Session->setFlash(' <div class="alert success">
                    <span class="closebtn" onclick="this.parentElement.style.display=\'none\';">&times;</span>
                        Link KRA KPI setup saved successfully. !!!
                    </div>');

                $this->redirect('linkKraKpi');
            } else {
                $success = $this->LinkKraKpi->updateAll(array('link_kra_kpi_type' => "'$LinkKraKpi'", 'updated_date' => "'$createdDate'", 'link_kra_kpi_type_value' => "'$LinkKraKpiValue'"), array('id' => 1));
                $this->Session->setFlash(' <div class="alert success">
                    <span class="closebtn" onclick="this.parentElement.style.display=\'none\';">&times;</span>
                        Link KRA KPI setup updated successfully. !!!
                    </div>');
                $this->redirect('linkKraKpi');
            }
        }
    }

    public function addKraTarget() {

//echo '<pre>';print_r($this->request->data);//die;

        $this->layout = 'employee-new';

        $data = $this->Common->findFInancialYearDesc($this->Auth->User('comp_code'));
        $currentFinancialYear = $data['FinancialYear']['id'];

        //$currentFinancialYear = "Apr " . date("Y") . " - Mar " . date('Y', strtotime('+1 years'));
        $this->set('currentFinancialYear', $currentFinancialYear);
		$viewKraRecords = $this->KraTarget->find('all', array('fields' => array('*'),
            'conditions' => array('KraTarget.emp_code' => $this->Auth->User('emp_code'), 'KraTarget.financial_year' => $currentFinancialYear)));
		
		 $this->set('viewKraRecords', $viewKraRecords);

        $currentYear = date("Y");

        $totalKraRecords = $this->KraTarget->find('all', array('fields' => array('KraTarget.id', 'KraTarget.financial_year'),
            'conditions' => array('KraTarget.emp_code' => $this->Auth->User('emp_code'), 'KraTarget.financial_year' => $currentFinancialYear, 'KraTarget.emp_status' => 2)));
			
		$KRAfeedback = $this->KraComptencyFeedback->find('all', array('fields' => array('*'),
            'conditions' => array('emp_code' => $this->Auth->User('emp_code'), 'financial_year' => $currentFinancialYear, 'kra_comp'=>1)));

        $empKraCreatedDate = $totalKraRecords[0]['KraTarget']['financial_year'];


        if (count($totalKraRecords) >= 1) {

            $this->Session->setFlash('<div class="uk-alert uk-alert-primary" data-uk-alert="">
                        <a href="#" class="uk-alert-close uk-close"></a>You have already applied KRA target details for current financial year.</div>');
            $this->redirect("viewKraTarget");
        }
		
        if ($this->request->data) {
            //Configure::write('debug',2);
           // echo '<pre>';print_r($this->request->data);die;
			$this->KraTarget->deleteAll(array('KraTarget.emp_code'=>$this->Auth->User('emp_code')));
            $kraTarget = array();
            for ($i = 0; $i < count($this->request->data['addKraTarget']['kra_name']); $i++) {
                //foreach ($this->request->data['addKraTarget']['kra_name']) as $key=>$row) {
                $kraTarget['kra_name'] = htmlentities($this->request->data['addKraTarget']['kra_name'][$i],ENT_QUOTES);
                $kraTarget['financial_year'] = "$currentFinancialYear";
                $kraTarget['weightage'] = $this->request->data['addKraTarget']['weightage'][$i];
                $kraTarget['measure'] = htmlentities($this->request->data['addKraTarget']['measure'][$i],ENT_QUOTES);
                $kraTarget['qualifying'] = htmlentities($this->request->data['addKraTarget']['qualifying'][$i],ENT_QUOTES);
                $kraTarget['measure_type'] = $this->request->data['addKraTarget']['measure_type_' . ($i + 1)];
                $kraTarget['target'] = htmlentities($this->request->data['addKraTarget']['target'][$i],ENT_QUOTES);
                $kraTarget['stretched'] = htmlentities($this->request->data['addKraTarget']['stretched'][$i],ENT_QUOTES);

                $kraTarget['mid_self_target'] = htmlentities($this->request->data['addKraTarget']['mid_target'][$i],ENT_QUOTES);
                $kraTarget['emp_code'] = $this->Auth->User('emp_code');
                $kraTarget['comp_code'] = $this->Auth->User('comp_code');
				$kraTarget['appraiser_id'] = $this->Common->getManagerCode($kraTarget['emp_code']);
				
				if(!isset($this->request->data['saveasdraft'])){
					
					$kraTarget['appraiser_comp_code'] = $this->Common->getManagerCompCode($kraTarget['emp_code']);
					$kraTarget['appraiser_status'] = 1;

					$reviewer_id = $this->Common->getManagerCode($kraTarget['appraiser_id']);
					if ($reviewer_id != "" || $reviewer_id != 0) {
						$kraTarget['reviewer_id'] = $this->Common->getManagerCode($kraTarget['appraiser_id']);
						$kraTarget['reviewer_comp_code'] = $this->Common->getManagerCompCode($kraTarget['appraiser_id']);
					} else {
						$kraTarget['reviewer_id'] = 0;
						$kraTarget['reviewer_comp_code'] = 0;
					}

					$kraTarget['reviewer_status'] = 0;

					$moderator_id = $this->Common->getManagerCode($kraTarget['reviewer_id']);
					if ($moderator_id != "" || $moderator_id != 0) {
						$kraTarget['moderator_id'] = $this->Common->getManagerCode($kraTarget['reviewer_id']);
						$kraTarget['moderator_comp_code'] = $this->Common->getManagerCompCode($kraTarget['moderator_id']);
					} else {
						$kraTarget['moderator_id'] = 0;
						$kraTarget['moderator_comp_code'] = 0;
					}

					$kraTarget['moderator_status'] = 0;

					$kraTarget['emp_status'] = 2;
					$kraTarget['final_status'] = 0;
				}

                $kraTarget['created_date'] = date("Y-m-d");
                //echo '<pre>';print_r($kraTarget);die;


                /*                 * *****************uploading documents code************************* */
                if ($this->request->data['addKraTarget']['kra_upload_' . ($i + 1) . '']['name'] != "") {

                    $newfilename = time() . basename($this->request->data['addKraTarget']['kra_upload_' . ($i + 1) . '']['name']);
                    $kraTarget['kra_upload'] = $newfilename;
                    $file = "uploads/KRA/" . $newfilename;
                    $filename = basename($this->request->data['addKraTarget']['kra_upload_' . ($i + 1) . '']['name']);
                    $ext = strtolower(substr($filename, strrpos($filename, '.') + 1));
                    if (($ext == 'exe') || ($this->request->data['addKraTarget']['kra_upload_' . ($i + 1) . '']['size'] > 2048000)) {
                        if ($this->request->data['addKraTarget']['kra_upload_' . ($i + 1) . '']['size'] > 2048000) {
                            $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert=""><a href="#" class="uk-alert-close uk-close"></a>Sorry, this is heavy sized file, please check the size !</div>');
                        } elseif (($ext == 'exe')) {
                            $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert=""><a href="#" class="uk-alert-close uk-close"></a>Sorry, this is invalid file, please check the extention !</div>');
                        }
                        $this->redirect("addKraTarget");
                    } else {
                        if (move_uploaded_file($this->request->data['addKraTarget']['kra_upload_' . ($i + 1) . '']['tmp_name'], $file)) {


                            if ($kraTarget['appraiser_id'] != "") {
								$this->KraTarget->create();
                                $success = $this->KraTarget->save($kraTarget);
                            } else {
                                $this->Session->setFlash('<div class="uk-alert uk-alert-warning" data-uk-alert="">
									<a href="#" class="uk-alert-close uk-close"></a>KRA target can not be saved successfully, because Appraiser is not linked with your profile. Please contact to HR Department.</div>');
                                $this->redirect("addKraTarget");
                            }
                        } else {
                            //echo '<pre>';print_r($kraTarget);die;
                            $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert=""><a href="#" class="uk-alert-close uk-close"></a>Document not uploaded successfully. Please try again.</div>');
                            $this->redirect("addKraTarget");
                        }
                    }
                    /*                     * ******************end here************************ */
                } else {

                    $kraTarget['kra_upload'] = '';
                    if ($kraTarget['appraiser_id'] != "") {
                        $this->KraTarget->create();
                        $success = $this->KraTarget->save($kraTarget);
                    } else {
                        $this->Session->setFlash('<div class="uk-alert uk-alert-warning" data-uk-alert="">
									<a href="#" class="uk-alert-close uk-close"></a>KRA target can not be saved successfully, because Appraiser is not linked with your profile. Please contact to HR Department !!!</div>');
                        $this->redirect("addKraTarget");
                    }
                }
            }
			
			if(trim($this->request->data['addKraTarget']['feedback'])!=''){
				//echo $this->request->data['addKraTarget']['feedback'];die;
						$KraComptencyFeedback['financial_year']= $currentFinancialYear;
						$KraComptencyFeedback['emp_code']= $this->Auth->User('emp_code');
						$KraComptencyFeedback['kra_comp']= $this->request->data['addKraTarget']['kra_comp'];
						$KraComptencyFeedback['feedback']= $this->request->data['addKraTarget']['feedback'];
						$KraComptencyFeedback['phase']= 1;
						$KraComptencyFeedback['created_by']= $this->Auth->User('emp_code');
						$KraComptencyFeedback['created_date']= date("Y-m-d");
						
						$this->KraComptencyFeedback->create();
                        $this->KraComptencyFeedback->save($KraComptencyFeedback);
			}
			if(!isset($this->request->data['saveasdraft'])){
            if (count($success)) {
				$KraApprovalStatus['financial_year']= $currentFinancialYear;
				$KraApprovalStatus['emp_code']= $this->Auth->User('emp_code');
				$KraApprovalStatus['emp_status']= 1;
				$this->KraApprovalStatus->create();
                $this->KraApprovalStatus->save($KraApprovalStatus);

                /////////Send Mail////

                $empList = $this->EmpDetail->getEmpEmailDetails($kraTarget['emp_code'], $kraTarget['comp_code']);
                $empID = $empList['UserDetail']['email'];


                $appList = $this->EmpDetail->getEmpEmailDetails($kraTarget['appraiser_id'], $kraTarget['appraiser_comp_code']);
                $managerID = $appList['UserDetail']['email'];

                $empDetails = $this->EmpDetail->getEmpDetails($kraTarget['emp_code']);
                $data['empName'] = $empDetails['MyProfile']['emp_full_name'];


                $emp_full_name = $empDetails['MyProfile']['emp_full_name'];

                $appDetails = $this->EmpDetail->getEmpDetails($kraTarget['appraiser_id']);
                $data['appName'] = $appDetails['MyProfile']['emp_full_name'];
				$data['logo'] ='logo_email.png';
                $contact_number = $appDetails['MyProfile']['contact'];


                $To = $managerID;
				$kra_config = $this->Session->read('sess_kra_config');
                $CC = $kra_config['MstPmsConfig']['hr_name'];
                $From = $empID;
                $sub = "Received KRAs for your approval";
                $msg = "This is to inform you that " . $emp_full_name . " has submitted, his/her KRA for your approval, kindly login to portal and initiate action.";
                $template = 'kra_fill_notification';
				
                if (isset($To)) {			
                    $this->send_mail($From, $To, $CC, $sub, $msg, $template, $data);
					
                }

                if (isset($contact_number) && preg_match("/^[789]\d{9}$/", $contact_number)) {
				
					$msg ="" . $emp_full_name . " has submitted, his/her KRA for your approval, kindly login to portal and initiate action.";
                    $this->Common->sendSms($contact_number, $msg);
                }


                $FinancialYear = base64_encode($currentFinancialYear);

                $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                        <a href="#" class="uk-alert-close uk-close"></a>KRAs and targets forwarded to appraiser for approval.</div>');
                $page_type=base64_encode('allemp');
				$emp_code=$this->Auth->User('emp_code');
				$this->redirect(array('controller' => 'KraMasters', 'action' => "viewKraTarget/$FinancialYear/$page_type"));
            }
			}else{
				 $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                        <a href="#" class="uk-alert-close uk-close"></a>KRAs and targets saved.</div>');
                $this->redirect("addKraTarget");
			}
        }
    }

    public function viewKraTarget($financialYear=null,$page_type=null) {
//Configure::write('debug',2);
        $this->layout = 'employee-new';

        $currentFinancialYear = base64_decode($financialYear);
        $this->set('currentFinancialYear', $currentFinancialYear);

        if (isset($empCode)) {
            $id = $empCode;
            $this->set('empCode', $id);
        } else {
            $id = $this->Auth->User('emp_code');
            $this->set('empAuthCode', $id);
        }
        $currentYear = date("Y");

        $totalKraRecords = $this->KraTarget->find('all', array('fields' => array('KraTarget.id', 'KraTarget.created_date'),
            'conditions' => array('KraTarget.emp_code' => $this->Auth->User('emp_code'), 'KraTarget.financial_year' => $currentFinancialYear)));
			
		$KRAfeedback = $this->KraComptencyFeedback->find('all', array('fields' => array('*'),
            'conditions' => array('emp_code' => $this->Auth->User('emp_code'), 'financial_year' => $currentFinancialYear, 'kra_comp' => 1)));
	
		$this->set('KRAfeedback',$KRAfeedback);
		
		$compfeedback = $this->KraComptencyFeedback->find('all', array('fields' => array('*'),
            'conditions' => array('emp_code' => $this->Auth->User('emp_code'), 'financial_year' => $currentFinancialYear, 'kra_comp' => 2)));
	
		$this->set('compfeedback',$compfeedback);
		
        $this->set('totalKraRecords', count($totalKraRecords));
        $empKraCreatedDate = $totalKraRecords[0]['KraTarget']['created_date'];
        $empKraCreatedYear = date('Y', strtotime($empKraCreatedDate));

        $allApprovedRecords = $this->KraTarget->find('all', array('fields' => array('id'),
            'conditions' => array('KraTarget.appraiser_status' => array(5), 'KraTarget.final_status' => 1, 'KraTarget.reviewer_status' => array(5), 'KraTarget.reviewer_final_status' => 1,
                'KraTarget.emp_code' => $this->Auth->User('emp_code'),
                'KraTarget.financial_year' => $currentFinancialYear)));


        if (count($allApprovedRecords) == count($totalKraRecords)) {
            $this->set('selfScoreTabOpen', 1);
        } else {
            $this->set('selfScoreTabOpen', 0);
        }


        $appraiserTotalRecords = $this->KraTarget->find('all', array('fields' => array('id'),
            'conditions' => array('KraTarget.appraiser_status' => array(1, 5),
                'KraTarget.emp_code' => $this->Auth->User('emp_code'), 'KraTarget.financial_year' => $currentFinancialYear)));

        $this->set('appraiserTotalRecords', $appraiserTotalRecords);
        $this->set('empKraCreatedDate', $empKraCreatedDate);
        $this->set('empKraCreatedYear', $empKraCreatedYear);

        $reviewerTotalRecords = $this->KraTarget->find('all', array('fields' => array('id'),
            'conditions' => array('KraTarget.reviewer_status' => array(3, 5), 'KraTarget.appraiser_status' => array(5, 3),
                'KraTarget.emp_code' => $this->Auth->User('emp_code'),
                'KraTarget.financial_year' => $currentFinancialYear)));

        if (count($totalKraRecords) == count($reviewerTotalRecords)) {
            $this->set('reviewerTotalRecords', count($reviewerTotalRecords));
        } else {
            $this->set('reviewerTotalRecords', 0);
        }


        $selfScoreBut = $this->KraTarget->find('all', array('fields' => array('id'),
		'joins' => array(
                array(
                    'table' => 'appraisal_process',
                    'alias' => 'appraisal_process',
                    'type' => 'inner',
                    'foreignKey' => false,
                    'conditions' => array('appraisal_process.emp_code = KraTarget.emp_code')
                )
            ),
            'conditions' => array('KraTarget.appraiser_status' => 5, 'KraTarget.final_status' => 1,
                'KraTarget.emp_code' => $this->Auth->User('emp_code'),
                'appraisal_process.emp_review_status' => 0,
                'KraTarget.financial_year' => $currentFinancialYear),
			'group' => 'KraTarget.emp_code'));


        if (count($selfScoreBut)!=1) {
            $this->set('selfScoreBut', 1);
        } else {
            $this->set('selfScoreBut', 0);
        }




        $revBy = $this->KraTarget->find('first', array('fields' => array('id', 'last_comment_by'),
            'conditions' => array('KraTarget.appraiser_status' => array(3, 5), 'KraTarget.reviewer_status' => array(0, 3, 5), 'KraTarget.financial_year' => $currentFinancialYear,
                'KraTarget.emp_code' => $this->Auth->User('emp_code'))));

        $revBy = $revBy['KraTarget']['last_comment_by'];
        $this->set('revBy', $revBy);

        $revRecords = $this->KraTarget->find('all', array('fields' => array('id'),
		'joins' => array(
								array(
									'table' => 'kra_approval_status',
									'alias' => 'kas',
									'type' => 'inner',
									'foreignKey' => false,
									'conditions' => array('kas.emp_code = KraTarget.emp_code')
								)
							),
            'conditions' => array('KraTarget.appraiser_status' => array(3, 5), 'KraTarget.financial_year' => $currentFinancialYear,'kas.emp_status' => 0,'kas.app_status' => 1,
                'KraTarget.emp_code' => $this->Auth->User('emp_code'))));

        $allApprRecords = $this->KraTarget->find('all', array('fields' => array('id'),
            'conditions' => array('KraTarget.appraiser_status' => array(5), 'KraTarget.reviewer_status' => array(3, 5), 'KraTarget.last_comment_by' => array(1), 'KraTarget.financial_year' => $currentFinancialYear,
                'KraTarget.emp_code' => $this->Auth->User('emp_code'))));

        if (count($allApprRecords) == count($totalKraRecords)) {
            $this->set('allApprRecords', 1);
        } else {
            $this->set('allApprRecords', 0);
        }


        if (count($revRecords)) {
            $this->set('revRecords', count($revRecords));
        } else {
            $this->set('revRecords', 0);
        }

        // Find all kra target records // 

        $this->paginate = array(
            'limit' => 100,
            'fields' => array('KraTarget.*'),
            'conditions' => array('KraTarget.emp_code' => $this->Auth->User('emp_code'), 'KraTarget.financial_year' => $currentFinancialYear),
            'order' => array('KraTarget.id' => 'asc')
        );

        $kraTargetList = $this->paginate('KraTarget');
        $this->set("kraTargetList", $kraTargetList);

        // End find all kra target records // 
        // 
        // Start emp development plan // 
        $totalDevelopmentPlan = $this->AppraisalDevelopmentPlan->find('all', array(
            'fields' => array('*'),
            'conditions' => array('AppraisalDevelopmentPlan.emp_code' => $this->Auth->User('emp_code'),
                'AppraisalDevelopmentPlan.financial_year' => $currentFinancialYear,
				//'AppraisalDevelopmentPlan.emp_review_status' => 1
				)
			)
		);
		$kra_config = $this->Session->read('sess_kra_config');
		if($kra_config['MstPmsConfig']['app_type']==1){
			if ($totalDevelopmentPlan[0]['AppraisalDevelopmentPlan']['mod_review_status'] == 2) {
				$this->set("developmentPlanSave", 0);
				$this->set("developmentPlanList", $totalDevelopmentPlan);
			} else if ($totalDevelopmentPlan[0]['AppraisalDevelopmentPlan']['emp_review_status'] == 1) {
				$this->set("developmentPlanSave", 1);
				$this->set("developmentPlanList", $totalDevelopmentPlan);
			}else{
				$this->set("developmentPlanSave", 0);
				$this->set("developmentPlanList", $totalDevelopmentPlan);
			}
		}else{
			if ($totalDevelopmentPlan[0]['AppraisalDevelopmentPlan']['emp_review_status'] == 1) {
				$this->set("developmentPlanSave", 1);
				$this->set("developmentPlanList", $totalDevelopmentPlan);
			}else{
				$this->set("developmentPlanSave", 0);
				$this->set("developmentPlanList", $totalDevelopmentPlan);
			}
		}
		if($page_type!=null) {
            $this->set("page_type", base64_decode($page_type));
        } else {
            $this->set("page_type", null);
        }

        // End emp development plan // 
    }

	   

    public function viewAppraiserKraTarget($empCode = Null, $finalYear=null,$page_type=null) {
       //Configure::write('debug',2);
        $this->layout = 'employee-new';

        $financialYear = base64_decode($finalYear);

        $data = $this->Common->findFInancialYearDesc($this->Auth->User('comp_code'));
        $currentFinancialYear = $data['FinancialYear']['id'];

        //$currentFinancialYear = "Apr " . date("Y") . " - Mar " . date('Y', strtotime('+1 years'));
        $this->set('currentFinancialYear', $financialYear);



        if (isset($empCode)) {
            $id = $empCode;
            $this->set('empCode', $id);
        }
        $emp_status_comment = " ";
        $empResponseRecords = $this->KraTarget->find('all', array('fields' => array('id'),
            'conditions' => array('KraTarget.appraiser_status' => array(1),
                'KraTarget.appraiser_id' => $this->Auth->User('emp_code'),
                'KraTarget.emp_status_comment !=' => '"'.htmlentities($emp_status_comment,ENT_QUOTES).'"',
                'KraTarget.final_status' => 0, 'KraTarget.emp_code' => $id)));

        $this->set('empResponseRecords', count($empResponseRecords));

        $currentYear = date("Y");
        $totalKraRecords = $this->KraTarget->find('all', array('fields' => array('KraTarget.id'),
            'conditions' => array('KraTarget.emp_code' => $empCode, 'KraTarget.appraiser_id' => $this->Auth->User('emp_code'),
                'KraTarget.financial_year' => $financialYear)));


        $this->set('totalKraRecords', count($totalKraRecords));

		$KRAfeedback = $this->KraComptencyFeedback->find('all', array('fields' => array('*'),
            'conditions' => array('emp_code' => $empCode, 'financial_year' => $currentFinancialYear, 'kra_comp' => 1)));
	
		$this->set('KRAfeedback',$KRAfeedback);
		
		$compfeedback = $this->KraComptencyFeedback->find('all', array('fields' => array('*'),
            'conditions' => array('emp_code' => $empCode, 'financial_year' => $currentFinancialYear, 'kra_comp' => 2)));
	
		$this->set('compfeedback',$compfeedback);
		
        $reviewerTotalRecords = $this->KraTarget->find('all', array('fields' => array('id'),
            'conditions' => array('KraTarget.reviewer_status' => array(3), 'KraTarget.appraiser_status' => array(1, 3),
                'KraTarget.emp_code' => $empCode,
                'KraTarget.financial_year' => $financialYear)));
	//print_r($reviewerTotalRecords);die;
        $this->set('reviewerTotalRecords', count($reviewerTotalRecords));

        $allApprovedRecords = $this->KraTarget->find('all', array('fields' => array('id'),
		'joins' => array(
								array(
									'table' => 'kra_approval_status',
									'alias' => 'kas',
									'type' => 'inner',
									'foreignKey' => false,
									'conditions' => array('kas.emp_code = KraTarget.emp_code')
								)
							),
            'conditions' => array('KraTarget.appraiser_status' => array(5), 'KraTarget.final_status' => 1,
                'KraTarget.emp_code' => $empCode,
                'KraTarget.appraiser_id' => $this->Auth->User('emp_code'),
                'KraTarget.financial_year' => $financialYear,"kas.emp_status = 1","kas.app_status = 1")));

        if (count($allApprovedRecords) == count($totalKraRecords)) {
            $this->set('selfScoreTabOpen', 1);
        } else {
            $this->set('selfScoreTabOpen', 0);
        }

        $selfScoreBut = $this->KraTarget->find('all', array('fields' => array('id'),
			'joins' => array(
                array(
                    'table' => 'appraisal_process',
                    'alias' => 'appraisal_process',
                    'type' => 'inner',
                    'foreignKey' => false,
                    'conditions' => array('appraisal_process.emp_code = KraTarget.emp_code')
                )
            ),
            'conditions' => array('KraTarget.appraiser_status' => 5, 'KraTarget.final_status' => 1,
                'KraTarget.emp_code' => $empCode,
                'KraTarget.appraiser_id' => $this->Auth->User('emp_code'),
                'appraisal_process.emp_review_status' => 1,
				'appraisal_process.app_review_status' => 1,
                'KraTarget.financial_year' => $financialYear)));

        if (count($totalKraRecords) == count($selfScoreBut)) {
            $this->set('selfScoreBut', 1);
        } else {
            $this->set('selfScoreBut', 0);
        }


        $this->paginate = array(
            'limit' => 100,
            'fields' => array('KraTarget.*'),
            'conditions' => array('KraTarget.emp_code' => $empCode, 'KraTarget.financial_year' => $financialYear, 'KraTarget.appraiser_id' => $this->Auth->User('emp_code')),
            'order' => array('KraTarget.id' => 'ASC')
        );

        $kraTargetList = $this->paginate('KraTarget');
        $this->set("kraTargetList", $kraTargetList);
        $this->set("kraTargetEmpCode", $empCode);
        $this->set("kraTargetFinancialYear", $finalYear);

        $appraiser_id = $this->Auth->User('emp_code');
        $this->set("appraiserId", $appraiser_id);

        /// Start Development Plane///

        $developmentPlanList = $this->AppraisalDevelopmentPlan->find('all', array(
            'fields' => array('*'),
            'conditions' => array('AppraisalDevelopmentPlan.emp_code' => $empCode,
                'AppraisalDevelopmentPlan.appraiser_id' => $this->Auth->User('emp_code'),
                'AppraisalDevelopmentPlan.emp_review_status IN (1,2)',
                'AppraisalDevelopmentPlan.app_review_status IN (0,2)',
                'AppraisalDevelopmentPlan.financial_year' => $financialYear)));

       //echo '<pre>'; print_r($developmentPlanList)."hjgjhg";die;

        if (count($developmentPlanList) >= 1) {
            $this->set("developmentPlanList", $developmentPlanList);
            $this->set("developmentPlanSave", 1);
        } else {
			 $developmentPlanList = $this->AppraisalDevelopmentPlan->find('all', array(
            'fields' => array('*'),
            'conditions' => array('AppraisalDevelopmentPlan.emp_code' => $empCode,
                'AppraisalDevelopmentPlan.appraiser_id' => $this->Auth->User('emp_code'),
                'AppraisalDevelopmentPlan.emp_review_status' => 1,
                'AppraisalDevelopmentPlan.app_review_status' => 1,
                'AppraisalDevelopmentPlan.financial_year' => $financialYear)));
            $this->set("developmentPlanList", $developmentPlanList);
            $this->set("developmentPlanSave", 0);
        }

		if($page_type!=null) {
            $this->set("page_type", base64_decode($page_type));
        } else {
            $this->set("page_type", null);
        }

        /// End Development Plane///
    }

    public function viewReviewerKraTarget($empCode = Null, $finalYear=null, $page_type=null) {
       //Configure::write('debug',2);
        $this->layout = 'employee-new';

        $financialYear = base64_decode($finalYear);

        $data = $this->Common->findFInancialYearDesc($this->Auth->User('comp_code'));
        $currentFinancialYear = $data['FinancialYear']['id'];

        //$currentFinancialYear = "Apr " . date("Y") . " - Mar " . date('Y', strtotime('+1 years'));
        $this->set('currentFinancialYear', $financialYear);

		
        if (isset($empCode)) {
            $id = $empCode;
            $this->set('empCode', $id);
        }
		$KRAfeedback = $this->KraComptencyFeedback->find('all', array('fields' => array('*'),
            'conditions' => array('emp_code' => $empCode, 'financial_year' => $currentFinancialYear, 'kra_comp' => 1)));
			$this->set('KRAfeedback',$KRAfeedback);
	
		$compfeedback = $this->KraComptencyFeedback->find('all', array('fields' => array('*'),
            'conditions' => array('emp_code' => $empCode, 'financial_year' => $currentFinancialYear, 'kra_comp' => 2)));
			$this->set('compfeedback',$compfeedback);
			
        $currentYear = date("Y");
        $totalKraRecords = $this->KraTarget->find('all', array('fields' => array('KraTarget.id'),
            'conditions' => array('KraTarget.emp_code' => $empCode, 'KraTarget.reviewer_id' => $this->Auth->User('emp_code'),
                'KraTarget.financial_year' => "$financialYear")));
        $this->set('totalKraRecords', count($totalKraRecords));

        $allApprovedRecords = $this->KraTarget->find('all', array('fields' => array('id'),
			'joins' => array(
							array(
								'table' => 'kra_approval_status',
								'alias' => 'kas',
								'type' => 'inner',
								'foreignKey' => false,
								'conditions' => array('kas.emp_code = KraTarget.emp_code')
							)
						),
            'conditions' => array('KraTarget.appraiser_status' => array(5), 'KraTarget.reviewer_final_status' => 1,
                'KraTarget.emp_code' => $empCode,
                'KraTarget.reviewer_id' => $this->Auth->User('emp_code'),
                'KraTarget.financial_year' => "$financialYear","kas.rev_status = 1")));


        if (count($allApprovedRecords) == count($totalKraRecords)) {
            $this->set('selfScoreTabOpen', 1);
        } else {
            $this->set('selfScoreTabOpen', 0);
        }
		
		
		$allApprRecords = $this->KraTarget->find('all', array('fields' => array('id'),
			
            'conditions' => array('KraTarget.appraiser_status' => array(5),'KraTarget.reviewer_status' => array(0,3,5),'KraTarget.last_comment_by' => array(1), 'KraTarget.financial_year' => $financialYear,
            'KraTarget.emp_code' => $empCode)));
		
		 if (count($allApprRecords) == count($totalKraRecords)) {
            $this->set('allApprRecords', 1);
        } else {
            $this->set('allApprRecords', 0);
        }

        $selfScoreBut = $this->KraTarget->find('all', array('fields' => array('id'),
		'joins' => array(
                array(
                    'table' => 'appraisal_process',
                    'alias' => 'appraisal_process',
                    'type' => 'inner',
                    'foreignKey' => false,
                    'conditions' => array('appraisal_process.emp_code = KraTarget.emp_code')
                )
            ),
            'conditions' => array('KraTarget.appraiser_status' => 5, 'KraTarget.final_status' => 1,
                'KraTarget.emp_code' => $empCode,
                'KraTarget.reviewer_id' => $this->Auth->User('emp_code'),
                'appraisal_process.emp_review_status' => 1,
				'appraisal_process.app_review_status' => 1,
				'appraisal_process.rev_review_status' => 1,
                'KraTarget.financial_year' => "$financialYear")));

        if (count($totalKraRecords) == count($selfScoreBut)) {
            $this->set('selfScoreBut', 1);
        } else {
            $this->set('selfScoreBut', 0);
        }

        $this->paginate = array(
            'limit' => 100,
            'fields' => array('KraTarget.*'),
            'conditions' => array('KraTarget.emp_code' => $id,
                'KraTarget.financial_year' => "$financialYear",
                'KraTarget.reviewer_id' => $this->Auth->User('emp_code'))
        );

        $kraTargetList = $this->paginate('KraTarget');
        $this->set("kraTargetList", $kraTargetList);
        $this->set("kraTargetFinancialYear", $finalYear);
        $this->set("kraTargetEmpCode", $empCode);

        $reviewer_id = $this->Auth->User('emp_code');
        $this->set("reviewerId", $reviewer_id);

        /// Start Development Plane///

        $developmentPlanList = $this->AppraisalDevelopmentPlan->find('all', array(
            'fields' => array('*'),
            'conditions' => array('AppraisalDevelopmentPlan.emp_code' => $empCode,
                'AppraisalDevelopmentPlan.self_areas_strength != ""',
                'AppraisalDevelopmentPlan.self_areas_development != ""',
                'AppraisalDevelopmentPlan.financial_year' => $financialYear)));

        if (count($developmentPlanList) >= 1) {
            $this->set("developmentPlanList", $developmentPlanList);
            $this->set("developmentPlanSave", 0);
        } else {
            $this->set("developmentPlanSave", 1);
            $this->set("developmentPlanList", $developmentPlanList);
        }
		
		if($page_type!=null) {
            $this->set("page_type", base64_decode($page_type));
        } else {
            $this->set("page_type", null);
        }
        /// End Development Plane///
    }

    public function viewModeratorKraTarget($empCode = Null, $finalYear=null,$page_type=null) {
		//Configure::write('debug',2);
        $this->layout = 'employee-new';

        $financialYear = base64_decode($finalYear);

        $data = $this->Common->findFInancialYearDesc($this->Auth->User('comp_code'));
        $currentFinancialYear = $data['FinancialYear']['id'];

        //$currentFinancialYear = "Apr " . date("Y") . " - Mar " . date('Y', strtotime('+1 years'));
        $this->set('currentFinancialYear', $financialYear);

		
        if (isset($empCode)) {
            $id = $empCode;
            $this->set('empCode', $id);
        }
			$KRAfeedback = $this->KraComptencyFeedback->find('all', array('fields' => array('*'),
            'conditions' => array('emp_code' => $empCode, 'financial_year' => $financialYear, 'kra_comp' => 1)));
			$this->set('KRAfeedback',$KRAfeedback);
			
			$compfeedback = $this->KraComptencyFeedback->find('all', array('fields' => array('*'),
            'conditions' => array('emp_code' => $empCode, 'financial_year' => $financialYear, 'kra_comp' => 2)));
			$this->set('compfeedback',$compfeedback);

        $currentYear = date("Y");
        $totalKraRecords = $this->KraTarget->find('all', array('fields' => array('KraTarget.id'),
            'conditions' => array('KraTarget.emp_code' => $empCode, 'KraTarget.moderator_id' => $this->Auth->User('emp_code'),
                'KraTarget.financial_year' => "$financialYear")));
        $this->set('totalKraRecords', count($totalKraRecords));

        $selfScoreBut = $this->KraTarget->find('all', array('fields' => array('id'),
		'joins' => array(
                array(
                    'table' => 'appraisal_process',
                    'alias' => 'appraisal_process',
                    'type' => 'inner',
                    'foreignKey' => false,
                    'conditions' => array('appraisal_process.emp_code = KraTarget.emp_code')
                )
            ),
            'conditions' => array('KraTarget.appraiser_status' => 5, 'KraTarget.final_status' => 1,
                'KraTarget.emp_code' => $empCode,
                'KraTarget.moderator_id' => $this->Auth->User('emp_code'),
                "appraisal_process.emp_review_status" => 1,
				"appraisal_process.app_review_status" => 1,
				"appraisal_process.rev_review_status" => 1,
				"appraisal_process.mod_review_status" => 1,
                'KraTarget.financial_year' => "$financialYear")));


        if (count($totalKraRecords) == count($selfScoreBut)) {
            $this->set('selfScoreBut', 1);
        } else {
            $this->set('selfScoreBut', 0);
        }

        $allApprovedRecords = $this->KraTarget->find('all', array('fields' => array('id'),
            'conditions' => array('KraTarget.appraiser_status' => array(5), 'KraTarget.final_status' => 1,
                'KraTarget.appraiser_status' => array(5), 'KraTarget.final_status' => 1,
                'KraTarget.emp_code' => $empCode,
                'KraTarget.moderator_id' => $this->Auth->User('emp_code'),
                'KraTarget.financial_year' => "$financialYear")));


        if (count($allApprovedRecords) == count($totalKraRecords)) {
            $this->set('selfScoreTabOpen', 1);
        } else {
            $this->set('selfScoreTabOpen', 0);
        }

        $moderator_id = $this->Auth->User('emp_code');
        $this->set("moderatorId", $moderator_id);


        $this->paginate = array(
            'limit' => 100,
            'fields' => array('KraTarget.*'),
            'conditions' => array('KraTarget.emp_code' => $id,
                'KraTarget.financial_year' => "$financialYear",
                'KraTarget.moderator_id' => $this->Auth->User('emp_code'))
        );

        $kraTargetList = $this->paginate('KraTarget');
        $this->set("kraTargetList", $kraTargetList);
        $this->set("kraTargetFinancialYear", $finalYear);
        $this->set("kraTargetEmpCode", $empCode);

        $moderator_id = $this->Auth->User('emp_code');
        $this->set("moderatorId", $moderator_id);

        /// Start Development Plane///

        $developmentPlanList = $this->AppraisalDevelopmentPlan->find('all', array(
            'fields' => array('*'),
            'conditions' => array('AppraisalDevelopmentPlan.emp_code' => $empCode,
                'AppraisalDevelopmentPlan.self_areas_strength != ""',
                'AppraisalDevelopmentPlan.self_areas_development != ""',
                'AppraisalDevelopmentPlan.appraiser_areas_strength != ""',
                'AppraisalDevelopmentPlan.appraiser_areas_development != ""',
                'AppraisalDevelopmentPlan.financial_year' => $financialYear)));

        //echo count($developmentPlanList); 
        if (count($developmentPlanList) >= 1) {
            $this->set("developmentPlanList", $developmentPlanList);
            $this->set("developmentPlanSave", 0);
        } else {
            $this->set("developmentPlanSave", 1);
            $this->set("developmentPlanList", $developmentPlanList);
        }
		
		if($page_type!=null) {
            $this->set("page_type", base64_decode($page_type));
        } else {
            $this->set("page_type", null);
        }
        /// End Development Plane///
    }

    public function updateKraTarget() {

        $this->layout = 'employee-new';
        if ($this->request->data) {

            $kraTarget = array();

            $kraTargetEmpCode = $this->request->data['kraTargetEmpCode'];
            $financialYear = $this->request->data['kraTargetFinancialYear'];

            $kraTargetFinancialYear = base64_decode($this->request->data['kraTargetFinancialYear']);

            if ($this->request->data['addSelfScore'] == "Submit") {

                for ($i = 0; $i < count($this->request->data['updateKraTarget']['id']); $i++) {

                    $kraTargetId = $this->request->data['updateKraTarget']['id'][$i];
					$appraiserScoreActual = $this->request->data['updateKraTarget']['appraiser_score_actual'][$i];
                    $appraiserScoreAchiev = $this->request->data['updateKraTarget']['appraiser_score_achiev'][$i];
                    $appraiserScoreComment = $this->request->data['updateKraTarget']['appraiser_score_comment'][$i];

                    $kraWeightage = $this->Common->getKraWeightageByID($kraTargetId);
					
					$kra_config = $this->Session->read('sess_kra_config');
					if($kra_config['MstPmsConfig']['app_type'] == 1){
						$chievSum += $kraWeightage * $appraiserScoreAchiev;
					}
                    
					if($kra_config['MstPmsConfig']['app_type'] == 2){
						$chievSum += $appraiserScoreActual;
					}
					

                    $kraDetails = $this->Common->getKraTargetDetails($kraTargetEmpCode, $kraTargetFinancialYear);

                    //echo "<pre>";
                   //print_r($this->request->data); //die;
                    $reviewer_id = $kraDetails[0]['KraTarget']['reviewer_id'];
                    $moderator_id = $kraDetails[0]['KraTarget']['moderator_id'];

                    $this->KraTarget->create();

                    if ($reviewer_id == 0 && $moderator_id == 0) {
                        $successSelfScore = $this->KraTarget->UpdateAll(array(
							'KraTarget.reviewer_score_actual' => "'$appraiserScoreActual'",
                            'KraTarget.reviewer_score_achiev' => "'$appraiserScoreAchiev'",
                            'KraTarget.reviewer_score_comment' => '"'.htmlentities($appraiserScoreComment,ENT_QUOTES).'"',
							'KraTarget.moderator_score_actual' => "'$appraiserScoreActual'",
                            'KraTarget.moderator_score_achiev' => "'$appraiserScoreAchiev'",
                            'KraTarget.moderator_score_comment' => '"'.htmlentities($appraiserScoreComment,ENT_QUOTES).'"',), array('KraTarget.id' => $kraTargetId, 'KraTarget.financial_year' => $kraTargetFinancialYear));
                    }

                    $successSelfScore = $this->KraTarget->UpdateAll(array(
						'KraTarget.appraiser_score_actual' => "'$appraiserScoreActual'",
                        'KraTarget.appraiser_score_achiev' => "'$appraiserScoreAchiev'",
                        'KraTarget.appraiser_score_comment' => '"'.htmlentities($appraiserScoreComment,ENT_QUOTES).'"'), array('KraTarget.id' => $kraTargetId, 'KraTarget.financial_year' => $kraTargetFinancialYear));
                }
				
				if(trim($this->request->data['updateKraTarget']['feedback'])!=''){
				//echo $this->request->data['updateKraTarget']['feedback'];die;
						$KraComptencyFeedback['financial_year']= $kraTargetFinancialYear;
						$KraComptencyFeedback['emp_code']= $kraTargetEmpCode;
						$KraComptencyFeedback['kra_comp']= $this->request->data['updateKraTarget']['kra_comp'];
						$KraComptencyFeedback['feedback']= $this->request->data['updateKraTarget']['feedback'];
						$KraComptencyFeedback['phase']= 3;
						$KraComptencyFeedback['created_by']= $this->Auth->User('emp_code');
						$KraComptencyFeedback['created_date']= date("Y-m-d");
						
						$this->KraComptencyFeedback->create();
                        $this->KraComptencyFeedback->save($KraComptencyFeedback);
			}
			
			   if ($successSelfScore && !isset($this->request->data['saveasdraft'])) {
					if($kra_config['MstPmsConfig']['app_type'] == 1){
						$totalAchiv = $chievSum / 100;
					}

					if($kra_config['MstPmsConfig']['app_type'] == 2){
						$totalAchiv = $chievSum;
					}

                    /* if ($totalAchiv < 60) {
                        $rating = 1;
                    } else if ($totalAchiv >= 60 && $totalAchiv <= 80) {
                        $rating = 2;
                    } else if ($totalAchiv >= 81 && $totalAchiv <= 100) {
                        $rating = 3;
                    } else if ($totalAchiv >= 101 && $totalAchiv <= 119) {
                        $rating = 4;
                    } else if ($totalAchiv >= 120) {
                        $rating = 5;
                    } */
					
					$kraRatings = $this->Common->findKraRatingList();
					for($kra=0;$kra<count($kraRatings);$kra++){
						
						if($totalAchiv >= $kraRatings[0]['KraRating']['achievement_from']){
							$rating = 5;
						}else if($totalAchiv >= $kraRatings[1]['KraRating']['achievement_from'] && $totalAchiv <= $kraRatings[1]['KraRating']['achievement_to']){
							$rating = 4;
						}else if($totalAchiv >= $kraRatings[2]['KraRating']['achievement_from'] && $totalAchiv <= $kraRatings[2]['KraRating']['achievement_to']){
							$rating = 3;
						}else if($totalAchiv >= $kraRatings[3]['KraRating']['achievement_from'] && $totalAchiv <= $kraRatings[3]['KraRating']['achievement_to']){
							$rating = 2;
						}else if($totalAchiv >= $kraRatings[4]['KraRating']['achievement_from'] && $totalAchiv <= $kraRatings[4]['KraRating']['achievement_to']){
							$rating = 1;
						}else{
							$rating = 1;
						}
						break;
					}

                    $kraCompOverallRating['appraiser_self_overall_achiev'] = $totalAchiv;
                    $kraCompOverallRating['appraiser_self_overall_rating'] = $rating;

                    $kraDetails = $this->Common->getKraTargetDetails($kraTargetEmpCode, $kraTargetFinancialYear);

                    //echo "<pre>"; print_r($kraDetails); die;
                    $reviewer_id = $kraDetails[0]['KraTarget']['reviewer_id'];
                    $moderator_id = $kraDetails[0]['KraTarget']['moderator_id'];
                    $reviewer_comp_code = $this->Common->getManagerCompCode($reviewer_id);

                    if ($reviewer_id == 0 && $moderator_id == 0) {

                        $list = $this->Common->getKraCompOverallRating($kraTargetEmpCode, $kraTargetFinancialYear);

                        $empKRAOverallRating = $list[0]['KraCompOverallRating']['emp_self_overall_rating'];
						
						if($kra_config['MstPmsConfig']['app_type'] == 1){
							$kraOverallRating = ($empKRAOverallRating + $rating + $rating + $rating) / 4;
						}
						if($kra_config['MstPmsConfig']['app_type'] == 2){
							$kraOverallRating = $kraCompOverallRating['appraiser_self_overall_rating'];
						}

                        $this->KraCompOverallRating->UpdateAll(array(
                            'KraCompOverallRating.reviewer_self_overall_achiev' => "'$totalAchiv'",
                            'KraCompOverallRating.reviewer_self_overall_rating' => "'$rating'",
                            'KraCompOverallRating.moderator_self_overall_achiev' => "'$totalAchiv'",
                            'KraCompOverallRating.moderator_self_overall_rating' => "'$rating'",
                            'KraCompOverallRating.kra_overall_rating' => $kraOverallRating), array('KraCompOverallRating.emp_code' => $kraTargetEmpCode,
                            'KraCompOverallRating.appraiser_id' => $this->Auth->User('emp_code'),
                            'KraCompOverallRating.financial_year' => $kraTargetFinancialYear));
                    }

                    $this->KraCompOverallRating->UpdateAll(array(
                        'KraCompOverallRating.appraiser_self_overall_achiev' => "'$totalAchiv'",
                        'KraCompOverallRating.appraiser_self_overall_rating' => "'$rating'",
                        'KraCompOverallRating.reviewer_id' => $reviewer_id,
                        'KraCompOverallRating.reviewer_comp_code' => $reviewer_comp_code), array('KraCompOverallRating.emp_code' => $kraTargetEmpCode,
                        'KraCompOverallRating.appraiser_id' => $this->Auth->User('emp_code'),
                        'KraCompOverallRating.financial_year' => $kraTargetFinancialYear));
			
						$kraDetails = $this->Common->getKraTargetDetails($kraTargetEmpCode, $kraTargetFinancialYear);
						
						$appList = $this->EmpDetail->getEmpEmailDetails( $kraDetails[0]['KraTarget']['appraiser_id'],$kraDetails[0]['KraTarget']['appraiser_comp_code']);
						$managerID = $appList['UserDetail']['email'];
						$appDetails = $this->EmpDetail->getEmpDetails($kraDetails[0]['KraTarget']['appraiser_id']);
						$appName = $appDetails['MyProfile']['emp_full_name'];
						
						$revList = $this->EmpDetail->getEmpEmailDetails( $kraDetails[0]['KraTarget']['reviewer_id'],$kraDetails[0]['KraTarget']['reviewer_comp_code']);
						$revID = $revList['UserDetail']['email'];
						$revDetails = $this->EmpDetail->getEmpDetails( $kraDetails[0]['KraTarget']['reviewer_id']);
						$rev_full_name = $revDetails['MyProfile']['emp_full_name'];
						
						$empList = $this->EmpDetail->getEmpEmailDetails( $kraTargetEmpCode,$kraDetails[0]['KraTarget']['comp_code']);
						$empID = $empList['UserDetail']['email'];
						$empDetails = $this->EmpDetail->getEmpDetails( $kraDetails[0]['KraTarget']['emp_code']);
						$emp_full_name = $empDetails['MyProfile']['emp_full_name'];
						
						$data['name'] = $revDetails['MyProfile']['emp_full_name'];
						$data['logo'] ='logo_email.png';
						//echo "<pre>";print_r($appDetails);die;
						
						
             if ($reviewer_id == 0 && $moderator_id == 0) {
						$To = $empID;
						$kra_config = $this->Session->read('sess_kra_config');
						$CC = $kra_config['MstPmsConfig']['hr_name'];
						$From = $managerID;
						$sub = "Your appraisal has been completed";
						$msg = "This is to inform you that " . $emp_full_name . " appraisal process has been completed, kindly login to portal to view the scores.";
						$template = 'appraisal_process_notification';
						
						//die;
						if (isset($To)) {			
							$this->send_mail($From, $To, $CC, $sub, $msg, $template, $data);
						}
						$contact_number = $empDetails['MyProfile']['contact'];
						 if (isset($contact_number) && preg_match("/^[789]\d{9}$/", $contact_number)) {
							$msg="This is to inform you that your appraisal process has been completed, kindly login to portal to view the scores.";
							$this->Common->sendSms($contact_number, $msg);
						}
						
					$success = $this->AppraisalProcess->UpdateAll(array(
                    'AppraisalProcess.app_review_status' => "1",
					'AppraisalProcess.rev_review_status' => "1",
					'AppraisalProcess.mod_review_status' => "1",
                        ), array('AppraisalProcess.emp_code' => $kraTargetEmpCode, 'AppraisalProcess.financial_year' => "$financialYear"));

						
						$page_type=base64_encode("allannapp");
                        $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                        <a href="#" class="uk-alert-close uk-close"></a>KRA annual self assessment saved. Please fill competency ratings to complete the appraisal process.</div>');
                    $this->redirect(array('controller' => 'KraMasters', 'action' => "viewAppraiserKraTarget/$kraTargetEmpCode/$financialYear/$page_type"));
				 
			 }else{
				 //Configure::write('debug',2);
						$success = $this->AppraisalProcess->UpdateAll(array(
							'AppraisalProcess.app_review_status' => "1",
                        ), array('AppraisalProcess.emp_code' => $kraTargetEmpCode, 'AppraisalProcess.financial_year' => "$kraTargetFinancialYear"));
						
						$To = $revID;
						$kra_config = $this->Session->read('sess_kra_config');
						$CC = $kra_config['MstPmsConfig']['hr_name'];
						$From = $managerID;
						$sub = "Received annual KRAS for your Assessment";
						$msg = "This is to inform you that " . $emp_full_name . " has submitted, his/ her annual KRAs for your assessment, kindly login to portal and initiate action.";
						$template = 'appraisal_process_notification';
						
						//die;
						if (isset($To)) {			
							$this->send_mail($From, $To, $CC, $sub, $msg, $template, $data);
						}
						$contact_number = $revDetails['MyProfile']['contact'];
						 if (isset($contact_number) && preg_match("/^[789]\d{9}$/", $contact_number)) {
							$msg="" . $emp_full_name . " has submitted, his/ her annual KRAs for your assessment, kindly login to portal and initiate action.";
							$this->Common->sendSms($contact_number, $msg);
						}
					

                    $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                        <a href="#" class="uk-alert-close uk-close"></a>KRA annual self assessment saved. Please fill competency ratings and development plan to forward the assessment to reviewer.</div>');
					$page_type=base64_encode("allannapp");
                    $this->redirect("viewAppraiserKraTarget/$kraTargetEmpCode/$financialYear/$page_type");
			 }
         }else{
			 $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                        <a href="#" class="uk-alert-close uk-close"></a>KRA annual self assessment saved.</div>');
					$page_type=base64_encode("allannapp");
                    $this->redirect("viewAppraiserKraTarget/$kraTargetEmpCode/".base64_encode($kraTargetFinancialYear)."/$page_type");
				
            
		 }
            }

        //  echo '<pre>';print_r($this->request->data);//die;

            if ($this->request->data['addMidAppSelfScore'] == "Submit") {
			
               // Configure::write('debug','2');
            //  echo '<pre>';print_r($this->request->data);

                for ($i = 0; $i < count($this->request->data['id']); $i++) {
                    $comm = $this->request->data['mid_appraiser_score_comment'][$i];
					
					$mid_app_actual_upload = '';
                /*                 * *****************uploading documents code************************* */
                if ($this->request->data['mid_app_actual_upload_' . ($i + 1) . ''] != '') {
					 /*                 * *****************uploading documents code************************* */
                if (is_array($this->request->data['mid_app_actual_upload_' . ($i + 1) . '']) && $this->request->data['mid_app_actual_upload_' . ($i + 1) . '']['name'] != '') {
                    $newfilename = time() . basename($this->request->data['mid_app_actual_upload_' . ($i + 1) . '']['name']);

                    $file = "uploads/KRA/" . $newfilename;
                    $filename = basename($this->request->data['mid_app_actual_upload_' . ($i + 1) . '']['name']);
                    $ext = strtolower(substr($filename, strrpos($filename, '.') + 1));
                    if (($ext == 'exe') || ($this->request->data['mid_app_actual_upload_' . ($i + 1) . '']['size'] >= 2048000)) {
                        if ($this->request->data['mid_app_actual_upload_' . ($i + 1) . '']['size'] >= 2048000) {
                            $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert=""><a href="#" class="uk-alert-close uk-close"></a>Sorry, this is heavy sized file, please check the size !</div>');
                        } elseif (($ext == 'exe')) {
                            $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert=""><a href="#" class="uk-alert-close uk-close"></a>Sorry, this is invalid file, please check the extention !</div>');
                        }
                        $this->redirect("viewAllMidAppraiserKraTarget");
                    } else {
                        if (move_uploaded_file($this->request->data['mid_app_actual_upload_' . ($i + 1) . '']['tmp_name'], $file)) {
                            $mid_app_actual_upload = $newfilename;
                        } else {
                            $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert=""><a href="#" class="uk-alert-close uk-close"></a>' . ($i + 1) . $this->request->data['mid_app_actual_upload_' . ($i + 1) . '']['name'] . 'Document not uploaded successfully. Please try again.</div>');
                            $this->redirect("viewAllMidAppraiserKraTarget");
                        }
                    }
                } elseif (is_array($this->request->data['mid_app_actual_upload_' . ($i + 1) . '']) != '' && $this->request->data['mid_app_actual_upload_' . ($i + 1) . '']['name'] == '') {
                    $mid_app_actual_upload = $this->request->data['updateKraTarget']['mid_app_actual_upload_pre'][$i];
                    //echo 'ww';
                } elseif (!is_array($this->request->data['mid_app_actual_upload_' . ($i + 1) . ''])) {
                    $mid_app_actual_upload = $this->request->data['mid_app_actual_upload_' . ($i + 1) . ''];

                    //echo 'pp';
                }
				
                  
                }
                /*                 * ******************end here************************ */
//Configure::write('debug','2');	
            //   echo ($i + 1) . ' ' . $mid_app_actual_upload . '<br>'; 

                    $successAppMid = $this->KraTarget->UpdateAll(array(
						'KraTarget.mid_app_actual_upload' => '"'.$mid_app_actual_upload.'"',
                        'KraTarget.mid_appraiser_score_comment' => '"'.htmlentities($comm,ENT_QUOTES).'"'), array('KraTarget.id' => $this->request->data['id'][$i], 'KraTarget.financial_year' => $kraTargetFinancialYear));
                }
			//die;	
				if(trim($this->request->data['updateKraTarget']['feedback'])!=''){
				//echo $this->request->data['updateKraTarget']['feedback'];die;
						$KraComptencyFeedback['financial_year']= $kraTargetFinancialYear;
						$KraComptencyFeedback['emp_code']= $kraTargetEmpCode;
						$KraComptencyFeedback['kra_comp']= $this->request->data['updateKraTarget']['kra_comp'];
						$KraComptencyFeedback['feedback']= $this->request->data['updateKraTarget']['feedback'];
						$KraComptencyFeedback['phase']= 2;
						$KraComptencyFeedback['created_by']= $this->Auth->User('emp_code');
						$KraComptencyFeedback['created_date']= date("Y-m-d");
						
						$this->KraComptencyFeedback->create();
                        $this->KraComptencyFeedback->save($KraComptencyFeedback);
			}
			if(isset($this->request->data['saveasdraft'])){
				$this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                        <a href="#" class="uk-alert-close uk-close"></a>Mid Review has been saved.</div>');
				$kraTargetFinancialYear = base64_encode($kraTargetFinancialYear);
					$page_type = base64_encode('allmidapp');
					
                    $this->redirect(array('controller' => 'KraMasters', 'action' => "viewAppraiserKraTarget/$kraTargetEmpCode/$kraTargetFinancialYear/$page_type"));
               
			}else{
			
                /////////Send Mail to reviewer for mid score review////
						//echo "<pre>";print_r($this->request->data);//die;
						$kraDetails = $this->Common->getKraTargetDetails($this->request->data['kraTargetEmpCode'], $kraTargetFinancialYear);
						
						$appList = $this->EmpDetail->getEmpEmailDetails( $kraDetails[0]['KraTarget']['appraiser_id'],$kraDetails[0]['KraTarget']['appraiser_comp_code']);
						$managerID = $appList['UserDetail']['email'];
						$appDetails = $this->EmpDetail->getEmpDetails($kraDetails[0]['KraTarget']['appraiser_id']);
						$appName = $appDetails['MyProfile']['emp_full_name'];
						
						$revList = $this->EmpDetail->getEmpEmailDetails( $kraDetails[0]['KraTarget']['reviewer_id'],$kraDetails[0]['KraTarget']['reviewer_comp_code']);
						$revID = $revList['UserDetail']['email'];
						$revDetails = $this->EmpDetail->getEmpDetails( $kraDetails[0]['KraTarget']['reviewer_id']);
						$rev_full_name = $revDetails['MyProfile']['emp_full_name'];
						
						$empDetails = $this->EmpDetail->getEmpDetails( $kraDetails[0]['KraTarget']['emp_code']);
						$empList = $this->EmpDetail->getEmpEmailDetails( $kraDetails[0]['KraTarget']['emp_code'],$kraDetails[0]['KraTarget']['comp_code']);
						$empID = $empList['UserDetail']['email'];
						$emp_full_name = $empDetails['MyProfile']['emp_full_name'];
						
						$data['name'] = $revDetails['MyProfile']['emp_full_name'];
						$data['logo'] ='logo_email.png';
						//echo "<pre>";print_r($appDetails);die;
						$contact_number = $revDetails['MyProfile']['contact'];
						
						$To = $revID;
						$kra_config = $this->Session->read('sess_kra_config');
						$CC = $kra_config['MstPmsConfig']['hr_name'];
						$From = $managerID;
						$sub = "Received Mid-Year KRAS for your Review";
						$msg = "This is to inform you that " . $emp_full_name . " has submitted, his/ her mid year KRAs for your review , kindly login to portal and initiate action.";
						$template = 'appraisal_process_notification';
						//die;
						if (isset($To)) {			
							$this->send_mail($From, $To, $CC, $sub, $msg, $template, $data);
						}
						 if (isset($contact_number) && preg_match("/^[789]\d{9}$/", $contact_number)) {
							$msg="" . $emp_full_name . " has submitted, his/ her mid year KRAs for your review , kindly login to portal and initiate action.";
							$this->Common->sendSms($contact_number, $msg);
						}
						
				if ($successAppMid) {
				
						if(empty($kraDetails[0]['KraTarget']['reviewer_id']) || $kraDetails[0]['KraTarget']['reviewer_id']==0){
							$success = $this->MidReviews->UpdateAll(array(
								'MidReviews.app_review_status' => 1,
								'MidReviews.rev_review_status' => 1,
								'MidReviews.mod_review_status' => 1
								),
								array('MidReviews.emp_code' => $this->request->data['kraTargetEmpCode'], 'MidReviews.financial_year' => $kraTargetFinancialYear));
						
						$To = $managerID.",".$empID;
						$kra_config = $this->Session->read('sess_kra_config');
						$CC = $kra_config['MstPmsConfig']['hr_name'];
						$From = $managerID;
						$sub = $emp_full_name . " Mid Year Review process has been completed.";
						$msg = "This is to inform you that Mid Year Review for " . $emp_full_name . " has completed successfully. Please login the PMS portal to view report.";
						$template = 'appraisal_process_notification';
						//die;
						if (isset($To)) {			
							$this->send_mail($From, $To, $CC, $sub, $msg, $template, $data);
						}
						$contact_number = $empDetails['MyProfile']['contact'];
						 if (isset($contact_number) && preg_match("/^[789]\d{9}$/", $contact_number)) {
							$msg="Mid Year Review completed for " . $emp_full_name . " successfully, kindly login to portal and view report.";
							$this->Common->sendSms($contact_number, $msg);
						}
						
							$this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                            <a href="#" class="uk-alert-close uk-close"></a>Mid year KRA assessment reviewed successfully.</div>');
						} else{
							
						$success = $this->MidReviews->UpdateAll(array(
                        'MidReviews.app_review_status' => 1 ),
						array('MidReviews.emp_code' => $this->request->data['kraTargetEmpCode'], 'MidReviews.financial_year' => $kraTargetFinancialYear));
						
						$this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                            <a href="#" class="uk-alert-close uk-close"></a>Mid year KRA assessment forwarded to reviewer for review. Please review competencies too.</div>');
						}
					$kraTargetFinancialYear = base64_encode($kraTargetFinancialYear);
					$page_type = base64_encode('allmidapp');
                    $this->redirect(array('controller' => 'KraMasters', 'action' => "viewAppraiserKraTarget/$kraTargetEmpCode/$kraTargetFinancialYear/$page_type"));
                }

			}
                //die;
            }



            if ($this->request->data['submit'] == "Submit") {
				//Configure::write('debug',2);
             //   echo '<pre>';print_r($this->request->data);die;
                $total = count($this->request->data['final_status_app']);

                if ($total == 1) {
                    $totalCount = $total;
                } else {
                    $totalCount = $total - 1;
                }

                for ($i = 0; $i <= $totalCount; $i++) {

                    if ($this->request->data['final_status_app'][$i] == 0) {
                        $final_status = 0;
                    } else {
                        $final_status = 1;
                    }

                    //$final_status = $this->request->data['final_status'][$i];
                    //$commentDate = date("d-M-Y");
                    $id = $this->request->data['id'][$i];

                    $commentList = $this->Common->getKraCommentByID($id);
                    $appraiserPreComment = $commentList[0]['KraTarget']['appraiser_status_comment'];

                    if ($appraiserPreComment != "") {
                        $comment = $appraiserPreComment . "<br>" . $this->request->data['appraiser_status_comment'][$i];
                    } else {
                        $comment = $this->request->data['appraiser_status_comment'][$i];
                    }

                    if ($final_status == 0) {
                        $appraiserStatus = 3;
                        $reviewerStatus = 1;
                        $reviewer_final_status = 0;
                    } else {
                        $appraiserStatus = 5;
                        $reviewerStatus = 1;
                        $reviewer_final_status = 0;
                    }

                    $currentYear = date("Y");
					
				//	if(!isset($this->request->data['saveasdraft'] )){

                    $reviewerTotalRecords = $this->KraTarget->find('all', array('fields' => array('id'),
                        'conditions' => array('KraTarget.reviewer_status' => array(1), 'KraTarget.appraiser_status' => 5,
                            'KraTarget.appraiser_id' => $this->Auth->User('emp_code'),
                            'KraTarget.emp_code' => $kraTargetEmpCode,
                            'KraTarget.id' => $id,
                            'KraTarget.financial_year' => $currentFinancialYear)));

                    if (count($reviewerTotalRecords) == 0) {
                        $this->KraTarget->create();
                        $success = $this->KraTarget->UpdateAll(array('KraTarget.final_status' => "$final_status",
                            'KraTarget.appraiser_status_comment' => '"'.htmlentities($comment,ENT_QUOTES).'"',
                            'KraTarget.appraiser_status' => "'$appraiserStatus'",
                            //'KraTarget.reviewer_final_status' => $reviewer_final_status,
                            //'reviewer_status' => "'$reviewerStatus'",
                            'last_comment_by' => "1",
                                ), array('KraTarget.id' => $id));
                    }
				//	}
                }
				//Configure::write('debug', '2');
				if(trim($this->request->data['updateKraTarget']['feedback'])!=''){
				//echo $this->request->data['updateKraTarget']['feedback'];die;
						$KraComptencyFeedback['financial_year']= $kraTargetFinancialYear;
						$KraComptencyFeedback['emp_code']= $kraTargetEmpCode;
						$KraComptencyFeedback['kra_comp']= $this->request->data['updateKraTarget']['kra_comp'];
						$KraComptencyFeedback['feedback']= $this->request->data['updateKraTarget']['feedback'];
						$KraComptencyFeedback['phase']= 1;
						$KraComptencyFeedback['created_by']= $this->Auth->User('emp_code');
						$KraComptencyFeedback['created_date']= date("Y-m-d");
						
						$this->KraComptencyFeedback->create();
                        $this->KraComptencyFeedback->save($KraComptencyFeedback);
			}
			if(!isset($this->request->data['saveasdraft'] )){
                //Configure::write('debug', '0');
                /*                 * ******update appraisertoreviewer column to 1****************** */
                $kraDetails = $this->Common->getKraTargetDetails($kraTargetEmpCode, $kraTargetFinancialYear);

                //echo "<pre>"; print_r($kraDetails); die;
              //  echo'<br>';
               $appraiser_id = $kraDetails[0]['KraTarget']['appraiser_id'];
               // echo'<br>';
               $reviewer_id = $kraDetails[0]['KraTarget']['reviewer_id'];
                //die("wwwwwwwww");

                $totalKraCount = count($this->Common->getKraTargetDetails($kraTargetEmpCode, $kraTargetFinancialYear));
                $totalApprovedKraCount = count($this->Common->getTotalApprovedByAppraiser($kraTargetEmpCode, $kraTargetFinancialYear));
				
				 $appraiser_comp_code = $kraDetails[0]['KraTarget']['appraiser_comp_code'];
                    $reviewer_comp_code = $kraDetails[0]['KraTarget']['reviewer_comp_code'];

                    $appList = $this->EmpDetail->getEmpEmailDetails($appraiser_id, $appraiser_comp_code);
                    $managerID = $appList['UserDetail']['email'];

                    $revList = $this->EmpDetail->getEmpEmailDetails($reviewer_id, $reviewer_comp_code);
                    $reviewerID = $revList['UserDetail']['email'];

                    $empDetails = $this->EmpDetail->getEmpDetails($kraTargetEmpCode);
                    $emp_full_name = $empDetails['MyProfile']['emp_full_name'];
					$empList = $this->EmpDetail->getEmpEmailDetails($kraTargetEmpCode, $appraiser_comp_code);
                    $empID = $empList['UserDetail']['email'];

                    $appDetails = $this->EmpDetail->getEmpDetails($appraiser_id);
                    $appName = $appDetails['MyProfile']['emp_full_name'];
                   

                    $revDetails = $this->EmpDetail->getEmpDetails($reviewer_id);
                    $data['appName'] = $revDetails['MyProfile']['emp_full_name'];
					$data['logo'] ='logo_email.png';
					
                if ($totalKraCount == $totalApprovedKraCount) {

                    /////////Send Mail to reviewer for approval////

                    $To = $reviewerID;
                    $kra_config = $this->Session->read('sess_kra_config');
					$CC = $kra_config['MstPmsConfig']['hr_name'];
                    $From = $managerID;
                    $sub = "Received employee KRAs for your approval";
                    $msg = "This is to inform you that " . $emp_full_name . " has submitted, his/ her KRAs and appraiser $appName has forwarded the same to you for your approval, kindly login to portal and initiate action.";
						$template = 'kra_fill_notification';
				
						if (isset($To)) {			
							//$this->send_mail($From, $To, $CC, $sub, $msg, $template, $data);
						}
						$contact_number = $revDetails['MyProfile']['contact'];
						 if (isset($contact_number) && preg_match("/^[789]\d{9}$/", $contact_number)) {
							$msg="$appName has forwarded the  " . $emp_full_name . "'s KRAs to you for approval, kindly login to portal and initiate action.";
							$this->Common->sendSms($contact_number, $msg);
						}
						
						$this->KraTarget->create();
						
						/* $success1 = $this->KraTarget->UpdateAll(array(
							'appraiser_to_reviewer' => "1",
							'KraTarget.reviewer_status' => 5,
							'KraTarget.reviewer_final_status' => 1
						), array('KraTarget.appraiser_status' => 5,'KraTarget.emp_code' => $kraTargetEmpCode,'KraTarget.appraiser_id' => $this->Auth->User('emp_code') ));
						 */
						if($reviewer_id==0){
							
							$success1 = $this->KraTarget->UpdateAll(array(
							'appraiser_to_reviewer' => "1",
							'KraTarget.reviewer_status' => 5,
							'KraTarget.reviewer_final_status' => 1
						), array('KraTarget.appraiser_status' => 5,'KraTarget.emp_code' => $kraTargetEmpCode,'KraTarget.appraiser_id' => $this->Auth->User('emp_code') ));
						
						}else{
							
                        $success1 = $this->KraTarget->UpdateAll(array(
                            'appraiser_to_reviewer' => "1",
                                ), array('KraTarget.appraiser_status' => 5, 'KraTarget.emp_code' => $kraTargetEmpCode, 'KraTarget.appraiser_id' => $this->Auth->User('emp_code')));
                    }
                }
                if ($success) {
                    if ($totalKraCount == $totalApprovedKraCount) {
						/* $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                            <a href="#" class="uk-alert-close uk-close"></a>KRAs and targets approved successfully.</div>');
						 */	
                         if ($reviewer_id == 0) {
							$data['appName'] = 'All';
							$contact_number = $empDetails['MyProfile']['contact'];
							$To = $managerID .','. $empID ;
							$kra_config = $this->Session->read('sess_kra_config');
							$CC = $kra_config['MstPmsConfig']['hr_name'];
							$From = $managerID;
							$sub = "KRAs have been successfully approved";
							$msg = "This is to inform you that " . $emp_full_name . " KRAs have been successfully approved.";
							$template = 'kra_fill_notification';
						
								if (isset($To)) {			
									$this->send_mail($From, $To, $CC, $sub, $msg, $template, $data);
								}
								 if (isset($contact_number) && preg_match("/^[789]\d{9}$/", $contact_number)) {
									$msg="This is to inform you that " . $emp_full_name . " KRAs have been successfully approved.";
									$this->Common->sendSms($contact_number, $msg);
								}
							
							$this->KraApprovalStatus->UpdateAll(array(
                            'app_status' =>1,'rev_status' =>1 ), array('financial_year' => $kraTargetFinancialYear, 'emp_code' => $kraTargetEmpCode));
							
                            $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                            <a href="#" class="uk-alert-close uk-close"></a>KRAs and targets approved successfully.</div>');
                        } else {
							$this->KraApprovalStatus->UpdateAll(array(
                             'app_status' =>1,'rev_status' =>0 ), array('financial_year' => $kraTargetFinancialYear, 'emp_code' => $kraTargetEmpCode));
							
                            $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                            <a href="#" class="uk-alert-close uk-close"></a>KRAs and targets forwarded to reviewer for approval.</div>');
                        }
													
                    } else {
						$this->KraApprovalStatus->UpdateAll(array(
                            'emp_status' =>0 ,'app_status' =>1 ), array('financial_year' => $kraTargetFinancialYear, 'emp_code' => $kraTargetEmpCode));
							
                        $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                            <a href="#" class="uk-alert-close uk-close"></a>KRAs and targets rejected for correction.</div>');
                    }
                    $this->redirect(array('controller' => 'KraMasters', 'action' => 'viewAllAppraiserKraTarget'));
                }
			}else{
				$this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                            <a href="#" class="uk-alert-close uk-close"></a>KRAs and targets saved.</div>');
				$this->redirect(array('controller' => 'KraMasters', 'action' => 'viewAppraiserKraTarget/'.$kraTargetEmpCode.'/'.base64_encode($kraTargetFinancialYear).'/'.base64_encode('allapp').''));
				
			}
            }
        }else
		{
			$this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
			<a href="#" class="uk-alert-close uk-close"></a>No data found to process further.</div>');
			$this->redirect(array('controller' => 'users', 'action' => "dashboard"));
		}
    }

    public function updateEmpKraTarget() {
        $this->layout = 'employee-new';
		
		$this->autoRender = false;

     // Configure::write('debug','2');
      // echo "<pre>";print_r($this->request->data); die;
        if ($this->request->data) {



            if ($this->request->data['addSelfScore'] == "Submit") {
             // echo "<pre>";print_r($this->request->data);//die;
                $chievSum = 0;
				
                for ($i = 0; $i < count($this->request->data['updateEmpKraTarget']['id']); $i++) {

                    $kraTargetId = $this->request->data['updateEmpKraTarget']['id'][$i];
                    $financialYear = $this->request->data['updateEmpKraTarget']['financial_year'][$i];
                    $selfScoreActual = $this->request->data['updateEmpKraTarget']['self_score_actual'][$i];
                    $selfScoreAchiev = $this->request->data['updateEmpKraTarget']['self_score_achiev'][$i];
                    $selfScoreComment = $this->request->data['updateEmpKraTarget']['self_score_comment'][$i];
                   // $selfUpload = $this->Auth->User('emp_code') . basename($this->request->data['updateEmpKraTarget']['self_upload_' . ($i + 1) . '']['name']);

                    $kraWeightage = $this->Common->getKraWeightageByID($kraTargetId);
					
					$kra_config = $this->Session->read('sess_kra_config');
					if($kra_config['MstPmsConfig']['app_type'] == 1){
						$chievSum += $kraWeightage * $selfScoreAchiev;
					}
                    
					if($kra_config['MstPmsConfig']['app_type'] == 2){
						$chievSum += $selfScoreActual;
					}
					
                    
                    /*                     * *****************uploading documents code************************* */

                    $newfilename = time() . basename($this->request->data['updateEmpKraTarget']['self_upload_' . ($i + 1) . '']['name']);
                    $file = "uploads/KRA/" . $newfilename;
                    $filename = basename($this->request->data['updateEmpKraTarget']['self_upload_' . ($i + 1) . '']['name']);
                    $ext = strtolower(substr($filename, strrpos($filename, '.') + 1));
                    if (($ext == 'exe') || ($this->request->data['updateEmpKraTarget']['self_upload_' . ($i + 1) . '']['size'] > 2048000)) {
                        if ($this->request->data['updateEmpKraTarget']['self_upload_' . ($i + 1) . '']['size'] > 2048000) {
                            $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert=""><a href="#" class="uk-alert-close uk-close"></a>Sorry, this is invalid file, please check the size !</div>');
                        } elseif (($ext == 'exe')) {
                            $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert=""><a href="#" class="uk-alert-close uk-close"></a>Sorry, this is invalid file, please check the extention !</div>');
                        }
                        $this->redirect('/KraMasters/viewAllEmpKraTarget');
                    } else {
                        if ($this->request->data['updateEmpKraTarget']['self_upload_' . ($i + 1) . '']['name'] != '' && !empty($this->Auth->User('emp_code'))) {
                            if (move_uploaded_file($this->request->data['updateEmpKraTarget']['self_upload_' . ($i + 1) . '']['tmp_name'], $file)) {
                                $this->KraTarget->create();
                                $successSelfScore = $this->KraTarget->UpdateAll(array('KraTarget.self_score_actual' => "'$selfScoreActual'",
                                    'KraTarget.self_score_achiev' => "'$selfScoreAchiev'",
                                    'KraTarget.self_score_comment' => '"'.htmlentities($selfScoreComment,ENT_QUOTES).'"',
                                    'KraTarget.self_upload' => "'$newfilename'"), array('KraTarget.id' => $kraTargetId, 'KraTarget.financial_year' => "$financialYear"));
                            } else {
                                $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert=""><a href="#" class="uk-alert-close uk-close"></a>Document not uploaded successfully.</div>');
                                $this->redirect('/KraMasters/viewAllEmpKraTarget');
                            }
                        } else {
                            $this->KraTarget->create();
                            $successSelfScore = $this->KraTarget->UpdateAll(array('KraTarget.self_score_actual' => "'$selfScoreActual'",
                                'KraTarget.self_score_achiev' => "'$selfScoreAchiev'",
                                'KraTarget.self_score_comment' => '"'.htmlentities($selfScoreComment,ENT_QUOTES).'"'), array('KraTarget.id' => $kraTargetId, 'KraTarget.financial_year' => "$financialYear"));
                        }
                    }
                    /*                     * ******************end here************************ */
                }
				if(trim($this->request->data['updateEmpKraTarget']['feedback'])!=''){
				//echo $this->request->data['updateEmpKraTarget']['feedback'];die;
						$KraComptencyFeedback['financial_year']= $financialYear;
						$KraComptencyFeedback['emp_code']= $this->Auth->User('emp_code');
						$KraComptencyFeedback['kra_comp']= $this->request->data['updateEmpKraTarget']['kra_comp'];
						$KraComptencyFeedback['feedback']= $this->request->data['updateEmpKraTarget']['feedback'];
						$KraComptencyFeedback['phase']= 3;
						$KraComptencyFeedback['created_by']= $this->Auth->User('emp_code');
						$KraComptencyFeedback['created_date']= date("Y-m-d");
						
						$this->KraComptencyFeedback->create();
                        $this->KraComptencyFeedback->save($KraComptencyFeedback);
			}
                if ($successSelfScore && !isset($this->request->data['saveasdraft'])) {
					
					
					if($kra_config['MstPmsConfig']['app_type'] == 1){
						$totalAchiv = $chievSum / 100;
					}
                    
					if($kra_config['MstPmsConfig']['app_type'] == 2){
						$totalAchiv = $chievSum;
					}
					//echo $totalAchiv;
					$kraRatings = $this->Common->findKraRatingList();
					for($kra=0;$kra<count($kraRatings);$kra++){
						
						if($totalAchiv >= $kraRatings[0]['KraRating']['achievement_from']){
							$rating = 5;
						}else if($totalAchiv >= $kraRatings[1]['KraRating']['achievement_from'] && $totalAchiv <= $kraRatings[1]['KraRating']['achievement_to']){
							$rating = 4;
						}else if($totalAchiv >= $kraRatings[2]['KraRating']['achievement_from'] && $totalAchiv <= $kraRatings[2]['KraRating']['achievement_to']){
							$rating = 3;
						}else if($totalAchiv >= $kraRatings[3]['KraRating']['achievement_from'] && $totalAchiv <= $kraRatings[3]['KraRating']['achievement_to']){
							$rating = 2;
						}else if($totalAchiv >= $kraRatings[4]['KraRating']['achievement_from'] && $totalAchiv <= $kraRatings[4]['KraRating']['achievement_to']){
							$rating = 1;
						}else{
							$rating = 1;
						}
						break;
					}
                   /*  if ($totalAchiv < 60) {
                        $rating = 1;
                    } else if ($totalAchiv >= 60 && $totalAchiv <= 80) {
                        $rating = 2;
                    } else if ($totalAchiv >= 81 && $totalAchiv <= 100) {
                        $rating = 3;
                    } else if ($totalAchiv >= 101 && $totalAchiv <= 119) {
                        $rating = 4;
                    } else if ($totalAchiv >= 120) {
                        $rating = 5;
                    } */

                    $kraCompOverallRating['financial_year'] = $financialYear;
                    $kraCompOverallRating['emp_code'] = $this->Auth->User('emp_code');
                    $kraCompOverallRating['comp_code'] = $this->Auth->User('comp_code');
                    $kraCompOverallRating['appraiser_id'] = $this->Common->getManagerCode($kraCompOverallRating['emp_code']);
                    $kraCompOverallRating['appraiser_comp_code'] = $this->Common->getManagerCompCode($kraCompOverallRating['emp_code']);


                    $kraCompOverallRating['emp_self_overall_achiev'] = $totalAchiv;
                    $kraCompOverallRating['emp_self_overall_rating'] = $rating;
					//echo $rating;
//echo "<pre>";print_r($kraCompOverallRating); die;
                    $this->KraCompOverallRating->save($kraCompOverallRating);
                    
					 $this->AppraisalProcess->create();
					$success = $this->AppraisalProcess->UpdateAll(array(
                    'AppraisalProcess.emp_review_status' => "1",
                        ), array('AppraisalProcess.emp_code' => $this->Auth->User('emp_code'), 'AppraisalProcess.financial_year' => "$financialYear"));

					
                    /////////Send Mail////

                    $empList = $this->EmpDetail->getEmpEmailDetails($kraCompOverallRating['emp_code'], $kraCompOverallRating['comp_code']);
                    $empID = $empList['UserDetail']['email'];


                    $appList = $this->EmpDetail->getEmpEmailDetails($kraCompOverallRating['appraiser_id'], $kraCompOverallRating['appraiser_comp_code']);
                    $managerID = $appList['UserDetail']['email'];

                    $empDetails = $this->EmpDetail->getEmpDetails($kraCompOverallRating['emp_code']);
                    $data['empName'] = $empDetails['MyProfile']['emp_full_name'];


                    $emp_full_name = $empDetails['MyProfile']['emp_full_name'];

                    $appDetails = $this->EmpDetail->getEmpDetails($kraCompOverallRating['appraiser_id']);
                    $data['appName'] = $appDetails['MyProfile']['emp_full_name'];
					$data['logo'] ='logo_email.png';
                    $contact_number = $appDetails['MyProfile']['contact'];

                    $To = $managerID;
                    $kra_config = $this->Session->read('sess_kra_config');
					$CC = $kra_config['MstPmsConfig']['hr_name'];
                    $From = $empID;
                    $sub = "Received KRAs annual scores for your review";
                    $msg = "This is to inform you that " . $emp_full_name . " has submitted, his/ her KRAs annual scores, kindly login to portal and initiate action.";
                    $template = 'kra_fill_notification';

                    if (isset($To)) {
                        $this->send_mail($From, $To, $CC, $sub, $msg, $template, $data);
                    }
                     if (isset($contact_number) && preg_match("/^[789]\d{9}$/", $contact_number)) {
                        $this->Common->sendSms($contact_number, $msg);
                    }

                    ////////////////// End Send Mail ////////////////

                    $fYear = base64_encode($financialYear);
					$page_type = base64_encode('allannemp');
                    $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                        <a href="#" class="uk-alert-close uk-close"></a>KRA annual self assessment saved. Please fill development plan also to forward your assessment to appraiser successfully.</div>');
                    $this->redirect(array('controller' => 'KraMasters', 'action' => "viewKraTarget/$fYear/$page_type"));
                }else{
					$fYear = base64_encode($financialYear);
					$page_type = base64_encode('allannemp');
                    $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                        <a href="#" class="uk-alert-close uk-close"></a>KRA annual self assessment saved.</div>');
                    $this->redirect(array('controller' => 'KraMasters', 'action' => "viewKraTarget/$fYear/$page_type"));
				}
            }elseif (isset($this->request->data['addMidScore'])) {
     //   echo'hiii';echo "<pre>";print_r($this->request->data);// die;
            for ($i = 0; $i < count($this->request->data['updateEmpKraTarget']['id']); $i++) {

                $kraTargetId = $this->request->data['updateEmpKraTarget']['id'][$i];
                $financialYear = $this->request->data['updateEmpKraTarget']['financial_year'][$i];

                $mid_self_score_actual = $this->request->data['updateEmpKraTarget']['mid_self_score_actual'][$i];
                $mid_self_score_comment = $this->request->data['updateEmpKraTarget']['mid_self_score_comment'][$i];

                //$appraiserStatus = 1;
                //$empStatus = 2;

                $mid_self_actual_upload = '';
                /*                 * *****************uploading documents code************************* */
                if (is_array($this->request->data['updateEmpKraTarget']['mid_self_actual_upload_' . ($i + 1) . '']) && $this->request->data['updateEmpKraTarget']['mid_self_actual_upload_' . ($i + 1) . '']['name'] != '') {
					echo 'upload'.$i;
                    $newfilename = date('mdyhis') . basename($this->request->data['updateEmpKraTarget']['mid_self_actual_upload_' . ($i + 1) . '']['name']);

                    $file = "uploads/KRA/" . $newfilename;
                    $filename = basename($this->request->data['updateEmpKraTarget']['mid_self_actual_upload_' . ($i + 1) . '']['name']);
                    $ext = strtolower(substr($filename, strrpos($filename, '.') + 1));
                    if (($ext == 'exe') || ($this->request->data['updateEmpKraTarget']['mid_self_actual_upload_' . ($i + 1) . '']['size'] >= 2048000)) {
                        if ($this->request->data['updateEmpKraTarget']['mid_self_actual_upload_' . ($i + 1) . '']['size'] >= 2048000) {
                            $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert=""><a href="#" class="uk-alert-close uk-close"></a>Sorry, this is heavy sized file, please check the size !</div>');
                        } elseif (($ext == 'exe')) {
                            $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert=""><a href="#" class="uk-alert-close uk-close"></a>Sorry, this is invalid file, please check the extention !</div>');
                        }
                        $this->redirect("viewAllEmpKraTarget");
                    } else {
                        if (move_uploaded_file($this->request->data['updateEmpKraTarget']['mid_self_actual_upload_' . ($i + 1) . '']['tmp_name'], $file)) {
                            $mid_self_actual_upload = $newfilename;
                        } else {
                            $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert=""><a href="#" class="uk-alert-close uk-close"></a>' . ($i + 1) . $this->request->data['updateEmpKraTarget']['mid_self_actual_upload_' . ($i + 1) . '']['name'] . 'Document not uploaded successfully. Please try again.</div>');
                            $this->redirect("viewAllEmpKraTarget");
                        }
                    }
                } elseif (is_array($this->request->data['updateEmpKraTarget']['mid_self_actual_upload_' . ($i + 1) . '']) != '' && $this->request->data['updateEmpKraTarget']['mid_self_actual_upload_' . ($i + 1) . '']['name'] == '') {
                    $mid_self_actual_upload = $this->request->data['updateEmpKraTarget']['mid_self_actual_upload_pre'][$i];
                  echo 'ww';
                } elseif (!is_array($this->request->data['updateEmpKraTarget']['mid_self_actual_upload_' . ($i + 1) . ''])) {
                    $mid_self_actual_upload = $this->request->data['updateEmpKraTarget']['mid_self_actual_upload_' . ($i + 1) . ''];

                   echo 'pp';
                }
                /*                 * ******************end here************************ */
//Configure::write('debug','2');	
              // echo ($i + 1) . ' ' . $mid_self_actual_upload . '<br>';
                $this->KraTarget->create();
                $success = $this->KraTarget->UpdateAll(array(
                    'KraTarget.mid_self_actual_upload' => "'$mid_self_actual_upload'",
                    'KraTarget.mid_self_score_actual' => "'$mid_self_score_actual'",
                    'KraTarget.mid_self_score_comment' => '"'.htmlentities($mid_self_score_comment,ENT_QUOTES).'"',
                        ), array('KraTarget.id' => $kraTargetId, 'KraTarget.financial_year' => "$financialYear"));
            }
			// die;
			if(trim($this->request->data['updateEmpKraTarget']['feedback'])!=''){
				//echo $this->request->data['updateEmpKraTarget']['feedback'];die;
						$KraComptencyFeedback['financial_year']= $financialYear;
						$KraComptencyFeedback['emp_code']= $this->Auth->User('emp_code');
						$KraComptencyFeedback['kra_comp']= $this->request->data['updateEmpKraTarget']['kra_comp'];
						$KraComptencyFeedback['feedback']= $this->request->data['updateEmpKraTarget']['feedback'];
						$KraComptencyFeedback['phase']= 2;
						$KraComptencyFeedback['created_by']= $this->Auth->User('emp_code');
						$KraComptencyFeedback['created_date']= date("Y-m-d");
						
						$this->KraComptencyFeedback->create();
                        $this->KraComptencyFeedback->save($KraComptencyFeedback);
			}
            if(isset($this->request->data['saveasdraft'])){
				$this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                        <a href="#" class="uk-alert-close uk-close"></a>Mid Review has been saved.</div>');
               
			}else{
				
            if ($success) {
						/////////Send Mail to appraiser for mid score review////
						//echo $this->request->data['mid_emp_code'];
						$kraDetails = $this->Common->getKraTargetDetails($this->request->data['updateEmpKraTarget']['mid_emp_code'], $financialYear);
						
						$empList = $this->EmpDetail->getEmpEmailDetails( $kraDetails[0]['KraTarget']['emp_code'],$kraDetails[0]['KraTarget']['comp_code']);
						$empID = $empList['UserDetail']['email'];
						$empDetails = $this->EmpDetail->getEmpDetails($this->request->data['updateEmpKraTarget']['mid_emp_code']);
						$emp_full_name = $empDetails['MyProfile']['emp_full_name'];
						
				
						$appList = $this->EmpDetail->getEmpEmailDetails( $kraDetails[0]['KraTarget']['appraiser_id'],$kraDetails[0]['KraTarget']['appraiser_comp_code']);
						$managerID = $appList['UserDetail']['email'];
						$appDetails = $this->EmpDetail->getEmpDetails($kraDetails[0]['KraTarget']['appraiser_id']);
						$appName = $appDetails['MyProfile']['emp_full_name'];
						
						$data['name'] = $appDetails['MyProfile']['emp_full_name'];
						$data['logo'] ='logo_email.png';
						//echo "<pre>";print_r($appDetails);die;
						$contact_number = $appDetails['MyProfile']['contact'];
						
						$To = $managerID;
						$kra_config = $this->Session->read('sess_kra_config');
						$CC = $kra_config['MstPmsConfig']['hr_name'];
						$From = $empID;
						$sub = "Received Mid-Year KRAS for your Assessment";
						$msg = "This is to inform you that " . $emp_full_name . " has submitted, his/ her mid year KRAs for your assessment, kindly login to portal and initiate action.";
						$template = 'appraisal_process_notification';
				//die;
						if (isset($To)) {			
							$this->send_mail($From, $To, $CC, $sub, $msg, $template, $data);
						}
						 if (isset($contact_number) && preg_match("/^[789]\d{9}$/", $contact_number)) {
							$msg ="" . $emp_full_name . " has submitted, his/ her mid year KRAs for your assessment, kindly login to portal and initiate action.";
							$this->Common->sendSms($contact_number, $msg);
						}
							
					

                $this->MidReviews->create();
                $success = $this->MidReviews->UpdateAll(array(
                    'MidReviews.emp_review_status' => "1",
                        ), array('MidReviews.emp_code' => $this->Auth->User('emp_code'), 'MidReviews.financial_year' => "$financialYear"));

                
            }
			    $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                        <a href="#" class="uk-alert-close uk-close"></a>Mid year assessment forwarded to appraiser for review.</div>');
			}
			$fYear = base64_encode($financialYear);
				$page_type = base64_encode('allmidemp');
			 $this->redirect(array('controller' => 'KraMasters', 'action' => "viewKraTarget/$fYear/$page_type"));
            
        }elseif (isset($this->request->data['submit'])) {
			$kraTarget = array();
			//Configure::write("debug",2);
            //echo "<pre>";print_r($this->request->data);//die;
            for ($i = 0; $i < count($this->request->data['updateEmpKraTarget']['id']); $i++) {

                $kraTargetId = $this->request->data['updateEmpKraTarget']['id'][$i];
                $financialYear = $this->request->data['updateEmpKraTarget']['financial_year'][$i];
                $kraName = htmlentities($this->request->data['updateEmpKraTarget']['kra_name'][$i],ENT_QUOTES);
                $weightage = $this->request->data['updateEmpKraTarget']['weightage'][$i];
               $measure = htmlentities($this->request->data['updateEmpKraTarget']['measure'][$i],ENT_QUOTES);

                $qualifying = htmlentities($this->request->data['updateEmpKraTarget']['qualifying'][$i],ENT_QUOTES);
                $measure_type = $this->request->data['updateEmpKraTarget']['measure_type_' . ($i + 1)];
                $target = htmlentities($this->request->data['updateEmpKraTarget']['target'][$i],ENT_QUOTES);
                $stretched = htmlentities($this->request->data['updateEmpKraTarget']['stretched'][$i],ENT_QUOTES);
                $mid_target = htmlentities($this->request->data['updateEmpKraTarget']['mid_target'][$i],ENT_QUOTES);

                $commentList = $this->Common->getKraCommentByID($id);
                $empPreComment = $commentList[0]['KraTarget']['emp_status_comment'];

                if ($empPreComment != "") {
                    $empStatusComment = $empPreComment . "<br>" . htmlentities($this->request->data['updateEmpKraTarget']['emp_status_comment'][$i],ENT_QUOTES);
                } else {
                    $empStatusComment = htmlentities($this->request->data['updateEmpKraTarget']['emp_status_comment'][$i],ENT_QUOTES);
                }


                $appraiserStatus = 1;
                $empStatus = 2;

                $kra_upload = '';
                /*                 * *****************uploading documents code************************* */
                if (is_array($this->request->data['updateEmpKraTarget']['kra_upload_' . ($i + 1) . '']) && $this->request->data['updateEmpKraTarget']['kra_upload_' . ($i + 1) . '']['name'] != '') {
                    echo 'dd';

                    $newfilename = time() . basename($this->request->data['updateEmpKraTarget']['kra_upload_' . ($i + 1) . '']['name']);

                    $file = "uploads/KRA/" . $newfilename;
                    $filename = basename($this->request->data['updateEmpKraTarget']['kra_upload_' . ($i + 1) . '']['name']);
                    $ext = strtolower(substr($filename, strrpos($filename, '.') + 1));
                    if (($ext == 'exe') || ($this->request->data['updateEmpKraTarget']['kra_upload_' . ($i + 1) . '']['size'] >= 2048000)) {
                        if ($this->request->data['updateEmpKraTarget']['kra_upload_' . ($i + 1) . '']['size'] >= 2048000) {
                            $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert=""><a href="#" class="uk-alert-close uk-close"></a>Sorry, this is heavy sized file, please check the size !</div>');
                        } elseif (($ext == 'exe')) {
                            $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert=""><a href="#" class="uk-alert-close uk-close"></a>Sorry, this is invalid file, please check the extention !</div>');
                        }
                        $this->redirect("viewAllEmpKraTarget");
                    } else {
                        if (move_uploaded_file($this->request->data['updateEmpKraTarget']['kra_upload_' . ($i + 1) . '']['tmp_name'], $file)) {
                            $kra_upload = $newfilename;
                        } else {
                            $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert=""><a href="#" class="uk-alert-close uk-close"></a>' . ($i + 1) . $this->request->data['updateEmpKraTarget']['kra_upload_' . ($i + 1) . '']['name'] . 'Document not uploaded successfully. Please try again.</div>');
                            $this->redirect("viewAllEmpKraTarget");
                        }
                    }
                } elseif (is_array($this->request->data['updateEmpKraTarget']['kra_upload_' . ($i + 1) . '']) != '' && $this->request->data['updateEmpKraTarget']['kra_upload_' . ($i + 1) . '']['name'] == '') {
                    $kra_upload = $this->request->data['updateEmpKraTarget']['kra_upload_fix'][$i];
                    echo 'ww';
                } elseif (!is_array($this->request->data['updateEmpKraTarget']['kra_upload_' . ($i + 1) . ''])) {
                    $kra_upload = $this->request->data['updateEmpKraTarget']['kra_upload_' . ($i + 1) . ''];

                    echo 'pp';
                }
                /*                 * ******************end here************************ */
//Configure::write('debug','2');	
             //   echo ($i + 1) . ' ' . $kra_upload . '<br>'; //die;
                $this->KraTarget->create();

$data = $this->Common->findFInancialYearDesc($this->Auth->User('comp_code'));
        $currentFinancialYear = $data['FinancialYear']['id'];

			if(trim($this->request->data['updateEmpKraTarget']['feedback'])!=''){
				//echo $this->request->data['updateEmpKraTarget']['feedback'];die;
						$KraComptencyFeedback['financial_year']= $currentFinancialYear;
						$KraComptencyFeedback['emp_code']= $this->Auth->User('emp_code');
						$KraComptencyFeedback['kra_comp']= $this->request->data['updateEmpKraTarget']['kra_comp'];
						$KraComptencyFeedback['feedback']= $this->request->data['updateEmpKraTarget']['feedback'];
						$KraComptencyFeedback['phase']= 1;
						$KraComptencyFeedback['created_by']= $this->Auth->User('emp_code');
						$KraComptencyFeedback['created_date']= date("Y-m-d");
						
						$this->KraComptencyFeedback->create();
                        $this->KraComptencyFeedback->save($KraComptencyFeedback);
			}

                if ($this->request->data['updateEmpKraTarget']['id'][$i] != '') {
					//die("wwwwwww");
					//echo htmlentities("No's",ENT_QUOTES);die;
                    $success = $this->KraTarget->UpdateAll(array('KraTarget.kra_name' => "'$kraName'",
                        'KraTarget.weightage' => "'$weightage'",
                        'KraTarget.measure' => "'$measure'",
                        'KraTarget.kra_upload' => "'$kra_upload'",
                        'KraTarget.qualifying' => "'$qualifying'",
                        'KraTarget.measure_type' => "'$measure_type'",
                        'KraTarget.target' => "'$target'",
                        'KraTarget.stretched' => "'$stretched'",
                        'KraTarget.mid_self_target' => "'$mid_target'",
                        'KraTarget.emp_status_comment' => '"'.htmlentities($empStatusComment,ENT_QUOTES).'"', 
                        'KraTarget.appraiser_status' => "'$appraiserStatus'",
                        'KraTarget.emp_status' => "'$empStatus'"), array('KraTarget.id' => $kraTargetId, 'KraTarget.financial_year' => "$financialYear"));
                } else {
					//die("sssssssss");
                    $data = $this->Common->findFInancialYearDesc($this->Auth->User('comp_code'));
                    $currentFinancialYear = $data['FinancialYear']['id'];

                    $kraTarget['kra_name'] = htmlentities($this->request->data['updateEmpKraTarget']['kra_name'][$i],ENT_QUOTES);
                    $kraTarget['financial_year'] = "$currentFinancialYear";
                    $kraTarget['weightage'] = $this->request->data['updateEmpKraTarget']['weightage'][$i];
                    $kraTarget['measure'] = htmlentities($this->request->data['updateEmpKraTarget']['measure'][$i],ENT_QUOTES);
                    $kraTarget['qualifying'] = htmlentities($this->request->data['updateEmpKraTarget']['qualifying'][$i],ENT_QUOTES);
                    $kraTarget['measure_type'] = $this->request->data['updateEmpKraTarget']['measure_type_' . ($i + 1)];
                    $kraTarget['target'] = htmlentities($this->request->data['updateEmpKraTarget']['target'][$i],ENT_QUOTES);
                    $kraTarget['stretched'] = htmlentities($this->request->data['updateEmpKraTarget']['stretched'][$i],ENT_QUOTES);
                    $kraTarget['mid_self_target'] = htmlentities($this->request->data['updateEmpKraTarget']['mid_target'][$i],ENT_QUOTES);
					$kraTarget['emp_status_comment'] = htmlentities($empStatusComment,ENT_QUOTES);
                    $kraTarget['emp_code'] = $this->Auth->User('emp_code');
                    $kraTarget['comp_code'] = $this->Auth->User('comp_code');
                    $kraTarget['appraiser_id'] = $this->Common->getManagerCode($kraTarget['emp_code']);
                    $kraTarget['appraiser_comp_code'] = $this->Common->getManagerCompCode($kraTarget['emp_code']);
                    $kraTarget['appraiser_status'] = 1;

                    $reviewer_id = $this->Common->getManagerCode($kraTarget['appraiser_id']);
                    if ($reviewer_id != "" || $reviewer_id != 0) {
                        $kraTarget['reviewer_id'] = $this->Common->getManagerCode($kraTarget['appraiser_id']);
                        $kraTarget['reviewer_comp_code'] = $this->Common->getManagerCompCode($kraTarget['appraiser_id']);
                    } else {
                        $kraTarget['reviewer_id'] = 0;
                        $kraTarget['reviewer_comp_code'] = 0;
                    }

                    $kraTarget['reviewer_status'] = 0;

                    $moderator_id = $this->Common->getManagerCode($kraTarget['reviewer_id']);
                    if ($moderator_id != "" || $moderator_id != 0) {
                        $kraTarget['moderator_id'] = $this->Common->getManagerCode($kraTarget['reviewer_id']);
                        $kraTarget['moderator_comp_code'] = $this->Common->getManagerCompCode($kraTarget['moderator_id']);
                    } else {
                        $kraTarget['moderator_id'] = 0;
                        $kraTarget['moderator_comp_code'] = 0;
                    }

                    $kraTarget['moderator_status'] = 0;
                    $kraTarget['emp_status'] = 2;
                    $kraTarget['final_status'] = 0;
                    $kraTarget['created_date'] = date("Y-m-d");
                    $kraTarget['kra_upload'] = $kra_upload;

                    $success = $this->KraTarget->save($kraTarget);
                }
            }
            //die;
            if ($success) {
				$this->KraApprovalStatus->UpdateAll(array('emp_status' =>1,'app_status' =>0 ), array('financial_year' => $currentFinancialYear, 'emp_code' => $this->Auth->User('emp_code')));	
                $fYear = base64_encode($financialYear);
                $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                        <a href="#" class="uk-alert-close uk-close"></a>KRA targets forwarded to appraiser for approval.</div>');
                $this->redirect(array('controller' => 'KraMasters', 'action' => "viewAllEmpKraTarget"));
            }
        }
        }else
		{
			$this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
			<a href="#" class="uk-alert-close uk-close"></a>No data found to process further.</div>');
			$this->redirect(array('controller' => 'users', 'action' => "dashboard"));
		}
    }

    public function updateReviewerKraTarget() {
        $this->layout = 'employee-new';

        if ($this->request->data) {

            //echo "<pre>";
            //print_r($this->request->data);
            //die;

            $kraTargetEmpCode = $this->request->data['kraTargetEmpCode'];
            $financialYear = $this->request->data['kraTargetFinancialYear'];

            $kraTargetFinancialYear = base64_decode($this->request->data['kraTargetFinancialYear']);
		
            /// Start Update Reviewer Score // 
            $reviewerAchievSum = 0;
            if ($this->request->data['reviewerSelfScore'] == "Submit") {

                for ($i = 0; $i < count($this->request->data['updateReviewerKraTarget']['id']); $i++) {

                    $kraTargetId = $this->request->data['updateReviewerKraTarget']['id'][$i];
					$reviewerScoreActual = $this->request->data['updateReviewerKraTarget']['reviewer_score_actual'][$i];
                    $reviewerScoreAchiev = $this->request->data['updateReviewerKraTarget']['reviewer_score_achiev'][$i];
                    $reviewerScoreComment = $this->request->data['updateReviewerKraTarget']['reviewer_score_comment'][$i];

                    $kraWeightage = $this->Common->getKraWeightageByID($kraTargetId);
					
					$kra_config = $this->Session->read('sess_kra_config');
					if($kra_config['MstPmsConfig']['app_type'] == 1){
						$reviewerAchievSum += $kraWeightage * $reviewerScoreAchiev;
					}

					if($kra_config['MstPmsConfig']['app_type'] == 2){
						$reviewerAchievSum += $reviewerScoreActual;
					}
					

                    $moderator_id = $this->Common->getManagerCode($this->Auth->User('emp_code'));
                    $moderator_comp_code = $this->Common->getManagerCompCode($this->Auth->User('emp_code'));
                    $this->KraTarget->create();

                    if ($moderator_id == 0) {
                        $successSelfScore = $this->KraTarget->UpdateAll(array(
							'KraTarget.moderator_score_actual' => "'$reviewerScoreActual'",
                            'KraTarget.moderator_score_achiev' => "'$reviewerScoreAchiev'",
                            'KraTarget.moderator_score_comment' => '"'.htmlentities($reviewerScoreComment,ENT_QUOTES).'"'), array('KraTarget.id' => $kraTargetId, 'KraTarget.financial_year' => $kraTargetFinancialYear));
                    }

                    $successSelfScore = $this->KraTarget->UpdateAll(array(
						'KraTarget.reviewer_score_actual' => "'$reviewerScoreActual'",
                        'KraTarget.reviewer_score_achiev' => "'$reviewerScoreAchiev'",
                        'KraTarget.reviewer_score_comment' => '"'.htmlentities($reviewerScoreComment,ENT_QUOTES).'"'), array('KraTarget.id' => $kraTargetId, 'KraTarget.financial_year' => "$kraTargetFinancialYear"));
                }
				
				if(trim($this->request->data['updateReviewerKraTarget']['feedback'])!=''){
				//echo $this->request->data['updateReviewerKraTarget']['feedback'];die;
						$KraComptencyFeedback['financial_year']= $kraTargetFinancialYear;
						$KraComptencyFeedback['emp_code']= $kraTargetEmpCode;
						$KraComptencyFeedback['kra_comp']= $this->request->data['updateReviewerKraTarget']['kra_comp'];
						$KraComptencyFeedback['feedback']= $this->request->data['updateReviewerKraTarget']['feedback'];
						$KraComptencyFeedback['phase']= 3;
						$KraComptencyFeedback['created_by']= $this->Auth->User('emp_code');
						$KraComptencyFeedback['created_date']= date("Y-m-d");
						
						$this->KraComptencyFeedback->create();
                        $this->KraComptencyFeedback->save($KraComptencyFeedback);
			}
				
                if ($successSelfScore && !isset($this->request->data['saveasdraft'])) {

                   /*  $totalReviewerAchiv = $reviewerAchievSum / 100;

                    if ($totalReviewerAchiv < 60) {
                        $reviewerRating = 1;
                    } else if ($totalReviewerAchiv >= 60 && $totalReviewerAchiv <= 80) {
                        $reviewerRating = 2;
                    } else if ($totalReviewerAchiv >= 81 && $totalReviewerAchiv <= 100) {
                        $reviewerRating = 3;
                    } else if ($totalReviewerAchiv >= 101 && $totalReviewerAchiv <= 119) {
                        $reviewerRating = 4;
                    } else if ($totalReviewerAchiv >= 120) {
                        $reviewerRating = 5;
                    } */
					
				
					if($kra_config['MstPmsConfig']['app_type'] == 1){
						$totalReviewerAchiv = $reviewerAchievSum / 100;
					}

					if($kra_config['MstPmsConfig']['app_type'] == 2){
						$totalReviewerAchiv = $reviewerAchievSum;
					}


					$kraRatings = $this->Common->findKraRatingList();
					for($kra=0;$kra<count($kraRatings);$kra++){
						
						if($totalReviewerAchiv >= $kraRatings[0]['KraRating']['achievement_from']){
							$reviewerRating = 5;
						}else if($totalReviewerAchiv >= $kraRatings[1]['KraRating']['achievement_from'] && $totalReviewerAchiv <= $kraRatings[1]['KraRating']['achievement_to']){
							$reviewerRating = 4;
						}else if($totalReviewerAchiv >= $kraRatings[2]['KraRating']['achievement_from'] && $totalReviewerAchiv <= $kraRatings[2]['KraRating']['achievement_to']){
							$reviewerRating = 3;
						}else if($totalReviewerAchiv >= $kraRatings[3]['KraRating']['achievement_from'] && $totalReviewerAchiv <= $kraRatings[3]['KraRating']['achievement_to']){
							$reviewerRating = 2;
						}else if($totalReviewerAchiv >= $kraRatings[4]['KraRating']['achievement_from'] && $totalReviewerAchiv <= $kraRatings[4]['KraRating']['achievement_to']){
							$reviewerRating = 1;
						}else{
							$reviewerRating = 1;
						}
						break;
					}

                    $list = $this->Common->getKraCompOverallRating($kraTargetEmpCode, $kraTargetFinancialYear);

                    $empKRAOverallRating = $list[0]['KraCompOverallRating']['emp_self_overall_rating'];
                    $appraiserKRAOverallRating = $list[0]['KraCompOverallRating']['appraiser_self_overall_rating'];
	
					if($kra_config['MstPmsConfig']['app_type'] == 1){
						$kraOverallRating = ($empKRAOverallRating + $appraiserKRAOverallRating + $reviewerRating + $reviewerRating) / 4;
					}

					if($kra_config['MstPmsConfig']['app_type'] == 2){
						$kraOverallRating = $reviewerRating;
					}

                    $kraCompOverallRating['moderator_id'] = $this->Common->getManagerCode($this->Auth->User('emp_code'));
                    $kraCompOverallRating['moderator_comp_code'] = $this->Common->getManagerCompCode($this->Auth->User('emp_code'));
//echo $totalReviewerAchiv;die;
                    if ($kraCompOverallRating['moderator_id'] == 0) {
                        $this->KraCompOverallRating->UpdateAll(array(
                            'KraCompOverallRating.reviewer_self_overall_achiev' => "'$totalReviewerAchiv'",
                            'KraCompOverallRating.reviewer_self_overall_rating' => "'$reviewerRating'",
                            'KraCompOverallRating.moderator_self_overall_achiev' => "'$totalReviewerAchiv'",
                            'KraCompOverallRating.moderator_self_overall_rating' => "'$reviewerRating'",
                            'KraCompOverallRating.kra_overall_rating' => $kraOverallRating), array('KraCompOverallRating.emp_code' => $kraTargetEmpCode,
                            'KraCompOverallRating.reviewer_id' => $this->Auth->User('emp_code'),
                            'KraCompOverallRating.financial_year' => $kraTargetFinancialYear));
                    } else {

                        $this->KraCompOverallRating->UpdateAll(array(
                            'KraCompOverallRating.reviewer_self_overall_achiev' => "'$totalReviewerAchiv'",
                            'KraCompOverallRating.reviewer_self_overall_rating' => "'$reviewerRating'",
                            'KraCompOverallRating.moderator_id' => $kraCompOverallRating['moderator_id'],
                            'KraCompOverallRating.moderator_comp_code' => $kraCompOverallRating['moderator_comp_code']), array('KraCompOverallRating.emp_code' => $kraTargetEmpCode,
                            'KraCompOverallRating.reviewer_id' => $this->Auth->User('emp_code'),
                            'KraCompOverallRating.financial_year' => $kraTargetFinancialYear));
                    }

						$kraDetails = $this->Common->getKraTargetDetails($kraTargetEmpCode, $kraTargetFinancialYear);
						
						$appList = $this->EmpDetail->getEmpEmailDetails( $kraDetails[0]['KraTarget']['appraiser_id'],$kraDetails[0]['KraTarget']['appraiser_comp_code']);
						$managerID = $appList['UserDetail']['email'];
						$appDetails = $this->EmpDetail->getEmpDetails($kraDetails[0]['KraTarget']['appraiser_id']);
						$appName = $appDetails['MyProfile']['emp_full_name'];
						
						$revList = $this->EmpDetail->getEmpEmailDetails( $kraDetails[0]['KraTarget']['reviewer_id'],$kraDetails[0]['KraTarget']['reviewer_comp_code']);
						$revID = $revList['UserDetail']['email'];
						$revDetails = $this->EmpDetail->getEmpDetails( $kraDetails[0]['KraTarget']['reviewer_id']);
						$rev_full_name = $revDetails['MyProfile']['emp_full_name'];
						
						$modList = $this->EmpDetail->getEmpEmailDetails( $kraDetails[0]['KraTarget']['moderator_id'],$kraDetails[0]['KraTarget']['moderator_comp_code']);
						$modID = $modList['UserDetail']['email'];
						$modDetails = $this->EmpDetail->getEmpDetails($kraDetails[0]['KraTarget']['moderator_id']);				
						
						$empDetails = $this->EmpDetail->getEmpDetails( $kraDetails[0]['KraTarget']['emp_code']);
						$empList = $this->EmpDetail->getEmpEmailDetails( $kraDetails[0]['KraTarget']['emp_code'],$kraDetails[0]['KraTarget']['comp_code']);
						$empID = $empList['UserDetail']['email'];
						$emp_full_name = $empDetails['MyProfile']['emp_full_name'];
						
						
						$data['name'] = $modDetails['MyProfile']['emp_full_name'];
						$data['logo'] ='logo_email.png';
						//echo "<pre>";print_r($appDetails);die;
						$contact_number = $modDetails['MyProfile']['contact'];
						
						$To = $modID;
						$kra_config = $this->Session->read('sess_kra_config');
						$CC = $kra_config['MstPmsConfig']['hr_name'];
						$From = $revID;
						$sub = "Received KRAs annual scores for your review";
						$msg = "This is to inform you that " . $emp_full_name . " has submitted, his/ her annual KRAs assessment for your review, kindly login to portal and initiate action.";
						$template = 'appraisal_process_notification';
						//die;
						if (isset($To)) {			
							//$this->send_mail($From, $To, $CC, $sub, $msg, $template, $data);
						}
						 if (isset($contact_number) && preg_match("/^[789]\d{9}$/", $contact_number)) {
							$this->Common->sendSms($contact_number, $msg);
						}
						if(empty($kraDetails[0]['KraTarget']['moderator_id']) || $kraDetails[0]['KraTarget']['moderator_id']=="" || $kraDetails[0]['KraTarget']['moderator_id']==0){
							$To = $managerID.",".$empID;
							$kra_config = $this->Session->read('sess_kra_config');
							$CC = $kra_config['MstPmsConfig']['hr_name'];
							$From = $revID;
							$sub = "Your appraisal has been completed";
							$msg = "This is to inform you that " . $emp_full_name . " appraisal process has been completed, kindly login to portal to view the scores.";
							$template = 'appraisal_process_notification';
							//die;
							if (isset($To)) {			
								//$this->send_mail($From, $To, $CC, $sub, $msg, $template, $data);
							}
							$contact_number = $empDetails['MyProfile']['contact'];
							 if (isset($contact_number) && preg_match("/^[789]\d{9}$/", $contact_number)) {
								$msg="This is to inform you that your appraisal process has been completed, kindly login to portal to view the scores.";
								$this->Common->sendSms($contact_number, $msg);
							}
							
							$success = $this->AppraisalProcess->UpdateAll(array(
							'AppraisalProcess.rev_review_status' => "1",
							'AppraisalProcess.mod_review_status' => "1",
                        ), array('AppraisalProcess.emp_code' => $kraTargetEmpCode, 'AppraisalProcess.financial_year' => "$kraTargetFinancialYear"));


							$this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                            <a href="#" class="uk-alert-close uk-close"></a>KRA annual self score saved. Please fill competency ratings to complete the appraisal.</div>');
							$page_type=base64_encode('allannrev');
						}else{
							$success = $this->AppraisalProcess->UpdateAll(array(
							'AppraisalProcess.rev_review_status' => "1",
                        ), array('AppraisalProcess.emp_code' => $kraTargetEmpCode, 'AppraisalProcess.financial_year' => "$kraTargetFinancialYear"));

							$this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                            <a href="#" class="uk-alert-close uk-close"></a>KRA annual self score forwarded to moderator successfully. Do not forget to fill competency ratings.</div>');
							$page_type=base64_encode('allannrev');
						}
					
                    $this->redirect(array('controller' => 'KraMasters', 'action' => "viewReviewerKraTarget/$kraTargetEmpCode/".base64_encode($kraTargetFinancialYear)."/$page_type"));
                }else{
					$this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                            <a href="#" class="uk-alert-close uk-close"></a>KRA annual self score saved.</div>');
							$page_type=base64_encode('allannrev');
				$this->redirect(array('controller' => 'KraMasters', 'action' => "viewReviewerKraTarget/$kraTargetEmpCode/".base64_encode($kraTargetFinancialYear)."/$page_type"));	
				}
            }
			
			if ($this->request->data['addMidRevSelfScore'] == "Submit") {
				//Configure::write('debug','2');
			//	echo '<pre>';print_r($this->request->data);//die;
				
				for ($i = 0; $i < count($this->request->data['id']); $i++) {
					$comm= $this->request->data['mid_reviewer_score_comment'][$i];
					$mid_rev_actual_upload='';
					if ($this->request->data['mid_rev_actual_upload_' . ($i + 1) . ''] != '') {
						//print_r($this->request->data['mid_rev_actual_upload_' . ($i + 1) . '']);//die;
						  /*                 * *****************uploading documents code************************* */
                if (is_array($this->request->data['mid_rev_actual_upload_' . ($i + 1) . '']) && $this->request->data['mid_rev_actual_upload_' . ($i + 1) . '']['name'] != '') {
                    $newfilename = time() . basename($this->request->data['mid_rev_actual_upload_' . ($i + 1) . '']['name']);

                   echo $file = "uploads/KRA/" . $newfilename;
				   echo '<br>';
                    $filename = basename($this->request->data['mid_rev_actual_upload_' . ($i + 1) . '']['name']);
                    $ext = strtolower(substr($filename, strrpos($filename, '.') + 1));
                    if (($ext == 'exe') || ($this->request->data['mid_rev_actual_upload_' . ($i + 1) . '']['size'] >= 2048000)) {
                        if ($this->request->data['mid_rev_actual_upload_' . ($i + 1) . '']['size'] >= 2048000) {
                            $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert=""><a href="#" class="uk-alert-close uk-close"></a>Sorry, this is heavy sized file, please check the size !</div>');
                        } elseif (($ext == 'exe')) {
                            $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert=""><a href="#" class="uk-alert-close uk-close"></a>Sorry, this is invalid file, please check the extention !</div>');
                        }
                        $this->redirect("viewAllMidReviewerKraTarget");
                    } else {
                        if (move_uploaded_file($this->request->data['mid_rev_actual_upload_' . ($i + 1) . '']['tmp_name'], $file)) {
                            $mid_rev_actual_upload = $newfilename;
                        } else {
                            $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert=""><a href="#" class="uk-alert-close uk-close"></a>' . ($i + 1) . $this->request->data['mid_rev_actual_upload_' . ($i + 1) . '']['name'] . 'Document not uploaded successfully. Please try again.</div>');
                            $this->redirect("viewAllMidReviewerKraTarget");
                        }
                    }
                } elseif (is_array($this->request->data['mid_rev_actual_upload_' . ($i + 1) . '']) != '' && $this->request->data['mid_rev_actual_upload_' . ($i + 1) . '']['name'] == '') {
                    $mid_rev_actual_upload = $this->request->data['updateReviewerKraTarget']['mid_rev_actual_upload_pre'][$i];
                 //   echo 'ww';echo '<br>';
                } elseif (!is_array($this->request->data['mid_rev_actual_upload_' . ($i + 1) . ''])) {
                    $mid_rev_actual_upload = $this->request->data['mid_rev_actual_upload_' . ($i + 1) . ''];

               //    echo 'pp';echo '<br>';
                }
				
					}
					//echo $mid_rev_actual_upload;
					  $successAppMid = $this->KraTarget->UpdateAll(array(
					  'KraTarget.mid_rev_actual_upload' => '"'.$mid_rev_actual_upload.'"',
                        'KraTarget.mid_reviewer_score_comment' => '"'.htmlentities($comm,ENT_QUOTES).'"' ), 
						array('KraTarget.id' => $this->request->data['id'][$i], 'KraTarget.financial_year' => $kraTargetFinancialYear));					 
				}
				//die;
				if(trim($this->request->data['updateReviewerKraTarget']['feedback'])!=''){
				//echo $this->request->data['updateReviewerKraTarget']['feedback'];die;
						$KraComptencyFeedback['financial_year']= $kraTargetFinancialYear;
						$KraComptencyFeedback['emp_code']= $kraTargetEmpCode;
						$KraComptencyFeedback['kra_comp']= $this->request->data['updateReviewerKraTarget']['kra_comp'];
						$KraComptencyFeedback['feedback']= $this->request->data['updateReviewerKraTarget']['feedback'];
						$KraComptencyFeedback['phase']= 2;
						$KraComptencyFeedback['created_by']= $this->Auth->User('emp_code');
						$KraComptencyFeedback['created_date']= date("Y-m-d");
						
						$this->KraComptencyFeedback->create();
                        $this->KraComptencyFeedback->save($KraComptencyFeedback);
			}
			$page_type = base64_encode('allmidrev');
			if(isset($this->request->data['saveasdraft'])){
				$this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                        <a href="#" class="uk-alert-close uk-close"></a>Mid Review has been saved.</div>');
						$financialYear = base64_encode($kraTargetFinancialYear);
						
                    $this->redirect(array('controller' => 'KraMasters', 'action' => "viewReviewerKraTarget/$kraTargetEmpCode/$financialYear/$page_type"));
               
			}else{
			
				 /////////Send Mail to reviewer for mid score review////
						//echo "<pre>";print_r($this->request->data);//die;
						$kraDetails = $this->Common->getKraTargetDetails($this->request->data['kraTargetEmpCode'], $kraTargetFinancialYear);
						
						$revList = $this->EmpDetail->getEmpEmailDetails( $kraDetails[0]['KraTarget']['reviewer_id'],$kraDetails[0]['KraTarget']['reviewer_comp_code']);
						$revID = $revList['UserDetail']['email'];
						$revDetails = $this->EmpDetail->getEmpDetails( $kraDetails[0]['KraTarget']['reviewer_id']);
						$rev_full_name = $revDetails['MyProfile']['emp_full_name'];
						
						$modList = $this->EmpDetail->getEmpEmailDetails( $kraDetails[0]['KraTarget']['moderator_id'],$kraDetails[0]['KraTarget']['moderator_comp_code']);
						$modID = $modList['UserDetail']['email'];
						$modDetails = $this->EmpDetail->getEmpDetails($kraDetails[0]['KraTarget']['moderator_id']);
						$modName = $modDetails['MyProfile']['emp_full_name'];
						
						$empDetails = $this->EmpDetail->getEmpDetails( $kraDetails[0]['KraTarget']['emp_code']);
						$emp_full_name = $empDetails['MyProfile']['emp_full_name'];
						
						$data['name'] = $modDetails['MyProfile']['emp_full_name'];
						$data['logo'] ='logo_email.png';
						//echo "<pre>";print_r($modID);die;
						$contact_number = $modDetails['MyProfile']['contact'];
						
						$To = $modID;
						$kra_config = $this->Session->read('sess_kra_config');
						$CC = $kra_config['MstPmsConfig']['hr_name'];
						$From = $revID;
						$sub = "Received Mid Year KRAS for your moderation";
						$msg = "This is to inform you that " . $emp_full_name . " has submitted, his/ her mid year KRAs for your moderation, kindly login to portal and initiate action.";
						$template = 'appraisal_process_notification';
						//die;
						if (isset($To)) {			
							$this->send_mail($From, $To, $CC, $sub, $msg, $template, $data);
						}
						 if (isset($contact_number) && preg_match("/^[789]\d{9}$/", $contact_number)) {
							$msg="" . $emp_full_name . " has submitted, his/ her mid year KRAs for your moderation, kindly login to portal and initiate action.";
							$this->Common->sendSms($contact_number, $msg);
						}
						
				if ($successAppMid) {
						
						if(empty($kraDetails[0]['KraTarget']['moderator_id']) || $kraDetails[0]['KraTarget']['moderator_id']=="" || $kraDetails[0]['KraTarget']['moderator_id']==0 ){
							$success = $this->MidReviews->UpdateAll(array(
                        'MidReviews.rev_review_status' => 1,
						'MidReviews.mod_review_status' => 1						
						),
						array('MidReviews.emp_code' => $this->request->data['kraTargetEmpCode'], 'MidReviews.financial_year' => $kraTargetFinancialYear));
						
						///////////////******** start of mail to all 3 levels for mid review completeion //////////////////////////////
						//echo "<pre>";print_r($this->request->data);//die;
						$kraDetails = $this->Common->getKraTargetDetails($this->request->data['kraTargetEmpCode'], $kraTargetFinancialYear);
						
						$appList = $this->EmpDetail->getEmpEmailDetails( $kraDetails[0]['KraTarget']['appraiser_id'],$kraDetails[0]['KraTarget']['appraiser_comp_code']);
						$managerID = $appList['UserDetail']['email'];
						$appDetails = $this->EmpDetail->getEmpDetails($kraDetails[0]['KraTarget']['appraiser_id']);
						$appName = $appDetails['MyProfile']['emp_full_name'];

						$revList = $this->EmpDetail->getEmpEmailDetails( $kraDetails[0]['KraTarget']['reviewer_id'],$kraDetails[0]['KraTarget']['reviewer_comp_code']);
						$revID = $revList['UserDetail']['email'];
						$revDetails = $this->EmpDetail->getEmpDetails( $kraDetails[0]['KraTarget']['reviewer_id']);
						$rev_full_name = $revDetails['MyProfile']['emp_full_name'];

						$modList = $this->EmpDetail->getEmpEmailDetails( $kraDetails[0]['KraTarget']['moderator_id'],$kraDetails[0]['KraTarget']['moderator_comp_code']);
						$modID = $modList['UserDetail']['email'];
						$modDetails = $this->EmpDetail->getEmpDetails($kraDetails[0]['KraTarget']['moderator_id']);				

						$empDetails = $this->EmpDetail->getEmpDetails( $kraDetails[0]['KraTarget']['emp_code']);
						$empList = $this->EmpDetail->getEmpEmailDetails( $kraDetails[0]['KraTarget']['emp_code'],$kraDetails[0]['KraTarget']['comp_code']);
						$empID = $empList['UserDetail']['email'];
						$emp_full_name = $empDetails['MyProfile']['emp_full_name'];

						$data['name'] = $modDetails['MyProfile']['emp_full_name'];
						$data['logo'] ='logo_email.png';
						//echo "<pre>";print_r($modID);die;
						
						
						$To = $revID.",".$managerID.",".$empID;
						$kra_config = $this->Session->read('sess_kra_config');
						$CC = $kra_config['MstPmsConfig']['hr_name'];
						$From = $revID;
						$sub = $emp_full_name . " Mid Year Review process has been completed.";
						$msg = "This is to inform you that Mid Year Review for " . $emp_full_name . " has completed successfully. Please login the PMS portal to view report.";
						$template = 'appraisal_process_notification';
						//die;
						if (isset($To)) {			
							$this->send_mail($From, $To, $CC, $sub, $msg, $template, $data);
						}
						$contact_number = $empDetails['MyProfile']['contact'];
						 if (isset($contact_number) && preg_match("/^[789]\d{9}$/", $contact_number)) {
							$msg="Mid Year Review completed for " . $emp_full_name . " successfully, kindly login to portal and view report.";
							$this->Common->sendSms($contact_number, $msg);
						}
						
						///////////////******** end of mail to all 3 levels for mid review completeion //////////////////////////////
					
					
					
						
						$this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                            <a href="#" class="uk-alert-close uk-close"></a>Mid year KRA assessment reviewed successfully. </div>');
							
						}else{
					
						$success = $this->MidReviews->UpdateAll(array(
                        'MidReviews.rev_review_status' => 1 ),
						array('MidReviews.emp_code' => $this->request->data['kraTargetEmpCode'], 'MidReviews.financial_year' => $kraTargetFinancialYear));
						
						$this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                            <a href="#" class="uk-alert-close uk-close"></a>Mid year KRA assessment forwarded to moderator for review. Please review competencies too.</div>');
						$this->redirect(array('controller' => 'KraMasters', 'action' => "viewReviewerKraTarget/$kraTargetEmpCode/$financialYear/$page_type"));
						}
						
						$financialYear = base64_encode($kraTargetFinancialYear);
						
                    $this->redirect(array('controller' => 'KraMasters', 'action' => "viewReviewerKraTarget/$kraTargetEmpCode/$financialYear/$page_type"));
                }

			}
                //die;
            }

            /// End Update Reviewer Score // 
            if ($this->request->data['submit'] == "Submit") {
			//Configure::write('debug',2);
              
                $kraTarget = array();
                $kraTargetEmpCode = $this->request->data['kraTargetEmpCode'];
                $total = count($this->request->data['reviewer_final_status_app']);
                if ($total == 1) {
                    $totalCount = $total;
                } else {
                    $totalCount = $total - 1;
                }

                for ($i = 0; $i <= $totalCount; $i++) {

                    $kraTarget['id'] = $this->request->data['id'][$i];
                    $comment = $this->request->data['reviewer_status_comment'][$i];

                    if ($this->request->data['reviewer_final_status_app'][$i] == 0) {
                        $reviewerFinal_status = 0;
                    } else {
                        $reviewerFinal_status = 1;
                    }
					
						 if ($reviewerFinal_status == 0) {
							$reviewerStatus = 3;
							$appraiserStatus = 3;
							$moderatorStatus = 0;
							$finalStatus = 0;
							$last_comment_by = 2;
						} else {
							$reviewerStatus = 5;
							$appraiserStatus = 5;
							$moderatorStatus = 1;
							$finalStatus = 1;
							$last_comment_by = 3;
						}
					
                    $currentYear = date("Y");

                    $reviewerTotalRecords = $this->KraTarget->find('all', array('fields' => array('id'),
                        'conditions' => array('KraTarget.reviewer_status' => array(5), 'KraTarget.appraiser_status' => 5,
                            'KraTarget.reviewer_id' => $this->Auth->User('emp_code'),
                            'KraTarget.emp_code' => $kraTargetEmpCode, 'KraTarget.reviewer_final_status' => "1",
                            'KraTarget.id' => $id, 'KraTarget.final_status' => "1",
                            'KraTarget.financial_year' => $currentFinancialYear)));

                    if (count($reviewerTotalRecords) == 0) {
                        $this->KraTarget->create();
						 if (isset($this->request->data['saveasdraft'])) {
							
							 $success1 = $this->KraTarget->UpdateAll(array('KraTarget.reviewer_final_status' => "$reviewerFinal_status",
                            'KraTarget.reviewer_status_comment' =>'"'.htmlentities($comment,ENT_QUOTES).'"',
                            'KraTarget.last_comment_by' => "'$last_comment_by'",
                            'reviewer_status' => "'$reviewerStatus'", 'moderator_status' => "'$moderatorStatus'"), array('KraTarget.id' => $kraTarget['id'],
                            'KraTarget.emp_code' => $kraTargetEmpCode));
						 }else{
							  $success = $this->KraTarget->UpdateAll(array('KraTarget.reviewer_final_status' => "$reviewerFinal_status",
                            'KraTarget.reviewer_status_comment' =>'"'.htmlentities($comment,ENT_QUOTES).'"',
                            'KraTarget.final_status' => "'$finalStatus'",
                            'KraTarget.appraiser_status' => "'$appraiserStatus'",
                            'KraTarget.last_comment_by' => "'$last_comment_by'",
                            'reviewer_status' => "'$reviewerStatus'", 'moderator_status' => "'$moderatorStatus'"), array('KraTarget.id' => $kraTarget['id'],
                            'KraTarget.emp_code' => $kraTargetEmpCode));
						 }
                       
                    }
                }
				
				$data = $this->Common->findFInancialYearDesc($this->Auth->User('comp_code'));
				$currentFinancialYear = $data['FinancialYear']['id'];
				if(trim($this->request->data['updateReviewerKraTarget']['feedback'])!=''){
				//echo $this->request->data['updateReviewerKraTarget']['feedback'];die;
						$KraComptencyFeedback['financial_year']= $currentFinancialYear;
						$KraComptencyFeedback['emp_code']= $kraTargetEmpCode;
						$KraComptencyFeedback['kra_comp']= $this->request->data['updateReviewerKraTarget']['kra_comp'];
						$KraComptencyFeedback['feedback']= $this->request->data['updateReviewerKraTarget']['feedback'];
						$KraComptencyFeedback['phase']= 1;
						$KraComptencyFeedback['created_by']= $this->Auth->User('emp_code');
						$KraComptencyFeedback['created_date']= date("Y-m-d");
						
						$this->KraComptencyFeedback->create();
                        $this->KraComptencyFeedback->save($KraComptencyFeedback);
			}
                if ($success && !isset($this->request->data['saveasdraft'])) {
                    $totalKraCount = count($this->Common->getKraTargetDetails($kraTargetEmpCode, $kraTargetFinancialYear));
                    $totalApprovedKraCount = count($this->Common->getTotalApprovedByReviewer($kraTargetEmpCode, $kraTargetFinancialYear));

                    if ($totalKraCount == $totalApprovedKraCount) {
						$kraDetails = $this->Common->getKraTargetDetails($kraTargetEmpCode, $kraTargetFinancialYear);

						$appList = $this->EmpDetail->getEmpEmailDetails( $kraDetails[0]['KraTarget']['appraiser_id'],$kraDetails[0]['KraTarget']['appraiser_comp_code']);
						$managerID = $appList['UserDetail']['email'];
						$appDetails = $this->EmpDetail->getEmpDetails($kraDetails[0]['KraTarget']['appraiser_id']);
						$appName = $appDetails['MyProfile']['emp_full_name'];

						$revList = $this->EmpDetail->getEmpEmailDetails( $kraDetails[0]['KraTarget']['reviewer_id'],$kraDetails[0]['KraTarget']['reviewer_comp_code']);
						$revID = $revList['UserDetail']['email'];
						$revDetails = $this->EmpDetail->getEmpDetails( $kraDetails[0]['KraTarget']['reviewer_id']);
						$rev_full_name = $revDetails['MyProfile']['emp_full_name'];

						$empDetails = $this->EmpDetail->getEmpDetails( $kraDetails[0]['KraTarget']['emp_code']);
						$empList = $this->EmpDetail->getEmpEmailDetails( $kraDetails[0]['KraTarget']['emp_code'],$kraDetails[0]['KraTarget']['comp_code']);
						$empID = $empList['UserDetail']['email'];
						$emp_full_name = $empDetails['MyProfile']['emp_full_name'];

						$data['name'] = 'All';
						$data['logo'] ='logo_email.png';
						$contact_number = $empDetails['MyProfile']['contact'];

						$To = $revID.",".$managerID.",".$empID;
						$kra_config = $this->Session->read('sess_kra_config');
						$CC = $kra_config['MstPmsConfig']['hr_name'];
						$From = $revID;
						$sub = $emp_full_name . " KRAs have been approved";
						$msg = "This is to inform you that " . $emp_full_name . " KRAs have been successfully approved.";
						$template = 'appraisal_process_notification';
						
						if (isset($To)) {			
							$this->send_mail($From, $To, $CC, $sub, $msg, $template, $data);
						}
						//die("ssss");
						 if (isset($contact_number) && preg_match("/^[789]\d{9}$/", $contact_number)) {
							$msg="This is to inform you that " . $emp_full_name . " KRAs have been successfully approved.";
							$this->Common->sendSms($contact_number, $msg);
						}
						$this->KraApprovalStatus->UpdateAll(array(
                           'emp_status' =>1 ,'app_status' =>1,'rev_status' =>1  ), array('financial_year' => $kraTargetFinancialYear, 'emp_code' => $kraTargetEmpCode));
                        $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                            <a href="#" class="uk-alert-close uk-close"></a>KRAs and targets successfully approved.</div>');
                    } else {
						$this->KraApprovalStatus->UpdateAll(array('emp_status' =>0 ,'app_status' =>0,'rev_status' =>1 ), array('financial_year' => $kraTargetFinancialYear, 'emp_code' => $kraTargetEmpCode));
                        $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                            <a href="#" class="uk-alert-close uk-close"></a>KRAs and targets rejected for correction.</div>');
                    }
					  
                    $this->redirect(array('controller' => 'KraMasters', 'action' => 'viewAllReviewerKraTarget'));
                }else{
					 $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                            <a href="#" class="uk-alert-close uk-close"></a>KRAs and targets saved.</div>');
					$this->redirect(array('controller' => 'KraMasters', 'action' => '/viewReviewerKraTarget/'.$kraTargetEmpCode.'/'.base64_encode($kraTargetFinancialYear).'/'.base64_encode('allrev').''));
				}
            }
        }else
		{
			$this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
			<a href="#" class="uk-alert-close uk-close"></a>No data found to process further.</div>');
			$this->redirect(array('controller' => 'users', 'action' => "dashboard"));
		}
    }

    public function updateModeratorKraTarget() {
        $this->layout = 'employee-new';
//Configure::write('debug','2');
        if ($this->request->data) {

            //echo "<pre>"; print_r($this->request->data);die;

            $kraTargetEmpCode = $this->request->data['kraTargetEmpCode'];
            $financialYear = $this->request->data['kraTargetFinancialYear'];

            $kraTargetFinancialYear = base64_decode($this->request->data['kraTargetFinancialYear']);

            /// Start Update Reviewer Score // 
            $modAchievSum = 0;
            if ($this->request->data['moderatorSelfScore'] == "Submit") {

                for ($i = 0; $i < count($this->request->data['updateModeratorKraTarget']['id']); $i++) {

                    $kraTargetId = $this->request->data['updateModeratorKraTarget']['id'][$i];
					$moderatorScoreActual = $this->request->data['updateModeratorKraTarget']['moderator_score_actual'][$i];
                    $moderatorScoreAchiev = $this->request->data['updateModeratorKraTarget']['moderator_score_achiev'][$i];
                    $moderatorScoreComment = $this->request->data['updateModeratorKraTarget']['moderator_score_comment'][$i];

                    $kraWeightage = $this->Common->getKraWeightageByID($kraTargetId);
					
					$kra_config = $this->Session->read('sess_kra_config');
					if($kra_config['MstPmsConfig']['app_type'] == 1){
						$modAchievSum += $kraWeightage * $moderatorScoreAchiev;
					}

					if($kra_config['MstPmsConfig']['app_type'] == 2){
						$modAchievSum += $moderatorScoreActual;
					}

                    $this->KraTarget->create();
                    $successSelfScore = $this->KraTarget->UpdateAll(array(
						'KraTarget.moderator_score_actual' => "'$moderatorScoreActual'",
                        'KraTarget.moderator_score_achiev' => "'$moderatorScoreAchiev'",
                        'KraTarget.moderator_score_comment' => '"'.htmlentities($moderatorScoreComment,ENT_QUOTES).'"'), array('KraTarget.id' => $kraTargetId, 'KraTarget.financial_year' => "$kraTargetFinancialYear"));
                }
				if(trim($this->request->data['updateModeratorKraTarget']['feedback'])!=''){
				//echo $this->request->data['updateModeratorKraTarget']['feedback'];die;
						$KraComptencyFeedback['financial_year']= $kraTargetFinancialYear;
						$KraComptencyFeedback['emp_code']= $kraTargetEmpCode;
						$KraComptencyFeedback['kra_comp']= $this->request->data['updateModeratorKraTarget']['kra_comp'];
						$KraComptencyFeedback['feedback']= $this->request->data['updateModeratorKraTarget']['feedback'];
						$KraComptencyFeedback['phase']= 3;
						$KraComptencyFeedback['created_by']= $this->Auth->User('emp_code');
						$KraComptencyFeedback['created_date']= date("Y-m-d");
						
						$this->KraComptencyFeedback->create();
                        $this->KraComptencyFeedback->save($KraComptencyFeedback);
			}
                if ($successSelfScore && !isset($this->request->data['saveasdraft'])) {
					
					if($kra_config['MstPmsConfig']['app_type'] == 1){
						$totalModeratorAchiv = $modAchievSum / 100;
					}

					if($kra_config['MstPmsConfig']['app_type'] == 2){
						$totalModeratorAchiv = $modAchievSum;
					}
					
					$kraRatings = $this->Common->findKraRatingList();
					for($kra=0;$kra<count($kraRatings);$kra++){
						
						if($totalModeratorAchiv >= $kraRatings[0]['KraRating']['achievement_from']){
							$moderatorRating = 5;
						}else if($totalModeratorAchiv >= $kraRatings[1]['KraRating']['achievement_from'] && $totalModeratorAchiv <= $kraRatings[1]['KraRating']['achievement_to']){
							$moderatorRating = 4;
						}else if($totalModeratorAchiv >= $kraRatings[2]['KraRating']['achievement_from'] && $totalModeratorAchiv <= $kraRatings[2]['KraRating']['achievement_to']){
							$moderatorRating = 3;
						}else if($totalModeratorAchiv >= $kraRatings[3]['KraRating']['achievement_from'] && $totalModeratorAchiv <= $kraRatings[3]['KraRating']['achievement_to']){
							$moderatorRating = 2;
						}else if($totalModeratorAchiv >= $kraRatings[4]['KraRating']['achievement_from'] && $totalModeratorAchiv <= $kraRatings[4]['KraRating']['achievement_to']){
							$moderatorRating = 1;
						}else{
							$moderatorRating = 1;
						}
						break;
					}

                   /*  if ($totalModeratorAchiv < 60) {
                        $moderatorRating = 1;
                    } else if ($totalModeratorAchiv >= 60 && $totalModeratorAchiv <= 80) {
                        $moderatorRating = 2;
                    } else if ($totalModeratorAchiv >= 81 && $totalModeratorAchiv <= 100) {
                        $moderatorRating = 3;
                    } else if ($totalModeratorAchiv >= 101 && $totalModeratorAchiv <= 119) {
                        $moderatorRating = 4;
                    } else if ($totalModeratorAchiv >= 120) {
                        $moderatorRating = 5;
                    }
 */
                    $list = $this->Common->getKraCompOverallRating($kraTargetEmpCode, $kraTargetFinancialYear);

                    $empKRAOverallRating = $list[0]['KraCompOverallRating']['emp_self_overall_rating'];
                    $appraiserKRAOverallRating = $list[0]['KraCompOverallRating']['appraiser_self_overall_rating'];
                    $reviewerKRAOverallRating = $list[0]['KraCompOverallRating']['reviewer_self_overall_rating'];
                    $moderatorKRAOverallRating = $moderatorRating;
	
					if($kra_config['MstPmsConfig']['app_type'] == 1){
						$kraOverallRating = ($empKRAOverallRating + $appraiserKRAOverallRating + $reviewerKRAOverallRating + $moderatorRating) / 4;
					}

					if($kra_config['MstPmsConfig']['app_type'] == 2){
						$kraOverallRating = $moderatorRating;
					}
					
                    $this->KraCompOverallRating->UpdateAll(array(
                        'KraCompOverallRating.moderator_self_overall_achiev' => "'$totalModeratorAchiv'",
                        'KraCompOverallRating.moderator_self_overall_rating' => "'$moderatorRating'",
                        'KraCompOverallRating.kra_overall_rating' => $kraOverallRating), array('KraCompOverallRating.emp_code' => $kraTargetEmpCode,
                        'KraCompOverallRating.moderator_id' => $this->Auth->User('emp_code'),
                        'KraCompOverallRating.financial_year' => $kraTargetFinancialYear));

					$kraDetails = $this->Common->getKraTargetDetails($kraTargetEmpCode, $kraTargetFinancialYear);
						
						$appList = $this->EmpDetail->getEmpEmailDetails( $kraDetails[0]['KraTarget']['appraiser_id'],$kraDetails[0]['KraTarget']['appraiser_comp_code']);
						$managerID = $appList['UserDetail']['email'];
						$appDetails = $this->EmpDetail->getEmpDetails($kraDetails[0]['KraTarget']['appraiser_id']);
						$appName = $appDetails['MyProfile']['emp_full_name'];
						
						$revList = $this->EmpDetail->getEmpEmailDetails( $kraDetails[0]['KraTarget']['reviewer_id'],$kraDetails[0]['KraTarget']['reviewer_comp_code']);
						$revID = $revList['UserDetail']['email'];
						$revDetails = $this->EmpDetail->getEmpDetails( $kraDetails[0]['KraTarget']['reviewer_id']);
						$rev_full_name = $revDetails['MyProfile']['emp_full_name'];
						
						$modList = $this->EmpDetail->getEmpEmailDetails( $kraDetails[0]['KraTarget']['moderator_id'],$kraDetails[0]['KraTarget']['moderator_comp_code']);
						$modID = $modList['UserDetail']['email'];
						$modDetails = $this->EmpDetail->getEmpDetails($kraDetails[0]['KraTarget']['moderator_id']);				
						
						$empDetails = $this->EmpDetail->getEmpDetails( $kraDetails[0]['KraTarget']['emp_code']);
						$empList = $this->EmpDetail->getEmpEmailDetails( $kraDetails[0]['KraTarget']['emp_code'],$kraDetails[0]['KraTarget']['comp_code']);
						$empID = $empList['UserDetail']['email'];
						$emp_full_name = $empDetails['MyProfile']['emp_full_name'];
						
						
						$data['name'] = $empDetails['MyProfile']['emp_full_name'];
						$data['logo'] ='logo_email.png';
						//echo "<pre>";print_r($appDetails);die;
						$contact_number = $empDetails['MyProfile']['contact'];
						
						$To = $empID.','.$managerID.','.$revID;
						$kra_config = $this->Session->read('sess_kra_config');
						$CC = $kra_config['MstPmsConfig']['hr_name'];
						$From = $modID;
						$sub = "Your appraisal has been completed";
						$msg = "This is to inform you that " . $emp_full_name . " appraisal process has been completed, kindly login to portal to view the scores.";
						$template = 'appraisal_process_notification';
						
						//die;
						if (isset($To)) {			
							$this->send_mail($From, $To, $CC, $sub, $msg, $template, $data);
						}
						 if (isset($contact_number) && preg_match("/^[789]\d{9}$/", $contact_number)) {
							$this->Common->sendSms($contact_number, $msg);
						}
						
						$success = $this->AppraisalProcess->UpdateAll(array(
							'AppraisalProcess.mod_review_status' => "1",
                        ), array('AppraisalProcess.emp_code' => $kraTargetEmpCode, 'AppraisalProcess.financial_year' => "$kraTargetFinancialYear"));

                    $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                            <a href="#" class="uk-alert-close uk-close"></a>KRA annual self score saved. Please fill competency ratings to complete the appraisal.</div>');
					$page_type=base64_encode('allannmod');
					$kraTargetFinancialYear = base64_encode($kraTargetFinancialYear);
                    $this->redirect(array('controller' => 'KraMasters', 'action' => "viewModeratorKraTarget/$kraTargetEmpCode/$kraTargetFinancialYear/$page_type"));
                }else{
					 $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                            <a href="#" class="uk-alert-close uk-close"></a>KRA annual self score saved.');
					$page_type=base64_encode('allannmod');
					$kraTargetFinancialYear = base64_encode($kraTargetFinancialYear);
                    $this->redirect(array('controller' => 'KraMasters', 'action' => "viewModeratorKraTarget/$kraTargetEmpCode/$kraTargetFinancialYear/$page_type"));
				}
            }
        if ($this->request->data['addMidModSelfScore'] == "Submit") {
				//Configure::write('debug','2');
				//echo '<pre>';print_r($this->request->data);die;
				
				for ($i = 0; $i < count($this->request->data['id']); $i++) {
					$comm= $this->request->data['mid_moderator_score_comment'][$i];
					$mid_mod_actual_upload = '';
						/*                 * *****************uploading documents code************************* */
						if ($this->request->data['mid_mod_actual_upload_' . ($i + 1) . ''] != '') {
							  /*                 * *****************uploading documents code************************* */
                if (is_array($this->request->data['mid_mod_actual_upload_' . ($i + 1) . '']) && $this->request->data['mid_mod_actual_upload_' . ($i + 1) . '']['name'] != '') {
                    $newfilename = time() . basename($this->request->data['mid_mod_actual_upload_' . ($i + 1) . '']['name']);

                    $file = "uploads/KRA/" . $newfilename;
                    $filename = basename($this->request->data['mid_mod_actual_upload_' . ($i + 1) . '']['name']);
                    $ext = strtolower(substr($filename, strrpos($filename, '.') + 1));
                    if (($ext == 'exe') || ($this->request->data['mid_mod_actual_upload_' . ($i + 1) . '']['size'] >= 2048000)) {
                        if ($this->request->data['mid_mod_actual_upload_' . ($i + 1) . '']['size'] >= 2048000) {
                            $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert=""><a href="#" class="uk-alert-close uk-close"></a>Sorry, this is heavy sized file, please check the size !</div>');
                        } elseif (($ext == 'exe')) {
                            $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert=""><a href="#" class="uk-alert-close uk-close"></a>Sorry, this is invalid file, please check the extention !</div>');
                        }
                        $this->redirect("viewAllMidModeratorKraTarget");
                    } else {
                        if (move_uploaded_file($this->request->data['mid_mod_actual_upload_' . ($i + 1) . '']['tmp_name'], $file)) {
                            $mid_mod_actual_upload = $newfilename;
                        } else {
                            $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert=""><a href="#" class="uk-alert-close uk-close"></a>' . ($i + 1) . $this->request->data['mid_mod_actual_upload_' . ($i + 1) . '']['name'] . 'Document not uploaded successfully. Please try again.</div>');
                            $this->redirect("viewAllMidModeratorKraTarget");
                        }
                    }
                } elseif (is_array($this->request->data['mid_mod_actual_upload_' . ($i + 1) . '']) != '' && $this->request->data['mid_mod_actual_upload_' . ($i + 1) . '']['name'] == '') {
                    $mid_mod_actual_upload = $this->request->data['updateModeratorKraTarget']['mid_mod_actual_upload_pre'][$i];
                    //echo 'ww';
                } elseif (!is_array($this->request->data['mid_mod_actual_upload_' . ($i + 1) . ''])) {
                    $mid_mod_actual_upload = $this->request->data['mid_mod_actual_upload_' . ($i + 1) . ''];

                   // echo 'pp';
                }
						}/* else{
							if ($this->request->data['mid_rev_actual_upload_' . ($i + 1) . ''] != '') {
							$mid_mod_actual_upload = time() . basename($this->request->data['mid_rev_actual_upload_' . ($i + 1) . '']);
							}
						} */
					  $successAppMid = $this->KraTarget->UpdateAll(array(
					  'KraTarget.mid_mod_actual_upload' => '"'.$mid_mod_actual_upload.'"',
                        'KraTarget.mid_moderator_score_comment' => '"'.htmlentities($comm,ENT_QUOTES).'"' ), 
						array('KraTarget.id' => $this->request->data['id'][$i], 'KraTarget.financial_year' => $kraTargetFinancialYear));					 
				}
				
				if(trim($this->request->data['updateModeratorKraTarget']['feedback'])!=''){
				//echo $this->request->data['updateModeratorKraTarget']['feedback'];die;
						$KraComptencyFeedback['financial_year']= $kraTargetFinancialYear;
						$KraComptencyFeedback['emp_code']= $this->request->data['kraTargetEmpCode'];
						$KraComptencyFeedback['kra_comp']= $this->request->data['updateModeratorKraTarget']['kra_comp'];
						$KraComptencyFeedback['feedback']= $this->request->data['updateModeratorKraTarget']['feedback'];
						$KraComptencyFeedback['phase']= 2;
						$KraComptencyFeedback['created_by']= $this->Auth->User('emp_code');
						$KraComptencyFeedback['created_date']= date("Y-m-d");
						
						$this->KraComptencyFeedback->create();
                        $this->KraComptencyFeedback->save($KraComptencyFeedback);
			}
			if(isset($this->request->data['saveasdraft'])){
				$this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                        <a href="#" class="uk-alert-close uk-close"></a>Mid Review has been saved.</div>');
			$financialYear=base64_encode($kraTargetFinancialYear);		
					$page_type=base64_encode('allmidmod');					
					$kraTargetEmpCode = $this->request->data['kraTargetEmpCode'];
                    $this->redirect(array('controller' => 'KraMasters', 'action' => "viewModeratorKraTarget/$kraTargetEmpCode/$financialYear/$page_type"));
               
			}else{
						
				if ($successAppMid) {
				
					
						$success = $this->MidReviews->UpdateAll(array(
                        'MidReviews.mod_review_status' => 1 ),
						array('MidReviews.emp_code' => $this->request->data['kraTargetEmpCode'], 'MidReviews.financial_year' => $kraTargetFinancialYear));
					
					///////////////******** start of mail to all 4 levels for mid review completeion //////////////////////////////
						//echo "<pre>";print_r($this->request->data);//die;
						$kraDetails = $this->Common->getKraTargetDetails($this->request->data['kraTargetEmpCode'], $kraTargetFinancialYear);
						
						$appList = $this->EmpDetail->getEmpEmailDetails( $kraDetails[0]['KraTarget']['appraiser_id'],$kraDetails[0]['KraTarget']['appraiser_comp_code']);
						$managerID = $appList['UserDetail']['email'];
						$appDetails = $this->EmpDetail->getEmpDetails($kraDetails[0]['KraTarget']['appraiser_id']);
						$appName = $appDetails['MyProfile']['emp_full_name'];

						$revList = $this->EmpDetail->getEmpEmailDetails( $kraDetails[0]['KraTarget']['reviewer_id'],$kraDetails[0]['KraTarget']['reviewer_comp_code']);
						$revID = $revList['UserDetail']['email'];
						$revDetails = $this->EmpDetail->getEmpDetails( $kraDetails[0]['KraTarget']['reviewer_id']);
						$rev_full_name = $revDetails['MyProfile']['emp_full_name'];

						$modList = $this->EmpDetail->getEmpEmailDetails( $kraDetails[0]['KraTarget']['moderator_id'],$kraDetails[0]['KraTarget']['moderator_comp_code']);
						$modID = $modList['UserDetail']['email'];
						$modDetails = $this->EmpDetail->getEmpDetails($kraDetails[0]['KraTarget']['moderator_id']);				

						$empDetails = $this->EmpDetail->getEmpDetails( $kraDetails[0]['KraTarget']['emp_code']);
						$empList = $this->EmpDetail->getEmpEmailDetails( $kraDetails[0]['KraTarget']['emp_code'],$kraDetails[0]['KraTarget']['comp_code']);
						$empID = $empList['UserDetail']['email'];
						$emp_full_name = $empDetails['MyProfile']['emp_full_name'];

						$data['name'] = $modDetails['MyProfile']['emp_full_name'];
						$data['logo'] ='logo_email.png';
						//echo "<pre>";print_r($modID);die;
						
						
						$To = $modID.",".$revID.",".$managerID.",".$empID;
						$kra_config = $this->Session->read('sess_kra_config');
						$CC = $kra_config['MstPmsConfig']['hr_name'];
						$From = $modID;
						$sub = $emp_full_name . " Mid Year Review process has been completed.";
						$msg = "This is to inform you that Mid Year Review for " . $emp_full_name . " has completed successfully. Please login the PMS portal to view report.";
						$template = 'appraisal_process_notification';
						//die;
						if (isset($To)) {			
							$this->send_mail($From, $To, $CC, $sub, $msg, $template, $data);
						}
						$contact_number = $empDetails['MyProfile']['contact'];
						 if (isset($contact_number) && preg_match("/^[789]\d{9}$/", $contact_number)) {
							$msg="Mid Year Review completed for " . $emp_full_name . " successfully, kindly login to portal and view report.";
							$this->Common->sendSms($contact_number, $msg);
						}
						
						///////////////******** end of mail to all 4 levels for mid review completeion //////////////////////////////
					
					
					
						$this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                            <a href="#" class="uk-alert-close uk-close"></a>Mid year KRA assessment reviewed successfully.</div>');
					$financialYear=base64_encode($kraTargetFinancialYear);		
					$page_type=base64_encode('allmidmod');					
					$kraTargetEmpCode = $this->request->data['kraTargetEmpCode'];
                    $this->redirect(array('controller' => 'KraMasters', 'action' => "viewModeratorKraTarget/$kraTargetEmpCode/$financialYear/$page_type"));
                }	
			} 
				
				//die;
						
            }
		}else
		{
			$this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
			<a href="#" class="uk-alert-close uk-close"></a>No data found to process further.</div>');
			$this->redirect(array('controller' => 'users', 'action' => "dashboard"));
		}

   }


    public function viewAllAppraiserKraTarget() {
		//Configure::write('debug',2);
        $this->layout = 'employee-new';

        $currentYear = date("Y");

        $totalKraRecords = $this->KraTarget->find('all', array('fields' => array('KraTarget.id', 'KraTarget.created_date'),
            'conditions' => array('KraTarget.appraiser_id' => $this->Auth->User('emp_code'))));

        $appraiserTotalRecords = $this->KraTarget->find('all', array('fields' => array('id'),
            'conditions' => array('KraTarget.appraiser_status' => array(1),
                'KraTarget.appraiser_id' => $this->Auth->User('emp_code'))));

        $this->set('totalKraRecords', count($totalKraRecords));
        $this->set('appraiserTotalRecords', count($appraiserTotalRecords));

        $this->paginate = array(
            'limit' => 500,
            'fields' => array('*'),
            'group' => array('KraTarget.financial_year', 'KraTarget.emp_code'),
            'conditions' => array('KraTarget.appraiser_id' => $this->Auth->User('emp_code'),'KraTarget.emp_status' => 2),
            'order' => 'KraTarget.modified_date desc'
        );

        $kraTargetList = $this->paginate('KraTarget');
		
		//echo '<pre>';print_r($kraTargetList);die;
        $this->set("kraTargetList", $kraTargetList);
    }

	    public function viewAllMidAppraiserKraTarget() {
		//Configure::write('debug',2);
        $this->layout = 'employee-new';

        $currentYear = date("Y");

        $totalKraRecords = $this->KraTarget->find('all', array('fields' => array('KraTarget.id', 'KraTarget.created_date'),
            'conditions' => array('KraTarget.appraiser_id' => $this->Auth->User('emp_code'))));

        $appraiserTotalRecords = $this->KraTarget->find('all', array('fields' => array('id'),
            'conditions' => array('KraTarget.appraiser_status' => array(1),
                'KraTarget.appraiser_id' => $this->Auth->User('emp_code'))));

        $this->set('totalKraRecords', count($totalKraRecords));
        $this->set('appraiserTotalRecords', count($appraiserTotalRecords));

        $this->paginate = array(
			'joins' => array(
					array(
						'table' => 'mid_reviews',
						'alias' => 'MidReviews',
						'type' => 'inner',
						'foreignKey' => false,
						'conditions' => array('MidReviews.emp_code = KraTarget.emp_code')
					)
				),
            'limit' => 500,
            'fields' => array('*'),
            'group' => array('KraTarget.financial_year', 'KraTarget.emp_code'),
            'conditions' => array('KraTarget.appraiser_id' => $this->Auth->User('emp_code'),'MidReviews.status' => 1,'MidReviews.emp_review_status' => 1),
            'order' => 'KraTarget.modified_date desc'
        );

        $kraTargetList = $this->paginate('KraTarget');
		
		//echo '<pre>';print_r($kraTargetList);die;
        $this->set("kraTargetList", $kraTargetList);
    }
	
	    public function viewAllAnnAppraiserKraTarget() {
		//Configure::write('debug',2);
        $this->layout = 'employee-new';

        $currentYear = date("Y");

        $totalKraRecords = $this->KraTarget->find('all', array('fields' => array('KraTarget.id', 'KraTarget.created_date'),
            'conditions' => array('KraTarget.appraiser_id' => $this->Auth->User('emp_code'))));

        $appraiserTotalRecords = $this->KraTarget->find('all', array('fields' => array('id'),
            'conditions' => array('KraTarget.appraiser_status' => array(1),
                'KraTarget.appraiser_id' => $this->Auth->User('emp_code'))));

        $this->set('totalKraRecords', count($totalKraRecords));
        $this->set('appraiserTotalRecords', count($appraiserTotalRecords));

        $this->paginate = array(
		'joins' => array(
					array(
						'table' => 'appraisal_process',
						'alias' => 'appraisal_process',
						'type' => 'inner',
						'foreignKey' => false,
						'conditions' => array('appraisal_process.emp_code = KraTarget.emp_code')
					),
					array(
						'table' => 'appraisal_development_plan',
						'alias' => 'appraisal_development_plan',
						'type' => 'inner',
						'foreignKey' => false,
						'conditions' => array('appraisal_development_plan.emp_code = KraTarget.emp_code')
					)
				),
				
            'limit' => 500,
            'fields' => array('*'),
            'group' => array('KraTarget.financial_year', 'KraTarget.emp_code'),
            'conditions' => array('KraTarget.appraiser_id' => $this->Auth->User('emp_code'),'appraisal_process.status' =>1,'appraisal_process.emp_review_status' => 1,'appraisal_development_plan.emp_review_status in (1,2) '),
            'order' => 'KraTarget.modified_date desc'
        );

        $kraTargetList = $this->paginate('KraTarget');
		
		//echo '<pre>';print_r($kraTargetList);die;
        $this->set("kraTargetList", $kraTargetList);
    }



    public function viewAllReviewerKraTarget() {
        //Configure::write('debug',2);
        $this->layout = 'employee-new';
        $this->paginate = array(
            'limit' => 500,
            'fields' => array('*'),
			'joins' => array(
								array(
									'table' => 'kra_approval_status',
									'alias' => 'kas',
									'type' => 'inner',
									'foreignKey' => false,
									'conditions' => array('kas.emp_code = KraTarget.emp_code')
								)
							),
            'group' => array('KraTarget.financial_year', 'KraTarget.emp_code'),
            'conditions' => array('KraTarget.reviewer_id' => $this->Auth->User('emp_code'),"kas.rev_status IN (0,1)",
                //"KraTarget.appraiser_status IN (5)", "KraTarget.self_score_achiev != ''", "KraTarget.appraiser_score_achiev != ''",),
                "KraTarget.appraiser_to_reviewer NOT IN (0)",),
			'order' => 'KraTarget.modified_date desc'
        );

        $kraTargetList = $this->paginate('KraTarget');

        $this->set("kraTargetList", $kraTargetList);
    }

	    public function viewAllMidReviewerKraTarget() {
        //Configure::write('debug',2);
        $this->layout = 'employee-new';
        $this->paginate = array(
		'joins' => array(
			array(
				'table' => 'mid_reviews',
				'alias' => 'MidReviews',
				'type' => 'inner',
				'foreignKey' => false,
				'conditions' => array('MidReviews.emp_code = KraTarget.emp_code')
			),
			array(
				'table' => 'competency_status',
				'alias' => 'cs',
				'type' => 'inner',
				'foreignKey' => false,
				'conditions' => array('KraTarget.emp_code = cs.emp_code')
			)
		),
            'limit' => 500,
            'fields' => array('*'),
            'group' => array('KraTarget.financial_year', 'KraTarget.emp_code'),
            'conditions' => array('KraTarget.reviewer_id' => $this->Auth->User('emp_code'),
                //"KraTarget.appraiser_status IN (5)", "KraTarget.self_score_achiev != ''", "KraTarget.appraiser_score_achiev != ''",),
                "KraTarget.appraiser_to_reviewer NOT IN (0)",'MidReviews.status' => 1,'MidReviews.emp_review_status' => 1,'MidReviews.app_review_status' => 1,'cs.app_mid_status' => 1),
			'order' => 'KraTarget.modified_date desc'
        );

        $kraTargetList = $this->paginate('KraTarget');

        $this->set("kraTargetList", $kraTargetList);
    }

	    public function viewAllAnnReviewerKraTarget() {
        //Configure::write('debug',2);
        $this->layout = 'employee-new';
        $this->paginate = array(
            'limit' => 500,
			'joins' => array(
								array(
									'table' => 'appraisal_process',
									'alias' => 'appraisal_process',
									'type' => 'inner',
									'foreignKey' => false,
									'conditions' => array('appraisal_process.emp_code = KraTarget.emp_code')
								),
								array(
									'table' => 'competency_status',
									'alias' => 'cs',
									'type' => 'inner',
									'foreignKey' => false,
									'conditions' => array('KraTarget.emp_code = cs.emp_code')
								),array(
									'table' => 'appraisal_development_plan',
									'alias' => 'appraisal_development_plan',
									'type' => 'inner',
									'foreignKey' => false,
									'conditions' => array('appraisal_development_plan.emp_code = KraTarget.emp_code')
								)
							),
            'fields' => array('*'),
            'group' => array('KraTarget.financial_year', 'KraTarget.emp_code'),
            'conditions' => array('KraTarget.reviewer_id' => $this->Auth->User('emp_code'),
                //"KraTarget.appraiser_status IN (5)", "KraTarget.self_score_achiev != ''", "KraTarget.appraiser_score_achiev != ''",),
                "KraTarget.appraiser_to_reviewer NOT IN (0)",'appraisal_process.status' => 1,'appraisal_process.emp_review_status' => 1,'appraisal_process.app_review_status' => 1,'appraisal_development_plan.emp_review_status' => 1,'appraisal_development_plan.app_review_status' => 1,'appraisal_development_plan.rev_review_status IN (0,1,2)' ),
			'order' => 'KraTarget.modified_date desc'
        );

        $kraTargetList = $this->paginate('KraTarget');

        $this->set("kraTargetList", $kraTargetList);
    }

    public function viewAllModeratorKraTarget() {
//		Configure::write('debug',2);
        $this->layout = 'employee-new';
        $this->paginate = array(
            'limit' => 500,
            'fields' => array('*'),
            'joins' => array(
                array(
                    'table' => 'competency_target',
                    'alias' => 'ct',
                    'type' => 'LEFT',
                    'foreignKey' => false,
                    'conditions' => array('KraTarget.emp_code = ct.emp_code')
                )
            ),
            'group' => array('KraTarget.financial_year', 'KraTarget.emp_code'),
            'conditions' => array('KraTarget.moderator_id' => $this->Auth->User('emp_code'),
                "KraTarget.appraiser_status IN (5)", "KraTarget.self_score_achiev != ''", "KraTarget.appraiser_score_achiev != ''", "KraTarget.reviewer_score_achiev != ''"),
            'order' => array('KraTarget.created_date' => 'desc')
        );

        $kraTargetList11 = $this->paginate('KraTarget');

		$totalMidReviews = $this->KraTarget->find('all', array(
			'fields' => array('*'),
			'joins' => array(
                    array(
                        'table' => 'mid_reviews',
                        'alias' => 'mr',
                        'type' => 'LEFT',
                        'foreignKey' => false,
                        'conditions' => array('KraTarget.emp_code = mr.emp_code')
                    )
                ),
			'group' => array('KraTarget.financial_year', 'KraTarget.emp_code'),
            'conditions' => array('KraTarget.moderator_id' => $this->Auth->User('emp_code'),'mr.emp_review_status' => 1,'mr.app_review_status' => 1,'mr.rev_review_status' => 1),
		)
		);
			//echo '<pre>';print_r($kraTargetList1);
			//echo '<pre>';print_r($totalMidReviews);//die;
		//$kraTargetList= array_unique(array_merge($totalMidReviews,$kraTargetList1));
		//$kraTargetList= array_intersect($totalMidReviews,$kraTargetList1);
$kraTargetList=  array_merge(  
            array_intersect($totalMidReviews, $kraTargetList1),  
            array_diff($totalMidReviews, $kraTargetList1),       
            array_diff($kraTargetList1, $totalMidReviews)        
        );
//$kraTargetList= $totalMidReviews + $kraTargetList1;
//echo '<pre>';print_r($kraTargetList);die;
		
        $this->set("kraTargetList", $kraTargetList11);
    }

	public function lists() {
        //Configure::write('debug',2);
        $q = '1=1';
        if (!empty($this->data)) {
            $id = $this->data['MstPmsConfig']['id'];
            $comp_code = strtoupper($this->data['MstPmsConfig']['comp_code']);
            if ($id != '') {
                $q .= " AND MstPmsConfig.id= " . $id;
            }
            if ($comp_name != '') {
                $q .= " AND MstPmsConfig.comp_code=" . $comp_code;
            }
        }
        $conditions = array($q);
        $this->paginate = array(
            'limit' => 10,
            'conditions' => $conditions,
            'fields' => array('*'),
            'order' => array(
                'MstPmsConfig.id' => 'asc',
            )
        );

        $result = $this->paginate('MstPmsConfig');
        $this->set('list', $result);
    }

	function add() {
		//Configure::write('debug',2);
        if (!empty($this->data)) {
            $this->autoRender = false;
            if (!empty($this->data)) {
			//	print_r($this->request->data);
                $this->request->data['MstPmsConfig']['comp_code'] = $this->request->data['KraMasters']['comp_code'];
                $this->request->data['MstPmsConfig']['app_type'] = $this->request->data['KraMasters']['calculation'];
                $this->request->data['MstPmsConfig']['hr_name'] = $this->request->data['KraMasters']['hr_name'];
				$this->request->data['MstPmsConfig']['mid_review'] = $this->request->data['KraMasters']['mid_review'];
                
                $con = $this->MstPmsConfig->find('count', array('conditions' => array('comp_code' => $this->request->data['KraMasters']['comp_code'])));
                if ($con > 0) {
					
                    $st = json_encode(array('msg' => "Duplicate Entry", 'type' => 'error'));
                } else {
					
                    if ($this->MstPmsConfig->save($this->data)) {
                        $st = json_encode(array('msg' => "Data saved successfully", 'type' => 'success'));
                        //$this->redirect('index');
                    } else {
						
                        $st = json_encode(array('msg' => 'Some Error Occurred', 'type' => 'error'));
                    }
                }
                echo $st;
                exit;
            }
        }
    }

	function delete($id = null) {
        $this->layout = false;
        $this->autoRender = false;
        if (!empty($id)) {
            if ($this->MstPmsConfig->delete($id)) {
                $st = json_encode(array('msg' => 'Record Deleted', 'type' => 'success'));
            } else {
                $st = json_encode(array('msg' => 'Record not deleted', 'type' => 'error'));
            }
        } else
            $st = json_encode(array('msg' => 'No Record Selected', 'type' => 'error'));
        echo $st;
        exit;
    }

	
	    public function viewAllMidModeratorKraTarget() {
//		Configure::write('debug',2);
        $this->layout = 'employee-new';
        $this->paginate = array(
            'limit' => 500,
            'fields' => array('*'),
            'joins' => array(
                array(
                    'table' => 'competency_status',
                    'alias' => 'cs',
                    'type' => 'LEFT',
                    'foreignKey' => false,
                    'conditions' => array('KraTarget.emp_code = cs.emp_code')
                ),
				array(
                        'table' => 'mid_reviews',
                        'alias' => 'mr',
                        'type' => 'LEFT',
                        'foreignKey' => false,
                        'conditions' => array('KraTarget.emp_code = mr.emp_code')
                    )
            ),
            'group' => array('KraTarget.financial_year', 'KraTarget.emp_code'),
            'conditions' => array('KraTarget.moderator_id' => $this->Auth->User('emp_code'),'cs.app_mid_status' => 1,'cs.rev_mid_status' => 1,'mr.emp_review_status' => 1,'mr.app_review_status' => 1,'mr.rev_review_status' => 1),
            'order' => array('KraTarget.modified_date' => 'desc')
        );

        $kraTargetList1 = $this->paginate('KraTarget');

		
        $this->set("kraTargetList", $kraTargetList1);
    }

	    public function viewAllAnnModeratorKraTarget() {
 //Configure::write('debug',2);
        $this->layout = 'employee-new';
        $this->paginate = array(
            'limit' => 500,
			'joins' => array(
								array(
									'table' => 'appraisal_process',
									'alias' => 'appraisal_process',
									'type' => 'inner',
									'foreignKey' => false,
									'conditions' => array('appraisal_process.emp_code = KraTarget.emp_code')
								),
								 array(
									'table' => 'appraisal_development_plan',
									'alias' => 'appraisal_development_plan',
									'type' => 'inner',
									'foreignKey' => false,
									'conditions' => array('appraisal_development_plan.emp_code = KraTarget.emp_code')
								)
							),
            'fields' => array('*'),
            'group' => array('KraTarget.financial_year', 'KraTarget.emp_code'),
            'conditions' => array('KraTarget.moderator_id' => $this->Auth->User('emp_code'),
                'appraisal_process.status' => 1,'appraisal_process.emp_review_status' => 1,'appraisal_process.app_review_status' => 1,'appraisal_process.rev_review_status' => 1,'appraisal_development_plan.emp_review_status' => 1,'appraisal_development_plan.app_review_status' => 1,'appraisal_development_plan.mod_review_status IN (0,1,2)'),
			'order' => 'KraTarget.modified_date desc'
        );
		
        $kraTargetList = $this->paginate('KraTarget');

        $this->set("kraTargetList", $kraTargetList);
    }

    public function viewAllEmpKraTarget() {
		//Configure::write('debug',2);
        $this->layout = 'employee-new';

        $this->paginate = array(
            'limit' => 500,
            'fields' => array('*'),
            'group' => 'KraTarget.financial_year',
            'conditions' => array('KraTarget.emp_code' => $this->Auth->User('emp_code'), 'KraTarget.emp_status' => 2),
            'order' => array('KraTarget.id' => 'ASC')
        );

        $kraTargetList = $this->paginate('KraTarget');
        $this->set("kraTargetList", $kraTargetList);
    }

    public function viewAllMidEmpKraTarget() {
		//Configure::write('debug',2);
        $this->layout = 'employee-new';

        $this->paginate = array(
		'joins' => array(
					array(
						'table' => 'mid_reviews',
						'alias' => 'MidReviews',
						'type' => 'inner',
						'foreignKey' => false,
						'conditions' => array('MidReviews.emp_code = KraTarget.emp_code')
					)
				),
            'limit' => 500,
            'fields' => array('*'),
            'group' => 'KraTarget.financial_year',
            'conditions' => array('KraTarget.emp_code' => $this->Auth->User('emp_code'),'MidReviews.status' => 1),
            'order' => array('KraTarget.id' => 'ASC')
        );

        $kraTargetList = $this->paginate('KraTarget');
        $this->set("kraTargetList", $kraTargetList);
    }

	public function viewAllAnnEmpKraTarget() {
		//Configure::write('debug',2);
        $this->layout = 'employee-new';

        $this->paginate = array(
		'joins' => array(
					array(
						'table' => 'appraisal_process',
						'alias' => 'appraisal_process',
						'type' => 'inner',
						'foreignKey' => false,
						'conditions' => array('appraisal_process.emp_code = KraTarget.emp_code')
					)
				),
            'limit' => 500,
            'fields' => array('*'),
            'group' => 'KraTarget.financial_year',
            'conditions' => array('KraTarget.emp_code' => $this->Auth->User('emp_code'),'appraisal_process.status' => 1),
            'order' => array('KraTarget.id' => 'ASC')
        );

        $kraTargetList = $this->paginate('KraTarget');
        $this->set("kraTargetList", $kraTargetList);
    }

    public function viewKraTargetProcess() {
        $this->layout = 'employee-new';

        $this->paginate = array(
            'limit' => 100,
            'fields' => array('KraTarget.id',
                'KraTarget.kra_name', 'KraTarget.weightage',
                'KraTarget.measure', 'KraTarget.qualifying', 'KraTarget.target',
                'KraTarget.stretched', 'KraTarget.emp_code',
                'KraTarget.emp_status', 'KraTarget.self_score_actual',
                'KraTarget.self_score_achiev', 'KraTarget.self_score_comment',
                'KraTarget.appraiser_id', 'KraTarget.appraiser_status',
                'KraTarget.appraiser_score_achiev', 'KraTarget.appraiser_score_comment',
                'KraTarget.reviewer_id', 'KraTarget.reviewer_status', 'KraTarget.reviewer_score_achiev',
                'KraTarget.reviewer_score_comment', 'KraTarget.final_status', 'KraTarget.created_date'),
            'conditions' => array('KraTarget.appraiser_id' => $this->Auth->User('emp_code')),
            'order' => array('KraTarget.id' => 'desc')
        );

        $kraTargetList = $this->paginate('KraTarget');
        $this->set("kraTargetList", $kraTargetList);

        if ($this->request->data) {

            $kraTarget = array();
            for ($i = 0; $i < count($this->request->data['addKraTarget']['kra_name']); $i++) {

                $kraTarget['kra_name'] = $this->request->data['addKraTarget']['kra_name'][$i];
                $kraTarget['weightage'] = $this->request->data['addKraTarget']['weightage'][$i];
                $kraTarget['measure'] = $this->request->data['addKraTarget']['measure'][$i];
                $kraTarget['qualifying'] = $this->request->data['addKraTarget']['qualifying'][$i];
                $kraTarget['target'] = $this->request->data['addKraTarget']['target'][$i];
                $kraTarget['stretched'] = $this->request->data['addKraTarget']['stretched'][$i];
                $kraTarget['emp_code'] = $this->Auth->User('emp_code');

                $kraTarget['appraiser_id'] = $this->Common->getManagerCode($kraTarget['emp_code']);
                $kraTarget['appraiser_status'] = 1;

                $kraTarget['reviewer_id'] = $this->Common->getManagerCode($kraTarget['appraiser_id']);
                $kraTarget['reviewer_status'] = 0;

                $kraTarget['emp_status'] = 2;
                $kraTarget['final_status'] = 0;
                $kraTarget['created_date'] = date("Y-m-d");


                $this->KraTarget->create();
                $success = $this->KraTarget->save($kraTarget);
            }
            if ($success) {
                $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                        <a href="#" class="uk-alert-close uk-close"></a>KRA target details forwarded successfully.</div>');
                //unset($tk_val);
            }
        }
    }

    protected function __dateDifference($date_1, $date_2, $differenceFormat = '%a') {
        $datetime1 = date_create($date_1);
        $datetime2 = date_create($date_2);
        $interval = date_diff($datetime1, $datetime2);
        return $interval->format($differenceFormat);
    }

    protected function __diff_in_weeks_and_days($from, $to) {
        $day = 24 * 3600;
        $from = strtotime($from);
        $to = strtotime($to) + $day;
        $diff = abs($to - $from);
        $weeks = floor($diff / $day / 7);
        $days = $diff / $day - $weeks * 7;
        $out = array();
        if ($weeks)
            $out[] = "$weeks" . ($weeks > 1 ? '' : '');
        if ($days)
            $out[] = "$days" . ($days > 1 ? '' : '');

        return $out[0];
    }

    protected function __diff_in_month($from, $to) {
        $d1 = strtotime("$from");
        $d2 = strtotime("$to");
        $min_date = min($d1, $d2);
        $max_date = max($d1, $d2);
        $i = 0;
        while (($min_date = strtotime("+1 MONTH", $min_date)) <= $max_date) {
            $i++;
        }
        return $i;
    }

    public function kraDelete() {
        $value = explode(",", $this->params['pass']['0']);
        $vl = base64_decode($value['0']);
        $emp_code = $value['1'];
        $this->KraMapEmp->deleteAll(
                array(
                    "KraMapEmp.kramasters_id" => $vl,
                    "KraMapEmp.myprofile_id" => $emp_code,
                    "KraMapEmp.kra_user_emp_code" => $this->Auth->User('emp_code'),
                    "KraMapEmp.status" => 0,
                )
        );
        if ($this->KpiMapEmps->deleteAll(
                        array(
                            "KpiMapEmps.kra_masters_id" => $vl,
                            "KpiMapEmps.myprofile_id" => $emp_code,
                            "KpiMapEmps.kpi_user_emp_code" => $this->Auth->User('emp_code'),
                            "KpiMapEmps.status" => 0,
                        )
                )) {
            echo "success";
        } else {
            echo "false";
        }
    }

    public function docDelete() {
        $vl = base64_decode($this->params['pass']['0']);
        if ($this->EmpDocuments->deleteAll(
                        array(
                            "EmpDocuments.id" => $vl,
                            "EmpDocuments.emp_code" => $this->Auth->User('emp_code')
                        )
                )) {
            echo "success";
        } else {
            echo "false";
        }
    }

    public function addKraRating() {
        $this->layout = 'employee-new';
//Configure::write('debug',2);
        //echo "<pre>";
        //print_r($this->Auth->User());
        //die;

        $this->paginate = array(
            'limit' => 15,
            'fields' => array('*'),
            'conditions' => array('KraRating.is_deleted' => 0),
            'order' => array('KraRating.rating_scale' => 'DESC')
        );

        $kraRatingList = $this->paginate('KraRating');
        $this->set("kraRatingList", $kraRatingList);

        if (empty($this->request->data['id'])) {

            if ($this->request->is('post') && !empty($this->request->data['KraRating']['ratingScale'])) {

                $arrayKraRating['rating_scale'] = $this->request->data['KraRating']['ratingScale'];
                $arrayKraRating['achievement_from'] = $this->request->data['KraRating']['achievement_from'];
                $arrayKraRating['achievement_to'] = $this->request->data['KraRating']['achievement_to'];

                $arrayKraRating['comment'] = $this->request->data['KraRating']['comment'];
                $arrayKraRating['status'] = $this->request->data['KraRating']['status'];

                $arrayKraRating['ho_org_id'] = $this->Common->getHO($this->Auth->User('comp_code'));
                $arrayKraRating['org_id'] = $this->Auth->User('comp_code');
                $arrayKraRating['created_date'] = date("Y-m-d");
                $arrayKraRating['created_by'] = $this->Auth->User('emp_code');

                $conditions = array('KraRating.rating_scale' => $arrayKraRating["rating_scale"],
                    'KraRating.achievement_from' => $arrayKraRating["achievement_from"],
                    'KraRating.achievement_to' => $arrayKraRating["achievement_to"], 'KraRating.is_deleted' => 0,
                );
                $data = $this->KraRating->find('all', array('conditions' => $conditions));

                if (count($data) >= 1) {
                    $this->Session->setFlash('<div class="uk-alert uk-alert-primary" data-uk-alert="">
                            <a href="#" class="uk-alert-close uk-close"></a>KRA Rating already exists. !!!</div>');
                    $this->redirect('/KraMasters/addKraRating');
                } else {
                    $this->KraRating->save($arrayKraRating);
                    $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                            <a href="#" class="uk-alert-close uk-close"></a>KRA Rating added successfully. !!!</div>');
                    $this->redirect('/KraMasters/addKraRating');
                }
            }
        }
    }

    public function kraRatingDelete($kraRatingId = null) {
        $this->layout = false;
        $this->autoRender = false;
        $deletedDate = date("Y-d-m");
        $id = base64_decode($kraRatingId);

        if (!empty($id)) {
            $success = $this->KraRating->updateAll(array('deleted_by' => $this->Auth->User('emp_code'), 'is_deleted' => '1', 'deleted_date' => "'$deletedDate'"), array('id' => $id));
            if ($success) {
                $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                        <a href="#" class="uk-alert-close uk-close"></a>KRA Rating deleted successfully. !!!</div>');

                $this->redirect("/KraMasters/addKraRating");
            } else {
                $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                        <a href="#" class="uk-alert-close uk-close"></a>KRA Rating not deleted successfully. !!!</div>');
                $this->redirect("/KraMasters/addKraRating");
            }
        } else {
            $this->Session->setFlash('<div class="uk-alert uk-alert-warning" data-uk-alert="">
                        <a href="#" class="uk-alert-close uk-close"></a>KRA Rating is not selected. !!!</div>');
        }
        $this->redirect("/KraMasters/addKraRating");
        exit;
    }

    public function midReviews() {
       // Configure::write('debug',2);

        $this->layout = 'employee-new';

        $data = $this->Common->findFInancialYearDesc($this->Auth->User('comp_code'));
        $currentFinancialYear = $data['FinancialYear']['id'];

        //$currentFinancialYear = "Apr " . date("Y") . " - Mar " . date('Y', strtotime('+1 years'));
        $this->set('currentFinancialYear', $currentFinancialYear);

        $currentYear = date("Y");

        if ($this->request->data) {

            $kraTarget = array();
            if (($this->request->data['emp_id']) != "") {
                for ($i = 0; $i < count($this->request->data['emp_id']); $i++) {

                    $midReviews['financial_year'] = "$currentFinancialYear";
                    $midReviews['emp_code'] = $this->request->data['emp_id'][$i];

                    $appraiserCode = $this->Common->getManagerCode($midReviews['emp_code']);
					$reviewerCode = $this->Common->getManagerCode($appraiserCode);
					$moderatorCode = $this->Common->getManagerCode($reviewerCode);


                    $midReviews['appraiser_code'] = isset($appraiserCode) ? $appraiserCode : 0;
					$midReviews['reviewer_code'] = isset($reviewerCode) ? $reviewerCode : 0;
					$midReviews['moderator_code'] = isset($moderatorCode) ? $moderatorCode : 0;
                    $midReviews['comp_code'] = $this->Auth->User('comp_code');
                    $midReviews['status'] = $this->request->data['midReviews']['status'];
                    $midReviews['created_by'] = $this->Auth->User('emp_code');
                    $midReviews['created_date'] = date("Y-m-d");

                $totalMidReviews = $this->MidReviews->find('all', array(
                    'fields' => array('MidReviews.id'),
                    'conditions' => array('MidReviews.emp_code' => $midReviews['emp_code'],
                        'MidReviews.financial_year' => $currentFinancialYear)));

                    if (count($totalMidReviews) == 0) {
                        $this->MidReviews->create();
						
                        $success = $this->MidReviews->save($midReviews);

                        $empList = $this->EmpDetail->getEmpEmailDetails($midReviews['emp_code'], $midReviews['comp_code']);

                        $empID = $empList['UserDetail']['email'];

                        $empDetails = $this->EmpDetail->getEmpDetails($midReviews['emp_code']);
						
                        $data['name'] = $empDetails['MyProfile']['emp_full_name'];
						$data['logo'] ='logo_email.png';
                        $contact_number = $empDetails['MyProfile']['contact'];
                        $emp_full_name = $empDetails['MyProfile']['emp_full_name'];

                        if (isset($empID)) {
                            $To = $empID;
                            $kra_config = $this->Session->read('sess_kra_config');
							$CC = $kra_config['MstPmsConfig']['hr_name'];
                            $From = $kra_config['MstPmsConfig']['hr_name'];
                            $sub = "Your mid year assessment has been initiated";
                            $msg = "This is to inform you that your mid year assessment has been initiated, kindly login to portal and fill the actuals.";
                            $template = 'appraisal_process_notification';

                            $this->send_mail($From, $To, $CC, $sub, $msg, $template, $data);
                        }

                        if (isset($contact_number) && preg_match("/^[789]\d{9}$/", $contact_number)) {
							 $msg = "This is to inform you that your mid year assessment has been initiated, kindly login to portal and fill the actuals.";
                            $this->Common->sendSms($contact_number, $msg);
                        }
                    }
                }
            } else {
                $this->Session->setFlash('<div class="uk-alert uk-alert-warning" data-uk-alert="">
                            <a href="#" class="uk-alert-close uk-close"></a>Please select atleast one employee. !!!</div>');
                $this->redirect("midReviews");
            }
            if ($success) {
                $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                        <a href="#" class="uk-alert-close uk-close"></a>Mid Reviews Process details saved successfully.</div>');
                $this->redirect("midReviews");
            }
			gc_collect_cycles();
			meminfo_objects_summary(fopen('/tmp/summary.txt','w'));
        }

        // Find all appraiser employee//

        $midReviewsList = $this->MidReviews->find('all', array(
                    'fields' => array('*'),
                    'order' => array("MidReviews.id DESC")
        ));


        $this->set("midReviewsList", $midReviewsList);

        // End find all appraiser employee//
        /// Update Status //

        if (isset($this->request->params['pass'][0]) == "midReviewstatus") {

            $midReviewsStatus = isset($this->request->params['pass'][1]) ? $this->request->params['pass'][1] : "";
            $midReviewsEditId = isset($this->request->params['pass'][2]) ? $this->request->params['pass'][2] : "";

            $status = base64_decode($midReviewsStatus);
            $appraisalId = base64_decode($midReviewsEditId);

            $successUpdate = $this->MidReviews->updateAll(array(
                'MidReviews.status' => "'$status'"), array('id' => $appraisalId));
            if ($successUpdate) {
                $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                    <a href="#" class="uk-alert-close uk-close"></a> Mid Reviews Process status details updated successfully. !!!</div>');
                $this->redirect("midReviews");
            }
        }

        // End Status //
    }

    public function appraisalProcess() {
        $this->layout = 'employee-new';

        $data = $this->Common->findFInancialYearDesc($this->Auth->User('comp_code'));
        $currentFinancialYear = $data['FinancialYear']['id'];

        //$currentFinancialYear = "Apr " . date("Y") . " - Mar " . date('Y', strtotime('+1 years'));
        $this->set('currentFinancialYear', $currentFinancialYear);

        $currentYear = date("Y");

        if ($this->request->data) {
//Configure::write('debug',2);
            $kraTarget = array();
            if (($this->request->data['emp_id']) != "") {
                for ($i = 0; $i < count($this->request->data['emp_id']); $i++) {

                    $appraisalProcess['financial_year'] = "$currentFinancialYear";
                    $appraisalProcess['emp_code'] = $this->request->data['emp_id'][$i];

                    $appraiserCode = $this->Common->getManagerCode($appraisalProcess['emp_code']);


                    $appraisalProcess['appraiser_code'] = isset($appraiserCode) ? $appraiserCode : "";
                    $appraisalProcess['comp_code'] = $this->Auth->User('comp_code');
                    $appraisalProcess['status'] = $this->request->data['AppraisalProcess']['status'];
                    $appraisalProcess['created_by'] = $this->Auth->User('emp_code');
                    $appraisalProcess['created_date'] = date("Y-m-d");

                    $totalAppraisalProcess = $this->AppraisalProcess->find('all', array(
                        'fields' => array('AppraisalProcess.id'),
                        'conditions' => array('AppraisalProcess.emp_code' => $appraisalProcess['emp_code'],
                            'AppraisalProcess.financial_year' => $currentFinancialYear)));

                    if (count($totalAppraisalProcess) == 0) {
                        $this->AppraisalProcess->create();
                        $success = $this->AppraisalProcess->save($appraisalProcess);

                        $empList = $this->EmpDetail->getEmpEmailDetails($appraisalProcess['emp_code'], $appraisalProcess['comp_code']);

                        $empID = $empList['UserDetail']['email'];

                        $empDetails = $this->EmpDetail->getEmpDetails($appraisalProcess['emp_code']);
                        $data['name'] = $empDetails['MyProfile']['emp_full_name'];
						$data['logo'] ='logo_email.png';
                        $contact_number = $empDetails['MyProfile']['contact'];
                        $emp_full_name = $empDetails['MyProfile']['emp_full_name'];

                        if (isset($empID)) {
                            $To = $empID;
                           $kra_config = $this->Session->read('sess_kra_config');
							$CC = $kra_config['MstPmsConfig']['hr_name'];
                            $From = $kra_config['MstPmsConfig']['hr_name'];
                            $sub = "Your annual assessment has been initiated";
                            $msg = "This is to inform you that your annual assessment has been initiated, kindly login to portal and fill the actuals.";
                            $template = 'appraisal_process_notification';

                            $this->send_mail($From, $To, $CC, $sub, $msg, $template, $data);
                        }

                        if (isset($contact_number) && preg_match("/^[789]\d{9}$/", $contact_number)) {
                            $this->Common->sendSms($contact_number, $msg);
                        }
                    }
                }
            } else {
                $this->Session->setFlash('<div class="uk-alert uk-alert-warning" data-uk-alert="">
                            <a href="#" class="uk-alert-close uk-close"></a>Please select atleast one employee. !!!</div>');
                $this->redirect("AppraisalProcess");
            }
			//die;
            if ($success) {
                $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                        <a href="#" class="uk-alert-close uk-close"></a>Appraisal Process details saved successfully. !!!</div>');
                $this->redirect("AppraisalProcess");
            }
        }

        // Find all appraiser employee//

        $appraisalProcessList = $this->AppraisalProcess->find('all', array(
            'fields' => array('*'),
            'order' => array("AppraisalProcess.id DESC")
        ));


        $this->set("appraisalProcessList", $appraisalProcessList);

        // End find all appraiser employee//
        /// Update Status //

        if (isset($this->request->params['pass'][0]) == "appraisalProcessStatus") {

            $appraisalStatus = isset($this->request->params['pass'][1]) ? $this->request->params['pass'][1] : "";
            $appraisalEditId = isset($this->request->params['pass'][2]) ? $this->request->params['pass'][2] : "";

            $status = base64_decode($appraisalStatus);
            $appraisalId = base64_decode($appraisalEditId);

            $successUpdate = $this->AppraisalProcess->updateAll(array(
                'AppraisalProcess.status' => "'$status'"), array('id' => $appraisalId));
            if ($successUpdate) {
                $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                    <a href="#" class="uk-alert-close uk-close"></a>Appraisal Process status details updated successfully. !!!</div>');
                $this->redirect("AppraisalProcess");
            }
        }

        // End Status //
    }

    public function getEmpListByJoiningDate($startDate, $endDate) {
        $this->set("startDate", $startDate);
        $this->set("endDate", $endDate);
    }

    public function getAnnEmpListByJoiningDate($startDate, $endDate) {
        $this->set("startDate", $startDate);
        $this->set("endDate", $endDate);
    }

    public function addCompetencyRating() {
//Configure::write("debug",2);
//echo "<pre>";print_r($this->request->data);die;  
        $this->layout = 'employee-new';
		$kra_config = $this->Session->read('sess_kra_config');
		
		if ($this->request->data['submitAppraiserMidRating']) {
            $competencyRating = array();
            $appRating = 0;
            $totalCompRating = count($this->request->data['addCompetencyRating']['competency_id']);
			$this->CompetencyTarget->deleteAll(array('CompetencyTarget.emp_code'=>$this->request->data['empCode']));
            for ($i = 0; $i < $totalCompRating; $i++) {	

                $competencyRating['competency_id'] = $this->request->data['addCompetencyRating']['competency_id'][$i];
                $financial_year = $this->request->data['FinancialYear'];
                $competencyRating['financial_year'] = "$financial_year";
                $competencyRating['appraiser_mid_rating_comment'] = $this->request->data['addCompetencyRating']['appraiser_mid_rating_comment'][$i];


                $competencyRating['emp_code'] = $this->request->data['empCode'];
                $competencyRating['comp_code'] = $this->request->data['empCompCode'];
                $competencyRating['appraiser_id'] = $this->Auth->User('emp_code');
                $competencyRating['appraiser_comp_code'] = $this->Auth->User('comp_code');

                $reviewer_id = $this->Common->getManagerCode($competencyRating['appraiser_id']);
                if ($reviewer_id != "" || $reviewer_id != 0) {
                    $competencyRating['reviewer_id'] = $this->Common->getManagerCode($competencyRating['appraiser_id']);
                    $competencyRating['reviewer_comp_code'] = $this->Common->getManagerCompCode($competencyRating['appraiser_id']);
                } else {
                     $competencyRating['reviewer_mid_rating_comment'] = $competencyRating['appraiser_mid_rating_comment'];
					 $competencyRating['reviewer_id'] = 0;
                    $competencyRating['reviewer_comp_code'] = 0;
                }

                $moderator_id = $this->Common->getManagerCode( $reviewer_id);
                if ($moderator_id != "" || $moderator_id != 0) {
                    $competencyRating['moderator_id'] = $this->Common->getManagerCode($competencyRating['reviewer_id']);
                    $competencyRating['moderator_comp_code'] = $this->Common->getManagerCompCode($competencyRating['reviewer_id']);
                } else {
					$competencyRating['moderator_mid_rating_comment'] = $competencyRating['appraiser_mid_rating_comment'];
                    $competencyRating['moderator_id'] = 0;
                    $competencyRating['moderator_comp_code'] = 0;
                }


                $competencyRating['appraiser_post_date'] = date("Y-m-d");
				
				$this->CompetencyTarget->create();

                $success = $this->CompetencyTarget->save($competencyRating);
				//echo "<pre>";print_r($competencyRating);die;  
				}
				
				if(trim($this->request->data['addCompetencyRating']['feedback'])!=''){
				//echo $this->request->data['addCompetencyRating']['feedback'];die;
						$KraComptencyFeedback['financial_year']= $financial_year;
						$KraComptencyFeedback['emp_code']= $this->request->data['empCode'];
						$KraComptencyFeedback['kra_comp']= $this->request->data['addCompetencyRating']['kra_comp'];
						$KraComptencyFeedback['feedback']= $this->request->data['addCompetencyRating']['feedback'];
						$KraComptencyFeedback['phase']= 3;
						$KraComptencyFeedback['created_by']= $this->Auth->User('emp_code');
						$KraComptencyFeedback['created_date']= date("Y-m-d");
						
						$this->KraComptencyFeedback->create();
                        $this->KraComptencyFeedback->save($KraComptencyFeedback);
			}
			  $FinancialYear = base64_encode($competencyRating['financial_year']);
				 $page_type = base64_encode('allmidapp');
                $empCodeId = $competencyRating['emp_code'];
				
			if(!isset($this->request->data['saveasdraftcomp'])){
            if ($success) {
				//echo $reviewer_id.' -> '.$moderator_id;die;
				 if ($reviewer_id == 0 && $moderator_id == 0) {
					$CompetencyStatus['emp_code']=$this->request->data['empCode'];
					$CompetencyStatus['financial_year']=$financial_year;
					$CompetencyStatus['app_mid_status']=1;
					$CompetencyStatus['rev_mid_status']=1;
					$CompetencyStatus['mod_mid_status']=1;
					
					$this->CompetencyStatus->create();
                    $this->CompetencyStatus->save($CompetencyStatus);
						
					 $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                        <a href="#" class="uk-alert-close uk-close"></a>Competency mid review details reviewed successfully.</div>');
				}else{
					$CompetencyStatus['emp_code']=$this->request->data['empCode'];
					$CompetencyStatus['financial_year']=$financial_year;
					$CompetencyStatus['app_mid_status']=1;
					
					$this->CompetencyStatus->create();
                    $this->CompetencyStatus->save($CompetencyStatus);
					$this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                        <a href="#" class="uk-alert-close uk-close"></a>Competency mid review details reviewed successfully forwarded to reviewer.</div>');
               
				 }
				 
				  $this->redirect(array('controller' => 'KraMasters', 'action' => "viewAppraiserKraTarget/$empCodeId/$FinancialYear/$page_type"));
            }
			}else{
				$this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                        <a href="#" class="uk-alert-close uk-close"></a>Competency mid review details saved.</div>');
						 $this->redirect(array('controller' => 'KraMasters', 'action' => "viewAppraiserKraTarget/$empCodeId/$FinancialYear/$page_type"));
				
			}
        }elseif ($this->request->data['submitAppraiserRating']) {
			//Configure::write("debug",2);
			//echo '<pre>';print_r($this->request->data);die;
            $competencyRating = array();
            $appRating = 0;
            $totalCompRating = count($this->request->data['addCompetencyRating']['competency_id']);
			//echo '<pre>';print_r($this->request->data['addCompetencyRating']);//die;
			$financial_year = $this->request->data['FinancialYear'];
			$comptency_list = $this->Common->getTotalAssignCompetencyList($this->request->data['empCode'],$this->request->data['FinancialYear']);
			if(count($comptency_list)==0){
				for ($i = 0; $i < $totalCompRating; $i++) {
					$competencyRating['competency_id'] = $this->request->data['addCompetencyRating']['competency_id'][$i];
					$financial_year = $this->request->data['FinancialYear'];
					$competencyRating['financial_year'] = "$financial_year";
					$competencyRating['emp_code'] = $this->request->data['empCode'];
					$competencyRating['comp_code'] = $this->request->data['empCompCode'];
					$competencyRating['appraiser_id'] = $this->Auth->User('emp_code');
					$competencyRating['appraiser_comp_code'] = $this->Auth->User('comp_code');

					$reviewer_id = $this->Common->getManagerCode($competencyRating['appraiser_id']);
					if ($reviewer_id != "" || $reviewer_id != 0) {
						$competencyRating['reviewer_id'] = $this->Common->getManagerCode($competencyRating['appraiser_id']);
						$competencyRating['reviewer_comp_code'] = $this->Common->getManagerCompCode($competencyRating['appraiser_id']);
					} else {
						$competencyRating['reviewer_id'] = 0;
						$competencyRating['reviewer_comp_code'] = 0;
					}

					$moderator_id = $this->Common->getManagerCode($competencyRating['reviewer_id']);
					if ($moderator_id != "" || $moderator_id != 0) {
						$competencyRating['moderator_id'] = $this->Common->getManagerCode($competencyRating['reviewer_id']);
						$competencyRating['moderator_comp_code'] = $this->Common->getManagerCompCode($competencyRating['reviewer_id']);
					} else {
						$competencyRating['moderator_id'] = 0;
						$competencyRating['moderator_comp_code'] = 0;
					}
					
					 $this->CompetencyTarget->create();
					 $success = $this->CompetencyTarget->save($competencyRating);
				}
				if (!isset($this->request->data['saveasdraftcomp'])) {
					$CompetencyStatus['emp_code']=$this->request->data['empCode'];
					$CompetencyStatus['financial_year']=$financial_year;
					$CompetencyStatus['app_ann_status']=1;
					
					$this->CompetencyStatus->create();
                    $this->CompetencyStatus->save($CompetencyStatus);
				}
			}
			
				$dataComp = $this->CompetencyStatus->find('all', array(
					'fields' => array('*'),
					'conditions' => array("CompetencyStatus.emp_code"=> $this->request->data['empCode'],"CompetencyStatus.financial_year"=> $financial_year)
				));
			
			if(count($dataComp)==0){
				$CompetencyStatus['emp_code']=$this->request->data['empCode'];
				$CompetencyStatus['financial_year']=$financial_year;
				
				$this->CompetencyStatus->create();
				$this->CompetencyStatus->save($CompetencyStatus);
			}
			
            for ($i = 0; $i < $totalCompRating; $i++) {

                $competencyRating['competency_id'] = $this->request->data['addCompetencyRating']['competency_id'][$i];
                $financial_year = $this->request->data['FinancialYear'];
                $competencyRating['financial_year'] = "$financial_year";
                $competencyRating['appraiser_rating'] = $this->request->data['addCompetencyRating']['appraiser_rating'][$i];
                $competencyRating['appraiser_comment'] = $this->request->data['addCompetencyRating']['appraiser_rating_comment'][$i];


                $competencyRating['emp_code'] = $this->request->data['empCode'];
                $competencyRating['comp_code'] = $this->request->data['empCompCode'];
                $competencyRating['appraiser_id'] = $this->Auth->User('emp_code');
                $competencyRating['appraiser_comp_code'] = $this->Auth->User('comp_code');

                $reviewer_id = $this->Common->getManagerCode($competencyRating['appraiser_id']);
                if ($reviewer_id != "" || $reviewer_id != 0) {
                    $competencyRating['reviewer_id'] = $this->Common->getManagerCode($competencyRating['appraiser_id']);
                    $competencyRating['reviewer_comp_code'] = $this->Common->getManagerCompCode($competencyRating['appraiser_id']);
                } else {
                    $competencyRating['reviewer_id'] = 0;
                    $competencyRating['reviewer_comp_code'] = 0;
                }

                $moderator_id = $this->Common->getManagerCode($competencyRating['reviewer_id']);
                if ($moderator_id != "" || $moderator_id != 0) {
                    $competencyRating['moderator_id'] = $this->Common->getManagerCode($competencyRating['reviewer_id']);
                    $competencyRating['moderator_comp_code'] = $this->Common->getManagerCompCode($competencyRating['reviewer_id']);
                } else {
                    $competencyRating['moderator_id'] = 0;
                    $competencyRating['moderator_comp_code'] = 0;
                }


                $competencyRating['appraiser_post_date'] = date("Y-m-d");

                $appRating += $competencyRating['appraiser_rating'];
				
				 $success = $this->CompetencyTarget->UpdateAll(array(
					'CompetencyTarget.appraiser_rating' => $competencyRating['appraiser_rating'],
					'CompetencyTarget.appraiser_comment' => "'".$competencyRating['appraiser_comment']."'",
					'CompetencyTarget.appraiser_post_date' => $competencyRating['appraiser_post_date']
					), 
					array('CompetencyTarget.competency_id' => $competencyRating['competency_id'],
					'CompetencyTarget.financial_year' => $competencyRating['financial_year'],
					'CompetencyTarget.emp_code' => $competencyRating['emp_code'],
					'CompetencyTarget.comp_code' => $competencyRating['comp_code'],
					)
				);
//print_r($competencyRating);die;
				if ($reviewer_id == 0 && $moderator_id == 0) {
                   
					$success = $this->CompetencyTarget->UpdateAll(array(
					'CompetencyTarget.reviewer_rating' => $competencyRating['appraiser_rating'],
					'CompetencyTarget.reviewer_comment' => "'".$competencyRating['appraiser_comment']."'",
					'CompetencyTarget.reviewer_post_date' => $competencyRating['appraiser_post_date'],
					'CompetencyTarget.moderator_rating' => $competencyRating['appraiser_rating'],
					'CompetencyTarget.moderator_comment' => "'".$competencyRating['appraiser_comment']."'",
					'CompetencyTarget.moderator_post_date' => $competencyRating['appraiser_post_date'],
					), 
					array('CompetencyTarget.competency_id' => $competencyRating['competency_id'],
					'CompetencyTarget.financial_year' => $competencyRating['financial_year'],
					'CompetencyTarget.emp_code' => $competencyRating['emp_code'],
					'CompetencyTarget.comp_code' => $competencyRating['comp_code'],
					)
				);
                }

               
            }
			if(trim($this->request->data['addCompetencyRating']['feedback'])!=''){
				//echo $this->request->data['addCompetencyRating']['feedback'];die;
						$KraComptencyFeedback['financial_year']= $this->request->data['FinancialYear'];
						$KraComptencyFeedback['emp_code']= $this->request->data['empCode'];
						$KraComptencyFeedback['kra_comp']= $this->request->data['addCompetencyRating']['kra_comp'];
						$KraComptencyFeedback['feedback']= $this->request->data['addCompetencyRating']['feedback'];
						$KraComptencyFeedback['phase']= 3;
						$KraComptencyFeedback['created_by']= $this->Auth->User('emp_code');
						$KraComptencyFeedback['created_date']= date("Y-m-d");
						
						$this->KraComptencyFeedback->create();
                        $this->KraComptencyFeedback->save($KraComptencyFeedback);
			}
			$FinancialYear = base64_encode($competencyRating['financial_year']);
			$empCodeId = $competencyRating['emp_code'];
			if (!isset($this->request->data['saveasdraftcomp'])) {
				if ($success) {
					
					if($kra_config['MstPmsConfig']['app_type']==1){
						$appraiserCompOverAllRating = round($appRating / $totalCompRating);
					}
					if($kra_config['MstPmsConfig']['app_type']==2){
						$appraiserCompOverAllRating = ($appRating / $totalCompRating)*100;
					}
					
					
				/* 	$compRatings = $this->Common->findCompRatingList();
						if($appraiserCompOverAllRating >= $compRatings['0']['CompetencyRating']['achievement_from']){
						//	echo '5';
							$appraiserCompOverAllRating = 5;
						}else if($appraiserCompOverAllRating >= $compRatings['1']['CompetencyRating']['achievement_from'] && $appraiserCompOverAllRating <= $compRatings['1']['CompetencyRating']['achievement_to']){
						//	echo '4';
							$appraiserCompOverAllRating = 4;
						}else if($appraiserCompOverAllRating >= $compRatings['2']['CompetencyRating']['achievement_from'] && $appraiserCompOverAllRating <= $compRatings['2']['CompetencyRating']['achievement_to']){
						//	echo '3';
							$appraiserCompOverAllRating = 3;
						}else if($appraiserCompOverAllRating >= $compRatings['3']['CompetencyRating']['achievement_from'] && $appraiserCompOverAllRating <= $compRatings['3']['CompetencyRating']['achievement_to']){
							$appraiserCompOverAllRating = 2;
						}else if($appraiserCompOverAllRating >= $compRatings['4']['CompetencyRating']['achievement_from'] && $appraiserCompOverAllRating <= $compRatings['4']['CompetencyRating']['achievement_to']){
							$appraiserCompOverAllRating = 1;
						}else{
							$appraiserCompOverAllRating = 1;
						} */
						
					if ($reviewer_id == 0 && $moderator_id == 0) {
						
								$this->CompetencyStatus->UpdateAll(array(
									'CompetencyStatus.app_ann_status' => 1,
									'CompetencyStatus.rev_ann_status' => 1,
									'CompetencyStatus.mod_ann_status' => 1
									), 
									array('CompetencyStatus.financial_year' => $competencyRating['financial_year'],
									'CompetencyStatus.emp_code' => $competencyRating['emp_code']
									)
								);
							if($kra_config['MstPmsConfig']['app_type']==1){
									$competencyOverallRating = ($appraiserCompOverAllRating + $appraiserCompOverAllRating + $appraiserCompOverAllRating) / 3;
							}
							if($kra_config['MstPmsConfig']['app_type']==2){
								$competencyOverallRating = $appraiserCompOverAllRating;
							}

						$this->KraCompOverallRating->UpdateAll(array(
							'KraCompOverallRating.appraiser_comp_overall_rating' => "'$appraiserCompOverAllRating'",
							'KraCompOverallRating.reviewer_comp_overall_rating' => "'$appraiserCompOverAllRating'",
							'KraCompOverallRating.moderator_comp_overall_rating' => "'$appraiserCompOverAllRating'",
							'KraCompOverallRating.comp_overall_rating' => $competencyOverallRating), array('KraCompOverallRating.emp_code' => $competencyRating['emp_code'],
							'KraCompOverallRating.appraiser_id' => $this->Auth->User('emp_code'),
							'KraCompOverallRating.financial_year' => $competencyRating['financial_year']));
					} else {
						$this->CompetencyStatus->UpdateAll(array(
									'CompetencyStatus.app_ann_status' => 1
									), 
									array('CompetencyStatus.financial_year' => $competencyRating['financial_year'],
									'CompetencyStatus.emp_code' => $competencyRating['emp_code']
									)
								);
						$this->KraCompOverallRating->UpdateAll(array(
							'KraCompOverallRating.appraiser_comp_overall_rating' => "'$appraiserCompOverAllRating'"), array('KraCompOverallRating.emp_code' => $competencyRating['emp_code'],
							'KraCompOverallRating.appraiser_id' => $this->Auth->User('emp_code'),
							'KraCompOverallRating.financial_year' => $competencyRating['financial_year']));
					}

					 if ($reviewer_id == 0 && $moderator_id == 0) {
						 $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
							<a href="#" class="uk-alert-close uk-close"></a>Competency rating details reviewed successfully and overall rating is calculated. Please fill development plan also.</div>');
					}else{
						$this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
							<a href="#" class="uk-alert-close uk-close"></a>Competency rating details saved. Please fill development plan to forward the assessment to reviewer.</div>');
				   
					 }
					 $page_type=base64_encode('allannapp');
					  $this->redirect(array('controller' => 'KraMasters', 'action' => "viewAppraiserKraTarget/$empCodeId/$FinancialYear/$page_type"));
				}
			}else{
				$this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
							<a href="#" class="uk-alert-close uk-close"></a>Competency rating details saved.</div>');
				$page_type=base64_encode('allannapp');
				$this->redirect(array('controller' => 'KraMasters', 'action' => "viewAppraiserKraTarget/$empCodeId/$FinancialYear/$page_type"));
			}
        }elseif ($this->request->data['submitMidReviewerRating']) {

            //echo "<pre>";print_r($this->request->data);die;
            $competencyRating = array();
            $rewRating = 0;
            $totalCompRating = count($this->request->data['addCompetencyRating']['competency_id']);
            for ($i = 0; $i < $totalCompRating; $i++) {

                $competencyTargetID = $this->request->data['addCompetencyRating']['competency_target_id'][$i];
                $competencyID = $this->request->data['addCompetencyRating']['competency_id'][$i];
                $financialYear = $this->request->data['FinancialYear'];
                $empCode = $this->request->data['empCode'];
                //$reviewerRating = $this->request->data['addCompetencyRating']['reviewer_rating'][$i];
                $reviewerComment = $this->request->data['addCompetencyRating']['reviewer_mid_rating_comment'][$i];
                $reviewerPostDate = date("Y-m-d");

                //$rewRating += $reviewerRating;


                $this->CompetencyTarget->create();

                $moderator_id = $this->Common->getManagerCode($this->Auth->User('emp_code'));
				if(!isset($this->request->data['saveasdraftcomp'])){
					if ($moderator_id == 0) {
						$success = $this->CompetencyTarget->updateAll(array('moderator_mid_rating_comment' => '"'.htmlentities($reviewerComment,ENT_QUOTES).'"',
							'moderator_post_date' => "'$reviewerPostDate'"), array('id' => $competencyTargetID));
					}
				}
                $success = $this->CompetencyTarget->updateAll(array('reviewer_mid_rating_comment' => '"'.htmlentities($reviewerComment,ENT_QUOTES).'"',
                    'reviewer_post_date' => "'$reviewerPostDate'"), array('id' => $competencyTargetID));
            }
				 if(trim($this->request->data['addCompetencyRating']['feedback'])!=''){
				//echo $this->request->data['addCompetencyRating']['feedback'];die;
						$KraComptencyFeedback['financial_year']= $this->request->data['FinancialYear'];
						$KraComptencyFeedback['emp_code']= $this->request->data['empCode'];
						$KraComptencyFeedback['kra_comp']= $this->request->data['addCompetencyRating']['kra_comp'];
						$KraComptencyFeedback['feedback']= $this->request->data['addCompetencyRating']['feedback'];
						$KraComptencyFeedback['phase']= 2;
						$KraComptencyFeedback['created_by']= $this->Auth->User('emp_code');
						$KraComptencyFeedback['created_date']= date("Y-m-d");
						
						$this->KraComptencyFeedback->create();
                        $this->KraComptencyFeedback->save($KraComptencyFeedback);
			}
			$financialYear = base64_encode($financialYear);
			$page_type = base64_encode('allmidrev');
			if(!isset($this->request->data['saveasdraftcomp'])){
				if ($success) { 
						if ($moderator_id == 0) {
							
							$this->CompetencyStatus->updateAll(array('rev_mid_status' => 1,'mod_mid_status' => 1), array('emp_code' => $this->request->data['empCode'] ));
							
							 $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
								<a href="#" class="uk-alert-close uk-close"></a>Competency mid review details reviewed successfully.</div>');
						}else{
							$this->CompetencyStatus->updateAll(array('rev_mid_status' => 1), array('emp_code' => $this->request->data['empCode'] ));
							$this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
								<a href="#" class="uk-alert-close uk-close"></a>Competency mid review details reviewed successfully forwarded to moderator.</div>');
					   
						 }
								
					
					$this->redirect(array('controller' => 'KraMasters', 'action' => "viewReviewerKraTarget/$empCode/$financialYear/$page_type"));
				}
			}else{
				$this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
								<a href="#" class="uk-alert-close uk-close"></a>Competency mid review details saved.</div>');
				$this->redirect(array('controller' => 'KraMasters', 'action' => "viewReviewerKraTarget/$empCode/$financialYear/$page_type"));
				
			}
        }elseif ($this->request->data['submitReviewerRating']) {
//Configure::write("debug",2);
           // echo "<pre>";print_r($this->request->data);die;
            $competencyRating = array();
            $rewRating = 0;
            $totalCompRating = count($this->request->data['addCompetencyRating']['competency_id']);
            for ($i = 0; $i < $totalCompRating; $i++) {

                $competencyTargetID = $this->request->data['addCompetencyRating']['competency_target_id'][$i];
                $competencyID = $this->request->data['addCompetencyRating']['competency_id'][$i];
                $financialYear = $this->request->data['FinancialYear'];
                $empCode = $this->request->data['empCode'];
                $reviewerRating = $this->request->data['addCompetencyRating']['reviewer_rating'][$i];
                $reviewerComment = $this->request->data['addCompetencyRating']['reviewer_rating_comment'][$i];
                $reviewerPostDate = date("Y-m-d");

                $rewRating += $reviewerRating;


                $this->CompetencyTarget->create();

                $moderator_id = $this->Common->getManagerCode($this->Auth->User('emp_code'));

                if ($moderator_id == 0) {
                    $success = $this->CompetencyTarget->updateAll(array('moderator_rating' => "'$reviewerRating'",
                        'moderator_comment' => '"'.htmlentities($reviewerComment,ENT_QUOTES).'"',
                        'moderator_post_date' => "'$reviewerPostDate'"), array('id' => $competencyTargetID));
                }

                $success = $this->CompetencyTarget->updateAll(array('reviewer_rating' => "'$reviewerRating'",
                    'reviewer_comment' => '"'.htmlentities($reviewerComment,ENT_QUOTES).'"',
                    'reviewer_post_date' => "'$reviewerPostDate'"), array('id' => $competencyTargetID));
            }
			
			if(trim($this->request->data['addCompetencyRating']['feedback'])!=''){
				//echo $this->request->data['addCompetencyRating']['feedback'];die;
						$KraComptencyFeedback['financial_year']= $this->request->data['FinancialYear'];
						$KraComptencyFeedback['emp_code']= $this->request->data['empCode'];
						$KraComptencyFeedback['kra_comp']= $this->request->data['addCompetencyRating']['kra_comp'];
						$KraComptencyFeedback['feedback']= $this->request->data['addCompetencyRating']['feedback'];
						$KraComptencyFeedback['phase']= 3;
						$KraComptencyFeedback['created_by']= $this->Auth->User('emp_code');
						$KraComptencyFeedback['created_date']= date("Y-m-d");
						
						$this->KraComptencyFeedback->create();
                        $this->KraComptencyFeedback->save($KraComptencyFeedback);
			}
            
		//die;
		$FinancialYear = base64_encode($financialYear);
		$empCodeId = $empCode;
		$page_type=base64_encode('allannrev');
		if(!isset($this->request->data['saveasdraftcomp'])){
            if ($success) {
				
				if($kra_config['MstPmsConfig']['app_type']==1){$reviewerCompOverAllRating =  round($rewRating / $totalCompRating);}
				if($kra_config['MstPmsConfig']['app_type']==2){$reviewerCompOverAllRating = ($rewRating / $totalCompRating)*100;}
				
			  /*  $compRatings = $this->Common->findCompRatingList();
			//	echo $appRating;
			//	echo $totalCompRating;
			//	echo $reviewerCompOverAllRating;
				//echo '<pre>';print_r($compRatings);
			
					if($reviewerCompOverAllRating >= $compRatings['0']['CompetencyRating']['achievement_from']){
					//	echo '5';
						$reviewerCompOverAllRating = 5;
					}else if($reviewerCompOverAllRating >= $compRatings['1']['CompetencyRating']['achievement_from'] && $reviewerCompOverAllRating <= $compRatings['1']['CompetencyRating']['achievement_to']){
					//	echo '4';
						$reviewerCompOverAllRating = 4;
					}else if($reviewerCompOverAllRating >= $compRatings['2']['CompetencyRating']['achievement_from'] && $reviewerCompOverAllRating <= $compRatings['2']['CompetencyRating']['achievement_to']){
					//	echo '3';
						$reviewerCompOverAllRating = 3;
					}else if($reviewerCompOverAllRating >= $compRatings['3']['CompetencyRating']['achievement_from'] && $reviewerCompOverAllRating <= $compRatings['3']['CompetencyRating']['achievement_to']){
						$reviewerCompOverAllRating = 2;
					}else if($reviewerCompOverAllRating >= $compRatings['4']['CompetencyRating']['achievement_from'] && $reviewerCompOverAllRating <= $compRatings['4']['CompetencyRating']['achievement_to']){
					//	echo 'kuut'.$compRatings[4]['CompetencyRating']['achievement_from'].'<br>';
					//	echo 'kuutaaa'.$compRatings[4]['CompetencyRating']['achievement_to'].'<br>';
						$reviewerCompOverAllRating = 1;
					}else{
						$reviewerCompOverAllRating = 1;
					}
 */
					
                $this->KraCompOverallRating->UpdateAll(array(
                    'KraCompOverallRating.reviewer_comp_overall_rating' => "'$reviewerCompOverAllRating'"), array('KraCompOverallRating.emp_code' => $empCode,
                    'KraCompOverallRating.reviewer_id' => $this->Auth->User('emp_code'),
                    'KraCompOverallRating.financial_year' => $financialYear));

				
                if ($moderator_id == 0) {
						$this->CompetencyStatus->updateAll(array('rev_ann_status' => 1,'mod_ann_status' => 1), array('emp_code' => $empCode ));
						
						if($kra_config['MstPmsConfig']['app_type']==1){
							$moderatorCompOverAllRating = $modRating / $totalCompRating;
						}
						if($kra_config['MstPmsConfig']['app_type']==2){
							$moderatorCompOverAllRating = ($modRating / $totalCompRating)*100;
						}
					if($moderatorCompOverAllRating >= $compRatings['0']['CompetencyRating']['achievement_from']){
					//	echo '5';
						$moderatorCompOverAllRating = 5;
					}else if($moderatorCompOverAllRating >= $compRatings['1']['CompetencyRating']['achievement_from'] && $moderatorCompOverAllRating <= $compRatings['1']['CompetencyRating']['achievement_to']){
					//	echo '4';
						$moderatorCompOverAllRating = 4;
					}else if($moderatorCompOverAllRating >= $compRatings['2']['CompetencyRating']['achievement_from'] && $moderatorCompOverAllRating <= $compRatings['2']['CompetencyRating']['achievement_to']){
					//	echo '3';
						$moderatorCompOverAllRating = 3;
					}else if($moderatorCompOverAllRating >= $compRatings['3']['CompetencyRating']['achievement_from'] && $moderatorCompOverAllRating <= $compRatings['3']['CompetencyRating']['achievement_to']){
						$moderatorCompOverAllRating = 2;
					}else if($moderatorCompOverAllRating >= $compRatings['4']['CompetencyRating']['achievement_from'] && $moderatorCompOverAllRating <= $compRatings['4']['CompetencyRating']['achievement_to']){
					//	echo 'kuut'.$compRatings[4]['CompetencyRating']['achievement_from'].'<br>';
					//	echo 'kuutaaa'.$compRatings[4]['CompetencyRating']['achievement_to'].'<br>';
						$moderatorCompOverAllRating = 1;
					}else{
						$moderatorCompOverAllRating = 1;
					}

                    $list = $this->Common->getKraCompOverallRating($empCode, $financialYear);

                    $appraiserCompOverallRating = $list[0]['KraCompOverallRating']['appraiser_comp_overall_rating'];

                    //$competencyOverallRating = ($appraiserCompOverallRating + $reviewerCompOverAllRating + $reviewerCompOverAllRating) / 3;
					$competencyOverallRating = $moderatorCompOverAllRating;
					
					if(trim($this->request->data['addCompetencyRating']['feedback'])!=''){
				//echo $this->request->data['addCompetencyRating']['feedback'];die;
						$KraComptencyFeedback['financial_year']= $this->request->data['FinancialYear'];
						$KraComptencyFeedback['emp_code']= $this->request->data['empCode'];
						$KraComptencyFeedback['kra_comp']= $this->request->data['addCompetencyRating']['kra_comp'];
						$KraComptencyFeedback['feedback']= $this->request->data['addCompetencyRating']['feedback'];
						$KraComptencyFeedback['phase']= 3;
						$KraComptencyFeedback['created_by']= $this->Auth->User('emp_code');
						$KraComptencyFeedback['created_date']= date("Y-m-d");
						
						$this->KraComptencyFeedback->create();
                        $this->KraComptencyFeedback->save($KraComptencyFeedback);
			}

                    $success = $this->KraCompOverallRating->updateAll(array(
                        'KraCompOverallRating.moderator_comp_overall_rating' => "'$reviewerCompOverAllRating'",
                        'KraCompOverallRating.comp_overall_rating' => $competencyOverallRating), array('KraCompOverallRating.emp_code' => $empCode,
                        'KraCompOverallRating.reviewer_id' => $this->Auth->User('emp_code'),
                        'KraCompOverallRating.financial_year' => $financialYear));
						$this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
				<a href="#" class="uk-alert-close uk-close"></a>Competency rating details reviewed successfully.</div>');
						
                }else{
					$this->CompetencyStatus->updateAll(array('rev_ann_status' => 1), array('emp_code' => $empCode ));
					$this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
				<a href="#" class="uk-alert-close uk-close"></a>Competency rating details forwarded to moderator successfully.</div>');
				}

                $this->redirect(array('controller' => 'KraMasters', 'action' => "viewReviewerKraTarget/$empCodeId/$FinancialYear/$page_type"));
            }
		}else{
			$this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
				<a href="#" class="uk-alert-close uk-close"></a>Competency rating details saved.</div>');
			$this->redirect(array('controller' => 'KraMasters', 'action' => "viewReviewerKraTarget/$empCodeId/$FinancialYear/$page_type"));
		}
        }elseif ($this->request->data['submitMidModeratorRating']) {

           // echo "<pre>";print_r($this->request->data);die;
            $competencyRating = array();
            $modRating = 0;
            $totalCompRating = count($this->request->data['addCompetencyRating']['competency_id']);
            for ($i = 0; $i < $totalCompRating; $i++) {

                $competencyTargetID = $this->request->data['addCompetencyRating']['competency_target_id'][$i];
                $competencyID = $this->request->data['addCompetencyRating']['competency_id'][$i];
                $financialYear = $this->request->data['FinancialYear'];
                $empCode = $this->request->data['empCode'];
                $moderatorComment = $this->request->data['addCompetencyRating']['moderator_mid_rating_comment'][$i];
                $moderatorPostDate = date("Y-m-d");

                $this->CompetencyTarget->create();
                $success = $this->CompetencyTarget->updateAll(array('moderator_mid_rating_comment' => '"'.htmlentities($moderatorComment,ENT_QUOTES).'"',
                    'moderator_post_date' => "'$moderatorPostDate'"), array('id' => $competencyTargetID));
            }
			
			if(trim($this->request->data['addCompetencyRating']['feedback'])!=''){
				//echo $this->request->data['addCompetencyRating']['feedback'];die;
						$KraComptencyFeedback['financial_year']= $financialYear;
						$KraComptencyFeedback['emp_code']= $this->request->data['empCode'];
						$KraComptencyFeedback['kra_comp']= $this->request->data['addCompetencyRating']['kra_comp'];
						$KraComptencyFeedback['feedback']= $this->request->data['addCompetencyRating']['feedback'];
						$KraComptencyFeedback['phase']= 2;
						$KraComptencyFeedback['created_by']= $this->Auth->User('emp_code');
						$KraComptencyFeedback['created_date']= date("Y-m-d");
						
						$this->KraComptencyFeedback->create();
                        $this->KraComptencyFeedback->save($KraComptencyFeedback);
			}
			
			$FinancialYear = base64_encode($financialYear);
			$page_type = base64_encode('allmidmod');
            $empCodeId = $empCode;
			if(!isset($this->request->data['saveasdraftcomp'])){
				if ($success) {
					$this->CompetencyStatus->updateAll(array('mod_mid_status' => 1), array('emp_code' => $this->request->data['empCode'] ));
					
					$this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
					<a href="#" class="uk-alert-close uk-close"></a>Competency rating details reviewed successfully.</div>');
					$this->redirect(array('controller' => 'KraMasters', 'action' => "viewModeratorKraTarget/$empCodeId/$FinancialYear/$page_type"));
				}
			}else{
				$this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
					<a href="#" class="uk-alert-close uk-close"></a>Competency rating details saved.</div>');
					$this->redirect(array('controller' => 'KraMasters', 'action' => "viewModeratorKraTarget/$empCodeId/$FinancialYear/$page_type"));
			}
			
        }elseif ($this->request->data['submitModeratorRating']) {

           // echo "<pre>";print_r($this->request->data);die;
            $competencyRating = array();
            $modRating = 0;
            $totalCompRating = count($this->request->data['addCompetencyRating']['competency_id']);
            for ($i = 0; $i < $totalCompRating; $i++) {

                $competencyTargetID = $this->request->data['addCompetencyRating']['competency_target_id'][$i];
                $competencyID = $this->request->data['addCompetencyRating']['competency_id'][$i];
                $financialYear = $this->request->data['FinancialYear'];
                $empCode = $this->request->data['empCode'];
                $moderatorRating = $this->request->data['addCompetencyRating']['moderator_rating'][$i];
                $moderatorComment = $this->request->data['addCompetencyRating']['moderator_comment'][$i];
                $moderatorPostDate = date("Y-m-d");

                $modRating += $moderatorRating;

                $this->CompetencyTarget->create();
                $success = $this->CompetencyTarget->updateAll(array('moderator_rating' => "'$moderatorRating'",
                    'moderator_comment' => '"'.htmlentities($moderatorComment,ENT_QUOTES).'"',
                    'moderator_post_date' => "'$moderatorPostDate'"), array('id' => $competencyTargetID));
            }
			if(trim($this->request->data['addCompetencyRating']['feedback'])!=''){
				//echo $this->request->data['addCompetencyRating']['feedback'];die;
						$KraComptencyFeedback['financial_year']= $this->request->data['FinancialYear'];
						$KraComptencyFeedback['emp_code']= $this->request->data['empCode'];
						$KraComptencyFeedback['kra_comp']= $this->request->data['addCompetencyRating']['kra_comp'];
						$KraComptencyFeedback['feedback']= $this->request->data['addCompetencyRating']['feedback'];
						$KraComptencyFeedback['phase']= 3;
						$KraComptencyFeedback['created_by']= $this->Auth->User('emp_code');
						$KraComptencyFeedback['created_date']= date("Y-m-d");
						
						$this->KraComptencyFeedback->create();
                        $this->KraComptencyFeedback->save($KraComptencyFeedback);
			}
			$FinancialYear = base64_encode($financialYear);
			$page_type = base64_encode('allannmod');				
			$empCodeId = $empCode;
			if(!isset($this->request->data['saveasdraftcomp'])){
            if ($success) {
				$compRatings = $this->Common->findCompRatingList();
				
				if($kra_config['MstPmsConfig']['app_type']==1){
                $moderatorCompOverAllRating =  round($modRating / $totalCompRating);
				}
				
				if($kra_config['MstPmsConfig']['app_type']==2){
				$moderatorCompOverAllRating = ($modRating / $totalCompRating)*100;
				}
			
                $list = $this->Common->getKraCompOverallRating($empCode, $financialYear);

                $appraiserCompOverallRating = $list[0]['KraCompOverallRating']['appraiser_comp_overall_rating'];
                $reviewerCompOverallRating = $list[0]['KraCompOverallRating']['reviewer_comp_overall_rating'];
				if($kra_config['MstPmsConfig']['app_type']==1){
                $moderatorCompOverallRating = $list[0]['KraCompOverallRating']['moderator_comp_overall_rating'];

                $competencyOverallRating = ($appraiserCompOverallRating + $reviewerCompOverallRating + $moderatorCompOverAllRating) / 3;
				}
				if($kra_config['MstPmsConfig']['app_type']==2){
					$moderatorCompOverAllRating = $moderatorCompOverAllRating;
					
					if($moderatorCompOverAllRating >= $compRatings['0']['CompetencyRating']['achievement_from']){
					//	echo '5';
						$competencyOverallRating = 5;
					}else if($moderatorCompOverAllRating >= $compRatings['1']['CompetencyRating']['achievement_from'] && $moderatorCompOverAllRating <= $compRatings['1']['CompetencyRating']['achievement_to']){
					//	echo '4';
						$competencyOverallRating = 4;
					}else if($moderatorCompOverAllRating >= $compRatings['2']['CompetencyRating']['achievement_from'] && $moderatorCompOverAllRating <= $compRatings['2']['CompetencyRating']['achievement_to']){
					//	echo '3';
						$competencyOverallRating = 3;
					}else if($moderatorCompOverAllRating >= $compRatings['3']['CompetencyRating']['achievement_from'] && $moderatorCompOverAllRating <= $compRatings['3']['CompetencyRating']['achievement_to']){
						$competencyOverallRating = 2;
					}else if($moderatorCompOverAllRating >= $compRatings['4']['CompetencyRating']['achievement_from'] && $moderatorCompOverAllRating <= $compRatings['4']['CompetencyRating']['achievement_to']){
					//	echo 'kuut'.$compRatings[4]['CompetencyRating']['achievement_from'].'<br>';
					//	echo 'kuutaaa'.$compRatings[4]['CompetencyRating']['achievement_to'].'<br>';
						$competencyOverallRating = 1;
					}else{
						$competencyOverallRating = 1;
					}
					
					
				}
				$this->CompetencyStatus->updateAll(array('mod_ann_status' => 1), array('emp_code' => $empCode ));
                $this->KraCompOverallRating->UpdateAll(array(
                    'KraCompOverallRating.moderator_comp_overall_rating' => "'$moderatorCompOverAllRating'",
                    'KraCompOverallRating.comp_overall_rating' => $competencyOverallRating), array('KraCompOverallRating.emp_code' => $empCode,
                    'KraCompOverallRating.moderator_id' => $this->Auth->User('emp_code'),
                    'KraCompOverallRating.financial_year' => $financialYear));
               
                $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
				<a href="#" class="uk-alert-close uk-close"></a>Competency rating details reviewed successfully.</div>');
                $this->redirect(array('controller' => 'KraMasters', 'action' => "viewModeratorKraTarget/$empCodeId/$FinancialYear/$page_type"));
            }
		}else{
			 $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
				<a href="#" class="uk-alert-close uk-close"></a>Competency rating details saved.</div>');
                $this->redirect(array('controller' => 'KraMasters', 'action' => "viewModeratorKraTarget/$empCodeId/$FinancialYear/$page_type"));
		}
        }else
		{
			$this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
			<a href="#" class="uk-alert-close uk-close"></a>No data found to process further.</div>');
			$this->redirect(array('controller' => 'users', 'action' => "dashboard"));
		}
    }

    public function addDevelopmentPlan() {
     //Configure::write('debug',2);
        //$this->layout = 'employee-new';
		$this->autoRender='false';
        if ($this->request->data['submitSelfPlan']) {
			//echo "<pre>";print_r($this->request->data);die;
			if(isset($this->request->data['emp_review_status']) && $this->request->data['emp_review_status'] == 2 ){
				//$this->AppraisalDevelopmentPlan->deleteAll(array('AppraisalDevelopmentPlan.emp_code'=>$this->Auth->User('emp_code')));
			}else{
				$this->AppraisalDevelopmentPlan->deleteAll(array('AppraisalDevelopmentPlan.emp_code'=>$this->Auth->User('emp_code')));
			}
            $developmentPlan = array();

            $developmentPlan['self_areas_strength'] = $this->request->data['addDevelopmentPlan']['self_areas_strength'];
            $financial_year = $this->request->data['currentFinancialYear'];
            $developmentPlan['financial_year'] = "$financial_year";
            $developmentPlan['self_areas_development'] = $this->request->data['addDevelopmentPlan']['self_areas_development'];
            $developmentPlan['emp_code'] = $this->Auth->User('emp_code');
            $developmentPlan['comp_code'] = $this->Auth->User('comp_code');
            $developmentPlan['emp_code'] = $this->Auth->User('emp_code');
            $developmentPlan['comp_code'] = $this->Auth->User('comp_code');
            $developmentPlan['appraiser_id'] = $this->Common->getManagerCode($developmentPlan['emp_code']);
            $developmentPlan['appraiser_comp_code'] = $this->Common->getManagerCompCode($developmentPlan['emp_code']);
			$developmentPlan['reviewer_code'] = $this->Common->getManagerCode($developmentPlan['appraiser_id']);
			$developmentPlan['moderator_code'] = $this->Common->getManagerCode($developmentPlan['reviewer_code']);
			$developmentPlan['mod_review_status'] = 0;

            $developmentPlan['self_post_date'] = date("Y-m-d");
			
			//echo "<pre>";print_r($developmentPlan);die;
			if(isset($this->request->data['emp_review_status']) && $this->request->data['emp_review_status'] == 2 ){
				$success = $this->AppraisalDevelopmentPlan->updateAll(array('self_areas_strength' => '"'.$developmentPlan['self_areas_strength'].'"','self_areas_development' => '"'.$developmentPlan['self_areas_development'].'"'), array('emp_code' => $this->Auth->User('emp_code')));
			}else{
				$success = $this->AppraisalDevelopmentPlan->save($developmentPlan);
			}
			$FinancialYear = base64_encode($developmentPlan['financial_year']);
			$page_type = base64_encode('allannemp');
			if (!isset($this->request->data['saveasdraftplan'])) {
				if ($success) {
					$this->AppraisalDevelopmentPlan->updateAll(array('emp_review_status' => 1,'app_review_status' => 0), array('emp_code' => $this->Auth->User('emp_code')));
					
					$this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
							<a href="#" class="uk-alert-close uk-close"></a>Development plan details forwarded to appraiser successfully.</div>');
					$this->redirect(array('controller' => 'KraMasters', 'action' => "viewKraTarget/$FinancialYear/$page_type"));
				}
			}else{
				$this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
							<a href="#" class="uk-alert-close uk-close"></a>Development plan details saved.</div>');
				$this->redirect(array('controller' => 'KraMasters', 'action' => "viewKraTarget/$FinancialYear/$page_type"));
			}
        }elseif ($this->request->data['submitAppraiserPlan']) {
			//Configure::write('debug',2);
			//echo "<pre>";print_r($this->request->data);die;
            $developmentPlan = array();
            $areasStrength = $this->request->data['addDevelopmentPlan']['appraiser_areas_strength'];
            $areasDevelopment = $this->request->data['addDevelopmentPlan']['appraiser_areas_development'];
            $higherAnotherRole = $this->request->data['addDevelopmentPlan']['higher_another_role'];


            $depPlanId = $this->request->data['depPlanId'];
            $financial_year = $this->request->data['currentFinancialYear'];
            $empCode = $this->request->data['empCode'];
            $appraiserId = $this->request->data['appraiserId'];
            $appraiserPostDate = date("Y-m-d");
			$this->AppraisalDevelopmentPlan->create();
            $success = $this->AppraisalDevelopmentPlan->updateAll(array('appraiser_areas_strength' => '"'.htmlentities($areasStrength,ENT_QUOTES).'"',
                'appraiser_areas_development' => '"'.htmlentities($areasDevelopment,ENT_QUOTES).'"',
                'higher_another_role' => '"'.htmlentities($higherAnotherRole,ENT_QUOTES).'"',
                'appraiser_post_date' => '"'.$appraiserPostDate.'"'), array('appraiser_id' => $appraiserId, 'emp_code' => $empCode, 'id' => "$depPlanId"));
	
            $totalTrainingRecords = count($this->request->data['addDevelopmentPlan']['identified_areas_for_development']);
			//if($this->request->data['app_review_status'] == 2){
				$this->TrainingDevelopment->deleteAll(array('TrainingDevelopment.emp_code' => $empCode, 'TrainingDevelopment.financial_year' => $financial_year));
			//}
            $trainingRecords = array();
            for ($i = 0; $i < $totalTrainingRecords; $i++) {

                $trainingRecords['dev_plan_id'] = $depPlanId;
                $trainingRecords['identified_areas_for_development'] = $this->request->data['addDevelopmentPlan']['identified_areas_for_development'][$i];
                $trainingRecords['observed_behavior'] = $this->request->data['addDevelopmentPlan']['observed_behavior'][$i];
                $trainingRecords['suggested_action_plan'] = $this->request->data['addDevelopmentPlan']['suggested_action_plan'][$i];
                $trainingRecords['timelines'] = $this->request->data['addDevelopmentPlan']['timelines'][$i];
                $trainingRecords['responsibility'] = $this->request->data['addDevelopmentPlan']['responsibility'][$i];

                $trainingRecords['financial_year'] = $financial_year;
                $trainingRecords['emp_code'] = $empCode;
                $trainingRecords['post_date'] = date("Y-m-d");
                $this->TrainingDevelopment->create();
                $success = $this->TrainingDevelopment->save($trainingRecords);
			}
			$FinancialYear = base64_encode($financial_year);
			$page_type=base64_encode('allannapp');
			if (!isset($this->request->data['saveasdraftplan'])) {		
				if ($success) { 
					$this->AppraisalDevelopmentPlan->updateAll(array('app_review_status' => 1,'mod_review_status' => 0), array('appraiser_id' => $appraiserId, 'emp_code' => $empCode, 'financial_year' => $financial_year));
				
				
					$kraDetails = $this->Common->getKraTargetDetails($empCode, $financial_year);
					//print_r($kraDetails);die;
					if($kraDetails[0]['KraTarget']['moderator_id']==0 || $kraDetails[0]['KraTarget']['moderator_id']==null){
						$this->AppraisalDevelopmentPlan->updateAll(array('mod_review_status' => 1), array('appraiser_id' => $appraiserId, 'emp_code' => $empCode, 'financial_year' => $financial_year));
					}
				
					if($kra_config['MstPmsConfig']['app_type']==1){
						$this->AppraisalDevelopmentPlan->updateAll(array('mod_review_status' => 1), array('appraiser_id' => $appraiserId, 'emp_code' => $empCode, 'financial_year' => $financial_year));
					}
				
				
					$this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
										<a href="#" class="uk-alert-close uk-close"></a>Development plan reviewed successfully.</div>');
					$this->redirect("viewAppraiserKraTarget/$empCode/$FinancialYear/$page_type");
				}
			}else{
				$this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
										<a href="#" class="uk-alert-close uk-close"></a>Development plan saved.</div>');
				$this->redirect("viewAppraiserKraTarget/$empCode/$FinancialYear/$page_type");
			}
        }elseif ($this->request->data['submitModeratorPlan']) {
			$FinancialYear = base64_encode($this->request->data['financial_year']);
			$page_type=base64_encode('allannmod');
			$empCode=$this->request->data['emp_code'];
			$this->AppraisalDevelopmentPlan->updateAll(array('mod_review_status' => 1), array( 'emp_code' => $empCode, 'financial_year' => $this->request->data['financial_year']));
			$this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
										<a href="#" class="uk-alert-close uk-close"></a>Development plan reviewed successfully.</div>');
			$this->redirect("viewModeratorKraTarget/$empCode/$FinancialYear/$page_type");
		}else
		{
			$this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
			<a href="#" class="uk-alert-close uk-close"></a>No data found to process further.</div>');
			$this->redirect(array('controller' => 'users', 'action' => "dashboard"));
		}
    }
	
	public function adp_remark($adp_id=null,$user_id=null) {
		//Configure::write('debug',2);
		$this->set("user_id", $user_id);
        if (isset($this->request->data['submit'])) {
		
			$success = $this->AppraisalDevelopmentPlan->UpdateAll(array(
						'AppraisalDevelopmentPlan.mod_remarks' => '"'.htmlentities($this->request->data['adp_remark']['mod_remarks'],ENT_QUOTES).'"',
						'AppraisalDevelopmentPlan.mod_review_status' => $this->request->data['adp_remark']['action'],
						'AppraisalDevelopmentPlan.app_review_status' => 0),						
						array('AppraisalDevelopmentPlan.id' => $this->request->data['adp_remark']['adp_id'])
						);
			if($success){
				$data = $this->Common->findFInancialYearDesc($this->Auth->User('comp_code'));
				$currentFinancialYear = $data['FinancialYear']['id'];
				$user_id=$this->request->data['adp_remark']['user_id'];
				$page_type=base64_encode('allannmod');
				$this->redirect("viewModeratorKraTarget/$user_id/".base64_encode($currentFinancialYear)."/$page_type");
			}
		}
		
		$this->set("adp_id", $adp_id);
        $this->set("Action", 2);
		
		
    }
	
	public function adp_remark_by_app($adp_id=null,$user_id=null) {
		//Configure::write('debug',2);
		$this->set("user_id", $user_id);
        $this->set("adp_id", $adp_id);
        $this->set("Action", 2);
		if(isset($this->request->data['adp_remark_by_app'])) {
		
			$success = $this->AppraisalDevelopmentPlan->UpdateAll(array(
						'AppraisalDevelopmentPlan.app_remark' => '"'.htmlentities($this->request->data['adp_remark_by_app']['app_remarks'],ENT_QUOTES).'"',
						'AppraisalDevelopmentPlan.app_review_status' => 2,
						'AppraisalDevelopmentPlan.emp_review_status' => 2,
						),						
						array('AppraisalDevelopmentPlan.id' => $this->request->data['adp_remark_by_app']['adp_id'])
						);
			if($success){
				$data = $this->Common->findFInancialYearDesc($this->Auth->User('comp_code'));
				$currentFinancialYear = $data['FinancialYear']['id'];
				$user_id=$this->request->data['adp_remark_by_app']['user_id'];
				$page_type=base64_encode('allannapp');
				$this->redirect("viewAppraiserKraTarget/$user_id/".base64_encode($currentFinancialYear)."/$page_type");
			}
		}
		
		
    }
	
	
	
    public function updateAllDetailsByModerator() {
       // Configure::write('debug', 2);
        if (isset($this->request->data['id'])) {
           // echo "<pre>"; print_r($this->request->data);die;

            $new = 0;
            $totalCount = count($this->request->data['id']);

            for ($i = 0; $i < $totalCount; $i++) {
                $id = count($this->request->data['id']);

                $emp_code = $this->request->data['empCode'][$i];
                $financial_year = $this->request->data['financialYear'][$i];


                if ($id >= 1) {
					 if ($this->request->data['review_type'][$i] == 'mr') {
						$kraDetails = $this->Common->getKraTargetDetails($emp_code, $financial_year);

						for ($k = 0; $k < count($kraDetails); $k++) {

							$kraTargetId = $kraDetails[$k]['KraTarget']['id'];
							$mid_rev_actual_upload = $kraDetails[$k]['KraTarget']['mid_rev_actual_upload'];
							$reviewer_score_comment = $kraDetails[$k]['KraTarget']['mid_reviewer_score_comment'];
							
							$success = $this->KraTarget->updateAll(array(
								'KraTarget.mid_mod_actual_upload' => '"'.$mid_rev_actual_upload.'"',
								'KraTarget.mid_moderator_score_comment' => '"'.htmlentities($reviewer_score_comment,ENT_QUOTES).'"'), array('KraTarget.id' => $kraTargetId));
						}

						$competencyDetails = $this->Common->getTotalAssignCompetencyList($emp_code, $financial_year);

						for ($c = 0; $c < count($competencyDetails); $c++) {

							$competencyTargetID = $competencyDetails[$c]['CompetencyTarget']['id'];
							$moderatorComment = $competencyDetails[$c]['CompetencyTarget']['reviewer_mid_rating_comment'];
							$moderatorPostDate = date("Y-m-d");

							$success = $this->CompetencyTarget->updateAll(array('moderator_mid_rating_comment' => '"'.htmlentities($moderatorComment,ENT_QUOTES).'"' ,
								'moderator_post_date' => "'$moderatorPostDate'"), array('id' => $competencyTargetID));
						}
						$success = $this->MidReviews->UpdateAll(array(
						'MidReviews.mod_review_status' => 1						
						),
						array('MidReviews.emp_code' => $emp_code, 'MidReviews.financial_year' => $financial_year));
						
					}elseif ($this->request->data['review_type'][$i] == 'ar') {
						$kraDetails = $this->Common->getKraTargetDetails($emp_code, $financial_year);

						for ($k = 0; $k < count($kraDetails); $k++) {

							$kraTargetId = $kraDetails[$k]['KraTarget']['id'];
							$reviewer_score_achiev = $kraDetails[$k]['KraTarget']['reviewer_score_achiev'];
							$reviewer_score_comment = $kraDetails[$k]['KraTarget']['reviewer_score_comment'];

							$success = $this->KraTarget->updateAll(array(
								'KraTarget.moderator_score_achiev' => "'$reviewer_score_achiev'",
								'KraTarget.moderator_score_comment' => '"'.htmlentities($reviewer_score_comment,ENT_QUOTES).'"'), array('KraTarget.id' => $kraTargetId));
						}

						$competencyDetails = $this->Common->getTotalAssignCompetencyList($emp_code, $financial_year);

						for ($c = 0; $c < count($competencyDetails); $c++) {

							$competencyTargetID = $competencyDetails[$c]['CompetencyTarget']['id'];
							$moderatorRating = $competencyDetails[$c]['CompetencyTarget']['reviewer_rating'];
							$moderatorComment = $competencyDetails[$c]['CompetencyTarget']['reviewer_comment'];
							$moderatorPostDate = date("Y-m-d");

							$success = $this->CompetencyTarget->updateAll(array('moderator_rating' => "'$moderatorRating'",
								'moderator_comment' => '"'.htmlentities($moderatorComment,ENT_QUOTES).'"' ,
								'moderator_post_date' => "'$moderatorPostDate'"), array('id' => $competencyTargetID));
						}

						$list = $this->Common->getKraCompOverallRating($emp_code, $financial_year);

						$empKRAOverallRating = $list[0]['KraCompOverallRating']['emp_self_overall_rating'];
						$appraiserKRAOverallRating = $list[0]['KraCompOverallRating']['appraiser_self_overall_rating'];
						$reviewerKRAOverallAchiev = $list[0]['KraCompOverallRating']['reviewer_self_overall_achiev'];
						$reviewerKRAOverallRating = $list[0]['KraCompOverallRating']['reviewer_self_overall_rating'];

						$appraiserCompOverallRating = $list[0]['KraCompOverallRating']['appraiser_comp_overall_rating'];
						$reviewerCompOverallRating = $list[0]['KraCompOverallRating']['reviewer_comp_overall_rating'];

						$competencyOverallRating = ($appraiserCompOverallRating + $reviewerCompOverallRating + $reviewerCompOverallRating) / 3;
						$kraOverallRating = ($empKRAOverallRating + $appraiserKRAOverallRating + $reviewerKRAOverallRating + $reviewerKRAOverallRating) / 4;

						$desgCode = $this->Common->getDesgCode($emp_code);
						$mgtGroup = $this->Common->findGroupDesg($desgCode);
						$groupWeightageList = $this->Common->findGroupWeightage($mgtGroup);

						$kraWeightage = $groupWeightageList['GroupWeightage']['kra_weightage'];
						$compWeightage = $groupWeightageList['GroupWeightage']['comp_weightage'];



						$kraCompetencyOverallRating = ($kraOverallRating * $kraWeightage + $competencyOverallRating * $compWeightage) / 100;

						if ($kraCompetencyOverallRating < 2.5) {
							$kraCompetencyOverallResult = "Does not meet expectations (DME)";
						} else if ($kraCompetencyOverallRating >= 2.5 && $kraCompetencyOverallRating <= 3) {
							$kraCompetencyOverallResult = "Needs improvement (NI)";
						} else if ($kraCompetencyOverallRating >= 3 && $kraCompetencyOverallRating <= 3.75) {
							$kraCompetencyOverallResult = "Meets Expectation (ME)";
						} else if ($kraCompetencyOverallRating >= 3.75 && $kraCompetencyOverallRating <= 4.5) {
							$kraCompetencyOverallResult = "Exceeds Expectation (EE)";
						} else if ($kraCompetencyOverallRating >= 4.5 && $kraCompetencyOverallRating <= 5) {
							$kraCompetencyOverallResult = "Far Exceeds Expectation (FEE)";
						}

						$success = $this->KraCompOverallRating->UpdateAll(array(
							'KraCompOverallRating.moderator_comp_overall_rating' => "'$reviewerCompOverallRating'",
							'KraCompOverallRating.comp_overall_rating' => $competencyOverallRating,
							'KraCompOverallRating.moderator_self_overall_achiev' => $reviewerKRAOverallAchiev,
							'KraCompOverallRating.moderator_self_overall_rating' => $reviewerKRAOverallRating,
							'KraCompOverallRating.kra_overall_rating' => $kraOverallRating,
							'KraCompOverallRating.kra_comp_overall_rating' => $kraCompetencyOverallRating,
							'KraCompOverallRating.kra_comp_overall_result' => "'$kraCompetencyOverallResult'"), array('KraCompOverallRating.emp_code' => $emp_code,
							'KraCompOverallRating.moderator_id' => $this->Auth->User('emp_code'),
							'KraCompOverallRating.financial_year' => $financial_year));
							
						$success = $this->AppraisalProcess->UpdateAll(array(
						'AppraisalProcess.mod_review_status' => 1						
						),
						array('AppraisalProcess.emp_code' => $emp_code, 'AppraisalProcess.financial_year' => $financial_year));
					}
                    
                }
            }
			if ($this->request->data['review_type'][0] == 'mr') {
				if ($success) {
					$this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
						<a href="#" class="uk-alert-close uk-close"></a>All records saved successfully.</div>');
					$this->redirect("viewAllMidModeratorKraTarget");
				} else {
					$this->Session->setFlash('<div class="uk-alert uk-alert-warning" data-uk-alert="">
						<a href="#" class="uk-alert-close uk-close"></a>Please select at least one records.</div>');
					$this->redirect("viewAllMidModeratorKraTarget");
				}
			}
			if ($this->request->data['review_type'][0] == 'ar') {
				if ($success) {
					$this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
						<a href="#" class="uk-alert-close uk-close"></a>All records saved successfully.</div>');
					$this->redirect("viewAllAnnModeratorKraTarget");
				} else {
					$this->Session->setFlash('<div class="uk-alert uk-alert-warning" data-uk-alert="">
						<a href="#" class="uk-alert-close uk-close"></a>Please select at least one records.</div>');
					$this->redirect("viewAllAnnModeratorKraTarget");
				}
			}
        }else
		{
			$this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
			<a href="#" class="uk-alert-close uk-close"></a>No data found to process further.</div>');
			$this->redirect(array('controller' => 'users', 'action' => "dashboard"));
		}
    }
	
	public function PmsStatusReport() {
     // Configure::write('debug',2);
        $data = $this->Common->findFInancialYearDesc($this->Auth->User('comp_code'));
        $currentFinancialYear = $data['FinancialYear']['id'];

        $empList = $this->KraTarget->find('all', array(
            'fields' => array('MyProfile.emp_code', 'MyProfile.emp_id', 'MyProfile.emp_full_name'),
            'order' => array('MyProfile.emp_full_name ASC'),
            'joins' => array(
                array(
                    'table' => 'myprofile',
                    'alias' => 'MyProfile',
                    'type' => 'left',
                    'foreignKey' => false,
                    'conditions' => array('KraTarget.emp_code = MyProfile.emp_code')
                )),
            'group' => array('KraTarget.emp_code'),
			'limit' => 500
        ));

        $this->set('empList', $empList);
        $this->set('currentFinancialYear', $currentFinancialYear);
        //echo '<pre>';print_r($this->request->data);
        if (isset($this->request->data['comp_code'])) {//Configure::write('debug',2);
            $queryCon = "";
			
            if ($this->request->data['emp_id'] != 0) {
                $empCode = $this->request->data['emp_id'];
                $queryCon .= "MyProfile.emp_code = $empCode ";
            } else {
                $queryCon .= " 1 ";
                $empCode = 0;
            }

            if ($this->request->data['comp_code'] != "" && $this->request->data['comp_code'] != "0") {
                $compCode = $this->request->data['comp_code'] . "%";
                $queryCon .= " AND myprofile.location_code LIKE '$compCode'";
            } else {
				$compCode = $this->request->data['comp_code'];
                $queryCon .= "";
            }
			
            $conditions = array($queryCon);
			
			$kraRecordList =  $this->MyProfile->query("SELECT myprofile.desg_code,myprofile.emp_full_name,myprofile.comp_code,myprofile.emp_code,myprofile.location_code FROM `myprofile` AS `MyProfile`  where ".$conditions[0]." UNION
SELECT myprofile.desg_code,myprofile.emp_full_name,myprofile.comp_code,myprofile.emp_code,myprofile.location_code FROM `myprofile` AS `MyProfile` inner JOIN `assign_competency_dept_desg` AS `acdd` ON (`acdd`.`emp_id` = `myprofile`.`emp_code`) where ".$conditions[0]."
UNION 
SELECT myprofile.desg_code,myprofile.emp_full_name,myprofile.comp_code,myprofile.emp_code,myprofile.location_code FROM `myprofile` AS `MyProfile` inner JOIN `assign_group_to_desg_details` AS `agtdd` ON (`agtdd`.`desg_id` = `myprofile`.`desg_code`) where ".$conditions[0]."  ");
			
			$this->set('kraRecordList', $kraRecordList);

            $this->set("empCode", $empCode);
            $this->set("fYear", $currentFinancialYear);
            $this->set("companyCode", $this->request->data['comp_code']);
        }
    }
	
	public function KraApprovalReport() {
        // Configure::write('debug',2);
        $data = $this->Common->findFInancialYearDesc($this->Auth->User('comp_code'));
        $currentFinancialYear = $data['FinancialYear']['id'];

        $empList = $this->KraTarget->find('all', array(
            'fields' => array('MyProfile.emp_code', 'MyProfile.emp_id', 'MyProfile.emp_full_name'),
            'order' => array('MyProfile.emp_full_name ASC'),
            'joins' => array(
                array(
                    'table' => 'myprofile',
                    'alias' => 'MyProfile',
                    'type' => 'left',
                    'foreignKey' => false,
                    'conditions' => array('KraTarget.emp_code = MyProfile.emp_code')
                )),
            'group' => array('KraTarget.emp_code'),
			'limit' => 500
        ));

        $this->set('empList', $empList);
        $this->set('currentFinancialYear', $currentFinancialYear);
        //print_r($this->request->data); die;
        if (isset($this->request->data['comp_code'])) {
            $queryCon = "";

            if ($this->request->data['emp_id'] != 0) {
                $empCode = $this->request->data['emp_id'];
                $queryCon .= "KraTarget.emp_code = $empCode AND ";
            } else {
                $queryCon .= "";
                $empCode = 0;
            }

            if ($this->request->data['financialYear'] != "" && $this->request->data['comp_code'] != "0") {
                $financialYear = $this->request->data['financialYear'];
                $queryCon .= "KraTarget.financial_year = $financialYear AND ";
            } else {
                $queryCon .= "";
            }

            if ($this->request->data['financialYear'] != "" && $this->request->data['comp_code'] == "0") {
                $financialYear = $this->request->data['financialYear'];
                $queryCon .= "KraTarget.financial_year = $financialYear";
            } else {
                $queryCon .= "";
            }

            if ($this->request->data['comp_code'] != "" && $this->request->data['comp_code'] != "0") {
                $compCode = $this->request->data['comp_code'] . "%";
                $queryCon .= "myprofile.location_code LIKE '$compCode'";
            } else {
                $queryCon .= "";
            }

            if ($this->request->data['comp_code'] == "0") {
                $compCode = $this->request->data['comp_code'];
                $queryCon .= "";
            }
            //print_r($queryCon); die;
			$queryCon .= " AND myprofile.status=32";
            $conditions = array($queryCon);
            $this->paginate = array(
                'joins' => array(
                    array(
                        'table' => 'myprofile',
                        'alias' => 'myprofile',
                        'type' => 'inner',
                        'foreignKey' => false,
                        'conditions' => array('KraTarget.emp_code = myprofile.emp_code')
                    )
                ),
                'fields' => array('KraTarget.*', 'myprofile.location_code'),
                'conditions' => $conditions,
                'group' => array('KraTarget.emp_code'),
			'limit' => 500
            );

            $kraRecordList = $this->paginate('KraTarget');
            $this->set('kraRecordList', $kraRecordList);

            $this->set("empCode", $empCode);
            $this->set("fYear", $financialYear);
            $this->set("companyCode", $this->request->data['comp_code']);
        }
    }
	
	public function KraApprovalDetails() {
        // Configure::write('debug',2);
        $data = $this->Common->findFInancialYearDesc($this->Auth->User('comp_code'));
        $currentFinancialYear = $data['FinancialYear']['id'];

        $empList = $this->KraTarget->find('all', array(
            'fields' => array('MyProfile.emp_code', 'MyProfile.emp_id', 'MyProfile.emp_full_name'),
            'order' => array('MyProfile.emp_full_name ASC'),
            'joins' => array(
                array(
                    'table' => 'myprofile',
                    'alias' => 'MyProfile',
                    'type' => 'left',
                    'foreignKey' => false,
                    'conditions' => array('KraTarget.emp_code = MyProfile.emp_code')
                )),
            'group' => array('KraTarget.emp_code'),
			'limit' => 500
        ));

        $this->set('empList', $empList);
        $this->set('currentFinancialYear', $currentFinancialYear);
        //print_r($this->request->data); die;
        if (isset($this->request->data['comp_code'])) {
            $queryCon = "";

            if ($this->request->data['emp_id'] != 0) {
                $empCode = $this->request->data['emp_id'];
                $queryCon .= "KraTarget.emp_code = $empCode AND ";
            } else {
                $queryCon .= "";
                $empCode = 0;
            }

            if ($this->request->data['financialYear'] != "" && $this->request->data['comp_code'] != "0") {
                $financialYear = $this->request->data['financialYear'];
                $queryCon .= "KraTarget.financial_year = $financialYear AND ";
            } else {
                $queryCon .= "";
            }

            if ($this->request->data['financialYear'] != "" && $this->request->data['comp_code'] == "0") {
                $financialYear = $this->request->data['financialYear'];
                $queryCon .= "KraTarget.financial_year = $financialYear";
            } else {
                $queryCon .= "";
            }

            if ($this->request->data['comp_code'] != "" && $this->request->data['comp_code'] != "0") {
                $compCode = $this->request->data['comp_code'] . "%";
                $queryCon .= "myprofile.location_code LIKE '$compCode'";
            } else {
                $queryCon .= "";
            }

            if ($this->request->data['comp_code'] == "0") {
                $compCode = $this->request->data['comp_code'];
                $queryCon .= "";
            }
            //print_r($queryCon); die;
			$queryCon .= " AND myprofile.status=32";
            $conditions = array($queryCon);
            $this->paginate = array(
                'joins' => array(
                    array(
                        'table' => 'myprofile',
                        'alias' => 'myprofile',
                        'type' => 'inner',
                        'foreignKey' => false,
                        'conditions' => array('KraTarget.emp_code = myprofile.emp_code')
                    )
                ),
                'fields' => array('KraTarget.*', 'myprofile.location_code'),
                'conditions' => $conditions,
                'group' => array('KraTarget.emp_code'),
			'limit' => 500
            );

            $kraRecordList = $this->paginate('KraTarget');
            $this->set('kraRecordList', $kraRecordList);

            $this->set("empCode", $empCode);
            $this->set("fYear", $financialYear);
            $this->set("companyCode", $this->request->data['comp_code']);
        }
    }
	
	public function KraMidReviewDetails() {
        //Configure::write('debug',2);
        $data = $this->Common->findFInancialYearDesc($this->Auth->User('comp_code'));
        $currentFinancialYear = $data['FinancialYear']['id'];

        $empList = $this->KraTarget->find('all', array(
            'fields' => array('MyProfile.emp_code', 'MyProfile.emp_id', 'MyProfile.emp_full_name'),
            'order' => array('MyProfile.emp_full_name ASC'),
            'joins' => array(
                array(
                    'table' => 'myprofile',
                    'alias' => 'MyProfile',
                    'type' => 'left',
                    'foreignKey' => false,
                    'conditions' => array('KraTarget.emp_code = MyProfile.emp_code')
                )),
            'group' => array('KraTarget.emp_code'),
			'limit' => 500
        ));

        $this->set('empList', $empList);
        $this->set('currentFinancialYear', $currentFinancialYear);
        //print_r($this->request->data); die;
        if (isset($this->request->data['comp_code'])) {
            $queryCon = "";

            if ($this->request->data['emp_id'] != 0) {
                $empCode = $this->request->data['emp_id'];
                $queryCon .= "KraTarget.emp_code = $empCode AND ";
            } else {
                $queryCon .= "";
                $empCode = 0;
            }

            if ($this->request->data['financialYear'] != "" && $this->request->data['comp_code'] != "0") {
                $financialYear = $this->request->data['financialYear'];
                $queryCon .= "KraTarget.financial_year = $financialYear AND ";
            } else {
                $queryCon .= "";
            }

            if ($this->request->data['financialYear'] != "" && $this->request->data['comp_code'] == "0") {
                $financialYear = $this->request->data['financialYear'];
                $queryCon .= "KraTarget.financial_year = $financialYear";
            } else {
                $queryCon .= "";
            }

            if ($this->request->data['comp_code'] != "" && $this->request->data['comp_code'] != "0") {
                $compCode = $this->request->data['comp_code'] . "%";
                $queryCon .= "myprofile.location_code LIKE '$compCode'";
            } else {
                $queryCon .= "";
            }

            if ($this->request->data['comp_code'] == "0") {
                $compCode = $this->request->data['comp_code'];
                $queryCon .= "";
            }
            //print_r($queryCon); die;
			 //Configure::write('debug',2);
			$queryCon .= " AND myprofile.status=32";
            $conditions = array($queryCon);
            $this->paginate = array(
                'joins' => array(
                    array(
                        'table' => 'myprofile',
                        'alias' => 'myprofile',
                        'type' => 'inner',
                        'foreignKey' => false,
                        'conditions' => array('KraTarget.emp_code = myprofile.emp_code')
                    ),
					array(
						'table' => 'mid_reviews',
						'alias' => 'MidReviews',
						'type' => 'inner',
						'foreignKey' => false,
						'conditions' => array('MidReviews.emp_code = KraTarget.emp_code')
					)
                ),
              'fields' => array('KraTarget.*', 'myprofile.location_code'),
                'conditions' => $conditions,
                'group' => array('KraTarget.emp_code'),
			'limit' => 500
            );

            $kraRecordList = $this->paginate('KraTarget');
            $this->set('kraRecordList', $kraRecordList);

            $this->set("empCode", $empCode);
            $this->set("fYear", $financialYear);
            $this->set("companyCode", $this->request->data['comp_code']);
        }
    }
	
    public function kraMidReviewReport() {
        // Configure::write('debug',2);
        $data = $this->Common->findFInancialYearDesc($this->Auth->User('comp_code'));
        $currentFinancialYear = $data['FinancialYear']['id'];

        $empList = $this->KraTarget->find('all', array(
            'fields' => array('MyProfile.emp_code', 'MyProfile.emp_id', 'MyProfile.emp_full_name'),
            'order' => array('MyProfile.emp_full_name ASC'),
            'joins' => array(
                array(
                    'table' => 'myprofile',
                    'alias' => 'MyProfile',
                    'type' => 'left',
                    'foreignKey' => false,
                    'conditions' => array('KraTarget.emp_code = MyProfile.emp_code')
                )),
            'group' => array('KraTarget.emp_code'),
			'limit' => 500
        ));

        $this->set('empList', $empList);
        $this->set('currentFinancialYear', $currentFinancialYear);
        //print_r($this->request->data); die;
        if (isset($this->request->data['comp_code'])) {
            $queryCon = "";

            if ($this->request->data['emp_id'] != 0) {
                $empCode = $this->request->data['emp_id'];
                $queryCon .= "KraTarget.emp_code = $empCode AND ";
            } else {
                $queryCon .= "";
                $empCode = 0;
            }

            if ($this->request->data['financialYear'] != "" && $this->request->data['comp_code'] != "0") {
                $financialYear = $this->request->data['financialYear'];
                $queryCon .= "KraTarget.financial_year = $financialYear AND ";
            } else {
                $queryCon .= "";
            }

            if ($this->request->data['financialYear'] != "" && $this->request->data['comp_code'] == "0") {
                $financialYear = $this->request->data['financialYear'];
                $queryCon .= "KraTarget.financial_year = $financialYear";
            } else {
                $queryCon .= "";
            }

            if ($this->request->data['comp_code'] != "" && $this->request->data['comp_code'] != "0") {
                $compCode = $this->request->data['comp_code'] . "%";
                $queryCon .= "myprofile.location_code LIKE '$compCode'";
            } else {
                $queryCon .= "";
            }

            if ($this->request->data['comp_code'] == "0") {
                $compCode = $this->request->data['comp_code'];
                $queryCon .= "";
            }
            //print_r($queryCon); die;
			 //Configure::write('debug',2);
			$queryCon .= " AND myprofile.status=32";
            $conditions = array($queryCon);
            $this->paginate = array(
                'joins' => array(
                    array(
                        'table' => 'myprofile',
                        'alias' => 'myprofile',
                        'type' => 'inner',
                        'foreignKey' => false,
                        'conditions' => array('KraTarget.emp_code = myprofile.emp_code')
                    ),
					array(
						'table' => 'mid_reviews',
						'alias' => 'MidReviews',
						'type' => 'inner',
						'foreignKey' => false,
						'conditions' => array('MidReviews.emp_code = KraTarget.emp_code')
					)
                ),
              'fields' => array('KraTarget.*', 'myprofile.location_code'),
                'conditions' => $conditions,
                'group' => array('KraTarget.emp_code'),
			'limit' => 500
            );

            $kraRecordList = $this->paginate('KraTarget');
            $this->set('kraRecordList', $kraRecordList);

            $this->set("empCode", $empCode);
            $this->set("fYear", $financialYear);
            $this->set("companyCode", $this->request->data['comp_code']);
        }
    }

    public function kraAssessmentReport() {
        // Configure::write('debug',2);
        $data = $this->Common->findFInancialYearDesc($this->Auth->User('comp_code'));
        $currentFinancialYear = $data['FinancialYear']['id'];

        $empList = $this->KraTarget->find('all', array(
            'fields' => array('MyProfile.emp_code', 'MyProfile.emp_id', 'MyProfile.emp_full_name'),
            'order' => array('MyProfile.emp_full_name ASC'),
            'joins' => array(
                array(
                    'table' => 'myprofile',
                    'alias' => 'MyProfile',
                    'type' => 'left',
                    'foreignKey' => false,
                    'conditions' => array('KraTarget.emp_code = MyProfile.emp_code')
                )),
            'group' => array('KraTarget.emp_code'),
			'limit' => 500
        ));

        $this->set('empList', $empList);
        $this->set('currentFinancialYear', $currentFinancialYear);
        //print_r($this->request->data); die;
        if (isset($this->request->data['comp_code'])) {
            $queryCon = "";

            if ($this->request->data['emp_id'] != 0) {
                $empCode = $this->request->data['emp_id'];
                $queryCon .= "KraTarget.emp_code = $empCode AND ";
            } else {
                $queryCon .= "";
                $empCode = 0;
            }

            if ($this->request->data['financialYear'] != "" && $this->request->data['comp_code'] != "0") {
                $financialYear = $this->request->data['financialYear'];
                $queryCon .= "KraTarget.financial_year = $financialYear AND ";
            } else {
                $queryCon .= "";
            }

            if ($this->request->data['financialYear'] != "" && $this->request->data['comp_code'] == "0") {
                $financialYear = $this->request->data['financialYear'];
                $queryCon .= "KraTarget.financial_year = $financialYear";
            } else {
                $queryCon .= "";
            }

            if ($this->request->data['comp_code'] != "" && $this->request->data['comp_code'] != "0") {
                $compCode = $this->request->data['comp_code'] . "%";
                $queryCon .= "myprofile.location_code LIKE '$compCode'";
            } else {
                $queryCon .= "";
            }

            if ($this->request->data['comp_code'] == "0") {
                $compCode = $this->request->data['comp_code'];
                $queryCon .= "";
            }
            //print_r($queryCon); die;
			$queryCon .= " AND myprofile.status=32";
            $conditions = array($queryCon);
            $this->paginate = array(
                'joins' => array(
                    array(
                        'table' => 'myprofile',
                        'alias' => 'myprofile',
                        'type' => 'inner',
                        'foreignKey' => false,
                        'conditions' => array('KraTarget.emp_code = myprofile.emp_code')
                    ),
					array(
                        'table' => 'appraisal_process',
                        'alias' => 'appraisal_process',
                        'type' => 'inner',
                        'foreignKey' => false,
                        'conditions' => array('KraTarget.emp_code = appraisal_process.emp_code')
                    )
                ),
                'fields' => array('KraTarget.*', 'myprofile.location_code'),
                'conditions' => $conditions,
                'group' => array('KraTarget.emp_code'),
			'limit' => 500
            );

            $kraRecordList = $this->paginate('KraTarget');
            $this->set('kraRecordList', $kraRecordList);

            $this->set("empCode", $empCode);
            $this->set("fYear", $financialYear);
            $this->set("companyCode", $this->request->data['comp_code']);
        }
    }

	function PmsStatusReportFile($employeeCode, $fYear, $compCode) {
       // Configure::write('debug',2);
        $this->autoRender = false;
        $empCode = base64_decode($employeeCode);
        $financialYear = base64_decode($fYear);

        $cCode = base64_decode($compCode);

        if ($cCode != "0") {
            $companyCode = base64_decode($compCode) . "%";
        } else {
            $companyCode = base64_decode($compCode);
        }


        $queryCon = "";
        if ($empCode != 0) {
            $queryCon .= "KraTarget.emp_code = $empCode AND ";
        } else {
            $queryCon .= "";
            $empCode = 0;
        }

        if ($financialYear != "" && $companyCode != "0") {
            $queryCon .= "KraTarget.financial_year = $financialYear AND ";
        } else {
            $queryCon .= "";
        }

        if ($financialYear != "" && $companyCode == "0") {
            $queryCon .= "KraTarget.financial_year = $financialYear";
        } else {
            $queryCon .= "";
        }

         if ($companyCode != "" && $companyCode != "0") {
            $queryCon .= "myprofile.location_code LIKE '$companyCode'";
			$query = "where `myprofile`.`status`='32' and myprofile.location_code LIKE '$companyCode'";
        } else {
            $queryCon .= "";
			$query = "where `myprofile`.`status`='32'";
        }

        if ($companyCode == "0") {
            $queryCon .= "";
        }

        $conditions = array($queryCon);
		$conditions1 = array($query);
       
        $header = array('Sr_No', 'Employee_Code', 'Name', 'Location', 'Department', 'Designation', 'Date_of_Joining', 'Appraiser_Name', 'Appraiser_Designation', 'Reviewer_Name', 'Reviewer_Designation', 'Moderator_Name', 'Moderator_Designation', 'Level_1_Status', 'Level_2_Status', 'Level_3_Status');
		
     // Configure::write('debug',2);
		//echo $empCode.$cCode;
		if($empCode != 0){
		//	echo'aaaaaa'.$cCode;
			
			$report =  $this->MyProfile->query("SELECT myprofile.desg_code,myprofile.emp_full_name,myprofile.comp_code,myprofile.emp_code,myprofile.location_code FROM `myprofile` AS `MyProfile` inner JOIN `kra_target` AS `KraTarget` ON (`KraTarget`.`emp_code` = `myprofile`.`emp_code`) WHERE `myprofile`.`status`='32' and ".$conditions[0]." GROUP BY `KraTarget`.`emp_code` ");
			$k='MyProfile';
			
		}else{
			//Configure::write('debug',2);
		//	echo'ssssssss'.$cCode;
			$report =  $this->MyProfile->query("SELECT myprofile.desg_code,myprofile.emp_full_name,myprofile.comp_code,myprofile.emp_code,myprofile.location_code FROM `myprofile` AS `MyProfile` UNION
SELECT myprofile.desg_code,myprofile.emp_full_name,myprofile.comp_code,myprofile.emp_code,myprofile.location_code FROM `myprofile` AS `MyProfile` inner JOIN `assign_competency_dept_desg` AS `acdd` ON (`acdd`.`emp_id` = `myprofile`.`emp_code`) ".$conditions1[0]."
UNION 
SELECT myprofile.desg_code,myprofile.emp_full_name,myprofile.comp_code,myprofile.emp_code,myprofile.location_code FROM `myprofile` AS `MyProfile` inner JOIN `assign_group_to_desg_details` AS `agtdd` ON (`agtdd`.`desg_id` = `myprofile`.`desg_code`) ".$conditions1[0]."  ");
		$k=0;	
		}
		 
		//echo '<pre>';print_r($report);die;
		 $ctr = 1;
		foreach ($report as $key => $val1) {
			$location = $this->EmpDetail->getCompanyName($val1[$k]['comp_code']);
            $desgCode = $this->EmpDetail->findDesignationByEmpCode($val1[$k]['emp_code']);
            $desgName = $this->EmpDetail->findDesignationName($desgCode, $val1[$k]['comp_code']);
			
			$deptCode = $this->EmpDetail->findDepartmentByEmpCode($val1[$k]['emp_code']); 
            $deptName = $this->EmpDetail->findDepartmentNameByCode($deptCode);

            $empDetails = $this->EmpDetail->getEmpDetails($val1[$k]['emp_code']);

            $joiningDate = date('d-m-Y', strtotime($empDetails['MyProfile']['join_date']));
            $manager_code = $this->EmpDetail->findEmpName($empDetails['MyProfile']['manager_code']);

            $AppraiserDesgCode = $this->EmpDetail->getempdesgcode($empDetails['MyProfile']['manager_code']);
            $appraiserDesgName = $this->EmpDetail->findDesignationName($AppraiserDesgCode, $empDetails['MyProfile']['comp_code']);

            $reviewerManagerCode = $this->EmpDetail->getManagerCode($empDetails['MyProfile']['manager_code']);
            $reviewerCode = $this->EmpDetail->findEmpName($reviewerManagerCode);
            $reviewerDesgCode = $this->EmpDetail->getempdesgcode($reviewerManagerCode);
            $reviewerDesgName = $this->EmpDetail->findDesignationName($reviewerDesgCode, $empDetails['MyProfile']['comp_code']);

            $moderatorManagerCode = $this->EmpDetail->getManagerCode($reviewerManagerCode);
            $moderatorDesgCode = $this->EmpDetail->getempdesgcode($moderatorManagerCode);
            $moderatorDesgName = $this->EmpDetail->findDesignationName($moderatorDesgCode, $empDetails['MyProfile']['comp_code']);
			$moderatorName = $this->EmpDetail->findEmpName($moderatorManagerCode);


            $empCode = $val1[$k]['emp_code'];
            $empName = ucfirst($this->EmpDetail->findEmpName($val1[$k]['emp_code']));

            $empDetails = $this->Common->getEmpDetails($val1[$k]['emp_code']);
            $listName = $this->Common->findInvestName($val1[$k]['location_code']);

            $locationName = $listName['OptionAttribute']['name'];
			
			$totalKRAs = $this->Common->getKraTargetDetails($val1[$k]['emp_code'],$financialYear);
			
			$empKraApprovedStatus = $this->Common->getKraTargetOpenStatusForEmp($val1[$k]['emp_code'],$financialYear);
			$empKraApprovedStatus1 = $this->Common->getKraTargetOpenStatusForEmp1($val1[$k]['emp_code'],$financialYear);
			 
			$appKraApprovedStatus = $this->Common->getKraTargetRevertStatusforEmpByAppraiser($val1[$k]['emp_code'],$financialYear);
			
			$revKraApprovedStatus = $this->Common->getKraTargetRevertStatusforEmpByReviewer($val1[$k]['emp_code'],$financialYear);
			
		   /*  if($empApprovedStatus == 0){                                        
				$levelZeroStatus = "Completed";
			}else{
				$levelZeroStatus = "Pending";
			} */

			if(count($empKraApprovedStatus) >= 1 || count($empKraApprovedStatus1) >= 1){                                        
				$levelOneStatus = "Completed";
			}else{
				if(count($totalKRAs)>=1){$levelOneStatus = "Pending";}else{$levelOneStatus = "Not Initiated";}
				
			}

			if(count($appKraApprovedStatus) < 1){                                        
				if(count($totalKRAs)>=1){$levelTwoStatus = "Completed";}else{$levelTwoStatus = "";}
			}else{
				$levelTwoStatus = "Pending";
			}
			if($reviewerManagerCode==0){
				$levelThreeStatus = "N/A";
			}else{
				if(count($revKraApprovedStatus) < 1){   
					if(count($totalKRAs)>=1){$levelThreeStatus = "Completed";}else{$levelThreeStatus = "";}				
					
				}else{
					$levelThreeStatus = "Pending";
				}
			}

		   /*  if($modSelfScoreStatus >= 1){
				$levelFourStatus = "Completed";
			}else{
				$levelFourStatus = "Pending";
			} */
			
//echo '<pre>';print_r($val1[$k]);die;
						
            
            # code...
            $val['Sr_no'] = $ctr;
            $val['Employee_Code'] = $empDetails['MyProfile']['emp_id'];
            $val['Name'] = $empName;
            $val['Location'] = $locationName;
			$val['Department'] = $deptName;
            $val['Designation'] = $desgName;
            $val['Date_of_Joining'] = $joiningDate;
            $val['Appraiser_Name'] = $manager_code;
            $val['Appraiser_Designation'] = $appraiserDesgName;
            $val['Reviewer_Name'] = $reviewerCode;
            $val['Reviewer_Designation'] = $reviewerDesgName;
            $val['Moderator_Name'] = $moderatorName;
            $val['Moderator_Designation'] = $moderatorDesgName;
            $val['Level_1_Status'] = $levelOneStatus;
            $val['Level_2_Status'] = $levelTwoStatus;
            $val['Level_3_Status'] = $levelThreeStatus;
          
            $input_array[$ctr] = $val;

            $ctr++;
		
	//echo '<pre>';print_r($input_array);die;
        }
		
		
		//echo '<pre>';print_r($input_array);die;

        //$this->convert_to_csv_download($input_array, $header, 'KRA_Approval_Report.csv', ' ');
		$this->excel($input_array, $header, 'KRA_Approval_Report.xls');
    }
	
	function kraApprovalReportFile($employeeCode, $fYear, $compCode) {
       // Configure::write('debug',2);
        $this->autoRender = false;
        $empCode = base64_decode($employeeCode);
        $financialYear = base64_decode($fYear);

        $cCode = base64_decode($compCode);

        if ($cCode != "0") {
            $companyCode = base64_decode($compCode) . "%";
        } else {
            $companyCode = base64_decode($compCode);
        }


        $queryCon = "";
        if ($empCode != 0) {
            $queryCon .= "KraTarget.emp_code = $empCode AND ";
        } else {
            $queryCon .= "";
            $empCode = 0;
        }

        if ($financialYear != "" && $companyCode != "0") {
            $queryCon .= "KraTarget.financial_year = $financialYear AND ";
        } else {
            $queryCon .= "";
        }

        if ($financialYear != "" && $companyCode == "0") {
            $queryCon .= "KraTarget.financial_year = $financialYear";
        } else {
            $queryCon .= "";
        }

         if ($companyCode != "" && $companyCode != "0") {
            $queryCon .= "myprofile.location_code LIKE '$companyCode'";
			$query = "where `myprofile`.`status`='32' and myprofile.location_code LIKE '$companyCode'";
        } else {
            $queryCon .= "";
			$query = "where `myprofile`.`status`='32'";
        }

        if ($companyCode == "0") {
            $queryCon .= "";
        }

        $conditions = array($queryCon);
		$conditions1 = array($query);
       
        $header = array('Sr_No', 'Employee_Code', 'Name', 'Location', 'Department', 'Designation', 'Date_of_Joining', 'Appraiser_Name', 'Appraiser_Designation', 'Reviewer_Name', 'Reviewer_Designation', 'Moderator_Name', 'Moderator_Designation', 'Level_1_Status', 'Level_2_Status', 'Level_3_Status');
		
     // Configure::write('debug',2);
		//echo $empCode.$cCode;
		if($empCode != 0){
		//	echo'aaaaaa'.$cCode;
			
			$report =  $this->MyProfile->query("SELECT myprofile.desg_code,myprofile.emp_full_name,myprofile.comp_code,myprofile.emp_code,myprofile.location_code FROM `myprofile` AS `MyProfile` inner JOIN `kra_target` AS `KraTarget` ON (`KraTarget`.`emp_code` = `myprofile`.`emp_code`) WHERE `myprofile`.`status`='32' and ".$conditions[0]." GROUP BY `KraTarget`.`emp_code` ");
			$k='MyProfile';
			
		}else{
			//Configure::write('debug',2);
		//	echo'ssssssss'.$cCode;
			$report =  $this->MyProfile->query("SELECT myprofile.desg_code,myprofile.emp_full_name,myprofile.comp_code,myprofile.emp_code,myprofile.location_code FROM `myprofile` AS `MyProfile` inner JOIN `kra_target` AS `KraTarget` ON (`KraTarget`.`emp_code` = `myprofile`.`emp_code`) WHERE `myprofile`.`status`='32' and ".$conditions[0]." GROUP BY `KraTarget`.`emp_code` 
UNION
SELECT myprofile.desg_code,myprofile.emp_full_name,myprofile.comp_code,myprofile.emp_code,myprofile.location_code FROM `myprofile` AS `MyProfile` inner JOIN `assign_competency_dept_desg` AS `acdd` ON (`acdd`.`emp_id` = `myprofile`.`emp_code`) ".$conditions1[0]."
UNION 
SELECT myprofile.desg_code,myprofile.emp_full_name,myprofile.comp_code,myprofile.emp_code,myprofile.location_code FROM `myprofile` AS `MyProfile` inner JOIN `assign_group_to_desg_details` AS `agtdd` ON (`agtdd`.`desg_id` = `myprofile`.`desg_code`) ".$conditions1[0]."  ");
		$k=0;	
		}
		 
		//echo '<pre>';print_r($report);die;
		 $ctr = 1;
		foreach ($report as $key => $val1) {
			$location = $this->EmpDetail->getCompanyName($val1[$k]['comp_code']);
            $desgCode = $this->EmpDetail->findDesignationByEmpCode($val1[$k]['emp_code']);
            $desgName = $this->EmpDetail->findDesignationName($desgCode, $val1[$k]['comp_code']);
			
			$deptCode = $this->EmpDetail->findDepartmentByEmpCode($val1[$k]['emp_code']); 
            $deptName = $this->EmpDetail->findDepartmentNameByCode($deptCode);

            $empDetails = $this->EmpDetail->getEmpDetails($val1[$k]['emp_code']);

            $joiningDate = date('d-m-Y', strtotime($empDetails['MyProfile']['join_date']));
            $manager_code = $this->EmpDetail->findEmpName($empDetails['MyProfile']['manager_code']);

            $AppraiserDesgCode = $this->EmpDetail->getempdesgcode($empDetails['MyProfile']['manager_code']);
            $appraiserDesgName = $this->EmpDetail->findDesignationName($AppraiserDesgCode, $empDetails['MyProfile']['comp_code']);

            $reviewerManagerCode = $this->EmpDetail->getManagerCode($empDetails['MyProfile']['manager_code']);
            $reviewerCode = $this->EmpDetail->findEmpName($reviewerManagerCode);
            $reviewerDesgCode = $this->EmpDetail->getempdesgcode($reviewerManagerCode);
            $reviewerDesgName = $this->EmpDetail->findDesignationName($reviewerDesgCode, $empDetails['MyProfile']['comp_code']);

            $moderatorManagerCode = $this->EmpDetail->getManagerCode($reviewerManagerCode);
            $moderatorDesgCode = $this->EmpDetail->getempdesgcode($moderatorManagerCode);
            $moderatorDesgName = $this->EmpDetail->findDesignationName($moderatorDesgCode, $empDetails['MyProfile']['comp_code']);
			$moderatorName = $this->EmpDetail->findEmpName($moderatorManagerCode);


            $empCode = $val1[$k]['emp_code'];
            $empName = ucfirst($this->EmpDetail->findEmpName($val1[$k]['emp_code']));

            $empDetails = $this->Common->getEmpDetails($val1[$k]['emp_code']);
            $listName = $this->Common->findInvestName($val1[$k]['location_code']);

            $locationName = $listName['OptionAttribute']['name'];
			
			$totalKRAs = $this->Common->getKraTargetDetails($val1[$k]['emp_code'],$financialYear);
			
			$empKraApprovedStatus = $this->Common->getKraTargetOpenStatusForEmp($val1[$k]['emp_code'],$financialYear);
			$empKraApprovedStatus1 = $this->Common->getKraTargetOpenStatusForEmp1($val1[$k]['emp_code'],$financialYear);
			 
			$appKraApprovedStatus = $this->Common->getKraTargetRevertStatusforEmpByAppraiser($val1[$k]['emp_code'],$financialYear);
			
			$revKraApprovedStatus = $this->Common->getKraTargetRevertStatusforEmpByReviewer($val1[$k]['emp_code'],$financialYear);
			
		   /*  if($empApprovedStatus == 0){                                        
				$levelZeroStatus = "Completed";
			}else{
				$levelZeroStatus = "Pending";
			} */

			if(count($empKraApprovedStatus) >= 1 || count($empKraApprovedStatus1) >= 1){                                        
				$levelOneStatus = "Completed";
			}else{
				if(count($totalKRAs)>=1){$levelOneStatus = "Pending";}else{$levelOneStatus = "Not Initiated";}
				
			}

			if(count($appKraApprovedStatus) < 1){                                        
				if(count($totalKRAs)>=1){$levelTwoStatus = "Completed";}else{$levelTwoStatus = "";}
			}else{
				$levelTwoStatus = "Pending";
			}
			if($reviewerManagerCode==0){
				$levelThreeStatus = "N/A";
			}else{
				if(count($revKraApprovedStatus) < 1){   
					if(count($totalKRAs)>=1){$levelThreeStatus = "Completed";}else{$levelThreeStatus = "";}				
					
				}else{
					$levelThreeStatus = "Pending";
				}
			}

		   /*  if($modSelfScoreStatus >= 1){
				$levelFourStatus = "Completed";
			}else{
				$levelFourStatus = "Pending";
			} */
			
//echo '<pre>';print_r($val1[$k]);die;
						
            
            # code...
            $val['Sr_no'] = $ctr;
            $val['Employee_Code'] = $empDetails['MyProfile']['emp_id'];
            $val['Name'] = $empName;
            $val['Location'] = $locationName;
			$val['Department'] = $deptName;
            $val['Designation'] = $desgName;
            $val['Date_of_Joining'] = $joiningDate;
            $val['Appraiser_Name'] = $manager_code;
            $val['Appraiser_Designation'] = $appraiserDesgName;
            $val['Reviewer_Name'] = $reviewerCode;
            $val['Reviewer_Designation'] = $reviewerDesgName;
            $val['Moderator_Name'] = $moderatorName;
            $val['Moderator_Designation'] = $moderatorDesgName;
            $val['Level_1_Status'] = $levelOneStatus;
            $val['Level_2_Status'] = $levelTwoStatus;
            $val['Level_3_Status'] = $levelThreeStatus;
          
            $input_array[$ctr] = $val;

            $ctr++;
		
	//echo '<pre>';print_r($input_array);die;
        }
		
		
		//echo '<pre>';print_r($input_array);die;

        //$this->convert_to_csv_download($input_array, $header, 'KRA_Approval_Report.csv', ' ');
		$this->excel($input_array, $header, 'KRA_Approval_Report.xls');
    }
	
	function kraMidReviewReportFile($employeeCode, $fYear, $compCode) {
       // Configure::write('debug',2);
        $this->autoRender = false;
        $empCode = base64_decode($employeeCode);
        $financialYear = base64_decode($fYear);
//die;
        $cCode = base64_decode($compCode);

        if ($cCode != "0") {
            $companyCode = base64_decode($compCode) . "%";
        } else {
            $companyCode = base64_decode($compCode);
        }


        $queryCon = "";
        if ($empCode != 0) {
            $queryCon .= "KraTarget.emp_code = $empCode AND ";
        } else {
            $queryCon .= "";
            $empCode = 0;
        }

        if ($financialYear != "" && $companyCode != "0") {
            $queryCon .= "KraTarget.financial_year = $financialYear AND ";
        } else {
            $queryCon .= "";
        }

        if ($financialYear != "" && $companyCode == "0") {
            $queryCon .= "KraTarget.financial_year = $financialYear";
        } else {
            $queryCon .= "";
        }

        if ($companyCode == "0") {
            $queryCon .= "";
			
        }
		$queryCon .= " AND myprofile.status=32";
        $conditions = array($queryCon);
        $kraRecordList = $this->KraTarget->find('all', array(
            'joins' => array(
                
				array(
						'table' => 'mid_reviews',
						'alias' => 'MidReviews',
						'type' => 'inner',
						'foreignKey' => false,
						'conditions' => array('MidReviews.emp_code = KraTarget.emp_code')
					),
					array(
						'table' => 'myprofile',
						'alias' => 'myprofile',
						'type' => 'inner',
						'foreignKey' => false,
						'conditions' => array('myprofile.emp_code = KraTarget.emp_code')
					)
            ),
            'fields' => array('KraTarget.*'),
            'conditions' => $conditions,
            'group' => array('KraTarget.emp_code'),
        ));

        $header = array('Sr_No', 'Employee_Code', 'Name', 'Location', 'Department', 'Designation', 'Date_of_Joining', 'Appraiser_Name', 'Appraiser_Designation', 'Reviewer_Name', 'Reviewer_Designation', 'Moderator_Name', 'Moderator_Designation', 'Level_1_Status', 'Level_2_Status', 'Level_3_Status', 'Level_4_Status');


        $ctr = 1;
	//print_r($kraRecordList);die;
        foreach ($kraRecordList as $key => $value) {

            $empApprovedStatus = count($this->Common->getKraTargetRevertStatusforEmp($kraRecordList[$key]['KraTarget']['emp_code'], $kraRecordList[$key]['KraTarget']['financial_year']));
            $empMidStatus = $this->Common->findMidReviewsDetailsEmp($kraRecordList[$key]['KraTarget']['emp_code'], $kraRecordList[$key]['KraTarget']['financial_year']);
            $appMidStatus = $this->Common->findMidReviewsDetailsApp($kraRecordList[$key]['KraTarget']['emp_code'], $kraRecordList[$key]['KraTarget']['financial_year']);
            $rewMidStatus = $this->Common->findMidReviewsDetailsRev($kraRecordList[$key]['KraTarget']['emp_code'], $kraRecordList[$key]['KraTarget']['financial_year']);
            $modMidStatus = $this->Common->findMidReviewsDetailsMod($kraRecordList[$key]['KraTarget']['emp_code'], $kraRecordList[$key]['KraTarget']['financial_year']);
/* 
            if ($empApprovedStatus == 0) {
                $levelZeroStatus = "Completed";
            } else {
                $levelZeroStatus = "Pending";
            } */

            if ($empMidStatus >= 1) {
                $levelOneStatus = "Completed";
            } else {
                $levelOneStatus = "Pending";
            }

            if ($appMidStatus >= 1) {
                $levelTwoStatus = "Completed";
            } else {
                $levelTwoStatus = "Pending";
            }

            if ($rewMidStatus >= 1) {
                $levelThreeStatus = "Completed";
            } else {
                $levelThreeStatus = "Pending";
            }

            if ($modMidStatus >= 1) {
                $levelFourStatus = "Completed";
            } else {
                $levelFourStatus = "Pending";
            }

            $location = $this->EmpDetail->getCompanyName($kraRecordList[$key]['KraTarget']['comp_code']);
            $desgCode = $this->EmpDetail->findDesignationByEmpCode($kraRecordList[$key]['KraTarget']['emp_code']);
            $desgName = $this->EmpDetail->findDesignationName($desgCode, $kraRecordList[$key]['KraTarget']['comp_code']);

            $empDetails1 = $this->EmpDetail->getEmpDetails($kraRecordList[$key]['KraTarget']['emp_code']);

			$joiningDate = date('d-m-Y', strtotime($empDetails1['MyProfile']['join_date']));
            $manager_code = $this->EmpDetail->findEmpName($empDetails1['MyProfile']['manager_code']);

            $AppraiserDesgCode = $this->EmpDetail->getempdesgcode($empDetails1['MyProfile']['manager_code']);
            $appraiserDesgName = $this->EmpDetail->findDesignationName($AppraiserDesgCode, $empDetails1['MyProfile']['comp_code']);

            $reviewerManagerCode = $this->EmpDetail->getManagerCode($empDetails1['MyProfile']['manager_code']);
            $reviewerCode = $this->EmpDetail->findEmpName($reviewerManagerCode);

            $reviewerDesgCode = $this->EmpDetail->getempdesgcode($reviewerManagerCode);
            $reviewerDesgName = $this->EmpDetail->findDesignationName($reviewerDesgCode, $empDetails1['MyProfile']['comp_code']);

            $moderatorName = $this->EmpDetail->findEmpName($kraRecordList[$key]['KraTarget']['moderator_id']);


            $moderatorManagerCode = $this->EmpDetail->getManagerCode($kraRecordList[$key]['KraTarget']['moderator_id']);
            $moderatorDesgCode = $this->EmpDetail->getempdesgcode($kraRecordList[$key]['KraTarget']['moderator_id']);
            $moderatorDesgName = $this->EmpDetail->findDesignationName($moderatorDesgCode, $empDetails1['MyProfile']['comp_code']);


            $empCode = $kraRecordList[$key]['KraTarget']['emp_code'];
            $empName = ucfirst($this->EmpDetail->findEmpName($kraRecordList[$key]['KraTarget']['emp_code']));

            $empDetails = $this->Common->getEmpDetails($kraRecordList[$key]['KraTarget']['emp_code']);
            $listName = $this->Common->findInvestName($empDetails1['MyProfile']['location_code']);

            $locationName = $listName['OptionAttribute']['name'];
			$deptCode = $this->EmpDetail->findDepartmentByEmpCode($kraRecordList[$key]['KraTarget']['emp_code']);
            $deptName = $this->EmpDetail->findDepartmentNameByCode($deptCode);

            # code...
            $val['Sr_no'] = $ctr;
            $val['Employee_Code'] = $empDetails['MyProfile']['emp_id'];
            $val['Name'] = $empName;
            $val['Location'] = $locationName;
			$val['Department'] = $deptName;
            $val['Designation'] = $desgName;
            $val['Date_of_Joining'] = $joiningDate;
            $val['Appraiser_Name'] = $manager_code;
            $val['Appraise_Designation'] = $appraiserDesgName;
            $val['Reviewer_Name'] = $reviewerCode;
            $val['Reviewer_Designation'] = $reviewerDesgName;
            $val['Moderator_Name'] = $moderatorName;
            $val['Moderator_Designation'] = $moderatorDesgName;
            //$val['Level_0_Status'] = $levelZeroStatus;
            $val['Level_1_Status'] = $levelOneStatus;
            $val['Level_2_Status'] = $levelTwoStatus;
            $val['Level_3_Status'] = $levelThreeStatus;
            $val['Level_4_Status'] = $levelFourStatus;

            $input_array[$ctr] = $val;

            $ctr++;
        }

        //$this->convert_to_csv_download($input_array, $header, 'KRA_Assessment_Report.csv', ' ');
		$this->excel($input_array, $header, 'KRA_Mid_Review_Report.xls');
    }


    function kraAssessmentReportFile($employeeCode, $fYear, $compCode) {
        //Configure::write('debug',2);
        $this->autoRender = false;
        $empCode = base64_decode($employeeCode);
        $financialYear = base64_decode($fYear);

        $cCode = base64_decode($compCode);

        if ($cCode != "0") {
            $companyCode = base64_decode($compCode) . "%";
        } else {
            $companyCode = base64_decode($compCode);
        }


        $queryCon = "";
        if ($empCode != 0) {
            $queryCon .= "KraTarget.emp_code = $empCode AND ";
        } else {
            $queryCon .= "";
            $empCode = 0;
        }

        if ($financialYear != "" && $companyCode != "0") {
            $queryCon .= "KraTarget.financial_year = $financialYear AND ";
        } else {
            $queryCon .= "";
        }

        if ($financialYear != "" && $companyCode == "0") {
            $queryCon .= "KraTarget.financial_year = $financialYear";
        } else {
            $queryCon .= "";
        }

        if ($companyCode != "" && $companyCode != "0") {
            $queryCon .= "myprofile.location_code LIKE '$companyCode'";
        } else {
            $queryCon .= "";
        }

        if ($companyCode == "0") {
            $queryCon .= "";
        }
		$queryCon .= " AND myprofile.status=32";
        $conditions = array($queryCon);
        $kraRecordList = $this->KraTarget->find('all', array(
            'joins' => array(
                array(
                    'table' => 'myprofile',
                    'alias' => 'myprofile',
                    'type' => 'inner',
                    'foreignKey' => false,
                    'conditions' => array('KraTarget.emp_code = myprofile.emp_code')
                )
            ),
            'fields' => array('KraTarget.*', 'myprofile.location_code'),
            'conditions' => $conditions,
            'group' => array('KraTarget.emp_code'),
        ));

        $header = array('Sr_No', 'Employee_Code', 'Name', 'Location', 'Department', 'Designation', 'Date_of_Joining', 'Appraiser_Name', 'Appraiser_Designation', 'Reviewer_Name', 'Reviewer_Designation', 'Moderator_Name', 'Moderator_Designation', 'Level_0_Status', 'Level_1_Status', 'Level_2_Status', 'Level_3_Status', 'Level_4_Status');


        $ctr = 1;
        foreach ($kraRecordList as $key => $value) {

            $empApprovedStatus = count($this->Common->getKraTargetRevertStatusforEmp($kraRecordList[$key]['KraTarget']['emp_code'], $kraRecordList[$key]['KraTarget']['financial_year']));
            $empSelfScoreStatus = $this->Common->getKraTargetLevelOne($kraRecordList[$key]['KraTarget']['emp_code'], $kraRecordList[$key]['KraTarget']['financial_year']);
            $appSelfScoreStatus = $this->Common->getKraTargetLevelTwo($kraRecordList[$key]['KraTarget']['emp_code'], $kraRecordList[$key]['KraTarget']['financial_year']);
            $rewSelfScoreStatus = $this->Common->getKraTargetLevelThree($kraRecordList[$key]['KraTarget']['emp_code'], $kraRecordList[$key]['KraTarget']['financial_year']);
            $modSelfScoreStatus = $this->Common->getKraTargetLevelFour($kraRecordList[$key]['KraTarget']['emp_code'], $kraRecordList[$key]['KraTarget']['financial_year']);

            if ($empApprovedStatus == 0) {
                $levelZeroStatus = "Completed";
            } else {
                $levelZeroStatus = "Pending";
            }

            if ($empSelfScoreStatus >= 1) {
                $levelOneStatus = "Completed";
            } else {
                $levelOneStatus = "Pending";
            }

            if ($appSelfScoreStatus >= 1) {
                $levelTwoStatus = "Completed";
            } else {
                $levelTwoStatus = "Pending";
            }

            if ($rewSelfScoreStatus >= 1) {
                $levelThreeStatus = "Completed";
            } else {
                $levelThreeStatus = "Pending";
            }

            if ($modSelfScoreStatus >= 1) {
                $levelFourStatus = "Completed";
            } else {
                $levelFourStatus = "Pending";
            }

            $location = $this->EmpDetail->getCompanyName($kraRecordList[$key]['KraTarget']['comp_code']);
            $desgCode = $this->EmpDetail->findDesignationByEmpCode($kraRecordList[$key]['KraTarget']['emp_code']);
            $desgName = $this->EmpDetail->findDesignationName($desgCode, $kraRecordList[$key]['KraTarget']['comp_code']);

            $empDetails = $this->EmpDetail->getEmpDetails($kraRecordList[$key]['KraTarget']['emp_code']);

            $joiningDate = date('d-m-Y', strtotime($empDetails['MyProfile']['join_date']));
            $manager_code = $this->EmpDetail->findEmpName($empDetails['MyProfile']['manager_code']);

            $AppraiserDesgCode = $this->EmpDetail->getempdesgcode($empDetails['MyProfile']['manager_code']);
            $appraiserDesgName = $this->EmpDetail->findDesignationName($AppraiserDesgCode, $empDetails['MyProfile']['comp_code']);

            $reviewerManagerCode = $this->EmpDetail->getManagerCode($empDetails['MyProfile']['manager_code']);
            $reviewerCode = $this->EmpDetail->findEmpName($reviewerManagerCode);

            $reviewerDesgCode = $this->EmpDetail->getempdesgcode($reviewerManagerCode);
            $reviewerDesgName = $this->EmpDetail->findDesignationName($reviewerDesgCode, $empDetails['MyProfile']['comp_code']);

            $moderatorName = $this->EmpDetail->findEmpName($kraRecordList[$key]['KraTarget']['moderator_id']);


            $moderatorManagerCode = $this->EmpDetail->getManagerCode($kraRecordList[$key]['KraTarget']['moderator_id']);
            $moderatorDesgCode = $this->EmpDetail->getempdesgcode($kraRecordList[$key]['KraTarget']['moderator_id']);
            $moderatorDesgName = $this->EmpDetail->findDesignationName($moderatorDesgCode, $empDetails['MyProfile']['comp_code']);


            $empCode = $kraRecordList[$key]['KraTarget']['emp_code'];
            $empName = ucfirst($this->EmpDetail->findEmpName($kraRecordList[$key]['KraTarget']['emp_code']));

            $empDetails = $this->Common->getEmpDetails($kraRecordList[$key]['KraTarget']['emp_code']);
            $listName = $this->Common->findInvestName($kraRecordList[$key]['myprofile']['location_code']);

            $locationName = $listName['OptionAttribute']['name'];
$deptCode = $this->EmpDetail->findDepartmentByEmpCode($kraRecordList[$key]['KraTarget']['emp_code']);
$deptName = $this->EmpDetail->findDepartmentNameByCode($deptCode);

            # code...
            $val['Sr_no'] = $ctr;
            $val['Employee_Code'] = $empDetails['MyProfile']['emp_id'];
            $val['Name'] = $empName;
            $val['Location'] = $locationName;
			$val['Department'] = $deptName;
            $val['Designation'] = $desgName;
            $val['Date_of_Joining'] = $joiningDate;
            $val['Appraiser_Name'] = $manager_code;
            $val['Appraise_Designation'] = $appraiserDesgName;
            $val['Reviewer_Name'] = $reviewerCode;
            $val['Reviewer_Designation'] = $reviewerDesgName;
            $val['Moderator_Name'] = $moderatorName;
            $val['Moderator_Designation'] = $moderatorDesgName;
            $val['Level_0_Status'] = $levelZeroStatus;
            $val['Level_1_Status'] = $levelOneStatus;
            $val['Level_2_Status'] = $levelTwoStatus;
            $val['Level_3_Status'] = $levelThreeStatus;
            $val['Level_4_Status'] = $levelFourStatus;

            $input_array[$ctr] = $val;

            $ctr++;
        }

        //$this->convert_to_csv_download($input_array, $header, 'KRA_Assessment_Report.csv', ' ');
		$this->excel($input_array, $header, 'KRA_Assessment_Report.xls');
    }

    public function overAllRatingReport() {
//Configure::write('debug',2);    
        $data = $this->Common->findFInancialYearDesc($this->Auth->User('comp_code'));
        $currentFinancialYear = $data['FinancialYear']['id'];

        $empList = $this->KraTarget->find('all', array(
            'fields' => array('MyProfile.emp_code', 'MyProfile.emp_id', 'MyProfile.emp_full_name'),
            'order' => array('MyProfile.emp_full_name ASC'),
            'joins' => array(
                array(
                    'table' => 'myprofile',
                    'alias' => 'MyProfile',
                    'type' => 'left',
                    'foreignKey' => false,
                    'conditions' => array('KraTarget.emp_code = MyProfile.emp_code')
                )),
            'group' => array('KraTarget.emp_code')
        ));

        $this->set('empList', $empList);
        $this->set('currentFinancialYear', $currentFinancialYear);

        if (isset($this->request->data['comp_code'])) {
            $queryCon = "";
            if ($this->request->data['emp_id'] != 0) {
                $empCode = $this->request->data['emp_id'];
                $queryCon .= "KraCompOverallRating.emp_code = $empCode AND ";
            } else {
                $queryCon .= "";
                $empCode = 0;
            }

            if ($this->request->data['financialYear'] != "" && $this->request->data['comp_code'] != "0") {
                $financialYear = $this->request->data['financialYear'];
                $queryCon .= "KraCompOverallRating.financial_year = $financialYear AND ";
            } else {
                $queryCon .= "";
            }

            if ($this->request->data['financialYear'] != "" && $this->request->data['comp_code'] == "0") {
                $financialYear = $this->request->data['financialYear'];
                $queryCon .= "KraCompOverallRating.financial_year = $financialYear";
            } else {
                $queryCon .= "";
            }

            if ($this->request->data['comp_code'] != "" && $this->request->data['comp_code'] != "0") {
                $compCode = $this->request->data['comp_code'] . "%";
                $queryCon .= "myprofile.location_code LIKE '$compCode'";
            } else {
                $queryCon .= "";
            }

            if ($this->request->data['comp_code'] == "0") {
                $compCode = $this->request->data['comp_code'];
                $queryCon .= "";
            }
			$queryCon .= " AND myprofile.status=32";
            $conditions = array($queryCon);
            $this->paginate = array(
                'joins' => array(
                    array(
                        'table' => 'myprofile',
                        'alias' => 'myprofile',
                        'type' => 'inner',
                        'foreignKey' => false,
                        'conditions' => array('KraCompOverallRating.emp_code = myprofile.emp_code')
                    ),
					array(
                        'table' => 'appraisal_process',
                        'alias' => 'appraisal_process',
                        'type' => 'inner',
                        'foreignKey' => false,
                        'conditions' => array('KraCompOverallRating.emp_code = appraisal_process.emp_code')
                    )
                ),
                'fields' => array('KraCompOverallRating.*', 'myprofile.location_code'),
                'conditions' => $conditions,
                'group' => array('KraCompOverallRating.emp_code'),
			'limit' => 500
            );

            $kraCompOverallRatingList = $this->paginate('KraCompOverallRating');
            $this->set('kraCompOverallRatingList', $kraCompOverallRatingList);

            $this->set("empCode", $empCode);
            $this->set("fYear", $financialYear);
            $this->set("companyCode", $this->request->data['comp_code']);
        }
    }

    function overAllRatingReportFile($employeeCode, $fYear, $compCode) {
        ob_start();
        $this->autoRender = false;
        $empCode = base64_decode($employeeCode);
        $financialYear = base64_decode($fYear);
        $cCode = base64_decode($compCode);

        if ($cCode != "0") {
            $companyCode = base64_decode($compCode) . "%";
        } else {
            $companyCode = base64_decode($compCode);
        }

        $queryCon = "";
        if ($empCode != 0) {
            $queryCon .= "KraCompOverallRating.emp_code = $empCode AND ";
        } else {
            $queryCon .= "";
            $empCode = 0;
        }

        if ($financialYear != "" && $companyCode != "0") {
            $queryCon .= "KraCompOverallRating.financial_year = $financialYear AND ";
        } else {
            $queryCon .= "";
        }

        if ($financialYear != "" && $companyCode == "0") {
            $queryCon .= "KraCompOverallRating.financial_year = $financialYear";
        } else {
            $queryCon .= "";
        }

        if ($companyCode != "" && $companyCode != "0") {
            $queryCon .= "myprofile.location_code LIKE '$companyCode'";
        } else {
            $queryCon .= "";
        }

        if ($companyCode == "0") {
            $queryCon .= "";
        }
$queryCon .= " AND myprofile.status=32";
        $conditions = array($queryCon);
        $kraCompOverallRatingList = $this->KraCompOverallRating->find('all', array(
            'joins' => array(
                array(
                    'table' => 'MyProfile',
                    'alias' => 'myprofile',
                    'type' => 'inner',
                    'foreignKey' => false,
                    'conditions' => array('KraCompOverallRating.emp_code = myprofile.emp_code')
                )
            ),
            'fields' => array('KraCompOverallRating.*', 'myprofile.location_code'),
            'conditions' => $conditions,
            'group' => array('KraCompOverallRating.emp_code')
        ));



        $header = array('Sr_No', 'Employee_Code', 'Name', 'Location', 'Department', 'Designation', 'Date_of_Joining', 'Appraiser_Name', 'Appraiser_Designation', 'Reviewer_Name', 'Reviewer_Designation', 'Moderator_Name', 'Moderator_Designation', 'Emp_KRA_Rating', 'Appraiser_KRA_&_Competency_Rating', 'Reviewer_KRA_&_Competency_Rating', 'Moderator_KRA_&_Competency_Rating', 'KRA_&_Competency_Overall_Rating', 'KRA_&_Competency_Overall_Result');


        $ctr = 1;
        foreach ($kraCompOverallRatingList as $key => $value) {



            $location = $this->EmpDetail->getCompanyName($kraCompOverallRatingList[$key]['KraCompOverallRating']['comp_code']);
            $desgCode = $this->EmpDetail->findDesignationByEmpCode($kraCompOverallRatingList[$key]['KraCompOverallRating']['emp_code']);
            $desgName = $this->EmpDetail->findDesignationName($desgCode, $kraCompOverallRatingList[$key]['KraCompOverallRating']['comp_code']);

            $empDetails = $this->EmpDetail->getEmpDetails($kraCompOverallRatingList[$key]['KraCompOverallRating']['emp_code']);

            $joiningDate = date('d-m-Y', strtotime($empDetails['MyProfile']['join_date']));
            $manager_code = $this->EmpDetail->findEmpName($empDetails['MyProfile']['manager_code']);

            $AppraiserDesgCode = $this->EmpDetail->getempdesgcode($empDetails['MyProfile']['manager_code']);
            $appraiserDesgName = $this->EmpDetail->findDesignationName($AppraiserDesgCode, $empDetails['MyProfile']['comp_code']);

            $reviewerManagerCode = $this->EmpDetail->getManagerCode($empDetails['MyProfile']['manager_code']);
            $reviewerCode = $this->EmpDetail->findEmpName($reviewerManagerCode);

            $reviewerDesgCode = $this->EmpDetail->getempdesgcode($reviewerManagerCode);
            $reviewerDesgName = $this->EmpDetail->findDesignationName($reviewerDesgCode, $empDetails['MyProfile']['comp_code']);

            $moderatorName = $this->EmpDetail->findEmpName($kraCompOverallRatingList[$key]['KraCompOverallRating']['moderator_id']);


            $moderatorManagerCode = $this->EmpDetail->getManagerCode($kraCompOverallRatingList[$key]['KraCompOverallRating']['moderator_id']);
            $moderatorDesgCode = $this->EmpDetail->getempdesgcode($kraCompOverallRatingList[$key]['KraCompOverallRating']['moderator_id']);
            $moderatorDesgName = $this->EmpDetail->findDesignationName($moderatorDesgCode, $empDetails['MyProfile']['comp_code']);


            $empCode = $kraCompOverallRatingList[$key]['KraCompOverallRating']['emp_code'];
            $empName = ucfirst($this->EmpDetail->findEmpName($kraCompOverallRatingList[$key]['KraCompOverallRating']['emp_code']));

            $emp_self_overall_rating = $this->Common->truncate_number($kraCompOverallRatingList[$key]['KraCompOverallRating']['emp_self_overall_rating']);
            $appraiser_self_overall_rating = $this->Common->truncate_number($kraCompOverallRatingList[$key]['KraCompOverallRating']['appraiser_self_overall_rating']);
            $appraiser_comp_overall_rating = $this->Common->truncate_number($kraCompOverallRatingList[$key]['KraCompOverallRating']['appraiser_comp_overall_rating']);

            $reviewer_self_overall_rating = $this->Common->truncate_number($kraCompOverallRatingList[$key]['KraCompOverallRating']['reviewer_self_overall_rating']);
            $reviewer_comp_overall_rating = $this->Common->truncate_number($kraCompOverallRatingList[$key]['KraCompOverallRating']['reviewer_comp_overall_rating']);
            $moderator_self_overall_rating = $this->Common->truncate_number($kraCompOverallRatingList[$key]['KraCompOverallRating']['moderator_self_overall_rating']);
            $moderator_comp_overall_rating = $this->Common->truncate_number($kraCompOverallRatingList[$key]['KraCompOverallRating']['moderator_comp_overall_rating']);

            $kra_overall_rating = $this->Common->truncate_number($kraCompOverallRatingList[$key]['KraCompOverallRating']['kra_overall_rating']);
            $comp_overall_rating = $this->Common->truncate_number($kraCompOverallRatingList[$key]['KraCompOverallRating']['comp_overall_rating']);
            $kra_comp_overall_rating = $this->Common->truncate_number($kraCompOverallRatingList[$key]['KraCompOverallRating']['kra_comp_overall_rating']);
            $kra_comp_overall_result = $kraCompOverallRatingList[$key]['KraCompOverallRating']['kra_comp_overall_result'];

            $empDetails = $this->Common->getEmpDetails($kraCompOverallRatingList[$key]['KraCompOverallRating']['emp_code']);
            $empID = $empDetails['MyProfile']['emp_id'];
            $listName = $this->Common->findInvestName($kraCompOverallRatingList[$key]['myprofile']['location_code']);

            $locationName = $listName['OptionAttribute']['name'];
$deptCode = $this->EmpDetail->findDepartmentByEmpCode($kraCompOverallRatingList[$key]['KraCompOverallRating']['emp_code']);
$deptName = $this->EmpDetail->findDepartmentNameByCode($deptCode);
            # code...
            $val['Sr_no'] = $ctr;
            $val['Employee_Code'] = $empID;
            $val['Name'] = $empName;
            $val['Location'] = $locationName;
			$val['Department'] = $deptName;
            $val['Designation'] = $desgName;
            $val['Date_of_Joining'] = $joiningDate;
            $val['Appraiser_Name'] = $manager_code;
            $val['Appraiser_Designation'] = $appraiserDesgName;
            $val['Reviewer_Name'] = $reviewerCode;
            $val['Reviewer_Designation'] = $reviewerDesgName;
            $val['Moderator_Name'] = $moderatorName;
            $val['Moderator_Designation'] = $moderatorDesgName;
            $val['Emp_KRA_Rating'] = $emp_self_overall_rating;
            $val['Appraiser_KRA_&_Competency_Rating'] = $appraiser_self_overall_rating . " / " . $appraiser_comp_overall_rating;
            $val['Reviewer_KRA_&_Competency_Rating'] = $reviewer_self_overall_rating . " / " . $reviewer_comp_overall_rating;
            $val['Moderator_KRA_&_Competency_Rating'] = $moderator_self_overall_rating . " / " . $moderator_comp_overall_rating;
            $val['KRA_&_Competency_Overall_Rating'] = $kra_overall_rating . " / " . $comp_overall_rating;
            $val['KRA_&_Competency_Overall_Result'] = $kra_comp_overall_rating . " / " . $kra_comp_overall_result;

            $input_array[$ctr] = $val;

            $ctr++;
        }

        //$this->convert_to_csv_download($input_array, $header, 'KRA_Competency_OverAll_Rating_Report.csv', ' ');
		$this->excel($input_array, $header, 'KRA_Competency_OverAll_Rating_Report.xls');
    }

    public function developmentPlanReport() {
        //Configure::write('debug',2);    
        $data = $this->Common->findFInancialYearDesc($this->Auth->User('comp_code'));
        $currentFinancialYear = $data['FinancialYear']['id'];

        $empList = $this->KraTarget->find('all', array(
            'fields' => array('MyProfile.emp_code', 'MyProfile.emp_id', 'MyProfile.emp_full_name'),
            'order' => array('MyProfile.emp_full_name ASC'),
            'joins' => array(
                array(
                    'table' => 'myprofile',
                    'alias' => 'MyProfile',
                    'type' => 'left',
                    'foreignKey' => false,
                    'conditions' => array('KraTarget.emp_code = MyProfile.emp_code')
                )),
            'group' => array('KraTarget.emp_code')
        ));

        $this->set('empList', $empList);
        $this->set('currentFinancialYear', $currentFinancialYear);

        if (isset($this->request->data['comp_code'])) {
            $queryCon = "";
            if ($this->request->data['emp_id'] != 0) {
                $empCode = $this->request->data['emp_id'];
                $queryCon .= "AppraisalDevelopmentPlan.emp_code = $empCode AND ";
            } else {
                $queryCon .= "";
                $empCode = 0;
            }

            if ($this->request->data['financialYear'] != "" && $this->request->data['comp_code'] != "0") {
                $financialYear = $this->request->data['financialYear'];
                $queryCon .= "AppraisalDevelopmentPlan.financial_year = $financialYear AND ";
            } else {
                $queryCon .= "";
            }

            if ($this->request->data['financialYear'] != "" && $this->request->data['comp_code'] == "0") {
                $financialYear = $this->request->data['financialYear'];
                $queryCon .= "AppraisalDevelopmentPlan.financial_year = $financialYear";
            } else {
                $queryCon .= "";
            }

            if ($this->request->data['comp_code'] != "" && $this->request->data['comp_code'] != "0") {
                $compCode = $this->request->data['comp_code'] . "%";
                $queryCon .= "myprofile.location_code LIKE '$compCode'";
            } else {
                $queryCon .= "";
            }

            if ($this->request->data['comp_code'] == "0") {
                $compCode = $this->request->data['comp_code'];
                $queryCon .= "";
            }
		$queryCon .= " AND myprofile.status=32";
            $conditions = array($queryCon);
            $this->paginate = array(
                'joins' => array(
                    array(
                        'table' => 'myprofile',
                        'alias' => 'myprofile',
                        'type' => 'inner',
                        'foreignKey' => false,
                        'conditions' => array('AppraisalDevelopmentPlan.emp_code = myprofile.emp_code')
                    ),
					array(
                        'table' => 'appraisal_process',
                        'alias' => 'appraisal_process',
                        'type' => 'inner',
                        'foreignKey' => false,
                        'conditions' => array('AppraisalDevelopmentPlan.emp_code = appraisal_process.emp_code')
                    )
                ),
                'fields' => array('AppraisalDevelopmentPlan.*', 'myprofile.location_code'),
                'conditions' => $conditions,
                'group' => array('AppraisalDevelopmentPlan.emp_code'),
			'limit' => 500
            );

            $developmentPlanList = $this->paginate('AppraisalDevelopmentPlan');
            $this->set('developmentPlanList', $developmentPlanList);

            $this->set("empCode", $empCode);
            $this->set("fYear", $financialYear);
            $this->set("companyCode", $this->request->data['comp_code']);
        }
    }

    function developmentPlanReportFile($employeeCode, $fYear, $compCode) {

        //Configure::write('debug',2);
        ob_start();
        $this->autoRender = false;
        $empCode = base64_decode($employeeCode);
        $financialYear = base64_decode($fYear);
        $cCode = base64_decode($compCode);

        if ($cCode != "0") {
            $companyCode = base64_decode($compCode) . "%";
        } else {
            $companyCode = base64_decode($compCode);
        }

        $queryCon = "";
        if ($empCode != 0) {
            $queryCon .= "AppraisalDevelopmentPlan.emp_code = $empCode AND ";
        } else {
            $queryCon .= "";
            $empCode = 0;
        }

        if ($financialYear != "" && $companyCode != "0") {
            $queryCon .= "AppraisalDevelopmentPlan.financial_year = $financialYear AND ";
        } else {
            $queryCon .= "";
        }

        if ($financialYear != "" && $companyCode == "0") {
            $queryCon .= "AppraisalDevelopmentPlan.financial_year = $financialYear";
        } else {
            $queryCon .= "";
        }

        if ($companyCode != "" && $companyCode != "0") {
            $queryCon .= "myprofile.location_code LIKE '$companyCode'";
        } else {
            $queryCon .= "";
        }

        if ($companyCode == "0") {
            $queryCon .= "";
        }
$queryCon .= " AND myprofile.status=32";
        $conditions = array($queryCon);
        $developmentPlanList = $this->AppraisalDevelopmentPlan->find('all', array(
            'joins' => array(
                array(
                    'table' => 'myprofile',
                    'alias' => 'myprofile',
                    'type' => 'inner',
                    'foreignKey' => false,
                    'conditions' => array('AppraisalDevelopmentPlan.emp_code = myprofile.emp_code')
                )
            ),
            'fields' => array('AppraisalDevelopmentPlan.*', 'myprofile.location_code'),
            'conditions' => $conditions,
            'group' => array('AppraisalDevelopmentPlan.emp_code')
        ));

        $header = array('Sr_No', 'Employee_Code', 'Name', 'Location', 'Department', 'Designation', 'Date_of_Joining', 'Appraiser_Name', 'Appraiser_Designation', 'Reviewer_Name', 'Reviewer_Designation', 'Moderator_Name', 'Moderator_Designation', 'Level_0_Status', 'Level_1_Status');


        $ctr = 1;
        foreach ($developmentPlanList as $key => $value) {

            $empStatus = count($this->Common->OpenDevpPlanForAppraiser($developmentPlanList[$key]['AppraisalDevelopmentPlan']['emp_code'], $developmentPlanList[$key]['AppraisalDevelopmentPlan']['financial_year']));
            $appraiserStatus = count($this->Common->openSummaryDiscussion($developmentPlanList[$key]['AppraisalDevelopmentPlan']['emp_code'], $developmentPlanList[$key]['AppraisalDevelopmentPlan']['financial_year']));

            if ($empStatus >= 1) {
                $levelZeroStatus = "Completed";
            } else {
                $levelZeroStatus = "Pending";
            }

            if ($appraiserStatus >= 1) {
                $levelOneStatus = "Completed";
            } else {
                $levelOneStatus = "Pending";
            }

            $location = $this->EmpDetail->getCompanyName($developmentPlanList[$key]['AppraisalDevelopmentPlan']['comp_code']);
            $desgCode = $this->EmpDetail->findDesignationByEmpCode($developmentPlanList[$key]['AppraisalDevelopmentPlan']['emp_code']);
            $desgName = $this->EmpDetail->findDesignationName($desgCode, $developmentPlanList[$key]['AppraisalDevelopmentPlan']['comp_code']);

            $empDetails = $this->EmpDetail->getEmpDetails($developmentPlanList[$key]['AppraisalDevelopmentPlan']['emp_code']);

            $joiningDate = date('d-m-Y', strtotime($empDetails['MyProfile']['join_date']));
            $manager_code = $this->EmpDetail->findEmpName($empDetails['MyProfile']['manager_code']);

            $AppraiserDesgCode = $this->EmpDetail->getempdesgcode($empDetails['MyProfile']['manager_code']);
            $appraiserDesgName = $this->EmpDetail->findDesignationName($AppraiserDesgCode, $empDetails['MyProfile']['comp_code']);

            $reviewerManagerCode = $this->EmpDetail->getManagerCode($empDetails['MyProfile']['manager_code']);
            $reviewerCode = $this->EmpDetail->findEmpName($reviewerManagerCode);

            $reviewerDesgCode = $this->EmpDetail->getempdesgcode($reviewerManagerCode);
            $reviewerDesgName = $this->EmpDetail->findDesignationName($reviewerDesgCode, $empDetails['MyProfile']['comp_code']);



            $moderatorManagerCode = $this->Common->getManagerCode($reviewerManagerCode);
            $moderatorName = $this->EmpDetail->findEmpName($moderatorManagerCode);

            $moderatorDesgCode = $this->EmpDetail->getempdesgcode($moderatorManagerCode);
            $moderatorDesgName = $this->EmpDetail->findDesignationName($moderatorDesgCode, $empDetails['MyProfile']['comp_code']);


            $empCode = $developmentPlanList[$key]['AppraisalDevelopmentPlan']['emp_code'];
            $empName = ucfirst($this->EmpDetail->findEmpName($developmentPlanList[$key]['AppraisalDevelopmentPlan']['emp_code']));

            $empDetails = $this->Common->getEmpDetails($developmentPlanList[$key]['AppraisalDevelopmentPlan']['emp_code']);
            $empID = $empDetails['MyProfile']['emp_id'];
            $listName = $this->Common->findInvestName($developmentPlanList[$key]['myprofile']['location_code']);

            $locationName = $listName['OptionAttribute']['name'];
$deptCode = $this->EmpDetail->findDepartmentByEmpCode($developmentPlanList[$key]['AppraisalDevelopmentPlan']['emp_code']);
$deptName = $this->EmpDetail->findDepartmentNameByCode($deptCode);
            # code...
            $val['Sr_no'] = $ctr;
            $val['Employee_Code'] = $empID;
            $val['Name'] = $empName;
            $val['Location'] = $locationName;
			$val['Department'] = $deptName;
            $val['Designation'] = $desgName;
            $val['Date_of_Joining'] = $joiningDate;
            $val['Appraiser_Name'] = $manager_code;
            $val['Appraiser_Designation'] = $appraiserDesgName;
            $val['Reviewer_Name'] = $reviewerCode;
            $val['Reviewer_Designation'] = $reviewerDesgName;
            $val['Moderator_Name'] = $moderatorName;
            $val['Moderator_Designation'] = $moderatorDesgName;
            $val['Level_0_Status'] = $levelZeroStatus;
            $val['Level_1_Status'] = $levelOneStatus;

            $input_array[$ctr] = $val;

            $ctr++;
        }

        //$this->convert_to_csv_download($input_array, $header, 'Development_Plan_Report.csv', ' ');
		$this->excel($input_array, $header, 'Development_Plan_Report.xls');
    }

    function convert_to_csv_download($input_array, $header, $output_file_name, $delimiter) {
        $f = fopen('php://memory', 'w');
        /** loop through array  */
        fputcsv($f, $header, $delimiter);

        foreach ($input_array as $line) {
            /** default php csv handler * */
            fputcsv($f, $line, $delimiter);
        }
        fseek($f, 0);
        // tell the browser it's going to be a csv file
        header('Content-Type: application/csv');
        // tell the browser we want to save it instead of displaying it
        header('Content-Disposition: attachment; filename="' . $output_file_name . '";');
        // make php send the generated csv lines to the browser
        fpassthru($f);
    }

    public function KraEmpList($locationID) {

        //Configure::write('debug',2);
        $this->layout = FALSE;


        $this->set("locationID", $locationID);
    }

    public function KraEmpListDetails($type,$locationID) {

        //Configure::write('debug',2);
        $this->layout = FALSE;


        $this->set("type", $type);
		$this->set("locationID", $locationID);
    }

    public function KraEmpListDevelopmentPlan($locationID) {

        //Configure::write('debug',2);
        $this->layout = FALSE;


        $this->set("locationID", $locationID);
    }

    public function addMore($param) {
        $this->layout = 'employee-new';
    }

    public function remove_kra_document($kraId) {
        //Configure::write('debug',2);
        echo $success = $this->KraTarget->UpdateAll(array(
    'KraTarget.kra_upload' => "''",
        ), array('KraTarget.id' => $kraId));

        exit();
    }

    public function remove_kra($delArr) {
        //Configure::write('debug',2);
        $arr = explode(',', $delArr);

        for ($i = 0; $i < count($arr); $i++) {
            if ($arr[$i] != '') {
                echo $success = $this->KraTarget->delete($arr[$i]);
            }
        }
        exit();
    }

    public function test_mail() {
		//Configure::write('debug',2);
        $this->autorender = false;
		//echo $this->Auth->password(date('dmY', strtotime(trim(' 1994-08-04 '))));
		//die;
        $To = "anita.yadav@essindia.com";
       $From = "surenderg@stlfasteners.com";
        $sub = "test mail";
        $msg = "This is to inform you that Anita Yadav has submitted, his/ her KRA self score, kindly login to portal and initiate action.";
        $template = 'kra_fill_notification';
        $data['appName'] = "Anita Yadav";
		$data['logo'] ='logo_email.png';
		
        if (isset($To)) {
            $this->send_mail($From, $To, $CC, $sub, $msg, $template, $data);
        }
        die;
    }
	
	function excel($data, $header, $filename) {
       // Configure::write('debug', 2);
       // print_r($data); die;
        App::import('Vendor', 'PHPExcel/Classes/PHPExcel');
        //$folderToSaveXls = 'C:\wamp\www\hrportal_live';
        
        $objReader = PHPExcel_IOFactory::createReader("Excel5");
        $objPHPExcel = new PHPExcel();
		
		$objPHPExcel->getProperties()->setCreator("ESS India")
                ->setLastModifiedBy("ESS India")
                ->setTitle("Online Report")
                ->setSubject("Online Report")
                ->setDescription("ESS India")
                ->setKeywords("ESS India")
                ->setCategory("ESS India");
		
		$no=1;
		$letter = 'A';
				
		foreach($header as $ha){
			//print_r($ha);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($letter++.$no, $ha);
        }
		
		$no=2;
		$letter = 'A';
		
		foreach($data as $da){
			//print_r($da);
			foreach($da as $val){
				//print_r($val);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue($letter++.$no, $val);
			}
			
           
			$no++;
			$letter = 'A';
        }
		
        ob_clean();
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        
        header('Content-Type: application/vnd.ms-excel');
        header("Content-Type:application/force-download");
        header('Content-Disposition: attachment;filename="'.$filename.'"');
        header('Cache-Control: max-age=0');
		
		//$objWriter->save( $folderToSaveXls . '/kra.xls' );
       $objWriter->save('php://output');
		
    }
	
	function usersReportFile() {
        //Configure::write('debug',2);
        $this->autoRender = false;
        
        $kraRecordList = $this->MyProfile->find('all', array(
            'fields' => array('*'),
            //'conditions' => $conditions,
            //'group' => array('KraTarget.emp_code'),
        ));

        $header = array('Sr_No', 'Employee_Code', 'Name', 'Location', 'Designation', 'Appraiser_Name', 'Appraiser_Designation', 'Reviewer_Name', 'Reviewer_Designation', 'Moderator_Name', 'Moderator_Designation');


        $ctr = 1;
        foreach ($kraRecordList as $key => $value) {

           
            $location = $this->EmpDetail->getCompanyName($kraRecordList[$key]['MyProfile']['comp_code']);
            $desgCode = $this->EmpDetail->findDesignationByEmpCode($kraRecordList[$key]['MyProfile']['emp_code']);
            $desgName = $this->EmpDetail->findDesignationName($desgCode, $kraRecordList[$key]['MyProfile']['comp_code']);

            $empDetails = $this->EmpDetail->getEmpDetails($kraRecordList[$key]['MyProfile']['emp_code']);

            $joiningDate = date('d-m-Y', strtotime($empDetails['MyProfile']['join_date']));
            $manager_code = $this->EmpDetail->findEmpName($empDetails['MyProfile']['manager_code']);
			
			$mngDetails = $this->EmpDetail->getEmpDetails($empDetails['MyProfile']['manager_code']);
			$reviewer_code = $this->EmpDetail->findEmpName($mngDetails['MyProfile']['manager_code']);
			$revDetails = $this->EmpDetail->getEmpDetails($mngDetails['MyProfile']['manager_code']);
			$moderator_code = $this->EmpDetail->findEmpName($revDetails['MyProfile']['manager_code']);
			

            $AppraiserDesgCode = $this->EmpDetail->getempdesgcode($empDetails['MyProfile']['manager_code']);
            $appraiserDesgName = $this->EmpDetail->findDesignationName($AppraiserDesgCode, $empDetails['MyProfile']['comp_code']);
			
			$ReviewerDesgCode = $this->EmpDetail->getempdesgcode($mngDetails['MyProfile']['manager_code']);
            $reviewerDesgName = $this->EmpDetail->findDesignationName($ReviewerDesgCode, $mngDetails['MyProfile']['comp_code']);
			$ModeratorDesgCode = $this->EmpDetail->getempdesgcode($revDetails['MyProfile']['manager_code']);
            $moderatorDesgName = $this->EmpDetail->findDesignationName($ModeratorDesgCode, $revDetails['MyProfile']['comp_code']);

            $empCode = $kraRecordList[$key]['MyProfile']['emp_code'];
            $empName = ucfirst($this->EmpDetail->findEmpName($kraRecordList[$key]['MyProfile']['emp_code']));

            $empDetails = $this->Common->getEmpDetails($kraRecordList[$key]['MyProfile']['emp_code']);
            $listName = $this->Common->findInvestName($kraRecordList[$key]['MyProfile']['location_code']);

            $locationName = $listName['OptionAttribute']['name'];


            # code...
            $val['Sr_no'] = $ctr;
            $val['Employee_Code'] = $empDetails['MyProfile']['emp_id'];
            $val['Name'] = $empName;
			$val['Location'] = $location;
            $val['Designation'] = $desgName;
         
            $val['Appraiser_Name'] = $manager_code;
            $val['Appraiser_Designation'] = $appraiserDesgName;
			$val['Reviewer_Name'] = $reviewer_code;
            $val['Reviewer_Designation'] = $reviewerDesgName;
			$val['Moderator_Name'] = $moderator_code;
            $val['Moderator_Designation'] = $ModeratorDesgCode;
			
			 $success = $this->KraTarget->UpdateAll(
								array(
									'KraTarget.appraiser_id' => $empDetails['MyProfile']['manager_code'],
									'KraTarget.reviewer_id' => $mngDetails['MyProfile']['manager_code'],
									'KraTarget.moderator_id' => $revDetails['MyProfile']['manager_code']
									), 
								array(
									'KraTarget.emp_code' => $kraRecordList[$key]['MyProfile']['emp_code']
									)
								); 
			$success = $this->CompetencyTarget->UpdateAll(
								array(
									'CompetencyTarget.appraiser_id' => $empDetails['MyProfile']['manager_code'],
									'CompetencyTarget.reviewer_id' => $mngDetails['MyProfile']['manager_code'],
									'CompetencyTarget.moderator_id' => $revDetails['MyProfile']['manager_code']
									), 
								array(
									'CompetencyTarget.emp_code' => $kraRecordList[$key]['MyProfile']['emp_code']
									)
								);
			$success = $this->MidReviews->UpdateAll(
								array(
									'MidReviews.appraiser_code' => $empDetails['MyProfile']['manager_code'],
									'MidReviews.reviewer_code' => $mngDetails['MyProfile']['manager_code'],
									'MidReviews.moderator_code' => $revDetails['MyProfile']['manager_code']
									), 
								array(
									'MidReviews.emp_code' => $kraRecordList[$key]['MyProfile']['emp_code']
									)
								);
            
          
            $input_array[$ctr] = $val;
//echo '<pre>';print_r($input_array);die;
            $ctr++;
        }
		//echo '<pre>';print_r($input_array);die;

        
		$this->excel($input_array, $header, 'all_users_Report.xls');
    }
	
	function kraReportFile($employeeCode, $fYear, $compCode,$page_type=null,$kra_det_comnts=null,$midkra=null,$annkra=null) {
       Configure::write('debug',2);
		
        $empCode = base64_decode($employeeCode);
        $financialYear = base64_decode($fYear);
        $cCode = base64_decode($compCode);
		$page_type = base64_decode($page_type);

        if ($cCode != "0") {
            $companyCode = base64_decode($compCode) . "%";
        } else {
            $companyCode = base64_decode($compCode);
        }
		
		App::import('Vendor', 'PHPExcel/Classes/PHPExcel');
	  
	     
		$queryCon = "";
        if ($empCode != 0) {
            $queryCon .= "KraTarget.emp_code = $empCode AND ";
        } else {
            $queryCon .= "";
            $empCode = 0;
        }

        if ($financialYear != "" && $companyCode != "0") {
            $queryCon .= "KraTarget.financial_year = $financialYear  ";
        } else {
            $queryCon .= "";
        }

        $conditions = array($queryCon);
				
		if ($empCode != 0) {
			
        $kraRecordList = $this->KraTarget->find('all', array(
		'joins' => array(
							array(
								'table' => 'myprofile',
								'alias' => 'myprofile',
								'type' => 'inner',
								'foreignKey' => false,
								'conditions' => array('KraTarget.emp_code = myprofile.emp_code')
							),
						),
						'fields' => array('KraTarget.*','myprofile.emp_id','myprofile.emp_firstname'),
						'conditions' => $conditions,
            
        ));
		
        $objReader = PHPExcel_IOFactory::createReader("Excel5");
        $objPHPExcel = new PHPExcel();
		
		$objPHPExcel->getProperties()->setCreator("ESS India")
                ->setLastModifiedBy("ESS India")
                ->setTitle("Online Report")
                ->setSubject("Online Report")
                ->setDescription("ESS India")
                ->setKeywords("ESS India")
                ->setCategory("ESS India");
		
	$objPHPExcel->setActiveSheetIndex(0);
			$empDetails = $this->Common->getEmpDetails($empCode);
			
			$xyz = $kraRecordList[0]['myprofile']['emp_id'].'_'.$kraRecordList[0]['myprofile']['emp_firstname'];
			$objPHPExcel->setActiveSheetIndex(0)->setTitle($xyz);
			$objPHPExcel->getActiveSheet()->setCellValue('A1', 'Performance Period');
			$objPHPExcel->getActiveSheet()->mergeCells('A1:B1');
			$objPHPExcel->getActiveSheet()->setCellValue('A2', 'Employee Name');
			$objPHPExcel->getActiveSheet()->mergeCells('A2:B2');
			$objPHPExcel->getActiveSheet()->setCellValue('A3', 'Department');
			$objPHPExcel->getActiveSheet()->mergeCells('A3:B3');
			$objPHPExcel->getActiveSheet()->setCellValue('A4', "Appraiser's Name");
			$objPHPExcel->getActiveSheet()->mergeCells('A4:B4');
			$objPHPExcel->getActiveSheet()->setCellValue('A5', "Reviewer's Name");
			$objPHPExcel->getActiveSheet()->mergeCells('A5:B5');
			$objPHPExcel->getActiveSheet()->setCellValue('A6', "Moderator's Name");
			$objPHPExcel->getActiveSheet()->mergeCells('A6:B6');
			$objPHPExcel->getActiveSheet()->setCellValue('C1', $this->Common->findfyDesc($financialYear));
			$objPHPExcel->getActiveSheet()->mergeCells('C1:D1');
			$objPHPExcel->getActiveSheet()->setCellValue('C2', ucwords(strtolower($empDetails['MyProfile']['emp_full_name'])));
			$objPHPExcel->getActiveSheet()->mergeCells('C2:D2');
			$objPHPExcel->getActiveSheet()->setCellValue('C3', $this->Common->findDepartmentNameByCode($empDetails['MyProfile']['dept_code']));
			$objPHPExcel->getActiveSheet()->mergeCells('C3:D3');
			$objPHPExcel->getActiveSheet()->setCellValue('C4', $this->Common->findEmpName($empDetails['MyProfile']['manager_code']));
			$objPHPExcel->getActiveSheet()->mergeCells('C4:D4');
			
			$reviewerManagerCode = $this->Common->getManagerCode($empDetails['MyProfile']['manager_code']);
			$objPHPExcel->getActiveSheet()->setCellValue('C5', $this->Common->findEmpName($reviewerManagerCode));
			$objPHPExcel->getActiveSheet()->mergeCells('C5:D5');
			
			$moderatorCode = $this->Common->getManagerCode($reviewerManagerCode);
			$objPHPExcel->getActiveSheet()->setCellValue('C6', $this->Common->findEmpName($moderatorCode));
			$objPHPExcel->getActiveSheet()->mergeCells('C6:D6');
			
			
			$objPHPExcel->getActiveSheet()->setCellValue('G2', 'Emp Code / Designation');
			$objPHPExcel->getActiveSheet()->mergeCells('G2:H2');
			$objPHPExcel->getActiveSheet()->setCellValue('G3', "Date of Joining");
			$objPHPExcel->getActiveSheet()->mergeCells('G3:H3');
			$objPHPExcel->getActiveSheet()->setCellValue('G4', "Appraiser's Designation");
			$objPHPExcel->getActiveSheet()->mergeCells('G4:H4');
			$objPHPExcel->getActiveSheet()->setCellValue('G5', "Reviewer's Designation");
			$objPHPExcel->getActiveSheet()->mergeCells('G5:H5');
			$objPHPExcel->getActiveSheet()->setCellValue('G6', "Moderator's Designation");
			$objPHPExcel->getActiveSheet()->mergeCells('G6:H6');
			$objPHPExcel->getActiveSheet()->setCellValue('I2', $empDetails['MyProfile']['emp_id'].' / '.$this->Common->findDesignationName($empDetails['MyProfile']['desg_code'],$empDetails['MyProfile']['comp_code']));
			$objPHPExcel->getActiveSheet()->mergeCells('I2:J2');
			$objPHPExcel->getActiveSheet()->setCellValue('I3', date('d-m-Y', strtotime($empDetails['MyProfile']['join_date'])));
			$objPHPExcel->getActiveSheet()->mergeCells('I3:J3');
			
			$AppraiserDesgCode =  $this->Common->getempdesgcode($empDetails['MyProfile']['manager_code']);
			$objPHPExcel->getActiveSheet()->setCellValue('I4', $this->Common->findDesignationName($AppraiserDesgCode,$empDetails['MyProfile']['comp_code']));
			$objPHPExcel->getActiveSheet()->mergeCells('I4:J4');
			
			$reviewerDesgCode = $this->Common->getempdesgcode($reviewerManagerCode);
			$objPHPExcel->getActiveSheet()->setCellValue('I5', $this->Common->findDesignationName($reviewerDesgCode,$empDetails['MyProfile']['comp_code']));
			$objPHPExcel->getActiveSheet()->mergeCells('I5:J5');
			
			$moderatorDesgCode = $this->Common->getempdesgcode($moderatorCode);
			$objPHPExcel->getActiveSheet()->setCellValue('I6', $this->Common->findDesignationName($moderatorDesgCode,$empDetails['MyProfile']['comp_code']));
			$objPHPExcel->getActiveSheet()->mergeCells('I6:J6');
			
			$objPHPExcel->getActiveSheet()->setCellValue('A8', 'Sl. No.');
			$objPHPExcel->getActiveSheet()->mergeCells('A8:A9');
			$objPHPExcel->getActiveSheet()->setCellValue('B8','KRA');
			$objPHPExcel->getActiveSheet()->mergeCells('B8:B9');
			$objPHPExcel->getActiveSheet()->setCellValue('C8','Weightage (%)');
			$objPHPExcel->getActiveSheet()->mergeCells('C8:C9');
			$objPHPExcel->getActiveSheet()->setCellValue('D8','Measure (KPI)');
			$objPHPExcel->getActiveSheet()->mergeCells('D8:D9');
			$objPHPExcel->getActiveSheet()->setCellValue('E8','Measure Type');
			$objPHPExcel->getActiveSheet()->mergeCells('E8:E9');
			$objPHPExcel->getActiveSheet()->setCellValue('F8','View Document');
			$objPHPExcel->getActiveSheet()->mergeCells('F8:F9'); 
			$objPHPExcel->getActiveSheet()->setCellValue('G8','Annual');
			$objPHPExcel->getActiveSheet()->mergeCells('G8:I8'); 
			$objPHPExcel->getActiveSheet()->setCellValue('J8','Mid Year');
			$objPHPExcel->getActiveSheet()->setCellValue('G9','Baseline');
			$objPHPExcel->getActiveSheet()->setCellValue('H9','Target');
			$objPHPExcel->getActiveSheet()->setCellValue('I9','Stretched');
			$objPHPExcel->getActiveSheet()->setCellValue('J9','Target');
		
		if($page_type=='mid'){
			$objPHPExcel->getActiveSheet()->setCellValue('K8','Mid Year Self Score');
			$objPHPExcel->getActiveSheet()->mergeCells('K8:M8'); 
			$objPHPExcel->getActiveSheet()->setCellValue('K9','Actual');
			$objPHPExcel->getActiveSheet()->setCellValue('L9','Comments');
			$objPHPExcel->getActiveSheet()->setCellValue('M9','View Document');
			$objPHPExcel->getActiveSheet()->setCellValue('N8','Mid Year Appraiser Score');
			$objPHPExcel->getActiveSheet()->mergeCells('N8:O8'); 
			$objPHPExcel->getActiveSheet()->setCellValue('N9','Comments');
			$objPHPExcel->getActiveSheet()->setCellValue('O9','View Document');
			if($kraRecordList[0]['KraTarget']['reviewer_id']!=0 && $kraRecordList[0]['KraTarget']['moderator_id']!=0){
				$objPHPExcel->getActiveSheet()->setCellValue('P8','Mid Year Reviewer Score');
				$objPHPExcel->getActiveSheet()->mergeCells('P8:Q8'); 
				$objPHPExcel->getActiveSheet()->setCellValue('P9','Comments');
				$objPHPExcel->getActiveSheet()->setCellValue('Q9','View Document');
				$objPHPExcel->getActiveSheet()->setCellValue('R8','Mid Year Moderator Score');
				$objPHPExcel->getActiveSheet()->mergeCells('R8:S8'); 
				$objPHPExcel->getActiveSheet()->setCellValue('R9','Comments');
				$objPHPExcel->getActiveSheet()->setCellValue('S9','View Document');
			}elseif($kraRecordList[0]['KraTarget']['reviewer_id']!=0 && $kraRecordList[0]['KraTarget']['moderator_id']==0){
				$objPHPExcel->getActiveSheet()->setCellValue('P8','Mid Year Reviewer Score');
				$objPHPExcel->getActiveSheet()->mergeCells('P8:Q8'); 
				$objPHPExcel->getActiveSheet()->setCellValue('P9','Comments');
				$objPHPExcel->getActiveSheet()->setCellValue('Q9','View Document');
			}
			
		}
		if($page_type=='ann'){
			$objPHPExcel->getActiveSheet()->setCellValue('K8','Mid Year Self Score');
			$objPHPExcel->getActiveSheet()->mergeCells('K8:M8'); 
			$objPHPExcel->getActiveSheet()->setCellValue('K9','Actual');
			$objPHPExcel->getActiveSheet()->setCellValue('L9','Comments');
			$objPHPExcel->getActiveSheet()->setCellValue('M9','View Document');
			$objPHPExcel->getActiveSheet()->setCellValue('N8','Mid Year Appraiser Score');
			$objPHPExcel->getActiveSheet()->mergeCells('N8:O8'); 
			$objPHPExcel->getActiveSheet()->setCellValue('N9','Comments');
			$objPHPExcel->getActiveSheet()->setCellValue('O9','View Document');
			if($kraRecordList[0]['KraTarget']['reviewer_id']!=0 && $kraRecordList[0]['KraTarget']['moderator_id']!=0){
				$objPHPExcel->getActiveSheet()->setCellValue('P8','Mid Year Reviewer Score');
				$objPHPExcel->getActiveSheet()->mergeCells('P8:Q8'); 
				$objPHPExcel->getActiveSheet()->setCellValue('P9','Comments');
				$objPHPExcel->getActiveSheet()->setCellValue('Q9','View Document');
				$objPHPExcel->getActiveSheet()->setCellValue('R8','Mid Year Moderator Score');
				$objPHPExcel->getActiveSheet()->mergeCells('R8:S8'); 
				$objPHPExcel->getActiveSheet()->setCellValue('R9','Comments');
				$objPHPExcel->getActiveSheet()->setCellValue('S9','View Document');
			}elseif($kraRecordList[0]['KraTarget']['reviewer_id']!=0 && $kraRecordList[0]['KraTarget']['moderator_id']==0){
				$objPHPExcel->getActiveSheet()->setCellValue('P8','Mid Year Reviewer Score');
				$objPHPExcel->getActiveSheet()->mergeCells('P8:Q8'); 
				$objPHPExcel->getActiveSheet()->setCellValue('P9','Comments');
				$objPHPExcel->getActiveSheet()->setCellValue('Q9','View Document');
			}
			
			$objPHPExcel->getActiveSheet()->setCellValue('K8','Mid Year Self Score');
			$objPHPExcel->getActiveSheet()->mergeCells('K8:M8'); 
			$objPHPExcel->getActiveSheet()->setCellValue('K9','Actual');
			$objPHPExcel->getActiveSheet()->setCellValue('L9','Comments');
			$objPHPExcel->getActiveSheet()->setCellValue('M9','View Document');
			$objPHPExcel->getActiveSheet()->setCellValue('N8','Mid Year Appraiser Score');
			$objPHPExcel->getActiveSheet()->mergeCells('N8:O8'); 
			$objPHPExcel->getActiveSheet()->setCellValue('N9','Comments');
			$objPHPExcel->getActiveSheet()->setCellValue('O9','View Document');
			if($kraRecordList[0]['KraTarget']['reviewer_id']!=0 && $kraRecordList[0]['KraTarget']['moderator_id']!=0){
				$objPHPExcel->getActiveSheet()->setCellValue('P8','Mid Year Reviewer Score');
				$objPHPExcel->getActiveSheet()->mergeCells('P8:Q8'); 
				$objPHPExcel->getActiveSheet()->setCellValue('P9','Comments');
				$objPHPExcel->getActiveSheet()->setCellValue('Q9','View Document');
				$objPHPExcel->getActiveSheet()->setCellValue('R8','Mid Year Moderator Score');
				$objPHPExcel->getActiveSheet()->mergeCells('R8:S8'); 
				$objPHPExcel->getActiveSheet()->setCellValue('R9','Comments');
				$objPHPExcel->getActiveSheet()->setCellValue('S9','View Document');
			}elseif($kraRecordList[0]['KraTarget']['reviewer_id']!=0 && $kraRecordList[0]['KraTarget']['moderator_id']==0){
				$objPHPExcel->getActiveSheet()->setCellValue('P8','Mid Year Reviewer Score');
				$objPHPExcel->getActiveSheet()->mergeCells('P8:Q8'); 
				$objPHPExcel->getActiveSheet()->setCellValue('P9','Comments');
				$objPHPExcel->getActiveSheet()->setCellValue('Q9','View Document');
			}
			
		}
	
	$objPHPExcel->getActiveSheet()->getStyle("A1")->getFont()->setBold(true);
	$objPHPExcel->getActiveSheet()->getStyle("A2")->getFont()->setBold(true);
	$objPHPExcel->getActiveSheet()->getStyle("A3")->getFont()->setBold(true);
	$objPHPExcel->getActiveSheet()->getStyle("A4")->getFont()->setBold(true);
	$objPHPExcel->getActiveSheet()->getStyle("A5")->getFont()->setBold(true);
	$objPHPExcel->getActiveSheet()->getStyle("A6")->getFont()->setBold(true);
	$objPHPExcel->getActiveSheet()->getStyle("G2")->getFont()->setBold(true);
	$objPHPExcel->getActiveSheet()->getStyle("G3")->getFont()->setBold(true);
	$objPHPExcel->getActiveSheet()->getStyle("G4")->getFont()->setBold(true);
	$objPHPExcel->getActiveSheet()->getStyle("G5")->getFont()->setBold(true);
	$objPHPExcel->getActiveSheet()->getStyle("G6")->getFont()->setBold(true);

	$objPHPExcel->getActiveSheet()->getStyle('A1:S1')->applyFromArray(
									array(
											'fill' => array(
												'type' => PHPExcel_Style_Fill::FILL_SOLID,
												'color' => array('rgb' => 'bbdefb')
											),
											'borders' => array(
												'allborders' => array(
													'style' => PHPExcel_Style_Border::BORDER_THIN,
													'color' => array('rgb' => '000000')
												)
											)
										)
									);
	$objPHPExcel->getActiveSheet()->getStyle('A2:S2')->applyFromArray(
									array(
											'fill' => array(
												'type' => PHPExcel_Style_Fill::FILL_SOLID,
												'color' => array('rgb' => 'bbdefb')
											),
											'borders' => array(
												'allborders' => array(
													'style' => PHPExcel_Style_Border::BORDER_THIN,
													'color' => array('rgb' => '000000')
												)
											)
										)
									);
	$objPHPExcel->getActiveSheet()->getStyle('A3:S3')->applyFromArray(
									array(
											'fill' => array(
												'type' => PHPExcel_Style_Fill::FILL_SOLID,
												'color' => array('rgb' => 'bbdefb')
											),
											'borders' => array(
												'allborders' => array(
													'style' => PHPExcel_Style_Border::BORDER_THIN,
													'color' => array('rgb' => '000000')
												)
											)
										)
									);
	$objPHPExcel->getActiveSheet()->getStyle('A4:S4')->applyFromArray(
									array(
											'fill' => array(
												'type' => PHPExcel_Style_Fill::FILL_SOLID,
												'color' => array('rgb' => 'bbdefb')
											),
											'borders' => array(
												'allborders' => array(
													'style' => PHPExcel_Style_Border::BORDER_THIN,
													'color' => array('rgb' => '000000')
												)
											)
										)
									);
	$objPHPExcel->getActiveSheet()->getStyle('A5:S5')->applyFromArray(
									array(
											'fill' => array(
												'type' => PHPExcel_Style_Fill::FILL_SOLID,
												'color' => array('rgb' => 'bbdefb')
											),
											'borders' => array(
												'allborders' => array(
													'style' => PHPExcel_Style_Border::BORDER_THIN,
													'color' => array('rgb' => '000000')
												)
											)
										)
									);
	$objPHPExcel->getActiveSheet()->getStyle('A6:S6')->applyFromArray(
									array(
											'fill' => array(
												'type' => PHPExcel_Style_Fill::FILL_SOLID,
												'color' => array('rgb' => 'bbdefb')
											),
											'borders' => array(
												'allborders' => array(
													'style' => PHPExcel_Style_Border::BORDER_THIN,
													'color' => array('rgb' => '000000')
												)
											)
										)
									);
	
	$objPHPExcel->getActiveSheet()->getStyle('A8:S8')->applyFromArray(
									array(
											'fill' => array(
												'type' => PHPExcel_Style_Fill::FILL_SOLID,
												'color' => array('rgb' => 'bbdefb')
											),
											'borders' => array(
												'allborders' => array(
													'style' => PHPExcel_Style_Border::BORDER_THIN,
													'color' => array('rgb' => '000000')
												)
											),
											'font' => array(
												'bold' => true,
											)
										)
									);
	$objPHPExcel->getActiveSheet()->getStyle('A9:S9')->applyFromArray(
									array(
											'fill' => array(
												'type' => PHPExcel_Style_Fill::FILL_SOLID,
												'color' => array('rgb' => 'bbdefb')
											),
											'borders' => array(
												'allborders' => array(
													'style' => PHPExcel_Style_Border::BORDER_THIN,
													'color' => array('rgb' => '000000')
												)
											),
											'font' => array(
												'bold' => true,
											)
										)
									);
	$objPHPExcel->getActiveSheet()->getStyle('A8:S8')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objPHPExcel->getActiveSheet()->getStyle('A9:S9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	
	
		$i=1;
		$j=10;
		//print_r($kraRecordList);die;
		foreach ($kraRecordList as $key => $value) {
			$objPHPExcel->getActiveSheet()->setCellValue('A'.$j,$i);
			$objPHPExcel->getActiveSheet()->setCellValue('B'.$j,$kraRecordList[$key]['KraTarget']['kra_name']);
			$objPHPExcel->getActiveSheet()->setCellValue('C'.$j,$kraRecordList[$key]['KraTarget']['weightage']);
			$objPHPExcel->getActiveSheet()->setCellValue('D'.$j,$kraRecordList[$key]['KraTarget']['measure']);
			if($kraRecordList[$key]['KraTarget']['measure_type']==1){
			$measure_type = 'Higher the Better';
			}elseif($kraRecordList[$key]['KraTarget']['measure_type']==2){
			$measure_type = 'Lower the Better';
			}elseif($kraRecordList[$key]['KraTarget']['measure_type']==3){
			$measure_type = 'Boolean';
			}
			$objPHPExcel->getActiveSheet()->setCellValue('E'.$j,$measure_type);
			if($kraRecordList[$key]['KraTarget']['kra_upload']==''){
			$kra_upload = 'N/A';
			}else{
			$kra_upload = $kraRecordList[$key]['KraTarget']['kra_upload'];
			}
			if($kraRecordList[$key]['KraTarget']['mid_self_score_actual']==''){
			$kraRecordList[$key]['KraTarget']['mid_self_score_actual'] = 'N/A';
			}else{
			$kraRecordList[$key]['KraTarget']['mid_self_score_actual'] = $kraRecordList[$key]['KraTarget']['mid_self_score_actual'];
				if($kraRecordList[$key]['KraTarget']['measure_type']==3){
					if($kraRecordList[$key]['KraTarget']['mid_self_score_actual']==1){
						$kraRecordList[$key]['KraTarget']['mid_self_score_actual'] = 'Overachieved';
					}elseif($kraRecordList[$key]['KraTarget']['mid_self_score_actual']==2){
						$kraRecordList[$key]['KraTarget']['mid_self_score_actual'] = 'Achieved';
					}elseif($kraRecordList[$key]['KraTarget']['mid_self_score_actual']==3){
						$kraRecordList[$key]['KraTarget']['mid_self_score_actual'] = 'Underachieved';
					}
				}
			}
			if($kraRecordList[$key]['KraTarget']['mid_self_upload']==''){
			$mid_self_upload = 'N/A';
			}else{
			$mid_self_upload = $kraRecordList[$key]['KraTarget']['mid_self_upload'];
			}
			if($kraRecordList[$key]['KraTarget']['mid_self_score_comment']==''){
			$mid_self_score_comment = 'N/A';
			}else{
			$mid_self_score_comment = $kraRecordList[$key]['KraTarget']['mid_self_score_comment'];
			}
			if($kraRecordList[$key]['KraTarget']['mid_self_actual_upload']==''){
			$mid_self_actual_upload = 'N/A';
			}else{
			$mid_self_actual_upload = $kraRecordList[$key]['KraTarget']['mid_self_actual_upload'];
			}
			if($kraRecordList[$key]['KraTarget']['mid_app_actual_upload']==''){
			$mid_app_actual_upload = 'N/A';
			}else{
			$mid_app_actual_upload = $kraRecordList[$key]['KraTarget']['mid_app_actual_upload'];
			}
			if($kraRecordList[$key]['KraTarget']['mid_rev_actual_upload']==''){
			$mid_rev_actual_upload = 'N/A';
			}else{
			$mid_rev_actual_upload = $kraRecordList[$key]['KraTarget']['mid_rev_actual_upload'];
			}
			if($kraRecordList[$key]['KraTarget']['mid_mod_actual_upload']==''){
			$mid_mod_actual_upload = 'N/A';
			}else{
			$mid_mod_actual_upload = $kraRecordList[$key]['KraTarget']['mid_mod_actual_upload'];
			}
			$objPHPExcel->getActiveSheet()->setCellValue('F'.$j,$kra_upload);
			$objPHPExcel->getActiveSheet()->setCellValue('G'.$j,$kraRecordList[$key]['KraTarget']['qualifying']);
			$objPHPExcel->getActiveSheet()->setCellValue('H'.$j,$kraRecordList[$key]['KraTarget']['target']);
			$objPHPExcel->getActiveSheet()->setCellValue('I'.$j,$kraRecordList[$key]['KraTarget']['stretched']);
			$objPHPExcel->getActiveSheet()->setCellValue('J'.$j,$kraRecordList[$key]['KraTarget']['mid_self_target']);
			if($page_type=='mid'){
				$objPHPExcel->getActiveSheet()->setCellValue('K'.$j,$kraRecordList[$key]['KraTarget']['mid_self_score_actual']);
				$objPHPExcel->getActiveSheet()->setCellValue('L'.$j,$mid_self_score_comment);
				$objPHPExcel->getActiveSheet()->setCellValue('M'.$j,$mid_self_actual_upload);
				$objPHPExcel->getActiveSheet()->setCellValue('N'.$j,$kraRecordList[$key]['KraTarget']['mid_appraiser_score_comment']);
				$objPHPExcel->getActiveSheet()->setCellValue('O'.$j,$mid_app_actual_upload);
				if($kraRecordList[0]['KraTarget']['reviewer_id']!=0 && $kraRecordList[0]['KraTarget']['moderator_id']!=0){
					$objPHPExcel->getActiveSheet()->setCellValue('P'.$j,$kraRecordList[$key]['KraTarget']['mid_reviewer_score_comment']);
					$objPHPExcel->getActiveSheet()->setCellValue('Q'.$j,$mid_rev_actual_upload);
					$objPHPExcel->getActiveSheet()->setCellValue('R'.$j,$kraRecordList[$key]['KraTarget']['mid_moderator_score_comment']);
					$objPHPExcel->getActiveSheet()->setCellValue('S'.$j,$mid_mod_actual_upload);
				}elseif($kraRecordList[0]['KraTarget']['reviewer_id']!=0 && $kraRecordList[0]['KraTarget']['moderator_id']==0){
					$objPHPExcel->getActiveSheet()->setCellValue('P'.$j,$kraRecordList[$key]['KraTarget']['mid_reviewer_score_comment']);
					$objPHPExcel->getActiveSheet()->setCellValue('Q'.$j,$mid_rev_actual_upload);
					
				}
			}
			if($page_type=='ann'){
				$objPHPExcel->getActiveSheet()->setCellValue('K'.$j,$kraRecordList[$key]['KraTarget']['mid_self_score_actual']);
				$objPHPExcel->getActiveSheet()->setCellValue('L'.$j,$mid_self_score_comment);
				$objPHPExcel->getActiveSheet()->setCellValue('M'.$j,$mid_self_actual_upload);
				$objPHPExcel->getActiveSheet()->setCellValue('N'.$j,$kraRecordList[$key]['KraTarget']['mid_appraiser_score_comment']);
				$objPHPExcel->getActiveSheet()->setCellValue('O'.$j,$mid_app_actual_upload);
				if($kraRecordList[0]['KraTarget']['reviewer_id']!=0 && $kraRecordList[0]['KraTarget']['moderator_id']!=0){
					$objPHPExcel->getActiveSheet()->setCellValue('P'.$j,$kraRecordList[$key]['KraTarget']['mid_reviewer_score_comment']);
					$objPHPExcel->getActiveSheet()->setCellValue('Q'.$j,$mid_rev_actual_upload);
					$objPHPExcel->getActiveSheet()->setCellValue('R'.$j,$kraRecordList[$key]['KraTarget']['mid_moderator_score_comment']);
					$objPHPExcel->getActiveSheet()->setCellValue('S'.$j,$mid_mod_actual_upload);
				}elseif($kraRecordList[0]['KraTarget']['reviewer_id']!=0 && $kraRecordList[0]['KraTarget']['moderator_id']==0){
					$objPHPExcel->getActiveSheet()->setCellValue('P'.$j,$kraRecordList[$key]['KraTarget']['mid_reviewer_score_comment']);
					$objPHPExcel->getActiveSheet()->setCellValue('Q'.$j,$mid_rev_actual_upload);
					
				}
				
				$objPHPExcel->getActiveSheet()->setCellValue('K'.$j,$kraRecordList[$key]['KraTarget']['mid_self_acheivement']);
				$objPHPExcel->getActiveSheet()->setCellValue('L'.$j,$mid_self_comment);
				$objPHPExcel->getActiveSheet()->setCellValue('M'.$j,$mid_self_upload);
				$objPHPExcel->getActiveSheet()->setCellValue('N'.$j,$kraRecordList[$key]['KraTarget']['mid_appraiser_score_comment']);
				$objPHPExcel->getActiveSheet()->setCellValue('O'.$j,$mid_app_actual_upload);
				if($kraRecordList[0]['KraTarget']['reviewer_id']!=0 && $kraRecordList[0]['KraTarget']['moderator_id']!=0){
					$objPHPExcel->getActiveSheet()->setCellValue('P'.$j,$kraRecordList[$key]['KraTarget']['mid_reviewer_score_comment']);
					$objPHPExcel->getActiveSheet()->setCellValue('Q'.$j,$mid_rev_actual_upload);
					$objPHPExcel->getActiveSheet()->setCellValue('R'.$j,$kraRecordList[$key]['KraTarget']['mid_moderator_score_comment']);
					$objPHPExcel->getActiveSheet()->setCellValue('S'.$j,$mid_mod_actual_upload);
				}elseif($kraRecordList[0]['KraTarget']['reviewer_id']!=0 && $kraRecordList[0]['KraTarget']['moderator_id']==0){
					$objPHPExcel->getActiveSheet()->setCellValue('P'.$j,$kraRecordList[$key]['KraTarget']['mid_reviewer_score_comment']);
					$objPHPExcel->getActiveSheet()->setCellValue('Q'.$j,$mid_rev_actual_upload);
					
				}
				
			}
			$i++;
			$j++;
		}
		ob_clean();
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        
        header('Content-Type: application/vnd.ms-excel');
        header("Content-Type:application/force-download");
       // header('Content-Disposition: attachment;filename="KRA_detail.xls"');
	   if($page_type=='mid'){
			 header('Content-Disposition: attachment;filename="KRA_MidReview.xls"');
		}elseif($page_type=='ann'){
			 header('Content-Disposition: attachment;filename="KRA_Annual.xls"');
		}else{
			 header('Content-Disposition: attachment;filename="KRA_detail.xls"');
		}
        header('Cache-Control: max-age=0');
		
		ob_end_clean();
		//$objWriter->save( $folderToSaveXls . '/kra.xls' );
       $objWriter->save('php://output');
		
		$this->excel($input_array, $header, 'KRA_Approval_Report.xls');
        
		}else{
		
		if($cCode==0){
			$cCode='';
		}
			//Configure::write('debug',2);
		if($page_type=='mid'){
        $kraRecordListAll = $this->KraTarget->find('all', array(
            'fields' => array('*'),
			'joins' => array(
                    array(
                        'table' => 'myprofile',
                        'alias' => 'myprofile',
                        'type' => 'inner',
                        'foreignKey' => false,
                        'conditions' => array('KraTarget.emp_code = myprofile.emp_code')
                    ),
				array(
                        'table' => 'mid_reviews',
                        'alias' => 'mr',
                        'type' => 'LEFT',
                        'foreignKey' => false,
                        'conditions' => array('KraTarget.emp_code = mr.emp_code')
                    )
                ),
				'conditions' => array("myprofile.location_code LIKE" => $cCode. "%","myprofile.status " => 32),
                'group' => array('KraTarget.emp_code'),
        ));
		}elseif($page_type=='ann'){
			
		}
		else{
			
		$kraRecordListAll = $this->KraTarget->find('all', array(
            'fields' => array('*'),
			'joins' => array(
                    array(
                        'table' => 'myprofile',
                        'alias' => 'myprofile',
                        'type' => 'inner',
                        'foreignKey' => false,
                        'conditions' => array('KraTarget.emp_code = myprofile.emp_code')
                    ),
					
                ),
				'conditions' => array("myprofile.location_code LIKE" => $cCode. "%","myprofile.status " => 32),
                'group' => array('KraTarget.emp_code'),
					 ));
		}
			$objReader = PHPExcel_IOFactory::createReader("Excel5");
			$objPHPExcel = new PHPExcel();

			$objPHPExcel->getProperties()->setCreator("ESS India")
					->setLastModifiedBy("ESS India")
					->setTitle("Online Report")
					->setSubject("Online Report")
					->setDescription("ESS India")
					->setKeywords("ESS India")
					->setCategory("ESS India");		
			$abc=0;
				//Configure::write('debug',2);
			foreach($kraRecordListAll as $keyAll){
				
				 $kraRecordList = $this->KraTarget->find('all', array(
						'joins' => array(
							array(
								'table' => 'myprofile',
								'alias' => 'myprofile',
								'type' => 'inner',
								'foreignKey' => false,
								'conditions' => array('KraTarget.emp_code = myprofile.emp_code')
							),
						),
						'fields' => array('KraTarget.*','myprofile.emp_id','myprofile.emp_firstname'),
						'conditions' => array("KraTarget.emp_code" => $keyAll['KraTarget']['emp_code'])
						
					));
			
			$objWorkSheet = $objPHPExcel->createSheet();//echo'<pre>';print_r($keyAll['myprofile']['emp_full_name']);
			$xyz = $keyAll['myprofile']['emp_id'].'_'.$keyAll['myprofile']['emp_firstname'];
			$objPHPExcel->setActiveSheetIndex($abc)->setTitle($xyz);
			
			$empDetails = $this->Common->getEmpDetails($kraRecordList[0]['KraTarget']['emp_code']);
		
			$abc++;
			//$objPHPExcel->setActiveSheetIndex(0)->setTitle($xyz);
			$objPHPExcel->getActiveSheet()->setCellValue('A1', 'Performance Period');
			$objPHPExcel->getActiveSheet()->mergeCells('A1:B1');
			$objPHPExcel->getActiveSheet()->setCellValue('A2', 'Employee Name');
			$objPHPExcel->getActiveSheet()->mergeCells('A2:B2');
			$objPHPExcel->getActiveSheet()->setCellValue('A3', 'Department');
			$objPHPExcel->getActiveSheet()->mergeCells('A3:B3');
			$objPHPExcel->getActiveSheet()->setCellValue('A4', "Appraiser's Name");
			$objPHPExcel->getActiveSheet()->mergeCells('A4:B4');
			$objPHPExcel->getActiveSheet()->setCellValue('A5', "Reviewer's Name");
			$objPHPExcel->getActiveSheet()->mergeCells('A5:B5');
			$objPHPExcel->getActiveSheet()->setCellValue('A6', "Moderator's Name");
			$objPHPExcel->getActiveSheet()->mergeCells('A6:B6');
			$objPHPExcel->getActiveSheet()->setCellValue('C1', $this->Common->findfyDesc($financialYear));
			$objPHPExcel->getActiveSheet()->mergeCells('C1:D1');
			$objPHPExcel->getActiveSheet()->setCellValue('C2', ucwords(strtolower($empDetails['MyProfile']['emp_full_name'])));
			$objPHPExcel->getActiveSheet()->mergeCells('C2:D2');
			$objPHPExcel->getActiveSheet()->setCellValue('C3', $this->Common->findDepartmentNameByCode($empDetails['MyProfile']['dept_code']));
			$objPHPExcel->getActiveSheet()->mergeCells('C3:D3');
			$objPHPExcel->getActiveSheet()->setCellValue('C4', $this->Common->findEmpName($empDetails['MyProfile']['manager_code']));
			$objPHPExcel->getActiveSheet()->mergeCells('C4:D4');
			
			$reviewerManagerCode = $this->Common->getManagerCode($empDetails['MyProfile']['manager_code']);
			$objPHPExcel->getActiveSheet()->setCellValue('C5', $this->Common->findEmpName($reviewerManagerCode));
			$objPHPExcel->getActiveSheet()->mergeCells('C5:D5');
			
			$moderatorCode = $this->Common->getManagerCode($reviewerManagerCode);
			$objPHPExcel->getActiveSheet()->setCellValue('C6', $this->Common->findEmpName($moderatorCode));
			$objPHPExcel->getActiveSheet()->mergeCells('C6:D6');
			
			
			$objPHPExcel->getActiveSheet()->setCellValue('G2', 'Emp Code / Designation');
			$objPHPExcel->getActiveSheet()->mergeCells('G2:H2');
			$objPHPExcel->getActiveSheet()->setCellValue('G3', "Date of Joining");
			$objPHPExcel->getActiveSheet()->mergeCells('G3:H3');
			$objPHPExcel->getActiveSheet()->setCellValue('G4', "Appraiser's Designation");
			$objPHPExcel->getActiveSheet()->mergeCells('G4:H4');
			$objPHPExcel->getActiveSheet()->setCellValue('G5', "Reviewer's Designation");
			$objPHPExcel->getActiveSheet()->mergeCells('G5:H5');
			$objPHPExcel->getActiveSheet()->setCellValue('G6', "Moderator's Designation");
			$objPHPExcel->getActiveSheet()->mergeCells('G6:H6');
			$objPHPExcel->getActiveSheet()->setCellValue('I2', $empDetails['MyProfile']['emp_id'].' / '.$this->Common->findDesignationName($empDetails['MyProfile']['desg_code'],$empDetails['MyProfile']['comp_code']));
			$objPHPExcel->getActiveSheet()->mergeCells('I2:J2');
			$objPHPExcel->getActiveSheet()->setCellValue('I3', date('d-m-Y', strtotime($empDetails['MyProfile']['join_date'])));
			$objPHPExcel->getActiveSheet()->mergeCells('I3:J3');
			
			$AppraiserDesgCode =  $this->Common->getempdesgcode($empDetails['MyProfile']['manager_code']);
			$objPHPExcel->getActiveSheet()->setCellValue('I4', $this->Common->findDesignationName($AppraiserDesgCode,$empDetails['MyProfile']['comp_code']));
			$objPHPExcel->getActiveSheet()->mergeCells('I4:J4');
			
			$reviewerDesgCode = $this->Common->getempdesgcode($reviewerManagerCode);
			$objPHPExcel->getActiveSheet()->setCellValue('I5', $this->Common->findDesignationName($reviewerDesgCode,$empDetails['MyProfile']['comp_code']));
			$objPHPExcel->getActiveSheet()->mergeCells('I5:J5');
			
			$moderatorDesgCode = $this->Common->getempdesgcode($moderatorCode);
			$objPHPExcel->getActiveSheet()->setCellValue('I6', $this->Common->findDesignationName($moderatorDesgCode,$empDetails['MyProfile']['comp_code']));
			$objPHPExcel->getActiveSheet()->mergeCells('I6:J6');
			
			$objPHPExcel->getActiveSheet()->setCellValue('A8', 'Sl. No.');
			$objPHPExcel->getActiveSheet()->mergeCells('A8:A9');
			$objPHPExcel->getActiveSheet()->setCellValue('B8','KRA');
			$objPHPExcel->getActiveSheet()->mergeCells('B8:B9');
			$objPHPExcel->getActiveSheet()->setCellValue('C8','Weightage (%)');
			$objPHPExcel->getActiveSheet()->mergeCells('C8:C9');
			$objPHPExcel->getActiveSheet()->setCellValue('D8','Measure (KPI)');
			$objPHPExcel->getActiveSheet()->mergeCells('D8:D9');
			$objPHPExcel->getActiveSheet()->setCellValue('E8','Measure Type');
			$objPHPExcel->getActiveSheet()->mergeCells('E8:E9');
			$objPHPExcel->getActiveSheet()->setCellValue('F8','View Document');
			$objPHPExcel->getActiveSheet()->mergeCells('F8:F9'); 
			$objPHPExcel->getActiveSheet()->setCellValue('G8','Annual');
			$objPHPExcel->getActiveSheet()->mergeCells('G8:I8'); 
			$objPHPExcel->getActiveSheet()->setCellValue('J8','Mid Year');
			$objPHPExcel->getActiveSheet()->setCellValue('G9','Baseline');
			$objPHPExcel->getActiveSheet()->setCellValue('H9','Target');
			$objPHPExcel->getActiveSheet()->setCellValue('I9','Stretched');
			$objPHPExcel->getActiveSheet()->setCellValue('J9','Target');
		
		if($page_type=='mid'){
			$objPHPExcel->getActiveSheet()->setCellValue('K8','Mid Year Self Score');
			$objPHPExcel->getActiveSheet()->mergeCells('K8:M8'); 
			$objPHPExcel->getActiveSheet()->setCellValue('K9','Actual');
			$objPHPExcel->getActiveSheet()->setCellValue('L9','Comments');
			$objPHPExcel->getActiveSheet()->setCellValue('M9','View Document');
			$objPHPExcel->getActiveSheet()->setCellValue('N8','Mid Year Appraiser Score');
			$objPHPExcel->getActiveSheet()->mergeCells('N8:O8'); 
			$objPHPExcel->getActiveSheet()->setCellValue('N9','Comments');
			$objPHPExcel->getActiveSheet()->setCellValue('O9','View Document');
			if($kraRecordList[0]['KraTarget']['reviewer_id']!=0 && $kraRecordList[0]['KraTarget']['moderator_id']!=0){
				$objPHPExcel->getActiveSheet()->setCellValue('P8','Mid Year Reviewer Score');
				$objPHPExcel->getActiveSheet()->mergeCells('P8:Q8'); 
				$objPHPExcel->getActiveSheet()->setCellValue('P9','Comments');
				$objPHPExcel->getActiveSheet()->setCellValue('Q9','View Document');
				$objPHPExcel->getActiveSheet()->setCellValue('R8','Mid Year Moderator Score');
				$objPHPExcel->getActiveSheet()->mergeCells('R8:S8'); 
				$objPHPExcel->getActiveSheet()->setCellValue('R9','Comments');
				$objPHPExcel->getActiveSheet()->setCellValue('S9','View Document');
			}elseif($kraRecordList[0]['KraTarget']['reviewer_id']!=0 && $kraRecordList[0]['KraTarget']['moderator_id']==0){
				$objPHPExcel->getActiveSheet()->setCellValue('P8','Mid Year Reviewer Score');
				$objPHPExcel->getActiveSheet()->mergeCells('P8:Q8'); 
				$objPHPExcel->getActiveSheet()->setCellValue('P9','Comments');
				$objPHPExcel->getActiveSheet()->setCellValue('Q9','View Document');
			}
			
		}
		if($page_type=='ann'){
			$objPHPExcel->getActiveSheet()->setCellValue('K8','Mid Year Self Score');
			$objPHPExcel->getActiveSheet()->mergeCells('K8:M8'); 
			$objPHPExcel->getActiveSheet()->setCellValue('K9','Actual');
			$objPHPExcel->getActiveSheet()->setCellValue('L9','Comments');
			$objPHPExcel->getActiveSheet()->setCellValue('M9','View Document');
			$objPHPExcel->getActiveSheet()->setCellValue('N8','Mid Year Appraiser Score');
			$objPHPExcel->getActiveSheet()->mergeCells('N8:O8'); 
			$objPHPExcel->getActiveSheet()->setCellValue('N9','Comments');
			$objPHPExcel->getActiveSheet()->setCellValue('O9','View Document');
			if($kraRecordList[0]['KraTarget']['reviewer_id']!=0 && $kraRecordList[0]['KraTarget']['moderator_id']!=0){
				$objPHPExcel->getActiveSheet()->setCellValue('P8','Mid Year Reviewer Score');
				$objPHPExcel->getActiveSheet()->mergeCells('P8:Q8'); 
				$objPHPExcel->getActiveSheet()->setCellValue('P9','Comments');
				$objPHPExcel->getActiveSheet()->setCellValue('Q9','View Document');
				$objPHPExcel->getActiveSheet()->setCellValue('R8','Mid Year Moderator Score');
				$objPHPExcel->getActiveSheet()->mergeCells('R8:S8'); 
				$objPHPExcel->getActiveSheet()->setCellValue('R9','Comments');
				$objPHPExcel->getActiveSheet()->setCellValue('S9','View Document');
			}elseif($kraRecordList[0]['KraTarget']['reviewer_id']!=0 && $kraRecordList[0]['KraTarget']['moderator_id']==0){
				$objPHPExcel->getActiveSheet()->setCellValue('P8','Mid Year Reviewer Score');
				$objPHPExcel->getActiveSheet()->mergeCells('P8:Q8'); 
				$objPHPExcel->getActiveSheet()->setCellValue('P9','Comments');
				$objPHPExcel->getActiveSheet()->setCellValue('Q9','View Document');
			}
			
			$objPHPExcel->getActiveSheet()->setCellValue('K8','Mid Year Self Score');
			$objPHPExcel->getActiveSheet()->mergeCells('K8:M8'); 
			$objPHPExcel->getActiveSheet()->setCellValue('K9','Actual');
			$objPHPExcel->getActiveSheet()->setCellValue('L9','Comments');
			$objPHPExcel->getActiveSheet()->setCellValue('M9','View Document');
			$objPHPExcel->getActiveSheet()->setCellValue('N8','Mid Year Appraiser Score');
			$objPHPExcel->getActiveSheet()->mergeCells('N8:O8'); 
			$objPHPExcel->getActiveSheet()->setCellValue('N9','Comments');
			$objPHPExcel->getActiveSheet()->setCellValue('O9','View Document');
			if($kraRecordList[0]['KraTarget']['reviewer_id']!=0 && $kraRecordList[0]['KraTarget']['moderator_id']!=0){
				$objPHPExcel->getActiveSheet()->setCellValue('P8','Mid Year Reviewer Score');
				$objPHPExcel->getActiveSheet()->mergeCells('P8:Q8'); 
				$objPHPExcel->getActiveSheet()->setCellValue('P9','Comments');
				$objPHPExcel->getActiveSheet()->setCellValue('Q9','View Document');
				$objPHPExcel->getActiveSheet()->setCellValue('R8','Mid Year Moderator Score');
				$objPHPExcel->getActiveSheet()->mergeCells('R8:S8'); 
				$objPHPExcel->getActiveSheet()->setCellValue('R9','Comments');
				$objPHPExcel->getActiveSheet()->setCellValue('S9','View Document');
			}elseif($kraRecordList[0]['KraTarget']['reviewer_id']!=0 && $kraRecordList[0]['KraTarget']['moderator_id']==0){
				$objPHPExcel->getActiveSheet()->setCellValue('P8','Mid Year Reviewer Score');
				$objPHPExcel->getActiveSheet()->mergeCells('P8:Q8'); 
				$objPHPExcel->getActiveSheet()->setCellValue('P9','Comments');
				$objPHPExcel->getActiveSheet()->setCellValue('Q9','View Document');
			}
			
		}
	
	$objPHPExcel->getActiveSheet()->getStyle("A1")->getFont()->setBold(true);
	$objPHPExcel->getActiveSheet()->getStyle("A2")->getFont()->setBold(true);
	$objPHPExcel->getActiveSheet()->getStyle("A3")->getFont()->setBold(true);
	$objPHPExcel->getActiveSheet()->getStyle("A4")->getFont()->setBold(true);
	$objPHPExcel->getActiveSheet()->getStyle("A5")->getFont()->setBold(true);
	$objPHPExcel->getActiveSheet()->getStyle("A6")->getFont()->setBold(true);
	$objPHPExcel->getActiveSheet()->getStyle("G2")->getFont()->setBold(true);
	$objPHPExcel->getActiveSheet()->getStyle("G3")->getFont()->setBold(true);
	$objPHPExcel->getActiveSheet()->getStyle("G4")->getFont()->setBold(true);
	$objPHPExcel->getActiveSheet()->getStyle("G5")->getFont()->setBold(true);
	$objPHPExcel->getActiveSheet()->getStyle("G6")->getFont()->setBold(true);

	$objPHPExcel->getActiveSheet()->getStyle('A1:S1')->applyFromArray(
									array(
											'fill' => array(
												'type' => PHPExcel_Style_Fill::FILL_SOLID,
												'color' => array('rgb' => 'bbdefb')
											),
											'borders' => array(
												'allborders' => array(
													'style' => PHPExcel_Style_Border::BORDER_THIN,
													'color' => array('rgb' => '000000')
												)
											)
										)
									);
	$objPHPExcel->getActiveSheet()->getStyle('A2:S2')->applyFromArray(
									array(
											'fill' => array(
												'type' => PHPExcel_Style_Fill::FILL_SOLID,
												'color' => array('rgb' => 'bbdefb')
											),
											'borders' => array(
												'allborders' => array(
													'style' => PHPExcel_Style_Border::BORDER_THIN,
													'color' => array('rgb' => '000000')
												)
											)
										)
									);
	$objPHPExcel->getActiveSheet()->getStyle('A3:S3')->applyFromArray(
									array(
											'fill' => array(
												'type' => PHPExcel_Style_Fill::FILL_SOLID,
												'color' => array('rgb' => 'bbdefb')
											),
											'borders' => array(
												'allborders' => array(
													'style' => PHPExcel_Style_Border::BORDER_THIN,
													'color' => array('rgb' => '000000')
												)
											)
										)
									);
	$objPHPExcel->getActiveSheet()->getStyle('A4:S4')->applyFromArray(
									array(
											'fill' => array(
												'type' => PHPExcel_Style_Fill::FILL_SOLID,
												'color' => array('rgb' => 'bbdefb')
											),
											'borders' => array(
												'allborders' => array(
													'style' => PHPExcel_Style_Border::BORDER_THIN,
													'color' => array('rgb' => '000000')
												)
											)
										)
									);
	$objPHPExcel->getActiveSheet()->getStyle('A5:S5')->applyFromArray(
									array(
											'fill' => array(
												'type' => PHPExcel_Style_Fill::FILL_SOLID,
												'color' => array('rgb' => 'bbdefb')
											),
											'borders' => array(
												'allborders' => array(
													'style' => PHPExcel_Style_Border::BORDER_THIN,
													'color' => array('rgb' => '000000')
												)
											)
										)
									);
	$objPHPExcel->getActiveSheet()->getStyle('A6:S6')->applyFromArray(
									array(
											'fill' => array(
												'type' => PHPExcel_Style_Fill::FILL_SOLID,
												'color' => array('rgb' => 'bbdefb')
											),
											'borders' => array(
												'allborders' => array(
													'style' => PHPExcel_Style_Border::BORDER_THIN,
													'color' => array('rgb' => '000000')
												)
											)
										)
									);
	
	$objPHPExcel->getActiveSheet()->getStyle('A8:S8')->applyFromArray(
									array(
											'fill' => array(
												'type' => PHPExcel_Style_Fill::FILL_SOLID,
												'color' => array('rgb' => 'bbdefb')
											),
											'borders' => array(
												'allborders' => array(
													'style' => PHPExcel_Style_Border::BORDER_THIN,
													'color' => array('rgb' => '000000')
												)
											),
											'font' => array(
												'bold' => true,
											)
										)
									);
	$objPHPExcel->getActiveSheet()->getStyle('A9:S9')->applyFromArray(
									array(
											'fill' => array(
												'type' => PHPExcel_Style_Fill::FILL_SOLID,
												'color' => array('rgb' => 'bbdefb')
											),
											'borders' => array(
												'allborders' => array(
													'style' => PHPExcel_Style_Border::BORDER_THIN,
													'color' => array('rgb' => '000000')
												)
											),
											'font' => array(
												'bold' => true,
											)
										)
									);
	$objPHPExcel->getActiveSheet()->getStyle('A8:S8')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objPHPExcel->getActiveSheet()->getStyle('A9:S9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$i=1;
		$j=10;
		
		foreach ($kraRecordList as $key => $value) {
			
			$objPHPExcel->getActiveSheet()->setCellValue('A'.$j,$i);
			$objPHPExcel->getActiveSheet()->setCellValue('B'.$j,$kraRecordList[$key]['KraTarget']['kra_name']);
			$objPHPExcel->getActiveSheet()->setCellValue('C'.$j,$kraRecordList[$key]['KraTarget']['weightage']);
			$objPHPExcel->getActiveSheet()->setCellValue('D'.$j,$kraRecordList[$key]['KraTarget']['measure']);
			if($kraRecordList[$key]['KraTarget']['measure_type']==1){
			$measure_type = 'Higher the Better';
			}elseif($kraRecordList[$key]['KraTarget']['measure_type']==2){
			$measure_type = 'Lower the Better';
			}elseif($kraRecordList[$key]['KraTarget']['measure_type']==3){
			$measure_type = 'Boolean';
			}
			$objPHPExcel->getActiveSheet()->setCellValue('E'.$j,$measure_type);
			if($kraRecordList[$key]['KraTarget']['kra_upload']==''){
			$kra_upload = 'N/A';
			}else{
			$kra_upload = $kraRecordList[$key]['KraTarget']['kra_upload'];
			}
			if($kraRecordList[$key]['KraTarget']['mid_self_upload']==''){
			$mid_self_upload = 'N/A';
			}else{
			$mid_self_upload = $kraRecordList[$key]['KraTarget']['mid_self_upload'];
			}
			if($kraRecordList[$key]['KraTarget']['mid_self_score_actual']==''){
			$kraRecordList[$key]['KraTarget']['mid_self_score_actual'] = 'N/A';
			}else{
			$kraRecordList[$key]['KraTarget']['mid_self_score_actual'] = $kraRecordList[$key]['KraTarget']['mid_self_score_actual'];
				if($kraRecordList[$key]['KraTarget']['measure_type']==3){
					if($kraRecordList[$key]['KraTarget']['mid_self_score_actual']==1){
						$kraRecordList[$key]['KraTarget']['mid_self_score_actual'] = 'Overachieved';
					}elseif($kraRecordList[$key]['KraTarget']['mid_self_score_actual']==2){
						$kraRecordList[$key]['KraTarget']['mid_self_score_actual'] = 'Achieved';
					}elseif($kraRecordList[$key]['KraTarget']['mid_self_score_actual']==3){
						$kraRecordList[$key]['KraTarget']['mid_self_score_actual'] = 'Underachieved';
					}
				}
			}
			if($kraRecordList[$key]['KraTarget']['mid_self_score_comment']==''){
			$mid_self_score_comment = 'N/A';
			}else{
			$mid_self_score_comment = $kraRecordList[$key]['KraTarget']['mid_self_score_comment'];
			}
			if($kraRecordList[$key]['KraTarget']['mid_self_actual_upload']==''){
			$mid_self_actual_upload = 'N/A';
			}else{
			$mid_self_actual_upload = $kraRecordList[$key]['KraTarget']['mid_self_actual_upload'];
			}
			if($kraRecordList[$key]['KraTarget']['mid_app_actual_upload']==''){
			$mid_app_actual_upload = 'N/A';
			}else{
			$mid_app_actual_upload = $kraRecordList[$key]['KraTarget']['mid_app_actual_upload'];
			}
			if($kraRecordList[$key]['KraTarget']['mid_rev_actual_upload']==''){
			$mid_rev_actual_upload = 'N/A';
			}else{
			$mid_rev_actual_upload = $kraRecordList[$key]['KraTarget']['mid_rev_actual_upload'];
			}
			if($kraRecordList[$key]['KraTarget']['mid_mod_actual_upload']==''){
			$mid_mod_actual_upload = 'N/A';
			}else{
			$mid_mod_actual_upload = $kraRecordList[$key]['KraTarget']['mid_mod_actual_upload'];
			}
			$objPHPExcel->getActiveSheet()->setCellValue('F'.$j,$kra_upload);
			$objPHPExcel->getActiveSheet()->setCellValue('G'.$j,$kraRecordList[$key]['KraTarget']['qualifying']);
			$objPHPExcel->getActiveSheet()->setCellValue('H'.$j,$kraRecordList[$key]['KraTarget']['target']);
			$objPHPExcel->getActiveSheet()->setCellValue('I'.$j,$kraRecordList[$key]['KraTarget']['stretched']);
			$objPHPExcel->getActiveSheet()->setCellValue('J'.$j,$kraRecordList[$key]['KraTarget']['mid_self_target']);
			if($page_type=='mid'){
				$objPHPExcel->getActiveSheet()->setCellValue('K'.$j,$kraRecordList[$key]['KraTarget']['mid_self_score_actual']);
				$objPHPExcel->getActiveSheet()->setCellValue('L'.$j,$mid_self_score_comment);
				$objPHPExcel->getActiveSheet()->setCellValue('M'.$j,$mid_self_actual_upload);
				$objPHPExcel->getActiveSheet()->setCellValue('N'.$j,$kraRecordList[$key]['KraTarget']['mid_appraiser_score_comment']);
				$objPHPExcel->getActiveSheet()->setCellValue('O'.$j,$mid_app_actual_upload);
				if($kraRecordList[0]['KraTarget']['reviewer_id']!=0 && $kraRecordList[0]['KraTarget']['moderator_id']!=0){
					$objPHPExcel->getActiveSheet()->setCellValue('P'.$j,$kraRecordList[$key]['KraTarget']['mid_reviewer_score_comment']);
					$objPHPExcel->getActiveSheet()->setCellValue('Q'.$j,$mid_rev_actual_upload);
					$objPHPExcel->getActiveSheet()->setCellValue('R'.$j,$kraRecordList[$key]['KraTarget']['mid_moderator_score_comment']);
					$objPHPExcel->getActiveSheet()->setCellValue('S'.$j,$mid_mod_actual_upload);
				}elseif($kraRecordList[0]['KraTarget']['reviewer_id']!=0 && $kraRecordList[0]['KraTarget']['moderator_id']==0){
					$objPHPExcel->getActiveSheet()->setCellValue('P'.$j,$kraRecordList[$key]['KraTarget']['mid_reviewer_score_comment']);
					$objPHPExcel->getActiveSheet()->setCellValue('Q'.$j,$mid_rev_actual_upload);
					
				}
			}
			if($page_type=='ann'){
				$objPHPExcel->getActiveSheet()->setCellValue('K'.$j,$kraRecordList[$key]['KraTarget']['mid_self_score_actual']);
				$objPHPExcel->getActiveSheet()->setCellValue('L'.$j,$mid_self_score_comment);
				$objPHPExcel->getActiveSheet()->setCellValue('M'.$j,$mid_self_actual_upload);
				$objPHPExcel->getActiveSheet()->setCellValue('N'.$j,$kraRecordList[$key]['KraTarget']['mid_appraiser_score_comment']);
				$objPHPExcel->getActiveSheet()->setCellValue('O'.$j,$mid_app_actual_upload);
				if($kraRecordList[0]['KraTarget']['reviewer_id']!=0 && $kraRecordList[0]['KraTarget']['moderator_id']!=0){
					$objPHPExcel->getActiveSheet()->setCellValue('P'.$j,$kraRecordList[$key]['KraTarget']['mid_reviewer_score_comment']);
					$objPHPExcel->getActiveSheet()->setCellValue('Q'.$j,$mid_rev_actual_upload);
					$objPHPExcel->getActiveSheet()->setCellValue('R'.$j,$kraRecordList[$key]['KraTarget']['mid_moderator_score_comment']);
					$objPHPExcel->getActiveSheet()->setCellValue('S'.$j,$mid_mod_actual_upload);
				}elseif($kraRecordList[0]['KraTarget']['reviewer_id']!=0 && $kraRecordList[0]['KraTarget']['moderator_id']==0){
					$objPHPExcel->getActiveSheet()->setCellValue('P'.$j,$kraRecordList[$key]['KraTarget']['mid_reviewer_score_comment']);
					$objPHPExcel->getActiveSheet()->setCellValue('Q'.$j,$mid_rev_actual_upload);
					
				}
				
				$objPHPExcel->getActiveSheet()->setCellValue('K'.$j,$kraRecordList[$key]['KraTarget']['mid_self_acheivement']);
				$objPHPExcel->getActiveSheet()->setCellValue('L'.$j,$mid_self_comment);
				$objPHPExcel->getActiveSheet()->setCellValue('M'.$j,$mid_self_upload);
				$objPHPExcel->getActiveSheet()->setCellValue('N'.$j,$kraRecordList[$key]['KraTarget']['mid_appraiser_score_comment']);
				$objPHPExcel->getActiveSheet()->setCellValue('O'.$j,$mid_app_actual_upload);
				if($kraRecordList[0]['KraTarget']['reviewer_id']!=0 && $kraRecordList[0]['KraTarget']['moderator_id']!=0){
					$objPHPExcel->getActiveSheet()->setCellValue('P'.$j,$kraRecordList[$key]['KraTarget']['mid_reviewer_score_comment']);
					$objPHPExcel->getActiveSheet()->setCellValue('Q'.$j,$mid_rev_actual_upload);
					$objPHPExcel->getActiveSheet()->setCellValue('R'.$j,$kraRecordList[$key]['KraTarget']['mid_moderator_score_comment']);
					$objPHPExcel->getActiveSheet()->setCellValue('S'.$j,$mid_mod_actual_upload);
				}elseif($kraRecordList[0]['KraTarget']['reviewer_id']!=0 && $kraRecordList[0]['KraTarget']['moderator_id']==0){
	
				$objPHPExcel->getActiveSheet()->setCellValue('P'.$j,$kraRecordList[$key]['KraTarget']['mid_reviewer_score_comment']);
					$objPHPExcel->getActiveSheet()->setCellValue('Q'.$j,$mid_rev_actual_upload);
					
				}
				
			}
			$i++;
			$j++;
		}
		
		}
		ob_clean();
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        
        header('Content-Type: application/vnd.ms-excel');
        header("Content-Type:application/force-download");
		if($page_type=='mid'){
			 header('Content-Disposition: attachment;filename="KRA_MidReview.xls"');
		}elseif($page_type=='ann'){
			 header('Content-Disposition: attachment;filename="KRA_Annual.xls"');
		}else{
			 header('Content-Disposition: attachment;filename="KRA_detail.xls"');
		}
       
        header('Cache-Control: max-age=0');
		
		ob_end_clean();
		//$objWriter->save( $folderToSaveXls . '/kra.xls' );
       $objWriter->save('php://output');
		
        
		}
		die;
    }
	
	
	public function checkstatus(){
		//Configure::write('debug',2);
	   $empCode = $_POST['empCode'];
	   $level = $_POST['level'];
	   
	   if($level==2){
		    $mid_kra_Status = $this->MidReviews->find('all', array(
				'fields' => array('*'),
				'conditions' => array("emp_code" => $empCode, "app_review_status" => 1),
				));
		
			if(!empty($mid_kra_Status)){
				$mid_kra_Status=1;
			}else{
				$mid_kra_Status=0;
			}
			$mid_comp_Status = $this->CompetencyTarget->find('all', array(
				'fields' => array('*'),
				'conditions' => array("emp_code" => $empCode, "appraiser_mid_rating_comment != " => ''),
				'group' => array("emp_code"),
				));
		
			if(!empty($mid_comp_Status)){
				$mid_comp_Status=1;
			}else{
				$mid_comp_Status=0;
			}
			
	  
	   }elseif($level==3){
		   $mid_kra_Status = $this->MidReviews->find('all', array(
				'fields' => array('*'),
				'conditions' => array("emp_code" => $empCode, "app_review_status" => 1, "rev_review_status" => 1),
				));
		
			if(!empty($mid_kra_Status)){
				$mid_kra_Status=1;
			}else{
				$mid_kra_Status=0;
			}
			$mid_comp_Status = $this->CompetencyTarget->find('all', array(
				'fields' => array('*'),
				'conditions' => array("emp_code" => $empCode, "appraiser_mid_rating_comment != " => '', "reviewer_mid_rating_comment != " => ''),
				'group' => array("emp_code"),
				));
		
			if(!empty($mid_comp_Status)){
				$mid_comp_Status=1;
			}else{
				$mid_comp_Status=0;
			}
	   }elseif($level==4){
		   $mid_kra_Status = $this->MidReviews->find('all', array(
				'fields' => array('*'),
				'conditions' => array("emp_code" => $empCode, "app_review_status" => 1, "mod_review_status" => 1, "rev_review_status" => 1),
				));
		
			if(!empty($mid_kra_Status)){
				$mid_kra_Status=1;
			}else{
				$mid_kra_Status=0;
			}
			$mid_comp_Status = $this->CompetencyTarget->find('all', array(
				'fields' => array('*'),
				'conditions' => array("emp_code" => $empCode, "appraiser_mid_rating_comment != " => '', "reviewer_mid_rating_comment != " => '', "moderator_mid_rating_comment != " => ''),
				'group' => array("emp_code"),
				));
		
			if(!empty($mid_comp_Status)){
				$mid_comp_Status=1;
			}else{
				$mid_comp_Status=0;
			}
	   }else{
		   $mid_kra_Status=1;
		   $mid_comp_Status=1;
	   }
      $this->layout = false;
	  $ar =array('mid_kra_Status'=>$mid_kra_Status ,'mid_comp_Status'=>$mid_comp_Status);
	  print_r(json_encode($ar));
	   die;
	}
	
	function updatePassword() {
     //  Configure::write('debug',2);
        $this->autoRender = false;
        
        $myprofile = $this->MyProfile->find('all', array(
            'fields' => array('*'),
            'conditions' => 'MyProfile.status=32',
            //'group' => array('KraTarget.emp_code'),
        ));


        $ctr = 1;
		$abc=1;
        foreach ($myprofile as $key => $value) {

           
            $location = $this->EmpDetail->getCompanyName($myprofile[$key]['MyProfile']['comp_code']);
            $desgCode = $this->EmpDetail->findDesignationByEmpCode($myprofile[$key]['MyProfile']['emp_code']);
            $desgName = $this->EmpDetail->findDesignationName($desgCode, $myprofile[$key]['MyProfile']['comp_code']);

            $empDetails = $this->EmpDetail->getEmpDetails($myprofile[$key]['MyProfile']['emp_code']);

            $joiningDate = date('d-m-Y', strtotime($empDetails['MyProfile']['join_date']));
            $manager_code = $this->EmpDetail->findEmpName($empDetails['MyProfile']['manager_code']);
			
			$mngDetails = $this->EmpDetail->getEmpDetails($empDetails['MyProfile']['manager_code']);
			$reviewer_code = $this->EmpDetail->findEmpName($mngDetails['MyProfile']['manager_code']);
			$revDetails = $this->EmpDetail->getEmpDetails($mngDetails['MyProfile']['manager_code']);
			$moderator_code = $this->EmpDetail->findEmpName($revDetails['MyProfile']['manager_code']);
			

            $AppraiserDesgCode = $this->EmpDetail->getempdesgcode($empDetails['MyProfile']['manager_code']);
            $appraiserDesgName = $this->EmpDetail->findDesignationName($AppraiserDesgCode, $empDetails['MyProfile']['comp_code']);
			
			$ReviewerDesgCode = $this->EmpDetail->getempdesgcode($mngDetails['MyProfile']['manager_code']);
            $reviewerDesgName = $this->EmpDetail->findDesignationName($ReviewerDesgCode, $mngDetails['MyProfile']['comp_code']);
			$ModeratorDesgCode = $this->EmpDetail->getempdesgcode($revDetails['MyProfile']['manager_code']);
            $moderatorDesgName = $this->EmpDetail->findDesignationName($ModeratorDesgCode, $revDetails['MyProfile']['comp_code']);

            $empCode = $myprofile[$key]['MyProfile']['emp_code'];
            $empName = ucfirst($this->EmpDetail->findEmpName($myprofile[$key]['MyProfile']['emp_code']));

            $empDetails = $this->Common->getEmpDetails($myprofile[$key]['MyProfile']['emp_code']);
            $listName = $this->Common->findInvestName($myprofile[$key]['MyProfile']['location_code']);

            $locationName = $listName['OptionAttribute']['name'];


            # code...
            $val['Sr_no'] = $ctr;
            $val['Employee_Code'] = $empDetails['MyProfile']['emp_id'];
            $val['Name'] = $empName;
			$val['Location'] = $location;
            $val['Designation'] = $desgName;
         
            $val['Appraiser_Name'] = $manager_code;
            $val['Appraiser_Designation'] = $appraiserDesgName;
			$val['Reviewer_Name'] = $reviewer_code;
            $val['Reviewer_Designation'] = $reviewerDesgName;
			$val['Moderator_Name'] = $moderator_code;
            $val['Moderator_Designation'] = $ModeratorDesgCode;
			
			$user = $this->UserDetail->find('first', array(
            'fields' => array('user_password','last_login'),
            'conditions' => array(
									'UserDetail.emp_code' => $myprofile[$key]['MyProfile']['emp_code'],
									)
								)); 
		
		if(($this->Auth->password(date('dmY', strtotime($myprofile[$key]['MyProfile']['dob']))) == $user['UserDetail']['user_password'])){
			echo 'matched';
		}else{
			if($user['UserDetail']['last_login'] ==''){
			echo '<br>changed - '.$myprofile[$key]['MyProfile']['emp_id']. $empName.' - '.$user['UserDetail']['last_login'].' - ';
			echo $abc.'<br>';
			/* $success = $this->UserDetail->UpdateAll(
								array(
									'UserDetail.user_password' => '"'.$this->Auth->password(date('dmY', strtotime($myprofile[$key]['MyProfile']['dob']))).'"',
									), 
								array(
									'UserDetail.emp_code' => $myprofile[$key]['MyProfile']['emp_code']
									)
								);  */
			$abc++;
			}
		}
			
          
            $input_array[$ctr] = $val;

            $ctr++;
        }
		//end
    }
	
	function updatePMS() {
      Configure::write('debug',2);
        $this->autoRender = false;
        
		
		/*  $data=$this->KraTarget->query('SELECT emp_code FROM `kra_target` WHERE `emp_status` = 2 group by emp_code ORDER BY `id` asc');

        $ctr = 1;
		$abc=1;
        foreach ($data as $key => $value) {
			echo $ctr;
			echo "INSERT INTO `kra_approval_status` (`id`, `financial_year`, `emp_code`, `emp_status`, `app_status`, `rev_status`) VALUES (NULL, '5', '" .$value['kra_target']['emp_code']."', '1', '', '');";
			echo '<br>';
			
			$this->KraTarget->query("INSERT INTO `kra_approval_status` (`id`, `financial_year`, `emp_code`, `emp_status`, `app_status`, `rev_status`) VALUES (NULL, '5', '" .$value['kra_target']['emp_code']."', '1', '', '')");
						
			$ctr++;
        } 
		
		
        $data=$this->KraTarget->query('SELECT emp_code FROM `kra_target` WHERE emp_code NOT IN (select emp_code from kra_target where `appraiser_status` = 3 or `appraiser_status` = 1) group by emp_code ORDER BY `id` asc');
		
        $ctr = 1;
		$abc=1;
        foreach ($data as $key => $value) {
			echo $ctr;
			echo "UPDATE `stl_live`.`kra_approval_status` SET `app_status` = '1' WHERE `kra_approval_status`.`emp_code` = " .$value['kra_target']['emp_code'].";";
			echo '<br>';
			
		$this->KraTarget->query("UPDATE `stl_live`.`kra_approval_status` SET `app_status` = '1' WHERE `kra_approval_status`.`emp_code` = " .$value['kra_target']['emp_code']."");
						
			$ctr++;
        }
		
		
		$data=$this->KraTarget->query('SELECT emp_code FROM `kra_target` WHERE emp_code NOT IN (select emp_code from kra_target where `reviewer_status` = 3 or `reviewer_status` = 0) group by emp_code ORDER BY `id` asc');
		
        $ctr = 1;
		$abc=1;
        foreach ($data as $key => $value) {
			echo $ctr;
			echo "UPDATE `stl_live`.`kra_approval_status` SET `rev_status` = '1' WHERE `kra_approval_status`.`emp_code` = " .$value['kra_target']['emp_code'].";";
			echo '<br>';
			
		$this->KraTarget->query("UPDATE `stl_live`.`kra_approval_status` SET `rev_status` = '1' WHERE `kra_approval_status`.`emp_code` = " .$value['kra_target']['emp_code']."");
						
			$ctr++;
        }
		
		
		
		$data=$this->CompetencyTarget->query("SELECT emp_code FROM `competency_target` where appraiser_mid_rating_comment!='' and reviewer_mid_rating_comment!='' and moderator_mid_rating_comment!='' group by emp_code ORDER BY `competency_target`.`appraiser_mid_rating_comment` ASC");
		
        $ctr = 1;
	
        foreach ($data as $key => $value) {
			echo $ctr;
			echo "INSERT INTO `competency_status` (`id`, `financial_year`, `emp_code`, `app_mid_status`, `rev_mid_status`, `mod_mid_status`, `app_ann_status`, `rev_ann_status`, `mod_ann_status`) VALUES (NULL, '5', '" .$value['competency_target']['emp_code']."', '1', '1', '1', '0', '0', '0');";
			echo '<br>';
			
		$this->CompetencyTarget->query("INSERT INTO `competency_status` (`id`, `financial_year`, `emp_code`, `app_mid_status`, `rev_mid_status`, `mod_mid_status`, `app_ann_status`, `rev_ann_status`, `mod_ann_status`) VALUES (NULL, '5', '" .$value['competency_target']['emp_code']."', '1', '1', '1', '0', '0', '0')");
						
			$ctr++;
        }
		
		*/
		
    }
    

}

?>
