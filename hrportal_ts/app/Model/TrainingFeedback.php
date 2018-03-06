<?php

class TrainingFeedback extends Model {

    var $name = 'TrainingFeedback';

    /**
     * Model use Table
     *
     * @var string
     * @access public
     */
    var $useTable = "training_feedback_details";

    /**
     * Model primary key
     *
     * @var string
     * @access public
     */
    var $primaryKey = 'feedback_id';
    public $hasMany = array(
        'TrainingTrainerFeedback' => array(
            'className' => 'TrainingTrainerFeedback',
            'foreignKey' => 'feedback_id'
        )
    );

}
