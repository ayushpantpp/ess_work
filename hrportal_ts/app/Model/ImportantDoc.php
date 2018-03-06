<?php

App::uses('AppModel', 'Model');

class ImportantDoc extends AppModel {

    public $useDbConfig = 'default';
    public $name = 'ImportantDoc';
    public $useTable = 'important_doc';
    public $primaryKey = 'id';
    var $belongsTo = array(
        'ImportantDocCategory' => array(
            'className' => 'ImportantDocCategory',
            'foreignKey' => 'important_doc_category_id',
            
        ),
        
    );

}
