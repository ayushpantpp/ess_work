<?php
 class TrainerMaster extends AppModel {
    
	/**
     * Model name
     *
     * @var string
     * @access public
     */
	var $name = 'TrainerMaster';
	
	/**
     * Model Database Configuration
     *
     * @var string
     * @access public
     */
   
	
	/**
     * Model use Table
     *
     * @var string
     * @access public
     */
	var $useTable='mst_trainer_masters';
	
	/**
     * Model primary key
     *
     * @var string
     * @access public
     */
    var $primaryKey= 'id';
	
	/*
	**
	**Server Side Validation
	**
	*/
	var $validate=array(
		'course_id' => array(
			'required' => array(
				'rule' => 'notEmpty',
				'required' =>true,
				'message' => 'Please select course name.'
			)
		),
		'trainer_id' => array(
			'required' => array(
				'rule' => 'notEmpty',
				'required' =>true,
				'message' => 'Please select reviewer name.'
			)
		)
	);
	}
