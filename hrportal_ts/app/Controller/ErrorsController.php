<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ErrorsController
 *
 * @author hp4420-28u
 */
class ErrorsController extends AppController {
    public $name = 'Errors';

    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('error404');
        //$this->Auth->allow('error404');
    }

    public function beforeRender() {
    
    $this->layout = 'employee-new';
    
}
    public function error404() {
       $this->layout = 'employee-new';
        $this->layout = 'default';
    }
    public function error400() {
       $this->layout = 'employee-new';
        $this->layout = 'default';
    }
    public function error500() {
        $this->layout = 'employee-new';
        $this->layout = 'default';
    }
    
}