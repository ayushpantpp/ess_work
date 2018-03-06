<?php

$kra_config = $this->Session->read('sess_kra_config');
$auth = $this->Session->read('Auth');
//echo "<pre>";
//print_r($auth['MyProfile']);
//die;
?>
<div id="page_content" role="main">
    <div id="page_content_inner">        
        
        <?php echo $flash = $this->Session->flash(); ?>
        <div class="md-card">
            <div class="md-card-content">    
			<h3>Moderator Screen: View All Annual KRAs</h3>			
             	<?php
                            if (isset($kraTargetList) && count($kraTargetList)>0) {
                            ?>
               <div class="uk-overflow-container uk-margin-bottom">
			        <?php echo $this->Form->create('updateAllDetailsByModerator', array('url' => array('controller' => 'KraMasters', 'action' => 'updateAllDetailsByModerator'), 'id' => 'form_validation', 'class' => 'uk-form-stacked')); ?>
                    <table class="uk-table uk-table-align-vertical uk-table-nowrap tablesorter tablesorter-altair" id="dt_colVis">
                        <thead>
                            <tr>
                                <th class="filter-false remove sorter-false"><input type="checkbox" class="ts_checkbox_all"></th>
                                <th>Sr.No.</th>
                                <th>Employee Name</th>
                                <th>Created Date</th>
                                <th>Appraiser Name</th>
								<th>Appraiser KRA Rating</th>
								<th>Appraiser Competency Rating</th>
                                <th>Reviewer Name</th>
								<th>Reviewer KRA Rating</th>
								<th>Reviewer Competency Rating</th>
                                <th>Moderator Name</th>
                                <th>Status</th>                                        
                                <th class="filter-false remove sorter-false">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php    $p = 1;
                                foreach ($kraTargetList as $key => $val) {
                                
									 if($this->Common->isUserActive($kraTargetList[$key]['KraTarget']['emp_code'])){
                                    $ctr = (($this->params['paging']['KraTarget']['page'] * $this->params['paging']['KraTarget']['limit']) - $this->params['paging']['KraTarget']['limit']) + $p;
                                               
									$annReviewsDetails = $this->Common->findAnnReviewsDetailsMod($kraTargetList[$key]['KraTarget']['emp_code'],$kraTargetList[$key]['KraTarget']['financial_year']);
									
                                    $annCompRecords = $this->Common->findCountCompetencyMod($kraTargetList[$key]['KraTarget']['emp_code'],$kraTargetList[$key]['KraTarget']['financial_year']);
									
									if($kra_config['MstPmsConfig']['app_type'] == 2){
										$annADPRecords = $this->Common->getADPTargetDetailsMod($kraTargetList[$key]['KraTarget']['emp_code'],$kraTargetList[$key]['KraTarget']['financial_year']);
										$annADPRecordsRev = $this->Common->getADPTargetDetailsModReverted($kraTargetList[$key]['KraTarget']['emp_code'],$kraTargetList[$key]['KraTarget']['financial_year']);
									}
									
									if($annReviewsDetails==1 || $annCompRecords==0 || count($annADPRecords)==1){
										$status = "Open";
										$btnClass = "uk-badge uk-badge-primary";
										$disableCheckBox = '';
									}else{
										$status = "Reverted Development Plan";
										$btnClass = "uk-badge uk-badge-danger";
										$disableCheckBox = 'disabled="disabled" ';
									}
									if($kra_config['MstPmsConfig']['app_type'] == 2){
									if(count($annADPRecordsRev)>=1){
										$status = "Reverted Development Plan";
										$btnClass = "uk-badge uk-badge-danger";
										$disableCheckBox = 'disabled="disabled" ';
									}
									}
									
								$overAllAnnualStatus = $this->Common->overAllAnnualStatus($kraTargetList[$key]['KraTarget']['emp_code'],$kraTargetList[$key]['KraTarget']['financial_year']);
								if(count($overAllAnnualStatus)==1){
									$status = "Completed";
									$btnClass = "uk-badge uk-badge-success";
									  $disableCheckBox = 'disabled="disabled" ';
								}

								$kraoverallratings = $this->Common->getKraoverallratings($kraTargetList[$key]['KraTarget']['emp_code'], $kraTargetList[$key]['KraTarget']['financial_year']);
		//echo '<pre>';print_r($kraoverallratings);die;
                                    ?>
                                    <tr>
                                        <td>
                                            <?php echo $this->Form->input('id.' . $key, array('type' => 'checkbox', "data-text" => "$key", 'label' => false, 'class' => "$readOnlyCheckBox", "data-md-icheck", "data-uk-tooltip" => "{cls:'long-text'}","$disableCheckBox"));?>                                           
                                            <input type="hidden" name="data[empCode][<?= $key ?>]" value="<?=$kraTargetList[$key]['KraTarget']['emp_code']?>">
                                            <input type="hidden" name="data[financialYear][<?= $key ?>]" value="<?=$kraTargetList[$key]['KraTarget']['financial_year']?>">
                                        </td>
                                        <td class="uk-text-center uk-width-small-1-10"><?= $ctr; ?></td>                            
                                        <td class="uk-text-small"><?php echo $this->Common->findEmpName($kraTargetList[$key]['KraTarget']['emp_code']); ?></td>
                                        <td><?php echo date("d-m-Y", strtotime($kraTargetList[$key]['KraTarget']['created_date'])); ?></td>                        
                                        <td><?php echo $this->Common->findEmpName($kraTargetList[$key]['KraTarget']['appraiser_id']); ?></td>
										<td><?php echo $kraoverallratings[0]['KraCompOverallRating']['appraiser_self_overall_rating']; ?></td>
										<td><?php echo $kraoverallratings[0]['KraCompOverallRating']['appraiser_comp_overall_rating']; ?></td>
                                        <td><?php echo $this->Common->findEmpName($kraTargetList[$key]['KraTarget']['reviewer_id']); ?></td>
										<td><?php echo $kraoverallratings[0]['KraCompOverallRating']['reviewer_self_overall_rating']; ?></td>
										<td><?php echo $kraoverallratings[0]['KraCompOverallRating']['reviewer_comp_overall_rating']; ?></td>
                                        <td><?php echo $this->Common->findEmpName($kraTargetList[$key]['KraTarget']['moderator_id']); ?></td>
                                        <td><span class="<?php echo $btnClass; ?>"><?php echo $status; ?></span></td>
										<td>    
											<?php 
											if($annReviewsDetails==1 || count($annCompRecords)>=1){
												?>
												<a href="<?php echo $this->webroot; ?>KraMasters/viewModeratorKraTarget/<?php echo $kraTargetList[$key]['KraTarget']['emp_code']."/".base64_encode($kraTargetList[$key]['KraTarget']['financial_year']); ?>/<?php echo base64_encode('allannmod'); ?>" alt="Assign Score" title="Assign Score" class="uk-badge uk-badge-warning">Assign Score</a>
												<input type="hidden" name ="data[review_type][<?= $key ?>]" value ='ar'>
												<?php
											}else{
												?>
												<a href="<?php echo $this->webroot; ?>KraMasters/viewModeratorKraTarget/<?php echo $kraTargetList[$key]['KraTarget']['emp_code']."/".base64_encode($kraTargetList[$key]['KraTarget']['financial_year']); ?>/<?php echo base64_encode('allannmod'); ?>" alt="View Score" title="View Score" class="uk-badge uk-badge-warning">View Score</a>
												<input type="hidden" name ="data[review_type][<?= $key ?>]" value ='ar'>
												<?php
											}
									?>
										 </td>  
																			
                                    </tr> 

                                    <?php $p++;
								}
                                }
                            ?>

                        </tbody>
                    </table>
			    </div>
                <div class="clearfix"></div>
                    <div class="uk-grid" data-uk-grid-margin>
                        <div class="uk-width-medium-1-2">
                            <button type="submit" name="submit" class="md-btn md-btn-success" href="#">Update All</button>
                            <button type="reset" name="reset" class="md-btn md-btn-primary">Reset</button>                                
                        </div>
                        <div class="uk-width-medium-1-2">
                            <ul class="uk-pagination uk-pagination-right">
                                <?php
                                  echo $this->Paginator->prev('Previous', array('tag' => 'li', 'escape' => false), '<a>Previous</a>', array('class' => 'uk-disabled', 'tag' => 'li', 'escape' => false));
                                  echo $this->Paginator->numbers(array('separator' => '', 'tag' => 'li', 'currentLink' => true, 'currentClass' => 'uk-active', 'currentTag' => 'a'));
                                  echo $this->Paginator->next('Next', array('tag' => 'li', 'escape' => false), '<a>Next</a>', array('class' => 'uk-disabled', 'tag' => 'li', 'escape' => false));
                                ?>
                            </ul>
                        </div>
                    </div>
                    <?php echo $this->Form->end();?>
						<?php	}else{
					echo '<div class="md-card-content">
                    <div class="uk-overflow-container">
                        <h3 class="uk-text-primary">No records found.</h3>
                    </div>
                </div>';
					
				} ?>
            
            </div>
        </div>        
    </div><style>
[type=checkbox]:after {
    content: attr(value);
    margin: -3px 15px;
    vertical-align: top;
    white-space:nowrap;
    display: inline-block;
}
</style>
</div>
