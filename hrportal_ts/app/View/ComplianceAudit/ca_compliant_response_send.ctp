<script type="text/javascript">
   
    function checkNumber(){
       var data = $('#mobile').val();
    if (isNaN(data)) {
    alert("Please enter valid mobile number.");
    return false;
    }
    }
    
    function actionType(val) {
        $.ajax({
            type: "POST",
            url: '<?php echo $this->webroot ?>ComplianceAudit/complain_action_field/' + val,
            //data:'project_id='+val,
            success: function (data) {
                $("#actionfield").html(data);
                
            }
        });
    }
    
    
</script>

<div id="page_content">
    <div id="page_heading" data-uk-sticky="{ top: 48, media: 960 }">
        <h1>Response against compliant !!</h1>
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
                <?php echo $this->Form->create('doc', array('url' => array('controller' => 'ComplianceAudit', 'action' => 'ca_compliant_response_send'), 'type' => 'file', 'id' => 'form_validation', 'class' => 'uk-form-stacked'));
                echo $this->form->input('compliant_id', array('type' => "hidden", 'label' => false, 'required' => true,'value'=>$complID,'class' => "md-input"));
                ?>
                <h3 class="heading_a">Compliant</h3>
                <div  class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-1-2">
                        <div class="parsley-row">
                            <label for="signi_compl" class="md-input label-fixed">Significance of Compliant<span class="req">*</span></label>
                            <?php
                            echo $this->form->input('signi_compl', array('type' => "text", 'label' => false, 'required' => true,'class' => "md-input"));
                            ?>
                        </div>
                    </div>
                    <div class="uk-width-medium-1-2"  >
                        <div class="parsley-row">
                            <label for="signi_compl" class="label-fixed">Symantec Problem <span class="req">*</span>
                        
                            <?php 
                                $options = array('0' => 'Yes', '1' => 'No');
                                $attributes = array('legend' => false,'lable'=>false,'default'=>'0');
                                echo $this->Form->radio('syman_prob', $options, $attributes);
                           ?>
                                </label>
                        </div>
                    </div>
                    
                </div>
                <div class="uk-grid" data-uk-grid-margin > </div>
                <div class="uk-grid" data-uk-grid-margin > 
                    <div class="uk-width-medium-1-2">
                        <div class="parsley-row">
                            <label for="scope_prob" class="md-input label-fixed">Scope of Problem<span class="req">*</span></label>
                            <?php
                            echo $this->form->input('scope_prob', array('type' => "text", 'label' => false, 'required' => true, 'class' => "md-input"));
                            ?>
                            <span class="md-input-bar"></span>
                        </div>
                    </div>
                    <div class="uk-width-medium-1-2" >
                        <div class="parsley-row">
                            <label for="resp" class="md-input label-fixed">Resource Requirement<span class="req fixed">*</span></label>
                            <?php
                            echo $this->form->input('resource_req', array('type' => 'text', 'label' => false, 'required' => true, 'class' => "md-input"));
                            ?>                
                        </div>
                    </div>
                </div>
                <div class="uk-grid" data-uk-grid-margin > </div>
                <div class="uk-grid" data-uk-grid-margin > 
                    <div class="uk-width-medium-1-1">
                            <label for="scope_prob">Is any authorization required to start investigation<span class="req">*</span> 
                              <?php 
                             
                                $options = array('0' => 'Yes', '1' => 'No');
                                $attributes = array('legend' => false,'label' => false,'default'=>'0');
                                echo $this->Form->radio('authorization', $options, $attributes);
                           ?>    
                                </label>
                    </div>
                    
                </div>
                
                <div class="uk-grid" data-uk-grid-margin > </div>
                <div class="uk-grid" data-uk-grid-margin > 
                    <div class="uk-width-medium-1-2">
                        <div class="parsley-row">
                            <label for="nature_outcome" class="md-input label-fixed">Nature of Outcome<span class="req">*</span></label>
                            <?php
                            echo $this->form->input('nature_outcome', array('type' => "text", 'label' => false, 'required' => true, 'class' => "md-input"));
                            ?>
                            <span class="md-input-bar"></span>
                        </div>
                    </div>
                    <div class="uk-width-medium-1-2" >
                        <div class="parsley-row">
                            <label for="description" class="md-input label-fixed">Description</label>
                            <?php
                            echo $this->form->input('description', array('type' => 'text', 'label' => false, 'class' => "md-input"));
                            ?>                
                        </div>
                    </div>
                </div>
                <div class="uk-grid" data-uk-grid-margin > </div>
               
                <div class="uk-grid">
                    <div class="uk-width-1-3 uk-margin-top">                            
                        <button type="submit" name="submit" value="submit" class="md-btn md-btn-success" href="#">Save</button>                    
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
