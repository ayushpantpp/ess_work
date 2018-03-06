<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of IconUser
 *
 * @author hp4420-28u
 */
App::uses('AppModel', 'Model');
class IconUser extends AppModel {
   var $useDbConfig = 'default';
    var $name = 'iconUser';
    var $primaryKey = 'id';
    var $useTable = 'icon_user';
    var $belongsTo = array(
        'Icon' => array(
            'className' => 'Icon',
            'foreignKey' => 'icon_id',
            
        ),
        'MyProfile' => array(
            'className' => 'MyProfile',
            'foreignKey' => 'myprofile_id',
           
        ),
        
    );
}
