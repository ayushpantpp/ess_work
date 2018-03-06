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
         
            <div class="md-card-content">         <h3>
                               View KRAs
                            </h3>                
                <div class="uk-overflow-container uk-margin-bottom">
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
                                    
                                   
					$totalApproved = $this->Common->getOpenKraStatusLevel($kraTargetList[$i]['KraTarget']['emp_code'],$kraTargetList[$i]['KraTarget']['financial_year'],'emp');
									if($totalApproved == 1){
										$status = "Open";
                                       $btnClass = "uk-badge uk-badge-primary";
									}else{
										$status = "Sent for approval";
										$btnClass = "uk-badge uk-badge-warning";
									}
					
					$AllApproved = $this->Common->getOpenFinalKraStatusLevel($kraTargetList[$i]['KraTarget']['emp_code'],$kraTargetList[$i]['KraTarget']['financial_year'],'emp');
									if($AllApproved == 1){
										$status = "KRA Approved";
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
                                            <a href="viewKraTarget/<?php echo base64_encode($kraTargetList[$i]['KraTarget']['financial_year']);?>/<?php echo base64_encode('allemp');?>" alt="View Details" title="View Details" class="uk-badge uk-badge-success">View Details</a>
										</td>                          
                                    </tr> 

                                    <?php $p++;
                                }
                            } ?>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>        
    </div>
</div>