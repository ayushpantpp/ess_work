<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of LtaController
 *
 * @author hp4420-28u
 */
class LtaController extends AppController {

    var $uses = array('LtaBalance', 'WfMstStatus', 'LtaBillAmount', 'MyProfile', 'LtaWorkflow', 'LtaGroup', 'LtaSal', 'SalaryDetail', 'LtaLeave', 'LtaGroup', 'LeaveDetails','WfPaginateLvl');
    var $components = array('Session', 'Cookie', 'RequestHandler', 'Auth', 'EmpDetail', 'Common');
    var $helpers = array('Html', 'Js', 'Form', 'Session', 'Userdetail', 'Leave', 'Common');

    function beforeFilter() {

        parent::beforeFilter();
        $this->Auth->allow();
        $this->set('status', $this->WfMstStatus->find('list', array('fields' => array('id', 'status_name'))));
        $this->set('appId', 14);
    }

    public function add() {
        /* $this->layout = 'employee-new';
          $emp_name = $this->MyProfile->find('first',array('fields'=>array('*'),'conditions'=>array('emp_code'=>$this->Auth->user('emp_code'))));
         */$this->layout = 'employee-new';

        $emp_code = $this->Auth->User('emp_code');
        $emp_details = $this->EmpDetail->getemployeeinfomation($emp_code);
        $emp_name = $this->MyProfile->find('first', array('fields' => array('*'), 'conditions' => array('emp_code' => $this->Auth->user('emp_code'))));

        // $lta_claim_flag = $this->EmpDetail->lta_per($this->Auth->User('emp_code'),$this->Auth->User('comp_code'));
        $lta_balance_years = $this->LtaBalance->find('first', array('fields' => array('*'), 'conditions' => array('emp_id' => $this->Auth->User('emp_id'))));
        $lta_claim_flag = floor($lta_balance_years['LtaBalance']['lta_years']);
        $date = date('Y-m-d');
        $time = strtotime($date);
        $year = date("Y", $time);
        $checkencsh = $this->LtaBillAmount->find('first', array('conditions' => array('year(created_at)' => $year, 'status IN(1,2)', 'emp_code' => $this->Auth->User('emp_code'))));
        $ltamonthchkprocess = $this->Common->chkLTAProcess();
        $this->set('checklta', $checkencsh);
        $this->set('ltamonthchkprocess', $ltamonthchkprocess);
        $this->set('lta_block', $lta_claim_flag);
        $this->set('gender', $emp_details['MyProfile']['gender']);
        $this->set('lastname', $emp_details['MyProfile']['emp_lastname']);
        $this->set('emp_name', $emp_details['MyProfile']['emp_full_name']);
        $this->set('emp_nm_tl', $emp_name['MyProfile']['emp_nm_ttl']);
        $this->set('emp_details', $emp_details['MyProfile']);
    }

