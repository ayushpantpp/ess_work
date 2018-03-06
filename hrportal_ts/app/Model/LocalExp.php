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
class LocalExp extends AppModel {
public  $useDbConfig = 'default';
public  $name = 'LocalExp'; 
public  $useTable = 'local_expence';
public  $primaryKey = 'id';   
}
