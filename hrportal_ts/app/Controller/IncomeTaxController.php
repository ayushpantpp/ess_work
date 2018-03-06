<?php

/* 
  * Property of Eastern Software Systems Pvt. Ltd.
  * Should be modified on by a Cake PHP Professional
  *  ******************************************************************************
  *  Description of IncomeTax_controller.php
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
  *  project version: 0.1.0
  *  @author Ayush Pant <ayush.pant@essindia.com>
  *  @client company: Eastern Software Systems Pvt. Ltd. Expression project.user is undefined on line 21, column 73 in Templates/Licenses/license-default.txt.
  *  @date created: 2017
  *  @date last modified: Jun 28, 2011 2:59:31 PM
  *  ******************************************************************************
 */

class IncomeTaxController extends AppController {

    var $name = 'IncomeTax';
    var $layout = 'employee-new';
    public $components = array('Auth', 'Session', 'Email', 'Cookie', 'RequestHandler', 'Paginator','Common');
    var $uses = array('EmpInvest', 'WfMstAppMapLvl', 'FinancialYear', 'Options', 'OptionAttribute', 'EmpInvestDtl', 'SectDtl', 'InvestDtl', 'MyProfile');
    public $helpers = array('Js', 'Html', 'Form', 'Session', 'Userdetail');

    function beforeFilter() {
        parent::beforeFilter();
        $this->set('appId', 16);

        $this->Auth->allow();
	$currentUser = $this->checkUser();
    }

    public function initialize() {
        parent::initialize();
        $this->loadComponent('Paginator');
    }

    function incometax_declaration() {
		$comp_code = $this->Auth->user('comp_code');
        $this->layout = 'employee-new';
        $myprofile = $this->MyProfile->find('first', array('fields' => array('*'), 'conditions' => array('emp_code' => $this->Auth->User('emp_code'))));
        $currentdate = date('Y-m-d');
		$q = "SELECT `FinancialYear`.`id` FROM financial_year AS FinancialYear WHERE '$currentdate' BETWEEN hcm_fy_start and hcm_fy_end";
		$db = ConnectionManager::getDataSource('default');
        $myData = $db->query($q);
        $fy_id = $myData[0]['FinancialYear']['id'];
        $income_tax = $this->SectDtl->find('all', array(
            'fields' => array('SectDtl.id', 'op2.name', 'SectDtl.cptr_id', 'SectDtl.sect_id', 'SectDtl.fy_id'),
            'joins' => array(
                array(
                    'table' => 'option_attribute',
                    'alias' => 'op2',
                    'type' => 'inner',
                    'foreignKey' => false,
                    'conditions' => array('op2.id = SectDtl.cptr_id')
                )
            ),
            'conditions' => array('SectDtl.fy_id' => $fy_id)
        ));

        $incometax_dec = $this->EmpInvest->find('first', array('fields' => array('*'), 'conditions' => array('emp_code' => $this->Auth->User('emp_code'), 'Fy_id' => $fy_id)));

        //echo '<pre>';print_r($income_tax);die;

        $this->set('decleration', $incometax_dec);
        $this->set('financial', $fy_id);
        $this->set('myprofile', $myprofile);
        $this->set('investment', $income_tax);
    }

