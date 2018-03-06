<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

App::uses('AppModel', 'Model');

/**
 * CakePHP MailerMaster
 * @author ravi
 */
class MailerMaster extends AppModel {

     public  $useDbConfig = 'default';
     public  $name = 'MailerMaster'; 
     public  $useTable = 'mailer_master';
     public  $primaryKey = 'id';
   
}

