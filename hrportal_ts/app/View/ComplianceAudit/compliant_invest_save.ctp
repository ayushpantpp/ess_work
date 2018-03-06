<script type="text/javascript">
   function require(val){
       
       if(val == '1'){
           $(".requirefield").attr('required', true);
           $(".require").attr('required', false);
           $(".requirefield_lable").show();
           $(".require_lable").hide();
       }else{
           $(".require").attr('required', true);
           $(".requirefield").attr('required', true);
           $(".requirefield_lable").show();
           $(".require_lable").show();
       }
       
   }
    function checkNumber(){ 
       var data = $('#mobile').val();
       var infodata = $('#info_mobile').val();
     
     
     
     var error1 = [];
   $("input.receive_doc").each(function (i) {
			if($(this).val()!=''){
                            //alert($(this).val());
				var file_size = $(this)[0].files[0].size;
				//alert(file_size);
				if(file_size>2048000) {
					alert("File size is heavy. Please upload less than 15MB.");
					error1[i]=2;
					return false;
				}

				var fileExtension = ['jpeg', 'jpg', 'png', 'gif','doc','docx','xls','xlsx', 'txt', 'pdf'];
				if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
					alert("File extension is invalid. Please use only : "+fileExtension.join(', '));
					error1[i]=2;
					return false;
				}
			}
		});

		if($.inArray(2,error1) != -1){	
			return false;
		}
       
    if(data!='' || infodata!=''){
    if ((/^\d{10}$/.test(data)) || (/^\d{10}$/.test(infodata))) {
     return true;
    }else{
     alert("Please enter valid mobile number.");
    return false;   
    }
    }
    
    var compliant_date = $('#doc').val();
    var compl_rec_date = $('#docr').val();
    
   
    
 if(compliant_date!='' && compl_rec_date!=''){ 
        var date11 = Date.parse(compliant_date);
        var date22 = Date.parse(compl_rec_date);

        if (date11 > date22) {
            alert ("Complian Date should be less than Complaint Receiving Date !!");
            return false;
        }
   }
   
}
    
    
</script>
<div id="page_content">
    <div id="page_heading" data-uk-sticky="{ top: 48, media: 960 }">
        <h1>Enter Complaint</h1>
    </div>
    <div id="page_content_inner">
        <?php echo $flash = $this->Session->flash(); ?> 
        <div class="md-card">  
            <div class="md-card-content large-padding">
                <?php
                if (!empty($EditCaseReceive)) {
                    foreach ($EditCaseReceive as $rec)
                        ;
                }
                ?>
                <?php echo $this->Form->create('doc', array('url' => array('controller' => 'ComplianceAudit', 'action' => 'compliant_invest_save'), 'type' => 'file', 'id' => 'form_validation', 'class' => 'uk-form-stacked'));
                ?>
                <h3 class="heading_a">Complaint</h3>
                <div  class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-1-2">
                        <div class="parsley-row">
                            <label for="t_o_org" class="md-input label-fixed">Case No. <span class="req">*</span></label>
                            <?php
                            echo $this->form->input('case_no', array('type' => 'text', 'label' => false, 'required' => true, 'value'=>$SerialNo, 'readonly'=>true,'class' => "md-input"));
                            ?>  
                        </div>
                    </div>
                    <div class="uk-width-medium-1-2">
                        <div class="parsley-row">
                            <label for="t_o_org" class="md-input label-fixed">Complaint Category <span class="req">*</span></label>
                            <select name="comp_category" required="required" onchange="require(this.value);" class="md-input data-md-selectize ">
                                <option value="">-- Select --</option>
                                <option value="1">Anonymous Whistle blower</option>
                                <option value="2">Public Servant</option>
                                <option value="3">Others</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div  class="uk-grid" data-uk-grid-margin></div>
                <div  class="uk-grid" data-uk-grid-margin>
                     <div class="uk-width-medium-1-2" >
                        <div class="parsley-row">
                            <label for="resp" class="md-input label-fixed">Applicable policies, procedures and practices/Guidelines <span class="req fixed requirefield_lable " style="display: none">*</span></label>
                            <?php
                            echo $this->form->textarea('compl_desc', array('type' => 'text', 'label' => false,'maxlength'=>'1000', 'class' => "md-input requirefield"));
                            ?>                
                        </div>
                    </div>
                    <div class="uk-width-medium-1-2">
                        <div class="parsley-row">
                            <label for="dor" class="md-input label-fixed">Type of ID Details <span class="req fixed require_lable " style="display: none">*</span></label>

                            <select name="id_detail_type" readonly="readonly" class="md-input require data-md-selectize">
                                <option value=" ">-- Select --</option>
                                <option value="1">Personal Number</option>
                                <option value="2">ID Number</option>
                                <option value="3">Passport Number</option>
                            </select>
                            <span class="md-input-bar"></span>
                        </div>
                    </div>
                   
                </div>
                <div  class="uk-grid" data-uk-grid-margin></div>
                <div  class="uk-grid" data-uk-grid-margin>
                     <div class="uk-width-medium-1-2" >
                        <div class="parsley-row">
                            <label for="resp" class="md-input label-fixed">ID Details <span class="req fixed require_lable " style="display: none">*</span></label>
                            <?php
                            echo $this->form->input('id_details', array('type' => 'text', 'label' => false,  'class' => "md-input require"));
                            ?>                
                        </div>
                    </div>
                    <div class="uk-width-medium-1-2" >
                        <div class="parsley-row">
                            <label for="resp" class="md-input label-fixed">Complaint Designation <span class="req fixed require_lable " style="display: none">*</span></label>
                            <?php
                            echo $this->form->input('compl_designation', array('type' => 'text', 'label' => false,  'class' => "md-input require"));
                            ?>                
                        </div>
                    </div>
                    
                </div>
                <div  class="uk-grid" data-uk-grid-margin></div>
                
                <div  class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-1-2" >
                        <div class="parsley-row">
                            <label for="resp" class="md-input label-fixed">Mobile number of the complainant<span class="req fixed require_lable " style="display: none">*</span></label>
                            <?php echo $this->form->input('mobile', array('type' => 'text', 'id'=>'mobile','label' => false, 'maxlength'=>'10','onblur'=>'return checkNumber();', 'class' => "md-input require")); ?>               
                        </div>
                    </div>
                    <div class="uk-width-medium-1-2" >
                        <div class="parsley-row">
                            <label for="resp" class="md-input label-fixed">Email Address of Complainant<span class="req fixed require_lable " style="display: none">*</span></label>
                           <?php echo $this->form->input('email', array('type' => 'email', 'label' => false,  'class' => "md-input require")); ?>               
                        </div>
                    </div>
                    
                </div>
                <div  class="uk-grid" data-uk-grid-margin></div>
                <div  class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-1-2" >
                        <div class="parsley-row">
                            <label for="resp" class="md-input label-fixed">Postal Address <span class="req fixed require_lable " style="display: none">*</span></label>
                            <?php echo $this->form->input('postal_add', array('type' => 'text', 'id' => 'emplmnt_number', 'label' => false, 'class' => "md-input require")); ?>               
                        </div>
                    </div>
                    <div class="uk-width-medium-1-2" >
                        <div class="parsley-row">
                            <label for="resp" class="md-input label-fixed">Complaint Type <span class="req fixed require_lable " style="display: none">*</span></label>
                           <select name="comp_type" class="md-input require data-md-selectize ">
                                <option value=" ">-- Select --</option>
                                <option value="1">Terms and Service</option>
                                <option value="2">Corrupt/Ethical Conduct</option>
                                <option value="3">Favoritism/Unfairness</option>
                                <option value="4">Workplace Discrimination</option>
                                <option value="5">Work Place Bullying</option>
                                <option value="6">Occupational Health and Safety</option>
                                <option value="7">Workloads</option>
                                <option value="8">Public Interest Disclosure</option>
                                <option value="9">Others</option>
                            </select>
                        </div>
                    </div>
                    
                </div>
                <div  class="uk-grid" data-uk-grid-margin></div>
                <div class="uk-grid" data-uk-grid-margin > 
                    <div class="uk-width-medium-1-2">
                        <div class="parsley-row">
                            <label for="dor" class="md-input label-fixed">Date of Complaint(On Complaint letter)<span class="req fixed require_lable " style="display: none">*</span></label>
                            <?php
                            echo $this->form->input('doc', array('type' => "text",'id'=>'doc', 'label' => false,  'data-uk-datepicker' => '{format:"YYYY-MM-DD",maxDate:"'.date('Y-m-d').'"}', 'class' => "md-input require"));
                            ?>
                            <span class="md-input-bar"></span>
                        </div>
                    </div>
                    <div class="uk-width-medium-1-2">
                        <div class="parsley-row">
                            <label for="dor" class="md-input label-fixed">Date of Complaint Receive(Received at the commission) <span class="req fixed require_lable " style="display: none">*</span></label>
                            <?php
                            echo $this->form->input('docr', array('type' => "text", 'id'=>'docr', 'label' => false, 'data-uk-datepicker' => '{format:"YYYY-MM-DD",maxDate:"'.date('Y-m-d').'"}', 'class' => "md-input require"));
                            ?>
                            <span class="md-input-bar"></span>
                        </div>
                    </div>
                </div>
                <div class="uk-grid" data-uk-grid-margin > </div>
                <div class="uk-grid" data-uk-grid-margin > 
                    <div class="uk-width-medium-1-2">
                        <div class="parsley-row">
                            <label for="dor" class="md-input label-fixed">Mode of Complaint Received <span class="req fixed require_lable " style="display: none">*</span></label>

                            <select name="complian_mode"  class="md-input require data-md-selectize label-fixed">
                                <option value="">-- Select --</option>
                                <option value="1">Email</option>
                                <option value="2">Physical Mail</option>
                            </select>
                            <span class="md-input-bar"></span>
                        </div>
                    </div>

                    <div class="uk-width-medium-1-2">
                        <div class="parsley-row">
                            <label for="department" class="md-input label-fixed">Entity complaint against <span class="req fixed require_lable " style="display: none">*</span></label>
                            <?php
                            echo $this->form->input('entity_compl', array('type' => "text", 'label' => false, 'class' => "md-input require"));
                            ?>   
                        </div>
                    </div>
                </div>
                <div  class="uk-grid" data-uk-grid-margin></div>
                <div class="uk-grid" data-uk-grid-margin > 
                    <div class="uk-width-medium-1-2" >
                        <label for="cc_num" class="" >Complaint Documents: </label>
                        <div class=" md-btn md-btn-primary">
                            <?php
                            echo $this->form->input('receive_doc', array('type' => 'file', 'class'=>'receive_doc',  'label' => false));
                            ?>
                        </div>
                    </div>
                </div>
                <div  class="uk-grid" data-uk-grid-margin></div>
                <hr><h3>Personal Information:</h3>
                <div  class="uk-grid" data-uk-grid-margin></div>
                <div class="uk-grid" data-uk-grid-margin > 
                    <div class="uk-width-medium-1-3" >
                        
                         <div class="parsley-row">
                            <label for="department" class="md-input label-fixed">Contact Person Name <span class="req fixed requirefield_lable " style="display: none">*</span></label>
                            <?php
                            echo $this->form->input('person_name', array('type' => "text", 'label' => false, 'class' => "md-input requirefield"));
                            ?>   
                        </div>
                    </div>
                    <div class="uk-width-medium-1-3" >
                        
                        <div class="parsley-row">
                            <label for="department" class="md-input label-fixed">Mobile <span class="req fixed require_lable " style="display: none">*</span></label>
                            <?php
                            echo $this->form->input('info_mobile', array('type' => "text", 'label' => false, 'maxlength'=>'10', 'onblur'=>'return checkNumber();','class' => "md-input require"));
                            ?>   
                        </div>
                    </div>
                    <div class="uk-width-medium-1-3" >
                       
                         <div class="parsley-row">
                            <label for="department" class="md-input label-fixed">Official E-Mail ID<span class="req fixed require_lable " style="display: none">*</span></label>
                            <?php
                            echo $this->form->input('info_mail', array('type' => "email", 'label' => false, 'class' => "md-input require"));
                            ?>   
                        </div>
                    </div>
                </div>
                
                <div  class="uk-grid" data-uk-grid-margin></div>
                <div class="uk-grid">
                    <div class="uk-width-1-3 uk-margin-top">                            
                        <button type="submit" name="submit" value="submit" onclick="return checkNumber();" class="md-btn md-btn-success" href="#">Save</button>                    
                    </div>
                    <div class="uk-width-1-3 uk-margin-top">                            
                        <a class="md-btn md-btn-primary" href="<?php echo $this->Html->url('/ComplianceAudit/compliant_investigation') ?>">Cancel</a>                       
                    </div>
                </div>
<?php echo $this->Form->end(); ?>
            </div>
        </div>
    </div>
</div>
