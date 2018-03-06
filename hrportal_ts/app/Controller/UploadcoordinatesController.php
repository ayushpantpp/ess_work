<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
set_time_limit(240);    //4minutes
ini_set('memory_limit', '64M');
App::import('Sanitize');
 App::import('Vendor', 'phpExcel/excel_reader2');
//App::import('Vendor', 'Spreadsheet_Excel_Reader', array('file' => 'Excel/reader.php'));
   //Configure::write('debug',1);
 class UploadcoordinatesController extends AppController{
      var $uses=array('UserDetail','CAEmployeeDefinitionUpload');
       public $helpers = array('Js', 'Html', 'Form', 'Session', 'Userdetail');
        var $components = array('Session', 'Cookie', 'RequestHandler', 'Auth', 'EmpDetail','Common');
           function beforeFilter() {
        parent::beforeFilter();
        $currentUser = $this->checkUser();
        $this->Auth->allow();
 
 
    }

 function update($id)
      {
        $this->autoRender = false;

        $this->layout = 'employee-new';
      if (!empty($id)) {
      
           
            $con1 = $this->UserDetail->find('count', array('conditions' => array('status' => '0', 'id' =>$id)));
            
            if ($con1 > 0) {
                $st = json_encode(array('msg' => "Data Already Inactived ", 'type' => 'error'));
            } else {
                /*  $this->request->data['Department']['usr_id_mod'] = '1';
                  $this->request->data['Department']['usr_id_mod_dt']=date('Y-m-d'); */
                
                $data['UserDetail']['status']= '0' ;
               $data['UserDetail']['id']=$id;
                //pr($this->request->data['Department']);die;

               

                if ($this->UserDetail->save($data)) {
                    $st = json_encode(array('msg' => "Data saved successfully", 'type' => 'success', 'dt' => date('d-M-Y h:i:s')));
                } else {
                    $st = json_encode(array('msg' => 'Updation not done', 'type' => 'error'));
                }
            }
        } else
            $st = json_encode(array('msg' => 'Updation not done', 'type' => 'error'));
        echo $st;
        exit;
          
        
       }


     function index()
      {

         
         $this->layout = 'employee-new';

       }


       function add()
       {
        //Configure::write('debug',2);

        $auth=$this->Session->read('Auth');
$mda_code=$auth['MstMda']['mda_code'];


  $Documentlist = $this->UserDetail->find('all', array('fields' => array(
                'id','comp_code','emp_id','user_name','user_password','email','personal_number','status'), 'conditions' => array('comp_code' =>$mda_code),'order' => array('id' => 'DESC')));

    
       $this->set('Documentlist', $Documentlist);

 $this->layout = 'employee-new';
        $file_ext=$this->data['file']['name'];
         $extension=explode(".",$file_ext);
                   echo $ext=$extension[1];
               if(($ext == 'pdf' || $ext == 'jpg' || $ext == 'png' || $ext == 'txt' || $ext == 'doc' || $ext == 'docx' )){
                 $this->Session->setFlash(" File Aborted! File Format should be xls Only.");
                  $this->redirect(array('controller' => 'Uploadcoordinates', 'action' => 'add'));
        
 }
         if(isset($this->data['file']['tmp_name'])){

if(!(empty($this->data)))
{
  //Configure::write('debug',2);
             $data = new Spreadsheet_Excel_Reader();
             $data->read($this->data['file']['tmp_name']);
             $headings = array();
             $xls_data = array();
             $import['comp_code']= $this->data['Mda_code'];
             $import1['ministry_id']= $this->data['Mda_code'];
              if(count($data->sheets[0]['cells'])<102)
              {

               $j=1;
             for ($i = 2; $i<=count($data->sheets[0]['cells']); $i++) {
                $row_data = array();
               
               /* $kRI= h($data->sheets[0]['cells'][$i][1]);*/
                  $import['emp_id']= h($data->sheets[0]['cells'][$i][1]);
                  $import['email']= h($data->sheets[0]['cells'][$i][2]);
                  $import['user_name']= h($data->sheets[0]['cells'][$i][3]);
                  //$import['user_password']= h($data->sheets[0]['cells'][$i][4]);
                  $import['status']= h($data->sheets[0]['cells'][$i][4]);
                  $import['personal_number']= h($data->sheets[0]['cells'][$i][5]);
                  $import1['kra_pin']= h($data->sheets[0]['cells'][$i][1]);
                   $import1['official_email']= h($data->sheets[0]['cells'][$i][2]);
                        $import1['emp_status']= h($data->sheets[0]['cells'][$i][5]);
                    $import1['organisation_name']= h($data->sheets[0]['cells'][$i][7]);
                     $import1['nature_of_employment']= h($data->sheets[0]['cells'][$i][8]);
                     $import1['department_id']= h($data->sheets[0]['cells'][$i][9]);
                     $import1['employment_numbe']= h($data->sheets[0]['cells'][$i][10]);
                        $import1['id_number']= h($data->sheets[0]['cells'][$i][11]);
                     $import1['salutation']= h($data->sheets[0]['cells'][$i][12]);
                     $import1['surname']= h($data->sheets[0]['cells'][$i][13]);
                     $import1['first_name']= h($data->sheets[0]['cells'][$i][14]);
                      $import1['othername ']= h($data->sheets[0]['cells'][$i][15]);
                     $import1['designation']= h($data->sheets[0]['cells'][$i][16]);
                     $import1['dob']= h($data->sheets[0]['cells'][$i][17]);
                     $import1['place_of_birth ']= h($data->sheets[0]['cells'][$i][18]);
                        $import1['marital_status']= h($data->sheets[0]['cells'][$i][19]);
                     $import1['postal_add']= h($data->sheets[0]['cells'][$i][20]);
                     $import1['physical_add']= h($data->sheets[0]['cells'][$i][21]);
                     $import1['emp_mobile']= h($data->sheets[0]['cells'][$i][22]);

                     if($import['emp_id']!='')
                    { 

                  $KRI_check=$this->UserDetail->find('count',array('conditions' => array('emp_id' =>$import['emp_id'])));
                  if($KRI_check>0)
                   { 
                      $status['status']= '0';
                      $result = $this->UserDetail->updateAll($status,array('UserDetail.emp_id' =>$import['emp_id']));
                      $con=$this->UserDetail->find('count',array('conditions' => array('emp_id' =>$import['emp_id'],'comp_code'=>$mda_code)));
                
                }
                  if($con>0)
                      {
                        //echo $import['emp_id'];
                      $this->UserDetail->updateAll(
                          array('UserDetail.status' => $import['status']),
                          array('UserDetail.emp_id'  => $import['emp_id'])); 

                       $this->Session->setFlash("Data Status has been successfully Updated");
 


                    }
                   else{
                    
                          
                         $this->UserDetail->create();
                     $result=$this->UserDetail->save($import);
                     $this->CAEmployeeDefinitionUpload->create();
                   $emp_def=$this->CAEmployeeDefinitionUpload->save($import1);

$KID=$j++;
                   }


                }
                        
            }
             if($result)
            {
             
if($KID!='')
{
              $this->Session->setFlash($KID.":Data has been successfully Uploaded");
 $this->redirect(array('controller' => 'Uploadcoordinates', 'action' => 'add'));
}else{
$this->Session->setFlash("Data has been successfully Updated");
 $this->redirect(array('controller' => 'Uploadcoordinates', 'action' => 'add'));

}
            }
            else{
             $this->Session->setFlash("Something Went Wring!Try Agian");
              $this->redirect(array('controller' => 'Uploadcoordinates', 'action' => 'add'));
            }
          }
          else{
 $this->Session->setFlash("Data Uploading Limit Exceed ! Kindly Upload  Data below OF 100 .");
  $this->redirect(array('controller' => 'Uploadcoordinates', 'action' => 'add'));

          }
      }
    }
  }



     
 }
?>