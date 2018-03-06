<?php

//echo $kraScore; echo $kraScorePos;echo $kraScoreIncAmt; die('herer');?>
<div id="popup1" class="HRoverlay">
    <div class="HRpopup">
        <a class="HRclose" href="#">×</a>
        <div class="HRcontent"> </div>
    </div>
</div>
<?php $i = 0; ?>
<?php if ($isRejected) { ?>
<div class="highlight-notice-box">
    <b>Note:</b> This appraisal has been sent to you by <?php echo $sentBy; ?> for review. Reason: <?php echo ($appraisalRequest['Appraisals']['review_reason'] == '') ? '<em>Not Specified</em>' : $appraisalRequest['Appraisals']['review_reason']; ?>
</div>
<?php } ?>
<?php
echo $this->Form->create('Appraisals', array(
    'id' => 'AppraisalprSheetEditHtml',
    'url' => '/appraisal/prSheetEditJson',
    'inputDefaults' => array(
        'label' => false,
        'div' => false,
        'error' => array(
            'wrap' => 'span',
            'class' => 'my-error-class'
        )
    )
        )
);
?>
<div role="main" class="right_col">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h2 class="demoheaders">Appraisal Sheet</h2>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="row">
            <div class="clearfix"></div>
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">

                    <div class="x_content">

                        <div class="RejectedLeave " role="tabpanel" data-example-id="togglable-tabs">
                            <ul id="myTab" class="nav nav-tabs bar_tabs " role="tablist">
                                <li role="presentation" class="active"><a href="#details" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">Details</a> </li>
                                <?php  if (!$isAppraisee) { ?>
                                <li role="presentation" class="active"><a href="#consolidate" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">Consolidated Sheet</a></li>
                                <?php } ?>
                                <?php
                                if ($isPeer == 1) {
                                  
                                    foreach ($appraisalRequest['Appraisers'] as $appraiser) {
                                        if ($appraiser['emp_code_appraiser'] == $isPeerId) {
                                            ?>
                                <li role="presentation" class=""><a href="#appraiser<?php echo $appraiser['id']; ?>" data-toggle="tab" aria-expanded="false"><span><?php echo $appraiser['MyProfile']['emp_name']; ?></span></a></li>    
                                        <?php } ?> 
                                        <?php
                                    }
                                } else {
                                     
                                    ?>
                                    <?php                                   
                                    foreach ($appraisalRequest['Appraisers'] as $appraiser) {
                                        
                                        if ($appraiser['skip_status'] != 1) {
                                            
                                            ?>
                                <li role="presentation" class=""><a href="#appraiser<?php echo $appraiser['id']; ?>" data-toggle="tab"><span><?php echo $appraiser['MyProfile']['emp_name']; ?></span><?php
                                                    foreach ($peerlist as $k => $val) {
                                                        if ($appraiser['emp_code_appraiser'] == $k) {
                                                            ?>
                                                            <?php if ($appraiser['dt_appraise'] == NULL) { ?>       
                                        <span> <input class='btn btn-xs' id ='skippeer' type='submit' value='skip'></span>
                                        <input type='hidden' id='skippeerid' value='<?php echo $appraiser['id']; ?>'>
                                        <input type='hidden' id='skippeerapp_id' value='<?php echo $appraiser['Appraisals']['id']; ?>'>     
                                                                <?php
                                                            }
                                                        }
                                                    }
                                                    ?></a>

                                                <?php if ($appraiser['dt_appraise'] == '') break; ?>   
                                                <?php
                                            }
                                        }
                                        ?>
                                    <?php } ?>

                            </ul>

                            <div id="myTabContent" class="tab-content">
                                <div role="tabpanel" class="tab-pane fade active in" id="details" aria-labelledby="home-tab"> 

                                    <!-- Start Details Information -->
                                    <div class="x_panel">
                                        <div class="x_title">
                                          <h2 class="RejectedLeave">Details <!--<small>sub title</small>--></h2>

                                            <div class="clearfix"></div>
                                        </div>
                                        <div class="x_content"> <br />
                                            <div id="details">
                                                <table class="table"  cellspacing="1" cellpadding="5" width="910px" border="0">
                                                    <tr class="cont">
                                                        <th class="ForwardLeave">Name:</th>
                                                        <td><?php echo $appraisalRequest['MyProfile']['emp_firstname']; ?></td>
                                                    </tr>
                                                    <tr class="ForwardLeave">
                                                        <th>Period:</th>
                                                        <td><?php echo date('d-m-Y', strtotime($appraisalRequest['Appraisals']['dt_fromDate'])); ?> To <?php echo date('d-m-Y', strtotime($appraisalRequest['Appraisals']['dt_toDate'])); ?></td>
                                                    </tr>
                                                    <tr class="ForwardLeave">
                                                        <th>Date (w.e.f):</th>
                                                        <td><?php echo date('d-m-Y', strtotime($appraisalRequest['Appraisals']['dt_appraisal'])); ?></td>
                                                    </tr>
                                                </table>

                                                <?php if (!$isAppraisee) { ?>
                                                <table class="table" >
                                                    <tr class="head">
                                                        <th class="RejectedLeave">
                                                            HR Factors
                                                        </th>
                                                    </tr>
                                                    <tr class="ForwardLeave">
                                                        <td>Total Yearly Incentive/12:</td>
                                                        <td><?php
                                                                if ($appraisalRequest['Appraisals']['yr_inct']) {
                                                                    echo $appraisalRequest['Appraisals']['yr_inct'];
                                                                } else {
                                                                    ?>
                                                        <td>N/A</td>    
                                                            <?php } ?>    
                                                        </td>
                                                        <td>Department:</td>
                                                        <td><?php echo $appraisalRequest['Departments']['dept_name']; ?></td>
                                                    </tr>
                                                    <tr class="cont1">

                                                    </tr>
                                                    <tr class="PendingLeave">
                                                        <td>Date of Joining</td>

                                                        <td><?php echo date('d-m-Y', strtotime($appraisalRequest['Appraisals']['dt_join'])); ?></td>
                                                        <td></td>
                                                        <td></td>
                                                    </tr>
                                                    <tr class="ForwardLeave">
                                                        <td>Experience with ESS (in Months)</td>

                                                        <td><?php echo $appraisalRequest['Appraisals']['ess_exp']; ?></td>
                                                        <td>Total Experience (in Months)</td>

                                                        <td><?php echo $appraisalRequest['Appraisals']['tot_exp']; ?></td>
                                                    </tr>
                                                    <tr class="PendingLeave">
                                                        <td>Present Salary</td>

                                                        <td><?php
                                                                if ($appraisalRequest['Appraisals']['gross_sal']) {
                                                                    echo $appraisalRequest['Appraisals']['gross_sal'];
                                                                } else {
                                                                    ?>
                                                            <p>N/A</p>    
                                                                <?php } ?>    
                                                        </td>
                                                        <td>Date of Last Promotion</td>

                                                        <td><?php echo ($appraisalRequest['Appraisals']['last_prmt'] == "") ? "N/A" : date('d-m-Y', strtotime($appraisalRequest['Appraisals']['last_prmt'])); ?></td>
                                                    </tr>
                                                    <tr class="ForwardLeave">
                                                        <td>Monthly House Rent(if any)</td>

                                                        <td><?php echo $appraisalRequest['Appraisals']['hra_amt']; ?></td>
                                                        <td>Amount of Last Increment</td>

                                                        <td><?php echo $appraisalRequest['Appraisals']['amt_lst_inc']; ?></td>
                                                    </tr>
                                                    <tr class="PendingLeave">
                                                        <td>Category</td>

                                                        <td><?php echo $categories[$appraisalRequest['Appraisals']['slab_category_id']]; ?></td>
                                                        <td colspan="2"></td>
                                                    </tr>  
                                                    <tr class="ForwardLeave">
                                                        <td>Applicable Slab</td>
                                                        <td colspan="3">
                                                                <?php if (!empty($slabs)) { ?>
                                                                    <?php $applicableSlab = array(); ?>
                                                                    <?php foreach ($performances as $key => $performance): ?>
                                                                        <?php if ($key != 0) { ?>
                                                                            <?php $applicableSlab[] = $performance . " (" . $slabs[$key] . ")"; ?>
                                                                        <?php } ?>
                                                                    <?php endforeach; ?>
                                                                    <?php echo implode(", ", $applicableSlab); ?>
                                                                <?php } else { ?>
                                                            <em>-None-</em>
                                                                <?php } ?>
                                                        </td>
                                                    </tr>

                                                </table>

                                                <!--------------------Start KRA Competency Group------------------>
                                                <div class="x_title">
                                                    <h2>Kra Competency Group</h2>
                                                    <div class="clearfix"></div>
                                                </div>
                                                <table class="table table-striped responsive-utilities jambo_table bulk_action">
                                                <?php $i=1;foreach($krlist as $kraListValue)  {
                                        $kpiVal=$this->common->getKpiDetail($kraListValue['KpiMapEmps']['kpi_masters_id']);
                                    ?>
                                                    <tr class="even pointer">
                                                        <td><?php echo $i;?></td>
                                                        <td><?php echo $this->common->getKraName($kpiVal['kpi_masters']['kra_id'])."<br/>".$kpiVal['kpi_masters']['kpi_name']; ?></td>
                                        <?php 
                                        $kraUnitslists=$this->common->getEmployeesUnitsByKra($kraListValue['KpiMapEmps']['kra_masters_id'], $kraListValue['KpiMapEmps']['kpi_masters_id'], $kraListValue['KpiMapEmps']['myprofile_id'], $kraListValue['KpiMapEmps']['id']);
                                        if(!empty($kraUnitslists)){
                                            foreach ($kraUnitslists as $kraUnitslist) {
                                                $tsum+=$kraUnitslist['kra_kpi_process']['units'];
                                            }
                                            echo "<td>".number_format($tsum / count($kraUnitslists), 2, '.', '')." (".$this->common->empKraKpiSlab(number_format($tsum / count($kraUnitslists), 2, '.', '')).")</td>";
                                            $totalAvgSum+=number_format($tsum / count($kraUnitslists), 2, '.', '');
                                            unset($tsum);
                                        }
                                        ?>
                                                    </tr>
                                    <?php $i++; }?>
                                                    <tr>
                                                        <td></td>
                                                        <td>Overall Rating</td>
                                                        <td><?php echo number_format($totalAvgSum / count($krlist), 2, '.', '')." (".$this->common->empKraKpiSlab(number_format($totalAvgSum / count($krlist), 2, '.', '')).")"; 
                                                        ?>
                                                        </td>
                                                    </tr>
                                                </table>
                                                <!--------Ends KRA Competency Group------------------>
                                                <?php if(!empty($complist)) {?>
                                                <!--------------------Start KRA Competency Group------------------>
                                                <div class="x_title">
                                                    <h2>Competency Competency Group</h2>
                                                    <div class="clearfix"></div>
                                                </div>
                                                <table class="table table-striped responsive-utilities jambo_table bulk_action">
                                                <?php $i=1;foreach($complist as $kraListValue)  {
                                        $kpiVal=$this->common->getKpiDetail($kraListValue['KpiMapEmps']['kpi_masters_id']);
                                    ?>
                                                    <tr class="even pointer">
                                                        <td><?php echo $i;?></td>
                                                        <td><?php echo $this->common->getKraName($kpiVal['kpi_masters']['kra_id'])."<br/>".$kpiVal['kpi_masters']['kpi_name']; ?></td>
                                        <?php 
                                        $kraUnitslists=$this->common->getEmployeesUnitsByKra($kraListValue['KpiMapEmps']['kra_masters_id'], $kraListValue['KpiMapEmps']['kpi_masters_id'], $kraListValue['KpiMapEmps']['myprofile_id'], $kraListValue['KpiMapEmps']['id']);
                                        if(!empty($kraUnitslists)){
                                            foreach ($kraUnitslists as $kraUnitslist) {
                                                $tsum+=$kraUnitslist['kra_kpi_process']['units'];
                                            }
                                            echo "<td>".number_format($tsum / count($kraUnitslists), 2, '.', '')." (".$this->common->empKraKpiSlab(number_format($tsum / count($kraUnitslists), 2, '.', '')).")</td>";
                                            $totalAvgSum+=number_format($tsum / count($kraUnitslists), 2, '.', '');
                                            unset($tsum);
                                        }
                                        ?>
                                                    </tr>
                                    <?php $i++; }?>
                                                </table>
                                                <?php } ?>
                                                <!--------Ends KRA Competency Group------------------>
                                                <table class="table table-striped responsive-utilities jambo_table bulk_action" >
                                                    <tr class="head">
                                                        <th class="RejectedLeave">
                                                            APPRAISAL HISTORY
                                                        </th>
                                                    </tr>                
                                                    <tr >
                                                        <th>
                                                            Period of Appraisal
                                                        </th>
                                                        <th>
                                                            Rating
                                                        </th>
                                                        <th>
                                                            Salary before appraisal
                                                        </th>
                                                        <th>
                                                            Increment Amount 
                                                        </th>
                                                        <th>
                                                            Remark
                                                        </th>                    
                                                    </tr>
                                                        <?php $i = 1; ?>
                                                        <?php foreach ($appraisalRequest_last_five as $appraisal_one_of_five) { ?>
                                                    <tr class="cont<?php echo ($i % 2) ? '' : '1' ?>">
                                                                <?php $i++; ?>
                                                        <td>
                                                                    <?php echo date('d-m-Y', strtotime($appraisal_one_of_five['Appraisals']['dt_fromDate'])); ?>
                                                                    <?php echo date('d-m-Y', strtotime($appraisal_one_of_five['Appraisals']['dt_toDate'])); ?>
                                                        </td>
                                                        <td>
                                                                    <?php echo $performances[$appraisal_one_of_five['Appraisals']['rating']]; ?>
                                                        </td>
                                                        <td>
                                                                    <?php echo $appraisal_one_of_five['Appraisals']['gross_sal']; ?>
                                                        </td>
                                                        <td>
                                                                    <?php echo $appraisal_one_of_five['Appraisals']['amt_inc']; ?>
                                                        </td>
                                                        <td>
                                                                    <?php echo $appraisal_one_of_five['Appraisals']['remark']; ?>
                                                        </td>                    
                                                    </tr>                    
                                                        <?php } ?>
                                                        <?php if (count($appraisalRequest_last_five) == 0) { ?>
                                                    <tr class="cont">
                                                        <td colspan="5" style="text-align: center;">
                                                            <em>-No Pervious Appraisals-</em>
                                                        </td>
                                                    </tr>
                                                        <?php } ?>
                                                </table>

                                               <?php if(!empty($kra)){  ?>
                                                <h4> Kra History </h4>
                                                <table class="table table-striped responsive-utilities jambo_table bulk_action">

                                                    <thead>
                                                        <tr class="headings">

                                                            <th class="column-title">Sr.No </th>
                                                            <th class="column-title">Kra Name </th>
                                                            <th class="column-title">Kpi Name </th>
                                                            <th class="column-title"> From Date</th>
                                                            <th class="column-title">To Date     </th>
                                                            <th class="column-title">weightage </th>
                                                            <th class="column-title">Overall Score </th>

                                                        </tr>
                                                    </thead>
                                                    <tbody>

                                                        <?php if(empty($kra))  { ?>
                                                        <tr class="even pointer">
                                                            <td style="text-align:center;" colspan="11">
                                                                <em>--No Records Found--</em>
                                                            </td>
                                                        </tr>
                                                    <?php } ?>

                                                   <?php  foreach ($kra as $kraValue)  {
                                                          if($i%2==0)$class='even pointer'; else $class='odd pointer';?>
                                                        <tr class="even pointer">
                                                            <td><?php echo $i+1;//echo $srcdet['MstEmpExpVoucher']['voucher_id'];?></td> 
                                                            <td><?php echo $kraValue['kra_name']; ?></td>
                                                            <td><?php echo $kraValue['kpi_name']; ?></td>
                                                            <td><?php echo $kraValue['from_date']; ?></td>
                                                            <td><?php echo $kraValue['to_date'];?></td>
                                                            <td><?php echo $kraValue['weightage']; ?></td>
                                                            <td><?php echo $kraValue['overall Score']; ?></td>
                                                        </tr>
                                                   <?php $i++ ;} ?>
                                                    </tbody>
                                                </table>
                                                <?php }} ?>
                                            </div>
                                        </div>

                                    </div>

                                </div>
                                <!-- End Details Information --> 

                                <!----------------------- start consolidate -------------------------------------->
                                <?php if (!$isAppraisee) { ?>
                                <div id="consolidate" class="tab-pane fade active in">
                                    <div class="x_panel">
                                        <div class="x_title">
                                          <h2 class="RejectedLeave">Consolidate sheet <!--<small>sub title</small>--></h2>
                                            <div class="clearfix"></div>
                                        </div>
                                        <div class="x_content"> <br />
                                                <?php
                                                $Ratings = array();
                                                $Factors = array();
                                                ?>
                                            <table class="table" >
                                                <tr class="head">
                                                    <td class="RejectedLeave">
                                                        Factor Name
                                                    </td>                            
                                                        <?php
                                                        $key = 0;
                                                        foreach ($appraisalRequest['Appraisers'] as $appraiser) {
                                                            ?>
                                                            <?php if (!empty($appraiser['dt_appraise'])) { ?>

                                                    <td>
                                                                    <?php echo $appraiser['MyProfile']['emp_name']; ?>
                                                    </td>
                                                                <?php foreach ($appraiser['Appraisalratings'] as $rating) { ?>
                                                                    <?php $Ratings[$appraiser['emp_code_appraiser']][$rating['factor_id']] = array('rating_id' => $rating['rating_id'], 'remarks' => $rating['remarks']); ?>
                                                                    <?php $Factors[$rating['factor_id']] = $rating['Appraisalfactors']['factor_name']; ?>
                                                                <?php } ?>
                                                            <?php } ?>
                                                            <?php
                                                            $key = $key + 1;
                                                        }
                                                        ?>
                                                </tr>
                                                    <?php $zebraClass = ""; ?>

                                                    <?php
                                                    $rate = 0;
                                                    foreach ($Factors as $key => $factor):
                                                        ?>  
                                                <tr class="ForwardLeave">
                                                    <td>
                                                        <b><?php echo $factor; ?></b>
                                                    </td>       

                                                            <?php foreach ($appraisalRequest['Appraisers'] as $appraiser) { ?> 
                                                                <?php if (!empty($appraiser['dt_appraise'])) { ?>
                                                    <td>
                                                                        <?php echo $performances[$appraiser['Appraisalratings'][$rate]['rating_id']]; ?>
                                                    </td>
                                                                <?php } ?> 
                                                            <?php } ?>                            
                                                </tr>

                                                        <?php
                                                        $rate = $rate + 1;
                                                    endforeach;
                                                    ?>
                                                <tr >
                                                    <td class="RejectedLeave">
                                                        <b>Increment As per Company Policy:</b>
                                                    </td>                            
                                                        <?php foreach ($appraisalRequest['Appraisers'] as $appraiser) { ?>
                                                            <?php if (!empty($appraiser['dt_appraise'])) { ?>
                                                    <td class="ForwardLeave">
                                                                    <?php echo $appraiser['Appraisalcomments']['amt_inc_standard']; ?>
                                                    </td>
                                                            <?php } else { ?>
                                                <p></p>   
                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                </tr>
                                                <!--tr class="<?php //echo $zebraClass = ($zebraClass == "cont") ? "cont1" : "cont";           ?>">
                                                    <td>
                                                        <b>Increment recommended:</b>
                                                    </td>                            
                                                    <?php foreach ($appraisalRequest['Appraisers'] as $appraiser) { ?>
                                                        <?php if (!empty($appraiser['dt_appraise'])) { ?>
                                                                                                                                                    <td>
                                                            <?php echo $appraiser['Appraisalcomments']['amt_inc_recommended']; ?>
                                                                                                                                                    </td>
                                                        <?php } ?>
                                                    <?php } ?>
                                                </tr-->
                                                <tr class="<?php echo $zebraClass = ($zebraClass == "cont") ? "cont1" : "cont"; ?>">
                                                    <td class="">
                                                        <b>Remarks for staff member:</b>
                                                    </td>                            
                                                        <?php foreach ($appraisalRequest['Appraisers'] as $appraiser) { ?>
                                                            <?php if (!empty($appraiser['dt_appraise'])) { ?>
                                                    <td class="ForwardLeave">
                                                                    <?php echo $appraiser['Appraisalcomments']['fac_comment']; ?>
                                                    </td>
                                                            <?php } ?>
                                                        <?php } ?>
                                                </tr>
                                                <tr class="">
                                                    <td class="RejectedLeave">
                                                        <b>Confidential Remarks:</b>
                                                    </td>                            
                                                        <?php foreach ($appraisalRequest['Appraisers'] as $appraiser) { ?>
                                                            <?php if (!empty($appraiser['dt_appraise'])) { ?>
                                                    <td class="ForwardLeave">
                                                                    <?php echo $appraiser['Appraisalcomments']['commentt_conf']; ?>
                                                    </td>
                                                            <?php } ?>
                                                        <?php } ?> 
                                                </tr>                            
                                            </table>   
                                        </div>
                                    </div>    
                                </div>
                                <?php } ?>
                                <!-------------------Appraisers Tab starts here------------------------------>

                                <?php if ($isPeer) { ?>
                                    <?php foreach ($appraisalRequest['Appraisers'] as $appraiser) { ?>

                                        <?php if ($appraiser['emp_code_appraiser'] == $isPeerId) { ?>

                                <div role="tabpanel" class="tab-pane fade" id="appraiser<?php echo $appraiser['id']; ?>" aria-labelledby="profile-tab"> 
                                    <!-- Start Personal Information -->
                                                <?php echo $this->form->input('id', array('type' => 'hidden', 'value' => $id)); ?>
                                                <?php echo $this->form->input('Appraisers.id', array('type' => 'hidden', 'value' => $appraiser['id'])); ?>
                                    <div class="x_panel">

                                        <div class="x_content"> <br />
                                            <table class="table"  cellspacing="1" cellpadding="5" width="910px" border="0">
                                                <tr valign="top" class="RejectedLeave">
                                                    <th>S. No.</th>
                                                    <th>Appraisal Criteria</th>
                                                    <th>Rating</th>
                                                    <th>Remarks</th>
                                                </tr>
                                                            <?php $i = 1; ?>
                                                            <?php foreach ($appraiser['Appraisalratings'] as $factors) { ?>
                                                <tr class="ForwardLeave">
                                                    <td><?= $i; ?>.</td>
                                                    <td <?php echo ($i <= 5) ? "style=\"font-weight:bold!important;\"" : ''; ?>>
                                                                        <?php echo $this->form->input("Appraisalratings.$i.id", array('type' => 'hidden', 'value' => $factors['id'])); ?>
                                                                        <?php echo $factors['Appraisalfactors']['factor_name']; ?></td>
                                                    <td class="AppraisalSheet">
                                                                        <?php echo $this->form->input("Appraisalratings.$i.rating_id", array('autocomplete' => 'off', 'type' => 'select', 'selected' => $factors['rating_id'], 'options' => $performances)); ?>
                                                    </td>
                                                    <td class="AppraisalRemark">
                                                                        <?php echo $this->form->input("Appraisalratings.$i.remarks", array('maxlength' => '255', 'autocomplete' => 'off', 'type' => 'text', 'value' => $factors['remarks'])); ?>
                                                    </td>
                                                </tr>
                                                                <?php $i++; ?>
                                                            <?php } ?>
                                            </table>
                                            <div style="padding-top:10px;padding-bottom:10px;"> 

                                            </div>
                                                        <?php if (!$isAppraisee) { ?>
                                            <table  class="table" width="910px" cellpadding="0" cellspacing="0" border="0">
                                                <tr class="head">
                                                    <td class="RejectedLeave">
                                                        <b>Performance &amp; Increment</b>
                                                    </td>
                                                </tr> 

                                                <tr class="ForwardLeave">
                                                    <td>
                                                        <b>Overall Performance:</b>
                                                    </td>
                                                    <td class="Appraisalperformance">
                                                                        <?php echo $this->Form->hidden('Appraisalcomments.id', array('value' => $appraiser['Appraisalcomments']['id'])); ?>
                                                                        <?php echo $this->Form->input('Appraisalcomments.nu_performance', array('autocomplete' => 'off', 'type' => 'select', 'selected' => $appraiser['Appraisalcomments']['nu_performance'], 'options' => $performances)); ?>
                                                                        <?php echo $this->Form->hidden('Appraisalcomments.nu_performance_default_value', array('value' => $appraiser['Appraisalcomments']['nu_performance'])); ?>
                                                    </td>
                                                    <td class="ForwardLeave">
                                                        <b>Increment as per company policy:</b>
                                                    </td>
                                                    <td class="AppraisalIncreamentstandard">
                                                                        <?php echo $this->Form->input('Appraisalcomments.amt_inc_standard_list', array('style' => 'display:none;', 'autocomplete' => 'off', 'type' => 'select', 'options' => $slabs, 'selected' => $appraiser['Appraisalcomments']['nu_performance'])); ?>
                                                                        <?php echo $this->Form->input('Appraisalcomments.amt_inc_standard', array('size' => '5', 'readonly' => 'true', 'autocomplete' => 'off', 'value' => $appraiser['Appraisalcomments']['amt_inc_standard'])); ?>
                                                    </td>
                                                    <td>
                                                        &nbsp;
                                                    </td>
                                                    <td>
                                                        &nbsp;<?php //echo $form->input('Appraisalcomments.nu_amt_inc_recommended', array('size' => '5', 'style' => 'display:none;', 'autocomplete' => 'off', 'value' => $appraiser['Appraisalcomments']['nu_amt_inc_recommended']));           ?>
                                                    </td> 
                                                </tr>
                                                <tr class="cont1">
                                                    <td class="RejectedLeave">
                                                        <b>Reason:</b>
                                                    </td>
                                                    <td class="AmountIncrementReason">
                                                                        <?php echo $this->Form->input('Appraisalcomments.amt_inc_reason', array('autocomplete' => 'off', 'size' => '100', 'value' => $appraiser['Appraisalcomments']['amt_inc_reason'])); ?>
                                                    </td>                                            
                                                </tr>
                                            </table>
                                                        <?php } else { ?>
                                            <div class="ForwardLeave AppraisalSheet">
                                                <b>Overall Performance:</b> <?php echo $this->form->input('Appraisalcomments.nu_performance', array('autocomplete' => 'off', 'type' => 'select', 'selected' => $appraiser['Appraisalcomments']['nu_performance'], 'options' => $performances)); ?>
                                                                <?php echo $this->Form->hidden('Appraisalcomments.nu_performance_default_value', array('value' => $appraiser['Appraisalcomments']['nu_performance'])); ?>                                                

                                            </div>
                                                        <?php } ?>

                                        </div>

                                                <?php } ?>


                                            <?php } ?>
                                        <?php } else { ?>
                                            <?php foreach ($appraisalRequest['Appraisers'] as $appraiser) { ?>

                                                <?php if ($appraiser['dt_appraise'] == '') { ?>
                                        <div  role="tabpanel" class="tab-pane fade " id="appraiser<?php echo $appraiser['id']; ?>">
                                                        <?php echo $this->form->input('id', array('type' => 'hidden', 'value' => $id)); ?>
                                                        <?php echo $this->form->input('Appraisers.id', array('type' => 'hidden', 'value' => $appraiser['id'])); ?>
                                            <div class="x_panel" >
                                                <div  class="x_content">
                                                    <table class="table"  cellspacing="1" cellpadding="5" width="910px" border="0">
                                                        <tr valign="top" class="RejectedLeave">
                                                            <th>S. No.</th>
                                                            <th>Apprasial Criteria</th>
                                                            <th>Rating</th>
                                                            <th>Remarks</th>
                                                        </tr>
                                                                    <?php $i = 1; ?>
                                                                    <?php foreach ($appraiser['Appraisalratings'] as $factors) { ?>
                                                        <tr class="ForwardLeave">
                                                            <td><?= $i; ?>.</td>
                                                            <td <?php echo ($i <= 5) ? "style=\"font-weight:bold!important;\"" : ''; ?>>
                                                                                <?php echo $this->form->input("Appraisalratings.$i.id", array('type' => 'hidden', 'value' => $factors['id'])); ?>
                                                                                <?php echo $factors['Appraisalfactors']['factor_name']; ?></td>
                                                            <td class="AppraisalSheet">
                                                                                <?php echo $this->form->input("Appraisalratings.$i.rating_id", array('autocomplete' => 'off', 'type' => 'select', 'selected' => $factors['rating_id'], 'options' => $performances)); ?>
                                                            </td>
                                                            <td class="AppraisalRemark">
                                                                                <?php echo $this->form->input("Appraisalratings.$i.remarks", array('maxlength' => '255', 'autocomplete' => 'off', 'type' => 'text', 'value' => $factors['remarks'])); ?>
                                                            </td>
                                                        </tr>
                                                                        <?php $i++; ?>
                                                                    <?php } ?>
                                                    </table>
                                                    <div style="padding-top:10px;padding-bottom:10px;"> 

                                                    </div>
                                                                <?php if (!$isAppraisee) { ?>
                                                    <table  class="table" width="910px" cellpadding="0" cellspacing="0" border="0">
                                                        <tr class="head">
                                                            <td class="RejectedLeave">
                                                                <b>Performance &amp; Increment</b>
                                                            </td>
                                                        </tr> 

                                                        <tr class="cont">
                                                            <td class="ForwardLeave" >
                                                                <b>Overall Performance:</b>
                                                            </td>
                                                            <td class="Appraisalperformance">
                                                                                <?php echo $this->form->input('Appraisalcomments.nu_performance', array('autocomplete' => 'off', 'type' => 'select', 'selected' => $appraiser['Appraisalcomments']['nu_performance'], 'options' => $performances)); ?>
                                                                                <?php echo $this->form->hidden('Appraisalcomments.nu_performance_default_value', array('value' => $appraiser['Appraisalcomments']['nu_performance'])); ?>
                                                            </td>
                                                            <td class="ForwardLeave">
                                                                <b>Increment as per company policy:</b>
                                                            </td>
                                                            <td class="AppraisalIncreamentstandard">


                                                                                <?php echo $this->form->input('Appraisalcomments.amt_inc_standard_list', array('style' => 'display:none;', 'autocomplete' => 'off', 'type' => 'select', 'options' => $slabs, 'selected' => $appraiser['Appraisalcomments']['nu_performance'])); ?>
                                                                                <?php echo $this->form->input('Appraisalcomments.amt_inc_standard', array('size' => '5', 'readonly' => 'true', 'autocomplete' => 'off', 'value' => $appraiser['Appraisalcomments']['amt_inc_standard']+$kraslab)); ?>
                                                                                <?php echo $this->form->input('Appraisalcomments.amt_inc_standards', array('style' => 'display:none;','size' => '5', 'readonly' => 'true', 'autocomplete' => 'off', 'value' => $appraiser['Appraisalcomments']['amt_inc_standard']+$kraslab)); ?>
                                                            </td>
                                                            <td>
                                                                &nbsp;
                                                            </td>
                                                            <td>
                                                                &nbsp;<?php //echo $form->input('Appraisalcomments.nu_amt_inc_recommended', array('size' => '5', 'style' => 'display:none;', 'autocomplete' => 'off', 'value' => $appraiser['Appraisalcomments']['nu_amt_inc_recommended']));           ?>
                                                            </td> 
                                                        </tr>
                                                        <tr class="cont1">
                                                            <td class="RejectedLeave">
                                                                <b>Reason:</b>
                                                            </td>
                                                            <td class ="AmountIncrementReason">
                                                                                <?php echo $this->form->input('Appraisalcomments.amt_inc_reason', array('autocomplete' => 'off', 'size' => '100', 'value' => $appraiser['Appraisalcomments']['amt_inc_reason'])); ?>
                                                            </td>                                            
                                                        </tr>
                                                    </table>
                                                                <?php } else { ?>
                                                    <div  class='form-group ForwardLeave Appraisalperformance' style="margin-bottom:10px;">
                                                        <b>Overall Performance:</b> <?php echo $this->form->input('Appraisalcomments.nu_performance', array('autocomplete' => 'off', 'type' => 'select', 'selected' => $appraiser['Appraisalcomments']['nu_performance'], 'options' => $performances)); ?>
                                                                        <?php echo $this->form->hidden('Appraisalcomments.nu_performance_default_value', array('value' => $appraiser['Appraisalcomments']['nu_performance'])); ?>                                                

                                                    </div>
                                                                <?php } ?>
                                                    <table class="table" width="910px" cellpadding="0" cellspacing="0" border="0">
                                                        <tr class="RejectedLeave">
                                                            <th><?php if (!$isAppraisee) { ?>Remarks For Staff Members<?php } else { ?>Remarks By Staff Members<?php } ?></th>
                                                            <th><?php if (!$isAppraisee) { ?>Confidential Remarks<?php } ?></th>
                                                        </tr>
                                                        <tr class="cont">
                                                            <td><?php echo $this->form->hidden('Appraisalcomments.id', array('value' => $appraiser['Appraisalcomments']['id'])); ?>
                                                                            <?php echo $this->form->textarea('Appraisalcomments.fac_comment', array('maxlength' => '1000', 'style' => 'width:420px;', 'autocomplete' => 'off', 'value' => $appraiser['Appraisalcomments']['fac_comment'])); ?></td>
                                                            <td><?php if (!$isAppraisee) { ?><?php echo $this->form->textarea('Appraisalcomments.commentt_conf', array('maxlength' => '1000', 'style' => 'width:420px;', 'autocomplete' => 'off', 'value' => $appraiser['Appraisalcomments']['commentt_conf'])); ?><?php } ?></td>
                                                        </tr>
                                                                    <?php if (!$isAppraisee) { ?>
                                                        <tr  class="head">
                                                            <td class="RejectedLeave">
                                                                Training Needs Identified (with specific action plan)<a href="#" id="training_request_popup" style="float:right;margin-right:4px;"><b>To Identify Training Topics </b></a>
                                                            </td>
                                                        </tr>
                                                        <tr class="cont">
                                                            <td colspan="2">
                                                                                <?php echo $this->form->textarea('Appraisalcomments.comment_training', array('maxlength' => '1000', 'style' => 'width:820px;', 'autocomplete' => 'off', 'value' => $appraiser['Appraisalcomments']['comment_training'])); ?>
                                                            </td>
                                                        </tr>
                                                                    <?php } ?>
                                                    </table>   
                                                </div>

                                            </div>    
                                        </div>


                                                    <?php break; ?>
                                                <?php } else { ?>
                                        <div role="tabpanel" class="tab-pane fade" id="appraiser<?php echo $appraiser['id']; ?>">
                                            <div class="x_panel">
                                                <div class="x_content"></div> 
                                                <table class="table"  cellspacing="1" cellpadding="5" width="910px" border="0">
                                                    <tr valign="top" class="RejectedLeave">
                                                        <th>S. No.</th>
                                                        <th>Appraisal Criteria</th>
                                                        <th>Rating</th>
                                                        <th>Remarks</th>
                                                    </tr>
                                                                <?php $i = 1; ?>
                                                                <?php foreach ($appraiser['Appraisalratings'] as $factors) { ?>
                                                    <tr class="ForwardLeave">
                                                        <td><?= $i; ?>
                                                            .</td>
                                                        <td <?php echo ($i <= 5) ? "style=\"font-weight:bold!important;\"" : ""; ?>>
                                                                            <?php echo $factors['Appraisalfactors']['factor_name']; ?></td>
                                                        <td><?php echo $performances[$factors['rating_id']]; ?></td>
                                                        <td><?php echo $factors['remarks']; ?></td>
                                                    </tr>
                                                                    <?php $i++; ?>
                                                                <?php } ?>
                                                </table>
                                                            <?php if (!$isAppraisee) { ?>                            
                                                <table  class="table" width="910px" cellpadding="0" cellspacing="0" border="0">
                                                    <tr class="RejectedLeave">
                                                        <td colspan="6">
                                                            <b>Performance &amp; Increment</b>
                                                        </td>
                                                    </tr>
                                                    <tr >
                                                        <td class="ForwardLeave">
                                                            <b>Overall Performance:</b>
                                                        </td>
                                                        <td>
                                                                            <?php echo $performances[$appraiser['Appraisalcomments']['nu_performance']]; ?>
                                                        </td>
                                                        <td class="ForwardLeave">
                                                            <b>Increment as per company policy:</b>
                                                        </td>
                                                        <td>
                                                                            <?php echo $appraiser['Appraisalcomments']['amt_inc_standard']; ?>
                                                        </td>
                                                        <td>
                                                            &nbsp;
                                                        </td>
                                                        <td>
                                                            &nbsp;<?php //echo $appraiser['Appraisalcomments']['nu_amt_inc_recommended']; ?>
                                                        </td> 
                                                    </tr>
                                                    <tr >
                                                        <td class="RejectedLeave">
                                                            <b>Reason:</b>
                                                        </td>
                                                                        <?php if (!empty($appraiser['Appraisalcomments']['amt_inc_reason'])) { ?>
                                                        <td colspan="5">
                                                                                <?php echo $appraiser['Appraisalcomments']['amt_inc_reason']; ?>
                                                        </td>  
                                                                        <?php } else { ?>
                                                    <p> N/A</p>
                                                                    <?php } ?>
                                                    </tr>
                                                </table>
                                                            <?php } else { ?>
                                                <div style="margin-bottom:10px;">
                                                    <b>Overall Performance:</b> <?php echo $performances[$appraiser['Appraisalcomments']['nu_performance']]; ?>
                                                </div>
                                                            <?php } ?>
                                                <table class="table" width="100%" cellpadding="0" cellspacing="0" border="0">
                                                    <tr >
                                                        <th class="RejectedLeave">Remarks For Staff Members</th>
                                                        <th class="RejectedLeave">Confidential Remarks</th>
                                                    </tr>
                                                    <tr class="cont">
                                                        <td>
                                                                        <?php echo $appraiser['Appraisalcomments']['fac_comment']; ?>
                                                        </td>
                                                        <td>
                                                                        <?php echo $appraiser['Appraisalcomments']['commentt_conf']; ?>
                                                        </td>
                                                    </tr>
                                                    <tr  class="head">
                                                        <td class="RejectedLeave">
                                                            Training Needs Identified (with specific action plan)
                                                        </td>
                                                    </tr>
                                                    <tr class="cont">
                                                        <td colspan="2">

                                                                        <?php echo $appraiser['Appraisalcomments']['comment_training']; ?>
                                                        </td>
                                                    </tr>                                        
                                                </table>

                                            </div>
                                        </div>
                                                <?php } ?>
                                            <?php } ?>
                                        <?php } ?> 
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class=" form-group col-md-12 col-sm-12 col-xs-12" style="padding:5px 0px 15px 0px;">
                        <div class="submit">
                            <?php if (trim($appraisalRequest['Appraisals']['ch_status']) != 'HR') { ?>
                                <?php if (!$isAppraisee && !$isForwarded) { ?>
                            <!--button type="button" id="appraisal_print" name="appraisal_print">Print</button-->
                            <div class="col-md-3">
                                <button type="button" class="form-control btn btn-success" id="appraisal_reject" name="appraisal_reject">Reject</button>   

                            </div>

                                <?php } ?>
                                <?php
                                $dept_code = $appraisalRequest['Appraisals']['dept_code'];
                                $desg_code = $appraisalRequest['MyProfile']['desg_code'];
                                $emp_code = $_SESSION['Auth']['MyProfile']['emp_code'];
                                $checllvl = $this->Common->findAppLevel('4');
                                //print_r($checllvl);die;
                                //$level_desg = $this->Common->findDesglvl($checllvl['WfMstAppMapLvl']['wf_id']);

                                $checkcountapraiser = $this->Common->findcountAppraiser($appraisalRequest['Appraisals']['id']);
                                $countappraisallvl = $this->Common->findAppraisalLevel($appraisalRequest['Appraisals']['id']);
                                $countappraisallvl = $countappraisallvl;
                              //  print_r($appraisalRequest);die;
                                if($checllvl == $countappraisallvl ){
                                  $fwemplist = $this->Common->getHrList($emp_code);
                                }
                                else{
                                   
                                    $fwemplist = $this->Common->findAppraisalRep($emp_code,'01');   
                                   
                                }
                               
                               
                                ?>
                                <?php if ($checkcountapraiser >= 2) { ?> 
                            <div class="col-md-3">
                                <button type="button" class="form-control btn btn-success" id="appraisal_add"  name="appraisal_add">Submit To Next Level</button>  
                            </div>


                                <?php } else { ?>
                                    <?php if ($checllvl < $countappraisallvl ) { ?>
                            <div class="col-md-3">
                                            <?php echo $this->Form->input('Appraisals.forwardlvl', array('type' => 'select', 'label' => false,'options' => $fwemplist, 'class' => ' form-control s-form-item s-form-all', 'id' => 'fwlvempcode')); ?>    
                            </div>

                            <div class = "col-md-3">
                                <button type="button"  class="form-control btn btn-success" id="appraisal_add" name="appraisal_add">Submit To HR </button>
                            </div>


                                    <?php } else { ?>

                            <div class = "col-md-3 ">
                                            <?php echo $this->Form->input('Appraisals.forwardlvl', array('type' => 'select', 'label' => false,  'options' => $fwemplist, 'class' => ' form-control s-form-item s-form-all', 'id' => 'fwlvempcode')); ?>
                            </div>
                            <div class="col-md-3">
                                <button type="button" class = 'form-control btn btn-success' id="appraisal_add" name="appraisal_add">Submit To Next Level</button>  
                            </div>


                                    <?php } ?>
                                <?php } ?>

                                <?php echo $this->form->end(); ?>    

                            <?php } else { ?>
                            <!--button type="button" id="appraisal_print" name="appraisal_print">Print</button-->
                                <?php
                                if ($isHR && $appraiser['from_hr'] != 1) {
                                    $total_count = count($appraisalRequest['Appraisers']);
                                    $required_count = $total_count - 2;
                                    $appraisee_id = $appraisalRequest['Appraisers'][$required_count]['emp_code_appraiser'];
                                    ?>

                            <form >
                                        <?php echo $this->form->input('Appraisals.id', array('type' => 'hidden', 'value' => $appraisalRequest['Appraisals']['id'])); ?>
                                        <?php echo $this->form->input('Appraisee.emp_code_appraiser', array('type' => 'hidden', 'value' => $appraisee_id)); ?>
                                <div class="col-md-3">
                                    <b>Increment Amount: </b><?php echo $this->Form->textarea('Appraisals.amt_inc', array('spellcheck' => 'false', 'rows' => '1', 'value' => $appraiser['Appraisalcomments']['amt_inc_standard'])); ?>  
                                </div> 
                                <div class ="col-md-3 ">
                                    <b id ="lblreason">Reason </b> <?php echo $this->Form->textarea('Appraisals.amt_inc_reason', array('label' => 'Reason', 'rows' => '1', 'style' => 'display:block;', 'id' => 'AppraisalsAmtIncReason')); ?>    
                                </div>
                               <?php if($kraScoreIncAmt){?>
                                <div class ="col-md-3 ">
                                    <b id ="lblreason">Kra Incremented Amount: </b> <?php echo $kraScoreIncAmt; ?>    
                                    <?php echo $this->form->input('Appraisals.kraincamt', array('type' => 'hidden', 'value' =>$kraScoreIncAmt)); ?>
                                </div>
                               <?php  }?> 
                                <div class ="col-md-3 ">
                                    <b id ="lblreason">Total Incremented Amount: </b>  <?php echo $kraScoreIncAmt +  $appraiser['Appraisalcomments']['amt_inc_standard']; ?>   
                                </div>
                                <div class="col-md-3">
                                    <button type="button" class=" form-control btn btn-success" style = "margin-top:18px;" id="complete" name="appraisal_add">Complete</button>   
                                </div>
                                <div class="col-md-3">
                                    <button type="button"  class=" form-control btn btn-success" style = "margin-top:18px;" id="submit_manager" name="appraisal_add">Submit To Manager</button>   
                                </div>

                            </form>                        
                                <?php } else { ?>
                            <form >
                                <div class ="col-md-3">
                                    <b>Amount Incremented by Hr: </b><?php echo $this->Form->textarea('Appraisals.amt_inc', array('spellcheck' => 'false', 'rows' => '1', 'class' => 'form-control', 'value' => $appraiser['Appraisalcomments']['amt_inc_recommended'])); ?>  
                                </div>
                                <div class="col-md-3 ">
                                    <b>Reason: </b><?php echo $this->Form->textarea('Appraisals.amt_inc_reason', array('id' => 'increasonbyhr', 'value' => $appraiser['Appraisalcomments']['amt_inc_reason'])); ?>    
                                </div>

                                <div class="col-md-1">
                                    <button type="button" class=" btn btn-success" id="approve_hr" name="appraisal_add">Approve</button>
                                </div>    
                                <div class="col-md-1">
                                    <button type="button" class=" btn btn-success" sty id="reject_hr" name="appraisal_add">Reject</button>   
                                </div>

                                        <?php echo $this->form->input('Appraisals.id', array('type' => 'hidden', 'value' => $appraisalRequest['Appraisals']['id'])); ?>
                                        <?php echo $this->form->input('Appraisee.emp_code_appraiser', array('type' => 'hidden', 'value' => $appraiser['emp_code_appraiser'])); ?>

                            </form>    

                                    <?php
                                }
                            }
                            ?>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div class="col-md-12">
            <div id="container" style="width: 600px; height: 400px; margin: 0 auto"></div>
        </div>

    </div>
</div>

<!-- footer content --> 
<!--<footer>
  <div class="">
    <p class="pull-right">HR Portal by <a href="https://essindia.com/" target="_blank">ESS</a>. | <span class="lead"> <img src="images/ess-logo.png" width="" height="20" alt="Ess Logo"></span> </p>
  </div>
  <div class="clearfix"></div>
</footer>--> 
<!-- /footer content --> 
<div >

    <div id="dialogRejectReason" title="Reason for rejection">
        <?php echo $this->Form->create('Appraisals'); ?>
        <?php echo $this->Form->input('id', array('type' => 'hidden', 'value' => $id)); ?>
        <?php echo $this->Form->textarea('review_reason', array('style' => '')); ?>
        <?php echo $this->Form->end(); ?>
    </div>     

    <div id="dialogRejecthrReason" title="Reason for rejection">
        <?php
        $total_count = count($appraisalRequest['Appraisers']);
        $required_count = $total_count - 2;
        $appraisee_id = $appraisalRequest['Appraisers'][$required_count]['emp_code_appraiser'];
        ?>
        <?php echo $this->Form->create('Appraisals'); ?>
        <?php echo $this->Form->input('id', array('type' => 'hidden', 'value' => $id)); ?>
        <?php echo $this->Form->input('emp_code_appraiser', array('type' => 'hidden', 'value' => $appraisee_id)); ?>
        <?php echo $this->Form->textarea('amt_reject_reason', array('style' => 'width:270px;he =[[[[--------=-ight:75px;')); ?>
        <?php echo $this->Form->end(); ?>
    </div>

    <!-- ******************************* SOC OF TRAINING MODULE  ************************************---->

    <div id="training_request" title="Identified Training (s)">

        <?php
        $identified_by = $appraiser['emp_code_appraiser'];

        $appriasal_id = $appraisalRequest['Appraisals']['id'];

        $trainee_code = $appraisalRequest['Appraisals']['emp_code'];

        echo $this->Form->create('TrainingRequest', array('url' => array('controller' => 'trainingmasters', 'action' => 'appriasal_training_requests')));

        echo $this->Form->input('TrainingRequest.identified_from', array('type' => 'hidden', 'value' => 'A'));

        echo $this->Form->input('TrainingRequest.appraisal_id', array('type' => 'hidden', 'value' => $appraisalRequest['Appraisals']['id']));

        echo $this->Form->input('TrainingRequest.identified_by', array('type' => 'hidden', 'value' => $identified_by));

        echo $this->Form->input('TrainingRequest.trainee_code', array('type' => 'hidden', 'value' => $trainee_code));
        ?>
        <table class="exp-voucher" border="0" cellpadding="0" cellspacing="0" width="104%" id="datatbl">
            <tbody>
                <tr>
                    <td height="30">&nbsp;</td>
                    <td height="30" align="left"><strong> Training Name:</strong></td>
                    <td height="30">
                        <div style="float:left; "><input name="data[TrainingRequest][topic_type]" id="existing_topic_chk" value="E" type="radio"<?php if ($trainData['TrainingRequest']['topic_type'] == 'E') { ?>checked="checked" <?php } ?>onClick="show_dd(this.value);">&nbsp; Existing</div>&nbsp;&nbsp;&nbsp;
                        <div style="float:left; margin-left: 8px;"><input name="data[TrainingRequest][topic_type]" id="new_topic_chk" value="N" type="radio" checked="checked" <?php if ($trainData['TrainingRequest']['topic_type'] == 'N') { ?>checked="checked" <?php } ?>onClick="show_dd(this.value);">&nbsp; New</div>
                    </td>
                    <td height="30">&nbsp;</td>
                </tr>
                <tr>
                    <td height="30">&nbsp;</td>
                    <td height="30"><strong>Training Required :</strong></td>
                    <td height="30">
                        <?php
                        $topicname = '';
                        $topicIds = array();
                        if ($trainData['TrainingRequest']['topic_type'] == 'E') {
                            $sbox_style = "height:58px;width:207px;overflow:scroll;display:block;";
                            $tbox = "height:56px;display:none;";


                            $topicIds = explode(',', $trainData['TrainingRequest']['training']);
                            foreach ($topicIds as $v) {
                                $topicIds[] = $v;
                            }
                        } else {
                            $tbox = "height:56px;";
                            $sbox_style = "height:58px;width:207px;overflow:scroll;display:none;";
                            $topicname = $trainData['TrainingRequest']['training'];
                        }
                        ?>

                        <select multiple style='<?php echo $sbox_style; ?>' id="existing_topics" class="round_select" name="data[TrainingRequest][existing_training_name][]">
                            <?php foreach ($courselisting as $key => $val) { ?>
                            <option value="<?php echo $key; ?>" <?php if (in_array($key, @$topicIds)) { ?>selected <?php } ?>><?php echo $val; ?></option>
                            <?php } ?>
                        </select>
                        <textarea name="data[TrainingRequest][new_training_name]" id="new_topics" class="round_select" style='<?php echo $tbox; ?>' maxlength="145" style="<?php echo $tbox; ?>"><?php echo $topicname; ?></textarea>
                    </td>
                    <td height="30">&nbsp;</td>
                </tr>
                <tr>
                    <td height="30" colspan="2">&nbsp;</td>
                    <td height="30" colspan="2"><font size="1"><i>(e.g. D2K Reports,Communication Skill)</i></font></td>
                </tr>
                <tr id="validation_errors" style="display:none;">
                    <td height="30" colspan="2">&nbsp;</td>
                    <td height="30" colspan="2"><font color="red" id="msg"></font></td>
                </tr>
        </table>
        <?php echo $this->Form->end(); ?>
    </div>
    <style>
        #dialogRejectReason textarea{background-color: #ffffff;
                                     border: 1px solid #afafaf;
                                     margin-top: -43px;
                                     width: 90%;} 
        #new_topics textarea{ width:90% !important;    }

        #training_request textarea{background-color: #ffffff;
                                   border: 1px solid #afafaf;

                                   width: 90%;}
        #AppraisalsReviewReason {width:100% !important;}
        #TrainingRequestEditForm{background-color: #ffffff; border: solid 1px #afafaf;}

        span#ui-id-2,span#ui-id-4{ background-color:#E0ECF8; font-size:14px; font-weight:bold; width: 100%; padding: 10px; float:left;}
        button.ui-button{ float:right; position: relative; background-color: #00a65a !important;
                          border-color: #008d4c!important; border-radius: 3px;
                          box-shadow: none;  color: #fff; -moz-user-select: none;
                          background-image: none;
                          border: 1px solid transparent;
                          border-radius: 4px;
                          cursor: pointer;
                          display: inline-block;
                          font-size: 14px;
                          font-weight: normal;
                          line-height: 1.42857;
                          margin-bottom: 0;
                          padding: 6px 12px;
                          text-align: center;
                          vertical-align: middle;
                          white-space: nowrap; margin-right: 10px;}
        .AppraisalSheet label{ display:none;}
        .AppraisalRemark label{display:none;}
        .Appraisalperformance label{display:none;}
        .AppraisalIncreamentstandard label{display:none;}
        .AmountIncrementReason label{display:none;}
    </style>


    <!---****************************** EOC OF TRAINING MODULE  ************************************---->
