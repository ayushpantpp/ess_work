<?php
App::uses('AppModel', 'Model');
/**
 * Separation Model
 *
 */
class FnfDetail extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'id';
	public $use_table = 'fnf_details';

	public $belongsTo = array(
		'Fnf' => array(
			'className' => 'Fnf',
			'foreignKey' => 'fnf_id'
			),
		'Project' => array(
			'className' => 'Project',
			'foreignKey' => 'project_id'
			),
		);



}
