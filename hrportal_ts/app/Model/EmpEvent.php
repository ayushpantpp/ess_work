<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Icon
 *
 * @author hp4420-28u
 */
App::uses('AppModel', 'Model');
class EmpEvent extends AppModel {
    var $useDbConfig = 'default';
    var $name = 'EmpEvent';
    var $primaryKey = 'id';
    var $useTable = 'emp_events';
    
}
