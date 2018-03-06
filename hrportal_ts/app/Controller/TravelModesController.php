<?php

class TravelModesController extends AppController {

    //put your code here
    var $name = 'TravelModes';
   // var $name='vehicleModes';
    var $layout = 'admin';
    public $components = array('Auth', 'Session', 'Email', 'Cookie', 'RequestHandler');
    var $uses = array('UserDetail', 'Departments', 'MstTravelMode','MstVehicleMode', 'Company');
    public $helpers = array('Js', 'Html', 'Form', 'Session', 'Userdetail', 'Common');

    function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow();
    }

    function index() {
        
        $this->layout = 'admin';
        $comp = $this->MstTravelMode->find('all');
        $this->set('MstTravelMode', $comp);
       
    }
     function index_vehicle() {
         $vname = 'VehicleModes';    
        $this->layout = 'admin';
        $comp = $this->MstVehicleMode->find('all');
        $this->set('MstVehicleMode', $comp);
       
    }

    function add() {

        if (!empty($this->data)) {

            $this->autoRender = false;
            if (!empty($this->data)) {
                $this->request->data['MstTravelMode']['name'] = $this->request->data['MstTravelMode']['mode_name'];
                $this->request->data['MstTravelMode']['created_date'] = date('Y-m-d');
                $this->request->data['MstTravelMode']['org_id'] = $this->request->data['MstTravelMode']['org_id'];
                $ho_id = $this->Company->find('first', array('conditions' => array('org_id' => $this->request->data['MstTravelMode']['org_id'])));
                $this->request->data['MstTravelMode']['ho_org_id'] = $ho_id['Company']['ho_org_id'];
                $this->request->data['MstTravelMode']['status'] = true;

                $con = $this->MstTravelMode->find('count', array('conditions' => array('name' => $this->request->data['MstTravelMode']['mode_name'])));
                if ($con > 0) {
                    $st = json_encode(array('msg' => "Duplicate Entry", 'type' => 'error'));
                } else {
                    if ($this->MstTravelMode->save($this->data)) {
                        $st = json_encode(array('msg' => "Data saved successfully", 'type' => 'success'));
                        //$this->redirect('index');
                    } else {
                        $st = json_encode(array('msg' => 'Some Error Occurred', 'type' => 'error'));
                    }
                }
                echo $st;
                exit;
            }
        }
    }
       
   
    function add_vehicle() {
        
         if (!empty($this->data)) {
            $this->autoRender = false;
            if (!empty($this->data)) {
                $this->request->data['MstVehicleMode']['Vehical_name'] = $this->request->data['MstVehicleMode']['name'];
                $this->request->data['MstVehicleMode']['created_date'] = date('Y-m-d');
                $this->request->data['MstVehicleMode']['org_id'] = $this->request->data['MstVehicleMode']['org_id'];
                $ho_id = $this->Company->find('first', array('conditions' => array('org_id' => $this->data['MstVehicleMode']['org_id'])));
                //$this->request->data['MstVehicleMode']['ho_org_id'] = $ho_id['Company']['ho_org_id'];
                $this->request->data['MstVehicleMode']['status'] = true;
                 $con = $this->MstVehicleMode->find('count', array('conditions' => 
                                        array('MstVehicleMode.vehical_name' => $this->data['MstVehicleMode']['vehical_name'],
                                              'MstVehicleMode.org_id' => $this->data['MstVehicleMode']['org_id']
                                              )));

                if ($con > 0) {

                    $st = json_encode(array('msg' => "Duplicate Entry", 'type' => 'error'));
                } else {
                    if ($this->MstVehicleMode->save($this->data)) {
                        $st = json_encode(array('msg' => "Data saved successfully", 'type' => 'success'));
                        //$this->redirect('index');
                    } else {
                        $st = json_encode(array('msg' => 'Some Error Occurred', 'type' => 'error'));
                    }
                }
                echo $st;
                exit;
            }
        }
    
}

    function lists() {
       //Configure::write('debug',2);
        $q = '';

        if (!empty($this->data)) {

            $id = $this->data['MstTravelMode']['org_id'];
            $name = strtoupper($this->data['MstTravelMode']['mode_name']);
            
            if ($id != '') {
                $q .= " MstTravelMode.org_id= '" . $id . "'";
            }
            if ($name != '' && $id!='') {
              $q .= " AND MstTravelMode.name LIKE '$name%'";
            }
            else if($name!=''){
$q .= "  MstTravelMode.name LIKE '$name%'";
            }
        
        $conditions = array($q);
    //print_r($conditions);
       
        $this->paginate = array(
            'limit' => 10,
            'conditions' => $conditions,
            'fields' => array('MstTravelMode.id', 'MstTravelMode.name', 'MstTravelMode.org_id'),
            'order' => array(
                'MstTravelMode.id' => 'Desc',
            )
        );

        $result = $this->paginate('MstTravelMode');

        $this->set('list', $result);
    
}
else {
             $this->paginate = array(
            'limit' => 10,
            'fields' => array('MstTravelMode.id', 'MstTravelMode.name', 'MstTravelMode.org_id'),
            'order' => array(
                'MstTravelMode.id' => 'Desc',
            )
        );
        $result = $this->paginate('MstTravelMode');
        $this->set('list', $result);
        

        }
    }
    function vehicle_lists() {

        $q='';     
         if (!empty($this->data)) {
            $id = $this->data['MstVehicleMode']['org_id'];
            $name = strtoupper($this->data['MstVehicleMode']['vehical_name']);
            if ($id != '') {
                $q .= "MstVehicleMode.org_id= '" . $id . "'";
            }
            if ($name != ''&&$id!='') {
                $q .= " AND MstVehicleMode.Vehical_name LIKE '$name%'";
            }
            else if( $name != '' ){
                   $q .= " MstVehicleMode.Vehical_name LIKE '$name%'";
            }


        $conditions = array($q);
        
         $this->paginate = array(
            'limit' => 10,
            'conditions' => $conditions,
            'fields' => array('MstVehicleMode.id', 'MstVehicleMode.Vehical_name', 'MstVehicleMode.org_id'),
            'order' => array(
                'MstVehicleMode.id' => 'Desc',
            )
        );
        $result = $this->paginate('MstVehicleMode');
        $this->set('list', $result);
        } else {
             $this->paginate = array(
            'limit' => 10,
            'fields' => array('MstVehicleMode.id', 'MstVehicleMode.Vehical_name', 'MstVehicleMode.org_id'),
            'order' => array(
                'MstVehicleMode.id' => 'Desc',
            )
        );
        $result = $this->paginate('MstVehicleMode');
        $this->set('list', $result);
        

        }

       
    }


    function edit($id) { 
        $this->autoRender = false;
        $this->layout = false;

        if (!empty($this->data)) {
            $this->request->data['MstTravelMode']['id'] = $id;
            $con = $this->MstTravelMode->find('count', array('conditions' => array('MstTravelMode.name' => $this->data['MstTravelMode']['name'],'MstTravelMode.org_id' => $this->data['MstTravelMode']['org_id'])));
            if ($con > 0) {
                $st = json_encode(array('msg' => "Duplicate Entry", 'type' => 'error'));
            } else {

                if ($this->MstTravelMode->save($this->data)) {
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


function edit_vehicle($id) { 
        $this->autoRender = false;
        $this->layout = false;
        if (!empty($this->data)) {
            $data['MstVehicleMode']['id'] = $id;
            $data['MstVehicleMode']['vehical_name'] = $this->data['MstVehicleMode']['name'];
             $data['MstVehicleMode']['org_id']=$this->data['MstVehicleMode']['org_id'];

            $con = $this->MstVehicleMode->find('count', array('conditions' => array('MstVehicleMode.vehical_name' => $this->data['MstVehicleMode']['name'],'MstVehicleMode.org_id' => $this->data['MstVehicleMode']['org_id'])));

            if ($con > 0) {
                $st = json_encode(array('msg' => "Duplicate Entry", 'type' => 'error'));
            } else {
                
                if ($this->MstVehicleMode->save($data)) {
                    $st = json_encode(array('msg' => "Data saved successfully", 'type' => 'success', 'dt' => date('d-M-Y h:i:s')));
                } else {
                    $st = json_encode(array('msg' => 'Updation not done', 'type' => 'error'));
                }
            }
            //print_r($con);die;
        } else
            $st = json_encode(array('msg' => 'Updation not done', 'type' => 'error'));
        echo $st;
        exit;
    }



    function delete($id = null) {
        $this->layout = false;
        $this->autoRender = false;
        if (!empty($id)) {
            if ($this->MstTravelMode->delete($id)) {
                $st = json_encode(array('msg' => 'Record Deleted', 'type' => 'success'));
            } else {
                $st = json_encode(array('msg' => 'Record not deleted', 'type' => 'error'));
            }
        } else
            $st = json_encode(array('msg' => 'No Record Selected', 'type' => 'error'));
        echo $st;
        exit;
    }

       function delete_vehicle($id = null) {
        $this->layout = false;
        $this->autoRender = false;
        if (!empty($id)) {
            if ($this->MstVehicleMode->delete($id)) {
                $st = json_encode(array('msg' => 'Record Deleted', 'type' => 'success'));
            } else {
                $st = json_encode(array('msg' => 'Record not deleted', 'type' => 'error'));
            }
        } else
            $st = json_encode(array('msg' => 'No Record Selected', 'type' => 'error'));
        echo $st;
        exit;
    }


}


?>
