<?php
  class TrainingSession extends Model {
	
	var $name = 'TrainingSession';
	
	
	
	
	var $useTable='dt_training_sessions';
	
	/**
     * Model primary key
     *
     * @var string
     * @access public
     */
    
	var $primaryKey= 'id';
	
	/*
	**
	**Assosciation
	**
	*/
	
	var $hasMany = array(
        'HdTrainingSession' => array(
            'className' => 'HdTrainingSession',
			'foreignKey'=>'training_sessions_id'
            )
    );	
		
		
   }