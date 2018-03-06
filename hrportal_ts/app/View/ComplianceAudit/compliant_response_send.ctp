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
                <?php echo $this->Form->create('doc', array('url' => array('controller' => 'ComplianceAudit', 'action' => 'compliant_response_send'), 'type' => 'file', 'id' => 'form_validation', 'class' => 'uk-form-stacked'));
                echo $this->form->input('compliant_id', array('type' => "hidden", 'label' => false, 'required' => true,'value'=>$complID,'class' => "md-input"));
                ?>
                <h3 class="heading_a">Compliant</h3>
                <div  class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-1-2">
                        <div class="parsley-row">
                            <label for="t_o_org" class="md-input label-fixed">Action<span class="req">*</span></label>
                            <select name="action_type" required="required" onchange="actionType(this.value);" class="md-input data-md-selectize ">
                                <option value="">-- Select --</option>
                                <option value="1">Forward to External</option>
                                <option value="2">Forward to Compliance</option>
                                <option value="3">Direct Response</option>
                            </select>
                        </div>
                    </div>
                    <div class="uk-width-medium-1-2" id="actionfield" >
                    </div>
                    
                </div>
                <div class="uk-grid" data-uk-grid-margin > </div>
                <div class="uk-grid" data-uk-grid-margin > 
                    <div class="uk-width-medium-1-2">
                        <div class="parsley-row">
                            <label for="response_date" class="md-input label-fixed">Date<span class="req">*</span></label>
                            <?php
                            $cur_date = date('d-m-Y');
                            echo $this->form->input('response_date', array('type' => "text", 'label' => false, 'required' => true,'value'=>$cur_date, 'readonly'=>true, 'class' => "md-input"));
                            ?>
                            <span class="md-input-bar"></span>
                        </div>
                    </div>
                    <div class="uk-width-medium-1-2" >
                        <div class="parsley-row">
                            <label for="resp" class="md-input label-fixed">CEO Remark <span class="req fixed">*</span></label>
                            <?php
                            echo $this->form->input('ceo_remark', array('type' => 'text', 'label' => false, 'required' => true, 'class' => "md-input"));
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
                        <a class="md-btn md-btn-primary" href="<?php echo $this->Html->url('/ComplianceAudit/compliant_received') ?>">Cancel</a>                       
                    </div>
                </div>
<?php echo $this->Form->end(); ?>
            </div>
        </div>
    </div>
</div>
