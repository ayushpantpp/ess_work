<?php

App::uses('AppModel', 'Model');
class CandMaster extends AppModel {

    var $useDbConfig = 'default';
    var $name = 'CandMaster';
	var $useTable = 'org$hcm$cndt$prf';
    var $primaryKey = 'id';
 
}