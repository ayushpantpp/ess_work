<script type="text/javascript">
    function checkDate(){
    
    var bring_date = $('#bring_date').val();
    var hearing_date = $('#mention_date').val();
    var judgment_date = $('#next_h_date').val();
    var decision_date = $('#decision_date').val();
    
    
   var error1 = [];
   $("input.upl_doc").each(function (i) {
			if($(this).val()!=''){
                            //alert($(this).val());
				var file_size = $(this)[0].files[0].size;
				//alert(file_size);
				if(file_size>15728640) {
					alert("In file no. "+(i+1)+", file size is heavy. Please upload less than 15MB.");
					error1[i]=2;
					return false;
				}

				var fileExtension = ['jpeg', 'jpg', 'png', 'gif', 'bmp', 'doc','docx','ppt','pptx','xls','xlsx', 'txt', 'pdf', 'xml', 'ods'];
				if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
					alert("In file no. "+(i+1)+", file extension is invalid. Please use only : "+fileExtension.join(', '));
					error1[i]=2;
					return false;
				}
			}
		});

		if($.inArray(2,error1) != -1){	
			return false;
		}
   
    
 if(bring_date!='' && hearing_date!=''){ 
        var date11 = Date.parse(bring_date);
        var date22 = Date.parse(hearing_date);

        if (date11 > date22) {
            alert ("Bring up Date should be less than Mention/Hearing Date !!");
            return false;
        }
   }
   
   if(bring_date!='' && decision_date!=''){ 
        var date111 = Date.parse(bring_date);
        var date222 = Date.parse(decision_date);

        if (date111 > date222) {
            alert("Bring up Date should be less than Decision Date !!");
            return false;
        }
   }
   
   if(bring_date!='' && hearing_date!='' && judgment_date!=''){ 
        var date11 = Date.parse(bring_date);
        var date22 = Date.parse(hearing_date);
        var date33 = Date.parse(judgment_date);

        if ((date11 > date22) || (date11 > date33)) {
            alert ("Bring up Date should be less than Mention/Hearing and Judgment Date !!");
            return false;
        }
        
        if (date22 > date33) {
            alert ("Judgment Date can not be less than Mention/Hearing Date !!");
            return false;
        }
   }
   
   if(judgment_date!='' && decision_date!=''){ 
        var date11 = Date.parse(judgment_date);
        var date22 = Date.parse(decision_date);

        if (date11 > date22) {
            alert ("Decision Date should be greater than Judgment Date !!");
            return false;
        }
   }
   
   
   
}
		
	
</script>

<div id="page_content">
    <div id="page_heading" data-uk-sticky="{ top: 48, media: 960 }">
            <h1>Enter Case Details</h1>
    </div>
    <div id="page_content_inner">
        <?php echo $flash = $this->Session->flash(); ?> 
        <?php