    public function Ltaclaim($val) {
        $lta_value = array();
        $n = rand(0, 100000);
        $date = new DateTime($this->data['jour_start_date']);
        $date2 = new DateTime($this->data['jour_end_date']);
        $diff = date_diff($date, $date2);
        $days = $diff->days;
        $journey_start_date = date('Y-m-d', strtotime($this->data['jour_start_date']));
        $journey_end_date = date('Y-m-d', strtotime($this->data['jour_end_date']));

        if ($journey_start_date > date('Y-m-d') || $journey_end_date > date('Y-m-d')) {
            $this->Session->setFlash('<div class="uk-alert uk-alert-warning" data-uk-alert="">
                            <a href="#" class="uk-alert-close uk-close"></a>You cannot claim in advance !!!</div>');
            $this->redirect('/lta/add');
        }
//      if ($days < 5 ) 
//         {
//           $this->Session->setFlash('journey start date and journey end date should be min 5 days');
//           $this->redirect('/lta/add');
//         }
        //print_r($_FILES);die;
        $emp_code = $this->Auth->User('emp_code');
        $emp_name = $this->MyProfile->find('first', array('fields' => array('*'), 'conditions' => array('emp_code' => $this->Auth->user('emp_code'))));
        if (!empty($_FILES['doc_file']['name']) && !empty($emp_code)) {

            $newfilename = $n . basename($_FILES['doc_file']['name']);
            $file = "uploads/Lta/" . $newfilename;
            $filename = basename($_FILES['doc_file']['name']);
            if (move_uploaded_file($_FILES['doc_file']['tmp_name'], $file)) {
                
            }
        }

//        $lta_expense = $this->LtaBillAmount->find('all', array(
//            'conditions' => array(
//                "NOT" => array("status" => array(4)),
//                "OR" => array("jour_start_date IN " => array(date('Y-m-d', strtotime($this->data['jour_start_date'])), date('Y-m-d', strtotime($this->data['jour_end_date'])))),
//                "OR" => array("jour_end_date IN " => array(date('Y-m-d', strtotime($this->data['jour_start_date'])), date('Y-m-d', strtotime($this->data['jour_end_date'])))),
//                'emp_code' => $this->Auth->User('emp_code'))
//        ));

        $lta_expense1 = $this->LtaBillAmount->find('all', array(
            'conditions' => array(
                "status NOT IN (4)",
                "jour_start_date IN " => array(date('Y-m-d', strtotime($this->data['jour_start_date'])), date('Y-m-d', strtotime($this->data['jour_end_date']))),
                'emp_code' => $emp_code
            )
        ));
        $lta_expense2 = $this->LtaBillAmount->find('all', array(
            'conditions' => array(
                "status NOT IN (4)",
                "jour_end_date IN " => array(date('Y-m-d', strtotime($this->data['jour_start_date'])), date('Y-m-d', strtotime($this->data['jour_end_date']))),
                'emp_code' => $emp_code
            )
        ));

        $lta_expense3 = $this->LtaBillAmount->find('all', array(
            'conditions' => array(
                "status NOT IN (4)",
                "jour_start_date between ? and ? " => array(date('Y-m-d', strtotime($this->data['jour_start_date'])), date('Y-m-d', strtotime($this->data['jour_end_date']))),
                'emp_code' => $emp_code
            )
        ));
        $lta_expense4 = $this->LtaBillAmount->find('all', array(
            'conditions' => array(
                "status NOT IN (4)",
                "jour_end_date between ? and ? " => array(date('Y-m-d', strtotime($this->data['jour_start_date'])), date('Y-m-d', strtotime($this->data['jour_end_date']))),
                'emp_code' => $emp_code
            )
        ));

        if (count($lta_expense1) > 0 || count($lta_expense2) > 0 || count($lta_expense3) > 0 || count($lta_expense4) > 0) {
            $this->Session->setFlash('<div class="uk-alert uk-alert-warning" data-uk-alert="">
                            <a href="#" class="uk-alert-close uk-close"></a>Lta Already claimed</div>');
            $this->redirect('/lta/add');
        }


        $date = date('Y-m-d');
        $time = strtotime($date);
        $year = date("Y", $time);
        $checkencsh = $this->LtaBillAmount->find('first', array('conditions' => array('year(created_at)' => $year, 'status' => '5', 'emp_code' => $this->Auth->User('emp_code'))));
        /* if(!empty($checkencsh)){
          $this->Session->setFlash('LTA to be claimed once in a year', 'default', array('class' => 'danger'));
          $this->redirect('view');
          }
          else{ */

        // $lta_claim_flag = $this->EmpDetail->lta_per($this->Auth->User('emp_code'),$this->Auth->User('comp_code'));
        //if($this->data['ltaclaimyear'] <= $lta_claim_flag){
        $lta_grp = $this->MyProfile->find('first', array(
            'fields' => array('*'),
            'conditions' => array('emp_code' => $this->Auth->User('emp_code'), 'comp_code' => $this->Auth->User('comp_code'))
        ));
        /*         * ***********  LTA Leave ****************** */
        $lta_leave_type = $this->LtaLeave->find('first', array(
            'fields' => array('*'),
            'conditions' => array('grp_id' => $lta_grp['MyProfile']['emp_grp_id'], 'org_id' => $this->Auth->User('comp_code'))
        ));

        $lta_max_leave = $this->LtaGroup->find('first', array(
            'fields' => array('*'),
            'conditions' => array('grp_id' => $lta_grp['MyProfile']['emp_grp_id'], 'org_id' => $this->Auth->User('comp_code'))
        ));
        $date = date('Y-m-d');
        $time = strtotime($date);
        $year = date("Y", $time);
        $val = $this->data['ltaclaimyear'];
        $cal_year = date("Y", strtotime(" -$val year"));
        $leave_details = $this->LeaveDetails->find('all', array(
            'fields' => array('leave_id', 'count(leave_detail_id)'),
            'conditions' => array('leave_code' => $lta_leave_type['LtaLeave']['leave_id'], 'emp_code' => $this->Auth->User('emp_code'), 'year(leave_date)>=' . $cal_year, 'year(leave_date) <=' . $year),
            'group' => array('leave_id'),
            'order' => array('leave_id desc')
        ));




        $lta_year = $this->data['ltaclaimyear'];

       

        $lta_component = $this->LtaSal->find('all', array(
            'fields' => array('*'),
            'conditions' => array('org_id' => $this->Auth->User('comp_code'), 'grp_id' => $lta_grp['MyProfile']['emp_grp_id'])
        ));
        //  print_r($lta_component);die;
        $sal_tot = 0;
        foreach ($lta_component as $component) {
            $sal_detail = $this->SalaryDetail->find('first', array(
                'fields' => array('sal_amt'),
                'conditions' => array('sal_id' => $component['LtaSal']['sal_id'], 'emp_id' => $this->Auth->User('emp_code'))
            ));
            $sal_tot = $sal_detail['SalaryDetail']['sal_amt'] + $sal_tot;
        }
        $tot_lta_cal = $sal_tot * $this->data['ltaclaimyear'];

        if ($tot_lta_cal == $this->data['bill_amt']) {
            $taxable_amt = 0;
        } else {
            if ($this->data['bill_amt'] > $tot_lta_cal) {
                $taxable_amt = 0;
            } else {
                $taxable_amt = $tot_lta_cal - $this->data['bill_amt'];
            }
        }


        /*         * ****************** ends here ****************************** */

        $lta_value['comp_code'] = $this->Auth->user('comp_code');
        $lta_value['emp_code'] = $this->Auth->user('emp_code');
        $lta_value['bill_amount'] = $this->data['bill_amt'];
        $lta_value['created_at'] = date('Y-m-d');
        $lta_value['jour_start_date'] = date('Y-m-d', strtotime($this->data['jour_start_date']));
        $lta_value['jour_end_date'] = date('Y-m-d', strtotime($this->data['jour_end_date']));
        $lta_value['uploaded_file'] = $newfilename;
        $lta_value['status'] = 1;
        $lta_value['taxable_amt'] = $taxable_amt;
        $lta_value['sal_id'] = 'PAR0000073';
        $grp_id = $this->MyProfile->find('first', array('fields' => array('emp_grp_id', 'doc_id'), 'conditions' => array('emp_code' => $this->Auth->User('emp_code'), 'comp_code' => $this->Auth->User('comp_code'))));
        $lta_value['emp_doc_id'] = $grp_id['MyProfile']['doc_id'];
        $lta_value['lta_years'] = $this->data['ltaclaimyear'];
        $lta_value['loc_type'] = $this->data['loc_type'];
        $lta_value['fy_id'] = $this->Common->findfy_id(date('Y-m-d'));
        $this->LtaBillAmount->create();
        if ($this->LtaBillAmount->save($lta_value)) {
            $claim_year = $this->data['ltaclaimyear'];
            /* $lta_balance_deduct = $this->LtaBalance->updateAll(
              array('LtaBalance.lta_years' =>"LtaBalance.lta_years - $claim_year"),
              array('LtaBalance.emp_id' =>$this->Auth->User('emp_id'))
              ); */
            $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                            <a href="#" class="uk-alert-close uk-close"></a>LTA Claim successfully saved. !!!</div>');
            $record_id = $this->LtaBillAmount->getLastInsertID();
            $this->redirect('/lta/workflow_display/' . $record_id);
        }

//        $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
//                            <a href="#" class="uk-alert-close uk-close"></a>LTA Claim successfully for approval. !!!</div>');

        $record_id = $this->LtaBillAmount->getLastInsertID();

        $this->redirect('/lta/workflow_display/' . $record_id);
        /* }else{
          $this->Session->setFlash('you cannot claim LTA for'.$this->data['ltaclaimyear'].'years', 'default', array('class' => 'danger'));
          $this->redirect('add');
          }
          } */
    }

    public function edit($id) {

        $lta_claim = $this->LtaBillAmount->find('first', array(
            'fields' => array('*'), 'conditions' => array('id' => $id)));
        $this->set('lta_claim', $lta_claim);
        $this->layout = 'employee-new';
        $emp_code = $this->Auth->User('emp_code');
        $emp_details = $this->EmpDetail->getemployeeinfomation($emp_code);

        $emp_name = $this->MyProfile->find('first', array('fields' => array('*'), 'conditions' => array('emp_code' => $this->Auth->user('emp_code'))));
        $lta_claim_flag = $this->EmpDetail->lta_per($this->Auth->User('emp_code'), $this->Auth->User('comp_code'));
        $date = date('Y-m-d');
        $time = strtotime($date);
        $year = date("Y", $time);
        $this->set('ltaid', $id);
        $this->set('lta_block', $lta_claim_flag);
        $this->set('gender', $emp_details['MyProfile']['gender']);
        $this->set('lastname', $emp_details['MyProfile']['emp_lastname']);
        $this->set('emp_name', $emp_details['MyProfile']['emp_firstname']);
        $this->set('emp_details', $emp_details['MyProfile']);
    }

    public function delete($ltaid) {
        $leave_id = base64_decode($leave_id);
        $ld = $this->LtaBillAmount->find('list', array(
            'conditions' => array(
                'id' => $ltaid
            )
        ));
        foreach ($ld as $key => $value) {
            $this->LtaBillAmount->delete($value);
        }
        $wf = $this->LtaWorkflow->find('list', array(
            'conditions' => array(
                'lta_bill_amount_id' => $ltaid
            )
        ));
        foreach ($wf as $key => $value) {
            $this->LtaWorkflow->delete($value);
        }

        $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                            <a href="#" class="uk-alert-close uk-close"></a>LTA Deleted Sucessfully !!!</div>');
        $this->redirect('view');
    }

    public function LtaClaimEdit() {

        $n = rand(0, 200000);
        $emp_code = $this->Auth->User('emp_code');
        $emp_name = $this->MyProfile->find('first', array('fields' => array('*'), 'conditions' => array('emp_code' => $this->Auth->user('emp_code'))));
        if (!empty($this->request->data)) {
            $ltaedit = array();
            $ltaedit['id'] = $this->data['ltaid'];
            $ltaedit['lta_years'] = $this->data['ltaclaimyear'];
            $ltaedit['bill_amount'] = $this->data['bill_amt'];
            $ltaedit['jour_start_date'] = date('Y-m-d', strtotime($this->data['jour_start_date']));
            $ltaedit['jour_end_date'] = date('Y-m-d', strtotime($this->data['jour_end_date']));
            $ltaedit['created_at'] = date('Y-m-d', strtotime(date('Y-m-d')));
            $ltaedit['status'] = 7;
            if (!empty($_FILES['doc_file']['name']) && !empty($emp_code)) {
                $newfilename = $n . basename($_FILES['doc_file']['name']);
                $file = "uploads/Lta/" . $newfilename;
                $filename = basename($_FILES['doc_file']['name']);
                if (move_uploaded_file($_FILES['doc_file']['tmp_name'], $file)) {
                    $ltaedit['uploaded_file'] = $newfilename;
                }
            }

            //print_r($ltaedit); die;

            if ($this->LtaBillAmount->save($ltaedit)) {
                $this->redirect('/lta/workflow_display/' . $this->data['ltaid']);
            }
        } else {
            $this->redirect('view');
        }
    }

    public function workflow_display($id) {
        $this->layout = 'employee-new';
        $this->set('id', $id);
    }

    public function saveinfomation() {
        //print_r($this->data);die;
        if (!empty($this->request->data)) {

            $org_id = $this->Auth->User('comp_code');
            $save = array();
            $save['lta_bill_amount_id'] = $this->request->data['lta_id'];
            $save['emp_code'] = $this->Auth->User('emp_code');
            $save['lta_status'] = 2;
            $save['fw_date'] = date('Y-m-d h:i:s');

            if ($this->LtaWorkflow->save($save)) {
                unset($save);
                $save1['emp_code'] = $this->request->data['fwlta']['emp_code'];

                $save1 = array();
                $save1['lta_bill_amount_id'] = $this->request->data['lta_id'];
                $save1['emp_code'] = $this->request->data['fwlta']['emp_code'];
                $this->LtaWorkflow->create();
                if ($this->LtaWorkflow->save($save1)) {
                    unset($save1);
                    $this->LtaBillAmount->updateAll(
                            array('LtaBillAmount.status' => '2'), array('LtaBillAmount.id' => $this->request->data['lta_id'])
                    );
                    $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                            <a href="#" class="uk-alert-close uk-close"></a>LTA Claim forwarded !!! </div>');
                    $this->redirect(array('controller' => 'Lta', 'action' => 'view'));
                }
            }
        }
    }

    public function view($val) {

        
        try {
            $this->layout = 'employee-new';
            if(!empty($val))
            {
              
            $dt=$val;
        $this->set('pen_val',$dt);
            }
            else{
                 $dt=$this->Common->findpaginateLevel('14');
            }
  
            $emp_code = $this->Auth->User('emp_code');
            $this->paginate = array(
                'fields' => array('*'),
                'limit' => $dt,
                'order' => 'LtaBillAmount.id DESC',
                'conditions' => array('LtaBillAmount.emp_code' => $emp_code)
            );
            $lta_view = $this->paginate('LtaBillAmount');
        } catch (Exception $e) {
            
        }
        //$lta_view = $this->paginate('LtaBillAmount', array('emp_code' => $this->Auth->User('emp_code')));
        $emp_name = $this->MyProfile->find('first', array('fields' => array('*'), 'conditions' => array('emp_code' => $this->Auth->user('emp_code'))));
        $lta_balance = $this->LtaBalance->find('first', array('fields' => array('*'), 'conditions' => array('emp_id' => $this->Auth->User('emp_id'))));

        $this->set('ltabalance', $lta_balance['LtaBalance']['lta_years']);
        $this->set('LtaDetails', $lta_view);

        $this->set('emp_name', $emp_name['MyProfile']['emp_firstname']);
        $this->set('lastname', $emp_name['MyProfile']['emp_lastname']);

        $this->set('emp_id', $emp_name['MyProfile']['emp_id']);
    }

    public function approval() {
        $this->layout = 'employee-new';
        $org_id = $this->Auth->User('comp_code');
        $emp_code = $this->Auth->User('emp_code');
        if (empty($emp_code)) {
            $this->redirect('view');
        }


        $this->paginate = array(
            'fields' => array('*'),
            'limit' => 10,
            'order' => 'LtaBillAmount.id DESC',
            'joins' => array(
                array(
                    'table' => 'lta_workflow',
                    'alias' => 'lta',
                    'type' => 'inner',
                    'foreignKey' => false,
                    'conditions' => array('lta.lta_bill_amount_id =  LtaBillAmount.id ')
                )
            ),
            'conditions' => array('lta.emp_code' => $emp_code, 'lta.fw_date' => NULL)
        );


        $pending_lta_employee = $this->paginate('LtaBillAmount');
        $emp_code_emp = $pending_lta_employee[0]['LtaBillAmount']['emp_code'];

        $this->set('pending_lta_employee', $pending_lta_employee);
    }

    public function fwlta($id) {
        $this->layout = 'employee-new';
        $ltaid = base64_decode($id);

        if ($ltaid) {
            $lta = $this->LtaBillAmount->find('first', array('fields' => array('*'), 'conditions' => array('id' => $ltaid)));
            $ltawfid = $this->LtaWorkflow->find('first', array('fields' => array('id'),
                'conditions' => array('emp_code' => $this->Auth->User('emp_code'), 'lta_bill_amount_id' => $ltaid)));

            $this->set('ltastatus', $lta['LtaBillAmount']['status']);
            $this->set('lta_amt_id', $lta['LtaBillAmount']['id']);
            $this->set('ltawfid', $ltawfid['LtaWorkflow']['id']);
        }
    }

    public function ltasaveinfo() {
        // ECHO "<pre>";  print_r($this->request->data);die;
        if (!empty($this->request->data)) {

            //============== Forward==================
            if ($this->request->data['LtaWorkflow']['type'] == 2) {

                $save = array();
                $save['id'] = $this->request->data['LtaWorkflow']['id'];
                $save['remark'] = $this->request->data['LtaWorkflow']['forward_remark'];
                $save['fw_date'] = date('Y-m-d');
                $save['lta_status'] = 2;

                $this->LtaWorkflow->save($save);
                unset($save);
                $check = $this->LtaWorkflow->find('first', array('conditions' => array(
                        'id' => $this->request->data['LtaWorkflow']['id'],
                        'emp_code' => $this->request->data['LtaWorkflow']['forward_emp_code'])));

                if (empty($check)) {
                    $save1 = array();
                    $save1['lta_bill_amount_id'] = $this->request->data['LtaWorkflow']['lta_bill_amount_id'];
                    $save1['emp_code'] = $this->request->data['LtaWorkflow']['forward_emp_code'];
                    $this->LtaWorkflow->create();
                    $this->LtaWorkflow->save($save1);
                    unset($save1);
                } else {
                    $remark = $this->request->data['LtaWorkflow']['forward_remark'];
                    $this->LtaBillAmount->updateAll(array('status' => null), array(
                        'lta_bill_amount_id' => $this->request->data['LtaWorkflow']['id'],
                        'emp_code' => $this->request->data['LtaWorkflow']['forward_emp_code']));
                    $this->LtaWorkflow->updateAll(array('lta_status' => 2, 'remark' => "'.$remark.'"), array('id' => $check['LtaWorkflow']['id']));
                }

                if ($this->EmpDetail->getlaststagelevel(1) == 0) {

                    $this->LtaBillAmount->updateAll(
                            array('LtaBillAmount.status' => 2), array('LtaBillAmount.id' => $this->request->data['LtaWorkflow']['lta_bill_amount_id'])
                    );
                } else {

                    $this->LtaBillAmount->updateAll(
                            array('LtaBillAmount.status' => 5), array('LtaBillAmount.id' => $this->request->data['LtaWorkflow']['lta_bill_amount_id'])
                    );
                }
                $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                            <a href="#" class="uk-alert-close uk-close"></a>Lta claim Forwarded. </div>');
                $this->redirect(array('controller' => 'lta', 'action' => 'approval'));
            } else if ($this->request->data['LtaWorkflow']['type'] == 3) {

                $save1 = array();
                $save = array();
                $save['id'] = $this->request->data['LtaWorkflow']['id'];
                $save['remark'] = $this->request->data['LtaWorkflow']['revert_remark'];
                $save['lta_status'] = 3;
                $save['fw_date'] = '';
                $this->LtaWorkflow->save($save);
                $check = $this->LtaWorkflow->find('first', array('conditions' => array(
                        'lta_bill_amount_id' => $this->request->data['LtaWorkflow']['lta_bill_amount_id'],
                        'emp_code' => $this->request->data['LtaWorkflow']['revert_emp_code'])));
                if (empty($check)) {
                    $save1['lta_bill_amount_id'] = $this->request->data['LtaWorkflow']['lta_bill_amount_id'];
                    $save1['emp_code'] = $this->request->data['LtaWorkflow']['revert_emp_code'];
                    $save1['lta_status'] = 2;
                    $this->LtaWorkflow->save($save1);
                } else {
                    $revert_reason = $this->request->data['LtaWorkflow']['revert_remark'];
                    $this->LtaWorkflow->updateAll(array('fw_date' => null, 'remark' => "'.$revert_reason.'"), array('id' => $check['LtaWorkflow']['id']));
                    $this->LtaBillAmount->updateAll(array('LtaBillAmount.status' => 3), array('LtaBillAmount.id' => $this->request->data['LtaBillAmount']['lta_bill_amount_id'])
                    );
                }
                unset($save1);
                unset($save);
                /* $this->ConveyencExpenseDetail->updateAll(
                  array('ConveyencExpenseDetail.conveyence_status' => '3'),
                  array('ConveyencExpenseDetail.voucher_id' => $this->request->data['ConveyenceWorkflow']['voucher_id'])); */
                $this->Session->setFlash('<div class="uk-alert uk-alert-warning" data-uk-alert=""><a href="#" class="uk-alert-close uk-close"></a>LTA Rejected.</div>');
                $this->redirect(array('controller' => 'lta', 'action' => 'approval'));
            } else if ($this->request->data['LtaWorkflow']['type'] == 4) {



                $rem = $this->request->data['LtaWorkflow']['reject_remark'];
                $lv_rej = $this->LtaBillAmount->updateAll(
                        array('LtaBillAmount.status' => 4, 'remark' => "'$rem'"), array(
                    'LtaBillAmount.id' => $this->request->data['LtaWorkflow']['lta_bill_amount_id'])
                );
                $remark = $this->request->data['LtaWorkflow']['reject_remark'];

                if ($lv_rej) {

                    $newsave = array();
                    $newsave['id'] = $this->request->data['LtaWorkflow']['id'];
                    $newsave['emp_code'] = $this->Auth->User('emp_code');
                    $newsave['remark'] = $this->request->data['LtaWorkflow']['reject_remark'];
                    $newsave['approval_date'] = date('Y-m-d', strtotime(date('Y-m-d')));
                    ;
                    $newsave['lta_status'] = 4;
                    $this->LtaWorkflow->save($newsave);

                    $this->Session->setFlash('<div class="uk-alert uk-alert-warning" data-uk-alert=""><a href="#" class="uk-alert-close uk-close"></a>LTA  Rejected.</div>', false, array('class' => 'flash flash_error'));
                    $this->redirect(array('controller' => 'lta', 'action' => 'approval'));
                }
            } else if ($this->request->data['LtaWorkflow']['type'] == 5) {


                $rem = $this->request->data['LtaWorkflow']['approve_remark'];
                $lv_app = $this->LtaBillAmount->updateAll(
                        array('LtaBillAmount.status' => 5, 'remark' => "'$rem'"), array(
                    'LtaBillAmount.id' => $this->request->data['LtaWorkflow']['lta_bill_amount_id'])
                );
                if ($lv_app) {
                    $newsave = array();


                    $newsave['id'] = $this->request->data['LtaWorkflow']['id'];
                    $newsave['lta_bill_amount_id'] = $this->request->data['LtaWorkflow']['lta_bill_amount_id'];
                    $newsave['emp_code'] = $this->Auth->User('emp_code');
                    $newsave['remark'] = $this->request->data['LtaWorkflow']['approve_remark'];
                    $newsave['approval_date'] = date('Y-m-d');
                    $newsave['lta_status'] = 5;

                    $this->LtaWorkflow->save($newsave);
                    /* 'emp_code' => $val['ConveyencExpenseDetail']['emp_code'],
                      'voucher_id' => $val['ConveyencExpenseDetail']['voucher_id']
                      )); */
                }

                $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                            <a href="#" class="uk-alert-close uk-close"></a>LTA Approved Successfully !!! </div>');
                $this->redirect(array('controller' => 'lta', 'action' => 'approval'));
            }
        }
        $this->redirect(array('controller' => 'lta', 'action' => 'approval'));
    }

    public function employee_lta_report() {
        //Configure::write('debug',2);
        $this->layout = 'employee-new';
        $auth = $this->Session->read('Auth');
        $orgID = $auth['MyProfile']['comp_code'];
        $empID = $auth['MyProfile']['emp_code'];

        $flag = '';
        if (isset($this->request->data['submit']) && $this->request->data['submit'] != '') {

            if (($this->request->data['lta_status'] == '0' || $this->request->data['lta_status'] == '') && $this->request->data['from_date'] == '' && $this->request->data['end_date'] == '') {
                $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert="">
                            <a href="#" class="uk-alert-close uk-close"></a>Please Enter Atleast One Value !!!!</div>');
                $this->redirect('employee_lta_report');
            }

            if ($this->request->data['lta_status'] != '0' && $this->request->data['lta_status'] != '') {
                $ORconditions['status'] = $this->request->data['lta_status'];

                $vouch_status = $this->request->data['lta_status'];
            }

            if ($this->request->data['from_date'] != '' && $this->request->data['end_date'] != '') {
                $from_date = date('Y-m-d', strtotime($this->request->data['from_date']));
                $end_date = date('Y-m-d', strtotime($this->request->data['end_date']));
                $ORconditions['jour_start_date between ? and ?'] = array($from_date, $end_date);
                //$ORconditions['ConveyencExpenseDetail.claim_date <='] = $end_date;
            }

            if ($this->request->data['from_date'] != '' && $this->request->data['end_date'] != '') {
                $from_date = date('Y-m-d', strtotime($this->request->data['from_date']));
                $end_date = date('Y-m-d', strtotime($this->request->data['end_date']));
                $ORconditions['jour_end_date between ? and ?'] = array($from_date, $end_date);
                //$ORconditions['ConveyencExpenseDetail.claim_date <='] = $end_date;
            }

            $ORconditions['comp_code'] = $orgID;
            $ORconditions['emp_code'] = $empID;
            $conditions = array($ORconditions);

            $VoucherDetails = $this->LtaBillAmount->find('all', array(
                'fields' => array('*'),
                //'limit' => 10,
                //'order' => array('DtTravelVoucher.voucher_id  DESC'),
                'conditions' => $conditions
                    //'order'=>array('LvMstId.id desc')
            ));

            if ($VoucherDetails) {
                $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                            <a href="#" class="uk-alert-close uk-close"></a>Report Generated Successfully !!!!</div>');
            } else {
                $this->Session->setFlash('<div class="uk-alert uk-alert-danger" data-uk-alert="">
                            <a href="#" class="uk-alert-close uk-close"></a>Sorry, there is no record found !!!!</div>');
            }

            $flag = 'open';
            $this->set(compact('VoucherDetails', 'flag', 'vouch_status', 'from_date', 'end_date'));
        }
        $voucherStatus = array('0' => '---Select---', '2' => 'Pending', '5' => 'Approved', '4' => 'Rejected');

        $this->set(compact('voucherStatus'));
    }

    public function generate_emp_lta_report_pdf($from_date = null, $end_date = null, $voucher_status = null) {
        //Configure::write('debug',2);
        $this->layout = 'employee-new';
        $auth = $this->Session->read('Auth');
        $orgID = $auth['MyProfile']['comp_code'];
        $empID = $auth['MyProfile']['emp_code'];


        if ($from_date != 'null' && $end_date != 'null') {
            $ORconditions['jour_start_date between ? and ?'] = array($from_date, $end_date);
        }
        if ($from_date != 'null' && $end_date != 'null') {
            $ORconditions['jour_end_date between ? and ?'] = array($from_date, $end_date);
        }

        if ($voucher_status != 'null') {
            $ORconditions['status'] = $voucher_status;
        }

        $ORconditions['comp_code'] = $orgID;
        $ORconditions['emp_code'] = $empID;
        $conditions = array($ORconditions);

        $VoucherDetails = $this->LtaBillAmount->find('all', array(
            'fields' => array('*'),
            //'limit' => 10,
            //'order' => array('DtTravelVoucher.voucher_id  DESC'),
            'conditions' => $conditions
                //'order'=>array('LvMstId.id desc')
        ));

        App::import('Vendor', 'TCpdf', array('file' => 'mpdf60/mpdf.php'));
        $this->layout = 'pdf';
        $this->set('pdf', new mPDF('utf-8', array(350, 500)));
        $this->set('VoucherDetails', $VoucherDetails);
    }

}
