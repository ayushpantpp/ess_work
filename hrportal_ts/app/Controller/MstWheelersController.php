<?php

class MstWheelersController extends AppController {

    //put your code here
    var $name = 'MstWheelerType';
    var $layout = 'admin';
    public $components = array('Auth', 'Session', 'Email', 'Cookie', 'RequestHandler', 'Common');
    var $uses = array('Employee', 'Department', 'MstWheelerType', 'MstTravelVoucher','MstVehicalMaster');
    public $helpers = array('Js', 'Html', 'Form', 'Session', 'Userdetail', 'Common');

    function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow();
    }

    function index() {
        $this->layout = 'admin';
    }

    function add() {

        if (!empty($this->data)) {
            $this->autoRender = false;
            if (!empty($this->data)) {
//                            echo "<pre>";
//                            print_r($this->data);
//                            die('here');
                $lv_val = array();
                $lv_val['org_id'] = $this->request->data['MstWheelerType']['org_id'];
                $lv_val['vehical'] = $this->request->data['MstWheelerType']['vehicle'];
                $lv_val['wheeler_type'] = $this->request->data['MstWheelerType']['wheeler_type'];
                $lv_val['price'] = $this->request->data['MstWheelerType']['price'];
                $lv_val['effected_date'] = date("Y-m-d", strtotime($this->data['MstWheelerType']['eff_date']));
                $lv_val['status'] = true;
                $lv_val['created'] = date('Y-m-d h:i:s');
                $con = $this->MstWheelerType->find('count', array(
                    'conditions' => array(
                        'MstWheelerType.org_id' => $this->data['MstWheelerType']['org_id'],
                        'MstWheelerType.vehical' => $this->data['MstWheelerType']['vehicle'],
                        'MstWheelerType.wheeler_type' => $this->data['MstWheelerType']['wheeler_type'],
                        'MstWheelerType.effected_date' => date("Y-m-d", strtotime($this->data['MstWheelerType']['eff_date']))
                )));
                if ($con > 0) {
                    $this->Session->setFlash('Duplicate Entry');
                    $this->redirect('/MstWheelers/index');
                } else {
                    $data_save = $this->MstWheelerType->save($lv_val);
                    unset($lv_val);
                    $this->Session->setFlash('Data Successfully Recorded');
                    $this->redirect('/MstWheelers/index');
                }
            }
        }
    }

    function lists() {
        
         $q = '';

        if (!empty($this->data)) {

            $id = $this->data['MstWheelerType']['org_id'];
            $name = strtoupper($this->data['MstWheelerType']['vehicle']);
            $type=$this->data['MstWheelerType']['wheeler_type'];
            $price=$this->data['MstWheelerType']['price'];
            $date=$this->data['MstWheelerType']['eff_date'];
            //$date = str_replace('/', '-', $date);
            if($date!='')
            {
            $date= date('Y-m-d', strtotime($date));
        }
            if ($id != '') {
                $q .= " MstWheelerType.org_id= '" . $id . "'";
            }
            if ($name != ''&& $id!='') {
              $q .= "  AND  MstWheelerType.vehical='".$name."'";
            }
            else if($name != ''){
                $q.="  MstWheelerType.vehical='".$name."'";
            }
            if($type!=''&& $name!=' '&&$id!='')
            {
                $q.=" AND MstWheelerType.wheeler_type='".$type."'";
            }
            elseif($type!='')
            {
            $q.="  MstWheelerType.wheeler_type='".$type."'";
            }
             if($price!=''&&$type!=''&& $name!=' '&&$id!='')
            {
                $q.=" AND  MstWheelerType.price='".$price."'";
            }
            else if($price!='')

            {
                 $q.="  MstWheelerType.price='".$price."'";
            }
             if($date!=''&&$type!=''&& $name!=' '&&$id!='')
            {
                $q.="   AND MstWheelerType.effected_date Like '$date%'";
            }
            else if($date!='')
            {
                $q.="   MstWheelerType.effected_date Like '$date%'"; 
            }

        $conditions = array($q, $status);
    
        $this->paginate = array(
            'limit' => 10,
            'conditions' => $conditions,
            'fields' => array('MstWheelerType.id', 'MstWheelerType.org_id', 'MstWheelerType.vehical', 'MstWheelerType.wheeler_type', 'MstWheelerType.price', 'MstWheelerType.effected_date', 'MstWheelerType.status'),
            'order' => array(
                'MstWheelerType.id' => 'desc',
            )
        );

        $result = $this->paginate('MstWheelerType');
        $this->set('list', $result);
    }
    else{
        $conditions = array($q, $status);
        $this->paginate = array(
            'limit' => 10,
            'conditions' => $conditions,
            'fields' => array('MstWheelerType.id', 'MstWheelerType.org_id', 'MstWheelerType.vehical', 'MstWheelerType.wheeler_type', 'MstWheelerType.price', 'MstWheelerType.effected_date', 'MstWheelerType.status'),
            'order' => array(
                'MstWheelerType.id' => 'desc',
            )
        );

        $result = $this->paginate('MstWheelerType');
        $this->set('list', $result);
    }}

    function edit($id) {
       // Configure::write('debug',2);

        $this->autoRender = false;
        $this->layout = false;
          
        
        if (!empty($this->data)) {

          $this->request->data['MstWheelerType']['id'] = $id;

            $lv_val = array();
            
            $lv_val['org_id'] = $this->request->data['MstWheelerType']['org_id'];
            $lv_val['vehical'] = $this->request->data['MstWheelerType']['vehical'];
            $lv_val['wheeler_type'] = $this->request->data['MstWheelerType']['wheeler_type'];
            $lv_val['price'] = $this->request->data['MstWheelerType']['price'];
            $lv_val['effected_date'] =date("Y-m-d", strtotime($this->request->data['MstWheelerType']['effected_date']));
            $lv_val['status'] = true;
            $lv_val['created'] = date('Y-m-d h:i:s');
            
         
            $count=$this->MstWheelerType->find('count',array(
                'conditions'=>array(
                    'MstWheelerType.org_id'=>$this->request->data['MstWheelerType']['org_id'],
                    'MstWheelerType.vehical'=>$this->request->data['MstWheelerType']['vehical'],
                    'MstWheelerType.wheeler_type'=>$this->request->data['MstWheelerType']['wheeler_type'],
                    'MstWheelerType.effected_date'=>date("Y-m-d", strtotime($this->request->data['MstWheelerType']['effected_date'])))));
                    
            
            
            if($count > 0){
                
                    $st = json_encode(array('msg' => 'Duplicate record not excepted !', 'type' => 'error'));
            }else{
                 
                 $data_save = $this->MstWheelerType->save($lv_val);
                    if($data_save){
                    unset($lv_val);
                    $st = json_encode(array('msg' => "Data updated successfully", 'type' => 'success', 'dt' => date('d-M-Y h:i:s')));
                } else {
                    $st = json_encode(array('msg' => 'Updation not done', 'type' => 'error'));
                }
            }

//			$val_arr['id']=$id;
//			$query=$this->MstTravelVoucher->find('all',array('conditions'=>array('MstTravelVoucher.desc'=>$this->request->data['MstWheelerType']['name'],'MstTravelVoucher.type'=>3),'fields'=>array('id')));
//			$val_arr['name']=$query[0]['MstTravelVoucher']['id'];
//			$val_arr['price']=$this->request->data['MstWheelerType']['price'];
//			if($this->MstWheelerType->save($val_arr)) {
//					$st= json_encode(array('msg'=>"Data saved successfully",'type'=>'success','dt'=>date('d-M-Y h:i:s')));
//			        } 
//					else {
//				        	$st= json_encode(array('msg'=>'Updation not done','type'=>'error'));
//				           }
        } else
            $st = json_encode(array('msg' => 'Updation not done', 'type' => 'error'));
        echo $st;
        exit;
    }

    function delete($id = null) {
        $this->layout = false;
        $this->autoRender = false;
        if (!empty($id)) {
            if ($this->MstWheelerType->delete($id)) {
                $st = json_encode(array('msg' => 'Record Deleted', 'type' => 'success'));
            } else {
                $st = json_encode(array('msg' => 'Record not deleted', 'type' => 'error'));
            }
        } else
            $st = json_encode(array('msg' => 'No Record Selected', 'type' => 'error'));
        echo $st;
        exit;
    }
    function getvehicle($comp_code)
    {
     

        $wheeler_type = $this->MstVehicalMaster->find('list',array('fields'=>array('id','vehical_name'),'conditions'=>array('org_id'=>$comp_code)));
        echo json_encode($wheeler_type);die;
       
        
    }

}

?>
