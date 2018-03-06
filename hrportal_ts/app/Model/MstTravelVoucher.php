<?php
App::uses('AppModel', 'Model');
class MstTravelVoucher extends AppModel{
    public  $useDbConfig = 'default';
    public  $name = 'MstTravelVoucher'; 
    public  $useTable = 'mst_travel_voucher';
    public  $primaryKey = 'id';
}
