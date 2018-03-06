<?php

/**
 * 
 * 	User login Detail Model
 */
class TrainingMstMatrix extends Model {

    /**
     * Model name
     *
     * @var string
     * @access public
     */
    var $name = 'TrainingMstMatrix';

    /**
     * Model use Table
     *
     * @var string
     * @access public
     */
    var $useTable = "mst_training_matrix";

    /**
     * Model primary key
     *
     * @var string
     * @access public
     */
    var $primaryKey = 'id';
    public $hasMany = array(
        'TrainingDtMatrix' => array(
            'className' => 'TrainingDtMatrix',
            'foreignKey' => 'mst_training_matrix_id'
        )
    );

}
