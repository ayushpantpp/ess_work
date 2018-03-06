<?php $auth = $this->Session->read('Auth');

//echo "<pre>";
//print_r($auth['MyProfile']);
//die;?>
<div id="page_content" role="main">
    <div id="page_content_inner">        
        
        <?php echo $flash = $this->Session->flash(); ?>
        <div class="md-card">
            <div class="md-card-toolbar">
                           
                            <h3 class="md-card-toolbar-heading-text">
                                <b>Add KRA</b>
                            </h3>
                        </div>
            <?php 
                    
                $empCode  = $auth['MyProfile']['emp_code'];
                $deptCode = $auth['MyProfile']['dept_code'];
                $desgCode = $auth['MyProfile']['desg_code'];

                $allGroupIds = $this->Common->findAssignGroupToEmpList($desgCode,$empCode,$currentFinancialYear);
                $competencyList = $this->Common->findGroupCompetencyDeptDesgList($allGroupIds);

                $assignCompetencyDeptDesgList = $this->Common->findAssignCompetencyDeptDesgList($deptCode,$desgCode,$empCode,$currentFinancialYear);
//print_r($viewKraRecords);
//print_r($competencyList);
//print_r($assignCompetencyDeptDesgList);
//die;

                $Cccc = array_unique(array_merge($competencyList, $assignCompetencyDeptDesgList));

                if(count($Cccc) >=1 || count($assignCompetencyDeptDesgList) >= 1){

            ?>
            
            <div class="md-card-content">
                <div class="uk-overflow-container">                    
                    <table class="uk-table md-bg-blue-50">
                        
                        <tbody>
                            <tr>
                                <td><b>Performance Period</b></td>
                                <td colspan="3"><?php echo $this->Common->findfyDesc($currentFinancialYear);?></td>                                
                            </tr>                           
                            
                        <tr>
                            <td><b>Employee Name</b></td>
                            <td><?php echo ucwords(strtolower($auth['MyProfile']['emp_full_name']));?></td>
                            <td><b>Emp Code / Designation</b></td>
                            <td><?php echo $auth['MyProfile']['emp_id'];?> / <?php echo $this->Common->findDesignationName($auth['MyProfile']['desg_code'],$auth['MyProfile']['comp_code']);?></td>
                        </tr>
                        <tr>
                            <td><b>Department</b></td>
                            <td><?php echo $this->common->findDepartmentNameByCode($auth['MyProfile']['dept_code']);?></td>
                            <td><b>Date of Joining</b></td>
                            <td><?php echo date('d-m-Y', strtotime($auth['MyProfile']['join_date'])); ?></td>
                        </tr>
                        <tr>
                            <td><b>Appraiser's Name</b></td>
                            <td><?php
                            echo $this->Common->findEmpName($auth['MyProfile']['manager_code']);?></td>
                            <td><b>Appraiser's Designation</b></td>
                            <td><?php $AppraiserDesgCode =  $this->Common->getempdesgcode($auth['MyProfile']['manager_code']);
                            echo $this->Common->findDesignationName($AppraiserDesgCode,$auth['MyProfile']['comp_code']);?></td>
                        </tr>
                        <tr>
                            <td><b>Reviewer's Name</b></td>
                            <td><?php $reviewerManagerCode = $this->Common->getManagerCode($auth['MyProfile']['manager_code']);
                                    echo $reviewerCode =  $this->Common->findEmpName($reviewerManagerCode);
                                    ?></td>
                            <td><b>Reviewer's Designation</b></td>
                            <td><?php 
                            $reviewerDesgCode = $this->Common->getempdesgcode($reviewerManagerCode);
                            echo $this->Common->findDesignationName($reviewerDesgCode,$auth['MyProfile']['comp_code']);
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
            
            
            <div class="md-card-content">
                <?php echo $this->Form->create('addKraTarget', array('url' => array('controller' => 'KraMasters', 'action' => 'addKraTarget'), 'id' => 'form_validation', 'class' => 'uk-form-stacked','enctype' => "multipart/form-data")); ?>
                <div class="uk-overflow-container">
                    <table border="1" class="uk-table uk-tab-responsive main" id="TextBoxesGroup">
                        <tr>
                            <th rowspan="2"  class="uk-text-center md-bg-blue-100 uk-text-small">(Tick only,<br/> if you want to<br/> delete the KRA)</th>
                            <th rowspan="2" class="uk-text-center md-bg-blue-100 uk-text-small" style="width:20%">KRA </th>
                            <th rowspan="2" class="uk-text-center md-bg-blue-100 uk-text-small">Weightage (%)</th>
                            <th rowspan="2" class="uk-text-center md-bg-blue-100 uk-text-small">Measure (KPI)</th>
                            <th rowspan="2" class="uk-text-center md-bg-blue-100 uk-text-small" style="width:20%">Measure Type</th>
							<th rowspan="2" class="uk-text-center md-bg-blue-100 uk-text-small">Upload Document</th>
                            <th colspan="3" class="uk-text-center md-bg-blue-100 uk-text-small" style="width:40%">Annual Target</th>
							<th class="uk-text-center md-bg-blue-100 uk-text-small" style="width:10%">Mid Year Target</th>
                        </tr>

                        <tr>
                            <th class="uk-text-center md-bg-blue-100 uk-text-small">Baseline</th>
                            <th class="uk-text-center md-bg-blue-100 uk-text-small">Target</th>
                            <th class="uk-text-center md-bg-blue-100 uk-text-small">Stretched</th>
							<th class="uk-text-center md-bg-blue-100 uk-text-small">Target</th>
                        </tr>
<?php
                                for($i=0;$i<count($viewKraRecords);$i++)
                                {
?>
                        <tr>
                            <td class="uk-text-center uk-width-small-1-10"><input type="checkbox" name="record"></td>                            
                            <td><?php echo $this->Form->input("kra_name.", array("class" => "uk-width-medium-1-1 textarea_expand", "label" => "","value" => $viewKraRecords[$i]['KraTarget']['kra_name'], "type" => "textarea", "maxlength" => "2000", "required" => True)); ?></td>
                            <td><?php echo $this->Form->input("weightage.", array("class" => "uk-width-medium-1-1 weightage", "id" => "weightage", "style"=>"width:45px !important", "maxlength" => "4","value" => $viewKraRecords[$i]['KraTarget']['weightage'], "onblur" => "setWeigh(this);", "onkeypress" => "return isNumberKey(event,this)", "label" => "", "type" => "text", "required" => True, "autocomplete"=> "off")); ?></td>
                            <td><?php echo $this->Form->input("measure.", array("class" => "uk-width-medium-1-1 textarea_expand","value" => $viewKraRecords[$i]['KraTarget']['measure'], "label" => "", "type" => "textarea", "maxlength" => "500", "required" => True)); ?></td>
                            <td class="measure_type"><?php if($viewKraRecords[$i]['KraTarget']['measure_type']!=''){

echo $this->Form->input("measure_type.", array(
		    'type' => 'radio',
		    'id' => "measure_type",
		    'name' => "data[updateEmpKraTarget][measure_type_".($i+1)."]",
		    "class" => "uk-width-medium-1-1 measure_type",
		    'options' => array('1'=>'Higher the Better','2'=>'Lower the Better','3'=>'Boolean'),
		    'separator' => '<br />',
		    "required" => True,
		    'onclick' => 'setNumberValidation(this.value,this)',
		    "value" => $viewKraRecords[$i]['KraTarget']['measure_type']
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
		    //"value" => $viewKraRecords[$i]['KraTarget']['measure_type']
		));
}
	?></td>
							<td class="kra_upload">
                                        <div class=" md-btn md-btn-primary">
                                          
                                            <input class="kra_upload" style="width:175px !important" type="file" data-parsley-id="10" id="form-file" name="data[addKraTarget][kra_upload_1]">
                                        </div><br/><span style="font-size:10px">mouseover to see document</span>
							</td> 
                            <td class="qualifying"><?php echo $this->Form->input("qualifying.", array("class" => "uk-width-medium-1-1 qualifying","id" => "qualifying", "label" => "","maxlength" => "500","value" => $viewKraRecords[$i]['KraTarget']['qualifying'], "type" => "text", "required" => True, "autocomplete"=> "off")); ?>

	
			    </td>
                            <td class="target"><?php echo $this->Form->input("target.", array("class" => "uk-width-medium-1-1 target","id" => "target","maxlength" => "500", "label" => "", "type" => "text","value" => $viewKraRecords[$i]['KraTarget']['target'], "required" => True, "autocomplete"=> "off")); ?></td>
                            <td class="stretched"><?php echo $this->Form->input("stretched.", array("class" => "uk-width-medium-1-1 stretched", "id" => "stretched","maxlength" => "500", "label" => "","value" => $viewKraRecords[$i]['KraTarget']['stretched'], "type" => "text", "required" => True, "autocomplete"=> "off")); ?></td>
							
							 <td class="mid_target"><?php echo $this->Form->input("mid_target.", array("class" => "uk-width-medium-1-1 mid_target", "id" => "mid_target","maxlength" => "500","value" => $viewKraRecords[$i]['KraTarget']['mid_self_target'], "label" => "", "type" => "text", "required" => True, "autocomplete"=> "off")); ?></td>
                        </tr>
		<?php } ?>
                    </table>
				<div class="uk-grid">
                    <div class="uk-width-1-1"> 
                       
                        <input type='button' class="md-btn md-btn-primary plusbtn"  value='Add More' id='addButton'>
                        <input type='button' class="md-btn md-btn-danger minusbtn" value='Delete KRAs' id='removeButton'>
                    </div>
                </div><br></br>
				<?php echo $this->Form->input("feedback", array("class" => "uk-width-medium-1-1 feedback","id" => "feedback", "label" => "Put comment (if any) :","maxlength" => "1000", "type" => "textarea", "autocomplete"=> "off")); ?>
				<?php echo $this->Form->input("kra_comp", array("class" => "uk-width-medium-1-1 kra_comp","id" => "kra_comp", "value" => "1", "type" => "hidden")); ?>
				
                </div>

                
                <br></br>
                <div class="uk-grid">
                    <div class="uk-width-1-1"> 
                        <input type="submit" class="md-btn md-btn-success" onclick="return confirmAction();" name="submit" value="Submit">
                        <input style="display:none" type="submit" class="md-btn md-btn-success" name="submit1" value="save" id="ww">
							<input type="button" class="md-btn md-btn-success" id="saveasdraft"  value="Save as draft">
                        
                    </div>
                </div>
            <?php echo $this->Form->end(); ?>
            </div>
			
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
				
            <?php }else{?>
                <div class="md-card-content">
                    <div class="uk-overflow-container">
                        <h3 class="uk-text-primary">HR has not initiated the process by linking competencies with you. Please wait for further communication.</h3>
                    </div>
                </div>                
            <?php }?>
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
//check
		var sum1=0;

		$("input.weightage").each(function (i) {
            sum1 = sum1 + parseFloat($(this).val());
			$("#totWeigh").text(sum1);
        });
		
		function setWeigh(weigh){
			var sum2=0;
		$("input.weightage").each(function (i) {
            sum2 = sum2 + parseFloat($(this).val());
			
			$("#totWeigh").text(sum2);
        });
		}    var counter = 2;
    $('.plusbtn').click(function () {

        $("#TextBoxesGroup").append('<tr><?php echo $this->Form->create("addKraTarget"); ?>' +
                '<td class="uk-text-center uk-width-small-1-10"><input type="checkbox" name="record"></td>' +
                '<td><?php echo $this->Form->input("kra_name.", array("class" => "uk-width-medium-1-1 textarea_expand", "label" => "", "type" => "textarea", "maxlength" => "2000", "required" => True)); ?></td>' +                
                '<td><?php echo $this->Form->input("weightage.", array("class" => "uk-width-medium-1-1 weightage","style"=>"width:45px !important", "id" => "weightage", "maxlength" => "4", "onblur" => "setWeigh(this);", "onkeypress" => "return isNumberKey(event,this)", "label" => "", "type" => "text", "required" => True, "autocomplete"=> "off")); ?></td>' +
                '<td><?php echo $this->Form->input("measure.", array("class" => "uk-width-medium-1-1 measure textarea_expand", "label" => "", "type" => "textarea", "maxlength" => "500", "required" => True)); ?></td>' +
                '<td class="measure_type"><?php echo $this->Form->input("measure_type.", array("type" => "radio","id" => "measure_type","name" => "data[addKraTarget][measure_type_' + counter+']","class" => "uk-width-medium-1-1 measure_type","options" => array("1"=>"Higher the Better","2"=>"Lower the Better","3"=>"Boolean"), "separator" => "<br>","onclick" => "setNumberValidation(this.value,this)", "required" => True)); ?></td>' +
				'<td class="kra_upload"><div class=" md-btn md-btn-primary"><input class="kra_upload" style="width:175px !important" type="file" data-parsley-id="10" id="form-file" name="data[addKraTarget][kra_upload_' + counter+']"></div><span style="font-size:10px"><br/>mouseover to see document</span></td>' +
				'<td class="qualifying"><?php echo $this->Form->input("qualifying.", array("class" => "uk-width-medium-1-1 qualifying","id" => "qualifying", "maxlength" => "500", "label" => "", "type" => "text", "required" => True, "autocomplete"=> "off")); ?></td>' +
                '<td class="target"><?php echo $this->Form->input("target.", array("class" => "uk-width-medium-1-1 target","id" => "target", "maxlength" => "500", "label" => "", "type" => "text", "required" => True, "autocomplete"=> "off")); ?></td>' +
                '<td class="stretched"><?php echo $this->Form->input("stretched.", array("class" => "uk-width-medium-1-1 stretched","id" => "stretched", "maxlength" => "500", "label" => "", "type" => "text", "required" => True, "autocomplete"=> "off")); ?></td>' +
				'<td class="mid_target"><?php echo $this->Form->input("mid_target.", array("class" => "uk-width-medium-1-1 mid_target", "id" => "mid_target","maxlength" => "500", "label" => "", "type" => "text", "required" => True, "autocomplete"=> "off")); ?></td>'  +
               '</tr>');
        counter++;
    });
	
	$(".minusbtn").click(function(){
		var cnt=0;
		var delArr=[];
		var r = confirm("Are you sure want to delete KRA?");
		if (r==true) {
            $("table#TextBoxesGroup.main tbody").find('input[name="record"]').each(function(i){
            	if($(this).is(":checked")){
					if ($("table#TextBoxesGroup.main tr").length != 3) {
										if(!isNaN(parseInt($.trim($(this).closest("tr").find("input#updateEmpKraTargetId").val())))){
											delArr[i] = parseInt($.trim($(this).closest("tr").find("input#updateEmpKraTargetId").val()));
										}
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
		/* if(!$.isEmptyObject(delArr)){
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
		
		}
		 */	//alert(delArr.toString());
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

    $(document).on('change', '#weightage', function () {
        if (Number($(this).val()) === 0) {
            $(this).val('');
            alert('Number must be greater than 0');
        } else if (Number($(this).val()) > 100) {
            $(this).val('');
            alert('Number must be less than 100');
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

    function setNumberValidation(this1,this2)
    {
	if(this1!=3){
                $(this2).closest("tr").find("textarea#qualifying").remove();
                $(this2).closest("tr").find(".qualifying .input.text").html( '<input name="data[addKraTarget][qualifying][]" class="uk-width-medium-1-1 qualifying" id="qualifying" maxlength="500" required="required" autocomplete="off" data-parsley-id="17" type="text">');
                $(this2).closest("tr").find("input#qualifying").val('');
				$(this2).closest("tr").find("input#qualifying").attr('onkeyup','return isNumber(this);');                                  
				$(this2).closest("tr").find("input#qualifying").attr('onkeypress','return isNumberKey(event,this);');
                
				$(this2).closest("tr").find("textarea#target").remove();
                $(this2).closest("tr").find(".target .input.text").html( '<input name="data[addKraTarget][target][]" class="uk-width-medium-1-1 target" id="target" maxlength="500" required="required" autocomplete="off" data-parsley-id="17" type="text">');
                $(this2).closest("tr").find("input#target").val('');
				$(this2).closest("tr").find("input#target").attr('onkeyup','return isNumber(this);');                                      
				$(this2).closest("tr").find("input#target").attr('onkeypress','return isNumberKey(event,this);');
	
				$(this2).closest("tr").find("textarea#stretched").remove();
                $(this2).closest("tr").find(".stretched .input.text").html( '<input name="data[addKraTarget][stretched][]" class="uk-width-medium-1-1 stretched" id="stretched" maxlength="500" required="required" autocomplete="off" data-parsley-id="17" type="text">');
                $(this2).closest("tr").find("input#stretched").val('');
				$(this2).closest("tr").find("input#stretched").attr('onkeyup','return isNumber(this);');                                  
				$(this2).closest("tr").find("input#stretched").attr('onkeypress','return isNumberKey(event,this);');	
				
				$(this2).closest("tr").find("textarea#mid_target").remove();
                $(this2).closest("tr").find(".mid_target .input.text").html( '<input name="data[addKraTarget][mid_target][]" class="uk-width-medium-1-1 mid_target" id="mid_target" maxlength="500" required="required" autocomplete="off" data-parsley-id="17" type="text">');
                $(this2).closest("tr").find("input#mid_target").val('');
				$(this2).closest("tr").find("input#mid_target").attr('onkeyup','return isNumber(this);');                                  
				$(this2).closest("tr").find("input#mid_target").attr('onkeypress','return isNumberKey(event,this);');					
	}else{
                $(this2).closest("tr").find("input#qualifying").remove();
                $(this2).closest("tr").find(".qualifying .input.text").html( '<textarea name="data[addKraTarget][qualifying][]" class="uk-width-medium-1-1 textarea_expand" maxlength="2000" required="required" cols="30" rows="6" id="qualifying" data-parsley-id="4"></textarea>');
                $(this2).closest("tr").find("textarea#qualifying").val('');
                			
				$(this2).closest("tr").find("input#target").remove();
                $(this2).closest("tr").find(".target .input.text").html( '<textarea name="data[addKraTarget][target][]" class="uk-width-medium-1-1 textarea_expand" maxlength="2000" required="required" cols="30" rows="6" id="target" data-parsley-id="4"></textarea>');
                $(this2).closest("tr").find("textarea#target").val('');

				$(this2).closest("tr").find("input#stretched").remove();
                $(this2).closest("tr").find(".stretched .input.text").html( '<textarea name="data[addKraTarget][stretched][]" class="uk-width-medium-1-1 textarea_expand" maxlength="2000" required="required" cols="30" rows="6" id="stretched" data-parsley-id="4"></textarea>');
                $(this2).closest("tr").find("textarea#stretched").val('');
				
				$(this2).closest("tr").find("input#mid_target").remove();
                $(this2).closest("tr").find(".mid_target .input.text").html( '<textarea name="data[addKraTarget][mid_target][]" class="uk-width-medium-1-1 textarea_expand" maxlength="2000" required="required" cols="30" rows="6" id="mid_target" data-parsley-id="4"></textarea>');
                $(this2).closest("tr").find("textarea#mid_target").val('');
	}
    }

    function confirmAction() {       
        
        var calculated_total_sum = 0; 
		var error = [];
		var error1 = [];	
		
		$("input.kra_upload").each(function (i) {
            $(this).removeAttr('name').attr("name","data[addKraTarget][kra_upload_"+(i+1)+"]");
        });
			

		$("td.measure_type").each(function (i) {
			$(this).find("input.measure_type").each(function (){
				$(this).removeAttr('name').attr("name","data[addKraTarget][measure_type_"+(i+1)+"]");
			});
        });
		
		
		$("input.kra_upload").each(function (i) {
			if($('[name="data[addKraTarget][kra_upload_'+(i+1)+']"]').val()!=''){
				var file_size = $('[name="data[addKraTarget][kra_upload_'+(i+1)+']"]')[0].files[0].size;
				var file_name = $('[name="data[addKraTarget][kra_upload_'+(i+1)+']"]')[0].files[0].name;
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
				if ($.inArray($('[name="data[addKraTarget][kra_upload_'+(i+1)+']"]').val().split('.').pop().toLowerCase(), fileExtension) == -1) {
					alert("In row no. "+(i+1)+", file extension is invalid. Please use only : "+fileExtension.join(', '));
					error1[i]=2;
					return false;
				}
			}
		});

		if($.inArray(2,error1) != -1){	
			return false;
		}		
	
		
	$("td.stretched").each(function (i) {
            var get_textbox_value = $(this).closest("tr").find(".input.text #stretched").val();

		if($(this).closest("tr").find(".measure_type:checked").val()==1 && parseFloat(get_textbox_value) < parseFloat($(this).closest("tr").find("input#target").val())){

			alert("In row no. "+(i+1)+", if your measure type is 'Higher the Better', then 'Stretched' cannot be less than 'Target'. Please input correct value.");
			error[i]=2;
			return false;
			

		} else if($(this).closest("tr").find(".measure_type:checked").val()==2 && parseFloat(get_textbox_value) > parseFloat($(this).closest("tr").find("input#target").val())){

			alert("In row no. "+(i+1)+", if your measure type is 'Lower the Better', then 'Stretched' cannot be greater than 'Target'. Please input correct value.");
			error[i]=2;
			return false;
		}
            
        });
		
		if($.inArray(2,error) != -1){	
		return false;
		}
	
	 /* $("td.mid_target").each(function (i) {
            var get_textbox_value = $(this).closest("tr").find(".input.text #mid_target").val();

			if(parseFloat(get_textbox_value) > parseFloat($(this).closest("tr").find("input#target").val())){

				alert("In row no. "+(i+1)+", Your 'Mid Year Target' value should not be greater than 'Annual Year Target'. Please input correct value.");
				error1[i]=2;
				return false;
			}
            
        }); */

		
		$(".weightage").each(function () {
            var get_textbox_value = $(this).val();
            if ($.isNumeric(get_textbox_value)) {
                calculated_total_sum += parseFloat(get_textbox_value);
            }
        });	

        if(calculated_total_sum !== 100){
            alert("Weightage sum must be 100 %. !!!");
            return false;
        }else{
            return true;
        }

        $("#total_sum_value").html(calculated_total_sum);       
	
    }
    
    $(function(){
        $("textarea").keyup(function(e){
             $(this).val($(this).val().replace(/^\s/g, ""));
        });
    });
 $(document).ready(function () {
		$('#saveasdraft').click(function (){
			var error1 = [];
			$('#form_validation input[type=text],#form_validation textarea,#form_validation input[type=radio], #form_validation select').each(function() {
						$(this).removeAttr('required');
			});
		var error = [];
		var error1 = [];	
		
		$("input.kra_upload").each(function (i) {
            $(this).removeAttr('name').attr("name","data[addKraTarget][kra_upload_"+(i+1)+"]");
        });
			

		$("td.measure_type").each(function (i) {
			$(this).find("input.measure_type").each(function (){
				$(this).removeAttr('name').attr("name","data[addKraTarget][measure_type_"+(i+1)+"]");
			});
        });
		
		
		$("input.kra_upload").each(function (i) {
			if($('[name="data[addKraTarget][kra_upload_'+(i+1)+']"]').val()!=''){
				var file_size = $('[name="data[addKraTarget][kra_upload_'+(i+1)+']"]')[0].files[0].size;
				var file_name = $('[name="data[addKraTarget][kra_upload_'+(i+1)+']"]')[0].files[0].name;
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
				if ($.inArray($('[name="data[addKraTarget][kra_upload_'+(i+1)+']"]').val().split('.').pop().toLowerCase(), fileExtension) == -1) {
					alert("In row no. "+(i+1)+", file extension is invalid. Please use only : "+fileExtension.join(', '));
					error1[i]=2;
					return false;
				}
			}
		});

		if($.inArray(2,error1) != -1){	
			return false;
		}		
			var cnt=0;
		
	var names=document.getElementsByName('data[addKraTarget][kra_name][]');
		 
	if($.trim(names[0].value) == ''){	
			alert("There must be atleast one record to submit and starting from first row.");
			return false;
		}
		$('<input />').attr('type', 'hidden')
              .attr('name', 'saveasdraft')
              .attr('value', 'saveasdraft')
              .appendTo('#form_validation');
		
		$('#ww').trigger('click');
		
		});
		
       
    });

</script>
