<?php

App::uses('Component', 'Controller');

class EmpDetailComponent extends Component {

    public $uses = array('UserDetail', 'Travelvouchermaster', 'MyProfile',
        'WfMstAppMapLvl', 'DtAppMapLvl', 'Department', 'Designation', 'MstEmpLeaveAllot', 'MstTravelVoucher', 'LeaveDetail', 'LeaveWorkflow', 'MstEmpLeave');

    public function __construct(ComponentCollection $collection, $settings = array()) {
        parent::__construct($collection, $settings);
    }

    public function initialize(Controller $controller) {
        //load required for component models
        if ($this->uses !== false) {
            foreach ($this->uses as $modelClass) {
                $controller->loadModel($modelClass);
                $this->$modelClass = $controller->$modelClass;
            }
        }
    }

    public function beforeRender(Controller $controller) {
        
    }

    public function shutdown(Controller $controller) {
        
    }

    public function startup(Controller $controller) {
        $this->controller = $controller;
    }

    public function getdepartmentdetail() {
        $ho_org_id = $_SESSION['Auth']['MyProfile']['comp_code'];
        $depcode = $_SESSION['Auth']['MyProfile']['dept_code'];
        $dept_val = $this->Department->find('first', array(
            'fields' => array('Department.dept_name'),
            'conditions' => array(
                'dept_code' => $depcode,
                'comp_code' => $ho_org_id)
        ));
        return $dept_val['Department']['dept_name'];
    }

    public function getdesgdetail() {
        $deptcode = $_SESSION['Auth']['MyProfile']['dept_code'];
        $dsgcode = $_SESSION['Auth']['MyProfile']['desg_code'];
        $desg_val = $this->Designation->find('first', array(
            'fields' => array('Designation.desc'),
            'conditions' => array(
                'desg_code' => $dsgcode,
                'dept_code' => $deptcode)
        ));
        return $desg_val['Designation']['desc'];
    }

    public function findtravelamt($type = NULL) {

        //$ho_org_id = $_SESSION['Auth']['MyProfile']['comp_code'];
        $tv = $this->MstTravelVoucher->find('list', array(
            'fields' => array('id', 'desc'),
            'conditions' => array(
                'type' => $type,
                'status' => true)
        ));

        return $tv;
    }

    public function getdepartmentlist() {
        $comp_code = $_SESSION['Auth']['MyProfile']['comp_code'];
        $deptlist = $this->Department->find('list', array(
            'fields' => array('Department.dept_code', 'Department.dept_name'),
            'conditions' => array(
                'comp_code' => $comp_code)
        ));
        return $deptlist;
    }

    public function getdesignationlist() {
        $comp_code = $_SESSION['Auth']['MyProfile']['comp_code'];
        $deptlist = $this->Designation->find('list', array(
            'fields' => array('Designation.desg_code', 'Designation.desc'),
            'conditions' => array(
                'comp_code' => $comp_code)
        ));
        return $deptlist;
    }

    public function getemployeeinfomation($emp_code = NULL) {
        $user_details = $this->MyProfile->find('first', array(
            'conditions' => array(
                'emp_code' => $emp_code
        )));
        
        return $user_details;
    }

    public function getlaststagelevel($appid = NULL, $emp_dept_id = NULL) {
        $org_id = $_SESSION['Auth']['MyProfile']['comp_code'];
        $emp_desg_id = $_SESSION['Auth']['MyProfile']['desg_code'];

        $query = $this->WfMstAppMapLvl->find('first', array(
            'fields' => array('WfMstAppMapLvl.wf_dept_id', 'WfMstAppMapLvl.wf_max_lvl', 'DtAppMapLvl.wf_id', 'DtAppMapLvl.wf_lvl',
                'DtAppMapLvl.wf_desg_id'),
            'joins' => array(
                array(
                    'table' => 'wf_dt_app_map_lvl',
                    'alias' => 'DtAppMapLvl',
                    'type' => 'inner',
                    'foreignKey' => false,
                    'conditions' => array('DtAppMapLvl.wf_app_map_lvl_id = WfMstAppMapLvl.wf_id ')
                )
            ),
            'conditions' => array(
                'WfMstAppMapLvl.comp_code' => $org_id,
                'WfMstAppMapLvl.wf_dept_id' => $emp_dept_id,
                'WfMstAppMapLvl.wf_app_id' => $appid,
                'DtAppMapLvl.wf_desg_id' => $emp_desg_id)
        ));
        $status = 0;
        if (!empty($query['WfMstAppMapLvl']['wf_max_lvl'])) {
            $maxlvl = $query['WfMstAppMapLvl']['wf_max_lvl'];
            $lvl = $maxlvl - 1;
            $getlabenm = 'Level' . $lvl;
            if ($getlabenm == $query['DtAppMapLvl']['wf_lvl']) {
                $status = 5;
            }
        }
        return $status;
    }

