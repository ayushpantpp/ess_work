<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of LtaGroup
 *
 * @author hp4420-28u
 */
App::uses('AppModel', 'Model');
class LtaGroup extends AppModel {
public  $useDbConfig = 'default';
public  $name = 'LtaGroup'; 
public  $useTable = 'lta_group';
public  $primaryKey = 'id';   
}
