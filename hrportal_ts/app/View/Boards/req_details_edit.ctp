<script>
    function fieldsDisable(val){ 
        if(val!='' && val!='0' && val=='1'){
        //var val=jQuery("#type").val();
        $.ajax({
            type: "POST",
            url: '<?php echo $this->webroot ?>Boards/fields_datatype/' + val,
            //data:'project_id='+val,
            success: function (data) {
                //alert(data);
                $("#newfield").slideDown();
                $("#newfield").html(data);
                
            }
        });
        }else{
                $("#newfield").slideUp();
        }
    }
    
    function phydisbl(val){
        if(val=='0'){
            $("#disbl_det").removeAttr("disabled");
            $("#disbl_det").attr('required', true);
        }else{
            $("#disbl_det").attr('disabled', 'disabled');
            $("#disbl_det").removeAttr('required');
        }
    }
    
  
</script>

<div id="page_content">
    <div id="page_heading" data-uk-sticky="{ top: 48, media: 960 }">
            
            <h1>Request Details</h1>
            
    </div>
    
    
    <div id="page_content_inner">
        <?php echo $flash = $this->Session->flash(); ?> 
       <div class="md-card">  
            <div class="md-card-content large-padding">
                 <?php foreach($reqDet as $rec);
                 ?>
                <?php echo $this->Form->create('doc', array('url' =>array('controller' => 'Boards', 'action' =>'req_details_edit'),'type' => 'file','id'=>'form_validation','class' => 'uk-form-stacked' )); 
                ?>
                <h3 class="heading_a">Enter Request Details</h3>
                <div  class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-1-4" >
                            <div class="parsley-row">
                                <label for="req_cat">Serial Number</label>
                                <?php echo $this->form->input('seri_Num', array('type'=>'text','label'=>false, 'disabled'=>'disabled','value'=>$rec['BMRequestDetails']['serial_num'],'required'=>true,'class'=>"md-input"));
                                echo $this->form->input('detID', array('type'=>'hidden','label'=>false,'value'=>$rec['BMRequestDetails']['id'],'required'=>true,'class'=>"md-input"));
                                  ?>
                             </div>
                       </div>
                       <div class="uk-width-medium-1-4">
                            <div class="parsley-row">
                                <label for="req_ref">Request Reference Number <span class="req">*</span></label>
                                <?php 
                                echo $this->form->input('refNum', array('type'=>'text','label'=>false, 'disabled'=>'disabled','value'=>$this->common->getReqRefNumByReqID($rec['BMRequestDetails']['request_id']),'required'=>true,'class'=>"md-input"));
                                echo $this->form->input('req_ref', array('label'=>false,'type' => "hidden",'required'=>true, 'value'=>$rec['BMRequestDetails']['request_id'])); 
                                   
                                ?>
                                
                        </div>
                       </div>
                    
                    <div class="uk-width-medium-1-4" >
                            <div class="parsley-row">
                                <label for="id_no">ID No. <span class="req">*</span></label>
                                <?php echo $this->form->input('id_no', array('type'=>'text','label'=>false,'value'=>$rec['BMRequestDetails']['id_no'],'required'=>true,'class'=>"md-input"));
                                  ?>
                             </div>
                       </div>
                    <div class="uk-width-medium-1-4" >
                            <div class="parsley-row">
                                <label for="p_no">P No. <span class="req">*</span></label>
                                <?php echo $this->form->input('p_no', array('type'=>'text','label'=>false,'value'=>$rec['BMRequestDetails']['p_no'], 'required'=>true,'class'=>"md-input"));
                                  ?>
                             </div>
                       </div>
                    </div>
                <div class="uk-grid" data-uk-grid-margin>
                        <div class="uk-width-medium-1-4" >
                            <div class="parsley-row">
                                <label for="title">Title <span class="req">*</span></label>
                                <?php 
                                array_unshift($title,'--Select--');
                                echo $this->form->input('title', array('label'=>false,'type' => "select",'empty'=>'-- Select --','required'=>true,'default'=>$rec['BMRequestDetails']['title'],'options' => $title, 'class' => "md-input",'data-md-selectize')); 
                                ?>
                             </div>
                       </div>
                    <div class="uk-width-medium-1-4" >
                            <div class="parsley-row">
                                <label for="surname">Surname <span class="req">*</span></label>
                                <?php echo $this->form->input('surname', array('type'=>'text','label'=>false,'value'=>$rec['BMRequestDetails']['surname'],'required'=>true,'class'=>"md-input"));
                                ?>
                             </div>
                       </div>
                       <div class="uk-width-medium-1-4">
                            <div class="parsley-row">
                                <label for="firstname">First name <span class="req">*</span></label>
                                <?php echo $this->form->input('firstname', array('type'=>'text','label'=>false,'value'=>$rec['BMRequestDetails']['firstname'],'required'=>true,'class'=>"md-input"));?>
                                
                        </div>
                       </div>
                    <div class="uk-width-medium-1-4">
                            <div class="parsley-row">
                                <label for="other_name">Other names </label>
                                <?php echo $this->form->input('other_name', array('type'=>'text','label'=>false, 'value'=>$rec['BMRequestDetails']['other_name'],'class'=>"md-input"));?>
                                
                        </div>
                       </div>
                </div>
                <div class="uk-grid" data-uk-grid-margin></div>
                
                      <div class="uk-grid" data-uk-grid-margin > 
                        <div class="uk-width-medium-1-3">
                            <div class="parsley-row">
                                <label for="dob">Date of Birth <span class="req">*</span></label>
                                <?php 
                                echo $this->form->input('dob', array('type' => "text",'label'=>false,'required'=>true,'data-uk-datepicker'=>'{format:"DD-MM-YYYY"}','value'=>date("d/m/Y", strtotime($rec['BMRequestDetails']['dob'])), 'class' => "md-input")); 
                                ?>
                                
                        </div>
                    </div>
                       <div class="uk-width-medium-1-3">
                            <div class="parsley-row">
                                <label for="gender">Gender <span class="req">*</span></label>
                                <?php 
                                echo $this->form->input('gender', array('label'=>false,'type' => "select",'empty'=>'-- Select --','required'=>true,'default'=>$rec['BMRequestDetails']['gender'],'options' => $gender, 'class' => "md-input",'data-md-selectize')); 
                                ?>
                        </div>
                       </div>
                    <div class="uk-width-medium-1-3">
                            <div class="parsley-row">
                                <label for="department">Data Entry Type <span class="req">*</span></label>
                                <?php 
                                array_unshift($data_E_type,'--Select--');
                                echo $this->form->input('data_entry_type', array('label'=>false,'type' => "select",'empty'=>'-- Select --','required'=>true,'default'=>$rec['BMRequestDetails']['data_entry_type'],'options' => $data_E_type, 'onchange'=>'fieldsDisable(this.value)','class' => "md-input",'data-md-selectize')); 
                                ?>
                            </div>
                       </div> 
                          
                               
                </div> 
                
                <div id="newfield" class="uk-grid" data-uk-grid-margin  >
                    <?php if($rec['BMRequestDetails']['data_entry_type'] == '1'){
                        ?>
                                <div class="uk-width-medium-1-3">
                                    <div class="parsley-row">
                                        <label for="subject">Academic <span class="req">*</span></label>
                                        <?php echo $this->form->textarea('acad', array('label' => false, 'value'=>$rec['BMRequestDetails']['academic'],'required' => true, 'class' => "md-input")); ?>                
                                    </div>
                                </div>

                                <div class="uk-width-medium-1-3">
                                    <div class="parsley-row">
                                        <label for="subject">Professional <span class="req">*</span></label>
                                        <?php echo $this->form->textarea('prof', array('label' => false, 'value'=>$rec['BMRequestDetails']['professional'],'required' => true, 'class' => "md-input")); ?>                
                                    </div>
                                </div>

                                <div class="uk-width-medium-1-3">
                                    <div class="parsley-row">
                                        <label for="subject">Experience <span class="req">*</span></label>
                                        <?php echo $this->form->textarea('exp', array('label' => false, 'value'=>$rec['BMRequestDetails']['experience'],'required' => true, 'class' => "md-input")); ?>                
                                    </div>
                                </div>

                            <?php
                    }?>
                </div>
                <div class="uk-grid" data-uk-grid-margin  >
                    <div class="uk-width-medium-1-1">
                            <div class="parsley-row">
                                <label for="department">Physical Disability <span class="req">*</span></label>
                                <?php 
                                $options = array('0' => 'Yes', '1' => 'No');
                                $attributes = array('legend' => false,'lable'=>false,'onclick'=>'phydisbl(this.value)','default'=>$rec['BMRequestDetails']['physical_disability'],'required'=>true);
                                echo $this->Form->radio('ph_disa', $options, $attributes);
                                ?>
                            </div>
                       </div> 
                    <div class="uk-width-medium-1-3">
                        <div class="parsley-row" id="disbl_dets" >
                                <label for="disabl_det">Disability Details <span class="req">*</span></label>
                                <?php 
                                if($rec['BMRequestDetails']['physical_disability']=='0'){
                                    $disability = array('label'=>false,'type' => "text",$disability,'value'=>$rec['BMRequestDetails']['disable_details'],'value'=>$rec['BMRequestDetails']['disable_details'],'id'=>'disbl_det','class' => "md-input");
                                }else{
                                    $disability = array('label'=>false,'type' => "text",$disability,'value'=>$rec['BMRequestDetails']['disable_details'],'disabled'=>'disabled','id'=>'disbl_det','class' => "md-input");
                                }
                                echo $this->form->input('disabl_det',$disability ); 
                                ?>
                            </div>
                       </div> 
                    <div class="uk-width-medium-1-3">
                            <div class="parsley-row">
                                <label for="ministry">Ministry <span class="req">*</span></label>
                                <?php 
                                array_unshift($Ministry,'--Select--');
                                echo $this->form->input('ministry', array('label'=>false,'type' => "select",'empty'=>'-- Select --','required'=>true,'default'=>$rec['BMRequestDetails']['ministry_id'],'options' => $Ministry,'class' => "md-input",'data-md-selectize')); 
                                ?>
                            </div>
                       </div> 
                    <div class="uk-width-medium-1-3">
                            <div class="parsley-row">
                                <label for="department">Department <span class="req">*</span></label>
                                <?php 
                                
                                array_unshift($department,'--Select--');
                                echo $this->form->input('department', array('label'=>false,'type' => "select",'empty'=>'-- Select --','required'=>true,'default'=>$rec['BMRequestDetails']['department_code'],'options' => $department,'class' => "md-input",'data-md-selectize')); 
                                ?>
                            </div>
                       </div> 
                    <div class="uk-width-medium-1-3">
                            <div class="parsley-row">
                                <label for="doa">Data of First Appointment <span class="req">*</span></label>
                                <?php 
                                echo $this->form->input('doa', array('type' => "text",'label'=>false,'required'=>true,'data-uk-datepicker'=>'{format:"DD-MM-YYYY"}','value'=>date("d/m/Y", strtotime($rec['BMRequestDetails']['d_o_appointment'])), 'class' => "md-input")); 
                                ?>
                                
                            </div>
                       </div> 
                    <div class="uk-width-medium-1-3">
                            <div class="parsley-row">
                                <label for="doca">Data of Current Appointment <span class="req">*</span></label>
                                <?php 
                                echo $this->form->input('doca', array('type' => "text",'label'=>false,'required'=>true,'data-uk-datepicker'=>'{format:"DD-MM-YYYY"}','value'=>date("d/m/Y", strtotime($rec['BMRequestDetails']['d_o_c_appointment'])), 'class' => "md-input")); 
                                ?>
                                
                            </div>
                       </div> 
                    <div class="uk-width-medium-1-3">
                            <div class="parsley-row">
                                <label for="department">Current Designation <span class="req">*</span></label>
                                <?php 
                                $Designation = $this->common->getDesignationList();
                                array_unshift($Designation,'--Select--');
                                echo $this->form->input('curr_desig', array('label'=>false,'type' => "select",'empty'=>'-- Select --','required'=>true,'default'=>$rec['BMRequestDetails']['currenct_designation'],'options' => $Designation,'class' => "md-input",'data-md-selectize')); 
                                ?>
                            </div>
                       </div> 
                    <div class="uk-width-medium-1-3">
                            <div class="parsley-row">
                                <label for="department">Recommended Designation<span class="req">*</span></label>
                                <?php 
                                $Designations = $this->common->getDesignationList();
                                array_unshift($Designations,'--Select--');
                                echo $this->form->input('recomm_desig', array('label'=>false,'type' => "select",'empty'=>'-- Select --','required'=>true,'default'=>$rec['BMRequestDetails']['recommended_designation'],'options' => $Designations,'class' => "md-input",'data-md-selectize')); 
                                ?>
                            </div>
                    </div> 
                    
                    <div class="uk-width-medium-1-3">
                            <div class="parsley-row">
                                <label for="department">Recommended Term of Services<span class="req">*</span></label>
                                 <?php echo $this->form->textarea('recomm_t_serv', array('label' => false, 'value'=>$rec['BMRequestDetails']['recomm_term_services'],'required' => true, 'class' => "md-input")); ?>
								 
                            </div>
                       </div>
                    <div class="uk-width-medium-1-2">
                            <div class="parsley-row">
                                <label for="department">Justification<span class="req">*</span></label>
                                 <?php echo $this->form->textarea('justification', array('label' => false, 'value'=>$rec['BMRequestDetails']['justification'],'required' => true, 'class' => "md-input")); ?>
								
                            </div>
                       </div>
                    <div class="uk-width-medium-1-2">
                            <div class="parsley-row">
                                <label for="department">Notes/Observations<span class="req">*</span></label>
								 <?php echo $this->form->textarea('notes', array('label' => false, 'value'=>$rec['BMRequestDetails']['notes'],'required' => true, 'class' => "md-input")); ?>
                               
                            </div>
                       </div>
                </div>
                <div class="uk-grid">
                    <div class="uk-width-1-3 uk-margin-top">                            
                        <button type="submit" name="submit" value="submit" class="md-btn md-btn-success" href="#">Save</button>                    
                    </div>
                    <div class="uk-width-1-3 uk-margin-top">                            
                        <a class="md-btn md-btn-primary" href="<?php echo $this->Html->url('/Boards/req_details') ?>">Cancel</a>                       
                    </div>
                </div>
                <?php echo $this->Form->end();?>
            </div>
           </div>
   </div>
</div>
