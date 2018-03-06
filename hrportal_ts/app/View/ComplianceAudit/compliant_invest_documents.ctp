<script type="text/javascript">
   
    function checkNumber(){
       var data = $('#mobile').val();
    if (isNaN(data)) {
    alert("Please enter valid mobile number.");
    return false;
    }
    }
    
    
</script>

<div id="page_content">
    <div id="page_heading" data-uk-sticky="{ top: 48, media: 960 }">
        <h1>Enter Compliant</h1>
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
                <?php echo $this->Form->create('doc', array('url' => array('controller' => 'ComplianceAudit', 'action' => 'compliant_invest_documents'), 'type' => 'file', 'id' => 'form_validation', 'class' => 'uk-form-stacked'));
                      echo $this->form->input('compliant_id', array('type' => 'hidden', 'label' => false,'value'=>$rec['CAInvestigation']['id'] ,'required' => true, 'class' => "md-input"));
                ?>
                <h3 class="heading_a">Compliant</h3>
                <div  class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-1-2">
                        <div class="parsley-row">
                            <label for="t_o_org" class="md-input label-fixed">Compliant Category <span class="req">*</span></label>
                            <select name="comp_category" required="required" disabled="disabled" class="md-input data-md-selectize ">
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
                    <div class="uk-width-medium-1-2" >
                        <div class="parsley-row">
                            <label for="resp" class="md-input label-fixed">Compliant Description <span class="req fixed">*</span></label>
                            <?php
                            echo $this->form->input('compl_desc', array('type' => 'text', 'disabled'=>true,'label' => false,'value'=>$rec['CAInvestigation']['compliant_description'] ,'required' => true, 'class' => "md-input"));
                            ?>                
                        </div>
                    </div>
                </div>
                <div class="uk-grid" data-uk-grid-margin > </div>
                <div class="uk-grid" data-uk-grid-margin > 
                    <div class="uk-width-medium-1-2">
                        <div class="parsley-row">
                            <label for="dor" class="md-input label-fixed">Date of Compliant <span class="req">*</span></label>
                            <?php
                            echo $this->form->input('doc', array('type' => "text", 'disabled'=>true,'label' => false, 'required' => true, 'data-uk-datepicker' => '{format:"DD-MM-YYYY"}','value'=>date("d/m/Y", strtotime($rec['CAInvestigation']['date_of_compliant'])), 'class' => "md-input"));
                            ?>
                            <span class="md-input-bar"></span>
                        </div>
                    </div>
                    <div class="uk-width-medium-1-2">
                        <div class="parsley-row">
                            <label for="dor" class="md-input label-fixed">Date of Compliant Receive <span class="req">*</span></label>
                            <?php
                            echo $this->form->input('docr', array('type' => "text", 'disabled'=>true,'label' => false, 'required' => true, 'data-uk-datepicker' => '{format:"DD-MM-YYYY"}', 'value'=>date("d/m/Y", strtotime($rec['CAInvestigation']['date_of_compliant_received'])),'class' => "md-input"));
                            ?>
                            <span class="md-input-bar"></span>
                        </div>
                    </div>
                </div>
                <div class="uk-grid" data-uk-grid-margin > </div>
                <div class="uk-grid" data-uk-grid-margin > 
                    <div class="uk-width-medium-1-2">
                        <div class="parsley-row">
                            <label for="dor" class="md-input label-fixed">Type of ID Details <span class="req">*</span></label>

                            <select name="id_detail_type" required="required" disabled="disabled" class="md-input data-md-selectize">
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
                    <div class="uk-width-medium-1-2">
                        <div class="parsley-row">
                            <label for="dor" class="md-input label-fixed">ID Details <span class="req">*</span></label>
                            <?php
                            echo $this->form->input('id_detail', array('type' => "text", 'disabled'=>true,'label' => false, 'value'=>$rec['CAInvestigation']['id_details'],'required' => true, 'class' => "md-input"));
                            ?>
                            <span class="md-input-bar"></span>
                        </div>
                    </div>
                </div>
                <div class="uk-grid" data-uk-grid-margin > </div>
                <div class="uk-grid" data-uk-grid-margin > 
                    <div class="uk-width-medium-1-2">
                        <div class="parsley-row">
                            <label for="dor" class="md-input label-fixed">Mode of Compliant Received <span class="req">*</span></label>

                            <select name="complian_mode" required="required" disabled="disabled" class="md-input data-md-selectize label-fixed">
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
                            <label for="department" class="md-input label-fixed">Entity Complaint Against </label>
                            <?php echo $this->form->input('department', array('type' => 'text', 'disabled'=>true,'label' => false, 'value'=>$rec['CAInvestigation']['compliant_entity'], 'required' => true, 'class' => "md-input")); ?>
                        </div>
                    </div>
                </div>
                <div  class="uk-grid" data-uk-grid-margin></div>
                <div class="uk-grid" data-uk-grid-margin > 
                    <div class="uk-width-medium-1-2">
                        <div class="parsley-row">
                            <label for="nature_employment" class="md-input label-fixed">Email Address<span class="req">*</span></label>
