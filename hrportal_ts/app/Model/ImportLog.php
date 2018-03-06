<?php
App::uses('AppModel', 'Model');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of EmpEdu
 *
 * @author hp4420-28u
 */
class ImportLog extends AppModel
{
    public $useDbConfig = 'default';
    public $name = 'ImportLog';
    public $useTable = 'import_log';
    public $primaryKey = 'id';

}
