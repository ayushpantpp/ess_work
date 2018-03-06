<?php

ob_start();
App::uses('AppController', 'Controller');

class AclsController extends AppController {

    public $uses = array('Roles', 'Applications', 'RolesPermissions', 'Acos', 'PermissionsAcos', 'Aros', 'ArosAcos', 'Permissions', 'UserDetail');
    public $components = array('Session', 'Cookie', 'RequestHandler', 'Applicationscmp');
    public $helpers = array('Html', 'Js', 'Form', 'Session'); //Helper

    public function beforeFilter() {
        $this->Auth->allow();
        if ($this->Auth->user('user_type') != 'Administrator') {
            $this->redirect(array('controller' => 'admins', 'action' => 'login'));
        }
        parent::beforeFilter();
    }

    public function application() {
        $this->layout = 'admin';
        $this->Auth->allow();
        // $this->Applications->recursive=3;
        $applications = $this->Applications->find('all');
        //  pr($applications);die;
        $arr = array();
        foreach ($applications as $app) {
            $arr[$app['Applications']['id']] = $app['Applications']['vc_application_name'];
        }
        $this->set('applications', $arr);
    }

    public function pr_controlleractiontreelist_json() {
        $this->layout = '';
        $this->autoRender = false;
        header("HTTP/1.0 200 OK");
        header('Content-type: text/json; charset=utf-8');
        header("Cache-Control: no-cache, must-revalidate");
        header("Expires: Mon, 21 Oct 2011 10:30:00 IST");
        header("Pragma: no-cache");
        if (empty($this->request->data['id']))
            $this->request->data['id'] = 13;
        $response = $this->Applicationscmp->getControllerActionTreeList($this->request->data['id']);
        echo $response;
    }

    public function pr_permissionenable_json() {
        $response = new stdClass();
        $this->layout = '';
        $this->autoRender = false;
        header("HTTP/1.0 200 OK");
        header('Content-type: text/json; charset=utf-8');
        header("Cache-Control: no-cache, must-revalidate");
        header("Expires: Mon, 21 Oct 2011 10:30:00 IST");
        header("Pragma: no-cache");
        $rolespermissions = $this->RolesPermissions->find('count', array(
            'conditions' => $this->request->data['RolesPermissions']
                )
        );
        if ($rolespermissions == 0)
            $this->RolesPermissions->save($this->request->data);
        $permissionsacos = $this->PermissionsAcos->find('all', array(
            'conditions' => array(
                'nu_permission_id' => $this->request->data['RolesPermissions']['nu_permission_id']
            )
        ));
        $aro = $this->Acl->Aro->find('first', array(
            'conditions' => array(
                'Aro.model' => 'Roles',
                'Aro.foreign_key' => $this->request->data['RolesPermissions']['nu_role_id'], //$current_user_id;
            ),
            'fields' => array(
                'model',
                'foreign_key'
            ),
        ));

        /*
          //Clear current employees cache
          $acos = $this->Acl->Aco->find('all');
          foreach($acos as $aco){
          $aco_parent = $this->Acl->Aco->findById($aco['Aco']['parent_id']);
          Cache::delete(intval($employee_id)."_".($aco_parent['Aco']['alias']."/".$aco['Aco']['alias']),"default");
          }
         */
        $aro = $aro['Aro'];
        foreach ($permissionsacos as $permissionaco) {
            //$permissionaco['PermissionsAcos']['nu_aco_id']
            //echo "<br/>START===================================";
            //echo "<br/>Role ID" . $this->data['Roles']['id'];
            $loop = true;
            $id = $permissionaco['PermissionsAcos']['nu_aco_id'];
            $aco_name = '';
            $counter = 0;
            while ($loop) {
                $aco = $this->Acl->Aco->findById($id);
                //$aco_name = Inflector::camelize($aco['Aco']['alias']) . ($aco_name==''?"":"/") .$aco_name;
                $aco_name = $aco['Aco']['alias'] . ($aco_name == '' ? "" : "/") . $aco_name;
                $id = $aco['Aco']['parent_id'];
                $counter++;
                if ($id == '' || $counter == 2)
                    $loop = false;
            }
            //$aco_name = Inflector::camelize($aco_name);
            //echo "<br/>NAMESSSS  " . $aco_name;
            //echo $permissionaco['PermissionsAcos']['ch_allow'];
            //pr($aro);
            //$aro = 'HR_R_17';
            //echo "ACO NAME::::::::::::";pr($aco_name);pr($id);// = 'Appraisal/view';
            if (intval($permissionaco['PermissionsAcos']['ch_allow']) == 1)
                $this->Acl->allow($aro, $aco_name);
            else
                $this->Acl->deny($aro, $aco_name);
            //echo "<br/>END===================================";
        }
        $response->message = 'Permission enabled successfully.';
        echo json_encode($response);
    }

