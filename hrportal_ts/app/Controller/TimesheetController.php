<?php

/*
 * Property of Eastern Software Systems Pvt. Ltd.
 * Should be modified on by a Cake PHP Professional
 */

/**
 * ******************************************************************************
 * Description of Function in class
 * ******************************************************************************
 * file (costing_controller.php) version: 0.1.0
 * file description: Cake PHP Controller file for manupilating Timesheet data
 * file change log:
 *                          created by Ayush Pant <ayush.pant at essindia.co.in>
 *                          12-2-2018 1:13:23 PM Created Global function, and actions add | edit | view | delete.
 *                          changed by <user>
 *                          <date> <time> <changed-action-name> <change-description>
 *
 * ******************************************************************************
 * project: EssPortal
 * project version: 0.1.0
 * @author Ayush Pant <ayush.pant at essindia.co.in>
 * @client company: Eastern Software Systems Pvt. Ltd.
 * @date created: Feb 4, 2018 1:13:23 PM
 * @date last modified:  4, 2018 1:13:23 PM
 * ******************************************************************************
 */
class TimesheetController extends AppController {

    var $uses = array('MyProfile', 'DtTimesheet', 'MstTimesheet', 'Bugs');
    var $components = array('Session', 'Cookie', 'RequestHandler','Common');
    var $helpers = array('Html', 'Ajax', 'Form', 'Session', 'Timesheet');

    function beforeFilter() {
        
    }

    function index() {
        $this->layout = 'admin';
    }

    function functions() {
        $this->layout = '';
        $this->autoRender = false;
        $this->Functions->main();
    }

    function timesheetrow($countrow = '') {
        $this->layout = '';
        $comp_code = $this->Auth->User('vc_comp_code');
        $emp_code = $this->Auth->User('vc_emp_id_makess');
        $this->set('emp_code', $emp_code);
        $this->set('divcountno', $countrow);
        $this->render('/Timesheet/timesheetrow');
    }

    function ApprovalMail($sheet_status, $sno) {
        $ora_conn = $this->Functions->connRet();
        if ($sheet_status == 'S') {
            $SQLEmp = "SELECT a . vc_emp_name, vc_login_name || '@essindia.co.in' mail_id from ebiz . emp_account a, persdet b where a . vc_emp_id_makess=b . vc_emp_code and b . vc_emp_id='" . $this->params['form']['employee'] . "'";
            $rsEmp = ociparse($ora_conn, $SQLEmp);
            ociexecute($rsEmp);
            ocifetch($rsEmp);
            $emp_name = ociresult($rsEmp, 'VC_EMP_NAME');
            $result = $this->MailCheck($this->params['form']['employee']);
            if ($this->MailCheck($this->params['form']['employee']) == true) {
                list($sd, $sm, $sy) = explode('-', $this->params['form']['wstDate']);
                list($ed, $em, $ey) = explode('-', $this->params['form']['wedDate']);
                $start = strtoupper(date('d-M-Y', mktime(0, 0, 0, $sm, $sd, $sy)));
                $end = strtoupper(date('d-M-Y', mktime(0, 0, 0, $em, $ed, $ey)));
            }
        }
    }

    function tslist() {
        Configure::write('debug', 0);
        $this->layout = 'employee-new';
        $comp_code = '01';
        $emp_code = $this->Auth->User('emp_id');
        $db_con = $this->Functions->connRet();
        $limit = 10;
        if (empty($_REQUEST['page'])) {
            $_REQUEST['page'] = 1;
        }
        $limitvalue = ($_REQUEST['page'] - 1) * $limit;
        $qlimit = $limitvalue + $limit;
        $SQLEmpTs = "SELECT a.s_no AS sno , a.vc_ts_status as ts_type , nvl(a.vc_tot_frms , '0') AS totfrm ,
                nvl(a.vc_tot_reps , '0') As totrep , nvl(a.vc_tot_hrs , '0') As tothrs ,
                b.vc_code_desc As region , c.vc_emp_name As emp_name , to_char(a.DT_end_date , 'dd-MON-rrrr')
                As end_date , to_char(a.dt_start_Date , 'dd-MON-rrrr') As start_date , nvl(to_char(a.dt_applied , 'dd-MON-rrrr'),'N/A')
                As submitted_on , nvl(to_char(a.dt_approved , 'dd-MON-rrrr'),'N/A') As approved_on , a.vc_status As status , a.vc_emp_id
                from hrpay . mst_timesheet a , sales . mst_code b , hrpay . persdet c where a.vc_emp_id = c.VC_EMP_ID 
                and a.vc_region = b.vc_code and c.ch_work_status in ('A','H','R') and c.vc_emp_id = '" . $emp_code . "'";
        if (isset($_GET['from_date']) && isset($_GET['to_date'])) {
            if ($_GET['from_date'] != '' && $_GET['to_date']) {
                $this->data['timesheet']['from_date'] = $_GET['from_date'];
                $this->data['timesheet']['to_date'] = $_GET['to_date'];
            }
        }
        $param = '';
        if ($this->data['timesheet']['from_date'] != '' && $this->data['timesheet']['to_date']) {
            $SQLEmpTs .= "and (a . DT_START_DATE between to_date('" . $this->data['timesheet']['from_date'] .
                    "' , 'DD-MM-YYYY') and to_date('" . $this->data['timesheet']['to_date'] . "' , 'DD-MM-YYYY') or a.DT_end_DATE between to_date('" . $this->data['timesheet']['from_date'] .
                    "' , 'DD-MM-YYYY') and to_date('" . $this->data['timesheet']['to_date'] . "' , 'DD-MM-YYYY'))";

            $param = "&from_date=" . $this->data['timesheet']['from_date'] . "&to_date=" . $this->data['timesheet']['to_date'];
        }
        if ($this->params['form'] != null || !empty($_REQUEST['TsFilter'])) {
            if (!empty($this->params['form']['TsFilter'])) {
                $SQLEmpTs .= " AND a.vc_status='" . $this->params['form']['TsFilter'] . "'";
            }
            if (!empty($_REQUEST['TsFilter'])) {
                $SQLEmpTs .= " AND a.vc_status='" . $_REQUEST['TsFilter'] . "'";
            }
            $param .= "&TsFilter=" . $_REQUEST['TsFilter'];
        }
        $this->set(compact('param'));
        $SQLEmpTs .= " and  b.vc_comp_code='01' ORDER BY a . dt_start_Date DESC ";
        $SQLEmpTs1 = $SQLEmpTs;
        $rsEmpTs1 = ociparse($db_con, $SQLEmpTs1);
        ociexecute($rsEmpTs1);
        $rsEmpTs = ociparse($db_con, $SQLEmpTs);
        ociexecute($rsEmpTs);
        $numEmpTs1 = oci_fetch_all($rsEmpTs1, $rwEmpTs1);
        $numEmpTs = oci_fetch_all($rsEmpTs, $rwEmpTs);
        $this->set('limit', $limit);
        $this->set('emp_code', $emp_code);
        $this->set('rwEmpTs', $rwEmpTs);
        $this->set('numEmpTs1', $numEmpTs1);
        $this->set('numEmpTs', $numEmpTs);
    }

