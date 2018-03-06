<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of LtaLeave
 *
 * @author hp4420-28u
 */
App::uses('AppModel', 'Model');
class LtaLeave extends AppModel {
public  $useDbConfig = 'default';
public  $name = 'LtaLeave'; 
public  $useTable = 'lta_leave';
public  $primaryKey = 'id';   
}