    public function prApplicationRoleListHtml() {
        $applications = $this->Applications->find('all');
        $arr = array();
        foreach ($applications as $app) {
            $arr[$app['Applications']['id']]['name'] = $app['Applications']['vc_application_name'];
            $roles = $this->Roles->find('list', array(
                'conditions' => array(
                    'nu_application_id' => $app['Applications']['id']
                ),
                'fields' => array(
                    'name'
                )
            ));
            $arr[$app['Applications']['id']]['roles'] = $roles;
        }
        $this->set('applications', $arr);
    }

    public function prAssignroleJson() {
        $response = new stdClass();
        $this->layout = '';
        $this->autoRender = false;
        header("HTTP/1.0 200 OK");
        header('Content-type: text/json; charset=utf-8');
        header("Cache-Control: no-cache, must-revalidate");
        header("Expires: Mon, 21 Oct 2011 10:30:00 IST");
        header("Pragma: no-cache");

        //$this->Acl->Aro->deleteAll(array('Aro.model'=>'Employees'));echo "DONE";
        //die;
        //Lets get the array of employee ids to who we need to assign the role
        if (isset($this->request->data['empIdList'])) {
            $employee_ids = explode(',', $this->request->data['empIdList']);
        } else {
            $conditions = array();
            if (!empty($this->request->data['UserDetail']['name'])) {
                $conditions['UserDetail.emp_name like'] = '%' . strtoupper($this->request->data['UserDetail']['name']) . '%';
            }

            $employee_ids = $this->UserDetail->find('list', array(
                'conditions' => $conditions,
                'fields' => array('emp_code', 'emp_code')
            ));
        }
        //pr($this->data);die;
        set_time_limit(0);
        //Apply role to each employee
        $db = $this->Roles->getDataSource();
        $db->begin();
        foreach ($employee_ids as $employee_id):
            foreach ($this->data['assignrole'] as $assignrole):
                if ($assignrole['nu_application_id'] != '' && $assignrole['nu_role_id'] != '') {
                    if (is_numeric($assignrole['nu_application_id']) && is_numeric($assignrole['nu_role_id'])) {
                        $aro = & $this->Acl->Aro;
                        //Find list of all roles under 
                        $roles = $this->Roles->find('list', array(
                            'conditions' => array(
                                'nu_application_id' => $assignrole['nu_application_id']
                            ),
                            'fields' => array('id')
                        ));
                        $roles = $aro->find('list', array(
                            'conditions' => array(
                                'Aro.foreign_key' => $roles,
                                'Aro.model' => 'Roles'
                            ),
                            'fields' => array('id')
                        ));
                        //Find Access Requester Object of the current employee
                        $employee = $aro->find('first', array(
                            'conditions' => array(
                                'Aro.parent_id' => $roles,
                                'Aro.foreign_key' => intval($employee_id),
                                'Aro.model' => 'UserDetail'
                            )
                        ));
                        //Clear current employees cache
                        $acos = $this->Acl->Aco->find('all');
                        //pr($acos);die;
                        foreach ($acos as $aco) {
                            $aco_parent = $this->Acl->Aco->findById($aco['Aco']['parent_id']);
                            Cache::delete(intval($employee_id) . "_" . (@$aco_parent['Aco']['alias'] . "/" . @$aco['Aco']['alias']), "default");
                        }
                        //If Access Requester Object is not found then create it
                        if (empty($employee)) {
                            //echo "Employee is empty<br/>";
                            $parent_role = $aro->find('first', array(
                                'conditions' => array(
                                    'Aro.foreign_key' => $assignrole['nu_role_id'],
                                    'Aro.model' => 'Roles'
                                )
                            ));
                            $new_employee = array(
                                'alias' => 'UserDetail' . intval($employee_id),
                                'parent_id' => $parent_role['Aro']['id'],
                                'model' => 'UserDetail',
                                'foreign_key' => intval($employee_id),
                            );
                            $employee['Aro'] = $new_employee;
                            //$employee['Aco'] = array();
                            $aro->create();
                            $succ = $aro->save($employee);
                        } else {
                            //If Access Requester Object is found then update it
                            $parent_role = $aro->find('first', array(
                                'conditions' => array(
                                    'Aro.foreign_key' => $assignrole['nu_role_id'],
                                    'Aro.model' => 'Roles'
                                )
                            ));
                            $employee['Aro']['parent_id'] = $parent_role['Aro']['id'];
                            $aro->save($employee);
                        }
                    } else {
                        $response->message = 'Some roles may not have been assigned.';
                        $response->status = 0;
                    }
                } else {      //remove permission of aro
                    if ($assignrole['nu_application_id'] != '' && $assignrole['nu_role_id'] == '') {
                        if (is_numeric($assignrole['nu_application_id'])) {
                            $aro = & $this->Acl->Aro;
                            //Find list of all roles under 
                            $roles = $this->Roles->find('list', array(
                                'conditions' => array(
                                    'nu_application_id' => $assignrole['nu_application_id']
                                ),
                                'fields' => array('id')
                            ));
                            $roles = $aro->find('list', array(
                                'conditions' => array(
                                    'Aro.foreign_key' => $roles,
                                    'Aro.model' => 'Roles'
                                ),
                                'fields' => array('id')
                            ));
                            //Find Access Requester Object of the current employee
                            $employee = $aro->find('first', array(
                                'conditions' => array(
                                    'Aro.parent_id' => $roles,
                                    'Aro.foreign_key' => intval($employee_id),
                                    'Aro.model' => 'UserDetail'
                                )
                            ));
                            if (!empty($employee)) {
                                $aro->delete($employee['Aro']['id']);
                            }
                        }
                    } else {
                        $response->message = 'Some roles may not have been assigned.';
                        $response->status = 0;
                    }
                }
            endforeach;
        endforeach;
        if (!isset($response->message)) {
            $response->message = 'Role assigned to ' . count($employee_ids) . ' user successfully.';
            $response->status = 1;
        }
        echo json_encode($response);
        //$db->rollback();
        $db->commit();
    }

