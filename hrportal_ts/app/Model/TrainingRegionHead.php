<?php

class TrainingRegionHead extends Model {

   
    var $name = 'TrainingRegionHead';

   
    /**
     * Model use Table
     *
     * @var string
     * @access public
     */
    var $useTable = "mst_training_region_head";
    
    /**
     * Model primary key
     *
     * @var string
     * @access public
     */
    var $primaryKey= 'nu_head_id';
	
	var $validate=array(
		'vc_region_head' => array(
			'required' => array(
				'rule' => 'isUnique',
				'required' =>true,
				'message' => 'Regional Head already exists.'
			)
		)
	);
   
}