    function tslist_new() {
        $this->layout = 'employee-new';
        $comp_code = '01';
        $emp_code = $this->Auth->User('emp_id');
        $vals = $this->MstTimesheet->find('all', array('conditions' => array(
                'vc_emp_id' => $emp_code),
            'order' => 'dt_start_date desc'));
        $this->set('limit', $limit);
        $this->set('emp_code', $emp_code);
        $this->set('rwEmpTs', $vals);
        $this->set('numEmpTs1', $numEmpTs1);
        $this->set('numEmpTs', $numEmpTs);
    }

    function delweektimesheet($task = '', $empcode = '', $id, $sno, $empid) {
        if ($task == "Delete") {
            $this->MstTimesheet->deleteAll(array('MstTimesheet.s_no' => $sno));
            $this->DtTimesheet->deleteAll(array('DtTimesheet.s_no' => $sno));
            $this->redirect('tslist_new');
        }
    }

    function delweektimesheetdtl($task = '', $id, $s_no, $vc_emp_id) {
        if ($task == "Delete") {
            $this->DtTimesheet->deleteAll(array('DtTimesheet.id' => $id));
            $this->redirect('editauto/' . $s_no . '/' . $vc_emp_id);
        }
    }

    function tsview($sno = '', $empid = '', $start = '', $end = '', $print = '', $ts_status = '', $cust_code) {

        $this->layout = 'admin';
        $emp_dtl = array($sno, $empid, $start, $end, $print, $ts_status, $cust_code);
        if ($ts_status == 'S') {
            $query = "SELECT a . s_no AS sno , NVL(a . vc_tot_frms , '0') AS totfrm , NVL(a . vc_tot_reps, '0') AS totrep ,
                    d . vc_emp_name manager, NVL(a . vc_tot_hrs, '0') tothrs , b . vc_code_desc AS region , b . vc_code As rcode ,
                    c . vc_emp_name AS emp_name , To_Char(a . DT_end_date, 'dd-mm-rrrr') AS end_date ,
                    To_char(a . dt_start_Date , 'dd-mm-rrrr') AS start_date ,
                    To_char(a . dt_applied , 'dd-mm-rrrr') AS applied , a . vc_status AS status, a . vc_ts_status as ts_type
                    FROM hrpay . mst_timesheet a , sales . mst_code b , hrpay . persdet c, hrpay . persdet d WHERE a . vc_emp_id = c . VC_EMP_ID  AND
                    a . vc_approved_code=d . vc_emp_code  and c . vc_comp_code=d . vc_comp_code  and a . vc_region = b . vc_code  AND c . vc_emp_id = '" . $empid . "'
                    and a . s_no =  '" . $sno . "' and To_Char(a . DT_START_DATE , 'dd-MON-yyyy')='" . $start . "'
                    AND To_Char(a . dt_end_Date, 'dd-MON-yyyy')='" . $end . "' ";
        } else {
            $query = "SELECT a . s_no AS sno, NVL(a . vc_tot_frms , '0') AS totfrm , NVL(a . vc_tot_reps, '0') AS totrep,
                    NVL(a . vc_tot_hrs, '0') tothrs, b . vc_code_desc AS region, b . vc_code As rcode, c . vc_emp_name AS emp_name ,
                    To_Char(a . DT_end_date, 'dd-mm-rrrr') AS end_date , To_Char(a . dt_start_Date, 'dd-mm-rrrr') AS start_date ,
                    To_Char(a . dt_applied, 'dd-mm-rrrr') AS applied, a . vc_status AS status, a . vc_ts_status as ts_type
                    FROM hrpay . mst_timesheet a, sales . mst_code b , hrpay . persdet c WHERE a . vc_emp_id = c . VC_EMP_ID  AND a . vc_region = b . vc_code
                    AND c . vc_emp_id = '" . $empid . "' AND a . s_no =  '" . $sno . "' AND To_Char(a . DT_START_DATE ,
                    'dd-MON-yyyy')='" . $start . "' AND To_Char(a . dt_end_Date, 'dd-MON-yyyy')='" . $end . "' ";
        }
        $db_con = $this->Functions->connRet();
        $statement = ociparse($db_con, $query);
        ociexecute($statement);
        $num_rows = ocifetchstatement($statement, $rows);
        ocifreestatement($statement);
        $type = ($rows['TS_TYPE'][0] == 'CO') ? 'Consolidated' : '';
        $tothrs1 = $rows['TOTHRS'][0];
        $SQLTsRec = "SELECT to_char(a.dt_wk_date,'dd-mm-yyyy') AS wk_date , a.VC_STRT_TIME , a.VC_END_TIME ,
                       a.VC_MODULE , a.VC_REMARKS , a.VC_FILE_NAME , a.VC_F_R,a.VC_MMPID,a.vc_hrs , a.nu_customer_no, a.VC_Leave,
                       a.vc_customer_name FROM hrpay . dt_timesheet a
                       WHERE a.vc_emp_id ='" . $empid . "' and a.S_NO ='" . $sno . "' ";

        if (!empty($this->params['form'])) {
            if (!empty($this->params['form']['customer_filter']) && $this->params['form']['customer_filter'] != '0') {
                $SQLTsRec .= " AND a.nu_customer_no='" . $this->params['form']['customer_filter'] . "'";
            } else if ($this->params['form']['customer_filter'] == '0') {
                $SQLTsRec .= " AND nu_customer_no is null";
            }
            $this->set('customer1', $this->params['form']['customer_filter']);
        } else if (is_numeric($cust_code)) {
            $SQLTsRec .= " AND a.nu_customer_no='" . $cust_code . "'";
            $this->set('customer1', $cust_code);
        }      //change end
        $SQLTsRec .= " ORDER BY a.dt_wk_date,a.vc_strt_time";

        $rsTsRec = ociparse($db_con, $SQLTsRec);
        ociexecute($rsTsRec);
        $numTsRec = ocifetchstatement($rsTsRec, $rwTsRec);
        ocifreestatement($rsTsRec);
        $SQLCus = "SELECT DISTINCT nvl(nu_customer_no,0) CID, nvl(vc_customer_name,'OnLeave/Holiday') AS CNAME
                     FROM hrpay . dt_timesheet  WHERE vc_emp_id ='" . $empid . "' and S_NO ='" . $sno . "' ";

        $rsCus = ociparse($db_con, $SQLCus);
        ociexecute($rsCus);
        $numCus = ocifetchstatement($rsCus, $rwCus);

        list($seldate, $smonth, $syear) = explode('-', $rows['START_DATE'][0]);
        $weekNumber = date('W', mktime(0, 0, 0, $smonth, $seldate, $syear));
        $this->set('rows', $rows);
        $this->set('num_rows', $num_rows);
        $this->set('rwTsRec', $rwTsRec);
        $this->set('numTsRec', $numTsRec);
        $this->set('emp_dtl', $emp_dtl);
        $this->set('type', $type);
        $this->set('empid', $empid);

        $this->set('rwCus', $rwCus);
        $this->set('numCus', $numCus);
    }

