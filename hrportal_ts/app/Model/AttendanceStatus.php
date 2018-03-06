<?php
class AttendanceStatus extends AppModel{
    public  $useDbConfig = 'default';
    public  $name = 'AttendanceStatus'; 
    public  $useTable = 'attendance_with_location';
    public  $primaryKey = 'id';
 	
}
?>