    function getBalLeave($emp_code, $lvtype) {
        $bal = $this->MstEmpLeaveAllot->find('first', array('conditions' => array('emp_code' => $emp_code, 'leave_code' => $lvtype)));
        if (!empty($bal))
            return $bal['MstEmpLeaveAllot']['allot_leave'];
        else
            return 0;
    }

    //function to calculate the pending notification

    function getPendingLeaves($emp_code) {
        App::import("Model", "LeaveDetail");
        $model = new LeaveDetail();
        App::import("Model", "MstEmpLeave");
        $model2 = new MstEmpLeave();
        $con2 = $model->find('all', array(
            'fields' => array('DISTINCT (LeaveDetail.leave_id)', 'LeaveDetail.leave_status'),
            'conditions' => array(
                'AND' => array(
                    'LeaveDetail.emp_code' => $emp_code,
                    'LeaveDetail.leave_status in (1,2,6)', //open,forwarded,pending at HR
                )
            )
                )
        );
        $leave_ids = array();
        foreach ($con2 as $key => $value) {
            $leave_ids[] = $value['LeaveDetail']['leave_id'];
            # code...
        }

        $leavelist = implode(',', $leave_ids);
        if (!empty($leavelist)) {
            $con3 = $model2->find('all', array(
                'conditions' => array(
                    "MstEmpLeave.leave_id in ($leavelist)",
                )
                    )
            );
        } else {
            $con3 = 0;
        }


        if (empty($con3)) {
            return 0;
        } else {
            return $con3;
        }
    }

    function getOptionName($optionCode) {
        App::import("Model", "OptionAttribute");
        $model = new OptionAttribute();
        $con2 = $model->find('first', array(
            'conditions' => array(
                'OptionAttribute.id' => $optionCode)
        ));
        if (empty($con2)) {
            return 0;
        } else {
            return $con2['OptionAttribute']['name'];
        }
    }

