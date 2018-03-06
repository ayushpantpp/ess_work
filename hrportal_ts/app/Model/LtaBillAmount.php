<?php
class LtaBillAmount extends AppModel {
	//var $useDbConfig = 'hcm';
    var $name = 'LtaBillAmount'; 
    public  $useTable ='lta_bill_amount'; 
    public $hasMany = array(
        'LtaWorkflow' => array(
            'className' => 'LtaWorkflow',
            'foreignKey' => 'lta_bill_amount_id'
    ));

}