//        echo "<pre>";
//        print_r($CaseDetails);
//        ?>
       <div class="md-card">  
            <div class="md-card-content large-padding">
               
                <?php echo $this->Form->create('doc', array('url' =>array('controller' => 'LegalManagement', 'action' =>'case_details_update'),'type' => 'file','id'=>'form_validation','class' => 'uk-form-stacked' )); 
                echo $this->form->input('caseid', array('type' => "hidden",'value'=>$CaseDetails['CaseReceive']['id'])); 
                echo $this->form->input('caseDetailId', array('type' => "hidden",'value'=>$CaseDetails['CaseDetails']['id'])); 
                ?>
                <h3 class="heading_a">Case Details</h3>
                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-1-3">
                        <div class="parsley-row">
                            <label for="resp">Case Number <span class="req">*</span></label>
                            <?php 
                            echo $this->form->input('case_num', array('type'=>'text','label'=>false,'disabled'=>'disabled','value'=>$CaseDetails['CaseReceive']['court_case_number'],'class'=>"md-input"));
                            echo $this->form->input('case_num', array('type'=>'hidden','label'=>false,'required'=>true,'value'=>$CaseDetails['CaseReceive']['court_case_number'],'class'=>"md-input"));
                            ?>                
                        </div>
                    </div>
                    <div class="uk-width-medium-1-3">
                        <div class="parsley-row">
                            <label for="resp">PSC File Number <span class="req">*</span></label>
                            <?php echo $this->form->input('psc_num', array('type'=>'text','label'=>false,'required'=>true,'disabled'=>'disabled','value'=>$CaseDetails['CaseReceive']['psc_file_number'],'class'=>"md-input")); ?>                
                        </div>
                    </div>
                    <div class="uk-width-medium-1-3" >
                            <div class="parsley-row">
                                <label for="case_type" class="md-input label-fixed">Case Type<span class="req">*</span></label>
                                <select name="case_type" required="required" class="md-input data-md-selectize">
                                    <?php
                                    
                                    foreach($CaseType as $rt){
                                        if($CaseDetails['CaseDetails']['case_type_id']==$rt['CaseType']['id']){
                                        echo "<option value='".$rt['CaseType']['id']."' selected='selected'>".$rt['CaseType']['casetype']."</option>";
                                        }
//                                        else{
//                                         echo "<option value='".$rt['CaseType']['id']."'>".$rt['CaseType']['casetype']."</option>";   
//                                        }
                                }
                                    ?>
                                </select>
                                  
                             </div>
                       </div>
                        <div class="uk-width-medium-1-2">
                        <div class="parsley-row">
                            <label for="subject">Subject</label>
                            <?php echo $this->form->textarea('subject', array('label'=>false,'value'=>$CaseDetails['CaseDetails']['subject'],'class'=>"md-input")); ?>                
                        </div>
                    </div>
                        <div class="uk-width-medium-1-2">
                        <div class="parsley-row">
                            <label for="case_particular">Case Particulars </label>
                            <?php echo $this->form->textarea('case_particular', array('label'=>false,'value'=>$CaseDetails['CaseDetails']['case_particulars'],'class'=>"md-input")); ?>                
                        </div>
                    </div>
                    <div class="uk-width-medium-1-3">
                        <div class="parsley-row">
                            <label for="petitioner">Petitioner(s) <span class="req">*</span></label>
                            <?php echo $this->form->textarea('petitioner', array('label'=>false,'required'=>true,'value'=>$CaseDetails['CaseDetails']['case_petitioners'],'class'=>"md-input")); ?>                
                        </div>
                    </div>
                    
                    <div class="uk-width-medium-1-3">
                        <div class="parsley-row">
                            <label for="respondent">Respondent(s) <span class="req">*</span></label>
                            <?php echo $this->form->textarea('respondent', array('label'=>false,'required'=>true,'value'=>$CaseDetails['CaseDetails']['case_respondents'],'class'=>"md-input")); ?>                
                        </div>
                    </div>
                    
                    <div class="uk-width-medium-1-3">
                        <div class="parsley-row">
                            <label for="witness">Witness(es) </label>
                            <?php echo $this->form->textarea('witness', array('label'=>false,'value'=>$CaseDetails['CaseDetails']['case_witness'],'class'=>"md-input")); ?>                
                        </div>
                    </div>
                    <div class="uk-width-medium-1-3">
                            <div class="parsley-row">
                                <label for="minstry" class="md-input label-fixed">Ministry/State Dept <span class="req">*</span></label>
                                <?php 
                                echo $this->form->input('minstry', array('type' => "text",'label'=>false,'disabled'=>'disabled','required'=>true,'value'=>$CaseReceive['Ministry']['ministry_name']." [".$CaseReceive['Ministry']['ministry_code']."]",'class' => "md-input")); 
                                ?>
                        </div>
                       </div>
                
                    <div class="uk-width-medium-1-3">
                            <div class="parsley-row">
                                <label for="court_type" class="md-input label-fixed">Court Type <span class="req">*</span></label>
                                <select name="court_type" required="required" class="md-input data-md-selectize ">
                                    <option value=" ">-- SELECT --</option>
                                    <?php
                                    foreach($CourtType as $rt){
                                        if($CaseDetails['CaseDetails']['court_type_id']==$rt['CourtType']['id']){
                                          echo "<option value='".$rt['CourtType']['id']."' selected='selected'>".$rt['CourtType']['courttype']."</option>";  
                                        }else{
                                          echo "<option value='".$rt['CourtType']['id']."'>".$rt['CourtType']['courttype']."</option>";  
                                        }
                                        
                                }
                                    ?>
                                </select>
                            </div>
                    </div>
                    <div class="uk-width-medium-1-3">
                            <div class="parsley-row">
                                <label for="court_location" class="md-input label-fixed">Court Location <span class="req">*</span></label>
                                <select name="court_location" required="required" class="md-input data-md-selectize ">
                                    <option value=" ">-- SELECT --</option>
                                    <?php
                                    foreach($CourtLocation as $rt){
                                        if($CaseDetails['CaseDetails']['court_location_id']==$rt['CaseCourtLocation']['id']){
                                            echo "<option value='".$rt['CaseCourtLocation']['id']."' selected='selected'>".$rt['CaseCourtLocation']['court_location']."</option>";
                                        }else{
                                            echo "<option value='".$rt['CaseCourtLocation']['id']."'>".$rt['CaseCourtLocation']['court_location']."</option>";
                                        }
                                        
                                }
                                    ?>
                                </select>
                            </div>
                    </div>
                    <div class="uk-grid" data-uk-grid-margin></div>
                    <div class="uk-width-medium-1-3">
                            <div class="parsley-row">
                                <label for="bring_date" class="md-input label-fixed">Bring Up Date <span class="req">*</span></label>
                                <?php 
