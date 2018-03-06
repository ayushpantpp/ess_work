<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of LeaveCOnfiguration
 *
 * @author Administrator
 */
class LeaveConfiguration extends AppModel{
    //put your code here
     public  $useDbConfig = 'default';
    public  $name = 'LeaveConfiguration'; 
    public  $useTable = 'leave_configuration';
    public  $primaryKey = 'id';
}
