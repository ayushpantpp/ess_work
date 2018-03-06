<?php

/**
 * 
 * 	User login Detail Model
 */
class TrainingCreation extends Model {

    /**
     * Model name
     *
     * @var string
     * @access public
     */
    var $name = 'TrainingCreation';

    /**
     * Model use Table
     *
     * @var string
     * @access public
     */
    var $useTable = "training_creation";

    /**
     * Model primary key
     *
     * @var string
     * @access public
     */
    var $primaryKey = 'training_id';
    public $hasMany = array(
        'TrainingWorkflow' => array(
            'className' => 'TrainingWorkflow',
            'foreignKey' => 'training_creation_id'
        ), 'TrainingEmployee' => array(
            'className' => 'TrainingEmployee',
            'foreignKey' => 'training_creation_id'
        ), 'TrainingCourseAttendence' => array(
            'className' => 'TrainingCourseAttendence',
            'foreignKey' => 'training_creation_id'
        )
    );
    
    public $belongsTo=array(
        'TrainingCourseCreation' =>array(
            'className' => 'TrainingCourseCreation',
            'foreignKey' => 'course_id'
        ),'TrainingScheduleCreation' =>array(
            'className' => 'TrainingScheduleCreation',
            'foreignKey' => 'schedule_id'
        )
        
    );
  
}
