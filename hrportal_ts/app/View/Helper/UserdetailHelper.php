<?php
/**
 * Application level View Helper
 *
 * This file is application-wide helper file. You can put all
 * application-wide helper-related methods here.
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Helper
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('AppHelper', 'View/Helper');

/**
 * Application helper
 *
 * Add your application-wide methods in the class below, your helpers
 * will inherit them.
 *
 * @package       app.View.Helper
 */
class UserdetailHelper extends AppHelper {
	
	public function findSetup($val=null, $ho_org_id=null)
	{
		/*App::import("Model", "MyProfilesetup");  
		$model = new MyProfilesetup();  
		$query=$model->find('first', array(
        'conditions' => array(
		'param_id' => $val,	
		'comp_code' => $ho_org_id)
		));
		return $query['MyProfilesetup']['param_desc'];*/
	}
	
	function findDetailType($val)
	{
		App::import("Model", "MyProfileatt");  
		$model = new MyProfileatt();  
		$query=$model->find('first', array(
        'conditions' => array(
		'att_id' => $val)
		));
		return $query['MyProfileatt']['att_nm'];
	}
	
	function findUserId($id)
	{
		App::import("Model", "MyProfile");  
		$model = new MyProfile();  
		$query=$model->find('first', array(
        'conditions' => array(
		'emp_code' => $id)
		));
		return $query['MyProfile']['emp_name'];
	}
        
	
	function findDeducType($id)
	{
		App::import("Model", "MyProfiledeductype");  
		$model = new MyProfiledeductype();  
		$query=$model->find('first', array(
        'conditions' => array(
		'doc_id' => $id)
		));
		return $query['MyProfiledeductype']['ded_desc'];
	}
	function findCountry($id)
	{
		App::import("Model", "AppCntry");  
		$model = new AppCntry();  
		$query=$model->find('first', array(
        'conditions' => array(
		'cntry_id' => $id)
		));
		return $query['AppCntry']['cntry_desc'];
	}
}
