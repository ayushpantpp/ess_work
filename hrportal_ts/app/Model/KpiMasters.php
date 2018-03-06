<?php

App::uses('AppModel', 'Model');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of KpiMasters
 *
 * @author hp4420-28u
 */
class KpiMasters extends AppModel {

    var $useDbConfig = 'default';
    var $name = 'kpi_masters';
    var $primaryKey = 'id';
    /*var $belongsTo = array(
        'KpiMapEmps' => array(
            'className' => 'KpiMapEmps',
            'foreignKey' => 'kpi_masters_id',
        ),
    );*/

}
