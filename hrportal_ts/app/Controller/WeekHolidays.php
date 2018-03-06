<?php
/* 
  * Property of Eastern Software Systems Pvt. Ltd.
  * Should be modified on by a Cake PHP Professional
  *  ******************************************************************************
  *  Description of WeekHolidays_controller.php
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
class WeekHolidaysController extends AppController{

    //put your code here
    var $name = 'WeekHoliday';
    var $layout = 'admin';
	public $components = array('Auth', 'Session', 'Email','Cookie', 'RequestHandler');
    var $uses = array('WeekHoliday');
	public $helpers = array('Js','Html','Form','Session');

    function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow();
	    
    }
	
    function index() {
       $this->layout = 'admin';
	   //$dept=$this->Departments->find('list',array('fields'=>array('dept_code','dept_name')));
      //echo '<pre>';print_r($dept);die;
		//$this->set('Department',$dept);
		$holiday=$this->Holiday->find('all');
      //echo '<pre>';print_r($dept);die;
		$this->set('Holiday',$holiday);
	}
    
    function add() {
       if(!empty($this->data)){
			$this->autoRender=false;		
			if(!empty($this->data)) {
				
				  
				  $this->request->data['Holiday']['holiday_date'] = $this->request->data['Holiday']['holiday_date'];
				  $this->request->data['Holiday']['holiday_name'] = $this->request->data['Holiday']['holiday_name'];
				  $this->request->data['Holiday']['status'] = true;
				  
				 $con=$this->Holiday->find('count',array('conditions'=>array('holiday_name'=>$this->request->data['Holiday']['holiday_name'])));
				 $con1=$this->Holiday->find('count',array('conditions'=>array('holiday_date'=>$this->request->data['Holiday']['holiday_date'])));
				  if($con>0 || $con1>0) {
						$st= json_encode(array('msg'=>"Duplicate Entry",'type'=>'error'));
				   } else { 
					   if($this->Holiday->save($this->data)) {
								   $st= json_encode(array('msg'=>"Data saved successfully",'type'=>'success'));
								 //$this->redirect('index');
						} else {
							 $st= json_encode(array('msg'=>'Some Error Occurred','type'=>'error'));
					   }
					}
				echo $st;
				exit;
			}   
       }
    }
    
    function lists() {
		$q='1=1';
		if(!empty($this->data)){
			$id = $this->data['Holiday']['id'];
			$dept_name = strtoupper($this->data['Holiday']['holiday_name']);
			if($id != ''){
				$q .= " AND Holiday.id= ".$id;
			}
			if($holiday_name != ''){
				$q .= " AND Holiday.holiday_name=".$holiday_name;
			}
		}
		$conditions=array($q);
		$this->paginate = array(
                              'limit' => 10,
                              'conditions'=>$conditions,
			                  'fields'=>array('Holiday.id','Holiday.holiday_name','Holiday.holiday_date'),
				               'order' => array(
									   'Holiday.id' => 'asc',
                                   )
                             );
							 
		$result = $this->paginate('Holiday');
		//pr($result); die;
		
		/*$this->paginate = array(
                              'limit' => 10,
                              'conditions'=>$conditions,
			                  'fields'=>array('Departments.id','Departments.dept_name','Departments.dept_code','Departments.status'),
				               'order' => array(
									   'Departments.id' => 'asc',
                                   )
                             );
							 
		$result = $this->paginate('Departments');*/
		$this->set('list',$result);
    }
        
        
        
        
	function edit($id) { //echo'<pre>';print_r($this->data);die('ss');
		$this->autoRender=false;
		$this->layout=false;
		if(!empty($this->data)) {
			$this->request->data['Holiday']['id']=$id;
			$con=$this->Holiday->find('count',array('conditions'=>array('Holiday.holiday_name'=>$this->data['Holiday']['holiday_name'],'holiday_date'=>$this->request->data['Holiday']['holiday_date'])));         
			 if($con>0) {
				$st= json_encode(array('msg'=>"Duplicate Entry",'type'=>'error'));
			 } else{
               /*  $this->request->data['Designations']['usr_id_mod'] = '1';
				$this->request->data['Designations']['usr_id_mod_dt']=date('Y-m-d'); */
				if($this->Holiday->save($this->data)) {
					$st= json_encode(array('msg'=>"Data saved successfully",'type'=>'success','dt'=>date('d-M-Y h:i:s')));
			   } else {
					$st= json_encode(array('msg'=>'Updation not done','type'=>'error'));
				}
			}
			//print_r($con);die;
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
			if($this->Holiday->delete($id)) {
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

}

?>
