<?php
class ApplicationscmpComponent extends Object {

    public $uses = array('Applications', 'Roles', 'Permissions', 'PermissionsAcos', 'Acos');

     public function __construct(ComponentCollection $collection,
      $settings = array()) {
        parent::__construct($collection, $settings);
    }
   public function initialize(&$controller) {
        //load required for component models
        if ($this->uses !== false) {
            foreach ($this->uses as $modelClass) {
                $controller->loadModel($modelClass);
                $this->$modelClass = $controller->$modelClass;
            }
        }
    }
    
    public function beforeRender()
    {
    }
    public function shutdown()
    {
    }
    public function startup(&$controller)
    {
        $this->controller = $controller;
    }

    public function getApplicationsTreeJson() {
        $applications = $this->Applications->find('all');
       // pr($applications);die;
        $data = "[";
        foreach ($applications as &$application) {
            if ($data != "[")
                $data = $data . ',';
            $data = $data . '{';
            $data = $data . '"data" : "' . $application['Applications']['vc_application_name'] . '","attr" : { "id" : "' . $application['Applications']['id'] . '", "rel" : "application" }';
            $children = $this->getRolesTreeJson($application['Applications']['id']);
            if ($children != "[{}]")
                $data = $data . ', "children" : ' . $children;
            $data = $data . '}';
        }
        $data = $data . ']';
        return '[{ "data" : "Applications" ,"attr" : { "id" : "0", "rel" : "application" }, "children" : ' . $data . '}]';
    }

    private function getRolesTreeJson($id) {
        $roles = $this->Roles->find('all', array(
                    'conditions' => array(
                        'Roles.nu_application_id' => $id,
                    ),
                ));
        $data = "[";
        foreach ($roles as &$role) {
            if ($data != "[")
                $data = $data . ',';
            $data = $data . '{';
            $data = $data . '"data" : "' . $role['Roles']['name'] . '","attr" : { "id" : "' . $role['Roles']['id'] . '", "rel" : "role"  }';
            $children = $this->getPermissionsTreeJson($role['Roles']['id'], $id);
            if ($children != "[{}]")
                $data = $data . ', "children" : ' . $children;
            $data = $data . '}';
        }
        $data = $data . ']';
        return $data;
    }

    private function getPermissionsTreeJson($roleId, $appId) {
        $permissionsall = $this->Applications->find('all', array(
                    'conditions' => array(
                        'Applications.id' => $appId,
                    )
                ));
        $permissionsall = $permissionsall[0]['Permissions'];
        //pr($permissionsall);
        $permissions = $this->Roles->find('all', array(
                    'conditions' => array(
                        'Roles.id' => $roleId,
                    ),
                        //'fields' =>array('id')
                ));
        $permissions = $permissions[0]['Permissions'];
        //pr($permissions);
        $permissions_sanitized = array();
        for ($i = 0; $i < count($permissions); $i++) {
            $permissions_sanitized[] = $permissions[$i]['id'];
        }

        //die;
        $data = "[";
        foreach ($permissionsall as &$permission) {
            if ($data != "[")
                $data = $data . ',';
            $data = $data . '{';
            $relation_name = "permission";
            if (!in_array($permission['id'], $permissions_sanitized))
                $relation_name = "permission_disabled";
            $data = $data . '"data" : "' . $permission['vc_permission_name'] . '","attr" : { "id" : "' . $roleId . "_" . $permission['id'] . '", "rel" : "' . $relation_name . '"  }';
            $data = $data . '}';
        }
        $data = $data . ']';
        return $data;
    }

