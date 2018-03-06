<?php

 class Trainingcalender extends AppModel {
    
	/**
     * Model name
     *
     * @var string
     * @access public
     */
	var $name = 'Trainingcalender';
	
	
	
	/**
     * Model use Table
     *
     * @var string
     * @access public
     */
	var $useTable='mst_training_calenders';
	
	/**
     * Model primary key
     *
     * @var string
     * @access public
     */
    var $primaryKey= 'id';
	
	var $hasMany = array(
        'MstTrainingRequests' => array(
             'className' => 'MstTrainingRequests',
			 'foreignKey'=>'id'
            ),
		'TrainingSession' => array(
             'className' => 'TrainingSession',
			    'foreignKey'=>'training_id'
            )
        );
	/*
	**
	**Server Side Validation
	**
	*/
	var $validate=array(
		'vc_course_id' => array(
		
		'notEmpty' => array(
            'rule' => array('notEmpty'),
            'message' => 'Please Select Value For Course Name.'
			)
		)
	);
	
	function getData() {
	
		  $data = $this->find('all');
		  echo "<pre>";print_r($data);
     }
	
	}
