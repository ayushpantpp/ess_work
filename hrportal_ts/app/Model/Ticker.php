<?php
App::uses('AppModel', 'Model');
class Ticker extends AppModel {

    var $useDbConfig = 'default';
    var $name = 'Ticker';
    var $primaryKey = 'id';
    var $useTable = 'ticker';
    
}