    function tsview_new($sno = '', $empid = '', $start = '', $end = '', $print = '', $ts_status = '', $cust_code) {
        $this->layout = 'employee-new';
        $emp_dtl = array($sno, $empid, $start, $end, $print, $ts_status, $cust_code);
        $data_array = $this->MstTimesheet->find('all', array(
            'conditions' => array('vc_emp_id' => $empid, 's_no' => $sno)
            , 'order' => 'id'));
        $SQLCus = "SELECT DISTINCT ifnull(nu_customer_no,0) CID, ifnull(vc_customer_name,'OnLeave/Holiday') AS CNAME
                     FROM dt_timesheet WHERE vc_emp_id ='" . $empid . "' and S_NO ='" . $sno . "' ";
        $rwCus = $this->MstTimesheet->query($SQLCus);
        list($seldate, $smonth, $syear) = explode('-', $rows['START_DATE'][0]);
        $weekNumber = date('W', mktime(0, 0, 0, $smonth, $seldate, $syear));
        $this->set('emp_dtl', $emp_dtl);
        $this->set('empid', $empid);
        $this->set('rwCus', $data_array);
    }

    function tsviewmngr($sno = '', $empid = '', $start = '', $end = '', $print = '', $ts_status = '', $cust_code) {
        $this->layout = 'printablepage';
        $emp_dtl = array($sno, $empid, $start, $end, $print, $ts_status, $cust_code);
        if ($ts_status == 'S') {
            $query = "SELECT a . s_no AS sno , NVL(a . vc_tot_frms , '0') AS totfrm , NVL(a . vc_tot_reps, '0') AS totrep ,
                    d . vc_emp_name manager, NVL(a . vc_tot_hrs, '0') tothrs , b . vc_code_desc AS region , b . vc_code As rcode ,
                    c . vc_emp_name AS emp_name , To_Char(a . DT_end_date, 'dd-mm-rrrr') AS end_date ,
                    To_char(a . dt_start_Date , 'dd-mm-rrrr') AS start_date ,
                    To_char(a . dt_applied , 'dd-mm-rrrr') AS applied , a . vc_status AS status, a . vc_ts_status as ts_type
                    FROM hrpay . mst_timesheet a , sales . mst_code b , hrpay . persdet c, hrpay . persdet d WHERE a . vc_emp_id = c . VC_EMP_ID  AND
                    a . vc_approved_code=d . vc_emp_code  and c . vc_comp_code=d . vc_comp_code  and a . vc_region = b . vc_code  AND c . vc_emp_id = '" . $empid . "'
                    and a . s_no =  '" . $sno . "' and To_Char(a . DT_START_DATE , 'dd-MON-yyyy')='" . $start . "'
                    AND To_Char(a . dt_end_Date, 'dd-MON-yyyy')='" . $end . "' ";
        } else {
            $query = "SELECT a . s_no AS sno, NVL(a . vc_tot_frms , '0') AS totfrm , NVL(a . vc_tot_reps, '0') AS totrep,
                    NVL(a . vc_tot_hrs, '0') tothrs, b . vc_code_desc AS region, b . vc_code As rcode, c . vc_emp_name AS emp_name ,
                    To_Char(a . DT_end_date, 'dd-mm-rrrr') AS end_date , To_Char(a . dt_start_Date, 'dd-mm-rrrr') AS start_date ,
                    To_Char(a . dt_applied, 'dd-mm-rrrr') AS applied, a . vc_status AS status, a . vc_ts_status as ts_type
                    FROM hrpay . mst_timesheet a, sales . mst_code b , hrpay . persdet c WHERE a . vc_emp_id = c . VC_EMP_ID  AND a . vc_region = b . vc_code
                    AND c . vc_emp_id = '" . $empid . "' AND a . s_no =  '" . $sno . "' AND To_Char(a . DT_START_DATE ,
                    'dd-MON-yyyy')='" . $start . "' AND To_Char(a . dt_end_Date, 'dd-MON-yyyy')='" . $end . "' ";
        }
        $db_con = $this->Functions->connRet();
        $statement = ociparse($db_con, $query);
        ociexecute($statement);
        $num_rows = ocifetchstatement($statement, $rows);
        ocifreestatement($statement);
        $type = ($rows['TS_TYPE'][0] == 'CO') ? 'Consolidated' : '';
        $tothrs1 = $rows['TOTHRS'][0];
        $SQLTsRec = "SELECT to_char(a.dt_wk_date,'dd-mm-yyyy') AS wk_date , a.VC_STRT_TIME , a.VC_END_TIME ,
                       a.VC_MODULE , a.VC_REMARKS , a.VC_FILE_NAME , a.VC_F_R,a.VC_MMPID,a.vc_hrs , a.nu_customer_no, a.VC_Leave,
                       a.vc_customer_name, D . VC_ACTIVITY, a . VC_SUBPROJECT FROM hrpay . dt_timesheet a LEFT JOIN  hrpay . dt_costing_sheet D ON
                       D.VC_DSNO = a.vc_milestone_id
                       WHERE a.vc_emp_id ='" . $empid . "' and a.S_NO ='" . $sno . "' ";
        if (!empty($this->params['form'])) {
            if (!empty($this->params['form']['customer_filter']) && $this->params['form']['customer_filter'] != '0') {
                $SQLTsRec .= " AND a.nu_customer_no='" . $this->params['form']['customer_filter'] . "'";
            } else if ($this->params['form']['customer_filter'] == '0') {
                $SQLTsRec .= " AND nu_customer_no is null";
            }
            $this->set('customer1', $this->params['form']['customer_filter']);
        } else if (is_numeric($cust_code)) {


            $SQLTsRec .= " AND a.nu_customer_no='" . $cust_code . "'";
            $this->set('customer1', $cust_code);
        }      //change end
        $SQLTsRec .= " ORDER BY a.dt_wk_date,a.vc_strt_time";

        $rsTsRec = ociparse($db_con, $SQLTsRec);
        ociexecute($rsTsRec);
        $numTsRec = ocifetchstatement($rsTsRec, $rwTsRec);
        ocifreestatement($rsTsRec);
        //Fetch all customer In case of Consolidate TS
        $SQLCus = "SELECT DISTINCT nvl(nu_customer_no,0) CID, nvl(vc_customer_name,'OnLeave/Holiday') AS CNAME
                     FROM hrpay . dt_timesheet  WHERE vc_emp_id ='" . $empid . "' and S_NO ='" . $sno . "' ";

        $rsCus = ociparse($db_con, $SQLCus);
        ociexecute($rsCus);
        $numCus = ocifetchstatement($rsCus, $rwCus);

        list($seldate, $smonth, $syear) = explode('-', $rows['START_DATE'][0]);
        $weekNumber = date('W', mktime(0, 0, 0, $smonth, $seldate, $syear));
        //pr($rwTsRec);
        $this->set('rows', $rows);
        $this->set('num_rows', $num_rows);
        $this->set('rwTsRec', $rwTsRec);
        $this->set('numTsRec', $numTsRec);
        $this->set('emp_dtl', $emp_dtl);
        $this->set('type', $type);
        $this->set('empid', $empid);

        $this->set('rwCus', $rwCus);
        $this->set('numCus', $numCus);
    }

