<?php

App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');
App::uses('Folder', 'Utility');
App::uses('File', 'Utility');

class BoardsController extends AppController {

    public $name = 'Boards';
    public $uses = array('MyProfile', 'Departments', 'BMDataTypeDetails','BMReportTypeAttachFiles','BMReportTypeAttachment', 'BMRecrutFinal', 'BMReceiveRequestForward', 'BMRequestDetails', 'BMMeetingRequest', 'BMMeetingRequestRefnum', 'BMTitle', 'MstRequest', 'MstSignatory', 'BMReceiveRequest', 'DataType', 'Ministry');
    public $helpers = array('Js', 'Html', 'Form', 'Session', 'Userdetail', 'Common');
    public $components = array('Auth', 'Session', 'Email', 'Cookie', 'EmpDetail', 'Common', 'RequestHandler', 'Paginator');

    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow();
        $currentUser = $this->checkUser();
    }

    public function department() {
        $this->layout = 'employee-new';
        $auth = $this->Session->read('Auth');
        $m = $auth['MyProfile']['emp_code'];
        $comp_code = $this->Auth->user('comp_code');

        $dept = $this->Departments->find('list', array(
            'fields' => array('Departments.dept_code', 'Departments.dept_name'),
            'conditions' => array('Departments.comp_code' => $comp_code)
        ));

        $this->set("department_list", $dept);
    }

    public function req_receive() {
		//Configure::write('debug',2);
        $this->layout = 'employee-new';
        $auth = $this->Session->read('Auth');
        $empID = $auth['MyProfile']['id'];


        $condition = array(
           // 'BMReceiveRequestForward.req_receive_by' => $empID, 
            //'BMReceiveRequestForward.frwd_status' => '0',
            'BMReceiveRequest.status' => '1',
            'OR'=>array('BMReceiveRequestForward.req_receive_by' => $empID,'BMReceiveRequest.created_by' => $empID)
        );

        $allRecReq = $this->BMReceiveRequest->find('all', array(
            'conditions' => $condition,
            
            'order' => 'BMReceiveRequest.id desc',
			'group' => 'created_by'
        ));
      
        $this->set(compact('EditaccessRight', 'allRecReq', 'empID'));
    }

    public function send_requester_notification() {
        // Configure::write('debug',2);
        $FwrdUser = $this->BMReceiveRequestForward->find('all', array(
            'conditions' => array('BMReceiveRequestForward.frwd_status' => '0'),
        ));

        foreach ($FwrdUser as $rec) {
            $frwd_date = date("Y-m-d", strtotime($rec['BMReceiveRequestForward']['forward_date']));
            $datetime1 = date_create($frwd_date);
            $datetime2 = date_create(date('Y-m-d'));
            $interval = date_diff($datetime1, $datetime2);
            $NumOfDays = $interval->format('%R%a');
            if ($NumOfDays >= 10) {
                
                $UserID = $rec['BMReceiveRequestForward']['req_receive_by'];
                $UserDet = $this->MyProfile->find('all', array('conditions' => array('MyProfile.id' => $UserID)));
                foreach($UserDet as $ud);        
                $data['id']=$ud['MyProfile']['id'];
                $data['name']=$ud['MyProfile']['emp_name'];
                
                $ReqNum = $this->Common->getReqRefNumByReqID($rec['BMReceiveRequestForward']['request_receive_id']);
                /////////Send Mail////
                $From                = "ess-portal@essindia.com" ;
                $manager_ID = $this->Common->getManagerCodeByID($UserID);
                //$ManagerMailID = $this->Common->getUserEmailByID($manager_ID);////make enable when going live....
                //$UserMailID = $this->Common->getUserEmailByID($UserID);
                $UserMailID = "bajrangi.srivastava@essindia.com"; //// make it comment when going live....
                $ManagerMailID = "ayush.pant@essindia.com";       //// make it comment when going live....
                
                
                $To = $UserMailID;
                $CC = $ManagerMailID;
                $sub = "Request Pending Notification!!!!";
                $msg = "Your request no. ".$ReqNum." is still pending, please take a prompt action on urgent basis!! ";
                $template = 'bm_req_receive';
                
                $this->Common->send_mail($From,$To, $CC, $sub, $msg,$template,$data);
                /////////End//////////
            }
        }
    }

    public function req_details() {
        // Configure::write('debug',2);
        $this->layout = 'employee-new';
        $auth = $this->Session->read('Auth');
        $empID = $auth['MyProfile']['id'];

        if ($empID == '183') {
            $condition = array('status' => '0');
            $EditaccessRight = "Yes";
        } else {
            //$ORconditions['forward_to']   = $empID;
            $condition = array('created_by' => $empID,
                'status' => '0'
            );
            $EditaccessRight = "Yes";
        }

        $ReqDet = $this->BMRequestDetails->find('all', array(
            'conditions' => $condition
        ));


        $this->set(compact('ReqDet', 'EditaccessRight'));
    }

    public function show_details($id) {
        // Configure::write('debug',2);
        // $this->layout = 'employee-new';
        $auth = $this->Session->read('Auth');
        $empID = $auth['MyProfile']['id'];

        $showDet = $this->BMRequestDetails->find('all', array(
            'conditions' => array('id' => $id)
        ));

        $this->set(compact('showDet'));
    }

    public function bm_show_details($id, $datatype) {
        // Configure::write('debug',2);
        // $this->layout = 'employee-new';
        $auth = $this->Session->read('Auth');
        $empID = $auth['MyProfile']['id'];

        $showDet = $this->BMDataTypeDetails->find('all', array(
            'conditions' => array('id' => $id)
        ));
        $val = $datatype;
        $this->set(compact('showDet', 'val'));
    }

    public function req_details_save() {
        //Configure::write('debug',2);
        $this->layout = 'employee-new';
        $auth = $this->Session->read('Auth');
        $empID = $auth['MyProfile']['id'];


        if (isset($this->request->data['submit']) && $this->request->data['submit'] != '') {

            $reqID = $this->request->data['req_ref'];

            $data['BMRequestDetails']['serial_num'] = $this->request->data['seriNum'];
            $data['BMRequestDetails']['request_id'] = $this->request->data['req_ref'];
            $data['BMRequestDetails']['id_no'] = $this->request->data['id_no'];
            $data['BMRequestDetails']['p_no'] = $this->request->data['p_no'];
            $data['BMRequestDetails']['title'] = $this->request->data['title'];
            $data['BMRequestDetails']['surname'] = $this->request->data['surname'];
            $data['BMRequestDetails']['firstname'] = $this->request->data['firstname'];
            $data['BMRequestDetails']['other_name'] = $this->request->data['other_name'];
            $data['BMRequestDetails']['dob'] = date("Y-m-d", strtotime($this->request->data['dob']));
            $data['BMRequestDetails']['gender'] = $this->request->data['gender'];
            $data['BMRequestDetails']['data_entry_type'] = $this->request->data['data_entry_type'];
            $data['BMRequestDetails']['academic'] = $this->request->data['acad'];
            $data['BMRequestDetails']['professional'] = $this->request->data['prof'];
            $data['BMRequestDetails']['experience'] = $this->request->data['exp'];
            $data['BMRequestDetails']['physical_disability'] = $this->request->data['doc']['ph_disa'];
            $data['BMRequestDetails']['disable_details'] = $this->request->data['disabl_det'];
            $data['BMRequestDetails']['ministry_id'] = $this->request->data['ministry'];
            $data['BMRequestDetails']['department_code'] = $this->request->data['department'];
            $data['BMRequestDetails']['d_o_appointment'] = date("Y-m-d", strtotime($this->request->data['doa']));
            $data['BMRequestDetails']['d_o_c_appointment'] = date("Y-m-d", strtotime($this->request->data['doca']));
            $data['BMRequestDetails']['currenct_designation'] = $this->request->data['curr_desig'];
            $data['BMRequestDetails']['recommended_designation'] = $this->request->data['recomm_desig'];
            $data['BMRequestDetails']['recomm_term_services'] = $this->request->data['recomm_t_serv'];
            $data['BMRequestDetails']['justification'] = $this->request->data['justification'];
            $data['BMRequestDetails']['notes'] = $this->request->data['notes'];
            $data['BMRequestDetails']['created_by'] = $empID;

            $success = $this->BMRequestDetails->save($data);

            $Details_success = $this->BMReceiveRequest->updateAll(array('BMReceiveRequest.request_details_status' => "1"), array('BMReceiveRequest.id' => $reqID));

            if ($success) {
                $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                    <a href="#" class="uk-alert-close uk-close"></a>Request Details entered successfully !</div>');
            } else {
                $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert="">
                    <a href="#" class="uk-alert-close uk-close"></a>Sorry, Details Not Entered !</div>');
            }
            $this->redirect('req_details');
        }
        $SeriNum = $this->randNumber();
        $reqDet = $this->BMRequestDetails->find('all', array(
            'fields' => 'request_id',
            'conditions' => array('created_by' => $empID, 'status' => '0')
        ));
        if (!empty($reqDet)) {
            foreach ($reqDet as $values) {
                $rID[] = $values['BMRequestDetails']['request_id'];
            }
            $reqID = implode(",", $rID);
            $cond = 'BMReceiveRequest.id NOT IN (' . $reqID . ')';
        } else {
            $cond = '';
        }
        $reqRef = $this->BMReceiveRequest->find('all', array(
            'fields' => array('BMReceiveRequest.id', 'BMReceiveRequest.reference_num'),
            'conditions' => array('BMReceiveRequestForward.req_receive_by' => $empID, $cond, 'BMReceiveRequest.status' => '1', 'BMReceiveRequestForward.frwd_status' => '0')));

        $data_E_type = $this->DataType->find('list', array(
            'fields' => array('id', 'datatype'),
            'conditions' => array('status' => '0')
        ));
        $department = $this->Departments->find('list', array(
            'fields' => array('Departments.dept_code', 'Departments.dept_name'),
            'conditions' => array('Departments.status' => '1')
        ));

        $Ministry = $this->Ministry->find('list', array('fields' => 'ministry_name',
            'conditions' => array('ministry_status' => '1')));

        $title = $this->BMTitle->find('list', array('fields' => 'title',
            'conditions' => array('status' => '0')));
        $gender = array('0' => 'Male', '1' => 'Female');


        $this->set(compact('SeriNum', 'reqRef', 'data_E_type', 'gender', 'title', 'Ministry', 'department'));
    }

    public function req_details_edit($val = null, $del = null) {
        // Configure::write('debug',2);
        $this->layout = 'employee-new';
        $auth = $this->Session->read('Auth');
        $empID = $auth['MyProfile']['id'];

        if ($val != '' && $del == "del") {
            $success = $this->BMRequestDetails->updateAll(array('status' => "1"), array('id' => $val));
            if ($success) {
                $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert="">
            <a href="#" class="uk-alert-close uk-close"></a>Request Details Deleted. !!!</div>');
            } else {
                $this->Session->setFlash('<div class="uk-alert uk-alert-primery" data-uk-alert="">
            <a href="#" class="uk-alert-close uk-close"></a>Request Details Not Deleted. !!!</div>');
            }
            $this->redirect("req_details");
        }
        if (isset($this->request->data['submit']) && $this->request->data['submit'] != '') {

            $data['BMRequestDetails']['id'] = $this->request->data['detID'];
            $data['BMRequestDetails']['request_id'] = $this->request->data['req_ref'];
            $data['BMRequestDetails']['id_no'] = $this->request->data['id_no'];
            $data['BMRequestDetails']['p_no'] = $this->request->data['p_no'];
            $data['BMRequestDetails']['title'] = $this->request->data['title'];
            $data['BMRequestDetails']['surname'] = $this->request->data['surname'];
            $data['BMRequestDetails']['firstname'] = $this->request->data['firstname'];
            $data['BMRequestDetails']['other_name'] = $this->request->data['other_name'];
            $data['BMRequestDetails']['dob'] = date("Y-m-d", strtotime($this->request->data['dob']));
            $data['BMRequestDetails']['gender'] = $this->request->data['gender'];
            $data['BMRequestDetails']['data_entry_type'] = $this->request->data['data_entry_type'];
            $data['BMRequestDetails']['academic'] = $this->request->data['acad'];
            $data['BMRequestDetails']['professional'] = $this->request->data['prof'];
            $data['BMRequestDetails']['experience'] = $this->request->data['exp'];
            $data['BMRequestDetails']['physical_disability'] = $this->request->data['doc']['ph_disa'];
            $data['BMRequestDetails']['disable_details'] = $this->request->data['disabl_det'];
            $data['BMRequestDetails']['ministry_id'] = $this->request->data['ministry'];
            $data['BMRequestDetails']['department_code'] = $this->request->data['department'];
            $data['BMRequestDetails']['d_o_appointment'] = date("Y-m-d", strtotime($this->request->data['doa']));
            $data['BMRequestDetails']['d_o_c_appointment'] = date("Y-m-d", strtotime($this->request->data['doca']));
            $data['BMRequestDetails']['currenct_designation'] = $this->request->data['curr_desig'];
            $data['BMRequestDetails']['recommended_designation'] = $this->request->data['recomm_desig'];
            $data['BMRequestDetails']['recomm_term_services'] = $this->request->data['recomm_t_serv'];
            $data['BMRequestDetails']['justification'] = $this->request->data['justification'];
            $data['BMRequestDetails']['notes'] = $this->request->data['notes'];
            $data['BMRequestDetails']['created_by'] = $empID;

            $success = $this->BMRequestDetails->save($data);

            if ($success) {
                $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                    <a href="#" class="uk-alert-close uk-close"></a>Request Details Modified successfully !</div>');
            } else {
                $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert="">
                    <a href="#" class="uk-alert-close uk-close"></a>Sorry, Details Not Modified !</div>');
            }
            $this->redirect('req_details');
        }
        //$SeriNum = $this->randNumber();
        $reqDet = $this->BMRequestDetails->find('all', array(
            'conditions' => array('id' => $val, 'status' => '0')
        ));

//        $reqRef = $this->BMReceiveRequest->find('list', array(
//            'fields' => array('id', 'reference_num'),
//            'conditions' => array('created_by' => $empID, 'status' => '1')
//        ));

        $reqRef = $this->BMReceiveRequest->find('list', array(
            'fields' => array('BMReceiveRequest.id', 'BMReceiveRequest.reference_num'),
            'conditions' => array('BMReceiveRequest.action_officer_id' => $empID, $cond, 'BMReceiveRequest.status' => '1')));


        $data_E_type = $this->DataType->find('list', array(
            'fields' => array('id', 'datatype'),
            'conditions' => array('status' => '0')
        ));
        $department = $this->Departments->find('list', array(
            'fields' => array('Departments.dept_code', 'Departments.dept_name'),
            'conditions' => array('Departments.status' => '1')
        ));

        $Ministry = $this->Ministry->find('list', array('fields' => 'ministry_name',
            'conditions' => array('ministry_status' => '1')));

        $gender = array('0' => 'Male', '1' => 'Female');
        $title = array('0' => 'Mr.', '1' => 'Mrs', '2' => 'Pro.', '3' => 'Dr.');

        $this->set(compact('reqDet', 'reqRef', 'data_E_type', 'gender', 'title', 'Ministry', 'department'));
    }

    public function req_meeting($ids=null, $del=null) {
        // Configure::write('debug',2);
        $this->layout = 'employee-new';
        $auth = $this->Session->read('Auth');
        $empID = $auth['MyProfile']['id'];

        if ($ids != '' && $del == "del") {
            $success = $this->BMMeetingRequest->updateAll(array('BMMeetingRequest.status' => "1"), array('BMMeetingRequest.id' => $ids));
            if ($success) {
                $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert="">
            <a href="#" class="uk-alert-close uk-close"></a>Meeting Request Deleted. !!!</div>');
            } else {
                $this->Session->setFlash('<div class="uk-alert uk-alert-primery" data-uk-alert="">
            <a href="#" class="uk-alert-close uk-close"></a>Meeting Request Not Deleted. !!!</div>');
            }
            $this->redirect("req_meeting");
        }
        $this->BMMeetingRequest->recursive = -1;
        $MeetReq = $this->BMMeetingRequest->find('all', array(
            'conditions' => array('BMMeetingRequest.status' => '0')
        ));

//        echo "<pre>";
//        print_r($MeetReq);die;

        $this->set(compact('MeetReq'));
    }

    public function req_meeting_save() {
        //Configure::write('debug',2);
        $this->layout = 'employee-new';
        $auth = $this->Session->read('Auth');
        $empID = $auth['MyProfile']['id'];

        if (isset($this->request->data['submit']) && $this->request->data['submit'] != '') {
            $uniqArray = array_unique($this->request->data['req_ref']);
            $refreqID = implode(",", $uniqArray);
			
            $data['BMMeetingRequest']['meeting_number'] = $this->request->data['meetNum'];
            $data['BMMeetingRequest']['request_receive_id'] = $refreqID;
            $data['BMMeetingRequest']['subject'] = $this->request->data['subject'];
            $data['BMMeetingRequest']['meeting_date'] = date("Y-m-d", strtotime($this->request->data['dom']));
            $data['BMMeetingRequest']['created_by'] = $empID;
			$data['BMMeetingRequest']['sub'] = $this->request->data['sub'];
			$data['BMMeetingRequest']['dep'] = $this->request->data['dep'];
			$data['BMMeetingRequest']['dor'] = $this->request->data['dor'];
			$data['BMMeetingRequest']['users'] = implode(",",$this->request->data['users']);

			if ($this->request->data['doc_upload']['name'] != "") {
//Configure::write('debug',2);
                    $newfilename = time() . basename($this->request->data['doc_upload']['name']);
                    
                    $file = "uploads/bom/" . $newfilename;
                    $filename = basename($this->request->data['doc_upload']['name']);
                    $ext = strtolower(substr($filename, strrpos($filename, '.') + 1));
                    if (($ext == 'exe') || ($this->request->data['doc_upload']['size'] > 2048000)) {
                        if ($this->request->data['doc_upload']['size'] > 2048000) {
                            $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert=""><a href="#" class="uk-alert-close uk-close"></a>Sorry, this is heavy sized file, please check the size !</div>');
                        } elseif (($ext == 'exe')) {
                            $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert=""><a href="#" class="uk-alert-close uk-close"></a>Sorry, this is invalid file, please check the extention !</div>');
                        }
                        $this->redirect("req_meeting");
                    } else {
                        if (move_uploaded_file($this->request->data['doc_upload']['tmp_name'], $file)) {
							$data['BMMeetingRequest']['doc_upload'] = $newfilename;
                        } else {
							$data['BMMeetingRequest']['doc_upload'] = '';
                            //echo '<pre>';print_r($kraTarget);die;
                            $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert=""><a href="#" class="uk-alert-close uk-close"></a>Document not uploaded successfully. Please try again.</div>');
                            $this->redirect("req_meeting");
                        }
                    }
                    /*                     * ******************end here************************ */
                }
				
				$success = $this->BMMeetingRequest->save($data);
				$MeetingReqID = $this->BMMeetingRequest->getLastInsertID();
				if ($success) {
					$users=explode(',',$data['BMMeetingRequest']['users']);
					foreach ($users as $val) {
							
						$empList = $this->EmpDetail->getEmpEmailDetails($val['emp_id'], $_SESSION['Auth']['MyProfile']['comp_code']);
						$empID1 = $empList['UserDetail']['email'];
						$To = $empID1;
						$From = 'boards@gmail.com';
						$sub = "Received KRAs for your approval";
						$msg = "This is to inform you that " . $empList['UserDetail']['user_name'] . " has submitted, his/her KRA for your approval, kindly login to portal and initiate action.";$template = 'kra_fill_notification';
						if (isset($To)) {
							$this->send_mail($From, $To, $CC, $sub, $msg, $template, $data);
							
						}
					}
					foreach ($uniqArray as $val) {

						$data['BMMeetingRequestRefnum']['meeting_request_id'] = $MeetingReqID;
						$data['BMMeetingRequestRefnum']['request_receive_id'] = $val;
						$data['BMMeetingRequestRefnum']['created_by'] = $empID;

						$this->BMMeetingRequestRefnum->create();
						$successfull = $this->BMMeetingRequestRefnum->save($data);
					}
				}

				if ($success) {
					$this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
						<a href="#" class="uk-alert-close uk-close"></a>Meeting Request Save Successfully !</div>');
				} else {
					$this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert="">
						<a href="#" class="uk-alert-close uk-close"></a>Sorry, Meeting Request Does Not Save !</div>');
				}
				$this->redirect('req_meeting');
			
			
        }
        $reqRef = $this->BMReceiveRequest->find('list', array(
            'fields' => array('BMReceiveRequest.id', 'BMReceiveRequest.reference_num'),
            'conditions' => array('BMReceiveRequest.status' => '1', 'BMReceiveRequest.final_status' => '0')
        ));

                   
//                echo "<pre>";
//        print_r($reqRef);die;
        $MeetNum = $this->randNumber();
        $this->set(compact('reqRef', 'MeetNum'));
    }

    public function meeting_decision_save() {
        //Configure::write('debug',2);
        $this->layout = 'employee-new';
        $auth = $this->Session->read('Auth');
        $empID = $auth['MyProfile']['id'];

        if (isset($this->request->data['submit']) && $this->request->data['submit'] != '') {

            $meetNumbr = $this->request->data['meetNum'];


            $Alldata = $this->request->data['reqID'];
            //echo count($Alldata);
            foreach ($Alldata as $k => $val) {

                if ($this->request->data['doc']['trns_commi'][$k] != '') {
                    $trns_commi = $this->request->data['doc']['trns_commi'][$k];
                } else {
                    $trns_commi = "";
                }
				if ($this->request->data['doc']['req_ref_serial_no'][$k] != '') {
                    $req_ref_serial_no = $this->request->data['doc']['req_ref_serial_no'][$k];
                } else {
                    $req_ref_serial_no = '';
                }
                if ($this->request->data['doc']['final'][$k] == '1') {
                    $finalize_status = '1';
                } else {
                    $finalize_status = '0';
                }
				
				if ($this->request->data['doc']['remark'][$k] != '') {
                    $remark = $this->request->data['doc']['remark'][$k];
                } else {
                    $remark = '';
                }
				
				if ($this->request->data['doc']['meeting_remark'][0] != '') {
                    $meeting_remark = $this->request->data['doc']['meeting_remark'][0];
                } else {
                    $meeting_remark = '';
                }

                $this->BMMeetingRequestRefnum->create();
                $success = $this->BMMeetingRequestRefnum->updateAll(array('BMMeetingRequestRefnum.transfer_commitee' => "'$trns_commi'", 'BMMeetingRequestRefnum.finalize_status' => $finalize_status, 'BMMeetingRequestRefnum.remark' => '"'.$remark.'"','BMMeetingRequestRefnum.req_ref_serial_no' => '"'.$req_ref_serial_no.'"', 'BMMeetingRequestRefnum.meeting_remark' => '"'.$meeting_remark.'"'),  array('BMMeetingRequestRefnum.meeting_request_id' => $meetNumbr, 'BMMeetingRequestRefnum.request_receive_id' => $val, 'BMMeetingRequestRefnum.status' => '0'));
                if ($this->request->data['doc']['final'][$k] == '1') {
                    $this->BMReceiveRequest->create();
                    $successfull = $this->BMReceiveRequest->updateAll(array('BMReceiveRequest.final_status' => $finalize_status), array('BMReceiveRequest.id' => $val, 'BMReceiveRequest.status' => '1'));
                }
            }


            if ($success) {
                $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                    <a href="#" class="uk-alert-close uk-close"></a>Meeting Decision Save Successfully !</div>');
            } else {
                $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert="">
                    <a href="#" class="uk-alert-close uk-close"></a>Sorry, Meeting Decision Does Not Save !</div>');
            }
            $this->redirect('meeting_decision');
        }
        $reqRef = $this->BMReceiveRequest->find('list', array(
            'fields' => array('id', 'reference_num'),
            'conditions' => array('status' => '1')
        ));


        $MeetNum = $this->BMMeetingRequest->find('list', array(
            'fields' => array('id', 'meeting_number'),
            'conditions' => array('status' => '0')
        ));




        $this->set(compact('reqRef', 'MeetNum'));
    }

    public function meeting_decision() {
        // Configure::write('debug',2);
        $this->layout = 'employee-new';
        $auth = $this->Session->read('Auth');
        $empID = $auth['MyProfile']['id'];

        if ($ids != '' && $del == "del") {
            $success = $this->BMMeetingRequest->updateAll(array('status' => "1"), array('id' => $ids));
            if ($success) {
                $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert="">
            <a href="#" class="uk-alert-close uk-close"></a>Meeting Request Deleted. !!!</div>');
            } else {
                $this->Session->setFlash('<div class="uk-alert uk-alert-primery" data-uk-alert="">
            <a href="#" class="uk-alert-close uk-close"></a>Meeting Request Not Deleted. !!!</div>');
            }
            $this->redirect("req_meeting");
        }
        $this->BMMeetingRequest->recursive = 2;
        $MeetReq = $this->BMMeetingRequest->find('all', array(
            'conditions' => array('BMMeetingRequest.status' => '0', 'BMMeetingRequestRefnum.finalize_status' => '1')
        ));
//        echo "<pre>";
//        print_r($MeetReq);die;
        $this->set(compact('MeetReq'));
    }

    public function meeting_decision_fields($reqID) {
       //Configure::write('debug',2);
        $auth = $this->Session->read('Auth');
        $empID = $auth['MyProfile']['id'];


        $reqRef = $this->BMMeetingRequest->find('all', array(
            'conditions' => array('BMMeetingRequest.id' => $reqID, 'BMMeetingRequest.status' => '0', 'BMMeetingRequestRefnum.finalize_status !=' => '1')
        ));

        $flag = 'close';
        foreach($reqRef as $rec){
            if($rec['BMMeetingRequestRefnum']['finalize_status'] == '0'){
                $flag='open';
            }
            
        }
        $this->set(compact('reqID', 'reqRef','flag'));
    }

    public function meeting_fields($reqID) {
        // Configure::write('debug',2);
        $auth = $this->Session->read('Auth');
        $empID = $auth['MyProfile']['id'];


        $reqRef = $this->BMReceiveRequest->find('all', array(
            'conditions' => array('BMReceiveRequest.id' => $reqID, 'BMReceiveRequest.status' => '1')
        ));

        $this->set(compact('reqID', 'reqRef'));
    }

    public function fields_datatype() {
        // Configure::write('debug',2);
        $auth = $this->Session->read('Auth');
        $empID = $auth['MyProfile']['id'];
    }

    public function randNumber() {

        list($usec, $sec) = explode(' ', microtime());
        return $sec + $usec * 1000000;
        die;
    }

    public function fields($val = null) {

        $ActionOfficer = $this->MyProfile->find('list', array(
            'fields' => array('id', 'emp_full_name'),
            'conditions' => array('dept_code' => $val)
        ));

        $this->set(compact('val', 'ActionOfficer'));
    }

    public function req_receive_save() {
        //Configure::write('debug',2);
        $this->layout = 'employee-new';
        $auth = $this->Session->read('Auth');
        $empID = $auth['MyProfile']['id'];
	$lastId=$this->BMReceiveRequest->find('first',array('order'=>'BMReceiveRequest.id DESC'));
		if(count($lastId)==0){$lastId =1;}else{$lastId = ($lastId['BMReceiveRequest']['last_serial_no']+1);}
		$this->set('lastSerialId','PSC-'.date('m/Y').'/'.str_pad($lastId, 5, '0', STR_PAD_LEFT));
	
        
		if (isset($this->request->data['submit'])) {
           
            $path = WWW_ROOT . 'bom\RequestReceiving';//die;
            $filename = $this->request->data['doc']['upl_doc']['name'];
			$data['BMReceiveRequest']['req_ref_serial_no'] = $this->request->data['req_ref_serial_no'];
            $data['BMReceiveRequest']['request_type_id'] = $this->request->data['req_cat'];
            $data['BMReceiveRequest']['dept_code'] = $this->request->data['department'];
            $data['BMReceiveRequest']['action_officer_id'] = $this->request->data['act_off'];
            $data['BMReceiveRequest']['signatory_name'] = $this->request->data['signatory'];
            $data['BMReceiveRequest']['reference_num'] = $this->request->data['refnum'];
            $data['BMReceiveRequest']['subject'] = $this->request->data['subject'];
            $data['BMReceiveRequest']['date_of_request'] = date('Y-m-d', strtotime($this->request->data['doreq']));
            $data['BMReceiveRequest']['date_of_receive'] = date('Y-m-d', strtotime($this->request->data['dorec']));
            $data['BMReceiveRequest']['created_by'] = $empID;
            $data['BMReceiveRequest']['file'] = $filename;
            $filePath = $path .DS. $filename;
            
            //////////////////file upload////////////
            
                    $filecheck = basename($this->request->data['doc']['upl_doc']['name']);
                    $ext = strtolower(substr($filecheck, strrpos($filecheck, '.') + 1));
                    if(!($ext == '' || $ext == 'pdf' || $ext == 'jpg' || $ext == 'png' || $ext == 'txt' || $ext == 'doc' || $ext == 'docx' || $ext == 'odt') || ($this->request->data['upl_doc']['size'] > 2048000) ){
                        
                        if($this->request->data['doc']['upl_doc']['size'] > 2048000){
                            $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert=""><a href="#" class="uk-alert-close uk-close"></a>Sorry, this is invalid file, please check the size !</div>');
                        }elseif(!($ext == 'pdf' || $ext == 'jpg' || $ext == 'png' || $ext == 'txt' || $ext == 'doc' || $ext == 'docx'|| $ext == 'odt')){
                            $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert=""><a href="#" class="uk-alert-close uk-close"></a>Sorry, this is invalid file, please check the extention !</div>');
                        }
                      
                        
                    }else{ 
//                            if($this->Category->save($data)) {
//                               if(move_uploaded_file($this->request->data['upl_doc']['tmp_name'],$filePath))
//                               $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert=""><a href="#" class="uk-alert-close uk-close"></a>Your file has been uploaded successfully!</div>');
//                               else
//                               $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert=""><a href="#" class="uk-alert-close uk-close"></a>Your file uploading failed!</div>');
//                            }
                           
                            $success = $this->BMReceiveRequest->save($data);
                            $RecReqID = $this->BMReceiveRequest->getLastInsertID();
							//Configure::write('debug',2);
							$successserial = $this->BMReceiveRequest->updateAll(array('last_serial_no' => $RecReqID), array('BMReceiveRequest.id' => $RecReqID));


                            $Frwd_data['BMReceiveRequestForward']['request_receive_id'] = $RecReqID;
                            $Frwd_data['BMReceiveRequestForward']['req_receive_by'] = $this->request->data['act_off'];
                            $Frwd_data['BMReceiveRequestForward']['req_forward_by'] = $empID;
                            $successFrwd = $this->BMReceiveRequestForward->save($Frwd_data);

                            if ($success) {
                                 move_uploaded_file($this->request->data['doc']['upl_doc']['tmp_name'],$filePath);
                                $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                            <a href="#" class="uk-alert-close uk-close"></a>Request Received succesfully. !!!</div>');
                            } else {
                                $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert="">
                            <a href="#" class="uk-alert-close uk-close"></a>Request is Not Received !!!</div>');
                            }
                            $this->redirect("req_receive");
                            
                            
                            
                        }
                        
            /////////////////////////////////////////
            
            
        }

        $department = $this->Departments->find('list', array(
            'fields' => array('Departments.dept_code', 'Departments.dept_name'),
            'conditions' => array('Departments.status' => '1')
        ));

        $RequestType = $this->MstRequest->find('list', array(
            'fields' => array('MstRequest.id', 'MstRequest.req_type_name'),
            'conditions' => array('MstRequest.status' => '1')
        ));
        $signatory = $this->MstSignatory->find('all', array(
            'conditions' => array('MstSignatory.status' => '1')
        ));

        foreach ($signatory as $semp) {
		if($semp['MstSignatory']['signatory_id']!= ''){
            $sig[] = $semp['MstSignatory']['signatory_id'];
			}
        }

        $signatoryID = implode(",", $sig);
        if ($signatoryID != '') {
            $Dept_Signatory = $this->MyProfile->find('list', array(
                'fields' => array('id', 'emp_full_name'),
                'conditions' => array('emp_code in (' . $signatoryID . ')')
            ));
        }
        
        $Ministry = $this->Ministry->find('list', array('fields' => 'ministry_name',
            'conditions' => array('ministry_status' => '1')));
        //array_unshift($Ministry, '--Select--');
       
        $this->set(compact("RequestType", "department", 'Dept_Signatory','Ministry'));
    }

    public function req_receive_edit($val = null, $del = null) {
        //Configure::write('debug',2);
        $this->layout = 'employee-new';
        $auth = $this->Session->read('Auth');
        $empID = $auth['MyProfile']['id'];

        if ($val != '' && $del == "del") {
            $success = $this->BMReceiveRequest->updateAll(array('BMReceiveRequest.status' => "0"), array('BMReceiveRequest.id' => $val));
            if ($success) {
                $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert="">
                            <a href="#" class="uk-alert-close uk-close"></a>Request Deleted. !!!</div>');
            } else {
                $this->Session->setFlash('<div class="uk-alert uk-alert-primery" data-uk-alert="">
            <a href="#" class="uk-alert-close uk-close"></a>Request Not Deleted. !!!</div>');
            }
            $this->redirect("req_receive");
        }

        if (isset($this->request->data['submit'])) {

            $data['BMReceiveRequest']['id'] = $this->request->data['reqID'];
            $data['BMReceiveRequest']['request_type_id'] = $this->request->data['req_cat'];
            $data['BMReceiveRequest']['dept_code'] = $this->request->data['department'];
            $data['BMReceiveRequest']['action_officer_id'] = $this->request->data['act_off'];
            $data['BMReceiveRequest']['signatory_name'] = $this->request->data['signatory'];
            $data['BMReceiveRequest']['reference_num'] = $this->request->data['refnum'];
            $data['BMReceiveRequest']['subject'] = $this->request->data['subject'];
            $data['BMReceiveRequest']['date_of_request'] = date('Y-m-d', strtotime($this->request->data['doreq']));
            $data['BMReceiveRequest']['date_of_receive'] = date('Y-m-d', strtotime($this->request->data['dorec']));
            $data['BMReceiveRequest']['created_by'] = $empID;

            $success = $this->BMReceiveRequest->save($data);

            if ($success) {
                $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
            <a href="#" class="uk-alert-close uk-close"></a>Request Modified Succesfully. !!!</div>');
                $this->redirect("req_receive");
            } else {
                $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert="">
            <a href="#" class="uk-alert-close uk-close"></a>Request Not Modify Succesfully. !!!</div>');
                $this->redirect("req_receive");
            }
        }

        $reqData = $this->BMReceiveRequest->find('all', array(
            'conditions' => array('BMReceiveRequest.id' => $val, 'BMReceiveRequest.status' => '1')
        ));


        $department = $this->Departments->find('list', array(
            'fields' => array('Departments.dept_code', 'Departments.dept_name'),
            'conditions' => array('Departments.status' => '1')
        ));

        $RequestType = $this->MstRequest->find('list', array(
            'fields' => array('MstRequest.id', 'MstRequest.req_type_name'),
            'conditions' => array('MstRequest.status' => '1')
        ));
        $signatory = $this->MstSignatory->find('all', array(
            'conditions' => array('MstSignatory.status' => '1')
        ));
        foreach ($signatory as $semp) {

            $sig[] = $semp['MstSignatory']['signatory_name'];
        }
        $signatoryID = implode(",", $sig);
        if ($signatoryID != '') {
            $Dept_Signatory = $this->MyProfile->find('list', array(
                'fields' => array('id', 'emp_full_name'),
                'conditions' => array('emp_code in (' . $signatoryID . ')')
            ));
        }

        $ActionOfficer = $this->MyProfile->find('list', array(
            'fields' => array('id', 'emp_full_name')
        ));


        $this->set(compact("RequestType", "department", 'Dept_Signatory', 'reqData', 'ActionOfficer'));
    }

    public function req_forward() {
        $this->layout = 'employee-new';
        $auth = $this->Session->read('Auth');
        $empID = $auth['MyProfile']['id'];
//
//        if ($empID == '183') {
//            $condition = array('status' => '1', 'forward_to !=' => '0');
//        }

        $condition = array('BMReceiveRequest.status' => '1', 'BMReceiveRequestForward.req_forward_by' => $empID);
        $allRecReq = $this->BMReceiveRequest->find('all', array(
            'conditions' => $condition,
            'group'=>'BMReceiveRequestForward.request_receive_id',
			'order' => 'BMReceiveRequest.id desc'
            
        ));
//        echo "<pre>";
//        print_r($allRecReq);die;
        $this->set("allRecReq", $allRecReq);
    }

    public function req_forward_save() {
        //Configure::write('debug',2);
        $this->layout = 'employee-new';
        $auth = $this->Session->read('Auth');
        $empID = $auth['MyProfile']['id'];

        if (isset($this->request->data['submit'])) {

            $reqID = $this->request->data['req_id'];
			$remark = $this->request->data['remark'];
            $Frwrd_act_off = $this->request->data['act_off'];
//            $MatchingUser = $this->BMReceiveRequest->find('first', array(
//                'fields' => array('created_by'),
//                'conditions' => array('BMReceiveRequest.id' => $reqID, 'BMReceiveRequest.status' => '1')
//            ));
            //print_r($MatchingUser);
            //echo ",".$MatchingUser['BMReceiveRequest']['created_by'];die;
            if ($empID == $Frwrd_act_off) {
                $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert="">
            <a href="#" class="uk-alert-close uk-close"></a>Sorry, this request is raised by forwarded action officer !!!</div>');
                $this->redirect("req_forward_save");
            }

            $successUpdate = $this->BMReceiveRequest->updateAll(array('BMReceiveRequestForward.frwd_status' => '1'), array('BMReceiveRequestForward.request_receive_id' => $reqID, 'BMReceiveRequestForward.frwd_status' => '0'));


            $data['BMReceiveRequestForward']['request_receive_id'] = $reqID;
            $data['BMReceiveRequestForward']['req_receive_by'] = $Frwrd_act_off;
            $data['BMReceiveRequestForward']['req_forward_by'] = $empID;
			$data['BMReceiveRequestForward']['remark'] = $remark;

            $this->BMReceiveRequestForward->create();
            $success = $this->BMReceiveRequestForward->save($data);
//             echo "<pre>";
//print_r($this->request->data);die;
            if ($success) {
                $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
            <a href="#" class="uk-alert-close uk-close"></a>Request forwarded succesfully !!!</div>');
            } else {
                $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert="">
            <a href="#" class="uk-alert-close uk-close"></a>Request is not forwarded  !!!</div>');
            }
            $this->redirect("req_forward");
        }


//        $RefNum = $this->BMReceiveRequest->find('list', array(
//            'fields' => array('id', 'reference_num'),
//            'conditions' => array('forward_to' => '0', 'status' => '1', 'final_status' => '0')
//        ));

        $RefNum = $this->BMReceiveRequest->find('all', array(
            'fields' => array('BMReceiveRequest.id', 'BMReceiveRequest.reference_num'),
            'conditions' => array('BMReceiveRequestForward.req_receive_by' => $empID, $cond, 'BMReceiveRequest.status' => '1', 'BMReceiveRequestForward.frwd_status' => '0')));

//        echo "<pre>";
//        print_r($RefNum);die;


        $RequestType = $this->MstRequest->find('list', array(
            'fields' => array('MstRequest.id', 'MstRequest.req_type_name'),
            'conditions' => array('MstRequest.status' => '1')
        ));

        $department = $this->Departments->find('list', array(
            'fields' => array('Departments.dept_code', 'Departments.dept_name'),
            'conditions' => array('Departments.status' => '1')
        ));
        $this->set(compact('RequestType', 'RefNum', 'department'));
    }

    public function frwrd_fields($reqID = null) {
        $ReceivReq = $this->BMReceiveRequest->find('all', array(
            'conditions' => array('id' => $reqID, 'status' => '1')
        ));

        $this->set(compact('ReceivReq', 'reqID'));
    }

    public function data_type($CTid = null, $DelVal = null) {
        //Configure::write('debug',2);
        $this->layout = 'employee-new';
        $auth = $this->Session->read('Auth');

        if (isset($this->request->data['submit']) && $this->request->data['submit'] != '') {

            if (isset($this->request->data['ctid']) && $this->request->data['ctid'] != '') {
                $data = $this->request->data['courttype'];
                $success = $this->DataType->updateAll(array('datatype' => "'$data'"), array('id' => $this->request->data['ctid']));
            } else {
                $data['datatype'] = $this->request->data['courttype'];
                $success = $this->DataType->save($data);
            }

            if ($success) {
                $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                <a href="#" class="uk-alert-close uk-close"></a>Data Type Entered Successfully!</div>');
            } else {
                $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert="">
                <a href="#" class="uk-alert-close uk-close"></a>Sorry, Data Type Not Entered !</div>');
            }
            $this->redirect('data_type');
        }


        if ($CTid != null && $DelVal == null) {
            $EditData = $this->DataType->find('all', array('conditions' => array('id' => $CTid, 'status' => '0')));
            $create = "enable";
            $this->set(compact('EditData', 'CTid', 'create'));
        } elseif ($CTid != null && $DelVal != null) {
            $Updsuccess = $this->DataType->updateAll(array('status' => '1'), array('id' => $CTid));
            if ($Updsuccess) {
                $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert="">
                <a href="#" class="uk-alert-close uk-close"></a>Data Type Deleted !</div>');
            }
            //$this->redirect('data_type');
        }
       // $data = $this->DataType->find('all', array('conditions' => array('status' => '0')));
		
		$this->paginate = array('limit' => 10,'conditions' => array('status' => '0'),'order'=> '`datatype` ASC');

        $data = $this->paginate('DataType');
		
		//$data = $this->paginate('data');
        $this->set('data', $data);
    }

    public function data_type_details() {
       // Configure::write('debug',2);
        $this->layout = 'employee-new';
        $auth = $this->Session->read('Auth');
        $empID = $auth['MyProfile']['id'];

        if (isset($this->request->data['submit']) && $this->request->data['submit'] != '') {
          // echo "<pre>";
          // print_r($this->request->data);//die;
		    $cnt=count($this->request->data['seriNum']);
            
            for ($i = 0; $i < $cnt; $i++) {

				$data['BMDataTypeDetails']['serial_num'] = $this->request->data['seriNum'][$i];
				$data['BMDataTypeDetails']['data_type_id'] = $this->request->data['data_type_id'];
				$data['BMDataTypeDetails']['id_no'] = $this->request->data['id_no'][$i];
				$data['BMDataTypeDetails']['p_no'] = $this->request->data['p_no'][$i];
				$data['BMDataTypeDetails']['title'] = $this->request->data['title'][$i];
				$data['BMDataTypeDetails']['surname'] = $this->request->data['surname'][$i];
				$data['BMDataTypeDetails']['firstname'] = $this->request->data['firstname'][$i];
				$data['BMDataTypeDetails']['other_name'] = $this->request->data['other_name'][$i];
				$data['BMDataTypeDetails']['dob'] = date("Y-m-d", strtotime($this->request->data['dob'][$i]));
				$data['BMDataTypeDetails']['gender'] = $this->request->data['gender'][$i];
				$data['BMDataTypeDetails']['qualification'] = $this->request->data['qualification'][$i];
				$data['BMDataTypeDetails']['promotion_type'] = $this->request->data['promotype'[$i]];
				$data['BMDataTypeDetails']['secondment_transfer_id'] = $this->request->data['secondment'][$i];
				$data['BMDataTypeDetails']['retirement_ground_id'] = $this->request->data['ret_ground'][$i];
				$data['BMDataTypeDetails']['academic'] = $this->request->data['acad'][$i];
				$data['BMDataTypeDetails']['professional'] = $this->request->data['prof'][$i];
				$data['BMDataTypeDetails']['experience'] = $this->request->data['exp'][$i];
				$data['BMDataTypeDetails']['physical_disability'] = $this->request->data['ph_disa'][$i];
				$data['BMDataTypeDetails']['disable_details'] = $this->request->data['disabl_det'][$i];
				$data['BMDataTypeDetails']['ministry_id'] = $this->request->data['ministry'][$i];
				$data['BMDataTypeDetails']['department_code'] = $this->request->data['department'][$i];
				$data['BMDataTypeDetails']['d_o_appointment'] = date("Y-m-d", strtotime($this->request->data['doa'][$i]));
				$data['BMDataTypeDetails']['d_o_c_appointment'] = date("Y-m-d", strtotime($this->request->data['doca'][$i]));
				$data['BMDataTypeDetails']['currenct_designation'] = $this->request->data['curr_desig'][$i];
				$data['BMDataTypeDetails']['recommended_designation'] = $this->request->data['recomm_desig'][$i];
				$data['BMDataTypeDetails']['recomm_term_services'] = $this->request->data['recomm_t_serv'][$i];
				$data['BMDataTypeDetails']['justification'] = $this->request->data['justification'][$i];
				$data['BMDataTypeDetails']['notes'] = $this->request->data['notes'][$i];
				$data['BMDataTypeDetails']['created_by'] = $empID;
				
				$this->BMDataTypeDetails->create();
				$success = $this->BMDataTypeDetails->save($data);
			}

            if ($success) {
                $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                    <a href="#" class="uk-alert-close uk-close"></a>Details entered successfully !</div>');
            } else {
                $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert="">
                    <a href="#" class="uk-alert-close uk-close"></a>Sorry, Details Not Entered !</div>');
            }
            $this->redirect('data_type_detail_list');
        }
        $DataType = $this->DataType->find('list', array(
            'fields' => array('id', 'datatype'),
            'conditions' => array('status' => '0'),
			'order'=> '`datatype` ASC'
        ));



        $this->set(compact('DataType'));
    }

    public function data_type_details_edit($id = null, $val = null, $del = null) {
        //Configure::write('debug',2);
        $this->layout = 'employee-new';
        $auth = $this->Session->read('Auth');
        $empID = $auth['MyProfile']['id'];

        if ($del != '' && $del == "del") {
            $success = $this->BMDataTypeDetails->updateAll(array('status' => "1"), array('id' => $id));
            if ($success) {
                $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert="">
            <a href="#" class="uk-alert-close uk-close"></a>Data Type Details Deleted. !!!</div>');
            } else {
                $this->Session->setFlash('<div class="uk-alert uk-alert-primery" data-uk-alert="">
            <a href="#" class="uk-alert-close uk-close"></a>Data Type Details Not Deleted. !!!</div>');
            }
            $this->redirect("data_type_detail_list/" . $val);
        }

        if (isset($this->request->data['submit']) && $this->request->data['submit'] != '') {

            $data['BMDataTypeDetails']['id'] = $this->request->data['rec_id'];
            $data['BMDataTypeDetails']['serial_num'] = $this->request->data['seriNum'];
            $data['BMDataTypeDetails']['data_type_id'] = $this->request->data['data_type_id'];
            $data['BMDataTypeDetails']['id_no'] = $this->request->data['id_no'];
            $data['BMDataTypeDetails']['p_no'] = $this->request->data['p_no'];
            $data['BMDataTypeDetails']['title'] = $this->request->data['title'];
            $data['BMDataTypeDetails']['surname'] = $this->request->data['surname'];
            $data['BMDataTypeDetails']['firstname'] = $this->request->data['firstname'];
            $data['BMDataTypeDetails']['other_name'] = $this->request->data['other_name'];
            $data['BMDataTypeDetails']['dob'] = date("Y-m-d", strtotime($this->request->data['dob']));
            $data['BMDataTypeDetails']['gender'] = $this->request->data['gender'];
            $data['BMDataTypeDetails']['qualification'] = $this->request->data['qualification'];
            $data['BMDataTypeDetails']['promotion_type'] = $this->request->data['promotype'];
            $data['BMDataTypeDetails']['secondment_transfer_id'] = $this->request->data['secondment'];
            $data['BMDataTypeDetails']['retirement_ground_id'] = $this->request->data['ret_ground'];
            $data['BMDataTypeDetails']['academic'] = $this->request->data['acad'];
            $data['BMDataTypeDetails']['professional'] = $this->request->data['prof'];
            $data['BMDataTypeDetails']['experience'] = $this->request->data['exp'];
            $data['BMDataTypeDetails']['physical_disability'] = $this->request->data['doc']['ph_disa'];
            $data['BMDataTypeDetails']['disable_details'] = $this->request->data['disabl_det'];
            $data['BMDataTypeDetails']['ministry_id'] = $this->request->data['ministry'];
            $data['BMDataTypeDetails']['department_code'] = $this->request->data['department'];
            $data['BMDataTypeDetails']['d_o_appointment'] = date("Y-m-d", strtotime($this->request->data['doa']));
            $data['BMDataTypeDetails']['d_o_c_appointment'] = date("Y-m-d", strtotime($this->request->data['doca']));
            $data['BMDataTypeDetails']['currenct_designation'] = $this->request->data['curr_desig'];
            $data['BMDataTypeDetails']['recommended_designation'] = $this->request->data['recomm_desig'];
            $data['BMDataTypeDetails']['recomm_term_services'] = $this->request->data['recomm_t_serv'];
            $data['BMDataTypeDetails']['justification'] = $this->request->data['justification'];
            $data['BMDataTypeDetails']['notes'] = $this->request->data['notes'];
            $data['BMDataTypeDetails']['created_by'] = $empID;

            $success = $this->BMDataTypeDetails->save($data);

            if ($success) {
                $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                    <a href="#" class="uk-alert-close uk-close"></a>Details Modified successfully !</div>');
            } else {
                $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert="">
                    <a href="#" class="uk-alert-close uk-close"></a>Sorry, Details Not Modified !</div>');
            }
            $this->redirect('data_type_detail_list/' . $this->request->data['data_type_id']);
        }


        $Record = $this->BMDataTypeDetails->find('first', array('conditions' => array('status' => '0', 'id' => $id)));
        $title = $this->BMTitle->find('list', array('fields' => 'title',
            'conditions' => array('status' => '0')));
        $Ministry = $this->Ministry->find('list', array('fields' => 'ministry_name',
            'conditions' => array('ministry_status' => '1')));
        array_unshift($Ministry, '--Select--');

        $this->set(compact('DataType', 'val', 'Record', 'title', 'Ministry'));
    }

    public function data_type_details_form($val) {
        Configure::write('debug',2);
        // $this->layout = 'employee-new';
        $auth = $this->Session->read('Auth');

        $SeriNum = $this->randNumber();
        $title = $this->BMTitle->find('list', array('fields' => 'title',
            'conditions' => array('status' => '0')));
        $Ministry = $this->Ministry->find('list', array('fields' => 'ministry_name',
            'conditions' => array('ministry_status' => '1')));
        array_unshift($Ministry, '--Select--');

        $this->set(compact('SeriNum', 'Ministry', 'val', 'title'));
    }

    public function data_type_detail_list($val = null) {
        //Configure::write('debug',2);
        $this->layout = 'employee-new';
        $auth = $this->Session->read('Auth');


        $DataType = $this->DataType->find('list', array(
            'fields' => array('id', 'datatype'),
            'conditions' => array('status' => '0')
        ));
        array_unshift($DataType, '--Select--');
        unset($DataType[1]);

        if ($val != null) {

            $DataDetailsList = $this->BMDataTypeDetails->find('all', array('conditions' => array('status' => '0', 'data_type_id' => $val)));
            $Data_Type_Name = $this->DataType->find('first', array('conditions' => array('status' => '0', 'id' => $val)));
            $DataTypeName = $Data_Type_Name['DataType']['datatype'];
            $this->paginate = array(
                'conditions' => array('BMDataTypeDetails.status' => '0', 'BMDataTypeDetails.data_type_id' => $val),
                'limit' => 10,
                'order' => array(
                    'BMDataTypeDetails.id' => 'desc'
                )
            );

            $this->set('dtlist', $this->paginate($this->BMDataTypeDetails));
        }


        $this->set(compact('DataType', 'DataDetailsList', 'DataTypeName'));
    }

    public function recrut_final() {
        //Configure::write('debug',2);
        $this->layout = 'employee-new';
        $auth = $this->Session->read('Auth');



        $this->paginate = array(
            'conditions' => array('BMRecrutFinal.status' => '1'),
            'limit' => 10,
            'order' => array(
                'BMRecrutFinal.id' => 'desc'
            )
        );



        $this->set('RFlist', $this->paginate($this->BMRecrutFinal));
    }

    public function recrut_final_save() {
        //Configure::write('debug',2);
        $this->layout = 'employee-new';
        $auth = $this->Session->read('Auth');
        $empID = $auth['MyProfile']['id'];

        if (isset($this->request->data['submit']) && $this->request->data['submit'] != '') {


            $data['BMRecrutFinal']['serial_num'] = $this->request->data['seriNum'];
            $data['BMRecrutFinal']['request_type_id'] = $this->request->data['req_type_id'];
            $data['BMRecrutFinal']['date_of_received'] = date("Y-m-d", strtotime($this->request->data['dor']));
            $data['BMRecrutFinal']['num_of_candidates'] = $this->request->data['candidate_num'];
            $data['BMRecrutFinal']['subject'] = $this->request->data['subject'];
            $data['BMRecrutFinal']['notes'] = $this->request->data['notes'];
            $data['BMRecrutFinal']['created_by'] = $empID;

            $success = $this->BMRecrutFinal->save($data);

            if ($success) {
                $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                    <a href="#" class="uk-alert-close uk-close"></a>Record Submited Successfully !</div>');
            } else {
                $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert="">
                    <a href="#" class="uk-alert-close uk-close"></a>Sorry, Record Not Submited !</div>');
            }
            $this->redirect('recrut_final');
        }



        $SeriNum = $this->randNumber();
        $RequestType = $this->MstRequest->find('list', array(
            'fields' => array('MstRequest.id', 'MstRequest.req_type_name'),
            'conditions' => array('MstRequest.status' => '1')
        ));

        $this->set(compact('SeriNum', 'RequestType'));
    }

    public function recrut_final_edit($id = null, $del = null) {
        //Configure::write('debug',2);
        $this->layout = 'employee-new';
        $auth = $this->Session->read('Auth');


        if ($del != '' && $del == "del") {
            $success = $this->BMRecrutFinal->updateAll(array('status' => "0"), array('id' => $id));
            if ($success) {
                $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert="">
            <a href="#" class="uk-alert-close uk-close"></a>Record Deleted. !!!</div>');
            } else {
                $this->Session->setFlash('<div class="uk-alert uk-alert-primery" data-uk-alert="">
            <a href="#" class="uk-alert-close uk-close"></a>Record Not Deleted. !!!</div>');
            }
            $this->redirect("recrut_final/" . $val);
        }
        if (isset($this->request->data['submit']) && $this->request->data['submit'] != '') {

            $data['BMRecrutFinal']['id'] = $this->request->data['rf_id'];
            $data['BMRecrutFinal']['serial_num'] = $this->request->data['seriNum'];
            $data['BMRecrutFinal']['request_type_id'] = $this->request->data['req_type_id'];
            $data['BMRecrutFinal']['date_of_received'] = date("Y-m-d", strtotime($this->request->data['dor']));
            $data['BMRecrutFinal']['num_of_candidates'] = $this->request->data['candidate_num'];
            $data['BMRecrutFinal']['subject'] = $this->request->data['subject'];
            $data['BMRecrutFinal']['notes'] = $this->request->data['notes'];
            $data['BMRecrutFinal']['created_by'] = $empID;

            $success = $this->BMRecrutFinal->save($data);

            if ($success) {
                $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                    <a href="#" class="uk-alert-close uk-close"></a>Record Modified Successfully !</div>');
            } else {
                $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert="">
                    <a href="#" class="uk-alert-close uk-close"></a>Sorry, Record Not Modified !</div>');
            }
            $this->redirect('recrut_final');
        }

        $RF_record = $this->BMRecrutFinal->find('all', array('conditions' => array('status' => '1', 'id' => $id)));
        $RequestType = $this->MstRequest->find('list', array(
            'fields' => array('MstRequest.id', 'MstRequest.req_type_name'),
            'conditions' => array('MstRequest.status' => '1')
        ));
        $this->set(compact('RF_record', 'RequestType'));
    }

    public function bm_reports() {
        //Configure::write('debug',2);
        $this->layout = 'employee-new';
        $auth = $this->Session->read('Auth');


        $flag = '';
        if (isset($this->request->data['submit']) && $this->request->data['submit'] != '') {
            if ($this->request->data['meet_num'] == '' && $this->request->data['depart'] == '' && $this->request->data['meet_from_date'] == '' && $this->request->data['meet_to_date'] == '' && $this->request->data['req_from_date'] == '' && $this->request->data['req_to_date'] == '' && $this->request->data['req_receive'] == '') {
                $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert="">
                            <a href="#" class="uk-alert-close uk-close"></a>Please Enter Atleast One Value !!!!</div>');
                $this->redirect('bm_reports');
            }

            if ($this->request->data['meet_num'] != '') {
                $ORconditions['BMMeetingRequestRefnum.meeting_request_id'] = $this->request->data['meet_num'];
                $meet_num = $this->request->data['meet_num'];
            }
            if ($this->request->data['depart'] != '') {
                $ORconditions['BMReceiveRequest.dept_code'] = $this->request->data['depart'];
                $depart = $this->request->data['depart'];
            }
            if ($this->request->data['meet_from_date'] != '' && $this->request->data['meet_to_date'] != '') {

                $meet_from_date = date('Y-m-d', strtotime($this->request->data['meet_from_date']));
                $meet_to_date = date('Y-m-d', strtotime($this->request->data['meet_to_date']));
                $ORconditions1['BMMeetingRequest.meeting_date between ? and ?'] = array($meet_from_date, $meet_to_date);
            }
            if ($this->request->data['req_from_date'] != '' && $this->request->data['req_to_date'] != '') {
                $req_from_date = date('Y-m-d', strtotime($this->request->data['req_from_date']));
                $req_to_date = date('Y-m-d', strtotime($this->request->data['req_to_date']));
                $ORconditions2['BMReceiveRequest.date_of_receive between ? and ?'] = array($req_from_date, $req_to_date);
            }
            if ($this->request->data['req_receive'] != '') {
                $ORconditions3['BMReceiveRequest.id'] = $this->request->data['req_receive'];
                $req_receive = $this->request->data['req_receive'];
            }

            $conditions = array('BMMeetingRequestRefnum.status' => '0',
                'OR' => array($ORconditions1, $ORconditions2, $ORconditions3, $ORconditions)
            );

            $Meeting_Request_Refnum = $this->BMMeetingRequestRefnum->find('all', array('conditions' => $conditions));
//            echo "<pre>";
//            print_r($Meeting_Request_Refnum);die;
            if ($Meeting_Request_Refnum) {
                $flag = 'open';
                $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                            <a href="#" class="uk-alert-close uk-close"></a>Report Generated Successfully !!!!</div>');
            } else {
                $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert="">
                            <a href="#" class="uk-alert-close uk-close"></a>Sorry, there is no record found !!!!</div>');
            }


            $this->set(compact('Meeting_Request_Refnum', 'flag', 'meet_num', 'depart', 'meet_from_date', 'meet_to_date', 'req_from_date', 'req_to_date', 'req_receive'));
        }

        $Meetinglist = $this->BMMeetingRequest->find('list', array('fields' => 'meeting_number'), array('conditions' => array('BMMeetingRequest.status' => '0')));
        array_unshift($Meetinglist, '---Select---');

        $reqRef = $this->BMReceiveRequest->find('list', array(
            'fields' => array('id', 'reference_num'),
            'conditions' => array('status' => '1')
        ));
        array_unshift($reqRef, '---Select---');


        $this->set(compact('Meetinglist', 'reqRef'));
    }

    public function bm_reports_sec() {
        //Configure::write('debug',2);
        $this->layout = 'employee-new';
        $auth = $this->Session->read('Auth');


        $flag = '';
        if (isset($this->request->data['submit']) && $this->request->data['submit'] != '') {
            if ($this->request->data['ministry'] == '' && $this->request->data['depart'] == '' && $this->request->data['meet_from_date'] == '' && $this->request->data['meet_to_date'] == '' && $this->request->data['action_officer'] == '') {
                $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert="">
                            <a href="#" class="uk-alert-close uk-close"></a>Please Enter Atleast One Value !!!!</div>');
                $this->redirect('bm_reports_sec');
            }


            if ($this->request->data['ministry'] != '') {
                $ORconditions['BMRequestDetails.ministry_id'] = $this->request->data['ministry'];
                $ministry = $this->request->data['ministry'];
            }
            if ($this->request->data['depart'] != '') {
                $ORconditions1['BMReceiveRequest.dept_code'] = $this->request->data['depart'];
                $depart = $this->request->data['depart'];
            }
            if ($this->request->data['meet_from_date'] != '' && $this->request->data['meet_to_date'] != '') {

                $meet_from_date = date('Y-m-d', strtotime($this->request->data['meet_from_date']));
                $meet_to_date = date('Y-m-d', strtotime($this->request->data['meet_to_date']));
                $ORconditions2['BMMeetingRequest.meeting_date between ? and ?'] = array($meet_from_date, $meet_to_date);
            }

            if ($this->request->data['action_officer'] != '') {
                //$ORconditions3['BMReceiveRequest.action_officer_id'] = $this->request->data['action_officer'];
                $ORconditions3['BMReceiveRequestForward.req_receive_by'] = $this->request->data['action_officer'];
                $action_officer = $this->request->data['action_officer'];
            }

            $conditions = array('BMMeetingRequestRefnum.status' => '0',
                'OR' => array($ORconditions1, $ORconditions2, $ORconditions3, $ORconditions)
            );

            $Meeting_Request_Refnum = $this->BMMeetingRequestRefnum->find('all', array('conditions' => $conditions));
            
            $TotalReq = count($Meeting_Request_Refnum);
            $count_Final = 0;
            foreach($Meeting_Request_Refnum as $rec){
                if($rec['BMMeetingRequestRefnum']['finalize_status']=='1'){
                    $count_Final++; 
                }
            }
            $Pending=$TotalReq-$count_Final;
//            echo "<pre>";
//            print_r($Meeting_Request_Refnum);die;
            if ($Meeting_Request_Refnum) {
                $flag = 'open';
                $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                            <a href="#" class="uk-alert-close uk-close"></a>Report Generated Successfully !!!!</div>');
            } else {
                $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert="">
                            <a href="#" class="uk-alert-close uk-close"></a>Sorry, there is no record found !!!!</div>');
            }


            $this->set(compact('TotalReq','count_Final','Pending','Meeting_Request_Refnum', 'flag', 'ministry', 'depart', 'meet_from_date', 'meet_to_date', 'action_officer'));
        }

        $Ministry = $this->Ministry->find('list', array('fields' => 'ministry_name',
            'conditions' => array('ministry_status' => '1')));
        array_unshift($Ministry, '---Select---');

        $ActionOfficer = $this->MyProfile->find('list', array(
            'fields' => array('id', 'emp_full_name')
        ));
        array_unshift($ActionOfficer, '---Select---');
//            echo "<pre>";
//            print_r($Ministry);die;

        $this->set(compact('Ministry', 'ActionOfficer'));
    }

    public function dept_employee($deptId) {
        //Configure::write('debug',2);
        $this->layout = 'employee-new';
        $comp_code = $this->Auth->user('comp_code');

        if (!empty($deptId)) {
            $departmentId = base64_decode($deptId);
        }
        //echo $departmentId; die;
        $profile = $this->MyProfile->find('all', array(
            'conditions' => array(
                'dept_code' => "$departmentId",
                'comp_code' => $comp_code,
                'status'=>32
            )
        ));
        //print_r($profile); die;
        $this->set("profile", $profile);
        $this->set("departmentId", $departmentId);
    }

    public function generate_bm_report_pdf($meet_num = null, $depart = null, $meet_from_date = null, $meet_to_date = null, $req_from_date = null, $req_to_date = null, $req_receive = null) {
        //Configure::write('debug', 2);
        $this->layout = 'employee-new';
        $auth = $this->Session->read('Auth');

        if ($meet_num == 'null') {
            $meet_num = null;
        }
        if ($depart == 'null') {
            $depart = null;
        }
        if ($meet_from_date == 'null' && $meet_to_date == 'null') {
            $meet_from_date = null;
            $meet_to_date = null;
        }
        if ($req_from_date == 'null' && $req_to_date == 'null') {
            $req_from_date = null;
            $req_to_date = null;
        }
        if ($req_receive == 'null') {
            $req_receive = null;
        }

        if ($meet_num != '') {
            $ORconditions['BMMeetingRequestRefnum.meeting_request_id'] = $meet_num;
        }
        if ($depart != '') {
            $ORconditions['BMReceiveRequest.dept_code'] = $depart;
        }
        if ($meet_from_date != '' && $meet_to_date != '') {
            $ORconditions1['BMMeetingRequest.meeting_date between ? and ?'] = array($meet_from_date, $meet_to_date);
        }
        if ($req_from_date != '' && $req_to_date != '') {
            $ORconditions2['BMReceiveRequest.date_of_receive between ? and ?'] = array($req_from_date, $req_to_date);
        }
        if ($req_receive != '') {
            $ORconditions3['BMReceiveRequest.id'] = $req_receive;
        }

        $conditions = array('BMMeetingRequestRefnum.status' => '0',
            'OR' => array($ORconditions1, $ORconditions2, $ORconditions3, $ORconditions)
        );

        $Meeting_Request_Refnum = $this->BMMeetingRequestRefnum->find('all', array('conditions' => $conditions));

        App::import('Vendor', 'TCpdf', array('file' => 'mpdf60/mpdf.php'));
        $this->layout = 'pdf';
        $this->set('pdf', new mPDF('utf-8', array(350, 500)));
        $this->set('Meeting_Request_Refnum', $Meeting_Request_Refnum);
    }

    public function generate_bm_report_sec_pdf($ministry = null, $depart = null, $meet_from_date = null, $meet_to_date = null, $action_officer = null) {
        //Configure::write('debug', 2);
        $this->layout = 'employee-new';
        $auth = $this->Session->read('Auth');

        if ($ministry == 'null') {
            $ministry = null;
        }
        if ($depart == 'null') {
            $depart = null;
        }
        if ($meet_from_date == 'null' && $meet_to_date == 'null') {
            $meet_from_date = null;
            $meet_to_date = null;
        }
        if ($action_officer == 'null') {
            $action_officer = null;
        }

        if ($ministry != '') {
            $ORconditions['BMRequestDetails.ministry_id'] = $ministry;
        }
        if ($depart != '') {
            $ORconditions2['BMReceiveRequest.dept_code'] = $depart;
        }
        if ($meet_from_date != '' && $meet_to_date != '') {
            $ORconditions1['BMMeetingRequest.meeting_date between ? and ?'] = array($meet_from_date, $meet_to_date);
        }
        if ($action_officer != '') {
            //$ORconditions3['BMReceiveRequest.action_officer_id'] = $action_officer;
            $ORconditions3['BMReceiveRequestForward.req_receive_by'] = $action_officer;
        }

        $conditions = array('BMMeetingRequestRefnum.status' => '0',
            'OR' => array($ORconditions1, $ORconditions2, $ORconditions3, $ORconditions)
        );

        $Meeting_Request_Refnum = $this->BMMeetingRequestRefnum->find('all', array('conditions' => $conditions));
        $TotalReq = count($Meeting_Request_Refnum);
            $count_Final = 0;
            foreach($Meeting_Request_Refnum as $rec){
                if($rec['BMMeetingRequestRefnum']['finalize_status']=='1'){
                    $count_Final++; 
                }
            }
            $Pending=$TotalReq-$count_Final;
        App::import('Vendor', 'TCpdf', array('file' => 'mpdf60/mpdf.php'));
        $this->layout = 'pdf';
        $this->set('pdf', new mPDF('utf-8', array(350, 500)));
        $this->set('Meeting_Request_Refnum', $Meeting_Request_Refnum);
        $this->set('TotalReq', $TotalReq);
        $this->set('count_Final', $count_Final);
        $this->set('Pending', $Pending);
    }

    public function employeelist($deptCode) {
        if ($deptCode) {
            $employee_name = $this->MyProfile->find('list', array('fields' => array('emp_code', 'emp_name'),
                'conditions' => array('dept_code' => $deptCode),
                'order' => array('MyProfile.emp_name' => 'ASC')
            ));
            return $employee_name;
        }
    }
    
    public function report_type_attach() {
       // Configure::write('debug',2);
        $this->layout = 'employee-new';
        $auth = $this->Session->read('Auth');
        //echo date("d-m-Y His");die;
        //$this->CaseReceive->recursive = -2;
        //$CaseReceive = $this->BMReportTypeAttachment->find('first',array('conditions' => array('CaseReceive.id' =>$caseID)));
        $Repot_attach = $this->BMReportTypeAttachment->find('all',array('conditions' => array('BMReportTypeAttachment.status' =>'0')));
        
        $this->paginate = array(
            'conditions' => array('BMReportTypeAttachment.status'=>'0'),
            'limit' => 4,
            'order' => array(
                'BMReportTypeAttachment.id' => 'desc'
            )
        );
        
        
            
        
        $this->set('ar', $this->paginate($this->BMReportTypeAttachment));
        $this->set(compact('Repot_attach'));
    }
    
    public function report_type_attach_save() {
        //Configure::write('debug',2);
        $this->layout = 'employee-new';
        $auth = $this->Session->read('Auth');
        
        if(isset($this->request->data['submit']) && $this->request->data['submit']!=''){
               
                
            $DataTypeName = $this->DataType->find('first', array('fields' => array('datatype'),
                'conditions' => array('status' => '0','id'=>$this->request->data['data_type']),
            ));  
//                echo "<pre>";
//                print_r($this->request->data);die;
            $UPLOAD_FILES=$this->request->data['upl_doc'];
            
            $data['BMReportTypeAttachment']['data_type_id']        =   $this->request->data['data_type'];
            $data['BMReportTypeAttachment']['remark']              =   $this->request->data['remark'] ;
            $data['BMReportTypeAttachment']['created_by']          =   $auth['MyProfile']['id'];
           
            $success = $this->BMReportTypeAttachment->save($data);
            $ReportAttachID = $this->BMReportTypeAttachment->getLastInsertID();
            
            $invl='0';
            if($success){
                if(!empty($UPLOAD_FILES)){
                    $DirName = $DataTypeName['DataType']['datatype'];
                    $Dir = WWW_ROOT .'bom';
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
                           
                            if(!($ext == 'pdf' || $ext == 'jpg' || $ext == 'png' || $ext == 'txt' || $ext == 'wmv' || $ext == 'doc' || $ext == 'docx') || ($file_up['size'] > 2048000) ){
                                $InvalidFiles .= $file_up['name'].",";
                                $invl='1';
                            }else{
                                if(move_uploaded_file($file_up['tmp_name'],$FILE_PATH)){
                                    //$caseID=$this->request->data['caseid'];
                                    $File_Data['BMReportTypeAttachFiles']['report_type_attach_id'] = $ReportAttachID;
                                    $File_Data['BMReportTypeAttachFiles']['attach_file'] = $FILE_NAME;
                                    $File_Data['BMReportTypeAttachFiles']['folder_name'] = $DirName;
                                    $this->BMReportTypeAttachFiles->create(); 
                                    $success_upld = $this->BMReportTypeAttachFiles->save($File_Data); 
                                } 
                            }
                        }
                    }
                }
            }
                if($invl=='0'){
                    $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                            <a href="#" class="uk-alert-close uk-close"></a>File Attached Successfully !</div>');
                
                }else{
                     $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                            <a href="#" class="uk-alert-close uk-close"></a>File Attached Successfully, This is invalid file [<font color='.red.'>'.$InvalidFiles.'</font>] Only !</div>');   
                
                }
                $this->redirect('report_type_attach');
        }
        
        $DataTypeList = $this->DataType->find('list', array('fields' => array('id', 'datatype'),
                'conditions' => array('status' => '0'),
                'order' => array('id' => 'ASC')
            ));
         array_unshift($DataTypeList, '--Select--');
        
        
        $this->set(compact('DataTypeList'));
    }
    
    public function report_type_attach_update($ReportAttachID=null,$DetailDel=null) {
        //Configure::write('debug',2);
        $this->layout = 'employee-new';
        $auth = $this->Session->read('Auth');
        
        
        if($DetailDel!='' && $DetailDel=='del'){
            $Delsuccess = $this->BMReportTypeAttachment->updateAll(array('BMReportTypeAttachment.status'=>'1'), array('BMReportTypeAttachment.id' => $ReportAttachID));
            if($Delsuccess){ 
                $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert="">
                    <a href="#" class="uk-alert-close uk-close"></a>Recored Deleted  !</div>');
                }else{
                    $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert="">
                    <a href="#" class="uk-alert-close uk-close"></a>Sorry, Recored Not Deleted !</div>');   
                }
            $this->redirect('report_type_attach/'); 
            
        }
        if(isset($this->request->data['submit']) && $this->request->data['submit']!=''){
            
            
             $DataTypeName = $this->DataType->find('first', array('fields' => array('datatype'),
                'conditions' => array('status' => '0','id'=>$this->request->data['data_type']),
            ));  
                
            $UPLOAD_FILES=$this->request->data['upl_doc'];
            
            $data['BMReportTypeAttachment']['id']                  =   $this->request->data['reportid'];
            $data['BMReportTypeAttachment']['data_type_id']        =   $this->request->data['data_type'];
            $data['BMReportTypeAttachment']['remark']              =   $this->request->data['remark'] ;
            $data['BMReportTypeAttachment']['created_by']          =   $auth['MyProfile']['id'];
           
            $success = $this->BMReportTypeAttachment->save($data);
            $ReportAttachID = $this->request->data['reportid'];
            
            $invl='0';
            if($success){
                if(!empty($UPLOAD_FILES)){
                    $DirName = $DataTypeName['DataType']['datatype'];
                    $Dir = WWW_ROOT .'bom';
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
                           
                            if(!($ext == 'pdf' || $ext == 'jpg' || $ext == 'png' || $ext == 'txt' || $ext == 'wmv' || $ext == 'doc' || $ext == 'docx') || ($file_up['size'] > 2048000) ){
                                $InvalidFiles .= $file_up['name'].",";
                                $invl='1';
                            }else{
                                if(move_uploaded_file($file_up['tmp_name'],$FILE_PATH)){
                                    //$caseID=$this->request->data['caseid'];
                                    $File_Data['BMReportTypeAttachFiles']['report_type_attach_id'] = $ReportAttachID;
                                    $File_Data['BMReportTypeAttachFiles']['attach_file'] = $FILE_NAME;
                                    $File_Data['BMReportTypeAttachFiles']['folder_name'] = $DirName;
                                    $this->BMReportTypeAttachFiles->create(); 
                                    $success_upld = $this->BMReportTypeAttachFiles->save($File_Data); 
                                } 
                            }
                        }
                    }
                }
            }
                if($invl=='0'){
                    $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                            <a href="#" class="uk-alert-close uk-close"></a>Record Modified Successfully !</div>');
                
                }else{
                     $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                            <a href="#" class="uk-alert-close uk-close"></a>Record Modified Successfully, This is invalid file [<font color='.red.'>'.$InvalidFiles.'</font>] Only !</div>');   
                
                }
                $this->redirect('report_type_attach');
        }
        
        
        $DataTypeList = $this->DataType->find('list', array('fields' => array('id', 'datatype'),
                'conditions' => array('status' => '0'),
                'order' => array('id' => 'ASC')
            ));
         array_unshift($DataTypeList, '--Select--');
        $ReportAttachDet    = $this->BMReportTypeAttachment->find('first',array('conditions' => array('BMReportTypeAttachment.id' =>$ReportAttachID)));
  
        $this->set(compact('DataTypeList','ReportAttachDet'));
    }
    
    public function report_attach_file_remove($ReportId=null,$fileID=null){
        $Delsuccess = $this->BMReportTypeAttachFiles->updateAll(array('BMReportTypeAttachFiles.status'=>'1'), array('BMReportTypeAttachFiles.id' =>$fileID));
            if($Delsuccess){ 
                $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert="">
                    <a href="#" class="uk-alert-close uk-close"></a>File Deleted  !</div>');
                }else{
                    $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert="">
                    <a href="#" class="uk-alert-close uk-close"></a>Sorry, File Not Deleted !</div>');   
                }
            $this->redirect('report_type_attach_update/'.$ReportId); 
        
    }
    
    public function report_attach_files($ReportAttachID){
        //Configure::write('debug',2);
        $Allfiles = $this->BMReportTypeAttachFiles->find('all',array('conditions'=>array('BMReportTypeAttachFiles.report_type_attach_id'=>$ReportAttachID,'BMReportTypeAttachFiles.status'=>'0')));
        
        $this->set('Allfiles', $Allfiles);
    }
    
    public function download($fileID) {
        
        //ob_start();
        ignore_user_abort(true);
        set_time_limit(0); // disable the time limit for this script
        $Dir_Name=$this->BMReportTypeAttachFiles->find('first',array('conditions'=>array('id'=>$fileID,'status'=>'0')));
            
        $DirName=$Dir_Name['BMReportTypeAttachFiles']['folder_name'];
        $fileName = $Dir_Name['BMReportTypeAttachFiles']['attach_file'];
        $path = WWW_ROOT.'bom'.DS.$DirName.DS;
            

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
     
     public function req_rec_file_download($id) {
        
        //ob_start();
        ignore_user_abort(true);
        set_time_limit(0); // disable the time limit for this script
        
        $auth = $this->Session->read('Auth');
        $empID = $auth['MyProfile']['id'];

        $condition = array(
           // 'BMReceiveRequestForward.req_receive_by' => $empID, 
            //'BMReceiveRequestForward.frwd_status' => '0',
            'BMReceiveRequest.id' => $id
            //'OR'=>array('BMReceiveRequestForward.req_receive_by' => $empID,'BMReceiveRequest.created_by' => $empID)
        );

        $allRecReq = $this->BMReceiveRequest->find('all', array(
            'conditions' => $condition,
            
            //'order' => 'BMReceiveRequest.id desc'
        ));
        
       
        
        
        
        
        
            
        $DirName= "RequestReceiving";
        $fileName = $allRecReq[0]['BMReceiveRequest']['file'];
        $path = WWW_ROOT.'bom'.DS.$DirName.DS;
          

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


	public function requestDetails($id) {
		//Configure::write('debug',2);
		
        $reqDetails = $this->BMReceiveRequest->find('all', array( 
            'conditions' => array('BMReceiveRequest.id' => $id),
			'order'=>array('BMReceiveRequestForward.id' => 'asc'),
        ));
       //print_r( $reqDetails); die;
        $this->set("reqDetails", $reqDetails);
		//die;
    }
}

?>
