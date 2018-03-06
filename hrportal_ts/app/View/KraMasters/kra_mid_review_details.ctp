<?php

    $auth = $this->Session->read('Auth'); 
    //echo "<pre>";print_r($auth);die;
    $empID = $auth['MyProfile']['emp_id'];

    $locationPrefixArray = explode("-", $empID);
    $locationPrefix = $locationPrefix[0];
?> 
<div id="me"></div>
<div id="page_content" role="main">
    <div id="page_content_inner">

        <?php echo $this->Session->flash(); ?>
        <div class="md-card">
            <div class="md-card-content large-padding"> <h3>KRA Mid Review Details Report</h3>
                <?php echo $this->Form->create('KraReport', array('url' =>array('controller' => 'KraMasters', 'action' => "KraMidReviewDetails"),'id'=>'form_validation','class' => 'uk-form-stacked')); ?>               

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
                        <a href="<?php echo $this->webroot?>KraMasters/KraMidReviewDetails" class="md-btn md-btn-primary"><i class="material-icons">&#xE5D5;</i> Refresh</a>
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
                        <a href="<?php echo $this->webroot;?>KraMasters/kraReportFile/<?php echo base64_encode($empCode)."/".base64_encode($fYear)."/".base64_encode($companyCode)."/".base64_encode("mid")?>" class="md-btn md-btn-primary md-btn-small"><i class="material-icons md-color-amber-900">&#xE2C4;</i> File Download</a>
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
									<td> <a href="<?php echo $this->webroot;?>KraMasters/kraReportFile/<?php echo base64_encode($kraRecordList[$i]['KraTarget']['emp_code'])."/".base64_encode($fYear)."/".base64_encode($kraRecordList[$i]['KraTarget']['comp_code'])."/".base64_encode("mid")?>" class="md-btn md-btn-primary md-btn-small"><i class="material-icons md-color-amber-900">&#xE2C4;</i> File Download</a></td>
                                   
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
            url: '<?php echo $this->webroot ?>KraMasters/KraEmpListDetails/kramiddet/' + locCode,
            //data:'project_id='+val,
            success: function (data) {
                //alert(data);
                $("#empList").html(data);
            }
        });
    }
</script>
