<?php

App::uses('AppModel', 'Model');

class TravelWfLvl extends AppModel {

    public $useDbConfig = 'default';
    public $name = 'TravelWfLvl';
    public $useTable = 'travel_workflow';
    public $primaryKey = 'id';
    
    
    
    
    public function checkstatus($docid=NULL, $voucherno=NULL)
    {
         $details = $this->find('count', array('conditions' => array('TravelWfLvl.doc_id'=>$docid,
             'TravelWfLvl.voucher_id'=>$voucherno,'TravelWfLvl.fw_date IS NOT NULL')));
         return $details;
    }
    
    

}
