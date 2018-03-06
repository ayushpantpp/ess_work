<?php
/*
 * Property of Eastern Software Systems Pvt. Ltd.
 * Should be modified on by a Cake PHP Professional
 */

 class SessionMaster extends AppModel {
    
	/**
     * Model name
     *
     * @var string
     * @access public
     */
	var $name = 'SessionMaster';
	
	
	
	/**
     * Model use Table
     *
     * @var string
     * @access public
     */
	var $useTable='mst_session_masters';
	
	/**
     * Model primary key
     *
     * @var string
     * @access public
     */
    var $primaryKey= 'id';
	
	/*
	**
	**Server Side Validation
	**
	*/
	var $validate = array(
		
		'vc_course_id' => array(
				'required' => array(
					'rule' => 'notEmpty',
					'required' =>true,
					'message' => 'Please select training'
					
				)
				
		),
		'vc_session' => array(
			'required' => array(
				'rule' => 'notEmpty',
				'required'=>true,
				'message' => 'Please fill session'
			),
		'unique' =>array(
				'rule' => 'isUnique',
				'required' =>true,
				'message' => 'Session already exists'
				
				)
		)
	);
	}
