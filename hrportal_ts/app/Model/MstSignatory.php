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
class MstSignatory extends AppModel {
    public  $useDbConfig = 'default';
    public  $name = 'MstSignatory'; 
    public  $useTable = 'mst_signatory';
    public  $primaryKey = 'id';
    
    
    
}
