<?php
App::uses('AppModel', 'Model');
class Appraisalslabcategories extends AppModel {

    var $useDbConfig = 'default';
    var $name = 'Appraisalslabcategories';
    var $primaryKey = 'id';
    var $useTable = 'app_slab_categories';
    var $displayField = 'description';

}