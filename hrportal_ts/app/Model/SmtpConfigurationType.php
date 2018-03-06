<?php
App::uses('AppModel', 'Model');
class SmtpConfigurationType extends AppModel{
    public  $useDbConfig = 'default';
    public  $name = 'SmtpConfigurationType'; 
    public  $useTable = 'smtp_configuration_type';
    public  $primaryKey = 'id';   
}