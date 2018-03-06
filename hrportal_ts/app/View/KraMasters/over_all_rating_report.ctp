<div id="page_content" role="main">
    <div id="page_content_inner">
        
       
        <?php echo $this->Session->flash(); ?>
        <div class="md-card">
            <div class="md-card-content large-padding"> <h3>KRA & Competency Overall Rating Report</h3>
                <?php echo $this->Form->create('overAllRatingReport', array('url' =>array('controller' => 'KraMasters', 'action' => "overAllRatingReport"),'id'=>'form_validation','class' => 'uk-form-stacked')); ?>               
                
                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-1-2">
                        <label>Location</label>
                        <div class="parsley-row">
                            <?php
                             $locationList1 = array('All');
                            $locationList = array_merge($locationList1, $this->Common->findLocationName());
                            			
				 echo $this->form->input('comp_code', array('class' => "md-select", 'label'=>false,'type' => 'select' ,'options' => $locationList, 'id' =>'employee_id','data-md-selectize'=>'true', 'onChange' => 'return getEmployeebyKraList(this.value)'));
                                 ?>
                            <!--<select class="md-select" name="comp_code" required="" id="employee_id" data-placeholder="Select Employee..." onChange = 'return getEmployeebyKraList(this.value)' data-md-selectize>
                                <option value=''>Select Location</option>
                                <option value='0'>All</option>
                                <?php 
                                foreach ($locationList as $k => $val){
                                    $listName = $this->Common->findInvestName($k);
                                    
                                    if($listName['OptionAttribute']['name'] == "FARIDABAD"){
                                        $locAliseName = "DLF";
                                    }else if($listName['OptionAttribute']['name'] == "PRITHLA"){
                                        $locAliseName = "PTR";
                                    }else if($listName['OptionAttribute']['name'] == "WDU"){
                                        $locAliseName = "WDU";
                                    }
                                ?>
                                    <option value='<?php echo $locAliseName;?>'> <?php echo $listName['OptionAttribute']['name'];?></option>
                                <?php } ?>
                            </select>  
                            -->
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
                        <a href="<?php echo $this->webroot?>KraMasters/overAllRatingReport" class="md-btn md-btn-primary"><i class="material-icons">&#xE5D5;</i> Refresh</a>
                    </div>
                </div>                            

            </div>

        </div>
        <?php if (isset($kraCompOverallRatingList)) {?>
            <div class="md-card">
                <div class="md-card-content">
                    <?php 
                            if (count($kraCompOverallRatingList) >= 1) {
                    ?>
                    <div class="uk-grid" data-uk-grid-margin>
                        <div class="uk-width-medium-1-2 uk-margin-bottom">
                            <a href="<?php echo $this->webroot;?>KraMasters/overAllRatingReportFile/<?php echo base64_encode($empCode)."/".base64_encode($fYear)."/".base64_encode($companyCode)?>" class="md-btn md-btn-primary md-btn-small"><i class="material-icons md-color-amber-900">&#xE2C4;</i> File Download</a>
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
                                    <th>Emp KRA Rating</th>
                                    <th>Appraiser KRA & Competency Rating</th>
                                    <th>Reviewer KRA & Competency Rating</th>
                                    <th>Moderator KRA & Competency Rating</th>
                                    <th>KRA & Competency Overall Rating</th>
                                    <th>KRA & Competency Overall Result</th>
                                </tr>
                            </thead>
                            
                            <tbody>
                                <?php
                                    $p = 1;
                                    for ($i = 0; $i < count($kraCompOverallRatingList); $i++) {

                                        $ctr = (($this->params['paging']['KraCompOverallRating']['page'] * $this->params['paging']['KraCompOverallRating']['limit']) - $this->params['paging']['KraCompOverallRating']['limit']) + $p;
                                        $emp_self_overall_rating = $this->Common->truncate_number($kraCompOverallRatingList[$i]['KraCompOverallRating']['emp_self_overall_rating']);
                                        $appraiser_self_overall_rating = $this->Common->truncate_number($kraCompOverallRatingList[$i]['KraCompOverallRating']['appraiser_self_overall_rating']);
                                        $appraiser_comp_overall_rating = $this->Common->truncate_number($kraCompOverallRatingList[$i]['KraCompOverallRating']['appraiser_comp_overall_rating']);
                                        
                                        $reviewer_self_overall_rating = $this->Common->truncate_number($kraCompOverallRatingList[$i]['KraCompOverallRating']['reviewer_self_overall_rating']);
                                        $reviewer_comp_overall_rating = $this->Common->truncate_number($kraCompOverallRatingList[$i]['KraCompOverallRating']['reviewer_comp_overall_rating']);
                                        $moderator_self_overall_rating = $this->Common->truncate_number($kraCompOverallRatingList[$i]['KraCompOverallRating']['moderator_self_overall_rating']);
                                        $moderator_comp_overall_rating = $this->Common->truncate_number($kraCompOverallRatingList[$i]['KraCompOverallRating']['moderator_comp_overall_rating']);
                                        
                                        $comp_overall_rating = $this->Common->truncate_number($kraCompOverallRatingList[$i]['KraCompOverallRating']['comp_overall_rating']);
                                        $kra_comp_overall_rating = $this->Common->truncate_number($kraCompOverallRatingList[$i]['KraCompOverallRating']['kra_comp_overall_rating']);
                                        $kra_comp_overall_result = $kraCompOverallRatingList[$i]['KraCompOverallRating']['kra_comp_overall_result'];
                                        
                                        $empDetails = $this->Common->getEmpDetails($kraCompOverallRatingList[$i]['KraCompOverallRating']['emp_code']);
                                        
                                        $listName = $this->Common->findInvestName($kraCompOverallRatingList[$i]['myprofile']['location_code']);
                                    
                                        $locationName = $listName['OptionAttribute']['name'];
                                ?>
                                    <tr>
                                            <td><?php echo $ctr; ?></td>
                                            <td><?php echo $empDetails['MyProfile']['emp_id']; ?></td>
                                            <td><?php echo ucfirst($this->Common->findEmpName($kraCompOverallRatingList[$i]['KraCompOverallRating']['emp_code'])); ?></td>                                        
                                            <td><?php echo $locationName; ?></td>
											
											 <td><?php $deptCode = $this->Common->findDepartmentByEmpCode($kraCompOverallRatingList[$i]['KraCompOverallRating']['emp_code']); 
												echo  $this->Common->findDepartmentNameByCode($deptCode);?> </td>
                                            <td><?php $desgCode = $this->Common->findDesignationByEmpCode($kraCompOverallRatingList[$i]['KraCompOverallRating']['emp_code']); 
                                            echo  $this->Common->findDesignationName($desgCode,$kraCompOverallRatingList[$i]['KraCompOverallRating']['comp_code']);?></td>
                                            <td>
                                            <?php 
                                                $empDetails = $this->Common->getEmpDetails($kraCompOverallRatingList[$i]['KraCompOverallRating']['emp_code']);                                       

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


                                            <td><?php echo $this->Common->findEmpName($kraCompOverallRatingList[$i]['KraCompOverallRating']['moderator_id']); ?></td>
                                            <td><?php 
                                                $moderatorManagerCode = $this->Common->getManagerCode($kraCompOverallRatingList[$i]['KraCompOverallRating']['moderator_id']);

                                                $moderatorDesgCode = $this->Common->getempdesgcode($kraCompOverallRatingList[$i]['KraCompOverallRating']['moderator_id']);
                                                echo $this->Common->findDesignationName($moderatorDesgCode,$empDetails['MyProfile']['comp_code']);
                                                ?>
                                            </td>
                                            <td><?php echo $emp_self_overall_rating; ?></td>
                                            <td><?php echo $appraiser_self_overall_rating." / ".$appraiser_comp_overall_rating; ?></td>
                                            <td><?php echo $reviewer_self_overall_rating." / ".$reviewer_comp_overall_rating; ?></td>
                                            <td><?php echo $moderator_self_overall_rating." / ".$moderator_comp_overall_rating; ?></td>
                                            <td><?php echo $this->Common->truncate_number($kraCompOverallRatingList[$i]['KraCompOverallRating']['kra_overall_rating'])." / ".$this->Common->truncate_number($kraCompOverallRatingList[$i]['KraCompOverallRating']['comp_overall_rating']);?></td>
                                            <td><?php echo $this->Common->truncate_number($kraCompOverallRatingList[$i]['KraCompOverallRating']['kra_comp_overall_rating'])." / ".$kraCompOverallRatingList[$i]['KraCompOverallRating']['kra_comp_overall_result'];;?></td>
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

    function getEmployeebyKraList(locCode){
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
