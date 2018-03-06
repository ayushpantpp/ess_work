<?php
/**
 * 
 *	User login Detail Model
 * //DT_TRAINING_FEEDBACK_TRAINERS
 */
class TrainingSchedule extends Model {

    /**
     * Model name
     *
     * @var string
     * @access public
     */
    var $name = 'TrainingSchedule';

   
    /**
     * Model use Table
     *
     * @var string
     * @access public
     */
    var $useTable = "MST_TRAINING_SCHEDULE_DETAILS";
    
    /**
     * Model primary key
     *
     * @var string
     * @access public
     */
    var $primaryKey= 'id';
    
   


}