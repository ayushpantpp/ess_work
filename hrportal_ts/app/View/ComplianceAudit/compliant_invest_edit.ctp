<script type="text/javascript">
   
   function require(val){
      
      // alert(<?php echo $Compliants[0]['CAInvestigation']['compliant_category'];?>);
       var value = <?php echo $Compliants[0]['CAInvestigation']['compliant_category'];?>;
//       alert(value);
      //alert(val);
       if(value == '1'){
           if(val == '1' && value == '1'){ 
                $(".requirefield").attr('required', true);
                $(".require").attr('required', false);
                $(".requirefield_lable").show();
                $(".require_lable").hide();
           }else if((val != '1' && val != '2' && val != '3' ) && value == '1'){
                 $(".requirefield").attr('required', true);
                $(".require").attr('required', false);
                $(".requirefield_lable").show();
                $(".require_lable").hide();
           }else if(val != '1' && value == '1'){
               $(".require").attr('required', true);
                $(".requirefield").attr('required', true);
                $(".requirefield_lable").show();
                $(".require_lable").show();
           }
//           $(".requirefield").attr('required', true);
//           $(".require").attr('required', false);
//           $(".requirefield_lable").show();
//           $(".require_lable").hide();
       }else{
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
//           $(".require").attr('required', true);
//           $(".requirefield").attr('required', true);
//           $(".requirefield_lable").show();
//           $(".require_lable").show();
       }
       
   }
   
   $(document).ready(require);
   
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
            alert ("Complian Date should be less than Complian Receiving Date !!");
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
                if (!empty($Compliants)) {
                    foreach ($Compliants as $rec)
                        ;
//                    echo "<pre>";
//                    print_r($rec);
                }
                ?>
                <?php echo $this->Form->create('doc', array('url' => array('controller' => 'ComplianceAudit', 'action' => 'compliant_invest_edit'), 'type' => 'file', 'id' => 'form_validation', 'class' => 'uk-form-stacked'));
                      echo $this->form->input('compliant_id', array('type' => 'hidden', 'label' => false,'value'=>$rec['CAInvestigation']['id'] ,'required' => true, 'class' => "md-input"));
                ?>
                <h3 class="heading_a">Complaint</h3>
                
                
                <div  class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-1-2">
                        <div class="parsley-row">
                            <label for="t_o_org" class="md-input label-fixed">Case No.<span class="req">*</span></label>
                            <?php
                            echo $this->form->input('case_no', array('type' => 'text', 'label' => false, 'required' => true, 'value'=>$rec['CAInvestigation']['case_no'], 'readonly'=>true,'class' => "md-input"));
                            ?>  
                        </div>
                    </div>
                    <div class="uk-width-medium-1-2">
                        <div class="parsley-row">
                            <label for="t_o_org" class="md-input label-fixed">Complaint Category <span class="req">*</span></label>
                            <select name="comp_category" required="required" onchange="require(this.value);" class="md-input data-md-selectize ">
                                <option value="">-- Select --</option>
                                <?php
                                $comp_cat = array('1'=>'Anonymous Whistle blower','2'=>'Public Servant','3'=>'Others');
                                foreach ($comp_cat as $key => $rt) {
                                    $value = $key;
                                    $option = $rt;
                                    if($rec['CAInvestigation']['compliant_category'] == $value){
                                        echo "<option value='" . $value . "' selected='selected'>" . $option . "</option>";
                                    }else{
                                    echo "<option value='" . $value . "'>" . $option . "</option>";
                                    }
                                }
                                 
                                ?>
                                
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
                            echo $this->form->textarea('compl_desc', array('type' => 'text', 'label' => false,'maxlength'=>'1000', 'value'=>$rec['CAInvestigation']['compliant_description'],'class' => "md-input requirefield"));
                            ?>                
                        </div>
                    </div>
                    <div class="uk-width-medium-1-2">
                        <div class="parsley-row">
                            <label for="dor" class="md-input label-fixed">Type of ID Details <span class="req fixed require_lable " style="display: none">*</span></label>

                            <select name="id_detail_type" class="md-input require data-md-selectize">
                                <option value="">-- Select --</option>
                                 <?php
                                $id_det_type = array('1'=>'Personal Number','2'=>'ID Number','3'=>'Passport Number');
                                foreach ($id_det_type as $key => $rt) {
                                    $value = $key;
                                    $option = $rt;
                                    if($rec['CAInvestigation']['id_details_type'] == $value){
                                        echo "<option value='" . $value . "' selected='selected'>" . $option . "</option>";
                                    }else{
                                    echo "<option value='" . $value . "'>" . $option . "</option>";
                                    }
                                }
                                 
                                ?>
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
                            echo $this->form->input('id_details', array('type' => 'text', 'label' => false, 'value'=>$rec['CAInvestigation']['id_details'], 'class' => "md-input require"));
                            ?>                
                        </div>
                    </div>
                    <div class="uk-width-medium-1-2" >
                        <div class="parsley-row">
                            <label for="resp" class="md-input label-fixed">Complaint Designation <span class="req fixed require_lable " style="display: none">*</span></label>
                            <?php
                            echo $this->form->input('compl_designation', array('type' => 'text', 'label' => false, 'value'=>$rec['CAInvestigation']['compliant_designation'], 'class' => "md-input require"));
                            ?>                
                        </div>
                    </div>
                    
                </div>
                <div  class="uk-grid" data-uk-grid-margin></div>
                
                <div  class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-1-2" >
                        <div class="parsley-row">
                            <label for="resp" class="md-input label-fixed">Mobile number of the complainant<span class="req fixed require_lable " style="display: none">*</span></label>
                            <?php echo $this->form->input('mobile', array('type' => 'text', 'id'=>'mobile','label' => false,'value'=>$rec['CAInvestigation']['phone_number'], 'maxlength'=>'10','onblur'=>'return checkNumber();', 'class' => "md-input require")); ?>               
                        </div>
                    </div>
                    <div class="uk-width-medium-1-2" >
                        <div class="parsley-row">
                            <label for="resp" class="md-input label-fixed">Email Address of Complainant<span class="req fixed require_lable " style="display: none">*</span></label>
                           <?php echo $this->form->input('email', array('type' => 'email', 'label' => false, 'value'=>$rec['CAInvestigation']['email'], 'class' => "md-input require")); ?>               
                        </div>
                    </div>
                    
                </div>
                <div  class="uk-grid" data-uk-grid-margin></div>
                <div  class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-1-2" >
                        <div class="parsley-row">
                            <label for="resp" class="md-input label-fixed">Postal Address <span class="req fixed require_lable " style="display: none">*</span></label>
                            <?php echo $this->form->input('postal_add', array('type' => 'text', 'id' => 'emplmnt_number', 'label' => false,'value'=>$rec['CAInvestigation']['postal_add'], 'class' => "md-input require")); ?>               
                        </div>
                    </div>
                    <div class="uk-width-medium-1-2" >
                        <div class="parsley-row">
                            <label for="resp" class="md-input label-fixed">Complaint Type <span class="req fixed require_lable " style="display: none">*</span></label>
                           <select name="comp_type" class="md-input require data-md-selectize ">
                                <option value="">-- Select --</option>
                                
                                <?php
                                $complain_type = array(
                                    '1'=>'Terms and Service',
                                    '2'=>'Corrupt/Ethical Conduct',
                                    '3'=>'Favoritism/Unfairness',
                                    '4'=>'Workplace Discrimination',
                                    '5'=>'Work Place Bullying',
                                    '6'=>'Occupational Health and Safety',
                                    '7'=>'Workloads',
                                    '8'=>'Occupational Health and Safety',
                                    '9'=>'Others',
                                        );
                                foreach ($complain_type as $key => $rt) {
                                    $value = $key;
                                    $option = $rt;
                                    if($rec['CAInvestigation']['compliant_type'] == $value){
                                        echo "<option value='" . $value . "' selected='selected'>" . $option . "</option>";
                                    }else{
                                    echo "<option value='" . $value . "'>" . $option . "</option>";
                                    }
                                }
                                 
                                ?>
                                
                                
                            </select>
                        </div>
                    </div>
                    
                </div>
                <div  class="uk-grid" data-uk-grid-margin></div>
                <div class="uk-grid" data-uk-grid-margin > 
                    <div class="uk-width-medium-1-2">
                        <div class="parsley-row">
                            <label for="dor" class="md-input label-fixed">Date of Complaint(On Complain letter)<span class="req fixed require_lable " style="display: none">*</span></label>
                            <?php
                            
                            if($rec['CAInvestigation']['date_of_compliant'] != '' && $rec['CAInvestigation']['date_of_compliant'] != '1970-01-01'){
                                $docl = date("Y-m-d", strtotime($rec['CAInvestigation']['date_of_compliant']));
                            }else{
                                $docl = "";
                            }
                            
                            echo $this->form->input('doc', array('type' => "text",'id'=>'doc', 'label' => false,  'data-uk-datepicker' => '{format:"YYYY-MM-DD",maxDate:"'.date('Y-m-d').'"}','value'=>$docl, 'class' => "md-input require"));
                            ?>
                            <span class="md-input-bar"></span>
                        </div>
                    </div>
                    <div class="uk-width-medium-1-2">
                        <div class="parsley-row">
                            <label for="dor" class="md-input label-fixed">Date of Complaint Receive(Received at the commission) <span class="req fixed require_lable " style="display: none">*</span></label>
                            <?php
                            if($rec['CAInvestigation']['date_of_compliant'] != '' && $rec['CAInvestigation']['date_of_compliant_received'] != '1970-01-01'){
                                date("Y-m-d", strtotime($rec['CAInvestigation']['date_of_compliant_received']));
                            }else{
                                $docr = "";
                            }
                            
                            echo $this->form->input('docr', array('type' => "text", 'id'=>'docr', 'label' => false, 'data-uk-datepicker' => '{format:"YYYY-MM-DD",maxDate:"'.date('Y-m-d').'"}','value'=>$docr, 'class' => "md-input require"));
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
                               <?php
                                $mode = array('1'=>'Email','2'=>'Physical Mail');
                                foreach ($mode as $key => $rt) {
                                    $value = $key;
                                    $option = $rt;
                                    if($rec['CAInvestigation']['mode_of_compliant_received'] == $value){
                                        echo "<option value='" . $value . "' selected='selected'>" . $option . "</option>";
                                    }else{
                                    echo "<option value='" . $value . "'>" . $option . "</option>";
                                    }
                                }
                                 
                                ?>
                            </select>
                            <span class="md-input-bar"></span>
                        </div>
                    </div>

                    <div class="uk-width-medium-1-2">
                        <div class="parsley-row">
                            <label for="department" class="md-input label-fixed">Entity complained against <span class="req fixed require_lable " style="display: none">*</span></label>
                            <?php
                            echo $this->form->input('entity_compl', array('type' => "text", 'label' => false, 'value'=>$rec['CAInvestigation']['compliant_entity'],'class' => "md-input require"));
                            ?>   
                        </div>
                    </div>
                </div>
                <div  class="uk-grid" data-uk-grid-margin></div>
                <div class="uk-grid" data-uk-grid-margin > 
                    
                         <?php 
                foreach($rec['CAComplianDoc'] as $recc){
                    if($recc['doc_status'] == '1'){
                    ?>
                    <div class="uk-width-medium-1-3" >
                    <?php echo $recc['file_real_name'];?>
                    </div>
                    <div class="uk-width-medium-1-3">
                    <a href="<?php echo $this->Html->url('investigation_file_download/' . $recc['id']); ?>" >View</a>  
                    </div>
                    <div class="uk-width-medium-1-3" >
                    <a class="md-btn md-btn-danger" href="<?php echo $this->Html->url('investigation_file_remove/'.base64_encode($rec['CAInvestigation']['id']).'/'.base64_encode($recc['id'])); ?>">Remove</a>                       
                    </div>
                      <?php
                    }
                }
                ?>
                   
                </div>
                <div  class="uk-grid" data-uk-grid-margin></div>
                <div class="uk-grid" data-uk-grid-margin > 
                    <div class="uk-width-medium-1-2" >
                        <label for="cc_num" class="" >Complaint Documents: </label>
                        <div class=" md-btn md-btn-primary">
                            <?php
                            echo $this->form->input('receive_doc', array('type' => 'file', 'label' => false));
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
                            echo $this->form->input('person_name', array('type' => "text", 'label' => false,'value'=>$rec['CAInvestigation']['info_name'] ,'class' => "md-input requirefield"));
                            ?>   
                        </div>
                    </div>
                    <div class="uk-width-medium-1-3" >
                        
                        <div class="parsley-row">
                            <label for="department" class="md-input label-fixed">Mobile <span class="req fixed require_lable " style="display: none">*</span></label>
                            <?php
                            echo $this->form->input('info_mobile', array('type' => "text", 'label' => false, 'value'=>$rec['CAInvestigation']['info_mobile'] ,'class' => "md-input require"));
                            ?>   
                        </div>
                    </div>
                    <div class="uk-width-medium-1-3" >
                       
                         <div class="parsley-row">
                            <label for="department" class="md-input label-fixed">Official E-Mail ID<span class="req fixed require_lable " style="display: none">*</span></label>
                            <?php
                            echo $this->form->input('info_mail', array('type' => "text", 'label' => false,'value'=>$rec['CAInvestigation']['info_email'] , 'class' => "md-input require"));
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
