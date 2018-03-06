<?php

/* 
  * Property of Eastern Software Systems Pvt. Ltd.
  * Should be modified on by a Cake PHP Professional
  *  ******************************************************************************
  *  Description of Salaries_controller.php
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


App::uses('AppController', 'Controller');

class SalariesController  extends AppController {
    var $name = 'Salary';
    var $uses = array('OracleHcmItProc','MstLogo', 'UserDetail','myprofile','SalaryDetail','SalaryProcessing','SalaryProcessingAddition','SalaryProcessingDeduction');
    public $helpers = array('Js', 'Html','Form', 'Session', 'Common');
    public $components = array('Auth', 'Session', 'Email', 'Cookie', 'RequestHandler', 'EmpDetail');
    
    
    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow();
        $currentUser = $this->checkUser();
        $this->layout = 'employee-new';
        

    }

    public function index() {
        $months = array(
          '1' => 'January',
          '2' => 'February',
          '3' => 'March',
          '4' => 'April',
          '5' => 'May',
          '6' => 'June',
          '7' => 'July',
          '8' => 'August',
          '9' => 'September',
          '10' => 'October',
          '11' => 'November',
          '12' => 'December',
        );
        $myprofile = $this->MyProfile->find('first',array('fields'=>array('doc_id'),'conditions'=>array('emp_id'=>$this->Auth->User('emp_id'))));
        $max_proc_dt = $this->SalaryProcessing->find('first',array('fields'=>array('month(max(proc_frm_dt)) as maxmonth'),'conditions'=>array('emp_doc_id'=>$myprofile['MyProfile']['doc_id'])));
        $years = array('2016'=>'2016','2017'=>'2017','2018'=>'2018','2019'=>'2019');
        $this->set('maxmonth',$max_proc_dt[0]['maxmonth']);
        $this->set('months',$months);
        $this->set('years',$years);
        $this->layout = 'employee-new';
    }

    public function add() {
        print_r($this->request->data);
        exit();
    }

    public function process_salary($emp_code, $from_date = null) {
        $this->autoRender = false;
        $user_detail = $this->EmpDetail->getemployeeinfomation($emp_code);
        $data['org_id'] = $user_detail['MyProfile']['comp_code'];
        $data['emp_code'] = $emp_code;
        $data_for_addition = array();
        $data_for_deduction = array();
        $tot_earning_arr = array();
        $tot_deduction_arr = array();
        $sal_details_earnings = $this->SalaryDetail->find('all',array(
            'conditions' => array(
                'emp_id' => $emp_code,
                'sal_behav != ' => '10'
                )
            ));
        $tot_earnings = 0;
        $ctr = 0;
        foreach ($sal_details_earnings as $key => $value) {
            if($value['SalaryDetail']['sal_val']) {
                $tot_earnings += $value['SalaryDetail']['sal_amt'];
                $tot_earning_arr[$ctr]['sal_amt'] = $value['SalaryDetail']['sal_amt'];
            }
            else {
                $val = $this->SalaryDetail->findById($value['SalaryDetail']['ref_sal_id']);
                if($value['SalaryDetail']['sal_amt']) {
                    $amt = $value['SalaryDetail']['sal_amt'];
                    }
                else {
                   $amt = ($value['SalaryDetail']['sal_perc_val'] / 100 ) * $val['SalaryDetail']['sal_val']; 
                }
                $tot_earnings += $amt;
                $tot_earning_arr[$ctr]['sal_amt'] = $amt;
            } 
            $tot_earning_arr[$ctr]['sal_id'] = $value['SalaryDetail']['sal_id'];
            $ctr++;
        }
        $sal_details_ded = $this->SalaryDetail->find('all',array(
            'conditions' => array(
                'emp_id' => $emp_code,
                'sal_behav' => '10'
                )
            ));
        $tot_deductions = 0;
        $ctr = 0;
        foreach ($sal_details_ded as $key => $value) {
            if($value['SalaryDetail']['sal_val']) {
                $tot_deductions += $value['SalaryDetail']['sal_amt'];
                $tot_deduction_arr[$ctr]['sal_amt'] = $value['SalaryDetail']['sal_amt'];
            }
            else {
                $val = $this->SalaryDetail->findById($value['SalaryDetail']['ref_sal_id']);
                if($value['SalaryDetail']['sal_amt']) {
                    $amt = $value['SalaryDetail']['sal_amt'];
                    }
                else {
                   $amt = ($value['SalaryDetail']['sal_perc_val'] / 100 ) * $val['SalaryDetail']['sal_val']; 
                }
                $tot_deductions += $amt;
                $tot_deduction_arr[$ctr]['sal_amt'] = $amt;
            } 
            $tot_deduction_arr[$ctr]['sal_id'] = $value['SalaryDetail']['sal_id'];
            $ctr++;
        }
        $total_sal = $tot_earnings - $tot_deductions;
        $data['tot_earn'] = $tot_earnings;
        $data['tot_ded'] = $tot_deductions;
        $data['tot_sal_amt'] = $total_sal;
        if($from_date != null) {
            $data['proc_frm_dt'] = date('Y-m-d',strtotime($from_date));
            $data['proc_to_dt'] = date('Y-m-d',strtotime('+1 month -1 day', strtotime($from_date)));
        }
        else {
            $data['proc_frm_dt'] = date('Y-m-d');
            $data['proc_to_dt'] = date('Y-m-d',strtotime('+1 month -1 day', strtotime(date('Y-m-d'))));
        }
        $data1['SalaryProcessing'] = $data;
        $this->SalaryProcessing->save($data1);
        $save_id = $this->SalaryProcessing->getLastInsertId();
        $data['employee_sal_proc_sal_id'] = $save_id;
        foreach ($tot_earning_arr as $key => $value) {
            $this->SalaryProcessingAddition->create();
            $data_ear['SalaryProcessingAddition']['employee_sal_proc_sal_id'] = $save_id ;
            $data_ear['SalaryProcessingAddition']['proc_frm_dt'] = date('Y-m-d',strtotime($data['proc_frm_dt'] ));
            $data_ear['SalaryProcessingAddition']['proc_to_dt'] = date('Y-m-d',strtotime($data['proc_to_dt'])) ;
            $data_ear['SalaryProcessingAddition']['org_id'] = $data['org_id'] ;
            $data_ear['SalaryProcessingAddition']['emp_code'] = $data['emp_code'] ;
            $data_ear['SalaryProcessingAddition']['sal_id'] = $value['sal_id'] ;
            $data_ear['SalaryProcessingAddition']['sal_amt'] = $value['sal_amt'] ;
            $this->SalaryProcessingAddition->save($data_ear);
        }
    }

    public function get_salary() {
        $logo = $this->MstLogo->find('first');
        $this->set('logo', $logo['MstLogo']['logo_file']);
        $months = array(
          '1' => 'January',
          '2' => 'February',
          '3' => 'March',
          '4' => 'April',
          '5' => 'May',
          '6' => 'June',
          '7' => 'July',
          '8' => 'August',
          '9' => 'September',
          '10' => 'October',
          '11' => 'November',
          '12' => 'December',
        );
        App::import('Vendor', 'TCpdf', array('file' => 'mpdf60/mpdf.php'));
        $user_detail = $_SESSION['Auth']['MyProfile'];
        $portal_app_eo = new Model(array('table' => 'oracle_app_eo', 'ds' => 'default', 'name'=> 'OracleAppEo'));
        $bank = $portal_app_eo->find('first',array('conditions'=>array('eo_id' => $user_detail['bank_code'])));
        $this->set('bank',$bank['OracleAppEo']['eo_alias']);
        $data = $this->request->data;
        $this->layout = 'pdf';
        $salary_date = strtotime($data['Salary']['year'].'-'.$data['Salary']['month']);
        $proc_date = date('Y-m-d',$salary_date);
        $ord = '-seq_no desc';
        $doc_id = $user_detail['doc_id'];
        $emp_code = $user_detail['emp_code'];
        $q="SELECT distinct `orahcmsal`.`seq_no`, `SalaryProcessingAddition`.*, `ot`.`name` FROM employee_sal_proc_sal AS `SalaryProcessingAddition` LEFT JOIN option_attribute AS `OptionAttribute` ON (`SalaryProcessingAddition`.`sal_id` = `OptionAttribute`.`id`) INNER JOIN oracle_org_hcm_salary AS `orahcmsal` ON (`orahcmsal`.`sal_id` = `SalaryProcessingAddition`.`sal_id`) INNER JOIN option_attribute AS `ot` ON (`ot`.`id` = `SalaryProcessingAddition`.`sal_id`) WHERE `SalaryProcessingAddition`.`proc_frm_dt` = '$proc_date' AND `SalaryProcessingAddition`.`emp_doc_id` = '$doc_id' AND `SalaryProcessingAddition`.`sal_behav` != 10 AND `orahcmsal`.`org_id` = 1 and ot.options_id=22 ORDER BY -`seq_no` desc ";
        $db = ConnectionManager::getDataSource('default');
        $earnings = $db->query($q);
		
		$arrear = "SELECT arr.* ,op.name FROM `emp_incr_arr` as arr inner join option_attribute as op on op.id=arr.sal_id WHERE `emp_code`=$emp_code AND `incr_dt` = '$proc_date' and arr_amt>0 and op.options_id=22";
        $arr=$db->query($arrear);
		
		$data_oracle_done = new Model(array('table' => 'hcmempmonextdtl', 'ds' => 'default', 
		'name' => 'HCMEMP'));
		//Configure::write('debug',2);
		$additional_add1 = $data_oracle_done->find('first',array(
			'fields'=>array('ext_time_amt'),
            'conditions' =>array(
                'proc_frm_dt' => $proc_date,
                'emp_doc_id'=>$user_detail['doc_id'],
				'rule_type'=>60
                )
            ));
		$additional_add2 = $data_oracle_done->find('all',array(
			'fields'=>array('ext_time_amt','rule_type'),
            'conditions' =>array(
                'proc_frm_dt' => $proc_date,
                'emp_doc_id'=>$user_detail['doc_id'],
				)
            ));
		$extra1 = $additional_add1['HCMEMP']['ext_time_amt'];
		$extra2 = $additional_add2['HCMEMP']['ext_time_amt'];
		$amt_extra_hrs = array($extra1,$extra2);
		$ear_cnt = count($earnings);
		//print_r($additional_add2); die;
		foreach($additional_add2 as $ad){
		$earnings[$ear_cnt]['SalaryProcessingAddition']['sal_amt'] = $ad['HCMEMP']['ext_time_amt'];
		if($ad['HCMEMP']['rule_type'] == 60){
			$extra1 = 'Normal Overtime @ 1.5 Hrs';
			} else {
			$extra1 = 'Normal Overtime @ 2 Hrs';
			}
			$earnings[$ear_cnt]['ot']['name'] = $extra1;
			$ear_cnt++;
		}
		
		
		$temp_ded = $this->SalaryProcessingAddition->find('all',array(
            'conditions' =>array(
                'SalaryProcessingAddition.proc_frm_dt' => $proc_date,
                'SalaryProcessingAddition.emp_doc_id'=>$user_detail['doc_id'],
                'SalaryProcessingAddition.sal_behav'=>10,
                )
            ));
            
        $allowances = $this->SalaryProcessingAddition->find('all',array(
            'conditions' =>array(
                'SalaryProcessingAddition.proc_frm_dt' => $proc_date,
                'SalaryProcessingAddition.emp_doc_id'=>$user_detail['doc_id'],
                'SalaryProcessingAddition.sal_behav'=>12,
                )
            ));

        $ded_monthly = $this->SalaryProcessingAddition->find('all',array(
            'conditions' =>array(
                'SalaryProcessingAddition.proc_frm_dt' => $proc_date,
                'SalaryProcessingAddition.emp_doc_id'=>$user_detail['doc_id'],
                'SalaryProcessingAddition.sal_behav'=>10,
                )
            ));
            
       $deductions = $this->SalaryProcessingDeduction->find('all',array(
            
            'conditions' =>array(
                'SalaryProcessingDeduction.proc_frm_dt' => $proc_date,
                'SalaryProcessingDeduction.emp_doc_id'=>$user_detail['doc_id'],
                ),
            'joins' =>array(
                array(
                 'table' => 'hcm_ded',
                'alias' => 'HcmDed',
                'type' => 'LEFT',
                'conditions' =>array(
                    'HcmDed.doc_id = SalaryProcessingDeduction.ded_doc_id'
                    )

                    ), 
                array(
                 'table' => 'oracle_hcm_emp_loan',
                'alias' => 'Loan',
                'type' => 'LEFT',
                'conditions' =>array(
                    'Loan.doc_id = SalaryProcessingDeduction.ded_doc_id'
                    )

                    ), 
                array(
                 'table' => 'option_attribute',
                'alias' => 'OA',
                'type' => 'LEFT',
                'conditions' =>array(
                    'OA.id = Loan.loan_id'
                    )

                    ), 
                
                ),
            'fields' => array(
                'SalaryProcessingDeduction.*',
                'HcmDed.*','OA.name'
                ),
            'order'=>array('SalaryProcessingDeduction.id DESC')
            ));
       
                    $cnt = 0;
			foreach($deductions as $ded){
				$cnt++;
				if($ded['HcmDed']['ded_desc'] == 'PF' && $ded['SalaryProcessingDeduction']['vpf'] != ''){
					$vpf_amt = $ded['SalaryProcessingDeduction']['vpf'];
					$flag = 1;
				}
			}
			if($flag == 1){
				$deductions[$cnt+1]['SalaryProcessingDeduction']['ded_amt'] = $vpf_amt;
				$deductions[$cnt+1]['HcmDed']['ded_desc'] = 'VPF';
				//$deductions[$i]['OA']['name'] 
			}
			//echo "<pre>"; print_r($deductions); die;
       
       
        $leaves = $this->MstEmpLeaveAllot->find('all',array(
            'conditions' =>array(
                'MstEmpLeaveAllot.emp_code'=>$user_detail['emp_code'],
                ),
            'fields' => array('MstEmpLeaveAllot.*','OptionAttribute.*'),
            'joins' =>array(
                array(
                    'table' => 'option_attribute',
                    'alias' => 'OptionAttribute',
                    'type' =>'LEFT',
                    'conditions' => array(
                        'MstEmpLeaveAllot.leave_code = OptionAttribute.id'
                    )
                ))
            ));
        $salary_details = $this->SalaryProcessing->find('first',array(
            'conditions' =>array(
                'proc_frm_dt' => $proc_date,
                'emp_doc_id'=>$user_detail['doc_id']
                )
            ));

        if(empty($salary_details)) {
            $this->Session->setFlash('No data found');
            $this->redirect(array('action'=>'index'));
        }
        $balances = $this->OracleHcmItProc->find('first',array(
        'conditions' => array(
        'emp_doc_id' => $user_detail['doc_id'],
                        'proc_frm_dt' => $proc_date,
            )
        ));
        $this->set('balances', $balances['OracleHcmItProc']);
        $this->set('pdf', new mPDF('utf-8', array(350,500)));
        $this->set('monthYear', strtoupper($months[$data['Salary']['month']]).'-'.$data['Salary']['year']);
        $user_detail['dob'] = date('d-m-Y',strtotime($user_detail['dob'] ));
        $user_detail['join_date'] = date('d-M-Y',strtotime($user_detail['join_date'] ));
        $this->set('user_detail',$user_detail);
        $this->set('location',$this->EmpDetail->getOptionName($user_detail['location_code']));
        $this->set('temp_ded',$temp_ded);
        $this->set('designation',$this->EmpDetail->getOptionName($user_detail['desg_code']));
        $this->set('department',$this->EmpDetail->getdepartmentdetail());
        $this->set('group',$this->EmpDetail->getOptionName($user_detail['emp_grp_id']));
        $this->set('company_name',$this->EmpDetail->getCompanyName($user_detail['comp_code']));
        $p_date = date('F-Y',$salary_date);
        $cp_date = (str_replace('-', ' ', $p_date)); 
        $this->set('p_date',$cp_date);
        $this->set('earnings',$earnings);
        $this->set('leaves',$leaves);
        $this->set('allowances',$allowances);
        $this->set('deductions',$deductions);
        $this->set('arr',$arr);
        $this->set('ded_monthly',$ded_monthly);
        $this->set('salary_details',$salary_details['SalaryProcessing']);
    }

    
}


