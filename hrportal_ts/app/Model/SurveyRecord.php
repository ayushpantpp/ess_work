<?php
App::uses('AppModel', 'Model');
class SurveyRecord extends AppModel {
    public  $useDbConfig = 'default';
    public  $name = 'SurveyRecord'; 
    public  $useTable = 'survey_record';
}
?>
