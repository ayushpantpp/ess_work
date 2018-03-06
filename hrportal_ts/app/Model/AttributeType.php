<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AttributeType
 *
 * @author Administrator
 */
class AttributeType extends AppModel{
  public  $useDbConfig = 'default';
  public  $name = 'AttributeType'; 
  public  $useTable = 'attribute_type';
  public  $primaryKey = 'id';
  public $hasMany   = array(
        'Options' => array(
            'className' => 'Options',
            'foreignKey' => 'attribute_type_id',
            )
    );
}
