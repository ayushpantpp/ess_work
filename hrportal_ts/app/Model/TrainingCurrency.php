<?php

/**
 * 
 * 	User login Detail Model
 * //DT_TRAINING_FEEDBACK_TRAINERS
 */
class TrainingCurrency extends Model {

    var $name = 'TrainingCurrency';

    /**
     * Model use Table
     *
     * @var string
     * @access public
     */
    var $useTable = "training_currency";

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
