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
        <div class="md-card">  
            <div class="md-card-content large-padding">

                <?php echo $this->Form->create('doc', array('url' =>array('controller' => 'LegalManagement', 'action' =>'case_details_save'),'type' => 'file','id'=>'form_validation','class' => 'uk-form-stacked' )); 
                echo $this->form->input('caseid', array('type' => "hidden",'value'=>$CaseReceive['CaseReceive']['id'])); 
                ?>
                <h3 class="heading_a">Case Details</h3>
                <div class="uk-grid" data-uk-grid-margin>
                    <?php 
//                    echo "<pre>";
//                    print_r($CaseReceive);die;
                    ?>
                    <div class="uk-width-medium-1-3">
                        <div class="parsley-row">
                            <label for="resp">Case Number <span class="req">*</span></label>
                            <?php 
                            echo $this->form->input('case_num', array('type'=>'text','label'=>false,'disabled'=>'disabled','value'=>$CaseReceive['CaseReceive']['court_case_number'],'class'=>"md-input"));
                            echo $this->form->input('case_num', array('type'=>'hidden','label'=>false,'required'=>true,'value'=>$CaseReceive['CaseReceive']['court_case_number'],'class'=>"md-input"));
                            ?>                
                        </div>
                    </div>
                    <div class="uk-width-medium-1-3">
                        <div class="parsley-row">
                            <label for="resp">PSC File Number <span class="req">*</span></label>
                            <?php echo $this->form->input('psc_num', array('type'=>'text','label'=>false,'required'=>true,'disabled'=>'disabled','value'=>$CaseReceive['CaseReceive']['psc_file_number'],'class'=>"md-input")); ?>                
                        </div>
                    </div>
                    <div class="uk-width-medium-1-3" >
                        <div class="parsley-row">
                            <label for="case_type" class="md-input label-fixed">Case Type <span class="req">*</span></label>
                            
                            <?php 
                            echo $this->form->input('casetype', array('type'=>'text','label'=>false,'required'=>true,'disabled'=>'disabled','value'=>$CaseReceive['CaseType']['casetype'],'class'=>"md-input"));
                            echo $this->form->input('case_type', array('type'=>'hidden','label'=>false,'required'=>true,'value'=>$CaseReceive['CaseType']['id'],'class'=>"md-input"));
                            ?>                

                        </div>
                    </div>
                    <div class="uk-width-medium-1-2">
                        <div class="parsley-row">
                            <label for="subject">Subject</label>
                            <?php echo $this->form->textarea('subject', array('label'=>false,'class'=>"md-input", 'value'=>$CaseReceive['CaseReceive']['subject'])); ?>                
                        </div>
                    </div>
                    <div class="uk-width-medium-1-2">
                        <div class="parsley-row">
                            <label for="case_particular">Case Particulars </label>
                            <?php echo $this->form->textarea('case_particular', array('label'=>false,'class'=>"md-input")); ?>                
                        </div>
                    </div>
                    <div class="uk-width-medium-1-3">
                        <div class="parsley-row">
                            <label for="petitioner">Petitioner(s) <span class="req">*</span></label>
                            <?php echo $this->form->textarea('petitioner', array('label'=>false,'required'=>true,'value'=>$CaseReceive['CaseReceive']['petitioners'],'class'=>"md-input")); ?>                
                        </div>
                    </div>

                    <div class="uk-width-medium-1-3">
                        <div class="parsley-row">
                            <label for="respondent">Respondent(s) <span class="req">*</span></label>
                            <?php echo $this->form->textarea('respondent', array('label'=>false,'required'=>true,'value'=>$CaseReceive['CaseReceive']['respondents'],'class'=>"md-input")); ?>                
                        </div>
                    </div>

                    <div class="uk-width-medium-1-3">
                        <div class="parsley-row">
                            <label for="witness">Witness(es) </label>
                            <?php echo $this->form->textarea('witness', array('label'=>false,'class'=>"md-input")); ?>                
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
                                        echo "<option value='".$rt['CourtType']['id']."'>".$rt['CourtType']['courttype']."</option>";
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
                                        echo "<option value='".$rt['CaseCourtLocation']['id']."'>".$rt['CaseCourtLocation']['court_location']."</option>";
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
                                $curDate = date('Y-m-d');
                                echo $this->form->input('bring_date', array('type' => "text",'id'=>'bring_date','label'=>false,'required'=>true,'readonly'=>true,'data-uk-datepicker'=>'{format:"YYYY-MM-DD",minDate:"'.$curDate.'"}', 'class' => "md-input")); 
                                ?>
                            <span class="md-input-bar"></span>
                        </div>
                    </div>
                    <div class="uk-grid" data-uk-grid-margin></div>
                    <div class="uk-width-medium-1-3">
                        <div class="parsley-row">
                            <label for="mention_date" class="md-input label-fixed">Mention/Hearing Date </label>
                                <?php 
                                echo $this->form->input('mention_date', array('type' => "text",'label'=>false,'id'=>'mention_date','readonly'=>true,'data-uk-datepicker'=>'{format:"YYYY-MM-DD",minDate:"'.date('Y-m-d').'"}', 'class' => "md-input")); 
                                ?>
                            <span class="md-input-bar"></span>
                        </div>
                    </div>
                    <div class="uk-grid" data-uk-grid-margin></div>
                    <div class="uk-width-medium-1-3">
                        <div class="parsley-row ">
                            <label for="next_h_date" class="md-input label-fixed">Ruling/Judgement Date </label>
                                <?php
                                echo $this->form->input('next_h_date', array('type' => "text",'id'=>'next_h_date','label'=>false,'readonly'=>true,'data-uk-datepicker'=>'{format:"YYYY-MM-DD",minDate:"'.date('Y-m-d').'"}', 'class' => "md-input ")); 
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
                                    echo "<option value='".$rt['CaseStatus']['id']."'>".$rt['CaseStatus']['case_status']."</option>";
                                }
                                    ?>
                            </select>
                        </div>
                    </div>    

                    <div class="uk-width-medium-1-3">
                        <div class="parsley-row">
                            <label for="status_details">Case Status Details </label>
                            <?php echo $this->form->textarea('status_details', array('label'=>false,'value'=>$rec['CaseReceive']['respondents'],'class'=>"md-input")); ?>                
                        </div>
                    </div>
                    <div class="uk-width-medium-1-3">
                        <div class="parsley-row">
                                <?php //echo $this->form->input('task_id', array('label' => "Task List", 'type' => "select",'empty' => ' -- Select Task --', 'options' => $CaseOutcome, 'class' => "md-input",'id' => 'task_id','data-md-selectize')); ?>
                            <label for="case_outcome" class="md-input label-fixed">Case Outcome </label>
                            <select name="case_outcome" class="md-input data-md-selectize ">

                                    <?php
                                    $list = "<option value=' '>--Select--</option>";
                                    foreach($CaseOutcome as $rt){
                                        $list .= "<option value='".$rt['CaseOutcome']['id']."'>".$rt['CaseOutcome']['case_outcome']."</option>";
                                }
                                    echo $list;
                                    ?>
                            </select>
                        </div>
                    </div>

                    <div class="uk-width-medium-1-3">
                        <div class="parsley-row">
                            <label for="outcome_details">Case Outcome Details </label>
                            <?php echo $this->form->textarea('outcome_details', array('label'=>false,'value'=>$rec['CaseReceive']['respondents'],'class'=>"md-input")); ?>                
                        </div>
                    </div>
                    <div class="uk-width-medium-1-3">
                        <div class="parsley-row">
                            <label for="remark">Remark/Comments </label>
                            <?php echo $this->form->textarea('remark', array('label'=>false,'value'=>$rec['CaseReceive']['respondents'],'class'=>"md-input")); ?>                
                        </div>
                    </div>
                    <div class="uk-width-medium-1-3">
                        <div class="parsley-row">
                            <label for="dos" class="md-input label-fixed">Decision Date </label>
                                <?php 
                                echo $this->form->input('decision_date', array('type' => "text",'id'=>'decision_date','readonly'=>true,'label'=>false,'data-uk-datepicker'=>'{format:"YYYY-MM-DD",minDate:"'.date('Y-m-d').'"}', 'class' => "md-input")); 
                                ?>
                            <span class="md-input-bar"></span>
                        </div>
                    </div>
                </div> 
                
                <div class="uk-grid" data-uk-grid-margin>
                    <font color="red" size="1">**File size should be less than 15MB.</font>
                </div>
                <div class="uk-grid" id='TextBoxesGroup' data-uk-grid-margin>
                    <div class="uk-width-medium-1-2" >
                        <label for="cc_num"  >Select File To Upload: <span class="req"><sup></sup>&nbsp;</span> </label>
                        <div class=" md-btn md-btn-primary">
                            
                        <?php 
                        echo $this->form->input('upl_doc.', array('type'=>'file', 'id'=>'first_upload', 'class'=>'upl_doc','label'=>false)); 
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
                        <a class="md-btn md-btn-primary" href="<?php echo $this->Html->url('case_details/'.base64_encode($caseID)); ?>">Cancel</a>                       
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

    $(document).ready(function () {

        var counter = 2;

        $("#addButton").click(function () {

            if (counter > 10) {
                alert("Only 10 files can upload at a time");
                return false;
            }

            var newTextBoxDiv = $(document.createElement('div'))
                    .attr({id: 'TextBoxDiv' + counter, class: "uk-width-medium-1-1 margin-bottom"});

            newTextBoxDiv.after().html('<br><label for="upl_doc">Select File To Upload: <span class="req"><sup>*</sup>&nbsp;</span></label>' +
                    '<div class="parsley-row  md-btn md-btn-primary">' +
                    '<?php echo $this->form->input('upl_doc.', array('type'=>'file','label'=>false,'class'=>'upl_doc','required'=>true)); ?>' +
                    '</div>');

            newTextBoxDiv.appendTo("#TextBoxesGroup");
            $('#first_upload').attr('required',true);

            counter++;
        });

        $("#removeButton").click(function () {
            
            if (counter == 3) {
                $('#first_upload').attr('required',false);
            }
            if (counter == 1) {
                alert("You can't delete default upload field !");
                return false;
            }
            counter--;
            $("#TextBoxDiv" + counter).remove();
        });
    });
</script>