    public function pr_permissiondisable_json() {
        $response = new stdClass();
        $this->layout = '';
        $this->autoRender = false;
        header("HTTP/1.0 200 OK");
        header('Content-type: text/json; charset=utf-8');
        header("Cache-Control: no-cache, must-revalidate");
        header("Expires: Mon, 21 Oct 2011 10:30:00 IST");
        header("Pragma: no-cache");
        //pr($this->data);
        $permissionsacos = $this->PermissionsAcos->find('all', array(
            'conditions' => array(
                'nu_permission_id' => $this->request->data['RolesPermissions']['nu_permission_id']
            )
        ));
        //echo 'List of permissions to be applied:';
        //pr($permissionsacos);
        $aro = $this->Acl->Aro->find('first', array(
            'conditions' => array(
                'Aro.model' => 'Roles',
                'Aro.foreign_key' => $this->request->data['RolesPermissions']['nu_role_id'], //$current_user_id;
            )
        ));
        //echo "Found ARO:";
        //pr($aro);
        $result = true;
        $aro = $aro['Aro'];
        $message = '';
        foreach ($permissionsacos as $permissionaco) {
            //$permissionaco['PermissionsAcos']['nu_aco_id']
            //echo "<br/>START===================================";
            //echo "<br/>Role ID" . $this->data['Roles']['id'];
            $result = $result AND $this->ArosAcos->deleteAll(array(
                        'aro_id' => $aro['id'],
                        'aco_id' => $permissionaco['PermissionsAcos']['nu_aco_id']
            ));
            //$message = $message . "     >>>>>>" . $aro['id'] . " " . $permissionaco['PermissionsAcos']['nu_aco_id'];
            //echo "<br/>END===================================";
        }

        $this->RolesPermissions->deleteAll($this->request->data['RolesPermissions'], false);
        if ($result) {
            $response->message = 'Permission disabled successfully.' . $message;
        } else {
            $response->message = 'Permission disabled failed.';
        }

        echo json_encode($response);
    }