    public function add() {
		$this->layout = 'employee-new';
        $grp_id = $this->MyProfile->find('first', array('fields' => array('emp_grp_id', 'doc_id'), 'conditions' => array('emp_code' => $this->Auth->User('emp_code'), 'comp_code' => $this->Auth->User('comp_code'))));
		$ora_get_id = $this->FinancialYear->find('all',array('fields'=>array('ora_fy_id'),'conditions'=>array('id'=>$this->data['IncomeTax']['fy_id'])));
        if (!empty($this->data)) {
            $val_arr['comp_code'] = $this->Auth->User('comp_code');
            $val_arr['emp_code'] = $this->Auth->User('emp_code');
            $val_arr['Fy_id'] = $this->request->data['IncomeTax']['fy_id'];
			$val_arr['ora_fy_id'] = $ora_get_id[0]['FinancialYear']['ora_fy_id'];
            $val_arr['loc_type'] = $this->data['loc_type'];
            $val_arr['invest_status'] = 2;
            $val_arr['emp_doc_id'] = $grp_id['MyProfile']['doc_id'];
			$val_arr['org_id'] = $this->Auth->User('comp_code');

            $count = floor(count($this->request->data['IncomeTax']) / 2);

            if ($this->EmpInvest->save($val_arr)) {
                for ($i = 0; $i < $count; $i++) {
                    if ($val['invest_amt'] = $this->data['IncomeTax']['planned_' . $i] != '') {
                        $val = array();
                        $val['emp_invest_id'] = $this->EmpInvest->getLastInsertID();
                        $val['emp_code'] = $this->Auth->User('emp_code');
                        $val['org_id'] = $this->Auth->User('comp_code');
                        $val['fy_id'] = $this->data['IncomeTax']['fy_id'];
			


			$val['ora_fy_id'] = $ora_get_id[0]['FinancialYear']['ora_fy_id'];
                        $val['invest_doc_id'] = $this->request->data['IncomeTax']['Investment_' . $i];
                        $sect_id = $this->InvestDtl->find('first', array('fields' => array('sect_id'), 'conditions' => array('invest_id' => $this->request->data['IncomeTax']['Investment_' . $i])));
                        $val['sect_id'] = $sect_id['InvestDtl']['sect_id'];
                        $val['invest_id'] = $this->request->data['IncomeTax']['Investment_' . $i];
                        $val['invest_amt'] = $this->data['IncomeTax']['planned_' . $i];
                        $val['actual_amt'] = $this->data['IncomeTax']['planned_' . $i];
                        $val['invest_status'] = 2;
                        $val['emp_doc_id'] = $grp_id['MyProfile']['doc_id'];
                        $val['approver_id'] = 209;
                        $this->EmpInvestDtl->create();
                        $this->EmpInvestDtl->save($val);
                        unset($val);
                    } else {
                        
                    }
                }

               
            }
$this->Session->setFlash("<div data-uk-alert='' class='uk-alert uk-alert-success'><a class='uk-alert-close uk-close' href='#'></a>Incometax declared successfully</div>");
                $this->redirect('/income_tax/view');
        }
 
    }

    public function view() {
        $this->layout = 'employee-new';
        $this->paginate = array(
            'fields' => array('*'),
            'limit' => 5,
            'conditions' => array('emp_code' => $this->Auth->User('emp_code'))
        );
        //$incometax = $this->EmpInvest->find('all',array('fields'=>array('*'),'conditions'=>array('emp_code'=>$this->Auth->User('emp_code'))));
        $incometax = $this->paginate('EmpInvest');

        $hrapproval = $this->WfMstAppMapLvl->find('first', array('fields' => array('wf_hr_approval'), 'conditions' => array('wf_app_id' => 16)));
        //print_r($hrapproval);die;
        $this->set('hrapproval', $hrapproval);
        $this->set('incometax', $incometax);
    }

    public function detailView($id) {
        $this->layout = false;
        $incometax = $this->EmpInvestDtl->find('all', array('fields' => array('*'), 'conditions' => array('emp_invest_id' => $id)));
        $this->set('incometax', $incometax);
    }

    public function saveinfo($invest_id) {
        $this->autoload = false;
        $invest_id = base64_decode($invest_id);
        $lv_app = $this->EmpInvestDtl->updateAll(
                array('EmpInvestDtl.invest_status' => '5'), array('EmpInvestDtl.emp_invest_id' => $invest_id)
        );
        $lv_app = $this->EmpInvest->updateAll(
                array('EmpInvest.invest_status' => '5'), array('EmpInvest.id' => $invest_id)
        );
        $this->Session->setFlash("<div data-uk-alert='' class='uk-alert uk-alert-success'><a class='uk-alert-close uk-close' href='#'></a>Incometax Approved Sucessfully</div>");
        $this->redirect('/income_tax/approval');
    }

    public function reject($invest_id) {
        $this->autoload = false;
        $invest_id = base64_decode($invest_id);
        $lv_app = $this->EmpInvestDtl->updateAll(
                array('EmpInvestDtl.invest_status' => '4'), array('EmpInvestDtl.emp_invest_id' => $invest_id)
        );
        $lv_app = $this->EmpInvest->updateAll(
                array('EmpInvest.invest_status' => '4'), array('EmpInvest.id' => $invest_id)
        );
        $this->Session->setFlash("<div data-uk-alert='' class='uk-alert uk-alert-danger'><a class='uk-alert-close uk-close' href='#'></a>Incometax rejected sucessfully</div>", false, array('class' => 'flash flash_error'));
        $this->redirect('/income_tax/approval');
    }

    public function hrView($slug) {
		$this->layout = 'employee-new';
        $fy_year = $this->data['fy']['fy_year'];

        if ($_GET['page'] != "") {
            $fy_year = $_GET['slug'];
        }

	$get_val = $this->FinancialYear->find('first',array('conditions'=>array('id'=>$fy_year)));//print_r($get_val);
	$this->set('fin_check',$get_val['FinancialYear']['status']);
        try {
            $this->paginate = array(
                'fields' => array('*'),
                'limit' => 20,
                'conditions' => array('fy_id' => $fy_year),
                'paramType' => 'querystring'
            );
            $incometax = $this->paginate('EmpInvest');

        } catch (Exception $e) {
            
        }

        //$incometax = $this->EmpInvest->find('all',array('fields'=>array('*')));
        // print_r($incometax);die;
        // $incometax=$this->paginate($incometax);
//die;
        $this->set('incometax', $incometax);
        $this->set('fy_year', $fy_year);
    }

