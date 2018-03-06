<?php
App::uses('AppModel', 'Model');
class MstPromotionType extends AppModel{
    public  $useDbConfig = 'default';
    public  $name = 'MstPromotionType'; 
    public  $useTable = 'mst_promotion_type';
    public  $primaryKey = 'id';
   
}