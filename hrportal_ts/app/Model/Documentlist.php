<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

App::uses('AppModel', 'Model');

/**
 * CakePHP mst_org
 * @author ravi
 */
class Documentlist extends AppModel {
     public  $useDbConfig = 'default';
     public  $name = 'Documentlists'; 
     public  $useTable = 'document_cat_lists';
     public  $primaryKey = 'id';
    
}