<?php
App::uses('AppModel', 'Model');
/**
 * Separation Model
 *
 */
class FnfWorkflow extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'id';
	public $use_table = 'fnf_workflows';

	public $belongsTo = array(
		'Fnf' => array(
			'className' => 'Fnf',
			'foreignKey' => 'fnf_id'
			)
		);


}
