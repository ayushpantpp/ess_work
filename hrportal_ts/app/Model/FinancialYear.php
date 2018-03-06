<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of FinancialYear
 *
 * @author hp4420-28u
 */
App::uses('AppModel', 'Model');
class FinancialYear extends AppModel {
    public  $useDbConfig = 'default';
    public  $name = 'FinancialYear'; 
    public  $useTable = 'financial_year';
    public  $primaryKey = 'id';
}