    function editauto($sno = '', $empid = '', $start = '', $end = '', $flag = '', $manager = '') {
        $this->layout = 'employee-new';
        $comp_code = '01';
        $empdetail = array($sno, $empid, $start, $end, $flag);
        $data_array = $this->MstTimesheet->find('all', array('conditions' => array(
                'vc_emp_id' => $empid, 's_no' => $sno),
        ));
        $tms_all = new Model(array('table' => 'bugs', 'ds' => 'sqltest', 'name' => 'bugs'));
        $tms_id_user = $tms_all->find('list', array('fields' => array('bugiddisp'), 'conditions' => array('bugiddisp >' => 40000)));

        if (empty($tms_id_user)) {
            echo "PEG Users TMS is Down Please Wait ... ";
            die;
        }
        $tms_id_user['Others'] = 'Others';
        $tms_ids = json_encode(array_values($tms_id_user));
        $primary_milestone = new Model(array('table' => 'primary_milestone', 'ds' => 'default', 'name' => 'MILESTONE'));
        $primary_milestone_list = $primary_milestone->find('list', array('fields' => array('id','name')));
        $this->set('primary_milestone_list', $primary_milestone_list);
        $this->set('tms_id', $tms_ids);
        if (!empty($manager)) {
            $this->set('manager', $manager);
        } else {
            $manager = '';
            $this->set('manager', $manager);
        }
        $read0nly = ($flag == "milestone") ? 'readonly="readonly"' : '';
        $this->set('sno', $sno);
        $this->set('rows', $rows);
        $this->set('statement', $statement);
        $this->set('rwTsRec', $data_array);
        $this->set('numTsRec', $numTsRec);
        $this->set('empdetail', $empdetail);
        $this->set('flag', $flag);
    }

    function autosuggestion($json = 'true', $input = '') {
        $this->layout = '';
        $this->autoRender = false;
        die('ayush');
    }

