<?php
$kra_config = $this->Session->read('sess_kra_config');
                        if ($empCode != "") {
                            $empId = $empCode;
                        }
?>
<style>
.uk-table {
    border-collapse: unset;
}

.uk-table tfoot td, .uk-table tfoot th, .uk-table thead th {
    font-style: normal;
    font-weight: bold;
    color: #727272;
    font-size: 14px;
    border: solid 1px !important;
}
#parent {
	height: 500px;
}

#fixTable {
	width: 1820px !important;
}

table#fixTable tr,table#fixTable td{
	border:solid 1px #000 !important;
}

</style>
<script src="<?php echo $this->webroot ?>js/tableHeadFixer.js" type="text/javascript"></script>
<script>

$(document).ready(function($) {
	$("#fixTable").tableHeadFixer({"left" : 2}); 
});
</script>
<div id="page_content" role="main">
    <div id="page_content_inner">        
        
        <?php echo $flash = $this->Session->flash(); ?>
        <div class="md-card">
            
            <div class="md-card-content"><h3>Appraiser Screen: View KRA</h3>
			<?php if(count($kraTargetList) > 0){?>
                <div class="uk-overflow-container">
                    <table class="uk-table md-bg-blue-50">
                        <?php
                        $empDetails = $this->Common->getEmpDetails($empId);
						
                        if($page_type=="allapp"){
							$CompetencyTab = 0;
							$midReviewsTab = 0;
							$midReviewsDetails = 0;
							$compmidReviewsDetails = 0;
							$countCompetency = 0;
						  
						}elseif($page_type=="allmidapp"){
							$CompetencyTab = 0;
							$midReviewsTab = $this->Common->findMidReviewsListApp($empDetails['MyProfile']['emp_code'],$currentFinancialYear);
							$midReviewsDetails = $this->Common->findMidReviewsDetailsApp($empDetails['MyProfile']['emp_code'],$currentFinancialYear);
							$midCompReviewsTab = $this->Common->findCompMidReviewsDetailsApp($empDetails['MyProfile']['emp_code'],$currentFinancialYear);
							$compmidReviewsDetails = $this->Common->findCompMidReviewsDetailsApp($empDetails['MyProfile']['emp_code'],$currentFinancialYear);
							$countCompetency = $this->Common->findCountCompetency($empDetails['MyProfile']['emp_code'],$currentFinancialYear);
						  
						}elseif($page_type=="allannapp"){
							$CompetencyTab = $this->Common->findAppraisalProcessListApp($empDetails['MyProfile']['emp_code'],$currentFinancialYear);
							if($kra_config['MstPmsConfig']['mid_review'] == 1){
							$midReviewsTab = $this->Common->findMidReviewsListApp($empDetails['MyProfile']['emp_code'],$currentFinancialYear);
							$midReviewsDetails = $this->Common->findMidReviewsDetailsApp($empDetails['MyProfile']['emp_code'],$currentFinancialYear);
							$compmidReviewsDetails = $this->Common->findCompMidReviewsDetailsApp($empDetails['MyProfile']['emp_code'],$currentFinancialYear);
							}
							$compannReviewsDetails = $this->Common->findCompAnnReviewsDetailsApp($empDetails['MyProfile']['emp_code'],$currentFinancialYear);
							$countCompetency = $this->Common->findCountCompetency($empDetails['MyProfile']['emp_code'],$currentFinancialYear);
							$annual_status_mod = $this->Common->findAnnReviewsDetails($empDetails['MyProfile']['emp_code'],$currentFinancialYear);
						}
						
						$midReviewsAllStatus = $this->Common->midReviewsAllStatus($empDetails['MyProfile']['emp_code'],$currentFinancialYear);
						
						?>
                        <tbody>
                            <tr>
                                <td><b>Performance Period</b></td>
                                <td colspan="3"><?php echo $this->Common->findfyDesc($currentFinancialYear);?></td>                                
                            </tr>
                            <tr>
                                <td><b>Employee Name</b></td>
                                <td><?php echo ucwords(strtolower($empDetails['MyProfile']['emp_full_name'])); ?></td>
                                <td><b>Emp Code / Designation</b></td>
                                <td><?php echo $empDetails['MyProfile']['emp_id']; ?> / <?php echo $this->Common->findDesignationName($empDetails['MyProfile']['desg_code'], $empDetails['MyProfile']['comp_code']); ?></td>
                            </tr>
                            <tr>
                                <td><b>Department</b></td>
                                <td><?php echo $this->common->findDepartmentNameByCode($empDetails['MyProfile']['dept_code']); ?></td>
                                <td><b>Date of Joining</b></td>
                                <td><?php echo date('d-m-Y', strtotime($empDetails['MyProfile']['join_date'])); ?></td>
                            </tr>
                            <tr>
                                <td><b>Appraiser's Name</b></td>
                                <td><?php echo $this->Common->findEmpName($empDetails['MyProfile']['manager_code']); ?></td>
                                <td><b>Appraiser's Designation</b></td>
                                <td><?php
                                    $AppraiserDesgCode = $this->Common->getempdesgcode($empDetails['MyProfile']['manager_code']);
                                    echo $this->Common->findDesignationName($AppraiserDesgCode, $empDetails['MyProfile']['comp_code']);
                                    ?></td>
                            </tr>
                            <tr>
                                <td><b>Reviewer's Name</b></td>
                                <td><?php
                                    $reviewerManagerCode = $this->Common->getManagerCode($empDetails['MyProfile']['manager_code']);
                                    echo $reviewerCode = $this->Common->findEmpName($reviewerManagerCode);
                                    ?></td>
                                <td><b>Reviewer's Designation</b></td>
                                <td><?php
                                    $reviewerDesgCode = $this->Common->getempdesgcode($reviewerManagerCode);
                                    echo $this->Common->findDesignationName($reviewerDesgCode, $empDetails['MyProfile']['comp_code']);
                                    ?></td>
                            </tr>
							<tr>
                                <td><b>Moderator's Name</b></td>
                                <td><?php $moderatorManagerCode = $this->Common->getManagerCode($reviewerManagerCode);
                                    echo $moderatorCode =  $this->Common->findEmpName($moderatorManagerCode);
                                    ?></td>
                                <td><b>Moderator's Designation</b></td>
                                <td><?php 
                            $moderatorDesgCode = $this->Common->getempdesgcode($moderatorManagerCode);
                            echo $this->Common->findDesignationName($moderatorDesgCode,$empDetails['MyProfile']['comp_code']);
                            ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            
            <div class="md-card-content">
		 <?php
					if($page_type=="allapp"){
						echo '<a alt="Download KRA details Report" title="Download KRA details Report" style="text-align:right" href="'.$this->webroot.'KraMasters/kraReportFile/'.base64_encode($empDetails['MyProfile']['emp_code'])."/".base64_encode($currentFinancialYear)."/".base64_encode($empDetails['MyProfile']['comp_code']).'/'.base64_encode('detail').'" class="md-btn md-btn-primary md-btn-small"><i class="material-icons md-color-amber-900">&#xE2C4;</i> File Download</a>
						  ';
						  echo '<br> <br> ';
					}
					if($page_type=="allmidapp"){
						if($midReviewsAllStatus==1){
						echo '<a alt="Download Mid Year Report" title="Download Mid Year Report" style="text-align:right" href="'.$this->webroot.'KraMasters/kraReportFile/'.base64_encode($empDetails['MyProfile']['emp_code'])."/".base64_encode($currentFinancialYear)."/".base64_encode($empDetails['MyProfile']['comp_code']).'/'.base64_encode('mid').'" class="md-btn md-btn-primary md-btn-small"><i class="material-icons md-color-amber-900">&#xE2C4;</i> File Download</a>
						  ';
						  echo '<br> <br> ';
						}
					}
					if($page_type=="allannapp"){
						if($annual_status_mod==1){
						echo '<a alt="Download Annual Report" title="Download Annual Report" style="text-align:right" href="'.$this->webroot.'KraMasters/kraReportFile/'.base64_encode($empDetails['MyProfile']['emp_code'])."/".base64_encode($currentFinancialYear)."/".base64_encode($empDetails['MyProfile']['comp_code']).'/'.base64_encode('ann').'" class="md-btn md-btn-primary md-btn-small"><i class="material-icons md-color-amber-900">&#xE2C4;</i> File Download</a>
						  ';
						  echo '<br> <br> ';
						}
					}
					?>
			  
                <div class="uk-accordion" data-uk-accordion>
                    <h3 class="uk-accordion-title" id="hideheader1">KRA Details</h3>
                        <div id="aaa" class="uk-accordion-content">
									<?php 
										if($selfScoreTabOpen == 0){
										?>
						<div style="margin-top: -20px;text-align: right;"><b>Note :</b> Tick to approve KRAs <input checked="" disabled="" type="checkbox"><br>Keep untick to reject KRAs <input disabled="" type="checkbox"></div>
										<?php
										}
										?>
                            <?php echo $this->Form->create('updateKraTarget', array('url' => array('controller' => 'KraMasters', 'action' => 'updateKraTarget'), 'id' => 'form_validation', 'class' => 'uk-form-stacked','enctype' => "multipart/form-data")); ?>
                                <div class="uk-overflow-container">

								
									<div id="parent">
			<table id="fixTable" class="uk-table uk-tab-responsive table">
			
			   <thead>
                        <tr>
                            <th rowspan="2" class="uk-text-center md-bg-blue-100 uk-te uk-text-small">Sr.No.</th>
                            <th rowspan="2" class="uk-text-center md-bg-blue-100 uk-text-small">KRA</th>
                            <th rowspan="2" class="uk-text-center md-bg-blue-100 uk-text-small">Weightage(%)</th>
                            <th rowspan="2" class="uk-text-center md-bg-blue-100 uk-text-small">Measure (KPI)</th>
                            <th rowspan="2" class="uk-text-center md-bg-blue-100 uk-text-small">Measure Type</th>
                            <th rowspan="2" class="uk-text-center md-bg-blue-100 uk-text-small">View Document</th>
							<th colspan="3" class="uk-text-center md-bg-blue-100 uk-text-small">Annual Target</th>
							<th class="uk-text-center md-bg-blue-100 uk-text-small">Mid Year Target</th>
                            
                            <?php if($selfScoreTabOpen == 0){?>
                            <th colspan="2" class="uk-text-center md-bg-blue-100 uk-text-small">Appraiser Comment</th>
                            <?php if ($empResponseRecords > 0) { ?>
                                <th colspan="1" class="uk-text-center md-bg-blue-100 uk-text-small">Emp Comment</th>
                            <?php } if($reviewerTotalRecords >=1){?>
                            <th colspan="2" class="uk-text-center md-bg-blue-100 uk-text-small">Reviewer Comment</th>
                            <?php }
							}elseif($midReviewsTab==1){ ?>
								<th colspan="3" class="uk-text-center md-bg-blue-100 uk-text-small">Mid Year Self Score</th>
								<th colspan='2' class="uk-text-center md-bg-blue-100 uk-text-small">Mid Year Appraiser Score</th>
							<?php	
							
							}								
									
									if($midReviewsAllStatus==1){
									if($kraTargetList[0]['KraTarget']['reviewer_id']!=0 && $kraTargetList[0]['KraTarget']['moderator_id']!=0){
										
									?>
									
									<th colspan="2" class="uk-text-center md-bg-blue-100 uk-text-small">Mid Year Reviewer Score</th>
									<th colspan="2" class="uk-text-center md-bg-blue-100 uk-text-small">Mid Year Moderator Score</th>
									<?php
										}elseif($kraTargetList[0]['KraTarget']['reviewer_id']!=0 && $kraTargetList[0]['KraTarget']['moderator_id']==0){
									?>
									<th colspan="2" class="uk-text-center md-bg-blue-100 uk-text-small">Mid Year Reviewer Score</th>
									<?php
										}
									}
									
									
							if($CompetencyTab == 1){?>                                
                                <th colspan="4" class="uk-text-center md-bg-blue-100 uk-text-small">Annual Self Score</th>
                               
                                <th colspan="3" class="uk-text-center md-bg-blue-100 uk-text-small">Annual Appraiser Score</th>
								
                                <?php }?>
                        </tr>

                        <tr>
                            <th class="uk-text-center md-bg-blue-100 uk-text-small">Baseline</th>
							<th class="uk-text-center md-bg-blue-100 uk-text-small">Target</th>
                            <th class="uk-text-center md-bg-blue-100 uk-text-small">Stretched</th>
							<th class="uk-text-center md-bg-blue-100 uk-text-small">Target</th> 
                            
                            <?php if($selfScoreTabOpen == 0){?>
                            <th class="uk-text-center md-bg-blue-100 uk-text-small">Approval Status</th>
                            <th class="uk-text-center md-bg-blue-100 uk-text-small">Comments</th>
                            
                            <?php if ($empResponseRecords > 0) { ?>
                                <th class="uk-text-center md-bg-blue-100 uk-text-small"></th>
                            <?php } if($reviewerTotalRecords >=1){?>
                            <th class="uk-text-center md-bg-blue-100 uk-text-small">Approval Status</th>
                            <th class="uk-text-center md-bg-blue-100 uk-text-small">Comments</th>
                            <?php }
							}elseif($midReviewsTab == 1){?>
                                    <th class="uk-text-center md-bg-blue-100 uk-text-small">Actual</th>
                                    <th class="uk-text-center md-bg-blue-100 uk-text-small">Comments</th>
                                    <th class="uk-text-center md-bg-blue-100 uk-text-small">View Document</th>
									<th class="uk-text-center md-bg-blue-100 uk-text-small">Comments</th>
                                    <th class="uk-text-center md-bg-blue-100 uk-text-small">Upload Document</th>
                                    <?php 
							}?>
							<?php
							if($midReviewsAllStatus==1){
									if($kraTargetList[0]['KraTarget']['reviewer_id']!=0 && $kraTargetList[0]['KraTarget']['moderator_id']!=0){
										
									?>
									<th class="uk-text-center md-bg-blue-100 uk-text-small">Comments</th>
									<th class="uk-text-center md-bg-blue-100 uk-text-small">View Document</th>
									<th class="uk-text-center md-bg-blue-100 uk-text-small">Comments</th>
									<th class="uk-text-center md-bg-blue-100 uk-text-small">View Document</th>
									<?php
										}elseif($kraTargetList[0]['KraTarget']['reviewer_id']!=0 && $kraTargetList[0]['KraTarget']['moderator_id']==0){
									?>
									<th class="uk-text-center md-bg-blue-100 uk-text-small">Comments</th>
									<th class="uk-text-center md-bg-blue-100 uk-text-small">View Document</th>
									<?php
										}
									}
							
									
									?>
									<?php if($CompetencyTab == 1){?>
                            <th class="uk-text-center md-bg-blue-100 uk-text-small">Actual</th>
                            <th class="uk-text-center md-bg-blue-100 uk-text-small">Achievement(%)</th>
                            <?php
									
									if($kra_config['MstPmsConfig']['app_type'] == 2){
									?>
                                    <th class="uk-text-center md-bg-blue-100 uk-text-small">Achieved</th>
                                    <?php
									}else{
									?>
									<th class="uk-text-center md-bg-blue-100 uk-text-small">Comments</th>
									<?php
									}
									?>
                            <th class="uk-text-center md-bg-blue-100 uk-text-small">View Document</th>
							 <?php
									
									if($kra_config['MstPmsConfig']['app_type'] == 2){
									?>
                            <th class="uk-text-center md-bg-blue-100 uk-text-small">Actual</th>
							<?php
									}
									?>
                            <th class="uk-text-center md-bg-blue-100 uk-text-small">Achievement(%)</th>
                            <th class="uk-text-center md-bg-blue-100 uk-text-small">Comments</th>
                            
                            <?php } ?>
                        </tr>
</thead>
                        <?php
						 
                        if (isset($kraTargetList)) {
                            $p = 1;

                            foreach ($kraTargetList as $key => $val) {
                                
                                $ctr = (($this->params['paging']['KraTarget']['page'] * $this->params['paging']['KraTarget']['limit']) - $this->params['paging']['KraTarget']['limit']) + $p;
                                $finalStatus = $kraTargetList[$key]['KraTarget']['final_status'];



                                $finalStatus = $kraTargetList[$key]['KraTarget']['final_status'];
                                $empStatus = $kraTargetList[$key]['KraTarget']['emp_status'];
                                $appraiserStatus = $kraTargetList[$key]['KraTarget']['appraiser_status'];
                                $reviewerFinalStatus = $kraTargetList[$key]['KraTarget']['reviewer_final_status'];

                                if ($finalStatus == 1) {
                                    $checkBoxStatus = "checked='checked'";
                                    $checkBoxDisable = "disabled";
                                } else {
                                    $checkBoxStatus = "";
                                    $checkBoxDisable = "";
                                }
                                
                                if($reviewerFinalStatus == 1){
                                    $reviewerCheckBoxStatus = "checked='checked'";                           
                                }else{
                                    $reviewerCheckBoxStatus = "";                           
                                }
                                ?>

                                <tr>
                                    <td class="uk-text-center"><?= $ctr; ?></td>                            
                                    <td><?php echo html_entity_decode($kraTargetList[$key]['KraTarget']['kra_name']); ?></td>
                                    <td class="weightage"><?php echo $kraTargetList[$key]['KraTarget']['weightage']; ?>%</td>
                                    <td><?php echo html_entity_decode($kraTargetList[$key]['KraTarget']['measure']); ?></td>
                                    <td>
										<?php if($kraTargetList[$key]['KraTarget']['measure_type']==1){
										echo 'Higher the Better';
										}elseif($kraTargetList[$key]['KraTarget']['measure_type']==2){
										echo 'Lower the Better';
										}elseif($kraTargetList[$key]['KraTarget']['measure_type']==3){
										echo 'Boolean';
										}
										?>
										</td>
									<td class="kra_upload">
										<?php 
									if ($kraTargetList[$key]['KraTarget']['kra_upload'] != "") {
										echo '<a href="'.$this->webroot . 'uploads/KRA/' . $kraTargetList[$key]['KraTarget']['kra_upload'].'" target="_blank">'.$kraTargetList[$key]['KraTarget']['kra_upload'].' </a>';
										
									}else{
										echo 'N/A';
									}
									echo $this->Form->input("kra_upload.", array("class" => "uk-width-medium-1-1 kra_upload","id" => "kra_upload","value" => $kraTargetList[$key]['KraTarget']['kra_upload'], "type" => "hidden", "required" => True, "autocomplete"=> "off")); ?>
									</td>
                                    <td><?php echo html_entity_decode($kraTargetList[$key]['KraTarget']['qualifying']); ?></td>
                                    <td class="target"><?php echo html_entity_decode($kraTargetList[$key]['KraTarget']['target']); ?></td>
                                    <td><?php echo html_entity_decode($kraTargetList[$key]['KraTarget']['stretched']); ?></td> 
									<td><?php echo html_entity_decode($kraTargetList[$key]['KraTarget']['mid_self_target']);
									echo $this->Form->input("mid_target.", array("class" => "uk-width-medium-1-1 mid_target","id" => "mid_target","value" => html_entity_decode($kraTargetList[$key]['KraTarget']['mid_self_target']), "type" => "hidden", "required" => True, "autocomplete"=> "off")); ?>
									</td>
                                           
                                <?php if($selfScoreTabOpen == 0){
                                    if (isset($empCode)) { ?>


                                        <td>
                                            <?php 
                                            if($checkBoxStatus == ""){
                                                echo $this->Form->input('final_status.' . $key, array('title' => 'Tick here to approve this point','type' => 'checkbox', "data-text" => "$key", 'label' => false,'class' => 'final_status'));
											?>
											<?php
                                            }else{?>
                                            <input readonly="true" type="checkbox" title = 'Tick here to approve this point' name="data[final_status][<?= $key ?>]" class="final_status" data-text="<?=$key?>" value="1" <?=$checkBoxStatus;?>>
                                            <?php } ?>
                                            <input type="hidden" name="data[id][<?= $key ?>]" value="<?= $kraTargetList[$key]['KraTarget']['id'] ?>" <?=$checkBoxStatus?>>
											<input type="hidden" id="final_status_app<?= $key ?>" name="data[final_status_app][<?= $key ?>]" value="<?= $kraTargetList[$key]['KraTarget']['final_status']; ?>" >
                                        </td>

                                        <td><?php if ($finalStatus == 1) {
                                                    $appraiserStatusComment = html_entity_decode($kraTargetList[$key]['KraTarget']['appraiser_status_comment']);
                                                    if($appraiserStatusComment != ""){
                                                ?>
                                                    <span data-uk-tooltip="{cls:'long-text'}" title="<?php echo $appraiserStatusComment ; ?>"><i class="material-icons">chat</i></span>
													<input type="hidden" name="data[appraiser_status_comment][<?= $key ?>]" value="<?= html_entity_decode($kraTargetList[$key]['KraTarget']['appraiser_status_comment']) ?>" >
                                                <?php }else{ echo "N/A";}

                                            } else { ?>
                                                <textarea name="data[appraiser_status_comment][<?= $key ?>]" class="uk-width-medium-1-1 textarea_expand" maxlength = "2000" required="" id="appraiser_status_comment<?=$key?>"></textarea> 
                                                <?php
                                                    $appraiserStatusComment = html_entity_decode($kraTargetList[$key]['KraTarget']['appraiser_status_comment']);
                                                    if($appraiserStatusComment != ""){
                                                ?>
                                                    <span data-uk-tooltip="{cls:'long-text'}" title="<?php echo $appraiserStatusComment ; ?>"><i class="material-icons">chat</i></span>
                                                <?php }?>
                                                    
                                            <?php }
                                            ?></td>
                                        <?php } if ($empResponseRecords > 0) {?>
                                            <td><?php if($kraTargetList[$key]['KraTarget']['emp_status_comment']!=''){echo ucfirst(html_entity_decode($kraTargetList[$key]['KraTarget']['emp_status_comment']));}else{echo 'N/A';}?></td>
                                        <?php } if($reviewerTotalRecords >=1){?>
                                            <td><input type="checkbox" disabled name="data[updateKraTarget][reviewer_final_status][]" value="<?=$kraTargetList[$key]['KraTarget']['reviewer_final_status']?>" <?=$reviewerCheckBoxStatus;?> ></td>
                                            <td><?php echo ucfirst(html_entity_decode($kraTargetList[$key]['KraTarget']['reviewer_status_comment'])); ?></td>
                                            <?php }}elseif($midReviewsTab == 1){?>
                                    <td><?php
									if($kraTargetList[$key]['KraTarget']['measure_type']==3){
													if($kraTargetList[$key]['KraTarget']['mid_self_score_actual']==1){
													echo 'Overachieved';
													}elseif($kraTargetList[$key]['KraTarget']['mid_self_score_actual']==2){
													echo 'Achieved';
													}elseif($kraTargetList[$key]['KraTarget']['mid_self_score_actual']==3){
													echo 'Underachieved';
													}
													
												}else{
													echo html_entity_decode($kraTargetList[$key]['KraTarget']['mid_self_score_actual']);
												}
									?></td>
                                    <td><?php
									
												if($kraTargetList[$key]['KraTarget']['mid_self_score_comment'] !=""){
                                                echo ucfirst(html_entity_decode($kraTargetList[$key]['KraTarget']['mid_self_score_comment']));  
                                            }else{
                                                echo "N/A";
                                            }
									?></td>
                                    <td><?php if($kraTargetList[$key]['KraTarget']['mid_self_actual_upload'] !=""){
                                                echo '<a href="'.$this->webroot . 'uploads/KRA/' . $kraTargetList[$key]['KraTarget']['mid_self_actual_upload'].'" target="_blank">'.$kraTargetList[$key]['KraTarget']['mid_self_actual_upload'].' </a>';  
                                            }else{
                                                echo "N/A";
                                            } 
											?></td>
											<td>
											<input type="hidden" name="data[id][<?= $key ?>]" value="<?= $kraTargetList[$key]['KraTarget']['id'] ?>" <?=$checkBoxStatus?>>
                                    <?php  if($midReviewsDetails==1){
							?>
							
							 <textarea name="data[mid_appraiser_score_comment][<?= $key ?>]" class="uk-width-medium-1-1 textarea_expand" maxlength = "2000" required="required" id="mid_appraiser_score_comment<?=$key?>"><?= html_entity_decode($kraTargetList[$key]['KraTarget']['mid_appraiser_score_comment']) ?></textarea>
							<?php	
							}else{
								//echo'dd';
								echo html_entity_decode($kraTargetList[$key]['KraTarget']['mid_appraiser_score_comment']);
							}
							?></td>
							<td>
							<?php
							if($midReviewsDetails==1){
								?>
                                        <div class=" md-btn md-btn-primary">
                                            
                                            <input class="mid_app_actual_upload" style="width:175px !important" type="file" data-parsley-id="10" id="form-file" name="data[mid_app_actual_upload_<?php echo $p ;?>]">
                                        </div><br/><span style="font-size:10px">mouseover to see document</span>
									<?php		
									echo $this->Form->input("mid_app_actual_upload_pre.", array("value" => $kraTargetList[$key]['KraTarget']['mid_app_actual_upload'], "type" => "hidden", "required" => True));
							echo '<a href="'.$this->webroot . 'uploads/KRA/' . $kraTargetList[$key]['KraTarget']['mid_app_actual_upload'].'" target="_blank">'.$kraTargetList[$key]['KraTarget']['mid_app_actual_upload'].' </a>'; 
									}else{
		
												 if($kraTargetList[$key]['KraTarget']['mid_app_actual_upload'] !=""){
                                                echo '<a href="'.$this->webroot . 'uploads/KRA/' . $kraTargetList[$key]['KraTarget']['mid_app_actual_upload'].'" target="_blank">'.$kraTargetList[$key]['KraTarget']['mid_app_actual_upload'].' </a>';  
                                            }else{
                                                echo "N/A";
                                            } 
											}
							?>
							</td>
							<?php
								if($midReviewsAllStatus==1){
									if($kraTargetList[$key]['KraTarget']['reviewer_id']!=0 && $kraTargetList[$key]['KraTarget']['moderator_id']!=0){
										
									?>
									<td><?=html_entity_decode($kraTargetList[$key]['KraTarget']['mid_reviewer_score_comment'])?></td>
											<td><?php if($kraTargetList[$key]['KraTarget']['mid_rev_actual_upload'] !=""){
                                                echo '<a href="'.$this->webroot . 'uploads/KRA/' . $kraTargetList[$key]['KraTarget']['mid_rev_actual_upload'].'" target="_blank">'.$kraTargetList[$key]['KraTarget']['mid_rev_actual_upload'].' </a>';  
                                            }else{
                                                echo "N/A";
                                            } 
											?>
									</td>
									<td><?=html_entity_decode($kraTargetList[$key]['KraTarget']['mid_moderator_score_comment'])?></td>
											<td><?php if($kraTargetList[$key]['KraTarget']['mid_mod_actual_upload'] !=""){
                                                echo '<a href="'.$this->webroot . 'uploads/KRA/' . $kraTargetList[$key]['KraTarget']['mid_mod_actual_upload'].'" target="_blank">'.$kraTargetList[$key]['KraTarget']['mid_mod_actual_upload'].' </a>';  
                                            }else{
                                                echo "N/A";
                                            } 
											?>
									</td>
									<?php
										}elseif($kraTargetList[$key]['KraTarget']['reviewer_id']!=0 && $kraTargetList[$key]['KraTarget']['moderator_id']==0){
									?>
									<td><?=html_entity_decode($kraTargetList[$key]['KraTarget']['mid_reviewer_score_comment'])?></td>
											<td><?php if($kraTargetList[$key]['KraTarget']['mid_rev_actual_upload'] !=""){
                                                echo '<a href="'.$this->webroot . 'uploads/KRA/' . $kraTargetList[$key]['KraTarget']['mid_rev_actual_upload'].'" target="_blank">'.$kraTargetList[$key]['KraTarget']['mid_rev_actual_upload'].' </a>';  
                                            }else{
                                                echo "N/A";
                                            } 
											?>
									</td>
									<?php
										}
									}
							
							}?>
							<?php if($CompetencyTab == 1){?>
                                            <td><?php if($kraTargetList[$key]['KraTarget']['measure_type']==3){
							if($kraTargetList[$key]['KraTarget']['self_score_actual']==1){
							echo 'Overachieved';
							}elseif($kraTargetList[$key]['KraTarget']['self_score_actual']==2){
							echo 'Achieved';
							}elseif($kraTargetList[$key]['KraTarget']['self_score_actual']==3){
							echo 'Underachieved';
							}
							
						}else{
							echo $kraTargetList[$key]['KraTarget']['self_score_actual'];
						}?></td>
                                            <td><?php echo $kraTargetList[$key]['KraTarget']['self_score_achiev']."%"; ?></td>
                                            <td><?php if($kraTargetList[$key]['KraTarget']['self_score_comment'] != ""){echo ucfirst($kraTargetList[$key]['KraTarget']['self_score_comment']);}else{ echo "N/A";}  ?></td>
                                            <td><?php  if($kraTargetList[$key]['KraTarget']['self_upload'] !=""){
                                                echo '<a href="'.$this->webroot . 'uploads/KRA/' . $kraTargetList[$key]['KraTarget']['self_upload'].'" target="_blank">'.$kraTargetList[$key]['KraTarget']['self_upload'].' </a>';  
                                            }else{
                                                echo "N/A";
                                            }
                                        ?>
                                    </td>
									 <?php
									
									if($kra_config['MstPmsConfig']['app_type'] == 2){
									?>
									 <td>
                                               
                                                <?php 
												//echo $selfScoreBut;
                                                if($selfScoreBut != 1){
                                                 
													echo $this->Form->input("appraiser_score_actual.", array("class" => "uk-width-medium-1-1 appraiser_score_actual","default"=>$kraTargetList[$key]['KraTarget']['appraiser_score_actual'], "id" => "appraiser_score_actual" ,"label" => "", "type" => "text","onblur" => "setAchievementHigherBetter(this)","onkeypress" => "return isNumberKey(event,this)", "required" => TRUE, "autocomplete"=> "off"));
													
                                                 
                                                }else{
													echo $kraTargetList[$key]['KraTarget']['appraiser_score_actual'].""; 
                                                 

                                                } ?>
                                            </td>
									
                                            <td>
                                                <input type="hidden" name="data[updateKraTarget][id][<?= $key ?>]" value="<?= $kraTargetList[$key]['KraTarget']['id'] ?>" <?=$checkBoxStatus?>>
                                                <?php 
                                                if($selfScoreBut != 1){
                                                    $achievementList = $this->Common->achievementList();
													
                                                   echo $this->Form->input("appraiser_score_achiev.", array("class" => "uk-width-medium-1-1 appraiser_score_achiev","default"=>$kraTargetList[$key]['KraTarget']['appraiser_score_achiev'], "label" => "","type" => "text", "required" => True));
                                            
                                                   
                                                }else{
													
                                                   echo $kraTargetList[$key]['KraTarget']['appraiser_score_achiev']."%"; 

                                                } ?>
                                            </td>
                                            <td><?php 
                                            if($selfScoreBut != 1){
                                                echo $this->Form->input("appraiser_score_comment.", array("class" => "uk-width-medium-1-1 textarea_expand", "id" => "appraiser_score_achiev" ,"default"=>$kraTargetList[$key]['KraTarget']['appraiser_score_comment'],"label" => "", "maxlength" => "2000", "type" => "textarea", "required" => True));
                                            }else{
                                               echo ucfirst(html_entity_decode($kraTargetList[$key]['KraTarget']['appraiser_score_comment'])); 

                                            } ?></td>
											
											<?php }else{ ?>
											
											 <td>
                                                <input type="hidden" name="data[updateKraTarget][id][<?= $key ?>]" value="<?= $kraTargetList[$key]['KraTarget']['id'] ?>" <?=$checkBoxStatus?>>
                                                <?php 
                                                if($selfScoreBut != 1){
                                                    $achievementList = $this->Common->achievementList();
                                                    echo $this->Form->input("appraiser_score_achiev.", array("class" => "uk-width-medium-1-1", "label" => "", 'options' => $achievementList, 'default' => $kraTargetList[$key]['KraTarget']['appraiser_score_achiev'],"type" => "select", "required" => True));
                                            
                                                    //echo $this->Form->input("appraiser_score_achiev.", array("class" => "uk-width-medium-1-1 appraiser_score_achiev", "id" => "appraiser_score_achiev" , "onkeypress" => "return isNumberKey(event)","label" => "", "type" => "text", 'maxlength' => '3','required' => TRUE));
                                                }else{
                                                   echo $kraTargetList[$key]['KraTarget']['appraiser_score_achiev']."%"; 

                                                } ?>
                                            </td>
                                            <td><?php 
                                            if($selfScoreBut != 1){
                                                echo $this->Form->input("appraiser_score_comment.", array("class" => "uk-width-medium-1-1 textarea_expand", "id" => "appraiser_score_achiev" , 'default' => $kraTargetList[$key]['KraTarget']['appraiser_score_comment'],"label" => "", "maxlength" => "2000", "type" => "textarea", "required" => True));
                                            }else{
                                               echo ucfirst($kraTargetList[$key]['KraTarget']['appraiser_score_comment']); 

                                            } ?></td>
                                            <?php ?>
                                        <?php 
											}
											} ?>
                                </tr>
                                <?php
                                $p++;
                            }
                        }
                        ?>
                    </table>
				
		</div>
	
								
								
                 	
				
                </div>
					<?php
				    $sl = 1;
					if(count($KRAfeedback) > 0){
						
					?>
					<label for="feedback">Showing Comments (If any):</label>
					<table class="uk-table " id="" role="grid">
                            <thead>
                                <tr role="row">
                                    <th class="uk-text-center" data-column="0">Sl. #</th>
									<th class="uk-text-center" data-column="0">Phase</th>
                                    <th data-column="1" width="50%">Comments</th>
                                    <th data-column="2">Given By</th>
                                    <th data-column="3">Given Date</th>
                                    
                                </tr>
                           </thead>
                            
                            <tbody aria-live="polite" aria-relevant="all">
                          <?php
							foreach($KRAfeedback as $k){
								$name=$this->Common->getEmpDetails($k['KraComptencyFeedback']['created_by']);
						  ?>  <tr role="row" class="odd">
                                    <td><span class="uk-text-small"><?php echo $sl;?></span></td>
                                    <td><span class="uk-text-small"><?php if($k['KraComptencyFeedback']['phase']==1){
										echo 'KRA Approval';
									}elseif($k['KraComptencyFeedback']['phase']==2){
										echo 'Mid Review';
									}elseif($k['KraComptencyFeedback']['phase']==3){
										echo 'Annual Review';
									}?></span></td><td class="uk-text-small"><?php echo $k['KraComptencyFeedback']['feedback'];?></td>
                                    <td class="uk-text-small"><?php echo $name['MyProfile']['emp_full_name'] ;?></td>
                                    <td><span class="uk-badge uk-badge-outline uk-text-upper"><?php echo date('d-m-Y', strtotime($k['KraComptencyFeedback']['created_date']));?></span></td>
                                </tr>
							<?php
							$sl++;
							}
						  ?>
							</tbody>
                        </table>
						<?php
					}
				?>
				
                <br></br>
                <div class="uk-grid">
                    <div class="uk-width-1-1"> 
                    <?php
				$annual_status_app = $this->Common->findAnnReviewsDetailsApp($empDetails['MyProfile']['emp_code'],$currentFinancialYear);
                $totalApproved = $this->Common->getOpenKraStatusLevel($empDetails['MyProfile']['emp_code'],$currentFinancialYear,'app');
				 $annual = $this->Common->findAnnReviewsDetailsTabRev($empDetails['MyProfile']['emp_code'],$currentFinancialYear);
                   // echo $totalKras = $this->common->getTotalKraTarge($empDetails['MyProfile']['emp_code'],$currentFinancialYear);
                 
				  if($totalApproved == 1){
				  ?>
				  <td><?php echo $this->Form->input("feedback", array("class" => "uk-width-medium-1-1 feedback","id" => "feedback", "label" => "Put comment (if any) :","maxlength" => "1000", "type" => "textarea", "autocomplete"=> "off")); ?>
					<?php echo $this->Form->input("kra_comp", array("class" => "uk-width-medium-1-1 kra_comp","id" => "kra_comp", "value" => "1", "type" => "hidden")); ?>
					</td>
				 <input type="submit" class="md-btn md-btn-success" onclick="return confirmAction();"  name="submit" value="Submit">
				<input type="button" class="md-btn md-btn-success" id="saveasdraft"  value="Save as draft">
				<input style="display:none" type="submit" class="md-btn md-btn-success" name="submit1" value="save" id="ww">
				<input type="hidden" value="<?=$kraTargetEmpCode;?>"  name="kraTargetEmpCode">
				<input type="hidden" value="<?=$kraTargetFinancialYear;?>"  name="kraTargetFinancialYear">
				<input type='reset' class="md-btn md-btn-primary" value='Cancel' id='removeButton'>
							
				  <?php }elseif($midReviewsDetails==1){ ?>
				  
				   <td><?php echo $this->Form->input("feedback", array("class" => "uk-width-medium-1-1 feedback","id" => "feedback", "label" => "Put comment (if any) :","maxlength" => "1000", "type" => "textarea", "autocomplete"=> "off")); ?>
					<?php echo $this->Form->input("kra_comp", array("class" => "uk-width-medium-1-1 kra_comp","id" => "kra_comp", "value" => "1", "type" => "hidden")); ?>
					</td>
				 <input type="submit" class="md-btn md-btn-success" onclick="return confirmAction();"  name="addMidAppSelfScore" value="Submit">
				<input type="button" class="md-btn md-btn-success" id="saveasdraft"  value="Save as draft">
				<input style="display:none" type="submit" class="md-btn md-btn-success" name="submit1" value="save" id="ww">
				<input type="hidden" value="<?=$kraTargetEmpCode;?>"  name="kraTargetEmpCode">
				<input type="hidden" value="<?=$kraTargetFinancialYear;?>"  name="kraTargetFinancialYear">
				<input type='reset' class="md-btn md-btn-primary" value='Cancel' id='removeButton'>
				  
				  <?php
					}elseif($annual_status_app == 1){
						
							?>
							 <td><?php echo $this->Form->input("feedback", array("class" => "uk-width-medium-1-1 feedback","id" => "feedback", "label" => "Put comment (if any) :","maxlength" => "1000", "type" => "textarea", "autocomplete"=> "off")); ?>
						<?php echo $this->Form->input("kra_comp", array("class" => "uk-width-medium-1-1 kra_comp","id" => "kra_comp", "value" => "1", "type" => "hidden")); ?>
						</td>
					
								<input type="submit" class="md-btn md-btn-success" onclick="return confirmAction();"  name="addSelfScore" value="Submit">
								<input type="button" class="md-btn md-btn-success" id="saveasdraft"  value="Save as draft">
								<input type="hidden" value="<?=$kraTargetEmpCode;?>"  name="kraTargetEmpCode">
								<input type="hidden" value="<?=$kraTargetFinancialYear;?>"  name="kraTargetFinancialYear">
								<input type='reset' class="md-btn md-btn-primary" value='Cancel' id='removeButton'>
							<?php
						 }
						?>
				
                    </div>
                </div>
                                <?php echo $this->Form->end(); ?>
                
                                    <?php 
                                    
                                   $ApprovedScore = $this->Common->getKraTargetAllApprovedScoreForAppraiser($empId,$currentFinancialYear);
                                   $totalRecords = count($ApprovedScore);

                                    $weightageSum = '';
                                    $chievSum = '';
									
									for($i=0; $i< $totalRecords; $i++){
										if($kra_config['MstPmsConfig']['app_type']==1){
											$chievSum+=$ApprovedScore[$i]['KraTarget']['self_score_achiev']*$ApprovedScore[$i]['KraTarget']['weightage'];
										}

										if($kra_config['MstPmsConfig']['app_type']==2){
											$chievSum+=$ApprovedScore[$i]['KraTarget']['self_score_actual'];
										}
									   
									}
                                 
                                    for($i=0; $i< $totalRecords; $i++){
                                       $weightageSum+=$ApprovedScore[$i]['KraTarget']['weightage'];
                                    }                                   
									
									 if($kra_config['MstPmsConfig']['app_type']==1){
										$totalAchiv = $chievSum / 100;
									}

									if($kra_config['MstPmsConfig']['app_type']==2){
										$totalAchiv = $chievSum;
									}
									
                                  

                                    /* if($totalAchiv < 60){
                                        $rating = 1;
                                    }else if($totalAchiv >= 60 && $totalAchiv <=80){
                                        $rating = 2;
                                    }else if($totalAchiv >= 81 && $totalAchiv <=100){
                                        $rating = 3;
                                    }else if($totalAchiv >= 101 && $totalAchiv <=119){
                                        $rating = 4;
                                    }else if($totalAchiv >= 120){
                                        $rating = 5;
                                    } */
									
									$kraRatings = $this->Common->findKraRatingList();
									for($kra=0;$kra<count($kraRatings);$kra++){
										
										if($totalAchiv >= $kraRatings[0]['KraRating']['achievement_from']){
											$rating = 5;
										}else if($totalAchiv >= $kraRatings[1]['KraRating']['achievement_from'] && $totalAchiv <= $kraRatings[1]['KraRating']['achievement_to']){
											$rating = 4;
										}else if($totalAchiv >= $kraRatings[2]['KraRating']['achievement_from'] && $totalAchiv <= $kraRatings[2]['KraRating']['achievement_to']){
											$rating = 3;
										}else if($totalAchiv >= $kraRatings[3]['KraRating']['achievement_from'] && $totalAchiv <= $kraRatings[3]['KraRating']['achievement_to']){
											$rating = 2;
										}else if($totalAchiv >= $kraRatings[4]['KraRating']['achievement_from'] && $totalAchiv <= $kraRatings[4]['KraRating']['achievement_to']){
											$rating = 1;
										}else{
											$rating = 1;
										}
										break;
									}

                                    /////
                                  // print_r($ApprovedScore);
                                    $appraiserSum = '';
                                    for($i=0; $i< $totalRecords; $i++){
										
											if($kra_config['MstPmsConfig']['app_type']==1){
												 $appraiserSum+=$ApprovedScore[$i]['KraTarget']['appraiser_score_achiev']*$ApprovedScore[$i]['KraTarget']['weightage'];
											}

											if($kra_config['MstPmsConfig']['app_type']==2){
												 $appraiserSum+=$ApprovedScore[$i]['KraTarget']['appraiser_score_actual'];
											}
                                      
                                    }  
								
										 if($kra_config['MstPmsConfig']['app_type']==1){
											 $totalAppraiserAchiv = $appraiserSum / 100;
										}

										if($kra_config['MstPmsConfig']['app_type']==2){
											$totalAppraiserAchiv = $appraiserSum;
										}
                                  
										
                                    /* if($totalAppraiserAchiv < 60){
                                        $appraiserRating = 1;
                                    }else if($totalAppraiserAchiv >= 60 && $totalAppraiserAchiv <=80){
                                        $appraiserRating = 2;                                        
                                    }else if($totalAppraiserAchiv >= 81 && $totalAppraiserAchiv <=100){
                                        $appraiserRating = 3;                                        
                                    }else if($totalAppraiserAchiv >= 101 && $totalAppraiserAchiv <=119){
                                        $appraiserRating = 4;
                                    }else if($totalAppraiserAchiv >= 120){
                                        $appraiserRating = 5;
                                    } */
									
									for($kra=0;$kra<count($kraRatings);$kra++){
										
										if($totalAppraiserAchiv >= $kraRatings[0]['KraRating']['achievement_from']){
											$appraiserRating = 5;
										}else if($totalAppraiserAchiv >= $kraRatings[1]['KraRating']['achievement_from'] && $totalAppraiserAchiv <= $kraRatings[1]['KraRating']['achievement_to']){
											$appraiserRating = 4;
										}else if($totalAppraiserAchiv >= $kraRatings[2]['KraRating']['achievement_from'] && $totalAppraiserAchiv <= $kraRatings[2]['KraRating']['achievement_to']){
											$appraiserRating = 3;
										}else if($totalAppraiserAchiv >= $kraRatings[3]['KraRating']['achievement_from'] && $totalAppraiserAchiv <= $kraRatings[3]['KraRating']['achievement_to']){
											$appraiserRating = 2;
										}else if($totalAppraiserAchiv >= $kraRatings[4]['KraRating']['achievement_from'] && $totalAppraiserAchiv <= $kraRatings[4]['KraRating']['achievement_to']){
											$appraiserRating = 1;
										}else{
											$appraiserRating = 1;
										}
										break;
									}


                                    ////
			
									
                                    if($annual == 1){?>
                                    <h4 class="heading_a uk-margin-bottom">Final Review for Appraisal</h4>
                                <div class="uk-grid">
                                    <div class="uk-width-medium-1-1 uk-row-first uk-margin-bottom">
                                        <div class="uk-overflow-container">
                                                    <table border="1" class="uk-table uk-tab-responsive">
                                                        <?php                                             
                                                                $commentList = $this->Common->getKraCommentByID($empDetails['MyProfile']['emp_code'],$currentFinancialYear);
                                                                $empPreComment = "";
                                                                $AppraiserPreComment = "";

                                                                for($i = 0; $i< count($commentList);$i++){
                                                                   $commentSrNo = $i+1;
                                                                   $emp_status_comment = html_entity_decode($commentList[$i]['KraTarget']['emp_status_comment']);
                                                                   $appraiser_status_comment = html_entity_decode($commentList[$i]['KraTarget']['appraiser_status_comment']);                                                         
                                                                   
                                                                   if($emp_status_comment != ""){
                                                                       $empPreComment.= "Kra "."$commentSrNo : ".ucfirst(html_entity_decode($commentList[$i]['KraTarget']['emp_status_comment']))."<br><br>";
                                                                   }else{
                                                                       $empPreComment.="Kra "."$commentSrNo : "."N/A<br>";
                                                                   }
                                                                   
                                                                   if($appraiser_status_comment != ""){
                                                                       $AppraiserPreComment.= "Kra "."$commentSrNo : ".ucfirst(html_entity_decode($commentList[$i]['KraTarget']['appraiser_status_comment']))."<br><br>";
                                                                   }else{
                                                                       $AppraiserPreComment.="Kra "."$commentSrNo : "."N/A<br>";
                                                                   }                                                                   
                                                                }
                                                                ?>
                                                        <tr>
                                                            <th class="uk-text-center md-bg-green-50 uk-te uk-text-small">KRA Overall achievement</th>
                                                            <th rowspan="2" class="uk-text-center md-bg-green-50 uk-text-small">(Self)</th>
                                                            <th class="uk-width-medium-7-10 uk-text-center md-bg-green-50 uk-text-small"><?=$totalAchiv;?> (%)</th>
                                                            <th rowspan="2" class="uk-text-center md-bg-green-50 uk-text-small"><span data-uk-tooltip="{cls:'long-text'}" title="<?=$empPreComment;?>" class="uk-badge uk-badge-success">Overall Comments (Self)</span>
                                                            </th>
                                                        </tr>
                                                        <tr>
                                                            <th class="uk-text-center md-bg-green-50 uk-text-small">Rating</th>
                                                            <th class="uk-text-center md-bg-green-50 uk-text-small"><?=$rating;?></th>                                                                               
                                                        </tr>

                                                        <tr>
                                                            <th class="uk-text-center md-bg-green-50 uk-te uk-text-small">KRA Overall achievement</th>
                                                            <th rowspan="2" class="uk-text-center md-bg-green-50 uk-text-small">(Appraiser)</th>
                                                            <th class="uk-width-medium-7-10 uk-text-center md-bg-green-50 uk-text-small"><?=$totalAppraiserAchiv;?> (%)</th>
                                                            <th rowspan="2" class="uk-text-center md-bg-green-50 uk-text-small"><span data-uk-tooltip="{cls:'long-text'}" title="<?=$AppraiserPreComment;?>" class="uk-badge uk-badge-success">Overall Comments (Appraiser)</span></th>                                        
                                                        </tr>
                                                        <tr>
                                                            <th class="uk-text-center md-bg-green-50 uk-text-small">Rating</th>
                                                            <th class="uk-text-center md-bg-green-50 uk-text-small"><?=$appraiserRating;?></th>                                                                               
                                                        </tr>
                                                    </table>
                                                </div>
                                    </div>
                                    <div class="clearfix"></div>
                                    <div class="uk-width-medium-1-1 margin-top">
                                        
                                                <div class="uk-overflow-container">
                                                    <table class="uk-table uk-text-nowrap" border="1">
                                                        <thead>
                                                            <tr class="md-bg-deep-orange-200">
                                                            <th>Rating Scale</th>
                                                            <th>Overall Achievement</th>
                                                            <th>Description of Rating</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody class="uk-text-small">
                                                            <?php 
                                                                $kraRatingList = $this->Common->findKraRatingList();                                            
                                                                for ($i = 0; $i < count($kraRatingList); $i++) {

                                                                    if ($kraRatingList[$i]['KraRating']['rating_scale'] == 1 && $kraRatingList[$i]['KraRating']['achievement_from'] == 60) {
                                                                        $overAllAchievement = "<".$kraRatingList[$i]['KraRating']['achievement_from']."%";
                                                                    }else if ($kraRatingList[$i]['KraRating']['rating_scale'] == 5 && $kraRatingList[$i]['KraRating']['achievement_from'] >= 120) {
                                                                        $overAllAchievement = ">=".$kraRatingList[$i]['KraRating']['achievement_from']."%";
                                                                    }else{
                                                                        $overAllAchievement = $kraRatingList[$i]['KraRating']['achievement_from']."% - ".$kraRatingList[$i]['KraRating']['achievement_to']."%";
                                                                    }

                                                            ?>
                                                                <tr>
                                                                    <td class="uk-text-center"><?php echo $kraRatingList[$i]['KraRating']['rating_scale'];?></td>
                                                                    <td class="uk-text-center"><?=$overAllAchievement;?></td>
                                                                    <td><?php echo wordwrap(ucfirst($kraRatingList[$i]['KraRating']['comment']), 120, "<br />\n"); ?></td>
                                                                </tr>
                                                            <?php } ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        
                                </div>

                                <?php }

                                ?>
                        </div>
                        <?php                   
                    
					
                    if($midReviewsTab== 1 || $CompetencyTab == 1){?>
                    <h3 class="uk-accordion-title" id="hideheader" >Competency Details</h3>
                    <div class="uk-accordion-content">
                        <h3 class="findAssignGroupToEmpList">Section B: Review of Assign Competencies</h3>
                        <div class="uk-width-large-1-1 uk-row-first">
                        <?php echo $this->Form->create('addCompetencyRating', array('url' => array('controller' => 'KraMasters', 'action' => 'addCompetencyRating'), 'id' => 'form_validation', 'class' => 'uk-form-stacked addCompetencyRating')); ?>
                        <div class="uk-overflow-container">
                            <div class="uk-grid">
                                <div class="uk-width-1-1">
                                <?php 
                                
                                    $empCode = $empDetails['MyProfile']['emp_code'];
                                    $deptCode = $empDetails['MyProfile']['dept_code'];
                                    $desgCode = $empDetails['MyProfile']['desg_code'];

                                    $allGroupIds = $this->Common->findAssignGroupToEmpList($desgCode,$empCode,$currentFinancialYear);
                                    
                                    $competencyList = $this->Common->findGroupCompetencyDeptDesgList($allGroupIds);                                   
                                    
                                    
                                    
                                    $assignCompetencyDeptDesgList = $this->Common->findAssignCompetencyDeptDesgList($deptCode,$desgCode,$empCode,$currentFinancialYear);
                                     
                                    
                                    
                                    if(count($assignCompetencyDeptDesgList) >= 1){
                                        $assignCompetency = array_unique(array_merge($competencyList, $assignCompetencyDeptDesgList));                                        
                                    }else{
                                        if(count($competencyList) >= 1){                                            
                                            $listC = $competencyList;
                                        }else{                                            
                                            $listC = 0;
                                        }
                                                    
                                        $assignCompetency = $listC;
                                    }
                                    
                                    $AssignCompetencyList = count($this->Common->getTotalAssignCompetencyList($empCode,$currentFinancialYear));
                                    
                                    
                                    $c = 1;
                                    
                                    $list = $this->Common->getTotalCompAppraiserCompetencyList($empCode,$appraiserId, $currentFinancialYear);
									$compStatus = $this->Common->getCompApp($empCode, $currentFinancialYear);
                                    
                                 //   print_r($compStatus);die;
                                    if($assignCompetency){
                                ?>
                                <table border="1" class="uk-table uk-tab-responsive">
                                    <tr>
									 <th <?php if($CompetencyTab== 1){ echo 'rowspan="2"';} ?> class="uk-text-center md-bg-light-green-100">Sr.No</th>
                                        <th <?php if($CompetencyTab== 1){ echo 'rowspan="2"';} ?> class="uk-text-center md-bg-light-green-100">Competency</th>
										
									<?php 
										if($midReviewsTab== 1){
									?>
                                       <th <?php if($CompetencyTab== 1){ echo 'rowspan="2"';} ?> class="uk-text-center md-bg-light-green-100">Appraiser Mid Reviews</th>
									<?php
										}
									?>
									
									<?php 
									
										if($CompetencyTab== 1){
											if($kra_config['MstPmsConfig']['app_type']== 2){
									?>
                                        <th colspan="2" class="uk-text-center md-bg-light-green-100">Appraiser Annual Assessment</th>
									<?php
											}else{
												echo '<th colspan="2" class="uk-text-center md-bg-light-green-100">Appraiser Annual Rating</th>';
											}
										}
									?>
                                    </tr>
                                 
									<?php 
										if($CompetencyTab== 1){
									?>
									   <tr>
									<?php
										if($kra_config['MstPmsConfig']['app_type']== 2){
									?>
                                        <th class="uk-text-center md-bg-light-green-100">Assessment</th>
										<?php
										}else{
											echo ' <th class="uk-text-center md-bg-light-green-100">Rating</th>';
											
										}
										?>
                                        <th class="uk-text-center md-bg-light-green-100">Comments</th>
										 </tr>
										<?php
										}
									?>
                                   
                                <?php     
								$appRatingScore = 0;
								for ($comp = 0; $comp < count($list);$comp++) { 
                                        $appraiserRating = $list[$comp]['CompetencyTarget']['appraiser_rating'];                                        
                                        $appRating += $appraiserRating;
										$appRatingScore = $appRating;
								}
                                    if(count($compStatus) == 1){
                                    
                                    $hideSaveButton = true;
                                    $appRating = 0;
                                    $id = array();
                                    for ($comp = 0; $comp < count($list);$comp++) { 
                                        $appraiserRating = $list[$comp]['CompetencyTarget']['appraiser_rating'];                                        
                                        $appRating += $appraiserRating;
										//$appRatingScore = $appRating;
										
										//print_r($list);
										?>
                                        <tr>
                                            <td><?=$comp+1?></td>
                                            <td><?php echo $this->Common->findCompetencyNameByID($list[$comp]['CompetencyTarget']['competency_id']).' <span title="'.$this->Common->findCompetencyDescByID($list[$comp]['CompetencyTarget']['competency_id']).'"><i class="material-icons">assignment</i></span>';
                                            $id[] = $list[$comp]['CompetencyTarget']['competency_id'];?></td>
											
									<?php 
									if($midReviewsTab== 1){
										//echo 'wwww';
										if($compmidReviewsDetails == $countCompetency){
									?>
										<td><?php echo wordwrap(ucfirst(html_entity_decode($list[$comp]['CompetencyTarget']['appraiser_mid_rating_comment'])),50, "<br />\n"); ?></td>
									<?php
										}
									}
									?>
									
									<?php 
									
										if($CompetencyTab== 1){
											if($kra_config['MstPmsConfig']['mid_review'] == 1){
									?>
                                        <td><?php echo wordwrap(ucfirst(html_entity_decode($list[$comp]['CompetencyTarget']['appraiser_mid_rating_comment'])),50, "<br />\n"); ?></td>
											<?php } ?>
                                            <td><?php echo $list[$comp]['CompetencyTarget']['appraiser_rating']; ?></td>
                                            <td><?php echo wordwrap(ucfirst(html_entity_decode($list[$comp]['CompetencyTarget']['appraiser_comment'])),50, "<br />\n"); ?></td>
										
									<?php
										}
									?>
									</tr>
                                      
                                    <?php 

                                    } }else{
                                    $id = array();   
                                    foreach ($assignCompetency as $key => $value) {
//print_r($assignCompetency);										?>
                                        <tr>
                                            <td><?=$c?></td>
                                            <td><?php
											$compID = $this->Common->findCompetencyIDByName($value);
                                            $id[] = $compID;
											echo $value.' <span title="'.$this->Common->findCompetencyDescByID($compID).'"><i class="material-icons">assignment</i></span>';
                                           
                                            echo $this->Form->input('competency_id.', array('type' => 'hidden','value' => $compID));
                                            $ratingList = $this->Common->findCompetencyRatList();
											?></td>
									<?php 
									$comp_review_mid = $this->Common->getCompMidAppraiserReview($empCode,$compID, $currentFinancialYear);
									
									if($midReviewsTab== 1){
										
										if( $countCompetency == 1){
										
										
									?>
										<td><?php echo wordwrap(ucfirst(html_entity_decode($comp_review_mid)),50, "<br />\n"); ?></td>
									<?php
										}else{
										?>
										<td><?php echo $this->Form->input("appraiser_mid_rating_comment.", array("class" => "uk-width-medium-1-1 textarea_expand","style"=>"width:auto", "label" => "", 'minlength' => '20','maxlength' => '2000', "value" => $comp_review_mid ,"type" => "textarea", "required" => True)); ?></td>
									<?php	
										}
									}
									?>
									
									<?php 
										if($CompetencyTab== 1){
											$comp_review_ann = $this->Common->getCompAnnAppraiserReview($empCode,$empDetails['MyProfile']['comp_code'],$compID, $currentFinancialYear);
											//echo $compID;print_r($comp_review_ann);die("sssssssssssssssssssssss");
									
									?>
									
                                            <td>
											<div class="input select">
											<label for="addCompetencyRatingAppraiserRating"></label>
											<select name="data[addCompetencyRating][appraiser_rating][]" class="uk-width-medium-1-1" required="required" id="addCompetencyRatingAppraiserRating">
									<?php 
									if($kra_config['MstPmsConfig']['app_type']== 1){		
									for($i=0;$i<count($ratingList);$i++){
										if($comp_review_ann['CompetencyTarget']['appraiser_rating']==(number_format($ratingList[$i]['CompetencyRating']['rating_scale'],2))){$selected = 'selected="selected"'; }else{$selected = '';}
										echo '<option value="'.number_format($ratingList[$i]['CompetencyRating']['rating_scale'],2).'" '.$selected.' >'.number_format($ratingList[$i]['CompetencyRating']['rating_scale'],2).'</option>';
									}
									}
									if($kra_config['MstPmsConfig']['app_type']== 2){		
									for($i=0;$i<count($ratingList);$i++){
										if($comp_review_ann['CompetencyTarget']['appraiser_rating']==(number_format($ratingList[$i],2))){$selected = 'selected="selected"'; }else{$selected = '';}
										echo '<option value="'.number_format($ratingList[$i],2).'" '.$selected.'>'.number_format($ratingList[$i],2).'</option>';
									}
									}
									?>
												</select>
											</div>
											
											
											<?php //echo $this->Form->input("appraiser_rating.", array("class" => "uk-width-medium-1-1", "label" => "", 'options' => $ratingList,"type" => "select", "required" => True)); ?>
											</td>
                                            <td><?php echo $this->Form->input("appraiser_rating_comment.", array("class" => "uk-width-medium-1-1 textarea_expand", "label" => "", 'minlength' => '20','maxlength' => '2000', "value" => $comp_review_ann['CompetencyTarget']['appraiser_comment'],"type" => "textarea", "required" => True)); ?></td>
										
									<?php
										}
									?>
                                     </tr>  
                                <?php $c++; 

                                    }}?> 
                                    <input type="hidden" name ="ids" id ="newid" value ='<?php echo json_encode($id); ?>'>
                            </table> 
                                    <div style="text-align:right;font-size:small;color:red">** Min. 20 characters required in each competency</div>
                                    
                                </div>
                            </div>
							<?php
				    $sl = 1;
					if(count($compfeedback) > 0){
						
					?>
					<label for="feedback">Showing Comments (If any):</label>
					<table class="uk-table " id="" role="grid">
                            <thead>
                                <tr role="row">
                                    <th class="uk-text-center" data-column="0">Sl. #</th>
									<th class="uk-text-center" data-column="0">Phase</th>
                                    <th data-column="1" width="50%">Comments</th>
                                    <th data-column="2">Given By</th>
                                    <th data-column="3">Given Date</th>
                                    
                                </tr>
                           </thead>
                            
                            <tbody aria-live="polite" aria-relevant="all">
                          <?php
							foreach($compfeedback as $k){
								$name=$this->Common->getEmpDetails($k['KraComptencyFeedback']['created_by']);
						  ?>  <tr role="row" class="odd">
                                    <td><span class="uk-text-small"><?php echo $sl;?></span></td>
                                    <td><span class="uk-text-small"><?php if($k['KraComptencyFeedback']['phase']==1){
										echo 'KRA Approval';
									}elseif($k['KraComptencyFeedback']['phase']==2){
										echo 'Mid Review';
									}elseif($k['KraComptencyFeedback']['phase']==3){
										echo 'Annual Review';
									}?></span></td><td class="uk-text-small"><?php echo $k['KraComptencyFeedback']['feedback'];?></td>
                                    <td class="uk-text-small"><?php echo $name['MyProfile']['emp_full_name'] ;?></td>
                                    <td><span class="uk-badge uk-badge-outline uk-text-upper"><?php echo date('d-m-Y', strtotime($k['KraComptencyFeedback']['created_date']));?></span></td>
                                </tr>
							<?php
							$sl++;
							}
						  ?>
							</tbody>
                        </table>
						<?php
					}
				?>
				<br/><br/>
                            <div class="uk-grid">
                                <div class="uk-width-1-1">
                                    <?php 
                                    if(count($assignCompetency) >= 1){
										
										if($midCompReviewsTab== 0 && ($kra_config['MstPmsConfig']['mid_review'] == 1)){
									?>
									<?php 
									?>
									<td><?php echo $this->Form->input("feedback", array("class" => "uk-width-medium-1-1 feedback","id" => "feedback", "label" => "Put comment (if any) :","maxlength" => "1000", "type" => "textarea", "autocomplete"=> "off")); ?>
										<?php echo $this->Form->input("kra_comp", array("class" => "uk-width-medium-1-1 kra_comp","id" => "kra_comp", "value" => "2", "type" => "hidden")); ?>
									</td>
									<?php 
								?>
										 <input type="submit" class="md-btn md-btn-success" name="submitAppraiserMidRating" value="Submit">
										 <input type="button" class="md-btn md-btn-success" id="saveasdraftcomp"  value="Save as draft">
										<input type='reset' class="md-btn md-btn-primary" value='Cancel'>
										<input type='hidden' class="md-btn md-btn-primary" name="FinancialYear" value='<?=$currentFinancialYear?>'>
										<input type='hidden' class="md-btn md-btn-primary" name="empCode" value='<?=$empCode?>'>
										<input type='hidden' class="md-btn md-btn-primary" name="empCompCode" value='<?=$empDetails['MyProfile']['comp_code'];?>'>
									<?php
										}
									?>
                                    <?php 
										if($CompetencyTab== 1 && $compannReviewsDetails!=1 ){
									
                                    if($hideSaveButton != 1){?>
                                    <?php 
									?>
									<td><?php echo $this->Form->input("feedback", array("class" => "uk-width-medium-1-1 feedback","id" => "feedback", "label" => "Put comment (if any) :","maxlength" => "1000", "type" => "textarea", "autocomplete"=> "off")); ?>
										<?php echo $this->Form->input("kra_comp", array("class" => "uk-width-medium-1-1 kra_comp","id" => "kra_comp", "value" => "2", "type" => "hidden")); ?>
									</td>
									<?php 
								?>
								<input type="submit" class="md-btn md-btn-success" name="submitAppraiserRating" value="Submit">
								<input type="button" class="md-btn md-btn-success" id="saveasdraftcomp"  value="Save as draft">
                                    <input type='reset' class="md-btn md-btn-primary" value='Cancel'>
                                    <input type='hidden' class="md-btn md-btn-primary" name="FinancialYear" value='<?=$currentFinancialYear?>'>
                                    <input type='hidden' class="md-btn md-btn-primary" name="empCode" value='<?=$empCode?>'>
                                    <input type='hidden' class="md-btn md-btn-primary" name="empCompCode" value='<?=$empDetails['MyProfile']['comp_code'];?>'>                                    
										<?php } }
									}?>                                    
                                </div>
                                <?php if($CompetencyTab== 1 && $compannReviewsDetails==1 ){
									
									?>
                                <table border="0" class="uk-table uk-tab-responsive">                                            
                                    <tr>
									<?php if($kra_config['MstPmsConfig']['app_type'] == 1){ ?>
										 <td class="uk-text-center md-bg-grey-50">Competency Overall Rating** (Appraiser)</td>
                                        <td class="uk-text-center md-bg-grey-50"><?php echo round($this->Common->truncate_number($appRatingScore/count($list))) ;?></td>
									<?php } ?>
										<?php if($kra_config['MstPmsConfig']['app_type'] == 2){ ?>
                                        <td class="uk-text-center md-bg-grey-50">Competency Total ** (Appraiser)</td>
                                        <td class="uk-text-center md-bg-grey-50"><?php echo $this->Common->truncate_number($appRatingScore) ;?></td>
										 <td class="uk-text-center md-bg-grey-50">Competency Overall % ** (Appraiser)</td>
                                        <td class="uk-text-center md-bg-grey-50"><?php echo $this->Common->truncate_number(round(($appRatingScore/count($list))*100)) ;?></td>
									<?php } ?>
                                    </tr>
                                </table>
                                <?php } ?>
                            </div>
                            <?php }else{?>
                                <span class="uk-text-danger">Competency not assign for this Employee.. please contact to HR Department</span>                                
                                
                    <?php }?>
                            <?php echo $this->Form->end(); ?>
                            <div class="uk-grid">
                                <a onClick ="return getCompetencyBehaviouList()" class= md-btn-flat md-btn-flat-primary md-btn-wave waves-effect waves-button uk-text-lower" data-uk-modal="{target:'#modal_overflow'}">***Click here to refer Behavioural Indicators describing the competency for evaluation</a>
                                <br>
                                <div class="uk-overflow-container">
                                    <table class="uk-table uk-text-nowrap" border="1">
                                        <thead>
                                            <tr class="md-bg-light-green-50">
                                                <?php
											if($kra_config['MstPmsConfig']['app_type']== 2){
											?>
                                                <th class="uk-text-center">Assessment Scale</th>
											<?php
											}else{
												echo '   <th class="uk-text-center">Rating Scale</th>';
											}
											?>
                                                <th class="uk-text-center">Description</th>
                                            </tr>
                                        </thead>
                                        <tbody class="uk-text-small">
                                            <?php 
                                                $kraRatingList = $this->Common->findCompetencyRatingList();                                            
                                                for ($i = 0; $i < count($kraRatingList); $i++) {

                                                    if ($kraRatingList[$i]['CompetencyRating']['rating_scale'] == 1 && $kraRatingList[$i]['CompetencyRating']['achievement_from'] == 60) {
                                                        $overAllAchievement = "<".$kraRatingList[$i]['CompetencyRating']['achievement_from']."%";
                                                    }else if ($kraRatingList[$i]['CompetencyRating']['rating_scale'] == 5 && $kraRatingList[$i]['CompetencyRating']['achievement_from'] >= 120) {
                                                        $overAllAchievement = ">=".$kraRatingList[$i]['CompetencyRating']['achievement_from']."%";
                                                    }else{
                                                        $overAllAchievement = $kraRatingList[$i]['CompetencyRating']['achievement_from']."% - ".$kraRatingList[$i]['CompetencyRating']['achievement_to']."%";
                                                    }

                                            ?>
                                                <tr>
                                                    <td class="uk-text-center"><?php echo $kraRatingList[$i]['CompetencyRating']['rating_scale'];?></td>                                                    
                                                    <td><?php echo wordwrap(ucfirst(html_entity_decode($kraRatingList[$i]['CompetencyRating']['comment'])), 120, "<br />\n"); ?></td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        </div>
                    </div>
                    <?php } 
					 
                    
					?>
					
					
					
                    <!--- Development Plan Start -->
                    <?php 
                    
                    $developmentPlanTab = count($this->Common->OpenDevpPlanForAppraiser($empDetails['MyProfile']['emp_code'],$currentFinancialYear)); 
                   
                    if($developmentPlanTab >=1){?>
                    <?php  //if($CompetencyTab == 1){?>
                        <h3 class="uk-accordion-title">Development Plan</h3>
                        <div class="uk-accordion-content">
                            <h3>Section C: Development Plan</h3>
                            <?php
						
						if($kra_config['MstPmsConfig']['app_type']==2){
						?>
						 <p class="md-bg-yellow-50 padding" style="padding:12px 8px"><b> A ) Training Needs Identification for next year </b><br>
                           </p>
						<?php
						}else{
						?>
						
                        <p class="md-bg-yellow-50 padding" style="padding:12px 8px"><b> A ) Area of Strength & Development</b><br>
                            <span class="uk-text-large">On the basis of Performance thus far, please identify Top 3 </span> 
                            <span class="uk-text-small">(i) Key Areas of Strength and (ii) Key Areas of Development. (You may include both work-related as well as personality related attributes)</span></p>
						<?php
						}
						?>
                           
                            <?php                            
                            if($developmentPlanList[0]['AppraisalDevelopmentPlan']['app_review_status'] == 0){
								if($developmentPlanList[0]['AppraisalDevelopmentPlan']['mod_review_status'] == 2){
								?>
							<p class="md-bg-deep-orange-200" style="padding:12px 8px"><b> Moderator remarks for rejecting this plan :-</b><br>
                          
                            <span class="uk-text-small"><?php echo $developmentPlanList[0]['AppraisalDevelopmentPlan']['mod_remarks']; ?></span></p>
						<?php
								}
								//echo '<pre>';print_r($developmentPlanList);die("ooooooo");
								?> <div class="clearfix"></div>
                            <?php echo $this->Form->create('addDevelopmentPlan', array('url' => array('controller' => 'KraMasters', 'action' => 'addDevelopmentPlan'), 'id' => 'form_validation', 'class' => 'uk-form-stacked addDevelopmentPlan')); ?>
                            <table border="1" class="uk-table uk-tab-responsive">
                                <tr>
                                    <th class="uk-width-medium-1-2 uk-row-first uk-text-center md-bg-yellow-50">Self</th>
                                    <th class="uk-width-medium-1-2 uk-text-center md-bg-yellow-50">Appraiser</th>
                                </tr>
                                <tr>
								<?php
								if($kra_config['MstPmsConfig']['app_type']==2){
									?>
									<th class="md-bg-yellow-50" colspan="2">Functional :-</th>
									<?php
								}else{
									?>
                                   <th class="md-bg-yellow-50" colspan="2">Areas of Strength (200 chars min, 2000 max)</th>
								<?php } ?>
                                    
                                </tr>
                                <tr>
                                    <td><?php echo ucfirst(html_entity_decode($developmentPlanList[0]['AppraisalDevelopmentPlan']['self_areas_strength']));?></td>
									<?php
									if($kra_config['MstPmsConfig']['app_type']== 2){
									?>
                                    <td><?php echo $this->Form->input("appraiser_areas_strength", array("class" => "md-input", "label" => "", "minlength"  => "200", "maxlength"  => "2000", "type" => "textarea",'value'=>html_entity_decode($developmentPlanList[0]['AppraisalDevelopmentPlan']['self_areas_strength']), "required" => True)); ?></td>
									<?php 
									}else{
									?>
									 <td><?php echo $this->Form->input("appraiser_areas_strength", array("class" => "md-input", "label" => "", "minlength"  => "200", "maxlength"  => "2000", "type" => "textarea",'value'=>html_entity_decode($developmentPlanList[0]['AppraisalDevelopmentPlan']['appraiser_areas_strength']), "required" => True)); ?></td>
									<?php
									}
									?>
                                </tr>
                                <tr>
								<?php
								if($kra_config['MstPmsConfig']['app_type']==2){
									?>
									<th class="md-bg-yellow-50" colspan="2">Behavioural :-</th>
									<?php
								}else{
									?>
                                    <th class="md-bg-yellow-50" colspan="2">Areas of Development (200 chars min, 2000 max)</th>
								<?php } ?>
                                   
                                </tr>
                                <tr>
                                    <td><?php echo ucfirst(html_entity_decode($developmentPlanList[0]['AppraisalDevelopmentPlan']['self_areas_development']));?></td>
                                    <?php
									if($kra_config['MstPmsConfig']['app_type']== 2){
									?>
                                    <td><?php echo $this->Form->input("appraiser_areas_development", array("class" => "md-input", "label" => "",  "minlength"  => "200", "maxlength"  => "2000", "type" => "textarea",'value'=>html_entity_decode($developmentPlanList[0]['AppraisalDevelopmentPlan']['self_areas_development']), "required" => True)); ?></td>
									<?php 
									}else{
									?>
									 <td><?php echo $this->Form->input("appraiser_areas_development", array("class" => "md-input", "label" => "",  "minlength"  => "200", "maxlength"  => "2000", "type" => "textarea",'value'=>html_entity_decode($developmentPlanList[0]['AppraisalDevelopmentPlan']['appraiser_areas_development']), "required" => True)); ?></td>
									<?php
									}
									?>
									
                                </tr>
                                <tr>
								<?php
								if($kra_config['MstPmsConfig']['app_type']==2){
									?>
									<td colspan="2" class="uk-text-bold">Summary Comments :-</td>
									<?php
								}else{
									?>
                                     <td colspan="2" class="uk-text-bold">* To be filled in by the Supervisor.</td>
								<?php } ?>
                                   
                                </tr>
                                <tr>
								<?php
								if($kra_config['MstPmsConfig']['app_type']==2){
									?>
									<td colspan="2" class="md-bg-yellow-50">Use this space to provide comments on employee's performance including description of thier behaviour, actions and impact to thier performance. </td>
									<?php
								}else{
									?>
                                     <td colspan="2" class="md-bg-yellow-50">Is the Employee capable of moving to a higher or another role within the Function/Department or in any other Function/ Department within the organization? If yes, then which role? Please justify.</td>
								<?php } ?>
                                    
                                </tr>
                                <tr>
                                    <td colspan="2"><?php echo $this->Form->input("higher_another_role", array("class" => "md-input", "label" => "", "minlength"  => "20", 'maxlength' => '2000', "type" => "textarea",'value'=>html_entity_decode($developmentPlanList[0]['AppraisalDevelopmentPlan']['higher_another_role']) , "required" => True)); ?></td>
                                </tr>
                            </table>
                            
                            <p class="md-bg-yellow-50 padding" style="padding:12px 8px">
							
                                <b>* To be filled in by the Supervisor.</b><br>
                                <b>B) Training & Development Inputs</b><br>
                                <span class="uk-text-large">Please provide inputs on the Training / Coaching / Development Needs of the Appraisee.Please specify responsibility- Manager, Individual, Class Room Training, under the said Column.</span> 
                            </p>
                            <div class="uk-overflow-container uk-margin-bottom">
							<table border="1" class="uk-table uk-text-nowrap uk-tab-responsive" id="TextBoxesGroup">
                                <tr>
                                    <th class="uk-text-center uk-width-small-1-10">Sr.No.</th>
                                    <th class="uk-width-medium-1-2 uk-row-first uk-text-center md-bg-yellow-50">Identified areas for development </th>
                                    <th class="uk-width-medium-1-2 uk-row-first uk-text-center md-bg-yellow-50">Reason/Observed Behavior</th>
                                    <th class="uk-width-medium-1-2 uk-row-first uk-text-center md-bg-yellow-50">Suggested Action Plan</th>
                                    <th class="uk-width-medium-1-2 uk-row-first uk-text-center md-bg-yellow-50">Timelines</th>
                                    <th class="uk-width-medium-1-2 uk-text-center md-bg-yellow-50">Responsibility</th>
                                </tr>
								 <?php 
                                $trainingDevelopmentList = $this->Common->findTrainingDevelopmentList($developmentPlanList[0]['AppraisalDevelopmentPlan']['id'],$developmentPlanList[0]['AppraisalDevelopmentPlan']['emp_code'],$developmentPlanList[0]['AppraisalDevelopmentPlan']['financial_year']);
                                
								if(count($trainingDevelopmentList) >= 1){
                                for($t = 0; $t< count($trainingDevelopmentList);$t++){
                                
                                
                                ?>
                              <tr>
                                    <td class="uk-text-center uk-width-small-1-10">1</td>
                                    <td><?php echo $this->Form->input("identified_areas_for_development.", array("class" => "textarea_expand", "value" =>$trainingDevelopmentList[$t]['TrainingDevelopment']['identified_areas_for_development'], "label" => "", "type" => "textarea", "minlength"  => "20", 'maxlength' => '2000',"required" => True)); ?></td>
                                    <td><?php echo $this->Form->input("observed_behavior.", array("class" => "textarea_expand", "value" =>$trainingDevelopmentList[$t]['TrainingDevelopment']['observed_behavior'], "label" => "", "type" => "textarea","minlength"  => "20", 'maxlength' => '2000', "required" => True)); ?></td>
                                    <td><?php echo $this->Form->input("suggested_action_plan.", array("class" => "textarea_expand", "value" =>$trainingDevelopmentList[$t]['TrainingDevelopment']['suggested_action_plan'], "label" => "", "type" => "textarea", "minlength"  => "20", 'maxlength' => '2000',"required" => True)); ?></td>
                                    <td><?php echo $this->Form->input("timelines.", array("class" => "textarea_expand", "value" =>$trainingDevelopmentList[$t]['TrainingDevelopment']['timelines'], "label" => "", "type" => "textarea", "minlength"  => "20", 'maxlength' => '2000',"required" => True)); ?></td>
                                    <td><?php echo $this->Form->input("responsibility.", array("class" => "textarea_expand", "value" =>$trainingDevelopmentList[$t]['TrainingDevelopment']['responsibility'], "label" => "", "type" => "textarea","minlength"  => "20", 'maxlength' => '2000', "required" => True)); ?></td>
                                </tr>
                                <?php }
								}else{
								?>
                                <tr>
                                    <td class="uk-text-center uk-width-small-1-10">1</td>
                                    <td><?php echo $this->Form->input("identified_areas_for_development.", array("class" => "textarea_expand", "label" => "", "type" => "textarea", "minlength"  => "20", 'maxlength' => '2000',"required" => True)); ?></td>
                                    <td><?php echo $this->Form->input("observed_behavior.", array("class" => "textarea_expand", "label" => "", "type" => "textarea","minlength"  => "20", 'maxlength' => '2000', "required" => True)); ?></td>
                                    <td><?php echo $this->Form->input("suggested_action_plan.", array("class" => "textarea_expand", "label" => "", "type" => "textarea", "minlength"  => "20", 'maxlength' => '2000',"required" => True)); ?></td>
                                    <td><?php echo $this->Form->input("timelines.", array("class" => "textarea_expand", "label" => "", "type" => "textarea", "minlength"  => "20", 'maxlength' => '2000',"required" => True)); ?></td>
                                    <td><?php echo $this->Form->input("responsibility.", array("class" => "textarea_expand", "label" => "", "type" => "textarea","minlength"  => "20", 'maxlength' => '2000', "required" => True)); ?></td>
                                </tr>
								<?php } ?>
                            </table>
                            </div>
							 <input type='button' class="md-btn md-btn-primary plusbtn"  value='Add More' id='addButton'>
                             <input type='button' class="md-btn md-btn-danger minusbtn" value='Remove' id='removeButton'>   
                            <div class="clearfix"></div>
							
                           <br>  <br>
                            <div class="uk-grid">
                                <div class="uk-width-1-1">
                                    <?php $empCode = $empDetails['MyProfile']['emp_code'];?>
                                    <input type="submit" class="md-btn md-btn-success" name="submitAppraiserPlan" value="Submit">
									<input type="button" class="md-btn md-btn-success" id="saveasdraftplan"  value="Save as draft">
                                                                   
                                  
                                    <input type="hidden" class="md-btn md-btn-success" name="currentFinancialYear" value="<?=$currentFinancialYear;?>">
                                    <input type="hidden" class="md-btn md-btn-success" name="appraiserId" value="<?=$developmentPlanList[0]['AppraisalDevelopmentPlan']['appraiser_id'];?>">
                                    <input type="hidden" class="md-btn md-btn-success" name="depPlanId" value="<?=$developmentPlanList[0]['AppraisalDevelopmentPlan']['id'];?>">
                                    <input type="hidden" class="md-btn md-btn-success" name="empCode" value="<?=$empCode;?>">
									
									<input type='button' class="md-btn md-btn-primary" data-uk-modal="{target:'#modal_overflow_response'}"  onclick="return viewFiles(<?=$developmentPlanList[0]['AppraisalDevelopmentPlan']['id']; ?>,<?=$developmentPlanList[0]['AppraisalDevelopmentPlan']['emp_code']; ?>)" value='Reject' />
								
								
						
                                </div>
                            </div>
                            <?php echo $this->form->end();?>
							<div class="uk-width-large-1-1">
									<div id="modal_overflow_response" class="uk-modal">
										<div class="uk-modal-dialog uk-modal-dialog-small">
											<button type="button" class="uk-modal-close uk-close"></button>            
											<div class="uk-overflow-container">
												<span id="vidResponse" class="verflow container"></span>
											</div>          
										</div>
									</div>
								</div>
                            <?php }else{
								//echo '<pre>';print_r($developmentPlanList);die("wwwww");
								?>
                            
                            <table border="1" class="uk-table uk-tab-responsive" id="TextBoxesGroup">
                                <tr>
                                    <th class="uk-width-medium-1-2 uk-row-first uk-text-center md-bg-yellow-50">Self</th>
                                    <th class="uk-width-medium-1-2 uk-text-center md-bg-yellow-50">Appraiser</th>
                                </tr>
                                <tr>
								<?php
								if($kra_config['MstPmsConfig']['app_type']==2){
									?>
									<th class="md-bg-yellow-50" colspan="2">Functional :- </th>
									<?php
								}else{
									?>
                                     <th class="md-bg-yellow-50" colspan="2">Areas of Strength </th>
								<?php } ?>
                                    
                                </tr>
                                <tr>
                                    <td><?php echo ucfirst(html_entity_decode($developmentPlanList[0]['AppraisalDevelopmentPlan']['self_areas_strength']));?></td>
                                    <td><?php echo ucfirst(html_entity_decode($developmentPlanList[0]['AppraisalDevelopmentPlan']['appraiser_areas_strength']));?></td>                                    
                                </tr>
                                <tr>
								<?php
								if($kra_config['MstPmsConfig']['app_type']==2){
									?>
								 <th class="md-bg-yellow-50" colspan="2">Behavioural :-</th>
									<?php
								}else{
									?>
                                     <th class="md-bg-yellow-50" colspan="2">Areas of Development</th>
								<?php } ?>
                                   
                                </tr>
                                <tr>
                                    <td><?php echo ucfirst(html_entity_decode($developmentPlanList[0]['AppraisalDevelopmentPlan']['self_areas_development']));?></td>
                                    <td><?php echo ucfirst(html_entity_decode($developmentPlanList[0]['AppraisalDevelopmentPlan']['appraiser_areas_development']));?></td>                                    
                                </tr>
                                <tr>
								<?php
								if($kra_config['MstPmsConfig']['app_type']==2){
									?>
								 <td colspan="2" class="uk-text-bold">Summary Comments :-</td>
									<?php
								}else{
									?>
                                     <td colspan="2" class="uk-text-bold">* To be filled in by the Supervisor.</td>
								<?php } ?>
                                   
                                </tr>
                                <tr>
								<?php
								if($kra_config['MstPmsConfig']['app_type']==2){
									?>
								<td colspan="2" class="md-bg-yellow-50"><b>Comments on employee's performance including description of thier behaviour, actions and impact to thier performance.</b></td>
									<?php
								}else{
									?>
                                    <td colspan="2" class="md-bg-yellow-50"><b>Is the Employee capable of moving to a higher or another role within the Function/Department or in any other Function/ Department within the organization? If yes, then which role? Please justify.</b></td>
								<?php } ?>
                                    
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <?php echo ucfirst(html_entity_decode($developmentPlanList[0]['AppraisalDevelopmentPlan']['higher_another_role']));?></td>
                                </tr>
                            </table>
                            
                            <p class="md-bg-yellow-50 padding" style="padding:12px 8px">
                                <b>* To be filled in by the Supervisor.</b><br>
                                <b>B) Training & Development Inputs</b><br>
                                <span class="uk-text-large">Please provide inputs on the Training / Coaching / Development Needs of the Appraisee.Please specify responsibility - Manager, Individual, Class Room Training, under the said Column.</span> 
                            </p>
                            <div class="uk-overflow-container uk-margin-bottom">
                            <table border="1" class="uk-table uk-tab-responsive" id="TextBoxesGroup">
                                <tr>
                                    <th class="uk-text-center md-bg-yellow-50">Sr.No.a</th>
                                    <th class="uk-text-center md-bg-yellow-50">Identified areas for development </th>
                                    <th class="uk-text-center md-bg-yellow-50">Reason/Observed Behavior</th>
                                    <th class="uk-text-center md-bg-yellow-50">Suggested Action Plan</th>
                                    <th class="uk-text-center md-bg-yellow-50">Timelines</th>
                                    <th class="uk-text-center md-bg-yellow-50">Responsibility</th>
                                    <!-- <th class="uk-text-center md-bg-yellow-50">Action</th> -->
                                </tr>
                                <?php 
                                $trainingDevelopmentList = $this->Common->findTrainingDevelopmentList($developmentPlanList[0]['AppraisalDevelopmentPlan']['id'],$developmentPlanList[0]['AppraisalDevelopmentPlan']['emp_code'],$developmentPlanList[0]['AppraisalDevelopmentPlan']['financial_year']);
                                
                                for($t = 0; $t< count($trainingDevelopmentList);$t++){
                                
                                
                                ?>
                                <tr>
                                    <td class="uk-text-center"><?php echo $t+1;?></td>
                                    <td><?php echo wordwrap(ucfirst(html_entity_decode($trainingDevelopmentList[$t]['TrainingDevelopment']['identified_areas_for_development'])),27, "<br />\n"); ?></td>
                                    <td><?php echo wordwrap(ucfirst(html_entity_decode($trainingDevelopmentList[$t]['TrainingDevelopment']['observed_behavior'])), 30, "<br />\n"); ?></td>
                                    <td><?php echo wordwrap(ucfirst(html_entity_decode($trainingDevelopmentList[$t]['TrainingDevelopment']['suggested_action_plan'])), 30, "<br />\n"); ?></td>
                                    <td><?php echo wordwrap(ucfirst(html_entity_decode($trainingDevelopmentList[$t]['TrainingDevelopment']['timelines'])), 30, "<br />\n"); ?></td>
                                    <td><?php echo wordwrap(ucfirst(html_entity_decode($trainingDevelopmentList[$t]['TrainingDevelopment']['responsibility'])), 30, "<br />\n"); ?></td>
                                    <!-- <td><a href="<?php echo $this->webroot; ?>KraMasters/viewAppraiserKraTarget/<?php echo base64_encode($trainingDevelopmentList[$t]['TrainingDevelopment']['id']); ?>" onClick="return confirm('are you sure you want to update??');" title="Click to Update" class="uk-badge uk-badge-primary">Update</a></td> -->
                                </tr>
                                <?php } ?>
                            </table>
                            
                            <?php echo "<span class='uk-text-success'>***Your Development Plan saved for this financial year</span>";
                            }?>
                        </div>
                               
                        </div>
                        <?php 
                        $summary = count($this->Common->openSummaryDiscussion($empDetails['MyProfile']['emp_code'],$currentFinancialYear)); 
                        if($summary >=1){?>
                        
                        <h3 class="uk-accordion-title">Summary Of Discussion</h3>
                        <div class="uk-accordion-content">
                            <h3>Section D: Summary Of Discussion</h3>
                            <div class="uk-overflow-container uk-margin-bottom">
                                <table border="1" class="uk-table uk-text-nowrap uk-tab-responsive" id="TextBoxesGroup">
                                    <tr>
                                        <th class="md-bg-yellow-50">Appraiser Comments***</th>                                    
                                    </tr>
                                    <tr>
                                        <td><?php echo wordwrap($AppraiserPreComment, 120, "<br />\n"); ?></td>
                                    </tr>
                                    <tr>
                                        <th class="md-bg-yellow-50">Employee Comments***</th>
                                    </tr>
                                    <tr>
                                        <td><?=$empPreComment?></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <?php }}?> 
                    <!--- Development Plan End -->
                    
                    <!--- Start Overall Rating -->
                    <?php $overallRatingList = $this->Common->getKraCompOverallRating($empDetails['MyProfile']['emp_code'],$currentFinancialYear);
                    
                        $moderatorSelfOverallRating = $overallRatingList[0]['KraCompOverallRating']['moderator_self_overall_rating'];
                        $moderatorCompOverallRating = $overallRatingList[0]['KraCompOverallRating']['moderator_comp_overall_rating'];              
                       $overAllAnnualStatus = $this->Common->overAllAnnualStatus($empDetails['MyProfile']['emp_code'],$currentFinancialYear);
                        
                        if(count($overAllAnnualStatus)==1){
                            
                        $mgtGroup = $this->Common->findGroupDesg($empDetails['MyProfile']['desg_code']);                            
                        $groupWeightageList = $this->Common->findGroupWeightage($mgtGroup);
                             
                        $kraWeightage = $groupWeightageList['GroupWeightage']['kra_weightage'];
                        $compWeightage = $groupWeightageList['GroupWeightage']['comp_weightage'];
                            
                        $kraOverallRating = $overallRatingList[0]['KraCompOverallRating']['kra_overall_rating'];                        
                        $compOverallRating = $overallRatingList[0]['KraCompOverallRating']['comp_overall_rating'];
                        
                        $kraCompetencyOverallRating = ($kraOverallRating*$kraWeightage + $compOverallRating*$compWeightage)/100;
						
						$kraModActual = $overallRatingList[0]['KraCompOverallRating']['moderator_self_overall_achiev'];
						$compModActual = $this->Common->getModCompOverallActual($empDetails['MyProfile']['emp_code'],$currentFinancialYear);
						$range=(($this->Common->truncate_number($kraModActual)*$kraWeightage)/100)+($this->Common->truncate_number(round(($compModActual[0]['comp_sum_mod']/count($list))*100)*$compWeightage/100));
						
						$overallRatings = $this->Common->findOverAllRatingList();
						if($kra_config['MstPmsConfig']['app_type'] == 2){
						for($kra=0;$kra<count($overallRatings);$kra++){
							
							if($range >= $overallRatings[0]['Rating']['rating_scale_from']){
								$kraCompetencyOverallResult = $overallRatings[0]['Rating']['rating_name'];
								$kraCompetencyOverallName = $overallRatings[0]['Rating']['description'];
							}else if($range >= $overallRatings[1]['Rating']['rating_scale_from'] && $range <= $overallRatings[1]['Rating']['rating_scale_to']){
								$kraCompetencyOverallResult = $overallRatings[1]['Rating']['rating_name'];
								$kraCompetencyOverallName = $overallRatings[1]['Rating']['description'];
							}else if($range >= $overallRatings[2]['Rating']['rating_scale_from'] && $range <= $overallRatings[2]['Rating']['rating_scale_to']){
								$kraCompetencyOverallResult = $overallRatings[2]['Rating']['rating_name'];
								$kraCompetencyOverallName = $overallRatings[2]['Rating']['description'];
							}else if($range >= $overallRatings[3]['Rating']['rating_scale_from'] && $range <= $overallRatings[3]['Rating']['rating_scale_to']){
								$kraCompetencyOverallResult = $overallRatings[3]['Rating']['rating_name'];
								$kraCompetencyOverallName = $overallRatings[3]['Rating']['description'];
							}else if($range >= $overallRatings[4]['Rating']['rating_scale_from'] && $range <= $overallRatings[4]['Rating']['rating_scale_to']){
								$kraCompetencyOverallResult = $overallRatings[4]['Rating']['rating_name'];
								$kraCompetencyOverallName = $overallRatings[4]['Rating']['description'];
							}
							break;
						}
						}
						if($kra_config['MstPmsConfig']['app_type'] == 1){
							for($kra=0;$kra<count($overallRatings);$kra++){
							
							if($kraCompetencyOverallRating >= $overallRatings[0]['Rating']['rating_scale_from']){
								$kraCompetencyOverallResult = $overallRatings[0]['Rating']['rating_name'];
							}else if($kraCompetencyOverallRating >= $overallRatings[1]['Rating']['rating_scale_from'] && $kraCompetencyOverallRating <= $overallRatings[1]['Rating']['rating_scale_to']){
								$kraCompetencyOverallResult = $overallRatings[1]['Rating']['rating_name'];
							}else if($kraCompetencyOverallRating >= $overallRatings[2]['Rating']['rating_scale_from'] && $kraCompetencyOverallRating <= $overallRatings[2]['Rating']['rating_scale_to']){
								$kraCompetencyOverallResult = $overallRatings[2]['Rating']['rating_name'];
							}else if($kraCompetencyOverallRating >= $overallRatings[3]['Rating']['rating_scale_from'] && $kraCompetencyOverallRating <= $overallRatings[3]['Rating']['rating_scale_to']){
								$kraCompetencyOverallResult = $overallRatings[3]['Rating']['rating_name'];
							}else if($kraCompetencyOverallRating >= $overallRatings[4]['Rating']['rating_scale_from'] && $kraCompetencyOverallRating <= $overallRatings[4]['Rating']['rating_scale_to']){
								$kraCompetencyOverallResult = $overallRatings[4]['Rating']['rating_name'];
							}
							break;
						}
						}
                        
                        $this->Common->saveKraCompetencyOverallRatingAndResult($empDetails['MyProfile']['emp_code'],$currentFinancialYear,$kraCompetencyOverallRating,$kraCompetencyOverallResult);
                         
                            
                    ?>
                    <h3 class="uk-accordion-title">Overall Rating</h3>
                    <div class="uk-accordion-content">
                        <h3>Section E: Overall Rating</h3>
                        <div class="uk-overflow-container">                        
                            <table border="1" class="uk-table uk-tab-responsive uk-margin-bottom">
                                <tbody>
                                <tr>
                                    <th class="uk-text-center md-bg-teal-50">Sections</th>
									<?php if($kra_config['MstPmsConfig']['app_type'] == 2){ ?>
									<th class="uk-text-center md-bg-teal-50">% Achieved</th>
									<?php } ?>
									<th class="uk-text-center md-bg-teal-50">Rating</th>
                                    <th class="uk-text-center md-bg-teal-50">Weightage</th>
                                </tr>
                                </tbody>
                                <tr>
                                    <td>KRA Rating (a)</td>
									<?php if($kra_config['MstPmsConfig']['app_type'] == 2){ ?>
									<td><?=$kraModActual;?> %</td>
									 <?php } ?>
                                    <td><?php echo $this->Common->truncate_number($kraOverallRating);?></td>
                                    <td><?=$kraWeightage?>%</td>		
                                </tr>
                                <tr>
                                    <td>Competency Rating (b)</td>
									<?php if($kra_config['MstPmsConfig']['app_type'] == 2){ ?>
									<td><?php echo $this->Common->truncate_number(round(($compModActual[0]['comp_sum_mod']/count($list))*100));?> %</td>
									<?php } ?>
                                    <td><?=$this->Common->truncate_number($compOverallRating)?></td>
                                    <td><?=$compWeightage?>%</td>		
                                </tr> 
                                <tr>
                                    <td>KRA & Competency Overall Rating</td>
									<?php if($kra_config['MstPmsConfig']['app_type'] == 2){ ?>
									 <td><?php echo round($range);
									
									 ?> %</td>
									 <?php } ?>
                                    <td><?php echo $this->Common->truncate_number($kraCompetencyOverallRating);?></td>
                                    <td>100%</td>		
                                </tr> 
                                <tr>
                                    <td>Overall Rating</td>
									
                                    <td colspan="3"><b><?=$kraCompetencyOverallResult?> <?php echo ' - '.$kraCompetencyOverallName?></b></td>
                                </tr>                              
                        </table>
                        </div>
                        <div class="uk-overflow-container">
                            <table class="uk-table uk-text-nowrap" border="1">
                                <thead>
                                    <tr class="md-bg-deep-orange-200">
                                    <th>RATING</th>
                                    <th>SCORE</th>
                                    <th>OVERALL DESCRIPTION OF PERFORMANCE</th>
                                </tr>
                                </thead>
                                <tbody class="uk-text-small">
                                    <?php 
                                        $overAllRatingList = $this->Common->getOverAllRatingList();                                            
                                        for ($i = 0; $i < count($overAllRatingList); $i++) {

                                    ?>
                                        <tr>
                                            <td><?php echo $overAllRatingList[$i]['Rating']['rating_name'];?></td>
                                            <td class="uk-text-center"><?php echo $overAllRatingList[$i]['Rating']['rating_scale_from']." - ".$overAllRatingList[$i]['Rating']['rating_scale_to'];?></td>
                                            <td><?php echo wordwrap(ucfirst($overAllRatingList[$i]['Rating']['description']), 120, "<br />\n"); ?></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                        <?php }?>
                    <!--- End Overall Rating -->
                    
                        
                        
                    <?php }else{
                            echo "<div class='md-card-content'>No Records Found....</div>";
                        }?>
            
        </div>        
    </div>
