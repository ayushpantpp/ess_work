<script src="<?php echo $this->webroot; ?>js/jquery.min.js"></script>
<script src="<?php echo $this->webroot; ?>js/jquery-ui.min.js"></script>
<?php
$auth = $this->Session->read('Auth');
 $kra_config = $this->Session->read('sess_kra_config');
 
?>        
<script></script>
<script>
    /* Sidebar Menu active class */
    $(window).load(function() {
        var url = window.location;
        $('#menu_section a[href="' + url + '"]').parent('li').addClass('current_section');
        $('#menu_section a').filter(function () {
            return this.href == url;
        }).parent('li').addClass('current_section act_item').parent('ul').slideDown().parent().addClass('act_item');
    });
</script>
<aside id="sidebar_main">        
    <?php $uservalues = $this->Session->read(); ?>
    <div class="sidebar_main_header">
        <a href="<?php echo $this->webroot; ?>/users/dashboard" class="sSidebar_hide"><img src="<?php echo $this->Html->url('/images', true); ?>/<?php echo $uservalues['Auth']['User']['logo']; ?>"/></a>
    </div>
    <div class="menu_section" id="menu_section">
        <ul class="abcd">
            <?php if ($uservalues['Auth']['User']['user_type'] != 'Administrator') { ?>


                <?php 
                if(($this->Common->check_access_right($auth['MyProfile']['emp_code'], $auth['MyProfile']['comp_code'], 'ceo_dashboard', 'approval'))){
                ?>
            <li title="Dashboard">
                <a href="<?php echo $this->webroot ?>users/ceodashboard">
                    <span class="menu_icon"><i class="material-icons">&#xE871;</i></span>
                    <span class="menu_title">CEO Dashboard</span>
                </a>
            </li>
                <?php }else{
                    ?>
            <li title="Dashboard">
                <a href="<?php echo $this->webroot ?>users/dashboard">
                    <span class="menu_icon"><i class="material-icons">&#xE871;</i></span>
                    <span class="menu_title">Dashboard</span>
                </a>
            </li>     
               <?php  } ?>
            <li title="User Profile Details">
                <a href="#">
                    <span class="menu_icon"><i class="material-icons">&#xE87C;</i></span>
                    <span class="menu_title">My Profile</span>
                </a>
                <ul>
                    <li><a href="<?php echo $this->webroot ?>users/myprofile">View Profile</a> </li>                            
                    <li><a href="<?php echo $this->webroot ?>users/changepass">Change Password</a> </li>                   

                        <?php if ($this->Common->check_access_right($auth['MyProfile']['emp_code'], $auth['MyProfile']['comp_code'], 'user_profile', 'approval')) { ?>
                        
                    <li><a href="<?php echo $this->webroot ?>users/pendingDocuments">Pending Documents</a> </li>                            
                    <li><a href="<?php echo $this->webroot ?>users/addressApproval">Pending Addresses</a> </li> 
                        <?php } ?>      
<!-- <li><a href="<?php echo $this->webroot ?>users/setting">Settings </a> </li> -->
                </ul>
            </li>
                <?php if ($this->Common->get_admin_option('attendance_module')) { ?>
            <li title="User Profile Details">
                <a href="#">
                    <span class="menu_icon"><i class="material-icons">event</i></span>
                    <span class="menu_title">Attendance</span>
                </a>
                <ul>
                    <li><a href="<?php echo $this->webroot ?>users/add_attendance">Attendance</a> </li>  
                    <li><a href="<?php echo $this->webroot ?>users/pen_attend_approval">View Attendance</a> </li>                            
                       <?php if ($this->Common->check_access_right($auth['MyProfile']['emp_code'], $auth['MyProfile']['comp_code'], 'attendance_module', 'approval')) { ?>
                    <li><a href="<?php echo $this->webroot ?>users/attendance_approve">Approve Attendance </a> </li>
                            <?php } ?>
                            <?php if ($this->Common->check_access_right($auth['MyProfile']['emp_code'], $auth['MyProfile']['comp_code'], 'attendance_module', 'reports')) { ?>
                    <li><a href="<?php echo $this->webroot ?>users/attendance_report">Attendance Reports</a> </li>
                            <?php } ?>



                </ul>
            </li>
                <?php } ?>
                <?php if ($this->Common->get_admin_option('leave_module')) { ?>
            <li><a><span class="menu_icon"><i class="material-icons">assignment_late</i></span>
                    <span class="menu_title">Leave System</span></a>

                <ul class="" style="display: none">
                    <li><a href="<?php echo $this->Html->url('/leaves/add') ?>">Apply Leave</a></li>
                    <li><a href="<?php echo $this->Html->url('/leaves/view') ?>">View Leaves</a></li>
                    <?php if ($this->Common->check_access_right($auth['MyProfile']['emp_code'], $auth['MyProfile']['comp_code'], 'leave_module', 'masters')) { ?>
                    <li><a href="<?php echo $this->Html->url('/leaves/add_others_leave') ?>">Add Employee Leaves</a></li>
                    <?php } ?>
                    <?php if ($this->Common->check_access_right($auth['MyProfile']['emp_code'], $auth['MyProfile']['comp_code'], 'leave_module', 'approval')) { ?>
                    <li><a href="<?php echo $this->Html->url('/leaves/approval') ?>">Leave Approval</a></li><?php } ?>
                    <!--<li><a href="<?php echo $this->Html->url('/leaves/leaveencash') ?>">Leave Encashment</a></li>
                    <li><a href="<?php echo $this->Html->url('/leaves/encashview') ?>">Leave Encashment  View</a></li> -->

                            <?php if ($this->Session->read('san_encash_count') > 0) { ?>
                    <li><a href="<?php echo $this->Html->url('/leaves/pendingEncashment') ?>">Pending Encashment</a></li>   
                            <?php } ?> 
                            <?php if ($this->Common->check_access_right($auth['MyProfile']['emp_code'], $auth['MyProfile']['comp_code'], 'leave_module', 'reports')) { ?>
                    <li><a href="<?php echo $this->Html->url('/leaves/leave_report') ?>">Leave Report</a></li>
                    <!--<li><a href="<?php echo $this->Html->url('/leaves/leaveencash_report') ?>">Leave Encashment Report</a></li> -->
                            <?php } ?>

                </ul>   
            </li>
                <?php } ?>
		<?php if ($this->Common->get_admin_option('timesheet')) { ?>
            	<li><a><span class="menu_icon"><i class="material-icons">assignment_late</i></span>
                    <span class="menu_title">Timesheet Management</span></a>
                <ul class="" style="display: none">
                    <li><a href="<?php echo $this->Html->url('/timesheet/tslist_new') ?>">Timesheet Summary</a></li>
                    <!--<li><a href="<?php echo $this->Html->url('/timesheet/tsauto') ?>">Generate Timesheet</a></li>-->
		    <li><a href="<?php echo $this->Html->url('/timesheet/sanctionedlist') ?>">Approve Timesheet</a></li>
                    <!--<li><a href="<?php echo $this->Html->url('/timesheet/tslist') ?>">Old Timesheet</a></li>-->
                </ul>   
                </li>
                <?php } ?>
                <?php if ($this->Common->get_admin_option('Recruitment_Module')) { ?>
            <li><a><span class="menu_icon"><i class="material-icons">record_voice_over</i></span>
                    <span class="menu_title">Recruitment System</span></a>

                <ul class="" style="display: none">
                    <li><a href="<?php echo $this->Html->url('/Recruitment/add') ?>"> Raise Requisition</a></li>
                    <li><a href="<?php echo $this->Html->url('/Recruitment/view') ?>">View Requisition</a></li>
                    
                  
                    <?php if ($this->Common->check_access_right($auth['MyProfile']['emp_code'], $auth['MyProfile']['comp_code'], 'Recruitment_Module', 'approval')) { ?>
                    <li><a href="<?php echo $this->Html->url('/Recruitment/approval') ?>"> Requisition Approval</a></li><?php }?>   <?php if ($this->Common->check_access_right($auth['MyProfile']['emp_code'], $auth['MyProfile']['comp_code'], 'Recruitment_Module', 'master')) { ?> 

              

                          <li><a href="<?php echo $this->Html->url('/Recruitment/view_shortcan_list') ?>">View  Shortlist Candidates list </a></li>
                    <?php }?>
        
                            <?php if ($this->Common->check_access_right($auth['MyProfile']['emp_code'], $auth['MyProfile']['comp_code'], 'Recruitment_Module', 'reports')) { ?>
                  <!--   <li><a href="<?php //echo $this->Html->url('/leaves/leave_report') ?>">Requisition Report</a></li>  -->
       <!--  <li><a href="<?php echo $this->Html->url('/leaves/leaveencash_report') ?>">Leave Encashment Report</a></li>  -->
                            <?php } ?>

<?php if ($this->Common->check_access_right($auth['MyProfile']['emp_code'], $auth['MyProfile']['comp_code'], 'Recruitment_Module', 'masters')) { ?>
<!-- <li><a href="<?php echo $this->Html->url('/Recruitment/candidateprofile') ?>">Add Candidate Profile</a></li> -->
                    <li><a href="<?php echo $this->Html->url('/Recruitment/view_can_list') ?>">View Candidate list </a></li>
                    <?php }?>
                </ul>   
            </li>
                <?php } ?>


                <?php if ($this->Common->get_admin_option('temporary_component')) { ?>
            <li>
                <a href="#">
                    <span class="menu_icon"><i class="material-icons">account_balance_wallet</i></span>
                    <span class="menu_title">Temporary Component</span>
                </a>

                <ul>
                    <li><a href="<?php echo $this->webroot ?>temporary_components/add">Add Temporary Component</a> </li>
                    <li><a href="<?php echo $this->webroot ?>temporary_components/View">View</a> </li>
                            <?php if ($this->Session->read('sess_temp_count') > 0) { ?>
                    <li><a href="<?php echo $this->webroot ?>temporary_components/approval">Pending Approval</a> </li>


                            <?php } ?>
                            <?php if ($this->Common->check_access_right($auth['MyProfile']['emp_code'], $auth['MyProfile']['comp_code'], 'temporary_component', 'reports')) { ?>
                    <li><a href="<?php echo $this->webroot ?>temporary_components/temporary_comp_report">Temporary Component Report</a></li>
                    
                            <?php } ?>
                            
                </ul>
            </li>
                <?php } ?> 
            <?php if ($this->Common->get_admin_option('conveyance_module')) { ?>
            <li><a><span class="menu_icon"><i class="material-icons">directions_bus</i></span>
                    <span class="menu_title">Conveyance System</span></a>

                <ul class="" style="display: none">
                    <li><a href="<?php echo $this->Html->url('/conveyence_expenses/add') ?>">Expense Voucher</a> </li>
                    <li><a href="<?php echo $this->Html->url('/conveyence_expenses/view') ?>">View Expense</a></li>
                            <?php //if ($sanConvenceCount > 0) {   ?>
                    <li><a href="<?php echo $this->Html->url('/conveyence_expenses/approval') ?>">Expense Approval</a></li>
                            <?php //}  ?>
                            <?php if ($this->Common->check_access_right($auth['MyProfile']['emp_code'], $auth['MyProfile']['comp_code'], 'conveyance_module', 'reports')) { ?>
                    <li><a href="<?php echo $this->Html->url('/conveyence_expenses/employee_expense_report') ?>">Employee Expense Report</a></li>           
                            <?php } ?>


                </ul>   
            </li>

                <?php } ?>

                <?php if ($this->Common->get_admin_option('travel_module')) { ?>
            <li>
                <a><span class="menu_icon"><i class="material-icons">directions_bus</i></span>
                    <span class="menu_title">Travel Expense</span></a>                      

                <ul class="" style="display: none">
                    <li><a href="<?php echo $this->Html->url('/travels/trvoucher') ?>">Travel Voucher</a></li>
                    <li><a href="<?php echo $this->Html->url('/travels/view') ?>">Travel Voucher View</a></li>  
                    <?php if ($this->Common->check_access_right($auth['MyProfile']['emp_code'], $auth['MyProfile']['comp_code'], 'travel_module', 'approval')) { ?>
                    <li><a href="<?php echo $this->Html->url('/travels/approval') ?>">Travel Voucher Approval</a> </li>
                    <?php }  ?>
                    <?php if ($this->Common->check_access_right($auth['MyProfile']['emp_code'], $auth['MyProfile']['comp_code'], 'travel_module', 'masters')) { ?>
                    <li><a href="<?php echo $this->Html->url('/TravelMasters/add') ?>">Travel Master Daily Allowance Add</a> </li>
                    <li><a href="<?php echo $this->Html->url('/TravelMasters') ?>">Travel Master Daily Allowance View</a> </li>
                    <li><a href="<?php echo $this->Html->url('/travels/employee_travel_report') ?>">Employee Travels Report</a></li>           
                    <?php }   ?>
                </ul>   
            </li>
                <?php } ?>
            <?php if ($this->Common->get_admin_option('tax_module')) { ?>
            <li>
                <a href="#">
                    <span class="menu_icon"><i class="material-icons">&#xE850;</i></span>
                    <span class="menu_title">Income Tax Declaration</span>
                </a>
                <ul style="display: none;" class="">
                    <li><a href="<?php echo $this->webroot ?>income_tax/incometax_declaration">Income Tax Declaration</a></li>
                    <li><a href="<?php echo $this->webroot ?>income_tax/view">View</a></li>
                            <?php if ($this->Common->check_access_right($auth['MyProfile']['emp_code'], $auth['MyProfile']['comp_code'], 'tax_module', 'approval')) { ?>
                    <li><a href="<?php echo $this->webroot ?>income_tax/investment_financial">View All Investments </a> </li> 
                            <?php } ?>  
                </ul>
            </li>
                <?php } ?>

                <?php if ($this->Common->get_admin_option('task_module')) { ?>
            <li>
                <a title="Task Management">
                    <span class="menu_icon"><i class="material-icons">&#xE85D;</i></span>
                    <span class="menu_title">Task Management</span>
                </a>
                <ul style="display: none;" class="">
                     <?php if ($this->Common->check_access_right($auth['MyProfile']['emp_code'], $auth['MyProfile']['comp_code'], 'task_module', 'masters')) { ?>
                            <?php } ?>
                            <?php if ($this->Common->check_access_right($auth['MyProfile']['emp_code'], $auth['MyProfile']['comp_code'], 'task_module', 'approval')) { ?>
                             <?php } ?>
                    <li><a href="<?php echo $this->webroot ?>tasks/taskproject">Project Master</a></li> 
                    <li><a href="<?php echo $this->webroot ?>tasks/mtaskdashboard">View Tasks Manager</a></li>                        
                    <li><a href="<?php echo $this->webroot ?>tasks/taskapproval">Approve Tasks</a></li> 
                    <li><a href="<?php echo $this->webroot ?>tasks/index">Add Tasks</a></li>   
                   
                    
                    <li><a href="<?php echo $this->webroot ?>tasks/emptask">View Tasks</a></li> 
                </ul>
            </li>
                <?php } ?>
                <?php if ($this->Common->get_admin_option('mom_module')) { ?>
            <li>
                <a title="MOM Management">
                    <span class="menu_icon"><i class="material-icons">&#xE7EF;</i></span>
                    <span class="menu_title">MOM Management</span>
                </a>
                <ul style="display: none;" class="">
                            <?php if ($this->Common->check_access_right($auth['MyProfile']['emp_code'], $auth['MyProfile']['comp_code'], 'mom_module', 'approval')) { ?>
                    <li><a href="<?php echo $this->webroot ?>moms/addMeeting">Add Meeting</a></li>
                    <li><a href="<?php echo $this->webroot ?>moms/viewMeeting">View All Meeting</a></li>
                            <?php } ?>
                    <li><a href="<?php echo $this->webroot ?>moms/empMeeting">View Emp Meeting</a></li>
                    <li><a href="<?php echo $this->webroot ?>Boards/req_meeting">Meeting Request of Board Management</a></li>
                    <li><a href="<?php echo $this->webroot ?>Boards/meeting_decision">Meeting Decision of Board Management</a></li>
                </ul>
            </li>

                <?php } ?>
                <?php if ($this->Common->get_admin_option('help_desk')) { ?>
            <li>
                <a title="Help Desk">
                    <span class="menu_icon"><i class="material-icons">&#xE85D;</i></span>
                    <span class="menu_title">Help Desk<?php //echo $this->Common->get_admin_option('bom_module')."===";die;               ?></span>
                </a>
                <ul style="display: none;" class="">
                    <li><a href="<?php echo $this->webroot ?>HelpDesks/index">Add Help Ticket</a></li>     
                    <li><a href="<?php echo $this->webroot ?>HelpDesks/emp_complaints">View Your Tickets</a></li> 
                    <li><a href="<?php echo $this->webroot ?>HelpDesks/assign_complaints">View Assigned Tickets</a></li>  
                            <?php if ($this->Common->check_access_right($auth['MyProfile']['emp_code'], $auth['MyProfile']['comp_code'], 'help_desk', 'approval')) { ?>
                    <li><a href="<?php echo $this->webroot ?>HelpDesks/complaints">View All Tickets</a></li>          
                            <?php } ?>
                </ul>
            </li>
                <?php } ?>
            
            <?php if ($this->Common->get_admin_option('separation_module')) { ?>
            <li>
                <a href="#">
                    <span class="menu_icon"><i class="material-icons">&#xE85E;</i></span>
                    <span class="menu_title">Separation System</span>
                </a>
                <ul style="display: none;" class="">
                    <li><a href="<?php echo $this->webroot ?>separations/add">Apply for separation</a></li>
                    <li><a href="<?php echo $this->webroot ?>separations/">View Separation</a></li>
                            <?php if ($this->Common->check_access_right($auth['MyProfile']['emp_code'], $auth['MyProfile']['comp_code'], 'separation_module', 'approval')) { ?>
                    <li><a href="<?php echo $this->webroot ?>separations/approval">Separation Approvals</a></li>
                    <li><a href="<?php echo $this->webroot ?>fnfs/approval">FNFS Approvals</a></li>
                    <li><a href="<?php echo $this->webroot ?>fnfs/final_fnf">Final FNFS Approvals</a></li>
                            <?php } ?>
                </ul>
            </li>
                <?php } ?>
                <?php if ($this->Common->get_admin_option('appraisal_module')) { ?>
            <li><a title="Performance Management">
                    <span class="menu_icon"><i class="material-icons">&#xE24D;</i></span>
                    <span class="menu_title">Performance Management</span>
                </a>
                <ul class="" style="display: none">

                            <?php if ($this->Common->check_access_right($auth['MyProfile']['emp_code'], $auth['MyProfile']['comp_code'], 'appraisal_module', 'masters')) { ?>
                                <?php //if ($auth['MyProfile']['emp_id'] == 'DLF-1915' || $auth['MyProfile']['emp_id'] == 'DLF-1931') {   ?>
                    <li><a href="#">Masters</a>
                        <ul>
                            <li><a href="<?php echo $this->Html->url('/Ratings/addRating') ?>">Overall Rating</a></li>
                            <li><a href="<?php echo $this->Html->url('/KraMasters/addKraRating') ?>">KRA Rating</a></li>
                            <li><a href="<?php echo $this->Html->url('/Competency/addCompetencyRating') ?>">Competency Rating</a> </li>
                            <li><a href="<?php echo $this->Html->url('/Competency/addCompetency') ?>">Add Competency</a> </li>
                            <li><a href="<?php echo $this->Html->url('/Ratings/addCompetencyBehaviour') ?>">Behavioural Indicators</a> </li>
                            <li><a href="<?php echo $this->Html->url('/Competency/addGroup') ?>">Create Group</a> </li>
                            <li><a href="<?php echo $this->Html->url('/Competency/addGroupCompetency') ?>">Assign Competencies into Group</a> </li>
                            <li><a href="<?php echo $this->Html->url('/Competency/AssignMgtGroupToDesg') ?>" title="Designation Management Group">Assign Group to Management Designation</a></li>
                        </ul>
                    </li>
                    <li><a href="<?php echo $this->Html->url('/Competency/AssignCompetencyDeptDesg') ?>" title="Assign Competency to Designation">Assign Competencies to Employee</a> </li>
                    <li><a href="<?php echo $this->Html->url('/Competency/AssignGroupToDesg') ?>" title="Assign Group to Designation">Assign Group to Designation</a>
                    <li><a href="<?php echo $this->Html->url('/Competency/ViewAssignGroupToDesg') ?>">View all Assigned Group</a></li>
					<?php if($kra_config['MstPmsConfig']['mid_review']== 1){ ?>
                    <li><a href="<?php echo $this->Html->url('/KraMasters/midReviews') ?>" title="Open mid year review forms">Open Mid Year Review Form</a></li>
					<?php } ?>
                    <li><a href="<?php echo $this->Html->url('/KraMasters/appraisalProcess') ?>" title="Start Appraisal Process by HR">Open Annual / Appraisal Process</a></li>

                                <?php //}  ?>
                            <?php } ?>
                    <li><a href="#" title="Self List">Self KRA Lists</a>
                        <ul>
                            <li><a href="<?php echo $this->Html->url('/KraMasters/addKraTarget') ?>" title="View KRA">Add KRA</a></li>
                            <li><a href="<?php echo $this->Html->url('/KraMasters/viewAllEmpKraTarget') ?>" title="View KRA">View KRA Details</a></li>
							<?php if($kra_config['MstPmsConfig']['mid_review']== 1){ ?>
                            <li><a href="<?php echo $this->Html->url('/KraMasters/viewAllMidEmpKraTarget') ?>" title="View KRA">Mid Year Reviews</a></li>
							<?php } ?>
                            <li><a href="<?php echo $this->Html->url('/KraMasters/viewAllAnnEmpKraTarget') ?>" title="View KRA">Annual Appraisal</a></li>
                        </ul>
                    </li>


                            <?php if ($this->Session->read('sessAppraiserKraTargetCount') > 0) { ?>
                    <li><a href="#" title="View KRA">Appraiser KRA Lists</a>
                        <ul>
                            <li><a href="<?php echo $this->Html->url('/KraMasters/viewAllAppraiserKraTarget') ?>">KRA Approval</a></li>
							<?php if($kra_config['MstPmsConfig']['mid_review']== 1){ ?>
                            <li><a href="<?php echo $this->Html->url('/KraMasters/viewAllMidAppraiserKraTarget') ?>">Mid Year Reviews</a></li>
							<?php } ?>
                            <li><a href="<?php echo $this->Html->url('/KraMasters/viewAllAnnAppraiserKraTarget') ?>">Annual Appraisal</a></li>
                        </ul>
                    </li>
                            <?php } if ($this->Session->read('sessReviewerKraTargetCount') > 0) { ?>
                    <li><a href="#" title="View KRA">Reviewer KRA Lists</a>
                        <ul>
                            <li><a href="<?php echo $this->Html->url('/KraMasters/viewAllReviewerKraTarget') ?>">KRA Approval</a></li>
							<?php if($kra_config['MstPmsConfig']['mid_review']== 1){ ?>
                            <li><a href="<?php echo $this->Html->url('/KraMasters/viewAllMidReviewerKraTarget') ?>">Mid Year Reviews</a></li>
							<?php } ?>
                            <li><a href="<?php echo $this->Html->url('/KraMasters/viewAllAnnReviewerKraTarget') ?>">Annual Appraisal</a></li>
                        </ul>
                    </li>
                            <?php } if ($this->Session->read('sessModeratorKraTargetCount') > 0) { ?>
                    <li><a href="#" title="View KRA">Moderator KRA Lists</a>
                        <ul>
						<?php if($kra_config['MstPmsConfig']['mid_review']== 1){ ?>
                            <li><a href="<?php echo $this->Html->url('/KraMasters/viewAllMidModeratorKraTarget') ?>">Mid Year Reviews</a></li>
						<?php } ?>
                            <li><a href="<?php echo $this->Html->url('/KraMasters/viewAllAnnModeratorKraTarget') ?>">Annual Appraisal</a></li>
                        </ul>
                    </li>
                            <?php } ?>

                            <?php if ($this->Common->check_access_right($auth['MyProfile']['emp_code'], $auth['MyProfile']['comp_code'], 'appraisal_module', 'reports')) { ?>
                                <?php //if ($auth['MyProfile']['emp_id'] == 'PRT-1419' || ($auth['MyProfile']['emp_id'] == 'PRT-301' || $auth['MyProfile']['emp_id'] == 'WDU-0156' && $auth['MyProfile']['desg_code'] == 'PAR0000036')) {  ?>

                                <li><a href="#">Reports</a>
                                    <ul>
									<?php 
									
									 if($kra_config['MstPmsConfig']['app_type']==2){
									?>
									<li><a href="<?php echo $this->Html->url('/KraMasters/PmsStatusReport') ?>" title="PMS Status Report">PMS Status Report</a></li>
									<?php
									
									 }else{
		
									?>
										<li><a href="<?php echo $this->Html->url('/KraMasters/KraApprovalReport') ?>" title="KRA Assessment Report">KRA Approval Report</a></li>
										<li><a href="<?php echo $this->Html->url('/KraMasters/KraApprovalDetails') ?>" title="KRA Assessment Report">View KRA Details</a></li>
                                        <li><a href="<?php echo $this->Html->url('/KraMasters/KraMidReviewReport') ?>" title="KRA Assessment Report">KRA Mid Review Report</a></li>
										<li><a href="<?php echo $this->Html->url('/KraMasters/KraMidReviewDetails') ?>" title="KRA Assessment Report">View KRA Mid Review Details</a></li>
										<li><a href="<?php echo $this->Html->url('/KraMasters/KraAssessmentReport') ?>" title="KRA Assessment Report">KRA Annual Report</a></li>
                                        <li><a href="<?php echo $this->Html->url('/Competency/CompAssessmentReport') ?>" title="Competency Assessment Report">Competency Report</a></li>
                                        <li><a href="<?php echo $this->Html->url('/KraMasters/OverAllRatingReport') ?>" title="Over All Rating Report">Rating Report</a></li>
                                        <li><a href="<?php echo $this->Html->url('/KraMasters/DevelopmentPlanReport') ?>" title="Development Plan Report">Development Plan Report</a></li>
                                    
                                <?php 
								
									 }
									 
									 
								//}  ?></ul></li>

                            <?php } ?>
                </ul>
            </li>
                <?php } ?>



                <?php //if($this->Common->checkMedComSt()){  ?>
                <?php if ($this->Common->get_admin_option('medical_module')) { ?>
                    <?php //echo "<pre>";print_r($this->Common->checkMedComSt()); ?>
            <li>
                <a><span class="menu_icon"><i class="material-icons">local_hospital</i></span>
                    <span class="menu_title">Medical Claim</span></a>

                <ul class="" style="display: none">
                    <li><a href="<?php echo $this->Html->url('/medical/add') ?>">Medical Claim</a> </li>
                    <li><a href="<?php echo $this->Html->url('/medical/view') ?>">View</a> </li>
                    <li><a href="<?php echo $this->Html->url('/medical/employee_medical_report') ?>">Medical Report</a></li>
                            <?php if ($this->Session->read('sess_medical_count') > 0) { ?>
                    <li><a href="<?php echo $this->Html->url('/medical/approval') ?>">Medical approval</a> </li>
                            <?php } ?>
                </ul>
            </li>
                    <?php
                }

                //} 
                ?>

                <?php if ($this->Common->get_admin_option('legal_module')) { ?>
            <li>
                <a title="Legal Management">
                    <span class="menu_icon"><i class="material-icons">&#xE32A;</i></span>
                    <span class="menu_title">Legal Management</span>
                </a>
                <ul style="display: none;" class="">
                            <?php if ($this->Common->check_access_right($auth['MyProfile']['emp_code'], $auth['MyProfile']['comp_code'], 'legal_module', 'masters')) { ?>
                    <li><a href="<?php echo $this->webroot ?>LegalManagement/court_type">Court Type Master</a></li>
                    <li><a href="<?php echo $this->webroot ?>LegalManagement/case_type">Case Type Master</a></li>
                    <li><a href="<?php echo $this->webroot ?>LegalManagement/case_status">Case Status Master</a></li>
                    <li><a href="<?php echo $this->webroot ?>LegalManagement/case_outcome">Case Outcome Master</a></li>
                    <li><a href="<?php echo $this->webroot ?>LegalManagement/court_location">Court Location Master</a></li>
                            <?php } ?> 
                    <li><a href="<?php echo $this->webroot ?>LegalManagement/">Case Receiving</a></li>
                            <?php if ($this->Common->check_access_right($auth['MyProfile']['emp_code'], $auth['MyProfile']['comp_code'], 'legal_module', 'reports')) { ?>
                    <li><a href="<?php echo $this->webroot ?>LegalManagement/case_report">Case Reports</a></li>
                            <?php } ?>
                </ul>
            </li>
                <?php } ?>
                <?php if ($this->Common->get_admin_option('lta_module')) { ?>
            <li><a><span class="menu_icon"><i class="material-icons">directions_bus</i></span>
                    <span class="menu_title">Claim LTA</span></a>

                <ul class="" style="display: none">
                    <li><a href="<?php echo $this->Html->url('/lta/add') ?>">LTA Claim</a> </li>
                    <li><a href="<?php echo $this->Html->url('/lta/view') ?>">View</a> </li>

                    <li><a href="<?php echo $this->Html->url('/lta/employee_lta_report') ?>">LTA Report</a> </li>


                            <?php if ($this->Session->read('sess_lta_count') > 0) { ?>  
                    <li><a href="<?php echo $this->Html->url('/lta/approval') ?>">LTA approval</a> </li>
                            <?php } ?>
                </ul>
            </li>
                    <?php
                }
                //} 
                ?>
 <?php if ($this->Common->get_admin_option('salary_slip')) { ?>
            <li><a><span class="menu_icon"><i class="material-icons">receipt</i></span>
                    <span class="menu_title">Salary </span></a>

                <ul class="" style="display: none">
                    <li><a href="<?php echo $this->Html->url('/salaries/index') ?>">Salary Slip</a> </li>


                </ul>
            </li>
                    <?php
                }
                //} 
                ?>
				<?php if ($this->Common->get_admin_option('survey_module')) { ?>
                    <li><a><span class="menu_icon"><i class="material-icons">receipt</i></span>
                            <span class="menu_title">Survey Master</span></a>
                        <ul class="" style="display: none">
                        <?php //if ($this->Common->check_access_right($auth['MyProfile']['emp_code'], $auth['MyProfile']['comp_code'], 'survey_module', 'masters')) { ?>
                            <li><a href="<?php echo $this->Html->url('/Surveys/create_survey') ?>">Create Survey</a> </li>
                            <li><a href="<?php echo $this->Html->url('/Surveys/parameter_type') ?>">Parameter Master</a></li>
                            <li><a href="<?php echo $this->Html->url('/Surveys/question_master') ?>">Question Master</a></li>
                            <?php //} ?>
							</li>
						</ul>
                        <?php } ?> 

                <?php if ($this->Common->get_admin_option('other_module')) { ?>
            <li><a><span class="menu_icon"><i class="material-icons">receipt</i></span>
                    <span class="menu_title">Important Documents</span></a>
                <ul class="" style="display: none">

                    <li><a href="<?php echo $this->webroot; ?>Holidays/holidaylisting">List of Holidays</a></li>
                    <li><a href="<?php echo $this->webroot; ?>Documents/doc_upload">Document Upload</a></li>
                    <!-- <?php } ?>
                   
                   <?php  if($this->Common->get_admin_option('other_module')) { 

                    ?> -->
                    <li>
                        <a href="#">
                            <span class="menu_icon"><i class="material-icons">receipt</i></span>
                            <span class="menu_title">Other Document</span>
                        </a>
                        <ul style="display: none;" class="">
                            <?php 
                            $doclist=$this->Common->finddocumentlist();
                            foreach($doclist as $K=> $doc)
                            {
                                $cat_status=$this->Common->findcatgallery_status($K);
                                if($cat_status==1) { ?>
                            <li><a href="<?php echo $this->webroot; ?>Documents/office_gallery?id=<?php echo $K; ?>"><?php echo $doc; ?></a></li><?php } else { ?>
                            <li><a href="<?php echo $this->webroot; ?>Documents/public_doclist?id=<?php echo $K; ?>"><?php echo $doc; ?></a></li><?php }}?>
                        </ul>
                    <li> 
                <?php } 
               ?>       

                 


                <?php if ($this->Common->get_admin_option('training_module')) { ?>
                            <li><a><span class="menu_icon"><i class="material-icons">directions_bus</i></span>
                                    <span class="menu_title">Training Management</span></a>
                                <ul class="" style="display: none">
                            <?php if ($this->Common->getTrainingUserType() == 'TI') { ?>
                                    <li><a href="<?php echo $this->Html->url('/training/cousre_masters') ?>">Course Master</a> </li>
                                    <li><a href="<?php echo $this->Html->url('/training/addCourseCreation') ?>">Course Creation</a> </li>
                                    <li><a href="<?php echo $this->Html->url('/training/viewAllCourseCreation') ?>">View All Courses</a> </li>
                                    <li><a href="<?php echo $this->Html->url('/training/addCourseSchedule') ?>">Course Schedule Creation</a></li>
                                    <li><a href="<?php echo $this->Html->url('/training/scheduleCourse') ?>">View All Course Schedules</a> </li>
                                    <li><a href="<?php echo $this->Html->url('/training/viewAllCourseSchedule') ?>">View All Course & Schedules</a> </li>
                                    <li><a href="<?php echo $this->Html->url('/training/assignEmployeeMatrix') ?>">Assign Evolution Matrix to Employee</a> </li>
                                    <li><a href="<?php echo $this->Html->url('/training/viewAssignedEmployeeMatrix') ?>">View all assigned Evolution Matrix Employee</a> </li>
                                    <li><a href="<?php echo $this->Html->url('/training/employeeHistoryReport') ?>">Training Reports</a></li>
                            <?php } ?>
                            <?php if ($this->Common->getTrainingUserType() == 'TI' || !empty($this->Common->checkReortEmpCount())) { ?>
                                    <li><a href="<?php echo $this->Html->url('/training/trainingIdentificationInitateForm') ?>">Training Initiation Request Form</a> </li>
                            <?php } ?>

                                    <li><a href="<?php echo $this->Html->url('/training/trainingIdentificationRequestForm') ?>">Training Enrollment Form</a> </li>
                                    <li><a href="<?php echo $this->Html->url('/training/manageTrainingIdentificationForm') ?>">Request Form Summary</a> </li>
                            <?php if ($this->Common->getTrainingUserType() == 'TI' || !empty($this->Notify->getSanctionTraining())) { ?>
                                    <li><a href="<?php echo $this->Html->url('/training/sanctionTrainingRequests') ?>">Pending Training Request Approval</a> </li>
                            <?php }?>
                                    <li><a href="<?php echo $this->Html->url('/training/pendingFeedbacks') ?>">Training Feedback Summary</a> </li>
                            <?php if ($this->Common->getTrainingUserType() == 'TI' || !empty($this->Common->getTrainingEmplyeeMatrixChk($auth['MyProfile']['emp_code']))) { ?>
                                    <li><a href="<?php echo $this->Html->url('/training/listevolutionMatrix') ?>">View all Evolution Matrix</a></li>
                                <?php } ?>
                                </ul>   
                            </li>
                <?php } ?>          

                    <?php if ($uservalues['Auth']['User']['user_type'] == 'Administrator') { ?>
                            <li>
                                <a title="All Masters">
                                    <span class="menu_icon"><i class="material-icons">&#xE87B;</i></span>
                                    <span class="menu_title">Masters</span>
                                </a>
                                <ul style="display: none;" class="">
                                    <li><a >Module Wise Masters</a>
                                        <ul class="sub_menu">
                                            <li><a href="<?php echo $this->webroot; ?>companies/index">Company Master</a></li>
                                            <li><a href="<?php echo $this->webroot; ?>MstTravelVouchers/index">Travel Master</a></li>
                                            <li><a href="<?php echo $this->webroot; ?>KraMasters/addKraType">KRA Type</a></li>
                                            <li><a href="<?php echo $this->webroot; ?>KpiMasters/addKpiType">KPI Type</a></li>
                                            <li><a href="<?php echo $this->webroot; ?>KraMasters/linkKraKpi">Link KRA & KPI</a></li>
                                            <li><a href="<?php echo $this->webroot; ?>Competency/addCompetencyType">Competency Type</a></li>
                                            <li><a href="<?php echo $this->webroot; ?>SetupMasters/addReqNotificationType">Request Notification Type</a></li>
                                            <li><a href="<?php echo $this->webroot; ?>SetupMasters/addNotificationReminderType">Notification Reminder Type</a></li>
                                            <li><a href="<?php echo $this->webroot; ?>SetupMasters/addWeightageCalculationType">Weightage Calculation Type</a></li>
                                            <li><a href="<?php echo $this->webroot; ?>SetupMasters/addSmtpConfigurationType">Smtp Configuration Type</a></li>                                
                                            <li><a href="<?php echo $this->webroot; ?>Departments/index">Department Master</a></li>
                                            <li><a href="<?php echo $this->webroot; ?>Designations/index">Designation Master</a></li>
                                            <li><a href="<?php echo $this->webroot; ?>TravelModes/index">Travel Mode Master</a></li>
                                            <li><a href="<?php echo $this->webroot; ?>MstWheelers/index">Wheeler Price Master</a></li>
                                            <li><a href="<?php echo $this->webroot; ?>SetupMasters/index">Setup Master</a></li>
                                            <li><a href="<?php echo $this->webroot ?>masters/ministry">Ministry</a></li>
                                            <li><a href="<?php echo $this->webroot ?>masters/promotion">Promotion Type</a></li>
                                            <li><a href="<?php echo $this->webroot ?>masters/termsOfService">Terms of Services</a></li>
                                            <li><a href="<?php echo $this->webroot ?>masters/schemeService">Scheme of Services Type</a></li>
                                            <li><a href="<?php echo $this->webroot ?>masters/recommendedTermsService">Recommended Terms of Services</a></li>
                                            <li><a href="<?php echo $this->webroot ?>masters/retirementGround">Retirement Grounds</a></li>
                                            <li><a href="<?php echo $this->webroot ?>masters/mstRequest">Request Type</a></li>
                                            <li><a href="<?php echo $this->webroot ?>masters/SignatoryMaster">Signatory Master</a></li>
                                            <li><a href="<?php echo $this->webroot ?>masters/logo">Logo Master</a></li>
                                        </ul>
                                    </li> 
                                    <li><a >Core</a>
                                        <ul class="sub_menu">
                                            <li><a href="<?php echo $this->webroot ?>acls/application" ><b>Core Master</b></a></li>
                                            <li><a href="<?php echo $this->webroot . "acls/application"; ?>">Application, Roles, Permissions</a></li>
                                            <li><a href="<?php echo $this->webroot . "acls/assignrole"; ?>">Assign Role</a></li>
                                            <li><a href="<?php echo $this->webroot . "acls/assignrolereport"; ?>">Assign Role Report</a></li>
                                            <li><a href="<?php echo $this->webroot; ?>workflows/applications">Application Master</a></li>
                                            <li><a href="<?php echo $this->webroot; ?>WfMstAppMapLvls">Workflow Appliation Level Master</a></li>
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

                        <?php } } ?>
                        </ul>
                    </li>
       
                    </ul>
                </div>
</aside><!-- main sidebar end -->


