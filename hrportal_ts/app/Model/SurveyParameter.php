<?php
App::uses('AppModel', 'Model');
class SurveyParameter extends AppModel {
    public  $useDbConfig = 'default';
    public  $name = 'SurveyParameter'; 
    public  $useTable = 'survey_parameter';
    public $primaryKey = 'id';
    
    
    public $hasMany = array(
        'SurveyQuestion' => array(
            'className' => 'SurveyQuestion',
            'foreignKey' => 'parameter_id'
        )
    );
}
?>