</div>
</div>
</div>    
<div id="modal_overflow" class="uk-modal">
    <div class="uk-modal-dialog uk-modal-dialog-large">
        <button type="button" class="uk-modal-close uk-close"></button>        
        <div class="uk-overflow-container" id="CompetencyBehaviourList"></div>
    </div>
</div>
<table id="slideleft" style=" overflow:auto; position:fixed; top:30%;text-align:l">
				<tbody><tr class="slideLeftItem" style="position:fixed;right: 0px;z-index:1000;height: 43px;width: 121px;border: solid 1px #000;background-color: #bbdefb!important;">
				<td>
				<div style="top:5px;position:absolute;border-left-width:5px;text-align:center"><b>Total Weightage</b><br> <span id="totWeigh">0</span></div>
				</td>

				</tr>
				</tbody>
				</table>
<script type="text/javascript">  
var sum1=0;
		$(".weightage").each(function (i) {
            sum1 = sum1 + parseFloat($(this).text());
			$("#totWeigh").text(sum1.toFixed(1));
        });
<?php if($kra_config['MstPmsConfig']['app_type']==2){ ?>
 function setAchievementHigherBetter(this1) {
        if (parseInt($.trim($(this1).closest("tr").find("input#appraiser_score_actual").val())) != '') {
			if (parseInt($.trim($(this1).closest("tr").find("input#appraiser_score_actual").val())) <= parseInt($.trim($(this1).closest("tr").find(".target").text()))) {
				total = (parseInt($.trim($(this1).closest("tr").find("input#appraiser_score_actual").val()))/parseInt($.trim($(this1).closest("tr").find(".target").text())))*100;
                $(this1).closest("tr").find(".appraiser_score_achiev").val(total.toFixed(1));
            } else if (parseInt($.trim($(this1).closest("tr").find("input#appraiser_score_actual").val())) >= parseInt($.trim($(this1).closest("tr").find(".target").text())) && parseInt($.trim($(this1).closest("tr").find("input#appraiser_score_actual").val())) < parseInt($.trim($(this1).closest("tr").find("input#stretched").val()))) {
              total = (parseInt($.trim($(this1).closest("tr").find("input#appraiser_score_actual").val()))/parseInt($.trim($(this1).closest("tr").find(".target").text())))*100;
                 $(this1).closest("tr").find(".appraiser_score_achiev").val(total);
            } else if (parseInt($.trim($(this1).closest("tr").find("input#appraiser_score_actual").val())) >= parseInt($.trim($(this1).closest("tr").find(".stretched").val()))) {
              total = (parseInt($.trim($(this1).closest("tr").find("input#appraiser_score_actual").val()))/parseInt($.trim($(this1).closest("tr").find(".target").text())))*100;
                  $(this1).closest("tr").find(".appraiser_score_achiev").val(total);
            }
        } else {
            $(this1).closest("tr").find(".appraiser_score_achiev").val("");
        }
		
    }
<?php	} ?>
     function confirmAction() {

        var error1 = [];
						$("input.mid_app_actual_upload").each(function (i) {
							//alert($('[name="data[mid_app_actual_upload_'+(i+1)+']"]').val());return false;
			if($('[name="data[mid_app_actual_upload_'+(i+1)+']"]').val()!=''){
			var file_size = $('[name="data[mid_app_actual_upload_'+(i+1)+']"]')[0].files[0].size;
			var file_name = $('[name="data[mid_app_actual_upload_'+(i+1)+']"]')[0].files[0].name;
			//alert(file_name.search("'"));
			if(file_name.search("'") != -1 ) {
				alert("In row no. "+(i+1)+", file name is invalid. Please remove quotes.");
				error1[i]=2;
				return false;
			}
			
			if(file_size>2048000) {
				alert("In row no. "+(i+1)+", file size is heavy. Please upload less than 2MB.");
				error1[i]=2;
				return false;
			}
			
			var fileExtension = ['jpeg', 'jpg', 'png', 'gif', 'bmp', 'doc','docx','ppt','pptx','xls','xlsx', 'txt', 'pdf', 'xml', 'ods'];
				if ($.inArray($('[name="data[mid_app_actual_upload_'+(i+1)+']"]').val().split('.').pop().toLowerCase(), fileExtension) == -1) {
					alert("In row no. "+(i+1)+", file extension is invalid. Please use only : "+fileExtension.join(', '));
					error1[i]=2;
					return false;
				}
				
			}			
		});
		
if ($.inArray(2, error1) != -1) {
            return false;
        }
//return false;
		
    }


    var counter = 2;
    $('.plusbtn').click(function () {

        $("#TextBoxesGroup").append('<tr>' +
                '<td class="uk-text-center uk-width-small-1-10">' + counter + '</td>' +
                '<td><?php echo $this->Form->input("identified_areas_for_development.", array("class" => "textarea_expand", "label" => "", "type" => "textarea", "required" => True)); ?></td>' +                
                '<td><?php echo $this->Form->input("observed_behavior.", array("class" => "textarea_expand", "label" => "", "type" => "textarea", "required" => True)); ?></td>' +
                '<td><?php echo $this->Form->input("suggested_action_plan.", array("class" => "textarea_expand", "label" => "", "type" => "textarea", "required" => True)); ?></td>' +
                '<td><?php echo $this->Form->input("timelines.", array("class" => "textarea_expand", "label" => "", "type" => "textarea", "required" => True)); ?></td>' +                
                '<td><?php echo $this->Form->input("responsibility.", array("class" => "textarea_expand", "label" => "", "type" => "textarea", "required" => True)); ?></td>' +                
                '</tr>');
        counter++;
    });

    $('.minusbtn').click(function () {
        if ($("#TextBoxesGroup tr").length != 2) {
            $("#TextBoxesGroup tr:last-child").remove();
            counter--;
        }
        else {
            alert("You cannot delete first row");
        }
    });
    
    $(document).on('change', '#appraiser_score_achiev1', function () {
        if (Number($(this).val()) < 0) {
            $(this).val('');
            alert('Number must be greater than 0 or equal to 0');
        }
        if (Number($(this).val()) > 100) {
            $(this).val('');
            alert('Number must be less than 100 or equal to 100');
        }
        ;
    });
    
    function isNumberKey(evt, obj) {
 
            var charCode = (evt.which) ? evt.which : event.keyCode
            var value = obj.value;
            var dotcontains = value.indexOf(".") != -1;
            if (dotcontains)
                if (charCode == 46) return false;
            if (charCode == 46) return true;
            if (charCode > 31 && (charCode < 48 || charCode > 57))
                return false;
            return true;
        }  

    function getCompetencyRatingList() {
        $.ajax({
            type: "POST",
            url: '<?php echo $this->webroot;?>Competency/CompetencyRatingList/',
            //data:'project_id='+val,
            success: function (data) {
                //alert(data);
                $("#competencyRatingList").html(data);
            }
        });
    }
    
    function getCompetencyBehaviouList() {
        ids = jQuery('#newid').val();
        //alert(ids);
        $.ajax({
            type: "POST",
            url: '<?php echo $this->webroot;?>Competency/CompetencyBehaviourList/',
            data:'id='+ids,
            success: function (data) {
                //alert(data);
                $("#CompetencyBehaviourList").html(data);
            }
        });
    }
   
    $(document).ready(function() {
        $('.final_status').click(function(i){
                var disable = $(this).attr('data-text');
				
                if ($(this).is(':checked')){
                    $("#appraiser_status_comment"+disable).removeAttr("required",  $(this).is(':checked')); 
					$("#final_status_app"+disable).val("1");
                }else{
					$("#appraiser_status_comment"+disable).attr("required","true");
					$("#final_status_app"+disable).val("0");
				}
				//alert($("#final_status_app"+disable).val());
        });
    });
    
    function isVisible(id) {
                var element = $('#' + id).parent();
				//alert(element.css('overflow'));
                if (element.css('overflow') !== 'hidden') {
                    return true;
                } else {
                    return false;
                }
            }
