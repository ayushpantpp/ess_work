<?php

App::uses('AppModel', 'Model');

class EmpAddress extends AppModel {

    public $useDbConfig = 'default';
    public $name = 'EmpAddress';
    public $useTable = 'emp_address';
    public $primaryKey = 'id';

}