<?php echo $this->form->input('email', array('type' => 'email', 'disabled'=>true,'label' => false, 'value'=>$rec['CAInvestigation']['email'], 'required' => true, 'class' => "md-input")); ?>
                        </div>
                    </div>
                    <div class="uk-width-medium-1-2">
                        <div class="parsley-row">
                            <label for="postal_add" class="md-input label-fixed">Postal Address <span class="req fixed" id="mend" style="display: none">*</span></label>
                            <?php
                            echo $this->form->input('postal_add', array('type' => 'text', 'disabled'=>true,'id' => 'emplmnt_number','value'=>$rec['CAInvestigation']['postal_add'], 'label' => false, 'class' => "md-input"));
                            //echo $this->form->input('refnum', array('type'=>'hidden','label'=>false,'required'=>true,'value'=>$RefNum,'class'=>"md-input"));
                            ?>                
                        </div>
                    </div>
                </div> 
                <div  class="uk-grid" data-uk-grid-margin></div>
                <div class="uk-grid" data-uk-grid-margin > 
                    <div class="uk-width-medium-1-2">
                        <div class="parsley-row">
                            <label for="nature_employment" class="md-input label-fixed">Mobile Number<span class="req">*</span></label>
<?php echo $this->form->input('mobile', array('type' => 'text', 'id'=>'mobile','label' => false,'disabled'=>true, 'required' => true, 'maxlength'=>'10','onblur'=>'return checkNumber();','value'=>$rec['CAInvestigation']['phone_number'], 'class' => "md-input")); ?>
                        </div>
                    </div>
                    <div class="uk-width-medium-1-2">
                        <div class="parsley-row">
                            <label for="nature_employment" class="md-input label-fixed">Compliant Document :
                            <?php 
                foreach($rec['CAComplianDoc'] as $recc){
                   if($recc['doc_status'] == '1'){
                   
                   ?>
                            &nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo $this->Html->url('investigation_file_download/' . $recc['id']); ?>" >View</a>
                    <!--<a class="md-btn md-btn-danger" href="<?php //echo $this->Html->url('investigation_file_remove/'.base64_encode($rec['CAInvestigation']['id']).'/'.base64_encode($recc['id'])); ?>">Remove</a>-->                       
                      <?php
                   }
                }
                ?>
                             </label>
                        </div>
                    </div>
                </div>
                
                <div class="uk-grid" data-uk-grid-margin > </div>
                <div class="uk-grid" data-uk-grid-margin > </div>
                
                <div class="uk-grid" data-uk-grid-margin > </div>
                
                        <?php 
                foreach($rec['CAComplianDoc'] as $recc){
                    
                   if($recc['doc_status'] == '2'){
                       
                   if($recc['final_doc_type'] == '1'){
                   ?>
                <div class="uk-grid" data-uk-grid-margin > 
                    <div class="uk-width-medium-1-3" >
                        <label for="nature_employment" class="md-input label-fixed">Term of Reference: </label>
                     </div>
                    <div class="uk-width-medium-1-3" >
                        &nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo $this->Html->url('investigation_file_download/' . $recc['id']); ?>" ><?php echo "View";?></a>
                    </div>
                    <div class="uk-width-medium-1-3" >
                    <a class="md-btn md-btn-danger" href="<?php echo $this->Html->url('investigation_file_remove/'.base64_encode($rec['CAInvestigation']['id']).'/'.base64_encode($recc['id']).'/final_doc'); ?>">Remove</a>
                    </div>
                </div>
                      <?php
                   }elseif($recc['final_doc_type'] == '2'){
                       ?>
                <div class="uk-grid" data-uk-grid-margin > 
                           <div class="uk-width-medium-1-3" >
                        <label for="nature_employment" class="md-input label-fixed">Letter appointing the investigation team:  </label>
                     </div>
                    <div class="uk-width-medium-1-3" >
                        &nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo $this->Html->url('investigation_file_download/' . $recc['id']); ?>" ><?php echo "View";?></a>
                    </div>
                    <div class="uk-width-medium-1-3" >
                    <a class="md-btn md-btn-danger" href="<?php echo $this->Html->url('investigation_file_remove/'.base64_encode($rec['CAInvestigation']['id']).'/'.base64_encode($recc['id']).'/final_doc'); ?>">Remove</a>
                    </div>
                </div>
                    <?php
                   }elseif($recc['final_doc_type'] == '3'){
                       ?>
                <div class="uk-grid" data-uk-grid-margin > 
                           <div class="uk-width-medium-1-3" >
                        <label for="nature_employment" class="md-input label-fixed">Documentary evidence provided/gathered:</label>
                     </div>
                    <div class="uk-width-medium-1-3" >
                            &nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo $this->Html->url('investigation_file_download/' . $recc['id']); ?>" ><?php echo "View";?></a>
                    </div>
                    <div class="uk-width-medium-1-3" >
                    <a class="md-btn md-btn-danger" href="<?php echo $this->Html->url('investigation_file_remove/'.base64_encode($rec['CAInvestigation']['id']).'/'.base64_encode($recc['id']).'/final_doc'); ?>">Remove</a>
                    </div>
                </div>
                    <?php
                   }elseif($recc['final_doc_type'] == '4'){
                       ?>
                <div class="uk-grid" data-uk-grid-margin > 
                           <div class="uk-width-medium-1-3" >
                        <label for="nature_employment" class="md-input label-fixed">Investigation report:</label>
                     </div>
                    <div class="uk-width-medium-1-3" >
                            &nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo $this->Html->url('investigation_file_download/' . $recc['id']); ?>" ><?php echo "View";?></a>
                    </div>
                    <div class="uk-width-medium-1-3" >
                    <a class="md-btn md-btn-danger" href="<?php echo $this->Html->url('investigation_file_remove/'.base64_encode($rec['CAInvestigation']['id']).'/'.base64_encode($recc['id']).'/final_doc'); ?>">Remove</a>
                    </div>
                </div>
                    <?php
                   }
                   }
                }
                ?>
                
                <div class="uk-grid" data-uk-grid-margin > </div>
                <hr>
                <div class="uk-grid" data-uk-grid-margin > 
                    <div class="uk-width-medium-1-2" >
                        <label for="cc_num" class="" >Term of Reference: </label>
                    </div>
                    <div class="uk-width-medium-1-2" >
                        <div class=" md-btn md-btn-primary">
                            <?php
                            echo $this->form->input('term_reference', array('type' => 'file', 'label' => false));
                            ?>
                        </div>
                    </div>
                </div>
                <div class="uk-grid" data-uk-grid-margin > </div>
                <div class="uk-grid" data-uk-grid-margin > 
                    <div class="uk-width-medium-1-2" >
                        <label for="cc_num" class="" >Letter appointing the investigation team: </label>
                    </div>
                    <div class="uk-width-medium-1-2" >
                        <div class=" md-btn md-btn-primary">
                            <?php
                            echo $this->form->input('letter_appointing', array('type' => 'file', 'label' => false));
                            ?>
                        </div>
                    </div>
                </div>
                <div class="uk-grid" data-uk-grid-margin > </div>
                <div class="uk-grid" data-uk-grid-margin > 
                    <div class="uk-width-medium-1-2" >
                        <label for="cc_num" class="" >Documentary evidence provided/gathered: </label>
                    </div>
                    <div class="uk-width-medium-1-2" >
                        <div class=" md-btn md-btn-primary">
                            <?php
                            echo $this->form->input('doc_evidence', array('type' => 'file', 'label' => false));
                            ?>
                        </div>
                    </div>
                </div>
                <div class="uk-grid" data-uk-grid-margin > </div>
                <div class="uk-grid" data-uk-grid-margin > 
                    <div class="uk-width-medium-1-2" >
                        <label for="cc_num" class="" >Investigation report: </label>
                    </div>
                    <div class="uk-width-medium-1-2" >
                        <div class=" md-btn md-btn-primary">
                            <?php
                            echo $this->form->input('invest_report', array('type' => 'file', 'label' => false));
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
                        <a class="md-btn md-btn-primary" href="<?php echo $this->Html->url('/ComplianceAudit/compliant_received_compliance_audit') ?>">Cancel</a>                       
                    </div>
                </div>
<?php echo $this->Form->end(); ?>
            </div>
        </div>
    </div>
</div>
