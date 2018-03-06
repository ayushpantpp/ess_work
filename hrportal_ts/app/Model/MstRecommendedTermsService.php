<?php
App::uses('AppModel', 'Model');
class MstRecommendedTermsService extends AppModel{
    public  $useDbConfig = 'default';
    public  $name = 'MstRecommendedTermsService'; 
    public  $useTable = 'mst_recommended_terms_service';
    public  $primaryKey = 'id';
   
}