    function getPendingLeave($emp_code) {
        App::import("Model", "LeaveDetail");
        $model = new LeaveDetail();
        $emp_code = $emp_code;
        $result = $model->find('all', array(
            'fields' => array('*'),
            'limit' => 10,
            'order' => 'MstEmpLeave.leave_id DESC',
            'joins' => array(
                array(
                    'table' => 'mst_emp_leaves',
                    'alias' => 'MstEmpLeave',
                    'type' => 'inner',
                    'foreignKey' => false,
                    'conditions' => array('LeaveDetail.leave_id = MstEmpLeave.leave_id AND 
                                      MstEmpLeave.start_date = LeaveDetail.leave_date')
                ),
                array(
                    'table' => 'leave_workflow',
                    'alias' => 'LeaveWorkflow',
                    'type' => 'inner',
                    'foreignKey' => false,
                    'conditions' => array('LeaveWorkflow.leave_id = LeaveDetail.leave_id')
                )
            ),
            'conditions' => array('LeaveWorkflow.emp_code' => $emp_code, 'MstEmpLeave.emp_code != ' . $emp_code, 'LeaveWorkflow.fw_date ' => NULL)

                //'order'=>array('LvMstId.id desc')
        ));
        if (!empty($result))
            return $result;
        else
            return '';
    }
    function getPendingAttendance($emp_code) {
        App::import("Model", "AttendanceDetail");
        $model = new AttendanceDetail();
        $emp_code = $emp_code;
        $result = $model->find('all', array(
            'conditions' => array(
              'AttendanceDetail.approver_id' => $emp_code,
              'status' => 6

              )
        ));
        if (!empty($result))
            return $result;
        else
            return '';
    }
    
 public function leaveConditions($leave_code,$tot,$emp_code){
 App::import("Model", "LeaveDetail");
 $leaveDetail = new LeaveDetail();
 App::import("Model", "MstEmpLeave");
 $mstempleave = new MstEmpLeave();
 App::import("Model", "MyProfile");
 $myprofile = new MyProfile();
 App::import("Model", "MstEmpLeaveAllot");
 $mstempleaveallot = new MstEmpLeaveAllot();
 $cl_pen = $mstempleaveallot->find('first',array(
    'fields'=>array('*'),
     'conditions'=>array('emp_code'=>array($emp_code),'leave_code'=>'PAR0000326')));
  
  $date = date('Y-m-d');
  $time=strtotime($date);    
  $year=date("Y",$time);   
  $ocassion =  $leaveDetail->find('count',array('fields'=>array('leave_id'),'conditions'=>array('year(leave_date)'=>$year,'emp_code'=>$emp_code,'leave_status'=>array(5,2),'leave_code'=>'PAR0000021'),
    'group'=>array('leave_id'))); 
 $dot = $myprofile->find('first',array('fields'=>array('join_date'),'conditions'=>array('emp_code'=>$emp_code)));
 
 $date = new DateTime($dot['MyProfile']['join_date']);
 $date2 = new DateTime(date('y-m-d'));
 $diff = date_diff($date, $date2);
 $dojyears = $diff->y;

 switch($leave_code) {
   case 'PAR0000021': 
   $date = date('Y-m-d');
   $time=strtotime($date);    
   $year=date("Y",$time);
   $query = $leaveDetail->find('count',array('fields'=>array('leave_id'),'conditions'=>array('year(leave_date)'=>$year,'emp_code'=>$emp_code,'leave_status'=>array(5,2),'leave_code'=>'PAR0000021'
       )));    
   if($query < 30){
    $total_leave = $query + $tot;  
    if($total_leave > 30){
     $msg = 'You exceed maximum limit of ordinary Leave';
      return $msg;
    }else{
    if($tot < 5){
     if($cl_pen['MstEmpLeaveAllot']['allot_leave'] < $tot && $ocassion > 2){
      return true;   
     }
     else{
     $msg = 'You cannot avail ordinary Leave for less than 5 days leave';
      return $msg;
     }
    }else {
      if($tot <= $cl_pen['MstEmpLeaveAllot']['allot_leave']) {
       $msg = 'No Ordinary Leave will be availed if equal no of casual leave is balance.'; 
        return $msg;
      } 
      else{
       
    if($ocassion < 2){
     return true;
    }else{
     $msg = 'Ordinary Leave can be applied twice in a year';
     return $msg;
    } 
      }
        
    }  
      
    }
    
   }else{
    $msg = 'You exceed maximum limit of ordinary Leave';
  return $msg;
   }
 
   break;
   case 'PAR0000326': 
   $date = date('Y-m-d');
   $time=strtotime($date);    
   $year=date("Y",$time);
   $query = $leaveDetail->find('count',array('fields'=>array('leave_id'),'conditions'=>array('year(leave_date)'=>$year,'emp_code'=>$emp_code,'leave_status'=>array(5,2),'leave_code'=>'PAR0000326')));    
   if($query < 12){
   $leave_total =  $query+$tot;
   if($leave_total > 12){
    $msg = 'You can avail maximum 12 casual Leaves in a calender year';
    return $msg;
   }else{
     if($tot > 5){
     $msg = 'you can avail maximum 5 leaves at a time'; 
      return $msg;
     } else{
      return true;    
     }
      
   }
    
   } else{
   $msg = 'You can avail maximum 12 casual Leaves in a calender year';
   return $msg;
   }   
   break;
   case 'PAR0000327': 
   $date = date('Y-m-d');
   $time=strtotime($date);    
   $year=date("Y",$time);
   $query = $leaveDetail->find('count',array('fields'=>array('leave_id'),'conditions'=>array('year(leave_date)'=>$year,'emp_code'=>$emp_code,'leave_status'=>array(5,2),'leave_code'=>'PAR0000327')));
   if($dojyears < 1){
    $msg = 'Sick Leave can be applied once you completed your one year';  
   return $msg;      
   }else{
    if($query < 15)
   {
   $leave_total =  $query+$tot;
   if($leave_total > 15){
   $msg = 'Maximum avail sick limit has been exceed';  
   return $msg;   
   }
   if($tot <= 3 && $cl_pen['MstEmpLeaveAllot']['allot_leave'] >= 3 ){
   $msg = 'No Sick Leave will be snactioned if CL is balance';  
   return $msg;
   }else{
     return true;  
   }
   } else{  
    $msg = 'You excced maximum Sick Leave Limit';  
   return $msg;   
   }    
   }
  
   break;  
   
   case 'PAR0000067': 
   break;
 }   

}
public function lta_calculate($lta_year){
App::import("Model", "LtaBillAmount");
  $lta = new LtaBillAmount();
  $date = date('Y-m-d');
  $time=strtotime($date);
  $year=date("Y",$time);
  $cal_year = date("Y",strtotime("-3 year")); 
  $previous_year = date("Y",strtotime("-1 year"));  
  $query = $lta->find('all',array(
      'fields'=>array('lta_years','year(created_at) as created_at'),
      'conditions'=>array('year(created_at)>='.$cal_year , 'year(created_at) <='.$year)
   ));
   
  $lta_block = 0;
  $lta_years = array();
  $i = 0;
  foreach($query as $res){
    $lta_years[] = $res[$i]['created_at'];
    $lta_block = $lta_block + $res['LtaBillAmount']['lta_years'];
    $i = $i + 1;
  }
  $flag = 0;
   switch ($lta_claim_flag) {
    case 0:
    $flag = 1;
    break;
    case 1:
     if( in_array($lta_years,$previous_year  ) && $lta_year > 1){
     $flag = 0;
     }
     else{
     if($lta_year > 3){
     $flag = 0;    
     }else{
     $flag = 1;   
     }
     }
    break;
    case 2:
     if(in_array($lta_years,$previous_year  ) && $lta_year > 1 ){
     $flag = 0;
     } 
     else{
    if($lta_year > 2){
     $flag = 0;   
    }
    else{
     $flag = 1;   
     }
    }
    break;
    case 3:
     if(in_array($lta_years,$previous_year  ) && $lta_year > 1 ){
     $flag = 0;
     }
     else{
     if($lta_year > 2) {
     $flag = 0;
     
     }
     else{
     $flag = 1;    
     }
     
     }
    break;
    case 4:
    if(in_array($lta_years,$previous_year  ) && $lta_year > 1 ){
     $flag = 0;
     }
     else{
     if($lta_year > 2)  {
     $flag = 0;    
     } 
     else{
     $flag = 1;    
     }
   }
    break;
    default:
    break;   
}
  
}
public function lta_per($emp_code,$comp_code){
  
App::import("Model", "LtaBillAmount");
  $lta = new LtaBillAmount();
  App::import("Model", "MyProfile");
  $myprofile = new MyProfile();
  $dob = $myprofile->find('first',array(
      'fields'=>array('join_date'),
      'conditions'=>array('emp_code'=>$emp_code)));
       $date = new DateTime($dob['MyProfile']['join_date']);
       $date2 = new DateTime(date('y-m-d'));
       $diff = date_diff($date, $date2);
       $dojyears = $diff->y;
  $flag = 0;
  $date = date('Y-m-d');
  $time=strtotime($date);
  $year=date("Y",$time);
  $cal_year = date("Y",strtotime("-3 year")); 
  $previous_year = date("Y",strtotime("-1 year"));
  $sec_previous = date("Y",strtotime("-2 year"));
  $query = $lta->find('all',array(
      'fields'=>array('lta_years','year(created_at) as created_at'),
      'conditions'=>array('year(created_at)>='.$cal_year , 'year(created_at) <='.$year,'emp_code'=>$emp_code,'comp_code'=>$comp_code)
   ));
  
     if($query)
     {
       $lta_years = array();
       $i = 0;
        foreach($query as $res){
       $lta_years[] = $res[$i]['created_at'];
       //$lta_block = $lta_block + $res['LtaBillAmount']['lta_years'];
        $i = $i + 1;
       }
       
      if (in_array($previous_year,$lta_years)) {
       $flag = 1;
       } elseif (in_array($sec_previous,$lta_years)) {
       $flag = 2;
       }  elseif (in_array($cal_year,$lta_years)) {
       $flag = 3;
       }
       else{
       $flag = 4;  
       }
       return $flag;
     }
     else
     {
       if($dojyears >= 4)
       {
          return $flag = 4;   
       }
       elseif($dojyears >=3)
       {
          return $flag = 3;   
       }
       elseif($dojyears >=2)
       {
          return $flag = 2;     
       }
       else
       {
          return $flag = 1;      
       }
     }
 
}
}