<?php

    $auth = $this->Session->read('Auth'); 
    //echo "<pre>";print_r($auth);die;
    $empID = $auth['MyProfile']['emp_id'];

    $locationPrefixArray = explode("-", $empID);
    $locationPrefix = $locationPrefix[0];
?> 
<div id="page_content" role="main">
    <div id="page_content_inner">

       
        <?php echo $this->Session->flash(); ?>
        <div class="md-card">
            <div class="md-card-content large-padding"> <h3>PMS Status Report</h3>
                <?php echo $this->Form->create('KraReport', array('url' =>array('controller' => 'KraMasters', 'action' => "PmsStatusReport"),'id'=>'form_validation','class' => 'uk-form-stacked')); ?>               

                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-1-2">
                        <label>Location</label>
                        <div class="parsley-row">
                            <?php
                             $locationList1 = array('All');
                            $locationList = array_merge($locationList1, $this->Common->findLocationName());
                            ?>
				
			 <?php				
				 echo $this->form->input('comp_code', array('class' => "md-select", 'label'=>false,'type' => 'select' ,'options' => $locationList, 'id' =>'employee_id','data-md-selectize'=>'true', 'onChange' => 'return getEmployeebyKraList(this.value)')); ?>
                        
                        </div>
                    </div>
                    <div class="uk-width-medium-1-2">
                        <label>Financial Year</label>
                        <div class="parsley-row">                                
                            <?php 
                            $financialYear = $this->Common->findfyDesc($currentFinancialYear);
                            echo $this->form->input('financial_year', array('label' => "", 'type' => "text", 'value' => "$financialYear",'class' => "md-input",'id' => 'financial_year', 'required' => true,'readonly' => 'readonly')); ?>
                            <input type="hidden" value="<?=$currentFinancialYear?>" name="financialYear">
                        </div>
                    </div>
                </div>
                <div class="uk-grid" data-uk-grid-margin id="empList">

                </div>

                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-1-1 uk-margin-top">                    
                        <button type="submit" name="submit" class="md-btn md-btn-success">Submit</button>
                        <a href="<?php echo $this->webroot?>KraMasters/PmsStatusReportFile" class="md-btn md-btn-primary"><i class="material-icons">&#xE5D5;</i> Refresh</a>
                    </div>
                </div>                            

            </div>

        </div>
        <?php
		if (isset($kraRecordList)) {?>
        <div class="md-card">
            <div class="md-card-content">
                    <?php 
                        if(count($kraRecordList) >= 1) {
                    ?>
                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-1-2 uk-margin-bottom">
                        <a href="<?php echo $this->webroot;?>KraMasters/PmsStatusReportFile/<?php echo base64_encode($empCode)."/".base64_encode($fYear)."/".base64_encode($companyCode)?>" class="md-btn md-btn-primary md-btn-small"><i class="material-icons md-color-amber-900">&#xE2C4;</i> File Download</a>
                            <?php 
                                if($empCode == "0"){
                                    $empCodeStr = "All";
                                }else{
                                    $empCodeStr = ucfirst($this->Common->findEmpName($empCode));
                                } 

                                $financialYear = $this->Common->findfyDesc($fYear);

                                if($companyCode  != "0"){
                                    $locationList = $this->Common->findInvestName($companyCode);
                                    //$compName = $locationList['OptionAttribute']['name'];
                                    $compName =  $companyCode;
                                }else{
                                    $compName = "All";
                                }
                            ?>

                    </div>
                </div>
                <div class="uk-overflow-container uk-margin-bottom">
                    <span class="uk-margin-bottom">Your searching criteria is Emp Name : <?=$empCodeStr?>, Financial Year : <?=$financialYear?>, and Location : <?=$compName;?> , If you want to search again please click to Refresh Button</span>                                
                    <br><br><br><div class="md-card-toolbar-actions">
                        <table id="dt_colVis" class="uk-table" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>Sr.No.</th>
                                    <th>Employee Code</th>
                                    <th>Name</th>
                                    <th>Location</th>
									<th>Department</th>
                                    <th>Designation</th>
                                    <th>Date of Joining</th>
                                    <th>Appraiser Name</th>
                                    <th>Appraiser Designation</th>
                                    <th>Reviewer Name</th>
                                    <th>Reviewer Designation</th>
                                    <th>Moderator Name</th>
                                    <th>Moderator Designation</th>
                                    <th>KRA Status</th>
                                    <th>Appraisal Status</th>
                                </tr>
                            </thead>
                      
                            <tbody>
                                <?php
                                    //echo "<pre>"; print_r($kraRecordList);die;
                                    $p = 1;
                                    for ($i = 0; $i < count($kraRecordList); $i++) {

                                        $ctr = (($this->params['paging']['KraTarget']['page'] * $this->params['paging']['KraTarget']['limit']) - $this->params['paging']['KraTarget']['limit']) + $p;
										
										$empDetails = $this->Common->getEmpDetails($kraRecordList[$i][0]['emp_code']);
                                        $listName = $this->Common->findInvestName($kraRecordList[$i][0]['location_code']);
                                        $locationName = $listName['OptionAttribute']['name'];
										
										$totalKraRecords = $this->Common->getTotalKraTarge($kraRecordList[$i][0]['emp_code'],$fYear);
										
										$KraStatus='';
										if($totalKraRecords <= 0){
											$KraStatus='Initiated';
											
										}else{
											$KraStatus='Submitted';
											$AppraisalStatus =='Pending';
										}
										$totalApprovedKraRecords = $this->Common->getKraTargetByEmpCodeForReviewer($kraRecordList[$i][0]['emp_code'],$fYear);
										
										if(($totalKraRecords == $totalApprovedKraRecords) && ($totalKraRecords!=0)){
											$KraStatus='Approved';
										}
										
										$annual_status = $this->Common->findAppraisalProcessList($kraRecordList[$i][0]['emp_code'],$fYear);
										if($annual_status >=1){
											$AppraisalStatus='Initiated';
										}else{
											$AppraisalStatus='Not Initiated';
										}
										
										$annual_status_emp = $this->Common->findAnnReviewsDetailsTabApp($kraRecordList[$i][0]['emp_code'],$fYear);
										$annual_status_app = $this->Common->findAnnReviewsDetailsTabRev($kraRecordList[$i][0]['emp_code'],$fYear);
										$annual_status_rev = $this->Common->findAnnReviewsDetailsTabMod($kraRecordList[$i][0]['emp_code'],$fYear);
										$annual_status_mod = $this->Common->findAnnReviewsDetails($kraRecordList[$i][0]['emp_code'],$fYear);
										
										if($annual_status_emp >=1){
											$AppraisalStatus='Pending at appraiser end';
										}
										if($annual_status_app >=1){
											$AppraisalStatus='Pending at reviewer end';
										}
										if($annual_status_rev >=1){
											$AppraisalStatus='Pending at moderator end';
										}
										if($annual_status_mod >=1){
											$AppraisalStatus='Completed';
										}
									?>
                                <tr>
                                    <td><?php echo $ctr; ?></td>
                                    <td><?php echo $empDetails['MyProfile']['emp_id']; ?></td>
                                    <td><?php echo ucfirst($this->Common->findEmpName($kraRecordList[$i][0]['emp_code'])); ?></td>                                        
                                    <td><?php echo $locationName; ?></td>
									<td><?php $deptCode = $this->Common->findDepartmentByEmpCode($kraRecordList[$i][0]['emp_code']); 
                                            echo  $this->Common->findDepartmentNameByCode($deptCode);?>
									</td>
                                    <td><?php $desgCode = $this->Common->findDesignationByEmpCode($kraRecordList[$i][0]['emp_code']); 
                                            echo  $this->Common->findDesignationName($desgCode,$kraRecordList[$i][0]['comp_code']);?></td>
                                    <td>
                                            <?php 
                                                $empDetails = $this->Common->getEmpDetails($kraRecordList[$i][0]['emp_code']);                                       

                                                echo date('d-m-Y', strtotime($empDetails['MyProfile']['join_date'])); ?>

                                    </td>
                                    <td><?php echo $this->Common->findEmpName($empDetails['MyProfile']['manager_code']);?></td>
                                    <td><?php
                                                $AppraiserDesgCode =  $this->Common->getempdesgcode($empDetails['MyProfile']['manager_code']);
                                                echo $this->Common->findDesignationName($AppraiserDesgCode,$empDetails['MyProfile']['comp_code']);?></td>

                                    <td><?php $reviewerManagerCode = $this->Common->getManagerCode($empDetails['MyProfile']['manager_code']);
                                                echo $reviewerCode =  $this->Common->findEmpName($reviewerManagerCode);
                                                ?></td>
                                    <td><?php 
                                                $reviewerDesgCode = $this->Common->getempdesgcode($reviewerManagerCode);
                                                echo $this->Common->findDesignationName($reviewerDesgCode,$empDetails['MyProfile']['comp_code']);
                                            ?></td>


                                    <td><?php $moderatorManagerCode = $this->Common->getManagerCode($reviewerManagerCode);
									echo $this->Common->findEmpName($moderatorManagerCode); 
									?></td>
                                    <td><?php
                                                $moderatorDesgCode = $this->Common->getempdesgcode($moderatorManagerCode);
                                                echo $this->Common->findDesignationName($moderatorDesgCode,$empDetails['MyProfile']['comp_code']);
                                                ?>
                                    </td>
                                    
                                    <td><?=$KraStatus;?></td>
                                    <td><?=$AppraisalStatus;?></td>
                                    
                                </tr> 

            <?php $p++;
        }
     ?>

                            </tbody>
                        </table>
                    </div>    
                    <div class="clearfix"></div>
                    <div class="uk-grid" data-uk-grid-margin>

                        <div class="uk-width-medium-1-1">
                            <ul class="uk-pagination uk-pagination-right">
                                    <?php
                                    //echo $this->Paginator->prev('Previous', array('tag' => 'li', 'escape' => false), '<a>Previous</a>', array('class' => 'uk-disabled', 'tag' => 'li', 'escape' => false));
                                    //echo $this->Paginator->numbers(array('separator' => '', 'tag' => 'li', 'currentLink' => true, 'currentClass' => 'uk-active', 'currentTag' => 'a'));
                                    //echo $this->Paginator->next('Next', array('tag' => 'li', 'escape' => false), '<a>Next</a>', array('class' => 'uk-disabled', 'tag' => 'li', 'escape' => false));
                                    ?>
                            </ul>
                        </div>
                    </div>
                </div>
                    <?php } else{ echo "No Records found....";}  ?>

            </div>
        </div>
        <?php } ?>
    </div>
</div>
<script type="text/javascript">

    function getEmployeebyKraList(locCode) {
        $.ajax({
            type: "POST",
            url: '<?php echo $this->webroot ?>KraMasters/KraEmpList/' + locCode,
            //data:'project_id='+val,
            success: function (data) {
                //alert(data);
                $("#empList").html(data);
            }
        });
    }
</script>
