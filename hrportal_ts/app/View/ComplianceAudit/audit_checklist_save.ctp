<script>
    function getTypeChecklistForm() {
        
        var audit_param = $('#audit_param').val();

        if (audit_param != ' ') { 
            $.ajax({
                type: "POST",
                url: '<?php echo $this->webroot ?>compliance_audit/audit_checklist_form_type/' + audit_param ,
                //data:'project_id='+val,
                success: function (data) {
                    $("#TextBoxesGroup").html(data);

                }
            });

        }
    }

    function getmeaurtype(val) {
    
        $.ajax({
            type: "POST",
            url: '<?php echo $this->webroot ?>compliance_audit/fields_measur/' + val,
            success: function (data) {
                //alert(data);
                $("#measur").html(data);
            }
        });
    }

</script>
<div id="page_content">
    <div id="page_heading" data-uk-sticky="{ top: 48, media: 960 }">
        <h1>Set Checklist Result</h1>
    </div>
    <div id="page_content_inner">
        <?php echo $flash = $this->Session->flash(); ?> 
        <div class="md-card">  
            <div class="md-card-content large-padding">
                <h3 class="heading_a">Set Checklist</h3>
                <?php echo $this->Form->create('doc', array('url' => array('controller' => 'ComplianceAudit', 'action' => 'audit_checklist_save'), 'type' => 'file', 'id' => 'form_validation', 'class' => 'uk-form-stacked'));
                ?><br>
                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-1-3" >
                        <div class="parsley-row">
                            <label for="req_cat" class="md-input label-fixed">Checklist Parameter<span class="req">*</span></label>
                            <select name="checklist_param" id="audit_param" required="true"  onchange="getTypeChecklistForm()" class="md-input data-md-selectize">
                                <?php
                                $list = "<option value=' '>--Select--</option>";
                                foreach ($audit_param as $key => $rt) {
                                    $list .= "<option value='" . $key . "'>" . $rt . "</option>";
                                }
                                echo $list;
                                ?>
                            </select>

                        </div>
                    </div>


                    
                </div>
                <div class="uk-grid" data-uk-grid-margin></div>
                <div  id='TextBoxesGroup'></div>
                
                <div class="uk-grid" data-uk-grid-margin></div>
                
                <?php echo $this->Form->end(); ?>

            </div>
        </div>
    </div>
