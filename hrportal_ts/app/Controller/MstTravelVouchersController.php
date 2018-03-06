<?php

class MstTravelVouchersController extends AppController {

    //put your code here
    var $name = 'MstTravelVouchers';
    var $layout = 'admin';
    public $components = array('Auth', 'Session', 'Email', 'Cookie', 'RequestHandler','Common');
    var $uses = array('MstTravelVoucher');
    public $helpers = array('Js', 'Html', 'Form', 'Session', 'Userdetail');

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
                
                $rec['type'] = $this->request->data['MstTravelVouchers']['type'];
                $rec['desc'] = $this->request->data['MstTravelVouchers']['travel_name'];
                $rec['status'] = true;
                $rec['created_date'] = date('Y-m-d h:i:s');
                $rec['module_name'] = 'Travel Voucher';
                $rec['ho_org_id'] = $this->Common->getHO($this->request->data['MstTravelVouchers']['org_id']);
                $rec['org_id'] = $this->request->data['MstTravelVouchers']['org_id'];
                
                $con = $this->MstTravelVoucher->find('count', array('conditions' => array('MstTravelVoucher.org_id'=>$this->request->data['MstTravelVouchers']['org_id'],'MstTravelVoucher.desc' => $this->request->data['MstTravelVouchers']['travel_name'])));

                if ($con > 0) {
                    $st = json_encode(array('msg' => "Duplicate Entry", 'type' => 'error'));
                } else {
                    if ($this->MstTravelVoucher->save($rec)) {
                        $st = json_encode(array('msg' => "Data saved successfully", 'type' => 'success'));
                        //  $this->redirect();
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
        
            $id = $this->data['MstTravelVouchers']['org_id'];
            $travel_name = strtoupper($this->data['MstTravelVouchers']['travel_name']);
            $travel_type = $this->data['MstTravelVouchers']['type'];
           // print_r($travel_name);
         if ($id != '') {
                $q .= " MstTravelVoucher.org_id= '" . $id . "'";
            }
            if($travel_type!=''&&$id!='')
            {
                 $q . " MstTravelVoucher.type= '" . $travel_type . "'";
            }
            if ($travel_name != ''&&$id!='') {
              $q .= " AND MstTravelVoucher.desc LIKE '$travel_name%'";
            }

            else if ($travel_name != ''){
                 $q .= "  MstTravelVoucher.desc LIKE '$travel_name%'";
            }
        
        $conditions = array($q);
        
        $this->paginate = array(
            'limit' => 10,
            'conditions' => $conditions,
            'fields' => array('MstTravelVoucher.id', 'MstTravelVoucher.desc', 'MstTravelVoucher.status', 'MstTravelVoucher.org_id'),
            'order' => array(
                'MstTravelVoucher.id' => 'Desc',
            )
        );

        $result = $this->paginate('MstTravelVoucher');
        
        $this->set('list', $result);
    }
    else{
$this->paginate = array(
            'limit' => 10,
            'conditions' => $conditions,
            'fields' => array('MstTravelVoucher.id', 'MstTravelVoucher.desc', 'MstTravelVoucher.status', 'MstTravelVoucher.org_id'),
            'order' => array(
                'MstTravelVoucher.id' => 'Desc',
            )
        );

        $result = $this->paginate('MstTravelVoucher');
        //pr($result); die;
        $this->set('list', $result);

    }
    }

    function edit($id) {
        $this->autoRender = false;
        $this->layout = false;
        if (!empty($this->data)) {
            $this->request->data['MstTravelVoucher']['id'] = $id;
            $con = $this->MstTravelVoucher->find('count', array('conditions' => array('MstTravelVoucher.desc' => $this->data['MstTravelVoucher']['desc'])));
            if ($con > 0) {
                $st = json_encode(array('msg' => "Duplicate Entry", 'type' => 'error'));
            } else {
                /*  $this->request->data['MstTravelVoucher']['usr_id_mod'] = '1';
                  $this->request->data['MstTravelVoucher']['usr_id_mod_dt']=date('Y-m-d'); */
                if ($this->MstTravelVoucher->save($this->data)) {
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

    function delete($id = null) {
        $this->layout = false;
        $this->autoRender = false;
        if (!empty($id)) {
            if ($this->MstTravelVoucher->delete($id)) {
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
