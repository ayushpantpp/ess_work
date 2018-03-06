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
            <div class="md-card-content">      <h3>Moderator Screen: View All Mid Review KRAs</h3>                    
                  <?php

                            if (isset($kraTargetList) && count($kraTargetList)>0) {
                        ?>  <div class="uk-overflow-container uk-margin-bottom">
                    <?php echo $this->Form->create('updateAllDetailsByModerator', array('url' => array('controller' => 'KraMasters', 'action' => 'updateAllDetailsByModerator'), 'id' => 'form_validation', 'class' => 'uk-form-stacked')); ?>
                    <table class="uk-table uk-table-align-vertical uk-table-nowrap tablesorter tablesorter-altair" id="dt_colVis">
                        <thead>
                            <tr>
                                <th class="filter-false remove sorter-false"><input type="checkbox" class="ts_checkbox_all"></th>
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
                        <?php        $p = 1;
                                foreach ($kraTargetList as $key => $val) {
                                 if($this->Common->isUserActive($kraTargetList[$key]['KraTarget']['emp_code'])){

                                    $ctr = (($this->params['paging']['KraTarget']['page'] * $this->params['paging']['KraTarget']['limit']) - $this->params['paging']['KraTarget']['limit']) + $p;
                                    
                                    $totalKraRecords = $this->Common->getTotalKraTarge($kraTargetList[$key]['KraTarget']['emp_code'],$kraTargetList[$key]['KraTarget']['financial_year']);                                    
                                    //$totalApproved = count($this->Common->getKraTargetApprovedStatusForModerator($kraTargetList[$key]['KraTarget']['emp_code'],$kraTargetList[$key]['KraTarget']['financial_year']));
                                    
									$midReviewsTab = $this->Common->findMidReviewsListMod($kraTargetList[$key]['KraTarget']['emp_code'],$kraTargetList[$key]['KraTarget']['financial_year']);
									$midReviewsDetails = $this->Common->findMidReviewsDetailsMod($kraTargetList[$key]['KraTarget']['emp_code'],$kraTargetList[$key]['KraTarget']['financial_year']);
									
									
                                   
                                    
                                    $totalCompRecords = $this->Common->getCompetencyTargetDetails($kraTargetList[$key]['KraTarget']['emp_code'],$kraTargetList[$key]['KraTarget']['financial_year']);
                                    
                                    $totalAssignCompRecords = $this->Common->getTotalAssignCompetencyList($kraTargetList[$key]['KraTarget']['emp_code'],$kraTargetList[$key]['KraTarget']['financial_year']);                                                                        
                                    
									$midReviewsAllStatus = $this->Common->midReviewsAllStatus($kraTargetList[$key]['KraTarget']['emp_code'],$kraTargetList[$key]['KraTarget']['financial_year']);
									
									$midCompDetails = $this->Common->findMidCompDetailsMod($kraTargetList[$key]['KraTarget']['emp_code'],$kraTargetList[$key]['KraTarget']['financial_year']);	
									
									if($midReviewsAllStatus==1){
                                        $readOnlyCheckBox = "ts_checkbox";
                                        $disableCheckBox = "";
                                       
                                    }else{
                                        $readOnlyCheckBox = "ts_checkbox";
                                        $disableCheckBox = "";
                                        
                                        
                                    }/* else{
                                        $readOnlyCheckBox = "";
                                        $disableCheckBox = 'disabled="disabled", title="Competency Rating not assign by Reviewer..." ';
                                           if(count($totalAssignCompRecords) != 0 && count($totalCompRecords) < count($totalAssignCompRecords)){
                                        $readOnlyCheckBox = "";
                                        $disableCheckBox = 'disabled="disabled", title="Competency Rating not assign by Reviewer..." ';
                                        
                                        
                                    } */                                    
                                    $midCompDetails = $this->Common->findMidCompDetailsMod($kraTargetList[$key]['KraTarget']['emp_code'],$kraTargetList[$key]['KraTarget']['financial_year']);	
									
                                    
									$kraoverallratings = $this->Common->getKraoverallratings($kraTargetList[$key]['KraTarget']['emp_code'],$kraTargetList[$key]['KraTarget']['financial_year']);
									
									
								
									if($midReviewsDetails==1){
										$status = "Open";
                                       $btnClass = "uk-badge uk-badge-primary";
									}
									if($midReviewsAllStatus==1){
									
										if($midCompDetails <1 ){
											$status = "Open";
											$btnClass = "uk-badge uk-badge-primary";
									   
										}else{
											$readOnlyCheckBox = "";
                                        $disableCheckBox = 'disabled="disabled" ';
										$status = "Completed";
                                       $btnClass = "uk-badge uk-badge-success";
										}
										
									}
									
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
										<td><?php echo $this->Common->findEmpName($kraTargetList[$key]['KraTarget']['reviewer_id']); ?></td>
										<td><span class="<?php echo $btnClass; ?>"><?php echo $status; ?></span></td>
										<td>    
									<a href="<?php echo $this->webroot; ?>KraMasters/viewModeratorKraTarget/<?php echo $kraTargetList[$key]['KraTarget']['emp_code']."/".base64_encode($kraTargetList[$key]['KraTarget']['financial_year']); ?>/<?php echo base64_encode('allmidmod'); ?>" alt="Assign KRA Score" title="Assign KRA Score" class="uk-badge uk-badge-warning">Mid Review</a>
									<input type="hidden" name ="data[review_type][<?= $key ?>]" value ='mr'>
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
