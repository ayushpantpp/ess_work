<?php
App::import('phpexcel');
ob_start();
/*
 * Property of Eastern Software Systems Pvt. Ltd.
 * Should be modified on by a Cake PHP Professional
 */

/**
 * ******************************************************************************
 * Description of empcomplaint_controller.php
 * ******************************************************************************
 * file (empcomplaint_controller.php) version: 0.1.0
 * file description: Cake PHP Controller file for manupilating complaint data
 * file change log:
 *                          created by Anshuk Kumar <anshuk-kumar at essindia.co.in>
 *                          Jun 28, 2011 2:59:31 PM Created controller, and actions add | edit | view | delete.
 *                          changed by <user>
 *                          <date> <time> <changed-action-name> <change-description> 
 * 
 * ******************************************************************************
 * project: EssPortal
 * project version: 0.1.0
 * @author Anshuk Kumar <anshuk-kumar at essindia.co.in>
 * @client company: Eastern Software Systems Pvt. Ltd.
 * @date created: Jun 28, 2011 2:59:31 PM
 * @date last modified: Jun 28, 2011 2:59:31 PM
 * ****************************************************************************** 
 */
class EmpcomplaintController extends AppController {

    var $name = 'Empcomplaint';
    //var $uses = array('Empcomplaint', 'Projects', 'General', 'Employees', 'Customers', 'EmpcomplaintAnnotations', 'ComplainEmployees', 'ProjectsEmployees', 'ZonesEmployees');
     var $uses = array('Empcomplaint', 'Projects', 'General', 'Employees', 'Customers', 'EmpcomplaintAnnotations', 'ComplainEmployees', 'ProjectsEmployees', 'ZonesEmployees',
                       'Customerdetails','Mstcomplaintmaster','Mstcomplaintmastervalue', 'Complaints', 'MstCustomerLoc','Mstcomplaintcustomer');
    var $helpers= array('Complaindetail');//projectcheck
     var $paginate = array(
        'limit' => 10,
        'order' => array(
            'vc_complain_no' => 'desc'
        )
    );

    function beforeFilter() {
        /**
         * **********************************************************************
         * Executed before any action of complaint ms 
         * **********************************************************************
         */
        //Calling App Controller's before filter
        parent::beforeFilter();
		$this->layout = 'employee';
        //Email Settings
        $this->Email->from = 'ESS Support <support@essindia.com>';
        //Check whether a user is Customer / Employee
        //based on which he will be authenticated and authorised
		 $this->Auth->allow('*');
       /* if ($this->Session->read('Auth.user_type') == 'Customers') {
            $this->layout = 'customer';
            $this->Auth->allow('add', 'type', 'typeListHtml', 'view', 'prAddJson', 'index', 'prListHtml');
        } else {
            $this->layout = 'employee';
        }*/
    }

    function isReportManager() {
        
    }

    function index() {
		
        /**
         * **********************************************************************
         * The index or the main page of Complaint MS. This shows the list of 
         * complaints which the customer has made if he is a customer or list
         * of complaints of porjects which he is a member of or zonal manager of.
         * **********************************************************************
         */
        try {
		
            /**
             * ************************************************************************
             * INPUT authentication check, autorization check, validation check,
             * data purging, variable initialization
             * ************************************************************************
             */
            /**
             * ************************************************************************
             * PROCESS 
             * ************************************************************************
             */
            /**
             * ************************************************************************
             * OUTPUT set output header, variable destruction, set layout, set view 
             * ************************************************************************
             */
        } catch (Exception $e) {
            /**
             * ************************************************************************
             * OUTPUT ERROR set output header, variable destruction, set layout, set view
             * ************************************************************************
             */
        }
    }


	function lists($tp=null) {
		
		


	}

		


