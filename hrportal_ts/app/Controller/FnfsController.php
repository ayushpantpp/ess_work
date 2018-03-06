<?php
App::uses('AppController', 'Controller');
/**
 * Fnfs Controller
 *
 * @property Fnf $Fnf
 * @property PaginatorComponent $Paginator
 */
class FnfsController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $uses = array('Fnf','Separation','FnfWorkflow','Project','FnfDetail');
	var $components = array('Session', 'Cookie', 'RequestHandler','Auth','EmpDetail','Paginator' );
    var $helpers = array('Html', 'Js','Form', 'Session','Userdetail','Leave', 'Common');

    function beforeFilter() {
		parent::beforeFilter();
		$this->layout = 'employee-new';
        $this->Auth->allow();
        $this->set('appId',8);
	$currentUser = $this->checkUser();
	
    }

    /* Function to show the status of the fnf and show an option to apply for it if not applied */
	public function index() {
		//exit();
		$this->Fnf->recursive = 2;
		$fnfs = $this->Fnf->find('first',array(
				'conditions' => array(
					'Fnf.emp_code' => $this->Auth->User('emp_code'),	
				)
			));
                
        foreach ($fnfs['FnfDetail'] as $key => $value) {
            $d = $this->EmpDetail->getemployeeinfomation($value['approver_id']);
            $fnfs['FnfDetail'][$key]['MyProfile']  = $d['MyProfile'];
            # code...
        }


		$this->set('fnfs', $fnfs);

		
	}

    /* Function to add he fnf details if not added */
    function fnf_details($fnf_id) {
              $dept = $this->MyProfile->find('first',array(
                    'field'=>array('MyProfile.dept_code'),
                    'conditions'=>array('MyProfile.emp_code'=>$this->Auth->User('emp_code'))
                    ));
               $dept_code = $dept['MyProfile']['dept_code'];
            
                $this->set('dept_code',$dept_code);
                $desg = $this->MyProfile->find('first',array(
                    'field'=>array('MyProfile.desg_code'),
                    'conditions'=>array('MyProfile.emp_code'=>$this->Auth->User('emp_code'))
                    ));
                $dept_code = $dept['MyProfile']['dept_code'];
                $this->set('dept_code',$dept_code);
        $fnf = $this->FnfDetail->find('all',array('conditions'=>array('fnf_id'=>$fnf_id)));
       // print_r($fnf);die;
               
        if($this->request->is('POST')) {
            if(empty($fnf)){
             unset($this->request->data['Fnf']['fnf_id']);
            
            //save project wise details in fnf details table and trasfer to workflow
            foreach ($this->request->data['Fnf'] as $data) {
                $this->FnfDetail->create();
                $this->FnfDetail->save($data);
            }
           
            //add first flow entry from user
            /*$wf_data['FnfWorkflow']['fnf_id'] = $fnf_id;
            $wf_data['FnfWorkflow']['emp_code'] = $this->Auth->User('emp_code');
            $wf_data['FnfWorkflow']['fw_date'] =  date('Y-m-d h:i:s');
            $this->FnfWorkflow->save($wf_data);*/

            //add second entry from user who created separation
            /*$wf_data['FnfWorkflow']['fnf_id'] = $fnf_id;
            $wf_data['FnfWorkflow']['emp_code'] = $this->Auth->User('emp_code');
            $this->FnfWorkflow->save($wf_data);*/
            
            //change the fnf status to forward
            /*$this->Fnf->id = $this->request->data['Fnf']['fnf_id'];
            $this->Fnf->save(array(
                'Fnf' => array(
                        'status' => 2,
                    )
                ));*/
            $fnf_det = $this->Fnf->findById($fnf_id);
            //change the separation status to approved
            $this->Separation->id = $fnf_det['Fnf']['separation_id'];
            $this->Separation->save(array(
                'Separation' => array(
                        'status' => 5,
                    )
                ));
            //change fnf status to approved 
            /*$this->Fnf->id = $fnf_id;
            $this->Fnf->save(array(
                'Fnf' => array(
                        'status' => 5,
                    )
                ));*/

            //redirect the workflow to add manager 
            $this->redirect(array('controller'=>'separations','action'=>'approval'));   
            }else{
              $this->redirect(array('controller'=>'separations','action'=>'approval'));      
            }
            
        }
        
        
        //add project lists
        $users_list = $this->MyProfile->find('list',array(
            'fields'=>'emp_firstname'
            ));
        $fnf_det = $this->Fnf->findById($fnf_id);
        
        $this->set('fnf_details', $fnf_det);
        $this->set('users_list',$users_list);
        $project_list = $this->Project->find('list');
        $this->set('project_list',$project_list);
        $this->set('fnf_id',$fnf_id);

    }

	/* Function to add the fnf details by the user */
	function fnf_edit($fnf_id) {
    	if($this->request->is('POST')) {
    		//save project wise details in fnf details table and trasfer to workflow
    		foreach ($this->request->data['FnfDetail'] as $key=>$value) {
                $this->FnfDetail->id = $key;
                $data['FnfDetail'] = $value;
                $data['FnfDetail']['completion_date'] = date('Y-m-d',strtotime($value['completion_date']));
    			$this->FnfDetail->save($data);
                if(empty($value['completion_date'])) {
                    $this->Session->setFlash('Complete the dates and then submit to manager');
                    $this->redirect('fnf_edit/'.$fnf_id);
                }
    		}

            $this->redirect('workflow_display/'.$fnf_id);
            /*

    		//add first flow entry from user
    		$wf_data['FnfWorkflow']['fnf_id'] = $fnf_id;
    		$wf_data['FnfWorkflow']['emp_code'] = $this->Auth->User('emp_code');
    		$wf_data['FnfWorkflow']['fw_date'] =  date('Y-m-d h:i:s');
            $this->FnfWorkflow->save($wf_data);

            $fnf_det = $this->Fnf->findById($fnf_id);*/
            

    	}

        //add fnf_details
        $fnf_details = $this->FnfDetail->find('all', array(
            'conditions'=>array( 'fnf_id'=> $fnf_id)
            ));
        $this->set('fnf_details',$fnf_details);
    	//add project lists
        $users_list = $this->MyProfile->find('list',array(
            'fields'=>'emp_firstname'
            ));
        $this->set('users_list',$users_list);
		$project_list = $this->Project->find('list');
    	$this->set('project_list',$project_list);
    	$this->set('fnf_id',$fnf_id);

    }

	/* function to create a fnf workflow*/
	function workflow_display($record_id=null){
		$this->layout = 'employee-new';
		$this->set('fnf', $record_id);
	}

	/* Function to save information for the workflow*/

	function saveworkflowinformation() {
		if(!empty($this->request->data)) {
			if($this->FnfWorkflow->save($this->request->data)){
                $update_fnf['Fnf']['id'] = $this->request->data['FnfWorkflow']['fnf_id'];
                $update_fnf['Fnf']['status'] = 2;
                $this->Fnf->save($update_fnf);

            }
			$this->redirect('index');
		}

	}

	function approval() {

        $this->layout = 'employee-new';
        $org_id = $this->Auth->User('comp_code');
        $emp_code = $this->Auth->User('emp_code');
		//pr($_SESSION);//die;
		//Designation code
		$designation_code = $_SESSION['Auth']['MyProfile']['desg_code'];
        
		//Department code
    	$dept_code = $_SESSION['Auth']['MyProfile']['dept_code'];
        
        
        $this->paginate = array(
            'conditions' => array('FnfDetail.approver_id' => $emp_code,'FnfDetail.completion_date' => null),
            'limit' => 10,
            'order' => array(
                'CaseDetails.id' => 'desc'
            )
        );
        
        
            
        
        $this->set('pending_fnf', $this->paginate($this->FnfDetail));
        
	}

	function edit_details($fnf_id = null) {
        
        if($this->request->is['POST']) {
            print_r($this->request->data);
            exit();

            $this->redirect('process_approval/'.$fnf_id);
        }
        else {
            
            //get the details of the projects and allow the user to edit them
            $fnf_details = $this->FnfDetail->find('all',array(
                'conditions'=>array(
                    'fnf_id' => $fnf_id,
                    )
                ));
            $this->set('fnf_details',$fnf_details);
            $this->set('fnf_id',$fnf_id);
            $project_list = $this->Project->find('list');
            $this->set('project_list',$project_list);
        }
		
		
		//furthur processing
		


	}

	//function to process approval and change the fields accordingly by the manager

    //Obsolete
	function process_approval($fnf_id = null) {
		$this->layout = 'employee-new';

    	if($this->request->is('POST')) {
    		$data = $this->request->data;
    		$status = $data['FnfWorkflow']['type']; 
    		    			unset($data['FnfWorkflow']['type'] );

    		$fnf_id = $data['FnfWorkflow']['id'];
    		    			unset($data['FnfWorkflow']['id'] );
    		$data['FnfWorkflow']['fnf_id'] = $fnf_id;   			

    		

    		//forwarded
    		if($status == 2) {
    			$update_wf['FnfWorkflow']['remarks'] = $data['FnfWorkflow']['forward_remark'] ;
    			unset($data['FnfWorkflow']['forward_remark'] );
    			unset($data['FnfWorkflow']['reject_remark'] );
	    		
	    		
    		}
    		//rejected
    		if($status == 4) {
    			$update_wf['FnfWorkflow']['remarks'] = $data['FnfWorkflow']['reject_remark'] ;
	    		unset($data['FnfWorkflow']['forward_remark'] );
    			unset($data['FnfWorkflow']['reject_remark'] );
    		}
    		//for approved 
    		if($status == 5){ 
    			$update_wf['FnfWorkflow']['remarks'] = 'Approved' ;
    			unset($data['FnfWorkflow']['forward_remark'] );
    			unset($data['FnfWorkflow']['reject_remark'] );

    		}


    		//update current wf and create a new wf
    		$update_wf['FnfWorkflow']['fw_date'] = date('Y-m-d h:i:s');
    		$update_wf['FnfWorkflow']['id'] = $data['FnfWorkflow']['wf_id'];
    		    			unset($data['FnfWorkflow']['wf_id'] );

	    	if($this->FnfWorkflow->save($update_wf)){ 
	    		if($status == 2) {
	    			$this->FnfWorkflow->create();
		    		if($this->FnfWorkflow->save($data)) {
		                $this->Session->setFlash('Fnf forwarded');		    			
		    		}   
		    		else {
		                $this->Session->setFlash('Fnf not forwarded');		    			
		    		}   

	    		}
	    		
                //$this->redirect(array('controller' => 'separations', 'action' => 'view'));
           	}
	   		else {
                $this->Session->setFlash('Fnf workflow not updated');
                //$this->redirect(array('controller' => 'separations', 'action' => 'view'));
		   	}

    		//update separation status
            $data1['Fnf']['id'] = $fnf_id;
            $data1['Fnf']['status'] = $status;

            $this->Fnf->save($data1);

            $this->redirect(array('controller' => 'separations', 'action' => 'approval'));


    	}
    	else {

    	//print_r($this->Common->getempinfo($this->Auth->User('emp_code')));
    	//exit();

    	$fnf = $this->Fnf->find('first',array(
    		'conditions' => array(
    			'Fnf.id' => $fnf_id,
    			)
    		));
    	//print_r($separation);
    	$current_wf_id = $fnf['FnfWorkflow'][sizeof($fnf['FnfWorkflow'])-1];
    	//exit();
    	$this->set('fnf',$fnf);
    	$this->set('current_wf_id',$current_wf_id['id']);
    	}


	}

    function process_fnf_detail($fnf_detail_id=null) {
       // Configure::write('debug',2);

        if(isset($this->request->data['FnfDetail']['id'])) {
            $data['FnfDetail']['id'] = $this->request->data['FnfDetail']['id'];
            $data['FnfDetail']['status'] = $this->request->data['FnfDetail']['status'];
            $data['FnfDetail']['approver_remark'] = $this->request->data['approver_remark'];
            $data['FnfDetail']['completion_date'] = date('Y-m-d');

            $this->FnfDetail->save($data);
            $this->Session->setFlash('<div class="uk-alert uk-alert-success" data-uk-alert="">
                            <a href="#" class="uk-alert-close uk-close"></a>FNFS Approved Successfully !!!!</div>');   
            $this->redirect(array('controller'=>'fnfs','action'=>'approval'));
            
        }

        else {

        $fnf_det = $this->FnfDetail->find('first',array(
        'conditions' => array(
            'FnfDetail.id' => $fnf_detail_id,
            )
        ));
        $this->set('fnf_det',$fnf_det);
        }

    }

    function other_users($fnf_id) {
        //exit();
        if($this->request->is['POST']) {
            print_r($this->request->data);
            exit();
        }
        else {
            $this->Fnf->recursive = 2;
            $fnfs = $this->Fnf->find('first',array(
                    'conditions' => array(
                        'Fnf.id' => $fnf_id,    
                    )
                ));
            //exit();
            foreach ($fnfs['FnfDetail'] as $key => $value) {
                $d = $this->EmpDetail->getemployeeinfomation($value['approver_id']);
                $fnfs['FnfDetail'][$key]['MyProfile']  = $d['MyProfile'];
                # code...
            }

            $this->set('fnfs', $fnfs);

        }
        

    }
    function final_fnf(){
    $emp_code = $this->Auth->User('emp_code');    
    $finalfnf = $this->Fnf->find('all',array('fields'=>array('*'),'conditions'=>array('Fnf.final_approver'=>$emp_code))) ;   
    
    $this->set('finalfnf',$finalfnf);  
    
    }
    function edit_other_users($fnf_id) {
        //exit();
        $this->Fnf->recursive = 2;
        $fnfs = $this->Fnf->find('first',array(
                'conditions' => array(
                    'Fnf.id' => $fnf_id,    
                )
            ));
        //exit();
        foreach ($fnfs['FnfDetail'] as $key => $value) {
            $d = $this->EmpDetail->getemployeeinfomation($value['approver_id']);
            $fnfs['FnfDetail'][$key]['MyProfile']  = $d['MyProfile'];
            # code...
        }

        $this->set('fnfs', $fnfs);

     

    }
    function approve_fnf($id){
       
       if($id){
       $this->Fnf->updateAll(
       array('Fnf.status' =>5), 
       array('Fnf.id' =>$id)
        ); 
       $this->Session->setFlash('FNFS Approved Successfully');
       $this->redirect("final_fnf/$this->Auth->User('emp_code)");
       } 
    }
	
 function reject_fnf(){
    
        $this->autoRender = false;
        $data['id'] = $this->data['Fnfs']['rejectid'];
        $data['status'] = 4;
        $data['reject_remark'] = $this->data['Fnfs']['remark'];
        $this->Fnf->save($data);
        $remark = $this->data['Fnfs']['remark'];
        $seperation_id = $this->Fnf->find('first',array('fields'=>array('separation_id'),'conditions'=>array('Fnf.id'=>$this->data['Fnfs']['rejectid'])));
       $this->Separation->updateAll(
       array('Separation.status' =>4,'remark'=>"'$remark'"), 
       array('Separation.id' =>$seperation_id['Fnf']['separation_id'])
        ); 
       $emp_code= $this->Auth->User('emp_code');
        $this->Session->setFlash('FNF Rejected Successfully');
        $this->redirect("final_fnf/$emp_code");
       
    }
public function rejectId($id)
{
$this->layout = false;
$this->set('rejectid',$id);
}
	
    

}
