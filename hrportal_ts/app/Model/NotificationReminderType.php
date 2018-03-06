<?php
App::uses('AppModel', 'Model');
class NotificationReminderType extends AppModel{
    public  $useDbConfig = 'default';
    public  $name = 'NotificationReminderType'; 
    public  $useTable = 'notification_reminder_type';
    public  $primaryKey = 'id';   
}