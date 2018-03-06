<?php
/* 
  * Property of Eastern Software Systems Pvt. Ltd.
  * Should be modified on by a Cake PHP Professional
  *  ******************************************************************************
  *  Description of Designations_controller.php
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
  * project version: 0.1.0
  *  @author Ayush Pant <ayush.pant@essindia.com>
  *  @client company: Eastern Software Systems Pvt. Ltd. Expression project.user is undefined on line 21, column 73 in Templates/Licenses/license-default.txt.
  *  @date created: 2017
  *  @date last modified: Jun 28, 2011 2:59:31 PM
  *  ******************************************************************************
 */



class DesignationsController extends AppController{

    //put your code here
    var $name = 'Designation';
    var $layout = 'admin';
	public $components = array('Auth', 'Session', 'Email','Cookie', 'RequestHandler',);
    var $uses = array('UserDetail','Designation','Department');
    
	public $helpers = array('Js','Html','Form','Session','Userdetail');

    function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow();
	    
    }
	
    function index() {
       $this->layout = 'admin';
	  
	}
        function add() {
		$add_var=array();
       if(!empty($this->data)){
			$this->autoRender=false;				
				  $add_var['dept_code']=$this->request->data['Designation']['dept_code'];
				  $add_var['desg_code']=strtoupper($this->request->data['Designation']['desg_code']);
				  $add_var['desc']=strtoupper($this->request->data['Designation']['desg_name']);
				  $add_var['status']=true;
				  $add_var['created_date']=date('Y-m-d h:i:s');
				  $add_var['comp_code']=$this->request->data['Designation']['comp_code'];
				$con3=$this->Designation->find('count',array('conditions'=>array('desc'=>$this->request->data['Designation']['desg_name'],'dept_code'=>$this->request->data['Designation']['dept_code'])));
				$con4=$this->Designation->find('count',array('conditions'=>array('desg_code'=>$this->request->data['Designation']['desg_code'],'dept_code'=>$this->request->data['Designation']['dept_code'])));
				 
				   if($con3>0||$con4>0)
					{
						$st= json_encode(array('msg'=>"Duplicate Entry",'type'=>'error'));
					}
					else{
					   if($this->Designation->save($add_var)) {
								   $st= json_encode(array('msg'=>"Data saved successfully",'type'=>'success'));
						} else {
							 $st= json_encode(array('msg'=>'Some Error Occurred','type'=>'error'));
					   }
					}
				echo $st;
				exit;
			}   
       
    }
    
    function lists() {
		$q='';
		
		if(!empty($this->data)){

			$id = $this->data['Designation']['comp_code'];
		
			$dept_name = strtoupper($this->data['Designation']['desg_name']);
			$dept_code=$this->data['Designation']['dept_code'];
				$desig_code=$this->data['Designation']['desg_code'];
			
			if($id != ''){
				$q .= "  Designation.comp_code= '" . $id . "'";
			}
			if($dept_code!=''&& $id !='')
			{
				$q .= "  AND Designation.dept_code= '" . $dept_code . "'";
			}
			
			if($dept_name != ''){
				$q .= " AND Designation.desc LIKE '$dept_name%'";
			}
			if($desig_code!=''&&$id!='')
			{
				$q .= " AND Designation.desg_code='".$desig_code."'";
			}
			else if($desig_code!=''){
				$q .= "  Designation.desg_code='".$desig_code."'";
			}

	
		$conditions=array($q);
		
		
		$this->paginate = array(
                              'limit' => 10,
                              'conditions'=>$conditions,
			                  'fields'=>array('Designation.id','Designation.dept_code','Designation.comp_code','Designation.desc','Designation.desg_code','Designation.status'),
				               'order' => array(
									   'Designation.id' => 'Desc',
                                   )
                             );
							 
		$result = $this->paginate('Designation');
		
		$this->set('list',$result);
    }

    else {
            $this->paginate = array(
                              'limit' => 10,
                              'conditions'=>$conditions,
			                  'fields'=>array('Designation.id','Designation.dept_code','Designation.comp_code','Designation.desc','Designation.desg_code','Designation.status'),
				               'order' => array(
									   'Designation.id' => 'Desc',
                                   )
                             );
        $result = $this->paginate('Designation');
        
        $this->set('list', $result);
        

        }
        }    
        
        
        
	function edit($id) { 
		$this->autoRender=false;
		$this->layout=false;
		if(!empty($this->data)) {
			$this->request->data['Designation']['id']=$id;
			
		
			
			$con3=$this->Designation->find('count',array('conditions'=>array('Designation.desc'=>$this->data['Designation']['desc'],'Designation.desg_code'=>$this->data['Designation']['desg_code'])));
				/*$con4=$this->Designation->find('count',array('conditions'=>array('Designation.desg_code'=>$this->data['Designation']['desg_code'],'Designation.dept_code'=>$this->data['Designation']['dept_code'])));*/
				
             

			        
			 if($con3>0) {
				$st= json_encode(array('msg'=>"Duplicate Entry",'type'=>'error'));
			 } else{
             $this->data['Designation']['desc'] =strtoupper($this->request->data['Designation']['desc']);
				$this->data['Designation']['desg_code']=strtoupper($this->request->data['Designation']['desg_code']);
				$this->data['Designation']['id']=$this->request->data['Designation']['id'];

				if($this->Designation->save($this->data)) {
					$st= json_encode(array('msg'=>"Data Updated  successfully",'type'=>'success','dt'=>date('d-M-Y h:i:s')));
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
			if($this->Designation->delete($id)) {
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
	function getDepartment($comp_code)
	{
		$deptList = $this->Department->find('list',array('fields'=>array('dept_code','dept_name'),'conditions'=>array('comp_code'=>$comp_code)));
		
		echo json_encode($deptList);die;
		
	}

}

?>
