<?php
class MstEmpExpVoucher extends AppModel{
	
    public  $useDbConfig = 'default';
    public  $name = 'MstEmpExpVoucher'; 
    public  $useTable = 'mst_emp_exp_voucher';
    public  $primaryKey = 'voucher_id';
	
	public  $hasMany = array(
        'ConveyencExpenseDetail' => array(
            'className' => 'ConveyencExpenseDetail',
            'foreignKey' => 'voucher_id'
        ),
        'ConveyenceWorkflow' => array(
            'className' => 'ConveyenceWorkflow',
            'foreignKey' => 'voucher_id'
        )
    );
 	
}
?>
