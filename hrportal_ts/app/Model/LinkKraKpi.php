<?php
App::uses('AppModel', 'Model');
class LinkKraKpi extends AppModel{
    public  $useDbConfig = 'default';
    public  $name = 'LinkKraKpi'; 
    public  $useTable = 'link_kra_kpi';
    public  $primaryKey = 'id'; 
}