    public function approval() {
        $this->layout = 'employee-new';
        $emp = $this->EmpInvestDtl->find('all', array('fields' => array('*'), 'conditions' => array('approver_id' => $this->Auth->User('emp_code'), 'invest_status' => 2), 'group' => array('emp_invest_id')));
        $this->set('list', $emp);
    }

    public function edit($id, $fy_id) {

        $this->layout = 'employee-new';
        $investid = base64_decode($id);
        $fyid = base64_decode($fy_id);
        $myprofile = $this->MyProfile->find('first', array('fields' => array('*'), 'conditions' => array('emp_code' => $this->Auth->User('emp_code'))));
        //$financial = $this->FinancialYear->find('list',array('fields'=>array('id','fy_year')));
        //print_r($financial);die;
        $income_tax = $this->SectDtl->find('all', array(
            'fields' => array('SectDtl.id', 'op2.name', 'SectDtl.cptr_id', 'SectDtl.sect_id', 'SectDtl.fy_id'),
            'joins' => array(
                array(
                    'table' => 'option_attribute',
                    'alias' => 'op2',
                    'type' => 'inner',
                    'foreignKey' => false,
                    'conditions' => array('op2.id = SectDtl.cptr_id')
                ),
            ),
            'conditions' => array('SectDtl.fy_id' => $fyid
            )
        ));

	$investid_det = $this->EmpInvest->find('all', array(
            'fields' => array('EmpInvest.loc_type'),
            'conditions' => array('EmpInvest.id' => $investid)
        ));

//echo '<pre>';print_r($income_tax);die;
        //$this->set('financial',$financial);
        $this->set('myprofile', $myprofile);
        $this->set('investment', $income_tax);
        //$incometax = $this->EmpInvestDtl->find('all',array('fields'=>array('*'),'conditions'=>array('emp_invest_id'=>$investid)));

        $this->set('empinvestid', $investid);
	$this->set('empinvestid_loc', $investid_det[0]['EmpInvest']['loc_type']);
    }

    public function editHr($id) {
        $this->layout = 'employee-new';
        $investid = base64_decode($id);
        $incometax = $this->EmpInvestDtl->find('all', array('fields' => array('*'), 'conditions' => array('emp_invest_id' => $investid)));
        $this->set('count', count($incometax));
        $this->set('incometax', $incometax);
	
    }

    public function editsaveinfo() {

        $count = floor(count($this->request->data['IncomeTax']) / 2);
        $grp_id = $this->MyProfile->find('first', array('fields' => array('emp_grp_id', 'doc_id'), 'conditions' => array('emp_code' => $this->Auth->User('emp_code'), 'comp_code' => $this->Auth->User('comp_code'))));
        $emp_invest['id'] = $this->data['lastempinvest'];
        $emp_invest['invest_status'] = 2;
	$emp_invest['loc_type'] = $this->data['loc_type'];
 echo '<pre>'; print_r($this->data);          
        
        $this->EmpInvest->save($emp_invest);
        if (!empty($this->data)) {
            for ($i = 0; $i < $count; $i++) {
              
                if ( $this->data['IncomeTax']['empinvest_' . $i] != '') {

                    if ($this->data['IncomeTax']['empinvest_' . $i]) {

                        $val = array();
                        $val['id'] = $this->data['IncomeTax']['empinvest_' . $i];
                        $val['invest_amt'] = $this->data['IncomeTax']['planned_' . $i];
                        $val['actual_amt'] = $this->data['IncomeTax']['actual_' . $i];
                       // echo $i;
 //print_r($val);
                        $this->EmpInvestDtl->save($val);
                        unset($val);
                    } else {

                        $val = array();
                        $val['emp_invest_id'] = $this->data['lastempinvest'];
                        $val['emp_code'] = $this->Auth->User('emp_code');
                        $val['org_id'] = $this->Auth->User('comp_code');
                        $val['fy_id'] = $this->Common->findfy_id(date('Y-m-d'));
                        $ora_get_id = $this->FinancialYear->find('all',array('fields'=>array('ora_fy_id'),'conditions'=>array('org_id'=>$this->Auth->User('comp_code'),'id'=>$val['fy_id'])));
                        $val['ora_fy_id'] = $ora_get_id[0]['FinancialYear']['ora_fy_id'];
                        $val['invest_doc_id'] = $this->request->data['IncomeTax']['Investment_' . $i];
                        $sect_id = $this->InvestDtl->find('first', array('fields' => array('sect_id'), 'conditions' => array('invest_id' => $this->request->data['IncomeTax']['Investment_' . $i])));
                        $val['sect_id'] = $sect_id['InvestDtl']['sect_id'];
                        $val['invest_id'] = $this->request->data['IncomeTax']['Investment_' . $i];
                        $val['invest_amt'] = $this->data['IncomeTax']['planned_' . $i];

                        $val['actual_amt'] = $this->data['IncomeTax']['actual_' . $i];
                        $val['invest_status'] = 2;
                        $val['emp_doc_id'] = $grp_id['MyProfile']['doc_id'];
                        $val['approver_id'] = 209;
//print_r($val);
                        $this->EmpInvestDtl->create();
                        $this->EmpInvestDtl->save($val);
                        unset($val);
                    }
                } else {
                    
                }

            }
//die;
            $this->Session->setFlash("<div data-uk-alert='' class='uk-alert uk-alert-success'><a class='uk-alert-close uk-close' href='#'></a>Incometax Edited successfully</div>");
            $this->redirect('/income_tax/view');
        }
    }

