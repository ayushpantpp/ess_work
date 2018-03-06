<?php

/**
 * 
 * 	User login Detail Model
 * //DT_TRAINING_FEEDBACK_TRAINERS
 */
class TrainingParameters extends Model {

    var $name = 'TrainingParameters';

    /**
     * Model use Table
     *
     * @var string
     * @access public
     */
    var $useTable = "training_parameters";

    /**
     * Model primary key
     *
     * @var string
     * @access public
     */
    var $primaryKey = 'id';

    /**
     * validate name
     *
     * @var array
     * @access public
     * @ contain complete description about validation of model
     */
    var $validate = null;

}