    public function buildAcl() {
        $log = array();

        $aco = & $this->Acl->Aco;
        $root = $aco->node('controllers');
        if (!$root) {
            $aco->create(array('parent_id' => null, 'model' => null, 'alias' => 'controllers'));
            $root = $aco->save();
            $root['Aco']['id'] = $aco->id;
            $log[] = 'Created Aco node for controllers';
        } else {
            $root = $root[0];
        }


        $Controllers = App::objects('controller');

        foreach ($Controllers as $controller) {
            if ($controller != 'AppController') {
                // Load the controller
                App::import('Controller', str_replace('Controller', '', $controller));

                // Load its methods / actions
                $aMethods = get_class_methods($controller);

                foreach ($aMethods as $idx => $method) {

                    if ($method{0} == '_') {
                        unset($aMethods[$idx]);
                    }
                }

                // Load the ApplicationController (if there is one)
                App::import('Controller', 'AppController');
                $parentActions = get_class_methods('AppController');

                $controllers[$controller] = array_diff($aMethods, $parentActions);
            }
        }
        /* App::import('Core', 'File');
          $dir = new Folder(CONTROLLERS);
          list($dirs, $Controllers) = $dir->read();
          $baseMethods = get_class_methods('Controller'); */
        $baseMethods[] = 'buildAcl';

        // look at each controller in app/controllers
        foreach ($Controllers as $Controller) {
            $ctrlName = Inflector::camelize(substr($Controller, 0, strpos($Controller, 'controller') - 10));

            App::import('Controller', $ctrlName);
            $ctrlclass = $ctrlName . 'Controller';
            $methods = get_class_methods($ctrlclass);

            // find / make controller node
            $controllerNode = $aco->node('controllers/' . $ctrlName);
            if (!$controllerNode) {
                $aco->create(array('parent_id' => $root['Aco']['id'], 'model' => null, 'alias' => $ctrlName));
                $controllerNode = $aco->save();
                $controllerNode['Aco']['id'] = $aco->id;
                $log[] = 'Created Aco node for ' . $ctrlName;
            } else {
                $controllerNode = $controllerNode[0];
            }

            //clean the methods. to remove those in Controller and private actions.
            foreach ($methods as $k => $method) {
                if (strpos($method, '_', 0) === 0) {
                    unset($methods[$k]);
                    continue;
                }
                if (in_array($method, $baseMethods)) {
                    unset($methods[$k]);
                    continue;
                }
                $methodNode = $aco->node('controllers/' . $ctrlName . '/' . $method);
                if (!$methodNode) {
                    $aco->create(array('parent_id' => $controllerNode['Aco']['id'], 'model' => null, 'alias' => $method));
                    $methodNode = $aco->save();
                    $log[] = 'Created Aco node for ' . $method;
                }
            }
        }
        debug($log);
    }

    public function pr_controlleractionrelease_json() {
        $response = new stdClass();
        $this->layout = '';
        $this->autoRender = false;
        header("HTTP/1.0 200 OK");
        header('Content-type: text/json; charset=utf-8');
        header("Cache-Control: no-cache, must-revalidate");
        header("Expires: Mon, 21 Oct 2011 10:30:00 IST");
        header("Pragma: no-cache");
        //echo "This Data";
        //pr($this->data);
        if ($this->request->data['controller_alias'] == '0')
            $this->request->data['controller_alias'] = 'Controllers';
        $controller_id = $this->Acos->find('first', array(
            'conditions' => array(
                'Acos.alias' => $this->request->data['controller_alias']
            ),
            'fields' => array('id')
        ));
        //echo "Current Controller";
        //pr($controller_id);
        $controller_id = $controller_id['Acos']['id'];
        $action_id = $this->Acos->find('first', array(
            'conditions' => array(
                'Acos.alias' => $this->request->data['action_alias'],
                'Acos.parent_id' => $controller_id
            ),
            'fields' => array('id')
        ));
        //echo "Current Action";
        //pr($action_id);
        $action_id = isset($action_id['Acos']['id']) ? $action_id['Acos']['id'] : 0;
        $permissionsacos = $this->PermissionsAcos->find('first', array(
            'conditions' => array(
                'nu_permission_id' => $this->request->data['nu_permission_id'],
                'nu_aco_id' => $action_id
            )
        ));
        //pr($permissionsacos);
        if (!empty($permissionsacos)) {
            //pr($permissionsacos);
            $this->PermissionsAcos->delete($permissionsacos['PermissionsAcos']['id']);
        }
        //pr($permissionsacos);
        $response->message = 'Controller Action released successfully.';
        echo json_encode($response);
    }

