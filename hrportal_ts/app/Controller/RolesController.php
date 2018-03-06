<?php
//ob_start();
class RolesController extends AppController {

    public $uses = array('Roles', 'RolesPermissions');
    public $components = array('Cookie', 'RequestHandler', 'Applicationscmp');
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
        //$this->data['created'] = 'SYSDATE';
      
        $this->Roles->save($this->request->data);
        $aro = & $this->Acl->Aro;
        $new_employee = array(
            'foreign_key' => $this->Roles->id,
            'model' => 'Roles',
            'alias' => $this->request->data['Roles']['name']
        );
        //echo "New Employee";
       
        $aro->save($new_employee);
       
         /*
        //CODE TO CREATE ALL ROLES
        $aro = & $this->Acl->Aro;
        $roles = $this->Roles->find('all');
        foreach ($roles as $role){
            $aro->create();
            $new_employee = array(
                'foreign_key' => $role['Roles']['id'],
                'model' => 'Roles',
                'alias' => $role['Roles']['name']
            );
            //echo "New Employee";
            //pr($new_employee);
            $aro->save($new_employee);        
        
        }
        */
        
        //$this->Applications->save();
        $response->message = 'Role created successfully.';
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

        //Delete from Roles Table
        $this->Roles->delete($this->request->data['Roles']['id']);
        $aro = &$this->Acl->Aro;
        $aro->deleteAll(array(
                        'Aro.model' => 'Roles',
                        'Aro.foreign_key' => $this->request->data['Roles']['id'], //$current_user_id;
                    ));
        $response->message = 'Role deleted successfully.';
        $response->status = 1;
        header("HTTP/1.0 200 OK");
        header('Content-type: text/json; charset=utf-8');
        header("Cache-Control: no-cache, must-revalidate");
        header("Expires: Mon, 21 Oct 2011 10:30:00 IST");
        header("Pragma: no-cache");
        echo json_encode($response);
    }

}
