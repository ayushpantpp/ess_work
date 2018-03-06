<?php

App::uses('AppModel', 'Model');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of KraMaster
 *
 * @author hp4420-28u
 */
class KraMasters extends AppModel {

    var $useDbConfig = 'default';
    var $name = 'kra_masters';
    var $primaryKey = 'id';
//    var $belongsTo = array(
//        'KpiMasters' => array(
//            'className' => 'KpiMasters',
//            'foreignKey' => 'kra_id',
//        ),
//        'KraMapEmp' => array(
//            'className' => 'KraMapEmp',
//            'foreignKey' => 'kramasters_id',
//        ),
//    );

}
