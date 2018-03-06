<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <title>Ess India Portal</title>
        <link REL="SHORTCUT ICON" HREF="<?php echo $this->webroot . ('img/favicon.png'); ?>">
            <?php
            echo $this->Html->css('acl/base.css');
            echo $this->Html->css('acl/style.css');
            echo $this->Html->css('acl/start/jquery-ui-1.8.13.custom.css');
            echo $this->Html->css('acl/essbilling.css'); 
            echo $this->Html->script('acl/jquery-1.5.1.min.js'); 
            echo $this->Html->script('acl/jquery-ui-1.8.13.custom.min.js'); 
            echo $this->Html->script('acl/jquery.dropdownPlain.js'); 
            echo $this->Html->script('acl/jquery.jstree.js'); 
            
            echo $this->Html->css('acl/default/style.css'); 
            
            echo $this->Html->script('acl/custom.js'); 
            echo $this->Html->css('acl/custom.css'); 
            echo $this->Html->css('acl/bread_crumb.css');
            echo $this->Html->css('acl/vtip.css');
            /* ====== Breadcrumb ================== */
            echo $this->Html->script('acl/jquery.jBreadCrumb.1.1.js');

            /* ====== Qtip ================== */
            echo $this->Html->script('acl/jquery.qtip-1.0.0-rc3-dm-min.js');
            echo $this->Html->script('acl/jquery.autocomplete.js');
            echo $this->Html->script('acl/download.jQuery.js');
            
            echo $this->Html->css('acl/start/jquery-ui-1.8.13.custom.css');
            echo $this->Html->css('acl/jquery.lightbox-0.5.css');
            ?>
            <?php $flash = $this->Session->flash(); ?>
            <?php if ($flash != '') { ?>
                <script>
                    //javascript:window.history.forward(-1);
                    jQuery(document).ready(function () {
                        var xyz = '<?php echo $flash; ?>';
                        jQuery('.new-messsages').html('<div style="float:left" id="response-message">' + jQuery(xyz).text() + '</div>');
                        if (jQuery(xyz).hasClass("flash_error"))
                            jQuery('#response-message').errorStyle();
                        else
                            jQuery('#response-message').highlightStyle();
                        jQuery('#response-message').show().delay(10000).fadeOut(900);
                    });
                </script>
            <?php } ?>
            <script>

                function createMsg(msg, type) {
                    jQuery('.new-messsages').html('<div style="float:left" id="response-message">' + msg + '</div>');
                    if (type == 'error') {
                        jQuery('#response-message').errorStyle();
                    } else if (type == 'success') {
                        jQuery('#response-message').highlightStyle();
                    } else {
                        jQuery('#response-message').highlightStyle();
                    }
                    jQuery('#response-message').show().delay(10000).fadeOut(900);

                }

                $(document).ready(function () {
                    $("#cl").click(function () {
                        $("#overlay").show();
                    })
                });

            </script>
            <style>
                #overlay {
                    background:transparent;
                    filter:progid:DXImageTransform.Microsoft.gradient(startColorstr=#90000000,endColorstr=#90000000); 
                    zoom: 1;
                    background-color: rgba(0, 0, 0, 0.6);
                    z-index: 999;
                    position: fixed;
                    left: 0;
                    top: 0;
                    width: 100%;
                    height: 100%;
                    display: none;
                    margin:0 auto;
                    padding-top:300px;   
                }	

            </style>
    </head>
    <body>
        <div id="overlay" align="center" style="font-size:12px; color: #FFFFFF;">
            <?php echo $this->Html->image("img/loadingbar.gif"); ?><br/><b>Please Wait....</b> 
        </div>
        <div class="body-bg">
            <div class="wrpper">
                <!-- Header Starts -->
                <div class="new-messsages"  style="margin-top:10px; margin-left:390px; color: crimson;"></div>
                <div class="header">
                    <div class="login-global" style="color:#DDDDDD;">
                        <ul class="site-m-ul">
                            <li><b>Hello <?php
                                $auth = $this->Session->read('Auth');
                                echo ucwords(strtolower($auth['User']['user_name']));
                                ?></b></li>
                            <li>|</li>
                            <!--<li><b><a href="#">Account Settings</a></b></li>
                            <li>|</li>----->
                            <li><b><a href="<?php echo $this->webroot . 'users/logout'; ?>">Logout</a></b></li>
                        </ul>
                    </div>
                    <div class="logo"><a href="#"><img src="<?php echo $this->webroot; ?>img/ess-logo.png" width="260" height="40" alt="ESS India" border="0"/></a></div>

                    <div class="nevigation">
                        <ul class="dropdown">
                            <!--<li><a href="<?php echo $this->webroot . "acls/application"; ?>">Application, Roles, Permissions</a></li>
                            <li><a href="<?php echo $this->webroot . "acls/assignrole"; ?>">Assign Role</a></li>
                            <li><a href="<?php echo $this->webroot . "acls/assignrolereport"; ?>">Assign Role Report</a></li>  --> 
                            <li><a href="<?php echo $this->webroot . "Configurations/accesscontrol"; ?>">Access Control</a></li>
                            <li><a >Masters</a>
                                <ul class="sub_menu">
                                    <li><a href="<?php echo $this->webroot; ?>companies/index">Company Master</a></li>
                                    <li><a href="<?php echo $this->webroot; ?>Companies/index_catagory">Catagory Master</a></li>
                                     <li><a href="<?php echo $this->webroot; ?>Companies/index_location">Location Master</a></li>
                                    <li><a href="<?php echo $this->webroot; ?>MstTravelVouchers/index">Travel Master</a></li>

									<li><a href="<?php echo $this->webroot; ?>KraMasters/index">PMS Master</a></li>

                                      <li><a href="<?php echo $this->webroot; ?>TravelModes/index_vehicle">Vehicle Master</a></li>

                                    <li><a href="<?php echo $this->webroot; ?>Departments/index">Department Master</a></li>
                                    <li><a href="<?php echo $this->webroot; ?>Designations/index">Designation Master</a></li>
                                   
                                    <li><a href="<?php echo $this->webroot; ?>MstWheelers/index">Wheeler Price Master</a></li>
                                <!--     <li><a href="<?php echo $this->webroot; ?>KraMasters/addKraType">KRA Type</a></li>
                                    <li><a href="<?php echo $this->webroot; ?>KpiMasters/addKpiType">KPI Type</a></li>
                                    <li><a href="<?php echo $this->webroot; ?>KraMasters/linkKraKpi">Link KRA & KPI</a></li>
                                    <li><a href="<?php echo $this->webroot; ?>Competency/addCompetencyType">Competency Type</a></li>
                                    <li><a href="<?php echo $this->webroot; ?>SetupMasters/addReqNotificationType">Request Notification Type</a></li>
                                    <li><a href="<?php echo $this->webroot; ?>SetupMasters/addNotificationReminderType">Notification Reminder Type</a></li>
                                    <li><a href="<?php echo $this->webroot; ?>SetupMasters/addWeightageCalculationType">Weightage Calculation Type</a></li>
                                    <li><a href="<?php echo $this->webroot; ?>SetupMasters/addSmtpConfigurationType">Smtp Configuration Type</a></li>    -->
                                    <li><a href="<?php echo $this->webroot; ?>MailerMaster/Index">Smtp Configuration Type</a></li>   
                           <li><a href="<?php echo $this->webroot; ?>TrainingMasters/configuration">Training Flash Configuration Type</a></li>             
                                </ul>
                            </li> 
                            <li><a >Core</a>
                                <ul class="sub_menu">
                                    <li><a href="<?php echo $this->webroot; ?>workflows/applications">Application Master</a></li>
                                    <li><a href="<?php echo $this->webroot; ?>wfmstappmaplvls">Work flow Application Level Master</a></li>
                                    <li><a href="<?php echo $this->webroot; ?>wf_dt_app_map_lvls">Work flow Application Level Department Master</a></li>
                                </ul>
                            </li>
                            <li><a >Import Data</a>
                                <ul class="sub_menu">						
                                    <li><a href="<?php echo $this->webroot; ?>Employees/index">Create User</a></li>
                                    <li><a href="<?php echo $this->webroot; ?>Employees/lists">View User</a></li>
                                    <li><a href="<?php echo $this->webroot; ?>Imports/index">One Time Import Tabs</a></li>
                                </ul>
                            </li>
                            <li><a >Leaves</a>
                                <ul class="sub_menu">
                                 <li><a href="<?php echo $this->webroot; ?>LeaveMaster/index">Leave Master</a></li>   						
                                    <li><a href="<?php echo $this->webroot; ?>Holidays/index">Holidays list</a></li>
                                    <li><a href="<?php echo $this->webroot; ?>week_holidays/index">Week offs</a></li>
                                </ul>
                            </li>
                            <li><a>Labels</a>
                                <ul class="sub_menu">
                                    <li><a href="<?php echo $this->webroot; ?>Labels/labelPage">Label Page </a></li>
                                    <li><a href="<?php echo $this->webroot; ?>Labels/label_block">Label Block </a></li>
                                    <li><a href="<?php echo $this->webroot; ?>Labels/index">Label List</a></li>								
                                </ul>
                            </li>
                            <li><a>Admin panels</a>
                                <ul class="sub_menu">
                                    <li><a href="<?php echo $this->webroot; ?>Configurations/admin_option">Enable/disable modules</a></li>
                                    <li><a href="<?php echo $this->webroot; ?>Setup/select_country">Reinstall Portal</a></li>
                                    <li><a href="<?php echo $this->webroot; ?>Configurations/important_doc_cat">Important document categories</a></li>

                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
                <!-- Header Ends -->
                <!-- Center Content Starts -->
                <div class="center-content">
                    <!-- Left Content Starts -->
                    <?php echo $content_for_layout; ?>
                    <!-- Left Ends Starts -->
                </div>
                <!-- Center Content Ends -->  
            </div>
        </div>
        <!-- Footer Starts -->
        <?php echo $this->element('footer'); ?>
        <?php echo $this->Html->script('acl/common.js'); ?>
        <?php echo $this->element('sql_dump'); ?>
        <!-- Footer Ends -->
    </body>
</html>