    function typeListHtml($STRUCT_CODE) {
        /**
         * **********************************************************************
         * Returns html list of sub-type of complaint based on their type.
         * **********************************************************************
         */
        try {
            /**
             * ************************************************************************
             * INPUT authentication check, autorization check, validation check,
             * data purging, variable initialization
             * ************************************************************************
             */
            /**
             * ************************************************************************
             * PROCESS 
             * ************************************************************************
             */
            $options = $this->General->query("SELECT DISTINCT 
                NU_DT_COMPLAINT_ID, VC_DT_COMPLAINT_DESC 
                FROM makess.dt_complaint_type WHERE NU_COMPLAINT_ID='" . $STRUCT_CODE . "' and ch_active_flag='Y'");

            /**
             * ************************************************************************
             * OUTPUT set output header, variable destruction, set layout, set view 
             * ************************************************************************
             */
            $this->layout = '';
            $this->autoRender = false;
            echo "<OPTION>";
            echo "--Select appropriate problem--";
            echo "</OPTION>";
            foreach ($options as $option) {
                echo "<OPTION VALUE='{$option[0]['NU_DT_COMPLAINT_ID']}'>";
                echo $option[0]['VC_DT_COMPLAINT_DESC'];
                echo "</OPTION>";
            }
        } catch (Exception $e) {
            /**
             * ************************************************************************
             * OUTPUT ERROR set output header, variable destruction, set layout, set view
             * ************************************************************************
             */
        }
    }

    function prListHtml($mgr=null) {
        /**
         * **********************************************************************
         * Returns html list of complaints for zonal managers, project managers
         * Teamleads / Project Leads, Engineers and customers.
         * **********************************************************************
         */
        try {
            /**
             * ************************************************************************
             * INPUT authentication check, autorization check, validation check,
             * data purging, variable initialization
             * ************************************************************************
             */
            /**
             * ************************************************************************
             * PROCESS 
             * ************************************************************************
             */
            
            
            
            $this->set('mgr',$mgr);
            $conditions = array();
            if (!empty($this->data)) {
                $this->redirect($this->data['Empcomplaint'], null, true);
            }
            //$this->data['Complaints'] = 
            if (!empty($this->passedArgs['priority'])) {
                $conditions['vc_priority'] = $this->passedArgs['priority'];
            }
            if (!empty($this->passedArgs['stage'])) {
                $conditions['vc_stage'] = $this->passedArgs['stage'];
            }
            if (!empty($this->passedArgs['startdate'])) {
                $conditions['dt_complain_date >='] = $this->passedArgs['startdate'];
            }
            if (!empty($this->passedArgs['enddate'])) {
                $conditions['dt_complain_date <='] = $this->passedArgs['enddate'];
            }
            if (!empty($this->passedArgs['manager'])) {
               $this->set('mgr',$this->passedArgs['manager']);
            } else {
            if(empty($mgr)) {
            $conditions['vc_user_code'] = $this->Auth->user('vc_emp_id_makess');
            }
            }
        
           $this->paginate = array(
                               'conditions' => $conditions,
                               'limit' => 10,
				               'order' => array(
                                           'Empcomplaint.dt_complain_date' => 'desc'
                                   )
                             );
			$result= $this->paginate('Empcomplaint');
			
			$this->set('data',$result);
        } catch (Exception $e) {
            /**
             * ************************************************************************
             * OUTPUT ERROR set output header, variable destruction, set layout, set view
             * ************************************************************************
             */
        }
    }



function listss($tp=null) {
		if(!empty($tp)) {
			$tp=str_replace('-',' ',$tp);
			$res=$this->General->query($tp);
			echo json_encode($res);
			exit;
		} else {
        $this->redirect('/');
		}
	}


    function prReportListHtml() {
        /**
         * **********************************************************************
         * Generates reports in html format
         * **********************************************************************
         */
        try {
            /**
             * ************************************************************************
             * INPUT authentication check, autorization check, validation check,
             * data purging, variable initialization
             * ************************************************************************
             */
            /**
             * ************************************************************************
             * PROCESS 
             * ************************************************************************
             */
             $conditions = array();
         
                if (!empty($this->data)) {
                $this->passedArgs = $this->data['Complaints'];
            }
         
             if (!empty($this->passedArgs['period'])) {
                $conditions['dt_complain_date >='] = $this->passedArgs['period'];
                $conditions['dt_complain_date <='] = date('Y-m-d');
            }
            if (!empty($this->passedArgs['projects'])) {
                $conditions['vc_user_code'] = $this->passedArgs['projects'];
            }
            if (!empty($this->passedArgs['fromDate'])) {
                $conditions['dt_complain_date >='] = $this->passedArgs['fromDate'];
            }
            if (!empty($this->passedArgs['toDate'])) {
                $conditions['dt_complain_date <='] = $this->passedArgs['toDate'];
            }
			/*if(empty($mgr)) {
			$conditions['vc_user_code'] = $this->Auth->user('vc_emp_id_makess');
			}*/
           $this->paginate = array(
                               'conditions' => $conditions,
                               'limit' => 10,
				               'order' => array(
                                           'Empcomplaint.dt_complain_date' => 'desc'
                                   )
                             );
			$result= $this->paginate('Empcomplaint');
		
            /**
             * ************************************************************************
             * OUTPUT set output header, variable destruction, set layout, set view 
             * ************************************************************************
             */
            $this->layout = '';
            $this->set('data', $result);
        } catch (Exception $e) {
            /**
             * ************************************************************************
             * OUTPUT ERROR set output header, variable destruction, set layout, set view
             * ************************************************************************
             */
        }
    }

    function prReportListXls() {
        /**
         * **********************************************************************
         * Generates reports in Excel format
         * **********************************************************************
         */
        try {
            /**
             * ************************************************************************
             * INPUT authentication check, autorization check, validation check,
             * data purging, variable initialization
             * ************************************************************************
             */
            /**
             * ************************************************************************
             * PROCESS 
             * ************************************************************************
             */
           $conditions = array();
         
                if (!empty($this->data)) {
                $this->passedArgs = $this->data['Complaints'];
            }
         
             if (!empty($this->passedArgs['period'])) {
                $conditions['dt_complain_date >='] = $this->passedArgs['period'];
                $conditions['dt_complain_date <='] = date('Y-m-d');
            }
            if (!empty($this->passedArgs['projects'])) {
                $conditions['vc_user_code'] = $this->passedArgs['projects'];
            }
            if (!empty($this->passedArgs['fromDate'])) {
                $conditions['dt_complain_date >='] = $this->passedArgs['fromDate'];
            }
            if (!empty($this->passedArgs['toDate'])) {
                $conditions['dt_complain_date <='] = $this->passedArgs['toDate'];
            }
			/*if(empty($mgr)) {
			$conditions['vc_user_code'] = $this->Auth->user('vc_emp_id_makess');
			}*/

			$result=$this->Empcomplaint->find('all',array('conditions' => $conditions,'order' => array(
                                           'Empcomplaint.dt_complain_date' => 'desc'
                                   )));
           
			//$result= $this->paginate('Empcomplaint');
		
  
            /**
             * ************************************************************************
             * OUTPUT set output header, variable destruction, set layout, set view 
             * ************************************************************************
             */
            $this->layout = '';
            $this->set('data', $result);
            header("HTTP/1.0 200 OK");
            header('Content-type: application/vnd.ms-excel; charset=utf-8');
            header("Content-Disposition: attachment; filename=\"complain_report_" . date('Y-m-d') . ".xls\";");
            header("Cache-Control: no-cache, must-revalidate");
            header("Expires: Mon, 21 Oct 2011 10:30:00 IST");
            header("Pragma: no-cache");
        } catch (Exception $e) {
            /**
             * ************************************************************************
             * OUTPUT ERROR set output header, variable destruction, set layout, set view
             * ************************************************************************
             */
        }
    }

    function prAddJson() {
        /**
         * **********************************************************************
         * @return json
         * This service adds new complaint.
         * **********************************************************************
         */
        try {
            /**
             * ************************************************************************
             * INPUT authentication check, autorization check, validation check,
             * data purging, variable initialization
             * ************************************************************************
             */
            $response = new stdClass();
            /**
             * ************************************************************************
             * PROCESS 
             * ************************************************************************
             */
            $ComplaintNo = $this->Empcomplaint->query("SELECT LPAD(TO_NUMBER(MAX(SUBSTR(vc_complain_no,1,9)))+1||'C'||'01',12,0) as vc_complain_no FROM makess.hd_emp_complain");
            $ComplaintNo = $ComplaintNo['0']['0']['vc_complain_no'];
            $this->data['Empcomplaint']['vc_complain_no'] = $ComplaintNo;
            $this->data['Empcomplaint']['dt_complain_date'] = date('Y-m-d');
            //nu_field1 is the Project code NOT the user code.
            //Need to correct this.I hate writing code over someone elses blunder.
            $this->data['Empcomplaint']['vc_user_code'] = $this->Auth->User('vc_emp_id_makess'); // $this->Auth->User('nu_customer_code');//
            $this->Empcomplaint->set($this->data);
            if ($this->Empcomplaint->validates()) {
                $file = new File($this->data['Empcomplaint']['bl_image']['tmp_name']);
                @$data = $file->read();
                $file->close();
                $dbo = $this->Empcomplaint->getDataSource();
                if (!empty($data)) {
                    $this->data['Empcomplaint']['bl_image_data'] = $dbo->expression('EMPTY_BLOB()');
                    $this->data['Empcomplaint']['vc_image_name'] = $this->data['Empcomplaint']['bl_image']['name'];
                    $this->data['Empcomplaint']['vc_image_type'] = $this->data['Empcomplaint']['bl_image']['type'];
                    $this->data['Empcomplaint']['vc_image_size'] = $this->data['Empcomplaint']['bl_image']['size'];
                }
                unset($this->data['Empcomplaint']['bl_image']);
                $this->Empcomplaint->set($this->data);
                $this->Empcomplaint->save();

                if (!empty($data)) {
                    $buffer = str_split($data, 2000);
                    foreach ($buffer as $chunk) {
                        $this->Empcomplaint->query("UPDATE hd_emp_complain SET bl_image_data = concat_blob(bl_image_data,hextoraw('" . bin2hex($chunk) . "')) WHERE vc_complain_no='{$this->Empcomplaint->id}'");
                    }
                }
                $this->Email->to = $this->data['Empcomplaint']['vc_email'];
                $this->Email->subject = 'You have successfully registered a complaint';
                //$this->Email->bcc = array("anshuk-kumar@essindia.co.in");

                $this->set('name', $this->data['Empcomplaint']['vc_logged_by']);
                $this->set('link', $this->webroot . 'Empcomplaint/view/' . $ComplaintNo);
                $this->set('link_message', 'Click here to see the Complaint.');
                $this->set('sign_off', 'Ess Support');
                $this->Email->send("You have successfully registered a complaint with ESS. Your complaint number is $ComplaintNo.You will be contacted shortly regarding the same.");

                //Send email to Complaint Receiver
                //First we need to find the list of PM's in the current project.
                $project_id = $this->Empcomplaint->findByVcComplainNo($ComplaintNo);
                $project = $this->Projects->findByNuProjectCode($project_id['Empcomplaint']['nu_project_code']);

                //Find Zonal Manager
                $zonal_manager = $this->ZonesEmployees->findByNuZoneId($project['Projects']['nu_zone_id']);
                $zonal_manager_employee = $this->Employees->findByVcEmpIdMakess($zonal_manager['ZonesEmployees']['vc_emp_code']);
                //Find Project Managers
                $project_managers = $this->ProjectsEmployees->findAllByNuProjectCode($project['Projects']['nu_project_code']);

                $project_manager_emails = array();
                foreach ($project_managers as $project_manager) {
                    $project_manager_employee = $this->Employees->findByVcEmpIdMakess($project_manager['ProjectsEmployees']['vc_emp_code']);
                    if ($project_manager['ProjectsEmployees']['ch_status'] == '')
                        $project_manager_emails[] = $project_manager_employee['Employees']['vc_email'];
                }
                $this->Email->to = $zonal_manager_employee['Employees']['vc_email'];
				if (count($project_manager_emails))
                $this->Email->cc = $project_manager_emails;
                //$this->Email->bcc = array("anshuk-kumar@essindia.co.in");
                $this->Email->subject = 'A Complaint has been added';

                $this->set('name', $zonal_manager['Employees']['vc_emp_name']);
                $this->set('link', $this->webroot . 'empcomplaint/edit/' . $ComplaintNo);
                $this->set('link_message', 'Click here to see the Complaint.');
                $this->set('sign_off', 'Ess Support');
                $message = "A New Complaint has been added with complaint number $ComplaintNo.";
				
                if (isset($this->data['Empcomplaint']['vc_logged_by']))
                    if (!empty($this->data['Empcomplaint']['vc_logged_by']))
                    $message .= " by " . $this->data['Empcomplaint']['vc_logged_by'];
                if (isset($this->data['Empcomplaint']['vc_desc']))
                    if (!empty($this->data['Empcomplaint']['vc_desc']))
                    $message .= " <br/><br/> " . $this->data['Empcomplaint']['vc_desc'];
               $this->Email->send($message);
                $response->status = 1;
                $response->message = "New Complaint has been added Complaint Number is $ComplaintNo";
                $this->Session->setFlash($response->message, false);
            }else {
                $response->status = 0;
                $response->errors = $this->Empcomplaint->invalidFields();
                $response->message = "Complaint registrations failed.";
            }
            /**
             * ************************************************************************
             * OUTPUT set output header, variable destruction, set layout, set view 
             * ************************************************************************
             */
            $this->layout = '';
            $this->autoRender = false;
            header("HTTP/1.0 200 OK");
            //For some reason json content type is not being accepted at the client
            //side. so commenting it out.
            //header('Content-type: text/json; charset=utf-8');
            header("Cache-Control: no-cache, must-revalidate");
            header("Expires: Mon, 21 Oct 2011 10:30:00 IST");
            header("Pragma: no-cache");
            echo json_encode($response);
			
        } catch (Exception $e) {
            /**
             * ************************************************************************
             * OUTPUT ERROR set output header, variable destruction, set layout, set view
             * ************************************************************************
             */
        }
    }

    function prEditJson() {
        /**
         * **********************************************************************
         * @return json
         * This service adds new complaint.
         * **********************************************************************
         */
        try {
            /**
             * ************************************************************************
             * INPUT authentication check, autorization check, validation check,
             * data purging, variable initialization
             * ************************************************************************
             */
            $response = new stdClass();
            /**
             * ************************************************************************
             * PROCESS 
             * ************************************************************************
             */
            Configure::write('debug', 2);
            //pr($this->data);
            //die;
           $this->Empcomplaint->set($this->data);
            if ($this->Empcomplaint->validates(array('fieldList' => array('vc_nature', 'vc_feedback', 'vc_cc_remark', 'vc_cm_remark', 'vc_manhours', 'dt_expected_closure', 'dt_real_closure')))) {
                $this->Empcomplaint->saveField('vc_nature', $this->data['Empcomplaint']['vc_nature']);
                $this->Empcomplaint->saveField('vc_feedback', $this->data['Empcomplaint']['vc_feedback']);
                $this->Empcomplaint->saveField('vc_cc_remarks', $this->data['Empcomplaint']['vc_cc_remark']);
                $this->Empcomplaint->saveField('vc_manhours', $this->data['Empcomplaint']['vc_manhours']);
                $this->Empcomplaint->saveField('dt_expected_closure', $this->data['Empcomplaint']['dt_expected_closure']);
                $this->Empcomplaint->saveField('vc_cm_remarks', $this->data['Empcomplaint']['vc_cm_remark']);
                $this->Empcomplaint->saveField('dt_real_closure', $this->data['Empcomplaint']['dt_real_closure']);
                $response->status = 1;
                $response->message = "Complaint saved successfuly.";
            } else {
                $response->status = 0;
                $response->errors = $this->Empcomplaint->invalidFields(array('fieldList' => array('vc_nature', 'vc_feedback', 'vc_cc_remark', 'vc_cm_remark', 'vc_manhours', 'dt_expected_closure', 'dt_real_closure')));
                $response->message = "Complaint save failed.";
            }
            /**
             * ************************************************************************
             * OUTPUT set output header, variable destruction, set layout, set view 
             * ************************************************************************
             */
            $this->layout = '';
            $this->autoRender = false;
            header("HTTP/1.0 200 OK");
            //For some reason json content type is not being accepted at the client
            //side. so commenting it out.
            //header('Content-type: text/json; charset=utf-8');
            header("Cache-Control: no-cache, must-revalidate");
            header("Expires: Mon, 21 Oct 2011 10:30:00 IST");
            header("Pragma: no-cache");
            echo json_encode($response);
        } catch (Exception $e) {
            /**
             * ************************************************************************
             * OUTPUT ERROR set output header, variable destruction, set layout, set view
             * ************************************************************************
             */
        }
    }

    function prViewFile($id) {
        /**
         * **********************************************************************
         * @return jpeg | png | jpg | gif
         * Fetchs image from database and echo it to the client. 
         * **********************************************************************
         */
        try {
            /**
             * ************************************************************************
             * INPUT authentication check, autorization check, validation check,
             * data purging, variable initialization
             * ************************************************************************
             */
            /**
             * ************************************************************************
             * PROCESS 
             * ************************************************************************
             */
            $file = $this->Empcomplaint->find('first', array(
                'conditions' => array('vc_complain_no' => $id)
                    ));
            /**
             * ************************************************************************
             * OUTPUT set output header, variable destruction, set layout, set view 
             * ************************************************************************
             */
            $this->layout = '';
            $this->autoRender = false;
            header("HTTP/1.0 200 OK");
            header("Content-type: {$file['Empcomplaint']['vc_image_type']}; charset=utf-8");
            header("Content-Disposition: attachment; filename=\"{$file['Empcomplaint']['vc_image_name']}\"");
            header("Cache-Control: no-cache, must-revalidate");
            header("Expires: Mon, 21 Oct 2011 10:30:00 IST");
            header("Pragma: no-cache");
            echo $file['Empcomplaint']['bl_image_data'];
        } catch (Exception $e) {
            /**
             * ************************************************************************
             * OUTPUT ERROR set output header, variable destruction, set layout, set view
             * ************************************************************************
             */
        }
    }

    function prViewImage($id) {
        /**
         * **********************************************************************
         * @return jpeg | png | jpg | gif
         * Fetchs image from database and echo it to the client. 
         * **********************************************************************
         */
        try {
            /**
             * ************************************************************************
             * INPUT authentication check, autorization check, validation check,
             * data purging, variable initialization
             * ************************************************************************
             */
            /**
             * ************************************************************************
             * PROCESS 
             * ************************************************************************
             */
            $file = $this->Empcomplaint->find('first', array(
                'conditions' => array('vc_complain_no' => $id)
                    ));
            /**
             * ************************************************************************
             * OUTPUT set output header, variable destruction, set layout, set view 
             * ************************************************************************
             */
            $this->layout = '';
            $this->autoRender = false;
            header("HTTP/1.0 200 OK");
            header("Content-type: {$file['Empcomplaint']['vc_image_type']}; charset=utf-8");
            header("Cache-Control: no-cache, must-revalidate");
            header("Expires: Mon, 21 Oct 2011 10:30:00 IST");
            header("Pragma: no-cache");
            echo $file['Empcomplaint']['bl_image_data'];
        } catch (Exception $e) {
            /**
             * ************************************************************************
             * OUTPUT ERROR set output header, variable destruction, set layout, set view
             * ************************************************************************
             */
        }
    }

    function view($id = null) {
        /**
         * **************************************************************************
         * Show the complaint
         * ************************************************************************** 
         */
        try {
            /**
             * ************************************************************************
             * INPUT authentication check, autorization check, validation check,
             * data purging, variable initialization
             * ************************************************************************
             */
            /**
             * ************************************************************************
             * PROCESS 
             * ************************************************************************
             */
            $this->Empcomplaint->id = $id;
            $this->data = $this->Empcomplaint->read();
            $this->data['Empcomplaint']['dt_expected_closure'] = str_replace(' 00:00:00', '', $this->data['Empcomplaint']['dt_expected_closure']);
            $this->data['Empcomplaint']['dt_real_closure'] = str_replace(' 00:00:00', '', $this->data['Empcomplaint']['dt_real_closure']);

            $level1 = ($this->data['Empcomplaint']['vc_type'] == 'Application') ? 1 : 2;
            $level2 = $this->data['Empcomplaint']['nu_dt_complaint_id'];
            $level2_name = $this->General->query("SELECT DISTINCT 
                NU_DT_COMPLAINT_ID, VC_DT_COMPLAINT_DESC 
                FROM makess.dt_complaint_type WHERE NU_COMPLAINT_ID='$level1' and ch_active_flag='Y' and NU_DT_COMPLAINT_ID=$level2");
            $level2_name = $level2_name[0][0]['VC_DT_COMPLAINT_DESC'];

            $complaint_annotations = $this->EmpcomplaintAnnotations->find('all', array(
                'conditions' => array('vc_complain_no' => $id),
                'order' => 'dt_created asc'
                    ));

            $complain_employees = $this->ComplainEmployees->find('all', array(
                'conditions' => array('ComplainEmployees.vc_complain_no' => $id)
                    ));

            $this->set('level2_name', $level2_name);
            $this->set('level1', $level1);
            $this->set('level2', $level2);
            $this->set('complaint_annotations', $complaint_annotations);
            $this->set('complain_employees', $complain_employees);
            /**
             * ************************************************************************
             * OUTPUT set output header, variable destruction, set layout, set view 
             * ************************************************************************
             */
            //$this->layout = 'employee';
        } catch (Exception $e) {
            /**
             * ************************************************************************
             * OUTPUT ERROR set output header, variable destruction, set layout, set view
             * ************************************************************************
             */
        }
    }

    function edit($id = null) {
        /**
         * **************************************************************************
         * Provides editable view of the complaint
         * ************************************************************************** 
         */
        try {
            /**
             * ************************************************************************
             * INPUT authentication check, autorization check, validation check,
             * data purging, variable initialization
             * ************************************************************************
             */
            /**
             * ************************************************************************
             * PROCESS 
             * ************************************************************************
             */
            $this->Empcomplaint->id = $id;
            $this->data = $this->Empcomplaint->read();
             // print_r($this->data);
            $isProjectManager = $this->ProjectsEmployees->find('count', array(
                'conditions' => array(
                    'ch_status is null',
                    'vc_emp_code' => $this->Auth->User('vc_emp_id_makess'),
                    'nu_project_code' => $this->data['Empcomplaint']['nu_project_code'],
                //'vc_role_name' => 'PM'
                )
                    ));
            $project = $this->Projects->findByNuProjectCode($this->data['Empcomplaint']['nu_project_code']);
            $isZonalManager = $this->ZonesEmployees->find('count', array(
                'conditions' => array(
                    'vc_emp_code' => $this->Auth->User('vc_emp_id_makess'),
                    'nu_zone_id' => $project['Projects']['nu_zone_id'],
                )
                    ));
            // if (!$isProjectManager && !$isZonalManager)
               // $this->redirect('/pages/permissionDenied');
            if($this->data['Empcomplaint']['dt_expected_closure'] != "") {
            $this->data['Empcomplaint']['dt_expected_closure'] = date("d-m-Y H:i", strtotime($this->data['Empcomplaint']['dt_expected_closure']));
            }
            if($this->data['Empcomplaint']['dt_real_closure'] != "") {
            $this->data['Empcomplaint']['dt_real_closure'] = date("d-m-Y H:i", strtotime($this->data['Empcomplaint']['dt_real_closure']));
            }
            $level1 = ($this->data['Empcomplaint']['vc_type'] == 'Application') ? 1 : 2;
            $level2 = $this->data['Empcomplaint']['nu_dt_complaint_id'];
            $level2_name = $this->General->query("SELECT DISTINCT 
                NU_DT_COMPLAINT_ID, VC_DT_COMPLAINT_DESC 
                FROM makess.dt_complaint_type WHERE NU_COMPLAINT_ID='$level1' and ch_active_flag='Y' and NU_DT_COMPLAINT_ID=$level2");
            $level2_name = $level2_name[0][0]['VC_DT_COMPLAINT_DESC'];

            $complaint_annotations = $this->EmpcomplaintAnnotations->find('all', array(
                'conditions' => array('vc_complain_no' => $id),
                'order' => 'EmpcomplaintAnnotations.dt_created asc'
                    ));

            $complain_employees = $this->ComplainEmployees->find('all', array(
                'conditions' => array('ComplainEmployees.vc_complain_no' => $id)
                    ));
            //print_r($complain_employees);

            $this->set('level2_name', $level2_name);
            $this->set('level1', $level1);
            $this->set('level2', $level2);
            $this->set('complaint_annotations', $complaint_annotations);
            $this->set('complain_employees', $complain_employees);
            /**
             * ************************************************************************
             * OUTPUT set output header, variable destruction, set layout, set view 
             * ************************************************************************
             */
        } catch (Exception $e) {
            /**
             * ************************************************************************
             * OUTPUT ERROR set output header, variable destruction, set layout, set view
             * ************************************************************************
             */
        }
    }

    function report() {
        /**
         * **************************************************************************
         * Show the report page
         * ************************************************************************** 
         */
        try {
            /**
             * ************************************************************************
             * INPUT authentication check, autorization check, validation check,
             * data purging, variable initialization
             * ************************************************************************
             */
            /**
             * ************************************************************************
             * PROCESS 
             * ************************************************************************
             */
            $period = array();
            $period[''] = "--Select Period Range--";
            for ($days = 10; $days < 60; $days+=10) {
                $period[date('Y-m-d', strtotime("-$days days"))] = "Last $days days";
            }
   
            $zones = $this->ZonesEmployees->find('list', array(
                'conditions' => array(
                    'vc_emp_code' => $this->Auth->User('vc_emp_id_makess')
                ),
                'fields' => 'nu_zone_id'
                    ));
		    
            $zones = array(0) + $zones;
            $projects_emp = $this->ProjectsEmployees->find('list', array(
                    'conditions' => array(
                        'vc_emp_code' => $this->Auth->User('vc_emp_id_makess'),
                        'ch_status is null',
                    ),
                    'fields' => 'nu_project_code'
                        ));
			$projects_emp = array(0) + $projects_emp;
            $projects = $this->Projects->find('list', array(
                'conditions' => array(
				'or' => array(
                    'nu_zone_id' => $zones,
				    'nu_project_code' => $projects_emp
				)
                ),
                'fields' => array('nu_project_code', 'vc_project_name'),
                'order' => 'vc_project_name asc'
                    ));
            //array_unshift($projects, array('' => "--Select Project--"));
            $this->set('period', $period);
            $this->set('projects', $projects);
            /**
             * ************************************************************************
             * OUTPUT set output header, variable destruction, set layout, set view 
             * ************************************************************************
             */
        } catch (Exception $e) {
            /**
             * ************************************************************************
             * OUTPUT ERROR set output header, variable destruction, set layout, set view
             * ************************************************************************
             */
        }
    }

    function prMatrixListHtml() {
        /**
         * **********************************************************************
         * Generates reports in html format
         * **********************************************************************
         */
        try {
            /**
             * ************************************************************************
             * INPUT authentication check, autorization check, validation check,
             * data purging, variable initialization
             * ************************************************************************
             */
            /**
             * ************************************************************************
             * PROCESS 
             * ************************************************************************
             */
            $conditions = array();
            if (!empty($this->data)) {
                $this->passedArgs = $this->data['Complaints'];
            }
            if (!empty($this->passedArgs['period'])) {
                $conditions['dt_complain_date >='] = $this->passedArgs['period'];
                $conditions['dt_complain_date <='] = date('Y-m-d');
            }
            if (!empty($this->passedArgs['projects'])) {
                $conditions['vc_user_code'] = $this->passedArgs['projects'];
            }
            if (!empty($this->passedArgs['fromDate'])) {
                $conditions['dt_complain_date >='] = $this->passedArgs['fromDate'];
            }
            if (!empty($this->passedArgs['toDate'])) {
                $conditions['dt_complain_date <='] = $this->passedArgs['toDate'];
            }
            if (!$this->check('Complaint/isReportManager')) {
                $zones = $this->ZonesEmployees->find('list', array(
                    'conditions' => array(
                        'vc_emp_code' => $this->Auth->User('vc_emp_id_makess')
                    ),
                    'fields' => 'nu_zone_id'
                        ));
                $zones = array(0) + $zones;
                $projects_zones = $this->Projects->find('list', array(
                    'conditions' => array(
                        'nu_zone_id' => $zones,
                    ),
                    'fields' => 'nu_project_code'
                        ));
                $projects_emp = $this->ProjectsEmployees->find('list', array('conditions' => array('vc_emp_code' => $this->Auth->User('vc_emp_id_makess'), 'ch_status is null',), 'fields' => 'nu_project_code'));
                $projects = array(0) + $projects_emp + $projects_zones;
            }
            //$conditions['Projects.nu_project_code'] = $projects;
            //$this->Complaints->recursive = -1;
            $stages = $this->Complaints->find('all', array('recursive' => 2, 'fields' => array('distinct Complaints.vc_stage')));

            $projects_code = $this->Complaints->find('all', array('conditions' => $conditions, 'fields' => array('distinct Complaints.nu_project_code')));
            $proj = array();
            foreach ($projects_code as $k => $v) {
                $proj[] = $projects_code[$k]['Complaints']['nu_project_code'];
            }
            foreach ($stages as $key => $value)
                $stages[$key] = $stages[$key]['Complaints']['vc_stage'];
            if (!$this->check('Complaint/isReportManager')) {
                $common_p = array_intersect($proj, $projects);
            } else {
                $common_p = $proj;
            }
            //pr($common_p);
            $this->paginate = array(
                'recursive' => 2,
                'conditions' => array('Projects.nu_project_code' => $common_p),
                'joins' => array(),
                'limit' => 10
            );
            $count = $this->paginate('Projects');

            $matrix = array();
            //pr($count); die;
            foreach ($count as $key => $value) {
                foreach ($stages as $stg) {
                    //pr($value);
                    $this->Complaints->recursive = -1;
                    $complaints = $this->Complaints->find('all', array(
                        'fields' => array('COUNT(*) as count'),
                        'conditions' => array('Complaints.nu_project_code' => $value['Projects']['nu_project_code'], 'Complaints.vc_stage' => $stg) + $conditions,
                        'group' => array('Complaints.vc_stage'))
                    );
                    //pr($complaints);
                    if (!empty($complaints['0']['0']['count']))
                        $matrix[$value['Projects']['nu_project_code']][$stg] = $complaints['0']['0']['count'];
                    else
                        $matrix[$value['Projects']['nu_project_code']][$stg] = 0;
                    $matrix[$value['Projects']['nu_project_code']]['vc_project_name'] = $value['Projects']['vc_project_name'];
                    $matrix[$value['Projects']['nu_project_code']]['vc_customer_name'] = $value['Customerdetails']['vc_customer_name'];
                }
            }

            $data = $matrix;
            /**
             * ************************************************************************
             * OUTPUT set output header, variable destruction, set layout, set view 
             * ************************************************************************
             */
            $this->layout = '';
            $this->set(compact('data', 'stages', 'data_projects'));
        } catch (Exception $e) {
            /**
             * ************************************************************************
             * OUTPUT ERROR set output header, variable destruction, set layout, set view
             * ************************************************************************
             */
        }
    }

    function prMatrixListXls() {
        /**
         * **********************************************************************
         * Generates reports in html format
         * **********************************************************************
         */
        try {
            /**
             * ************************************************************************
             * INPUT authentication check, autorization check, validation check,
             * data purging, variable initialization
             * ************************************************************************
             */
            /**
             * ************************************************************************
             * PROCESS 
             * ************************************************************************
             */
            $conditions = array();
            if (!empty($this->data)) {
                $this->passedArgs = $this->data['Complaints'];
            }
            if (!empty($this->passedArgs['period'])) {
                //$conditions['dt_complain_date >='] = $this->passedArgs['period'];
                //$conditions['dt_complain_date <='] = date('Y-m-d');
            }
            if (!empty($this->passedArgs['projects'])) {
                $conditions['vc_user_code'] = $this->passedArgs['projects'];
            }
            if (!empty($this->passedArgs['fromDate'])) {
                $conditions['Complaints.dt_complain_date >='] = $this->passedArgs['fromDate'];
            }
            if (!empty($this->passedArgs['toDate'])) {
                $conditions['Complaints.dt_complain_date <='] = $this->passedArgs['toDate'];
            }
            if (!$this->check('Complaint/isReportManager')) {
                $zones = $this->ZonesEmployees->find('list', array(
                    'conditions' => array(
                        'vc_emp_code' => $this->Auth->User('vc_emp_id_makess')
                    ),
                    'fields' => 'nu_zone_id'
                        ));
                $zones = array(0) + $zones;
                $projects_zones = $this->Projects->find('list', array(
                    'conditions' => array(
                        'nu_zone_id' => $zones,
                    ),
                    'fields' => 'nu_project_code'
                        ));
                $projects_emp = $this->ProjectsEmployees->find('list', array('conditions' => array('vc_emp_code' => $this->Auth->User('vc_emp_id_makess'), 'ch_status is null',), 'fields' => 'nu_project_code'));
                $projects = array(0) + $projects_emp + $projects_zones;
                //$conditions['Projects.nu_project_code'] = $projects;
                //$this->Complaints->recursive = -1;
            }
            $stages = $this->Complaints->find('all', array('recursive' => 2, 'fields' => array('distinct Complaints.vc_stage')));

            $projects_code = $this->Complaints->find('all', array(
                'fields' => array('distinct Complaints.nu_project_code'),
                'conditions' => $conditions
                    ));
            $proj = array();
            foreach ($projects_code as $k => $v) {
                $proj[] = $projects_code[$k]['Complaints']['nu_project_code'];
            }
            foreach ($stages as $key => $value)
                $stages[$key] = $stages[$key]['Complaints']['vc_stage'];
            if (!$this->check('Complaint/isReportManager')) {
                $common_p = array_intersect($proj, $projects);
            } else {
                $common_p = $proj;
            }
            $count = $this->Projects->find('all', array(
                'recursive' => 2,
                'conditions' => array('Projects.nu_project_code' => $common_p),
                'joins' => array()
                    ));

            $matrix = array();
            //pr($count); die;
            foreach ($count as $key => $value) {
                foreach ($stages as $stg) {
                    //pr($value);
                    $this->Complaints->recursive = -1;
                    $complaints = $this->Complaints->find('all', array(
                        'fields' => array('COUNT(*) as count'),
                        'conditions' => array('Complaints.nu_project_code' => $value['Projects']['nu_project_code'], 'Complaints.vc_stage' => $stg)+$conditions,
                        'group' => array('Complaints.vc_stage'))
                    );
                    //pr($complaints);
                    if (!empty($complaints['0']['0']['count']))
                        $matrix[$value['Projects']['nu_project_code']][$stg] = $complaints['0']['0']['count'];
                    else
                        $matrix[$value['Projects']['nu_project_code']][$stg] = 0;
                    $matrix[$value['Projects']['nu_project_code']]['vc_project_name'] = $value['Projects']['vc_project_name'];
                    $matrix[$value['Projects']['nu_project_code']]['vc_customer_name'] = $value['Customerdetails']['vc_customer_name'];
                }
            }

            $data = $matrix;
            /**
             * ************************************************************************
             * OUTPUT set output header, variable destruction, set layout, set view 
             * ************************************************************************
             */
            $this->layout = '';
            $this->set(compact('data', 'stages', 'data_projects'));
            header("HTTP/1.0 200 OK");
            header('Content-type: application/vnd.ms-excel; charset=utf-8');
            header("Content-Disposition: attachment; filename=\"complain_report_matrix_" . date('Y-m-d') . ".xls\";");
            header("Cache-Control: no-cache, must-revalidate");
            header("Expires: Mon, 21 Oct 2011 10:30:00 IST");
            header("Pragma: no-cache");
        } catch (Exception $e) {
            /**
             * ************************************************************************
             * OUTPUT ERROR set output header, variable destruction, set layout, set view
             * ************************************************************************
             */
        }
    }

    function matrix() {
        /**
         * **************************************************************************
         * Show the report page
         * ************************************************************************** 
         */
        try {
            /**
             * ************************************************************************
             * INPUT authentication check, autorization check, validation check,
             * data purging, variable initialization
             * ************************************************************************
             */
            /**
             * ************************************************************************
             * PROCESS 
             * ************************************************************************
             */
            /**
             * ************************************************************************
             * OUTPUT set output header, variable destruction, set layout, set view 
             * ************************************************************************
             */
        } catch (Exception $e) {
            /**
             * ************************************************************************
             * OUTPUT ERROR set output header, variable destruction, set layout, set view
             * ************************************************************************
             */
        }
    }

    function prDeleteJson($id) {
        /**
         * **************************************************************************
         * Description of delete
         * **************************************************************************
         * @return json
         * Service to delete Complaints
         * ************************************************************************** 
         */
        try {
            /**
             * ************************************************************************
             * INPUT authentication check, autorization check, validation check,
             * data purging, variable initialization
             * ************************************************************************
             */
            $response = new stdClass();
            /**
             * ************************************************************************
             * PROCESS 
             * ************************************************************************
             */
            $this->Complaints->delete($id);
            $response->status = 1;
            $response->message = "The complaint has been deleted.";
            /**
             * ************************************************************************
             * OUTPUT set output header, variable destruction, set layout, set view 
             * ************************************************************************
             */
            $this->layout = '';
            $this->autoRender = false;
            header("HTTP/1.0 200 OK");
            //header('Content-type: text/json; charset=utf-8');
            header("Cache-Control: no-cache, must-revalidate");
            header("Expires: Mon, 21 Oct 2011 10:30:00 IST");
            header("Pragma: no-cache");
            echo json_encode($response);
        } catch (Exception $e) {
            /**
             * ************************************************************************
             * OUTPUT ERROR set output header, variable destruction, set layout, set view
             * ************************************************************************
             */
        }
    }

    function type() {
        /**
         * **************************************************************************
         * Show list of type on the basis of which the complaint form will be 
         * generated.
         * **************************************************************************
         */
        try {
            /**
             * ************************************************************************
             * INPUT authentication check, autorization check, validation check,
             * data purging, variable initialization
             * ************************************************************************
             */
            /**
             * ************************************************************************
             * PROCESS
             * ************************************************************************
             */
            $totaltype = $this->General->query("SELECT DISTINCT nu_complaint_id, vc_complaint_desc FROM makess.hd_complaint_type WHERE ch_active_flag='Y' AND nu_complaint_id !=3 ORDER BY nu_complaint_id");
            $this->set('ctypeoption', $totaltype);
            /**
             * ************************************************************************
             * OUTPUT set output header, variable destruction, set layout, set view
             * ************************************************************************
             */
        } catch (Exception $e) {
            /**
             * ************************************************************************
             * OUTPUT ERROR set output header, variable destruction, set layout, set view
             * ************************************************************************
             */
        }
    }

    function add($level1 = 1, $level2 = 1) {
        /**
         * **************************************************************************
         * Description of delete
         * **************************************************************************
         * Form to add Complaint accessible by Customers only.
         * **************************************************************************
         */
        try {
            /**
             * ************************************************************************
             * INPUT authentication check, autorization check, validation check,
             * data purging, variable initialization
             * ************************************************************************
             */
            /**
             * ************************************************************************
             * PROCESS
             * ************************************************************************
             */
			 $compCode=$this->Auth->user('vc_comp_code');
			 $empCode=$this->Auth->user('vc_emp_id_makess');
			 $empName=$this->Auth->user('vc_emp_name');
			 $this->set('empName',$empName);
			 $info=$this->General->query("SELECT vc_email FROM ebiz.emp_account WHERE vc_emp_id_makess='".$empCode."' AND vc_comp_code='".$compCode."'");
			 $this->set('email',$info[0][0]['vc_email']);		
             $level2_name = $this->General->query("SELECT DISTINCT 
                NU_DT_COMPLAINT_ID, VC_DT_COMPLAINT_DESC 
                FROM makess.dt_complaint_type WHERE NU_COMPLAINT_ID='$level1' and ch_active_flag='Y' and NU_DT_COMPLAINT_ID=$level2");
            $level2_name = $level2_name[0][0]['VC_DT_COMPLAINT_DESC'];
            $this->set('level2_name', $level2_name);
            $this->set('level1', $level1);
            $this->set('level2', $level2);
            $block_box = $this->General->query("SELECT VC_COMMON_BLOCK_APPLICABLE, VC_DT_COMPLAINT_DESC FROM makess.dt_complaint_type WHERE nu_complaint_id='" . $level1 . "' and nu_dt_complaint_id='" . $level2 . "'");
            $blockbox = $block_box['0']['0']['VC_COMMON_BLOCK_APPLICABLE'];
            $this->set('common_block', $blockbox);
            $projects = $this->Projects->find('list', array(
                'conditions' => array(
                    // 'nu_customer_code' => $this->Auth->User('nu_field1')
                    'nu_customer_code' => 296
                ),
                'fields' => array('nu_project_code', 'vc_project_name')
                    ));
            $this->set('projects', $projects);
         
            /**
             * ************************************************************************
             * OUTPUT set output header, variable destruction, set layout, set view
             * ************************************************************************
             */
        } catch (Exception $e) {
            /**
             * ************************************************************************
             * OUTPUT ERROR set output header, variable destruction, set layout, set view
             * ************************************************************************
             */
        }
    }


function test() {
	$res=$this->Empcomplaint->query("SELECT vc_complain_no FROM makess.hd_emp_complain");
	
	echo "<pre>";
	print_r($res);
	exit;


}


/*--------------- 19/04/2014-----------------------------------------*/
function view_customer_complaint()
   {
         if (!empty($this->data)) {
                $this->passedArgs = $this->data['Empcomplaint'];
            }  
			$page_no=$this->params['named']['page'];
			$this->set('pageno',$page_no);
            $startdate=$this->passedArgs['startdate'];
            $enddate=$this->passedArgs['enddate'];
			//$sub=$this->data['Empcomplaint']['subtype'];
			$comtype=$this->passedArgs['ctype'];
            //$restype=$this->passedArgs['resolutiontype'];
            $modul=$this->passedArgs['module'];
			$pri=$this->passedArgs['priority'];
			$probtype=$this->passedArgs['problemtype'];
			$app=$this->passedArgs['applicationtype'];
			$fil=$this->passedArgs['stage'];
			$projtype=$this->passedArgs['project'];
			 $conditions=array();
            $conditions=array('Complaints.vc_request_type' => '3');
            
            if($startdate!=''){
            $conditions+=array('Complaints.dt_complain_date >='=>$startdate);
            }
            if($enddate!=''){
            $conditions+=array('Complaints.dt_complain_date <='=>$enddate);
                    
            }
//			if ($sub!='') {
//                $conditions+=array('Complaints.vc_sub_complaint_type'=> $sub);
//            }
            if ($comtype!='') {
                $conditions+=array('Complaints.vc_type'=>$comtype);
            }
						//if ($restype!='') {
              //  $conditions+=array('Complaints.vc_resolution'=> $restype);
           // }
		   if ($modul!='') {
                $conditions+=array('Complaints.vc_module'=> $modul);
            }
			if ($pri!='') {
                $conditions+=array('Complaints.vc_priority'=> $pri);
            }
			if ($probtype!='') {
                $conditions+=array('Complaints.vc_problem_source'=> $probtype);
            }
			if ($app!='') {
                $conditions+=array('Complaints.vc_appication_name'=> $app);
            }
			if ($fil!='') {
                $conditions+=array('Complaints.vc_stage'=> $fil);
            }
			if ($projtype!='') {
                $conditions+=array('Complaints.vc_user_code'=> $projtype);
            }
			
        try {
          
                        
            $complaint_type = $this->Mstcomplaintmaster->find('list', array(
                'conditions' => array(
                    // 'nu_customer_code' => $this->Auth->User('nu_field1')
                    'status' =>'1'
                ),
                'fields' => array('id', 'formvalue')
                    ));
              $this->set('complaint_type', $complaint_type);
			
              $project_type = $this->Mstcomplaintcustomer->find('list', array(
                    'fields' => array('Mstcomplaintcustomer.vc_customer_code', 'Mstcomplaintcustomer.vc_customer_name')
                ));
//              $project_type = $this->Mstcomplaintcustomer->find('list', array(
//                'conditions' => array(
//                    // 'nu_customer_code' => $this->Auth->User('nu_field1')
//                    'status' =>'ebizframe10'
//                ),
//                'fields' => array('vc_customer_code', 'vc_customer_name')
//                    ));
              $this->set('project_type', $project_type);
            $complaint_subtype = $this->Mstcomplaintmaster->find('list', array(
                'conditions' => array(
                    // 'nu_customer_code' => $this->Auth->User('nu_field1')
                    'status' =>'2'
                ),
                'fields' => array('id', 'formvalue')
                    ));
            $this->set('sub_complaint_type', $complaint_subtype);
            $problem_in_form_report = $this->Mstcomplaintmaster->find('list', array(
                'conditions' => array(
                    // 'nu_customer_code' => $this->Auth->User('nu_field1')
                    'status' =>'3'
                ),
                'fields' => array('id', 'formvalue')
                    ));
             $this->set('problem_in_form_report', $problem_in_form_report);
            $application_name = $this->Mstcomplaintmaster->find('list', array(
                'conditions' => array(
                    // 'nu_customer_code' => $this->Auth->User('nu_field1')
                    'status' =>'4'
                ),
                'fields' => array('id', 'formvalue')
                    ));
             $this->set('application_name', $application_name);
             $array1= array('' => '--Select Stage--', 'Recorded' => 'Recorded', 'Work In Progress' => 'Work In Progress', 'User Feedback Awaited' => 'User Feedback Awaited', 'Closed' => 'Closed', 'ESS Feedback Awaited' => 'ESS Feedback Awaited', 'Force Close' => 'Force Close', 'Dropped' => 'Dropped');
            $complaint_recorded = $this->Mstcomplaintmaster->find('list', array(
                'conditions' => array(
                    'status' =>'5'
                ),
                'fields' => array('formvalue', 'formvalue')
				,'order' => 'formvalue asc'
                    ));
            $array2=array_merge($array1,$complaint_recorded);
            $this->set('complaintrecorded', $array2);
			$resolution = $this->Mstcomplaintmaster->find('list', array(
                'conditions' => array(
                    // 'nu_customer_code' => $this->Auth->User('nu_field1')
                    'status' =>'6'
                ),
                'fields' => array('id', 'formvalue')
                    ));
            $this->set('resolution', $resolution);
			$module = $this->Mstcomplaintmaster->find('list', array(
                    'conditions' => array(
                        // 'nu_customer_code' => $this->Auth->User('nu_field1')
                        'status' => '7'
                    ),
                    'fields' => array('id', 'formvalue')
                ));
                $this->set('module', $module);
			
             if (isset($this->data['Download'])) {
                $result = $this->Complaints->find('all', array(
                    'conditions' => $conditions,
                    'recursive' => -1,
                    'order' => array(
                        'Complaints.vc_complain_no' => 'desc'
                    )
                ));

                $this->view_customer_complaint_excel($result);
            } else {

                $this->paginate = array(
                    'conditions' => $conditions,
                    'limit' => 10,
                    'recursive' => -1,
                    'order' => array(
                        'Complaints.vc_complain_no' => 'desc'
                    )
                );
                $result = $this->paginate('Complaints');
            }
            $this->set('data',$result);
        } catch (Exception $e) {
            /**
             * ************************************************************************
             * OUTPUT ERROR set output header, variable destruction, set layout, set view
             * ************************************************************************
             */
        }
       
   }
   
   function view_customer_complaint_excel($data) {

        set_time_limit(0);
        Configure::write('debug', 2);

         $allnewexitcustomers = $this->Customers->find('list', array(
                    'fields' => array('Customers.nu_customer_code', 'Customers.vc_customer_name')
                ));
//        $allnewexitcustomers = $this->Mstcomplaintcustomer->find('list', array(
//            'fields' => array('Mstcomplaintcustomer.vc_customer_code', 'Mstcomplaintcustomer.vc_customer_name')
//        ));

        $complaint_type = $this->Mstcomplaintmaster->find('list', array(
            'conditions' => array('status' => '1'),
            'fields' => array('id', 'formvalue')
        ));


        $project_type = $this->Mstcomplaintcustomer->find('list', array(
                    'fields' => array('Mstcomplaintcustomer.vc_customer_code', 'Mstcomplaintcustomer.vc_customer_name')
                ));
//        $project_type = $this->Mstcomplaintcustomer->find('list', array(
//            'conditions' => array('status' => 'ebizframe10'),
//            'fields' => array('vc_customer_code', 'vc_customer_name')
//        ));

        $complaint_subtype = $this->Mstcomplaintmaster->find('list', array(
            'conditions' => array('status' => '2'),
            'fields' => array('id', 'formvalue')
        ));


        $problem_in_form_report = $this->Mstcomplaintmaster->find('list', array(
            'conditions' => array('status' => '3'),
            'fields' => array('id', 'formvalue')));

        $application_name = $this->Mstcomplaintmaster->find('list', array(
            'conditions' => array('status' => '4'),
            'fields' => array('id', 'formvalue')
        ));
		$module = $this->Mstcomplaintmaster->find('list', array(
                    'conditions' => array(
                        // 'nu_customer_code' => $this->Auth->User('nu_field1')
                        'status' => '7'
                    ),
                    'fields' => array('id', 'formvalue')
                ));
               


        $array1 = array('' => '--Select Stage--', 'Recorded' => 'Recorded', 'Work In Progress' => 'Work In Progress', 'User Feedback Awaited' => 'User Feedback Awaited', 'Closed' => 'Closed', 'ESS Feedback Awaited' => 'ESS Feedback Awaited', 'Force Close' => 'Force Close', 'Dropped' => 'Dropped');
        $complaint_recorded = $this->Mstcomplaintmaster->find('list', array(
            'conditions' => array('status' => '5'),
            'fields' => array('formvalue', 'formvalue'), 'order' => 'formvalue asc'
        ));
        $array2 = array_merge($array1, $complaint_recorded);

        $this->set('complaintrecorded', $array2);
        $resolution = $this->Mstcomplaintmaster->find('list', array(
            'conditions' => array('status' => '6'),
            'fields' => array('id', 'formvalue')
        ));




        $inputFileType = 'Excel5';

        $inputFileName = 'customer-complaint-report.xls';
        $objReader = PHPExcel_IOFactory::createReader($inputFileType);
        $objPHPExcel = $objReader->load($inputFileName);

        $objPHPExcel->getActiveSheet()->insertNewRowBefore(5, 1);
        $no = 7;


        foreach ($data as $index => $value) {
            $nu_project_code = $value['Complaints']['nu_project_code'];

            if ($value['Complaints']['vc_priority'] != '')
                $pri = $value['Complaints']['vc_priority'];
            else
                $pri = 'N/A';
            if ($value['Complaints']['vc_email'] != '')
                $logemail = $value['Complaints']['vc_email'];
            else
                $logemail = 'N/A';

            if ($value['Complaints']['vc_contact_no'] != '')
                $contactno = $value['Complaints']['vc_contact_no'];
            else
                $contactno = 'N/A';
            if ($value['Complaints']['vc_resolution'] != '')
                $res = $resolution[$value['Complaints']['vc_resolution']];
            else
                $res = 'N/A';
            if ($value['Complaints']['vc_complain_no'] != '')
                $comno = $value['Complaints']['vc_complain_no'];
            else
                $comno = 'N/A';

            if ($value['Complaints']['vc_appication_name'] != '')
                $applicationame = $application_name[$value['Complaints']['vc_appication_name']];
            else
                $applicationame = 'N/A';
            if ($value['Complaints']['vc_type'] != '')
                $complainttype = $complaint_type[$value['Complaints']['vc_type']];
            else
                $complainttype = 'N/A';
            if ($value['Complaints']['vc_sub_complaint_type'] != '')
                $complaintsubtype = $complaint_subtype[$value['Complaints']['vc_sub_complaint_type']];
            else
                $complaintsubtype = 'N/A';

            if ($value['Complaints']['vc_problem_source'] != '')
                $prob = $problem_in_form_report[$value['Complaints']['vc_problem_source']];
            else
                $prob = 'N/A';
            if ($value['Complaints']['vc_logged_by'] != '')
                $loggedby = $value['Complaints']['vc_logged_by'];
            else
                $loggedby = 'N/A';
            if ($value['Complaints']['dt_complain_date'] != '')
                $loggedon = $value['Complaints']['dt_complain_date'];
            else
                $loggedon = 'N/A';
            if ($value['Complaints']['vc_desc'] != '')
                $feed = $value['Complaints']['vc_desc'];
            else
                $feed = 'N/A';

            if ($value['Complaints']['vc_desc'] != '')
                $desc = $value['Complaints']['vc_desc'];
            else
                $desc = 'N/A';
            if ($value['Complaints']['dt_verified_on'] != '')
                $ver = 'N/A';//$value['Complaints']['dt_verified_on'];
            else
                $ver = 'N/A';
            if ($value['Complaints']['vc_stage'] != '')
                $complaintrecorded = $value['Complaints']['vc_stage'];
            else
                $complaintrecorded = 'N/A';
			if ($value['Complaints']['vc_module'] != '')
                $modul =$module[$value['Complaints']['vc_module']];
				
            else
                $modul = 'N/A';


            $objPHPExcel->getActiveSheet()->setCellValue('A' . $no, $comno);
            $objPHPExcel->getActiveSheet()->setCellValue('B' . $no, date('d-m-y', strtotime($loggedon)));
            $objPHPExcel->getActiveSheet()->setCellValue('C' . $no, $allnewexitcustomers[$nu_project_code]);
            $objPHPExcel->getActiveSheet()->setCellValue('D' . $no, $loggedby);
            $objPHPExcel->getActiveSheet()->setCellValue('E' . $no, $complainttype);
            //$objPHPExcel->getActiveSheet()->setCellValue('F' . $no, $complaintsubtype);
            $objPHPExcel->getActiveSheet()->setCellValue('F' . $no, $modul);
            $objPHPExcel->getActiveSheet()->setCellValue('G' . $no, $applicationame);
            $objPHPExcel->getActiveSheet()->setCellValue('H' . $no, $prob);
            $objPHPExcel->getActiveSheet()->setCellValue('I' . $no, $desc);
            $objPHPExcel->getActiveSheet()->setCellValue('J' . $no, $ver);//date('d-m-y', strtotime($ver)));
           // $objPHPExcel->getActiveSheet()->setCellValue('K' . $no, $res);
            $objPHPExcel->getActiveSheet()->setCellValue('K' . $no, $complaintrecorded);
            $objPHPExcel->getActiveSheet()->setCellValue('L' . $no, $pri);
            $objPHPExcel->getActiveSheet()->setCellValue('M' . $no, $logemail);
            $objPHPExcel->getActiveSheet()->setCellValue('N' . $no, $contactno);
           

            $no++;
        }

        ob_clean();
        $outputFileType = 'Excel5';
        $outputFileName = 'Complaint-report-ebizframe10-implementation.xls';
        header('Content-Type: application/vnd.ms-excel');
        header("Content-Type:application/force-download");
        header('Content-Disposition: attachment;filename="' . $outputFileName);
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, $outputFileType);
        $objWriter->save('php://output');

        exit;
    }
    
    /*--------------- 19/04/2014-----------------------------------------*/
function addebiztencustomers(){
	
        //pr($this->Auth->User('vc_comp_code'));
        $comp_code=$this->Auth->User('vc_comp_code');   
        $vc_emp_code = $this->Auth->user('vc_emp_id_makess');
        $vc_emp_code = $this->Auth->user('vc_emp_id_makess');
            
        $lasthistory_id = $this->Mstcomplaintcustomer->getMaxId();
        $customers=$this->Customerdetails->find('list',array(                                   
                                    'conditions' => array('Customerdetails.vc_comp_code' =>$comp_code),
                                    'fields' => array('Customerdetails.nu_customer_code','Customerdetails.vc_customer_name'),
            'order' =>'Customerdetails.vc_customer_name asc'
                                ));

      //  $customerslist = $this->Mstcomplaintcustomer->find('list', array('conditions' => array('Company.ch_status' => 'STSTY04','Company.vc_username' =>$vc_username), 'fields' => array('nu_company_id', 'vc_company_name'), 'order' => array('Company.vc_company_name' => 'asc')));
       // $customers['other']='Other';
        $this->set('customerslist',$customers);
        if(isset($this->data['Mstcomplaintcustomer'])){
          
            $this->data['Mstcomplaintcustomer']['id'] = $lasthistory_id;
             //pr($this->data);
            // pr($_POST['vc_typecustomer']);
             //die;
            $vc_typecustomer = $_POST['vc_typecustomer'];
            $this->data['Mstcomplaintcustomer']['vc_emp_code'] = $vc_emp_code;
            if($vc_typecustomer=='1'){
            
                $this->data['Mstcomplaintcustomer']['vc_customer_code']= '19000'.$lasthistory_id;
                       
                    $this->data['Mstcomplaintcustomer']['vc_customer_name']= trim($this->data['Mstcomplaintcustomer']['vc_customer_name']); 
                    $countcust = $this->Mstcomplaintcustomer->find('count',array('conditions'=>array('Mstcomplaintcustomer.vc_customer_name'=>trim($this->data['Mstcomplaintcustomer']['vc_customer_name'])
                        )));
                    if($countcust>0){
                        $this->Session->setFlash('Customer already exsist', false, array('class' => 'flash flash_success'));
                        $this->redirect('addebiztencustomers');
                        
                    }
                
            }else{
                $countcust = $this->Mstcomplaintcustomer->find('count',array('conditions'=>array('Mstcomplaintcustomer.vc_customer_code'=>$this->data['Mstcomplaintcustomer']['vc_customer_code'], )));
                    if($countcust>0){
                        $this->Session->setFlash('Customer already exsist', false, array('class' => 'flash flash_success'));
                        $this->redirect('addebiztencustomers');
                        
                    }
                
            }
            
            $this->data['Mstcomplaintcustomer']['dt_created_date'] = date('Y-m-d');
            $this->data['Mstcomplaintcustomer']['status'] = 'ebizframe10';
            $this->data['Mstcomplaintcustomer']['vc_comp_code'] = $comp_code;
            
            
            $this->Mstcomplaintcustomer->save($this->data['Mstcomplaintcustomer'],false);
        //    pr($this->data['Mstcomplaintcustomer']);die;
            $this->Session->setFlash('Customer added successfully', false, array('class' => 'flash flash_success'));
            $this->redirect('addebiztencustomers');
            }
    }
    
    
    function add_complaint($id=null) {

	@$type= $this->params['pass'][0];
	@$id=$this->params['pass'][1];
		
	if($id !='' && $type=='D') {
		if($this->Mstcomplaintmaster->delete($id)) {
			$this->Session->setFlash('The record has been deleted.');
			$this->redirect(array('action' => '/add_complaint'));
	   }
   }
   
   
   if(!isset($this->data['Update']) && $id !='' && $type=='E') {
		
		 $complainData = $this->Mstcomplaintmaster->findById($id);
		  //pr($complainData);die;
		  $this->set('id',$id);
		  $this->set('type',$type);
		  $this->set('complainData',$complainData);
	  
	  }else {
		 if(isset($this->data['Update']) && !empty($this->data)){
		 
			 $valID = $this->data['Mstcomplaintmaster']['id'];
			 $status = $this->data['Mstcomplaintmaster']['status'];
			 $formvalue = $this->data['Mstcomplaintmaster']['formvalue'];
			 
			if( $this->Mstcomplaintmaster->updateAll(array('Mstcomplaintmaster.status'=>$status,'Mstcomplaintmaster.formvalue'=>"'$formvalue'"),array('Mstcomplaintmaster.id'=>$valID))) {
		    $this->Session->setFlash('The record has been updated.');
			$this->redirect(array('action' => '/add_complaint'));
		  }
		
		}
      }
	  
	  
	if(!empty($this->data)){
	
		if(isset($this->data['Mstcomplaintmaster']['stat1']) && $this->data['Mstcomplaintmaster']['stat1']!=''){
			$listdata = $this->Mstcomplaintmaster->find('all',array('conditions'=>array('Mstcomplaintmaster.status'=>$this->data['Mstcomplaintmaster']['stat1'])));
			//pr($listdata);die;
			$len=count($listdata);
			$this->set('len',$len);
			$this->set('listdata',$listdata);
			$this->set('postedid',$this->data['Mstcomplaintmaster']['stat1']);
		}else{
		
	        $this->set('len',0);
	
	
            $errror =false;
           // die;
            if($this->data['Mstcomplaintmaster']['status']==''){
               $this->Session->setFlash("Please select complaint type");
               $errror =true;
            }
            if($this->data['Mstcomplaintmaster']['formvalue']==''){
                $this->Session->setFlash("Please Enter value in text box");
               $errror =true;
            }
            $this->data['Mstcomplaintmaster']['id'] = $this->Mstcomplaintmaster->getMaxId();
            $this->data['Mstcomplaintmaster']['status'] = $this->data['Mstcomplaintmaster']['status'];
            $this->data['Mstcomplaintmaster']['formvalue'] = $this->data['Mstcomplaintmaster']['formvalue'];
            $this->data['Mstcomplaintmaster']['dt_created_date'] = date('y-m-d');
            
            
           if($errror==false){
                if($this->Mstcomplaintmaster->save($this->data)){

                    $this->Session->setFlash("Saved sucessfully!!");
                    $this->redirect('/empcomplaint/add_complaint');
                }else{
                    $this->Session->setFlash("Not saved");
                    $this->redirect('/empcomplaint/add_complaint' );
                }
           }else{
            
                //$this->redirect('/qsd/qsd_council_feedback?reqno='.$rn );
           }
        }
		}$comlaintvalue = $this->Mstcomplaintmastervalue->find('all');
	   // pr($feedbacks);die;
        $fdbk = array();
        if(!empty($comlaintvalue)){
            foreach($comlaintvalue as $key=>$val){
                $fdbk[$val['Mstcomplaintmastervalue']['id']] = $val['Mstcomplaintmastervalue']['formname'];
            }
			//pr($fdbk);die;
        
            $this->set('complaintdetails',$fdbk);
        }
}


function view_summary() {
        @$type= $this->params['pass'][0];
        @$id=$this->params['pass'][1];
    
		if($id !='' && $type=='D') {
			if($this->Mstcomplaintcustomer->delete($id)) {
			$this->Session->setFlash('The customer has been deleted.');
			$this->redirect(array('action' => '/view_summary'));
			}
        }
        $emp_code = $this->Auth->User('vc_emp_id_makess');
        //pr($emp_code);die;
        $customers = $this->Mstcomplaintcustomer->find('all', array('fields' =>
            array('Mstcomplaintcustomer.id','Mstcomplaintcustomer.vc_customer_code','Mstcomplaintcustomer.vc_customer_name',
                'Mstcomplaintcustomer.dt_created_date'), 'order'=>'Mstcomplaintcustomer.id desc'));
        $len=count($customers);
        $this->set('customers',$customers);
        $this->set('len',$len);


//pr($customers);die;
}

		
    function prAssocEmployeeListHtml($id=null){
        try {/* $projectsemployees = $this->ProjectsEmployees->find('all',array(
                'conditions' => array(
                    'nu_project_code' => $id,
					'ch_status is null'
                    ),
                'order' => 'vc_role_name'
            )); */
            
            $projectsemployees = $this->Personaldetails->find('all',array(
                'conditions' => array(
                    "ch_work_status IN ('A','H')" ,'vc_rep_to'=> 1355 ),
                'fields'=>array('vc_emp_code','vc_emp_name'),
                'order' => 'vc_emp_name',
                'recursive'=>-1
            ));
          //  pr($projectsemployees);die;
            $options='';
            foreach($projectsemployees as $projectemployee){
               // $options .= "<option value='{$projectemployee['Employees']['vc_emp_id_makess']}'>{$projectemployee['Employees']['vc_emp_name']}</option>";
             $options .= "<option value='{$projectemployee['Personaldetails']['vc_emp_code']}'>{$projectemployee['Personaldetails']['vc_emp_name']}</option>";
                
            }
            $options=(empty($options)?'<option value="">No Engineer Assigned to Project</option>':$options);
            /**
             * ************************************************************************
             * OUTPUT set output header, variable destruction, set layout, set view 
             * ************************************************************************
             */
            $this->layout = '';
            $this->autoRender = false;
            echo $options;
        } catch (Exception $e) {
            /**
             * ************************************************************************
             * OUTPUT ERROR set output header, variable destruction, set layout, set view
             * ************************************************************************
             */
        }
    }


}