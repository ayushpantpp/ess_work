<?php
class SalaryProcessingAddition extends AppModel {
	//var $useDbConfig = 'hcm';
    var $name = 'SalaryProcessingAddition'; 
    public  $useTable ='employee_sal_proc_sal'; 
 	var $belongsTo = array(
        'OptionAttribute' => array(
            'className' => 'OptionAttribute',
            'foreignKey' => 'sal_id',
         
        ),
       
    );
}