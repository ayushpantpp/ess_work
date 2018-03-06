<?php
App::uses('AppModel', 'Model');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of EmpInvest
 *
 * @author hp4420-28u
 */
class EmpInvest extends AppModel{
    public  $useDbConfig = 'default';
    public  $name = 'EmpInvest'; 
    public  $useTable = 'emp_invest';
    public  $primaryKey = 'id';
}
