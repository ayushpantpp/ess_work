<?php
App::uses('AppModel', 'Model');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SectDtl
 *
 * @author hp4420-28u
 */
class SectDtl extends AppModel   {
    public  $useDbConfig = 'default';
    public  $name = 'SectDtl'; 
    public  $useTable = 'sect_dtl';
    public  $primaryKey = 'id';
}