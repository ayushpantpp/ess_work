<?php

/*
 * Property of Eastern Software Systems Pvt. Ltd.
 * Should be modified on by a Cake PHP Professional
 */

/**
 * ******************************************************************************
 * Description of mst_timesheet.php
 * ******************************************************************************
 * file (mst_timesheet.php) version: 0.1.0
 * file description: Cake PHP model file for manupilating mst_timesheet table data
 * file change log:
 *                          created by Saurabh agarwal <saurabh.agarwal at essindia.co.in>
 *                          Aug 23, 2013 4:56:21 PM Created model.
 *                          changed by <user>
 *                          <date> <time> <changed-action-name> <change-description> 
 * 
 * ******************************************************************************
 * project: EssPortal
 * project version: 0.1.0
 * @author Saurabh agarwal<saurabh.agarwal at essindia.co.in>
 * @client company: Eastern Software Systems Pvt. Ltd.
 * @date created:  Aug 23, 2013  4:56:21 PM
 * @date last modified:  Aug 23, 2013  4:56:21 PM
 * ****************************************************************************** 
 */

class MstTimesheet extends AppModel 
{
     var $useDbConfig = 'default';
     var $name='MstTimesheet';
     var $useTable='mst_timesheet';
	 var $primaryKey='s_no';
	 var $hasMany = array(
            'DtTimesheet' => array(
            'className' => 'DtTimesheet',
            'foregin_key'=>'DtTimesheet.s_no',
            'order' => 'DtTimesheet.dt_wk_date asc'
        )
    );
}
