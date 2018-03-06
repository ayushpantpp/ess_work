<?php
App::uses('AppModel', 'Model');
class RequestNotificationType extends AppModel{
    public  $useDbConfig = 'default';
    public  $name = 'RequestNotificationType'; 
    public  $useTable = 'request_notification_type';
    public  $primaryKey = 'id';
   
}