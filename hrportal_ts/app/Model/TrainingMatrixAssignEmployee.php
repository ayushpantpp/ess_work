<?php

/**
 * 
 */
class TrainingMatrixAssignEmployee extends Model {

    /**
     * Model name
     *
     * @var string
     * @access public
     */
    var $name = 'TrainingMatrixAssignEmployee';

    /**
     * Model use Table
     *
     * @var string
     * @access public
     */
    var $useTable = "training_matrix_assign_employee";

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
