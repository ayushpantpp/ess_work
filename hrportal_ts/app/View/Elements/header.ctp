<?php
$auth = $this->Session->read('Auth');
$kra_config = $this->Session->read('sess_kra_config');
$empCode = $auth['MyProfile']['emp_code'];
$deptCode = $auth['MyProfile']['dept_code'];
$desgCode = $auth['MyProfile']['desg_code'];
$name = $auth['MyProfile']['user_name'];
$empFisrtName = $auth['MyProfile']['emp_name'];
$currentFinancialYear = $auth['User']['financial_year'];
$allGroupIds = $this->Common->findAssignGroupToEmpList($desgCode, $empCode, $currentFinancialYear);
$competencyList = $this->Common->findGroupCompetencyDeptDesgList($allGroupIds);
$assignCompetencyDeptDesgList = $this->Common->findAssignCompetencyDeptDesgList($deptCode, $desgCode, $empCode, $currentFinancialYear);
$Cccc = array_unique(array_merge($competencyList, $assignCompetencyDeptDesgList));
$kraList = $this->Common->getTotalKraTarge($empCode, $currentFinancialYear);
if ($kraList == 0) {
    if (count($Cccc) >= 1 || count($assignCompetencyDeptDesgList) >= 1) {
        $kraAlert = 1;
    }
} else {
    $kraAlert = 0;
}
$reqList = $this->Common->getTotalreq();

$Requisitionlist=count($reqList);
//print_r($Requisitionlist);die;
if($Requisitionlist!=0)
{
    $reqalert=1;
}
else {
    $reqalert = 0;
}
$interview = $this->Common->getTotalinterviewscheduled($empCode);

$interviewList=count($interview);
if($interviewList!=0)
{
    $interalert=1;
}
else {
    $interalert = 0;
}


$appraisalList = $this->Common->findAppraisalProcessList($empCode, $currentFinancialYear);
$midreviewList = $this->Common->findMidReviewsListEmp($empCode, $currentFinancialYear);
$selfScoreList = $this->Common->getKraTargetEmpSelfScore($empCode, $currentFinancialYear);
if ($selfScoreList == 0) {
    if ($appraisalList == 1) {
        $appraisalAlert = 1;
    }
	if ($midreviewList == 1 && ($kra_config['MstPmsConfig']['mid_review'] == 1)) {
        $midreviewAlert = 1;
    }
} else {
    $appraisalAlert = 0;
	 $midreviewAlert = 0;
}
if($kra_config['MstPmsConfig']['mid_review'] == 1){

$midreviewAppTab = $this->Common->findMidReviewsDetailsAppAlert($empCode, $currentFinancialYear);
$midCompAppTab = $this->Common->findMidCompDetailsAppAlert($empCode, $currentFinancialYear);
if ($midreviewAppTab >= 1 ) {
    $midreviewAppAlert = 1;
} else {
	if($midCompAppTab == 1){
		 $midreviewAppAlert = 1;
	}else{
		$midreviewAppAlert = 0;
	}
	
}

$midreviewRevTab = $this->Common->findMidReviewsDetailsRevAlert($empCode, $currentFinancialYear);
$midCompRevTab = $this->Common->findMidCompDetailsRevAlert($empCode, $currentFinancialYear);
if ($midreviewRevTab >= 1) {
    $midreviewRevAlert = 1;
} else {
	if($midCompRevTab == 1){
		 $midreviewRevAlert = 1;
	}else{
    $midreviewRevAlert = 0;
	}
}

$midreviewModTab = $this->Common->findMidReviewsDetailsModAlert($empCode, $currentFinancialYear);
$midCompModTab = $this->Common->findMidCompDetailsModAlert($empCode, $currentFinancialYear);
if ($midreviewModTab >= 1) {
    $midreviewModAlert = 1;
} else {
	if($midCompModTab == 1){
		 $midreviewModAlert = 1;
	}else{
    $midreviewModAlert = 0;
	}
}
}
$totalKraTargeList = $this->Common->getTotalKraTarge($empCode, $currentFinancialYear);
$totalRevert = count($this->Common->getKraTargetRevertStatusforEmpByAppraiser($empCode, $currentFinancialYear));
$totalRevert1 = count($this->Common->getKraTargetRevertStatusforEmpByReviewer($empCode, $currentFinancialYear));
$totalApproved = count($this->Common->getKraTargetApprovalStatus($empCode, $currentFinancialYear));

//echo'-<br>';

if (($totalRevert <= $totalApproved || $totalRevert1 <= $totalApproved) && $totalRevert != 0) {
    $kraReverAlert = 1;
} else if ($totalRevert < $totalKraTargeList && $totalRevert != 0 && $totalKraTargeList != $totalApproved) {
    $kraReverAlert = 1;
} else {
    $kraReverAlert = 0;
}
//echo $empCode;
//die;
$totalOpen = $this->Common->getKraTargetOpenStatusForAppraiser($empCode, $currentFinancialYear);

if ($totalOpen >= 1) {
    $appraiserAlert = 1;
} else {
    $appraiserAlert = 0;
}

$totalOpen1 = $this->Common->getKraTargetOpenStatusForReviewer($empCode, $currentFinancialYear);
$totalOpen2 = $this->Common->getKraTargetOpenStatusForReviewer1($empCode, $currentFinancialYear);
//print_r(count($totalOpen1));
//print_r(count($totalOpen2));
if (count($totalOpen1) >= 1 || count($totalOpen2) >= 1) {
    $reviewerAlert = 1;
} else {
    $reviewerAlert = 0;
}

$selfScore = $this->Common->getKraTargetEmpSelfScoreForAppraiser($empCode, $currentFinancialYear);
if ($selfScore >= 1) {
    $selfScoreAlert = 1;
} else {
    $selfScoreAlert = 0;
}

