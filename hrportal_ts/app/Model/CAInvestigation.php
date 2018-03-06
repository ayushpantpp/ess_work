<?php
App::uses('AppModel', 'Model');
class CAInvestigation extends AppModel {
    public  $useDbConfig = 'default';
    public  $name = 'CAInvestigation'; 
    public  $useTable = 'ca_investigation';
    
    public  $hasMany = array(
                            'CAComplianDoc' => array(
                                'className'  => 'CAComplianDoc',
                                'foreignKey' => 'complian_invest_id',
                                'bindingKey' => 'id',
                                'conditions'=>array('CAComplianDoc.status'=>'0')
                            )
                        ); 
}
?>
