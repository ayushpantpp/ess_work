<?php

/*
 * Property of Eastern Software Systems Pvt. Ltd.
 * Should be modified on by a Cake PHP Professional
 *  ******************************************************************************
 *  Description of Configuration_controller.php
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



App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');
App::import('uploader');

class ConfigurationsController extends AppController {

    public $name = 'Configurations';
    var $layout = 'admin';
    public $uses = array('MyProfile', 'ImportantDocCategory', 'EmpAddress', 'UserDetail', 'Icon', 'IconUser', 'AdminOption', 'UserAudittrail', 'KraKpiProcess', 'LabelPage', 'LabelBlock', 'Labels', 'Ticker', 'TickerUser', 'Departments', 'Event', 'Separation', 'DtTravelVoucher', 'DtExpVoucher', 'EmpDocuments','SyncStatus');
    public $helpers = array('Js', 'Html', 'Form', 'Session', 'Userdetail', 'Common');
    public $components = array('Auth', 'Session', 'Email', 'Cookie', 'EmpDetail', 'RequestHandler', 'Common');

    const DEFAULT_PASSWORD = '123456';
    //const form_ids = array('attendence_sync','leave_sync','salary_sync','db_backup');//insert all the ids of the button here to sync


    public function beforeFilter() {
        parent::beforeFilter();
        //$this->Auth->allow(array('index'));
        $this->Auth->allow('admin_option', 'lists', 'add_module', 'update_value', 'resetUserPassword', 'changeUserPassword', 'changeUserStatus','syncData','lastSync');
        // $currentUser = $this->checkUser();
    }

    public function admin_option() {
        $this->layout = 'admin';
    }

    public function important_doc_cat() {
        $this->layout = 'admin';
    }

    function lists($id) {
        //Configure::write('debug',2);
        $q = '1=1';
        if (!empty($this->data)) {
            $id = $this->data['AdminOption']['id'];
            $travel_name = strtoupper($this->data['AdminOption']['desc']);
        }
        $conditions = array($q);
        $admin_org = new Model(array('table' => 'admin_option_org', 'ds' => 'default', 'name' => 'ADMIN_ORG'));
        $count1 = $this->AdminOption->find('all', array(
            'joins' => array(
                array(
                    'table' => 'admin_option_org',
                    'alias' => 'ADMIN_ORG',
                    'type' => 'LEFT',
                    'conditions' => array(
                        'ADMIN_ORG.admin_options_id = AdminOption.id'
                    )
                ),
            ),
            'fields' => array(
                'AdminOption.*',
                'ADMIN_ORG.*'
            ), 'conditions' => array('ADMIN_ORG.org_id' => $id)
        ));
        //echo "<pre>"; print_r($count1); die;
        $this->set('list', $count1);
    }

    function important_doc_cat_lists() {

        $q = '1=1';
        $conditions = array($q);
        $this->paginate = array(
            'limit' => 10,
            'conditions' => $conditions,
            'fields' => array('ImportantDocCategory.id', 'ImportantDocCategory.title'),
            'order' => array(
                'ImportantDocCategory.id' => 'asc',
            )
        );

        $result = $this->paginate('ImportantDocCategory');
        //pr($result); die;
        $this->set('list', $result);
    }

    //function to update the option values for admin
    function update_value() {

        $admin_org = new Model(array('table' => 'admin_option_org', 'ds' => 'default', 'name' => 'ADMIN_ORG'));

        $this->autoRender = false;
        $id = $_POST['id'];
        $org_id = $_POST['org'];
        $data['ADMIN_ORG']['status'] = $_POST['value'];
        $value = $admin_org->find('all', array('conditions' => array('admin_options_id' => $id, 'org_id' => $org_id)));
        $data['ADMIN_ORG']['id'] = $value[0]['ADMIN_ORG']['id'];
        $data['ADMIN_ORG']['admin_options_id'] = $id;
        $data['ADMIN_ORG']['org_id'] = $org_id;
        $result = $admin_org->save($data);

        $this->lists($org_id);
    }

    //function to update the important doc category values for admin
    function update_important_doc_cat() {
        $this->autoRender = false;
        $id = $_POST['id'];
        $data['title'] = $_POST['title'];
        $this->ImportantDocCategory->id = $id;
        $result = $this->ImportantDocCategory->save($data);
        $this->important_doc_cat_lists();
    }

    //function to update the important doc category values for admin
    function add_important_doc_cat() {
        $this->autoRender = false;
        //$id = $_POST['id'];
        $data = $_POST['data'];
        //$this->ImportantDocCategory->id = $id;
        $result = $this->ImportantDocCategory->save($data);
        $this->important_doc_cat_lists();
    }

    function add_module() {

        $this->autoRender = false;
        $data['Module']['status'] = 1;
        $data['Module']['org_id'] = $_POST['org_id'];
        $data['Module']['admin_options_id'] = $_POST['ref_id'];
        $admin_org = new Model(array('table' => 'admin_option_org', 'ds' => 'default', 'name' => 'Module'));
        $check = $admin_org->find('count', array('conditions' => array('admin_options_id' => $_POST['ref_id'], 'org_id' => $_POST['org_id'])));

        if ((!$check) > 0) {
            $admin_org->save($data);
            $this->lists($_POST['org_id']);
        } else {

            $st = html_encode(array('msg' => "Duplicate Entry"));
        }
    }

    function accesscontrol() {
        // Configure::write('debug',2);
        $this->layout = 'admin';
    }

    function userslists($org_id, $search_text) {
        //Configure::write('debug',2);
        $q = '1=1';
        if (!empty($this->data)) {
            $id = $this->data['id'];
            $search_text = $this->data['search_text'];
            //if ($id != '') {
            $q .= " AND MyProfile.comp_code = '" . $id . "'";
            //}
            if ($search_text != '') {
                $q .= " AND MyProfile.emp_full_name LIKE '%" . $search_text . "%'";
            }
        }
        $conditions = array($q);

        $this->paginate = array(
            'fields' => array('id', 'emp_full_name', 'emp_code', 'dept_code', 'comp_code'),
            'limit' => 10,
            'conditions' => $conditions
        );
        $this->MyProfile->recursive = -1;
        $count1 = $this->paginate('MyProfile');
        $this->set('list', $count1);
    }

    function getAllEnabledModule() {
        if ($_POST['uc_action'] == 'usercontrol') {
            $this->set('uc_action', $_POST['uc_action']);
            $user = $this->UserDetail->find('first', array('fields' => array('id', 'portal_status'), 'conditions' => array('emp_code' => $_POST['id'], 'comp_code' => $_POST['comp_code'])));
            $this->set('user_portal_status', $user['UserDetail']['portal_status']);
            $this->set('id', $user['UserDetail']['id']);
        } else {
            $enabled_modules = $this->Common->get_all_admin_option($_POST['comp_code']);
            $this->set('enabled_modules', $enabled_modules);
        }
        $this->set('emp_code', $_POST['id']);
        $this->set('comp_code', $_POST['comp_code']);
    }

    function UpdateACL() {
        $auth = $this->Session->read('Auth');
        $tempData = html_entity_decode($this->request->data['rights_type']);
        $cleanData = json_decode($tempData);
        $rights_type = $cleanData;
        $emp_code = $this->request->data['emp_code'];
        $comp_code = $this->request->data['comp_code'];
        $mst_acl = new Model(array('table' => 'mst_acl', 'ds' => 'default', 'name' => 'MST_ACL'));
        $mst_acl->deleteAll(['MST_ACL.emp_code' => $emp_code, 'MST_ACL.org_id' => $comp_code], false);
        foreach ($rights_type as $rt) {
            $arr = explode("rights_type_", $rt->name);
            $mod_id = $arr[1] . '<br>';
            $data['MST_ACL']['admin_options_id'] = $mod_id;
            $data['MST_ACL']['acl_rights_id'] = $rt->value;
            $data['MST_ACL']['emp_code'] = $emp_code;
            $data['MST_ACL']['status'] = 1;
            $data['MST_ACL']['org_id'] = $comp_code;
            $mst_acl->create();
            $mst_acl->save($data);
        }
        echo 'ACL Successfully saved.';
        die;
    }

    function usercontrol() {
        $this->layout = 'admin';
    }

    function resetUserPassword() {
        $this->autoRender = false;
        try {
            if (!$this->request->data['user_id'])
                throw new Exception('Invalid User');
            $user_id = $this->request->data['user_id'];
            $encrypted_password = AuthComponent::password(self::DEFAULT_PASSWORD);
            $update = $this->UserDetail->updateAll(array('user_password' => "'$encrypted_password'"), array('id' => $user_id));
            if (!$update)
                throw new Exception('Something went wrong please try again');
            echo 'Password Reset successfull';
            exit;
        } catch (\Exception $ex) {
            echo $ex->getMessage();
            exit;
        }
    }

    function changeUserPassword() {
        $this->autoRender = false;
        try {
            $user_id = $this->request->data['user_id'];
            $password = $this->request->data['new_pass'];
            $encrypted_password = AuthComponent::password($password);
            $update = $this->UserDetail->updateAll(array('user_password' => "'$encrypted_password'"), array('id' => $user_id));
            if (!$update)
                throw new Exception('Something went wrong please try again');
            echo 'Password Change successfull';
            exit;
        } catch (Exception $ex) {
            echo $ex->getMessage();
            exit;
        }
    }

    function changeUserStatus() {
        $this->autoRender = false;
        try {
            $user_id = $this->request->data['user_id'];
            $portal_status = $this->request->data['portal_status'];
            $status = $portal_status ? 'activated' : 'deactivated';
            $update = $this->UserDetail->updateAll(array('portal_status' => "'$portal_status'"), array('id' => $user_id));
            if (!$update)
                throw new Exception('Something went wrong please try again');
            echo "User $status from portal successfully";
            exit;
        } catch (Exception $ex) {
            echo $ex->getMessage();
            exit;
        }
    }

    function updateMultipleUser() {
        $this->autoRender = false;
        $user_ids = $this->request->data['user_ids'];
        $selected = $this->request->data['selected'];
        $new_password = $this->request->data['new_password'];
        $datasource = $this->UserDetail->getDataSource();
        try {
            $datasource->begin();
            foreach ($user_ids as $user_id) {
                if ($selected == 'change_password') {
                    $encrypted_password = AuthComponent::password($new_password);
                    $update = $this->UserDetail->updateAll(array('user_password' => "'$encrypted_password'"), array('id' => $user_id));
                    $message = "Password Changed succesfull";
                } else if ($selected == 'reset_password') {
                    $encrypted_password = AuthComponent::password(self::DEFAULT_PASSWORD);
                    $update = $this->UserDetail->updateAll(array('user_password' => "'$encrypted_password'"), array('id' => $user_id));
                    $message = "Password Reset succesfull";
                } else if ($selected == 'activate_user') {
                    $update = $this->UserDetail->updateAll(array('portal_status' => 1), array('id' => $user_id));
                    $message = "Users Activation succesfull";
                } else if ($selected == 'deactivate_user') {
                    $update = $this->UserDetail->updateAll(array('portal_status' => 0), array('id' => $user_id));
                    $message = "Users De-Activation succesfull";
                }
                if (!$update)
                    throw new Exception('Something went wrong while updating please try again');
            }
            $datasource->commit();
            echo $message;
            exit;
        } catch (\Exception $ex) {
            $datasource->rollback();
            echo $ex->getMessage();
            exit;
        }
    }

    function synccontrol() {
        $this->layout = 'admin';
    }

    function syncData() {
        $this->autoRender = false;
        $sync_value = $this->request->data['sync_value'];
        
        if(in_array($sync_value, self::form_ids)){
            $insert_status = $this->SyncStatus->save(array('sync_value' => $sync_value));
            if(!$insert_status){
                echo 'Synchronization Failed';
                exit;
            }
            echo 'Synchronization Successful';
            exit;
        }
        else{
            echo 'Synchronization Failed';
            exit;
        }
    }
    
    
    function lastSync(){//function to retrieve last sync date and time
        $this->autoRender = false;
        $last_sync_time = [];
        foreach (self::form_ids as $form_id){
            $status = $this->SyncStatus->find('first', array('conditions' => array('sync_value' => $form_id),'order' => array('created' => 'DESC')));
            if(!empty($status)){
                $last_sync_time[$form_id] = date('M j Y g:i A', strtotime($status['SyncStatus']['created']));
            }
        }
        echo json_encode($last_sync_time); 
        exit;
    }
    

}