//                                $Bringup_date = date("Y-m-d", strtotime($CaseDetails['CaseDetails']['bringup_date']));
//                                echo $this->form->input('bring_date', array('type' => "text",'label'=>false,'required'=>true,'data-uk-datepicker'=>'{format:"YYYY-MM-DD"}','value'=>$Bringup_date, 'class' => "md-input")); 
                                ?>
                                
                                <?php 
                                $curDate = date('Y-m-d');
                                $Bringup_date = date("Y-m-d", strtotime($CaseDetails['CaseDetails']['bringup_date']));
                                echo $this->form->input('bring_date', array('type' => "text",'id'=>'bring_date','readonly'=>true,'label'=>false,'required'=>true,'data-uk-datepicker'=>'{format:"YYYY-MM-DD",minDate:"'.$curDate.'"}','value'=>$Bringup_date, 'class' => "md-input")); 
                                ?>
                                
                                <span class="md-input-bar"></span>
                        </div>
                    </div>
                    <div class="uk-grid" data-uk-grid-margin></div>
                    <div class="uk-width-medium-1-3">
                            <div class="parsley-row">
                                <label for="mention_date" class="md-input label-fixed">Mention/Hearing Date  </label>
                                <?php 
                                if($CaseDetails['CaseDetails']['mention_date'] != ''){
                                    $Mention_date = date("Y-m-d", strtotime($CaseDetails['CaseDetails']['mention_date']));
                                }
                                
                                //echo $this->form->input('mention_date', array('type' => "text",'label'=>false,'data-uk-datepicker'=>'{format:"YYYY-MM-DD",minDate:"'.date('Y-m-d').'"}','value'=>$Mention_date, 'class' => "md-input")); 
                                ?>
                                
                                <?php 
                                echo $this->form->input('mention_date', array('type' => "text",'label'=>false,'readonly'=>true,'id'=>'mention_date','data-uk-datepicker'=>'{format:"YYYY-MM-DD",minDate:"'.date('Y-m-d').'"}', 'value'=>$Mention_date, 'class' => "md-input")); 
                                ?>
                                <span class="md-input-bar"></span>
                        </div>
                    </div>
                    <div class="uk-grid" data-uk-grid-margin></div>
                    <div class="uk-width-medium-1-3">
                            <div class="parsley-row ">
                                <label for="next_h_date" class="md-input label-fixed">Ruling/Judgement Date </label>
                                <?php
                                if($CaseDetails['CaseDetails']['next_hearing_date']!=''){
                                  $next_h_date = date("Y-m-d", strtotime($CaseDetails['CaseDetails']['next_hearing_date']));  
                                }
                                
                                //echo $this->form->input('next_h_date', array('type' => "text",'label'=>false,'data-uk-datepicker'=>'{format:"YYYY-MM-DD",minDate:"'.date('Y-m-d').'"}','value'=>$next_h_date, 'class' => "md-input ")); 
                                ?>
                                
                                <?php
                                echo $this->form->input('next_h_date', array('type' => "text",'id'=>'next_h_date','readonly'=>true,'label'=>false,'data-uk-datepicker'=>'{format:"YYYY-MM-DD",minDate:"'.date('Y-m-d').'"}', 'value'=>$next_h_date,'class' => "md-input ")); 
                                ?>
                                <span class="md-input-bar"></span>
                        </div>
                    </div>
                    <div class="uk-width-medium-1-3">
                            <div class="parsley-row">
                                <label for="case_status" class="md-input label-fixed">Case Status <span class="req">*</span></label>
                                <select name="case_status" required="required" class="md-input data-md-selectize ">
                                    <option value=" ">-- SELECT --</option>
                                    <?php
                                    foreach($CaseStatus as $rt){
                                        if($CaseDetails['CaseDetails']['case_status_id']==$rt['CaseStatus']['id']){
                                            echo "<option value='".$rt['CaseStatus']['id']."' selected='selected'>".$rt['CaseStatus']['case_status']."</option>";
                                        }else{
                                            echo "<option value='".$rt['CaseStatus']['id']."'>".$rt['CaseStatus']['case_status']."</option>";
                                        }
                                    
                                }
                                    ?>
                                </select>
                            </div>
                        </div>    
                       
                    <div class="uk-width-medium-1-3">
                        <div class="parsley-row">
                            <label for="status_details">Case Status Details </label>
                            <?php echo $this->form->textarea('status_details', array('label'=>false,'value'=>$CaseDetails['CaseDetails']['case_status_details'],'class'=>"md-input")); ?>                
                        </div>
                    </div>
                    <div class="uk-width-medium-1-3">
                            <div class="parsley-row">
                                <label for="case_outcome" class="md-input label-fixed">Case Outcome </label>
                                <select name="case_outcome" class="md-input data-md-selectize ">
                                    <option value=" ">-- SELECT --</option>
                                    <?php
                                    foreach($CaseOutcome as $rt){
                                     if($CaseDetails['CaseDetails']['case_outcome_id']==$rt['CaseOutcome']['id']){
                                         echo "<option value='".$rt['CaseOutcome']['id']."' selected='selected'>".$rt['CaseOutcome']['case_outcome']."</option>";  
                                     }else{
                                       echo "<option value='".$rt['CaseOutcome']['id']."'>".$rt['CaseOutcome']['case_outcome']."</option>";  
                                     }   
                                }
                                    ?>
                                </select>
                            </div>
                    </div>
                    
                    <div class="uk-width-medium-1-3">
                        <div class="parsley-row">
                            <label for="outcome_details">Case Outcome Details </label>
                            <?php echo $this->form->textarea('outcome_details', array('label'=>false,'value'=>$CaseDetails['CaseDetails']['case_outcome_details'],'class'=>"md-input")); ?>                
                        </div>
                    </div>
                    <div class="uk-width-medium-1-3">
                        <div class="parsley-row">
                            <label for="remark">Remark/Comments </label>
                            <?php echo $this->form->textarea('remark', array('label'=>false,'value'=>$CaseDetails['CaseDetails']['remark'],'class'=>"md-input")); ?>                
                        </div>
                    </div>
                    <div class="uk-width-medium-1-3">
                            <div class="parsley-row">
                                <label for="dos" class="md-input label-fixed">Decision Date </label>
                                <?php
                                if($CaseDetails['CaseDetails']['decision_date']!=''){
                                  $Decision_date = date("Y-m-d", strtotime($CaseDetails['CaseDetails']['decision_date']));
                                }
                                
                                //echo $this->form->input('decision_date', array('type' => "text",'label'=>false,'data-uk-datepicker'=>'{format:"DD-MM-YYYY"}','value'=>$Decision_date, 'class' => "md-input")); 
                                ?>
                                <?php 
                                echo $this->form->input('decision_date', array('type' => "text",'id'=>'decision_date','label'=>false,'readonly'=>true,'data-uk-datepicker'=>'{format:"YYYY-MM-DD",minDate:"'.date('Y-m-d').'"}','value'=>$Decision_date, 'class' => "md-input")); 
                                ?>
                                <span class="md-input-bar"></span>
                        </div>
                    </div>
                </div> 
            <div class="uk-grid"  data-uk-grid-margin>
            
                
                
                <?php 
                foreach($CaseDetails['CaseFiles'] as $recc){?>
                    <div class="uk-width-medium-1-2" >
                    <?php
                  echo $recc['file_name'];?>
                </div>
                <div class="uk-width-medium-1-2" >
                <a class="md-btn md-btn-danger" href="<?php echo $this->Html->url('case_details_file_remove/'.$recc['id'].'/'.base64_encode($CaseDetails['CaseDetails']['id'])) ?>">Remove</a>                       
                </div>
                      <?php
                }
                ?>
                
            </div> 
            <div class="uk-grid" data-uk-grid-margin>
                <font color="red" size="1">**File size should be less than 15MB.</font>
            </div>
            <div class="uk-grid" id='TextBoxesGroup' data-uk-grid-margin>
            <div class="uk-width-medium-1-2" >
                <label for="cc_num"  >Select File To Upload: <span class="req"><sup></sup>&nbsp;</span></label>
                <div class=" md-btn md-btn-primary">
                        <?php 
                        echo $this->form->input('upl_doc.', array('type'=>'file','id'=>'first_upload','class'=>'upl_doc','label'=>false)); 
                        ?>
                </div>
            </div>
            </div>  
            
            <div class="uk-grid" data-uk-grid-margin></div>
            <div class="uk-width-1-1">                        
                <input type='button' class="md-btn md-btn-primary"  value='Add More' id='addButton'>
                <input type='button' class="md-btn md-btn-danger" value='Remove' id='removeButton'>         
            </div>
                
                <div class="uk-grid" data-uk-grid-margin></div>
                <div class="uk-grid">
                    <div class="uk-width-1-3 uk-margin-top">                            
                        <button type="submit" name="submit" value="submit" onclick="return checkDate();" class="md-btn md-btn-success" href="#">Save</button>                    
                    </div>
                    <div class="uk-width-1-3 uk-margin-top">                            
                        <a class="md-btn md-btn-primary" href="<?php echo $this->Html->url('case_details/'.base64_encode($CaseDetails['CaseReceive']['id'])); ?>">Cancel</a>                       
                    </div>
                </div>
        
                <?php echo $this->Form->end();?>
            </div>
           </div>
   </div>
