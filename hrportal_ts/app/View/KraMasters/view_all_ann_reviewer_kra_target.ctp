<?php
$auth = $this->Session->read('Auth');
//echo "<pre>";print_r($kraTargetList);die;
?>
<div id="page_content" role="main">
    <div id="page_content_inner">        
       
        <?php echo $flash = $this->Session->flash(); ?>
        <div class="md-card">
            <div class="md-card-content">     <h3>View All Annual KRAs</h3>                    
             <?php
							
                            if (isset($kraTargetList) && count($kraTargetList)>0) {
                            ?>   <div class="uk-overflow-container uk-margin-bottom">
                    <table class="uk-table uk-table-align-vertical uk-table-nowrap tablesorter tablesorter-altair" id="dt_colVis">
                        <thead>
                            <tr>
                                <th>Sr.No.</th>
                                <th>Employee Name</th>
                                <th>Created Date</th>
                                <th>Appraiser Name</th>
                                <th>Reviewer Name</th>
                                <th>Status</th>                                        
                                <th class="filter-false remove sorter-false">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php    $p = 1;
                                for ($i = 0; $i < count($kraTargetList); $i++) {
								if($this->Common->isUserActive($kraTargetList[$i]['KraTarget']['emp_code'])){
                                    $ctr = (($this->params['paging']['KraTarget']['page'] * $this->params['paging']['KraTarget']['limit']) - $this->params['paging']['KraTarget']['limit']) + $p;
                                    
                                    $annReviewsDetails = $this->Common->findAnnReviewsDetailsRev($kraTargetList[$i]['KraTarget']['emp_code'],$kraTargetList[$i]['KraTarget']['financial_year']);
									
                                    $annCompRecords = $this->Common->getCompetencyTargetDetailsRev($kraTargetList[$i]['KraTarget']['emp_code'],$kraTargetList[$i]['KraTarget']['financial_year']);
									
									if($annReviewsDetails==1 || count($annCompRecords)==0){
										$status = "Open";
										$btnClass = "uk-badge uk-badge-primary";
										  $disableCheckBox = '';
									}else{
										$status = "Sent for review";
										$btnClass = "uk-badge uk-badge-primary";
										  $disableCheckBox = 'disabled="disabled" ';
									}
								$overAllAnnualStatus = $this->Common->overAllAnnualStatus($kraTargetList[$i]['KraTarget']['emp_code'],$kraTargetList[$i]['KraTarget']['financial_year']);
								if(count($overAllAnnualStatus)==1){
									$status = "Completed";
									$btnClass = "uk-badge uk-badge-success";
									  $disableCheckBox = 'disabled="disabled" ';
								}
									
                                    ?>
                                    <tr>               
                                        <td class="uk-text-center uk-width-small-1-10"><?= $ctr; ?></td>                            
                                        <td class="uk-text-small"><?php echo $this->Common->findEmpName($kraTargetList[$i]['KraTarget']['emp_code']); ?></td>
                                        <td><?php echo date("d-m-Y", strtotime($kraTargetList[$i]['KraTarget']['created_date'])); ?></td>                        
                                        <td><?php echo $this->Common->findEmpName($kraTargetList[$i]['KraTarget']['appraiser_id']); ?></td>
                                        <td><?php echo $this->Common->findEmpName($kraTargetList[$i]['KraTarget']['reviewer_id']); ?></td>
                                        <td><span class="<?php echo $btnClass; ?>"><?=$status?></span></td>
                                            
                                        
                                        <td>
                                          <?php 
											if($annReviewsDetails==1 || count($annCompRecords)>=1){
												?>
                                                <a href="<?php echo $this->webroot; ?>KraMasters/viewReviewerKraTarget/<?php echo $kraTargetList[$i]['KraTarget']['emp_code']."/".base64_encode($kraTargetList[$i]['KraTarget']['financial_year']); ?>/<?php echo base64_encode('allannrev');?>" alt="Assign Score" title="Assign Score" class="uk-badge uk-badge-warning">Assign Score</a>
												<?php
											}else{
												?>
												 <a href="<?php echo $this->webroot; ?>KraMasters/viewReviewerKraTarget/<?php echo $kraTargetList[$i]['KraTarget']['emp_code']."/".base64_encode($kraTargetList[$i]['KraTarget']['financial_year']); ?>/<?php echo base64_encode('allannrev');?>" alt="View Score" title="View Score" class="uk-badge uk-badge-warning">View Score</a>
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
						<?php	}else{
					echo '<div class="md-card-content">
                    <div class="uk-overflow-container">
                        <h3 class="uk-text-primary">No records found.</h3>
                    </div>
                </div>';
					
				} ?>
            </div>
        </div>        
    </div>
</div>