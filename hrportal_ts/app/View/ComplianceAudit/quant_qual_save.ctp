<script>
    function getTypeForm() {
        
        var thematicarea = $('#thematic_area').val();
        var typeid = $('#type_id').val();

        if (thematicarea != ' ' && typeid != '') {
            $.ajax({
                type: "POST",
                url: '<?php echo $this->webroot ?>compliance_audit/form_type/' + thematicarea + '/' + typeid,
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
        <h1>Governance</h1>
    </div>
    <div id="page_content_inner">
        <?php echo $flash = $this->Session->flash(); ?> 
        <div class="md-card">  
            <div class="md-card-content large-padding">
                <h3 class="heading_a">Quantitative data type & Qualitative data type</h3>
                <?php echo $this->Form->create('doc', array('url' => array('controller' => 'ComplianceAudit', 'action' => 'quant_qual_save'), 'type' => 'file', 'id' => 'form_validation', 'class' => 'uk-form-stacked'));
                ?><br>
                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-1-3" >
                        <div class="parsley-row">
                            <label for="req_cat">Organization <span class="req">*</span></label>
                            <select name="mda" required="true"  class="md-input data-md-selectize label-fixed">
                                <?php
                                $list = "<option value=' '>--Select--</option>";
                                foreach ($Ministry as $key => $rt) {
                                    $list .= "<option value='" . $key . "'>" . $rt . "</option>";
                                }
                                echo $list;
                                ?>
                            </select>

                        </div>
                    </div>
                    <div class="uk-width-medium-1-3" >
                        <div class="parsley-row">
                            <label for="req_cat">Thematic Area <span class="req">*</span></label>
                            <select name="thematic_area" id="thematic_area" required="true"  onchange="getTypeForm()" class="md-input data-md-selectize label-fixed">
                                <?php
                                $list = "<option value=' '>--Select--</option>";
                                foreach ($ThematicArea as $key => $rt) {
                                    $list .= "<option value='" . $key . "'>" . $rt . "</option>";
                                }
                                echo $list;
                                ?>
                            </select>

                        </div>
                    </div>


                    <div class="uk-width-medium-1-3" >
                        <div class="parsley-row" >
                            <label for="req_cat" >Type<span class="req">*</span></label>
                            <select name="type_id" id="type_id"   onchange="getTypeForm()" class="md-input data-md-selectize label-fixed">
                                <option value="">--Select--</option>
                                <option value="1">Quantitative</option>
                                <option value="2">Qualitative</option>
                            </select>

                        </div>
                    </div>
                </div>
                <div class="uk-grid" data-uk-grid-margin></div>
                <div  id='TextBoxesGroup'></div>

                <?php echo $this->Form->end(); ?>

            </div>
        </div>
    </div>
