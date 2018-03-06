<?php

App::uses('AppController', 'Controller');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TrainingMastersController
 *
 * @author hp4420-28u
 */
class TrainingMastersController extends AppController {

    var $name = 'TrainingMasters';
    var $uses = array('MstTrainingRequests', 'TrainingRegistrations', 'MyProfile', 'TrainingConfig');
    var $components = array('Session', 'RequestHandler', 'Email', 'TrainingCmp');
    var $helpers = array('Html', 'Form', 'Session');
    var $layout = 'employee-new';
    var $desg = array('DIRECTOR' => 'PAR0000028', 'SR PROJECT MANAGER' => 'PAR0000044');

    function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow();
        $this->desig_code = $this->TrainingCmp->getDesignationCode($this->Auth->User('emp_code'));

        $this->designations = array('DIRECTOR' => 'PAR0000028', 'SR PROJECT MANAGER' => 'PAR0000044');

        $this->set('designations', $this->designations);

        $this->set('appId', 6);
    }

    function training_identification_form() {

        $desig_code = $this->TrainingCmp->getDesignationCode($this->Auth->User('emp_code'));
        $this->set('desig_code', $desig_code);

        if (!empty($this->data)) {
            $resultdata = $this->MstTrainingRequests->find('first', array('fields' => array('MstTrainingRequests.request_id'), 'order' => array('MstTrainingRequests.request_id DESC')));
            $requestID = '';
            if (!empty($resultdata)) {
                $requestID = $resultdata['MstTrainingRequests']['request_id'] + 1;
            } else {
                $requestID = 1;
            }
            $trainingrequest = array();
            $trainingrequest['request_id'] = $requestID;
            $trainingrequest['training_date'] = date('Y-m-d', strtotime(date('d-M-Y')));
            $trainingrequest['training_status'] = 'PENDING';
            $trainingrequest['request_status'] = 'MR';
            $trainingrequest['comp_code'] = $this->Auth->User('comp_code');
            $trainingrequest['identified_by'] = $this->Auth->User('emp_code');
            $trainingrequest['duration_hh'] = $this->data['TrainingMaster']['nu_duration_hh'];
            $trainingrequest['duration_mm'] = $this->data['TrainingMaster']['nu_duration_mm'];
            $trainingrequest['training_topic_id'] = $this->data['TrainingMaster']['vc_training_topic_id'];
            $trainingrequest['training_topic_type'] = $this->data['TrainingMaster']['vc_training_topic_type'];
            $trainingrequest['training_name'] = $this->data['TrainingMaster']['vc_training_name'];
            $trainingrequest['self_intraining_nameclude'] = $this->data['TrainingMaster']['vc_self_include'];
            $idf = 'O';
            // print_r($trainingrequest);die;
            if ($this->desig_code == 'PAR0000017') {
                $idf = 'I';
            } else if (in_array($this->desig_code, $desg)) {
                $idf = 'M';
            } else {
                $idf = 'O';
            }

            $trainingrequest['identified_from'] = $idf;

//print_r($trainingrequest);die;
            if ($this->MstTrainingRequests->save($trainingrequest)) {
                /*                 * ****************************************************** */
                $traningres = array();
                if ($this->data['TrainingMaster']['vc_self_include'] == 'Y') {
                    $trainingrequest['tr_status'] = 'ALLOWED';
                } else {
                    $trainingrequest['tr_status'] = 'NOTINCLUDED';
                }
                $resultdata = $this->TrainingRegistrations->find('first', array('fields' => array('TrainingRegistrations.request_id'), 'order' => array('TrainingRegistrations.request_id DESC')));
                $requestID = '';
                if (!empty($resultdata)) {
                    $requestID = $resultdata['TrainingRegistrations']['request_id'] + 1;
                } else {
                    $requestID = 1;
                }
                $trainingrequest['request_id'] = $requestID;
                $trainingrequest['trainee_code'] = $this->Auth->User('emp_code');
                $trainingrequest['regis_date'] = date('d-M-Y');
                $this->MstTrainingRequests->save($trainingrequest);
                if (!empty($this->data['TrainingMasterDetail'])) {
                    $manager = $this->data['TrainingMasterDetail']['manager'][0];

                    foreach ($this->data['TrainingMasterDetail']['traineecode'] as $index => $value) {
                        $resultdata = $this->TrainingRegistrations->find('first', array('fields' => array('TrainingRegistrations.request_id'), 'order' => array('TrainingRegistrations.request_id DESC')));
                        $requestID = '';
                        if (!empty($resultdata)) {
                            $requestID = $resultdata['TrainingRegistrations']['request_id'] + 1;
                        } else {
                            $requestID = 1;
                        }

                        $traningres['request_id'] = $requestID;
                        $traningres['training_status'] = 'ALLOWED';
                        $traningres['trainee_code'] = $value;
                        $traningres['type'] = 'M';
                        $traningres['tr_status'] = 'ALLOWED';
                        $traningres['manager'] = $manager;
                        $traningres['regis_date'] = date('Y-m-d', strtotime(date('d-M-Y')));
                        $traningres['approved_date'] = date('Y-m-d', strtotime(date('d-M-Y')));
                        $this->TrainingRegistrations->save($traningres);
                    }
                }


                $this->Session->setFlash('Training details saved successfully', 'default', array(
                    'class' => 'succuss'));
            } else {
                $this->Session->setFlash('Training details could not be saved.', 'default', array(
                    'class' => 'succuss'));
            }

            $this->redirect('manage_training_identification_form');
        }

        $courselist = $this->TrainingCmp->courselisting();

        if ($this->desig_code == 'PAR0000044') {
            $userType = 'TI';
        } else if ($this->desig_code == 'PAR0000031') {
            $userType = 'ER';
        } else {
            $userType = 'MR';
        }

        $reported_emp = $this->TrainingCmp->reportedEmpList($this->Auth->User('comp_code'), $this->Auth->User('emp_code'), $userType);

        $this->set('reported_emp', $reported_emp);
        $this->set("courselist", $courselist);
    }

    /*
     * *
     * *
     * *Edit training identification form
     * *
     */

    function training_identification_form_edit() {

        $desig_code = $this->TrainingCmp->getDesignationCode($this->Auth->User('emp_code'));
        $this->set('desig_code', $desig_code);

        if (isset($this->params['pass'][1]) && !isset($this->data['Update'])) {
            $nu_request_id = base64_decode($this->params['pass'][1]);

            if ($this->params['pass'][0] == 'EDIT') {
                $trainData = $this->MstTrainingRequests->find('first', array(
                    'conditions' => array(
                        'MstTrainingRequests.request_id' => $nu_request_id
                    )
                ));

                $selected_empcodes = array();
                $remaining_emps = array();

                if (!empty($trainData)) {
                    foreach ($trainData['TrainingMasterDetail'] as $v) {
                        if ($v['tr_status'] == 'ALLOWED' && $this->Auth->User('emp_code') != $v['trainee_code']) {
                            $selected_empcodes[] = $v['trainee_code'];
                        }
                    }

                    $selected_emps = array();
                    $remaining_emps = array();
                }

                if (!empty($selected_empcodes)) {

                    if ($this->desig_code == 'PAR0000044') {
                        $remaining_emps = $this->TrainingCmp->remainingAllEmps($this->Auth->User('comp_code'), $selected_empcodes, 'REMAINS');
                        $selected_emps = $this->TrainingCmp->remainingAllEmps($this->Auth->User('comp_code'), $selected_empcodes, 'SELECETED');
                    } else {
                        $remaining_emps = $this->TrainingCmp->remainingEmpList($this->Auth->User('comp_code'), $this->Auth->User('emp_code'), $selected_empcodes, 'REMAINS');
                        $selected_emps = $this->TrainingCmp->remainingEmpList($this->Auth->User('comp_code'), $this->Auth->User('emp_code'), $selected_empcodes, 'SELECETED');
                    }
                }

                $courselist = $this->TrainingCmp->courselisting();
                $this->set('selected_emps', $selected_emps);
                $this->set('remaining_emps', $remaining_emps);
                $this->set("courselist", $courselist);
                $this->set('trainData', $trainData);
                $this->set('nu_request_id', $nu_request_id);
            } elseif ($this->params['pass'][0] == 'DELETE') {

                if ($this->MstTrainingRequests->delete(array('MstTrainingRequests.request_id' => $nu_request_id))) {

                    $this->Session->setFlash('Training identification request deleted successfully', 'default', array('class' => 'succuss'));
                    $this->redirect($this->referer());
                }
            }
        } else {

            $requestID = $this->data['TrainingMaster']['nu_request_id'];

            $requestBy = $this->TrainingCmp->getEmailID($this->TrainingCmp->identifiedBY($requestID));

            $email_status = 'NO';
            $from_emp_code = $this->Auth->User('emp_code');
            $to_emp_code = '';
            $subject = '';
            $msg_body_text = '';
            $approvedBy = '';
            $topicType = $this->data['MstTrainingRequests']['training_topic_type'];

            $training_name = '';
            if ($topicType == 'N') {
                if (isset($this->data['TrainingMaster']['topic_name'])) {
                    $training_name = htmlentities($this->data['TrainingMaster']['topic_name']);
                } else {

                    $training_name = htmlentities($this->data['TrainingMaster']['vc_training_name']);
                }
            } else {

                $topicId = $this->data['MstTrainingRequests']['topic_id'];
                $training_name = $this->TrainingCmp->getCouseName($topicId);
            }

            if (isset($this->data['Update'])) {
                $request_status = 'MR';
                $flash_msg = "Training details updated successfully";
                $to_emp_code = $this->data['TrainingMaster']['emp_code'];
                $approvedBy = $to_emp_code;
            } else if (isset($this->data['Submit']) && (in_array($this->desig_code, $this->designations))) {
                $flash_msg = "The Training request has been successfully submitted.";
                $request_status = 'TI';
                $approvedBy = $this->Auth->User('emp_code');
            } else {
                $flash_msg = "The Training request has been successfully submitted to the reporting manager.";
                $request_status = 'RM';
                $email_status = 'YES';
                $to_emp_code = $this->data['TrainingMaster']['emp_code'];

                $approvedBy = $to_emp_code;

                $msg_body_text = "<div>This is to bring into your notice that I have submitted an online training identification request for <b>" . $training_name . "</b>.<br /><br />I would appreciate if you could please approve it.</div> <br />";
            }

            $modifiedDate = date('Y-m-d', strtotime(date('d-M-Y')));

            $approvedBy = $this->data['TrainingMaster']['emp_code'];

            $trndate = $this->data['TrainingMaster']['vc_training_date'];
            $hh = $this->data['TrainingMaster']['nu_duration_hh'];
            $mm = $this->data['TrainingMaster']['nu_duration_mm'];
            $idefy = $this->data['TrainingMaster']['vc_identified_by'];
            $include = $this->data['TrainingMaster']['vc_self_include'];
            $subject = 'Training Request - ' . $training_name;
            $this->MstTrainingRequests->updateAll(array(
                'MstTrainingRequests.training_topic_id' => "'$topicId'",
                'MstTrainingRequests.training_name' => "'$training_name'",
                'MstTrainingRequests.training_date' => "'$trndate'",
                'MstTrainingRequests.duration_hh' => "'$hh'",
                'MstTrainingRequests.duration_mm' => "'$mm'",
                'MstTrainingRequests.request_status' => "'$request_status'",
                'MstTrainingRequests.training_status' => "'PENDING'",
                'MstTrainingRequests.self_include' => "'$include'",
                'MstTrainingRequests.approved_by' => "'$approvedBy'"
                    ), array(
                'MstTrainingRequests.request_id' => "$requestID"
            ));
            $this->MstTrainingRequests->commit();
            /*             * ****************************************************** */
            $condition = array('TrainingRegistrations.request_id' => $requestID);
            $this->TrainingRegistrations->deleteAll($condition, false);
            $trainingreg = array();
            if ($this->data['TrainingMaster']['vc_self_include'] == 'Y') {
                $trainingreg['tr_status'] = 'ALLOWED';
            } else {
                $trainingreg['tr_status'] = 'NOTINCLUDED';
            }

            $mgrID = $this->data['TrainingMaster']['emp_code'];
            $trainingreg['manager'] = $mgrID;
            $trainingreg['request_id'] = $requestID;
            $trainingreg['trainee_code'] = $this->Auth->User('emp_code');
            $trainingreg['regis_date'] = date('Y-m-d', strtotime(date('d-M-Y')));
            $this->TrainingRegistrations->save($trainingreg);
            foreach ($this->data['TrainingMasterDetail']['trainee_code'] as $index => $value) {
                $traineereg = array();
                $this->data['TrainingMasterDetail']['manager'] = $this->data['TrainingMaster']['emp_code'];
                $traineereg['request_id'] = $requestID;
                $traineereg['tr_status'] = 'ALLOWED';
                $traineereg['trainee_code'] = $value;
                $traineereg['regis_date'] = date("Y-m-d ");
                $traineereg['approved'] = date("Y-m-d ");
                $this->TrainingRegistrations->save($traineereg);
            }

            $this->Session->setFlash($flash_msg, 'default', array(
                'class' => 'succuss'
            ));

            if ($email_status == 'YES') {

                // $this->training_emails($from_emp_code,$to_emp_code,$subject,$msg_body_text);
            }
            /*             * ******************************************************************************** */
            $this->redirect('manage_training_identification_form');
        }

        $this->set("empcode", $this->Auth->User('emp_code'));
    }

    /*
     * *
     * *Manage training identification form
     * *
     * *
     */

    function manage_training_identification_form() {

        $this->paginate = array(
            'conditions' => array(
                'MstTrainingRequests.identified_by' => $this->Auth->User('emp_code')
            ),
            'order' => array('MstTrainingRequests.training_date DESC')
        );
        $paginateData = $this->paginate('MstTrainingRequests');
        $this->set('paginateData', $paginateData);
    }

    /*
     * *
     * *for manager only
     * *
     * *
     */

    function view_manager_training_identification() {

        if (isset($this->params['pass'][1]) && $this->params['pass'][0] == 'VIEW') {

            $nu_request_id = base64_decode($this->params['pass'][1]);
            // print_r($nu_request_id);die;
            $requestData = $this->MstTrainingRequests->find('first', array(
                'conditions' => array(
                    'MstTrainingRequests.request_id' => $nu_request_id
                )
            ));

            $traineeData = $this->TrainingRegistrations->find('all', array(
                'conditions' => array(
                    'TrainingRegistrations.request_id' => $nu_request_id,
                    'TrainingRegistrations.tr_status' => 'ALLOWED'
                )
            ));

            $this->set('traineeData', $traineeData);

            $this->set('request', $requestData);
            $this->set('nu_request_id', $nu_request_id);
        }

        $courselist = $this->TrainingCmp->courselisting();
        $this->set("courselist", $courselist);
        $this->set('emp_code', $this->Auth->User('emp_code'));
    }

    /*
     * *
     * *
     * *For manager only
     * *
     */

    function sanction_training_identification_form() {

        $new_cond_date = date('Y-m-d');

        $where_clause = array();

        $where_clause = array('MstTrainingRequests.approved_by' => $this->Auth->User('emp_code'));

        $where_clause += array('MstTrainingRequests.request_status' => array('RM'));



        $this->paginate = array(
            'MstTrainingRequests' => array(
                'limit' => '10',
                'conditions' => $where_clause,
                'order' => array('MstTrainingRequests.training_date DESC')
            )
        );

        $paginateData = $this->paginate('MstTrainingRequests');

        $this->set('paginateData', $paginateData);
    }

    function sanctioned_training_identification_requests() {
        $this->paginate = array(
            'conditions' => array(
                'TrainingMaster.vc_approved_by' => $this->emp_code,
                'TrainingMaster.vc_request_status' => array('PR', 'TI')
            ),
            'order' => array(
                'TrainingMaster.vc_date_modified' => 'DESC'
            )
        );
        $paginateData = $this->paginate('TrainingMaster');
        $this->set('paginateData', $paginateData);
    }

    function manager_training_identification() {
        $desig_code = $this->TrainingCmp->getDesignationCode($this->Auth->User('emp_code'));
        $this->set('desig_code', $desig_code);

        // print_r($this->data);die;
        if (isset($this->params['pass'][1]) && $this->params['pass'][0] == 'SANCTION' && (!isset($this->data['Approve']) || (!isset($this->data['Reject'])))) {
            $nu_request_id = base64_decode($this->params['pass'][1]);

            $requestData = $this->MstTrainingRequests->find('first', array(
                'conditions' => array(
                    'MstTrainingRequests.request_id' => $nu_request_id
                )
            ));

            $traineeData = $this->TrainingRegistrations->find('all', array(
                'conditions' => array(
                    'TrainingRegistrations.request_id' => $nu_request_id,
                    'TrainingRegistrations.tr_status' => 'ALLOWED'
                )
            ));

            $this->set('traineeData', $traineeData);
            $this->set('requestData', $requestData);
            $this->set('nu_request_id', $nu_request_id);
        } else {

            if (!empty($this->data)) {

                if (isset($this->data['TrainingMaster']['emp_code'])) {
                    $approved_by = $this->data['TrainingMaster']['emp_code'];
                } else {

                    $approved_by = $this->Auth->User('emp_code');
                }


                $requestID = $this->data['TrainingMaster']['nu_request_id'];

                $status = '';

                $msg_status = '';

                $idetifiedBy = $this->TrainingCmp->identifiedBY($requestID);

                $getName = $this->TrainingCmp->getEmailID($idetifiedBy);

                $prefix = $this->TrainingCmp->getNamePrefix($idetifiedBy, 'N');
                if (isset($this->data['TrainingMaster']['emp_code'])) {
                    $repto = $this->data['TrainingMaster']['emp_code'];
                } else {

                    $repto = $this->Auth->User('emp_code');
                }


                $managerData = $this->TrainingCmp->getEmailID($repto);

                $training_status = 'PENDING';

                $vcremarks = $this->data['TrainingMaster']['vc_remarks'];
                $hh = $this->data['TrainingMaster']['nu_duration_hh'];
                $mm = $this->data['TrainingMaster']['nu_duration_mm'];
                $date_modified = date('d-M-Y');

                $topicType = $this->data['MstTrainingRequests']['training_topic_type'];

                $training_name = '';

                if ($topicType == 'E') {
                    $topicId = $this->data['MstTrainingRequests']['topic_id'];
                    $training_name = $this->TrainingCmp->getCouseName($topicId);
                } else {
                    $training_name = $this->data['TrainingMaster']['vc_training_name'];
                }
                $trndate = $this->data['TrainingMaster']['vc_training_date'];

                $training_incharge = $this->TrainingCmp->getTrainingIncharge();

                $training_incharge_details = $this->TrainingCmp->getEmailID($training_incharge);

                $sendRemovedEmail = 'N';

                if (isset($this->data['forward'])) {
                    $approved_by = $this->data['TrainingMaster']['emp_code'];
                    $req_status = 'RM';
                } else if (isset($this->data['Approve'])) {

                    $status = 'ALLOWED';
                    $req_status = 'TI';
                    $flsh_msg = "The Training request has been successfully submitted to the training in-charge";
                    $training_status = 'PENDING';

                    /*                     * **************************************************************************************** */
                } else {

                    $moveforwered = $this->TrainingRegistrations->find('first', array('conditions' => array('TrainingRegistrations.request_id' => $requestID, 'TrainingRegistrations.type' => 'MF', 'TrainingRegistrations.trainee_code' => $repto)));

                    if (!empty($moveforwered)) {
                        //$this->Email->cc       = 'hakim.singh@essindia.co.in';
                    }

                    $status = 'NOT-ALLOWED';

                    $req_status = 'RR';

                    $flsh_msg = "The Training request has been successfully rejected by the reporting manager.";

                    $training_status = 'REJECTED';

                    //$from_email = $idf_manager_details['Employees']['vc_email'];

                    $to_email = $getName['UserDetail']['email'];

                    $this->Email->from = $from_email;

                    //$this->Email->to       = 'hakim.singh@essindia.co.in';

                    $this->Email->to = $to_email;

                    $this->Email->subject = 'Rejection of ' . $training_name . ' training request';
                    $this->Email->layout = 'trainemail_template';

                    $this->Email->template = 'trainemail_template';

                    $this->Email->sendAs = 'html';

                    $sign_off = ucwords(strtolower($idf_manager_details['UserDetails']['user_name']));

                    $this->set('sign_off', $sign_off);

                    $this->set('name', $prefix . ucwords(strtolower($getName['UserDetail']['user_name'])));

                    $mesg = "<div>This is to inform that your request regarding the " . $training_name . "  training been rejected <strong>" . $vcremarks . "</strong>.<br/>For any further clarification please feel free to reach me.</div><br/>";

                    $this->set('mesg', $mesg);
                    //$this->Email->send($mesg);			
                }

                $insData['MstTrainingRequests']['id'] = $requestID;
                $insData['MstTrainingRequests']['request_id'] = $requestID;
                $insData['MstTrainingRequests']['comp_code'] = $this->Auth->User('comp_code');
                $insData['MstTrainingRequests']['training_name'] = htmlentities($training_name);
                $insData['MstTrainingRequests']['training_status'] = $training_status;
                $insData['MstTrainingRequests']['request_status'] = $req_status;
                $insData['MstTrainingRequests']['date_modified'] = date('d-M-Y');
                $insData['MstTrainingRequests']['approved_by'] = $approved_by;
                $insData['MstTrainingRequests']['request_reason'] = $vc_remarks;
                $insData['MstTrainingRequests']['duration_hh'] = $hh;
                $insData['MstTrainingRequests']['duration_mm'] = $mm;
                $insData['MstTrainingRequests']['training_topic_type'] = $topicType;
                $insData['MstTrainingRequests']['training_date'] = $trndate;

                $idf = 'O';

                if ($this->desig_code == 'PAR0000017') {
                    $idf = 'I';
                } else if (in_array($this->desig_code, $desg)) {
                    $idf = 'M';
                } else {
                    $idf = 'O';
                }

                $insData['MstTrainingRequests']['identified_from'] = $idf;

                if ($this->MstTrainingRequests->save($insData)) {


                    if (isset($this->data['TrainingMaster']['vc_self_include']) && $this->data['TrainingMaster']['vc_self_include'] == 'Y') {
                        $mgr_status = 'ALLOWED';
                    } else {
                        //$mgr_status = 'NOTINCLUDED';
                        $mgr_status = 'ALLOWED';
                        $remarks = "You are not allowed for the requested  training.";
                    }

//				   $this->TrainingRegistrations>updateAll(array(
//						'TrainingRegistrations.tr_status' => "'$mgr_status'",
//						'TrainingRegistrations.remarks' => "'$remarks'"
//				   ), array(
//						'TrainingRegistrations.request_id' => $requestID,
//						'TrainingRegistrations.trainee_code' => $idetifiedBy
//				   ));
                    foreach ($this->data['TrainingMasterDetail']['trainee_code'] as $traineecode) {
                        $this->TrainingRegistrations->updateAll(array(
                            'TrainingRegistrations.tr_status' => "'$mgr_status'",
                            'TrainingRegistrations.remarks' => "'$remarks'"
                                ), array(
                            'TrainingRegistrations.request_id' => $requestID,
                            'TrainingRegistrations.trainee_code' => $traineecode
                        ));
                    }


                    $this->Session->setFlash($flsh_msg, 'default', array('class' => 'succuss'));
                    $this->redirect('sanction_training_identification_form');
                }
            }
        }
        if (isset($this->params['pass'][1]) && $this->params['pass'][0] == 'VIEW') {
            $nu_request_id = base64_decode($this->params['pass'][1]);
            $requestData = $this->MstTrainingRequests->find('first', array('conditions' => array('MstTrainingRequests.request_id' => $nu_request_id)));
            $traineeData = $this->TrainingRegistrations->find('all', array('conditions' => array('MstTrainingRequests.request_id' => $nu_request_id, 'MstTrainingRequests.status' => array('ALLOWED'))));
            $this->set('traineeData', $traineeData);
            $this->set('requestData', $requestData);
            $this->set('nu_request_id', $nu_request_id);
        }
        $courselist = $this->TrainingCmp->courselisting();

        $this->set("mgr_code", $this->emp_code);
        $this->set("courselist", $courselist);
    }

    function reportedEmps() {

        $requestID = $this->data['reqID'];


        $already_added = $this->TrainingRegistrations->find('list', array('conditions' => array('TrainingRegistrations.request_id' => $requestID, 'tr_status' => 'ALLOWED'), 'fields' => array('TrainingRegistrations.trainee_code')));

        $this->layout = false;
        $remaining_emps = $this->TrainingCmp->remainingEmpList($this->Auth->User('comp_code'), $this->Auth->User('emp_code'), $already_added, 'REMAINS');

        $this->set('data', $remaining_emps);
        $this->set('requestid', $requestID);
        $this->render('reportedEmps');
    }

    function add_more_trainees() {


        $reqID = $this->data['TrainingMaster']['nu_request_id'];

        if (!empty($reqID) && $reqID != '') {

            $flsh_msg = '';
            $vtype = 'MA';

            if (isset($this->data['vc_emp_code']) && !empty($this->data['vc_emp_code'])) {

                if (in_array($this->Auth->User('emp_code'), $this->data['vc_emp_code'])) {
                    $mgrID = '';
                    if (in_array($this->desig_code, $this->designations)) {

                        $request_status = 'RM';
                        $mgrID = $this->Auth->User('emp_code');
                    } else {
                        $request_status = 'RM';
                        $mgrID = 179;
                    }

                    $vtype = 'MF';
                    $this->MstTrainingRequests->query("update mst_training_requests TrainingMaster set TrainingMaster.approved_by='" . $mgrID . "' where TrainingMaster.request_id ='" . $reqID . "' AND TrainingMaster.training_status='PENDING' AND TrainingMaster.request_status='" . $request_status . "'");

                    $this->MstTrainingRequests->commit();


                    $insertData['TainingRegistrations'] = array(
                        'request_id' => $reqID,
                        'trainee_code' => $this->Auth->User('emp_code'),
                        'manager' => $mgrID,
                        'status' => 'ALLOWED',
                        'type' => $vtype,
                        'regis_date' => date('d-M-Y')
                    );
                    $this->TainingRegistrations->save($insertData);
                    $flsh_msg = "The Training request has been successfully submitted to the reporting manager";
                } else {

                    $this->MstTrainingRequests->query("update mst_training_requests TrainingMaster set TrainingMaster.approved_by=179 ,TrainingMaster.request_status='RM' where TrainingMaster.request_id ='" . $reqID . "' AND TrainingMaster.training_status='PENDING'");
                    $this->MstTrainingRequests->commit();

//				$reportingTo = $this->Trainingcmp->getEmailID($this->emp_code);
//				$training_name = $this->Trainingcmp->getTrainingName($reqID);
//				$requestBy     = $this->Trainingcmp->identifiedBY($reqID);
//				$getName         = $this->Trainingcmp->getEmailID($requestBy);
//				$prefix = $this->Trainingcmp->getNamePrefix($requestBy,'N');
//				$managerID       = $this->Trainingcmp->getEmailID($this->Trainingcmp->getReportTo($requestBy));
//				$flsh_msg        = "The Training request has been successfully submitted to the training in-charge";			
//				
//				$from_email = $reportingTo['Employees']['vc_email'];
//				$to_email = $getName['Employees']['vc_email'];
//				//$this->Email->to       = 'hakim.singh@essindia.co.in';	
//				$this->Email->from     = $from_email;				
//				$this->Email->to       = $to_email;						
//				$this->Email->subject  = 'Approval of '.$training_name.' training request';				
//				$this->Email->layout   = 'trainemail_template';				
//				$this->Email->template = 'trainemail_template';				
//				$this->Email->sendAs   = 'html';				
//				$sign_off              = ucwords(strtolower($reportingTo['Employees']['vc_emp_name']));				
//				$this->set('sign_off', $sign_off);
//				$this->set('name',$prefix.ucwords(strtolower($getName['Employees']['vc_emp_name'])));				
//				$mesg = "<div>This is to inform that your ".$training_name." training request has been approved & has been forwarded to the training in-charge for further management.</div> <br />";
//				$this->set('mesg', $mesg);				
//				//$this->Email->send($mesg);
//				
//				$training_incharge     = $this->Trainingcmp->getTrainingIncharge();						
//			    $training_incharge_details = $this->Trainingcmp->getEmailID($training_incharge);
//				
//				/************************* Email to Training Incharge *************************************/
//				      
//					$from_email = $managerData['Employees']['vc_email'];
//					$to_email = $training_incharge_details['Employees']['vc_email'];	
//					$this->Email->from     = $from_email;				
//					//$this->Email->to       = 'hakim.singh@essindia.co.in';	
//                    $this->Email->to       = $to_email;						
//					$this->Email->subject  = $training_name.' training request to be schedule';				
//					$this->Email->layout   = 'trainemail_template';				
//					$this->Email->template = 'trainemail_template';				
//					$this->Email->sendAs   = 'html';				
//					$sign_off              = ucwords(strtolower($managerData['Employees']['vc_emp_name']));				
//					$this->set('sign_off', $sign_off);				
//					$this->set('name',ucwords(strtolower($training_incharge_details['Employees']['vc_emp_name'])));	
//					$prefix = $this->Trainingcmp->getNamePrefix($requestBy,'N');
//                    $initiator = $getName['Employees']['vc_emp_name'];					
//					$ti_email = "<div>This is to inform that you have received ".$training_name." training request from ".$prefix.$initiator.".<br/><br/>";
//					$this->set('mesg', $ti_email);					
//		            $this->Email->send($ti_email);

                    /*                     * **************************************************************************************** */
                }

                foreach ($this->data['vc_emp_code'] as $index => $traineeCode) {

                    if ($this->Auth->User('emp_code') != $traineeCode) {

                        $insData = array();

                        $managerID = $this->Auth->User('emp_code');



                        $insData['TrainingRegistrations'] = array(
                            'request_id' => $reqID,
                            'trainee_code' => $traineeCode,
                            'manager' => $managerID,
                            'tr_status' => 'ALLOWED',
                            'type' => $vtype,
                            'regis_date' => date('Y-m-d', strtotime(date('d-M-Y')))
                        );
                        //print_r($insData);die;
                        $this->TrainingRegistrations->save($insData);
                    }
                }
            }
            $this->Session->setFlash($flsh_msg, 'default', array('class' => 'succuss'));
            $this->redirect('sanction_training_identification_form');
        }
    }

    function process_training_identification_form() {
        $this->paginate = array(
            'conditions' => array(
                'MstTrainingRequests.comp_code' => $this->Auth->User('comp_code'),
                'MstTrainingRequests.request_status' => 'TI',
                'NOT' => array(
                    'MstTrainingRequests.training_status' => array(
                        'CANCELLED',
                        'SCHEDULED'
                    )
                )
            ),
            'order' => array('MstTrainingRequests.training_date DESC')
        );
        $paginateData = $this->paginate('MstTrainingRequests');

        $this->set('paginateData', $paginateData);
    }

    function training_emails($from_emp_code, $to_emp_code, $subject, $msg_body_text) {

        $from_details = $this->Trainingcmp->getEmailID($from_emp_code);

        $to_details = $this->Trainingcmp->getEmailID($to_emp_code);

        $this->Email->from = $from_details['Employees']['vc_email'];

        $this->Email->to = $to_details['Employees']['vc_email'];

//$this->Email->to       = 'hakim.singh@essindia.co.in';

        $this->Email->subject = $subject;

        $this->Email->layout = 'trainemail_template';

        $this->Email->template = 'trainemail_template';

        $this->Email->sendAs = 'html';

        $sign_off = ucwords(strtolower($from_details['Employees']['vc_emp_name']));

        $this->set('sign_off', $sign_off);

        $prefix = $this->Trainingcmp->getNamePrefix($to_emp_code, 'RM');

        $this->set('name', $prefix . ucwords($name));

        $this->set('mesg', $msg_body_text);

        //$this->Email->send($msg_body_text);
    }

    function feedback() {
        
    }

    function configuration() {
        $this->layout = 'admin';
    }

    function configAdd() {
        //$this->layout = 'admin';
        if (!empty($this->data)) {
            $this->autoRender = false;
            $add_data = array();

            if (!empty($this->data)) {
                $add_data['email'] = $this->request->data['TrainingMasters']['email_check']; //= $this->data['Department']['company_name'];
                $add_data['sms'] = $this->request->data['TrainingMasters']['sms_check']; // = $this->data['Department']['dept_code'];
                $add_data['open_attendance_hour'] = $this->request->data['TrainingMasters']['open_attendance_hour']; // = $this->data['Department']['dept_name'];
                $add_data['open_attendance_min'] = $this->request->data['TrainingMasters']['open_attendance_min'];
                $add_data['close_attendance_hour'] = $this->request->data['TrainingMasters']['close_attendance_hour'];
                $add_data['close_attendance_min'] = $this->request->data['TrainingMasters']['close_attendance_min'];
                $add_data['comp_code'] = $this->request->data['TrainingMasters']['company_name'];
                // print_r($add_data);die;
                $con = $this->TrainingConfig->find('count', array('conditions' => array('comp_code' => $this->request->data['TrainingMasters']['company_name'])));
                // print_r($con);die; 
                if ($con > 0) {
                    //$st = array('msg' => "Duplicate Entry", 'type' => 'error');
                    $st = json_encode(array('msg' => "Duplicate Entry", 'type' => 'error'));
                } else {

                    $this->TrainingConfig->save($add_data);
                    // print_r('done');die; 
                    // $st = array('msg' => "Data saved successfully", 'type' => 'success');
                    $st = json_encode(array('msg' => "Data saved successfully", 'type' => 'error'));
                }
                echo $st;
                exit;
            }
        }
    }

    function configList() {

        /* $this->paginate = array(
          'limit' => 10,
          'fields' => array('*'),
          'order' => array(
          'TrainingConfig.id' => 'asc',
          )
          ); */
        $config = $this->TrainingConfig->find('first', array('fields' => array('*')));
        //print_r($config); die;
        $result = $this->paginate('TrainingConfig');
        //print($result);die;
        $this->set('list', $result);
    }

    function configEdit($id) {
        $this->layout = 'admin';
        $id = base64_decode($id);

        $config = $this->TrainingConfig->find('first', array('fields' => array('*'), 'conditions' => array('id' => $id)));
        $this->set('trainingconfig', $config);
        $this->set('id', $id);
    }

    function editsaveinfo() {
        if (!empty($this->data)) {
            if ($this->request->data['email_check'] == "") {
                $add_data['email'] = 0;
            } else {
                $add_data['email'] = 1;
            }
            if ($this->request->data['sms_check'] == "") {
                $add_data['sms'] = 0;
            } else {
                $add_data['sms'] = 1;
            }

            $add_data['open_attendance_hour'] = $this->request->data['TrainingMasters']['open_attendance_hour']; // = $this->data['Department']['dept_name'];
            $add_data['open_attendance_min'] = $this->request->data['TrainingMasters']['open_attendance_min'];
            $add_data['close_attendance_hour'] = $this->request->data['TrainingMasters']['close_attendance_hour'];
            $add_data['close_attendance_min'] = $this->request->data['TrainingMasters']['close_attendance_min'];
            $add_data['comp_code'] = $this->request->data['TrainingMasters']['company_name'];
            $add_data['id'] = $this->request->data['trainingid'];

            if ($this->TrainingConfig->save($add_data)) {
                $this->redirect(array('controller' => 'TrainingMasters', 'action' => 'configuration'));
            }
        }
    }

    function delete($id = null) {
        $this->layout = false;
        $this->autoRender = false;
        if (!empty($id)) {
            if ($this->TrainingConfig->delete($id)) {
                $st = json_encode(array('msg' => 'Record Deleted', 'type' => 'success'));
            } else {
                $st = json_encode(array('msg' => 'Record not deleted', 'type' => 'error'));
            }
        } else
            $st = json_encode(array('msg' => 'No Record Selected', 'type' => 'error'));
        echo $st;
        exit;
    }

}
