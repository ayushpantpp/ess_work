<?php
App::uses('AppModel', 'Model');
class SyncStatus extends AppModel {

    var $useDbConfig = 'default';
    var $name = 'SyncStatus';
    var $primaryKey = 'id';
    var $useTable = 'sync_status';
          
}