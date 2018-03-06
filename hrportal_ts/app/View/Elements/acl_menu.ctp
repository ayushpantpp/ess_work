
<?php $auth = $this->Session->read('Auth'); ?>          
<script>
    /* Sidebar Menu active class */
    $(function () {
        var url = window.location;
        $('#menu_section a[href="' + url + '"]').parent('li').addClass('current_section');
        $('#menu_section a').filter(function () {
            return this.href == url;
        }).parent('li').addClass('current_section act_item').parent('ul').slideDown().parent().addClass('act_item');
    });
</script>
<aside id="sidebar_main">        
    
    <div class="sidebar_main_header">
        <div class="sidebar_logo">
            <a href="<?php echo $this->webroot; ?>/users/dashboard" class="sSidebar_hide"><img src="<?php echo $this->webroot; ?>css/img/logo_main.png" alt="" height="15" width="71"/></a>
            <a href="<?php echo $this->webroot; ?>/users/dashboard" class="sSidebar_show"><img src="<?php echo $this->webroot; ?>css/img/logo_main_small.png" alt="" height="32" width="32"/></a>
        </div>
    </div>
    <?php $uservalues = $this->Session->read(); ?>
    <div class="menu_section" id="menu_section">
        <ul class="abcd">
            <?php if($uservalues['Auth']['User']['user_type'] != 'Administrator') { ?>
            <li title="Dashboard">
                <a href="<?php echo $this->webroot ?>users/dashboard">
                    <span class="menu_icon"><i class="material-icons">&#xE871;</i></span>
                    <span class="menu_title">Dashboard</span>
                </a>
            <li title="User Profile Details">
                <a href="#">
                    <span class="menu_icon"><i class="material-icons">&#xE87C;</i></span>
                    <span class="menu_title">My Profile</span>
                </a>
                <ul>
                    <li><a href="<?php echo $this->webroot ?>users/myprofile">View Profile</a> </li>                            
                    <li><a href="<?php echo $this->webroot ?>users/changepass">Change Password</a> </li>                            
                    <li><a href="<?php echo $this->webroot ?>users/setting">Settings </a> </li>
                </ul>
            </li>                
            <?php if($this->Common->get_admin_option('task_module')) { ?>
            <li>
                <a title="Task Management">
                    <span class="menu_icon"><i class="material-icons">&#xE85D;</i></span>
                    <span class="menu_title">Task Management</span>
                </a>
                <ul style="display: none;" class="">
                    <li><a href="<?php echo $this->webroot ?>tasks/index">Add Tasks</a></li>                        
                    <li><a href="<?php echo $this->webroot ?>tasks/emptask">View Tasks</a></li>                        
                    <li><a href="<?php echo $this->webroot ?>tasks/mtaskdashboard">View Tasks Manager</a></li>                        
                    <li><a href="<?php echo $this->webroot ?>tasks/taskapproval">Approve Tasks</a></li>                        

                </ul>
            </li>
            <?php } ?>
            <?php if($this->Common->get_admin_option('bom_module')) { ?>
                <li>
                    <a href="#">
                        <span class="menu_icon"><i class="material-icons">&#xE85E;</i></span>
                        <span class="menu_title">Board of Management</span>
                    </a>
                    <ul style="display: none;" class="">
                        <li><a href="<?php echo $this->webroot?>boards/department">View Department</a></li>
                        <li><a href="<?php echo $this->webroot?>boards/promotion">Promotion</a></li>
                    </ul>
                </li>
            <?php } ?>
            <?php if($this->Common->get_admin_option('doc_module')) { ?>
                <li>
                    <a href="#">
                        <span class="menu_icon"><i class="material-icons">&#xE86D;</i></span>
                        <span class="menu_title">Record Management</span>
                    </a>
                    <ul style="display: none;" class="">
                        <?php if($auth['User']['emp_code']=='1'){?>
                        <li><a href="<?php echo $this->webroot; ?>documents/">Documents Management</a></li>
                        <li><a href="<?php echo $this->webroot; ?>documents/request_view">File Request View</a></li>
                        <!--<li><a href="<?php echo $this->webroot; ?>documents/advance_search">Advance Search</a></li>-->
                        <?php }else{?>
                        <li><a href="<?php echo $this->webroot; ?>documents/request_raise">File Request Add</a></li>
                        <li><a href="<?php echo $this->webroot; ?>documents/request_view">File Request View</a></li>    
                        <?php }?>
                        
                       
                    </ul>
                </li> 
            <?php } ?>
            <?php if($this->Common->get_admin_option('mom_module')) { ?>
            <li>
                <a title="MOM Management">
                    <span class="menu_icon"><i class="material-icons">&#xE7EF;</i></span>
                    <span class="menu_title">MOM Management</span>
                </a>
                <ul style="display: none;" class="">
                    <?php if ($auth['MyProfile']['desg_code'] == 'PAR0000044') { ?>
                        <li><a href="<?php echo $this->webroot ?>moms/addMeeting">Add Meeting</a></li>
                        <li><a href="<?php echo $this->webroot ?>moms/viewMeeting">View Meeting</a></li>
                    <?php } else { ?>
                        <li><a href="<?php echo $this->webroot ?>moms/empMeeting"><?php echo $auth['MyProfile']['desg_code'];?>View Meeting</a></li>
                    <?php } ?>
                </ul>
            </li>
            <?php } ?>
            <li>
                <a title="Reports">
                    <span class="menu_icon"><i class="material-icons">&#xE24D;</i></span>
                    <span class="menu_title">Reports</span>
                </a>
                <ul style="display: none;" class="">
                    <li><a href="<?php echo $this->webroot ?>">Coming Soon</a></li>                        
                </ul>
            </li> 
            <?php if($this->Common->get_admin_option('legal_module')) { ?>
            <li>
                <a title="Legal Management">
                    <span class="menu_icon"><i class="material-icons">&#xE32A;</i></span>
                    <span class="menu_title">Legal Management</span>
                </a>
                <ul style="display: none;" class="">
                    <li><a href="<?php echo $this->webroot ?>legalmanagement/ministry_type">Ministry Setup</a></li>
                    <li><a href="<?php echo $this->webroot ?>legalmanagement/request_type">Request Setup</a></li>
                    <li><a href="<?php echo $this->webroot ?>legalmanagement/">Case Receiving</a></li>
                    <li><a href="<?php echo $this->webroot ?>legalmanagement/caseDetails">Case Details</a></li>
                    <li><a href="<?php echo $this->webroot ?>legalmanagement/request_type">Generate Reports</a></li>
                </ul>
            </li>
            <?php } ?>
            <?php } ?>
            <?php if($uservalues['Auth']['User']['user_type'] == 'Administrator') { ?>
            <li>
                <a title="All Masters">
                    <span class="menu_icon"><i class="material-icons">&#xE87B;</i></span>
                    <span class="menu_title">Masters</span>
                </a>
                <ul style="display: none;" class="">
                    <li><a href="<?php echo $this->webroot ?>masters/ministry">Ministry</a></li>
                    <li><a href="<?php echo $this->webroot ?>masters/promotion">Promotion Type</a></li>
                    <li><a href="<?php echo $this->webroot ?>masters/termsOfService">Terms of Services</a></li>
                    <li><a href="<?php echo $this->webroot ?>masters/schemeService">Scheme of Services Type</a></li>
                    <li><a href="<?php echo $this->webroot ?>masters/recommendedTermsService">Recommended Terms of Services</a></li>
                    <li><a href="<?php echo $this->webroot ?>masters/retirementGround">Retirement Grounds</a></li>
                    <li><a href="<?php echo $this->webroot ?>masters/mstRequest">Request Type</a></li>
                    <li><a href="<?php echo $this->webroot ?>masters/SignatoryMaster">Signatory Master</a></li>
                    <li><a href="<?php echo $this->webroot ?>acls/application">Core Master</a></li>
                            <li><a href="<?php echo $this->webroot . "acls/application"; ?>">Application, Roles, Permissions</a></li>
                            <li><a href="<?php echo $this->webroot . "acls/assignrole"; ?>">Assign Role</a></li>
                            <li><a href="<?php echo $this->webroot . "acls/assignrolereport"; ?>">Assign Role Report</a></li>   
                            <li><a >Masters</a>
                                <ul class="sub_menu">
                                    <li><a href="<?php echo $this->webroot; ?>companies/index">Company Master</a></li>
                                    <li><a href="<?php echo $this->webroot; ?>MstTravelVouchers/index">Travel Master</a></li>
                                      <li><a href="<?php echo $this->webroot; ?>TravelModes/index_vehicle">Vehicle Master</a></li>
                                    <li><a href="<?php echo $this->webroot; ?>Departments/index">Department Master</a></li>
                                    <li><a href="<?php echo $this->webroot; ?>Designations/index">Designation Master</a></li>
                                    <li><a href="<?php echo $this->webroot; ?>TravelModes/index">Travel Mode Master</a></li>
                                    <li><a href="<?php echo $this->webroot; ?>MstWheelers/index">Wheeler Price Master</a></li>

                                </ul>
                            </li> 
                            <li><a >Core</a>
                                <ul class="sub_menu">
                                    <li><a href="<?php echo $this->webroot; ?>workflows/applications">Application Master</a></li>
                                    <li><a href="<?php echo $this->webroot; ?>wfmstappmaplvls">Workflow Appliation Level Master</a></li>
                                    <li><a href="<?php echo $this->webroot; ?>wf_dt_app_map_lvls">Workflow Appliation Level Departmant Master</a></li>
                                </ul>
                            </li>
                            <li><a >User</a>
                                <ul class="sub_menu">						
                                    <li><a href="<?php echo $this->webroot; ?>Employees/index">Create User</a></li>
                                    <li><a href="<?php echo $this->webroot; ?>Employees/lists">View User</a></li>
                                </ul>
                            </li>
                            <li><a >Leaves</a>
                                <ul class="sub_menu">						
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
                                    <li><a href="<?php echo $this->webroot; ?>Configurations/important_doc_cat">Important document categories</a></li>

                                </ul>
                            </li>
                </ul>
            </li>
        
            <?php } ?>
        </ul>
        </li>
        </ul>
    </div>
</aside><!-- main sidebar end -->
