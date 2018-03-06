<?php
class MstEmpLeave extends AppModel{
    public  $useDbConfig = 'default';
    public  $name = 'MstEmpLeave'; 
    public  $useTable = 'mst_emp_leaves';
    public  $primaryKey = 'leave_id';
 	
    public  $hasMany = array(
        'LeaveDetail' => array(
            'className' => 'LeaveDetail',
            'foreignKey' => 'leave_id'
        ),
        'LeaveWorkflow' => array(
            'className' => 'LeaveWorkflow',
            'foreignKey' => 'leave_id'
        )
    );    
}
?>