</script>


<script>
  $(document).ready(function(){
	
  $('form textarea[minlength]').on('keyup', function(){
    e_len = $(this).val().trim().length
    e_min_len = Number($(this).attr('minlength'))
    message = e_min_len <= e_len ? '' : e_min_len + ' characters minimum'
    this.setCustomValidity(message)
  })
});
$(document).ready(function($){
	$('#saveasdraft').click(function (){
		var error1 = [];
			$('#form_validation input[type=text],#form_validation textarea, #form_validation select').each(function() {
						$(this).removeAttr('required');
			});
				var total_file_size = 0;
		<?php if($page_type=="allmidapp"){ ?>
		$("input.mid_app_actual_upload").each(function (i) {
			if($('[name="data[mid_app_actual_upload_'+(i+1)+']"]').val()!=''){
			var file_size = $('[name="data[mid_app_actual_upload_'+(i+1)+']"]')[0].files[0].size;
			var file_name = $('[name="data[mid_app_actual_upload_'+(i+1)+']"]')[0].files[0].name;
			//alert(file_name.search("'"));
			if(file_name.search("'") != -1 ) {
				alert("In row no. "+(i+1)+", file name is invalid. Please remove quotes.");
				error1[i]=2;
				return false;
			}
			
			total_file_size = (total_file_size + $('[name="data[mid_app_actual_upload_'+(i+1)+']"]')[0].files[0].size);
			if(file_size>2048000) {
				alert("In row no. "+(i+1)+", file size is heavy. Please upload less than 2MB.");
				error1[i]=2;
				return false;
			}
			
			var fileExtension = ['jpeg', 'jpg', 'png', 'gif', 'bmp', 'doc','docx','ppt','pptx','xls','xlsx', 'txt', 'pdf', 'xml', 'ods'];
				if ($.inArray($('[name="data[mid_app_actual_upload_'+(i+1)+']"]').val().split('.').pop().toLowerCase(), fileExtension) == -1) {
					alert("In row no. "+(i+1)+", file extension is invalid. Please use only : "+fileExtension.join(', '));
					error1[i]=2;
					return false;
				}
				
			}			
		});
		<?php } ?>
	/* 	
		<?php if($page_type=="allannemp"){ ?>
		$("input.mid_app_actual_upload").each(function (i) {
			if($('[name="data[mid_app_actual_upload_'+(i+1)+']"]').val()!=''){
			var file_size = $('[name="data[mid_app_actual_upload_'+(i+1)+']"]')[0].files[0].size;
			var file_name = $('[name="data[mid_app_actual_upload_'+(i+1)+']"]')[0].files[0].name;
			//alert(file_name.search("'"));
			if(file_name.search("'") != -1 ) {
				alert("In row no. "+(i+1)+", file name is invalid. Please remove quotes.");
				error1[i]=2;
				return false;
			}
			
			total_file_size = (total_file_size + $('[name="data[mid_app_actual_upload_'+(i+1)+']"]')[0].files[0].size);
			if(file_size>2048000) {
				alert("In row no. "+(i+1)+", file size is heavy. Please upload less than 2MB.");
				error1[i]=2;
				return false;
			}
			
			var fileExtension = ['jpeg', 'jpg', 'png', 'gif', 'bmp', 'doc','docx','ppt','pptx','xls','xlsx', 'txt', 'pdf', 'xml', 'ods'];
				if ($.inArray($('[name="data[mid_app_actual_upload_'+(i+1)+']"]').val().split('.').pop().toLowerCase(), fileExtension) == -1) {
					alert("In row no. "+(i+1)+", file extension is invalid. Please use only : "+fileExtension.join(', '));
					error1[i]=2;
					return false;
				}
				
			}			
		});
		<?php } ?>
		 */
		
if ($.inArray(2, error1) != -1) {
            return false;
        }
	
		$('<input />').attr('type', 'hidden')
              .attr('name', 'saveasdraft')
              .attr('value', 'saveasdraft')
              .appendTo('#form_validation');
		
		$('<input />').attr('type', 'hidden')
              .attr('name', 'saveasdraftcomp')
              .attr('value', 'saveasdraftcomp')
              .appendTo('.addCompetencyRating');
			  
		<?php   if($page_type=="allapp"){
				?>
		$('<input />').attr('type', 'hidden')
		  .attr('name', 'submit')
		  .attr('value', 'Submit')
		  .appendTo('#form_validation');
		  
		  $('#ww').trigger('click');
				<?php
						}elseif($page_type=="allmidapp"){
						?>
		$('<input />').attr('type', 'hidden')
		  .attr('name', 'addMidAppSelfScore')
		  .attr('value', 'Submit')
		  .appendTo('#form_validation');
		  
		  
		$('#form_validation').attr("action", "<?php echo $this->webroot;?>KraMasters/updateKraTarget");
		$('#form_validation').submit();
		
				<?php
						}elseif($page_type=="allannapp"){
						?>
		$('<input />').attr('type', 'hidden')
		  .attr('name', 'addSelfScore')
		  .attr('value', 'Submit')
		  .appendTo('#form_validation');
		  
		$('#form_validation').attr("action", "<?php echo $this->webroot;?>KraMasters/updateKraTarget");
		$('#form_validation').submit();
		
				<?php
						}
		?>
		
		});
		
$('#saveasdraftcomp').click(function (){
		var error1 = [];
			$('#form_validation input[type=text],#form_validation textarea, #form_validation select').each(function() {
						$(this).removeAttr('required');
			});
				
		$('<input />').attr('type', 'hidden')
              .attr('name', 'saveasdraftcomp')
              .attr('value', 'saveasdraftcomp')
              .appendTo('.addCompetencyRating');
			  
		<?php  if($page_type=="allmidapp"){
						?>
		
		$('<input />').attr('type', 'hidden')
		  .attr('name', 'submitAppraiserMidRating')
		  .attr('value', 'Submit')
		  .appendTo('.addCompetencyRating');
		  
		  
		$('.addCompetencyRating').attr("action", "<?php echo $this->webroot;?>KraMasters/addCompetencyRating");
		$('.addCompetencyRating').submit();
		
				<?php
						}elseif($page_type=="allannapp"){
						?>
		$('<input />').attr('type', 'hidden')
		  .attr('name', 'submitAppraiserRating')
		  .attr('value', 'Submit')
		  .appendTo('.addCompetencyRating');
		  
		$('.addCompetencyRating').attr("action", "<?php echo $this->webroot;?>KraMasters/addCompetencyRating");
		$('.addCompetencyRating').submit();
		
				<?php
						}
		?>
		
		});

		$('#saveasdraftplan').click(function (){
			
			$('#form_validation input[type=textarea]').each(function() {
						$(this).removeAttr('required');
						$(this).removeAttr('minlength');
			});
		
		$('<input />').attr('type', 'hidden')
              .attr('name', 'saveasdraftplan')
              .attr('value', 'saveasdraftplan')
              .appendTo('.addDevelopmentPlan');
			  
		$('<input />').attr('type', 'hidden')
		  .attr('name', 'submitAppraiserPlan')
		  .attr('value', 'Submit')
		  .appendTo('.addDevelopmentPlan');
		 
		$('.addDevelopmentPlan').attr("action", "<?php echo $this->webroot;?>KraMasters/addDevelopmentPlan");
		
		$('.addDevelopmentPlan').submit();
		
		});
		
	if($("#flashMessage").length > 0 ){
		<?php if(($kra_config['MstPmsConfig']['mid_review'] == 1) && ($page_type!="allapp")){ ?>
		$.ajax({
			type: "POST",
			url: '<?php echo $this->webroot;?>KraMasters/checkstatus/',
			data: {empCode: <?php echo $empCode; ?>, level: 2},
			success: function (data) {
				var array = $.parseJSON(data);
				if(array['mid_kra_Status']==0){
						alert('Please review mid year KRAs completely.');
				}else if(array['mid_comp_Status']==0){
						alert('Please review mid year competencies too.');
				}
			}
		});
		<?php } ?>
	}

	
	
});

function viewFiles(adp_id,user_id){ 
        jQuery.ajax({
            url: '<?php echo $this->webroot ?>KraMasters/adp_remark_by_app/'+adp_id+'/'+user_id,
            success: function(data){
             jQuery('#vidResponse').html(data);
            }
        });
    }
  </script>
