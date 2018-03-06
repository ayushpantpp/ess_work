<?php
App::uses('AppModel', 'Model');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of KraSlab
 *
 * @author hp4420-28u
 */
class KraSlab extends AppModel{
    var $name = 'KraSlab';
    var $primaryKey = 'id';
    var $useTable = 'kra_slabs';
    var $belongsTo = array(
        
        'Department' => array(
            'className' => 'Departments',
            'foreignKey' => 'department_id',
           
        ),
         'Designation' => array(
            'className' => 'Designation',
            'foreignKey' => 'designation_id',
           
        )
        
    );
}