    public function edithrsaveinfo() {

        if (!empty($this->data)) {

            for ($i = 0; $i < $this->data['IncomeTax']['count']; $i++) {
                $val = array();
                $val['id'] = $this->data['IncomeTax']['invest_id_' . $i];
                $val['invest_amt'] = $this->data['IncomeTax']['planned_' . $i];
                $val['actual_amt'] = $this->data['IncomeTax']['actual_' . $i];
                $this->EmpInvestDtl->save($val);
                unset($val);
            }

            $this->Session->setFlash("<div data-uk-alert='' class='uk-alert uk-alert-success'><a class='uk-alert-close uk-close' href='#'></a>Incometax Edited successfully</div>");
            $this->redirect('/income_tax/view');
        }
    }

    public function Configure($id) {
        $investid = base64_decode($id);
        //update configure coloum value
        $lv_app = $this->EmpInvest->updateAll(
                array('EmpInvest.config' => 1), array('EmpInvest.id' => $investid)
        );
	$this->Session->setFlash("<div data-uk-alert='' class='uk-alert uk-alert-success'><a class='uk-alert-close uk-close' href='#'></a>Incometax Decleration form has been enabled Sucessfully</div>");
        $this->redirect('/income_tax/investment_financial');
    }

    public function ReConfigure($id) {
        $investid = base64_decode($id);
        //update configure coloum value
        $lv_app = $this->EmpInvest->updateAll(
                array('EmpInvest.config' => 0), array('EmpInvest.id' => $investid)
        );

        $this->Session->setFlash("<div data-uk-alert='' class='uk-alert uk-alert-success'><a class='uk-alert-close uk-close' href='#'></a>Incometax Decleration form has been disabled Sucessfully</div>");
        $this->redirect('/income_tax/investment_financial');
    }

    public function editConfig() {
        $this->autoload = false;
        if ($this->request->is('post') && !empty($this->request->data)) {
            if ($this->data['settingsave'] == 'Enable') {
                $data = $this->request->data['pending_docs'];
                if (!empty($data)) {
                    foreach ($data as $key => $value) {
                        if ($value == 1) {
                            $this->EmpInvest->id = $this->request->data['pending_docs_vl'][$key];
                            $this->EmpInvest->saveField('config', 1);
                        }
                    }
		    $this->Session->setFlash("<div data-uk-alert='' class='uk-alert uk-alert-success'><a class='uk-alert-close uk-close' href='#'></a>IncomeTax Declaration Form Enabled</div>");
                    $this->redirect('investment_financial');
                }
            } else {
                $data = $this->request->data['pending_docs'];
                if (!empty($data)) {
                    foreach ($data as $key => $value) {
                        if ($value == 1) {
                            $this->EmpInvest->id = $this->request->data['pending_docs_vl'][$key];
                            $this->EmpInvest->saveField('config', 0);
                        }
                    }
                    $this->Session->setFlash("<div data-uk-alert='' class='uk-alert uk-alert-success'><a class='uk-alert-close uk-close' href='#'></a>IncomeTax Declaration Form Disabled</div>");
                    $this->redirect('investment_financial');
                }
            }
        }
    }

    function investment_financial() {
        $this->layout = 'employee-new';
        $org_id = '01';
        $fy = $this->FinancialYear->find('list', array('fields' => array('id', 'fy_desc'),'conditions'=>array('org_id'=>$org_id),'order' => 'id desc'));
        $this->set('financialYear', $fy);
    }

}
