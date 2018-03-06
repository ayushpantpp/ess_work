<?php
App::uses('AppController', 'Controller');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CourseMastersController
 *
 * @author hp4420-28u
 */
class CourseMastersController extends AppController{
   
    var $name = 'CourseMasters';
    var $uses = array('CourseMaster', 'CourseMasterDetail', 'MyProfile');
    var $components = array('Session', 'RequestHandler', 'Email', 'TrainingCmp');
    var $helpers = array('Html', 'Form', 'Session');
    var $layout = 'employee-new';
    
    function beforeFilter()
    {
        parent::beforeFilter();
        $this->Auth->allow();
    }
    
    
    function addCourse()
    {
        
    }
}    