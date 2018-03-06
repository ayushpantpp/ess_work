<?php

//NAME - HAKIM SINGH NIGAM

//Define Class - Traininghlp

 class TraininghlpHelper extends AppHelper {
	 
	function getCouseName($courseID){
	   
            App::import("Model",'CourseMaster');
	   $modelObj = new CourseMaster();
	   $coursedata = $modelObj->find('first', array(
            'fields' => array(
                'CourseMaster.course_name'
            ),
            'conditions' => array(
                'CourseMaster.id' =>$courseID
            )
        ));
	   return $coursedata['CourseMaster']['course_name'];
	 
	 }
function getDept($empcode){
		$modelObj = ClassRegistry::init('MyProfile');
        $managerData = $modelObj->find('first', array(
            'fields' => array(
                'MyProfile.dept_code'
            ),
            'conditions' => array(
                'MyProfile.status' =>1,
                'MyProfile.emp_code' => $empcode
            )
        ));
		$vc_dept_code = $managerData['MyProfile']['dept_code'];
		
		$desc = $this->getDep($vc_dept_code);
	
        return $desc;
    }
function getDesg($empcode){
        $modelObj = ClassRegistry::init('MyProfile');
        $managerData = $modelObj->find('first', array(
            'fields' => array(
                'MyProfile.desg_code'
            ),
            'conditions' => array(
                //'MyProfile.status' =>1,
                'MyProfile.emp_code' => $empcode
				)
        ));
		$vc_dept_code = $managerData['MyProfile']['desg_code'];
		
		$desc = $this->getDesc($vc_dept_code);
	
        return $desc;
		
    }	
    function getDep($stuct_code){
	 
	    $modelObj = ClassRegistry::init('Departments');
	 
	    $desgData = $modelObj->find('first', array(
				'fields' => array(
					'Departments.dept_name'
				),
				'conditions' => array(
					'Departments.dept_code' => $stuct_code
				)
           ));
        
		 $dept	= $desgData['Departments']['dept_name'];
			 
		 return $dept;
	 }
	 
    function getDesc($stuct_code){
	 
	    $modelObj = ClassRegistry::init('OptionAttribute');
	 
	    $desgData = $modelObj->find('first', array(
				'fields' => array(
					'OptionAttribute.name'
				),
				'conditions' => array(
					'OptionAttribute.id' => $stuct_code
				)
           ));
        
		 $desg	= $desgData['OptionAttribute']['name'];
			 
		 return $desg;
	 }
	 
    
	
    function formatDuration($duraHH,$duraMM){
 
		$dHH ='0';
		
		if($duraHH < 10 && ($duraHH !=0 || $duraHH !='')){
		
		  $dHH ='0'.$duraHH;
		  
		}else if($duraHH !=0 && $duraHH !=''){
		     $dHH = $duraHH;
		}else{
		    $dHH = '00';
		}
	
		if($duraMM < 10 && ($duraMM !=0 || $duraMM !='')){
		
		  $dMM ='0'.$duraMM;
		  
		}else if($duraMM !=0 && $duraMM !=''){
		    $dMM = $duraMM;
		}else{
		    $dMM ='00';
		}
		
		if(($dHH *60 + $dMM) <= 60){
                 $hrs = 'Hour';
                 }else{
                 $hrs = 'Hours';
                 }		
		$duration = $dHH.':'.$dMM.' '.$hrs;
		
		return $duration;
   
   
   }
   function getEmpName($value){
      
	 $empname = '';
         
	   if(is_numeric($value)) {
	     $modelObj = ClassRegistry::init('MyProfile');
	     $resultdata = $modelObj->find('first', array(
            'fields' => array(
                'MyProfile.emp_code',
                'MyProfile.emp_firstname',
            ),
            'conditions' => array(
                //'MyProfile.status' =>1,
                'MyProfile.emp_code' =>$value
            )
         ));
		 
		$empname = $resultdata['MyProfile']['emp_firstname'];

	  }else{
	        $modelObj = ClassRegistry::init('InstituteMasterDetail');
			 $resultdata = $modelObj->find('first', array(
				'fields' => array(
					'InstituteMasterDetail.emp_code',
					'InstituteMasterDetail.emp_name'
				),
				'conditions' => array(
					'InstituteMasterDetail.status' => 'A',
					'InstituteMasterDetail.emp_code' => $value
				)
			 ));
		$empname = strtoupper($resultdata['InstituteMasterDetail']['vc_emp_name']);
	  }

	   return $empname;
	   
	 }

   
}