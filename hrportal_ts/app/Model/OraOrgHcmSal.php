<?php
App::uses('AppModel', 'Model');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of OraOrgHcmSal
 *
 * @author hp4420-28u
 */
class OraOrgHcmSal extends AppModel{
   var $useDbConfig = 'ora';
     //public  $name = 'MyProfile'; 
    public  $useTable = 'ORG$HCM$SALARY';
}
