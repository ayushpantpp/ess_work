<?php
$auth = $this->Session->read('Auth');
//echo "<pre>";
//print_r($auth['MyProfile']);
//die;
?>
<div id="page_content" role="main">
    <div id="page_content_inner">        
   
<?php echo $flash = $this->Session->flash(); ?>
        <div class="md-card">
            <div class="md-card-content">     <h3>
                                Annual Appraisal Details
                            </h3>                     
                <div class="uk-overflow-container uk-margin-bottom">
                   <?php
				   
                            if (isset($kraTargetList) && count($kraTargetList)>0) {
                            ?> <table class="uk-table uk-table-align-vertical uk-table-nowrap tablesorter tablesorter-altair" id="dt_colVis">
                        <thead>
                            <tr>
                                <th>Sr.No.</th>
                                <th>Employee Name</th>
                                <th>Financial Year</th>
                                <th>Created Date</th>
                                <th>Appraiser Name</th>
                                <th>Status</th>                                        
                                <th class="filter-false remove sorter-false">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php    $p = 1;
                                for ($i = 0; $i < count($kraTargetList); $i++) {

                                    $ctr = (($this->params['paging']['KraTarget']['page'] * $this->params['paging']['KraTarget']['limit']) - $this->params['paging']['KraTarget']['limit']) + $p;
									
                                    $annReviewsDetails = $this->Common->findAnnReviewsDetailsEmp($kraTargetList[$i]['KraTarget']['emp_code'],$kraTargetList[$i]['KraTarget']['financial_year']);
									
									$annADPDetails = $this->Common->getCompEmpSelfScore($kraTargetList[$i]['KraTarget']['emp_code'],$kraTargetList[$i]['KraTarget']['financial_year']);
									$button = 0;
									if($annReviewsDetails==1){
										$status = "Open";
										$btnClass = "uk-badge uk-badge-primary";
										if($annADPDetails==0){
											$status = "Open";
											$btnClass = "uk-badge uk-badge-primary";
										}
									}else if($annADPDetails==0){
										$status = "Open";
										$btnClass = "uk-badge uk-badge-primary";
									}else if($annADPDetails==1){
										$button = 1;
										$status = "Sent for review";
										$btnClass = "uk-badge uk-badge-success";
									}else{
										$button = 1;
										$status = "Sent for review";
										$btnClass = "uk-badge uk-badge-success";
									}
																	$overAllAnnualStatus = $this->Common->overAllAnnualStatus($kraTargetList[$i]['KraTarget']['emp_code'],$kraTargetList[$i]['KraTarget']['financial_year']);
								if(count($overAllAnnualStatus)==1){
									$status = "Completed";
									$btnClass = "uk-badge uk-badge-success";
									  $disableCheckBox = 'disabled="disabled" ';
								}

                                    ?>
                                    
                                    <tr class="<?= $rowClass; ?>">               
                                        <td class="uk-text-center uk-width-small-1-10"><?= $ctr; ?></td>                            
                                        <td class="uk-text-small"><?php echo $this->Common->findEmpName($kraTargetList[$i]['KraTarget']['emp_code']); ?></td>
                                        <td class="uk-text-small"><?php echo $this->Common->findfyDesc($kraTargetList[$i]['KraTarget']['financial_year']); ?></td>
                                        <td><?php echo date("d-m-Y", strtotime($kraTargetList[$i]['KraTarget']['created_date'])); ?></td>                        
                                        <td><?php echo $this->Common->findEmpName($kraTargetList[$i]['KraTarget']['appraiser_id']); ?></td>
                                        <td><span class="<?php echo $btnClass; ?>"><?php echo $status; ?></span></td>
                                        <td>  
											 <?php

											if($button==1){
											?>
												 <a href="viewKraTarget/<?php echo base64_encode($kraTargetList[$i]['KraTarget']['financial_year']);?>/<?php echo base64_encode('allannemp');?>" alt="View Score" title="View Score" class="uk-badge uk-badge-primary">View Score</a>
											<?php
											}else{
												?>
												<a href="viewKraTarget/<?php echo base64_encode($kraTargetList[$i]['KraTarget']['financial_year']);?>/<?php echo base64_encode('allannemp');?>" alt="Assign Score" title="Assign Score" class="uk-badge uk-badge-warning">Assign Score</a>
												
												<?php
											}
											?>									
                                           
											
                                        </td>                          
                                    </tr> 

                                    <?php $p++;
                                }
                            ?>

                        </tbody>
                    </table>
	<?php	}else{
								
								echo '<div class="uk-overflow-container">
                        <h3 class="uk-text-primary">HR has not initiated your annual appraisal process.</h3>
                    </div>';
							} ?>

                </div>
            </div>
        </div>        
    </div>
</div>