<?php

App::uses('AppModel', 'Model');

class EmpDocuments extends AppModel {

    public $useDbConfig = 'default';
    public $name = 'EmpDocuments';
    public $useTable = 'emp_documents';
    public $primaryKey = 'id';

}
