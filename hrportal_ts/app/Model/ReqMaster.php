<?php

App::uses('AppModel', 'Model');
class ReqMaster extends AppModel {

    var $useDbConfig = 'default';
    var $name = 'ReqMaster';
	var $useTable = 'req_master_details';
    var $primaryKey = 'id';
 
}