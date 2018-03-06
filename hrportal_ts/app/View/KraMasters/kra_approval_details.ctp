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
            <div class="md-card-content large-padding"><h3>KRA Details Report</h3>
                <?php echo $this->Form->create('KraReport', array('url' =>array('controller' => 'KraMasters', 'action' => "kraApprovalDetails"),'id'=>'form_validation','class' => 'uk-form-stacked')); ?>               

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
                        <a href="<?php echo $this->webroot?>KraMasters/kraApprovalDetails" class="md-btn md-btn-primary"><i class="material-icons">&#xE5D5;</i> Refresh</a>
                    </div>
                </div>                            

            </div>

        </div>
        <?php if (isset($kraRecordList)) {?>
        <div class="md-card">
            <div class="md-card-content">
                    <?php 
                        if(count($kraRecordList) >= 1) {
                    ?>
                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-1-2 uk-margin-bottom">
                        <a href="<?php echo $this->webroot;?>KraMasters/kraReportFile/<?php echo base64_encode($empCode)."/".base64_encode($fYear)."/".base64_encode($companyCode)?>" class="md-btn md-btn-primary md-btn-small"><i class="material-icons md-color-amber-900">&#xE2C4;</i> File Download</a>
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
									<th>Download KRA details</th>
                                    <!--<th>Appraiser Name</th>
                                    <th>Appraiser Designation</th>
                                    <th>Reviewer Name</th>
                                    <th>Reviewer Designation</th>
                                    <th>Moderator Name</th>
                                    <th>Moderator Designation</th>
                                    <th>Level 0 Status</th>
                                    <th>Level 1 Status</th>
                                    <th>Level 2 Status</th>
                                    <th>Level 3 Status</th>
                                    <th>Level 4 Status</th>-->
                                </tr>
                            </thead>
                      
                            <tbody>
                                <?php
                                    //echo "<pre>"; print_r($kraRecordList);die;
                                    $p = 1;
                                    for ($i = 0; $i < count($kraRecordList); $i++) {

                                        $ctr = (($this->params['paging']['KraTarget']['page'] * $this->params['paging']['KraTarget']['limit']) - $this->params['paging']['KraTarget']['limit']) + $p;
										
										
                                        $empDetails = $this->Common->getEmpDetails($kraRecordList[$i]['KraTarget']['emp_code']);
                                        $listName = $this->Common->findInvestName($kraRecordList[$i]['myprofile']['location_code']);
                                    
                                        $locationName = $listName['OptionAttribute']['name'];

                                        $empKraApprovedStatus = $this->Common->getKraTargetOpenStatusForEmp($kraRecordList[$i]['KraTarget']['emp_code'],$kraRecordList[$i]['KraTarget']['financial_year']);
										$empKraApprovedStatus1 = $this->Common->getKraTargetOpenStatusForEmp1($kraRecordList[$i]['KraTarget']['emp_code'],$kraRecordList[$i]['KraTarget']['financial_year']);
										 
										//echo '<pre>1'.ucfirst($this->Common->findEmpName($kraRecordList[$i]['KraTarget']['emp_code']));print_r($empKraApprovedStatus);
                                        $appKraApprovedStatus = $this->Common->getKraTargetRevertStatusforEmpByAppraiser($kraRecordList[$i]['KraTarget']['emp_code'],$kraRecordList[$i]['KraTarget']['financial_year']);
										//echo '<pre>2'.ucfirst($this->Common->findEmpName($kraRecordList[$i]['KraTarget']['emp_code']));print_r($appKraApprovedStatus);
                                        $revKraApprovedStatus = $this->Common->getKraTargetRevertStatusforEmpByReviewer($kraRecordList[$i]['KraTarget']['emp_code'],$kraRecordList[$i]['KraTarget']['financial_year']);
										//echo '<pre>3'.ucfirst($this->Common->findEmpName($kraRecordList[$i]['KraTarget']['emp_code']));print_r($revKraApprovedStatus);
                                        //$rewSelfScoreStatus = $this->Common->getKraTargetLevelThree($kraRecordList[$i]['KraTarget']['emp_code'],$kraRecordList[$i]['KraTarget']['financial_year']);
                                        //$modSelfScoreStatus = $this->Common->getKraTargetLevelFour($kraRecordList[$i]['KraTarget']['emp_code'],$kraRecordList[$i]['KraTarget']['financial_year']);

                                       /*  if($empApprovedStatus == 0){                                        
                                            $levelZeroStatus = "Completed";
                                        }else{
                                            $levelZeroStatus = "Pending";
                                        } */

                                        if(count($empKraApprovedStatus) >= 1 || count($empKraApprovedStatus1) >= 1){                                        
                                            $levelOneStatus = "Completed";
                                        }else{
                                            $levelOneStatus = "Pending";
                                        }

                                        if(count($appKraApprovedStatus) < 1){                                        
                                            $levelTwoStatus = "Completed";
                                        }else{
                                            $levelTwoStatus = "Pending";
                                        }
										if($kraRecordList[$i]['KraTarget']['reviewer_id']==0){
											$levelThreeStatus = "N/A";
										}else{
											if(count($revKraApprovedStatus) < 1){                                        
												$levelThreeStatus = "Completed";
											}else{
												$levelThreeStatus = "Pending";
											}
										}

                                       /*  if($modSelfScoreStatus >= 1){
                                            $levelFourStatus = "Completed";
                                        }else{
                                            $levelFourStatus = "Pending";
                                        } */
                                        
                                    ?>
                                <tr>
                                    <td><?php echo $ctr; ?></td>
                                    <td><?php echo $empDetails['MyProfile']['emp_id']; ?></td>
                                    <td><?php echo ucfirst($this->Common->findEmpName($kraRecordList[$i]['KraTarget']['emp_code'])); ?></td>                                        
                                    <td><?php echo $locationName; ?></td>
									<td><?php $deptCode = $this->Common->findDepartmentByEmpCode($kraRecordList[$i]['KraTarget']['emp_code']); 
                                            echo  $this->Common->findDepartmentNameByCode($deptCode);?>
									</td>
                                    <td><?php $desgCode = $this->Common->findDesignationByEmpCode($kraRecordList[$i]['KraTarget']['emp_code']); 
                                            echo  $this->Common->findDesignationName($desgCode,$kraRecordList[$i]['KraTarget']['comp_code']);?>
									</td>
                                    <td>
                                            <?php 
                                                $empDetails = $this->Common->getEmpDetails($kraRecordList[$i]['KraTarget']['emp_code']);                                       

                                                echo date('d-m-Y', strtotime($empDetails['MyProfile']['join_date'])); ?>

                                    </td>
									<td> <a href="<?php echo $this->webroot;?>KraMasters/kraReportFile/<?php echo base64_encode($kraRecordList[$i]['KraTarget']['emp_code'])."/".base64_encode($fYear)."/".base64_encode($kraRecordList[$i]['KraTarget']['comp_code'])?>" class="md-btn md-btn-primary md-btn-small"><i class="material-icons md-color-amber-900">&#xE2C4;</i> File Download</a></td>
                                   <!--<td><?php echo $this->Common->findEmpName($empDetails['MyProfile']['manager_code']);?></td>
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


                                    <td><?php echo $this->Common->findEmpName($kraRecordList[$i]['KraTarget']['moderator_id']); ?></td>
                                    <td><?php 
                                                $moderatorManagerCode = $this->Common->getManagerCode($kraRecordList[$i]['KraTarget']['moderator_id']);

                                                $moderatorDesgCode = $this->Common->getempdesgcode($kraRecordList[$i]['KraTarget']['moderator_id']);
                                                echo $this->Common->findDesignationName($moderatorDesgCode,$empDetails['MyProfile']['comp_code']);
                                                ?>
                                    </td>
                                    <td><?=$levelZeroStatus;?></td>
                                    <td><?=$levelOneStatus;?></td>
                                    <td><?=$levelTwoStatus;?></td>
                                    <td><?=$levelThreeStatus;?></td>
                                    <td><?=$levelFourStatus;?></td>-->
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
            url: '<?php echo $this->webroot ?>KraMasters/KraEmpListDetails/kradet/' + locCode,
            //data:'project_id='+val,
            success: function (data) {
                //alert(data);
                $("#empList").html(data);
            }
        });
    }
</script>