    public function pr_controlleractionallow_json() {
        $response = new stdClass();
        $this->layout = '';
        $this->autoRender = false;
        header("HTTP/1.0 200 OK");
        header('Content-type: text/json; charset=utf-8');
        header("Cache-Control: no-cache, must-revalidate");
        header("Expires: Mon, 21 Oct 2011 10:30:00 IST");
        header("Pragma: no-cache");
        if ($this->request->data['controller_alias'] == '0')
            $this->request->data['controller_alias'] = 'Controllers';
        $controller_id = $this->Acos->find('first', array(
            'conditions' => array(
                'Acos.alias' => $this->request->data['controller_alias']
            ),
            'fields' => array('id')
        ));

        if (empty($controller_id)) {
            $supercontroller_id = $this->Acos->find('first', array(
                'conditions' => array(
                    'Acos.alias' => 'Controllers'
                ),
                'fields' => array('id')
            ));
            $this->Acl->Aco->create(array('parent_id' => $supercontroller_id['Acos']['id'], 'model' => null, 'alias' => $this->request->data['controller_alias']));
            $this->Acl->Aco->save();
            $controller_id['Acos']['id'] = $this->Acl->Aco->id;
        }
        //echo "Current Controller";
        //pr($controller_id);        
        $controller_id = $controller_id['Acos']['id'];
        $action_id = $this->Acos->find('first', array(
            'conditions' => array(
                'Acos.alias' => $this->request->data['action_alias'],
                'Acos.parent_id' => $controller_id
            ),
            'fields' => array('id')
        ));

        if (empty($action_id)) {
            $this->Acl->Aco->create(array('parent_id' => $controller_id, 'model' => null, 'alias' => $this->request->data['action_alias']));
            $this->Acl->Aco->save();
            $action_id['Acos']['id'] = $this->Acl->Aco->id;
        }
        //echo "Current Action";
        //pr($action_id);
        $action_id = $action_id['Acos']['id'];
        $permissionsacos = $this->PermissionsAcos->find('first', array(
            'conditions' => array(
                'nu_permission_id' => $this->request->data['nu_permission_id'],
                'nu_aco_id' => $action_id
            )
        ));

        if (!empty($permissionsacos)) {
            $permissionsacos['PermissionsAcos']['ch_allow'] = 1;
        } else {
            $permissionsacos['PermissionsAcos']['nu_permission_id'] = $this->request->data['nu_permission_id'];
            $permissionsacos['PermissionsAcos']['nu_aco_id'] = $action_id;
            $permissionsacos['PermissionsAcos']['ch_allow'] = 1;
        }
        //pr($permissionsacos);
        $this->PermissionsAcos->save($permissionsacos);
        $response->message = 'Controller Action allowed successfully.';
        echo json_encode($response);
    }

    public function pr_controlleractiondeny_json() {
        $response = new stdClass();
        $this->layout = '';
        $this->autoRender = false;
        header("HTTP/1.0 200 OK");
        header('Content-type: text/json; charset=utf-8');
        header("Cache-Control: no-cache, must-revalidate");
        header("Expires: Mon, 21 Oct 2011 10:30:00 IST");
        header("Pragma: no-cache");
        //echo "This Data:";
        //pr($this->data);
        if ($this->request->data['controller_alias'] == '0')
            $this->request->data['controller_alias'] = 'Controllers';
        //echo "This Data(After):".($this->data['controller_alias'] == '0');
        //pr($this->data);        
        $controller_id = $this->Acos->find('first', array(
            'conditions' => array(
                'Acos.alias' => $this->request->data['controller_alias']
            ),
            'fields' => array('id')
        ));
        //echo "Controller ID";
        //pr($controller_id);
        $controller_id = $controller_id['Acos']['id'];
        $action_id = $this->Acos->find('first', array(
            'conditions' => array(
                'Acos.alias' => $this->request->data['action_alias'],
                'Acos.parent_id' => $controller_id
            ),
            'fields' => array('id')
        ));
        if (empty($action_id)) {
            $this->Acl->Aco->create(array('parent_id' => $controller_id, 'model' => null, 'alias' => $this->request->data['action_alias']));
            $this->Acl->Aco->save();
            $action_id['Acos']['id'] = $this->Acl->Aco->id;
        }
        //echo "Action ID";
        //pr($action_id);
        $action_id = $action_id['Acos']['id'];
        $permissionsacos = $this->PermissionsAcos->find('first', array(
            'conditions' => array(
                'nu_permission_id' => $this->request->data['nu_permission_id'],
                'nu_aco_id' => $action_id
            )
        ));
        //echo "Permissions Acos";
        //pr($permissionsacos);
        if (!empty($permissionsacos)) {
            $permissionsacos['PermissionsAcos']['ch_allow'] = -1;
        } else {
            $permissionsacos['PermissionsAcos']['nu_permission_id'] = $this->request->data['nu_permission_id'];
            $permissionsacos['PermissionsAcos']['nu_aco_id'] = $action_id;
            $permissionsacos['PermissionsAcos']['ch_allow'] = -1;
        }
        //pr($permissionsacos);
        $this->PermissionsAcos->save($permissionsacos);
        $response->message = 'Controller Action denied successfully.';
        echo json_encode($response);
    }

    function assignrole() {
        $this->layout = 'admin';
    }

    function assignrolereport() {
        $this->layout = 'admin';

        $applications = $this->Applications->find('list', array(
            'fields' => array('id', 'vc_application_name')
        ));
        $applications = array('0' => '--Select Applicaton--') + $applications;

        $this->set(compact('applications'));
    }

}
