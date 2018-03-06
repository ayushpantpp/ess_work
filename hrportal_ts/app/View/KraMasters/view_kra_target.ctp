<?php
$kra_config = $this->Session->read('sess_kra_config');

?>
<style>
.uk-table {
    border-collapse: unset;
}

.uk-table tfoot td, .uk-table tfoot th, .uk-table thead th {
    font-style: normal;
    font-weight: bold;
    color: #727272;
    font-size: 14px;
    border: solid 1px !important;
}
#parent {
	height: 500px;
}

.tbl {
	width: 1820px !important;
}

table.tbl tr,table.tbl td{
	border:solid 1px #000 !important;
}

</style>
<script src="<?php echo $this->webroot ?>js/tableHeadFixer.js" type="text/javascript"></script>
<script>
  
$(document).ready(function($) {
	$(".tbl").tableHeadFixer({"left" : 2}); 
});
</script><div id="page_content" role="main">
    <div id="page_content_inner">        
      
        <?php echo $flash = $this->Session->flash(); ?>
        <div class="md-card">            
            <div class="md-card-content">  <h3>View KRA</h3>
                <div class="uk-overflow-container">
				
                    <?php  if(count($kraTargetList)>0){?>
                    <table class="uk-table md-bg-blue-50">
                        <?php 
                        if($empAuthCode !=""){
                            $empId = $empAuthCode;
                        }
                        
                        if($empCode !=""){
                            $empId = $empCode;
                        }
                      
                        $empDetails = $this->Common->getEmpDetails($empId);
						//echo $page_type;die;
						if($page_type=="allemp"){
							$CompetencyTab = 0;
							$midReviewsTab = 0;
							$midReviewsDetails = 2;
						}elseif($page_type=="allmidemp"){
							$CompetencyTab = 0;
							$midReviewsTab = $this->Common->findMidReviewsList($empDetails['MyProfile']['emp_code'],$currentFinancialYear);
							$midReviewsDetails = $this->Common->findMidReviewsDetails($empDetails['MyProfile']['emp_code'],$currentFinancialYear);
							$midReviewsAllStatus = $this->Common->midReviewsAllStatus($empDetails['MyProfile']['emp_code'],$currentFinancialYear);
						}elseif($page_type=="allannemp"){
							$CompetencyTab = $this->Common->findAppraisalProcessList($empDetails['MyProfile']['emp_code'],$currentFinancialYear);
							if($kra_config['MstPmsConfig']['mid_review'] == 1){
							$midReviewsTab = $this->Common->findMidReviewsList($empDetails['MyProfile']['emp_code'],$currentFinancialYear);
							$midReviewsDetails = $this->Common->findMidReviewsDetails($empDetails['MyProfile']['emp_code'],$currentFinancialYear);
							$midReviewsAllStatus = $this->Common->midReviewsAllStatus($empDetails['MyProfile']['emp_code'],$currentFinancialYear);
							}
							$annual_status_mod = $this->Common->findAnnReviewsDetails($empDetails['MyProfile']['emp_code'],$currentFinancialYear);
						}
						
							
                        ?>
                        <tbody>
                            <tr>
                                <td><b>Performance Period</b></td>
                                <td colspan="3"><?php echo $this->Common->findfyDesc($currentFinancialYear);?></td>
                            </tr>
                            <tr>
                                <td><b>Employee Name</b></td>
                                <td><?php echo ucwords(strtolower($empDetails['MyProfile']['emp_full_name']));?></td>
                                <td><b>Emp Code / Designation</b></td>
                                <td><?php echo $empDetails['MyProfile']['emp_id'];?> / <?php echo $this->Common->findDesignationName($empDetails['MyProfile']['desg_code'],$empDetails['MyProfile']['comp_code']);?></td>
                            </tr>
                            <tr>
                                <td><b>Department</b></td>
                                <td><?php echo $this->Common->findDepartmentNameByCode($empDetails['MyProfile']['dept_code']);?></td>
                                <td><b>Date of Joining</b></td>
                                <td><?php echo date('d-m-Y', strtotime($empDetails['MyProfile']['join_date'])); ?></td>
                            </tr>
                            <tr>
                                <td><b>Appraiser's Name</b></td>
                                <td><?php echo $this->Common->findEmpName($empDetails['MyProfile']['manager_code']);?></td>
                                <td><b>Appraiser's Designation</b></td>
                                <td><?php
                            $AppraiserDesgCode =  $this->Common->getempdesgcode($empDetails['MyProfile']['manager_code']);
                            echo $this->Common->findDesignationName($AppraiserDesgCode,$empDetails['MyProfile']['comp_code']);?></td>
                            </tr>
                            <tr>
                                <td><b>Reviewer's Name</b></td>
                                <td><?php $reviewerManagerCode = $this->Common->getManagerCode($empDetails['MyProfile']['manager_code']);
                                    echo $reviewerCode =  $this->Common->findEmpName($reviewerManagerCode);
                                    ?></td>
                                <td><b>Reviewer's Designation</b></td>
                                <td><?php 
                            $reviewerDesgCode = $this->Common->getempdesgcode($reviewerManagerCode);
                            echo $this->Common->findDesignationName($reviewerDesgCode,$empDetails['MyProfile']['comp_code']);
                            ?></td>
                            </tr>
							
						  <tr>
                                <td><b>Moderator's Name</b></td>
                                <td><?php $moderatorManagerCode = $this->Common->getManagerCode($reviewerManagerCode);
                                    echo $moderatorCode =  $this->Common->findEmpName($moderatorManagerCode);
                                    ?></td>
                                <td><b>Moderator's Designation</b></td>
                                <td><?php 
                            $moderatorDesgCode = $this->Common->getempdesgcode($moderatorManagerCode);
                            echo $this->Common->findDesignationName($moderatorDesgCode,$empDetails['MyProfile']['comp_code']);
                            ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
<?php // endme ?>
            <div class="md-card-content">
			 <?php
					if($page_type=="allemp"){
						echo '<a alt="Download KRA details Report" title="Download KRA details Report" style="text-align:right" href="'.$this->webroot.'KraMasters/kraReportFile/'.base64_encode($empDetails['MyProfile']['emp_code'])."/".base64_encode($currentFinancialYear)."/".base64_encode($empDetails['MyProfile']['comp_code']).'/'.base64_encode('detail').'" class="md-btn md-btn-primary md-btn-small"><i class="material-icons md-color-amber-900">&#xE2C4;</i> File Download</a>
						  ';
						  
						  echo '<br> <br> ';
					}
					if($page_type=="allmidemp"){
						if($midReviewsAllStatus==1){
						echo '<a alt="Download Mid Year Report" title="Download Mid Year Report" style="text-align:right" href="'.$this->webroot.'KraMasters/kraReportFile/'.base64_encode($empDetails['MyProfile']['emp_code'])."/".base64_encode($currentFinancialYear)."/".base64_encode($empDetails['MyProfile']['comp_code']).'/'.base64_encode('mid').'" class="md-btn md-btn-primary md-btn-small"><i class="material-icons md-color-amber-900">&#xE2C4;</i> File Download</a>
						  ';
						  echo '<br> <br> ';
						}
					}
					if($page_type=="allannemp"){
						if($annual_status_mod==1){
						echo '<a alt="Download Annual Report" title="Download Annual Report" style="text-align:right" href="'.$this->webroot.'KraMasters/kraReportFile/'.base64_encode($empDetails['MyProfile']['emp_code'])."/".base64_encode($currentFinancialYear)."/".base64_encode($empDetails['MyProfile']['comp_code']).'/'.base64_encode('ann').'" class="md-btn md-btn-primary md-btn-small"><i class="material-icons md-color-amber-900">&#xE2C4;</i> File Download</a>
						  ';
						  echo '<br> <br> ';
						}
					}
					?>
						 
                <div class="uk-accordion" data-uk-accordion>
                    <h3 class="uk-accordion-title">KRA Details</h3>
                    <div class="uk-accordion-content">
										<?php 
										if($selfScoreTabOpen == 0){
										?>
						<div style="margin-top: -20px;text-align: right;"><b>Note :</b> Tick to approve KRAs <input checked="" disabled="" type="checkbox"><br>Keep untick to reject KRAs <input disabled="" type="checkbox"></div>
										<?php
										}
										?>
                        <?php echo $this->Form->create('updateEmpKraTarget', array('url' => array('controller' => 'KraMasters', 'action' => 'updateEmpKraTarget'), 'id' => 'form_validation', 'class' => 'uk-form-stacked','enctype' => "multipart/form-data")); ?>
                        <div class="uk-overflow-container">
                            <?php 
                            if($selfScoreTabOpen == 1){
                                echo "<h3>Section A: Review of KRA</h3>";
                            }

                            ?> 
<div id="parent">
			
			 <table border="1" class="uk-table uk-tab-responsive main tbl" id="TextBoxesGroup">
			  <thead>
                                <tr>
									<?php 
										if($selfScoreTabOpen == 0){
											
											if($revRecords >= 1){
												if($allApprRecords == 1){
													echo '<th rowspan="2" class="uk-text-center md-bg-blue-100 uk-te uk-text-small">Sr.No.</th>';
												}else{
									?>
									<th rowspan="2" class="uk-text-center md-bg-blue-100 uk-te uk-text-small">(Tick only,<br/> if you want to<br/> delete the KRA)</th>
									<?php		
										}
											}else{
										echo '<th rowspan="2" class="uk-text-center md-bg-blue-100 uk-te uk-text-small">Sr.No.</th>';
											}
										}else{
											echo '<th rowspan="2" class="uk-text-center md-bg-blue-100 uk-te uk-text-small">Sr.No.</th>';
											
										}
                                    ?>
                                    
                                    <th rowspan="2" class="uk-text-center md-bg-blue-100 uk-text-small">KRA</th>
                                    <th rowspan="2" class="uk-text-center md-bg-blue-100 uk-text-small">Weightage (%) </th>
                                    <th rowspan="2" class="uk-text-center md-bg-blue-100 uk-text-small">Measure (KPI)</th>
                                    <th rowspan="2" class="uk-text-center md-bg-blue-100 uk-text-small">Measure Type</th>
                                    <th rowspan="2" class="uk-text-center md-bg-blue-100 uk-text-small">View Document</th>
									<th colspan="3" class="uk-text-center md-bg-blue-100 uk-text-small">Annual</th>
									<th class="uk-text-center md-bg-blue-100 uk-text-small">Mid Year</th>
                                    <?php  
									
                                    if($selfScoreTabOpen == 0){
                                    if($revRecords >= 1){
										if($revBy == 1){
									?>
                                    <th colspan="2" class="uk-text-center md-bg-blue-100 uk-text-small">Appraiser Comment</th>
									<?php
										}else{
									?>
                                    <th colspan="2" class="uk-text-center md-bg-blue-100 uk-text-small">Reviewer Comment</th>
									<?php		
										}
									?>
                                    <th colspan="1" class="uk-text-center md-bg-blue-100 uk-text-small">Emp Comment</th>
                                    <?php } if($reviewerTotalRecords != 0){?>

                                    <?php }                                    
                                    }else{
										if($midReviewsTab == 0 && $CompetencyTab == 0){ ?>
                                    <th rowspan="2" class="uk-text-center md-bg-blue-100 uk-text-small">Emp Comment</th>
									<th rowspan="2" class="uk-text-center md-bg-blue-100 uk-text-small">Appraiser Comment</th>
									<th rowspan="2" class="uk-text-center md-bg-blue-100 uk-text-small">Reviewer Comment</th>									
                                    <?php 
                                        }
                                        if($midReviewsTab == 1){?>
                                    <th colspan="3" class="uk-text-center md-bg-blue-100 uk-text-small">Mid Year Self Score</th>                                        
                                    <?php 
                                        }
                                       										
                                    }?>
									
									<?php
									
								
									if($midReviewsAllStatus==1){
									?>
									<th colspan="2" class="uk-text-center md-bg-blue-100 uk-text-small">Mid Year Appraiser Score</th>
									<?php
									if($kraTargetList[0]['KraTarget']['reviewer_id']!=0 && $kraTargetList[0]['KraTarget']['moderator_id']!=0){
										
									?>
									
									<th colspan="2" class="uk-text-center md-bg-blue-100 uk-text-small">Mid Year Reviewer Score</th>
									<th colspan="2" class="uk-text-center md-bg-blue-100 uk-text-small">Mid Year Moderator Score</th>
									<?php
										}elseif($kraTargetList[0]['KraTarget']['reviewer_id']!=0 && $kraTargetList[0]['KraTarget']['moderator_id']==0){
										?>
									<th colspan="2" class="uk-text-center md-bg-blue-100 uk-text-small">Mid Year Reviewer Score</th>
									
									<?php
									}
									}
									 if($CompetencyTab == 1){?>
                                    <th colspan="4" class="uk-text-center md-bg-blue-100 uk-text-small">Annual Self Score</th>                                        
                                    <?php 
                                        }
									?>
                                </tr>

                                <tr>
                                    
                                    <th class="uk-text-center md-bg-blue-100 uk-text-small">Baseline</th>
                            <th class="uk-text-center md-bg-blue-100 uk-text-small">Target</th>
                            <th class="uk-text-center md-bg-blue-100 uk-text-small">Stretched</th>
							<th class="uk-text-center md-bg-blue-100 uk-text-small">Target</th>                           
                                    <?php  
                                    if($selfScoreTabOpen == 0){

                                        if($revRecords >= 1){?>
                                    <th class="uk-text-center md-bg-blue-100 uk-text-small">Approval Status</th>
                                    <th class="uk-text-center md-bg-blue-100 uk-text-small">Comments</th>
                                    <th class="uk-text-center md-bg-blue-100 uk-text-small"></th>
                                        <?php }if($reviewerTotalRecords != 0){?>

                                        <?php }                            
                                    }else{if($midReviewsTab == 1){?>
                                    <th class="uk-text-center md-bg-blue-100 uk-text-small">Actual</th>
                                    <th class="uk-text-center md-bg-blue-100 uk-text-small">Comments</th>
                                    <th class="uk-text-center md-bg-blue-100 uk-text-small">Upload Document</th>
                                    <?php }
									
									
									}
									if($midReviewsAllStatus==1){
									?>
									<th class="uk-text-center md-bg-blue-100 uk-text-small">Comments</th>
									<th class="uk-text-center md-bg-blue-100 uk-text-small">View Document</th>
									<?php
									if($kraTargetList[0]['KraTarget']['reviewer_id']!=0 && $kraTargetList[0]['KraTarget']['moderator_id']!=0){
										
									?>
									<th class="uk-text-center md-bg-blue-100 uk-text-small">Comments</th>
									<th class="uk-text-center md-bg-blue-100 uk-text-small">View Document</th>
									<th class="uk-text-center md-bg-blue-100 uk-text-small">Comments</th>
									<th class="uk-text-center md-bg-blue-100 uk-text-small">View Document</th>
									<?php
										}elseif($kraTargetList[0]['KraTarget']['reviewer_id']!=0 && $kraTargetList[0]['KraTarget']['moderator_id']==0){
									?>
									<th class="uk-text-center md-bg-blue-100 uk-text-small">Comments</th>
									<th class="uk-text-center md-bg-blue-100 uk-text-small">View Document</th>
									<?php
										}
									
									}
									if($CompetencyTab == 1){?>
                                    <th class="uk-text-center md-bg-blue-100 uk-text-small">Actual</th>
                                    <th class="uk-text-center md-bg-blue-100 uk-text-small">Achievement (%)</th>
									<?php
									
									if($kra_config['MstPmsConfig']['app_type'] == 2){
									?>
                                    <th class="uk-text-center md-bg-blue-100 uk-text-small">Achieved</th>
                                    <?php
									}else{
									?>
									<th class="uk-text-center md-bg-blue-100 uk-text-small">Comments</th>
									<?php
									}
									?>
									<th class="uk-text-center md-bg-blue-100 uk-text-small">Upload Document</th>
                                    <?php }
									?>

                                </tr>
 </thead>
                                <?php 

                                  $p = 1;
                                for($i=0;$i<count($kraTargetList);$i++)
                                {

                                $ctr = (($this->params['paging']['KraTarget']['page']*$this->params['paging']['KraTarget']['limit'])-$this->params['paging']['KraTarget']['limit'])+$p;

                                $finalStatus = $kraTargetList[$i]['KraTarget']['final_status'];
                                $appraiserStatus = $kraTargetList[$i]['KraTarget']['appraiser_status'];
                                $reviewerFinalStatus = $kraTargetList[$i]['KraTarget']['reviewer_final_status'];


                                if($finalStatus == 1){
                                   $checkBoxStatus = "checked='checked'";                           
                                }else{
                                    $checkBoxStatus = "";                           
                                }

                                if($reviewerFinalStatus == 1){
                                    $reviewerCheckBoxStatus = "checked='checked'";                           
                                }else{
                                    $reviewerCheckBoxStatus = "";                           
                                }
										

                                ?>

                                <tr>
								<td>  
								<?php 
										if($selfScoreTabOpen == 0){
											//echo $finalStatus;
											if($revRecords >= 1){
												if($allApprRecords == 1){
													echo $ctr;
												}else{
											if($finalStatus == 0 && $appraiserStatus==3 ){
									?>
									<input type="checkbox" name="record">
									<?php	
											}
												}
												
											}else{
												echo $ctr;
											}											
										}else{
												echo $ctr;
											}
                                    ?></td>
                                   
                                    <?php if($appraiserStatus ==3){
                                        ?>
                                    <td><?php echo $this->Form->input("kra_name.", array("class" => "uk-width-medium-1-1 textarea_expand", "value" => html_entity_decode($kraTargetList[$i]['KraTarget']['kra_name']), "label" => "", "type" => "textarea", "maxlength" => "2000", "required" => True)); ?>
									</td>
                                    <?php }else{?>
                                    <td><?php echo $this->Form->input("kra_name.", array("class" => "uk-width-medium-1-1 textarea_expand", "label" => "", "value" => html_entity_decode($kraTargetList[$i]['KraTarget']['kra_name']) ,"type" => "hidden", "required" => True));
                                        echo html_entity_decode($kraTargetList[$i]['KraTarget']['kra_name']);?></td>
                                    <?php }


                                    ?>  
<?php
								echo $this->Form->input("id.", array("value" => $kraTargetList[$i]['KraTarget']['id'], "type" => "hidden", "required" => True)); 
                                        echo $this->Form->input("financial_year.", array("value" => $kraTargetList[$i]['KraTarget']['financial_year'], "type" => "hidden")); 
								?>
                                    <td><?php 
                                   
                                        if($selfScoreTabOpen == 0){ 
                                            if($appraiserStatus == 5 ){
                                                echo $this->Form->input("weightage.", array("class" => "weightage", "value" => $kraTargetList[$i]['KraTarget']['weightage'] , "id" => "weightage", "onblur" => "setWeigh(this);", "onkeypress" => "return isNumberKey(event,this)", "label" => "", "type" => "text",'div' => false ,'style' => 'width:45px;', "required" => True,'readonly'=> 'readonly', "autocomplete"=> "off"))."<label>%</label>"; 

                                            }elseif($appraiserStatus == 3 ){                                           
                                                echo $this->Form->input("weightage.", array("class" => "weightage", "value" => $kraTargetList[$i]['KraTarget']['weightage'] , "id" => "weightage", "onblur" => "setWeigh(this);", "onkeypress" => "return isNumberKey(event,this)", "label" => false, "type" => "text",'div' => false,'style' => 'width:45px;', "required" => True, "autocomplete"=> "off")); 
                                            }else{
												echo '<input type="hidden" class="weightage" value="'.$kraTargetList[$i]['KraTarget']['weightage'].'" />';
												echo $kraTargetList[$i]['KraTarget']['weightage']."%";
											}
                                            
                                        }else{
                                            echo $this->Form->input("weightage.", array("class" => "weightage", "value" => $kraTargetList[$i]['KraTarget']['weightage'] , "id" => "weightage", "onblur" => "setWeigh(this);", "onkeypress" => "return isNumberKey(event,this)", "label" => false, "type" => "hidden",'style' => 'width:45px;','div' => false, "required" => True, "autocomplete"=> "off")); 
										
                                           echo $kraTargetList[$i]['KraTarget']['weightage']."%"; 
                                        }


                                    ?></td>    

                                    <?php if($appraiserStatus ==3){?>
                                    <td><?php echo $this->Form->input("measure.", array("class" => "uk-width-medium-1-1 textarea_expand",  "value" => html_entity_decode($kraTargetList[$i]['KraTarget']['measure']) , "label" => "", "type" => "textarea", "required" => True)); ?></td>
                                    <?php }else{?>
                                    <td><?php echo $this->Form->input("measure.", array("class" => "uk-width-medium-1-1 textarea_expand",  "value" => html_entity_decode($kraTargetList[$i]['KraTarget']['measure']) , "label" => "", "type" => "hidden", "required" => True));
                                        echo html_entity_decode($kraTargetList[$i]['KraTarget']['measure']);?></td>
                                    <?php }if($appraiserStatus ==3){?>
                                   
                                    <td class="measure_type">
<?php if($kraTargetList[$i]['KraTarget']['measure_type']!=''){

echo $this->Form->input("measure_type.", array(
		    'type' => 'radio',
		    'id' => "measure_type",
		    'name' => "data[updateEmpKraTarget][measure_type_".($i+1)."]",
		    "class" => "uk-width-medium-1-1 measure_type",
		    'options' => array('1'=>'Higher the Better','2'=>'Lower the Better','3'=>'Boolean'),
		    'separator' => '<br />',
		    "required" => True,
		    'onclick' => 'setNumberValidation(this.value,this)',
		    "value" => $kraTargetList[$i]['KraTarget']['measure_type']
		));

}else{
		echo $this->Form->input("measure_type.", array(
		    'type' => 'radio',
		    'id' => "measure_type",
		    'name' => "data[updateEmpKraTarget][measure_type_1]",
		    "class" => "uk-width-medium-1-1 measure_type",
		    'options' => array('1'=>'Higher the Better','2'=>'Lower the Better','3'=>'Boolean'),
		    'separator' => '<br />',
		    "required" => True,
		    'onclick' => 'setNumberValidation(this.value,this)',
		    //"value" => $kraTargetList[$i]['KraTarget']['measure_type']
		));
}
	?>
                                    </td>                            
                                    <?php }else{?>
                                    <td class="measure_type">
<?php 
//echo 'aaaaa';
echo $this->Form->input("measure_type.", array(
		    'type' => 'hidden',
		    'id' => "measure_type",
		    'name' => "data[updateEmpKraTarget][measure_type_".($i+1)."]",
		    "class" => "uk-width-medium-1-1 measure_type",
		    'options' => array('1'=>'Higher the Better','2'=>'Lower the Better','3'=>'Boolean'),
		    'separator' => '<br />',
		    "required" => True,
		    'onclick' => 'setNumberValidation(this.value,this)',
		    "value" => $kraTargetList[$i]['KraTarget']['measure_type']
		));

if($kraTargetList[$i]['KraTarget']['measure_type']==1){
echo 'Higher the Better';
}elseif($kraTargetList[$i]['KraTarget']['measure_type']==2){
echo 'Lower the Better';
}elseif($kraTargetList[$i]['KraTarget']['measure_type']==3){
echo 'Boolean';
}
?></td>

                                    <?php }if($appraiserStatus ==3){
                                        ?>
                                    <td class="kra_upload">
										<div class=" md-btn md-btn-primary">
                                            
                                            <input class="kra_upload" style="width:175px !important" type="file" data-parsley-id="10" id="form-file" name="data[updateEmpKraTarget][kra_upload_<?php echo ($i+1); ?>]">
                                        </div><br><span style="font-size:10px">* mouseover to see document<br/>* uploading new document will override old document</span><br>
										<?php
											if ($kraTargetList[$i]['KraTarget']['kra_upload'] != "") {
												echo '<span id="kra_upload'.$kraTargetList[$i]['KraTarget']['id'].'"><a href="'.$this->webroot . 'uploads/KRA/' . $kraTargetList[$i]['KraTarget']['kra_upload'].'" target="_blank">'.$kraTargetList[$i]['KraTarget']['kra_upload'].'</a>  <span onclick="remove_doc('.$kraTargetList[$i]['KraTarget']['id'].','.$i.');"><span class="menu_icon"><i class="material-icons">&#xe5c9;</i></span></span></span>';
											}else{
												echo 'N/A';
											}
										?>
									</td>
                                    <?php }else{?>
                                    <td><?php 
									if ($kraTargetList[$i]['KraTarget']['kra_upload'] != "") {
										echo '<a href="'.$this->webroot . 'uploads/KRA/' . $kraTargetList[$i]['KraTarget']['kra_upload'].'" target="_blank">'.$kraTargetList[$i]['KraTarget']['kra_upload'].' </a>';
										//echo $kraTargetList[$i]['KraTarget']['kra_upload'];
									}else{
										echo 'N/A';
									}
									echo '<input  class="kra_upload" type="hidden" value="'.$kraTargetList[$i]["KraTarget"]["kra_upload"].'" name="data[updateEmpKraTarget][kra_upload_'.($i+1).']">'; ?></td>
                                    <?php }if($appraiserStatus ==3){
                                        ?>
                                    <td class="qualifying"><?php
                                        if($kraTargetList[$i]['KraTarget']['measure_type']==1){
                                            echo $this->Form->input("qualifying.", array("class" => "uk-width-medium-1-1 qualifying","id" => "qualifying","value" => html_entity_decode($kraTargetList[$i]['KraTarget']['qualifying']) , "label" => "","onkeyup"=>"return isNumber(this);","onkeypress" =>"return isNumberKey(event,this);", "type" => "text", "required" => True, "autocomplete"=> "off")); 
                                            }elseif($kraTargetList[$i]['KraTarget']['measure_type']==2){
                                            echo $this->Form->input("qualifying.", array("class" => "uk-width-medium-1-1 qualifying","id" => "qualifying","value" => html_entity_decode($kraTargetList[$i]['KraTarget']['qualifying']) , "label" => "","onkeyup"=>"return isNumber(this);","onkeypress" =>"return isNumberKey(event,this);",  "type" => "text", "required" => True, "autocomplete"=> "off"));
                                            }elseif($kraTargetList[$i]['KraTarget']['measure_type']==3){
                                            echo $this->Form->input("qualifying.", array("class" => "uk-width-medium-1-1 qualifying textarea_expand","id" => "qualifying","value" => html_entity_decode($kraTargetList[$i]['KraTarget']['qualifying']) , "label" => "", "type" => "textarea", "required" => True, "autocomplete"=> "off"));
                                            }
                                     ?></td>
                                    <?php }else{?>
                                    <td><?php echo html_entity_decode($kraTargetList[$i]['KraTarget']['qualifying']);
echo $this->Form->input("qualifying.", array("class" => "uk-width-medium-1-1 qualifying","id" => "qualifying","value" =>html_entity_decode( $kraTargetList[$i]['KraTarget']['qualifying']), "type" => "hidden", "required" => True, "autocomplete"=> "off")); ?></td>
                                    <?php }if($appraiserStatus ==3){
                                        ?>
                                    <td class="target"><?php
									//echo html_entity_decode($kraTargetList[$i]['KraTarget']['target']);
                                        if($kraTargetList[$i]['KraTarget']['measure_type']==1){
                                            echo $this->Form->input("target.", array("class" => "uk-width-medium-1-1 target","id" => "target","value" => html_entity_decode($kraTargetList[$i]['KraTarget']['target']) , "label" => "","onkeyup"=>"return isNumber(this);","onkeypress" =>"return isNumberKey(event,this);", "type" => "text", "required" => True, "autocomplete"=> "off")); 
                                            }elseif($kraTargetList[$i]['KraTarget']['measure_type']==2){
                                            echo $this->Form->input("target.", array("class" => "uk-width-medium-1-1 target","id" => "target","value" =>html_entity_decode( $kraTargetList[$i]['KraTarget']['target']) , "label" => "","onkeyup"=>"return isNumber(this);","onkeypress" =>"return isNumberKey(event,this);",  "type" => "text", "required" => True, "autocomplete"=> "off"));
                                            }elseif($kraTargetList[$i]['KraTarget']['measure_type']==3){
                                            echo $this->Form->input("target.", array("class" => "uk-width-medium-1-1 target textarea_expand","id" => "target","value" => html_entity_decode($kraTargetList[$i]['KraTarget']['target'], ENT_COMPAT, 'UTF-8') , "label" => "", "type" => "textarea", "required" => True, "autocomplete"=> "off"));
                                            }
//echo $this->Form->input("target.", array("class" => "uk-width-medium-1-1 target","id" => "target","value" => $kraTargetList[$i]['KraTarget']['target'] , "label" => "", "type" => "text", "required" => True)); ?></td>
                                    <?php }else{?>
                                    <td><?php echo html_entity_decode($kraTargetList[$i]['KraTarget']['target']);
echo $this->Form->input("target.", array("class" => "uk-width-medium-1-1 target","id" => "target","value" => html_entity_decode($kraTargetList[$i]['KraTarget']['target']), "type" => "hidden", "required" => True)); ?></td>
                                    <?php }if($appraiserStatus ==3){?>
                                    <td class="stretched"><?php if($kraTargetList[$i]['KraTarget']['measure_type']==1){
                                            echo $this->Form->input("stretched.", array("class" => "uk-width-medium-1-1 stretched","id" => "stretched","value" => html_entity_decode($kraTargetList[$i]['KraTarget']['stretched']) , "label" => "","onkeyup"=>"return isNumber(this);","onkeypress" =>"return isNumberKey(event,this);", "type" => "text", "required" => True, "autocomplete"=> "off")); 
                                            }elseif($kraTargetList[$i]['KraTarget']['measure_type']==2){
                                            echo $this->Form->input("stretched.", array("class" => "uk-width-medium-1-1 stretched","id" => "stretched","value" => html_entity_decode($kraTargetList[$i]['KraTarget']['stretched']) , "label" => "","onkeyup"=>"return isNumber(this);","onkeypress" =>"return isNumberKey(event,this);",  "type" => "text", "required" => True, "autocomplete"=> "off"));
                                            }elseif($kraTargetList[$i]['KraTarget']['measure_type']==3){
                                            echo $this->Form->input("stretched.", array("class" => "uk-width-medium-1-1 stretched textarea_expand","id" => "stretched","value" => html_entity_decode($kraTargetList[$i]['KraTarget']['stretched']) , "label" => "", "type" => "textarea", "required" => True, "autocomplete"=> "off"));
                                            }
//echo $this->Form->input("stretched.", array("class" => "uk-width-medium-1-1 stretched", "id" => "stretched","value" => $kraTargetList[$i]['KraTarget']['stretched'] , "label" => "", "type" => "text", "required" => True)); ?></td>
                                    <?php }else{?>
                                    <td><?php echo html_entity_decode($kraTargetList[$i]['KraTarget']['stretched']);
                                        
echo $this->Form->input("stretched.", array("class" => "uk-width-medium-1-1 stretched", "id" => "stretched","value" => html_entity_decode($kraTargetList[$i]['KraTarget']['stretched']) , "type" => "hidden", "autocomplete"=> "off"));?></td>
                                    <?php }if($appraiserStatus ==3){
                                        ?>
                                    <td class="mid_target"><?php
                                        if($kraTargetList[$i]['KraTarget']['measure_type']==1){
                                            echo $this->Form->input("mid_target.", array("class" => "uk-width-medium-1-1 mid_target","id" => "mid_target","value" => html_entity_decode($kraTargetList[$i]['KraTarget']['mid_self_target']) , "label" => "","onkeyup"=>"return isNumber(this);","onkeypress" =>"return isNumberKey(event,this);", "type" => "text", "required" => True, "autocomplete"=> "off")); 
                                            }elseif($kraTargetList[$i]['KraTarget']['measure_type']==2){
                                            echo $this->Form->input("mid_target.", array("class" => "uk-width-medium-1-1 mid_target","id" => "mid_target","value" => html_entity_decode($kraTargetList[$i]['KraTarget']['mid_self_target']) , "label" => "","onkeyup"=>"return isNumber(this);","onkeypress" =>"return isNumberKey(event,this);",  "type" => "text", "required" => True, "autocomplete"=> "off"));
                                            }elseif($kraTargetList[$i]['KraTarget']['measure_type']==3){
                                            echo $this->Form->input("mid_target.", array("class" => "uk-width-medium-1-1 mid_target textarea_expand","id" => "mid_target","value" => html_entity_decode($kraTargetList[$i]['KraTarget']['mid_self_target']) , "label" => "", "type" => "textarea", "required" => True, "autocomplete"=> "off"));
                                            }
                                     ?></td>
                                    <?php }else{?>
                                    <td><?php echo html_entity_decode($kraTargetList[$i]['KraTarget']['mid_self_target']);
echo $this->Form->input("mid_target.", array("class" => "uk-width-medium-1-1 mid_target","id" => "mid_target","value" => html_entity_decode($kraTargetList[$i]['KraTarget']['mid_self_target']), "type" => "hidden", "required" => True, "autocomplete"=> "off")); ?></td>
                                    <?php } ?>  

                                    <?php 
                                    
                                    if($selfScoreTabOpen == 0){ 
                                        // self score 
                                        
                                        if($revRecords >= 1){
											if($revBy == 1){
											?>
											 <td><input type="checkbox" name="data[updateKraTarget][final_status][]" value="1" <?=$checkBoxStatus;?>   disabled></td>
                                    <td><?php if($kraTargetList[$i]['KraTarget']['appraiser_status_comment']){echo html_entity_decode($kraTargetList[$i]['KraTarget']['appraiser_status_comment']);}else{echo "N/A";} ?></td>
											<?php
												}else{
											?>
							<td><input type="checkbox" name="data[updateKraTarget][reviewer_final_status][]" value="1" <?=$checkBoxStatus;?>   disabled> </td>
                                    <td><?php if($kraTargetList[$i]['KraTarget']['reviewer_status_comment']){echo $kraTargetList[$i]['KraTarget']['reviewer_status_comment'];}else{echo "N/A";} ?></td>
											<?php		
												}
												
											//echo $this->Form->input("id.", array("value" => $kraTargetList[$i]['KraTarget']['id'], "type" => "hidden", "required" => True)); 
                                            //echo $this->Form->input("financial_year.", array("value" => $kraTargetList[$i]['KraTarget']['financial_year'], "type" => "hidden"));
											
											?>
										<input id="kra_upload_fix_<?php echo $i; ?>" name="data[updateEmpKraTarget][kra_upload_fix][]" value="<?php echo $kraTargetList[$i]['KraTarget']['kra_upload']; ?>" type="hidden">
                                   

                                    <td><?php 
                                            if($finalStatus == 0){
                                            echo $this->Form->input("emp_status_comment.", array("class" => "uk-width-medium-1-1 textarea_expand", "label" => "","value" => html_entity_decode($kraTargetList[$i]['KraTarget']['emp_status_comment'] ), "type" => "textarea","required" => TRUE, "maxlength" => "2000")); 
                                            }else{
                                                if($kraTargetList[$i]['KraTarget']['emp_status_comment'] !=""){
                                                  echo ucfirst(html_entity_decode($kraTargetList[$i]['KraTarget']['emp_status_comment']));  
                                                }else{
                                                    echo "N/A";
                                                    echo $this->Form->input("emp_status_comment.", array("class" => "uk-width-medium-1-1 textarea_expand", "label" => "","value" => html_entity_decode($kraTargetList[$i]['KraTarget']['emp_status_comment'] ), "type" => "hidden","required" => TRUE, "maxlength" => "2000")); 
                                                }

                                            }
                                                ?>
                                    </td>
                                        <?php }                             

                                    }else{ 
									if($midReviewsTab == 0 && $CompetencyTab == 0){?>
                                    <td><?php echo ucfirst(html_entity_decode($kraTargetList[$i]['KraTarget']['emp_status_comment']));  ?></td>
									<td><?php echo ucfirst(html_entity_decode($kraTargetList[$i]['KraTarget']['appraiser_status_comment']));  ?></td>
									<td><?php echo ucfirst(html_entity_decode($kraTargetList[$i]['KraTarget']['reviewer_status_comment']));  ?></td>									
                                    <?php 
                                        }
									
									if($midReviewsTab == 1){
                                       
                                        ?>
                                    <td><?php
										if($page_type=='allmidemp'){
												$selfScoreBut=0;
										}
                                        
                                        if($selfScoreBut != 1){
											if($midReviewsDetails==1){
												if($kraTargetList[$i]['KraTarget']['measure_type']==3){
													if($kraTargetList[$i]['KraTarget']['mid_self_score_actual']==1){
													echo 'Overachieved';
													}elseif($kraTargetList[$i]['KraTarget']['mid_self_score_actual']==2){
													echo 'Achieved';
													}elseif($kraTargetList[$i]['KraTarget']['mid_self_score_actual']==3){
													echo 'Underachieved';
													}
													
												}else{
													echo $kraTargetList[$i]['KraTarget']['mid_self_score_actual'];
												}
											}else{
						if($kraTargetList[$i]['KraTarget']['measure_type']==1){
							echo $this->Form->input("mid_self_score_actual.", array("class" => "uk-width-medium-1-1 mid_self_score_actual", "id" => "mid_self_score_actual" ,"label" => "", "type" => "text", "value" =>$kraTargetList[$i]['KraTarget']['mid_self_score_actual'] ,"onblur" => "setAchievementHigherBetter(this)","onkeypress" => "return isNumberKey(event,this)", "required" => TRUE, "autocomplete"=> "off"));
						}elseif($kraTargetList[$i]['KraTarget']['measure_type']==2){
							echo $this->Form->input("mid_self_score_actual.", array("class" => "uk-width-medium-1-1 mid_self_score_actual", "id" => "mid_self_score_actual" ,"label" => "", "type" => "text", "value" =>$kraTargetList[$i]['KraTarget']['mid_self_score_actual'],"onblur" => "setAchievementLowerBetter(this)","onkeypress" => "return isNumberKey(event,this)", "required" => TRUE, "autocomplete"=> "off"));
						}elseif($kraTargetList[$i]['KraTarget']['measure_type']==3){
                                           		 
								echo $this->Form->input("mid_self_score_actual.", array(
								    'type' => 'select',
								    'id' => "mid_self_score_actual",
								    "class" => "uk-width-medium-1-1 mid_self_score_actual",
								    'options' => array(''=>'Please Select','1'=>'Overachieved','2'=>'Achieved','3'=>'Underachieved'),
								    'separator' => '<br />',
								    "onchange" => "setAchievementBoolean(this)",
								    "required" => True,
									"default" => $kraTargetList[$i]['KraTarget']['mid_self_score_actual'],
								));
							
						}
											}
                                        }else{
						if($kraTargetList[$i]['KraTarget']['measure_type']==3){
							if($kraTargetList[$i]['KraTarget']['mid_self_score_actual']==1){
							echo 'Overachieved';
							}elseif($kraTargetList[$i]['KraTarget']['mid_self_score_actual']==2){
							echo 'Achieved';
							}elseif($kraTargetList[$i]['KraTarget']['mid_self_score_actual']==3){
							echo 'Underachieved';
							}
							
						}else{
							
							echo $kraTargetList[$i]['KraTarget']['mid_self_score_actual'];
						}
                                           
                                        }
                                        ?>
                                    </td>
                                 <!--   <td class="mid_self_score_achiev"><?php 
                                       /*  if($selfScoreBut != 1){
                                            
                                            $achievementList = $this->Common->achievementList();
                                            //echo $this->Form->input("self_score_achiev.", array("class" => "uk-width-medium-1-1", "label" => "", 'options' => $achievementList,"type" => "select", "required" => True));
                                            
                                            echo $this->Form->input("mid_self_score_achiev.", array("class" => "uk-width-medium-1-1 mid_self_score_achiev", "id" => "mid_self_score_achiev", "value" => $kraTargetList[$i]['KraTarget']['mid_self_score_achiev'] ,"label" => "", "type" => "text", "onkeypress" => "return isNumberKey(event,this)", "maxlength" => "4", "required" => TRUE, 'readonly' => 'true', "autocomplete"=> "off")); 
                                        }else{
                                            echo $kraTargetList[$i]['KraTarget']['mid_self_score_achiev']."%";
                                        } */
                                        ?></td>-->
                                    <td><?php 
                                        if($selfScoreBut != 1){
											if($midReviewsDetails==1){
												if($kraTargetList[$i]['KraTarget']['mid_self_score_comment'] !=""){
                                                echo ucfirst(html_entity_decode($kraTargetList[$i]['KraTarget']['mid_self_score_comment']));  
                                            }else{
                                                echo "N/A";
                                            }
											}else{
                                            echo $this->Form->input("mid_self_score_comment.", array("class" => "uk-width-medium-1-1 mid_self_score_comment textarea_expand", "id" => "mid_self_score_comment" ,"label" => "", "maxlength" => "2000", "type" => "textarea", "value" =>$kraTargetList[$i]['KraTarget']['mid_self_score_comment']));
											}
                                        }else{
                                            if($kraTargetList[$i]['KraTarget']['mid_self_score_comment'] !=""){
                                                echo ucfirst(html_entity_decode($kraTargetList[$i]['KraTarget']['mid_self_score_comment']));  
                                            }else{
                                                echo "N/A";
                                            }                        

                                        } ?></td> 
                                    <td><?php 
                                        if($selfScoreBut != 1){
											if($midReviewsDetails==1){
												 if($kraTargetList[$i]['KraTarget']['mid_self_actual_upload'] !=""){
                                                echo '<a href="'.$this->webroot . 'uploads/KRA/' . $kraTargetList[$i]['KraTarget']['mid_self_actual_upload'].'" target="_blank">'.$kraTargetList[$i]['KraTarget']['mid_self_actual_upload'].' </a>';  
                                            }else{
                                                echo "N/A";
                                            } 
											}else{
		?>
                                        <div class=" md-btn md-btn-primary">
                                            
                                            <input class="mid_self_actual_upload" style="width:175px !important" type="file" data-parsley-id="10" id="form-file" name="data[updateEmpKraTarget][mid_self_actual_upload_<?php echo $p ;?>]">
                                        </div><br/><span style="font-size:10px">mouseover to see document</span><br/>
										
 					<?php					 echo $this->Form->input("mid_self_actual_upload_pre.", array("value" => $kraTargetList[$i]['KraTarget']['mid_self_actual_upload'], "type" => "hidden", "required" => True));
					echo '<a href="'.$this->webroot . 'uploads/KRA/' . $kraTargetList[$i]['KraTarget']['mid_self_actual_upload'].'" target="_blank">'.$kraTargetList[$i]['KraTarget']['mid_self_actual_upload'].' </a>'; 
											}
                                        }else{
                                            if($kraTargetList[$i]['KraTarget']['mid_self_actual_upload'] !=""){
                                                echo '<a href="'.$this->webroot . 'uploads/KRA/' . $kraTargetList[$i]['KraTarget']['mid_self_actual_upload'].'" target="_blank">'.$kraTargetList[$i]['KraTarget']['mid_self_actual_upload'].' </a>';  
                                            }else{
                                                echo "N/A";
                                            }                        

                                        } ?></td>                               
                                    <?php 
									
									}
									}
									if($midReviewsAllStatus==1){
									
									?>
									<td><?=html_entity_decode($kraTargetList[$i]['KraTarget']['mid_appraiser_score_comment'])?></td>
											
											<td><?php if($kraTargetList[$i]['KraTarget']['mid_app_actual_upload'] !=""){
                                                echo '<a href="'.$this->webroot . 'uploads/KRA/' . $kraTargetList[$i]['KraTarget']['mid_app_actual_upload'].'" target="_blank">'.$kraTargetList[$i]['KraTarget']['mid_app_actual_upload'].' </a>';  
                                            }else{
                                                echo "N/A";
                                            } 
											?>
									</td>
									<?php
									if($kraTargetList[$i]['KraTarget']['reviewer_id']!=0 && $kraTargetList[$i]['KraTarget']['moderator_id']!=0){
										
									?>
									<td><?=html_entity_decode($kraTargetList[$i]['KraTarget']['mid_reviewer_score_comment'])?></td>
											<td><?php if($kraTargetList[$i]['KraTarget']['mid_rev_actual_upload'] !=""){
                                                echo '<a href="'.$this->webroot . 'uploads/KRA/' . $kraTargetList[$i]['KraTarget']['mid_rev_actual_upload'].'" target="_blank">'.$kraTargetList[$i]['KraTarget']['mid_rev_actual_upload'].' </a>';  
                                            }else{
                                                echo "N/A";
                                            } 
											?>
									</td>
									<td><?=html_entity_decode($kraTargetList[$i]['KraTarget']['mid_moderator_score_comment'])?></td>
											<td><?php if($kraTargetList[$i]['KraTarget']['mid_mod_actual_upload'] !=""){
                                                echo '<a href="'.$this->webroot . 'uploads/KRA/' . $kraTargetList[$i]['KraTarget']['mid_mod_actual_upload'].'" target="_blank">'.$kraTargetList[$i]['KraTarget']['mid_mod_actual_upload'].' </a>';  
                                            }else{
                                                echo "N/A";
                                            } 
											?>
									</td>
									<?php
										}elseif($kraTargetList[$i]['KraTarget']['reviewer_id']!=0 && $kraTargetList[$i]['KraTarget']['moderator_id']==0){
									?>
									<td><?=html_entity_decode($kraTargetList[$i]['KraTarget']['mid_reviewer_score_comment'])?></td>
											<td><?php if($kraTargetList[$i]['KraTarget']['mid_rev_actual_upload'] !=""){
                                                echo '<a href="'.$this->webroot . 'uploads/KRA/' . $kraTargetList[$i]['KraTarget']['mid_rev_actual_upload'].'" target="_blank">'.$kraTargetList[$i]['KraTarget']['mid_rev_actual_upload'].' </a>';  
                                            }else{
                                                echo "N/A";
                                            } 
											?>
									</td>
									<?php
										}
									
									}
									    // self score end 
                                        if($CompetencyTab == 1){
                                        //echo $this->Form->input("id.", array("value" => $kraTargetList[$i]['KraTarget']['id'], "type" => "hidden", "required" => True)); 
                                       // echo $this->Form->input("financial_year.", array("value" => $kraTargetList[$i]['KraTarget']['financial_year'], "type" => "hidden")); 
                                        ?>
                                    <td><?php 
                                        
                                        if($selfScoreBut != 1){
						if($kraTargetList[$i]['KraTarget']['measure_type']==1){
							echo $this->Form->input("self_score_actual.", array("class" => "uk-width-medium-1-1 self_score_actual", "id" => "self_score_actual" ,"label" => "", "type" => "text","default" => $kraTargetList[$i]['KraTarget']['self_score_actual'],"onblur" => "setAchievementHigherBetter(this)","onkeypress" => "return isNumberKey(event,this)", "required" => TRUE, "autocomplete"=> "off"));
						}elseif($kraTargetList[$i]['KraTarget']['measure_type']==2){
							echo $this->Form->input("self_score_actual.", array("class" => "uk-width-medium-1-1 self_score_actual", "id" => "self_score_actual" ,"label" => "", "type" => "text","default" => $kraTargetList[$i]['KraTarget']['self_score_actual'],"onblur" => "setAchievementLowerBetter(this)","onkeypress" => "return isNumberKey(event,this)", "required" => TRUE, "autocomplete"=> "off"));
						}elseif($kraTargetList[$i]['KraTarget']['measure_type']==3){
                                           		 
								echo $this->Form->input("self_score_actual.", array(
								    'type' => 'select',
								    'id' => "self_score_actual",
								    "class" => "uk-width-medium-1-1 self_score_actual",
								    'options' => array(''=>'Please Select','1'=>'Overachieved','2'=>'Achieved','3'=>'Underachieved'),
								    'separator' => '<br />',
								    "onchange" => "setAchievementBoolean(this)",
								    "required" => True,
									"default" => $kraTargetList[$i]['KraTarget']['self_score_actual']
								));
							
						}
                                        }else{
						if($kraTargetList[$i]['KraTarget']['measure_type']==3){
							if($kraTargetList[$i]['KraTarget']['self_score_actual']==1){
							echo 'Overachieved';
							}elseif($kraTargetList[$i]['KraTarget']['self_score_actual']==2){
							echo 'Achieved';
							}elseif($kraTargetList[$i]['KraTarget']['self_score_actual']==3){
							echo 'Underachieved';
							}
							
						}else{
							echo $kraTargetList[$i]['KraTarget']['self_score_actual'];
						}
                                           
                                        }
                                        ?>
                                    </td>
                                    <td class="self_score_achiev"><?php 
                                        if($selfScoreBut != 1){
                                           // echo 'sss';
                                            $achievementList = $this->Common->achievementList();
                                            //echo $this->Form->input("self_score_achiev.", array("class" => "uk-width-medium-1-1", "label" => "", 'options' => $achievementList,"type" => "select", "required" => True));
                                            
                                            echo $this->Form->input("self_score_achiev.", array("class" => "uk-width-medium-1-1 self_score_achiev", "id" => "self_score_achiev", "value" => $kraTargetList[$i]['KraTarget']['self_score_achiev'] ,"default" => $kraTargetList[$i]['KraTarget']['self_score_achiev'] ,"label" => "", "type" => "text", "onkeypress" => "return isNumberKey(event,this)", "maxlength" => "4", "required" => TRUE, 'readonly' => 'true', "autocomplete"=> "off")); 
                                        }else{
											//echo 'eeee';
                                            echo $kraTargetList[$i]['KraTarget']['self_score_achiev']."%";
                                        }
                                        ?></td>
                                    <td><?php 
                                        if($selfScoreBut != 1){
                                            echo $this->Form->input("self_score_comment.", array("class" => "uk-width-medium-1-1 self_score_achiev textarea_expand", "id" => "self_score_achiev","default" => $kraTargetList[$i]['KraTarget']['self_score_comment'] ,"label" => "", "maxlength" => "2000", "type" => "textarea"));
                                        }else{
                                            if($kraTargetList[$i]['KraTarget']['self_score_comment'] !=""){
                                                echo ucfirst(html_entity_decode($kraTargetList[$i]['KraTarget']['self_score_comment']));  
                                            }else{
                                                echo "N/A";
                                            }                        

                                        } ?></td> 
                                    <td><?php 
                                        if($selfScoreBut != 1){ 
											 if($kraTargetList[$i]['KraTarget']['self_upload'] !=""){
		?>
						<div class=" md-btn md-btn-primary">
                                            
                                            <input class="self_upload" style="width:175px !important" type="file" data-parsley-id="10" id="form-file" name="data[updateEmpKraTarget][self_upload_<?php echo $p ;?>]">
                                        </div><br/><span style="font-size:10px">mouseover to see document</span><br/>
										
 					<?php					 echo $this->Form->input("self_upload.", array("value" => $kraTargetList[$i]['KraTarget']['self_upload'], "type" => "hidden", "required" => True));
					echo '<a href="'.$this->webroot . 'uploads/KRA/' . $kraTargetList[$i]['KraTarget']['self_upload'].'" target="_blank">'.$kraTargetList[$i]['KraTarget']['self_upload'].' </a>';
					}else{ ?>
											  <div class=" md-btn md-btn-primary">
                                            
                                            <input type="file" data-parsley-id="10" class="self_upload" id="form-file" name="data[updateEmpKraTarget][self_upload_<?php echo $p ;?>]">
                                        </div><br/><span style="font-size:10px">mouseover to see document</span>
											 <?php   }
                                        }else{
                                            if($kraTargetList[$i]['KraTarget']['self_upload'] !=""){
                                                echo '<a href="'.$this->webroot . 'uploads/KRA/' . $kraTargetList[$i]['KraTarget']['self_upload'].'" target="_blank">'.$kraTargetList[$i]['KraTarget']['self_upload'].' </a>';  
                                            }else{
                                                echo "N/A";
                                            }                        

                                        } ?></td>                               
                                    <?php 
									
									} 
									
									?>


                                </tr>
                                <?php $p++; } ?>
                            </table>
							
</div>					
                           
						   <?php
//if($revRecords >= 1 ){
                        //if($revRecords >= 1){?>
                        <br></br>                
                        <div class="uk-grid">
                            <div class="uk-width-1-1">
                                <?php
								 $totalApproved = $this->Common->getOpenKraStatusLevel($empDetails['MyProfile']['emp_code'],$currentFinancialYear,'emp');
                         if($totalApproved == 1){
                              
                                   ?>
                              
								<input type='button' class="md-btn md-btn-primary plusbtn"  value='Add More' id='addButton'>
								<input type='button' class="md-btn md-btn-danger minusbtn" value='Delete KRAs' id='removeButton'>
                                <!--<input type='reset' class="md-btn md-btn-primary" value='Cancel' id='removeButton'>                -->        
								   <?php 
									   }
								
                                    
                                    ?>


                                <?php //} //}?>
                         
				<br><br>
					<?php
				    $sl = 1;
					if(count($KRAfeedback) > 0){
						
					?><label for="feedback">Showing Comments (If any):</label>
					
					<table class="uk-table " id="" role="grid">
                            <thead>
                                <tr role="row">
                                    <th class="uk-text-center" data-column="0">Sl. #</th>
									<th class="uk-text-center" data-column="0">Phase</th>
                                    <th data-column="1" width="50%">Comments</th>
                                    <th data-column="2">Given By</th>
                                    <th data-column="3">Given Date</th>
                                    
                                </tr>
                           </thead>
                            
                            <tbody aria-live="polite" aria-relevant="all">
                          <?php
							foreach($KRAfeedback as $k){
								$name=$this->Common->getEmpDetails($k['KraComptencyFeedback']['created_by']);
						  ?>  <tr role="row" class="odd">
                                    <td><span class="uk-text-small"><?php echo $sl;?></span></td>
                                    <td><span class="uk-text-small"><?php if($k['KraComptencyFeedback']['phase']==1){
										echo 'KRA Approval';
									}elseif($k['KraComptencyFeedback']['phase']==2){
										echo 'Mid Review';
									}elseif($k['KraComptencyFeedback']['phase']==3){
										echo 'Annual Review';
									}?></span></td><td class="uk-text-small"><?php echo $k['KraComptencyFeedback']['feedback'];?></td>
                                    <td class="uk-text-small"><?php echo $name['MyProfile']['emp_full_name'] ;?></td>
                                    <td><span class="uk-badge uk-badge-outline uk-text-upper"><?php echo date('d-m-Y', strtotime($k['KraComptencyFeedback']['created_date']));?></span></td>
                                </tr>
							<?php
							$sl++;
							}
						  ?>
							</tbody>
                        </table>
						<?php
					}
				?>
				 </div>		
				 </div>
                        <?php
						echo $this->Form->input("mid_emp_code", array("value" => $empDetails['MyProfile']['emp_code'], "type" => "hidden", "required" => True)); 
                        $annual_status_emp = $this->Common->findAnnReviewsDetailsEmp($empDetails['MyProfile']['emp_code'],$currentFinancialYear);
                        //$totalApproved = count($this->Common->getKraTargetApprovedStatusForEmp($empDetails['MyProfile']['emp_code'],$currentFinancialYear));
                        //$totalKras = $this->common->getTotalKraTarge($empDetails['MyProfile']['emp_code'],$currentFinancialYear);
						$totalApproved = $this->Common->getOpenKraStatusLevel($empDetails['MyProfile']['emp_code'],$currentFinancialYear,'emp');
						$annual = $this->Common->findAnnReviewsDetailsTabApp($empDetails['MyProfile']['emp_code'],$currentFinancialYear);	
						
                         if($totalApproved == 1){
                       ?>
					   <td><?php echo $this->Form->input("feedback", array("class" => "uk-width-medium-1-1 feedback","id" => "feedback", "label" => "Put comment (if any) :","maxlength" => "1000", "type" => "textarea", "autocomplete"=> "off")); ?>
						<?php echo $this->Form->input("kra_comp", array("class" => "uk-width-medium-1-1 kra_comp","id" => "kra_comp", "value" => "1", "type" => "hidden")); ?>
						</td>
					
								<input type="submit" class="md-btn md-btn-success" onclick="return confirmAction();"  name="submit" value="Submit">
								<input type="button" class="md-btn md-btn-success" id="saveasdraft"  value="Save as draft">
								 <input type='reset' class="md-btn md-btn-primary" value='Cancel' id='removeButton'>
					   
					   
						 <?php }elseif($annual_status_emp == 1 && $page_type=='allannemp'){
							?>
							 <td><?php echo $this->Form->input("feedback", array("class" => "uk-width-medium-1-1 feedback","id" => "feedback", "label" => "Put comment (if any) :","maxlength" => "1000", "type" => "textarea", "autocomplete"=> "off")); ?>
						<?php echo $this->Form->input("kra_comp", array("class" => "uk-width-medium-1-1 kra_comp","id" => "kra_comp", "value" => "1", "type" => "hidden")); ?>
						</td>
					
								<input type="submit" class="md-btn md-btn-success" onclick="return confirmAction();"  name="addSelfScore" value="Submit">
								<input type="button" class="md-btn md-btn-success" id="saveasdraft"  value="Save as draft">
								 <input type='reset' class="md-btn md-btn-primary" value='Cancel' id='removeButton'>
							<?php
						 }
						elseif(($midReviewsDetails !=2) && ($kra_config['MstPmsConfig']['mid_review'] == 1) && ($annual == 0) && ($midReviewsAllStatus != 1)  && $page_type=='allmidemp'){
							 
							 ?>
							 <td><?php echo $this->Form->input("feedback", array("class" => "uk-width-medium-1-1 feedback","id" => "feedback", "label" => "Put comment (if any) :","maxlength" => "1000", "type" => "textarea", "autocomplete"=> "off")); ?>
						<?php echo $this->Form->input("kra_comp", array("class" => "uk-width-medium-1-1 kra_comp","id" => "kra_comp", "value" => "1", "type" => "hidden")); ?>
						</td>
					
								<input type="submit" class="md-btn md-btn-success" onclick="return confirmAction();"  name="addMidScore" value="Submit">
								<input type="button" class="md-btn md-btn-success" id="saveasdraft"  value="Save as draft">
								 <input type='reset' class="md-btn md-btn-primary" value='Cancel' id='removeButton'>
							 <?php
						 } 
						 echo $this->Form->end();?>

</div>	
				

                        <!-- ////////////////////// END KRA ASSESSMENT ////////////////////////////// -->
                        <?php 
                        //echo $ApprovedScore = $this->Common->getKraTargetAllApprovedScoreForEmp($empDetails['MyProfile']['emp_code'],$currentFinancialYear);
                        $ApprovedScore = $this->Common->getKraTargetApprovedStatusForEmp($empDetails['MyProfile']['emp_code'],$currentFinancialYear);
						$totalApprovedKRAs = $this->Common->getTotalKraTarge($empDetails['MyProfile']['emp_code'],$currentFinancialYear);
						
                        $totalRecords = $totalApprovedKRAs;              
                        
                                
                        $weightageSum = '';
                        $chievSum = '';
						
						for($i=0; $i< $totalRecords; $i++){
							if($kra_config['MstPmsConfig']['app_type']==1){
								$chievSum+=$ApprovedScore[$i]['KraTarget']['self_score_achiev']*$ApprovedScore[$i]['KraTarget']['weightage'];
							}

							if($kra_config['MstPmsConfig']['app_type']==2){
								$chievSum+=$ApprovedScore[$i]['KraTarget']['self_score_actual'];
							}
                           
                        }
					
		
                        for($i=0; $i< $totalRecords; $i++){

                           $weightageSum+=$ApprovedScore[$i]['KraTarget']['weightage'];
                        }
                        
                        $weightageAverage =  $weightageSum / $totalRecords;
                        
                        if($kra_config['MstPmsConfig']['app_type']==1){
							$totalAchiv = $chievSum / 100;
						}

						if($kra_config['MstPmsConfig']['app_type']==2){
							$totalAchiv = $chievSum;
						}
					
$kraRatings = $this->Common->findKraRatingList();

for($kra=0;$kra<count($kraRatings);$kra++){
	if($totalAchiv >= $kraRatings[0]['KraRating']['achievement_from']){
		$rating = 5;
	}else if($totalAchiv >= $kraRatings[1]['KraRating']['achievement_from'] && $totalAchiv <= $kraRatings[1]['KraRating']['achievement_to']){
		$rating = 4;
	}else if($totalAchiv >= $kraRatings[2]['KraRating']['achievement_from'] && $totalAchiv <= $kraRatings[2]['KraRating']['achievement_to']){
		$rating = 3;
	}else if($totalAchiv >= $kraRatings[3]['KraRating']['achievement_from'] && $totalAchiv <= $kraRatings[3]['KraRating']['achievement_to']){
		$rating = 2;
	}else if($totalAchiv >= $kraRatings[4]['KraRating']['achievement_from'] && $totalAchiv <= $kraRatings[4]['KraRating']['achievement_to']){
		$rating = 1;
	}else{
		$rating = 1;
	}
	break;
}



                     /*    if($totalAchiv < 60){
                            $rating = 1;
                        }else if($totalAchiv >= 60 && $totalAchiv <=80){
                            $rating = 2;
                        }else if($totalAchiv >= 81 && $totalAchiv <=100){
                            $rating = 3;
                        }else if($totalAchiv >= 101 && $totalAchiv <=119){
                            $rating = 4;
                        }else if($totalAchiv >= 120){
                            $rating = 5;
                        } */
	
                        if($annual == 1){?>
                        <h4 class="heading_a uk-margin-bottom">Final Review for Appraisal</h4>
                        <div class="uk-grid">
                            <div class="uk-width-medium-1-1 uk-row-first">
                                <div class="">
                                    <div class="md-card-content">
                                        <div class="uk-overflow-container">
                                            <table border="1" class="uk-table uk-tab-responsive" id="TextBoxesGroup">
                                                <tr>
                                                    <th class="uk-text-center md-bg-green-50 uk-te uk-text-small">KRA Overall achievement</th>
                                                    <th rowspan="2" class="uk-text-center md-bg-green-50 uk-text-small">(Self)</th>
                                                    <th class="uk-width-medium-7-10 uk-text-center md-bg-green-50 uk-text-small"><?=$totalAchiv;?> (%)</th>
                                                    <th rowspan="2" class="uk-text-center md-bg-green-50 uk-text-small">
                                                <?php
                                                
                                                $commentList = $this->Common->getKraCommentByID($empDetails['MyProfile']['emp_code'],$currentFinancialYear);
                                                $empPreComment = "";
                                                
                                                for($i = 0; $i< count($commentList);$i++){
                                                   $commentSrNo = $i+1;
                                                   $emp_status_comment = $commentList[$i]['KraTarget']['emp_status_comment'];
                                                   $appraiser_status_comment = $commentList[$i]['KraTarget']['appraiser_status_comment'];
                                                   
                                                   if($emp_status_comment != ""){
                                                        $empPreComment.= "Kra "."$commentSrNo : ".ucfirst(html_entity_decode($commentList[$i]['KraTarget']['emp_status_comment']))."<br><br>";
                                                   }else{
                                                        $empPreComment.= "Kra "."$commentSrNo : "."N/A<br>";
                                                   }
                                                   
                                                   if($appraiser_status_comment != ""){
                                                        $AppraiserPreComment.= "Kra "."$commentSrNo : ".ucfirst(html_entity_decode($commentList[$i]['KraTarget']['appraiser_status_comment']))."<br><br>";
                                                    }else{
                                                        $AppraiserPreComment.="Kra "."$commentSrNo : "."N/A";
                                                    }
                                                }
                                                ?>
                                                        <span data-uk-tooltip="{cls:'long-text'}" title="<?=$empPreComment;?>" class="uk-badge uk-badge-success">Overall Comments (Self)</span>
                                                    </th>

                                                </tr>
                                                <tr>
                                                    <th class="uk-text-center md-bg-green-50 uk-text-small">Rating</th>
                                                    <th class="uk-text-center md-bg-green-50 uk-text-small"><?=$rating;?></th>                                                                               
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="uk-width-medium-1-1">
                                <div class="md-card">
                                    <div class="md-card-content">
                                        <div class="uk-overflow-container">
                                            <table class="uk-table uk-text-nowrap" border="1">
                                                <thead>
                                                    <tr class="md-bg-deep-orange-200">
                                                        <th>Rating Scale</th>
                                                        <th>Overall Achievement</th>
                                                        <th>Description of Rating</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="uk-text-small">
                                                    <?php 
                                                        $kraRatingList = $this->Common->findKraRatingList();                                            
                                                        for ($i = 0; $i < count($kraRatingList); $i++) {
                                                            
                                                            if ($kraRatingList[$i]['KraRating']['rating_scale'] == 1 && $kraRatingList[$i]['KraRating']['achievement_from'] == 60) {
                                                                $overAllAchievement = "<".$kraRatingList[$i]['KraRating']['achievement_from']."%";
                                                            }else if ($kraRatingList[$i]['KraRating']['rating_scale'] == 5 && $kraRatingList[$i]['KraRating']['achievement_from'] >= 120) {
                                                                $overAllAchievement = ">=".$kraRatingList[$i]['KraRating']['achievement_from']."%";
                                                            }else{
                                                                $overAllAchievement = $kraRatingList[$i]['KraRating']['achievement_from']."% - ".$kraRatingList[$i]['KraRating']['achievement_to']."%";
                                                            }
                                                        
                                                    ?>
                                                    <tr>
                                                        <td class="uk-text-center"><?php echo $kraRatingList[$i]['KraRating']['rating_scale'];?></td>
                                                        <td class="uk-text-center"><?=$overAllAchievement;?></td>
                                                        <td><?php echo wordwrap(ucfirst(html_entity_decode($kraRatingList[$i]['KraRating']['comment'])), 120, "<br />\n"); ?></td>
                                                    </tr>
                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <?php }?>
	
                    </div>
                    <?php if($CompetencyTab == 1){?>
                    <h3 class="uk-accordion-title">Competency Details</h3>
                    <div class="uk-accordion-content">
                        <h3 class="">Section B: List of your Competencies</h3>
                        <div class="uk-width-medium-1-2 uk-row-first">
                            <?php 
                                
                                $empCode = $empDetails['MyProfile']['emp_code'];
                                $deptCode = $empDetails['MyProfile']['dept_code'];
                                $desgCode = $empDetails['MyProfile']['desg_code'];
                                
                                $allGroupIds = $this->Common->findAssignGroupToEmpList($desgCode,$empCode,$currentFinancialYear);
                                $competencyList = $this->Common->findGroupCompetencyDeptDesgList($allGroupIds);
                                
                                $assignCompetencyDeptDesgList = $this->Common->findAssignCompetencyDeptDesgList($deptCode,$desgCode,$empCode,$currentFinancialYear);
                                
                                
                                $Cccc = array_unique(array_merge($competencyList, $assignCompetencyDeptDesgList));
                                if(count($Cccc) >=1 ){
                            
                            ?>
                            <table border="1" class="uk-table uk-tab-responsive" id="TextBoxesGroup">
                                <tr>
                                    <th class="uk-text-center md-bg-light-green-100">Sr.No</th>
                                    <th class="uk-text-center md-bg-light-green-100">Competency</th>
                                </tr>
                            <?php                                 
                                $c = 1;
                                
                                foreach ($Cccc as $key => $value) { 
								//print_r($Cccc);	?>
                                <tr>
                                    <td><?=$c?></td>
                                    <td><?php
											$compID = $this->Common->findCompetencyIDByName($value);
											echo $value.' <span title="'.$this->Common->findCompetencyDescByID($compID).'"><i class="material-icons">assignment</i></span>';
                                        
                                        echo $this->Form->input('competency_id', array('type' => 'hidden','value' => $compID));?></td>
                                </tr>
                            <?php $c++; 
                            
                    }?>

                            </table>
                            <?php }else{?>
                            <span class="uk-text-danger">Competency not assign for you.. please contact to HR Department</span>                                

                    <?php }?>
                        </div>
                    </div>
                    <?php } ?>

                    <!--- Development Plan Start -->
                    <?php 
                    
                    $developmentPlanTab = $this->Common->developmentPlanTab($empDetails['MyProfile']['emp_code'],$currentFinancialYear); 
                    $totalCompTarget =  count($this->Common->getCompetencyTarget($empDetails['MyProfile']['emp_code'],$currentFinancialYear)); 
                    
                    //if($developmentPlanTab == $totalKras && $totalCompTarget != 0){
					if($CompetencyTab == 1){
						?>
                    <h3 class="uk-accordion-title">Development Plan</h3>
                    <div class="uk-accordion-content">
                        <h3>Section D: Development Plan</h3>
						 <?php 
                            
                            if($developmentPlanSave == 0){
								if($kra_config['MstPmsConfig']['app_type']==2){
									if($developmentPlanList[0]['AppraisalDevelopmentPlan']['app_review_status'] == 2){
								?>
							<p class="md-bg-deep-orange-200" style="padding:12px 8px"><b> Appraiser remarks for rejecting this plan :-</b><br>
                          
                            <span class="uk-text-small"><?php echo $developmentPlanList[0]['AppraisalDevelopmentPlan']['app_remark']; ?></span></p>
						<?php
						
						if($kra_config['MstPmsConfig']['app_type']==2){
						?>
						 <p class="md-bg-yellow-50 padding" style="padding:12px 8px"><b> A ) Training Needs Identification for next year </b><br>
                           </p>
						<?php
						}else{
						?>
						
                        <p class="md-bg-yellow-50 padding" style="padding:12px 8px"><b> A ) Area of Strength & Development</b><br>
                            <span class="uk-text-large">On the basis of Performance thus far, please identify Top 3 </span> 
                            <span class="uk-text-small">(i) Key Areas of Strength and (ii) Key Areas of Development. (You may include both work-related as well as personality related attributes)</span></p>
						<?php
						}
						?>
                        <div class="clearfix"></div>
                           
                            <?php 
									}
								}
								echo $this->Form->create('addDevelopmentPlan', array('url' => array('controller' => 'KraMasters', 'action' => 'addDevelopmentPlan'), 'id' => 'form_validation', 'class' => 'uk-form-stacked addDevelopmentPlan')); ?>
                        <table border="1" class="uk-table uk-tab-responsive" id="TextBoxesGroup">
                            <tr>
                                <th class="uk-text-center md-bg-yellow-50">Self</th>
                            </tr>
                        </table>
                        <div class="uk-grid">
                            <div class="uk-width-1-1">
                                <div class="parsley-row">
								<?php
								if($kra_config['MstPmsConfig']['app_type']==2){
									?>
									<label>Functional :-</label>
									<?php
								}else{
									?>
                                    <label>Areas of Strength (200 chars min, 2000 max)</label>
								<?php } ?>
									<?php echo $this->Form->input("self_areas_strength", array("class" => "md-input", "label" => "", "minlength"  => "200", "maxlength"  => "2000", "type" => "textarea","value" => $developmentPlanList[0]['AppraisalDevelopmentPlan']['self_areas_strength'], "required" => True)); ?>
                                </div>
                            </div>
                        </div>
                        <div class="uk-grid">
                            <div class="uk-width-1-1">
                                <div class="parsley-row">
                                    <?php
								if($kra_config['MstPmsConfig']['app_type']==2){
									?>
									<label>Behavioural :- </label>
									<?php
								}else{
									?>
                                    <label>Areas of Development (200 chars min, 2000 max)</label>
								<?php } ?>
                                        <?php echo $this->Form->input("self_areas_development", array("class" => "md-input", "label" => "", 'maxlength' => '2000', "minlength"  => "200", "type" => "textarea","value" => $developmentPlanList[0]['AppraisalDevelopmentPlan']['self_areas_development'], "required" => True)); ?>
                                </div>
                            </div>
                        </div>
                        <div class="uk-grid">
                            <div class="uk-width-1-1">
                                <input type="submit" class="md-btn md-btn-success" name="submitSelfPlan" value="Submit">
								<input type="button" class="md-btn md-btn-success" id="saveasdraftplan"  value="Save as draft">
                                <input type="hidden" class="md-btn md-btn-success" name="currentFinancialYear" value="<?=$currentFinancialYear;?>">
								<input type="hidden" class="md-btn md-btn-success" name="emp_review_status" value="<?=$developmentPlanList[0]['AppraisalDevelopmentPlan']['emp_review_status'];?>">
								<input type="hidden" class="md-btn md-btn-success" name="" value="<?=$currentFinancialYear;?>">								
                                <input type='reset' class="md-btn md-btn-primary" value='Cancel'>
                            </div>
                        </div>
                            <?php echo $this->form->end();?>
                            <?php }else{?>
                        <table border="1" class="uk-table uk-tab-responsive" id="TextBoxesGroup">
                            <tr>
                                <th class="uk-text-center md-bg-yellow-50">Self</th>
                            </tr>
                            <tr>
							<?php
								if($kra_config['MstPmsConfig']['app_type']==2){
									?>
									<th class="md-bg-yellow-50">Functional :-</th>
									<?php
								}else{
									?>
                                    <th class="md-bg-yellow-50">Areas of Strength</th>
								<?php } ?>
                                
                            </tr>
                            <tr>
                                <td><?php echo ucfirst(html_entity_decode($developmentPlanList[0]['AppraisalDevelopmentPlan']['self_areas_strength']));?></td>
                            </tr>
                            <tr>
                                <?php
								if($kra_config['MstPmsConfig']['app_type']==2){
									?>
									<th class="md-bg-yellow-50">Behavioural :-</th>
									<?php
								}else{
									?>
                                   <th class="md-bg-yellow-50" >Areas of Development</th>
								<?php } ?>
                            </tr>
                            <tr>
                                <td><?php echo ucfirst(html_entity_decode($developmentPlanList[0]['AppraisalDevelopmentPlan']['self_areas_development']));?></td>
                            </tr>                                
                        </table>
                               <?php echo "<span class='uk-text-success'>***Your Development Plan saved for this financial year</span>";
                            }?>
                    </div>
                    <!--- Development Plan End -->
                    <?php 
                        $summary = count($this->Common->openSummaryDiscussion($empDetails['MyProfile']['emp_code'],$currentFinancialYear)); 
                        if($summary >=1){?>
                    <h3 class="uk-accordion-title">Summary Of Discussion</h3>
                    <div class="uk-accordion-content">
                        <h3>Section E: Summary Of Discussion</h3>
                        <div class="uk-overflow-container uk-margin-bottom">
                            <table border="1" class="uk-table uk-text-nowrap uk-tab-responsive" id="TextBoxesGroup">
                                <tr>
                                    <th class="md-bg-yellow-50">Appraiser Comments***</th>                                    
                                </tr>
                                <tr>
                                    <td><?php echo wordwrap($AppraiserPreComment, 120, "<br />\n"); ?></td>
                                </tr>
                                <tr>
                                    <th class="md-bg-yellow-50">Employee Comments***</th>
                                </tr>
                                <tr>
                                    <td><?=$empPreComment?></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                     <?php }}?>
                      <?php  }else{ echo "No Records found. !!!";}?>
					  <!--- Start Overall Rating -->
                    <?php
                    
                    
                    $overallRatingList = $this->Common->getKraCompOverallRating($empDetails['MyProfile']['emp_code'],$currentFinancialYear);
          //echo '<pre>'; print_r($overallRatingList);die; 
                    
                        $moderatorSelfOverallRating = $overallRatingList[0]['KraCompOverallRating']['moderator_self_overall_rating'];
                        $moderatorCompOverallRating = $overallRatingList[0]['KraCompOverallRating']['moderator_comp_overall_rating'];    
				
						$kraModActual = $overallRatingList[0]['KraCompOverallRating']['moderator_self_overall_achiev'];
						$compModActual = $this->Common->getModCompOverallActual($empDetails['MyProfile']['emp_code'],$currentFinancialYear);						
                       
						$overAllAnnualStatus = $this->Common->overAllAnnualStatus($empDetails['MyProfile']['emp_code'],$currentFinancialYear);
                        
                        if(count($overAllAnnualStatus)==1){
                            
                            //print_r($empDetails['MyProfile']['desg_code']);
                            $mgtGroup = $this->Common->findGroupDesg($empDetails['MyProfile']['desg_code']);
                            //print_r($mgtGroup);//die;
                            $groupWeightageList = $this->Common->findGroupWeightage($mgtGroup);
                             
                            $kraWeightage = $groupWeightageList['GroupWeightage']['kra_weightage'];
                            $compWeightage = $groupWeightageList['GroupWeightage']['comp_weightage'];
                            
                            $kraOverallRating = $overallRatingList[0]['KraCompOverallRating']['kra_overall_rating'];                        
                            $compOverallRating = $overallRatingList[0]['KraCompOverallRating']['comp_overall_rating'];

                            $kraCompetencyOverallRating = ($kraOverallRating*$kraWeightage + $compOverallRating*$compWeightage)/100;
							
							$list = $this->Common->getTotalAssignCompetencyList($empDetails['MyProfile']['emp_code'],$currentFinancialYear);
							
							$range=(($this->Common->truncate_number($kraModActual)*$kraWeightage)/100)+($this->Common->truncate_number(round(($compModActual[0]['comp_sum_mod']/count($list))*100)*$compWeightage/100));
						
						$overallRatings = $this->Common->findOverAllRatingList();
						
						if($kra_config['MstPmsConfig']['app_type'] == 2){
						for($kra=0;$kra<count($overallRatings);$kra++){
							
							if($range >= $overallRatings[0]['Rating']['rating_scale_from']){
								$kraCompetencyOverallResult = $overallRatings[0]['Rating']['rating_name'];
								$kraCompetencyOverallName = $overallRatings[0]['Rating']['description'];
							}else if($range >= $overallRatings[1]['Rating']['rating_scale_from'] && $range <= $overallRatings[1]['Rating']['rating_scale_to']){
								$kraCompetencyOverallResult = $overallRatings[1]['Rating']['rating_name'];
								$kraCompetencyOverallName = $overallRatings[1]['Rating']['description'];
							}else if($range >= $overallRatings[2]['Rating']['rating_scale_from'] && $range <= $overallRatings[2]['Rating']['rating_scale_to']){
								$kraCompetencyOverallResult = $overallRatings[2]['Rating']['rating_name'];
								$kraCompetencyOverallName = $overallRatings[2]['Rating']['description'];
							}else if($range >= $overallRatings[3]['Rating']['rating_scale_from'] && $range <= $overallRatings[3]['Rating']['rating_scale_to']){
								$kraCompetencyOverallResult = $overallRatings[3]['Rating']['rating_name'];
								$kraCompetencyOverallName = $overallRatings[3]['Rating']['description'];
							}else if($range >= $overallRatings[4]['Rating']['rating_scale_from'] && $range <= $overallRatings[4]['Rating']['rating_scale_to']){
								$kraCompetencyOverallResult = $overallRatings[4]['Rating']['rating_name'];
								$kraCompetencyOverallName = $overallRatings[4]['Rating']['description'];
							}
							break;
						}
						}
						if($kra_config['MstPmsConfig']['app_type'] == 1){
							for($kra=0;$kra<count($overallRatings);$kra++){
							
							if($kraCompetencyOverallRating >= $overallRatings[0]['Rating']['rating_scale_from']){
								$kraCompetencyOverallResult = $overallRatings[0]['Rating']['rating_name'];
							}else if($kraCompetencyOverallRating >= $overallRatings[1]['Rating']['rating_scale_from'] && $kraCompetencyOverallRating <= $overallRatings[1]['Rating']['rating_scale_to']){
								$kraCompetencyOverallResult = $overallRatings[1]['Rating']['rating_name'];
							}else if($kraCompetencyOverallRating >= $overallRatings[2]['Rating']['rating_scale_from'] && $kraCompetencyOverallRating <= $overallRatings[2]['Rating']['rating_scale_to']){
								$kraCompetencyOverallResult = $overallRatings[2]['Rating']['rating_name'];
							}else if($kraCompetencyOverallRating >= $overallRatings[3]['Rating']['rating_scale_from'] && $kraCompetencyOverallRating <= $overallRatings[3]['Rating']['rating_scale_to']){
								$kraCompetencyOverallResult = $overallRatings[3]['Rating']['rating_name'];
							}else if($kraCompetencyOverallRating >= $overallRatings[4]['Rating']['rating_scale_from'] && $kraCompetencyOverallRating <= $overallRatings[4]['Rating']['rating_scale_to']){
								$kraCompetencyOverallResult = $overallRatings[4]['Rating']['rating_name'];
							}
							break;
						}
						}
                           
                      
                    ?>
                    <h3 class="uk-accordion-title">Overall Rating</h3>
                    <div class="uk-accordion-content">
                        <h3>Section C: Overall Rating</h3>
                        <table border="1" id="TextBoxesGroup" class="uk-table uk-tab-responsive">
                            <tbody>
                                <tr>
                                     <th class="uk-text-center md-bg-teal-50">Sections</th>
									 <?php if($kra_config['MstPmsConfig']['app_type'] == 2){ ?>
									<th class="uk-text-center md-bg-teal-50">% Achieved</th>
									<?php } ?>
									<th class="uk-text-center md-bg-teal-50">Rating</th>
                                    <th class="uk-text-center md-bg-teal-50">Weightage</th>
                                </tr>
                            </tbody>
                            <tr>
                                <td>KRA Rating (a)</td>
								<?php if($kra_config['MstPmsConfig']['app_type'] == 2){ ?>
								<td><?=$kraModActual;?> %</td>
								<?php } ?>
                                <td><?php echo $this->Common->truncate_number($kraOverallRating);?></td>
                                <td><?=$kraWeightage?>%</td>		
                            </tr>
                            <tr>
                                <td>Competency Rating (b)</td>
								<?php if($kra_config['MstPmsConfig']['app_type'] == 2){ ?>
								<td><?php echo $this->Common->truncate_number(round(($compModActual[0]['comp_sum_mod']/count($list))*100));?> %</td>
								<?php } ?>
                                <td><?php echo $this->Common->truncate_number($compOverallRating);?></td>
                                <td><?=$compWeightage?>%</td>		
                            </tr> 
                            <tr>
                                <td>KRA & Competency Overall Rating</td>
								<?php if($kra_config['MstPmsConfig']['app_type'] == 2){ ?>
								 <td><?php echo round($range);?> %</td>
								 <?php } ?>
                                <td><?php echo $this->Common->truncate_number($kraCompetencyOverallRating);?></td>
                                <td>100%</td>		
                            </tr> 
                            <tr>
                                <td>Overall Rating</td>
                                <td colspan="3"><b><?=$kraCompetencyOverallResult?> <?php echo ' - '.$kraCompetencyOverallName?></b></td>
                            </tr> 
                        </table>
                        <div class="uk-overflow-container">
                            <table class="uk-table uk-text-nowrap" border="1">
                                <thead>
                                    <tr class="md-bg-deep-orange-200">
                                        <th>RATING</th>
                                        <th>SCORE</th>
                                        <th>OVERALL DESCRIPTION OF PERFORMANCE</th>
                                    </tr>
                                </thead>
                                <tbody class="uk-text-small">
                                    <?php 
                                        $overAllRatingList = $this->Common->getOverAllRatingList();                                            
                                        for ($i = 0; $i < count($overAllRatingList); $i++) {

                                    ?>
                                    <tr>
                                        <td><?php echo $overAllRatingList[$i]['Rating']['rating_name'];?></td>
                                        <td class="uk-text-center"><?php echo $overAllRatingList[$i]['Rating']['rating_scale_from']." - ".$overAllRatingList[$i]['Rating']['rating_scale_to'];?></td>
                                        <td><?php echo wordwrap(ucfirst($overAllRatingList[$i]['Rating']['description']), 120, "<br />\n"); ?></td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                        <?php }?>
                    <!--- End Overall Rating -->


                  
                </div>                    
            </div>
        </div>
    </div>        
</div>
</div>


<table id="slideleft" style=" overflow:auto; position:fixed; top:30%;text-align:l">
<tbody><tr class="slideLeftItem" style="position:fixed;right: 0px;z-index:1000;height: 43px;width: 121px;border: solid 1px #000;background-color: #bbdefb!important;">
<td>
<div style="top:5px;position:absolute;border-left-width:5px;text-align:center"><b>Total Weightage</b><br> <span id="totWeigh">0</span></div>
</td>

</tr>
</tbody>
</table>

<script type="text/javascript">
var sum1=0;
		$("input.weightage").each(function (i) {
            sum1 = sum1 + parseFloat($(this).val());
			$("#totWeigh").text(sum1.toFixed(1));
        });
		
		function setWeigh(weigh){
			var sum2=0;
		$("input.weightage").each(function (i) {
            sum2 = sum2 + parseFloat($(this).val());
			
			$("#totWeigh").text(sum2.toFixed(1));
        });
		}
    function remove_doc(id,rowno){
				var r = confirm("Are you sure want to delete document?");
				if (r==true) {
					jQuery.ajax({
						type: "POST", 
						url: '<?php echo $this->webroot ?>kra_masters/remove_kra_document/' + id, 
						beforeSend: function(){
								jQuery('#loading_image').show();
							},
						success:function(response){
							if(response){
							jQuery('#loading_image').hide();
							jQuery('#kra_upload'+id).html("");
							jQuery("input#kra_upload_fix_"+rowno).val('');
							//console.log(rowno);
							//console.log(jQuery("input#kra_upload_fix_"+rowno).val());
							}else{
								alert("Something went wrong!! Please try again. ");
							}
						}
					});
				}		
	}
	
	var counter = <?php echo $p; ?>;
	
    $('.plusbtn').click(function () {

        $("#TextBoxesGroup").append('<tr><?php echo $this->Form->create("updateEmpKraTarget"); ?>' +
				'<td>  <input type="checkbox" name="record"></td>' +
                //'<td class="uk-text-center uk-width-small-1-10">' + counter + '</td>' +
                '<td><?php echo $this->Form->input("kra_name.", array("class" => "uk-width-medium-1-1 textarea_expand", "label" => "", "type" => "textarea", "maxlength" => "2000", "required" => True)); ?></td>' +
                '<td><?php echo $this->Form->input("weightage.", array("class" => "uk-width-medium-1-1 weightage", "style"=>"width:45px !important", "id" => "weightage", "onblur" => "setWeigh(this);", "onkeypress" => "return isNumberKey(event,this)", "label" => "", "type" => "text", "required" => True, "autocomplete"=> "off")); ?></td>' +
                '<td><?php echo $this->Form->input("measure.", array("class" => "uk-width-medium-1-1 measure textarea_expand", "label" => "", "type" => "text", "required" => True)); ?></td>' +
                '<td class="measure_type"><?php echo $this->Form->input("measure_type.", array("type" => "radio","id" => "measure_type","name" => "data[updateEmpKraTarget][measure_type_' + counter+']","class" => "uk-width-medium-1-1 measure_type","options" => array("1"=>"Higher the Better","2"=>"Lower the Better","3"=>"Boolean"), "separator" => "<br>","onclick" => "setNumberValidation(this.value,this)", "required" => True)); ?></td>' +
				
				'<td class="kra_upload"><div class=" md-btn md-btn-primary"><input class="kra_upload" style="width:175px !important" type="file" data-parsley-id="10" id="form-file" name="data[updateEmpKraTarget][kra_upload_' + counter+']"></div><span style="font-size:10px"><br>mouseover to see document</span></td>' +
				
                '<td class="qualifying"><?php echo $this->Form->input("qualifying.", array("class" => "uk-width-medium-1-1 qualifying","id" => "qualifying", "maxlength" => "500", "label" => "", "type" => "text", "required" => True, "autocomplete"=> "off")); ?></td>' +
                '<td class="target"><?php echo $this->Form->input("target.", array("class" => "uk-width-medium-1-1 target","id" => "target", "onkeyup" => "return isNumber(this);", "onkeypress" => "return isNumberKey(event,this)", "label" => "", "type" => "text", "required" => True, "autocomplete"=> "off")); ?></td>' +
                '<td class="stretched"><?php echo $this->Form->input("stretched.", array("class" => "uk-width-medium-1-1 stretched","id" => "stretched", "onkeyup" => "return isNumber(this);", "onkeypress" => "return isNumberKey(event,this)", "label" => "", "type" => "text", "required" => True, "autocomplete"=> "off")); ?></td>' +
				
				'<td class="mid_target"><?php echo $this->Form->input("mid_target.", array("class" => "uk-width-medium-1-1 mid_target", "id" => "mid_target","maxlength" => "500", "label" => "", "type" => "text", "required" => True, "autocomplete"=> "off")); ?></td>'  +
								
				'<td><input type="checkbox" name="data[updateEmpKraTarget][final_status][]" value="0" disabled> </td><input name="data[updateEmpKraTarget][id][]" value="" id="updateEmpKraTargetId" type="hidden"><input id="kra_upload_fix" name="data[updateEmpKraTarget][kra_upload_fix][]" value="" type="hidden"><input name="data[updateEmpKraTarget][financial_year][]" value="2" id="updateEmpKraTargetFinancialYear" type="hidden">' +
				'<td>N/A</td>' +
				'<td><?php echo $this->Form->input("emp_status_comment.", array("class" => "uk-width-medium-1-1 textarea_expand", "label" => "","value" => "", "type" => "textarea","required" => TRUE, "maxlength" => "2000")); ?> </td>' +

                '</tr>');
				
        counter++;
		
    });
	
	$(".minusbtn").click(function(){
		var cnt=0;
		var delArr;
		var r = confirm("Are you sure want to delete KRA?");
		if (r==true) {
            $("table#TextBoxesGroup.main tbody").find('input[name="record"]').each(function(i){
            	if($(this).is(":checked")){
					if ($("table#TextBoxesGroup.main tr").length != 3) {
										if(!isNaN(parseInt($.trim($(this).closest("tr").find("input#updateEmpKraTargetId").val())))){
											delArr = parseInt($.trim($(this).closest("tr").find("input#updateEmpKraTargetId").val()));
										}
										$.ajax({
											type: "POST", 
											url: '<?php echo $this->webroot ?>kra_masters/remove_kra/' + delArr, 
											beforeSend: function(){
													$('#loading_image').show();
												},
											success:function(response){
												if(response){
												$('#loading_image').hide();
												
												}else{
													alert("Something went wrong!! Please try again. ");
												}
											}
										}); 
										$(this).parents("tr").remove();
						cnt++;
					}
					else {
						alert("There must be atleast one record to submit.");
						cnt++;
					}
                }
				
            });
		}
		if(!$.isEmptyObject(delArr)){
			
		
		}
			//alert(delArr.toString());
			if(cnt==0){
					alert("Please select records to delete.");
					return false;
				}
        });

    /* $('.minusbtn').click(function () {
        if ($("#TextBoxesGroup tr").length != 3) {
            $("#TextBoxesGroup tr:last-child").remove();
            counter--;
        }
        else {
            alert("You cannot delete first row");
        }
    }); */

    $(document).on('change', '#weightage, #qualifying1 , #target1, #stretched1', function () {
        if (Number($(this).val()) === 0) {
            $(this).val('');
            alert('Number must be greater than 0');
        } else if (Number($(this).val()) > 100) {
            $(this).val('');
            alert('Number must be less than 100');
        }
        ;
    });

    $(document).on('change', '#self_score_actual1, #self_score_achiev1', function () {
        if (Number($(this).val()) < 0) {
            $(this).val('');
            alert('Number must be greater than 0 or equal to 0');
        } else if (Number($(this).val()) > 100) {
            $(this).val('');
            alert('Number must be less than 100 or equal to 100');
        }
        ;
    });

	
    function isNumberKey(evt, obj) {
 
            var charCode = (evt.which) ? evt.which : event.keyCode
            var value = obj.value;
            var dotcontains = value.indexOf(".") != -1;
            if (dotcontains)
                if (charCode == 46) return false;
            if (charCode == 46) return true;
            if (charCode > 31 && (charCode < 48 || charCode > 57))
                return false;
            return true;
        }

    function setAchievementBoolean(this1) {
        if (parseFloat($.trim($(this1).closest("tr").find("select#self_score_actual").val())) != 0) {

            //If Actual < Target, 0 % ; If Actual >=Target but < Stretched ; 100% ; If Actual >= Stretched, 120% 
            if (parseFloat($.trim($(this1).closest("tr").find("select#self_score_actual").val())) == 3) {
                $(this1).closest("tr").find("input#self_score_achiev").val("0");
            } else if (parseFloat($.trim($(this1).closest("tr").find("select#self_score_actual").val())) == 2) {
                $(this1).closest("tr").find("input#self_score_achiev").val("100");
            } else if (parseFloat($.trim($(this1).closest("tr").find("select#self_score_actual").val())) == 1) {
                $(this1).closest("tr").find("input#self_score_achiev").val("120");
            }
        } else {
            $(this1).closest("tr").find("input#self_score_achiev").val("");
        }
        
    }

    function setAchievementHigherBetter(this1) {
        if (parseInt($.trim($(this1).closest("tr").find("input#self_score_actual").val())) != '') {
			
            //If Actual < Target, 0 % ; If Actual >=Target but < Stretched ; 100% ; If Actual >= Stretched, 120% 
            if (parseInt($.trim($(this1).closest("tr").find("input#self_score_actual").val())) < parseInt($.trim($(this1).closest("tr").find("input#target").val()))) {
				total = (parseInt($.trim($(this1).closest("tr").find("input#self_score_actual").val()))/parseInt($.trim($(this1).closest("tr").find("input#target").val())))*100;
				<?php if($kra_config['MstPmsConfig']['app_type']==1){ ?>
								 $(this1).closest("tr").find("input#self_score_achiev").val("0");
					<?php		}
				if($kra_config['MstPmsConfig']['app_type']==2){?>
								$(this1).closest("tr").find("input#self_score_achiev").val(total.toFixed(1));
						<?php	}?>
                
            } else if (parseInt($.trim($(this1).closest("tr").find("input#self_score_actual").val())) >= parseInt($.trim($(this1).closest("tr").find("input#target").val())) && parseInt($.trim($(this1).closest("tr").find("input#self_score_actual").val())) < parseInt($.trim($(this1).closest("tr").find("input#stretched").val()))) {
              total = (parseInt($.trim($(this1).closest("tr").find("input#self_score_actual").val()))/parseInt($.trim($(this1).closest("tr").find("input#target").val())))*100;
                
				<?php if($kra_config['MstPmsConfig']['app_type']==1){ ?>
								  $(this1).closest("tr").find("input#self_score_achiev").val("100");
							<?php		}
				if($kra_config['MstPmsConfig']['app_type']==2){?>
								$(this1).closest("tr").find("input#self_score_achiev").val(total);
							<?php	} ?>
				
            } else if (parseInt($.trim($(this1).closest("tr").find("input#self_score_actual").val())) >= parseInt($.trim($(this1).closest("tr").find("input#stretched").val()))) {
              total = (parseInt($.trim($(this1).closest("tr").find("input#self_score_actual").val()))/parseInt($.trim($(this1).closest("tr").find("input#target").val())))*100;
					<?php if($kra_config['MstPmsConfig']['app_type']==1){ ?>
								  $(this1).closest("tr").find("input#self_score_achiev").val("120");
							<?php		}
				if($kra_config['MstPmsConfig']['app_type']==2){?>
							 $(this1).closest("tr").find("input#self_score_achiev").val(total);
							<?php	} ?>
            }
        } else {
            $(this1).closest("tr").find("input#self_score_achiev").val("");
        }
		
    }

    function setAchievementLowerBetter(this1) {
        if (parseFloat($.trim($(this1).closest("tr").find("input#self_score_actual").val())) != '') {
            //If Actual > Target, 0 % ; If Actual <=Target but > Stretched ; 100% ; If Actual <= Stretched, 120%
            if (parseFloat($.trim($(this1).closest("tr").find("input#self_score_actual").val())) > parseFloat($.trim($(this1).closest("tr").find("input#target").val()))) {
                $(this1).closest("tr").find("input#self_score_achiev").val("0");
            } else if (parseFloat($.trim($(this1).closest("tr").find("input#self_score_actual").val())) <= parseFloat($.trim($(this1).closest("tr").find("input#target").val())) && parseFloat($.trim($(this1).closest("tr").find("input#self_score_actual").val())) > parseFloat($.trim($(this1).closest("tr").find("input#stretched").val()))) {
                $(this1).closest("tr").find("input#self_score_achiev").val("100");
            } else if (parseFloat($.trim($(this1).closest("tr").find("input#self_score_actual").val())) <= parseFloat($.trim($(this1).closest("tr").find("input#stretched").val()))) {
                $(this1).closest("tr").find("input#self_score_achiev").val("120");
            }
        } else {
            $(this1).closest("tr").find("input#self_score_achiev").val("");
        }
		
    }


    function setNumberValidation(this1,this2)
    {
	if(this1!=3){
                $(this2).closest("tr").find("textarea#qualifying").remove();
                $(this2).closest("tr").find(".qualifying .input").html( '<input name="data[updateEmpKraTarget][qualifying][]" class="uk-width-medium-1-1 qualifying" id="qualifying" maxlength="500" required="required" autocomplete="off" data-parsley-id="17" type="text">');
                $(this2).closest("tr").find("input#qualifying").val('');
				$(this2).closest("tr").find("input#qualifying").attr('onkeyup','return isNumber(this);');                                  
				$(this2).closest("tr").find("input#qualifying").attr('onkeypress','return isNumberKey(event,this);');
                
				$(this2).closest("tr").find("textarea#target").remove();
                $(this2).closest("tr").find(".target .input").html( '<input name="data[updateEmpKraTarget][target][]" class="uk-width-medium-1-1 target" id="target" maxlength="500" required="required" autocomplete="off" data-parsley-id="17" type="text">');
                $(this2).closest("tr").find("input#target").val('');
				$(this2).closest("tr").find("input#target").attr('onkeyup','return isNumber(this);');                                      
				$(this2).closest("tr").find("input#target").attr('onkeypress','return isNumberKey(event,this);');
	
				$(this2).closest("tr").find("textarea#stretched").remove();
                $(this2).closest("tr").find(".stretched .input").html( '<input name="data[updateEmpKraTarget][stretched][]" class="uk-width-medium-1-1 stretched" id="stretched" maxlength="500" required="required" autocomplete="off" data-parsley-id="17" type="text">');
                $(this2).closest("tr").find("input#stretched").val('');
				$(this2).closest("tr").find("input#stretched").attr('onkeyup','return isNumber(this);');                                  
				$(this2).closest("tr").find("input#stretched").attr('onkeypress','return isNumberKey(event,this);');

				$(this2).closest("tr").find("textarea#mid_target").remove();
                $(this2).closest("tr").find(".mid_target .input").html( '<input name="data[updateEmpKraTarget][mid_target][]" class="uk-width-medium-1-1 mid_target" id="mid_target" maxlength="500" required="required" autocomplete="off" data-parsley-id="17" type="text">');
                $(this2).closest("tr").find("input#mid_target").val('');
				$(this2).closest("tr").find("input#mid_target").attr('onkeyup','return isNumber(this);');                                  
				$(this2).closest("tr").find("input#mid_target").attr('onkeypress','return isNumberKey(event,this);');
	}else{
                $(this2).closest("tr").find("input#qualifying").remove();
                $(this2).closest("tr").find(".qualifying .input").html( '<textarea name="data[updateEmpKraTarget][qualifying][]" class="uk-width-medium-1-1 textarea_expand" maxlength="2000" required="required" cols="30" rows="6" id="qualifying" data-parsley-id="4"></textarea>');
                $(this2).closest("tr").find("textarea#qualifying").val('');
                			
				$(this2).closest("tr").find("input#target").remove();
                $(this2).closest("tr").find(".target .input").html( '<textarea name="data[updateEmpKraTarget][target][]" class="uk-width-medium-1-1 textarea_expand" maxlength="2000" required="required" cols="30" rows="6" id="target" data-parsley-id="4"></textarea>');
                $(this2).closest("tr").find("textarea#target").val('');

				$(this2).closest("tr").find("input#stretched").remove();
                $(this2).closest("tr").find(".stretched .input").html( '<textarea name="data[updateEmpKraTarget][stretched][]" class="uk-width-medium-1-1 textarea_expand" maxlength="2000" required="required" cols="30" rows="6" id="stretched" data-parsley-id="4"></textarea>');
                $(this2).closest("tr").find("textarea#stretched").val('');
				
				$(this2).closest("tr").find("input#mid_target").remove();
                $(this2).closest("tr").find(".mid_target .input").html( '<textarea name="data[updateEmpKraTarget][mid_target][]" class="uk-width-medium-1-1 textarea_expand" maxlength="2000" required="required" cols="30" rows="6" id="mid_target" data-parsley-id="4"></textarea>');
                $(this2).closest("tr").find("textarea#mid_target").val('');
	}
    }

    function confirmAction() {

        var calculated_total_sum = 0;

        var error = [];
		var error1 = [];
		
		$("input.kra_upload").each(function (i) {
            $(this).removeAttr('name').attr("name","data[updateEmpKraTarget][kra_upload_"+(i+1)+"]");
        });
		
		$("input.mid_self_actual_upload").each(function (i) {
            $(this).removeAttr('name').attr("name","data[updateEmpKraTarget][mid_self_actual_upload_"+(i+1)+"]");
        });			

		$("td.measure_type").each(function (i) {
			$(this).find("input.measure_type").each(function (){
				$(this).removeAttr('name').attr("name","data[updateEmpKraTarget][measure_type_"+(i+1)+"]");
			});
        });
		

     <?php if($midReviewsTab!=1){
		 ?>
	
		$("input.kra_upload").each(function (i) {
			if($('[name="data[updateEmpKraTarget][kra_upload_'+(i+1)+']"]').val()!=''){
			var file_size = $('[name="data[updateEmpKraTarget][kra_upload_'+(i+1)+']"]')[0].files[0].size;
			var file_name = $('[name="data[updateEmpKraTarget][kra_upload_'+(i+1)+']"]')[0].files[0].name;
			//alert(file_name.search("'"));
			if(file_name.search("'") != -1 ) {
				alert("In row no. "+(i+1)+", file name is invalid. Please remove quotes.");
				error1[i]=2;
				return false;
			}
			
			if(file_size>2048000) {
				alert("In row no. "+(i+1)+", file size is heavy. Please upload less than 2MB.");
				error1[i]=2;
				return false;
			}
			
			var fileExtension = ['jpeg', 'jpg', 'png', 'gif', 'bmp', 'doc','docx','ppt','pptx','xls','xlsx', 'txt', 'pdf', 'xml', 'ods'];
				if ($.inArray($('[name="data[updateEmpKraTarget][kra_upload_'+(i+1)+']"]').val().split('.').pop().toLowerCase(), fileExtension) == -1) {
					alert("In row no. "+(i+1)+", file extension is invalid. Please use only : "+fileExtension.join(', '));
					error1[i]=2;
					return false;
				}
			}			
		});

		if ($.inArray(2, error1) != -1) {
            return false;
        }
	<?php }
	?>
	var total_file_size = 0;
		$("input.mid_self_actual_upload").each(function (i) {
			if($('[name="data[updateEmpKraTarget][mid_self_actual_upload_'+(i+1)+']"]').val()!=''){
			var file_size = $('[name="data[updateEmpKraTarget][mid_self_actual_upload_'+(i+1)+']"]')[0].files[0].size;
			var file_name = $('[name="data[updateEmpKraTarget][mid_self_actual_upload_'+(i+1)+']"]')[0].files[0].name;
			//alert(file_name.search("'"));
			if(file_name.search("'") != -1 ) {
				alert("In row no. "+(i+1)+", file name is invalid. Please remove quotes.");
				error1[i]=2;
				return false;
			}
			
			total_file_size = (total_file_size + $('[name="data[updateEmpKraTarget][mid_self_actual_upload_'+(i+1)+']"]')[0].files[0].size);
			if(file_size>2048000) {
				alert("In row no. "+(i+1)+", file size is heavy. Please upload less than 2MB.");
				error1[i]=2;
				return false;
			}
			
			var fileExtension = ['jpeg', 'jpg', 'png', 'gif', 'bmp', 'doc','docx','ppt','pptx','xls','xlsx', 'txt', 'pdf', 'xml', 'ods'];
				if ($.inArray($('[name="data[updateEmpKraTarget][mid_self_actual_upload_'+(i+1)+']"]').val().split('.').pop().toLowerCase(), fileExtension) == -1) {
					alert("In row no. "+(i+1)+", file extension is invalid. Please use only : "+fileExtension.join(', '));
					error1[i]=2;
					return false;
				}
				
			}			
		});
		
if ($.inArray(2, error1) != -1) {
            return false;
        }
		

        $(".uk-width-medium-1-1.stretched").each(function (i) {
            var get_textbox_value = $(this).val();
            //alert(i);
            if ($(this).closest("tr").find(".measure_type:checked").val() == 1 && parseFloat(get_textbox_value) < parseFloat($(this).closest("tr").find("input#target").val())) {
                alert("In row no. " + (i + 1) + ", if your measure type is 'Higher the Better', then 'Stretched' cannot be less than 'Target'. Please input correct value.");
                error[i] = 2;
                return false;

            } else if ($(this).closest("tr").find(".measure_type:checked").val() == 2 && parseFloat(get_textbox_value) > parseFloat($(this).closest("tr").find("input#target").val())) {
                alert("In row no. " + (i + 1) + ", if your measure type is 'Lower the Better', then 'Stretched' cannot be greater than 'Target'. Please input correct value.");
                error[i] = 2;
                return false;
            }

        });
		
        if ($.inArray(2, error) != -1) {
            return false;
        }

 $(".weightage").each(function () {

            var get_textbox_value = $(this).val();
            if ($.isNumeric(get_textbox_value)) {
                calculated_total_sum += parseFloat(get_textbox_value);
            }
        });
		
		
        if (calculated_total_sum !== 100) {
            alert("Weightage sum must be 100 %. !!!");
            return false;
        } else {
            return true;
        }

        $("#total_sum_value").html(calculated_total_sum);

    }

</script>
  
<script>

    $(document).ready(function () {
		$('#saveasdraft').click(function (){
			
			var error1 = [];
			$('#form_validation input[type=text], #form_validation select').each(function() {
						$(this).removeAttr('required');
			});
		var total_file_size = 0;
		
		<?php if($page_type=="allmidemp"){ ?>
		$("input.mid_self_actual_upload").each(function (i) {
			if($('[name="data[updateEmpKraTarget][mid_self_actual_upload_'+(i+1)+']"]').val()!=''){
			var file_size = $('[name="data[updateEmpKraTarget][mid_self_actual_upload_'+(i+1)+']"]')[0].files[0].size;
			var file_name = $('[name="data[updateEmpKraTarget][mid_self_actual_upload_'+(i+1)+']"]')[0].files[0].name;
			//alert(file_name.search("'"));
			if(file_name.search("'") != -1 ) {
				alert("In row no. "+(i+1)+", file name is invalid. Please remove quotes.");
				error1[i]=2;
				return false;
			}
			
			total_file_size = (total_file_size + $('[name="data[updateEmpKraTarget][mid_self_actual_upload_'+(i+1)+']"]')[0].files[0].size);
			if(file_size>2048000) {
				alert("In row no. "+(i+1)+", file size is heavy. Please upload less than 2MB.");
				error1[i]=2;
				return false;
			}
			
			var fileExtension = ['jpeg', 'jpg', 'png', 'gif', 'bmp', 'doc','docx','ppt','pptx','xls','xlsx', 'txt', 'pdf', 'xml', 'ods'];
				if ($.inArray($('[name="data[updateEmpKraTarget][mid_self_actual_upload_'+(i+1)+']"]').val().split('.').pop().toLowerCase(), fileExtension) == -1) {
					alert("In row no. "+(i+1)+", file extension is invalid. Please use only : "+fileExtension.join(', '));
					error1[i]=2;
					return false;
				}
				
			}			
		});
		<?php } ?>
		
		<?php if($page_type=="allannemp"){ ?>
		$("input.self_upload").each(function (i) {
			
			if($('[name="data[updateEmpKraTarget][self_upload_'+(i+1)+']"]').val()!=''){
			var file_size = $('[name="data[updateEmpKraTarget][self_upload_'+(i+1)+']"]')[0].files[0].size;
			var file_name = $('[name="data[updateEmpKraTarget][self_upload_'+(i+1)+']"]')[0].files[0].name;
			//alert(file_name.search("'"));
			if(file_name.search("'") != -1 ) {
				alert("In row no. "+(i+1)+", file name is invalid. Please remove quotes.");
				error1[i]=2;
				return false;
			}
			
			total_file_size = (total_file_size + $('[name="data[updateEmpKraTarget][self_upload_'+(i+1)+']"]')[0].files[0].size);
			if(file_size>2048000) {
				alert("In row no. "+(i+1)+", file size is heavy. Please upload less than 2MB.");
				error1[i]=2;
				return false;
			}
			
			var fileExtension = ['jpeg', 'jpg', 'png', 'gif', 'bmp', 'doc','docx','ppt','pptx','xls','xlsx', 'txt', 'pdf', 'xml', 'ods'];
				if ($.inArray($('[name="data[updateEmpKraTarget][self_upload_'+(i+1)+']"]').val().split('.').pop().toLowerCase(), fileExtension) == -1) {
					alert("In row no. "+(i+1)+", file extension is invalid. Please use only : "+fileExtension.join(', '));
					error1[i]=2;
					return false;
				}
				
			}			
		});
		<?php } ?>
		
		if ($.inArray(2, error1) != -1) {
					return false;
				}
	
		$('<input />').attr('type', 'hidden')
              .attr('name', 'saveasdraft')
              .attr('value', 'saveasdraft')
              .appendTo('#form_validation');
		
		<?php if($page_type=="allmidemp"){ ?>
		$('<input />').attr('type', 'hidden')
		  .attr('name', 'addMidScore')
		  .attr('value', 'addMidScore')
		  .appendTo('#form_validation');
		 <?php } ?>
		 
		 <?php if($page_type=="allannemp"){ ?>
		$('<input />').attr('type', 'hidden')
		  .attr('name', 'addSelfScore')
		  .attr('value', 'Submit')
		  .appendTo('#form_validation');
		 <?php } ?>
		 
		$('#form_validation').attr("action", "<?php echo $this->webroot;?>KraMasters/updateEmpKraTarget");
		
		$('#form_validation').submit();
		
		});
		
		$('#saveasdraftplan').click(function (){
			
			$('#form_validation input[type=textarea]').each(function() {
						$(this).removeAttr('required');
						$(this).removeAttr('minlength');
			});
		
		$('<input />').attr('type', 'hidden')
              .attr('name', 'saveasdraftplan')
              .attr('value', 'saveasdraftplan')
              .appendTo('.addDevelopmentPlan');
			  
		$('<input />').attr('type', 'hidden')
		  .attr('name', 'submitSelfPlan')
		  .attr('value', 'Submit')
		  .appendTo('.addDevelopmentPlan');
		 
		$('.addDevelopmentPlan').attr("action", "<?php echo $this->webroot;?>KraMasters/addDevelopmentPlan");
		
		$('.addDevelopmentPlan').submit();
		
		});
		
        $('form textarea[minlength]').on('keyup', function () {
            e_len = $(this).val().trim().length
            e_min_len = Number($(this).attr('minlength'))
            message = e_min_len <= e_len ? '' : e_min_len + ' characters minimum'
            this.setCustomValidity(message)
        });
		
    })
</script>
<?php ?>
