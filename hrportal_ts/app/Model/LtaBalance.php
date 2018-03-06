<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of LtaBalance
 *
 * @author hp4420-28u
 */
App::uses('AppModel', 'Model');

class LtaBalance extends AppModel {
public  $useDbConfig = 'default';
public  $name = 'LtaBalance'; 
public  $useTable = 'lta_balance';
public  $primaryKey = 'id';     
}
