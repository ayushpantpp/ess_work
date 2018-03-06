<?php
ob_start();
App::import('phpexcel');

/* 
  * Property of Eastern Software Systems Pvt. Ltd.
  * Should be modified on by a Cake PHP Professional
  *  ******************************************************************************
  *  Description of Leaves_controller.php
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


class MdaManagementController extends AppController {
    
    var $uses = array('UserDetail');
    var $components = array('Session', 'Cookie', 'RequestHandler', 'Auth', 'EmpDetail','Common');
    var $helpers = array('Html', 'Js', 'Form', 'Session', 'Userdetail', 'Leave', 'Common');
    var $paginate = array(
        'limit' => 10,
        'order' => array(
            'Leave.applied_date' => 'desc'
        )
    );

    function beforeFilter() {
        parent::beforeFilter();
        $currentUser = $this->checkUser();
        $this->Auth->allow();

    }

  

   
   

  
   function add() {

//Configure::write('debug',2);
     $this->layout = 'employee-new';
        if (!empty($this->data)) {
            
            $this->autoRender = false;
            if (!empty($this->data)) {
   $data['email']=$this->data['file'];
   $data['comp_code']=$this->data['Mda_code'];
   

            if($this->UserDetail->save($data))
            {   
die("here");
}
else{
  echo "NO dara";
}
                /*$con = $this->LeaveMaster->find('count', array('conditions' => array('leave_code' => $this->request->data['LeaveMaster']['leave_code'])));*/
               /* if ($con > 1) {
                    $st = json_encode(array('msg' => "Duplicate Entry", 'type' => 'error'));
                } else {
                      
                    if ($this->LeaveMaster->save($this->data)) {
                        $st = json_encode(array('msg' => "Data saved successfully", 'type' => 'success'));
                        //$this->redirect( $_SERVER['PHP_SELF']);
                    } else {
                        $st = json_encode(array('msg' => 'Some Error Occurred', 'type' => 'error'));
                   */ 
                }
                /*echo $st;
                exit;*/
            }
        }
    
    
}

?>
