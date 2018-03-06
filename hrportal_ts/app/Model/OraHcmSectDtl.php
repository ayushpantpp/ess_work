<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of OraHCMITSECTDTL
 *
 * @author hp4420-28u
 */
App::uses('AppModel', 'Model');
class OraHcmSectDtl extends AppModel {
       var $useDbConfig = 'ora';
     //public  $name = 'MyProfile'; 
      public  $useTable = 'HCM$IT$SECT$DTL';
   //put your code here
}
