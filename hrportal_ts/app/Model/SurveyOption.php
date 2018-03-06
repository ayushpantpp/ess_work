<?php
App::uses('AppModel', 'Model');
class SurveyOption extends AppModel {
    public  $useDbConfig = 'default';
    public  $name = 'SurveyOption'; 
    public  $useTable = 'survey_options';
}
?>