    function tsauto() {
        $this->layout = 'employee-new';
        $comp_code = '01';
        $emp_code = $this->Auth->User('emp_code');
        $empid = $this->Auth->User('emp_id');
        $this->MstTimesheet->recursive = -1;
        $get_lastweek = $this->MstTimesheet->find('all', array('fields' => array('MAX(dt_end_date) as dt_end_date'),
            'conditions' => array(
                'vc_emp_id' => $empid),
        ));
        $personal_details = $this->MyProfile->find('first', array('fields' => array('emp_id', 'manager_code', 'join_date'),
            'conditions' => array(
                'emp_code' => $emp_code),
        ));

        if (empty($get_lastweek[0][0]['dt_end_date'])) {
            $get_lastweek[0][0]['dt_end_date'] = date('Y-m-d', strtotime("previous sunday", strtotime($personal_details['MyProfile']['join_date'])));
        }
        $get_max_s_no = $this->MstTimesheet->find('all', array('fields' => array('MAX(s_no) as s_no'),
        ));
        $get_nxt_start_date = date('Y-m-d', strtotime($get_lastweek[0][0]['dt_end_date'] . '+1 day'));
        $get_nxt_end_date = date('Y-m-d', strtotime($get_lastweek[0][0]['dt_end_date'] . '+7 day'));

        $personal_details = $this->MyProfile->find('first', array('fields' => array('emp_id', 'manager_code'),
            'conditions' => array(
                'emp_code' => $emp_code),
        ));
        $data['vc_emp_id'] = $empid;
        $data['dt_start_date'] = $get_nxt_start_date;
        $data['dt_end_date'] = $get_nxt_end_date;
        $data['s_no'] = $get_max_s_no[0][0]['s_no'] + 1;
        $data['vc_cur_mgr_id'] = $personal_details['MyProfile']['manager_code'];
        $data['timesheet_id'] = 1;
        $data['vc_tot_hrs'] = '48:00';
        $data['vc_tot_frms'] = 0;
        $data['vc_tot_reps'] = 0;
        $data['vc_status'] = 'I';
        $data['vc_ts_status'] = 'CO';
        $data['dt_forward_date'] = '';
        $data['dt_approved'] = '';
        $data['dt_applied'] = date('Y-m-d');
        if ($this->MstTimesheet->save($data)) {
            for ($i = 1; $i <= 7; $i++) {
                $data_dt['vc_emp_id'] = $empid;
                $data_dt['dt_wk_date'] = date('Y-m-d', strtotime($get_lastweek[0][0]['dt_end_date'] . '+' . $i . 'day'));
                $data_dt['vc_strt_time'] = '09:30';
                $data_dt['vc_end_time'] = '17:30';
                $data_dt['vc_hrs'] = '08:00';
                $data_dt['vc_module'] = 'None';
                $data_dt['vc_remarks'] = 'Auto Generated';
                $data_dt['s_no'] = $get_max_s_no[0][0]['s_no'] + 1;
                $data_dt['mst_timesheet_id'] = $this->MstTimesheet->getLastInsertID();
                $data_dt['tms_id'] = 'Others';

                $this->DtTimesheet->create();
                $this->DtTimesheet->save($data_dt);
            }
        }
        $data_array = $this->MstTimesheet->find('first', array('conditions' => array(
                'vc_emp_id' => $empid),
        ));
        $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                            <a href="#" class="uk-alert-close uk-close"></a>Timesheet generated Successfully , please edit and send for approval.</div>');
        $this->redirect('tslist_new');
        $this->set('emp_code', $emp_code);
        $this->set('region', $region_name);
        $this->set('region_code', $region);
        $this->set('rwTsRec', $data_array);
    }
    
    function approve_timesheet($data_array){
        //Configure::write('debug',2);
        $status = "'Checked'";
        foreach($this->request->data['all'] as $k){
        $this->DtTimesheet->updateAll(
            array('DtTimesheet.vc_cm_code' => $status),
            array('DtTimesheet.id' => $k)
        );
        } 
        $status_approve = "'I'";
        $this->MstTimesheet->updateAll(
            array('MstTimesheet.vc_status' => $status_approve),
            array('MstTimesheet.s_no' => $this->request->data['sno'])
        );
        if($this->request->data['all'][0] == 'on'){
        $status_approve = "'S'";
        $dt_approve = "'".date('Y-m-d')."'";
        $this->MstTimesheet->updateAll(
            array('MstTimesheet.vc_status' => $status_approve,'MstTimesheet.dt_approved' => $dt_approve),
            array('MstTimesheet.s_no' => $this->request->data['sno'])
        );
        $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                            <a href="#" class="uk-alert-close uk-close"></a>Timesheet Approved.</div>');
        
        } else {
            $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                            <a href="#" class="uk-alert-close uk-close"></a>Timesheet partially approved and sent for moderation.</div>');
        
        }
        $this->redirect('sanctionedlist');
        
    }
    
    function forward_timesheet(){
        //print_r($this->request->data); die;
        $manager_code = "'".$this->request->data['forward_to_code']."'";
        $manager_remark = "'".$this->request->data['forward_to_remark']."'";
        
        foreach($this->request->data['all'] as $k){
        $this->MstTimesheet->updateAll(
            array('MstTimesheet.vc_cur_mgr_id' => $manager_code,'MstTimesheet.vc_forward_remarks' => $manager_remark),
            array('MstTimesheet.s_no' => $k)
        );
        } 
        $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                            <a href="#" class="uk-alert-close uk-close"></a>Timesheet Forwarded Successfully.</div>');
        $this->redirect('sanctionedlist');
        
    }

