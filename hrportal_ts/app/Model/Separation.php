<?php
App::uses('AppModel', 'Model');
/**
 * Separation Model
 *
 */
class Separation extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'emp_code';

	public $hasMany = array(
		'SeparationWorkflow' => array(
			'className' => 'SeparationWorkflow',
			'foreignKey' => 'separation_id'
			)
		);
	public $belongsTo = array(
		'WfMstStatus' => array(
			'className' => 'WfMstStatus',
			'foreignKey' => 'status'
			)
		);

}
