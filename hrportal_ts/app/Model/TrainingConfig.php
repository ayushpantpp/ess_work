<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TrainingConfig
 *
 * @author Administrator
 */
class TrainingConfig extends AppModel {
     public  $useDbConfig = 'default';
     public  $name = 'TrainingConfig'; 
     public  $useTable = 'training_config';
     public  $primaryKey = 'id';
}