    public function getControllerActionTreeList($id) {
       
        $acos_locked = array();
        $controller_parent_acos = $this->Permissions->Acos->find('all', array(
                    'conditions' => array(
                        'alias' => 'Controllers'
                    )
                ));
       
        $acos = $this->Permissions->find('all', array(
                    'conditions' => array(
                        'id' => $id
                    )
                        )
        );
        //echo "List of ACOS used by this Permission:";
        //print_r($acos);
        if (isset($acos[0])) {
            $application_id = $acos[0]['Permissions']['nu_application_id'];
            $acos = $acos[0]['Acos'];
            //Find the list of ACOS which are not found in the current application 
            $permissions_sibling_list = $this->Permissions->find('list', array(
                        'conditions' => array(
                            'nu_application_id' => $application_id
                        ),
                        'fields' => array(
                            'id'
                        )
                            )
            );
            array_push($permissions_sibling_list,0);
            //pr($permissions_sibling_list);
            //echo "List of Permissions Siblings ";
            //pr($permissions_sibling_list);
            $acos_locked = $this->PermissionsAcos->find('list', array(
                        'conditions' => array(
                            'nu_permission_id NOT ' => $permissions_sibling_list
                        ),
                        'fields' => array(
                            'nu_aco_id'
                        )
                    ));
            //echo "List of Locked ACOS";
            //pr($acos_locked);
            //echo "Testing InArray:" . in_array($aco_sanitized_id[1], $acos_locked);
            //die;            
        }
        //pr($acos);
        foreach ($acos as $aco) {
            if ($aco['parent_id'] == $controller_parent_acos[0]['Acos']['id']) {
                $aco_sanitized_alias[] = $aco['alias'];
                $aco_sanitized_id[] = $aco['id'];
                $aco_sanitized_allow[] = $aco['PermissionsAco']['ch_allow'];
            }
        }
        //echo "List of Sanitized Alias:";
        //pr($aco_sanitized_id);
      //  pr($this->controller);
        $Controllers = App::objects('controller');
        
        foreach ($Controllers as $controller) {
            if ($controller != 'AppController') {
                // Load the controller
                App::import('Controller', str_replace('Controller', '', $controller));

                // Load its methods / actions
                $aMethods = get_class_methods($controller);
               // print_r($aMethods);die;
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

        $data = "[";
        foreach ($Controllers as $Controller) {
           $ctrlName = Inflector::camelize(substr($Controller, 0, strpos($Controller, 'controller') - 10));
            $controller_parent_acos[0]['Acos']['id'] = isset($controller_parent_acos[0]['Acos']['id']) ? $controller_parent_acos[0]['Acos']['id'] : 0;
            if ($data != "[")
                $data = $data . ',';
            $data = $data . '{';
            $ctrlId = $this->Acos->find('first', array(
                        'conditions' => array(
                            'alias' => $ctrlName,
                            'parent_id' => $controller_parent_acos[0]['Acos']['id']
                        )
                            )
            );
          
            $ctrlId = isset($ctrlId['Acos']['id']) ? $ctrlId['Acos']['id'] : 0;
            $relation_name = 'controller_notspecified';
            if (in_array($ctrlId, $acos_locked)) {
                $relation_name = 'controller_locked';
            } else {
                if (isset($aco_sanitized_alias)) {
                    if (in_array($ctrlName, $aco_sanitized_alias)) {
                        $key = array_search($ctrlName, $aco_sanitized_alias);
                        //$ctrlId = $aco_sanitized_id[$key];
                        $allow = $aco_sanitized_allow[$key];

                        if ($allow == 1) {
                            $relation_name = 'controller_enabled';
                        } else {
                            $relation_name = 'controller_disabled';
                        }
                    }
                }
            }
            $data = $data . '"data" : "' . $ctrlName . '","attr" : { "id" : "' . $ctrlName . '", "rel" : "' . $relation_name . '" }';
            $children = $this->getActionTreeList($ctrlName, $ctrlId, $id, $relation_name);
            if ($children != "[{}]")
                $data = $data . ', "children" : ' . $children;
            $data = $data . '}';
        }
        $data = $data . ']';
        return '[{ "data" : "ControllersAndActions" ,"attr" : { "id" : "0", "rel" : "controller_enabled" }, "children" : ' . $data . '}]';
    }

   public function getActionTreeList($ctrlName, $ctrlId, $id, $controller_relation_name) {
        //$this->autoRender = false;
        //echo "Parent Controller Id:".$ctrlId;
        $acos_locked = array();
        $action_parent_acos = $this->Permissions->Acos->find('all', array(
                    'conditions' => array(
                        'id' => $ctrlId
                    )
                        )
        );
//        if($ctrlName=='Acls'){
//        echo "<br/>Actions Parent ACOs";
//        pr($action_parent_acos);
//        die;
//        }
        $acos = $this->Permissions->find('all', array(
                    'conditions' => array(
                        'id' => $id
                    )
                        )
        );
//        if($ctrlName=='Acls'){
//        echo "ACOS:";
//        pr($acos);
//        die;
//        }        
        if (isset($acos[0])) {
            $application_id = $acos[0]['Permissions']['nu_application_id'];
//            echo "list of acos";
//            pr($acos);
            $acos = $acos[0]['Acos'];
            //Find the list of ACOS which are not found in the current application 
            $permissions_sibling_list = $this->Permissions->find('list', array(
                        'conditions' => array(
                            'nu_application_id' => $application_id
                        ),
                        'fields' => array(
                            'id'
                        )
                            )
            );
            array_push($permissions_sibling_list,0);
            //echo "List of Permissions Siblings ";
            //pr($permissions_sibling_list);
            $acos_locked = $this->PermissionsAcos->find('list', array(
                        'conditions' => array(
                            'nu_permission_id NOT ' => $permissions_sibling_list
                        ),
                        'fields' => array(
                            'nu_aco_id'
                        )
                    ));
            //echo "list of locked ACOS";
            //pr($acos_locked);
            //die;
        }
//        if($ctrlName=='Acls'){
//            echo "";
//            pr($acos);
//            die;
//        }
        if (isset($action_parent_acos[0]))
//            echo "in heress";
//            pr($acos);
            foreach ($acos as $aco) {
                if ($aco['parent_id'] == $action_parent_acos[0]['Acos']['id']) {
                    $aco_sanitized_alias[] = $aco['alias'];
                    $aco_sanitized_id[] = $aco['id'];
                    $aco_sanitized_allow[] = $aco['PermissionsAco']['ch_allow'];
                }
            }
//        if($ctrlName=='Acls'){
//        pr( $aco_sanitized_alias);
//        pr( $aco_sanitized_id);
//        pr( $aco_sanitized_allow);
//        die;
//        }

        App::import('Controller', $ctrlName);
        $ctrlclass = $ctrlName . 'Controller';
        $methods = get_class_methods($ctrlclass);
        $baseMethods = get_class_methods('Controller');
        $baseMethods[] = 'buildAcl';
        $data = "[";
        foreach ($methods as $k => $method) {
            if (strpos($method, '_', 0) === 0) {
                unset($methods[$k]);
                continue;
            }
            if (in_array($method, $baseMethods)) {
                unset($methods[$k]);
                continue;
            }
            if ($data != "[")
                $data = $data . ',';
            $data = $data . '{';
            //If Controller is Allowed to Access
            //so are its Actions and visa-versa
            $relation_name = "action_notspecified";
            if ($controller_relation_name == 'controller_enabled')
                $relation_name = "action_enabled";

            if ($controller_relation_name == 'controller_disabled')
                $relation_name = "action_disabled";
            //echo "Parent Id found in Action:".$ctrlId;
            $action_id = $this->Acos->find('first', array(
                        'conditions' => array(
                            'parent_id' => $ctrlId,
                            'alias' => $method
                        )
                            )
            );
            //echo "<BR/>Retriveing action id";
            //pr($action_id);
            //pr($acos_locked);
            //echo "<br/>==========================================================";
            //die;
            $action_id = isset($action_id['Acos']['id']) ? $action_id['Acos']['id'] : 0;
            //But if it is specified explicitly the 
            //access of Allow/Deny on an action
            //echo "<br/> Action ID".$action_id."  bool ".(in_array($action_id, $acos_locked));
            if (in_array($action_id, $acos_locked)) {
                //echo "FROM HEREWERWERWE";
                $relation_name = 'action_locked';
            } else {
//                echo "FROM HERE SDFSDF";
//                pr($aco_sanitized_alias);
                if (isset($aco_sanitized_alias)) {
                    if (in_array($method, $aco_sanitized_alias)) {
//                        echo "method name".$method;
                        $key = array_search($method, $aco_sanitized_alias);
                        $allow = $aco_sanitized_allow[$key];
//                        echo "allow".$allow;
                        if ($allow == 1)
                            $relation_name = 'action_enabled';
                        else
                            $relation_name = 'action_disabled';
                    }
                }
            }
            $data = $data . '"data" : "' . $method . '","attr" : { "id" : "' . $method . '", "rel" : "' . $relation_name . '" }';
            $data = $data . '}';
        }
        $data = $data . ']';
        return $data;
    }
}