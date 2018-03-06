<?php

class CandidateDetail extends AppModel {

    public $useDbConfig = 'default';
    public $name = 'CandidateDetail';
    public $useTable = 'org$hcm$cndt$prf';
    public $primaryKey = 'id';

      public $hasMany = array(
                                'Candidateskills' => array(
                                    'className' => 'Candidateskills',
                                    'foreignKey' => 'cndt_code',
                                    'bindingKey' => 'id',
                                    
                                )
            );
       /*public  $belongsTo = array(
                            'CandidateDocumentsDetail' => array(
                                'className'  => 'CandidateDocumentsDetail',
                                'foreignKey' => 'candidate_id',
                                'bindingKey' => 'id'
                            )
                        );*/

}

?>