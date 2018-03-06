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
        <?php
        echo $flash = $this->Session->flash();
        foreach ($EditRecord as $rec)
            ;
//        echo "<pre>";
//        print_r($rec);
        ?> 
        <div class="md-card">  
            <div class="md-card-content large-padding">
                <h3 class="heading_a">Quantitative and Qualitative</h3>
                <?php echo $this->Form->create('doc', array('url' => array('controller' => 'ComplianceAudit', 'action' => 'quant_qual_edit'), 'type' => 'file', 'id' => 'form_validation', 'class' => 'uk-form-stacked'));
                      echo $this->form->input('data_id', array('label' => false, 'type' => "hidden", 'required' => true,'value'=>$dataID));
                ?><br>
                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-1-3" >
                        <div class="parsley-row">
                            <label for="req_cat">MDA<span class="req">*</span></label>
                            <select name="mda" required="true"  class="md-input data-md-selectize">
                                <option value="">--Select--</option>
                                <?php
                                foreach ($Ministry as $key => $rt) {
                                    $value = $key;
                                    $option = $rt;
                                    if ($rec['Ministry']['id'] == $value) {
                                        echo "<option value='" . $value . "' selected='selected'>" . $option . "</option>";
                                    } else {
                                        echo "<option value='" . $value . "'>" . $option . "</option>";
                                    }
                                }
                                ?>
                            </select>



                        </div>
                    </div>
                    <div class="uk-width-medium-1-3" >
                        <div class="parsley-row">
                            <label for="req_cat">Thematic Area <span class="req">*</span></label>
                            <select name="thematic_area" id="thematic_area" required="true"   class="md-input data-md-selectize">
                                <option value="">--Select--</option>
                                <?php
                                foreach ($ThematicArea as $key => $rt) {
                                    $value = $key;
                                    $option = $rt;
                                    if ($rec['CASetType']['id'] == $value) {
                                        echo "<option value='" . $value . "' selected='selected'>" . $option . "</option>";
                                    }
                                }
                                ?>
                            </select>

                        </div>
                    </div>


                    <div class="uk-width-medium-1-3" >
                        <div class="parsley-row" >
                            <label for="req_cat" >Type<span class="req">*</span></label>
                            <select name="type_id" id="type_id"    class="md-input data-md-selectize ">
                                <option value="">--Select--</option>
                                <?php
                                $type = array('1' => 'Quantitative', '2' => 'Qualitative');
                                foreach ($type as $key => $rt) {
                                    $value = $key;
                                    $option = $rt;
                                    if ($rec['CAQuantitativeQualitative']['type'] == $value) {
                                        echo "<option value='" . $value . "' selected='selected'>" . $option . "</option>";
                                    }
                                }
                                ?>
                            </select>

                        </div>
                    </div>
                </div>
                <div class="uk-grid" data-uk-grid-margin></div>
                <div  id='TextBoxesGroup'>
                    <?php if ($Typeid == '1') {
                        ?>
                        <br>
                        <hr>
                        <h3 class="heading_a" style="text-align: center">Quantitative</h3>
                        <hr>
                        <div class="uk-grid" data-uk-grid-margin  >
                            <div class="uk-width-medium-1-3">
                                <div class="parsley-row">
                                    <label for="department">Performance Indicator <span class="req">*</span></label>
                                    <?php
                                    echo $this->form->input('per_indicator', array('label' => false, $dsblFild, 'type' => "select", 'empty' => '-- Select --', 'required' => true, 'options' => $perf_indic, 'default' => $rec['CAQuantitativeQualitative']['performance_indicator_quant'], 'onchange' => 'getmeaurtype(this.value)', 'class' => "md-input", 'data-md-selectize'));
                                    ?>
                                </div>
                            </div>
                            <div class="uk-width-medium-1-3" id="measur">
                                <div class="parsley-row">
                                    <label for="department">Measurement <span class="req">*</span></label>
                                    <select name="measurement_type" id="measurement"  required="required"  class="md-input data-md-selectize ">
                                        <?php
                                        foreach ($measurType as $key => $rt) {
                                            $value = $key;
                                            $option = $rt;
                                            if ($rec['CAQuantitativeQualitative']['measurement_type'] == $value) {
                                                echo "<option value='" . $value . "' selected='selected'>" . $option . "</option>";
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="uk-width-medium-1-3">
                                <div class="parsley-row">
                                    <label for="department">Comments</label>
                                    <?php
                                    echo $this->form->input('comment', array('label' => false, $dsblFild, 'type' => "text", 'value' => $rec['CAQuantitativeQualitative']['comment'], 'class' => "md-input"));
                                    ?>
                                </div>
                            </div> 
                        </div>
<?php } else if ($Typeid == '2') { ?>
                        <br>
                        <hr>
                        <h3 class="heading_a" style="text-align: center">Qualitative</h3>
                        <hr>
                        <div class="uk-grid" data-uk-grid-margin  >
                            <div class="uk-width-medium-1-3">
                                <div class="parsley-row">
                                    <label for="department">Description</label>
                                    <?php
                                    echo $this->form->input('description', array('label' => false, 'type' => "text", 'value'=>$rec['CAQuantitativeQualitative']['description'], 'class' => "md-input"));
                                    ?>
                                </div>
                            </div> 
                            <div class="uk-width-medium-1-3">
                                <div class="parsley-row">
                                    <label for="department">Performance Standards</label>
                                    <?php
                                    echo $this->form->input('perform_stantd', array('label' => false, 'type' => "text",'value'=>$rec['CAQuantitativeQualitative']['performance_standard'], 'class' => "md-input"));
                                    ?>
                                </div>
                            </div> 
                            <div class="uk-width-medium-1-3">
                                <div class="parsley-row">
                                    <label for="department">Performance Indicator</label>
                                    <?php
                                    echo $this->form->input('perform_indicat', array('label' => false, 'type' => "text", 'value'=>$rec['CAQuantitativeQualitative']['performance_indicator_qual'],'class' => "md-input"));
                                    ?>
                                </div>
                            </div> 
                        </div>
                        <div class="uk-grid" data-uk-grid-margin  >
                            <div class="uk-width-medium-1-3">
                                <div class="parsley-row">
                                    <label for="department">Analysis of the findings</label>
                                    <?php
                                    echo $this->form->input('analysis_findings', array('label' => false, 'type' => "text",'value'=>$rec['CAQuantitativeQualitative']['analysis_finding'], 'class' => "md-input"));
                                    ?>
                                </div>
                            </div> 
                            <div class="uk-width-medium-1-3">
                                <div class="parsley-row">
                                    <label for="department">Progress achieved</label>
                                    <?php
                                    echo $this->form->input('progress_achieved', array('label' => false, 'type' => "text", 'value'=>$rec['CAQuantitativeQualitative']['progress_achieve'],'class' => "md-input"));
                                    ?>
                                </div>
                            </div> 
                            <div class="uk-width-medium-1-3">
                                <div class="parsley-row">
                                    <label for="department">Challenges faced</label>
                                    <?php
                                    echo $this->form->input('challeng_face', array('label' => false, 'type' => "text", 'value'=>$rec['CAQuantitativeQualitative']['challenge_face'],'class' => "md-input"));
                                    ?>
                                </div>
                            </div> 
                        </div>
                        <div class="uk-grid" data-uk-grid-margin  >
                            <div class="uk-width-medium-1-3">
                                <div class="parsley-row">
                                    <label for="department">Recommendations</label>
                                    <?php
                                    echo $this->form->input('recommend', array('label' => false, 'type' => "text",'value'=>$rec['CAQuantitativeQualitative']['recommendation'], 'class' => "md-input"));
                                    ?>
                                </div>
                            </div> 
                            <div class="uk-width-medium-1-3">
                                <div class="parsley-row">
                                    <label for="department">Conclusion</label>
                                    <?php
                                    echo $this->form->input('conclusion', array('label' => false, 'type' => "text",'value'=>$rec['CAQuantitativeQualitative']['conclusion'], 'class' => "md-input"));
                                    ?>
                                </div>
                            </div> 
                        </div>
<?php } ?>
                    <div class="uk-grid" data-uk-grid-margin>
                        <div class="uk-width-1-3 uk-margin-top">                            
                            <button type="submit" name="submit" value="submit"  class="md-btn md-btn-success" href="#">Save</button>                    
                        </div>
                        <div class="uk-width-1-3 uk-margin-top">                            
                            <a class="md-btn md-btn-primary" href="<?php echo $this->Html->url('quant_qual_list/' . $rec['CAQuantitativeQualitative']['type']) ?>">Cancel</a>                       
                        </div>
                    </div>

                </div>

<?php echo $this->Form->end(); ?>

            </div>
        </div>
    </div>
