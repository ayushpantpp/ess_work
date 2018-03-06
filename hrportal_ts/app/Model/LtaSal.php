<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of LtaSal
 *
 * @author hp4420-28u
 */
App::uses('AppModel', 'Model');
class LtaSal extends AppModel {
public  $useDbConfig = 'default';
public  $name = 'LtaSal'; 
public  $useTable = 'lta_sal';
public  $primaryKey = 'id';   
}
