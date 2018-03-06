<?php
$auth = $this->Session->read('Auth');
//echo "<pre>";print_r($kraTargetList);die;
?>
<div id="page_content" role="main">
    <div id="page_content_inner">        
       
        <?php echo $flash = $this->Session->flash(); ?>
        <div class="md-card">
            <div class="md-card-content">           <h3>View All KRAs</h3>              
                <div class="uk-overflow-container uk-margin-bottom">
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
                            <?php
							
                            if (isset($kraTargetList)) {
                                $p = 1;
                                for ($i = 0; $i < count($kraTargetList); $i++) {
									if($this->Common->isUserActive($kraTargetList[$i]['KraTarget']['emp_code'])){
                                    $ctr = (($this->params['paging']['KraTarget']['page'] * $this->params['paging']['KraTarget']['limit']) - $this->params['paging']['KraTarget']['limit']) + $p;
                                    
                    $totalApproved = $this->Common->getOpenKraStatusLevel($kraTargetList[$i]['KraTarget']['emp_code'],$kraTargetList[$i]['KraTarget']['financial_year'],'rev');
									if($totalApproved == 1){
										$status = "Open";
                                       $btnClass = "uk-badge uk-badge-primary";
									}else{
										$status = "Rejected";
										$btnClass = "uk-badge uk-badge-danger";
									}
					
					$AllApproved = $this->Common->getOpenFinalKraStatusLevel($kraTargetList[$i]['KraTarget']['emp_code'],$kraTargetList[$i]['KraTarget']['financial_year'],'rev');
									if($AllApproved == 1){
										$status = "KRA Approved";
										$btnClass = "uk-badge uk-badge-success";
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
                                        //$reviewerTotalRecords =  $this->Common->getKraTargetByEmpCodeForReviewer($kraTargetList[$i]['KraTarget']['emp_code'],$kraTargetList[$i]['KraTarget']['financial_year']);
                                        //$totalKraRecords = $this->Common->getTotalKraTarge($kraTargetList[$i]['KraTarget']['emp_code'],$kraTargetList[$i]['KraTarget']['financial_year']);
										//if($w==0){
											
											//if(($totalRevertByReviewer < $totalApproved && $totalApproved == $totalKraRecords) || ($totalRevert1 == 1 && $totalKraRecords==1 ) || (($totalRevertByReviewer == $totalApproved) && ($totalApproved == $totalKraRecords))){
										?>
                                                <a href="<?php echo $this->webroot; ?>KraMasters/viewReviewerKraTarget/<?php echo $kraTargetList[$i]['KraTarget']['emp_code']."/".base64_encode($kraTargetList[$i]['KraTarget']['financial_year']); ?>/<?php echo base64_encode('allrev');?>" alt="View Full Details" title="View Full Details" class="uk-badge uk-badge-success">View Details</a>
                                            <?php //}		
									//	}									
										?>	
                                        </td>                          
                                    </tr> 

                                    <?php $p++;
								}
                                }
                            } ?>

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
            </div>
        </div>        
    </div>
</div>