$reviewerSelfScore = $this->Common->getKraTargetAppraiserSelfScoreForReviewer($empCode, $currentFinancialYear);
if ($reviewerSelfScore >= 1) {
    $reviewerSelfScoreAlert = 1;
} else {
    $reviewerSelfScoreAlert = 0;
}

$moderatorSelfScore = $this->Common->getKraTargetReviewerSelfScoreForModerator($empCode, $currentFinancialYear);
if ($moderatorSelfScore >= 1) {
    $moderatorSelfScoreAlert = 1;
} else {
    $moderatorSelfScoreAlert = 0;
}
?>
<?php
            $hour = date('H');
            if ($hour >= 20) {
                $greetings = "Good Night";
                $icon = "md-color-grey-50 uk-text-bold uk-icon-star";
            } elseif ($hour > 17) {
                $greetings = "Good Evening";
                $icon = "md-color-grey-50 uk-text-bold uk-icon-star-half-o";
            } elseif ($hour > 11) {
                $greetings = "Good Afternoon";
                $icon = "md-color-grey-50 uk-text-bold uk-icon-sun-o";
            } elseif ($hour < 12) {
                $greetings = "Good Morning";
                $icon = "md-color-grey-50 uk-text-bold uk-icon-sun-o";
            }
            ?>

