<?php
App::uses('AppModel', 'Model');
/**
 * Event Model
 *
 * @property User $User
 */
class Event extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'title';
	var $useDbConfig = 'default';
    var $name = 'Event';
    var $primaryKey = 'id';
    var $useTable = 'events';


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */	
	
	public $belongsTo = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
