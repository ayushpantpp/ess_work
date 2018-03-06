<?php

/*
 * Property of Eastern Software Systems Pvt. Ltd.
 * Should be modified on by a Cake PHP Professional
 */

/**
 * ******************************************************************************
 * Description of accounts.php
 * ******************************************************************************
 * file (accounts.php) version: 0.1.0
 * file description: Cake PHP model file for manupilating accounts table data
 * file change log:
 *                          created by Anshuk Kumar <anshuk-kumar at essindia.co.in>
 *                          Jun 17, 2011 4:56:21 PM Created model.
 *                          changed by <user>
 *                          <date> <time> <changed-action-name> <change-description> 
 * 
 * ******************************************************************************
 * project: EssPortal
 * project version: 0.1.0
 * @author Anshuk Kumar <anshuk-kumar at essindia.co.in>
 * @client company: Eastern Software Systems Pvt. Ltd.
 * @date created: Jun 17, 2011 4:56:21 PM
 * @date last modified: Jun 17, 2011 4:56:21 PM
 * ****************************************************************************** 
 */
class Bugs extends AppModel {

    var $useDbConfig = 'sqltest';
    var $name = 'Bugs';
    var $useTable = 'bugs';
    var $primaryKey = 'id';

}