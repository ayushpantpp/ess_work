<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

App::uses('AppModel', 'Model');

/**
 * CakePHP MstRequest
 * @author ravi
 */
class MstJobcode extends AppModel {
    public  $useDbConfig = 'default';
    public  $name = 'MstJobcode'; 
    public  $useTable = 'mst_jobcode';
    
    public  $belongsTo = array(
                            'Departments' => array(
                                'className'  => 'Departments',
                                'foreignKey' => 'dept_id',
                                'bindingKey' => 'id'
                            )
                        );
    
}
