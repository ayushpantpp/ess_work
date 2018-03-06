<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

App::uses('AppModel', 'Model');

/**
 * CakePHP MstLogo
 * @author ravi
 */
class MstMda extends AppModel {
    public  $useDbConfig = 'default';
    public  $name = 'MstMda'; 
    public  $useTable = 'mda_details';
    public  $primaryKey = 'id';
}
