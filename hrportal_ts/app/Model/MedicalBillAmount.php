<?php
class MedicalBillAmount extends AppModel {
	//var $useDbConfig = 'hcm';
    var $name = 'MedicalBillAmount'; 
    public  $useTable ='medical_bill_amount'; 
    public  $hasMany = array(
        'MedicalWorkflow' => array(
            'className' => 'MedicalWorkflow',
            'foreignKey' => 'medical_bill_amount_id'
        ));
   }