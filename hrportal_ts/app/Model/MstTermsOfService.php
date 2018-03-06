<?php
App::uses('AppModel', 'Model');
class MstTermsOfService extends AppModel{
    public  $useDbConfig = 'default';
    public  $name = 'MstTermsOfService'; 
    public  $useTable = 'mst_terms_of_service';
    public  $primaryKey = 'id';
   
}