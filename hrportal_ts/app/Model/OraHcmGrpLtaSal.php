<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of OraHcmGrpLtaSal
 *
 * @author hp4420-28u
 */
App::uses('AppModel', 'Model');
class OraHcmGrpLtaSal extends AppModel {
   var $useDbConfig = 'ora';
     //public  $name = 'MyProfile'; 
  public  $useTable = 'HCM$GRP$LTA$SAL'; 
   
}
