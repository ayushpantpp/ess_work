<?php

App::uses('AppModel', 'Model');

class Resignation extends AppModel {

    public $useDbConfig = 'default';
    public $name = 'Resignation';
    public $useTable = 'resignation';
    public $primaryKey = 'id';

}