    function save_timesheet() {
        if($this->request->data['sheet_status_manager'] == 'Approve'){
            $this->approve_timesheet($this->request->data);
        }
		//print_r($this->request->data); die;
        for ($i = 0; $i < count($this->request->data['tms_id']); $i++) {
            if (!empty($this->request->data['record_id'][$i])) {
                $data_dt['id'] = $this->request->data['record_id'][$i];
            } else {
                unset($data_dt['id']);
            }
            $data_dt['vc_emp_id'] = $this->request->data['$this->request->data'];
            $data_dt['dt_wk_date'] = date('Y-m-d', strtotime($this->request->data['dt_week_dt'][$i]));
            $data_dt['vc_strt_time'] = $this->request->data['start_time'][$i];
            $data_dt['vc_end_time'] = $this->request->data['end_time'][$i];
            $data_dt['vc_hrs'] = $this->request->data['total_hrs'][$i];
            $data_dt['vc_module'] = $this->request->data['module'][$i];
            $data_dt['vc_remarks'] = $this->request->data['remark'][$i];
            $data_dt['vc_emp_id'] = $this->request->data['empid'];
            $data_dt['s_no'] = $this->request->data['sno'];
            $data_dt['mst_timesheet_id'] = $this->request->data['sno'];
            $data_dt['tms_id'] = $this->request->data['tms_id'][$i];
            $data_dt['vc_f_r'] = $this->request->data['frms_report'][$i];
            $data_dt['nu_customer_no'] = $this->request->data['customer_code'][$i];
            $data_dt['vc_customer_name'] = $this->request->data['customer_name'][$i];
            $data_dt['tms_customer'] = $this->request->data['customer_name'][$i];
            $data_dt['changed_date'] = date('Y-m-d');
            $data_dt['primary_milestone_id'] = $this->request->data['primary_milestone_id'][$i];
            $data_dt['bt_type'] = $this->request->data['bug_type'][$i];
            $this->DtTimesheet->create();
            $this->DtTimesheet->save($data_dt);
        }
        $tot_hrs = "'".$this->request->data['tothr']."'";
        $status = "'P'";
        $this->MstTimesheet->updateAll(
            array('MstTimesheet.vc_tot_hrs' => $tot_hrs),
            array('MstTimesheet.s_no' => $this->request->data['sno'])
        );
        $dt_applied = "'".date('Y-m-d')."'";
        if($this->request->data['sheet_status_manager'] == 'Submit To Manager'){
            $this->MstTimesheet->updateAll(
            array('MstTimesheet.vc_cur_mgr_id' => $this->Common->getManagerCodebyID($this->request->data['empid']),
                'MstTimesheet.vc_status' => $status,'MstTimesheet.dt_applied' => $dt_applied),
            array('MstTimesheet.s_no' => $this->request->data['sno'])
        );
            $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                            <a href="#" class="uk-alert-close uk-close"></a>Timesheet sent to manager for approval.</div>');
            $this->redirect('tslist_new');
        }
        $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                            <a href="#" class="uk-alert-close uk-close"></a>Changes to Timesheet saved successfully.</div>');

        $this->redirect('editauto/' . $this->request->data['sno'] . '/' . $this->request->data['empid']);
    }

    function autosuggestionbyemp($region = '') {
        
    }

    function tsreport() {
        $values = $this->DtTimesheet->find('all',array('fields'=>array('sum(vc_hrs)','nu_customer_no'),
            'group'=> 'nu_customer_no'
        ));
        $times = array();
        $times[] = "12:59";
        $times[] = "0:58";
        $times[] = "0:02";
        echo $this->AddPlayTime($times); die;
        
    }

    function sendreminder($empval, $stdate, $eddate) {
        
    }
    public function getmilestones($cust_id){
		App::import("Model", "DtCosting");
        $model = new DtCosting();
		$this->autoRender = false;
		$section_dtl = $model->find('all', array(
            'fields' => array('DtCosting.vc_dsno', 'DtCosting.vc_activity'),
            'joins' => array(
                array(
                    'table' => 'hd_costing_sheet',
                    'alias' => 'HdCosting',
                    'type' => 'left',
                    'foreignKey' => false,
                    'conditions' => array('HdCosting.vc_sno = DtCosting.vc_sno')
                ),
            ),
            'conditions' => array('HdCosting.nu_cust_code' => $cust_id)
        ));
		$html = '<select name="data[milestone_id][]" id="milestone_id_'.$x.'>';
		foreach($section_dtl as $ne){
			$html.= '<option value="'.$ne['DtCosting']['vc_dsno'].'">'.$ne['DtCosting']['vc_activity'].'</option>';
		}
		$html.= '</select>'	;
		echo $html;
    }
		
    function AddPlayTime($times) {
    $minutes = 0; //declare minutes either it gives Notice: Undefined variable
    // loop throught all the times
    foreach ($times as $time) {
        list($hour, $minute) = explode(':', $time);
        $minutes += $hour * 60;
        $minutes += $minute;
    }

    $hours = floor($minutes / 60);
    $minutes -= $hours * 60;

    // returns the time already formatted
    return sprintf('%02d:%02d', $hours, $minutes);
    }

    function sanctionedlist() {
        $this->layout = 'employee-new';
        $comp_code = '01';
        $emp_code = $this->Auth->user('emp_code');
        $vals = $this->MstTimesheet->find('all', array('conditions' => array(
                'vc_cur_mgr_id' => $emp_code,
                'vc_status in ("P","S")'),
            'order' => 'vc_status'));
        $this->set('limit', $limit);
        $this->set('emp_code', $emp_code);
        $this->set('rwEmpTs', $vals);
        $this->set('numEmpTs1', $numEmpTs1);
        $this->set('numEmpTs', $numEmpTs);
    }

    function getdtl($term) {
        $this->autoRender = false;
        $term = $_POST['keyword'];
        $values = $this->MyProfile->find('all', array('fields' => array('emp_code', 'emp_full_name'),
            'conditions' => array('emp_name LIKE' => "%$term%")));
        $html = '<ul id="country-list">';
        foreach ($values as $country) {
            $val = "'" . $country["MyProfile"]["emp_full_name"] . "'";
            $val1 = "'" . $country["MyProfile"]["emp_code"] . "'";
            $html .= '<li onClick="selectCountry(' . $val . ',' . $val1 . ');">' . $country["MyProfile"]["emp_full_name"] . '</li>';
        }
        $html .= '</ul>';
        echo $html;
        die;
    }
    function getcustomer($id) {
        $this->autoRender = false;
        $term = $_POST['keyword'];
        $bank = new Model(array('table' => 'oracle_app_eo', 'ds' => 'default', 'name' => 'CUSTOMERS'));
        $values = $bank->find('all', array('fields' => array('eo_leg_code', 'eo_nm'), 
            'conditions' => array('eo_type' => 68, 'eo_nm LIKE' => "%$term%")));
        
        $html = '<ul id="country-list">';
        foreach ($values as $country) {
            $val = "'" . $country["CUSTOMERS"]["eo_nm"] . "'";
            $val1 = "'" . $country["CUSTOMERS"]["eo_leg_code"] . "'";
            $html .= '<li onClick="selectCountry(' . $val . ',' . $val1 . ',' . $id . ');">' . $country["CUSTOMERS"]["eo_nm"] . '</li>';
        }
        $html .= '</ul>';
        echo $html;
        die;
    }

