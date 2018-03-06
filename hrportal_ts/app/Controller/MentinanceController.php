<?php
class MentinanceController extends AppController {
     
	  var $helpers = array('Html', 'Js','Form', 'Session','Userdetail','Leave', 'Common');
	 function beforeFilter() {
	 
       
        parent::beforeFilter();
        $this->Auth->allow();
	}
	
	function index(){
	
	
	}

   
}
