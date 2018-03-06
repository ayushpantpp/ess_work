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
                                       Mid Review Details
                            </h3>                     
                <div class="uk-overflow-container uk-margin-bottom">
<?php
$data = $this->Common->findFInancialYearDesc($auth['MyProfile']['comp_code']);
$currentFinancialYear = $data['FinancialYear']['id'];

$midReviewsTab = $this->Common->findMidReviewsList($auth['MyProfile']['emp_code'],$currentFinancialYear);
if($midReviewsTab==0){
	echo '<div class="uk-overflow-container">
                        <h3 class="uk-text-primary">HR has not initiated your mid review process.</h3>
                    </div>';
}else if($midReviewsTab==1){
	?>
                    <table class="uk-table uk-table-align-vertical uk-table-nowrap tablesorter tablesorter-altair" id="dt_colVis">
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
                            <?php
                            if (isset($kraTargetList)) {
                                $p = 1;
                                for ($i = 0; $i < count($kraTargetList); $i++) {

                                    $ctr = (($this->params['paging']['KraTarget']['page'] * $this->params['paging']['KraTarget']['limit']) - $this->params['paging']['KraTarget']['limit']) + $p;
                                    
                                    $totalOpen = count($this->Common->getKraTargetOpenStatusForEmp($kraTargetList[$i]['KraTarget']['emp_code'],$kraTargetList[$i]['KraTarget']['financial_year']));
                                    $totalRevert = count($this->Common->getKraTargetRevertStatusforEmpByAppraiser($kraTargetList[$i]['KraTarget']['emp_code'],$kraTargetList[$i]['KraTarget']['financial_year']));
                                    
									$totalRevertRev = count($this->Common->getKraTargetRevertStatusforEmpByReviewer($kraTargetList[$i]['KraTarget']['emp_code'],$kraTargetList[$i]['KraTarget']['financial_year']));
                                    
									$totalApproved = count($this->Common->getKraTargetApprovedStatusForEmp($kraTargetList[$i]['KraTarget']['emp_code'],$kraTargetList[$i]['KraTarget']['financial_year']));
                                    $totalKras = $this->common->getTotalKraTarge($kraTargetList[$i]['KraTarget']['emp_code'],$kraTargetList[$i]['KraTarget']['financial_year']);
                                    
                                    
									$midReviewsDetails = $this->Common->findMidReviewsListEmp($kraTargetList[$i]['KraTarget']['emp_code'],$kraTargetList[$i]['KraTarget']['financial_year']);
									
									if($midReviewsDetails==1){
										$status = "Open";
                                       $btnClass = "uk-badge uk-badge-primary";
									}else{
										$status = "Sent for review";
                                       $btnClass = "uk-badge uk-badge-primary";
									}
									$midReviewsAllStatus = $this->Common->midReviewsAllStatus($kraTargetList[$i]['KraTarget']['emp_code'],$kraTargetList[$i]['KraTarget']['financial_year']);
									if($midReviewsAllStatus==1){
										$status = "Completed";
                                       $btnClass = "uk-badge uk-badge-success";
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
											    <a href="viewKraTarget/<?php echo base64_encode($kraTargetList[$i]['KraTarget']['financial_year']);?>/<?php echo base64_encode('allmidemp');?>" alt="Assign Mid Review" title="Assign Mid Review" class="uk-badge uk-badge-warning">Mid Review</a>
                                            
                                        </td>                          
                                    </tr> 

                                    <?php $p++;
                                }
                            } ?>

                        </tbody>
                    </table>
		<?php
}
?>
                </div>
            </div>
        </div>        
    </div>
</div>