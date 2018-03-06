<?php
App::uses('AppModel', 'Model');
/**
 * Separation Model
 *
 */
class Fnf extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'id';
	public $use_table = 'fnfs';

	public $belongsTo = array(
		'Separation' => array(
			'className' => 'Separation',
			'foreignKey' => 'separation_id'
			)
		);

	public $hasMany = array(
		'FnfDetail' => array(
			'className' => 'FnfDetail',
			),/*
		'FnfWorkflow' => array(
			'className' => 'FnfWorkflow',
			),*/
		);

}
