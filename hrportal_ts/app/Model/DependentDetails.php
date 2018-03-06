<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DependentDetails
 *
 * @author hp4420-28u
 */
App::uses('AppModel', 'Model');
class DependentDetails extends AppModel {
    
    public  $useDbConfig = 'default';
    public  $name = 'DependentDetails'; 
    public  $useTable = 'dependent_details';
    public  $primaryKey = 'id';
    var $belongsTo = array(
        'MyProfile' => array(
            'className' => 'MyProfile',
			'foreignKey'=>'myprofile_id'
            )
        );
}
