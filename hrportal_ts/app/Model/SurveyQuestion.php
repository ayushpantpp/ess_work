<?php
App::uses('AppModel', 'Model');
class SurveyQuestion extends AppModel {
    public  $useDbConfig = 'default';
    public  $name = 'SurveyQuestion'; 
    public  $useTable = 'survey_question';
    public $primaryKey = 'id';
}
?>