</div>
<script src="<?php echo $this->webroot;?>js/jquery.min.js"></script>
<script src="<?php echo $this->webroot;?>js/jquery-ui.min.js"></script>
<script type="text/javascript">
 
$(document).ready(function(){
 
    var counter = 2;
 
    $("#addButton").click(function () {
 
    if(counter>10){
            alert("Only 10 files can upload at a time");
            return false;
    }
 
    var newTextBoxDiv = $(document.createElement('div'))
         .attr({id:'TextBoxDiv' + counter,class:"uk-width-medium-1-1 margin-bottom"});
 
    newTextBoxDiv.after().html('<br><label for="upl_doc">Select File To Upload: <span class="req"><sup>*</sup>&nbsp;</span></label>'+
                            '<div class="parsley-row  md-btn md-btn-primary">'+
                                '<?php echo $this->form->input('upl_doc.', array('type'=>'file','label'=>false,'required'=>true)); ?>'+
                        '</div>');
 
    newTextBoxDiv.appendTo("#TextBoxesGroup");
    $('#first_upload').attr('required',true);
 
 
    counter++;
     });
 
     $("#removeButton").click(function () {
         if (counter == 3) {
                $('#first_upload').attr('required',false);
            }
    if(counter==1){
          alert("You can't delete default upload field !");
          return false;
       }
    counter--;
        $("#TextBoxDiv" + counter).remove();
     });    
  });
</script>
