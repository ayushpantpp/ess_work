<?php

/**
 * 
 */
class TrainingParameter extends Model {

    var $name = 'TrainingParameter';

    /**
     * Model use Table
     *
     * @var string
     * @access public
     */
    var $useTable = "MST_TRAINING_PARAMETERS";

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
