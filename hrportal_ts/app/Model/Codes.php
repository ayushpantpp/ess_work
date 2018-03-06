<?php

/*
 * Property of Eastern Software Systems Pvt. Ltd.
 * Should be modified on by a Cake PHP Professional
 */

/**
 * ******************************************************************************
 * Description of codes.php
 * ******************************************************************************
 * file (codes.php) version: 0.1.0
 * file description: Cake PHP model file for manupilating codes table data
 * file change log:
 *                          created by Anshuk Kumar <anshuk-kumar at essindia.co.in>
 *                          Jun 17, 2011 4:16:09 PM Created model.
 *                          changed by <user>
 *                          <date> <time> <changed-action-name> <change-description> 
 * 
 * ******************************************************************************
 * project: EssPortal
 * project version: 0.1.0
 * @author Anshuk Kumar <anshuk-kumar at essindia.co.in>
 * @client company: Eastern Software Systems Pvt. Ltd.
 * @date created: Jun 17, 2011 4:16:09 PM
 * @date last modified: Jun 17, 2011 4:16:09 PM
 * ****************************************************************************** 
 */
class Codes extends AppModel {
    var $useDbConfig = 'sales';
    var $name = 'mst_code';
    var $primaryKey = 'vc_code';
}