    function managerfrwd($empval, $stdate, $eddate, $managerdesg) {
        
    }

    function rejecttimesheet() {
        $empid = $this->params['form']['empid'];
        if ($this->params['form']['rej'] == 'Reject') {
            $SQLMasterTs = "UPDATE hrpay . mst_timesheet SET VC_STATUS = 'R', vc_reject='" . $this->params['form']['rejectreson'] . "' 
                                WHERE S_NO='" . $this->params['form']['sno'] . "' AND   VC_EMP_ID='" . $empid . "'";
        }
    }

    function tsrules() {

        $this->layout = 'employee';
        $comp_code = $this->Auth->User('vc_comp_code');
        $emp_code = $this->Auth->User('vc_emp_id_makess');
    }

    function getrejectionresion($sno, $empid) {
        $this->layout = '';
        $comp_code = $this->Auth->User('vc_comp_code');
        $emp_code = $this->Auth->User('vc_emp_id_makess');

        if (!empty($sno)) {
            $conStr1 = $this->General->query("SELECT vc_reject FROM hrpay . mst_timesheet WHERE S_NO='" . $sno . "' AND   VC_EMP_ID='" . $empid . "'");

            $this->set('rejectcmnt', $conStr1);
            $this->set('vou_no', $sno);
            $this->render('/timesheet/getrejectionresion');
        }
    }

    function getmngfrwdresion($sno, $empid) {
        $this->layout = '';
        $comp_code = $this->Auth->User('vc_comp_code');
        $emp_code = $this->Auth->User('vc_emp_id_makess');

        if (!empty($sno)) {
            $conStr1 = $this->General->query("SELECT vc_forward_remarks FROM hrpay . mst_timesheet WHERE S_NO='" . $sno . "' AND   VC_EMP_ID='" . $empid . "'");

            $this->set('forwardcmnt', $conStr1);
            $this->set('vou_no', $sno);
            $this->render('/timesheet/getforwardresion');
        }
    }

    function findleave($empId = NULL, $startDate = NULL, $endDate = NULL) {
        
    }

    /* ============Endb 23 Feb 2015 ================= */

    function reminder() {
        
    }

    public function import_timesheet_data() {
        $this->autoRender = false;
        $db_con = $this->Functions->connRet();
        $SQLEmpTs1 = "SELECT VC_REGION, VC_EMP_ID, DT_START_DATE, DT_END_DATE, S_NO, VC_TOT_HRS, VC_TOT_FRMS, VC_TOT_REPS, DT_APPLIED, VC_STATUS, VC_TS_STATUS, DT_APPROVED, VC_APPROVED_CODE, VC_REJECT, VC_FORWARD_REMARKS, VC_FORWARD_MANAGER, DT_FORWARD_DATE, VC_FORWARDED_TO_MGR, VC_CUR_MGR_ID FROM HRPAY.MST_TIMESHEET
			WHERE DT_START_DATE >= to_date('04-12-2017' ,'dd-mm-yyyy')";
        $rsEmpTs1 = ociparse($db_con, $SQLEmpTs1);
        oci_execute($rsEmpTs1);
        while (($row = oci_fetch_array($rsEmpTs1, OCI_BOTH)) != false) {
            $values[] = $row;
        }
        $arr = new Model(array('table' => 'mst_timesheet', 'ds' => 'default', 'name' => 'DBCONF'));
        foreach ($values as $v) {
            $var = "INSERT INTO mst_timesheet (vc_region, vc_emp_id, dt_start_date, dt_end_date, s_no, vc_tot_hrs, vc_tot_frms, vc_tot_reps, dt_applied, vc_status, vc_ts_status, dt_approved, vc_approved_code, vc_reject, vc_forward_remarks, vc_forward_manager, dt_forward_date, vc_forwarded_to_mgr, vc_cur_mgr_id, id, timesheet_id) VALUES ('" . $v['VC_REGION'] . "', '" . $v['VC_EMP_ID'] . "', '" . date('Y-m-d', strtotime($v['DT_START_DATE'])) . "', '" . date('Y-m-d', strtotime($v['DT_END_DATE'])) . "', '" . $v['S_NO'] . "', '" . $v['VC_TOT_HRS'] . "', '" . $v['VC_TOT_FRMS'] . "', '" . $v['VC_TOT_REPS'] . "', '" . date('Y-m-d', strtotime($v['DT_APPLIED'])) . "', '" . $v['VC_STATUS'] . "', '" . $v['VC_TS_STATUS'] . "', '" . date('Y-m-d', strtotime($v['DT_APPROVED'])) . "', '" . $v['VC_APPROVED_CODE'] . "', '" . $v['VC_REJECT'] . "', '" . $v['VC_FORWARD_REMARKS'] . "', '" . $v['VC_FORWARD_MANAGER'] . "', '" . date('Y-m-d', strtotime($v['DT_FORWARD_DATE'])) . "', '" . $v['VC_FORWARDED_TO_MGR'] . "', '" . $v['VC_CUR_MGR_ID'] . "', NULL, '1')";
            $valu = $arr->query($var);
        }
    }

