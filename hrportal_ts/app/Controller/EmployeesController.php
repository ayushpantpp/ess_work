<?php
class EmployeesController extends AppController{

    //put your code here
    var $name = 'Employee';
    var $layout = 'admin';
	public $components = array('Auth', 'Session', 'Email','Cookie', 'RequestHandler','Common');
    var $uses = array('Employee','Department','EmpStatus','Country');
	public $helpers = array('Js','Html','Form','Session','Userdetail','Common');

    function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow();
	    
    }
	
    function index() {
       $this->layout = 'admin';
	   //$this->getDeptlist();
       $this->findStatus();
	   $this->findCountry();
    }
    
	 function findStatus(){
		$Status = $this->EmpStatus->find('list',array('fields'=>array('EmpStatus.id','EmpStatus.st_name')));
		//echo "<pre>"; print_r($Status);die;
		$this->set('st',$Status);
	}
	
	 function findCountry(){
		$Country = $this->Country->find('list',array('fields'=>array('Country.id','Country.country_name')));
		//echo "<pre>"; print_r($Status);die;
		$this->set('country',$Country);
	}
	function findCountry1(){
		$Country = $this->Country->find('list',array('fields'=>array('Country.id','Country.country_name')));
		//echo "<pre>"; print_r($Status);die;
		$this->set('country1',$Country);
	}
	
	
    function add() {
		
       if(!empty($this->data)){
			$this->autoRender=false;		
			if(!empty($this->data)) {
				$dob=date('Y-m-d',strtotime($this->request->data['Employee']['dob']));
				$doj=date('Y-m-d',strtotime($this->request->data['Employee']['join_date']));
				$lv_val=array();
				//print_r($this->request->data);die;
				  $lv_val['emp_code'] =$this->request->data['Employee']['emp_code'];
				  $lv_val['dept_code'] = $this->request->data['Employee']['dept_code'];
				  $lv_val['desg_code'] = $this->request->data['Employee']['desg_code'];
				  $lv_val['emp_firstname'] = $this->request->data['Employee']['emp_firstname'];
				  $lv_val['emp_lastname']=$this->request->data['Employee']['emp_lastname'];
				  $lv_val['comp_code'] = $this->request->data['Employee']['comp_code'];
				  $lv_val['gender']    = $this->request->data['Employee']['gender'];
				  $lv_val['address']   = $this->request->data['Employee']['address'];
				  $lv_val['contact']   = $this->request->data['Employee']['contact'];
				  $lv_val['dob']       =  $dob;
				  $lv_val['join_date'] = $doj;
						
		if($_FILES['user_img']['name'])
		{
			$other='';
			$name=$_FILES['user_img']['name'];
			$lv_val['image']=trim($_FILES['user_img']['name']);
			echo move_uploaded_file($_FILES['user_img']['tmp_name'], WWW_ROOT .'img/uploads/' . $_FILES['user_img']['name']);
			$other='image';
		}
				 $con=$this->UserDetail->find('count',array('conditions'=>array('UserDetail.emp_code'=>$this->request->data['Employee']['emp_code'])));
				 if($con==0){
					  $con1=$this->UserDetail->find('count',array('conditions'=>array('UserDetail.email'=>$this->request->data['Employee']['email'])));
					 if($con1==0){
						 $con2=$this->UserDetail->find('count',array('conditions'=>array('UserDetail.user_name'=>$this->request->data['Employee']['username'])));
						 if($con2==0){
                             $lv_save=$this->Employee->save($lv_val);
							 unset($lv_val);
									 }
						 else{
							 $this->Session->setflash("User With This Username Already Exists, Please Try With Another Username");
							 $this->redirect('/employees/index');
						     }
								 }
                     else{
						 $this->Session->setflash("User With This E-mail Already Exists, Please Try With Another E-mail");
					     $this->redirect('/employees/index');
					     }								 
							}
				else{ $this->Session->setflash("User With This Employee Code Already Exists, Please Try With Another Employee Code");
					 $this->redirect('/employees/index');
				 }
				  if($lv_save)
			{ 
				$this->saveUser();
			}				
			}			
       }
    }
	function saveUser(){
		$data_val=array();
				$data_val['email']= $this->request->data['Employee']['email']; 
				$data_val['user_name'] = $this->request->data['Employee']['username'];
				$data_val['user_password'] = $this->request->data['Employee']['password'];
				$data_val['emp_code'] =$this->request->data['Employee']['emp_code'];
			 $data_val['comp_code'] = $this->request->data['Employee']['comp_code']; 
				
			
				/* if(!empty($this->request->data['Employee']['upload']['name']))
        {   // echo "hello1"; die;
                $file= $this->request->data['Employee']['upload'];
               
                $ext = substr(strtolower(strrchr($file['name'],'.')),1);
                $arr_ext = array('jpg','jpeg','gif');
                       
                        if(in_array($ext , $arr_ext))
                        {
                            move_uploaded_file($_FILES['tmp_name'], WWW_ROOT .'img/uploads' . $_FILES['image']);
                            $data_val['image']=$file['name'];
                        }
        
		} */
				$data_save=$this->UserDetail->save($data_val);
				  unset($data_save);
				  
			
				$this->Session->setFlash('Data Successfully Recorded');
				  $this->redirect('/employees/index');
			
	}
	
	function lists() {
	$q='1=1';
		if(!empty($this->data)){
			$id = $this->data['Employee']['id'];
			$emp_code = strtoupper($this->data['Employee']['emp_code']);
			$dept_code = strtoupper($this->data['Employee']['dept_code']);
			$desg_code = strtoupper($this->data['Employee']['desg_code']);
			$emp_firstname = strtoupper($this->data['Employee']['emp_firstname']);
			$emp_lastname = strtoupper($this->data['Employee']['emp_lastname']);
			$comp_code = strtoupper($this->data['Employee']['comp_code']);
			
		}
		$conditions=array($q);
		$this->paginate = array(
                              'limit' => 10,
                              'conditions'=>$conditions,
			                  'fields'=>array('Employee.id','Employee.emp_code','Employee.dept_code','Employee.desg_code','Employee.emp_firstname','Employee.emp_lastname','Employee.comp_code'),
				               'order' => array(
									   'Employee.id' => 'asc',
                                   )
                             );
							 
		$result = $this->paginate('Employee');
		//pr($result); die;
		$this->set('list',$result);
    }
        
