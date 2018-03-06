<?php

App::uses('AppModel', 'Model');

class ImportantDocCategory extends AppModel {

    public $useDbConfig = 'default';
    public $name = 'ImportantDocCategory';
    public $useTable = 'important_doc_category';
    public $primaryKey = 'id';

}
