<?php
App::uses('AppHelper', 'View/Helper');

class PermissionHelper extends AppHelper {
    
    public $helpers = array('Html');
    public $components = array('Acl','Session');
    
    public function check($aco) {
     
       App::import('Component', 'Acl');
       $acl = new AclComponent(new ComponentCollection());
        switch ($_SESSION['Auth']['user_type']) {
           
            case 'Employee':
               $current_user_id = $_SESSION['Auth']['User']['vc_emp_id_makess'];//$Session->read('Auth.Employees.vc_emp_id_makess');
                //Cache::delete("{$current_user_id}_{$aco}","default");
                $acl_permission = Cache::read("{$current_user_id}_{$aco}", "default");
                if ($acl_permission !== false) {
                    //CakeLog::write('activity', 'TESTING JAI SHREE RAM'.$acl_permission);
                    return (boolean) $acl_permission;
                }
        
                $aros = $acl->Aro->find('all', array(
                    'conditions' => array(
                        'model' => 'Employee',
                        'foreign_key' => $current_user_id,
                    ),
                ));
                break;
            case 'Customer':
                $aros = $acl->Aro->find('all', array(
                    'conditions' => array(
                        'model' => 'Customer',
                        'foreign_key' => $current_user_id,
                    ),
                ));
                break;
        }
        //$query_end_time = microtime(true);
        //$time = $query_end_time - $start_time;
        //CakeLog::write('activity', 'QUERY '.$time);
        foreach ($aros as $aro) {
            if ($acl->check($aro['Aro'], $aco)) {
                //$end_time = microtime(true);
                //$time = $end_time - $start_time;
                //CakeLog::write('activity', '-- END '.$time.' COUNT '.count($aros));
                Cache::write("{$current_user_id}_{$aco}", "1", "default");
                return true;
            }
        }
        //$end_time = microtime(true);
        //$time = $end_time - $start_time;
        //CakeLog::write('activity', '-- END '.$time.' COUNT '.count($aros));
        Cache::write("{$current_user_id}_{$aco}", "0", "default");
        return false;
    }

}