function edit($id) {
	//echo $id; die;
		$this->autoRender=false;
		$this->layout=false;
		if(!empty($this->data)) {
			$this->request->data['Employee']['id']=$id;
			$con=$this->Employee->find('count',array('conditions'=>array('Employee.emp_firstname'=>$this->data['Employee']['emp_firstname'])));         
			 if($con>0) {
				$st= json_encode(array('msg'=>"Duplicate Entry",'type'=>'error'));
			 } else{
               /*  $this->request->data['MstTravelVoucher']['usr_id_mod'] = '1';
				$this->request->data['MstTravelVoucher']['usr_id_mod_dt']=date('Y-m-d'); */
				if($this->Employee->save($this->data)) {
					$st= json_encode(array('msg'=>"Data saved successfully",'type'=>'success','dt'=>date('d-M-Y h:i:s')));
			   } else {
					  $st= json_encode(array('msg'=>'Updation not done','type'=>'error'));
				}
			}
		}
		else
			$st= json_encode(array('msg'=>'Updation not done','type'=>'error'));
	   echo $st;
	   exit;  
	}
        
	function delete($id=null) {
		$this->layout=false;
		$this->autoRender=false;
        if(!empty($id)) {
			if($this->Employee->delete($id)) {
              $st= json_encode(array('msg'=>'Record Deleted','type'=>'success'));
		   } else {
			  $st= json_encode(array('msg'=>'Record not deleted','type'=>'error'));
		   }
		}
		else
			$st= json_encode(array('msg'=>'No Record Selected','type'=>'error'));
		echo $st;
		exit;
	}
	
	function getDepartment($compCode){
		    
			$deptList = $this->Common->getDepartmentList($compCode);
			//print_r($deptList);die;
			echo json_encode($deptList);
			die;			
	}
	function getDesignation($deptCode){
		    
			$desgList = $this->Common->getDesignationList($deptCode);
			//print_r($deptList);die;
			echo json_encode($desgList);
			die;			
	}
	
	function getState($countryCode){
		    
			$stateList = $this->Common->getStateList($countryCode);
			//print_r($deptList);die;
			echo json_encode($stateList);
			die;			
	}
	function getState1($countryCode){
		    
			$state1List = $this->Common->getState1List($countryCode);
			//print_r($deptList);die;
			echo json_encode($state1List);
			die;			
	}
	function getCity($stateCode){
		    
			$cityList = $this->Common->getCityList($stateCode);
			//print_r($deptList);die;
			echo json_encode($cityList);
			die;			
	}
	function getCity1($stateCode){
		    
			$city1List = $this->Common->getCity1List($stateCode);
			//print_r($deptList);die;
			echo json_encode($city1List);
			die;			
	}
	function getDetails()
	{
		try {
		 $emp_code = $this->params['pass']['0'];
		 //print_r($emp_code);die;
		// $empList=$this->Common->findEmployeeDetails($emp_code);
		$empList=$this->Employee->find('all',array('conditions'=>array('Employee.emp_code'=>$emp_code)));
		$this->set('emplist',$empList);
		$this->render('view');
		//echo json_encode($empList);die;
		
               
	}
	catch(Exception $d)
	{
		
	}
	}
	public function findUserDetailByEmpCode()
	{
        $emp_code = $this->params['pass']['0'];
		$query = $this->UserDetail->find('list',array('fields'=>array('emp_code','user_name'),'conditions'=>array('UserDetail.emp_code'=>$emp_code)));
		echo json_encode($query);die;
	}
	function UpdateDetails($id=null)
	{
		$user = $this->request->data['username'];
		$pass = $this->request->data['password'];
		$cpass = $this->request->data['confirm_password'];
		
		$emp_code= $this->request->data['emp_code'];
		 if(!empty($user)&&!empty($pass)&&!empty($cpass))
		{ 
			if($pass==$cpass)
			{
				$pass=$this->Auth->password(trim($this->request->data['password']));
				$this->UserDetail->query("UPDATE users SET user_name='$user',user_password='$pass' WHERE emp_code ='$emp_code';");
				$st= json_encode(array('msg'=>"Credentials updated successfully",'type'=>'success','dt'=>date('d-M-Y h:i:s')));
				echo $st; die;
			}
			else
			{
				echo json_encode(array('msg'=>"Password Mismatch",'type'=>'error','dt'=>date('d-M-Y h:i:s')));die;
			}
		}
		else
			{
				echo json_encode(array('msg'=>"Empty Data",'type'=>'error','dt'=>date('d-M-Y h:i:s')));die;
			}
	}

}

?>
