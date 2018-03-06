<?php
App::uses('AppModel', 'Model');
/**
 * Project Model
 *
 */
class GeneralOracle extends AppModel {
/**
 * Display field
 *
 * @var string
 */
    var $useDbConfig = 'ora';
    public  $useTable = false;
}