    public function import_timesheet_detail() {
        $this->autoRender = false;
        $db_con = $this->Functions->connRet();
        $SQLEmpTs1 = "SELECT S_NO, VC_EMP_ID, DT_WK_DATE, VC_STRT_TIME, VC_END_TIME, VC_HRS, VC_MODULE, VC_REMARKS, VC_FILE_NAME, VC_F_R, NU_CUSTOMER_NO, VC_CUSTOMER_NAME, VC_CM_CODE, VC_PM_CODE, VC_MILESTONE_ID, VC_LEAVE, VC_MMPID, VC_SUBPROJECT, VC_COMP_CODE, TMS_ID, TMS_CUSTOMER, DT_SAVED, CHANGED_DATE, BT_TYPE, PRIMARY_MILESTONE_ID FROM HRPAY.DT_TIMESHEET WHERE DT_WK_DATE >= to_date('04-12-2017' ,'dd-mm-yyyy')";
        $rsEmpTs1 = ociparse($db_con, $SQLEmpTs1);
        oci_execute($rsEmpTs1);
        while (($row = oci_fetch_array($rsEmpTs1, OCI_BOTH)) != false) {
            $values[] = $row;
        }
        $arr = new Model(array('table' => 'dt_timesheet', 'ds' => 'default', 'name' => 'DBCONF'));
        $valu = $arr->query('TRUNCATE DT_TIMESHEET');
        foreach ($values as $v) {
            $var = "INSERT INTO dt_timesheet (s_no, vc_emp_id, dt_wk_date, vc_strt_time, vc_end_time, vc_hrs, vc_module, vc_remarks, vc_file_name, vc_f_r, nu_customer_no, vc_customer_name, vc_cm_code, vc_pm_code, vc_milestone_id, vc_leave, vc_mmpid, vc_subproject, vc_comp_code, tms_id, tms_customer, dt_saved, changed_date, bt_type, primary_milestone_id, id, mst_timesheet_id) VALUES ('" . $v['S_NO'] . "', '" . $v['VC_EMP_ID'] . "', '" . date('Y-m-d', strtotime($v['DT_WK_DATE'])) . "', '" . $v['VC_STRT_TIME'] . "', '" . $v['VC_END_TIME'] . "', '" . $v['VC_HRS'] . "', '" . str_replace("'", "", $v['VC_MODULE']) . "', '" . htmlentities(str_replace("'", "", str_replace(".", "", $v['VC_REMARKS']))) . "', '" . str_replace("'", "", $v['VC_FILE_NAME']) . "', '" . str_replace("'", "", $v['VC_F_R']) . "', '" . $v['NU_CUSTOMER_NO'] . "', '" . str_replace($v['VC_CUSTOMER_NAME']) . "', '" . $v['VC_CM_CODE'] . "', '" . $v['VC_PM_CODE'] . "', '" . $v['VC_MILESTONE_ID'] . "', '" . $v['VC_LEAVE'] . "', '" . str_replace($v['VC_MMPID']) . "', '" . str_replace($v['VC_SUBPROJECT']) . "', '" . $v['VC_COMP_CODE'] . "', '" . $v['TMS_ID'] . "', '" . $v['TMS_CUSTOMER'] . "', '" . date('Y-m-d H:i:s', strtotime($v['DT_SAVED'])) . "', '" . date('Y-m-d', strtotime($v['CHANGED_DATE'])) . "', '" . str_replace($v['BT_TYPE']) . "', '" . $v['PRIMARY_MILESTONE_ID'] . "', NULL,'" . $v['S_NO'] . "')";
            $valu = $arr->query($var);
            echo ";</br>";
        }
        $valu = $arr->find('all');
    }

    public function get_cust_dtl($tms_id) {
        $tms_id_user = $this->Bugs->find('first', array('fields' => array('customer.name', 'module.name', 'description', 'ticket.name', 'customer_id'),
            'joins' => array(
                array(
                    'table' => 'modulemasters',
                    'alias' => 'module',
                    'type' => 'inner',
                    'foreignKey' => false,
                    'conditions' => array('module.id= bugs.module_id')
                ),
                array(
                    'table' => 'customers',
                    'alias' => 'customer',
                    'type' => 'inner',
                    'foreignKey' => false,
                    'conditions' => array('customer.id= bugs.customer_id')
                ),
                array(
                    'table' => 'ticketmasters',
                    'alias' => 'ticket',
                    'type' => 'left',
                    'foreignKey' => false,
                    'conditions' => array('ticket.id= bugs.ticket_type_id')
                )),
            'conditions' => array('bugiddisp' => $tms_id),
        ));
        $tms_all = new Model(array('table' => 'customers', 'ds' => 'sqltest', 'name' => 'bugs'));
        $tmscustid = $tms_all->find('first', array('fields' => array('portal_customer_id'), 'conditions' => array('id' => $tms_id_user['Bugs']['customer_id'])));
        if (!empty($tmscustid['bugs']['portal_customer_id'])) {
            $tms_cst_list = $tmscustid['bugs']['portal_customer_id'];
        } else {
            $tms_cst_list = '';
        }
        //$milestonelist=$this->TSMilestone($tms_cst_list,"","","",false);
        $array = array('Customer_ID' => $tms_id_user['Bugs']['customer_id'], 'Customer' => $tms_id_user['customer']['name'], 'Module' => $tms_id_user['module']['name'], 'nature_of_bug' => $tms_id_user['ticket']['name'], 'description' => $tms_id_user['Bugs']['description']);
        echo json_encode($array);
        die;
    }
    
    public function reject_timesheet(){
            $this->autoRender = false;
            $this->MstTimesheet->updateAll(
                array('MstTimesheet.vc_status' => "'R'",
                    'MstTimesheet.vc_reject' => "'".$this->request->data['timesheet']['reject_remark']."'"),
                array('MstTimesheet.s_no' => $this->request->data['timesheet']['timesheet_id'])
            );
            $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                            <a href="#" class="uk-alert-close uk-close"></a>Timesheet rejected successfully.</div>');
       
            $this->redirect('sanctionedlist');
        
    }
    
    public function rej_remark(){
            $this->autoRender = false;
            $this->MstTimesheet->find('first',array('fields'=>array()));
            $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                            <a href="#" class="uk-alert-close uk-close"></a>Timesheet rejected successfully.</div>');
       
            $this->redirect('sanctionedlist');
        
    }

}
