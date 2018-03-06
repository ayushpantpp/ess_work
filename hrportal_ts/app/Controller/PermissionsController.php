<?php
//ob_start();
class PermissionsController extends AppController {

    public $uses = array('Permissions', 'PermissionsAcos');
    public $components = array('Session', 'Cookie', 'RequestHandler', 'Applicationscmp');
    public $helpers = array('Html', 'Js', 'Form', 'Session'); //Helper

    public function beforeFilter() {
       if($this->Auth->user('user_type')!='Administrator')
        {
           $this->redirect(array('controller'=>'admins', 'action'=>'login'));
        }
        parent::beforeFilter();
        //$this->Auth->allow(array('*'));
    }

    public function pr_create() {
        $this->autoRender = false;
        $response = new stdClass();
        $response->message = '';
        //pr($this->data);
        $this->Permissions->save($this->request->data);
            //$this->Applications->save();
        $response->message = 'Permission created successfully.';
        header("HTTP/1.0 200 OK");
        header('Content-type: text/json; charset=utf-8');
        header("Cache-Control: no-cache, must-revalidate");
        header("Expires: Mon, 21 Oct 2011 10:30:00 IST");
        header("Pragma: no-cache");
        echo json_encode($response);        
    }
    public function prDelete() {
        $this->autoRender = false;
        $response = new stdClass();
        $response->message = '';
        $this->Permissions->delete($this->request->data['Permissions']['id']);
        $this->PermissionsAcos->deleteAll(array(
                        'nu_permission_id'=>$this->request->data['Permissions']['id']
                ));
        $response->message = 'Permission deleted successfully.';
        header("HTTP/1.0 200 OK");
        header('Content-type: text/json; charset=utf-8');
        header("Cache-Control: no-cache, must-revalidate");
        header("Expires: Mon, 21 Oct 2011 10:30:00 IST");
        header("Pragma: no-cache");
        echo json_encode($response);        
    }    
}