<header id="header_main">
    <div class="header_main_content">
        <nav class="uk-navbar">   
            <a href="#" id="sidebar_main_toggle" class="sSwitch sSwitch_left">
                <span class="sSwitchIcon"></span>
            </a>
            <?php
            if ($this->Common->get_admin_option('leave_module')) {
                 $pendingLeave = $this->Notify->getPendingLeave();
                 $sanctionLeave = $this->Notify->getSanctionLeave();
             }
               if ($this->Common->get_admin_option('attendance_module')) {
                 $pendattendance = $this->Notify->sanctionAttendance();
                 $penhrattendance=$this->Notify->HrApproveAttendance();
                $pendattendanceemp = $this->Notify->pendingAttendance();
                
            }
             if ($this->Common->get_admin_option('Recruitment_Module')) {
                //echo "s" ;die;
                 $sanctionRequisition = $this->Notify->sanctionRequisition();
                // $penmanagerRequisition=$this->Notify->HrApproveRequisition();
                $pendingRequisition = $this->Notify->pendingRequisition();
              //  print_r($pendingRequisition);
              
                
            }
            if ($this->Common->get_admin_option('conveyance_module')) {
                $pendingConv = $this->Notify->getPendingConv();
                $sanctionConv = $this->Notify->getSanctionConv();
            }
            if ($this->Common->get_admin_option('temporary_component')) {
                $pendingTemp = $this->Notify->pendingTemp();
                $sanctionTemp = $this->Notify->getSanctionTemp();
            }
            if ($this->Common->get_admin_option('training_module')) {
                $pendingTraining = $this->Notify->pendingTraining();
                $pendingTrainingFeedback = $this->Notify->pendingTrainingFeedback();
                $sanctionTraining = $this->Notify->getSanctionTraining();
                $pendingTrainingAttendence = $this->Notify->pendingTrainingAttendence();

                $pendingTrainingCloseAttendence = $this->Notify->pendingTrainingAttendenceClose();
            }
            if ($this->Common->get_admin_option('travel_module')) {
                $pendingTravel = $this->Notify->pendingTravel();
                $sanctionTravel = $this->Notify->getSanctionTravel();
            }
            if ($this->Common->get_admin_option('timesheet')) { 
                $pendingTimesheet = $this->Notify->pendingTimesheet();
                $sanctionTimesheet = $this->Notify->getSanctionTimesheet();
            }
            	
            ?>
            <div class="uk-navbar-flip">
                <ul class="uk-navbar-nav user_actions">
                    <li><a href="#" id="full_screen_toggle" class="user_action_icon uk-visible-large"><i class="material-icons md-24 md-light">&#xE5D0;</i></a></li>
                    <li data-uk-dropdown="{mode:'click',pos:'bottom-right'}">
                        <a href="#" class="user_action_icon">
                            <i class="material-icons md-24 md-light">&#xE7F4;</i>

                            <span class="uk-badge"><?php echo $pendingRequisition+$sanctionRequisition+$sanctionTimesheet+$pendingTimesheet+$pendattendanceemp+$pendattendance + $pendingLeave + $pendingConv + $pendingTemp + $pendingTravel + $sanctionConv + $sanctionTravel +$sanctionTemp + $sanctionLeave +$reqalert+ $kraAlert + $midreviewAlert + $appraisalAlert + $kraReverAlert + $midreviewAppAlert + $midreviewRevAlert + $midreviewModAlert + $appraiserAlert + $reviewerAlert + $selfScoreAlert + $reviewerSelfScoreAlert + $moderatorSelfScoreAlert + $pendingTraining + $sanctionTraining + count($pendingTrainingAttendence) + count($pendingTrainingCloseAttendence)+ count($pendingTrainingFeedback)+$training; ?></span>

                        </a>
                        <div class="uk-dropdown uk-dropdown-xlarge">
                            <div class="md-card-content">
                                <ul class="uk-tab uk-tab-grid" data-uk-tab="{connect:'#header_alerts',animation:'slide-horizontal'}">
                                    <?php

                                    $TotalPnding = $pendingRequisition+$pendingTimesheet+$$pendattendanceemp + $pendingLeave + $pendingConv + $pendingTemp + $pendingTravel + $pendingTraining + count($pendingTrainingFeedback)+ count($pendingTrainingAttendence) + count($pendingTrainingCloseAttendence)+$training;

                                    $TotalSenc = $sanctionRequisition+$sanctionTimesheet+$pendattendance+$sanctionLeave + $sanctionConv + $sanctionTemp + $sanctionTravel + $sanctionTraining;
                                    $TotalKRA = $reqalert+$kraAlert + $midreviewAlert + $appraisalAlert + $kraReverAlert + $midreviewAppAlert + $midreviewRevAlert + $midreviewModAlert + $appraiserAlert + $reviewerAlert + $selfScoreAlert + $reviewerSelfScoreAlert + $moderatorSelfScoreAlert;
                                    
                                    ?>
                                    <li class="uk-width-1-3 uk-active" aria-expanded="true"><a href="#" class="js-uk-prevent uk-text-small">Pending(<?php echo $TotalPnding; ?>)</a></li>
                                    <?php
                                    //}
                                    //if($TotalSenc > 0){
                                    ?>
                                    <li class="uk-width-1-3" aria-expanded="false"><a href="#" class="js-uk-prevent uk-text-small">Sanction(<?php echo $TotalSenc; ?>)</a></li>
                                    <?php
                                    //}
                                    //if($TotalKRA > 0){
                                    ?>
                                    <li class="uk-width-1-3" aria-expanded="false"><a href="#" class="js-uk-prevent uk-text-small">Alerts(<?php echo $TotalKRA; ?>)</a></li>
                                    <?php //}      ?>
                                </ul>
                                <ul id="header_alerts" class="uk-switcher uk-margin">
                                    <li aria-hidden="false" class="uk-active">
                                        <ul class="md-list md-list-addon">

                                            <?php
                                  if($TotalPnding<=0){?>
                                            <span class="uk-text-small uk-text-muted"> &nbsp; &nbsp;&nbsp;&nbsp;Nothing Pending Found </span>
                                           <?php }
                                            if ($this->Common->get_admin_option('leave_module')) {
                                                
                                                if (($pendingLeave > 0) && ($TotalPnding > 0)) {
                                                    ?>
                                            <li>
                                                <div class="md-list-addon-element">
                                                    <span class="md-user-letters md-bg-cyan"><?php echo $pendingLeave; ?></span>
                                                </div>
                                                <div class="md-list-content">
                                                    <span class="md-list-heading"><a href="<?php echo $this->Html->url('/leaves/view') ?>">Pending Leaves</a></span>
                                                    <span class="uk-text-small uk-text-muted">Leaves Pending for Manager Approval</span>
                                                </div>
                                            </li>

                                                    <?php
                                                }
                                                if ($pendattendanceemp > 0 ) {


                                                    ?>
                                            <li>
                                                <div class="md-list-addon-element">
                                                    <span class="md-user-letters md-bg-cyan"><?php echo $pendattendanceemp; ?></span>
                                                </div>
                                                <div class="md-list-content">
                                                    <span class="md-list-heading"><a href="<?php echo $this->Html->url('/users/pen_attend_approval') ?>">Pending Attendance</a></span>
                                                  
                                        
                                                  
                                        
                                                    <span class="uk-text-small uk-text-muted"> Pending Attendance for Manager Approval</span>
                                                </div>
                                            </li>

                                                    <?php
                                                }
                                                
                                                
                                                  
                                            } 

    
                                  
                                                if ($this->Common->get_admin_option('Recruitment_module')) {
                                                
                                                if (($pendingRequisition  < 0) && ($TotalPnding > 0)) {
                                                    ?>
                                            <li>
                                                <div class="md-list-addon-element">
                                                    <span class="md-user-letters md-bg-cyan"><?php echo $pendingRequisition; ?></span>
                                                </div>
                                                <div class="md-list-content">
                                                    <span class="md-list-heading"><a href="<?php echo $this->Html->url('/Recruitment/view') ?>">Pending Requisition Approval</a></span>
                                                    <span class="uk-text-small uk-text-muted">Requisition Pending for Manager Approval</span>
                                                </div>
                                            </li>

                                                   <?php
                                                }

                                                if ($pendingRequisition > 0 ) {


                                                    ?>
                                            <li>
                                                <div class="md-list-addon-element">
                                                    <span class="md-user-letters md-bg-cyan"><?php echo $pendingRequisition; ?></span>
                                                </div>
                                                <div class="md-list-content">
                                                    <span class="md-list-heading"><a href="<?php echo $this->Html->url('/Recruitment/view') ?>">Pending Requisition</a></span>
                                                  
                                        
                                                  
                                        
                                                    <span class="uk-text-small uk-text-muted"> Pending Requisition for Manager Approval</span>
                                                </div>
                                            </li>

                                                    <?php
                                                }
                                                
                                                
                                                  
                                            } 





                                            if ($this->Common->get_admin_option('conveyance_module')) {
                                                if (($pendingConv > 0) && ($TotalPnding > 0)) {
                                                    ?>                                                
                                            <li>
                                                <div class="md-list-addon-element">
                                                    <span class="md-user-letters md-bg-cyan"><?php echo $pendingConv; ?></span>
                                                </div>
                                                <div class="md-list-content">
                                                    <span class="md-list-heading"><a href="<?php echo $this->Html->url('/conveyence_expenses/view') ?>">Pending Conveyance</a></span>
                                                    <span class="uk-text-small uk-text-muted">Vouchers Pending for Manager Approval</span>
                                                </div>
                                            </li>
                                                    <?php
                                                }
                                            } 
                                            if ($this->Common->get_admin_option('timesheet')) {
                                                if (($pendingTimesheet > 0) && ($TotalPnding > 0)) {
                                                    ?>                                                
                                            <li>
                                                <div class="md-list-addon-element">
                                                    <span class="md-user-letters md-bg-cyan"><?php echo $pendingTimesheet; ?></span>
                                                </div>
                                                <div class="md-list-content">
                                                    <span class="md-list-heading"><a href="<?php echo $this->Html->url('/timesheet/tslist_new') ?>">Pending Timesheet</a></span>
                                                    <span class="uk-text-small uk-text-muted">Timesheet Pending for Manager Approval</span>
                                                </div>
                                            </li>
                                                    <?php
                                                }
                                            }
                                            if ($this->Common->get_admin_option('travel_module')) {
                                                if (($pendingTravel > 0) && ($TotalPnding > 0)) {
                                                    ?>
                                            <li>
                                                <div class="md-list-addon-element">
                                                    <span class="md-user-letters md-bg-cyan"><?php echo $pendingTravel; ?></span>
                                                </div>
                                                <div class="md-list-content">
                                                    <span class="md-list-heading"><a href="<?php echo $this->Html->url('/travels/view') ?>">Pending Travel</a></span>
                                                    <span class="uk-text-small uk-text-muted">Travel Pending for Manager Approval</span>
                                                </div>
                                            </li>
                                                    <?php
                                                }
                                            } if ($this->Common->get_admin_option('temporary_component')) {
                                                if (($pendingTemp > 0) && ($TotalPnding > 0)) {
                                                    ?>                                                
                                            <li>
                                                <div class="md-list-addon-element">
                                                    <span class="md-user-letters md-bg-cyan"><?php echo $pendingTemp; ?></span>
                                                </div>
                                                <div class="md-list-content">
                                                    <span class="md-list-heading"><a href="<?php echo $this->Html->url('/temporary_components/View') ?>">Pending Temporary Comp.</a></span>
                                                    <span class="uk-text-small uk-text-muted">Temporary Components Pending for Manager Approval</span>
                                                </div>
                                            </li>
                                                    <?php
                                                }
                                            }
                                            if ($this->Common->get_admin_option('training_module')) {
                                                if (count($pendingTrainingAttendence) > 0) {
                                                    ?>
                                            <li>
                                                <div class="md-list-addon-element">e
                                                    <span class="md-user-letters md-bg-cyan"><?php echo count($pendingTrainingAttendence); ?></span>
                                                </div>
                                                <div class="md-list-content">
                                                    <span class="md-list-heading"><a href="<?php echo $this->Html->url('/training/trainingAttendence') ?>">Pending Training Attendance.</a></span>
                                                    <span class="uk-text-small uk-text-muted">Open Attendance</span>
                                                </div>
                                            </li>
                                                <?php }if (count($pendingTrainingFeedback) > 0) {
                                                    ?>
                                            <li>
                                                <div class="md-list-addon-element">
                                                    <span class="md-user-letters md-bg-cyan"><?php echo count($pendingTrainingFeedback); ?></span>
                                                </div>
                                                <div class="md-list-content">
                                                    <span class="md-list-heading"><a href="<?php echo $this->Html->url('/training/pendingFeedbacks') ?>">Pending Training Feedback</a></span>
                                                    <span class="uk-text-small uk-text-muted">Open Feedback Form</span>
                                                </div>
                                            </li>
                                                    <?php
                                                } if ($training > 0) { ?>
                                            <li>
                                                <div class="md-list-addon-element">
                                                    <span class="md-user-letters md-bg-cyan"><?php echo $training; ?></span>
                                                </div>
                                                <div class="md-list-content">
                                                    <span class="md-list-heading"><a href="<?php echo $this->Html->url('/training/upcomingTraining') ?>">Pending Upcoming Training</a></span>
                                                    <span class="uk-text-small uk-text-muted">Open Upcoming Training Form</span>
                                                </div>
                                            </li>
                                                <?php } if (count($pendingTrainingCloseAttendence) > 0) {
                                                    ?>
                                            <li>
                                                <div class="md-list-addon-element">
                                                    <span class="md-user-letters md-bg-cyan"><?php echo count($pendingTrainingCloseAttendence); ?></span>
                                                </div>
                                                <div class="md-list-content">
                                                    <span class="md-list-heading"><a href="<?php echo $this->Html->url('/training/trainingAttendence') ?>">Pending Training Attendance.</a></span>
                                                    <span class="uk-text-small uk-text-muted">Close Attendance</span>
                                                </div>
                                            </li>
                                                    <?php
                                                } 
                                            }
                                            ?>
                                            <?php
                                            if ($this->Common->get_admin_option('training_module')) {
                                                if (($pendingTraining > 0) && ($TotalPnding > 0)) {
                                                    ?>  
                                            <li>
                                                <div class="md-list-addon-element">
                                                    <span class="md-user-letters md-bg-cyan"><?php echo $pendingTraining; ?></span>
                                                </div>
                                                <div class="md-list-content">
                                                    <span class="md-list-heading"><a href="<?php echo $this->Html->url('/training/manageTrainingIdentificationForm') ?>">Pending Training</a></span>
                                                    <span class="uk-text-small uk-text-muted">Pending Training request approval</span>
                                                </div>
                                            </li>
                                                    <?php
                                                }
                                            }
                                            ?>
                                                <?php    if ((($mailOfficeAlertCEO > 0) || ($mailOfficeAlertRMS > 0) || ($mailOfficeAlertBMS > 0) || ($mailOfficeAlertDIR > 0) || ($CAInvestigationAlertCEO > 0) || ($CAInvestigationAlertCQA > 0) )  && ($TotalPnding > 0)) {
                                                    
                                                    
                                                    if (($CAInvestigationAlertCEO > 0) && ($this->Common->check_access_right($auth['MyProfile']['emp_code'], $auth['MyProfile']['comp_code'], 'ceo_dashboard', 'approval'))) {
                                                        
                                                        ?>
                                            <li>
                                                <div class="md-list-addon-element">
                                                    <span class="md-user-letters md-bg-cyan"><?php echo $CAInvestigationAlertCEO; ?></span>
                                                </div>
                                                <div class="md-list-content">
                                                    <span class="md-list-heading"><a href="<?php echo $this->Html->url('/ComplianceAudit/compliant_received/') ?>">Request from investigation team</a></span>
                                                    <span class="uk-text-small uk-text-muted ">Pending to check</span>
                                                </div>
                                            </li>    
                                                        <?php
                                                        
                                                    }else{
                                                        if(($CAInvestigationAlertCQA > 0) && ($this->Common->check_access_right($auth['MyProfile']['emp_code'], $auth['MyProfile']['comp_code'], 'compliance_audit', 'approval'))) {
                                                        ?>
                                            <li>
                                                <div class="md-list-addon-element">
                                                    <span class="md-user-letters md-bg-cyan"><?php echo $CAInvestigationAlertCQA; ?></span>
                                                </div>
                                                <div class="md-list-content">
                                                    <span class="md-list-heading"><a href="<?php echo $this->Html->url('/ComplianceAudit/compliant_received_compliance_audit/') ?>">Investigation compliant received from CEO</a></span>
                                                    <span class="uk-text-small uk-text-muted ">Pending to check</span>
                                                </div>
                                            </li>    
                                                        <?php 
                                                        }
                                                    }
                                                    
                                                    if (($mailOfficeAlertCEO > 0) && ($this->Common->check_access_right($auth['MyProfile']['emp_code'], $auth['MyProfile']['comp_code'], 'ceo_dashboard', 'approval'))) {
                                                        
                                                        ?>
                                            <li>e
                                                <div class="md-list-addon-element">
                                                    <span class="md-user-letters md-bg-cyan"><?php echo $mailOfficeAlertCEO; ?></span>
                                                </div>
                                                <div class="md-list-content">
                                                    <span class="md-list-heading"><a href="<?php echo $this->Html->url('/Documents/mail_office_ceo_received/') ?>">Request from mail office</a></span>
                                                    <span class="uk-text-small uk-text-muted ">Pending to forward</span>
                                                </div>
                                            </li>    
                                                        <?php
                                                        
                                                    }else{
                                                        if(($mailOfficeAlertRMS > 0) && ($this->Common->check_access_right($auth['MyProfile']['emp_code'], $auth['MyProfile']['comp_code'], 'doc_module', 'approval'))) {
                                                        ?>
                                            <li>
                                                <div class="md-list-addon-element">
                                                    <span class="md-user-letters md-bg-cyan"><?php echo $mailOfficeAlertRMS; ?></span>
                                                </div>
                                                <div class="md-list-content">
                                                    <span class="md-list-heading"><a href="<?php echo $this->Html->url('/Documents/mail_received_listing/'.base64_encode('1')) ?>">Mail received from mail office</a></span>
                                                    <span class="uk-text-small uk-text-muted ">Pending to check</span>
                                                </div>
                                            </li>    
                                                        <?php 
                                                        }
                                                        if(($mailOfficeAlertBMS > 0) && ($this->Common->check_access_right($auth['MyProfile']['emp_code'], $auth['MyProfile']['comp_code'], 'bom_module', 'approval'))){
                                                         ?>
                                            <li>
                                                <div class="md-list-addon-element">
                                                    <span class="md-user-letters md-bg-cyan"><?php echo $mailOfficeAlertBMS; ?></span>
                                                </div>
                                                <div class="md-list-content">
                                                    <span class="md-list-heading"><a href="<?php echo $this->Html->url('/Documents/mail_received_listing/'.base64_encode('3')) ?>">Mail received from CEO</a></span>
                                                    <span class="uk-text-small uk-text-muted ">Pending to check</span>
                                                </div>
                                            </li> 
                                                        <?php   
                                                        }
                                                        if(($mailOfficeAlertDIR >0) && ($this->Common->check_access_right($auth['MyProfile']['emp_code'], $auth['MyProfile']['comp_code'], 'bom_module', 'approval'))){
                                                         ?>
                                            <li>
                                                <div class="md-list-addon-element">
                                                    <span class="md-user-letters md-bg-cyan"><?php echo $mailOfficeAlertDIR; ?></span>
                                                </div>
                                                <div class="md-list-content">
                                                    <span class="md-list-heading"><a href="<?php echo $this->Html->url('/Documents/mail_received_listing/'.base64_encode('4')) ?>">Mail received from CEO</a></span>
                                                    <span class="uk-text-small uk-text-muted ">Pending to check</span>
                                                </div>
                                            </li>     
                                                        <?php   
                                                        }
                                                    }
                                                    ?>

                                                    <?php
                                                }
                                                ?>
                                        </ul>
                                        <!--                                            <div class="uk-text-center uk-margin-top uk-margin-small-bottom">
                                                                                        <a href="page_mailbox.html" class="md-btn md-btn-flat md-btn-flat-primary js-uk-prevent">Show All</a>
                                                                                    </div>-->
                                    </li>
                                    <li aria-hidden="true">
                                        <ul class="md-list md-list-addon">
                                             <?php
                                  if($TotalSenc <=0 && $pendattendance<= 0){?>
                                            <span class="uk-text-small uk-text-muted"> &nbsp; &nbsp;&nbsp;&nbsp;Nothing Pending Found</span>

                                            <?php }
                                            if ($this->Common->get_admin_option('leave_module')) {
                                                
                                                if (($sanctionLeave > 0) && ($TotalSenc > 0)) {
                                                    ?>
                                            <li>
                                                <div class="md-list-addon-element">
                                                    <i class="md-user-letters md-bg-light-green"><?php echo $sanctionLeave; ?></i>
                                                </div>
                                                <div class="md-list-content">
                                                    <span class="md-list-heading"><a href="<?php echo $this->Html->url('/leaves/approval') ?>">Pending Leaves</a></span>
                                                    <span class="uk-text-small uk-text-muted ">Pending Leaves For Your Approval</span>
                                                </div>
                                            </li>
                                                    <?php
                                                }

}

                                                if ($pendattendance > 0 &&$penhrattendance > 0  )  {

                                                	
                                                    ?>
                                            <li>
                                                <div class="md-list-addon-element">
                                                    <span class="md-user-letters md-bg-light-green"><?php echo $pendattendance; ?></span>
                                                </div>
                                                <div class="md-list-content">
                                                    <span class="md-list-heading"><a href="<?php echo $this->Html->url('/users/hr_attendance_approve') ?>">Pending Attendance</a></span>
                                                    <span class="uk-text-small uk-text-muted"> Pending Attendance for Your Approval</span>
                                                </div>
                                            </li>
                                                    <?php
                                                }

                                                else{

                                                if ($pendattendance > 0 )  {


                                                    ?>
                                            <li>
                                                <div class="md-list-addon-element">
                                                    <span class="md-user-letters md-bg-light-green"><?php echo $pendattendance; ?></span>
                                                </div>
                                                <div class="md-list-content">
                                                    <span class="md-list-heading"><a href="<?php echo $this->Html->url('/users/attendance_approve') ?>">Pending Attendance</a></span>
                                                    <span class="uk-text-small uk-text-muted"> Pending Attendance for Your Approval</span>
                                                </div>
                                            </li>
                                                    <?php
                                                }
                                            }
                                         if ($this->Common->get_admin_option('Recruitment_Module')) {
                                                if (($sanctionRequisition > 0) && ($TotalSenc > 0)) {
                                                    ?>
                                            <li>
                                                <div class="md-list-addon-element">
                                                    <i class="md-user-letters md-bg-light-green"><?php echo $sanctionRequisition; ?></i>
                                                </div>
                                                <div class="md-list-content">
                                                    <span class="md-list-heading"><a href="<?php echo $this->Html->url('/Recruitment/approval') ?>">Pending Requisition</a></span>
                                                    <span class="uk-text-small uk-text-muted ">Pending Requisition For Your Approval</span>
                                                </div>
                                            </li>
                                                    <?php
                                                }
                                                

                                            } if ($this->Common->get_admin_option('conveyance_module')) {
                                                if (($sanctionConv > 0) && ($TotalSenc > 0)) {
                                                    ?>          
                                            <li>
                                                <div class="md-list-addon-element">
                                                    <i class="md-user-letters md-bg-light-green"><?php echo $sanctionConv; ?></i>
                                                </div>
                                                <div class="md-list-content">
                                                    <span class="md-list-heading"><a href="<?php echo $this->Html->url('/conveyence_expenses/approval') ?>">Pending Conveyance</a></span>
                                                    <span class="uk-text-small uk-text-muted ">Pending Conveyance For Your Approval</span>
                                                </div>
                                            </li>
                                                    <?php
                                                }
                                            } 
                                            if ($this->Common->get_admin_option('timesheet')) {
                                                if (($sanctionTimesheet > 0) && ($TotalSenc > 0)) {
                                                    ?>          
                                            <li>
                                                <div class="md-list-addon-element">
                                                    <i class="md-user-letters md-bg-light-green"><?php echo $sanctionTimesheet; ?></i>
                                                </div>
                                                <div class="md-list-content">
                                                    <span class="md-list-heading"><a href="<?php echo $this->Html->url('/timesheet/sanctionedlist') ?>">Pending Conveyance</a></span>
                                                    <span class="uk-text-small uk-text-muted ">Pending Conveyance For Your Approval</span>
                                                </div>
                                            </li>
                                                    <?php
                                                }
                                            }
                                            
                                            if ($this->Common->get_admin_option('travel_module')) {
                                                if (($sanctionTravel > 0) && ($TotalSenc > 0)) {
                                                    ?>
                                            <li>
                                                <div class="md-list-addon-element">
                                                    <i class="md-user-letters md-bg-light-green"><?php echo $sanctionTravel; ?></i>
                                                </div>
                                                <div class="md-list-content">
                                                    <span class="md-list-heading"> <a href="<?php echo $this->Html->url('/travels/approval') ?>">Pending Travel</a></span>
                                                    <span class="uk-text-small uk-text-muted "> Pending Travel For Your Approval</span>
                                                </div>
                                            </li>
                                                    <?php
                                                }
                                            } if ($this->Common->get_admin_option('temporary_component')) {
                                                if (($sanctionTemp > 0) && ($TotalSenc > 0)) {
                                                    ?>                                                
                                            <li>
                                                <div class="md-list-addon-element">
                                                    <span class="md-user-letters md-bg-light-green"><?php echo $sanctionTemp; ?></span>
                                                </div>
                                                <div class="md-list-content">
                                                    <span class="md-list-heading"><a href="<?php echo $this->Html->url('/temporary_components/approval') ?>">Approval Pending Temporary Comp.</a></span>
                                                    <span class="uk-text-small uk-text-muted">Temporary Components Pending for Approval</span>
                                                </div>
                                            </li>
                                                    <?php
                                                }
                                            } if ($this->Common->get_admin_option('training_module')) {
                                                if (($sanctionTraining > 0) && ($TotalSenc > 0)) {
                                                    ?>                                                        <li>
                                                <div class="md-list-addon-element">
                                                    <span class="md-user-letters md-bg-light-green"><?php echo $sanctionTraining; ?></span>
                                                </div>
                                                <div class="md-list-content">
                                                    <span class="md-list-heading"><a href="<?php echo $this->Html->url('/training/sanctionTrainingRequests') ?>">Training Request Approval</a></span>
                                                    <span class="uk-text-small uk-text-muted">Training Request for Approval</span>
                                                </div>
                                            </li>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </ul>
                                    </li>
                                     <li aria-hidden="">
                                    
                                          <?php if($TotalKRA <= 0){?>
                                        <span class="uk-text-small uk-text-muted"> &nbsp; &nbsp;&nbsp;&nbsp;No Pending Alert Found</span>

                                        <?php } if ($this->Common->get_admin_option('Recruitment_Module')) { ?>
                                        <ul class="md-list md-list-addon">

  
                                                <?php if ($reqalert > 0) { ?>
                                            <li>
                                                <div class="md-list-addon-element">
                                                     <span class="md-user-letters md-bg-light-green"><?php echo $Requisitionlist?></span>
                                                </div>
                                                <div class="md-list-content">
                                                    <span class="md-list-heading"><a href="<?php echo $this->Html->url('/Recruitment/opening') ?>">Latest Opening</a></span>
                                                    <span class="uk-text-small uk-text-muted ">Recruitment For Internal and External Hiring </span>
                                                </div>
                                            </li>
                                                    <?php
                                                }
                                               ?>
                                                <?php if ($interalert > 0) { ?>
                                            <li>
                                                <div class="md-list-addon-element">
                                                     <span class="md-user-letters md-bg-light-green"><?php echo $interviewList;?></span>
                                                </div>
                                                <div class="md-list-content">
                                                    <span class="md-list-heading"><a href="<?php echo $this->Html->url('/Recruitment/Scheduledintlist') ?>"> Current Interview Scheduled</a></span>
                                                    <span class="uk-text-small uk-text-muted ">Interview Scheduled For Internal and External Hiring </span>
                                                </div>
                                            </li>
                                                    <?php
                                                }
                                               ?>
                                        </ul>
                                        <?php } ?>
                                    </li>
                                    <li aria-hidden="">
                                        <?php if ($this->Common->get_admin_option('appraisal_module')) { ?>
                                            <ul class="md-list md-list-addon">
                                                
                                                <?php if ($kraAlert == 1) { ?>
                                                    <li>
                                                        <div class="md-list-addon-element">
                                                            <i class="md-list-addon-icon material-icons uk-text-primary">&#xE88E;</i>
                                                        </div>
                                                        <div class="md-list-content">
                                                            <span class="md-list-heading"><a href="<?php echo $this->Html->url('/KraMasters/addKraTarget') ?>">Add KRAs & Targets</a></span>
                                                            <span class="uk-text-small uk-text-muted ">Please add KRAs & Targets for current financial year.</span>
                                                        </div>
                                                    </li>
                                                    <?php
                                                }
												if ($midreviewAlert == 1 && ($kra_config['MstPmsConfig']['mid_review'] == 1)) {
                                                    ?>
                                                    <li>
                                                        <div class="md-list-addon-element">
                                                            <i class="md-list-addon-icon material-icons uk-text-primary">&#xE88E;</i>
                                                        </div>
                                                        <div class="md-list-content">
                                                            <span class="md-list-heading"><a href="<?php echo $this->Html->url('/KraMasters/viewAllMidEmpKraTarget') ?>">Mid Review Process</a></span>
                                                            <span class="uk-text-small uk-text-muted ">Mid Review Pending as a Appraisee</span>
                                                        </div>
                                                    </li>
                                                <?php }
                                                if ($appraisalAlert == 1) {
                                                    ?>
                                                    <li>
                                                        <div class="md-list-addon-element">
                                                            <i class="md-list-addon-icon material-icons uk-text-primary">&#xE88E;</i>
                                                        </div>
                                                        <div class="md-list-content">
                                                            <span class="md-list-heading"><a href="<?php echo $this->Html->url('/KraMasters/viewAllAnnEmpKraTarget') ?>">Appraisal Process</a></span>
                                                            <span class="uk-text-small uk-text-muted ">Annual Appraisal Pending as a Appraisee</span>
                                                        </div>
                                                    </li>
                                                <?php } if ($kraReverAlert == 1) { ?>                                               
                                                    <li>
                                                        <div class="md-list-addon-element">
                                                            <i class="md-list-addon-icon material-icons uk-text-primary">&#xE88E;</i>
                                                        </div>
                                                        <div class="md-list-content">
                                                            <span class="md-list-heading"><a href="<?php echo $this->Html->url('/KraMasters/viewAllEmpKraTarget') ?>">Revert KRA Target</a></span>
                                                            <span class="uk-text-small ">Please edit KRAs & Targets as a Appraisee</span>
                                                        </div>
                                                    </li> 
                                                <?php } 
												
												if ($midreviewAppAlert == 1 && ($kra_config['MstPmsConfig']['mid_review'] == 1)) { ?>                                                
                                                    <li>
                                                        <div class="md-list-addon-element">
                                                            <i class="md-list-addon-icon material-icons uk-text-primary">&#xE88E;</i>
                                                        </div>
                                                        <div class="md-list-content">
                                                            <span class="md-list-heading"><a href="<?php echo $this->Html->url('/KraMasters/viewAllMidAppraiserKraTarget') ?>">Employee Forwarded KRAs Mid Reviews</a></span>
                                                            <span class="uk-text-small uk-text-muted ">Mid Reviews Pending as a Appraiser</span>
                                                        </div>
                                                    </li>
													<?php }
													if ($appraiserAlert == 1) { ?>                                                
                                                    <li>
                                                        <div class="md-list-addon-element">
                                                            <i class="md-list-addon-icon material-icons uk-text-primary">&#xE88E;</i>
                                                        </div>
                                                        <div class="md-list-content">
                                                            <span class="md-list-heading"><a href="<?php echo $this->Html->url('/KraMasters/viewAllAppraiserKraTarget') ?>">Employee KRAs & Targets Approval</a></span>
                                                            <span class="uk-text-small uk-text-muted ">KRA Approval Pending as a Appraiser</span>
                                                        </div>
                                                    </li>
													<?php } 
													if ($midreviewRevAlert == 1 && ($kra_config['MstPmsConfig']['mid_review'] == 1)) { ?>                                                
                                                    <li>
                                                        <div class="md-list-addon-element">
                                                            <i class="md-list-addon-icon material-icons uk-text-primary">&#xE88E;</i>
                                                        </div>
                                                        <div class="md-list-content">
                                                            <span class="md-list-heading"><a href="<?php echo $this->Html->url('/KraMasters/viewAllMidReviewerKraTarget') ?>">Employee Forwarded KRAs Mid Reviews</a></span>
                                                            <span class="uk-text-small uk-text-muted ">Mid Reviews Pending as a Reviewer</span>
                                                        </div>
                                                    </li>
                                                <?php }
												if ($reviewerAlert == 1) { ?>                                                
                                                    <li>
                                                        <div class="md-list-addon-element">
                                                            <i class="md-list-addon-icon material-icons uk-text-primary">&#xE88E;</i>
                                                        </div>
                                                        <div class="md-list-content">
                                                            <span class="md-list-heading"><a href="<?php echo $this->Html->url('/KraMasters/viewAllReviewerKraTarget') ?>">Employee Forwarded KRAs & Targets Approval</a></span>
                                                            <span class="uk-text-small uk-text-muted ">KRA Approval Pending as a Reviewer</span>
                                                        </div>
                                                    </li>
                                                <?php } if ($midreviewModAlert == 1 && ($kra_config['MstPmsConfig']['mid_review'] == 1)) { ?>                                                
                                                    <li>
                                                        <div class="md-list-addon-element">
                                                            <i class="md-list-addon-icon material-icons uk-text-primary">&#xE88E;</i>
                                                        </div>
                                                        <div class="md-list-content">
                                                            <span class="md-list-heading"><a href="<?php echo $this->Html->url('/KraMasters/viewAllMidModeratorKraTarget') ?>">Employee Forwarded Mid Reviews KRAs & Targets</a></span>
                                                            <span class="uk-text-small uk-text-muted ">Mid Reviews Pending as a Moderator</span>
                                                        </div>
                                                    </li>
                                                <?php }
												if ($selfScoreAlert == 1) { ?>                                                
                                                    <li>
                                                        <div class="md-list-addon-element">
                                                            <i class="md-list-addon-icon material-icons uk-text-primary">&#xE88E;</i>
                                                        </div>
                                                        <div class="md-list-content">
                                                            <span class="md-list-heading"><a href="<?php echo $this->Html->url('/KraMasters/viewAllAnnAppraiserKraTarget') ?>">Employee Forwarded Annual KRAs & Targets</a></span>
                                                            <span class="uk-text-small uk-text-muted ">Annual Appraisal Pending as a Appraiser</span>
                                                        </div>
                                                    </li>
                                                <?php } ?>
                                                <?php if ($reviewerSelfScoreAlert == 1) { ?>                                                
                                                    <li>
                                                        <div class="md-list-addon-element">
                                                            <i class="md-list-addon-icon material-icons uk-text-primary">&#xE88E;</i>
                                                        </div>
                                                        <div class="md-list-content">
                                                            <span class="md-list-heading"><a href="<?php echo $this->Html->url('/KraMasters/viewAllAnnReviewerKraTarget') ?>">Employee Forwarded Annual Scores of KRAs & Targets</a></span>
                                                            <span class="uk-text-small">Annual Appraisal Pending as a Reviewer</span>
                                                        </div>
                                                    </li>
                                                <?php } ?>
                                                <?php if ($moderatorSelfScoreAlert == 1) { ?>                                                
                                                    <li>
                                                        <div class="md-list-addon-element">
                                                            <i class="md-list-addon-icon material-icons uk-text-primary">&#xE88E;</i>
                                                        </div>
                                                        <div class="md-list-content">
                                                            <span class="md-list-heading"><a href="<?php echo $this->Html->url('/KraMasters/viewAllAnnModeratorKraTarget') ?>">Reviewer Forwarded Annual Scores of KRAs & Targets</a></span>
                                                            <span class="uk-text-small uk-text-muted ">Annual Appraisal Pending as a Moderator</span>
                                                        </div>
                                                    </li>
                                                <?php } ?>

                                            </ul>
                                        <?php } ?>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </li>                        
                    <li data-uk-dropdown="{mode:'click',pos:'bottom-right'}">                            
                        <a href="#" class="user_action_image">
                            <?php if (!empty($auth['MyProfile']['image'])) { ?>
                            <img src="<?php echo $this->webroot . 'uploads/profile/' . $auth['MyProfile']['image']; ?>" class="md-user-image" alt="User Image" />
                            <?php } else { ?>
                            <img src="<?php echo $this->webroot . "images/no_image.png"; ?>" class="md-user-image" alt="User Image" />
                            <?php } ?>                                
                        </a>
                        <div class="uk-dropdown uk-dropdown-small">
                            <ul class="uk-nav js-uk-prevent">
                                <li><a href="<?php echo $this->Html->url('/users/myprofile') ?>">My profile</a></li>
                               <!-- <li><a href="<?php echo $this->Html->url('/users/setting') ?>">Settings</a></li> -->
                                <li><a href="<?php echo $this->Html->url('/users/logout') ?>">Logout</a></li>
                            </ul>
                        </div>
                    </li>
                    <li class="md-color-grey-50 uk-text-bold margin-top"><?php echo "Welcome, " . $empFisrtName; ?></li></br>
                    <li class="md-color-grey-50 uk-text-bold margin-bottom"> 
                                <?php echo ucfirst(strtolower($this->Common->findDesignationName($auth['MyProfile']['desg_code'], $auth['User']['comp_code']))); ?>
                    </li> 
                </ul>
            </div>
        </nav>
    </div>
    <div class="header_main_search_form">
        <i class="md-icon header_main_search_close material-icons">ï¿½?</i>
        <form class="uk-form">
            <input type="text" class="header_main_search_input">
            <button class="header_main_search_btn uk-button-link"><i class="md-icon material-icons">î¢¶</i></button>
        </form>
    </div>
</header>
<!--<div style="float: left;margin-left: 360px;align-items: center;">
<form id="langauge_form" method="post" action="<?php echo $this->webroot ?>users/language">
		<select id="select_langauage" name="langu" onChange="this.form.submit();">
				<option><?php echo __d('debug_kit', 'Select'); ?></option>
				<option <?php echo ($this->Session->read('Config.language') == 'en')? 'selected':'';?> value="en">English</option>
				<option <?php echo ($this->Session->read('Config.language') == 'hin')? 'selected':'';?> value="hin">हिंदी</option>
				<option <?php echo ($this->Session->read('Config.language') == 'fr')? 'selected':'';?> value="fr">français</option>
				<option <?php echo ($this->Session->read('Config.language') == 'ara')? 'selected':'';?> value="ara">عربى</option>
	
		</select>
</form>
</div>-->
