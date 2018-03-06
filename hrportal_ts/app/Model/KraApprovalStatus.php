<?php
App::uses('AppModel', 'Model');
class KraApprovalStatus extends AppModel{
    public  $useDbConfig = 'default';
    public  $name = 'KraApprovalStatus'; 
    public  $useTable = 'kra_approval_status';
    public  $primaryKey = 'id';
   
}