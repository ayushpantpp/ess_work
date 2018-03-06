<?php

class TrainingBudget extends Model {

    
    var $name = 'TrainingBudgets';

    
    /**
     * Model use Table
     *
     * @var string
     * @access public
     */
    var $useTable = "mst_training_budget";
    
    /**
     * Model primary key
     *
     * @var string
     * @access public
     */
    var $primaryKey= 'id';
   
}